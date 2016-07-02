<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);
class Pemeriksaan_act extends Model{
	function list_pemeriksaan($doc, $kk){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			if($kk=="") redirect(base_url());
			if($doc=="all") $doc = "0_";
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$sarana = "'".join("','", $this->newsession->userdata('SESS_SARANA'))."'";
			$arrsts = array('20101','30101','40101','20111','20115','30111','40111');
			$this->load->library('newtable');
			$this->newtable->hiddens(array('IDPERIKSA','PERIKSA_ID','SARANA_ID','JENIS_SARANA_ID','CREATE_DATE','LAST_UPDATE'));
			if(in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')))
				$this->newtable->search(array(array('B.NAMA_SARANA', 'Nama Sarana'),array('{IN}A.PERIKSA_ID IN (SELECT K.PERIKSA_ID FROM T_PEMERIKSAAN_KLASIFIKASI K WHERE K.KK_ID IN(SELECT KK_ID FROM M_KLASIFIKASI_KATEGORI WHERE KK_ID = K.KK_ID AND NAMA_KK {LIKE}))', 'Komoditi'),array('H.NAMA_JENIS_SARANA', 'Jenis Sarana'),array('B.ALAMAT_1', 'Alamat Sarana'),array('CONVERT(VARCHAR(10), A.AWAL_PERIKSA, 120)', 'Tanggal Awal Periksa'),array('CONVERT(VARCHAR(10), A.AKHIR_PERIKSA, 120)', 'Tanggal Akhir Periksa'),array('D.NAMA_BBPOM', 'Balai Pemeriksa'), array('A.HASIL', 'Hasil Pemeriksaan'), array('Z.URAIAN', 'Status Pemeriksaan'),array('{IN}A.PERIKSA_ID IN (SELECT Y.LAPOR_ID FROM T_SURAT_TUGAS_PELAPORAN Y WHERE Y.SURAT_ID IN(SELECT SURAT_ID FROM T_SURAT_TUGAS WHERE SURAT_ID = Y.SURAT_ID AND NOMOR {LIKE}))', 'Nomor Surat Tugas'), array('{IN}A.PERIKSA_ID IN (SELECT PERIKSA_ID FROM T_PEMERIKSAAN_TEMUAN_PRODUK WHERE PERIKSA_ID = A.PERIKSA_ID AND NOMOR_REGISTRASI {LIKE} OR NAMA_PRODUK {LIKE} OR PRODUSEN {LIKE} OR NAMA_PERUSAHAAN {LIKE})', 'Identitas Produk Ditemukan'), array('C.NAMA_USER', 'Nama Petugas Entri')));
			else
				$this->newtable->search(array(array('B.NAMA_SARANA', 'Nama Sarana'),array('{IN}A.PERIKSA_ID IN (SELECT K.PERIKSA_ID FROM T_PEMERIKSAAN_KLASIFIKASI K WHERE K.KK_ID IN(SELECT KK_ID FROM M_KLASIFIKASI_KATEGORI WHERE KK_ID = K.KK_ID AND NAMA_KK {LIKE}))', 'Komoditi'),array('H.NAMA_JENIS_SARANA', 'Jenis Sarana'),array('B.ALAMAT_1', 'Alamat Sarana'),array('CONVERT(VARCHAR(10), A.AWAL_PERIKSA, 120)', 'Tanggal Awal Periksa'),array('CONVERT(VARCHAR(10), A.AKHIR_PERIKSA, 120)', 'Tanggal Akhir Periksa'),array('Z.URAIAN', 'Status Pemeriksaan'),array('A.HASIL', 'Hasil Pemeriksaan'),array('{IN}A.PERIKSA_ID IN (SELECT Y.LAPOR_ID FROM T_SURAT_TUGAS_PELAPORAN Y WHERE Y.SURAT_ID 
IN(SELECT SURAT_ID FROM T_SURAT_TUGAS WHERE SURAT_ID = Y.SURAT_ID AND NOMOR {LIKE}))', 'Nomor Surat Tugas'),  array('{IN}A.PERIKSA_ID IN (SELECT PERIKSA_ID FROM T_PEMERIKSAAN_TEMUAN_PRODUK WHERE PERIKSA_ID = A.PERIKSA_ID AND NOMOR_REGISTRASI {LIKE} OR NAMA_PRODUK {LIKE} OR PRODUSEN {LIKE} OR NAMA_PERUSAHAAN {LIKE})', 'Identitas Produk Ditemukan'), array('C.NAMA_USER', 'Nama Petugas Entri')));
			
			$this->newtable->action(site_url()."/home/pelaporan/pemeriksaan/view/$doc/$kk");
			$this->newtable->detail(site_url()."/get/pemeriksaan/set_preview");
			$this->newtable->cidb($this->db);
			$this->newtable->ciuri($this->uri->segment_array());
			$this->newtable->keys(array('IDPERIKSA'));
			
			if(in_array(in_array('2', $this->newsession->userdata('SESS_KODE_ROLE'))) || $kk == "20101" || $kk == "20111"){#Operator
				$proses['Edit Data Pemeriksaan'] = array('GET', site_url()."/home/pemeriksaan", '1');
				$proses['Edit Data Surat'] = array('GET', site_url()."/home/surat/data", '1');
				$proses['Detil Data Surat'] = array('GET', site_url()."/home/surat/list", '1');
				$proses['Data Petugas Pemeriksa'] = array('GET', site_url()."/home/pelaporan/petugas", '1');
				$proses['Hapus Data Pemeriksaan'] = array('POST', site_url()."/post/pemeriksaan/hapus_act/delete/ajax", 'N');
			}
			if($kk == "send"){#Tekirim
				$stat = $sipt->main->status_send();
				$judul = "Data Pemeriksaan Terkirim";
				$proses['Data Temuan Produk'] = array('GET', site_url()."/home/produk/view", '1');
			}else if($kk == "balai"){#Direktur Unit Asal dari balai
				$stat = '60111';
				$judul = "Data Pemeriksaan Asal Balai";
				$proses['Proses Data Pemeriksaan'] = array('GET', site_url()."/home/proses", '1');
				#$proses['Kirim Ke Balai'] = array('POST', site_url()."/post/pemeriksaan/set_kirim/balai/ajax", 'N');
				$proses['Kirim Ke Balai'] = array('MPOST', site_url()."/post/pemeriksaan/set_all/ajax", 'N');
				$proses['Tutup Kasus'] = array('POST', site_url()."/post/pemeriksaan/set_kirim/closed/ajax", 'N');
			}else if($kk == "pusat"){#Direktur Unit Asal dari pusat
				$judul = $sipt->main->get_uraian("SELECT URAIAN FROM M_TABEL WHERE JENIS = 'STATUS' AND KODE = '60111'","URAIAN");
				$stat = '60111';
				$proses['Proses Data Pemeriksaan'] = array('GET', site_url()."/home/proses", '1');
				$proses['Tutup Kasus'] = array('POST', site_url()."/post/pemeriksaan/set_kirim/closed/ajax", 'N');
			}else if($kk == "60010"){
				$judul = $sipt->main->get_uraian("SELECT URAIAN FROM M_TABEL WHERE JENIS = 'STATUS' AND KODE = '60010'","URAIAN");
				$stat = $kk;
				$proses['Data Temuan Produk'] = array('GET', site_url()."/home/produk/view", '1');
			}else{#Selain Diatas
				$stat = $kk;
				$judul = $sipt->main->get_uraian("SELECT URAIAN FROM M_TABEL WHERE JENIS = 'STATUS' AND KODE = '$kk'","URAIAN");
				$proses['Proses Data Pemeriksaan'] = array('GET', site_url()."/home/proses", '1');
				
				if(in_array($kk, $arrsts)){
					$proses['Kirim Semua Data'] = array('MPOST', site_url()."/post/pemeriksaan/set_all/ajax", 'N');
				}
				if(in_array('5', $this->newsession->userdata('SESS_KODE_ROLE'))){
					$proses['Kirim Ke Pusat'] = array('MPOST', site_url()."/post/pemeriksaan/set_all/ajax", 'N');
				}			
			}
			if($kk == "20101" || $kk == "20111"){
				$proses['Data Temuan Produk'] = array('GET', site_url()."/home/produk/add", '1');
			}else if($kk == "20102" || $kk == "20112"){
				$proses['Edit Data Temuan Produk'] = array('GET', site_url()."/home/produk/add", '1');
				$proses['Edit Data Surat'] = array('GET', site_url()."/home/surat/data", '1');
				$proses['Detil Data Surat'] = array('GET', site_url()."/home/surat/list", '1');
			}else{
				$proses['Data Temuan Produk'] = array('GET', site_url()."/home/produk/view", '1');
			}
			if($kk == "20102" || $kk == "20112" || $kk == "60020"){
				$proses['Perbaiki Data Pemeriksaan'] = array('GET', site_url()."/home/pemeriksaan", '1');
				$proses['Data Petugas Pemeriksa'] = array('GET', site_url()."/home/pelaporan/petugas", '1');
				$proses['Edit Data Surat'] = array('GET', site_url()."/home/surat/data", '1');
				$proses['Detil Data Surat'] = array('GET', site_url()."/home/surat/list", '1');
			}
			$proses['Cetak Form Pemeriksaan'] = array('GETNEW', site_url()."/home/bap", '1');
			if(in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))){#Pusat
				$query = "SELECT (CAST(A.SARANA_ID AS VARCHAR) + '/' + A.JENIS_SARANA_ID + '/' + STUFF(dbo.GROUP_KLASIFIKASI(A.PERIKSA_ID),1,1,'') + '/' + CAST(A.PERIKSA_ID AS VARCHAR) + '.' + A.STATUS) AS IDPERIKSA, A.PERIKSA_ID, A.SARANA_ID, A.JENIS_SARANA_ID, '<a href=\"#\" class=\"row_preview\">'+ LTRIM(RTRIM(REPLACE(UPPER(B.NAMA_SARANA),'-',''))) + '</a><div>'+ REPLACE(B.ALAMAT_1,'\n',' ') +' - '+G.NAMA_PROPINSI+'</div><div><a href=\"#\" class=\"row_riwayat\" record=\"'+CAST(A.PERIKSA_ID AS VARCHAR)+'\">Riwayat Pemeriksaan</a></div>' AS [NAMA SARANA], STUFF(dbo.GROUP_KK(A.PERIKSA_ID),1,1,'') +'<div>'+ dbo.NAMA_JENIS_SARANA(A.JENIS_SARANA_ID) +'</div>' AS KOMODITI, CONVERT(VARCHAR(10), A.AWAL_PERIKSA, 120) + '<div> Sampai Dengan </div>' + CONVERT(VARCHAR(10), A.AKHIR_PERIKSA, 120) AS [TANGGAL PERIKSA], REPLACE(REPLACE(D.NAMA_BBPOM,'BALAI BESAR POM DI', ''),'BALAI POM DI','') AS [BB/BPOM], A.HASIL +'<div>Temuan Produk ('+ (SELECT CAST(COUNT(PERIKSA_ID) AS VARCHAR) FROM T_PEMERIKSAAN_TEMUAN_PRODUK WHERE PERIKSA_ID = A.PERIKSA_ID) +')</div>' AS HASIL, REPLACE(Z.URAIAN,' - ', '<div>') AS [STATUS], A.CREATE_DATE, dbo.GET_HISTORY('PERIKSA',A.PERIKSA_ID)+'<div>'+dbo.GET_HISTORY('CATATAN',A.PERIKSA_ID)+'</div>' AS [UPDATE TERAKHIR], A.LAST_UPDATE FROM T_PEMERIKSAAN A LEFT JOIN M_SARANA B ON A.SARANA_ID = B.SARANA_ID LEFT JOIN T_USER C ON A.CREATE_BY = C.USER_ID LEFT JOIN M_TABEL Z ON A.STATUS = Z.KODE LEFT JOIN M_BBPOM D ON A.BBPOM_ID = D.BBPOM_ID LEFT JOIN M_PROPINSI G ON B.PROPINSI = G.PROPINSI_ID LEFT JOIN M_JENIS_SARANA H ON A.JENIS_SARANA_ID = H.JENIS_SARANA_ID WHERE A.JENIS_SARANA_ID LIKE '%".$doc."__' AND Z.JENIS = 'STATUS' AND A.STATUS IN (".$stat.") AND A.JENIS_SARANA_ID IN (".$sarana.")";
				if($kk == "20115" || $kk == "balai"){
					$query .= " AND A.BBPOM_ID <> '".$this->newsession->userdata('SESS_BBPOM_ID')."'";
				}else if($kk == "pusat"){
					$query .= " AND A.BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'";
				}
				$this->newtable->width(array('NAMA SARANA' => 250,'KOMODITI' => 150, 'TANGGAL PERIKSA' => 110, 'BB/BPOM' => 110, 'HASIL' => 50, 'STATUS' => 125,'UPDATE TERAKHIR' => 125));
				$this->newtable->columns(array("CAST(A.SARANA_ID AS VARCHAR) + '/' + A.JENIS_SARANA_ID + '/' + STUFF(dbo.GROUP_KLASIFIKASI(A.PERIKSA_ID),1,1,'') + '/' + CAST(A.PERIKSA_ID AS VARCHAR) + '.' + A.STATUS)", "A.PERIKSA_ID", "A.SARANA_ID", "A.JENIS_SARANA_ID", "'<a href=\"#\" class=\"row_preview\">'+ LTRIM(RTRIM(REPLACE(UPPER(B.NAMA_SARANA),'-',''))) + '</a><div>'+ REPLACE(B.ALAMAT_1,'\n',' ') +' - '+G.NAMA_PROPINSI+'</div><div><a href=\"#\" class=\"row_riwayat\" record=\"'+CAST(A.PERIKSA_ID AS VARCHAR)+'\">Riwayat Pemeriksaan</a></div>' ", "STUFF(dbo.GROUP_KK(A.PERIKSA_ID),1,1,'') +'<div>'+ dbo.NAMA_JENIS_SARANA(A.JENIS_SARANA_ID) +'</div>'", "CONVERT(VARCHAR(10), A.AWAL_PERIKSA, 120) + '<div> Sampai Dengan </div>' + CONVERT(VARCHAR(10), A.AKHIR_PERIKSA, 120)", "REPLACE(REPLACE(D.NAMA_BBPOM,'BALAI BESAR POM DI', ''),'BALAI POM DI','')", array("A.HASIL +'<div>Temuan Produk ('+ (SELECT CAST(COUNT(PERIKSA_ID) AS VARCHAR) FROM T_PEMERIKSAAN_TEMUAN_PRODUK WHERE PERIKSA_ID = A.PERIKSA_ID) +')</div>'",site_url().'/home/produk/view/{IDPERIKSA}'), "REPLACE(Z.URAIAN,' - ', '<div>')","A.CREATE_DATE","dbo.GET_HISTORY('PERIKSA',A.PERIKSA_ID)+'<div>'+dbo.GET_HISTORY('CATATAN',A.PERIKSA_ID)+'</div>'","A.LAST_UPDATE"));
				$this->newtable->orderby(13);
			}else{#Balai
				$query = "SELECT (CAST(A.SARANA_ID AS VARCHAR) + '/' + A.JENIS_SARANA_ID + '/' + STUFF(dbo.GROUP_KLASIFIKASI(A.PERIKSA_ID),1,1,'') + '/' + CAST(A.PERIKSA_ID AS VARCHAR) + '.' + A.STATUS) AS IDPERIKSA, A.PERIKSA_ID, A.SARANA_ID, A.JENIS_SARANA_ID, '<a href=\"#\" class=\"row_preview\">'+ LTRIM(RTRIM(REPLACE(UPPER(B.NAMA_SARANA),'-',''))) + '</a><div>'+ REPLACE(B.ALAMAT_1,'\n',' ') + ' -  '+G.NAMA_PROPINSI+'</div><div><a href=\"#\" class=\"row_riwayat\" record=\"'+CAST(A.PERIKSA_ID AS VARCHAR)+'\">Riwayat Pemeriksaan</a></div>' AS [NAMA SARANA], STUFF(dbo.GROUP_KK(A.PERIKSA_ID),1,1,'') +'<div>'+ dbo.NAMA_JENIS_SARANA(A.JENIS_SARANA_ID) +'</div>' AS KOMODITI, CONVERT(VARCHAR(10), A.AWAL_PERIKSA, 120) + '<div> Sampai Dengan </div>' + CONVERT(VARCHAR(10), A.AKHIR_PERIKSA, 120) AS [TANGGAL PERIKSA], A.HASIL +'<div>Temuan Produk ('+ (SELECT CAST(COUNT(PERIKSA_ID) AS VARCHAR) FROM T_PEMERIKSAAN_TEMUAN_PRODUK WHERE PERIKSA_ID = A.PERIKSA_ID) +')</div>' AS HASIL, REPLACE(Z.URAIAN,' - ', '<div>') AS [STATUS], A.CREATE_DATE, dbo.GET_HISTORY('PERIKSA',A.PERIKSA_ID)+'<div>'+dbo.GET_HISTORY('CATATAN',A.PERIKSA_ID)+'</div>' AS [UPDATE TERAKHIR], A.LAST_UPDATE FROM T_PEMERIKSAAN A LEFT JOIN M_SARANA B ON A.SARANA_ID = B.SARANA_ID LEFT JOIN T_USER C ON A.CREATE_BY = C.USER_ID LEFT JOIN M_TABEL Z ON A.STATUS = Z.KODE LEFT JOIN M_PROPINSI G ON B.PROPINSI = G.PROPINSI_ID LEFT JOIN M_JENIS_SARANA H ON A.JENIS_SARANA_ID = H.JENIS_SARANA_ID WHERE A.JENIS_SARANA_ID LIKE '%".$doc."__' AND Z.JENIS = 'STATUS' AND C.BBPOM_ID ='".$this->newsession->userdata('SESS_BBPOM_ID')."' AND A.STATUS IN (".$stat.")";
				$this->newtable->width(array('NAMA SARANA' => 250,'KOMODITI' => 150, 'TANGGAL PERIKSA' => 110, 'HASIL' => 50, 'STATUS' => 150, 'UPDATE TERAKHIR' => 50));
				$this->newtable->columns(array("(CAST(A.SARANA_ID AS VARCHAR) + '/' + A.JENIS_SARANA_ID + '/' + STUFF(dbo.GROUP_KLASIFIKASI(A.PERIKSA_ID),1,1,'') + '/' + CAST(A.PERIKSA_ID AS VARCHAR) + '.' + A.STATUS)", "A.PERIKSA_ID", "A.SARANA_ID", "A.JENIS_SARANA_ID", "'<a href=\"#\" class=\"row_preview\">'+ LTRIM(RTRIM(REPLACE(UPPER(B.NAMA_SARANA),'-',''))) + '</a><div>'+ REPLACE(B.ALAMAT_1,'\n',' ') + ' - '+G.NAMA_PROPINSI+'</div><div><a href=\"#\" class=\"row_riwayat\" record=\"'+CAST(A.PERIKSA_ID AS VARCHAR)+'\">Riwayat Pemeriksaan</a></div>'","STUFF(dbo.GROUP_KK(A.PERIKSA_ID),1,1,'') +'<div>'+ dbo.NAMA_JENIS_SARANA(A.JENIS_SARANA_ID) +'</div>'", "CONVERT(VARCHAR(10), A.AWAL_PERIKSA, 120) + '<div> Sampai Dengan </div>' + CONVERT(VARCHAR(10), A.AKHIR_PERIKSA, 120)", array("A.HASIL +'<div>Temuan Produk ('+ (SELECT CAST(COUNT(PERIKSA_ID) AS VARCHAR) FROM T_PEMERIKSAAN_TEMUAN_PRODUK WHERE PERIKSA_ID = A.PERIKSA_ID) +')</div>'",site_url().'/home/produk/view/{IDPERIKSA}'), "REPLACE(Z.URAIAN,' - ', '<div>')+ '<div><a href=\"#\" class=\"row_riwayat\" record=\"'+CAST(A.PERIKSA_ID AS VARCHAR)+'\">Riwayat Pemeriksaan</a></div>'","A.CREATE_DATE","dbo.GET_HISTORY('PERIKSA',A.PERIKSA_ID)+'<div>'+dbo.GET_HISTORY('CATATAN',A.PERIKSA_ID)+'</div>'","A.LAST_UPDATE"));
				$this->newtable->orderby(12);
			}
			if($kk == "20101" || $kk == "20111")
				$query .= " AND A.CREATE_BY = '".$this->newsession->userdata('SESS_USER_ID')."'";
			else
				$query .= "";	
			if($kk == "20102" || $kk == "60020"){
				if(array_key_exists('2', $this->newsession->userdata('SESS_KODE_ROLE'))){
					$query .= " AND A.CREATE_BY = '".$this->newsession->userdata('SESS_USER_ID')."'";
				}else{
					$query .= "";
				}
			}

			$this->newtable->sortby("ASC");
			$this->newtable->menu($proses);
			// echo $query;die();
			$tabel = $this->newtable->generate($query);
			$arrdata = array('table' => $tabel,
							 'idjudul' => 'judulpmnsarana',	
							 'caption_header' => $judul,
							 'batal' => '',
							 'cancel' => '');
			return $arrdata;
			
		}
		$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
	}

