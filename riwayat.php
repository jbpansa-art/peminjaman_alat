<?php
include 'koneksi.php';

$query = "SELECT nis, nama, alat, status, waktu, tanggal_kembali
          FROM tb_peminjaman
          ORDER BY waktu DESC";

$result = mysqli_query($koneksi, $query);

$data = [];

while ($row = mysqli_fetch_assoc($result)) {
    $data[] =
        $row['nis'] . " - " .
        $row['nama'] . " - " .
        $row['alat'] . " - Status: " .
        $row['status'];
}

header('Content-Type: application/json');
echo json_encode($data);
?>