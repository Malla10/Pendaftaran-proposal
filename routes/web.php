<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\Admin\DosenCrudController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Home - Redirect to login
Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Mahasiswa Routes
Route::middleware(['auth', 'role:mahasiswa'])->prefix('mahasiswa')->name('mahasiswa.')->group(function () {
    Route::get('/dashboard', [MahasiswaController::class, 'dashboard'])->name('dashboard');
    Route::get('/proposal/create', [MahasiswaController::class, 'createProposal'])->name('proposal.create');
    Route::post('/proposal', [MahasiswaController::class, 'storeProposal'])->name('proposal.store');
    Route::get('/proposal/{id}', [MahasiswaController::class, 'showProposal'])->name('proposal.show');
    Route::get('/riwayat', [MahasiswaController::class, 'riwayat'])->name('riwayat');
});

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/proposals', [AdminController::class, 'listProposals'])->name('proposals');
    Route::get('/proposal/{id}', [AdminController::class, 'showProposal'])->name('proposal.show');
    Route::post('/proposal/{id}/assign', [AdminController::class, 'assignDosen'])->name('proposal.assign');
    Route::post('/proposal/{id}/auto-assign', [AdminController::class, 'autoAssign'])->name('proposal.auto-assign');
    Route::delete('/proposal/{id}', [AdminController::class, 'destroy'])->name('proposal.destroy');
    Route::get('/activity-logs', [AdminController::class, 'activityLogs'])->name('logs');

    // CRUD Dosen
    Route::resource('dosen', DosenCrudController::class);
});

// Dosen Routes
Route::middleware(['auth', 'role:dosen'])->prefix('dosen')->name('dosen.')->group(function () {
    Route::get('/dashboard', [DosenController::class, 'dashboard'])->name('dashboard');
    Route::get('/mahasiswa', [DosenController::class, 'listMahasiswa'])->name('mahasiswa');
    Route::get('/proposal/{id}', [DosenController::class, 'showProposal'])->name('proposal.show');
});
