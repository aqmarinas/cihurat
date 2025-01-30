@extends('admin.layouts.app')

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
                                    <a href="javascript:void(0);" class="btn btn-primary btn-sm btn-edit me-2"
                                        data-id="{{ $rtList->id }}" data-rt_rw="{{ $rtList->rt_rw }}"
                                        data-nama="{{ $rtList->nama }}" data-nomor_whatsapp="{{ $rtList->nomor_whatsapp }}"
                                        data-email="{{ $rtList->email }}">
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

    <!-- Modal for Editing RT -->
    <div class="modal fade" id="editDataModal" tabindex="-1" aria-labelledby="editDataModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editDataModalLabel">Ubah RT</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('rt.update', ':id') }}" method="post" id="editDataForm">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label" for="edit-nama">Nama Ketua RT <span
                                    style="color: red">*</span></label>
                            <input type="text" name="nama" class="form-control" id="edit-nama"
                                placeholder="Nama Ketua RT" required />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="edit-rt_rw">RT/RW <span style="color: red">*</span></label>
                            <select name="rt_rw" class="form-control" id="edit-rt_rw" required>
                                <option value="" selected disabled>Pilih RT/RW</option>
                                <option value="01/01">01/01</option>
                                <option value="02/01">02/01</option>
                                <option value="03/02">03/02</option>
                                <option value="04/02">04/02</option>
                                <option value="05/03">05/03</option>
                                <option value="06/03">06/03</option>
                                <option value="07/04">07/04</option>
                                <option value="08/04">08/04</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="edit-nomor_whatsapp">Nomor WhatsApp <span
                                    style="color: red">*</span></label>
                            <input type="text" name="nomor_whatsapp" class="form-control" id="edit-nomor_whatsapp"
                                placeholder="Nomor WhatsApp" required />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="edit-email">Email <span style="color: red">*</span></label>
                            <input type="email" name="email" class="form-control" id="edit-email" placeholder="Email"
                                required />
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
                const rtRwId = this.getAttribute('data-id');
                const rtRw = this.getAttribute('data-rt_rw');
                const namaKetua = this.getAttribute('data-nama');
                const nomorWhatsApp = this.getAttribute('data-nomor_whatsapp');
                const email = this.getAttribute('data-email');

                const form = document.getElementById('editDataForm');
                form.action = form.action.replace(':id', rtRwId);


                document.getElementById('edit-nama').value = namaKetua;
                document.getElementById('edit-nomor_whatsapp').value = nomorWhatsApp;
                document.getElementById('edit-email').value = email;

                const selectRtRw = document.getElementById('edit-rt_rw');
                for (let option of selectRtRw.options) {
                    if (option.value === rtRw) {
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
