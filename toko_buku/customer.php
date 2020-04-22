<?php
//memmanggil file config.php
//agar tidak perlu membuat koneksi baru
include ("config.php");

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script type="text/javascript">
    Add = () => {
        document.getElementById('action').value = "insert";
        document.getElementById('id_customer').value = "";
        document.getElementById('nama').value = "";
        document.getElementById('alamat').value = "";
        document.getElementById('kontak').value = "";
        document.getElementById('username').value = "";
        document.getElementById('password').value = "";
    }

    Edit = (item) => {
        document.getElementById('action').value = "update";
        document.getElementById('id_customer').value = item.id_customer;
        document.getElementById('nama').value = item.nama;
        document.getElementById('alamat').value = item.alamat;
        document.getElementById('kontak').value = item.kontak;
        document.getElementById('username').value = item.username;
        document.getElementById('password').value = item.password;
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
                <li class="nav-item"><a href="http://localhost/toko_buku/admin.php" target="blank" class="nav-link">Data Admin</a></li>
                <li class="nav-item"><a href="http://localhost/toko_buku/buku.php" target="blank" class="nav-link">Buku</a></li>
                <li class="nav-item"><a href="#" target="blank" class="nav-link">Customer</a></li>
            </ul>
        </div>
    </nav>
    <div class="container-fluid cover">
        <div class="row">
            <div class="col-lg-6 col-sm-12 text-center">
                <img src="medium_lt5c35c5db8631a.jpg" class="logo">
            </div>
            <div class="col-lg-6 col-sm-12">
                <h1 class="judul text-left">Data Customer</h1>
            </div>
        </div>
    </div>
    <br>
    <?php
    //membuat perintah sql untuk menampilkan data siswa
    if (isset($_POST["cari"])) {
        $cari = $_POST["cari"];
        $sql = "select * from customer 
        where id_customer like '%$cari%' 
        or nama like '%$cari%'
        or alamat like '%$cari%' 
        or kontak like '%$cari%' 
        or username like '%$cari%'
        or password like '%$cari%'";
    }else {
        //query jika tidak mencari
        $sql ="select * from customer";
    }
    //eksekusi perintah SQL-nya
    $query = mysqli_query($connect, $sql);
    ?>
    <div>
        <!-- start card -->
        <div class = "card">
            <div class = "card-header bg-info text-white">
            <h4> DATA CUSTOMER </h4>
            </div>
            <div class="card-body">

            <form action="customer.php" method ="post">
            <input type="text" name="cari" class="form-control" placeholder="Pencarian...">
            </form>
            <table class="table" border="1">
        <thead>
            <tr>
                <th>Id customer</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>Kontak</th>
                <th>username</th>
                <th>Password</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($query as $customer ): ?>
            <tr>
                <td><?php echo $customer ["id_customer"];?></td>
                <td><?php echo $customer ["nama"];?></td>
                <td><?php echo $customer ["alamat"];?></td>
                <td><?php echo $customer ["kontak"];?></td>
                <td><?php echo $customer["username"];?></td>
                <td><?php echo $customer["password"];?></td>
                <td>
                <button type="button" name="Edit" class="btn btn-sm btn-info"
                              data-toggle="modal" data-target="#modal_customer"
                              onclick='Edit(<?php echo json_encode($customer);?>)'>Edit</button>

                      <a href="proses_customer.php?hapus=true&id_customer=<?php echo $customer["id_customer"];?>"
                          onclick="return confirm('Apakah anda yakin ingin menghapus data ini ?')">
                          <button type="button" name="Hapus" class="btn btn-sm btn-danger"
                                  data-toggle="modal" data-target="#modal_customer"
                                  onclick="Hapus(<?php ?>);">
                            Hapus
                          </button>
                      </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <button data-toggle="modal" data-target="#modal_customer" type="button" class="btn btn-sm btn-success" onclick="Add()">Tambah Data<button>
            </div>
        </div>
        <!-- end card -->

        <!-- form modal -->
        <div class="modal fade" id = "modal_customer">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="proses_customer.php" 
                    method="post" enctype="multipart/form-data">
                        <div class="modal-header bg-info text-white">
                        <h4>form customer</h4>
                        </div>
                        <div class="modal-body">
                        <input type="hidden" name="action" id="action">
                        Id_Customer
                        <input type="number" name="id_customer" id="id_customer" class="form-control" required/>
                        Nama
                        <input type="text" name="nama" id="nama" class="form-control" required/>
                        Alamat
                        <input type="text" name="alamat" id="alamat" class="form-control" required/>
                        Kontak
                        <input type="text" name="kontak" id="kontak" class="form-control" required/>
                        Username
                        <input type="text" name="username" id="username" class="form-control" required/>
                        Password
                        <input type="text" name="password" id="password" class="form-control" required/>
                        </div>
                        <div class="modal-footer">
                        <button type="submit" name="save_customer" class="btn btn-primary">
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