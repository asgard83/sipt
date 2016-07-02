<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Master extends Controller{
	
	function Master(){
		parent::Controller();
	}
	
	function index(){
	  	$this->fungsi->redirectMessage('Maaf anda tidak bisa mengakses halaman ini.','/home');
	}
	
	function get_jenis_sarana($jenis,$id=""){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$this->load->model('master/sarana_act');
			$arrdata = $this->sarana_act->get_jenis($jenis, $id);
			$this->load->view('master/sarana/'.$jenis, $arrdata);
			return;
		}else{
			$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
		}
	}
	
	function list_sarana(){
		$this->load->library('newtable');
		if(in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))){	
			$query = "SELECT A.SARANA_ID,UPPER(A.NAMA_SARANA) AS [NAMA SARANA], A.ALAMAT_1 AS [ALAMAT], B.NAMA_PROPINSI AS KOTA, C.NAMA_PROPINSI AS PROPINSI FROM M_SARANA A LEFT JOIN M_PROPINSI B ON A.KOTA = B.PROPINSI_ID LEFT JOIN M_PROPINSI C ON A.PROPINSI = C.PROPINSI_ID";
			$this->newtable->columns(array("A.SARANA_ID", "UPPER(A.NAMA_SARANA)", "A.ALAMAT_1", "B.NAMA_PROPINSI", "C.NAMA_PROPINSI"));
		}else{
			if($this->newsession->userdata('SESS_PROP_ID') == '7100')
				$prop = "'7100','8200'";
			else
				$prop = "'".$this->newsession->userdata('SESS_PROP_ID')."'";			  
			$query = "SELECT A.SARANA_ID, UPPER(A.NAMA_SARANA) AS [NAMA SARANA], A.ALAMAT_1 AS [ALAMAT], B.NAMA_PROPINSI AS KOTA, C.NAMA_PROPINSI AS PROPINSI FROM M_SARANA A LEFT JOIN M_PROPINSI B ON A.KOTA = B.PROPINSI_ID LEFT JOIN M_PROPINSI C ON A.PROPINSI = C.PROPINSI_ID WHERE A.PROPINSI IN($prop)";
			$this->newtable->columns(array("A.SARANA_ID", "UPPER(A.NAMA_SARANA)", "A.ALAMAT_1", "B.NAMA_PROPINSI", "C.NAMA_PROPINSI"));
		}
		$this->newtable->hiddens(array('SARANA_ID'));
		$this->newtable->search(array(array('A.NAMA_SARANA', 'Berdasarkan Nama Sarana'), array('A.ALAMAT_1', 'Berdasarkan Alamat'), array('B.NAMA_PROPINSI', 'Berdasarkan Kota'), array('C.NAMA_PROPINSI', 'Berdasarkan Propinsi')));
		$this->newtable->action(site_url()."/load/master/list_sarana");
		$this->newtable->cidb($this->db);
		$this->newtable->ciuri($this->uri->segment_array());
		$this->newtable->orderby(5);
		$this->newtable->sortby("DESC");
		$this->newtable->keys(array('SARANA_ID','NAMA SARANA'));
		$tabel = $this->newtable->generate($query);		
		$arrdata = array('tabel' => $tabel, 'button' => TRUE, 'id' => 'proses_sarana');
		$this->load->view('master/browse', $arrdata);
	}
	
	function list_pelanggaran($jenis=""){
		$this->load->library('newtable');
		$this->newtable->hiddens(array('ASPEK','SERI'));
		$this->newtable->action(site_url()."/load/master/list_pelanggaran/$jenis");
		$this->newtable->cidb($this->db);
		$this->newtable->ciuri($this->uri->segment_array());
		$this->newtable->orderby(3);
		$this->newtable->sortby("ASC");
		$this->newtable->keys(array('ASPEK','SERI'));
		$this->newtable->search(array(array('B.NAMA_JENIS_SARANA', 'Berdasarkan Jenis Sarana'), array('A.URAIAN', 'Berdasarkan Aspek Pelanggaran'), array('C.JENIS_PELANGGARAN', 'Berdasarkan Jenis Pelanggaran'), array('C.JENIS_PENYIMPANGAN', 'Berdasarkan Jenis Penyimpangan'),array('C.JENIS_KRITERIA_PELANGGARAN', 'Berdasarkan Kriteria Pelanggaran')));
		$query = "SELECT C.ASPEK, C.SERI, REPLACE(B.NAMA_JENIS_SARANA,'(Pengawasan NAPZA)','') AS [JENIS SARANA], A.URAIAN AS [ASPEK PELANGGARAN], C.JENIS_PELANGGARAN+'<div>Jenis Penyimpangan : '+C.JENIS_PENYIMPANGAN+'</div><div>Kriteria Pelanggaran : '+C.JENIS_KRITERIA_PELANGGARAN AS [PELANGGARAN] FROM M_PELANGGARAN C LEFT JOIN M_TABEL A ON C.ASPEK = A.KODE LEFT JOIN M_JENIS_SARANA B ON C.JENIS_SARANA = B.JENIS_SARANA_ID WHERE A.JENIS = 'ASPEK_KTL' AND C.JENIS_SARANA = '$jenis'";
		$this->newtable->columns(array("C.ASPEK","C.SERI","REPLACE(B.NAMA_JENIS_SARANA,'(Pengawasan NAPZA)','')","A.URAIAN","C.JENIS_PELANGGARAN+'<div>Jenis Penyimpangan : '+C.JENIS_PENYIMPANGAN+'</div><div>Kriteria Pelanggaran : '+C.JENIS_KRITERIA_PELANGGARAN"));
		$tabel = $this->newtable->generate($query);
		$arrdata = array('tabel' => $tabel, 'button' => FALSE);
		$this->load->view('master/browse', $arrdata);
	}
	
	function list_prioritas($kategori, $prioritas){
		
		$this->load->library('newtable');
		
		$jmljabatan = (int) $this->db->query("SELECT DISTINCT(USER_ID), LEFT(SARANA_MEDIA_ID, 2) AS BID FROM T_USER_ROLE WHERE USER_ID = '" . $this->newsession->userdata('SESS_USER_ID') . "' GROUP BY USER_ID, SARANA_MEDIA_ID")->num_rows();
		if ($this->newsession->userdata('SESS_BBPOM_ID') != "99"){
			if (in_array('B1', $this->newsession->userdata('SESS_SUB_SARANA')) || in_array('B2', $this->newsession->userdata('SESS_SUB_SARANA'))) {#Bidang Kimia Fisika
				$bidang = " AND BIDANG_UJI = '02'";
			}else if(in_array('B3', $this->newsession->userdata('SESS_SUB_SARANA'))) {#Bidang Mikro
				$bidang = " AND BIDANG_UJI = '01'";
			}
		}else{
			if (in_array('B5', $this->newsession->userdata('SESS_SUB_SARANA'))) {#Bidang Mikrobiologi PPOMN
				$bidang = " AND BIDANG_UJI = '01'";
			}else{#Selain Bidang Mikrobiologi PPOMN
				$bidang = " AND BIDANG_UJI = '02'";
			}
		}
		
		
		$substr = $substr = substr($kategori, 0,4);
		if($substr == "0107"){
			$query = "SELECT SRL_ID, dbo.KATEGORI(GOLONGAN,'1') AS KATEGORI, PARAMETER_UJI, PUSTAKA, METODE, SYARAT FROM M_PRIORITAS WHERE LEFT(GOLONGAN,2) = '01' $bidang ";
		}else{
			$query = "SELECT SRL_ID, dbo.KATEGORI(GOLONGAN,'1') AS KATEGORI, PARAMETER_UJI, PUSTAKA, METODE, SYARAT FROM M_PRIORITAS WHERE GOLONGAN  = '".$kategori."' $bidang ";
		}
		$this->newtable->action(site_url()."/load/master/list_prioritas/$kategori/$prioritas");
		$this->newtable->cidb($this->db);
		$this->newtable->ciuri($this->uri->segment_array());
		$this->newtable->hiddens(array('SRL_ID'));
		
		$this->newtable->orderby(2);
		$this->newtable->sortby("ASC");
		$this->newtable->keys(array('SRL_ID'));
		
		$this->newtable->search(array(array("dbo.KATEGORI(GOLONGAN,'1')", 'Berdasarkan Kategori'), array('PARAMETER_UJI', 'Berdasarkan Parameter Uji'), array('PUSTAKA', 'Berdasarkan Pustaka'), array('METODE', 'Berdasarkan Metode'),array('SYARAT', 'Berdasarkan Syarat')));
		
		$this->newtable->columns(array("SRL_ID", "dbo.KATEGORI(GOLONGAN,'1')", "PARAMETER_UJI", "PUSTAKA", "METODE", "SYARAT"));
		
		$tabel = $this->newtable->generate($query);
		$arrdata = array('tabel' => $tabel, 'button' => TRUE, 'id' => 'capture_prioritas');
		$this->load->view('master/browse', $arrdata);
	}
	
	function set_detil($master="", $id="", $isPrev=TRUE){
		$sipt =& get_instance();
		$sipt->load->model("main", "main", true);	
		if($master=="sarana"){
			 $get_jenis = $sipt->main->get_uraian("SELECT JENIS_SARANA FROM M_SARANA WHERE SARANA_ID='$id'","JENIS_SARANA");
			 $this->load->model('master/sarana_act');
			 $data = $this->sarana_act->get_detil($id, $get_jenis);
			 $this->load->view('master/sarana/'.$get_jenis, $data);
		}else if($master=="produk"){
			 $this->load->model('master/produk_act');
			 $data = $this->produk_act->set_detil($id, $isPrev);
			 $this->load->view('master/produk_reg', $data);
		}else if($master=="petugas"){
			$this->load->model('master/petugas_act');
		    $data = $this->petugas_act->set_detil($id);
		    $this->load->view('master/detil_petugas', $data);
		}else if($master=="daerah"){
			$this->load->model('master/geo_act');
		    $ret = $this->geo_act->detil_daerah($id);
			echo $ret;
		}
		
	}
	
	
	
}
?>