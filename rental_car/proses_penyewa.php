<?php
if (isset($_POST["save_penyewa"])) {
    //isset digunakan untuk mengecek 
    //apakah ketika megakses file ini, dikirimkan
    //data dengan nama "save_siswa" dg method POST

    // kita tampung data yang dikirimkan
    $action = $_POST["action"];
    $id_penyewa = $_POST["id_penyewa"];
    $nama = $_POST["nama"];
    $alamat = $_POST["alamat"];
    $kontak = $_POST["kontak"];
    $usernam = $_POST["username"];
    $pass = $_POST["pass"];


    //load file config.php
    include("config.php");

    //cek aksi nya
    if ($action == "insert"){
        //sintak utuk insert
        $sql = "insert into penyewa values ('$id_penyewa','$nama','$alamat','$kontak','$usernam','$pass')";
        //eksekusi
        mysqli_query($connect, $sql);
    }else if($action == "update"){
            //sintak update
        $sql= "update penyewa set 
                nama ='$nama',
                alamat = '$alamat',
                kontak='$kontak',
                username='$usernam',
                pass='$pass'
                where id_penyewa='$id_penyewa'";
        }
        mysqli_query($connect, $sql);
    }

    //redirect ke halaman siswa.php
    header("location:penyewa.php");

if (isset ($_GET["hapus"])) {
    include("config.php");
    $id_admin = $_GET["id_penyewa"];
    $sql = "delete from penyewa
            where id_penyewa='$id_penyewa'";

    mysqli_query($connect, $sql);

    //direct ke halaman data siswa
    header("location:penyewa.php");
}
?>