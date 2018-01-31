<div>
  [<?php echo $this->pustaka->tanggal_jam_indo($pelayanan->waktu); ?>] [<?php echo $this->lapi->ambil_display_name($pelayanan->id_line); ?>] <?php echo $pelayanan->pelayanan; ?>
</div>

<?php
$src_line = null;
foreach ($chat as $item) {
?>
  <?php
  if ($item[5] == "local") {
    $src = base_url("assets/dist/img/avatar1.png");
    $class = "container darker";
  } elseif ($item[5] == "line") {
    if ($src_line == null) {
      $src_line = $this->lapi->ambil_picture_url($item[4]);
    }
    $src = $src_line;
    $class = "container";
  }
  ?>
  <?php
  if ($item[2] == "text") {
    $isi = $item[3];
  } elseif ($item[2] == "image") {
    $isi = base_url('api/gambar/'.$item[3]);
  }
  ?>
<div>
  [<?php echo $this->pustaka->tanggal_jam_indo($item[0]); ?>] [<?php echo $item[1]; ?>] <?php echo $isi; ?>
</div>
<?php
}
?>
