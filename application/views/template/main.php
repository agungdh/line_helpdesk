<script type="text/javascript" language="javascript" >
  $(document).ready(function() {
        var dataTable = $('#lookup').DataTable( {
          "responsive": true,
          "processing": true,
          "serverSide": true,
          "ordering": false,
          "ajax":{
            url :"<?php echo base_url("welcome/ajax") ?>", // json datasource
            type: "post",  // method  , by default get
            /*
            error: function(){  // error handling
              $(".lookup-error").html("");
              $("#lookup").append('');
              $("#lookup").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
              $("#lookup_processing").css("display","none");
            }
            */
            
          }
        } );
      } );
</script>
<?php
if ($this->input->post('proses')) {
   if (strpos($this->input->post('url'),"http://") !== false || strpos($this->input->post('url'),"https://") !== false) {
  $sql = "insert into redirect
      set id_user = ?,
      redirect = ?";

  $this->db->query($sql, array($this->session->id,$this->input->post('url')));
  
  $last_id = $this->db->insert_id();

   } else {
    ?>
    <script type="text/javascript">
      alertModal("Error !!!","URL Harus diawali dengan http:// atau https://");
    </script>
    <?php
   }

}
?>
      <?php
      $query = $this->db->query("select *  from statistik",array());
      foreach ($query->result() as $row) {
        $jumlah_url = $row->jumlah_url;
        $jumlah_pengunjung = $row->jumlah_pengunjung;
      }
      ?>

      <?php
      $query = $this->db->query("SELECT Round(Sum(data_length + index_length) / 1024 / 1024, 1) 'db_size' 
FROM   information_schema.tables
WHERE table_schema = ?
GROUP  BY table_schema",array($this->db->database));
      foreach ($query->result() as $row) {
        $db_size = $row->db_size;
      }
      ?>

<div class="box box-primary">
  <div class="box-header with-border">
    <h4><strong><font color=blue>DAFTAR URL REDIRECT</font></strong></h4>
  </div><!-- /.box-header -->

  <!-- form start -->
  <form role="form" method="post" >
    <div class="box-body">

    <div class="form-group">
      <label for="url">URL</label>
          <input type="text" class="form-control" id="url" placeholder="Isi URL" name="url">
          <p>*Harus diawali dengan http:// atau https://</p>          
    </div>

    <div class="form-group">
    <label for="url">STATISTIK</label>
    <table id="lookups" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
      <thead>
        <tr>
                    <th>Jumlah URL Terdaftar</th>
                    <th>Jumlah URL Dikunjungi</th>
                    <th>Database Size</th>
        </tr>
      </thead>

      <tbody>
        <tr>
                    <th><?php echo $jumlah_url == null ? "0" : $jumlah_url; ?> URL</th>
                    <th><?php echo $jumlah_pengunjung == null ? "0" : $jumlah_pengunjung; ?> Kali</th>
                    <th><?php echo $db_size . " MB"; ?></th>
        </tr>
      </tbody>

      </table>
    </div> 

    </div><!-- /.box-body -->

    <div class="box-footer">
      <input class="btn btn-success" name="proses" type="submit" value="Simpan Data" />
    </div>
  </form>
</div><!-- /.box -->


<div class="box box-primary">
  <div class="box-header with-border">
    <h4><strong><font color=blue>TABEL URL REDIRECT</font></strong></h4>
  </div><!-- /.box-header -->

    <div class="box-body">


    <table id="lookup" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
      <thead>
        <tr>
                    <th>URL Tujuan</th>
                    <?php 
                    if ($this->session->level != 2) {
                      ?>
                      <th>Custom URL Redirect</th>
                      <?php
                    }
                    ?>
                    <th>URL Redirect</th>
                    <?php 
                    if ($this->session->level != 2) {
                      ?>
                      <th>Keterangan</th>
                      <?php
                    }
                    ?>
                    <th>Jumlah Kunjungan</th>
                    <?php 
                    if ($this->session->level != 2) {
                      ?>
                      <th>Aksi</th>
                      <?php
                    }
                    ?>
        </tr>
      </thead>

      <tbody>
      </tbody>

      <?php
      $query = $this->db->query("select sum(visit) total_kunjungan from redirect where id_user = ?",array($this->session->id));
      foreach ($query->result() as $row) {
        $total_kunjungan = $row->total_kunjungan;
      }
      ?>

      <tfoot>
        <tr>
                    <th></th>
                    <?php 
                    if ($this->session->level != 2) {
                      ?>
                      <th></th>
                      <th></th>
                      <?php
                    }
                    ?>
                    <th>Total Kunjungan</th>
                    <th><?php echo $total_kunjungan == null ? "0" : $total_kunjungan; ?> Kali</th>
        </tr>
      </tfoot>
      
    </table>
  </div><!-- /.boxbody -->
</div><!-- /.box -->
