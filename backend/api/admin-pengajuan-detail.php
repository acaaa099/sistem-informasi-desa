<?php
include "_init.php";
require_roles(['admin','kepala_desa','sekretaris','kaur']);

$id = intval($_GET['id'] ?? 0);
if($id<=0){ echo json_encode([]); exit; }

$stmt = mysqli_prepare($koneksi,"
 SELECT p.*, j.nama_surat
 FROM pengajuan_surat p
 JOIN jenis_surat j ON j.id=p.jenis_surat_id
 WHERE p.id=?
");
mysqli_stmt_bind_param($stmt,"i",$id);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);

echo json_encode(mysqli_fetch_assoc($res) ?: []);
