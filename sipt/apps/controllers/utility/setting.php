<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR);
class Setting extends Controller{
	function Setting(){
		parent::Controller();
	}
	
	function get_sampel($balai,$anggaran){
		if (in_array('1', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('9', $this->newsession->userdata('SESS_KODE_ROLE'))) {
			$this->load->model('setting/sampel_act');
			$arrdata = $this->sampel_act->get_sampel($balai, $anggaran);
			echo $this->load->view('admin/setting/list-nomor',$arrdata,true);
		}
	}
	
	function set_sampel($multi, $balai, $anggaran, $komoditi, $reset=""){
		if (in_array('1', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('9', $this->newsession->userdata('SESS_KODE_ROLE'))) {
			$this->load->model('setting/sampel_act');
			echo $this->sampel_act->set_sampel($multi, $balai, $anggaran, $komoditi, $reset);
		}
	}

	function get_spu($balai,$anggaran){
		if (in_array('1', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('9', $this->newsession->userdata('SESS_KODE_ROLE'))) {
			$this->load->model('setting/spu_act');
			$arrdata = $this->spu_act->get_spu($balai, $anggaran);
			echo $this->load->view('admin/setting/list-spu',$arrdata,true);
		}
	}
	
	function set_spu($multi, $balai, $anggaran, $komoditi, $reset=""){
		if (in_array('1', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('9', $this->newsession->userdata('SESS_KODE_ROLE'))) {
			$this->load->model('setting/spu_act');
			echo $this->spu_act->set_spu($multi, $balai, $anggaran, $komoditi, $reset);
		}
	}
	
	function get_sps($balai,$anggaran){
		if (in_array('1', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('9', $this->newsession->userdata('SESS_KODE_ROLE'))) {
			$this->load->model('setting/sps_act');
			$arrdata = $this->sps_act->get_sps($balai, $anggaran);
			echo $this->load->view('admin/setting/list-sps',$arrdata,true);
		}
	}
	
	function set_sps($multi, $balai, $anggaran, $komoditi, $reset=""){
		if (in_array('1', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('9', $this->newsession->userdata('SESS_KODE_ROLE'))) {
			$this->load->model('setting/sps_act');
			echo $this->sps_act->set_sps($multi, $balai, $anggaran, $komoditi, $reset);
		}
	}
	
	function get_spk($balai){
		if (in_array('1', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('9', $this->newsession->userdata('SESS_KODE_ROLE'))) {
			$this->load->model('setting/spk_act');
			$arrdata = $this->spk_act->get_spk($balai);
			echo $this->load->view('admin/setting/list-spk',$arrdata,true);
		}
	}
	
	function set_spk($multi, $balai, $bidang, $komoditi, $reset=""){
		if (in_array('1', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('9', $this->newsession->userdata('SESS_KODE_ROLE'))) {
			$this->load->model('setting/spk_act');
			echo $this->spk_act->set_spk($multi, $balai, $bidang, $komoditi, $reset);
		}
	}
	
	function get_spp($balai){
		if (in_array('1', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('9', $this->newsession->userdata('SESS_KODE_ROLE'))) {
			$this->load->model('setting/spp_act');
			$arrdata = $this->spp_act->get_spp($balai);
			echo $this->load->view('admin/setting/list-spp',$arrdata,true);
		}
	}
	
	function set_spp($multi, $balai, $bidang, $komoditi, $reset=""){
		if (in_array('1', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('9', $this->newsession->userdata('SESS_KODE_ROLE'))) {
			$this->load->model('setting/spp_act');
			echo $this->spp_act->set_spp($multi, $balai, $bidang, $komoditi, $reset);
		}
	}
	
	function get_uji($balai){
		if (in_array('1', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('9', $this->newsession->userdata('SESS_KODE_ROLE'))) {
			$this->load->model('setting/uji_act');
			$arrdata = $this->uji_act->get_uji($balai);
			echo $this->load->view('admin/setting/list-uji',$arrdata,true);
		}
	}
	
	function set_uji($multi, $balai, $bidang, $komoditi, $reset=""){
		if (in_array('1', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('9', $this->newsession->userdata('SESS_KODE_ROLE'))) {
			$this->load->model('setting/uji_act');
			echo $this->uji_act->set_uji($multi, $balai, $bidang, $komoditi, $reset);
		}
	}
	
	function get_cp($balai){
		if (in_array('1', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('9', $this->newsession->userdata('SESS_KODE_ROLE'))) {
			$this->load->model('setting/cp_act');
			$arrdata = $this->cp_act->get_cp($balai);
			echo $this->load->view('admin/setting/list-cp',$arrdata,true);
		}
	}
	
	function set_cp($multi, $balai, $komoditi, $reset=""){
		if (in_array('1', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('9', $this->newsession->userdata('SESS_KODE_ROLE'))) {
			$this->load->model('setting/cp_act');
			echo $this->cp_act->set_cp($multi, $balai, $komoditi, $reset);
		}
	}
	
	function get_lhu($balai,$anggaran){
		if (in_array('1', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('9', $this->newsession->userdata('SESS_KODE_ROLE'))) {
			$this->load->model('setting/lhu_act');
			$arrdata = $this->lhu_act->get_lhu($balai, $anggaran);
			echo $this->load->view('admin/setting/list-lhu',$arrdata,true);
		}
	}
	
	function set_lhu($multi, $balai, $anggaran, $komoditi, $reset=""){
		if (in_array('1', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('9', $this->newsession->userdata('SESS_KODE_ROLE'))) {
			$this->load->model('setting/lhu_act');
			echo $this->lhu_act->set_lhu($multi, $balai, $anggaran, $komoditi, $reset);
		}
	}

	
}
?>
