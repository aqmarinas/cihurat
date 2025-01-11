@extends('admin.layouts.app')

@section('title', 'Edit Konten')

@section('container')
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
                    <h5 class="mb-0">Edit Konten</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('content.update', $content->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-course">Course <span
                                    style="color: red">*</span></label>
                            <select name="course_id" class="form-select" id="basic-default-course" required>
                                <option value="">Select a course</option>
                                @foreach ($courses as $course)
                                    <option value="{{ $course->id }}"
                                        {{ $course->id == $content->course_id ? 'selected' : '' }}>
                                        {{ $course->judul }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-pertemuan">Pertemuan ke-<span
                                    style="color: red">*</span></label>
                            <input type="number" name="pertemuan" class="form-control" id="basic-default-pertemuan"
                                value="{{ old('pertemuan', $content->pertemuan) }}" required />
                            <div id="pertemuan-error" style="color: red; display: none;">Pertemuan harus angka positif (min.
                                1).</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="desc">Deskripsi <span style="color: red">*</span></label>
                            <textarea name="deskripsi_konten" id="desc" class="form-control" cols="30" rows="5" required>{{ old('deskripsi_konten', $content->deskripsi_konten) }}</textarea>
                        </div>

                        <!-- Existing Files Section -->
                        <div class="mb-3">
                            <label class="form-label">File Saat Ini</label>
                            <div id="existing-files" class="mb-3">
                                @php
                                    // Decode the JSON stored in 'file_paths' to get an array of file paths
                                    $filePaths = json_decode($content->file_paths, true) ?? [];
                                @endphp

                                @foreach ($filePaths as $filePath)
                                    @php
                                        // Extract the file name from the file path
                                        $fileName = basename($filePath);
                                    @endphp
                                    <span class="badge bg-primary file-badge" style="margin: 5px 5px 5px 5px;">
                                        {{ $fileName }} <!-- Display the file name -->
                                        <button type="button" class="btn btn-sm btn-danger delete-existing-file"
                                            data-file-path="{{ $filePath }}" style="margin-left: 5px;">
                                            &times;
                                        </button>
                                    </span>
                                @endforeach
                            </div>
                        </div>

                        <!-- New Files Upload Section -->
                        <div class="mb-3">
                            <label class="form-label">Upload File Baru (Max 4 file)</label>
                            <div class="upload-file-container">
                                <div class="upload-area">
                                    <input type="file" id="files" name="files[]" multiple style="display: none;"
                                        accept=".jpeg,.jpg,.png,.pdf,.ppt,.pptx,.mp4">
                                    <label for="files" class="upload-label">
                                        <div class="upload-icon">
                                            <i class="bx bx-cloud-upload"></i>
                                        </div>
                                        <span>Click To Upload New Files</span>
                                    </label>
                                </div>
                                <div id="file-list" class="file-list"></div>
                                <div id="fileError" style="display:none; color:red;">File size exceeds 20MB or invalid file
                                    type.</div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary" id="saveButton">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        .file-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        .file-name {
            flex-grow: 1;
            margin-right: 10px;
        }

        .file-actions {
            display: flex;
            gap: 5px;
        }

        .upload-area {
            border: 2px dashed #007bff;
            padding: 20px;
            text-align: center;
            cursor: pointer;
            margin-bottom: 15px;
        }

        .upload-label {
            cursor: pointer;
            color: #007bff;
        }
    </style>

    <script>
        // Validasi input pertemuan
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

        // Handle existing file deletion
        document.querySelectorAll('.delete-existing-file').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const filePath = this.getAttribute('data-file-path'); // Get the file path

                // SweetAlert confirmation
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "File ini akan dihapus!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus file!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // AJAX request to delete the file from the database
                        fetch('{{ route('content.delete-file') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({
                                    file_path: filePath,
                                    content_id: {{ $content->id }} // Pass the content ID to the server
                                })
                            }).then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    // Remove file from the DOM
                                    e.target.closest('.file-badge').remove();

                                    // SweetAlert success message
                                    Swal.fire(
                                        'Terhapus!',
                                        'File telah berhasil dihapus.',
                                        'success'
                                    );
                                } else {
                                    Swal.fire(
                                        'Error!',
                                        'Gagal menghapus file.',
                                        'error'
                                    );
                                }
                            });
                    }
                });
            });
        });

        // File upload handling
        const inputFile = document.getElementById('files');
        const fileListContainer = document.getElementById('file-list');
        const fileError = document.getElementById('fileError');
        const maxFileSize = 20 * 1024 * 1024; // 20MB
        const maxFiles = 4;
        const allowedTypes = [
            'image/jpeg',
            'image/png',
            'application/pdf',
            'application/vnd.ms-powerpoint',
            'application/vnd.openxmlformats-officedocument.presentationml.presentation',
            'video/mp4'
        ];

        let selectedFiles = new Set();

        // Handle new file selection
        inputFile.addEventListener('change', function(e) {
            const existingFilesCount = document.querySelectorAll('#existing-files .file-badge').length;
            const newFiles = Array.from(e.target.files);

            // Check total files limit (existing + new should not exceed maxFiles)
            if ((existingFilesCount + selectedFiles.size + newFiles.length) > maxFiles) {
                // Menggunakan SweetAlert untuk peringatan
                Swal.fire({
                    icon: 'error',
                    title: 'Maksimum File Tercapai',
                    text: `Anda sudah memiliki ${existingFilesCount} file. Total file tidak boleh melebihi ${maxFiles}.`,
                });
                e.target.value = ''; // Reset file input
                return;
            }

            // Validate each new file
            let hasError = false;
            newFiles.forEach(file => {
                if (file.size > maxFileSize || !allowedTypes.includes(file.type)) {
                    hasError = true;
                } else {
                    selectedFiles.add(file);
                }
            });

            if (hasError) {
                fileError.style.display = 'block';
            } else {
                fileError.style.display = 'none';
            }

            updateFileList();
        });

        // Update file list display
        function updateFileList() {
            fileListContainer.innerHTML = '';

            selectedFiles.forEach(file => {
                const fileItem = document.createElement('div');
                fileItem.classList.add('file-item');

                const fileName = document.createElement('span');
                fileName.classList.add('file-name');
                fileName.textContent = file.name;

                const removeButton = document.createElement('button');
                removeButton.type = 'button';
                removeButton.classList.add('btn', 'btn-sm', 'btn-danger');
                removeButton.innerHTML = '<i class="bx bx-trash"></i> Remove';
                removeButton.onclick = () => removeNewFile(file);

                fileItem.appendChild(fileName);
                fileItem.appendChild(removeButton);
                fileListContainer.appendChild(fileItem);
            });
        }

        // Remove new file
        function removeNewFile(fileToRemove) {
            selectedFiles.delete(fileToRemove);
            updateFileList();
        }

        // Form submission validation
        document.querySelector('form').addEventListener('submit', function(e) {
            const existingFilesCount = document.querySelectorAll('#existing-files .file-badge').length;
            const newFilesCount = selectedFiles.size;

            if (existingFilesCount + newFilesCount === 0) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'File Diperlukan',
                    text: 'Minimal satu file harus diunggah.'
                });
            }
        });
    </script>
@endsection
