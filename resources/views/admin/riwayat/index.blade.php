@extends('admin.layouts.app')

@section('title', 'Course')

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
                                <td colspan="6" class="text-center">No data available</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($histories instanceof \Illuminate\Pagination\LengthAwarePaginator && $histories->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $histories->links() }}
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
                notFoundMessage.textContent = 'No matching histories found';
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
