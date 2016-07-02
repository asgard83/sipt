<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR);
class Spu_act extends Model{
	
	function get_spu($balai, $anggaran){
		if(in_array('1', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('9', $this->newsession->userdata('SESS_KODE_ROLE'))){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$query = "SELECT A.BBPOM_ID, A.ANGGARAN, A.KOMODITI, B.URAIAN AS UR_ANGGARAN, C.KLASIFIKASI, A.NOMOR, CASE WHEN A.RESET = 'Y' THEN 'Per Tahun' WHEN A.RESET = 'M' THEN 'Per Bulan' WHEN A.RESET = 'D' THEN 'Per Hari' END AS RESET, A.AUTO_RESET, A.CURRENT_YEAR, CONVERT(VARCHAR(10), A.UPDATED, 105) AS UPDATED FROM M_REF_SPU A LEFT JOIN M_TABEL B ON A.ANGGARAN = B.KODE AND B.JENIS = 'ANGGARAN_SAMPLING' LEFT JOIN M_GOLONGAN C ON A.KOMODITI = C.KLASIFIKASI_ID AND LEN(C.KLASIFIKASI_ID) = 2 WHERE A.BBPOM_ID = '".$balai."' AND A.ANGGARAN = '".$anggaran."' ORDER BY 2";
			$data = $sipt->main->get_result($query);
			if($data){
				$arrdata = array('balai' => $balai, 
							     'anggaran' => $anggaran);
				foreach($query->result_array() as $row){
					$arrdata['sess'][] = $row;
				}
				return $arrdata;
			}
		}
	}
	
	function set_spu($multi, $balai, $anggaran, $komoditi, $reset=""){
		if(in_array('1', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('9', $this->newsession->userdata('SESS_KODE_ROLE'))){
			if($multi == "single"){
				$arrdata = array("AUTO_RESET" => ($reset == "0" ? 1 : 0),'RESET_DATE' => 'GETDATE()', 'RESET_BY' => $this->newsession->userdata('SESS_USER_ID'));
				$this->db->where('BBPOM_ID', $balai);
				$this->db->where('ANGGARAN', $anggaran);
				$this->db->where('KOMODITI', $komoditi);
				$ret = $this->db->update("M_REF_SPU", $arrdata);
				if($ret) return "MSG#YES#Auto reset berhasil di update";
				else return "MSG#NO#Auto reset gagal di update";
			}else if($multi == "multi"){
				$arrdata = array("AUTO_RESET" => 1,'RESET_DATE' => 'GETDATE()', 'RESET_BY' => $this->newsession->userdata('SESS_USER_ID'));
				$this->db->where('BBPOM_ID', $balai);
				$this->db->where('ANGGARAN', $anggaran);
				$ret = $this->db->update("M_REF_SPU", $arrdata);
				if($ret) return "MSG#YES#Auto reset berhasil di update";
				else return "MSG#NO#Auto reset gagal di update";
			}
		}
	}
}
?>