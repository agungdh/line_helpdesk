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

<a class="btn btn-success" href="<?php echo base_url('pengaduan'); ?>">Kembali</a>
<?php
if ($pengaduan->status == 0) {
  $status = "Belum Diproses";
  $next_status = "Sedang Diproses";
  $next_status_number = 1;
} elseif ($pengaduan->status == 1) {
  $status = "Sedang Diproses";
  $next_status = "Selesai";
  $next_status_number = 2;
} elseif ($pengaduan->status == 2) {
  $status = "Selesai";
  $next_status = null;
  $next_status_number = null;
} else {
  $status = "Error !!!";
}
?>
<?php 
if ($pengaduan->status != 2) {
?>

<a class="btn btn-success" href="<?php echo base_url('pengaduan/lihat/'.$id_pengaduan); ?>">Refresh</a>
<br>
Status : <?php echo $status; ?>
<br>
Ubah Status => <a class="btn btn-success" href="<?php echo base_url('pengaduan/ubah_status/'.$id_pengaduan.'/'.$next_status_number); ?>"><?php echo $next_status; ?></a>
<form action="<?php echo base_url('pengaduan/chat'); ?>" method="post">
  <input type="hidden" name="id_pengaduan" value="<?php echo $id_pengaduan; ?>">
  <input type="hidden" name="id_line" value="<?php echo $pengaduan->id_line; ?>">
  <input type="text" name="chat" class="form-control" placeholder="Isi Chat">
  <input type="submit" value="kirim" class="btn btn-success">
</form>

<?php
}
?>

<?php
foreach ($chat as $item) {
?>
  <?php
  if ($item[5] == "local") {
    $src = base_url("assets/dist/img/avatar1.png");
    $class = "container darker";
  } elseif ($item[5] == "line") {
    $src = $this->lapi->ambil_picture_url($item[4]);
    $class = "container";
  }
  ?>
  <?php
  if ($item[2] == "text") {
    $isi = $item[3];
  } elseif ($item[2] == "image") {
    $konten = $this->lapi->ambil_gambar($item[3]);        
    $isi = '<img src="data:image;base64,'.base64_encode( $konten ).'"/>';
  }
  ?>
<div class="<?php echo $class; ?>">
  <img class="dp" src="<?php echo $src; ?>" alt="Avatar">
  <span class="time-left"><?php echo $item[1]; ?></span>
  <br>
  <span class="time-left"><?php echo $this->pustaka->tanggal_jam_indo($item[0]); ?></span>
  <br>
  <?php echo $isi; ?>
  <br>
</div>
<?php
}
?>
<div class="container">
  <img class="dp" src="<?php echo $this->lapi->ambil_picture_url($pengaduan->id_line); ?>" alt="Avatar">
  <span class="time-left"><?php echo $this->lapi->ambil_display_name($pengaduan->id_line); ?></span>
  <br>
  <span class="time-left"><?php echo $this->pustaka->tanggal_jam_indo($pengaduan->waktu); ?></span>
  <br>
  <?php echo $pengaduan->pengaduan; ?>
  <br>
</div>
