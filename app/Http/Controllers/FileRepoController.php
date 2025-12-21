<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessOCR;
use App\Models\Department;
use App\Models\FileRepo;
use App\Models\FileStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Smalot\PdfParser\Parser;

class FileRepoController extends Controller
{
    public function index(Request $request){
        $searchText = $request->get('search');
        if ($searchText){
            $fileIds = FileRepo::search($searchText)->get()->pluck('id');
            $list = FileRepo::with('statusInfo')
                ->whereIn('id', $fileIds)
                ->orderByDesc('id');
        }else{  
            $list = FileRepo::with('statusInfo')->latest();
        }
        if(!empty(auth()->user()->department_id)){
            $list->where('department_id', auth()->user()->department_id);
        }
        if(!empty(auth()->user()->desk_id)){
            $list->where('desk_id', auth()->user()->desk_id);
        }

        $list = $list->paginate(10);

        return view('file-repo.list', ['list' => $list]);
    }

    public function create(){
        $departments = Department::all();
        return view('file-repo.create',compact('departments'));
    }

    public function store(Request $request){
        try {

            $request->validate([
                'title' => 'required|string|max:255',
                'file' => 'required|mimes:pdf|max:20480',
            ]);
            $file = $request->file('file');
            $path = $file->store('uploads/files', 'public');

            $datePrefix = now()->format('Ymd');
            $lastFile = FileRepo::latest('id')->first();
            $nextNumber = $lastFile ? $lastFile->id + 1 : 1;
            $trackingNo = 'FR-' . $datePrefix . '-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

            $senderDept = Department::find($request->sender_department_select);
            $receiverDept = Department::find($request->receiver_department_select);
            DB::beginTransaction();


            $fileRepo = FileRepo::create([
                'sarok_no' => $request->sarok_no,
                'urgency' => $request->urgency,
                'tracking_no' => $trackingNo,
                'tags'=>$request->get('tags'),
                'title' => $request->title,
                // sender
                'sender_department_id' => $request->sender_department_select,
                'sender_department_custom_name' => $request->sender_department_input,
                'sender_designation' => $request->sender_designation,
                'sender_name' => $request->sender_name,
                'is_sender_ict' => isset($senderDept)?1:0,
                // receiver
                'receiver_department_id' => $request->receiver_department_select,
                'receiver_department_custom_name' => $request->receiver_department_input,
                'receiver_designation' => $request->receiver_designation,
                'receiver_name' => $request->receiver_name,
                'is_receiver_ict' => isset($receiverDept)?1:0,

                'file_name' => $file->getClientOriginalName(),
                'file_path' => $path,
                'file_type' => $file->getClientMimeType(),
                'status' => 1,
                'relevant_date' => $request->relevant_date ?: now()->format('Y-m-d'),
                'uploaded_by' => auth()->id(),
            ]);
            ProcessOCR::dispatch($fileRepo,$path);

            $fileRepo->onulipis()->delete(); // Remove old CCs first
            if(isset($request->onulipi_department_input)){
                foreach ($request->onulipi_department_input as $index => $deptId) {
                    $fileRepo->onulipis()->create([
                        'custom_department_name' => $request->onulipi_department_input[$index] ?? null,
                    ]);
                }
            }
            if (isset($request->onulipi_department_select)) {
                foreach ($request->onulipi_department_select as $index => $deptId) {
                    $fileRepo->onulipis()->create([
                        'department_id' => $request->onulipi_department_select[$index] ?? null,
                    ]);
                }
            }



            DB::commit();

            return redirect()->route('fileRepo.index')->with('success', 'File uploaded successfully!');

        }catch (\Exception $exception){
            DB::rollBack();
            dd($exception->getMessage());
            return redirect()->back()->withErrors([$exception->getMessage()])->withInput();
        }


    }

    public function show($id){
        $file = FileRepo::with('statusInfo')->findOrFail($id);
        $departments = Department::all();
        $statuses = FileStatus::whereIn('id',[3,4])->get();
        return view('file-repo.show',['file' => $file, 'departments' => $departments,'statuses' => $statuses]);

    }
    public function search(Request $request, $id){
        $searchText = $request->get('search_text');
        $list = FileRepo::search($searchText)->get();
        return view('file-repo.list', ['list' => $list]);
    }

    public function assignDesk(Request $request)
    {
        // Validate request
        $request->validate([
            'file_id' => 'required|exists:file_repo,id',
            'department_id' => 'required|exists:departments,id',
            'desk_id' => 'required|exists:desks,id',
        ]);

        // Find the file
        $file = FileRepo::findOrFail($request->file_id);

        // Update file record
        $file->update([
            'department_id' => $request->department_id,
            'desk_id' => $request->desk_id,
            'status' => 2, // 2 = Desk Assigned
        ]);

        // Optionally log or perform any notification
        // activity()->performedOn($file)->log('Desk assigned.');

        // Redirect back to index with success message
        return redirect()
            ->route('fileRepo.index')
            ->with('success', 'Desk assigned successfully!');
    }

    public function updateStatus(Request $request){
        $request->validate([
            'status_id' => 'required|exists:file_status,id',
            'file_id' => 'required',
            'remarks' => 'nullable|string|max:500',
        ]);

        $file = FileRepo::findOrFail($request->file_id);
        $file->status = $request->status_id;
        $file->remarks = $request->remarks ?? null;
        $file->save();

        return redirect()->route('fileRepo.index')->with('success', 'File status updated successfully.');
    }

    public function destroy($id)
    {
        FileRepo::destroy($id);
        return redirect()->route('fileRepo.index')->with('success', 'File removed successfully.');

    }

}
