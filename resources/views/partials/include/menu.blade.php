<ul class="menu-inner py-1">
    <!-- Dashboard -->
    <li class="menu-item {{ Route::is('dashboard') ? 'active' : '' }}">
        <a href="{{ route('dashboard') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-home"></i>
            <div data-i18n="Analytics">Dashboard</div>
        </a>
    </li>

    @if (Auth::user()->role == 'admin')
        <li class="menu-item {{ Route::is('admin.surat.index') ? 'active' : '' }}">
            <a href="{{ route('admin.surat.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-envelope"></i>
                <div data-i18n="Analytics">Kelola Surat</div>
            </a>
        </li>

        {{-- <li class="menu-item {{ Route::is('admin.template.upload') ? 'active' : '' }}">
            <a href="{{ route('admin.template.upload') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-upload"></i>
                <div data-i18n="Analytics">Kelola Template Surat</div>
            </a>
        </li> --}}

        <li class="menu-item {{ Route::is('rt.*') ? 'open active' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-group"></i>
                <div data-i18n="Account Settings">Kelola RT dan RW</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ Route::is('rt.index') ? 'active' : '' }}">
                    <a href="{{ route('rt.index') }}" class="menu-link">
                        <div data-i18n="Notifications">Data RT</div>
                    </a>
                </li>
                <li class="menu-item {{ Route::is('rw.index') ? 'active' : '' }}">
                    <a href="{{ route('rw.index') }}" class="menu-link">
                        <div data-i18n="Account">Data RW</div>
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
                <li class="menu-item {{ Route::is('admin.pengguna.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.pengguna.index') }}" class="menu-link">
                        <div data-i18n="Notifications">Data Pengguna</div>
                    </a>
                </li>
            </ul>
        </li>
    @elseif (Auth::user()->role == 'rt')
        <li class="menu-item {{ Route::is('verifikasi.index') ? 'active' : '' }}">
            <a href="{{ route('verifikasi.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-question-mark"></i>
                <div data-i18n="Analytics">Cek Pengajuan Surat</div>
            </a>
        </li>
        <li class="menu-item {{ Route::is('rt.pengguna.index') ? 'active' : '' }}">
            <a href="{{ route('rt.pengguna.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-group"></i>
                <div data-i18n="Analytics">Data Pengguna RT
                    @php
                        $rt_rw = Auth::user()->rt_rw;
                        $rt = explode('/', $rt_rw)[0];
                    @endphp
                    {{ $rt ?? '' }}
                </div>
            </a>
        </li>
    @elseif (Auth::user()->role == 'pengguna')
        <li class="menu-item {{ Route::is('surat.index') ? 'active' : '' }}">
            <a href="{{ route('surat.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-file"></i>
                <div data-i18n="Analytics">Pengajuan Surat</div>
            </a>
        </li>
        <li class="menu-item {{ Route::is('riwayat.index') ? 'active' : '' }}">
            <a href="{{ route('riwayat.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-history"></i>
                <div data-i18n="Analytics">Riwayat Pengajuan</div>
            </a>
        </li>
    @endif

    <li class="menu-header small text-uppercase">
        <span class="menu-header-text">Lainnya</span>
    </li>
    <li class="menu-item">
        @php
            $link =
                auth()->user()->role === 'pengguna'
                    ? 'https://shorturl.at/iu26r'
                    : (auth()->user()->role === 'rt'
                        ? 'https://shorturl.at/20whI'
                        : 'https://shorturl.at/Lo5Rk');
        @endphp
        <a href="{{ $link }}" class="menu-link" target="_blank">
            <i class="menu-icon tf-icons bx bx-info-circle"></i>
            <div data-i18n="Analytics">Panduan</div>
        </a>
        </a>
    </li>
</ul>
