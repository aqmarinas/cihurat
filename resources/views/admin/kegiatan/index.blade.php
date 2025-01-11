@extends('admin.layouts.app')

@section('title', 'Daftar Kegiatan')

@section('container')
    {{-- <p>Kegiatan</p> --}}
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Button to Open the Modal -->
        <div class="d-flex justify-content-start mb-3">
            <a href="{{ route('kegiatan.create') }}" type="button" class="btn btn-success">
                Tambah Data
            </a>
        </div>

        @if (session('success'))
            <div class="alert-dismissible fade show alert alert-success" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert-danger alert-dismissible fade show alert" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Daftar Kegiatan</h5>
                <div class="col-auto">
                    <input type="text" id="searchInput" class="form-control" style="width: 250px;" placeholder="Cari Kegiatan...">
                </div>
            </div>
            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Gambar Kegiatan</th>
                            <th>Deskripsi Kegiatan</th>
                            <th>Tahun Kegiatan</th>
                            <th>Options</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @if ($kegiatans->isEmpty())
                            <tr>
                                <td colspan="3" class="text-center">No data available</td>
                            </tr>
                        @else
                            @foreach ($kegiatans as $kegiatan)
                                <tr>
                                    <td>
                                        <!-- Menampilkan Thumbnail dengan ukuran 200x200 -->
                                        <img src="{{ asset('storage/' . $kegiatan->gambar_kegiatan) }}"
                                            alt="gambar kegiatan" style="width: 150px">
                                    </td>
                                    <td>{{ $kegiatan->deskripsi_kegiatan }}</td>
                                    <td>{{ $kegiatan->waktu }}</td>
                                    <td>
                                        <!-- Tombol Edit -->
                                        <a href="{{ route('kegiatan.edit', $kegiatan->id) }}"
                                            class="btn-edit btn btn-primary btn-sm me-2">
                                            <i class="bx bx-edit-alt me-1"></i> Edit
                                        </a>
                                        <!-- Tombol Hapus -->
                                        <form id="delete-form-{{ $kegiatan->id }}"
                                            action="{{ route('kegiatan.destroy', $kegiatan->id) }}" method="POST"
                                            style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn-danger btn btn-sm"
                                                onclick="confirmDelete('{{ $kegiatan->id }}')">
                                                <i class="bx bx-trash me-1"></i> Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
            {{-- @if ($kegiatans instanceof \Illuminate\Pagination\LengthAwarePaginator && $kegiatans->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $kegiatans->links() }}
                </div>
            @endif --}}
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
                    notFoundMessage.textContent = 'No matching courses found';
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
    </div>

    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }
    </script>
@endsection
