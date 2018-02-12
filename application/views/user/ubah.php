<?php 
// print_r(array_keys(get_defined_vars()));
// var_dump($layanan);
// exit();
?>
<div class="box box-primary">
  <div class="box-header with-border">
    <h4><strong><font color=blue>UBAH USER</font></strong></h4>
  </div><!-- /.box-header -->

  <!-- form start -->
  <form name="form" id="form" role="form" method="post" action="<?php echo base_url('user/aksi_ubah'); ?>" >
    <div class="box-body">

      <input type="hidden" name="id_user" value="<?php echo $user->id; ?>">

    <div class="form-group">
      <label for="username">Username</label>
          <input type="text" class="form-control" id="username" placeholder="Isi username" name="username" value="<?php echo $user->username; ?>">          
    </div>

    <div class="form-group">
      <label for="nama">Nama</label>
          <input type="text" class="form-control" id="nama" placeholder="Isi nama" name="nama" value="<?php echo $user->nama; ?>">          
    </div>

    <div class="form-group">
      <a href="<?php echo base_url("user/ubah_password/".$user->id); ?>">Ubah Password</a>
    </div>

    <div class="form-group">
      <label for="role">Role</label>
      <div class="checkbox">
        <label>
          <input type="radio" name="radio" id="radio" value='2' <?php echo $user->level == 2 ? "checked" : null; ?>>
          Administrator
        </label>
      </div>
      <div class="checkbox">
        <label>
          <input type="radio" name="radio" id="radio" value='1' <?php echo $user->level == 1 ? "checked" : null; ?>>
          Operator
        </label>
      </div>
    </div>

    <div class="form-group">
      <label for="layanan">Layanan</label>
      <?php
      $udah = null; 
      foreach ($layanan as $item) {
      $udah = false;
        ?>
      <div class="checkbox">
        <label>
          <?php
           foreach ($pelayan as $item2) {
             if ($item->id == $item2->id_layanan) {
              $udah = true;
              ?>
              <input type="checkbox" checked id="layanan" name="<?php echo $item->id; ?>" value='1'>
              <?php
             }
           }
          ?>
          <?php
          if ($udah == false) {
            ?>
            <input type="checkbox" id="layanan" name="<?php echo $item->id; ?>" value='1'>
            <?php
          }
          ?>
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
function disable_checkbox() {
  if ($("input[name='radio']:checked").val() == 2) {
      $("input[id='layanan']").prop('disabled', true);
      $("input[id='layanan']").prop('checked', false);
    } else {
      $("input[id='layanan']").prop('disabled', false);
    }
}
$(document).ready(function(){
  disable_checkbox();
  $("input[name='radio']").click(function() {
    // console.log($("input[name='radio']:checked").val());
    disable_checkbox();
  });
});

$('#form').submit(function() 
{
    if ($.trim($("#username").val()) === "" || $.trim($("#nama").val()) === "") {
        alert('Data masih kosong !!!');
    return false;
    }
});

</script>