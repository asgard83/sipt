<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);

class Pejabat_act extends Model{
	function list_pejabat($id){
		if($this->newsession->userdata('LOGGED_IN') || array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('10', $this->newsession->userdata('SESS_KODE_ROLE'))){
			$this->load->library('newtable');			
			$proses['Pejabat Baru'] = array('GET', site_url()."/home/pejabat/new", '0');
			$proses['Edit Pejabat'] = array('GET', site_url()."/home/pejabat/new", '1');
			$proses['Hapus Pejabat'] = array('POST', site_url()."/post/master/pejabat/hapus/ajax", 'N');
			$this->newtable->search(array(array('NIP', 'NIP Pejabat'), array('NAMA', 'Nama Pejabat')));
			$query = "SELECT NIP, NAMA, JABATAN FROM M_PEJABAT";
			$this->newtable->columns(array("NIP", "NAMA","JABATAN"));
			$this->newtable->hiddens(array(''));
			$this->newtable->action(site_url()."/home/pejabat/list");
			$this->newtable->cidb($this->db);
			$this->newtable->ciuri($this->uri->segment_array());
			$this->newtable->orderby(2);
			$this->newtable->sortby("ASC");
			$this->newtable->keys(array('NIP'));
			$this->newtable->menu($proses);
			$tabel = $this->newtable->generate($query);
			$arrdata = array('table' => $tabel,
							 'idjudul' => 'judulpetugas',
							 'caption_header' => 'Data Pejabat Penanda Tangan',
							 'batal' => '',
							 'cancel' => '');
			return $arrdata;
		}else{
			$this->fungsi->redirectMessage('Maaf, anda tidak berhak mengakses halaman ini.','/home');
		}
	}
	
	function get_pejabat($id){
		if($this->newsession->userdata('LOGGED_IN') || array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('10', $this->newsession->userdata('SESS_KODE_ROLE'))){
			$sipt =& get_instance();
			$this->load->model("main","main", true);
			if($id==""){
				$arrdata = array('sess' => '',
								 'header' => 'Tambah Pejabat Penanda Tangan Baru',
								 'act' => site_url().'/post/master/save/pejabat/simpan',
								 'batal' => site_url().'/home/pejabat/list',
								 'save' => 'Simpan',
								 'cancel' => 'Batal');
			}else{
				$query = "SELECT NIP, NAMA, JABATAN FROM M_PEJABAT WHERE NIP = '".$id."'";
				$data = $sipt->main->get_result($query);
				if($data){
					foreach($query->result_array() as $row){						
						$arrdata = array('sess' => $row,
										 'header' => 'Update Pejabat Penanda Tangan Baru',
										 'act' => site_url().'/post/master/save/pejabat/update',
										 'batal' => site_url().'/home/pejabat/list',
										 'save' => 'Update',
										 'cancel' => 'Batal');
					}
				}
			}
			return $arrdata;
		}else{
			$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
		}
	}
	
	
	function SavePejabat($setaction, $isajax){
		if($this->newsession->userdata('LOGGED_IN') || array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('10', $this->newsession->userdata('SESS_KODE_ROLE'))){
			$sipt =& get_instance();
			$this->load->model("main","main", true);
			if($setaction=="simpan"){
				foreach($this->input->post('PEJABAT') as $a => $b){
					$arrpejabat[$a] = $b;
				}	
				$inv_pejabat = (int)$sipt->main->get_uraian("SELECT COUNT(*) AS INVALID FROM M_PEJABAT WHERE NIP = '".$arrpejabat['NIP']."'", "INVALID");
				if($inv_pejabat > 0) return "MSG#NO#NIP Pejabat Sudah Ada.#";
				if($this->db->insert('M_PEJABAT', $arrpejabat)) return "MSG#YES#Data berhasil disimpan#".site_url().'/home/pejabat/list';
				if($isajax!="ajax"){
					redirect(site_url().'/home/pejabat/list');
					exit();
				}
			}
			else if($setaction=="update"){
				$id = $this->input->post('NIP');
				foreach($this->input->post('PEJABAT') as $a => $b){
					$arrpejabat[$a] = $b;
				}	
				$this->db->where(array("NIP" => $id));
				if($this->db->update('M_PEJABAT', $arrpejabat))return "MSG#YES#Data berhasil disimpan#".site_url().'/home/pejabat/list';
				if($isajax!="ajax"){
					redirect(base_url());
					exit();
				}
			}else if($setaction=="hapus"){
				$ret = "MSG#Hapus Pejabat Gagal.";
				foreach($this->input->post('tb_chk') as $chkitem){
					$this->db->where('NIP', $chkitem);
					if($this->db->delete('M_PEJABAT')) $ret = "MSG#Hapus Pejabat Berhasil.#".site_url().'/home/pejabat/list';
				}
				if($isajax!="ajax"){
					redirect(base_url());
					exit();			  
				}
				return $ret;
			}
			
			if($isajax!="ajax"){
				redirect(site_url().'/home/pejabat/list');
				exit();
			}
			return "MSG#NO#Data gagal disimpan";
		}
		else{
			$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
		}
	}
	
}
?>