<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Unggulan extends Controller{
	function Unggulan(){
		parent::Controller();
	}
	function index(){
		redirect(base_url());
		exit();
	}

	function surat_pengantar_unggulan($id){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$query = "select KODE_SAMPEL,KOTA,CONVERT(VARCHAR(30), CREATE_DATE, 13) AS CREATE_DATE, BBPOM_NAMA_TUJUAN,BBPOM_NAMA_PENGIRIM, NAMA_SAMPEL,PABRIK,NO_BETS, NAMA_KEPALA_BALAI,NIP_KEPALA_BALAI  from T_SURAT_PENGANTAR_UNGGULAN WHERE KODE_SAMPEL='".$id."' ";
			$res = $sipt->main->get_result($query);			
			if($res){				
				foreach($query->result_array() as $row){
					$sampel[] = $row; 
					$arrdata = array('header' => $sampel);
				}
				
				/*$querydetil = "select parameter_uji, hasil, hasil_kualitatif, hasil_parameter,catatan from t_sampel_rujukan_detil where kode_sampel='".$id."' ";
				$resdetil = $sipt->main->get_result($querydetil);
				foreach($querydetil->result_array() as $rowdetil){
					$sampeldetil[] = $rowdetil; 
					$arrdata['detil'] =  $sampeldetil;
				}*/	

				//$arr_tanggal  = $this->db->query("SELECT KODE_SAMPEL, MIN(CONVERT(VARCHAR(10), AWAL_UJI, 120)) AS MINTGL, MAX(CONVERT(VARCHAR(10), AKHIR_UJI, 13)) AS MAXTGL FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL = '".$id."' GROUP BY KODE_SAMPEL")->result_array();
				//$arrdata['tgl_akhir_uji'] = $arr_tanggal;
				$this->load->library('mpdf');
				$mpdf=new mPDF('win-1252',array(210,330));
				//$mpdf=new mPDF('','', 0, '', 15, 115, 16, 16, 9, 9, 'L');
				$mpdf->mirrorMargins = true;
				$mpdf->SetAuthor("Bobi Hariadi");
				$mpdf->SetDisplayMode('fullpage','two');
				$html = $this->load->view('pengujian/unggulan/cetak/pengantar_unggulan', $arrdata, true);
				$lampiran = $this->mpdf->WriteHTML($html);
				$lampiran = $this->mpdf->Output();
				echo $lampiran;
				exit();
			}


		}
	}		
}
?>