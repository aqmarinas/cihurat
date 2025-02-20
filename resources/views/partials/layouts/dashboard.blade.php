@extends('partials.layouts.app')

@section('title', 'Dashboard')

@section('container')
    <style>
        .hover-card {
            transition: transform 0.3s, box-shadow 0.3s;
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            background-color: #f8f9fa;
        }

        .hover-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        .icon-style {
            font-size: 60px;
            margin-bottom: 10px;
            color: #ffffff;
            padding: 20px;
            border-radius: 50%;
        }

        .icon-style.bx-file {
            background-color: #28a745;
        }

        .icon-style.bx-user {
            background-color: #6f42c1;
            /* Purple for teachers */
        }

        .icon-style.bx-user-pin {
            background-color: maroon;
            /* Purple for teachers */
        }

        .icon-style.bx-group {
            background-color: #17a2b8;
            /* Teal for students */
        }

        .card-title {
            margin-bottom: 5px;
        }

        .card-text {
            font-size: 24px;
            font-weight: bold;
        }
    </style>

    <div class="container-xxl flex-grow-1 container-p-y">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="row">
            <div class="col-lg-12 order-0 mb-4">
                <div class="card">
                    <div class="d-flex align-items-center row">
                        <div class="col-sm-7">
                            <div class="card-body">
                                <h5 class="card-title text-primary">Selamat datang, {{ Auth::user()->nama }}!</h5>
                                @if (Auth::user()->role == 'rt')
                                    @php
                                        $rt_rw = Auth::user()->rt_rw;
                                        $rt = explode('/', $rt_rw)[0];
                                    @endphp
                                    <p class="fw-bold text-secondary">Ketua RT {{ $rt ?? '' }}</p>
                                    <p class="mt-2">Cek pengajuan surat <a href="{{ route('verifikasi.index') }}"
                                            class="text-primary fw-bold">di
                                            sini</a></p>
                                @endif
                                @if (Auth::user()->role == 'pengguna')
                                    <p class="mt-2">Ajukan surat <a href="{{ route('surat.index') }}"
                                            class="text-primary fw-bold">di
                                            sini</a></p>
                                @endif

                            </div>
                        </div>
                        <div class="col-sm-5 text-sm-left text-center">
                            <div class="card-body px-md-4 px-0 pb-0">
                                <img src="../assets/img/illustrations/man-with-laptop-light.png" height="140"
                                    alt="View Badge User" data-app-dark-img="illustrations/man-with-laptop-dark.png"
                                    data-app-light-img="illustrations/man-with-laptop-light.png" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Dashboard -->
            {{-- User --}}
            @if (Auth::user()->role == 'pengguna')
                <div class="col-lg-4 mb-4">
                    <a href="{{ route('riwayat.index') }}" class="card hover-card text-decoration-none text-center">
                        <div class="card-body">
                            <i class="bx bx-check-circle icon-style"
                                style="background-color: #28a745; padding: 12px; border-radius: 100%;"></i>
                            <h5 class="card-title">Total Surat Disetujui</h5>
                            <p class="card-text">{{ $totalSuratDisetujuiUser ?? '0' }}</p>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 mb-4">
                    <a href="{{ route('riwayat.index') }}" class="card hover-card text-decoration-none text-center">
                        <div class="card-body">
                            <i class="bx bx-time icon-style"
                                style="background-color: #ffc107; padding: 12px; border-radius: 100%;"></i>
                            <h5 class="card-title">Total Surat Menunggu </h5>
                            <p class="card-text">{{ $totalSuratMenungguUser ?? '0' }}</p>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 mb-4">
                    <a href="{{ route('riwayat.index') }}" class="card hover-card text-decoration-none text-center">
                        <div class="card-body">
                            <i class="bx bx-file icon-style"
                                style="background-color: #007bff; padding: 12px; border-radius: 100%;"></i>
                            <h5 class="card-title">Total Surat Diajukan</h5>
                            <p class="card-text">{{ $totalSuratDiajukanUser ?? '0' }}</p>
                        </div>
                    </a>
                </div>
            @endif

            {{-- RT --}}
            @if (Auth::user()->role == 'rt')
                <div class="col-lg-4 mb-4">
                    <a href="{{ route('verifikasi.index', ['status' => 'menunggu']) }}"
                        class="card hover-card text-decoration-none text-center">
                        <div class="card-body">
                            <i class="bx bx-time icon-style"
                                style="background-color: #ffc107; padding: 12px; border-radius: 100%;"></i>
                            <h5 class="card-title">Total Surat Menunggu </h5>
                            <p class="card-text">{{ $totalSuratMenungguRT ?? '0' }}</p>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 mb-4">
                    <a href="{{ route('verifikasi.index') }}" class="card hover-card text-decoration-none text-center">
                        <div class="card-body">
                            <i class="bx bx-file icon-style"
                                style="background-color: #007bff; padding: 12px; border-radius: 100%;"></i>
                            <h5 class="card-title">Total Surat Diajukan</h5>
                            <p class="card-text">{{ $totalSuratDiajukanRT ?? '0' }}</p>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 mb-4">
                    <a href="{{ route('rt.pengguna.index') }}" class="card hover-card text-decoration-none text-center">
                        <div class="card-body">
                            <i class="bx bx-group icon-style"
                                style="background-color: #6f42c1; padding: 12px; border-radius: 100%;"></i>
                            @php
                                $rt_rw = Auth::user()->rt_rw;
                                $rt = explode('/', $rt_rw)[0];
                            @endphp

                            <h5 class="card-title">Total Pengguna RT {{ $rt ?? '' }}</h5>
                            <p class="card-text">{{ $totalWargaRT ?? '0' }}</p>
                        </div>
                    </a>
                </div>
        </div>
        @endif

        {{-- Admin --}}
        @if (Auth::user()->role == 'admin')
            <div class="col-lg-4 mb-4">
                <a href="{{ route('admin.surat.index', ['status' => 'disetujui']) }}"
                    class="card hover-card text-decoration-none text-center">
                    <div class="card-body">
                        <i class="bx bx-check-circle icon-style"
                            style="background-color: #28a745; padding: 12px; border-radius: 100%;"></i>
                        <h5 class="card-title">Total Surat Disetujui</h5>
                        <p class="card-text">{{ $totalSuratDisetujuiAdmin ?? '0' }}</p>
                    </div>
                </a>
            </div>
            <div class="col-lg-4 mb-4">
                <a href="{{ route('admin.surat.index') }}" class="card hover-card text-decoration-none text-center">
                    <div class="card-body">
                        <i class="bx bx-file icon-style"
                            style="background-color: #007bff; padding: 12px; border-radius: 100%;"></i>
                        <h5 class="card-title">Total Surat Diajukan</h5>
                        <p class="card-text">{{ $totalSuratDiajukanAdmin ?? '0' }}</p>
                    </div>
                </a>
            </div>
            <div class="col-lg-4 mb-4">
                <a href="{{ route('admin.pengguna.index') }}" class="card hover-card text-decoration-none text-center">
                    <div class="card-body">
                        <i class="bx bx-group icon-style" style="padding: 12px; border-radius: 100%;"></i>
                        <h5 class="card-title">Total Pengguna</h5>
                        <p class="card-text">{{ $totalUsers ?? '0' }}</p>
                    </div>
                </a>
            </div>
    </div>
    @endif

    </div>
    </div>
@endsection
