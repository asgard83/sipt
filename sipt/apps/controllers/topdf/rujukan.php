<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Rujukan extends Controller{
	function Rujukan(){
		parent::Controller();
	}
	function index(){
		redirect(base_url());
		exit();
	}

	function surat_pengantar_rujukan($id){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$query = "select CONVERT(VARCHAR(30), a.create_date, 13) AS create_date, a.nomor_surat, b.satuan,c.nama_bbpom AS bbpom_asal, c.kota, d.nama_bbpom AS bbpom_rujuk, dbo.FORMAT_NOMOR('SPL',a.kode_sampel) AS kode_sampel, b.nama_sampel, b.nomor_registrasi, b.pabrik, b.importir,b.kemasan,b.no_bets, b.keterangan_ed, b.tempat_sampling, b.tanggal_sampling, b.komposisi, a.jumlah_sampel from t_sampel_rujukan a
						 left join t_m_sampel b on b.kode_sampel=a.kode_sampel
						 left join m_bbpom c on c.bbpom_id=a.bbpom_asal
						 left join m_bbpom d on d.bbpom_id=a.bbpom_rujuk
						where a.kode_sampel='".$id."' ";
			
			$query = "SELECT *, CONVERT(VARCHAR(30), TANGGAL_SURAT, 103) AS TGL_SURAT, CONVERT(VARCHAR(30), TANGGAL_SELESAI_UJI, 103) AS TGL_SELESAI, CONVERT(VARCHAR(30), TANGGAL_SAMPLING, 103) AS TGL_SAMPLING,  dbo.FORMAT_NOMOR('SPL',KODE_SAMPEL) AS KODE_SAMPEL FROM T_SURAT_PENGANTAR_RUJUKAN WHERE KODE_SAMPEL='".$id."'";
			$res = $sipt->main->get_result($query);			
			$bulan = $this->config->config;
			$bulan = $bulan['bulan'];

			if($res){				

				foreach($query->result_array() as $row){
					$tgl = explode('/', $row['TGL_SURAT']);
					$tgla = (int)$tgl[1];
					$tgla = $bulan[$tgla];					
					$row['TGL_SRT'] = $tgl[0]." ".$tgla." ".$tgl[2];

					$tgl1 = explode('/', $row['TGL_SELESAI']);
					$tgla1 = (int)$tgl1[1];
					$tgla1 = $bulan[$tgla1];					
					$row['TGL_UJI'] = $tgl1[0]." ".$tgla1." ".$tgl1[2];

					$tgl2 = explode('/', $row['TGL_SAMPLING']);
					$tgla2 = (int)$tgl2[1];
					$tgla2 = $bulan[$tgla2];					
					$row['TGL_SAMPLING'] = $tgl2[0]." ".$tgla2." ".$tgl2[2];

					$sampel[] = $row; 
					$arrdata = array('header' => $sampel);
				}
				
				$querydetil = "select parameter_uji, hasil, hasil_kualitatif, hasil_parameter,catatan from t_sampel_rujukan_detil where kode_sampel='".$id."' ";
				$resdetil = $sipt->main->get_result($querydetil);
				foreach($querydetil->result_array() as $rowdetil){
					$sampeldetil[] = $rowdetil; 
					$arrdata['detil'] =  $sampeldetil;
				}	

				//$arr_tanggal  = $this->db->query("SELECT KODE_SAMPEL, MIN(CONVERT(VARCHAR(10), AWAL_UJI, 120)) AS MINTGL, MAX(CONVERT(VARCHAR(10), AKHIR_UJI, 13)) AS MAXTGL FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL = '".$id."' GROUP BY KODE_SAMPEL")->result_array();
				//$arrdata['tgl_akhir_uji'] = $arr_tanggal;
				$this->load->library('mpdf');
				$mpdf=new mPDF('win-1252',array(210,330));
				//$mpdf=new mPDF('','', 0, '', 15, 115, 16, 16, 9, 9, 'L');
				$mpdf->mirrorMargins = true;
				$mpdf->SetAuthor("Bobi Hariadi");
				$mpdf->SetDisplayMode('fullpage','two');
				$html = $this->load->view('pengujian/rujukan/cetak/pengantar_rujukan', $arrdata, true);
				$lampiran = $this->mpdf->WriteHTML($html);
				$lampiran = $this->mpdf->Output();
				echo $lampiran;
				exit();
			}
		}
	}

	function surat_tanggapan_rujukan($id){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			
			$query = "SELECT *, CONVERT(VARCHAR(30), TANGGAL_SURAT, 103) AS TGL_SURAT, CONVERT(VARCHAR(30), TANGGAL_SURAT_PENGANTAR, 103) AS TGL_SURAT_PENGANTAR,  dbo.FORMAT_NOMOR('SPL',KODE_SAMPEL) AS KODE_SAMPEL FROM T_SURAT_TANGGAPAN_RUJUKAN WHERE KODE_SAMPEL_LAMA = '".$id."'";
			
			$res = $sipt->main->get_result($query);
			$bulan = $this->config->config;
			$bulan = $bulan['bulan'];

			if($res){

				foreach($query->result_array() as $row){
					$tgl = explode('/', $row['TGL_SURAT']);
					$tgla = (int)$tgl[1];
					$tgla = $bulan[$tgla];					
					$row['TGL_SRT'] = $tgl[0]." ".$tgla." ".$tgl[2];

					$tgl1 = explode('/', $row['TGL_SURAT_PENGANTAR']);
					$tgla1 = (int)$tgl1[1];
					$tgla1 = $bulan[$tgla1];					
					$row['TGL_SURAT_PENGANTAR'] = $tgl1[0]." ".$tgla1." ".$tgl1[2];				

					$sampel[] = $row; 
					$arrdata = array('header' => $sampel);
				}


				$this->load->library('mpdf');
				$mpdf=new mPDF('win-1252',array(210,330));
				//$mpdf=new mPDF('','', 0, '', 15, 115, 16, 16, 9, 9, 'L');
				$mpdf->mirrorMargins = true;
				$mpdf->SetAuthor("Bobi Hariadi");
				$mpdf->SetDisplayMode('fullpage','two');
				$html = $this->load->view('pengujian/rujukan/cetak/tanggapan_rujukan', $arrdata, true);
				$lampiran = $this->mpdf->WriteHTML($html);
				$lampiran = $this->mpdf->Output();
				echo $lampiran;
				exit();
			}
		}
	}		
}
?>