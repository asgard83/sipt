<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);
class F01HH extends Model{
	function GetForm01HH($sarana, $jenis, $klasifikasi, $idperiksa){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			if(!array_key_exists($jenis, $this->newsession->userdata("SESS_SARANA")) && !array_key_exists($klasifikasi, $this->newsession->userdata("SESS_KLASIFIKASI_ID"))) return $this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
			$sipt =& get_instance();
			$sipt->load->model("main", "main", true);
			if($idperiksa==""){#Input Mode				  
				 if(!$this->session->userdata('SURAT')) return $this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
$qsarana = "SELECT(SELECT COUNT(SARANA_ID) FROM T_PEMERIKSAAN WHERE SARANA_ID='$sarana' AND STATUS NOT IN('20')) AS PERIKSA_SEBELUMNYA, A.SARANA_ID, A.NAMA_SARANA, A.ALAMAT_1, A.ALAMAT_2, A.JENIS_INDUSTRI, A.NAMA_PIMPINAN, A.PENANGGUNG_JAWAB, A.KEGIATAN_SARANA FROM M_SARANA A LEFT JOIN T_PEMERIKSAAN B ON A.SARANA_ID = B.SARANA_ID WHERE A.SARANA_ID ='$sarana'";
				  $dt_sarana = $sipt->main->get_result($qsarana);
				  if($dt_sarana){
					  foreach($qsarana->result_array() as $row){
						  $arrdata = array('sess' => $row,
										   'SURAT_ID' => '',								
										   'BBPOM_ID' => $this->newsession->userdata('SESS_BBPOM_ID'),
										   'PERIKSA_ID' => '',
										   'sel_hasil' => 'MK',
										   'sel_tmk' => '',
										   'detil_kesimpulan_tmk' => '',
										   'temuan_produk' => array(),
										   'temuan_cpotb' => array(),
										   'act' => site_url().'/post/pemeriksaan/set_periksa/01HH/simpan',
										   'urlback' => site_url().'/home/pelaporan/pemeriksaan');
					  }
				  }			
				  
			}else{#Edit Mode
				$idperiksa = explode(".", $idperiksa);
				$status = $idperiksa[1];
				$qperiksa = "SELECT(SELECT COUNT(SARANA_ID) FROM T_PEMERIKSAAN WHERE SARANA_ID = '$sarana' AND STATUS IN('20')) AS PERIKSA_SEBELUMNYA, (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN_TEMUAN_PRODUK WHERE PERIKSA_ID='$idperiksa[0]') AS JMLTEMUAN, A.SARANA_ID, A.NAMA_SARANA, A.ALAMAT_1, A.ALAMAT_2, A.JENIS_INDUSTRI, A.NAMA_PIMPINAN, A.PENANGGUNG_JAWAB, A.KEGIATAN_SARANA, B.PERIKSA_ID, B.JENIS_SARANA_ID, B.BBPOM_ID, STUFF(dbo.GROUP_KLASIFIKASI(B.PERIKSA_ID),1,1,'') AS KK_ID, CONVERT(VARCHAR(10), B.AWAL_PERIKSA, 103) AS AWAL_PERIKSA, CONVERT(VARCHAR(10), B.AKHIR_PERIKSA, 103) AS AKHIR_PERIKSA, C.TUJUAN_PEMERIKSAAN, C.STANDARD, C.KEPATUHAN_CPOTB, C.LATAR_BELAKANG, C.PERUBAHAN_BERMAKNA, C.RUANG_LINGKUP, C.AREA_INSPEKSI, C.DISTRIBUSI_PENGANGKUTAN, C.PERMOHONAN_PENDAFTARAN_PRODUK, C.ISU_SPESIFIK_LAINNYA, C.SITE_FILE_MASTER, C.LAIN_LAIN, C.SAMPEL_DIAMBIL, C.DISTRIBUSI_LAPORAN, C.LAMPIRAN, C.TINDAKAN_OBSERVASI, C.TEMUAN_KRITIKAL, C.TEMUAN_MAJOR, C.TEMUAN_MINOR, B.HASIL, C.DETIL_HASIL, C.KESIMPULAN_DETIL_TMK, C.REKOMENDASI, C.KESIMPULAN, C.TINDAK_LANJUT, C.TIME_LINE, C.STATUS_CAPA, C.CAPA_CLOSED, D.NAMA_PRODUK, D.KLASIFIKASI_PRODUK, D.NETTO, D.NOMOR_REGISTRASI, D.SATUAN, D.NO_BATCH, D.TANGGAL_EXPIRE, D.NAMA_PERUSAHAAN, D.ALAMAT_PERUSAHAAN, D.KATEGORI, D.JUMLAH_TEMUAN, D.HARGA_SATUAN, D.HARGA_TOTAL, D.TINDAKAN_PRODUK, D.KETERANGAN_SUMBER, D.JENIS_PELANGGARAN, D.TINDAKAN_PRODUK, STUFF(dbo.GROUP_CONCAT(B.PERIKSA_ID),1,1,'') AS SURAT_ID FROM M_SARANA A LEFT JOIN T_PEMERIKSAAN B ON A.SARANA_ID = B.SARANA_ID LEFT JOIN T_PEMERIKSAAN_PRODUKSI_CPOTB C ON B.PERIKSA_ID = C.PERIKSA_ID LEFT JOIN T_PEMERIKSAAN_TEMUAN_PRODUK D ON B.PERIKSA_ID = D.PERIKSA_ID WHERE B.SARANA_ID = '$sarana' AND B.PERIKSA_ID = '$idperiksa[0]'";
				$dt_periksa = $sipt->main->get_result($qperiksa);	
				if($dt_periksa){
					  foreach($qperiksa->result_array() as $row){
						  $temuan_produk[] = $row;
						  $arrdata = array('sess' => $row,
						  				   'temuan_produk' => $temuan_produk,
										   'urlback' => site_url().'/home/pelaporan/pemeriksaan/view/'.$status);
					  }
					  $arrdata['SURAT_ID'] = $row['SURAT_ID'];
					  $arrdata['BBPOM_ID'] = $row['BBPOM_ID'];
					  $arrdata['PERIKSA_ID'] = $row['PERIKSA_ID'];	
					  $arrdata['sel_hasil'] = $row['HASIL'];
					  $arrdata['sel_tmk'] = explode("#", $row['DETIL_HASIL']);
					  $arrdata['detil_kesimpulan_tmk'] = explode("#", $row['KESIMPULAN_DETIL_TMK']);
					  $arrdata['sel_tindakan_observasi'] = explode("#", $row['TINDAKAN_OBSERVASI']);
				  }
				  if($this->newsession->userdata('SESS_BBPOM_ID') != "94"){#Update dan Perbaikan Balai
					  if($status=="20101"){
						  $arrdata['act'] = site_url().'/post/pemeriksaan/set_periksa/01HH/update';
					  }else if($status=="20102" || $status =="20103"){
						  $arrdata['act'] = site_url().'/post/pemeriksaan/set_periksa/01HH/perbaikan';
					  }else if($status =="60020"){
						  $arrdata['act'] = site_url().'/post/pemeriksaan/set_periksa/01HH/rekomendasi';
					  }
				  }else{#Update dan Perbaikan Pusat
					  if($status=="20111"){
						  $arrdata['act'] = site_url().'/post/pemeriksaan/set_periksa/01HH/update';
					  }else if($status =="20113" || $status =="20112"){
						  $arrdata['act'] = site_url().'/post/pemeriksaan/set_periksa/01HH/perbaikan';
					  }else if($status =="60020"){
						  $arrdata['act'] = site_url().'/post/pemeriksaan/set_periksa/01HH/rekomendasi';
					  }
				  }
				  $arrdata['stat'] = $status;				  
				  $arrdata['status'] = $sipt->main->set_verifikasi($status, $this->newsession->userdata('SESS_JENIS_PELAPORAN'), $this->newsession->userdata('SESS_KODE_ROLE'));
				  $arrdata['disverifikasi'] = $status;
				  $arrdata['log'] = site_url().'/get/pemeriksaan/get_log/'.$idperiksa[0];
				  $arrdata['temuan_cpotb'] = $sipt->main->get_observasi($idperiksa[0], "OT", "");
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
			
			if($this->newsession->userdata('SESS_BBPOM_ID') == "94")
				$arrdata['tujuan_pemeriksaan'] = $sipt->main->referensi("TUJUAN_PEMERIKSAAN","'1','2','3','13','15'",TRUE);
			else
				$arrdata['tujuan_pemeriksaan'] = $sipt->main->referensi("TUJUAN_PEMERIKSAAN","'1','2'",TRUE);
			
			$arrdata['temuan_observasi'] = $sipt->main->referensi("TEMUAN_OBSERVASI_CPOTB","",FALSE,TRUE);
			$arrdata['tindakan_observasi'] = $sipt->main->referensi("TL_OBSERVASI","'05','06','07'",TRUE,FALSE);
			$arrdata['cb_observasi'] = $sipt->main->referensi("CB_OBSERVASI","",TRUE,TRUE);
			$arrdata['klasifikasi_temuan'] = $sipt->main->referensi("KLASIFIKASI_TEMUAN","'01','02','03'",TRUE,TRUE);
			$arrdata['kategori_temuan'] = $sipt->main->referensi("KATEGORI_TEMUAN","'01','02','03','04','05','06'",TRUE,TRUE);
			$arrdata['farmasetik'] = $sipt->main->referensi("FARMASETIK","",TRUE);
			$arrdata['tindak_lanjut_temuan_produk'] = $sipt->main->referensi("TL_PRODUK_TEMUAN","'01','02','03','04'",TRUE,TRUE);			
			$arrdata['hasil'] = $sipt->main->referensi("HASIL","'MK','TMK','TTP'",FALSE,TRUE);
			$arrdata['detil_tmk'] = $sipt->main->referensi("DTL_TMK","'01','02','03','04','05','11'",TRUE);
			$arrdata['tl_cpotb'] = $sipt->main->referensi("TL_CPOTB","",TRUE,TRUE);
			$arrdata['capa_cpotb'] = $sipt->main->referensi("CAPA_OTSM","",TRUE,TRUE);
			$arrdata['capa_close_cpotb'] = $sipt->main->referensi("CLOSED_CPOTB","",TRUE,TRUE);
			$arrdata['urlinspeksi'] = site_url().'/get/pemeriksaan/set_detail_inspeksi/'.$jenis."/".$sarana;
			$arrdata['histori_petugas'] = site_url().'/load/petugas/get_petugas/'.$arrdata['SURAT_ID'];
			$arrdata['url_izin'] = site_url().'/get/distribusi/set_izin/'.$jenis.'/'.$sarana;
			$arrdata['url_sertifikat'] = site_url().'/get/distribusi/set_sertifikat/'.$jenis.'/'.$sarana;
			$arrdata['jmlizin'] = $sipt->main->get_uraian("SELECT COUNT(*) AS JMLIZIN FROM M_SARANA_IZIN WHERE SARANA_ID = '".$sarana."'","JMLIZIN");
			return $arrdata;
			
		}
		else
		{
			$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
		}
	  
	}
	
