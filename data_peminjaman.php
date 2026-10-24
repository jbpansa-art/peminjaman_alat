<?php
include 'koneksi.php';

$cari = $_GET['cari'] ?? '';
$status = $_GET['status'] ?? '';

$query = "SELECT * FROM tb_peminjaman WHERE 1=1";

if ($cari != '') {
    $cari = mysqli_real_escape_string($koneksi, $cari);
    $query .= " AND (nis LIKE '%$cari%' OR nama LIKE '%$cari%')";
}

if ($status != '') {
    $status = mysqli_real_escape_string($koneksi, $status);
    $query .= " AND status = '$status'";
}

$query .= " ORDER BY waktu DESC";

$result = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <title>Data Peminjaman</title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            color: #333;
        }

        /* SIDEBAR */

        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 190px;
            height: 100vh;
            background: #1e293b;
            padding-top: 25px;
        }

        .sidebar h2 {
            color: white;
            text-align: center;
            margin-bottom: 30px;
            font-size: 20px;
        }

        .menu {
            display: block;
            color: white;
            text-decoration: none;
            padding: 14px 20px;
            margin: 5px 10px;
            border-radius: 8px;
            transition: 0.2s;
        }

        .menu:hover {
            background: #334155;
        }

        /* CONTENT */

        .content {
            margin-left: 218px;
            padding: 30px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .header h1 {
            margin: 0;
            font-size: 26px;
        }

        /* FILTER */

        .filter-box {
            background: white;
            padding: 18px;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }

        .filter-box form {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .filter-box input,
        .filter-box select {
            padding: 10px 12px;
            border: 1px solid #d1d5db;
            border-radius: 7px;
            font-size: 14px;
        }

        .filter-box input {
            width: 250px;
        }

        .btn-filter {
            background: #2563eb;
            color: white;
            border: none;
            padding: 10px 18px;
            border-radius: 7px;
            cursor: pointer;
        }

        .btn-filter:hover {
            background: #1d4ed8;
        }

        .btn-reset {
            background: #64748b;
            color: white;
            text-decoration: none;
            padding: 10px 18px;
            border-radius: 7px;
        }

        /* EXPORT */

        .export-box {
            margin-bottom: 20px;
        }

        .btn-excel {
            display: inline-block;
            background: #16a34a;
            color: white;
            text-decoration: none;
            padding: 10px 16px;
            border-radius: 7px;
            margin-right: 8px;
        }

        .btn-pdf {
            display: inline-block;
            background: #dc2626;
            color: white;
            text-decoration: none;
            padding: 10px 16px;
            border-radius: 7px;
            cursor: pointer;
        }

        /* TABLE */

        .table-box {
            background: white;
            border-radius: 10px;
            padding: 15px;
            overflow-x: auto;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 1200px;
        }

        th {
            background: #1e293b;
            color: white;
            padding: 13px 10px;
            text-align: left;
            font-size: 14px;
        }

        td {
            padding: 12px 10px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 13px;
        }

        tr:hover {
            background: #f8fafc;
        }

        /* STATUS */

        .status {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            display: inline-block;
        }

        .dipinjam {
            background: #fef3c7;
            color: #92400e;
        }

        .dikembalikan {
            background: #dcfce7;
            color: #166534;
        }

        /* MAPS */

        .btn-maps {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            background: #4285f4;
            color: white;
            text-decoration: none;
            padding: 7px 11px;
            border-radius: 7px;
            font-size: 12px;
            font-weight: bold;
            white-space: nowrap;
            transition: 0.2s;
        }

        .btn-maps:hover {
            background: #3367d6;
            transform: translateY(-1px);
        }

        /* HAPUS */

        .btn-hapus {
            display: inline-block;
            background: #ef4444;
            color: white;
            text-decoration: none;
            padding: 7px 10px;
            border-radius: 7px;
            font-size: 12px;
        }

        .btn-hapus:hover {
            background: #dc2626;
        }

        /* PRINT */

        @media print {

            .sidebar,
            .filter-box,
            .export-box,
            .btn-hapus {
                display: none !important;
            }

            .content {
                margin-left: 0;
                padding: 0;
            }

            .table-box {
                box-shadow: none;
                padding: 0;
            }

            body {
                background: white;
            }

        }

    </style>

</head>

<body>

    <!-- SIDEBAR -->

    <div class="sidebar">

        <h2>SIPAT</h2>

        <a href="dashboard.php" class="menu">
            🏠 Dashboard
        </a>

        <a href="data_peminjaman.php" class="menu">
            📋 Data Peminjaman
        </a>

    </div>


    <!-- CONTENT -->

    <div class="content">

        <div class="header">

            <h1>Data Peminjaman</h1>

        </div>


        <!-- FILTER -->

        <div class="filter-box">

            <form method="GET">

                <input
                    type="text"
                    name="cari"
                    placeholder="Cari NIS atau nama..."
                    value="<?= htmlspecialchars($cari); ?>"
                >

                <select name="status">

                    <option value="">Semua Status</option>

                    <option value="Dipinjam"
                        <?= $status == 'Dipinjam' ? 'selected' : ''; ?>>
                        Dipinjam
                    </option>

                    <option value="Dikembalikan"
                        <?= $status == 'Dikembalikan' ? 'selected' : ''; ?>>
                        Dikembalikan
                    </option>

                </select>

                <button type="submit" class="btn-filter">
                    🔍 Filter
                </button>

                <a href="data_peminjaman.php" class="btn-reset">
                    Reset
                </a>

            </form>

        </div>


        <!-- EXPORT -->

        <div class="export-box">

            <a href="export_excel.php" class="btn-excel">
                📊 Export Excel
            </a>

            <a
                href="#"
                class="btn-pdf"
                onclick="window.print(); return false;"
            >
                📄 Cetak PDF
            </a>

        </div>


        <!-- TABLE -->

        <div class="table-box">

            <table>

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
                    <th>Lokasi</th>
                    <th>Aksi</th>

                </tr>


                <?php

                $no = 1;

                while ($row = mysqli_fetch_assoc($result)):

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

                        <?php if ($row['status'] == 'Dipinjam'): ?>

                            <span class="status dipinjam">
                                Dipinjam
                            </span>

                        <?php else: ?>

                            <span class="status dikembalikan">
                                Dikembalikan
                            </span>

                        <?php endif; ?>

                    </td>

                    <td>

                        <?php

                        if (!empty($row['tanggal_kembali'])) {

                            echo htmlspecialchars(
                                $row['tanggal_kembali']
                            );

                        } else {

                            echo '-';

                        }

                        ?>

                    </td>

                    <td>

                        <?php

                        if (!empty($row['kondisi_kembali'])) {

                            echo htmlspecialchars(
                                $row['kondisi_kembali']
                            );

                        } else {

                            echo '-';

                        }

                        ?>

                    </td>


                    <!-- MAPS -->

                    <td>

                        <?php if (
                            !empty($row['latitude']) &&
                            !empty($row['longitude'])
                        ): ?>

                            <a
                                href="https://www.google.com/maps?q=<?= urlencode($row['latitude'] . ',' . $row['longitude']); ?>"
                                target="_blank"
                                class="btn-maps"
                                title="Buka lokasi di Google Maps"
                            >
                                🗺️ Maps
                            </a>

                        <?php else: ?>

                            <span style="color:#94a3b8;">
                                Tidak tersedia
                            </span>

                        <?php endif; ?>

                    </td>


                    <!-- AKSI -->

                    <td>

                        <a
                            href="hapus.php?id=<?= $row['id']; ?>"
                            class="btn-hapus"
                            onclick="return confirm('Yakin ingin menghapus data ini?');"
                        >
                            🗑 Hapus
                        </a>

                    </td>

                </tr>

                <?php endwhile; ?>

            </table>

        </div>

    </div>

</body>

</html>