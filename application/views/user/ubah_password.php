<div class="box box-primary">
  <div class="box-header with-border">
    <h4><strong><font color=blue>UBAH PASSWORD</font></strong></h4>
  </div><!-- /.box-header -->

  <!-- form start -->
  <form name="form" id="form" role="form" method="post" action="<?php echo base_url('user/aksi_ubah_password'); ?>" >
    <div class="box-body">

      <input type="hidden" name="id_user" value="<?php echo $user->id; ?>">

    <div class="form-group">
      <label for="password">Password</label>
          <input type="password" class="form-control" id="password" placeholder="Isi password" name="password">          
    </div>

    <div class="form-group">
      <label for="password2">Password Lagi</label>
          <input type="password2" class="form-control" id="password2" placeholder="Isi password lagi" name="password2">          
    </div>

    </div><!-- /.box-body -->

    <div class="box-footer">
      <input class="btn btn-success" name="proses" type="submit" value="Simpan Data" />
      <a href="<?php echo base_url('user/ubah/'.$user->id); ?>" class="btn btn-info">Batal</a>
    </div>
  </form>
</div><!-- /.box -->

<script type="text/javascript">

$('#form').submit(function() 
{
    if ($.trim($("#password").val()) === "" || $.trim($("#password2").val()) === "") {
        alert('Data masih kosong !!!');
    return false;
    }

    if ($("#password").val() != $("#password2").val()) {
        alert('Password tidak sama !!!');
    return false;
    }
});

</script>