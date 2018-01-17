  <div class="box box-primary">
    <div class="box-header with-border">
      <h4><strong><font color=blue>UBAH DATA PROFIL</font></strong></h4>
    </div><!-- /.box-header -->
    <!-- form start -->
      <div class="box-body">

    <form role="form" method="post" action="<?php echo base_url('profil/aksi_ubah_profil') ?>" name="form" id="form">
                  <!-- text input -->
                  <input type="hidden" name="id" value="<?php echo $this->session->id; ?>">

                      <div class="form-group">
                        <label for="nama">Nama</label>
                            <input type="text" class="form-control" id="nama" placeholder="Isi nama" name="nama" value="<?php echo $data['nama']; ?>">          
                      </div>

                  <div class="form-group">
                    <label><a href="<?php echo base_url('profil/ganti_password'); ?>">Ganti Password</a></label>
                  </div>                  

        <input class="btn btn-primary" type="submit" name="proses" value="Ubah">
        <a href="<?php echo base_url(); ?>" class="btn btn-primary" name="kembali" >Kembali</a>
    </form>
    </div><!-- /.boxbody -->
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