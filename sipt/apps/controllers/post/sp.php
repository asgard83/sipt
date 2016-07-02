<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Sp extends Controller{
	
	function Sp(){
		parent::Controller();
	}
	
	function index(){
	  	$this->fungsi->redirectMessage('Maaf anda tidak bisa mengakses halaman ini.','/home');
	}
	
	function dispo_act($action="", $isajax=""){#Proses Ke sp_act
		if(strtolower($_SERVER['REQUEST_METHOD'])!="post"){
			redirect(base_url());
			exit();
		}else{
			$this->load->model('pengujian/sp_act');
			$ret = $this->sp_act->set_disposp($action, $isajax);
		}
		if($isajax!="ajax"){
	  		$this->fungsi->redirectMessage('Maaf anda tidak bisa mengakses halaman ini.','/home');
		}
		echo $ret;
	}
	
	function sp_act($action="", $isajax=""){#Proses Ke sp_act
		if(strtolower($_SERVER['REQUEST_METHOD'])!="post"){
			redirect(base_url());
			exit();
		}else{
			$this->load->model('pengujian/sp_act');
			$ret = $this->sp_act->set_sp($action, $isajax);
		}
		if($isajax!="ajax"){
	  		$this->fungsi->redirectMessage('Maaf anda tidak bisa mengakses halaman ini.','/home');
		}
		echo $ret;
	}	
}
?>