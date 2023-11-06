<?php
session_start();

if (!isset($_SESSION['login'])) {
  header("Location: login.php");
  exit;
}

require 'functions.php';

// ambil data berdasarkan id di url
$id = $_GET['id'];

// query atau tampilkan berdasarkan id
$mhs = query("SELECT * FROM mahasiswa WHERE id = $id");


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Detail Mahasiwa</title>
</head>

<body>
  <h3>Detail Mahasiwa</h3>
  <ul>
    <li><img src="img/<?= $mhs['gambar']; ?>"></li>
    <li>NRP : <?= $mhs['nrp']; ?></li>
    <li>Nama : <?= $mhs['nama']; ?></li>
    <li>Email : <?= $mhs['email']; ?></li>
    <li>Jurusan : <?= $mhs['jurusan']; ?></li>
    <li>
      <a href="ubah.php?id=<?= $mhs['id']; ?>">ubah</a> | <a href="hapus.php?id=<?= $mhs['id']; ?>" onclick="return confirm('anda yakin menghapus data');">hapus</a>
    </li>
    <li><a href="index.php">kembali ke daftar mahasiswa</a></li>
  </ul>
</body>

</html>