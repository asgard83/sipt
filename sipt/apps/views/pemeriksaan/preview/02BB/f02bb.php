<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR);
class f02bb extends Model{
	function GetForm02BB($sarana, $jenis, $klasifikasi, $idperiksa){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			if(!array_key_exists($jenis, $this->newsession->userdata("SESS_SARANA")) && !array_key_exists($klasifikasi, $this->newsession->userdata("SESS_KLASIFIKASI_ID"))) return $this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
			$sipt =& get_instance();
			$sipt->load->model("main", "main", true);			
			if($idperiksa==""){#Input Mode				  
				 if(!$this->session->userdata('SURAT')) return $this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
				 $qsarana = "SELECT SARANA_ID, NAMA_SARANA, ALAMAT_1, ALAMAT_2, TELEPON, NAMA_PIMPINAN, PENANGGUNG_JAWAB, NOMOR_IZIN, SARANA_BB FROM M_SARANA WHERE SARANA_ID = '$sarana'";
				  $dt_sarana = $sipt->main->get_result($qsarana);
				  if($dt_sarana){
					  foreach($qsarana->result_array() as $row){
						  $arrdata = array('sess' => $row,					
										   'SURAT_ID' => '',								
										   'BBPOM_ID' => $this->newsession->userdata('SESS_BBPOM_ID'),
										   'aspek_check' => '',
										   'aspek_keterangan' => '',
										   'PERIKSA_ID' => '',
										   'act' => site_url().'/post/pemeriksaan/set_periksa/02BB/simpan',
										   'urlback' => site_url().'/home/pelaporan/pemeriksaan');
					  }
				  }				
			}else{#Edit Mode
				$idperiksa = explode(".", $idperiksa);
				$status = $idperiksa[1];
				$qperiksa = "SELECT (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN_BB_PRODUK WHERE PERIKSA_ID='".$idperiksa[0]."') AS JMLTEMUAN, (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN_BB_LAPORAN WHERE PERIKSA_ID='".$idperiksa[0]."') AS JMLLAPORAN,(SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN_PROSES WHERE PERIKSA_ID='".$idperiksa[0]."') AS JML_PROSES, A.SARANA_ID, A.NAMA_SARANA, A.ALAMAT_1, A.ALAMAT_2, A.TELEPON, A.NAMA_PIMPINAN, A.PENANGGUNG_JAWAB, A.SARANA_BB, A.NOMOR_IZIN, A.STATUS_SARANA, B.PERIKSA_ID, B.JENIS_SARANA_ID, B.BBPOM_ID, STUFF(dbo.GROUP_KLASIFIKASI(B.PERIKSA_ID),1,1,'') AS KK_ID, CONVERT(VARCHAR(10), B.AWAL_PERIKSA, 103) AS AWAL_PERIKSA, CONVERT(VARCHAR(10), B.AKHIR_PERIKSA, 103) AS AKHIR_PERIKSA, B.HASIL, C.TUJUAN_PEMERIKSAAN, C.PRODUK, C.ASPEK_PRODUK, C.ASPEK_CHECK, C.ASPEK_KETERANGAN, C.REKOMENDASI, RTRIM(LTRIM(C.TINDAK_LANJUT)) AS TINDAK_LANJUT, C.KEBIJAKAN, C.CATATAN, C.HASIL_UJI, C.KODE_SAMPEL, C.LAMPIRAN, STUFF(dbo.GROUP_CONCAT(B.PERIKSA_ID),1,1,'') AS SURAT_ID FROM M_SARANA A LEFT JOIN T_PEMERIKSAAN B ON A.SARANA_ID = B.SARANA_ID LEFT JOIN T_PEMERIKSAAN_BB C ON B.PERIKSA_ID = C.PERIKSA_ID WHERE B.SARANA_ID = '".$sarana."' AND B.PERIKSA_ID = '".$idperiksa[0]."'";
				  $dt_periksa = $sipt->main->get_result($qperiksa);
				  if($dt_periksa){
					  foreach($qperiksa->result_array() as $row){
						  $arrdata = array('sess' => $row,
										   'urlback' => site_url().'/home/pelaporan/pemeriksaan/view/'.$status);
					  }					  
					  $arrdata['SURAT_ID'] = $row['SURAT_ID'];
					  $arrdata['BBPOM_ID'] = $row['BBPOM_ID'];
					  $arrdata['PERIKSA_ID'] = $row['PERIKSA_ID'];
					  $jenis_produk = explode("#", trim($row['PRODUK']));
					  $arrdata['divproduk'] = $jenis_produk;
					  $arrdata['aspek_check'] = explode("#", trim($row['ASPEK_CHECK']));
					  $arrdata['aspek_keterangan'] = explode("#", trim($row['ASPEK_KETERANGAN']));
					  $arrdata['arrtl'] = explode("#", $row['TINDAK_LANJUT']);
					  $chk_produk = explode("|",$row['ASPEK_PRODUK']);
					  $arrdata['formalin'] = explode(",",$chk_produk[0]);
					  $arrdata['serbuk'] = explode(",",$chk_produk[1]);
					  $arrdata['tablet'] = explode(",",$chk_produk[2]);
					  $arrdata['boraks'] = explode(",",$chk_produk[3]);
					  $arrdata['rhodamin'] = explode(",",$chk_produk[4]);
					  $arrdata['metanil'] = explode(",",$chk_produk[5]);
					  $arrdata['auramin'] = explode(",",$chk_produk[6]);
					  $arrdata['amaran'] = explode(",",$chk_produk[7]);
					  $arrdata['laporan_bb'] = $this->db->query("SELECT PERIKSA_ID, PRODUK_BB, CASE WHEN PRODUK_BB = '01' THEN 'Larutan Formaldehid (Formalin)' WHEN PRODUK_BB = '02' THEN 'Paraformaldehid serbuk' WHEN PRODUK_BB = '03' THEN 'Paraformaldehidtablet' WHEN PRODUK_BB = '04' THEN 'Boraks' WHEN PRODUK_BB = '05' THEN 'Rhodamin B' WHEN PRODUK_BB = '06' THEN 'Kuning Metanil' WHEN PRODUK_BB = '07' THEN 'Auramin' WHEN PRODUK_BB = '08' THEN 'Amaran' END AS UR_PRODUK_BB, PENGADAAN_SARANA, PENGADAAN_ALAMAT, dbo.GET_PROPINSI(PENGADAAN_DAERAH_ID) AS UR_PENGADAAN_DAERAH_ID, PENGADAAN_STATUS, PENGADAAN_KEMASAN, DISTRIBUSI_SARANA, DISTRIBUSI_ALAMAT, PENGADAAN_DAERAH_ID, DISTRIBUSI_DAERAH_ID, dbo.GET_PROPINSI(DISTRIBUSI_DAERAH_ID) AS UR_DISTRIBUSI_DAERAH_ID, DISTRIBUSI_JENIS, DISTRIBUSI_TUJUAN, KEMASAN, REPACKING, CASE WHEN REPACKING = 'T' THEN 'Tidak' WHEN REPACKING = 'Y' THEN 'Ya' END AS UR_REPACKING, PENGADAAN_STATUS FROM T_PEMERIKSAAN_BB_LAPORAN WHERE PERIKSA_ID = '".$idperiksa[0]."'")->result_array();
					  $arrdata['produk_bb'] = $this->db->query("SELECT PERIKSA_ID, SERI, NAMA_BB, NAMA_PRODUK, KEMASAN, KLASIFIKASI_PRODUK, SUMBER_PENGADAAN, NAMA_PERUSAHAAN, ALAMAT_PERUSAHAAN, TELEPON, CARA_PEMBELIAN, STATUS_REPACKING, LAMPIRAN FROM T_PEMERIKSAAN_TEMUAN_PRODUK WHERE PERIKSA_ID = '".$idperiksa[0]."'")->result_array();
				  }
				  if($this->newsession->userdata('SESS_BBPOM_ID') != "96"){#Update dan Perbaikan Balai
					  if($status=="20101"){
						  $arrdata['act'] = site_url().'/post/pemeriksaan/set_periksa/02BB/update';
					  }else if($status=="20102" || $status =="20103"){
						  $arrdata['act'] = site_url().'/post/pemeriksaan/set_periksa/02BB/perbaikan';
					  }
				  }else{#Update dan Perbaikan Pusat
					  if($status=="20111"){
						  $arrdata['act'] = site_url().'/post/pemeriksaan/set_periksa/02BB/update';
					  }else if($status =="20113" || $status =="20112"){
						  $arrdata['act'] = site_url().'/post/pemeriksaan/set_periksa/02BB/perbaikan';
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
			$arrdata['tujuan_pemeriksaan'] = $sipt->main->referensi("TUJUAN_PEMERIKSAAN", "'1','2','30'",TRUE,TRUE);
			$arrdata['klasifikasi_temuan'] = $sipt->main->referensi("KLASIFIKASI_TEMUAN","'01','02'",TRUE,TRUE);
			$arrdata['hasil'] = $sipt->main->referensi("HASIL","'TMK','MK','TTP','TMBB'",FALSE,TRUE);
			$arrdata['propinsi'] = $sipt->main->combobox("SELECT PROPINSI_ID, NAMA_PROPINSI FROM M_PROPINSI WHERE RIGHT(PROPINSI_ID, 2) = '00'", "PROPINSI_ID", "NAMA_PROPINSI", TRUE);
			$arrdata['sarana_bb'] = $sipt->main->combobox("SELECT RTRIM(KODE) AS KODE, URAIAN FROM M_STATUS WHERE JENIS = 'STATUS_BB'", "KODE", "URAIAN", TRUE);
			$arrdata['status_bb'] = array("0" => array("" => "", "IT-B2" => "IT-B2", "IT-B2C" => "IT-B2 Cabang", "DT-B2" => "DT-B2", "DT-B2C" => "DT-B2 Cabang", "PT-B2" => "PT-B2","STB" => "Sarana Tidak Berizin"), "1" => array("" => "", "IT-B2" => "IT-B2", "IT-B2C" => "IT-B2 Cabang", "DT-B2" => "DT-B2", "DT-B2C" => "DT-B2 Cabang", "PT-B2" => "PT-B2","IP-B2" => "IP-B2", "STB" => "Sarana Tidak Berizin","PR" => "Produsen","SF" => "Sarana Fiktif"),"3" => array("" => "", "01" => "Peringatan Tertulis", "02" => "Penghentian Sementara Kegiatan", "03" => "Pencabutan Izin Usaha Khusus", "04" => "Pencabutan Izin Usaha Umum", "05" => "Kebijakan Lain"), "4" => array("" => "", "IT-B2" => "IT-B2", "IT-B2C" => "IT-B2 Cabang", "DT-B2" => "DT-B2", "DT-B2C" => "DT-B2 Cabang", "PT-B2" => "PT-B2","STB" => "Sarana Tidak Berizin","SF" => "Sarana Fiktif", "PA" => "Pengguna Akhir"));
			$arrdata['status_sarana'] = array("" => "","1" => "Aktif", "4" => "Tidak Menyalurkan Bahan Berbahaya Lagi", "0" => "Tutup");
			$arrdata['tindak_lanjut'] = array("" => "", "01" => "Rekomendasi", "02" => "Inventarisasi", "03" => "Larangan Mengedarkan Sementara", "04" => "Pengambilan Contoh");
			$arrdata['hasil_uji'] = array("" => "", "Positif" => "Positif Bahan Berbahaya", "Negatif" => "Negatif Bahan Berbahaya", "Pending" => "Menunggu Hasil Uji Lab");
			$arrdata['kemasan'] = $sipt->main->combobox("SELECT KEMASAN_ID, CASE WHEN JENIS = '1' THEN 'Keperluan Tidak Untuk Pangan' WHEN JENIS = '2' THEN  'Laboratorium / Penelitian' END + ' - ' + NAMA AS 'KEMASAN_MINIMAL' FROM M_KEMASAN_BB", "KEMASAN_ID", "KEMASAN_MINIMAL", TRUE);	  
			$arrdata['log_bb'] = $this->db->query("SELECT D.URAIAN AS STATUS_BB, CONVERT(VARCHAR(10), B.WAKTU, 103) AS [UPDATE], C.NAMA_USER FROM M_LOG_SARANA_BB B LEFT JOIN M_SARANA A ON B.SARANA_ID = A.SARANA_ID LEFT JOIN T_USER C ON B.CREATE_BY = C.USER_ID LEFT JOIN M_STATUS D ON B.SARANA_BB = LTRIM(D.KODE) WHERE B.SARANA_ID = '".$sarana."' AND D.JENIS = 'STATUS_BB'")->result_array();
			$arrdata['histori_petugas'] = site_url().'/load/petugas/get_petugas/'.$arrdata['SURAT_ID'];
			$arrdata['url_izin'] = site_url().'/get/distribusi/set_izin/'.$jenis.'/'.$sarana;
			$arrdata['history_periksa'] = site_url().'/get/pemeriksaan/set_detail_periksa/'.$sarana."/".$jenis.'/'.$idperiksa;
			return $arrdata;
		}
		else
		{
			$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
		}
	}
	
	function SaveForm02BB($action, $isajax){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main","main", true);
			
			if(in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')))
				$status = '20111';
			else
				$status = '20101';
			$ret = "MSG#NO#Data gagal disimpan#";
			$formalin = join(",",$this->input->post('formalin'));
			$serbuk = join(",",$this->input->post('serbuk'));
			$tablet = join(",",$this->input->post('tablet'));
			$boraks = join(",",$this->input->post('boraks'));
			$rhodamin = join(",",$this->input->post('rhodamin'));
			$metanil = join(",",$this->input->post('metanil'));
			$auramin = join(",",$this->input->post('auramin'));
			$amaran = join(",",$this->input->post('amaran'));
			$aspek_produk = $formalin . "|". $serbuk . "|" .$tablet . "|" .$boraks ."|" .$rhodamin ."|" .$metanil . "|" .$auramin ."|" .$amaran;
			$tindak_lanjut = join("#",$this->input->post('TINDAK_LANJUT'));
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
					$this->db->simple_query("UPDATE M_SARANA SET SARANA_BB = '".$this->input->post('STATUS_BB')."', STATUS_SARANA = '".$this->input->post('STATUS_SARANA')."' WHERE SARANA_ID = '".$this->input->post('SARANA_ID')."'");
					$arr_klasifikasi = explode("-", $this->input->post('KLASIFIKASI'));
					$arr_bb = array('PERIKSA_ID' => $periksa_id);
					foreach($this->input->post('PEMERIKSAAN_DIST_BB') as $c => $d){
						if(!is_array($d))
							$arr_bb[$c] = $d;
						else
							$arr_bb[$c] = join("#", $d);
					}
					$arr_bb['ASPEK_PRODUK'] = $aspek_produk;
					$arr_bb['TINDAK_LANJUT'] = $tindak_lanjut;
					$this->db->insert('T_PEMERIKSAAN_BB', $arr_bb);
					
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
											'KK_ID' => '015',
											'FLAG' => 0);
							for($j=0;$j<count($arrkeys);$j++){
								$temuan[$arrkeys[$j]] = $arrtemuan[$arrkeys[$j]][$i];
							}
							$this->db->insert('T_PEMERIKSAAN_TEMUAN_PRODUK', $temuan);
						}
					}
					if($this->input->post('LAPORAN_BB')){					
						$arr_laporan = $this->input->post('LAPORAN_BB');
						$arr_keys = array_keys($arr_laporan);
						for($i=0;$i<count($arr_laporan[$arr_keys[0]]);$i++){
							$seri = (int)$sipt->main->get_uraian("SELECT MAX(SERI) AS MAXID FROM T_PEMERIKSAAN_BB_LAPORAN WHERE PERIKSA_ID = '$periksa_id'", "MAXID") + 1;
							$laporan_bb = array('PERIKSA_ID' => $periksa_id,
											    'SERI' => $seri);
							for($j=0;$j<count($arr_keys);$j++){
								$laporan_bb[$arr_keys[$j]] = $arr_laporan[$arr_keys[$j]][$i];
							}
							$this->db->insert('T_PEMERIKSAAN_BB_LAPORAN', $laporan_bb);
							if($laporan_bb['PENGADAAN_ID'] == "" || ($laporan_bb['PENGADAAN_DAERAH_ID'] <> $this->newsession->userdata('SESS_PROP_ID'))){
								$id_tmp = (int)$sipt->main->get_uraian("SELECT MAX(ID_TMP) AS MAXID FROM T_NOTIF_TMPBB", "MAXID") + 1;
								$arrtmp = array('ID_TMP' => $id_tmp,
												'SARANA_ID' => $laporan_bb['PENGADAAN_ID'],
												'ISPERIKSA' => 1,
												'NAMA_SARANA' => $laporan_bb['PENGADAAN_SARANA'],
												'DAERAH_ID' => $laporan_bb['PENGADAAN_DAERAH_ID'],
												'BBPOM_ID' => $this->newsession->userdata('SESS_BBPOM_ID'),
												'CREATED' => 'GETDATE()',
												'CREATE_BY' => $this->newsession->userdata('SESS_USER_ID'));
								$this->db->insert('T_NOTIF_TMPBB', $arrtmp);				
							}
							
							if($laporan_bb['DISTRIBUSI_ID '] == "" || ($laporan_bb['DISTRIBUSI_DAERAH_ID'] <> $this->newsession->userdata('SESS_PROP_ID'))){
								$id_tmp = (int)$sipt->main->get_uraian("SELECT MAX(ID_TMP) AS MAXID FROM T_NOTIF_TMPBB", "MAXID") + 1;
								$arrtmp = array('ID_TMP' => $id_tmp,
												'SARANA_ID' => $laporan_bb['DISTRIBUSI_ID'],
												'ISPERIKSA' => 1,
												'NAMA_SARANA' => $laporan_bb['DISTRIBUSI_SARANA'],
												'DAERAH_ID' => $laporan_bb['DISTRIBUSI_DAERAH_ID'],
												'BBPOM_ID' => $this->newsession->userdata('SESS_BBPOM_ID'),
												'CREATED' => 'GETDATE()',
												'CREATE_BY' => $this->newsession->userdata('SESS_USER_ID'));
								$this->db->insert('T_NOTIF_TMPBB', $arrtmp);				
							}
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
			}else if($action=="update" || $action=="perbaikan"){#Update Mode
				$arr_pemeriksaan = array('UPDATE_BY' => $this->newsession->userdata('SESS_USER_ID'),'LAST_UPDATE' => 'GETDATE()');
				foreach($this->input->post('PEMERIKSAAN') as $a => $b){
				  $arr_pemeriksaan[$a] = $b;
				}
				if($action=="perbaikan"){
					if($this->newsession->userdata('SESS_BBPOM_ID') != "96"){
					  $arr_pemeriksaan['STATUS'] = '30104';
					  $status = "30104";
					}else{
					  $arr_pemeriksaan['STATUS'] = '30114';
					  $status = "30114";
					}
				}		
				$this->db->where(array("PERIKSA_ID" => $this->input->post('PERIKSA_ID')));	
				if($this->db->update('T_PEMERIKSAAN', $arr_pemeriksaan)){
					$this->db->simple_query("UPDATE M_SARANA SET SARANA_BB = '".$this->input->post('STATUS_BB')."', STATUS_SARANA = '".$this->input->post('STATUS_SARANA')."' WHERE SARANA_ID = '".$this->input->post('SARANA_ID')."'");
					
					foreach($this->input->post('PEMERIKSAAN_DIST_BB') as $c => $d){
						if(!is_array($d))
							$arr_bb[$c] = $d;
						else
							$arr_bb[$c] = join("#", $d);
					}
					$arr_bb['ASPEK_PRODUK'] = $aspek_produk;
					$arr_bb['TINDAK_LANJUT'] = $tindak_lanjut;
					$this->db->where(array("PERIKSA_ID" => $this->input->post('PERIKSA_ID')));
					$this->db->update('T_PEMERIKSAAN_BB', $arr_bb);
					
					if($this->input->post('LAPORAN_BB')){
						$this->db->where('PERIKSA_ID', $this->input->post('PERIKSA_ID'));
						$this->db->delete('T_PEMERIKSAAN_BB_LAPORAN');
						$arr_laporan = $this->input->post('LAPORAN_BB');
						$arr_keys = array_keys($arr_laporan);
						for($i=0;$i<count($arr_laporan[$arr_keys[0]]);$i++){
							$seri = (int)$sipt->main->get_uraian("SELECT MAX(SERI) AS MAXID FROM T_PEMERIKSAAN_BB_LAPORAN WHERE PERIKSA_ID = '".$this->input->post('PERIKSA_ID')."'", "MAXID") + 1;
							$laporan_bb = array('PERIKSA_ID' => $this->input->post('PERIKSA_ID'),
											'SERI' => $seri);
							for($j=0;$j<count($arr_keys);$j++){
								$laporan_bb[$arr_keys[$j]] = $arr_laporan[$arr_keys[$j]][$i];
							}
							$this->db->insert('T_PEMERIKSAAN_BB_LAPORAN', $laporan_bb);
							if($laporan_bb['PENGADAAN_ID'] == "" || ($laporan_bb['PENGADAAN_DAERAH_ID'] <> $this->newsession->userdata('SESS_PROP_ID'))){
								$id_tmp = (int)$sipt->main->get_uraian("SELECT MAX(ID_TMP) AS MAXID FROM T_NOTIF_TMPBB", "MAXID") + 1;
								$arrtmp = array('ID_TMP' => $id_tmp,
												'SARANA_ID' => $laporan_bb['PENGADAAN_ID'],
												'ISPERIKSA' => 1,
												'NAMA_SARANA' => $laporan_bb['PENGADAAN_SARANA'],
												'DAERAH_ID' => $laporan_bb['PENGADAAN_DAERAH_ID'],
												'BBPOM_ID' => $this->newsession->userdata('SESS_BBPOM_ID'),
												'CREATED' => 'GETDATE()',
												'CREATE_BY' => $this->newsession->userdata('SESS_USER_ID'));
								$this->db->insert('T_NOTIF_TMPBB', $arrtmp);				
							}
							
							if($laporan_bb['DISTRIBUSI_ID '] == "" || ($laporan_bb['DISTRIBUSI_DAERAH_ID'] <> $this->newsession->userdata('SESS_PROP_ID'))){
								$id_tmp = (int)$sipt->main->get_uraian("SELECT MAX(ID_TMP) AS MAXID FROM T_NOTIF_TMPBB", "MAXID") + 1;
								$arrtmp = array('ID_TMP' => $id_tmp,
												'SARANA_ID' => $laporan_bb['DISTRIBUSI_ID'],
												'ISPERIKSA' => 1,
												'NAMA_SARANA' => $laporan_bb['DISTRIBUSI_SARANA'],
												'DAERAH_ID' => $laporan_bb['DISTRIBUSI_DAERAH_ID'],
												'BBPOM_ID' => $this->newsession->userdata('SESS_BBPOM_ID'),
												'CREATED' => 'GETDATE()',
												'CREATE_BY' => $this->newsession->userdata('SESS_USER_ID'));
								$this->db->insert('T_NOTIF_TMPBB', $arrtmp);				
							}
						}
					}
					
					if($this->input->post('TEMUAN_PRODUK')){					
						$arrtemuan = $this->input->post('TEMUAN_PRODUK');
						$arrkeys = array_keys($arrtemuan);
						for($i=0;$i<count($arrtemuan[$arrkeys[0]]);$i++){
							$seri = (int)$sipt->main->get_uraian("SELECT MAX(SERI) AS MAXID FROM T_PEMERIKSAAN_TEMUAN_PRODUK WHERE PERIKSA_ID = '$periksa_id'", "MAXID") + 1;
							$temuan = array('PERIKSA_ID' => $periksa_id,
											'SERI' => $seri,
											'KK_ID' => '015',
											'FLAG' => 0);
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
										'CATATAN' => 'Update Pemeriksaan sarana status draft',
										'CREATE_BY' => $this->newsession->userdata('SESS_USER_ID'),
										'CREATE_DATE' => 'GETDATE()');
					if($action=="update"){
						$arr_log['CATATAN'] = 'Update Pemeriksaan sarana status draft';
						$sipt->main->get_kegiatan("Mengupdate Data Pemeriksaan Untuk Sarana : ".$this->input->post('NAMA_SARANA'));
					}else if($action=="perbaikan"){
						$arr_log['CATATAN'] = $this->input->post('catatan');
						 $sipt->main->get_kegiatan("Melakukan Perbaikan Data Pemeriksaan Untuk Sarana : ".$this->input->post('NAMA_SARANA'));
					}
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
					}else if($action=="perbaikan"){
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
		$query = "SELECT A.SARANA_BB, A.STATUS_SARANA, (CAST(B.SARANA_ID AS VARCHAR) + '/' + B.JENIS_SARANA_ID + '/' + STUFF(dbo.GROUP_KLASIFIKASI(B.PERIKSA_ID),1,1,'') + '/' + CAST(B.PERIKSA_ID AS VARCHAR) + '.' + B.STATUS) AS IDPERIKSA, CONVERT(VARCHAR(10), B.AWAL_PERIKSA, 103) AS [AWAL_PERIKSA], CONVERT(VARCHAR(10), B.AKHIR_PERIKSA, 103) AS [AKHIR_PERIKSA], B.HASIL,STUFF(dbo.GROUP_CONCAT(B.PERIKSA_ID),1,1,'') AS SURAT_ID, C.TUJUAN_PEMERIKSAAN, C.PRODUK, CASE WHEN C.TINDAK_LANJUT = '01' THEN 'Rekomendasi' WHEN C.TINDAK_LANJUT = '02' THEN 'Inventarisasi' WHEN C.TINDAK_LANJUT = '03' THEN 'Pengamanan Setempat' WHEN C.TINDAK_LANJUT = '04' THEN 'Pengambilan Contoh' END AS TINDAK_LANJUT, CASE WHEN C.REKOMENDASI = '01' THEN 'Peringatan Tertulis' WHEN C.REKOMENDASI = '02' THEN 'Penghentian Sementara Kegiatan' WHEN C.REKOMENDASI = '03' THEN 'Pencabutan Izin Usaha Khusus' WHEN C.REKOMENDASI = '04' THEN 'Rekomendas Izin Usaha Umum' WHEN C.REKOMENDASI = '05' THEN 'Kebijakan Lain' END AS REKOMENDASI, C.KEBIJAKAN, C.CATATAN FROM M_SARANA A LEFT JOIN T_PEMERIKSAAN B ON A.SARANA_ID = B.SARANA_ID LEFT JOIN T_PEMERIKSAAN_BB C ON B.PERIKSA_ID = C.PERIKSA_ID WHERE A.SARANA_ID ='$sarana' AND B.PERIKSA_ID = '$id[0]'";
		$judul = $sipt->main->get_judul($jenis);
		$data = $sipt->main->get_result($query);
		if($data){
			foreach($query->result_array() as $row){
				$arrdata = array('sess' => $row, 'judul' => $judul);
			}
			$arrdata['histori_petugas'] = site_url().'/load/petugas/get_petugas/'.$row['SURAT_ID'];
			$aspek = explode("#", $row['PRODUK']);
			$inisal = array("01", "02", "03", "04","05", "06", "07", "08");
			$ganti = array("Formaldehid (formalin)", "Paraformaldehid serbuk", "Paraformaldehid tablet", "Boraks", "Rhodamin B", "Kuning Metanil","Auramin","Amaran");
			$arrdata['produk'] = str_replace($inisal, $ganti, $aspek); 
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
			$query = "SELECT (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN_BB_PRODUK WHERE PERIKSA_ID='".$idperiksa[0]."') AS JMLTEMUAN, (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN_BB_LAPORAN WHERE PERIKSA_ID='".$idperiksa[0]."') AS JMLLAPORAN,(SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN_PROSES WHERE PERIKSA_ID='".$idperiksa[0]."') AS JML_PROSES, A.SARANA_ID, A.NAMA_SARANA, A.ALAMAT_1, A.ALAMAT_2, A.TELEPON, A.NAMA_PIMPINAN, A.PENANGGUNG_JAWAB, A.SARANA_BB, A.NOMOR_IZIN, CASE WHEN A.STATUS_SARANA = '0' THEN 'Tutup' WHEN A.STATUS_SARANA = '1' THEN 'Aktif' WHEN A.STATUS_SARANA = '4' THEN 'Tidak Menyalurkan Bahan Berbahaya Lagi' END AS STATUS_SARANA, B.PERIKSA_ID, B.JENIS_SARANA_ID, B.BBPOM_ID, STUFF(dbo.GROUP_KLASIFIKASI(B.PERIKSA_ID),1,1,'') AS KK_ID, CONVERT(VARCHAR(10), B.AWAL_PERIKSA, 103) AS AWAL_PERIKSA, CONVERT(VARCHAR(10), B.AKHIR_PERIKSA, 103) AS AKHIR_PERIKSA, B.HASIL, B.HASIL_PUSAT, C.TUJUAN_PEMERIKSAAN, C.PRODUK, C.ASPEK_PRODUK, C.ASPEK_CHECK, C.ASPEK_KETERANGAN, CASE WHEN C.REKOMENDASI = '01' THEN 'Peringatan Tertulis' WHEN C.REKOMENDASI = '02' THEN 'Penghentian Sementara Kegiatan' WHEN C.REKOMENDASI = '03' THEN 'Pencabutan Izin Usaha Khusus' WHEN C.REKOMENDASI = '04' THEN 'Rekomendas Izin Usaha Umum' WHEN C.REKOMENDASI = '05' THEN 'Kebijakan Lain' END AS REKOMENDASI, CASE WHEN C.TINDAK_LANJUT = '01' THEN 'Rekomendasi' WHEN C.TINDAK_LANJUT = '02' THEN 'Inventarisasi' WHEN C.TINDAK_LANJUT = '03' THEN 'Pengamanan Setempat' WHEN C.TINDAK_LANJUT = '04' THEN 'Pengambilan Contoh' END AS UR_TINDAK_LANJUT, RTRIM(LTRIM(C.TINDAK_LANJUT)) AS TINDAK_LANJUT, C.KEBIJAKAN, C.CATATAN, C.HASIL_UJI, C.KODE_SAMPEL, C.LAMPIRAN, STUFF(dbo.GROUP_CONCAT(B.PERIKSA_ID),1,1,'') AS SURAT_ID FROM M_SARANA A LEFT JOIN T_PEMERIKSAAN B ON A.SARANA_ID = B.SARANA_ID LEFT JOIN T_PEMERIKSAAN_BB C ON B.PERIKSA_ID = C.PERIKSA_ID WHERE B.SARANA_ID = '".$sarana."' AND B.PERIKSA_ID = '".$idperiksa[0]."'";
			$data = $sipt->main->get_result($query);
			if($data){
					foreach($query->result_array() as $row){
						$arrdata = array('sess' => $row,
										 'urlback' => site_url().'/home/pelaporan/pemeriksaan/view/'.substr($jenis,0,2));
					}
					$arrdata['SURAT_ID'] = $row['SURAT_ID'];
					$arrdata['BBPOM_ID'] = $row['BBPOM_ID'];
					$arrdata['PERIKSA_ID'] = $row['PERIKSA_ID'];
					$jenis_produk = explode("#", $row['PRODUK']);
					$inisal_produk = array("01", "02", "03", "04","05", "06", "07", "08");
					$ganti_produk = array("Formaldehid (formalin)", "Paraformaldehid serbuk", "Paraformaldehid tablet", "Boraks", "Rhodamin B", "Kuning Metanil","Auramin","Amaran");
					$arrdata['arrtl'] = explode("#", $row['TINDAK_LANJUT']);
					$arrdata['jenis_produk'] = str_replace($inisal_produk, $ganti_produk, $jenis_produk); 
					$arrdata['divproduk'] = $jenis_produk;
					$arrdata['aspek_check'] = explode("#", $row['ASPEK_CHECK']);
					$arrdata['aspek_keterangan'] = explode("#", $row['ASPEK_KETERANGAN']);
					$chk_produk = explode("|",$row['ASPEK_PRODUK']);
					$aspek = explode("#", $row['TINDAK_LANJUT']);
					$inisal = array("01", "02", "03", "04");
					$ganti = array("Rekomendasi", "Inventarisasi", "Larangan Mengedarkan Sementara", "Pengambilan Contoh");
					$arrdata['tindak_lanjut'] = str_replace($inisal, $ganti, $aspek); 
					$arrdata['formalin'] = explode(",",$chk_produk[0]);
					$arrdata['serbuk'] = explode(",",$chk_produk[1]);
					$arrdata['tablet'] = explode(",",$chk_produk[2]);;
					$arrdata['boraks'] = explode(",",$chk_produk[3]);;
					$arrdata['rhodamin'] = explode(",",$chk_produk[4]);
					$arrdata['metanil'] = explode(",",$chk_produk[5]);;
					$arrdata['auramin'] = explode(",",$chk_produk[6]);;
					$arrdata['amaran'] = explode(",",$chk_produk[7]);

			}
			if(array_key_exists('2', $this->newsession->userdata('SESS_KODE_ROLE'))){#Operator
				$arrdata['act'] = site_url().'/post/pemeriksaan/set_proses/02BB/operator';
				$arrdata['obj_status'] = 'OPERATOR[STATUS]';
				$arrdata['obj_hasil'] = 'OPERATOR[HASIL_PUSAT]';
			}else if(array_key_exists('3', $this->newsession->userdata('SESS_KODE_ROLE'))){#Supervisor Satu
				$arrdata['act'] = site_url().'/post/pemeriksaan/set_proses/02BB/spv-satu';
				$arrdata['obj_status'] = 'SUPERVISOR[STATUS]';
				$arrdata['obj_hasil'] = 'SUPERVISOR[HASIL_PUSAT]';
			}else if(array_key_exists('4', $this->newsession->userdata('SESS_KODE_ROLE'))){#Supervisor Lanjutan
				$arrdata['act'] = site_url().'/post/pemeriksaan/set_proses/02BB/spv-dua';
				$arrdata['obj_status'] = 'SUPERVISOR[STATUS]';
				$arrdata['obj_hasil'] = 'SUPERVISOR[HASIL_PUSAT]';
			}else if(array_key_exists('5', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('6', $this->newsession->userdata('SESS_KODE_ROLE'))){
			  $arrdata['obj_status'] = 'VERIFIKASI[STATUS]';
			  $arrdata['act'] = site_url().'/post/pemeriksaan/set_proses/02BB/56';
			}
			if($subid!=""){
				$isverifikasi = FALSE;
			}else{
				$isverifikasi = TRUE;
			}
			$arrdata['headersarana'] = $judul;
			#$pusat = $sipt->main->get_uraian("SELECT BBPOM_ID FROM T_PEMERIKSAAN WHERE PERIKSA_ID = '".$idperiksa[0]."'","BBPOM_ID");
			#if($pusat != $this->newsession->userdata('SESS_BBPOM_ID'))
				#$arrdata['status'] = $sipt->main->set_verifikasi($stat, $this->newsession->userdata('SESS_JENIS_PELAPORAN'), $this->newsession->userdata('SESS_KODE_ROLE'));
			#else
				#$arrdata['status'] = $sipt->main->verifikasi_direktur($stat, $this->newsession->userdata('SESS_JENIS_PELAPORAN'), $this->newsession->userdata('SESS_KODE_ROLE'));
			if(array_key_exists('6', $this->newsession->userdata('SESS_KODE_ROLE'))){
				$arrdata['status'] = $sipt->main->verifikasi_direktur($stat, $this->newsession->userdata('SESS_JENIS_PELAPORAN'), $this->newsession->userdata('SESS_KODE_ROLE'));
			}else{
				$arrdata['status'] = $sipt->main->set_verifikasi($stat, $this->newsession->userdata('SESS_JENIS_PELAPORAN'), $this->newsession->userdata('SESS_KODE_ROLE'));
			}
			$arrdata['disverifikasi'] = $stat;
			$arrdata['hasil'] = $sipt->main->referensi("HASIL","'TMK','MK','TTP','TMBB'",FALSE,TRUE);
			$arrdata['isverifikasi'] = $isverifikasi;
			$arrdata['histori_petugas'] = site_url().'/load/petugas/get_petugas/'.$arrdata['SURAT_ID'];
			$arrdata['history_periksa'] = site_url().'/get/pemeriksaan/set_detail_periksa/'.$sarana."/".$jenis.'/'.$idperiksa;
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
		$query = "SELECT SERI, JENIS_IZIN AS [JENIS IZIN], NOMOR_IZIN AS [NOMOR IZIN], CONVERT(VARCHAR(10), TANGGAL_IZIN, 103) AS [TANGGAL DIKELUARKAN IZIN], CONVERT(VARCHAR(10), TANGGAL_EXPIRED, 103) AS [MASA BERLAKU IZIN], BAHAN_BERBAHAYA AS [BB Yang DIKELOLA] FROM M_SARANA_IZIN WHERE SARANA_ID = '$sarana'";
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
			$query = "SELECT (CAST(A.SARANA_ID AS VARCHAR) + '/' + A.JENIS_SARANA_ID + '/' + STUFF(dbo.GROUP_KLASIFIKASI(A.PERIKSA_ID),1,1,'') + '/' + CAST(A.PERIKSA_ID AS VARCHAR) + '.' + A.STATUS + '/1') AS IDPERIKSA, A.PERIKSA_ID, A.SARANA_ID, A.JENIS_SARANA_ID, CONVERT(VARCHAR(10), A.AWAL_PERIKSA, 103) AS [AWAL PERIKSA], CONVERT(VARCHAR(10), A.AKHIR_PERIKSA, 103) AS [AKHIR PERIKSA], A.HASIL, C.URAIAN AS [STATUS PEMERIKSAAN] FROM T_PEMERIKSAAN A LEFT JOIN T_PEMERIKSAAN_BB B ON A.PERIKSA_ID = B.PERIKSA_ID LEFT JOIN M_TABEL C ON A.STATUS = C.KODE WHERE A.SARANA_ID = '$sarana' AND C.JENIS='STATUS' AND A.STATUS IN ('20')";
			$tabel = $this->newtable->generate($query);
			$tabel .= "<script type=\"text/javascript\" src=\"".base_url()."js/newtable.js\"></script>";
			return $tabel;
		}else{
			$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
		}
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
	
	function notif($isperiksa){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$sipt->load->model("main", "main", true);
			$this->load->library('newtable');
			$this->newtable->hiddens(array('ID_TMP'));
			$this->newtable->action(site_url()."/home/notifikasi/bahan-berbahaya/".$isperiksa);
			$this->newtable->cidb($this->db);
			$this->newtable->ciuri($this->uri->segment_array());
			$this->newtable->orderby(1);
			$this->newtable->sortby("ASC");
			$this->newtable->keys(array('ID_TMP'));
			$this->newtable->search(array(array("A.NAMA_SARANA", "Nama Sarana"), array("B.NAMA_BBPOM", "Asal Balai Besar / Balai POM")));
			
			$this->newtable->menu($proses);
			if($this->newsession->userdata('SESS_PROP_ID') == '7100'){
				$prop = "'7100','8200'";
			}else if($this->newsession->userdata('SESS_PROP_ID') == '7300'){
				$prop = "'7300','7600'";
			}else{
				$prop = $this->newsession->userdata('SESS_PROP_ID');
			}
			if($isperiksa == "new")
				$stts = '1';
			else	
				$stts = '0';
				
			if($this->newsession->userdata('SESS_BBPOM_ID') != '96')	
			$query = "SELECT A.ID_TMP, A.NAMA_SARANA AS 'NAMA SARANA', B.NAMA_BBPOM AS 'ASAL ENTRI', C.NAMA_USER AS 'PETUGAS ENTRI', 
CONVERT(VARCHAR(10), A.CREATED, 120) AS 'TANGGAL ENTRI', CASE WHEN A.SARANA_ID = '0' THEN 'Tidak Terdapat Di Master Data' WHEN A.SARANA_ID <> '0' THEN 'Terdapat Di Master Data' END AS [STATUS SARANA], 'Segera ditindak lanjuti' AS [AKSI] FROM T_NOTIF_TMPBB A LEFT JOIN M_BBPOM B ON A.BBPOM_ID = B.BBPOM_ID LEFT JOIN T_USER C ON A.CREATE_BY = C.USER_ID WHERE A.DAERAH_ID IN ($prop) AND ISPERIKSA = '".$stts."'";
			else
			$query = "SELECT A.ID_TMP, A.NAMA_SARANA AS 'NAMA SARANA', B.NAMA_BBPOM AS 'ASAL ENTRI', C.NAMA_USER AS 'PETUGAS ENTRI', 
CONVERT(VARCHAR(10), A.CREATED, 120) AS 'TANGGAL ENTRI', CASE WHEN A.SARANA_ID = '0' THEN 'Tidak Terdapat Di Master Data' WHEN A.SARANA_ID <> '0' THEN 'Terdapat Di Master Data' END AS [STATUS SARANA], 'Segera ditindak lanjuti' AS [AKSI] FROM T_NOTIF_TMPBB A LEFT JOIN M_BBPOM B ON A.BBPOM_ID = B.BBPOM_ID LEFT JOIN T_USER C ON A.CREATE_BY = C.USER_ID WHERE ISPERIKSA = '".$stts."'";
			$this->newtable->columns(array("A.ID_TMP", "A.NAMA_SARANA", "B.NAMA_BBPOM", "C.NAMA_USER","CONVERT(VARCHAR(10), A.CREATED, 120)","CASE WHEN A.SARANA_ID = '0' THEN 'Tidak Terdapat Di Master Data' WHEN A.SARANA_ID <> '0' THEN 'Terdapat Di Master Data' END","'Segera ditindak lanjuti'"));
			$this->newtable->width(array('NAMA SARANA' => 175,'ASAL ENTRI' => 100, 'PETUGAS ENTRI' => 100, 'TANGGAL ENTRI' => 75, 'STATUS SARANA' => 100, 'AKSI' => 150));
			$tabel = $this->newtable->generate($query);
			$arrdata = array('table' => $tabel,
							 'idjudul' => 'judulpmnsarana',
							 'caption_header' => 'Notifikasi Sarana Pengadaan dan Distribusi Bahan Berbahaya',
							 'batal' => '',
							 'cancel' => '');
			return $arrdata;
		}else{
			$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
		}
	}	
	
			
}
?>