<?php

namespace App\Http\Controllers\Auth;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    // Proses login admin
    public function login(Request $request)
    {
        // Validasi input
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Periksa apakah checkbox "remember me" dicentang
        $remember = $request->has('remember-me');

        // Cek apakah email ada di database
        $admin = Admin::where('email', $request->email)->first();

        if (!$admin) {
            // Jika email tidak ditemukan
            return back()->withErrors([
                'email' => 'The email address is not registered.',
            ])->withInput($request->except('password'));
        }

        // Cek apakah password sesuai dengan email yang ada
        if (!Auth::guard('admin')->attempt($credentials, $remember)) {
            // Jika password salah
            return back()->withErrors([
                'password' => 'The password is incorrect.',
            ])->withInput($request->except('password'));
        }

        // Redirect ke dashboard admin jika login berhasil
        return redirect()->intended(route('admin.dashboard'));
    }


    // Logout admin
    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }

    public function updateProfile(Request $request)
    {
        // Pastikan admin terautentikasi
        if (!Auth::check()) {
            return redirect()->route('admin.login')->with('error', 'Silakan masuk terlebih dahulu.');
        }

        $admin = Auth::user(); // Mendapatkan admin yang sedang terautentikasi

        // Pastikan objek admin adalah instance dari Admin
        if (!$admin instanceof Admin) {
            return redirect()->back()->with('error', 'Admin tidak valid.');
        }

        // Validasi data yang masuk
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:admin,email,' . $admin->id,
            'password' => 'nullable|string|min:6|confirmed', // Menggunakan nullable agar password tidak wajib diubah
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10048', // Sesuaikan ukuran jika perlu
        ]);

        // Perbarui nama dan email admin
        $admin->name = $request->name;
        $admin->email = $request->email;

        // Jika password baru diberikan, hash dan set
        if ($request->filled('password')) {
            $admin->password = Hash::make($request->password);
        }

        // Menangani unggahan file untuk foto profil
        if ($request->hasFile('foto_profil')) {
            // Hapus foto lama jika ada
            if ($admin->foto_profil) {
                Storage::disk('public')->delete($admin->foto_profil);
            }

            // Simpan foto profil dengan nama asli
            $file = $request->file('foto_profil');
            $filename = $file->getClientOriginalName(); // Mengambil nama file asli
            $path = $file->storeAs('profile_pictures', $filename, 'public'); // Menyimpan dengan nama asli
            $admin->foto_profil = $path; // Menyimpan jalur file di database
        }

        // Simpan perubahan
        $admin->save(); // Memastikan ini dipanggil pada instansi Admin

        // Kembali dengan pesan sukses
        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }

    public function editProfile()
    {
        $admin = Auth::user(); // Mendapatkan admin yang sedang terautentikasi

        // Pastikan admin terautentikasi
        if (!$admin) {
            return redirect()->route('admin.login')->with('error', 'Silakan masuk terlebih dahulu.');
        }

        return view('admin.profile.edit', compact('admin'));
    }

    public function index()
    {
        $gurus = Admin::where('role', 'guru')->get();
        return view('admin.guru.index', compact('gurus'));
    }
    public function indexForClient()
    {
        // $teachers = Admin::where('role', 'guru')->get();
        $teachers = Admin::where('role', 'guru')->paginate(9);
        return view('client.pages.teachers', compact('teachers'));
    }

    public function create()
    {
        return view('admin.guru.create');
    }

    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5048',
            'email' => 'required|email|unique:admin,email',
            'role' => 'required|in:admin,guru',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Jika ada foto profil, simpan file dan ambil path-nya
        if ($request->hasFile('foto_profil')) {
            $file = $request->file('foto_profil');

            // Ambil nama asli file
            $filename = $file->getClientOriginalName();

            // Simpan file dengan nama aslinya di direktori 'profile_pictures' dalam storage publik
            $filePath = $file->storeAs('profile_pictures', $filename, 'public');

            // Simpan path file ke database
            $validatedData['foto_profil'] = $filePath;
        }

        // Enkripsi password sebelum menyimpan
        $validatedData['password'] = bcrypt($request->password);

        // Simpan data ke database
        Admin::create($validatedData);

        // Redirect atau response setelah data berhasil disimpan
        return redirect()->route('guru.index')->with('success', 'Data berhasil disimpan!');
    }

    public function destroy(string $id)
    {
        // Temukan data guru berdasarkan ID
        $guru = Admin::find($id);

        // Jika data ditemukan
        if ($guru) {
            // Jika ada foto profil, hapus file dari storage
            if ($guru->foto_profil) {
                Storage::disk('public')->delete($guru->foto_profil);
            }

            // Hapus data dari database
            $guru->delete();

            // Redirect dengan pesan sukses
            return redirect()->route('guru.index')->with('success', 'Data berhasil dihapus!');
        } else {
            // Jika data tidak ditemukan, redirect dengan pesan error
            return redirect()->route('guru.index')->with('error', 'Data tidak ditemukan!');
        }
    }
}
