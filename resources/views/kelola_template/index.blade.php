@extends('partials.layouts.app')

@section('title', 'Tambah Template Surat')

@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="container">
            @if (session('success'))
                <div class="alert-dismissible fade show alert alert-success">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

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
                    <h5 class="mb-0">Tambah Template Surat</h5>
                </div>
                <div class="card-body">
                    <form id="" action="{{ route('admin.template.store') }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            {{-- <label for="jenis_surat">Jenis Surat</label>
                            <select name="jenis_surat" id="jenis_surat" required>
                                <option value="Surat Pengantar">Surat Pengantar</option>
                                <option value="Surat Keterangan Tidak Mampu">Surat Keterangan Tidak Mampu</option>
                                <option value="Surat Keterangan Kematian">Surat Keterangan Kematian</option>
                                <option value="Surat Keterangan Usaha">Surat Keterangan Usaha</option>
                                <option value="Surat Keterangan Belum Menikah">Surat Keterangan Belum Menikah</option>
                                <option value="Surat Domisili">Surat Domisili</option>
                            </select> --}}

                            <div class="mb-3">
                                <label class="form-label" for="kk">Template Surat<span
                                        style="color: red">*</span></label>
                                <input type="file" name="template" class="form-control" id="template"
                                    accept=".docx, .doc" required />
                            </div>

                            <button type="submit" class="btn btn-primary">Tambah</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
