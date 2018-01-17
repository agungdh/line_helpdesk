<?php

class Pustaka {

	function tanggal_indo($tanggal) {
		return date("d-m-Y", strtotime($tanggal));
	}

	function dec_to_int($int) {
		return round($int,0);
	}

	function penyebut($nilai) {
	  	switch ($nilai) {
	  		case 0:
	  			$hasil = "Nol";
	  			break;
	  		case 10:
	  			$hasil = "Sepuluh";
	  			break;
	  		case 20:
	  			$hasil = "Dua Puluh";
	  			break;
	  		case 30:
	  			$hasil = "Tiga Puluh";
	  			break;
	  		case 40:
	  			$hasil = "Empat Puluh";
	  			break;
	  		case 50:
	  			$hasil = "Lima Puluh";
	  			break;
	  		case 60:
	  			$hasil = "Enam Puluh";
	  			break;
	  		case 70:
	  			$hasil = "Tujuh Puluh";
	  			break;
	  		case 80:
	  			$hasil = "Delapan Puluh";
	  			break;
	  		case 90:
	  			$hasil = "Sembilan Puluh";
	  			break;
	  		case 100:
	  			$hasil = "Seratus";
	  			break;
	  		
	  		default:
	  			$hasil = "Error!!!";
	  			break;
	  	}
	  	return $hasil;
	}

	function terbilang_core($x)
	{
	  $abil = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
	  if ($x < 12)
	    return " " . $abil[$x];
	  elseif ($x < 20)
	    return $this->terbilang_core($x - 10) . " belas";
	  elseif ($x < 100)
	    return $this->terbilang_core($x / 10) . " puluh" . $this->terbilang_core($x % 10);
	  elseif ($x < 200)
	    return " seratus" . $this->terbilang_core($x - 100);
	  elseif ($x < 1000)
	    return $this->terbilang_core($x / 100) . " ratus" . $this->terbilang_core($x % 100);
	  elseif ($x < 2000)
	    return " seribu" . $this->terbilang_core($x - 1000);
	  elseif ($x < 1000000)
	    return $this->terbilang_core($x / 1000) . " ribu" . $this->terbilang_core($x % 1000);
	  elseif ($x < 1000000000)
	    return $this->terbilang_core($x / 1000000) . " juta" . $this->terbilang_core($x % 1000000);
	}

	function terbilang($x) {
		if ($x == 0){
			return "nol";
		} else{
			return $this->terbilang_core($x);
		}
	}
}

?>