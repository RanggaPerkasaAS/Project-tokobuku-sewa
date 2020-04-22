<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Rent Car</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js" ></script>
    <style media="screen">
    body{
        background-image: linear-gradient(rgba(0,0,0,0.5),rgba(0,0,0,0.5)), url("milosz-klinowski-iAnhwi6QXUs-unsplash.jpg")  ;
        background-position : center;
        background-repeat : no-repeat;
        background-size : cover;
        background-attachment : fixed;
    }
 
h1{
	text-align: center;
	/*ketebalan font*/
	font-weight: 300;
}
 
.tulisan_login{
	text-align: center;
	/*membuat semua huruf menjadi kapital*/
	text-transform: uppercase;
}
 
.kotak_login{
	width: 350px;
	background-color:rgba(255,255,255,0.8);
	/*meletakkan form ke tengah*/
	margin: 80px auto;
	padding: 30px 20px;
}
 
label{
	font-size: 11pt;
}
 
.form_login{
	/*membuat lebar form penuh*/
	box-sizing : border-box;
	width: 100%;
	padding: 10px;
	font-size: 11pt;
	margin-bottom: 20px;
}
 
.tombol_login{
	background: #242121;
	color: white;
	font-size: 11pt;
	width: 100%;
	border: none;
	border-radius: 3px;
	padding: 10px 20px;
}
 
.link{
	color: #232323;
	text-decoration: none;
	font-size: 10pt;
}
    </style>
</head>
<body>
<div class="kotak_login">
	<p class="tulisan_login">Silahkan login</p>

	<form action="proses_login_penyewa.php" method="post">
		<label>Username</label>
		<input type="text" name="username" class="form_login" placeholder="Username atau email ..">

		<label>Password</label>
		<input type="password" name="pass" class="form_login" placeholder="Password ..">

		<input type="submit" class="tombol_login" value="LOGIN" name="login_penyewa">

		<br/>
		<br/>
        
		<center>
        <h6 class="link">Tidak punya akun ?</h6><a class="link" href="http://localhost/rental_car/daftar.php">Daftar</a>
		</center>
	</form>
	
</div>
</body>
</html>