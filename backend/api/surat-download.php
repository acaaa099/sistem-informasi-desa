<?php
// backend/api/surat-download.php
include "_init.php";

$kode = $_GET['kode'] ?? '';
if ($kode === '') {
  http_response_code(400);
  exit("Kode tidak valid");
}

// ambil data pengajuan
$stmt = mysqli_prepare($koneksi, "
  SELECT p.nama, p.nik, j.nama_surat, p.created_at, p.status
  FROM pengajuan_surat p
  JOIN jenis_surat j ON j.id = p.jenis_surat_id
  WHERE p.tracking_code = ?
  LIMIT 1
");
mysqli_stmt_bind_param($stmt, "s", $kode);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);
$d = mysqli_fetch_assoc($res);

// validasi
if (!$d || $d['status'] !== 'Disetujui') {
  http_response_code(403);
  exit("Surat belum disetujui");
}

// ===== GENERATE FILE HTML (BISA DIPRINT / SAVE PDF) =====
header("Content-Type: text/html; charset=utf-8");
?>
<!DOCTYPE html>
<html>
<head>
  <title>Surat <?= htmlspecialchars($d['nama_surat']) ?></title>
  <style>
    body{font-family:Arial;padding:40px;line-height:1.6}
    h2{text-align:center;text-transform:uppercase}
    .ttd{margin-top:60px;text-align:right}
  </style>
</head>
<body>

<h2>SURAT <?= strtoupper($d['nama_surat']) ?></h2>

<p>Yang bertanda tangan di bawah ini menerangkan bahwa:</p>

<table>
  <tr><td>Nama</td><td>: <?= htmlspecialchars($d['nama']) ?></td></tr>
  <tr><td>NIK</td><td>: <?= htmlspecialchars($d['nik']) ?></td></tr>
</table>

<p>
Surat ini dibuat untuk keperluan administrasi desa dan dinyatakan sah.
</p>

<div class="ttd">
  <p>Katingan, <?= date("d-m-Y") ?></p>
  <p><b>Kepala Desa</b></p>
  <br><br>
  <p>( __________________ )</p>
</div>

<script>
  window.print(); // otomatis buka dialog print
</script>

</body>
</html>
