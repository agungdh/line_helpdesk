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

<form>
  <input type="text" name="chat">
  <br>
  <input type="submit" value="kirim">
</form>

<div class="container">
  <img class="dp" src="<?php echo $this->lapi->ambil_picture_url('U44189559eb5eb95389b3e876cec00d39'); ?>" alt="Avatar">
  <span class="time-left">Ade</span>
  <br>
  <span class="time-left">10-01-2018 23:04:02</span>
  <br>
  Hello. How are you today?
  <br>
</div>

<div class="container">
  <img class="dp" src="<?php echo $this->lapi->ambil_picture_url('U03d5b88ff78ad8bdd6df0b122a0bde6a'); ?>" alt="Avatar">
  <span class="time-left">Ade</span>
  <br>
  <span class="time-left">10-01-2018 23:04:02</span>
  <br>
  <img src="<?php echo $this->lapi->ambil_picture_url('Ua9c75272c83b722557fb63c68a3997fc'); ?>" alt="Avatar">
  <br>
</div>
