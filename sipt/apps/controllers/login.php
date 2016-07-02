<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends Controller{
	function Login(){
		parent::Controller();
	}
		
	function login_attempt($sessid="", $isajax=""){
		$ret = "";
		if(strtolower($_SERVER['REQUEST_METHOD'])!="post" || $this->session->userdata('session_id')!=$sessid){
			 $ret = "NO";
		}
		if($ret==""){
			$uid = $this->input->post('userid');
			$pwd = $this->input->post('password');
			$this->load->model('User_activity');
			$ret = $this->User_activity->user_login($uid, $pwd);
		}
		if($isajax!="ajax"){
			redirect(base_url());
			exit();
		}
		echo $ret;
	}	
	
	function password($isajax=""){
		$ret = "";
		if(strtolower($_SERVER['REQUEST_METHOD'])!="post") $ret = "NO";
		if($ret==""){
			$this->load->model('master/user_act');
			$ret = $this->user_act->ubahpassword($isajax);
		}
		if($isajax!="ajax"){
			redirect(base_url());
			exit();
		}
		echo $ret;
	}
	
	
	function data($isajax=""){
		$ret = "";
		if(strtolower($_SERVER['REQUEST_METHOD'])!="post") $ret = "NO";
		if($ret==""){
			$this->load->model('master/user_act');
			$ret = $this->user_act->ubahprofil($isajax);
		}
		if($isajax!="ajax"){
			redirect(base_url());
			exit();
		}
		echo $ret;
	}
	
}

?>