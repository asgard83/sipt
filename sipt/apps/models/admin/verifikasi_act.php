<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);
class Verifikasi_act extends Model{

	function list_verifikasi(){
		if(array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('10', $this->newsession->userdata('SESS_KODE_ROLE')) || $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$this->load->library('newtable');
			$this->newtable->hiddens(array('PELAPORAN_ID','ROLE_ID','SEBELUM','PROSES','SESUDAH'));
			$this->newtable->search(array(array('J.URAIAN', 'Berdasarkan Jenis Pelaporan'), array('R.URAIAN', 'Berdasarkan Role')));
			$query = "SELECT V.PELAPORAN_ID, V.ROLE_ID, V.SEBELUM, V.PROSES, V.SESUDAH, 
J.URAIAN AS [JENIS PELAPORAN], R.URAIAN AS [ROLE], REPLACE(B.URAIAN,' - ', '<div>') AS [DOKUMEN SEBELUM PROSES], REPLACE(P.URAIAN, ':', '') AS [PROSES VERIFIKASI], REPLACE(A.URAIAN, ' - ', '<div>') AS [DOKUMEN SESUDAH PROSES] FROM M_VERIFIKASI V LEFT JOIN M_TABEL J ON V.PELAPORAN_ID = J.KODE LEFT JOIN M_TABEL R ON V.ROLE_ID = R.KODE LEFT JOIN M_TABEL B ON V.SEBELUM = B.KODE LEFT JOIN M_TABEL P ON V.PROSES = P.KODE LEFT JOIN M_TABEL A ON V.SESUDAH = A.KODE WHERE J.JENIS = 'JENIS_PELAPORAN' AND R.JENIS = 'ROLE' AND B.JENIS = 'STATUS' AND P.JENIS = 'PROSES' AND A.JENIS = 'STATUS'";	
			$this->newtable->columns(array("V.PELAPORAN_ID","V.ROLE_ID","V.SEBELUM","V.PROSES","V.SESUDAH","J.URAIAN","R.URAIAN","REPLACE(B.URAIAN,' - ', '<div>')","REPLACE(P.URAIAN, ':', '')","REPLACE(A.URAIAN, ' - ', '<div>')"));
			$this->newtable->width(array('JENIS PELAPORAN' => 100, 'ROLE' => 75, 'DOKUMEN SEBELUM PROSES' => 200, 'PROSES VERIFIKASI' => 105, 'DOKUMEN SESUDAH PROSES' => 200));
			$proses['Tambah Proses Verifikasi'] = array('GET', site_url()."/home/master/pverifikasi/new", '0');
			$proses['Edit Proses Verifikasi'] = array('GET', site_url()."/home/master/pverifikasi/new", '1');
			$proses['Hapus Proses Verifikasi'] = array('POST', site_url()."/post/master/verifikasi/hapus/ajax", 'N');
			$this->newtable->action(site_url()."/home/master/pverifikasi");
			$this->newtable->cidb($this->db);
			$this->newtable->ciuri($this->uri->segment_array());
			$this->newtable->orderby(2);
			$this->newtable->sortby("ASC");
			$this->newtable->keys(array('PELAPORAN_ID','ROLE_ID','SEBELUM','PROSES','SESUDAH'));
			$this->newtable->menu($proses);
			$tabel = $this->newtable->generate($query);
			$arrdata = array('table' => $tabel,
							 'idjudul' => 'judulpetugas',
							 'caption_header' => 'Data Master Verifikasi Dokumen',
							 'batal' => '',
							 'cancel' => '');
			return $arrdata;
		}else{
			$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
		}
	}

