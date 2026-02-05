<?php
include "_init.php";
$rows = [];
$q = mysqli_query($koneksi, "SELECT filename,keterangan FROM galeri ORDER BY id DESC");
while ($r = mysqli_fetch_assoc($q)) $rows[] = $r;
echo json_encode($rows);
