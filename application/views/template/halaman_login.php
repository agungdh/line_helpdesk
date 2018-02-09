<?php
if ($this->input->get('valid') == '0') {
  ?>
    <script type="text/javascript">
      alert("Password salah");
    </script>
  <?php
}
?>

<!DOCTYPE html>

<html>
  <head>
    <?php $this->load->view('template/meta'); ?>
  </head>

  <body class="hold-transition login-page">
    <div class="login-box">
      <div class="login-logo">
        <a><b>Login</b></a>
        <br>
        <a href="<?php echo base_url(); ?>">Aplikasi Kasbon Online <br> berbasis Web</a>
      </div><!-- /.login-logo -->
      <div class="login-box-body">
        <p class="login-box-msg">Isi Username dan Password</p>
        <form role="form" method="post" name="loginForm" id="loginForm" action="<?php echo base_url('login'); ?>">
          
          <div class="form-group has-feedback">
            <input name="username" required id="username" type="text" class="form-control" placeholder="Username:">
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
          </div>
          
          <div class="form-group has-feedback">
            <input name="password" required id="password" type="password" class="form-control" placeholder="Password:">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          
          <div class="row">
            <div class="col-xs-8">
            </div><!-- /.col -->
            <div class="col-xs-4">
              <button type="submit" class="btn btn-primary btn-block btn-flat">Log In</button>
              <!-- <button type="submit" class="btn btn-primary btn-block btn-flat">Log In</button> -->
              <!-- <button type="submit" class="btn btn-primary btn-block btn-flat">Log In</button> -->
            </div><!-- /.col -->
          </div>
                            
        </form>
      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->

  </body>
</html>