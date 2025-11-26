<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\{PublicController, LoginController, AdminController, GuruController, SiswaController, LikeController};

// Public routes
Route::get('/', function() {
    if (Auth::check()) {
        $user = Auth::user();
        if ($user->role === 'admin') {
            return redirect('/admin/dashboard');
        } elseif ($user->role === 'guru') {
            return redirect('/guru/dashboard');
        } else {
            return redirect('/siswa/dashboard');
        }
    }
    return app(PublicController::class)->home();
})->name('home');
Route::get('/artikel', [PublicController::class, 'artikel'])->name('artikel.index');
Route::get('/artikel/{id_artikel}', [PublicController::class, 'detail'])->name('artikel.detail');
Route::get('/artikel/{id_artikel}/download', [PublicController::class, 'download'])->name('artikel.download');

// Auth routes
Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout.get');

// Like route - accessible by all users (including guests)
Route::post('/artikel/{id}/like', [LikeController::class, 'toggle'])->name('artikel.like');

// Siswa routes
Route::middleware(['auth', 'role:siswa'])->group(function () {
    Route::get('/siswa', function() { return redirect('/siswa/dashboard'); });
    Route::get('/siswa/dashboard', [SiswaController::class, 'dashboard'])->name('siswa.dashboard');
    Route::get('/siswa/tulis', [SiswaController::class, 'tulis'])->name('siswa.tulis');
    Route::post('/siswa/store', [SiswaController::class, 'store'])->name('siswa.store');
    Route::get('/siswa/kelola', [SiswaController::class, 'kelola'])->name('siswa.kelola');
    Route::get('/siswa/edit/{id}', [SiswaController::class, 'edit'])->name('siswa.edit');
    Route::put('/siswa/update/{id}', [SiswaController::class, 'update'])->name('siswa.update');
    Route::delete('/siswa/delete/{id}', [SiswaController::class, 'delete'])->name('siswa.delete');
    Route::get('/siswa/baca', [SiswaController::class, 'baca'])->name('siswa.baca');
    Route::get('/siswa/detail/{id}', [SiswaController::class, 'detail'])->name('siswa.detail');
    Route::get('/siswa/preview/{id}', [SiswaController::class, 'preview'])->name('siswa.preview');
    Route::get('/siswa/download/{id}', [SiswaController::class, 'download'])->name('siswa.download');
});

// Admin routes - 5 fitur utama
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    // Kelola User
    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
    Route::post('/admin/users', [AdminController::class, 'createUser'])->name('admin.create-user');
    Route::delete('/admin/users/{id}', [AdminController::class, 'deleteUser'])->name('admin.delete-user');
    
    // Verifikasi Artikel
    Route::get('/admin/verifikasi', [AdminController::class, 'verifikasi'])->name('admin.verifikasi');
    Route::post('/admin/approve/{id}', [AdminController::class, 'approveArtikel'])->name('admin.approve');
    Route::post('/admin/reject/{id}', [AdminController::class, 'rejectArtikel'])->name('admin.reject');
    
    // Kelola Kategori
    Route::get('/admin/kategori', [AdminController::class, 'kategori'])->name('admin.kategori');
    Route::post('/admin/kategori', [AdminController::class, 'storeKategori'])->name('admin.store-kategori');
    Route::delete('/admin/kategori/{id}', [AdminController::class, 'deleteKategori'])->name('admin.delete-kategori');
    
    // Membuat Laporan
    Route::get('/admin/laporan', [AdminController::class, 'laporan'])->name('admin.laporan');
    Route::get('/admin/laporan/pdf', [AdminController::class, 'exportPDF'])->name('admin.laporan.pdf');
});