	function get_verifikasi($id){
		if(array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('10', $this->newsession->userdata('SESS_KODE_ROLE')) || $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$sipt->load->model("main", "main", true);
			$jenis_pelaporan = $sipt->main->combobox("SELECT KODE, URAIAN FROM M_TABEL WHERE JENIS = 'JENIS_PELAPORAN' AND KODE NOT IN ('00')", "KODE", "URAIAN", TRUE);
			$role = $sipt->main->combobox("SELECT KODE, URAIAN FROM M_TABEL WHERE JENIS = 'ROLE' AND KODE NOT IN ('1','9','10')", "KODE", "URAIAN", TRUE);
			$sebelum = $sipt->main->combobox("SELECT KODE, URAIAN FROM M_TABEL WHERE JENIS = 'STATUS' AND LEN(KODE) > 3 ORDER BY KODE ASC", "KODE", "URAIAN", TRUE);
			$proses = $sipt->main->combobox("SELECT KODE, URAIAN FROM M_TABEL WHERE JENIS = 'PROSES'", "KODE", "URAIAN", TRUE);
			$sesudah = $sipt->main->combobox("SELECT KODE, URAIAN FROM M_TABEL WHERE JENIS = 'STATUS' AND LEN(KODE) > 3 ORDER BY KODE ASC", "KODE", "URAIAN", TRUE);
			
			if($id==""){
				$arrdata = array('act' => site_url().'/post/master/verifikasi/simpan',				
								 'batal' => site_url().'/home/master/pverifikasi',
								 'id' => '',
								 'sess' => '',
								 'save' => 'Simpan',
								 'cancel' => 'Batal');
			}else{
				$id = explode(".", $id);
				$query = "SELECT PELAPORAN_ID, ROLE_ID, SEBELUM, PROSES, SESUDAH FROM M_VERIFIKASI WHERE PELAPORAN_ID = '$id[0]' AND ROLE_ID = '$id[1]' AND SEBELUM = '$id[2]' AND PROSES = '$id[3]' AND SESUDAH = '$id[4]'";
				$data = $sipt->main->get_result($query);
				if($data){
					foreach($query->result_array() as $row){
						$arrdata = array('sess' => $row,
										 'act' => site_url().'/post/master/verifikasi/update',
										 'batal' => site_url().'/home/master/pverifikasi',
										 'id' => join(".",$id),
										 'save' => 'Update',
										 'cancel' => 'Kembali');
					}
				}
			}
			$arrdata['jenis_pelaporan'] = $jenis_pelaporan;
			$arrdata['role'] = $role;
			$arrdata['sebelum'] = $sebelum;
			$arrdata['proses'] = $proses;
			$arrdata['sesudah'] = $sesudah;
			return $arrdata;
		}else{
			$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
		}
	}
	
	function set_verifikasi($action, $isajax){
		if(array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('10', $this->newsession->userdata('SESS_KODE_ROLE')) || $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main","main", true);
			if($action=="simpan"){
				foreach($this->input->post('VERIFIKASI') as $a => $b){
					$verifikasi[$a] = $b;
				}
				if($this->db->insert('M_VERIFIKASI', $verifikasi)) return "MSG#YES#Data berhasil disimpan#".site_url().'/home/master/pverifikasi';
				if($isajax!="ajax"){
					redirect(site_url().'/home/master/pverifikasi');
					exit();
				}
			}
			else if($action=="update"){
				$id = explode(".", $this->input->post('ID'));
				foreach($this->input->post('VERIFIKASI') as $a => $b){
					$verifikasi[$a] = $b;
				}
				$this->db->where(array("PELAPORAN_ID" => $id[0], "ROLE_ID" => $id[1], "SEBELUM" => $id[2], "PROSES" => $id[3], "SESUDAH" => $id[4]));
				if($this->db->update('M_VERIFIKASI', $verifikasi))return "MSG#YES#Data berhasil disimpan#".site_url().'/home/master/pverifikasi';
				if($isajax!="ajax"){
					redirect(base_url());
					exit();
				}
			}
			else if($action=="hapus"){
				$ret = "MSG#Hapus Pejabat Gagal.";
				foreach($this->input->post('tb_chk') as $chkitem){
					$id = explode(".", $chkitem);
					$this->db->where(array("PELAPORAN_ID" => $id[0], "ROLE_ID" => $id[1], "SEBELUM" => $id[2], "PROSES" => $id[3], "SESUDAH" => $id[4]));
					if($this->db->delete('M_VERIFIKASI')) $ret = "MSG#Hapus Proses Verifikasi Berhasil.#".site_url().'/home/master/pverifikasi';
				}
				if($isajax!="ajax"){
					redirect(base_url());
					exit();			  
				}
				return $ret;
			}
		}
		
		else{
			$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
		}		
	}
	
}
?>