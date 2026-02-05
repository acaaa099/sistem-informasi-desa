<?php
include "_init.php";

require_token();

$headers = function_exists('getallheaders') ? getallheaders() : [];
$auth = $headers['Authorization'] ?? $headers['authorization'] ?? '';
preg_match('/Bearer\s(\S+)/', $auth, $m);
$token = $m[1] ?? '';

$stmt = mysqli_prepare($koneksi, "DELETE FROM user_tokens WHERE token=?");
mysqli_stmt_bind_param($stmt, "s", $token);
mysqli_stmt_execute($stmt);

echo json_encode(["success"=>true,"message"=>"Logout berhasil"]);
