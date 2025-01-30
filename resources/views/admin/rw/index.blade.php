@extends('admin.layouts.app')

@section('title', 'Data Ketua RW')

@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Button to Open the Modal -->
        <div class="d-flex justify-content-start mb-3">
            <a href="{{ route('rw.create') }}" class="btn btn-primary">Tambah Data</a>
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
                <h5 class="mb-0">Data Ketua RW</h5>
            </div>
            <div class="table-responsive text-nowrap">
                <table class="table-bordered table-striped table">
                    <thead>
                        <tr>
                            <th>Nomor RW</th>
                            <th>Nama Ketua RW</th>
                            <th>Nomor WhatsApp</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rwLists as $rwList)
                            <tr>
                                <td><strong>{{ $rwList->rw }}</strong></td>
                                <td>{{ $rwList->nama }}</td>
                                <td>{{ $rwList->no_whatsapp }}</td>
                                <td>
                                    <!-- Tombol Edit -->
                                    <a href="javascript:void(0);" class="btn btn-primary btn-sm btn-edit me-2"
                                        data-id="{{ $rwList->id }}" data-rw="{{ $rwList->rw }}"
                                        data-nama="{{ $rwList->nama }}" data-no_whatsapp="{{ $rwList->no_whatsapp }}">
                                        <i class="bx bx-edit-alt me-1"></i> Edit
                                    </a>
                                    <!-- Tombol Hapus -->
                                    <form id="delete-form-{{ $rwList->id }}"
                                        action="{{ route('rw.destroy', $rwList->id) }}" method="POST"
                                        style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm"
                                            onclick="confirmDelete('{{ $rwList->id }}')">
                                            <i class="bx bx-trash me-1"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach

                        @if ($rwLists->isEmpty())
                            <tr>
                                <td colspan="5" class="text-center">Tidak ada data yang tersedia</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($rwLists instanceof \Illuminate\Pagination\LengthAwarePaginator && $rwLists->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $rwLists->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Modal for Editing Course -->
    <div class="modal fade" id="editDataModal" tabindex="-1" aria-labelledby="editDataModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editDataModalLabel">Ubah RW</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('rw.update', ':id') }}" method="post" id="editDataForm">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label" for="edit-nama">Nama Ketua RW <span
                                    style="color: red">*</span></label>
                            <input type="text" name="nama" class="form-control" id="edit-nama"
                                placeholder="Nama Ketua RW" required />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="edit-rw">RT/RW <span style="color: red">*</span></label>
                            <select name="rw" class="form-control" id="edit-rw" required>
                                <option value="" selected disabled>Pilih RW</option>
                                <option value="01">01</option>
                                <option value="02">02</option>
                                <option value="03">03</option>
                                <option value="04">04</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="edit-no_whatsapp">Nomor WhatsApp <span
                                    style="color: red">*</span></label>
                            <input type="text" name="no_whatsapp" class="form-control" id="edit-no_whatsapp"
                                placeholder="Nomor WhatsApp" required />
                        </div>
                        <button type="submit" class="btn btn-primary">Ubah</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Script for filling the edit modal
        document.querySelectorAll('.btn-edit').forEach(button => {
            button.addEventListener('click', function() {
                const rwId = this.getAttribute('data-id');
                const rw = this.getAttribute('data-rw');
                const namaKetua = this.getAttribute('data-nama');
                const nomorWhatsApp = this.getAttribute('data-no_whatsapp');

                const form = document.getElementById('editDataForm');
                form.action = form.action.replace(':id', rwId);

                document.getElementById('edit-nama').value = namaKetua;
                document.getElementById('edit-no_whatsapp').value = nomorWhatsApp;

                const selectRw = document.getElementById('edit-rw');
                for (let option of selectRw.options) {
                    if (option.value === rw) {
                        option.selected = true;
                        break;
                    }
                }

                var editModal = new bootstrap.Modal(document.getElementById('editDataModal'));
                editModal.show();
            });
        });

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
