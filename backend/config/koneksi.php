<?php
$DB_HOST = "localhost";
$DB_USER = "root";
$DB_PASS = "";
$DB_NAME = "desa_digital";

$koneksi = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

if (!$koneksi) {
  http_response_code(500);
  header("Content-Type: application/json");
  echo json_encode(["success"=>false,"message"=>"DB connection failed"]);
  exit;
}
mysqli_set_charset($koneksi, "utf8mb4");
