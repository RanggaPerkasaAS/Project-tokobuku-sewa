<?php
   
if (isset($_POST["save_admin"])) {
    //isset digunakan untuk mengecek 
    //apakah ketika megakses file ini, dikirimkan
    //data dengan nama "save_siswa" dg method POST

    // kita tampung data yang dikirimkan
    $action = $_POST["action"];
    $id_admin = $_POST["id_admin"];
    $nama = $_POST["nama"];
    $kontak = $_POST["kontak"];
    $user = $_POST["username"];
    $pass = $_POST["password"];


    //load file config.php
    include("config.php");

    //cek aksi nya
    if ($action == "insert"){
        //sintak utuk insert
        $sql = "insert into admin values ('$id_admin','$nama','$kontak','$user','$pass')";
        //eksekusi
        mysqli_query($connect, $sql);
    }else if($action == "update"){
            //sintak update
        $sql= "update admin set 
                nama ='$nama',
                kontak='$kontak',
                username='$user',
                password='$pass'
                where id_admin='$id_admin'";
        }
        mysqli_query($connect, $sql);
    }

    //redirect ke halaman siswa.php
    header("location:admin.php");

if (isset ($_GET["hapus"])) {
    include("config.php");
    $id_admin = $_GET["id_admin"];
    $sql = "delete from admin
            where id_admin='$id_admin'";

    mysqli_query($connect, $sql);

    //direct ke halaman data siswa
    header("location:admin.php");
}
?>