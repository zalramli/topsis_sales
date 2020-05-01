<?php 
include "koneksi/koneksi.php";
    if(isset($_POST['simpan']))
    {
        session_start();
        $username = $_POST['username'];
        $password = $_POST['password'];

        $query = mysqli_query($koneksi,"SELECT * FROM user WHERE username='$username'");
        $cek = mysqli_num_rows($query);
        $data = mysqli_fetch_array($query);
        if($cek > 0)
        {
            if(password_verify($_POST['password'],$data['password']))
            {

                $_SESSION['kode_user'] = $data['kode_user'];
                $_SESSION['username_user'] = $data['username'];
                $_SESSION['nama_user'] = $data['nama_user'];

                header("location:admin.php?halaman=karyawan");
            }
            else
            {
            echo "<script>alert('username atau password anda salah');</script>";
            }
        }
        else{
            echo "<script>alert('username atau password anda salah');</script>";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dealerku</title>
    <link rel="stylesheet" href="assets/css/all.css">
    <link rel="stylesheet" href="assets/css/bootstrap4.min.css">
    <link rel="stylesheet" href="assets/css/custom.css">
</head>
<body>
  <div class="container mt-5">
    <div class="row">
      <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
        <div class="card card-signin my-5">
          <div class="card-body">
            <h5 class="card-title text-center">Sign In</h5>
            <form class="form-signin" method="post" action="">
              <div class="form-label-group">
                <input type="text" name="username" id="inputEmail" class="form-control" placeholder="Username" required autofocus>
                <label for="inputEmail">Username</label>
              </div>

              <div class="form-label-group">
                <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
                <label for="inputPassword">Password</label>
              </div>
              <button class="btn btn-lg btn-primary btn-block text-uppercase" type="submit" name="simpan">Sign in</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
<script src="assets/vendor/jquery/bootstrap.bundle.min.js"></script>
<script src="assets/vendor/jquery/jquery.slim.min.js"></script>

</body>
</html>