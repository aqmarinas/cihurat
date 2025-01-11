<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Carbon\Carbon;
use App\Models\Siswa;
use App\Models\Course;
use App\Models\Content;
use App\Models\Kegiatan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Menghitung total kursus
        $courseCount = Course::count();

        // Menghitung total konten
        $contentCount = Content::count();

        // Menghitung total kegiatan
        $eventCount = Kegiatan::count();
        // Menghitung total guru (hanya untuk admin)
        $teacherCount = Admin::where('role', 'guru')->count();
        $adminCount = Admin::where('role', 'admin')->count();

        // Menghitung total siswa (guard siswa)
        $studentCount = Siswa::count();

        // Array berisi kata-kata penyemangat
        $motivationalQuotes = [
            'Teruslah menginspirasi murid-murid Anda dengan semangat dan kreativitas!',
            'Setiap langkah kecil yang Anda ambil memberikan dampak besar bagi murid-murid Anda!',
            'Mengajar adalah profesi yang melahirkan semua profesi lainnya!',
            'Anda sedang membentuk masa depan, satu murid pada satu waktu!',
            'Kerja keras dan dedikasi Anda benar-benar membuat perbedaan!',
            'Percayalah pada kekuatan pengaruh Anda, Anda membuat dampak besar!',
            'Terima kasih telah menjadi mentor dan pembimbing luar biasa bagi murid-murid Anda!',
            'Semangat mengajar Anda menerangi pikiran murid-murid Anda!',
            'Teruslah maju, Anda melakukan pekerjaan yang luar biasa!',
            'Anda memiliki kekuatan untuk mengubah hidup setiap hari!'
        ];        

        // Ambil waktu saat ini dan bagi menjadi interval 6 jam
        $hour = Carbon::now()->hour;
        $quoteIndex = floor($hour / 6) % count($motivationalQuotes);

        // Pilih kata penyemangat berdasarkan waktu
        $randomQuote = $motivationalQuotes[$quoteIndex];

        // Kirim ke view
        return view('admin.layouts.dashboard', compact('courseCount', 'contentCount', 'eventCount', 'teacherCount', 'studentCount', 'randomQuote', 'adminCount'));
    }

    // public function profile() {
    //     $users = Admin::all();
    //     return view('admin.include.navbar', compact('users'));
    // }
}
