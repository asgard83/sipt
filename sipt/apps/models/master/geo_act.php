<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);

class Geo_act extends Model{

	function list_negara(){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$this->load->library('newtable');
			$this->newtable->hiddens(array(''));
			$this->newtable->search(array(array('KODE_NEGARA', 'Berdasarkan Kode Negara'), array('URAIAN_NEGARA', 'Berdasarkan Nama Negara')));
			$this->newtable->action(site_url()."/home/master/negara");
			$this->newtable->cidb($this->db);
			$this->newtable->ciuri($this->uri->segment_array());
			$this->newtable->orderby("KODE_NEGARA ASC");
			$this->newtable->show_chk(FALSE);
			$query = "SELECT KODE_NEGARA AS [KODE NEGARA], URAIAN_NEGARA AS [NAMA NEGARA] FROM M_NEGARA";							
			$tabel = $this->newtable->generate($query);
			$arrdata = array('table' => $tabel,
							 'idjudul' => 'judulnegara',
							 'caption_header' => 'Master Negara',
							 'batal' => '',
							 'cancel' => '');
			return $arrdata;
		}else{
			$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
		}
	}

	function list_daerah(){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$this->load->library('newtable');
			$this->newtable->hiddens(array(''));
			$this->newtable->search(array(array('PROPINSI_ID', 'Berdasarkan Kode'), array('NAMA_PROPINSI', 'Berdasarkan Kota / Kabupaten')));
			$this->newtable->action(site_url()."/home/master/daerah");
			$this->newtable->cidb($this->db);
			$this->newtable->ciuri($this->uri->segment_array());
			$this->newtable->orderby(1);
			$this->newtable->sortby("ASC");
			$this->newtable->keys(array('KODE'));
			$proses = array('Tambah Kabupaten / Kota' => array('GET', site_url()."/home/master/daerah/new", '0'), 'Edit Kabupaten / Kota' => array('GET', site_url()."/home/master/daerah/new", '1'),'Hapus Kabupaten / Kota' => array('POST', site_url()."/post/master/save/daerah/delete/ajax", 'N'));
			$this->newtable->menu($proses);
			$prop = substr($this->newsession->userdata('SESS_PROP_ID'),0,2);
			if($this->newsession->userdata('SESS_BBPOM_ID') != '00'){
				if($this->newsession->userdata('SESS_PROP_ID') == '7100'){
					$str_prop1 = substr('7100',0,2);
					$str_prop2 = substr('8200',0,2);
					$query = "SELECT PROPINSI_ID AS [KODE], NAMA_PROPINSI AS [NAMA PROPINSI] FROM M_PROPINSI WHERE (RIGHT(PROPINSI_ID, 2) != '00') AND PROPINSI_ID LIKE '$str_prop1%' OR PROPINSI_ID LIKE '$str_prop2%' AND (RIGHT(PROPINSI_ID, 2) != '00')";
				}else if($this->newsession->userdata('SESS_PROP_ID') == '7300'){
					$str_prop1 = substr('7300',0,2);
					$str_prop2 = substr('7600',0,2);
					$query = "SELECT PROPINSI_ID AS [KODE], NAMA_PROPINSI AS [NAMA PROPINSI] FROM M_PROPINSI WHERE (RIGHT(PROPINSI_ID, 2) != '00') AND PROPINSI_ID LIKE '$str_prop1%' OR PROPINSI_ID LIKE '$str_prop2%' AND (RIGHT(PROPINSI_ID, 2) != '00')";
				}else{
					$query = "SELECT PROPINSI_ID AS [KODE], NAMA_PROPINSI AS [KOTA / KABUPATEN] FROM M_PROPINSI WHERE PROPINSI_ID LIKE '$prop%' AND PROPINSI_ID NOT IN ('".$this->newsession->userdata('SESS_PROP_ID')."')";			
				}				
			}else{
				$this->newtable->detail(site_url()."/load/master/set_detil/daerah");
				$query = "SELECT PROPINSI_ID AS [KODE], NAMA_PROPINSI AS [NAMA PROPINSI] FROM M_PROPINSI WHERE (RIGHT(PROPINSI_ID, 2) = '00')";
			}			
			
			$this->newtable->columns(array("PROPINSI_ID","NAMA_PROPINSI"));
			$tabel = $this->newtable->generate($query);
			$arrdata = array('table' => $tabel,
							 'idjudul' => 'juduldaerah',
							 'caption_header' => 'Master Daerah',
							 'batal' => '',
							 'cancel' => '');
			return $arrdata;
		}else{
			$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
		}
	}
	
	function get_daerah($id){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$sipt->load->model("main", "main", true);
			if(!in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')))
				$prop = substr($this->newsession->userdata('SESS_PROP_ID'),0,2);
			else 
				$prop = "";				
			if($id==""){
				  $arrdata = array('sess' => '',
								   'act' => site_url().'/post/master/save/daerah/simpan',
								   'batal' => site_url().'/home/master/daerah',
								   'id' => '',
								   'prop' => $prop,
								   'save' => 'Simpan',
								   'cancel' => 'Batal');
			}else{
				$query = "SELECT PROPINSI_ID, NAMA_PROPINSI FROM M_PROPINSI WHERE PROPINSI_ID = '$id'";
				$data = $sipt->main->get_result($query);
				if($data){
					foreach($query->result_array() as $row){
						$arrdata = array('sess' => $row,
										 'act' => site_url().'/post/master/save/daerah/update',
										 'batal' => site_url().'/home/master/daerah',
										 'id' => $row['PROPINSI_ID'],
										 'save' => 'Update',
										 'cancel' => 'Kembali');
					}
				}

			}
			return $arrdata;
		}else{
			$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
		}
	}
	
	function SaveDaerah($setaction, $isajax){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main","main", true);
			if($setaction=="simpan"){#Insert Mode
				foreach($this->input->post('DAERAH') as $a => $b){
					$arrdaerah[$a] = $b;
				}	
				$inv_daerah = (int)$sipt->main->get_uraian("SELECT COUNT(*) AS INVALID FROM M_PROPINSI WHERE PROPINSI_ID = '".$arrdaerah['PROPINSI_ID']."'", "INVALID");
				if($inv_daerah > 0) return "MSG#NO#Kode Propinsi / Kota / Kabupaten Telah Ada.#";
				if($this->db->insert('M_PROPINSI', $arrdaerah)) return "MSG#YES#Data berhasil disimpan#".site_url().'/home/master/daerah';
				if($isajax!="ajax"){
					redirect(base_url());
					exit();
				}
			}
			else if($setaction=="update"){#Update Mode
				$id = $this->input->post('ID');
				foreach($this->input->post('DAERAH') as $a => $b){
					$arrdaerah[$a] = $b;
				}	
				$this->db->where(array("PROPINSI_ID" => $id));
				if($this->db->update('M_PROPINSI', $arrdaerah))return "MSG#YES#Data berhasil disimpan#".site_url().'/home/master/daerah';
				if($isajax!="ajax"){
					redirect(base_url());
					exit();
				}
			}else if($setaction=="delete"){#Delete Mode
				$ret = "MSG#Hapus Kabupaten / Kota Gagal.";
				foreach($this->input->post('tb_chk') as $chkitem){
					$this->db->where('PROPINSI_ID', $chkitem);
					if($this->db->delete('M_PROPINSI')) $ret = "MSG#Hapus Kabupaten / Kota.#";
				}
				if($isajax!="ajax"){
					redirect(base_url());
					exit();			  
				}
				return $ret;
			}
			
			if($isajax!="ajax"){
				redirect(site_url().'/home/master/daerah');
				exit();
			}
			return "MSG#NO#Data gagal disimpan";
		}
		else{
			$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
		}
	}
	
	
	function detil_daerah($id){
		$id = substr($id, 0, 2);
		$query = "SELECT PROPINSI_ID AS [KODE], NAMA_PROPINSI AS [KOTA / KABUPATEN] FROM M_PROPINSI WHERE PROPINSI_ID LIKE '$id%' AND RIGHT(PROPINSI_ID, 2) <> '00'";
		$this->load->library('newtable');
		$this->newtable->search(array(array('', '')));
		$this->newtable->action(site_url());
		$this->newtable->cidb($this->db);
		$this->newtable->ciuri($this->uri->segment_array());
		$this->newtable->orderby("PROPINSI_ID ASC");
		$this->newtable->rowcount("ALL");
		$this->newtable->show_chk(FALSE);
		$this->newtable->show_search(FALSE);
		$tabel = $this->newtable->generate($query);
		return $tabel;	
	}


}
?>