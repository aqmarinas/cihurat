<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Content;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ContentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = Auth::user()->id; // Mendapatkan ID pengguna yang sedang login

        // Ambil semua kursus yang dimiliki oleh admin yang sedang login
        $courses = Course::where('admin_id', $userId)->get();

        // Ambil konten yang hanya terkait dengan kursus milik admin yang sedang login
        $contents = Content::with('course')
            ->whereHas('course', function ($query) use ($userId) {
                $query->where('admin_id', $userId);
            })->paginate(10);

        return view('admin.content.index', compact('courses', 'contents'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $courses = Course::all(); // Ambil semua kursus
        $contents = Content::with('course')->get(); // Ambil semua konten dengan relasi kursus

        return view('admin.content.create', compact('courses', 'contents'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'pertemuan' => 'required|integer|min:1',
            'deskripsi_konten' => 'required|string|max:255',
            'files.*' => 'required|file|mimes:jpeg,png,jpg,pdf,ppt,pptx,mp4|max:20480',
        ]);

        // Ambil nama course
        $course = Course::find($request->course_id);
        $courseName = $course ? $course->judul : 'Course tidak ditemukan';

        // Cek apakah pertemuan sudah ada untuk course_id yang sama
        $existingContent = Content::where('course_id', $request->course_id)
            ->where('pertemuan', $request->pertemuan)
            ->first();

        if ($existingContent) {
            return redirect()->back()->withErrors(['pertemuan' => "Pertemuan {$request->pertemuan} sudah ada untuk course {$courseName}."]);
        }

        // Proses upload file
        $filePaths = [];
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $fileExtension = $file->getClientOriginalExtension();
                $uniqueFileName = $fileName . '.' . $fileExtension;

                // Cek jika file dengan nama yang sama sudah ada, tambahkan indeks
                $index = 1;
                while (Storage::exists('public/contents/' . $uniqueFileName)) {
                    $uniqueFileName = $fileName . "({$index})." . $fileExtension;
                    $index++;
                }

                // Simpan file dengan nama unik di folder 'public/contents'
                $path = $file->storeAs('public/contents', $uniqueFileName);
                $filePaths[] = str_replace('public/', '', $path); // Simpan path tanpa 'public/' untuk konsistensi
            }
        }

        // Simpan data ke database
        $data = new Content();
        $data->course_id = $request->course_id;
        $data->pertemuan = $request->pertemuan;
        $data->deskripsi_konten = $request->deskripsi_konten;
        $data->file_paths = json_encode($filePaths); // Simpan array file path sebagai JSON
        $data->save();

        // Redirect atau mengembalikan response
        return redirect()->route('content.index')->with('success', 'Data berhasil disimpan!');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $course = Course::findOrFail($id);
        $contents = Content::where('course_id', $course->id)->get();

        // Decode file paths for each content
        foreach ($contents as $content) {
            $content->file_paths = json_decode($content->file_paths);
        }

        return view('client.course.show', compact('course', 'contents'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $content = Content::with('course')->find($id); // Ambil konten dengan
        $courses = Course::all(); // Ambil semua kursus
        return view('admin.content.edit', compact('content', 'courses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'pertemuan' => 'required|integer|min:1',
            'deskripsi_konten' => 'required|string|max:255',
            'files.*' => 'nullable|file|mimes:jpeg,png,jpg,pdf,ppt,pptx,mp4|max:20480', // Support multiple file types
        ]);

        // Temukan data yang ingin diupdate
        $data = Content::findOrFail($id);

        // Update informasi yang ada
        $data->course_id = $request->course_id;
        $data->pertemuan = $request->pertemuan;
        $data->deskripsi_konten = $request->deskripsi_konten;

        // Ambil file path lama dari database
        $existingFiles = !empty($data->file_paths) ? json_decode($data->file_paths, true) : [];

        // Proses upload file baru tanpa menghapus file yang sudah ada
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $fileExtension = $file->getClientOriginalExtension();
                $uniqueFileName = $fileName . '.' . $fileExtension;

                // Cek jika file dengan nama yang sama sudah ada, tambahkan indeks
                $index = 1;
                while (Storage::exists('public/contents/' . $uniqueFileName)) {
                    $uniqueFileName = $fileName . "({$index})." . $fileExtension;
                    $index++;
                }

                // Simpan file dengan nama unik di folder 'public/contents'
                $path = $file->storeAs('public/contents', $uniqueFileName);
                $existingFiles[] = str_replace('public/', '', $path); // Simpan path tanpa 'public/' untuk konsistensi
            }
        }

        // Simpan file path baru dan lama ke database
        $data->file_paths = json_encode($existingFiles);

        // Simpan perubahan ke database
        $data->save();

        // Redirect atau mengembalikan response
        return redirect()->route('content.index')->with('success', 'Data berhasil diupdate!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Ambil konten yang ada
        $content = Content::findOrFail($id);

        // Hapus video jika ada
        if ($content->video) {
            Storage::disk('public')->delete($content->video); // Hapus file video dari penyimpanan
        }

        // Hapus file yang ada di 'file_paths'
        if ($content->file_paths) {
            $filePaths = json_decode($content->file_paths, true);
            foreach ($filePaths as $filePath) {
                // Hapus file dari penyimpanan
                Storage::disk('public')->delete($filePath);
            }
        }

        // Hapus konten dari database
        $content->delete();

        // Redirect atau mengembalikan response
        return redirect()->route('content.index')->with('success', 'Data berhasil dihapus!');
    }


    public function deleteFile(Request $request)
    {
        // Pastikan file_path dan content_id diterima dari request
        $filePath = $request->input('file_path'); // Misalnya: 'uploads/nama_file.ext'
        $contentId = $request->input('content_id');

        // Cari content berdasarkan ID
        $content = Content::find($contentId);

        if (!$content) {
            return response()->json(['success' => false, 'message' => 'Konten tidak ditemukan.'], 404);
        }

        // Decode file_paths dari database
        $filePaths = json_decode($content->file_paths, true);

        // Hapus file dari array
        if (($key = array_search($filePath, $filePaths)) !== false) {
            unset($filePaths[$key]);
        }

        // Update file_paths di database
        $content->file_paths = json_encode(array_values($filePaths)); // Re-index array
        $content->save();

        // Hapus file secara fisik jika diperlukan
        // Pastikan menggunakan disk 'public' jika file disimpan di storage/app/public/uploads
        if (Storage::disk('public')->exists($filePath)) {
            Storage::disk('public')->delete($filePath);
        }

        return response()->json(['success' => true]);
    }
}
