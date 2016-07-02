<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Spux extends Controller{
	
	function Spux(){
		parent::Controller();
	}
	
	function index(){
	  	$this->fungsi->redirectMessage('Maaf anda tidak bisa mengakses halaman ini.','/home');
	}
	
	function spux_act($action="", $isajax=""){#Proses Ke Spu act
		if(strtolower($_SERVER['REQUEST_METHOD'])!="post"){
			redirect(base_url());
			exit();
		}else{
			$this->load->model('pengujian/spux_act');
			$ret = $this->spux_act->set_spu($action, $isajax);
		}
		if($isajax!="ajax"){
	  		$this->fungsi->redirectMessage('Maaf anda tidak bisa mengakses halaman ini.','/home');
		}
		echo $ret;
	}
		
}
?>