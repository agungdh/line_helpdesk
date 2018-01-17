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
    <h4><strong><font color=blue>BAYAR KASBON</font></strong></h4>
  </div><!-- /.box-header -->

  <div class="box-header with-border">
    <h4><strong>Sisa hutang : <?php echo $data['sisa_hutang'] <= 0 ? "Lunas" : $this->rupiah->convert_ke_rupiah($data['sisa_hutang']); ?></font></strong></h4>
  </div><!-- /.box-header -->

  <!-- form start -->
  <form name="form" id="form" role="form" method="post" action="<?php echo base_url('kasbon/aksi_bayar'); ?>" >
    <div class="box-body">

      <input type="hidden" name="id_kasbon" value="<?php echo $data['id']; ?>">

    <div class="form-group">
      <label for="jumlah">Jumlah</label>
          <input type="text" class="form-control" id="jumlah" placeholder="Isi Jumlah" name="jumlah">          
    </div>

    </div><!-- /.box-body -->

    <div class="box-footer">
      <input class="btn btn-success" name="proses" type="submit" value="Simpan Data" />
      <a href="<?php echo base_url('kasbon'); ?>" class="btn btn-info">Batal</a>
    </div>
  </form>
</div><!-- /.box -->

<script type="text/javascript">

$('#form').submit(function() 
{
    if ($.trim($("#jumlah").val()) === "") {
        alert('Data masih kosong !!!');
    return false;
    }
});

</script>

<div class="box box-primary">
  <div class="box-header with-border">
    <h4><strong><font color=blue>DATA DETAIL PEMBAYARAN</font></strong></h4>
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
      
  </div><!-- /.boxbody -->
</div><!-- /.box -->