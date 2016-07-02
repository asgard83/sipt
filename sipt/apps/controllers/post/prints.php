<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Prints extends Controller{
	
	function Prints(){
		parent::Controller();
	}
	
	function index(){
		redirect(base_url());
		exit();
	}
		
	function pemeriksaan($rpt){
		$sipt =& get_instance();
		$this->load->model("main", "main", true);
		$jenis = $this->input->post('JENIS');
		$judul = $sipt->main->get_judul($this->input->post("JENIS"));
		if($rpt=="komoditi"){
			$this->load->model('report/report_act');
			$arrdata = $this->report_act->set_rekap_komoditi();
			$ret = $this->load->view('pemeriksaan/report/rekap/REKAP_KOMODITI', $arrdata, true);		
		}else if($rpt=="status"){
			$this->load->model('report/report_act');
			if(!in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))){
				$arrdata = $this->report_act->set_rekap_status();
				$ret = $this->load->view('pemeriksaan/report/rekap/REKAP_STATUS_DOKUMEN', $arrdata, true);	
			}else{
				$arrdata = $this->report_act->set_rekap_unit();
				$ret = $this->load->view('pemeriksaan/report/rekap/REKAP_STATUS_UNIT', $arrdata, true);	
			}
		}else if($rpt=="statuskomoditi"){
			$this->load->model('report/report_act');
			$arrdata = $this->report_act->set_rekap_status_komoditi();
			$ret = $this->load->view('pemeriksaan/report/rekap/REKAP_STATUS_KOMODITI', $arrdata, true);		
		}else if($rpt=="produk"){
			$this->load->model('report/report_act');
			$arrdata = $this->report_act->set_temuan_produk();
			$ret = $this->load->view('pemeriksaan/report/produk/'.$this->input->post('PRODUK_KLASIFIKASI'), $arrdata, true);		
		}else if($rpt=="rhpk"){
			$modul = "rhpk_".$this->input->post('JENIS');
			$this->load->model('roren/roren_act');
			$distribusi = array('02MM','02LL','02TF','03AA','03BB','03RS','03TR','03WW');
			$napza = array('01ON','02MN','02TN','03AN','03BN','03NN','03RN','03TP','03WN');
			if(in_array($this->input->post('JENIS'), $distribusi)){
				$file = "distribusi";
				$arrdata = $this->roren_act->rhpk_distribusi();	
			}else if(in_array($this->input->post('JENIS'),$napza)){
				$file = "napza";
				$arrdata = $this->roren_act->rhpk_napza();
			}else{
				$file = $this->input->post('JENIS');
				$arrdata = $this->roren_act->$modul();
			}
			$ret = $this->load->view('pemeriksaan/report/rhpk/'.$file, $arrdata, true);		
		}
		
		if(!in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))){
			$balai = $this->newsession->userdata('SESS_MBBPOM');
		}else{
			if(trim($this->input->post('BBPOM_ID'))==""){
				$balai = 'ALL';
			}else{
				$balai = str_replace(" ","_",$sipt->main->get_uraian("SELECT NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID = '".$this->input->post('BBPOM_ID')."'","NAMA_BBPOM"));
			}
		}
		
		header("Content-type: application/x-msdownload");
		header("Content-Disposition: attachment; filename=\"PEMERIKSAAN_SARANA_$balai_".date("YmdHis").".xls\"");
		header("Pragma: no-cache");
		header("Expires: 0");
		echo "$headers\n$ret";
	}
	
}

?>