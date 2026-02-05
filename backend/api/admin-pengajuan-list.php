<?php
header("Content-Type: application/json");
include "../config/koneksi.php";

$data = [];

$q = mysqli_query($koneksi, "
  SELECT 
    p.id,
    p.created_at,
    p.nama,
    p.nik,
    p.tracking_code,
    p.status,
    j.nama_surat
  FROM pengajuan_surat p
  LEFT JOIN jenis_surat j ON j.id = p.jenis_surat_id
  ORDER BY p.created_at DESC
");

if(!$q){
  http_response_code(500);
  echo json_encode(["error"=>"Query gagal"]);
  exit;
}

while($r = mysqli_fetch_assoc($q)){
  $data[] = $r;
}

echo json_encode($data);
