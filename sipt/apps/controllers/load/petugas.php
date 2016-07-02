<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Petugas extends Controller{
	
	function Petugas(){
		parent::Controller();
	}
	
	function index(){
	  	$this->fungsi->redirectMessage('Maaf anda tidak bisa mengakses halaman ini.','/home');
	}
	
	function get_petugas($periksa_id=""){
		if($periksa_id==""){
			$tabel = $this->sess_petugas();
		}else{
			$periksa_id = join(",", explode(".",$periksa_id));
			$query = "SELECT A.NOMOR AS [Nomor Surat Tugas], CONVERT(VARCHAR(10), A.TANGGAL, 103) AS [Tanggal Surat], B.NAMA_USER AS [Nama Petugas], C.NAMA_BBPOM AS [Balai / Badan] FROM T_SURAT_TUGAS A LEFT JOIN T_SURAT_TUGAS_PETUGAS D ON A.SURAT_ID = D.SURAT_ID LEFT JOIN T_USER B ON B.USER_ID = D.USER_ID LEFT JOIN M_BBPOM C ON C.BBPOM_ID = B.BBPOM_ID WHERE A.SURAT_ID IN ($periksa_id)";
			$this->load->library('newtable');
			$this->newtable->search(array(array('', '')));
			$this->newtable->action(site_url());
			$this->newtable->cidb($this->db);
			$this->newtable->ciuri($this->uri->segment_array());
			$this->newtable->orderby("Nama Petugas");
			$this->newtable->keys("Nama Petugas");
			$this->newtable->rowcount("ALL");
			$this->newtable->show_chk(FALSE);
			$this->newtable->show_search(FALSE);
			$tabel = $this->newtable->generate($query);
		}
		echo $tabel;
	}
	
	function sess_petugas(){
		$BBPOM = $this->session->userdata('BBPOM');
		$SURAT = $this->session->userdata('SURAT');
		$str = '<table class="tabelajax"><tr class="head"><th>Nomor Surat</th><th>Tanggal Surat</th><th>Petugas</th><th>Badan / Balai</th></tr>';
		for($i=0;$i<count($BBPOM['NAMA']);$i++){
			foreach($BBPOM['NAMA'][$i] as $a => $b){
				$str .= '<tr><td>'.$SURAT['NOMOR'][$i].'</td><td>'.$SURAT['TANGGAL'][$i].'</td><td>'.$b.'</td><td>'.$BBPOM['MBBPOM_ID'][$i].'</td></tr>';
			}
		}
		$str .= '</table>';
		return $str;
	}	
	
	function set_kinerja($jenis="", $nip=""){
		if($this->newsession->userdata('LOGGED_IN') == "TRUE"){
			$this->load->model('master/petugas_act');
			$arrdata = $this->petugas_act->list_kinerja($jenis="", $nip="");
			$ret = $this->load->view('ajax', $arrdata, true);		
			echo $ret;
		}
	}
	
//	Pengawasan Iklan dan Penandaan
	
	function get_petugas_2($periksa_id = "", $tabel = "") {
		if ($periksa_id == "") {
		  $tabel = $this->sess_petugas_2();
		} else {
		  $query = "SELECT TU.NAMA_USER AS 'Nama Petugas', A.NOMOR_SURAT AS [Nomor Surat Tugas], CONVERT(VARCHAR(10), A.TANGGAL, 120) AS [Tanggal Surat], MB.NAMA_BBPOM AS [Badan / Balai] FROM $tabel A RIGHT JOIN T_USER TU ON TU.USER_ID  = A.PETUGAS LEFT JOIN M_BBPOM MB ON MB.BBPOM_ID  = TU.BBPOM_ID WHERE A.SURAT_ID IN ($periksa_id)";
		  $this->load->library('newtable');
		  $this->newtable->search(array(array('', '')));
		  $this->newtable->action(site_url());
		  $this->newtable->cidb($this->db);
		  $this->newtable->ciuri($this->uri->segment_array());
		  $this->newtable->orderby("PETUGAS");
		  $this->newtable->keys("PETUGAS");
		  $this->newtable->rowcount("ALL");
		  $this->newtable->show_chk(FALSE);
		  $this->newtable->show_search(FALSE);
		  $tabel = $this->newtable->generate($query);
		}
		echo $tabel;
	}

	function sess_petugas_2() {
		$BBPOM = $this->session->userdata('BBPOM');
		$SURAT = $this->session->userdata('SURAT');
		$TANGGAL = $this->session->userdata('TANGGAL');
		$str = '<table class="tabelajax"><tr class="head"><th>Nama Petugas</th><th>Nomor Surat Tugas</th><th>Tanggal Surat</th><th>Badan / Balai</th></tr>';
		for ($i = 0; $i < count($BBPOM['NAMA']); $i++) {
		  foreach ($BBPOM['NAMA'][$i] as $a => $b) {
			$str .= '<tr><td>' . $b . '</td><td>' . $SURAT . '</td><td>' . $TANGGAL . '</td><td>' . $BBPOM['MBBPOM_ID'][$i] . '</td></tr>';
		  }
		}
		$str .= '</table>';
		return $str;
	}

}
?>