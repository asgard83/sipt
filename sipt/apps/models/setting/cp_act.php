<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR);
class Cp_act extends Model{
	
	function get_cp($balai){
		if(in_array('1', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('9', $this->newsession->userdata('SESS_KODE_ROLE'))){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$query = "SELECT A.BBPOM_ID, A.KOMODITI, B.KLASIFIKASI, A.NOMOR, A.RESET, CASE WHEN A.RESET = 'Y' THEN 'Per Tahun' WHEN A.RESET = 'M' THEN 'Per Bulan' END AS UR_RESET, A.AUTO_RESET, CONVERT(VARCHAR(10), A.UPDATED, 105) AS UPDATED FROM M_REF_CP A LEFT JOIN M_GOLONGAN B ON A.KOMODITI = B.KLASIFIKASI_ID AND LEN(B.KLASIFIKASI_ID) = 2 WHERE A.BBPOM_ID = '".$balai."' ORDER BY 2, 3";
			$data = $sipt->main->get_result($query);
			if($data){
				$arrdata = array('balai' => $balai);
				foreach($query->result_array() as $row){
					$arrdata['sess'][] = $row;
				}
				return $arrdata;
			}
		}
	}
	
	function set_cp($multi, $balai, $komoditi, $reset=""){
		if(in_array('1', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('9', $this->newsession->userdata('SESS_KODE_ROLE'))){
			if($multi == "single"){
				$arrdata = array("AUTO_RESET" => ($reset == "0" ? 1 : 0),'RESET_DATE' => 'GETDATE()', 'RESET_BY' => $this->newsession->userdata('SESS_USER_ID'));
				$this->db->where('BBPOM_ID', $balai);
				$this->db->where('KOMODITI', $komoditi);
				$ret = $this->db->update("M_REF_CP", $arrdata);
				if($ret) return "MSG#YES#Auto reset berhasil di update";
				else return "MSG#NO#Auto reset gagal di update";
			}else if($multi == "multi"){
				$arrdata = array("AUTO_RESET" => 1,'RESET_DATE' => 'GETDATE()', 'RESET_BY' => $this->newsession->userdata('SESS_USER_ID'));
				$this->db->where('BBPOM_ID', $balai);
				$ret = $this->db->update("M_REF_CP", $arrdata);
				if($ret) return "MSG#YES#Auto reset berhasil di update";
				else return "MSG#NO#Auto reset gagal di update";
			}
		}
	}
}
?>