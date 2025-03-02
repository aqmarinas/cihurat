@extends('partials.layouts.app')

@section('title', 'Surat Keterangan Tidak Mampu')

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
                    <input type="hidden" name="jenis_surat" value="Surat Keterangan Tidak Mampu">

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6>Data Orang Tua Pemohon</h6>
                            <hr>

                            {{-- Nama --}}
                            <div class="mb-3">
                                <label class="form-label" for="basic-default-nama_ortu">Nama Lengkap Orang Tua<span
                                        style="color: red">
                                        *</span></label>
                                <input type="text" name="nama_ortu" class="form-control" id="basic-default-nama_ortu"
                                    placeholder="Nama Lengkap Orang Tua" required value="{{ old('nama_ortu') }}" />
                            </div>
                            {{-- NIK --}}
                            <div class="mb-3">
                                <label class="form-label" for="basic-default-nik_ortu">Nomor Induk Kependudukan
                                    (NIK) Orang Tua<span style="color: red"> *</span></label>
                                <input type="text" name="nik_ortu" class="form-control" id="basic-default-nik_ortu"
                                    inputmode="numeric" placeholder="Nomor Induk Kependudukan (NIK)" required
                                    value="{{ old('nik_ortu') }}" maxlength="16" />
                            </div>
                            {{-- TTL --}}
                            <div class="mb-3">
                                <label class="form-label" for="basic-default-ttl_ortu">Tempat, Tanggal Lahir Orang
                                    Tua<span style="color: red">
                                        *</span></label>
                                <input type="text" name="ttl_ortu" class="form-control" id="basic-default-ttl_ortu"
                                    placeholder="Tempat, Tanggal Lahir" required value="{{ old('ttl_ortu') }}" />
                                <p style="font-size: 12px">Contoh: Purwakarta, 24 Januari 1980</p>
                            </div>
                            {{-- Jenis Kelamin --}}
                            <div class="mb-3">
                                <label class="form-label" for="basic-default-jenis_kelamin_ortu">Jenis Kelamin <span
                                        style="color: red">*</span></label>
                                <select id="basic-default-jenis_kelamin_ortu" name="jenis_kelamin_ortu" class="form-control"
                                    required>
                                    <option value="" disabled
                                        {{ old('jenis_kelamin_ortu') == null ? 'selected' : '' }}>
                                        Pilih Jenis Kelamin
                                    </option>
                                    <option value="Laki-laki"
                                        {{ old('jenis_kelamin_ortu') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki
                                    </option>
                                    <option value="Perempuan"
                                        {{ old('jenis_kelamin_ortu') == 'Perempuan' ? 'selected' : '' }}>Perempuan
                                    </option>
                                </select>
                            </div>
                            {{-- Nomor WhatsApp --}}
                            <div class="mb-3">
                                <label class="form-label" for="basic-default-no_whatsapp">Nomor WhatsApp yang dapat
                                    dihubungi <span style="color: red">
                                        *</span></label>
                                <input type="text" name="no_whatsapp" class="form-control" id="basic-default-no_whatsapp"
                                    inputmode="numeric" maxlength="15" placeholder="Nomor WhatsApp" required
                                    value="{{ old('no_whatsapp') }}" />
                            </div>
                            {{-- Status Perkawinan --}}
                            <div class="mb-3">
                                <label class="form-label" for="basic-default-status_kawin">Status Perkawinan <span
                                        style="color: red">*</span></label>
                                <select id="basic-default-status_kawin" name="status_kawin" class="form-control" required>
                                    <option value="" disabled {{ old('status_kawin') == null ? 'selected' : '' }}>
                                        Pilih Status Perkawinan
                                    </option>
                                    <option value="Belum Kawin"
                                        {{ old('status_kawin') == 'Belum Kawin' ? 'selected' : '' }}>Belum Kawin
                                    </option>
                                    <option value="Kawin" {{ old('status_kawin') == 'Kawin' ? 'selected' : '' }}>Kawin
                                    </option>
                                    <option value="Cerai Hidup"
                                        {{ old('status_kawin') == 'Cerai Hidup' ? 'selected' : '' }}>Cerai Hidup
                                    </option>
                                    <option value="Cerai Mati" {{ old('status_kawin') == 'Cerai Mati' ? 'selected' : '' }}>
                                        Cerai Mati</option>
                                </select>
                            </div>
                            {{-- Alamat --}}
                            <div class="mb-3">
                                <label class="form-label" for="alamat">Alamat <span style="color: red">
                                        *</span></label>
                                <textarea name="alamat" id="alamat" class="form-control" cols="30" rows="5"
                                    placeholder="Alamat sesuai Kartu Keluarga (KK)" required>{{ old('alamat') }}</textarea>
                            </div>
                            {{-- Penghasilan Per Bulan --}}
                            <div class="mb-3">
                                <label class="form-label" for="basic-default-penghasilan">Penghasilan Per Bulan<span
                                        style="color: red">
                                        *</span></label>
                                <input type="text" name="penghasilan" class="form-control" id="basic-default-penghasilan"
                                    placeholder="500.000" required value="{{ old('penghasilan') }}"
                                    pattern="^\d{1,3}(\.\d{3})*$" />
                                <p style="font-size: 12px">Contoh: 1.000.000 (Gunakan titik untuk memisahkan ribuan)
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            {{-- Data Pemohon --}}
                            <h6>Data Pemohon</h6>
                            <hr>
                            {{-- Nama --}}
                            <div class="mb-3">
                                <label class="form-label" for="basic-default-nama">Nama Lengkap <span style="color: red">
                                        *</span></label>
                                <input type="text" name="nama" class="form-control" id="basic-default-nama"
                                    placeholder="Nama Lengkap" required value="{{ old('nama') }}" />
                            </div>

                            {{-- NIK --}}
                            <div class="mb-3">
                                <label class="form-label" for="basic-default-nik">Nomor Induk Kependudukan (NIK)<span
                                        style="color: red"> *</span></label>
                                <input type="text" name="nik" class="form-control" id="basic-default-nik"
                                    inputmode="numeric" maxlength="16" placeholder="Nomor Induk Kependudukan (NIK)"
                                    required value="{{ old('nik') }}" />
                            </div>
                            {{-- TTL --}}
                            <div class="mb-3">
                                <label class="form-label" for="basic-default-ttl">Tempat, Tanggal Lahir<span
                                        style="color: red">
                                        *</span></label>
                                <input type="text" name="ttl" class="form-control" id="basic-default-ttl"
                                    placeholder="Tempat, Tanggal Lahir" required value="{{ old('ttl') }}" />
                                <p style="font-size: 12px">Contoh: Purwakarta, 24 Januari 2010</p>
                            </div>
                            {{-- Jenis Kelamin --}}
                            <div class="mb-3">
                                <label class="form-label" for="basic-default-jenis_kelamin">Jenis Kelamin <span
                                        style="color: red">*</span></label>
                                <select id="basic-default-jenis_kelamin" name="jenis_kelamin" class="form-control"
                                    required>
                                    <option value="" disabled {{ old('jenis_kelamin') == null ? 'selected' : '' }}>
                                        Pilih Jenis Kelamin
                                    </option>
                                    <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>
                                        Laki-laki</option>
                                    <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>
                                        Perempuan</option>
                                </select>
                            </div>

                            {{-- Sekolah --}}
                            <div class="mb-3">
                                <label class="form-label" for="basic-default-sekolah">Sekolah<span style="color: red">
                                        *</span></label>
                                <input type="text" name="sekolah" class="form-control" id="basic-default-sekolah"
                                    placeholder="Sekolah" required value="{{ old('sekolah') }}" />
                            </div>

                            {{-- Jurusan --}}
                            <div class="mb-3">
                                <label class="form-label" for="basic-default-jurusan">Jurusan<span style="color: red">
                                        *</span></label>
                                <input type="text" name="jurusan" class="form-control" id="basic-default-jurusan"
                                    placeholder="Jurusan" required value="{{ old('jurusan') }}" />
                                <p style="font-size: 12px">Isi tanda strip "-" jika tidak ada jurusan</p>

                            </div>

                            {{-- Keperluan --}}
                            <div class="mb-3">
                                <label class="form-label" for="basic-default-keperluan">Keperluan Surat<span
                                        style="color: red">
                                        *</span></label>
                                <input type="text" name="keperluan" class="form-control" id="basic-default-keperluan"
                                    placeholder="Keperluan" required value="{{ old('keperluan') }}" />
                            </div>
                        </div>
                    </div>

                    {{-- Attachment --}}
                    <hr>
                    <h6>Berkas </h6>

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
