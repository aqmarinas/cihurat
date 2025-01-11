@extends('admin.layouts.app')

@section('title', 'Pengajuan Surat')

@section('container')
    <style>
        .upload-file-container {
            text-align: center;
            margin-top: 20px;
        }

        .upload-area {
            border: 2px dashed #007bff;
            padding: 20px;
            cursor: pointer;
        }

        .upload-label {
            display: inline-block;
            color: #007bff;
        }

        .file-list {
            margin-top: 10px;
        }

        .file-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 5px;
            padding: 5px;
            background-color: #f1f1f1;
            border-radius: 5px;
        }

        .file-item .remove-file {
            cursor: pointer;
            color: red;
        }
    </style>
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="container">

            @if ($errors->any())
                <div class="alert-danger alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Formulir Pengajuan Surat [nama surat]</h5>
                </div>

                <div class="card-body">
                    <form action="{{ route('surat-domisili.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-nama_lengkap">Nama Lengkap<span style="color: red">
                                    *</span></label>
                            <input type="text" name="nama_lengkap" class="form-control" id="basic-default-nama_lengkap"
                                placeholder="Nama lengkap" required />
                            <div id="nama_lengkap-error" style="color: red; display: none;">Nama lengkap wajib diisi</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-nik">Nomor Induk Kependudukan (NIK)<span
                                    style="color: red"> *</span></label>
                            <input type="text" name="nik" class="form-control" id="basic-default-nik"
                                inputmode="numeric" placeholder="Nomor Induk Kependudukan (NIK)" required />
                            <div id="nik-error" style="color: red; display: none;">NIK wajib diisi dengan angka</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="alamat">Alamat Domisili Saat Ini <span style="color: red">
                                    *</span></label>
                            <textarea name="alamat" id="alamat" class="form-control" cols="30" rows="5" placeholder="Alamat Domisili"
                                required></textarea>
                        </div>
                        {{-- todo: select --}}
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-rt-rw">RT/RW
                                {{-- <span style="color: red">*</span> --}}
                            </label>
                            <input type="text" name="rt_rw" class="form-control" id="basic-default-rt_rw"
                                placeholder="RT/RW" />
                            <div id="rt_rw-error" style="color: red; display: none;">RT/RW wajib diisi</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-tempat_lahir">Tempat Lahir<span style="color: red">
                                    *</span></label>
                            <input type="text" name="tempat_lahir" class="form-control" id="basic-default-tempat_lahir"
                                placeholder="Tempat Lahir" required />
                            <div id="tempat_lahir-error" style="color: red; display: none;">Tempat lahir wajib diisi</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-tanggal_lahir">Tanggal Lahir<span
                                    style="color: red">
                                    *</span></label>
                            <input type="text" name="tanggal_lahir" class="form-control" id="basic-default-tanggal_lahir"
                                placeholder="Tanggal Lahir" required />
                            <div id="tanggal_lahir-error" style="color: red; display: none;">Tanggal lahir wajib diisi</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-pekerjaan">Pekerjaan<span style="color: red">
                                    *</span></label>
                            <input type="text" name="pekerjaan" class="form-control" id="basic-default-pekerjaan"
                                placeholder="Pekerjaan" required />
                            <div id="pekerjaan-error" style="color: red; display: none;">Pekerjaan wajib diisi</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-keperluan">Keperluan<span style="color: red">
                                    *</span></label>
                            <input type="text" name="keperluan" class="form-control" id="basic-default-keperluan"
                                placeholder="Keperluan" required />
                            <div id="keperluan-error" style="color: red; display: none;">Keperluan wajib diisi</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-no_whatsapp">Nomor WhatsApp <span
                                    style="color: red">
                                    *</span></label>
                            <input type="text" name="no_whatsapp" class="form-control" id="basic-default-no_whatsapp"
                                inputmode="numeric" placeholder="Nomor WhatsApp" required />
                            <div id="no_whatsapp-error" style="color: red; display: none;">Nomor WA wajib diisi dengan
                                angka
                            </div>
                        </div>

                        <div>
                            File KTP <span style="color: red"> *</span>
                        </div>
                        <div class="upload-file-container">
                            <div class="upload-area">
                                <input type="file" id="files" name="files[]" multiple style="display: none;">
                                <label for="files" class="upload-label">
                                    <div class="upload-icon">
                                        <i class="bx bx-cloud-upload"></i>
                                    </div>
                                    <span>Click To Upload</span>
                                </label>
                            </div>
                            <div id="file-list" class="file-list" style="margin: 10px 0px 10px 0px"></div>
                            <div id="fileError" style="display:none; color:red;">File size exceeds 20MB.</div>
                        </div>
                        <button type="submit" class="btn btn-primary" id="saveButton">Save</button> <!-- Tombol Save -->
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        const pertemuanInput = document.getElementById('basic-default-pertemuan');
        const errorDiv = document.getElementById('pertemuan-error');
        const saveButton = document.getElementById('saveButton');

        pertemuanInput.addEventListener('input', function() {
            const value = parseInt(pertemuanInput.value);
            if (isNaN(value) || value < 1) {
                errorDiv.style.display = 'block';
                saveButton.disabled = true;
            } else {
                errorDiv.style.display = 'none';
                saveButton.disabled = false;
            }
        });

        // Definisi variabel global
        const inputFile = document.getElementById('files');
        const fileListContainer = document.getElementById('file-list');
        const fileError = document.getElementById('fileError');
        const maxFileSize = 20 * 1024 * 1024; // 20MB// 10MB
        const maxFiles = 4; // Maksimal 4 file

        let selectedFiles = new Set(); // Menggunakan Set untuk menghindari duplikasi

        // Event listener untuk input file
        inputFile.addEventListener('change', function(e) {
            const newFiles = Array.from(e.target.files);

            // Validasi jumlah file
            if ((selectedFiles.size + newFiles.length) > maxFiles) {
                alert(`Maksimal ${maxFiles} file yang diperbolehkan`);
                return;
            }

            // Validasi ukuran file
            let hasOversizedFile = false;
            newFiles.forEach(file => {
                if (file.size > maxFileSize) {
                    hasOversizedFile = true;
                } else {
                    selectedFiles.add(file);
                }
            });

            if (hasOversizedFile) {
                fileError.style.display = 'block';
            } else {
                fileError.style.display = 'none';
            }

            updateFileList();
            updateFileInput();
        });

        // Fungsi untuk memperbarui tampilan daftar file
        function updateFileList() {
            fileListContainer.innerHTML = ''; // Bersihkan daftar file

            selectedFiles.forEach((file, index) => {
                const fileItem = document.createElement('div');
                fileItem.classList.add('file-item');

                const fileName = document.createElement('span');
                fileName.textContent = file.name;

                const removeButton = document.createElement('span');
                removeButton.classList.add('remove-file');
                removeButton.innerHTML = '&times;';
                removeButton.onclick = () => removeFile(file);

                fileItem.appendChild(fileName);
                fileItem.appendChild(removeButton);
                fileListContainer.appendChild(fileItem);
            });
        }

        // Fungsi untuk menghapus file
        function removeFile(fileToRemove) {
            selectedFiles.delete(fileToRemove);
            updateFileList();
            updateFileInput();
        }

        // Fungsi untuk memperbarui input file
        function updateFileInput() {
            const dt = new DataTransfer();
            selectedFiles.forEach(file => dt.items.add(file));
            inputFile.files = dt.files;
        }

        // Tambahkan validasi form
        const form = document.querySelector('form');
        form.addEventListener('submit', function(e) {
            if (selectedFiles.size === 0) {
                e.preventDefault();
                alert('Pilih setidaknya satu file');
            }
        });
    </script>
@endsection
