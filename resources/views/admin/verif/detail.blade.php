@extends('admin.layouts.app')

@section('title', 'Detail Pengajuan Surat')

@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class="card">
            <div class="card-body">
                <div class="mb-3">
                    <a href="{{ route('verifikasi.index') }}" class="text-secondary">← Kembali</a>
                </div>

                <h5><strong>Detail Pengajuan {{ $surat->jenis_surat }}</strong>
                </h5>
                {{-- Surat --}}
                <div class="row">
                    <div class="col-md-6">
                        <p>
                            <strong>Tanggal Pengajuan</strong>
                            <br>
                            {{ \Carbon\Carbon::parse($surat->tanggal_pengajuan)->translatedFormat('d F Y H:i') ?? '-' }}
                            WIB
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

                <hr>
                {{-- Button --}}
                <div class="d-flex justify-content-end mb-3 me-3">
                    <form action="{{ route('verifikasi.setujui', $surat->id) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-success me-2">
                            <i class="bx bx-check-circle me-1"></i> Setujui
                        </button>
                    </form>

                    <form action="{{ route('verifikasi.tolak', $surat->id) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="button" class="btn btn-danger me-2" data-bs-toggle="modal"
                            data-bs-target="#modalTolak{{ $surat->id }}">
                            <i class="bx bx-x-circle me-1"></i>
                            Tolak
                        </button>
                    </form>
                </div>
            </div>

            <!-- Modal alasan penolakan -->
            <div class="modal fade" id="modalTolak{{ $surat->id }}" tabindex="-1" aria-labelledby="modalTolakLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalTolakLabel">Alasan Penolakan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ route('verifikasi.tolak', $surat->id) }}" method="POST">
                            @csrf
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="keterangan">Masukkan alasan penolakan:</label>
                                    <textarea name="keterangan" id="keterangan" class="form-control" rows="3" required></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-danger">Tolak</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
