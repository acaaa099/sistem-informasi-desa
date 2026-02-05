<?php
include "_init.php";
$rows = [];
$q = mysqli_query($koneksi, "SELECT nama,deskripsi FROM umkm ORDER BY id DESC");
while ($r = mysqli_fetch_assoc($q)) $rows[] = $r;
echo json_encode($rows);
