<?php

class Welcome extends Controller {

	function Welcome()
	{
		parent::Controller();
		$this->load->model('main');	
	}
	
	function index()
	{
		$this->load->view('welcome_message');
	}
	function timeline(){
		$query = "SELECT A.KODE_SAMPEL, dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) AS UR_KODE_SAMPEL,
				  A.NAMA_SAMPEL, A.KOMODITI, A.BBPOM_ID, 
				  CONVERT(VARCHAR(10), A.TANGGAL_SAMPLING, 103) AS TANGGAL_SAMPLING,
				  CONVERT(VARCHAR(10), C.TANGGAL, 103) AS TGL_SPU,
				  CONVERT(VARCHAR(10), C.TANGGAL_KIRIM, 103) AS TGL_KIRIM_PEMDIK,
				  CONVERT(VARCHAR(10), C.TANGGAL_TERIMA_TPS, 103) AS TGL_TERIMA_TPS,
				  CONVERT(VARCHAR(10), C.TANGGAL_PERINTAH, 103) AS TGL_PERINTAH,
				  CONVERT(VARCHAR(10), C.CREATE_DATE, 103) AS CREATE_SPU,
				  CONVERT(VARCHAR(10), D.TANGGAL, 103) AS TGL_SPK,
				  CONVERT(VARCHAR(10), D.CREATE_DATE, 103) AS CREATE_SPK,
				  CONVERT(VARCHAR(10), E.TANGGAL, 103) AS TGL_SPP,
				  D.SPK_ID, LEFT(RIGHT(D.SPK_ID,5),1) AS BIDANG,
				  CONVERT(VARCHAR(10), A.AWAL_UJI, 103) AS AWAL_UJI,CONVERT(VARCHAR(10), A.AKHIR_UJI, 103) AS AKHIR_UJI
				  FROM T_M_SAMPEL_RILIS A
				  LEFT JOIN T_M_SAMPEL B ON A.KODE_SAMPEL = B.KODE_SAMPEL
				  LEFT JOIN T_SPU C ON B.SPU_ID = C.SPU_ID
				  LEFT JOIN T_SPK D ON B.KODE_SAMPEL = D.KODE_SAMPEL
				  LEFT JOIN T_SPP E ON D.SPK_ID = E.SPK_ID
				  WHERE 
				  dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) = '15.100.01.13.01.0075.KM'";
		$data = $this->main->get_result($query);
		$affected = 0;
		$error = 0;
		if($data){
			foreach($query->result_array() as $row){
				$arrdata['SERI'] = (int)$this->main->get_uraian("SELECT COUNT(*) AS SERI FROM T_REKAP_TGL_PENGUJIAN WHERE KODE_SAMPEL = '".$row['KODE_SAMPEL']."'","SERI") + 1;
				$arrdata['KODE_SAMPEL'] = $row['KODE_SAMPEL'];
				$arrdata['NAMA_SAMPEL'] = $row['NAMA_SAMPEL'];
				$arrdata['KOMODITI'] = $row['KOMODITI'];
				$arrdata['BBPOM_ID'] = $row['BBPOM_ID'];
				$arrdata['TANGGAL_SAMPLING'] = $row['TANGGAL_SAMPLING'];
				$arrdata['TANGGAL_SPU'] = $row['TGL_SPU'];
				$arrdata['TANGGAL_KIRIM_PEMDIK'] = $row['TGL_KIRIM_PEMDIK'];
				$arrdata['TANGGAL_TERIMA_TPS'] = $row['TGL_TERIMA_TPS'];
				$arrdata['TANGGAL_PERINTAH'] = $row['TGL_PERINTAH'];
				$arrdata['TANGGAL_SPK'] = $row['TGL_SPK'];
				$arrdata['TANGGAL_SPP'] = $row['TGL_SPP'];
				$arrdata['BIDANG'] = $row['BIDANG'];
				$arrdata['AWAL_UJI'] = $row['AWAL_UJI'];
				$arrdata['AKHIR_UJI'] = $row['AKHIR_UJI'];
				
				$queryx = "SELECT CONVERT(VARCHAR(10), A.PEJABAT_TANGGAL, 103) AS TGL_TTD,
						  CONVERT(VARCHAR(10), A.CREATE_DATE, 103) AS CREATE_CP,
						  CONVERT(VARCHAR(10), A.CREATE_DATE, 103) AS TGL_LHU
						  FROM T_CP A 
						  LEFT JOIN T_LHU B ON A.CP_ID = B.CP_ID
						  WHERE A.KODE_SAMPEL = '".$row['KODE_SAMPEL']."'";
				if($this->main->get_result($queryx)){
					foreach($queryx->result_array() as $rowx){
						$arrdata['TANGGAL_PEJABAT'] = $rowx['TGL_TTD'];
						$arrdata['TANGGAL_CP'] = $rowx['CREATE_CP'];
						$arrdata['TANGGAL_LHU'] = $rowx['TGL_LHU'];
					}
				}
				
				$ujibidang = $this->db->query("SELECT SPK_ID, MIN(CONVERT(VARCHAR(10),AWAL_UJI,120)) AS AWAL_UJI_BIDANG, MAX(CONVERT(VARCHAR(10),AKHIR_UJI,120)) AS AKHIR_UJI_BIDANG FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL = '".$row['KODE_SAMPEL']."' AND SPK_ID = '".$row['SPK_ID']."' GROUP BY SPK_ID")->row();
				$awal = explode("-",$ujibidang->AWAL_UJI_BIDANG);
				$awal = $awal[2]."/".$awal[1]."/".$awal[0];
				$akhir = explode("-",$ujibidang->AKHIR_UJI_BIDANG);
				$akhir = $akhir[2]."/".$akhir[1]."/".$akhir[0];
				$arrdata['AWAL_UJI_BIDANG'] = $awal;
				$arrdata['AKHIR_UJI_BIDANG'] = $akhir;
				$this->db->insert('T_REKAP_TGL_PENGUJIAN', $arrdata);
				if($this->db->affected_rows() > 0){
					$affected++;
				}else{
					$error++;
				}
			}
		}
		echo "Data Masuk : ".$affected.", Datat Gagal : ".$error;
	}
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */