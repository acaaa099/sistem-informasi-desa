<?php
include "_init.php";
require_roles(['admin','kepala_desa','sekretaris','kaur']);

$rows = [];
$q = mysqli_query($koneksi, "
  SELECT p.id, p.nama, p.nik, j.nama_surat, p.status, p.tracking_code, p.created_at
  FROM pengajuan_surat p
  JOIN jenis_surat j ON j.id = p.jenis_surat_id
  ORDER BY p.id DESC
  LIMIT 200
");
while ($r = mysqli_fetch_assoc($q)) $rows[] = $r;

echo json_encode($rows);
