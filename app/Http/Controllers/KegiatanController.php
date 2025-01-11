<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KegiatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil admin yang sedang login
        // $admin = auth()->user();

        // Ambil semua kegiatan yang terkait dengan admin ini
        $kegiatans = Kegiatan::all();

        // Kirimkan data kegiatan ke view
        return view("admin.kegiatan.index", compact('kegiatans'));
    }

    public function indexActivitiesClient()
    {
        $activities = Kegiatan::paginate(9);
        return view('client.pages.activities')->with('activities', $activities);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("admin.kegiatan.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            "gambar_kegiatan" => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10899',
            "deskripsi_kegiatan" => 'required|string|max:255',
            "waktu" => 'required|integer|digits:4'
        ]);

        // Ambil file gambar
        $file = $request->file('gambar_kegiatan');
        $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $fileExtension = $file->getClientOriginalExtension();
        $uniqueFileName = $fileName . '.' . $fileExtension;

        // Cek jika file dengan nama yang sama sudah ada, tambahkan indeks
        $index = 1;
        while (Storage::exists('public/kegiatan/' . $uniqueFileName)) {
            $uniqueFileName = $fileName . "({$index})." . $fileExtension;
            $index++;
        }

        // Menyimpan gambar ke storage dengan nama unik
        $gambarPath = $file->storeAs('public/kegiatan', $uniqueFileName);
        $gambarPath = str_replace('public/', '', $gambarPath); // Menghilangkan 'public/' dari path untuk konsistensi

        // Membuat data kegiatan dengan menambahkan path gambar
        Kegiatan::create([
            'admin_id' => auth()->id(),
            'gambar_kegiatan' => $gambarPath, // Simpan path gambar
            'deskripsi_kegiatan' => $request->deskripsi_kegiatan, // Simpan deskripsi
            'waktu' => $request->waktu // Simpan waktu
        ]);

        return redirect()->route('kegiatan.index')->with('success', 'Kegiatan has been saved');
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $kegiatans = Kegiatan::all()->find($id);

        return view("admin.content.edit", compact("kegiatans"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $kegiatan = Kegiatan::all()->find($id);
        return view("admin.kegiatan.edit", compact('kegiatan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validasi input
        $request->validate([
            "gambar_kegiatan" => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10899',
            "deskripsi_kegiatan" => 'required|string|max:255',
            "waktu" => 'required|integer|digits:4'
        ]);

        // Mencari kegiatan berdasarkan ID
        $kegiatan = Kegiatan::findOrFail($id);

        // Menyiapkan data untuk diupdate
        $dataToUpdate = [
            'deskripsi_kegiatan' => $request->deskripsi_kegiatan,
            'waktu' => $request->waktu
        ];

        // Memeriksa apakah gambar baru diupload
        if ($request->hasFile('gambar_kegiatan')) {
            // Menghapus gambar lama dari storage jika ada
            if ($kegiatan->gambar_kegiatan) {
                Storage::disk('public')->delete($kegiatan->gambar_kegiatan);
            }

            // Mengambil file gambar baru
            $file = $request->file('gambar_kegiatan');
            $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $fileExtension = $file->getClientOriginalExtension();
            $uniqueFileName = $fileName . '.' . $fileExtension;

            // Cek jika file dengan nama yang sama sudah ada, tambahkan indeks
            $index = 1;
            while (Storage::exists('public/kegiatan/' . $uniqueFileName)) {
                $uniqueFileName = $fileName . "({$index})." . $fileExtension;
                $index++;
            }

            // Menyimpan gambar baru dengan nama unik
            $gambarPath = $file->storeAs('public/kegiatan', $uniqueFileName);
            $gambarPath = str_replace('public/', '', $gambarPath); // Menghilangkan 'public/' dari path untuk konsistensi

            // Menambahkan path gambar baru ke data yang akan diupdate
            $dataToUpdate['gambar_kegiatan'] = $gambarPath;
        }

        // Melakukan update data kegiatan
        $kegiatan->update($dataToUpdate);

        return redirect()->route('kegiatan.index')->with('success', 'Kegiatan has been updated');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $kegiatan = Kegiatan::findOrFail($id);

        if ($kegiatan) {
            // Hapus thumbnail dari storage jika ada
            if ($kegiatan->gambar_kegiatan) {
                $gambar_kegiatanPath = public_path('storage/' . $kegiatan->gambar_kegiatan); // Sesuaikan dengan lokasi penyimpanan gambar_kegiatan
                if (file_exists($gambar_kegiatanPath)) {
                    unlink($gambar_kegiatanPath); // Hapus file thumbnail
                }
            }

            $kegiatan->delete(); // Hapus kursus dari database

            return redirect()->back()->with('success', 'Kegiatan deleted successfully!');
        }

        return redirect()->back()->with('error', 'Kegiatan not found.');
    }
}
