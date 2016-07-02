<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);

class tproduk_act extends Model{
	
	function list_produk($sarana, $jenis, $klasifikasi, $idperiksa, $subid){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$sipt->load->model("main","main",true);
			$idperiksa = explode(".",$idperiksa);
			$kk_id = $sipt->main->combobox("SELECT DISTINCT(KK_ID) AS KK_ID, NAMA_KK FROM M_KLASIFIKASI_KATEGORI WHERE KK_ID IN ('001','010','011','012','013','015')","KK_ID","NAMA_KK", TRUE);
			if(in_array('2', $this->newsession->userdata('SESS_KODE_ROLE'))){
				if(in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')))
					$status = "20111";
				else
					$status = "20101";
			}
			
			$arrdata = array('act' => site_url().'/post/pemeriksaan/set_produk/save/',
							 'header' => 'Tambah Temuan Produk',
							 'url_selesai' => site_url().'/home/pelaporan/pemeriksaan/view/'.substr($jenis, 0,2)."/".$idperiksa[1],
							 'save' => 'Tambah',
							 'selesai' => 'Selesai',
							 'klasifikasi' => $kk_id,
							 'sel_kk' => '',
							 'sess' => '',
							 'seri' => '');
			if($subid != "" && $subid != "row"){
				$subid = explode(".",$subid); 
				$query = "SELECT DISTINCT(B.NAMA_KK) AS NAMA_KK, A.KK_ID FROM T_PEMERIKSAAN_TEMUAN_PRODUK A LEFT JOIN M_KLASIFIKASI_KATEGORI B ON A.KK_ID = B.KK_ID WHERE A.PERIKSA_ID ='$subid[2]' AND A.SERI = '$subid[0]'";
				$data = $sipt->main->get_result($query);
				if($data){
					foreach($query->result_array() as $row){
						$arrdata = array('act' => site_url().'/post/pemeriksaan/set_produk/update/',
										 'sess' => $row,
										 'header' => 'Edit Temuan Produk',
										 'url_selesai' => site_url().'/home/produk/add/'.$sarana.'/'.$jenis.'/'.$klasifikasi.'/'.join(".",$idperiksa),
										 'save' => 'Update',
										 'selesai' => 'Kembali',
										 'klasifikasi' => $kk_id,
										 'sel_kk' => $row['KK_ID'],
										 'seri' => $subid[0]);
					}
				}
			}
			
			$arrisi = $this->get_klasifikasi($arrdata['sel_kk'], join(".",$subid));
			if($arrdata['sel_kk'] != ""){
				$arrdata['load_kk'] = $this->load->view("pemeriksaan/produk/".$arrdata['sel_kk'], $arrisi, true);
			}
			$arrdata['id'] = join(".",$idperiksa);
			$arrdata['produk'] = $this->get_produk($sarana, $jenis, $klasifikasi, join(".",$idperiksa));
			$arrdata['url_hidden'] = site_url().'/home/produk/add/'.$sarana.'/'.$jenis.'/'.$klasifikasi.'/'.join(".",$idperiksa);
			return $arrdata;
		}else{
			$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
		}
	}
	
