
  <div class="box box-primary">
    <div class="box-header with-border">
      <h4><strong><font color=blue>GANTI PASSWORD</font></strong></h4>
    </div><!-- /.box-header -->
    <!-- form start -->
      <div class="box-body">

    <form name="form" id="form" role="form" method="post" action="<?php echo base_url('profil/aksi_ganti_password'); ?>">
                  <!-- text input -->
                  <input type="hidden" name="id" value="<?php echo $this->session->id; ?>">

                  <div class="form-group">
                    <label>Password baru</label>
                    <input name="password" id="password" type="password" class="form-control" placeholder="Masukkan Password Baru">
                  </div>

                  <div class="form-group">
                    <label>Ulangi Password baru</label>
                    <input name="ulangi_password" id="ulangi_password" type="password" class="form-control" placeholder="Masukkan Password Baru">
                  </div>

        <input class="btn btn-primary" type="submit" name="proses" value="Submit">
        <a href="<?php echo base_url('profil'); ?>" class="btn btn-primary">Kembali</a>
    </form>
    </div><!-- /.boxbody -->
  </div><!-- /.box -->

  <script type="text/javascript">

$('#form').submit(function() 
{
    if ($.trim($("#password").val()) === "" || $.trim($("#ulangi_password").val()) === "" ) {
        alert('Data masih kosong !!!');
    return false;
    }

    if ($.trim($("#password").val()) != $.trim($("#ulangi_password").val()) ) {
        alert('Password tidak sama !!!');
    return false;
    }

});

</script>