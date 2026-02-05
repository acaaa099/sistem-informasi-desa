<?php
include "../config/auth.php";
cekRole(['admin','kepala_desa','sekretaris','kaur']);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Admin Desa</title>
  <link rel="stylesheet" href="assets/css/admin.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<div class="layout">

  <!-- SIDEBAR -->
  <aside class="sidebar">
    <h2>Admin Desa</h2>
    <a href="#">Dashboard</a>
    <a href="#">Data Warga</a>
    <a href="#">Pengajuan Surat</a>
    <a href="#">Profil Desa</a>
    <a href="logout.php" class="logout">Logout</a>
  </aside>

  <!-- MAIN -->
  <main class="content">
    <h1>Dashboard Admin</h1>

    <!-- STAT CARDS -->
    <div class="stats">
      <div class="card">
        <h3 id="total">0</h3>
        <p>Total Penduduk</p>
      </div>
      <div class="card">
        <h3 id="laki">0</h3>
        <p>Laki-laki</p>
      </div>
      <div class="card">
        <h3 id="perempuan">0</h3>
        <p>Perempuan</p>
      </div>
      <div class="card">
        <h3 id="dusun">0</h3>
        <p>Jumlah Dusun</p>
      </div>
    </div>

    <!-- CHART -->
    <div class="chart-box">
      <canvas id="chartPenduduk"></canvas>
    </div>

  </main>

</div>

<div class="card" style="margin-top:20px">
  <h3>Data Warga</h3>
  <table class="table" style="margin-top:10px">
    <thead>
      <tr>
        <th>NIK</th>
        <th>Nama</th>
        <th>JK</th>
        <th>Pekerjaan</th>
      </tr>
    </thead>
    <tbody id="tblWarga"></tbody>
  </table>
</div>

<script src="assets/js/dashboard.js"></script>
</body>
</html>
