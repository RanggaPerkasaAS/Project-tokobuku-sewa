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
            document.getElementById("jumlah_sewa").max = item.stok;

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

    .button5 {border-radius: 80%;}
    .button {
    background-color: rgba(255,255,255,0.8); ; 
    border: none;
    color: white;
    padding: 20px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
    padding-right: 30px;
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
            <li class="nav-item"><a href="#" class="nav-link">
            <i class="fa fa-houzz"></i> Home</a></li>
            <li class="nav-item"><a href="#" target="blank" class="nav-link">
            <i class="fa fa-shopping-cart"> </i> How to Order</a></li>
            <li class="nav-item"><a href="#" target="blank" class="nav-link">
            <i class="fa fa-phone"></i> Contact</a></li>
            <li class="nav-item"><a href="proses_login_penyewa.php?logout=true" class="nav-link">
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
  <div class="row">
  <?php foreach ($query as $mobil): ?>
    <div class="col-6 col-sm-6 col-md-6 col-lg-4 col-xl-3">
      <div class="card border-white m-0.5 mt-4">
      <div class="card-header text-white" style="background-color : #242121" align="center"><?php echo $mobil["nama_mobil"]; ?></div>
        <img src="<?php echo 'image/'.$mobil['image']; ?>" alt="mobil" width="100%" height="190" />
        <div class="card-body border-dark text-white"  style="background-color : #242121" align="center"><?php echo "Rp ".$mobil["harga"]; ?></div>
        <div class="card-footer bg-light border-dark">
          <center><button type="button" name="info" class="btn btn-sm btn-outline-dark text-center" onclick='detail(<?php echo json_encode($mobil); ?>)'
          data-toggle="modal" data-target="#modal_detail">Lihat</button></center>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
  </div>
<div class="modal" id="modal_detail">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-dark">
                        <h4 class="text-white">Detail Mobil</h4>
                    </div>
                    <div class="modal-body bg-secondary text-warning">
                        <div class="row">
                            <div class="col-6">
                                <img id="image" style="width:100%; height:auto;">
                            </div>
                            <div class="col-6">
                                Nama Mobil :
                                <h4 id="nama_mobil"></h4>
                                Jenis :
                                <h4 id="jenis"></h4>
                                Tahun
                                <h4 id="tahun"></h4>  
                                Harga :
                                <br>Rp
                                <h5 id="harga"></h5>/hari
                                <br>
                                Max. Lama Sewa
                                <h4 id="stok"></h4> hari
                                <form action="proses_garasi.php" method="post">
                                <input type="hidden" name="no_mobil" id="no_mobil">
                                Lama Sewa
                                <input type="number" name="jumlah_sewa" id="jumlah_sewa"
                                class="form-control" min="1">
                                <br>
                                <button type="submit" name="add_to_garasi" class="btn btn-outline-warning"><i class="fa fa-warehouse"></i>
                                Tambahkan ke Garasi
                                </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 

<button class="button button5 fixed-bottom " >
<a href="garasi.php"><i class="fa fa-warehouse"></i>(<?php echo count($_SESSION["garasi"]);?>)</a>
</button> 
<br><br>   
<center>
<h5>Copyright © Ranggaaaa</h5>
</center>
</body>
</html>