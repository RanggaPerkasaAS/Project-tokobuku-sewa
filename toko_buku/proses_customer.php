<?php
if (isset($_POST["save_customer"])) {
    //isset digunakan untuk mengecek 
    //apakah ketika megakses file ini, dikirimkan
    //data dengan nama "save_siswa" dg method POST

    // kita tampung data yang dikirimkan
    $action = $_POST["action"];
    $id_customer = $_POST["id_customer"];
    $nama = $_POST["nama"];
    $alamat = $_POST["alamat"];
    $kontak = $_POST["kontak"];
    $usernam = $_POST["username"];
    $passw = $_POST["password"];


    //load file config.php
    include("config.php");

    //cek aksi nya
    if ($action == "insert"){
        //sintak utuk insert
        $sql = "insert into customer values ('$id_customer','$nama','$alamat','$kontak','$usernam','$passw')";
        //eksekusi
        mysqli_query($connect, $sql);
    }else if($action == "update"){
            //sintak update
        $sql= "update customer set 
                nama ='$nama',
                alamat = '$alamat',
                kontak='$kontak',
                username='$usernam',
                password='$passw'
                where id_customer='$id_customer'";
        }
        mysqli_query($connect, $sql);
    }

    //redirect ke halaman siswa.php
    header("location:customer.php");

if (isset ($_GET["hapus"])) {
    include("config.php");
    $id_admin = $_GET["id_customer"];
    $sql = "delete from customer
            where id_customer='$id_customer'";

    mysqli_query($connect, $sql);

    //direct ke halaman data siswa
    header("location:customer.php");
}
?>