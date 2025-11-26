<nav id="navmenu" class="navmenu">
  <ul>
    <li><a href="{{ route('home') }}">Home</a></li>
    <li><a href="{{ route('artikel.index') }}">Artikel</a></li>
    
    @if(Auth::check())
      @if(Auth::user()->role === 'admin')
        <li><a href="{{ route('admin.dashboard') }}">Dashboard Admin</a></li>
      @elseif(Auth::user()->role === 'guru')
        <li><a href="{{ route('guru.dashboard') }}">Dashboard Guru</a></li>
      @else
        <li><a href="{{ route('siswa.dashboard') }}">Dashboard Siswa</a></li>
      @endif
      
      <li>
        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
          @csrf
          <button type="submit" style="background: none; border: none; color: inherit; font: inherit; cursor: pointer; padding: 18px 15px;" onclick="return confirm('Yakin ingin logout?')">Logout</button>
        </form>
      </li>
    @else
      <li><a href="{{ route('login') }}">Login</a></li>
    @endif
  </ul>
  <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
</nav>