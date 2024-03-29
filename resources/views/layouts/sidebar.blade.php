<div class="app-sidebar colored">
  <div class="sidebar-header">
    <a class="header-brand" href="{{ route('home') }}">
      <div class="logo-img">
        <img src="{{ $logo }}" class="header-brand-img" alt="" style="width: 100%">
      </div>
      <span class="text">Buku Tamu</span>
    </a>
    <button type="button" class="nav-toggle"><i data-toggle="expanded" class="ik ik-toggle-right toggle-icon"></i></button>
    <button id="sidebarClose" class="nav-close"><i class="ik ik-x"></i></button>
  </div>

  <div class="sidebar-content">
    <div class="nav-container">
      <nav id="main-menu-navigation" class="navigation-main">
        <div class="nav-lavel">DATA TAMU</div>
        <div class="nav-item{{ Request::url()==route('home')?' active':'' }}">
          <a href="{{ route('home') }}"><i class="ik ik-bar-chart-2"></i><span>Beranda</span></a>
        </div>
        <div class="nav-item{{ stripos(Request::url(),route('guest.index'))!==false?' active':'' }}">
          <a href="{{ route('guest.index') }}"><i class="ik ik-users"></i><span>Data Tamu</span></a>
        </div>
        <div class="nav-lavel">PENGATURAN</div>
        @if (auth()->user()->role == 'admin')
          <div class="nav-item{{ stripos(Request::url(),route('instansi.index'))!==false?' active':'' }}">
            <a href="{{ route('instansi.index') }}"><i class="fas fa-building"></i><span>Pengaturan Instansi</span></a>
          </div>
          <div class="nav-item{{ stripos(Request::url(),route('users.index'))!==false?' active':'' }}">
            <a href="{{ route('users.index') }}"><i class="fas fa-user-tie"></i><span>Pengaturan Pengguna</span></a>
          </div>
        @endif
        <div class="nav-item{{ Request::url()==route('configs')?' active':'' }}">
          <a href="{{ route('configs') }}"><i class="ik ik-settings"></i><span>Pengaturan Sistem</span></a>
        </div>
        <div class="nav-item">
          <a href="{{ route('logout') }}"><i class="ik ik-power"></i><span>Keluar</span></a>
        </div>
      </nav>
    </div>
  </div>
</div>
