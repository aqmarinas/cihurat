@extends('admin.layouts.app')

@section('title', 'Cek Pengajuan Surat')

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

        <div class="card">
            <div class="row mx-3 my-4">
                <div class="col-md-6">
                    <h5>Verifikasi Pengajuan Surat</h5>
                </div>
                <div class="col-md-6">
                    <form method="GET" action="{{ route('verifikasi.index') }}" class="d-flex">
                        <input type="text" name="search" class="form-control me-2" value="{{ request('search') }}"
                            placeholder="Cari nama..." />
                        <button type="submit" class="btn btn-primary">Cari</button>
                    </form>
                </div>
            </div>
            <div class="">
                <div class="btn-group d-flex col-md-6 mx-4 flex-wrap pb-3 pr-4" role="group" aria-label="Filter Status">
                    <a href="{{ route('verifikasi.index', ['status' => 'menunggu']) }}"
                        class="btn btn-outline-dark flex-fill {{ strtoupper(request()->query('status')) == 'MENUNGGU' ? 'active' : '' }} mb-2">
                        Menunggu
                    </a>
                    <a href="{{ route('verifikasi.index', ['status' => 'disetujui']) }}"
                        class="btn btn-outline-dark flex-fill {{ strtoupper(request()->query('status')) == 'DISETUJUI' ? 'active' : '' }} mb-2">
                        Disetujui
                    </a>
                    <a href="{{ route('verifikasi.index', ['status' => 'ditolak']) }}"
                        class="btn btn-outline-dark flex-fill {{ strtoupper(request()->query('status')) == 'DITOLAK' ? 'active' : '' }} mb-2">
                        Ditolak
                    </a>
                    <a href="{{ route('verifikasi.index') }}"
                        class="btn btn-outline-dark flex-fill {{ request()->query('status') == null ? 'active' : '' }} mb-2">
                        Semua
                    </a>
                </div>

                {{-- Table --}}
                <div class="table-responsive text-nowrap">
                    <table class="table-bordered table-striped table">
                        <thead>
                            <tr>
                                <th>Tanggal Pengajuan</th>
                                <th>Nama</th>
                                <th>Jenis Surat</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- @php
                                $hasCourses = false; 
                            @endphp --}}

                            @foreach ($letters as $letter)
                                {{-- @if (Auth::user()->id == $letter->user_id) --}}
                                @php
                                    // $hasCourses = true;
                                @endphp
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($letter->tanggal_pengajuan)->translatedFormat('d F Y H:i') ?? '-' }}
                                        WIB
                                    </td>
                                    <td>{{ $letter->user->nama ?? '-' }}</td>
                                    <td>{{ $letter->jenis_surat ?? '-' }}</td>
                                    </td>
                                    <td>
                                        @if ($letter->status === 'MENUNGGU')
                                            <span class="badge bg-warning">Menunggu</span>
                                        @elseif ($letter->status === 'DISETUJUI')
                                            <span class="badge bg-success">Disetujui</span>
                                        @elseif ($letter->status === 'DITOLAK')
                                            <span class="badge bg-danger">Ditolak</span>
                                        @else
                                            "-"
                                        @endif
                                    <td>
                                        <a href="{{ route('verifikasi.show', $letter->id) }}"
                                            class="btn btn-primary btn-sm me-2">Detail</a>
                                    </td>
                                    </td>
                                </tr>
                                {{-- @endif --}}
                            @endforeach

                            @if ($letters->isEmpty())
                                <tr>
                                    <td colspan="6" class="text-center">Tidak ada data yang tersedia</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Pagination --}}
            @if ($letters instanceof \Illuminate\Pagination\LengthAwarePaginator && $letters->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $letters->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
