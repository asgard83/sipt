<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cp extends Controller{
	
	function Cp(){
		parent::Controller();
	}
	
	function index(){
	  	$this->fungsi->redirectMessage('Maaf anda tidak bisa mengakses halaman ini.','/home');
	}
	
	
	function cp_act($action="", $isajax=""){#Proses Ke sp_act
		if(strtolower($_SERVER['REQUEST_METHOD'])!="post"){
			redirect(base_url());
			exit();
		}else{
			$this->load->model('pengujian/cp_act');
			$ret = $this->cp_act->set_cp($action, $isajax);
		}
		if($isajax!="ajax"){
	  		$this->fungsi->redirectMessage('Maaf anda tidak bisa mengakses halaman ini.','/home');
		}
		echo $ret;
	}	
}
?>