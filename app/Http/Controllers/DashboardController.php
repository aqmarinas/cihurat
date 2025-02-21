<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Course;
use App\Models\Content;
use App\Models\Kegiatan;
use App\Models\Surat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Auth check
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $userId = Auth::id();
        $rtRw = Auth::user()->rt_rw;

        // User 
        $totalSuratDiajukanUser = Surat::where('user_id', $userId)->count();
        $totalSuratDisetujuiUser = Surat::where('user_id', $userId)->where('status', 'DISETUJUI')->count();
        $totalSuratMenungguUser = Surat::where('user_id', $userId)->where('status', 'MENUNGGU')->count();

        // RT 
        $totalSuratMenungguRT = Surat::where('rt_rw', $rtRw)->where('status', 'MENUNGGU')->count();
        $totalSuratDiajukanRT = Surat::where('rt_rw', $rtRw)->count();
        $totalWargaRT = User::where('role', 'pengguna')->where('rt_rw', $rtRw)->count();

        // Admin 
        // $totalAdmin = User::where('role', 'admin')->count();
        // $totalRt = User::where('role', 'rt')->count();
        $totalUsers = User::where('role', 'pengguna')->count();
        $totalSuratDiajukanAdmin = Surat::count();
        $totalSuratDisetujuiAdmin = Surat::where('status', 'DISETUJUI')->count();
        $totalSuratDitolakAdmin = Surat::where('status', 'DITOLAK')->count();

        return view('partials.layouts.dashboard', compact(
            // User
            'totalSuratDiajukanUser',
            'totalSuratDisetujuiUser',
            'totalSuratMenungguUser',

            // RT
            'totalWargaRT',
            'totalSuratMenungguRT',
            'totalSuratDiajukanRT',

            // Admin
            // 'totalAdmin',
            // 'totalRt',
            'totalUsers',
            'totalSuratDiajukanAdmin',
            'totalSuratDisetujuiAdmin',
            'totalSuratDitolakAdmin'
        ));
    }
}
