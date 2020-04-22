<?php
session_start();
if (!isset($_SESSION["id_pemilik"])) {
    header("location:login_pemilik.php");
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
    <title>Sultan-Sultan</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script type="text/javascript">
    Add = () => {
        document.getElementById('action').value = "insert";
        document.getElementById('id_pemilik').value = "";
        document.getElementById('nama').value = "";
        document.getElementById('kontak').value = "";
        document.getElementById('username').value = "";
        document.getElementById('pass').value = "";
    }

    Edit = (item) => {
        document.getElementById('action').value = "update";
        document.getElementById('id_pemilik').value = item.id_admin;
        document.getElementById('nama').value = item.nama;
        document.getElementById('kontak').value = item.kontak;
        document.getElementById('username').value = item.username;
        document.getElementById('pass').value = item.pass;
    }
    </script>
    <style media="screen">
        *{
            box-sizing:border-box;
        }
        [class*="col-"] {float: left; padding: 15px;}
        [class*="col-"] {width: 100%;}
        .cover{
            background: url("five-assorted-color-cars-parked-inside-room-1231643.jpg");
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
                color: red;
                font-size: 70px;
                font-family:cursive;
                font-variant: initial;
                margin-top: 265px;
                text-shadow: 2px 2px 2px black;
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
<nav class="navbar navbar-expand-lg navbar-light bg-primary sticky-top">

    <a class="navbar-brand" href="#">Rental SportCar</a>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">

      <ul class="navbar-nav mr-auto">
        <li class="nav-item">
          <a class="nav-link" href="http://localhost/rental_car/pemilik.php">Pemilik</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="http://localhost/rental_car/mobil.php">Mobil</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="http://localhost/rental_car/penyewa.php" >Penyewa</a>
        </li>
        <li class="nav-item"><a href="proses_login_pemilik.php?logout=true" 
        class="nav-link">Logout</a>
        </li>
      </ul>

      <form action="pemilik.php" method ="post" class="form-inline my-2 my-lg-0">
            <input type="text" name="cari" class="form-control" placeholder="Pencarian...">
            <button class="btn btn-outline-dark my-2 my-sm-0" type="submit">Cari</button>
            </form>
   </div>
</nav>

<div class="container-fluid cover">
        <div class="row">
            <div class="col-lg-6 col-sm-12">
                <h1 class="judul text-left">Rental SportCar</h1>
            </div>
        </div>
    </div>
    <br>

    <?php
    //membuat perintah sql untuk menampilkan data siswa
    if (isset($_POST["cari"])) {
        $cari = $_POST["cari"];
        $sql = "select * from pemilik 
        where id_pemilik like '%$cari%' 
        or nama like '%$cari%' 
        or kontak like '%$cari%' 
        or username like '%$cari%'
        or pass like '%$cari%'";
    }else {
        //query jika tidak mencari
        $sql ="select * from pemilik";
    }
    //eksekusi perintah SQL-nya
    $query = mysqli_query($connect, $sql);
    ?>

    <div class="container">
        <!-- start card -->
        <div class = "card">
            <div class = "card-header bg-primary text-white">
            <h4> Data Sultan </h4>
            </div>
            <div class="card-body">

            <table class="table" border="1">
            <br>
        <thead>
            <tr>
                <th>Id Pemilik</th>
                <th>Nama</th>
                <th>Kontak</th>
                <th>username</th>
                <th>Password</th>
                <th> Option</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($query as $pemilik ): ?>
            <tr>
                <td><?php echo $pemilik ["id_pemilik"];?></td>
                <td><?php echo $pemilik ["nama"];?></td>
                <td><?php echo $pemilik ["kontak"];?></td>
                <td><?php echo $pemilik["username"];?></td>
                <td><?php echo $pemilik["pass"];?></td>
                <td>
                <button type="button" name="Edit" class="btn btn-sm btn-info"
                              data-toggle="modal" data-target="#modal_pemilik"
                              onclick='Edit(<?php echo json_encode($pemilik);?>)'>Edit</button>

                      <a href="proses_pemilik.php?hapus=true&id_pemilik=<?php echo $pemilik["id_pemilik"];?>"
                          onclick="return confirm('Apakah anda yakin ingin menghapus data ini ?')">
                          <button type="button" name="Hapus" class="btn btn-sm btn-danger"
                                  data-toggle="modal" data-target="#modal_pemilik"
                                  onclick="Hapus(<?php ?>);">
                            Hapus
                          </button>
                      </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <button data-toggle="modal" data-target="#modal_pemilik" type="button" class="btn btn-sm btn-success" onclick="Add()">Tambah Data<button>
            </div>
        </div>
        <!-- end card -->

        <!-- form modal -->
        <div class="modal fade" id = "modal_pemilik">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="proses_pemilik.php" 
                    method="post" enctype="multipart/form-data">
                        <div class="modal-header bg-info text-white">
                        <h4>form Pemilik</h4>
                        </div>
                        <div class="modal-body">
                        <input type="hidden" name="action" id="action">
                        Id Pemilik
                        <input type="number" name="id_pemilik" id="id_pemilik" class="form-control" required/>
                        Nama
                        <input type="text" name="nama" id="nama" class="form-control" required/>
                        Kontak
                        <input type="text" name="kontak" id="kontak" class="form-control" required/>
                        Username
                        <input type="text" name="username" id="username" class="form-control" required/>
                        Password
                        <input type="text" name="pass" id="pass" class="form-control" required/>
                        </div>
                        <div class="modal-footer">
                        <button type="submit" name="save_pemilik" class="btn btn-primary">
                        simpan                            
                        </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- end form modal -->
    </div>
</body>
</html>