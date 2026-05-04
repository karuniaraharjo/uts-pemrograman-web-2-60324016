# SISTEM MANAJEMEN KATEGORI BUKU

# BAGIAN 2: READ - TAMPILKAN DAFTAR KATEGORI (20 Poin)
Buat file index.php yang menampilkan semua data kategori dalam bentuk tabel.

Spesifikasi:
A. Query Data (5 poin)
SELECT semua data kategori
ORDER BY id_kategori DESC (terbaru di atas)
Gunakan prepared statement (wajib untuk keamanan)

B. Tampilan Tabel (12 poin)
Header tabel: No, Kode, Nama Kategori, Deskripsi, Status, Aksi
Data ditampilkan dalam tabel Bootstrap
Nomor urut dimulai dari 1
Status ditampilkan dengan badge:
Aktif: badge hijau (bg-success)
Nonaktif: badge merah (bg-danger)

C. Tombol Aksi (3 poin)
Tombol Edit (warna kuning/warning)
Tombol Hapus (warna merah/danger) dengan konfirmasi JavaScript
Template Code:

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Kategori - UTS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php
    require_once 'config/database.php';
    
    // TODO: Query data kategori
    // TODO: Cek hasil query
    ?>
    
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Daftar Kategori Buku</h2>
            <a href="create.php" class="btn btn-primary">Tambah Kategori</a>
        </div>
        
        <!-- TODO: Tampilkan pesan sukses/error jika ada -->
        
        <div class="card">
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th width="50">No</th>
                            <th width="100">Kode</th>
                            <th>Nama Kategori</th>
                            <th>Deskripsi</th>
                            <th width="100">Status</th>
                            <th width="150">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // TODO: Loop data dan tampilkan
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <script>
    function confirmDelete(id) {
        if (confirm('Yakin ingin menghapus kategori ini?')) {
            window.location.href = 'delete.php?id=' + id;
        }
    }
    </script>
</body>
</html>

Kriteria Penilaian:
Query benar dan menggunakan prepared statement (5 poin)
Data tampil dalam tabel dengan benar (8 poin)
Badge status dengan warna yang tepat (4 poin)
Tombol aksi berfungsi (3 poin)

# BAGIAN 3: CREATE - TAMBAH KATEGORI BARU (25 Poin)
Buat file create.php untuk menambah kategori baru.

Spesifikasi:
A. Form Input (8 poin)

Field yang harus ada:

Kode Kategori (text, required)
Nama Kategori (text, required)
Deskripsi (textarea, optional)
Status (radio button: Aktif/Nonaktif, default: Aktif)
B. Validasi Server-Side (10 poin)

Validasi yang harus diimplementasikan:

Kode Kategori:

Wajib diisi
Panjang 4-10 karakter
Format: harus diawali "KAT-" (validasi dengan regex atau substr)
Tidak boleh duplikat (cek ke database)
Nama Kategori:

Wajib diisi
Minimal 3 karakter
Maksimal 50 karakter
Deskripsi:

Opsional (boleh kosong)
Jika diisi, maksimal 200 karakter
Status:

Harus Aktif atau Nonaktif
C. Proses Insert (7 poin)

Gunakan prepared statement (wajib)
Sanitasi input dengan htmlspecialchars() dan trim()
Jika berhasil: redirect ke index.php dengan pesan sukses
Jika gagal: tampilkan error dan keep form value
Template Code:

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Kategori - UTS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php
    require_once 'config/database.php';
    
    $errors = [];
    $kode = '';
    $nama = '';
    $deskripsi = '';
    $status = 'Aktif';
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // TODO: Ambil dan sanitasi data dari form
        
        // TODO: Validasi kode kategori
        
        // TODO: Validasi nama kategori
        
        // TODO: Validasi deskripsi
        
        // TODO: Cek duplikasi kode
        
        // TODO: Jika tidak ada error, insert data
        
        // TODO: Redirect jika berhasil
    }
    ?>
    
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4>Tambah Kategori Baru</h4>
                    </div>
                    <div class="card-body">
                        <!-- TODO: Tampilkan error jika ada -->
                        
                        <form method="POST">
                            <!-- TODO: Form fields -->
                            
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <a href="index.php" class="btn btn-secondary">Kembali</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
Kriteria Penilaian:

Form lengkap dengan semua field (8 poin)
Validasi benar untuk semua field (10 poin)
Insert berhasil dengan prepared statement (5 poin)
Redirect dan pesan sukses (2 poin)

# BAGIAN 4: UPDATE - EDIT KATEGORI (20 Poin)
Buat file edit.php untuk mengubah data kategori.

Spesifikasi:
A. Retrieve Data (5 poin)

Ambil data berdasarkan id_kategori dari parameter GET
Validasi: cek apakah ID ada di database
Jika tidak ada, redirect ke index.php dengan pesan error
B. Form Edit (5 poin)

Form yang sama dengan create.php
Pre-fill form dengan data yang sudah ada
Semua field dapat diedit
C. Validasi (5 poin)

Validasi sama dengan CREATE
Khusus kode_kategori: cek duplikasi, tapi exclude record yang sedang diedit
WHERE kode_kategori = ? AND id_kategori != ?
D. Proses Update (5 poin)

Gunakan prepared statement
UPDATE berdasarkan id_kategori
Redirect dengan pesan sukses jika berhasil
Template Code:

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Kategori - UTS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php
    require_once 'config/database.php';
    
    // TODO: Ambil ID dari GET
    
    // TODO: Retrieve data berdasarkan ID
    
    // TODO: Jika POST, proses update
    
    ?>
    
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4>Edit Kategori</h4>
                    </div>
                    <div class="card-body">
                        <!-- TODO: Form dengan data pre-filled -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
Kriteria Penilaian:

Data berhasil diambil dan ditampilkan di form (5 poin)
Form pre-filled dengan benar (5 poin)
Validasi duplikasi exclude self (5 poin)
Update berhasil dengan prepared statement (5 poin)

# BAGIAN 5: DELETE - HAPUS KATEGORI (10 Poin)
Buat file delete.php untuk menghapus kategori.

Spesifikasi:
A. Validasi ID (3 poin)

Cek apakah parameter id ada
Cek apakah ID valid dan ada di database
B. Proses Delete (5 poin)

Gunakan prepared statement
DELETE berdasarkan id_kategori
Cek affected_rows untuk memastikan berhasil
C. Redirect (2 poin)

Redirect ke index.php dengan pesan sukses/error
Template Code:

<?php
require_once 'config/database.php';
 
// TODO: Validasi ID dari GET
 
// TODO: Cek keberadaan data
 
// TODO: Delete data
 
// TODO: Redirect dengan pesan
?>
Kriteria Penilaian:

Validasi ID benar (3 poin)
Delete berhasil dengan prepared statement (5 poin)
Redirect dengan pesan yang tepat (2 poin)

# BAGIAN 6: STRUKTUR KODE & UI (10 Poin)
A. Struktur Folder (3 poin)
uts_[NIM]/
├── config/
│   └── database.php
├── index.php
├── create.php
├── edit.php
└── delete.php
B. Code Quality (4 poin)
Indentasi konsisten
Penamaan variabel jelas
Komentar pada bagian penting
Tidak ada code yang tidak terpakai
C. User Interface (3 poin)
Menggunakan Bootstrap dengan baik
Layout rapi dan responsive
Pesan sukses/error jelas
Navigasi mudah dipahami

## Tambahkan file README.md yang berisi(diisi data dummy):
Nama dan NIM 
Deskripsi singkat aplikasi
Cara instalasi dan menjalankan aplikasi
Struktur folder
Link repository GitHub