@extends('admin.layouts.app')

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

        .icon-style.bx-book {
            background-color: #007bff;
        }

        .icon-style.bx-file {
            background-color: #28a745;
        }

        .icon-style.bx-calendar-event {
            background-color: #ffc107;
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
        <div class="row">
            <div class="col-lg-12 order-0 mb-4">
                <div class="card">
                    <div class="d-flex align-items-center row">
                        <div class="col-sm-7">
                            <div class="card-body">
                                <h5 class="card-title text-primary">Selamat datang, {{ Auth::user()->nama }}!</h5>
                                @if (Auth::user()->role == 'rt')
                                    <p>Ketua RT/RW {{ Auth::user()->rt_rw }}</p>
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
                    <div class="card hover-card text-center">
                        <div class="card-body">
                            <i class="bx bx-check-circle icon-style"
                                style="background-color: #28a745; padding: 12px; border-radius: 100%;"></i>
                            <h5 class="card-title">Total Surat Disetujui</h5>
                            <p class="card-text">{{ $totalSuratDisetujuiUser }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-4">
                    <div class="card hover-card text-center">
                        <div class="card-body">
                            <i class="bx bx-time icon-style"
                                style="background-color: #ffc107; padding: 12px; border-radius: 100%;"></i>
                            <h5 class="card-title">Total Surat Menunggu Disetujui </h5>
                            <p class="card-text">{{ $totalSuratMenungguUser }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-4">
                    <div class="card hover-card text-center">
                        <div class="card-body">
                            <i class="bx bx-file icon-style"
                                style="background-color: #007bff; padding: 12px; border-radius: 100%;"></i>
                            <h5 class="card-title">Total Surat Diajukan</h5>
                            <p class="card-text">{{ $totalSuratDiajukanUser }}</p>
                        </div>
                    </div>
                </div>
            @endif

            {{-- RT --}}
            @if (Auth::user()->role == 'rt')
                <div class="col-lg-4 mb-4">
                    <div class="card hover-card text-center">
                        <div class="card-body">
                            <i class="bx bx-time icon-style"
                                style="background-color: #ffc107; padding: 12px; border-radius: 100%;"></i>
                            <h5 class="card-title">Total Surat Menunggu Disetujui </h5>
                            <p class="card-text">{{ $totalSuratMenungguRT }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-4">
                    <div class="card hover-card text-center">
                        <div class="card-body">
                            <i class="bx bx-file icon-style"
                                style="background-color: #007bff; padding: 12px; border-radius: 100%;"></i>
                            <h5 class="card-title">Total Surat Diajukan</h5>
                            <p class="card-text">{{ $totalSuratDiajukanRT }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-4">
                    <div class="card hover-card text-center">
                        <div class="card-body">
                            <i class="bx bx-group icon-style"
                                style="background-color: #6f42c1; padding: 12px; border-radius: 100%;"></i>
                            <h5 class="card-title">Total Warga RT [nama RT]</h5>
                            <p class="card-text">{{ $totalWargaRT }}</p>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Admin --}}
            @if (Auth::user()->role == 'admin')
                <div class="col-lg-4 mb-4">
                    <div class="card hover-card text-center">
                        <div class="card-body">
                            <i class="bx bx-check-circle icon-style"
                                style="background-color: #28a745; padding: 12px; border-radius: 100%;"></i>
                            <h5 class="card-title">Total Surat Disetujui</h5>
                            <p class="card-text">{{ $totalSuratDisetujuiAdmin }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-4">
                    <div class="card hover-card text-center">
                        <div class="card-body">
                            <i class="bx bx-time icon-style"
                                style="background-color: red; padding: 12px; border-radius: 100%;"></i>
                            <h5 class="card-title">Total Surat Ditolak </h5>
                            <p class="card-text">{{ $totalSuratDitolakAdmin }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-4">
                    <div class="card hover-card text-center">
                        <div class="card-body">
                            <i class="bx bx-file icon-style"
                                style="background-color: #007bff; padding: 12px; border-radius: 100%;"></i>
                            <h5 class="card-title">Total Surat Diajukan</h5>
                            <p class="card-text">{{ $totalSuratDiajukanAdmin }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-4">
                    <div class="card hover-card text-center">
                        <div class="card-body">
                            <i class="bx bx-user icon-style"></i>
                            <h5 class="card-title">Total Admin</h5>
                            <p class="card-text">{{ $totalAdmin }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-4">
                    <div class="card hover-card text-center">
                        <div class="card-body">
                            <i class="bx bx-user-pin icon-style"></i>
                            <h5 class="card-title">Total RT</h5>
                            <p class="card-text">{{ $totalRt }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-4">
                    <div class="card hover-card text-center">
                        <div class="card-body">
                            <i class="bx bx-group icon-style"></i>
                            <h5 class="card-title">Total Users</h5>
                            <p class="card-text">{{ $totalUsers }}</p>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>
@endsection
