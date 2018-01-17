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
    <h4><strong><font color=blue>HAPUS USER</font></strong></h4>
  </div><!-- /.box-header -->

  <!-- form start -->
  <form role="form" method="post" action="<?php echo base_url('user/aksi_hapus'); ?>">
    <div class="box-body">

      <input type="hidden" name="id" value="<?php echo $id; ?>">

    <div class="form-group">
      <label for="nama">Nama</label>
          <input readonly type="text" class="form-control" id="nama" placeholder="Isi nama" name="nama" value="<?php echo $nama; ?>">          
    </div>

    <div class="form-group">
      <label for="username">Username</label>
          <input readonly type="text" class="form-control" id="username" placeholder="Isi username" name="username" value="<?php echo $username; ?>">          
    </div>

    </div><!-- /.box-body -->

    <div class="box-footer">
      <input class="btn btn-danger" name="proses" type="submit" value="Hapus Data" />
      <a href="<?php echo base_url('user'); ?>" class="btn btn-info">Batal</a>
    </div>
  </form>
</div><!-- /.box -->
