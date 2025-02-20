@extends('partials.layouts.app')

@section('title', 'Tambah Ketua RW')

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
                <h5 class="mb-0">Tambah Ketua RW</h5>
            </div>
            <div class="card-body">
                <form id="rwForm" action="{{ route('rw.store') }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label" for="nama">Nama Lengkap Ketua RW <span
                                style="color: red">*</span></label>
                        <input type="text" name="nama" class="form-control" id="nama" required
                            placeholder="Masukkan Nama Lengkap" value="{{ old('nama') }}" />
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="no_whatsapp">Nomor WhatsApp <span style="color: red">*</span></label>
                        <input type="text" name="no_whatsapp" class="form-control" id="no_whatsapp" required
                            value="{{ old('no_whatsapp') }}" placeholder="Masukkan Nomor WhatsApp" inputmode="numeric"
                            maxlength="15" />
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="rw">RW <span style="color: red">*</span></label>
                        <select name="rw" class="form-control" id="rw" required>
                            <option value="" disabled {{ old('rw') == null ? 'selected' : '' }}>Pilih RW</option>
                            <option value="01" {{ old('rw') == '01' ? 'selected' : '' }}>01</option>
                            <option value="02" {{ old('rw') == '02' ? 'selected' : '' }}>02</option>
                            <option value="03" {{ old('rw') == '03' ? 'selected' : '' }}>03</option>
                            <option value="04" {{ old('rw') == '04' ? 'selected' : '' }}>04</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary" id="saveButton">Tambah</button>
                </form>
            </div>
        </div>
    </div>
@endsection
