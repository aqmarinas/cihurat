@extends('partials.layouts.app')

@section('title', 'Data Ketua RT')

@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Button to Open the Modal -->
        <div class="d-flex justify-content-start mb-3">
            <a href="{{ route('rt.create') }}" class="btn btn-primary">Tambah Data</a>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Basic Bootstrap Table -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Data Ketua RT</h5>
            </div>
            <div class="table-responsive text-nowrap">
                <table class="table-bordered table-striped table">
                    <thead>
                        <tr>
                            <th>Nomor RT/RW</th>
                            <th>Nama Ketua RT</th>
                            <th>Email</th>
                            <th>Nomor WhatsApp</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rtLists as $rtList)
                            <tr>
                                <td><strong>{{ $rtList->rt_only ?? '-' }}</strong></td>
                                <td>{{ $rtList->nama ?? '-' }}</td>
                                <td>{{ $rtList->email ?? '-' }}</td>
                                <td>{{ $rtList->nomor_whatsapp ?? '-' }}</td>
                                <td>
                                    <!-- Tombol Edit -->
                                    <a href="{{ route('rt.edit', $rtList->id) }}"
                                        class="btn btn-primary btn-sm btn-edit me-2">
                                        <i class="bx bx-edit-alt me-1"></i> Ubah
                                    </a>
                                    <!-- Tombol Hapus -->
                                    <form id="delete-form-{{ $rtList->id }}"
                                        action="{{ route('rt.destroy', $rtList->id) }}" method="POST"
                                        style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm"
                                            onclick="confirmDelete('{{ $rtList->id }}')">
                                            <i class="bx bx-trash me-1"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach

                        @if ($rtLists->isEmpty())
                            <tr>
                                <td colspan="5" class="text-center">Tidak ada data yang tersedia</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($rtLists instanceof \Illuminate\Pagination\LengthAwarePaginator && $rtLists->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $rtLists->links() }}
                </div>
            @endif
        </div>
    </div>

    <script>
        function confirmDelete(id) {
            Swal.fire({
                text: 'Apakah Anda yakin untuk menghapus data ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3435',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya',
                cancelButtonText: 'Tidak'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }
    </script>
@endsection
