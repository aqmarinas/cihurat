@extends('partials.layouts.app')

@section('title', 'Detail Pengajuan Surat')

@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        {{-- @if ($errors->any())
            <div class="alert-danger alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif --}}

        <div class="card">
            <div class="card-body">
                <div class="mb-3">
                    @if (Auth::user()->role == 'pengguna')
                        <a href="{{ route('pengguna.riwayat') }}" class="text-secondary">← Kembali</a>
                    @elseif (Auth::user()->role == 'rt')
                        <a href="{{ route('verifikasi.index') }}" class="text-secondary">← Kembali</a>
                    @elseif (Auth::user()->role == 'admin')
                        <a href="{{ route('admin.kelola.surat') }}" class="text-secondary">← Kembali</a>
                    @endif
                </div>

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5><strong>Detail Pengajuan {{ $surat->jenis_surat }}</strong></h5>

                    @if (Auth::user()->role == 'pengguna')
                        @if ($surat->status === 'MENUNGGU' && $surat->status !== 'DIBATALKAN' && $surat->status !== 'DISETUJUI')
                            <form id="cancelForm" action="{{ route('surat.destroy', $surat->id) }}" method="POST"
                                class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="button" id="cancelButton" class="btn btn-danger btn-sm">
                                    <i class="bx bx-x-circle me-1"></i> Batal
                                </button>
                            </form>
                        @endif
                    @endif

                    @if (Auth::user()->role == 'admin')
                        @if ($surat->status === 'DISETUJUI')
                            <a href="{{ route('surat.download', $surat->id) }}" class="btn btn-success btn-sm">
                                <i class="fas fa-download"></i> Unduh
                            </a>
                        @endif
                    @endif

                </div>
                {{-- Informasi Pengajuan Surat --}}
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
                            @elseif ($surat->status === 'DIBATALKAN')
                                <span class="badge bg-secondary">Dibatalkan</span>
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

                {{-- Detail Surat --}}
                <div class="row">
                    @foreach ($fields->chunk(ceil($fields->count() / 2)) as $columnFields)
                        <div class="col-md-6">
                            @foreach ($columnFields as $field)
                                <p>
                                    <strong>{{ $field->label }}</strong>
                                    <br>
                                    {{ $detailSurat->{$field->field_name} ?? '-' }}
                                </p>
                            @endforeach
                        </div>
                    @endforeach
                </div>

                <hr>

                <h5><strong>Lampiran</strong></h5>

                @if ($detailSurat->ktp)
                    <x-file-viewer title="KTP" file="{{ $detailSurat->ktp }}" />
                @endif
                @if ($detailSurat->kk)
                    <x-file-viewer title="KK" file="{{ $detailSurat->kk }}" />
                @endif

                {{-- Action --}}
                @if (Auth::user()->role == 'rt')
                    @if ($surat->status === 'MENUNGGU')
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
                    @endif
                @endif

            </div>
        </div>
    </div>

    {{-- Modal lampiran --}}
    <div class="modal fade" id="viewFileModal" tabindex="-1" aria-labelledby="viewFileModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewFileModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img src="" alt="File" id="modalFileImage" class="img-fluid rounded">
                </div>
            </div>
        </div>
    </div>

    {{-- Modal alasan penolakan --}}
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

    <script>
        // Modal Lampiran
        document.addEventListener('DOMContentLoaded', function() {
            const viewFileModal = document.getElementById('viewFileModal');
            const modalTitle = document.getElementById('viewFileModalLabel');
            const modalImage = document.getElementById('modalFileImage');

            viewFileModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const title = button.getAttribute('data-title');
                const file = button.getAttribute('data-file');

                modalTitle.textContent = title;
                modalImage.src = file;
            });
        });

        // Modal Batal
        document.getElementById('cancelButton').addEventListener('click', function(e) {
            e.preventDefault();

            Swal.fire({
                text: "Apakah Anda yakin ingin membatalkan pengajuan surat?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3435',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Batal',
                cancelButtonText: 'Tidak'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('cancelForm').submit();
                }
            });
        });
    </script>

@endsection
