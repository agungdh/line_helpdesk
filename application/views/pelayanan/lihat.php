<style type="text/css">
   /* Chat containers */
.container {
    border: 2px solid #dedede;
    background-color: #f1f1f1;
    border-radius: 5px;
    padding: 10px;
    margin: 10px 0;
}

/* Darker chat container */
.darker {
    border-color: #ccc;
    background-color: #ddd;
}

/* Clear floats */
.container::after {
    content: "";
    clear: both;
    display: table;
}

/* Style images */
.container img.dp {
    float: left;
    max-width: 60px;
    width: 100%;
    margin-right: 20px;
    border-radius: 50%;
}

/* Style the right image */
.container img.right {
    float: right;
    margin-left: 20px;
    margin-right:0;
}

/* Style time text */
.time-right {
    float: right;
    color: #aaa;
}

/* Style time text */
.time-left {
    float: left;
    color: #999;
} 
</style>

<script type="text/javascript">
function ganti_last_id(local, line) {
  $("#last_id_local").val(local);
  $("#last_id_line").val(line);
}

$(document).ready(function(){
  $("#refresh").click(function(){
        if ($("#bisa_refresh").val() == '0') {
          return;
        }
        $("#bisa_refresh").val('0'),
        $.post('<?php echo base_url('pelayanan/ajax_cek_pesan_baru'); ?>',
        {
          id_pelayanan: '<?php echo $id_pelayanan; ?>',
          last_id_local: $("#last_id_local").val(),
          last_id_line: $("#last_id_line").val(),
        },
        function(data,status){
          $('#div_ajax').prepend(data),
          $("#bisa_refresh").val('1'),
          alert(
            'local = ' + $('#last_id_local').val() + "\n"
            + 'line = ' + $('#last_id_line').val()
            );
        }); 
    });

  $("#kirim").click(function(){
        $.post('<?php echo base_url('pelayanan/ajax_kirim_pesan'); ?>',
        {
          chat: $("#chat").val(),
          id_pelayanan: $("#id_pelayanan").val(),
          id_line: $("#id_line").val(),
        },
        function(data,status){
            $("#chat").val('');
        }); 
    });

  $("#chat").keyup(function(event) {
    if (event.keyCode === 13) {
        $("#kirim").click();
    }
  });

});
</script>

<a class="btn btn-success" href="<?php echo base_url('pelayanan'); ?>">Kembali</a>
<?php
if ($pelayanan->status == 0) {
  $status = "Belum Diproses";
  $next_status = "Sedang Diproses";
  $next_status_number = 1;
} elseif ($pelayanan->status == 1) {
  $status = "Sedang Diproses";
  $next_status = "Selesai";
  $next_status_number = 2;
} elseif ($pelayanan->status == 2) {
  $status = "Selesai";
  $next_status = null;
  $next_status_number = null;
} else {
  $status = "Error !!!";
}
?>
<button class="btn btn-success" id="refresh" name="refresh">Refresh</button>
<?php 
if ($pelayanan->status != 2) {
?>

<!-- <a class="btn btn-success" href="<?php echo base_url('pelayanan/lihat/'.$id_pelayanan); ?>">Refresh</a> -->
<br>
Status : <?php echo $status; ?>
<br>
Ubah Status => <a class="btn btn-success" href="<?php echo base_url('pelayanan/ubah_status/'.$id_pelayanan.'/'.$next_status_number); ?>"><?php echo $next_status; ?></a>
<!-- <form action="<?php echo base_url('pelayanan/chat'); ?>" method="post"> -->
  <input type="hidden" name="id_pelayanan" id="id_pelayanan" value="<?php echo $id_pelayanan; ?>">
  <input type="hidden" name="id_line" id="id_line" value="<?php echo $pelayanan->id_line; ?>">
  <input type="text" name="chat" id="chat" class="form-control" placeholder="Isi Chat">
  <button class="btn btn-success" id="kirim">Kirim</button>
  <!-- <input type="submit" value="kirim" class="btn btn-success"> -->
<!-- </form> -->

<?php
}
?>

<div id="div_ajax">
  
</div>

<div class="container">
  <img class="dp" src="<?php echo $this->lapi->ambil_picture_url($pelayanan->id_line); ?>" alt="Avatar">
  <span class="time-left"><?php echo $this->lapi->ambil_display_name($pelayanan->id_line); ?></span>
  <br>
  <span class="time-left"><?php echo $this->pustaka->tanggal_jam_indo($pelayanan->waktu); ?></span>
  <br>
  <?php echo $pelayanan->pelayanan; ?>
  <br>
</div>
<input type="hidden" name="last_id_local" id="last_id_local" value="0">
<input type="hidden" name="last_id_line" id="last_id_line" value="0">
<input type="hidden" name="bisa_refresh" id="bisa_refresh" value="1">
<!-- <input type="hidden" name="last_id" id="last_id" value="<?php echo $last_id; ?>"> -->