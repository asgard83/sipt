<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);

class TL_act extends Model{
	
	function get_perbaikan($sarana="",$jenis="",$periksa="",$id=""){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$sipt->load->model("main", "main", true);
			$disinput = array("JENISDIS","NAMADIS");
			$jenis_sarana = $sipt->main->combobox("SELECT A.JENIS_SARANA_ID, A.NAMA_JENIS_SARANA, B.JENIS_SARANA_ID AS JENISDIS, B.NAMA_JENIS_SARANA AS NAMADIS FROM M_JENIS_SARANA A LEFT JOIN M_JENIS_SARANA B ON LEFT(A.JENIS_SARANA_ID, 2) = B.JENIS_SARANA_ID WHERE A.JENIS_SARANA_ID IN (SELECT SARANA_MEDIA_ID FROM T_USER_ROLE WHERE USER_ID='".$this->newsession->userdata('SESS_USER_ID')."') AND A.JENIS_SARANA_ID = '".$jenis."' ORDER BY A.JENIS_SARANA_ID ASC","JENIS_SARANA_ID","NAMA_JENIS_SARANA", FALSE, $disinput);
			$pejabat = $sipt->main->combobox("SELECT NIP, NAMA+'&nbsp;&nbsp;'+JABATAN AS NAMA FROM M_PEJABAT","NIP","NAMA", TRUE);
			if($id==""){
				$arrdata = array('act' => site_url().'/pemeriksaan/pemeriksaan/set_tl/save',
								 'surat_id' => '',
								 'jenis' => $jenis_sarana,
								 'disinput' => $disinput,
								 'simpan' => 'Simpan',
								 'urlback' => site_url()."/home/pelaporan/pemeriksaan/view/recomended");
				$arrdata['sel_jenis'] = '';
			}else{
				$query = "SELECT A.SURAT_ID, A.PERIKSA_ID, A.JENIS_SARANA_ID, A.NOMOR_SURAT, CONVERT(VARCHAR(10), A.TANGGAL_SURAT, 103) AS TANGGAL_SURAT, A.PEJABAT_TTD, B.NAMA, A.PERIHAL, A.LAMPIRAN, A.TEMPAT_TTD, A.TEMBUSAN FROM T_SURAT_TINDAK_LANJUT A LEFT JOIN M_PEJABAT B ON A.PEJABAT_TTD = B.NIP WHERE A.SURAT_ID = '$id'";
				$data = $sipt->main->get_result($query);
				if($data){
					foreach($query->result_array() as $row){
						$arrdata = array('act' => site_url().'/pemeriksaan/pemeriksaan/set_tl/update',
										 'sess' => $row,
										 'surat_id' => $row['SURAT_ID'],
										 'sel_jenis' => $row['JENIS_SARANA_ID'],
										 'jenis' => $jenis,
										 'simpan' => 'Update',
										 'hide' => TRUE,
										 'istable' => FALSE);
					}
				}
			}
			$arrisi = $this->get_jenis($jenis, $id);
			$arrdata['pejabat'] = $pejabat;
			$arrdata['load_jenis'] = $this->load->view("pemeriksaan/tl/".$jenis, $arrisi, true);
			return $arrdata;
		}else{
			$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');	
		}
	}
	
	function get_tl($submenu,$doc,$kk,$id,$subid){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$sipt->load->model("main", "main", true);
			$id = explode(".",$id);
			$arrstatus = array('90','91','92','93');
			$disinput = array("JENISDIS","NAMADIS");
			$jenis = $sipt->main->combobox("SELECT A.JENIS_SARANA_ID, A.NAMA_JENIS_SARANA, B.JENIS_SARANA_ID AS JENISDIS, B.NAMA_JENIS_SARANA AS NAMADIS FROM M_JENIS_SARANA A LEFT JOIN M_JENIS_SARANA B ON LEFT(A.JENIS_SARANA_ID, 2) = B.JENIS_SARANA_ID WHERE A.JENIS_SARANA_ID IN (SELECT SARANA_MEDIA_ID FROM T_USER_ROLE WHERE USER_ID='".$this->newsession->userdata('SESS_USER_ID')."') AND A.JENIS_SARANA_ID = '".$doc."' ORDER BY A.JENIS_SARANA_ID ASC","JENIS_SARANA_ID","NAMA_JENIS_SARANA", FALSE, $disinput);
			$pejabat = $sipt->main->combobox("SELECT NIP, NAMA+'&nbsp;&nbsp;'+JABATAN AS NAMA FROM M_PEJABAT","NIP","NAMA", TRUE);
			if($subid==""){
				if(!in_array($id[1], $arrstatus)) return redirect(base_url());
				$arrdata = array('act' => site_url().'/pemeriksaan/pemeriksaan/set_tl/save',
								 'surat_id' => '',
								 'jenis' => $jenis,
								 'disinput' => $disinput,
								 'simpan' => 'Simpan',
								 'urlback' => site_url()."/home/pelaporan/pemeriksaan/view/recomended");
				$jml = (int)$sipt->main->get_uraian("SELECT COUNT(SURAT_ID) AS JML FROM T_SURAT_TINDAK_LANJUT WHERE PERIKSA_ID='$id[0]'","JML");
				if($jml > 0){ 
					$arrdata['istable'] = TRUE;
					$arrdata['hide'] = FALSE;
				}
				else{
					$arrdata['istable'] = FALSE;
					$arrdata['hide'] = TRUE;
				}
				$arrdata['sel_jenis'] = $kk;
			}else{
				$query = "SELECT A.SURAT_ID, A.PERIKSA_ID, A.JENIS_SARANA_ID, A.NOMOR_SURAT, CONVERT(VARCHAR(10), A.TANGGAL_SURAT, 103) AS TANGGAL_SURAT, A.PEJABAT_TTD, B.NAMA, A.PERIHAL, A.LAMPIRAN, A.TEMPAT_TTD, A.TEMBUSAN FROM T_SURAT_TINDAK_LANJUT A LEFT JOIN M_PEJABAT B ON A.PEJABAT_TTD = B.NIP WHERE A.SURAT_ID = $subid";
				$data = $sipt->main->get_result($query);
				if($data){
					foreach($query->result_array() as $row){
						$arrdata = array('act' => site_url().'/pemeriksaan/pemeriksaan/set_tl/update',
										 'sess' => $row,
										 'surat_id' => $row['SURAT_ID'],
										 'sel_jenis' => $row['JENIS_SARANA_ID'],
										 'jenis' => $jenis,
										 'simpan' => 'Update',
										 'urlback' => site_url().'/home/pelaporan/rekomendasi/'.$submenu.'/'.$doc.'/'.$kk.'/'.join(".",$id),
										 'hide' => TRUE,
										 'istable' => FALSE);
					}
				}
			}
			$arrisi = $this->get_jenis($doc, $id);
			$arrdata['pejabat'] = $pejabat;
			$arrdata['load_jenis'] = $this->load->view("pemeriksaan/tl/".$doc, $arrisi, true);
			if(array_key_exists('2', $this->newsession->userdata('SESS_KODE_ROLE'))){
				$status = " AND Z.STATUS = '90'";
			}else if(array_key_exists('3', $this->newsession->userdata('SESS_KODE_ROLE'))){
				$status = " AND Z.STATUS = '91'";
			}else if(array_key_exists('4', $this->newsession->userdata('SESS_KODE_ROLE'))){
				$status = " AND Z.STATUS = '92'";
			}else if(array_key_exists('5', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('6', $this->newsession->userdata('SESS_KODE_ROLE'))){
				$status = " AND Z.STATUS = '93'";
			}
			
			$query = "SELECT (CAST(Z.SARANA_ID AS VARCHAR) + '/' + Z.JENIS_SARANA_ID + '/' + STUFF(dbo.GROUP_KLASIFIKASI(Z.PERIKSA_ID),1,1,'') + '/' + CAST(Z.PERIKSA_ID AS VARCHAR) + '.' + Z.STATUS +'/'+ CAST(A.SURAT_ID AS VARCHAR)) AS IDPERIKSA, A.SURAT_ID, A.PERIKSA_ID, A.NOMOR_SURAT AS [NOMOR SURAT], CONVERT(VARCHAR(10), A.TANGGAL_SURAT, 103) AS [TANGGAL SURAT], B.NAMA AS [PEJABAT PENANDA TANGAN], X.URAIAN AS PERIHAL, A.LAMPIRAN FROM T_SURAT_TINDAK_LANJUT A LEFT JOIN M_PEJABAT B ON A.PEJABAT_TTD = B.NIP LEFT JOIN T_PEMERIKSAAN Z ON A.PERIKSA_ID = Z.PERIKSA_ID LEFT JOIN M_TABEL X ON A.PERIHAL = X.KODE WHERE A.PERIKSA_ID = '$id[0]' AND X.JENIS = 'JENIS_SURAT' $status AND Z.BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'";
			$this->load->library('newtable');
			$this->newtable->search(array(array('', '')));
			$this->newtable->hiddens(array('SURAT_ID','PERIKSA_ID','IDPERIKSA'));
			$this->newtable->columns(array("(CAST(Z.SARANA_ID AS VARCHAR) + '/' + Z.JENIS_SARANA_ID + '/' + STUFF(dbo.GROUP_KLASIFIKASI(Z.PERIKSA_ID),1,1,'') + '/' + CAST(Z.PERIKSA_ID AS VARCHAR) + '.' + Z.STATUS +'/'+ CAST(A.SURAT_ID AS VARCHAR))","A.SURAT_ID", "A.PERIKSA_ID", "A.NOMOR_SURAT", "CONVERT(VARCHAR(10), A.TANGGAL_SURAT, 103)", "B.NAMA", "X.URAIAN", "A.LAMPIRAN"));
			if(array_key_exists('5', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('6', $this->newsession->userdata('SESS_KODE_ROLE'))){
				$proses = array('Terbit Surat Tindak Lanjut' => array('GETNEW',site_url().'/pemeriksaan/detail/prev_surat','1'));
			}else{
				if(array_key_exists('2', $this->newsession->userdata('SESS_KODE_ROLE'))){
					$action = "operator";
				}else if(array_key_exists('3', $this->newsession->userdata('SESS_KODE_ROLE'))){
					$action = "spv1";
				}else if(array_key_exists('4', $this->newsession->userdata('SESS_KODE_ROLE'))){
					$action = "spv2";
				}
				$proses = array('Edit Surat Tindak Lanjut' => array('GET', site_url()."/home/pelaporan/rekomendasi", '1'),'Proses Surat Tindak Lanjut' => array('POST',site_url().'/pemeriksaan/pemeriksaan/proses_tl/'.$action.'/ajax','N'));
			}
			$this->newtable->action(site_url());
			$this->newtable->cidb($this->db);
			$this->newtable->ciuri($this->uri->segment_array());
			if($id[1] != '93'){
			$this->newtable->detail(site_url()."/pemeriksaan/detail/prev_surat");
			}
			$this->newtable->orderby(2);
			$this->newtable->sortby("ASC");
			$this->newtable->keys("IDPERIKSA");
			$this->newtable->rowcount("ALL");
			$this->newtable->show_search(FALSE);
			$this->newtable->menu($proses);
			$tabel = $this->newtable->generate($query);
			$arrdata['url_preview'] = site_url().'/home/proses/'.$submenu.'/'.$doc.'/'.$kk.'/'.join(".",$id).'/1';
			$arrdata['url_'] = site_url().'/home/pelaporan/rekomendasi/'.$submenu.'/'.$doc.'/'.$kk.'/'.join(".",$id);
			$arrdata['periksa_id'] = $id[0];
			$arrdata['tabel'] = $tabel;
			return $arrdata;
		}else{
			$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');	
		}
	}
	
	function get_jenis($jenis, $id){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$sipt->load->model("main", "main", true);
			if($jenis!=""){
				if($jenis == "01JJ"){#Insert Pangan
					$perihal = $sipt->main->combobox("SELECT KODE, URAIAN FROM M_TABEL WHERE JENIS = 'JENIS_SURAT' AND (LEFT(KODE, 2) = '30')","KODE","URAIAN", TRUE);
					$tsurat = array("Peringatan" => "Peringatan", "Peringatan Keras" => "Peringatan Keras");
					$query = "SELECT PERIHAL, POINT, PELANGGARAN, KETENTUAN, TINDAKAN, KETERANGAN FROM T_SURAT_TINDAK_LANJUT WHERE PERIKSA_ID = '$id[0]'";
					$point = $sipt->main->combobox("SELECT KODE, URAIAN FROM M_TABEL WHERE JENIS = 'PELANGGARAN_PANGAN'","URAIAN","URAIAN");
					$bbpom = array('');
				}
				
				else if($jenis=="02LL" || $jenis=="02MM" || $jenis=="02TF" || $jenis=="03AA" || $jenis=="03BB" || $jenis=="03RS" || $jenis=="03TR" || $jenis=="03WW"){#Ditwas Distribusi
					if(in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')) && $this->newsession->userdata('SESS_BBPOM_ID') == "92"){
						$perihal = $sipt->main->combobox("SELECT KODE, URAIAN FROM M_TABEL WHERE JENIS = 'JENIS_SURAT' AND (LEFT(KODE, 2) = '11')","KODE","URAIAN", TRUE);
					}else{
						$perihal = $sipt->main->combobox("SELECT KODE, URAIAN FROM M_TABEL WHERE JENIS = 'JENIS_SURAT' AND KODE IN ('F01')","KODE","URAIAN", TRUE);
					}
					$tsurat = array('');
					$query = "SELECT PERIHAL, BBPOM_ID, AWAL_PSK, AKHIR_PSK, TINDAKAN, PIHAK FROM T_SURAT_TINDAK_LANJUT WHERE PERIKSA_ID = '$id[0]'";
					$bbpom = $sipt->main->combobox("SELECT BBPOM_ID, NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID NOT IN ('00','91','93','94','95','99')","BBPOM_ID","NAMA_BBPOM", TRUE);
				}
				
				else if($jenis=="01KO" || $jenis=="02KO" || $jenis=="01HH" || $jenis=="02OT"){#Insert OTKOSPK
					$perihal = $sipt->main->combobox("SELECT KODE, URAIAN FROM M_TABEL WHERE JENIS = 'JENIS_SURAT' AND (LEFT(KODE, 2) = '21')","KODE","URAIAN", TRUE);
					$tsurat = array('');
					$query = "SELECT PERIHAL, BBPOM_ID, POINT, PELANGGARAN, TINDAKAN, AWAL_PSK, NOSERTIFIKAT, TGSERTIFIKAT, KETERANGAN FROM T_SURAT_TINDAK_LANJUT WHERE PERIKSA_ID = '$id[0]'";
					$bbpom = $sipt->main->combobox("SELECT BBPOM_ID, NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID NOT IN ('00','91','92','93','95','99')","BBPOM_ID","NAMA_BBPOM", TRUE);
				}
				
				else if($jenis=="01OO"){#Ditwas Produksi
					$perihal = array('');
					$tsurat = array('');
					$bbpom = $sipt->main->combobox("SELECT BBPOM_ID, NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID NOT IN ('00','92','93','94','95','99')","BBPOM_ID","NAMA_BBPOM", TRUE);
					$query = "";
				}
				
				if($id == ""){
					$arrdata = array('sess_' => '','jml_point' => array(), 'pelanggaran' => array());
				}else{
					if($query!=""){
						$data = $sipt->main->get_result($query);
						if($data){
							foreach($query->result_array() as $row){
								$arrdata = array('sess_' => $row);
							}
							$arrdata['jml_point'] = explode("||",$row['POINT']);
							$arrdata['pelanggaran'] = explode("||", $row['PELANGGARAN']);
						}
					}
				}
				
			}else if($jenis==""){
				$arrdata = array();
			}
			$arrdata['bbpom'] = $bbpom;
			$arrdata['perihal'] = $perihal;
			$arrdata['point'] = $point;
			$arrdata['tsurat'] = $tsurat;
			return $arrdata;
		}else{
			$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
		}
	}
	
	
	function set_tl($action, $isajax){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main","main", true);
			if($action=="save"){
				$tl_id = (int)$sipt->main->get_uraian("SELECT MAX(SURAT_ID) AS MAXID FROM T_SURAT_TINDAK_LANJUT", "MAXID") + 1;
				$arr_tl = array('SURAT_ID' => $tl_id,
								'PERIKSA_ID' => $this->input->post('PERIKSA_ID'),
							    'CREATE_BY' => $this->newsession->userdata('SESS_USER_ID'),
							    'CREATE_DATE' => 'GETDATE()');
				foreach($this->input->post('TL') as $a => $b){
					if(!is_array($b))
						$arr_tl[$a] = $b;
					else
						$arr_tl[$a] = join("||", $b);
				}
				
				$cek_pejabat = (int)$sipt->main->get_uraian("SELECT COUNT(*) AS INVALID FROM T_USER WHERE USER_ID = '".$arr_tl['PEJABAT_TTD']."'", "INVALID");
				
				if($cek_pejabat < 0 || $cek_pejabat == NULL) return "MSG#NO#Pejabat Penanda Tangan Tidak Sah#";
				
				if($this->db->insert('T_SURAT_TINDAK_LANJUT', $arr_tl)){
					$no = (int)$sipt->main->get_uraian("SELECT MAX(SERI) AS MAXID FROM T_PEMERIKSAAN_PROSES WHERE PERIKSA_ID = '".$this->input->post('PERIKSA_ID')."'", "MAXID") + 1;
					$arr_log = array('PERIKSA_ID' => $this->input->post('PERIKSA_ID'),
									 'SERI' => $no,
									 'HASIL' => '90',
									 'CATATAN' => 'Pembuatan Surat Tindak Lanjut',
									 'CREATE_BY' => $this->newsession->userdata('SESS_USER_ID'),
									 'CREATE_DATE' => 'GETDATE()');
					$this->db->insert('T_PEMERIKSAAN_PROSES', $arr_log);
					if($isajax!="ajax"){
						redirect(base_url());
						exit();
					}
					return "MSG#YES#Data berhasil disimpan#".$this->input->post('URL');					
				}				
							
			}else if($action="update"){
				foreach($this->input->post('TL') as $a => $b){
					if(!is_array($b))
						$arr_tl[$a] = $b;
					else
						$arr_tl[$a] = join("||", $b);
				}
				$this->db->where(array("SURAT_ID" => $this->input->post('SURAT_ID')));					   
				if($this->db->update('T_SURAT_TINDAK_LANJUT', $arr_tl)){	
					$no = (int)$sipt->main->get_uraian("SELECT MAX(SERI) AS MAXID FROM T_PEMERIKSAAN_PROSES WHERE PERIKSA_ID = '".$this->input->post('PERIKSA_ID')."'", "MAXID") + 1;
					$arr_log = array('PERIKSA_ID' => $this->input->post('PERIKSA_ID'),
									 'SERI' => $no,
									 'HASIL' => '90',
									 'CATATAN' => 'Update Surat Tindak Lanjut',
									 'CREATE_BY' => $this->newsession->userdata('SESS_USER_ID'),
									 'CREATE_DATE' => 'GETDATE()');
					$this->db->insert('T_PEMERIKSAAN_PROSES', $arr_log);
					if($isajax!="ajax"){
						redirect(base_url());
						exit();
					}
					return "MSG#YES#Data berhasil disimpan#".$this->input->post('URL');					
				}
			}
		}else{
			$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');	
		}
	}
	
	function proses_tl($action, $isajax){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$sipt->load->model("main", "main", true);
			$ret = "MSG#Data Gagal Dikirim.";
			foreach($this->input->post('tb_chk') as $a){
				$split_uri = explode("/", $a);
				$id_uri = explode(".", $split_uri[3]);
				if($action == "operator"){
					$arr_status = array("STATUS" => "91");
					$hasil = '91';
					$catatan = 'Proses Surat Tindak Lanjut Oleh Operator';
				}else if($action == "spv1"){
					$arr_status = array("STATUS" => "92");
					$hasil = '92';
					$catatan = 'Proses Surat Tindak Lanjut Oleh Supervisor Satu';
				}else if($action == "spv2"){
					$arr_status = array("STATUS" => "93");
					$hasil = '93';
					$catatan = 'Proses Surat Tindak Lanjut Oleh Supervisor Dua';
				}
				$this->db->where('PERIKSA_ID', $id_uri[0]);
				if($this->db->update('T_PEMERIKSAAN', $arr_status)){ 
					$seri = (int)$sipt->main->get_uraian("SELECT MAX(SERI) AS MAXID FROM T_PEMERIKSAAN_PROSES WHERE PERIKSA_ID = '".$id_uri[0]."'", "MAXID") + 1;
					$arr_proses = array('PERIKSA_ID' => $id_uri[0],
									  'SERI' => $seri,
									  'HASIL' => $hasil,
									  'CATATAN' => $catatan,
									  'CREATE_BY' => $this->newsession->userdata('SESS_USER_ID'),
									  'CREATE_DATE' => 'GETDATE()');
					$this->db->insert('T_PEMERIKSAAN_PROSES', $arr_proses);
				}
				$ret = "MSG#Data Berhasil Dikirim#".site_url().'/home/pelaporan/pemeriksaan/view/send'; 
			}
			
			if($isajax!="ajax"){
				redirect(base_url());
				exit();
			}
			return $ret;
		}
	}
		
			
}

?>