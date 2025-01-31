@extends('partials.layouts.app')

@section('title', 'Surat Keterangan Belum Menikah')

@section('container')
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
                        <input type="hidden" name="jenis_surat" value="Surat Keterangan Belum Menikah">

                        {{-- Nama --}}
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-nama">Nama Lengkap<span style="color: red">
                                    *</span></label>
                            <input type="text" name="nama" class="form-control" id="basic-default-nama"
                                placeholder="Nama Lengkap" required value="{{ old('nama', $user->nama) }}" />
                        </div>
                        {{-- Bin/Binti --}}
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-bin">Bin/Binti<span style="color: red">
                                    *</span></label>
                            <input type="text" name="bin" class="form-control" id="basic-default-bin"
                                placeholder="Bin/Binti" required value="{{ old('bin') }}" />
                        </div>
                        {{-- NIK --}}
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-nik">Nomor Induk Kependudukan (NIK)<span
                                    style="color: red"> *</span></label>
                            <input type="text" name="nik" class="form-control" id="basic-default-nik"
                                inputmode="numeric" placeholder="Nomor Induk Kependudukan (NIK)" required
                                value="{{ old('nik', $user->nik) }}" inputmode="numeric" maxlength="16" />
                        </div>
                        {{-- TTL --}}
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-ttl">Tempat, Tempat Lahir<span style="color: red">
                                    *</span></label>
                            <input type="text" name="ttl" class="form-control" id="basic-default-ttl"
                                placeholder="Tempat, Tanggal Lahir" required value="{{ old('ttl') }}" />
                            <p style="font-size: 12px">Contoh: Purwakarta, 24 Januari 1980</p>

                        </div>
                        {{-- Agama --}}
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-agama">Agama<span style="color: red">
                                    *</span></label>
                            <input type="text" name="agama" class="form-control" id="basic-default-agama"
                                placeholder="Tempat Lahir" required value="{{ old('agama') }}" />
                        </div>
                        {{-- Kewarganegaraan --}}
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-kewarganegaraan">Kewarganegaraan<span
                                    style="color: red">
                                    *</span></label>
                            <input type="text" name="kewarganegaraan" class="form-control"
                                id="basic-default-kewarganegaraan" placeholder="Kewarganegaraan" required
                                value="{{ old('kewarganegaraan') }}" />
                        </div>
                        {{-- Status Perkawinan --}}
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-status_kawin">Status Perkawinan <span
                                    style="color: red">*</span></label>
                            <select id="basic-default-status_kawin" name="status_kawin" class="form-control" required>
                                <option value="" disabled {{ old('status_kawin') == null ? 'selected' : '' }}>
                                    Pilih Status Perkawinan
                                </option>
                                <option value="Belum Kawin" {{ old('status_kawin') == 'Belum Kawin' ? 'selected' : '' }}>
                                    Belum Kawin</option>
                                <option value="Kawin" {{ old('status_kawin') == 'Kawin' ? 'selected' : '' }}>Kawin
                                </option>
                                <option value="Cerai Hidup" {{ old('status_kawin') == 'Cerai Hidup' ? 'selected' : '' }}>
                                    Cerai Hidup</option>
                                <option value="Cerai Mati" {{ old('status_kawin') == 'Cerai Mati' ? 'selected' : '' }}>
                                    Cerai Mati</option>
                            </select>
                        </div>
                        {{-- Pekerjaan --}}
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-pekerjaan">Pekerjaan<span style="color: red">
                                    *</span></label>
                            <input type="text" name="pekerjaan" class="form-control" id="basic-default-pekerjaan"
                                placeholder="pekerjaan" required value="{{ old('pekerjaan') }}" />
                        </div>
                        {{-- Alamat --}}
                        <div class="mb-3">
                            <label class="form-label" for="alamat">Alamat <span style="color: red">
                                    *</span></label>
                            <textarea name="alamat" id="alamat" class="form-control" cols="30" rows="5" placeholder="Alamat "
                                required value="{{ $user->alamat }}">{{ old('alamat') }}</textarea>
                        </div>
                        {{-- Nomor WhatsApp --}}
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-no_whatsapp">Nomor WhatsApp yang dapat dihubungi
                                <span style="color: red">
                                    *</span></label>
                            <input type="text" name="no_whatsapp" class="form-control" id="basic-default-no_whatsapp"
                                inputmode="numeric" placeholder="Nomor WhatsApp" required
                                value="{{ old('nomor_whatsapp', $user->nomor_whatsapp) }}" />
                        </div>
                        {{-- Attachment --}}
                        <div class="mb-3">
                            <label class="form-label" for="ktp">Kartu Tanda Penduduk (KTP) <span
                                    style="color: red">*</span></label>
                            <input type="file" name="ktp" class="form-control" id="ktp"
                                accept="image/jpeg,image/png,image/jpg" required />
                            <p style="font-size: 12px">(.jpg, .jpeg, .png; Maksimal 2MB)</p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="kk">Kartu Keluarga (KK) <span
                                    style="color: red">*</span></label>
                            <input type="file" name="kk" class="form-control" id="kk"
                                accept="image/jpeg,image/png, image/jpg" required />
                            <p style="font-size: 12px">(.jpg, .jpeg, .png; Maksimal 2MB)</p>
                        </div>

                        <button type="submit" class="btn btn-primary" id="saveButton">Kirim</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
