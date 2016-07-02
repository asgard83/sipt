<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Functions extends Model{
	
	function get_hari($tgl){
		$hari = date('l', strtotime($tgl));
		switch($hari){
			case "Sunday": 
          		return "Minggu";
          		break;
			case "Monday":
				return "Senin";
				break;
			case "Tuesday":
				return "Selasa";
				break;
			case "Wednesday":
				return "Rabu";
				break;
			case "Thursday":
				return "Kamis";
				break;
			case "Friday":
				return "Jum'at";
				break;
			case "Saturday":
				return "Sabtu";
				break;
		}
		return $hari;
	}
		
	function weekend(){
		$skrg = time();
		$tglskrg = date('w', $skrg);
		$akhir = $tglskrg - 1;
		if($akhir < 0){
			$akhir = 6;
		}
		$senin = $skrg - ($akhir * 86400);
		$minggu = $senin + (6 * 86400);
		$hasil = array("awal" => date("m/d/Y", $senin), "akhir" => date("m/d/Y",$minggu));
		return $hasil;
	}
	function yearz(){
		$years = "";
		$year = date('Y');
		$start = mktime(0, 0, 0, 1, 1, $year);
		$end = mktime(0, 0, 0, 12, 31, $year);
		$early = date("d-m-Y", $start);
		$last = date("d-m-Y", $end);
		$years = $early."|".$last;
		return $years;
	}
}
?>