<?php
require 'functions.php';

// jika tidak ada id di url
if (!isset($_GET['id'])) {
  header("Location: index.php");
  exit;
}

// ambil id dari url
$id = $_GET['id'];

// query mahasiswa berdasarkan id yang dipilih
$m = query("SELECT * FROM mahasiswa WHERE id=$id");


// cek apakah tomboh ubah sudah di set atau diaktifkan
if (isset($_POST['ubah'])) {
  if (ubah($_POST) > 0) {
    echo "
          <script>
          alert('data berhasil diubahkan');
          document.location.href = 'index.php';
          </script>
          ";
  } else {
    echo "Data Gagal Diubahkan";
  }
}


?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ubah Data Mahasiswa</title>
</head>

<body>
  <h3>Ubah Data Mahasiswa</h3>
  <form action="" method="POST">
    <input type="hidden" name="id" value="<?= $m['id']; ?>">
    <ul>
      <li>
        <label>
          Nama :
          <input type="text" name="nama" value="<?= $m['nama']; ?>" autofocus required>
        </label>
      </li>
      <li>
        <label>
          NRP :
          <input type="text" name="nrp" value="<?= $m['nrp']; ?>">
        </label>
      </li>
      <li>
        <label>
          Email :
          <input type="text" name="email" value="<?= $m['email']; ?>">
        </label>
      </li>
      <li>
        <label>
          Jurusan
          <input type="text" name="jurusan" value="<?= $m['jurusan']; ?>">
        </label>
      </li>
      <li>
        <label>
          Gambar :
          <input type="text" name="gambar" value="<?= $m['gambar']; ?>">
        </label>
      </li>
      <li>
        <button type="submit" name="ubah">Ubah Data</button>
      </li>
    </ul>
  </form>
</body>

</html>