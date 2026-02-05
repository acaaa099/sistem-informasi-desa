<?php
session_start();
header("Content-Type: application/json");

if (!isset($_SESSION['role'])) {
  http_response_code(401);
  echo json_encode([
    "login" => false,
    "message" => "Belum login"
  ]);
  exit;
}

if (!in_array($_SESSION['role'], ['admin','kepala_desa','sekretaris','kaur'])) {
  http_response_code(403);
  echo json_encode([
    "login" => false,
    "message" => "Akses ditolak"
  ]);
  exit;
}

echo json_encode([
  "login" => true,
  "role" => $_SESSION['role']
]);
