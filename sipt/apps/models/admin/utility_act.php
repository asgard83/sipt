<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);

class Utility_act extends Model{
	
	function log_aktivitas(){
		if($this->newsession->userdata('LOGGED_IN') && array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('10', $this->newsession->userdata('SESS_KODE_ROLE'))){
			$this->load->library('newtable');
			$this->newtable->hiddens(array('ID','WAKTU'));
			$this->newtable->action(site_url()."/home/utility/log");
			$this->newtable->search(array(array('A.NAMA_USER', 'Berdasarkan Nama Pengguna'), array('B.NAMA_BBPOM', 'Berdasarkan Badan / Balai POM'), array('C.KEGIATAN', 'Berdasarkan Kegiatan')));
			$this->newtable->cidb($this->db);
			$this->newtable->ciuri($this->uri->segment_array());
			$this->newtable->orderby(5);
			$this->newtable->sortby("DESC");
			$this->newtable->keys(array('ID'));
			$proses['Hapus Data Log'] = array('POST',site_url().'/post/utility/set_log/delete/ajax','N');
			$this->newtable->menu($proses);
			$query = "SELECT C.ID, A.NAMA_USER +'<div>'+B.NAMA_BBPOM+'</div>'AS [PENGGUNA], C.KEGIATAN, dbo.HISTORI_LOG_USER(C.ID) AS [WAKTU TERAKHIR], C.WAKTU, C.IP_ADDRESS AS [IP ADDRESS] FROM T_USER_LOG C LEFT JOIN T_USER A ON C.USER_ID = A.USER_ID LEFT JOIN M_BBPOM B ON A.BBPOM_ID = B.BBPOM_ID WHERE C.USER_ID IS NOT NULL";			
			$this->newtable->width(array('PENGGUNA' => 200 ,'KEGIATAN' => 350, 'WAKTU TERAKHIR' => 150, 'IP ADDRESS' => 50));
			$this->newtable->columns(array("C.ID","A.NAMA_USER +'<div>'+B.NAMA_BBPOM+'</div>'","C.KEGIATAN","dbo.HISTORI_LOG_USER(C.ID)","C.WAKTU","C.IP_ADDRESS"));
			$tabel = $this->newtable->generate($query);
			$arrdata = array('table' => $tabel,
							 'idjudul' => 'judulpetugas',
							 'caption_header' => 'Monitoring Aktifitas Petugas SIPT',
							 'batal' => '',
							 'cancel' => '');
			return $arrdata;
		}else{
			$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
		}
	}
	
	function list_news(){
		if($this->newsession->userdata('LOGGED_IN')){
			$this->load->library('newtable');
			$this->newtable->hiddens(array('NEWS_ID','CREATE_DATE'));
			$this->newtable->action(site_url()."/home/utility/news");
			$this->newtable->search(array(array('A.JUDUL', 'Berdasarkan Judul Update'), array('B.HEADLINE', 'Berdasarkan Headline')));
			$this->newtable->cidb($this->db);
			$this->newtable->ciuri($this->uri->segment_array());
			$this->newtable->orderby(5);
			$this->newtable->sortby("DESC");
			$this->newtable->keys(array('NEWS_ID'));
			if(array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('10', $this->newsession->userdata('SESS_KODE_ROLE'))){
				$proses['Tambah Data Berita'] = array('GET',site_url().'/home/utility/news/new','0');
				$proses['Edit Data Berita'] = array('GET',site_url().'/home/utility/news/new','1');
				$proses['Hapus Data Berita'] = array('POST',site_url().'/post/utility/set_news/delete/ajax','N');
				$proses['View Berita'] = array('GET',site_url().'/home/berita','1');
			}
			$proses['View Berita'] = array('GET',site_url().'/home/berita','1');
			$this->newtable->menu($proses);
			$query = "SELECT A.NEWS_ID, A.JUDUL, A.HEADLINE, B.NAMA_USER AS [UPDATE BY], A.CREATE_DATE FROM T_NEWS_UPDATE A LEFT JOIN T_USER B ON A.CREATE_BY = B.USER_ID";			
			$this->newtable->width(array('JUDUL' => 200 ,'HEADLINE' => 350, 'UPDATE BY' => 150));
			$this->newtable->columns(array("A.NEWS_ID","A.JUDUL","A.HEADLINE","B.NAMA_USER","A.CREATE_DATE"));
			$tabel = $this->newtable->generate($query);
			$arrdata = array('table' => $tabel,
							 'idjudul' => '',
							 'caption_header' => 'Daftar Update Aplikasi',
							 'batal' => '',
							 'cancel' => '');
			return $arrdata;			
		}else{
			$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
		}
	}
	
	
	function get_news($id,$prev){
		if($this->newsession->userdata('LOGGED_IN') && array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('10', $this->newsession->userdata('SESS_KODE_ROLE'))){
			$sipt = get_instance();
			$sipt->load->model("main","main", true);
			$arrdata = array('act' => site_url().'/post/utility/set_news/save/');
			if($id!=""){
				$query = "SELECT NEWS_ID, JUDUL, HEADLINE, KONTEN FROM T_NEWS_UPDATE WHERE NEWS_ID = '".$id."'";
				$data = $sipt->main->get_result($query);
				if($data){
					foreach($query->result_array() as $row){
						$arrdata = array('act' => site_url().'/post/utility/set_news/update/',
										 'sess' => $row);
					}
				}
			}
			$arrdata['urlback'] = site_url().'/home/utility/news';
			return $arrdata;
		}else{
			$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
		}
	}

	function preview_news($id){
		if($this->newsession->userdata('LOGGED_IN')){
			$sipt = get_instance();
			$sipt->load->model("main","main", true);
			$query = "SELECT NEWS_ID, JUDUL, HEADLINE, KONTEN FROM T_NEWS_UPDATE WHERE NEWS_ID = '".$id."'";
			$data = $sipt->main->get_result($query);
			if($data){
				foreach($query->result_array() as $row){
					$arrdata = array('sess' => $row);
				}
			}
			return $arrdata;
		}else{
			$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
		}
	}

	
	function set_news($action, $isajax){
		if($this->newsession->userdata('LOGGED_IN') && array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('10', $this->newsession->userdata('SESS_KODE_ROLE'))){
			$sipt = get_instance();
			$sipt->load->model("main","main", true);
			if($action=="save"){
				$ret = "MSG#NO#Data gagal disimpan";
				$newsid = (int)$sipt->main->get_uraian("SELECT MAX(NEWS_ID) AS MAXI FROM T_NEWS_UPDATE","MAXI") + 1;
				$arr_news = array('NEWS_ID' => $newsid,
								  'CREATE_DATE' => 'GETDATE()',
								  'CREATE_BY' => $this->newsession->userdata('SESS_USER_ID'));
				foreach($this->input->post('NEWS') as $a => $b){
					$arr_news[$a] = $b;
				}	
				if($this->db->insert('T_NEWS_UPDATE', $arr_news)) $ret = "MSG#YES#Data berhasil disimpan#".site_url().'/home/utility/news';
				if($isajax!="ajax"){
					redirect(base_url());
					exit();
				}
				return $ret;
			}else if($action=="update"){
				$ret = "MSG#NO#Data gagal disimpan";
				foreach($this->input->post('NEWS') as $a => $b){
					$arr_news[$a] = $b;
				}
				$this->db->where('NEWS_ID', $this->input->post('NEWS_ID'));	
				if($this->db->update('T_NEWS_UPDATE', $arr_news)) $ret = "MSG#YES#Data berhasil disimpan#".site_url().'/home/utility/news';
				if($isajax!="ajax"){
					redirect(base_url());
					exit();
				}
				return $ret;
			}else if($action=="delete"){
				$ret = "MSG#Petugas Gagal di Hapus.";
				foreach($this->input->post('tb_chk') as $a){
					$this->db->where('NEWS_ID', $a);
					if($this->db->delete('T_NEWS_UPDATE')) $ret = "MSG#Data berita berhasil dihapus#".site_url()."/home/utility/news"; 
				}
				if($isajax!="ajax"){
					redirect(base_url());
					exit();
				}
				return $ret;	
			}
		}
	}
	
