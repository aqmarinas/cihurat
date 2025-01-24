<?php

namespace App\Http\Controllers;

use App\Models\JenisSurat;
use App\Models\Surat;
use App\Models\SuratDomisili;
use App\Models\SuratPengantar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuratController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $letters = JenisSurat::all();
        return view('admin.surat.index', compact('letters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(string $id)
    {
        $surat = JenisSurat::findOrFail($id);
        $user = Auth::user();

        switch ($surat->name) {
            case 'Surat Pengantar RT/RW':
                return view('admin.surat.pengantar_rt.create', compact('surat', 'user'));
            case 'Surat Keterangan Tidak Mampu':
                return view('admin.surat.tidak_mampu.create', compact('surat', 'user'));
            case 'Surat Keterangan Kematian':
                return view('admin.surat.kematian.create', compact('surat', 'user'));
            case 'Surat Keterangan Usaha':
                return view('admin.surat.usaha.create', compact('surat', 'user'));
            case 'Surat Keterangan Belum Menikah':
                return view('admin.surat.belum_menikah.create', compact('surat', 'user'));
            case 'Surat Keterangan Ahli Waris':
                return view('admin.surat.ahli_waris.create', compact('surat', 'user'));
            case 'Surat Keterangan Ahli Waris Bank':
                return view('admin.surat.ahli_waris_bank.create', compact('surat', 'user'));
            case 'Surat Pernyataan Kepemilikan Tanah':
                return view('admin.surat.kepemilikan_tanah.create', compact('surat', 'user'));
            case 'Surat Keterangan Domisili':
                return view('admin.surat.domisili.create', compact('surat', 'user'));
            case 'Surat Keterangan Beda Nama':
                return view('admin.surat.beda_nama.create', compact('surat', 'user'));
            default:
                abort(404, 'Jenis surat tidak ditemukan');
        }
        return view('admin.surat.create', compact('letters'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $jenis_surat = $request->input('jenis_surat');

            switch ($jenis_surat) {
                case 'Surat Domisili':
                    $validateSurat = $request->validate([
                        'nama' => 'required|string|max:50',
                        'nik' => 'required|digits:16',
                        'tempat_lahir' => 'required|string|max:30',
                        'tanggal_lahir' => 'required|string|max:30',
                        'status_kawin' => 'required|string|max:50',
                        'agama' => 'required|string|max:50',
                        'pekerjaan' => 'required|string|max:30',
                        'alamat' => 'required|string|max:50',
                        'keperluan' => 'required|string|max:50',
                        'no_whatsapp' => 'required|string|max:20',
                    ]);

                    $suratModel = SuratDomisili::create($validateSurat);
                    break;
                case 'Surat Pengantar':
                    $validateSurat = $request->validate([
                        'nama' => 'required|string|max:50',
                        'tempat_lahir' => 'required|string|max:30',
                        'tanggal_lahir' => 'required|string|max:30',
                        'jenis_kelamin' => 'required|string|max:15',
                        'agama' => 'required|string|max:50',
                        'pekerjaan' => 'required|string|max:30',
                        'nik' => 'required|digits:16',
                        'keperluan' => 'required|string|max:50',
                        'no_whatsapp' => 'required|string|max:20',
                        'ktp_file' => 'required|image|mimes:jpg,jpeg,png|max:2048'
                    ]);

                    $ktpFile = $request->file('ktp_file');
                    $filename = time() . '.' . $ktpFile->getClientOriginalExtension();
                    $path = $ktpFile->storeAs('documents/ktp', $filename, 'public');


                    $suratModel = SuratPengantar::create(array_merge($validateSurat, [
                        'ktp_file' => $path
                    ]));
                    break;
                default:
                    return redirect()->route('surat.index')->with('error', 'Jenis surat tidak valid');
            }

            Surat::create([
                'user_id' => auth()->id(),
                'rt_rw' => auth()->user()->rt_rw,
                'suratable_type' => get_class($suratModel),
                'suratable_id' => $suratModel->id,
                'jenis_surat' => $jenis_surat,
                'tanggal_pengajuan' => now(),
            ]);
            return redirect()->route('pengguna.riwayat')->with('success', 'Berhasil mengajukan ' . $jenis_surat);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id) {}

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

    // User
    public function history()
    {
        $histories = Surat::where('user_id', auth()->id())
            ->orderBy('tanggal_pengajuan', 'desc')
            ->paginate(5);

        return view('admin.riwayat.index', compact('histories'));
    }

    public function historyDetails(string $id)
    {
        $surat = Surat::with(['user', 'suratable'])->findOrFail($id);

        if (!$surat) {
            return redirect()->route('verifikasi.index')->with('error', 'Data pengajuan surat tidak ditemukan.');
        }

        $detailSurat = $surat->suratable;

        return view('admin.riwayat.detail', compact('surat', 'detailSurat'));
    }


    // Admin
    public function kelolaSurat(Request $request)
    {
        $status = $request->get('status');
        $allLeters = Surat::query()
            ->when($status, function ($query, $status) {
                return $query->where('status', strtoupper($status));
            })
            ->orderBy('tanggal_pengajuan', 'desc')
            ->get();

        return view('admin.arsip.index', compact('allLeters'));
    }
}
