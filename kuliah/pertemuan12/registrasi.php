<?php
require 'functions.php';

if (isset($_POST['registrasi'])) {
  if (registrasi($_POST) > 0) {
    echo "
  <script>
    alert('user baru berhasil ditambahkan , silahkan login');
    documen.location.href = login.php;
  </script>
  ";
  } else {
    echo 'username gagal ditambahkan';
  }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>registrasi</title>
</head>

<body>
  <h3>Registrasi</h3>
  <form action="" method="post">
    <ul>
      <li>
        <label>
          Username
          <input type="text" name="username" autocomplete="off" autofocus required>
        </label>
      </li>
      <li>
        <label>
          Password
          <input type="password" name="password1">
        </label>
      </li>
      <li>
        <label>
          Konfirmasi Password
          <input type="password" name="password2">
        </label>
      </li>
      <li>
        <button type="submit" name="registrasi">Registrasi</button>
      </li>
    </ul>
  </form>
</body>

</html>