<?php

namespace App\Http\Controllers;

use App\Enums\TransactionType;
use App\Jobs\SendAnalysisRequest;
use App\Models\Bank;
use App\Models\BankStatementAnalysis;
use App\Models\BankStatementFile;
use App\Models\Statement;
use App\Models\StatementTag;
use App\Models\StatementYearlySummary;
use App\Models\Summary;
use App\Models\Transaction;
use App\Services\NodeAuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Mpdf\Mpdf;

class BankStatementAnalysisController extends Controller
{
    public function index(){
        $list = BankStatementAnalysis::where('created_by',auth()->id())->latest()->paginate(10);
        return view('analysis.list',compact('list'));
    }

    public function create(){
        $banks = Bank::where('status',1)->pluck('name','id');
        $projects = DB::table('projects')->get(['name','id']);
        return view('analysis.create',compact('banks','projects'));
    }

    public function store(Request $request){
        $request->validate([
            'taxpayer_name' => 'required',
            'tin_no' => 'required|numeric',
            'trade_license' => 'string|nullable',
            'bin_no' => 'string|nullable',
            'contact_person' => 'string|nullable',
            'contact_number' => 'string|nullable',
            'project_id' => 'string|nullable',
            'tender_ref_no' => 'string|nullable',
            'tender_amount' => 'string|nullable',
        ]);

        $statementAnalysis = BankStatementAnalysis::create([
            'taxpayer_name' => $request->taxpayer_name,
            'tin_no' => $request->tin_no,
            'trade_license' => $request->trade_license,
            'bin_no' => $request->trade_license,
            'contact_person' => $request->contact_person,
            'contact_number' => $request->contact_number,
            'project_id' => $request->project_id,
            'tender_ref_no' => $request->tender_ref_no,
            'tender_amount' => $request->tender_amount
        ]);
        foreach ($request->banks as $index => $bankId) {
            if ($request->hasFile('files.' . $index)) {
                $file = $request->file('files.' . $index);
                $path = $file->store('', 'idf_content'); // saves to storage/app/public/bank_statements
                BankStatementFile::create([
                    'bank_statement_analysis_id' => $statementAnalysis->id,
                    'bank_id' => $bankId,
                    'file_path' => $path,
                ]);
            }
        }
        SendAnalysisRequest::dispatch($statementAnalysis);
        return redirect()->route('analysis.index')->with('success', 'Request Submitted Successfully');

    }

    public function show($id){
        $analysis = BankStatementAnalysis::with(['files.bank', 'files.yearlySummaries'])->findOrFail($id);
        if($analysis->status == 'processing'){
            $analysisRequest = \App\Models\Request::where('id',$analysis->request_id)->first();
            $statements = Statement::where('request_id', $analysisRequest->id)
                ->orderBy('id') // important for consistent serial
                ->get();

            $files = BankStatementFile::where('bank_statement_analysis_id', $analysis->id)
                ->orderBy('id')
                ->get();

            foreach ($files as $index => $file) {
                if (isset($statements[$index])) {
                    $file->statement_id = $statements[$index]->id;
                    $file->save();
                    if (!empty($statements[$index]->tags)) {
                        \App\Models\StatementTag::where('file_id', $file->id)->delete();
                        $decodedTags = json_decode($statements[$index]->tags);
                        foreach ($decodedTags as $tag => $count) {
                            \App\Models\StatementTag::create([
                                'file_id' => $file->id,
                                'tag'     => $tag,
                                'count'   => $count,
                            ]);
                        }
                    }
                }
            }

            $analysis->status = 'done';
            $analysis->save();
            $analysis->refresh();
        }

        return view('analysis.show', compact('analysis'));
    }

    public function destroy($id)
    {
        $analysis = BankStatementAnalysis::with('files')->findOrFail($id);

        foreach ($analysis->files as $file) {
            if ($file->file_path && Storage::exists($file->file_path)) {
                Storage::delete($file->file_path);
            }
            StatementYearlySummary::where('file_id', $file->id)->delete();
            $file->delete();
        }

        $analysis->delete();

        return redirect()->route('analysis.index')->with('success', 'Analysis request and related files deleted successfully.');
    }

