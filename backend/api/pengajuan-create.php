<?php
include "_init.php";

$data = json_input();
$nik = trim($data['nik'] ?? '');
$nama = trim($data['nama'] ?? '');
$jenis = intval($data['jenis'] ?? 0);
$keperluan = trim($data['keperluan'] ?? '');

if ($nik==='' || $nama==='' || $jenis<=0 || $keperluan==='') {
  http_response_code(400);
  echo json_encode(["success"=>false,"message"=>"Data belum lengkap"]);
  exit;
}

$kode = "KAT-" . strtoupper(substr(bin2hex(random_bytes(3)), 0, 6));

$stmt = mysqli_prepare($koneksi, "
  INSERT INTO pengajuan_surat (nik,nama,jenis_surat_id,keperluan,tracking_code,status)
  VALUES (?,?,?,?,?,'Diproses')
");
mysqli_stmt_bind_param($stmt, "ssiss", $nik, $nama, $jenis, $keperluan, $kode);

if (!mysqli_stmt_execute($stmt)) {
  http_response_code(500);
  echo json_encode(["success"=>false,"message"=>"Gagal simpan. Pastikan NIK ada di tabel warga"]);
  exit;
}

echo json_encode(["success"=>true,"kode"=>$kode]);