	function GetFormPemeriksaan(){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$sipt->load->model("main", "main", true);
			$disinput = array("JENISDIS","NAMADIS");
			$media = $sipt->main->get_jenis_sarana($this->newsession->userdata("SESS_USER_ID"), $disinput);
			$sarana = "'".join("','", $this->config->item('jenis_sarana'))."'";
			$klasifikasi = $sipt->main->combobox("SELECT * FROM M_KLASIFIKASI_KATEGORI WHERE LEN(KK_ID) = 3 AND KK_ID IN ($sarana)", "KK_ID", "NAMA_KK", TRUE);	
			$arrdata = array('act' => site_url().'/post/pemeriksaan/set_surat/pemeriksaan', 'media' => $media, 'disinput' => $disinput, 'klasifikasi' => $klasifikasi, 'selklasifikasi' => '', 'batal' => site_url().'/home/pelaporan/pemeriksaan', 'browse' => site_url().'/load/master/list_sarana');
			return $arrdata;
		}
		else{
			$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
		}
	}
	
	function set_surat($isajax){
		$ret = "MSG#NO#Data gagal disimpan#";
		$sipt =& get_instance();
		$sipt->load->model("main","main", true);
		$arr_no = $this->input->post('SURAT');
		$arr_petugas = $this->input->post('USER_ID');
		$arr_bpom = $this->input->post('BBPOM');
		$arr_tanggal = $this->input->post('TANGGAL');
		if(!$arr_petugas) return "MSG#NO#Anda Belum Memasukan Petugas Pemeriksa#";
		$SES_SURAT['SURAT'] = $arr_no;
		$SES_SURAT['BBPOM'] = $arr_bpom;
		$SES_SURAT['USER'] = $arr_petugas;
		$this->session->set_userdata($SES_SURAT);
		$klasifikasi = join('-',$this->input->post('klasifikasi'));
		$ret = "MSG#YES#Data berhasil disimpan#".site_url().'/home/pemeriksaan/'.$this->input->post('saranaidval_').'/'.$this->input->post('media_').'/'.$klasifikasi;
		if($isajax!="ajax"){
			redirect(base_url());
			exit();
		}
		return $ret;
	}
	
	function set_confirm($isajax, $id, $catatan){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$sipt->load->model("main", "main", true);
			$ret = "MSG#NO#Data Gagal Dikirim.";
			if(in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')) && in_array('2', $this->newsession->userdata('SESS_KODE_ROLE'))){
				$next_status = $sipt->main->get_uraian("SELECT SESUDAH FROM M_VERIFIKASI WHERE SEBELUM = '20111' AND PROSES = '1'","SESUDAH");
			}else{
				$next_status = $sipt->main->get_uraian("SELECT SESUDAH FROM M_VERIFIKASI WHERE SEBELUM = '20101' AND PROSES = '1'","SESUDAH");
			}
			$arr_status = array('STATUS' => $next_status, 'UPDATE_BY' => $this->newsession->userdata('SESS_USER_ID'),'LAST_UPDATE' => 'GETDATE()');
			$this->db->where('PERIKSA_ID', $id);
			if($this->db->update('T_PEMERIKSAAN', $arr_status)){ 
				$seri = (int)$sipt->main->get_uraian("SELECT MAX(SERI) AS MAXID FROM T_PEMERIKSAAN_PROSES WHERE PERIKSA_ID = '".$id."'", "MAXID") + 1;
				$arr_proses = array('PERIKSA_ID' => $id,
								  'SERI' => $seri,
								  'HASIL' => $next_status,
								  'CATATAN' => str_replace("_"," ",$catatan),
								  'CREATE_BY' => $this->newsession->userdata('SESS_USER_ID'),
								  'CREATE_DATE' => 'GETDATE()');
				$this->db->insert('T_PEMERIKSAAN_PROSES', $arr_proses);
				$kegiatan = $sipt->main->get_uraian("SELECT A.NAMA_SARANA AS NAMA_SARANA FROM M_SARANA A LEFT JOIN T_PEMERIKSAAN B ON A.SARANA_ID = B.SARANA_ID WHERE B.PERIKSA_ID ='".$id."'", "NAMA_SARANA");
				$sipt->main->get_kegiatan("Mengirim Data Pemeriksaan Sarana : ".$kegiatan);
				$ret = "MSG#YES#Data berhasil disimpan#".site_url()."/home/pelaporan/pemeriksaan/view/all/send";
			}
			if($isajax!="ajax"){
				redirect(base_url());
				exit();
			}
			return $ret;
		}
	}
	
	function set_kirim($action, $isajax){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			  $sipt =& get_instance();
			  $sipt->load->model("main", "main", true);
			  if($action=="pusat" && array_key_exists('5', $this->newsession->userdata('SESS_KODE_ROLE'))){#Dari Balai Ke Pusat
				$ret = "MSG#Data Gagal Dikirim.";
				foreach($this->input->post('tb_chk') as $a){
					$split_uri = explode("/", $a);
					$id_uri = explode(".", $split_uri[3]);
					$arr_status = array('STATUS' => '20115', 'UPDATE_BY' => $this->newsession->userdata('SESS_USER_ID'),'LAST_UPDATE' => 'GETDATE()');
					$this->db->where('PERIKSA_ID', $id_uri[0]);
					if($this->db->update('T_PEMERIKSAAN', $arr_status)){ 
						$seri = (int)$sipt->main->get_uraian("SELECT MAX(SERI) AS MAXID FROM T_PEMERIKSAAN_PROSES WHERE PERIKSA_ID = '".$id_uri[0]."'", "MAXID") + 1;
						$arr_proses = array('PERIKSA_ID' => $id_uri[0],
										  'SERI' => $seri,
										  'HASIL' => '20115',
										  'CATATAN' => 'Pemeriksaan Disetujui oleh Kepala Balai Besar / Balai Untuk Dikirim Ke Pusat',
										  'CREATE_BY' => $this->newsession->userdata('SESS_USER_ID'),
										  'CREATE_DATE' => 'GETDATE()');
						$this->db->insert('T_PEMERIKSAAN_PROSES', $arr_proses);
						$get_nama = $sipt->main->get_uraian("SELECT NAMA_SARANA FROM M_SARANA WHERE SARANA_ID='".$split_uri[0]."'", "NAMA_SARANA");
						$sipt->main->get_kegiatan("Memverifikasi Data Pemeriksaan Untuk Sarana : ".$get_nama);
					}
					$ret = "MSG#Data Berhasil Dikirim#";
				}
			    
				if($isajax!="ajax"){
					redirect(base_url());
					exit();
				}
				return $ret;
			}else if($action=="balai" || $action == "op_pusat" && array_key_exists('6', $this->newsession->userdata('SESS_KODE_ROLE'))){#Dari Pusat Ke Balai
				$ret = "MSG#Data Gagal Dikirim.";
				foreach($this->input->post('tb_chk') as $a){
					$split_uri = explode("/", $a);
					$id_uri = explode(".", $split_uri[3]);
					/*$cek_hasil = array('MK','BAIK SEKALI','BAIK','CUKUP');
					$get_hasil = $sipt->main->get_uraian("SELECT HASIL FROM T_PEMERIKSAAN WHERE PERIKSA_ID ='".$id_uri[0]."'","HASIL");
					if(in_array($get_hasil, $cek_hasil)) return $ret = "MSG#Kirim ke balai Gagal. Status Yang Bisa di kirim kembali ke balai  : \n TMK"; */
					$arr_status = array('STATUS' => '60020', 'UPDATE_BY' => $this->newsession->userdata('SESS_USER_ID'),'LAST_UPDATE' => 'GETDATE()');
					$this->db->where('PERIKSA_ID', $id_uri[0]);
					if($this->db->update('T_PEMERIKSAAN', $arr_status)){ 
						$seri = (int)$sipt->main->get_uraian("SELECT MAX(SERI) AS MAXID FROM T_PEMERIKSAAN_PROSES WHERE PERIKSA_ID = '".$id_uri[0]."'", "MAXID") + 1;
						$arr_proses = array('PERIKSA_ID' => $id_uri[0],
										  'SERI' => $seri,
										  'HASIL' => '60020',
										  'CATATAN' => 'Rekomendasi Tindak Lanjut Pusat',
										  'CREATE_BY' => $this->newsession->userdata('SESS_USER_ID'),
										  'CREATE_DATE' => 'GETDATE()');
						$this->db->insert('T_PEMERIKSAAN_PROSES', $arr_proses);
					}
					$get_nama = $sipt->main->get_uraian("SELECT NAMA_SARANA FROM M_SARANA WHERE SARANA_ID='".$split_uri[0]."'", "NAMA_SARANA");
					$sipt->main->get_kegiatan("Memverifikasi Data Pemeriksaan Untuk Sarana : ".$get_nama);
					$ret = "MSG#Data Berhasil Disimpan#";
				}
			    
				if($isajax!="ajax"){
					redirect(base_url());
					exit();
				}
				return $ret;
			}else if($action=="closed" && array_key_exists('6', $this->newsession->userdata('SESS_KODE_ROLE'))){#Tutup Pemeriksaan 
				$ret = "MSG#Data Gagal Dikirim.";
				foreach($this->input->post('tb_chk') as $a){
					$split_uri = explode("/", $a);
					$id_uri = explode(".", $split_uri[3]);
					/*$cek_hasil = array('MK','BAIK SEKALI','BAIK','CUKUP');
					$get_hasil = $sipt->main->get_uraian("SELECT HASIL FROM T_PEMERIKSAAN WHERE PERIKSA_ID ='".$id_uri[0]."'","HASIL");
					if(!in_array($get_hasil, $cek_hasil)) return $ret = "MSG#Tutup Kasus Gagal. Status Yang Bisa di Tutup : \n MK, BAIK SEKALI, BAIK, CUKUP";*/ 
					$arr_status = array('STATUS' => '60010', 'UPDATE_BY' => $this->newsession->userdata('SESS_USER_ID'),'LAST_UPDATE' => 'GETDATE()');
					$this->db->where('PERIKSA_ID', $id_uri[0]);
					if($this->db->update('T_PEMERIKSAAN', $arr_status)){ 
						$seri = (int)$sipt->main->get_uraian("SELECT MAX(SERI) AS MAXID FROM T_PEMERIKSAAN_PROSES WHERE PERIKSA_ID = '".$id_uri[0]."'", "MAXID") + 1;
						$arr_proses = array('PERIKSA_ID' => $id_uri[0],
										  'SERI' => $seri,
										  'HASIL' => '60010',
										  'CATATAN' => 'Pemeriksaan Selesai',
										  'CREATE_BY' => $this->newsession->userdata('SESS_USER_ID'),
										  'CREATE_DATE' => 'GETDATE()');
						$this->db->insert('T_PEMERIKSAAN_PROSES', $arr_proses);
					}
					$get_nama = $sipt->main->get_uraian("SELECT NAMA_SARANA FROM M_SARANA WHERE SARANA_ID='".$split_uri[0]."'", "NAMA_SARANA");
					$sipt->main->get_kegiatan("Menutup Data Pemeriksaan Untuk Sarana : ".$get_nama);
					$ret = "MSG#Data Berhasil Disimpan#"; 
				}
			    
				if($isajax!="ajax"){
					redirect(base_url());
					exit();
				}
				return $ret;
			}else if($action == "all"){
				$ret = "MSG#Data Gagal Dikirim.";
				foreach($this->input->post('PERIKSA_ID') as $a){
					$arr_status = array('STATUS' => $this->input->post('HASIL'), 'UPDATE_BY' => $this->newsession->userdata('SESS_USER_ID'),'LAST_UPDATE' => 'GETDATE()');
					$this->db->where('PERIKSA_ID', $a);
					if($this->db->update('T_PEMERIKSAAN', $arr_status)){ 
						$seri = (int)$sipt->main->get_uraian("SELECT MAX(SERI) AS MAXID FROM T_PEMERIKSAAN_PROSES WHERE PERIKSA_ID = '".$a."'", "MAXID") + 1;
						$arr_proses = array('PERIKSA_ID' => $a,
										  'SERI' => $seri,
										  'HASIL' => $this->input->post('HASIL'),
										  'CATATAN' => $this->input->post('CATATAN'),
										  'CREATE_BY' => $this->newsession->userdata('SESS_USER_ID'),
										  'CREATE_DATE' => 'GETDATE()');
						$this->db->insert('T_PEMERIKSAAN_PROSES', $arr_proses);
						$get_nama = $sipt->main->get_uraian("SELECT A.NAMA_SARANA AS NAMA_SARANA FROM M_SARANA A LEFT JOIN T_PEMERIKSAAN B ON A.SARANA_ID = B.SARANA_ID WHERE B.PERIKSA_ID ='".$a."'", "NAMA_SARANA");
						$sipt->main->get_kegiatan("Mengirim Data Pemeriksaan Sarana : ".$get_nama);
					}
					$ret = "MSG#Data Berhasil Dikirim#";
				}
			    
				if($isajax!="ajax"){
					redirect(base_url());
					exit();
				}
				return $ret;
			}
		}
	}
	
	function set_newsurat($action, $isajax){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$sipt->load->model("main", "main", true);
			if($action=="update"){#Edit Surat
				$ret = "MSG#NO#Data gagal disimpan";
				foreach($this->input->post('SURAT') as $a => $b){
					$arrsurat[$a] = $b;
				}
				$this->db->where(array("SURAT_ID" => $this->input->post("SURAT_ID")));
				if($this->db->update('T_SURAT_TUGAS', $arrsurat))$ret = "MSG#YES#Data berhasil disimpan#";
				if($isajax!="ajax"){
					redirect(base_url());
					exit();
				}
				return $ret;
  			}else if($action=="new"){
				$ret = "MSG#NO#Data gagal disimpan";
				$arr_petugas = $this->input->post('USER_ID');
				if(!$arr_petugas) return "MSG#NO#Anda Belum Memasukan Petugas Pemeriksa#";
				$surat_id = (int)$sipt->main->get_uraian("SELECT MAX(SURAT_ID) AS MAXSURAT FROM T_SURAT_TUGAS", "MAXSURAT") + 1;
				$arr_surat = array('SURAT_ID' => $surat_id,
								   'CREATE_BY' => $this->input->post('CREATE_BY'),
								   'CREATE_DATE' => $this->input->post('CREATE_DATE'));
				foreach($this->input->post('SURAT') as $a => $b){
					$arr_surat[$a] = $b;
				}
				if($this->db->insert('T_SURAT_TUGAS', $arr_surat)){
					foreach($this->input->post('USER_ID') as $a){
						$surat_petugas['SURAT_ID'] = $surat_id;
						$surat_petugas['USER_ID'] = $a;
						$this->db->insert('T_SURAT_TUGAS_PETUGAS', $surat_petugas);
					}
					$pelaporan = array('SURAT_ID' => $surat_id, 'LAPOR_ID' => $this->input->post('PERIKSA_ID'));
					$this->db->insert('T_SURAT_TUGAS_PELAPORAN', $pelaporan);
					$ret = "MSG#YES#Data berhasil disimpan#";
				}
				if($isajax!="ajax"){
					redirect(base_url());
					exit();
				}
				return $ret;
			}
		}else{
			$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
		}
	}
	
	function set_hapus($action, $isajax){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE && array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('2', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('9', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('10', $this->newsession->userdata('SESS_KODE_ROLE'))){
			$sipt =& get_instance();
			$sipt->load->model("main", "main", true);
			$ret = "MSG#Data Gagal Dihapus.";
			if($action=="delete"){
				foreach($this->input->post('tb_chk') as $a){
					$split_uri = explode("/", $a);
					$periksa_id = explode(".", $split_uri[3]);
					$this->db->where('PERIKSA_ID', $periksa_id[0]);
					$arr_status = array('STATUS' => '00', 'UPDATE_BY' => $this->newsession->userdata('SESS_USER_ID'),'LAST_UPDATE' => 'GETDATE()');
					$this->db->where('PERIKSA_ID', $periksa_id[0]);
					if($this->db->update('T_PEMERIKSAAN', $arr_status)) $ret = "MSG#Data Pemeriksaan Berhasil Dihapus#";
						$this->db->where('PERIKSA_ID', $periksa_id[0]);
						$this->db->delete('T_PEMERIKSAAN_TEMUAN_PRODUK');
						$get_nama = $sipt->main->get_uraian("SELECT NAMA_SARANA FROM M_SARANA WHERE SARANA_ID='".$split_uri[0]."'", "NAMA_SARANA");
						$sipt->main->get_kegiatan("Menghapus Data Pemeriksaan Untuk Sarana : ".$get_nama);				  
				}
				if($isajax!="ajax"){
					redirect(base_url());
					exit();			  
				}
				return $ret;
			}
		}else{
			redirect(base_url());
			exit();
		}
	}

	
	function get_petugas($submenu, $doc, $kk, $id="", $subid=""){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$sipt->load->model("main", "main", true);
			if($id == "") return redirect(base_url());
			$id = explode(".",$id); 
			$surat_id = $sipt->main->get_uraian("SELECT SURAT_ID FROM T_SURAT_TUGAS_PELAPORAN WHERE LAPOR_ID='$id[0]'","SURAT_ID");
			if($subid != ""){
				$query = "SELECT B.USER_ID, B.NAMA_USER FROM T_SURAT_TUGAS_PETUGAS A LEFT JOIN T_USER B ON A.USER_ID = B.USER_ID WHERE A.SURAT_ID = '$surat_id' AND A.USER_ID = '$subid'";
				$data = $sipt->main->get_result($query);
				if($data){
					foreach($query->result_array() as $row){
						$arrdata = array('act' => site_url().'/post/pemeriksaan/set_petugas/update/',
										 'sess' => $row,
										 'SURAT_ID' => $surat_id,
										 'header' => 'Edit Petugas Pemeriksa',
										 'save' => 'Update',
										 'cancel' => 'Batal');
					}
				}				
			}else{
				$arrdata = array('act' => site_url().'/post/pemeriksaan/set_petugas/save/',
								 'sess' => '',
								 'SURAT_ID' => $surat_id,
								 'header' => 'Tambah Petugas Pemeriksa',
								 'save' => 'Tambah',
								 'cancel' => 'Batal');
			}
			$query = "SELECT(SELECT (CAST(Z.SARANA_ID AS VARCHAR) + '/' + Z.JENIS_SARANA_ID + '/' + STUFF(dbo.GROUP_KLASIFIKASI(Z.PERIKSA_ID),1,1,'') + '/' + CAST(Z.PERIKSA_ID AS VARCHAR) + '.' + Z.STATUS) FROM T_PEMERIKSAAN Z WHERE Z.PERIKSA_ID='$id[0]')+'/'+B.USER_ID AS PERIKSA_ID,  A.NOMOR AS [Nomor Surat Tugas], CONVERT(VARCHAR(10), A.TANGGAL, 103) AS [Tanggal Surat], B.NAMA_USER AS [Nama Petugas], C.NAMA_BBPOM AS [Balai / Badan] FROM T_SURAT_TUGAS A LEFT JOIN T_SURAT_TUGAS_PETUGAS D ON A.SURAT_ID = D.SURAT_ID LEFT JOIN T_SURAT_TUGAS_PELAPORAN E ON A.SURAT_ID = E.SURAT_ID LEFT JOIN T_USER B ON B.USER_ID = D.USER_ID LEFT JOIN M_BBPOM C ON C.BBPOM_ID = B.BBPOM_ID WHERE E.LAPOR_ID = '$id[0]'";
			$this->load->library('newtable');
			$this->newtable->search(array(array('', '')));
			$this->newtable->hiddens(array('PERIKSA_ID'));
			$proses = array('Edit Petugas' => array('GET', site_url()."/home/pelaporan/petugas", '1'), 'Hapus Petugas' => array('POST', site_url()."/post/pemeriksaan/set_petugas/hapus/ajax", 'N'));
			$this->newtable->action(site_url());
			$this->newtable->cidb($this->db);
			$this->newtable->ciuri($this->uri->segment_array());
			$this->newtable->orderby("1 ASC");
			$this->newtable->keys("PERIKSA_ID");
			$this->newtable->rowcount("ALL");
			$this->newtable->show_search(FALSE);
			$this->newtable->menu($proses);
			$tabel = $this->newtable->generate($query);
			$arrdata['tabel'] = $tabel;
			$arrdata['url'] = $submenu."/".$doc."/".$kk."/".join(".",$id);
			$arrdata['bpomid'] = $this->newsession->userdata('SESS_BBPOM_ID');
			return $arrdata;
		}else{
			$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
		}
	}
	
	function set_petugas($action, $isajax){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$sipt->load->model("main", "main", true);
			if($action=="save"){#Tambah Petugas
				foreach($this->input->post('SURAT') as $a => $b){
					$arrsurat[$a] = $b;
				}
				$arrsurat['SURAT_ID'] = $this->input->post('surat');
				if($this->db->insert('T_SURAT_TUGAS_PETUGAS', $arrsurat)) return "MSG#YES#Data berhasil disimpan#".site_url().'/home/pelaporan/petugas/'.$this->input->post('url');
				if($isajax!="ajax"){
					redirect(base_url());
					exit();
				}
			}else if($action=="update"){#Edit Petugas
				foreach($this->input->post('SURAT') as $a => $b){
					$arrsurat[$a] = $b;
				}
				$this->db->where(array("SURAT_ID" => $this->input->post("surat"),"USER_ID" => $this->input->post("user")));
				if($this->db->update('T_SURAT_TUGAS_PETUGAS', $arrsurat))return "MSG#YES#Data berhasil disimpan#".site_url().'/home/pelaporan/petugas/'.$this->input->post('url');
				if($isajax!="ajax"){
					redirect(base_url());
					exit();
				}
  			}else if($action=="hapus"){#Hapus Petugas
				$ret = "MSG#Data Gagal Dihapus.";
				foreach($this->input->post('tb_chk') as $a){
					$split_uri = explode("/", $a);
					$periksa_id = explode(".", $split_uri[3]);
					$user_id = $split_uri[4];
					$surat_id = $sipt->main->get_uraian("SELECT SURAT_ID FROM T_SURAT_TUGAS_PELAPORAN WHERE LAPOR_ID='$periksa_id[0]'","SURAT_ID");
					$this->db->where(array('SURAT_ID' => $surat_id, 'USER_ID' => $user_id));
				    if($this->db->delete('T_SURAT_TUGAS_PETUGAS')) $ret = "MSG#Petugas berhasil di hapus#";
				}
				if($isajax!="ajax"){
					redirect(base_url());
					exit();
				}
				return $ret;				  
			}
		}else{
			$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
		}
	}
	
	function set_riwayat($action, $isajax){
		if(array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) && $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main","main", true);
			if($action == "delete"){
				$ret = "MSG#Data Gagal Dihapus.\n Silahkan untuk mencoba lagi.";
				$hasil = FALSE;
				foreach($this->input->post('tb_chk') as $a){
					$arr_id = explode(".", $a);
					$sql = "DELETE FROM T_PEMERIKSAAN_PROSES WHERE PERIKSA_ID = '".$arr_id[0]."' AND SERI = '".$arr_id[1]."'";
					if($this->db->simple_query($sql)){
						$hasil = TRUE;
					}
				}
				if($hasil){
					$arr_update = explode("|",$sipt->main->get_uraian("SELECT TOP 1 HASIL +'|'+ CREATE_BY+'|'+CONVERT(VARCHAR(19), CREATE_DATE, 120) AS LOGS FROM T_PEMERIKSAAN_PROSES WHERE PERIKSA_ID = '".$arr_id[0]."' ORDER BY SERI DESC","LOGS"));
					$newstatus = "UPDATE T_PEMERIKSAAN SET STATUS = '".$arr_update[0]."', UPDATE_BY = '".$arr_update[1]."', LAST_UPDATE = '".$arr_update[2]."' WHERE PERIKSA_ID = '".$arr_id[0]."'";
					$this->db->simple_query($newstatus);
					$ret = "MSG#Riwayat Pemeriksaan Berhasil di Update#";
				}
				if($isajax!="ajax"){
					redirect(base_url());
					exit();
				}
				return $ret;
			}
		}
	}	
	
	function get_header($periksa,$sarana){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main","main", true);
			$data = "SELECT D.PERIKSA_ID, D.BBPOM_ID, A.NAMA_SARANA, B.NAMA_BBPOM, C.NAMA_JENIS_SARANA, CONVERT(VARCHAR(10), D.AWAL_PERIKSA, 103) AS AWAL_PERIKSA, CONVERT(VARCHAR(10), D.AKHIR_PERIKSA, 103) AS AKHIR_PERIKSA, D.CREATE_BY, E.URAIAN AS STATUS, F.NAMA_USER AS PETUGAS FROM M_SARANA A LEFT JOIN T_PEMERIKSAAN D ON A.SARANA_ID = D.SARANA_ID LEFT JOIN M_JENIS_SARANA C ON D.JENIS_SARANA_ID = C.JENIS_SARANA_ID LEFT JOIN M_BBPOM B ON D.BBPOM_ID = B.BBPOM_ID LEFT JOIN M_TABEL E ON D.STATUS = E.KODE LEFT JOIN T_USER F ON D.CREATE_BY = F.USER_ID WHERE A.SARANA_ID = '".$sarana."' AND D.PERIKSA_ID = '".$periksa."' AND E.JENIS = 'STATUS'";
			$res = $sipt->main->get_result($data);
			$arrdata = array('act' => site_url().'/post/pemeriksaan/set_header/update');	
			if($res){
				foreach($data->result_array() as $row){
					$arrdata['sess'] = $row;
				}
				$arrdata['petugas'] = $sipt->main->combobox("SELECT USER_ID, NAMA_USER + ' - ' +JABATAN AS NAMA FROM T_USER WHERE BBPOM_ID = '".$row['BBPOM_ID']."' AND USER_ID IN (SELECT USER_ID FROM T_USER_ROLE WHERE JENIS_PELAPORAN = '01') ORDER BY 2", "USER_ID", "NAMA", TRUE);
				return $arrdata;
			}
		}
	}
	
	function set_header($action, $isajax){
		if((array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('9', $this->newsession->userdata('SESS_KODE_ROLE')))&& $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main","main", true);
			if($action == "update"){
				$hasil = FALSE;
				$msgok = "Update header pemeriksaan berhasil disimpan";
				$msgerr = "Update header pemeriksaan gagal disimpan";
				$header = $sipt->main->post_to_query($this->input->post('PEMERIKSAAN'));
				$this->db->where('PERIKSA_ID',$this->input->post('PERIKSA_ID'));
				$res = $this->db->update('T_PEMERIKSAAN',$header);
				if($res){
					$hasil = TRUE;
				}
				if($hasil){
					return "MSG#YES#$msgok#SUKSES";
				}else{
					return "MSG#NO#$msgerr";
				}
			}
		}
	}
	
}
?>