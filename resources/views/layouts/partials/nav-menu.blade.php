<nav class="navbar navbar-expand-lg align-items-center">
    <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
      <div class="offcanvas-body">
        <ul class="navbar-nav align-items-center flex-grow-1">
          {{-- ... (Menu Dashboard, Alarm, Pengaturan tetap sama) ... --}}
          <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="{{route('dashboard')}}">
                  <div class="parent-icon"><i class="fadeIn animated bx bx-tachometer"></i>
                  </div>
                  <div class="menu-title d-flex align-items-center">Dashboard</div>
              </a>
            </li>
          <li class="nav-item dropdown d-none">
              <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="javascript:;">
                  <div class="parent-icon"><i class="fadeIn animated bx bx-trending-up"></i>
                  </div>
                  <div class="menu-title d-flex align-items-center">Trending</div>
              </a>
            </li>
          <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="{{route('alarm.history')}}">
                  <div class="parent-icon"><i class="fadeIn animated bx bx-alarm"></i>
                  </div>
                  <div class="menu-title d-flex align-items-center">Alarm</div>
              </a>
            </li>
          <li class="nav-item dropdown d-none">
              <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="javascript:;">
                  <div class="parent-icon"><i class="fadeIn animated bx bx-server"></i>
                  </div>
                  <div class="menu-title d-flex align-items-center">API Logs</div>
              </a>
            </li>
          <li class="nav-item dropdown d-none">
              <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="javascript:;">
                  <div class="parent-icon"><i class="fadeIn animated bx bx-paper-plane"></i>
                  </div>
                  <div class="menu-title d-flex align-items-center">Republish Data</div>
              </a>
            </li>
          <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="{{route('settings.menu')}}">
                  <div class="parent-icon"><i class="fadeIn animated bx bx-wrench"></i>
                  </div>
                  <div class="menu-title d-flex align-items-center">Pengaturan</div>
              </a>
            </li>
          
          {{-- Kode untuk Manajemen User --}}
          <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="{{route('users.index')}}">
                  <div class="parent-icon"><i class="fadeIn animated bx bx-user-circle"></i>
                  </div>
                  <div class="menu-title d-flex align-items-center">Manajemen User</div>
              </a>
            </li>

          {{-- ▼▼▼ TEMPATKAN KODE BARU DI SINI (DI SAMPING MANAJEMEN USER) ▼▼▼ --}}
          <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="{{ route('trending.selection') }}">
                  <div class="parent-icon"><i class="fadeIn animated bx bx-line-chart"></i>
                  </div>
                  <div class="menu-title d-flex align-items-center">Grafik Historis</div>
              </a>
            </li>
          {{-- ▲▲▲ BATAS AKHIR KODE TAMBAHAN ▲▲▲ --}}
           
        </ul>
      </div>
    </div>
</nav>
