<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR);
class Sps_act extends Model{
	function list_sps($doc="all", $jenis){
		if(in_array('7', $this->newsession->userdata('SESS_KODE_ROLE')) && $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$this->load->library('newtable');
			if($jenis=="rutin"){
				$this->newtable->hiddens(array('SPU_GENERATE'));
				$this->newtable->search(array(array("dbo.FORMAT_NOMOR('SPU', SPU_GENERATE)", "Nomor SPU"),array("dbo.FORMAT_NOMOR('SPS',NOMOR_SPS)", "Nomor SPS"), array("CONVERT(VARCHAR(10), TANGGAL, 120)", "Tanggal"),array("dbo.URAIAN_M_TABEL('ASAL_SAMPLING', ASAL_SAMPLING)", "Asal Sampel"),array('dbo.GOLONGAN_SAMPEL(KLASIFIKASI)','Komoditi')));
				$query = "SELECT SPU_GENERATE, dbo.FORMAT_NOMOR('SPU', SPU_GENERATE) AS [NOMOR SPU], dbo.FORMAT_NOMOR('SPS',NOMOR_SPS) AS [NOMOR SPS], CONVERT(VARCHAR(10), TANGGAL_TERIMA_TPS, 120) AS [TANGGAL TERIMA],
						  dbo.URAIAN_M_TABEL('ANGGARAN_SAMPLING', ANGGARAN) AS ANGGARAN,
						  dbo.GOLONGAN_SAMPEL(KLASIFIKASI) AS KOMODITI,
						  (SELECT COUNT(SPU_ID) FROM T_SAMPEL A WHERE A.SPU_ID = SPU_GENERATE) AS [TOTAL SAMPEL],
						  dbo.URAIAN_M_TABEL('STATUS',STATUS) AS STATUS
						  FROM T_SURAT_PERMINTAAN_UJI WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND STATUS = '70001'";
				$this->newtable->columns(array("SPU_GENERATE", "dbo.FORMAT_NOMOR('SPU', SPU_GENERATE)", "dbo.FORMAT_NOMOR('SPS',NOMOR_SPS)","CONVERT(VARCHAR(10), TANGGAL_TERIMA_TPS, 120)", "dbo.URAIAN_M_TABEL('ASAL_SAMPLING', ASAL_SAMPLING)","dbo.GOLONGAN_SAMPEL(KLASIFIKASI)","(SELECT COUNT(SPU_ID) FROM T_SAMPEL A WHERE A.SPU_ID = SPU_GENERATE)","dbo.URAIAN_M_TABEL('STATUS',STATUS)"));
				$this->newtable->action(site_url()."/home/pengujian/sps/all/rutin");
				$this->newtable->width(array('NOMOR SPU' => 200, 'NOMOR SPS' => 200, 'TANGGAL TERIMA' => 120, 'ANGGARAN' => 100, 'ASAL SAMPEL' => 150, 'KOMODITI' => 100,'TOTAL SAMPEL' => 75, 'STATUS' => 150));
				$this->newtable->cidb($this->db);
				$this->newtable->ciuri($this->uri->segment_array());
				$this->newtable->orderby(1);
				$this->newtable->sortby("ASC");
				$this->newtable->keys(array('SPU_GENERATE'));
				//$proses['Cetak Surat Penyerahan Sampel'] = array('GETNEW', site_url()."/topdf/sps/prints", '1');
				$proses['Tambah Surat Perintah Uji'] = array('GET', site_url()."/home/pengujian/spu/new", '1');
				$this->newtable->menu($proses);
				$tabel = $this->newtable->generate($query);
			}
			$arrdata = array('table' => $tabel,
							 'idjudul' => 'juduluji',
							 'caption_header' => 'Data Penerimaan Sampel',
							 'batal' => '',
							 'cancel' => '');
			return $arrdata;
		}
	}
	
	function get_sps($id){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE && (in_array('1',$this->newsession->userdata('SESS_KODE_ROLE')) || in_array('9',$this->newsession->userdata('SESS_KODE_ROLE')) || in_array('7',$this->newsession->userdata('SESS_KODE_ROLE')))){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$arrid = explode(".",$id);
			$query = "SELECT A.SPU_ID, A.KODE_SAMPEL, A.USER_ID, dbo.FORMAT_NOMOR('SPU',A.SPU_ID) AS UR_SPU, dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) AS UR_SPL, A.STATUS, B.NAMA_USER, CASE WHEN A.STATUS = '40201' THEN 'Pembuatan SPK' WHEN A.STATUS = '30201' THEN 'Terbit SPK' WHEN A.STATUS = '40205' THEN 'Review Ulang SPK' END AS UR_STATUS FROM T_SAMPEL_MT A LEFT JOIN T_USER B ON A.USER_ID = B.USER_ID WHERE A.SPU_ID = '".$arrid[0]."' AND A.KODE_SAMPEL = '".$arrid[1]."' AND A.USER_ID = '".$arrid[2]."'";
			$data = $sipt->main->get_result($query);
			if($data){
				foreach($query->result_array() as $row){
					$arrdata['sess'] = $row;
				}
				$arrdata['jml'] = (int)$sipt->main->get_uraian("SELECT COUNT(*) AS JML FROM T_SPK WHERE SPU_ID = '".$row['SPU_ID']."' AND KODE_SAMPEL = '".$row['KODE_SAMPEL']."' AND CREATE_BY = '".$row['USER_ID']."'","JML");
				$spk = "SELECT dbo.FORMAT_NOMOR('SPK', A.SPK_ID) AS UR_SPK, dbo.GOLONGAN_SAMPEL(A.KOMODITI) AS KOMODITI, CONVERT(VARCHAR(10), A.TANGGAL, 103) AS TANGGAL, B.NAMA_USER AS PENYELIA FROM T_SPK A LEFT JOIN T_USER B ON A.KASIE = B.USER_ID WHERE A.SPU_ID = '".$row['SPU_ID']."' AND A.KODE_SAMPEL = '".$row['KODE_SAMPEL']."' AND A.CREATE_BY = '".$row['USER_ID']."'";
				$dspk = $sipt->main->get_result($spk);
				if($dspk){
					foreach($spk->result_array() as $row){
						$arrdata['spk'] = $row;
					}
				}
				$arrdata['status'] = array('' => '', '40201' => 'Pembuatan SPK', '30201' => 'Terbit SPK', '40205' => 'Review Ulang SPK');
				$arrdata['act'] = site_url().'/post/sp/dispo_act/update-sps';
				return $arrdata;
			}
		}

	}
	
}
?>