	function get_klasifikasi($kk,$seri){
		$sipt =& get_instance();
		$sipt->load->model("main","main",true);
		if($kk == "001"){
			$tindakan_produk = $sipt->main->combobox("SELECT KODE, URAIAN FROM M_TABEL WHERE JENIS = 'TL_PRODUK_TEMUAN' AND KODE IN ('10','11')","URAIAN","URAIAN");
			$kategori_temuan = $sipt->main->combobox("SELECT KODE, URAIAN FROM M_TABEL WHERE JENIS = 'KATEGORI_TEMUAN' AND KODE IN ('09','10','11','12','14')","URAIAN","URAIAN");
			$kemasan = array("Buah/Pieces" => "Buah/Pieces", "Tablet" => "Tablet", "Strip" => "Strip", "Karton" => "Karton", "Sachet" => "Sachet","Dus" => "Dus", "Botol" => "Botol");
			$registrasi_produk = array();
			$klasifikasi_temuan = array();
			$farmasetik = array();
		}
		
		else if($kk == "010"){
			$tindakan_produk = $sipt->main->combobox("SELECT KODE, URAIAN FROM M_TABEL WHERE JENIS = 'TL_PRODUK_TEMUAN' AND KODE IN ('01','02','03')","URAIAN","URAIAN");
			$kategori_temuan = $sipt->main->combobox("SELECT KODE, URAIAN FROM M_TABEL WHERE JENIS = 'KATEGORI_TEMUAN' AND KODE IN ('01','02','03','04','05','06')","URAIAN","URAIAN");
			$klasifikasi_temuan = $sipt->main->combobox("SELECT KODE, URAIAN FROM M_TABEL WHERE JENIS = 'KLASIFIKASI_TEMUAN'","URAIAN","URAIAN");
			$farmasetik = $sipt->main->combobox("SELECT KODE, URAIAN FROM M_TABEL WHERE JENIS = 'FARMASETIK'","URAIAN","URAIAN");
			$kemasan = array("Buah/Pieces" => "Buah/Pieces", "Sachet" => "Sachet", "Bungkus" => "Bungkus", "Botol" => "Botol", "Kaleng" => "Kaleng", "Karton" => "Karton", "Cup" => "Cup", "Tube" => "Tube");
			$registrasi_produk = array();
		}
		
		else if($kk == "011"){
			$tindakan_produk = $sipt->main->combobox("SELECT KODE, URAIAN FROM M_TABEL WHERE JENIS = 'TL_PRODUK_TEMUAN' AND KODE IN ('01','02','03')","URAIAN","URAIAN");
			$kategori_temuan = $sipt->main->combobox("SELECT KODE, URAIAN FROM M_TABEL WHERE JENIS = 'KATEGORI_TEMUAN' AND KODE IN ('01','02','03','04','05','06')","URAIAN","URAIAN");
			$klasifikasi_temuan = $sipt->main->combobox("SELECT KODE, URAIAN FROM M_TABEL WHERE JENIS = 'KLASIFIKASI_TEMUAN'","URAIAN","URAIAN");
			$farmasetik = $sipt->main->combobox("SELECT KODE, URAIAN FROM M_TABEL WHERE JENIS = 'FARMASETIK'","URAIAN","URAIAN");
			$kemasan = array("Buah/Pieces" => "Buah/Pieces", "Sachet" => "Sachet", "Bungkus" => "Bungkus", "Botol" => "Botol", "Kaleng" => "Kaleng", "Karton" => "Karton", "Cup" => "Cup", "Tube" => "Tube");
			$registrasi_produk = array();
		}
		
		else if($kk == "012"){
			$tindakan_produk = $sipt->main->combobox("SELECT KODE, URAIAN FROM M_TABEL WHERE JENIS = 'TL_PRODUK_TEMUAN' AND KODE IN ('01','02','03','04')","URAIAN","URAIAN");
			$kategori_temuan = $sipt->main->combobox("SELECT KODE, URAIAN FROM M_TABEL WHERE JENIS = 'KATEGORI_TEMUAN' AND KODE IN ('01','03','04','06','07')","URAIAN","URAIAN");
			$klasifikasi_temuan = $sipt->main->combobox("SELECT KODE, URAIAN FROM M_TABEL WHERE JENIS = 'KLASIFIKASI_TEMUAN' AND KODE IN ('01','02')","URAIAN","URAIAN");
			$farmasetik = array();
			$kemasan = array("Buah/Pieces" => "Buah/Pieces", "Sachet" => "Sachet", "Bungkus" => "Bungkus", "Botol" => "Botol", "Kaleng" => "Kaleng", "Karton" => "Karton", "Cup" => "Cup", "Tube" => "Tube");
			$registrasi_produk = array();			
		}
		
		else if($kk == "013"){
			$tindakan_produk = array('');
			$kategori_temuan = array("TIE (Tanpa Izin Edar)" => "TIE (Tanpa Izin Edar)", "Rusak" => "Rusak", "ED (Expired Date / Kadaluarsa)" => "ED (Expired Date / Kadaluarsa)", "TMK Label" => "TMK Label");
			$kemasan = array("Buah/Pieces" => "Buah/Pieces", "Sachet" => "Sachet", "Bungkus" => "Bungkus", "Botol" => "Botol", "Kaleng" => "Kaleng", "Karton" => "Karton", "Cup" => "Cup");
			$registrasi_produk = array("MD" => "MD","ML" => "ML","P-IRT" => "P-IRT", "SP" => "SP", "Tidak Terdaftar" => "Tidak Terdaftar");
			$klasifikasi_temuan = array();
			$farmasetik = array();
		}
		
		else if($kk == "015"){
			$klasifikasi_temuan = $sipt->main->referensi("KLASIFIKASI_TEMUAN","'01','02'",TRUE,TRUE);
			$arrdata['status_bb'] = array("" => "", "IT-B2" => "IT-B2", "IT-B2C" => "IT-B2 Cabang", "DT-B2" => "DT-B2", "DT-B2C" => "DT-B2 Cabang", "PT-B2" => "PT-B2","STB" => "Sarana Tidak Berizin");
		}
		
		if($seri != ""){
			$seri = explode(".",$seri);
			$where = " WHERE PERIKSA_ID = '$seri[2]' AND SERI = '$seri[0]'";		
			if($kk == "001"){
				$query = "SELECT NAMA_PRODUK, NOMOR_REGISTRASI, KEMASAN, NO_BATCH, TANGGAL_EXPIRE, KATEGORI, PRODUSEN, NAMA_PERUSAHAAN, ALAMAT_PERUSAHAAN, NEGARA_ASAL, JUMLAH_TEMUAN, SATUAN, TINDAKAN_PRODUK, KETERANGAN_SUMBER, HARGA_SATUAN FROM T_PEMERIKSAAN_TEMUAN_PRODUK $where";
			}
			else if($kk == "010"){
				$query = "SELECT NAMA_PRODUK, PRODUSEN, KLASIFIKASI_PRODUK, ALAMAT_PERUSAHAAN, NOMOR_REGISTRASI, NO_BATCH, TANGGAL_EXPIRE, NETTO, KATEGORI, SATUAN, TINDAKAN_PRODUK, JUMLAH_TEMUAN, HARGA_SATUAN, KETERANGAN_SUMBER, JENIS_PELANGGARAN FROM T_PEMERIKSAAN_TEMUAN_PRODUK $where";
			}else if($kk == "011"){
				$query = "SELECT NAMA_PRODUK, PRODUSEN, KLASIFIKASI_PRODUK, ALAMAT_PERUSAHAAN, NOMOR_REGISTRASI, NO_BATCH, TANGGAL_EXPIRE, NETTO, KATEGORI, SATUAN, TINDAKAN_PRODUK, JUMLAH_TEMUAN, HARGA_SATUAN, KETERANGAN_SUMBER, JENIS_PELANGGARAN FROM T_PEMERIKSAAN_TEMUAN_PRODUK $where";
			}
			else if($kk == "012"){
				$query = "SELECT NAMA_PRODUK, PRODUSEN, KLASIFIKASI_PRODUK, ALAMAT_PERUSAHAAN, NOMOR_REGISTRASI, NO_BATCH, TANGGAL_EXPIRE, NETTO, KATEGORI, SATUAN, TINDAKAN_PRODUK, JUMLAH_TEMUAN, HARGA_SATUAN, KETERANGAN_SUMBER, JENIS_PELANGGARAN FROM T_PEMERIKSAAN_TEMUAN_PRODUK $where";
			}
			else if($kk == "013"){
				$query = "SELECT NAMA_PRODUK, PRODUSEN, REGISTRASI, NOMOR_REGISTRASI, JUMLAH_TEMUAN, SATUAN, KATEGORI, HARGA FROM T_PEMERIKSAAN_TEMUAN_PRODUK $where";
			}
			else if($kk == "015"){
				$query = "SELECT PERIKSA_ID, SERI, NAMA_BB, NAMA_PRODUK, KEMASAN, KLASIFIKASI_PRODUK, SUMBER_PENGADAAN, NAMA_PERUSAHAAN, ALAMAT_PERUSAHAAN, TELEPON, CARA_PEMBELIAN, STATUS_REPACKING, LAMPIRAN FROM T_PEMERIKSAAN_TEMUAN_PRODUK $where";
			}
			$data = $sipt->main->get_result($query);
			if($data){
				foreach($query->result_array() as $row){
					$arrdata = array('sess_produk' => $row);
				}
			}
			
		}
		
		$arrdata['tindakan_produk'] = $tindakan_produk;
		$arrdata['kategori_temuan'] = $kategori_temuan;
		$arrdata['klasifikasi_temuan'] = $klasifikasi_temuan;
		$arrdata['kemasan'] = $kemasan;
		$arrdata['registrasi_produk'] = $registrasi_produk;
		$arrdata['farmasetik'] = $farmasetik;
		return $arrdata;
	}
	
