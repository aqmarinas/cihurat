@extends('partials.layouts.app')

@section('title', 'Surat Keterangan Kematian')

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
                                inputmode="numeric" placeholder="Nomor Induk Kependudukan (NIK) Alm." required
                                value="{{ old('nik') }}" />
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
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="alamat">Alamat <span style="color: red">
                                    *</span></label>
                            <textarea name="alamat" id="alamat" class="form-control" cols="30" rows="5"
                                placeholder="Alamat sesuai Kartu Keluarga (KK)" required>{{ old('alamat') }}</textarea>
                        </div>
                        {{-- Hari Meninggal --}}
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-hari_meninggal">Hari Meninggal<span
                                    style="color: red">
                                    *</span></label>
                            <input type="text" name="hari_meninggal" class="form-control"
                                id="basic-default-hari_meninggal" placeholder="Hari" required
                                value="{{ old('hari_meninggal') }}" />
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
                            <input type="text" name="sebab_meninggal" class="form-control"
                                id="basic-default-sebab_meninggal" placeholder="Penyebab" required
                                value="{{ old('sebab_meninggal') }}" />
                        </div>
                        {{-- Nomor WhatsApp --}}
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-no_whatsapp">Nomor WhatsApp yang dapat
                                dihubungi<span style="color: red">
                                    *</span></label>
                            <input type="text" name="no_whatsapp" class="form-control" id="basic-default-no_whatsapp"
                                placeholder="Nomor WhatsApp" required value="{{ old('no_whatsapp') }}" />
                        </div>

                        {{-- Attachment --}}
                        <div class="mb-3">
                            <label class="form-label" for="ktp">Kartu Tanda Penduduk (KTP) Alm. <span
                                    style="color: red">*</span></label>
                            <input type="file" name="ktp" class="form-control" id="ktp"
                                accept="image/jpeg,image/png,image/jpg" required />
                            <p style="font-size: 12px">(.jpg, .jpeg, .png; Maksimal 2MB)</p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="kk">Kartu Keluarga (KK) Terbaru <span
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
