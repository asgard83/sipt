<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR);
class Chasil extends Controller{
	
	function Chasil(){
		parent::Controller();
	}
	
	function index(){
		if($this->newsession->userdata('LOGGED_IN') && array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('10', $this->newsession->userdata('SESS_KODE_ROLE'))){
			$sipt =& get_instance();
			$this->load->model("main","main", true);
			$query = "SELECT A.PERIKSA_ID, A.HASIL, B.KESIMPULAN_GRUP FROM T_PEMERIKSAAN A LEFT JOIN T_PEMERIKSAAN_PANGAN B ON A.PERIKSA_ID = B.PERIKSA_ID WHERE A.JENIS_SARANA_ID = '01VV' AND A.HASIL = ''";
			$data = $sipt->main->get_result($query);
			if($data){
				$jmlgagal = 0;
				$jmlupdate = 0;
				$jum_maksb = 0;
				$jum_maksc = 0;
				foreach($query->result_array() as $row){
					$periksa = $row['PERIKSA_ID'];
					$grup = explode("#",$row['KESIMPULAN_GRUP']);
					$jml = count($group);
					for($i = 0; $i < $jml; ++$i){
						if(in_array("K", $grup)){
							$jum_maksb++;
						}
					}
					if($grup[3] == "B" && $grup[5] == "B" && $grup[6] == "B" && $grup[7] == "B" && $jum_maksb <= 2){
						$chk = "BAIK";
					}else if(($grup[3] == "B" || $grup[3] == "C") && ($grup[5] == "B" || $grup[5] == "C") && ($grup[6] == "B" || $grup[6] == "C") && ($grup[7] == "B" || $grup[3] == "C") && $jum_maksb <=5 ){
						$chk = "CUKUP";
					}else if(($grup[3] == "B" || $grup[3] == "C") && ($grup[5] == "B" || $grup[5] == "C") && ($grup[6] == "B" || $grup[6] == "C") && ($grup[7] == "B" || $grup[3] == "C") && $jum_maksb >= 6 ){
						$chk = "KURANG";
					}else if($grup[3] == "K" || $grup[5] == "K" || $grup[6] == "K" || $grup[7] == "K"){
						$chk = "KURANG";
					}else{
						$ini_grup = array("B", "C", "K");
						$ganti_grup = array(3, 2, 1);
						$angka = str_replace($ini_grup, $ganti_grup, $grup);
						$jmlangka = count($angka);
						$hasil = ($angka[0] + $angka[1] + $angka[2] + $angka[3] + $angka[4] + $angka[5] + $angka[6] + $angka[7] + $angka[8] + $angka[9] + $angka[9] + $angka[10] + $angka[11] + $angka[12]) / $jmlangka;
						if($hasil <= 1.4){
							$chk = "KURANG";
						}else if($hasil >= 1.5 && $hasil <= 2.4 ){
							$chk = "CUKUP";
						}else if($hasil >= 2.5){
							$chk = "BAIK";
						}
					}
					$qupdate = $this->db->simple_query("UPDATE T_PEMERIKSAAN SET HASIL = '".$chk."' WHERE PERIKSA_ID = '".$row['PERIKSA_ID']."'");
					if($qupdate){
						$jmlupdate++;
					}else{
						$jmlgagal++;
					}
				}
				echo "Record terupdate : " . $jmlupdate . ", record gagal : " . $jmlgagal;
			}
		}else{
			$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
		}
	}
	
	function md(){
		if($this->newsession->userdata('LOGGED_IN') && array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('10', $this->newsession->userdata('SESS_KODE_ROLE'))){
			$sipt =& get_instance();
			$this->load->model("main","main", true);
			$query = "SELECT A.PERIKSA_ID, A.HASIL, B.JUMLAH_KRITIS, B.JUMLAH_SERIUS, B.JUMLAH_MAJOR, B.JUMLAH_MINOR, B.STATUS_SARANA
FROM T_PEMERIKSAAN A LEFT JOIN T_PEMERIKSAAN_PANGAN B ON A.PERIKSA_ID = B.PERIKSA_ID WHERE A.JENIS_SARANA_ID = '01JJ' AND A.HASIL = ''";
			$data = $sipt->main->get_result($query);
			if($data){
				$jmlgagal = 0;
				$jmlupdate = 0;
				$hasil = "";
				/*
				0 => Tutup, 
				1 => Aktif, 
				2 => Tidak Produksi Saat Diperiksa,
				3 => Menolak Diperiksa
				*/
				foreach($query->result_array() as $row){
					if($row['STATUS_SARANA'] == "0"){
						$hasil = "TTP";
					}else if($row['STATUS_SARANA'] == "1"){
						if($row['JUMLAH_KRITIS'] >= 1){
							$hasil = "D";
						}else if($row['JUMLAH_SERIUS'] >= 5){
							$hasil = "D";
						}else if($row['JUMLAH_SERIUS'] >= 3 || $row['JUMLAH_SERIUS'] == 4){
							$hasil = "C";
						}else if($row['JUMLAH_KRITIS']  == 0 && $row['JUMLAH_SERIUS'] == 0 && $row['JUMLAH_MAJOR'] >= 11){
							$hasil = "B";
						}else{
							if($row['JUMLAH_SERIUS'] >=1 && $row['JUMLAH_SERIUS'] <= 2){
								$hasil = "B";
							}else if($row['JUMLAH_MINOR'] >= 7){
								$hasil = "B";
							}else if($row['JUMLAH_MAJOR'] <= 5){
								$hasil = "A";
							}else if($row['JUMLAH_MAJOR'] >= 6 && $row['JUMLAH_MAJOR'] == 10){
								$hasil = "B";
							}else if($row['JUMLAH_MINOR'] <= 6){
								$hasil = "A";
							}
						}
					}else if($row['STATUS_SARANA'] == "2" || $row['STATUS_SARANA'] == "3" ){
						$hasil = "TDP";
					}else{
						$hasil = "TTP";
					}
					$qupdate = $this->db->simple_query("UPDATE T_PEMERIKSAAN SET HASIL = '".$hasil."' WHERE PERIKSA_ID = '".$row['PERIKSA_ID']."'");
					if($qupdate){
						$jmlupdate++;
					}else{
						$jmlgagal++;
					}
					
				}
				echo "Record terupdate : " . $jmlupdate . ", record gagal : " . $jmlgagal;
			}
		}else{
			$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
		}
	}
}
?>
