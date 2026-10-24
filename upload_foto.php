<?php

$folder = "uploads/";

if (!is_dir($folder)) {
    mkdir($folder, 0777, true);
}

$data = file_get_contents("php://input");

if ($data === false || strlen($data) == 0) {
    echo "FOTO TIDAK ADA";
    exit;
}

$nama_file = "kembali_" . date("Ymd_His") . "_" . uniqid() . ".jpg";

$target = $folder . $nama_file;

if (file_put_contents($target, $data) !== false) {
    echo $nama_file;
} else {
    echo "GAGAL MENYIMPAN FOTO";
}

?>