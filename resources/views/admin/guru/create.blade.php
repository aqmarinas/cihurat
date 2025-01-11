@extends('admin.layouts.app')

@section('title', 'Tambah Guru')

@section('container')
    <style>
        .preview-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 10px;
        }

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
                    <h5 class="mb-0">Tambah Pengguna (Admin / Guru)</h5>
                </div>
                <div class="card-body">
                    <form id="userForm" action="{{ route('guru.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label" for="name">Nama Pengguna <span style="color: red">*</span></label>
                            <input type="text" name="name" class="form-control" id="name" required />
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="basic-default-gambar">Foto Profil</label>
                            <input type="file" name="foto_profil" class="form-control" id="basic-default-gambar"
                                accept="image/*" />
                            <div id="gambarError" class="text-danger" style="display: none;">Please upload an image (max 10
                                MB).</div>

                            <div class="preview-container">
                                <img id="gambarPreview" src="#" alt="Preview Gambar"
                                    style="display: none; width: 250px; margin-top: 10px;" />
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="email">Email <span style="color: red">*</span></label>
                            <input type="email" name="email" class="form-control" id="email" required />
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="role">Role <span style="color: red">*</span></label>
                            <select name="role" class="form-control" id="role" required>
                                <option disabled selected>Pilih Jabatan</option>
                                <option value="admin">Admin</option>
                                <option value="guru">Guru</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="password">Password <span style="color: red">*</span></label>
                            <input type="password" name="password" class="form-control" id="password" required />
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="password_confirmation">Konfirmasi Password <span
                                    style="color: red">*</span></label>
                            <input type="password" name="password_confirmation" class="form-control"
                                id="password_confirmation" required />
                            <div id="passwordError" class="text-danger" style="display: none;">Konfimasi password tidak
                                sesuai!</div>
                        </div>

                        <button type="submit" class="btn btn-primary" id="saveButton">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('userForm');
            const gambarInput = document.getElementById('basic-default-gambar');
            const gambarPreview = document.getElementById('gambarPreview');
            const saveButton = document.getElementById('saveButton');
            const password = document.getElementById('password');
            const passwordConfirmation = document.getElementById('password_confirmation');
            const passwordError = document.getElementById('passwordError');
            const gambarError = document.getElementById('gambarError');
            const validImageTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg', 'image/svg+xml'];

            // Validasi gambar
            gambarInput.addEventListener('change', function() {
                const file = gambarInput.files[0];

                if (file) {
                    if (!validImageTypes.includes(file.type) || file.size > 10485760) {
                        gambarError.style.display = 'block';
                        gambarPreview.style.display = 'none';
                        saveButton.disabled = true;
                    } else {
                        gambarError.style.display = 'none';

                        // Preview gambar
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            gambarPreview.src = e.target.result;
                            gambarPreview.style.display = 'block';
                        };
                        reader.readAsDataURL(file);

                        checkFormValidity(); // Periksa validitas form
                    }
                } else {
                    checkFormValidity(); // Jika tidak ada gambar, tetap lanjut validasi form
                }
            });

            // Fungsi untuk memeriksa kesesuaian password
            function validatePassword() {
                if (password.value !== passwordConfirmation.value) {
                    passwordError.style.display = 'block';
                    saveButton.disabled = true;
                } else {
                    passwordError.style.display = 'none';
                    checkFormValidity(); // Periksa validitas form secara keseluruhan
                }
            }

            // Validasi password ketika pengguna mengetik ulang password confirmation
            passwordConfirmation.addEventListener('input', validatePassword);

            // Fungsi untuk memeriksa validitas seluruh form (gambar dan password)
            function checkFormValidity() {
                const file = gambarInput.files[0];
                const isPasswordValid = password.value === passwordConfirmation.value;
                const isGambarValid = !file || (validImageTypes.includes(file.type) && file.size <=
                10485760); // Gambar opsional

                if (isPasswordValid && isGambarValid) {
                    saveButton.disabled = false; // Enable tombol save jika semua valid
                } else {
                    saveButton.disabled = true; // Disable tombol save jika ada yang tidak valid
                }
            }
        });
    </script>
@endsection
