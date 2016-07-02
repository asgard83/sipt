<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);

class Sarana_act extends Model{

	function list_sarana(){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$sipt->load->model("main", "main", true);
			$this->load->library('newtable');
			$this->newtable->hiddens(array('SARANA_ID','JENIS_SARANA'));
			$this->newtable->action(site_url()."/home/master/sarana");
			$this->newtable->detail(site_url()."/load/master/set_detil/sarana");
			$this->newtable->cidb($this->db);
			$this->newtable->ciuri($this->uri->segment_array());
			$this->newtable->orderby(3);
			$this->newtable->sortby("ASC");
			$this->newtable->keys(array('SARANA_ID'));
			$this->newtable->search(array(array('', '')));
			$this->newtable->show_search(FALSE);
			
			if(array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('9', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('10', $this->newsession->userdata('SESS_KODE_ROLE'))){
				$proses['Tambah Sarana Baru'] = array('GET', site_url()."/home/master/sarana/new", '0');
				$proses['Edit Data Sarana'] = array('GET', site_url()."/home/master/sarana/new", '1');
				$proses['Hapus Data Sarana'] = array('POST', site_url()."/post/master/hapus/sarana/ajax", 'N');
				$proses['Data Izin Industri / Izin Produksi'] = array('GET', site_url()."/home/master/izin/list", '1');
				$proses['Data Sertifikat'] = array('GET', site_url()."/home/master/sertifikat/list", '1');
				$proses['Data Jenis Produk Pangan dan Pemasaran'] = array('GET', site_url()."/home/master/pemasaran/list", '1');
				$proses['Data Jenis Pangan'] = array('GET', site_url()."/home/master/pangan/list", '1');
				$proses['Data Jenis Distribusi'] = array('GET', site_url()."/home/master/jenis/list", '1');
			}else{
				if(array_key_exists('2', $this->newsession->userdata('SESS_KODE_ROLE'))){ 
					$proses['Tambah Sarana Baru'] = array('GET', site_url()."/home/master/sarana/new", '0');
					$proses['Edit Data Sarana'] = array('GET', site_url()."/home/master/sarana/new", '1');
				}
				$proses['Data Izin Industri / Izin Produksi'] = array('GET', site_url()."/home/master/izin/list", '1');
				$proses['Data Sertifikat'] = array('GET', site_url()."/home/master/sertifikat/list", '1');
				$proses['Data Jenis Produk Pangan dan Pemasaran'] = array('GET', site_url()."/home/master/pemasaran/list", '1');
				$proses['Data Jenis Pangan'] = array('GET', site_url()."/home/master/pangan/list", '1');
				$proses['Data Jenis Distribusi'] = array('GET', site_url()."/home/master/jenis/list", '1');
			}
			
			$this->newtable->menu($proses);
			if(!in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')) && $this->newsession->userdata('SESS_BBPOM_ID') != '00'){
				if($this->newsession->userdata('SESS_PROP_ID') == '7100'){
					$prop = "'7100','8200'";
				}else if($this->newsession->userdata('SESS_PROP_ID') == '7300'){
					$prop = "'7300','7600'";
				}else{
					$prop = "'".$this->newsession->userdata('SESS_PROP_ID')."'";			  
				}
				$query = "SELECT A.SARANA_ID, A.JENIS_SARANA, UPPER(REPLACE(A.NAMA_SARANA,'-',''))+'<div>Jenis Sarana : '+B.NAMA_JENIS_SARANA+'</div>' AS [NAMA SARANA], 'Kantor : '+A.ALAMAT_1+'<div>Pabrik / Gudang : '+A.ALAMAT_2+'</div><div>'+C.NAMA_PROPINSI+'</div>' AS ALAMAT, 'Penanggung Jawab : '+A.PENANGGUNG_JAWAB+'<div>Pimpinan : '+A.NAMA_PIMPINAN+'</div>' AS [PENANGGUNG JAWAB], A.NOMOR_IZIN+'<div>'+A.TANGGAL_IZIN+'<div>' AS PERIZINAN,(SELECT  CAST(COUNT(SARANA_ID) AS VARCHAR) FROM T_PEMERIKSAAN WHERE SARANA_ID = A.SARANA_ID) +' Kali' AS [DIPERIKSA] FROM M_SARANA A LEFT JOIN M_JENIS_SARANA B ON A.JENIS_SARANA = B.JENIS_SARANA_ID LEFT JOIN M_PROPINSI C ON A.PROPINSI = C.PROPINSI_ID WHERE A.PROPINSI IN ($prop)";
				$this->newtable->columns(array("A.SARANA_ID", "A.JENIS_SARANA","UPPER(A.NAMA_SARANA)+'<div>Jenis Sarana : '+B.NAMA_JENIS_SARANA+'</div>'", "'Kantor : '+A.ALAMAT_1+'<div>Pabrik / Gudang : '+A.ALAMAT_2+'</div><div>'+C.NAMA_PROPINSI+'</div>'","'Penanggung Jawab : '+A.PENANGGUNG_JAWAB+'<div>Pimpinan : '+A.NAMA_PIMPINAN+'</div>'","A.NOMOR_IZIN+'<div>'+A.TANGGAL_IZIN+'<div>'","(SELECT  CAST(COUNT(SARANA_ID) AS VARCHAR) FROM T_PEMERIKSAAN WHERE SARANA_ID = A.SARANA_ID) +' Kali'"));
			}else{
				$sarana = "'".join("','", $this->newsession->userdata('SESS_SARANA'))."'";
				if($this->newsession->userdata('SESS_BBPOM_ID') == "93"){
					$sarana .= "'01OO','02MM','02LL','03AA'";
				}
				if($this->newsession->userdata('SESS_BBPOM_ID') == "00"){
					$flags = " ,CASE A.FLAG WHEN '0' THEN 'Input Balai' WHEN '1' THEN 'WEB REGISTRASI' WHEN '2' THEN 'Tidak Diketahui' END AS [SUMBER DATA]";
					$this->newtable->columns(array("A.SARANA_ID", "A.JENIS_SARANA","UPPER(REPLACE(A.NAMA_SARANA,'-',''))+'<div>Jenis Sarana : '+B.NAMA_JENIS_SARANA+'</div>'", "'Kantor : '+A.ALAMAT_1+'<div>Pabrik / Gudang : '+A.ALAMAT_2+'</div><div>'+C.NAMA_PROPINSI+'</div>'","'Penanggung Jawab : '+A.PENANGGUNG_JAWAB+'<div>Pimpinan : '+A.NAMA_PIMPINAN+'</div>'","A.NOMOR_IZIN+'<div>'+A.TANGGAL_IZIN+'<div>'","(SELECT  CAST(COUNT(SARANA_ID) AS VARCHAR) FROM T_PEMERIKSAAN WHERE SARANA_ID = A.SARANA_ID) +' Kali'","CASE A.FLAG WHEN '0' THEN 'Input Balai' WHEN '1' THEN 'WEB REGISTRASI' WHEN '2' THEN 'Tidak Diketahui' END"));

				}else{
					$flags = "";
					$this->newtable->columns(array("A.SARANA_ID", "A.JENIS_SARANA","UPPER(REPLACE(A.NAMA_SARANA,'-',''))+'<div>Jenis Sarana : '+B.NAMA_JENIS_SARANA+'</div>'","'Kantor : '+A.ALAMAT_1+'<div>Pabrik / Gudang : '+A.ALAMAT_2+'</div><div>'+C.NAMA_PROPINSI+'</div>'","'Penanggung Jawab : '+A.PENANGGUNG_JAWAB+'<div>Pimpinan : '+A.NAMA_PIMPINAN+'</div>'","A.NOMOR_IZIN+'<div>'+A.TANGGAL_IZIN+'<div>'","(SELECT  CAST(COUNT(SARANA_ID) AS VARCHAR) FROM T_PEMERIKSAAN WHERE SARANA_ID = A.SARANA_ID) +' Kali'"));
				}				
				$query = "SELECT A.SARANA_ID, A.JENIS_SARANA, UPPER(REPLACE(A.NAMA_SARANA,'-',''))+'<div>Jenis Sarana : '+B.NAMA_JENIS_SARANA+'</div>' AS [NAMA SARANA], 'Kantor : '+A.ALAMAT_1+'<div>Pabrik / Gudang : '+A.ALAMAT_2+'</div><div>'+C.NAMA_PROPINSI+'</div>' AS ALAMAT, 'Penanggung Jawab : '+PENANGGUNG_JAWAB+'<div>Pimpinan : '+NAMA_PIMPINAN+'</div>' AS [PENANGGUNG JAWAB], A.NOMOR_IZIN+'<div>'+A.TANGGAL_IZIN+'<div>' AS PERIZINAN, (SELECT  CAST(COUNT(SARANA_ID) AS VARCHAR) FROM T_PEMERIKSAAN WHERE SARANA_ID = A.SARANA_ID) +' Kali' AS [DIPERIKSA] $flags FROM M_SARANA A LEFT JOIN M_JENIS_SARANA B ON A.JENIS_SARANA = B.JENIS_SARANA_ID LEFT JOIN M_PROPINSI C ON A.PROPINSI = C.PROPINSI_ID WHERE A.JENIS_SARANA IN (".$sarana.")";
			} 
			$tabel = $this->newtable->generate($query);
			$arrdata = array('table' => $tabel,
							 'idjudul' => 'judulmsarana',
							 'search' => TRUE,
							 'frmsearch' => $sipt->main->_fsarana(site_url().'/home/cari/sarana',$cari, $subcari),
							 'caption_header' => 'Master Sarana',
							 'batal' => '',
							 'cancel' => '');
			return $arrdata;
		}else{
			$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
		}
	}
	
	function get_sarana($id){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$sipt->load->model("main", "main", true);
			$nama = $sipt->main->combobox("SELECT URAIAN FROM M_TABEL WHERE JENIS='JENIS_SARANA' ORDER BY URAIAN ASC", "URAIAN", "URAIAN");
			$disinput = array("JENISDIS","NAMADIS");
			$jenis = $sipt->main->get_jenis_sarana($this->newsession->userdata("SESS_USER_ID"), $disinput);
			$klasifikasi = $sipt->main->combobox("SELECT * FROM M_KLASIFIKASI_KATEGORI WHERE LEN(KK_ID) = 3", "KK_ID", "NAMA_KK", TRUE);	
			if($id==""){#Insert Mode
				$arrdata = array('sess' => '',
								 'act' => site_url().'/post/master/save/sarana/simpan',
								 'batal' => site_url().'/home/master/sarana',
								 'id' => '',
								 'sel_jenis' => '',
								 'sel_nama' => '',
								 'save' => 'Simpan',
								 'cancel' => 'Batal');
			}else{#Edit Mode
				$qsarana = "SELECT SARANA_ID, JENIS_SARANA, NAMA_SARANA, NPWP, SARANA_BB FROM M_SARANA WHERE SARANA_ID='$id'";
				$dt_sarana = $sipt->main->get_result($qsarana);
				if($dt_sarana){
					foreach($qsarana->result_array() as $row){
						$arrdata = array('sess' => $row,
								 'act' => site_url().'/post/master/save/sarana/update',
								 'batal' => site_url().'/home/master/sarana',
								 'id' => $row['SARANA_ID'],
								 'sel_nama' => explode(",", $row['NAMA_SARANA']),
								 'sel_jenis' => $row['JENIS_SARANA'],
								 'save' => 'Update',
								 'cancel' => 'Kembali');
					}
				}
			}
			$arrdata['nama'] = $nama;
			$arrdata['jenis'] = $jenis;
			$arrdata['disinput'] = $disinput;
			$arrdata['klasifikasi'] = $klasifikasi;
			$arrdata['sarana_bb'] = $sipt->main->combobox("SELECT LTRIM(KODE) AS KODE, URAIAN FROM M_STATUS WHERE JENIS = 'STATUS_BB'","KODE","URAIAN", TRUE);
			$arrisi = $this->get_jenis($arrdata['sel_jenis'], $id);
			if($arrdata['sel_jenis'] != ""){
				$arrdata['load_jenis'] = $this->load->view("master/sarana/".$arrdata['sel_jenis'], $arrisi, true);
			}
			return $arrdata;
		}else{
			$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
		}
	}

	function get_jenis($jenis, $id){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$sipt->load->model("main", "main", true);
			$nama_jenis_sarana = $sipt->main->get_uraian("SELECT (B.NAMA_JENIS_SARANA + ' - ' + A.NAMA_JENIS_SARANA) AS JUDUL FROM M_JENIS_SARANA A LEFT JOIN M_JENIS_SARANA B ON LEFT(A.JENIS_SARANA_ID, 2) = B.JENIS_SARANA_ID WHERE A.JENIS_SARANA_ID = '$jenis'","JUDUL");			
			$arr_jenis[0] = array("GOL-A" => "Golongan A", "GOL-B" => "Golongan B");
			$arr_jenis[1] = array("IOT" => "IOT", "IKOT" => "IKOT", "IEBA" => "IEBA", "UKOT" => "UKOT", "UMOT" => "UMOT");
			$arr_golongan = $sipt->main->combobox("SELECT URAIAN FROM M_TABEL WHERE JENIS='GOLONGAN_SARANA'", "URAIAN", "URAIAN");
			if($jenis!=""){
				if($this->newsession->userdata('SESS_BBPOM_ID') == "00" || in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))){
					$propinsi = $sipt->main->combobox("SELECT PROPINSI_ID, NAMA_PROPINSI FROM M_PROPINSI WHERE RIGHT(PROPINSI_ID, 2) = '00'","PROPINSI_ID","NAMA_PROPINSI", TRUE);
					$kota = $sipt->main->combobox("SELECT PROPINSI_ID, NAMA_PROPINSI FROM M_PROPINSI WHERE RIGHT(PROPINSI_ID, 2) <> '00'","PROPINSI_ID","NAMA_PROPINSI", TRUE);
					$sel_propinsi = "";
					$sel_kota = "";
				}else{
					
					if($this->newsession->userdata('SESS_PROP_ID') == '7100'){
						$prop = "'7100','8200'";
					}else if($this->newsession->userdata('SESS_PROP_ID') == '7300'){
						$prop = "'7300','7600'";
					}else{
						$prop = "'".$this->newsession->userdata('SESS_PROP_ID')."'";			  
					}
					
					/*if($this->newsession->userdata('SESS_PROP_ID') == '7100')
						$prop = "'7100','8200'";
					else
						$prop = "'".$this->newsession->userdata('SESS_PROP_ID')."'";*/
					$propinsi = $sipt->main->combobox("SELECT PROPINSI_ID, NAMA_PROPINSI FROM M_PROPINSI WHERE RIGHT(PROPINSI_ID, 2) = '00' AND PROPINSI_ID IN($prop)","PROPINSI_ID","NAMA_PROPINSI");
					$kode = substr($this->newsession->userdata('SESS_PROP_ID'), 0, 2);
					$kota = $sipt->main->combobox("SELECT PROPINSI_ID, NAMA_PROPINSI FROM M_PROPINSI WHERE PROPINSI_ID LIKE '".$kode."%' AND RIGHT(PROPINSI_ID, 2) <> '00'","PROPINSI_ID","NAMA_PROPINSI", TRUE);
					$sel_propinsi = $this->newsession->userdata('SESS_PROP_ID');
					$sel_kota = "";
				}
				if($id == ""){
					$arrdata = array('sess' => '', 'sel_propinsi' => $sel_propinsi, 'sel_kota' => '', 'kota' => $kota);
				}else{
					$qsarana = "SELECT A.*, CONVERT(VARCHAR(10), A.TANGGAL_IZIN, 103) AS TANGGAL_IZIN, B.PROPINSI_ID AS PROP_ID, B.NAMA_PROPINSI AS NAMA_PROP, C.PROPINSI_ID AS KOTA_ID, C.NAMA_PROPINSI AS NAMA_KOTA FROM M_SARANA A LEFT JOIN M_PROPINSI B ON A.PROPINSI = B.PROPINSI_ID LEFT JOIN M_PROPINSI C ON A.KOTA = C.PROPINSI_ID WHERE A.SARANA_ID='$id'";
					$dt_sarana = $sipt->main->get_result($qsarana);
					if($dt_sarana){
						foreach($qsarana->result_array() as $row){
							$arrdata = array('sess' => $row,
											 'act' => site_url().'/post/master/save/sarana/update',
											 'batal' => site_url().'/home/master/sarana',
											 'id' => $row['SARANA_ID'],
											 'sel_jenis' => $row['JENIS_SARANA'],
											 'sel_propinsi' => $row['PROP_ID'],
											 'sel_kota' => $row['KOTA_ID'],
											 'save' => 'Update',
											 'cancel' => 'Kembali');
						}
						$kode = substr($row['PROP_ID'],0,2);
						$arrdata['kota'] = $sipt->main->combobox("SELECT PROPINSI_ID, NAMA_PROPINSI FROM M_PROPINSI WHERE PROPINSI_ID LIKE '".$kode."%' AND RIGHT(PROPINSI_ID, 2) <> '00'","PROPINSI_ID","NAMA_PROPINSI", TRUE);
					}
				}
				$arrdata['propinsi'] = $propinsi;
				if($jenis == "01VV"){
					/*$jenis_pangan = $this->db->query("SELECT TOP 1 SERI, KODE, NO_PIRT FROM T_SARANA_JENIS_PANGAN WHERE SARANA_ID = '".$id."' ORDER BY SERI DESC")->row();
					$arrdata['sess']['KODE_JENIS_PANGAN'] = substr($jenis_pangan->KODE, 0,2);
					$arrdata['sess']['KODE_JENIS_PANGAN_2'] = $jenis_pangan->KODE;
					$arrdata['jenis_pangan_new_2'] = $sipt->main->combobox("SELECT LTRIM(RTRIM(KODE)) AS KODE, JENIS_PANGAN FROM M_JENIS_PANGAN_NEW WHERE KODE LIKE '".substr($jenis_pangan->KODE,0,2)."%__' AND LEN(KODE) = '4' ORDER BY JENIS_PANGAN ASC", "KODE", "JENIS_PANGAN", TRUE);
					$arrdata['sess']['NO_PIRT_2'] = $jenis_pangan->NO_PIRT;*/
					$arrdata['t_jenis_pangan'] = $this->db->query("SELECT SARANA_ID, SERI, NO_PIRT, KODE, JENIS_PANGAN, CASE WHEN STATUS = 1 THEN 'Berlaku' WHEN STATUS = 0 THEN 'Tidak berlaku' END AS UR_STATUS, STATUS FROM T_SARANA_JENIS_PANGAN WHERE SARANA_ID = '".$id."' ")->result_array();
				}
			}else if($jenis==""){
				$arrdata = array();
			}
			$arrdata['jenis_industri'] = $arr_jenis;
			$arrdata['nama_jenis_sarana'] = $nama_jenis_sarana;
			$arrdata['arr_golongan'] = $arr_golongan;
			$arrdata['jenis_pangan_new'] = $sipt->main->combobox("SELECT LTRIM(RTRIM(KODE)) AS KODE, dbo.FIRST_CAPITAL(JENIS_PANGAN) AS JENIS_PANGAN FROM M_JENIS_PANGAN_NEW WHERE LEN(KODE) = 2","KODE","JENIS_PANGAN",TRUE);
			$arrdata['ispreview'] = FALSE;
			return $arrdata;
		}else{
			$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
		}		
	}
	
	function get_detil($id="", $jenis=""){
		$sipt =& get_instance();
		$sipt->load->model("main", "main", true);
		$query = "SELECT A.*, CONVERT(VARCHAR(10), A.TANGGAL_IZIN, 103) AS TANGGAL_IZIN, B.PROPINSI_ID AS PROP_ID, B.NAMA_PROPINSI AS NAMA_PROP, C.PROPINSI_ID AS KOTA_ID, C.NAMA_PROPINSI AS NAMA_KOTA FROM M_SARANA A LEFT JOIN M_PROPINSI B ON A.PROPINSI = B.PROPINSI_ID LEFT JOIN M_PROPINSI C ON A.KOTA = C.PROPINSI_ID WHERE A.SARANA_ID='$id'";
		$nama_jenis_sarana = $sipt->main->get_uraian("SELECT (B.NAMA_JENIS_SARANA + ' - ' + A.NAMA_JENIS_SARANA) AS JUDUL FROM M_JENIS_SARANA A LEFT JOIN M_JENIS_SARANA B ON LEFT(A.JENIS_SARANA_ID, 2) = B.JENIS_SARANA_ID WHERE A.JENIS_SARANA_ID = '$jenis'","JUDUL");			

		$data = $sipt->main->get_result($query);
		if($data){
			foreach($query->result_array() as $row){
				$arrdata = array('sess' => $row);
			}
		}
		$arrdata['nama_jenis_sarana'] = $nama_jenis_sarana;
		$arrdata['ispreview'] = TRUE;
		return $arrdata;
	}
		
	function get_detil_sarana($id){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$sipt->load->model("main", "main", true);
			$jenis_sarana = $sipt->main->get_uraian("SELECT (B.NAMA_JENIS_SARANA + ' - ' + A.NAMA_JENIS_SARANA) AS JUDUL FROM M_JENIS_SARANA A LEFT JOIN M_JENIS_SARANA B ON LEFT(A.JENIS_SARANA_ID, 2) = B.JENIS_SARANA_ID WHERE A.JENIS_SARANA_ID = '$id'","JUDUL");			
			$arrdata = array('nama_jenis_sarana' => $jenis_sarana,
							 'sess' => '');
			return $arrdata;
		}else{
			$this->fungsi->redirectMessage('Maaf, halaman yang anda tuju tidak ditemukan.','/home');
		}
	}
	
	function list_pemasaran($id){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$this->load->library('newtable');
			$this->newtable->hiddens(array('SARANA_ID','SERI'));
			$this->newtable->search(array(array('NEGARA', 'Negara Tujuan'), array('JENIS_PRODUK', 'Jenis Produk')));
			$this->newtable->action(site_url()."/home/master/pemasaran/list/$id");
			$this->newtable->cidb($this->db);
			$this->newtable->ciuri($this->uri->segment_array());
			$this->newtable->orderby(2);
			$this->newtable->sortby("ASC");
			$this->newtable->keys(array('SARANA_ID','SERI'));
			$proses = array('Tambah Pemasaran Baru' => array('GET', site_url()."/home/master/pemasaran/new/$id", '0'), 'Edit Pemasaran' => array('GET', site_url()."/home/master/pemasaran/new", '1'), 'Hapus Hasil Pemasaran' => array('POST', site_url()."/master/master/hapus/pemasaran/ajax", 'N'));
			$this->newtable->menu($proses);
			$this->newtable->columns(array("SARANA_ID","SERI","TUJUAN","JENIS_PRODUK","NEGARA","PRESENTASE"));
			$query = "SELECT SARANA_ID, SERI, TUJUAN, JENIS_PRODUK AS [JENIS PRODUK], NEGARA, PERSENTASE FROM M_SARANA_HASIL_PEMASARAN WHERE SARANA_ID=$id";  
			$tabel = $this->newtable->generate($query);
			$arrdata = array('table' => $tabel,
							 'idjudul' => 'judulmsarana',
							 'caption_header' => 'Master Sarana &raquo; Hasil Pemasaran',
							 'batal' => site_url().'/home/master/sarana',
							 'cancel' => 'Kembali');
			return $arrdata;
		}else{
			$this->fungsi->redirectMessage('Maaf, halaman yang anda tuju tidak ditemukan.','/home');
		}
	}
	
	function get_pemasaran($id=""){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main","main", true);
			$id = explode(".", $id);
			$arrtujuan = array("Dalam Negeri" => "Dalam Negeri", "Luar Negeri" => "Luar Negeri");
			$arrdata = array('act' => site_url().'/post/master/save/pemasaran/simpan',
							 'batal' => site_url().'/home/master/pemasaran/list/'.$id[0],
							 'id' => $id[0],
							 'seri' => '',
							 'save' => 'Simpan',
							 'cancel' => 'Batal');
			if(count($id)>1){
				$query = "SELECT SARANA_ID, SERI, TUJUAN, JENIS_PRODUK, NEGARA, PERSENTASE FROM M_SARANA_HASIL_PEMASARAN WHERE SARANA_ID=$id[0] AND SERI=$id[1]";
				$res = $sipt->main->get_result($query);
				if($res){
					foreach($query->result_array() as $row){
						$arrdata = array('act' => site_url().'/post/master/save/pemasaran/update',
										 'batal' => site_url().'/home/master/pemasaran/list/'.$id[0],
										 'save' => 'Simpan',
										 'cancel' => 'Kembali',
										 'sess' => $row,
										 'id' => $id[0],
										 'seri' => $id[1]);
					}
				}
			}
			$arrdata['tujuan'] = $arrtujuan;
			return $arrdata;
		}else{
			$this->fungsi->redirectMessage('Maaf, halaman yang anda tuju tidak ditemukan.','/home');
		}
	}
	
	function list_izin($id){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$this->load->library('newtable');
			$this->newtable->hiddens(array('SARANA_ID','SERI'));
			$this->newtable->search(array(array('NOMOR_IZIN', 'Nomor Izin')));
			$this->newtable->action(site_url()."/home/master/izin/list/$id");
			$this->newtable->cidb($this->db);
			$this->newtable->ciuri($this->uri->segment_array());
			$this->newtable->orderby(2);
			$this->newtable->sortby("ASC");
			$this->newtable->columns(array("SARANA_ID","SERI","NOMOR_IZIN","JENIS_IZIN","BENTUK_SEDIAAN","JENIS_SEDIAAN","CONVERT(VARCHAR(10), TANGGAL_IZIN, 103)","CONVERT(VARCHAR(10), TANGGAL_EXPIRED, 103)"));
			$this->newtable->keys(array('SARANA_ID','SERI'));
			$proses = array('Tambah Izin Baru' => array('GET', site_url()."/home/master/izin/new/$id", '0'), 'Edit Izin' => array('GET', site_url()."/home/master/izin/new", '1'), 'Hapus Izin' => array('POST', site_url()."/post/master/hapus/izin/ajax", 'N'));
			$this->newtable->menu($proses);
			$query = "SELECT SARANA_ID, SERI, NOMOR_IZIN AS [NOMOR IZIN], JENIS_IZIN AS [JENIS IZIN], BENTUK_SEDIAAN AS [BENTUK SEDIAAN], JENIS_SEDIAAN AS [JENIS SEDIAAN], CONVERT(VARCHAR(10), TANGGAL_IZIN, 103) AS [TANGGAL IZIN], CONVERT(VARCHAR(10), TANGGAL_EXPIRED, 103) AS [MASA BERLAKU] FROM M_SARANA_IZIN WHERE SARANA_ID=$id";  
			$tabel = $this->newtable->generate($query);
			$arrdata = array('table' => $tabel,
							 'idjudul' => 'judulmsarana',
							 'caption_header' => 'Master Sarana &raquo; Izin Industri / Izin Produksi',
							 'batal' => site_url().'/home/master/sarana',
							 'cancel' => 'Kembali');
			return $arrdata;
		}else{
			$this->fungsi->redirectMessage('Maaf, halaman yang anda tuju tidak ditemukan.','/home');
		}
	}	
	
	function get_izin($id=""){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main","main", true);
			$id = explode(".", $id);
			$jenis_izin = $sipt->main->combobox("SELECT URAIAN FROM M_TABEL WHERE JENIS = 'IZIN'","URAIAN","URAIAN", TRUE);
			$arrdata = array('act' => site_url().'/post/master/save/izin/simpan',
							 'batal' => site_url().'/home/master/izin/list/'.$id[0],
							 'id' => $id[0],
							 'seri' => '',
							 'save' => 'Simpan',
							 'cancel' => 'Batal');
			if(count($id)>1){
				$query = "SELECT SARANA_ID, SERI, JENIS_IZIN, NOMOR_IZIN, BENTUK_SEDIAAN, JENIS_SEDIAAN, CONVERT(VARCHAR(10), TANGGAL_IZIN, 103) AS TANGGAL_IZIN, CONVERT(VARCHAR(10), TANGGAL_EXPIRED, 103) AS TANGGAL_EXPIRED FROM M_SARANA_IZIN WHERE SARANA_ID=$id[0] AND SERI=$id[1]";
				$res = $sipt->main->get_result($query);
				if($res){
					foreach($query->result_array() as $row){
						$arrdata = array('act' => site_url().'/post/master/save/izin/update',
										 'batal' => site_url().'/home/master/izin/list/'.$id[0],
										 'save' => 'Simpan',
										 'cancel' => 'Kembali',
										 'sess' => $row,
										 'id' => $id[0],
										 'seri' => $id[1]);
					}
				}
			}
			$arrdata['jenis_izin'] = $jenis_izin;
			return $arrdata;
		}else{
			$this->fungsi->redirectMessage('Maaf, halaman yang anda tuju tidak ditemukan.','/home');
		}
	}
	
	function list_sertifikat($id){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$this->load->library('newtable');
			$this->newtable->hiddens(array('SARANA_ID','SERI'));
			$this->newtable->search(array(array('NOMOR_SERTIFIKAT', 'Nomor Sertifikat'),array('JENIS', 'Jenis Sertifikat'),array('PEMEBERI_SERTIFIKAT', 'Dikeluarkan Oleh')));
			$this->newtable->action(site_url()."/home/master/sertifikat/list/$id");
			$this->newtable->cidb($this->db);
			$this->newtable->ciuri($this->uri->segment_array());			
			$this->newtable->orderby(2);
			$this->newtable->sortby("ASC");
			$this->newtable->columns(array("SARANA_ID","SERI","CASE JENIS WHEN '01' THEN 'Yang Dimiliki' WHEN '02' THEN 'Yang Diberikan' END","NOMOR_SERTIFIKAT","BENTUK_SEDIAAN","CONVERT(VARCHAR(10), TANGGAL_SERTIFIKAT, 103","PEMBERI_SERTIFIKAT"));
			$this->newtable->keys(array('SARANA_ID','SERI'));
			$proses = array('Tambah Sertifikat Baru' => array('GET', site_url()."/home/master/sertifikat/new/$id", '0'), 'Edit Sertifikat' => array('GET', site_url()."/home/master/sertifikat/new", '1'), 'Hapus Sertifikat' => array('POST', site_url()."/post/master/hapus/serifikat/ajax", 'N'));
			$this->newtable->menu($proses);
			$query = "SELECT SARANA_ID, SERI, CASE JENIS WHEN '01' THEN 'Yang Dimiliki' WHEN '02' THEN 'Yang Diberikan' END AS [JENIS], NOMOR_SERTIFIKAT AS [NOMOR SERTIFIKAT], BENTUK_SEDIAAN AS [BENTUK SEDIAAN], CONVERT(VARCHAR(10), TANGGAL_SERTIFIKAT, 103) AS [TANGGAL SERTIFIKAT], PEMBERI_SERTIFIKAT AS [DIKELURAKAN OLEH] FROM M_SARANA_SERTIFIKAT WHERE SARANA_ID=$id";  
			$tabel = $this->newtable->generate($query);
			$arrdata = array('table' => $tabel,
							 'idjudul' => 'judulmsarana',
							 'caption_header' => 'Master Sarana &raquo; Sertifikat Yang Dimiliki',
							 'batal' => site_url().'/home/master/sarana',
							 'cancel' => 'Kembali');
			return $arrdata;
		}else{
			$this->fungsi->redirectMessage('Maaf, halaman yang anda tuju tidak ditemukan.','/home');
		}
	}	
	
	function get_sertifikat($id=""){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main","main", true);
			$id = explode(".", $id);
			$arr_sertifikat = array("01" => "Sertifikat Yang Dimiliki", "02" => "Sertifikat Yang Diberikan"); 
			$arrdata = array('act' => site_url().'/post/master/save/sertifikat/simpan',
							 'batal' => site_url().'/home/master/sertifikat/list/'.$id[0],
							 'id' => $id[0],
							 'seri' => '',
							 'save' => 'Simpan',
							 'cancel' => 'Batal');
			if(count($id)>1){
				$query = "SELECT SARANA_ID, SERI, JENIS, NOMOR_SERTIFIKAT, BENTUK_SEDIAAN, CONVERT(VARCHAR(10), TANGGAL_SERTIFIKAT, 103) AS TANGGAL_SERTIFIKAT, PEMBERI_SERTIFIKAT FROM M_SARANA_SERTIFIKAT WHERE SARANA_ID=$id[0] AND SERI=$id[1]";
				$res = $sipt->main->get_result($query);
				if($res){
					foreach($query->result_array() as $row){
						$arrdata = array('act' => site_url().'/post/master/save/sertifikat/update',
										 'batal' => site_url().'/home/master/sertifikat/list/'.$id[0],
										 'save' => 'Simpan',
										 'cancel' => 'Kembali',
										 'sess' => $row,
										 'id' => $id[0],
										 'seri' => $id[1]);
					}
				}
			}
			$arrdata['jenis_sertifikat'] = $arr_sertifikat;
			return $arrdata;
		}else{
			$this->fungsi->redirectMessage('Maaf, halaman yang anda tuju tidak ditemukan.','/home');
		}
	}

	function list_jenis_pangan($id){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$this->load->library('newtable');
			$this->newtable->hiddens(array('SARANA_ID','SERI'));
			$this->newtable->search(array(array('NAMA_JENIS', 'Jenis Pangan'),array('NO_PIRT', 'No. PIRT')));
			$this->newtable->action(site_url()."/home/master/pangan/list/$id");
			$this->newtable->cidb($this->db);
			$this->newtable->ciuri($this->uri->segment_array());
			$this->newtable->orderby(2);
			$this->newtable->sortby("ASC");
			$this->newtable->columns(array("SARANA_ID","SERI","JENIS","NAMA_JENIS","NO_PIRT"));
			$this->newtable->keys(array('SARANA_ID','SERI'));
			$proses = array('Tambah Jenis Pangan Baru' => array('GET', site_url()."/home/master/pangan/new/$id", '0'), 'Edit Jenis Pangan' => array('GET', site_url()."/home/master/pangan/new", '1'), 'Hapus Jenis Pangan' => array('POST', site_url()."/post/master/hapus/pangan/ajax", 'N'));
			$this->newtable->menu($proses);
			$query = "SELECT SARANA_ID, SERI, JENIS, NAMA_JENIS AS [JENIS PANGAN], NO_PIRT AS [NO PIRT] FROM M_SARANA_JENIS_PANGAN WHERE SARANA_ID=$id";  
			$tabel = $this->newtable->generate($query);
			$arrdata = array('table' => $tabel,
							 'idjudul' => 'judulmsarana',
							 'caption_header' => 'Master Sarana &raquo; Jenis Pangan',
							 'batal' => site_url().'/home/master/sarana',
							 'cancel' => 'Kembali');
			return $arrdata;
		}else{
			$this->fungsi->redirectMessage('Maaf, halaman yang anda tuju tidak ditemukan.','/home');
		}
	}	
	
	function get_jenis_pangan($id=""){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main","main", true);
			$id = explode(".", $id);
			$arr_jenis = array("Terdaftar" => "Terdaftar", "Tidak Terdaftar" => "Tidak Terdaftar"); 
			$arrdata = array('act' => site_url().'/post/master/save/pangan/simpan',
							 'batal' => site_url().'/home/master/pangan/list/'.$id[0],
							 'id' => $id[0],
							 'seri' => '',
							 'save' => 'Simpan',
							 'cancel' => 'Batal');
			if(count($id)>1){
				$query = "SELECT SARANA_ID, SERI, JENIS, NAMA_JENIS, NO_PIRT FROM M_SARANA_JENIS_PANGAN WHERE SARANA_ID=$id[0] AND SERI=$id[1]";
				$res = $sipt->main->get_result($query);
				if($res){
					foreach($query->result_array() as $row){
						$arrdata = array('act' => site_url().'/post/master/save/pangan/update',
										 'batal' => site_url().'/home/master/pangan/list/'.$id[0],
										 'save' => 'Simpan',
										 'cancel' => 'Kembali',
										 'sess' => $row,
										 'id' => $id[0],
										 'seri' => $id[1]);
					}
				}
			}
			$arrdata['arr_jenis'] = $arr_jenis;
			return $arrdata;
		}else{
			$this->fungsi->redirectMessage('Maaf, halaman yang anda tuju tidak ditemukan.','/home');
		}
	}

	function list_jenis_distribusi($id){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$this->load->library('newtable');
			$this->newtable->hiddens(array('SARANA_ID','SERI'));
			$this->newtable->search(array(array('A.BERTINDAK_SEBAGAI', 'Jenis Distribusi'),array('A.NAMA', 'Nama'),array('A.ALAMAT', 'Alamat')));
			$this->newtable->action(site_url()."/home/master/jenis/list/$id");
			$this->newtable->cidb($this->db);
			$this->newtable->ciuri($this->uri->segment_array());
			$this->newtable->orderby(2);
			$this->newtable->sortby("ASC");
			$this->newtable->columns(array("A.SARANA_ID","A.SERI","A.BERTINDAK_SEBAGAI","A.NAMA","A.ALAMAT"));
			$this->newtable->keys(array('SARANA_ID','SERI'));
			$proses = array('Tambah Jenis Distribusi' => array('GET', site_url()."/home/master/jenis/new/$id", '0'), 'Edit Jenis Distribusi' => array('GET', site_url()."/home/master/jenis/new", '1'), 'Hapus Jenis Distribusi' => array('POST', site_url()."/post/master/hapus/jenis/ajax", 'N'));
			$this->newtable->menu($proses);
			$query = "SELECT A.SARANA_ID, A.SERI, A.BERTINDAK_SEBAGAI AS [BERTINDAK SEBAGAI], A.NAMA, A.ALAMAT FROM M_SARANA_JENIS_DISTRIBUSI A WHERE A.SARANA_ID = $id";  
			$tabel = $this->newtable->generate($query);
			$arrdata = array('table' => $tabel,
							 'idjudul' => 'judulmsarana',
							 'caption_header' => 'Master Sarana &raquo; Jenis Distribusi',
							 'batal' => site_url().'/home/master/sarana',
							 'cancel' => 'Kembali');
			return $arrdata;
		}else{
			$this->fungsi->redirectMessage('Maaf, halaman yang anda tuju tidak ditemukan.','/home');
		}
	}	
	
	function get_jenis_distribusi($id=""){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main","main", true);
			$id = explode(".", $id);
			$arr_sebagai = $sipt->main->combobox("SELECT URAIAN FROM M_TABEL WHERE JENIS='JENIS_DISTRIBUSI'","URAIAN","URAIAN");
			$arrdata = array('act' => site_url().'/post/master/save/jenis/simpan',
							 'batal' => site_url().'/home/master/jenis/list/'.$id[0],
							 'id' => $id[0],
							 'seri' => '',
							 'save' => 'Simpan',
							 'cancel' => 'Batal');
			if(count($id)>1){
				$query = "SELECT SARANA_ID, SERI, BERTINDAK_SEBAGAI, NAMA, ALAMAT FROM M_SARANA_JENIS_DISTRIBUSI WHERE SARANA_ID=$id[0] AND SERI=$id[1]";
				$res = $sipt->main->get_result($query);
				if($res){
					foreach($query->result_array() as $row){
						$arrdata = array('act' => site_url().'/master/master/save/jenis/update',
										 'batal' => site_url().'/home/master/jenis/list/'.$id[0],
										 'save' => 'Simpan',
										 'cancel' => 'Kembali',
										 'sess' => $row,
										 'id' => $id[0],
										 'seri' => $id[1]);
					}

				}
			}
			$arrdata['arr_sebagai'] = $arr_sebagai;
			return $arrdata;
		}else{
			$this->fungsi->redirectMessage('Maaf, halaman yang anda tuju tidak ditemukan.','/home');
		}
	}

	
	function SaveForm($setaction, $isajax){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main","main", true);
			if($setaction=="simpan"){#Insert Mode
				$id = (int)$sipt->main->get_uraian("SELECT MAX(SARANA_ID) AS MAXID FROM M_SARANA", "MAXID") + 1;
				$arr_sarana = array('SARANA_ID' => $id);
				foreach($this->input->post('SARANA') as $a => $b){
					if(!is_array($b)){
						$arr_sarana[$a] = $b;
					}else{
						$arr_sarana[$a] = "";
						$temp = "";
						foreach($b as $c => $d){
						   $arr_sarana[$a] .= $temp.$c."|".$d;
						   $temp = "#";
						}
					} 
				}
				
				if($arr_sarana['JENIS_SARANA'] == "01VV"){
					if(!$this->input->post('PIRT')){
						return "MSG#NO#Mohon periksa kembali isian master data sarana.\n Untuk data jenis pangan tidak boleh kosong (wajib diisi)";
						die();
					}
				}
				
				$arr_sarana['NAMA_SARANA'] = $this->input->post('NAMA_SARANA').", ".$this->input->post('NAMA');
				
				if(array_key_exists('JUMLAH_KARYAWAN', $arr_sarana)){
					if($arr_sarana['JUMLAH_KARYAWAN'] == "") $arr_sarana['JUMLAH_KARYAWAN'] = (float)$arr_sarana['JUMLAH_KARYAWAN'];
				}
				if(array_key_exists('KAPASITAS_PENGOLAHAN', $arr_sarana)){
					if($arr_sarana['KAPASITAS_PENGOLAHAN'] == "") $arr_sarana['KAPASITAS_PENGOLAHAN'] = (float)$arr_sarana['KAPASITAS_PENGOLAHAN'];
				}
				if(array_key_exists('PRODUKSI_PER_HARI', $arr_sarana)){
					if($arr_sarana['PRODUKSI_PER_HARI'] == "") $arr_sarana['PRODUKSI_PER_HARI'] = (float)$arr_sarana['PRODUKSI_PER_HARI'];
				}
				
				if(array_key_exists('KARYAWAN_TETAP_PRIA_OLAH', $arr_sarana)){
					if($arr_sarana['KARYAWAN_TETAP_PRIA_OLAH'] == "") $arr_sarana['KARYAWAN_TETAP_PRIA_OLAH'] = (float)$arr_sarana['KARYAWAN_TETAP_PRIA_OLAH'];
				}

				if(array_key_exists('KARYAWAN_HARIAN_PRIA_OLAH', $arr_sarana)){
					if($arr_sarana['KARYAWAN_HARIAN_PRIA_OLAH'] == "") $arr_sarana['KARYAWAN_HARIAN_PRIA_OLAH'] = (float)$arr_sarana['KARYAWAN_HARIAN_PRIA_OLAH'];
				}

				if(array_key_exists('KARYAWAN_TETAP_PRIA_ADM', $arr_sarana)){
					if($arr_sarana['KARYAWAN_TETAP_PRIA_ADM'] == "") $arr_sarana['KARYAWAN_TETAP_PRIA_ADM'] = (float)$arr_sarana['KARYAWAN_TETAP_PRIA_ADM'];
				}
				if(array_key_exists('KARYAWAN_HARIAN_PRIA_ADM', $arr_sarana)){
					if($arr_sarana['KARYAWAN_HARIAN_PRIA_ADM'] == "") $arr_sarana['KARYAWAN_HARIAN_PRIA_ADM'] = (float)$arr_sarana['KARYAWAN_HARIAN_PRIA_ADM'];
				}
				if(array_key_exists('KARYAWAN_BORONGAN_PRIA_OLAH', $arr_sarana)){
					if($arr_sarana['KARYAWAN_BORONGAN_PRIA_OLAH'] == "") $arr_sarana['KARYAWAN_BORONGAN_PRIA_OLAH'] = (float)$arr_sarana['KARYAWAN_BORONGAN_PRIA_OLAH'];
				}
				if(array_key_exists('KARYAWAN_BORONGAN_PRIA_ADM', $arr_sarana)){
					if($arr_sarana['KARYAWAN_BORONGAN_PRIA_ADM'] == "") $arr_sarana['KARYAWAN_BORONGAN_PRIA_ADM'] = (float)$arr_sarana['KARYAWAN_BORONGAN_PRIA_ADM'];
				}
				if(array_key_exists('KARYAWAN_TETAP_WANITA_OLAH', $arr_sarana)){
					if($arr_sarana['KARYAWAN_TETAP_WANITA_OLAH'] == "") $arr_sarana['KARYAWAN_TETAP_WANITA_OLAH'] = (float)$arr_sarana['KARYAWAN_TETAP_WANITA_OLAH'];
				}
				if(array_key_exists('KARYAWAN_TETAP_WANITA_ADM', $arr_sarana)){
					if($arr_sarana['KARYAWAN_TETAP_WANITA_ADM'] == "") $arr_sarana['KARYAWAN_TETAP_WANITA_ADM'] = (float)$arr_sarana['KARYAWAN_TETAP_WANITA_ADM'];
				}
				if(array_key_exists('KARYAWAN_HARIAN_WANITA_OLAH', $arr_sarana)){
					if($arr_sarana['KARYAWAN_HARIAN_WANITA_OLAH'] == "") $arr_sarana['KARYAWAN_HARIAN_WANITA_OLAH'] = (float)$arr_sarana['KARYAWAN_HARIAN_WANITA_OLAH'];
				}
				if(array_key_exists('KARYAWAN_HARIAN_WANITA_ADM', $arr_sarana)){
					if($arr_sarana['KARYAWAN_HARIAN_WANITA_ADM'] == "") $arr_sarana['KARYAWAN_HARIAN_WANITA_ADM'] = (float)$arr_sarana['KARYAWAN_HARIAN_WANITA_ADM'];
				}
				if(array_key_exists('KARYAWAN_BORONGAN_WANITA_OLAH', $arr_sarana)){
					if($arr_sarana['KARYAWAN_BORONGAN_WANITA_OLAH'] == "") $arr_sarana['KARYAWAN_BORONGAN_WANITA_OLAH'] = (float)$arr_sarana['KARYAWAN_BORONGAN_WANITA_OLAH'];
				}
				if(array_key_exists('KARYAWAN_BORONGAN_WANITA_ADM', $arr_sarana)){
					if($arr_sarana['KARYAWAN_BORONGAN_WANITA_ADM'] == "") $arr_sarana['KARYAWAN_BORONGAN_WANITA_ADM'] = (float)$arr_sarana['KARYAWAN_BORONGAN_WANITA_OLAH'];
				}
				if(array_key_exists('KAPASITAS_ES', $arr_sarana)){
					if($arr_sarana['KAPASITAS_ES'] == "") $arr_sarana['KAPASITAS_ES'] = (float)$arr_sarana['KAPASITAS_ES'];
				}
				if(array_key_exists('KEBUTUHAN_ES', $arr_sarana)){
					if($arr_sarana['KEBUTUHAN_ES'] == "") $arr_sarana['KEBUTUHAN_ES'] = (float)$arr_sarana['KEBUTUHAN_ES'];
				}
				if(array_key_exists('KAPASITAS_AIR_TANAH', $arr_sarana)){
					if($arr_sarana['KAPASITAS_AIR_TANAH'] == "") $arr_sarana['KAPASITAS_AIR_TANAH'] = (float)$arr_sarana['KAPASITAS_AIR_TANAH'];
				}
				if(array_key_exists('KAPASITAS_AIR_LEDENG', $arr_sarana)){
					if($arr_sarana['KAPASITAS_AIR_LEDENG'] == "") $arr_sarana['KAPASITAS_AIR_LEDENG'] = (float)$arr_sarana['KAPASITAS_AIR_LEDENG'];
				}
				$arr_sarana['FLAG'] = '0';
				if($arr_sarana['JENIS_SARANA'] == "02BB"){
					$sipt->main->get_kegiatan("Menambahkan Data Sarana : ".$this->input->post('NAMA_SARANA'));		
					$this->db->insert('M_LOG_SARANA_BB', array('SARANA_ID' => $id, 'WAKTU' => 'GETDATE()', 'KETERANGAN' => 'Simpan Data '.$this->input->post('NAMA_SARANA'), 'SARANA_BB' => $arr_sarana['STATUS_BB'], 'CREATE_BY' => $this->newsession->userdata('SESS_USER_ID')));
				}else{
					$sipt->main->get_kegiatan("Menambahkan Data Sarana : ".$this->input->post('NAMA_SARANA').", ".$this->input->post('NAMA'));		
				}
				if($this->db->insert('M_SARANA', $arr_sarana)){
					if($arr_sarana['JENIS_SARANA'] == "01VV"){
						if($this->input->post('PIRT')){					
							$arrpirt = $this->input->post('PIRT');
							$arrkeys = array_keys($arrpirt);
							for($i=0;$i<count($arrpirt[$arrkeys[0]]);$i++){
								$docpirt = array('SARANA_ID' => $id,
												 'SERI' => (int)$sipt->main->get_uraian("SELECT MAX(SERI) AS MAXSERI FROM T_SARANA_JENIS_PANGAN WHERE SARANA_ID = '".$id."'","MAXSERI") + 1,
												 'CREATE_BY' => $this->newsession->userdata('SESS_USER_ID'),
												 'CREATE_DATE' => 'GETDATE()');
								for($j=0;$j<count($arrkeys);$j++){
									$docpirt[$arrkeys[$j]] = $arrpirt[$arrkeys[$j]][$i];
								}
								$this->db->insert('T_SARANA_JENIS_PANGAN', $docpirt);
							}
						}
					}
					return "MSG#YES#Data berhasil disimpan#".site_url().'/home/master/sarana';
				}
				
				if($this->db->insert('M_SARANA', $arr_sarana)){
					
				}
				return "MSG#YES#Data berhasil disimpan#".site_url().'/home/master/sarana';
				if($isajax!="ajax"){
					redirect(base_url());
					exit();
				}
			}
			else if($setaction=="update"){#Update Mode
				$id = $this->input->post('ID');
				$arr_sarana = array();
				foreach($this->input->post('SARANA') as $a => $b){
					if(!is_array($b)){
						$arr_sarana[$a] = $b;
					}else{
						$arr_sarana[$a] = "";
						$temp = "";
						foreach($b as $c => $d){
						   $arr_sarana[$a] .= $temp.$c."|".$d;
						   $temp = "#";
						}
					} 
				}
				if($arr_sarana['JENIS_SARANA'] == "01VV"){
					if(!$this->input->post('PIRT')){
						return "MSG#NO#Mohon periksa kembali isian master data sarana.\n Untuk data jenis pangan tidak boleh kosong (wajib diisi)";
						die();
					}
				}
				$arr_sarana['NAMA_SARANA'] = $this->input->post('NAMA_SARANA').", ".$this->input->post('NAMA');
				if(array_key_exists('JUMLAH_KARYAWAN', $arr_sarana)){
					if($arr_sarana['JUMLAH_KARYAWAN'] == "") $arr_sarana['JUMLAH_KARYAWAN'] = (float)$arr_sarana['JUMLAH_KARYAWAN'];
				}
				if(array_key_exists('KAPASITAS_PENGOLAHAN', $arr_sarana)){
					if($arr_sarana['KAPASITAS_PENGOLAHAN'] == "") $arr_sarana['KAPASITAS_PENGOLAHAN'] = (float)$arr_sarana['KAPASITAS_PENGOLAHAN'];
				}
				if(array_key_exists('PRODUKSI_PER_HARI', $arr_sarana)){
					if($arr_sarana['PRODUKSI_PER_HARI'] == "") $arr_sarana['PRODUKSI_PER_HARI'] = (float)$arr_sarana['PRODUKSI_PER_HARI'];
				}
				
				if(array_key_exists('KARYAWAN_TETAP_PRIA_OLAH', $arr_sarana)){
					if($arr_sarana['KARYAWAN_TETAP_PRIA_OLAH'] == "") $arr_sarana['KARYAWAN_TETAP_PRIA_OLAH'] = (float)$arr_sarana['KARYAWAN_TETAP_PRIA_OLAH'];
				}

				if(array_key_exists('KARYAWAN_HARIAN_PRIA_OLAH', $arr_sarana)){
					if($arr_sarana['KARYAWAN_HARIAN_PRIA_OLAH'] == "") $arr_sarana['KARYAWAN_HARIAN_PRIA_OLAH'] = (float)$arr_sarana['KARYAWAN_HARIAN_PRIA_OLAH'];
				}

				if(array_key_exists('KARYAWAN_TETAP_PRIA_ADM', $arr_sarana)){
					if($arr_sarana['KARYAWAN_TETAP_PRIA_ADM'] == "") $arr_sarana['KARYAWAN_TETAP_PRIA_ADM'] = (float)$arr_sarana['KARYAWAN_TETAP_PRIA_ADM'];
				}
				if(array_key_exists('KARYAWAN_HARIAN_PRIA_ADM', $arr_sarana)){
					if($arr_sarana['KARYAWAN_HARIAN_PRIA_ADM'] == "") $arr_sarana['KARYAWAN_HARIAN_PRIA_ADM'] = (float)$arr_sarana['KARYAWAN_HARIAN_PRIA_ADM'];
				}
				if(array_key_exists('KARYAWAN_BORONGAN_PRIA_OLAH', $arr_sarana)){
					if($arr_sarana['KARYAWAN_BORONGAN_PRIA_OLAH'] == "") $arr_sarana['KARYAWAN_BORONGAN_PRIA_OLAH'] = (float)$arr_sarana['KARYAWAN_BORONGAN_PRIA_OLAH'];
				}
				if(array_key_exists('KARYAWAN_BORONGAN_PRIA_ADM', $arr_sarana)){
					if($arr_sarana['KARYAWAN_BORONGAN_PRIA_ADM'] == "") $arr_sarana['KARYAWAN_BORONGAN_PRIA_ADM'] = (float)$arr_sarana['KARYAWAN_BORONGAN_PRIA_ADM'];
				}
				if(array_key_exists('KARYAWAN_TETAP_WANITA_OLAH', $arr_sarana)){
					if($arr_sarana['KARYAWAN_TETAP_WANITA_OLAH'] == "") $arr_sarana['KARYAWAN_TETAP_WANITA_OLAH'] = (float)$arr_sarana['KARYAWAN_TETAP_WANITA_OLAH'];
				}
				if(array_key_exists('KARYAWAN_TETAP_WANITA_ADM', $arr_sarana)){
					if($arr_sarana['KARYAWAN_TETAP_WANITA_ADM'] == "") $arr_sarana['KARYAWAN_TETAP_WANITA_ADM'] = (float)$arr_sarana['KARYAWAN_TETAP_WANITA_ADM'];
				}
				if(array_key_exists('KARYAWAN_HARIAN_WANITA_OLAH', $arr_sarana)){
					if($arr_sarana['KARYAWAN_HARIAN_WANITA_OLAH'] == "") $arr_sarana['KARYAWAN_HARIAN_WANITA_OLAH'] = (float)$arr_sarana['KARYAWAN_HARIAN_WANITA_OLAH'];
				}
				if(array_key_exists('KARYAWAN_HARIAN_WANITA_ADM', $arr_sarana)){
					if($arr_sarana['KARYAWAN_HARIAN_WANITA_ADM'] == "") $arr_sarana['KARYAWAN_HARIAN_WANITA_ADM'] = (float)$arr_sarana['KARYAWAN_HARIAN_WANITA_ADM'];
				}
				if(array_key_exists('KARYAWAN_BORONGAN_WANITA_OLAH', $arr_sarana)){
					if($arr_sarana['KARYAWAN_BORONGAN_WANITA_OLAH'] == "") $arr_sarana['KARYAWAN_BORONGAN_WANITA_OLAH'] = (float)$arr_sarana['KARYAWAN_BORONGAN_WANITA_OLAH'];
				}
				if(array_key_exists('KARYAWAN_BORONGAN_WANITA_ADM', $arr_sarana)){
					if($arr_sarana['KARYAWAN_BORONGAN_WANITA_ADM'] == "") $arr_sarana['KARYAWAN_BORONGAN_WANITA_ADM'] = (float)$arr_sarana['KARYAWAN_BORONGAN_WANITA_OLAH'];
				}
				if(array_key_exists('KAPASITAS_ES', $arr_sarana)){
					if($arr_sarana['KAPASITAS_ES'] == "") $arr_sarana['KAPASITAS_ES'] = (float)$arr_sarana['KAPASITAS_ES'];
				}
				if(array_key_exists('KEBUTUHAN_ES', $arr_sarana)){
					if($arr_sarana['KEBUTUHAN_ES'] == "") $arr_sarana['KEBUTUHAN_ES'] = (float)$arr_sarana['KEBUTUHAN_ES'];
				}
				if(array_key_exists('KAPASITAS_AIR_TANAH', $arr_sarana)){
					if($arr_sarana['KAPASITAS_AIR_TANAH'] == "") $arr_sarana['KAPASITAS_AIR_TANAH'] = (float)$arr_sarana['KAPASITAS_AIR_TANAH'];
				}
				if(array_key_exists('KAPASITAS_AIR_LEDENG', $arr_sarana)){
					if($arr_sarana['KAPASITAS_AIR_LEDENG'] == "") $arr_sarana['KAPASITAS_AIR_LEDENG'] = (float)$arr_sarana['KAPASITAS_AIR_LEDENG'];
				}
				
					
				$this->db->where(array("SARANA_ID" => $id));
				if($this->db->update('M_SARANA', $arr_sarana)){
					if($arr_sarana['JENIS_SARANA'] == "02BB"){
						$sipt->main->get_kegiatan("Menambahkan Data Sarana : ".$this->input->post('NAMA_SARANA'));		
						$this->db->insert('M_LOG_SARANA_BB', array('SARANA_ID' => $id, 'WAKTU' => 'GETDATE()', 'KETERANGAN' => 'Update Data '.$this->input->post('NAMA_SARANA'), 'SARANA_BB' => $arr_sarana['STATUS_BB'], 'CREATE_BY' => $this->newsession->userdata('SESS_USER_ID')));
					}
					
					if($arr_sarana['JENIS_SARANA'] == "01VV"){
						if($this->input->post('PIRT')){		
							$ada = (int)$sipt->main->get_uraian("SELECT COUNT(*) AS JML FROM T_SARANA_JENIS_PANGAN WHERE SARANA_ID = '".$id."'","JML");
							if($ada > 0){
								$this->db->where('SARANA_ID', $id);
								$this->db->delete('T_SARANA_JENIS_PANGAN');
								if($this->db->affected_rows() > 0){
									$arrpirt = $this->input->post('PIRT');
									$arrkeys = array_keys($arrpirt);
									for($i=0;$i<count($arrpirt[$arrkeys[0]]);$i++){
										$docpirt = array('SARANA_ID' => $id,
														 'SERI' => (int)$sipt->main->get_uraian("SELECT MAX(SERI) AS MAXSERI FROM T_SARANA_JENIS_PANGAN WHERE SARANA_ID = '".$id."'","MAXSERI") + 1,
														 'CREATE_BY' => $this->newsession->userdata('SESS_USER_ID'),
														 'CREATE_DATE' => 'GETDATE()');
										for($j=0;$j<count($arrkeys);$j++){
											$docpirt[$arrkeys[$j]] = $arrpirt[$arrkeys[$j]][$i];
										}
										$this->db->insert('T_SARANA_JENIS_PANGAN', $docpirt);
									}
								}
							}else{
								$arrpirt = $this->input->post('PIRT');
								$arrkeys = array_keys($arrpirt);
								for($i=0;$i<count($arrpirt[$arrkeys[0]]);$i++){
									$docpirt = array('SARANA_ID' => $id,
													 'SERI' => (int)$sipt->main->get_uraian("SELECT MAX(SERI) AS MAXSERI FROM T_SARANA_JENIS_PANGAN WHERE SARANA_ID = '".$id."'","MAXSERI") + 1,
													 'CREATE_BY' => $this->newsession->userdata('SESS_USER_ID'),
													 'CREATE_DATE' => 'GETDATE()');
									for($j=0;$j<count($arrkeys);$j++){
										$docpirt[$arrkeys[$j]] = $arrpirt[$arrkeys[$j]][$i];
									}
									$this->db->insert('T_SARANA_JENIS_PANGAN', $docpirt);
								}
							}
						}
					}
	
					$sipt->main->get_kegiatan("Mengupdate Data Sarana : ".$this->input->post('NAMA_SARANA').", ".$this->input->post('NAMA'));

					return "MSG#YES#Data berhasil disimpan#".site_url().'/home/master/sarana';
				}
				if($isajax!="ajax"){
					redirect(base_url());
					exit();
				}
			}
			
			if($isajax!="ajax"){
				redirect(site_url().'/home/master/sarana');
				exit();
			}
			return "MSG#NO#Data gagal disimpan";
		}
		else{
			$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
		}
	}

	function SavePemasaran($setaction, $isajax){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main","main", true);
			$id = $this->input->post('ID');
			if($setaction=="simpan"){#Insert Mode
				$seri = (int)$sipt->main->get_uraian("SELECT MAX(SERI) AS MAXSERI FROM M_SARANA_HASIL_PEMASARAN WHERE SARANA_ID=$id", "MAXSERI") + 1;
				$arr_pemasaran = array('SARANA_ID' => $this->input->post('ID'),
									   'SERI' => $seri);
				foreach($this->input->post('PEMASARAN') as $a => $b){
					$arr_pemasaran[$a] = $b;
				}
				$arr_pemasaran['PERSENTASE'] = (float)$arr_pemasaran['PERSENTASE'];
				if($this->db->insert('M_SARANA_HASIL_PEMASARAN', $arr_pemasaran)) return "MSG#YES#Data berhasil disimpan#".site_url().'/home/master/pemasaran/list/'.$this->input->post('ID');
				if($isajax!="ajax"){
					redirect(base_url());
					exit();
				}
			}
			else if($setaction=="update"){#Update Mode
				foreach($this->input->post('PEMASARAN') as $a => $b){
					$arr_pemasaran[$a] = $b;
				}
				$arr_pemasaran['PERSENTASE'] = (float)$arr_pemasaran['PERSENTASE'];
				$this->db->where(array("SARANA_ID" => $id, 'SERI' => $this->input->post('SERI')));
				if($this->db->update('M_SARANA_HASIL_PEMASARAN', $arr_pemasaran))return "MSG#YES#Data berhasil disimpan#".site_url().'/home/master/pemasaran/list/'.$id;
				if($isajax!="ajax"){
					redirect(base_url());
					exit();
				}
			}
			
			if($isajax!="ajax"){
				redirect(site_url().'/home/master/sarana');
				exit();
			}
			return "MSG#NO#Data gagal disimpan";
		}
		else{
			$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
		}
	}

	function SaveIzin($setaction, $isajax){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main","main", true);
			$id = $this->input->post('ID');
			if($setaction=="simpan"){#Insert Mode
				$seri = (int)$sipt->main->get_uraian("SELECT MAX(SERI) AS MAXSERI FROM M_SARANA_IZIN WHERE SARANA_ID=$id", "MAXSERI") + 1;
				$arr_pemasaran = array('SARANA_ID' => $this->input->post('ID'),
									   'SERI' => $seri);
				foreach($this->input->post('IZIN') as $a => $b){
					$arr_pemasaran[$a] = $b;
				}
				if($this->db->insert('M_SARANA_IZIN', $arr_pemasaran)) return "MSG#YES#Data berhasil disimpan#".site_url().'/home/master/izin/list/'.$this->input->post('ID');
				if($isajax!="ajax"){
					redirect(base_url());
					exit();
				}
			}
			else if($setaction=="update"){#Update Mode
				foreach($this->input->post('IZIN') as $a => $b){
					$arr_pemasaran[$a] = $b;
				}
				$this->db->where(array("SARANA_ID" => $id, 'SERI' => $this->input->post('SERI')));
				if($this->db->update('M_SARANA_IZIN', $arr_pemasaran))return "MSG#YES#Data berhasil disimpan#".site_url().'/home/master/izin/list/'.$id;
				if($isajax!="ajax"){
					redirect(base_url());
					exit();
				}
			}
			
			if($isajax!="ajax"){
				redirect(site_url().'/home/master/sarana');
				exit();
			}
			return "MSG#NO#Data gagal disimpan";
		}
		else{
			$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
		}
	}

	function SaveSertifikat($setaction, $isajax){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main","main", true);
			$id = $this->input->post('ID');
			if($setaction=="simpan"){#Insert Mode
				$seri = (int)$sipt->main->get_uraian("SELECT MAX(SERI) AS MAXSERI FROM M_SARANA_SERTIFIKAT WHERE SARANA_ID=$id", "MAXSERI") + 1;
				$arr_pemasaran = array('SARANA_ID' => $this->input->post('ID'),
									   'SERI' => $seri);
				foreach($this->input->post('SERTIFIKAT') as $a => $b){
					$arr_pemasaran[$a] = $b;
				}
				if($this->db->insert('M_SARANA_SERTIFIKAT', $arr_pemasaran)) return "MSG#YES#Data berhasil disimpan#".site_url().'/home/master/sertifikat/list/'.$this->input->post('ID');
				if($isajax!="ajax"){
					redirect(base_url());
					exit();
				}
			}
			else if($setaction=="update"){#Update Mode
				foreach($this->input->post('SERTIFIKAT') as $a => $b){
					$arr_pemasaran[$a] = $b;
				}
				$this->db->where(array("SARANA_ID" => $id, 'SERI' => $this->input->post('SERI')));
				if($this->db->update('M_SARANA_SERTIFIKAT', $arr_pemasaran))return "MSG#YES#Data berhasil disimpan#".site_url().'/home/master/sertifikat/list/'.$id;
				if($isajax!="ajax"){
					redirect(base_url());
					exit();
				}
			}
			
			if($isajax!="ajax"){
				redirect(site_url().'/home/master/sarana');
				exit();
			}
			return "MSG#NO#Data gagal disimpan";
		}
		else{
			$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
		}
	}

	function SavePangan($setaction, $isajax){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main","main", true);
			$id = $this->input->post('ID');
			if($setaction=="simpan"){#Insert Mode
				$seri = (int)$sipt->main->get_uraian("SELECT MAX(SERI) AS MAXSERI FROM M_SARANA_JENIS_PANGAN WHERE SARANA_ID=$id", "MAXSERI") + 1;
				$arr_pemasaran = array('SARANA_ID' => $this->input->post('ID'),
									   'SERI' => $seri);
				foreach($this->input->post('JENIS') as $a => $b){
					$arr_pemasaran[$a] = $b;
				}
				if($this->db->insert('M_SARANA_JENIS_PANGAN', $arr_pemasaran)) return "MSG#YES#Data berhasil disimpan#".site_url().'/home/master/pangan/list/'.$this->input->post('ID');
				if($isajax!="ajax"){
					redirect(base_url());
					exit();
				}
			}
			else if($setaction=="update"){#Update Mode
				foreach($this->input->post('JENIS') as $a => $b){
					$arr_pemasaran[$a] = $b;
				}
				$this->db->where(array("SARANA_ID" => $id, 'SERI' => $this->input->post('SERI')));
				if($this->db->update('M_SARANA_JENIS_PANGAN', $arr_pemasaran))return "MSG#YES#Data berhasil disimpan#".site_url().'/home/master/pangan/list/'.$id;
				if($isajax!="ajax"){
					redirect(base_url());
					exit();
				}
			}
			
			if($isajax!="ajax"){
				redirect(site_url().'/home/master/sarana');
				exit();
			}
			return "MSG#NO#Data gagal disimpan";
		}
		else{
			$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
		}
	}

	function SaveJenisDistribusi($setaction, $isajax){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main","main", true);
			$id = $this->input->post('ID');
			if($setaction=="simpan"){#Insert Mode
				$seri = (int)$sipt->main->get_uraian("SELECT MAX(SERI) AS MAXSERI FROM M_SARANA_JENIS_DISTRIBUSI WHERE SARANA_ID=$id", "MAXSERI") + 1;
				$arr_pemasaran = array('SARANA_ID' => $this->input->post('ID'),
									   'SERI' => $seri);
				foreach($this->input->post('GOLONGAN') as $a => $b){
					$arr_pemasaran[$a] = $b;
				}
				if($this->db->insert('M_SARANA_JENIS_DISTRIBUSI', $arr_pemasaran)) return "MSG#YES#Data berhasil disimpan#".site_url().'/home/master/jenis/list/'.$this->input->post('ID');
				if($isajax!="ajax"){
					redirect(base_url());
					exit();
				}
			}
			else if($setaction=="update"){#Update Mode
				foreach($this->input->post('GOLONGAN') as $a => $b){
					$arr_pemasaran[$a] = $b;
				}
				$this->db->where(array("SARANA_ID" => $id, 'SERI' => $this->input->post('SERI')));
				if($this->db->update('M_SARANA_JENIS_DISTRIBUSI', $arr_pemasaran))return "MSG#YES#Data berhasil disimpan#".site_url().'/home/master/jenis/list/'.$id;
				if($isajax!="ajax"){
					redirect(base_url());
					exit();
				}
			}
			
			if($isajax!="ajax"){
				redirect(site_url().'/home/master/sarana');
				exit();
			}
			return "MSG#NO#Data gagal disimpan";
		}
		else{
			$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
		}
	}
	
	function DeleteSarana($isajax){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$ret = "MSG#Hapus Sarana Gagal.";
			foreach($this->input->post('tb_chk') as $chkitem){
				$arrchk = explode(".", $chkitem);
				$this->db->where('SARANA_ID', $arrchk[0]);
				if($this->db->delete('T_PEMERIKSAAN')){
					$this->db->where('SARANA_ID', $arrchk[0]);
					$this->db->delete('M_SARANA');
					$ret = "MSG#Data Sarana Berhasil Di Hapus.#";
				}
			}
			if($isajax!="ajax"){
				redirect(base_url());
				exit();			  
			}
			return $ret;
		}
		$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
	}
	
	function DeletePemasaran($isajax){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$ret = "MSG#Hapus Pemasaran Gagal.";
			foreach($this->input->post('tb_chk') as $chkitem){
				$arrchk = explode(".", $chkitem);
				$this->db->where('SARANA_ID', $arrchk[0]);
				$this->db->where('SERI', $arrchk[1]);
				if($this->db->delete('M_SARANA_HASIL_PEMASARAN')) $ret = "MSG#Hapus Pemasaran Berhasil.#".site_url().'/home/master/pemasaran/list/'.$arrchk[0];
			}
			if($isajax!="ajax"){
				redirect(base_url());
				exit();			  
			}
			return $ret;
		}
		$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
	}
	
	function DeleteIzin($isajax){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$ret = "MSG#Hapus Izin Gagal.";
			foreach($this->input->post('tb_chk') as $chkitem){
				$arrchk = explode(".", $chkitem);
				$this->db->where('SARANA_ID', $arrchk[0]);
				$this->db->where('SERI', $arrchk[1]);
				if($this->db->delete('M_SARANA_IZIN')) $ret = "MSG#Hapus Izin Berhasil.#".site_url().'/home/master/izin/list/'.$arrchk[0];
			}
			if($isajax!="ajax"){
				redirect(base_url());
				exit();			  
			}
			return $ret;
		}
		$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
	}

	function DeleteSertifikat($isajax){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$ret = "MSG#Hapus Sertifikat Gagal.";
			foreach($this->input->post('tb_chk') as $chkitem){
				$arrchk = explode(".", $chkitem);
				$this->db->where('SARANA_ID', $arrchk[0]);
				$this->db->where('SERI', $arrchk[1]);
				if($this->db->delete('M_SARANA_SERTIFIKAT')) $ret = "MSG#Hapus Sertifikat Berhasil.#".site_url().'/home/master/sertifikat/list/'.$arrchk[0];
			}
			if($isajax!="ajax"){
				redirect(base_url());
				exit();			  
			}
			return $ret;
		}
		$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
	}

	function DeletePangan($isajax){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$ret = "MSG#Hapus Pangan Gagal.";
			foreach($this->input->post('tb_chk') as $chkitem){
				$arrchk = explode(".", $chkitem);
				$this->db->where('SARANA_ID', $arrchk[0]);
				$this->db->where('SERI', $arrchk[1]);
				if($this->db->delete('M_SARANA_JENIS_PANGAN')) $ret = "MSG#Hapus Jenis Pangan Berhasil.#".site_url().'/home/master/pangan/list/'.$arrchk[0];
			}
			if($isajax!="ajax"){
				redirect(base_url());
				exit();			  
			}
			return $ret;
		}
		$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
	}

	function DeleteJenisDistribusi($isajax){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$ret = "MSG#Hapus Jenis Distribusi Sarana Gagal.";
			foreach($this->input->post('tb_chk') as $chkitem){
				$arrchk = explode(".", $chkitem);
				$this->db->where('SARANA_ID', $arrchk[0]);
				$this->db->where('SERI', $arrchk[1]);
				if($this->db->delete('M_SARANA_JENIS_DISTRIBUSI')) $ret = "MSG#Hapus Jenis Sarana Distribusi Sarana Berhasil.#".site_url().'/home/master/jenis/list/'.$arrchk[0];
			}
			if($isajax!="ajax"){
				redirect(base_url());
				exit();			  
			}
			return $ret;
		}
		$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
	}
	
	function view_sarana(){
		$this->load->library('newtable_ajax');
		if(in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))){	
			$query = "SELECT A.SARANA_ID,UPPER(A.NAMA_SARANA) AS [NAMA SARANA], A.ALAMAT_1 + '<div>'+B.NAMA_PROPINSI+'</div><div>'+C.NAMA_PROPINSI+'</div>' AS ALAMAT FROM M_SARANA A LEFT JOIN M_PROPINSI B ON A.KOTA = B.PROPINSI_ID LEFT JOIN M_PROPINSI C ON A.PROPINSI = C.PROPINSI_ID";
			$this->newtable_ajax->columns(array("A.SARANA_ID", "UPPER(A.NAMA_SARANA)", "A.ALAMAT_1 + '<div>'+B.NAMA_PROPINSI+'</div><div>'+C.NAMA_PROPINSI+'</div>'"));
		}else{
			if($this->newsession->userdata('SESS_PROP_ID') == '7100')
				$prop = "'7100','8200'";
			else
				$prop = "'".$this->newsession->userdata('SESS_PROP_ID')."'";			  
			$query = "SELECT A.SARANA_ID, UPPER(A.NAMA_SARANA) AS [NAMA SARANA], A.ALAMAT_1 + '<div>'+B.NAMA_PROPINSI+'</div><div>'+C.NAMA_PROPINSI+'</div>' AS ALAMAT FROM M_SARANA A LEFT JOIN M_PROPINSI B ON A.KOTA = B.PROPINSI_ID LEFT JOIN M_PROPINSI C ON A.PROPINSI = C.PROPINSI_ID WHERE A.PROPINSI IN($prop)";
			$this->newtable_ajax->columns(array("A.SARANA_ID", "UPPER(A.NAMA_SARANA)", "A.ALAMAT_1 + '<div>'+B.NAMA_PROPINSI+'</div><div>'+C.NAMA_PROPINSI+'</div>'"));
		}
		$this->newtable_ajax->hiddens(array('SARANA_ID'));
		$this->newtable_ajax->search(array(array('A.NAMA_SARANA', 'Berdasarkan Nama Sarana'), array('A.ALAMAT_1', 'Berdasarkan Alamat'), array('B.NAMA_PROPINSI', 'Berdasarkan Kota'), array('C.NAMA_PROPINSI', 'Berdasarkan Propinsi')));
		$this->newtable_ajax->width(array('NAMA SARANA' => 300, 'ALAMAT' => 500));
		$ciuri = (!$this->input->post("ajax"))?$this->uri->segment_array():$this->input->post("uri");		
		$this->newtable_ajax->action(site_url()."/master/master/browse");
		$this->newtable_ajax->cidb($this->db);
		$this->newtable_ajax->ciuri($ciuri);
		$this->newtable_ajax->orderby(2);
		$this->newtable_ajax->sortby("ASC");
		$this->newtable_ajax->detils_tipe=("pilih");
		$this->newtable_ajax->keys(array('SARANA_ID','NAMA SARANA'));
		$this->newtable_ajax->set_tbviews("tb_sarana");
		$this->newtable_ajax->formField("fpemeriksaan_");
		$this->newtable_ajax->indexField(array('SARANA_ID','NAMA SARANA'));
		$this->newtable_ajax->clear(); 
		$tabel = $this->newtable_ajax->generate($query);	
		$arrdata = array('tabel' => $tabel, 'tb_views' => 'tb_sarana');
		if($this->input->post("ajax"))
			echo $tabel;	
		else 
			return $arrdata;
	}
	

}
?>