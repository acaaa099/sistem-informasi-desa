<?php
include "_init.php";
require_roles(['admin']);

$data = json_input();

$stmt = mysqli_prepare($koneksi,"
  UPDATE warga SET nama=?, jenis_kelamin=?, pekerjaan=?
  WHERE nik=?
");

mysqli_stmt_bind_param($stmt,"ssss",
  $data['nama'],
  $data['jk'],
  $data['pekerjaan'],
  $data['nik']
);

mysqli_stmt_execute($stmt);
echo json_encode(["success"=>true]);
