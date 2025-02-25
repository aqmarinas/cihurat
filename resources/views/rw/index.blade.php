@extends('partials.layouts.app')

@section('title', 'Data Ketua RW')

@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="alert alert-primary alert-dismissible fade show col-md-9" role="alert">
            <h5 class="text-primary mb-2">Informasi</h5>
            <li>Ketua RW tidak memiliki akses untuk mengelola surat.</li>
            <li>Ketua RW hanya dapat mendaftarkan akun sebagai warga biasa.</li>
            <li>Namun, admin wajib menambahkan data Ketua RW agar namanya tercantum di bagian tanda tangan surat. Jika
                tidak, maka bagian tersebut akan kosong.</li>
            <li>Jika terjadi pergantian ketua RW, admin wajib mengubah data ketua RW.</li>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>

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

        @if ($errors->any())
            <div class="alert-danger alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
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
                                        <i class="bx bx-edit-alt me-1"></i> Ubah
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

    <!-- Modal for Editing RW -->
    <div class="modal fade" id="editDataModal" tabindex="-1" aria-labelledby="editDataModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editDataModalLabel">Ubah Ketua RW</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('rw.update', ':id') }}" method="post" id="editDataForm">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label" for="edit-nama">Nama Ketua RW</label>
                            <input type="text" name="nama" class="form-control" id="edit-nama"
                                placeholder="Nama Ketua RW" required />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="edit-rw">RT/RW</label>
                            <select name="rw" class="form-control" id="edit-rw" required>
                                <option value="" selected disabled {{ old('rw') == null ? 'selected' : '' }}>Pilih RW
                                </option>
                                <option value="01" {{ old('rw') == '01' ? 'selected' : '' }}>01</option>
                                <option value="02" {{ old('rw') == '02' ? 'selected' : '' }}>02</option>
                                <option value="03" {{ old('rw') == '03' ? 'selected' : '' }}>03</option>
                                <option value="04" {{ old('rw') == '04' ? 'selected' : '' }}>04</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="edit-no_whatsapp">Nomor WhatsApp</label>
                            <input type="text" name="no_whatsapp" class="form-control" id="edit-no_whatsapp"
                                placeholder="Nomor WhatsApp" required inputmode="numeric" maxlength="15" />
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
