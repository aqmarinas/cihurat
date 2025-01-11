<?php

namespace App\Http\Controllers;

use App\Models\RtRw;
use Illuminate\Http\Request;

class RtRwController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rtRwLists = RtRw::all();
        return view('admin.rt.index', compact('rtRwLists'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'rt_rw' => 'required|string|max:8',
            'nama_ketua' => 'required|string|max:50',
            'nomor_whatsapp' => 'required|string|max:15',
        ]);

        RtRw::create($validate);
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
        $validate = $request->validate([
            'rt_rw' => 'required|string|max:8',
            'nama_ketua' => 'required|string|max:50',
            'nomor_whatsapp' => 'required|string|max:15',
        ]);

        RtRw::where('id', $id)->update($validate);
        return redirect()->back()->with('success', 'Data berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $rtRw = RtRw::find($id);

        if ($rtRw) {
            $rtRw->delete();
            return redirect()->back()->with('success', 'Data berhasil dihapus');
        }

        return redirect()->back()->with('error', 'RT/RW tidak ditemukan!');
    }
}
