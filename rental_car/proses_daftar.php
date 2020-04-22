<?php
  if (isset($_POST["save_daftar"])) {
    // isset digunakan untuk mengecek
    // apakah kita mengakses file ini. dikirimkan
    // data dengan nama "save_siswa" dg method $_POST

    // kita tampung  data yang dikirimkan
    $id_penyewa = $_POST["id_penyewa"];
    $nama = $_POST["nama"];
    $alamat = $_POST["alamat"];
    $kontak = $_POST["kontak"];
    $usernam = $_POST["username"];
    $pass = $_POST["pass"];

    // load file config.?php
    include("config.php");

    // cek aksi

      // insert
   $sql = "insert into penyewa values ('$id_penyewa','$nama', '$alamat','$kontak','$usernam','$pass')";

      // eksekusi perintah
      mysqli_query($connect, $sql);

    //redirect ke halaman siswa.php
    header("location:login_penyewa.php");
  }

 ?>