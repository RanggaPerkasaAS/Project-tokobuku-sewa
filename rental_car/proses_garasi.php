<?php
session_start();
include("config.php");

if(isset($_POST["add_to_garasi"])){
    //tampung kode_buku dan jumlah sewa
    $no_mobil = $_POST["no_mobil"];
    $jumlah_sewa = $_POST["jumlah_sewa"];

    // ambil data buku dari data base dengan kode buku yang dipilih
    $sql = "select * from mobil where no_mobil = '$no_mobil'";
    $query = mysqli_query($connect, $sql); // eksekusi sintak sql
    $mobil = mysqli_fetch_array($query); // menampung data dari data base ke array
    echo $sql;
    // membuat sebuah array 
    $item = [
    "no_mobil" => $mobil["no_mobil"],
    "nama_mobil" => $mobil["nama_mobil"],
    "image" => $mobil["image"] ,
    "harga" => $mobil["harga"],
    "jumlah_sewa" => $jumlah_sewa
    ];

    //memasukkan item ke keranjang cart
    array_push($_SESSION["garasi"],$item);
    $sql2 = "update mobil set stok = stok - 1 where no_mobil ='$no_mobil'";
    mysqli_query($connect,$sql2);
    header("location:tampilan_penyewa.php");
}

//mengahapus item pada cart
if(isset($_GET["hapus"])){
    //tampung data kode_buku yang dihapus
    $no_mobil = $_GET["no_mobil"];

    $index = array_search(
        $kode_buku,array_column(
            $_SESSION["garasi"],"no_mobil"
        )
    );

    //hapus item pada cart 
    array_splice($_SESSION["garasi"],$index,1);
    header("location:garasi.php");
}

//checkout 
if(isset($_GET["checkout"])){
    // memasukkan data pada cart ke databese
    $id_sewa = "ID".rand(1,10000);
    $tgl = date("Y-m-d H:i:s");
    $id_penyewa = $_SESSION["id_penyewa"];

    //buat query 
    $sql = "insert into sewa values ('$id_sewa','$tgl','$id_penyewa')";
    mysqli_query($connect,$sql);//ekssekusi query


    foreach ($_SESSION["garasi"] as $garasi) {
        $no_mobil = $garasi ["no_mobil"];
        $jumlah = $garasi ["jumlah_sewa"];
        $harga = $garasi ["harga"];

        //buat query insert ke tabel detail 
        $sql ="insert into detail_sewa values ('$id_sewa','$no_mobil','$jumlah','$harga')";
        mysqli_query($connect,$sql);

        $sql2 = "update mobil set stok = stok + 1 where no_mobil ='$no_mobil'";
        mysqli_query($connect,$sql2);

    }
    //kita kosongkan cart
    $_SESSION["garasi"] = array();
    header("location:sewa.php");
}
?>