<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Utility extends Controller{
	
	function set_log($action="", $isajax=""){
		if(strtolower($_SERVER['REQUEST_METHOD'])!="post"){
			redirect(base_url());
			exit();
		}else{
			$this->load->model('admin/utility_act');
			$ret = $this->utility_act->set_log($action, $isajax);
		}
		
		if($isajax!="ajax"){
			redirect(base_url());
			exit();
		}
		echo $ret;
	}
	
	function set_news($action="", $isajax=""){
		if(strtolower($_SERVER['REQUEST_METHOD'])!="post"){
			redirect(base_url());
			exit();
		}else{
			$this->load->model('admin/utility_act');
			$ret = $this->utility_act->set_news($action, $isajax);
		}
		
		if($isajax!="ajax"){
			redirect(base_url());
			exit();
		}
		echo $ret;
	}
	
	function set_faq($action="",$isajax=""){
		if(strtolower($_SERVER['REQUEST_METHOD'])!="post" && !$this->newsession->userdata('LOGGED_IN') ==  TRUE ){
			redirect(base_url());
			exit();
		}else{
			$this->load->model("admin/utility_act");
			$ret = $this->utility_act->set_faq($action, $isajax);
		}
		if($isajax!="ajax"){
			redirect(base_url());
			exit();
		}
		echo $ret;
	}
	
	function set_reference($action="",$isajax=""){
		if(strtolower($_SERVER['REQUEST_METHOD'])!="post" && !$this->newsession->userdata('LOGGED_IN') ==  TRUE ){
			redirect(base_url());
			exit();
		}else{
			$this->load->model("admin/utility_act");
			$ret = $this->utility_act->set_reference($action, $isajax);
		}
		if($isajax!="ajax"){
			redirect(base_url());
			exit();
		}
		echo $ret;
	}

	
}