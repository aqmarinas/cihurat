@extends('partials.layouts.app')

@section('title', 'Tambah Akun Ketua RT')

@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        {{-- <div class="container"> --}}
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
                <h5 class="mb-0">Tambah Akun Ketua RT</h5>
            </div>
            <div class="card-body">
                <form id="userForm" action="{{ route('rt.store') }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label" for="nama">Nama Lengkap Ketua RT <span
                                style="color: red">*</span></label>
                        <input type="text" name="nama" class="form-control" id="nama" required
                            value="{{ old('nama') }}" />
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="email">Email <span style="color: red">*</span></label>
                        <input type="email" name="email" class="form-control" id="email" required
                            value="{{ old('email') }}" />
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="nomor_whatsapp">Nomor WhatsApp <span
                                style="color: red">*</span></label>
                        <input type="text" name="nomor_whatsapp" class="form-control" id="nomor_whatsapp" required
                            value="{{ old('nomor_whatsapp') }}" />
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="rt_rw">RT/RW <span style="color: red">*</span></label>
                        <select name="rt_rw" class="form-control" id="rt_rw" required>
                            <option value="" disabled {{ old('rt_rw') == null ? 'selected' : '' }}>Pilih RT/RW
                            </option>
                            <option value="01/01" {{ old('rt_rw') == '01/01' ? 'selected' : '' }}>01/01</option>
                            <option value="02/01" {{ old('rt_rw') == '02/01' ? 'selected' : '' }}>02/01</option>
                            <option value="03/02" {{ old('rt_rw') == '03/02' ? 'selected' : '' }}>03/02</option>
                            <option value="04/02" {{ old('rt_rw') == '04/02' ? 'selected' : '' }}>04/02</option>
                            <option value="05/03" {{ old('rt_rw') == '05/03' ? 'selected' : '' }}>05/03</option>
                            <option value="06/03" {{ old('rt_rw') == '06/03' ? 'selected' : '' }}>06/03</option>
                            <option value="07/04" {{ old('rt_rw') == '07/04' ? 'selected' : '' }}>07/04</option>
                            <option value="08/04" {{ old('rt_rw') == '08/04' ? 'selected' : '' }}>08/04</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="password">Password <span style="color: red">*</span></label>
                        <input type="password" name="password" class="form-control" id="password" required />
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="password_confirmation">Konfirmasi Password <span
                                style="color: red">*</span></label>
                        <input type="password" name="password_confirmation" class="form-control" id="password_confirmation"
                            required />
                        <div id="passwordError" class="text-danger" style="display: none;">Konfimasi password tidak
                            sesuai!</div>
                    </div>

                    <input type="hidden" name="role" value="rt">

                    <button type="submit" class="btn btn-primary" id="saveButton">Tambah</button>
                </form>
            </div>
        </div>
        {{-- </div> --}}
    </div>
@endsection
