<script type="text/javascript" language="javascript" >
  $(document).ready(function() {
        var dataTable = $('#lookup').DataTable( {
          "responsive": true,
          "processing": true,
          "serverSide": true,
          "searching": false,
          "ajax":{
            url :"<?php echo base_url("kasbon/ajaxlihat?id=".$data['id']) ?>", // json datasource
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

<div class="box box-primary">
  <div class="box-header with-border">
    <h4><strong><font color=blue>DATA DETAIL PEMBAYARAN</font></strong></h4>
  </div><!-- /.box-header -->

  <div class="box-header with-border">
    <h4><strong>Sisa hutang : <?php echo $data['sisa_hutang'] <= 0 ? "Lunas" : $this->rupiah->convert_ke_rupiah($data['sisa_hutang']); ?></font></strong></h4>
  </div><!-- /.box-header -->

    <div class="box-body">

    <table id="lookup" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
      <thead>
        <tr>
                    <th>TANGGAL</th>
                    <th>JUMLAH</th>
        </tr>
      </thead>

      <tbody>
      </tbody>
      
    </table>
    
    <div class="box-footer">
      <a href="<?php echo base_url('kasbon'); ?>" class="btn btn-info">Kembali</a>
    </div>
  
  </div><!-- /.boxbody -->
</div><!-- /.box -->