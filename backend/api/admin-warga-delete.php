<?php
header("Content-Type: application/json");
include "../config/koneksi.php";

$d = json_decode(file_get_contents("php://input"), true);
$nik = $d['nik'] ?? '';

if(!$nik){
  http_response_code(400);
  echo json_encode(["success"=>false]);
  exit;
}

mysqli_query($koneksi,"DELETE FROM warga WHERE nik='$nik'");
echo json_encode(["success"=>true]);
