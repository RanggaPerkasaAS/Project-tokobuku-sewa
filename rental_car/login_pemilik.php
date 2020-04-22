<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js" ></script>
</head>
<body>
    <div class="container">
    <center>
    <div class="card col-sm-6">
    <div class="card-header">
        <h4>Login Admin</h4>
    </div>
    <div class="card-body">
    <form action="proses_login_pemilik.php" method="post">
    Username 
    <input type="text" name="username" class="form-control" required/>
    Password
    <input type="password" name="pass" class="form-control" required/>
    <button type="submit" name="login_pemilik" class="btn btn-block btn-primary">
    Login
    </button>
    </form>
    </div>
    </div>
    </div>
    </center>
</body>
</html>