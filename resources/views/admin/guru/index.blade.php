@extends('admin.layouts.app')

@section('title', 'Daftar Guru')

@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Button to Add Admin -->
        <div class="d-flex justify-content-start mb-3">
            <a href="{{ route('guru.create') }}" type="button" class="btn btn-success">
                Tambah Admin
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
                <h5 class="mb-0">Daftar Guru</h5>
                <div class="col-auto">
                    <input type="text" id="searchInput" class="form-control" style="width: 250px;" placeholder="Cari Guru...">
                </div>
            </div>
            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nama Admin</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Options</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @if ($gurus->isEmpty())
                            <tr>
                                <td colspan="4" class="text-center">No data available</td>
                            </tr>
                        @else
                            @foreach ($gurus as $guru)
                                <tr>
                                    <td>{{ $guru->name }}</td>
                                    <td>{{ $guru->email }}</td>
                                    <td>{{ ucfirst($guru->role) }}</td>
                                    <td>
                                        <!-- Tombol Hapus -->
                                        <form id="delete-form-{{ $guru->id }}"
                                            action="{{ route('guru.destroy', $guru->id) }}" method="POST"
                                            style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn-danger btn btn-sm"
                                                onclick="confirmDelete('{{ $guru->id }}')">
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
            {{-- @if ($gurus instanceof \Illuminate\Pagination\LengthAwarePaginator && $gurus->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $gurus->links() }}
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
                    notFoundMessage.textContent = 'No matching data found';
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