	function get_produk($sarana, $jenis, $klasifikasi, $idperiksa){
		$this->load->library('newtable');
		$idperiksa = explode(".",$idperiksa);
		$query = "SELECT PERIKSA_ID, SERI, KK_ID, NAMA_PRODUK AS [NAMA PRODUK], NOMOR_REGISTRASI AS [NOMOR REGISTRASI], NO_BATCH AS [NO BATCH], PRODUSEN, KATEGORI, JENIS_PELANGGARAN FROM T_PEMERIKSAAN_TEMUAN_PRODUK WHERE PERIKSA_ID='$idperiksa[0]'";
		$this->newtable->search(array(array('NAMA_PRODUK', 'Berdasarkan Nama Produk'), array('NOMOR_REGISTRASI', 'Berdasarkan Nomor Registrasi'), array('PRODUSEN', 'Berdasarkan Nama Produsen')));
		$this->newtable->action(site_url()."/home/produk/add/".$sarana."/".$jenis."/".$klasifikasi."/".join(".",$idperiksa));
		$this->newtable->cidb($this->db);
		$this->newtable->ciuri($this->uri->segment_array());
		$this->newtable->orderby(2);
		$this->newtable->sortby("ASC");
		$this->newtable->columns(array("PERIKSA_ID","SERI","KK_ID","NAMA_PRODUK","NOMOR_REGISTRASI","NO_BATCH","PRODUSEN","KATEGORI"));
		$this->newtable->hiddens(array('SERI','KK_ID','PERIKSA_ID'));
		$this->newtable->keys(array('SERI','KK_ID','PERIKSA_ID'));
		$proses['Edit Produk'] = array('GET', site_url()."/home/produk/add/".$sarana."/".$jenis."/".$klasifikasi."/".join(".",$idperiksa), '1');
		$proses['Hapus Produk'] = array('POST', site_url()."/post/pemeriksaan/set_produk/hapus/ajax", 'N');
		$this->newtable->menu($proses);
		$tabel = $this->newtable->generate($query);
		return $tabel;
	}
	
	function view_produk($sarana, $jenis, $klasifikasi, $idperiksa){
		$this->load->library('newtable');
		$idperiksa = explode(".",$idperiksa);
		$query = "SELECT PERIKSA_ID, SERI, KK_ID, NAMA_PRODUK AS [NAMA PRODUK], NOMOR_REGISTRASI AS [NOMOR REGISTRASI], NO_BATCH AS [NO BATCH], PRODUSEN, KATEGORI FROM T_PEMERIKSAAN_TEMUAN_PRODUK WHERE PERIKSA_ID='$idperiksa[0]'";
		$this->newtable->search(array(array('NAMA_PRODUK', 'Berdasarkan Nama Produk'), array('NOMOR_REGISTRASI', 'Berdasarkan Nomor Registrasi'), array('PRODUSEN', 'Berdasarkan Nama Produsen')));
		$this->newtable->action(site_url()."/home/produk/view/".$sarana."/".$jenis."/".$klasifikasi."/".join(".",$idperiksa));
		$this->newtable->cidb($this->db);
		$this->newtable->ciuri($this->uri->segment_array());
		$this->newtable->orderby(2);
		$this->newtable->sortby("ASC");
		$this->newtable->columns(array("PERIKSA_ID","SERI","KK_ID","NAMA_PRODUK","NOMOR_REGISTRASI","NO_BATCH","PRODUSEN","KATEGORI"));
		$this->newtable->hiddens(array('SERI','KK_ID','PERIKSA_ID'));
		$this->newtable->keys(array('SERI','KK_ID','PERIKSA_ID'));
		$this->newtable->show_chk(FALSE);
		$tabel = $this->newtable->generate($query);		
		$arrdata = array('table' => $tabel,
						 'idjudul' => 'judulpmnsarana',
						 'caption_header' => 'Data Temuan Produk',
						 'batal' => '',
						 'cancel' => '');
		return $arrdata;
	}
	
