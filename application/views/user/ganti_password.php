<?php
$query = $this->db->query("select * from user where id = ?", array($id));
  
  foreach ($query->result() as $row) {   
    $id  = $row->id;
    $nama  = $row->nama;
    $username  = $row->username;
  }
?>

<div class="box box-primary">
  <div class="box-header with-border">
    <h4><strong><font color=blue>GANTI PASSWORD</font></strong></h4>
  </div><!-- /.box-header -->

  <!-- form start -->
  <form role="form" method="post" name="form" id="form" action="<?php echo base_url('user/aksi_ganti_password'); ?>">
    <div class="box-body">

      <input type="hidden" name="id" value="<?php echo $id; ?>">

    <div class="form-group">
      <label for="username">Username : <?php echo $username; ?></label>
    </div>

    <div class="form-group">
      <label for="nama">Nama : <?php echo $nama; ?></label>
    </div>

    <div class="form-group">
      <label for="password">Password</label>
          <input type="password" class="form-control" id="password" placeholder="Isi Password" name="password">          
    </div>

    <div class="form-group">
      <label for="ulangi_password">Ulangi Password</label>
          <input type="password" class="form-control" id="ulangi_password" placeholder="Isi Ulangi Password" name="ulangi_password">          
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