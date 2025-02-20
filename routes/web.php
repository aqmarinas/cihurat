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
        Route::get('/profile/edit', [UserController::class, 'editProfile'])->name('profile.edit');
        Route::patch('/profile/update', [UserController::class, 'updateProfile'])->name('profile.update');

        // Panduan
        Route::get('/panduan', function () {
            return view('panduan.index');
        })->name('panduan.index');

        // Routes Pengguna
        Route::middleware(['role:pengguna'])->group(function () {
            Route::resource('surat', SuratController::class);
            Route::get('/surat/{id}/create', [SuratController::class, 'create'])->name('surat.create');

            Route::get('/riwayat', [SuratController::class, 'history'])->name('riwayat.index');
            Route::get('/riwayat/{id}', [SuratController::class, 'historyDetails'])->name('riwayat.show');
        });

        // Routes RT
        Route::middleware(['role:rt'])->prefix('rt')->group(function () {
            Route::resource('verifikasi', VerifSuratController::class);
            Route::patch('/verifikasi/{id}/setujui', [VerifSuratController::class, 'setujui'])->name('verifikasi.setujui');
            Route::patch('/verifikasi/{id}/tolak', [VerifSuratController::class, 'tolak'])->name('verifikasi.tolak');
            Route::get('/verifikasi/{id}/download', [VerifSuratController::class, 'download'])->name('verifikasi.download');

            Route::get('/pengguna', [UserController::class, 'getAllPenggunaByRt'])->name('rt.pengguna.index');
        });

        // Routes Admin
        Route::middleware(['role:admin'])->prefix('admin')->group(function () {
            Route::resource('rt', RtController::class);
            Route::resource('rw', RwController::class);

            Route::get('/pengguna', [UserController::class, 'getAllPengguna'])->name('admin.pengguna.index');
            Route::get('/pengguna/{id}/edit', [UserController::class, 'editPengguna'])->name('admin.pengguna.edit');
            Route::patch('/pengguna/{id}', [UserController::class, 'updatePengguna'])->name('admin.pengguna.update');
            Route::patch('/pengguna/{id}/deactivate', [UserController::class, 'deactivate'])->name('admin.pengguna.deactivate');

            // Route::get('/template/upload', [SuratController::class, 'uploadTemplateView'])->name('admin.template.upload');
            // Route::post('/template/store', [SuratController::class, 'uploadTemplate'])->name('admin.template.store');

            Route::get('/surat', [SuratController::class, 'kelolaSurat'])->name('admin.surat.index');
            Route::get('/surat/{id}/detail', [SuratController::class, 'historyDetails'])->name('admin.surat.show');
            Route::get('/surat/{id}/download', [VerifSuratController::class, 'download'])->name('admin.surat.download');
        });
    }
);
