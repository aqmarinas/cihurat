<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\AdminController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\RtController;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\RwController;
use App\Http\Controllers\VerifSuratController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route untuk halaman login admin
Route::get('/login', [AdminController::class, 'showLoginForm'])->name('admin.login');
Route::post('/login', [AdminController::class, 'login2'])->name('admin.login.submit');

Route::get('/register', [UserController::class, 'registerUserView'])->name('register.index');
Route::post('/register', [UserController::class, 'registerUser'])->name('register.submit');

Route::post('/logout', [AdminController::class, 'logout'])->name('admin.logout');

// temporary
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/panduan', function () {
    return view('admin.panduan.index');
})->name('panduan.index');
Route::post('/profile/update', [UserController::class, 'updateProfile'])->name('update.profile');
Route::get('/profile/edit', [AdminController::class, 'editProfile'])->name('edit.profile');

Route::middleware(['role:rt'])->group(function () {
    Route::resource('verifikasi', VerifSuratController::class);
    Route::post('/verifikasi/{id}/setujui', [VerifSuratController::class, 'setujui'])->name('verifikasi.setujui');
    Route::post('/verifikasi/{id}/tolak', [VerifSuratController::class, 'tolak'])->name('verifikasi.tolak');
});

Route::middleware(['role:pengguna'])->group(function () {
    Route::resource('surat', SuratController::class);
    Route::get('/surat/{id}/create', [SuratController::class, 'create'])->name('surat.create');
    Route::get('/riwayat', [SuratController::class, 'history'])->name('pengguna.riwayat');
    Route::get('/riwayat/{id}', [SuratController::class, 'historyDetails'])->name('pengguna.detail.riwayat');
});

Route::middleware(['role:admin'])->group(function () {
    Route::resource('rt', RtController::class);
    Route::resource('rw', RwController::class);

    Route::get('/users', [UserController::class, 'getAllPengguna'])->name('pengguna.index');
    Route::get('/admin/surat', [SuratController::class, 'kelolaSurat'])->name('admin.surat');
    Route::get('/admin/surat/{id}/detail', [SuratController::class, 'historyDetails'])->name('admin.surat.detail');
    Route::get('/download/{id}', [VerifSuratController::class, 'download'])->name('surat.download');



    Route::get('/arsip', function () {
        return view('admin.arsip.index');
    })->name('arsip.index');
});
