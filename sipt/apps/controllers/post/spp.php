<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Spp extends Controller{
	
	function Spp(){
		parent::Controller();
	}
	
	function index(){
	  	$this->fungsi->redirectMessage('Maaf anda tidak bisa mengakses halaman ini.','/home');
	}
	
	function spp_act($action="", $isajax=""){#Proses Ke Spp Act
		if(strtolower($_SERVER['REQUEST_METHOD'])!="post"){
			redirect(base_url());
			exit();
		}else{
			$this->load->model('pengujian/spp_act');
			$ret = $this->spp_act->set_spp($action, $isajax);
		}
		if($isajax!="ajax"){
	  		$this->fungsi->redirectMessage('Maaf anda tidak bisa mengakses halaman ini.','/home');
		}
		echo $ret;
	}
		
}
?>