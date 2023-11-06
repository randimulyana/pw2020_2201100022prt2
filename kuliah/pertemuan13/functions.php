<?php

function koneksi()
{
  return mysqli_connect('localhost', 'root', '', 'pw_2201100022');
}

function query($query)
{
  $conn = koneksi();

  $result = mysqli_query($conn, $query);

  if (mysqli_num_rows($result) == 1) {
    return mysqli_fetch_assoc($result);
  }

  $rows = [];
  while ($row = mysqli_fetch_assoc($result)) {
    $rows[] = $row;
  }

  return $rows;
}

// Tambah Mahasiswa

function tambah($data)
{
  $conn = koneksi();

  $nama = $data['nama'];
  $nrp = $data['nrp'];
  $email = $data['email'];
  $jurusan = $data['jurusan'];
  $gambar = $data['gambar'];

  $query = "INSERT INTO
              mahasiswa
            VALUES
            (null, '$nama', '$nrp', '$email', '$jurusan', '$gambar');
            ";

  mysqli_query($conn, $query) or die(mysqli_error($conn));
  // echo mysqli_error($conn);
  return mysqli_affected_rows($conn);
}

// hapus mahasiswa
function hapus($id)
{
  $conn = koneksi();

  mysqli_query($conn, "DELETE FROM mahasiswa WHERE id=$id") or die(mysqli_error($conn));
  return mysqli_affected_rows($conn);
}

// ubah mahasiswa
function ubah($data)
{
  $conn = koneksi();

  $id = $data['id'];
  $nama = $data['nama'];
  $nrp = $data['nrp'];
  $email = $data['email'];
  $jurusan = $data['jurusan'];
  $gambar = $data['gambar'];

  $query = "UPDATE mahasiswa SET
              nama = '$nama',
              nrp = '$nrp',
              email = '$email',
              jurusan = '$jurusan',
              gambar = '$gambar'
            WHERE id = $id";
  mysqli_query($conn, $query) or die(mysqli_error($conn));
  // echo mysqli_error($conn);
  return mysqli_affected_rows($conn);
}


// fungsi cari data mahasiswa
function cari($keyword)
{
  $conn = koneksi();

  $query = "SELECT * FROM mahasiswa
              WHERE nama LIKE '%$keyword%' OR
              nrp LIKE '%$keyword%'";

  $result = mysqli_query($conn, $query);

  $rows = [];
  while ($row = mysqli_fetch_assoc($result)) {
    $rows[] = $row;
  }

  return $rows;
}

// fungsi login

function login($data)
{
  $conn = koneksi();

  $username = $data['username'];
  $password = $data['password'];

  // cek username
  if ($user = query("SELECT * FROM user WHERE username = '$username'")) {
    // cek password
    if (password_verify($password, $user['password'])) {
      // set session
      $_SESSION['login'] = true;

      header("Location: index.php");
      exit;
    }
  }
  return [
    'error' => true,
    'pesan' => 'Username atau password salah'
  ];
}


// function registasi 

function registrasi($data)
{
  $conn = koneksi();

  $username = strtolower($data['username']);
  $password1 = mysqli_real_escape_string($conn, $data['password1']);
  $password2 = mysqli_real_escape_string($conn, $data['password2']);


  // jika username dan password kosong
  if (empty($username) || empty($password1) || empty($password2)) {
    echo "
          <script>
            alert('username dan password tidak boleh kosong');
            documen.location.href = registrasi.php;
          </script>
          ";
    return false;
  }


  // jika username sudah ada di database
  if (query("SELECT * FROM user WHERE username = '$username'")) {
    echo "
    <script>
      alert('username sudah terdaftar');
      documen.location.href = registrasi.php;
    </script>
    ";
    return false;
  }

  // jika konfirmasi password tidak sama
  if ($password1 !== $password2) {
    echo "
    <script>
      alert('konfirmasi password tidak sesuai');
      documen.location.href = registrasi.php;
    </script>
    ";
    return false;
  }


  // jika password < 5 digit
  if (strlen($password1) < 5) {
    echo "
    <script>
      alert('password terlalu pendek');
      documen.location.href = registrasi.php;
    </script>
    ";
    return false;
  }

  // jika username dan password sudah sesuai
  // enskripsi password

  $password_baru = password_hash($password1, PASSWORD_DEFAULT);
  // insert ke tabel user
  $query = "INSERT INTO user 
            VALUES
            (null, '$username', '$password_baru')
            ";
  mysqli_query($conn, $query) or die(mysqli_error(($conn)));
  return mysqli_affected_rows($conn);
}
