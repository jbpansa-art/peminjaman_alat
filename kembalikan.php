<?php
include 'koneksi.php';

// Menerima data dari App Inventor
$nis = $_POST['nis'] ?? '';
$nama = $_POST['nama'] ?? '';
$alat = $_POST['alat'] ?? '';
$kondisi = $_POST['kondisi'] ?? '';
$foto_kembali = $_POST['foto_kembali'] ?? '';
$latitude_kembali = $_POST['latitude_kembali'] ?? '';
$longitude_kembali = $_POST['longitude_kembali'] ?? '';

// Cek data wajib
if ($nis == '' || $alat == '') {
    echo "DATA TIDAK LENGKAP";
    exit;
}

// Update data peminjaman
$query = "UPDATE tb_peminjaman
          SET status = 'Dikembalikan',
              tanggal_kembali = NOW(),
              foto_kembali = ?,
              kondisi_kembali = ?,
              latitude_kembali = ?,
              longitude_kembali = ?
          WHERE nis = ?
          AND alat = ?
          AND status = 'Dipinjam'
          LIMIT 1";

$stmt = mysqli_prepare($koneksi, $query);

if (!$stmt) {
    echo "GAGAL MENYIAPKAN QUERY";
    exit;
}

mysqli_stmt_bind_param(
    $stmt,
    "ssssss",
    $foto_kembali,
    $kondisi,
    $latitude_kembali,
    $longitude_kembali,
    $nis,
    $alat
);

if (mysqli_stmt_execute($stmt)) {

    if (mysqli_stmt_affected_rows($stmt) > 0) {
        echo "PEMINJAMAN BERHASIL DIKEMBALIKAN";
    } else {
        echo "DATA PEMINJAMAN TIDAK DITEMUKAN";
    }

} else {
    echo "GAGAL MEMPROSES PENGEMBALIAN";
}

mysqli_stmt_close($stmt);
mysqli_close($koneksi);
?>