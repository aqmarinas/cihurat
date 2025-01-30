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
                                <td>{{ $user->alamat ?? '-' }}</td>
                                <td>
                                    <!-- Tombol Edit -->
                                    <a href="javascript:void(0);" class="btn btn-primary btn-sm btn-edit me-2"
                                        data-id="{{ $user->id }}" data-rt_rw="{{ $user->rt_rw }}"
                                        data-nama_ketua="{{ $user->nama_ketua }}"
                                        data-nomor_whatsapp="{{ $user->nomor_whatsapp }}">
                                        <i class="bx bx-edit-alt me-1"></i> Edit
                                    </a>
                                    <!-- Tombol Hapus -->
                                    <form id="delete-form-{{ $user->id }}"
                                        action="{{ route('rt.destroy', $user->id) }}" method="POST"
                                        style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm"
                                            onclick="confirmDelete('{{ $user->id }}')">
                                            <i class="bx bx-trash me-1"></i> Delete
                                        </button>
                                    </form>
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

        <script>
            // Tunggu sampai DOM sepenuhnya dimuat
            document.addEventListener('DOMContentLoaded', function() {
                const searchInput = document.getElementById('searchInput');
                const tableBody = document.querySelector('tbody');
                const tableRows = tableBody.getElementsByTagName('tr');
                const notFoundMessage = document.createElement('div');
                notFoundMessage.className = 'alert alert-info text-center mt-3';
                notFoundMessage.style.display = 'none';
                notFoundMessage.textContent = 'No matching data found';
                document.querySelector('.table-responsive').after(notFoundMessage);

                function performSearch() {
                    const searchTerm = searchInput.value.toLowerCase().trim();
                    let matchFound = false;

                    Array.from(tableRows).forEach(row => {
                        if (row.cells.length === 1 && row.cells[0].textContent.trim() ===
                            'Tidak ada data yang tersedia') {
                            return;
                        }

                        const rtRw = row.cells[0].textContent.toLowerCase();
                        const namaKetua = row.cells[1].textContent.toLowerCase();
                        const nomorWhatsApp = row.cells[2].textContent.toLowerCase();

                        if (rtRw.includes(searchTerm) || namaKetua.includes(searchTerm) || nomorWhatsApp
                            .includes(searchTerm)) {
                            row.style.display = '';
                            matchFound = true;
                        } else {
                            row.style.display = 'none';
                        }
                    });

                    if (searchTerm && !matchFound) {
                        notFoundMessage.style.display = 'block';
                    } else {
                        notFoundMessage.style.display = 'none';
                    }
                }

                searchInput.addEventListener('input', performSearch);
            });
        </script>
    </div>

    <!-- Modal for Editing User -->
    <div class="modal fade" id="editDataModal" tabindex="-1" aria-labelledby="editDataModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editDataModalLabel">Edit RT/RW</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('rt.update', ':id') }}" method="post" id="editDataForm">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label" for="edit-rt_rw">RT/RW <span style="color: red">*</span></label>
                            <input type="text" name="rt_rw" class="form-control" id="edit-rt_rw" placeholder="01/01"
                                required />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="edit-nama_ketua">Nama Ketua RT <span
                                    style="color: red">*</span></label>
                            <input type="text" name="nama_ketua" class="form-control" id="edit-nama_ketua"
                                placeholder="Nama Ketua RT" required />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="edit-nomor_whatsapp">RT/RW <span
                                    style="color: red">*</span></label>
                            <input type="text" name="nomor_whatsapp" class="form-control" id="edit-nomor_whatsapp"
                                placeholder="081234567890" required />
                        </div>
                        <button type="submit" class="btn btn-primary">Edit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Script for filling the edit modal
        document.querySelectorAll('.btn-edit').forEach(button => {
            button.addEventListener('click', function() {
                const rtRwId = this.getAttribute('data-id');
                const rtRw = this.getAttribute('data-rt_rw');
                const namaKetua = this.getAttribute('data-nama_ketua');
                const nomorWhatsApp = this.getAttribute('data-nomor_whatsapp');

                // Replace URL in edit form action
                const form = document.getElementById('editDataForm');
                form.action = form.action.replace(':id', rtRwId);

                document.getElementById('edit-rt_rw').value = rtRw;
                document.getElementById('edit-nama_ketua').value = namaKetua;
                document.getElementById('edit-nomor_whatsapp').value = nomorWhatsApp;

                // Tampilkan modal
                var editModal = new bootstrap.Modal(document.getElementById('editDataModal'));
                editModal.show();
            });
        });

        function confirmDelete(id) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }
    </script>
@endsection
