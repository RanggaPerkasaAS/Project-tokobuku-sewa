<?php
//koneksi ke data base 
$host = "localhost"; //server local
$username = "root"; 
$password = "";
$db = "toko_buku";
$connect = mysqli_connect($host,$username,$password,$db);

//cek koneksi database
if (mysqli_connect_errno()) {
    echo mysqli_connect_errno();
}else{
    echo "koneksi berhasil";
}
?>