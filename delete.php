<?php
require_once 'config/database.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: index.php?message=' . urlencode('ID tidak valid.') . '&type=error');
    exit;
}
$id = (int)$_GET['id'];

// Cek keberadaan data
$checkSql = 'SELECT id_kategori FROM kategori WHERE id_kategori = ?';
$checkStmt = $conn->prepare($checkSql);
if (!$checkStmt) {
    header('Location: index.php?message=' . urlencode('Query gagal.') . '&type=error');
    exit;
}
$checkStmt->bind_param('i', $id);
$checkStmt->execute();
$res = $checkStmt->get_result();
if ($res->num_rows === 0) {
    $checkStmt->close();
    header('Location: index.php?message=' . urlencode('Data tidak ditemukan.') . '&type=error');
    exit;
}
$checkStmt->close();

// Delete
$delSql = 'DELETE FROM kategori WHERE id_kategori = ?';
$delStmt = $conn->prepare($delSql);
if (!$delStmt) {
    header('Location: index.php?message=' . urlencode('Gagal menyiapkan query delete.') . '&type=error');
    exit;
}
$delStmt->bind_param('i', $id);
$delStmt->execute();
if ($delStmt->affected_rows > 0) {
    $delStmt->close();
    header('Location: index.php?message=' . urlencode('Kategori berhasil dihapus.') . '&type=success');
    exit;
} else {
    $delStmt->close();
    header('Location: index.php?message=' . urlencode('Gagal menghapus kategori.') . '&type=error');
    exit;
}
