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
    <div>
        <!-- start card -->
        <div class = "card">
            <div class = "card-header bg-info text-white">
            <h4> Buku Buku </h4>
            </div>
            <div class="card-body">

            <form action="buku.php" method ="post">
            <input type="text" name="cari" class="form-control" placeholder="Pencarian...">
            </form>
            <table class="table" border="1">
        <thead>
            <tr>
                <th>Kode Buku</th>
                <th>Judul</th>
                <th>Penulis</th>
                <th>Tahun</th>
                <th>Harga</th>
                <th>Stok </th>
                <th>Image</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($query as $buku ): ?>
            <tr>
                <td><?php echo $buku ["kode_buku"];?></td>
                <td><?php echo $buku ["judul"];?></td>
                <td><?php echo $buku ["penulis"];?></td>
                <td><?php echo $buku["tahun"];?></td>
                <td><?php echo $buku["harga"];?></td>
                <td><?php echo $buku["stok"];?></td>
                <td>
                <img src="<?php echo  'image/'.$buku['image']; ?>" alt="Gambar buku" width="300" height="200">
                </td>
                <td>
                <button type="button" name="Edit" class="btn btn-sm btn-info"
                              data-toggle="modal" data-target="#modal_buku"
                              onclick='Edit(<?php echo json_encode($buku);?>)'>Edit</button>

                      <a href="proses_buku.php?hapus=true&kode_buku=<?php echo $buku["kode_buku"];?>"
                          onclick="return confirm('Apakah anda yakin ingin menghapus data ini ?')">
                          <button type="button" name="Hapus" class="btn btn-sm btn-danger"
                                  data-toggle="modal" data-target="#modal_buku"
                                  onclick="Hapus(<?php ?>);">
                            Hapus
                          </button>
                      </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <button data-toggle="modal" data-target="#modal_buku" type="button" class="btn btn-sm btn-success" onclick="Add()">Tambah Data<button>
            </div>
        </div>
        <!-- end card -->

        <!-- form modal -->
        <div class="modal fade" id = "modal_buku">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="proses_buku.php" 
                    method="post" enctype="multipart/form-data">
                        <div class="modal-header bg-info text-white">
                        <h4>Form Buku</h4>
                        </div>
                        <div class="modal-body">
                        <input type="hidden" name="action" id="action">
                        Kode buku
                        <input type="number" name="kode_buku" id="kode_buku" class="form-control" required/>
                        Judul
                        <input type="text" name="judul" id="judul" class="form-control" required/>
                        Penulis
                        <input type="text" name="penulis" id="penulis" class="form-control" required/>
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
                        <button type="submit" name="save_buku" class="btn btn-primary">
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