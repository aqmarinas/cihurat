<?php

namespace App\Http\Controllers;

use App\Models\Rw;
use Illuminate\Http\Request;

class RwController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rwLists = Rw::orderBy('rw', 'asc')->get();
        return view('rw.index', compact('rwLists'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('rw.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = request()->validate([
            'nama' => 'required|string|max:50',
            'no_whatsapp' => 'required|digits_between:10,15|unique:users,nomor_whatsapp',
            'rw' => 'required|digits:2|unique:rw,rw',
        ]);

        Rw::create($validate);
        return redirect()->route('rw.index')->with('success', 'Berhasil menambahkan data ketua RW');
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
        $rw = Rw::find($id);

        if (!$rw) {
            return redirect()->back()->with('error', 'Data RW tidak ditemukan');
        }

        $validated = $request->validate([
            'nama' => 'nullable|string|max:50',
            'no_whatsapp' => 'nullable|digits_between:10,15|unique:rw,no_whatsapp,' . $id,
            'rw' => 'nullable|digits:2',
        ]);

        $rw->update($validated);
        return redirect()->back()->with('success', 'Berhasil mengubah data ketua RW');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $rw = Rw::find($id);

        if (!$rw) {
            return redirect()->back()->with('error', 'Ketua RT tidak ditemukan!');
        }

        $rw->delete();
        return redirect()->back()->with('success', 'Berhasil menghapus data ketua RW');
    }
}
