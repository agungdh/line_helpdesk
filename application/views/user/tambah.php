<div class="box box-primary">
  <div class="box-header with-border">
    <h4><strong><font color=blue>TAMBAH USER</font></strong></h4>
  </div><!-- /.box-header -->

  <!-- form start -->
  <form name="form" id="form" role="form" method="post" action="<?php echo base_url('user/aksi_tambah'); ?>" >
    <div class="box-body">

    <div class="form-group">
      <label for="nama">Nama</label>
          <input type="text" class="form-control" id="nama" placeholder="Isi nama" name="nama">          
    </div>

    <div class="form-group">
      <label for="username">Username</label>
          <input type="text" class="form-control" id="username" placeholder="Isi username" name="username">          
    </div>

    <div class="form-group">
      <label for="password">Password</label>
          <input type="password" class="form-control" id="password" placeholder="Isi password" name="password">          
    </div>

    </div><!-- /.box-body -->

    <div class="box-footer">
      <input class="btn btn-success" name="proses" type="submit" value="Simpan Data" />
      <a href="<?php echo base_url('user'); ?>" class="btn btn-info">Batal</a>
    </div>
  </form>
</div><!-- /.box -->

<script type="text/javascript">

$('#form').submit(function() 
{
    if ($.trim($("#username").val()) === "" || $.trim($("#password").val()) === "" || $.trim($("#nama").val()) === "") {
        alert('Data masih kosong !!!');
    return false;
    }
});

</script>