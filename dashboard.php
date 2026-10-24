<?php
include 'koneksi.php';

$query = "SELECT * FROM tb_peminjaman ORDER BY waktu DESC";
$result = mysqli_query($koneksi, $query);

// Statistik
$total = mysqli_num_rows($result);

$queryDipinjam = mysqli_query(
    $koneksi,
    "SELECT COUNT(*) AS jumlah FROM tb_peminjaman WHERE status='Dipinjam'"
);
$dipinjam = mysqli_fetch_assoc($queryDipinjam)['jumlah'];

$queryKembali = mysqli_query(
    $koneksi,
    "SELECT COUNT(*) AS jumlah FROM tb_peminjaman WHERE status='Dikembalikan'"
);
$dikembalikan = mysqli_fetch_assoc($queryKembali)['jumlah'];
?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Dashboard SIPAT</title>

<style>

* {
    box-sizing: border-box;
}

body {
    margin: 0;
    font-family: Arial, Helvetica, sans-serif;
    background: #f4f6f9;
    color: #1f2937;
}


/* ================= SIDEBAR ================= */

.sidebar {
    position: fixed;
    left: 0;
    top: 0;
    width: 230px;
    height: 100vh;
    background: #172554;
    color: white;
    padding: 25px 18px;
}

.logo {
    font-size: 24px;
    font-weight: bold;
    margin-bottom: 5px;
}

.logo-sub {
    font-size: 12px;
    color: #bfdbfe;
    margin-bottom: 35px;
}

.menu-title {
    font-size: 11px;
    color: #93c5fd;
    margin-bottom: 10px;
    text-transform: uppercase;
}

.menu {
    display: block;
    padding: 12px 14px;
    margin-bottom: 8px;
    border-radius: 8px;
    color: white;
    text-decoration: none;
    background: rgba(255,255,255,0.08);
}

.menu:hover {
    background: rgba(255,255,255,0.15);
}


/* ================= MAIN ================= */

.main {
    margin-left: 230px;
    padding: 30px;
}


/* ================= HEADER ================= */

.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 25px;
}

.header h1 {
    margin: 0;
    font-size: 27px;
}

.header p {
    margin: 6px 0 0;
    color: #6b7280;
}


/* ================= CARD ================= */

.cards {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 18px;
    margin-bottom: 25px;
}

.card {
    padding: 22px;
    border-radius: 12px;
    box-shadow: 0 3px 12px rgba(0,0,0,0.06);
    transition: 0.2s;
}

.card:hover {
    transform: translateY(-3px);
}


/* TOTAL DATA */

.card-total {
    background: #dbeafe;
    border-left: 5px solid #2563eb;
}

.card-total .card-title {
    color: #1d4ed8;
}

.card-total .card-number {
    color: #1e40af;
}


/* SEDANG DIPINJAM */

.card-pinjam {
    background: #ffedd5;
    border-left: 5px solid #f97316;
}

.card-pinjam .card-title {
    color: #c2410c;
}

.card-pinjam .card-number {
    color: #9a3412;
}


/* SUDAH DIKEMBALIKAN */

.card-kembali {
    background: #dcfce7;
    border-left: 5px solid #22c55e;
}

.card-kembali .card-title {
    color: #15803d;
}

.card-kembali .card-number {
    color: #166534;
}


.card-title {
    font-size: 14px;
    font-weight: bold;
}

.card-number {
    font-size: 30px;
    font-weight: bold;
    margin-top: 8px;
}


/* ================= TABLE ================= */

.table-box {
    background: white;
    border-radius: 12px;
    padding: 22px;
    box-shadow: 0 3px 12px rgba(0,0,0,0.06);
}

.table-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 18px;
}

.table-header h2 {
    margin: 0;
    font-size: 20px;
}

.table-wrapper {
    overflow-x: auto;
}

table {
    width: 100%;
    border-collapse: collapse;
    min-width: 1200px;
}

th {
    background: #eff6ff;
    color: #1e3a8a;
    padding: 13px;
    text-align: center;
    font-size: 13px;
}

td {
    padding: 12px;
    border-bottom: 1px solid #e5e7eb;
    text-align: center;
    font-size: 13px;
}

tr:hover {
    background: #f8fafc;
}


/* ================= STATUS ================= */

.status {
    padding: 6px 10px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: bold;
}

.dipinjam {
    background: #fef3c7;
    color: #92400e;
}

.dikembalikan {
    background: #dcfce7;
    color: #166534;
}


/* ================= BUTTON ================= */

