<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.auth.register');
    }

    public function registerUser()
    {
        $validate = request()->validate([
            'nama' => 'required|string|max:50',
            'nik' => 'required|string|max:20',
            'email' => 'required|email|unique:users,email',
            'nomor_whatsapp' => 'required|digits_between:10,15',
            'rt_rw' => 'nullable|string|max:8',
            'alamat' => 'nullable|string|max:255',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $validate['role'] = 'pengguna';
        $validate['password'] = bcrypt($validate['password']);

        try {
            User::create($validate);
            return redirect()->route('admin.login');
        } catch (\Exception $e) {
            return back()->withErrors(['registerUser' => $e->getMessage()]);
        }
    }

    public function registerRt()
    {
        // request()->merge(['role' => 'rt']);

        $validate = request()->validate([
            'nama' => 'required|string|max:50',
            'nik' => 'nullable|string|max:20',
            'email' => 'required|email',
            'nomor_whatsapp' => 'required|digits_between:10,15',
            'rt_rw' => 'required|string|max:8|unique:users,rt_rw',
            'alamat' => 'nullable|string|max:255',
            'role' => 'required|string|in:rt',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $validate['password'] = bcrypt($validate['password']);
        $validate['role'] = 'rt';

        User::create($validate);
        return redirect()->route('rt.index')->with('success', 'Berhasil menambahkan akun ketua RT');
    }

    public function getAllPengguna()
    {
        $users = User::where('role', 'pengguna')
            ->orderBy('nama', 'asc')
            ->get();
        return view('admin.pengguna.index', compact('users'));
    }
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
