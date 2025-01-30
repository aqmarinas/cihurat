@extends('admin.layouts.app')

@section('title', 'Riwayat')

@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        @if (session('success'))
            <div class="alert-dismissible fade show alert alert-success">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert-danger alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="alert alert-primary alert-dismissible fade show col-md-6" role="alert">
            <h5 class="text-primary">Informasi</h5>
            <ul>
                <li>
                    <p>
                        Setelah pengajuan surat Anda disetujui, <strong>
                            silakan datang ke Kantor Desa
                        </strong>
                        untuk mengambil surat yang telah
                        diberi stempel basah.

                    </p>
                </li>
                <li>
                    Pastikan <strong>
                        membawa bukti pengajuan surat
                    </strong>
                    untuk ditunjukkan kepada petugas di Kantor Desa.
                </li>
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Riwayat Pengajuan Surat</h5>
                {{-- todo: filter by jenis surat and status --}}
            </div>
            <div class="table-responsive text-nowrap">
                <table class="table-bordered table-striped table">
                    <thead>
                        <tr>
                            <th>Jenis Surat</th>
                            <th>Tanggal Pengajuan</th>
                            <th>Tanggal Disetujui</th>
                            <th>Status</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- @php
                            $hasCourses = false; 
                        @endphp --}}

                        @foreach ($histories as $history)
                            @if (Auth::user()->id == $history->user_id)
                                @php
                                    // $hasCourses = true;
                                @endphp
                                <tr>
                                    <td>{{ $history->jenis_surat ?? '-' }}</td>
                                    <td>
                                        @if ($history->tanggal_pengajuan)
                                            {{ \Carbon\Carbon::parse($history->tanggal_pengajuan)->translatedFormat('d F Y H:i') }}
                                            WIB
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @if ($history->tanggal_disetujui)
                                            {{ \Carbon\Carbon::parse($history->tanggal_disetujui)->translatedFormat('d F Y H:i') }}
                                            WIB
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @if ($history->status === 'MENUNGGU')
                                            <span class="badge bg-warning">Menunggu</span>
                                        @elseif ($history->status === 'DISETUJUI')
                                            <span class="badge bg-success">Disetujui</span>
                                        @elseif ($history->status === 'DITOLAK')
                                            <span class="badge bg-danger">Ditolak</span>
                                        @elseif ($history->status === 'DIBATALKAN')
                                            <span class="badge bg-secondary">Dibatalkan</span>
                                        @else
                                            "-"
                                        @endif
                                    <td>{{ $history->keterangan ?? '-' }}</td>
                                    <td><a href="{{ route('pengguna.detail.riwayat', $history->id) }}"
                                            class="btn btn-primary btn-sm">Detail</a></td>
                                </tr>
                            @endif
                        @endforeach

                        @if ($histories->isEmpty())
                            <tr>
                                <td colspan="6" class="text-center">Belum ada pengajuan surat</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($histories instanceof \Illuminate\Pagination\LengthAwarePaginator && $histories->hasPages())
                <div class="d-flex justify-content-between align-items-center mx-4 mt-2">
                    <div>
                        <p class="mb-0">
                            Menampilkan <strong>{{ $histories->count() }}</strong> dari total
                            <strong>{{ $histories->total() }}</strong> data.
                        </p>
                    </div>
                    <div>
                        {{ $histories->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