	function get_temuan($sarana, $periksa, $isprev){
		$sipt =& get_instance();
		$this->load->model("main","main", true);
		$cb_observasi = array("" => "Pilih", "Kritikal" => "Kritikal", "Major" => "Major", "Minor" => "Minor", "Observasi" => "Observasi");
		$temuan_observasi = $sipt->main->combobox("SELECT KODE, URAIAN FROM M_TABEL WHERE JENIS='TEMUAN_OBSERVASI_CPOTB' ORDER BY KODE ASC","KODE","URAIAN", TRUE);
		if($periksa==""){
			$arrdata = array('sess_temuan' => '', 'isprev' => $isprev);	
		}else{
			$query = "SELECT (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN_PRODUKSI_CPOTB_TEMUAN WHERE PERIKSA_ID='$periksa') AS JUMLAH_TEMUAN, A.SARANA_ID, C.SERI, C.TEMUAN_OBSERVASI, C.TEMUAN_TEKS, C.TEMUAN_KRITERIA, C.TEMUAN_FILE, D.URAIAN AS UR_JENIS FROM T_PEMERIKSAAN A LEFT JOIN T_PEMERIKSAAN_PRODUKSI_CPOTB B ON A.PERIKSA_ID = B.PERIKSA_ID LEFT JOIN T_PEMERIKSAAN_PRODUKSI_CPOTB_TEMUAN C ON B.PERIKSA_ID = C.PERIKSA_ID LEFT JOIN M_TABEL D ON D.KODE = C.TEMUAN_OBSERVASI WHERE A.PERIKSA_ID = '$periksa' AND A.SARANA_ID = '$sarana' AND D.JENIS='TEMUAN_OBSERVASI_CPOTB'";
			$data = $sipt->main->get_result($query);
			if($data){
				foreach($query->result_array() as $row){
					$temuan_cpotb[] = $row;
					$arrdata = array('sess_temuan' => $row, 'temuan_cpotb' => $temuan_cpotb, 'isprev' => $isprev);
				}
			}
		}
		$arrdata['sarana_id'] = $sarana;
		$arrdata['cb_observasi'] = $cb_observasi;
		$arrdata['temuan_observasi'] = $temuan_observasi;
		return $arrdata;	  
	}
		
