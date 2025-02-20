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
        {{-- <div class="container"> --}}
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
                <form id="profileForm" action="{{ route('profile.update') }}" method="post">
                    @csrf
                    @method('PATCH')
                    <div class="row">
                        <div class="col-md-6">
                            {{-- Nama --}}
                            <div class="mb-3">
                                <label class="form-label" for="nama">Nama Lengkap</label>
                                <input type="text" name="nama"
                                    class="@error('nama') is-invalid @enderror form-control" id="nama"
                                    value="{{ $user->nama }}" />
                            </div>
                            {{-- Email --}}
                            <div class="mb-3">
                                <label class="form-label" for="email">Email</label>
                                <input type="email" name="email"
                                    class="@error('email') is-invalid @enderror form-control" id="email"
                                    value="{{ $user->email }}" />
                            </div>
                            {{-- NIK --}}
                            <div class="mb-3">
                                <label class="form-label" for="nik">Nomor Induk Kependudukan (NIK)</label>
                                <input type="text" name="nik" class="@error('nik') is-invalid @enderror form-control"
                                    id="nik" inputmode="numeric" maxlength="16" value="{{ $user->nik }}" />
                            </div>
                            {{-- Nomor WhatsApp --}}
                            <div class="mb-3">
                                <label class="form-label" for="nomor_whatsapp">Nomor WhatsApp</label>
                                <input type="text" name="nomor_whatsapp"
                                    class="@error('nomor_whatsapp') is-invalid @enderror form-control" id="nomor_whatsapp"
                                    value="{{ $user->nomor_whatsapp }}" inputmode="numeric" maxlength="15" />
                            </div>
                        </div>

                        <!-- Column 2 -->
                        <div class="col-md-6">
                            {{-- Alamat --}}
                            <div class="mb-3">
                                <label class="form-label" for="alamat">Alamat</label>
                                <input type="text" name="alamat"
                                    class="@error('alamat') is-invalid @enderror form-control" id="alamat"
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
                            <div class="form-password-toggle mb-3">
                                <div class="d-flex justify-content-between">
                                    <label class="form-label" for="password">Password</label>
                                </div>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password"
                                        class="@error('password') is-invalid @enderror form-control" name="password"
                                        aria-describedby="password" />
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                </div>
                                <div class="mt-0" id="passwordError"></div>

                            </div>
                            {{-- Confirm New Password --}}
                            <div class="form-password-toggle mb-3">
                                <label for="password_confirmation" class="form-label">Konfirmasi
                                    Password</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password_confirmation" class="form-control"
                                        name="password_confirmation" aria-describedby="password_confirmation" />
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                </div>
                                <div class="mt-0" id="passwordConfirmationError"></div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary" id="saveButton">Ubah</button>
                </form>
            </div>
        </div>
        {{-- </div> --}}
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const form = document.getElementById("profileForm");
            const passwordField = document.getElementById("password");
            const confirmPasswordField = document.getElementById("password_confirmation");
            const errorDiv = document.getElementById("passwordConfirmationError");
            const passwordErrorDiv = document.getElementById("passwordError");



            function validatePasswords() {
                if (confirmPasswordField.value !== passwordField.value) {
                    confirmPasswordField.classList.add("is-invalid");
                    errorDiv.textContent = "Konfirmasi password tidak cocok.";
                    errorDiv.style.color = "red";
                    return false;
                } else {
                    confirmPasswordField.classList.remove("is-invalid");
                    errorDiv.textContent = "";
                    return true;
                }
            }

            function validatePasswordLength() {
                if (passwordField.value.length > 0 && passwordField.value.length < 8) {
                    passwordField.classList.add("is-invalid");
                    passwordErrorDiv.textContent = "Password minimal 8 karakter.";
                    passwordErrorDiv.style.color = "red";
                    return false;
                } else {
                    passwordField.classList.remove("is-invalid");
                    passwordErrorDiv.textContent = "";
                    return true;
                }
            }


            passwordField.addEventListener("input", function() {
                validatePasswordLength();

                if (passwordField.value.length > 0) {
                    confirmPasswordField.setAttribute("required", "required");
                } else {
                    confirmPasswordField.removeAttribute("required");
                    confirmPasswordField.classList.remove("is-invalid");
                    errorDiv.textContent = "";
                }
            });

            confirmPasswordField.addEventListener("input", validatePasswords);

            form.addEventListener("submit", function(event) {
                if (!validatePasswordLength() || (passwordField.value.length > 0 && !validatePasswords())) {
                    event.preventDefault();
                }
            });
        });
    </script>

@endsection
