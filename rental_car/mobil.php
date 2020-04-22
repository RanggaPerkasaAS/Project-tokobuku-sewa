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
    <title>Mobil-Mobli</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/popper.min.js" ></script>
    <script type="text/javascript">
        Add = () => {
        document.getElementById('action').value = "insert";
        document.getElementById('no_mobil').value = "";
        document.getElementById('nama_mobil').value = "";
        document.getElementById('jenis').value = "";
        document.getElementById('tahun').value = "";
        document.getElementById('harga').value = "";
        document.getElementById('stok').value = "";
    }

    Edit = (item) => {
        document.getElementById('action').value = "update";
        document.getElementById('no_mobil').value = item.no_mobil;
        document.getElementById('nama_mobil').value = item.nama_mobil;
        document.getElementById('jenis').value = item.jenis;
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
      <form action="mobil.php" method ="post" class="form-inline my-2 my-lg-0">
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
        <!-- start card -->
        <div class = "card ">
            <div class = "card-header bg-primary">
            <h4> Rental Supercar Hypercar untuk kondangan & Balapan </h4>
            </div>
            <div class="card-body">

            <table class="table" border="1">
            <br>
        <thead>
            <tr>
                <th>Nomor Mesin</th>
                <th>Nama Mobil</th>
                <th>Jenis</th>
                <th>Tahun</th>
                <th>Harga</th>
                <th>Stok </th>
                <th>Image</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($query as $mobil ): ?>
            <tr>
                <td><?php echo $mobil ["no_mobil"];?></td>
                <td><?php echo $mobil ["nama_mobil"];?></td>
                <td><?php echo $mobil ["jenis"];?></td>
                <td><?php echo $mobil["tahun"];?></td>
                <td><?php echo $mobil["harga"];?></td>
                <td><?php echo $mobil["stok"];?></td>
                <td>
                <img src="<?php echo  'image/'.$mobil['image']; ?>" alt="Gambar Car" width="300" height="200">
                </td>
                <td>
                <button type="button" name="Edit" class="btn btn-sm btn-info"
                              data-toggle="modal" data-target="#modal_mobil"
                              onclick='Edit(<?php echo json_encode($mobil);?>)'>Edit</button>

                      <a href="proses_mobil.php?hapus=true&no_mobil=<?php echo $mobil["no_mobil"];?>"
                          onclick="return confirm('Apakah anda yakin ingin menghapus data ini ?')">
                          <button type="button" name="Hapus" class="btn btn-sm btn-danger"
                                  data-toggle="modal" data-target="#modal_mobil"
                                  onclick="Hapus(<?php ?>);">
                            Hapus
                          </button>
                      </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <button data-toggle="modal" data-target="#modal_mobil" type="button" class="btn btn-sm btn-success" onclick="Add()">Tambah Data<button>
    </div>
    </div>
    <!-- end card -->

    <!-- form modal -->
    <div class="modal fade" id = "modal_mobil">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="proses_mobil.php" 
                    method="post" enctype="multipart/form-data">
                        <div class="modal-header bg-info text-white">
                        <h4>Form Buku</h4>
                        </div>
                        <div class="modal-body">
                        <input type="hidden" name="action" id="action">
                        Nomor Mesin
                        <input type="number" name="no_mobil" id="no_mobil" class="form-control" required/>
                        Nama Mobil
                        <input type="text" name="nama_mobil" id="nama_mobil" class="form-control" required/>
                        Jenis
                        <input type="text" name="jenis" id="jenis" class="form-control" required/>
                        Tahun 
                        <input type="text" name="tahun" id="tahun" class="form-control" required/>
                        Harga
                        <input type="text" name="harga" id="harga" class="form-control" required/>
                        Stok
                        <input type="text" name="stok" id="stok" class="form-control" required/>
                        Cover
                        <input type="file" name="image" id="image" class="form-control"/>
                        </div>
                        <div class="modal-footer">
                        <button type="submit" name="save_mobil" class="btn btn-primary">
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