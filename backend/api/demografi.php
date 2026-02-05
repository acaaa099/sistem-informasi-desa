<?php
include "_init.php";
require_roles(['admin','kepala_desa','sekretaris','kaur']);

$q = mysqli_query($koneksi,"
  SELECT 
    COUNT(*) AS total,
    SUM(jenis_kelamin='L') AS laki,
    SUM(jenis_kelamin='P') AS perempuan
  FROM warga
");
$d = mysqli_fetch_assoc($q);
$d['dusun'] = 5;

echo json_encode($d);
