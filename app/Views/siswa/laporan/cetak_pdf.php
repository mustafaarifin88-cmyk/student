<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 12px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 18px;
            text-transform: uppercase;
        }
        .header p {
            margin: 5px 0 0;
            font-size: 12px;
            color: #666;
        }
        .info-table {
            width: 100%;
            margin-bottom: 20px;
        }
        .info-table td {
            padding: 3px;
            vertical-align: top;
        }
        .info-label {
            font-weight: bold;
            width: 120px;
        }
        .table-data {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .table-data th, .table-data td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }
        .table-data th {
            background-color: #f2f2f2;
            font-weight: bold;
            text-align: center;
        }
        .text-center {
            text-align: center;
        }
        .badge {
            background-color: #e0e0e0;
            padding: 2px 5px;
            border-radius: 3px;
            font-size: 10px;
        }
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: right;
            font-size: 10px;
            color: #999;
            border-top: 1px solid #ccc;
            padding-top: 5px;
        }
        .total-row td {
            font-weight: bold;
            background-color: #eef;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>Laporan Aktivitas Siswa</h1>
        <p>Student Activity Record System</p>
    </div>

    <table class="info-table">
        <tr>
            <td class="info-label">Nama Siswa</td>
            <td>: <?= $siswa['nama_lengkap'] ?></td>
            <td class="info-label">Kelas</td>
            <td>: <?= $siswa['nama_kelas'] ?></td>
        </tr>
        <tr>
            <td class="info-label">NISN</td>
            <td>: <?= $siswa['nisn'] ?></td>
            <td class="info-label">Total Poin</td>
            <td>: <strong><?= $siswa['total_poin'] ?> Poin</strong></td>
        </tr>
    </table>

    <h3 style="margin-bottom: 10px;">Riwayat Kegiatan</h3>

    <table class="table-data">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="20%">Tanggal</th>
                <th width="55%">Kegiatan</th>
                <th width="20%">Poin Diperoleh</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($logs)) : ?>
                <?php $no = 1; foreach ($logs as $log) : ?>
                    <tr>
                        <td class="text-center"><?= $no++ ?></td>
                        <td><?= date('d-m-Y H:i', strtotime($log['tanggal_dikerjakan'])) ?></td>
                        <td>
                            <strong><?= $log['judul'] ?></strong>
                            <br>
                            <small style="color: #666;">Instruksi: <?= substr($log['instruksi'], 0, 50) ?>...</small>
                        </td>
                        <td class="text-center">
                            +<?= $log['total_poin_diperoleh'] ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="4" class="text-center" style="padding: 20px;">Belum ada riwayat aktivitas.</td>
                </tr>
            <?php endif; ?>
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="3" style="text-align: right;">Total Poin Saat Ini:</td>
                <td class="text-center"><?= $siswa['total_poin'] ?></td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        Dicetak pada: <?= date('d F Y H:i:s') ?>
    </div>

</body>
</html>