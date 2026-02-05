<?php
include "_init.php";
require_roles(['admin','kepala_desa','sekretaris','kaur']);

$data = json_input();
$id = intval($data['id'] ?? 0);
$status = $data['status'] ?? '';

$allowed = ['Diproses','Disetujui','Ditolak'];
if ($id<=0 || !in_array($status, $allowed)) {
  http_response_code(400);
  echo json_encode(["success"=>false,"message"=>"Data tidak valid"]);
  exit;
}

$stmt = mysqli_prepare($koneksi, "UPDATE pengajuan_surat SET status=? WHERE id=?");
mysqli_stmt_bind_param($stmt, "si", $status, $id);
mysqli_stmt_execute($stmt);

echo json_encode(["success"=>true]);
