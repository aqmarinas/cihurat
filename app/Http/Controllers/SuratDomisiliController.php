<?php

namespace App\Http\Controllers;

use App\Models\SuratDomisili;
use Illuminate\Http\Request;

class SuratDomisiliController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $validate = $request->validate([
            'nama_lengkap' => 'required|string|max:50',
            'nik' => 'required|string|max:50',
            'alamat' => 'required|string|max:50',
            'rt_rw' => 'string|max:50',
            'tempat_lahir' => 'required|string|max:50',
            'tanggal_lahir' => 'required|string|max:50',
            'pekerjaan' => 'required|string|max:50',
            'keperluan' => 'required|string|max:50',
            'no_whatsapp' => 'required|string|max:50',
        ]);

        SuratDomisili::create($validate);
        // todo: success tidak muncul
        return redirect()->back()->with('success', 'Data berhasil ditambahkan');

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
