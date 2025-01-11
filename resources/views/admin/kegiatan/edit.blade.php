@extends('admin.layouts.app')

@section('title', 'Edit Kegiatan')

@section('container')
    {{-- <p>Tambah Kegiatan</p> --}}
    <style>
        /* Container untuk gambar preview */
        .preview-container {
            display: flex;
            justify-content: center;
            /* Mengatur gambar ke tengah secara horizontal */
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
                    <h5 class="mb-0">Tambah Kegiatan</h5>
                </div>
                <div class="card-body">
                    <form id="kegiatanForm" action="{{ route('kegiatan.update', $kegiatan->id) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT') <!-- Ini penting untuk update data -->
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-gambar">Gambar Kegiatan <span
                                    style="color: red">*</span></label>
                            <input type="file" name="gambar_kegiatan" class="form-control" id="basic-default-gambar"
                                accept="image/*" />
                            <div id="gambarError" class="text-danger" style="display: none;">Please upload an image (max 10
                                MB).</div>

                            <!-- Tambahkan Preview Gambar di sini -->
                            <div class="preview-container">
                                <img id="gambarPreview" src="{{ asset('storage/' . $kegiatan->gambar_kegiatan) }}"
                                    alt="Preview Gambar" style="display: block; width: 250px; margin-top: 10px;" />
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="desc">Deskripsi Kegiatan<span
                                    style="color: red">*</span></label>
                            <textarea name="deskripsi_kegiatan" id="desc" class="form-control" cols="30" rows="5" required>{{ $kegiatan->deskripsi_kegiatan }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="waktu">Tahun Kegiatan<span style="color: red">*</span></label>
                            <input type="text" name="waktu" class="form-control" id="waktu"
                                value="{{ $kegiatan->waktu }}" required />
                            <div id="waktuError" class="text-danger" style="display: none;">Waktu harus 4 digit angka.</div>
                        </div>

                        <button type="submit" class="btn btn-primary" id="saveButton">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript untuk validasi realtime -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('kegiatanForm');
            const gambarInput = document.getElementById('basic-default-gambar');
            const gambarPreview = document.getElementById('gambarPreview');
            const saveButton = document.getElementById('saveButton');
            const gambarError = document.getElementById('gambarError');
            const waktuInput = document.getElementById('waktu');
            const waktuError = document.getElementById('waktuError');

            const validImageTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg', 'image/svg+xml'];

            // Fungsi untuk preview gambar
            gambarInput.addEventListener('change', function() {
                const file = gambarInput.files[0];

                if (file) {
                    if (!validImageTypes.includes(file.type) || file.size > 10485760) {
                        gambarError.style.display = 'block';
                        gambarPreview.style.display = 'none'; // Sembunyikan gambar jika tidak valid
                    } else {
                        gambarError.style.display = 'none';

                        // Preview gambar
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            gambarPreview.src = e.target.result;
                            gambarPreview.style.display = 'block'; // Tampilkan preview gambar
                        };
                        reader.readAsDataURL(file);
                    }
                }
                checkFormValidity(); // Periksa validitas form setelah memuat gambar
            });

            // Fungsi untuk memeriksa validitas seluruh form (gambar dan waktu)
            function checkFormValidity() {
                const file = gambarInput.files[0];
                const waktuValue = waktuInput.value;
                const isWaktuValid = /^\d{4}$/.test(waktuValue);

                // Jika tidak ada file yang baru diupload (berarti gambar tetap) atau file valid, serta waktu valid, enable tombol
                if ((!file || (file && validImageTypes.includes(file.type) && file.size <= 10485760)) &&
                    isWaktuValid) {
                    saveButton.disabled = false; // Enable tombol save jika semua valid
                } else {
                    saveButton.disabled = true; // Disable tombol save jika ada yang tidak valid
                }
            }

            // Validasi real-time untuk input waktu (4 digit angka)
            waktuInput.addEventListener('input', function() {
                const waktuValue = waktuInput.value;

                if (/^\d{4}$/.test(waktuValue)) {
                    waktuError.style.display = 'none';
                    checkFormValidity();
                } else {
                    waktuError.style.display = 'block';
                    saveButton.disabled = true;
                }
            });
        });
    </script>
@endsection
