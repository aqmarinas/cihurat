@extends('admin.layouts.app')

@section('title', 'Edit Profil')

@section('container')
<style>
    /* Gaya untuk avatar */
    .avatar-profile {
        width: 100px; /* Lebar avatar */
        height: 100px; /* Tinggi avatar */
        border-radius: 50%; /* Membuat gambar menjadi bulat */
        object-fit: cover; /* Memastikan gambar tidak terdistorsi */
        margin: 10px auto; /* Mengatur margin untuk tengah */
        border: 2px solid #ddd; /* Border untuk avatar */
    }

    /* Container untuk gambar preview */
    .preview-container {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 10px;
    }

    /* Gaya untuk form */
    .card {
        max-width: 80rem; /* Ukuran maksimal form diperlebar */
        margin: 0; /* Menghilangkan margin auto */
    }

    /* Gaya untuk dua kolom */
    .form-row {
        display: flex;
        flex-wrap: wrap; /* Mengizinkan baris baru jika tidak muat */
        gap: 15px; /* Jarak antara kolom */
    }

    .form-column {
        flex: 1; /* Mengatur kolom agar sama lebar */
        min-width: 250px; /* Lebar minimal untuk kolom */
    }

    /* Gaya untuk pesan kesalahan */
    .error-message {
        color: red;
        font-size: 0.875em; /* Ukuran font untuk pesan kesalahan */
    }
</style>
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="container">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if (session('success'))
            <div class="alert-dismissible fade show alert alert-success">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="card mb-12">
            <div class="card-header">
                <h5 class="mb-0">Edit Profil</h5>
            </div>
            <div class="card-body">
                <!-- Tampilkan gambar profil sebagai avatar di atas input nama -->
                <div class="preview-container">
                    <img id="gambarPreview" src="{{ $admin->foto_profil ? asset('storage/' . $admin->foto_profil) : 'assets/img/avatars/1.png' }}" alt="Avatar" class="avatar-profile" />
                </div>

                <form id="profileForm" action="{{ route('update.profile') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label" for="name">Nama <span style="color: red">*</span></label>
                        <input type="text" name="name" class="form-control" id="name" value="{{ $admin->name }}" required />
                    </div>

                    <div class="form-row">
                        <div class="form-column">
                            <div class="mb-3">
                                <label class="form-label" for="email">Email <span style="color: red">*</span></label>
                                <input type="email" name="email" class="form-control" id="email" value="{{ $admin->email }}" required />
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="password">Password Baru (Opsional)</label>
                                <input type="password" name="password" class="form-control" id="password" />
                            </div>
                            <div class="error-message" id="passwordError"></div> <!-- Pesan kesalahan untuk password -->
                        </div>

                        <div class="form-column">
                            <div class="mb-3">
                                <label class="form-label" for="password_confirmation">Konfirmasi Password</label>
                                <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" />
                            </div>
                            <div class="error-message" id="passwordConfirmationError"></div> <!-- Pesan kesalahan untuk konfirmasi password -->
                            <div class="mb-3">
                                <label class="form-label" for="foto_profil">Foto Profil</label>
                                <input type="file" name="foto_profil" class="form-control" id="foto_profil" accept="image/*" />
                                <div class="error-message" id="fileError"></div> <!-- Pesan kesalahan untuk file -->
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary" id="saveButton">Perbarui Profil</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript untuk preview gambar dan validasi -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fotoProfilInput = document.getElementById('foto_profil');
        const gambarPreview = document.getElementById('gambarPreview');
        const passwordInput = document.getElementById('password');
        const passwordConfirmationInput = document.getElementById('password_confirmation');
        const saveButton = document.getElementById('saveButton');
        const passwordError = document.getElementById('passwordError');
        const passwordConfirmationError = document.getElementById('passwordConfirmationError');
        const fileError = document.getElementById('fileError');

        // Fungsi untuk preview gambar
        fotoProfilInput.addEventListener('change', function() {
            const file = fotoProfilInput.files[0];

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    gambarPreview.src = e.target.result;
                    gambarPreview.style.display = 'block'; // Tampilkan preview gambar
                };
                reader.readAsDataURL(file);
            }
            validateFile(file);
        });

        // Fungsi untuk memeriksa kesesuaian password
        function validatePassword() {
            const password = passwordInput.value;
            const passwordConfirmation = passwordConfirmationInput.value;

            if (password !== passwordConfirmation) {
                passwordConfirmationError.textContent = 'Konfirmasi password tidak cocok.';
                passwordConfirmationInput.classList.add('is-invalid'); // Tambahkan kelas untuk styling
                saveButton.disabled = true; // Nonaktifkan tombol simpan
            } else {
                passwordConfirmationError.textContent = ''; // Reset pesan kesalahan
                passwordConfirmationInput.classList.remove('is-invalid'); // Hapus kelas styling
                saveButton.disabled = false; // Aktifkan tombol simpan
            }
        }

        // Fungsi untuk memvalidasi file
        function validateFile(file) {
            const allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;
            const maxSize = 10 * 1024 * 1024; // 10 MB

            if (file) {
                if (!allowedExtensions.exec(file.name)) {
                    fileError.textContent = 'Format file harus JPG, JPEG, atau PNG.';
                    saveButton.disabled = true; // Nonaktifkan tombol simpan
                } else if (file.size > maxSize) {
                    fileError.textContent = 'Ukuran file tidak boleh lebih dari 10 MB.';
                    saveButton.disabled = true; // Nonaktifkan tombol simpan
                } else {
                    fileError.textContent = ''; // Reset pesan kesalahan
                    saveButton.disabled = false; // Aktifkan tombol simpan
                }
            } else {
                fileError.textContent = ''; // Reset pesan kesalahan
                saveButton.disabled = false; // Aktifkan tombol simpan
            }
        }

        // Tambahkan event listener untuk konfirmasi password
        passwordConfirmationInput.addEventListener('input', validatePassword);
    });
</script>
@endsection
