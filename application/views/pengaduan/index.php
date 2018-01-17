<script type="text/javascript" language="javascript" >
  var dTable;
  $(document).ready(function() {
    dTable = $('#lookup').DataTable({
      responsive: true
    });
  });
</script>
<script type="text/javascript" language="javascript" >
  var dTable;
  $(document).ready(function() {
    dTable = $('#lookup2').DataTable({
      responsive: true
    });
  });
</script>

<div class="box box-primary">
  <div class="box-header with-border">
    <h4><strong><font color=blue>DATA PENGADUAN BELUM SELESAI</font></strong></h4>
  </div><!-- /.box-header -->

    <div class="box-body">

    <table id="lookup" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
      <thead>
        <tr>
                    <th>TANGGAL</th>
                    <th>NAMA</th>
                    <th>ADUAN</th>
                    <th>STATUS</th>
                    <th>PROSES</th>
        </tr>
      </thead>

      <tbody>
        <?php
        foreach ($data['pengaduan_belum'] as $item) {
          $nama = $this->lapi->ambil_display_name($item->id_line);
          $tanggal = $this->pustaka->tanggal_indo($item->tanggal);
          $status = "Error !!!";
          
          if ($item->status == 0) {
            $status = "Belum Diproses";
          } elseif ($item->status == 1) {
            $status = "Sedang Diproses";
          } elseif ($item->status == 2) {
            $status = "Selesai";
          } else {
            $status = "Error !!!";
          }

          ?>
          <tr>
            <td><?php echo $tanggal; ?></td>
            <td><?php echo $nama; ?></td>
            <td><?php echo $item->pengaduan; ?></td>
            <td><?php echo $status; ?></td>
            <td><a class="btn btn-primary" href="<?php echo base_url('pengaduan/lihat/'.$item->id); ?>">Lihat</a></td>
          </tr>
          <?php
        }
        ?>
      </tbody>
      
    </table>
  </div><!-- /.boxbody -->
</div><!-- /.box --><div class="box box-primary">
  <div class="box-header with-border">
    <h4><strong><font color=blue>DATA PENGADUAN SUDAH SELESAI</font></strong></h4>
  </div><!-- /.box-header -->

    <div class="box-body">

    <table id="lookup2" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
      <thead>
        <tr>
                    <th>TANGGAL</th>
                    <th>NAMA</th>
                    <th>ADUAN</th>
                    <th>STATUS</th>
                    <th>PROSES</th>
        </tr>
      </thead>

      <tbody>
        <?php
        foreach ($data['pengaduan_selesai'] as $item) {
          $nama = $this->lapi->ambil_display_name($item->id_line);
          $tanggal = $this->pustaka->tanggal_indo($item->tanggal);
          $status = "Error !!!";
          
          if ($item->status == 0) {
            $status = "Belum Diproses";
          } elseif ($item->status == 1) {
            $status = "Sedang Diproses";
          } elseif ($item->status == 2) {
            $status = "Selesai";
          } else {
            $status = "Error !!!";
          }

          ?>
          <tr>
            <td><?php echo $tanggal; ?></td>
            <td><?php echo $nama; ?></td>
            <td><?php echo $item->pengaduan; ?></td>
            <td><?php echo $status; ?></td>
            <td><a class="btn btn-primary" href="<?php echo base_url('pengaduan/lihat/'.$item->id); ?>">Lihat</a></td>
          </tr>
          <?php
        }
        ?>      </tbody>
      
    </table>
  </div><!-- /.boxbody -->
</div><!-- /.box -->