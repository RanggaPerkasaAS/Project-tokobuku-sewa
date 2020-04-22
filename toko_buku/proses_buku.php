<?php
include("config.php");
  if (isset($_POST["save_buku"])) {
    // isset digunakan untuk mengecek
    // apakah kita mengakses file ini. dikirimkan
    // data dengan nama "save_siswa" dg method $_POST

    // kita tampung  data yang dikirimkan
    $action = $_POST["action"];
    $kode_buku = $_POST["kode_buku"];
    $judul = $_POST["judul"];
    $penulis = $_POST["penulis"];
    $tahun = $_POST["tahun"];
    $harga = $_POST["harga"];
    $stok = $_POST["stok"];

    //menampung file image
    // if (isset($_FILES["image"])) {
    if (!empty($_FILES["image"]["name"])) {
      // empty digunakan untuk mengecek Apakah
      // seuah variable itu menyimpan nilai atau tidak
      /*contoh
      $angka;
      echo empty($angka); -->hasilnya true, karena angka tidak punya nilai
      atau variable tsb kosong
      */
      $path = pathinfo($_FILES["image"]["name"]);
      // mengambil extensi gambar
      $extension = $path["extension"];

      // rangkai file name
      $filename = $kode_buku."-".rand(1,1000).".".$extension;
      // generate nama file
      // exp : 111-804.JPG
      // rand() random nilai 1 - 1000
    }

    // load file config.?php


    // cek aksi
    if ($action == "insert") {
      // insert
      $sql = "insert into buku values ('$kode_buku','$judul','$penulis','$tahun','$harga','$stok','$filename')";

      // proses upload file
      move_uploaded_file($_FILES["image"]["tmp_name"],"image/$filename");
      // eksekusi perintah
      mysqli_query($connect, $sql);
    }else if ($action == "update") {
      // if (isset($_FILES["image"])) {
      if(!empty($_FILES["image"]["name"])){
        $path = pathinfo($_FILES["image"]["name"]);
        // mengambil extensi gambar
        $extension = $path["extension"];

        // rangkai file name
        $filename = $kode_buku."-".rand(1,1000).".".$extension;
        // generate nama file
        // exp : 111-804.JPG
        // rand() random nilai 1 - 1000

        // ambil data yang akan di edit
        $sql = "select * from buku where kode_buku = '$kode_buku'";
        $query = mysqli_query($connect,$sql);
        $hasil = mysqli_fetch_array($query);

        if (file_exists("image/".$hasil["image"])) {
          unlink("image/".$hasil["image"]);
          // mengahpus gambar yang terdahulu
        }

        // upload gambarnya
        move_uploaded_file($_FILES["image"]["tmp_name"],"image/$filename");
        // sintak untuk update
        $sql = "update buku set judul = '$judul', penulis = '$penulis', 
        tahun = '$tahun', harga = '$harga', stok = '$stok', image='$filename' where kode_buku = '$kode_buku'";
      }
      else{
        // sintak untuk update
        $sql = "update buku set judul = '$judul', penulis = '$penulis', 
        tahun = '$tahun', harga = '$harga', stok = '$stok', image='$filename' where kode_buku = '$kode_buku'";
      }

      // eksekusi perintah
      mysqli_query($connect,$sql);
    }

    //redirect ke halaman siswa.php
    header("location:buku.php");
  }

  if (isset($_GET["hapus"])) {
    include("config.php");
    $kode_buku = $_GET["kode_buku"];
    // if (file_exists("image/".$hasil["image"])) {
    //   unlink("image/".$hasil["image"]);
    // }
    $sql = "delete from buku where kode_buku='$kode_buku'";

    mysqli_query($connect, $sql);
    // direct ke halaman data siswa
    header("location:buku.php");
  }
 ?>