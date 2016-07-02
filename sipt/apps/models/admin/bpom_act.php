<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR);
class Bpom_act extends Model{
	function list_bpom(){
		if(array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) && $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$this->load->library('newtable');
			$this->newtable->hiddens(array('BBPOM_ID'));
			$this->newtable->search(array(array('NAMA_BBPOM', 'Berdasarkan Nama BBPOM / BPOM'), array('TIPE', 'Berdasarkan Tipe Balai')));
			$query = "SELECT BBPOM_ID, REPLACE(REPLACE(NAMA_BBPOM,'BALAI BESAR POM DI ', ''),'BALAI POM DI ','') AS [BBPOM / BPOM], KODE_BALAI AS [KODE BALAI], TIPE AS [TIPE BALAI], ALAMAT_BALAI AS [ALAMAT], KOTA FROM M_BBPOM WHERE BBPOM_ID NOT IN ('00','91','92','93','94','95','96','99')";	
			$this->newtable->columns(array("BBPOM_ID","REPLACE(REPLACE(NAMA_BBPOM,'BALAI BESAR POM DI ', ''),'BALAI POM DI ','')", "KODE_BALAI","TIPE", "ALAMAT_BALAI", "KOTA"));
			$this->newtable->width(array('BBPOM / BPOM' => 250, 'KODE BALAI' => 75, 'TIPE BALAI' => 75, 'ALAMAT' => 400, 'KOTA' => 100));
			$proses['Edit Data Balai'] = array('GET', site_url()."/home/master/bpom/new", '1');
			$this->newtable->action(site_url()."/home/master/bpom");
			$this->newtable->cidb($this->db);
			$this->newtable->ciuri($this->uri->segment_array());
			$this->newtable->orderby(2);
			$this->newtable->sortby("ASC");
			$this->newtable->keys(array('BBPOM_ID'));
			$this->newtable->menu($proses);
			$tabel = $this->newtable->generate($query);
			$arrdata = array('table' => $tabel,
							 'idjudul' => 'judulpetugas',
							 'caption_header' => 'Data Master BBPOM / BPOM',
							 'batal' => '',
							 'cancel' => '');
			return $arrdata;
		}else{
			$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
		}
	}

	function get_bpom($id){
		if(array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) && $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$sipt->load->model("main", "main", true);
			$query = "SELECT * FROM M_BBPOM WHERE BBPOM_ID = '".$id."'";
			$data = $sipt->main->get_result($query);
			if($data){
				foreach($query->result_array() as $row){
					$arrdata = array('sess' => $row,
									 'act' => site_url().'/post/master/bpom/update',
									 'batal' => site_url().'/home/master/bpom',
									 'save' => 'Update',
									 'cancel' => 'Kembali');
				}
			}
			$arrdata['id'] = $id;
			$arrdata['tipe_balai'] = array("" => "", "A" => "Balai Tipe A", "B" => "Balai Tipe B"); 
			$arrdata['wilayah'] = $sipt->main->combobox("SELECT LTRIM(RTRIM(KODE)) AS KODE, URAIAN FROM M_TABEL WHERE JENIS = 'WILAYAH' ORDER BY KODE ASC", "KODE", "URAIAN", TRUE);
			return $arrdata;
		}else{
			$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
		}
	}
	
	function set_bpom($action, $isajax){
		if(array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('10', $this->newsession->userdata('SESS_KODE_ROLE')) || $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main","main", true);
			if($action=="update"){
				foreach($this->input->post('BBPOM') as $a => $b){
					$mbbpom[$a] = $b;
				}
				$this->db->where(array("BBPOM_ID" => $this->input->post('BBPOM_ID')));
				if($this->db->update('M_BBPOM', $mbbpom))return "MSG#YES#Data berhasil disimpan#".site_url().'/home/master/bpom';
				if($isajax!="ajax"){
					redirect(base_url());
					exit();
				}
			}
		}
		
		else{
			$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
		}		
	}
	
}
?>