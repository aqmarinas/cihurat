<?php

namespace App\Http\Controllers\Auth;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    // Proses login admin
    // public function login(Request $request)
    // {
    //     try {
    //         // Validasi input
    //         $credentials = $request->validate([
    //             'email' => ['required', 'email'],
    //             'password' => ['required'],
    //         ]);

    //         // Periksa apakah checkbox "remember me" dicentang
    //         $remember = $request->has('remember-me');

    //         // Cek apakah email ada di database admin
    //         $admin = Admin::where('email', $request->email)->first();

    //         if ($admin) {
    //             // Jika email ditemukan di tabel Admin
    //             if (Auth::guard('admin')->attempt($credentials, $remember)) {
    //                 return redirect()->intended(route('dashboard'));
    //             }

    //             // Jika password salah untuk Admin
    //             return back()->withErrors([
    //                 'password' => 'The password is incorrect (admin).',
    //             ])->withInput($request->except('password'));
    //         }

    //         $user = User::where('email', $request->email)->first();
            
    //         if ($user) {
    //             // Jika email ditemukan di tabel Users
    //             if (Auth::guard('users')->attempt($credentials, $remember)) {
    //                 return redirect()->intended(route('dashboard'));
    //             }
    //             // Jika password salah untuk User
    //             return back()->withErrors([
    //                 'password' => 'The password is incorrect (user).',
    //             ])->withInput($request->except('password'));
    //         }

    //         return back()->withErrors([
    //             'email' => 'The email address is not registered.',
    //         ])->withInput($request->except('password'));
    //     } catch (\Exception $e) {
    //         return back()->withErrors(['admin.login' => $e->getMessage()]);
    //     }    
    // }

    public function login2(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();
            return redirect()->route('dashboard'); 
        }        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }
    
    // Logout admin
    public function logout(Request $request)
    {
        // if (Auth::guard('admin')->check()) {
        //     Auth::guard('admin')->logout();
        // } elseif (Auth::guard('users')->check()) {
        //     Auth::guard('users')->logout();
        // }
        
        $request->session()->flush();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }


    public function updateProfile(Request $request)
    {
        try {
            if (!Auth::check()) {
                return redirect()->route('admin.login')->with('error', 'Silakan masuk terlebih dahulu.');
            }

            $user = Auth::user(); 

            if (!$user instanceof User) {
                return redirect()->back()->with('error', 'Admin tidak valid.');
            }

            $validated = $request->validate([
                'nama' => 'nullable|string|max:50',
                'nik' => 'nullable|string|max:20',
                'email' => 'nullable|email',
                'nomor_whatsapp' => 'nullable|digits_between:10,15',
                'rt_rw' => 'nullable|string|max:8',
                'alamat' => 'nullable|string|max:255',
                'password' => 'nullable|string|min:8|confirmed',
            ]);

            if ($request->filled('password')) {
                $validated['password'] = Hash::make($request->password);
            } else {
                unset($validated['password']);
            }

            $user->update($validated);
            return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
        } catch (\Exception $e) {
            return back()->withErrors(['edit.profile' => $e->getMessage()]);
        }    
    }

    public function editProfile()
    {
        $user = Auth::user(); // Mendapatkan admin yang sedang terautentikasi

        // Pastikan admin terautentikasi
        if (!$user) {
            return redirect()->route('admin.login')->with('error', 'Silakan masuk terlebih dahulu.');
        }

        return view('admin.profile.edit', compact('user'));
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
            'nama' => 'required|string|max:255',
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
