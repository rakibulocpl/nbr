<?php

namespace App\Http\Controllers;


use App\Models\BankStatementAnalysis;
use App\Models\FileRepo;
use App\Models\Option;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{


    public function index()
    {
        // Fetch latest file records with related status
        $files = BankStatementAnalysis::where('created_by',auth()->id())->latest()->take(5)->get();

        // Total file count
        $totalFiles = BankStatementAnalysis::where('created_by',auth()->id())->count();

        // Count files grouped by status name
        $statusCounts = BankStatementAnalysis::where('created_by',auth()->id())->get()
            ->groupBy(fn($file) => $file->status ?? 'Unknown')
            ->map->count();

        return view('dashboard', compact('files', 'totalFiles', 'statusCounts'));
    }

}
