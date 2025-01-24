@extends('admin.layouts.app')

@section('title', 'Kelola Surat')

@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Kelola Surat</h5>
                <div class="col-auto">
                    <input type="text" id="searchInput" class="form-control" style="width: 250px;" placeholder="Cari nama...">
                </div>
            </div>
            <div class="">
                {{-- Filter by status --}}
                <div class="btn-group mx-4 pb-3" role="group" aria-label="Filter Status">
                    <a href="{{ route('admin.surat', ['status' => 'disetujui']) }}"
                        class="btn btn-outline-dark {{ request('status') === 'disetujui' ? 'active' : '' }}">
                        Disetujui
                    </a>
                    <a href="{{ route('admin.surat', ['status' => 'menunggu']) }}"
                        class="btn btn-outline-dark {{ request('status') === 'menunggu' ? 'active' : '' }}">
                        Menunggu
                    </a>
                    <a href="{{ route('admin.surat', ['status' => 'ditolak']) }}"
                        class="btn btn-outline-dark {{ request('status') === 'ditolak' ? 'active' : '' }}">
                        Ditolak
                    </a>
                    <a href="{{ route('admin.surat') }}"
                        class="btn btn-outline-dark {{ request('status') === null ? 'active' : '' }}">
                        Semua
                    </a>
                </div>
                {{-- Table --}}
                <div class="table-responsive text-nowrap">
                    <table class="table-bordered table-striped table">
                        <thead>
                            <tr>
                                <th>Tanggal Masuk</th>
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

                            @foreach ($allLeters as $letter)
                                {{-- @if (Auth::user()->id == $letter->user_id) --}}
                                @php
                                    // $hasCourses = true;
                                @endphp
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($letter->tanggal_pengajuan)->translatedFormat('d F Y') ?? '-' }}
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
                                        @if ($letter->status === 'DISETUJUI')
                                            <a href="{{ route('surat.download', $letter->id) }}"
                                                class="btn btn-success btn-sm">
                                                <i class="fas fa-download"></i> Unduh
                                            </a>
                                        @endif
                                    </td>
                                    </td>
                                </tr>
                                {{-- @endif --}}
                            @endforeach

                            @if ($allLeters->isEmpty())
                                <tr>
                                    <td colspan="6" class="text-center">No data available</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Pagination --}}
            @if ($allLeters instanceof \Illuminate\Pagination\LengthAwarePaginator && $allLeters->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $allLeters->links() }}
                </div>
            @endif
        </div>
        <script>
            // Tunggu sampai DOM sepenuhnya dimuat
            document.addEventListener('DOMContentLoaded', function() {
                // Ambil elemen input search dan tbody
                const searchInput = document.getElementById('searchInput');
                const tableBody = document.querySelector('tbody');
                const tableRows = tableBody.getElementsByTagName('tr');

                // Buat div untuk pesan "tidak ditemukan"
                const notFoundMessage = document.createElement('div');
                notFoundMessage.className = 'alert alert-info text-center mt-3';
                notFoundMessage.style.display = 'none';
                notFoundMessage.textContent = 'No matching allLeters found';
                document.querySelector('.table-responsive').after(notFoundMessage);

                // Fungsi untuk melakukan pencarian
                function performSearch() {
                    const searchTerm = searchInput.value.toLowerCase().trim();
                    let matchFound = false;

                    // Loop melalui setiap baris tabel
                    Array.from(tableRows).forEach(row => {
                        // Skip baris "No data available"
                        if (row.cells.length === 1 && row.cells[0].textContent.trim() === 'No data available') {
                            return;
                        }

                        // Ambil teks dari kolom judul dan deskripsi
                        const title = row.cells[1].textContent.toLowerCase();
                        const description = row.cells[2].textContent.toLowerCase();

                        // Cek apakah searchTerm ada dalam title atau description
                        if (title.includes(searchTerm) || description.includes(searchTerm)) {
                            row.style.display = ''; // Tampilkan baris
                            matchFound = true;
                        } else {
                            row.style.display = 'none'; // Sembunyikan baris
                        }
                    });

                    // Tampilkan/sembunyikan pesan "tidak ditemukan"
                    if (searchTerm && !matchFound) {
                        notFoundMessage.style.display = 'block';
                    } else {
                        notFoundMessage.style.display = 'none';
                    }
                }

                // Event listener untuk input search
                searchInput.addEventListener('input', performSearch);
            });
        </script>
    </div>

@endsection
