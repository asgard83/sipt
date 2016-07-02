<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR);
class Penguji_act extends Model{
	function list_uji($id){
		if((in_array('2', $this->newsession->userdata('SESS_KODE_ROLE')) && in_array('02', $this->newsession->userdata('SESS_JENIS_PELAPORAN'))) && $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model('main','main',TRUE);
			$this->load->library('newtable');
			if($id!="all")
				$status = " AND STATUS = '$id'";
			else
				$status = " AND STATUS NOT IN ('20101','20202') AND STATUS IS NOT NULL";
			$this->newtable->hiddens(array('UJI_ID','KODE_SAMPEL'));
			$query = "SELECT A.KODE_SAMPEL, dbo.FORMAT_NOMOR('SPL', A.KODE_SAMPEL) AS [KODE SAMPEL], A.NAMA_SAMPEL AS [NAMA SAMPEL], dbo.KATEGORI(A.KOMODITI,A.PRIORITAS) AS KOMODITI, STUFF(dbo.PARAMUJI(A.KODE_SAMPEL,'".$this->newsession->userdata('SESS_USER_ID')."'),1,1,'') AS [PARAMETER UJI], CASE WHEN A.KODE_RUJUKAN IS NOT NULL THEN 'Uji Rujuk' WHEN A.KODE_UNGGULAN IS NOT NULL THEN 'Uji Unggulan' ELSE 'Rutin' END AS [TIPE UJI] FROM T_M_SAMPEL A 
WHERE A.KODE_SAMPEL IN (SELECT KODE_SAMPEL FROM T_PARAMETER_HASIL_UJI WHERE PENGUJI = '".$this->newsession->userdata('SESS_USER_ID')."' $status GROUP BY KODE_SAMPEL, PENGUJI)";
			$this->newtable->search(array(array("dbo.FORMAT_NOMOR('SPL', A.KODE_SAMPEL)", "Kode Sampel"),
										  array("dbo.KATEGORI(A.KOMODITI,A.PRIORITAS)", "Komoditi"),
										  array("STUFF(dbo.PARAMUJI(A.KODE_SAMPEL,'".$this->newsession->userdata('SESS_USER_ID')."'),1,1,'')", "Parameter Uji"),
										  array("CASE WHEN KODE_RUJUKAN IS NOT NULL THEN 'Uji Rujuk' WHEN KODE_UNGGULAN IS NOT NULL THEN 'Uji Unggulan' ELSE 'Rutin' END AS [TIPE UJI]"), "Tipe Uji"));
			if($id == "all")							  
				$this->newtable->columns(array("A.KODE_SAMPEL", array("dbo.FORMAT_NOMOR('SPL', A.KODE_SAMPEL)",site_url()."/home/pengujian/uji/view/{KODE_SAMPEL}"), "A.NAMA_SAMPEL","dbo.KATEGORI(A.KOMODITI,A.PRIORITAS)","STUFF(dbo.PARAMUJI(A.KODE_SAMPEL,'".$this->newsession->userdata('SESS_USER_ID')."'),1,1,'')", "CASE WHEN A.KODE_RUJUKAN IS NOT NULL THEN 'Uji Rujuk' WHEN A.KODE_UNGGULAN IS NOT NULL THEN 'Uji Unggulan' ELSE 'Rutin' END"));
			else
				$this->newtable->columns(array("A.KODE_SAMPEL", "dbo.FORMAT_NOMOR('SPL', A.KODE_SAMPEL)", "A.NAMA_SAMPEL","dbo.KATEGORI(A.KOMODITI,A.PRIORITAS)","STUFF(dbo.PARAMUJI(A.KODE_SAMPEL,'".$this->newsession->userdata('SESS_USER_ID')."'),1,1,'')", "CASE WHEN A.KODE_RUJUKAN IS NOT NULL THEN 'Uji Rujuk' WHEN A.KODE_UNGGULAN IS NOT NULL THEN 'Uji Unggulan' ELSE 'Rutin' END"));
			//echo $query;	
			$this->newtable->action(site_url()."/home/pengujian/uji/list/".$id);
			$this->newtable->width(array('KODE SAMPEL' => 175, 'KOMODITI' => 150, 'TIPE UJI' => 75));
			$this->newtable->cidb($this->db);
			$this->newtable->ciuri($this->uri->segment_array());
			$this->newtable->orderby(1);
			$this->newtable->sortby("ASC");
			$this->newtable->keys(array('KODE_SAMPEL'));
			if($id=="20201"){
				$proses['Entri Uji Sampel'] = array('GET', site_url()."/home/pengujian/uji/new", '1');
				$judul = 'Data Perintah Pengujian';
			}else if($id=="20202"){
				$proses['Perbaiki Uji Sampel'] = array('GET', site_url()."/home/pengujian/uji/review", '1');
				$judul = 'Data Pengujian Ditolak';
			}else{
				$proses['Preview Data Hasil Uji'] = array('GET', site_url()."/home/pengujian/uji/view", '1');
				$judul = 'Hasil Data Pengujian';
			}
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
	
	
	function get_uji($id){
		if((in_array('2', $this->newsession->userdata('SESS_KODE_ROLE')) && in_array('02', $this->newsession->userdata('SESS_JENIS_PELAPORAN'))) && $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model('main','main',TRUE);
			$arrdata = array();
			$boleh = array('20201','20202');
			$query = "SELECT LTRIM(RTRIM(UJI_ID)) AS UJI_ID, SPK_ID, dbo.FORMAT_NOMOR('SPL', KODE_SAMPEL) AS KODE, KODE_SAMPEL, PARAMETER_UJI, METODE, PUSTAKA, SYARAT, RUANG_LINGKUP, JENIS_UJI, JUMLAH_UJI, SISA_UJI, REAGEN, JUMLAH_REAGEN, HASIL, HASIL_KUALITATIF, CATATAN, CONVERT(VARCHAR(10), AWAL_UJI, 103) AS AWAL_UJI, CONVERT(VARCHAR(10), AKHIR_UJI, 103) AS AKHIR_UJI, LCP, STATUS, PENGUJI, HASIL_PARAMETER FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL = '".$id."' AND PENGUJI = '".$this->newsession->userdata('SESS_USER_ID')."'";
			$data = $sipt->main->get_result($query);
			if($data){
				foreach($query->result_array() as $row){
					$arrdata['sess'][] = $row;
				}
				$arrdata['act'] = site_url().'/post/uji/penguji_act/save';
				$arrdata['sp'] = $this->db->query("SELECT dbo.FORMAT_NOMOR('SPK', A.SPK_ID) AS UR_SPK, CONVERT(VARCHAR(10), A.TANGGAL, 103) AS TGL_SPK, dbo.FORMAT_NOMOR('SPP',B.SPP_ID) AS UR_SPP, CONVERT(VARCHAR(10), B.TANGGAL, 103) AS TGL_SPP FROM T_SPK A LEFT JOIN T_SPP B ON A.SPK_ID = B.SPK_ID WHERE A.SPK_ID = '".$row['SPK_ID']."'")->result_array();
				$arrdata['jml'] = $this->db->query("SELECT JUMLAH_SAMPEL, JUMLAH_KIMIA, JUMLAH_MIKRO, SISA, ISNULL(SISA_KIMIA,'0') AS SISA_KIMIA, ISNULL(SISA_MIKRO,'0') AS SISA_MIKRO, UJI_KIMIA, UJI_MIKRO, SATUAN FROM T_M_SAMPEL WHERE KODE_SAMPEL = '".$id."'")->result_array();
				$arrdata['kode_sampel'] = $id;
				$arrdata['spk_id'] = $row['SPK_ID'];
				
			}
			$arrdata['sampel'] = $this->db->query("SELECT A.PERIKSA_SAMPEL, A.KODE_SAMPEL, dbo.FORMAT_NOMOR('SPL', A.KODE_SAMPEL) AS UR_KODESAMPEL,dbo.KATEGORI(A.KOMODITI,A.PRIORITAS) AS KOMODITI,dbo.KATEGORI(A.KATEGORI,A.PRIORITAS) AS UR_KATEGORIX, A.NAMA_KATEGORI AS UR_KATEGORI, dbo.URAIAN_M_TABEL('SUB_TUJUAN', A.SUB_TUJUAN) AS SUB_TUJUAN, A.KLASIFIKASI_TAMBAHAN,A.NAMA_SAMPEL,A.NOMOR_REGISTRASI,A.PABRIK,IMPORTIR,A.BENTUK_SEDIAAN,A.KEMASAN,A.NO_BETS,A.KETERANGAN_ED,A.JUMLAH_SAMPEL,A.SATUAN,A.HARGA_SAMPEL,A.UJI_KIMIA,A.JUMLAH_KIMIA,A.UJI_MIKRO,A.JUMLAH_MIKRO,A.SISA,A.KOMPOSISI,A.NETTO,A.KONDISI_SAMPEL,A.EVALUASI_PENANDAAN,A.CARA_PENYIMPANAN, A.LABEL, A.SEGEL,A.CATATAN, ISNULL(A.SISA_KIMIA, 0) AS SISA_KIMIA, ISNULL(A.SISA_MIKRO, 0) AS SISA_MIKRO, A.STATUS_KIMIA,A.STATUS_MIKRO,A.PEMERIAN, LEN(LTRIM(RTRIM(A.PEMERIAN))) AS PJ_PEMERIAN, A.STATUS_SAMPEL,A.LAMPIRAN,B.BBPOM_ID FROM T_M_SAMPEL A LEFT JOIN T_PERIKSA_SAMPEL B ON A.PERIKSA_SAMPEL = B.PERIKSA_SAMPEL WHERE A.KODE_SAMPEL = '".$id."'")->result_array(); 
			$arrdata['file'] = base_url().'files/sampel/'.md5(trim($arrdata['sampel'][0]['BBPOM_ID'])).'/'.$arrdata['sampel'][0]['LAMPIRAN'];
			$arrdata['hasil'] = $sipt->main->referensi("HASIL","'MS','TMS'",FALSE,TRUE);
			$arrdata['batal'] = site_url().'/home/pengujian/uji/list/20201';
			$arrdata['jml_log'] = $sipt->main->get_uraian("SELECT COUNT(*) AS JML FROM T_SAMPLING_LOG WHERE KODE_SAMPEL = '".$id."'","JML");
			return $arrdata;
		}
	}
	
	function get_edit_params($id){
		if((in_array('2', $this->newsession->userdata('SESS_KODE_ROLE'))) && in_array('02', $this->newsession->userdata('SESS_JENIS_PELAPORAN')) && $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$arrid = explode(".",$id);
			if(count($arrid) < 2){
				return false;
			}
			$query = "SELECT UJI_ID, SPK_ID, KODE_SAMPEL, dbo.FORMAT_NOMOR('SPL', KODE_SAMPEL) AS KODE, KODE_SAMPEL, PARAMETER_UJI, METODE, PUSTAKA, SYARAT, RUANG_LINGKUP, JENIS_UJI, JUMLAH_UJI, SISA_UJI, REAGEN, JUMLAH_REAGEN, HASIL, HASIL_KUALITATIF, CATATAN, CONVERT(VARCHAR(10), AWAL_UJI, 103) AS AWAL_UJI, CONVERT(VARCHAR(10), AKHIR_UJI, 103) AS AKHIR_UJI, LCP, STATUS, PENGUJI FROM T_PARAMETER_HASIL_UJI WHERE SPK_ID = '".$arrid[0]."' AND UJI_ID = '".$arrid[1]."' AND PENGUJI = '".$this->newsession->userdata('SESS_USER_ID')."'";
			$data = $sipt->main->get_result($query);
			if($data){
				foreach($query->result_array() as $row){
					$arrdata['sess'] = $row;
				}
				$arrdata['act'] = site_url().'/post/uji/penguji_act/review-update';
				return $arrdata;
			}
		}
	}
	
	function get_reupload($kode_sampel, $uji_id){
		if((in_array('2', $this->newsession->userdata('SESS_KODE_ROLE'))) && in_array('02', $this->newsession->userdata('SESS_JENIS_PELAPORAN')) && $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$query = "SELECT UJI_ID, SPK_ID, KODE_SAMPEL, dbo.FORMAT_NOMOR('SPL', KODE_SAMPEL) AS KODE, KODE_SAMPEL, PARAMETER_UJI, METODE, PUSTAKA, SYARAT, RUANG_LINGKUP, JENIS_UJI, JUMLAH_UJI, SISA_UJI, REAGEN, JUMLAH_REAGEN, HASIL, HASIL_KUALITATIF, CATATAN, CONVERT(VARCHAR(10), AWAL_UJI, 103) AS AWAL_UJI, CONVERT(VARCHAR(10), AKHIR_UJI, 103) AS AKHIR_UJI, RTRIM(LTRIM(LCP)) AS LCP, STATUS, PENGUJI FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL = '".$kode_sampel."' AND UJI_ID = '".$uji_id."' AND PENGUJI = '".$this->newsession->userdata('SESS_USER_ID')."'";
			$data = $sipt->main->get_result($query);
			if($data){
				foreach($query->result_array() as $row){
					$arrdata['sess'] = $row;
				}
				$arrdata['act'] = site_url().'/post/uji/penguji_act/update-lcp';
				return $arrdata;
			}
		}
	}
	
	function set_uji($action, $isajax){
		$sipt =& get_instance();
		$this->load->model("main", "main", true);
		if((in_array('2', $this->newsession->userdata('SESS_KODE_ROLE'))) && in_array('02', $this->newsession->userdata('SESS_JENIS_PELAPORAN')) && $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			if($action=="save"){
				$hasil = FALSE;
				$msgok = "Entri Hasil Pengujian berhasil";
				$msgerr = "Entri Hasil Pengujian gagal, Silahkan coba lagi";
				$terpakai = 0;
				$arr_sampel = $this->input->post('UJI');
				#if(in_array('0', $_POST['UJI']['JUMLAH_UJI']) || in_array(!is_numeric(array_values($_POST['UJI']['JUMLAH_UJI'])),$_POST['UJI']['JUMLAH_UJI'])){
				#if(in_array('0', $_POST['UJI']['JUMLAH_UJI'])){
					#return "MSG#NO#Entri hasil pengujian gagal. \n Ini dikarenakan ada jumlah uji yang diisi 0 (nol), \n atau diisi dengan karakter. \n Silahkan periksa kembali isian hasil pengujian."; die();
				#}
				if($this->input->post('PEMERIAN')){
					if($this->input->post('PEMERIAN') == ""){
						return "MSG#NO#Maaf, data pemerian sampel tidak boleh kosong. \n Silahkan periksa kembali form pengisian pemerian.";
						exit();
					}
				}
				$arrkeys_sampel = array_keys($arr_sampel);
				$pemerian = $sipt->main->get_uraian("SELECT LEN(RTRIM(LTRIM(PEMERIAN))) AS PEMERIAN FROM T_M_SAMPEL WHERE KODE_SAMPEL = '".$this->input->post('KODE_SAMPEL')."'","PEMERIAN");
				if(strlen($pemerian) == 0 || $pemerian == "NULL" || $pemerian == ""){
					$this->db->where('KODE_SAMPEL', $this->input->post('KODE_SAMPEL'));
					$this->db->update('T_M_SAMPEL', array('PEMERIAN' => str_replace("'","",$this->input->post('PEMERIAN'))));
				}
				for($i = 0; $i < count($_POST['UJI']['UJI_ID']); $i++){
					$arr_update = array('STATUS' => '30202');
					for($j=0;$j<count($arrkeys_sampel);$j++){
						$arr_update[$arrkeys_sampel[$j]] = $arr_sampel[$arrkeys_sampel[$j]][$i];
					}
					# ---------------- Update Tipe Data
					if(array_key_exists('JUMLAH_UJI', $arr_update))$arr_update['JUMLAH_UJI'] = (float)$arr_update['JUMLAH_UJI'];
					# ---------------- Update Tipe Data
					$this->db->where('UJI_ID', $_POST['UJI']['UJI_ID'][$i]);
					if($this->db->update('T_PARAMETER_HASIL_UJI', $arr_update)){
						$seri = (int)$sipt->main->get_uraian("SELECT MAX(SERI) AS MAXID FROM T_PU_LOG WHERE UJI_ID = '".$_POST['UJI']['UJI_ID'][$i]."'","MAXID")+1;						
						$arrpu = array('UJI_ID' => $_POST['UJI']['UJI_ID'][$i],
									   'SERI' => $seri,
									   'HASIL' => str_replace(">", " > ", str_replace("<"," < ", preg_replace('/[^(\x20-\x7F)]*/','',$sipt->main->clean_tags($arr_update['HASIL'])))),
									   'HASIL_KUALITATIF' => str_replace(">", " > ", str_replace("<"," < ", preg_replace('/[^(\x20-\x7F)]*/','',$sipt->main->clean_tags($arr_update['HASIL_KUALITATIF'])))),
									   'LCP' => $arr_update['LCP'],
									   'PENGUJI' => $arr_update['PENGUJI'],
									   'CREATE_DATE' => 'GETDATE()',
									   'CREATE_BY' => $this->newsession->userdata('SESS_USER_ID'));
						$this->db->insert('T_PU_LOG', $arrpu);			   
						$hasil = TRUE;
						$terpakai = (float)$terpakai + (float)$_POST['UJI']['JUMLAH_UJI'][$i];
					}
				}
				#----- Update tipe data int to decimal(18,2)
				if($hasil){
					if(in_array('B1',$this->newsession->userdata('SESS_SUB_SARANA')) || in_array('B2',$this->newsession->userdata('SESS_SUB_SARANA'))){#Bidang Kimia Fisika
						$jml = $sipt->main->get_uraian("SELECT JUMLAH_KIMIA FROM T_M_SAMPEL WHERE KODE_SAMPEL = '".$this->input->post('KODE_SAMPEL')."'","JUMLAH_KIMIA");
						$ceksisa = (float)$sipt->main->get_uraian("SELECT ISNULL(SISA_KIMIA, 0) AS SISA_KIMIA FROM T_M_SAMPEL WHERE KODE_SAMPEL = '".$this->input->post('KODE_SAMPEL')."'","SISA_KIMIA");
						if($ceksisa > 0)
							$this->db->simple_query("UPDATE T_M_SAMPEL SET SISA_KIMIA = '".((float)$ceksisa-(float)$terpakai)."' WHERE KODE_SAMPEL = '".$this->input->post('KODE_SAMPEL')."'");
						else
							$this->db->simple_query("UPDATE T_M_SAMPEL SET SISA_KIMIA = '".((float)$jml-(float)$terpakai)."' WHERE KODE_SAMPEL = '".$this->input->post('KODE_SAMPEL')."'");
					}else if(in_array('B3',$this->newsession->userdata('SESS_SUB_SARANA'))){#Bidang Mikro
						$jml = $sipt->main->get_uraian("SELECT JUMLAH_MIKRO FROM T_M_SAMPEL WHERE KODE_SAMPEL = '".$this->input->post('KODE_SAMPEL')."'","JUMLAH_MIKRO");
						$ceksisa = (float)$sipt->main->get_uraian("SELECT ISNULL(SISA_MIKRO, 0) AS SISA_MIKRO FROM T_M_SAMPEL WHERE KODE_SAMPEL = '".$this->input->post('KODE_SAMPEL')."'","SISA_MIKRO");
						if($ceksisa > 0)
							$this->db->simple_query("UPDATE T_M_SAMPEL SET SISA_MIKRO = '".((float)$ceksisa-(float)$terpakai)."' WHERE KODE_SAMPEL = '".$this->input->post('KODE_SAMPEL')."'");
						else
							$this->db->simple_query("UPDATE T_M_SAMPEL SET SISA_MIKRO = '".((float)$jml-(float)$terpakai)."' WHERE KODE_SAMPEL = '".$this->input->post('KODE_SAMPEL')."'");
						
					}
					$this->db->simple_query("UPDATE T_SPK SET STATUS = '30202' WHERE SPK_ID = '".$this->input->post('SPK_ID')."'");					
					
					$cek_uji = $this->db->query("SELECT UJI_KIMIA, UJI_MIKRO FROM T_M_SAMPEL WHERE KODE_SAMPEL = '".$this->input->post('KODE_SAMPEL')."'")->result_array();
					if($cek_uji[0]['UJI_KIMIA'] == 1 && $cek_uji[0]['UJI_MIKRO'] == 1){
						$jmlpu = $sipt->main->get_uraian("SELECT COUNT(JML) AS JML FROM (SELECT DISTINCT(STATUS) AS JML FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL = '".$this->input->post('KODE_SAMPEL')."') AS DATA","JML");
						if($jmlpu == 1){
							$this->db->simple_query("UPDATE T_M_SAMPEL SET STATUS_SAMPEL = '30202' WHERE KODE_SAMPEL = '".$this->input->post('KODE_SAMPEL')."'");
						}
					}else{
						$this->db->simple_query("UPDATE T_M_SAMPEL SET STATUS_SAMPEL = '30202' WHERE KODE_SAMPEL = '".$this->input->post('KODE_SAMPEL')."'");
					}
					return "MSG#YES#$msgok.#".site_url()."/home/pengujian/uji/list/20201";
				}else{
					return "MSG#NO#$msgerr";
				}
				
				if($isajax!="ajax"){
					redirect(base_url());
					exit();
				}
			}
			else if($action == "review-update"){
				$hasil = FALSE;
				$msgok = "Perbaikan data parameter uji hasil pengujian berhasil disimpan";
				$msgerr = "Perbaikan data parameter uji hasil pengujian gagal disimpan";
				$dtparams = $sipt->main->post_to_query($this->input->post('UJI'));
				$dtparams['STATUS'] = '30202';
				#if($dtparams['JUMLAH_UJI'] == 0 || !is_numeric($dtparams['JUMLAH_UJI'])){
					#return "MSG#NO#Perbaikan data parameter uji hasil pengujian gagal disimpan. \n Ini dikarenakan ada jumlah uji yang diisi 0 (nol), \n atau diisi dengan karakter. \n Silahkan periksa kembali isian hasil pengujian."; die();
				#}
				$this->db->where(array('SPK_ID' => $this->input->post('SPK_ID'),'UJI_ID' => $this->input->post('UJI_ID')));
				$res = $this->db->update('T_PARAMETER_HASIL_UJI', $dtparams);
				if($res){
					$hasil = TRUE;
				}
				if($hasil){
					return "MSG#YES#$msgok#".site_url();
				}else{
					return "MSG#YES#$msgerr";
				}
				if($isajax!="ajax"){
					redirect(base_url());
					exit();
				}
			}
			else if($action == "update-lcp"){
				$hasil = FALSE;
				if($this->input->post('chk_lampiran')){
					$msgok = "Proses pembatalan / hapus LCP berhasil";
					$msgerr = "Proses pembatalan / hapus LCP gagal";
					$dtparams['LCP'] = '';
				}else{
					$dtparams = $sipt->main->post_to_query($this->input->post('UJI')); 
					$msgok = "Upload ulang LCP berhasil disimpan";
					$msgerr = "Upload ulang LCP gagal disimpan";
				}
				$this->db->where(array('KODE_SAMPEL' => $this->input->post('KODE_SAMPEL'),'UJI_ID' => $this->input->post('UJI_ID')));
				$res = $this->db->update('T_PARAMETER_HASIL_UJI', $dtparams);
				if($res){
					$hasil = TRUE;
				}
				if($hasil){
					return "MSG#YES#$msgok#".site_url();
				}else{
					return "MSG#YES#$msgerr";
				}
				if($isajax!="ajax"){
					redirect(base_url());
					exit();
				}
			}
		}
		else if($this->newsession->userdata('SESS_BBPOM_ID') == "00" || (in_array('9', $this->newsession->userdata('SESS_KODE_ROLE')) && !in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')))){
			if($action == "update-hasil-parameter"){
				$hasil = FALSE;
				$msgok = "Update perubahan hasil parameter berhasil di simpan";
				$msgerr = "Update perubahan hasil parameter gagal di simpan";
				$dtparams = $sipt->main->post_to_query($this->input->post('UJI'));
				$before = $sipt->main->get_uraian("SELECT HASIL_PARAMETER FROM T_PARAMETER_HASIL_UJI WHERE UJI_ID = '".$this->input->post('UJI_ID')."' AND KODE_SAMPEL = '".$this->input->post('KODE_SAMPEL')."'","HASIL_PARAMETER");
				$catatan = 'Hasil uji dengan nomor uji '.$this->input->post('UJI_ID').', parameter sebelum perubahan '.$before.', hasil parameter setelah perubahan '.$dtparams['HASIL_PARAMETER'];
				$this->db->where(array('KODE_SAMPEL' => $this->input->post('KODE_SAMPEL'),'UJI_ID' => $this->input->post('UJI_ID')));
				$res = $this->db->update('T_PARAMETER_HASIL_UJI', $dtparams);
				if($res){
					$hasil = TRUE;
				}
				if($hasil){
					$data = array('KODE_SAMPEL' => $this->input->post('KODE_SAMPEL'),
								  'WAKTU' => 'GETDATE()',
								  'USER_ID' => $this->newsession->userdata('SESS_USER_ID'),
								  'KEGIATAN' => 'Update perubahan hasil parameter',
								  'CATATAN' => $catatan);
						$this->db->insert('T_SAMPLING_LOG', $data);
					return 'MSG#YES#'.$msgok.'#'.$this->input->post('UJI_ID').'#<a href="javascript:;" class="view-hasil" url = "'.site_url().'/get/pengujian/get_hasil/" kode = "'.$this->input->post('KODE_SAMPEL').'">'.$dtparams['HASIL_PARAMETER'].'</a>';
				}else{
					return "MSG#YES#$msgerr";
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