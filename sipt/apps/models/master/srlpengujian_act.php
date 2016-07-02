<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);

class Srlpengujian_act extends Model{

	function list_srl(){
		if((in_array('1', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('9', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('4', $this->newsession->userdata('SESS_KODE_ROLE'))) && $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$sipt->load->model("main", "main", true);
			$this->load->library('newtable');
			$this->newtable->hiddens(array('SRL_ID'));
			$this->newtable->action(site_url()."/home/master/srlpengujian");
			$this->newtable->cidb($this->db);
			$this->newtable->ciuri($this->uri->segment_array());
			$this->newtable->orderby(1);
			$this->newtable->sortby("ASC");
			$this->newtable->keys(array('SRL_ID'));
			$this->newtable->search(array(array("CASE WHEN A.BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN A.BIDANG_UJI = 'Kimia Fisika' THEN 'Mikro' END", "Berdasarkan Bidang Pengujian"), array("dbo.KATEGORI(LEFT(A.GOLONGAN,2),'0')", "Berdasarkan Komoditi"), array("dbo.KATEGORI(A.GOLONGAN,'0')", "Berdasarkan Kategori"), array("A.PARAMETER_UJI", "Berdasarkan Parameter Uji"),array("A.PUSTAKA", "Berdasarkan Pustaka"),array("A.METODE", "Berdasarkan Metode"),array("A.SYARAT", "Berdasarkan Syarat"), array("REPLACE(REPLACE(B.NAMA_BBPOM,'BALAI BESAR POM DI ', ''),'BALAI POM DI ','')","Sumber Pengentri")));
			if(in_array('1', $this->newsession->userdata('SESS_KODE_ROLE')) && (in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')) || $this->newsession->userdata('SESS_BBPOM_ID') == "99")){
				$proses['SRL Pengujian Baru'] = array('GET',site_url().'/home/master/srlpengujian/new','0');
				$proses['Edit SRL Pengujian'] = array('GET',site_url().'/home/master/srlpengujian/new','1');
				$proses['Hapus SRL Pengujian'] = array('POST', site_url()."/post/master/srlpengujian/hapus/ajax", 'N');
			}
			$this->newtable->menu($proses);
			$query = "SELECT A.SRL_ID, CASE WHEN A.BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN A.BIDANG_UJI = '02' THEN 'Kimia' END AS 'BIDANG UJI', dbo.KATEGORI(LEFT(A.GOLONGAN,2),'0') AS KOMODITI, dbo.KATEGORI(A.GOLONGAN,'0') + '</div>' AS KATEGORI, A.PARAMETER_UJI AS [PARAMETER UJI], A.PUSTAKA, A.METODE, A.SYARAT, REPLACE(REPLACE(B.NAMA_BBPOM,'BALAI BESAR POM DI ', ''),'BALAI POM DI ','') AS SUMBER FROM M_SRL A LEFT JOIN M_BBPOM B ON A.BBPOM_ID = B.BBPOM_ID";
			$this->newtable->columns(array("A.SRL_ID", "CASE WHEN A.BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN A.BIDANG_UJI = 'Kimia Fisika' THEN 'Mikro' END", "dbo.KATEGORI(LEFT(A.GOLONGAN,2),'0')", "dbo.KATEGORI(A.GOLONGAN,'0') + '</div>'", "A.PARAMETER_UJI", "A.PUSTAKA", "A.METODE","A.SYARAT"));
			$this->newtable->width(array('BIDANG UJI' => 75,'KOMODITI' => 100, 'KATEGORI' => 200, 'PARAMETER UJI' => 200, 'PUSTAKA' => 150, 'METODE' => 150, 'SUMBER' => 75));
			$tabel = $this->newtable->generate($query);
			$arrdata = array('table' => $tabel,
							 'idjudul' => 'juduluji',
							 'caption_header' => 'Standar Ruang Lingkup Pengujian',
							 'batal' => '',
							 'cancel' => '');
			return $arrdata;
		}else{
			$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
		}
	}
	
	function get_srl($id){
		if(in_array('1', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('9', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('4', $this->newsession->userdata('SESS_KODE_ROLE')) || (in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')) || $this->newsession->userdata('SESS_BBPOM_ID') == "99")){ 
			$sipt =& get_instance();
			$sipt->load->model("main", "main", true);
			$bidang = $sipt->main->combobox("SELECT KODE, URAIAN FROM M_TABEL WHERE JENIS ='BIDANG_PENGUJIAN'","KODE", "URAIAN", TRUE);
			$golongan = $sipt->main->combobox("SELECT KLASIFIKASI_ID, KLASIFIKASI FROM M_GOLONGAN WHERE LEN(KLASIFIKASI_ID) = 2","KLASIFIKASI_ID", "KLASIFIKASI", TRUE);
			if($id==""){
				$arrdata = array('act' => site_url().'/post/master/srlpengujian/simpan',				
								 'batal' => site_url().'/home/master/srlpengujian',
								 'sess' => '',
								 'id' => '',
								 'sess' => '',
								 'save' => 'Simpan',
								 'cancel' => 'Batal');
			}else{
				$qsrl = $this->db->query("SELECT CREATE_BY, BBPOM_ID FROM M_SRL WHERE SRL_ID = '".$id."'")->result_array();
				/*if(($this->newsession->userdata('SESS_USER_ID') != $qsrl[0]['CREATE_BY']) && ($this->newsession->userdata('SESS_BBPOM_ID') != $qsrl[0]['SESS_BBPOM_ID'])){
					return $this->fungsi->redirectMessage('Mohon maaf, Petugas entri dan BBPOM / BPOM tidak sesuai.','/home'); exit();
				}*/
				$query = "SELECT SRL_ID, BIDANG_UJI, SUBSTRING(RTRIM(LTRIM(GOLONGAN)),1,2) AS KOMODITI, SUBSTRING(RTRIM(LTRIM(GOLONGAN)),1,4) AS KATEGORI, SUBSTRING(RTRIM(LTRIM(GOLONGAN)),1,6) AS SUB_KATEGORI, SUBSTRING(RTRIM(LTRIM(GOLONGAN)),1,8) AS SUB_KATEGORI_1, SUBSTRING(RTRIM(LTRIM(GOLONGAN)),1,10) AS SUB_KATEGORI_2, PARAMETER_UJI, METODE, PUSTAKA, SYARAT, RUANG_LINGKUP, PRIORITAS FROM M_SRL WHERE SRL_ID = '".$id."'";
				$data = $sipt->main->get_result($query);
				if($data){
					foreach($query->result_array() as $row){
						$arrdata = array('sess' => $row,
										 'act' => site_url().'/post/master/srlpengujian/update',
										 'batal' => site_url().'/home/master/srlpengujian',
										 'id' => $row['SRL_ID'],
										 'save' => 'Update',
										 'cancel' => 'Kembali');
					}
					if(trim($row['KOMODITI']) != ""){
						$arrdata['kategori'] = $sipt->main->combobox("SELECT LTRIM(RTRIM(KLASIFIKASI_ID)) AS KLASIFIKASI_ID, KLASIFIKASI FROM M_GOLONGAN WHERE KLASIFIKASI_ID LIKE '%".$row['KOMODITI']."%__' AND LEN(KLASIFIKASI_ID) = '4' ORDER BY KLASIFIKASI_ID ASC","KLASIFIKASI_ID", "KLASIFIKASI", TRUE);
					}
					if(trim($row['KATEGORI']) != ""){
						$arrdata['sub_kategori'] = $sipt->main->combobox("SELECT LTRIM(RTRIM(KLASIFIKASI_ID)) AS KLASIFIKASI_ID, KLASIFIKASI FROM M_GOLONGAN WHERE KLASIFIKASI_ID LIKE '%".$row['KATEGORI']."%__' AND LEN(KLASIFIKASI_ID) = '6' ORDER BY KLASIFIKASI_ID ASC","KLASIFIKASI_ID", "KLASIFIKASI", TRUE);
					}
					if(trim($row['SUB_KATEGORI']) != ""){
						$arrdata['sub_kategori_1'] = $sipt->main->combobox("SELECT LTRIM(RTRIM(KLASIFIKASI_ID)) AS KLASIFIKASI_ID, KLASIFIKASI FROM M_GOLONGAN WHERE KLASIFIKASI_ID LIKE '%".$row['SUB_KATEGORI']."%__' AND LEN(KLASIFIKASI_ID) = '8' ORDER BY KLASIFIKASI_ID ASC","KLASIFIKASI_ID", "KLASIFIKASI", TRUE);
					}
					if(trim($row['SUB_KATEGORI']) != ""){
						$arrdata['sub_kategori_2'] = $sipt->main->combobox("SELECT LTRIM(RTRIM(KLASIFIKASI_ID)) AS KLASIFIKASI_ID, KLASIFIKASI FROM M_GOLONGAN WHERE KLASIFIKASI_ID LIKE '%".$row['SUB_KATEGORI_1']."%__' AND LEN(KLASIFIKASI_ID) = '10' ORDER BY KLASIFIKASI_ID ASC","KLASIFIKASI_ID", "KLASIFIKASI", TRUE);
					}
				}
			}
			$arrdata['prioritas'] = array('' => '', 'DP '.date("Y") => 'DP '.date("Y"), 'BDP '.date("Y") => 'BDP '.date("Y"));
			$arrdata['golongan'] = $golongan;
			$arrdata['bidang'] = $bidang;
			return $arrdata;
		}else{
			$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
		}
	}
	
	function set_srlpengujian($action, $isajax){
		if(in_array('1', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('9', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('4', $this->newsession->userdata('SESS_KODE_ROLE'))){ 
			$sipt =& get_instance();
			$this->load->model("main","main", true);
			if($action=="simpan"){
				$srl_id = (int)$sipt->main->get_uraian("SELECT MAX(SRL_ID) AS MAXID FROM M_SRL", "MAXID") + 1;
				$arr_slr = array('SRL_ID' => $srl_id,
								 'CREATE_DATE' => 'GETDATE()',
								 'CREATE_BY' => $this->newsession->userdata('SESS_USER_ID'),
								 'STATUS' => '2');
				foreach($this->input->post('SRL') as $a => $b){
					$arr_slr[$a] = $b;
				}
				
				if(strlen($arr_slr['PARAMETER_UJI']) == 1 || strlen($arr_slr['METODE']) == 1 || strlen($arr_slr['PUSTAKA']) == 1 || strlen($arr_slr['SYARAT']) == 1){
					return "MSG#NO#Data Gagal Disimpan, ini dikarenakan : \n Parameter Uji, Metode, Pustaka atau Syarat hanya diisi dengan tanda minus (-)"; 
					die();
				}
				
				
				$golongan = array_filter($this->input->post('GOLONGAN'));
				$arr_slr['GOLONGAN'] = $golongan[count($golongan)-1];
				$arr_slr['BBPOM_ID'] = $this->newsession->userdata('SESS_BBPOM_ID');
				#if(in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')) || $this->newsession->userdata('SESS_BBPOM_ID') == "00")
				$arr_slr['VERIFI'] = '01';
				#else $arr_slr['VERIFI'] = '00';
				if($this->db->insert('M_SRL', $arr_slr)){
					$kiri = substr($arr_slr['GOLONGAN'],0,2);
					if($kiri == "01")
						$redir = substr($arr_slr['GOLONGAN'],0,4);
					else
						$redir = substr($arr_slr['GOLONGAN'],0,2);
					#return "MSG#YES#Data berhasil disimpan.#".site_url().'/home/master/parameter-uji/view/'.$redir;
					return "MSG#YES#Data berhasil disimpan.#".site_url().'/home/master/srlpengujian/new';
				}else{
					return "MSG#NO#Data Gagal Disimpan";
				}
				if($isajax!="ajax"){
					redirect(site_url().'/home/master/srlpengujian');
					exit();
				}
			}
			else if($action=="update"){
				$id = $this->input->post('ID');
				foreach($this->input->post('SRL') as $a => $b){
					$arr_slr[$a] = $b;
				}
				$golongan = array_filter($this->input->post('GOLONGAN'));
				$arr_slr['GOLONGAN'] = $golongan[count($golongan)-1];
				$arr_slr['BBPOM_ID'] = $this->newsession->userdata('SESS_BBPOM_ID');
				$this->db->where('SRL_ID', $id);
				if($this->db->update('M_SRL', $arr_slr)){
					$kiri = substr($arr_slr['GOLONGAN'],0,2);
					if($kiri == "01")
						$redir = substr($arr_slr['GOLONGAN'],0,4);
					else
						$redir = substr($arr_slr['GOLONGAN'],0,2);
					return "MSG#YES#Data berhasil diupdate#".site_url().'/home/master/parameter-uji/view/'.$redir;
				}else{
					return "MSG#NO#Data Gagal Diupdate";
				}
				if($isajax!="ajax"){
					redirect(base_url());
					exit();
				}
			}else if($action=="hapus"){
				$ret = "MSG#Hapus Data SRL Pengujian Gagal.";
				foreach($this->input->post('tb_chk') as $chkitem){
					$gol = $this->db->query("SELECT LTRIM(RTRIM(SUBSTRING(GOLONGAN,1,2))) LEFT2, LTRIM(RTRIM(SUBSTRING(GOLONGAN,1,4))) LEFT4 FROM M_SRL WHERE SRL_ID = '".$chkitem."'")->result_array();
					$kiri = substr($arr_slr['GOLONGAN'],0,2);
					if($gol[0]['LEFT2'] == "01")
						$redir = $gol[0]['LEFT4'];
					else
						$redir = $gol[0]['LEFT2'];
					$this->db->where('SRL_ID', $chkitem);
					if($this->db->delete('M_SRL')){
						 $ret = "MSG#Hapus SRL Pengujian Berhasil.#".site_url().'/home/master/parameter-uji/view/'.$redir;
					}
				}
				if($isajax!="ajax"){
					redirect(base_url());
					exit();			  
				}
				return $ret;
			}else if($action == "verifikasi"){
				$id = $this->input->post('ID');
				foreach($this->input->post('SRL') as $a => $b){
					$arr_slr[$a] = $b;
				}
				$arr_slr['UPDATE_BY'] = $this->newsession->userdata('SESS_USER_ID');
				$this->db->where('SRL_ID', $id);
				if($this->db->update('M_SRL', $arr_slr)){
					$golongan = $sipt->main->get_uraian("SELECT RTRIM(LTRIM(GOLONGAN)) AS GOLONGAN FROM M_SRL WHERE SRL_ID = '".$id."'","GOLONGAN");
					$kiri = substr($golongan,0,2);
					if($kiri == "01")
						$redir = substr($golongan,0,4);
					else
						$redir = substr($golongan,0,2);
					return "MSG#YES#Data berhasil diverifikasi#".site_url().'/home/master/parameter-uji/view/'.$redir;
				}else{
					return "MSG#NO#Data gagal diverifikasi";
				}
				if($isajax!="ajax"){
					redirect(base_url());
					exit();
				}
			}
		}else{
			$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
		}		
	}
	
	function list_golongan(){
		if((in_array('1', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('9', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('4', $this->newsession->userdata('SESS_KODE_ROLE'))) && $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$sipt->load->model("main", "main", true);
			$this->load->library('newtable');
			$this->newtable->hiddens(array('KLASIFIKASI_ID'));
			$this->newtable->action(site_url()."/home/master/golongan");
			$this->newtable->cidb($this->db);
			$this->newtable->ciuri($this->uri->segment_array());
			$this->newtable->orderby(1);
			$this->newtable->sortby("ASC");
			$this->newtable->keys(array('KLASIFIKASI_ID'));
			$this->newtable->search(array(array("dbo.GOLONGAN_SAMPEL(LEFT(A.KLASIFIKASI_ID,2))","Komoditi"),
										  array("dbo.GOLONGAN_SAMPEL(LEFT(A.KLASIFIKASI_ID,4))","Kategori"),
										  array("dbo.GOLONGAN_SAMPEL(LEFT(A.KLASIFIKASI_ID,6))","Sub Kategori"),
										  array("CASE WHEN LEN(KLASIFIKASI_ID) > 6 THEN dbo.GOLONGAN_SAMPEL(LEFT(A.KLASIFIKASI_ID,8)) ELSE '' END","Sub Sub Kategori"),
										  array("CASE WHEN LEN(KLASIFIKASI_ID) > 8 THEN dbo.GOLONGAN_SAMPEL(LEFT(KLASIFIKASI_ID,10)) ELSE '' END","Sub Sub Sub Kategori")));
			if(in_array('1', $this->newsession->userdata('SESS_KODE_ROLE'))){
				$proses['Golongan Baru'] = array('GET',site_url().'/home/master/golongan/new','0');
				$proses['Edit Golongan'] = array('GET',site_url().'/home/master/golongan/edit','1');
				$proses['Hapus Golongan'] = array('POST', site_url()."/post/master/golongan/hapus/ajax", 'N');
			}
			$this->newtable->menu($proses);
			#$query = "SELECT A.KLASIFIKASI_ID, dbo.KATEGORI(A.KLASIFIKASI_ID) AS GOLONGAN, B.NAMA_USER AS SUMBER, REPLACE(REPLACE(C.NAMA_BBPOM,'BALAI BESAR POM DI ', ''),'BALAI POM DI ','') AS BBPOM FROM M_GOLONGAN A LEFT JOIN T_USER B ON A.CREATE_BY = B.USER_ID LEFT JOIN M_BBPOM C ON B.BBPOM_ID = C.BBPOM_ID WHERE LEN(A.KLASIFIKASI_ID) > 6";
			
			$query = "SELECT A.KLASIFIKASI_ID, dbo.GOLONGAN_SAMPEL(LEFT(A.KLASIFIKASI_ID,2)) AS KOMODITI, dbo.GOLONGAN_SAMPEL(LEFT(A.KLASIFIKASI_ID,4)) AS KATEGORI, dbo.GOLONGAN_SAMPEL(LEFT(A.KLASIFIKASI_ID,6)) AS [SUB KATEGORI], CASE WHEN LEN(KLASIFIKASI_ID) > 6 THEN dbo.GOLONGAN_SAMPEL(LEFT(A.KLASIFIKASI_ID,8)) ELSE '' END AS [SUB SUB KATEGORI], CASE WHEN LEN(KLASIFIKASI_ID) > 8 THEN dbo.GOLONGAN_SAMPEL(LEFT(KLASIFIKASI_ID,10)) ELSE '' END AS [SUB SUB SUB KATEGORI] FROM M_GOLONGAN A WHERE LEN(A.KLASIFIKASI_ID) > 4";
			
			
			$this->newtable->columns(array("A.KLASIFIKASI_ID", "dbo.GOLONGAN_SAMPEL(LEFT(A.KLASIFIKASI_ID,2))", "dbo.GOLONGAN_SAMPEL(LEFT(A.KLASIFIKASI_ID,4))", "dbo.GOLONGAN_SAMPEL(LEFT(A.KLASIFIKASI_ID,6))", "CASE WHEN LEN(KLASIFIKASI_ID) > 6 THEN dbo.GOLONGAN_SAMPEL(LEFT(A.KLASIFIKASI_ID,8)) ELSE '' END", "CASE WHEN LEN(KLASIFIKASI_ID) > 8 THEN dbo.GOLONGAN_SAMPEL(LEFT(KLASIFIKASI_ID,10)) ELSE '' END"));
			$this->newtable->width(array('KOMODITI' => 100, 'KATEGORI' => 150, 'SUB KATEGORI' => 150, 'SUB SUB KATEGORI' => 150, 'SUB SUB SUB KATEGORI' => 150));
			$tabel = $this->newtable->generate($query);
			$arrdata = array('table' => $tabel,
							 'idjudul' => 'juduluji',
							 'caption_header' => 'Daftar Kategori Standar Ruang Lingkup',
							 'batal' => '',
							 'cancel' => '');
			return $arrdata;
		}else{
			$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
		}
	}
	
	function get_golongan($id){
		if((in_array('1', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('9', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('4', $this->newsession->userdata('SESS_KODE_ROLE'))) && $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$sipt->load->model("main", "main", true);
			if($id==""){
				$arrdata = array('act' => site_url().'/post/master/golongan/simpan',				
								 'batal' => site_url().'/home/master/golongan',
								 'sess' => '',
								 'id' => '',
								 'sess' => '',
								 'save' => 'Simpan',
								 'cancel' => 'Batal');
			}else{
				#$query = "SELECT LEFT(KLASIFIKASI_ID,2) AS KOMODITI, LEFT(KLASIFIKASI_ID,4) AS KATEGORI, LEFT(KLASIFIKASI_ID,6) AS SUB_KATEGORI, LEFT(KLASIFIKASI_ID,8) AS SUB_SUB_KATEGORI, CASE WHEN LEN(RTRIM(LTRIM(KLASIFIKASI_ID))) > 8 THEN LEFT(KLASIFIKASI_ID,10) ELSE '' END AS SUB_SUB_SUB_KATEGORI, RTRIM(LTRIM(KLASIFIKASI_ID)) AS KLASIFIKASI_ID FROM M_GOLONGAN WHERE KLASIFIKASI_ID = '".$id."'";
				$query = "SELECT RTRIM(LTRIM(KLASIFIKASI_ID)) AS KLASIFIKASI_ID, 
CASE WHEN LEN(KLASIFIKASI_ID) > 2 THEN LEFT(KLASIFIKASI_ID,2) ELSE '' END AS KOMODITI,
CASE WHEN LEN(KLASIFIKASI_ID) >= 4 THEN LEFT(KLASIFIKASI_ID,4) ELSE '' END AS KATEGORI,
CASE WHEN LEN(KLASIFIKASI_ID) >= 6 THEN LEFT(KLASIFIKASI_ID,6) ELSE '' END AS SUB_KATEGORI,
CASE WHEN LEN(KLASIFIKASI_ID) >= 8 THEN LEFT(KLASIFIKASI_ID,8) ELSE '' END AS SUB_SUB_KATEGORI,
CASE WHEN LEN(KLASIFIKASI_ID) = 10 THEN KLASIFIKASI_ID ELSE '' END AS SUB_SUB_SUB_KATEGORI,
dbo.GOLONGAN_SAMPEL(LEFT(KLASIFIKASI_ID,2)) AS UR_KOMODITI, 
dbo.GOLONGAN_SAMPEL(LEFT(KLASIFIKASI_ID,4)) AS UR_KATEGORI, 
CASE WHEN LEN(KLASIFIKASI_ID) > 4 THEN dbo.GOLONGAN_SAMPEL(LEFT(KLASIFIKASI_ID,6)) ELSE '' END AS UR_SUB_KATEGORI, 
CASE WHEN LEN(KLASIFIKASI_ID) > 6 THEN dbo.GOLONGAN_SAMPEL(LEFT(KLASIFIKASI_ID,8)) ELSE '' END AS UR_SUB_SUB_KATEGORI, 
CASE WHEN LEN(KLASIFIKASI_ID) > 8 THEN dbo.GOLONGAN_SAMPEL(LEFT(KLASIFIKASI_ID,10)) ELSE '' END AS UR_SUB_SUB_SUB_KATEGORI, 
REPLACE(dbo.KATEGORI(LTRIM(RTRIM(KLASIFIKASI_ID)),'0'),' &raquo; ','][') AS URAIAN 
FROM M_GOLONGAN WHERE KLASIFIKASI_ID = '".$id."'";
				$data = $sipt->main->get_result($query);
				if($data){
					foreach($query->result_array() as $row){
						$arrdata = array('sess' => $row,
										 'act' => site_url().'/post/master/golongan/update',
										 'id' => $row['KLASIFIKASI_ID'],
										 'save' => 'Update',
										 'cancel' => 'Kembali');
					}
					$arrdata['uraian'] = explode("][",$row['URAIAN']);
					/*$arrdata['sel'][0] = substr($row['KLASIFIKASI_ID'],0,4);
					$arrdata['sel'][1] = substr($row['KLASIFIKASI_ID'],0,6);
					$arrdata['sel'][2] = substr($row['KLASIFIKASI_ID'],0,8);
					$arrdata['sel'][3] = $row['KLASIFIKASI_ID'];
					$arrdata['selkategori'][0] = $sipt->main->combobox("SELECT LTRIM(RTRIM(KLASIFIKASI_ID)) AS KLASIFIKASI_ID, KLASIFIKASI FROM M_GOLONGAN WHERE KLASIFIKASI_ID LIKE '".substr($row['KLASIFIKASI_ID'],0,2)."%__' AND LEN(KLASIFIKASI_ID) = '4' ORDER BY KLASIFIKASI_ID ASC", "KLASIFIKASI_ID", "KLASIFIKASI", TRUE);
					$arrdata['selkategori'][1] = $sipt->main->combobox("SELECT LTRIM(RTRIM(KLASIFIKASI_ID)) AS KLASIFIKASI_ID, KLASIFIKASI FROM M_GOLONGAN WHERE KLASIFIKASI_ID LIKE '".substr($row['KLASIFIKASI_ID'],0,4)."%__' AND LEN(KLASIFIKASI_ID) = '6' ORDER BY KLASIFIKASI_ID ASC", "KLASIFIKASI_ID", "KLASIFIKASI", TRUE);
					$arrdata['selkategori'][2] = $sipt->main->combobox("SELECT LTRIM(RTRIM(KLASIFIKASI_ID)) AS KLASIFIKASI_ID, KLASIFIKASI FROM M_GOLONGAN WHERE KLASIFIKASI_ID LIKE '".substr($row['KLASIFIKASI_ID'],0,6)."%__' AND LEN(KLASIFIKASI_ID) = '8' ORDER BY KLASIFIKASI_ID ASC", "KLASIFIKASI_ID", "KLASIFIKASI", TRUE);
					$arrdata['selkategori'][3] = $sipt->main->combobox("SELECT LTRIM(RTRIM(KLASIFIKASI_ID)) AS KLASIFIKASI_ID, KLASIFIKASI FROM M_GOLONGAN WHERE KLASIFIKASI_ID LIKE '".substr($row['KLASIFIKASI_ID'],0,8)."%__' AND LEN(KLASIFIKASI_ID) = '10' ORDER BY KLASIFIKASI_ID ASC", "KLASIFIKASI_ID", "KLASIFIKASI", TRUE); */
				}
			}
			$arrdata['golongan'] = $sipt->main->combobox("SELECT KLASIFIKASI_ID, KLASIFIKASI FROM M_GOLONGAN WHERE LEN(KLASIFIKASI_ID) = 2","KLASIFIKASI_ID", "KLASIFIKASI", TRUE);
			return $arrdata;
		}else{
			$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
		}
	}
	
	function set_golongan($action, $isajax){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main","main", true);
			if($action=="simpan"){
				$digit = 2;
				$golongan = array_filter($this->input->post('GOLONGAN'));
				$induk = $golongan[count($golongan)-1];
				$pjinduk = strlen($induk);
				$child = $pjinduk+2;
				$no = (int)$sipt->main->get_uraian("SELECT MAX(KLASIFIKASI_ID) AS MAXID FROM M_GOLONGAN WHERE LEN(KLASIFIKASI_ID) = '".$child."' AND KLASIFIKASI_ID LIKE '".$induk."%__'","MAXID") + 1;
				$seri = substr(str_repeat("0", $digit).$no, -$digit);
				$urut = $induk.$seri;
				$arrgolongan = array('KLASIFIKASI_ID' => $urut,
									 'KLASIFIKASI' => $this->input->post('KLASIFIKASI'),
									 'CREATE_DATE' => 'GETDATE()',
									 'CREATE_BY' => $this->newsession->userdata('SESS_USER_ID'));
				if($this->db->insert('M_GOLONGAN', $arrgolongan)){
					 return "MSG#YES#Data berhasil disimpan.#".site_url().'/home/master/golongan';
				}else{
					return "MSG#NO#Data Gagal Disimpan";
				}
				if($isajax!="ajax"){
					redirect(site_url().'/home/master/golongan');
					exit();
				}
			}else if($action == "update"){
				$arrgolongan = array('KLASIFIKASI' => $this->input->post('KLASIFIKASI'));
				$this->db->where('KLASIFIKASI_ID', $this->input->post('KLASIFIKASI_ID'));
				if($this->db->update('M_GOLONGAN', $arrgolongan)){
					return "MSG#YES#Data berhasil diupdate#".site_url().'/home/master/golongan';
				}else{
					return "MSG#NO#Data Gagal Diupdate";
				}
				if($isajax!="ajax"){
					redirect(base_url());
					exit();
				}
			}
		}else{
			$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
		}		
	}
	
	function show_srl(){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main","main", true);
			$query = "SELECT A.KLASIFIKASI_ID, A.KLASIFIKASI, COUNT(*) AS JML 
FROM M_GOLONGAN A LEFT JOIN M_SRL B ON A.KLASIFIKASI_ID = SUBSTRING(B.GOLONGAN,1,2) 
WHERE LEN(A.KLASIFIKASI_ID) = 2 AND A.KLASIFIKASI_ID <> '01' GROUP BY KLASIFIKASI_ID, KLASIFIKASI ORDER BY 1 ASC";
			$data = $sipt->main->get_result($query);
			if($data){
				foreach($query->result_array() as $row){
					$srlall['klasifikasi'][] = $row;
				}
			}
			$qobat = "SELECT A.KLASIFIKASI_ID, A.KLASIFIKASI, COUNT(*) AS JML 
FROM M_GOLONGAN A LEFT JOIN M_SRL B ON A.KLASIFIKASI_ID = SUBSTRING(B.GOLONGAN,1,4) 
WHERE LEN(A.KLASIFIKASI_ID) = 4 AND LEFT(A.KLASIFIKASI_ID,2) = '01' GROUP BY KLASIFIKASI_ID, KLASIFIKASI ORDER BY 1 ASC";
			$dobat = $sipt->main->get_result($qobat);
			if($dobat){
				foreach($qobat->result_array() as $robat){
					$srlobat['klasifikasio'][] = $robat;
				}
			}
			$arrdata['srl'] = array_merge($srlall, $srlobat);
			return $arrdata;
		}
	}
	
	function list_new_srl($kategori){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$sipt->load->model("main", "main", true);
			$this->load->library('newtable');
			if(strlen($kategori) == 2){
				if($kategori == "10" || $kategori == "11" || $kategori == "12"){
					$query = "SELECT SRL_ID, CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END AS [BIDANG UJI], dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,4)) AS KATEGORI, dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,6)) AS [SUB KATEGORI],CASE WHEN LEN(LTRIM(RTRIM(GOLONGAN))) > 6 THEN dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,8)) ELSE '' END AS [SUB SUB KATEGORI], PARAMETER_UJI AS [PARAMETER UJI], PUSTAKA, METODE, SYARAT, PRIORITAS FROM M_SRL WHERE LEFT(GOLONGAN,2) = '".$kategori."' AND STATUS IN ('2','9') AND VERIFI = '01'";
					$this->newtable->columns(array("SRL_ID", "CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END", "dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,4))","dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,6))", "CASE WHEN LEN(LTRIM(RTRIM(GOLONGAN))) > 6 THEN dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,8)) ELSE '' END" ,"PARAMETER_UJI", "PUSTAKA", "METODE", "SYARAT", "PRIORITAS"));
					$this->newtable->width(array('BIDANG UJI' => 75,'KATEGORI' => 200, 'SUB KATEGORI' => 200, 'SUB SUB KATEGORI' => 200, 'PARAMETER UJI' => 200, 'PUSTAKA' => 150, 'METODE' => 150, 'SYARAT' => 150, 'PRIORITAS' => 50));
					$this->newtable->search(array(array("CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END", "Berdasarkan Bidang Pengujian"), array("dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,4))", "Berdasarkan Kategori"), array("dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,6))", "Berdasarkan Sub Kategori"), array("CASE WHEN LEN(LTRIM(RTRIM(GOLONGAN))) > 6 THEN dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,8)) ELSE '' END", "Berdasarkan Sub Sub Kategori"), array("PARAMETER_UJI", "Berdasarkan Parameter Uji"),array("PUSTAKA", "Berdasarkan Pustaka"),array("METODE", "Berdasarkan Metode"),array("SYARAT", "Berdasarkan Syarat"), array("PRIORITAS","Berdasarkan Prioritas")));
				}else if($kategori == "13"){
					$query = "SELECT SRL_ID, CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END AS [BIDANG UJI], dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,4)) AS KATEGORI, dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,6)) AS [JENIS PANGAN], dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,8)) AS [PRODUK PANGAN], PARAMETER_UJI AS [PARAMETER UJI], PUSTAKA, METODE, SYARAT, PRIORITAS FROM M_SRL WHERE LEFT(GOLONGAN,2) = '".$kategori."' AND STATUS IN ('2','9') AND VERIFI = '01'";
					$this->newtable->columns(array("SRL_ID", "CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END", "dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,4))","dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,6))","dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,8))","PARAMETER_UJI", "PUSTAKA", "METODE", "SYARAT", "PRIORITAS"));
					$this->newtable->width(array('BIDANG UJI' => 75,'KATEGORI' => 200, 'JENIS PANGAN' => 200, 'PRODUK PANGAN' => 200,'PARAMETER UJI' => 200, 'PUSTAKA' => 150, 'METODE' => 150, 'SYARAT' => 150, 'PRIORITAS' => 50));
					$this->newtable->search(array(array("CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END", "Berdasarkan Bidang Pengujian"), array("dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,4))", "Berdasarkan Kategori"), array("dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,6))", "Berdasarkan Jenis Pangan"),array("dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,8))", "Berdasarkan Produk Pangan"), array("PARAMETER_UJI", "Berdasarkan Parameter Uji"),array("PUSTAKA", "Berdasarkan Pustaka"),array("METODE", "Berdasarkan Metode"),array("SYARAT", "Berdasarkan Syarat"), array("PRIORITAS","Berdasarkan Prioritas")));
				}else if($kategori == "14"){
					$query = "SELECT SRL_ID, CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END AS [BIDANG UJI], dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,4)) AS [BAHAN KEMASAN] , dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,6)) AS [JENIS KEMASAN], PARAMETER_UJI AS [PARAMETER UJI], PUSTAKA, METODE, SYARAT, PRIORITAS FROM M_SRL WHERE LEFT(GOLONGAN,2) = '".$kategori."' AND STATUS IN ('2','9') AND VERIFI = '01'";
					$this->newtable->columns(array("SRL_ID", "CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END", "dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,4))","dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,6))","PARAMETER_UJI", "PUSTAKA", "METODE", "SYARAT", "PRIORITAS"));
					$this->newtable->width(array('BIDANG UJI' => 75,'BAHAN KEMASAN' => 200, 'JENIS KEMASAN' => 200, 'PARAMETER UJI' => 200, 'PUSTAKA' => 150, 'METODE' => 150, 'SYARAT' => 150, 'PRIORITAS' => 50));
					$this->newtable->search(array(array("CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END", "Berdasarkan Bidang Pengujian"), array("dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,4))", "Berdasarkan Bahan Kemasan"), array("dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,6))", "Berdasarkan Jenis Kemasan"), array("PARAMETER_UJI", "Berdasarkan Parameter Uji"),array("PUSTAKA", "Berdasarkan Pustaka"),array("METODE", "Berdasarkan Metode"),array("SYARAT", "Berdasarkan Syarat"), array("PRIORITAS","Berdasarkan Prioritas")));
				}else if($kategori == "20"){
					$query = "SELECT SRL_ID, CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END AS [BIDANG UJI], dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,8)) AS [BENTUK SEDIAAN] , dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,10)) AS [ZAT AKTIF], PARAMETER_UJI AS [PARAMETER UJI], PUSTAKA, METODE, SYARAT, PRIORITAS FROM M_SRL WHERE LEFT(GOLONGAN,2) = '".$kategori."' AND STATUS IN ('2','9') AND VERIFI = '01'";
					$this->newtable->columns(array("SRL_ID", "CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END", "dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,8))","dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,10))","PARAMETER_UJI", "PUSTAKA", "METODE", "SYARAT", "PRIORITAS"));
					$this->newtable->width(array('BIDANG UJI' => 75,'BENTUK SEDIAAN' => 200, 'ZAT AKTIF' => 200, 'PARAMETER UJI' => 200, 'PUSTAKA' => 150, 'METODE' => 150, 'SYARAT' => 150, 'PRIORITAS' => 50));
					$this->newtable->search(array(array("CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END", "Berdasarkan Bidang Pengujian"), array("dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,8))", "Berdasarkan Bentuk Sediaan"), array("dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,10))", "Berdasarkan Zat Aktif"), array("PARAMETER_UJI", "Berdasarkan Parameter Uji"),array("PUSTAKA", "Berdasarkan Pustaka"),array("METODE", "Berdasarkan Metode"),array("SYARAT", "Berdasarkan Syarat"), array("PRIORITAS","Berdasarkan Prioritas")));
				}else if($kategori == "02"){
					$query = "SELECT SRL_ID, CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END AS [BIDANG UJI], dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,4)) AS [KATEGORI] , dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,6)) AS [SUB KATEGORI], PARAMETER_UJI AS [PARAMETER UJI], PUSTAKA, METODE, SYARAT, PRIORITAS FROM M_SRL WHERE LEFT(GOLONGAN,2) = '".$kategori."' AND STATUS IN ('2','9') AND VERIFI = '01'";
					$this->newtable->columns(array("SRL_ID", "CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END", "dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,4))","dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,6))","PARAMETER_UJI", "PUSTAKA", "METODE", "SYARAT", "PRIORITAS"));
					$this->newtable->width(array('BIDANG UJI' => 75,'KATEGORI' => 200, 'SUB KATEGORI' => 200, 'PARAMETER UJI' => 200, 'PUSTAKA' => 150, 'METODE' => 150, 'SYARAT' => 150, 'PRIORITAS' => 50));
					$this->newtable->search(array(array("CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END", "Berdasarkan Bidang Pengujian"), array("dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,4))", "Berdasarkan Kategori"), array("dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,6))", "Berdasarkan Sub Kategori"),array("PUSTAKA", "Berdasarkan Pustaka"),array("METODE", "Berdasarkan Metode"),array("SYARAT", "Berdasarkan Syarat"), array("PRIORITAS","Berdasarkan Prioritas")));
				}else if($kategori == "03" || $kategori == "07"){
					$query = "SELECT SRL_ID, CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END AS [BIDANG UJI], dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,4)) AS [KATEGORI], PARAMETER_UJI AS [PARAMETER UJI], PUSTAKA, METODE, SYARAT, PRIORITAS FROM M_SRL WHERE LEFT(GOLONGAN,2) = '".$kategori."' AND STATUS IN ('2','9') AND VERIFI = '01'";
					$this->newtable->columns(array("SRL_ID", "CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END", "dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,4))","PARAMETER_UJI", "PUSTAKA", "METODE", "SYARAT", "PRIORITAS"));
					$this->newtable->width(array('BIDANG UJI' => 75,'KATEGORI' => 200, 'PARAMETER UJI' => 200, 'PUSTAKA' => 150, 'METODE' => 150, 'SYARAT' => 150, 'PRIORITAS' => 50));
					$this->newtable->search(array(array("CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END", "Berdasarkan Bidang Pengujian"), array("dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,4))", "Berdasarkan Kategori"),array("PUSTAKA", "Berdasarkan Pustaka"),array("METODE", "Berdasarkan Metode"),array("SYARAT", "Berdasarkan Syarat"), array("PRIORITAS","Berdasarkan Prioritas")));
				}
			}else if(strlen($kategori) == "4"){
				if($kategori == "0101" || $kategori == "0104"){
					$query = "SELECT SRL_ID, CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END AS [BIDANG UJI], dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,6)) AS [BENTUK SEDIAAN] , dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,8)) AS [ZAT AKTIF], PARAMETER_UJI AS [PARAMETER UJI], PUSTAKA, METODE, SYARAT, PRIORITAS FROM M_SRL WHERE LEFT(GOLONGAN,4) = '".$kategori."' AND STATUS IN ('2','9') AND VERIFI = '01'";
					$this->newtable->columns(array("SRL_ID", "CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END", "dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,6))","dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,8))","PARAMETER_UJI", "PUSTAKA", "METODE", "SYARAT", "PRIORITAS"));
					$this->newtable->width(array('BIDANG UJI' => 75,'BENTUK SEDIAAN' => 200, 'ZAT AKTIF' => 200, 'PARAMETER UJI' => 200, 'PUSTAKA' => 150, 'METODE' => 150, 'SYARAT' => 150, 'PRIORITAS' => 50));
					$this->newtable->search(array(array("CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END", "Berdasarkan Bidang Pengujian"), array("dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,6))", "Berdasarkan Bentuk Sediaan"), array("dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,8))", "Berdasarkan Zat Aktif"), array("PARAMETER_UJI", "Berdasarkan Parameter Uji"),array("PUSTAKA", "Berdasarkan Pustaka"),array("METODE", "Berdasarkan Metode"),array("SYARAT", "Berdasarkan Syarat"), array("PRIORITAS","Berdasarkan Prioritas")));
				}else if($kategori == "0102"){
					$query = "SELECT SRL_ID, CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END AS [BIDANG UJI], dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,6)) AS [ZAT AKTIF] , dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,8)) AS [BENTUK SEDIAAN], PARAMETER_UJI AS [PARAMETER UJI], PUSTAKA, METODE, SYARAT, PRIORITAS FROM M_SRL WHERE LEFT(GOLONGAN,4) = '".$kategori."' AND STATUS IN ('2','9') AND VERIFI = '01'";
					$this->newtable->columns(array("SRL_ID", "CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END", "dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,6))","dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,8))","PARAMETER_UJI", "PUSTAKA", "METODE", "SYARAT", "PRIORITAS"));
					$this->newtable->width(array('BIDANG UJI' => 75,'ZAT AKTIF' => 200, 'BENTUK SEDIAAN' => 200, 'PARAMETER UJI' => 200, 'PUSTAKA' => 150, 'METODE' => 150, 'SYARAT' => 150, 'PRIORITAS' => 50));
					$this->newtable->search(array(array("CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END", "Berdasarkan Bidang Pengujian"), array("dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,6))", "Berdasarkan Zat Aktif"), array("dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,8))", "Berdasarkan Bentuk Sediaan"), array("PARAMETER_UJI", "Berdasarkan Parameter Uji"),array("PUSTAKA", "Berdasarkan Pustaka"),array("METODE", "Berdasarkan Metode"),array("SYARAT", "Berdasarkan Syarat"), array("PRIORITAS","Berdasarkan Prioritas")));
				}else if($kategori == "0103"){
					$query = "SELECT SRL_ID, CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END AS [BIDANG UJI], dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,6)) AS [NAMA OBAT] , dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,8)) AS [ZAT AKTIF], PARAMETER_UJI AS [PARAMETER UJI], PUSTAKA, METODE, SYARAT, PRIORITAS FROM M_SRL WHERE LEFT(GOLONGAN,4) = '".$kategori."' AND STATUS IN ('2','9') AND VERIFI = '01'";
					$this->newtable->columns(array("SRL_ID", "CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END", "dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,6))","dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,8))","PARAMETER_UJI", "PUSTAKA", "METODE", "SYARAT", "PRIORITAS"));
					$this->newtable->width(array('BIDANG UJI' => 75,'NAMA OBAT' => 200, 'ZAT AKTIF' => 200, 'PARAMETER UJI' => 200, 'PUSTAKA' => 150, 'METODE' => 150, 'SYARAT' => 150, 'PRIORITAS' => 50));
					$this->newtable->search(array(array("CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END", "Berdasarkan Bidang Pengujian"), array("dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,6))", "Berdasarkan Nama Obat"), array("dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,8))", "Berdasarkan Zat Aktif"), array("PARAMETER_UJI", "Berdasarkan Parameter Uji"),array("PUSTAKA", "Berdasarkan Pustaka"),array("METODE", "Berdasarkan Metode"),array("SYARAT", "Berdasarkan Syarat"), array("PRIORITAS","Berdasarkan Prioritas")));
				}else if($kategori == "0105" || $kategori == "0106" || $kategori == "0107"){
					$query = "SELECT SRL_ID, CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END AS [BIDANG UJI], dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,6)) AS [BENTUK SEDIAAN], dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,8)) AS [NAMA OBAT], dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,10)) AS [ZAT AKTIF], PARAMETER_UJI, PUSTAKA, METODE, SYARAT, PRIORITAS FROM M_SRL WHERE LEFT(GOLONGAN,4) = '".$kategori."' AND STATUS IN ('2','9') AND VERIFI = '01'";
					$this->newtable->columns(array("SRL_ID", "CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END", "dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,6))","dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,8))","dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,10))","PARAMETER_UJI", "PUSTAKA", "METODE", "SYARAT", "PRIORITAS"));
					$this->newtable->width(array('BIDANG UJI' => 75,'BENTUK SEDIAAN' => 200, 'NAMA OBAT' => 200,'ZAT AKTIF' => 200,'PARAMETER UJI' => 200, 'PUSTAKA' => 150, 'METODE' => 150, 'SYARAT' => 150, 'PRIORITAS' => 50));
					$this->newtable->search(array(array("CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END", "Berdasarkan Bidang Pengujian"), array("dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,6))", "Berdasarkan Bentuk Sediaan"), array("dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,8))", "Berdasarkan Nama Obat"),array("dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,10))", "Berdasarkan Zat Aktif"), array("PARAMETER_UJI", "Berdasarkan Parameter Uji"),array("PUSTAKA", "Berdasarkan Pustaka"),array("METODE", "Berdasarkan Metode"),array("SYARAT", "Berdasarkan Syarat"), array("PRIORITAS","Berdasarkan Prioritas")));
				}else if($kategori == "0108"){
					$query = "SELECT SRL_ID, CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END AS [BIDANG UJI], dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,6)) AS [NAMA OBAT], dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,8)) AS [BENTUK SEDIAAN], PARAMETER_UJI AS [PARAMETER UJI], PUSTAKA, METODE, SYARAT, PRIORITAS FROM M_SRL WHERE LEFT(GOLONGAN,4) = '".$kategori."' AND STATUS IN ('2','9') AND VERIFI = '01'";
					$this->newtable->columns(array("SRL_ID", "CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END", "dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,6))","dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,8))","PARAMETER_UJI", "PUSTAKA", "METODE", "SYARAT", "PRIORITAS"));
					$this->newtable->width(array('BIDANG UJI' => 75,'NAMA OBAT' => 200, 'BENTUK SEDIAAN' => 200,'PARAMETER UJI' => 200, 'PUSTAKA' => 150, 'METODE' => 150, 'SYARAT' => 150, 'PRIORITAS' => 50));
					$this->newtable->search(array(array("CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END", "Berdasarkan Bidang Pengujian"), array("dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,6))", "Berdasarkan Nama Obat"), array("dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,8))", "Berdasarkan Bentuk Sediaan"), array("PARAMETER_UJI", "Berdasarkan Parameter Uji"),array("PUSTAKA", "Berdasarkan Pustaka"),array("METODE", "Berdasarkan Metode"),array("SYARAT", "Berdasarkan Syarat"), array("PRIORITAS","Berdasarkan Prioritas")));
					
				}else if($kategori == "0109" || $kategori == "0110" || $kategori == "0111"){
					$query = "SELECT SRL_ID, CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END AS [BIDANG UJI], dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,6)) AS [BENTUK SEDIAAN], dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,8)) AS [NAMA OBAT], PARAMETER_UJI, PUSTAKA, METODE, SYARAT, PRIORITAS FROM M_SRL WHERE LEFT(GOLONGAN,4) = '".$kategori."' AND STATUS IN ('2','9') AND VERIFI = '01'";
					$this->newtable->columns(array("SRL_ID", "CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END", "dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,6))","dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,8))","PARAMETER_UJI", "PUSTAKA", "METODE", "SYARAT", "PRIORITAS"));
					$this->newtable->width(array('BIDANG UJI' => 75,'BENTUK SEDIAAN' => 200, 'NAMA OBAT' => 200,'PARAMETER UJI' => 200, 'PUSTAKA' => 150, 'METODE' => 150, 'SYARAT' => 150, 'PRIORITAS' => 50));
					$this->newtable->search(array(array("CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END", "Berdasarkan Bidang Pengujian"), array("dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,6))", "Berdasarkan Bentuk Sediaan"), array("dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,8))", "Berdasarkan Nama Obat"), array("PARAMETER_UJI", "Berdasarkan Parameter Uji"),array("PUSTAKA", "Berdasarkan Pustaka"),array("METODE", "Berdasarkan Metode"),array("SYARAT", "Berdasarkan Syarat"), array("PRIORITAS","Berdasarkan Prioritas")));
				}
			}
			if(in_array('1', $this->newsession->userdata('SESS_KODE_ROLE')) || (in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')) || $this->newsession->userdata('SESS_BBPOM_ID') == "99")){
				$proses['SRL Pengujian Baru'] = array('GET',site_url().'/home/master/srlpengujian/new','0');
				#$proses['Edit SRL Pengujian'] = array('GET',site_url().'/home/master/srlpengujian/new','1');
				#if(in_array('1', $this->newsession->userdata('SESS_KODE_ROLE'))){
				$proses['Edit SRL Pengujian'] = array('MPOST', site_url()."/post/master/srl/view/ajax", '1');
				#}
				$proses['Hapus SRL Pengujian'] = array('POST', site_url()."/post/master/srlpengujian/hapus/ajax", 'N');
			}
			$this->newtable->orderby(1);
			$this->newtable->sortby("ASC");
			$this->newtable->keys(array('SRL_ID'));
			$this->newtable->hiddens(array('SRL_ID'));
			$this->newtable->action(site_url()."/home/master/parameter-uji/view/".$kategori);
			$this->newtable->cidb($this->db);
			$this->newtable->ciuri($this->uri->segment_array());
			$this->newtable->menu($proses);
			$tabel = $this->newtable->generate($query); 
			$komoditi = $sipt->main->get_uraian("SELECT dbo.KATEGORI('".$kategori."','0') AS KOMODITI","KOMODITI");
			$arrdata = array('table' => $tabel,
							 'idjudul' => 'juduluji',
							 'caption_header' => 'Standar Ruang Lingkup Pengujian - '.$komoditi,
							 'batal' => '',
							 'cancel' => '');
			return $arrdata;
		}
	}

	function list_verifikasi_srl($kategori){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$sipt->load->model("main", "main", true);
			$this->load->library('newtable');
			if(strlen($kategori) == 2){
				if($kategori == "10" || $kategori == "11" || $kategori == "12"){
					$query = "SELECT SRL_ID, CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END AS [BIDANG UJI], dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,4)) AS KATEGORI, dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,6)) AS [SUB KATEGORI], CASE WHEN LEN(LTRIM(RTRIM(GOLONGAN))) > 6 THEN dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,8)) ELSE '' END AS [SUB SUB KATEGORI], PARAMETER_UJI AS [PARAMETER UJI], PUSTAKA, METODE, SYARAT, PRIORITAS FROM M_SRL WHERE LEFT(GOLONGAN,2) = '".$kategori."' AND STATUS = 2 AND VERIFI = '00'";
					$this->newtable->columns(array("SRL_ID", "CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END", "dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,4))","dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,6))","CASE WHEN LEN(LTRIM(RTRIM(GOLONGAN))) > 6 THEN dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,8)) ELSE '' END", "PARAMETER_UJI", "PUSTAKA", "METODE", "SYARAT", "PRIORITAS"));
					$this->newtable->width(array('BIDANG UJI' => 75,'KATEGORI' => 200, 'SUB KATEGORI' => 200, 'SUB SUB KATEGORI','PARAMETER UJI' => 200, 'PUSTAKA' => 150, 'METODE' => 150, 'SYARAT' => 150, 'PRIORITAS' => 50));
					$this->newtable->search(array(array("CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END", "Berdasarkan Bidang Pengujian"), array("dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,4))", "Berdasarkan Kategori"), array("dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,6))", "Berdasarkan Sub Kategori"),array("CASE WHEN LEN(LTRIM(RTRIM(GOLONGAN))) > 6 THEN dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,8)) ELSE '' END","Berdasarkan Sub Sub Kategori"), array("PARAMETER_UJI", "Berdasarkan Parameter Uji"),array("PUSTAKA", "Berdasarkan Pustaka"),array("METODE", "Berdasarkan Metode"),array("SYARAT", "Berdasarkan Syarat"), array("PRIORITAS","Berdasarkan Prioritas")));
				}else if($kategori == "13"){
					$query = "SELECT SRL_ID, CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END AS [BIDANG UJI], dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,4)) AS KATEGORI, dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,6)) AS [JENIS PANGAN], dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,8)) AS [PRODUK PANGAN], PARAMETER_UJI AS [PARAMETER UJI], PUSTAKA, METODE, SYARAT, PRIORITAS FROM M_SRL WHERE LEFT(GOLONGAN,2) = '".$kategori."' AND STATUS = 2 AND VERIFI = '00'";
					$this->newtable->columns(array("SRL_ID", "CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END", "dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,4))","dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,6))","dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,8))","PARAMETER_UJI", "PUSTAKA", "METODE", "SYARAT", "PRIORITAS"));
					$this->newtable->width(array('BIDANG UJI' => 75,'KATEGORI' => 200, 'JENIS PANGAN' => 200, 'PRODUK PANGAN' => 200,'PARAMETER UJI' => 200, 'PUSTAKA' => 150, 'METODE' => 150, 'SYARAT' => 150, 'PRIORITAS' => 50));
					$this->newtable->search(array(array("CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END", "Berdasarkan Bidang Pengujian"), array("dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,4))", "Berdasarkan Kategori"), array("dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,6))", "Berdasarkan Jenis Pangan"),array("dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,8))", "Berdasarkan Produk Pangan"), array("PARAMETER_UJI", "Berdasarkan Parameter Uji"),array("PUSTAKA", "Berdasarkan Pustaka"),array("METODE", "Berdasarkan Metode"),array("SYARAT", "Berdasarkan Syarat"), array("PRIORITAS","Berdasarkan Prioritas")));
				}else if($kategori == "14"){
					$query = "SELECT SRL_ID, CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END AS [BIDANG UJI], dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,4)) AS [BAHAN KEMASAN] , dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,6)) AS [JENIS KEMASAN], PARAMETER_UJI AS [PARAMETER UJI], PUSTAKA, METODE, SYARAT, PRIORITAS FROM M_SRL WHERE LEFT(GOLONGAN,2) = '".$kategori."' AND STATUS = 2 AND VERIFI = '00'";
					$this->newtable->columns(array("SRL_ID", "CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END", "dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,4))","dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,6))","PARAMETER_UJI", "PUSTAKA", "METODE", "SYARAT", "PRIORITAS"));
					$this->newtable->width(array('BIDANG UJI' => 75,'BAHAN KEMASAN' => 200, 'JENIS KEMASAN' => 200, 'PARAMETER UJI' => 200, 'PUSTAKA' => 150, 'METODE' => 150, 'SYARAT' => 150, 'PRIORITAS' => 50));
					$this->newtable->search(array(array("CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END", "Berdasarkan Bidang Pengujian"), array("dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,4))", "Berdasarkan Bahan Kemasan"), array("dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,6))", "Berdasarkan Jenis Kemasan"), array("PARAMETER_UJI", "Berdasarkan Parameter Uji"),array("PUSTAKA", "Berdasarkan Pustaka"),array("METODE", "Berdasarkan Metode"),array("SYARAT", "Berdasarkan Syarat"), array("PRIORITAS","Berdasarkan Prioritas")));
				}else if($kategori == "20"){
					$query = "SELECT SRL_ID, CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END AS [BIDANG UJI], dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,8)) AS [BENTUK SEDIAAN] , dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,10)) AS [ZAT AKTIF], PARAMETER_UJI AS [PARAMETER UJI], PUSTAKA, METODE, SYARAT, PRIORITAS FROM M_SRL WHERE LEFT(GOLONGAN,2) = '".$kategori."' AND STATUS = 2 AND VERIFI = '00'";
					$this->newtable->columns(array("SRL_ID", "CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END", "dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,8))","dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,10))","PARAMETER_UJI", "PUSTAKA", "METODE", "SYARAT", "PRIORITAS"));
					$this->newtable->width(array('BIDANG UJI' => 75,'BENTUK SEDIAAN' => 200, 'ZAT AKTIF' => 200, 'PARAMETER UJI' => 200, 'PUSTAKA' => 150, 'METODE' => 150, 'SYARAT' => 150, 'PRIORITAS' => 50));
					$this->newtable->search(array(array("CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END", "Berdasarkan Bidang Pengujian"), array("dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,8))", "Berdasarkan Bentuk Sediaan"), array("dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,10))", "Berdasarkan Zat Aktif"), array("PARAMETER_UJI", "Berdasarkan Parameter Uji"),array("PUSTAKA", "Berdasarkan Pustaka"),array("METODE", "Berdasarkan Metode"),array("SYARAT", "Berdasarkan Syarat"), array("PRIORITAS","Berdasarkan Prioritas")));
				}else if($kategori == "02"){
					$query = "SELECT SRL_ID, CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END AS [BIDANG UJI], dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,4)) AS [KATEGORI] , dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,6)) AS [SUB KATEGORI], PARAMETER_UJI AS [PARAMETER UJI], PUSTAKA, METODE, SYARAT, PRIORITAS FROM M_SRL WHERE LEFT(GOLONGAN,2) = '".$kategori."'";
					$this->newtable->columns(array("SRL_ID", "CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END", "dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,4))","dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,6))","PARAMETER_UJI", "PUSTAKA", "METODE", "SYARAT", "PRIORITAS"));
					$this->newtable->width(array('BIDANG UJI' => 75,'KATEGORI' => 200, 'SUB KATEGORI' => 200, 'PARAMETER UJI' => 200, 'PUSTAKA' => 150, 'METODE' => 150, 'SYARAT' => 150, 'PRIORITAS' => 50));
					$this->newtable->search(array(array("CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END", "Berdasarkan Bidang Pengujian"), array("dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,4))", "Berdasarkan Kategori"), array("dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,6))", "Berdasarkan Sub Kategori"),array("PUSTAKA", "Berdasarkan Pustaka"),array("METODE", "Berdasarkan Metode"),array("SYARAT", "Berdasarkan Syarat"), array("PRIORITAS","Berdasarkan Prioritas")));
				}else if($kategori == "03" || $kategori == "07"){
					$query = "SELECT SRL_ID, CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END AS [BIDANG UJI], dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,4)) AS [KATEGORI], PARAMETER_UJI AS [PARAMETER UJI], PUSTAKA, METODE, SYARAT, PRIORITAS FROM M_SRL WHERE LEFT(GOLONGAN,2) = '".$kategori."'";
					$this->newtable->columns(array("SRL_ID", "CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END", "dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,4))","PARAMETER_UJI", "PUSTAKA", "METODE", "SYARAT", "PRIORITAS"));
					$this->newtable->width(array('BIDANG UJI' => 75,'KATEGORI' => 200, 'PARAMETER UJI' => 200, 'PUSTAKA' => 150, 'METODE' => 150, 'SYARAT' => 150, 'PRIORITAS' => 50));
					$this->newtable->search(array(array("CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END", "Berdasarkan Bidang Pengujian"), array("dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,4))", "Berdasarkan Kategori"),array("PUSTAKA", "Berdasarkan Pustaka"),array("METODE", "Berdasarkan Metode"),array("SYARAT", "Berdasarkan Syarat"), array("PRIORITAS","Berdasarkan Prioritas")));
				}
			}else if(strlen($kategori) == "4"){
				if($kategori == "0101" || $kategori == "0104"){
					$query = "SELECT SRL_ID, CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END AS [BIDANG UJI], dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,6)) AS [BENTUK SEDIAAN] , dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,8)) AS [ZAT AKTIF], PARAMETER_UJI AS [PARAMETER UJI], PUSTAKA, METODE, SYARAT, PRIORITAS FROM M_SRL WHERE LEFT(GOLONGAN,4) = '".$kategori."' AND STATUS = 2 AND VERIFI = '00'";
					$this->newtable->columns(array("SRL_ID", "CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END", "dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,6))","dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,8))","PARAMETER_UJI", "PUSTAKA", "METODE", "SYARAT", "PRIORITAS"));
					$this->newtable->width(array('BIDANG UJI' => 75,'BENTUK SEDIAAN' => 200, 'ZAT AKTIF' => 200, 'PARAMETER UJI' => 200, 'PUSTAKA' => 150, 'METODE' => 150, 'SYARAT' => 150, 'PRIORITAS' => 50));
					$this->newtable->search(array(array("CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END", "Berdasarkan Bidang Pengujian"), array("dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,6))", "Berdasarkan Bentuk Sediaan"), array("dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,8))", "Berdasarkan Zat Aktif"), array("PARAMETER_UJI", "Berdasarkan Parameter Uji"),array("PUSTAKA", "Berdasarkan Pustaka"),array("METODE", "Berdasarkan Metode"),array("SYARAT", "Berdasarkan Syarat"), array("PRIORITAS","Berdasarkan Prioritas")));
				}else if($kategori == "0102"){
					$query = "SELECT SRL_ID, CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END AS [BIDANG UJI], dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,6)) AS [ZAT AKTIF] , dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,8)) AS [BENTUK SEDIAAN], PARAMETER_UJI AS [PARAMETER UJI], PUSTAKA, METODE, SYARAT, PRIORITAS FROM M_SRL WHERE LEFT(GOLONGAN,4) = '".$kategori."' AND STATUS = 2 AND VERIFI = '00'";
					$this->newtable->columns(array("SRL_ID", "CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END", "dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,6))","dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,8))","PARAMETER_UJI", "PUSTAKA", "METODE", "SYARAT", "PRIORITAS"));
					$this->newtable->width(array('BIDANG UJI' => 75,'ZAT AKTIF' => 200, 'BENTUK SEDIAAN' => 200, 'PARAMETER UJI' => 200, 'PUSTAKA' => 150, 'METODE' => 150, 'SYARAT' => 150, 'PRIORITAS' => 50));
					$this->newtable->search(array(array("CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END", "Berdasarkan Bidang Pengujian"), array("dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,6))", "Berdasarkan Zat Aktif"), array("dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,8))", "Berdasarkan Bentuk Sediaan"), array("PARAMETER_UJI", "Berdasarkan Parameter Uji"),array("PUSTAKA", "Berdasarkan Pustaka"),array("METODE", "Berdasarkan Metode"),array("SYARAT", "Berdasarkan Syarat"), array("PRIORITAS","Berdasarkan Prioritas")));
				}else if($kategori == "0103"){
					$query = "SELECT SRL_ID, CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END AS [BIDANG UJI], dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,6)) AS [NAMA OBAT] , dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,8)) AS [ZAT AKTIF], PARAMETER_UJI AS [PARAMETER UJI], PUSTAKA, METODE, SYARAT, PRIORITAS FROM M_SRL WHERE LEFT(GOLONGAN,4) = '".$kategori."' AND STATUS = 2 AND VERIFI = '00'";
					$this->newtable->columns(array("SRL_ID", "CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END", "dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,6))","dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,8))","PARAMETER_UJI", "PUSTAKA", "METODE", "SYARAT", "PRIORITAS"));
					$this->newtable->width(array('BIDANG UJI' => 75,'NAMA OBAT' => 200, 'ZAT AKTIF' => 200, 'PARAMETER UJI' => 200, 'PUSTAKA' => 150, 'METODE' => 150, 'SYARAT' => 150, 'PRIORITAS' => 50));
					$this->newtable->search(array(array("CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END", "Berdasarkan Bidang Pengujian"), array("dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,6))", "Berdasarkan Nama Obat"), array("dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,8))", "Berdasarkan Zat Aktif"), array("PARAMETER_UJI", "Berdasarkan Parameter Uji"),array("PUSTAKA", "Berdasarkan Pustaka"),array("METODE", "Berdasarkan Metode"),array("SYARAT", "Berdasarkan Syarat"), array("PRIORITAS","Berdasarkan Prioritas")));
				}else if($kategori == "0105" || $kategori == "0106" || $kategori == "0107"){
					$query = "SELECT SRL_ID, CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END AS [BIDANG UJI], dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,6)) AS [BENTUK SEDIAAN], dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,8)) AS [NAMA OBAT], dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,10)) AS [ZAT AKTIF], PARAMETER_UJI, PUSTAKA, METODE, SYARAT, PRIORITAS FROM M_SRL WHERE LEFT(GOLONGAN,4) = '".$kategori."' AND STATUS = 2 AND VERIFI = '00'";
					$this->newtable->columns(array("SRL_ID", "CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END", "dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,6))","dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,8))","dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,10))","PARAMETER_UJI", "PUSTAKA", "METODE", "SYARAT", "PRIORITAS"));
					$this->newtable->width(array('BIDANG UJI' => 75,'BENTUK SEDIAAN' => 200, 'NAMA OBAT' => 200,'ZAT AKTIF' => 200,'PARAMETER UJI' => 200, 'PUSTAKA' => 150, 'METODE' => 150, 'SYARAT' => 150, 'PRIORITAS' => 50));
					$this->newtable->search(array(array("CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END", "Berdasarkan Bidang Pengujian"), array("dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,6))", "Berdasarkan Bentuk Sediaan"), array("dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,8))", "Berdasarkan Nama Obat"),array("dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,10))", "Berdasarkan Zat Aktif"), array("PARAMETER_UJI", "Berdasarkan Parameter Uji"),array("PUSTAKA", "Berdasarkan Pustaka"),array("METODE", "Berdasarkan Metode"),array("SYARAT", "Berdasarkan Syarat"), array("PRIORITAS","Berdasarkan Prioritas")));
				}else if($kategori == "0108"){
					$query = "SELECT SRL_ID, CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END AS [BIDANG UJI], dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,6)) AS [NAMA OBAT], dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,8)) AS [BENTUK SEDIAAN], PARAMETER_UJI AS [PARAMETER UJI], PUSTAKA, METODE, SYARAT, PRIORITAS FROM M_SRL WHERE LEFT(GOLONGAN,4) = '".$kategori."' AND STATUS = 2 AND VERIFI = '00'";
					$this->newtable->columns(array("SRL_ID", "CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END", "dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,6))","dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,8))","PARAMETER_UJI", "PUSTAKA", "METODE", "SYARAT", "PRIORITAS"));
					$this->newtable->width(array('BIDANG UJI' => 75,'NAMA OBAT' => 200, 'BENTUK SEDIAAN' => 200,'PARAMETER UJI' => 200, 'PUSTAKA' => 150, 'METODE' => 150, 'SYARAT' => 150, 'PRIORITAS' => 50));
					$this->newtable->search(array(array("CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END", "Berdasarkan Bidang Pengujian"), array("dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,6))", "Berdasarkan Nama Obat"), array("dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,8))", "Berdasarkan Bentuk Sediaan"), array("PARAMETER_UJI", "Berdasarkan Parameter Uji"),array("PUSTAKA", "Berdasarkan Pustaka"),array("METODE", "Berdasarkan Metode"),array("SYARAT", "Berdasarkan Syarat"), array("PRIORITAS","Berdasarkan Prioritas")));
					
				}else if($kategori == "0109" || $kategori == "0110" || $kategori == "0111"){
					$query = "SELECT SRL_ID, CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END AS [BIDANG UJI], dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,6)) AS [BENTUK SEDIAAN], dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,8)) AS [NAMA OBAT], PARAMETER_UJI, PUSTAKA, METODE, SYARAT, PRIORITAS FROM M_SRL WHERE LEFT(GOLONGAN,4) = '".$kategori."' AND STATUS = 2 AND VERIFI = '00'";
					$this->newtable->columns(array("SRL_ID", "CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END", "dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,6))","dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,8))","PARAMETER_UJI", "PUSTAKA", "METODE", "SYARAT", "PRIORITAS"));
					$this->newtable->width(array('BIDANG UJI' => 75,'BENTUK SEDIAAN' => 200, 'NAMA OBAT' => 200,'PARAMETER UJI' => 200, 'PUSTAKA' => 150, 'METODE' => 150, 'SYARAT' => 150, 'PRIORITAS' => 50));
					$this->newtable->search(array(array("CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END", "Berdasarkan Bidang Pengujian"), array("dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,6))", "Berdasarkan Bentuk Sediaan"), array("dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,8))", "Berdasarkan Nama Obat"), array("PARAMETER_UJI", "Berdasarkan Parameter Uji"),array("PUSTAKA", "Berdasarkan Pustaka"),array("METODE", "Berdasarkan Metode"),array("SYARAT", "Berdasarkan Syarat"), array("PRIORITAS","Berdasarkan Prioritas")));
				}
			}
			if((in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')) || $this->newsession->userdata('SESS_BBPOM_ID') == "99" || $this->newsession->userdata('SESS_BBPOM_ID') == "00")){
				$proses['Preview Data Parameter'] = array('GET',site_url().'/home/master/parameter-uji/preview','1');
			}
			$this->newtable->orderby(1);
			$this->newtable->sortby("ASC");
			$this->newtable->keys(array('SRL_ID'));
			$this->newtable->hiddens(array('SRL_ID'));
			$this->newtable->action(site_url()."/home/master/parameter-uji/verifikasi/".$kategori);
			$this->newtable->cidb($this->db);
			$this->newtable->ciuri($this->uri->segment_array());
			$this->newtable->menu($proses);
			$tabel = $this->newtable->generate($query);
			$komoditi = $sipt->main->get_uraian("SELECT dbo.KATEGORI('".$kategori."','0') AS KOMODITI","KOMODITI");
			$arrdata = array('table' => $tabel,
							 'idjudul' => 'juduluji',
							 'caption_header' => 'Verifikasi Data Parameter Uji - '.$komoditi,
							 'batal' => '',
							 'cancel' => '');
			return $arrdata;
		}
	}

	function preview_srl($id){
		if(in_array('9', $this->newsession->userdata('SESS_KODE_ROLE')) || (in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')) || $this->newsession->userdata('SESS_BBPOM_ID') == "99" || $this->newsession->userdata('SESS_BBPOM_ID') == "00")){
			$sipt =& get_instance();
			$this->load->model("main","main", true);
			$query = "SELECT A.SRL_ID, CASE WHEN A.BIDANG_UJI = '01' THEN 'Uji Mikrobiologi' WHEN A.BIDANG_UJI = '02' THEN 'Uji Kimia' END AS BIDANG_UJI,
dbo.GOLONGAN_SAMPEL(LEFT(A.GOLONGAN,2)) AS UR_KOMODITI, dbo.GOLONGAN_SAMPEL(LEFT(A.GOLONGAN,4)) AS UR_KATEGORI, 
CASE WHEN LEN(A.GOLONGAN) > 4 THEN dbo.GOLONGAN_SAMPEL(LEFT(A.GOLONGAN,6)) ELSE '' END AS UR_SUB_KATEGORI, 
CASE WHEN LEN(A.GOLONGAN) > 6 THEN dbo.GOLONGAN_SAMPEL(LEFT(A.GOLONGAN,8)) ELSE '' END AS UR_SUB_SUB_KATEGORI, 
CASE WHEN LEN(A.GOLONGAN) > 8 THEN dbo.GOLONGAN_SAMPEL(LEFT(A.GOLONGAN,10)) ELSE '' END AS UR_SUB_SUB_SUB_KATEGORI, A.PARAMETER_UJI, A.METODE, A.PUSTAKA, A.SYARAT, A.RUANG_LINGKUP, A.PRIORITAS, B.NAMA_USER, REPLACE(REPLACE(C.NAMA_BBPOM, 'BALAI POM DI ', ''), 'BALAI BESAR POM DI ','') AS NAMA_BBPOM FROM M_SRL A LEFT JOIN T_USER B ON A.CREATE_BY = B.USER_ID LEFT JOIN M_BBPOM C ON A.BBPOM_ID = C.BBPOM_ID WHERE A.SRL_ID = '".$id."' AND A.VERIFI = '00'";
			$data = $sipt->main->get_result($query);
			if($data){
				foreach($query->result_array() as $row){
					$arrdata = array('sess' => $row,
									 'act' => site_url().'/post/master/srlpengujian/verifikasi',
									 'id' => $row['SRL_ID'],
									 'save' => 'Proses',
									 'cancel' => 'Kembali');
				}
				$arrdata['verifikasi'] = array('' => '', '01' => 'Verifikasi', '02' => 'Ditolak');
			}
			return $arrdata;
		}
	}

	
}
?>