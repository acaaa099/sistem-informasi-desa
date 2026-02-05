<?php
// CORS (lokal aman pakai *)
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') exit;

header("Content-Type: application/json");

include __DIR__ . "/../config/koneksi.php";

function json_input() {
  $raw = file_get_contents("php://input");
  return json_decode($raw, true) ?: [];
}

function make_token() {
  return bin2hex(random_bytes(32)); // 64 chars
}

function require_token() {
  global $koneksi;

  $headers = function_exists('getallheaders') ? getallheaders() : [];
  $auth = $headers['Authorization'] ?? $headers['authorization'] ?? '';

  if (!preg_match('/Bearer\s(\S+)/', $auth, $m)) {
    http_response_code(401);
    echo json_encode(["success"=>false,"message"=>"Missing token"]);
    exit;
  }

  $token = $m[1];

  $stmt = mysqli_prepare($koneksi, "
    SELECT u.id, u.username, u.role
    FROM user_tokens t
    JOIN users u ON u.id = t.user_id
    WHERE t.token = ? AND (t.expired_at IS NULL OR t.expired_at > NOW())
    LIMIT 1
  ");
  mysqli_stmt_bind_param($stmt, "s", $token);
  mysqli_stmt_execute($stmt);
  $res = mysqli_stmt_get_result($stmt);
  $me = mysqli_fetch_assoc($res);

  if (!$me) {
    http_response_code(401);
    echo json_encode(["success"=>false,"message"=>"Invalid/expired token"]);
    exit;
  }
  return $me;
}

function require_roles($roles = []) {
  $me = require_token();
  if (!in_array($me['role'], $roles)) {
    http_response_code(403);
    echo json_encode(["success"=>false,"message"=>"Access denied"]);
    exit;
  }
  return $me;
}
