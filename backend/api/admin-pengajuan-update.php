<?php
header("Content-Type: application/json");
include "../config/koneksi.php";

$input = json_decode(file_get_contents("php://input"), true);

$id = intval($input['id'] ?? 0);
$status = $input['status'] ?? '';

$allowed = ["Diproses","Disetujui","Ditolak"];
if($id <= 0 || !in_array($status, $allowed)){
  http_response_code(400);
  echo json_encode(["success"=>false,"message"=>"Data tidak valid"]);
  exit;
}

$stmt = mysqli_prepare($koneksi, "UPDATE pengajuan_surat SET status=? WHERE id=?");
mysqli_stmt_bind_param($stmt,"si",$status,$id);
mysqli_stmt_execute($stmt);

echo json_encode(["success"=>true]);
