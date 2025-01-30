<html lang="en" class="light-style customizer-hide" dir="ltr" data-theme="theme-default"
    data-assets-path="../assets/" data-template="vertical-menu-template-free">

    <head>
        <meta charset="utf-8" />
        <meta name="viewport"
            content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

        <title>Daftar | Cihurat</title>

        <meta name="description" content="" />

        <!-- Favicon -->
        <link rel="icon" type="image/x-icon" href="../assets/img/favicon/cidahu.svg" />

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link
            href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
            rel="stylesheet" />

        <!-- Icons. Uncomment required icon fonts -->
        <link rel="stylesheet" href="../assets/vendor/fonts/boxicons.css" />

        <!-- Core CSS -->
        <link rel="stylesheet" href="../assets/vendor/css/core.css" class="template-customizer-core-css" />
        <link rel="stylesheet" href="../assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
        <link rel="stylesheet" href="../assets/css/demo.css" />

        <!-- Vendors CSS -->
        <link rel="stylesheet" href="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

        <!-- Page CSS -->
        <!-- Page -->
        <link rel="stylesheet" href="../assets/vendor/css/pages/page-auth.css" />
        <!-- Helpers -->
        <script src="../assets/vendor/js/helpers.js"></script>

        <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
        <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
        <script src="../assets/js/config.js"></script>
    </head>

    <body>
        <!-- Content -->

        <div class="container-xxl">
            <div class="authentication-wrapper authentication-basic container-p-y">
                <div class="authentication-inner">
                    <!-- Register -->
                    <div class="card">
                        <div class="card-body">
                            <!-- Logo -->
                            <div class="app-brand justify-content-center">
                                <span class="app-brand-logo demo">
                                    <img src="../assets/img/favicon/cidahu.svg" class="img-fluid" style="height: 2rem;"
                                        alt="Cihurat Logo" />
                                </span>
                                <span class="app-brand-text demo text-body fw-bolder ms-2"
                                    style="text-transform:capitalize !important;">{{ env('APP_NAME') }}</span>
                            </div>
                            <!-- /Logo -->
                            <h4 class="mb-4">Daftar Akun</h4>

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form id="formRegister" class="mb-8" action="{{ route('register.store') }}"
                                method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email <span
                                            style="color: red">*</span></label>
                                    <input type="text" class="@error('email') is-invalid @enderror form-control"
                                        id="email" name="email" placeholder="Masukkan Email" autofocus required />
                                    @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="nomor_whatsapp" class="form-label">Nomor WhatsApp <span
                                            style="color: red">*</span></label>
                                    <input type="text"
                                        class="@error('nomor_whatsapp') is-invalid @enderror form-control"
                                        id="nomor_whatsapp" name="nomor_whatsapp" placeholder="Masukkan Nomor WhatsApp"
                                        required />
                                    @error('nomor_whatsapp')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="nik" class="form-label">NIK <span
                                            style="color: red">*</span></label>
                                    <input type="text" class="@error('nik') is-invalid @enderror form-control"
                                        id="nik" name="nik" placeholder="Masukkan NIK" required />
                                    @error('nik')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama Lengkap <span
                                            style="color: red">*</span></label>
                                    <input type="text" class="@error('nama') is-invalid @enderror form-control"
                                        id="nama" name="nama" placeholder="Masukkan Nama Lengkap" required />
                                    @error('nama')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="alamat" class="form-label">Alamat <span
                                            style="color: red">*</span></label>
                                    <input type="text" class="@error('alamat') is-invalid @enderror form-control"
                                        id="alamat" name="alamat" placeholder="Masukkan Alamat" required />
                                    @error('alamat')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="rt_rw" class="form-label">RT/RW <span
                                            style="color: red">*</span></label>
                                    <select name="rt_rw" class="form-control" id="rt_rw">
                                        <option value="" selected disabled>Pilih RT/RW</option>
                                        <option value="01/01">01/01</option>
                                        <option value="02/01">02/01</option>
                                        <option value="03/02">03/02</option>
                                        <option value="04/02">04/02</option>
                                        <option value="05/03">05/03</option>
                                        <option value="06/03">06/03</option>
                                        <option value="07/04">07/04</option>
                                        <option value="08/04">08/04</option>
                                    </select> @error('rt_rw')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-password-toggle mb-3">
                                    <div class="d-flex justify-content-between">
                                        <label class="form-label" for="password">Password <span
                                                style="color: red">*</span></label>
                                    </div>
                                    <div class="input-group input-group-merge">
                                        <input type="password" id="password"
                                            class="@error('password') is-invalid @enderror form-control"
                                            name="password"
                                            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                            aria-describedby="password" required />
                                        <span class="input-group-text cursor-pointer"><i
                                                class="bx bx-hide"></i></span>
                                        @error('password')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-password-toggle mb-3">
                                    <label for="password_confirmation" class="form-label">Konfirmasi Password <span
                                            style="color: red">*</span></label>
                                    <div class="input-group input-group-merge">
                                        <input type="password" id="password_confirmation" class="form-control"
                                            name="password_confirmation"
                                            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                            required />
                                        <span class="input-group-text cursor-pointer"><i
                                                class="bx bx-hide"></i></span>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <button class="d-grid w-100 btn btn-primary" type="submit">Daftar</button>
                                </div>

                                <p class="mt-6 text-center">
                                    Sudah punya akun? <a href="{{ route('login') }}"
                                        class="fw-bold text-primary">Masuk</a>
                                </p>

                                <!-- Tampilkan error general jika ada -->
                                @if ($errors->has('nomor_whatsapp'))
                                    <div class="alert-danger alert">
                                        {{ $errors->first('nomor_whatsapp') }}
                                    </div>
                                @endif
                            </form>
                        </div>
                    </div>
                    <!-- /Register -->
                </div>
            </div>
        </div>

        <!-- Core JS -->
        <!-- build:js assets/vendor/js/core.js -->
        <script src="../assets/vendor/libs/jquery/jquery.js"></script>
        <script src="../assets/vendor/libs/popper/popper.js"></script>
        <script src="../assets/vendor/js/bootstrap.js"></script>
        <script src="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

        <script src="../assets/vendor/js/menu.js"></script>
        <!-- endbuild -->

        <!-- Vendors JS -->

        <!-- Main JS -->
        <script src="../assets/js/main.js"></script>

        <!-- Page JS -->

        <!-- Place this tag in your head or just before your close body tag. -->
        <script async defer src="https://buttons.github.io/buttons.js"></script>
    </body>

</html>
