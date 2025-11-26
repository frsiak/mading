@extends('welcome')

@section('title', 'Login - Mading Digital')

@section('content')
<section class="section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="row">
                    <!-- Login Form -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body p-4">
                                <div class="text-center mb-4">
                                    <h2>Login</h2>
                                    <p class="text-muted">Masuk ke sistem mading digital</p>
                                </div>

                                @if(session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                                @endif

                                @if($errors->any())
                                <div class="alert alert-danger">
                                    {{ $errors->first() }}
                                </div>
                                @endif

                                <form action="{{ route('login') }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label">Username</label>
                                        <input type="text" name="username" class="form-control" placeholder="Masukkan username" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Password</label>
                                        <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100 mb-3">Login</button>
                                </form>
                                
                                <div class="text-center mb-3">
                                    <p class="text-muted">atau</p>
                                </div>
                                
                                <!-- Quick Login Button -->
                                <div class="text-center">
                                    <form action="{{ route('login') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="username" value="guru1">
                                        <input type="hidden" name="password" value="guru123">
                                        <button type="submit" class="btn btn-success">
                                            <i class="bi bi-mortarboard me-1"></i>Demo Guru
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Account Info -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body p-4">
                                <h5 class="mb-3"><i class="bi bi-info-circle me-2"></i>Akun Login</h5>
                                
                                <div class="mb-3">
                                    <h6 class="text-primary">👨🏫 Guru</h6>
                                    <p class="mb-1">Akses khusus untuk guru</p>
                                    <small class="text-muted">Verifikasi artikel siswa, menulis artikel</small>
                                </div>

                                <div class="mb-3">
                                    <h6 class="text-success">👨🎓 Siswa</h6>
                                    <p class="mb-1">Akun siswa dibuat oleh admin</p>
                                    <small class="text-muted">Menulis artikel, membaca, berkomentar</small>
                                </div>

                                <div class="alert alert-info">
                                    <i class="bi bi-lightbulb me-2"></i>
                                    <strong>Tips:</strong> Guru dapat mengelola artikel siswa, siswa dapat menulis artikel baru.
                                </div>
                                
                                <div class="alert alert-warning">
                                    <i class="bi bi-exclamation-triangle me-2"></i>
                                    <strong>Catatan:</strong> Hubungi administrator untuk mendapatkan akun baru.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection