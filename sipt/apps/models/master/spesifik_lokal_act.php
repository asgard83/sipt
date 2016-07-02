<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);

class Spesifik_lokal_act extends Model{
	function list_golongan(){
		if((in_array('1', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('9', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('4', $this->newsession->userdata('SESS_KODE_ROLE'))) && $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$sipt->load->model("main", "main", true);
			$this->load->library('newtable');
			$this->newtable->hiddens(array('KLASIFIKASI_ID'));
			$this->newtable->action(site_url()."/home/master/golongan-spesifik");
			$this->newtable->cidb($this->db);
			$this->newtable->ciuri($this->uri->segment_array());
			$this->newtable->orderby(1);
			$this->newtable->sortby("ASC");
			$this->newtable->keys(array('KLASIFIKASI_ID'));
			$this->newtable->search(array(array("dbo.GOLONGAN_SAMPEL(LEFT(A.KLASIFIKASI_ID,2))","Komoditi"),
										  array("dbo.GOLONGAN_SAMPEL(LEFT(A.KLASIFIKASI_ID,4))","Kategori"),
										  array("CASE WHEN LEN(KLASIFIKASI_ID) > 4 THEN dbo.GOLONGAN_SAMPEL(LEFT(A.KLASIFIKASI_ID,6)) ELSE '' END AS","Sub Kategori"),
										  array("CASE WHEN LEN(KLASIFIKASI_ID) > 6 THEN dbo.GOLONGAN_SAMPEL(LEFT(A.KLASIFIKASI_ID,8)) ELSE '' END","Sub Sub Kategori"),
										  array("CASE WHEN LEN(KLASIFIKASI_ID) > 8 THEN dbo.GOLONGAN_SAMPEL(LEFT(KLASIFIKASI_ID,10)) ELSE '' END","Sub Sub Sub Kategori")));
			$proses['Golongan Baru'] = array('GET',site_url().'/home/master/golongan-spesifik/new','0');
			$proses['Edit Golongan'] = array('GET',site_url().'/home/master/golongan-spesifik/edit','1');
			$proses['Hapus Golongan'] = array('POST', site_url()."/post/master/spesifik/hapus/ajax", 'N');
			$this->newtable->menu($proses);
			$query = "SELECT A.KLASIFIKASI_ID, dbo.GOLONGAN_SAMPEL(LEFT(A.KLASIFIKASI_ID,2)) AS KOMODITI, dbo.GOLONGAN_SAMPEL(LEFT(A.KLASIFIKASI_ID,4)) AS KATEGORI, CASE WHEN LEN(KLASIFIKASI_ID) > 4 THEN dbo.GOLONGAN_SAMPEL(LEFT(A.KLASIFIKASI_ID,6)) ELSE '' END AS [SUB KATEGORI], CASE WHEN LEN(KLASIFIKASI_ID) > 6 THEN dbo.GOLONGAN_SAMPEL(LEFT(A.KLASIFIKASI_ID,8)) ELSE '' END AS [SUB SUB KATEGORI], CASE WHEN LEN(KLASIFIKASI_ID) > 8 THEN dbo.GOLONGAN_SAMPEL(LEFT(KLASIFIKASI_ID,10)) ELSE '' END AS [SUB SUB SUB KATEGORI] FROM M_GOLONGAN A WHERE LEN(A.KLASIFIKASI_ID) > 2 AND A.LOKAL = 1";
			$this->newtable->columns(array("A.KLASIFIKASI_ID", "dbo.GOLONGAN_SAMPEL(LEFT(A.KLASIFIKASI_ID,2))", "dbo.GOLONGAN_SAMPEL(LEFT(A.KLASIFIKASI_ID,4))", "CASE WHEN LEN(KLASIFIKASI_ID) > 4 THEN dbo.GOLONGAN_SAMPEL(LEFT(A.KLASIFIKASI_ID,6)) ELSE '' END AS", "CASE WHEN LEN(KLASIFIKASI_ID) > 6 THEN dbo.GOLONGAN_SAMPEL(LEFT(A.KLASIFIKASI_ID,8)) ELSE '' END", "CASE WHEN LEN(KLASIFIKASI_ID) > 8 THEN dbo.GOLONGAN_SAMPEL(LEFT(KLASIFIKASI_ID,10)) ELSE '' END"));
			$this->newtable->width(array('KOMODITI' => 100, 'KATEGORI' => 150, 'SUB KATEGORI' => 150, 'SUB SUB KATEGORI' => 150, 'SUB SUB SUB KATEGORI' => 150));
			$tabel = $this->newtable->generate($query);
			$arrdata = array('table' => $tabel,
							 'idjudul' => 'juduluji',
							 'caption_header' => 'Daftar Kategori Spesifik Lokal',
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
				$arrdata = array('act' => site_url().'/post/master/spesifik/simpan',				
								 'batal' => site_url().'/home/master/golongan-spesifik',
								 'sess' => '',
								 'save' => 'Simpan',
								 'cancel' => 'Batal');
			}else{
				$chk = $sipt->main->get_uraian("SELECT CREATE_BY FROM M_GOLONGAN WHERE KLASIFIKASI_ID = '".$id."'","CREATE_BY");
				if(!in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))){
					if(($this->newsession->userdata('SESS_USER_ID') != $chk)){
						return $this->fungsi->redirectMessage('Mohon maaf, anda tidak diperkenankan untuk mengedit data kategori, golongan atau bentuk sediaan tersebut.','/home/master/golongan-spesifik'); exit();
					}
				}
				$query = "SELECT *, UR_KOMODITI +'|'+ UR_KATEGORI +'|' + UR_SUB_KATEGORI + '|' + UR_SUB_SUB_KATEGORI + '|' + UR_SUB_SUB_SUB_KATEGORI +'|' AS URAIAN FROM (SELECT RTRIM(LTRIM(KLASIFIKASI_ID)) AS KLASIFIKASI_ID, CASE WHEN LEN(KLASIFIKASI_ID) > 2 THEN LEFT(KLASIFIKASI_ID,2) ELSE '' END AS KOMODITI, CASE WHEN LEN(KLASIFIKASI_ID) >= 4 THEN LEFT(KLASIFIKASI_ID,4) ELSE '' END AS KATEGORI, CASE WHEN LEN(KLASIFIKASI_ID) >= 6 THEN LEFT(KLASIFIKASI_ID,6) ELSE '' END AS SUB_KATEGORI, CASE WHEN LEN(KLASIFIKASI_ID) >= 8 THEN LEFT(KLASIFIKASI_ID,8) ELSE '' END AS SUB_SUB_KATEGORI, CASE WHEN LEN(KLASIFIKASI_ID) = 10 THEN KLASIFIKASI_ID ELSE '' END AS SUB_SUB_SUB_KATEGORI, dbo.GOLONGAN_SAMPEL(LEFT(KLASIFIKASI_ID,2)) AS UR_KOMODITI, dbo.GOLONGAN_SAMPEL(LEFT(KLASIFIKASI_ID,4)) AS UR_KATEGORI, CASE WHEN LEN(KLASIFIKASI_ID) > 4 THEN dbo.GOLONGAN_SAMPEL(LEFT(KLASIFIKASI_ID,6)) ELSE '' END AS UR_SUB_KATEGORI, CASE WHEN LEN(KLASIFIKASI_ID) > 6 THEN dbo.GOLONGAN_SAMPEL(LEFT(KLASIFIKASI_ID,8)) ELSE '' END AS UR_SUB_SUB_KATEGORI, CASE WHEN LEN(KLASIFIKASI_ID) > 8 THEN dbo.GOLONGAN_SAMPEL(LEFT(KLASIFIKASI_ID,10)) ELSE '' END AS UR_SUB_SUB_SUB_KATEGORI FROM M_GOLONGAN WHERE KLASIFIKASI_ID = '".$id."') AS DATA";
				$data = $sipt->main->get_result($query);
				if($data){
					foreach($query->result_array() as $row){
						$arrdata = array('sess' => $row,
										 'act' => site_url().'/post/master/spesifik/update',
										 'id' => $row['KLASIFIKASI_ID'],
										 'save' => 'Update',
										 'cancel' => 'Kembali');
					}
					$arrdata['uraian'] = explode("|",$row['URAIAN']);
				}
			}
			$arrdata['golongan'] = $sipt->main->combobox("SELECT KLASIFIKASI_ID, KLASIFIKASI FROM M_GOLONGAN WHERE LEN(KLASIFIKASI_ID) = 2 AND KLASIFIKASI_ID IN ('10','11','12','13')","KLASIFIKASI_ID", "KLASIFIKASI", TRUE);
			return $arrdata;
		}else{
			$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
		}
	}
	
	
	function set_golongan($action, $isajax){
		if((in_array('1', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('9', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('4', $this->newsession->userdata('SESS_KODE_ROLE'))) && $this->newsession->userdata('LOGGED_IN') ==  TRUE){
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
									 'CREATE_BY' => $this->newsession->userdata('SESS_USER_ID'),
									 'LOKAL' => 1);
				if($this->db->insert('M_GOLONGAN', $arrgolongan)){
					 return "MSG#YES#Data berhasil disimpan.#".site_url().'/home/master/golongan-spesifik';
				}else{
					return "MSG#NO#Data Gagal Disimpan";
				}
				if($isajax!="ajax"){
					redirect(site_url().'/home/master/golongan-spesifik');
					exit();
				}
			}else if($action == "update"){
				$arrgolongan = array('KLASIFIKASI' => $this->input->post('KLASIFIKASI'));
				$this->db->where('KLASIFIKASI_ID', $this->input->post('KLASIFIKASI_ID'));
				if($this->db->update('M_GOLONGAN', $arrgolongan)){
					return "MSG#YES#Data berhasil diupdate#".site_url().'/home/master/golongan-spesifik';
				}else{
					return "MSG#NO#Data Gagal Diupdate";
				}
				if($isajax!="ajax"){
					redirect(base_url());
					exit();
				}
			}else if($action == "hapus"){
				$ret = "MSG#Hapus Golongan Gagal.";
				foreach($this->input->post('tb_chk') as $chkitem){
					$by = $sipt->main->get_uraian("SELECT CREATE_BY FROM M_GOLONGAN WHERE KLASIFIKASI_ID = '".$chkitem."'","CREATE_BY");
					if(($this->newsession->userdata('SESS_USER_ID') != $by)){
						$ret = "MSG#Hapus Golongan Gagal.";
					}else{
						$this->db->where('KLASIFIKASI_ID', $chkitem);
						if($this->db->delete('M_GOLONGAN')){
							$ret = "MSG#Hapus Data golongan lokal spesifik berhasil.#".site_url().'/home/master/golongan-spesifik';
						}
					}
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
	
	function show_srl(){
		if((in_array('1', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('9', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('4', $this->newsession->userdata('SESS_KODE_ROLE'))) && $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main","main", true);
			$query = "SELECT A.KLASIFIKASI_ID, A.KLASIFIKASI, COUNT(*) AS JML FROM M_GOLONGAN A LEFT JOIN M_SRL B ON A.KLASIFIKASI_ID = SUBSTRING(B.GOLONGAN,1,2) WHERE LEN(A.KLASIFIKASI_ID) = 2 AND A.KLASIFIKASI_ID <> '01' AND A.KLASIFIKASI_ID IN ('10','11','12','13') AND B.STATUS = '9' GROUP BY KLASIFIKASI_ID, KLASIFIKASI ORDER BY 1 ASC";
			$data = $sipt->main->get_result($query);
			if($data){
				foreach($query->result_array() as $row){
					$arrdata['srl'][] = $row;
				}
			}
			return $arrdata;
		}
	}

	function list_new_srl($kategori){
		if((in_array('1', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('9', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('4', $this->newsession->userdata('SESS_KODE_ROLE'))) && $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$sipt->load->model("main", "main", true);
			$this->load->library('newtable');
			if($kategori == "10" || $kategori == "11" || $kategori == "12"){
				$query = "SELECT SRL_ID, CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END AS [BIDANG UJI], dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,4)) AS KATEGORI, dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,6)) AS [SUB KATEGORI], CASE WHEN LEN(LTRIM(RTRIM(GOLONGAN))) > 6 THEN dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,8)) ELSE '' END AS [SUB SUB KATEGORI], PARAMETER_UJI AS [PARAMETER UJI], PUSTAKA, METODE, SYARAT,CASE WHEN VERIFI = '00' THEN '<div style=\"color:#FFF; font-weight:bold; background:#CE0000; padding:2px;\">Belum di Verifikasi</div>' ELSE '<div style=\"color:#FFF; font-weight:bold; background:#006600; padding:2px;\">Sudah Verifikasi</div>' END AS [VERIFIKASI] FROM M_SRL WHERE LEFT(GOLONGAN,2) = '".$kategori."' AND STATUS = 9";
				$this->newtable->columns(array("SRL_ID", "CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END", "dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,4))","dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,6))","CASE WHEN LEN(LTRIM(RTRIM(GOLONGAN))) > 6 THEN dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,8)) ELSE '' END", "PARAMETER_UJI", "PUSTAKA", "METODE", "SYARAT","CASE WHEN VERIFI = '00' THEN '<div style=\"color:#FFF; font-weight:bold; background:#CE0000; padding:2px;\">Belum di Verifikasi</div>' ELSE '<div style=\"color:#FFF; font-weight:bold; background:#006600; padding:2px;\">Sudah Verifikasi</div>' END"));
				$this->newtable->width(array('BIDANG UJI' => 75,'KATEGORI' => 200, 'SUB KATEGORI' => 200, 'SUB SUB KATEGORI' => 200, 'PARAMETER UJI' => 200, 'PUSTAKA' => 150, 'METODE' => 150, 'SYARAT' => 150, 'VERIFIKASI' => 100));
				$this->newtable->search(array(array("CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END", "Berdasarkan Bidang Pengujian"), array("dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,4))", "Berdasarkan Kategori"), array("dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,6))", "Berdasarkan Sub Kategori"), array("CASE WHEN LEN(LTRIM(RTRIM(GOLONGAN))) > 6 THEN dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,8)) ELSE '' END","Berdasarkan Sub Sub Kategori"), array("PARAMETER_UJI", "Berdasarkan Parameter Uji"),array("PUSTAKA", "Berdasarkan Pustaka"),array("METODE", "Berdasarkan Metode"),array("SYARAT", "Berdasarkan Syarat")));
			}else if($kategori == "13"){
				$query = "SELECT SRL_ID, CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END AS [BIDANG UJI], dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,4)) AS KATEGORI, dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,6)) AS [JENIS PANGAN], dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,8)) AS [PRODUK PANGAN], PARAMETER_UJI AS [PARAMETER UJI], PUSTAKA, METODE, SYARAT, CASE WHEN VERIFI = '00' THEN '<div style=\"color:#FFF; font-weight:bold; background:#CE0000; padding:2px;\">Belum di Verifikasi</div>' ELSE '<div style=\"color:#FFF; font-weight:bold; background:#006600; padding:2px;\">Sudah Verifikasi</div>' END AS [VERIFIKASI] FROM M_SRL WHERE LEFT(GOLONGAN,2) = '".$kategori."' AND STATUS = 9";
				$this->newtable->columns(array("SRL_ID", "CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END", "dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,4))","dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,6))","dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,8))","PARAMETER_UJI", "PUSTAKA", "METODE", "SYARAT","CASE WHEN VERIFI = '00' THEN '<div style=\"color:#FFF; font-weight:bold; background:#CE0000; padding:2px;\">Belum di Verifikasi</div>' ELSE '<div style=\"color:#FFF; font-weight:bold; background:#006600; padding:2px;\">Sudah Verifikasi</div>"));
				$this->newtable->width(array('BIDANG UJI' => 75,'KATEGORI' => 200, 'JENIS PANGAN' => 200, 'PRODUK PANGAN' => 200,'PARAMETER UJI' => 200, 'PUSTAKA' => 150, 'METODE' => 150, 'SYARAT' => 150, 'VERIFIKASI' => 100));
				$this->newtable->search(array(array("CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END", "Berdasarkan Bidang Pengujian"), array("dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,4))", "Berdasarkan Kategori"), array("dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,6))", "Berdasarkan Jenis Pangan"),array("dbo.GOLONGAN_SAMPEL(SUBSTRING(GOLONGAN,1,8))", "Berdasarkan Produk Pangan"), array("PARAMETER_UJI", "Berdasarkan Parameter Uji"),array("PUSTAKA", "Berdasarkan Pustaka"),array("METODE", "Berdasarkan Metode"),array("SYARAT", "Berdasarkan Syarat")));
			}
			if(in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))){
				$proses['Preview Data'] = array('GET',site_url().'/home/master/parameter-uji-spesifik/preview','1');
			}else{
				$proses['Parameter Lokal Spesifik Baru'] = array('GET',site_url().'/home/master/parameter-uji-spesifik/new','0');
				$proses['Edit Parameter Lokal Spesifik'] = array('GET',site_url().'/home/master/parameter-uji-spesifik/new','1');
				$proses['Hapus Parameter Lokal Spesifik'] = array('POST', site_url()."/post/master/spesifik_lokal/hapus/ajax", 'N');
			}
			$this->newtable->orderby(1);
			$this->newtable->sortby("ASC");
			$this->newtable->keys(array('SRL_ID'));
			$this->newtable->hiddens(array('SRL_ID'));
			$this->newtable->action(site_url()."/home/master/parameter-uji-spesifik/view/".$kategori);
			$this->newtable->cidb($this->db);
			$this->newtable->ciuri($this->uri->segment_array());
			$this->newtable->menu($proses);
			$tabel = $this->newtable->generate($query);
			$komoditi = $sipt->main->get_uraian("SELECT dbo.KATEGORI('".$kategori."','0') AS KOMODITI","KOMODITI");
			$arrdata = array('table' => $tabel,
							 'idjudul' => 'juduluji',
							 'caption_header' => 'Parameter Uji Lokal Spesifik - '.$komoditi,
							 'batal' => '',
							 'cancel' => '');
			return $arrdata;
		}
	}
	
	function get_srl($id){
		if(in_array('9', $this->newsession->userdata('SESS_KODE_ROLE')) || (in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')) || $this->newsession->userdata('SESS_BBPOM_ID') == "99")){ 
			$sipt =& get_instance();
			$sipt->load->model("main", "main", true);
			$bidang = $sipt->main->combobox("SELECT KODE, URAIAN FROM M_TABEL WHERE JENIS ='BIDANG_PENGUJIAN'","KODE", "URAIAN", TRUE);
			$golongan = $sipt->main->combobox("SELECT KLASIFIKASI_ID, KLASIFIKASI FROM M_GOLONGAN WHERE LEN(KLASIFIKASI_ID) = 2 AND KLASIFIKASI_ID IN ('10','11','12','13')","KLASIFIKASI_ID", "KLASIFIKASI", TRUE);
			if($id==""){
				$arrdata = array('act' => site_url().'/post/master/spesifik_lokal/simpan',
								 'save' => 'Simpan',
								 'cancel' => 'Batal');
			}else{
				$qsrl = $this->db->query("SELECT CREATE_BY, BBPOM_ID FROM M_SRL WHERE SRL_ID = '".$id."'")->result_array();
				/*if(($this->newsession->userdata('SESS_USER_ID') != $qsrl[0]['CREATE_BY']) && ($this->newsession->userdata('SESS_BBPOM_ID') != $qsrl[0]['SESS_BBPOM_ID'])){
					return $this->fungsi->redirectMessage('Mohon maaf, Petugas entri dan BBPOM / BPOM tidak sesuai.','/home'); exit();
				}*/
				$query = "SELECT SRL_ID, BIDANG_UJI, SUBSTRING(RTRIM(LTRIM(GOLONGAN)),1,2) AS KOMODITI, SUBSTRING(RTRIM(LTRIM(GOLONGAN)),1,4) AS KATEGORI, SUBSTRING(RTRIM(LTRIM(GOLONGAN)),1,6) AS SUB_KATEGORI, SUBSTRING(RTRIM(LTRIM(GOLONGAN)),1,8) AS SUB_KATEGORI_1, SUBSTRING(RTRIM(LTRIM(GOLONGAN)),1,10) AS SUB_KATEGORI_2, PARAMETER_UJI, METODE, PUSTAKA, SYARAT, RUANG_LINGKUP FROM M_SRL WHERE SRL_ID = '".$id."'";
				$data = $sipt->main->get_result($query);
				if($data){
					foreach($query->result_array() as $row){
						$arrdata = array('sess' => $row,
										 'act' => site_url().'/post/master/spesifik_lokal/update',
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
			$arrdata['golongan'] = $golongan;
			$arrdata['bidang'] = $bidang;
			return $arrdata;
		}else{
			$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
		}
	}
	
	function preview_srl($id){
		if(in_array('9', $this->newsession->userdata('SESS_KODE_ROLE')) || (in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')) || $this->newsession->userdata('SESS_BBPOM_ID') == "99")){
			$sipt =& get_instance();
			$this->load->model("main","main", true);
			$query = "SELECT SRL_ID, CASE WHEN BIDANG_UJI = '01' THEN 'Uji Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Uji Kimia' END AS BIDANG_UJI,
dbo.GOLONGAN_SAMPEL(LEFT(GOLONGAN,2)) AS UR_KOMODITI, dbo.GOLONGAN_SAMPEL(LEFT(GOLONGAN,4)) AS UR_KATEGORI, 
CASE WHEN LEN(GOLONGAN) > 4 THEN dbo.GOLONGAN_SAMPEL(LEFT(GOLONGAN,6)) ELSE '' END AS UR_SUB_KATEGORI, 
CASE WHEN LEN(GOLONGAN) > 6 THEN dbo.GOLONGAN_SAMPEL(LEFT(GOLONGAN,8)) ELSE '' END AS UR_SUB_SUB_KATEGORI, 
CASE WHEN LEN(GOLONGAN) > 8 THEN dbo.GOLONGAN_SAMPEL(LEFT(GOLONGAN,10)) ELSE '' END AS UR_SUB_SUB_SUB_KATEGORI, PARAMETER_UJI, METODE, PUSTAKA, SYARAT, RUANG_LINGKUP FROM M_SRL WHERE SRL_ID = '".$id."'";
			$data = $sipt->main->get_result($query);
			if($data){
				foreach($query->result_array() as $row){
					$arrdata = array('sess' => $row,
									 'act' => site_url().'/post/master/spesifik_lokal/verifikasi',
									 'id' => $row['SRL_ID'],
									 'save' => 'Proses',
									 'cancel' => 'Kembali');
				}
				$arrdata['verifikasi'] = array('' => '', '01' => 'Verifikasi');
			}
			return $arrdata;
		}
	}
	
	function set_params($action, $isajax){
		if(in_array('9', $this->newsession->userdata('SESS_KODE_ROLE')) || (in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')) || $this->newsession->userdata('SESS_BBPOM_ID') == "99")){
			$sipt =& get_instance();
			$this->load->model("main","main", true);
			if($action=="simpan"){
				$srl_id = (int)$sipt->main->get_uraian("SELECT MAX(SRL_ID) AS MAXID FROM M_SRL", "MAXID") + 1;
				$arr_slr = array('SRL_ID' => $srl_id,
								 'CREATE_DATE' => 'GETDATE()',
								 'CREATE_BY' => $this->newsession->userdata('SESS_USER_ID'));
				foreach($this->input->post('SRL') as $a => $b){
					$arr_slr[$a] = $b;
				}
				$golongan = array_filter($this->input->post('GOLONGAN'));
				$arr_slr['GOLONGAN'] = $golongan[count($golongan)-1];
				$arr_slr['BBPOM_ID'] = $this->newsession->userdata('SESS_BBPOM_ID');
				$arr_slr['PARAMETER_UJI'] = preg_replace('/[^(\x20-\x7F)]*/','',$sipt->main->clean_tags($arr_slr['PARAMETER_UJI']));
				$arr_slr['METODE'] = preg_replace('/[^(\x20-\x7F)]*/','',$sipt->main->clean_tags($arr_slr['METODE']));
				$arr_slr['PUSTAKA'] = preg_replace('/[^(\x20-\x7F)]*/','',$sipt->main->clean_tags($arr_slr['PUSTAKA']));
				$arr_slr['SYARAT'] = preg_replace('/[^(\x20-\x7F)]*/','',$sipt->main->clean_tags($arr_slr['SYARAT']));
				$arr_slr['RUANG_LINGKUP'] = preg_replace('/[^(\x20-\x7F)]*/','',$sipt->main->clean_tags($arr_slr['RUANG_LINGKUP']));
				$arr_slr['STATUS'] = '9';
				$arr_slr['VERIFI'] = '01';
				if($this->db->insert('M_SRL', $arr_slr)){
					$kiri = substr($arr_slr['GOLONGAN'],0,2);
					if($kiri == "01")
						$redir = substr($arr_slr['GOLONGAN'],0,4);
					else
						$redir = substr($arr_slr['GOLONGAN'],0,2);
					return "MSG#YES#Data berhasil disimpan.#".site_url().'/home/master/parameter-uji-spesifik/view/'.$redir;
				}else{
					return "MSG#NO#Data Gagal Disimpan";
				}
				if($isajax!="ajax"){
					redirect(site_url().'/home/master/parameter-uji-spesifik');
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
				$arr_slr['PARAMETER_UJI'] = preg_replace('/[^(\x20-\x7F)]*/','',$sipt->main->clean_tags($arr_slr['PARAMETER_UJI']));
				$arr_slr['METODE'] = preg_replace('/[^(\x20-\x7F)]*/','',$sipt->main->clean_tags($arr_slr['METODE']));
				$arr_slr['PUSTAKA'] = preg_replace('/[^(\x20-\x7F)]*/','',$sipt->main->clean_tags($arr_slr['PUSTAKA']));
				$arr_slr['SYARAT'] = preg_replace('/[^(\x20-\x7F)]*/','',$sipt->main->clean_tags($arr_slr['SYARAT']));
				$arr_slr['RUANG_LINGKUP'] = preg_replace('/[^(\x20-\x7F)]*/','',$sipt->main->clean_tags($arr_slr['RUANG_LINGKUP']));
				$this->db->where('SRL_ID', $id);
				if($this->db->update('M_SRL', $arr_slr)){
					$kiri = substr($arr_slr['GOLONGAN'],0,2);
					if($kiri == "01")
						$redir = substr($arr_slr['GOLONGAN'],0,4);
					else
						$redir = substr($arr_slr['GOLONGAN'],0,2);
					return "MSG#YES#Data berhasil diupdate#".site_url().'/home/master/parameter-uji-spesifik/view/'.$redir;
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
						 $ret = "MSG#Hapus SRL Pengujian Berhasil.#".site_url().'/home/master/parameter-uji-spesifik/view/'.$redir;
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
					return "MSG#YES#Data berhasil diverifikasi#".site_url().'/home/master/parameter-uji-spesifik/view/'.$redir;
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
	}}
?>