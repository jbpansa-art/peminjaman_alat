<?php

$koneksi = mysqli_connect(
    "localhost",
    "root",
    "",
    "db_peminjaman_alat"
);

if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>