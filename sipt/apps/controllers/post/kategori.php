<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Kategori extends Controller{
	function Kategori(){
		parent::Controller();
	}
	
	function index(){
		
	}
	
	function kategori_act($action, $isajax){
		if($this->newsession->userdata('LOGGED_IN') == TRUE){
			if(strtolower($_SERVER['REQUEST_METHOD'])!="post"){
				redirect(base_url());
				exit();
			}else{
				$this->load->model('master/kategori_act');
				$ret = $this->kategori_act->set_kategori($action, $isajax);
			}
			if($isajax!="ajax"){
				redirect(base_url());
			}
			echo $ret;
		}
	}

	
}