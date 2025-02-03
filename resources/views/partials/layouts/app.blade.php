<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default"
    data-assets-path="../assets/" data-template="vertical-menu-template-free">

    <head>
        @include('partials.include.head')
    </head>

    <body>
        <!-- Layout wrapper -->
        <div class="layout-wrapper layout-content-navbar">
            <div class="layout-container">
                <!-- Menu -->

                <aside id="layout-menu" class="layout-menu bg-menu-theme menu menu-vertical">
                    <div class="app-brand demo">
                        <img src="{{ asset('assets/img/favicon/cidahu.svg') }}" class="img-fluid" style="height: 2rem;"
                            alt="Cidahu Logo" />
                        <span class="app-brand-text demo text-body fw-bolder ms-2"
                            style="text-transform:capitalize !important;">Cihurat</span>

                        <a href="javascript:void(0);"
                            class="layout-menu-toggle menu-link text-large d-block d-xl-none ms-auto">
                            <i class="bx bx-chevron-left bx-sm align-middle"></i>
                        </a>
                    </div>

                    <div class="menu-inner-shadow"></div>

                    @include('partials.include.menu')
                </aside>
                <!-- / Menu -->

                <!-- Layout container -->
                <div class="layout-page">
                    <!-- Navbar -->

                    <nav class="layout-navbar container-xxl navbar-expand-xl navbar-detached align-items-center bg-navbar-theme navbar"
                        id="layout-navbar">
                        @include('partials.include.navbar')
                    </nav>

                    <!-- / Navbar -->

                    <!-- Content wrapper -->
                    <div class="content-wrapper">
                        <!-- Content -->

                        @yield('container')
                        <!-- / Content -->

                        <!-- Footer -->
                        <footer class="content-footer bg-footer-theme footer">
                            @include('partials.include.footer')
                        </footer>
                        <!-- / Footer -->

                        <div class="content-backdrop fade"></div>
                    </div>
                    <!-- Content wrapper -->
                </div>
                <!-- / Layout page -->
            </div>

            <!-- Overlay -->
            <div class="layout-overlay layout-menu-toggle"></div>
        </div>
        <!-- / Layout wrapper -->

        <!-- Core JS -->
        <!-- build:js assets/vendor/js/core.js -->
        @include('partials.include.script')
    </body>

</html>
