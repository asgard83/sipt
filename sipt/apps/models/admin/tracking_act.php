<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);
class Tracking_act extends Model{

	function list_pemeriksaan(){
		if(array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('10', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('9', $this->newsession->userdata('SESS_KODE_ROLE')) || $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$this->load->library('newtable');
			$sarana = "'".join("','", $this->newsession->userdata('SESS_SARANA'))."'";
			$this->newtable->hiddens(array('IDPERIKSA','CREATE_DATE','LAST_UPDATE'));
			if($this->newsession->userdata('SESS_BBPOM_ID') == "00")
				$deleted = "";
			else
				$deleted = " AND LEN(C.STATUS) > 2 ";
			
			if($this->newsession->userdata('SESS_BBPOM_ID') == "00" || in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))){
				$this->newtable->search(array(array('', '')));
				$query = "SELECT (CAST(C.SARANA_ID AS VARCHAR) + '/' + C.JENIS_SARANA_ID + '/' + STUFF(dbo.GROUP_KLASIFIKASI(C.PERIKSA_ID),1,1,'') + '/' + CAST(C.PERIKSA_ID AS VARCHAR) + '.' + C.STATUS) AS IDPERIKSA, '<a href=\"#\" class=\"row_preview\">'+LTRIM(RTRIM(REPLACE(UPPER(E.NAMA_SARANA),'-',''))) + '</a><div><b>Komoditi : '+STUFF(dbo.GROUP_KK(C.PERIKSA_ID),1,1,'')+'</b></div><div>'+ dbo.NAMA_JENIS_SARANA(C.JENIS_SARANA_ID) +'</div><div>Alamat : '+E.ALAMAT_1+'</div><div>'+G.NAMA_PROPINSI+'</div><div><a href=\"#\" class=\"row_riwayat\" record=\"'+CAST(C.PERIKSA_ID AS VARCHAR)+'\">Riwayat Pemeriksaan</a></div>' AS [NAMA SARANA], CONVERT(VARCHAR(10), C.AWAL_PERIKSA, 103) + '<div> Sampai Dengan </div>' + CONVERT(VARCHAR(10), C.AKHIR_PERIKSA, 103) AS [TANGGAL PERIKSA], REPLACE(REPLACE(D.NAMA_BBPOM,'BALAI BESAR POM DI ', ''),'BALAI POM DI ','') AS [BB / BPOM], C.HASIL +'<div>Temuan Produk ('+ (SELECT CAST(COUNT(PERIKSA_ID) AS VARCHAR) FROM T_PEMERIKSAAN_TEMUAN_PRODUK WHERE PERIKSA_ID = C.PERIKSA_ID) +')</div>' AS HASIL, REPLACE(F.URAIAN, ' - ', '<div>') AS STATUS,  dbo.GET_HISTORY('PERIKSA',C.PERIKSA_ID)+'<div>'+dbo.GET_HISTORY('CATATAN',C.PERIKSA_ID)+'</div>' AS [UPDATE TERAKHIR], C.CREATE_DATE, C.LAST_UPDATE FROM T_PEMERIKSAAN C LEFT JOIN M_BBPOM D ON C.BBPOM_ID = D.BBPOM_ID LEFT JOIN M_SARANA E ON C.SARANA_ID = E.SARANA_ID LEFT JOIN M_TABEL F ON C.STATUS = F.KODE LEFT JOIN M_PROPINSI G ON E.PROPINSI = G.PROPINSI_ID WHERE F.JENIS = 'STATUS' AND C.JENIS_SARANA_ID IN (".$sarana.") AND YEAR(C.AWAL_PERIKSA) = '".date("Y")."' AND MONTH(C.AWAL_PERIKSA) = '".date("m")."' $deleted";	
			  $this->newtable->columns(array("(CAST(C.SARANA_ID AS VARCHAR) + '/' + C.JENIS_SARANA_ID + '/' + STUFF(dbo.GROUP_KLASIFIKASI(C.PERIKSA_ID),1,1,'') + '/' + CAST(C.PERIKSA_ID AS VARCHAR) + '.' + C.STATUS)","'<a href=\"#\" class=\"row_preview\">'+LTRIM(RTRIM(REPLACE(UPPER(E.NAMA_SARANA),'-',''))) + '</a><div><b>Komoditi : '+STUFF(dbo.GROUP_KK(C.PERIKSA_ID),1,1,'')+'</b></div><div>'+ dbo.NAMA_JENIS_SARANA(C.JENIS_SARANA_ID) +'</div><div>Alamat : '+E.ALAMAT_1+'</div><div>'+G.NAMA_PROPINSI+'</div><div><a href=\"#\" class=\"row_riwayat\" record=\"'+CAST(C.PERIKSA_ID AS VARCHAR)+'\">Riwayat Pemeriksaan</a></div>'","CONVERT(VARCHAR(10), C.AWAL_PERIKSA, 103) + '<div> Sampai Dengan </div>' + CONVERT(VARCHAR(10), C.AKHIR_PERIKSA, 103)","REPLACE(REPLACE(D.NAMA_BBPOM,'BALAI BESAR POM DI ', ''),'BALAI POM DI ','')",array("C.HASIL +'<div>Temuan Produk ('+ (SELECT CAST(COUNT(PERIKSA_ID) AS VARCHAR) FROM T_PEMERIKSAAN_TEMUAN_PRODUK WHERE PERIKSA_ID = C.PERIKSA_ID) +')</div>'",site_url().'/home/produk/view/{IDPERIKSA}'),"REPLACE(F.URAIAN,' - ', '<div>')","dbo.GET_HISTORY('PERIKSA',C.PERIKSA_ID)+'<div>'+dbo.GET_HISTORY('CATATAN',C.PERIKSA_ID)+'</div>'","C.CREATE_DATE","C.LAST_UPDATE"));
			  $this->newtable->width(array('TANGGAL PERIKSA' => 110, 'HASIL' => 75, 'STATUS' => 175, 'UPDATE TERAKHIR' => 150));
			  $this->newtable->orderby(8);
			}else{
				$this->newtable->search(array(array('', '')));
				$query = "SELECT (CAST(C.SARANA_ID AS VARCHAR) + '/' + C.JENIS_SARANA_ID + '/' + STUFF(dbo.GROUP_KLASIFIKASI(C.PERIKSA_ID),1,1,'') + '/' + CAST(C.PERIKSA_ID AS VARCHAR) + '.' + C.STATUS) AS IDPERIKSA, '<a href=\"#\" class=\"row_preview\">'+LTRIM(RTRIM(REPLACE(UPPER(E.NAMA_SARANA),'-',''))) + '</a><div><b>Komoditi : '+STUFF(dbo.GROUP_KK(C.PERIKSA_ID),1,1,'')+'</b></div><div>'+ dbo.NAMA_JENIS_SARANA(C.JENIS_SARANA_ID) +'</div><div>Alamat : '+E.ALAMAT_1+'</div><div>'+G.NAMA_PROPINSI+'</div><div><a href=\"#\" class=\"row_riwayat\" record=\"'+CAST(C.PERIKSA_ID AS VARCHAR)+'\">Riwayat Pemeriksaan</a></div>' AS [NAMA SARANA], CONVERT(VARCHAR(10), C.AWAL_PERIKSA, 103) + ' s.d ' + CONVERT(VARCHAR(10), C.AKHIR_PERIKSA, 103) AS [TANGGAL PEMERIKSAAN], C.HASIL +'<div>Temuan Produk ('+ (SELECT CAST(COUNT(PERIKSA_ID) AS VARCHAR) FROM T_PEMERIKSAAN_TEMUAN_PRODUK WHERE PERIKSA_ID = C.PERIKSA_ID) +')</div>' AS HASIL, REPLACE(F.URAIAN,' - ', '<div>') AS STATUS, dbo.GET_HISTORY('PERIKSA',C.PERIKSA_ID)+'<div>'+dbo.GET_HISTORY('CATATAN',C.PERIKSA_ID)+'</div>' AS [UPDATE TERAKHIR], C.CREATE_DATE, C.LAST_UPDATE FROM T_PEMERIKSAAN C LEFT JOIN M_SARANA E ON C.SARANA_ID = E.SARANA_ID LEFT JOIN M_TABEL F ON C.STATUS = F.KODE LEFT JOIN M_PROPINSI G ON E.PROPINSI = G.PROPINSI_ID WHERE C.BBPOM_ID ='".$this->newsession->userdata('SESS_BBPOM_ID')."' AND F.JENIS = 'STATUS' AND YEAR(C.AWAL_PERIKSA) = '".date("Y")."' AND MONTH(C.AWAL_PERIKSA) = '".date("m")."' $deleted";							
			  $this->newtable->columns(array("(CAST(C.SARANA_ID AS VARCHAR) + '/' + C.JENIS_SARANA_ID + '/' + STUFF(dbo.GROUP_KLASIFIKASI(C.PERIKSA_ID),1,1,'') + '/' + CAST(C.PERIKSA_ID AS VARCHAR) + '.' + C.STATUS)","'<a href=\"#\" class=\"row_preview\">'+LTRIM(RTRIM(REPLACE(UPPER(E.NAMA_SARANA),'-',''))) + '</a><div><b>Komoditi : '+STUFF(dbo.GROUP_KK(C.PERIKSA_ID),1,1,'')+'</b></div><div>'+ dbo.NAMA_JENIS_SARANA(C.JENIS_SARANA_ID) +'</div><div>Alamat : '+E.ALAMAT_1+'</div><div>'+G.NAMA_PROPINSI+'</div><div><a href=\"#\" class=\"row_riwayat\" record=\"'+CAST(C.PERIKSA_ID AS VARCHAR)+'\">Riwayat Pemeriksaan</a></div>'", "CONVERT(VARCHAR(10), C.AWAL_PERIKSA, 103) + ' s.d ' + CONVERT(VARCHAR(10), C.AKHIR_PERIKSA, 103)", array("C.HASIL +'<div>Temuan Produk ('+ (SELECT CAST(COUNT(PERIKSA_ID) AS VARCHAR) FROM T_PEMERIKSAAN_TEMUAN_PRODUK WHERE PERIKSA_ID = C.PERIKSA_ID) +')</div>'",site_url().'/home/produk/view/{IDPERIKSA}'), "REPLACE(F.URAIAN,' - ', '<div>')"," dbo.GET_HISTORY('PERIKSA',C.PERIKSA_ID)+'<div>'+dbo.GET_HISTORY('CATATAN',C.PERIKSA_ID)+'</div>'","C.CREATE_DATE","C.LAST_UPDATE"));
			  $this->newtable->width(array('NAMA SARANA' => 300,'TANGGAL PEMERIKSAAN' => 150, 'HASIL' => 75, 'STATUS' => 175, 'UPDATE TERAKHIR' => 130));
			  $this->newtable->orderby(7);
			}
			if(array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('9', $this->newsession->userdata('SESS_KODE_ROLE'))){
				$proses['Edit Data Surat'] = array('GET', site_url()."/home/surat/data", '1');
				$proses['Detil Data Surat'] = array('GET', site_url()."/home/surat/list", '1');
			}
			$proses['Data Petugas Pemeriksa'] = array('GET', site_url()."/home/pelaporan/petugas", '1');
			$proses['Data Temuan Produk'] = array('GET', site_url()."/home/produk/view", '1');
			$proses['Cetak Form Pemeriksaan'] = array('GETNEW', site_url()."/home/bap", '1');
			$proses['Hapus Data Pemeriksaan'] = array('POST', site_url()."/post/pemeriksaan/hapus_act/delete/ajax", 'N');
			if(array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('9', $this->newsession->userdata('SESS_KODE_ROLE'))){
				$proses['Detil Riwayat Pemeriksaan'] = array('GET', site_url()."/home/riwayat/pemeriksaan", '1');
			}
			
			$this->newtable->action(site_url()."/home/tracking/pemeriksaan");
			$this->newtable->detail(site_url()."/get/pemeriksaan/set_preview");
			$this->newtable->cidb($this->db);
			$this->newtable->ciuri($this->uri->segment_array());
			$this->newtable->sortby("DESC");
			$this->newtable->keys(array('IDPERIKSA'));
			$this->newtable->menu($proses);
			$this->newtable->show_search(FALSE);
			$tabel = $this->newtable->generate($query);
			$arrdata = array('table' => $tabel,
							 'search' => TRUE,
							 'frmsearch' => $sipt->main->_showformperiksa(site_url().'/home/cari/pemeriksaan',$cari, $subcari),
							 'idjudul' => 'judulpmnsarana',
							 'caption_header' => 'Trakcing Pemeriksaan Sarana',
							 'batal' => '',
							 'cancel' => '');
			return $arrdata;
		}else{
			$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
		}
	}

	
	function tracking_sarana($cari, $subcari){
		if(array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('10', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('9', $this->newsession->userdata('SESS_KODE_ROLE')) || $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$this->load->library('newtable');
			$uricari = explode("_",$cari);
			$urisubcari = explode("_",$subcari);
			$sess_sarana = "'".join("','", $this->newsession->userdata('SESS_SARANA'))."'";
			$this->newtable->hiddens(array('IDPERIKSA','CREATE_DATE','LAST_UPDATE'));
			$this->newtable->search(array(array('', '')));
			if($this->newsession->userdata('SESS_BBPOM_ID') == "00")
				$deleted = "";
			else
				$deleted = " AND LEN(C.STATUS) > 2 ";
				
			if($urisubcari[4]!= "ALL")
				$klas = " LEFT JOIN T_PEMERIKSAAN_KLASIFIKASI G ON C.PERIKSA_ID = G.PERIKSA_ID ";
			else
				$klas = "";
			if($this->newsession->userdata('SESS_BBPOM_ID') == "00" || in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))){
				$this->newtable->search(array(array('', '')));
				$query = "SELECT (CAST(C.SARANA_ID AS VARCHAR) + '/' + C.JENIS_SARANA_ID + '/' + STUFF(dbo.GROUP_KLASIFIKASI(C.PERIKSA_ID),1,1,'') + '/' + CAST(C.PERIKSA_ID AS VARCHAR) + '.' + C.STATUS) AS IDPERIKSA, '<a href=\"#\" class=\"row_preview\">'+LTRIM(RTRIM(REPLACE(UPPER(E.NAMA_SARANA),'-',''))) + '</a><div><b>Komoditi : '+STUFF(dbo.GROUP_KK(C.PERIKSA_ID),1,1,'')+'</b></div><div>'+ dbo.NAMA_JENIS_SARANA(C.JENIS_SARANA_ID) +'</div><div>Alamat : '+E.ALAMAT_1+'</div><div>'+H.NAMA_PROPINSI+'</div><div><a href=\"#\" class=\"row_riwayat\" record=\"'+CAST(C.PERIKSA_ID AS VARCHAR)+'\">Riwayat Pemeriksaan</a></div>' AS [NAMA SARANA], CONVERT(VARCHAR(10), C.AWAL_PERIKSA, 103) + '<div> Sampai Dengan </div>' + CONVERT(VARCHAR(10), C.AKHIR_PERIKSA, 103) AS [TANGGAL PERIKSA], REPLACE(REPLACE(D.NAMA_BBPOM,'BALAI BESAR POM DI ', ''),'BALAI POM DI ','') AS [BB / BPOM], C.HASIL +'<div>Temuan Produk ('+ (SELECT CAST(COUNT(PERIKSA_ID) AS VARCHAR) FROM T_PEMERIKSAAN_TEMUAN_PRODUK WHERE PERIKSA_ID = C.PERIKSA_ID) +')</div>' AS HASIL, REPLACE(F.URAIAN, ' - ', '<div>') AS STATUS, dbo.GET_HISTORY('PERIKSA',C.PERIKSA_ID)+'<div>'+dbo.GET_HISTORY('CATATAN',C.PERIKSA_ID)+'</div>' AS [UPDATE TERAKHIR], C.CREATE_DATE, C.LAST_UPDATE FROM T_PEMERIKSAAN C LEFT JOIN M_BBPOM D ON C.BBPOM_ID = D.BBPOM_ID LEFT JOIN M_SARANA E ON C.SARANA_ID = E.SARANA_ID LEFT JOIN M_TABEL F ON C.STATUS = F.KODE LEFT JOIN M_PROPINSI H ON E.PROPINSI = H.PROPINSI_ID $klas WHERE F.JENIS = 'STATUS' AND C.JENIS_SARANA_ID IN (".$sess_sarana.") $deleted";	
			  $this->newtable->columns(array("(CAST(C.SARANA_ID AS VARCHAR) + '/' + C.JENIS_SARANA_ID + '/' + STUFF(dbo.GROUP_KLASIFIKASI(C.PERIKSA_ID),1,1,'') + '/' + CAST(C.PERIKSA_ID AS VARCHAR) + '.' + C.STATUS)","'<a href=\"#\" class=\"row_preview\">'+LTRIM(RTRIM(REPLACE(UPPER(E.NAMA_SARANA),'-',''))) + '</a><div><b>Komoditi : '+STUFF(dbo.GROUP_KK(C.PERIKSA_ID),1,1,'')+'</b></div><div>'+ dbo.NAMA_JENIS_SARANA(C.JENIS_SARANA_ID) +'</div><div>Alamat : '+E.ALAMAT_1+'</div><div>'+H.NAMA_PROPINSI+'</div><div><a href=\"#\" class=\"row_riwayat\" record=\"'+CAST(C.PERIKSA_ID AS VARCHAR)+'\">Riwayat Pemeriksaan</a></div>'","CONVERT(VARCHAR(10), C.AWAL_PERIKSA, 103) + '<div> Sampai Dengan </div>' + CONVERT(VARCHAR(10), C.AKHIR_PERIKSA, 103)","REPLACE(REPLACE(D.NAMA_BBPOM,'BALAI BESAR POM DI ', ''),'BALAI POM DI ','')",array("C.HASIL +'<div>Temuan Produk ('+ (SELECT CAST(COUNT(PERIKSA_ID) AS VARCHAR) FROM T_PEMERIKSAAN_TEMUAN_PRODUK WHERE PERIKSA_ID = C.PERIKSA_ID) +')</div>'",site_url().'/home/produk/view/{IDPERIKSA}'),"REPLACE(F.URAIAN,' - ', '<div>')","dbo.GET_HISTORY('PERIKSA',C.PERIKSA_ID)+'<div>'+dbo.GET_HISTORY('CATATAN',C.PERIKSA_ID)+'</div>'","C.CREATE_DATE","C.LAST_UPDATE"));
			  $this->newtable->width(array('TANGGAL PERIKSA' => 110, 'HASIL' => 75, 'STATUS' => 175, 'UPDATE TERAKHIR' => 130));
			  $this->newtable->orderby(8);
			}else{
				$this->newtable->search(array(array('', '')));
				$query = "SELECT (CAST(C.SARANA_ID AS VARCHAR) + '/' + C.JENIS_SARANA_ID + '/' + STUFF(dbo.GROUP_KLASIFIKASI(C.PERIKSA_ID),1,1,'') + '/' + CAST(C.PERIKSA_ID AS VARCHAR) + '.' + C.STATUS) AS IDPERIKSA, '<a href=\"#\" class=\"row_preview\">'+LTRIM(RTRIM(REPLACE(UPPER(E.NAMA_SARANA),'-',''))) + '</a><div><b>Komoditi : '+STUFF(dbo.GROUP_KK(C.PERIKSA_ID),1,1,'')+'</b></div><div>'+ dbo.NAMA_JENIS_SARANA(C.JENIS_SARANA_ID) +'</div><div>Alamat : '+E.ALAMAT_1+'</div><div>'+H.NAMA_PROPINSI+'</div><div><a href=\"#\" class=\"row_riwayat\" record=\"'+CAST(C.PERIKSA_ID AS VARCHAR)+'\">Riwayat Pemeriksaan</a></div>' AS [NAMA SARANA], CONVERT(VARCHAR(10), C.AWAL_PERIKSA, 103) + ' s.d ' + CONVERT(VARCHAR(10), C.AKHIR_PERIKSA, 103) AS [TANGGAL PEMERIKSAAN], C.HASIL +'<div>Temuan Produk ('+ (SELECT CAST(COUNT(PERIKSA_ID) AS VARCHAR) FROM T_PEMERIKSAAN_TEMUAN_PRODUK WHERE PERIKSA_ID = C.PERIKSA_ID) +')</div>' AS HASIL, REPLACE(F.URAIAN,' - ', '<div>') AS STATUS, dbo.GET_HISTORY('PERIKSA',C.PERIKSA_ID)+'<div>'+dbo.GET_HISTORY('CATATAN',C.PERIKSA_ID)+'</div>' AS [UPDATE TERAKHIR], C.CREATE_DATE, C.LAST_UPDATE FROM T_PEMERIKSAAN C LEFT JOIN M_SARANA E ON C.SARANA_ID = E.SARANA_ID LEFT JOIN M_TABEL F ON C.STATUS = F.KODE LEFT JOIN M_PROPINSI H ON E.PROPINSI = H.PROPINSI_ID $klas WHERE C.BBPOM_ID ='".$this->newsession->userdata('SESS_BBPOM_ID')."' AND F.JENIS = 'STATUS' $deleted";							
			  $this->newtable->columns(array("(CAST(C.SARANA_ID AS VARCHAR) + '/' + C.JENIS_SARANA_ID + '/' + STUFF(dbo.GROUP_KLASIFIKASI(C.PERIKSA_ID),1,1,'') + '/' + CAST(C.PERIKSA_ID AS VARCHAR) + '.' + C.STATUS)","'<a href=\"#\" class=\"row_preview\">'+LTRIM(RTRIM(REPLACE(UPPER(E.NAMA_SARANA),'-',''))) + '</a><div><b>Komoditi : '+STUFF(dbo.GROUP_KK(C.PERIKSA_ID),1,1,'')+'</b></div><div>'+ dbo.NAMA_JENIS_SARANA(C.JENIS_SARANA_ID) +'</div><div>Alamat : '+E.ALAMAT_1+'</div><div>'+H.NAMA_PROPINSI+'</div><div><a href=\"#\" class=\"row_riwayat\" record=\"'+CAST(C.PERIKSA_ID AS VARCHAR)+'\">Riwayat Pemeriksaan</a></div>'", "CONVERT(VARCHAR(10), C.AWAL_PERIKSA, 103) + ' s.d ' + CONVERT(VARCHAR(10), C.AKHIR_PERIKSA, 103)", array("C.HASIL +'<div>Temuan Produk ('+ (SELECT CAST(COUNT(PERIKSA_ID) AS VARCHAR) FROM T_PEMERIKSAAN_TEMUAN_PRODUK WHERE PERIKSA_ID = C.PERIKSA_ID) +')</div>'",site_url().'/home/produk/view/{IDPERIKSA}'), "REPLACE(F.URAIAN,' - ', '<div>')"," dbo.GET_HISTORY('PERIKSA',C.PERIKSA_ID)+'<div>'+dbo.GET_HISTORY('CATATAN',C.PERIKSA_ID)+'</div>'","C.CREATE_DATE","C.LAST_UPDATE"));
			  $this->newtable->width(array('NAMA SARANA' => 300,'TANGGAL PEMERIKSAAN' => 150, 'HASIL' => 75, 'STATUS' => 175, 'UPDATE TERAKHIR' => 130));
			  $this->newtable->orderby(7);
			}
						
			if(array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('9', $this->newsession->userdata('SESS_KODE_ROLE'))){
				$proses['Edit Data Surat'] = array('GET', site_url()."/home/surat/data", '1');
				$proses['Detil Data Surat'] = array('GET', site_url()."/home/surat/list", '1');
			}
			$proses['Data Petugas Pemeriksa'] = array('GET', site_url()."/home/pelaporan/petugas", '1');
			$proses['Data Temuan Produk'] = array('GET', site_url()."/home/produk/view", '1');
			$proses['Cetak Form Pemeriksaan'] = array('GETNEW', site_url()."/home/bap", '1');
			$proses['Hapus Data Pemeriksaan'] = array('POST', site_url()."/post/pemeriksaan/hapus_act/delete/ajax", 'N');
			if(array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('9', $this->newsession->userdata('SESS_KODE_ROLE'))){
				$proses['Detil Riwayat Pemeriksaan'] = array('GET', site_url()."/home/riwayat/pemeriksaan", '1');
			}
			$this->newtable->action(site_url()."/home/cari/pemeriksaan/".$cari."/".$subcari);
			$this->newtable->detail(site_url()."/get/pemeriksaan/set_preview");
			$this->newtable->cidb($this->db);
			$this->newtable->ciuri($this->uri->segment_array());
			$this->newtable->sortby("DESC");
			$this->newtable->keys(array('IDPERIKSA'));
			$this->newtable->menu($proses);
			$this->newtable->show_search(FALSE);
			if($uricari[0]!= "ALL") $query .= " AND C.PERIKSA_ID IN (SELECT Z.LAPOR_ID FROM T_SURAT_TUGAS X LEFT JOIN T_SURAT_TUGAS_PELAPORAN Z ON Z.SURAT_ID = X.SURAT_ID WHERE X.NOMOR = '".$uricari[0]."')";
			if($uricari[1] != "ALL"){ $uricari[1] = str_replace(".",",",str_replace("-"," ",$uricari[1])); $query .= " AND E.NAMA_SARANA LIKE '%".$uricari[1]."%'";
			}
			if($uricari[2] != "ALL") $query .= " AND DATEDIFF(dy, 0, convert(DATETIME, C.AWAL_PERIKSA, 105)) >= DATEDIFF(dy, 0, convert(DATETIME, '".$uricari[2]."', 105))"; 
			if($uricari[3] != "ALL") $query .= " AND DATEDIFF(dy, 0, convert(DATETIME, C.AKHIR_PERIKSA, 105)) <= DATEDIFF(dy, 0, convert(DATETIME, '".$uricari[3]."', 105))";
			if($uricari[4] != "ALL") $query .= " AND C.STATUS = '".$uricari[4]."'";
			
			$arrdisobat = array('02MM','02LL','02TF','03AA','03BB','03RS','03TR','03WW'); #Tujuan Pemeriksaan Distribusi Obat
			if(in_array($urisubcari[3],$arrdisobat) && $uricari[5] != "ALL"){
				$query .= " AND C.PERIKSA_ID IN (SELECT PERIKSA_ID FROM T_PEMERIKSAAN_DISTRIBUSI WHERE TUJUAN_PEMERIKSAAN = '".$uricari[5]."')";
			}
			
			if($urisubcari[0] != "ALL") $query .= " AND C.CREATE_BY = '".$urisubcari[0]."'";
			if($urisubcari[1] != "ALL") $query .= " AND C.BBPOM_ID = '".$urisubcari[1]."'";						
			if($urisubcari[2] != "ALL") $query .= " AND C.HASIL = '".str_replace("-"," ",$urisubcari[2])."'";
			if($urisubcari[3] != "ALL") $query .= " AND C.JENIS_SARANA_ID = '".$urisubcari[3]."'";
			if($urisubcari[4] != "ALL") $query .= " AND G.KK_ID = '".$urisubcari[4]."'";
			$tabel = $this->newtable->generate($query);
			$arrdata = array('table' => $tabel,
							 'search' => TRUE,
							 'frmsearch' => $sipt->main->_showformperiksa(site_url().'/home/cari/pemeriksaan', $cari, $subcari),
							 'idjudul' => 'judulpmnsarana',
							 'caption_header' => 'Trakcing Pemeriksaan Sarana',
							 'batal' => '',
							 'cancel' => '');
			return $arrdata;
		}else{
			$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
		}
	}	
	
	function list_produk(){
		if(array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('10', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('9', $this->newsession->userdata('SESS_KODE_ROLE')) || $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$this->load->library('newtable');
			$sarana = "'".join("','", $this->newsession->userdata('SESS_SARANA'))."'";
			$klas = "'".join("','", $this->newsession->userdata('SESS_KLASIFIKASI_ID'))."'";
			$this->newtable->hiddens(array(''));
			if($this->newsession->userdata('SESS_BBPOM_ID') == "00" || in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))){
				$this->newtable->search(array(array('', '')));
				if($this->newsession->userdata('SESS_BBPOM_ID') == "93"){
					$klas .= ",'001'";
				}
				$query = "SELECT LTRIM(RTRIM(REPLACE(UPPER(A.NAMA_SARANA),'-',''))) +'<div>Alamat : '+A.ALAMAT_1+', Propinsi : '+D.NAMA_PROPINSI+'</div>' AS [DETIL SARANA], CONVERT(VARCHAR(10), C.AWAL_PERIKSA, 103) + '<div> Sampai Dengan </div>' + CONVERT(VARCHAR(10), C.AKHIR_PERIKSA, 103) AS [TANGGAL PERIKSA], B.NAMA_PRODUK +'<div>NIE : '+B.NOMOR_REGISTRASI+'<div><div>Bets : '+B.NO_BATCH +'</div><div><b>Komoditi :'+dbo.GET_KK_PRODUK(B.PERIKSA_ID)+'</b></div>' AS [DETIL PRODUK], B.PRODUSEN+'<div>'+B.NAMA_PERUSAHAAN+'<div>' AS [PRODUSEN / PERUSAHAAN], B.KATEGORI AS [KATEGORI TEMUAN], REPLACE(REPLACE(E.NAMA_BBPOM, 'BALAI POM DI ', ''), 'BALAI BESAR POM DI ','') AS [BBPOM/BPOM] FROM T_PEMERIKSAAN_TEMUAN_PRODUK B LEFT JOIN T_PEMERIKSAAN C ON B.PERIKSA_ID = C.PERIKSA_ID LEFT JOIN M_SARANA A ON C.SARANA_ID = A.SARANA_ID LEFT JOIN M_PROPINSI D ON A.PROPINSI = D.PROPINSI_ID LEFT JOIN M_BBPOM E ON C.BBPOM_ID = E.BBPOM_ID WHERE B.KK_ID IN (".$klas.")";
			}else{
				$this->newtable->search(array(array('', '')));
				$query = "SELECT LTRIM(RTRIM(REPLACE(UPPER(A.NAMA_SARANA),'-',''))) +'<div>Alamat : '+A.ALAMAT_1+', Propinsi : '+D.NAMA_PROPINSI+'</div>' AS [DETIL SARANA], CONVERT(VARCHAR(10), C.AWAL_PERIKSA, 103) + '<div> Sampai Dengan </div>' + CONVERT(VARCHAR(10), C.AKHIR_PERIKSA, 103) AS [TANGGAL PERIKSA], B.NAMA_PRODUK +'<div>NIE : '+B.NOMOR_REGISTRASI+'<div><div>Bets : '+B.NO_BATCH +'</div><div><b>Komoditi :'+dbo.GET_KK_PRODUK(B.PERIKSA_ID)+'</b></div>' AS [DETIL PRODUK], B.PRODUSEN+'<div>'+B.NAMA_PERUSAHAAN+'<div>' AS [PRODUSEN / PERUSAHAAN], B.KATEGORI AS [KATEGORI TEMUAN], REPLACE(REPLACE(E.NAMA_BBPOM, 'BALAI POM DI ', ''), 'BALAI BESAR POM DI ','') AS [BBPOM/BPOM] FROM T_PEMERIKSAAN_TEMUAN_PRODUK B LEFT JOIN T_PEMERIKSAAN C ON B.PERIKSA_ID = C.PERIKSA_ID LEFT JOIN M_SARANA A ON C.SARANA_ID = A.SARANA_ID LEFT JOIN M_PROPINSI D ON A.PROPINSI = D.PROPINSI_ID LEFT JOIN M_BBPOM E ON C.BBPOM_ID = E.BBPOM_ID WHERE C.BBPOM_ID ='".$this->newsession->userdata('SESS_BBPOM_ID')."'";
			}
			$this->newtable->columns(array("LTRIM(RTRIM(REPLACE(UPPER(A.NAMA_SARANA),'-',''))) +'<div>Alamat : '+A.ALAMAT_1+', Propinsi : '+D.NAMA_PROPINSI+'</div>'","CONVERT(VARCHAR(10), C.AWAL_PERIKSA, 103) + '<div> Sampai Dengan </div>' + CONVERT(VARCHAR(10), C.AKHIR_PERIKSA, 103)","B.NAMA_PRODUK +'<div>NIE : '+B.NOMOR_REGISTRASI+'<div><div>Bets : '+B.NO_BATCH +'</div><div><b>Komoditi :'+dbo.GET_KK_PRODUK(B.PERIKSA_ID)+'</b></div>'","B.PRODUSEN+'<div>'+B.NAMA_PERUSAHAAN+'<div>'","B.KATEGORI","REPLACE(REPLACE(E.NAMA_BBPOM, 'BALAI POM DI ', ''), 'BALAI BESAR POM DI ','')"));
			$this->newtable->width(array('DETIL SARANA' => 150, 'TANGGAL PERIKSA' => 75, 'DETIL PRODUK' => 130, 'PRODUSEN / PERUSAHAAN' => 130, 'KATEGORI TEMUAN' => 100, 'BBPOM/BPOM' => 75));
			$proses = array('Edit Data Petugas Pemeriksa' => array('GET', site_url()."/home/pelaporan/petugas", '1'), 'Hapus Data Pemeriksaan' => array('POST', site_url()."/post/pemeriksaan/hapus_act/delete/ajax", 'N'));
			$this->newtable->action(site_url()."/home/tracking/produk");
			$this->newtable->cidb($this->db);
			$this->newtable->ciuri($this->uri->segment_array());
			$this->newtable->orderby(1);
			$this->newtable->sortby("ASC");
			$this->newtable->keys(array(''));
			$this->newtable->show_search(FALSE);
			$this->newtable->show_chk(FALSE);
			$tabel = $this->newtable->generate($query);
			$arrdata = array('table' => $tabel,
							 'search' => TRUE,
							 'frmsearch' => $sipt->main->_showformproduk(site_url().'/home/cari/produk', $cari, $subcari),
							 'idjudul' => 'judulpmnsarana',
							 'caption_header' => 'Trakcing Pemeriksaan Produk',
							 'batal' => '',
							 'cancel' => '');
			return $arrdata;
		}else{
			$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
		}
	}
	
	function tracking_produk($cari, $subcari){
		if(array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('10', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('9', $this->newsession->userdata('SESS_KODE_ROLE')) || $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$this->load->library('newtable');
			$uricari = explode("_",$cari);
			$urisubcari = explode("_",$subcari);
			$sarana = "'".join("','", $this->newsession->userdata('SESS_SARANA'))."'";
			$klas = "'".join("','", $this->newsession->userdata('SESS_KLASIFIKASI_ID'))."'";
			$this->newtable->hiddens(array(''));
			if($this->newsession->userdata('SESS_BBPOM_ID') == "00" || in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))){
				$this->newtable->search(array(array('', '')));
				if($this->newsession->userdata('SESS_BBPOM_ID') == "93"){
					$klas .= ",'001'";
				}
				$query = "SELECT LTRIM(RTRIM(REPLACE(UPPER(A.NAMA_SARANA),'-',''))) +'<div>Alamat : '+A.ALAMAT_1+', Propinsi : '+D.NAMA_PROPINSI+'</div>' AS [DETIL SARANA], CONVERT(VARCHAR(10), C.AWAL_PERIKSA, 103) + '<div> Sampai Dengan </div>' + CONVERT(VARCHAR(10), C.AKHIR_PERIKSA, 103) AS [TANGGAL PERIKSA], B.NAMA_PRODUK +'<div>NIE : '+B.NOMOR_REGISTRASI+'<div><div>Bets : '+B.NO_BATCH +'</div><div><b>Komoditi :'+dbo.GET_KK_PRODUK(B.PERIKSA_ID)+'</b></div>' AS [DETIL PRODUK], B.PRODUSEN+'<div>'+B.NAMA_PERUSAHAAN+'<div>' AS [PRODUSEN / PERUSAHAAN], B.KATEGORI AS [KATEGORI TEMUAN], REPLACE(REPLACE(E.NAMA_BBPOM, 'BALAI POM DI ', ''), 'BALAI BESAR POM DI ','') AS [BBPOM/BPOM] FROM T_PEMERIKSAAN_TEMUAN_PRODUK B LEFT JOIN T_PEMERIKSAAN C ON B.PERIKSA_ID = C.PERIKSA_ID LEFT JOIN M_SARANA A ON C.SARANA_ID = A.SARANA_ID LEFT JOIN M_PROPINSI D ON A.PROPINSI = D.PROPINSI_ID LEFT JOIN M_BBPOM E ON C.BBPOM_ID = E.BBPOM_ID WHERE B.KK_ID IN (".$klas.")";
			}else{
				$this->newtable->search(array(array('', '')));
				$query = "SELECT LTRIM(RTRIM(REPLACE(UPPER(A.NAMA_SARANA),'-',''))) +'<div>Alamat : '+A.ALAMAT_1+', Propinsi : '+D.NAMA_PROPINSI+'</div>' AS [DETIL SARANA], CONVERT(VARCHAR(10), C.AWAL_PERIKSA, 103) + '<div> Sampai Dengan </div>' + CONVERT(VARCHAR(10), C.AKHIR_PERIKSA, 103) AS [TANGGAL PERIKSA], B.NAMA_PRODUK +'<div>NIE : '+B.NOMOR_REGISTRASI+'<div><div>Bets : '+B.NO_BATCH +'</div><div><b>Komoditi :'+dbo.GET_KK_PRODUK(B.PERIKSA_ID)+'</b></div>' AS [DETIL PRODUK], B.PRODUSEN+'<div>'+B.NAMA_PERUSAHAAN+'<div>' AS [PRODUSEN / PERUSAHAAN], B.KATEGORI AS [KATEGORI TEMUAN], REPLACE(REPLACE(E.NAMA_BBPOM, 'BALAI POM DI ', ''), 'BALAI BESAR POM DI ','') AS [BBPOM/BPOM] FROM T_PEMERIKSAAN_TEMUAN_PRODUK B LEFT JOIN T_PEMERIKSAAN C ON B.PERIKSA_ID = C.PERIKSA_ID LEFT JOIN M_SARANA A ON C.SARANA_ID = A.SARANA_ID LEFT JOIN M_PROPINSI D ON A.PROPINSI = D.PROPINSI_ID LEFT JOIN M_BBPOM E ON C.BBPOM_ID = E.BBPOM_ID WHERE C.BBPOM_ID ='".$this->newsession->userdata('SESS_BBPOM_ID')."'";
			}
			$this->newtable->columns(array("LTRIM(RTRIM(REPLACE(UPPER(A.NAMA_SARANA),'-',''))) +'<div>Alamat : '+A.ALAMAT_1+'</div><div>Propinsi : '+D.NAMA_PROPINSI+'</div>'","CONVERT(VARCHAR(10), C.AWAL_PERIKSA, 103) + '<div> Sampai Dengan </div>' + CONVERT(VARCHAR(10), C.AKHIR_PERIKSA, 103)","B.NAMA_PRODUK +'<div>NIE : '+B.NOMOR_REGISTRASI+'<div><div>Bets : '+B.NO_BATCH +'</div><div><b>Komoditi :'+dbo.GET_KK_PRODUK(B.PERIKSA_ID)+'</b></div>'","B.PRODUSEN+'<div>'+B.NAMA_PERUSAHAAN+'<div>'","B.KATEGORI","REPLACE(REPLACE(E.NAMA_BBPOM, 'BALAI POM DI ', ''), 'BALAI BESAR POM DI ','')"));
			$this->newtable->width(array('DETIL SARANA' => 150, 'TANGGAL PERIKSA' => 75, 'DETIL PRODUK' => 130, 'PRODUSEN / PERUSAHAAN' => 130, 'KATEGORI TEMUAN' => 100, 'BBPOM/BPOM' => 75));
			$proses = array('Edit Data Petugas Pemeriksa' => array('GET', site_url()."/home/pelaporan/petugas", '1'), 'Hapus Data Pemeriksaan' => array('POST', site_url()."/post/pemeriksaan/hapus_act/delete/ajax", 'N'));
			$this->newtable->action(site_url()."/home/cari/produk/".$cari."/".$subcari);
			$this->newtable->cidb($this->db);
			$this->newtable->ciuri($this->uri->segment_array());
			$this->newtable->orderby(1);
			$this->newtable->sortby("ASC");
			$this->newtable->keys(array(''));
			$this->newtable->show_search(FALSE);
			$this->newtable->show_chk(FALSE);
			if($uricari[0] != "ALL"){
				$uricari[0] = str_replace(",",".",str_replace("-"," ",$uricari[0]));
				$query .= " AND B.NAMA_PRODUK LIKE '%".$uricari[0]."%'";
			}else{
				$query .= "";
			}
			if($uricari[1]!= "ALL"){
				$query .= " AND B.NAMA_PERUSAHAAN LIKE '%".$uricari[1]."%'";
			}else{
				$query .= "";
			}
			if($uricari[2] != "ALL"){
				$query .= " AND C.BBPOM_ID = '".$uricari[2]."'";
			}else{
				$query .= "";
			}
			if($uricari[3] != "ALL"){
				$query .= " AND B.KATEGORI LIKE '%".$uricari[3]."%'";
			}else{
				$query .= "";
			}
			if($urisubcari[0] != "ALL") $query .= " AND DATEDIFF(dy, 0, convert(DATETIME, C.AWAL_PERIKSA, 105)) >= DATEDIFF(dy, 0, convert(DATETIME, '".$urisubcari[0]."', 105))"; 
			if($urisubcari[1] != "ALL") $query .= " AND DATEDIFF(dy, 0, convert(DATETIME, C.AWAL_PERIKSA, 105)) <= DATEDIFF(dy, 0, convert(DATETIME, '".$urisubcari[1]."', 105))";
			if($urisubcari[2] != "ALL"){
				$query .= " AND B.KK_ID = '".$urisubcari[2]."'";
			}else{
				$query .= "";
			}
			
			if($urisubcari[3] != "ALL"){
				$query .= " AND B.NOMOR_REGISTRASI LIKE '%".$urisubcari[3]."%'";
			}
			
			if($urisubcari[4] != "ALL"){
				$query .= " AND B.NO_BATCH LIKE '%".$urisubcari[4]."%'";
			}
			$tabel = $this->newtable->generate($query);
			$arrdata = array('table' => $tabel,
							 'search' => TRUE,
							 'frmsearch' => $sipt->main->_showformproduk(site_url().'/home/cari/produk', $cari, $subcari),
							 'idjudul' => 'judulpmnsarana',
							 'caption_header' => 'Trakcing Pemeriksaan Produk',
							 'batal' => '',
							 'cancel' => '');
			return $arrdata;
		}else{
			$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
		}
	}
	function list_sampling(){
		if(array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('10', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('9', $this->newsession->userdata('SESS_KODE_ROLE')) || $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$this->load->library('newtable');
			$this->newtable->search(array(array('', '')));
			$this->newtable->hiddens(array('PERIKSA_SAMPEL','KODE_SAMPEL','TANGGAL_SAMPLING'));
			if($this->newsession->userdata('SESS_BBPOM_ID') == "00" || in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))){
				
				$query = "SELECT A.PERIKSA_SAMPEL, A.KODE_SAMPEL, 
				REPLACE(REPLACE(C.NAMA_BBPOM,'BALAI BESAR POM DI ', ''),'BALAI POM DI ','') + '<div>' + CONVERT(VARCHAR(10), A.TANGGAL_SAMPLING, 120) +'</div><div>'+ A.BULAN_ANGGARAN + '</div>' AS [BB / BPOM <br> TANGGAL & BULAN ANGGARAN],  dbo.URAIAN_M_TABEL('ASAL_SAMPLING',A.ASAL_SAMPEL) + '<div>' + dbo.URAIAN_M_TABEL('TUJUAN_SAMPLING',A.TUJUAN_SAMPLING) +'</div>' AS [ASAL & TUJUAN <br> SAMPLING],
	'<a href=\"javascript:;\" class=\"row_preview\">' +A.NAMA_SAMPEL +'</a><div>' + dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) + '</div><div>' + CASE WHEN A.SPU_ID != '0' THEN 
	dbo.FORMAT_NOMOR('SPU',A.SPU_ID) ELSE '-' END +'</div>' AS [NAMA & KODE <br> SAMPEL], dbo.KATEGORI(A.KOMODITI, A.PRIORITAS) AS KOMODITI,
	CAST(A.JUMLAH_SAMPEL AS VARCHAR) +'&nbsp;'+ A.SATUAN +'<div>&bull;&nbsp;Uji Kimia : '+ CAST(A.JUMLAH_KIMIA AS VARCHAR)+', Uji Mikro : '+CAST(A.JUMLAH_MIKRO AS VARCHAR) +'</div><div>&bull;&nbsp;Sisa Sampel : '+CAST(A.SISA AS VARCHAR) +'</div>' AS [JUMLAH <br> SAMPEL],
	CASE WHEN UJI_KIMIA = '1' AND UJI_MIKRO = '1' THEN 'Uji Kimia - Mikro' 
	WHEN UJI_KIMIA = '1' THEN 'Uji Kimia' WHEN UJI_MIKRO = '1' THEN 'Uji Mikro' END AS [JENIS UJI],
	dbo.URAIAN_M_TABEL('STATUS', A.STATUS_SAMPEL) AS [STATUS], CONVERT(VARCHAR(10), A.TANGGAL_SAMPLING,120) AS TANGGAL_SAMPLING
	FROM T_M_SAMPEL A LEFT JOIN T_PERIKSA_SAMPEL B ON A.PERIKSA_SAMPEL = B.PERIKSA_SAMPEL
	LEFT JOIN M_BBPOM C ON B.BBPOM_ID = C.BBPOM_ID WHERE YEAR(A.TANGGAL_SAMPLING) = '".date("Y")."' AND MONTH(A.TANGGAL_SAMPLING) = '".date("m")."' AND A.STATUS_SAMPEL <> '00000' "; 
				if($this->newsession->userdata('SESS_BBPOM_ID') == '91'){#Ditwas Produksi
					$query .= $sipt->main->find_where($query);
					$query .= " LEFT(A.KATEGORI,2) = '01'";
				}else if($this->newsession->userdata('SESS_BBPOM_ID') == '92'){#Ditwas Distribusi
					$query .= $sipt->main->find_where($query);
					$query .= " LEFT(A.KATEGORI,2) = '01' AND A.TUJUAN_SAMPLING IN ('02')";
				}else if($this->newsession->userdata('SESS_BBPOM_ID') == '93'){#Ditwas NAPZA
					$query .= $sipt->main->find_where($query);
					$query .= " LEFT(A.KATEGORI,2) = '07' OR LEFT(A.KATEGORI,2) = '20'";
				}else if($this->newsession->userdata('SESS_BBPOM_ID') == '94'){#Insert OTKOS
					$query .= $sipt->main->find_where($query);
					$query .= " LEFT(A.KATEGORI,2) = '10' OR LEFT(A.KATEGORI,2) = '11' OR LEFT(A.KATEGORI,2) = '12'";
				}else if($this->newsession->userdata('SESS_BBPOM_ID') == '95'){#Insert Pangan
					$query .= $sipt->main->find_where($query);
					$query .= " LEFT(A.KATEGORI,2) = '13'";
				}else if($this->newsession->userdata('SESS_BBPOM_ID') == '96'){#Ditwas BB
					$query .= $sipt->main->find_where($query);
					$query .= " LEFT(A.KATEGORI,2) = '14'";
				}
				
			}else{
			$query = "SELECT A.PERIKSA_SAMPEL, A.KODE_SAMPEL, 
			REPLACE(REPLACE(C.NAMA_BBPOM,'BALAI BESAR POM DI ', ''),'BALAI POM DI ','') + '<div>' + CONVERT(VARCHAR(10), A.TANGGAL_SAMPLING, 120) +'</div><div>'+ A.BULAN_ANGGARAN + '</div>' AS [BB / BPOM <br> TANGGAL & BULAN ANGGARAN],  dbo.URAIAN_M_TABEL('ASAL_SAMPLING',A.ASAL_SAMPEL) + '<div>' + dbo.URAIAN_M_TABEL('TUJUAN_SAMPLING',A.TUJUAN_SAMPLING) +'</div>' AS [ASAL & TUJUAN <br> SAMPLING],
'<a href=\"javascript:;\" class=\"row_preview\">' +A.NAMA_SAMPEL +'</a><div>' + dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) + '</div><div>' + CASE WHEN A.SPU_ID != '0' THEN 
	dbo.FORMAT_NOMOR('SPU',A.SPU_ID) ELSE '-' END +'</div>' AS [NAMA & KODE <br> SAMPEL], dbo.KATEGORI(A.KOMODITI, A.PRIORITAS) AS KOMODITI,
