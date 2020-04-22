<?php
   
if (isset($_POST["save_pemilik"])) {
    //isset digunakan untuk mengecek 
    //apakah ketika megakses file ini, dikirimkan
    //data dengan nama "save_siswa" dg method POST

    // kita tampung data yang dikirimkan
    $action = $_POST["action"];
    $id_pemilik = $_POST["id_pemilik"];
    $nama = $_POST["nama"];
    $kontak = $_POST["kontak"];
    $user = $_POST["username"];
    $pass = $_POST["pass"];


    //load file config.php
    include("config.php");

    //cek aksi nya
    if ($action == "insert"){
        //sintak utuk insert
        $sql = "insert into pemilik values ('$id_pemilik','$nama','$kontak','$user','$pass')";
        //eksekusi
        mysqli_query($connect, $sql);
    }else if($action == "update"){
            //sintak update
        $sql= "update pemilik set 
                nama ='$nama',
                kontak='$kontak',
                username='$user',
                pass ='$pass'
                where id_pemilik='$id_pemilik'";
        }
        mysqli_query($connect, $sql);
    }

    //redirect ke halaman siswa.php
    header("location:pemilik.php");

if (isset ($_GET["hapus"])) {
    include("config.php");
    $id_pemilik = $_GET["id_pemilik"];
    $sql = "delete from pemilik
            where id_pemilik='$id_pemilik'";

    mysqli_query($connect, $sql);

    //direct ke halaman data siswa
    header("location:pemilik.php");
}
?>