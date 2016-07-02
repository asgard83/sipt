<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Rujukan extends Controller{
	
	function Rujukan(){
		parent::Controller();
	}
	
	function index(){
	  	$this->fungsi->redirectMessage('Maaf anda tidak bisa mengakses halaman ini.','/home');
	}
	
	function rujukan_act($action="", $isajax=""){
		if(strtolower($_SERVER['REQUEST_METHOD'])!="post"){
			redirect(base_url());
			exit();
		}else{
			#$this->load->model('pengujian/sampel_act');
			#$ret = $this->sampel_act->set_sampel($action, $isajax);
		}
		if($isajax!="ajax"){
	  		$this->fungsi->redirectMessage('Maaf anda tidak bisa mengakses halaman ini.','/home');
		}
		echo $ret;
	}
	
	function kirim_act($action="", $isajax=""){
		if(strtolower($_SERVER['REQUEST_METHOD'])!="post"){
			redirect(base_url());
			exit();
		}else{
			$this->load->model('pengujian/rujukan_act');
			$ret = $this->rujukan_act->set_kirim($action, $isajax);
		}
		if($isajax!="ajax"){
	  		$this->fungsi->redirectMessage('Maaf anda tidak bisa mengakses halaman ini.','/home');
		}
		echo $ret;
	}
	
	function set_rujukan($action="", $isajax=""){
		if(strtolower($_SERVER['REQUEST_METHOD'])!="post"){
			redirect(base_url());
			exit();
		}else{
			$this->load->model('pengujian/rujukan_act');
			$ret = $this->rujukan_act->set_proses($action, $isajax);
		}
		if($isajax!="ajax"){
	  		$this->fungsi->redirectMessage('Maaf anda tidak bisa mengakses halaman ini.','/home');
		}
		echo $ret;
	}
		
}
?>