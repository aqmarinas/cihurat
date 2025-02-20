<div class="layout-menu-toggle navbar-nav align-items-xl-center me-xl-0 d-xl-none me-3">
    <a class="nav-item nav-link me-xl-4 px-0" href="javascript:void(0)">
        <i class="bx bx-menu bx-sm"></i>
    </a>
</div>

<div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
    <!-- Search -->
    {{-- <div class="navbar-nav align-items-center">
        <div class="nav-item d-flex align-items-center">
            <i class="bx bx-search fs-4 lh-0"></i>
            <input type="text" class="form-control border-0 shadow-none" placeholder="Search..."
                aria-label="Search..." />
        </div>
    </div> --}}
    <!-- /Search -->

    <ul class="navbar-nav align-items-center ms-auto flex-row">
        <!-- Place this tag where you want the button to render. -->
        <!-- User -->
        <style>
            .avatar img {
                width: 40px;
                /* pastikan width dan height sama */
                height: 40px;
                border-radius: 50%;
                /* membuat bulat sempurna */
                object-fit: cover;
                /* memastikan gambar terpotong dengan proporsi yang baik */
                aspect-ratio: 1 / 1;
                /* membuat gambar tetap persegi */
            }
        </style>
        <li class="nav-item navbar-dropdown dropdown-user dropdown">
            <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                <div class="avatar avatar-online">
                    <img src="{{ asset('assets/img/avatars/default.jpg') }}" alt=""
                        class="w-px-40 rounded-circle h-auto" />
                </div>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
                <li>
                    <a class="dropdown-item" href="#">
                        <div class="d-flex">
                            <div class="me-3 flex-shrink-0">
                                <div class="avatar avatar-online">
                                    <img src="{{ asset('assets/img/avatars/default.jpg') }}" alt
                                        class="w-px-40 rounded-circle h-auto" />
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <span class="fw-semibold d-block text-truncate"
                                    style="max-width: 150px;">{{ Auth::user()->nama }}</span>
                                <small class="text-muted text-capitalize">
                                    @if (Auth::user()->role == 'rt')
                                        @php
                                            $rt_rw = Auth::user()->rt_rw;
                                            $rt = explode('/', $rt_rw)[0];
                                        @endphp

                                        Ketua RT {{ $rt ?? '' }}
                                    @else
                                        {{ Auth::user()->role }}
                                    @endif
                                </small>
                            </div>
                        </div>
                    </a>
                </li>
                <li>
                    <div class="dropdown-divider"></div>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('profile.edit') }}">
                        <i class="bx bx-user me-2"></i>
                        <span class="align-middle">Profil</span>
                    </a>
                </li>
                <li>
                </li>
                <li>
                    <form id="logoutForm" action="{{ route('logout') }}" method="POST">
                        @csrf
                        <a href="javascript:void(0);" id="logoutButton" class="dropdown-item">
                            <i class="bx bx-power-off me-2"></i>
                            <span class="align-middle">Keluar</span>
                        </a>
                    </form>
                </li>
            </ul>
        </li>
        <!--/ User -->
    </ul>
</div>

<script>
    document.getElementById('logoutButton').addEventListener('click', function(e) {
        e.preventDefault(); // Mencegah form logout langsung dieksekusi

        Swal.fire({
            text: "Apakah Anda yakin ingin keluar?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3435',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Keluar',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('logoutForm').submit(); // Submit form jika dikonfirmasi
            }
        });
    });
</script>
