<?php
header("Content-Type: application/json");
include "../config/koneksi.php";

$data = json_decode(file_get_contents("php://input"),true);

$kode = "KAT-".substr(md5(time()),0,6);

mysqli_query($koneksi,"
 INSERT INTO pengajuan_surat
 (nik,nama,jenis_surat_id,keperluan,tracking_code,status)
 VALUES
 ('{$data['nik']}','{$data['nama']}','{$data['jenis']}',
  '{$data['keperluan']}','$kode','Diproses')
");

echo json_encode(["kode"=>$kode]);
