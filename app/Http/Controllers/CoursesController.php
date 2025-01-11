<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Content;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class CoursesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $adminId = auth()->id();

        $courses = Course::where('admin_id', $adminId)->get();

        return view('admin.course.index', compact('courses'));
    }

    public function indexCoursesClient(Request $request)
    {
        // $courses = Course::all();
        // $courses = Course::paginate(6);

        $search = $request->input('search');

        $courses = Course::query()
            ->when($search, function ($query, $search) {
                return $query->where('judul', 'like', '%' . $search . '%')
                    ->orWhere('deskripsi', 'like', '%' . $search . '%');
            })
            ->paginate(6);

        return view('client.pages.courses', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $courses = Course::all();
        return view('admin.course.index', compact('courses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input, termasuk thumbnail
        $validasi = $request->validate([
            'judul' => 'required|max:255',
            'deskripsi' => 'required|max:255',
            'thumbnail' => 'image|mimes:jpeg,png,jpg,gif,svg|max:10048', // Validasi file gambar
        ]);

        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $fileExtension = $file->getClientOriginalExtension();
            $uniqueFileName = $fileName . '.' . $fileExtension;

            // Cek jika file dengan nama yang sama sudah ada, tambahkan indeks
            $index = 1;
            while (Storage::exists('public/thumbnails/' . $uniqueFileName)) {
                $uniqueFileName = $fileName . "({$index})." . $fileExtension;
                $index++;
            }

            // Simpan file dengan nama unik ke folder 'public/thumbnails'
            $file->storeAs('public/thumbnails', $uniqueFileName);

            // Buat entri data course dengan thumbnail dan admin_id
            Course::create([
                'admin_id' => auth()->id(),
                'judul' => $validasi['judul'],
                'deskripsi' => $validasi['deskripsi'],
                'thumbnail' => 'thumbnails/' . $uniqueFileName, // Simpan path thumbnail
            ]);

            return redirect()->route('course.index')->with('success', 'Course has been saved');
        } else {
            return redirect()->route('course.index')->with('error', 'Thumbnail is required');
        }
    }


    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        // Cari course berdasarkan slug
        $course = Course::where('slug', $slug)->firstOrFail();

        // Ambil konten terkait dengan course yang ditemukan
        $contents = Content::where('course_id', $course->id)->get();

        return view('client.pages.detail', compact('course', 'contents'));
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
    public function update(Request $request, string $slug)
    {
        // Validasi input
        $validasi = $request->validate([
            'judul' => 'required|sometimes|max:255',
            'deskripsi' => 'required|sometimes|max:255',
            'thumbnail' => 'nullable|sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:10048',
        ]);

        // Cari course berdasarkan slug
        $course = Course::where('slug', $slug)->firstOrFail();

        // Simpan path thumbnail lama
        $oldThumbnailPath = $course->thumbnail;

        // Update data course (tanpa thumbnail terlebih dahulu)
        $course->update([
            'judul' => $validasi['judul'],
            'deskripsi' => $validasi['deskripsi']
        ]);

        // Periksa jika ada thumbnail baru yang diunggah
        if ($request->hasFile('thumbnail')) {
            // Ambil file thumbnail baru
            $file = $request->file('thumbnail');
            $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $fileExtension = $file->getClientOriginalExtension();
            $uniqueFileName = $fileName . '.' . $fileExtension;

            // Cek jika file dengan nama yang sama sudah ada, tambahkan indeks
            $index = 1;
            while (Storage::exists('public/thumbnails/' . $uniqueFileName)) {
                $uniqueFileName = $fileName . "({$index})." . $fileExtension;
                $index++;
            }

            // Simpan file baru ke folder 'public/thumbnails' dengan nama yang unik
            $file->storeAs('public/thumbnails', $uniqueFileName);

            // Update path thumbnail pada data course
            $course->update(['thumbnail' => 'thumbnails/' . $uniqueFileName]);

            // Hapus file thumbnail lama jika ada
            if ($oldThumbnailPath) {
                $oldFilePath = storage_path('app/public/' . $oldThumbnailPath);
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }
            }
        }

        return redirect()->route('course.index')->with('success', 'Course updated successfully!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $slug)
    {
        $course = Course::where('slug', $slug)->first();

        if ($course) {
            // Hapus thumbnail dari storage jika ada
            if ($course->thumbnail) {
                $thumbnailPath = public_path('storage/' . $course->thumbnail);
                if (file_exists($thumbnailPath)) {
                    unlink($thumbnailPath); // Hapus file thumbnail
                }
            }

            $course->delete(); // Hapus kursus dari database

            return redirect()->back()->with('success', 'Course deleted successfully!');
        }

        return redirect()->back()->with('error', 'Course not found.');
    }
}