// Guru routes - 3 fitur utama
Route::middleware(['auth', 'role:guru'])->group(function () {
    Route::get('/guru/dashboard', [GuruController::class, 'dashboard'])->name('guru.dashboard');
    
    // Menulis artikel
    Route::get('/guru/tulis', [GuruController::class, 'tulis'])->name('guru.tulis');
    Route::post('/guru/store', [GuruController::class, 'store'])->name('guru.store');
    
    // Mengedit artikel milik guru
    Route::get('/guru/edit/{id}', [GuruController::class, 'edit'])->name('guru.edit');
    Route::put('/guru/update/{id}', [GuruController::class, 'update'])->name('guru.update');
    
    // Kelola artikel milik guru
    Route::get('/guru/kelola', [GuruController::class, 'kelola'])->name('guru.kelola');
    
    // Profil guru
    Route::get('/guru/profil', [GuruController::class, 'profil'])->name('guru.profil');
    
    // Menyetujui artikel siswa
    Route::get('/guru/verifikasi', [GuruController::class, 'verifikasi'])->name('guru.verifikasi');
    Route::post('/guru/approve/{id}', [GuruController::class, 'approve'])->name('guru.approve');
    Route::post('/guru/reject/{id}', [GuruController::class, 'reject'])->name('guru.reject');
    
    // Download artikel guru
    Route::get('/guru/download/{id}', [GuruController::class, 'download'])->name('guru.download');
    
    // Detail artikel untuk verifikasi
    Route::get('/guru/detail/{id}', [GuruController::class, 'detail'])->name('guru.detail');
});

// Authenticated user routes (for commenting)
Route::middleware(['auth'])->group(function () {
    // Comment route - accessible by all authenticated users
    Route::post('/artikel/{id}/comment', [SiswaController::class, 'comment'])->name('artikel.comment');
    // Delete comment route - accessible by all authenticated users (with authorization check in controller)
    Route::delete('/comments/{komentar}', [AdminController::class, 'deleteComment'])->name('comment.delete');
});

// Test routes
Route::get('/test-users', function() {
    $users = \App\Models\User::all();
    $output = "<h3>Daftar User:</h3>";
    foreach($users as $user) {
        $output .= "<p>ID: {$user->id_user} | Username: {$user->username} | Nama: {$user->nama} | Role: {$user->role}</p>";
    }
    return $output;
});

Route::get('/test-artikel', function() {
    $artikel = \App\Models\Artikel::with(['user', 'kategori'])->get();
    $output = "<h3>Daftar Artikel:</h3>";
    foreach($artikel as $art) {
        $output .= "<p>ID: {$art->id_artikel} | Judul: {$art->judul} | Status: {$art->status} | Penulis: {$art->user->nama}</p>";
    }
    return $output;
});

Route::get('/reset-admin', function() {
    $admin = \App\Models\User::where('username', 'admin')->first();
    if($admin) {
        $admin->password = \Hash::make('admin123');
        $admin->save();
        return 'Password admin berhasil direset ke: admin123';
    }
    return 'User admin tidak ditemukan';
});

// Login langsung untuk testing
Route::get('/login-admin', function() {
    $admin = \App\Models\User::where('username', 'admin')->first();
    if($admin) {
        \Auth::login($admin);
        return redirect('/admin/dashboard');
    }
    return 'Admin tidak ditemukan';
});

Route::get('/login-siswa/{username}', function($username) {
    try {
        $user = \App\Models\User::where('username', $username)->where('role', 'siswa')->first();
        if($user) {
            \Auth::login($user);
            session()->regenerate();
            return redirect('/siswa/dashboard')->with('success', 'Login berhasil via direct link');
        }
        return 'Siswa tidak ditemukan: ' . $username;
    } catch (\Exception $e) {
        return 'Error: ' . $e->getMessage();
    }
});

Route::get('/login-guru', function() {
    try {
        $guru = \App\Models\User::where('username', 'guru1')->first();
        if($guru) {
            \Auth::login($guru);
            session()->regenerate();
            return redirect('/guru/dashboard')->with('success', 'Login berhasil via direct link');
        }
        return 'Guru tidak ditemukan';
    } catch (\Exception $e) {
        return 'Error: ' . $e->getMessage();
    }
});

// Test PDF route
Route::get('/test-pdf/{id}', function($id) {
    try {
        $artikel = \App\Models\Artikel::with(['user', 'kategori'])
            ->where('id_artikel', $id)
            ->firstOrFail();
            
        return view('pdf.artikel', compact('artikel'));
    } catch (\Exception $e) {
        return 'Error: ' . $e->getMessage();
    }
});

// Debug login route
Route::get('/test-login-debug', function() {
    return view('test-login-debug');
});