.btn-print {
    background: #2563eb;
    color: white;
    padding: 9px 15px;
    border-radius: 7px;
    text-decoration: none;
    font-size: 13px;
}

.btn-print:hover {
    background: #1d4ed8;
}


/* ================= RESPONSIVE ================= */

@media (max-width: 900px) {

    .sidebar {
        width: 190px;
    }

    .main {
        margin-left: 190px;
    }

    .cards {
        grid-template-columns: 1fr;
    }

}

</style>

</head>

<body>


<!-- ================= SIDEBAR ================= -->

<div class="sidebar">

    <div class="logo">
        SIPAT
    </div>

    <div class="logo-sub">
        Sistem Peminjaman Alat Sekolah
    </div>

    <div class="menu-title">
        Menu Utama
    </div>

    <a href="dashboard.php" class="menu">
        🏠 Dashboard
    </a>

    <a href="data_peminjaman.php" class="menu">
        📋 Data Peminjaman
    </a>

</div>


<!-- ================= MAIN ================= -->

<div class="main">


    <!-- HEADER -->

    <div class="header">

        <div>

            <h1>
                Dashboard
            </h1>

            <p>
                Rekap data peminjaman dan pengembalian alat sekolah
            </p>

        </div>

        <a href="#" onclick="window.print()" class="btn-print">
            🖨 Cetak
        </a>

    </div>


    <!-- ================= STATISTIK ================= -->

    <div class="cards">


        <!-- TOTAL DATA -->

        <div class="card card-total">

            <div class="card-title">
                Total Data
            </div>

            <div class="card-number">
                <?= $total; ?>
            </div>

        </div>


        <!-- SEDANG DIPINJAM -->

        <div class="card card-pinjam">

            <div class="card-title">
                Sedang Dipinjam
            </div>

            <div class="card-number">
                <?= $dipinjam; ?>
            </div>

        </div>


        <!-- SUDAH DIKEMBALIKAN -->

        <div class="card card-kembali">

            <div class="card-title">
                Sudah Dikembalikan
            </div>

            <div class="card-number">
                <?= $dikembalikan; ?>
            </div>

        </div>

    </div>


    <!-- ================= DATA PEMINJAMAN ================= -->

    <div class="table-box">

        <div class="table-header">

            <h2>
                Data Peminjaman
            </h2>

        </div>


        <div class="table-wrapper">

            <table>

                <thead>

                    <tr>

                        <th>No</th>
                        <th>NIS</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>Alat</th>
                        <th>Keperluan</th>
                        <th>Tanggal Pinjam</th>
                        <th>Status</th>
                        <th>Tanggal Kembali</th>
                        <th>Kondisi</th>
                        <th>Lokasi Pinjam</th>
                        <th>Lokasi Kembali</th>

                    </tr>

                </thead>


                <tbody>

                <?php

                $no = 1;

                while ($row = mysqli_fetch_assoc($result)) {

                ?>

                    <tr>

                        <td>
                            <?= $no++; ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($row['nis']); ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($row['nama']); ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($row['alamat']); ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($row['alat']); ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($row['keperluan']); ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($row['waktu']); ?>
                        </td>

                        <td>

                            <?php if ($row['status'] == 'Dipinjam') { ?>

                                <span class="status dipinjam">
                                    Dipinjam
                                </span>

                            <?php } else { ?>

                                <span class="status dikembalikan">
                                    Dikembalikan
                                </span>

                            <?php } ?>

                        </td>


                        <td>

                            <?php

                            if ($row['tanggal_kembali']) {

                                echo htmlspecialchars(
                                    $row['tanggal_kembali']
                                );

                            } else {

                                echo "-";

                            }

                            ?>

                        </td>


                        <td>

                            <?php

                            if ($row['kondisi_kembali']) {

                                echo htmlspecialchars(
                                    $row['kondisi_kembali']
                                );

                            } else {

                                echo "-";

                            }

                            ?>

                        </td>


                        <td>

                            <?= htmlspecialchars($row['latitude']); ?>

                            <br>

                            <?= htmlspecialchars($row['longitude']); ?>

                        </td>


                        <td>

                            <?php

                            if ($row['latitude_kembali']) {

                                echo htmlspecialchars(
                                    $row['latitude_kembali']
                                );

                                echo "<br>";

                                echo htmlspecialchars(
                                    $row['longitude_kembali']
                                );

                            } else {

                                echo "-";

                            }

                            ?>

                        </td>

                    </tr>

                <?php } ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

</body>

</html>