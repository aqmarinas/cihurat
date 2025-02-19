@extends('partials.layouts.app')

@section('title', 'Ubah Profil')

@section('container')
    <style>
        .card {
            max-width: 80rem;
            margin: 0;
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
                    <h5 class="mb-0">Ubah Profil</h5>
                </div>
                <div class="card-body">
                    <form id="profileForm" action="{{ route('update.profile') }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                {{-- Nama --}}
                                <div class="mb-3">
                                    <label class="form-label" for="nama">Nama Lengkap</label>
                                    <input type="text" name="nama" class="form-control" id="nama"
                                        value="{{ $user->nama }}" />
                                </div>
                                {{-- Email --}}
                                <div class="mb-3">
                                    <label class="form-label" for="email">Email</label>
                                    <input type="email" name="email" class="form-control" id="email"
                                        value="{{ $user->email }}" />
                                </div>
                                {{-- NIK --}}
                                <div class="mb-3">
                                    <label class="form-label" for="nik">Nomor Induk Kependudukan (NIK)</label>
                                    <input type="text" name="nik" class="form-control" id="nik"
                                        inputmode="numeric" maxlength="16" value="{{ $user->nik }}" />
                                </div>
                                {{-- Nomor WhatsApp --}}
                                <div class="mb-3">
                                    <label class="form-label" for="nomor_whatsapp">Nomor WhatsApp</label>
                                    <input type="text" name="nomor_whatsapp" class="form-control" id="nomor_whatsapp"
                                        value="{{ $user->nomor_whatsapp }}" />
                                </div>
                            </div>

                            <!-- Column 2 -->
                            <div class="col-md-6">
                                {{-- Alamat --}}
                                <div class="mb-3">
                                    <label class="form-label" for="alamat">Alamat</label>
                                    <input type="text" name="alamat" class="form-control" id="alamat"
                                        value="{{ $user->alamat }}" />
                                </div>
                                {{-- RT/RW --}}
                                <div class="mb-3">
                                    <label class="form-label" for="rt_rw">RT/RW</label>
                                    <select name="rt_rw" class="form-control" id="rt_rw">
                                        <option value="" selected disabled>Pilih RT/RW</option>
                                        <option value="01/01" {{ $user->rt_rw == '01/01' ? 'selected' : '' }}>01/01
                                        </option>
                                        <option value="02/01" {{ $user->rt_rw == '02/01' ? 'selected' : '' }}>02/01
                                        </option>
                                        <option value="03/02" {{ $user->rt_rw == '03/02' ? 'selected' : '' }}>03/02
                                        </option>
                                        <option value="04/02" {{ $user->rt_rw == '04/02' ? 'selected' : '' }}>04/02
                                        </option>
                                        <option value="05/03" {{ $user->rt_rw == '05/03' ? 'selected' : '' }}>05/03
                                        </option>
                                        <option value="06/03" {{ $user->rt_rw == '06/03' ? 'selected' : '' }}>06/03
                                        </option>
                                        <option value="07/04" {{ $user->rt_rw == '07/04' ? 'selected' : '' }}>07/04
                                        </option>
                                        <option value="08/04" {{ $user->rt_rw == '08/04' ? 'selected' : '' }}>08/04
                                        </option>
                                    </select>
                                </div>
                                {{-- New Password --}}
                                <div class="mb-3">
                                    <label class="form-label" for="password">Password Baru</label>
                                    <input type="password" name="password" class="form-control" id="password" />
                                </div>
                                <div class="error-message" id="passwordError"></div>
                                {{-- Confirm New Password --}}
                                <div class="mb-3">
                                    <label class="form-label" for="password_confirmation">Konfirmasi Password</label>
                                    <input type="password" name="password_confirmation" class="form-control"
                                        id="password_confirmation" />
                                </div>
                                <div class="error-message" id="passwordConfirmationError"></div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary" id="saveButton">Ubah</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
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

            // Tambahkan event listener untuk konfirmasi password
            passwordConfirmationInput.addEventListener('input', validatePassword);
        });
    </script>
@endsection
