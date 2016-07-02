<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR);
class Setting_act extends Model{
	function kode_sampel(){
		if (in_array('1', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('9', $this->newsession->userdata('SESS_KODE_ROLE'))) {
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$arrdata = array();
			if($this->newsession->userdata('SESS_BBPOM_ID') == "00")
			$arrdata['balai'] = $sipt->main->combobox("SELECT BBPOM_ID, REPLACE(REPLACE(NAMA_BBPOM,'BALAI BESAR POM DI ', ''),'BALAI POM DI ','') AS NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID NOT IN('00','91','92','93','94','95','96') ORDER BY 2 ASC","BBPOM_ID","NAMA_BBPOM", TRUE);
			else
			$arrdata['balai'] = $sipt->main->combobox("SELECT BBPOM_ID, REPLACE(REPLACE(NAMA_BBPOM,'BALAI BESAR POM DI ', ''),'BALAI POM DI ','') AS NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","BBPOM_ID","NAMA_BBPOM", TRUE);
			$arrdata['anggaran'] = $sipt->main->combobox("SELECT KODE, URAIAN FROM M_TABEL WHERE JENIS = 'ANGGARAN_SAMPLING'", "KODE","URAIAN", TRUE);
			return $arrdata;
		}
	}
	
	function spu(){
		if (in_array('1', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('9', $this->newsession->userdata('SESS_KODE_ROLE'))) {
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$arrdata = array();
			if($this->newsession->userdata('SESS_BBPOM_ID') == "00")
			$arrdata['balai'] = $sipt->main->combobox("SELECT BBPOM_ID, REPLACE(REPLACE(NAMA_BBPOM,'BALAI BESAR POM DI ', ''),'BALAI POM DI ','') AS NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID NOT IN('00','91','92','93','94','95','96') ORDER BY 2 ASC","BBPOM_ID","NAMA_BBPOM", TRUE);
			else
			$arrdata['balai'] = $sipt->main->combobox("SELECT BBPOM_ID, REPLACE(REPLACE(NAMA_BBPOM,'BALAI BESAR POM DI ', ''),'BALAI POM DI ','') AS NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","BBPOM_ID","NAMA_BBPOM", TRUE);
			$arrdata['anggaran'] = $sipt->main->combobox("SELECT KODE, URAIAN FROM M_TABEL WHERE JENIS = 'ANGGARAN_SAMPLING'", "KODE","URAIAN", TRUE);
			return $arrdata;
		}
	}

	function sps(){
		if (in_array('1', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('9', $this->newsession->userdata('SESS_KODE_ROLE'))) {
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$arrdata = array();
			if($this->newsession->userdata('SESS_BBPOM_ID') == "00")
			$arrdata['balai'] = $sipt->main->combobox("SELECT BBPOM_ID, REPLACE(REPLACE(NAMA_BBPOM,'BALAI BESAR POM DI ', ''),'BALAI POM DI ','') AS NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID NOT IN('00','91','92','93','94','95','96') ORDER BY 2 ASC","BBPOM_ID","NAMA_BBPOM", TRUE);
			else
			$arrdata['balai'] = $sipt->main->combobox("SELECT BBPOM_ID, REPLACE(REPLACE(NAMA_BBPOM,'BALAI BESAR POM DI ', ''),'BALAI POM DI ','') AS NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","BBPOM_ID","NAMA_BBPOM", TRUE);
			$arrdata['anggaran'] = $sipt->main->combobox("SELECT KODE, URAIAN FROM M_TABEL WHERE JENIS = 'ANGGARAN_SAMPLING'", "KODE","URAIAN", TRUE);
			return $arrdata;
		}
	}
	
	function spk(){
		if (in_array('1', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('9', $this->newsession->userdata('SESS_KODE_ROLE'))) {
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$arrdata = array();
			if($this->newsession->userdata('SESS_BBPOM_ID') == "00")
			$arrdata['balai'] = $sipt->main->combobox("SELECT BBPOM_ID, REPLACE(REPLACE(NAMA_BBPOM,'BALAI BESAR POM DI ', ''),'BALAI POM DI ','') AS NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID NOT IN('00','91','92','93','94','95','96') ORDER BY 2 ASC","BBPOM_ID","NAMA_BBPOM", TRUE);
			else
			$arrdata['balai'] = $sipt->main->combobox("SELECT BBPOM_ID, REPLACE(REPLACE(NAMA_BBPOM,'BALAI BESAR POM DI ', ''),'BALAI POM DI ','') AS NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","BBPOM_ID","NAMA_BBPOM",TRUE);
			return $arrdata;
		}
	}
	
	function spp(){
		if (in_array('1', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('9', $this->newsession->userdata('SESS_KODE_ROLE'))) {
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$arrdata = array();
			if($this->newsession->userdata('SESS_BBPOM_ID') == "00")
			$arrdata['balai'] = $sipt->main->combobox("SELECT BBPOM_ID, REPLACE(REPLACE(NAMA_BBPOM,'BALAI BESAR POM DI ', ''),'BALAI POM DI ','') AS NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID NOT IN('00','91','92','93','94','95','96') ORDER BY 2 ASC","BBPOM_ID","NAMA_BBPOM", TRUE);
			else
			$arrdata['balai'] = $sipt->main->combobox("SELECT BBPOM_ID, REPLACE(REPLACE(NAMA_BBPOM,'BALAI BESAR POM DI ', ''),'BALAI POM DI ','') AS NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","BBPOM_ID","NAMA_BBPOM",TRUE);
			return $arrdata;
		}
	}
	
	function uji(){
		if (in_array('1', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('9', $this->newsession->userdata('SESS_KODE_ROLE'))) {
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$arrdata = array();
			if($this->newsession->userdata('SESS_BBPOM_ID') == "00")
			$arrdata['balai'] = $sipt->main->combobox("SELECT BBPOM_ID, REPLACE(REPLACE(NAMA_BBPOM,'BALAI BESAR POM DI ', ''),'BALAI POM DI ','') AS NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID NOT IN('00','91','92','93','94','95','96') ORDER BY 2 ASC","BBPOM_ID","NAMA_BBPOM", TRUE);
			else
			$arrdata['balai'] = $sipt->main->combobox("SELECT BBPOM_ID, REPLACE(REPLACE(NAMA_BBPOM,'BALAI BESAR POM DI ', ''),'BALAI POM DI ','') AS NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","BBPOM_ID","NAMA_BBPOM",TRUE);
			return $arrdata;
		}
	}
	
	function cp(){
		if (in_array('1', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('9', $this->newsession->userdata('SESS_KODE_ROLE'))) {
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$arrdata = array();
			if($this->newsession->userdata('SESS_BBPOM_ID') == "00")
			$arrdata['balai'] = $sipt->main->combobox("SELECT BBPOM_ID, REPLACE(REPLACE(NAMA_BBPOM,'BALAI BESAR POM DI ', ''),'BALAI POM DI ','') AS NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID NOT IN('00','91','92','93','94','95','96') ORDER BY 2 ASC","BBPOM_ID","NAMA_BBPOM", TRUE);
			else
			$arrdata['balai'] = $sipt->main->combobox("SELECT BBPOM_ID, REPLACE(REPLACE(NAMA_BBPOM,'BALAI BESAR POM DI ', ''),'BALAI POM DI ','') AS NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","BBPOM_ID","NAMA_BBPOM",TRUE);
			return $arrdata;
		}
	}
	
	function lhu(){
		if (in_array('1', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('9', $this->newsession->userdata('SESS_KODE_ROLE'))) {
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$arrdata = array();
			if($this->newsession->userdata('SESS_BBPOM_ID') == "00")
			$arrdata['balai'] = $sipt->main->combobox("SELECT BBPOM_ID, REPLACE(REPLACE(NAMA_BBPOM,'BALAI BESAR POM DI ', ''),'BALAI POM DI ','') AS NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID NOT IN('00','91','92','93','94','95','96') ORDER BY 2 ASC","BBPOM_ID","NAMA_BBPOM", TRUE);
			else
			$arrdata['balai'] = $sipt->main->combobox("SELECT BBPOM_ID, REPLACE(REPLACE(NAMA_BBPOM,'BALAI BESAR POM DI ', ''),'BALAI POM DI ','') AS NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","BBPOM_ID","NAMA_BBPOM", TRUE);
			$arrdata['anggaran'] = $sipt->main->combobox("SELECT KODE, URAIAN FROM M_TABEL WHERE JENIS = 'ANGGARAN_SAMPLING'", "KODE","URAIAN", TRUE);
			return $arrdata;
		}
	}

	
}
?>