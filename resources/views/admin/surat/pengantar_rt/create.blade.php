@extends('admin.layouts.app')

@section('title', 'Surat Pengantar RT/RW')

@section('container')
    <style>
        .upload-file-container {
            text-align: center;
            margin-top: 20px;
        }

        .upload-area {
            border: 2px dashed #007bff;
            padding: 20px;
            cursor: pointer;
        }

        .upload-label {
            display: inline-block;
            color: #007bff;
        }

        .file-list {
            margin-top: 10px;
        }

        .file-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 5px;
            padding: 5px;
            background-color: #f1f1f1;
            border-radius: 5px;
        }

        .file-item .remove-file {
            cursor: pointer;
            color: red;
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
                    <h5 class="mb-0">Formulir Pengajuan {{ $surat->name ?? '' }}</h5>
                </div>

                <div class="card-body">
                    <form action="{{ route('surat.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="jenis_surat" value="Surat Pengantar">

                        {{-- Nama --}}
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-nama">Nama Lengkap<span style="color: red">
                                    *</span></label>
                            <input type="text" name="nama" class="form-control" id="basic-default-nama"
                                placeholder="Nama lengkap" required value="{{ old('nama', $user->nama) }}" />
                            <div id="nama-error" style="color: red; display: none;">Nama lengkap wajib diisi</div>
                        </div>
                        {{-- Tempat Lahir --}}
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-tempat_lahir">Tempat Lahir<span style="color: red">
                                    *</span></label>
                            <input type="text" name="tempat_lahir" class="form-control" id="basic-default-tempat_lahir"
                                placeholder="Tempat Lahir" required
                                value="{{ old('tempat_lahir', $user->tempat_lahir) }}" />
                            <div id="tempat_lahir-error" style="color: red; display: none;">Tempat lahir wajib diisi</div>
                        </div>
                        {{-- Tanggal Lahir --}}
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-tanggal_lahir">Tanggal Lahir<span
                                    style="color: red">
                                    *</span></label>
                            <input type="text" name="tanggal_lahir" class="form-control" id="basic-default-tanggal_lahir"
                                placeholder="Tanggal Lahir" required
                                value="{{ old('tanggal_lahir', $user->tanggal_lahir) }}" />
                            <div id="tanggal_lahir-error" style="color: red; display: none;">Tanggal lahir wajib diisi</div>
                        </div>
                        {{-- Jenis Kelamin --}}
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-jenis_kelamin">Jenis Kelamin<span
                                    style="color: red">
                                    *</span></label>
                            <select id="basic-default-jenis_kelamin" name="jenis_kelamin" class="form-control" required>
                                <option value="" disabled {{ old('jenis_kelamin') == null ? 'selected' : '' }}>Pilih
                                    Jenis Kelamin</option>
                                <option value="Laki-Laki">Laki-Laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                            <div id="jenis_kelamin-error" style="color: red; display: none;">Status perkawinan wajib diisi
                            </div>
                        </div>
                        {{-- NIK --}}
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-nik">Nomor Induk Kependudukan (NIK)<span
                                    style="color: red"> *</span></label>
                            <input type="text" name="nik" class="form-control" id="basic-default-nik"
                                inputmode="numeric" placeholder="Nomor Induk Kependudukan (NIK)" required
                                value="{{ old('nik', $user->nik) }}" />
                            <div id="nik-error" style="color: red; display: none;">NIK wajib diisi dengan angka</div>
                        </div>
                        {{-- Agama --}}
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-agama">Agama<span style="color: red">
                                    *</span></label>
                            <input type="text" name="agama" class="form-control" id="basic-default-agama"
                                placeholder="Agama" required value="{{ old('agama') }}" />
                            <div id="agama-error" style="color: red; display: none;">Agama wajib diisi</div>
                        </div>
                        {{-- Pekerjaan --}}
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-pekerjaan">Pekerjaan<span style="color: red">
                                    *</span></label>
                            <input type="text" name="pekerjaan" class="form-control" id="basic-default-pekerjaan"
                                placeholder="Pekerjaan" required value="{{ old('pekerjaan') }}" />
                            <div id="pekerjaan-error" style="color: red; display: none;">Pekerjaan wajib diisi</div>
                        </div>
                        {{-- Keperluan --}}
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-keperluan">Keperluan<span style="color: red">
                                    *</span></label>
                            <input type="text" name="keperluan" class="form-control" id="basic-default-keperluan"
                                placeholder="Keperluan" required value="{{ old('keperluan') }}" />
                            <div id="keperluan-error" style="color: red; display: none;">Keperluan wajib diisi</div>
                        </div>
                        {{-- Nomor WhatsApp --}}
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-no_whatsapp">Nomor WhatsApp <span
                                    style="color: red">
                                    *</span></label>
                            <input type="text" name="no_whatsapp" class="form-control" id="basic-default-no_whatsapp"
                                inputmode="numeric" placeholder="Nomor WhatsApp" required
                                value="{{ old('nomor_whatsapp', $user->nomor_whatsapp) }}" />
                            <div id="no_whatsapp-error" style="color: red; display: none;">Nomor WA wajib diisi dengan
                                angka
                            </div>
                        </div>
                        {{-- Attachment --}}
                        {{-- <div>
                            Scan KTP <span style="color: red"> *</span>
                        </div>
                        <div class="upload-file-container">
                            <div class="upload-area">
                                <input type="file" id="files" name="files[]" multiple style="display: none;">
                                <label for="files" class="upload-label">
                                    <div class="upload-icon">
                                        <i class="bx bx-cloud-upload"></i>
                                    </div>
                                    <span>Click To Upload</span>
                                </label>
                            </div>
                            <div id="file-list" class="file-list" style="margin: 10px 0px 10px 0px"></div>
                            <div id="fileError" style="display:none; color:red;">File size exceeds 20MB.</div>
                        </div> --}}
                        {{-- <div class="mb-3">
                            <label for="ktp" class="form-label">KTP <span style="color: red">
                                    *</span></label>
                            <input type="file" class="form-control" id="ktp" name="ktp" required>
                        </div> --}}
                        <div class="mb-3">
                            <label class="form-label" for="ktp_file">Upload KTP <span style="color: red">*</span></label>
                            <input type="file" name="ktp_file" class="form-control" id="ktp_file"
                                accept="image/jpeg,image/png" required />
                            @error('ktp_file')
                                <div style="color: red;">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary" id="saveButton">Kirim</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
