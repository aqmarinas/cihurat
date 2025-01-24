<ul class="menu-inner py-1">
    <!-- Dashboard -->
    <li class="menu-item {{ Route::is('dashboard') ? 'active' : '' }}">
        <a href="{{ route('dashboard') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-home"></i>
            <div data-i18n="Analytics">Dashboard</div>
        </a>
    </li>

    @if (Auth::user()->role == 'admin')
        <li class="menu-item {{ Route::is('admin.surat') ? 'active' : '' }}">
            <a href="{{ route('admin.surat') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-envelope"></i>
                <div data-i18n="Analytics">Kelola Surat</div>
            </a>
        </li>

        <li class="menu-item {{ Route::is('rt.*') ? 'open active' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-group"></i>
                <div data-i18n="Account Settings">Kelola RT</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ Route::is('rt.index') ? 'active' : '' }}">
                    <a href="{{ route('rt.index') }}" class="menu-link">
                        <div data-i18n="Notifications">Daftar RT</div>
                    </a>
                </li>
                <li class="menu-item {{ Route::is('rt.create') ? 'active' : '' }}">
                    <a href="{{ route('rt.create') }}" class="menu-link">
                        <div data-i18n="Account">Tambah Akun Ketua RT</div>
                    </a>
                </li>
            </ul>
        </li>

        <li class="menu-item {{ Route::is('user.*') ? 'open active' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-group"></i>
                <div data-i18n="Account Settings">Kelola Pengguna</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ Route::is('pengguna.index') ? 'active' : '' }}">
                    <a href="{{ route('pengguna.index') }}" class="menu-link">
                        <div data-i18n="Notifications">Daftar Pengguna</div>
                    </a>
                </li>
            </ul>
        </li>
    @elseif (Auth::user()->role == 'rt')
        <li class="menu-item {{ Route::is('verifikasi.index') ? 'active' : '' }}">
            <a href="{{ route('verifikasi.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-question-mark"></i>
                <div data-i18n="Analytics">Verifikasi Pengajuan</div>
            </a>
        </li>
    @elseif (Auth::user()->role == 'pengguna')
        <li class="menu-item {{ Route::is('surat.index') ? 'active' : '' }}">
            <a href="{{ route('surat.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-file"></i>
                <div data-i18n="Analytics">Pengajuan Surat</div>
            </a>
        </li>
        <li class="menu-item {{ Route::is('pengguna.riwayat') ? 'active' : '' }}">
            <a href="{{ route('pengguna.riwayat') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-history"></i>
                <div data-i18n="Analytics">Riwayat Pengajuan</div>
            </a>
        </li>
    @endif

    <li class="menu-header small text-uppercase">
        <span class="menu-header-text">Lainnya</span>
    </li>
    <li class="menu-item {{ Route::is('panduan.index') ? 'active' : '' }}">
        <a href="{{ route('panduan.index') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-info-circle"></i>
            <div data-i18n="Analytics">Panduan</div>
        </a>
    </li>

    <li class="menu-header small text-uppercase">
        <span class="menu-header-text">Main</span>
    </li>
    <li class="menu-item {{ Route::is('course.*') || Route::is('content.*') ? 'open active' : '' }}">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons bx bx-book"></i>
            <div data-i18n="Account Settings">Kursus</div>
        </a>
        <ul class="menu-sub">
            <li class="menu-item {{ Route::is('course.create') ? 'active' : '' }}">
                <a href="{{ route('course.create') }}" class="menu-link">
                    <div data-i18n="Account">Pembuatan Surat</div>
                </a>
            </li>

            <li class="menu-item {{ Route::is('course.create') ? 'active' : '' }}">
                <a href="{{ route('course.create') }}" class="menu-link">
                    <div data-i18n="Account">Kursus</div>
                </a>
            </li>
            <li class="menu-item {{ Route::is('content.index') ? 'active' : '' }}">
                <a href="{{ route('content.index') }}" class="menu-link">
                    <div data-i18n="Notifications">Konten</div>
                </a>
            </li>
        </ul>
    </li>

    @if (Auth::user()->role == 'admin')
        <li class="menu-item {{ Route::is('kegiatan.*') ? 'open active' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-calendar-event"></i>
                <div data-i18n="Account Settings">Kegiatan</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ Route::is('kegiatan.create') ? 'active' : '' }}">
                    <a href="{{ route('kegiatan.create') }}" class="menu-link">
                        <div data-i18n="Account">Tambah Kegiatan</div>
                    </a>
                </li>
                <li class="menu-item {{ Route::is('kegiatan.index') ? 'active' : '' }}">
                    <a href="{{ route('kegiatan.index') }}" class="menu-link">
                        <div data-i18n="Notifications">Daftar Kegiatan</div>
                    </a>
                </li>
            </ul>
        </li>
        {{-- <li class="menu-item {{ Route::is('logo.*') ? 'open active' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-palette"></i>
                <div data-i18n="Account Settings">Logo</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ Route::is('logo.create') ? 'active' : '' }}">
                    <a href="{{ route('logo.create') }}" class="menu-link">
                        <div data-i18n="Account">Tambah Logo</div>
                    </a>
                </li>
                <li class="menu-item {{ Route::is('logo.index') ? 'active' : '' }}">
                    <a href="{{ route('logo.index') }}" class="menu-link">
                        <div data-i18n="Notifications">Daftar Logo</div>
                    </a>
                </li>
            </ul>
        </li> --}}
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Guru</span>
        </li>
        <li class="menu-item {{ Route::is('guru.*') ? 'open active' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-chalkboard"></i>
                <div data-i18n="Account Settings">Manajemen User</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ Route::is('guru.create') ? 'active' : '' }}">
                    <a href="{{ route('guru.create') }}" class="menu-link">
                        <div data-i18n="Account">Tambah Guru</div>
                    </a>
                </li>
                <li class="menu-item {{ Route::is('guru.index') ? 'active' : '' }}">
                    <a href="{{ route('guru.index') }}" class="menu-link">
                        <div data-i18n="Notifications">Daftar Guru</div>
                    </a>
                </li>
            </ul>
        </li>
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Siswa</span>
        </li>
        <li class="menu-item {{ Route::is('siswa.*') ? 'open active' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-user"></i>
                <div data-i18n="Account Settings">Manajemen User</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ Route::is('siswa.index') ? 'active' : '' }}">
                    <a href="{{ route('siswa.index') }}" class="menu-link">
                        <div data-i18n="Notifications">Daftar Siswa</div>
                    </a>
                </li>
            </ul>
        </li>
    @endif
</ul>
