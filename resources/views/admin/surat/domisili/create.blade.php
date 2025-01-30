@extends('admin.layouts.app')

@section('title', 'Surat Keterangan Domisili')

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
                        <input type="hidden" name="jenis_surat" value="Surat Domisili">

                        <div class="mb-3">
                            <label class="form-label" for="basic-default-nama">Nama Lengkap<span style="color: red">
                                    *</span></label>
                            <input type="text" name="nama" class="form-control" id="basic-default-nama"
                                placeholder="Nama lengkap" required value="{{ old('nama', $user->nama) }}" />
                            <div id="nama-error" style="color: red; display: none;">Nama lengkap wajib diisi</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-nik">Nomor Induk Kependudukan (NIK)<span
                                    style="color: red"> *</span></label>
                            <input type="text" name="nik" class="form-control" id="basic-default-nik"
                                inputmode="numeric" placeholder="Nomor Induk Kependudukan (NIK)" required
                                value="{{ old('nik', $user->nik) }}" />
                            <div id="nik-error" style="color: red; display: none;">NIK wajib diisi dengan angka</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-ttl">Tempat, Tanggal Lahir<span style="color: red">
                                    *</span></label>
                            <input type="text" name="ttl" class="form-control" id="basic-default-ttl"
                                placeholder="Tanggal Lahir" required value="{{ old('ttl') }}" />
                            <div id="ttl-error" style="color: red; display: none;">Tempat, tanggal lahir wajib diisi</div>
                            <p style="font-size: 12px">Contoh: Purwakarta, 25 Januari 2025</p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="basic-default-status_kawin">Status Perkawinan<span
                                    style="color: red">
                                    *</span></label>
                            <select id="basic-default-status_kawin" name="status_kawin" class="form-control" required>
                                <option value="" disabled {{ old('status_kawin') == null ? 'selected' : '' }}>Pilih
                                    Status Perkawinan</option>
                                <option value="Belum Kawin">Belum Kawin</option>
                                <option value="Kawin">Kawin</option>
                                <option value="Cerai Hidup">Cerai Hidup</option>
                                <option value="Cerai Mati">Cerai Mati</option>
                            </select>
                            <div id="status_kawin-error" style="color: red; display: none;">Status perkawinan wajib diisi
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-agama">Agama<span style="color: red">
                                    *</span></label>
                            <input type="text" name="agama" class="form-control" id="basic-default-agama"
                                placeholder="Agama" required value="{{ old('agama') }}" />
                            <div id="agama-error" style="color: red; display: none;">Agama wajib diisi</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-pekerjaan">Pekerjaan<span style="color: red">
                                    *</span></label>
                            <input type="text" name="pekerjaan" class="form-control" id="basic-default-pekerjaan"
                                placeholder="Pekerjaan" required value="{{ old('pekerjaan') }}" />
                            <div id="pekerjaan-error" style="color: red; display: none;">Pekerjaan wajib diisi</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="alamat">Alamat Domisili Saat Ini <span style="color: red">
                                    *</span></label>
                            <textarea name="alamat" id="alamat" class="form-control" cols="30" rows="5" placeholder="Alamat Domisili"
                                required value="{{ $user->alamat }}">{{ old('alamat') }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-keperluan">Keperluan<span style="color: red">
                                    *</span></label>
                            <input type="text" name="keperluan" class="form-control" id="basic-default-keperluan"
                                placeholder="Keperluan" required value="{{ old('keperluan') }}" />
                            <div id="keperluan-error" style="color: red; display: none;">Keperluan wajib diisi</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-no_whatsapp">Nomor WhatsApp yang dapat dihubungi
                                <span style="color: red">
                                    *</span></label>
                            <input type="text" name="no_whatsapp" class="form-control" id="basic-default-no_whatsapp"
                                inputmode="numeric" placeholder="Nomor WhatsApp" required
                                value="{{ old('nomor_whatsapp', $user->nomor_whatsapp) }}" />
                            <div id="no_whatsapp-error" style="color: red; display: none;">Nomor WA wajib diisi dengan
                                angka
                            </div>
                        </div>

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
