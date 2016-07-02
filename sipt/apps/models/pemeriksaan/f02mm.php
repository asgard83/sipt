<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);

class F02MM extends Model{
	
	function GetForm02MM($sarana, $jenis, $klasifikasi, $idperiksa){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			if(!array_key_exists($jenis, $this->newsession->userdata("SESS_SARANA")) && !array_key_exists($klasifikasi, $this->newsession->userdata("SESS_KLASIFIKASI_ID"))) return $this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
			$sipt =& get_instance();
			$sipt->load->model("main", "main", true);
			if($idperiksa==""){#Input Mode				  
				if(!$this->session->userdata('SURAT')) return $this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
				$qsarana = "SELECT SARANA_ID, NAMA_SARANA, ALAMAT_1, ALAMAT_2, TELEPON, NOMOR_IZIN, TANGGAL_IZIN, NO_SIK, PENANGGUNG_JAWAB, NAMA_PIMPINAN FROM M_SARANA WHERE SARANA_ID='$sarana'";
				$dt_sarana = $sipt->main->get_result($qsarana);
				if($dt_sarana){
					foreach($qsarana->result_array() as $row){
						$arrdata = array('sess' => $row,
										 'SURAT_ID' => '',								 
										 'BBPOM_ID' => $this->newsession->userdata('SESS_BBPOM_ID'),
										 'aspek_penilaian' => '',
										 'tindak_lanjut_balai' => '',
										 'detil_tindak_lanjut_balai' => '',
										 'tindak_lanjut_pusat' => '',
										 'detil_tindak_lanjut_pusat' => '',
										 'temuan_produk' => '',
										 'sel_tujuan' => 'Rutin',
										 'act' => site_url().'/post/pemeriksaan/set_periksa/02MM/simpan',
										 'urlback' => site_url().'/home/pelaporan/pemeriksaan');
					}
				}
			}else{
				$idperiksa = explode(".", $idperiksa);
				$status = $idperiksa[1];
				/**
				* Redirect for old form
				*/
				$is_distribusi_new = (int)$sipt->main->get_uraian("SELECT IS_DISTRIBUSI_NEW FROM T_PEMERIKSAAN WHERE PERIKSA_ID ='".$idperiksa[0]."'","IS_DISTRIBUSI_NEW");
				if($is_distribusi_new == 0){
					redirect(site_url().'/home/distribusi/checklist/' . $sarana . '/' . $jenis . '/001/' . join(".",$idperiksa));  
					exit();
				}
				/**
				*End Redirect
				*/
				$qperiksa = "SELECT (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN_DISTRIBUSI_PERBAIKAN WHERE PERIKSA_ID='$idperiksa[0]') AS JML_PERBAIKAN, (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN_TEMUAN_PRODUK WHERE PERIKSA_ID='$idperiksa[0]') AS JUMLAH_TEMUAN, A.NAMA_SARANA, A.ALAMAT_1, A.ALAMAT_2, A.TELEPON, A.NOMOR_IZIN, A.TANGGAL_IZIN, A.NO_SIK, A.NAMA_PIMPINAN, A.PENANGGUNG_JAWAB, B.PERIKSA_ID, B.JENIS_SARANA_ID, B.BBPOM_ID,STUFF(dbo.GROUP_KLASIFIKASI(B.PERIKSA_ID),1,1,'') AS KK_ID, CONVERT(VARCHAR(10), B.AWAL_PERIKSA, 103) AS AWAL_PERIKSA, CONVERT(VARCHAR(10), B.AKHIR_PERIKSA, 103) AS AKHIR_PERIKSA, C.TUJUAN_PEMERIKSAAN, C.ASPEK_PENILAIAN, C.HASIL_TEMUAN, C.HASIL_TEMUAN_LAIN, C.CATATAN_HASIL_PEMERIKSAAN, B.HASIL, B.HASIL_PUSAT, C.KASUS_POINT_A, C.KASUS_POINT_B, C.KASUS_POINT_C, C.KASUS_POINT_D, C.KASUS_POINT_E, C.KASUS_POINT_F, C.KASUS_POINT_G, C.KASUS_POINT_H, C.KLASIFIKASI_PELANGGARAN_MAJOR AS MAJOR, C.KLASIFIKASI_PELANGGARAN_MINOR AS MINOR, C.KLASIFIKASI_PELANGGARAN_CRITICAL AS CRITICAL, KLASIFIKASI_PELANGGARAN_CRITICAL_ABSOLUTE AS CRITICAL_ABSOLUT, C.TINDAK_LANJUT_BALAI, C.DETAIL_TINDAK_LANJUT_BALAI, C.TINDAK_LANJUT_PUSAT, C.DETIL_TINDAK_LANJUT_PUSAT, C.LAMPIRAN_MAPPING, C.LAMPIRAN_BAP, D.KATEGORI, D.NAMA_PRODUK, D.NAMA_PABRIK, D.NEGARA_ASAL, D.KEMASAN, D.NOMOR_REGISTRASI, D.NO_BATCH, D.TANGGAL_EXPIRE, D.JUMLAH_TEMUAN, D.SATUAN, D.NAMA_PERUSAHAAN, D.ALAMAT_PERUSAHAAN, D.PEMILIK, D.TINDAKAN_PRODUK, D.KETERANGAN_SUMBER, STUFF(dbo.GROUP_CONCAT(B.PERIKSA_ID),1,1,'') AS SURAT_ID FROM M_SARANA A LEFT JOIN T_PEMERIKSAAN B ON A.SARANA_ID = B.SARANA_ID LEFT JOIN T_PEMERIKSAAN_DISTRIBUSI C ON B.PERIKSA_ID = C.PERIKSA_ID LEFT JOIN T_PEMERIKSAAN_TEMUAN_PRODUK D ON B.PERIKSA_ID = D.PERIKSA_ID WHERE B.SARANA_ID='$sarana' AND B.PERIKSA_ID='$idperiksa[0]'";
				$dt_periksa = $sipt->main->get_result($qperiksa);
				if($dt_periksa){
					foreach($qperiksa->result_array() as $row){
						$temuan_produk[] = $row;
						$arrdata = array('sess' => $row,
										 'temuan_produk' => $temuan_produk,
										 'sel_tujuan' => $row['TUJUAN_PEMERIKSAAN'],
										 'urlback' => site_url().'/home/pelaporan/pemeriksaan/view/'.$status);
					}
					$arrdata['SURAT_ID'] = $row['SURAT_ID'];
					$arrdata['BBPOM_ID'] = $row['BBPOM_ID'];
					$arrdata['aspek_penilaian'] = explode("#", $row['ASPEK_PENILAIAN']);
					$arrdata['tindak_lanjut_balai'] = explode("#", $row['TINDAK_LANJUT_BALAI']);
					$arrdata['tindak_lanjut_pusat'] = explode("#", $row['TINDAK_LANJUT_PUSAT']);
					$arrdata['url_detil_perbaikan'] = site_url().'/get/pemeriksaan/set_perbaikan/'.$row['PERIKSA_ID'].'/'.$row['JENIS_SARANA_ID'];
				}
				if($this->newsession->userdata('SESS_BBPOM_ID') != "92"){#Update dan Perbaikan Balai
					if($status=="20101"){
						$arrdata['act'] = site_url().'/post/pemeriksaan/set_periksa/02MM/update';
					}else if($status=="20102" || $status =="20103"){
						$arrdata['act'] = site_url().'/post/pemeriksaan/set_periksa/02MM/perbaikan';
					}else if($status =="60020"){
						  $arrdata['act'] = site_url().'/post/pemeriksaan/set_periksa/02MM/rekomendasi';
					}
				}else{#Update dan Perbaikan Pusat
					if($status=="20111"){
						$arrdata['act'] = site_url().'/post/pemeriksaan/set_periksa/02MM/update';
					}else if($status =="20113" || $status =="20112"){
						$arrdata['act'] = site_url().'/post/pemeriksaan/set_periksa/02MM/perbaikan';
					}else if($status =="60020"){
						  $arrdata['act'] = site_url().'/post/pemeriksaan/set_periksa/02MM/rekomendasi';
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
			$disinput = array("JENISDIS","NAMADIS");
			$arrdata['headersarana'] =$sipt->main->get_judul($jenis);
			$arrdata['sarana_id'] = $sarana;
			$arrdata['jenis_sarana_id'] = $jenis;
			$arrdata['klasifikasi'] = $klasifikasi;
			$arrdata['jenis_sarana'] = $sipt->main->get_jenis_sarana($this->newsession->userdata("SESS_USER_ID"), $disinput);
			$arrdata['tujuan_periksa'] = $sipt->main->referensi("TUJUAN_PEMERIKSAAN","'1','2'",TRUE,TRUE);
			$arrdata['disinput'] = array("JENISDIS","NAMADIS");
			$arrdata['klasifikasi_kategori'] = $sipt->main->get_klasifikasi();
			$arrdata['kategori_temuan'] = $sipt->main->referensi("KATEGORI_TEMUAN","'09','10','11','12','14'",TRUE,FALSE);
			$arrdata['tindakan_produk'] = $sipt->main->referensi("TL_PRODUK_TEMUAN","'10','11'",TRUE,FALSE);
			$arrdata['kemasan'] = $sipt->main->referensi("KEMASAN","",TRUE,TRUE);
			$arrdata['hasil'] = $sipt->main->referensi("HASIL","'TMK','MK','TTP','TDP'",FALSE,TRUE);
			$arrdata['cb_kritis'] = array("0" => array("Y" => "Ya", "T" => "Tidak"), "1" => array("Y" => "Ya", "T" => "Tidak", "N" => "NA"));
			$arrdata['cb_tindakan'] = $sipt->main->referensi("TL_DISTRIBUSI","",TRUE,FALSE);
			$arrdata['histori_petugas'] = site_url().'/load/petugas/get_petugas/'.$arrdata['SURAT_ID'];			
			return $arrdata;
		}
		else
		{
			$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
		}
	}
		
	function SaveForm02MM($action, $isajax){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main","main", true);
			if(in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')))
				$status = '20111';
			else
				$status = '20101';		  	
			$ret = "MSG#NO#Data gagal disimpan#";
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
				if($_POST['PEMERIKSAAN_DISTRIBUSI']['TUJUAN_PEMERIKSAAN'] == "Mapping" && trim($_POST['PEMERIKSAAN_DISTRIBUSI']['LAMPIRAN_MAPPING']) == ""){
					return "MSG#NO#Data gagal disimpan, belum melampirkan file attachment maping. \n Atau terjadi kesalahan dalam Upload attachment mapping. \n Silahkan muat ulang kembali halaman browser";
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
										 'IS_DISTRIBUSI_NEW' => 1,
										 'UPDATE_BY' => $this->newsession->userdata('SESS_USER_ID'),
										 'LAST_UPDATE' => 'GETDATE()');
				foreach($this->input->post('PEMERIKSAAN') as $a => $b){
					$arr_pemeriksaan[$a] = $b;
				}
				if($this->db->insert('T_PEMERIKSAAN', $arr_pemeriksaan)){
					$arr_klasifikasi = explode("-", $this->input->post('KLASIFIKASI'));
					$arr_distribusi = array('PERIKSA_ID' => $periksa_id);
					foreach($this->input->post('PEMERIKSAAN_DISTRIBUSI') as $c => $d){
						if(!is_array($d))
							$arr_distribusi[$c] = $d;
						else
							$arr_distribusi[$c] = join("#", $d);
					}
					if($arr_pemeriksaan['HASIL'] != "TMK"){
						$arr_distribusi['ASPEK_PENILAIAN'] = str_replace("T","Y",$arr_distribusi['ASPEK_PENILAIAN']);
						$arr_distribusi['HASIL_TEMUAN'] = "";
						$arr_distribusi['KLASIFIKASI_PELANGGARAN_MAJOR'] = 0;
						$arr_distribusi['KLASIFIKASI_PELANGGARAN_MINOR'] = 0;
						$arr_distribusi['KLASIFIKASI_PELANGGARAN_CRITICAL'] = 0;
						$arr_distribusi['KLASIFIKASI_PELANGGARAN_CRITICAL_ABSOLUTE'] = 0;
					}
					$this->db->insert('T_PEMERIKSAAN_DISTRIBUSI', $arr_distribusi);
					
					foreach($SES_ID as $a){
						$pelaporan = array('SURAT_ID' => $a, 'LAPOR_ID' => $periksa_id);
						$this->db->insert('T_SURAT_TUGAS_PELAPORAN', $pelaporan);
					}
					
					foreach($arr_klasifikasi as $kk_id){
						$pemeriksaan_klasifikasi = array('PERIKSA_ID' => $periksa_id, 'KK_ID' => $kk_id);
						$this->db->insert('T_PEMERIKSAAN_KLASIFIKASI', $pemeriksaan_klasifikasi);
					}

					if($this->input->post('TEMUAN_PRODUK')){					
						$arrtemuan = $this->input->post('TEMUAN_PRODUK');
						$arrkeys = array_keys($arrtemuan);
						for($i=0;$i<count($arrtemuan[$arrkeys[0]]);$i++){
							$seri = (int)$sipt->main->get_uraian("SELECT MAX(SERI) AS MAXID FROM T_PEMERIKSAAN_TEMUAN_PRODUK WHERE PERIKSA_ID = '$periksa_id'", "MAXID") + 1;
							$temuan = array('PERIKSA_ID' => $periksa_id,
											'SERI' => $seri,
											'KK_ID' => '001');
							for($j=0;$j<count($arrkeys);$j++){
								$temuan[$arrkeys[$j]] = $arrtemuan[$arrkeys[$j]][$i];
							}
							$this->db->insert('T_PEMERIKSAAN_TEMUAN_PRODUK', $temuan);
						}
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
			}else if($action=="update" || $action == "perbaikan" || $action == "perbaikan"){#Update
				  $arr_pemeriksaan = array('UPDATE_BY' => $this->newsession->userdata('SESS_USER_ID'),'LAST_UPDATE' => 'GETDATE()');
				  foreach($this->input->post('PEMERIKSAAN') as $a => $b){
				  	$arr_pemeriksaan[$a] = $b;
				  }
				  if($action=="perbaikan" || $action == "rekomendasi"){
					  if($this->newsession->userdata('SESS_BBPOM_ID') != "92"){
					  	$arr_pemeriksaan['STATUS'] = '30104';
						$status = "30104";
					  }else{
					  	$arr_pemeriksaan['STATUS'] = '30114';
						$status = "30114";
					  }
				  }		
				  $this->db->where(array("PERIKSA_ID" => $this->input->post('PERIKSA_ID')));	
				  if($this->db->update('T_PEMERIKSAAN', $arr_pemeriksaan)){	
					  foreach($this->input->post('PEMERIKSAAN_DISTRIBUSI') as $c => $d){
						  if(!is_array($d))
							  $arr_distribusi[$c] = $d;
						  else
						  	  $arr_distribusi[$c] = join("#", $d);
					  }
					  if($arr_pemeriksaan['HASIL'] != "TMK"){
						  $arr_distribusi['ASPEK_PENILAIAN'] = str_replace("T","Y",$arr_distribusi['ASPEK_PENILAIAN']);
						  $arr_distribusi['HASIL_TEMUAN'] = "";
						  $arr_distribusi['KLASIFIKASI_PELANGGARAN_MAJOR'] = 0;
						  $arr_distribusi['KLASIFIKASI_PELANGGARAN_MINOR'] = 0;
						  $arr_distribusi['KLASIFIKASI_PELANGGARAN_CRITICAL'] = 0;
						  $arr_distribusi['KLASIFIKASI_PELANGGARAN_CRITICAL_ABSOLUTE'] = 0;
					  }
					  $this->db->where(array("PERIKSA_ID" => $this->input->post('PERIKSA_ID')));
					  $this->db->update('T_PEMERIKSAAN_DISTRIBUSI', $arr_distribusi);

					  if($this->input->post('TEMUAN_PRODUK')){
						  $this->db->where('PERIKSA_ID', $this->input->post('PERIKSA_ID'));
						  $this->db->delete('T_PEMERIKSAAN_TEMUAN_PRODUK');
						  $arrtemuan = $this->input->post('TEMUAN_PRODUK');
						  $arrkeys = array_keys($arrtemuan);
						  for($i=0;$i<count($arrtemuan[$arrkeys[0]]);$i++){
							  $seri = (int)$sipt->main->get_uraian("SELECT MAX(SERI) AS MAXID FROM T_PEMERIKSAAN_TEMUAN_PRODUK WHERE PERIKSA_ID = '".$this->input->post('PERIKSA_ID')."'", "MAXID") + 1;
							  $temuan = array('PERIKSA_ID' => $this->input->post('PERIKSA_ID'),
											  'SERI' => $seri,
											  'KK_ID' => '001');
							  for($j=0;$j<count($arrkeys);$j++){
								  $temuan[$arrkeys[$j]] = $arrtemuan[$arrkeys[$j]][$i];
							  }
							  $this->db->insert('T_PEMERIKSAAN_TEMUAN_PRODUK', $temuan);
						  }
					  }
					  
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
						  $ret = "MSG#YES#Data berhasil disimpan#".site_url()."/home/pelaporan/pemeriksaan/view/".substr($this->input->post('JENIS_SARANA_ID'), 0,2)."/".$redir."#".site_url()."/post/pemeriksaan/set_confirm/ajax/".$periksa_id;
					  }else if($action=="perbaikan" || $action == "rekomendasi"){
						  $ret = "MSG#YES#Data berhasil disimpan#".site_url()."/home/pelaporan/pemeriksaan/view/all/send";
					  }

				  }
			  return $ret;  
			}
			else if($action == "reupload-mapping"){
				$hasil = FALSE;
				$msgok = "Update ulang lampiran mapping berhasil";
				$msgerr = "Update ulang lampiran mapping gagal";
				foreach($this->input->post('PEMERIKSAAN_DISTRIBUSI') as $a => $b){
					$arrmap[$a] = $b;
				}	
				$this->db->where(array("PERIKSA_ID" => $this->input->post('PERIKSA_ID')));
				$res = $this->db->update('T_PEMERIKSAAN_DISTRIBUSI', $arrmap);
				if($res){
					$hasil = TRUE;
				}
				if($hasil) return "MSG#YES#$msgok#SUKSES";
				else return "MSG#NO#$msgerr";
			}
		}else{
			$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
		}
	}

	function get_preview($sarana,$id, $jenis){
		$sipt =& get_instance();
		$this->load->model("main","main", true);		
		$id = explode(".", $id);
		$query = "SELECT A.CREATE_BY, A.JENIS_SARANA_ID, (CAST(A.SARANA_ID AS VARCHAR) + '/' + A.JENIS_SARANA_ID + '/' + STUFF(dbo.GROUP_KLASIFIKASI(A.PERIKSA_ID),1,1,'') + '/' + CAST(A.PERIKSA_ID AS VARCHAR) + '.' + A.STATUS) AS IDPERIKSA, A.PERIKSA_ID, A.SARANA_ID, A.STATUS, CONVERT(VARCHAR(10), A.AWAL_PERIKSA, 103) AS [AWAL_PERIKSA], CONVERT(VARCHAR(10), A.AKHIR_PERIKSA, 103) AS [AKHIR_PERIKSA], B.TUJUAN_PEMERIKSAAN, B.HASIL_TEMUAN, B.CATATAN_HASIL_PEMERIKSAAN, B.KASUS_POINT_A, B.KASUS_POINT_B, B.KASUS_POINT_C, B.KASUS_POINT_D, B.KASUS_POINT_E, B.KASUS_POINT_F, B.KASUS_POINT_G, B.KASUS_POINT_H, B.KLASIFIKASI_PELANGGARAN_MAJOR AS MAJOR, B.KLASIFIKASI_PELANGGARAN_MINOR AS MINOR, B.KLASIFIKASI_PELANGGARAN_CRITICAL AS CRITICAL, B.KLASIFIKASI_PELANGGARAN_CRITICAL_ABSOLUTE AS CA, B.LAMPIRAN_MAPPING, B.LAMPIRAN_BAP, STUFF(dbo.GROUP_CONCAT(A.PERIKSA_ID),1,1,'') AS SURAT_ID, C.URAIAN FROM T_PEMERIKSAAN A LEFT JOIN T_PEMERIKSAAN_DISTRIBUSI B ON A.PERIKSA_ID = B.PERIKSA_ID LEFT JOIN M_TABEL C ON A.HASIL = C.KODE WHERE A.SARANA_ID = '$sarana'  AND C.JENIS = 'HASIL' AND A.PERIKSA_ID = '$id[0]' ";
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
			/**
			* Redirect for old form
			*/
			$is_distribusi_new = (int)$sipt->main->get_uraian("SELECT IS_DISTRIBUSI_NEW FROM T_PEMERIKSAAN WHERE PERIKSA_ID ='".$idperiksa[0]."'","IS_DISTRIBUSI_NEW");
			if($is_distribusi_new == 0){
				redirect(site_url().'/home/distribusi/proses/' . $sarana . '/' . $jenis . '/001/' . join(".",$idperiksa));  
				exit();
			}
			/**
			*End Redirect
			*/
			$query = "SELECT (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN_DISTRIBUSI_PERBAIKAN WHERE PERIKSA_ID='$idperiksa[0]') AS JML_PERBAIKAN, (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN_PROSES WHERE PERIKSA_ID = '$idperiksa[0]') AS JML_PROSES, (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN_TEMUAN_PRODUK WHERE PERIKSA_ID='$idperiksa[0]') AS JUMLAH_TEMUAN, A.SARANA_ID, A.NAMA_SARANA, A.ALAMAT_1, A.ALAMAT_2, A.TELEPON, A.NOMOR_IZIN, A.TANGGAL_IZIN, A.NO_SIK, A.NAMA_PIMPINAN, A.PENANGGUNG_JAWAB, B.PERIKSA_ID, B.JENIS_SARANA_ID, B.BBPOM_ID,STUFF(dbo.GROUP_KLASIFIKASI(B.PERIKSA_ID),1,1,'') AS KK_ID, CONVERT(VARCHAR(10), B.AWAL_PERIKSA, 103) AS AWAL_PERIKSA, CONVERT(VARCHAR(10), B.AKHIR_PERIKSA, 103) AS AKHIR_PERIKSA, C.TUJUAN_PEMERIKSAAN, C.ASPEK_PENILAIAN, C.HASIL_TEMUAN, C.HASIL_TEMUAN_LAIN, C.CATATAN_HASIL_PEMERIKSAAN, B.HASIL, B.HASIL_PUSAT, C.KASUS_POINT_A, C.KASUS_POINT_B, C.KASUS_POINT_C, C.KASUS_POINT_D, C.KASUS_POINT_E, C.KASUS_POINT_F, C.KASUS_POINT_G, C.KASUS_POINT_H, C.KLASIFIKASI_PELANGGARAN_MAJOR AS MAJOR, C.KLASIFIKASI_PELANGGARAN_MINOR AS MINOR, C.KLASIFIKASI_PELANGGARAN_CRITICAL AS CRITICAL, KLASIFIKASI_PELANGGARAN_CRITICAL_ABSOLUTE AS CRITICAL_ABSOLUT, C.TINDAK_LANJUT_BALAI, C.DETAIL_TINDAK_LANJUT_BALAI, C.TINDAK_LANJUT_PUSAT, C.DETIL_TINDAK_LANJUT_PUSAT,C.LAMPIRAN_MAPPING, C.LAMPIRAN_BAP, STUFF(dbo.GROUP_CONCAT(B.PERIKSA_ID),1,1,'') AS SURAT_ID, E.KATEGORI, E.NAMA_PRODUK, E.NAMA_PABRIK, E.NEGARA_ASAL, E.KEMASAN, E.NOMOR_REGISTRASI, E.NO_BATCH, E.TANGGAL_EXPIRE, E.JUMLAH_TEMUAN, E.SATUAN, E.NAMA_PERUSAHAAN, E.ALAMAT_PERUSAHAAN, E.PEMILIK, E.TINDAKAN_PRODUK, E.KETERANGAN_SUMBER, E.HARGA_SATUAN, E.HARGA_TOTAL, E.HARGA_SATUAN, E.HARGA_TOTAL, D.URAIAN AS UR_HASIL, B.CREATE_BY FROM M_SARANA A LEFT JOIN T_PEMERIKSAAN B ON A.SARANA_ID = B.SARANA_ID LEFT JOIN T_PEMERIKSAAN_DISTRIBUSI C ON B.PERIKSA_ID = C.PERIKSA_ID LEFT JOIN T_PEMERIKSAAN_TEMUAN_PRODUK E ON B.PERIKSA_ID = E.PERIKSA_ID LEFT JOIN M_TABEL D ON B.HASIL = D.KODE WHERE B.SARANA_ID='$sarana' AND B.PERIKSA_ID='$idperiksa[0]' AND D.JENIS='HASIL'";
			$data = $sipt->main->get_result($query);
			if($data){
				foreach($query->result_array() as $row){
					$temuan_produk[] = $row;
					$arrdata = array('sess' => $row,
									 'temuan_produk' => $temuan_produk);
				}
				$arrdata['SURAT_ID'] = $row['SURAT_ID'];
				$arrdata['BBPOM_ID'] = $row['BBPOM_ID'];
				$aspek = explode("#", $row['ASPEK_PENILAIAN']);
				$inisal = array("Y", "T");
				$ganti = array("Ya", "Tidak");
				$arrdata['aspek_penilaian'] = str_replace($inisal, $ganti, $aspek); 			  
				$arrdata['tindak_lanjut_balai'] = explode("#", $row['TINDAK_LANJUT_BALAI']);
				$arrdata['tindak_lanjut_pusat'] = explode("#", $row['TINDAK_LANJUT_PUSAT']);					  
				$arrdata['cb_tindakan'] = $sipt->main->referensi("TL_DISTRIBUSI","",TRUE,FALSE);
			}
			if(array_key_exists('2', $this->newsession->userdata('SESS_KODE_ROLE'))){#Operator
				  if($this->newsession->userdata('SESS_BBPOM_ID') != "92"){
					  $isEditTLBalai = FALSE;
					  $isEditTLPusat = FALSE;
					  $arrdata['obj_distribusi'] = 'PEMERIKSAAN_DISTRIBUSI';
					  if(strlen($row['TINDAK_LANJUT_PUSAT']) == "0"){
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
					  $arrdata['obj_distribusi'] = 'PEMERIKSAAN_DISTRIBUSI_PUSAT';
					  $arrdata['obj_hasil'] = 'OPERATOR[HASIL_PUSAT]';
					  $isPerbaikan = TRUE;
					  $urlPerbaikan = site_url().'/get/pemeriksaan/get_perbaikan/'.$sarana.'/'.$jenis.'/'.$idperiksa[0].'/'.$subid;					
				  }
				  $arrdata['act'] = site_url().'/post/pemeriksaan/set_proses/02MM/operator';
				  $arrdata['obj_status'] = 'OPERATOR[STATUS]';
			  }else if(array_key_exists('3', $this->newsession->userdata('SESS_KODE_ROLE'))){#Supervisor Satu
				if($this->newsession->userdata('SESS_BBPOM_ID') != "92"){
					  $arrdata['obj_distribusi'] = 'PEMERIKSAAN_DISTRIBUSI';
					  $isEditTLBalai = TRUE;
					  $isEditTLPusat = FALSE;
					  if(strlen($row['TINDAK_LANJUT_PUSAT']) == "0"){
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
					  $arrdata['obj_distribusi'] = 'PEMERIKSAAN_DISTRIBUSI_PUSAT';
					  $arrdata['obj_hasil'] = 'SUPERVISOR[HASIL_PUSAT]';
				}
				$arrdata['act'] = site_url().'/post/pemeriksaan/set_proses/02MM/spv-satu';
				$arrdata['obj_status'] = 'SUPERVISOR[STATUS]';
			}else if(array_key_exists('4', $this->newsession->userdata('SESS_KODE_ROLE'))){#Supervisor Lanjutan
				if($this->newsession->userdata('SESS_BBPOM_ID') != "92"){
					  $isEditTLBalai = TRUE;
					  $isEditTLPusat = FALSE;
					  $arrdata['obj_distribusi'] = 'PEMERIKSAAN_DISTRIBUSI';
					  $arrdata['obj_hasil'] = 'SUPERVISOR[HASIL_PUSAT]';
					  if(strlen($row['TINDAK_LANJUT_PUSAT']) == "0"){
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
					  $arrdata['obj_distribusi'] = 'PEMERIKSAAN_DISTRIBUSI_PUSAT';
					  $isPerbaikan = TRUE;
				}
				$arrdata['obj_status'] = 'SUPERVISOR[STATUS]';
				$arrdata['act'] = site_url().'/post/pemeriksaan/set_proses/02MM/spv-dua';
			}else if(array_key_exists('5', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('6', $this->newsession->userdata('SESS_KODE_ROLE'))){
				$isEditTLBalai = FALSE;
				$isEditTLPusat = FALSE;
				$isPerbaikan = FALSE;
				$arrdata['obj_status'] = 'VERIFIKASI[STATUS]';
				$arrdata['act'] = site_url().'/post/pemeriksaan/set_proses/02MM/56';
			}
			if($subid!=""){
				$isPerbaikan = FALSE;
				$isEditTLBalai = FALSE;
				$isEditTLPusat = FALSE;
				$isverifikasi = FALSE;
			}else{
				$isverifikasi = TRUE;
			}
			
			$arrdata['hasil'] = $sipt->main->referensi("HASIL","'TMK','MK'",FALSE,TRUE);
			$arrdata['headersarana'] =$sipt->main->get_judul($jenis);
            $arrdata['status'] = $sipt->main->set_verifikasi($stat, $this->newsession->userdata('SESS_JENIS_PELAPORAN'), $this->newsession->userdata('SESS_KODE_ROLE'));
            $arrdata['disverifikasi'] = $stat;
			$arrdata['isPerbaikan'] = $isPerbaikan;
			$arrdata['isEditTLBalai'] = $isEditTLBalai;
			$arrdata['isEditTLPusat'] = $isEditTLPusat;
			$arrdata['isverifikasi'] = $isverifikasi;
			$arrdata['urlback'] = site_url().'/home/pelaporan/pemeriksaan/view';
			$arrdata['histori_petugas'] = site_url().'/load/petugas/get_petugas/'.$arrdata['SURAT_ID'];
			$arrdata['histori_perbaikan'] = site_url().'/get/pemeriksaan/set_perbaikan/'.$idperiksa[0].'/'.$jenis;
			$arrdata['urlPerbaikan'] = $urlPerbaikan;
			$arrdata['log'] = site_url().'/get/pemeriksaan/get_log/'.$idperiksa[0];
			$arrdata['redir'] = substr($jenis,0,2)."/".$idperiksa[1];
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
					  if($this->newsession->userdata('SESS_BBPOM_ID') == "92"){
						  $arr_input = $this->input->post('PEMERIKSAAN_DISTRIBUSI_PUSAT'); 
						  foreach($arr_input as $c => $d){
							  if(!is_array($d))
								  $arr_update[$c] = $d;
							  else
								  $arr_update[$c] = join("#", $d);		
						  }
						  $this->db->where(array("PERIKSA_ID" => $this->input->post('PERIKSA_ID')));
						  $this->db->update('T_PEMERIKSAAN_DISTRIBUSI', $arr_update); #Update Tindak Lanjut Pusat
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
						  $perbaikan = (int)$sipt->main->get_uraian("SELECT MAX(SERI) AS MAXID FROM T_PEMERIKSAAN_DISTRIBUSI_PERBAIKAN WHERE PERIKSA_ID = '".$this->input->post('PERIKSA_ID')."'", "MAXID") + 1;
						  $arr_perbaikan = array('PERIKSA_ID' => $this->input->post('PERIKSA_ID'),
												 'SERI' => $perbaikan,
												 'CREATE_BY' => $this->newsession->userdata('SESS_USER_ID'),
												 'CREATE_DATE' => 'GETDATE()');
						  foreach($this->input->post('PERBAIKAN') as $x => $z){
							  $arr_perbaikan[$x] = $z;
						  }
						  if(trim($arr_perbaikan['TANGGAL_PERBAIKAN']) != "" || trim($arr_perbaikan['DETAIL_PERBAIKAN']) != ""){
							  $this->db->insert('T_PEMERIKSAAN_DISTRIBUSI_PERBAIKAN', $arr_perbaikan);#Perbaikan Pemeriksaan					  
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
					 if($this->newsession->userdata('SESS_BBPOM_ID') == "92"){
						  $arr_input = $this->input->post('PEMERIKSAAN_DISTRIBUSI_PUSAT'); 
						  foreach($arr_input as $c => $d){
							  if(!is_array($d))
								  $arr_update[$c] = $d;
							  else
								  $arr_update[$c] = join("#", $d);
						  }
						  $this->db->where(array("PERIKSA_ID" => $this->input->post('PERIKSA_ID')));
						  $this->db->update('T_PEMERIKSAAN_DISTRIBUSI', $arr_update); 
					 }
					 $seri = (int)$sipt->main->get_uraian("SELECT MAX(SERI) AS MAXID FROM T_PEMERIKSAAN_PROSES WHERE PERIKSA_ID = '".$this->input->post('PERIKSA_ID')."'", "MAXID") + 1;
					  $arr_proses = array('PERIKSA_ID' => $this->input->post('PERIKSA_ID'),
										  'SERI' => $seri,
										  'HASIL' => $status,
										  'CATATAN' => $this->input->post('catatan'),
										  'CREATE_BY' => $this->newsession->userdata('SESS_USER_ID'),
										  'CREATE_DATE' => 'GETDATE()');
					  $this->db->insert('T_PEMERIKSAAN_PROSES', $arr_proses);
					  if($this->input->post('PERBAIKAN')){
						  $perbaikan = (int)$sipt->main->get_uraian("SELECT MAX(SERI) AS MAXID FROM T_PEMERIKSAAN_DISTRIBUSI_PERBAIKAN WHERE PERIKSA_ID = '".$this->input->post('PERIKSA_ID')."'", "MAXID") + 1;
						  $arr_perbaikan = array('PERIKSA_ID' => $this->input->post('PERIKSA_ID'),
												 'SERI' => $perbaikan,
												 'CREATE_BY' => $this->newsession->userdata('SESS_USER_ID'),
												 'CREATE_DATE' => 'GETDATE()');
						  foreach($this->input->post('PERBAIKAN') as $x => $z){
							  $arr_perbaikan[$x] = $z;
						  }
						  if(trim($arr_perbaikan['TANGGAL_PERBAIKAN']) != "" || trim($arr_perbaikan['DETAIL_PERBAIKAN']) != ""){
							  $this->db->insert('T_PEMERIKSAAN_DISTRIBUSI_PERBAIKAN', $arr_perbaikan);#Perbaikan Pemeriksaan					  
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
	
	
	function get_perbaikan($periksa_id){
		$query = "SELECT A.SARANA_ID, B.SERI AS NO, CONVERT(VARCHAR(10), B.TANGGAL_PERBAIKAN, 103) AS [TANGGAL PERBAIKAN], B.DETAIL_PERBAIKAN AS [DETAIL PERBAIKAN], '<a class=\"normal\" href=\"".base_url()."files/' + CAST(A.SARANA_ID AS VARCHAR)+ '/'+ B.FILE_PERBAIKAN +'\" target=\"_blank\">View</a>' AS [FILE PERBAIKAN], C.NAMA_BBPOM AS [BALAI ATAU UNIT], D.NAMA_USER AS [NAMA PETUGAS] FROM T_PEMERIKSAAN A LEFT JOIN T_PEMERIKSAAN_DISTRIBUSI_PERBAIKAN B ON A.PERIKSA_ID = B.PERIKSA_ID LEFT JOIN T_USER D ON B.CREATE_BY = D.USER_ID LEFT JOIN M_BBPOM C ON D.BBPOM_ID = C.BBPOM_ID WHERE B.PERIKSA_ID='$periksa_id'";
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
	
	
	function set_perbaikan($periksa_id){
		$sipt =& get_instance();
		$this->load->model("main","main", true);
		$query = "SELECT A.SARANA_ID, CONVERT(VARCHAR(10), A.TANGGAL_PERBAIKAN, 105) AS TANGGAL_PERBAIKAN, A.DETAIL_PERBAIKAN, A.FILE_PERBAIKAN, B.NAMA_USER, C.NAMA_BBPOM FROM T_PERBAIKAN A LEFT JOIN T_USER B ON A.CREATE_BY = B.USER_ID LEFT JOIN M_BBPOM C ON A.BBPOM_ID = C.BBPOM_ID WHERE A.PERIKSA_ID = '$periksa_id'";
		$dt_tindakan = $sipt->main->get_result($query);
		if($dt_tindakan){
			foreach($query->result_array() as $row){
				$arrdata = array('sess' => $row);
			}
		}
		return $arrdata;

	}
	
	function get_reupload($periksa, $jenis){
		$sipt =& get_instance();
		$this->load->model("main","main", true);
		$query = "SELECT A.CREATE_BY, (CAST(A.SARANA_ID AS VARCHAR) + '/' + A.JENIS_SARANA_ID + '/' + STUFF(dbo.GROUP_KLASIFIKASI(A.PERIKSA_ID),1,1,'') + '/' + CAST(A.PERIKSA_ID AS VARCHAR) + '.' + A.STATUS) AS IDPERIKSA, A.PERIKSA_ID, A.SARANA_ID, A.STATUS, CONVERT(VARCHAR(10), A.AWAL_PERIKSA, 103) AS [AWAL_PERIKSA], CONVERT(VARCHAR(10), A.AKHIR_PERIKSA, 103) AS [AKHIR_PERIKSA], B.TUJUAN_PEMERIKSAAN, B.HASIL_TEMUAN, B.CATATAN_HASIL_PEMERIKSAAN, B.KASUS_POINT_A, B.KASUS_POINT_B, B.KASUS_POINT_C, B.KASUS_POINT_D, B.KASUS_POINT_E, B.KASUS_POINT_F, B.KASUS_POINT_G, B.KASUS_POINT_H, B.KLASIFIKASI_PELANGGARAN_MAJOR AS MAJOR, B.KLASIFIKASI_PELANGGARAN_MINOR AS MINOR, B.KLASIFIKASI_PELANGGARAN_CRITICAL AS CRITICAL, B.KLASIFIKASI_PELANGGARAN_CRITICAL_ABSOLUTE AS CA, B.LAMPIRAN_MAPPING, B.LAMPIRAN_BAP, STUFF(dbo.GROUP_CONCAT(A.PERIKSA_ID),1,1,'') AS SURAT_ID, C.URAIAN, X.NAMA_SARANA FROM T_PEMERIKSAAN A LEFT JOIN T_PEMERIKSAAN_DISTRIBUSI B ON A.PERIKSA_ID = B.PERIKSA_ID LEFT JOIN M_TABEL C ON A.HASIL = C.KODE LEFT JOIN M_SARANA X ON A.SARANA_ID = X.SARANA_ID WHERE A.PERIKSA_ID = '".$periksa."' AND C.JENIS = 'HASIL'";
		$data = $sipt->main->get_result($query);
		if($data){
			foreach($query->result_array() as $row){
				$arrdata = array('sess' => $row);
			}
			$arrdata['act'] = site_url().'/post/pemeriksaan/set_periksa/02MM/reupload-mapping';
		}
		return $arrdata;
	}
	
	function prev_surat_tl($periksa){
		if($this->newsession->userdata('LOGGED_IN') == TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$arrstatus = '93';
			$periksa = explode(".",$periksa);
			if($periksa[1] != $arrstatus)
				$ispdf = FALSE;
			else
				$ispdf = TRUE;
			$query = "SELECT A.NAMA_SARANA, A.ALAMAT_1, A.KEGIATAN_SARANA, STUFF(dbo.ASAL_BBPOM(B.BBPOM_ID),1,0,'') AS BBPOM, C.HASIL_TEMUAN, C.TINDAK_LANJUT_BALAI, C.TINDAK_LANJUT_PUSAT, D.NOMOR_SURAT AS [SURAT TL], CONVERT(VARCHAR, D.TANGGAL_SURAT, 105) AS [TANGGAL TL], D.PERIHAL, D.TEMPAT_TTD AS TEMPAT, CAST(SUBSTRING(D.PEJABAT_TTD, 0, 9)+ ' ' +SUBSTRING(D.PEJABAT_TTD, 9, 6)+' '+SUBSTRING(D.PEJABAT_TTD, 15, 1)+' '+SUBSTRING(D.PEJABAT_TTD, 16, 3) AS VARCHAR) AS NIP, D.TEMBUSAN, D.AWAL_PSK, D.AKHIR_PSK, D.TINDAKAN, D.PIHAK, STUFF(dbo.ASAL_BBPOM(D.BBPOM_ID),1,0,'') AS BALAI, F.NAMA AS [NAMA TTD], F.JABATAN, E.NOMOR AS NOMOR, CONVERT(VARCHAR, E.TANGGAL, 105) AS TANGGAL, Z.URAIAN AS [PERIHAL SURAT], D.LAMPIRAN FROM M_SARANA A LEFT JOIN T_PEMERIKSAAN B ON A.SARANA_ID = B.SARANA_ID LEFT JOIN T_PEMERIKSAAN_DISTRIBUSI C ON B.PERIKSA_ID = C.PERIKSA_ID LEFT JOIN T_SURAT_TINDAK_LANJUT D ON C.PERIKSA_ID = D.PERIKSA_ID LEFT JOIN T_SURAT_TUGAS_PELAPORAN G ON B.PERIKSA_ID = G.LAPOR_ID LEFT JOIN T_SURAT_TUGAS E ON G.SURAT_ID = E.SURAT_ID LEFT JOIN M_PEJABAT F ON D.PEJABAT_TTD = F.NIP LEFT JOIN M_TABEL Z ON D.PERIHAL = Z.KODE WHERE B.PERIKSA_ID = '$periksa[0]' AND Z.JENIS = 'JENIS_SURAT'";
			$data = $sipt->main->get_result($query);
			$bulan = $this->config->config;
			$bulan = $bulan['bulan'];		
			if($data){
				foreach($query->result_array() as $row){
					$tgl = explode('-', $row['TANGGAL TL']);
					$tgla = (int)$tgl[1];
					$tgla = $bulan[$tgla];
					$row['TANGGAL TL'] = "$tgl[0] $tgla $tgl[2]";
					$tgl_ = explode('-', $row['TANGGAL']);
					$tglb = (int)$tgl_[1];
					$tglb = $bulan[$tglb];
					$row['TANGGAL'] = "$tgl_[0] $tglb $tgl_[2]";
					$arrdata = array('sess' => $row,
									 'ispdf' => $ispdf);
				}
			}else{
				$arrdata = array('');
			}
			if($ispdf == FALSE){
				$ret = $this->load->view('pemeriksaan/tl/distribusi/'.$row['PERIHAL'], $arrdata, true);
			}else{
				$this->load->library('mpdf');
				$mpdf=new mPDF('win-1252',array(210,330));
				$mpdf->useOnlyCoreFonts = true;
				$mpdf->SetProtection(array('print'));
				$mpdf->SetAuthor("Bidang TI PIOM");
				$mpdf->SetDisplayMode('fullpage','two');
				$html = $this->load->view('pemeriksaan/tl/distribusi/'.$row['PERIHAL'], $arrdata, true);
				$ret = $this->mpdf->WriteHTML($html);
				$ret = $this->mpdf->Output();
			}
			echo $ret;
		}
	}


}

?>