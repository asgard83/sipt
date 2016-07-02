<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Grafik extends Controller{
	
	function Grafik(){
		parent::Controller();
	}
	
	function index(){
	}
	
	function top_chart($periode){
		$this->load->model('admin/dashboard_act');
		$ret = $this->dashboard_act->top_chart($periode);
		echo $ret;
	}
	
	function chart_komoditi(){
		$this->load->model('admin/utility_act');
		$ret = $this->utility_act->chart_komoditi();
		echo $ret;
	}
	
	function chart_jsarana(){
		$this->load->model('admin/utility_act');
		$ret = $this->utility_act->chart_jsarana();
		echo $ret;
	}
	
	function pemeriksaan(){
		if(array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('10', $this->newsession->userdata('SESS_KODE_ROLE')) || $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$this->load->model('admin/dashboard_act');
			$jenis = $this->input->post('jenis');
			if(trim($this->input->post('jenis'))!=""){
				$ret = $this->dashboard_act->detil($jenis);
			}else{
				$ret = $this->dashboard_act->all_jenis();
			}
			echo $ret;
		}
	}
	
	function get_chart($pelaporan="", $tipe=""){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main","main", true);
			if($pelaporan=="pemeriksaan"){
				if($tipe=="periksa"){
					$query = "SELECT SUM(CASE WHEN MONTH(AWAL_PERIKSA)=1 THEN 1 ELSE 0 END) AS JAN,
							  SUM(CASE WHEN MONTH(AWAL_PERIKSA)=2 THEN 1 ELSE 0 END) AS FEB,
							  SUM(CASE WHEN MONTH(AWAL_PERIKSA)=3 THEN 1 ELSE 0 END) AS MAR,
							  SUM(CASE WHEN MONTH(AWAL_PERIKSA)=4 THEN 1 ELSE 0 END) AS APR,
							  SUM(CASE WHEN MONTH(AWAL_PERIKSA)=5 THEN 1 ELSE 0 END) AS MEI,
							  SUM(CASE WHEN MONTH(AWAL_PERIKSA)=6 THEN 1 ELSE 0 END) AS JUN,
							  SUM(CASE WHEN MONTH(AWAL_PERIKSA)=7 THEN 1 ELSE 0 END) AS JUL,
							  SUM(CASE WHEN MONTH(AWAL_PERIKSA)=8 THEN 1 ELSE 0 END) AS AUG,
							  SUM(CASE WHEN MONTH(AWAL_PERIKSA)=9 THEN 1 ELSE 0 END) AS SEP,
							  SUM(CASE WHEN MONTH(AWAL_PERIKSA)=10 THEN 1 ELSE 0 END) AS OKT,
							  SUM(CASE WHEN MONTH(AWAL_PERIKSA)=11 THEN 1 ELSE 0 END) AS NOV,
							  SUM(CASE WHEN MONTH(AWAL_PERIKSA)=12 THEN 1 ELSE 0 END) AS DEC
							  FROM T_PEMERIKSAAN WHERE YEAR(AWAL_PERIKSA) = '".date("Y"). "'";
					$data = $sipt->main->get_result($query);
					if($data){
						foreach($query->result_array() as $row){
							if(!array_key_exists($row['JAN'], $row)) $responce[]=array("Bulan"=> 'Jan',"Total"=>$row['JAN']); 
							if(!array_key_exists($row['FEB'], $row)) $responce[]=array("Bulan"=> 'Feb',"Total"=>$row['FEB']); 
							if(!array_key_exists($row['MAR'], $row)) $responce[]=array("Bulan"=> 'Mar',"Total"=>$row['MAR']); 
							if(!array_key_exists($row['APR'], $row)) $responce[]=array("Bulan"=> 'Apr',"Total"=>$row['APR']); 
							if(!array_key_exists($row['MEI'], $row)) $responce[]=array("Bulan"=> 'Mei',"Total"=>$row['MEI']); 
							if(!array_key_exists($row['JUN'], $row)) $responce[]=array("Bulan"=> 'Jun',"Total"=>$row['JUN']); 
							if(!array_key_exists($row['JUL'], $row)) $responce[]=array("Bulan"=> 'Jul',"Total"=>$row['JUL']); 
							if(!array_key_exists($row['AUG'], $row)) $responce[]=array("Bulan"=> 'Aug',"Total"=>$row['AUG']); 
							if(!array_key_exists($row['SEP'], $row)) $responce[]=array("Bulan"=> 'Sep',"Total"=>$row['SEP']); 
							if(!array_key_exists($row['OKT'], $row)) $responce[]=array("Bulan"=> 'Okt',"Total"=>$row['OKT']); 
							if(!array_key_exists($row['NOV'], $row)) $responce[]=array("Bulan"=> 'Nov',"Total"=>$row['NOV']); 
							if(!array_key_exists($row['DEC'], $row)) $responce[]=array("Bulan"=> 'Des',"Total"=>$row['DEC']); 
						}
						echo json_encode($responce);
					}		  
				}else if($tipe=="jenis-sarana"){
					$query = "SELECT (SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE LEFT(JENIS_SARANA_ID, 2) = '01' AND YEAR(AWAL_PERIKSA) = '".date("Y")."') AS PRODUKSI,
					(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE LEFT(JENIS_SARANA_ID, 2) = '02' AND YEAR(AWAL_PERIKSA) = '".date("Y")."') AS DISTRIBUSI,
					(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE LEFT(JENIS_SARANA_ID, 2) = '03' AND YEAR(AWAL_PERIKSA) = '".date("Y")."') AS PELAYANAN";
					$data = $sipt->main->get_result($query);
					if($data){
						foreach($query->result_array() as $row){
							if(!array_key_exists($row['PRODUKSI'], $row)) $responce[]=array("value"=> $row['PRODUKSI'],"label"=>"Sarana Produksi","uri"=>"01"); 
							if(!array_key_exists($row['DISTRIBUSI'], $row)) $responce[]=array("value"=> $row['DISTRIBUSI'],"label"=>"Sarana Distribusi","uri"=>"02"); 
							if(!array_key_exists($row['PELAYANAN'], $row)) $responce[]=array("value"=> $row['PELAYANAN'],"label"=>"Sarana Pelayanan","uri"=>"03"); 
						}
						echo json_encode($responce);
					}
				}
			}else if($pelaporan=="pengujian"){
				if($tipe=="sampling"){
					$query = "SELECT
					SUM(CASE WHEN MONTH(TANGGAL_SAMPLING)=1 THEN 1 ELSE 0 END) AS JAN,
					SUM(CASE WHEN MONTH(TANGGAL_SAMPLING)=2 THEN 1 ELSE 0 END) AS FEB,
					SUM(CASE WHEN MONTH(TANGGAL_SAMPLING)=3 THEN 1 ELSE 0 END) AS MAR,
					SUM(CASE WHEN MONTH(TANGGAL_SAMPLING)=4 THEN 1 ELSE 0 END) AS APR,
					SUM(CASE WHEN MONTH(TANGGAL_SAMPLING)=5 THEN 1 ELSE 0 END) AS MEI,
					SUM(CASE WHEN MONTH(TANGGAL_SAMPLING)=6 THEN 1 ELSE 0 END) AS JUN,
					SUM(CASE WHEN MONTH(TANGGAL_SAMPLING)=7 THEN 1 ELSE 0 END) AS JUL,
					SUM(CASE WHEN MONTH(TANGGAL_SAMPLING)=8 THEN 1 ELSE 0 END) AS AUG,
					SUM(CASE WHEN MONTH(TANGGAL_SAMPLING)=9 THEN 1 ELSE 0 END) AS SEP,
					SUM(CASE WHEN MONTH(TANGGAL_SAMPLING)=10 THEN 1 ELSE 0 END) AS OKT,
					SUM(CASE WHEN MONTH(TANGGAL_SAMPLING)=11 THEN 1 ELSE 0 END) AS NOV,
					SUM(CASE WHEN MONTH(TANGGAL_SAMPLING)=12 THEN 1 ELSE 0 END) AS DEC
					FROM T_M_SAMPEL WHERE SUBSTRING(KODE_SAMPEL, 1,2) = '".substr(date("Y"),2,4)."'";
					$data = $sipt->main->get_result($query);
					if($data){
						foreach($query->result_array() as $row){
							if(!array_key_exists($row['JAN'], $row)) $responce[]=array("Bulan"=> 'Jan',"Total"=>$row['JAN']); 
							if(!array_key_exists($row['FEB'], $row)) $responce[]=array("Bulan"=> 'Feb',"Total"=>$row['FEB']); 
							if(!array_key_exists($row['MAR'], $row)) $responce[]=array("Bulan"=> 'Mar',"Total"=>$row['MAR']); 
							if(!array_key_exists($row['APR'], $row)) $responce[]=array("Bulan"=> 'Apr',"Total"=>$row['APR']); 
							if(!array_key_exists($row['MEI'], $row)) $responce[]=array("Bulan"=> 'Mei',"Total"=>$row['MEI']); 
							if(!array_key_exists($row['JUN'], $row)) $responce[]=array("Bulan"=> 'Jun',"Total"=>$row['JUN']); 
							if(!array_key_exists($row['JUL'], $row)) $responce[]=array("Bulan"=> 'Jul',"Total"=>$row['JUL']); 
							if(!array_key_exists($row['AUG'], $row)) $responce[]=array("Bulan"=> 'Aug',"Total"=>$row['AUG']); 
							if(!array_key_exists($row['SEP'], $row)) $responce[]=array("Bulan"=> 'Sep',"Total"=>$row['SEP']); 
							if(!array_key_exists($row['OKT'], $row)) $responce[]=array("Bulan"=> 'Okt',"Total"=>$row['OKT']); 
							if(!array_key_exists($row['NOV'], $row)) $responce[]=array("Bulan"=> 'Nov',"Total"=>$row['NOV']); 
							if(!array_key_exists($row['DEC'], $row)) $responce[]=array("Bulan"=> 'Des',"Total"=>$row['DEC']); 
						}
						echo json_encode($responce);
					}
				}else if($tipe=="komoditi"){
					$query = "SELECT B.KLASIFIKASI, COUNT(A.KOMODITI) AS JML FROM T_M_SAMPEL A LEFT JOIN M_GOLONGAN B ON A.KOMODITI = B.KLASIFIKASI_ID WHERE SUBSTRING(KODE_SAMPEL,1,2) = '".substr(date("Y"),2,4)."' GROUP BY B.KLASIFIKASI";
					$data = $sipt->main->get_result($query);
					if($data){
						foreach($query->result_array() as $row){
							$responce[]=array("value"=> $row['JML'],"label"=>$row['KLASIFIKASI']); 
						}
						echo json_encode($responce);
					}
				}
			}
		}
	}
	
}