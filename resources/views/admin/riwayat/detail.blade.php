@extends('admin.layouts.app')

@section('title', 'Detail Pengajuan Surat')

@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-body">
                <div class="mb-3">
                    @if (Auth::user()->role == 'pengguna')
                        <a href="{{ route('pengguna.riwayat') }}" class="text-secondary">← Kembali</a>
                    @elseif (Auth::user()->role == 'rt')
                        <a href="{{ route('verifikasi.index') }}" class="text-secondary">← Kembali</a>
                    @elseif (Auth::user()->role == 'admin')
                        {{-- todo: route --}}
                        <a href="{{ route('verifikasi.index') }}" class="text-secondary">← Kembali</a>
                    @endif
                </div>

                <h5><strong>Detail Pengajuan {{ $surat->jenis_surat }}</strong>
                </h5>
                {{-- Surat --}}
                <div class="row">
                    <div class="col-md-6">
                        <p>
                            <strong>Tanggal Pengajuan</strong>
                            <br>
                            @if ($surat->tanggal_pengajuan)
                                {{ \Carbon\Carbon::parse($surat->tanggal_pengajuan)->translatedFormat('d F Y H:i') }}
                                WIB
                            @else
                                -
                            @endif
                        </p>
                        <p>
                            <strong>Tanggal Disetujui</strong>
                            <br>
                            @if ($surat->tanggal_disetujui)
                                {{ \Carbon\Carbon::parse($surat->tanggal_disetujui)->translatedFormat('d F Y H:i') }}
                                WIB
                            @else
                                -
                            @endif
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p>
                            <strong>Status Pengajuan</strong>
                            <br>
                            @if ($surat->status === 'MENUNGGU')
                                <span class="badge bg-warning">Menunggu</span>
                            @elseif ($surat->status === 'DISETUJUI')
                                <span class="badge bg-success">Disetujui</span>
                            @elseif ($surat->status === 'DITOLAK')
                                <span class="badge bg-danger">Ditolak</span>
                            @else
                                "-"
                            @endif
                        </p>

                        <p>
                            <strong>Keterangan</strong>
                            <br>
                            {{ $surat->keterangan ?? '-' }}
                        </p>

                    </div>
                </div>

                <hr>

                {{-- Detail  --}}
                @if ($surat->jenis_surat === 'Surat Domisili')
                    <div class="row">
                        <div class="col-md-6">
                            <p>
                                <strong>Nama</strong>
                                <br>
                                {{ $detailSurat->nama ?? '-' }}
                            </p>
                            <p>
                                <strong>Nomor WhatsApp</strong>
                                <br>
                                {{ $detailSurat->no_whatsapp ?? '-' }}
                            </p>

                            <p>
                                <strong>NIK</strong>
                                <br>
                                {{ $detailSurat->nik ?? '-' }}
                            </p>
                            <p>
                                <strong>Tempat, Tanggal Lahir</strong>
                                <br>
                                {{ $detailSurat->tempat_lahir ?? '-' }}, {{ $detailSurat->tanggal_lahir ?? '-' }}
                            </p>
                            <p>
                                <strong>Status Perkawinan</strong>
                                <br>
                                {{ $detailSurat->status_kawin ?? '-' }}
                            </p>

                        </div>
                        <div class="col-md-6">
                            <p>
                                <strong>Agama</strong>
                                <br>
                                {{ $detailSurat->agama ?? '-' }}
                            </p>
                            <p>
                                <strong>Pekerjaan</strong>
                                <br>
                                {{ $detailSurat->pekerjaan ?? '-' }}
                            </p>
                            <p>
                                <strong>Alamat</strong>
                                <br>
                                {{ $detailSurat->alamat ?? '-' }}
                            </p>
                            <p>
                                <strong>Keperluan</strong>
                                <br>
                                {{ $detailSurat->keperluan ?? '-' }}
                            </p>
                        </div>
                    </div>
                @elseif($surat->jenis_surat === 'Surat Pengantar')
                    <div class="row">
                        <div class="col-md-6">
                            <p>
                                <strong>Nama</strong>
                                <br>
                                {{ $detailSurat->nama ?? '-' }}
                            </p>
                            <p>
                                <strong>Nomor WhatsApp</strong>
                                <br>
                                {{ $detailSurat->no_whatsapp ?? '-' }}
                            </p>

                            <p>
                                <strong>NIK</strong>
                                <br>
                                {{ $detailSurat->nik ?? '-' }}
                            </p>
                            <p>
                                <strong>Tempat, Tanggal Lahir</strong>
                                <br>
                                {{ $detailSurat->tempat_lahir ?? '-' }}, {{ $detailSurat->tanggal_lahir ?? '-' }}
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p>
                                <strong>Jenis Kelamin</strong>
                                <br>
                                {{ $detailSurat->jenis_kelamin ?? '-' }}
                            </p>

                            <p>
                                <strong>Agama</strong>
                                <br>
                                {{ $detailSurat->agama ?? '-' }}
                            </p>
                            <p>
                                <strong>Pekerjaan</strong>
                                <br>
                                {{ $detailSurat->pekerjaan ?? '-' }}
                            </p>
                            <p>
                                <strong>Keperluan</strong>
                                <br>
                                {{ $detailSurat->keperluan ?? '-' }}
                            </p>
                        </div>
                    </div>
                @else
                    <p>Jenis surat tidak diketahui.</p>
                @endif

                <hr>
                {{-- todo: Lampiran --}}
                <h5><strong>Lampiran</strong></h5>
                <p>{{ $detailSurat->ktp_file ?? '-' }}</p>
                <img src="{{ asset('storage/' . $detailSurat->ktp_file) }}" alt="KTP"
                    style="max-width: 300px; max-height: 400px;">

            </div>
        </div>
    </div>
    </div>
@endsection
