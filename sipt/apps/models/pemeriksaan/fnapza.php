<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);

class FNapza extends Model{
	
	function GetFormNapza($sarana, $jenis, $klasifikasi, $idperiksa){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			if(!array_key_exists($jenis, $this->newsession->userdata("SESS_SARANA")) && !array_key_exists($klasifikasi, $this->newsession->userdata("SESS_KLASIFIKASI_ID"))) return $this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
			$sipt =& get_instance();
			$sipt->load->model("main", "main", true);
			if($idperiksa==""){#Input Mode 
				  if(!$this->session->userdata('SURAT')) return $this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
				  $qsarana = "SELECT SARANA_ID, JENIS_SARANA, NAMA_SARANA, PENANGGUNG_JAWAB, ALAMAT_1 AS ALAMAT, TELEPON FROM M_SARANA WHERE SARANA_ID='$sarana'";
				  $dt_sarana = $sipt->main->get_result($qsarana);
				  if($dt_sarana){
					  foreach($qsarana->result_array() as $row){
						  $arrdata = array('sess' => $row,
						  				   'SURAT_ID' => '',
										   'BBPOM_ID' => $this->newsession->userdata('SESS_BBPOM_ID'),
						  				   'temuan_produk' => array(),
										   'act' => site_url().'/post/pemeriksaan/set_periksa/napza/simpan',
										   'urlback' => site_url().'/home/pelaporan/pemeriksaan');
					  }
				  }
			}else{
				  $idperiksa = explode(".", $idperiksa);
				  $status = $idperiksa[1];
				  $qperiksa = "SELECT(SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN_TEMUAN_PRODUK WHERE PERIKSA_ID='$idperiksa[0]') AS JML_TEMUAN, A.SARANA_ID, A.NAMA_SARANA, A.PENANGGUNG_JAWAB, A.NAMA_APA, A.ALAMAT_1 AS ALAMAT, A.TELEPON, B.PERIKSA_ID, B.JENIS_SARANA_ID, STUFF(dbo.GROUP_KLASIFIKASI(B.PERIKSA_ID),1,1,'') AS KK_ID, CONVERT(VARCHAR(10), B.AWAL_PERIKSA, 103) AS AWAL_PERIKSA, CONVERT(VARCHAR(10), B.AKHIR_PERIKSA, 103) AS AKHIR_PERIKSA, B.BBPOM_ID, C.TUJUAN_PEMERIKSAAN, C.DASAR_PEMERIKSAAN, CONVERT(VARCHAR(10), C.TANGGAL_TINDAKAN_BALAI, 103) AS TANGGAL_TINDAKAN_BALAI, C.DETAIL_TINDAKAN_BALAI, C.UNIT_BALAI, CONVERT(VARCHAR(10), C.TANGGAL_TINDAKAN_PUSAT, 103) AS TANGGAL_TINDAKAN_PUSAT, C.DETAIL_TINDAKAN_PUSAT, C.UNIT_PUSAT, C.FILE_BAP, C.FILE_LAMPIRAN_BAP, C.FILE_TINDAK_LANJUT, C.FILE_TL_BALAI, D.SERI, D.NAMA_PRODUK, D.KLASIFIKASI_PRODUK, D.JENIS_PELANGGARAN, D.JENIS_PENYIMPANGAN, D.JENIS_KRITERIA_PELANGGARAN, STUFF(dbo.GROUP_CONCAT(B.PERIKSA_ID),1,1,'') AS SURAT_ID FROM M_SARANA A LEFT JOIN T_PEMERIKSAAN B ON A.SARANA_ID = B.SARANA_ID LEFT JOIN T_PEMERIKSAAN_NAPZA C ON B.PERIKSA_ID = C.PERIKSA_ID LEFT JOIN T_PEMERIKSAAN_TEMUAN_PRODUK D ON B.PERIKSA_ID = D.PERIKSA_ID WHERE B.SARANA_ID='$sarana' AND B.PERIKSA_ID='$idperiksa[0]'";
				  $dt_periksa = $sipt->main->get_result($qperiksa);
				  if($dt_periksa){
					  foreach($qperiksa->result_array() as $row){
						  $temuan_produk[] = $row;
						  $arrdata = array('sess' => $row,
						  				   'sess_periksa' => '',
										   'temuan_produk' => $temuan_produk,
										   'urlback' => site_url().'/home/pelaporan/pemeriksaan/view/'.$status);
					  }
					  $arrdata['SURAT_ID'] = $row['SURAT_ID'];
					  $arrdata['BBPOM_ID'] = $row['BBPOM_ID'];
				  }
				  
				if($this->newsession->userdata('SESS_BBPOM_ID') != "93"){#Update dan Perbaikan Balai
					if($status=="20101"){
						$arrdata['act'] = site_url().'/post/pemeriksaan/set_periksa/napza/update';
					}else if($status=="20102" || $status =="20103"){
						$arrdata['act'] = site_url().'/post/pemeriksaan/set_periksa/napza/perbaikan';
					}else if($status=="60020"){
						$arrdata['act'] = site_url().'/post/pemeriksaan/set_periksa/napza/rekomendasi';
					}
				}else{#Update dan Perbaikan Pusat
					if($status=="20111"){
						$arrdata['act'] = site_url().'/post/pemeriksaan/set_periksa/napza/update';
					}else if($status =="20113" || $status =="20112"){
						$arrdata['act'] = site_url().'/post/pemeriksaan/set_periksa/napza/perbaikan';
					}else if($status=="60020"){
						$arrdata['act'] = site_url().'/post/pemeriksaan/set_periksa/napza/rekomendasi';
					}
				}
				  $arrdata['stat'] = $status;				  
				  $arrdata['status'] = $sipt->main->set_verifikasi($status, $this->newsession->userdata('SESS_JENIS_PELAPORAN'), $this->newsession->userdata('SESS_KODE_ROLE'));
				  $arrdata['disverifikasi'] = $status;
				  $arrdata['log'] = site_url().'/get/pemeriksaan/get_log/'.$idperiksa[0];
				  if($idperiksa[1] == "20113" || $idperiksa[1] == "20112"){
					  if($this->newsession->userdata('SESS_BBPOM_ID') <> $arrdata['BBPOM_ID']){
						  redirect(site_url().'/home/proses/'.$sarana.'/'.$jenis.'/'.$klasifikasi.'/'.join(".",$idperiksa)); exit();
					  }
				  }
			}
			
			$arrdata['headersarana'] = $sipt->main->get_judul($jenis);
			$arrdata['sarana_id'] = $sarana;
			$arrdata['jenis_sarana_id'] = $jenis;
			$arrdata['klasifikasi'] = $klasifikasi;
			$disinput = array("JENISDIS","NAMADIS");
			$arrdata['jenis_sarana'] =$sipt->main->combobox("SELECT A.JENIS_SARANA_ID, A.NAMA_JENIS_SARANA, B.JENIS_SARANA_ID AS JENISDIS, B.NAMA_JENIS_SARANA AS NAMADIS FROM M_JENIS_SARANA A LEFT JOIN M_JENIS_SARANA B ON LEFT(A.JENIS_SARANA_ID, 2) = B.JENIS_SARANA_ID WHERE A.JENIS_SARANA_ID IN (SELECT SARANA_MEDIA_ID FROM T_USER_ROLE WHERE USER_ID='".$this->newsession->userdata("SESS_USER_ID")."')ORDER BY A.JENIS_SARANA_ID ASC","JENIS_SARANA_ID","NAMA_JENIS_SARANA", TRUE, $disinput);
			$arrdata['tujuan_periksa'] = $sipt->main->referensi("TUJUAN_PEMERIKSAAN","'1','2','5','6','7'",TRUE,TRUE);
			$arrdata['klasifikasi_kategori'] = $sipt->main->get_klasifikasi();
			$arrdata['disinput'] = array("JENISDIS","NAMADIS");
			$arrdata['histori_petugas'] = site_url().'/load/petugas/get_petugas/'.$arrdata['SURAT_ID'];
			$arrdata['history_periksa'] = site_url().'/get/pemeriksaan/set_detail_periksa/'.$sarana."/".$jenis.'/'.$klasifikasi;
			$arrdata['ispelayanan'] = substr($jenis, 0, 2);
			return $arrdata;
		}
		else
		{
			$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
		}
	}
	
	function SaveFormNapza($action, $isajax){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main","main", true);
			if(in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')))
				$status = '20111';
			else
				$status = '20101';		  
			if($action=="simpan"){#Insert Mode
				#Cek Double
				$jml = $sipt->main->get_uraian("SELECT COUNT(*) AS JML FROM T_PEMERIKSAAN WHERE JENIS_SARANA_ID = '".$this->input->post('JENIS_SARANA_ID')."' AND SARANA_ID = '".$this->input->post('SARANA_ID')."' AND DATEDIFF(dy, 0, convert(DATETIME, AWAL_PERIKSA, 105)) = DATEDIFF(dy, 0, convert(DATETIME, '".$_POST['PEMERIKSAAN']['AWAL_PERIKSA']."', 105)) AND DATEDIFF(dy, 0, convert(DATETIME, AKHIR_PERIKSA, 105)) = DATEDIFF(dy, 0, convert(DATETIME, '".$_POST['PEMERIKSAAN']['AKHIR_PERIKSA']."', 105)) AND LEN(STATUS) > 2","JML");
				if($jml > 0){
					$nama = $sipt->main->get_uraian("SELECT LTRIM(NAMA_SARANA) AS NAMA_SARANA FROM M_SARANA WHERE SARANA_ID = '".$this->input->post('SARANA_ID')."'","NAMA_SARANA");
					$msg = "Untuk data pemeriksaan sarana : .".strtoupper($nama)."\n Dengan tanggal pemeriksaan : ".$_POST['PEMERIKSAAN']['AWAL_PERIKSA']." s.d ".$_POST['PEMERIKSAAN']['AKHIR_PERIKSA']."\n Data tersebut sudah pernah di entri, mohon untuk dikrosecek kembali";
					return "MSG#NO#".$msg;
					die();
				}
				#End Cek Double
				#INSERT SURAT TUGAS			
				$arr_nosurat = $this->session->userdata('SURAT');
				$arr_petugas = $this->session->userdata('USER');
				$arrkeys_surat = array_keys($arr_nosurat);
				$bap = $_POST['PEMERIKSAAN_NAPZA']['FILE_BAP'];
				$lapbap = $_POST['PEMERIKSAAN_NAPZA']['FILE_LAMPIRAN_BAP'];
				if($bap == "" && $lapbap == ""){
					return "MSG#NO#Data gagal disimpan, belum melampirkan File BAP atau Lampiran File BAP";
					exit();
				}
				$SES_ID = array();
				$surat_id = (int)$sipt->main->get_uraian("SELECT MAX(SURAT_ID) AS MAXSURAT FROM T_SURAT_TUGAS", "MAXSURAT") + 1;
				for($i=0;$i<count($arr_nosurat[$arrkeys_surat[0]]);$i++){
					$surat = array('SURAT_ID' => $surat_id,
								   'CREATE_BY' => $this->newsession->userdata('SESS_USER_ID'),
								   'CREATE_DATE' => 'GETDATE()');
					for($j=0;$j<count($arrkeys_surat);$j++){
						$surat[$arrkeys_surat[$j]] = $arr_nosurat[$arrkeys_surat[$j]][$i];
					}
					$this->db->insert('T_SURAT_TUGAS', $surat);
					if(count($arr_petugas)>0){
						foreach($arr_petugas[$i] as $a){
							$surat_petugas['SURAT_ID'] = $surat_id;
							$surat_petugas['USER_ID'] = $a;
							$this->db->insert('T_SURAT_TUGAS_PETUGAS', $surat_petugas);
						}
					}
					$SES_ID[$i] = $surat_id;
				}
				#INSERT PEMERIKSAAN
				$periksa_id = (int)$sipt->main->get_uraian("SELECT MAX(PERIKSA_ID) AS MAXID FROM T_PEMERIKSAAN", "MAXID") + 1;
				$arr_pemeriksaan = array('PERIKSA_ID' => $periksa_id,
										 'BBPOM_ID' => $this->newsession->userdata('SESS_BBPOM_ID'),
										 'JENIS_SARANA_ID' => $this->input->post('JENIS_SARANA_ID'),
										 'SARANA_ID' => $this->input->post('SARANA_ID'),
										 'CREATE_BY' => $this->newsession->userdata('SESS_USER_ID'),
										 'CREATE_DATE' => 'GETDATE()',
										 'STATUS' => $status,
										 'UPDATE_BY' => $this->newsession->userdata('SESS_USER_ID'),
										 'LAST_UPDATE' => 'GETDATE()');
				foreach($this->input->post('PEMERIKSAAN') as $a => $b){
					$arr_pemeriksaan[$a] = $b;
				}
				if($this->db->insert('T_PEMERIKSAAN', $arr_pemeriksaan)){
					$arr_klasifikasi = explode("-", $this->input->post('KLASIFIKASI'));
					$arr_napza = array('PERIKSA_ID' => $periksa_id);
					foreach($this->input->post('PEMERIKSAAN_NAPZA') as $c => $d){
						$arr_napza[$c] = $d;
					}
					if(array_key_exists('TANGGAL_TINDAKAN_BALAI',$arr_napza)){
						if($arr_napza['TANGGAL_TINDAKAN_BALAI'] == "") $arr_napza['TANGGAL_TINDAKAN_BALAI'] = null;
					}
					if(array_key_exists('TANGGAL_TINDAKAN_PUSAT',$arr_napza)){
						if($arr_napza['TANGGAL_TINDAKAN_PUSAT'] == "") $arr_napza['TANGGAL_TINDAKAN_PUSAT'] = null;
					}
					$this->db->insert('T_PEMERIKSAAN_NAPZA', $arr_napza);
					
					foreach($SES_ID as $a){
						$pelaporan = array('SURAT_ID' => $a, 'LAPOR_ID' => $periksa_id);
						$this->db->insert('T_SURAT_TUGAS_PELAPORAN', $pelaporan);
					}
					
					foreach($arr_klasifikasi as $kk_id){
						$pemeriksaan_klasifikasi = array('PERIKSA_ID' => $periksa_id, 'KK_ID' => $kk_id);
						$this->db->insert('T_PEMERIKSAAN_KLASIFIKASI', $pemeriksaan_klasifikasi);
					}
					
					if($this->input->post('TEMUAN')){					
						$arrtemuan = $this->input->post('TEMUAN');
						$arrkeys = array_keys($arrtemuan);
						for($i=0;$i<count($arrtemuan[$arrkeys[0]]);$i++){
							$seri = (int)$sipt->main->get_uraian("SELECT MAX(SERI) AS MAXID FROM T_PEMERIKSAAN_TEMUAN_PRODUK WHERE PERIKSA_ID = '$periksa_id'", "MAXID") + 1;
							$temuan = array('PERIKSA_ID' => $periksa_id,
											'SERI' => $seri);
							for($j=0;$j<count($arrkeys);$j++){
								$temuan[$arrkeys[$j]] = $arrtemuan[$arrkeys[$j]][$i];
							}
							$this->db->insert('T_PEMERIKSAAN_TEMUAN_PRODUK', $temuan);
						}
						$array_cek = array_count_values($arrtemuan['JENIS_KRITERIA_PELANGGARAN']);
						$HSL = $sipt->main->hasil_array($array_cek);
					}else{
						$HSL = "MK";
					}
					
					$this->db->where('PERIKSA_ID', $periksa_id);
					$this->db->update('T_PEMERIKSAAN', array('HASIL' => $HSL));
					
					$no = (int)$sipt->main->get_uraian("SELECT MAX(SERI) AS MAXID FROM T_PEMERIKSAAN_PROSES WHERE PERIKSA_ID = '".$periksa_id."'", "MAXID") + 1;
					$arr_log = array('PERIKSA_ID' => $periksa_id,
										'SERI' => $no,
										'HASIL' => $status,
										'CATATAN' => 'Pemeriksaan sarana status draft',
										'CREATE_BY' => $this->newsession->userdata('SESS_USER_ID'),
										'CREATE_DATE' => 'GETDATE()');
					$this->db->insert('T_PEMERIKSAAN_PROSES', $arr_log);
					$sipt->main->get_kegiatan("Menambahkan Data Pemeriksaan Untuk Sarana : ".$this->input->post('NAMA_SARANA'));
					if($isajax!="ajax"){
						redirect(base_url());
						exit();
					}
					if(in_array('2', $this->newsession->userdata('SESS_KODE_ROLE'))){
						if(in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')))
							$redir = "20111";
						else
							$redir = "20101";
					}
					
					if($this->input->post('cb_konfirm') == "01"){#Temuan Sarana
						if($this->input->post('jns') != "" && $this->input->post('kk') != ""){
							return "MSG#YES#Data berhasil disimpan#".site_url()."/home/pemeriksaan/".$this->input->post('SARANA_ID')."/".$this->input->post('jns')."/".$this->input->post('kk');
						}else{
							return "MSG#YES#Data berhasil disimpan#".site_url()."/home/pelaporan/pemeriksaan/view/".substr($this->input->post('JENIS_SARANA_ID'),0,2)."/".$redir;
						}
					}else if($this->input->post('cb_konfirm') == "02"){#Temuan Produk
						return "MSG#YES#Data berhasil disimpan#".site_url()."/home/produk/add/".$this->input->post('SARANA_ID')."/".$this->input->post('JENIS_SARANA_ID')."/".$this->input->post('KLASIFIKASI')."/".$periksa_id;
					}else{
						return "MSG#YES#Data berhasil disimpan#".site_url()."/home/pelaporan/pemeriksaan/view/".substr($this->input->post('JENIS_SARANA_ID'),0,2)."/".$redir;
					}
				}
			}else if($action=="update" || $action=="perbaikan" || $action == "rekomendasi"){#Update
				  $arr_pemeriksaan = array('UPDATE_BY' => $this->newsession->userdata('SESS_USER_ID'),'LAST_UPDATE' => 'GETDATE()');
				  foreach($this->input->post('PEMERIKSAAN') as $a => $b){
				  	$arr_pemeriksaan[$a] = $b;
				  }				  
				  if($action=="perbaikan" || $action == "rekomendasi"){
					  if($this->newsession->userdata('SESS_BBPOM_ID') != "93"){
					  	$arr_pemeriksaan['STATUS'] = '30104';
						$status = "30104";
					  }else{
					  	$arr_pemeriksaan['STATUS'] = '30114';
						$status = "30114";
					  }
				  }		
				  $this->db->where(array("PERIKSA_ID" => $this->input->post('PERIKSA_ID')));					   
				  if($this->db->update('T_PEMERIKSAAN', $arr_pemeriksaan)){					  
					  foreach($this->input->post('PEMERIKSAAN_NAPZA') as $c => $d){
						  $arr_napza[$c] = $d;
					  }
					  if(array_key_exists('TANGGAL_TINDAKAN_BALAI',$arr_napza)){
						if($arr_napza['TANGGAL_TINDAKAN_BALAI'] == "") $arr_napza['TANGGAL_TINDAKAN_BALAI'] = null;
					  }
					  if(array_key_exists('TANGGAL_TINDAKAN_PUSAT',$arr_napza)){
						  if($arr_napza['TANGGAL_TINDAKAN_PUSAT'] == "") $arr_napza['TANGGAL_TINDAKAN_PUSAT'] = null;
					  }
					  $this->db->where(array("PERIKSA_ID" => $this->input->post('PERIKSA_ID')));
					  $this->db->update('T_PEMERIKSAAN_NAPZA', $arr_napza);
					  
					  if($this->input->post('TEMUAN')){
						  $this->db->where('PERIKSA_ID', $this->input->post('PERIKSA_ID'));
						  $this->db->delete('T_PEMERIKSAAN_TEMUAN_PRODUK');
						  $arrtemuan = $this->input->post('TEMUAN');
						  $arrkeys = array_keys($arrtemuan);
						  for($i=0;$i<count($arrtemuan[$arrkeys[0]]);$i++){
							  $seri = (int)$sipt->main->get_uraian("SELECT MAX(SERI) AS MAXID FROM T_PEMERIKSAAN_TEMUAN_PRODUK WHERE PERIKSA_ID = '".$this->input->post('PERIKSA_ID')."'", "MAXID") + 1;
							  $temuan = array('PERIKSA_ID' => $this->input->post('PERIKSA_ID'),
											  'SERI' => $seri);
							  for($j=0;$j<count($arrkeys);$j++){
								  $temuan[$arrkeys[$j]] = $arrtemuan[$arrkeys[$j]][$i];
							  }
							  $this->db->insert('T_PEMERIKSAAN_TEMUAN_PRODUK', $temuan);
						  }
						  $array_cek = array_count_values($arrtemuan['JENIS_KRITERIA_PELANGGARAN']);
						  $HSL = $sipt->main->hasil_array($array_cek);
					  }else{
						  $HSL = "MK";
					  }
					  
					  $this->db->where('PERIKSA_ID', $this->input->post('PERIKSA_ID'));
					  $this->db->update('T_PEMERIKSAAN', array('HASIL' => $HSL));
					  
					$no = (int)$sipt->main->get_uraian("SELECT MAX(SERI) AS MAXID FROM T_PEMERIKSAAN_PROSES WHERE PERIKSA_ID = '".$this->input->post('PERIKSA_ID')."'", "MAXID") + 1;
					$arr_log = array('PERIKSA_ID' => $this->input->post('PERIKSA_ID'),
										'SERI' => $no,
										'HASIL' => $status,
										'CREATE_BY' => $this->newsession->userdata('SESS_USER_ID'),
										'CREATE_DATE' => 'GETDATE()');
					if($action=="update"){
					  $sipt->main->get_kegiatan("Mengupdate Data Pemeriksaan Untuk Sarana : ".$this->input->post('NAMA_SARANA'));
					  $catatan = "Update Pemeriksaan sarana status draft";
					}else if($action=="perbaikan"){
						$sipt->main->get_kegiatan("Melakukan Perbaikan Data Pemeriksaan Untuk Sarana : ".$this->input->post('NAMA_SARANA'));
						$catatan = $this->input->post('catatan');
					}else if($action=="rekomendasi"){
						$sipt->main->get_kegiatan("Melakukan Perbaikan Data Pemeriksaan hasil rekomendasi pusat Untuk Sarana : ".$this->input->post('NAMA_SARANA'));
						$catatan = $this->input->post('catatan');
					}
					$no = (int)$sipt->main->get_uraian("SELECT MAX(SERI) AS MAXID FROM T_PEMERIKSAAN_PROSES WHERE PERIKSA_ID = '".$this->input->post('PERIKSA_ID')."'", "MAXID") + 1;
					$arr_log = array('PERIKSA_ID' => $this->input->post('PERIKSA_ID'),
								     'SERI' => $no,
									 'HASIL' => $status,
									 'CATATAN' => $catatan,
									 'CREATE_BY' => $this->newsession->userdata('SESS_USER_ID'),
									 'CREATE_DATE' => 'GETDATE()');
					$this->db->insert('T_PEMERIKSAAN_PROSES', $arr_log);
					if($isajax!="ajax"){
						redirect(base_url());
						exit();
					}
					if($action=="update"){
						if(in_array('2', $this->newsession->userdata('SESS_KODE_ROLE'))){
							if(in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')))
								$redir = "20111";
							else
								$redir = "20101";
						}
						return "MSG#YES#Data berhasil disimpan#".site_url()."/home/pelaporan/pemeriksaan/view/".substr($this->input->post('JENIS_SARANA_ID'), 0,2)."/".$redir."#".site_url()."/post/pemeriksaan/set_confirm/ajax/".$periksa_id;
					}else if($action=="perbaikan" || $action == "rekomendasi"){
						return "MSG#YES#Data berhasil disimpan#".site_url()."/home/pelaporan/pemeriksaan/view/all/send";
					}
				  }
			}
			
			else if($action == "update-tl-balai"){
				$hasil = FALSE;
				$msgok = "Update Tindak Lanjut berhasil";
				$msgerr = "Update Tindak Lanjut gagal";
				foreach($this->input->post('PEMERIKSAAN') as $a => $b){
					$arrnapza[$a] = $b;
				}	
				if(array_key_exists('TANGGAL_TINDAKAN_BALAI',$arrnapza)){
					if($arrnapza['TANGGAL_TINDAKAN_BALAI'] == "") $arrnapza['TANGGAL_TINDAKAN_BALAI'] = null;
				}
				if(array_key_exists('TANGGAL_TINDAKAN_PUSAT',$arrnapza)){
					if($arrnapza['TANGGAL_TINDAKAN_PUSAT'] == "") $arrnapza['TANGGAL_TINDAKAN_PUSAT'] = null;
				}
				$this->db->where(array("PERIKSA_ID" => $this->input->post('PERIKSA_ID')));
				$res = $this->db->update('T_PEMERIKSAAN_NAPZA', $arrnapza);
				if($res){
					$hasil = TRUE;
				}
				if($hasil) return "MSG#YES#$msgok#SUKSES";
				else return "MSG#NO#$msgerr";
			}
			
			else if($action == "update-perbaikan-balai"){
				$hasil = FALSE;
				$msgok = "Simpan perbaikan berhasil";
				$msgerr = "Simpan perbaikan gagal";
				$perbaikan = (int)$sipt->main->get_uraian("SELECT MAX(SERI) AS MAXID FROM T_PEMERIKSAAN_NAPZA_PERBAIKAN WHERE PERIKSA_ID = '".$this->input->post('PERIKSA_ID')."'", "MAXID") + 1;
				$arr_perbaikan = array('PERIKSA_ID' => $this->input->post('PERIKSA_ID'),
									   'SERI' => $perbaikan,
									   'CREATE_BY' => $this->newsession->userdata('SESS_USER_ID'),
									   'CREATE_DATE' => 'GETDATE()');
				foreach($this->input->post('PERBAIKAN') as $a => $b){
					$arr_perbaikan[$a] = $b;
				}	
				if(array_key_exists('TANGGAL_PERBAIKAN',$arr_perbaikan)){
					if($arr_perbaikan['TANGGAL_PERBAIKAN'] == "") $arr_perbaikan['TANGGAL_PERBAIKAN'] = null;
				}
				$res = $this->db->insert('T_PEMERIKSAAN_NAPZA_PERBAIKAN', $arr_perbaikan);
				if($res){
					$hasil = TRUE;
				}
				if($hasil) return "MSG#YES#$msgok#SUKSES";
				else return "MSG#NO#$msgerr";
			}
		}
		else{
			$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
		}
	}
	
	function get_preview($sarana,$id,$jenis){
		$sipt =& get_instance();
		$this->load->model("main","main", true);
		$id = explode(".", $id);
		$query = "SELECT (CAST(A.SARANA_ID AS VARCHAR) + '/' + A.JENIS_SARANA_ID + '/' + STUFF(dbo.GROUP_KLASIFIKASI(A.PERIKSA_ID),1,1,'') + '/' + CAST(A.PERIKSA_ID AS VARCHAR) + '.' + A.STATUS) AS IDPERIKSA, A.PERIKSA_ID, A.SARANA_ID, A.STATUS, CONVERT(VARCHAR(10), A.AWAL_PERIKSA, 103) AS [AWAL_PERIKSA], CONVERT(VARCHAR(10), A.AKHIR_PERIKSA, 103) AS [AKHIR_PERIKSA], B.TUJUAN_PEMERIKSAAN, B.DASAR_PEMERIKSAAN, B.UNIT_BALAI, CONVERT(VARCHAR(10), B.TANGGAL_TINDAKAN_BALAI, 103) AS [TANGGAL_TINDAKAN_BALAI], B.FILE_BAP, B.FILE_LAMPIRAN_BAP, B.FILE_TL_BALAI,  B.UNIT_PUSAT, CONVERT(VARCHAR(10), B.TANGGAL_TINDAKAN_PUSAT, 103) AS [TANGGAL_TINDAKAN_PUSAT], B.FILE_TINDAK_LANJUT, STUFF(dbo.GROUP_CONCAT(A.PERIKSA_ID),1,1,'') AS SURAT_ID, A.CREATE_BY FROM T_PEMERIKSAAN A LEFT JOIN T_PEMERIKSAAN_NAPZA B ON A.PERIKSA_ID = B.PERIKSA_ID WHERE A.SARANA_ID = '$sarana' AND A.PERIKSA_ID = '$id[0]'";
		$judul = $sipt->main->get_judul($jenis);
		$data = $sipt->main->get_result($query);
		if($data){
			foreach($query->result_array() as $row){
				$arrdata = array('sess' => $row, 'judul' => $judul);
			}
			$arrdata['histori_petugas'] = site_url().'/load/petugas/get_petugas/'.$row['SURAT_ID'];
			
		}
		return $arrdata;
	}
	
	function input_preview($sarana,$jenis,$idperiksa,$subid){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE ){
			$sipt =& get_instance();
			$sipt->load->model("main","main", true);
			$idperiksa = explode(".", $idperiksa);
			$stat = $idperiksa[1];
			$query = "SELECT(SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN_TEMUAN_PRODUK WHERE PERIKSA_ID='$idperiksa[0]') AS JML_TEMUAN,(SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN_NAPZA_PERBAIKAN WHERE PERIKSA_ID='$idperiksa[0]') AS JML_PERBAIKAN, (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN_PROSES WHERE PERIKSA_ID = '$idperiksa[0]') AS JML_PROSES, A.SARANA_ID, A.NAMA_SARANA, A.PENANGGUNG_JAWAB, A.NAMA_APA, A.ALAMAT_1 AS ALAMAT, A.TELEPON, B.PERIKSA_ID, B.JENIS_SARANA_ID, B.BBPOM_ID, CONVERT(VARCHAR(10), B.AWAL_PERIKSA, 103) AS AWAL_PERIKSA, CONVERT(VARCHAR(10), B.AKHIR_PERIKSA, 103) AS AKHIR_PERIKSA, C.TUJUAN_PEMERIKSAAN, C.DASAR_PEMERIKSAAN, CASE WHEN C.TANGGAL_TINDAKAN_BALAI IS NULL THEN '' ELSE CONVERT(VARCHAR(10), C.TANGGAL_TINDAKAN_BALAI, 103) END AS TANGGAL_TINDAKAN_BALAI, CASE WHEN C.TANGGAL_TINDAKAN_PUSAT IS NULL THEN '' ELSE CONVERT(VARCHAR(10), C.TANGGAL_TINDAKAN_PUSAT, 103) END AS TANGGAL_TINDAKAN_PUSAT, C.DETAIL_TINDAKAN_BALAI, C.UNIT_BALAI, C.DETAIL_TINDAKAN_PUSAT, C.UNIT_PUSAT, C.FILE_BAP, C.FILE_LAMPIRAN_BAP, C.FILE_TINDAK_LANJUT, C.FILE_TL_BALAI, D.SERI, D.NAMA_PRODUK, D.KLASIFIKASI_PRODUK, D.JENIS_PELANGGARAN, D.JENIS_PENYIMPANGAN, D.JENIS_KRITERIA_PELANGGARAN, STUFF(dbo.GROUP_CONCAT(B.PERIKSA_ID),1,1,'') AS SURAT_ID, B.CREATE_BY FROM M_SARANA A LEFT JOIN T_PEMERIKSAAN B ON A.SARANA_ID = B.SARANA_ID LEFT JOIN T_PEMERIKSAAN_NAPZA C ON B.PERIKSA_ID = C.PERIKSA_ID LEFT JOIN T_PEMERIKSAAN_TEMUAN_PRODUK D ON B.PERIKSA_ID = D.PERIKSA_ID WHERE B.SARANA_ID='$sarana' AND B.PERIKSA_ID='$idperiksa[0]'";
			$judul = $sipt->main->get_judul($jenis);
			$data = $sipt->main->get_result($query);
			if($data){
				foreach($query->result_array() as $row){
					$temuan_produk[] = $row;
					$arrdata = array('sess' => $row,
									 'temuan_produk' => $temuan_produk);
				}
				$arrdata['SURAT_ID'] = $row['SURAT_ID'];
				$arrdata['BBPOM_ID'] = $row['BBPOM_ID'];
			}
			
			if(array_key_exists('2', $this->newsession->userdata('SESS_KODE_ROLE'))){#Operator
				if($this->newsession->userdata('SESS_BBPOM_ID') != "93"){
					$isEditTLBalai = TRUE;
					$isEditTLPusat = FALSE;
					$arrdata['obj_napza'] = 'PEMERIKSAAN_NAPZA';
					if(strlen($row['DETAIL_TINDAKAN_PUSAT']) == "0"){
						$isPerbaikan = FALSE;
					}else{
						$isPerbaikan = TRUE;
					}
				}else{
					if($this->newsession->userdata('SESS_BBPOM_ID') == $arrdata['BBPOM_ID'])
						$isEditTLBalai = TRUE;
					else
						$isEditTLBalai = FALSE;					
					$isEditTLPusat = TRUE;
					$arrdata['obj_napza'] = 'PEMERIKSAAN_NAPZA_PUSAT';
					$isPerbaikan = TRUE;					
				}
				$arrdata['act'] = site_url().'/post/pemeriksaan/set_proses/napza/operator';
				$arrdata['obj_status'] = 'OPERATOR[STATUS]';
			}else if(array_key_exists('3', $this->newsession->userdata('SESS_KODE_ROLE'))){#Supervisor Satu
				if($this->newsession->userdata('SESS_BBPOM_ID') != "93"){
					  $arrdata['obj_napza'] = 'PEMERIKSAAN_NAPZA';
					  $isEditTLBalai = TRUE;
					  $isEditTLPusat = FALSE;
					  if(strlen($row['DETAIL_TINDAKAN_PUSAT']) == "0"){
						  $isPerbaikan = FALSE;
					  }else{
						  $isPerbaikan = TRUE;
					  }
				}else{
					  if($this->newsession->userdata('SESS_BBPOM_ID') == $arrdata['BBPOM_ID'])
						  $isEditTLBalai = TRUE;
					  else
						  $isEditTLBalai = FALSE;
					  $isEditTLPusat = TRUE;
					  $isPerbaikan = TRUE;
					  $arrdata['obj_napza'] = 'PEMERIKSAAN_NAPZA_PUSAT';
				}
				$arrdata['act'] = site_url().'/post/pemeriksaan/set_proses/napza/spv-satu';
				$arrdata['obj_status'] = 'SUPERVISOR[STATUS]';
			}else if(array_key_exists('4', $this->newsession->userdata('SESS_KODE_ROLE'))){#Supervisor Lanjutan
				if($this->newsession->userdata('SESS_BBPOM_ID') != "93"){
					  $isEditTLBalai = TRUE;
					  $isEditTLPusat = FALSE;
					  $arrdata['obj_napza'] = 'PEMERIKSAAN_NAPZA';
					  if(strlen($row['DETAIL_TINDAKAN_PUSAT']) == "0"){
						  $isPerbaikan = FALSE;
					  }else{
						  $isPerbaikan = TRUE;
					  }
					
				}else{
					  if($this->newsession->userdata('SESS_BBPOM_ID') == $arrdata['BBPOM_ID'])
						  $isEditTLBalai = TRUE;
					  else
						  $isEditTLBalai = FALSE;
					  $isEditTLPusat = TRUE;
					  $arrdata['obj_napza'] = 'PEMERIKSAAN_NAPZA_PUSAT';
					  $isPerbaikan = TRUE;
				}
				$arrdata['obj_status'] = 'SUPERVISOR[STATUS]';
				$arrdata['act'] = site_url().'/post/pemeriksaan/set_proses/napza/spv-dua';
			}else if(array_key_exists('5', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('6', $this->newsession->userdata('SESS_KODE_ROLE'))){
				$isEditTLBalai = FALSE;
				$isEditTLPusat = FALSE;
				$isPerbaikan = FALSE;
				$arrdata['obj_status'] = 'VERIFIKASI[STATUS]';
				$arrdata['act'] = site_url().'/post/pemeriksaan/set_proses/napza/56';
			}
			
			if($subid!=""){
				$isPerbaikan = FALSE;
				$isEditTLBalai = FALSE;
				$isEditTLPusat = FALSE;
				$isverifikasi = FALSE;
			}else{
				$isverifikasi = TRUE;
			}
			$arrdata['status'] = $sipt->main->set_verifikasi($stat, $this->newsession->userdata('SESS_JENIS_PELAPORAN'), $this->newsession->userdata('SESS_KODE_ROLE'));
			$arrdata['disverifikasi'] = $stat;
			$arrdata['isPerbaikan'] = $isPerbaikan;
			$arrdata['isEditTLBalai'] = $isEditTLBalai;
			$arrdata['isEditTLPusat'] = $isEditTLPusat;			
			$arrdata['isverifikasi'] = $isverifikasi;
			$arrdata['headersarana'] =$sipt->main->get_judul($jenis);
			$arrdata['urlback'] = site_url().'/home/pelaporan/pemeriksaan/view';
			$arrdata['history_periksa'] = site_url().'/get/pemeriksaan/set_detail_periksa/'.$sarana."/".$jenis.'/'.$idperiksa[0];
			$arrdata['histori_petugas'] = site_url().'/load/petugas/get_petugas/'.$arrdata['SURAT_ID'];
			$arrdata['histori_perbaikan'] = site_url().'/get/pemeriksaan/set_perbaikan/'.$idperiksa[0].'/'.$jenis;
			$arrdata['log'] = site_url().'/get/pemeriksaan/get_log/'.$idperiksa[0];
			$arrdata['redir'] = substr($jenis,0,2)."/".$idperiksa[1];
			$arrdata['ispelayanan'] = substr($jenis, 0, 2);
			return $arrdata;
		}else{
			$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
		}
	}
	
	function set_status($role, $isajax){
		if($this->newsession->userdata('LOGGED_IN') == TRUE){
			$sipt =& get_instance();
			$this->load->model("main","main", true);
			if($role=="operator"){
				$arr_status = array('UPDATE_BY' => $this->newsession->userdata('SESS_USER_ID'),'LAST_UPDATE' => 'GETDATE()');	
				foreach($this->input->post('OPERATOR') as $a => $b){
					$arr_status[$a] = $b;
				}
				$status = $arr_status['STATUS'];
				$this->db->where(array("PERIKSA_ID" => $this->input->post('PERIKSA_ID')));
				if($this->db->update('T_PEMERIKSAAN', $arr_status)){#Update Status Operator
					  if($this->newsession->userdata('SESS_BBPOM_ID') == "93"){
						  $arr_input = $this->input->post('PEMERIKSAAN_NAPZA_PUSAT'); 
						  foreach($arr_input as $c => $d){
							  $arr_update[$c] = $d;
						  }
						  if(array_key_exists('TANGGAL_TINDAKAN_BALAI',$arr_napza)){
							  if($arr_napza['TANGGAL_TINDAKAN_BALAI'] == "") $arr_napza['TANGGAL_TINDAKAN_BALAI'] = null;
						  }
						  if(array_key_exists('TANGGAL_TINDAKAN_PUSAT',$arr_napza)){
							  if($arr_napza['TANGGAL_TINDAKAN_PUSAT'] == "") $arr_napza['TANGGAL_TINDAKAN_PUSAT'] = null;
						  }
						  $this->db->where(array("PERIKSA_ID" => $this->input->post('PERIKSA_ID')));
						  $this->db->update('T_PEMERIKSAAN_NAPZA', $arr_update); #Update Tindak Lanjut Pusat
					  }
					  $seri = (int)$sipt->main->get_uraian("SELECT MAX(SERI) AS MAXID FROM T_PEMERIKSAAN_PROSES WHERE PERIKSA_ID = '".$this->input->post('PERIKSA_ID')."'", "MAXID") + 1;
					  $arr_proses = array('PERIKSA_ID' => $this->input->post('PERIKSA_ID'),
										  'SERI' => $seri,
										  'HASIL' => $status,
										  'CATATAN' => $this->input->post('catatan'),
										  'CREATE_BY' => $this->newsession->userdata('SESS_USER_ID'),
										  'CREATE_DATE' => 'GETDATE()');
					  $this->db->insert('T_PEMERIKSAAN_PROSES', $arr_proses);#Log Pemeriksaan
					  if($this->input->post('PERBAIKAN')){
						  $perbaikan = (int)$sipt->main->get_uraian("SELECT MAX(SERI) AS MAXID FROM T_PEMERIKSAAN_NAPZA_PERBAIKAN WHERE PERIKSA_ID = '".$this->input->post('PERIKSA_ID')."'", "MAXID") + 1;
						  $arr_perbaikan = array('PERIKSA_ID' => $this->input->post('PERIKSA_ID'),
												 'SERI' => $perbaikan,
												 'CREATE_BY' => $this->newsession->userdata('SESS_USER_ID'),
												 'CREATE_DATE' => 'GETDATE()');
						  foreach($this->input->post('PERBAIKAN') as $x => $z){
							  $arr_perbaikan[$x] = $z;
						  }
						  if(trim($arr_perbaikan['TANGGAL_PERBAIKAN']) != "" || trim($arr_perbaikan['DETAIL_PERBAIKAN']) != ""){
							  $this->db->insert('T_PEMERIKSAAN_NAPZA_PERBAIKAN', $arr_perbaikan);#Perbaikan Pemeriksaan					  
						  }
					  }
					  $sipt->main->get_kegiatan("Memverifikasi Data Pemeriksaan Untuk Sarana : ".$this->input->post('NAMA_SARANA'));
					  
					  if($isajax!="ajax"){
						  redirect(base_url());
						  exit();
					  }
					  return "MSG#YES#Data berhasil dikirim#".site_url().'/home/pelaporan/pemeriksaan/view/'.$this->input->post('redir');
				}
			}else if($role=="spv-satu" || $role=="spv-dua"){#Supervisor Satu dan Supervisor Dua (Lanjutan)
				$arr_status = array('UPDATE_BY' => $this->newsession->userdata('SESS_USER_ID'),'LAST_UPDATE' => 'GETDATE()');	
				foreach($this->input->post('SUPERVISOR') as $a => $b){
					$arr_status[$a] = $b;
				}
				$status = $arr_status['STATUS'];
				$this->db->where(array("PERIKSA_ID" => $this->input->post('PERIKSA_ID')));
				if($this->db->update('T_PEMERIKSAAN', $arr_status)){
					  if($this->newsession->userdata('SESS_BBPOM_ID') == "93")
						  $arr_input = $this->input->post('PEMERIKSAAN_NAPZA_PUSAT'); 
					  else
						  $arr_input = $this->input->post('PEMERIKSAAN_NAPZA'); 
					  foreach($arr_input as $c => $d){
						  $arr_update[$c] = $d;
					  }
					  if(array_key_exists('TANGGAL_TINDAKAN_BALAI',$arr_napza)){
						  if($arr_napza['TANGGAL_TINDAKAN_BALAI'] == "") $arr_napza['TANGGAL_TINDAKAN_BALAI'] = null;
					  }
					  if(array_key_exists('TANGGAL_TINDAKAN_PUSAT',$arr_napza)){
						  if($arr_napza['TANGGAL_TINDAKAN_PUSAT'] == "") $arr_napza['TANGGAL_TINDAKAN_PUSAT'] = null;
					  }
					  $this->db->where(array("PERIKSA_ID" => $this->input->post('PERIKSA_ID')));
					  $this->db->update('T_PEMERIKSAAN_NAPZA', $arr_update); #Update Tindak Lanjut
  
					 $seri = (int)$sipt->main->get_uraian("SELECT MAX(SERI) AS MAXID FROM T_PEMERIKSAAN_PROSES WHERE PERIKSA_ID = '".$this->input->post('PERIKSA_ID')."'", "MAXID") + 1;
					  $arr_proses = array('PERIKSA_ID' => $this->input->post('PERIKSA_ID'),
										  'SERI' => $seri,
										  'HASIL' => $status,
										  'CATATAN' => $this->input->post('catatan'),
										  'CREATE_BY' => $this->newsession->userdata('SESS_USER_ID'),
										  'CREATE_DATE' => 'GETDATE()');
					  $this->db->insert('T_PEMERIKSAAN_PROSES', $arr_proses);
					  if($this->input->post('PERBAIKAN')){
						  $perbaikan = (int)$sipt->main->get_uraian("SELECT MAX(SERI) AS MAXID FROM T_PEMERIKSAAN_NAPZA_PERBAIKAN WHERE PERIKSA_ID = '".$this->input->post('PERIKSA_ID')."'", "MAXID") + 1;
						  $arr_perbaikan = array('PERIKSA_ID' => $this->input->post('PERIKSA_ID'),
												 'SERI' => $perbaikan,
												 'CREATE_BY' => $this->newsession->userdata('SESS_USER_ID'),
												 'CREATE_DATE' => 'GETDATE()');
						  foreach($this->input->post('PERBAIKAN') as $x => $z){
							  $arr_perbaikan[$x] = $z;
						  }
						  if(trim($arr_perbaikan['TANGGAL_PERBAIKAN']) != "" || trim($arr_perbaikan['DETAIL_PERBAIKAN']) != ""){
							  $this->db->insert('T_PEMERIKSAAN_NAPZA_PERBAIKAN', $arr_perbaikan);#Perbaikan Pemeriksaan					  
						  }
					  }
					  $sipt->main->get_kegiatan("Memverifikasi Data Pemeriksaan Untuk Sarana : ".$this->input->post('NAMA_SARANA'));
					  
					  if($isajax!="ajax"){
						  redirect(base_url());
						  exit();
					  }
					  return "MSG#YES#Data berhasil dikirim#".site_url().'/home/pelaporan/pemeriksaan/view/'.$this->input->post('redir');
				}
			}else if($role=="56"){#Penolakan Kepala Balai dan Direktur
				$arr_status = array('UPDATE_BY' => $this->newsession->userdata('SESS_USER_ID'),'LAST_UPDATE' => 'GETDATE()');
				foreach($this->input->post('VERIFIKASI') as $a => $b){
					$arr_status[$a] = $b;
				}
				$status = $arr_status['STATUS'];
				$this->db->where(array("PERIKSA_ID" => $this->input->post('PERIKSA_ID')));
				if($this->db->update('T_PEMERIKSAAN', $arr_status)){
					 $seri = (int)$sipt->main->get_uraian("SELECT MAX(SERI) AS MAXID FROM T_PEMERIKSAAN_PROSES WHERE PERIKSA_ID = '".$this->input->post('PERIKSA_ID')."'", "MAXID") + 1;
					 $arr_proses = array('PERIKSA_ID' => $this->input->post('PERIKSA_ID'),
										 'SERI' => $seri,
										 'HASIL' => $status,
										 'CATATAN' => $this->input->post('catatan'),
										 'CREATE_BY' => $this->newsession->userdata('SESS_USER_ID'),
										 'CREATE_DATE' => 'GETDATE()');
					 $this->db->insert('T_PEMERIKSAAN_PROSES', $arr_proses);
					 $sipt->main->get_kegiatan("Memverifikasi Data Pemeriksaan Untuk Sarana : ".$this->input->post('NAMA_SARANA'));
					 $asal = $sipt->main->get_uraian("SELECT BBPOM_ID FROM T_PEMERIKSAAN WHERE PERIKSA_ID = '".$this->input->post('PERIKSA_ID')."'","BBPOM_ID");
					 if($isajax!="ajax"){
						 redirect(base_url());
						 exit();
					 }
					 if(array_key_exists('6', $this->newsession->userdata('SESS_KODE_ROLE'))){
						 if(in_array($asal, $this->config->item('cfg_unit')))
							 return "MSG#YES#Data berhasil dikirim#".site_url().'/home/pelaporan/pemeriksaan/view/'.substr($this->input->post('redir'),0,2)."/pusat";
						 else
							 return "MSG#YES#Data berhasil dikirim#".site_url().'/home/pelaporan/pemeriksaan/view/'.substr($this->input->post('redir'),0,2)."/balai";
					 }else{
						 return "MSG#YES#Data berhasil dikirim#".site_url().'/home/pelaporan/pemeriksaan/view/'.$this->input->post('redir');
					 }
				}
			}
		}else{
			$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
		}
	}
	
	function get_history($sarana){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$this->load->library('newtable');
			$this->newtable->hiddens(array('IDPERIKSA','PERIKSA_ID','SARANA_ID','JENIS_SARANA_ID'));
			$this->newtable->search(array(array('', '')));
			$this->newtable->action(site_url());
			$this->newtable->cidb($this->db);
			$this->newtable->ciuri($this->uri->segment_array());
			$this->newtable->orderby("A.PERIKSA_ID");
			$this->newtable->keys(array('IDPERIKSA'));
			$this->newtable->show_search(FALSE);
			$proses = array('Preview' => array('GETNEW', site_url()."/home/proses", '1'));
			$this->newtable->menu($proses);
			$query = "SELECT (CAST(A.SARANA_ID AS VARCHAR) + '/' + A.JENIS_SARANA_ID + '/' + STUFF(dbo.GROUP_KLASIFIKASI(A.PERIKSA_ID),1,1,'') + '/' + CAST(A.PERIKSA_ID AS VARCHAR) + '.' + A.STATUS + '/1') AS IDPERIKSA, A.PERIKSA_ID, A.SARANA_ID, A.JENIS_SARANA_ID, CONVERT(VARCHAR(10), A.AWAL_PERIKSA, 103) AS [AWAL PERIKSA], CONVERT(VARCHAR(10), A.AKHIR_PERIKSA, 103) AS [AKHIR PERIKSA], B.TUJUAN_PEMERIKSAAN AS [TUJUAN PEMERIKSAAN], B.UNIT_BALAI AS [UNIT BALAI], C.URAIAN AS [STATUS PEMERIKSAAN] FROM T_PEMERIKSAAN A LEFT JOIN T_PEMERIKSAAN_NAPZA B ON A.PERIKSA_ID = B.PERIKSA_ID LEFT JOIN M_TABEL C ON A.STATUS = C.KODE WHERE A.SARANA_ID = '$sarana' AND C.JENIS='STATUS' AND A.BBPOM_ID ='".$this->newsession->userdata('SESS_BBPOM_ID')."' AND A.STATUS IN ('02','12','20')";
			$tabel = $this->newtable->generate($query);
			$tabel .= "<script type=\"text/javascript\" src=\"".base_url()."js/newtable.js\"></script>";
			return $tabel;
		}else{
			$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
		}
	}

	function get_perbaikan($periksa_id){
		$query = "SELECT A.SARANA_ID, B.SERI AS NO, CONVERT(VARCHAR(10), B.TANGGAL_PERBAIKAN, 103) AS [TANGGAL PERBAIKAN], B.DETAIL_PERBAIKAN AS [DETAIL PERBAIKAN], '<a class=\"normal\" href=\"".base_url()."files/' + CAST(A.SARANA_ID AS VARCHAR)+ '/'+ B.FILE_PERBAIKAN +'\" target=\"_blank\">View</a>' AS [FILE PERBAIKAN], C.NAMA_BBPOM AS [BALAI ATAU UNIT], D.NAMA_USER AS [NAMA PETUGAS] FROM T_PEMERIKSAAN A LEFT JOIN T_PEMERIKSAAN_NAPZA_PERBAIKAN B ON A.PERIKSA_ID = B.PERIKSA_ID LEFT JOIN T_USER D ON B.CREATE_BY = D.USER_ID LEFT JOIN M_BBPOM C ON D.BBPOM_ID = C.BBPOM_ID WHERE B.PERIKSA_ID='$periksa_id'";
		$this->load->library('newtable');
		$this->newtable->search(array(array('', '')));
		$this->newtable->hiddens(array('SARANA_ID','BBPOM_ID'));
		$this->newtable->action(site_url());
		$this->newtable->cidb($this->db);
		$this->newtable->ciuri($this->uri->segment_array());
		$this->newtable->orderby("TANGGAL PERBAIKAN");
		$this->newtable->keys("TANGGAL PERBAIKAN");
		$this->newtable->rowcount("ALL");
		$this->newtable->show_chk(FALSE);
		$this->newtable->show_search(FALSE);
		$tabel = $this->newtable->generate($query);
		return $tabel;	
	}
	
	function get_tindakan($periksa){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$sipt->load->model("main","main", true);
			$query = "SELECT A.SARANA_ID, X.NAMA_SARANA, A.PERIKSA_ID, A.JENIS_SARANA_ID, SUBSTRING(A.JENIS_SARANA_ID,1,2) AS JENIS_SARANA, A.CREATE_BY, 
					 CONVERT(VARCHAR(10), A.AWAL_PERIKSA, 103) AS AWAL_PERIKSA,
					 CONVERT(VARCHAR(10), A.AKHIR_PERIKSA, 103) AS AKHIR_PERIKSA,
					 B.TUJUAN_PEMERIKSAAN, B.DASAR_PEMERIKSAAN,
					 CASE WHEN B.TANGGAL_TINDAKAN_BALAI IS NULL THEN '' ELSE CONVERT(VARCHAR(10), B.TANGGAL_TINDAKAN_BALAI, 103) END AS TANGGAL_TINDAKAN_BALAI,
					 B.DETAIL_TINDAKAN_BALAI, B.FILE_TL_BALAI
					 FROM M_SARANA X LEFT JOIN T_PEMERIKSAAN A ON X.SARANA_ID = A.SARANA_ID
					 LEFT JOIN T_PEMERIKSAAN_NAPZA B ON A.PERIKSA_ID = B.PERIKSA_ID
					 WHERE A.PERIKSA_ID = '".$periksa."'";
			$data = $sipt->main->get_result($query);
			if($data){
				$arrdata = array('act' => site_url().'/post/pemeriksaan/set_periksa/napza/update-tl-balai');
				foreach($query->result_array() as $row){
					$arrdata['sess'] = $row;
				}
				return $arrdata;
			}
		}
	}
	
	function input_perbaikan($periksa){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$sipt->load->model("main","main", true);
			$query = "SELECT A.SARANA_ID, X.NAMA_SARANA, A.PERIKSA_ID, A.JENIS_SARANA_ID, SUBSTRING(A.JENIS_SARANA_ID,1,2) AS JENIS_SARANA, A.CREATE_BY, 
					 CONVERT(VARCHAR(10), A.AWAL_PERIKSA, 103) AS AWAL_PERIKSA,
					 CONVERT(VARCHAR(10), A.AKHIR_PERIKSA, 103) AS AKHIR_PERIKSA,
					 B.TUJUAN_PEMERIKSAAN, B.DASAR_PEMERIKSAAN,
					 CASE WHEN B.TANGGAL_TINDAKAN_BALAI IS NULL THEN '' ELSE CONVERT(VARCHAR(10), B.TANGGAL_TINDAKAN_BALAI, 103) END AS TANGGAL_TINDAKAN_BALAI,
					 B.DETAIL_TINDAKAN_BALAI, B.FILE_TL_BALAI
					 FROM M_SARANA X LEFT JOIN T_PEMERIKSAAN A ON X.SARANA_ID = A.SARANA_ID
					 LEFT JOIN T_PEMERIKSAAN_NAPZA B ON A.PERIKSA_ID = B.PERIKSA_ID
					 WHERE A.PERIKSA_ID = '".$periksa."'";
			$data = $sipt->main->get_result($query);
			if($data){
				$arrdata = array('act' => site_url().'/post/pemeriksaan/set_periksa/napza/update-perbaikan-balai');
				foreach($query->result_array() as $row){
					$arrdata['sess'] = $row;
				}
				return $arrdata;
			}
		}
	}
	
	
	function set_bap($sarana,$jenis,$idperiksa,$subid){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$sipt->load->model("main","main", true);
			$func =& get_instance();
			$func->load->model("functions","functions", true);
			$idperiksa = explode(".", $idperiksa);
			$query = "SELECT(SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN_TEMUAN_PRODUK WHERE PERIKSA_ID='$idperiksa[0]') AS JML_TEMUAN,(SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN_NAPZA_PERBAIKAN WHERE PERIKSA_ID='$idperiksa[0]') AS JML_PERBAIKAN, A.SARANA_ID, A.NAMA_SARANA, A.PENANGGUNG_JAWAB, A.NOMOR_IZIN, A.ALAMAT_1 AS ALAMAT, A.TELEPON, B.PERIKSA_ID, B.JENIS_SARANA_ID, B.BBPOM_ID, CONVERT(VARCHAR(10), B.AWAL_PERIKSA, 103) AS AWAL_PERIKSA, CONVERT(VARCHAR(10), B.AKHIR_PERIKSA, 103) AS AKHIR_PERIKSA, C.TUJUAN_PEMERIKSAAN, C.DASAR_PEMERIKSAAN, CONVERT(VARCHAR(10), C.TANGGAL_TINDAKAN_BALAI, 103) AS TANGGAL_TINDAKAN_BALAI, C.DETAIL_TINDAKAN_BALAI, C.UNIT_BALAI, CONVERT(VARCHAR(10), C.TANGGAL_TINDAKAN_PUSAT, 103) AS TANGGAL_TINDAKAN_PUSAT, C.DETAIL_TINDAKAN_PUSAT, C.UNIT_PUSAT, C.FILE_BAP, C.FILE_LAMPIRAN_BAP, C.FILE_TINDAK_LANJUT, D.SERI, D.NAMA_PRODUK, D.KLASIFIKASI_PRODUK, D.JENIS_PELANGGARAN, D.JENIS_PENYIMPANGAN, D.JENIS_KRITERIA_PELANGGARAN, STUFF(dbo.GROUP_CONCAT(B.PERIKSA_ID),1,1,'') AS SURAT_ID FROM M_SARANA A LEFT JOIN T_PEMERIKSAAN B ON A.SARANA_ID = B.SARANA_ID LEFT JOIN T_PEMERIKSAAN_NAPZA C ON B.PERIKSA_ID = C.PERIKSA_ID LEFT JOIN T_PEMERIKSAAN_TEMUAN_PRODUK D ON B.PERIKSA_ID = D.PERIKSA_ID WHERE B.SARANA_ID='$sarana' AND B.PERIKSA_ID='$idperiksa[0]'";
			$data = $sipt->main->get_result($query);
			$bulan = $this->config->config;
			$bulan = $bulan['bulan'];		
			if($data){
				foreach($query->result_array() as $row){
					$temuan_produk[] = $row;
					$tgl = explode('/', $row['AWAL_PERIKSA']);
					$tgla = (int)$tgl[1];
					$tgla = $bulan[$tgla];
					$hari = "$tgl[2]/$tgl[1]/$tgl[0]";
					$arrdata = array('sess' => $row,
									 'temuan_produk' => $temuan_produk,
									 'petugas' => $sipt->main->bap_petugas($idperiksa[0]), 'hari' => $func->functions->get_hari($hari),
									 'awal_periksa' => "$tgl[0] bulan $tgla tahun $tgl[2]");
				}
			}
			
		}		
		$this->load->library('mpdf');
		$headerO = '<div style="text-align:right;">{PAGENO}   /   {nb}</div>';
		$headerE = '<div style="text-align:right;">{PAGENO}   /   {nb}</div>';
		$mpdf=new mPDF('win-1252',array(210,330));
		$mpdf->SetHTMLFooter($headerO);
		$mpdf->SetHTMLFooter($headerE,'E');
		$mpdf->mirrorMargins = true;
		$mpdf->SetAuthor("Bidang TI PIOM");
		$mpdf->SetDisplayMode('fullpage','two');
		$html = $this->load->view('pemeriksaan/bap/napza', $arrdata, true);
		$bap = $this->mpdf->WriteHTML($html);
		$bap = $this->mpdf->Output();
		echo $bap;
	}
}

?>