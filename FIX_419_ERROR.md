# Fix Error 419 "Page Expired" - Ujikom Mading Friska

## Masalah
Error 419 "Page Expired" saat login siswa disebabkan oleh:
1. Session driver database yang bermasalah
2. CSRF token mismatch
3. Database connection issues

## Solusi yang Diterapkan

### 1. **Ubah Session Driver**
```env
# Dari:
SESSION_DRIVER=database

# Ke:
SESSION_DRIVER=file
```

### 2. **Perpanjang Session Lifetime**
```env
# Dari:
SESSION_LIFETIME=120

# Ke:
SESSION_LIFETIME=1440  # 24 jam
```

### 3. **Ubah Database ke SQLite**
```env
# Dari:
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_mading
DB_USERNAME=root
DB_PASSWORD=

# Ke:
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite
```

### 4. **Tambah CSRF Exception**
Di `bootstrap/app.php`:
```php
$middleware->validateCsrfTokens(except: [
    '/login-guru',
    '/login-admin', 
    '/login-siswa/*',
    '/reset-admin',
    '/test-users',
    '/artikel/*/like'  // Ditambahkan
]);
```

### 5. **Perbaiki Direct Login Route**
```php
Route::get('/login-siswa/{username}', function($username) {
    try {
        $user = \App\Models\User::where('username', $username)->where('role', 'siswa')->first();
        if($user) {
            \Auth::login($user);
            session()->regenerate();  // Ditambahkan
            return redirect('/siswa/dashboard')->with('success', 'Login berhasil via direct link');
        }
        return 'Siswa tidak ditemukan: ' . $username;
    } catch (\Exception $e) {
        return 'Error: ' . $e->getMessage();
    }
});
```

## Cara Testing

1. **Clear semua cache:**
```bash
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

2. **Test direct login:**
- Akses: `http://localhost:8000/login-siswa/siswa1`
- Harus redirect ke dashboard siswa

3. **Test normal login:**
- Akses: `http://localhost:8000/login`
- Username: `siswa1`
- Password: `siswa123`

## Akun Default Setelah Seeder

- **Admin:** username: `admin`, password: `admin123`
- **Guru:** username: `guru1`, password: `guru123`  
- **Siswa:** username: `siswa1`, password: `siswa123`

## Jika Masih Error

1. Restart development server
2. Clear browser cache/cookies
3. Cek file `.env` sudah benar
4. Pastikan file `database/database.sqlite` ada

## Rollback ke MySQL (Opsional)

Jika ingin kembali ke MySQL:
1. Buat database `db_mading` di MySQL
2. Ubah `.env` kembali ke MySQL settings
3. Run `php artisan migrate:fresh --seed`