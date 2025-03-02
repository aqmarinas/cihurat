@extends('partials.layouts.app')

@section('title', 'Surat Keterangan Kematian')

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
                <h5 class="mb-0">Formulir Pengajuan {{ $surat->name ?? '' }}</h5>
            </div>

            <div class="card-body">
                <form action="{{ route('surat.store') }}" method="post" enctype="multipart/form-data" id="suratForm">
                    @csrf
                    <input type="hidden" name="jenis_surat" value="Surat Keterangan Kematian">

                    {{-- Nama --}}
                    <div class="mb-3">
                        <label class="form-label" for="basic-default-nama">Nama Lengkap Alm.<span style="color: red">
                                *</span></label>
                        <input type="text" name="nama" class="form-control" id="basic-default-nama"
                            placeholder="Nama Lengkap Alm." required value="{{ old('nama') }}" />
                    </div>
                    {{-- NIK --}}
                    <div class="mb-3">
                        <label class="form-label" for="basic-default-nik">Nomor Induk Kependudukan (NIK) Alm.<span
                                style="color: red"> *</span></label>
                        <input type="text" name="nik" class="form-control" id="basic-default-nik"
                            placeholder="Nomor Induk Kependudukan (NIK) Alm." required value="{{ old('nik') }}"
                            inputmode="numeric" maxlength="16" />
                    </div>
                    {{-- Jenis Kelamin --}}
                    <div class="mb-3">
                        <label class="form-label" for="basic-default-jenis_kelamin">Jenis Kelamin <span
                                style="color: red">*</span></label>
                        <select id="basic-default-jenis_kelamin" name="jenis_kelamin" class="form-control" required>
                            <option value="" disabled {{ old('jenis_kelamin') == null ? 'selected' : '' }}>
                                Pilih Jenis Kelamin
                            </option>
                            <option value="Laki-Laki" {{ old('jenis_kelamin') == 'Laki-Laki' ? 'selected' : '' }}>
                                Laki-Laki</option>
                            <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>
                                Perempuan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="alamat">Alamat <span style="color: red">
                                *</span></label>
                        <textarea name="alamat" id="alamat" class="form-control" cols="30" rows="5"
                            placeholder="Alamat sesuai Kartu Keluarga (KK)" required>{{ old('alamat') }}</textarea>
                    </div>
                    {{-- Hari Meninggal --}}
                    <div class="mb-3">
                        <label class="form-label" for="basic-default-hari_meninggal">Hari Meninggal<span style="color: red">
                                *</span></label>
                        <select name="hari_meninggal" class="form-control" id="basic-default-hari_meninggal" required>
                            <option value="" disabled selected>Pilih Hari</option>
                            <option value="Senin" {{ old('hari_meninggal') == 'Senin' ? 'selected' : '' }}>Senin
                            </option>
                            <option value="Selasa" {{ old('hari_meninggal') == 'Selasa' ? 'selected' : '' }}>Selasa
                            </option>
                            <option value="Rabu" {{ old('hari_meninggal') == 'Rabu' ? 'selected' : '' }}>Rabu
                            </option>
                            <option value="Kamis" {{ old('hari_meninggal') == 'Kamis' ? 'selected' : '' }}>Kamis
                            </option>
                            <option value="Jumat" {{ old('hari_meninggal') == 'Jumat' ? 'selected' : '' }}>Jumat
                            </option>
                            <option value="Sabtu" {{ old('hari_meninggal') == 'Sabtu' ? 'selected' : '' }}>Sabtu
                            </option>
                            <option value="Minggu" {{ old('hari_meninggal') == 'Minggu' ? 'selected' : '' }}>Minggu
                            </option>
                        </select>
                    </div>
                    {{-- Tanggal Meninggal --}}
                    <div class="mb-3">
                        <label class="form-label" for="basic-default-tanggal_meninggal">Tanggal Meninggal<span
                                style="color: red">
                                *</span></label>
                        <input type="text" name="tanggal_meninggal" class="form-control"
                            id="basic-default-tanggal_meninggal" placeholder="Tanggal" required
                            value="{{ old('tanggal_meninggal') }}" />
                        <p style="font-size: 12px">Contoh: 25 Januari 2025</p>
                    </div>
                    {{-- Desa Tempat Meninggal --}}
                    <div class="mb-3">
                        <label class="form-label" for="basic-default-tempat_meninggal">Desa Tempat Meninggal<span
                                style="color: red">
                                *</span></label>
                        <input type="text" name="tempat_meninggal" class="form-control"
                            id="basic-default-tempat_meninggal" placeholder="Tempat" required
                            value="{{ old('tempat_meninggal') }}" />
                    </div>
                    {{-- Penyebab Meninggal --}}
                    <div class="mb-3">
                        <label class="form-label" for="basic-default-sebab_meninggal">Penyebab Meninggal<span
                                style="color: red">
                                *</span></label>
                        <input type="text" name="sebab_meninggal" class="form-control" id="basic-default-sebab_meninggal"
                            placeholder="Penyebab" required value="{{ old('sebab_meninggal') }}" />
                    </div>
                    {{-- Nomor WhatsApp --}}
                    <div class="mb-3">
                        <label class="form-label" for="basic-default-no_whatsapp">Nomor WhatsApp yang dapat
                            dihubungi<span style="color: red">
                                *</span></label>
                        <input type="text" name="no_whatsapp" class="form-control" id="basic-default-no_whatsapp"
                            placeholder="Nomor WhatsApp" required value="{{ old('no_whatsapp') }}" inputmode="numeric"
                            maxlength="15" />
                    </div>

                    {{-- Attachment --}}
                    <div class="mb-3">
                        <label class="form-label" for="ktp">Kartu Tanda Penduduk (KTP) <span
                                style="color: red">*</span></label>
                        <input type="file" name="ktp" class="form-control" id="ktp"
                            accept="image/jpeg,image/png,image/jpg" required />
                        <p style="font-size: 12px">(.jpg, .jpeg, .png; Maksimal 1MB)</p>
                        <div id="ktpError" style="color: red; display: none;">Ukuran file tidak boleh lebih dari 1MB.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="kk">Kartu Keluarga (KK) <span
                                style="color: red">*</span></label>
                        <input type="file" name="kk" class="form-control" id="kk"
                            accept="image/jpeg,image/png,image/jpg" required />
                        <p style="font-size: 12px">(.jpg, .jpeg, .png; Maksimal 1MB)</p>
                        <div id="kkError" style="color: red; display: none;">Ukuran file tidak boleh lebih dari 1MB.
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary" id="saveButton">Kirim</button>
                </form>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('suratForm').addEventListener('submit', function(event) {
            event.preventDefault();

            let isKkValid = true;
            let isKtpValid = true;

            if (document.getElementById('kk').files.length > 0) {
                isKkValid = checkFileSize('kk', 'kkError');
            }

            if (document.getElementById('ktp').files.length > 0) {
                isKtpValid = checkFileSize('ktp', 'ktpError');
            }

            if (isKkValid && isKtpValid) {
                this.submit();
            } else {
                if (!isKkValid) {
                    document.getElementById('kkError').scrollIntoView({
                        behavior: 'smooth'
                    });
                } else if (!isKtpValid) {
                    document.getElementById('ktpError').scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            }
        });

        function checkFileSize(inputId, errorId) {
            const file = document.getElementById(inputId).files[0];
            const input = document.getElementById(inputId);
            const errorMessage = document.getElementById(errorId);

            if (file && file.size > 1 * 1024 * 1024) { // 1MB
                errorMessage.style.display = 'block';
                input.style.border = '2px solid red';
                return false;
            } else {
                errorMessage.style.display = 'none';
                input.style.border = '';
                return true;
            }
        }

        document.getElementById('ktp').addEventListener('change', function() {
            checkFileSize('ktp', 'ktpError');
        });

        document.getElementById('kk').addEventListener('change', function() {
            checkFileSize('kk', 'kkError');
        });
    </script>
@endsection
