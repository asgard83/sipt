<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Prioritas extends Controller{
	function Prioritas(){
		parent::Controller();
	}
	
	function index(){
		
	}
	
	function prioritas_act($action, $isajax){
		if($this->newsession->userdata('LOGGED_IN') == TRUE){
			if(strtolower($_SERVER['REQUEST_METHOD'])!="post"){
				redirect(base_url());
				exit();
			}else{
				$this->load->model('master/prioritas_act');
				$ret = $this->prioritas_act->set_prioritas($action, $isajax);
			}
			if($isajax!="ajax"){
				redirect(base_url());
			}
			echo $ret;
		}
	}

	
}