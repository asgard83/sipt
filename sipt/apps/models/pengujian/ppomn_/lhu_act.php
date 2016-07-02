<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR);
class Lhu_act extends Model{
	function list_lhu($id){
		if((in_array('3', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('4', $this->newsession->userdata('SESS_KODE_ROLE')) && in_array('02', $this->newsession->userdata('SESS_JENIS_PELAPORAN'))) && $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$this->load->library('newtable');
			if($id == "draft"){
				$judul = "Laporan Hasil Uji";
				$query = "SELECT B.CP_ID, A.KODE_SAMPEL, B.STATUS, dbo.FORMAT_NOMOR('SPL', A.KODE_SAMPEL) AS [KODE SAMPEL], A.NAMA_SAMPEL + '<div>' + A.KEMASAN + '</div><div>' + A.NOMOR_REGISTRASI + '</div>' AS [IDENTITAS SAMPEL], dbo.KATEGORI(A.KOMODITI) + '<div>' + dbo.KATEGORI(A.KATEGORI) + '</div>' AS KOMODITI FROM T_M_SAMPEL A LEFT JOIN T_CP B ON A.KODE_SAMPEL = B.KODE_SAMPEL WHERE B.BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND B.MT = '".$this->newsession->userdata('SESS_USER_ID')."' AND B.STATUS = '40202'";
				$this->newtable->columns(array("B.CP_ID", "A.KODE_SAMPEL", "B.STATUS", array("dbo.FORMAT_NOMOR('SPL', A.KODE_SAMPEL)",site_url()."/home/ppomn/lhu/new/{CP_ID}.{KODE_SAMPEL}.{STATUS}"), "A.NAMA_SAMPEL + '<div>' + A.KEMASAN + '</div><div>' + A.NOMOR_REGISTRASI + '</div>'", "dbo.KATEGORI(A.KOMODITI) + '<div>' + dbo.KATEGORI(A.KATEGORI) + '</div>'"));
				$proses['Preview Data'] = array('GET', site_url()."/home/pengujian/lhu/new", '1');
			}else if($id == "data"){
				$judul = "Laporan Hasil Uji";
				$query = "SELECT B.CP_ID, A.KODE_SAMPEL, B.STATUS, dbo.FORMAT_NOMOR('SPL', A.KODE_SAMPEL) AS [KODE SAMPEL], A.NAMA_SAMPEL + '<div>' + A.KEMASAN + '</div><div>' + A.NOMOR_REGISTRASI + '</div>' AS [IDENTITAS SAMPEL], dbo.KATEGORI(A.KOMODITI) + '<div>' + dbo.KATEGORI(A.KATEGORI) + '</div>' AS KOMODITI FROM T_M_SAMPEL A LEFT JOIN T_CP B ON A.KODE_SAMPEL = B.KODE_SAMPEL WHERE B.BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND B.CREATE_BY = '".$this->newsession->userdata('SESS_USER_ID')."' AND B.STATUS = '30203'";
				$this->newtable->columns(array("B.CP_ID","A.KODE_SAMPEL", "B.STATUS",array("dbo.FORMAT_NOMOR('SPL', A.KODE_SAMPEL)",site_url()."/home/ppomn/lhu/konsep/{CP_ID}.{KODE_SAMPEL}.{STATUS}"), "A.NAMA_SAMPEL + '<div>' + A.KEMASAN + '</div><div>' + A.NOMOR_REGISTRASI + '</div>'", "dbo.KATEGORI(A.KOMODITI) + '<div>' + dbo.KATEGORI(A.KATEGORI) + '</div>'"));
				#if(in_array('B3',$this->newsession->userdata('SESS_SUB_SARANA'))){
					#$proses['Preview Data'] = array('GET', site_url()."/home/pengujian/lhu/new", '1');
				#}else{
					#$proses['Konsep Pelaporan'] = array('GET', site_url()."/home/pengujian/konsep/new", '1');
					$proses['Konsep Pelaporan'] = array('GET', site_url()."/home/ppomn/lhu/konsep", '1');
				#}
		    }else if($id == "all"){
				$judul = "Konsep Pelaporan / Sertifikat";
				if(in_array('3', $this->newsession->userdata('SESS_KODE_ROLE'))){
					$query = "SELECT B.CP_ID, A.KODE_SAMPEL, B.STATUS, dbo.FORMAT_NOMOR('SPL', A.KODE_SAMPEL) AS [KODE SAMPEL], A.NAMA_SAMPEL + '<div>' + A.KEMASAN + '</div><div>' + A.NOMOR_REGISTRASI + '</div>' AS [IDENTITAS SAMPEL], dbo.KATEGORI(A.KOMODITI) + '<div>' + dbo.KATEGORI(A.KATEGORI) + '</div>' AS KOMODITI FROM T_M_SAMPEL A LEFT JOIN T_CP B ON A.KODE_SAMPEL = B.KODE_SAMPEL WHERE B.BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND B.CREATE_BY = '".$this->newsession->userdata('SESS_USER_ID')."' AND B.STATUS IN('40204','50202')";
					$proses['Cetak Data LHU'] = array('GETNEW', site_url()."/topdf/lhu/prints", '1');
				}
				#Revisi tanggal 27 12 2013 16:05
				if(in_array('4', $this->newsession->userdata('SESS_KODE_ROLE'))){
					$query = "SELECT B.CP_ID, A.KODE_SAMPEL, B.STATUS, dbo.FORMAT_NOMOR('SPL', A.KODE_SAMPEL) AS [KODE SAMPEL], A.NAMA_SAMPEL + '<div>' + A.KEMASAN + '</div><div>' + A.NOMOR_REGISTRASI + '</div>' AS [IDENTITAS SAMPEL], dbo.KATEGORI(A.KOMODITI) + '<div>' + dbo.KATEGORI(A.KATEGORI) + '</div>' AS KOMODITI FROM T_M_SAMPEL A LEFT JOIN T_CP B ON A.KODE_SAMPEL = B.KODE_SAMPEL WHERE B.BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND B.MT = '".$this->newsession->userdata('SESS_USER_ID')."' AND B.STATUS = '40204'";
				}
				$this->newtable->columns(array("B.CP_ID", "A.KODE_SAMPEL", "B.STATUS", array("dbo.FORMAT_NOMOR('SPL', A.KODE_SAMPEL)",site_url()."/home/ppomn/lhu/konsep/{CP_ID}.{KODE_SAMPEL}.{STATUS}"), "A.NAMA_SAMPEL + '<div>' + A.KEMASAN + '</div><div>' + A.NOMOR_REGISTRASI + '</div>'", "dbo.KATEGORI(A.KOMODITI) + '<div>' + dbo.KATEGORI(A.KATEGORI) + '</div>'"));
				$proses['Preview Data'] = array('GET', site_url()."/home/ppomn/lhu/konsep", '1');
			}else if($id == "data"){
				$judul = "Laporan Hasil Uji";
				$query = "SELECT B.CP_ID, A.KODE_SAMPEL, B.STATUS, dbo.FORMAT_NOMOR('SPL', A.KODE_SAMPEL) AS [KODE SAMPEL], A.NAMA_SAMPEL + '<div>' + A.KEMASAN + '</div><div>' + A.NOMOR_REGISTRASI + '</div>' AS [IDENTITAS SAMPEL], dbo.KATEGORI(A.KOMODITI) + '<div>' + dbo.KATEGORI(A.KATEGORI) + '</div>' AS KOMODITI FROM T_M_SAMPEL A LEFT JOIN T_CP B ON A.KODE_SAMPEL = B.KODE_SAMPEL WHERE B.BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND B.CREATE_BY = '".$this->newsession->userdata('SESS_USER_ID')."' AND B.STATUS = '30203'";
				$this->newtable->columns(array("B.CP_ID","A.KODE_SAMPEL", "B.STATUS",array("dbo.FORMAT_NOMOR('SPL', A.KODE_SAMPEL)",site_url()."/home/ppomn/lhu/konsep/{CP_ID}.{KODE_SAMPEL}.{STATUS}"), "A.NAMA_SAMPEL + '<div>' + A.KEMASAN + '</div><div>' + A.NOMOR_REGISTRASI + '</div>'", "dbo.KATEGORI(A.KOMODITI) + '<div>' + dbo.KATEGORI(A.KATEGORI) + '</div>'"));
				if(in_array('B3',$this->newsession->userdata('SESS_SUB_SARANA'))){
					$proses['Preview Data'] = array('GET', site_url()."/home/ppomn/lhu/new", '1');
				}else{
					$proses['Konsep Pelaporan'] = array('GET', site_url()."/home/ppomn/lhu/konsep", '1');
				}
			}
			$this->newtable->hiddens(array('CP_ID','KODE_SAMPEL','STATUS'));
			$this->newtable->search(array(array("dbo.FORMAT_NOMOR('SPL', A.KODE_SAMPEL)", "Kode Sampel"),array("A.NAMA_SAMPEL","Nama Sampel"), array("dbo.KATEGORI(A.KOMODITI)","Komoditi")));
			$this->newtable->action(site_url()."/home/ppomn/lhu/list/".$id);
			$this->newtable->width(array('KODE SAMPEL' => 75, 'IDENTITAS SAMPEL' => 300, 'KOMODITI' => 200));
			$this->newtable->cidb($this->db);
			$this->newtable->ciuri($this->uri->segment_array());
			$this->newtable->orderby(1);
			$this->newtable->sortby("ASC");
			$this->newtable->keys(array('CP_ID','KODE_SAMPEL','STATUS'));
			$this->newtable->menu($proses);
			$tabel = $this->newtable->generate($query);
			$arrdata = array('table' => $tabel,
							 'idjudul' => 'juduluji',
							 'caption_header' => $judul,
							 'batal' => '',
							 'cancel' => '');
			return $arrdata;
		}
	}

	function get_lhu($id){
		if((in_array('3', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('4', $this->newsession->userdata('SESS_KODE_ROLE')) && in_array('02', $this->newsession->userdata('SESS_JENIS_PELAPORAN'))) && $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$this->load->library('newtable');
			$arrid = explode(".",$id);
			$query = "SELECT A.NAMA_SAMPEL, A.KODE_SAMPEL, dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) AS KODE, dbo.FORMAT_NOMOR('SPU',C.SPU_ID) AS SPU, A.TEMPAT_SAMPLING, CONVERT(VARCHAR(10), A.TANGGAL_SAMPLING, 103) AS TANGGAL_SAMPLING, A.ALAMAT_SAMPLING, A.NOMOR_REGISTRASI, A.PABRIK, A.IMPORTIR, A.KEMASAN, A.BENTUK_SEDIAAN, A.NO_BETS, A.SATUAN, dbo.KATEGORI(A.KOMODITI) AS KOMODITI, dbo.KATEGORI(A.KATEGORI) AS KATEGORI, A.KETERANGAN_ED, A.JUMLAH_KIMIA, A.JUMLAH_MIKRO, REPLACE(A.KOMPOSISI,';','<br>') AS KOMPOSISI, A.NETTO, B.NOMOR_SURAT, CONVERT(VARCHAR(10), B.TANGGAL_SURAT, 103) AS TANGGAL_SURAT, B.NAMA_PENGIRIM, CONVERT(VARCHAR(10), C.TANGGAL_TERIMA_TPS, 103) AS TANGGAL_TERIMA_TPS, CONVERT(VARCHAR(10), C.TANGGAL, 103) AS TANGGAL_SPU, A.JUMLAH_KIMIA, A.UJI_KIMIA, A.UJI_MIKRO, A.JUMLAH_MIKRO, A.HASIL_KIMIA, A.HASIL_MIKRO, A.HASIL_SAMPEL, A.PEMERIAN, A.STATUS_SAMPEL FROM T_M_SAMPEL A LEFT JOIN T_PERIKSA_SAMPEL B ON A.PERIKSA_SAMPEL = B.PERIKSA_SAMPEL LEFT JOIN T_SPU C ON A.SPU_ID = C.SPU_ID WHERE A.KODE_SAMPEL = '".$arrid[1]."'";
			$tanggaluji = $this->db->query("SELECT MIN(CONVERT(VARCHAR(10), AWAL_UJI, 103)) AS MINTGL, MAX(CONVERT(VARCHAR(10), AKHIR_UJI, 103)) AS MAXTGL FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL = '".$arrid[1]."'")->result_array();
			$rowcp = $this->db->query("SELECT dbo.URAIAN_M_TABEL('HASIL',HASIL) AS HASIL, CATATAN FROM T_CP WHERE CP_ID = '".$arrid[0]."'")->result_array();
			$data = $sipt->main->get_result($query);
			if($data){
				foreach($query->result_array() as $row){
					$arrdata = array('sess' => $row,
									 'rowcp' => $rowcp,
									 'tanggaluji' => $tanggaluji,
									 'stts' => $arrid[2]);

				}
			}
			$arrdata['cp_id'] = $arrid[0];
			$arrdata['judul'] = "Laporan Hasil Uji";
			$arrdata['jml_log'] = $sipt->main->get_uraian("SELECT COUNT(*) AS JML FROM T_CP_LOG WHERE CP_ID ='".$arrid[0]."'","JML"); 
			if($arrid[2] == "40202"){
				$arrdata['act'] = site_url().'/post/ppomn/lhu_act/save';
				$arrdata['batal'] = site_url().'/home/ppomn/lhu/list/draft';
				if(in_array('B5',$this->newsession->userdata('SESS_SUB_SARANA'))){#Bidang Mikro
					$arrdata['parameter'] = $this->db->query("SELECT SPK_ID, PARAMETER_UJI, METODE, PUSTAKA, SYARAT, RUANG_LINGKUP, HASIL, HASIL_KUALITATIF, LCP FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL = '".$arrid[1]."' AND JENIS_UJI = '01'")->result_array();
				}else{
					$arrdata['parameter'] = $this->db->query("SELECT SPK_ID, PARAMETER_UJI, METODE, PUSTAKA, SYARAT, RUANG_LINGKUP, HASIL, HASIL_KUALITATIF, LCP FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL = '".$arrid[1]."' AND JENIS_UJI = '02'")->result_array();
				}
			}else if($arrid[2] == "30203"){ 
				$arrdata['act'] = site_url().'/post/ppomn/lhu_act/konsep';
				$arrdata['hasil'] = $sipt->main->combobox("SELECT KODE,URAIAN FROM M_TABEL WHERE JENIS = 'HASIL' AND KODE IN ('HPST','MS','TMS')", "KODE", "URAIAN", TRUE);
				if(in_array('B5',$this->newsession->userdata('SESS_SUB_SARANA'))){#Bidang Mikro
					$arrdata['parameter'] = $this->db->query("SELECT CASE WHEN JENIS_UJI = '01' THEN 'Mikrobiologi' WHEN JENIS_UJI = '02' THEN 'Kimia - Fisika' END AS JENIS_UJI, SPK_ID,PARAMETER_UJI, METODE, PUSTAKA, SYARAT, RUANG_LINGKUP, HASIL, HASIL_KUALITATIF, LCP FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL = '".$arrid[1]."' AND JENIS_UJI = '01' AND STATUS = '40202'")->result_array();
				}else{
					$arrdata['parameter'] = $this->db->query("SELECT CASE WHEN JENIS_UJI = '01' THEN 'Mikrobiologi' WHEN JENIS_UJI = '02' THEN 'Kimia - Fisika' END AS JENIS_UJI, SPK_ID,PARAMETER_UJI, METODE, PUSTAKA, SYARAT, RUANG_LINGKUP, HASIL, HASIL_KUALITATIF, LCP FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL = '".$arrid[1]."' AND STATUS = '40202'")->result_array();
				}
				$arrdata['rowmt'] = $this->db->query("SELECT A.NAMA_USER, A.JABATAN, A.USER_ID, CONVERT(VARCHAR(10), B.PEJABAT_TANGGAL, 103) AS TTDMT FROM T_USER A LEFT JOIN T_CP B ON A.USER_ID = B.MT WHERE B.CP_ID = '".$arrid[0]."'")->result_array();
				$arrdata['batal'] = site_url().'/home/ppomn/lhu/list/data';
				$arrdata['kesimpulan'] = $this->db->query("SELECT dbo.URAIAN_M_TABEL('HASIL',HASIL) AS HASIL, CATATAN FROM T_CP WHERE KODE_SAMPEL = '".$arrid[1]."'")->result_array();
			}else if($arrid[2] == "40204"){
				$arrdata['act'] = site_url().'/post/ppomn/lhu_act/rilis';
				if(in_array('B5',$this->newsession->userdata('SESS_SUB_SARANA'))){#Bidang Mikro
					$arrdata['parameter'] = $this->db->query("SELECT CASE WHEN JENIS_UJI = '01' THEN 'Mikrobiologi' WHEN JENIS_UJI = '02' THEN 'Kimia - Fisika' END AS JENIS_UJI, SPK_ID,PARAMETER_UJI, METODE, PUSTAKA, SYARAT, RUANG_LINGKUP, HASIL, HASIL_KUALITATIF, LCP FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL = '".$arrid[1]."' AND JENIS_UJI = '01'")->result_array();
				}else{
					$arrdata['parameter'] = $this->db->query("SELECT CASE WHEN JENIS_UJI = '01' THEN 'Mikrobiologi' WHEN JENIS_UJI = '02' THEN 'Kimia - Fisika' END AS JENIS_UJI, SPK_ID,PARAMETER_UJI, METODE, PUSTAKA, SYARAT, RUANG_LINGKUP, HASIL, HASIL_KUALITATIF, LCP FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL = '".$arrid[1]."'")->result_array();
					$arrdata['hasil'] = $sipt->main->combobox("SELECT KODE,URAIAN FROM M_TABEL WHERE JENIS = 'HASIL' AND KODE IN ('HPST','MS','TMS')", "KODE", "URAIAN", TRUE);
				}
				$arrdata['rowmt'] = $this->db->query("SELECT A.NAMA_USER, A.JABATAN, A.USER_ID, CONVERT(VARCHAR(10), B.PEJABAT_TANGGAL, 103) AS TTDMT FROM T_USER A LEFT JOIN T_CP B ON A.USER_ID = B.MT WHERE B.CP_ID = '".$arrid[0]."'")->result_array();
				$arrdata['kesimpulan'] = $this->db->query("SELECT dbo.URAIAN_M_TABEL('HASIL',HASIL) AS HASIL, CATATAN FROM T_CP WHERE KODE_SAMPEL = '".$arrid[1]."'")->result_array();
				$arrdata['batal'] = site_url().'/home/ppomn/lhu/list/all';
			}else if($arrid[2] == "50202"){
				if(in_array('B5',$this->newsession->userdata('SESS_SUB_SARANA'))){#Bidang Mikro
					$arrdata['parameter'] = $this->db->query("SELECT CASE WHEN JENIS_UJI = '01' THEN 'Mikrobiologi' WHEN JENIS_UJI = '02' THEN 'Kimia - Fisika' END AS JENIS_UJI, SPK_ID,PARAMETER_UJI, METODE, PUSTAKA, SYARAT, RUANG_LINGKUP, HASIL, HASIL_KUALITATIF,  LCP FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL = '".$arrid[1]."' AND JENIS_UJI = '01'")->result_array();
				}else{
					$arrdata['parameter'] = $this->db->query("SELECT CASE WHEN JENIS_UJI = '01' THEN 'Mikrobiologi' WHEN JENIS_UJI = '02' THEN 'Kimia - Fisika' END AS JENIS_UJI, SPK_ID,PARAMETER_UJI, METODE, PUSTAKA, SYARAT, RUANG_LINGKUP, HASIL, HASIL_KUALITATIF,  LCP FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL = '".$arrid[1]."'")->result_array();
					$arrdata['hasil'] = $sipt->main->combobox("SELECT KODE,URAIAN FROM M_TABEL WHERE JENIS = 'HASIL' AND KODE IN ('HPST','MS','TMS')", "KODE", "URAIAN", TRUE);
				}
			}
			return $arrdata;
		}
	}

	function set_lhu($action, $isajax){print_r($_POST); die();
		if((in_array('2', $this->newsession->userdata('SESS_KODE_ROLE'))  || in_array('3', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('4', $this->newsession->userdata('SESS_KODE_ROLE'))) && in_array('02', $this->newsession->userdata('SESS_JENIS_PELAPORAN')) && $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			if($action=="save"){
				$hasil = FALSE;
				$chk = FALSE;
				$msgok = "Laporan Hasil Uji Berhasil di Verifikasi";
				$msgerr = "Laporan Hasil Uji Gagal di Verifikasi, Silahkan coba lagi";
				if(in_array('B5',$this->newsession->userdata('SESS_SUB_SARANA'))){
					$lab = 'M';
				}else{
					$lab = 'K';
				}
				$anggaran = substr($this->input->post('KODE_SAMPEL'),9,2);
				$ko = substr($this->input->post('KODE_SAMPEL'),7,2);
				$kode_lhu = $sipt->main->set_kode_lhu($lab,$anggaran,$ko);
				$arr_lhu = array('LHU_ID' => $kode_lhu,
								 'CP_ID' => $this->input->post('CP_ID'),
								 'CREATE_DATE' => 'GETDATE()',
								 'CREATE_BY' => $this->newsession->userdata('SESS_USER_ID'));
				if($this->db->insert('T_LHU',$arr_lhu)){
					$hasil = TRUE;
					$sipt->main->set_max('lhu',$ko);
					
					$cek_uji = $this->db->query("SELECT UJI_KIMIA, UJI_MIKRO FROM T_M_SAMPEL WHERE KODE_SAMPEL = '".$this->input->post('KODE_SAMPEL')."'")->result_array();
					if($cek_uji[0]['UJI_KIMIA'] == 1 && $cek_uji[0]['UJI_MIKRO'] == 1){
						if(in_array('B5',$this->newsession->userdata('SESS_SUB_SARANA'))){
							$chk = FALSE;
						}else{
							$chk = TRUE;
						}
					}else{
						$chk = TRUE;
					}					
					
					if(in_array('B5',$this->newsession->userdata('SESS_SUB_SARANA'))){
						$this->db->simple_query("UPDATE T_M_SAMPEL SET STATUS_MIKRO = '1' WHERE KODE_SAMPEL = '".$this->input->post('KODE_SAMPEL')."'");	
					}else{
						$this->db->simple_query("UPDATE T_M_SAMPEL SET STATUS_KIMIA = '1' WHERE KODE_SAMPEL = '".$this->input->post('KODE_SAMPEL')."'");	
					}
					
					//$this->db->simple_query("SET DATEFORMAT DMY UPDATE T_CP SET PEJABAT_TANGGAL = GETDATE(), LAST_UPDATE = GETDATE(), UPDATE_BY = '".$this->newsession->userdata('SESS_USER_ID')."', STATUS = '30203' WHERE CP_ID = '".$this->input->post('CP_ID')."'");
					$this->db->simple_query("SET DATEFORMAT DMY UPDATE T_CP SET PEJABAT_TANGGAL = GETDATE(), LAST_UPDATE = GETDATE(), UPDATE_BY = '".$this->newsession->userdata('SESS_USER_ID')."', STATUS = '11002' WHERE CP_ID = '".$this->input->post('CP_ID')."'");
					if($chk){
						$this->db->simple_query("UPDATE T_M_SAMPEL SET CATATAN_CP = '".$this->input->post('CATATAN_CP')."' WHERE KODE_SAMPEL = '".$this->input->post('KODE_SAMPEL')."'");	
					}
					
					$logcp = array('CP_ID' => $this->input->post('CP_ID'),
								   'WAKTU' => 'GETDATE()',
								   'USER_ID' => $this->newsession->userdata('SESS_USER_ID'),
								   'KEGIATAN' => 'Verifikasi data LHU : '. $kode_lhu,
								   'CATATAN' => $this->input->post('CATATAN_CP'));
					$this->db->insert('T_CP_LOG', $logcp);
					
					$loglhu = array('LHU_ID' => $kode_lhu,
								    'WAKTU' => 'GETDATE()',
									'USER_ID' => $this->newsession->userdata('SESS_USER_ID'),
									'KEGIATAN' => 'Verifikasi data LHU : '. $kode_lhu,
									'CATATAN' => $this->input->post('CATATAN_CP'));
					$this->db->insert('T_LHU_LOG', $loglhu);
				}				 
				if($hasil){
					return "MSG#YES#$msgok.#".site_url().'/home/ppomn/lhu/list/draft';
				}else{
					return "MSG#NO#$msgerror";
				}
				if($isajax!="ajax"){
					redirect(base_url());
					exit();
				}
			}else if($action == "konsep"){
				$hasil = FALSE;
				$msgok = "Konsep Laporan berhasil di proses";
				$msgerr = "Konsep Laporan gagal di proses, Silahkan coba lagi";
				$cek_uji = $this->db->query("SELECT UJI_KIMIA, UJI_MIKRO, ISNULL(STATUS_KIMIA,'0') AS STATUS_KIMIA, ISNULL(STATUS_MIKRO,'0') AS STATUS_MIKRO FROM T_M_SAMPEL WHERE KODE_SAMPEL = '".$this->input->post('KODE_SAMPEL')."'")->result_array();
				if($cek_uji[0]['UJI_KIMIA'] == 1 && $cek_uji[0]['UJI_MIKRO'] == 1){
					if($cek_uji[0]['STATUS_KIMIA'] == 1 && $cek_uji[0]['STATUS_MIKRO'] == 1){
						$hasil = TRUE;
					}else{
						return "MSG#NO#Konsep Laporan gagal diproses. \n Dikarenakan LHU Mikro belum diverifikasi"; die();
					}
				}else{
					$hasil = TRUE;
				}
				if($hasil){
					if($this->input->post('HASIL_SAMPEL')){
						$this->db->simple_query("UPDATE T_M_SAMPEL SET HASIL_SAMPEL = '".$this->input->post('HASIL_SAMPEL')."', STATUS_SAMPEL = '40204' WHERE KODE_SAMPEL = '".$this->input->post('KODE_SAMPEL')."'");	
					}
					$this->db->simple_query("UPDATE T_PARAMETER_HASIL_UJI SET STATUS = '40204' WHERE KODE_SAMPEL = '".$this->input->post('KODE_SAMPEL')."'");
					$this->db->simple_query("SET DATEFORMAT DMY UPDATE T_CP SET LAST_UPDATE = GETDATE(), UPDATE_BY = '".$this->newsession->userdata('SESS_USER_ID')."', STATUS = '40204' WHERE KODE_SAMPEL = '".$this->input->post('KODE_SAMPEL')."'");
					$logcp = array('CP_ID' => $this->input->post('CP_ID'),
								   'WAKTU' => 'GETDATE()',
								   'USER_ID' => $this->newsession->userdata('SESS_USER_ID'),
								   'KEGIATAN' => 'Pembuatan Konsep Pelaporan',
								   'CATATAN' => '-');
					$this->db->insert('T_CP_LOG', $logcp);
					return "MSG#YES#$msgok#".site_url().'/home/ppomn/lhu/list/data';
				}else{
					return "MSG#NO#$msgerr";
				}
				if($isajax!="ajax"){
					redirect(base_url());
					exit();
				}
			}else if($action == "rilis"){
				$hasil = FALSE;
				$msgok = "Laporan berhasil dikirim";
				$msgerror = "Laporan gagal dikirim, Silahkan coba lagi";
				$query = "SELECT KODE_SAMPEL,KOMODITI,KATEGORI,ANGGARAN,ASAL_SAMPEL,CONVERT(VARCHAR(10), TANGGAL_SAMPLING, 103) AS TANGGAL_SAMPLING,SARANA_ID,TEMPAT_SAMPLING,ALAMAT_SAMPLING,NAMA_SAMPEL,NOMOR_REGISTRASI,PABRIK,IMPORTIR,BENTUK_SEDIAAN,KEMASAN,NO_BETS,KETERANGAN_ED,JUMLAH_SAMPEL,SATUAN,HARGA_SAMPEL,UJI_KIMIA,JUMLAH_KIMIA,UJI_MIKRO,JUMLAH_MIKRO,SISA,KOMPOSISI,NETTO,KONDISI_SAMPEL,EVALUASI_PENANDAAN,CARA_PENYIMPANAN,HASIL_KIMIA,HASIL_MIKRO,UJI_ULANG,HASIL_SAMPEL,PEMERIAN, CATATAN_CP FROM T_M_SAMPEL WHERE KODE_SAMPEL = '".$this->input->post('KODE_SAMPEL')."'";
				$data = $sipt->main->get_result($query);
				if($data){
					foreach($query->result_array() as $row){
						$sql = "SET DATEFORMAT DMY INSERT INTO T_M_SAMPEL_RILIS(KODE_SAMPEL,BBPOM_ID,KOMODITI,KATEGORI,ANGGARAN,ASAL_SAMPEL,TANGGAL_SAMPLING, SARANA_ID,TEMPAT_SAMPLING,ALAMAT_SAMPLING,NAMA_SAMPEL,NOMOR_REGISTRASI,PABRIK,IMPORTIR,BENTUK_SEDIAAN,KEMASAN,NO_BETS,KETERANGAN_ED,JUMLAH_SAMPEL,SATUAN,HARGA_SAMPEL,UJI_KIMIA,JUMLAH_KIMIA,UJI_MIKRO,JUMLAH_MIKRO,SISA,KOMPOSISI,NETTO,KONDISI_SAMPEL,EVALUASI_PENANDAAN,CARA_PENYIMPANAN,HASIL_KIMIA,HASIL_MIKRO,UJI_ULANG,HASIL_SAMPEL,PEMERIAN,CATATAN_CP,CREATE_BY,CREATE_DATE,STATUS) VALUES('".$row['KODE_SAMPEL']."','".$this->newsession->userdata('SESS_BBPOM_ID')."','".$row['KOMODITI']."','".$row['KATEGORI']."','".$row['ANGGARAN']."','".$row['ASAL_SAMPEL']."','".$row['TANGGAL_SAMPLING']."','".$row['SARANA_ID']."','".$row['TEMPAT_SAMPLING']."','".$row['ALAMAT_SAMPLING']."','".$row['NAMA_SAMPEL']."','".$row['NOMOR_REGISTRASI']."','".$row['PABRIK']."','".$row['IMPORTIR']."','".$row['BENTUK_SEDIAAN']."','".$row['KEMASAN']."','".$row['NO_BETS']."','".$row['KETERANGAN_ED']."','".$row['JUMLAH_SAMPEL']."','".$row['SATUAN']."','".$row['HARGA_SAMPEL']."','".$row['UJI_KIMIA']."','".$row['JUMLAH_KIMIA']."','".$row['UJI_MIKRO']."','".$row['JUMLAH_MIKRO']."','".$row['SISA']."','".$row['KOMPOSISI']."','".$row['NETTO']."','".$row['KONDISI_SAMPEL']."','".$row['EVALUASI_PENANDAAN']."','".$row['CARA_PENYIMPANAN']."','".$row['HASIL_KIMIA']."','".$row['HASIL_MIKRO']."','".$row['UJI_ULANG']."','".$row['HASIL_SAMPEL']."','".$row['PEMERIAN']."','".$row['CATATAN_CP']."','".$this->newsession->userdata('SESS_USER_ID')."',GETDATE(),'50202')";
					}
					$res = $this->db->simple_query($sql);
					if($res){
						$hasil = TRUE;
						$this->db->simple_query("SET DATEFORMAT DMY  UPDATE T_M_SAMPEL SET STATUS_SAMPEL = '50202', UPDATE_BY = '".$this->newsession->userdata('SESS_USER_ID')."', UPDATE_DATE = GETDATE() WHERE KODE_SAMPEL = '".$this->input->post('KODE_SAMPEL')."'");	
						$this->db->simple_query("UPDATE T_PARAMETER_HASIL_UJI SET STATUS = '50202' WHERE KODE_SAMPEL = '".$this->input->post('KODE_SAMPEL')."'");	
						$this->db->simple_query("SET DATEFORMAT DMY UPDATE T_CP SET LAST_UPDATE = GETDATE(), UPDATE_BY = '".$this->newsession->userdata('SESS_USER_ID')."', STATUS = '50202' WHERE KODE_SAMPEL = '".$this->input->post('KODE_SAMPEL')."'");
						$logcp = array('CP_ID' => $this->input->post('CP_ID'),
									   'WAKTU' => 'GETDATE()',
									   'USER_ID' => $this->newsession->userdata('SESS_USER_ID'),
									   'KEGIATAN' => 'Verifikasi konsep laporan dan kirim hasil akhir sampel',
									   'CATATAN' => $row['CATATAN_CP']);
						$this->db->insert('T_CP_LOG', $logcp);

					}
				}
				if($hasil){
					return "MSG#YES#$msgok#".site_url().'/home/ppomn/lhu/list/all';
				}else{
					return "MSG#NO#$msgerror";
				}
				if($isajax!="ajax"){
					redirect(base_url());
					exit();
				}
			}
		}
	}
}
?>