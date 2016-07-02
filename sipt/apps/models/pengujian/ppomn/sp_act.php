<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR);
class Sp_act extends Model{
	function list_sp($id){
		if((in_array('04',$this->newsession->userdata('SESS_KODE_ROLE')) && in_array('02', $this->newsession->userdata('SESS_JENIS_PELAPORAN'))) && $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$this->load->library('newtable');
			if($id == "verifikasi"){
				$judul = "Daftar Pengujian Sampel - Proses Verifikasi Sampel Pembuatan SPK";
				$query = "SELECT A.PERIKSA_SAMPEL, A.KODE_SAMPEL, dbo.FORMAT_NOMOR('SPL', A.KODE_SAMPEL) AS 'KODE SAMPEL', dbo.FORMAT_NOMOR('SPU',A.SPU_ID) AS 'NOMOR SPU', CONVERT(VARCHAR(10), C.TANGGAL, 120) AS 'TANGGAL SPU', dbo.FORMAT_NOMOR('SP', C.NOMOR_SP) AS 'NOMOR SP', CONVERT(VARCHAR(10), C.TANGGAL_PERINTAH, 120) AS 'TANGGAL SP',A.NAMA_SAMPEL AS 'NAMA SAMPEL', dbo.KATEGORI(A.KOMODITI,A.PRIORITAS) AS 'KOMODITI' FROM T_SAMPEL_MT B LEFT JOIN T_M_SAMPEL A ON A.KODE_SAMPEL = B.KODE_SAMPEL LEFT JOIN T_SPU C ON B.SPU_ID = C.SPU_ID WHERE B.USER_ID = '".$this->newsession->userdata('SESS_USER_ID')."' AND B.STATUS = '40201'";
				$this->newtable->columns(array("A.PERIKSA_SAMPEL","A.KODE_SAMPEL",array("dbo.FORMAT_NOMOR('SPL', A.KODE_SAMPEL)",site_url()."/home/sampel/preview/{PERIKSA_SAMPEL}.{KODE_SAMPEL}"), "dbo.FORMAT_NOMOR('SPU',A.SPU_ID)", "CONVERT(VARCHAR(10), C.TANGGAL, 120)","dbo.FORMAT_NOMOR('SP', C.NOMOR_SP)","CONVERT(VARCHAR(10), C.TANGGAL_PERINTAH, 120)","A.NAMA_SAMPEL", "dbo.KATEGORI(A.KOMODITI,A.PRIORITAS)"));
				$this->newtable->search(array(array("dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL)", "Kode Sampel"),
										      array("dbo.FORMAT_NOMOR('SPU',A.SPU_ID)", "Nomor Surat Perintah Uji"),
											  array("A.NAMA_SAMPEL", "Nama Sampel"),
											  array("dbo.KATEGORI(A.KOMODITI,A.PRIORITAS)", "Komoditi")));						  
				$this->newtable->width(array('KODE SAMPEL' => 125, 'NOMOR SPU' => 125, 'TANGGAL SPU' => 80, 'NOMOR SP' => 125, 'TANGGAL SP' => 80, 'NAMA SAMPEL' => 200));
				$this->newtable->hiddens(array('PERIKSA_SAMPEL','KODE_SAMPEL'));
				$this->newtable->keys(array('KODE_SAMPEL'));
				$proses['Tambah SPK Baru'] = array('GET', site_url()."/home/ppomn/spk/new", '1');
			}else if($id == "send"){
				$judul = "Daftar Pengujian Sampel - SPK Terkirim";
				$query = "SELECT C.KODE_SAMPEL, C.PERIKSA_SAMPEL, dbo.FORMAT_NOMOR('SPL', C.KODE_SAMPEL) AS [KODE SAMPEL], dbo.FORMAT_NOMOR('SPU',A.SPU_ID) AS [NOMOR SPU], dbo.FORMAT_NOMOR('SPK',B.SPK_ID) AS [NOMOR SPK], CONVERT(VARCHAR(10), B.TANGGAL, 120) AS [TANGGAL SPK], C.NAMA_SAMPEL AS [NAMA SAMPEL], dbo.KATEGORI(SUBSTRING(A.SPU_ID, 13,2),'0') AS [KOMODITI], D.NAMA_USER AS [PENYELIA] FROM T_SPK B LEFT JOIN T_SPU A ON B.SPU_ID = A.SPU_ID LEFT JOIN T_M_SAMPEL C ON B.KODE_SAMPEL = C.KODE_SAMPEL LEFT JOIN T_USER D ON B.KASIE = D.USER_ID WHERE A.BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND B.CREATE_BY = '".$this->newsession->userdata('SESS_USER_ID')."' AND B.STATUS NOT IN ('40205')";
				$this->newtable->columns(array("C.KODE_SAMPEL","C.PERIKSA_SAMPEL",array("dbo.FORMAT_NOMOR('SPL', A.KODE_SAMPEL)",site_url()."/home/sampel/preview/{PERIKSA_SAMPEL}.{KODE_SAMPEL}"), "dbo.FORMAT_NOMOR('SPU',A.SPU_ID)", "dbo.FORMAT_NOMOR('SPK',B.SPK_ID)", "CONVERT(VARCHAR(10), B.TANGGAL, 120)", "C.NAMA_SAMPEL", "dbo.KATEGORI(SUBSTRING(A.SPU_ID, 13,2),'0')", "D.NAMA_USER"));
				$this->newtable->search(array(array("dbo.FORMAT_NOMOR('SPL',C.KODE_SAMPEL)", "Kode Sampel"),
										      array("dbo.FORMAT_NOMOR('SPK',B.SPK_ID)", "Nomor Surat Perintah Kerja"),
										      array("dbo.FORMAT_NOMOR('SPU',A.SPU_ID)", "Nomor Surat Perintah Uji"),
											  array("A.NAMA_SAMPEL", "Nama Sampel"),
											  array("dbo.KATEGORI(SUBSTRING(A.SPU_ID, 13,2),'0')", "Komoditi")));
				$this->newtable->width(array('KODE SAMPEL' => 125, 'NOMOR SPU' => 125, 'NOMOR SPK' => 125, 'TANGGAL SPK' => 80, 'NAMA SAMPEL' => 200, 'KOMODITI' => 150, 'PENYELIA' => 175));
				$this->newtable->hiddens(array('PERIKSA_SAMPEL','KODE_SAMPEL'));
				$this->newtable->keys(array('KODE_SAMPEL'));
				$proses['Detail Surat Perintah Kerja'] = array('GET', site_url()."/home/ppomn/spk/view", '1');
				$proses['Cetak Surat Perintah Kerja Terpilih'] = array('GETNEW', site_url()."/topdf/ppomn/cetak/spk", 'N');
			}else if($id == "review"){
				$judul = "Daftar Pengujian Sampel - Review SPK dan Parameter Uji";
				$query = "SELECT B.SPK_ID, C.KODE_SAMPEL, C.PERIKSA_SAMPEL, dbo.FORMAT_NOMOR('SPL', C.KODE_SAMPEL) AS [KODE SAMPEL], dbo.FORMAT_NOMOR('SPU',A.SPU_ID) AS [NOMOR SPU], dbo.FORMAT_NOMOR('SPK',B.SPK_ID) AS [NOMOR SPK], CONVERT(VARCHAR(10), B.TANGGAL, 120) AS [TANGGAL SPK], C.NAMA_SAMPEL AS [NAMA SAMPEL], dbo.KATEGORI(SUBSTRING(A.SPU_ID, 13,2),'0') AS [KOMODITI], D.NAMA_USER AS [PENYELIA] FROM T_SPK B LEFT JOIN T_SPU A ON B.SPU_ID = A.SPU_ID LEFT JOIN T_M_SAMPEL C ON B.KODE_SAMPEL = C.KODE_SAMPEL LEFT JOIN T_USER D ON B.CREATE_BY = D.USER_ID WHERE A.BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND B.CREATE_BY = '".$this->newsession->userdata('SESS_USER_ID')."' AND B.STATUS= '40205'";
				$this->newtable->columns(array("B.SPK_ID","C.KODE_SAMPEL","C.PERIKSA_SAMPEL",array("dbo.FORMAT_NOMOR('SPL', A.KODE_SAMPEL)",site_url()."/home/sampel/preview/{PERIKSA_SAMPEL}.{KODE_SAMPEL}"), "dbo.FORMAT_NOMOR('SPU',A.SPU_ID)", "dbo.FORMAT_NOMOR('SPK',B.SPK_ID)", "CONVERT(VARCHAR(10), B.TANGGAL, 120)", "C.NAMA_SAMPEL", "dbo.KATEGORI(SUBSTRING(A.SPU_ID, 13,2),'0')", "D.NAMA_USER"));
				$this->newtable->search(array(array("dbo.FORMAT_NOMOR('SPL',C.KODE_SAMPEL)", "Kode Sampel"),
										      array("dbo.FORMAT_NOMOR('SPK',B.SPK_ID)", "Nomor Surat Perintah Kerja"),
											  array("A.NAMA_SAMPEL", "Nama Sampel"),
											  array("dbo.KATEGORI(SUBSTRING(A.SPU_ID, 13,2),'0')", "Komoditi")));
				$this->newtable->width(array('KODE SAMPEL' => 125, 'NOMOR SPU' => 125, 'NOMOR SPK' => 125, 'TANGGAL SPK' => 80, 'NAMA SAMPEL' => 200, 'KOMODITI' => 150, 'PENYELIA' => 175));
				$this->newtable->hiddens(array('SPK_ID','PERIKSA_SAMPEL','KODE_SAMPEL'));
				$this->newtable->keys(array('SPK_ID'));
				$proses['Review SPK'] = array('GET', site_url()."/home/ppomn/spk/review", '1');
			}
			$this->newtable->action(site_url()."/home/ppomn/sp/list/".$id);
			$this->newtable->cidb($this->db);
			$this->newtable->ciuri($this->uri->segment_array());
			$this->newtable->orderby(1);
			$this->newtable->sortby("ASC");
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

	function get_spp($id){
		if((in_array('3', $this->newsession->userdata('SESS_KODE_ROLE')) && in_array('02', $this->newsession->userdata('SESS_JENIS_PELAPORAN'))) && $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$params = explode(".",$id);
			$jml = count($params);
			if($jml < 2){
				return redirect(base_url());
			}
			$arrdata = array();
			if(in_array('B1',$this->newsession->userdata('SESS_SUB_SARANA')) || in_array('B2',$this->newsession->userdata('SESS_SUB_SARANA')) || in_array('B3',$this->newsession->userdata('SESS_SUB_SARANA')) || in_array('B4',$this->newsession->userdata('SESS_SUB_SARANA'))){
				$arrdata['jenis_uji'] = "01";
				$bidang = "B.UJI_KIMIA = '1'";
			}else if(in_array('B5',$this->newsession->userdata('SESS_SUB_SARANA'))){
				$arrdata['jenis_uji'] = "02";
				$bidang = "B.UJI_MIKRO = '1'";
			}		  
			$query = "SELECT A.UJI_ID, A.PARAMETER_UJI AS PARAM, A.METODE, A.PUSTAKA, dbo.FORMAT_NOMOR('SPL',B.KODE_SAMPEL) AS KODE_SAMPEL, B.NAMA_SAMPEL, dbo.KATEGORI(B.KATEGORI, B.PRIORITAS) AS KOMODITI FROM T_PARAMETER_HASIL_UJI A LEFT JOIN T_M_SAMPEL B ON A.KODE_SAMPEL = B.KODE_SAMPEL WHERE A.SPK_ID = '".$params[1]."' AND $bidang ORDER BY 5 ASC"; 
			$data = $sipt->main->get_result($query);
			if($data){
				foreach($query->result_array() as $row){
					$arr [] = $row;
					$arrdata['arr'] = $arr;
					$arrdata['act'] = site_url().'/post/ppomn/spk_act/spp-save';
				}
				
			}
			$arrdata['dtspk'] = $this->db->query("SELECT dbo.FORMAT_NOMOR('SPK', A.SPK_ID) UR_SPK, dbo.FORMAT_NOMOR('SPU', A.SPU_ID) UR_SPU, CONVERT(VARCHAR(10), B.TANGGAL, 105) AS TANGGAL_SPU, CONVERT(VARCHAR(10), A.TANGGAL, 105) AS TANGGAL_SPK, C.NAMA_USER FROM T_SPK A LEFT JOIN T_SPU B ON A.SPU_ID = B.SPU_ID LEFT JOIN T_USER C ON A.CREATE_BY = C.USER_ID WHERE SPK_ID = '".$params[1]."'")->result_array();
			$kdsampel = $sipt->main->get_uraian("SELECT DISTINCT(KODE_SAMPEL) AS KODE FROM T_PARAMETER_HASIL_UJI WHERE SPK_ID = '".$params[1]."'","KODE");
			$arrdata['logspk'] = $sipt->main->get_uraian("SELECT COUNT(*) LOGSPK FROM T_SPK_LOG WHERE SPK_ID = '".$params[1]."'","LOGSPK"); 
			$arrdata['logspu'] = $sipt->main->get_uraian("SELECT COUNT(*) LOGSPU FROM T_SPU_LOG WHERE SPU_ID = '".$params[0]."'","LOGSPU"); 
			$arrdata['kode_sampel'] = $sipt->main->get_uraian("SELECT DISTINCT(KODE_SAMPEL) AS KODE_SAMPEL FROM T_PARAMETER_HASIL_UJI WHERE SPK_ID = '".$params[1]."'","KODE_SAMPEL"); 
			$arrdata['spkid'] = $params[1];
			$arrdata['spuid'] = $params[0];
			$arrdata['batal'] = site_url().'/home/ppomn/spp/list/verifikasi';
			return $arrdata;
		}
	}

	function view_spp($id){
		if((in_array('3', $this->newsession->userdata('SESS_KODE_ROLE')) && in_array('02', $this->newsession->userdata('SESS_JENIS_PELAPORAN'))) && $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			if($id!=""){
				$query = "SELECT A.SPK_ID, dbo.FORMAT_NOMOR('SPK', A.SPK_ID) AS UR_SPK, CONVERT(VARCHAR(10), A.TANGGAL, 103) AS TGL_SPK, dbo.FORMAT_NOMOR('SPL', B.KODE_SAMPEL) AS UR_KODE_SAMPEL, B.NAMA_SAMPEL, B.NOMOR_REGISTRASI, B.NO_BETS, B.BENTUK_SEDIAAN, B.KEMASAN, B.KOMPOSISI, dbo.KATEGORI(B.KOMODITI, B.PRIORITAS) AS KOMODITI, B.KETERANGAN_ED, B.PEMERIAN,dbo.FORMAT_NOMOR('SPP', C.SPP_ID) AS UR_SPP, D.NAMA_USER AS PENYELIA FROM T_SPK A LEFT JOIN T_M_SAMPEL B ON A.KODE_SAMPEL = B.KODE_SAMPEL LEFT JOIN T_SPP C ON A.SPK_ID = C.SPK_ID LEFT JOIN T_USER D ON A.CREATE_BY = D.USER_ID WHERE A.SPK_ID = '".$id."'";
				$data = $sipt->main->get_result($query);
				if($data){
					foreach($query->result_array() as $row){
						$arrdata['sess'] = $row;
					}
				}
				$qparameter = "SELECT A.SPK_ID, A.UJI_ID, A.PARAMETER_UJI, A.METODE, A.PUSTAKA, A.SYARAT, A.RUANG_LINGKUP, A.HASIL, A.HASIL_KUALITATIF, CASE WHEN A.PENGUJI = '' THEN 'Belum Ditentukan Penguji' ELSE B.NAMA_USER END AS PENGUJI, A.AWAL_UJI, A.STATUS FROM T_PARAMETER_HASIL_UJI A LEFT JOIN T_USER B ON A.PENGUJI = B.USER_ID WHERE A.SPK_ID = '".$id."'";
				$dataparam = $sipt->main->get_result($qparameter);
				if($dataparam){
					foreach($qparameter->result_array() as $rparameter){
						$arrdata['sess_parameter'][] = $rparameter;
					}
				}
				return $arrdata;
			}
		}
	}
	
	function get_parameters($id){
		if((in_array('3', $this->newsession->userdata('SESS_KODE_ROLE')) && in_array('02', $this->newsession->userdata('SESS_JENIS_PELAPORAN'))) && $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model('main','main', true);
			$arrid = explode("-",$id);
			if(count($arrid) < 2){
				return false;
				exit();
			}
			$query = "SELECT A.UJI_ID, A.SPK_ID, A.PARAMETER_UJI, A.METODE, A.PUSTAKA, A.SYARAT, A.PEMERIAN, A.IDENTIFIKASI, A.JENIS_UJI, A.HASIL, A.HASIL_KUALITATIF, A.HASIL_PARAMETER, A.PENGUJI, A.LCP, dbo.FORMAT_NOMOR('SPP',B.SPP_ID) AS UR_SPP, C.NAMA_USER, A.STATUS FROM T_PARAMETER_HASIL_UJI A LEFT JOIN T_SPP B ON A.SPK_ID = B.SPK_ID LEFT JOIN T_USER C ON A.PENGUJI = C.USER_ID WHERE A.SPK_ID = '".$arrid[0]."' AND A.UJI_ID = '".$arrid[1]."'";
			$data = $sipt->main->get_result($query);
			$arrboleh = array('20201','20202');
			if($data){
				foreach($query->result_array() as $row){
					$arrdata['sess'] = $row;
				}
				
				if(in_array($row['STATUS'],$arrboleh))
					$arrdata['allowed'] = TRUE;
				else
					$arrdata['allowed'] = FALSE;
				$arrdata['act']	= site_url().'/post/ppomn/spp_act/update';
				$arrdata['arrpenguji'] = $sipt->main->combobox("SELECT USER_ID, NAMA_USER FROM T_USER WHERE USER_ID IN (SELECT USER_ID FROM T_USER_ROLE WHERE ROLE = '2' AND JENIS_PELAPORAN = '02') AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' ORDER BY 2","USER_ID","NAMA_USER",TRUE);	
				return $arrdata;
			}
		}
	}

	function get_disposp($id){
		if(in_array('7', $this->newsession->userdata('SESS_KODE_ROLE')) && $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model('main','main', true);
			$this->load->library('newtable');
			if($id=="") return redirect(base_url());
			$query = "SELECT SPU_ID, CONVERT(VARCHAR(10), TANGGAL_TERIMA_TPS, 103) AS TANGGAL_TERIMA, dbo.FORMAT_NOMOR('SPU', SPU_ID) AS SPU, SUBSTRING(SPU_ID, 13,2) AS KOMODITI FROM T_SPU WHERE SPU_ID = '".$id."'";
			$rspu = $sipt->main->get_result($query);
			if($query){
				foreach($query->result_array() as $row){
					$arrdata = array('sess' => $row);
				}
				$query = "SELECT A.PERIKSA_SAMPEL, A.KODE_SAMPEL, B.NOMOR_SURAT +'<div>Tanggal Sampling : ' + CONVERT(VARCHAR(10), A.TANGGAL_SAMPLING, 120) + '</div><div>Bulan Anggaran : '+ A.BULAN_ANGGARAN +'</div><div>Asal Sampel : '+dbo.URAIAN_M_TABEL('ASAL_SAMPLING',A.ASAL_SAMPEL)+'</div>' AS [NOMOR SURAT / PENGANTAR], A.NAMA_SAMPEL + '<div>' + dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) + '</div><div>' + A.BENTUK_SEDIAAN + '</div><div>' + A.PABRIK + '</div><div>' + A.NOMOR_REGISTRASI + ', No Batch  : ' +  A.NO_BETS + '</div><div>'+A.TEMPAT_SAMPLING+'</div>' AS [IDENTITAS SAMPEL], CAST(A.JUMLAH_SAMPEL AS VARCHAR) +'&nbsp;'+ A.SATUAN +'<div>&bull;&nbsp;Uji Kimia : '+ CAST(A.JUMLAH_KIMIA AS VARCHAR)+'</div><div>&bull;&nbsp;Uji Mikro : '+CAST(A.JUMLAH_MIKRO AS VARCHAR) +'</div><div>&bull;&nbsp;Sisa Sampel : '+CAST(A.SISA AS VARCHAR) +'</div><div>' +CASE WHEN UJI_KIMIA = '1' AND UJI_MIKRO = '1' THEN 'Uji Kimia - Mikro' WHEN UJI_KIMIA = '1' THEN 'Uji Kimia' WHEN UJI_MIKRO = '1' THEN 'Uji Mikro' END+ '</div>' AS [JUMLAH UJI], dbo.KATEGORI(A.KATEGORI, A.PRIORITAS) AS KOMODITI, dbo.URAIAN_M_TABEL('STATUS', A.STATUS_SAMPEL) AS [STATUS] FROM T_M_SAMPEL A LEFT JOIN T_PERIKSA_SAMPEL B ON A.PERIKSA_SAMPEL = B.PERIKSA_SAMPEL WHERE A.SPU_ID = '".$id."'";
				$this->newtable->hiddens(array('PERIKSA_SAMPEL','KODE_SAMPEL'));
				$this->newtable->search(array(array("B.NOMOR_SURAT", "Nomor Surat Tugas / Pengantar"),array("CONVERT(VARCHAR(10), A.TANGGAL_SAMPLING, 120)", "Tanggal Sampling"),array("A.BULAN_ANGGARAN","Bulan Anggaran"),array("dbo.URAIAN_M_TABEL('ASAL_SAMPLING', A.ASAL_SAMPEL)", "Asal Sampel"),array("A.NAMA_SAMPEL","Nama Sampel"),array("dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL)","Kode Sampel"),array("A.TEMPAT_SAMPLING","Tempat Sampling"),array("dbo.KATEGORI(A.KOMODITI, A.PRIORITAS)","Komoditi"),array("dbo.KATEGORI(A.KATEGORI, A.PRIORITAS)","Kategori"),array("dbo.URAIAN_M_TABEL('STATUS', A.STATUS_SAMPEL)","Status / Proses Sampel")));
				$this->newtable->columns(array("A.PERIKSA_SAMPEL", "A.KODE_SAMPEL", "B.NOMOR_SURAT +'<div>Tanggal Sampling : ' + CONVERT(VARCHAR(10), A.TANGGAL_SAMPLING, 120) + '</div><div>Bulan Anggaran : '+ A.BULAN_ANGGARAN +'</div><div>Asal Sampel : '+dbo.URAIAN_M_TABEL('ASAL_SAMPLING',A.ASAL_SAMPEL)+'</div>'",array("A.NAMA_SAMPEL + '<div>' + dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) + '</div><div>' + A.BENTUK_SEDIAAN + '</div><div>' + A.PABRIK + '</div><div>' + A.NOMOR_REGISTRASI + ', No Batch  : ' +  A.NO_BETS + '</div><div>'+A.TEMPAT_SAMPLING+'</div><div>'",site_url()."/home/sampel/preview/{PERIKSA_SAMPEL}.{KODE_SAMPEL}"),"CAST(A.JUMLAH_SAMPEL AS VARCHAR) +'&nbsp;'+ A.SATUAN +'<div>&bull;&nbsp;Uji Kimia : '+ CAST(A.JUMLAH_KIMIA AS VARCHAR)+'</div><div>&bull;&nbsp;Uji Mikro : '+CAST(A.JUMLAH_MIKRO AS VARCHAR) +'</div><div>&bull;&nbsp;Sisa Sampel : '+CAST(A.SISA AS VARCHAR) +'</div><div>' +CASE WHEN UJI_KIMIA = '1' AND UJI_MIKRO = '1' THEN 'Uji Kimia - Mikro' WHEN UJI_KIMIA = '1' THEN 'Uji Kimia' WHEN UJI_MIKRO = '1' THEN 'Uji Mikro' END+ '</div>'","dbo.KATEGORI(A.KATEGORI,A.PRIORITAS)","dbo.URAIAN_M_TABEL('STATUS', A.STATUS_SAMPEL)"));
				$this->newtable->width(array('NOMOR SURAT / PENGANTAR' => 200,'IDENTITAS SAMPEL' => 225, 'JUMLAH UJI' => 85, 'KOMODITI' => 75, 'STATUS' => 105));
				$this->newtable->action(site_url()."/home/ppomn/pengujian/spu/".$id);
				$this->newtable->detail(site_url()."/get/pengujian/preview_sampel");
				$this->newtable->cidb($this->db);
				$this->newtable->ciuri($this->uri->segment_array());
				$this->newtable->orderby(1);
				$this->newtable->sortby("ASC");
				$this->newtable->keys(array('PERIKSA_SAMPEL','KODE_SAMPEL'));
				if(in_array('3', $this->newsession->userdata('SESS_KODE_ROLE')) && $row['STATUS'] == "30106"){
					$proses['Perbaiki Data Sampel'] = array('POST', site_url().'/post/sampel/sampel_act/reject/ajax', 'N');
					$this->newtable->menu($proses);
				}else if(in_array('4', $this->newsession->userdata('SESS_KODE_ROLE')) && $row['STATUS'] == "40106"){
					$proses['Perbaiki Data Sampel'] = array('POST', site_url().'/post/sampel/sampel_act/reject/ajax', 'N');
					$this->newtable->menu($proses);
				}
				$chkjml = $this->db->query("SELECT SUM(CASE WHEN UJI_MIKRO = '1' THEN 1 ELSE 0 END) AS JML_MIKRO,SUM(CASE WHEN UJI_KIMIA = '1' THEN 1 ELSE 0 END) AS JML_KIMIA FROM T_M_SAMPEL WHERE SPU_ID = '".$id."'")->result_array();
				if($chkjml[0]['JML_MIKRO'] > 0 && $chkjml[0]['JML_KIMIA'] > 0){
					$arrdata['jmlinput'] = 2;
					$arrdata['tipeuji'] = 'Kimia - Mikrobiologi';
				}else if($chkjml[0]['JML_MIKRO'] > 0 && $chkjml[0]['JML_KIMIA'] == 0){
					$arrdata['jmlinput'] = 1;
					$arrdata['tipeuji'] = 'Mikrobiologi';
				}else if($chkjml[0]['JML_MIKRO'] == 0 && $chkjml[0]['JML_KIMIA'] > 0){
					$arrdata['jmlinput'] = 1;
					$arrdata['tipeuji'] = 'Kimia';
				}
				$arrdata['komoditinya'] = $sipt->main->get_uraian("SELECT DISTINCT(dbo.KATEGORI(KOMODITI,'0')) AS KK FROM T_M_SAMPEL WHERE SPU_ID = '".$id."'","KK");
				$arrdata['tabel'] = $this->newtable->generate($query);
				$arrdata['act'] = site_url().'/post/ppomn/dispo_act/save';
				$arrdata['back'] = site_url().'/home/ppomn/spsx/list/sp';
			}
			$arrdata['arrmt'] = $sipt->main->combobox("SELECT A.USER_ID, A.NAMA_USER +' - '+ A.JABATAN AS NAMA_USER FROM T_USER A LEFT JOIN T_USER_ROLE B ON A.USER_ID = B.USER_ID WHERE B.ROLE = '4' AND B.JENIS_PELAPORAN = '02' AND A.BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' GROUP BY A.USER_ID, A.NAMA_USER, A.JABATAN ORDER BY 2 ASC", "USER_ID", "NAMA_USER", TRUE);
			return $arrdata;			
		}
	}

	function get_sp($id){
		if(in_array('7', $this->newsession->userdata('SESS_KODE_ROLE')) && $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$query = "SELECT A.SPU_ID, dbo.FORMAT_NOMOR('SPU',A.SPU_ID) AS UR_SPU, dbo.FORMAT_NOMOR('SPS',A.NOMOR_SPS) AS NOMOR_SPS, dbo.FORMAT_NOMOR('SP',A.NOMOR_SP) AS NOMOR_SP, CONVERT(VARCHAR(10), A.TANGGAL, 103) AS TANGGAL_SPU, CONVERT(VARCHAR(10), A.TANGGAL_PERINTAH,103) AS TANGGAL_PERINTAH, B.NAMA_BBPOM, C.NAMA_USER FROM T_SPU A LEFT JOIN M_BBPOM B ON A.BBPOM_ID = B.BBPOM_ID LEFT JOIN T_USER C ON A.TTD_MP = C.USER_ID WHERE A.SPU_ID = '".$id."'";
			$data = $sipt->main->get_result($query);
			if($data){
				foreach($query->result_array() as $row){
					$arrdata['sess'] = $row;
				}
				$arrdata['kabid'] = $this->db->query("SELECT DISTINCT A.USER_ID, B.NAMA_USER, B.JABATAN FROM T_SAMPEL_MT A LEFT JOIN T_USER B ON A.USER_ID = B.USER_ID WHERE A.SPU_ID = '".$id."'")->result_array();
				
				$arrdata['chk_uji'] = $this->db->query("SELECT SUM(CASE WHEN UJI_KIMIA = '1' THEN 1 ELSE 0 END) AS KIMIA, SUM(CASE WHEN UJI_MIKRO = '1' THEN 1 ELSE 0 END) AS MIKRO FROM T_M_SAMPEL WHERE SPU_ID = '".$id."'")->result_array();
				if($arrdata['chk_uji'][0]['KIMIA'] > 0){
					$arrdata['sampelk'] = $this->db->query("SELECT dbo.FORMAT_NOMOR('SPL', KODE_SAMPEL) AS UR_KODE, dbo.FIRST_CAPITAL(NAMA_SAMPEL) AS NAMA_SAMPEL, NOMOR_REGISTRASI, NO_BETS, dbo.KATEGORI(KATEGORI,'0') AS KATEGORI FROM T_M_SAMPEL WHERE SPU_ID = '".$id."' AND UJI_KIMIA = '1' ORDER BY KODE_SAMPEL ASC")->result_array();
				}else{
					$arrdata['sampelk'] = array();
				}
				
				if($arrdata['chk_uji'][0]['MIKRO'] > 0){
					$arrdata['sampelm'] = $this->db->query("SELECT dbo.FORMAT_NOMOR('SPL', KODE_SAMPEL) AS UR_KODE, dbo.FIRST_CAPITAL(NAMA_SAMPEL) AS NAMA_SAMPEL, NOMOR_REGISTRASI, NO_BETS, dbo.KATEGORI(KATEGORI,'0') AS KATEGORI FROM T_M_SAMPEL WHERE SPU_ID = '".$id."' AND UJI_MIKRO = '1' ORDER BY KODE_SAMPEL ASC")->result_array();
				}else{
					$arrdata['sampelm'] = array();
				}
				
			}
			return $arrdata;
		}
	}

	function get_mt($spuid,$userid){
		if($this->newsession->userdata('LOGGED_IN')){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$query = "SELECT DISTINCT A.SPU_ID, dbo.FORMAT_NOMOR('SPU',A.SPU_ID) AS UR_SPU, A.USER_ID, B.NAMA_USER
FROM T_SAMPEL_MT A LEFT JOIN T_USER B ON A.USER_ID = B.USER_ID 
WHERE A.SPU_ID = '".$spuid."' AND A.USER_ID = '".$userid."'";
			$data = $sipt->main->get_result($query);
			if($data){
				foreach($query->result_array() as $row){
					$arrdata['sess'] = $row;
				}
				$arrdata['arrmt'] = $sipt->main->combobox("SELECT A.USER_ID, A.NAMA_USER +' - '+ A.JABATAN AS NAMA_USER FROM T_USER A LEFT JOIN T_USER_ROLE B ON A.USER_ID = B.USER_ID WHERE B.ROLE = '4' AND B.JENIS_PELAPORAN = '02' AND A.BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' GROUP BY A.USER_ID, A.NAMA_USER, A.JABATAN ORDER BY 2 ASC", "USER_ID", "NAMA_USER", TRUE);
				$arrdata['act'] = site_url().'/post/ppomn/dispo_act/replace-dispo';
				return $arrdata;
			}
		}
	}

	function get_add($spuid){
		if($this->newsession->userdata('LOGGED_IN')){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$query = "SELECT DISTINCT A.SPU_ID, dbo.FORMAT_NOMOR('SPU',A.SPU_ID) AS UR_SPU, A.USER_ID, B.NAMA_USER
FROM T_SAMPEL_MT A LEFT JOIN T_USER B ON A.USER_ID = B.USER_ID 
WHERE A.SPU_ID = '".$spuid."'";
			$data = $sipt->main->get_result($query);
			if($data){
				foreach($query->result_array() as $row){
					$arrdata['sess'] = $row;
				}
				$arrdata['arrmt'] = $sipt->main->combobox("SELECT A.USER_ID, A.NAMA_USER +' - '+ A.JABATAN AS NAMA_USER FROM T_USER A LEFT JOIN T_USER_ROLE B ON A.USER_ID = B.USER_ID WHERE B.ROLE = '4' AND B.JENIS_PELAPORAN = '02' AND A.BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' GROUP BY A.USER_ID, A.NAMA_USER, A.JABATAN ORDER BY 2 ASC", "USER_ID", "NAMA_USER", TRUE);
				$arrdata['act'] = site_url().'/post/ppomn/dispo_act/add-mt';
				return $arrdata;
			}
		}
	}

	function set_disposp($action, $isajax){
		if(in_array('7', $this->newsession->userdata('SESS_KODE_ROLE')) && $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			if($action == "save"){
				$hasil = FALSE;
				$msgok = "Tambah data surat perintah uji baru berhasil";
				$msgerr = "Tambah data surat perintah uji baru berhasil, Silahkan coba lagi";
				$arr_petugas = $this->input->post('USER_ID');
				if(!$arr_petugas){
					return "MSG#NO#MT Pengujian belum ditunjuk."; die();
				}
				$jml = count($arr_petugas);
				$chk = $this->input->post('chkjml');
				
				$user = "'".join("','", $this->input->post('USER_ID'))."'";
				$jmljabatan = (int)$this->db->query("SELECT DISTINCT(USER_ID), LEFT(SARANA_MEDIA_ID, 2) AS BID FROM T_USER_ROLE WHERE USER_ID IN (".$user.") GROUP BY USER_ID, SARANA_MEDIA_ID")->num_rows();
				$chkuji = FALSE;
				if($jml < $chk){
					if($jmljabatan == $chk)
					$chkuji = TRUE;
					else
					$chkuji = FALSE;
				}else if($jml > $chk){
					$chkuji = FALSE;
				}else if($chk <= $jmljabatan){
					$chkuji = TRUE;
				}
				if($chkuji){
					$asal = $sipt->main->get_uraian("SELECT ASAL_SAMPEL FROM T_SPU WHERE SPU_ID = '".$this->input->post('SPU_ID')."'","ASAL_SAMPEL");
					$dtsp = $sipt->main->post_to_query($this->input->post('PERINTAH_UJI'));
					$dtsp['UPDATE_BY'] = $this->newsession->userdata('SESS_USER_ID');
					$dtsp['LAST_UPDATE'] = 'GETDATE()';
					$dtsp['STATUS'] = '40201';
					$dtsp['JML_SPU'] = $jml;
					$this->db->where('SPU_ID',$this->input->post('SPU_ID'));
					if($this->db->update('T_SPU',$dtsp)){
						$hasil = TRUE;
						if(count($arr_petugas)>0){
							$qmt = "SELECT DISTINCT(USER_ID), LEFT(SARANA_MEDIA_ID, 2) AS BID FROM T_USER_ROLE WHERE USER_ID IN (".$user.") GROUP BY USER_ID, SARANA_MEDIA_ID";
							$dmt = $sipt->main->get_result($qmt);
							if($dmt){
								$arrtmpmt = array();
								$arrbid = array();
								$arrkimia = array();
								$arrmikro = array();
								$jmlkmia = 0;
								$jmlmikro = 0;
								foreach($qmt->result_array() as $rmt){
									if(!array_key_exists($rmt['BID'], $arrbid)) $arrbid[$rmt['BID']] = $rmt['BID'];
									if(!array_key_exists($rmt['BID'], $arrtmpmt)) $arrtmpmt[$rmt['USER_ID']] = $rmt['BID'];
								}
								foreach($arrtmpmt as $x => $y){
									if($y == "B1" || $y == "B2" || $y == "B3" || $y == "B4"){
										$qkimia = "SELECT KODE_SAMPEL, STATUS_SAMPEL FROM T_M_SAMPEL WHERE SPU_ID = '".$this->input->post('SPU_ID')."' AND UJI_KIMIA = '1'";
										$dtkimia = $sipt->main->get_result($qkimia);
										if($dtkimia){
											foreach($qkimia->result_array() as $rowkimia){
												$arrkimia['SPU_ID'] = $this->input->post('SPU_ID');
												$arrkimia['KODE_SAMPEL'] = $rowkimia['KODE_SAMPEL'];
												$arrkimia['USER_ID'] = $x;
												$arrkimia['STATUS'] = '40201';
												$this->db->insert('T_SAMPEL_MT', $arrkimia);
												$jmlkmia++;
											}
										}
									}
									if($y == "B5"){
										$qmikro = "SELECT KODE_SAMPEL, STATUS_SAMPEL FROM T_M_SAMPEL WHERE SPU_ID = '".$this->input->post('SPU_ID')."' AND UJI_MIKRO = '1'";
										$dtmikro = $sipt->main->get_result($qmikro);
										if($dtmikro){
											foreach($qmikro->result_array() as $rowmikro){
												$arrmikro['SPU_ID'] = $this->input->post('SPU_ID');
												$arrmikro['KODE_SAMPEL'] = $rowmikro['KODE_SAMPEL'];
												$arrmikro['USER_ID'] = $x;
												$arrmikro['STATUS'] = '40201';
												$this->db->insert('T_SAMPEL_MT', $arrmikro);
												$jmlmikro++;
											}
										}
									}
								}							
								$logspu = array('SPU_ID' => $this->input->post('SPU_ID'),
												'WAKTU' => 'GETDATE()',
												'USER_ID' => $this->newsession->userdata('SESS_USER_ID'),
												'KEGIATAN' => 'Simpan Surat Perintah Uji, Disposisi ke Bidang Pengujian',
												'CATATAN' => 'Nomor Surat Surat Permintaan Uji : '.$this->input->post('SPU_ID'));
								$this->db->insert('T_SPU_LOG', $logspu);
							}
						}
					}
					
					if($hasil){
						$this->db->simple_query("UPDATE T_M_SAMPEL SET STATUS_SAMPEL = '40201' WHERE SPU_ID = '".$this->input->post('SPU_ID')."'");
						$arrext = array('10','11','12');
						if(in_array($asal, $arrext))
							return "MSG#YES#$msgok.\n Jumlah Sampel dikirim ke Kimia : ".$jmlkmia."\n Jumlah Sampel dikirim ke Mikro :".$jmlmikro." #".site_url().'/home/ppomn/spsx/list/all';
						else
							return "MSG#YES#$msgok.\n Jumlah Sampel dikirim ke Kimia : ".$jmlkmia."\n Jumlah Sampel dikirim ke Mikro :".$jmlmikro." #".site_url().'/home/ppomn/sps/list/all';
					}else{
						$this->db->where('SPU_ID', $this->input->post('SPU_ID'));
						$this->db->delete('T_SAMPEL_MT');
						$sql = "UPDATE T_SPU SET STATUS = '50201' WHERE SPU_ID = '".$this->input->post('SPU_ID')."'";
						$this->db->simple_query($sql);
						return "MSG#NO#$msgerror";
					}
					
					if($isajax!="ajax"){
						redirect(base_url());
						exit();
					}
				}else{
					return "MSG#NO#Harap cek kembali jenis pengujian dan manajer teknis yang dituju"; die();
				}
			}else if($action == "replace-dispo"){
				$hasil = FALSE;
				$msgok = "Edit data manajer teknis berhasil";
				$msgerr = "Edit data manajer teknis gagal";
				$resampel = $this->db->simple_query("UPDATE T_SAMPEL_MT SET USER_ID = '".$this->input->post('USER_ID')."' WHERE SPU_ID = '".$this->input->post('SPU_ID')."' AND USER_ID = '".$this->input->post('USER_ID_OLD')."'");
				if($resampel){
					return "MSG#YES#$msgok#SUKSES";
				}else{
					return "MSG#NO#$msgerr";
				}
			}else if($action == "add-mt"){
				$hasil = FALSE;
				$msgok = "Penambahan Data Kepala Bidang Berhasil";
				$msgerr = "Penambahan Data Kepala Bidang Gagal";
				$qmt = "SELECT DISTINCT(USER_ID), LEFT(SARANA_MEDIA_ID, 2) AS BID FROM T_USER_ROLE WHERE USER_ID = '".$this->input->post('USER_ID')."' GROUP BY USER_ID, SARANA_MEDIA_ID";
				$dmt = $sipt->main->get_result($qmt);
				if($dmt){
					$arrtmpmt = array();
					$arrbid = array();
					$arrkimia = array();
					$arrmikro = array();
					$jmlkmia = 0;
					$jmlmikro = 0;
					foreach($qmt->result_array() as $rmt){
						if(!array_key_exists($rmt['BID'], $arrbid)) $arrbid[$rmt['BID']] = $rmt['BID'];
						if(!array_key_exists($rmt['USER_ID'], $arrtmpmt)) $arrtmpmt[$rmt['USER_ID']] = $rmt['BID'];
					}
					foreach($arrtmpmt as $x => $y){
						if($y == "B1" || $y == "B2"){
							$qkimia = "SELECT KODE_SAMPEL, STATUS_SAMPEL FROM T_M_SAMPEL WHERE SPU_ID = '".$this->input->post('SPU_ID')."' AND UJI_KIMIA = '1'";
							$dtkimia = $sipt->main->get_result($qkimia);
							if($dtkimia){
								foreach($qkimia->result_array() as $rowkimia){
									$chkspkimia = $sipt->main->get_uraian("SELECT COUNT(KODE_SAMPEL) AS JML FROM T_SPK WHERE SPU_ID = '".$this->input->post('SPU_ID')."' AND KODE_SAMPEL = '".$rowkimia['KODE_SAMPEL']."' AND CREATE_BY = '".$x."'","JML");
									$arrkimia['SPU_ID'] = $this->input->post('SPU_ID');
									$arrkimia['KODE_SAMPEL'] = $rowkimia['KODE_SAMPEL'];
									$arrkimia['USER_ID'] = $x;
									$arrkimia['STATUS'] = '40201';
									if($this->db->insert('T_SAMPEL_MT', $arrkimia)){
										$hasil = TRUE;
									}
									$jmlkmia++;
								}
							}
						}else if($y == "B3"){
							$qmikro = "SELECT KODE_SAMPEL, STATUS_SAMPEL FROM T_M_SAMPEL WHERE SPU_ID = '".$this->input->post('SPU_ID')."' AND UJI_MIKRO = '1'";
							$dtmikro = $sipt->main->get_result($qmikro);
							if($dtmikro){
								foreach($qmikro->result_array() as $rowmikro){
									$chkspkmikro = $sipt->main->get_uraian("SELECT COUNT(KODE_SAMPEL) AS JML FROM T_SPK WHERE SPU_ID = '".$this->input->post('SPU_ID')."' AND KODE_SAMPEL = '".$rowmikro['KODE_SAMPEL']."' AND CREATE_BY = '".$x."'","JML");
									$arrmikro['SPU_ID'] = $this->input->post('SPU_ID');
									$arrmikro['KODE_SAMPEL'] = $rowmikro['KODE_SAMPEL'];
									$arrmikro['USER_ID'] = $x;
									$arrmikro['STATUS'] = '40201';
									if($this->db->insert('T_SAMPEL_MT', $arrmikro)){
										$hasil = TRUE;
									}
									$jmlmikro++;
								}
							}
						}
					}
					if($hasil){
						return "MSG#YES#$msgok.\n Jumlah Sampel dikirim ke Kimia : ".$jmlkmia."\n Jumlah Sampel dikirim ke Mikro :".$jmlmikro."#SUKSES";
					}
				}
				
				if($isajax!="ajax"){
					redirect(base_url());
					exit();
				}
			}
		}
	}
	
	function del_spu_mt($spu_id, $user_id, $isajax){
		if((in_array('07',$this->newsession->userdata('SESS_KODE_ROLE')) && in_array('02', $this->newsession->userdata('SESS_JENIS_PELAPORAN'))) && $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$hasil = FALSE;
			if($spu_id!="" && $user_id !=""){
				$ret = $this->db->simple_query("DELETE FROM T_SAMPEL_MT WHERE USER_ID = '".$user_id."' AND SPU_ID = '".$spu_id."'");
				if($ret){
					$hasil = TRUE;
				}
			}
			if($hasil){
				return "MSG#YES";
			}else{
				return "MSG#NO";
			}
			if($isajax!="ajax"){
				redirect(base_url());
				exit();
			}
		}
	}

	
}	
?>