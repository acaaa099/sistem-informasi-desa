<?php
// ===== CORS WAJIB =====
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
  exit;
}

include "../config/koneksi.php";

$q = mysqli_query($koneksi, "SELECT id, nama_surat FROM jenis_surat ORDER BY id ASC");

$data = [];
while($r = mysqli_fetch_assoc($q)){
  $data[] = $r;
}

echo json_encode($data);
