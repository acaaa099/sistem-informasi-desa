<?php
header("Content-Type: application/json");
include "../config/koneksi.php";

$data = [];
$q = mysqli_query($koneksi, "SELECT nik,nama,jenis_kelamin,pekerjaan FROM warga ORDER BY nama");

while($r = mysqli_fetch_assoc($q)){
  $data[] = $r;
}

echo json_encode($data);
