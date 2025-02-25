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
                                    style="text-transform:capitalize !important;">Cihurat</span>
                            </div>
                            <!-- /Logo -->
                            <h4>Daftar Akun</h4>
                            <p>
                                <i class="bx bx-info-circle icon-style"
                                    style="vertical-align: middle; margin-right: 5px;"></i>
                                Butuh bantuan? Baca <a href="#" class="text-primary">panduan pengguna</a>
                            </p>

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
                                <div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="email" class="form-label">Email <span
                                                        style="color: red">*</span></label>
                                                <input type="text"
                                                    class="@error('email') is-invalid @enderror form-control"
                                                    id="email" name="email" placeholder="Masukkan Email"
                                                    value="{{ old('email') }}" autofocus required />
                                            </div>

                                            <div class="mb-3">
                                                <label for="nomor_whatsapp" class="form-label">Nomor WhatsApp <span
                                                        style="color: red">*</span></label>
                                                <input type="text"
                                                    class="@error('nomor_whatsapp') is-invalid @enderror form-control"
                                                    id="nomor_whatsapp" name="nomor_whatsapp"
                                                    placeholder="Masukkan Nomor WhatsApp"
                                                    value="{{ old('nomor_whatsapp') }}" required maxlength="15"
                                                    inputmode="numeric" />
                                            </div>

                                            <div class="mb-3">
                                                <label for="nik" class="form-label">Nomor Induk Kependudukan (NIK)
                                                    <span style="color: red">*</span></label>
                                                <input type="text"
                                                    class="@error('nik') is-invalid @enderror form-control"
                                                    id="nik" name="nik" placeholder="Masukkan NIK"
                                                    value="{{ old('nik') }}" required maxlength="16"
                                                    inputmode="numeric" />
                                            </div>

                                            <div class="mb-3">
                                                <label for="nama" class="form-label">Nama Lengkap <span
                                                        style="color: red">*</span></label>
                                                <input type="text"
                                                    class="@error('nama') is-invalid @enderror form-control"
                                                    id="nama" name="nama" placeholder="Masukkan Nama Lengkap"
                                                    value="{{ old('nama') }}" required />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="alamat" class="form-label">Alamat <span
                                                        style="color: red">*</span></label>
                                                <input type="text"
                                                    class="@error('alamat') is-invalid @enderror form-control"
                                                    id="alamat" name="alamat" placeholder="Masukkan Alamat"
                                                    value="{{ old('alamat') }}" required />
                                            </div>

                                            <div class="mb-3">
                                                <label for="rt_rw" class="form-label">RT/RW <span
                                                        style="color: red">*</span></label>
                                                <select name="rt_rw" class="form-control" id="rt_rw">
                                                    <option value="" disabled
                                                        {{ old('rt_rw') == null ? 'selected' : '' }}>
                                                        Pilih RT/RW</option>
                                                    <option value="01/01"
                                                        {{ old('rt_rw') == '01/01' ? 'selected' : '' }}>01/01
                                                    </option>
                                                    <option value="02/01"
                                                        {{ old('rt_rw') == '02/01' ? 'selected' : '' }}>02/01
                                                    </option>
                                                    <option value="03/02"
                                                        {{ old('rt_rw') == '03/02' ? 'selected' : '' }}>03/02
                                                    </option>
                                                    <option value="04/02"
                                                        {{ old('rt_rw') == '04/02' ? 'selected' : '' }}>04/02
                                                    </option>
                                                    <option value="05/03"
                                                        {{ old('rt_rw') == '05/03' ? 'selected' : '' }}>05/03
                                                    </option>
                                                    <option value="06/03"
                                                        {{ old('rt_rw') == '06/03' ? 'selected' : '' }}>06/03
                                                    </option>
                                                    <option value="07/04"
                                                        {{ old('rt_rw') == '07/04' ? 'selected' : '' }}>07/04
                                                    </option>
                                                    <option value="08/04"
                                                        {{ old('rt_rw') == '08/04' ? 'selected' : '' }}>08/04
                                                    </option>
                                                </select>
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
                                                </div>
                                                <div class="mt-0" id="passwordError"></div>

                                            </div>

                                            <div class="form-password-toggle mb-3">
                                                <label for="password_confirmation" class="form-label">Konfirmasi
                                                    Password <span style="color: red">*</span></label>
                                                <div class="input-group input-group-merge">
                                                    <input type="password" id="password_confirmation"
                                                        class="form-control" name="password_confirmation"
                                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                                        aria-describedby="password_confirmation" required />
                                                    <span class="input-group-text cursor-pointer"><i
                                                            class="bx bx-hide"></i></span>
                                                </div>
                                                <div class="mt-0" id="passwordConfirmationError"></div>
                                            </div>
                                        </div>

                                        <div class="d-flex">
                                            <input type="checkbox" class="me-2" id="tnc" name="tnc"
                                                required>
                                            <label for="tnc"> Saya setuju dengan
                                                <a href="#" class="fw-bold text-primary" data-bs-toggle="modal"
                                                    data-bs-target="#tncModal">Syarat dan Ketentuan</a> yang berlaku
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="my-3">
                                    <button class="d-grid w-100 btn btn-primary" type="submit">Daftar</button>
                                </div>

                                <p class="mt-6 text-center">
                                    Sudah punya akun? <a href="{{ route('login') }}"
                                        class="fw-bold text-primary">Masuk</a>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- TNC Modal --}}
        <div class="modal fade" id="tncModal" tabindex="-1" aria-labelledby="tncModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Syarat dan Ketentuan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Dengan mendaftar sebagai warga di Cihurat, Anda setuju untuk mematuhi ketentuan dan
                            syarat berikut:</p>

                        <p class="fw-bold">1. Pendaftaran Warga</p>
                        <p>Pengguna yang mendaftar harus memberikan informasi yang benar, akurat, dan terkini. Data yang
                            diberikan akan digunakan untuk tujuan administratif dan tidak akan disalahgunakan tanpa izin
                            Anda.</p>

                        <p class="fw-bold">2. Kewajiban Pengguna</p>
                        <p>Setelah terdaftar, Anda setuju untuk:</p>
                        <ul>
                            <li>Menjaga kerahasiaan informasi akun Anda.</li>
                            <li>Memberikan informasi yang akurat pada formulir yang diminta oleh sistem.</li>
                            <li>Tidak melakukan penyalahgunaan layanan ini untuk tujuan yang melanggar hukum atau
                                merugikan pihak lain.</li>
                        </ul>

                        <p class="fw-bold">3. Penggunaan Data Pribadi</p>
                        <p>Data pribadi yang dikumpulkan selama proses pendaftaran akan digunakan untuk administrasi
                            warga dan kepentingan terkait lainnya. Kami berkomitmen untuk menjaga kerahasiaan data Anda
                            sesuai dengan kebijakan privasi yang berlaku.</p>

                        <p class="fw-bold">4. Penghentian Akun</p>
                        <p>Kami berhak untuk menangguhkan atau menghentikan akun pengguna yang melanggar ketentuan
                            ini tanpa pemberitahuan sebelumnya.</p>

                        <p class="fw-bold">5. Pembaruan Ketentuan</p>
                        <p>Ketentuan ini dapat diperbarui dari waktu ke waktu sesuai kebutuhan, dan pembaruan akan
                            diberitahukan kepada pengguna melalui website kami.</p>

                        <p class="fw-bold">6. Penerimaan Ketentuan</p>
                        <p>Dengan menyetujui pendaftaran, Anda mengkonfirmasi bahwa Anda telah membaca dan menyetujui
                            semua syarat dan ketentuan ini. Anda juga setuju untuk mematuhi semua kebijakan dan
                            peraturan yang berlaku.</p>

                        <p>Jika Anda setuju dengan syarat dan ketentuan di atas, Anda dapat melanjutkan ke halaman
                            pendaftaran.</p>

                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal"
                            aria-label="Close">Kembali</button>

                    </div>
                </div>
            </div>
        </div>

        <!-- Core JS -->
        <!-- build:js assets/vendor/js/core.js -->
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const form = document.getElementById("formRegister");
                const passwordField = document.getElementById("password");
                const confirmPasswordField = document.getElementById("password_confirmation");
                const errorDiv = document.getElementById("passwordConfirmationError");
                const passwordErrorDiv = document.getElementById("passwordError");


                function validatePasswords() {
                    if (confirmPasswordField.value !== passwordField.value) {
                        confirmPasswordField.classList.add("is-invalid");
                        errorDiv.textContent = "Konfirmasi password tidak cocok.";
                        errorDiv.style.color = "red";
                        return false;
                    } else {
                        confirmPasswordField.classList.remove("is-invalid");
                        errorDiv.textContent = "";
                        return true;
                    }
                }

                function validatePasswordLength() {
                    if (passwordField.value.length > 0 && passwordField.value.length < 8) {
                        passwordField.classList.add("is-invalid");
                        passwordErrorDiv.textContent = "Password minimal 8 karakter.";
                        passwordErrorDiv.style.color = "red";
                        return false;
                    } else {
                        passwordField.classList.remove("is-invalid");
                        passwordErrorDiv.textContent = "";
                        return true;
                    }
                }

                passwordField.addEventListener("input", function() {
                    validatePasswordLength();
                    if (passwordField.value.length > 0) {
                        confirmPasswordField.setAttribute("required", "required");
                    } else {
                        confirmPasswordField.removeAttribute("required");
                        confirmPasswordField.classList.remove("is-invalid");
                        errorDiv.textContent = "";
                    }
                });

                confirmPasswordField.addEventListener("input", validatePasswords);

                form.addEventListener("submit", function(event) {
                    if (!validatePasswordLength() || (passwordField.value.length > 0 && !validatePasswords())) {
                        event.preventDefault();
                    }
                });
            });
        </script>

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
