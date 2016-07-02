<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);


class F02KO extends Model{
	
	function GetForm02KO($sarana, $jenis, $klasifikasi, $idperiksa){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			if(!array_key_exists($jenis, $this->newsession->userdata("SESS_SARANA")) && !array_key_exists($klasifikasi, $this->newsession->userdata("SESS_KLASIFIKASI_ID"))) return $this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
			$sipt =& get_instance();
			$sipt->load->model("main", "main", true);			
			if($idperiksa==""){#Input Mode				  
				 if(!$this->session->userdata('SURAT')) return $this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
$qsarana = "SELECT SARANA_ID, NAMA_SARANA, ALAMAT_1, ALAMAT_2, TELEPON, NAMA_PIMPINAN, PENANGGUNG_JAWAB FROM M_SARANA WHERE SARANA_ID = '$sarana'";
				  $dt_sarana = $sipt->main->get_result($qsarana);
				  if($dt_sarana){
					  foreach($qsarana->result_array() as $row){
						  $arrdata = array('sess' => $row,
						  				   'sel_hasil' => 'MK',
						  				   'sel_tindakan_sarana' => '',
										   'sel_detil_hasil' => '',		
										   'sel_tmk' => '',					
										   'SURAT_ID' => '',								
										   'BBPOM_ID' => $this->newsession->userdata('SESS_BBPOM_ID'),
										   'temuan_produk' => array(),
										   'aspek_check' => '',
										   'aspek_keterangan' => '',
										   'PERIKSA_ID' => '',
										   'act' => site_url().'/post/pemeriksaan/set_periksa/02KO/simpan',
										   'urlback' => site_url().'/home/pelaporan/pemeriksaan');
					  }
				  }				
			}else{#Edit Mode
				$idperiksa = explode(".", $idperiksa);
				$status = $idperiksa[1];
				$qperiksa = "SELECT (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN_TEMUAN_PRODUK WHERE PERIKSA_ID='$idperiksa[0]') AS JMLTEMUAN, A.SARANA_ID, A.NAMA_SARANA, A.ALAMAT_1, A.ALAMAT_2, A.TELEPON, A.NAMA_PIMPINAN, A.PENANGGUNG_JAWAB, B.PERIKSA_ID, B.JENIS_SARANA_ID, B.BBPOM_ID, STUFF(dbo.GROUP_KLASIFIKASI(B.PERIKSA_ID),1,1,'') AS KK_ID, CONVERT(VARCHAR(10), B.AWAL_PERIKSA, 103) AS AWAL_PERIKSA, CONVERT(VARCHAR(10), B.AKHIR_PERIKSA, 103) AS AKHIR_PERIKSA, C.TUJUAN_PEMERIKSAAN, C.KLASIFIKASI_PEMERIKSAAN, C.ASPEK_CHECK, C.ASPEK_KETERANGAN, C.HASIL_TEMUAN_LAIN, C.PEMANTAUAN_HASIL, C.HASIL_DIP_A, C.HASIL_DIP_B, C.HASIL_DIP_C, C.HASIL_DIP_D, B.HASIL, C.CATATAN, C.DETIL_HASIL, C.KESIMPULAN_DETIL_TMK, C.TINDAKAN_SARANA, C.SARAN_TL, D.NAMA_PRODUK, D.KLASIFIKASI_PRODUK, D.NOMOR_REGISTRASI, D.NO_BATCH, D.NETTO, D.TANGGAL_EXPIRE, D.NAMA_PERUSAHAAN, D.ALAMAT_PERUSAHAAN, D.JENIS_PELANGGARAN, D.KATEGORI, D.JUMLAH_TEMUAN, D.HARGA_SATUAN, D.SATUAN, (D.JUMLAH_TEMUAN * D.HARGA_SATUAN)AS HARGA_TOTAL, D.TINDAKAN_PRODUK, D.KETERANGAN_SUMBER, STUFF(dbo.GROUP_CONCAT(B.PERIKSA_ID),1,1,'') AS SURAT_ID FROM M_SARANA A LEFT JOIN T_PEMERIKSAAN B ON A.SARANA_ID = B.SARANA_ID LEFT JOIN T_PEMERIKSAAN_KOSMETIK C ON B.PERIKSA_ID = C.PERIKSA_ID LEFT JOIN T_PEMERIKSAAN_TEMUAN_PRODUK D ON B.PERIKSA_ID = D.PERIKSA_ID WHERE B.SARANA_ID = '$sarana' AND B.PERIKSA_ID = '$idperiksa[0]'";
				  $dt_periksa = $sipt->main->get_result($qperiksa);
				  if($dt_periksa){
					  foreach($qperiksa->result_array() as $row){
						  $temuan_produk[] = $row;
						  $arrdata = array('sess' => $row,
										 'temuan_produk' => $temuan_produk,
										 'sel_hasil' => $row['HASIL'],
										 'urlback' => site_url().'/home/pelaporan/pemeriksaan/view/'.$status);
					  }
					  $arrdata['SURAT_ID'] = $row['SURAT_ID'];
					  $arrdata['BBPOM_ID'] = $row['BBPOM_ID'];
					  $arrdata['PERIKSA_ID'] = $row['PERIKSA_ID'];
					  $aspek_check = explode("#", $row['ASPEK_CHECK']);
					  array_shift($aspek_check);
					  //$arrdata['aspek_check'] = explode("#", $row['ASPEK_CHECK']);
					  $arrdata['aspek_check'] = $aspek_check;
					  //$shift = explode("#", $row['ASPEK_KETERANGAN']);
					  //if($row['KLASIFIKASI_PEMERIKSAAN']!='Importir Kosmetika') { array_shift($shift); }
					  $aspek_keterangan = explode("#", $row['ASPEK_KETERANGAN']);
					  array_shift($aspek_keterangan);
					  $arrdata['aspek_keterangan'] = $aspek_keterangan;
					  $arrdata['sel_tindakan_sarana'] = explode("#", $row['TINDAKAN_SARANA']);
					  $arrdata['sel_tmk']= explode("#", $row['DETIL_HASIL']);
					  $arrdata['sel_detil_hasil'] = explode("#", $row['KESIMPULAN_DETIL_TMK']);
				  }
				  if($this->newsession->userdata('SESS_BBPOM_ID') != "94"){#Update dan Perbaikan Balai
					  if($status=="20101"){
						  $arrdata['act'] = site_url().'/post/pemeriksaan/set_periksa/02KO/update';
					  }else if($status=="20102" || $status =="20103"){
						  $arrdata['act'] = site_url().'/post/pemeriksaan/set_periksa/02KO/perbaikan';
					  }else if($status =="60020"){
						  $arrdata['act'] = site_url().'/post/pemeriksaan/set_periksa/02KO/rekomendasi';
					  }
				  }else{#Update dan Perbaikan Pusat
					  if($status=="20111"){
						  $arrdata['act'] = site_url().'/post/pemeriksaan/set_periksa/02KO/update';
					  }else if($status =="20113" || $status =="20112"){
						  $arrdata['act'] = site_url().'/post/pemeriksaan/set_periksa/02KO/perbaikan';
					  }else if($status =="60020"){
						  $arrdata['act'] = site_url().'/post/pemeriksaan/set_periksa/02KO/rekomendasi';
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
			$arrdata['headersarana'] = $sipt->main->get_judul($jenis);
			$arrdata['sarana_id'] = $sarana;
			$arrdata['jenis_sarana_id'] = $jenis;
			$arrdata['klasifikasi'] = $klasifikasi;
			$arrdata['jenis_sarana'] = $sipt->main->get_jenis_sarana($this->newsession->userdata("SESS_USER_ID"), $disinput);
			$arrdata['klasifikasi_kategori'] = $sipt->main->get_klasifikasi();
			$arrdata['disinput'] = array("JENISDIS","NAMADIS");
			$arrdata['tujuan_pemeriksaan'] = $sipt->main->referensi("TUJUAN_PEMERIKSAAN", "'1','2','25','26','27','28','99'",TRUE,TRUE);
			$arrdata['klasifikasi_distribusi'] = $sipt->main->referensi("KD_KOS","",TRUE,TRUE);
			$arrdata['pilihan'] = array("Y" => "Ya", "T" => "Tidak");
			$arrdata['klasifikasi_temuan'] = $sipt->main->referensi("KLASIFIKASI_TEMUAN","'01','02'",TRUE,TRUE);
			$arrdata['kategori_temuan'] = $sipt->main->referensi("KATEGORI_TEMUAN","'01','07','08','03','06'",TRUE,TRUE);
			$arrdata['hasil'] = $sipt->main->referensi("HASIL","'TMK','MK','TTP'",FALSE,TRUE);
			$arrdata['tindak_lanjut_temuan'] = $sipt->main->referensi("TL_PRODUK_TEMUAN","'01','02','03','04'",TRUE,TRUE);
			$arrdata['detil_hasil'] = $sipt->main->referensi("DTL_HASIL_TMK","",TRUE,FALSE);
			
			if($this->newsession->userdata('SESS_BBPOM_ID') != '94')
				  $arrdata['tindakan_sarana'] = $sipt->main->referensi("TSARANA_KOS","'00','01','02','03','04','05','07','08'",TRUE,FALSE);
			else
				  $arrdata['tindakan_sarana'] = $sipt->main->referensi("TSARANA_KOS","",TRUE,FALSE);
				  
			$arrdata['histori_petugas'] = site_url().'/load/petugas/get_petugas/'.$arrdata['SURAT_ID'];
			$arrdata['url_izin'] = site_url().'/get/distribusi/set_izin/'.$jenis.'/'.$sarana;
			return $arrdata;
		}
		else
		{
			$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
		}
	}
	
	function SaveForm02KO($action, $isajax){
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
				/* print_r($_POST);
				die(); */
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
					foreach($this->input->post('PEMERIKSAAN_DIST_KOS') as $c => $d){
						if(!is_array($d))
							$arr_distribusi[$c] = $d;
						else
							$arr_distribusi[$c] = join("#", $d);
					}
					$this->db->insert('T_PEMERIKSAAN_KOSMETIK', $arr_distribusi);
					
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
											'KK_ID' => '012');
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
			}else if($action=="update" || $action=="perbaikan" || $action == "rekomendasi"){#Update Mode
				//print_r($_POST); die();
				$arr_pemeriksaan = array('UPDATE_BY' => $this->newsession->userdata('SESS_USER_ID'),'LAST_UPDATE' => 'GETDATE()');
				foreach($this->input->post('PEMERIKSAAN') as $a => $b){
				  $arr_pemeriksaan[$a] = $b;
				}
				if($action=="perbaikan" || $action=="rekomendasi"){
					if($this->newsession->userdata('SESS_BBPOM_ID') != "94"){
					  $arr_pemeriksaan['STATUS'] = '30104';
					  $status = "30104";
					}else{
					  $arr_pemeriksaan['STATUS'] = '30114';
					  $status = "30114";
					}
				}		
				$this->db->where(array("PERIKSA_ID" => $this->input->post('PERIKSA_ID')));	
				if($this->db->update('T_PEMERIKSAAN', $arr_pemeriksaan)){	
					foreach($this->input->post('PEMERIKSAAN_DIST_KOS') as $c => $d){
						if(!is_array($d))
							$arr_distribusi[$c] = $d;
						else
							$arr_distribusi[$c] = join("#", $d);
					}
					$this->db->where(array("PERIKSA_ID" => $this->input->post('PERIKSA_ID')));
					$this->db->update('T_PEMERIKSAAN_KOSMETIK', $arr_distribusi);
					
					if($this->input->post('TEMUAN_PRODUK')){
						$this->db->where('PERIKSA_ID', $this->input->post('PERIKSA_ID'));
						$this->db->delete('T_PEMERIKSAAN_TEMUAN_PRODUK');
						$arrtemuan = $this->input->post('TEMUAN_PRODUK');
						$arrkeys = array_keys($arrtemuan);
						for($i=0;$i<count($arrtemuan[$arrkeys[0]]);$i++){
							$seri = (int)$sipt->main->get_uraian("SELECT MAX(SERI) AS MAXID FROM T_PEMERIKSAAN_TEMUAN_PRODUK WHERE PERIKSA_ID = '".$this->input->post('PERIKSA_ID')."'", "MAXID") + 1;
							$temuan = array('PERIKSA_ID' => $this->input->post('PERIKSA_ID'),
											'SERI' => $seri,
											'KK_ID' => '012');
							for($j=0;$j<count($arrkeys);$j++){
								$temuan[$arrkeys[$j]] = $arrtemuan[$arrkeys[$j]][$i];
							}
							$this->db->insert('T_PEMERIKSAAN_TEMUAN_PRODUK', $temuan);
						}
					}
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
					}else if($action=="perbaikan" || $action=="rekomendasi"){
						$ret = "MSG#YES#Data berhasil disimpan#".site_url()."/home/pelaporan/pemeriksaan/view/all/send";
					}
				}
				return $ret;
			}
		}else{
			$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');		  
		}
	}	
	
	function get_preview($sarana,$id, $jenis){
		$sipt =& get_instance();
		$this->load->model("main","main", true);
		$id = explode(".", $id);
		$query = "SELECT (CAST(A.SARANA_ID AS VARCHAR) + '/' + A.JENIS_SARANA_ID + '/' + STUFF(dbo.GROUP_KLASIFIKASI(A.PERIKSA_ID),1,1,'') + '/' + CAST(A.PERIKSA_ID AS VARCHAR) + '.' + A.STATUS) AS IDPERIKSA, A.PERIKSA_ID, A.SARANA_ID, A.STATUS, CONVERT(VARCHAR(10), A.AWAL_PERIKSA, 103) AS [AWAL_PERIKSA], CONVERT(VARCHAR(10), A.AKHIR_PERIKSA, 103) AS [AKHIR_PERIKSA], B.TUJUAN_PEMERIKSAAN, B.KLASIFIKASI_PEMERIKSAAN, A.HASIL, B.CATATAN,B.DETIL_HASIL, B.KESIMPULAN_DETIL_TMK, B.TINDAKAN_SARANA, STUFF(dbo.GROUP_CONCAT(A.PERIKSA_ID),1,1,'') AS SURAT_ID FROM T_PEMERIKSAAN A LEFT JOIN T_PEMERIKSAAN_KOSMETIK B ON A.PERIKSA_ID = B.PERIKSA_ID WHERE A.SARANA_ID = '$sarana' AND A.PERIKSA_ID = '$id[0]'";
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
			$judul = $sipt->main->get_judul($jenis);
			$query = "SELECT (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN_TEMUAN_PRODUK WHERE PERIKSA_ID='$idperiksa[0]') AS JMLTEMUAN,(SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN_PROSES WHERE PERIKSA_ID='$idperiksa[0]') AS JML_PROSES, A.SARANA_ID, A.NAMA_SARANA, A.ALAMAT_1, A.ALAMAT_2, A.TELEPON, A.NAMA_PIMPINAN, A.PENANGGUNG_JAWAB, B.PERIKSA_ID, B.JENIS_SARANA_ID, B.BBPOM_ID, STUFF(dbo.GROUP_KLASIFIKASI(B.PERIKSA_ID),1,1,'') AS KK_ID, CONVERT(VARCHAR(10), B.AWAL_PERIKSA, 103) AS AWAL_PERIKSA, CONVERT(VARCHAR(10), B.AKHIR_PERIKSA, 103) AS AKHIR_PERIKSA, C.TUJUAN_PEMERIKSAAN, C.KLASIFIKASI_PEMERIKSAAN, C.ASPEK_CHECK, C.ASPEK_KETERANGAN, C.HASIL_TEMUAN_LAIN, C.PEMANTAUAN_HASIL, C.HASIL_DIP_A, C.HASIL_DIP_B, C.HASIL_DIP_C, C.HASIL_DIP_D, B.HASIL, C.CATATAN, C.DETIL_HASIL, C.KESIMPULAN_DETIL_TMK, C.TINDAKAN_SARANA, C.SARAN_TL, C.HASIL_PUSAT, C.TINDAKAN_PUSAT, C.CATATAN_PUSAT, D.NAMA_PRODUK, D.KLASIFIKASI_PRODUK, D.NOMOR_REGISTRASI, D.NO_BATCH, D.NETTO, D.TANGGAL_EXPIRE, D.NAMA_PERUSAHAAN, D.ALAMAT_PERUSAHAAN, D.JENIS_PELANGGARAN, D.KATEGORI, D.JUMLAH_TEMUAN, D.SATUAN, D.HARGA_SATUAN, (D.JUMLAH_TEMUAN * D.HARGA_SATUAN)AS HARGA_TOTAL, D.TINDAKAN_PRODUK, D.KETERANGAN_SUMBER, STUFF(dbo.GROUP_CONCAT(B.PERIKSA_ID),1,1,'') AS SURAT_ID FROM M_SARANA A LEFT JOIN T_PEMERIKSAAN B ON A.SARANA_ID = B.SARANA_ID LEFT JOIN T_PEMERIKSAAN_KOSMETIK C ON B.PERIKSA_ID = C.PERIKSA_ID LEFT JOIN T_PEMERIKSAAN_TEMUAN_PRODUK D ON B.PERIKSA_ID = D.PERIKSA_ID WHERE B.SARANA_ID = '$sarana' AND B.PERIKSA_ID = '$idperiksa[0]'";
			$data = $sipt->main->get_result($query);
			if($data){
					foreach($query->result_array() as $row){
						$temuan_produk[] = $row;
						$arrdata = array('sess' => $row,
										 'temuan_produk' => $temuan_produk,
										 'urlback' => site_url().'/home/pelaporan/pemeriksaan/view');
					}
					$arrdata['SURAT_ID'] = $row['SURAT_ID'];
					$arrdata['BBPOM_ID'] = $row['BBPOM_ID'];
					$arrdata['PERIKSA_ID'] = $row['PERIKSA_ID'];
					$aspek = explode("#", $row['ASPEK_CHECK']);
					array_shift($aspek);
					$inisal = array("T", "Y");
					$ganti = array("Tidak", "Ya");
					$arrdata['aspek_check'] = str_replace($inisal, $ganti, $aspek);
					$aspek_keterangan = explode("#", $row['ASPEK_KETERANGAN']);
					array_shift($aspek_keterangan);
					$arrdata['aspek_keterangan'] = $aspek_keterangan;
					$arrdata['sel_tindakan_sarana'] = explode("#", $row['TINDAKAN_SARANA']);
					$arrdata['sel_tmk']= explode("#", $row['DETIL_HASIL']);
					$arrdata['sel_detil_hasil'] = explode("#", $row['KESIMPULAN_DETIL_TMK']);
			}
			if(array_key_exists('2', $this->newsession->userdata('SESS_KODE_ROLE'))){#Operator
				  if($this->newsession->userdata('SESS_BBPOM_ID') != "94"){
					  $arrdata['obj_kos'] = 'PEMERIKSAAN_DIST_KOS';
				  }else{
					   $arrdata['obj_kos'] = 'PEMERIKSAAN_DIST_KOS_PUSAT';
				  }				  
				  $isEditTL = TRUE;
				  $isEditTLBalai = TRUE;
				  $arrdata['act'] = site_url().'/post/pemeriksaan/set_proses/02KO/operator';
				  $arrdata['obj_status'] = 'OPERATOR[STATUS]';
			  }else if(array_key_exists('3', $this->newsession->userdata('SESS_KODE_ROLE'))){#Supervisor Satu
				if($this->newsession->userdata('SESS_BBPOM_ID') != "94"){
					  $arrdata['obj_kos'] = 'PEMERIKSAAN_DIST_KOS';
					  $isEditTLBalai = TRUE;
					  $isEditTL = TRUE;
				}else{
					  if($this->newsession->userdata('SESS_BBPOM_ID') == $arrdata['BBPOM_ID']){
						  $isEditTLBalai = FALSE;
						  $isEditTL = FALSE;
					  }else{
						  $isEditTLBalai = TRUE;
						  $isEditTL = TRUE;
					  }
					  $arrdata['obj_kos'] = 'PEMERIKSAAN_DIST_KOS_PUSAT';
				}
				$arrdata['act'] = site_url().'/post/pemeriksaan/set_proses/02KO/spv-satu';
				$arrdata['obj_status'] = 'SUPERVISOR[STATUS]';
			}else if(array_key_exists('4', $this->newsession->userdata('SESS_KODE_ROLE'))){#Supervisor Lanjutan
				if($this->newsession->userdata('SESS_BBPOM_ID') != "94"){
					  $arrdata['obj_kos'] = 'PEMERIKSAAN_DIST_KOS';
					  $isEditTLBalai = TRUE;
					  $isEditTL = TRUE;
				}else{
					  if($this->newsession->userdata('SESS_BBPOM_ID') == $arrdata['BBPOM_ID']){
						  $isEditTLBalai = FALSE;
						  $isEditTL = FALSE;
					  }else{
						  $isEditTLBalai = TRUE;
						  $isEditTL = TRUE;
					  }
					  $arrdata['obj_kos'] = 'PEMERIKSAAN_DIST_KOS_PUSAT';
				}
				$arrdata['act'] = site_url().'/post/pemeriksaan/set_proses/02KO/spv-dua';
				$arrdata['obj_status'] = 'SUPERVISOR[STATUS]';
			}else if(array_key_exists('5', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('6', $this->newsession->userdata('SESS_KODE_ROLE'))){
			  $isEditTLBalai = TRUE;
			  $isEditTL = TRUE;
			  $arrdata['obj_status'] = 'VERIFIKASI[STATUS]';
			  $arrdata['act'] = site_url().'/post/pemeriksaan/set_proses/02KO/56';
			}
			
			if($subid!=""){
				$isEditTLBalai = TRUE;
				$isEditTL = TRUE;
				$isverifikasi = FALSE;
			}else{
				$isverifikasi = TRUE;
			}
			
			$arrdata['headersarana'] = $judul;			
			$arrdata['status'] = $sipt->main->set_verifikasi($stat, $this->newsession->userdata('SESS_JENIS_PELAPORAN'), $this->newsession->userdata('SESS_KODE_ROLE'));
			$arrdata['disverifikasi'] = $stat;
			$arrdata['hasil'] = $sipt->main->referensi("HASIL","'TMK','MK','TTP'",FALSE,TRUE);
			$arrdata['detil_hasil'] = $sipt->main->referensi("DTL_HASIL_TMK","",TRUE,FALSE);
			
			if($this->newsession->userdata('SESS_BBPOM_ID') != '94')
				  $arrdata['tindakan_sarana'] = $sipt->main->referensi("TSARANA_KOS","'01','02','03','04','05','07'",TRUE,FALSE);
			else
				  $arrdata['tindakan_sarana'] = $sipt->main->referensi("TSARANA_KOS","",TRUE,FALSE);
				  
			$arrdata['isEditTLBalai'] = $isEditTLBalai;
			$arrdata['isEditTL'] = $isEditTL;
			$arrdata['isverifikasi'] = $isverifikasi;
			$arrdata['histori_petugas'] = site_url().'/load/petugas/get_petugas/'.$arrdata['SURAT_ID'];
			$arrdata['url_izin'] = site_url().'/get/distribusi/set_izin/'.$jenis.'/'.$sarana;
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
					  if($this->newsession->userdata('SESS_BBPOM_ID') == "94"){
						  if($this->input->post('PEMERIKSAAN_DIST_KOS_PUSAT')){
							  $arr_input = $this->input->post('PEMERIKSAAN_DIST_KOS_PUSAT'); 
							  foreach($arr_input as $c => $d){
								  if(!is_array($d))
									  $arr_update[$c] = $d;
								  else
									  $arr_update[$c] = join("#", $d);		
							  }
							  $this->db->where(array("PERIKSA_ID" => $this->input->post('PERIKSA_ID')));
							  $this->db->update('T_PEMERIKSAAN_KOSMETIK', $arr_update); #Update Tindak Lanjut Pusat
						  }
					  }
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
					 if($this->newsession->userdata('SESS_BBPOM_ID') == "94"){
						  if($this->input->post('PEMERIKSAAN_DIST_KOS_PUSAT')){
							  $arr_input = $this->input->post('PEMERIKSAAN_DIST_KOS_PUSAT'); 
							  foreach($arr_input as $c => $d){
								  if(!is_array($d))
									  $arr_update[$c] = $d;
								  else
									  $arr_update[$c] = join("#", $d);		
							  }
							  $this->db->where(array("PERIKSA_ID" => $this->input->post('PERIKSA_ID')));
							  $this->db->update('T_PEMERIKSAAN_KOSMETIK', $arr_update); #Update Tindak Lanjut Pusat
						  }
					 }else{
						 if($this->input->post('PEMERIKSAAN_DIST_KOS')){
						 $arr_input = $this->input->post('PEMERIKSAAN_DIST_KOS'); 
						 foreach($arr_input as $c => $d){
							if(!is_array($d))
								$arr_update[$c] = $d;
							else
								$arr_update[$c] = join("#", $d);
						 }
						 $this->db->where(array("PERIKSA_ID" => $this->input->post('PERIKSA_ID')));
						 $this->db->update('T_PEMERIKSAAN_KOSMETIK', $arr_update); #Update Tindak Lanjut
						 }
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

			
	function get_izin($sarana){
		$query = "SELECT SERI, NOMOR_IZIN AS [NOMOR IZIN], JENIS_IZIN AS [JENIS IZIN], BENTUK_SEDIAAN AS [BENTUK SEDIAAN], JENIS_SEDIAAN AS [JENIS SEDIAAN], CONVERT(VARCHAR(10), TANGGAL_IZIN, 103) AS [TANGGAL DIKELUARKAN IZIN], CONVERT(VARCHAR(10), TANGGAL_EXPIRED, 103) AS [MASA BERLAKU IZIN] FROM M_SARANA_IZIN WHERE SARANA_ID = '$sarana'";
		$this->load->library('newtable');
		$this->newtable->hiddens(array('SERI'));
		$this->newtable->search(array(array('', '')));
		$this->newtable->action(site_url());
		$this->newtable->cidb($this->db);
		$this->newtable->ciuri($this->uri->segment_array());
		$this->newtable->orderby("SERI");
		$this->newtable->keys("SERI");
		$this->newtable->rowcount("ALL");
		$this->newtable->show_chk(FALSE);
		$this->newtable->show_search(FALSE);
		$tabel = $this->newtable->generate($query);
		return $tabel;	
	}

	function set_bap($sarana,$jenis,$idperiksa,$subid){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$sipt->load->model("main","main", true);
			$func =& get_instance();
			$func->load->model("functions","functions", true);
			$idperiksa = explode(".", $idperiksa);
			$query = "SELECT (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN_TEMUAN_PRODUK WHERE PERIKSA_ID='$idperiksa[0]') AS JUMLAH_TEMUAN,(SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN_PROSES WHERE PERIKSA_ID='$idperiksa[0]') AS JML_PROSES, A.SARANA_ID, A.NAMA_SARANA, A.ALAMAT_1, A.ALAMAT_2, A.TELEPON, A.NAMA_PIMPINAN, A.PENANGGUNG_JAWAB, B.PERIKSA_ID, B.JENIS_SARANA_ID, B.BBPOM_ID, STUFF(dbo.GROUP_KLASIFIKASI(B.PERIKSA_ID),1,1,'') AS KK_ID, CONVERT(VARCHAR(10), B.AWAL_PERIKSA, 103) AS AWAL_PERIKSA, CONVERT(VARCHAR(10), B.AKHIR_PERIKSA, 103) AS AKHIR_PERIKSA, C.TUJUAN_PEMERIKSAAN, C.KLASIFIKASI_PEMERIKSAAN, C.ASPEK_CHECK, C.ASPEK_KETERANGAN, C.HASIL_TEMUAN_LAIN, C.PEMANTAUAN_HASIL, C.HASIL_DIP_A, C.HASIL_DIP_B, C.HASIL_DIP_C, C.HASIL_DIP_D, B.HASIL, C.CATATAN, C.DETIL_HASIL, C.KESIMPULAN_DETIL_TMK, C.TINDAKAN_SARANA, D.NAMA_PRODUK, D.KLASIFIKASI_PRODUK, D.NOMOR_REGISTRASI, D.NO_BATCH, D.NETTO, D.TANGGAL_EXPIRE, D.NAMA_PERUSAHAAN, D.ALAMAT_PERUSAHAAN, D.JENIS_PELANGGARAN, D.KATEGORI, D.JUMLAH_TEMUAN, D.SATUAN, D.HARGA_SATUAN, (D.JUMLAH_TEMUAN * D.HARGA_SATUAN) AS HARGA_TOTAL, D.TINDAKAN_PRODUK, D.KETERANGAN_SUMBER, STUFF(dbo.GROUP_CONCAT(B.PERIKSA_ID),1,1,'') AS SURAT_ID FROM M_SARANA A LEFT JOIN T_PEMERIKSAAN B ON A.SARANA_ID = B.SARANA_ID LEFT JOIN T_PEMERIKSAAN_KOSMETIK C ON B.PERIKSA_ID = C.PERIKSA_ID LEFT JOIN T_PEMERIKSAAN_TEMUAN_PRODUK D ON B.PERIKSA_ID = D.PERIKSA_ID WHERE B.SARANA_ID = '$sarana' AND B.PERIKSA_ID = '$idperiksa[0]'";
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
					$aspek = explode("#", $row['ASPEK_CHECK']);
					$inisal = array("T", "Y");
					$ganti = array("Tidak", "Ya");
					$arrdata['aspek_check'] = str_replace($inisal, $ganti, $aspek);
					$arrdata['aspek_keterangan'] = explode("#", $row['ASPEK_KETERANGAN']);
					$arrdata['sel_tindakan_sarana'] = explode("#", $row['TINDAKAN_SARANA']);
					$arrdata['sel_tmk']= explode("#", $row['DETIL_HASIL']);
					$arrdata['sel_detil_hasil'] = explode("#", $row['KESIMPULAN_DETIL_TMK']);
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
			$query = "SELECT A.NAMA_SARANA, A.ALAMAT_1, A.KEGIATAN_SARANA, STUFF(dbo.ASAL_BBPOM(B.BBPOM_ID),1,0,'') AS BBPOM, D.NOMOR_SURAT AS [SURAT TL], CONVERT(VARCHAR, D.TANGGAL_SURAT, 105) AS [TANGGAL TL], D.PERIHAL, D.TEMPAT_TTD AS TEMPAT, CAST(SUBSTRING(D.PEJABAT_TTD, 0, 9)+ ' ' +SUBSTRING(D.PEJABAT_TTD, 9, 6)+' '+SUBSTRING(D.PEJABAT_TTD, 15, 1)+' '+SUBSTRING(D.PEJABAT_TTD, 16, 3) AS VARCHAR) AS NIP, D.TEMBUSAN, D.AWAL_PSK, D.TINDAKAN, D.POINT, D.PELANGGARAN, D.KETERANGAN,  STUFF(dbo.ASAL_BBPOM(D.BBPOM_ID),1,0,'') AS BALAI, F.NAMA AS [NAMA TTD], F.JABATAN, E.NOMOR AS NOMOR, CONVERT(VARCHAR, E.TANGGAL, 105) AS TANGGAL, Z.URAIAN AS [PERIHAL SURAT], D.LAMPIRAN FROM M_SARANA A LEFT JOIN T_PEMERIKSAAN B ON A.SARANA_ID = B.SARANA_ID LEFT JOIN T_SURAT_TINDAK_LANJUT D ON B.PERIKSA_ID = D.PERIKSA_ID LEFT JOIN T_SURAT_TUGAS_PELAPORAN G ON B.PERIKSA_ID = G.LAPOR_ID LEFT JOIN T_SURAT_TUGAS E ON G.SURAT_ID = E.SURAT_ID LEFT JOIN M_PEJABAT F ON D.PEJABAT_TTD = F.NIP LEFT JOIN M_TABEL Z ON D.PERIHAL = Z.KODE WHERE B.PERIKSA_ID = '$periksa[0]' AND Z.JENIS = 'JENIS_SURAT'";
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
				$ret = $this->load->view('pemeriksaan/tl/kosmetik/02KO/'.$row['PERIHAL'], $arrdata, true);
			}else{
				$this->load->library('mpdf');
				$mpdf=new mPDF('win-1252',array(210,330));
				$mpdf->useOnlyCoreFonts = true;
				$mpdf->SetProtection(array('print'));
				$mpdf->SetAuthor("Bidang TI PIOM");
				$mpdf->SetDisplayMode('fullpage','two');
				$html = $this->load->view('pemeriksaan/tl/kosmetik/02KO/'.$row['PERIHAL'], $arrdata, true);
				$ret = $this->mpdf->WriteHTML($html);
				$ret = $this->mpdf->Output();
			}
			echo $ret;
		}
	}
		
}

?>