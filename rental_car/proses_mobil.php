<?php
include("config.php");
  if (isset($_POST["save_mobil"])) {
    // isset digunakan untuk mengecek
    // apakah kita mengakses file ini. dikirimkan
    // data dengan nama "save_siswa" dg method $_POST

    // kita tampung  data yang dikirimkan
    $action = $_POST["action"];
    $no_mobil = $_POST["no_mobil"];
    $nama_mobil = $_POST["nama_mobil"];
    $jenis = $_POST["jenis"];
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
      $filename = $no_mobil."-".rand(1,1000).".".$extension;
      // generate nama file
      // exp : 111-804.JPG
      // rand() random nilai 1 - 1000
    }

    // load file config.?php


    // cek aksi
    if ($action == "insert") {
      // insert
      $sql = "insert into mobil values ('$no_mobil','$nama_mobil','$jenis','$tahun','$harga','$stok','$filename')";

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
        $filename = $no_mobil."-".rand(1,1000).".".$extension;
        // generate nama file
        // exp : 111-804.JPG
        // rand() random nilai 1 - 1000

        // ambil data yang akan di edit
        $sql = "select * from mobil where no_mobil = '$no_mobil'";
        $query = mysqli_query($connect,$sql);
        $hasil = mysqli_fetch_array($query);

        if (file_exists("image/".$hasil["image"])) {
          unlink("image/".$hasil["image"]);
          // mengahpus gambar yang terdahulu
        }

        // upload gambarnya
        move_uploaded_file($_FILES["image"]["tmp_name"],"image/$filename");
        // sintak untuk update
        $sql = "update mobil set nama_mobil = '$nama_mobil', jenis = '$jenis', 
        tahun = '$tahun', harga = '$harga', stok = '$stok', image='$filename' where no_mobil = '$no_mobil'";
      }
      else{
        // sintak untuk update
        $sql = "update mobil set nama_mobil = '$nama_mobil', jenis = '$jenis', 
        tahun = '$tahun', harga = '$harga', stok = '$stok', image='$filename' where no_mobil = '$no_mobil'";
      }

      // eksekusi perintah
      mysqli_query($connect,$sql);
    }

    //redirect ke halaman siswa.php
    header("location:mobil.php");
  }

  if (isset($_GET["hapus"])) {
    include("config.php");
    $no_mobil = $_GET["no_mobil"];
    // if (file_exists("image/".$hasil["image"])) {
    //   unlink("image/".$hasil["image"]);
    // }
    $sql = "delete from mobil where no_mobil='$no_mobil'";

    mysqli_query($connect, $sql);
    // direct ke halaman data siswa
    header("location:mobil.php");
  }
 ?>