    public function yearDetails($analysisId, $yearDetailId,$type){

        $summary = Summary::findOrFail($yearDetailId);
        $statementId = $summary->statement_id;

        $fileDetails = BankStatementFile::with(['bank', 'analysis'])->where('statement_id',$statementId)->first();

        $fiscalYear = $summary->fiscal_year;


        $transectionType = TransactionType::fromSlug($type);

        $summaryDetails = Transaction::where('fiscal_year', $fiscalYear)
            ->where('statement_id', $statementId)
            ->where('Cat_L3',$transectionType)->paginate(12);


        return view('analysis.year-details', compact('summary','summaryDetails','fileDetails'));

    }

    public function exportPdf($id)
    {
        $analysis = BankStatementAnalysis::with(['files.bank', 'files.yearlySummaries'])->findOrFail($id);

        // Render the HTML from your existing view
        $html = View::make('analysis.analysis-pdf', compact('analysis'))->render();

        // Clean unwanted elements for PDF
        $html = preg_replace('/<a\b[^>]*>(.*?)<\/a>/is', '$1', $html); // remove all <a> tags
        $html = preg_replace('/<button\b[^>]*>.*?<\/button>/is', '', $html); // remove <button> tags
        $html = preg_replace('/<script\b[^>]*>.*?<\/script>/is', '', $html); // remove scripts

        // Create mPDF instance
        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'margin_top' => 10,
            'margin_bottom' => 10,
            'margin_left' => 10,
            'margin_right' => 10,
            'default_font' => 'dejavusans',
        ]);

        // Optional header and footer
        $mpdf->SetHTMLHeader('
            <div style="text-align: left; font-size: 12px; border-bottom: 1px solid #ccc; padding-bottom: 5px;">
                Analysis Report
            </div>
        ');

        $mpdf->SetHTMLFooter('
            <div style="text-align: right; font-size: 12px; border-top: 1px solid #ccc; padding-top: 5px;">
                Page {PAGENO}
            </div>
        ');

        // Write HTML content
        $mpdf->WriteHTML($html);

        // Output inline in browser (use 'D' for download)
        return response($mpdf->Output("Analysis_{$analysis->id}.pdf", 'D'))
            ->header('Content-Type', 'application/pdf');
    }

    public function allTransactionsByFileId($fileId,Request $request)
    {
        $searchData = null;
        $transections = null;

        $tag = request('tag');
        if (request('search')) {
            $tag = request('search');
        }




        if ($tag){
            $searchResult = Transaction::search($tag)
                ->where('statement_id', $fileId)
                ->get();
            $transections = Transaction::whereIn('id', $searchResult->pluck('id'))
                ->orderBy('date', 'desc')
                ->paginate(10)->withQueryString();
            $totals = Transaction::whereIn('id', $searchResult->pluck('id'))
                ->selectRaw('
                COALESCE(SUM(debit), 0) as total_debit,
                COALESCE(SUM(credit), 0) as total_credit
            ')
                ->first();

            $totalDebit  = $totals->total_debit;
            $totalCredit = $totals->total_credit;

        }else{
            $transections = Transaction::where('statement_id', '=', $fileId)->orderBy('date', 'desc')->paginate(10);
            $totals = Transaction::where('statement_id', $fileId)
                ->selectRaw('
                    SUM(debit) as total_debit,
                    SUM(credit) as total_credit
                ')
                ->first();

            $totalDebit  = $totals->total_debit;
            $totalCredit = $totals->total_credit;
        }

        $statementFile = BankStatementFile::with('analysis')->where('statement_id',$fileId)->first();
        return view('analysis.transactions', compact('transections','statementFile','searchData','totalDebit','totalCredit'));
    }

    public function allTagsByFileId($fileId)
    {
        $statementFile = BankStatementFile::with('analysis')->findOrFail($fileId);

        $tags = StatementTag::where('file_id', '=', $fileId)->orderBy('count','desc')->get();
        return view('analysis.tags', compact('tags','statementFile'));

    }

}
