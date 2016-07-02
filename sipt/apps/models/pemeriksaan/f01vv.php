<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);

class F01VV extends Model{
	
	function GetForm01VV($sarana, $jenis, $klasifikasi, $idperiksa){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			if(!array_key_exists($jenis, $this->newsession->userdata("SESS_SARANA")) && !array_key_exists($klasifikasi, $this->newsession->userdata("SESS_KLASIFIKASI_ID"))) return $this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
			$sipt =& get_instance();
			$sipt->load->model("main", "main", true);
			if($idperiksa==""){#Input Mode				  
				 if(!$this->session->userdata('SURAT')) return $this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
				 $qsarana = "SELECT SARANA_ID, NAMA_SARANA, NAMA_PIMPINAN, PENANGGUNG_JAWAB, ALAMAT_1, JENIS_PANGAN, NAMA_PANGAN, NOMOR_REGISTRASI,CONVERT(VARCHAR(10), TANGGAL_IZIN, 103) AS TANGGAL_IZIN, NOMOR_IZIN, TELEPON, EMAIL FROM M_SARANA WHERE SARANA_ID='$sarana'";
				  $dt_sarana = $sipt->main->get_result($qsarana);
				  if($dt_sarana){
					  foreach($qsarana->result_array() as $row){
						  $arrdata = array('sess' => $row,
										   'SURAT_ID' => '',								
										   'BBPOM_ID' => $this->newsession->userdata('SESS_BBPOM_ID'),
										   'act' => site_url().'/post/pemeriksaan/set_periksa/01VV/simpan',
										   'urlback' => site_url().'/home/pelaporan/pemeriksaan',
										   'kesimpulan_grup' => '',
										   'aspek_penilaian' => '',
										   'PERIKSA_ID' => '');
					  }
				  }
			}else{
				  $idperiksa = explode(".", $idperiksa);
				  $status = $idperiksa[1];
				  $qperiksa = "SELECT A.SARANA_ID, A.NAMA_SARANA, A.NAMA_PIMPINAN, A.PENANGGUNG_JAWAB, A.ALAMAT_1, A.JENIS_PANGAN, A.NAMA_PANGAN, A.NOMOR_REGISTRASI, CONVERT(VARCHAR(10), A.TANGGAL_IZIN, 103) AS TANGGAL_IZIN, A.NOMOR_IZIN, A.TELEPON, A.EMAIL, B.PERIKSA_ID, B.JENIS_SARANA_ID, B.BBPOM_ID, STUFF(dbo.GROUP_KLASIFIKASI(B.PERIKSA_ID),1,1,'') AS KK_ID, CONVERT(VARCHAR(10), B.AWAL_PERIKSA, 103) AS AWAL_PERIKSA, CONVERT(VARCHAR(10), B.AKHIR_PERIKSA, 103) AS AKHIR_PERIKSA, B.HASIL, C.STATUS_SARANA, C.PENGAWAS, C.TUJUAN_PEMERIKSAAN, C.ELEMENT_PERIKSA, C.KETIDAKSESUAIAN, C.CATATAN, C.RINCIAN_NOMOR, CAST(C.RINCIAN_KETIDAKSESUAIAN AS VARCHAR(MAX)) AS RINCIAN_KETIDAKSESUAIAN, CAST(C.RINCIAN_KRITERIA AS VARCHAR(MAX)) AS RINCIAN_KRITERIA, CAST(C.RINCIAN_TIMELINE AS VARCHAR(MAX)) AS RINCIAN_TIMELINE, CAST(C.RINCIAN_PERBAIKAN AS VARCHAR(MAX)) AS RINCIAN_PERBAIKAN, C.JML_KRITIS, C.JML_SERIUS, C.JML_MAJOR, C.JML_MINOR, C.LEVEL_IRTP, STUFF(dbo.GROUP_CONCAT(B.PERIKSA_ID),1,1,'') AS SURAT_ID FROM M_SARANA A LEFT JOIN T_PEMERIKSAAN B ON A.SARANA_ID = B.SARANA_ID LEFT JOIN T_PEMERIKSAAN_PIRT C ON B.PERIKSA_ID = C.PERIKSA_ID WHERE B.SARANA_ID = '$sarana' AND B.PERIKSA_ID = '$idperiksa[0]'";
				  $dt_periksa = $sipt->main->get_result($qperiksa);
				  if($dt_periksa){
					  foreach($qperiksa->result_array() as $row){
						  $arrdata = array('sess' => $row,
										   'urlback' => site_url().'/home/pelaporan/pemeriksaan/view/'.$status);
					  }
					  $arrdata['SURAT_ID'] = $row['SURAT_ID'];
					  $arrdata['BBPOM_ID'] = $row['BBPOM_ID'];
					  $arrdata['PERIKSA_ID'] = $row['PERIKSA_ID'];
					  $arrdata['aspek_penilaian'] = explode("#", $row['KETIDAKSESUAIAN']);
					  $arrdata['element_periksa'] = explode("#", $row['ELEMENT_PERIKSA']);
					  $arrdata['rincian_nomor'] = explode("#", $row['RINCIAN_NOMOR']);
					  $arrdata['rincian_ketidaksesuaian'] = explode("#", $row['RINCIAN_KETIDAKSESUAIAN']);
					  $arrdata['rincian_kriteria'] = explode("#", $row['RINCIAN_KRITERIA']);
					  $arrdata['rincian_timeline'] = explode("#", $row['RINCIAN_TIMELINE']);
					  $arrdata['rincian_perbaikan'] = explode("#", $row['RINCIAN_PERBAIKAN']);
					  $arrdata['rincian'] = $this->db->query("SELECT PERIKSA_ID, SERI, LTRIM(RTRIM(ID)) AS ID, KETIDAKSESUAIAN, KRITERIA, TIMELINE, TINDAKAN_PERBAIKAN, STATUS FROM T_PEMERIKSAAN_PIRT_FLTK WHERE PERIKSA_ID = '".$row['PERIKSA_ID']."'")->result_array();
					  
				  }
				  if($this->newsession->userdata('SESS_BBPOM_ID') != "95"){#Update dan Perbaikan Balai
					  if($status=="20101"){
						  $arrdata['act'] = site_url().'/post/pemeriksaan/set_periksa/01VV/update';
					  }else if($status=="20102" || $status =="20103"){
						  $arrdata['act'] = site_url().'/post/pemeriksaan/set_periksa/01VV/perbaikan';
					  }else if($status=="60020"){
						  $arrdata['act'] = site_url().'/post/pemeriksaan/set_periksa/01VV/rekomendasi';
					  }
				  }else{#Update dan Perbaikan Pusat
					  if($status=="20111"){
						  $arrdata['act'] = site_url().'/post/pemeriksaan/set_periksa/01VV/update';
					  }else if($status =="20113" || $status =="20112"){
						  $arrdata['act'] = site_url().'/post/pemeriksaan/set_periksa/01VV/perbaikan';
					  }else if($status=="60020"){
						  $arrdata['act'] = site_url().'/post/pemeriksaan/set_periksa/01VV/rekomendasi';
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
			$arrdata['headersarana'] =$sipt->main->get_judul($jenis);
			$disinput = array("JENISDIS","NAMADIS");
			$arrdata['sarana_id'] = $sarana;
			$arrdata['jenis_sarana_id'] = $jenis;
			$arrdata['klasifikasi'] = $klasifikasi;
			$arrdata['jenis_sarana'] = $sipt->main->get_jenis_sarana($this->newsession->userdata("SESS_USER_ID"), $disinput);
			$arrdata['klasifikasi_kategori'] = $sipt->main->get_klasifikasi();
			$arrdata['status_sarana'] = array("" => "Status Sarana","1" => "Aktif","0" => "Tidak Aktif / Tutup", "2" => "Tidak Produksi Saat Diperiksa", "3" => "Menolak Diperiksa");
			$arrdata['tujuan_pemeriksaan'] = array("" => "", "Rutin" => "Rutin",  "Kasus" => "Kasus");			
			$arrdata['disinput'] = array("JENISDIS","NAMADIS");
			$arrdata['cb_kriteria'] = array("" => "Pilihan", "OK" => "OK", "Minor" => "Minor", "Major" => "Major", "Serius" => "Serius", "Kritis" => "Kritis", "TB" => "Tidak Berlaku");
			$arrdata['histori_petugas'] = site_url().'/load/petugas/get_petugas/'.$arrdata['SURAT_ID'];
			$arrdata['history_periksa'] = site_url().'/get/pemeriksaan/set_detail_periksa/'.$sarana."/".$jenis.'/'.join(".",$idperiksa);
			/* Cek Pemeriksaan Sebelumnya */
			$chkquery = "SELECT TOP 1 A.PERIKSA_ID FROM T_PEMERIKSAAN_PIRT A LEFT JOIN T_PEMERIKSAAN B ON A.PERIKSA_ID = B.PERIKSA_ID WHERE B.SARANA_ID = '".$sarana."' AND B.STATUS = '60010' ORDER BY B.PERIKSA_ID DESC";
			$arrdata['histori'] = FALSE;
			$datachk = $this->db->query($chkquery);
			if($datachk->num_rows() > 0){
				$res = $datachk->row();
				$arrdata['histori'] = TRUE;
				$arrdata['histori_rekapan'] = $this->db->query("SELECT PERIKSA_ID, SERI, LTRIM(RTRIM(ID)) AS ID, KETIDAKSESUAIAN, KRITERIA, TIMELINE, TINDAKAN_PERBAIKAN, STATUS FROM T_PEMERIKSAAN_PIRT_FLTK WHERE PERIKSA_ID = '".$res->PERIKSA_ID."'")->result_array();
				$arrdata['histori_id'] = $res->PERIKSA_ID;
				$arrdata['arrstatus'] = array("Pilihan" => "", "Sesuai" => "Sesuai", "Tidak Sesuai" => "Tidak Sesuai");
			}
			/* Akhir Pemeriksaan Sebelumnya */
			
			/* Jenis Pangan */
			$arrdata['jenis_pangan'] = $this->db->query("SELECT SARANA_ID, SERI, NO_PIRT, JENIS_PANGAN, CASE WHEN STATUS = 1 THEN 'Berlaku' WHEN STATUS = 0 THEN 'Tidak berlaku' END AS STATUS FROM T_SARANA_JENIS_PANGAN WHERE SARANA_ID = '".$sarana."' ")->result_array();
			/* Akhir Jenis Pangan */
			return $arrdata;
		}
		else
		{
			$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
		}
	}
		
	function SaveForm01VV($action, $isajax){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main","main", true);
			if(in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')))
				$status = '20111';
			else
				$status = '20101';
			$ret = "MSG#NO#Data gagal disimpan#";
			if($action=="simpan"){#Insert Mode
				#Cek Jenis Pangan#
				#if($this->input->post('STATUS_SARANA') == "1"){
					$adajenispangan = (int)$sipt->main->get_uraian("SELECT COUNT(*) AS JML FROM T_SARANA_JENIS_PANGAN WHERE SARANA_ID = '".$this->input->post('SARANA_ID')."'","JML");
					if($adajenispangan == 0){
						return "MSG#NO#Proses entri data pemeriksaan tidak dapat dilanjutkan. \n Ini dikarenakan data jenis pangan sarana tersebut belum terdapat atau di update di master data jenis pangan. \n Silahkan untuk melakukan update master data jenis pangan.";
						die();
					}
				#}
				#Akhir Cek Jenis Pangan#
			
				#Cek Double
				$jml = $sipt->main->get_uraian("SELECT COUNT(*) AS JML FROM T_PEMERIKSAAN WHERE JENIS_SARANA_ID = '".$this->input->post('JENIS_SARANA_ID')."' AND SARANA_ID = '".$this->input->post('SARANA_ID')."' AND DATEDIFF(dy, 0, convert(DATETIME, AWAL_PERIKSA, 105)) = DATEDIFF(dy, 0, convert(DATETIME, '".$_POST['PEMERIKSAAN']['AWAL_PERIKSA']."', 105)) AND DATEDIFF(dy, 0, convert(DATETIME, AKHIR_PERIKSA, 105)) = DATEDIFF(dy, 0, convert(DATETIME, '".$_POST['PEMERIKSAAN']['AKHIR_PERIKSA']."', 105)) AND LEN(STATUS) > 2","JML");
				if($jml > 0){
					$nama = $sipt->main->get_uraian("SELECT LTRIM(NAMA_SARANA) AS NAMA_SARANA FROM M_SARANA WHERE SARANA_ID = '".$this->input->post('SARANA_ID')."'","NAMA_SARANA");
					$msg = "Untuk data pemeriksaan sarana : .".strtoupper($nama)."\n Dengan tanggal pemeriksaan : ".$_POST['PEMERIKSAAN']['AWAL_PERIKSA']." s.d ".$_POST['PEMERIKSAAN']['AKHIR_PERIKSA']."\n Data tersebut sudah pernah di entri, mohon untuk dikrosecek kembali";
					return "MSG#NO#".$msg;
					die();
				}
				#End Cek Double
				
				#Cek Length Karakter Catatan 
				if($this->input->post('CATATAN')){
					if(strlen($this->input->post('CATATAN')) < 10){
						return "MSG#NO#Proses entri data pemeriksaan tidak dapat dilanjutkan. \n Mohon mengisi catatan dengan jelas untuk keterangan sarana yang tidak aktif / tutup, tidak produksi saaat di periksa dan tidak dapat di periksa. \n Minimal panjang karakter catatan adalah 50 karakter";
						die();
					}
				}
				#End Cek Catatan
				
				#INSERT SURAT TUGAS			
				$arr_nosurat = $this->session->userdata('SURAT');
				$arr_petugas = $this->session->userdata('USER');
				$arrkeys_surat = array_keys($arr_nosurat);
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
					$arr_distribusi = array('PERIKSA_ID' => $periksa_id);
					foreach($this->input->post('PEMERIKSAAN_PANGAN') as $c => $d){
						if(!is_array($d))
							$arr_distribusi[$c] = $d;
						else
							$arr_distribusi[$c] = join("#", $d);
					}
					$qjenispangan = "SELECT NO_PIRT, JENIS_PANGAN FROM T_SARANA_JENIS_PANGAN WHERE SARANA_ID = '".$this->input->post('SARANA_ID')."'";
					$djenispangan = $sipt->main->get_result($qjenispangan);
					if($djenispangan){
						foreach($qjenispangan->result_array() as $row){
							$arr_no_pirt[] = $row['NO_PIRT'];
							$arr_jenis_pangan[] = $row['JENIS_PANGAN'];
						}
						$arr_distribusi['NO_PIRT'] = join(",",$arr_no_pirt);
						$arr_distribusi['JENIS_PANGAN'] = join(",",$arr_jenis_pangan);
					}
					if($this->input->post('CATATAN')){ 
						$arr_distribusi['CATATAN'] = $this->input->post('CATATAN');
					}
					$arr_distribusi['STATUS_SARANA'] = $this->input->post('STATUS_SARANA');
					$this->db->insert('T_PEMERIKSAAN_PIRT', $arr_distribusi);
					$arrhasil['HASIL'] = $arr_distribusi['LEVEL_IRTP'];
					if($this->input->post('STATUS_SARANA') == "0"){
						$arrhasil['HASIL'] = 'TTP';
					}else if($this->input->post('STATUS_SARANA') == "2" || $this->input->post('STATUS_SARANA') == "3"){
						$arrhasil['HASIL'] = 'TDP';
					}
					$this->db->where('PERIKSA_ID', $periksa_id);
					$this->db->update('T_PEMERIKSAAN', $arrhasil);
					
					if($this->input->post('FLTK')){					
						$arrrincian = $this->input->post('FLTK');
						$arrkeys = array_keys($arrrincian);
						for($i=0;$i<count($arrrincian[$arrkeys[0]]);$i++){
							$seri = (int)$sipt->main->get_uraian("SELECT MAX(SERI) AS MAXID FROM T_PEMERIKSAAN_PIRT_FLTK WHERE PERIKSA_ID = '$periksa_id'", "MAXID") + 1;
							$rincian = array('PERIKSA_ID' => $periksa_id,
											'SERI' => $seri);
							for($j=0;$j<count($arrkeys);$j++){
								$rincian[$arrkeys[$j]] = $arrrincian[$arrkeys[$j]][$i];
							}
							$this->db->insert('T_PEMERIKSAAN_PIRT_FLTK', $rincian);
						}
					}
					
					/*Update histori pemeriksaan sebelumnya*/
					if($this->input->post('HISTORI')){
						$arrhistori = $this->input->post('HISTORI');
						$arrkeys_histori = array_keys($arrhistori);
						for($i = 0; $i < count($_POST['HISTORI']['PERIKSA_ID']); $i++){
							for($j=0;$j<count($arrkeys_histori);$j++){
								$arrupdatehistori[$arrkeys_histori[$j]] = $arrhistori[$arrkeys_histori[$j]][$i];
							}
							$this->db->where('PERIKSA_ID', $_POST['HISTORI']['PERIKSA_ID'][$i]);
							$this->db->where('SERI', $_POST['HISTORI']['SERI'][$i]);
							$this->db->update('T_PEMERIKSAAN_PIRT_FLTK', $arrupdatehistori);
						}
					}
					/*Akhir update histori pemeriksaan sebelumnya*/
					
					foreach($SES_ID as $a){
						$pelaporan = array('SURAT_ID' => $a, 'LAPOR_ID' => $periksa_id);
						$this->db->insert('T_SURAT_TUGAS_PELAPORAN', $pelaporan);
					}
					
					foreach($arr_klasifikasi as $kk_id){
						$pemeriksaan_klasifikasi = array('PERIKSA_ID' => $periksa_id, 'KK_ID' => $kk_id);
						$this->db->insert('T_PEMERIKSAAN_KLASIFIKASI', $pemeriksaan_klasifikasi);
					}
					
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
							$ret = "MSG#YES#Data berhasil disimpan#".site_url()."/home/pemeriksaan/".$this->input->post('SARANA_ID')."/".$this->input->post('jns')."/".$this->input->post('kk');
						}else{
							$ret = "MSG#YES#Data berhasil disimpan#".site_url()."/home/pelaporan/pemeriksaan/view/".substr($this->input->post('JENIS_SARANA_ID'),0,2)."/".$redir;
						}
					}else if($this->input->post('cb_konfirm') == "02"){#Temuan Produk
						$ret = "MSG#YES#Data berhasil disimpan#".site_url()."/home/produk/add/".$this->input->post('SARANA_ID')."/".$this->input->post('JENIS_SARANA_ID')."/".$this->input->post('KLASIFIKASI')."/".$periksa_id;
					}else{
						$ret = "MSG#YES#Data berhasil disimpan#".site_url()."/home/pelaporan/pemeriksaan/view/".substr($this->input->post('JENIS_SARANA_ID'),0,2)."/".$redir."#".site_url()."/post/pemeriksaan/set_confirm/ajax/".$periksa_id;
					}
				}
				return $ret;
			}else if($action=="update" || $action=="perbaikan" || $action=="rekomendasi"){#Update Mode
				$arr_pemeriksaan = array('UPDATE_BY' => $this->newsession->userdata('SESS_USER_ID'),'LAST_UPDATE' => 'GETDATE()');
				foreach($this->input->post('PEMERIKSAAN') as $a => $b){
				  $arr_pemeriksaan[$a] = $b;
				}
				if($action=="perbaikan" || $action=="rekomendasi"){
					if($this->newsession->userdata('SESS_BBPOM_ID') != "95"){
					  $arr_pemeriksaan['STATUS'] = '30104';
					  $status = "30104";
					}else{
					  $arr_pemeriksaan['STATUS'] = '30114';
					  $status = "30114";
					}
				}		
				$this->db->where(array("PERIKSA_ID" => $this->input->post('PERIKSA_ID')));	
				if($this->db->update('T_PEMERIKSAAN', $arr_pemeriksaan)){	
					foreach($this->input->post('PEMERIKSAAN_PANGAN') as $c => $d){
						if(!is_array($d))
							$arr_distribusi[$c] = $d;
						else
							$arr_distribusi[$c] = join("#", $d);
					}
					$qjenispangan = "SELECT NO_PIRT, JENIS_PANGAN FROM T_SARANA_JENIS_PANGAN WHERE SARANA_ID = '".$this->input->post('SARANA_ID')."'";
					$djenispangan = $sipt->main->get_result($qjenispangan);
					if($djenispangan){
						foreach($qjenispangan->result_array() as $row){
							$arr_no_pirt[] = $row['NO_PIRT'];
							$arr_jenis_pangan[] = $row['JENIS_PANGAN'];
						}
						$arr_distribusi['NO_PIRT'] = join(",",$arr_no_pirt);
						$arr_distribusi['JENIS_PANGAN'] = join(",",$arr_jenis_pangan);
					}
					if($this->input->post('CATATAN')){ 
						$arr_distribusi['CATATAN'] = $this->input->post('CATATAN');
					}
					$arr_distribusi['STATUS_SARANA'] = $this->input->post('STATUS_SARANA');
					$this->db->where(array("PERIKSA_ID" => $this->input->post('PERIKSA_ID')));
					$this->db->update('T_PEMERIKSAAN_PIRT', $arr_distribusi);
					$arrhasil['HASIL'] = $arr_distribusi['LEVEL_IRTP'];
					if($this->input->post('STATUS_SARANA') == "0"){
						$arrhasil['HASIL'] = 'TTP';
					}else if($this->input->post('STATUS_SARANA') == "2" || $this->input->post('STATUS_SARANA') == "3"){
						$arrhasil['HASIL'] = 'TDP';
					}
					$this->db->where('PERIKSA_ID', $periksa_id);
					$this->db->update('T_PEMERIKSAAN', $arrhasil);
					
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
					
					if($this->input->post('FLTK')){					
						$this->db->where('PERIKSA_ID', $this->input->post('PERIKSA_ID'));
						$this->db->delete('T_PEMERIKSAAN_PIRT_FLTK');
						$arrrincian = $this->input->post('FLTK');
						$arrkeys = array_keys($arrrincian);
						for($i=0;$i<count($arrrincian[$arrkeys[0]]);$i++){
							$seri = (int)$sipt->main->get_uraian("SELECT MAX(SERI) AS MAXID FROM T_PEMERIKSAAN_PIRT_FLTK WHERE PERIKSA_ID = '".$this->input->post('PERIKSA_ID')."'", "MAXID") + 1;
							$rincian = array('PERIKSA_ID' => $this->input->post('PERIKSA_ID'),
											'SERI' => $seri);
							for($j=0;$j<count($arrkeys);$j++){
								$rincian[$arrkeys[$j]] = $arrrincian[$arrkeys[$j]][$i];
							}
							$this->db->insert('T_PEMERIKSAAN_PIRT_FLTK', $rincian);
						}
					}
					
					/*Update histori pemeriksaan sebelumnya*/
					if($this->input->post('HISTORI')){
						$arrhistori = $this->input->post('HISTORI');
						$arrkeys_histori = array_keys($arrhistori);
						for($i = 0; $i < count($_POST['HISTORI']['PERIKSA_ID']); $i++){
							for($j=0;$j<count($arrkeys_histori);$j++){
								$arrupdatehistori[$arrkeys_histori[$j]] = $arrhistori[$arrkeys_histori[$j]][$i];
							}
							$this->db->where('PERIKSA_ID', $_POST['HISTORI']['PERIKSA_ID'][$i]);
							$this->db->where('SERI', $_POST['HISTORI']['SERI'][$i]);
							$this->db->update('T_PEMERIKSAAN_PIRT_FLTK', $arrupdatehistori);
						}
					}
					/*Akhir update histori pemeriksaan sebelumnya*/
					
					
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
						$ret = "MSG#YES#Data berhasil disimpan#".site_url()."/home/pelaporan/pemeriksaan/view/".substr($this->input->post('JENIS_SARANA_ID'), 0,2)."/".$redir."#".site_url()."/post/pemeriksaan/set_confirm/ajax/".$periksa_id;
					}else if($action=="perbaikan" || $action=="rekomendasi"){
						$ret = "MSG#YES#Data berhasil disimpan#".site_url()."/home/pelaporan/pemeriksaan/view/all/send";
					}
				}
			}else if($action == "jenis-pangan"){
				$docpirt = $sipt->main->post_to_query($this->input->post('JENIS_PANGAN'));
				$docpirt['SERI'] = (int)$sipt->main->get_uraian("SELECT MAX(SERI) AS MAXSERI FROM T_SARANA_JENIS_PANGAN WHERE SARANA_ID = '".$docpirt['SARANA_ID']."'","MAXSERI") + 1;
				$docpirt['KODE'] = $this->input->post('UR_JENIS_PANGAN');
				$docpirt['JENIS_PANGAN'] = $sipt->main->get_uraian("SELECT JENIS_PANGAN FROM M_JENIS_PANGAN_NEW WHERE KODE = '".$this->input->post('UR_JENIS_PANGAN')."'","JENIS_PANGAN");
				$docpirt['CREATE_BY'] = $this->newsession->userdata('SESS_USER_ID');
				$docpirt['CREATE_DATE'] = 'GETDATE()';
				$this->db->insert('T_SARANA_JENIS_PANGAN', $docpirt);
				if($this->db->affected_rows() > 0){
					$tbl = '<tr id="' . $docpirt['SARANA_ID'] . '-'.$docpirt['SERI'].'"><td>' . $docpirt['JENIS_PANGAN'] . '</td><td>' . $docpirt['NO_PIRT'] . '</td><td>' . ($docpirt['STATUS'] = '1' ? 'Berlaku' : 'Tidak Berlaku'). '</td></tr>';
					$tbl .= '#APPEND';
					$ret = "MSG#YES#Data jenis pangan berhasil disimpan#".$tbl;
				}else{
					$ret = "MSG#NO#Data jenis pangan gagal disimpan";
				}
			}
			return $ret;
		}else{
			$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
		}
	}		
		
	function get_preview($sarana,$id,$jenis){
		$sipt =& get_instance();
		$this->load->model("main","main", true);
		$id = explode(".", $id);
		$query = "SELECT (CAST(A.SARANA_ID AS VARCHAR) + '/' + A.JENIS_SARANA_ID + '/' + STUFF(dbo.GROUP_KLASIFIKASI(A.PERIKSA_ID),1,1,'') + '/' + CAST(A.PERIKSA_ID AS VARCHAR) + '.' + A.STATUS) AS IDPERIKSA, A.PERIKSA_ID, A.SARANA_ID, A.STATUS, CONVERT(VARCHAR(10), A.AWAL_PERIKSA, 103) AS [AWAL_PERIKSA], CONVERT(VARCHAR(10), A.AKHIR_PERIKSA, 103) AS [AKHIR_PERIKSA], A.HASIL, B.STATUS_SARANA, B.PENGAWAS, B.TUJUAN_PEMERIKSAAN, B.ELEMENT_PERIKSA, B.KETIDAKSESUAIAN, B.CATATAN, B.RINCIAN_NOMOR, CAST(B.RINCIAN_KETIDAKSESUAIAN AS VARCHAR(MAX)) AS RINCIAN_KETIDAKSESUAIAN, CAST(B.RINCIAN_KRITERIA AS VARCHAR(MAX)) AS RINCIAN_KRITERIA, CAST(B.RINCIAN_TIMELINE AS VARCHAR(MAX)) AS RINCIAN_TIMELINE, CAST(B.RINCIAN_PERBAIKAN AS VARCHAR(MAX)) AS RINCIAN_PERBAIKAN, B.JML_KRITIS, B.JML_SERIUS, B.JML_MAJOR, B.JML_MINOR, B.LEVEL_IRTP, STUFF(dbo.GROUP_CONCAT(A.PERIKSA_ID),1,1,'') AS SURAT_ID FROM T_PEMERIKSAAN A LEFT JOIN T_PEMERIKSAAN_PIRT B ON A.PERIKSA_ID = B.PERIKSA_ID WHERE A.SARANA_ID = '$sarana' AND A.PERIKSA_ID = '$id[0]'";
		$judul = $sipt->main->get_judul($jenis);
		$data = $sipt->main->get_result($query);
		if($data){
			foreach($query->result_array() as $row){
				$arrdata = array('sess' => $row, 'judul' => $judul);
			}
			$arrdata['aspek_penilaian'] = explode("#", $row['KETIDAKSESUAIAN']);
			$arrdata['element_periksa'] = explode("#", $row['ELEMENT_PERIKSA']);
			$arrdata['rincian_nomor'] = explode("#", $row['RINCIAN_NOMOR']);
			$arrdata['rincian_ketidaksesuaian'] = explode("#", $row['RINCIAN_KETIDAKSESUAIAN']);
			$arrdata['rincian_kriteria'] = explode("#", $row['RINCIAN_KRITERIA']);
			$arrdata['rincian_timeline'] = explode("#", $row['RINCIAN_TIMELINE']);
			$arrdata['rincian_perbaikan'] = explode("#", $row['RINCIAN_PERBAIKAN']);
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
			$query = "SELECT (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN_PROSES WHERE PERIKSA_ID='$idperiksa[0]') AS JML_PROSES, A.SARANA_ID, A.NAMA_SARANA, A.NAMA_PIMPINAN, A.PENANGGUNG_JAWAB, A.ALAMAT_1, A.JENIS_PANGAN, A.NAMA_PANGAN, A.NOMOR_REGISTRASI, CONVERT(VARCHAR(10), A.TANGGAL_IZIN, 103) AS TANGGAL_IZIN, A.NOMOR_IZIN, B.PERIKSA_ID, B.PERIKSA_ID, B.JENIS_SARANA_ID, B.BBPOM_ID, STUFF(dbo.GROUP_KLASIFIKASI(B.PERIKSA_ID),1,1,'') AS KK_ID, CONVERT(VARCHAR(10), B.AWAL_PERIKSA, 103) AS AWAL_PERIKSA, CONVERT(VARCHAR(10), B.AKHIR_PERIKSA, 103) AS AKHIR_PERIKSA, B.HASIL, CASE WHEN C.STATUS_SARANA = '1' THEN 'Aktif' WHEN C.STATUS_SARANA = '0' THEN 'Tidak Aktif / Tutup' WHEN C.STATUS_SARANA = '2' THEN 'Tidak Produksi Saat Diperiksa' WHEN C.STATUS_SARANA = '3' THEN 'Menolak Diperiksa' END AS UR_STATUS_SARANA, C.STATUS_SARANA, C.PENGAWAS, C.TUJUAN_PEMERIKSAAN, C.ELEMENT_PERIKSA, C.KETIDAKSESUAIAN, C.CATATAN, C.RINCIAN_NOMOR, CAST(C.RINCIAN_KETIDAKSESUAIAN AS VARCHAR(MAX)) AS RINCIAN_KETIDAKSESUAIAN, CAST(C.RINCIAN_KRITERIA AS VARCHAR(MAX)) AS RINCIAN_KRITERIA, CAST(C.RINCIAN_TIMELINE AS VARCHAR(MAX)) AS RINCIAN_TIMELINE, CAST(C.RINCIAN_PERBAIKAN AS VARCHAR(MAX)) AS RINCIAN_PERBAIKAN, C.JML_KRITIS, C.JML_SERIUS, C.JML_MAJOR, C.JML_MINOR, C.LEVEL_IRTP, STUFF(dbo.GROUP_CONCAT(B.PERIKSA_ID),1,1,'') AS SURAT_ID FROM M_SARANA A LEFT JOIN T_PEMERIKSAAN B ON A.SARANA_ID = B.SARANA_ID LEFT JOIN T_PEMERIKSAAN_PIRT C ON B.PERIKSA_ID = C.PERIKSA_ID WHERE B.SARANA_ID = '$sarana' AND B.PERIKSA_ID = '$idperiksa[0]'";
			$data = $sipt->main->get_result($query);
			if($data){
				foreach($query->result_array() as $row){
					$arrdata = array('sess' => $row);
				}
				$arrdata['SURAT_ID'] = $row['SURAT_ID'];
				$arrdata['BBPOM_ID'] = $row['BBPOM_ID'];		  
				$arrdata['aspek_penilaian'] = explode("#", $row['KETIDAKSESUAIAN']);
				$arrdata['element_periksa'] = explode("#", $row['ELEMENT_PERIKSA']);
				$arrdata['rincian_nomor'] = explode("#", $row['RINCIAN_NOMOR']);
				$arrdata['rincian_ketidaksesuaian'] = explode("#", $row['RINCIAN_KETIDAKSESUAIAN']);
				$arrdata['rincian_kriteria'] = explode("#", $row['RINCIAN_KRITERIA']);
				$arrdata['rincian_timeline'] = explode("#", $row['RINCIAN_TIMELINE']);
				$arrdata['rincian_perbaikan'] = explode("#", $row['RINCIAN_PERBAIKAN']);
			}			
			if(array_key_exists('2', $this->newsession->userdata('SESS_KODE_ROLE'))){#Operator
				  if($this->newsession->userdata('SESS_BBPOM_ID') != "95"){
					  $arrdata['obj_pangan'] = 'PEMERIKSAAN_PANGAN';
				  }else{
				  }
				  $isEditTLBalai = FALSE;
				  $arrdata['act'] = site_url().'/post/pemeriksaan/set_proses/01VV/operator';
				  $arrdata['obj_status'] = 'OPERATOR[STATUS]';
			  }else if(array_key_exists('3', $this->newsession->userdata('SESS_KODE_ROLE'))){#Supervisor Satu
				if($this->newsession->userdata('SESS_BBPOM_ID') != "95"){
					  $arrdata['obj_pangan'] = 'PEMERIKSAAN_PANGAN';
					  $isEditTLBalai = TRUE;
				}else{
					  if($this->newsession->userdata('SESS_BBPOM_ID') == $arrdata['BBPOM_ID'])
						  $isEditTLBalai = FALSE;
					  else
						  $isEditTLBalai = FALSE;
				}
				$arrdata['act'] = site_url().'/post/pemeriksaan/set_proses/01VV/spv-satu';
				$arrdata['obj_status'] = 'SUPERVISOR[STATUS]';
			}else if(array_key_exists('4', $this->newsession->userdata('SESS_KODE_ROLE'))){#Supervisor Lanjutan
				if($this->newsession->userdata('SESS_BBPOM_ID') != "95"){
					  $isEditTLBalai = TRUE;
					  $arrdata['obj_pangan'] = 'PEMERIKSAAN_PANGAN';
				}else{
					  if($this->newsession->userdata('SESS_BBPOM_ID') == $arrdata['BBPOM_ID'])
						  $isEditTLBalai = TRUE;
					  else
						  $isEditTLBalai = FALSE;
				}
				$arrdata['obj_status'] = 'SUPERVISOR[STATUS]';
				$arrdata['act'] = site_url().'/post/pemeriksaan/set_proses/01VV/spv-dua';
			}else if(array_key_exists('5', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('6', $this->newsession->userdata('SESS_KODE_ROLE'))){
				$isEditTLBalai = FALSE;
				$arrdata['obj_status'] = 'VERIFIKASI[STATUS]';
				$arrdata['act'] = site_url().'/post/pemeriksaan/set_proses/01VV/56';			  
			}
			
			if($subid!=""){
				$isEditTLBalai = FALSE;
				$isverifikasi = FALSE;
			}else{
				$isverifikasi = TRUE;
			}
			
			$arrdata['headersarana'] =$sipt->main->get_judul($jenis);
			$arrdata['status'] = $sipt->main->set_verifikasi($stat, $this->newsession->userdata('SESS_JENIS_PELAPORAN'), $this->newsession->userdata('SESS_KODE_ROLE'));
			$arrdata['disverifikasi'] = $stat;
			$arrdata['isEditTLBalai'] = $isEditTLBalai;
			$arrdata['isverifikasi'] = $isverifikasi;
			$arrdata['tindakan'] = $sipt->main->referensi("TL_PANGAN","'01','02','03','04','05','06'",TRUE,FALSE);
			$arrdata['urlback'] = site_url().'/home/pelaporan/pemeriksaan/view';
			$arrdata['histori_petugas'] = site_url().'/load/petugas/get_petugas/'.$arrdata['SURAT_ID'];
			$arrdata['log'] = site_url().'/get/pemeriksaan/get_log/'.$idperiksa[0];
			$arrdata['redir'] = substr($jenis,0,2)."/".$idperiksa[1];
			/* Cek Pemeriksaan Sebelumnya */
			$chkquery = "SELECT TOP 1 A.PERIKSA_ID FROM T_PEMERIKSAAN_PIRT A LEFT JOIN T_PEMERIKSAAN B ON A.PERIKSA_ID = B.PERIKSA_ID WHERE B.SARANA_ID = '".$sarana."' AND B.STATUS = '60010' ORDER BY B.PERIKSA_ID DESC";
			$arrdata['histori'] = FALSE;
			$datachk = $this->db->query($chkquery);
			if($datachk->num_rows() > 0){
				$res = $datachk->row();
				$arrdata['histori'] = TRUE;
				$arrdata['histori_rekapan'] = $this->db->query("SELECT PERIKSA_ID, SERI, LTRIM(RTRIM(ID)) AS ID, KETIDAKSESUAIAN, KRITERIA, TIMELINE, TINDAKAN_PERBAIKAN, STATUS FROM T_PEMERIKSAAN_PIRT_FLTK WHERE PERIKSA_ID = '".$res->PERIKSA_ID."'")->result_array();
				$arrdata['histori_id'] = $res->PERIKSA_ID;
				$arrdata['arrstatus'] = array("Pilihan" => "", "Sesuai" => "Sesuai", "Tidak Sesuai" => "Tidak Sesuai");
			}
			/* Akhir Pemeriksaan Sebelumnya */
			
			/* Jenis Pangan */
			$arrdata['jenis_pangan'] = $this->db->query("SELECT SARANA_ID, SERI, NO_PIRT, JENIS_PANGAN, CASE WHEN STATUS = 1 THEN 'Berlaku' WHEN STATUS = 0 THEN 'Tidak berlaku' END AS STATUS FROM T_SARANA_JENIS_PANGAN WHERE SARANA_ID = '".$sarana."' ")->result_array();
			/* Akhir Jenis Pangan */
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
					  $seri = (int)$sipt->main->get_uraian("SELECT MAX(SERI) AS MAXID FROM T_PEMERIKSAAN_PROSES WHERE PERIKSA_ID = '".$this->input->post('PERIKSA_ID')."'", "MAXID") + 1;
					  $arr_proses = array('PERIKSA_ID' => $this->input->post('PERIKSA_ID'),
										  'SERI' => $seri,
										  'HASIL' => $status,
										  'CATATAN' => $this->input->post('catatan'),
										  'CREATE_BY' => $this->newsession->userdata('SESS_USER_ID'),
										  'CREATE_DATE' => 'GETDATE()');
					  $this->db->insert('T_PEMERIKSAAN_PROSES', $arr_proses);#Log Pemeriksaan
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
					 if($this->newsession->userdata('SESS_BBPOM_ID') != "00" && $this->input->post('PEMERIKSAAN_PANGAN'))
						  foreach($this->input->post('PEMERIKSAAN_PANGAN') as $c => $d){
							  if(!is_array($d))
								  $arr_update[$c] = $d;
							  else
								  $arr_update[$c] = join("#", $d);
						  $this->db->where(array("PERIKSA_ID" => $this->input->post('PERIKSA_ID')));
						  $this->db->update('T_PEMERIKSAAN_PANGAN', $arr_update); #Update Tindak Lanjut
					 }
					 $seri = (int)$sipt->main->get_uraian("SELECT MAX(SERI) AS MAXID FROM T_PEMERIKSAAN_PROSES WHERE PERIKSA_ID = '".$this->input->post('PERIKSA_ID')."'", "MAXID") + 1;
					 $arr_proses = array('PERIKSA_ID' => $this->input->post('PERIKSA_ID'),
										 'SERI' => $seri,
										 'HASIL' => $status,
										 'CATATAN' => $this->input->post('catatan'),
										 'CREATE_BY' => $this->newsession->userdata('SESS_USER_ID'),
										 'CREATE_DATE' => 'GETDATE()');
					 $this->db->insert('T_PEMERIKSAAN_PROSES', $arr_proses);
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

	function get_history($sarana,$idperiksa){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$idperiksa = explode(".",$idperiksa);
			$query = "SELECT (CAST(A.SARANA_ID AS VARCHAR) + '/' + A.JENIS_SARANA_ID + '/' + STUFF(dbo.GROUP_KLASIFIKASI(A.PERIKSA_ID),1,1,'') + '/' + CAST(A.PERIKSA_ID AS VARCHAR) + '.' + A.STATUS + '/1') AS IDPERIKSA, A.PERIKSA_ID, A.SARANA_ID, A.JENIS_SARANA_ID, CONVERT(VARCHAR(10), A.AWAL_PERIKSA, 103) AS [AWAL PERIKSA], CONVERT(VARCHAR(10), A.AKHIR_PERIKSA, 103) AS [AKHIR PERIKSA], A.HASIL, B.LEVEL_IRTP
FROM T_PEMERIKSAAN A LEFT JOIN  T_PEMERIKSAAN_PIRT B ON A.PERIKSA_ID = B.PERIKSA_ID WHERE A.SARANA_ID = '".$sarana."' AND A.BBPOM_ID ='".$this->newsession->userdata('SESS_BBPOM_ID')."'";
			$arrdata['data'] = $this->db->query($query)->result_array();
			echo $this->load->view('pemeriksaan/preview/01VV/histori',$arrdata,true);
		}
	}
	
	function set_histori($periksaid){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$sipt->load->model("main","main", true);
			$query = "SELECT A.SARANA_ID, A.NAMA_SARANA, A.NAMA_PIMPINAN, A.PENANGGUNG_JAWAB, A.ALAMAT_1, A.JENIS_PANGAN, A.NAMA_PANGAN, A.NOMOR_REGISTRASI, CONVERT(VARCHAR(10), A.TANGGAL_IZIN, 103) AS TANGGAL_IZIN, A.NOMOR_IZIN, A.TELEPON, A.EMAIL, B.PERIKSA_ID, B.JENIS_SARANA_ID, B.BBPOM_ID, STUFF(dbo.GROUP_KLASIFIKASI(B.PERIKSA_ID),1,1,'') AS KK_ID, CONVERT(VARCHAR(10), B.AWAL_PERIKSA, 103) AS AWAL_PERIKSA, CONVERT(VARCHAR(10), B.AKHIR_PERIKSA, 103) AS AKHIR_PERIKSA, B.HASIL, C.STATUS_SARANA, C.PENGAWAS, C.TUJUAN_PEMERIKSAAN, C.ELEMENT_PERIKSA, C.KETIDAKSESUAIAN, C.CATATAN, C.RINCIAN_NOMOR, CAST(C.RINCIAN_KETIDAKSESUAIAN AS VARCHAR(MAX)) AS RINCIAN_KETIDAKSESUAIAN, CAST(C.RINCIAN_KRITERIA AS VARCHAR(MAX)) AS RINCIAN_KRITERIA, CAST(C.RINCIAN_TIMELINE AS VARCHAR(MAX)) AS RINCIAN_TIMELINE, CAST(C.RINCIAN_PERBAIKAN AS VARCHAR(MAX)) AS RINCIAN_PERBAIKAN, C.JML_KRITIS, C.JML_SERIUS, C.JML_MAJOR, C.JML_MINOR, C.LEVEL_IRTP, STUFF(dbo.GROUP_CONCAT(B.PERIKSA_ID),1,1,'') AS SURAT_ID FROM M_SARANA A LEFT JOIN T_PEMERIKSAAN B ON A.SARANA_ID = B.SARANA_ID LEFT JOIN T_PEMERIKSAAN_PIRT C ON B.PERIKSA_ID = C.PERIKSA_ID WHERE B.PERIKSA_ID = '".$periksaid."'";
			$data = $sipt->main->get_result($query);
			if($data){
				foreach($query->result_array() as $row){
					$arrdata['sess'] = $row;
				}
				$arrdata['histori_petugasx'] = site_url().'/load/petugas/get_petugas/'.$arrdata['SURAT_ID'];
				$arrdata['aspek_penilaian'] = explode("#", $row['KETIDAKSESUAIAN']);
				$arrdata['element_periksa'] = explode("#", $row['ELEMENT_PERIKSA']);
				$arrdata['rincian_nomor'] = explode("#", $row['RINCIAN_NOMOR']);
				$arrdata['rincian_ketidaksesuaian'] = explode("#", $row['RINCIAN_KETIDAKSESUAIAN']);
				$arrdata['rincian_kriteria'] = explode("#", $row['RINCIAN_KRITERIA']);
				$arrdata['rincian_timeline'] = explode("#", $row['RINCIAN_TIMELINE']);
				$arrdata['rincian_perbaikan'] = explode("#", $row['RINCIAN_PERBAIKAN']);
			}
			return $arrdata;
		}
	}
	
	function get_history_($sarana){
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
			$query = "SELECT (CAST(A.SARANA_ID AS VARCHAR) + '/' + A.JENIS_SARANA_ID + '/' + STUFF(dbo.GROUP_KLASIFIKASI(A.PERIKSA_ID),1,1,'') + '/' + CAST(A.PERIKSA_ID AS VARCHAR) + '.' + A.STATUS + '/1') AS IDPERIKSA, A.PERIKSA_ID, A.SARANA_ID, A.JENIS_SARANA_ID, CONVERT(VARCHAR(10), A.AWAL_PERIKSA, 103) AS [AWAL PERIKSA], CONVERT(VARCHAR(10), A.AKHIR_PERIKSA, 103) AS [AKHIR PERIKSA], A.HASIL, C.URAIAN AS [STATUS PEMERIKSAAN] FROM T_PEMERIKSAAN A LEFT JOIN T_PEMERIKSAAN_PANGAN B ON A.PERIKSA_ID = B.PERIKSA_ID LEFT JOIN M_TABEL C ON A.STATUS = C.KODE WHERE A.SARANA_ID = '$sarana' AND C.JENIS='STATUS' AND A.BBPOM_ID ='".$this->newsession->userdata('SESS_BBPOM_ID')."' AND A.STATUS IN ('20')";
			$tabel = $this->newtable->generate($query);
			$tabel .= "<script type=\"text/javascript\" src=\"".base_url()."js/newtable.js\"></script>";
			return $tabel;
		}else{
			$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
		}
	}
	
	function set_bap_($sarana,$jenis,$idperiksa,$subid){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$sipt->load->model("main","main", true);
			$func =& get_instance();
			$func->load->model("functions","functions", true);
			$idperiksa = explode(".", $idperiksa);
			$query = "SELECT (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN_PROSES WHERE PERIKSA_ID='$idperiksa[0]') AS JML_PROSES, A.SARANA_ID, A.NAMA_SARANA, A.ALAMAT_1, A.NAMA_PIMPINAN, A.NOMOR_IZIN, A.JUMLAH_KARYAWAN, A.UMUR_BANGUNAN, B.PERIKSA_ID, B.JENIS_SARANA_ID, B.BBPOM_ID, STUFF(dbo.GROUP_KLASIFIKASI(B.PERIKSA_ID),1,1,'') AS KK_ID, CONVERT(VARCHAR(10), B.AWAL_PERIKSA, 103) AS AWAL_PERIKSA, CONVERT(VARCHAR(10), B.AKHIR_PERIKSA, 103) AS AKHIR_PERIKSA, B.HASIL, C.KESIMPULAN, C.REKOMENDASI, C.TINDAKAN, C.CAPA, C.ASPEK_PENILAIAN, C.KESIMPULAN_GRUP, C.HASIL_TEMUAN_LAIN, STUFF(dbo.GROUP_CONCAT(B.PERIKSA_ID),1,1,'') AS SURAT_ID FROM M_SARANA A LEFT JOIN T_PEMERIKSAAN B ON A.SARANA_ID = B.SARANA_ID LEFT JOIN T_PEMERIKSAAN_PANGAN C ON B.PERIKSA_ID = C.PERIKSA_ID WHERE B.SARANA_ID = '$sarana' AND B.PERIKSA_ID = '$idperiksa[0]'";
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
					$aspek = explode("#", $row['ASPEK_PENILAIAN']);
					$inisal = array("3", "2", "1");
					$ganti = array("Baik", "Cukup", "Kurang");
					$arrdata['aspek_penilaian'] = str_replace($inisal, $ganti, $aspek); 
					$grup = explode("#", $row['KESIMPULAN_GRUP']);
					$ini_grup = array("B", "C", "K");
					$ganti_grup = array("Baik", "Cukup", "Kurang");
					$arrdata['kesimpulan_grup'] = str_replace($ini_grup, $ganti_grup, $grup);
					$arrdata['sel_tindakan'] = explode("#", $row['TINDAKAN']);
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
		$html = $this->load->view('pemeriksaan/bap/'.$jenis, $arrdata, true);
		$bap = $this->mpdf->WriteHTML($html);
		$bap = $this->mpdf->Output();
		echo $bap;
	}
	
	function set_bap($sarana,$jenis,$idperiksa,$subid){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$sipt->load->model("main","main", true);
			$func =& get_instance();
			$func->load->model("functions","functions", true);
			$idperiksa = explode(".", $idperiksa);
			
			$query = "SELECT (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN_PROSES WHERE PERIKSA_ID='$idperiksa[0]') AS JML_PROSES, A.SARANA_ID, A.NAMA_SARANA, A.NAMA_PIMPINAN, A.PENANGGUNG_JAWAB, A.ALAMAT_1, A.JENIS_PANGAN, A.NAMA_PANGAN, A.NOMOR_REGISTRASI, CONVERT(VARCHAR(10), A.TANGGAL_IZIN, 103) AS TANGGAL_IZIN, A.NOMOR_IZIN, B.PERIKSA_ID, B.PERIKSA_ID, B.JENIS_SARANA_ID, B.BBPOM_ID, STUFF(dbo.GROUP_KLASIFIKASI(B.PERIKSA_ID),1,1,'') AS KK_ID, CONVERT(VARCHAR(10), B.AWAL_PERIKSA, 103) AS AWAL_PERIKSA, CONVERT(VARCHAR(10), B.AKHIR_PERIKSA, 103) AS AKHIR_PERIKSA, B.HASIL, CASE WHEN C.STATUS_SARANA = '1' THEN 'Aktif' WHEN C.STATUS_SARANA = '0' THEN 'Tidak Aktif / Tutup' WHEN C.STATUS_SARANA = '2' THEN 'Tidak Produksi Saat Diperiksa' WHEN C.STATUS_SARANA = '3' THEN 'Menolak Diperiksa' END AS UR_STATUS_SARANA, C.STATUS_SARANA, C.PENGAWAS, C.TUJUAN_PEMERIKSAAN, C.ELEMENT_PERIKSA, C.KETIDAKSESUAIAN, C.CATATAN, C.RINCIAN_NOMOR, CAST(C.RINCIAN_KETIDAKSESUAIAN AS VARCHAR(MAX)) AS RINCIAN_KETIDAKSESUAIAN, CAST(C.RINCIAN_KRITERIA AS VARCHAR(MAX)) AS RINCIAN_KRITERIA, CAST(C.RINCIAN_TIMELINE AS VARCHAR(MAX)) AS RINCIAN_TIMELINE, CAST(C.RINCIAN_PERBAIKAN AS VARCHAR(MAX)) AS RINCIAN_PERBAIKAN, C.JML_KRITIS, C.JML_SERIUS, C.JML_MAJOR, C.JML_MINOR, C.LEVEL_IRTP, STUFF(dbo.GROUP_CONCAT(B.PERIKSA_ID),1,1,'') AS SURAT_ID FROM M_SARANA A LEFT JOIN T_PEMERIKSAAN B ON A.SARANA_ID = B.SARANA_ID LEFT JOIN T_PEMERIKSAAN_PIRT C ON B.PERIKSA_ID = C.PERIKSA_ID WHERE B.SARANA_ID = '$sarana' AND B.PERIKSA_ID = '$idperiksa[0]'";
			$data = $sipt->main->get_result($query);
			$bulan = $this->config->config;
			$bulan = $bulan['bulan'];		
			if($data){
				foreach($query->result_array() as $row){
					$tgl = explode('/', $row['AWAL_PERIKSA']);
					$tgla = (int)$tgl[1];
					$tgla = $bulan[$tgla];
					$hari = "$tgl[2]/$tgl[1]/$tgl[0]";
					$arrdata = array('sess' => $row,
									 'petugas' => $sipt->main->bap_petugas($idperiksa[0]), 'hari' => $func->functions->get_hari($hari),
									 'awal_periksa' => "$tgl[0] bulan $tgla tahun $tgl[2]");
					$arrdata['aspek_penilaian'] = explode("#", $row['KETIDAKSESUAIAN']);
					$arrdata['element_periksa'] = explode("#", $row['ELEMENT_PERIKSA']);
					$arrdata['rincian_nomor'] = explode("#", $row['RINCIAN_NOMOR']);
					$arrdata['rincian_ketidaksesuaian'] = explode("#", $row['RINCIAN_KETIDAKSESUAIAN']);
					$arrdata['rincian_kriteria'] = explode("#", $row['RINCIAN_KRITERIA']);
					$arrdata['rincian_timeline'] = explode("#", $row['RINCIAN_TIMELINE']);
					$arrdata['rincian_perbaikan'] = explode("#", $row['RINCIAN_PERBAIKAN']);
					
				}
				$chkquery = "SELECT TOP 1 A.PERIKSA_ID FROM T_PEMERIKSAAN_PIRT A LEFT JOIN T_PEMERIKSAAN B ON A.PERIKSA_ID = B.PERIKSA_ID WHERE B.SARANA_ID = '".$sarana."' AND B.STATUS = '60010' ORDER BY B.PERIKSA_ID DESC";
				$arrdata['histori'] = FALSE;
				$datachk = $this->db->query($chkquery);
				if($datachk->num_rows() > 0){
					$res = $datachk->row();
					$arrdata['histori'] = TRUE;
					$arrdata['histori_rekapan'] = $this->db->query("SELECT PERIKSA_ID, SERI, LTRIM(RTRIM(ID)) AS ID, KETIDAKSESUAIAN, KRITERIA, TIMELINE, TINDAKAN_PERBAIKAN, STATUS FROM T_PEMERIKSAAN_PIRT_FLTK WHERE PERIKSA_ID = '".$res->PERIKSA_ID."'")->result_array();
					$arrdata['histori_id'] = $res->PERIKSA_ID;
					$arrdata['arrstatus'] = array("Pilihan" => "", "Sesuai" => "Sesuai", "Tidak Sesuai" => "Tidak Sesuai");
				}
				$arrdata['jenis_pangan'] = $this->db->query("SELECT SARANA_ID, SERI, NO_PIRT, JENIS_PANGAN, CASE WHEN STATUS = 1 THEN 'Berlaku' WHEN STATUS = 0 THEN 'Tidak berlaku' END AS STATUS FROM T_SARANA_JENIS_PANGAN WHERE SARANA_ID = '".$sarana."' ")->result_array();
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
		$html = $this->load->view('pemeriksaan/bap/01VV_NEW', $arrdata, true);
		$bap = $this->mpdf->WriteHTML($html);
		$bap = $this->mpdf->Output();
		echo $bap;
	}
	
	
	function get_jenis_pangan($sarana){
		if($this->newsession->userdata('LOGGED_IN')){
			$sipt =& get_instance();
			$sipt->load->model("main","main", true);
			$arrdata['jenis_pangan_new'] = $sipt->main->combobox("SELECT LTRIM(RTRIM(KODE)) AS KODE, dbo.FIRST_CAPITAL(JENIS_PANGAN) AS JENIS_PANGAN FROM M_JENIS_PANGAN_NEW WHERE LEN(KODE) = 2","KODE","JENIS_PANGAN",TRUE);
			$arrdata['act'] = site_url().'/post/pemeriksaan/set_periksa/01VV/jenis-pangan';
			$arrdata['sarana_id'] = $sarana;
			return $arrdata;
		}
	}
}
?>