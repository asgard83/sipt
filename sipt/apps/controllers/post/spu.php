<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Spu extends Controller{
	
	function Spu(){
		parent::Controller();
	}
	
	function index(){
	  	$this->fungsi->redirectMessage('Maaf anda tidak bisa mengakses halaman ini.','/home');
	}
	
	function spu_act($action="", $isajax=""){#Proses Ke Spu act
		if(strtolower($_SERVER['REQUEST_METHOD'])!="post"){
			redirect(base_url());
			exit();
		}else{
			$this->load->model('pengujian/spu_act');
			$ret = $this->spu_act->set_spu($action, $isajax);
		}
		if($isajax!="ajax"){
	  		$this->fungsi->redirectMessage('Maaf anda tidak bisa mengakses halaman ini.','/home');
		}
		echo $ret;
	}
		
}
?>