<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Dashboard Guru</title>
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('guru.dashboard') }}">Dashboard Guru</a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="{{ route('home') }}">Lihat Situs</a>
                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <button class="btn btn-outline-light btn-sm">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2 bg-light p-3">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('guru.dashboard') }}">
                            <i class="bi bi-speedometer2"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('guru.tulis') }}">
                            <i class="bi bi-pencil"></i> Tulis Artikel
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('guru.kelola') }}">
                            <i class="bi bi-file-text"></i> Kelola Artikel
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('guru.verifikasi') }}">
                            <i class="bi bi-check-circle"></i> Verifikasi Artikel
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('guru.profil') }}">
                            <i class="bi bi-person"></i> Profil
                        </a>
                    </li>
                </ul>
            </div>
            <div class="col-md-10 p-4">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @yield('content')
            </div>
        </div>
    </div>
</body>
</html>