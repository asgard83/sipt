<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);

class User_act extends Model{
	
	function getFormProfil(){
		if($this->newsession->userdata('LOGGED_IN')==TRUE){
			$id = $this->newsession->userdata("SESS_USER_ID");
			$sipt =& get_instance();
			$sipt->load->model("main", "main", true);
			$query = "SELECT * FROM T_USER WHERE USER_ID='$id'";
			if($sipt->main->get_result($query)){
				$row = $query->row();
				$arrdata["act"] = site_url().'/login/data';
				$arrdata["nama"] = $row->NAMA_USER;
				$arrdata["jabatan"] = $row->JABATAN;
				$arrdata["email"] = $row->EMAIL;
				$arrdata["batal"] = site_url().'/home/user/profil';
		}
		return $arrdata;
		}else{
			$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
		}
	}
	
	function ubahpassword($isajax){
		if($this->newsession->userdata('LOGGED_IN')){
			if($this->input->post('pwd') != $this->input->post('kpwd')){
				return "MSG#NO#Ubah profil gagal#".site_url()."/home/user/password";
			}
			$arrpwd = array('PASSWORD' => md5($this->input->post('pwd')));
			$this->db->where('USER_ID', $this->newsession->userdata('SESS_USER_ID'));
			if($this->db->update('T_USER', $arrpwd)){
				if($isajax!="ajax"){
					redirect(base_url());
					exit();
				}
				return "MSG#YES#Ubah Password Berhasil#".site_url()."/home/user/password";
			}
			if($isajax!="ajax"){
				redirect(base_url());
				exit();
			}
			return "MSG#NO#Ubah profil gagal";
		}else{
			redirect(base_url());
			exit();
		}
	}
	
	function ubahprofil($isajax){
		if($this->newsession->userdata('LOGGED_IN')){
			$arrdata = array('NAMA_USER' => $this->input->post('nama'),
							 'JABATAN' => $this->input->post('jabatan'),
							 'EMAIL' => $this->input->post('email'));
			$this->db->where('USER_ID', $this->newsession->userdata('SESS_USER_ID'));
			if($this->db->update('T_USER', $arrdata)){
				if($isajax!="ajax"){
					redirect(base_url());
					exit();
				}
				return "MSG#YES#Ubah Profil Berhasil#".site_url()."/home/user/profil";
			}
			if($isajax!="ajax"){
				redirect(base_url());
				exit();
			}
			return "MSG#NO#Ubah profil gagal#".site_url()."/home/user/profil";
		}else{
			redirect(base_url());
			exit();
		}
	}


}

?>