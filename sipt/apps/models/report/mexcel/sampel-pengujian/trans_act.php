<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);
class Trans_act extends Model{
	
	function list_spu(){
		if(array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('10', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('9', $this->newsession->userdata('SESS_KODE_ROLE')) || $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$this->load->library('newtable');
			$this->newtable->search(array(array('', '')));
			if($this->newsession->userdata('SESS_BBPOM_ID') == "00"){
				$query = "SELECT SPU_ID, dbo.FORMAT_NOMOR('SPU',SPU_ID) +'<div>'+ CONVERT(VARCHAR(10), TANGGAL, 120) +'</div>' AS [NOMOR & TANGGAL], dbo.URAIAN_M_TABEL('ANGGARAN_SAMPLING', SUBSTRING(SPU_ID, 7,2)) +'<div>'+ dbo.URAIAN_M_TABEL('ASAL_SAMPLING', ASAL_SAMPEL) +'</div>' AS [ANGGARAN & ASAL SAMPEL], dbo.KATEGORI(SUBSTRING(SPU_ID, 13,2)) AS [KOMODITI], dbo.TOTAL_SAMPEL(SPU_ID) AS [TOTAL SAMPEL], dbo.URAIAN_M_TABEL('STATUS',STATUS) AS STATUS, CONVERT(VARCHAR(10), LAST_UPDATE, 120) +'<div>'+ CONVERT(VARCHAR(8), LAST_UPDATE, 108) +'</div>' AS [UPDATE TERAKHIR] FROM T_SPU WHERE LEFT(CONVERT(VARCHAR, CREATE_DATE, 112), 4) = '".date("Y")."' AND SUBSTRING(CONVERT(VARCHAR, CREATE_DATE, 112),5,2) = '".date("m")."'";
			}else{
				$query = "SELECT SPU_ID, dbo.FORMAT_NOMOR('SPU',SPU_ID) +'<div>'+ CONVERT(VARCHAR(10), TANGGAL, 120) +'</div>' AS [NOMOR & TANGGAL], dbo.URAIAN_M_TABEL('ANGGARAN_SAMPLING', SUBSTRING(SPU_ID, 7,2)) +'<div>'+ dbo.URAIAN_M_TABEL('ASAL_SAMPLING', ASAL_SAMPEL) +'</div>' AS [ANGGARAN & ASAL SAMPEL], dbo.KATEGORI(SUBSTRING(SPU_ID, 13,2)) AS [KOMODITI], dbo.TOTAL_SAMPEL(SPU_ID) AS [TOTAL SAMPEL], dbo.URAIAN_M_TABEL('STATUS',STATUS) AS STATUS, CONVERT(VARCHAR(10), LAST_UPDATE, 120) +'<div>'+ CONVERT(VARCHAR(8), LAST_UPDATE, 108) +'</div>' AS [UPDATE TERAKHIR] FROM T_SPU WHERE BBPOM_ID  = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND LEFT(CONVERT(VARCHAR, CREATE_DATE, 112), 4) = '".date("Y")."' AND SUBSTRING(CONVERT(VARCHAR, CREATE_DATE, 112),5,2) = '".date("m")."'";
			}
			$this->newtable->columns(array("SPU_ID", "dbo.FORMAT_NOMOR('SPU',SPU_ID) +'<div>'+ CONVERT(VARCHAR(10), TANGGAL, 120) +'</div>'", "dbo.URAIAN_M_TABEL('ANGGARAN_SAMPLING', SUBSTRING(SPU_ID, 7,2)) +'<div>'+ dbo.URAIAN_M_TABEL('ASAL_SAMPLING', ASAL_SAMPEL)+'</div>'","dbo.KATEGORI(SUBSTRING(SPU_ID, 13,2))","dbo.TOTAL_SAMPEL(SPU_ID)", "dbo.URAIAN_M_TABEL('STATUS',STATUS)","CONVERT(VARCHAR(10), LAST_UPDATE, 120) +'<div>'+ CONVERT(VARCHAR(8), LAST_UPDATE, 108) +'</div>'"));
			$this->newtable->width(array('NOMOR & TANGGAL' => 125, 'ANGGARAN & ASAL SAMPEL' => 200, 'KOMODITI' => 75,'TOTAL SAMPEL' => 50, 'STATUS' => 150, 'UPDATE TERAKHIR' => 80));
			$proses['Detail Data SPU'] = array('GET', site_url()."/home/spu/detil", '1');
			$proses['Cetak Data SPU'] = array('GETNEW', site_url()."/topdf/spu/prints", '1');
			$this->newtable->action(site_url()."/home/tracking/spu");
			$this->newtable->cidb($this->db);
			$this->newtable->ciuri($this->uri->segment_array());
			$this->newtable->orderby(7);
			$this->newtable->sortby("DESC");
			$this->newtable->hiddens(array('SPU_ID'));
			$this->newtable->keys(array('SPU_ID'));
			$this->newtable->menu($proses);
			$this->newtable->show_search(FALSE);
			$tabel = $this->newtable->generate($query);
			$arrdata = array('table' => $tabel,
							 'search' => TRUE,
							 'frmsearch' => $sipt->main->_showformspu(site_url().'/home/cari/spu',$cari, $subcari),
							 'idjudul' => 'judulmsampel',
							 'caption_header' => 'Data Surat Permintaan Uji',
							 'batal' => '',
							 'cancel' => '');
			return $arrdata;
		}else{
			$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
		}
	}
	
	function tracking_spu($cari, $subcari){
		if(array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('10', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('9', $this->newsession->userdata('SESS_KODE_ROLE')) || $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$this->load->library('newtable');
			$uricari = explode("_",$cari);
			$urisubcari = explode("_",$subcari);
			$this->newtable->search(array(array('', '')));
			if($this->newsession->userdata('SESS_BBPOM_ID') == "00"){
				$query = "SELECT SPU_ID, dbo.FORMAT_NOMOR('SPU',SPU_ID) +'<div>'+ CONVERT(VARCHAR(10), TANGGAL, 120) +'</div>' AS [NOMOR & TANGGAL], dbo.URAIAN_M_TABEL('ANGGARAN_SAMPLING', SUBSTRING(SPU_ID, 7,2)) +'<div>'+ dbo.URAIAN_M_TABEL('ASAL_SAMPLING', ASAL_SAMPEL) +'</div>' AS [ANGGARAN & ASAL SAMPEL], dbo.KATEGORI(SUBSTRING(SPU_ID, 13,2)) AS [KOMODITI], dbo.TOTAL_SAMPEL(SPU_ID) AS [TOTAL SAMPEL], dbo.URAIAN_M_TABEL('STATUS',STATUS) AS STATUS, CONVERT(VARCHAR(10), LAST_UPDATE, 120) +'<div>'+ CONVERT(VARCHAR(8), LAST_UPDATE, 108) +'</div>' AS [UPDATE TERAKHIR] FROM T_SPU";
			}else{
				$query = "SELECT SPU_ID, dbo.FORMAT_NOMOR('SPU',SPU_ID) +'<div>'+ CONVERT(VARCHAR(10), TANGGAL, 120) +'</div>' AS [NOMOR & TANGGAL], dbo.URAIAN_M_TABEL('ANGGARAN_SAMPLING', SUBSTRING(SPU_ID, 7,2)) +'<div>'+ dbo.URAIAN_M_TABEL('ASAL_SAMPLING', ASAL_SAMPEL) +'</div>' AS [ANGGARAN & ASAL SAMPEL], dbo.KATEGORI(SUBSTRING(SPU_ID, 13,2)) AS [KOMODITI], dbo.TOTAL_SAMPEL(SPU_ID) AS [TOTAL SAMPEL], dbo.URAIAN_M_TABEL('STATUS',STATUS) AS STATUS, CONVERT(VARCHAR(10), LAST_UPDATE, 120) +'<div>'+ CONVERT(VARCHAR(8), LAST_UPDATE, 108) +'</div>' AS [UPDATE TERAKHIR] FROM T_SPU WHERE BBPOM_ID  = '".$this->newsession->userdata('SESS_BBPOM_ID')."'";
			}
			
			if($uricari[0] != "ALL"){
				$query .= $sipt->main->find_where($query);
				$query .= " BBPOM_ID = '".$uricari[0]."'";
			}
			if($uricari[1] != "ALL"){
				$query .= $sipt->main->find_where($query);
				$query .= " SUBSTRING(SPU_ID,13,2) = '".$uricari[1]."'";
			}
			
			if($urisubcari[0] != "ALL"){
				$query .= $sipt->main->find_where($query);
				$query .= " DATEDIFF(dy, 0, convert(DATETIME, TANGGAL, 105)) >= DATEDIFF(dy, 0, convert(DATETIME, '".$urisubcari[0]."', 105))"; 
			}
			if($urisubcari[1] != "ALL"){
				$query .= $sipt->main->find_where($query);
				$query .= " DATEDIFF(dy, 0, convert(DATETIME, TANGGAL, 105)) <= DATEDIFF(dy, 0, convert(DATETIME, '".$urisubcari[1]."', 105))";
			}
			if($urisubcari[2] != "ALL"){
				$query .= $sipt->main->find_where($query);
				$query .= " dbo.FORMAT_NOMOR('SPU',SPU_ID) LIKE '%".$urisubcari[2]."%'";
			}
			
			$this->newtable->columns(array("SPU_ID", "dbo.FORMAT_NOMOR('SPU',SPU_ID) +'<div>'+ CONVERT(VARCHAR(10), TANGGAL, 120) +'</div>'", "dbo.URAIAN_M_TABEL('ANGGARAN_SAMPLING', SUBSTRING(SPU_ID, 7,2)) +'<div>'+ dbo.URAIAN_M_TABEL('ASAL_SAMPLING', ASAL_SAMPEL)+'</div>'","dbo.KATEGORI(SUBSTRING(SPU_ID, 13,2))","dbo.TOTAL_SAMPEL(SPU_ID)", "dbo.URAIAN_M_TABEL('STATUS',STATUS)","CONVERT(VARCHAR(10), LAST_UPDATE, 120) +'<div>'+ CONVERT(VARCHAR(8), LAST_UPDATE, 108) +'</div>'"));
			$this->newtable->width(array('NOMOR & TANGGAL' => 125, 'ANGGARAN & ASAL SAMPEL' => 200, 'KOMODITI' => 75,'TOTAL SAMPEL' => 50, 'STATUS' => 150, 'UPDATE TERAKHIR' => 80));
			$proses['Detail Data SPU'] = array('GET', site_url()."/home/spu/detil", '1');
			$proses['Cetak Data SPU'] = array('GETNEW', site_url()."/topdf/spu/prints", '1');
			$this->newtable->action(site_url()."/home/cari/spu/".$cari."/".$subcari);
			$this->newtable->cidb($this->db);
			$this->newtable->ciuri($this->uri->segment_array());
			$this->newtable->orderby(7);
			$this->newtable->sortby("DESC");
			$this->newtable->hiddens(array('SPU_ID'));
			$this->newtable->keys(array('SPU_ID'));
			$this->newtable->menu($proses);
			$this->newtable->show_search(FALSE);
			$tabel = $this->newtable->generate($query);
			$arrdata = array('table' => $tabel,
							 'search' => TRUE,
							 'frmsearch' => $sipt->main->_showformspu(site_url().'/home/cari/spu',$cari, $subcari),
							 'idjudul' => 'judulmsampel',
							 'caption_header' => 'Data Surat Permintaan Uji',
							 'batal' => '',
							 'cancel' => '');
			return $arrdata;
		}else{
			$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
		}
	}
	
	function list_spk(){
		if(array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('10', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('9', $this->newsession->userdata('SESS_KODE_ROLE')) || $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$this->load->library('newtable');
			$this->newtable->search(array(array('', '')));
			if($this->newsession->userdata('SESS_BBPOM_ID') == "00"){
				$query =  "SELECT B.SPK_ID, A.SPU_ID, A.NOMOR_SP, C.KODE_SAMPEL, C.PERIKSA_SAMPEL, B.KASIE, dbo.FORMAT_NOMOR('SPL', C.KODE_SAMPEL) +'<div>'+ dbo.FORMAT_NOMOR('SPU',A.SPU_ID) +'<div>' AS [KODE SAMPEL <br> NOMOR SPU], dbo.FORMAT_NOMOR('SPK',B.SPK_ID) +'<div>'+ CONVERT(VARCHAR(10), B.TANGGAL, 120) +'</div>' AS [NOMOR & TANGGAL SPK], C.NAMA_SAMPEL +'<div>Komoditi : '+ dbo.KATEGORI(SUBSTRING(A.SPU_ID, 13,2)) +'</div>' AS [NAMA SAMPEL], CASE WHEN B.STATUS = '20201' THEN 'SPK Baru' ELSE D.NAMA_USER END AS [PENYELIA] FROM T_SPK B LEFT JOIN T_SPU A ON B.SPU_ID = A.SPU_ID LEFT JOIN T_M_SAMPEL C ON B.KODE_SAMPEL = C.KODE_SAMPEL LEFT JOIN T_USER D ON B.KASIE = D.USER_ID WHERE LEFT(CONVERT(VARCHAR, B.CREATE_DATE, 112), 4) = '".date("Y")."' AND SUBSTRING(CONVERT(VARCHAR, B.CREATE_DATE, 112),5,2) = '".date("m")."'";
			}else{
				$query =  "SELECT B.SPK_ID, A.SPU_ID, A.NOMOR_SP, C.KODE_SAMPEL, C.PERIKSA_SAMPEL, B.KASIE, dbo.FORMAT_NOMOR('SPL', C.KODE_SAMPEL) +'<div>'+ dbo.FORMAT_NOMOR('SPU',A.SPU_ID) +'<div>' AS [KODE SAMPEL <br> NOMOR SPU], dbo.FORMAT_NOMOR('SPK',B.SPK_ID) +'<div>'+ CONVERT(VARCHAR(10), B.TANGGAL, 120) +'</div>' AS [NOMOR & TANGGAL SPK], C.NAMA_SAMPEL +'<div>Komoditi : '+ dbo.KATEGORI(SUBSTRING(A.SPU_ID, 13,2)) +'</div>' AS [NAMA SAMPEL],CASE WHEN B.STATUS = '20201' THEN 'SPK Baru' ELSE D.NAMA_USER END AS [PENYELIA] FROM T_SPK B LEFT JOIN T_SPU A ON B.SPU_ID = A.SPU_ID LEFT JOIN T_M_SAMPEL C ON B.KODE_SAMPEL = C.KODE_SAMPEL  LEFT JOIN T_USER D ON B.KASIE = D.USER_ID WHERE B.BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND LEFT(CONVERT(VARCHAR, B.CREATE_DATE, 112), 4) = '".date("Y")."' AND SUBSTRING(CONVERT(VARCHAR, B.CREATE_DATE, 112),5,2) = '".date("m")."'";
			}
			$this->newtable->columns(array("B.SPK_ID", "A.SPU_ID", "A.NOMOR_SP", "C.KODE_SAMPEL", "C.PERIKSA_SAMPEL", "B.KASIE", "dbo.FORMAT_NOMOR('SPL', C.KODE_SAMPEL) +'<div>'+ dbo.FORMAT_NOMOR('SPU',A.SPU_ID) +'<div>'","dbo.FORMAT_NOMOR('SPK',B.SPK_ID) +'<div>'+ CONVERT(VARCHAR(10), B.TANGGAL, 120) +'</div>'","C.NAMA_SAMPEL +'<div>Komoditi : '+ dbo.KATEGORI(SUBSTRING(A.SPU_ID, 13,2)) +'</div>'","CASE WHEN B.STATUS = '20201' THEN 'SPK Baru' ELSE D.NAMA_USER END"));
			$this->newtable->width(array('KODE SAMPEL <br> NOMOR SPU' => 100, 'NOMOR & TANGGAL SPK' => 100, 'NAMA SAMPEL' => 250, 'PENYELIA' => 250));
			$proses['Detail Data SPK'] = array('GET', site_url().'/home/pengujian/spk/detil', '1');
			$proses['Hapus Data SPK'] = array('POST', site_url().'/post/spk/spk_act_admin/delete/ajax', '1');
			$this->newtable->action(site_url()."/home/tracking/spk");
			$this->newtable->cidb($this->db);
			$this->newtable->ciuri($this->uri->segment_array());
			$this->newtable->orderby(1);
			$this->newtable->sortby("ASC");
			$this->newtable->hiddens(array('SPK_ID','SPU_ID','NOMOR_SP','KODE_SAMPEL','PERIKSA_SAMPEL','KASIE'));
			$this->newtable->keys(array('SPK_ID','KODE_SAMPEL','KASIE'));
			$this->newtable->menu($proses);
			$this->newtable->show_search(FALSE);
			$tabel = $this->newtable->generate($query);
			$arrdata = array('table' => $tabel,
							 'search' => TRUE,
							 'frmsearch' => $sipt->main->_showformspk(site_url().'/home/cari/spk',$cari, $subcari),
							 'idjudul' => 'judulmsampel',
							 'caption_header' => 'Data Surat Perintah Kerja',
							 'batal' => '',
							 'cancel' => '');
			return $arrdata;
		}else{
			$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
		}
	}
	
	function tracking_spk($cari, $subcari){
		if(array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('10', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('9', $this->newsession->userdata('SESS_KODE_ROLE')) || $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$this->load->library('newtable');
			$uricari = explode("_",$cari);
			$urisubcari = explode("_",$subcari);
			if($this->newsession->userdata('SESS_BBPOM_ID') == "00"){
				$query =  "SELECT B.SPK_ID, A.SPU_ID, A.NOMOR_SP, C.KODE_SAMPEL, C.PERIKSA_SAMPEL, B.KASIE, dbo.FORMAT_NOMOR('SPL', C.KODE_SAMPEL) +'<div>'+ dbo.FORMAT_NOMOR('SPU',A.SPU_ID) +'<div>' AS [KODE SAMPEL <br> NOMOR SPU], dbo.FORMAT_NOMOR('SPK',B.SPK_ID) +'<div>'+ CONVERT(VARCHAR(10), B.TANGGAL, 120) +'</div>' AS [NOMOR & TANGGAL SPK], C.NAMA_SAMPEL +'<div>Komoditi : '+ dbo.KATEGORI(SUBSTRING(A.SPU_ID, 13,2)) +'</div>' AS [NAMA SAMPEL], CASE WHEN B.STATUS = '20201' THEN 'SPK Baru' ELSE D.NAMA_USER END AS [PENYELIA] FROM T_SPK B LEFT JOIN T_SPU A ON B.SPU_ID = A.SPU_ID LEFT JOIN T_M_SAMPEL C ON B.KODE_SAMPEL = C.KODE_SAMPEL LEFT JOIN T_USER D ON B.KASIE = D.USER_ID";
			}else{
				$query =  "SELECT B.SPK_ID, A.SPU_ID, A.NOMOR_SP, C.KODE_SAMPEL, C.PERIKSA_SAMPEL, B.KASIE, dbo.FORMAT_NOMOR('SPL', C.KODE_SAMPEL) +'<div>'+ dbo.FORMAT_NOMOR('SPU',A.SPU_ID) +'<div>' AS [KODE SAMPEL <br> NOMOR SPU], dbo.FORMAT_NOMOR('SPK',B.SPK_ID) +'<div>'+ CONVERT(VARCHAR(10), B.TANGGAL, 120) +'</div>' AS [NOMOR & TANGGAL SPK], C.NAMA_SAMPEL +'<div>Komoditi : '+ dbo.KATEGORI(SUBSTRING(A.SPU_ID, 13,2)) +'</div>' AS [NAMA SAMPEL],CASE WHEN B.STATUS = '20201' THEN 'SPK Baru' ELSE D.NAMA_USER END AS [PENYELIA] FROM T_SPK B LEFT JOIN T_SPU A ON B.SPU_ID = A.SPU_ID LEFT JOIN T_M_SAMPEL C ON B.KODE_SAMPEL = C.KODE_SAMPEL  LEFT JOIN T_USER D ON B.KASIE = D.USER_ID WHERE B.BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'";
			}
			if($uricari[0] != "ALL"){
				$query .= $sipt->main->find_where($query);
				$query .= " B.BBPOM_ID = '".$uricari[0]."'";
			}
			if($uricari[1] != "ALL"){
				$query .= $sipt->main->find_where($query);
				$query .= " B.KOMODITI = '".$uricari[1]."'";
			}
			if($uricari[2] != "ALL"){
				$query .= $sipt->main->find_where($query);
				$query .= " dbo.FORMAT_NOMOR('SPL',C.KODE_SAMPEL) LIKE '%".$uricari[2]."%'";
			}
			
			if($uricari[3] != "ALL"){
				$query .= $sipt->main->find_where($query);
				$query .= " dbo.FORMAT_NOMOR('SPU',B.SPU_ID) LIKE '%".$uricari[3]."%'";
			}
			
			if($urisubcari[0] != "ALL"){
				$query .= $sipt->main->find_where($query);
				$query .= " DATEDIFF(dy, 0, convert(DATETIME, B.TANGGAL, 105)) >= DATEDIFF(dy, 0, convert(DATETIME, '".$urisubcari[0]."', 105))"; 
			}
			if($urisubcari[1] != "ALL"){
				$query .= $sipt->main->find_where($query);
				$query .= " DATEDIFF(dy, 0, convert(DATETIME, B.TANGGAL, 105)) <= DATEDIFF(dy, 0, convert(DATETIME, '".$urisubcari[1]."', 105))";
			}
			if($urisubcari[2] != "ALL"){
				$query .= $sipt->main->find_where($query);
				$query .= " dbo.FORMAT_NOMOR('SPK',B.SPK_ID) LIKE '%".$urisubcari[2]."%'";
			}
			
			$this->newtable->columns(array("B.SPK_ID", "A.SPU_ID", "A.NOMOR_SP", "C.KODE_SAMPEL", "C.PERIKSA_SAMPEL", "B.KASIE","dbo.FORMAT_NOMOR('SPL', C.KODE_SAMPEL) +'<div>'+ dbo.FORMAT_NOMOR('SPU',A.SPU_ID) +'<div>'","dbo.FORMAT_NOMOR('SPK',B.SPK_ID) +'<div>'+ CONVERT(VARCHAR(10), B.TANGGAL, 120) +'</div>'","C.NAMA_SAMPEL +'<div>Komoditi : '+ dbo.KATEGORI(SUBSTRING(A.SPU_ID, 13,2)) +'</div>'","CASE WHEN B.STATUS = '20201' THEN 'SPK Baru' ELSE D.NAMA_USER END"));
			$this->newtable->width(array('KODE SAMPEL <br> NOMOR SPU' => 100, 'NOMOR & TANGGAL SPK' => 100, 'NAMA SAMPEL' => 250, 'PENYELIA' => 250));
			$proses['Detail Data SPK'] = array('GET', site_url().'/home/pengujian/spk/detil', '1');
			$proses['Hapus Data SPK'] = array('POST', site_url().'/post/spk/spk_act_admin/delete/ajax', '1');
			$this->newtable->action(site_url()."/home/cari/spk/".$cari."/".$subcari);
			$this->newtable->cidb($this->db);
			$this->newtable->ciuri($this->uri->segment_array());
			$this->newtable->orderby(1);
			$this->newtable->sortby("ASC");
			$this->newtable->hiddens(array('SPK_ID','SPU_ID','NOMOR_SP','KODE_SAMPEL','PERIKSA_SAMPEL','KASIE'));
			$this->newtable->keys(array('SPK_ID','KODE_SAMPEL','KASIE'));
			$this->newtable->menu($proses);
			$this->newtable->show_search(FALSE);
			$tabel = $this->newtable->generate($query);
			$arrdata = array('table' => $tabel,
							 'search' => TRUE,
							 'frmsearch' => $sipt->main->_showformspk(site_url().'/home/cari/spk',$cari, $subcari),
							 'idjudul' => 'judulmsampel',
							 'caption_header' => 'Data Surat Perintah Kerja',
							 'batal' => '',
							 'cancel' => '');
			return $arrdata;

		}else{
			$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
		}
	}
	
	function list_sps(){
		if(array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('10', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('9', $this->newsession->userdata('SESS_KODE_ROLE')) || $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$this->load->library('newtable');
			$this->newtable->search(array(array('', '')));
			if($this->newsession->userdata('SESS_BBPOM_ID') == "00"){
				$query = "SELECT A.SPU_ID, B.KODE_SAMPEL, B.USER_ID, REPLACE(REPLACE(D.NAMA_BBPOM, 'BALAI POM DI ', ''), 'BALAI BESAR POM DI ','') AS BBPOM, dbo.FORMAT_NOMOR('SPU', A.SPU_ID) AS [NOMOR SPU], CONVERT(VARCHAR(10), A.TANGGAL_PERINTAH, 120) AS TANGGAL, dbo.FORMAT_NOMOR('SPL', B.KODE_SAMPEL) AS [KODE SAMPEL], CASE WHEN LEN(B.USER_ID) > 0 THEN C.NAMA_USER ELSE 'Belum Di Disposisikan' END AS [MANAJER TEKNIS], CASE WHEN B.STATUS = '40201' THEN 'Pembuatan SPK' WHEN B.STATUS = '30201' THEN 'Terbit SPK' ELSE 'Belum Di Disposisikan' END AS [STATUS] FROM T_SAMPEL_MT B LEFT JOIN T_SPU A ON B.SPU_ID = A.SPU_ID LEFT JOIN T_USER C ON B.USER_ID = C.USER_ID LEFT JOIN M_BBPOM D ON A.BBPOM_ID = D.BBPOM_ID WHERE LEFT(CONVERT(VARCHAR, A.TANGGAL_PERINTAH, 112), 4) = '".date("Y")."' AND SUBSTRING(CONVERT(VARCHAR, A.TANGGAL_PERINTAH, 112),5,2) = '".date("m")."'";
			}else{
				$query = "SELECT A.SPU_ID, B.KODE_SAMPEL, B.USER_ID, REPLACE(REPLACE(D.NAMA_BBPOM, 'BALAI POM DI ', ''), 'BALAI BESAR POM DI ','') AS BBPOM, dbo.FORMAT_NOMOR('SPU', A.SPU_ID) AS [NOMOR SPU], CONVERT(VARCHAR(10), A.TANGGAL_PERINTAH, 120) AS TANGGAL, dbo.FORMAT_NOMOR('SPL', B.KODE_SAMPEL) AS [KODE SAMPEL], CASE WHEN LEN(B.USER_ID) > 0 THEN C.NAMA_USER ELSE 'Belum Di Disposisikan' END AS [MANAJER TEKNIS], CASE WHEN B.STATUS = '40201' THEN 'Pembuatan SPK' WHEN B.STATUS = '30201' THEN 'Terbit SPK' ELSE 'Belum Di Disposisikan' END AS [STATUS] FROM T_SAMPEL_MT B LEFT JOIN T_SPU A ON B.SPU_ID = A.SPU_ID LEFT JOIN T_USER C ON B.USER_ID = C.USER_ID LEFT JOIN M_BBPOM D ON A.BBPOM_ID = D.BBPOM_ID WHERE A.BBPOM_ID  = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND LEFT(CONVERT(VARCHAR, A.TANGGAL_PERINTAH, 112), 4) = '".date("Y")."' AND SUBSTRING(CONVERT(VARCHAR, A.TANGGAL_PERINTAH, 112),5,2) = '".date("m")."'";
			}
			$this->newtable->columns(array("A.SPU_ID", "B.KODE_SAMPEL", "B.USER_ID", "REPLACE(REPLACE(D.NAMA_BBPOM, 'BALAI POM DI ', ''), 'BALAI BESAR POM DI ','')", "dbo.FORMAT_NOMOR('SPU', A.SPU_ID) AS [NOMOR SPU]", "CONVERT(VARCHAR(10), A.TANGGAL_PERINTAH, 120)", "dbo.FORMAT_NOMOR('SPL', B.KODE_SAMPEL)", "CASE WHEN LEN(B.USER_ID) > 0 THEN C.NAMA_USER ELSE 'Belum Di Disposisikan'", "CASE WHEN B.STATUS = '40201' THEN 'Pembuatan SPK' WHEN B.STATUS = '30201' THEN 'Terbit SPK' ELSE 'Belum Di Disposisikan'"));
			$this->newtable->width(array('BBPOM' => 100, 'NOMOR SPU' => 100, 'TANGGAL PERINTAH' => 75,'KODE SAMPEL' => 80, 'MANAJER TEKNIS' => 250, 'STATUS' => 120));
			$proses['Detail Data SPU'] = array('GET', site_url()."/home/spu/detil", '1');
			$this->newtable->action(site_url()."/home/tracking/sps");
			$this->newtable->cidb($this->db);
			$this->newtable->ciuri($this->uri->segment_array());
			$this->newtable->orderby(5);
			$this->newtable->sortby("DESC");
			$this->newtable->hiddens(array('SPU_ID','KODE_SAMPEL','USER_ID'));
			$this->newtable->keys(array('SPU_ID','KODE_SAMPEL','USER_ID'));
			$this->newtable->menu($proses);
			$this->newtable->show_search(FALSE);
			$tabel = $this->newtable->generate($query);
			$arrdata = array('table' => $tabel,
							 'search' => TRUE,
							 'frmsearch' => $sipt->main->_showformsps(site_url().'/home/cari/sps',$cari, $subcari),
							 'idjudul' => 'judulmsampel',
							 'caption_header' => 'Data Surat Penyerahan Sampel',
							 'batal' => '',
							 'cancel' => '');
			return $arrdata;
		}else{
			$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
		}
	}
	
	function tracking_sps($cari, $subcari){
		if(array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('10', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('9', $this->newsession->userdata('SESS_KODE_ROLE')) || $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			return $arrdata;
		}else{
			$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
		}
	}
	
	#Transaksional Sampel
	function get_sps($kode){
		if(array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('10', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('9', $this->newsession->userdata('SESS_KODE_ROLE')) || $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$query = "SELECT dbo.FORMAT_NOMOR('SPU', A.SPU_ID) AS UR_SPU, dbo.FORMAT_NOMOR('SPS', B.NOMOR_SPS) AS UR_SPS, C.NAMA_USER AS [MT], CASE WHEN A.STATUS = '40201' THEN 'Pembuatan SPK' WHEN A.STATUS = '30201' THEN 'Terbit SPK' END AS UR_STATUS FROM T_SAMPEL_MT A LEFT JOIN T_SPU B ON A.SPU_ID = B.SPU_ID LEFT JOIN T_USER C ON A.USER_ID = C.USER_ID WHERE A.KODE_SAMPEL = '".$kode."'";
			$data = $sipt->main->get_result($query);
			if($data){
				foreach($query->result_array() as $row){
					$arrdata['sess'][] = $row;
				}
				return $arrdata;
			}
		}
	}
	
	function get_spk($kode){
		if(array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('10', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('9', $this->newsession->userdata('SESS_KODE_ROLE')) || $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$query = "SELECT dbo.FORMAT_NOMOR('SPK', A.SPK_ID) AS UR_SPK, CONVERT(VARCHAR(10), A.TANGGAL, 103) AS TGL_SPK, B.NAMA_USER AS MT, C.NAMA_USER AS PENYELIA, CASE WHEN SUBSTRING(A.SPK_ID, 13,1) = 'K' THEN 'SPK - Kimia' ELSE 'SPK - Mikro' END AS SPK_BIDANG FROM T_SPK A LEFT JOIN T_USER B ON A.CREATE_BY = B.USER_ID LEFT JOIN T_USER C ON A.KASIE = C.USER_ID WHERE A.KODE_SAMPEL = '".$kode."'";
			$data = $sipt->main->get_result($query);
			if($data){
				foreach($query->result_array() as $row){
					$arrdata['sess'][] = $row;
				}
				return $arrdata;
			}
		}
	}
	
	function get_spp($kode){
		if(array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('10', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('9', $this->newsession->userdata('SESS_KODE_ROLE')) || $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$query = "SELECT dbo.FORMAT_NOMOR('SPP', A.SPP_ID) AS UR_SPP, CONVERT(VARCHAR(10), A.TANGGAL, 103) AS TGL_SPP, B.NAMA_USER AS PENYELIA FROM T_SPP A LEFT JOIN T_USER B ON A.CREATE_BY = B.USER_ID LEFT JOIN T_SPK C ON A.SPK_ID = C.SPK_ID WHERE C.KODE_SAMPEL = '".$kode."'";
			$data = $sipt->main->get_result($query);
			if($data){
				foreach($query->result_array() as $row){
					$arrdata['sess'][] = $row;
				}
				return $arrdata;
			}
		}
	}
	
	function get_parameter($kode){
		if(array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('10', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('9', $this->newsession->userdata('SESS_KODE_ROLE')) || $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$query = "SELECT A.UJI_ID, A.KODE_SAMPEL, CASE WHEN A.JENIS_UJI = '01' THEN 'Mikrobiologi' WHEN A.JENIS_UJI = '02' THEN 'Kimia - Fisika' END AS JENIS_UJI, A.UJI_ID, A.SPK_ID, A.PARAMETER_UJI, A.METODE, A.PUSTAKA, A.SYARAT, A.RUANG_LINGKUP, A.HASIL, A.HASIL_KUALITATIF, A.LCP, A.HASIL_PARAMETER, B.NAMA_USER FROM T_PARAMETER_HASIL_UJI A LEFT JOIN T_USER B ON A.PENGUJI = B.USER_ID WHERE KODE_SAMPEL = '".$kode."'";
			$data = $sipt->main->get_result($query);
			if($data){
				foreach($query->result_array() as $row){
					$arrdata['sess'][] = $row;
				}
				return $arrdata;
			}
		}
	}
	
	function get_cp($kode){
		if(array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('10', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('9', $this->newsession->userdata('SESS_KODE_ROLE')) || $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$query = "SELECT dbo.FORMAT_NOMOR('LHU', D.LHU_ID) AS UR_LHU, A.HASIL, A.CATATAN, B.NAMA_USER AS 'PENYELIA', CONVERT(VARCHAR(10), A.CREATE_DATE, 105) AS TGL_CP, CONVERT(VARCHAR(10), A.PEJABAT_TANGGAL, 105) AS TGL_MT, C.NAMA_USER AS 'MANAJER' FROM T_CP A LEFT JOIN T_USER B ON A.CREATE_BY = B.USER_ID LEFT JOIN T_USER C ON A.MT = C.USER_ID LEFT JOIN T_LHU D ON A.CP_ID = D.CP_ID WHERE A.KODE_SAMPEL = '".$kode."'"; 
			$data = $sipt->main->get_result($query);
			if($data){
				foreach($query->result_array() as $row){
					$arrdata['sess'][] = $row;
				}
				return $arrdata;
			}
		}
	}
	
	#End Transakional Sampel
	
}
?>