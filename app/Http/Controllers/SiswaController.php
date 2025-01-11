<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SiswaController extends Controller
{
    public function showRegistrationForm()
    {
        return view('client.pages.register');
    }

    public function register(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'kelas' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:siswa',
            'password' => 'required|string|min:6|confirmed',
        ]);

        try {
            $siswa = Siswa::create([
                'nama' => $request->nama,
                'kelas' => $request->kelas,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            Auth::guard('siswa')->login($siswa);
            return redirect()->to('/')->with('success', 'Registrasi berhasil, selamat datang!');
        } catch (\Exception $e) {
            return back()->withErrors(['register' => 'Terjadi kesalahan, silakan coba lagi.']);
        }
    }

    public function showLoginForm()
    {
        return view('client.pages.login');
    }

    // Metode untuk login siswa
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        // Coba autentikasi menggunakan guard siswa
        if (Auth::guard('siswa')->attempt($credentials, $request->filled('remember'))) {
            // Jika sukses, redirect ke halaman beranda
            return redirect()->to('/')->with('success', 'Login berhasil!'); // Ganti '/' dengan route yang sesuai jika diperlukan
        }

        // Jika gagal, kembali ke halaman login dengan error
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }


    public function logout()
    {
        Auth::guard('siswa')->logout();
        return redirect('/')->with('success', 'Anda telah logout.');
    }

    public function index()
    {
        $siswas = Siswa::all();
        return view('admin.siswa.index', compact('siswas'));
    }

    public function destroy(string $id)
    {
        $siswa = Siswa::find($id);
        $siswa->delete();
        return redirect()->route('siswa.index')->with('success', 'Data berhasil dihapus!');
    }

    // Profile
    public function showProfile()
    {
        $siswa = Auth::guard('siswa')->user();
        return view('client.pages.profile', compact('siswa'));
    }

    public function updateProfile(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama' => 'nullable|string|max:255',
            'kelas' => 'nullable|string|max:255',
            'email' => 'nullable|string|email|max:255|unique:siswa,email,' . Auth::guard('siswa')->id(),
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $siswa = Auth::guard('siswa')->user();

        // Cek apakah user ditemukan
        if (!$siswa) {
            return redirect()->route('admin.login')->withErrors(['update' => 'User tidak ditemukan.']);
        }

        try {
            $siswa->nama = $request->nama;
            $siswa->kelas = $request->kelas;
            $siswa->email = $request->email;

            if ($request->filled('password')) {
                $siswa->password = Hash::make($request->password);
            }

            $siswa->save();

            return redirect()->route('profile')->with('success', 'Profil berhasil diperbarui!');
        } catch (\Exception $e) {
            return back()->withErrors(['update' => 'Terjadi kesalahan, silakan coba lagi.']);
        }
    }
}
