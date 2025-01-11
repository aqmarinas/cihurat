<?php

namespace App\Http\Controllers;

use App\Models\Logo;
use Illuminate\Http\Request;

class LogoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $admin = auth()->user();
        $logos = Logo::all();
        return view("admin.logo.index", compact('logos'));
    }
    public function indexForClient()
    {
        // $admin = auth()->user();
        $logos = Logo::all();
        return view("client.components.navbar", compact('logos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("admin.logo.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input dari request
        $validasi = $request->validate([
            'nama_logo' => "required|string|max:255",
            'gambar_logo' => "required|image|mimes:jpeg,png,jpg,gif,svg|max:5048"
        ]);

        // Menyimpan gambar logo jika ada
        if ($request->hasFile('gambar_logo')) {
            $file = $request->file('gambar_logo');
            $filename = $file->getClientOriginalName(); // Menggunakan nama asli file
            $file->move(public_path('uploads/logo'), $filename); // Memindahkan file ke direktori yang diinginkan
            $validasi['gambar_logo'] = $filename; // Menyimpan nama file dalam validasi
        }

        // Membuat logo baru dengan data yang valid
        Logo::create([
            'admin_id' => auth()->id(),
            'nama_logo' => $validasi['nama_logo'], // Menggunakan data validasi
            'gambar_logo' => $validasi['gambar_logo'],
        ]);

        // Redirect ke index dengan pesan sukses
        return redirect()->route('logo.index')->with('success', "Logo berhasil ditambahkan!");
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
        $logos = Logo::all()->find($id);
        return view('admin.logo.edit', compact('logos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validasi input dari request
        $validasi = $request->validate([
            'nama_logo' => 'required|string|max:255',
            'gambar_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5048'
        ]);

        // Temukan logo berdasarkan ID
        $logo = Logo::findOrFail($id);

        // Cek apakah ada file gambar yang diupload
        if ($request->hasFile('gambar_logo')) {
            // Hapus gambar lama jika ada
            if ($logo->gambar_logo && file_exists(public_path('uploads/logo/' . $logo->gambar_logo))) {
                unlink(public_path('uploads/logo/' . $logo->gambar_logo)); // Hapus file lama dari direktori
            }

            // Simpan gambar baru
            $file = $request->file('gambar_logo');
            $filename = $file->getClientOriginalName(); // Simpan dengan nama asli
            $file->move(public_path('uploads/logo'), $filename); // Simpan file ke direktori uploads/logo
            $validasi['gambar_logo'] = $filename; // Simpan nama file ke dalam array validasi
        }

        // Update data logo dengan data baru
        $logo->update($validasi);

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('logo.index')->with('success', 'Logo berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Cari logo berdasarkan ID
        $logo = Logo::findOrFail($id);

        // Cek apakah logo memiliki gambar yang tersimpan
        if ($logo->gambar_logo) {
            // Hapus file gambar dari storage
            $imagePath = public_path('uploads/logo/' . $logo->gambar_logo);
            if (file_exists($imagePath)) {
                unlink($imagePath); // Hapus gambar jika ada
            }
        }

        // Hapus data logo dari database
        $logo->delete();

        // Redirect dengan pesan sukses
        return redirect()->route('logo.index')->with('success', 'Logo berhasil dihapus.');
    }
}
