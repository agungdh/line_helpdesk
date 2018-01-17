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
    <h4><strong><font color=blue>UBAH USER</font></strong></h4>
  </div><!-- /.box-header -->

  <!-- form start -->
  <form role="form" method="post" name="form" id="form" action="<?php echo base_url('user/aksi_ubah'); ?>">
    <div class="box-body">

    <div class="form-group">
      <label for="username">Username : <?php echo $username; ?></label>
    </div>

      <input type="hidden" name="id" value="<?php echo $id; ?>">

    <div class="form-group">
      <label for="nama">Nama</label>
          <input type="text" class="form-control" id="nama" placeholder="Isi nama" name="nama" value="<?php echo $nama; ?>">          
    </div>

    <div class="form-group">
      <label for="chpass"><a href="<?php echo base_url('user/ganti_password/'.$id); ?>">Ganti Password</a></label>
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
    if ($.trim($("#nama").val()) === "") {
        alert('Data masih kosong !!!');
    return false;
    }
});

</script>