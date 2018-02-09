<div class="box box-primary">
  <div class="box-header with-border">
    <h4><strong><font color=blue>TAMBAH USER</font></strong></h4>
  </div><!-- /.box-header -->

  <!-- form start -->
  <form name="form" id="form" role="form" method="post" action="<?php echo base_url('user/aksi_tambah'); ?>" >
    <div class="box-body">

    <div class="form-group">
      <label for="username">Username</label>
          <input type="text" class="form-control" id="username" placeholder="Isi username" name="username">          
    </div>

    <div class="form-group">
      <label for="nama">Nama</label>
          <input type="text" class="form-control" id="nama" placeholder="Isi nama" name="nama">          
    </div>

    <div class="form-group">
      <label for="password">Password</label>
          <input type="password" class="form-control" id="password" placeholder="Isi password" name="password">          
    </div>

    <div class="form-group">
      <label for="role">Role</label>
      <div class="checkbox">
        <label>
          <input type="radio" name="radio" id="radio" value='2'>
          Administrator
        </label>
      </div>
      <div class="checkbox">
        <label>
          <input type="radio" name="radio" id="radio" checked value='1'>
          Operator
        </label>
      </div>
    </div>

    <div class="form-group">
      <label for="layanan">Layanan</label>
      <?php
      foreach ($layanan as $item) {
        ?>
      <div class="checkbox">
        <label>
          <input type="checkbox" id="layanan" name="<?php echo $item->id; ?>" value='1'>
          <?php echo $item->layanan; ?>
        </label>
      </div>
        <?php        
      }
      ?>
    </div>

    </div><!-- /.box-body -->

    <div class="box-footer">
      <input class="btn btn-success" name="proses" type="submit" value="Simpan Data" />
      <a href="<?php echo base_url('user'); ?>" class="btn btn-info">Batal</a>
    </div>
  </form>
</div><!-- /.box -->

<script type="text/javascript">

$(document).ready(function(){
  $("input[name='radio']").click(function() {
    // console.log($("input[name='radio']:checked").val());
    if ($("input[name='radio']:checked").val() == 2) {
      $("input[id='layanan']").prop('disabled', true);
      $("input[id='layanan']").prop('checked', false);
    } else {
      $("input[id='layanan']").prop('disabled', false);
    }
  });
});

$('#form').submit(function() 
{
    if ($.trim($("#username").val()) === "" || $.trim($("#password").val()) === "" || $.trim($("#nama").val()) === "") {
        alert('Data masih kosong !!!');
    return false;
    }
});

</script>