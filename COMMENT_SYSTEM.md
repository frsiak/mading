# Sistem Komentar - Ujikom Mading Friska

## Fitur Komentar yang Telah Ditambahkan

### 1. **Menampilkan Komentar**
- Komentar ditampilkan di halaman detail artikel (public dan siswa)
- Menampilkan nama penulis, waktu posting, dan isi komentar
- Komentar diurutkan berdasarkan tanggal terbaru
- Jumlah komentar ditampilkan di header section dan info artikel

### 2. **Menambah Komentar**
- User yang login dapat menambahkan komentar
- Form komentar tersedia di halaman detail artikel
- Validasi: komentar minimal 3 karakter, maksimal 500 karakter
- Guest user akan diminta login untuk berkomentar

### 3. **Menghapus Komentar**
- **Admin**: Dapat menghapus semua komentar
- **Guru**: Dapat menghapus semua komentar  
- **Pemilik komentar**: Dapat menghapus komentar sendiri
- Konfirmasi sebelum menghapus komentar

### 4. **Tampilan dan UX**
- Desain responsif dengan Bootstrap
- Hover effect pada komentar
- Scrollable area jika komentar banyak (max-height: 500px)
- Icon dan styling yang konsisten dengan tema aplikasi
- Alert success setelah berhasil menambah/hapus komentar

## Struktur Database

### Tabel `komentar`
```sql
- id_komentar (Primary Key)
- id_artikel (Foreign Key ke artikel)
- id_user (Foreign Key ke users)
- komentar (Text)
- tanggal (DateTime)
```

## Routes yang Tersedia

```php
// Menambah komentar (authenticated users)
POST /artikel/{id}/comment

// Menghapus komentar (admin, guru, atau pemilik)
DELETE /comments/{komentar}
```

## Model Relationships

### Artikel Model
```php
public function komentar()
{
    return $this->hasMany(Komentar::class, 'id_artikel', 'id_artikel')
           ->orderBy('tanggal', 'desc');
}
```

### Komentar Model
```php
public function artikel()
{
    return $this->belongsTo(Artikel::class, 'id_artikel', 'id_artikel');
}

public function user()
{
    return $this->belongsTo(User::class, 'id_user', 'id_user');
}
```

## Halaman yang Mendukung Komentar

1. **Public Detail** (`/artikel/{id}`)
   - Semua user dapat melihat komentar
   - User login dapat menambah komentar
   - Guest diminta login untuk berkomentar

2. **Siswa Detail** (`/siswa/detail/{id}`)
   - Siswa dapat melihat dan menambah komentar
   - Siswa dapat menghapus komentar sendiri

## Keamanan

- CSRF protection pada form komentar
- Authorization untuk menghapus komentar
- Input validation dan sanitization
- Role-based access control

## Testing

Untuk testing sistem komentar:

1. Jalankan seeder untuk membuat sample komentar:
```bash
php artisan db:seed --class=KomentarSeeder
```

2. Login sebagai user berbeda (admin, guru, siswa)
3. Buka halaman detail artikel
4. Test menambah dan menghapus komentar

## Fitur Tambahan yang Bisa Dikembangkan

- Reply/balasan komentar (nested comments)
- Like/dislike pada komentar
- Moderasi komentar oleh admin
- Notifikasi komentar baru
- Edit komentar
- Report komentar yang tidak pantas