<?php

use App\Http\Controllers\BankStatementAnalysisController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FileRepoController;
use App\Http\Controllers\InfoController;
use App\Http\Controllers\LandController;
use App\Http\Controllers\LandPurchaseController;
use App\Http\Controllers\LandSaleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('user', UserController::class)->names('user');
    Route::resource('statement-analysis', BankStatementAnalysisController::class)->names('analysis');
    Route::get('statement-analysis/{analysisId}/year-details/{yearDetailId}/{type}', [BankStatementAnalysisController::class, 'yearDetails'])->name('statement-analysis.year-details');

    Route::get('/transactions/{fileId}', [BankStatementAnalysisController::class, 'allTransactionsByFileId'])
        ->name('transactions.index');
    Route::get('tags/summary/{fileId}', [BankStatementAnalysisController::class, 'allTagsByFileId'])->name('analysis.tags');

    Route::get('statement-analysis/{id}/export-pdf', [BankStatementAnalysisController::class, 'exportPdf'])->name('analysis.export-pdf');

    Route::resource('file-repo', FileRepoController::class)->names('fileRepo');
    Route::post('file-repo/assign-desk',[FileRepoController::class,'assignDesk'])->name('fileRepo.assignDesk');
    Route::post('file-repo/status-update',[FileRepoController::class,'updateStatus'])->name('fileRepo.updateStatus');
    Route::get('info/departments/desks',[InfoController::class,'deskByDepartment'])->name('departments.desks');
    Route::post('user/{id}/transection-store', [UserController::class,'transectionStore'])->name('user.transectionStore');
    Route::get('user/{id}/transection', [UserController::class,'transection'])->name('user.transection');
    Route::resource('role', RoleController::class)->names('role');

    /**/

});

require __DIR__ . '/auth.php';
