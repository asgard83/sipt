<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class User extends Controller{
	
	function User(){
		parent::Controller();
	}
	
	function index(){ 	
	  	$this->fungsi->redirectMessage('Maaf anda tidak bisa mengakses halaman ini.','/home');
	}
	
	function privilage(){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$jml = count($this->newsession->userdata('SESS_KODE_ROLE'));
			if($jml > 1){
				$this->load->model('privilage_act');
				$arrdata = $this->privilage_act->get_privilage();
				echo $this->load->view('privilage', $arrdata, true);
			}else{
				echo $jml;
			}
		}
	}
	
	function set_privilage($isajax){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			if(strtolower($_SERVER['REQUEST_METHOD'])!="post"){
				redirect(base_url());
				exit();
			}else{
				$this->load->model('privilage_act');
				$ret = $this->privilage_act->set_privilage();
			}
			echo $ret;
		}
	}
	
}
?>