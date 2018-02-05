<script type="text/javascript" language="javascript" >
  var dTable;
  $(document).ready(function() {
    dTable = $('#lookup').DataTable({
      responsive: true
    });
  });
</script>
<div class="box box-primary">
  <div class="box-header with-border">
    <h4><strong><font color=blue>DATA USER</font></strong></h4>
  </div><!-- /.box-header -->

    <div class="box-body">

    <div class="form-group">
      <a href='<?php echo base_url("user/tambah"); ?>'><button class="btn btn-success">+ Tambah User</button></a>
    </div>

    <table id="lookup" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
      <thead>
        <tr>
                    <th>USERNAME</th>
                    <th>NAMA</th>
                    <th>LEVEL</th>
                    <th>PROSES</th>
        </tr>
      </thead>

      <tbody>
        <?php
        foreach ($user as $item) {
          if ($item->level == 2) {
            $level = "Administrator";
          } elseif ($item->level == 1) {
            $level = "Operator";
          } else {
            $level = "ERROR !!!";
          }
          ?>
          <tr>
            <td><?php echo $item->username; ?></td>
            <td><?php echo $item->nama; ?></td>
            <td><?php echo $level; ?></td>
            <td>
              <a class="btn btn-primary" href="<?php echo base_url('pelayanan/ubah/'.$item->id); ?>">Ubah</a>
              <a class="btn btn-danger" onclick="hapus()">Hapus</a>
            </td>
          </tr>
          <?php
        }
        ?>
      </tbody>
      
    </table>
  </div><!-- /.boxbody -->
</div><!-- /.box -->