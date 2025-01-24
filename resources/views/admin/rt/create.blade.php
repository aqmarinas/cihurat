@extends('admin.layouts.app')

@section('title', 'Tambah Akun Ketua RT')

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
                    <h5 class="mb-0">Tambah Akun Ketua RT</h5>
                </div>
                <div class="card-body">
                    <form id="userForm" action="{{ route('register.rt.submit') }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label" for="nama">Nama Lengkap Ketua RT <span
                                    style="color: red">*</span></label>
                            <input type="text" name="nama" class="form-control" id="nama" required
                                value="{{ old('nama') }}" />
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="email">Email <span style="color: red">*</span></label>
                            <input type="email" name="email" class="form-control" id="email" required
                                value="{{ old('email') }}" />
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="nomor_whatsapp">Nomor Whatsapp <span
                                    style="color: red">*</span></label>
                            <input type="text" name="nomor_whatsapp" class="form-control" id="nomor_whatsapp" required
                                value="{{ old('nomor_whatsapp') }}" />
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="rt_rw">RT/RW <span style="color: red">*</span></label>
                            <select name="rt_rw" class="form-control" id="rt_rw" required>
                                <option value="" selected disabled {{ old('rt_rw') == null ? 'selected' : '' }}>Pilih
                                    RT/RW</option>
                                <option value="01/01">01/01</option>
                                <option value="02/01">02/01</option>
                                <option value="03/02">03/02</option>
                                <option value="04/02">04/02</option>
                                <option value="05/03">05/03</option>
                                <option value="06/03">06/03</option>
                                <option value="07/04">07/04</option>
                                <option value="08/04">08/04</option>
                                {{-- @foreach ($dataRtRw as $rtRw)
                                    <option value="{{ $rtRw->kode }}" {{ old('rt_rw') == $rtRw->kode ? 'selected' : '' }}>
                                        {{ $rtRw->nama }}
                                    </option>
                                @endforeach --}}
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

                        <input type="hidden" name="role" value="rt">

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
