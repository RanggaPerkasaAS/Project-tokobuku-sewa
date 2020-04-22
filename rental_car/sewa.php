<?php
session_start();
if (!isset($_SESSION["id_penyewa"])) {
    header("location:login_penyewa.php");
}
//memmanggil file config.php
//agar tidak perlu membuat koneksi baru
include ("config.php");

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Rental Sportcar</title>
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <script src="https://kit.fontawesome.com/dc8a681ba8.js" crossorigin="anonymous"></script>
  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/js/bootstrap.js"></script>
  <script src="assets/js/popper.min.js"></script>
  <script type="text/javascript">
  detail= (item) => {
            document.getElementById("no_mobil").value = item.no_mobil;
            document.getElementById("nama_mobil").innerHTML = item.nama_mobil;
            document.getElementById("jenis").innerHTML = item.jenis;
            document.getElementById("harga").innerHTML = item.harga;
            document.getElementById("stok").innerHTML = item.stok;
            document.getElementById("tahun").innerHTML = item.tahun;
            document.getElementById("jumlah_sewa").value ="1";

            document.getElementById('image').src = "image/" + item.image;
        }
  </script>

<style media="screen">
    body{
      background-image: linear-gradient(rgba(0,0,0,0.5),rgba(0,0,0,0.5)), url("leon-seibert-AGa9slidhVc-unsplash.jpg")  ;
        background-position : center;
        background-repeat : no-repeat;
        background-size : cover;
        background-attachment : fixed;
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
        font-family: Agency FB;
        font-variant: initial;
        margin-top: 150px;
        text-shadow: 5px 5px 5px grey;
      }
    }

    </style>
</head>
<body>

<nav class= "navbar navbar-dark sticky-top" style="background-color : #242121" id="Home">
        <a href="3" target="blank">
          <img src="#" width="50">
        </a>
        <form action="tampilan_penyewa.php" method ="post" class="form-inline my-2 my-lg-0">
              <input type="search" name="cari" class="form-control mr-sm-2" placeholder="Pencarian...">
              <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#menu">
          <span class="navbar navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="menu">
          <ul class="navbar-nav">
            <li class="nav-item"><a href="http://localhost/rental_car/tampilan_penyewa.php" class="nav-link">
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
  <div class="col-sm-6 col-sm-12">
    <h1 class="judul text-center">Dealer Sportcar</h1>
  </div>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
  <?php
    //membuat perintah sql untuk menampilkan data siswa
    if (isset($_POST["cari"])) {
        $cari = $_POST["cari"];
        $sql = "select * from mobil 
        where no_mobil like '%$cari%' 
        or nama_mobil like '%$cari%' 
        or jenis like '%$cari%' 
        or tahun like '%$cari%'
        or harga like '%$cari%'
        or stok like '%$cari%'";
    }else {
        //query jika tidak mencari
        $sql ="select * from mobil";
    }
    //eksekusi perintah SQL-nya
    $query = mysqli_query($connect, $sql);
  ?>
    <div class="container">
        <div class="card mt-3">
            <div class="card-header bg-dark">
                <h4 class="text-white">Riwayat Sewa</h4>
            </div>
            <div class="card-body">
            <?php
            $sql = "select * from sewa s inner join penyewa p 
            on s.id_penyewa = p.id_penyewa 
            where s.id_penyewa = '".$_SESSION["id_penyewa"]."' order by s.tgl desc"; 
            $query = mysqli_query($connect,$sql);
            ?>

                <ul class="list-group">
                    <?php foreach($query as $sewa): ?>
                        <li class="list-group-item mb-4">
                        <h6>ID SEWA : <?php echo $sewa ["id_sewa"]; ?></h6>
                        <h6>Nama Pembeli : <?php echo $sewa ["nama"]; ?></h6>
                        <h6>Tgl. Transaksi : <?php echo $sewa ["tgl"]; ?></h6>
                        <h6>List Barang</h6>


                        <?php 
                        $sql2 = "select * from detail_sewa d inner join mobil m 
                        on d.no_mobil = m.no_mobil where d.id_sewa = '".$sewa["id_sewa"]."'";
                        $query2 = mysqli_query($connect,$sql2);
                        ?>

                        <table class="table table-border-less">
                            <thead>
                                <tr>
                                    <th>Judul</th>
                                    <th>Lama Sewa</th>
                                    <th>Harga</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $total = 0; foreach ($query2 as $detail): ?>
                                    <tr>
                                        <td><?php echo $detail["nama_mobil"] ?></td>
                                        <td><?php echo $detail["lama_sewa"] ?></td>
                                        <td>Rp<?php echo number_format($detail["harga_sewa"]) ?></td>
                                        <td>
                                        Rp <?php echo number_format($detail["harga_sewa"] * $detail["lama_sewa"]); ?>
                                        </td>
                                    </tr>
                                <?php $total += ($detail["harga_sewa"]*$detail["lama_sewa"]);
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

</html>