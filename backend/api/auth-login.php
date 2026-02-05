<?php
include "_init.php";

$data = json_input();
$username = trim($data['username'] ?? '');
$password = $data['password'] ?? '';

$stmt = mysqli_prepare($koneksi, "SELECT id, username, password, role FROM users WHERE username=? LIMIT 1");
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);
$u = mysqli_fetch_assoc($res);

if (!$u || !password_verify($password, $u['password'])) {
  http_response_code(401);
  echo json_encode(["success"=>false,"message"=>"Username atau password salah"]);
  exit;
}

$token = make_token();
$stmt2 = mysqli_prepare($koneksi, "INSERT INTO user_tokens (user_id, token) VALUES (?,?)");
mysqli_stmt_bind_param($stmt2, "is", $u['id'], $token);
mysqli_stmt_execute($stmt2);

echo json_encode([
  "success"=>true,
  "token"=>$token,
  "role"=>$u['role'],
  "username"=>$u['username']
]);
