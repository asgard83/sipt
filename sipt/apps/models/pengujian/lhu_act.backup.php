<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR);
class Lhu_act extends Model{
	function list_lhu($id){
		if((in_array('3', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('4', $this->newsession->userdata('SESS_KODE_ROLE')) && in_array('02', $this->newsession->userdata('SESS_JENIS_PELAPORAN'))) && $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$this->load->library('newtable');
			if($id == "draft"){
				$judul = "Laporan Hasil Uji";
				$query = "SELECT B.CP_ID, A.KODE_SAMPEL, B.STATUS, C.USER_ID, dbo.FORMAT_NOMOR('SPL', A.KODE_SAMPEL) AS [KODE SAMPEL], A.NAMA_SAMPEL + '<div>' + A.KEMASAN + '</div><div>' + A.NOMOR_REGISTRASI + '</div>' AS [IDENTITAS SAMPEL], dbo.KATEGORI(A.KOMODITI,A.PRIORITAS) + '<div>' + A.NAMA_KATEGORI + '</div>' AS KOMODITI, C.NAMA_USER AS [PENYELIA] FROM T_M_SAMPEL A LEFT JOIN T_CP B ON A.KODE_SAMPEL = B.KODE_SAMPEL LEFT JOIN T_USER C ON B.CREATE_BY = C.USER_ID WHERE B.BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND B.MT = '".$this->newsession->userdata('SESS_USER_ID')."' AND B.STATUS = '40202'";
				$this->newtable->columns(array("B.CP_ID", "A.KODE_SAMPEL", "B.STATUS", "C.USER_ID", array("dbo.FORMAT_NOMOR('SPL', A.KODE_SAMPEL)",site_url()."/home/pengujian/lhu/new/{CP_ID}.{KODE_SAMPEL}.{STATUS}.{USER_ID}"), "A.NAMA_SAMPEL + '<div>' + A.KEMASAN + '</div><div>' + A.NOMOR_REGISTRASI + '</div>'", "dbo.KATEGORI(A.KOMODITI,A.PRIORITAS) + '<div>' + A.NAMA_KATEGORI + '</div>'","C.NAMA_USER"));
				$proses['Preview Data'] = array('GET', site_url()."/home/pengujian/lhu/new", '1');
				$this->newtable->orderby(1);
				$this->newtable->sortby("ASC");
				$this->newtable->hiddens(array('CP_ID','KODE_SAMPEL','STATUS', 'USER_ID'));
			}else if($id == "all"){
				$judul = "Konsep Pelaporan / Sertifikat";
				if(in_array('3', $this->newsession->userdata('SESS_KODE_ROLE'))){
					$query = "SELECT B.CP_ID, A.KODE_SAMPEL, B.STATUS, C.USER_ID, dbo.FORMAT_NOMOR('SPL', A.KODE_SAMPEL) AS [KODE SAMPEL], A.NAMA_SAMPEL + '<div>' + A.KEMASAN + '</div><div>' + A.NOMOR_REGISTRASI + '</div>' AS [IDENTITAS SAMPEL], dbo.KATEGORI(A.KOMODITI,A.PRIORITAS) + '<div>' + A.NAMA_KATEGORI + '</div>' AS KOMODITI, C.NAMA_USER AS [PENYELIA] FROM T_M_SAMPEL A LEFT JOIN T_CP B ON A.KODE_SAMPEL = B.KODE_SAMPEL  LEFT JOIN T_USER C ON B.CREATE_BY = C.USER_ID WHERE B.BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND B.CREATE_BY = '".$this->newsession->userdata('SESS_USER_ID')."' AND B.STATUS IN('40204','50202')";
					$proses['Cetak Data LHU'] = array('GETNEW', site_url()."/topdf/lhu/prints", '1');
				}
				if(in_array('4', $this->newsession->userdata('SESS_KODE_ROLE'))){
					$query = "SELECT B.CP_ID, A.KODE_SAMPEL, B.STATUS, C.USER_ID, dbo.FORMAT_NOMOR('SPL', A.KODE_SAMPEL) AS [KODE SAMPEL], A.NAMA_SAMPEL + '<div>' + A.KEMASAN + '</div><div>' + A.NOMOR_REGISTRASI + '</div>' AS [IDENTITAS SAMPEL], dbo.KATEGORI(A.KOMODITI,A.PRIORITAS) + '<div>' + A.NAMA_KATEGORI + '</div>' AS KOMODITI,  C.NAMA_USER AS [PENYELIA] FROM T_M_SAMPEL A LEFT JOIN T_CP B ON A.KODE_SAMPEL = B.KODE_SAMPEL LEFT JOIN T_USER C ON B.CREATE_BY = C.USER_ID WHERE B.BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND B.MT = '".$this->newsession->userdata('SESS_USER_ID')."' AND B.STATUS = '40204'";
				}
				$this->newtable->columns(array("B.CP_ID", "A.KODE_SAMPEL", "B.STATUS", "C.USER_ID", array("dbo.FORMAT_NOMOR('SPL', A.KODE_SAMPEL)",site_url()."/home/pengujian/lhu/konsep/{CP_ID}.{KODE_SAMPEL}.{STATUS}.{USER_ID}"), "A.NAMA_SAMPEL + '<div>' + A.KEMASAN + '</div><div>' + A.NOMOR_REGISTRASI + '</div>'", "dbo.KATEGORI(A.KOMODITI,A.PRIORITAS) + '<div>' + A.NAMA_KATEGORI + '</div>'","C.NAMA_USER"));
				$proses['Preview Data'] = array('GET', site_url()."/home/pengujian/lhu/konsep", '1');
				$this->newtable->orderby(1);
				$this->newtable->sortby("ASC");
				$this->newtable->hiddens(array('CP_ID','KODE_SAMPEL','STATUS', 'USER_ID'));
			}else if($id == "data"){
				$judul = "Laporan Hasil Uji";
				$query = "SELECT B.CP_ID, A.KODE_SAMPEL, B.STATUS, C.USER_ID, dbo.FORMAT_NOMOR('SPL', A.KODE_SAMPEL) AS [KODE SAMPEL], A.NAMA_SAMPEL + '<div>' + A.KEMASAN + '</div><div>' + A.NOMOR_REGISTRASI + '</div>' AS [IDENTITAS SAMPEL], dbo.KATEGORI(A.KOMODITI,A.PRIORITAS) + '<div>' + A.NAMA_KATEGORI + '</div>' AS KOMODITI, C.NAMA_USER AS [PENYELIA], CASE WHEN A.STATUS_KIMIA = 1 AND A.STATUS_MIKRO IS NULL THEN '&radic; Kimia - &times; Mikro' WHEN A.STATUS_KIMIA IS NULL AND A.STATUS_MIKRO = 1 THEN '&times; Kimia - &radic; Mikro' WHEN A.STATUS_KIMIA = 1 AND A.STATUS_MIKRO = 1 THEN '&radic; Kimia - &radic; Mikro' ELSE '&times; Kimia - &times; Mikro' END AS [STATUS UJI] FROM T_M_SAMPEL A LEFT JOIN T_CP B ON A.KODE_SAMPEL = B.KODE_SAMPEL LEFT JOIN T_USER C ON B.CREATE_BY = C.USER_ID WHERE B.BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND B.CREATE_BY = '".$this->newsession->userdata('SESS_USER_ID')."' AND B.STATUS = '30203'";
				
				$this->newtable->columns(array("B.CP_ID","A.KODE_SAMPEL", "B.STATUS", "C.USER_ID", array("dbo.FORMAT_NOMOR('SPL', A.KODE_SAMPEL)",site_url()."/home/pengujian/lhu/konsep/{CP_ID}.{KODE_SAMPEL}.{STATUS}"), "A.NAMA_SAMPEL + '<div>' + A.KEMASAN + '</div><div>' + A.NOMOR_REGISTRASI + '</div>'", "dbo.KATEGORI(A.KOMODITI,A.PRIORITAS) + '<div>' + A.NAMA_KATEGORI + '</div>'","C.NAMA_USER","CASE WHEN A.STATUS_KIMIA = 1 AND A.STATUS_MIKRO IS NULL THEN '&radic; Kimia - &times; Mikro' WHEN A.STATUS_KIMIA IS NULL AND A.STATUS_MIKRO = 1 THEN '&radic; Kimia - &times; Mikro' WHEN A.STATUS_KIMIA = 1 AND A.STATUS_MIKRO = 1 THEN '&radic; Kimia - &radic; Mikro' ELSE '&times; Kimia - &times; Mikro' END"));
				if(in_array('B3',$this->newsession->userdata('SESS_SUB_SARANA'))){
					$proses['Preview Data'] = array('GET', site_url()."/home/pengujian/lhu/konsep", '1');
				}else{
					$proses['Konsep Pelaporan'] = array('GET', site_url()."/home/pengujian/lhu/konsep", '1');
				}
				$this->newtable->orderby(1);
				$this->newtable->sortby("ASC");
				$this->newtable->hiddens(array('CP_ID','KODE_SAMPEL','STATUS', 'USER_ID'));
			}else if($id == "send"){
				$judul = "Laporan Uji Terkirim";
				$query = "SELECT B.CP_ID, A.KODE_SAMPEL, B.STATUS, C.USER_ID, dbo.FORMAT_NOMOR('SPL', A.KODE_SAMPEL) AS [KODE SAMPEL], A.NAMA_SAMPEL + '<div>' + A.KEMASAN + '</div><div>' + A.NOMOR_REGISTRASI + '</div>' AS [IDENTITAS SAMPEL], dbo.KATEGORI(A.KOMODITI,A.PRIORITAS) + '<div>' + A.NAMA_KATEGORI + '</div>' AS KOMODITI, C.NAMA_USER AS [PENYELIA], CONVERT(VARCHAR(10), B.LAST_UPDATE, 120) AS LAST_UPDATE FROM T_M_SAMPEL A LEFT JOIN T_CP B ON A.KODE_SAMPEL = B.KODE_SAMPEL LEFT JOIN T_USER C ON B.CREATE_BY = C.USER_ID WHERE B.BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND B.MT = '".$this->newsession->userdata('SESS_USER_ID')."' AND B.STATUS = '50202'";
				$this->newtable->columns(array("B.CP_ID","A.KODE_SAMPEL", "B.STATUS", "C.USER_ID", array("dbo.FORMAT_NOMOR('SPL', A.KODE_SAMPEL)",site_url()."/home/pengujian/lhu/konsep/{CP_ID}.{KODE_SAMPEL}.{STATUS}"), "A.NAMA_SAMPEL + '<div>' + A.KEMASAN + '</div><div>' + A.NOMOR_REGISTRASI + '</div>'", "dbo.KATEGORI(A.KOMODITI,A.PRIORITAS) + '<div>' + A.NAMA_KATEGORI + '</div>'","C.NAMA_USER","CONVERT(VARCHAR(10), B.LAST_UPDATE, 120)"));
				$proses['Preview Data'] = array('GET', site_url()."/home/pengujian/lhu/konsep", '1');
				$this->newtable->orderby(7);
				$this->newtable->sortby("ASC");
				$this->newtable->hiddens(array('CP_ID','KODE_SAMPEL','STATUS', 'USER_ID','LAST_UPDATE'));
			}
			$this->newtable->search(array(array("dbo.FORMAT_NOMOR('SPL', B.KODE_SAMPEL)", "Kode Sampel"),array("A.NAMA_SAMPEL","Nama Sampel"), array("dbo.KATEGORI(A.KOMODITI,A.PRIORITAS)","Komoditi")));
			$this->newtable->action(site_url()."/home/pengujian/lhu/list/".$id);
			if($id == "data")
			$this->newtable->width(array('KODE SAMPEL' => 75, 'IDENTITAS SAMPEL' => 300, 'KOMODITI' => 200, 'PENYELIA' => 100, 'UJI' => 75));
			else
			$this->newtable->width(array('KODE SAMPEL' => 75, 'IDENTITAS SAMPEL' => 300, 'KOMODITI' => 200, 'PENYELIA' => 100));
			
			$this->newtable->cidb($this->db);
			$this->newtable->ciuri($this->uri->segment_array());
			$this->newtable->keys(array('CP_ID','KODE_SAMPEL','STATUS','USER_ID'));
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
			$query = "SELECT A.NAMA_SAMPEL, A.PERIKSA_SAMPEL, A.KODE_SAMPEL, dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) AS KODE, dbo.FORMAT_NOMOR('SPU',C.SPU_ID) AS SPU, A.TEMPAT_SAMPLING, CONVERT(VARCHAR(10), A.TANGGAL_SAMPLING, 103) AS TANGGAL_SAMPLING, A.ALAMAT_SAMPLING, A.NOMOR_REGISTRASI, A.PABRIK, A.IMPORTIR, A.KEMASAN, A.BENTUK_SEDIAAN, A.NO_BETS, A.SATUAN, dbo.KATEGORI(A.KOMODITI,A.PRIORITAS) AS KOMODITI, dbo.KATEGORI(A.KATEGORI,A.PRIORITAS) AS KATEGORI, A.KETERANGAN_ED, A.JUMLAH_KIMIA, A.JUMLAH_MIKRO, REPLACE(A.KOMPOSISI,';','<br>') AS KOMPOSISI, A.NETTO, B.NOMOR_SURAT, CONVERT(VARCHAR(10), B.TANGGAL_SURAT, 103) AS TANGGAL_SURAT, B.NAMA_PENGIRIM, CONVERT(VARCHAR(10), C.TANGGAL_TERIMA_TPS, 103) AS TANGGAL_TERIMA_TPS, CONVERT(VARCHAR(10), C.TANGGAL, 103) AS TANGGAL_SPU, A.JUMLAH_KIMIA, ISNULL(A.UJI_KIMIA,'0') AS UJI_KIMIA, ISNULL(A.UJI_MIKRO,'0') AS UJI_MIKRO, A.JUMLAH_MIKRO, LTRIM(RTRIM(A.HASIL_KIMIA)) AS HASIL_KIMIA, LTRIM(RTRIM(A.HASIL_MIKRO)) HASIL_MIKRO, LTRIM(RTRIM(A.HASIL_SAMPEL)) AS HASIL_SAMPEL, A.PEMERIAN, A.STATUS_SAMPEL, LTRIM(RTRIM(A.KODE_RUJUKAN)) AS KODE_RUJUKAN, LTRIM(RTRIM(A.KODE_UNGGULAN)) AS KODE_UNGGULAN, dbo.FORMAT_NOMOR('SPL', A.KODE_RUJUKAN) AS UR_KODE_RUJUKAN, ISNULL(A.SISA,0) AS SISA, ISNULL(A.SISA_KIMIA,0) AS SISA_KIMIA, ISNULL(A.SISA_MIKRO,0) AS SISA_MIKRO, ISNULL(A.JUMLAH_SAMPEL,0) AS JUMLAH_SAMPEL FROM T_M_SAMPEL A LEFT JOIN T_PERIKSA_SAMPEL B ON A.PERIKSA_SAMPEL = B.PERIKSA_SAMPEL LEFT JOIN T_SPU C ON A.SPU_ID = C.SPU_ID WHERE A.KODE_SAMPEL = '".$arrid[1]."'";
			//echo $query;die();
			$tanggaluji = $this->db->query("SELECT KODE_SAMPEL, MIN(CONVERT(VARCHAR(10), AWAL_UJI, 120)) AS MINTGL, MAX(CONVERT(VARCHAR(10), AKHIR_UJI, 120)) AS MAXTGL FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL = '".$arrid[1]."' GROUP BY KODE_SAMPEL")->result_array();
			$rowcp = $this->db->query("SELECT RTRIM(LTRIM(HASIL)) AS HSL, dbo.URAIAN_M_TABEL('HASIL',HASIL) AS HASIL, CATATAN FROM T_CP WHERE CP_ID = '".$arrid[0]."'")->result_array();
			$data = $sipt->main->get_result($query);
			if($data){
				foreach($query->result_array() as $row){
					$arrdata = array('sess' => $row,
									 'rowcp' => $rowcp,
									 'tanggaluji' => $tanggaluji,
									 'stts' => $arrid[2]);

				}
				$arrdata['capafile'] = $this->db->query("SELECT KODE_SAMPEL, CAPA_FILE FROM T_SAMPEL_RUJUKAN_CAPA WHERE KODE_SAMPEL = '".$row['KODE_RUJUKAN']."'")->result_array();
			}
			$arrdata['cp_id'] = $arrid[0];
			$arrdata['judul'] = "Laporan Hasil Uji";
			$arrdata['jml_log'] = $sipt->main->get_uraian("SELECT COUNT(*) AS JML FROM T_CP_LOG WHERE CP_ID ='".$arrid[0]."'","JML"); 
			if($arrid[2] == "40202"){
				$arrdata['act'] = site_url().'/post/lhu/lhu_act/save';
				$arrdata['batal'] = site_url().'/home/pengujian/lhu/list/draft';
				$arrdata['hasil'] = $sipt->main->combobox("SELECT KODE,URAIAN FROM M_TABEL WHERE JENIS = 'HASIL' AND KODE IN ('HPST','MS','TMS')", "KODE", "URAIAN", TRUE);
				if(in_array('B1',$this->newsession->userdata('SESS_SUB_SARANA')) || in_array('B2',$this->newsession->userdata('SESS_SUB_SARANA'))){#Bidang Kimia Fisika
					if($this->newsession->userdata('SESS_TIPE_BBPOM') == "A"){
						$arrdata['parameter'] = $this->db->query("SELECT UJI_ID, SPK_ID, PARAMETER_UJI, METODE, PUSTAKA, SYARAT, RUANG_LINGKUP, HASIL, HASIL_KUALITATIF, LCP, HASIL_PARAMETER, CASE WHEN UJI_MAMPU = '0' THEN 'Tidak' ELSE 'Ya' END AS UJI_MAMPU FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL = '".$arrid[1]."' AND JENIS_UJI = '02'")->result_array();						
					}else{
						$arrdata['parameter'] = $this->db->query("SELECT UJI_ID, SPK_ID, PARAMETER_UJI, METODE, PUSTAKA, SYARAT, RUANG_LINGKUP, HASIL, HASIL_KUALITATIF, LCP, HASIL_PARAMETER, CASE WHEN UJI_MAMPU = '0' THEN 'Tidak' ELSE 'Ya' END AS UJI_MAMPU FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL = '".$arrid[1]."' AND PENYELIA = '".$arrid[3]."'")->result_array();
						$getuid = "SELECT DISTINCT(USER_ID), LEFT(SARANA_MEDIA_ID, 2) AS BID FROM T_USER_ROLE WHERE USER_ID = '".$arrid[3]."' GROUP BY USER_ID, SARANA_MEDIA_ID";
						$dtuid = $sipt->main->get_result($getuid);
						if($dtuid){
							$arrbid = array();
							foreach($getuid->result_array() as $row){
								if(!array_key_exists($row['BID'], $arrbid)) $arrbid[$row['BID']] = $row['BID'];
							}
							if(in_array('B3', $arrbid))
							$arrdata['bypass'] = TRUE;
							else
							$arrdata['bypass'] = FALSE;
						}else{

							$arrdata['bypass'] = FALSE;
						}
						$arrdata['uid'] = $arrid[3];
					}
						 
				}else if(in_array('B3',$this->newsession->userdata('SESS_SUB_SARANA'))){#Bidang Mikro
					$arrdata['parameter'] = $this->db->query("SELECT UJI_ID, SPK_ID, PARAMETER_UJI, METODE, PUSTAKA, SYARAT, RUANG_LINGKUP, HASIL, HASIL_KUALITATIF, LCP, HASIL_PARAMETER, CASE WHEN UJI_MAMPU = '0' THEN 'Tidak' ELSE 'Ya' END AS UJI_MAMPU FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL = '".$arrid[1]."' AND JENIS_UJI = '01'")->result_array();
				}				 
			}
			else if($arrid[2] == "30203"){ 
				$arrdata['action'] = site_url().'/post/lhu/lhu_act/konsep';
				$arrdata['hasil'] = $sipt->main->combobox("SELECT KODE,URAIAN FROM M_TABEL WHERE JENIS = 'HASIL' AND KODE IN ('HPST','MS','TMS')", "KODE", "URAIAN", TRUE);
				if(in_array('B1',$this->newsession->userdata('SESS_SUB_SARANA')) || in_array('B2',$this->newsession->userdata('SESS_SUB_SARANA'))){#Bidang Kimia Fisika
					$arrdata['parameter'] = $this->db->query("SELECT UJI_ID, CASE WHEN JENIS_UJI = '01' THEN 'Mikrobiologi' WHEN JENIS_UJI = '02' THEN 'Kimia - Fisika' END AS JENIS_UJI, SPK_ID,PARAMETER_UJI, METODE, PUSTAKA, SYARAT, RUANG_LINGKUP, HASIL, HASIL_KUALITATIF, LCP, HASIL_PARAMETER, CASE WHEN UJI_MAMPU = '0' THEN 'Tidak' ELSE 'Ya' END AS UJI_MAMPU FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL = '".$arrid[1]."'")->result_array();
				}else if(in_array('B3',$this->newsession->userdata('SESS_SUB_SARANA'))){#Bidang Mikro
					$arrdata['parameter'] = $this->db->query("SELECT UJI_ID, CASE WHEN JENIS_UJI = '01' THEN 'Mikrobiologi' WHEN JENIS_UJI = '02' THEN 'Kimia - Fisika' END AS JENIS_UJI, SPK_ID,PARAMETER_UJI, METODE, PUSTAKA, SYARAT, RUANG_LINGKUP, HASIL, HASIL_KUALITATIF, LCP, HASIL_PARAMETER, CASE WHEN UJI_MAMPU = '0' THEN 'Tidak' ELSE 'Ya' END AS UJI_MAMPU FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL = '".$arrid[1]."' AND JENIS_UJI = '01'")->result_array();

				}
				$arrdata['rowmt'] = $this->db->query("SELECT A.NAMA_USER, A.JABATAN, A.USER_ID, CONVERT(VARCHAR(10), B.PEJABAT_TANGGAL, 103) AS TTDMT FROM T_USER A LEFT JOIN T_CP B ON A.USER_ID = B.MT WHERE B.CP_ID = '".$arrid[0]."'")->result_array();
				$arrdata['batal'] = site_url().'/home/pengujian/lhu/list/data';
				$arrdata['kesimpulan'] = $this->db->query("SELECT dbo.URAIAN_M_TABEL('HASIL',HASIL) AS HASIL, CATATAN FROM T_CP WHERE KODE_SAMPEL = '".$arrid[1]."'")->result_array();
			}
			else if($arrid[2] == "40204"){	//echo $arrid[0];die();			
				$arrdata['action'] = site_url().'/post/lhu/lhu_act/rilis';
				$arrdata['hasil'] = $sipt->main->combobox("SELECT KODE,URAIAN FROM M_TABEL WHERE JENIS = 'HASIL' AND KODE IN ('HPST','MS','TMS')", "KODE", "URAIAN", TRUE);
				if(in_array('B1',$this->newsession->userdata('SESS_SUB_SARANA')) || in_array('B2',$this->newsession->userdata('SESS_SUB_SARANA'))){#Bidang Kimia Fisika
					$arrdata['parameter'] = $this->db->query("SELECT UJI_ID, CASE WHEN JENIS_UJI = '01' THEN 'Mikrobiologi' WHEN JENIS_UJI = '02' THEN 'Kimia - Fisika' END AS JENIS_UJI, SPK_ID,PARAMETER_UJI, METODE, PUSTAKA, SYARAT, RUANG_LINGKUP, HASIL, HASIL_KUALITATIF, LCP, HASIL_PARAMETER, CASE WHEN UJI_MAMPU = '0' THEN 'Tidak' ELSE 'Ya' END AS UJI_MAMPU FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL = '".$arrid[1]."'")->result_array();
					$arrdata['hasil'] = $sipt->main->combobox("SELECT KODE,URAIAN FROM M_TABEL WHERE JENIS = 'HASIL' AND KODE IN ('HPST','MS','TMS')", "KODE", "URAIAN", TRUE);
				}else if(in_array('B3',$this->newsession->userdata('SESS_SUB_SARANA'))){#Bidang Mikro
					$arrdata['parameter'] = $this->db->query("SELECT CASE WHEN JENIS_UJI = '01' THEN 'Mikrobiologi' WHEN JENIS_UJI = '02' THEN 'Kimia - Fisika' END AS JENIS_UJI, SPK_ID,PARAMETER_UJI, METODE, PUSTAKA, SYARAT, RUANG_LINGKUP, HASIL, HASIL_KUALITATIF, LCP, HASIL_PARAMETER, CASE WHEN UJI_MAMPU = '0' THEN 'Tidak' ELSE 'Ya' END AS UJI_MAMPU FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL = '".$arrid[1]."' AND JENIS_UJI = '01'")->result_array();
				}
				$arrdata['rowmt'] = $this->db->query("SELECT A.NAMA_USER, A.JABATAN, A.USER_ID, CONVERT(VARCHAR(10), B.PEJABAT_TANGGAL, 103) AS TTDMT FROM T_USER A LEFT JOIN T_CP B ON A.USER_ID = B.MT WHERE B.CP_ID = '".$arrid[0]."'")->result_array();
				$arrdata['kesimpulan'] = $this->db->query("SELECT dbo.URAIAN_M_TABEL('HASIL',HASIL) AS HASIL, CATATAN FROM T_CP WHERE KODE_SAMPEL = '".$arrid[1]."'")->result_array();
				$arrdata['batal'] = site_url().'/home/pengujian/lhu/list/all';
				$arrdata['lingkup_uji'] = $sipt->main->combobox("SELECT ID, URAIAN FROM  M_LINGKUP_RUJUKAN", "ID", "URAIAN", TRUE);
			}
			else if($arrid[2] == "50202"){
				if(in_array('B1',$this->newsession->userdata('SESS_SUB_SARANA')) || in_array('B2',$this->newsession->userdata('SESS_SUB_SARANA'))){#Bidang Kimia Fisika
					$arrdata['parameter'] = $this->db->query("SELECT CASE WHEN JENIS_UJI = '01' THEN 'Mikrobiologi' WHEN JENIS_UJI = '02' THEN 'Kimia - Fisika' END AS JENIS_UJI, SPK_ID,PARAMETER_UJI, METODE, PUSTAKA, SYARAT, RUANG_LINGKUP, HASIL, HASIL_KUALITATIF, LCP, HASIL_PARAMETER, CASE WHEN UJI_MAMPU = '0' THEN 'Tidak' ELSE 'Ya' END AS UJI_MAMPU FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL = '".$arrid[1]."'")->result_array();
					$arrdata['hasil'] = $sipt->main->combobox("SELECT KODE,URAIAN FROM M_TABEL WHERE JENIS = 'HASIL' AND KODE IN ('HPST','MS','TMS')", "KODE", "URAIAN", TRUE);
				}else if(in_array('B3',$this->newsession->userdata('SESS_SUB_SARANA'))){#Bidang Mikro
					$arrdata['parameter'] = $this->db->query("SELECT CASE WHEN JENIS_UJI = '01' THEN 'Mikrobiologi' WHEN JENIS_UJI = '02' THEN 'Kimia - Fisika' END AS JENIS_UJI, SPK_ID,PARAMETER_UJI, METODE, PUSTAKA, SYARAT, RUANG_LINGKUP, HASIL, HASIL_KUALITATIF, LCP, HASIL_PARAMETER, CASE WHEN UJI_MAMPU = '0' THEN 'Tidak' ELSE 'Ya' END AS UJI_MAMPU FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL = '".$arrid[1]."' AND JENIS_UJI = '01'")->result_array();
				}
			}
			return $arrdata;
		}
	}

	function set_lhu($action, $isajax){
		if((in_array('2', $this->newsession->userdata('SESS_KODE_ROLE'))  || in_array('3', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('4', $this->newsession->userdata('SESS_KODE_ROLE'))) && in_array('02', $this->newsession->userdata('SESS_JENIS_PELAPORAN')) && $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			if($action=="save"){
				$hasil = FALSE;
				$chk = FALSE;
				$msgok = "Laporan Hasil Uji Berhasil di Verifikasi";
				$msgerr = "Laporan Hasil Uji Gagal di Verifikasi, Silahkan coba lagi";
				if(in_array('B1',$this->newsession->userdata('SESS_SUB_SARANA')) || in_array('B2',$this->newsession->userdata('SESS_SUB_SARANA'))){
					$lab = 'K';
				}else if(in_array('B3',$this->newsession->userdata('SESS_SUB_SARANA'))){
					$lab = 'M';
				}
				$anggaran = substr($this->input->post('KODE_SAMPEL'),9,2);
				$ko = substr($this->input->post('KODE_SAMPEL'),7,2);
				$chk = (int)$sipt->main->get_uraian("SELECT AUTO_RESET FROM M_REF_LHU WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND KOMODITI = '".$ko."' AND ANGGARAN = '".$anggaran."' AND BIDANG = '".$lab."'","AUTO_RESET");
				if($chk == 1)
					$kode_lhu = $sipt->main->set_kode_lhu($lab,$anggaran,$ko,$this->input->post('PEJABAT_TANGGAL'));
				else $kode_lhu = $sipt->main->set_kode_lhu($lab,$anggaran,$ko,$this->input->post('PEJABAT_TANGGAL'));
				$arr_lhu = array('LHU_ID' => $kode_lhu,
								 'CP_ID' => $this->input->post('CP_ID'),
								 'CREATE_DATE' => 'GETDATE()',
								 'CREATE_BY' => $this->newsession->userdata('SESS_USER_ID'));
				if($this->db->insert('T_LHU',$arr_lhu)){
					$hasil = TRUE;
					$cek_uji = $this->db->query("SELECT UJI_KIMIA, UJI_MIKRO FROM T_M_SAMPEL WHERE KODE_SAMPEL = '".$this->input->post('KODE_SAMPEL')."'")->result_array();
					if($cek_uji[0]['UJI_KIMIA'] == 1 && $cek_uji[0]['UJI_MIKRO'] == 1){
						if(in_array('B1',$this->newsession->userdata('SESS_SUB_SARANA')) || in_array('B2',$this->newsession->userdata('SESS_SUB_SARANA'))){
							$chk = TRUE;
						}else{
							$chk = FALSE;
						}
					}else{
						$chk = TRUE;
					}					
					
					if(in_array('B3',$this->newsession->userdata('SESS_SUB_SARANA'))){
						$this->db->simple_query("UPDATE T_M_SAMPEL SET STATUS_MIKRO = '1', HASIL_MIKRO = '".$this->input->post('HASIL')."' WHERE KODE_SAMPEL = '".$this->input->post('KODE_SAMPEL')."'");	
					}else if(in_array('B1',$this->newsession->userdata('SESS_SUB_SARANA')) || in_array('B2',$this->newsession->userdata('SESS_SUB_SARANA'))){
						if(!$this->input->post('BYPASS'))
						$this->db->simple_query("UPDATE T_M_SAMPEL SET STATUS_KIMIA = '1', HASIL_KIMIA = '".$this->input->post('HASIL')."' WHERE KODE_SAMPEL = '".$this->input->post('KODE_SAMPEL')."'");
						else	
						$this->db->simple_query("UPDATE T_M_SAMPEL SET STATUS_MIKRO = '1', HASIL_MIKRO = '".$this->input->post('HASIL')."' WHERE KODE_SAMPEL = '".$this->input->post('KODE_SAMPEL')."'");
					}
					
					if($this->input->post('CREATE_BY')){
						$ada = (int)$sipt->main->get_uraian("SELECT COUNT(*) AS JML FROM T_CP WHERE CP_ID = '".$this->input->post('CP_ID')."' AND KODE_SAMPEL = '".$this->input->post('KODE_SAMPEL')."' AND CREATE_BY = '".$this->input->post('CREATE_BY')."'","JML");
						if($ada > 0){
							$this->db->simple_query("SET DATEFORMAT DMY UPDATE T_CP SET PEJABAT_TANGGAL = '".$this->input->post('PEJABAT_TANGGAL')."', LAST_UPDATE = GETDATE(), HASIL = '".$this->input->post('HASIL')."', CATATAN = '".$this->input->post('CATATAN_CP')."', UPDATE_BY = '".$this->newsession->userdata('SESS_USER_ID')."', STATUS = '30203' WHERE CP_ID = '".$this->input->post('CP_ID')."'");
						}
					}
					else{
						$this->db->simple_query("SET DATEFORMAT DMY UPDATE T_CP SET PEJABAT_TANGGAL = '".$this->input->post('PEJABAT_TANGGAL')."', LAST_UPDATE = GETDATE(), HASIL = '".$this->input->post('HASIL')."', CATATAN = '".$this->input->post('CATATAN_CP')."', UPDATE_BY = '".$this->newsession->userdata('SESS_USER_ID')."', STATUS = '30203' WHERE CP_ID = '".$this->input->post('CP_ID')."'");
					}
					
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
					return "MSG#YES#$msgok.#".site_url().'/home/pengujian/lhu/list/draft';
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
						return "MSG#NO#Konsep Laporan gagal diproses. \n Dikarenakan LHU Mikro atau Kimia belum diverifikasi"; die();
					}
				}else{
					$hasil = TRUE;
				}
				if($hasil){
					if($this->input->post('HASIL_SAMPEL')){
						$dtsampel = $sipt->main->post_to_query($this->input->post('SAMPEL'));
						$dtsampel['STATUS_SAMPEL'] = '40204';
						/*$dtsampel['HASIL_KIMIA'] = $this->input->post('HASIL_KIMIA');
						$dtsampel['HASIL_MIKRO'] = $this->input->post('HASIL_MIKRO');*/
						$dtsampel['HASIL_SAMPEL'] = $this->input->post('HASIL_SAMPEL');
						$this->db->where('KODE_SAMPEL', $this->input->post('KODE_SAMPEL'));
						$this->db->update('T_M_SAMPEL', $dtsampel);
					}
					$this->db->simple_query("UPDATE T_PARAMETER_HASIL_UJI SET STATUS = '40204' WHERE KODE_SAMPEL = '".$this->input->post('KODE_SAMPEL')."'");
					$this->db->simple_query("SET DATEFORMAT DMY UPDATE T_CP SET LAST_UPDATE = GETDATE(), UPDATE_BY = '".$this->newsession->userdata('SESS_USER_ID')."', STATUS = '40204' WHERE KODE_SAMPEL = '".$this->input->post('KODE_SAMPEL')."' AND CREATE_BY = '".$this->newsession->userdata('SESS_USER_ID')."'");
					$logcp = array('CP_ID' => $this->input->post('CP_ID'),
								   'WAKTU' => 'GETDATE()',
								   'USER_ID' => $this->newsession->userdata('SESS_USER_ID'),
								   'KEGIATAN' => 'Pembuatan Konsep Pelaporan',
								   'CATATAN' => '-');
					$this->db->insert('T_CP_LOG', $logcp);
					return "MSG#YES#$msgok#".site_url().'/home/pengujian/lhu/list/data';
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
				/*Cek jumlah checkbox parameter
				- Jika lebih dari 0 
					1. Insert ke tabel T_PARAMETER_UJI_RUJUKAN (select dari T_PARAMETER_HASIL_UJI WHERE ID = 'value checkbox')
					2. UPDATE T_M_SAMPEL 
						STATUS_SAMPEL = '50203'
						UJI_RUJUK = '1'
						BBPOM_RUJUK = $_POST['BBPOM_RUJUK']
						JML_RUJUK = jumlah checkbox WHERE KODE_SAMPEL = '$_POST['KODE_SAMPE']
					3. Update T_PARAMETER_HASIL_UJI SET STATUS = '50202' WHERE KODE_SAMPEL = '$_POST['KODE_SAMPE']
						
				- Jika tidak jalanin yang bawah (proses) normal.
				*/
				$jml_rujuk = count($_POST['chk_uji']);
				if($jml_rujuk > 0){
					$arrrujukan = $this->input->post('RUJUKAN');
					$group = array();
					for($y = 0; $y < count($arrrujukan['BBPOM_ID']); $y++){
						if(!array_key_exists($arrrujukan['BBPOM_ID'][$y], $group)) $group[$arrrujukan['BBPOM_ID'][$y]] = $arrrujukan['BBPOM_ID'][$y];
					}
					foreach($group as $val){
						$head_rujuk = array('KODE_SAMPEL' => $this->input->post('KODE_SAMPEL'),
											'BBPOM_ASAL' => $this->newsession->userdata('SESS_BBPOM_ID'),
											'BBPOM_RUJUK' => $val,
											'JUMLAH_SAMPEL' => $this->input->post('JUMLAH_SAMPEL'),
											'STATUS_RUJUKAN' => '0',
											'CREATE_BY' => $this->newsession->userdata('SESS_USER_ID'),
											'CREATE_DATE' => 'GETDATE()');
						$this->db->insert('T_SAMPEL_RUJUKAN', $head_rujuk);
					}
					for($i = 0; $i < count($_POST['RUJUKAN']); $i++){							
							$queryc = "SELECT UJI_ID, KODE_SAMPEL, GOLONGAN, PARAMETER_UJI, SIMULAN, KATEGORI_PU, METODE, PUSTAKA, SYARAT, RUANG_LINGKUP, JENIS_UJI, SYARAT_UJI, HASIL, HASIL_KUALITATIF, HASIL_PARAMETER, CATATAN, LCP FROM T_PARAMETER_HASIL_UJI WHERE UJI_ID = '".$arrrujukan['UJI_ID'][$i]."'";
							$datac = $sipt->main->get_result($queryc);
							if($datac){
								$inc = 0;
								foreach($queryc->result_array() as $row){
									$arrtmp['UJI_ID'] = $row['UJI_ID'];
									$arrtmp['KODE_SAMPEL'] = $row['KODE_SAMPEL'];						
									$arrtmp['BBPOM_ID'] = $arrrujukan['BBPOM_ID'][$i];
									$arrtmp['LINGKUP_UJI'] = $arrrujukan['LINGKUP_UJI'][$i];
									$arrtmp['GOLONGAN'] = $row['GOLONGAN'];
									$arrtmp['PARAMETER_UJI'] = $row['PARAMETER_UJI'];
									$arrtmp['SIMULAN'] = $row['SIMULAN'];
									$arrtmp['KATEGORI_PU'] = $row['KATEGORI_PU'];
									$arrtmp['METODE'] = $row['METODE'];
									$arrtmp['PUSTAKA'] = $row['PUSTAKA'];
									$arrtmp['SYARAT'] = $row['SYARAT'];
									$arrtmp['RUANG_LINGKUP'] = $row['RUANG_LINGKUP'];
									$arrtmp['JENIS_UJI'] = $row['JENIS_UJI'];
									$arrtmp['SYARAT_UJI'] = $row['SYARAT_UJI'];
									$arrtmp['HASIL'] = $row['HASIL'];
									$arrtmp['HASIL_KUALITATIF'] = $row['HASIL_KUALITATIF'];
									$arrtmp['HASIL_PARAMETER'] = $row['HASIL_PARAMETER'];
									$arrtmp['CATATAN'] = $row['CATATAN'];
									$arrtmp['LCP'] = $row['LCP'];
									$this->db->insert('T_SAMPEL_RUJUKAN_DETIL', $arrtmp);
									if($this->db->affected_rows() > 0){
										$inc++;
									}
								}									
							}
					}
					
					if($inc > 0){
						$arrsampel = array('UJI_RUJUK' => '1',
										   'UPDATE_DATE' => 'GETDATE()',
										   'UPDATE_BY' => $this->newsession->userdata('SESS_USER_ID'),
										   'STATUS_SAMPEL' => '50203');
						$this->db->where('KODE_SAMPEL', $this->input->post('KODE_SAMPEL'));
						$this->db->update('T_M_SAMPEL', $arrsampel);				   
						if($this->db->affected_rows() > 0){
							$this->db->simple_query("SET DATEFORMAT DMY UPDATE T_CP SET LAST_UPDATE = GETDATE(), UPDATE_BY = '".$this->newsession->userdata('SESS_USER_ID')."', STATUS = '50202' WHERE KODE_SAMPEL = '".$this->input->post('KODE_SAMPEL')."'");
							$logcp = array('CP_ID' => $this->input->post('CP_ID'),
										   'WAKTU' => 'GETDATE()',
										   'USER_ID' => $this->newsession->userdata('SESS_USER_ID'),
										   'KEGIATAN' => 'Verifikasi konsep laporan dan kirim hasil akhir sampel',
										   'CATATAN' => $row['CATATAN_CP']);
							$this->db->insert('T_CP_LOG', $logcp);
							$data = array('KODE_SAMPEL' => $dtsampel['KODE_SAMPEL'],
										  'WAKTU' => 'GETDATE()',
										  'USER_ID' => $this->newsession->userdata('SESS_USER_ID'),
										  'KEGIATAN' => 'Penentuan Parameter Uji Rujuk',
										  'CATATAN' => $this->input->post('CATATAN'));
							$this->db->insert('T_SAMPLING_LOG', $data);				   
							$hasil = TRUE;
						}
					}
				}else{
					
					if($this->input->post('KODE_RUJUKAN')){#Update hasil sampel rujukan sebelum dikirim ke balai asal.
						$status_rujukan = array('STATUS_RUJUKAN' => '2','STATUS' => '50204');
						$this->db->where('KODE_SAMPEL', $this->input->post('KODE_RUJUKAN'));
						$this->db->where('BBPOM_RUJUK', $this->newsession->userdata('SESS_BBPOM_ID'));
						$this->db->update('T_SAMPEL_RUJUKAN', $status_rujukan);
						if($this->db->affected_rows() > 0){
							$chkstatusrujukan = $sipt->main->get_uraian("SELECT COUNT(*) AS JML FROM (SELECT DISTINCT(STATUS_RUJUKAN) AS JML FROM T_SAMPEL_RUJUKAN WHERE KODE_SAMPEL = '".$this->input->post('KODE_RUJUKAN')."') AS DATA","JML");
							if($this->input->post('HASIL_SAMPEL')){
								$dtsampel['HASIL_SAMPEL'] = $this->input->post('HASIL_SAMPEL');
								$this->db->where('KODE_SAMPEL', $this->input->post('KODE_SAMPEL'));
								$this->db->update('T_M_SAMPEL', $dtsampel);
								if($this->db->affected_rows() == 1){
									if((int)$chkstatusrujukan == 1){
										$arrstatus = array('STATUS_SAMPEL' => '50204');
										$this->db->where('KODE_SAMPEL', $this->input->post('KODE_RUJUKAN'));
										$this->db->update('T_M_SAMPEL', $arrstatus);
									}
									$this->db->simple_query("SET DATEFORMAT DMY  UPDATE T_M_SAMPEL SET STATUS_SAMPEL = '50204', UPDATE_BY = '".$this->newsession->userdata('SESS_USER_ID')."', UPDATE_DATE = GETDATE() WHERE KODE_SAMPEL = '".$this->input->post('KODE_SAMPEL')."'");
									$this->db->simple_query("UPDATE T_PARAMETER_HASIL_UJI SET STATUS = '50204' WHERE KODE_SAMPEL = '".$this->input->post('KODE_SAMPEL')."'");	
								
									$this->db->simple_query("SET DATEFORMAT DMY UPDATE T_CP SET LAST_UPDATE = GETDATE(), UPDATE_BY = '".$this->newsession->userdata('SESS_USER_ID')."', STATUS = '50202' WHERE KODE_SAMPEL = '".$this->input->post('KODE_SAMPEL')."'");
									$logcp = array('CP_ID' => $this->input->post('CP_ID'),
												   'WAKTU' => 'GETDATE()',
												   'USER_ID' => $this->newsession->userdata('SESS_USER_ID'),
												   'KEGIATAN' => 'Verifikasi konsep laporan dan kirim hasil akhir sampel',
												   'CATATAN' => $row['CATATAN_CP']);
									$this->db->insert('T_CP_LOG', $logcp);
									$hasil = TRUE;
								}
							}
						}
					}
					
					else{#Update proses sampel normal;
						
						$chkunggulan = $sipt->main->get_uraian("SELECT KODE_UNGGULAN FROM T_M_SAMPEL WHERE KODE_SAMPEL = '".$this->input->post('KODE_SAMPEL')."'","KODE_UNGGULAN");
						
						$checkrujukan = $sipt->main->get_uraian("SELECT COUNT(*) AS JML FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL = '".$this->input->post('KODE_SAMPEL')."' AND UJI_MAMPU = '0'", "JML");
						if($checkrujukan > 0){
							return "MSG#NO#Laporan gagal dikirim.\n Ini dikarenakan ada beberapa parameter uji yang akan dirujuk. \n Silahkan untuk memeriksa kembali daftar parameter uji yang akan di rujuk. \n Parameter uji yang akan dirujuk bisa dilihat pada kolom Mampu uji dengan keterangan Tidak.";
							die();
						}
				if($this->input->post('HASIL_SAMPEL')){
					$dtsampel['HASIL_SAMPEL'] = $this->input->post('HASIL_SAMPEL');
					$this->db->where('KODE_SAMPEL', $this->input->post('KODE_SAMPEL'));
					$this->db->update('T_M_SAMPEL', $dtsampel);
				}
				$awal_uji = $sipt->main->get_uraian("SELECT MIN(CONVERT(VARCHAR(10), AWAL_UJI, 120)) AS MINTGL FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL = '".$this->input->post('KODE_SAMPEL')."' GROUP BY KODE_SAMPEL","MINTGL");
				$akhir_uji = $sipt->main->get_uraian("SELECT MAX(CONVERT(VARCHAR(10), AKHIR_UJI, 120)) AS MAXTGL FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL = '".$this->input->post('KODE_SAMPEL')."' GROUP BY KODE_SAMPEL","MAXTGL");
				$query = "SELECT KODE_SAMPEL,KOMODITI,KATEGORI, NAMA_KATEGORI, ANGGARAN,ASAL_SAMPEL,CONVERT(VARCHAR(10), TANGGAL_SAMPLING, 103) AS TUJUAN_SAMPLING, SUB_TUJUAN, PRIORITAS, TANGGAL_SAMPLING,SARANA_ID,TEMPAT_SAMPLING,ALAMAT_SAMPLING,NAMA_SAMPEL,NOMOR_REGISTRASI,PABRIK,IMPORTIR,BENTUK_SEDIAAN,KEMASAN,NO_BETS,KETERANGAN_ED,JUMLAH_SAMPEL,SATUAN,HARGA_SAMPEL,UJI_KIMIA,JUMLAH_KIMIA,UJI_MIKRO,JUMLAH_MIKRO,SISA,KOMPOSISI,NETTO,KONDISI_SAMPEL,EVALUASI_PENANDAAN,CARA_PENYIMPANAN,HASIL_KIMIA,HASIL_MIKRO, UJI_UNGGULAN, HASIL_SAMPEL,PEMERIAN, LAMPIRAN, CATATAN_CP, UJI_RUJUK, BBPOM_RUJUK, JML_RUJUK, HASIL_KIMIA_RUJUK, HASIL_MIKRO_RUJUK, HASIL_SAMPEL_RUJUK, CATATAN_CP_RUJUK, JML_IRISAN, KOMODITI_IRISAN FROM T_M_SAMPEL WHERE KODE_SAMPEL = '".$this->input->post('KODE_SAMPEL')."'";
				$data = $sipt->main->get_result($query);
				if($data){
					foreach($query->result_array() as $row){						
						$arrrilis['KODE_SAMPEL'] = $row['KODE_SAMPEL'];
						$arrrilis['BBPOM_ID'] = $this->newsession->userdata('SESS_BBPOM_ID');
						$arrrilis['KOMODITI'] = $row['KOMODITI'];
						$arrrilis['KATEGORI'] = $row['KATEGORI'];
						$arrrilis['ANGGARAN'] = $row['ANGGARAN'];
						$arrrilis['TUJUAN_SAMPLING'] = $row['TUJUAN_SAMPLING'];
						$arrrilis['AWAL_UJI'] = $awal_uji;
						$arrrilis['AKHIR_UJI'] = $akhir_uji;
						$arrrilis['SUB_TUJUAN'] = $row['SUB_TUJUAN'];
						$arrrilis['PRIORITAS'] = $row['PRIORITAS'];
						$arrrilis['NAMA_SAMPEL'] = $row['NAMA_SAMPEL'];
						$arrrilis['ASAL_SAMPEL'] = $row['ASAL_SAMPEL'];
						$arrrilis['TANGGAL_SAMPLING'] = $row['TANGGAL_SAMPLING'];
						$arrrilis['SARANA_ID'] = $row['SARANA_ID'];
						$arrrilis['TEMPAT_SAMPLING'] = $row['TEMPAT_SAMPLING'];
						$arrrilis['ALAMAT_SAMPLING'] = $row['ALAMAT_SAMPLING'];
						$arrrilis['NOMOR_REGISTRASI'] = $row['NOMOR_REGISTRASI'];
						$arrrilis['PABRIK'] = $row['PABRIK'];
						$arrrilis['IMPORTIR'] = $row['IMPORTIR'];
						$arrrilis['BENTUK_SEDIAAN'] = $row['BENTUK_SEDIAAN'];
						$arrrilis['KEMASAN'] = $row['KEMASAN'];
						$arrrilis['NO_BETS'] = $row['NO_BETS'];
						$arrrilis['KETERANGAN_ED'] = $row['KETERANGAN_ED'];
						$arrrilis['JUMLAH_SAMPEL'] = $row['JUMLAH_SAMPEL'];
						$arrrilis['SATUAN'] = $row['SATUAN'];
						$arrrilis['HARGA_SAMPEL'] = $row['HARGA_SAMPEL'];
						$arrrilis['UJI_KIMIA'] = $row['UJI_KIMIA'];
						$arrrilis['JUMLAH_KIMIA'] = $row['JUMLAH_KIMIA'];
						$arrrilis['UJI_MIKRO'] = $row['UJI_MIKRO'];
						$arrrilis['JUMLAH_MIKRO'] = $row['JUMLAH_MIKRO'];
						$arrrilis['SISA'] = $row['SISA'];
						$arrrilis['KOMPOSISI'] = $row['KOMPOSISI'];
						$arrrilis['NETTO'] = $row['NETTO'];
						$arrrilis['KONDISI_SAMPEL'] = $row['KONDISI_SAMPEL'];
						$arrrilis['EVALUASI_PENANDAAN'] = $row['EVALUASI_PENANDAAN'];
						$arrrilis['CARA_PENYIMPANAN'] = $row['CARA_PENYIMPANAN'];
						$arrrilis['HASIL_KIMIA'] = $row['HASIL_KIMIA'];
						$arrrilis['HASIL_MIKRO'] = $row['HASIL_MIKRO'];
						$arrrilis['UJI_UNGGULAN'] = $row['UJI_UNGGULAN'];
						$arrrilis['HASIL_SAMPEL'] = $row['HASIL_SAMPEL'];
						$arrrilis['UJI_RUJUK'] = $row['UJI_RUJUK'];
						$arrrilis['UJI_UNGGULAN'] = (strlen(trim($chkunggulan)) > 0 ? (int)'1' : 'NULL');
						$arrrilis['BBPOM_RUJUK'] = $row['BBPOM_RUJUK'];
						$arrrilis['JML_RUJUK'] = $row['JML_RUJUK'];
						$arrrilis['HASIL_KIMIA_RUJUK'] = $row['HASIL_KIMIA_RUJUK'];
						$arrrilis['HASIL_MIKRO_RUJUK'] = $row['HASIL_MIKRO_RUJUK'];
						$arrrilis['HASIL_SAMPEL_RUJUK'] = $row['HASIL_SAMPEL_RUJUK'];
						$arrrilis['CATATAN_CP_RUJUK'] = $row['CATATAN_CP_RUJUK'];
						$arrrilis['JML_IRISAN'] = $row['JML_IRISAN'];
						$arrrilis['KOMODITI_IRISAN'] = $row['KOMODITI_IRISAN'];
						$arrrilis['PEMERIAN'] = $row['PEMERIAN'];
						$arrrilis['LAMPIRAN'] = $row['LAMPIRAN'];
						$arrrilis['CATATAN_CP'] = $row['CATATAN_CP'];
						$arrrilis['CREATE_BY'] = $this->newsession->userdata('SESS_USER_ID');
						$arrrilis['CREATE_DATE'] = 'GETDATE()';
						$arrrilis['STATUS'] = '50202';
						$dtsampel['NAMA_KATEGORI'] = $row['NAMA_KATEGORI'];
						$res = $this->db->insert('T_M_SAMPEL_RILIS',$arrrilis);
						if($res){
							$hasil = TRUE;
							insert_rkpsampel_helper($this->input->post('KODE_SAMPEL'));
						}
					}
					if($hasil){
						$this->db->simple_query("SET DATEFORMAT DMY  UPDATE T_M_SAMPEL SET STATUS_SAMPEL = '50202', UPDATE_BY = '".$this->newsession->userdata('SESS_USER_ID')."', UPDATE_DATE = GETDATE() WHERE KODE_SAMPEL = '".$this->input->post('KODE_SAMPEL')."'");	
						$this->db->simple_query("UPDATE T_PARAMETER_HASIL_UJI SET STATUS = '50202' WHERE KODE_SAMPEL = '".$this->input->post('KODE_SAMPEL')."'");	
						
						$param = "SELECT UJI_ID, SPK_ID, KODE_SAMPEL, GOLONGAN, PARAMETER_UJI, SIMULAN, KATEGORI_PU, METODE, PUSTAKA, SYARAT, RUANG_LINGKUP, PEMERIAN, IDENTIFIKASI, JENIS_UJI, SYARAT_UJI, JUMLAH_UJI, SISA_UJI, REAGEN, JUMLAH_REAGEN, HASIL, HASIL_KUALITATIF, HASIL_PARAMETER, CATATAN, PENYELIA, PENGUJI, AWAL_UJI, AKHIR_UJI, LCP, STATUS, UJI_MAMPU FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL = '".$this->input->post('KODE_SAMPEL')."'";
						$dparam = $sipt->main->get_result($param);
						if($dparam){
							foreach($param->result_array() as $rparam){
								$arrparam['UJI_ID'] = $rparam['UJI_ID'];
								$arrparam['SPK_ID'] = $rparam['SPK_ID'];
								$arrparam['KODE_SAMPEL'] = $rparam['KODE_SAMPEL'];
								$arrparam['GOLONGAN'] = $rparam['GOLONGAN'];
								$arrparam['PARAMETER_UJI'] = $rparam['PARAMETER_UJI'];
								$arrparam['SIMULAN'] = $rparam['SIMULAN'];
								$arrparam['KATEGORI_PU'] = $rparam['KATEGORI_PU'];
								$arrparam['METODE'] = $rparam['METODE'];
								$arrparam['PUSTAKA'] = $rparam['PUSTAKA'];
								$arrparam['SYARAT'] = $rparam['SYARAT'];
								$arrparam['RUANG_LINGKUP'] = $rparam['RUANG_LINGKUP'];
								$arrparam['PEMERIAN'] = $rparam['PEMERIAN'];
								$arrparam['IDENTIFIKASI'] = $rparam['IDENTIFIKASI'];
								$arrparam['JENIS_UJI'] = $rparam['JENIS_UJI'];
								$arrparam['SYARAT_UJI'] = $rparam['SYARAT_UJI'];
								$arrparam['JUMLAH_UJI'] = $rparam['JUMLAH_UJI'];
								$arrparam['SISA_UJI'] = $rparam['SISA_UJI'];
								$arrparam['REAGEN'] = $rparam['REAGEN'];
								$arrparam['JUMLAH_REAGEN'] = $rparam['JUMLAH_REAGEN'];
								$arrparam['HASIL'] = $rparam['HASIL'];
								$arrparam['HASIL_KUALITATIF'] = $rparam['HASIL_KUALITATIF'];
								$arrparam['HASIL_PARAMETER'] = $rparam['HASIL_PARAMETER'];
								$arrparam['CATATAN'] = $rparam['CATATAN'];
								$arrparam['PENYELIA'] = $rparam['PENYELIA'];
								$arrparam['PENGUJI'] = $rparam['PENGUJI'];
								$arrparam['AWAL_UJI'] = $rparam['AWAL_UJI'];
								$arrparam['AKHIR_UJI'] = $rparam['AKHIR_UJI'];
								$arrparam['LCP'] = $rparam['LCP'];
								$arrparam['UJI_MAMPU'] = $rparam['UJI_MAMPU'];
								$arrparam['STATUS'] = $rparam['STATUS'];
								$this->db->insert('T_PARAMETER_HASIL_UJI_RILIS',$arrparam);
							}
						}
						
						$this->db->simple_query("SET DATEFORMAT DMY UPDATE T_CP SET LAST_UPDATE = GETDATE(), UPDATE_BY = '".$this->newsession->userdata('SESS_USER_ID')."', STATUS = '50202' WHERE KODE_SAMPEL = '".$this->input->post('KODE_SAMPEL')."'");
						$logcp = array('CP_ID' => $this->input->post('CP_ID'),
									   'WAKTU' => 'GETDATE()',
									   'USER_ID' => $this->newsession->userdata('SESS_USER_ID'),
									   'KEGIATAN' => 'Verifikasi konsep laporan dan kirim hasil akhir sampel',
									   'CATATAN' => $row['CATATAN_CP']);
						$this->db->insert('T_CP_LOG', $logcp);

					}
				}
						
					}
					
				}
				
				if($hasil){
					return "MSG#YES#$msgok#".site_url().'/home/pengujian/lhu/list/all';
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