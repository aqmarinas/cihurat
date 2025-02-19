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
                <form action="{{ route('rt.update', $rt->id) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Nama Ketua RT</label>
                        <input type="text" name="nama" class="form-control" id="edit-nama"
                            value="{{ old('nama', $rt->nama) }}" />
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
                            value="{{ old('nomor_whatsapp', $rt->nomor_whatsapp) }}" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $rt->email) }}" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="password">Password Baru</label>
                        <input type="password" name="password" class="form-control" id="password" />
                    </div>
                    <div class="error-message" id="passwordError"></div>
                    <div class="mb-3">
                        <label class="form-label" for="password_confirmation">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" class="form-control"
                            id="password_confirmation" />
                    </div>
                    <div class="error-message" id="passwordConfirmationError"></div>
                    <button type="submit" class="btn btn-primary" id="saveButton">Ubah</button>
                </form>
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
