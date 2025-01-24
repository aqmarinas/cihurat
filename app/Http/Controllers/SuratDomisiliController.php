<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use App\Models\SuratDomisili;
use Illuminate\Http\Request;
use PhpOffice\PhpWord\TemplateProcessor;

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
        $validateSurat = $request->validate([
            'nama' => 'required|string|max:50',
            'nik' => 'required|digits:16',
            'tempat_lahir' => 'required|string|max:30',
            'tanggal_lahir' => 'required|string|max:30',
            'status_kawin' => 'required|string|max:50',
            'agama' => 'required|string|max:50',
            'pekerjaan' => 'required|string|max:50',
            'alamat' => 'required|string|max:50',
            'keperluan' => 'required|string|max:50',
            'no_whatsapp' => 'required|string|max:50',
        ]);

        $suratDomisili = SuratDomisili::create($validateSurat);

        Surat::create([
            'user_id' => auth()->id(),
            'rt_rw' => auth()->user()->rt_rw,
            'suratable_type' => SuratDomisili::class,
            'suratable_id' => $suratDomisili->id,
            'jenis_surat' => 'Surat Domisili',
            'tanggal_pengajuan' => now(),
        ]);

        // todo: success tidak muncul
        return redirect()->back()->with('success', 'Berhasil mengajukan surat domisili');
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
