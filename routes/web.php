<?php

use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\LogoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\CoursesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\AdminController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\RtRwController;
use App\Http\Controllers\SuratDomisiliController;
use App\Models\Surat;

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
Route::post('/login', [AdminController::class, 'login'])->name('admin.login.submit');
Route::post('/logout', [AdminController::class, 'logout'])->name('admin.logout');

// Route yang memerlukan login admin
Route::middleware(['auth:admin'])->group(function () {
    // temporary
    Route::get('/panduan', function () {
        return view('admin.panduan.index');
    })->name('panduan.index');

    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard'); // Mengarahkan ke dashboard jika sudah login
    Route::get('surat', [SuratController::class, 'index'])->name('admin.surat');
    Route::resource('surat', SuratController::class);
    Route::resource('surat-domisili', SuratDomisiliController::class);
    Route::resource('rt-rw', RtRwController::class);
    Route::resource('course', CoursesController::class); // Akses ke resource courses
    Route::resource('content', ContentController::class);
    Route::post('/content/delete-file', [ContentController::class, 'deleteFile'])->name('content.delete-file');
    Route::resource('kegiatan', KegiatanController::class);
    Route::resource('logo', LogoController::class);
    Route::post('profile/update', [AdminController::class, 'updateProfile'])->name('update.profile');
    Route::get('profile/edit', [AdminController::class, 'editProfile'])->name('edit.profile');
    Route::get('daftar-guru', [AdminController::class, 'index'])->name('guru.index');
    Route::get('tambah-guru', [AdminController::class, 'create'])->name('guru.create');
    Route::post('store-guru', [AdminController::class, 'store'])->name('guru.store');
    Route::get('daftar-siswa', [SiswaController::class, 'index'])->name('siswa.index');
    Route::delete('hapus-guru/{id}', [AdminController::class, 'destroy'])->name('guru.destroy');
    Route::delete('hapus-siswa/{id}', [SiswaController::class, 'destroy'])->name('siswa.destroy');
});
