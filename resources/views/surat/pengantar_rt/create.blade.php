@extends('partials.layouts.app')

@section('title', 'Surat Pengantar RT/RW')

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
                        <input type="hidden" name="jenis_surat" value="Surat Pengantar">

                        {{-- Nama --}}
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-nama">Nama Lengkap<span style="color: red">
                                    *</span></label>
                            <input type="text" name="nama" class="form-control" id="basic-default-nama"
                                placeholder="Nama Lengkap" required value="{{ old('nama', $user->nama) }}" />
                        </div>
                        {{-- TTL --}}
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-ttl">Tempat, Tanggal Lahir<span style="color: red">
                                    *</span></label>
                            <input type="text" name="ttl" class="form-control" id="basic-default-ttl"
                                placeholder="Tanggal Lahir" required value="{{ old('ttl') }}" />
                            <p style="font-size: 12px">Contoh: Purwakarta, 25 Januari 2025</p>
                        </div>
                        {{-- Jenis Kelamin --}}
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-jenis_kelamin">Jenis Kelamin <span
                                    style="color: red">*</span></label>
                            <select id="basic-default-jenis_kelamin" name="jenis_kelamin" class="form-control" required>
                                <option value="" disabled {{ old('jenis_kelamin') == null ? 'selected' : '' }}>Pilih
                                    Jenis Kelamin</option>
                                <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>
                                    Laki-laki</option>
                                <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>
                                    Perempuan</option>
                            </select>
                        </div>
                        {{-- NIK --}}
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-nik">Nomor Induk Kependudukan (NIK)<span
                                    style="color: red"> *</span></label>
                            <input type="text" name="nik" class="form-control" id="basic-default-nik"
                                inputmode="numeric" placeholder="Nomor Induk Kependudukan (NIK)" required
                                value="{{ old('nik', $user->nik) }}" inputmode="numeric" maxlength="16" />
                        </div>
                        {{-- Agama --}}
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-agama">Agama<span style="color: red">
                                    *</span></label>
                            <input type="text" name="agama" class="form-control" id="basic-default-agama"
                                placeholder="Agama" required value="{{ old('agama') }}" />
                        </div>
                        {{-- Pekerjaan --}}
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-pekerjaan">Pekerjaan<span style="color: red">
                                    *</span></label>
                            <input type="text" name="pekerjaan" class="form-control" id="basic-default-pekerjaan"
                                placeholder="Pekerjaan" required value="{{ old('pekerjaan') }}" />
                        </div>
                        {{-- Keperluan --}}
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-keperluan">Keperluan Surat<span style="color: red">
                                    *</span></label>
                            <input type="text" name="keperluan" class="form-control" id="basic-default-keperluan"
                                placeholder="Keperluan" required value="{{ old('keperluan') }}" />
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
