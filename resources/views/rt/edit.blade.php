@extends('partials.layouts.app')

@section('title', 'Ubah Akun Ketua RT')

@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
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
                <h5 class="mb-0">Ubah Akun Ketua RT</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('rt.update', $rt->id) }}" method="post" id="editRtForm">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Nama Ketua RT</label>
                        <input type="text" name="nama" class="form-control" id="edit-nama"
                            value="{{ old('nama', $rt->nama) }}" placeholder="Nama Ketua RT" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">RT/RW</label>
                        <select name="rt_rw" class="form-control">
                            <option value="" disabled {{ old('rt_rw', $rt->rt_rw) == null ? 'selected' : '' }}>Pilih
                                RT/RW</option>
                            <option value="01/01" {{ old('rt_rw', $rt->rt_rw) == '01/01' ? 'selected' : '' }}>01/01
                            </option>
                            <option value="02/01" {{ old('rt_rw', $rt->rt_rw) == '02/01' ? 'selected' : '' }}>02/01
                            </option>
                            <option value="03/02" {{ old('rt_rw', $rt->rt_rw) == '03/02' ? 'selected' : '' }}>03/02
                            </option>
                            <option value="04/02" {{ old('rt_rw', $rt->rt_rw) == '04/02' ? 'selected' : '' }}>04/02
                            </option>
                            <option value="05/03" {{ old('rt_rw', $rt->rt_rw) == '05/03' ? 'selected' : '' }}>05/03
                            </option>
                            <option value="06/03" {{ old('rt_rw', $rt->rt_rw) == '06/03' ? 'selected' : '' }}>06/03
                            </option>
                            <option value="07/04" {{ old('rt_rw', $rt->rt_rw) == '07/04' ? 'selected' : '' }}>07/04
                            </option>
                            <option value="08/04" {{ old('rt_rw', $rt->rt_rw) == '08/04' ? 'selected' : '' }}>08/04
                            </option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nomor WhatsApp</label>
                        <input type="text" name="nomor_whatsapp" class="form-control"
                            value="{{ old('nomor_whatsapp', $rt->nomor_whatsapp) }}" inputmode="numeric" maxlength="15"
                            placeholder="Nomor WhatsApp" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $rt->email) }}"
                            placeholder="Email" />
                    </div>
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
                    </div>
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
                    <div class="mt-0" id="passwordConfirmationError"></div>
                    <button type="submit" class="btn btn-primary" id="saveButton">Ubah</button>
                </form>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const form = document.getElementById("editRtForm");
            const passwordField = document.getElementById("password");
            const confirmPasswordField = document.getElementById("password_confirmation");
            const errorDiv = document.getElementById("passwordConfirmationError");

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

            passwordField.addEventListener("input", function() {
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
                if (passwordField.value.length > 0 && !validatePasswords()) {
                    event.preventDefault();
                }
            });
        });
    </script>
@endsection
