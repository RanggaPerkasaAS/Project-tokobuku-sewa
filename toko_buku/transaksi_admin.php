<?php
session_start();
if (!isset($_SESSION["id_admin"])) {
    header("location:login_admin.php");
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
    <title>BUKU</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script type="text/javascript">
    Add = () => {
        document.getElementById('action').value = "insert";
        document.getElementById('kode_buku').value = "";
        document.getElementById('judul').value = "";
        document.getElementById('penulis').value = "";
        document.getElementById('tahun').value = "";
        document.getElementById('harga').value = "";
        document.getElementById('stok').value = "";
    }

    Edit = (item) => {
        document.getElementById('action').value = "update";
        document.getElementById('kode_buku').value = item.kode_buku;
        document.getElementById('judul').value = item.judul;
        document.getElementById('penulis').value = item.penulis;
        document.getElementById('tahun').value = item.tahun;
        document.getElementById('harga').value = item.harga;
        document.getElementById('stok').value = item.stok;
    }
    </script>

<style media="screen">
        *{
            box-sizing:border-box;
        }
        [class*="col-"] {float: left; padding: 15px;}
        [class*="col-"] {width: 100%;}
        .cover{
            background: url("large-jessica-ruscello-oqsctabgksy-unsplash-276c39eb36b80e49915bd8675dbe31b3.jpg");
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
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
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
<nav class="navbar navbar-expand-md bg-primary navbar-dark sticky-top" id="Home">
        <a href="3" target="blank">
            <img src="medium_lt5c35c5db8631a.jpg" width="80">
        </a>

        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#menu">
            <span class="navbar navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="menu">
            <ul class="navbar-nav">
                <li class="nav-item"><a href="#" class="nav-link">Home</a></li>
                <li class="nav-item"><a href="http://localhost/toko_buku/admin.php#" target="blank" class="nav-link">Data Admin</a></li>
                <li class="nav-item"><a href="#" target="blank" class="nav-link">Buku</a></li>
                <li class="nav-item"><a href="http://localhost/toko_buku/customer.php#" target="blank" class="nav-link">Customer</a></li>
                <li class="nav-item"><a href="proses_login_admin.php?logout=true" class="nav-link"><?php echo $_SESSION["nama"]; ?> | Logout</a></li>
            </ul>
        </div>
    </nav>
    <div class="container-fluid cover">
        <div class="row">
            <div class="col-lg-6 col-sm-12 text-center">
                <img src="medium_lt5c35c5db8631a.jpg" class="logo">
            </div>
            <div class="col-lg-6 col-sm-12">
                <h1 class="judul text-left">Data Buku</h1>
            </div>
        </div>
    </div>
    <br>
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
    $query = mysqli_query($connect, $sql);
     ?>
     <ul class="list-group">
       <?php foreach ($query as $transaksi): ?>
         <li class="list-group-item mb-4">
         <h6>ID Transaksi: <?php echo $transaksi["id_transaksi"]; ?></h6>
         <h6>Nama Pembeli: <?php echo $transaksi["nama"]; ?></h6>
         <h6>Tgl. Transaksi: <?php echo $transaksi["tgl"]; ?></h6>
         <h6>List Barang: </h6>

         <?php
         $sql2 = "select * from detail_transaksi d inner join buku b
         on d.kode_buku = b.kode_buku
         where d.id_transaksi = '".$transaksi["id_transaksi"]."'";
         $query2 = mysqli_query($connect, $sql2);
          ?>

          <table class="table table-borderless">
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
                  <td>Rp <?php echo number_format($detail["harga_beli"]); ?></td>
                  <td>
                    Rp <?php echo number_format($detail["harga_beli"]*$detail["jumlah"]); ?>
                  </td>
                </tr>
              <?php $total += ($detail['harga_beli']*$detail["jumlah"]); endforeach; ?>
            </tbody>
          </table>
          <h6 class="text-danger">Rp <?php echo number_format($total); ?></h6>
        </li>
       <?php endforeach; ?>
     </ul>
  </div>
</div>
</div>