@extends('partials.layouts.app')

@section('title', 'Data Pengguna')

@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Button to Open the Modal -->
        {{-- <div class="d-flex justify-content-start mb-3">
            <a href="{{ route('rt.create') }}" class="btn btn-primary">Tambah Data</a>
        </div> --}}

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
            <div class="row mx-3 my-4">
                <div class="col-md-6">
                    <h5>Data Pengguna</h5>
                </div>
                <div class="col-md-6">
                    <form method="GET" action="{{ route('admin.kelola.pengguna') }}" class="d-flex">
                        <input type="text" name="search" class="form-control me-2" value="{{ request('search') }}"
                            placeholder="Cari nama..." />
                        <button type="submit" class="btn btn-primary">Cari</button>
                    </form>
                </div>
            </div>
            <div class="table-responsive text-nowrap">
                <table class="table-bordered table-striped table">
                    <thead>
                        <tr>
                            <th>Nomor</th>
                            <th>Nama</th>
                            <th>NIK</th>
                            <th>Email</th>
                            <th>Nomor WhatsApp</th>
                            <th>RT/RW</th>
                            <th>Alamat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $index => $user)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td><strong>{{ $user->nama ?? '-' }}</strong></td>
                                <td>{{ $user->nik ?? '-' }}</td>
                                <td>{{ $user->email ?? '-' }}</td>
                                <td>{{ $user->nomor_whatsapp ?? '-' }}</td>
                                <td>{{ $user->rt_rw ?? '-' }}</td>
                                <td>{{ Str::limit($user->alamat ?? '-', 30, '...') }}</td>
                                <td>
                                    <!-- Tombol Edit -->
                                    <a href="{{ route('admin.edit.pengguna', $user->id) }}"
                                        class="btn btn-primary btn-sm btn-edit me-2">
                                        <i class="bx bx-edit-alt me-1"></i> Ubah
                                    </a>
                                    {{-- <!-- Tombol Hapus -->
                                    <form id="delete-form-{{ $user->id }}"
                                        action="{{ route('rt.destroy', $user->id) }}" method="POST"
                                        style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm"
                                            onclick="confirmDelete('{{ $user->id }}')">
                                            <i class="bx bx-trash me-1"></i> Delete
                                        </button>
                                    </form> --}}
                                </td>
                            </tr>
                        @endforeach

                        @if ($users->isEmpty())
                            <tr>
                                <td colspan="8" class="text-center">Tidak ada data yang tersedia</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($users instanceof \Illuminate\Pagination\LengthAwarePaginator && $users->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $users->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
