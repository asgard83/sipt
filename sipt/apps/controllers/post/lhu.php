<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Lhu extends Controller{
	
	function Lhu(){
		parent::Controller();
	}
	
	function index(){
	  	$this->fungsi->redirectMessage('Maaf anda tidak bisa mengakses halaman ini.','/home');
	}
	
	
	function lhu_act($action="", $isajax=""){#Proses Ke sp_act
		if(strtolower($_SERVER['REQUEST_METHOD'])!="post"){
			redirect(base_url());
			exit();
		}else{
			$this->load->model('pengujian/lhu_act');
			$ret = $this->lhu_act->set_lhu($action, $isajax);
		}
		if($isajax!="ajax"){
	  		$this->fungsi->redirectMessage('Maaf anda tidak bisa mengakses halaman ini.','/home');
		}
		echo $ret;
	}	
}
?>