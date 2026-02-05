<?php
include "_init.php";
$q = mysqli_query($koneksi, "SELECT * FROM profil_desa LIMIT 1");
echo json_encode(mysqli_fetch_assoc($q) ?: []);
