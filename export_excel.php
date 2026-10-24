<?php
include 'koneksi.php';

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=data_peminjaman.xls");
header("Pragma: no-cache");
header("Expires: 0");

$query = "SELECT * FROM tb_peminjaman ORDER BY waktu DESC";
$result = mysqli_query($koneksi, $query);
?>

<table border="1">

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
        <th>Latitude Pinjam</th>
        <th>Longitude Pinjam</th>
        <th>Latitude Kembali</th>
        <th>Longitude Kembali</th>
    </tr>

    <?php
    $no = 1;

    while ($row = mysqli_fetch_assoc($result)) {
    ?>

    <tr>

        <td><?= $no++; ?></td>

        <td><?= htmlspecialchars($row['nis']); ?></td>

        <td><?= htmlspecialchars($row['nama']); ?></td>

        <td><?= htmlspecialchars($row['alamat']); ?></td>

        <td><?= htmlspecialchars($row['alat']); ?></td>

        <td><?= htmlspecialchars($row['keperluan']); ?></td>

        <td><?= htmlspecialchars($row['waktu']); ?></td>

        <td><?= htmlspecialchars($row['status']); ?></td>

        <td>
            <?= $row['tanggal_kembali']
                ? htmlspecialchars($row['tanggal_kembali'])
                : '-'; ?>
        </td>

        <td>
            <?= $row['kondisi_kembali']
                ? htmlspecialchars($row['kondisi_kembali'])
                : '-'; ?>
        </td>

        <td><?= htmlspecialchars($row['latitude']); ?></td>

        <td><?= htmlspecialchars($row['longitude']); ?></td>

        <td><?= htmlspecialchars($row['latitude_kembali']); ?></td>

        <td><?= htmlspecialchars($row['longitude_kembali']); ?></td>

    </tr>

    <?php } ?>

</table>