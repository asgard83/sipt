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
}
?>