<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // user
    public function registerUserView()
    {
        return view('auth.register');
    }

    public function registerUser()
    {
        $validate = request()->validate([
            'nama' => 'required|string|max:50',
            'nik' => 'required|digits:16|unique:users,nik',
            'email' => 'required|email|unique:users,email',
            'nomor_whatsapp' => 'required|digits_between:10,15|unique:users,nomor_whatsapp',
            'rt_rw' => 'nullable|string|max:8',
            'alamat' => 'nullable|string|max:255',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $validate['role'] = 'pengguna';
        $validate['password'] = Hash::make($validate['password']);

        User::create($validate);
        return redirect()->route('login')->with('success', 'Berhasil mendaftar akun. Silahkan masuk.');
    }

    public function updateProfile(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan masuk terlebih dahulu.');
        }

        $user = Auth::user();

        if (!$user instanceof User) {
            return redirect()->back()->with('error', 'Admin tidak valid.');
        }

        $validated = $request->validate([
            'nama' => 'nullable|string|max:50',
            'nik' => 'nullable|digits:16|unique:users,nik,' . $user->id,
            'email' => 'nullable|email|unique:users,email,' . $user->id,
            'nomor_whatsapp' => 'nullable|digits_between:10,15|unique:users,nomor_whatsapp,' . $user->id,
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
        return redirect()->back()->with('success', 'Profil berhasil diubah!');
    }

    public function editProfile()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan masuk terlebih dahulu.');
        }

        return view('profile.edit', compact('user'));
    }

    // admin
    public function getAllPengguna(Request $request)
    {
        $search = $request->get('search');

        $users = User::where('role', 'pengguna')
            ->when($search, function ($query) use ($search) {
                return $query->where('nama', 'like', "%{$search}%");
            })->orderBy('nama', 'asc')
            ->paginate(10);
        return view('pengguna.index', compact('users', 'search'));
    }

    public function editPengguna(string $id)
    {
        return view('pengguna.edit', ['user' => User::find($id)]);
    }

    public function updatePengguna(Request $request, string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return redirect()->back()->with('error', 'Pengguna tidak ditemukan!');
        }

        $validated = $request->validate([
            'nama' => 'nullable|string|max:50',
            'nik' => 'nullable|digits:16|unique:users,nik,' . $id,
            'email' => 'nullable|email|unique:users,email,' . $id,
            'nomor_whatsapp' => 'nullable|digits_between:10,15|unique:users,nomor_whatsapp,' . $id,
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
        return redirect()->back()->with('success', 'Data akun berhasil diubah!');
    }

    public function deactivate($id)
    {
        $user = User::find($id);

        if (!$user) {
            return redirect()->back()->with('error', 'Akun tidak ditemukan.');
        }

        $user->is_active = !$user->is_active;
        $user->save();

        return redirect()->back()->with('success', 'Status akun berhasil diperbarui.');
    }

    // rt
    public function getAllPenggunaByRt(Request $request)
    {
        $search = $request->get('search');
        $user = auth()->user();

        $users = User::where('role', 'pengguna')
            ->where('rt_rw', $user->rt_rw)
            ->when($search, function ($query) use ($search) {
                return $query->where('nama', 'like', "%{$search}%");
            })->orderBy('nama', 'asc')
            ->paginate(10);
        return view('pengguna.index', compact('users', 'search'));
    }


    /**
     * Update the specified resource in storage.
     */


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
