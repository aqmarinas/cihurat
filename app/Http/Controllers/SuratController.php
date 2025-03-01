<?php

namespace App\Http\Controllers;

use App\Models\JenisSurat;
use App\Models\Rw;
use App\Models\Surat;
use App\Models\SuratBelumNikah;
use App\Models\SuratDomisili;
use App\Models\SuratField;
use App\Models\SuratKematian;
use App\Models\SuratPengantar;
use App\Models\SuratTidakMampu;
use App\Models\SuratUsaha;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Illuminate\Support\Str;

class SuratController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $letters = JenisSurat::all();
        return view('surat.index', compact('letters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(string $id)
    {
        $surat = JenisSurat::find($id);
        $user = auth()->user();

        if (!$surat) {
            return redirect()->route('surat.index')->with('error', 'Jenis surat tidak ditemukan.');
        }

        switch ($surat->name) {
            case 'Surat Pengantar RT/RW':
                return view('surat.pengantar_rt.create', compact('surat', 'user'));
            case 'Surat Keterangan Tidak Mampu':
                return view('surat.tidak_mampu.create', compact('surat', 'user'));
            case 'Surat Keterangan Kematian':
                return view('surat.kematian.create', compact('surat', 'user'));
            case 'Surat Keterangan Usaha':
                return view('surat.usaha.create', compact('surat', 'user'));
            case 'Surat Keterangan Belum Menikah':
                return view('surat.belum_menikah.create', compact('surat', 'user'));
            case 'Surat Keterangan Domisili':
                return view('surat.domisili.create', compact('surat', 'user'));
                // case 'Surat Keterangan Ahli Waris':
                //     return view('surat.ahli_waris.create', compact('surat', 'user'));
                // case 'Surat Keterangan Ahli Waris Bank':
                //     return view('surat.ahli_waris_bank.create', compact('surat', 'user'));
                // case 'Surat Pernyataan Kepemilikan Tanah':
                //     return view('surat.kepemilikan_tanah.create', compact('surat', 'user'));
                // case 'Surat Keterangan Beda Nama':
                //     return view('surat.beda_nama.create', compact('surat', 'user'));
            default:
                return redirect()->route('surat.index')->with('error', 'Jenis surat tidak ditemukan');
        }
        return view('surat.create', compact('letters'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $jenis_surat = $request->input('jenis_surat');
        $user = auth()->user();
        $rt_rw = $user->rt_rw;

        $validationRules = [
            'Surat Pengantar' => [
                'nama' => 'required|string|max:50',
                'ttl' => 'required|string|max:50|regex:/^[A-Za-z]+, \d{1,2} [A-Za-z]+ \d{4}$/',
                'jenis_kelamin' => 'required|string|max:15',
                'agama' => 'required|string|max:15',
                'pekerjaan' => 'required|string|max:30',
                'nik' => 'required|digits:16',
                'keperluan' => 'required|string|max:50',
                'no_whatsapp' => 'required|digits_between:10,15',
                'ktp' => 'required|mimes:jpg,jpeg,png|max:1024',
                'kk' => 'required|mimes:jpg,jpeg,png|max:1024'
            ],
            'Surat Domisili' => [
                'nama' => 'required|string|max:50',
                'nik' => 'required|digits:16',
                'ttl' => 'required|string|max:50|regex:/^[A-Za-z]+, \d{1,2} [A-Za-z]+ \d{4}$/',
                'status_kawin' => 'required|string|max:50',
                'agama' => 'required|string|max:50',
                'pekerjaan' => 'required|string|max:30',
                'alamat' => 'required|string|max:255',
                'keperluan' => 'required|string|max:50',
                'no_whatsapp' => 'required|digits_between:10,15',
                'ktp' => 'required|mimes:jpg,jpeg,png|max:1024',
                'kk' => 'required|mimes:jpg,jpeg,png|max:1024'
            ],
            'Surat Keterangan Tidak Mampu' => [
                'nama_ortu' => 'required|string|max:50',
                'nik_ortu' => 'required|digits:16',
                "ttl_ortu" => 'required|string|max:50|regex:/^[A-Za-z]+, \d{1,2} [A-Za-z]+ \d{4}$/',
                'jenis_kelamin_ortu' => 'required|string|max:15',
                'no_whatsapp' => 'required|digits_between:10,15',
                'status_kawin' => 'required|string|max:20',
                'alamat' => 'required|string|max:255',
                'penghasilan' => 'required|string|max:20',

                'nama' => 'required|string|max:50',
                'nik' => 'required|digits:16|different:nik_ortu',
                "ttl" => 'required|string|max:50|regex:/^[A-Za-z]+, \d{1,2} [A-Za-z]+ \d{4}$/|different:ttl_ortu',
                'jenis_kelamin' => 'required|string|max:15',
                'sekolah' => 'required|string|max:50',
                'jurusan' => 'required|string|max:50',
                'keperluan' => 'required|string|max:50',

                'ktp' => 'required|mimes:jpg,jpeg,png|max:1024',
                'kk' => 'required|mimes:jpg,jpeg,png|max:1024',
            ],
            'Surat Keterangan Usaha' => [
                'nama' => 'required|string|max:50',
                'nik' => 'required|digits:16',
                'ttl' => 'required|string|max:50|regex:/^[A-Za-z]+, \d{1,2} [A-Za-z]+ \d{4}$/',
                'kewarganegaraan' => 'required|string|max:20',
                'agama' => 'required|string|max:15',
                'status_kawin' => 'required|string|max:15',
                'pekerjaan' => 'required|string|max:30',
                'alamat' => 'required|string|max:255',
                'jenis_usaha' => 'required|string|max:50',
                'no_whatsapp' => 'required|digits_between:10,15',
                'ktp' => 'required|mimes:jpg,jpeg,png|max:1024',
                'kk' => 'required|mimes:jpg,jpeg,png|max:1024'
            ],
            'Surat Keterangan Belum Menikah' => [
                'nama' => 'required|string|max:50',
                'bin' => 'required|string|max:50',
                'nik' => 'required|digits:16',
                'ttl' => 'required|string|max:50|regex:/^[A-Za-z]+, \d{1,2} [A-Za-z]+ \d{4}$/',
                'agama' => 'required|string|max:15',
                'kewarganegaraan' => 'required|string|max:15',
                'status_kawin' => 'required|string|max:30',
                'pekerjaan' => 'required|string|max:30',
                'alamat' => 'required|string|max:255',
                'no_whatsapp' => 'required|digits_between:10,15',
                'ktp' => 'required|mimes:jpg,jpeg,png|max:1024',
                'kk' => 'required|mimes:jpg,jpeg,png|max:1024'
            ],
        ];

        if (!isset($validationRules[$jenis_surat])) {
            return redirect()->route('riwayat.index')->with('error', 'Jenis surat tidak valid.');
        }

        $validateSurat = $request->validate($validationRules[$jenis_surat]);

        $fileFields = ['ktp', 'kk'];
        $filePaths = [];


        foreach ($fileFields as $field) {
            if ($request->hasFile($field)) {
                $file = $request->file($field);
                $filePaths[$field] = $this->processImageWithWatermark($file, $field);
            }
        }

        $additionalData = [];
        if ($jenis_surat === 'Surat Pengantar') {
            list($rt, $rw) = explode('/', $rt_rw);
            $ketuaRt = User::where('role', 'rt')->where('rt_rw', $rt_rw)->first();
            $ketuaRw = Rw::where('rw', $rw)->first();

            $additionalData = [
                'rt' => $rt,
                'rw' => $rw,
                'ketua_rw' => $ketuaRw->nama ?? "-",
                'ketua_rt' => $ketuaRt->nama ?? "-",
            ];
        }

        $modelMap = [
            'Surat Pengantar' => SuratPengantar::class,
            'Surat Domisili' => SuratDomisili::class,
            'Surat Keterangan Tidak Mampu' => SuratTidakMampu::class,
            'Surat Keterangan Kematian' => SuratKematian::class,
            'Surat Keterangan Usaha' => SuratUsaha::class,
            'Surat Keterangan Belum Menikah' => SuratBelumNikah::class,
        ];

        $modelClass = $modelMap[$jenis_surat];
        $data = array_merge($validateSurat, $filePaths, $additionalData);
        $suratModel = $modelClass::create($data);

        Surat::create([
            'user_id' => $user->id,
            'rt_rw' => $rt_rw,
            'suratable_type' => get_class($suratModel),
            'suratable_id' => $suratModel->id,
            'jenis_surat' => $jenis_surat,
            'tanggal_pengajuan' => now(),
        ]);

        return redirect()->route('riwayat.index')->with('success', 'Berhasil mengajukan ' . $jenis_surat);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $surat = Surat::find($id);

        if (!$surat) {
            return redirect()->route('riwayat.index')->with('error', 'Pengajuan tidak ditemukan.');
        }

        $surat->status = 'DIBATALKAN';
        $surat->save();

        // soft delete
        $surat->delete();

        return redirect()->route('riwayat.index')->with('success', 'Pengajuan berhasil dibatalkan.');
    }

    // User
    public function history()
    {
        $histories = Surat::where('user_id', auth()->id())
            ->withTrashed()
            // ->with('user')
            ->orderBy('tanggal_pengajuan', 'desc')
            ->paginate(5);

        $rt_rw = Auth::user()->rt_rw;
        $rt = explode('/', $rt_rw)[0];

        $ketuaRt = User::where('role', 'rt')
            ->where('rt_rw', "$rt_rw")
            ->first();
        $namaKetua = $ketuaRt ? $ketuaRt->nama : "";
        $noKetua = $ketuaRt ? $ketuaRt->nomor_whatsapp : "";

        return view('riwayat.index', compact('histories', 'rt', 'namaKetua', 'noKetua'));
    }

    public function historyDetails(string $id)
    {
        $surat = Surat::withTrashed()
            ->with(['user', 'suratable'])
            ->find($id);

        if (!$surat) {
            return redirect()->back()->with('error', 'Data pengajuan surat tidak ditemukan.');
        }

        $user = Auth::user();

        if ($user->role === 'pengguna' && $surat->user_id !== $user->id) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk mengakses detail surat ini');
        }

        $detailSurat = $surat->suratable;
        $fields = SuratField::where('jenis_surat', $surat->jenis_surat)->get();

        return view('riwayat.detail', compact('surat', 'detailSurat', 'fields'));
    }

    // Admin
    public function kelolaSurat(Request $request)
    {
        $status = $request->get('status');
        $search = $request->get('search');

        $allLetters = Surat::with('user')
            ->when($status, function ($query, $status) {
                return $query->where('status', strtoupper($status));
            })
            ->when($search, function ($query, $search) {
                return $query->whereHas('user', function ($q) use ($search) {
                    $q->where('nama', 'like', "%{$search}%");
                });
            })
            ->orderBy('tanggal_pengajuan', 'desc')
            ->paginate(10);

        return view('arsip.index', compact('allLetters', 'status', 'search'));
    }

    public function processImageWithWatermark($file, $folder)
    {
        $manager = new ImageManager(new Driver());

        $filename = Str::ulid() . "." . $file->getClientOriginalExtension();
        $watermarkedImage = $manager->read($file);

        $dateTime = date('Y/m/d H:i');
        $textLines = ['Desa Cidahu', 'Kab. Purwakarta', $dateTime];

        $x = $watermarkedImage->width() / 2;
        $lineHeight = 80;
        $startY = ($watermarkedImage->height() / 2) - (count($textLines) - 1) * $lineHeight / 2;

        foreach ($textLines as $index => $line) {
            $y = $startY + ($index * $lineHeight);

            $watermarkedImage->text($line, $x, $y, function ($font) {
                $font->file(public_path('fonts/Roboto-Bold.ttf'));
                $font->size(70);
                $font->color('rgba(192, 192, 192, .5)');
                $font->align('center');
                $font->valign('middle');
            });
        }

        $path = storage_path("app/private/documents/$folder/$filename");
        $watermarkedImage->save($path);

        return "documents/$folder/$filename";
    }

    public function uploadTemplate(Request $request)
    {
        $request->validate([
            'template' => 'required|mimes:docx|max:1024'
        ]);

        $file = $request->file('template');
        $fileName = $file->getClientOriginalName();

        $file->storeAs('private/templates', $fileName);

        return back()->with('success', 'Template berhasil diunggah.');
    }

    public function uploadTemplateView()
    {
        return view('kelola_template.index');
    }
}
