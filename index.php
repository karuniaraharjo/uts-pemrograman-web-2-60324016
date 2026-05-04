<?php
// Konfigurasi database
require_once 'config/database.php';

// Query: ambil semua data kategori, terbaru di atas
$sql = "SELECT * FROM kategori ORDER BY id_kategori DESC";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die('Gagal menyiapkan query: ' . $conn->error);
}
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Kategori - UTS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Daftar Kategori Buku</h2>
            <a href="create.php" class="btn btn-primary">Tambah Kategori</a>
        </div>

        <!-- Pesan sukses/error -->
        <?php if (isset($_GET['message'])): ?>
            <?php $type = (isset($_GET['type']) && $_GET['type'] === 'success') ? 'success' : 'danger'; ?>
            <div class="alert alert-<?php echo htmlspecialchars($type); ?>"><?php echo htmlspecialchars($_GET['message']); ?></div>
        <?php endif; ?>

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
                        $no = 1;
                        while ($row = $result->fetch_assoc()):
                        ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td><?php echo htmlspecialchars($row['kode_kategori']); ?></td>
                                <td><?php echo htmlspecialchars($row['nama_kategori']); ?></td>
                                <td><?php echo nl2br(htmlspecialchars($row['deskripsi'])); ?></td>
                                <td>
                                    <?php if ($row['status'] === 'Aktif'): ?>
                                        <span class="badge bg-success">Aktif</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">Nonaktif</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="edit.php?id=<?php echo $row['id_kategori']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                    <button onclick="confirmDelete(<?php echo $row['id_kategori']; ?>)" class="btn btn-danger btn-sm">Hapus</button>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                        <?php $stmt->close(); ?>
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