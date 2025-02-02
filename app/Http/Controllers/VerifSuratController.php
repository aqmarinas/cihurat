<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use App\Models\SuratField;
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
        $search = $request->get('search');
        $user = auth()->user();

        $letters = Surat::with('user')
            ->where('rt_rw', $user->rt_rw)
            ->when($status, function ($query, $status) {
                return $query->where('status', strtoupper($status));
            })
            ->when($search, function ($query) use ($search) {
                return $query->where('nama', 'like', "%{$search}%");
            })
            ->orderBy('tanggal_pengajuan', 'desc')
            ->paginate(5);

        return view('verif.index', compact('letters', 'status', 'search'));
    }


    public function show(string $id)
    {
        $surat = Surat::with(['user', 'suratable'])->find($id);

        if (!$surat) {
            return redirect()->route('verifikasi.index')->with('error', 'Data pengajuan surat tidak ditemukan.');
        }

        if (auth()->user()->role !== 'rt' || auth()->user()->rt_rw !== $surat->rt_rw) {
            return redirect()->route('verifikasi.index')->with('error', 'Anda tidak berwenang melihat verifikasi ini.');
        }

        $detailSurat = $surat->suratable;
        $fields = SuratField::where('jenis_surat', $surat->jenis_surat)->get();


        return view('riwayat.detail', compact('surat', 'detailSurat', 'fields'));
    }

    public function tolak(Request $request, string $id)
    {
        $letter = Surat::find($id);

        if (!$letter) {
            return redirect()->route('verifikasi.index')->with('error', 'Data pengajuan surat tidak ditemukan.');
        }

        $request->validate([
            'keterangan' => 'required|string|max:255',
        ]);

        $letter->status = 'DITOLAK';
        $letter->keterangan = $request->keterangan;
        $letter->save();

        return redirect()->route('verifikasi.index')->with('success', 'Pengajuan berhasil ditolak.');
    }


    public function setujui(string $id)
    {
        $letter = Surat::find($id);

        if (!$letter) {
            return redirect()->route('verifikasi.index')->with('error', 'Data pengajuan surat tidak ditemukan.');
        }

        // update status
        $letter->status = 'DISETUJUI';
        $letter->tanggal_disetujui = now();
        $letter->save();

        return redirect()->route('verifikasi.index')->with('success', 'Pengajuan berhasil disetujui.');
    }


    protected function generate(Surat $letter)
    {
        $detailSurat = $letter->suratable;

        if (!$detailSurat) {
            return redirect()->route('verifikasi.index')->with('error', 'Data surat tidak ditemukan.');
        }

        // Pilih template sesuai jenis surat
        switch ($letter->jenis_surat) {
            case 'Surat Pengantar':
                $templatePath = public_path('templates/Surat Pengantar RT RW.docx');
                $outputPath = storage_path('app/public/surat/surat_pengantar/Surat_Pengantar_' . $detailSurat->id . '.docx');
                break;
            case 'Surat Keterangan Tidak Mampu':
                $templatePath = public_path('templates/Surat Keterangan Tidak Mampu.docx');
                $outputPath = storage_path('app/public/surat/surat_tidak_mampu/Surat_Tidak_Mampu_' . $detailSurat->id . '.docx');
                break;
            case 'Surat Keterangan Kematian':
                $templatePath = public_path('templates/Surat Keterangan Kematian.docx');
                $outputPath = storage_path('app/public/surat/surat_kematian/Surat_Kematian_' . $detailSurat->id . '.docx');
                break;
            case 'Surat Keterangan Usaha':
                $templatePath = public_path('templates/Surat Keterangan Usaha.docx');
                $outputPath = storage_path('app/public/surat/surat_usaha/Surat_Usaha_' . $detailSurat->id . '.docx');
                break;
            case 'Surat Keterangan Belum Menikah':
                $templatePath = public_path('templates/Surat Keterangan Belum Menikah.docx');
                $outputPath = storage_path('app/public/surat/surat_belum_nikah/Surat_Belum_Nikah_' . $detailSurat->id . '.docx');
                break;
            case 'Surat Domisili':
                $templatePath = public_path('templates/Surat Domisili.docx');
                $outputPath = storage_path('app/public/surat/surat_domisili/Surat_Domisili_' . $detailSurat->id . '.docx');
                break;
            default:
                return redirect()->route('verifikasi.index')->with('error', 'Template untuk jenis surat ini belum tersedia.');
        }

        // Load template
        $templateProcessor = new TemplateProcessor($templatePath);

        // Set placeholders sesuai data
        $placeholders = [
            'nama' => $detailSurat->nama ?? '',
            'nik' => $detailSurat->nik ?? '',
            'ttl' => $detailSurat->ttl ?? '',
            'jenis_kelamin' => $detailSurat->jenis_kelamin ?? '',
            'rt' => $detailSurat->rt ?? '',
            'rw' => $detailSurat->rw ?? '',
            'ketua_rt' => $detailSurat->ketua_rt ?? '',
            'ketua_rw' => $detailSurat->ketua_rw ?? '',
            'status_kawin' => $detailSurat->status_kawin ?? '',
            'agama' => $detailSurat->agama ?? '',
            'pekerjaan' => $detailSurat->pekerjaan ?? '',
            'alamat' => $detailSurat->alamat ?? '',
            'keperluan' => $detailSurat->keperluan ?? '',
            'no_whatsapp' => $detailSurat->no_whatsapp ?? '',
            'tanggal_disetujui' => now()->translatedFormat('d F Y'),

            'nama_ortu' => $detailSurat->nama_ortu ?? '',
            'nik_ortu' => $detailSurat->nik_ortu ?? '',
            'ttl_ortu' => $detailSurat->ttl_ortu ?? '',
            'jenis_kelamin_ortu' => $detailSurat->jenis_kelamin_ortu ?? '',
            'penghasilan' => $detailSurat->penghasilan ?? '',
            'sekolah' => $detailSurat->sekolah ?? '',
            'jurusan' => $detailSurat->jurusan ?? '',

            'hari_meninggal' => $detailSurat->hari_meninggal ?? '',
            'tanggal_meninggal' => $detailSurat->tanggal_meninggal ?? '',
            'tempat_meninggal' => $detailSurat->tempat_meninggal ?? '',
            'sebab_meninggal' => $detailSurat->sebab_meninggal ?? '',
            'bin' => $detailSurat->bin ?? '',
            'kewarganegaraan' => $detailSurat->kewarganegaraan ?? '',
            'jenis_usaha' => $detailSurat->jenis_usaha ?? '',

            'ketua_rt' => $detailSurat->ketua_rt ?? '',
            'ketua_rw' => $detailSurat->ketua_rw ?? '',
        ];

        $templateProcessor->setValues($placeholders);

        // Simpan file hasil
        $templateProcessor->saveAs($outputPath);

        // Kirim file ke browser untuk diunduh
        return response()->download($outputPath)->deleteFileAfterSend(true);
    }

    public function download(string $id)
    {
        $letter = Surat::with('suratable')->find($id);

        if (!$letter) {
            return redirect()->route('verifikasi.index')->with('error', 'Data pengajuan surat tidak ditemukan.');
        }

        if ($letter->status !== 'DISETUJUI') {
            return redirect()->route('verifikasi.index')->with('error', 'Surat hanya dapat diunduh setelah disetujui.');
        }

        $detailSurat = $letter->suratable;

        if (!$detailSurat) {
            return redirect()->route('verifikasi.index')->with('error', 'Data detail surat tidak ditemukan.');
        }

        // generate surat
        $this->generate($letter);

        // Tentukan path file berdasarkan jenis surat
        switch ($letter->jenis_surat) {
            case 'Surat Pengantar':
                $outputPath = storage_path('app/public/surat/surat_pengantar/Surat_Pengantar_' . $detailSurat->id . '.docx');
                break;
            case 'Surat Keterangan Tidak Mampu':
                $outputPath = storage_path('app/public/surat/surat_tidak_mampu/Surat_Tidak_Mampu_' . $detailSurat->id . '.docx');
                break;
            case 'Surat Keterangan Kematian':
                $outputPath = storage_path('app/public/surat/surat_kematian/Surat_Kematian_' . $detailSurat->id . '.docx');
                break;
            case 'Surat Keterangan Usaha':
                $outputPath = storage_path('app/public/surat/surat_usaha/Surat_Usaha_' . $detailSurat->id . '.docx');
                break;
            case 'Surat Keterangan Belum Menikah':
                $outputPath = storage_path('app/public/surat/surat_belum_nikah/Surat_Belum_Nikah_' . $detailSurat->id . '.docx');
                break;
            case 'Surat Domisili':
                $outputPath = storage_path('app/public/surat/surat_domisili/Surat_Domisili_' . $detailSurat->id . '.docx');
                break;

            default:
                return redirect()->route('verifikasi.index')->with('error', 'File untuk jenis surat ini tidak ditemukan.');
        }

        return response()->download($outputPath);
    }
}