	function list_faq($stts){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$this->load->library('newtable');
			if($stts == "draft"){
				if($this->newsession->userdata('SESS_BBPOM_ID') == "00")
				#$query = "SELECT A.FAQ_ID, UPPER(A.SUBJEK) AS SUBJEK, B.URAIAN +'<div>By : '+C.NAMA_USER+'</div><div>'+CONVERT(VARCHAR(10), A.CREATE_DATE, 103)+'</div>' AS [KLASIFIKASI], A.KEY_TAGS AS [KATA KUNCI] FROM T_FAQ A LEFT JOIN M_REFERENSI_FAQ B ON A.REF_FAQ = B.KODE LEFT JOIN T_USER C ON A.CREATE_BY = C.USER_ID WHERE A.STATUS = '0'";
				$query = "SELECT A.FAQ_ID, CAST(A.FAQ_ID AS VARCHAR) AS [NO FAQ],UPPER(A.SUBJEK) AS SUBJEK, B.URAIAN AS KLASIFIKASI, C.NAMA_USER AS [SUMBER], CONVERT(VARCHAR(10), A.CREATE_DATE, 120) AS [TANGGAL FAQ], A.KEY_TAGS AS [KATA KUNCI] FROM T_FAQ A LEFT JOIN M_REFERENSI_FAQ B ON A.REF_FAQ = B.KODE LEFT JOIN T_USER C ON A.CREATE_BY = C.USER_ID WHERE A.STATUS = '0'";
				else
				#$query = "SELECT A.FAQ_ID, UPPER(A.SUBJEK) AS SUBJEK, B.URAIAN +'<div>By : '+C.NAMA_USER+'</div><div>'+CONVERT(VARCHAR(10), A.CREATE_DATE, 103)+'</div>' AS [KLASIFIKASI], A.KEY_TAGS AS [KATA KUNCI] FROM T_FAQ A LEFT JOIN M_REFERENSI_FAQ B ON A.REF_FAQ = B.KODE LEFT JOIN T_USER C ON A.CREATE_BY = C.USER_ID WHERE A.STATUS = '0' AND A.CREATE_BY = '".$this->newsession->userdata('SESS_USER_ID')."'";
				$query = "SELECT A.FAQ_ID, CAST(A.FAQ_ID AS VARCHAR) AS [NO FAQ],UPPER(A.SUBJEK) AS SUBJEK, B.URAIAN AS KLASIFIKASI, C.NAMA_USER AS [SUMBER], CONVERT(VARCHAR(10), A.CREATE_DATE, 120) AS [TANGGAL FAQ], A.KEY_TAGS AS [KATA KUNCI] FROM T_FAQ A LEFT JOIN M_REFERENSI_FAQ B ON A.REF_FAQ = B.KODE LEFT JOIN T_USER C ON A.CREATE_BY = C.USER_ID WHERE A.STATUS = '0' AND A.CREATE_BY = '".$this->newsession->userdata('SESS_USER_ID')."'";

				$proses['Tambah FAQ'] = array('GET', site_url()."/home/utility/faq/new", '0');
				$proses['Edit FAQ'] = array('GET', site_url()."/home/utility/faq/new", '1');
				$proses['Hapus FAQ'] = array('POST', site_url()."/post/utility/set_faq/delete/ajax", '1');
				if(in_array('1', $this->newsession->userdata('SESS_KODE_ROLE'))){
					$proses['Publish FAQ'] = array('POST', site_url()."/post/utility/set_faq/publish/ajax", '1');
				}
				$this->newtable->menu($proses);
				$this->newtable->columns(array("A.FAQ_ID","CAST(A.FAQ_ID AS VARCHAR)",array("UPPER(A.SUBJEK)",site_url().'/home/utility/faq/new/{FAQ_ID}'),"B.URAIAN","C.NAMA_USER", "CONVERT(VARCHAR(10), A.CREATE_DATE, 120)"));
				$this->newtable->width(array('NO FAQ' => 10,'SUBJEK' => 175,'KLASIFIKASI' => 150, 'SUMBER' => 100, 'TANGGAL FAQ' => 100, 'KATA KUNCI' => 100));
			}else if($stts == "unpublish" && in_array('1', $this->newsession->userdata('SESS_KODE_ROLE'))){
				$query = "SELECT A.FAQ_ID, CAST(A.FAQ_ID AS VARCHAR) AS [NO FAQ],UPPER(A.SUBJEK) AS SUBJEK, B.URAIAN AS KLASIFIKASI, C.NAMA_USER AS [SUMBER], CONVERT(VARCHAR(10), A.CREATE_DATE, 120) AS [TANGGAL FAQ], A.KEY_TAGS AS [KATA KUNCI] FROM T_FAQ A LEFT JOIN M_REFERENSI_FAQ B ON A.REF_FAQ = B.KODE LEFT JOIN T_USER C ON A.CREATE_BY = C.USER_ID WHERE A.STATUS = '2'";
				$this->newtable->columns(array("A.FAQ_ID","CAST(A.FAQ_ID AS VARCHAR)",array("UPPER(A.SUBJEK)",site_url().'/home/utility/faq/new/{FAQ_ID}'),"B.URAIAN","C.NAMA_USER", "CONVERT(VARCHAR(10), A.CREATE_DATE, 120)"));
				$this->newtable->width(array('NO FAQ' => 10,'SUBJEK' => 175,'KLASIFIKASI' => 150, 'SUMBER' => 100, 'TANGGAL FAQ' => 100, 'KATA KUNCI' => 100));
				$proses['Publish FAQ'] = array('POST', site_url()."/post/utility/set_faq/publish/ajax", '1');
				$this->newtable->menu($proses);
			}else if($stts == "publish"){
				$query = "SELECT A.FAQ_ID, CAST(A.FAQ_ID AS VARCHAR) AS [NO FAQ],UPPER(A.SUBJEK) AS SUBJEK, B.URAIAN AS KLASIFIKASI, C.NAMA_USER AS [SUMBER], CONVERT(VARCHAR(10), A.CREATE_DATE, 120) AS [TANGGAL FAQ], A.KEY_TAGS AS [KATA KUNCI] FROM T_FAQ A LEFT JOIN M_REFERENSI_FAQ B ON A.REF_FAQ = B.KODE LEFT JOIN T_USER C ON A.CREATE_BY = C.USER_ID WHERE A.STATUS = '1'";
				$this->newtable->columns(array("A.FAQ_ID","CAST(A.FAQ_ID AS VARCHAR)",array("UPPER(A.SUBJEK)",site_url().'/home/utility/faq/new/{FAQ_ID}'),"B.URAIAN","C.NAMA_USER", "CONVERT(VARCHAR(10), A.CREATE_DATE, 120)"));
				$this->newtable->width(array('NO FAQ' => 10,'SUBJEK' => 175,'KLASIFIKASI' => 150, 'SUMBER' => 100, 'TANGGAL FAQ' => 100, 'KATA KUNCI' => 100));
				if(in_array('1', $this->newsession->userdata('SESS_KODE_ROLE'))){
					$proses['Unpublish FAQ'] = array('POST', site_url()."/post/utility/set_faq/unpublish/ajax", '1');
					$this->newtable->show_chk(TRUE);
					$this->newtable->menu($proses);
				}else{
					$this->newtable->show_chk(FALSE);
				}
			}else if($stts == "reference" && array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE'))){
				  $query = "SELECT A.KODE, B.URAIAN AS [KLASIFIKASI REFERENSI], A.URAIAN AS [KETERANGAN KLASIFIKASI] FROM M_REFERENSI_FAQ A LEFT JOIN M_TABEL B ON A.JENIS = B.KODE WHERE B.JENIS = 'JENIS_PELAPORAN'";
				  $this->newtable->columns(array("B.URAIAN","A.URAIAN"));
				  $proses['Tambah Referensi'] = array('GET', site_url()."/home/utility/reference/new", '0');
				  $proses['Edit Referensi'] = array('GET', site_url()."/home/utility/reference/new", '1');
				  $proses['Hapus Referensi'] = array('POST', site_url()."/post/utility/set_reference/delete/ajax", '1');
				  $this->newtable->menu($proses);
			}
			if($stts != "reference"){
				$this->newtable->hiddens(array('FAQ_ID'));
				$this->newtable->search(array(array('A.FAQ_ID', 'Berdasarkan Nomor FAQ'), array('A.SUBJEK', 'Berdasarkan Subjek'), array('A.PERTANYAAN', 'Berdasarkan Pertanyaan'), array('A.JAWABAN', 'Berdasarkan Jawaban'), array('A.KEY_TAGS', 'Berdasarkan Kata Kunci'),array('CONVERT(VARCHAR(10), A.CREATE_DATE, 120)', 'Berdasarkan Tanggal FAQ')));
				$this->newtable->orderby(1);
				$this->newtable->sortby("ASC");
				$this->newtable->keys(array('FAQ_ID'));
				$caption = "Draft FAQ";
			}else{
				$this->newtable->hiddens(array('KODE'));
				$this->newtable->width(array('KLASIFIKASI REFERENSI' => 175, 'KETERANGAN' => 450));
				$this->newtable->search(array(array('B.URAIAN', 'Berdasarkan Jenis Referensi'), array('A.URAIAN', 'Berdasarkan Uraian Referensi')));
				$this->newtable->orderby(2);
				$this->newtable->sortby("ASC");
				$this->newtable->keys(array('KODE'));
				$caption = "Referensi FAQ";
			}
			
			$this->newtable->action(site_url()."/home/utility/faq/$stts");
			$this->newtable->cidb($this->db);
			$this->newtable->ciuri($this->uri->segment_array());
			$this->newtable->show_search(TRUE);
			$tabel = $this->newtable->generate($query);
			$arrdata = array('table' => $tabel,
							 'idjudul' => '',
							 'caption_header' => 'Draft FAQ',
							 'batal' => '',
							 'cancel' => '');
			return $arrdata;
		}else{
			$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
		}
	}
	
	function get_faq($id,$prev){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$faq =& get_instance();
			$this->load->model("main", "main", true);
			$arrdata = array('act' => site_url().'/post/utility/set_faq/save/','save' => 'Simpan', 'prev' => FALSE);
			if($id!=""){
				$query = "SELECT A.*, B.URAIAN FROM T_FAQ A LEFT JOIN M_REFERENSI_FAQ B ON A.REF_FAQ = B.KODE WHERE A.FAQ_ID = '".$id."'";
				$data = $faq->main->get_result($query);
				if($data){
					foreach($query->result_array() as $row){
						$arrdata = array('sess' => $row);
					}
					$arrdata['id'] = $row['FAQ_ID'];
				}
				$arrdata['act'] = site_url().'/post/utility/set_faq/update/';
				$arrdata['save'] = 'Update';
			}
			$stts = $row['STATUS'];
			if($stts == "0"){
				$redir = "draft";
				$arrdata['prev'] = FALSE;
			}else if($stts == "1"){
				$redir = "publish";
				$arrdata['prev'] = TRUE;
			}else if($stts == "2"){
				$redir = "unpublish";
				$arrdata['prev'] = FALSE;
			}else{
				$redir = "draft";
			}
			$arrdata['ref'] = $faq->main->combobox("SELECT KODE, URAIAN FROM M_REFERENSI_FAQ","KODE","URAIAN",TRUE);
			if($prev){
				$arrdata['back'] = site_url().'/home/utility/faq/'.$redir;
				$arrdata['cancel'] = 'Kembali';
			}else{
				$arrdata['back'] = site_url().'/home/utility/faq/'.$redir;
				$arrdata['cancel'] = 'Batal';
			}
			return $arrdata;
		}
		redirect(base_url());
		exit();
	}
	
	function set_faq($action="", $isajax=""){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$faq =& get_instance();
			$this->load->model("main", "main", true);
			if($action=="save"){#Insert
				$ret = "MSG#NO#Simpan FAQ Gagal";
				$id = (int)$faq->main->get_uraian("SELECT MAX(FAQ_ID) AS FAQ_ID FROM T_FAQ","FAQ_ID") + 1;
				$arr_faq = array('FAQ_ID' => $id,
								 'CREATE_BY' => $this->newsession->userdata('SESS_USER_ID'),
								 'CREATE_DATE' => 'GETDATE()',
								 'STATUS' => '0');
				foreach($this->input->post('FAQ') as $a => $z){
					$arr_faq[$a] = $z;
					#$arr_faq[$a] = preg_replace('/[^(\x20-\x7F)]*/','',$z);
				}
				if($this->db->insert('T_FAQ', $arr_faq)){
					$ret = "MSG#YES#Simpan FAQ Berhasil#".site_url().'/home/utility/faq/draft';
				}else{
					$ret = "MSG#NO#Simpan FAQ Gagal.";
				}
				if($isajax!="ajax"){
					redirect(site_url());
					exit();
				}
				return $ret;
			}else if($action=="update"){#Update
				$ret = "MSG#NO#Edit FAQ Gagal";
				foreach($this->input->post('FAQ') as $a => $z){
					$arr_faq[$a] = $z;
					#$arr_faq[$a] = preg_replace('/[^(\x20-\x7F)]*/','',$z);
				}
				$id = $this->input->post('FAQ_ID');
				$this->db->where('FAQ_ID', $id);
				if($this->db->update('T_FAQ', $arr_faq)){
					$ret = "MSG#YES#Edit data FAQ berhasil disimpan#".site_url().'/home/utility/faq/draft';
				}else{
					$ret = "MSG#NO#Edit data FAQ gagal disimpan#";
				}
				if($isajax!="ajax"){
					redirect(site_url());
					exit();
				}
				return $ret;
			}else if($action=="delete"){#Delete 
				$ret = "MSG#Hapus FAQ gagal.";
				foreach($this->input->post('tb_chk') as $chkitem){
					$this->db->where(array("FAQ_ID" => $chkitem));
					if($this->db->delete('T_FAQ')) $ret = "MSG#Hapus FAQ berhasil.#";
				}
				if($isajax!="ajax"){
					redirect(base_url());
					exit();			  
				}
				return $ret;
			}else if($action=="publish"){#Publish
				$ret = "MSG#Publish FAQ gagal.";
				foreach($this->input->post('tb_chk') as $chkitem){
					$this->db->where(array("FAQ_ID" => $chkitem));
					if($this->db->update('T_FAQ', array('STATUS' => '1'))) $ret = "MSG#Publish FAQ berhasil.#";
				}
				if($isajax!="ajax"){
					redirect(base_url());
					exit();			  
				}
				return $ret;
			}else if($action=="unpublish"){#Unpublish
				$ret = "MSG#Unpublish FAQ gagal.";
				foreach($this->input->post('tb_chk') as $chkitem){
					$this->db->where(array("FAQ_ID" => $chkitem));
					if($this->db->update('T_FAQ', array('STATUS' => '2'))) $ret = "MSG#Unpublish FAQ berhasil.#";
				}
				if($isajax!="ajax"){
					redirect(base_url());
					exit();			  
				}
				return $ret;
			}
		}
	}

	function get_reference($id){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE && array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE'))){
			$faq =& get_instance();
			$this->load->model("main", "main", true);
			$arrdata = array('act' => site_url().'/post/utility/set_reference/save/','save' => 'Simpan');
			if($id!=""){
				$query = "SELECT * FROM M_REFERENSI_FAQ WHERE KODE = '".$id."'";
				$data = $faq->main->get_result($query);
				if($data){
					foreach($query->result_array() as $row){
						$arrdata = array('sess' => $row);
					}
					$arrdata['kode'] = $row['KODE'];
				}
				$arrdata['act'] = site_url().'/post/utility/set_reference/update/';
				$arrdata['save'] = 'Update';
			}
			$arrdata['pelaporan'] = $faq->main->referensi("JENIS_PELAPORAN","'04','01','02','03'",FALSE,TRUE);
			$arrdata['back'] = site_url().'/home/utility/reference';
			$arrdata['cancel'] = 'Batal';
			return $arrdata;
		}
		redirect(base_url());
		exit();
	}

	function set_reference($action="", $isajax=""){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE && array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE'))){
			$faq =& get_instance();
			$this->load->model("main", "main", true);
			if($action=="save"){#Insert
				$ret = "MSG#NO#Simpan Referensi Gagal";
				$kode = (int)$faq->main->get_uraian("SELECT MAX(KODE) AS KODE FROM M_REFERENSI_FAQ","KODE") + 1;
				$arr_reference = array('KODE' => $kode);
				foreach($this->input->post('REFERENCE') as $a => $z){
					$arr_reference[$a] = $z;
				}
				$arr_reference['JENIS'] = str_replace(" ","_",$arr_reference['JENIS']);
				if($this->db->insert('M_REFERENSI_FAQ', $arr_reference)){
					$ret = "MSG#YES#Simpan Referensi Berhasil#".site_url().'/home/utility/faq/reference';
				}else{
					$ret = "MSG#NO#Simpan Referensi Gagal#".site_url().'/home/utility/faq/reference';
				}
				if($isajax!="ajax"){
					redirect(site_url());
					exit();
				}
				return $ret;
			}else if($action=="update"){#Update
				$ret = "MSG#NO#Edit Referensi Gagal";
				foreach($this->input->post('REFERENCE') as $a => $z){
					$arr_reference[$a] = $z;
				}
				$kode = $this->input->post('KODE');
				$this->db->where('KODE', $kode);
				if($this->db->update('M_REFERENSI_FAQ', $arr_reference)){
					$ret = "MSG#YES#Edit data referensi berhasil disimpan#".site_url().'/home/utility/faq/reference';
				}else{
					$ret = "MSG#NO#Edit data referensi gagal disimpan#";
				}
				if($isajax!="ajax"){
					redirect(site_url());
					exit();
				}
				return $ret;
			}else if($action=="delete"){#Delete
				$ret = "MSG#Hapus referensi gagal.";
				foreach($this->input->post('tb_chk') as $chkitem){
					$this->db->where(array("KODE" => $chkitem));
					if($this->db->delete('M_REFERENSI_FAQ')) $ret = "MSG#Hapus referensi berhasil.#";
				}
				if($isajax!="ajax"){
					redirect(base_url());
					exit();			  
				}
				return $ret;
			}
		}
	}
	
	function ws_logsinkronisasi(){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE && array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE'))){
			$this->load->library('newtable');
			$this->newtable->hiddens(array('USER_ID','SERI'));
			$this->newtable->action(site_url()."/home/utility/wslog");
			$this->newtable->search(array(array('B.NAMA_USER', 'Berdasarkan Nama Pengguna'), array('C.NAMA_BBPOM', 'Berdasarkan Badan / Balai POM'), array('A.KETERANGAN', 'Berdasarkan Kegiatan')));
			//$this->newtable->show_search(FALSE);
			$this->newtable->cidb($this->db);
			$this->newtable->ciuri($this->uri->segment_array());
			$this->newtable->orderby(5);
			$this->newtable->sortby("DESC");
			$this->newtable->keys(array('USER_ID','SERI'));
			$proses['Hapus Data Log'] = array('POST',site_url().'/post/utility/set_log/delete/ajax','N');
			$this->newtable->menu($proses);
			$query = "SELECT A.USER_ID, A.SERI, B.NAMA_USER + '<div>' + REPLACE(REPLACE(C.NAMA_BBPOM,'BALAI BESAR POM', 'BBPOM'),'BALAI POM','BPOM') + '</div>' AS PENGGUNA,
					  A.KETERANGAN + '<div>IP : ' + A.IP_ADDRESS + '</div>' AS KEGIATAN, CONVERT(VARCHAR(10), A.CREATE_DATE, 120) + '<div>' +
					  CONVERT(VARCHAR(8), A.CREATE_DATE, 108) + '</div>' AS WAKTU, A.FL AS [FILE DOWNLOAD], A.STATUS 
					  FROM T_SINKRONISASI_LOG A LEFT JOIN T_USER B ON A.USER_ID = B.USER_ID
					  LEFT JOIN M_BBPOM C ON B.BBPOM_ID = C.BBPOM_ID";			
			$this->newtable->width(array('PENGGUNA' => 200 ,'KEGIATAN' => 350, 'WAKTU' => 75, 'STATUS' => 50));
			$this->newtable->columns(array("A.USER_ID","A.SERI", "B.NAMA_USER + '<div>' + REPLACE(REPLACE(C.NAMA_BBPOM,'BALAI BESAR POM', 'BBPOM'),'BALAI POM','BPOM') + '</div>'","A.KETERANGAN + '<div>IP : ' + A.IP_ADDRESS + '</div>'","CONVERT(VARCHAR(10), A.CREATE_DATE, 120) + '<div>' + CONVERT(VARCHAR(8), A.CREATE_DATE, 108) + '</div>'","A.FL","A.STATUS"));
			$tabel = $this->newtable->generate($query);
			$arrdata = array('table' => $tabel,
							 'idjudul' => 'judulpetugas',
							 'caption_header' => 'Monitoring WS Log Sinkronisasi Modul Offline',
							 'batal' => '',
							 'cancel' => '');
			return $arrdata;
		}
	}
	

	function chart_pemeriksaan($periode){
		if($this->newsession->userdata('LOGGED_IN') && array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('10', $this->newsession->userdata('SESS_KODE_ROLE'))){
			$sipt = get_instance();
			$sipt->load->model("main","main", true);
			$tgl = $this->weekend();
			$filter = "";
			$top = "";
			if($periode=="week"){
				$filter = "AND B.AWAL_PERIKSA BETWEEN '".$tgl['awal']."' AND '".$tgl['akhir']."'";
				$judul = "TOP 10 Pemeriksaan Periode Minggu Ini";
				$top = "TOP 10";
			}else if($periode=="month"){
				$filter = "AND B.AWAL_PERIKSA BETWEEN '".date('m-01-Y')."' AND '".date('m-t-Y')."'";
				$judul = "TOP 10 Pemeriksaan Periode Bulan Ini";
				$top = "TOP 10";
			}else if($periode=="year"){
				$filter = "AND YEAR(B.AWAL_PERIKSA) = '".date('Y')."'";
				$judul = "TOP 10 Pemeriksaan Periode Tahun Ini";
				$top = "TOP 10";
			}else if($periode=="all"){
				$filter = "";
				$judul = "Rekapitulasi Semua Pemeriksaan Sarana";
			}
			$query = "SELECT $top REPLACE(REPLACE(A.NAMA_BBPOM,'BALAI BESAR POM', 'BBPOM'),'BALAI POM','BPOM') 
AS NAMA_BBPOM, COUNT(B.BBPOM_ID) AS JUMLAH, A.BBPOM_ID FROM T_PEMERIKSAAN B LEFT JOIN M_BBPOM A ON B.BBPOM_ID = A.BBPOM_ID WHERE B.STATUS NOT IN ('00') AND A.BBPOM_ID NOT IN ('00','99') $filter GROUP BY NAMA_BBPOM, A.BBPOM_ID ORDER BY 2 DESC";			  
			$data = $sipt->main->get_result($query);
			$ret = "";
			$tbl = "";
			if($data){
				if($query->num_rows()>0){
					if($top==""){
						$tbl = "<hr><table class=\"chart_tabel\" style=\"width:400px;\" align=\"center\">";
						$tbl .= "<thead><tr><th colspan=\"3\"><b>".$judul."</b></th></tr></thead>";
					}else{
						$tbl = "<table class=\"chart_tabel\">";
						$tbl .= "<thead><tr><th colspan=\"3\"><b>".$judul."</b></th></tr></thead>";
					}
					$i = 0;
					$no = 0;
					foreach($query->result_array() as $row){
						$no = $no + 1;
						if($periode=="week"){
							$tgawal = explode("/",$tgl['awal']);
							$tgawalz = $tgawal[1]."-".$tgawal[0]."-".$tgawal[2];
							$tgakhir = explode("/",$tgl['akhir']);
							$tgakhirz = $tgakhir[1]."-".$tgakhir[0]."-".$tgakhir[2];
							$link = site_url()."/home/cari/pemeriksaan/ALL/ALL/ALL/".$row['BBPOM_ID']."/".$tgawalz."/".$tgakhirz."/ALL/ALL/ALL";
						}else if($periode=="month"){
							$awbulan = explode("-",date('m-01-Y'));
							$awblnz = $awbulan[1]."-".$awbulan[0]."-".$awbulan[2];
							$akbulan = explode("-",date('m-t-Y'));
							$akblnz= $akbulan[1]."-".$akbulan[0]."-".$akbulan[2];
							$link = site_url()."/home/cari/pemeriksaan/ALL/ALL/ALL/".$row['BBPOM_ID']."/".$awblnz."/".$akblnz."/ALL/ALL/ALL";
						}else if($periode=="year"){
							$year = explode("|",$this->yearz());
							$link = site_url()."/home/cari/pemeriksaan/ALL/ALL/ALL/".$row['BBPOM_ID']."/".$year[0]."/".$year[1]."/ALL/ALL/ALL/ALL";
						}else if($periode=="all"){
							$link = site_url()."/home/cari/pemeriksaan/ALL/ALL/ALL/".$row['BBPOM_ID']."/ALL/ALL/ALL/ALL/ALL/ALL";
						}else{
							$link = "#";
						}
						if($i%2>0) $cls = 'class="odd"';
						else $cls = "";
						$ret .= $row['NAMA_BBPOM'].";".$row['JUMLAH']."|";
						$tbl .= "<tr><td width=\"10\" ".$cls.">".$no."</td><td width=\"200\" ".$cls."><a href=\"".$link."\">".$row['NAMA_BBPOM']."</a></td><td ".$cls." align=\"right\">".$row['JUMLAH']."</td></tr>";
						$i++;
					}
					$tbl .= "</table>";
				}
			}
			if($top=="") return $tbl;
			else return $ret.$tbl;
		}		
	}

	function chart_komoditi(){
		$sipt = get_instance();
		$sipt->load->model("main","main", true);
		
		if(in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))){
			$klas = "'".join("','", $this->newsession->userdata('SESS_KLASIFIKASI_ID'))."'";
			$where = " WHERE A.STATUS NOT IN ('00') AND B.KK_ID IN ($klas) ";
			$judul = "Pemeriksaan Komoditi Seluruh Balai Besar / Balai POM";
		}else if(!in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')) && $this->newsession->userdata('SESS_BBPOM_ID') != "00"){
			$where = " WHERE A.STATUS NOT IN ('00') AND A.BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'";
			$judul = "Pemeriksaan Komoditi di ".$sipt->main->get_uraian("SELECT NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID='".$this->newsession->userdata('SESS_BBPOM_ID')."'","NAMA_BBPOM");
		}else{
			$where = " WHERE A.STATUS NOT IN ('00') ";
			$judul = "Pemeriksaan Komoditi Seluruh Balai Besar / Balai POM";
		}
		
		$query = "SELECT CASE B.KK_ID WHEN '001' THEN 'Obat' WHEN '005' THEN 'Narkotika' WHEN '006' THEN 'Psikotropika' WHEN '009' THEN 'Prekursor' WHEN '010' THEN 'Obat Tradisional' WHEN '011' THEN 'Produk Komplemen' WHEN '012' THEN 'Kosmetika' WHEN '013' THEN 'Produk Pangan' WHEN '018' THEN 'Obat dan Produk Biologi' WHEN '019' THEN 'Bahan Obat' END AS KK_ID, COUNT(B.KK_ID) AS JUMLAH FROM T_PEMERIKSAAN A LEFT JOIN T_PEMERIKSAAN_KLASIFIKASI B ON A.PERIKSA_ID = B.PERIKSA_ID LEFT JOIN M_BBPOM C ON A.BBPOM_ID = C.BBPOM_ID $where GROUP BY B.KK_ID ORDER BY 2 DESC";
		$data = $sipt->main->get_result($query);
		$ret = "";
		$tbl = "";
		if($data){
			if($query->num_rows()>0){
				$tbl = "<table class=\"chart_tabel\">";
				$tbl .= "<tr><th colspan=\"2\"><b>".$judul."</b></th></tr>";
				$i = 0;
				$jml = 0;
				foreach($query->result_array() as $row){
					$ret .= $row['KK_ID'].";".$row['JUMLAH']."|";
					if($i%2>0) $cls = 'class="odd"';
					else $cls = "";
					$tbl .= "<tr><td width=\"200\" ".$cls.">".$row['KK_ID']."</td><td ".$cls." align=\"right\" width=\"50\">".$row['JUMLAH']."</td></tr>";
					$jml = $jml + $row['JUMLAH'];
					$i++;
				}
				$tbl .= "<tr><td width=\"300\" ".$cls.">Jumlah </td><td ".$cls." align=\"right\" width=\"50\">".$jml."</td></tr>";
				$tbl .= "</table>";
			}
		}
		return $ret.$tbl;
	}
	
	function chart_jsarana(){
		$sipt =& get_instance();
		$sipt->load->model('main','main',true);
		if(in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))){
			$sarana = "'".join("','", $this->newsession->userdata('SESS_SARANA'))."'";
			$where = " AND C.JENIS_SARANA_ID IN ($sarana)";
			$judul = "Pemeriksaan Sarana Seluruh Balai Besar / Balai POM";
		}else if(!in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')) && $this->newsession->userdata('SESS_BBPOM_ID') != "00"){
			$where = " AND C.BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'";
			$judul = "Pemeriksaan Sarana di ".$sipt->main->get_uraian("SELECT NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID='".$this->newsession->userdata('SESS_BBPOM_ID')."'","NAMA_BBPOM");
		}else{
			$where = "";
			$judul = "Pemeriksaan Sarana Seluruh Balai Besar / Balai POM";
		}
		
		$query = "SELECT B.NAMA_JENIS_SARANA + ' - ' + A.NAMA_JENIS_SARANA AS NAMA_JENIS, COUNT(C.JENIS_SARANA_ID) AS JUMLAH FROM M_JENIS_SARANA A LEFT JOIN M_JENIS_SARANA B ON LEFT(A.JENIS_SARANA_ID, 2) = B.JENIS_SARANA_ID LEFT JOIN T_PEMERIKSAAN C ON A.JENIS_SARANA_ID = C.JENIS_SARANA_ID WHERE LEN(A.JENIS_SARANA_ID) > 2 AND C.STATUS NOT IN('00') $where GROUP BY C.JENIS_SARANA_ID, B.NAMA_JENIS_SARANA, A.NAMA_JENIS_SARANA ORDER BY 2 DESC";
		$data = $sipt->main->get_result($query);
		$ret = "";
		$tbl = "";
		if($data){
			if($query->num_rows()>0){
				$tbl = "<table class=\"chart_tabel\">";
				$tbl .= "<tr><th colspan=\"2\"><b>".$judul."</b></th></tr>";
				$i = 0;
				$jml = 0 ;
				foreach($query->result_array() as $row){
					$ret .= $row['NAMA_JENIS'].";".$row['JUMLAH']."|";
					if($i%2>0) $cls = 'class="odd"';
					else $cls = "";
					$tbl .= "<tr><td width=\"300\" ".$cls.">".$row['NAMA_JENIS']."</td><td ".$cls." align=\"right\" width=\"50\">".$row['JUMLAH']."</td></tr>";
					$i++;
					$jml = $jml + $row['JUMLAH'];
				}
				$tbl .= "<tr><td width=\"300\" ".$cls.">Jumlah </td><td ".$cls." align=\"right\" width=\"50\">".$jml."</td></tr>";
				$tbl .= "</table>";
			}
		}
		return $ret.$tbl;

	}
	
	function list_session(){
		if($this->newsession->userdata('LOGGED_IN') && array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('10', $this->newsession->userdata('SESS_KODE_ROLE'))){
			$sipt = get_instance();
			$sipt->load->model("main","main", true);
			$path = realpath(session_save_path());
			foreach(glob($path . '/sess*') as $file){
				$isi = serialize(file_get_contents($file));
				$cari = strpos($isi, "LOGGED_IN");
				if($cari != false){
					$session[$file] = $isi;
				}
			}
			$arrdata = array('act' => '',
							 'caption' => "Simpan",
							 'sess' => $session,
							 'idjudul' => 'judulpetugas',
							 'caption_header' => "Monitoring Session Pengguna Aktif");
			return $arrdata;
		}else{
			$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
		}
	}
	
	function set_log($action, $isajax){
		if(array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('10', $this->newsession->userdata('SESS_KODE_ROLE')) || $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main","main", true);
			if($action=="delete"){
				$ret = "MSG#Hapus Log Gagal.";
				foreach($this->input->post('tb_chk') as $chkitem){
					$ids = explode(".", $chkitem);
					$this->db->where(array("USER_ID" => $ids[0], "SERI" => $ids[1]));
					if($this->db->delete('T_SINKRONISASI_LOG')) $ret = "MSG#Hapus Log Berhasil.#";
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
	
	function list_surat($menu, $sarana,$jenis,$komoditi,$periksa){
		if((array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('2', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('9', $this->newsession->userdata('SESS_KODE_ROLE')))  && $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$periksa = explode(".",$periksa);
			if(count($periksa) < 1) return redirect(base_url());
			$sipt =& get_instance();
			$this->load->model("main","main", true);
			$surat_id = $sipt->main->get_uraian("SELECT SURAT_ID FROM T_SURAT_TUGAS_PELAPORAN WHERE LAPOR_ID = '".$periksa[0]."'","SURAT_ID");
			$this->load->library('newtable');
			$this->newtable->hiddens(array('SURAT_ID'));
			$this->newtable->show_search(FALSE);
			$this->newtable->cidb($this->db);
			$this->newtable->rowcount("ALL");
			$this->newtable->ciuri($this->uri->segment_array());
			$this->newtable->orderby(1);
			$this->newtable->sortby("DESC");
			$this->newtable->keys(array('SURAT_ID'));
			$uri = site_url().'/home/surat/new/'.$sarana.'/'.$jenis.'/'.$komoditi.'/'.join(".",$periksa);
			$proses['Edit Data Surat'] = array('GET',$uri,'1');
			$this->newtable->menu($proses);
			$query = "SELECT A.SURAT_ID, A.NOMOR, CONVERT(VARCHAR(10), A.TANGGAL, 120) AS TANGGAL, B.NAMA_USER AS [NAMA PETUGAS] FROM T_SURAT_TUGAS A LEFT JOIN T_USER B ON A.CREATE_BY = B.USER_ID WHERE A.SURAT_ID = '".$surat_id."'";			
			$this->newtable->width(array('NOMOR' => 200 ,'TANGGAL' => 350, 'NAMA PETUGAS' => 150));
			$this->newtable->columns(array("A.SURAT_ID", "A.NOMOR", "CONVERT(VARCHAR(10), A.TANGGAL, 120)", "B.NAMA_USER"));
			$tabel = $this->newtable->generate($query);
			$arrdata = array('table' => $tabel,
							 'idjudul' => 'judulpetugas',
							 'caption_header' => 'Detil Data Surat',
							 'batal' => '',
							 'cancel' => '');
			return $arrdata;

		}
	}

	function get_riwayat($sarana,$jenis,$komoditi,$periksa){
		if((array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('2', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('9', $this->newsession->userdata('SESS_KODE_ROLE')))  && $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main","main", true);
			$this->load->library('newtable');
			$arr_id = explode(".",$periksa);
			if(count($arr_id) < 1) return redirect(base_url());
			
			$isproses = $sipt->main->get_uraian("SELECT BBPOM_ID FROM T_PEMERIKSAAN WHERE PERIKSA_ID = '".$arr_id[0]."'","BBPOM_ID");
			
			$query = "SELECT A.PERIKSA_ID, A.SERI, Z.NAMA_USER AS [NAMA], STUFF(dbo.GROUP_ROLE(Z.USER_ID),1,1,'') AS ROLE,(CASE WHEN DATEDIFF(DAY, A.CREATE_DATE, GETDATE()) > 0 THEN CONVERT(VARCHAR(10), A.CREATE_DATE, 105)+'<div>'+CONVERT(VARCHAR(10), CREATE_DATE, 108)+'</div>' ELSE (CASE WHEN DATEDIFF(HOUR, CREATE_DATE, GETDATE()) > 0 THEN CAST(DATEDIFF(HOUR, A.CREATE_DATE, GETDATE())%24 AS VARCHAR) + ' Jam, ' ELSE '' END) + CAST(DATEDIFF(MINUTE, A.CREATE_DATE, GETDATE())%60 AS VARCHAR) + ' Menit Yang Lalu' END) AS WAKTU,'<div> Status Pemeriksaan : '+ C.URAIAN+'</div><div>'+CAST(A.CATATAN AS VARCHAR(255))+'</div>' AS CATATAN FROM T_PEMERIKSAAN_PROSES A LEFT JOIN T_USER Z ON A.CREATE_BY = Z.USER_ID LEFT JOIN M_TABEL C ON A.HASIL = C.KODE LEFT JOIN M_BBPOM D ON Z.BBPOM_ID = D.BBPOM_ID WHERE A.PERIKSA_ID = '".$arr_id[0]."' AND C.JENIS = 'STATUS'";
			$this->load->library('newtable');
			$this->newtable->search(array(array('', '')));
			$this->newtable->hiddens(array('PERIKSA_ID','SERI','CREATE_DATE'));
			$this->newtable->action(site_url().'/riwayat/pemeriksaan/'.$sarana.'/'.$jenis.'/'.$komoditi.'/'.$periksa);
			$this->newtable->cidb($this->db);
			$this->newtable->ciuri($this->uri->segment_array());
			$this->newtable->orderby('SERI');
			$this->newtable->sortby("DESC");
			$this->newtable->keys(array('PERIKSA_ID','SERI'));
			$this->newtable->columns(array("A.PERIKSA_ID, A.SERI, Z.NAMA_USER","STUFF(dbo.GROUP_ROLE(Z.USER_ID),1,1,'')","(CASE WHEN DATEDIFF(DAY, A.CREATE_DATE, GETDATE()) > 0 THEN CONVERT(VARCHAR(10), A.CREATE_DATE, 105)+'<div>'+CONVERT(VARCHAR(10), CREATE_DATE, 108)+'</div>' ELSE (CASE WHEN DATEDIFF(HOUR, CREATE_DATE, GETDATE()) > 0 THEN CAST(DATEDIFF(HOUR, A.CREATE_DATE, GETDATE())%24 AS VARCHAR) + ' Jam, ' ELSE '' END) + CAST(DATEDIFF(MINUTE, A.CREATE_DATE, GETDATE())%60 AS VARCHAR) + ' Menit Yang Lalu' END)","CAST(A.CATATAN AS VARCHAR(MAX))+ '<div> Status Pemeriksaan : '+ CAST(C.URAIAN AS VARCHAR(50)) + '</div>'"));
			$this->newtable->width(array('NAMA' => 150, 'ROLE' => 100, 'WAKTU' => '75', 'CATATAN' => '250'));
			$this->newtable->show_search(FALSE);
			if(($isproses == $this->newsession->userdata('SESS_BBPOM_ID')) || array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE'))){
				$proses['Restore Riwayat Pemeriksaan'] = array('POST',site_url().'/post/pemeriksaan/set_riwayat/delete/ajax','N');
				$this->newtable->menu($proses);
				$allowed = TRUE;
			}else{
				$this->newtable->show_chk(FALSE);
				$allowed = FALSE;
			}
			$data = "SELECT D.PERIKSA_ID, A.SARANA_ID, A.NAMA_SARANA, B.NAMA_BBPOM, C.NAMA_JENIS_SARANA, CONVERT(VARCHAR(10), D.AWAL_PERIKSA, 103) AS AWAL_PERIKSA, CONVERT(VARCHAR(10), D.AKHIR_PERIKSA, 103) AS AKHIR_PERIKSA, E.URAIAN AS STATUS, F.NAMA_USER AS PETUGAS FROM M_SARANA A LEFT JOIN T_PEMERIKSAAN D ON A.SARANA_ID = D.SARANA_ID LEFT JOIN M_JENIS_SARANA C ON D.JENIS_SARANA_ID = C.JENIS_SARANA_ID LEFT JOIN M_BBPOM B ON D.BBPOM_ID = B.BBPOM_ID LEFT JOIN M_TABEL E ON D.STATUS = E.KODE LEFT JOIN T_USER F ON D.CREATE_BY = F.USER_ID WHERE A.SARANA_ID = '".$sarana."' AND D.PERIKSA_ID = '".$arr_id[0]."' AND E.JENIS = 'STATUS'";
			$res = $sipt->main->get_result($data);
			if($res){
				foreach($data->result_array() as $row){
					$arrdata = array('sess' => $row,
									 'header' => 'Detil Riwayat Pemeriksaan',
									 'cancel' => 'Kembali');
				}
			}				
			$arrdata['allowed'] = $allowed;
			$arrdata['tabel'] = $this->newtable->generate($query);
			return $arrdata;
		}
	}
	
	function get_surat($menu,$sarana,$jenis,$komoditi,$periksa,$id){
		if((array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('2', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('9', $this->newsession->userdata('SESS_KODE_ROLE')))  && $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$sipt->load->model("main", "main", true);
			if($id == "") return redirect(base_url());
			if($id != ""){
				$query = "SELECT SURAT_ID, NOMOR, CONVERT(VARCHAR(10), TANGGAL, 103) AS TANGGAL FROM T_SURAT_TUGAS WHERE SURAT_ID = '".$id."'";
				$data = $sipt->main->get_result($query);
				if($data){
					foreach($query->result_array() as $row){
						$arrdata = array('act' => site_url().'/post/pemeriksaan/set_newsurat/update/',
										 'sess' => $row,
										 'header' => 'Edit Data Surat',
										 'save' => 'Update',
										 'cancel' => 'Kembali');
					}
				}				
			}
			$arr = explode(".",$periksa);
			$arrdata['id'] = $id;
			$arrdata['periksa_id'] = $arr[0];
			return $arrdata;
		}
	}
	
	function get_new_surat($menu,$sarana,$jenis,$komoditi,$periksa){
		if((array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('2', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('9', $this->newsession->userdata('SESS_KODE_ROLE')))  && $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$arrid = explode(".",$periksa);
			$sipt->load->model("main", "main", true);
			$query = "SELECT A.NAMA_SARANA, CONVERT(VARCHAR(10), B.AWAL_PERIKSA, 103) AS TANGGAL, B.CREATE_BY, CONVERT(VARCHAR(10), B.CREATE_DATE, 103) AS CREATE_DATE, C.NAMA_USER AS PETUGAS, STUFF(dbo.GROUP_CONCAT(B.PERIKSA_ID),1,1,'') AS SURAT_ID
					  FROM M_SARANA A LEFT JOIN T_PEMERIKSAAN B ON A.SARANA_ID = B.SARANA_ID LEFT JOIN T_USER C ON B.CREATE_BY = C.USER_ID
					  WHERE B.PERIKSA_ID = '".$arrid[0]."'";
			$data = $sipt->main->get_result($query);
			if($data){
				foreach($query->result_array() as $row){
					$arrdata = array('act' => site_url().'/post/pemeriksaan/set_newsurat/new/',
									 'sess' => $row,
									 'header' => 'Tambah Surat Tugas',
									 'save' => 'Simpan',
									 'cancel' => 'Kembali');
				}
				if(trim($row['SURAT_ID']) != ""){
					$surat = join(",", explode(".",$row['SURAT_ID']));		  
					$query = "SELECT A.NOMOR AS [Nomor Surat Tugas], CONVERT(VARCHAR(10), A.TANGGAL, 103) AS [Tanggal Surat], B.NAMA_USER AS [Nama Petugas], C.NAMA_BBPOM AS [Balai / Badan] FROM T_SURAT_TUGAS A LEFT JOIN T_SURAT_TUGAS_PETUGAS D ON A.SURAT_ID = D.SURAT_ID LEFT JOIN T_USER B ON B.USER_ID = D.USER_ID LEFT JOIN M_BBPOM C ON C.BBPOM_ID = B.BBPOM_ID WHERE A.SURAT_ID IN ($surat)";
					$this->load->library('newtable');
					$this->newtable->search(array(array('', '')));
					$this->newtable->action(site_url());
					$this->newtable->cidb($this->db);
					$this->newtable->ciuri($this->uri->segment_array());
					$this->newtable->orderby("Nama Petugas");
					$this->newtable->keys("Nama Petugas");
					$this->newtable->rowcount("ALL");
					$this->newtable->show_chk(FALSE);
					$this->newtable->show_search(FALSE);
					$arrdata['tabel'] = $this->newtable->generate($query);
				}
			}
			$arrdata['periksa_id'] = $arrid[0];
			return $arrdata;
		}
	}
	
	function get_sampel(){
		if(array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt = get_instance();
			$sipt->load->model("main","main", true);
			$query = "SELECT ID FROM T_M_SAMPEL WHERE FLAG = 0 ORDER BY KODE_SAMPEL ASC";
			$data = $sipt->main->get_result($query);
			if($data){
				foreach($query->result_array() as $row){
					$id[] = $row['ID'];
				}
			}
			$arrdata = array('id' => join('|', $id));
			return $arrdata;
		}
	}
	
	function set_kodesampel($kode=""){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE && $this->newsession->userdata('SESS_BBPOM_ID') == "00"){
			$sipt =& get_instance();
			$this->load->model("main","main", true);
			$data = $this->db->query("SELECT KODE_SAMPEL, CASE WHEN A.TUJUAN_SAMPLING != '01' OR A.TUJUAN_SAMPLING != '02' OR A.TUJUAN_SAMPLING != '03' OR A.TUJUAN_SAMPLING != '04' OR A.TUJUAN_SAMPLING != '05' THEN A.TUJUAN_SAMPLING ELSE '99' END AS TUJUAN_SAMPLING, A.KOMODITI, A.ANGGARAN, CASE WHEN A.UJI_KIMIA = 1 AND A.UJI_MIKRO = 1 THEN 'KM' WHEN A.UJI_KIMIA = 1 AND A.UJI_MIKRO = 0 THEN 'K' WHEN A.UJI_KIMIA = 0 AND A.UJI_MIKRO = 1 THEN 'M' END AS LAB, CONVERT(VARCHAR(10), A.TANGGAL_SAMPLING, 103) AS TANGGAL_SAMPLING, B.BBPOM_ID, C.NAMA_BBPOM, D.KODE_BALAI FROM T_M_SAMPEL_UPDATE A LEFT JOIN T_PERIKSA_SAMPEL B ON A.PERIKSA_SAMPEL = B.PERIKSA_SAMPEL LEFT JOIN M_BBPOM C ON B.BBPOM_ID = C.BBPOM_ID LEFT JOIN M_NOMOR D ON C.BBPOM_ID = D.BBPOM_ID WHERE A.ID = '".$kode."'");
			$hasil = FALSE;
			if($data->num_rows() > 0){
				foreach($data->result_array() as $row){
					$new = $sipt->main->backup_kode($row['TUJUAN_SAMPLING'], $row['ANGGARAN'], $row['KOMODITI'], $row['LAB'], $row['BBPOM_ID']);
					$this->db->simple_query("UPDATE T_M_SAMPEL_UPDATE SET KODE_SAMPEL = '".$new."', FLAG = 1, KODE_SAMPELX = '".$row['KODE_SAMPEL']."' WHERE ID = '".$kode."'");
					if($this->db->affected_rows() > 0){
						$hasil = TRUE;
						$arrlog = array("KODE_SAMPEL" => $new,
										"WAKTU" => $row['TANGGAL_SAMPLING'],
										"USER_ID" => "administrator",
										"KEGIATAN " => "Simpan Data Sampel",
										"CATATAN" => "-");
						$this->db->insert("T_SAMPLING_LOG", $arrlog);			
					}else{
						$hasil = FALSE;
					}
				}
				if($hasil)
				return "OK#".$new."#".$row['KODE_SAMPEL']."#Sukses";
				else
				return "OK#".$new."#".$row['KODE_SAMPEL']."#Gagal";
			}
		}
	}
	
	function weekend(){
		$skrg = time();
		$tglskrg = date('w', $skrg);
		$akhir = $tglskrg - 1;
		if($akhir < 0){
			$akhir = 6;
		}
		$senin = $skrg - ($akhir * 86400);
		$minggu = $senin + (6 * 86400);
		$hasil = array("awal" => date("m/d/Y", $senin), "akhir" => date("m/d/Y",$minggu));
		return $hasil;
	}
	function yearz(){
		$years = "";
		$year = date('Y');
		$start = mktime(0, 0, 0, 1, 1, $year);
		$end = mktime(0, 0, 0, 12, 31, $year);
		$early = date("d-m-Y", $start);
		$last = date("d-m-Y", $end);
		$years = $early."|".$last;
		return $years;
	}

}


?>