	function SaveForm01HH($action, $isajax){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main","main", true);
			if(in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')))
				$status = '20111';
			else
				$status = '20101';
			$ret = "MSG#NO#Data gagal disimpan#";
			if($action=="simpan"){#Insert
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
					$arr_cpotb = array('PERIKSA_ID' => $periksa_id);
					foreach($this->input->post('PEMERIKSAAN_CPOTB') as $c => $d){
						if(!is_array($d))
							$arr_cpotb[$c] = $d;
						else
							$arr_cpotb[$c] = join("#", $d);
					}
					$arr_cpotb['KESIMPULAN_DETIL_TMK'] = htmlspecialchars_decode($arr_cpotb['KESIMPULAN_DETIL_TMK']);
					$this->db->insert('T_PEMERIKSAAN_PRODUKSI_CPOTB', $arr_cpotb);
															
					foreach($SES_ID as $z){
						$pelaporan = array('SURAT_ID' => $z, 'LAPOR_ID' => $periksa_id);
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
							$seri = (int)$sipt->main->get_uraian("SELECT MAX(SERI) AS MAXID FROM T_PEMERIKSAAN_PRODUKSI_CPOTB_TEMUAN WHERE PERIKSA_ID = '$periksa_id'", "MAXID") + 1;
							$temuan = array('PERIKSA_ID' => $periksa_id,
											'SERI' => $seri);
							for($j=0;$j<count($arrkeys);$j++){
								#$temuan[$arrkeys[$j]] = preg_replace('/[^(\x20-\x7F)]*/','',$arrtemuan[$arrkeys[$j]][$i]);
								$temuan[$arrkeys[$j]] = preg_replace('/[^(\x20-\x7F)]*/','',$sipt->main->clean_tags($arrtemuan[$arrkeys[$j]][$i]));
							}
							$this->db->insert('T_PEMERIKSAAN_PRODUKSI_CPOTB_TEMUAN', $temuan);
						}
					}
					
					if($this->input->post('TEMUAN_PRODUK')){					
						$arrtemuan_produk = $this->input->post('TEMUAN_PRODUK');
						$arrkeys_produk = array_keys($arrtemuan_produk);
						for($i=0;$i<count($arrtemuan_produk[$arrkeys_produk[0]]);$i++){
							$seri = (int)$sipt->main->get_uraian("SELECT MAX(SERI) AS MAXID FROM T_PEMERIKSAAN_TEMUAN_PRODUK WHERE PERIKSA_ID = '$periksa_id'", "MAXID") + 1;
							$temuan_produk = array('PERIKSA_ID' => $periksa_id,
											'SERI' => $seri,
											'KK_ID' => '010');
							for($j=0;$j<count($arrkeys_produk);$j++){
								$temuan_produk[$arrkeys_produk[$j]] = $arrtemuan_produk[$arrkeys_produk[$j]][$i];
							}
							$this->db->insert('T_PEMERIKSAAN_TEMUAN_PRODUK', $temuan_produk);
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
			}else if($action=="update" || $action=="perbaikan" || $action=="rekomendasi"){#Update
				$arr_pemeriksaan = array('UPDATE_BY' => $this->newsession->userdata('SESS_USER_ID'),
										 'LAST_UPDATE' => 'GETDATE()');
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
					foreach($this->input->post('PEMERIKSAAN_CPOTB') as $c => $d){
						if(!is_array($d))
							$arr_cpotb[$c] = $d;
						else
							$arr_cpotb[$c] = join("#", $d);
					}
					$arr_cpotb['KESIMPULAN_DETIL_TMK'] = htmlspecialchars_decode($arr_cpotb['KESIMPULAN_DETIL_TMK']);
					$this->db->where(array("PERIKSA_ID" => $this->input->post('PERIKSA_ID')));
					$this->db->update('T_PEMERIKSAAN_PRODUKSI_CPOTB', $arr_cpotb);
				}
				
				if($this->input->post('TEMUAN')){
					  $this->db->where('PERIKSA_ID', $this->input->post('PERIKSA_ID'));
					  $this->db->delete('T_PEMERIKSAAN_PRODUKSI_CPOTB_TEMUAN');
					  $arrtemuan = $this->input->post('TEMUAN');
					  $arrkeys = array_keys($arrtemuan);
					  for($i=0;$i<count($arrtemuan[$arrkeys[0]]);$i++){
						  $seri = (int)$sipt->main->get_uraian("SELECT MAX(SERI) AS MAXID FROM T_PEMERIKSAAN_PRODUKSI_CPOTB_TEMUAN WHERE PERIKSA_ID = '".$this->input->post('PERIKSA_ID')."'", "MAXID") + 1;
						  $temuan = array('PERIKSA_ID' => $this->input->post('PERIKSA_ID'),
										  'SERI' => $seri);
						  for($j=0;$j<count($arrkeys);$j++){
							  #$temuan[$arrkeys[$j]] = preg_replace('/[^(\x20-\x7F)]*/','',$arrtemuan[$arrkeys[$j]][$i]);
							  $temuan[$arrkeys[$j]] = preg_replace('/[^(\x20-\x7F)]*/','',$sipt->main->clean_tags($arrtemuan[$arrkeys[$j]][$i]));
						  }
						  $this->db->insert('T_PEMERIKSAAN_PRODUKSI_CPOTB_TEMUAN', $temuan);
					  }
				  }			
				  
				  if($this->input->post('TEMUAN_PRODUK')){
					  $this->db->where('PERIKSA_ID', $this->input->post('PERIKSA_ID'));
					  $this->db->delete('T_PEMERIKSAAN_TEMUAN_PRODUK');
					  $arrtemuan_produk = $this->input->post('TEMUAN_PRODUK');
					  $arrkeys_produk = array_keys($arrtemuan_produk);
					  for($i=0;$i<count($arrtemuan_produk[$arrkeys_produk[0]]);$i++){
						  $seri = (int)$sipt->main->get_uraian("SELECT MAX(SERI) AS MAXID FROM T_PEMERIKSAAN_TEMUAN_PRODUK WHERE PERIKSA_ID = '".$this->input->post('PERIKSA_ID')."'", "MAXID") + 1;
						  $temuan_produk = array('PERIKSA_ID' => $this->input->post('PERIKSA_ID'),
										  'SERI' => $seri,
										  'KK_ID' => '010');
						  for($j=0;$j<count($arrkeys_produk);$j++){
							  $temuan_produk[$arrkeys_produk[$j]] = $arrtemuan_produk[$arrkeys_produk[$j]][$i];
						  }
						  $this->db->insert('T_PEMERIKSAAN_TEMUAN_PRODUK', $temuan_produk);
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
				return $ret;
			}
		}else{
			$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
		}
	}
	
	function get_preview($sarana,$id,$jenis){
		$sipt =& get_instance();
		$this->load->model("main","main", true);
		$id = explode(".", $id);
		$query = "SELECT (CAST(A.SARANA_ID AS VARCHAR) + '/' + A.JENIS_SARANA_ID + '/' + STUFF(dbo.GROUP_KLASIFIKASI(A.PERIKSA_ID),1,1,'') + '/' + CAST(A.PERIKSA_ID AS VARCHAR) + '.' + A.STATUS) AS IDPERIKSA, A.PERIKSA_ID, A.SARANA_ID, A.STATUS, CONVERT(VARCHAR(10), A.AWAL_PERIKSA, 103) AS [AWAL_PERIKSA], CONVERT(VARCHAR(10), A.AKHIR_PERIKSA, 103) AS [AKHIR_PERIKSA], B.KEPATUHAN_CPOTB, B.LATAR_BELAKANG, B.PERUBAHAN_BERMAKNA, B.RUANG_LINGKUP, B.AREA_INSPEKSI, B.TEMUAN_KRITIKAL, B.TEMUAN_MAJOR, B.TEMUAN_MINOR, A.HASIL, B.DETIL_HASIL, B.KESIMPULAN_DETIL_TMK, B.REKOMENDASI, B.KESIMPULAN, STUFF(dbo.GROUP_CONCAT(A.PERIKSA_ID),1,1,'') AS SURAT_ID FROM T_PEMERIKSAAN A LEFT JOIN T_PEMERIKSAAN_PRODUKSI_CPOTB B ON A.PERIKSA_ID = B.PERIKSA_ID WHERE A.SARANA_ID = '$sarana' AND A.PERIKSA_ID = '$id[0]'";
		
		$judul = $sipt->main->get_judul($jenis);
		$data = $sipt->main->get_result($query);
		$observasi = $sipt->main->get_observasi($id[0], "OT", "");
		if($data){
			foreach($query->result_array() as $row){
				$arrdata = array('sess' => $row, 'observasi' => $observasi, 'judul' => $judul);
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
			$query = "SELECT(SELECT COUNT(SARANA_ID) FROM T_PEMERIKSAAN WHERE SARANA_ID = '$sarana' AND STATUS IN('20')) AS PERIKSA_SEBELUMNYA, (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN_TEMUAN_PRODUK WHERE PERIKSA_ID='$idperiksa[0]') AS JMLTEMUAN, (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN_PRODUKSI_CPOB_PERBAIKAN WHERE PERIKSA_ID='$idperiksa[0]') AS JML_PERBAIKAN, (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN_PROSES WHERE PERIKSA_ID = '$idperiksa[0]') AS JML_PROSES, (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN_PRODUKSI_CPOTB_PERBAIKAN WHERE PERIKSA_ID='$idperiksa[0]') AS JML_PERBAIKAN, A.SARANA_ID, A.NAMA_SARANA, A.ALAMAT_1, A.ALAMAT_2, A.JENIS_INDUSTRI, A.NAMA_PIMPINAN, A.PENANGGUNG_JAWAB, A.KEGIATAN_SARANA, B.PERIKSA_ID, B.JENIS_SARANA_ID, B.BBPOM_ID, STUFF(dbo.GROUP_KLASIFIKASI(B.PERIKSA_ID),1,1,'') AS KK_ID, CONVERT(VARCHAR(10), B.AWAL_PERIKSA, 103) AS AWAL_PERIKSA, CONVERT(VARCHAR(10), B.AKHIR_PERIKSA, 103) AS AKHIR_PERIKSA, C.TUJUAN_PEMERIKSAAN, C.STANDARD, C.KEPATUHAN_CPOTB, C.LATAR_BELAKANG, C.PERUBAHAN_BERMAKNA, C.RUANG_LINGKUP, C.AREA_INSPEKSI, C.DISTRIBUSI_PENGANGKUTAN, C.PERMOHONAN_PENDAFTARAN_PRODUK, C.ISU_SPESIFIK_LAINNYA, C.SITE_FILE_MASTER, C.LAIN_LAIN, C.SAMPEL_DIAMBIL, C.DISTRIBUSI_LAPORAN, C.LAMPIRAN, C.TINDAKAN_OBSERVASI, C.TEMUAN_KRITIKAL, C.TEMUAN_MAJOR, C.TEMUAN_MINOR, B.HASIL, C.DETIL_HASIL, C.KESIMPULAN_DETIL_TMK, C.REKOMENDASI, C.KESIMPULAN, C.TINDAK_LANJUT, C.TIME_LINE, C.STATUS_CAPA, C.CAPA_CLOSED, C.CATATAN_PUSAT, C.HASIL_PUSAT, D.NAMA_PRODUK, D.KLASIFIKASI_PRODUK, D.NETTO, D.NOMOR_REGISTRASI, D.SATUAN, D.NO_BATCH, D.TANGGAL_EXPIRE, D.NAMA_PERUSAHAAN, D.ALAMAT_PERUSAHAAN, D.KATEGORI, D.JUMLAH_TEMUAN, D.HARGA_SATUAN, D.HARGA_TOTAL, D.TINDAKAN_PRODUK, D.KETERANGAN_SUMBER, D.JENIS_PELANGGARAN, D.TINDAKAN_PRODUK, STUFF(dbo.GROUP_CONCAT(B.PERIKSA_ID),1,1,'') AS SURAT_ID FROM M_SARANA A LEFT JOIN T_PEMERIKSAAN B ON A.SARANA_ID = B.SARANA_ID LEFT JOIN T_PEMERIKSAAN_PRODUKSI_CPOTB C ON B.PERIKSA_ID = C.PERIKSA_ID LEFT JOIN T_PEMERIKSAAN_TEMUAN_PRODUK D ON B.PERIKSA_ID = D.PERIKSA_ID WHERE B.SARANA_ID = '$sarana' AND B.PERIKSA_ID = '$idperiksa[0]'";
			$data = $sipt->main->get_result($query);
			if($data){
				foreach($query->result_array() as $row){
					$temuan_produk[] = $row;
					$arrdata = array('sess' => $row, 'temuan_produk' => $temuan_produk);
				}
				$arrdata['SURAT_ID'] = $row['SURAT_ID'];
				$arrdata['BBPOM_ID'] = $row['BBPOM_ID'];
				$arrdata['sel_hasil'] = $row['HASIL'];
				$arrdata['sel_tmk'] = explode("#", $row['DETIL_HASIL']);
				$arrdata['detil_kesimpulan_tmk'] = explode("#", $row['KESIMPULAN_DETIL_TMK']);
				$arrdata['sel_tindakan_observasi'] = explode("#", $row['TINDAKAN_OBSERVASI']);
			}
			if(array_key_exists('2', $this->newsession->userdata('SESS_KODE_ROLE'))){#Operator
				if($this->newsession->userdata('SESS_BBPOM_ID') != "94"){
					$isEditTL = TRUE;
					$arrdata['obj_ot'] = 'PEMERIKSAAN_CPOTB';
					if($row['JML_PERBAIKAN'] == 0){
						$isPerbaikan = FALSE;
					}else{
						$isPerbaikan = TRUE;
					}
				}else{
					$isPerbaikan = TRUE; 
					$isEditTL = FALSE;
					$arrdata['obj_ot'] = 'PEMERIKSAAN_CPOTB';
				}
				$isEditTLBalai = TRUE;
				$arrdata['act'] = site_url().'/post/pemeriksaan/set_proses/01HH/operator';
				$arrdata['obj_status'] = 'OPERATOR[STATUS]';
			}else if(array_key_exists('3', $this->newsession->userdata('SESS_KODE_ROLE'))){#Supervisor Satu
			  if($this->newsession->userdata('SESS_BBPOM_ID') != "94"){
					$arrdata['obj_ot'] = 'PEMERIKSAAN_CPOTB';
					if($row['JML_PERBAIKAN'] == 0){
						$isPerbaikan = FALSE;
					}else{
						$isPerbaikan = TRUE;
					}
					$isEditTLBalai = FALSE;
					$isEditTL = TRUE;
			  }else{
					if($this->newsession->userdata('SESS_BBPOM_ID') == $arrdata['BBPOM_ID']){
						$isEditTLBalai = FALSE;
						$isEditTL = FALSE;
					}else{
						$isEditTLBalai = TRUE;
						$isEditTL = FALSE;
					}
					$isPerbaikan = TRUE;
					$arrdata['obj_ot'] = 'PEMERIKSAAN_CPOTB';
			  }
			  $arrdata['act'] = site_url().'/post/pemeriksaan/set_proses/01HH/spv-satu';
			  $arrdata['obj_status'] = 'SUPERVISOR[STATUS]';
		  }else if(array_key_exists('4', $this->newsession->userdata('SESS_KODE_ROLE'))){#Supervisor Lanjutan
			  if($this->newsession->userdata('SESS_BBPOM_ID') != "94"){
					$arrdata['obj_ot'] = 'PEMERIKSAAN_CPOTB';
					if($row['JML_PERBAIKAN'] == 0){
						$isPerbaikan = FALSE;
					}else{
						$isPerbaikan = TRUE;
					}
					$isEditTLBalai = FALSE;
					$isEditTL = TRUE;
			  }else{
					if($this->newsession->userdata('SESS_BBPOM_ID') == $arrdata['BBPOM_ID']){
						$isEditTLBalai = FALSE;
						$isEditTL = FALSE;
					}else{
						$isEditTLBalai = TRUE;
						$isEditTL = FALSE;
					}
					$isPerbaikan = TRUE;
					$arrdata['obj_ot'] = 'PEMERIKSAAN_CPOTB';
			  }
			  $arrdata['act'] = site_url().'/post/pemeriksaan/set_proses/01HH/spv-dua';
			  $arrdata['obj_status'] = 'SUPERVISOR[STATUS]';
		  }else if(array_key_exists('5', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('6', $this->newsession->userdata('SESS_KODE_ROLE'))){
			  $isEditTL = TRUE;
			  $isEditTLBalai = TRUE;
			  $isPerbaikan = TRUE;
			  $arrdata['obj_status'] = 'VERIFIKASI[STATUS]';
			  $arrdata['act'] = site_url().'/post/pemeriksaan/set_proses/01HH/56';
		  }
		  
		  if($subid!=""){
			  $isPerbaikan = FALSE;
			  $isEditTLBalai = TRUE;
			  $isEditTL = TRUE;
			  $isverifikasi = FALSE;
		  }else{
			  $isverifikasi = TRUE;
		  }		  
		  
		  $arrdata['headersarana'] = $sipt->main->get_judul($jenis);
		  $arrdata['status'] = $sipt->main->set_verifikasi($stat, $this->newsession->userdata('SESS_JENIS_PELAPORAN'), $this->newsession->userdata('SESS_KODE_ROLE'));
		  $arrdata['disverifikasi'] = $stat;		
		  $arrdata['isEditTLBalai'] = $isEditTLBalai;
		  $arrdata['isEditTL'] = $isEditTL;
		  $arrdata['isPerbaikan'] = $isPerbaikan;
		  $arrdata['isverifikasi'] = $isverifikasi;
		  $arrdata['hasil'] = $sipt->main->referensi("HASIL","'MK','TMK','TTP'",FALSE,TRUE);
		  $arrdata['detil_tmk'] = $sipt->main->referensi("DTL_TMK","'01','02','03','04','05','11'",TRUE);
		  $arrdata['tl_cpotb'] = $sipt->main->referensi("TL_CPOTB","",TRUE,TRUE);
		  $arrdata['capa_cpotb'] = $sipt->main->referensi("CAPA_OTSM","",TRUE,TRUE);
		  $arrdata['capa_close_cpotb'] = $sipt->main->referensi("CLOSED_CPOTB","",TRUE,TRUE);
		  $arrdata['urlback'] = site_url().'/home/pelaporan/pemeriksaan/view';
		  $arrdata['urlinspeksi'] = site_url().'/get/pemeriksaan/set_detail_inspeksi/'.$jenis."/".$sarana;
		  $arrdata['histori_petugas'] = site_url().'/load/petugas/get_petugas/'.$arrdata['SURAT_ID'];
		  $arrdata['histori_perbaikan'] = site_url().'/get/pemeriksaan/set_perbaikan/'.$idperiksa[0].'/'.$jenis;
		  $arrdata['url_izin'] = site_url().'/get/distribusi/set_izin/'.$jenis.'/'.$sarana;
		  $arrdata['url_sertifikat'] = site_url().'/get/distribusi/set_sertifikat/'.$jenis.'/'.$sarana;
		  $arrdata['url_observasi'] = site_url().'/get/pemeriksaan/set_temuan/'.$jenis.'/'.$sarana.'/'.$row['PERIKSA_ID']."/preview";
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
				$arr_status = array('UPDATE_BY' => $this->newsession->userdata('SESS_USER_ID'),
									'LAST_UPDATE' => 'GETDATE()');
				foreach($this->input->post('OPERATOR') as $a => $b){
					$arr_status[$a] = $b;
				}
				$status = $arr_status['STATUS'];
				$this->db->where(array("PERIKSA_ID" => $this->input->post('PERIKSA_ID')));
				if($this->db->update('T_PEMERIKSAAN', $arr_status)){#Update Status Operator
					  if($this->input->post('PEMERIKSAAN_CPOTB')){
						  foreach($this->input->post('PEMERIKSAAN_CPOTB') as $c => $d){
							  if(!is_array($d))
								$arr_update[$c] = $d;
							  else
								$arr_update[$c] = join("#", $d);
						  }
						  $this->db->where(array("PERIKSA_ID" => $this->input->post('PERIKSA_ID')));
						  $this->db->update('T_PEMERIKSAAN_PRODUKSI_CPOTB', $arr_update); #Update Tindak Lanjut Pusat
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
						  $perbaikan = (int)$sipt->main->get_uraian("SELECT MAX(SERI) AS MAXID FROM T_PEMERIKSAAN_PRODUKSI_CPOTB_PERBAIKAN WHERE PERIKSA_ID = '".$this->input->post('PERIKSA_ID')."'", "MAXID") + 1;
						  $arr_perbaikan = array('PERIKSA_ID' => $this->input->post('PERIKSA_ID'),
												 'SERI' => $perbaikan,
												 'CREATE_BY' => $this->newsession->userdata('SESS_USER_ID'),
												 'CREATE_DATE' => 'GETDATE()');
						  foreach($this->input->post('PERBAIKAN') as $x => $z){
							  $arr_perbaikan[$x] = $z;
						  }
						  if(trim($arr_perbaikan['TANGGAL_PERBAIKAN']) != "" || trim($arr_perbaikan['DETAIL_PERBAIKAN']) != ""){
							  $this->db->insert('T_PEMERIKSAAN_PRODUKSI_CPOTB_PERBAIKAN', $arr_perbaikan);#Perbaikan Pemeriksaan					  
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
					  $arr_input = $this->input->post('PEMERIKSAAN_CPOTB'); 
					  foreach($arr_input as $c => $d){
						  if(!is_array($d))
							$arr_update[$c] = $d;
						  else 
							$arr_update[$c] = join("#", $d);
					  }
					  $this->db->where(array("PERIKSA_ID" => $this->input->post('PERIKSA_ID')));
					  $this->db->update('T_PEMERIKSAAN_PRODUKSI_CPOTB', $arr_update); #Update Tindak Lanjut
  
					 $seri = (int)$sipt->main->get_uraian("SELECT MAX(SERI) AS MAXID FROM T_PEMERIKSAAN_PROSES WHERE PERIKSA_ID = '".$this->input->post('PERIKSA_ID')."'", "MAXID") + 1;
					  $arr_proses = array('PERIKSA_ID' => $this->input->post('PERIKSA_ID'),
										  'SERI' => $seri,
										  'HASIL' => $status,
										  'CATATAN' => $this->input->post('catatan'),
										  'CREATE_BY' => $this->newsession->userdata('SESS_USER_ID'),
										  'CREATE_DATE' => 'GETDATE()');
					  $this->db->insert('T_PEMERIKSAAN_PROSES', $arr_proses);
					  if($this->input->post('PERBAIKAN')){
						  $perbaikan = (int)$sipt->main->get_uraian("SELECT MAX(SERI) AS MAXID FROM T_PEMERIKSAAN_PRODUKSI_CPOTB_PERBAIKAN WHERE PERIKSA_ID = '".$this->input->post('PERIKSA_ID')."'", "MAXID") + 1;
						  $arr_perbaikan = array('PERIKSA_ID' => $this->input->post('PERIKSA_ID'),
												 'SERI' => $perbaikan,
												 'CREATE_BY' => $this->newsession->userdata('SESS_USER_ID'),
												 'CREATE_DATE' => 'GETDATE()');
						  foreach($this->input->post('PERBAIKAN') as $x => $z){
							  $arr_perbaikan[$x] = $z;
						  }
						  if(trim($arr_perbaikan['TANGGAL_PERBAIKAN']) != "" || trim($arr_perbaikan['DETAIL_PERBAIKAN']) != ""){
							  $this->db->insert('T_PEMERIKSAAN_PRODUKSI_CPOTB_PERBAIKAN', $arr_perbaikan);#Perbaikan Pemeriksaan
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

	function get_sertifikat($sarana){
		$query = "SELECT SERI, CASE JENIS WHEN '01' THEN 'Yang Dimiliki' WHEN '02' THEN 'Yang Diberikan' END AS [JENIS SERTIFIKAT], NOMOR_SERTIFIKAT AS [NOMOR SERTIFIKAT], BENTUK_SEDIAAN AS [BENTUK SEDIAAN], CONVERT(VARCHAR(10), TANGGAL_SERTIFIKAT, 103) AS TANGGAL FROM M_SARANA_SERTIFIKAT WHERE SARANA_ID = '$sarana'";
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


	function get_inspeksi($sarana){
		$sipt =& get_instance();
		$sipt->load->model("main", "main", true);
		$query = "SELECT TOP 1 A.SARANA_ID, CONVERT(VARCHAR(10), A.AWAL_PERIKSA, 103) AS AWAL_PERIKSA, CONVERT(VARCHAR(10), A.AKHIR_PERIKSA, 103) AS AKHIR_PERIKSA, STUFF(dbo.GROUP_PETUGAS(A.PERIKSA_ID),1,0,'') AS PETUGAS, B.LATAR_BELAKANG FROM T_PEMERIKSAAN A LEFT JOIN T_PEMERIKSAAN_PRODUKSI_CPOTB B ON A.PERIKSA_ID = B.PERIKSA_ID WHERE A.SARANA_ID = '$sarana' ORDER BY A.PERIKSA_ID DESC";
		$data = $sipt->main->get_result($query);
		if($data){
			foreach($query->result_array() as $row){
				$arrdata = array('sess' => $row);
			}
		}
		return $arrdata;
	}
	
	function get_perbaikan($periksa_id){
		$query = "SELECT A.SARANA_ID, B.SERI AS NO, CONVERT(VARCHAR(10), B.TANGGAL_PERBAIKAN, 103) AS [TANGGAL PERBAIKAN], B.DETAIL_PERBAIKAN AS [DETAIL PERBAIKAN], '<a class=\"normal\" href=\"".base_url()."files/' + CAST(A.SARANA_ID AS VARCHAR)+ '/'+ B.FILE_PERBAIKAN +'\" target=\"_blank\">View</a>' AS [FILE PERBAIKAN], C.NAMA_BBPOM AS [BALAI ATAU UNIT], D.NAMA_USER AS [NAMA PETUGAS] FROM T_PEMERIKSAAN A LEFT JOIN T_PEMERIKSAAN_PRODUKSI_CPOTB_PERBAIKAN B ON A.PERIKSA_ID = B.PERIKSA_ID LEFT JOIN T_USER D ON B.CREATE_BY = D.USER_ID LEFT JOIN M_BBPOM C ON D.BBPOM_ID = C.BBPOM_ID WHERE B.PERIKSA_ID='$periksa_id'";
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
	
	function set_bap($sarana,$jenis,$idperiksa,$subid){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$sipt->load->model("main","main", true);
			$func =& get_instance();
			$func->load->model("functions","functions", true);
			$idperiksa = explode(".", $idperiksa);
			$query = "SELECT(SELECT TOP 1 CONVERT(VARCHAR(10), AWAL_PERIKSA, 103) + ' s.d ' + CONVERT(VARCHAR(10), AKHIR_PERIKSA, 103) FROM T_PEMERIKSAAN WHERE SARANA_ID = '$sarana' ) AS TERAKHIR, (SELECT STUFF(dbo.GROUP_PETUGAS('$sarana'),1,0,'')) AS INSPEKTUR, (SELECT TOP 1 LATAR_BELAKANG FROM T_PEMERIKSAAN WHERE SARANA_ID = '$sarana') AS RINGKASAN, (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN_TEMUAN_PRODUK WHERE PERIKSA_ID='$idperiksa[0]') AS JUMLAH_TEMUAN, A.SARANA_ID, A.NAMA_SARANA, A.ALAMAT_1, A.ALAMAT_2, A.JENIS_INDUSTRI, A.NAMA_PIMPINAN, A.PENANGGUNG_JAWAB, A.KEGIATAN_SARANA, B.PERIKSA_ID, B.JENIS_SARANA_ID, B.BBPOM_ID, STUFF(dbo.GROUP_KLASIFIKASI(B.PERIKSA_ID),1,1,'') AS KK_ID, CONVERT(VARCHAR(10), B.AWAL_PERIKSA, 103) AS AWAL_PERIKSA, CONVERT(VARCHAR(10), B.AKHIR_PERIKSA, 103) AS AKHIR_PERIKSA, C.TUJUAN_PEMERIKSAAN, C.STANDARD, C.KEPATUHAN_CPOTB, C.LATAR_BELAKANG, C.PERUBAHAN_BERMAKNA, C.RUANG_LINGKUP, C.AREA_INSPEKSI, C.DISTRIBUSI_PENGANGKUTAN, C.PERMOHONAN_PENDAFTARAN_PRODUK, C.ISU_SPESIFIK_LAINNYA, C.SITE_FILE_MASTER, C.LAIN_LAIN, C.SAMPEL_DIAMBIL, C.DISTRIBUSI_LAPORAN, C.LAMPIRAN, C.TINDAKAN_OBSERVASI, C.TEMUAN_KRITIKAL, C.TEMUAN_MAJOR, C.TEMUAN_MINOR, B.HASIL, C.DETIL_HASIL, C.KESIMPULAN_DETIL_TMK, C.REKOMENDASI, C.KESIMPULAN, C.TINDAK_LANJUT, C.TIME_LINE, C.STATUS_CAPA, C.CAPA_CLOSED, D.NAMA_PRODUK, D.KLASIFIKASI_PRODUK, D.NETTO, D.NOMOR_REGISTRASI, D.SATUAN, D.NO_BATCH, D.TANGGAL_EXPIRE, D.NAMA_PERUSAHAAN, D.ALAMAT_PERUSAHAAN, D.KATEGORI, D.JUMLAH_TEMUAN, D.HARGA_SATUAN, D.HARGA_TOTAL, D.TINDAKAN_PRODUK, D.KETERANGAN_SUMBER, D.JENIS_PELANGGARAN, D.TINDAKAN_PRODUK, STUFF(dbo.GROUP_CONCAT(B.PERIKSA_ID),1,1,'') AS SURAT_ID FROM M_SARANA A LEFT JOIN T_PEMERIKSAAN B ON A.SARANA_ID = B.SARANA_ID LEFT JOIN T_PEMERIKSAAN_PRODUKSI_CPOTB C ON B.PERIKSA_ID = C.PERIKSA_ID LEFT JOIN T_PEMERIKSAAN_TEMUAN_PRODUK D ON B.PERIKSA_ID = D.PERIKSA_ID WHERE B.SARANA_ID = '$sarana' AND B.PERIKSA_ID = '$idperiksa[0]'";
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
									 'petugas' => $sipt->main->bap_petugas($idperiksa[0]), 
									 'hari' => $func->functions->get_hari($hari),
									 'awal_periksa' => "$tgl[0] $tgla $tgl[2]",
									 'inspeksi' => $this->get_inspeksi($sarana),
									 'temuan' => $sipt->main->get_observasi($idperiksa[0], "OT", ""),
									 'awal_periksa' => "$tgl[0] bulan $tgla tahun $tgl[2]",
									 'temuan_produk' => $temuan_produk);
				}
				$arrdata['sel_hasil'] = $row['HASIL'];
				$arrdata['sel_tmk'] = explode("#", $row['DETIL_HASIL']);
				$arrdata['detil_kesimpulan_tmk'] = explode("#", $row['KESIMPULAN_DETIL_TMK']);
				$arrdata['sel_tindakan_observasi'] = explode("#", $row['TINDAKAN_OBSERVASI']);
				$sel_tindakan_observasi = explode("#", $row['TINDAKAN_OBSERVASI']);
				$detil_hasil = explode("#", $row['DETIL_HASIL']);
			}
			
		}		
		require_once(APPPATH.'libraries/PHPDocx'.EXT);
		$msword = new PHPDocx();
		$msword->addParagraph('FORM - LAPORAN INSPEKSI CPOTB', array('text-align' => 'justify','font-weight' => 'bold'));
		$msword->addParagraph('');
		$header = '<table width="100%">
				  <tr><td width="220">Nama Sarana</td><td width="10">:</td><td><b>'.strtoupper($row['NAMA_SARANA']).'</b></td></tr>
				  <tr><td width="220">Alamat</td><td width="10">:</td><td>'.$row['ALAMAT_1'].'</td></tr>
				  <tr><td width="220">Jenis Industri</td><td width="10">:</td><td>'.$row['JENIS_INDUSTRI'].'</td></tr>
				  <tr><td width="220">Kegiatan yang dilakukan</td><td width="10">:</td><td>';
				  if(trim($row['KEGIATAN_SARANA']) != ""){
					  $kegiatan = explode("|", $row['KEGIATAN_SARANA']);
					  $jmlkegiatan = count($kegiatan);
					  $header .= '<ul style="list-style-type:decimal; padding-left:15px; margin:0;">';
					  for($k=0;$k<$jmlkegiatan;$k++){
						  $header .= $kegiatan[$k];
					  }
					  $header .= '</ul>';
				  }
		$header .= '<tr><td width="220">Nama Pemilik</td><td width="10">:</td><td>'.$row['NAMA_PIMPINAN'].'</td></tr>
				  <tr><td width="220">Nama Penanggung Jawab</td><td width="10">:</td><td>'.$row['PENANGGUNG_JAWAB'].'</td></tr>
				  <tr><td width="220">Tanggal Pemeriksaan</td><td width="10">:</td><td>'.$row['AWAL_PERIKSA'].'&nbsp; sampai dengan &nbsp;'.$row['AKHIR_PERIKSA'].'</td></tr>
				  <tr><td width="220">Tujuan Pemeriksaan</td><td width="10">:</td><td>'.$row['TUJUAN_PEMERIKSAAN'].'</td></tr>
				  </table><div style="height:10px;>&nbsp;</div>"';
		$msword->addParagraph($header, array('text-align' => 'justify'));
		$msword->addParagraph('');
		$msword->addParagraph('Kepatuhan CPOTB dan Keputusan', array('text-align' => 'justify', 'font-weight' => 'bold'));
		$msword->addParagraph(preg_replace('/[^(\x20-\x7F)]*/', "",html_entity_decode($row['KEPATUHAN_CPOTB'])), array('text-align' => 'justify'));
		$msword->addParagraph('Latar Belakang Hasil Pemeriksaan yang lalu', array('text-align' => 'justify', 'font-weight' => 'bold'));
		$msword->addParagraph(preg_replace('/[^(\x20-\x7F)]*/', "",html_entity_decode($row['LATAR_BELAKANG'])), array('text-align' => 'justify'));
		$msword->addParagraph('Perubahan Bermakna sejak inspeksi terakhir', array('text-align' => 'justify', 'font-weight' => 'bold'));
		$msword->addParagraph(preg_replace('/[^(\x20-\x7F)]*/', "",html_entity_decode($row['PERUBAHAN_BERMAKNA'])), array('text-align' => 'justify'));

		$msword->addParagraph('');
		$msword->addParagraph('Inspektur yang bertugas pada inspeksi sebelumnya', array('text-align' => 'justify', 'font-weight' => 'bold'));
		$suratke = $sipt->main->get_uraian("SELECT dbo.CONCAT_PERIKSA('$sarana','$jenis') AS SURAT","SURAT");
		$arr_surat = explode("#",$suratke);
		$cari_periksa = array_search($idperiksa[0],$arr_surat);
		$idx = $cari_periksa - 1;
		if($idx < 0)
			$last_id = "";
		else
			$last_id = $sipt->main->get_uraian("SELECT SURAT_ID AS SURAT_ID FROM T_SURAT_TUGAS_PELAPORAN WHERE LAPOR_ID = '".$arr_surat[$idx]."'","SURAT_ID");
		if($last_id!=""){
			$terakhir = $sipt->main->petugas_terakhir($last_id);
			if(count($terakhir) > 0){
				foreach($terakhir as $ptgs){
					$msword->addParagraph('- '.$ptgs,array('text-align' => 'justify'));
				}
			}
		}else{
			$msword->addParagraph('-', array('text-align' => 'justify'));
		}

		$msword->addParagraph('');
		$msword->addParagraph('Ringkasan Hasil Inspeksi Sebelumnya', array('text-align' => 'justify', 'font-weight' => 'bold'));
		$msword->addParagraph(preg_replace('/[^(\x20-\x7F)]*/', "",html_entity_decode($row['RINGKASAN'])), array('text-align' => 'justify'));
		$msword->addParagraph('Ruang Lingkup', array('text-align' => 'justify', 'font-weight' => 'bold'));
		$msword->addParagraph(preg_replace('/[^(\x20-\x7F)]*/', "",html_entity_decode($row['RUANG_LINGKUP'])), array('text-align' => 'justify'));
		$msword->addParagraph('Area Inspeksi', array('text-align' => 'justify', 'font-weight' => 'bold'));
		$msword->addParagraph(preg_replace('/[^(\x20-\x7F)]*/', "",html_entity_decode($row['AREA_INSPEKSI'])), array('text-align' => 'justify'));
		$msword->addParagraph('');
		$msword->addParagraph('TEMUAN DAN OBSERVASI', array('text-align' => 'justify', 'font-weight' => 'bold'));
		$temuan = $sipt->main->get_observasi($idperiksa[0], "OT", "");
		$jmltemuan = count($temuan);
		if($jmltemuan > 1){	
			$currenttemuan = "";
			for($t=0; $t<$jmltemuan; $t++){
				if($temuan[$t]['URAIAN'] != $currenttemuan){
					$msword->addParagraph($temuan[$t]['URAIAN'], array('text-align' => 'justify','font-weight' => 'bold'));
				}
				$msword->addParagraph(preg_replace('/[^(\x20-\x7F)]*/', "",html_entity_decode($temuan[$t]['TEMUAN_TEKS'])), array('text-align' => 'justify'));
				$msword->addParagraph('Kriteria : '. $temuan[$t]['TEMUAN_KRITERIA'], array('text-align' => 'justify'));
				$currenttemuan = $temuan[$t]['URAIAN'];
			}
		}
		$msword->addParagraph('Distribusi dan Pengangkutan', array('text-align' => 'justify', 'font-weight' => 'bold'));
		$msword->addParagraph(trim($row['DISTRIBUSI_PENGANGKUTAN']) != "" ?  preg_replace('/[^(\x20-\x7F)]*/', "",html_entity_decode($row['DISTRIBUSI_PENGANGKUTAN'])): "-", array('text-align' => 'justify'));
		$msword->addParagraph('Pertanyaan Berkaitan dengan Penilaian Permohonan Pendaftaran Produk', array('text-align' => 'justify', 'font-weight' => 'bold'));
		$msword->addParagraph(trim($row['PERMOHONAN_PENDAFTARAN_PRODUK']) != "" ?  preg_replace('/[^(\x20-\x7F)]*/', "",html_entity_decode($row['PERMOHONAN_PENDAFTARAN_PRODUK'])): "-", array('text-align' => 'justify'));
		$msword->addParagraph('Isu Spesifik Lainnya', array('text-align' => 'justify', 'font-weight' => 'bold'));
		$msword->addParagraph(trim($row['ISU_SPESIFIK_LAINNYA']) != "" ?  preg_replace('/[^(\x20-\x7F)]*/', "",html_entity_decode($row['ISU_SPESIFIK_LAINNYA'])): "-", array('text-align' => 'justify'));
		$msword->addParagraph('Site Master File', array('text-align' => 'justify', 'font-weight' => 'bold'));
		$msword->addParagraph(trim($row['SITE_FILE_MASTER']) != "" ?  preg_replace('/[^(\x20-\x7F)]*/', "",$row['SITE_FILE_MASTER']): "-", array('text-align' => 'justify'));
		$msword->addParagraph('Lain-Lain', array('text-align' => 'justify', 'font-weight' => 'bold'));
		$msword->addParagraph(trim($row['LAIN_LAIN']) != "" ?  preg_replace('/[^(\x20-\x7F)]*/', "",html_entity_decode($row['LAIN_LAIN'])): "-", array('text-align' => 'justify'));
		$msword->addParagraph('Sampel yang Diambil', array('text-align' => 'justify', 'font-weight' => 'bold'));
		$msword->addParagraph(trim($row['SAMPEL_DIAMBIL']) != "" ?  preg_replace('/[^(\x20-\x7F)]*/', "",html_entity_decode($row['SAMPEL_DIAMBIL'])): "-", array('text-align' => 'justify'));
$msword->addParagraph('Distribusi Laporan', array('text-align' => 'justify', 'font-weight' => 'bold'));
		$msword->addParagraph(trim($row['DISTRIBUSI_LAPORAN']) != "" ?  preg_replace('/[^(\x20-\x7F)]*/', "",html_entity_decode($row['DISTRIBUSI_LAPORAN'])): "-", array('text-align' => 'justify'));
		$msword->addParagraph('Kesimpulan Observasi', array('text-align' => 'justify', 'font-weight' => 'bold'));
		$msword->addParagraph('Tindak Lanjut Temuan dan Observasi', array('text-align' => 'justify', 'font-weight' => 'bold'));
		$msword->addParagraph(trim($row['TINDAKAN_OBSERVASI']) != "" ?  '<ul style="list-style-type:disc;"><li>'.join('</li><li>', $sel_tindakan_observasi).'</li></ul>': "-", array('text-align' => 'justify'));
		$msword->addParagraph('<table width="100%"><tr><td width="220">1. Temuan Kritikal</td><td width="10">&nbsp;</td><td>'.$row['TEMUAN_KRITIKAL'].'</td></tr><tr><td width="220">2. Temuan Major</td><td width="10">&nbsp;</td><td>'.$row['TEMUAN_MAJOR'].'</td></tr><tr><td width="220">3. Temuan Minor</td><td width="10">&nbsp;</td><td>'.$row['TEMUAN_MINOR'].'</td></tr></table>', array('text-align' => 'justify'));
		
		$msword->addParagraph('Kesimpulan', array('text-align' => 'justify', 'font-weight' => 'bold'));
		$msword->addParagraph('<table width="100%"><tr><td width="220">Hasil Pemeriksaan</td><td width="10">&nbsp;</td><td>'.$row['HASIL'].'</td></tr></table>', array('text-align' => 'justify'));
		$msword->addParagraph('Catatan', array('text-align' => 'justify', 'font-weight' => 'bold'));
		$msword->addParagraph(trim($row['REKOMENDASI']) != "" ?  preg_replace('/[^(\x20-\x7F)]*/', "",html_entity_decode($row['REKOMENDASI'])): "-", array('text-align' => 'justify'));
		
		if($row['HASIL'] == "TMK"){
		$msword->addParagraph('Detil Hasil Pemeriksaan', array('text-align' => 'justify', 'font-weight' => 'bold'));
		$msword->addParagraph(trim($row['DETIL_HASIL']) != "" ?  '<ul style="list-style-type:disc;"><li>'.join('</li><li>', $detil_hasil).'</li></ul>': "-", array('text-align' => 'justify'));
		$msword->addParagraph('Detil Kesimpulan TMK', array('text-align' => 'justify', 'font-weight' => 'bold'));
		$msword->addParagraph(trim($row['KESIMPULAN_DETIL_TMK']) != "" ?  preg_replace('/[^(\x20-\x7F)]*/', "",html_entity_decode($row['KESIMPULAN_DETIL_TMK'])): "-", array('text-align' => 'justify'));
		$msword->addParagraph('<table width="100%"><tr><td colspan="3"><b>Tindak Lanjut</b></td></tr><tr><td width="220">Tindak Lanjut Hasil Inspeksi</td><td width="10">&nbsp;</td><td>'.$row['TINDAK_LANJUT'].'</td></tr><tr><td width="220">Time Line</td><td width="10">&nbsp;</td><td>'.preg_replace('/[^(\x20-\x7F)]*/', "",html_entity_decode($row['TIME_LINE'])).'</td></tr><tr><td colspan="3"><b>C A P A</b></td></tr><tr><td width="220">Hasil Evaluasi CAPA</td><td width="10">&nbsp;</td><td>'.preg_replace('/[^(\x20-\x7F)]*/', "",html_entity_decode($row['STATUS_CAPA'])).'</td></tr></table>', array('text-align' => 'justify', 'font-weight' => 'bold'));
		}
		
		$inspektur = $sipt->main->get_uraian("SELECT STUFF(dbo.GROUP_PETUGAS('$idperiksa[0]'),1,0,'') AS PETUGAS","PETUGAS");
		$inspekturs = explode("-",$inspektur);
		$msword->addParagraph('Nama Inspektur BPOM', array('text-align' => 'justify', 'font-weight' => 'bold'));
		foreach($inspekturs as $ins){
			$msword->addParagraph($ins, array('text-align' => 'justify'));
		}		
		$msword->addParagraph('<div style="height:50px;">&nbsp;</div>', array('text-align' => 'justify', 'font-weight' => 'bold'));
		$msword->addParagraph('Tanggal : '.$tgl[0] .' bulan '. $tgla .' tahun '. $tgl[2], array('text-align' => 'justify'));
		$msword->output('INSPEKSI_CPOTB_'.date('Ymd').".doc");
	}
}
?>