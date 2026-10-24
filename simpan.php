<?php
include 'koneksi.php';

$nis = $_POST['nis'] ?? '';
$nama = $_POST['nama'] ?? '';
$alamat = $_POST['alamat'] ?? '';
$alat = $_POST['alat'] ?? '';
$keperluan = $_POST['keperluan'] ?? '';
$foto = $_POST['foto'] ?? '';
$latitude = $_POST['latitude'] ?? '';
$longitude = $_POST['longitude'] ?? '';

if ($nis == '' || $nama == '' || $alat == '') {
    echo "DATA TIDAK LENGKAP";
    exit;
}

$query = "INSERT INTO tb_peminjaman
(
    nis,
    nama,
    alamat,
    alat,
    keperluan,
    foto,
    latitude,
    longitude
)
VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = mysqli_prepare($koneksi, $query);

if (!$stmt) {
    echo "QUERY ERROR: " . mysqli_error($koneksi);
    exit;
}

mysqli_stmt_bind_param(
    $stmt,
    "ssssssss",
    $nis,
    $nama,
    $alamat,
    $alat,
    $keperluan,
    $foto,
    $latitude,
    $longitude
);

if (mysqli_stmt_execute($stmt)) {

    echo "DATA PEMINJAMAN BERHASIL DISIMPAN\n";
    echo "Latitude: " . $latitude . "\n";
    echo "Longitude: " . $longitude;

} else {

    echo "GAGAL MENYIMPAN DATA\n";
    echo mysqli_stmt_error($stmt);

}

mysqli_stmt_close($stmt);
mysqli_close($koneksi);
?>