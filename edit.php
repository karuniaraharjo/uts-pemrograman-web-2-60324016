<?php
require_once 'config/database.php';

// Ambil ID dari GET
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: index.php?message=' . urlencode('ID tidak valid.') . '&type=error');
    exit;
}
$id = (int)$_GET['id'];

// Retrieve data berdasarkan ID
$selectSql = 'SELECT id_kategori, kode_kategori, nama_kategori, deskripsi, status FROM kategori WHERE id_kategori = ?';
$selectStmt = $conn->prepare($selectSql);
if (!$selectStmt) {
    die('Gagal menyiapkan query: ' . $conn->error);
}
$selectStmt->bind_param('i', $id);
$selectStmt->execute();
$res = $selectStmt->get_result();
if ($res->num_rows === 0) {
    header('Location: index.php?message=' . urlencode('Data tidak ditemukan.') . '&type=error');
    exit;
}
$data = $res->fetch_assoc();
$selectStmt->close();

$errors = [];
$kode = $data['kode_kategori'];
$nama = $data['nama_kategori'];
$deskripsi = $data['deskripsi'];
$status = $data['status'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kode = trim($_POST['kode'] ?? '');
    $nama = trim($_POST['nama'] ?? '');
    $deskripsi = trim($_POST['deskripsi'] ?? '');
    $status = ($_POST['status'] ?? 'Aktif') === 'Nonaktif' ? 'Nonaktif' : 'Aktif';

    // Validasi kode
    if ($kode === '') {
        $errors[] = 'Kode Kategori wajib diisi.';
    } else {
        if (strlen($kode) < 4 || strlen($kode) > 10) {
            $errors[] = 'Panjang Kode Kategori harus 4-10 karakter.';
        }
        if (strpos($kode, 'KAT-') !== 0) {
            $errors[] = 'Kode harus diawali dengan "KAT-".';
        }
    }

    // Validasi nama
    if ($nama === '') {
        $errors[] = 'Nama Kategori wajib diisi.';
    } else {
        if (strlen($nama) < 3 || strlen($nama) > 50) {
            $errors[] = 'Nama Kategori harus 3-50 karakter.';
        }
    }

    // Deskripsi
    if ($deskripsi !== '' && strlen($deskripsi) > 200) {
        $errors[] = 'Deskripsi maksimal 200 karakter.';
    }

    // Cek duplikasi kode kecuali self
    if (empty($errors)) {
        $checkSql = 'SELECT COUNT(*) as cnt FROM kategori WHERE kode_kategori = ? AND id_kategori != ?';
        $checkStmt = $conn->prepare($checkSql);
        if (!$checkStmt) {
            $errors[] = 'Gagal menyiapkan query pengecekan duplikat.';
        } else {
            $checkStmt->bind_param('si', $kode, $id);
            $checkStmt->execute();
            $res2 = $checkStmt->get_result()->fetch_assoc();
            if ($res2 && $res2['cnt'] > 0) {
                $errors[] = 'Kode Kategori sudah digunakan oleh data lain.';
            }
            $checkStmt->close();
        }
    }

    // Update jika tidak ada error
    if (empty($errors)) {
        $updateSql = 'UPDATE kategori SET kode_kategori = ?, nama_kategori = ?, deskripsi = ?, status = ? WHERE id_kategori = ?';
        $updateStmt = $conn->prepare($updateSql);
        if (!$updateStmt) {
            $errors[] = 'Gagal menyiapkan query update: ' . $conn->error;
        } else {
            $updateStmt->bind_param('ssssi', $kode, $nama, $deskripsi, $status, $id);
            if ($updateStmt->execute()) {
                $updateStmt->close();
                header('Location: index.php?message=' . urlencode('Kategori berhasil diupdate.') . '&type=success');
                exit;
            } else {
                $errors[] = 'Gagal melakukan update: ' . $updateStmt->error;
            }
            $updateStmt->close();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Edit Kategori - UTS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4>Edit Kategori</h4>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($errors)): ?>
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    <?php foreach ($errors as $e): ?>
                                        <li><?php echo htmlspecialchars($e); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <form method="POST">
                            <div class="mb-3">
                                <label class="form-label">Kode Kategori</label>
                                <input type="text" name="kode" class="form-control" required value="<?php echo htmlspecialchars($kode); ?>">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Nama Kategori</label>
                                <input type="text" name="nama" class="form-control" required value="<?php echo htmlspecialchars($nama); ?>">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Deskripsi</label>
                                <textarea name="deskripsi" class="form-control" rows="4"><?php echo htmlspecialchars($deskripsi); ?></textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="status" id="s1" value="Aktif" <?php echo ($status === 'Aktif') ? 'checked' : ''; ?>>
                                        <label class="form-check-label" for="s1">Aktif</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="status" id="s2" value="Nonaktif" <?php echo ($status === 'Nonaktif') ? 'checked' : ''; ?>>
                                        <label class="form-check-label" for="s2">Nonaktif</label>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">Update</button>
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