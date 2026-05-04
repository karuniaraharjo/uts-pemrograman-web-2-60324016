# SISTEM MANAJEMEN KATEGORI BUKU

- Nama: Karunia Raharjo
- NIM: 60324016

## Deskripsi singkat:
Sistem sederhana untuk mengelola kategori buku (CRUD) menggunakan PHP + MySQL dan Bootstrap untuk UI.

## Cara instalasi & menjalankan:
1. Letakkan folder `uts-60324016` di dalam `htdocs` XAMPP (misal `c:\xampp\htdocs\uts-60324016`).
2. Buat database MySQL dengan nama `uts_perpustakaan_60324016` (atau ganti di `config/database.php`).
3. Buat tabel `kategori` dengan SQL berikut:

```sql
CREATE TABLE kategori (
    id_kategori INT AUTO_INCREMENT PRIMARY KEY,
    kode_kategori VARCHAR(10) UNIQUE NOT NULL,
    nama_kategori VARCHAR(50) NOT NULL,
    deskripsi TEXT,
    status ENUM('Aktif', 'Nonaktif') DEFAULT 'Aktif',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

4. Akses aplikasi melalui browser: `http://localhost/uts-60324016/`.

Struktur folder:
uts_60324016/
- config/
  - database.php
- index.php
- create.php
- edit.php
- delete.php
- README.md

Link repository GitHub: https://github.com/karuniaraharjo/uts-pemrograman-web-2-60324016