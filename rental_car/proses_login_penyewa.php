<?php
session_start();
//session_start() digunakan sebagai tanda kalau kita akan session pada halaman ini
//session_start() harus diletakkan pada baris pertama
include("config.php");

//tampung data username dan passwordnya
$username = $_POST["username"];
$pass = $_POST["pass"];

if (isset($_POST["login_penyewa"])) {
    $sql = "select * from penyewa where username = '$username' and pass = '$pass'";
    //eksekusi query
    $query = mysqli_query($connect,$sql);
    $jumlah = mysqli_num_rows($query);
    //mysqli_num_rows digunakan untuk meghitun jumlah data hasil dari query

    if($jumlah > 0){
        // jika jumlahnya lebih dari nol artinya terdapat data admin yang sesuai dengan username dan password yang diinputkan
        // ini blok jika login berhasil
        // kita ubah hasil query ke array
        $customer = mysqli_fetch_array($query);

        //membuat session 
        $_SESSION["id_penyewa"] = $customer["id_penyewa"];
        $_SESSION["nama"] = $customer["nama"];
        $_SESSION["garasi"] = array();

        header("location:tampilan_penyewa.php");
    }else{
        // jika jumlahnya nol, artinya tidak ada data admin yang sesuai dengan username dan password yang diinputkan 
        // ini blok kode jika loginnya gagal / salah 
        header("location:login_penyewa.php");
    }
}

if (isset($_GET["logout"])) {
    //proses logout 
    //menghapus data session yang telah dibuat
    session_destroy();
    header("location:login_penyewa.php");
}
?>