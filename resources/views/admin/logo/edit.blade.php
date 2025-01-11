@extends('admin.layouts.app')

@section('title', 'Edit Logo')

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
                    <h5 class="mb-0">Edit Logo</h5>
                </div>
                <div class="card-body">
                    <form id="logoForm" action="{{ route('logo.update', $logos->id) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT') <!-- Ini penting untuk update data -->

                        <!-- Input Nama Logo -->
                        <div class="mb-3">
                            <label class="form-label" for="nama_logo">Nama Logo <span style="color: red">*</span></label>
                            <input type="text" name="nama_logo" id="nama_logo" class="form-control" value="{{ $logos->nama_logo }}" required />
                        </div>

                        <!-- Input Gambar Logo -->
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-gambar">Gambar Logo (optional)</label>
                            <input type="file" name="gambar_logo" class="form-control" id="basic-default-gambar"
                                accept="image/*" />
                            <div id="gambarError" class="text-danger" style="display: none;">Please upload an image (max 5 MB).</div>

                            <!-- Preview Gambar -->
                            <div class="preview-container">
                                <img id="gambarPreview" src="{{ asset('uploads/logo/' . $logos->gambar_logo) }}"
                                    alt="Preview Gambar" style="display: block; width: 250px; margin-top: 10px;" />
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary" id="saveButton">Update Logo</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript untuk validasi realtime -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('logoForm');
            const gambarInput = document.getElementById('basic-default-gambar');
            const gambarPreview = document.getElementById('gambarPreview');
            const saveButton = document.getElementById('saveButton');
            const gambarError = document.getElementById('gambarError');

            const validImageTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg', 'image/svg+xml'];

            // Fungsi untuk preview gambar
            gambarInput.addEventListener('change', function() {
                const file = gambarInput.files[0];

                if (file) {
                    if (!validImageTypes.includes(file.type) || file.size > 5242880) {
                        gambarError.style.display = 'block';
                        gambarPreview.style.display = 'none'; // Sembunyikan gambar jika tidak valid
                        saveButton.disabled = true;
                    } else {
                        gambarError.style.display = 'none';

                        // Preview gambar
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            gambarPreview.src = e.target.result;
                            gambarPreview.style.display = 'block'; // Tampilkan preview gambar
                        };
                        reader.readAsDataURL(file);

                        saveButton.disabled = false; // Enable tombol save jika valid
                    }
                }
            });
        });
    </script>
@endsection
