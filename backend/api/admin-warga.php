<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Authorization");
header("Content-Type: application/json");

include "_init.php";
require_roles(['admin','kepala_desa','sekretaris','kaur']);

$q = mysqli_query($koneksi,"SELECT * FROM warga ORDER BY nama ASC");
$data = [];
while($r = mysqli_fetch_assoc($q)) $data[] = $r;

echo json_encode($data);
