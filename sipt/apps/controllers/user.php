<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends Controller{
	
	function User(){
		parent::Controller();
	}
	
	function index(){
		redirect(base_url());
		exit();
	}
	
	function savepassword($isajax){
		if($this->newsession->userdata('logged_in')==TRUE){
			if(md5($this->input->post('plama'))==$this->newsession->userdata('SESS_PASS')){
				$arrpwd = array('PASSWORD' => md5($this->input->post('pbaru')));
				$this->db->where('USER_ID', $this->newsession->userdata('SESS_USER_ID'));
				if($this->db->update('T_USER', $arrpwd)){
					if($isajax!="ajax"){
						redirect(site_url()."/home/password");
						exit();
					}
					return "YES";
				}
			}
			if($isajax!="ajax"){
				redirect(site_url().'/home/password');
				exit();
			}
			return "NO";
		}else{
			redirect(base_url());
			exit();
		}
	}
	
	function update($id, $isajax=""){
		$id = $this->newsession->userdata("SESS_USER_ID");
		$isajax = $this->uri->segment(3, "");
		if(strtolower($_SERVER['REQUEST_METHOD'])!="post" || !$this->newsession->userdata('logged_in')==TRUE){
			redirect(base_url());
			exit();
		}else{
			$this->load->model('master/user_act');
			$ret = $this->user_act->update($id, $isajax);
		}
		if($isajax!="ajax"){
			redirect(site_url().'/home/profil');
			exit();
		}
		echo $ret;
	}

}

?>