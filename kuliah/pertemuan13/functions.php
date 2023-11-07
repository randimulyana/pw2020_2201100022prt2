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


// function upload

function upload()
{
  $nama_file = $_FILES['gambar']['name'];
  $tipe_file = $_FILES['gambar']['type'];
  $ukuran_file = $_FILES['gambar']['size'];
  $error = $_FILES['gambar']['error'];
  $tmp_file = $_FILES['gambar']['tmp_name'];


  // ketika tidak ada gambar yang di pilih
  if ($error == 4) {
    echo "
      <script>
        alert('pilih gambar terlebih dahulu');
      </script>
    ";

    return false;
  }

  // cek ekstensi file apakah gambar atau tidak
  $daftar_gambar = ['jpg', 'jpeg', 'png'];
  $ekstensi_file = explode('.', $nama_file);
  $ekstensi_file = strtolower(end($ekstensi_file));
  if (!in_array($ekstensi_file, $daftar_gambar)) {
    echo "
    <script>
      alert('yang anda pilih bukan gambar');
    </script>
  ";

    return false;
  }

  // cek tipe file
  if ($tipe_file != 'image/jpeg' && $tipe_file != 'image/png') {
    echo "
    <script>
      alert('yang anda pilih bukan gambar');
    </script>
  ";

    return false;
  }

  // cek ukuran file
  // maksimal 5mb = 5000000 
  if ($ukuran_file > 5000000) {
    echo "
    <script>
      alert('ukuran file terlalu besar dari 5mb');
    </script>
  ";

    return false;
  }

  // lolos pengecekan 
  // siap upload file
  // generate nama file baru dan unik
  $nama_file_baru = uniqid();
  $nama_file_baru .= '.';
  $nama_file_baru .= $ekstensi_file;

  move_uploaded_file($tmp_file, 'img/' . $nama_file_baru);

  return $nama_file_baru;
}








// Tambah Mahasiswa

function tambah($data)
{
  $conn = koneksi();

  $nama = $data['nama'];
  $nrp = $data['nrp'];
  $email = $data['email'];
  $jurusan = $data['jurusan'];
  // $gambar = $data['gambar'];

  // upload gambar
  $gambar = upload();
  if (!$gambar) {
    return false;
  }

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

  // menghapus gambar di folder img
  $mhs = query("SELECT * FROM mahasiswa WHERE id = $id");
  if ($mhs['gambar'] != 'nophoto.jpg') {
    unlink('img/' . $mhs['gambar']);
  }

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
  $gambar_lama = $data['gambar_lama'];

  $gambar = upload();
  if (!$gambar) {
    return false;
  }

  // ketika user tidak upload gambar
  if ($gambar == 'nophoto.jpg') {
    $gambar = $gambar_lama;
  }

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
