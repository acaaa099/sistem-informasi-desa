<?php
header("Content-Type: application/json");
include "../config/koneksi.php";

$d = json_decode(file_get_contents("php://input"), true);

$nik = $d['nik'] ?? '';
$nama = $d['nama'] ?? '';
$jk = $d['jk'] ?? '';
$pekerjaan = $d['pekerjaan'] ?? '';

if(!$nik || !$nama || !$jk || !$pekerjaan){
  http_response_code(400);
  echo json_encode(["success"=>false,"message"=>"Data tidak lengkap"]);
  exit;
}

mysqli_query($koneksi,"
  INSERT INTO warga (nik,nama,jenis_kelamin,pekerjaan)
  VALUES ('$nik','$nama','$jk','$pekerjaan')
");

echo json_encode(["success"=>true]);
