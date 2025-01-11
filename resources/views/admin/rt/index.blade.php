@extends('admin.layouts.app')

@section('title', 'RT/RW Data')

@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Button to Open the Modal -->
        <div class="d-flex justify-content-start mb-3">
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addDataModal">
                Tambah Data
            </button>
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
                <h5 class="mb-0">Daftar RT/RW</h5>
                <div class="col-auto">
                    <input type="text" id="searchInput" class="form-control" style="width: 250px;"
                        placeholder="Cari RT/RW...">
                </div>
            </div>
            <div class="table-responsive text-nowrap">
                <table class="table-bordered table-striped table">
                    <thead>
                        <tr>
                            <th>Nomor RT/RW</th>
                            <th>Nama Ketua</th>
                            <th>Nomor WhatsApp</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rtRwLists as $rtRwList)
                            <tr>
                                <td><strong>{{ $rtRwList->rt_rw }}</strong></td>
                                <td>{{ $rtRwList->nama_ketua }}</td>
                                <td>{{ $rtRwList->nomor_whatsapp }}</td>
                                <td>
                                    <!-- Tombol Edit -->
                                    <a href="javascript:void(0);" class="btn btn-primary btn-sm btn-edit me-2"
                                        data-id="{{ $rtRwList->id }}" data-rt_rw="{{ $rtRwList->rt_rw }}"
                                        data-nama_ketua="{{ $rtRwList->nama_ketua }}"
                                        data-nomor_whatsapp="{{ $rtRwList->nomor_whatsapp }}">
                                        <i class="bx bx-edit-alt me-1"></i> Edit
                                    </a>
                                    <!-- Tombol Hapus -->
                                    <form id="delete-form-{{ $rtRwList->id }}"
                                        action="{{ route('rt-rw.destroy', $rtRwList->id) }}" method="POST"
                                        style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm"
                                            onclick="confirmDelete('{{ $rtRwList->id }}')">
                                            <i class="bx bx-trash me-1"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach

                        @if ($rtRwLists->isEmpty())
                            <tr>
                                <td colspan="4" class="text-center">No data available</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($rtRwLists instanceof \Illuminate\Pagination\LengthAwarePaginator && $rtRwLists->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $rtRwLists->links() }}
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
                        if (row.cells.length === 1 && row.cells[0].textContent.trim() === 'No data available') {
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

    <!-- Modal for Adding Data -->
    <div class="modal fade" id="addDataModal" tabindex="-1" aria-labelledby="addDataModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addDataModalLabel">Tambah Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('rt-rw.store') }}" method="post" id="addDataForm">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label" for="rt_rw">Nomor RT/RW <span style="color: red">*</span></label>
                            <input type="text" name="rt_rw" class="form-control" id="rt_rw" required
                                placeholder="01/01" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="nama_ketua">Nama Ketua <span style="color: red">*</span></label>
                            <input type="text" name="nama_ketua" class="form-control" id="nama_ketua" required
                                placeholder="Nama Ketua RT" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="nomor_whatsapp">Nomor WhatsApp <span
                                    style="color: red">*</span></label>
                            <input type="text" name="nomor_whatsapp" class="form-control" id="nomor_whatsapp" required
                                placeholder="081234567890" />
                        </div>

                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Editing Course -->
    <div class="modal fade" id="editDataModal" tabindex="-1" aria-labelledby="editDataModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editDataModalLabel">Edit RT/RW</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('rt-rw.update', ':id') }}" method="post" id="editDataForm">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label" for="edit-rt_rw">RT/RW <span style="color: red">*</span></label>
                            <input type="text" name="rt_rw" class="form-control" id="edit-rt_rw"
                                placeholder="01/01" required />
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

                // Isi field modal dengan data course
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