CAST(A.JUMLAH_SAMPEL AS VARCHAR) +'&nbsp;'+ A.SATUAN +'<div>&bull;&nbsp;Uji Kimia : '+ CAST(A.JUMLAH_KIMIA AS VARCHAR)+', Uji Mikro : '+CAST(A.JUMLAH_MIKRO AS VARCHAR) +'</div><div>&bull;&nbsp;Sisa Sampel : '+CAST(A.SISA AS VARCHAR) +'</div>' AS [JUMLAH <br> SAMPEL],
CASE WHEN UJI_KIMIA = '1' AND UJI_MIKRO = '1' THEN 'Uji Kimia - Mikro' 
WHEN UJI_KIMIA = '1' THEN 'Uji Kimia' WHEN UJI_MIKRO = '1' THEN 'Uji Mikro' END AS [JENIS UJI],
dbo.URAIAN_M_TABEL('STATUS', A.STATUS_SAMPEL) AS [STATUS], CONVERT(VARCHAR(10), A.TANGGAL_SAMPLING,120) AS TANGGAL_SAMPLING
FROM T_M_SAMPEL A LEFT JOIN T_PERIKSA_SAMPEL B ON A.PERIKSA_SAMPEL = B.PERIKSA_SAMPEL
LEFT JOIN M_BBPOM C ON B.BBPOM_ID = C.BBPOM_ID WHERE B.BBPOM_ID ='".$this->newsession->userdata('SESS_BBPOM_ID')."' $in AND YEAR(A.TANGGAL_SAMPLING) = '".date("Y")."' AND MONTH(A.TANGGAL_SAMPLING) = '".date("m")."' AND A.STATUS_SAMPEL <> '00000'";
			}
			$this->newtable->columns(array("A.PERIKSA_SAMPEL", "A.KODE_SAMPEL", "REPLACE(REPLACE(C.NAMA_BBPOM,'BALAI BESAR POM DI ', ''),'BALAI POM DI ','') + '<div>' +CONVERT(VARCHAR(10), A.TANGGAL_SAMPLING, 120) +'</div><div>'+ A.BULAN_ANGGARAN + '</div>'", "dbo.URAIAN_M_TABEL('ASAL_SAMPLING',A.ASAL_SAMPEL) + '<div>' + dbo.URAIAN_M_TABEL('TUJUAN_SAMPLING',A.TUJUAN_SAMPLING) +'</div>'","'<a href=\"javascript:;\" class=\"row_preview\">' +A.NAMA_SAMPEL +'</a><div>' + dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) + '</div><div>' + CASE WHEN A.SPU_ID != '0' THEN 
	dbo.FORMAT_NOMOR('SPU',A.SPU_ID) ELSE '-' END +'</div>'", "dbo.KATEGORI(A.KOMODITI, A.PRIORITAS)", "CAST(A.JUMLAH_SAMPEL AS VARCHAR) +'&nbsp;'+ A.SATUAN +'<div>&bull;&nbsp;Uji Kimia : '+ CAST(A.JUMLAH_KIMIA AS VARCHAR)+', Uji Mikro : '+CAST(A.JUMLAH_MIKRO AS VARCHAR) +'</div><div>&bull;&nbsp;Sisa Sampel : '+CAST(A.SISA AS VARCHAR) +'</div>'", "CASE WHEN UJI_KIMIA = '1' AND UJI_MIKRO = '1' THEN 'Uji Kimia - Mikro' WHEN UJI_KIMIA = '1' THEN 'Uji Kimia' WHEN UJI_MIKRO = '1' THEN 'Uji Mikro' END","dbo.URAIAN_M_TABEL('STATUS', A.STATUS_SAMPEL)","CONVERT(VARCHAR(10), A.TANGGAL_SAMPLING,120)"));
			$this->newtable->width(array('BB / BPOM <br> TANGGAL & BULAN ANGGARAN' => 100, 'ASAL & TUJUAN <br> SAMPLING' => 200, 'NAMA & KODE <br> SAMPEL' => 150, 'KOMODITI' => 150, 'JUMLAH <br> SAMPEL' => 150, 'JENIS UJI' => 75, 'STATUS' => 130));
			$proses['Preview Data Sampel'] = array('GET', site_url().'/home/sampel/detil', '1');
			if((array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('9', $this->newsession->userdata('SESS_KODE_ROLE'))) && !in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))){
				$proses['Edit Detil Sampel'] = array('GET', site_url().'/home/sampel/edit', '1');
				$proses['View Hasil Parameter'] = array('GET', site_url().'/home/sampel/parameter', '1');
				$proses['Hapus Data Sampel'] = array('POST', site_url()."/post/sampel/hapus_act/delete/ajax", 'N');
			}
			$this->newtable->action(site_url()."/home/tracking/sampling");
			$this->newtable->detail(site_url()."/get/pengujian/sampel");
			$this->newtable->cidb($this->db);
			$this->newtable->ciuri($this->uri->segment_array());
			$this->newtable->orderby(10);
			$this->newtable->sortby("DESC");
			$this->newtable->keys(array('PERIKSA_SAMPEL','KODE_SAMPEL'));
			$this->newtable->menu($proses);
			$this->newtable->show_search(FALSE);
			$tabel = $this->newtable->generate($query);
			$arrdata = array('table' => $tabel,
							 'search' => TRUE,
							 'frmsearch' => $sipt->main->_showformsampling(site_url().'/home/cari/sampling',$cari, $subcari),
							 'idjudul' => 'judulmsampel',
							 'caption_header' => 'Data Sampling',
							 'batal' => '',
							 'cancel' => '');
			return $arrdata;
		}else{
			$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
		}
	}
	
	function tracking_sampling($cari, $subcari){
		if(array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('10', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('9', $this->newsession->userdata('SESS_KODE_ROLE')) || $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$this->load->library('newtable');
			$uricari = explode("_",$cari);
			$urisubcari = explode("_",$subcari);
			$this->newtable->search(array(array('', '')));
			$this->newtable->hiddens(array('PERIKSA_SAMPEL','KODE_SAMPEL','TANGGAL_SAMPLING'));
			if($this->newsession->userdata('SESS_BBPOM_ID') == "00" || in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))){
				$query = "SELECT A.PERIKSA_SAMPEL, A.KODE_SAMPEL, REPLACE(REPLACE(C.NAMA_BBPOM,'BALAI BESAR POM DI ', ''),'BALAI POM DI ','') + '<div>' + CONVERT(VARCHAR(10), A.TANGGAL_SAMPLING, 120) +'</div><div>'+ A.BULAN_ANGGARAN + '</div>' AS [BB / BPOM <br> TANGGAL & BULAN ANGGARAN],  dbo.URAIAN_M_TABEL('ASAL_SAMPLING',A.ASAL_SAMPEL) + '<div>' + dbo.URAIAN_M_TABEL('TUJUAN_SAMPLING',A.TUJUAN_SAMPLING) +'</div>' AS [ASAL & TUJUAN <br> SAMPLING], '<a href=\"javascript:;\" class=\"row_preview\">' +A.NAMA_SAMPEL +'</a><div>' + dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) + '</div><div>' + CASE WHEN A.SPU_ID != '0' THEN dbo.FORMAT_NOMOR('SPU',A.SPU_ID) ELSE '-' END +'</div>' AS [NAMA & KODE <br> SAMPEL], dbo.KATEGORI(A.KOMODITI,A.PRIORITAS) AS KOMODITI, CAST(A.JUMLAH_SAMPEL AS VARCHAR) +'&nbsp;'+ A.SATUAN +'<div>&bull;&nbsp;Uji Kimia : '+ CAST(A.JUMLAH_KIMIA AS VARCHAR)+', Uji Mikro : '+CAST(A.JUMLAH_MIKRO AS VARCHAR) +'</div><div>&bull;&nbsp;Sisa Sampel : '+CAST(A.SISA AS VARCHAR) +'</div>' AS [JUMLAH <br> SAMPEL], CASE WHEN UJI_KIMIA = '1' AND UJI_MIKRO = '1' THEN 'Uji Kimia - Mikro' WHEN UJI_KIMIA = '1' THEN 'Uji Kimia' WHEN UJI_MIKRO = '1' THEN 'Uji Mikro' END AS [JENIS UJI], dbo.URAIAN_M_TABEL('STATUS', A.STATUS_SAMPEL) AS [STATUS], CONVERT(VARCHAR(10), A.TANGGAL_SAMPLING,120) AS TANGGAL_SAMPLING FROM T_M_SAMPEL A LEFT JOIN T_PERIKSA_SAMPEL B ON A.PERIKSA_SAMPEL = B.PERIKSA_SAMPEL LEFT JOIN M_BBPOM C ON B.BBPOM_ID = C.BBPOM_ID WHERE A.STATUS_SAMPEL <> '00000' ";
				if($this->newsession->userdata('SESS_BBPOM_ID') == '91'){#Ditwas Produksi
					$query .= $sipt->main->find_where($query);
					$query .= " LEFT(A.KATEGORI,2) = '01'";
				}else if($this->newsession->userdata('SESS_BBPOM_ID') == '92'){#Ditwas Distribusi
					$query .= $sipt->main->find_where($query);
					$query .= " LEFT(A.KATEGORI,2) = '01' AND A.TUJUAN_SAMPLING IN ('02')";
				}else if($this->newsession->userdata('SESS_BBPOM_ID') == '93'){#Ditwas NAPZA
					$query .= $sipt->main->find_where($query);
					$query .= " LEFT(A.KATEGORI,2) = '07' OR LEFT(A.KATEGORI,2) = '20'";
				}else if($this->newsession->userdata('SESS_BBPOM_ID') == '94'){#Insert OTKOS
					$query .= $sipt->main->find_where($query);
					$query .= " (LEFT(A.KATEGORI,2) = '10' OR LEFT(A.KATEGORI,2) = '11' OR LEFT(A.KATEGORI,2) = '12') ";
				}else if($this->newsession->userdata('SESS_BBPOM_ID') == '95'){#Insert Pangan
					$query .= $sipt->main->find_where($query);
					$query .= " LEFT(A.KATEGORI,2) = '13'";
				}else if($this->newsession->userdata('SESS_BBPOM_ID') == '96'){#Ditwas BB
					$query .= $sipt->main->find_where($query);
					$query .= " LEFT(A.KATEGORI,2) = '14'";
				}
			}else{
				$query = "SELECT A.PERIKSA_SAMPEL, A.KODE_SAMPEL, 
			REPLACE(REPLACE(C.NAMA_BBPOM,'BALAI BESAR POM DI ', ''),'BALAI POM DI ','') + '<div>' + CONVERT(VARCHAR(10), A.TANGGAL_SAMPLING, 120) +'</div><div>'+ A.BULAN_ANGGARAN + '</div>' AS [BB / BPOM <br> TANGGAL & BULAN ANGGARAN],  dbo.URAIAN_M_TABEL('ASAL_SAMPLING',A.ASAL_SAMPEL) + '<div>' + dbo.URAIAN_M_TABEL('TUJUAN_SAMPLING',A.TUJUAN_SAMPLING) +'</div>' AS [ASAL & TUJUAN <br> SAMPLING],
'<a href=\"javascript:;\" class=\"row_preview\">' +A.NAMA_SAMPEL +'</a><div>' + dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) + '</div><div>' + CASE WHEN A.SPU_ID != '0' THEN 
	dbo.FORMAT_NOMOR('SPU',A.SPU_ID) ELSE '-' END +'</div>' AS [NAMA & KODE <br> SAMPEL], dbo.KATEGORI(A.KOMODITI,A.PRIORITAS) AS KOMODITI,
CAST(A.JUMLAH_SAMPEL AS VARCHAR) +'&nbsp;'+ A.SATUAN +'<div>&bull;&nbsp;Uji Kimia : '+ CAST(A.JUMLAH_KIMIA AS VARCHAR)+', Uji Mikro : '+CAST(A.JUMLAH_MIKRO AS VARCHAR) +'</div><div>&bull;&nbsp;Sisa Sampel : '+CAST(A.SISA AS VARCHAR) +'</div>' AS [JUMLAH <br> SAMPEL],
CASE WHEN UJI_KIMIA = '1' AND UJI_MIKRO = '1' THEN 'Uji Kimia - Mikro' 
WHEN UJI_KIMIA = '1' THEN 'Uji Kimia' WHEN UJI_MIKRO = '1' THEN 'Uji Mikro' END AS [JENIS UJI],
dbo.URAIAN_M_TABEL('STATUS', A.STATUS_SAMPEL) AS [STATUS], CONVERT(VARCHAR(10), A.TANGGAL_SAMPLING,120) AS TANGGAL_SAMPLING
FROM T_M_SAMPEL A LEFT JOIN T_PERIKSA_SAMPEL B ON A.PERIKSA_SAMPEL = B.PERIKSA_SAMPEL
LEFT JOIN M_BBPOM C ON B.BBPOM_ID = C.BBPOM_ID WHERE B.BBPOM_ID ='".$this->newsession->userdata('SESS_BBPOM_ID')."' AND A.STATUS_SAMPEL <> '00000'";
			}
			if($uricari[0] != "ALL"){
				$uricari[0] = str_replace(",",".",str_replace("-"," ",$uricari[0]));
				$query .= $sipt->main->find_where($query);
				$query .= " A.NAMA_SAMPEL LIKE '%".$uricari[0]."%'";
			}else{
				$query .= "";
			}
			if($uricari[1]!= "ALL"){
				$query .= $sipt->main->find_where($query);
				$query .= " A.ASAL_SAMPEL = '".$uricari[1]."'";
			}else{
				$query .= "";
			}
			if($uricari[2]!= "ALL"){
				$query .= $sipt->main->find_where($query);
				$query .= " A.KOMODITI = '".substr($uricari[2],-2)."'";
			}else{
				$query .= "";
			}
			if($uricari[3] != "ALL"){
				$query .= $sipt->main->find_where($query);
				$query .= " DATEDIFF(dy, 0, convert(DATETIME, A.TANGGAL_SAMPLING, 105)) >= DATEDIFF(dy, 0, convert(DATETIME, '".$uricari[3]."', 105))"; 
			}
			if($uricari[4] != "ALL"){
				$query .= $sipt->main->find_where($query);
				$query .= " DATEDIFF(dy, 0, convert(DATETIME, A.TANGGAL_SAMPLING, 105)) <= DATEDIFF(dy, 0, convert(DATETIME, '".$uricari[4]."', 105))";
			}
			if($uricari[5] != "ALL"){
				$query .= $sipt->main->find_where($query);
				$query .= " A.STATUS_SAMPEL = '".$uricari[5]."'";
			}
			if($uricari[6] != "ALL"){
				$query .= $sipt->main->find_where($query);
				$query .= " A.NO_BETS LIKE '%".$uricari[6]."%'";
			}
			if($urisubcari[0] != "ALL"){
				$query .= $sipt->main->find_where($query);
				$query .= " dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) LIKE '%".$urisubcari[0]."%'";
			}
			if($urisubcari[1] != "ALL"){
				$query .= $sipt->main->find_where($query);
				$query .= " B.BBPOM_ID = '".$urisubcari[1]."'";
			}
			if($urisubcari[2] != "ALL"){
				$query .= $sipt->main->find_where($query);
				if($urisubcari[2] == "Mikro")
					$query .= " A.UJI_MIKRO = '1'";
				else
					$query .= " A.UJI_KIMIA = '1'";
			}
			if($urisubcari[3] != "ALL"){
				$query .= $sipt->main->find_where($query);
				$query .= " A.BULAN_ANGGARAN = '".$urisubcari[3]."'";
			}
			if($urisubcari[4] != "ALL"){
				$query .= $sipt->main->find_where($query);
				$query .= " dbo.FORMAT_NOMOR('SPU',A.SPU_ID) LIKE '%".$urisubcari[4]."%'";
			} 
			
			$this->newtable->columns(array("A.PERIKSA_SAMPEL", "A.KODE_SAMPEL", "REPLACE(REPLACE(C.NAMA_BBPOM,'BALAI BESAR POM DI ', ''),'BALAI POM DI ','') + '<div>' +CONVERT(VARCHAR(10), A.TANGGAL_SAMPLING, 120) +'</div><div>'+ A.BULAN_ANGGARAN + '</div>'", "dbo.URAIAN_M_TABEL('ASAL_SAMPLING',A.ASAL_SAMPEL) + '<div>' + dbo.URAIAN_M_TABEL('TUJUAN_SAMPLING',A.TUJUAN_SAMPLING) +'</div>'","'<a href=\"javascript:;\" class=\"row_preview\">' +A.NAMA_SAMPEL +'</a><div>' + dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) + '</div><div>' + CASE WHEN A.SPU_ID != '0' THEN 
	dbo.FORMAT_NOMOR('SPU',A.SPU_ID) ELSE '-' END +'</div>'", "dbo.KATEGORI(A.KOMODITI,A.PRIORITAS)", "CAST(A.JUMLAH_SAMPEL AS VARCHAR) +'&nbsp;'+ A.SATUAN +'<div>&bull;&nbsp;Uji Kimia : '+ CAST(A.JUMLAH_KIMIA AS VARCHAR)+', Uji Mikro : '+CAST(A.JUMLAH_MIKRO AS VARCHAR) +'</div><div>&bull;&nbsp;Sisa Sampel : '+CAST(A.SISA AS VARCHAR) +'</div>'", "CASE WHEN UJI_KIMIA = '1' AND UJI_MIKRO = '1' THEN 'Uji Kimia - Mikro' WHEN UJI_KIMIA = '1' THEN 'Uji Kimia' WHEN UJI_MIKRO = '1' THEN 'Uji Mikro' END","dbo.URAIAN_M_TABEL('STATUS', A.STATUS_SAMPEL)","CONVERT(VARCHAR(10), A.TANGGAL_SAMPLING,120)"));
			$this->newtable->width(array('BB / BPOM <br> TANGGAL & BULAN ANGGARAN' => 100, 'ASAL & TUJUAN <br> SAMPLING' => 200, 'NAMA & KODE <br> SAMPEL' => 150, 'KOMODITI' => 150, 'JUMLAH <br> SAMPEL' => 150, 'JENIS UJI' => 75, 'STATUS' => 130));
			$proses['Preview Data Sampel'] = array('GET', site_url().'/home/sampel/detil', '1');
			if((array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('9', $this->newsession->userdata('SESS_KODE_ROLE'))) && !in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))){
				$proses['Edit Detil Sampel'] = array('GET', site_url().'/home/sampel/edit', '1');
				$proses['View Hasil Parameter'] = array('GET', site_url().'/home/sampel/parameter', '1');
				$proses['Hapus Data Sampel'] = array('POST', site_url()."/post/sampel/hapus_act/delete/ajax", 'N');
			}
			$this->newtable->action(site_url()."/home/cari/sampling/".$cari."/".$subcari);
			$this->newtable->detail(site_url()."/get/pengujian/sampel");
			$this->newtable->cidb($this->db);
			$this->newtable->ciuri($this->uri->segment_array());
			$this->newtable->orderby(10);
			$this->newtable->sortby("DESC");
			$this->newtable->keys(array('PERIKSA_SAMPEL','KODE_SAMPEL'));
			$this->newtable->menu($proses);
			$this->newtable->show_search(FALSE);
			//echo $query;die();
			$tabel = $this->newtable->generate($query);
			$arrdata = array('table' => $tabel,
							 'search' => TRUE,
							 'frmsearch' => $sipt->main->_showformsampling(site_url().'/home/cari/sampling',$cari, $subcari),
							 'idjudul' => 'judulmsampel',
							 'caption_header' => 'Data Sampling',
							 'batal' => '',
							 'cancel' => '');
			return $arrdata;
		}else{
			$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
		}
	}
	
	
	function list_sampling_deleted(){
		if(array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('10', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('9', $this->newsession->userdata('SESS_KODE_ROLE')) || $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$this->load->library('newtable');
			$this->newtable->search(array(array('', '')));
			$this->newtable->hiddens(array('PERIKSA_SAMPEL','KODE_SAMPEL','TANGGAL_SAMPLING'));
			if($this->newsession->userdata('SESS_BBPOM_ID') == "00" || in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))){
				$query = "SELECT A.PERIKSA_SAMPEL, A.KODE_SAMPEL, 
				REPLACE(REPLACE(C.NAMA_BBPOM,'BALAI BESAR POM DI ', ''),'BALAI POM DI ','') + '<div>' + CONVERT(VARCHAR(10), A.TANGGAL_SAMPLING, 120) +'</div><div>'+ A.BULAN_ANGGARAN + '</div>' AS [BB / BPOM <br> TANGGAL & BULAN ANGGARAN],  dbo.URAIAN_M_TABEL('ASAL_SAMPLING',A.ASAL_SAMPEL) + '<div>' + dbo.URAIAN_M_TABEL('TUJUAN_SAMPLING',A.TUJUAN_SAMPLING) +'</div>' AS [ASAL & TUJUAN <br> SAMPLING],
	'<a href=\"javascript:;\" class=\"row_preview\">' +A.NAMA_SAMPEL +'</a><div>' + dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) + '</div><div>' + CASE WHEN A.SPU_ID != '0' THEN 
	dbo.FORMAT_NOMOR('SPU',A.SPU_ID) ELSE '-' END +'</div>' AS [NAMA & KODE <br> SAMPEL], dbo.KATEGORI(A.KOMODITI,A.PRIORITAS) AS KOMODITI,
	CAST(A.JUMLAH_SAMPEL AS VARCHAR) +'&nbsp;'+ A.SATUAN +'<div>&bull;&nbsp;Uji Kimia : '+ CAST(A.JUMLAH_KIMIA AS VARCHAR)+', Uji Mikro : '+CAST(A.JUMLAH_MIKRO AS VARCHAR) +'</div><div>&bull;&nbsp;Sisa Sampel : '+CAST(A.SISA AS VARCHAR) +'</div>' AS [JUMLAH <br> SAMPEL],
	CASE WHEN UJI_KIMIA = '1' AND UJI_MIKRO = '1' THEN 'Uji Kimia - Mikro' 
	WHEN UJI_KIMIA = '1' THEN 'Uji Kimia' WHEN UJI_MIKRO = '1' THEN 'Uji Mikro' END AS [JENIS UJI],
	dbo.URAIAN_M_TABEL('STATUS', A.STATUS_SAMPEL) AS [STATUS], CONVERT(VARCHAR(10), A.TANGGAL_SAMPLING,120) AS TANGGAL_SAMPLING
	FROM T_M_SAMPEL_DELETE A LEFT JOIN T_PERIKSA_SAMPEL B ON A.PERIKSA_SAMPEL = B.PERIKSA_SAMPEL
	LEFT JOIN M_BBPOM C ON B.BBPOM_ID = C.BBPOM_ID WHERE YEAR(A.TANGGAL_SAMPLING) = '".date("Y")."' AND MONTH(A.TANGGAL_SAMPLING) = '".date("m")."'"; 
				if($this->newsession->userdata('SESS_BBPOM_ID') == '91'){#Ditwas Produksi
					$query .= $sipt->main->find_where($query);
					$query .= " LEFT(A.KATEGORI,2) = '01'";
				}else if($this->newsession->userdata('SESS_BBPOM_ID') == '92'){#Ditwas Distribusi
					$query .= $sipt->main->find_where($query);
					$query .= " LEFT(A.KATEGORI,2) = '01' AND A.TUJUAN_SAMPLING IN ('02')";
				}else if($this->newsession->userdata('SESS_BBPOM_ID') == '93'){#Ditwas NAPZA
					$query .= $sipt->main->find_where($query);
					$query .= " LEFT(A.KATEGORI,2) = '07' OR LEFT(A.KATEGORI,2) = '20'";
				}else if($this->newsession->userdata('SESS_BBPOM_ID') == '94'){#Insert OTKOS
					$query .= $sipt->main->find_where($query);
					$query .= " LEFT(A.KATEGORI,2) = '10' OR LEFT(A.KATEGORI,2) = '11' OR LEFT(A.KATEGORI,2) = '12'";
				}else if($this->newsession->userdata('SESS_BBPOM_ID') == '95'){#Insert Pangan
					$query .= $sipt->main->find_where($query);
					$query .= " LEFT(A.KATEGORI,2) = '13'";
				}else if($this->newsession->userdata('SESS_BBPOM_ID') == '96'){#Ditwas BB
					$query .= $sipt->main->find_where($query);
					$query .= " LEFT(A.KATEGORI,2) = '14'";
				}
			}else{
			$query = "SELECT A.PERIKSA_SAMPEL, A.KODE_SAMPEL, 
			REPLACE(REPLACE(C.NAMA_BBPOM,'BALAI BESAR POM DI ', ''),'BALAI POM DI ','') + '<div>' + CONVERT(VARCHAR(10), A.TANGGAL_SAMPLING, 120) +'</div><div>'+ A.BULAN_ANGGARAN + '</div>' AS [BB / BPOM <br> TANGGAL & BULAN ANGGARAN],  dbo.URAIAN_M_TABEL('ASAL_SAMPLING',A.ASAL_SAMPEL) + '<div>' + dbo.URAIAN_M_TABEL('TUJUAN_SAMPLING',A.TUJUAN_SAMPLING) +'</div>' AS [ASAL & TUJUAN <br> SAMPLING],
'<a href=\"javascript:;\" class=\"row_preview\">' +A.NAMA_SAMPEL +'</a><div>' + dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) + '</div><div>' + CASE WHEN A.SPU_ID != '0' THEN 
	dbo.FORMAT_NOMOR('SPU',A.SPU_ID) ELSE '-' END +'</div>' AS [NAMA & KODE <br> SAMPEL], dbo.KATEGORI(A.KOMODITI,A.PRIORITAS) AS KOMODITI,
