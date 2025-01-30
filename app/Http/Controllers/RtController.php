<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

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
            'nik' => 'nullable|string|max:20',
            'email' => 'required|email',
            'nomor_whatsapp' => 'required|digits_between:10,15',
            'rt_rw' => 'required|string|max:8',
            'alamat' => 'nullable|string|max:255',
            'role' => 'required|string|in:rt',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $validate['password'] = bcrypt($validate['password']);

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
        //
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
            'rt_rw' => 'required|string|max:8',
            'nomor_whatsapp' => 'required|string|max:15',
        ]);

        $rt->update($validated);
        return redirect()->back()->with('success', 'Berhasil mengubah data ketua RT');
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
