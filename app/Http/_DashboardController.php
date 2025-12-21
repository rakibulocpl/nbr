<?php

namespace App\Http;


use App\Http\Controllers\Controller;
use App\Models\FileRepo;
use App\Models\Option;
use App\Models\User;
use Illuminate\Http\Request;

class _DashboardController extends Controller
{


    public function index()
    {
        // Fetch latest file records with related status
        $files = FileRepo::with('statusInfo')->latest()->take(5)->get();

        // Total file count
        $totalFiles = FileRepo::count();

        // Count files grouped by status name
        $statusCounts = FileRepo::with('statusInfo')
            ->get()
            ->groupBy(fn($file) => $file->statusInfo->name ?? 'Unknown')
            ->map->count();

        return view('dashboard', compact('files', 'totalFiles', 'statusCounts'));
    }

}
