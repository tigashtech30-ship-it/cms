<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\UserManagementController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\CategoryController;

Route::get('/', fn() => redirect('/login'));

// Admin routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::resource('branches', BranchController::class);
    Route::resource('users', UserManagementController::class);
    Route::resource('complaints', ComplaintController::class);
    Route::get('/complaints/{complaint}/print', [ComplaintController::class, 'print'])->name('complaints.print');
    Route::resource('categories', CategoryController::class);
});

// Super Admin routes
Route::middleware(['auth', 'role:super_admin'])->prefix('superadmin')->name('superadmin.')->group(function () {
    Route::get('/dashboard',   [SuperAdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/complaints',  [SuperAdminController::class, 'complaints'])->name('complaints');
    Route::get('/branches',    [SuperAdminController::class, 'branches'])->name('branches');
    Route::get('/users',       [SuperAdminController::class, 'users'])->name('users');
    Route::get('/complaints/{complaint}', [SuperAdminController::class, 'complaintShow'])->name('complaints.show');

    // Reports
    Route::get('/reports',                    [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/complaints/excel',   [ReportController::class, 'downloadComplaintsExcel'])->name('reports.complaints.excel');
    Route::get('/reports/complaints/pdf',     [ReportController::class, 'downloadComplaintsPdf'])->name('reports.complaints.pdf');
    Route::get('/reports/branches/excel',     [ReportController::class, 'downloadBranchExcel'])->name('reports.branches.excel');
    Route::get('/reports/branches/pdf',       [ReportController::class, 'downloadBranchPdf'])->name('reports.branches.pdf');
});

// User (Branch Rep) routes
Route::middleware(['auth', 'role:user'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
    Route::get('/complaint/{complaint}', [UserController::class, 'show'])->name('complaint.show');
    Route::post('/complaint/{complaint}/status', [UserController::class, 'updateStatus'])->name('complaint.status');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// Health check route
Route::get('/health', function () {
    return response()->json(['status' => 'ok'], 200);
});