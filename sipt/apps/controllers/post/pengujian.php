<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pengujian extends Controller{
	
	function Pengujian(){
		parent::Controller();
	}
	
	function index(){
	  	$this->fungsi->redirectMessage('Maaf anda tidak bisa mengakses halaman ini.','/home');
	}
	
	function set_all($isajax = ""){
		if(strtolower($_SERVER['REQUEST_METHOD'])!="post"){
			redirect(base_url());
			exit();
		}else{
			$sipt =& get_instance();
			$sipt->load->model("main", "main", true);
			$pelaporan = "'".join("', '", array_keys($this->newsession->userdata('SESS_JENIS_PELAPORAN')))."'";
			$role = "'".join("', '", array_keys($this->newsession->userdata('SESS_KODE_ROLE')))."'";
			$src = "<form id=\"fset_all\" action=\"".site_url()."/post/pemeriksaan/all_checked/all/ajax\">";
			$src .= "<div><b>Kirim Data Terpilih</b></div>";
			$src .= "<ul style=\"list-style:decimal; margin-left:17px;\">";
			foreach($this->input->post('tb_chk') as $a){
				$split_uri = explode("/", $a);
				$id_uri = explode(".", $split_uri[3]);
				if(array_key_exists('6', $this->newsession->userdata('SESS_KODE_ROLE')))
				$next = "60020";
				else
				$next = $sipt->main->get_uraian("SELECT SESUDAH FROM M_VERIFIKASI WHERE PELAPORAN_ID IN($pelaporan) AND ROLE_ID IN($role) AND SEBELUM IN('".$id_uri[1]."') AND PROSES = '1'","SESUDAH"); 
				$src .= "<li>".$sipt->main->get_uraian("SELECT NAMA_SARANA FROM M_SARANA WHERE SARANA_ID ='".$split_uri[0]."'","NAMA_SARANA")."<input type=\"hidden\" name=\"PERIKSA_ID[]\" value=\"".$id_uri[0]."\"></li>";
			}
			$src .= "</ul>";
			$src .= "<div style=\"padding-top:5px;\"><b>Mengirim Ke : ".$sipt->main->get_uraian("SELECT URAIAN FROM M_TABEL WHERE JENIS = 'STATUS' AND KODE = '".$next."'","URAIAN")."</b></div>";
			$src .= "<div style=\"padding-top:5px;\">Catatan :</div>";
			$src .= "<div style=\"padding-top:5px;\"><textarea class=\"stext catatan\" rel=\"required\" name=\"CATATAN\"></textarea></div>";
			$src .= "<div style=\"padding-top:5px;\"><a href=\"#\" class=\"button check\" id=\"set_all\"><span><span class=\"icon\"></span>&nbsp; Proses &nbsp;</span></a></div>";
			$src .= "<input type=\"hidden\" name=\"HASIL\" value=\"".$next."\">";
			$src .= "</form";
			echo $src;
		}
	}
	
	function all_checked($action="",$isajax=""){
		if(strtolower($_SERVER['REQUEST_METHOD'])!="post"){
			redirect(base_url());
			exit();
		}else{
			$this->load->model('pemeriksaan/pemeriksaan_act');
			$ret = $this->pemeriksaan_act->set_kirim($action, $isajax);
		}
		echo $ret;
	}
	
}
?>