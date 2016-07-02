<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Puk extends Controller{
	
	function Puk(){
		parent::Controller();
	}
	
	function index(){
	  	$this->fungsi->redirectMessage('Maaf anda tidak bisa mengakses halaman ini.','/home');
	}
	
	function puk_act($action="", $isajax=""){#Proses Ke Puk Act
		if(strtolower($_SERVER['REQUEST_METHOD'])!="post"){
			redirect(base_url());
			exit();
		}else{
			$this->load->model('pengujian/puk_act');
			$ret = $this->puk_act->set_puk($action, $isajax);
		}
		if($isajax!="ajax"){
	  		$this->fungsi->redirectMessage('Maaf anda tidak bisa mengakses halaman ini.','/home');
		}
		echo $ret;
	}
		
}
?>