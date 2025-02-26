<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RtController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rtLists = User::where('role', 'rt')
            ->orderBy('rt_rw', 'asc')
            ->get()
            ->map(function ($rt) {
                $rt->rt_only = explode('/', $rt->rt_rw)[0]; // ambil RT saja
                return $rt;
            });

        return view('rt.index', compact('rtLists'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('rt.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        request()->merge(['role' => 'rt']);

        $validate = request()->validate([
            'nama' => 'required|string|max:50',
            'nik' => 'nullable|digits:16|unique:users,nik',
            'email' => 'required|email|unique:users,email',
            'nomor_whatsapp' => 'required|digits_between:10,15|unique:users,nomor_whatsapp',
            'rt_rw' => 'required|string|max:8|unique:users,rt_rw',
            'alamat' => 'nullable|string|max:255',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $validate['role'] = 'rt';
        $validate['password'] = Hash::make($validate['password']);

        User::create($validate);

        return redirect()->route('rt.index')->with('success', 'Berhasil menambahkan akun ketua RT');
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
        return view('rt.edit', ['rt' => User::find($id)]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $rt = User::find($id);

        if (!$rt) {
            return redirect()->back()->with('error', 'Ketua RT tidak ditemukan!');
        }

        $validated = $request->validate([
            'nama' => 'required|string|max:50',
            'nik' => 'nullable|digits:16|unique:users,nik,' . $id,
            'email' => 'required|email|unique:users,email,' . $id,
            'nomor_whatsapp' => 'required|digits_between:10,15|unique:users,nomor_whatsapp,' . $id,
            'rt_rw' => 'required|string|max:8',
            'alamat' => 'nullable|string|max:255',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($request->password);
        } else {
            unset($validated['password']);
        }

        $rt->update($validated);
        return redirect()->route('rt.index')->with('success', 'Berhasil mengubah data ketua RT');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $rt = User::find($id);

        if (!$rt) {
            return redirect()->back()->with('error', 'Ketua RT tidak ditemukan!');
        }

        $rt->delete();
        return redirect()->back()->with('success', 'Berhasil menghapus data ketua RT');
    }
}
