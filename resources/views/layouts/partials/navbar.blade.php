<header>
    <div class="topbar d-flex align-items-center">
        <nav class="navbar navbar-expand gap-3">
            <div class="topbar-logo-header d-none d-lg-flex">
                <div class="">
                    {{-- Menambahkan logo Polsri, Palembang, dan PUPR --}}
                    <img src="{{asset('assets')}}/images/polsri/logo-polsri.png" class="logo-icon" alt="Logo Polsri" style="margin-right: 10px;">
                    <img src="{{asset('assets')}}/images/polsri/logo-palembang.png" class="logo-icon" alt="Logo Palembang" style="margin-right: 10px;">
                    <img src="{{asset('assets')}}/images/polsri/logo-pupr.png" class="logo-icon" alt="Logo PUPR">
                </div>
                <div class="">
                    <h4 class="logo-text text-dark">SMART VILLAGE MONITORING SYSTEM </h4>
                </div>
            </div>
            <div class="mobile-toggle-menu d-block d-lg-none" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"><i class='bx bx-menu'></i></div>
             <h6 class="logo-text text-dark" style="font-size: 14px;">SISTEM PEMANTAUAN SUNGAI BERBASIS IoT DAN WEBSITE</h6>
              <div class="top-menu ms-auto">
                <ul class="navbar-nav align-items-center gap-1">
                    <li class="nav-item mobile-search-icon d-flex d-lg-none" data-bs-toggle="modal" data-bs-target="#SearchModal">
                        <a class="nav-link" href="avascript:;"><i class='bx bx-search'></i>
                        </a>
                    </li>
                    {{-- Bagian Notifikasi Alarm disembunyikan untuk saat ini --}}
                </ul>
            </div>

            {{-- Menambahkan pengecekan @auth untuk memastikan hanya user yang sudah login yang bisa melihat ini --}}
            @auth
            <div class="user-box dropdown px-3">
                <a class="d-flex align-items-center nav-link dropdown-toggle gap-3 dropdown-toggle-nocaret" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="{{asset('assets')}}/images/avatars/{{Auth::user()->avatar ?? 'user.png'}}" class="user-img" alt="user avatar">
                    <div class="user-info">
                        <p class="user-name mb-0">{{ucfirst(Auth::user()->name)}}</p>
                        <p class="designattion mb-0">Environment</p>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item d-flex align-items-center" href="{{route('users.show', Auth::user()->id)}}"><i class="bx bx-user fs-5"></i><span>Profile</span></a>
                    </li>
                    <li><a class="dropdown-item d-flex align-items-center" href="{{route('users.index')}}"><i class="bx bx-cog fs-5"></i><span>Settings</span></a>
                    </li>
                    </li>
                    <li>
                        <div class="dropdown-divider mb-0"></div>
                    </li>
                    <li><a class="dropdown-item d-flex align-items-center" href="javascript:;" onclick="logout()"><i class="bx bx-log-out-circle"></i><span>Logout</span></a>
                    </li>
                </ul>
            </div>
            @endauth

            {{-- Menambahkan tombol Login untuk pengguna yang belum login (tamu) --}}
            @guest
                <a href="{{ route('login') }}" class="btn btn-primary ms-3">Login</a>
            @endguest
        </nav>
    </div>
</header>