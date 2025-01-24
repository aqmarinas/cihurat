<?php

use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\LogoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\CoursesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\AdminController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\RtRwController;
use App\Http\Controllers\SuratDomisiliController;
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

Route::get('/register', [UserController::class, 'index'])->name('register.index');
Route::post('/register', [UserController::class, 'registerUser'])->name('register.submit');

Route::post('/logout', [AdminController::class, 'logout'])->name('admin.logout');

// temporary
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/panduan', function () {
    return view('admin.panduan.index');
})->name('panduan.index');
Route::post('/profile/update', [AdminController::class, 'updateProfile'])->name('update.profile');
Route::get('/profile/edit', [AdminController::class, 'editProfile'])->name('edit.profile');

// Route::get('/surat-domisili/create', function () {
//     return view('admin.surat.create');
// })->name('surat-domisili.create');



// todo: error
Route::middleware(['role:rt'])->group(function () {
    Route::resource('verifikasi', VerifSuratController::class);
    // Route::get('/verifikasi?status=menunggu', [VerifSuratController::class, 'index'])->name('verifikasi.index');
    Route::post('/verifikasi/{id}/setujui', [VerifSuratController::class, 'setujui'])->name('verifikasi.setujui');
    Route::post('/verifikasi/{id}/tolak', [VerifSuratController::class, 'tolak'])->name('verifikasi.tolak');
    Route::get('/download-surat/{id}', [VerifSuratController::class, 'download'])->name('surat.download');
});

Route::middleware(['role:pengguna'])->group(function () {
    Route::resource('surat', SuratController::class);
    Route::get('/surat/{id}/create', [SuratController::class, 'create'])->name('surat.create');
    Route::get('/riwayat', [SuratController::class, 'history'])->name('pengguna.riwayat');
    Route::get('/riwayat/{id}', [SuratController::class, 'historyDetails'])->name('pengguna.detail.riwayat');

    Route::resource(
        'surat-domisili',
        SuratDomisiliController::class
    );
});


Route::middleware(['role:admin'])->group(function () {
    Route::resource('rt', RtRwController::class);
    Route::post('/rt/create', [UserController::class, 'registerRt'])->name('register.rt.submit');

    Route::get('/users', [UserController::class, 'getAllPengguna'])->name('pengguna.index');
    Route::get('/admin/surat', [SuratController::class, 'kelolaSurat'])->name('admin.surat');
    // ?status=disetujui

    Route::get('surat-domisili/1/generate', [SuratDomisiliController::class, 'generate'])->name('surat-domisili.generate');

    Route::get('/arsip', function () {
        return view('admin.arsip.index');
    })->name('arsip.index');
});

// old
Route::resource('course', CoursesController::class);
Route::resource('content', ContentController::class);
Route::post('/content/delete-file', [ContentController::class, 'deleteFile'])->name('content.delete-file');

Route::resource('kegiatan', KegiatanController::class);

Route::resource('logo', LogoController::class);

Route::get('daftar-guru', [AdminController::class, 'index'])->name('guru.index');
Route::get('tambah-guru', [AdminController::class, 'create'])->name('guru.create');
Route::post('store-guru', [AdminController::class, 'store'])->name('guru.store');

Route::get('daftar-siswa', [SiswaController::class, 'index'])->name('siswa.index');
Route::delete('hapus-guru/{id}', [AdminController::class, 'destroy'])->name('guru.destroy');
Route::delete('hapus-siswa/{id}', [SiswaController::class, 'destroy'])->name('siswa.destroy');
