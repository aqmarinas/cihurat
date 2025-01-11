@extends('admin.layouts.app')

@section('title', 'Tambah Logo')

@section('container')
    <style>
        /* Container untuk gambar preview */
        .preview-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 10px;
        }

        /* Atur lebar gambar dan responsivitas */
        #gambarPreview {
            max-width: 100%;
            height: auto;
            width: 150px;
        }

        /* Style untuk pesan error */
        .text-danger {
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
                    <h5 class="mb-0">Tambah Logo</h5>
                </div>
                <div class="card-body">
                    <form id="logoForm" action="{{ route('logo.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label" for="nama_logo">Nama Logo<span style="color: red"> *</span></label>
                            <input type="text" name="nama_logo" id="nama_logo" class="form-control" placeholder="Masukkan nama logo" required />
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="gambar_logo">Gambar Logo (optional)</label>
                            <input type="file" name="gambar_logo" class="form-control" id="gambar_logo" accept="image/*" onchange="previewGambar()" />
                            <small id="fileSizeError" class="text-danger" style="display: none;">Ukuran file maksimal 5 MB.</small>
                        </div>

                        <!-- Preview Gambar -->
                        <div class="preview-container">
                            <img id="gambarPreview" src="#" alt="Gambar Logo Preview" style="display: none;" />
                        </div>

                        <button type="submit" class="btn btn-primary mt-3" id="saveButton" disabled>Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function previewGambar() {
            const file = document.getElementById('gambar_logo').files[0];
            const preview = document.getElementById('gambarPreview');
            const errorMessage = document.getElementById('fileSizeError');
            const saveButton = document.getElementById('saveButton');

            if (file) {
                // Validasi ukuran file (5MB = 5 * 1024 * 1024 bytes)
                if (file.size > 5 * 1024 * 1024) {
                    errorMessage.style.display = 'block';
                    preview.style.display = 'none'; // Sembunyikan gambar preview jika terlalu besar
                    saveButton.disabled = true; // Disable tombol save
                } else {
                    errorMessage.style.display = 'none'; // Sembunyikan pesan error
                    saveButton.disabled = false; // Enable tombol save

                    const reader = new FileReader();

                    reader.onload = function(e) {
                        preview.src = e.target.result;
                        preview.style.display = 'block'; // Tampilkan gambar setelah ada file
                    }

                    reader.readAsDataURL(file); // Membaca file gambar
                }
            } else {
                preview.style.display = 'none'; // Sembunyikan jika tidak ada gambar
                saveButton.disabled = false; // Enable tombol save
            }
        }
    </script>
@endsection
