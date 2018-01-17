<?php
require('config.php');
require('fungsi.php');

session_start(); // Menciptakan session

if(cek_login($db) == true){
	header('location: home.php');
	exit();	
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
	if(isset($_POST['username']) and isset($_POST['password'])){
		$username = $_POST['username'];
		$password = $_POST['password'];
		$level = $_POST['level'];
		if(login($username, md5($password), $db) == true){
			// Berhasil login
			header('location: home.php');
			exit();
		}else{
			// Gagal login
			header('location: index.php');
			exit();	
		}
	}
}
?>

<!DOCTYPE html>

<html>
  <head>
  <?php require('meta.php'); ?>
  </head>

  <body class="hold-transition login-page">
    <div class="login-box">
      <div class="login-logo">
        <a href=""><b>Pelangi</b>Soft</a>
      </div><!-- /.login-logo -->
      <div class="login-box-body">
        <p class="login-box-msg">Isi Username dan Password</p>
        <form role="form" method="post">
          
          <div class="form-group has-feedback">
            <input name="username" type="text" class="form-control" placeholder="Username:">
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
          </div>
          
          <div class="form-group has-feedback">
            <input name="password" type="password" class="form-control" placeholder="Password:">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          
          <div class="row">
            <div class="col-xs-8">
            </div><!-- /.col -->
            <div class="col-xs-4">
              <button type="submit" class="btn btn-primary btn-block btn-flat">Log In</button>
            </div><!-- /.col -->
          </div>
                            
        </form>
      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->

    <!-- REQUIRED JS SCRIPTS -->

  <?php require('meta.php'); ?>

  </body>
</html>
