<?php
include 'koneksi.php';

$id = $_GET['id'] ?? '';

if ($id == '') {
    header("Location: data_peminjaman.php");
    exit;
}

$id = mysqli_real_escape_string($koneksi, $id);

$query = "DELETE FROM tb_peminjaman WHERE id = '$id'";

if (mysqli_query($koneksi, $query)) {
    header("Location: data_peminjaman.php");
    exit;
} else {
    echo "Gagal menghapus data: " . mysqli_error($koneksi);
}
?>