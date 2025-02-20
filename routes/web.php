<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RtController;
use App\Http\Controllers\RwController;
use App\Http\Controllers\SuratController;
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

// Login
Route::get('/login', [AuthController::class, 'loginView'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.store');

// Register
Route::get('/register', [UserController::class, 'registerUserView'])->name('register');
Route::post('/register', [UserController::class, 'registerUser'])->name('register.store');

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected
Route::middleware(['auth'])->group(
    function () {
        // Dashboard
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // Profile (All role)
        Route::get('/profile/edit', [UserController::class, 'editProfile'])->name('edit.profile');
        Route::post('/profile/update', [UserController::class, 'updateProfile'])->name('update.profile');

        // Panduan
        Route::get('/panduan', function () {
            return view('panduan.index');
        })->name('panduan.index');

        // Routes Pengguna
        Route::middleware(['role:pengguna'])->group(function () {
            Route::resource('surat', SuratController::class);
            Route::get('/surat/{id}/create', [SuratController::class, 'create'])->name('pengguna.surat.create');
            Route::get('/riwayat', [SuratController::class, 'history'])->name('pengguna.riwayat');
            Route::get('/riwayat/{id}', [SuratController::class, 'historyDetails'])->name('pengguna.detail.riwayat');
        });

        // Routes RT
        Route::middleware(['role:rt'])->group(function () {
            Route::resource('verifikasi', VerifSuratController::class);
            Route::post('/verifikasi/{id}/setujui', [VerifSuratController::class, 'setujui'])->name('verifikasi.setujui');
            Route::post('/verifikasi/{id}/tolak', [VerifSuratController::class, 'tolak'])->name('verifikasi.tolak');
            Route::get('/verifikasi/{id}/download', [VerifSuratController::class, 'download'])->name('verifikasi.download');

            Route::get('/rt/pengguna', [UserController::class, 'getAllPenggunaByRt'])->name('rt.kelola.pengguna');
        });

        // Routes Admin
        Route::middleware(['role:admin'])->group(function () {
            Route::resource('rt', RtController::class);
            Route::resource('rw', RwController::class);

            Route::get('/admin/pengguna', [UserController::class, 'getAllPengguna'])->name('admin.kelola.pengguna');
            Route::get('/admin/pengguna/{id}/edit', [UserController::class, 'editPengguna'])->name('admin.edit.pengguna');
            Route::post('/admin/pengguna/{id}/edit', [UserController::class, 'updatePengguna'])->name('admin.update.pengguna');


            Route::post('/admin/template/store', [SuratController::class, 'uploadTemplate'])->name('admin.template.store');
            Route::get('/admin/template/upload', [SuratController::class, 'uploadTemplateView'])->name('admin.template.upload');

            Route::get('/admin/surat', [SuratController::class, 'kelolaSurat'])->name('admin.kelola.surat');
            Route::get('/admin/surat/{id}/detail', [SuratController::class, 'historyDetails'])->name('admin.surat.detail');
            Route::get('/admin/surat/{id}/download', [VerifSuratController::class, 'download'])->name('surat.download');
        });
    }
);
