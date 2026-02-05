<?php
include "_init.php";

$kode = $_GET['kode'] ?? '';

$stmt = mysqli_prepare($koneksi, "SELECT nama,status,created_at FROM pengajuan_surat WHERE tracking_code=? LIMIT 1");
mysqli_stmt_bind_param($stmt, "s", $kode);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);
$d = mysqli_fetch_assoc($res);

echo json_encode($d ?: []);
