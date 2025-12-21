<?php

namespace App\Http\Controllers;

use App\Enums\PaymentMethod;
use App\Models\Department;
use App\Models\Investment;
use App\Models\InvestorBalance;
use App\Models\Option;

use App\Models\User;
use App\Services\TransactionService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;


class UserController extends Controller
{
    private $transectionService;

    public function __construct(
        TransactionService $transactionService
    )
    {
        $this->transectionService = $transactionService;
    }

    public function index()
    {
        $users = User::query(); // start query builder

        if (!empty(auth()->user()->department_id)) {
            $users->where('department_id', auth()->user()->department_id);
        }

        $users = $users->get(); // run the query

        return view("user.list", compact("users"));
    }

    public function create()
    {
        $roles = Role::all();
        $departments = Department::all();

        return view("user.create", compact("roles", 'departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required',
            'address' => 'required',
            'password' => 'required',
            'roles' => 'required',
        ]);
//        dd(request()->all());


        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'desk_id' => $request->desk_id,
            'department_id' => $request->department_id,
            'address' => $request->address,
            'password' => $request->password ? bcrypt($request->password) : null, // keep old password if not updated
        ]);
        $user->syncRoles($request->roles);

        return redirect()->route('user.index')->with('success', 'User Created');
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,name',
            'password' => 'nullable|string|min:6',
        ]);

        // Handle NID file upload (if new one uploaded)
        $nidPath = $user->nid_file; // keep old one by default
        if ($request->hasFile('nid_file')) {
            $nidPath = $request->file('nid_file')->store('nids', 'public');
        }

        // Update user data
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'father_name' => $request->father_name,
            'mother_name' => $request->mother_name,
            'nid_no' => $request->nid_no,
            'address' => $request->address,
            'nid_file' => $nidPath,
            'password' => $request->password ? bcrypt($request->password) : $user->password, // keep old password if not updated
        ]);

        // Sync roles
        $user->syncRoles($request->roles);

        return redirect()->route('user.index')->with('success', 'User Updated Successfully');
    }


    public function show($id)
    {


        $user = User::findOrFail($id);
        return view('user.show', compact('user'));

    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('user.index')->with('success', 'User Deleted Successfully');
    }

    public function transectionStore($id, Request $request)
    {
        $user = User::find($id);


        $request->validate([
            'payment_date' => 'required|date',
            'payment_method' => 'required|string',
            'collected_by' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:1',
            'transection_type' => 'required',
            'note' => 'nullable|string',
        ]);


        try {

            if ($request->transection_type == 'investment') {
                $inout = 'in';
            } elseif ($request->transection_type == 'withdrawal' || $request->transection_type == 'transfer') {
                $inout = 'out';
            } else {
                return redirect()->back()->withErrors(['error' => 'Invalid transection type:']);
            }
            if ($inout == 'in') {
                $options = Option::whereIn('option_name', ['global_balance', 'payable'])
                    ->pluck('option_value', 'option_name');

                $currentBalance = (float)($options['global_balance'] ?? 0);
                $payable = (float)($options['payable'] ?? 0);

                $newBalance = (float)$request->amount;

                if (($currentBalance + $newBalance) > $payable) {
                    DB::rollBack();
                    return redirect()->back()->with('error', 'Cannot add balance because total balance would exceed payable.');
                }
            }
            DB::beginTransaction();
            $transaction = $this->transectionService->createTransaction([
                'date' => $request->payment_date,
                'in_out' => $inout,
                'type' => $request->transection_type,
                'reference_type' => 'investor',
                'reference_id' => $user->id,
                'payment_method' => $request->payment_method,
                'amount' => $request->amount,
                'description' => $request->note,
            ]);

            $investment = Investment::create([
                'investor_id' => $user->id,
                'collected_by' => $request->collected_by,
                'transection_type' => $request->transection_type,
                'date' => $request->payment_date,
                'payment_method' => $request->payment_method,
                'amount' => $request->amount,
                'description' => $request->note,
            ]);

            $currentBalance = InvestorBalance::where('investor_id', $user->id)->orderBy('id', 'desc')->first();
            if ($currentBalance) {
                $currentBalance->update(['effective_to' => Carbon::now()->format('Y-m-d')]);
                $newBalance = ($inout === 'in')
                    ? $currentBalance->balance + $transaction->amount
                    : $currentBalance->balance - $transaction->amount;
            } else {
                $newBalance = $inout === 'in' ? $transaction->amount : -$transaction->amount;
            }


            InvestorBalance::create([
                'investor_id' => $user->id,
                'ref_transection_id' => $investment->id,
                'balance' => $newBalance,
                'effective_from' => Carbon::now()->format('Y-m-d'),
            ]);
            // 2️⃣ Handle transfer (create receiver records)
            if ($request->transection_type === 'transfer') {
                $receiver = User::findOrFail($request->transfer_to);
                $investment->update([
                    'description' => "Transfer to {$receiver->name}",
                ]);

                // Receiver transaction
                $receiverTransaction = $this->transectionService->createTransaction([
                    'date' => $request->payment_date,
                    'in_out' => 'in',
                    'type' => 'investment',
                    'reference_type' => 'investor',
                    'reference_id' => $receiver->id,
                    'payment_method' => $request->payment_method,
                    'amount' => $request->amount,
                    'description' => "Transfer from {$user->name}",
                ]);

                $receiverInvestment = Investment::create([
                    'investor_id' => $receiver->id,
                    'collected_by' => $request->collected_by,
                    'transection_type' => 'investment',
                    'date' => $request->payment_date,
                    'payment_method' => $request->payment_method,
                    'amount' => $request->amount,
                    'description' => "Transfer from {$user->name}",
                    'ref_transection_id' => $investment->id,
                ]);

                // Update receiver balance
                $receiverBalance = InvestorBalance::where('investor_id', $receiver->id)->orderBy('id', 'desc')->first();
                if ($receiverBalance) {
                    $receiverBalance->update(['effective_to' => Carbon::now()->format('Y-m-d')]);
                    $newReceiverBalance = $receiverBalance->balance + $receiverTransaction->amount;
                } else {
                    $newReceiverBalance = $receiverTransaction->amount;
                }

                InvestorBalance::create([
                    'investor_id' => $receiver->id,
                    'ref_transection_id' => $receiverInvestment->id,
                    'balance' => $newReceiverBalance,
                    'effective_from' => Carbon::now()->format('Y-m-d'),
                ]);
            }

            DB::commit();

            return redirect()->route('user.show', [$user->id])->withErrors(['error' => 'Transection recorded successfully.']);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Error saving Transection:' . $e->getMessage()]);
        }

    }

    public function edit(User $user)
    {

        $roles = Role::all();
        return view('user.edit', compact('user', 'roles'));

    }

    public function transection($id)
    {
        $user = User::findOrFail($id);
        $balance = InvestorBalance::where('investor_id', $user->id)->orderBy('id', 'desc')->value('balance');

        $transactions = Investment::where('investments.investor_id', $user->id)
            ->leftJoin('investor_balance_histories as ibh', 'ibh.ref_transection_id', '=', 'investments.id')
            ->select('investments.*', 'ibh.balance as current_balance')
            ->orderBy('investments.id', 'desc')
            ->get();

        return view('user.transection', compact('user', 'transactions', 'balance'));

    }

}
