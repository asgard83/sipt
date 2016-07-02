<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);

class F02PR extends Model{
	
	function GetForm02PR($sarana, $jenis, $klasifikasi, $idperiksa){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			if(!array_key_exists($jenis, $this->newsession->userdata("SESS_SARANA")) && !array_key_exists($klasifikasi, $this->newsession->userdata("SESS_KLASIFIKASI_ID"))) return $this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
			$sipt =& get_instance();
			$sipt->load->model("main", "main", true);
			$klasifikasi_produk = array("Parcel" => "Parcel", "Diluar Parcel" => "Diluar Parcel");
			if($idperiksa==""){#Input Mode				  
				if(!$this->session->userdata('SURAT')) return $this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
$qsarana = "SELECT NAMA_SARANA, ALAMAT_1, NAMA_PIMPINAN, IZIN_PERUSAHAAN FROM M_SARANA WHERE SARANA_ID='$sarana'";
				$dt_sarana = $sipt->main->get_result($qsarana);
				if($dt_sarana){
					foreach($qsarana->result_array() as $row){
						$arrdata = array('sess' => $row,
										 'SURAT_ID' => '',								 
										 'BBPOM_ID' => $this->newsession->userdata('SESS_BBPOM_ID'),
										 'act' => site_url().'/post/pemeriksaan/set_periksa/02PR/simpan',
										 'temuan_produk' => array(),
										 'urlback' => site_url().'/home/pelaporan/pemeriksaan');
					}
				}
			}else{
				$idperiksa = explode(".", $idperiksa);
				$status = $idperiksa[1];
				$qperiksa = "SELECT (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN_TEMUAN_PRODUK WHERE PERIKSA_ID='$idperiksa[0]') AS JUMLAH_TEMUAN,A.SARANA_ID, A.NAMA_SARANA, A.ALAMAT_1, A.NAMA_PIMPINAN, A.IZIN_PERUSAHAAN, B.PERIKSA_ID, B.JENIS_SARANA_ID, B.BBPOM_ID, STUFF(dbo.GROUP_KLASIFIKASI(B.PERIKSA_ID),1,1,'') AS KK_ID, CONVERT(VARCHAR(10), B.AWAL_PERIKSA, 103) AS AWAL_PERIKSA, CONVERT(VARCHAR(10), B.AKHIR_PERIKSA, 103) AS AKHIR_PERIKSA, C.TUJUAN_PEMERIKSAAN, B.HASIL, C.TINDAKAN, D.SERI, D.KLASIFIKASI_TEMUAN, D.NAMA_PRODUK, D.PRODUSEN, D.REGISTRASI, D.NOMOR_REGISTRASI, D.KEMASAN, D.SATUAN, D.KATEGORI, D.HARGA, STUFF(dbo.GROUP_CONCAT(B.PERIKSA_ID),1,1,'') AS SURAT_ID FROM M_SARANA A LEFT JOIN T_PEMERIKSAAN B ON A.SARANA_ID = B.SARANA_ID LEFT JOIN T_PEMERIKSAAN_PANGAN C ON B.PERIKSA_ID = C.PERIKSA_ID LEFT JOIN T_PEMERIKSAAN_TEMUAN_PRODUK D ON C.PERIKSA_ID = D.PERIKSA_ID WHERE B.SARANA_ID = '$sarana' AND B.PERIKSA_ID = '$idperiksa[0]'";
				  $dt_periksa = $sipt->main->get_result($qperiksa);
				  if($dt_periksa){
					  foreach($qperiksa->result_array() as $row){
						  $temuan_produk[] = $row;
						  $arrdata = array('sess' => $row,
										 'sess_periksa' => '',
										 'sel_tujuan' => $row['TUJUAN_PEMERIKSAAN'],
										 'jml_temuan' => '',
										 'temuan_produk' => $temuan_produk,
										 'urlback' => site_url().'/home/pelaporan/pemeriksaan/view/'.$status);
					  }
					  $arrdata['SURAT_ID'] = $row['SURAT_ID'];
					  $arrdata['BBPOM_ID'] = $row['BBPOM_ID'];
					  $arrdata['PERIKSA_ID'] = $row['PERIKSA_ID'];
					  $arrdata['jml_temuan'] = $row['JUMLAH_TEMUAN'];
				  }
				  if($this->newsession->userdata('SESS_BBPOM_ID') != "95"){#Update dan Perbaikan Balai
					  if($status=="20101"){
						  $arrdata['act'] = site_url().'/post/pemeriksaan/set_periksa/02PR/update';
					  }else if($status=="20102" || $status =="20103"){
						  $arrdata['act'] = site_url().'/post/pemeriksaan/set_periksa/02PR/perbaikan';
					  }else if($status=="60020"){
						  $arrdata['act'] = site_url().'/post/pemeriksaan/set_periksa/02PR/rekomendasi';
					  }
				  }else{#Update dan Perbaikan Pusat
					  if($status=="20111"){
						  $arrdata['act'] = site_url().'/post/pemeriksaan/set_periksa/02PR/update';
					  }else if($status =="20113" || $status =="20112"){
						  $arrdata['act'] = site_url().'/post/pemeriksaan/set_periksa/02PR/perbaikan';
					  }else if($status=="60020"){
						  $arrdata['act'] = site_url().'/post/pemeriksaan/set_periksa/02PR/rekomendasi';
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
			$arrdata['klasifikasi_kategori'] = $sipt->main->get_klasifikasi();
			$arrdata['disinput'] = array("JENISDIS","NAMADIS");
			$arrdata['tujuan_pemeriksaan'] = $sipt->main->referensi("TUJUAN_PEMERIKSAAN","'20','21','22','23','24'",TRUE,TRUE);
			$arrdata['klasifikasi_produk'] = $sipt->main->referensi("KLASIFIKASI_TEMUAN","'11','12'",TRUE,TRUE);
			$arrdata['hasil'] = $sipt->main->referensi("HASIL","'MK','TMK'",FALSE,TRUE);
			$arrdata['tindakan_sarana'] = $sipt->main->referensi("TL_PARCEL","",TRUE,TRUE);
			$arrdata['histori_petugas'] = site_url().'/load/petugas/get_petugas/'.$arrdata['SURAT_ID'];
			return $arrdata;
		}
	}
	
	function SaveForm02PR($action, $isajax){
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
				$SES_ID = array();
				for($i=0;$i<count($arr_nosurat[$arrkeys_surat[0]]);$i++){
					$surat_id = (int)$sipt->main->get_uraian("SELECT MAX(SURAT_ID) AS MAXSURAT FROM T_SURAT_TUGAS", "MAXSURAT") + 1;
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
					$this->db->insert('T_PEMERIKSAAN_PANGAN', $arr_distribusi);
					
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
											'KK_ID' => '013');
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
				$arr_pemeriksaan = array('UPDATE_BY' => $this->newsession->userdata('SESS_USER_ID'),
										 'LAST_UPDATE' => 'GETDATE()');
				foreach($this->input->post('PEMERIKSAAN') as $a => $b){
				  $arr_pemeriksaan[$a] = $b;
				}
				if($action=="perbaikan" || $action == "rekomendasi"){
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
					$this->db->where(array("PERIKSA_ID" => $this->input->post('PERIKSA_ID')));
					$this->db->update('T_PEMERIKSAAN_PANGAN', $arr_distribusi);
					
					if($this->input->post('TEMUAN_PRODUK')){
						$this->db->where('PERIKSA_ID', $this->input->post('PERIKSA_ID'));
						$this->db->delete('T_PEMERIKSAAN_TEMUAN_PRODUK');
						$arrtemuan = $this->input->post('TEMUAN_PRODUK');
						$arrkeys = array_keys($arrtemuan);
						for($i=0;$i<count($arrtemuan[$arrkeys[0]]);$i++){
							$seri = (int)$sipt->main->get_uraian("SELECT MAX(SERI) AS MAXID FROM T_PEMERIKSAAN_TEMUAN_PRODUK WHERE PERIKSA_ID = '".$this->input->post('PERIKSA_ID')."'", "MAXID") + 1;
							$temuan = array('PERIKSA_ID' => $this->input->post('PERIKSA_ID'),
											'SERI' => $seri,
											'KK_ID' => '013');
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
		}else{
			$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');		  
		}
	}
	
	function get_preview($sarana,$id,$jenis){
		$sipt =& get_instance();
		$this->load->model("main","main", true);
		$id = explode(".", $id);
		$query = "SELECT (CAST(A.SARANA_ID AS VARCHAR) + '/' + A.JENIS_SARANA_ID + '/' + STUFF(dbo.GROUP_KLASIFIKASI(A.PERIKSA_ID),1,1,'') + '/' + CAST(A.PERIKSA_ID AS VARCHAR) + '.' + A.STATUS) AS IDPERIKSA, A.PERIKSA_ID, A.SARANA_ID, A.STATUS, CONVERT(VARCHAR(10), A.AWAL_PERIKSA, 103) AS [AWAL_PERIKSA], CONVERT(VARCHAR(10), A.AKHIR_PERIKSA, 103) AS [AKHIR_PERIKSA], B.TUJUAN_PEMERIKSAAN, A.HASIL, B.TINDAKAN, STUFF(dbo.GROUP_CONCAT(A.PERIKSA_ID),1,1,'') AS SURAT_ID, C.URAIAN FROM T_PEMERIKSAAN A LEFT JOIN T_PEMERIKSAAN_PANGAN B ON A.PERIKSA_ID = B.PERIKSA_ID LEFT JOIN M_TABEL C ON A.HASIL = C.KODE WHERE A.SARANA_ID = '$sarana' AND A.PERIKSA_ID = '$id[0]' AND C.JENIS = 'HASIL'";
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
			$query = "SELECT (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN_TEMUAN_PRODUK WHERE PERIKSA_ID='$idperiksa[0]') AS JUMLAH_TEMUAN, (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN_PROSES WHERE PERIKSA_ID='$idperiksa[0]') AS JML_PROSES,
A.SARANA_ID, A.NAMA_SARANA, A.ALAMAT_1, A.NAMA_PIMPINAN, A.IZIN_PERUSAHAAN, B.PERIKSA_ID, B.JENIS_SARANA_ID, B.BBPOM_ID, STUFF(dbo.GROUP_KLASIFIKASI(B.PERIKSA_ID),1,1,'') AS KK_ID, CONVERT(VARCHAR(10), B.AWAL_PERIKSA, 103) AS AWAL_PERIKSA, CONVERT(VARCHAR(10), B.AKHIR_PERIKSA, 103) AS AKHIR_PERIKSA, C.TUJUAN_PEMERIKSAAN, B.HASIL, C.TINDAKAN, D.SERI, D.KLASIFIKASI_TEMUAN, D.NAMA_PRODUK, D.PRODUSEN, D.REGISTRASI, D.NOMOR_REGISTRASI, D.KEMASAN, D.SATUAN, D.KATEGORI, D.HARGA, STUFF(dbo.GROUP_CONCAT(B.PERIKSA_ID),1,1,'') AS SURAT_ID, E.URAIAN FROM M_SARANA A LEFT JOIN T_PEMERIKSAAN B ON A.SARANA_ID = B.SARANA_ID LEFT JOIN T_PEMERIKSAAN_PANGAN C ON B.PERIKSA_ID = C.PERIKSA_ID LEFT JOIN T_PEMERIKSAAN_TEMUAN_PRODUK D ON C.PERIKSA_ID = D.PERIKSA_ID  LEFT JOIN M_TABEL E ON B.HASIL = E.KODE WHERE B.SARANA_ID = '$sarana' AND B.PERIKSA_ID = '$idperiksa[0]' AND E.JENIS='HASIL'";
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
				  if($this->newsession->userdata('SESS_BBPOM_ID') != "95"){
					  $isEditTLBalai = FALSE;
					  $arrdata['obj_pangan'] = 'PEMERIKSAAN_PANGAN';
				  }else{
					  if($this->newsession->userdata('SESS_BBPOM_ID') == $arrdata['BBPOM_ID'])
						  $isEditTLBalai = FALSE;
					  else
						  $isEditTLBalai = FALSE;					
				  }
				  $arrdata['act'] = site_url().'/post/pemeriksaan/set_proses/02PR/operator';
				  $arrdata['obj_status'] = 'OPERATOR[STATUS]';
			  }else if(array_key_exists('3', $this->newsession->userdata('SESS_KODE_ROLE'))){#Supervisor Satu
				if($this->newsession->userdata('SESS_BBPOM_ID') != "95"){
					  $arrdata['obj_pangan'] = 'PEMERIKSAAN_PANGAN';
					  $isEditTLBalai = FALSE;
				}else{
					  if($this->newsession->userdata('SESS_BBPOM_ID') == $arrdata['BBPOM_ID'])
						  $isEditTLBalai = FALSE;
					  else
						  $isEditTLBalai = FALSE;
				}
				$arrdata['act'] = site_url().'/post/pemeriksaan/set_proses/02PR/spv-satu';
				$arrdata['obj_status'] = 'SUPERVISOR[STATUS]';
			}else if(array_key_exists('4', $this->newsession->userdata('SESS_KODE_ROLE'))){#Supervisor Lanjutan
				if($this->newsession->userdata('SESS_BBPOM_ID') != "95"){
					  $isEditTLBalai = FALSE;
					  $arrdata['obj_pangan'] = 'PEMERIKSAAN_PANGAN';
				}else{
					  if($this->newsession->userdata('SESS_BBPOM_ID') == $arrdata['BBPOM_ID'])
						  $isEditTLBalai = FALSE;
					  else
						  $isEditTLBalai = FALSE;
				}
				$arrdata['obj_status'] = 'SUPERVISOR[STATUS]';
				$arrdata['act'] = site_url().'/post/pemeriksaan/set_proses/02PR/spv-dua';
			}else if(array_key_exists('5', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('6', $this->newsession->userdata('SESS_KODE_ROLE'))){
				$isEditTLBalai = FALSE;
				$arrdata['obj_status'] = 'VERIFIKASI[STATUS]';
				$arrdata['act'] = site_url().'/post/pemeriksaan/set_proses/02PR/56';
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
			$arrdata['hasil'] = $sipt->main->referensi("HASIL","'MK','TMK'",FALSE,FALSE);
			$arrdata['tindakan_sarana'] = $sipt->main->referensi("TL_PARCEL","",TRUE,TRUE);
			$arrdata['isEditTLBalai'] = $isEditTLBalai;
			$arrdata['isverifikasi'] = $isverifikasi;
			$arrdata['urlback'] = site_url().'/home/pelaporan/pemeriksaan/view';
			$arrdata['histori_petugas'] = site_url().'/load/petugas/get_petugas/'.$arrdata['SURAT_ID'];
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
					 if($this->newsession->userdata('SESS_BBPOM_ID') != "95" && $this->input->post('PEMERIKSAAN_PANGAN'))
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
	
	function set_bap($sarana,$jenis,$idperiksa,$subid){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$sipt->load->model("main","main", true);
			$func =& get_instance();
			$func->load->model("functions","functions", true);
			$idperiksa = explode(".", $idperiksa);
			$query = "SELECT (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN_TEMUAN_PRODUK WHERE PERIKSA_ID='$idperiksa[0]') AS JUMLAH_TEMUAN, (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN_PROSES WHERE PERIKSA_ID='$idperiksa[0]') AS JML_PROSES, A.SARANA_ID, A.NAMA_SARANA, A.ALAMAT_1, A.NAMA_PIMPINAN, A.TELEPON, A.IZIN_PERUSAHAAN, A.NOMOR_IZIN, A.GOLONGAN_SARANA, A.JUMLAH_KARYAWAN, A.UMUR_BANGUNAN, B.PERIKSA_ID, B.JENIS_SARANA_ID, B.BBPOM_ID, STUFF(dbo.GROUP_KLASIFIKASI(B.PERIKSA_ID),1,1,'') AS KK_ID, CONVERT(VARCHAR(10), B.AWAL_PERIKSA, 103) AS AWAL_PERIKSA, CONVERT(VARCHAR(10), B.AKHIR_PERIKSA, 103) AS AKHIR_PERIKSA, B.HASIL, C.KESIMPULAN, C.REKOMENDASI, C.TINDAKAN, C.CAPA, C.ASPEK_PENILAIAN, C.KESIMPULAN_GRUP, C.HASIL_TEMUAN_LAIN, D.SERI, D.KLASIFIKASI_TEMUAN, D.NAMA_PRODUK, D.PRODUSEN, D.REGISTRASI, D.NOMOR_REGISTRASI, D.KEMASAN, D.SATUAN, D.KATEGORI, D.HARGA, STUFF(dbo.GROUP_CONCAT(B.PERIKSA_ID),1,1,'') AS SURAT_ID FROM M_SARANA A LEFT JOIN T_PEMERIKSAAN B ON A.SARANA_ID = B.SARANA_ID LEFT JOIN T_PEMERIKSAAN_PANGAN C ON B.PERIKSA_ID = C.PERIKSA_ID LEFT JOIN T_PEMERIKSAAN_TEMUAN_PRODUK D ON C.PERIKSA_ID = D.PERIKSA_ID WHERE B.SARANA_ID = '$sarana' AND B.PERIKSA_ID = '$idperiksa[0]'";
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
		$html = $this->load->view('pemeriksaan/bap/'.$jenis, $arrdata, true);
		$bap = $this->mpdf->WriteHTML($html);
		$bap = $this->mpdf->Output();
		echo $bap;
	}

		
}

?>