	function set_produk($action, $isajax){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main","main", true);
			if($action=="save"){
				$periksa = explode(".",$this->input->post('PERIKSA_ID'));
				$seri = (int)$sipt->main->get_uraian("SELECT MAX(SERI) AS MAXID FROM T_PEMERIKSAAN_TEMUAN_PRODUK WHERE PERIKSA_ID = '$periksa[0]'", "MAXID") + 1;
				$temuan = array('PERIKSA_ID' => $periksa[0],
								'SERI' => $seri);
				foreach($this->input->post('TEMUAN') as $a => $b){
					if(!is_array($b))
						$temuan[$a] = $b;
					else
						$temuan[$a] = join(",", $b);
				}
				if($temuan['KK_ID'] == "010" || $temuan['KK_ID'] == "011" | $temuan['KK_ID'] == "012"){
					if(array_key_exists('JUMLAH_TEMUAN', $temuan)){ 
						$temuan['HARGA_TOTAL'] = $temuan['HARGA_SATUAN'] * $temuan['JUMLAH_TEMUAN'];	
					}
				}
				if($this->db->insert('T_PEMERIKSAAN_TEMUAN_PRODUK', $temuan)) return "MSG#YES#Data produk berhasil disimpan#".$this->input->post('URL');
				if($isajax!="ajax"){
					redirect(base_url());
					exit();
				}
			}
			else if($action=="update"){
				$periksa = explode(".",$this->input->post('PERIKSA_ID'));
				foreach($this->input->post('TEMUAN') as $a => $b){
					if(!is_array($b))
						$temuan[$a] = $b;
					else
						$temuan[$a] = join(",", $b);
				}
				if($temuan['KK_ID'] == "010" || $temuan['KK_ID'] == "011" | $temuan['KK_ID'] == "012"){
					if(array_key_exists('JUMLAH_TEMUAN', $temuan)){ 
						$temuan['HARGA_TOTAL'] = $temuan['HARGA_SATUAN'] * $temuan['JUMLAH_TEMUAN'];	
					}
				}
				$this->db->where(array("PERIKSA_ID" => $periksa[0], "SERI" => $this->input->post('SERI')));
				
				if($this->db->update('T_PEMERIKSAAN_TEMUAN_PRODUK', $temuan))return "MSG#YES#Data berhasil diedit#".$this->input->post('URL');
				if($isajax!="ajax"){
					redirect(base_url());
					exit();
				}
			}
			else if($action=="hapus"){
				$ret = "MSG#Hapus Produk Gagal.";
				foreach($this->input->post('tb_chk') as $chkitem){
					$id = explode(".", $chkitem);
					$this->db->where(array("PERIKSA_ID" => $id[2], "SERI" => $id[0]));
					if($this->db->delete('T_PEMERIKSAAN_TEMUAN_PRODUK')) $ret = "MSG#Hapus Data Produk Berhasil.#";
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