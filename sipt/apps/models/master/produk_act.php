<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);

class Produk_act extends Model{
	var $db;
	
	function list_produk_web(){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$this->db = $this->load->database('registrasi', TRUE);
			$this->load->library('newtb');
			$this->newtb->hiddens(array('nomor_permohonan'));
			$this->newtb->search(array(array('nama_produk', 'Berdasarkan Nama Produk'),array('no_registrasi', 'Berdasarkan Nomor Registrasi'),array('kemasan', 'Berdasarkan Kemasan')));
			$this->newtb->action(site_url()."/home/master/web");
			$this->newtb->detail(site_url()."/load/master/set_detil/produk");
			$this->newtb->cidb($this->db);
			$this->newtb->ciuri($this->uri->segment_array());
			$this->newtb->keys(array('nomor_permohonan'));
			$this->newtb->orderby(3);
			$this->newtb->sortby("ASC");
			$this->newtb->columns(array("nomor_permohonan","no_registrasi","nama_produk","bentuk_sediaan","kemasan","indikasi"));				
			$this->newtb->width(array('NIE' => 100, 'BENTUK SEDIAAN' => 150, 'KEMASAN' => 150));
			foreach($this->newsession->userdata('SESS_KLASIFIKASI_ID') as $val){
				$kk[] = substr($val, 1, 2);
			}
			$klasifikasi = "'".join("','", $kk)."'";
			$query = "SELECT nomor_permohonan, no_registrasi AS [NIE], nama_produk AS [NAMA PRODUK], bentuk_sediaan AS [BENTUK SEDIAAN], kemasan AS KEMASAN FROM registrasi WHERE LEN(no_registrasi) <> '0' AND nama_produk IS NOT NULL AND kode_klasifikasi IN ($klasifikasi)";
			$tabel = $this->newtb->generate($query);
			$arrdata = array('table' => $tabel,
							 'idjudul' => 'judulmproduk',
							 'caption_header' => 'Master produk',
							 'batal' => '',
							 'cancel' => '');
			return $arrdata;
		}else{
			$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
		}
	}	
	
	function list_produk_lokal(){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$this->load->library('newtable');
			$this->newtable->hiddens(array('PRODUK_ID'));
			$this->newtable->action(site_url()."/home/master/lokal");
			$this->newtable->cidb($this->db);
			$this->newtable->ciuri($this->uri->segment_array());
			$this->newtable->keys(array('PRODUK_ID'));
			$this->newtable->orderby(3);
			$this->newtable->sortby("ASC");
			if(in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')) || $this->newsession->userdata('SESS_BBPOM_ID') == "00"){				
			  $this->newtable->search(array(array('A.NAMA_PRODUK', 'Berdasarkan Nama Produk'),array('A.NOMOR_REGISTRASI', 'Berdasarkan Nomor Registrasi'),array('A.KEMASAN', 'Berdasarkan Kemasan'),array('A.BENTUK_SEDIAAN', 'Berdasarkan Bentuk Sediaan'),array('B.NAMA_PROPINSI', 'Berdasarkan Nama Propinsi')));
			  $this->newtable->columns(array("A.PRODUK_ID", "A.NAMA_SARANA", "A.NAMA_PRODUK +'<div>A.NIE : '+A.NOMOR_REGISTRASI+'</div>' ", "'Kemasan : '+ A.KEMASAN + '<div>Bentuk Sediaan : '+A.BENTUK_SEDIAAN+'</div><div>Indikasi : '+A.INDIKASI+'</div>'", "'Label : '+ A.LABEL + '<div>Komposisi '+A.KOMPOSISI+'</div>'","B.NAMA_PROPINSI"));
				$query = "SELECT A.PRODUK_ID, A.NAMA_SARANA AS [NAMA SARANA], A.NAMA_PRODUK +'<div>NIE : '+A.NOMOR_REGISTRASI+'</div>' AS [NAMA PRODUK], 'Kemasan : '+ A.KEMASAN + '<div>Bentuk Sediaan : '+A.BENTUK_SEDIAAN+'</div><div>Indikasi : '+A.INDIKASI+'</div>' AS KEMASAN, 'Label : '+ A.LABEL + '<div>Komposisi '+A.KOMPOSISI+'</div>' AS KOMPOSISI, B.NAMA_PROPINSI AS PROPINSI FROM M_PRODUK A LEFT JOIN M_PROPINSI B ON A.PROPINSI = B.PROPINSI_ID";
			}else{
				$this->newtable->columns(array("PRODUK_ID", "NAMA_SARANA", "NAMA_PRODUK +'<div>NIE : '+NOMOR_REGISTRASI+'</div>' ", "'Kemasan : '+ KEMASAN + '<div>Bentuk Sediaan : '+BENTUK_SEDIAAN+'</div><div>Indikasi : '+INDIKASI+'</div>'", "'Label : '+ LABEL + '<div>Komposisi '+KOMPOSISI+'</div>'"));
				
				if($this->newsession->userdata('SESS_PROP_ID') == '7100'){
					$propid = "'7100','8200'";
				}else if($this->newsession->userdata('SESS_PROP_ID') == '7300'){
					$propid = "'7300','7600'";
				}else{
					$propid = $this->newsession->userdata('SESS_PROP_ID');
				}
				
				$query = "SELECT PRODUK_ID, NAMA_SARANA AS [NAMA SARANA], NAMA_PRODUK +'<div>NIE : '+NOMOR_REGISTRASI+'</div>' AS [NAMA PRODUK], 'Kemasan : '+ KEMASAN + '<div>Bentuk Sediaan : '+BENTUK_SEDIAAN+'</div><div>Indikasi : '+INDIKASI+'</div>' AS KEMASAN, 'Label : '+ LABEL + '<div>Komposisi '+KOMPOSISI+'</div>' AS KOMPOSISI FROM M_PRODUK WHERE PROPINSI IN ($propid)";
			}
			$proses['Tambah Produk Lokal Baru'] = array('GET', site_url()."/home/master/lokal/new", '0');
			$proses['Edit Produk Lokal'] = array('GET', site_url()."/home/master/lokal/new", '1');
			$proses['Hapus Produk Lokal'] = array('POST', site_url()."/post/master/hapus/lokal/ajax", 'N');
			$this->newtable->menu($proses);
			$tabel = $this->newtable->generate($query);
			$arrdata = array('table' => $tabel,
							 'idjudul' => 'judulmproduk',
							 'caption_header' => 'Master Produk Lokal Spesifik',
							 'batal' => '',
							 'cancel' => '');
			return $arrdata;
		}else{
			$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
		}
	}
	
	function set_detil($id){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$sipt->load->model("main", "main", true);
			$id = str_replace("-"," ",$id);
			$query = "SELECT A.no_registrasi AS [NOMOR REGISTRASI], A.nama_produk AS [NAMA PRODUK], A.bentuk_sediaan AS [BENTUK SEDIAAN], A.kemasan AS KEMASAN, A.indikasi AS INDIKASI, B.nama_sarana AS PRODUSEN, B.alamat AS [ALAMAT PRODUSEN], C.nama_sarana AS PENDAFTAR, C.alamat AS [ALAMAT PENDAFTAR], D.nama_sarana AS IMPORTIR, D.alamat AS [ALAMAT IMPORTIR], E.nama_klasifikasi AS [KLASIFIKASI], F.nama_katagori AS [NAMA KATAGORI] FROM registrasi A LEFT JOIN sarana B ON A.kode_produsen = B.kode_sarana LEFT JOIN sarana C ON A.kode_pendaftar = C.kode_sarana LEFT JOIN sarana D ON A.kode_importir = D.kode_sarana LEFT JOIN master_klasifikasi E ON A.kode_klasifikasi = E.kode_klasifikasi LEFT JOIN master_katagori F ON A.kode_katagori = F.kode_katagori AND E.kode_klasifikasi = F.kode_klasifikasi WHERE A.nomor_permohonan LIKE '%$id%'";
			$data = $this->main->get_result_webreg($query);
			if($data){
				foreach($query->result_array() as $row){
					$arrdata = array('sess' => $row);
				}
			}		  
		}
		return $arrdata;
	}
	
	function get_produk($id, $isPrev){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$sipt->load->model("main", "main", true);
			if($this->newsession->userdata('SESS_BBPOM_ID') == "00" || in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))){
				$propinsi = $sipt->main->combobox("SELECT PROPINSI_ID, NAMA_PROPINSI FROM M_PROPINSI WHERE RIGHT(PROPINSI_ID, 2) = '00'","PROPINSI_ID","NAMA_PROPINSI", TRUE);
			}else{
				if($this->newsession->userdata('SESS_PROP_ID') == '7100'){
					$propid = "'7100','8200'";
					$propinsi = $sipt->main->combobox("SELECT PROPINSI_ID, NAMA_PROPINSI FROM M_PROPINSI WHERE RIGHT(PROPINSI_ID, 2) = '00' AND PROPINSI_ID IN ($propid)","PROPINSI_ID","NAMA_PROPINSI");
				}else if($this->newsession->userdata('SESS_PROP_ID') == '7300'){
					$propid = "'7300','7600'";
					$propinsi = $sipt->main->combobox("SELECT PROPINSI_ID, NAMA_PROPINSI FROM M_PROPINSI WHERE RIGHT(PROPINSI_ID, 2) = '00' AND PROPINSI_ID IN ($propid)","PROPINSI_ID","NAMA_PROPINSI");
				}else{
					$propinsi = $sipt->main->combobox("SELECT PROPINSI_ID, NAMA_PROPINSI FROM M_PROPINSI WHERE RIGHT(PROPINSI_ID, 2) = '00' AND PROPINSI_ID = '".$this->newsession->userdata('SESS_PROP_ID')."'","PROPINSI_ID","NAMA_PROPINSI");
				}
			}

			if($id==""){
				  $arrdata = array('sess' => '',
								   'act' => site_url().'/post/master/save/produk/simpan',
								   'batal' => site_url().'/home/master/lokal',
								   'id' => '',
								   'propinsi' => $propinsi,
								   'save' => 'Simpan',
								   'cancel' => 'Batal');
			}else{
				$query = "SELECT A.PRODUK_ID, A.NAMA_SARANA, A.NAMA_PRODUK, A.NOMOR_REGISTRASI, A.KEMASAN, A.BENTUK_SEDIAAN, A.INDIKASI, A.LABEL, A.KOMPOSISI, B.NAMA_PROPINSI FROM M_PRODUK A LEFT JOIN M_PROPINSI B ON A.PROPINSI = B.PROPINSI_ID WHERE A.PRODUK_ID = '$id'";
				$data = $sipt->main->get_result($query);
				if($data){
					foreach($query->result_array() as $row){
						$arrdata = array('sess' => $row,
										 'act' => site_url().'/post/master/save/produk/update',
										 'batal' => site_url().'/home/master/lokal',
										 'id' => $row['PRODUK_ID'],
										 'propinsi' => $propinsi,
										 'save' => 'Update',
										 'cancel' => 'Kembali');
					}
				}

			}
			$arrdata['isPrev'] = $isPrev;
			return $arrdata;
		}else{
			$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
		}
	}
	
	function SaveForm($setaction, $isajax){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main","main", true);
			if($setaction=="simpan"){#Insert Mode
				$id = (int)$sipt->main->get_uraian("SELECT MAX(PRODUK_ID) AS MAXID FROM M_PRODUK", "MAXID") + 1;
				$arr_produk = array('PRODUK_ID' => $id);
				foreach($this->input->post('PRODUK') as $a => $b){
						$arr_produk[$a] = $b;
				}	
				if($this->db->insert('M_PRODUK', $arr_produk)) return "MSG#YES#Data berhasil disimpan#".site_url().'/home/master/lokal';
				if($isajax!="ajax"){
					redirect(base_url());
					exit();
				}
			}
			else if($setaction=="update"){#Update Mode
				foreach($this->input->post('PRODUK') as $a => $b){
						$arr_produk[$a] = $b;
				}	
				$this->db->where(array("PRODUK_ID" => $this->input->post('ID')));
				if($this->db->update('M_PRODUK', $arr_produk)) return "MSG#YES#Data berhasil disimpan#".site_url().'/home/master/lokal';
				if($isajax!="ajax"){
					redirect(base_url());
					exit();
				}
			}
			
			if($isajax!="ajax"){
				redirect(site_url().'/home/master/lokal');
				exit();
			}
			return "MSG#NO#Data gagal disimpan";
		}
		else{
			$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
		}
	}
	
	function DeleteLokal($isajax){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$ret = "MSG#Hapus Produk Lokal Gagal.";
			foreach($this->input->post('tb_chk') as $chkitem){
				$this->db->where('PRODUK_ID', $chkitem);
				if($this->db->delete('M_PRODUK')) $ret = "MSG#Hapus Produk Lokal Berhasil.#";
			}
			if($isajax!="ajax"){
				redirect(base_url());
				exit();			  
			}
			return $ret;
		}
		$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
	}
	
	

}
?>