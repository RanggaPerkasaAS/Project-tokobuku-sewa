<?php
session_start();
//session_start() digunakan sebagai tanda kalau kita akan session pada halaman ini
//session_start() harus diletakkan pada baris pertama
include("config.php");

//tampung data username dan passwordnya
$username = $_POST["username"];
$pass = $_POST["pass"];

if (isset($_POST["login_pemilik"])) {
    $sql = "select * from pemilik where username = '$username' and pass = '$pass'";
    //eksekusi query
    $query = mysqli_query($connect,$sql);
    $jumlah = mysqli_num_rows($query);
    //mysqli_num_rows digunakan untuk meghitun jumlah data hasil dari query

    if($jumlah > 0){
        // jika jumlahnya lebih dari nol artinya terdapat data admin yang sesuai dengan username dan password yang diinputkan
        // ini blok jika login berhasil
        // kita ubah hasil query ke array
        $pemilik = mysqli_fetch_array($query);

        //membuat session 
        $_SESSION["id_pemilik"] = $pemilik["id_pemilik"];
        $_SESSION["nama"] = $pemilik["nama"];

        header("location:pemilik.php");
    }else{
        // jika jumlahnya nol, artinya tidak ada data admin yang sesuai dengan username dan password yang diinputkan 
        // ini blok kode jika loginnya gagal / salah 
        header("location:login_pemilik.php");
        
    }
}

if (isset($_GET["logout"])) {
    //proses logout 
    //menghapus data session yang telah dibuat
    session_destroy();
    header("location:login_pemilik.php");
}
?>