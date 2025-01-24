<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use Illuminate\Http\Request;
use PhpOffice\PhpWord\TemplateProcessor;

class VerifSuratController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $status = $request->get('status');
        $user = auth()->user();

        $letters = Surat::with('user')
            ->where('rt_rw', $user->rt_rw)
            ->when($status, function ($query, $status) {
                return $query->where('status', strtoupper($status));
            })
            ->orderBy('tanggal_pengajuan', 'desc')
            ->paginate(5);

        return view('admin.verif.index', compact('letters', 'status'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $surat = Surat::with(['user', 'suratable'])->findOrFail($id);

        if (!$surat) {
            return redirect()->route('verifikasi.index')->with('error', 'Data pengajuan surat tidak ditemukan.');
        }

        $detailSurat = $surat->suratable;

        return view('admin.verif.detail', compact('surat', 'detailSurat'));
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

    public function setujui(string $id)
    {
        try {
            $letter = Surat::findOrFail($id);
            $letter->status = 'DISETUJUI';
            $letter->tanggal_disetujui = now();
            $letter->save();

            $this->generate($letter); // generate surat

            return redirect()->back()->with('success', 'Pengajuan berhasil disetujui.');
        } catch (\Exception $e) {
            return back()->withErrors(['verifikasi.show' => $e->getMessage()]);
        }
    }

    public function tolak(Request $request, string $id)
    {
        try {
            $request->validate([
                'keterangan' => 'required|string|max:255',
            ]);

            $letter = Surat::findOrFail($id);
            $letter->status = 'DITOLAK';
            $letter->keterangan = $request->keterangan;
            $letter->save();

            return redirect()->back()->with('success', 'Pengajuan berhasil disetujui.');
        } catch (\Exception $e) {
            return back()->withErrors(['verifikasi..show' => $e->getMessage()]);
        }
    }
    protected function generate(Surat $letter)
    {
        $detailSurat = $letter->suratable;

        if (!$detailSurat) {
            return redirect()->back()->with('error', 'Data surat tidak ditemukan.');
        }

        // Pilih template sesuai jenis surat
        switch ($letter->jenis_surat) {
            case 'Surat Domisili':
                $templatePath = public_path('templates/09. Surat Keterangan Domisili.docx');
                $outputPath = storage_path('app/public/surat_domisili_' . $detailSurat->id . '.docx');
                break;

            case 'Surat Keterangan Tidak Mampu':
                $templatePath = public_path('templates/10. Surat Keterangan Tidak Mampu.docx');
                $outputPath = storage_path('app/public/surat_tidak_mampu_' . $detailSurat->id . '.docx');
                break;

            case 'Surat Pengantar':
                $templatePath = public_path('templates/01. Surat Pengantar RT RW.docx');
                $outputPath = storage_path('app/public/surat_pengantar_' . $detailSurat->id . '.docx');
                break;

            default:
                return redirect()->back()->with('error', 'Template untuk jenis surat ini belum tersedia.');
        }

        // Load template
        $templateProcessor = new TemplateProcessor($templatePath);

        // Set placeholders (dinamis untuk semua jenis surat)
        $placeholders = [
            'nama' => $detailSurat->nama ?? '',
            'nik' => $detailSurat->nik ?? '',
            'tempat_lahir' => $detailSurat->tempat_lahir ?? '',
            'tanggal_lahir' => $detailSurat->tanggal_lahir ?? '',
            'status_kawin' => $detailSurat->status_kawin ?? '',
            'agama' => $detailSurat->agama ?? '',
            'pekerjaan' => $detailSurat->pekerjaan ?? '',
            'alamat' => $detailSurat->alamat ?? '',
            'keperluan' => $detailSurat->keperluan ?? '',
            'no_whatsapp' => $detailSurat->no_whatsapp ?? '',
            'tanggal_disetujui' => now()->translatedFormat('d F Y'),
        ];

        $templateProcessor->setValues($placeholders);

        // Simpan file hasil
        $templateProcessor->saveAs($outputPath);

        // Kirim file ke browser untuk diunduh
        return response()->download($outputPath)->deleteFileAfterSend(true);
    }

    public function download(string $id)
    {
        $letter = Surat::with('suratable')->findOrFail($id);

        if ($letter->status !== 'DISETUJUI') {
            return redirect()->back()->with('error', 'Surat hanya dapat diunduh setelah disetujui.');
        }

        $detailSurat = $letter->suratable;

        if (!$detailSurat) {
            return redirect()->back()->with('error', 'Data surat tidak ditemukan.');
        }

        // Tentukan path file berdasarkan jenis surat
        switch ($letter->jenis_surat) {
            case 'Surat Domisili':
                $outputPath = storage_path('app/public/surat_domisili_' . $detailSurat->id . '.docx');
                break;

            case 'Surat Keterangan Tidak Mampu':
                $outputPath = storage_path('app/public/surat_tidak_mampu_' . $detailSurat->id . '.docx');
                break;

            case 'Surat Pengantar RT/RW':
                $outputPath = storage_path('app/public/surat_pengantar_' . $detailSurat->id . '.docx');
                break;

            default:
                return redirect()->back()->with('error', 'File untuk jenis surat ini tidak ditemukan.');
        }

        // Periksa apakah file ada
        if (!file_exists($outputPath)) {
            return redirect()->back()->with('error', 'File surat belum tersedia.');
        }

        // Unduh file
        return response()->download($outputPath);
    }
}
