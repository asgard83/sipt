<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Distribusi extends Controller{
	
	function Distribusi(){
		parent::Controller();
	}
	
	function index(){
	  	$this->fungsi->redirectMessage('Maaf anda tidak bisa mengakses halaman ini.','/home');
	}
	
	
	function list_pirt($sarana){
		$query = "SELECT SERI, JENIS, NAMA_JENIS AS [JENIS PANGAN], NO_PIRT AS [PIRT NO] FROM M_SARANA_JENIS_PANGAN WHERE SARANA_ID = $sarana";
		$this->load->library('newtable');
		$this->newtable->hiddens(array('SERI'));
		$this->newtable->search(array(array('', '')));
		$this->newtable->action(site_url());
		$this->newtable->cidb($this->db);
		$this->newtable->ciuri($this->uri->segment_array());
		$this->newtable->orderby("SERI");
		$this->newtable->keys("SERI");
		$this->newtable->rowcount("ALL");
		$this->newtable->show_chk(FALSE);
		$this->newtable->show_search(FALSE);
		$tabel = $this->newtable->generate($query);
		echo $tabel;	
	}
	
	function set_panganmd($sarana, $ispreview){
		if($this->newsession->userdata('LOGGED_IN') == "TRUE"){
			$this->load->model("pemeriksaan/F01JJ");
			$data = $this->F01JJ->get_dataumum($sarana,$ispreview);
			$this->load->view('pemeriksaan/preview/01JJ/data_umum', $data);			  
		}
	}
		
	function set_jenis($jenis="",$sarana=""){
		if($jenis=="02PG"){
			$this->load->model('pemeriksaan/F02PG');
			$ret = $this->F02PG->get_jenis($sarana);
		}
		echo $ret;
	}
	
	function set_izin($jenis="", $sarana=""){
		$mdl = "F".$jenis;
		$this->load->model('pemeriksaan/'.$mdl);
		$ret = $this->$mdl->get_izin($sarana);
		echo $ret;
	}
	
	function set_sertifikat($jenis="", $sarana){
		if($jenis=="01KO"){
			$this->load->model('pemeriksaan/F01KO');
			$ret = $this->F01KO->get_sertifikat($sarana);			
		}else if($jenis=="01HH"){
			$this->load->model('pemeriksaan/F01HH');
			$ret = $this->F01HH->get_sertifikat($sarana);			
		}else if($jenis=="01PK"){
			$this->load->model('pemeriksaan/F01PK');
			$ret = $this->F01PK->get_sertifikat($sarana);			
		}
		echo $ret;
	}
	
	
}


?>