<?php
session_start();
include "../config/koneksi.php";

$data = json_decode(file_get_contents("php://input"), true);

$username = $data['username'];
$password = md5($data['password']);

$q = mysqli_query($koneksi,"
 SELECT * FROM users
 WHERE username='$username' AND password='$password'
");

if ($u = mysqli_fetch_assoc($q)) {
  $_SESSION['role'] = $u['role'];

  echo json_encode([
    "success" => true,
    "role" => $u['role']
  ]);
} else {
  echo json_encode([
    "success" => false,
    "message" => "Username atau password salah"
  ]);
}
