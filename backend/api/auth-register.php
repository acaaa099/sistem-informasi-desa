<?php
include "_init.php";

$data = json_input();
$username = trim($data['username'] ?? '');
$password = $data['password'] ?? '';

if ($username === '' || strlen($password) < 6) {
  http_response_code(400);
  echo json_encode(["success"=>false,"message"=>"Username wajib, password minimal 6 karakter"]);
  exit;
}

$hash = password_hash($password, PASSWORD_BCRYPT);
$role = "warga";

$stmt = mysqli_prepare($koneksi, "INSERT INTO users (username,password,role) VALUES (?,?,?)");
mysqli_stmt_bind_param($stmt, "sss", $username, $hash, $role);

if (!mysqli_stmt_execute($stmt)) {
  http_response_code(409);
  echo json_encode(["success"=>false,"message"=>"Username sudah dipakai"]);
  exit;
}

echo json_encode(["success"=>true,"message"=>"Registrasi berhasil, silakan login"]);
