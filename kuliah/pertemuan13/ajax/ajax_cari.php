<?php
require '../functions.php';

$mahasiswa = cari($_GET['keyword']);
?>

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