CAST(A.JUMLAH_SAMPEL AS VARCHAR) +'&nbsp;'+ A.SATUAN +'<div>&bull;&nbsp;Uji Kimia : '+ CAST(A.JUMLAH_KIMIA AS VARCHAR)+', Uji Mikro : '+CAST(A.JUMLAH_MIKRO AS VARCHAR) +'</div><div>&bull;&nbsp;Sisa Sampel : '+CAST(A.SISA AS VARCHAR) +'</div>' AS [JUMLAH <br> SAMPEL],
CASE WHEN UJI_KIMIA = '1' AND UJI_MIKRO = '1' THEN 'Uji Kimia - Mikro' 
WHEN UJI_KIMIA = '1' THEN 'Uji Kimia' WHEN UJI_MIKRO = '1' THEN 'Uji Mikro' END AS [JENIS UJI],
dbo.URAIAN_M_TABEL('STATUS', A.STATUS_SAMPEL) AS [STATUS], CONVERT(VARCHAR(10), A.TANGGAL_SAMPLING,120) AS TANGGAL_SAMPLING
FROM T_M_SAMPEL_DELETE A LEFT JOIN T_PERIKSA_SAMPEL B ON A.PERIKSA_SAMPEL = B.PERIKSA_SAMPEL
LEFT JOIN M_BBPOM C ON B.BBPOM_ID = C.BBPOM_ID WHERE B.BBPOM_ID ='".$this->newsession->userdata('SESS_BBPOM_ID')."' $in AND YEAR(A.TANGGAL_SAMPLING) = '".date("Y")."' AND MONTH(A.TANGGAL_SAMPLING) = '".date("m")."'";
			}
			$this->newtable->columns(array("A.PERIKSA_SAMPEL", "A.KODE_SAMPEL", "REPLACE(REPLACE(C.NAMA_BBPOM,'BALAI BESAR POM DI ', ''),'BALAI POM DI ','') + '<div>' +CONVERT(VARCHAR(10), A.TANGGAL_SAMPLING, 120) +'</div><div>'+ A.BULAN_ANGGARAN + '</div>'", "dbo.URAIAN_M_TABEL('ASAL_SAMPLING',A.ASAL_SAMPEL) + '<div>' + dbo.URAIAN_M_TABEL('TUJUAN_SAMPLING',A.TUJUAN_SAMPLING) +'</div>'","'<a href=\"javascript:;\" class=\"row_preview\">' +A.NAMA_SAMPEL +'</a><div>' + dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) + '</div><div>' + CASE WHEN A.SPU_ID != '0' THEN 
	dbo.FORMAT_NOMOR('SPU',A.SPU_ID) ELSE '-' END +'</div>'", "dbo.KATEGORI(A.KOMODITI,A.PRIORITAS)", "CAST(A.JUMLAH_SAMPEL AS VARCHAR) +'&nbsp;'+ A.SATUAN +'<div>&bull;&nbsp;Uji Kimia : '+ CAST(A.JUMLAH_KIMIA AS VARCHAR)+', Uji Mikro : '+CAST(A.JUMLAH_MIKRO AS VARCHAR) +'</div><div>&bull;&nbsp;Sisa Sampel : '+CAST(A.SISA AS VARCHAR) +'</div>'", "CASE WHEN UJI_KIMIA = '1' AND UJI_MIKRO = '1' THEN 'Uji Kimia - Mikro' WHEN UJI_KIMIA = '1' THEN 'Uji Kimia' WHEN UJI_MIKRO = '1' THEN 'Uji Mikro' END","dbo.URAIAN_M_TABEL('STATUS', A.STATUS_SAMPEL)","CONVERT(VARCHAR(10), A.TANGGAL_SAMPLING,120)"));
			$this->newtable->width(array('BB / BPOM <br> TANGGAL & BULAN ANGGARAN' => 100, 'ASAL & TUJUAN <br> SAMPLING' => 200, 'NAMA & KODE <br> SAMPEL' => 150, 'KOMODITI' => 150, 'JUMLAH <br> SAMPEL' => 150, 'JENIS UJI' => 75, 'STATUS' => 130));
			/*$proses['Preview Data Sampel'] = array('GET', site_url().'/home/sampel/detil', '1');
			if((array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('9', $this->newsession->userdata('SESS_KODE_ROLE'))) && !in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))){
				$proses['Edit Detil Sampel'] = array('GET', site_url().'/home/sampel/edit', '1');
				$proses['View Hasil Parameter'] = array('GET', site_url().'/home/sampel/parameter', '1');
				$proses['Hapus Data Sampel'] = array('POST', site_url()."/post/sampel/hapus_act/delete/ajax", 'N');
			}*/
			$this->newtable->action(site_url()."/home/tracking/sampel-deleted");
			$this->newtable->detail(site_url()."/get/pengujian/sampel");
			$this->newtable->cidb($this->db);
			$this->newtable->ciuri($this->uri->segment_array());
			$this->newtable->orderby(10);
			$this->newtable->sortby("DESC");
			$this->newtable->keys(array('PERIKSA_SAMPEL','KODE_SAMPEL'));
			$this->newtable->menu($proses);
			$this->newtable->show_search(FALSE);
			$tabel = $this->newtable->generate($query);
			$arrdata = array('table' => $tabel,
							 'search' => TRUE,
							 'frmsearch' => $sipt->main->_showformsampling(site_url().'/home/cari/sampel-deleted',$cari, $subcari),
							 'idjudul' => 'judulmsampel',
							 'caption_header' => 'Data Sampling Di Hapus',
							 'batal' => '',
							 'cancel' => '');
			return $arrdata;
		}else{
			$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
		}
	}
	
	function tracking_sampling_deleted($cari, $subcari){
		if(array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('10', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('9', $this->newsession->userdata('SESS_KODE_ROLE')) || $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$this->load->library('newtable');
			$uricari = explode("_",$cari);
			$urisubcari = explode("_",$subcari);
			$this->newtable->search(array(array('', '')));
			$this->newtable->hiddens(array('PERIKSA_SAMPEL','KODE_SAMPEL','TANGGAL_SAMPLING'));
			if($this->newsession->userdata('SESS_BBPOM_ID') == "00" || in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))){
				$query = "SELECT A.PERIKSA_SAMPEL, A.KODE_SAMPEL, REPLACE(REPLACE(C.NAMA_BBPOM,'BALAI BESAR POM DI ', ''),'BALAI POM DI ','') + '<div>' + CONVERT(VARCHAR(10), A.TANGGAL_SAMPLING, 120) +'</div><div>'+ A.BULAN_ANGGARAN + '</div>' AS [BB / BPOM <br> TANGGAL & BULAN ANGGARAN],  dbo.URAIAN_M_TABEL('ASAL_SAMPLING',A.ASAL_SAMPEL) + '<div>' + dbo.URAIAN_M_TABEL('TUJUAN_SAMPLING',A.TUJUAN_SAMPLING) +'</div>' AS [ASAL & TUJUAN <br> SAMPLING], '<a href=\"javascript:;\" class=\"row_preview\">' +A.NAMA_SAMPEL +'</a><div>' + dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) + '</div><div>' + CASE WHEN A.SPU_ID != '0' THEN dbo.FORMAT_NOMOR('SPU',A.SPU_ID) ELSE '-' END +'</div>' AS [NAMA & KODE <br> SAMPEL], dbo.KATEGORI(A.KOMODITI,A.PRIORITAS) AS KOMODITI, CAST(A.JUMLAH_SAMPEL AS VARCHAR) +'&nbsp;'+ A.SATUAN +'<div>&bull;&nbsp;Uji Kimia : '+ CAST(A.JUMLAH_KIMIA AS VARCHAR)+', Uji Mikro : '+CAST(A.JUMLAH_MIKRO AS VARCHAR) +'</div><div>&bull;&nbsp;Sisa Sampel : '+CAST(A.SISA AS VARCHAR) +'</div>' AS [JUMLAH <br> SAMPEL], CASE WHEN UJI_KIMIA = '1' AND UJI_MIKRO = '1' THEN 'Uji Kimia - Mikro' WHEN UJI_KIMIA = '1' THEN 'Uji Kimia' WHEN UJI_MIKRO = '1' THEN 'Uji Mikro' END AS [JENIS UJI], dbo.URAIAN_M_TABEL('STATUS', A.STATUS_SAMPEL) AS [STATUS], CONVERT(VARCHAR(10), A.TANGGAL_SAMPLING,120) AS TANGGAL_SAMPLING FROM T_M_SAMPEL_DELETE A LEFT JOIN T_PERIKSA_SAMPEL B ON A.PERIKSA_SAMPEL = B.PERIKSA_SAMPEL LEFT JOIN M_BBPOM C ON B.BBPOM_ID = C.BBPOM_ID ";
				if($this->newsession->userdata('SESS_BBPOM_ID') == '91'){#Ditwas Produksi
					$query .= $sipt->main->find_where($query);
					$query .= " LEFT(A.KATEGORI,2) = '01'";
				}else if($this->newsession->userdata('SESS_BBPOM_ID') == '92'){#Ditwas Distribusi
					$query .= $sipt->main->find_where($query);
					$query .= " LEFT(A.KATEGORI,2) = '01' AND A.TUJUAN_SAMPLING IN ('02')";
				}else if($this->newsession->userdata('SESS_BBPOM_ID') == '93'){#Ditwas NAPZA
					$query .= $sipt->main->find_where($query);
					$query .= " LEFT(A.KATEGORI,2) = '07' OR LEFT(A.KATEGORI,2) = '20'";
				}else if($this->newsession->userdata('SESS_BBPOM_ID') == '94'){#Insert OTKOS
					$query .= $sipt->main->find_where($query);
					$query .= " LEFT(A.KATEGORI,2) = '10' OR LEFT(A.KATEGORI,2) = '11' OR LEFT(A.KATEGORI,2) = '12'";
				}else if($this->newsession->userdata('SESS_BBPOM_ID') == '95'){#Insert Pangan
					$query .= $sipt->main->find_where($query);
					$query .= " LEFT(A.KATEGORI,2) = '13'";
				}else if($this->newsession->userdata('SESS_BBPOM_ID') == '96'){#Ditwas BB
					$query .= $sipt->main->find_where($query);
					$query .= " LEFT(A.KATEGORI,2) = '14'";
				}
			}else{
				$query = "SELECT A.PERIKSA_SAMPEL, A.KODE_SAMPEL, 
			REPLACE(REPLACE(C.NAMA_BBPOM,'BALAI BESAR POM DI ', ''),'BALAI POM DI ','') + '<div>' + CONVERT(VARCHAR(10), A.TANGGAL_SAMPLING, 120) +'</div><div>'+ A.BULAN_ANGGARAN + '</div>' AS [BB / BPOM <br> TANGGAL & BULAN ANGGARAN],  dbo.URAIAN_M_TABEL('ASAL_SAMPLING',A.ASAL_SAMPEL) + '<div>' + dbo.URAIAN_M_TABEL('TUJUAN_SAMPLING',A.TUJUAN_SAMPLING) +'</div>' AS [ASAL & TUJUAN <br> SAMPLING],
'<a href=\"javascript:;\" class=\"row_preview\">' +A.NAMA_SAMPEL +'</a><div>' + dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) + '</div><div>' + CASE WHEN A.SPU_ID != '0' THEN 
	dbo.FORMAT_NOMOR('SPU',A.SPU_ID) ELSE '-' END +'</div>' AS [NAMA & KODE <br> SAMPEL], dbo.KATEGORI(A.KOMODITI,A.PRIORITAS) AS KOMODITI,
CAST(A.JUMLAH_SAMPEL AS VARCHAR) +'&nbsp;'+ A.SATUAN +'<div>&bull;&nbsp;Uji Kimia : '+ CAST(A.JUMLAH_KIMIA AS VARCHAR)+', Uji Mikro : '+CAST(A.JUMLAH_MIKRO AS VARCHAR) +'</div><div>&bull;&nbsp;Sisa Sampel : '+CAST(A.SISA AS VARCHAR) +'</div>' AS [JUMLAH <br> SAMPEL],
CASE WHEN UJI_KIMIA = '1' AND UJI_MIKRO = '1' THEN 'Uji Kimia - Mikro' 
WHEN UJI_KIMIA = '1' THEN 'Uji Kimia' WHEN UJI_MIKRO = '1' THEN 'Uji Mikro' END AS [JENIS UJI],
dbo.URAIAN_M_TABEL('STATUS', A.STATUS_SAMPEL) AS [STATUS], CONVERT(VARCHAR(10), A.TANGGAL_SAMPLING,120) AS TANGGAL_SAMPLING
FROM T_M_SAMPEL_DELETE A LEFT JOIN T_PERIKSA_SAMPEL B ON A.PERIKSA_SAMPEL = B.PERIKSA_SAMPEL
LEFT JOIN M_BBPOM C ON B.BBPOM_ID = C.BBPOM_ID WHERE B.BBPOM_ID ='".$this->newsession->userdata('SESS_BBPOM_ID')."'";
			}
			if($uricari[0] != "ALL"){
				$uricari[0] = str_replace(",",".",str_replace("-"," ",$uricari[0]));
				$query .= $sipt->main->find_where($query);
				$query .= " A.NAMA_SAMPEL LIKE '%".$uricari[0]."%'";
			}else{
				$query .= "";
			}
			if($uricari[1]!= "ALL"){
				$query .= $sipt->main->find_where($query);
				$query .= " A.ASAL_SAMPEL = '".$uricari[1]."'";
			}else{
				$query .= "";
			}
			if($uricari[2]!= "ALL"){
				$query .= $sipt->main->find_where($query);
				$query .= " A.KOMODITI = '".substr($uricari[2],-2)."'";
			}else{
				$query .= "";
			}
			if($uricari[3] != "ALL"){
				$query .= $sipt->main->find_where($query);
				$query .= " DATEDIFF(dy, 0, convert(DATETIME, A.TANGGAL_SAMPLING, 105)) >= DATEDIFF(dy, 0, convert(DATETIME, '".$uricari[3]."', 105))"; 
			}
			if($uricari[4] != "ALL"){
				$query .= $sipt->main->find_where($query);
				$query .= " DATEDIFF(dy, 0, convert(DATETIME, A.TANGGAL_SAMPLING, 105)) <= DATEDIFF(dy, 0, convert(DATETIME, '".$uricari[4]."', 105))";
			}
			if($uricari[5] != "ALL"){
				$query .= $sipt->main->find_where($query);
				$query .= " A.STATUS_SAMPEL = '".$uricari[5]."'";
			}
			if($uricari[6] != "ALL"){
				$query .= $sipt->main->find_where($query);
				$query .= " A.NO_BETS LIKE '%".$uricari[6]."%'";
			}
			if($urisubcari[0] != "ALL"){
				$query .= $sipt->main->find_where($query);
				$query .= " dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) LIKE '%".$urisubcari[0]."%'";
			}
			if($urisubcari[1] != "ALL"){
				$query .= $sipt->main->find_where($query);
				$query .= " B.BBPOM_ID = '".$urisubcari[1]."'";
			}
			if($urisubcari[2] != "ALL"){
				$query .= $sipt->main->find_where($query);
				if($urisubcari[2] == "Mikro")
					$query .= " A.UJI_MIKRO = '1'";
				else
					$query .= " A.UJI_KIMIA = '1'";
			}
			if($urisubcari[3] != "ALL"){
				$query .= $sipt->main->find_where($query);
				$query .= " A.BULAN_ANGGARAN = '".$urisubcari[3]."'";
			}
			if($urisubcari[4] != "ALL"){
				$query .= $sipt->main->find_where($query);
				$query .= " dbo.FORMAT_NOMOR('SPU',A.SPU_ID) LIKE '%".$urisubcari[4]."%'";
			}
			$this->newtable->columns(array("A.PERIKSA_SAMPEL", "A.KODE_SAMPEL", "REPLACE(REPLACE(C.NAMA_BBPOM,'BALAI BESAR POM DI ', ''),'BALAI POM DI ','') + '<div>' +CONVERT(VARCHAR(10), A.TANGGAL_SAMPLING, 120) +'</div><div>'+ A.BULAN_ANGGARAN + '</div>'", "dbo.URAIAN_M_TABEL('ASAL_SAMPLING',A.ASAL_SAMPEL) + '<div>' + dbo.URAIAN_M_TABEL('TUJUAN_SAMPLING',A.TUJUAN_SAMPLING) +'</div>'","'<a href=\"javascript:;\" class=\"row_preview\">' +A.NAMA_SAMPEL +'</a><div>' + dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) + '</div><div>' + CASE WHEN A.SPU_ID != '0' THEN 
	dbo.FORMAT_NOMOR('SPU',A.SPU_ID) ELSE '-' END +'</div>'", "dbo.KATEGORI(A.KOMODITI,A.PRIORITAS)", "CAST(A.JUMLAH_SAMPEL AS VARCHAR) +'&nbsp;'+ A.SATUAN +'<div>&bull;&nbsp;Uji Kimia : '+ CAST(A.JUMLAH_KIMIA AS VARCHAR)+', Uji Mikro : '+CAST(A.JUMLAH_MIKRO AS VARCHAR) +'</div><div>&bull;&nbsp;Sisa Sampel : '+CAST(A.SISA AS VARCHAR) +'</div>'", "CASE WHEN UJI_KIMIA = '1' AND UJI_MIKRO = '1' THEN 'Uji Kimia - Mikro' WHEN UJI_KIMIA = '1' THEN 'Uji Kimia' WHEN UJI_MIKRO = '1' THEN 'Uji Mikro' END","dbo.URAIAN_M_TABEL('STATUS', A.STATUS_SAMPEL)","CONVERT(VARCHAR(10), A.TANGGAL_SAMPLING,120)"));
			$this->newtable->width(array('BB / BPOM <br> TANGGAL & BULAN ANGGARAN' => 100, 'ASAL & TUJUAN <br> SAMPLING' => 200, 'NAMA & KODE <br> SAMPEL' => 150, 'KOMODITI' => 150, 'JUMLAH <br> SAMPEL' => 150, 'JENIS UJI' => 75, 'STATUS' => 130));
			/*$proses['Preview Data Sampel'] = array('GET', site_url().'/home/sampel/detil', '1');
			if((array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('9', $this->newsession->userdata('SESS_KODE_ROLE'))) && !in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))){
				$proses['Edit Detil Sampel'] = array('GET', site_url().'/home/sampel/edit', '1');
				$proses['View Hasil Parameter'] = array('GET', site_url().'/home/sampel/parameter', '1');
				$proses['Hapus Data Sampel'] = array('POST', site_url()."/post/sampel/hapus_act/delete/ajax", 'N');
			}*/
			$this->newtable->action(site_url()."/home/cari/sampel-deleted/".$cari."/".$subcari);
			$this->newtable->detail(site_url()."/get/pengujian/sampel");
			$this->newtable->cidb($this->db);
			$this->newtable->ciuri($this->uri->segment_array());
			$this->newtable->orderby(10);
			$this->newtable->sortby("DESC");
			$this->newtable->keys(array('PERIKSA_SAMPEL','KODE_SAMPEL'));
			$this->newtable->menu($proses);
			$this->newtable->show_search(FALSE);
			$tabel = $this->newtable->generate($query);
			$arrdata = array('table' => $tabel,
							 'search' => TRUE,
							 'frmsearch' => $sipt->main->_showformsampling(site_url().'/home/cari/sampel-deleted',$cari, $subcari),
							 'idjudul' => 'judulmsampel',
							 'caption_header' => 'Data Sampling Di Hapus',
							 'batal' => '',
							 'cancel' => '');
			return $arrdata;
		}else{
			$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
		}
	}

	
	function list_hasil_uji($status){
		if(array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('10', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('9', $this->newsession->userdata('SESS_KODE_ROLE')) || $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$this->load->library('newtable');
			$this->newtable->search(array(array('', '')));
			$this->newtable->hiddens(array('KODE_SAMPEL','TANGGAL_SAMPLING'));
			
			if($status == "balai"){
				if($this->newsession->userdata('SESS_BBPOM_ID') == "00" || (in_array('9', $this->newsession->userdata('SESS_KODE_ROLE')) && !in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')))){
					$link = "+ '<div><a href=\"javascript:void(0);\" class=\"view-hasil-params\" id=\"' + A.KODE_SAMPEL + '\">Detail Parameter Uji</div>'";
				}else{
					$link = "";
				}
			}
			
			if($this->newsession->userdata('SESS_BBPOM_ID') == "00" || in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))){
				$query = "SELECT A.KODE_SAMPEL, REPLACE(REPLACE(B.NAMA_BBPOM,'BALAI BESAR POM DI ', ''),'BALAI POM DI ','') AS [BB / BPOM], dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) $link AS [KODE SAMPEL], CASE WHEN LEN(LTRIM(RTRIM(A.NOMOR_REGISTRASI))) = 0 OR LEN(LTRIM(RTRIM(A.NOMOR_REGISTRASI))) = 1 THEN A.NAMA_SAMPEL ELSE A.NAMA_SAMPEL +'<div>'+A.NOMOR_REGISTRASI+'</div>' END AS [NAMA SAMPEL], CASE WHEN LEN(LTRIM(RTRIM(A.PABRIK))) = 0 OR LEN(LTRIM(RTRIM(A.PABRIK))) = 1 THEN '' WHEN LEN(LTRIM(RTRIM(A.IMPORTIR))) = 0 OR LEN(LTRIM(RTRIM(A.IMPORTIR))) = 1 THEN A.PABRIK WHEN LEN(LTRIM(RTRIM(A.PABRIK))) = 0 OR LEN(LTRIM(RTRIM(A.PABRIK))) = 1 AND LEN(LTRIM(RTRIM(A.IMPORTIR))) = 0 OR LEN(LTRIM(RTRIM(A.IMPORTIR))) = 1 THEN A.PABRIK ELSE A.PABRIK + ' / ' + A.IMPORTIR END AS [PABRIK / IMPORTIR], LOWER(A.BENTUK_SEDIAAN) + '<div>Kemasan : ' + A.KEMASAN + '</div>' AS [BENTUK SEDIAAN], A.NO_BETS AS [NO BETS], dbo.KATEGORI(A.KOMODITI,A.PRIORITAS) AS KOMODITI, A.HASIL_SAMPEL AS [HASIL], CASE WHEN A.STATUS_KIRIM = 1 THEN 'Terkirim' WHEN A.STATUS_KIRIM = 0 THEN 'Di Kepala Balai' END AS [STATUS], CONVERT(VARCHAR(10), A.TANGGAL_SAMPLING, 120) AS TANGGAL_SAMPLING FROM T_M_SAMPEL_RILIS A LEFT JOIN M_BBPOM B ON A.BBPOM_ID = B.BBPOM_ID";
				
				if($this->newsession->userdata('SESS_BBPOM_ID') == '91'){#Ditwas Produksi
					$query .= $sipt->main->find_where($query);
					$query .= " LEFT(A.KATEGORI,2) = '01'";
				}else if($this->newsession->userdata('SESS_BBPOM_ID') == '92'){#Ditwas Distribusi
					$query .= $sipt->main->find_where($query);
					$query .= " LEFT(A.KATEGORI,2) = '01' AND A.TUJUAN_SAMPLING IN ('02')";
				}else if($this->newsession->userdata('SESS_BBPOM_ID') == '93'){#Ditwas NAPZA
					$query .= $sipt->main->find_where($query);
					$query .= " LEFT(A.KATEGORI,2) = '07' OR LEFT(A.KATEGORI,2) = '20'";
				}else if($this->newsession->userdata('SESS_BBPOM_ID') == '94'){#Insert OTKOS
					$query .= $sipt->main->find_where($query);
					$query .= " LEFT(A.KATEGORI,2) = '10' OR LEFT(A.KATEGORI,2) = '11' OR LEFT(A.KATEGORI,2) = '12'";
				}else if($this->newsession->userdata('SESS_BBPOM_ID') == '95'){#Insert Pangan
					$query .= $sipt->main->find_where($query);
					$query .= " LEFT(A.KATEGORI,2) = '13'";
				}else if($this->newsession->userdata('SESS_BBPOM_ID') == '96'){#Ditwas BB
					$query .= $sipt->main->find_where($query);
					$query .= " LEFT(A.KATEGORI,2) = '14'";
				}
				
				$this->newtable->columns(array("A.KODE_SAMPEL", "REPLACE(REPLACE(B.NAMA_BBPOM,'BALAI BESAR POM DI ', ''),'BALAI POM DI ','')", "dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) $link", "CASE WHEN LEN(LTRIM(RTRIM(A.NOMOR_REGISTRASI))) = 0 OR LEN(LTRIM(RTRIM(A.NOMOR_REGISTRASI))) = 1 THEN A.NAMA_SAMPEL ELSE A.NAMA_SAMPEL +'<div>'+A.NOMOR_REGISTRASI+'</div>' END", "CASE WHEN LEN(LTRIM(RTRIM(A.PABRIK))) = 0 OR LEN(LTRIM(RTRIM(A.PABRIK))) = 1 THEN '' WHEN LEN(LTRIM(RTRIM(A.IMPORTIR))) = 0 OR LEN(LTRIM(RTRIM(A.IMPORTIR))) = 1 THEN A.PABRIK WHEN LEN(LTRIM(RTRIM(A.PABRIK))) = 0 OR LEN(LTRIM(RTRIM(A.PABRIK))) = 1 AND LEN(LTRIM(RTRIM(A.IMPORTIR))) = 0 OR LEN(LTRIM(RTRIM(A.IMPORTIR))) = 1 THEN A.PABRIK ELSE A.PABRIK + ' / ' + A.IMPORTIR END", "LOWER(A.BENTUK_SEDIAAN) + '<div>Kemasan : ' + A.KEMASAN + '</div>'", "A.NO_BETS", "dbo.KATEGORI(A.KOMODITI,A.PRIORITAS)", "A.HASIL_SAMPEL","CASE WHEN A.STATUS_KIRIM = 1 THEN 'Terkirim' WHEN A.STATUS_KIRIM = 0 THEN 'Di Kepala Balai' END","CONVERT(VARCHAR(10), A.TANGGAL_SAMPLING, 120)"));
				$this->newtable->width(array('BB / BPOM ' => 125, 'KODE SAMPEL' => 100, 'NAMA SAMPEL' => 250, 'PABRIK / IMPORTIR' => 200, 'BENTUK SEDIAAN' => 150, 'NO BETS' => 80, 'KOMODITI' => 150, 'HASIL' => 50, 'STATUS' => 75));
				$this->newtable->orderby(11);
				if($this->newsession->userdata('SESS_BBPOM_ID') == "00"){
					$proses['Preview Sampel'] = array('GET', site_url().'/home/pengujian/data/view', '1');
				}
			}else{
				$query = "SELECT A.KODE_SAMPEL, dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) $link AS [KODE SAMPEL], CASE WHEN LEN(LTRIM(RTRIM(A.NOMOR_REGISTRASI))) = 0 OR LEN(LTRIM(RTRIM(A.NOMOR_REGISTRASI))) = 1 THEN A.NAMA_SAMPEL ELSE A.NAMA_SAMPEL +'<div>'+A.NOMOR_REGISTRASI+'</div>' END AS [NAMA SAMPEL], CASE WHEN LEN(LTRIM(RTRIM(A.PABRIK))) = 0 OR LEN(LTRIM(RTRIM(A.PABRIK))) = 1 THEN '' WHEN LEN(LTRIM(RTRIM(A.IMPORTIR))) = 0 OR LEN(LTRIM(RTRIM(A.IMPORTIR))) = 1 THEN A.PABRIK WHEN LEN(LTRIM(RTRIM(A.PABRIK))) = 0 OR LEN(LTRIM(RTRIM(A.PABRIK))) = 1 AND LEN(LTRIM(RTRIM(A.IMPORTIR))) = 0 OR LEN(LTRIM(RTRIM(A.IMPORTIR))) = 1 THEN A.PABRIK ELSE A.PABRIK + ' / ' + A.IMPORTIR END AS [PABRIK / IMPORTIR], LOWER(A.BENTUK_SEDIAAN) + '<div>Kemasan : ' + A.KEMASAN + '</div>' AS [BENTUK SEDIAAN], A.NO_BETS AS [NO BETS], dbo.KATEGORI(A.KOMODITI,A.PRIORITAS) AS KOMODITI, A.HASIL_SAMPEL AS [HASIL], CASE WHEN A.STATUS_KIRIM = 1 THEN 'Terkirim' WHEN A.STATUS_KIRIM = 0 THEN 'Di Kepala Balai' END AS [STATUS], CONVERT(VARCHAR(10), A.TANGGAL_SAMPLING, 120) AS TANGGAL_SAMPLING FROM T_M_SAMPEL_RILIS A LEFT JOIN M_BBPOM B ON A.BBPOM_ID = B.BBPOM_ID WHERE A.BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'";
				$this->newtable->columns(array("A.KODE_SAMPEL", "dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) $link", "CASE WHEN LEN(LTRIM(RTRIM(A.NOMOR_REGISTRASI))) = 0 OR LEN(LTRIM(RTRIM(A.NOMOR_REGISTRASI))) = 1 THEN A.NAMA_SAMPEL ELSE A.NAMA_SAMPEL +'<div>'+A.NOMOR_REGISTRASI+'</div>' END", "CASE WHEN LEN(LTRIM(RTRIM(A.PABRIK))) = 0 OR LEN(LTRIM(RTRIM(A.PABRIK))) = 1 THEN '' WHEN LEN(LTRIM(RTRIM(A.IMPORTIR))) = 0 OR LEN(LTRIM(RTRIM(A.IMPORTIR))) = 1 THEN A.PABRIK WHEN LEN(LTRIM(RTRIM(A.PABRIK))) = 0 OR LEN(LTRIM(RTRIM(A.PABRIK))) = 1 AND LEN(LTRIM(RTRIM(A.IMPORTIR))) = 0 OR LEN(LTRIM(RTRIM(A.IMPORTIR))) = 1 THEN A.PABRIK ELSE A.PABRIK + ' / ' + A.IMPORTIR END", "LOWER(A.BENTUK_SEDIAAN) + '<div>Kemasan : ' + A.KEMASAN + '</div>'", "A.NO_BETS", "dbo.KATEGORI(A.KOMODITI,A.PRIORITAS)", "A.HASIL_SAMPEL","CASE WHEN A.STATUS_KIRIM = 1 THEN 'Terkirim' WHEN A.STATUS_KIRIM = 0 THEN 'Di Kapal Balai' END", "CONVERT(VARCHAR(10), A.TANGGAL_SAMPLING, 120)"));
				$this->newtable->width(array('KODE SAMPEL' => 100, 'NAMA SAMPEL' => 250, 'PABRIK / IMPORTIR' => 200, 'BENTUK SEDIAAN' => 150, 'NO BETS' => 80, 'KOMODITI' => 150, 'HASIL' => 50, 'STATUS' => 75));
				$this->newtable->orderby(10);
				$proses['Preview Sampel'] = array('GET', site_url().'/home/pengujian/data/view', '1');

			}
			
			if($status == "balai"){
				$query .= $sipt->main->find_where($query);
				$query .= " A.STATUS_KIRIM = 0";
			}else if($status == "terkirim"){
				$query .= $sipt->main->find_where($query);
				$query .= " A.STATUS_KIRIM = 1";
			}
			$proses['Download CP, LHU'] = array('GETNEW', site_url().'/topdf/sampel/rilis/cp-lcp-lhu', '1');
			$this->newtable->action(site_url()."/home/tracking/hasil-uji/".$status);
			$this->newtable->detail(site_url()."/get/pengujian/sampel");
			$this->newtable->cidb($this->db);
			$this->newtable->ciuri($this->uri->segment_array());
			$this->newtable->sortby("DESC");
			$this->newtable->keys(array('KODE_SAMPEL'));
			$this->newtable->menu($proses);
			$this->newtable->show_search(FALSE);
			$tabel = $this->newtable->generate($query);
			$arrdata = array('table' => $tabel,
							 'search' => TRUE,
							 'frmsearch' => $sipt->main->_showformuji(site_url().'/home/cari/hasil-uji/'.$status, $cari, $subcari),
							 'idjudul' => 'judulmsampel',
							 'caption_header' => 'Data Hasil Pengujian',
							 'batal' => '',
							 'cancel' => '');
			return $arrdata;
		}else{
			$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
		}
	}

	function tracking_hasiluji($status, $cari, $subcari){
		if(array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('10', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('9', $this->newsession->userdata('SESS_KODE_ROLE')) || $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$this->load->library('newtable');
			$uricari = explode("_",$cari);
			$urisubcari = explode("_",$subcari);
			$this->newtable->search(array(array('', '')));
			$this->newtable->hiddens(array('KODE_SAMPEL','TANGGAL_SAMPLING'));
			if($status == "balai"){
				if($this->newsession->userdata('SESS_BBPOM_ID') == "00" || (in_array('9', $this->newsession->userdata('SESS_KODE_ROLE')) && !in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')))){
					$link = "+ '<div><a href=\"javascript:void(0);\" class=\"view-hasil-params\" id=\"' + A.KODE_SAMPEL + '\">Detail Parameter Uji</div>'";
				}else{
					$link = "";
				}
			}
			if($this->newsession->userdata('SESS_BBPOM_ID') == "00" || in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))){
				$query = "SELECT A.KODE_SAMPEL, REPLACE(REPLACE(B.NAMA_BBPOM,'BALAI BESAR POM DI ', ''),'BALAI POM DI ','') AS [BB / BPOM], dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) $link AS [KODE SAMPEL], CASE WHEN LEN(LTRIM(RTRIM(A.NOMOR_REGISTRASI))) = 0 OR LEN(LTRIM(RTRIM(A.NOMOR_REGISTRASI))) = 1 THEN A.NAMA_SAMPEL ELSE A.NAMA_SAMPEL +'<div>'+A.NOMOR_REGISTRASI+'</div>' END AS [NAMA SAMPEL], CASE WHEN LEN(LTRIM(RTRIM(A.PABRIK))) = 0 OR LEN(LTRIM(RTRIM(A.PABRIK))) = 1 THEN '' WHEN LEN(LTRIM(RTRIM(A.IMPORTIR))) = 0 OR LEN(LTRIM(RTRIM(A.IMPORTIR))) = 1 THEN A.PABRIK WHEN LEN(LTRIM(RTRIM(A.PABRIK))) = 0 OR LEN(LTRIM(RTRIM(A.PABRIK))) = 1 AND LEN(LTRIM(RTRIM(A.IMPORTIR))) = 0 OR LEN(LTRIM(RTRIM(A.IMPORTIR))) = 1 THEN A.PABRIK ELSE A.PABRIK + ' / ' + A.IMPORTIR END AS [PABRIK / IMPORTIR], LOWER(A.BENTUK_SEDIAAN) + '<div>Kemasan : ' + A.KEMASAN + '</div>' AS [BENTUK SEDIAAN], A.NO_BETS AS [NO BETS], dbo.KATEGORI(A.KOMODITI,A.PRIORITAS) AS KOMODITI, A.HASIL_SAMPEL AS [HASIL], CASE WHEN A.STATUS_KIRIM = 1 THEN 'Terkirim' WHEN A.STATUS_KIRIM = 0 THEN 'Di Kepala Balai' END AS [STATUS], CONVERT(VARCHAR(10), A.TANGGAL_SAMPLING, 120) AS TANGGAL_SAMPLING FROM T_M_SAMPEL_RILIS A LEFT JOIN M_BBPOM B ON A.BBPOM_ID = B.BBPOM_ID ";
				
				if($this->newsession->userdata('SESS_BBPOM_ID') == '91'){#Ditwas Produksi
					$query .= $sipt->main->find_where($query);
					$query .= " LEFT(A.KATEGORI,2) = '01'";
				}else if($this->newsession->userdata('SESS_BBPOM_ID') == '92'){#Ditwas Distribusi
					$query .= $sipt->main->find_where($query);
					$query .= " LEFT(A.KATEGORI,2) = '01' AND A.TUJUAN_SAMPLING IN ('02')";
				}else if($this->newsession->userdata('SESS_BBPOM_ID') == '93'){#Ditwas NAPZA
					$query .= $sipt->main->find_where($query);
					$query .= " (LEFT(A.KATEGORI,2) = '07' OR LEFT(A.KATEGORI,2) = '20') ";
				}else if($this->newsession->userdata('SESS_BBPOM_ID') == '94'){#Insert OTKOS
					$query .= $sipt->main->find_where($query);
					$query .= " (LEFT(A.KATEGORI,2) = '10' OR LEFT(A.KATEGORI,2) = '11' OR LEFT(A.KATEGORI,2) = '12')";
				}else if($this->newsession->userdata('SESS_BBPOM_ID') == '95'){#Insert Pangan
					$query .= $sipt->main->find_where($query);
					$query .= " LEFT(A.KATEGORI,2) = '13'";
				}else if($this->newsession->userdata('SESS_BBPOM_ID') == '96'){#Ditwas BB
					$query .= $sipt->main->find_where($query);
					$query .= " LEFT(A.KATEGORI,2) = '14'";
				}
				
				$this->newtable->columns(array("A.KODE_SAMPEL", "REPLACE(REPLACE(B.NAMA_BBPOM,'BALAI BESAR POM DI ', ''),'BALAI POM DI ','')", "dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) $link", "CASE WHEN LEN(LTRIM(RTRIM(A.NOMOR_REGISTRASI))) = 0 OR LEN(LTRIM(RTRIM(A.NOMOR_REGISTRASI))) = 1 THEN A.NAMA_SAMPEL ELSE A.NAMA_SAMPEL +'<div>'+A.NOMOR_REGISTRASI+'</div>' END", "CASE WHEN LEN(LTRIM(RTRIM(A.PABRIK))) = 0 OR LEN(LTRIM(RTRIM(A.PABRIK))) = 1 THEN '' WHEN LEN(LTRIM(RTRIM(A.IMPORTIR))) = 0 OR LEN(LTRIM(RTRIM(A.IMPORTIR))) = 1 THEN A.PABRIK WHEN LEN(LTRIM(RTRIM(A.PABRIK))) = 0 OR LEN(LTRIM(RTRIM(A.PABRIK))) = 1 AND LEN(LTRIM(RTRIM(A.IMPORTIR))) = 0 OR LEN(LTRIM(RTRIM(A.IMPORTIR))) = 1 THEN A.PABRIK ELSE A.PABRIK + ' / ' + A.IMPORTIR END", "LOWER(A.BENTUK_SEDIAAN) + '<div>Kemasan : ' + A.KEMASAN + '</div>'", "A.NO_BETS", "dbo.KATEGORI(A.KOMODITI,A.PRIORITAS)", "A.HASIL_SAMPEL","CASE WHEN A.STATUS_KIRIM = 1 THEN 'Terkirim' WHEN A.STATUS_KIRIM = 0 THEN 'Di Kepala Balai' END","CONVERT(VARCHAR(10), A.TANGGAL_SAMPLING, 120)"));
				$this->newtable->width(array('BB / BPOM ' => 125, 'KODE SAMPEL' => 100, 'NAMA SAMPEL' => 250, 'PABRIK / IMPORTIR' => 200, 'BENTUK SEDIAAN' => 150, 'NO BETS' => 80, 'KOMODITI' => 150, 'HASIL' => 50, 'STATUS' => 75));
				$this->newtable->orderby(11);
				if($this->newsession->userdata('SESS_BBPOM_ID') == "00"){
					$proses['Preview Sampel'] = array('GET', site_url().'/home/pengujian/data/view', '1');
				}
			}else{
				$query = "SELECT A.KODE_SAMPEL, dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) $link AS [KODE SAMPEL], CASE WHEN LEN(LTRIM(RTRIM(A.NOMOR_REGISTRASI))) = 0 OR LEN(LTRIM(RTRIM(A.NOMOR_REGISTRASI))) = 1 THEN A.NAMA_SAMPEL ELSE A.NAMA_SAMPEL +'<div>'+A.NOMOR_REGISTRASI+'</div>' END AS [NAMA SAMPEL], CASE WHEN LEN(LTRIM(RTRIM(A.PABRIK))) = 0 OR LEN(LTRIM(RTRIM(A.PABRIK))) = 1 THEN '' WHEN LEN(LTRIM(RTRIM(A.IMPORTIR))) = 0 OR LEN(LTRIM(RTRIM(A.IMPORTIR))) = 1 THEN A.PABRIK WHEN LEN(LTRIM(RTRIM(A.PABRIK))) = 0 OR LEN(LTRIM(RTRIM(A.PABRIK))) = 1 AND LEN(LTRIM(RTRIM(A.IMPORTIR))) = 0 OR LEN(LTRIM(RTRIM(A.IMPORTIR))) = 1 THEN A.PABRIK ELSE A.PABRIK + ' / ' + A.IMPORTIR END AS [PABRIK / IMPORTIR], LOWER(A.BENTUK_SEDIAAN) + '<div>Kemasan : ' + A.KEMASAN + '</div>' AS [BENTUK SEDIAAN], A.NO_BETS AS [NO BETS], dbo.KATEGORI(A.KOMODITI,A.PRIORITAS) AS KOMODITI, A.HASIL_SAMPEL AS [HASIL], CASE WHEN A.STATUS_KIRIM = 1 THEN 'Terkirim' WHEN A.STATUS_KIRIM = 0 THEN 'Di Kepala Balai' END AS [STATUS], CONVERT(VARCHAR(10), A.TANGGAL_SAMPLING, 120) AS TANGGAL_SAMPLING FROM T_M_SAMPEL_RILIS A LEFT JOIN M_BBPOM B ON A.BBPOM_ID = B.BBPOM_ID WHERE A.BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'";
				$this->newtable->columns(array("A.KODE_SAMPEL", "dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) $link", "CASE WHEN LEN(LTRIM(RTRIM(A.NOMOR_REGISTRASI))) = 0 OR LEN(LTRIM(RTRIM(A.NOMOR_REGISTRASI))) = 1 THEN A.NAMA_SAMPEL ELSE A.NAMA_SAMPEL +'<div>'+A.NOMOR_REGISTRASI+'</div>' END", "CASE WHEN LEN(LTRIM(RTRIM(A.PABRIK))) = 0 OR LEN(LTRIM(RTRIM(A.PABRIK))) = 1 THEN '' WHEN LEN(LTRIM(RTRIM(A.IMPORTIR))) = 0 OR LEN(LTRIM(RTRIM(A.IMPORTIR))) = 1 THEN A.PABRIK WHEN LEN(LTRIM(RTRIM(A.PABRIK))) = 0 OR LEN(LTRIM(RTRIM(A.PABRIK))) = 1 AND LEN(LTRIM(RTRIM(A.IMPORTIR))) = 0 OR LEN(LTRIM(RTRIM(A.IMPORTIR))) = 1 THEN A.PABRIK ELSE A.PABRIK + ' / ' + A.IMPORTIR END", "LOWER(A.BENTUK_SEDIAAN) + '<div>Kemasan : ' + A.KEMASAN + '</div>'", "A.NO_BETS", "dbo.KATEGORI(A.KOMODITI,A.PRIORITAS)", "A.HASIL_SAMPEL","CASE WHEN A.STATUS_KIRIM = 1 THEN 'Terkirim' WHEN A.STATUS_KIRIM = 0 THEN 'Di Kepala Balai' END", "CONVERT(VARCHAR(10), A.TANGGAL_SAMPLING, 120)"));
				$this->newtable->width(array('KODE SAMPEL' => 100, 'NAMA SAMPEL' => 250, 'PABRIK / IMPORTIR' => 200, 'BENTUK SEDIAAN' => 150, 'NO BETS' => 80, 'KOMODITI' => 150, 'HASIL' => 50, 'STATUS' => 75));
				$this->newtable->orderby(10);
				$proses['Preview Sampel'] = array('GET', site_url().'/home/pengujian/data/view', '1');
			}
			
			if($uricari[0] != "ALL"){
				$query .= $sipt->main->find_where($query);
				$query .= " A.BBPOM_ID = '".$uricari[0]."'";
			}
			if($uricari[1] != "ALL"){
				$query .= $sipt->main->find_where($query);
				$query .= " dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) LIKE '%".$uricari[1]."%'";
			}
			if($uricari[2]!= "ALL"){
				$query .= $sipt->main->find_where($query);
				$query .= " A.KOMODITI = '".substr($uricari[2],-2)."'";
			}
			if($uricari[3]!= "ALL"){
				$query .= $sipt->main->find_where($query);
				$query .= " A.NO_BETS LIKE '%".$uricari[3]."%'";
			}
			if($urisubcari[0] != "ALL"){
				$query .= $sipt->main->find_where($query);
				$query .= " DATEDIFF(dy, 0, convert(DATETIME, A.TANGGAL_SAMPLING, 105)) >= DATEDIFF(dy, 0, convert(DATETIME, '".$urisubcari[0]."', 105))"; 
			}
			if($urisubcari[1] != "ALL"){
				$query .= $sipt->main->find_where($query);
				$query .= " DATEDIFF(dy, 0, convert(DATETIME, A.TANGGAL_SAMPLING, 105)) <= DATEDIFF(dy, 0, convert(DATETIME, '".$urisubcari[1]."', 105))";
			}
			if($urisubcari[2] != "ALL"){
				$query .= $sipt->main->find_where($query);
				$urisubcari[2] = str_replace(",",".",str_replace("-"," ",$urisubcari[2]));
				$query .= " A.NAMA_SAMPEL LIKE '%".$urisubcari[2]."%'";
			}
			if($urisubcari[3] != "ALL"){
				$query .= $sipt->main->find_where($query);
				$query .= " A.HASIL_SAMPEL = '".$urisubcari[3]."'";
			}
			
			if($status == "balai"){
				$query .= $sipt->main->find_where($query);
				$query .= " A.STATUS_KIRIM = 0";
			}else if($status == "terkirim"){
				$query .= $sipt->main->find_where($query);
				$query .= " A.STATUS_KIRIM = 1";
			}
			
			$proses['Download CP, LHU'] = array('GETNEW', site_url().'/topdf/sampel/rilis/cp-lcp-lhu', '1');
			$this->newtable->action(site_url()."/home/cari/hasil-uji/".$status."/".$cari."/".$subcari);
			$this->newtable->detail(site_url()."/get/pengujian/sampel");
			$this->newtable->cidb($this->db);
			$this->newtable->ciuri($this->uri->segment_array());
			$this->newtable->sortby("DESC");
			$this->newtable->keys(array('KODE_SAMPEL'));
			$this->newtable->menu($proses);
			$this->newtable->show_search(FALSE);
			//echo $query;die();
			$tabel = $this->newtable->generate($query);
			$arrdata = array('table' => $tabel,
							 'search' => TRUE,
							 'frmsearch' => $sipt->main->_showformuji(site_url().'/home/cari/hasil-uji/'.$status, $cari, $subcari),
							 'idjudul' => 'judulmsampel',
							 'caption_header' => 'Data Hasil Pengujian',
							 'batal' => '',
							 'cancel' => '');
			return $arrdata;
		}
	}
	
	function master_sarana($cari, $subcari){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$sipt->load->model("main", "main", true);
			$this->load->library('newtable');
			$uricari = explode("_",$cari);
			$urisubcari = explode("_",$subcari);
			$this->newtable->hiddens(array('SARANA_ID','JENIS_SARANA'));
			$this->newtable->action(site_url()."/home/cari/sarana/".$cari."/".$subcari);
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
				
				$query = "SELECT A.SARANA_ID, A.JENIS_SARANA, UPPER(REPLACE(A.NAMA_SARANA,'-',''))+'<div>Jenis Sarana : '+B.NAMA_JENIS_SARANA+'</div>' AS [NAMA SARANA], 'Kantor : '+A.ALAMAT_1+'<div>Pabrik / Gudang : '+A.ALAMAT_2+'</div><div>'+C.NAMA_PROPINSI+'</div>' AS ALAMAT, 'Penanggung Jawab : '+A.PENANGGUNG_JAWAB+'<div>Pimpinan : '+A.NAMA_PIMPINAN+'</div>' AS [PENANGGUNG JAWAB], A.NOMOR_IZIN+'<div>'+A.TANGGAL_IZIN+'<div>' AS PERIZINAN,(SELECT  CAST(COUNT(SARANA_ID) AS VARCHAR) FROM T_PEMERIKSAAN WHERE SARANA_ID = A.SARANA_ID) +' Kali' AS 'DIPERIKSA' FROM M_SARANA A LEFT JOIN M_JENIS_SARANA B ON A.JENIS_SARANA = B.JENIS_SARANA_ID LEFT JOIN M_PROPINSI C ON A.PROPINSI = C.PROPINSI_ID WHERE A.PROPINSI IN ($prop)";
				$this->newtable->columns(array("A.SARANA_ID", "A.JENIS_SARANA","UPPER(A.NAMA_SARANA)+'<div>Jenis Sarana : '+B.NAMA_JENIS_SARANA+'</div>'", "'Kantor : '+A.ALAMAT_1+'<div>Pabrik / Gudang : '+A.ALAMAT_2+'</div><div>'+C.NAMA_PROPINSI+'</div>'","'Penanggung Jawab : '+A.PENANGGUNG_JAWAB+'<div>Pimpinan : '+A.NAMA_PIMPINAN+'</div>'","A.NOMOR_IZIN+'<div>'+A.TANGGAL_IZIN+'<div>'","(SELECT  CAST(COUNT(SARANA_ID) AS VARCHAR) FROM T_PEMERIKSAAN WHERE SARANA_ID = A.SARANA_ID) +' Kali'"));
			}else{
				$sarana = "'".join("','", $this->newsession->userdata('SESS_SARANA'))."'";
				if($this->newsession->userdata('SESS_BBPOM_ID') == "93" && in_array('9', $this->newsession->userdata('SESS_KODE_ROLE'))){
					$sarana .= "'01OO','02MM','02LL','03AA'";
				}
				if($this->newsession->userdata('SESS_BBPOM_ID') == "00"){
					$flags = " ,CASE A.FLAG WHEN '0' THEN 'Input Balai' WHEN '1' THEN 'WEB REGISTRASI' WHEN '2' THEN 'Tidah Diketahui' END AS [SUMBER DATA]";
				}else{
					$flags = "";
				}				
				$query = "SELECT A.SARANA_ID, A.JENIS_SARANA, UPPER(REPLACE(A.NAMA_SARANA,'-',''))+'<div>Jenis Sarana : '+B.NAMA_JENIS_SARANA+'</div>' AS [NAMA SARANA], 'Kantor : '+A.ALAMAT_1+'<div>Pabrik / Gudang : '+A.ALAMAT_2+'</div><div>'+C.NAMA_PROPINSI+'</div>' AS ALAMAT, 'Penanggung Jawab : '+PENANGGUNG_JAWAB+'<div>Pimpinan : '+NAMA_PIMPINAN+'</div>' AS [PENANGGUNG JAWAB], A.NOMOR_IZIN+'<div>'+A.TANGGAL_IZIN+'<div>' AS PERIZINAN,(SELECT  CAST(COUNT(SARANA_ID) AS VARCHAR) FROM T_PEMERIKSAAN WHERE SARANA_ID = A.SARANA_ID) +' Kali' AS [DIPERIKSA] $flags FROM M_SARANA A LEFT JOIN M_JENIS_SARANA B ON A.JENIS_SARANA = B.JENIS_SARANA_ID LEFT JOIN M_PROPINSI C ON A.PROPINSI = C.PROPINSI_ID WHERE A.JENIS_SARANA IN (".$sarana.")";
				$this->newtable->columns(array("A.SARANA_ID", "A.JENIS_SARANA","UPPER(REPLACE(A.NAMA_SARANA,'-',''))+'<div>Jenis Sarana : '+B.NAMA_JENIS_SARANA+'</div>'", "'Kantor : '+A.ALAMAT_1+'<div>Pabrik / Gudang : '+A.ALAMAT_2+'</div><div>'+C.NAMA_PROPINSI+'</div>'","'Penanggung Jawab : '+A.PENANGGUNG_JAWAB+'<div>Pimpinan : '+A.NAMA_PIMPINAN+'</div>'","A.NOMOR_IZIN+'<div>'+A.TANGGAL_IZIN+'<div>'","(SELECT  CAST(COUNT(SARANA_ID) AS VARCHAR) FROM T_PEMERIKSAAN WHERE SARANA_ID = A.SARANA_ID) +' Kali'","CASE A.FLAG WHEN '0' THEN 'Input Balai' WHEN '1' THEN 'WEB REGISTRASI' WHEN '2' THEN 'Tidah Diketahui' END"));
			}
			
			if($uricari[0] != "ALL"){
				$query .= " AND B.JENIS_SARANA_ID = '".$uricari[0]."'";
			}else{
				$query .= "";
			}
			
			if($uricari[1] != "ALL"){
				$uricari[1] = str_replace("-"," ",$uricari[1]);
				$query .= " AND A.NAMA_SARANA LIKE '%".$uricari[1]."%'";
			}else{
				$query .= "";
			}
			
			if($urisubcari[0] != "ALL"){
				$urisubcari[0] = str_replace("-"," ",$urisubcari[0]);
				$query .= " AND A.ALAMAT_1 LIKE '%".$urisubcari."%'";
			}else{
				$query .= "";
			}
			
			if($urisubcari[1] != "ALL"){
				$query .= " AND A.PROPINSI = '".$urisubcari[1]."'";
			}else{
				$query .= "";
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
	
	function master_petugas($id, $cari, $subcari){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$this->load->library('newtable');
			$uricari = explode("_",$cari);
			$urisubcari = explode("_",$subcari);
			if($id=="aktif"){
				$status = "A.STATUS='Aktif'";
				if(array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE'))){
					$proses['Edit Petugas'] = array('GET', site_url()."/home/petugas/new", '1');
					$proses['Non Aktifkan Petugas'] = array('POST', site_url()."/post/master/petugas/non-aktif/ajax", 'N');
					$proses['Kirim Ulang Password Petugas Ke e-Mail'] = array('POST', site_url()."/post/master/petugas/resend/ajax", 'N');
					$proses['Reset Password Default (NIP)'] = array('POST', site_url()."/post/master/petugas/default/ajax", 'N');
					$proses['Login'] = array('POST', site_url()."/post/master/petugas/login/ajax", '1');
				}else if(array_key_exists('9', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('10', $this->newsession->userdata('SESS_KODE_ROLE'))){
					$proses['Edit Petugas'] = array('GET', site_url()."/home/petugas/new", '1');
					$proses['Non Aktifkan Petugas'] = array('POST', site_url()."/post/master/petugas/non-aktif/ajax", 'N');
					$proses['Kirim Ulang Password Petugas Ke e-Mail'] = array('POST', site_url()."/post/master/petugas/resend/ajax", 'N');
					$proses['Reset Password Default (NIP)'] = array('POST', site_url()."/post/master/petugas/default/ajax", 'N');	
				}
			}else if($id=="non-aktif"){
				$status = "A.STATUS='Non-Aktif'";
				$proses = array('Aktifkan Petugas' => array('POST', site_url()."/post/master/petugas/aktif/ajax", 'N'),'Hapus Petugas' => array('POST', site_url()."/post/master/petugas/hapus/ajax", 'N'));
			}

			$this->newtable->hiddens(array(''));
			$this->newtable->action(site_url()."/home/cari/petugas/$id/".$cari."/".$subcari);
			$this->newtable->detail(site_url()."/load/master/set_detil/petugas");
			$this->newtable->cidb($this->db);
			$this->newtable->ciuri($this->uri->segment_array());
			$this->newtable->orderby(2);
			$this->newtable->sortby("ASC");
			$this->newtable->keys(array('NIP'));
			$this->newtable->search(array(array('', '')));
			$this->newtable->show_search(FALSE);
			$this->newtable->menu($proses);
			$tabel = $this->newtable->generate($query);
			if(array_key_exists('9', $this->newsession->userdata('SESS_KODE_ROLE'))){
				$sarana = "'".join("','", $this->newsession->userdata('SESS_SARANA'))."'";
				//$query = "SELECT A.USER_ID AS NIP, A.NAMA_USER AS [NAMA PETUGAS], A.JABATAN + '<div>'+ STUFF(dbo.GROUP_ROLE(A.USER_ID),1,1,'') + '</div>' AS JABATAN, dbo.GROUP_BIDANG(A.USER_ID) AS [PELAPORAN],  A.EMAIL FROM T_USER A LEFT JOIN M_BBPOM B ON A.BBPOM_ID = B.BBPOM_ID WHERE A.BBPOM_ID='".$this->newsession->userdata('SESS_BBPOM_ID')."' AND A.USER_ID IN (SELECT DISTINCT USER_ID FROM T_USER_ROLE WHERE ROLE NOT IN('1','9','10')) AND $status";
				$query = "SELECT A.USER_ID AS NIP, A.NAMA_USER AS [NAMA PETUGAS], A.JABATAN + '<div>'+ STUFF(dbo.GROUP_ROLE(A.USER_ID),1,1,'') + '</div>' AS JABATAN, dbo.GROUP_BIDANG(A.USER_ID) AS [PELAPORAN], A.EMAIL FROM T_USER A LEFT JOIN M_BBPOM B ON A.BBPOM_ID = B.BBPOM_ID WHERE A.BBPOM_ID='".$this->newsession->userdata('SESS_BBPOM_ID')."' AND $status";
				$this->newtable->columns(array("A.USER_ID", "A.NAMA_USER","A.JABATAN + '<div>'+ STUFF(dbo.GROUP_ROLE(A.USER_ID),1,1,'') + '</div>'","A.EMAIL"));				
				$this->newtable->width(array('NIP' => 100, 'NAMA PETUGAS' => 250, 'JABATAN' => 300, 'PELAPORAN' => 200, 'EMAIL' => 200));
			}else if(array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('10', $this->newsession->userdata('SESS_KODE_ROLE'))){
				$query = "SELECT A.USER_ID AS NIP, A.NAMA_USER +'<div>'+  B.NAMA_BBPOM + '</div>' AS [NAMA PETUGAS], A.JABATAN + '<div>' + STUFF(dbo.GROUP_ROLE(A.USER_ID),1,1,'') + '</div>' AS JABATAN, dbo.GROUP_BIDANG(A.USER_ID) AS [PELAPORAN], A.EMAIL FROM T_USER A LEFT JOIN M_BBPOM B ON A.BBPOM_ID = B.BBPOM_ID WHERE $status";
				$this->newtable->columns(array("A.USER_ID", "A.NAMA_USER +'<div>'+  B.NAMA_BBPOM + '</div>'","A.JABATAN + '<div>'+ STUFF(dbo.GROUP_ROLE(A.USER_ID),1,1,'') + '</div>'","A.EMAIL"));				
				$this->newtable->width(array('NIP' => 100, 'NAMA PETUGAS' => 250, 'JABATAN' => 300, 'PELAPORAN' => 200, 'EMAIL' => 200));
			}
			if($uricari[0]!= "ALL"){
				$query .= " AND A.USER_ID = '".$uricari[0]."'";
			}else{
				$query .= "";
			}			
			if($uricari[1] != "ALL"){
				$uricari[1] = str_replace("-"," ",$uricari[1]);
				$query .= " AND A.NAMA_USER LIKE '%".$uricari[1]."%'";
			}else{
				$query .= "";
			}
			
			if($uricari[2] != "ALL"){
				$query .= " AND A.USER_ID IN (SELECT DISTINCT USER_ID FROM T_USER_ROLE WHERE JENIS_PELAPORAN = '".$uricari[2]."')";
			}else{
				$query .= "";
			}
			
			if($urisubcari[0] != "ALL"){
				$query .= " AND A.USER_ID IN (SELECT DISTINCT USER_ID FROM T_USER_ROLE WHERE ROLE IN ('".$urisubcari[0]."'))";
			}else{
				$query .= "";
			}
			if($urisubcari[1] != "ALL"){
				$query .= " AND A.BBPOM_ID = '".$urisubcari[1]."'";
			}else{
				$query .= "";
			}
			$tabel = $this->newtable->generate($query);
			$arrdata = array('table' => $tabel,
							 'idjudul' => 'judulpetugas',
							 'search' => TRUE,
							 'frmsearch' => $sipt->main->_fpetugas(site_url().'/home/cari/petugas/'.$id, $cari, $subcari),
							 'caption_header' => 'Data Master Petugas SIPT',
							 'batal' => '',
							 'cancel' => '');
			return $arrdata;
		}else{
			$this->fungsi->redirectMessage('Maaf anda tidak diperkenakan mengakses halaman ini.','/home');
		}
	}
	
}
?>