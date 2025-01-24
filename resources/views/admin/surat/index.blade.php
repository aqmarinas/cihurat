@extends('admin.layouts.app')

@section('title', 'Course')

@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="m-8">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
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

            {{-- @if ($errors->has('error'))
                <div class="alert alert-danger">
                    {{ $errors->first('error') }}
                </div>
            @endif --}}

            <div class="row">
                @foreach ($letters as $letter)
                    <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                        <div class="card h-100 d-flex flex-column">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title flex-grow-0">{{ $letter->name }}</h5>
                                <p class="card-text flex-grow-1">{{ $letter->description }}</p>
                                <div class="d-grid mt-auto">
                                    <a href="{{ route('surat.create', $letter->id) }}" class="btn btn-primary">Buat
                                        Surat</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
