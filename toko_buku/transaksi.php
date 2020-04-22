<?php
session_start();
if (!isset($_SESSION["id_customer"])) {
    header("location:login_customer.php");
}
//memmanggil file config.php
//agar tidak perlu membuat koneksi baru
include ("config.php");

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tampilan </title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/dc8a681ba8.js" crossorigin="anonymous"></script>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script type="text/javascript">
        detail= (item) => {
            document.getElementById("kode_buku").value = item.kode_buku;
            document.getElementById("judul").innerHTML = item.judul;
            document.getElementById("penulis").innerHTML = item.penulis;
            document.getElementById("harga").innerHTML = item.harga;
            document.getElementById("stok").innerHTML = item.stok;
            document.getElementById("jumlah_beli").value ="1";

            document.getElementById('image').src = "image/" + item.image;
        }
    </script>
    <style media="screen">
        *{
            box-sizing:border-box;
        }
        [class*="col-"] {float: left; padding: 15px;}
        [class*="col-"] {width: 100%;}
        .cover{
            background: url("brown-book-page-1112048.jpg");
            background-size: cover;
            height: 90vh;
        }
        @media only screen and (max-width: 560px) {
            .judul{
                display: none;
            }
        }
        @media only screen and (min-width: 561px) {
            .judul{
                color: white;
                font-size: 70px;
                font-family:cursive;
                font-variant: initial;
                margin-top: 265px;
                text-shadow: 5px 5px 5px black;
            }
        }

        .logo{
            margin-top: 170px;
            width: 350px;
        }
        .title{
            width: 85%;
            color: black;
            font-family: Arial, sans-serif;
        }
        .box{
            text-align: center;
        }
        .gbr{
            width: 200px;
            height: 200px;
            border-radius: 45%;
            margin: 0 auto;
            border: 20px double green;
        }
        .textimage{
            margin-top: 20px;
            color: black;
            font-family:arial;
            font-style: oblique;
        }
    </style>
</head>
<body>
<nav class= "navbar navbar-expand-md navbar-dark bg-dark sticky-top" id="Home">
        <a href="3" target="blank">
            <img src="kisspng-logo-library-graphic-design-corporate-identity-feather-logo-5b312461565de3.1811352315299472333538.png" width="80">
        </a>
        <form action="tampilan_customer.php" method ="post" class="form-inline my-2 my-lg-0">
            <input type="search" name="cari" class="form-control mr-sm-2" placeholder="Pencarian...">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#menu">
            <span class="navbar navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="menu">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="cart.php" class="nav-link">
                    Cart (<?php echo count($_SESSION["cart"]); ?>)
                    </a>
                </li>
                <li class="nav-item"><a href="http://localhost/toko_buku/tampilan_customer.php" class="nav-link">
                <i class="fa fa-houzz"></i> Home</a></li>
                <li class="nav-item"><a href="#" target="blank" class="nav-link">
                <i class="fa fa-shopping-cart"> </i> How to Order</a></li>
                <li class="nav-item"><a href="#" target="blank" class="nav-link">
                <i class="fa fa-phone"></i> Contact</a></li>
                <li class="nav-item"><a href="proses_login_customer.php?logout=true" class="nav-link">
                <i class="fa fa-sign-out-alt"></i>Logout</a></li>
            </ul>
        </div>
    </nav>
    <div class="container-fluid cover">
        <div class="row">
            <div class="col-lg-6 col-sm-12 text-center">
                <img src="kisspng-logo-library-graphic-design-corporate-identity-feather-logo-5b312461565de3.1811352315299472333538.png" class="logo">
            </div>
            <div class="col-lg-6 col-sm-12">
                <h1 class="judul text-left">Toko Buku Online</h1>
            </div>
        </div>
    </div>
    
    <?php
    //membuat perintah sql untuk menampilkan data siswa
    if (isset($_POST["cari"])) {
        $cari = $_POST["cari"];
        $sql = "select * from buku 
        where kode_buku like '%$cari%' 
        or judul like '%$cari%' 
        or penulis like '%$cari%' 
        or tahun like '%$cari%'
        or harga like '%$cari%'
        or stok like '%$cari%'";
    }else {
        //query jika tidak mencari
        $sql ="select * from buku";
    }
    //eksekusi perintah SQL-nya
    $query = mysqli_query($connect, $sql);
    ?>

    <div class="container">
        <div class="card mt-3">
            <div class="card-header bg-dark">
                <h4 class="text-white">Riwayat Transaksi</h4>
            </div>
            <div class="card-body">
            <?php
            $sql = "select * from transaksi t inner join customer c 
            on t.id_customer = c.id_customer 
            where t.id_customer = '".$_SESSION["id_customer"]."' order by t.tgl desc"; 
            $query = mysqli_query($connect,$sql);
            ?>

                <ul class="list-group">
                    <?php foreach($query as $transaksi): ?>
                        <li class="list-group-item mb-4">
                        <h6>ID TRANSAKSI : <?php echo $transaksi ["id_transaksi"]; ?></h6>
                        <h6>Nama Pembeli : <?php echo $transaksi ["nama"]; ?></h6>
                        <h6>Tgl. Transaksi : <?php echo $transaksi ["tgl"]; ?></h6>
                        <h6>List Barang</h6>


                        <?php 
                        $sql2 = "select * from detail_transaksi d inner join buku b 
                        on d.kode_buku = b.kode_buku where d.id_transaksi = '".$transaksi["id_transaksi"]."'";
                        $query2 = mysqli_query($connect,$sql2);
                        ?>

                        <table class="table table-border-less">
                            <thead>
                                <tr>
                                    <th>Judul</th>
                                    <th>Jumlah</th>
                                    <th>Harga</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $total = 0; foreach ($query2 as $detail): ?>
                                    <tr>
                                        <td><?php echo $detail["judul"] ?></td>
                                        <td><?php echo $detail["jumlah"] ?></td>
                                        <td>Rp<?php echo number_format($detail["harga_beli"]) ?></td>
                                        <td>
                                        Rp <?php echo number_format($detail["harga_beli"] * $detail["jumlah"]); ?>
                                        </td>
                                    </tr>
                                <?php $total += ($detail["harga_beli"]*$detail["jumlah"]);
                                 endforeach ?>
                            </tbody>
                        </table>
                        <h5 class="text-danger">Rp <?php echo number_format($total) ?></h5>
                        </li>
                    <?php endforeach ?>
                </ul>
            </div>
        </div>
    </div>
</body>