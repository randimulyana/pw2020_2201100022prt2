<?php
session_start();

if (!isset($_SESSION['login'])) {
  header("Location: login.php");
  exit;
}

require 'functions.php';
$mahasiswa = query("SELECT * FROM mahasiswa");

// ketika tombol cari di klik
if (isset($_POST['cari'])) {
  $mahasiswa = cari($_POST['keyword']);
}

?>





<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar Mahasiswa</title>
</head>

<body>
  <a href="logout.php">logout</a>
  <h3>Daftar Mahsiswa</h3>

  <a href="tambah.php">Tambah Data Mahasiswa</a>
  <br><br>

  <form action="" method="POST">
    <input type="text" name="keyword" placeholder="masukan keyword pencarian!" size="40" autocomplete="off" autofocus class="keyword">
    <button type="submit" name="cari" class="tombol-cari">Cari!</button>
  </form>
  <br>

  <div class="container">
    <table border="1px" cellpadding="5px" cellspacing="0px">
      <tr>
        <th>#</th>
        <th>Gambar</th>
        <th>Nama</th>
        <th>Aksi</th>
      </tr>

      <?php if (empty($mahasiswa)) : ?>
        <tr>
          <td colspan="4">
            <p style="color: red; font-style: italic;">data mahasiswa tidak di temukan</p>
          </td>
        </tr>
      <?php endif; ?>

      <?php $i = 1; ?>
      <?php foreach ($mahasiswa as $mhs) : ?>

        <tr>
          <td><?= $i++; ?></td>
          <td><img src="img/<?= $mhs['gambar']; ?>"></td>
          <td><?= $mhs['nama']; ?></td>
          <td>
            <a href="detail.php?id=<?= $mhs['id']; ?>">lihat detail</a>
          </td>

        <?php endforeach; ?>

        </tr>
    </table>
  </div>

  <script src="js/script.js"></script>

</body>

</html>