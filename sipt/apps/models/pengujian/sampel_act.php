<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR);
class Sampel_act extends Model{
	function get_sampel($submenu){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE && in_array('2',$this->newsession->userdata('SESS_KODE_ROLE'))){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$arrdata = array('act' => site_url().'/post/sampel/sampel_act/save', 'caption' => 'Simpan', 'kode_sampel' => '', 'periksa_sampel' => '');
			$arrdata['komoditi'] = $sipt->main->combobox("SELECT KLASIFIKASI_ID, KLASIFIKASI FROM M_GOLONGAN_NEW WHERE LEN(KLASIFIKASI_ID) = 2  AND KLASIFIKASI_ID NOT IN ('05','06','20') ORDER BY KLASIFIKASI_ID", "KLASIFIKASI_ID", "KLASIFIKASI", TRUE);
			if($submenu!=""){
				$arrid = explode(".",$submenu);
				$asal = $sipt->main->get_uraian("SELECT ASAL_SAMPEL FROM T_M_SAMPEL WHERE KODE_SAMPEL = '".$arrid[1]."'","ASAL_SAMPEL");
				if($asal == "13")
					$bbpom = '';
				else $bbpom = " AND D.BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'";
				$query = "SELECT dbo.FORMAT_NOMOR('SPL', A.KODE_SAMPEL) AS UR_KODE, A.KODE_SAMPEL, dbo.FORMAT_NOMOR('SPU', A.SPU_ID) AS FR_SPUID, A.SPU_ID, A.PERIKSA_SAMPEL, dbo.KATEGORI(A.KOMODITI, A.PRIORITAS) AS KO, A.KOMODITI, LEN(A.KATEGORI) AS LENKATEGORI, A.KATEGORI, A.SPU_ID, A.ANGGARAN, A.ASAL_SAMPEL, A.TUJUAN_SAMPLING, A.SUB_TUJUAN, A.PRIORITAS, CONVERT(VARCHAR(10), A.TANGGAL_SAMPLING, 103) AS TANGGAL_SAMPLING, A.BULAN_ANGGARAN, A.SARANA_ID, A.TEMPAT_SAMPLING, A.ALAMAT_SAMPLING, A.KLASIFIKASI_TAMBAHAN, A.NAMA_SAMPEL, A.NOMOR_REGISTRASI, A.PABRIK, A.IMPORTIR, A.BENTUK_SEDIAAN, A.KEMASAN, A.NO_BETS, A.KETERANGAN_ED, A.JUMLAH_SAMPEL, A.SATUAN, A.HARGA_SAMPEL, A.UJI_KIMIA, A.JUMLAH_KIMIA, A.UJI_MIKRO, A.JUMLAH_MIKRO, A.SISA, A.KOMPOSISI, A.NETTO, A.KONDISI_SAMPEL, A.LABEL, A.SEGEL, A.EVALUASI_PENANDAAN, A.SEGEL, A.LABEL, A.CARA_PENYIMPANAN, A.HASIL_KIMIA, A.HASIL_MIKRO, A.UJI_UNGGULAN, A.LAMPIRAN, A.CATATAN AS [CATATAN SAMPEL], A.STATUS_KIMIA, A.STATUS_MIKRO, A.STATUS_SAMPEL, B.BBPOM_ID, B.NOMOR_SURAT, CONVERT(VARCHAR(10), TANGGAL_SURAT, 103) AS TANGGAL_SURAT, B.NAMA_PENGIRIM, B.NIP_PENGIRIM, B.SURAT_PENGANTAR, B.NIP_POLISI, B.PANGKAT, B.INSTITUSI, B.ALAMAT, B.KOTA, B.NO_RESI_BANK, CONVERT(VARCHAR(10), B.TANGGAL_RESI_BANK, 103) AS TANGGAL_RESI_BANK, B.BIAYA, B.NO_LP, CONVERT(VARCHAR(10), B.TANGGAL_LP, 103) AS TANGGAL_LP, B.NO_SPDP, CONVERT(VARCHAR(10), B.TANGGAL_SPDP, 103) AS TANGGAL_SPDP, B.SAKSI_POLISI, B.NAMA_TERSANGKA, CONVERT(VARCHAR(10), B.TANGGAL_TERIMA, 103) AS TANGGAL_TERIMA, B.HARI_TERIMA, B.SAKSI_UJI, B.JUMLAH_UJI, B.CATATAN AS [CATATAN SURAT], C.USER_ID, D.NAMA_USER FROM T_M_SAMPEL A LEFT JOIN T_PERIKSA_SAMPEL B ON A.PERIKSA_SAMPEL = B.PERIKSA_SAMPEL LEFT JOIN T_PETUGAS_SAMPEL C ON A.PERIKSA_SAMPEL = C.PERIKSA_SAMPEL LEFT JOIN T_USER D ON C.USER_ID = D.USER_ID WHERE A.KODE_SAMPEL = '".$arrid[1]."' AND A.PERIKSA_SAMPEL = '".$arrid[0]."' $bbpom";
				$res = $sipt->main->get_result($query);
				if($res){
					$user_id = array();
					$nama_user = array();
					foreach($query->result_array() as $row){
						if(!array_key_exists($row['USER_ID'], $user_id)) $user_id[] = $row['USER_ID'];
						if(!array_key_exists($row['NAMA_USER'], $nama_user)) $nama_user[] = $row['NAMA_USER'];
						$arrdata = array('sess' => $row,
						                 'act' => site_url().'/post/sampel/sampel_act/update',
										 'user_id' => $user_id,
										 'nama_user' => $nama_user);

					}
					if(strlen($row['SPU_ID']) > 1)
						$arrdata['caption'] = "Proses Sampel";
					else
						$arrdata['caption'] = "Ubah";
					$ganjil = substr($row['KATEGORI'],0,4);
					$arrdata['kode_sampel'] = $row['KODE_SAMPEL'];
					$arrdata['periksa_sampel'] = $row['PERIKSA_SAMPEL'];
					$arrdata['sel'][0] = substr($row['KATEGORI'],0,4);
					$arrdata['sel'][1] = substr($row['KATEGORI'],0,6);
					if($row['PRIORITAS'] == "1"){
						if($ganjil == "0101" || $ganjil == "0105"){
							if($row['LENKATEGORI'] == 11) $arrdata['sel'][1] = substr($row['KATEGORI'],0,7);
						}
						$arrdata['sel'][2] = substr($row['KATEGORI'],0,8);
						if($ganjil == "0101" || $ganjil == "0105"){
							if($row['LENKATEGORI'] == 11) $arrdata['sel'][2] = substr($row['KATEGORI'],0,9);
						}
					}else if($row['PRIORITAS'] == "0"){
						$arrdata['sel'][1] = substr($row['KATEGORI'],0,6);
						$arrdata['sel'][2] = substr($row['KATEGORI'],0,8);
					}
					$arrdata['sel'][3] = $row['KATEGORI'];
					
					if($row['PRIORITAS'] == "1"){
						$arrdata['selkategori'][0] = $sipt->main->combobox("SELECT LTRIM(RTRIM(KLASIFIKASI_ID)) AS KLASIFIKASI_ID, KLASIFIKASI FROM M_GOLONGAN_NEW WHERE KLASIFIKASI_ID LIKE '".substr($row['KATEGORI'],0,2)."%__' AND LEN(KLASIFIKASI_ID) = '4' AND KLASIFIKASI <> '' AND STATUS = '1' ORDER BY KLASIFIKASI_ID ASC", "KLASIFIKASI_ID", "KLASIFIKASI", TRUE);
						if($ganjil == "0101" || $ganjil == "0105"){
							$arrdata['selkategori'][1] = $sipt->main->combobox("SELECT (LTRIM(RTRIM(KLASIFIKASI_ID))) AS KLASIFIKASI_ID, LTRIM(RTRIM(KLASIFIKASI)) AS KLASIFIKASI FROM M_GOLONGAN_NEW WHERE KLASIFIKASI_PARENT = '".$ganjil."' AND KLASIFIKASI_ID LIKE '".substr($row['KATEGORI'],0,4)."%__' OR KLASIFIKASI_ID LIKE '".substr($row['KATEGORI'],0,4)."%___' AND (LEN(KLASIFIKASI_ID) = '6' OR  LEN(KLASIFIKASI_ID) = '7')  AND KLASIFIKASI <> '' AND STATUS = '1' ORDER BY KLASIFIKASI ASC", "KLASIFIKASI_ID", "KLASIFIKASI", TRUE);
						}else{
							$arrdata['selkategori'][1] = $sipt->main->combobox("SELECT LTRIM(RTRIM(KLASIFIKASI_ID)) AS KLASIFIKASI_ID, KLASIFIKASI FROM M_GOLONGAN_NEW WHERE KLASIFIKASI_ID LIKE '".substr($row['KATEGORI'],0,4)."%__' AND LEN(KLASIFIKASI_ID) = '6' AND KLASIFIKASI <> '' AND STATUS = '1' ORDER BY KLASIFIKASI_ID ASC", "KLASIFIKASI_ID", "KLASIFIKASI", TRUE);
						}
						if($ganjil == "0101" || $ganjil == "0105"){
							$arrdata['selkategori'][2] = $sipt->main->combobox("SELECT (LTRIM(RTRIM(KLASIFIKASI_ID))) AS KLASIFIKASI_ID, LTRIM(RTRIM(KLASIFIKASI)) AS KLASIFIKASI FROM M_GOLONGAN_NEW WHERE KLASIFIKASI_ID LIKE '".substr($row['KATEGORI'],0,6)."%__' OR KLASIFIKASI_ID LIKE '".substr($row['KATEGORI'],0,6)."%___' AND (LEN(KLASIFIKASI_ID) = '8' OR  LEN(KLASIFIKASI_ID) = '9')  AND KLASIFIKASI <> '' AND STATUS = '1' ORDER BY KLASIFIKASI ASC", "KLASIFIKASI_ID", "KLASIFIKASI", TRUE);
						}else{
							$arrdata['selkategori'][2] = $sipt->main->combobox("SELECT LTRIM(RTRIM(KLASIFIKASI_ID)) AS KLASIFIKASI_ID, KLASIFIKASI FROM M_GOLONGAN_NEW WHERE KLASIFIKASI_ID LIKE '".substr($row['KATEGORI'],0,6)."%__' AND LEN(KLASIFIKASI_ID) = '8' AND KLASIFIKASI <> '' AND STATUS = '1' ORDER BY KLASIFIKASI_ID ASC", "KLASIFIKASI_ID", "KLASIFIKASI", TRUE);
						}
						if($ganjil == "0101" || $ganjil == "0105"){
							$arrdata['selkategori'][3] = $sipt->main->combobox("SELECT (LTRIM(RTRIM(KLASIFIKASI_ID))) AS KLASIFIKASI_ID, LTRIM(RTRIM(KLASIFIKASI)) AS KLASIFIKASI FROM M_GOLONGAN_NEW WHERE KLASIFIKASI_ID LIKE '".substr($row['KATEGORI'],0,8)."%__' OR KLASIFIKASI_ID LIKE '".substr($row['KATEGORI'],0,9)."%___' AND (LEN(KLASIFIKASI_ID) = '10' OR  LEN(KLASIFIKASI_ID) = '11')  AND KLASIFIKASI <> '' AND STATUS = '1' ORDER BY KLASIFIKASI ASC", "KLASIFIKASI_ID", "KLASIFIKASI", TRUE);
						}else{
							$arrdata['selkategori'][3] = $sipt->main->combobox("SELECT LTRIM(RTRIM(KLASIFIKASI_ID)) AS KLASIFIKASI_ID, KLASIFIKASI FROM M_GOLONGAN_NEW WHERE KLASIFIKASI_ID LIKE '".substr($row['KATEGORI'],0,8)."%__' AND LEN(KLASIFIKASI_ID) = '10' ORDER BY KLASIFIKASI_ID ASC", "KLASIFIKASI_ID", "KLASIFIKASI", TRUE);
						}
					}else if($row['PRIORITAS'] == "0"){
						$arrdata['selkategori'][0] = $sipt->main->combobox("SELECT LTRIM(RTRIM(KLASIFIKASI_ID)) AS KLASIFIKASI_ID, KLASIFIKASI FROM M_GOLONGAN WHERE KLASIFIKASI_ID LIKE '".substr($row['KATEGORI'],0,2)."%__' AND LEN(KLASIFIKASI_ID) = '4' ORDER BY KLASIFIKASI_ID ASC", "KLASIFIKASI_ID", "KLASIFIKASI", TRUE);
						$arrdata['selkategori'][1] = $sipt->main->combobox("SELECT LTRIM(RTRIM(KLASIFIKASI_ID)) AS KLASIFIKASI_ID, KLASIFIKASI FROM M_GOLONGAN WHERE KLASIFIKASI_ID LIKE '".substr($row['KATEGORI'],0,4)."%__' AND LEN(KLASIFIKASI_ID) = '6' ORDER BY KLASIFIKASI_ID ASC", "KLASIFIKASI_ID", "KLASIFIKASI", TRUE);
						$arrdata['selkategori'][2] = $sipt->main->combobox("SELECT LTRIM(RTRIM(KLASIFIKASI_ID)) AS KLASIFIKASI_ID, KLASIFIKASI FROM M_GOLONGAN WHERE KLASIFIKASI_ID LIKE '".substr($row['KATEGORI'],0,6)."%__' AND LEN(KLASIFIKASI_ID) = '8' ORDER BY KLASIFIKASI_ID ASC", "KLASIFIKASI_ID", "KLASIFIKASI", TRUE);
						$arrdata['selkategori'][3] = $sipt->main->combobox("SELECT LTRIM(RTRIM(KLASIFIKASI_ID)) AS KLASIFIKASI_ID, KLASIFIKASI FROM M_GOLONGAN WHERE KLASIFIKASI_ID LIKE '".substr($row['KATEGORI'],0,8)."%__' AND LEN(KLASIFIKASI_ID) = '10' ORDER BY KLASIFIKASI_ID ASC", "KLASIFIKASI_ID", "KLASIFIKASI", TRUE);
					}
					
					if(substr($row['KATEGORI'],0,2) == "01"){
						
						$arrdata['klasifikasi_tambahan'] = $sipt->main->combobox("SELECT NAMA_TAMBAHAN FROM M_GOLONGAN_TAMBAHAN WHERE KLASIFIKASI = '".substr($row['KATEGORI'],0,4)."' ORDER BY 1 ASC", "NAMA_TAMBAHAN", "NAMA_TAMBAHAN", TRUE);
					}else{
						
						$arrdata['klasifikasi_tambahan'] = $sipt->main->combobox("SELECT NAMA_TAMBAHAN FROM M_GOLONGAN_TAMBAHAN WHERE KLASIFIKASI = '".substr($row['KATEGORI'],0,2)."' ORDER BY 1 ASC", "NAMA_TAMBAHAN", "NAMA_TAMBAHAN", TRUE);
					}
					
					if($row['SUB_TUJUAN'] != ""){
						$ko = substr($row['SUB_TUJUAN'], 0,2);
						$tipe = $row['TUJUAN_SAMPLING']; 
						$arrdata['sub_tujuan'] = $sipt->main->combobox("SELECT KODE, URAIAN FROM M_TABEL WHERE JENIS = 'SUB_TUJUAN' AND KODE LIKE '".$ko."%____' AND URAIAN_DETIL = '".$tipe."' ORDER BY 1 ASC", "KODE", "URAIAN", TRUE);
					}
					$arrdata['jml_log'] = $sipt->main->get_uraian("SELECT COUNT(*) AS JML FROM T_SAMPLING_LOG WHERE KODE_SAMPEL = '".$arrid[1]."'","JML");
					$arrdata['selkondisi'] = explode(",", $row['KONDISI_SAMPEL']);
					if((int)$row['PRIORITAS'] == 0){
						$arrdata['komoditi'] = $sipt->main->combobox("SELECT KLASIFIKASI_ID, KLASIFIKASI FROM M_GOLONGAN WHERE LEN(KLASIFIKASI_ID) = 2  AND KLASIFIKASI_ID NOT IN ('05','06') ORDER BY KLASIFIKASI_ID", "KLASIFIKASI_ID", "KLASIFIKASI", TRUE);
					}
				}
			}
			
			$arrdata['tujuan'] = $sipt->main->referensi("TUJUAN_SAMPLING","",FALSE,TRUE);
			
			$bbpominsert = array("09","18","13","50");			
			if(in_array('2',$this->newsession->userdata('SESS_KODE_ROLE'))){
				$arrdata['anggaran'] = $sipt->main->referensi("ANGGARAN_SAMPLING","'01','02','03','04','08','09','10','11'",FALSE,TRUE);
				if(in_array($this->newsession->userdata('SESS_BBPOM_ID'),$bbpominsert)){
					$arrdata['asal'] = $sipt->main->referensi("ASAL_SAMPLING","'01','02','03','04','05','06','07','08','09','13'",FALSE,TRUE);
				}else{
					$arrdata['asal'] = $sipt->main->referensi("ASAL_SAMPLING","'01','02','03','04','05','06','07','08','09'",FALSE,TRUE);
					}
			}else{
				$arrdata['anggaran'] = $sipt->main->referensi("ANGGARAN_SAMPLING","'05','06','07'",FALSE,TRUE);
				if(in_array($this->newsession->userdata('SESS_BBPOM_ID'),$bbpominsert)){
					$arrdata['asal'] = $sipt->main->referensi("ASAL_SAMPLING","'10','11','12','13'",FALSE,TRUE);
				}else{
					$arrdata['asal'] = $sipt->main->referensi("ASAL_SAMPLING","'10','11','12'",FALSE,TRUE);
				}
			}
			
			$arrdata['satuan'] = $sipt->main->combobox("SELECT SATUAN_ID, NAMA_SATUAN FROM M_SATUAN ORDER BY 2 ASC", "NAMA_SATUAN", "NAMA_SATUAN", TRUE);
			$arrdata['prioritas'] = array("" => "", "1" => "Data Prioritas Sampling 2015", "0" => "Data Prioritas Sampling 2014");
			$arrdata['kondisi_sampel'] = $sipt->main->referensi("KONDISI_SAMPEL","",TRUE,TRUE);
			$arrdata['segel'] = $sipt->main->referensi("SEGEL_SAMPLING","",TRUE,TRUE);
			$arrdata['label_sampel'] = $sipt->main->referensi("LABEL_SAMPLING","",TRUE,TRUE);
			$arrdata['prevadmin'] = TRUE;
			$arrdata['unggulan'] = array('0'=>'Tidak', '1'=>'Ya');
			$arrdata['bulan'] = array('' => '','Januari' => 'Januari',
									  'Februari' => 'Febuari',
									  'Maret' => 'Maret',
									  'April' => 'April',
									  'Mei' => 'Mei',
									  'Juni' => 'Juni',
									  'Juli' => 'Juli',
									  'Agustus' => 'Agustus',
									  'September' => 'September',
									  'Oktober' => 'Oktober',
									  'November' => 'November',
									  'Desember' => 'Desember');
			return $arrdata;
		}
	}
	
	function get_edit($submenu){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE && (in_array('1',$this->newsession->userdata('SESS_KODE_ROLE')) || in_array('9',$this->newsession->userdata('SESS_KODE_ROLE')))){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			if($submenu!=""){
				$arrid = explode(".",$submenu);
				$bbpomid = $sipt->main->get_uraian("SELECT RTRIM(LTRIM(BBPOM_ID)) AS BBPOM_ID FROM T_PERIKSA_SAMPEL WHERE PERIKSA_SAMPEL = '".$arrid[0]."'","BBPOM_ID");
				$query = "SELECT dbo.FORMAT_NOMOR('SPL', A.KODE_SAMPEL) AS UR_KODE, A.KODE_SAMPEL, dbo.FORMAT_NOMOR('SPU', A.SPU_ID) AS FR_SPUID, A.SPU_ID, A.PERIKSA_SAMPEL, dbo.KATEGORI(A.KOMODITI, A.PRIORITAS) AS KO, A.NAMA_KATEGORI AS KOX, A.KOMODITI, A.KATEGORI, LEN(A.KATEGORI) AS LENKATEGORI, A.SPU_ID, A.ANGGARAN, A.ASAL_SAMPEL, A.TUJUAN_SAMPLING, A.SUB_TUJUAN, A.PRIORITAS, CONVERT(VARCHAR(10), A.TANGGAL_SAMPLING, 103) AS TANGGAL_SAMPLING, A.BULAN_ANGGARAN, A.SARANA_ID, A.TEMPAT_SAMPLING, A.ALAMAT_SAMPLING, A.KLASIFIKASI_TAMBAHAN, A.NAMA_SAMPEL, A.NOMOR_REGISTRASI, A.PABRIK, A.IMPORTIR, A.BENTUK_SEDIAAN, A.KEMASAN, A.NO_BETS, A.KETERANGAN_ED, A.JUMLAH_SAMPEL, A.SATUAN, A.HARGA_SAMPEL, A.UJI_KIMIA, A.JUMLAH_KIMIA, A.UJI_MIKRO, A.JUMLAH_MIKRO, A.SISA, A.KOMPOSISI, A.NETTO, A.KONDISI_SAMPEL, A.LABEL, A.SEGEL, A.EVALUASI_PENANDAAN, A.SEGEL, A.LABEL, A.CARA_PENYIMPANAN, LTRIM(RTRIM(A.HASIL_KIMIA)) AS HASIL_KIMIA, LTRIM(RTRIM(A.HASIL_MIKRO)) AS HASIL_MIKRO, A.UJI_UNGGULAN, A.LAMPIRAN, A.CATATAN AS [CATATAN SAMPEL], A.STATUS_KIMIA, LTRIM(RTRIM(A.HASIL_SAMPEL)) AS HASIL_SAMPEL, A.STATUS_MIKRO, A.STATUS_SAMPEL, A.PEMERIAN,  A.PRIORITAS, B.BBPOM_ID, B.NOMOR_SURAT, CONVERT(VARCHAR(10), TANGGAL_SURAT, 103) AS TANGGAL_SURAT, B.NAMA_PENGIRIM, B.NIP_PENGIRIM, B.SURAT_PENGANTAR, B.NIP_POLISI, B.PANGKAT, B.INSTITUSI, B.ALAMAT, B.KOTA, B.NO_RESI_BANK, CONVERT(VARCHAR(10), B.TANGGAL_RESI_BANK, 103) AS TANGGAL_RESI_BANK, B.BIAYA, B.NO_LP, CONVERT(VARCHAR(10), B.TANGGAL_LP, 103) AS TANGGAL_LP, B.NO_SPDP, CONVERT(VARCHAR(10), B.TANGGAL_SPDP, 103) AS TANGGAL_SPDP, B.SAKSI_POLISI, B.NAMA_TERSANGKA, CONVERT(VARCHAR(10), B.TANGGAL_TERIMA, 103) AS TANGGAL_TERIMA, B.HARI_TERIMA, B.SAKSI_UJI, B.JUMLAH_UJI, B.CATATAN AS [CATATAN SURAT], C.USER_ID, D.NAMA_USER FROM T_M_SAMPEL A LEFT JOIN T_PERIKSA_SAMPEL B ON A.PERIKSA_SAMPEL = B.PERIKSA_SAMPEL LEFT JOIN T_PETUGAS_SAMPEL C ON A.PERIKSA_SAMPEL = C.PERIKSA_SAMPEL LEFT JOIN T_USER D ON C.USER_ID = D.USER_ID WHERE A.KODE_SAMPEL = '".$arrid[1]."' AND A.PERIKSA_SAMPEL = '".$arrid[0]."' AND D.BBPOM_ID = '".$bbpomid."'";
				$res = $sipt->main->get_result($query);
				if($res){
					$user_id = array();
					$nama_user = array();
					foreach($query->result_array() as $row){
						if(!array_key_exists($row['USER_ID'], $user_id)) $user_id[] = $row['USER_ID'];
						if(!array_key_exists($row['NAMA_USER'], $nama_user)) $nama_user[] = $row['NAMA_USER'];
						$arrdata = array('sess' => $row,
										 'user_id' => $user_id,
										 'nama_user' => $nama_user);

					}
					if(strlen($row['SPU_ID']) > 1)
						$arrdata['caption'] = "Proses";
					else
						$arrdata['caption'] = "Ubah";
					$arrdata['kode_sampel'] = $row['KODE_SAMPEL'];
					$arrdata['periksa_sampel'] = $row['PERIKSA_SAMPEL'];
					
					/*
					$arrdata['sel'][0] = substr($row['KATEGORI'],0,4);
					$arrdata['sel'][1] = substr($row['KATEGORI'],0,6);
					$arrdata['sel'][2] = substr($row['KATEGORI'],0,8);
					$arrdata['sel'][3] = $row['KATEGORI'];
					$arrdata['selkategori'][0] = $sipt->main->combobox("SELECT LTRIM(RTRIM(KLASIFIKASI_ID)) AS KLASIFIKASI_ID, KLASIFIKASI FROM M_GOLONGAN WHERE KLASIFIKASI_ID LIKE '".substr($row['KATEGORI'],0,2)."%__' AND LEN(KLASIFIKASI_ID) = '4' ORDER BY KLASIFIKASI_ID ASC", "KLASIFIKASI_ID", "KLASIFIKASI", TRUE);
					$arrdata['selkategori'][1] = $sipt->main->combobox("SELECT LTRIM(RTRIM(KLASIFIKASI_ID)) AS KLASIFIKASI_ID, KLASIFIKASI FROM M_GOLONGAN WHERE KLASIFIKASI_ID LIKE '".substr($row['KATEGORI'],0,4)."%__' AND LEN(KLASIFIKASI_ID) = '6' ORDER BY KLASIFIKASI_ID ASC", "KLASIFIKASI_ID", "KLASIFIKASI", TRUE);
					$arrdata['selkategori'][2] = $sipt->main->combobox("SELECT LTRIM(RTRIM(KLASIFIKASI_ID)) AS KLASIFIKASI_ID, KLASIFIKASI FROM M_GOLONGAN WHERE KLASIFIKASI_ID LIKE '".substr($row['KATEGORI'],0,6)."%__' AND LEN(KLASIFIKASI_ID) = '8' ORDER BY KLASIFIKASI_ID ASC", "KLASIFIKASI_ID", "KLASIFIKASI", TRUE);
					$arrdata['selkategori'][3] = $sipt->main->combobox("SELECT LTRIM(RTRIM(KLASIFIKASI_ID)) AS KLASIFIKASI_ID, KLASIFIKASI FROM M_GOLONGAN WHERE KLASIFIKASI_ID LIKE '".substr($row['KATEGORI'],0,8)."%__' AND LEN(KLASIFIKASI_ID) = '10' ORDER BY KLASIFIKASI_ID ASC", "KLASIFIKASI_ID", "KLASIFIKASI", TRUE);*/
					
					$ganjil = substr($row['KATEGORI'],0,4);
					$arrdata['kode_sampel'] = $row['KODE_SAMPEL'];
					$arrdata['periksa_sampel'] = $row['PERIKSA_SAMPEL'];
					$arrdata['sel'][0] = substr($row['KATEGORI'],0,4);
					$arrdata['sel'][1] = substr($row['KATEGORI'],0,6);
					/*if($row['PRIORITAS'] == "1"){
						if($ganjil == "0101" || $ganjil == "0105"){
							if($row['LENKATEGORI'] == 11) $arrdata['sel'][1] = substr($row['KATEGORI'],0,7);
						}
						$arrdata['sel'][2] = substr($row['KATEGORI'],0,8);
						if($ganjil == "0101" || $ganjil == "0105"){
							if($row['LENKATEGORI'] == 11) $arrdata['sel'][2] = substr($row['KATEGORI'],0,9);
						}
						if($row['LENKATEGORI'] == 13){
							$arrdata['sel'][3] = substr($row['KATEGORI'],0,11);
							$arrdata['sel'][4] = $row['KATEGORI'];
						}else{
							$arrdata['sel'][3] = $row['KATEGORI'];
						}
					}else if($row['PRIORITAS'] == "0"){
						$arrdata['sel'][1] = substr($row['KATEGORI'],0,6);
						$arrdata['sel'][2] = substr($row['KATEGORI'],0,8);
						$arrdata['sel'][3] = $row['KATEGORI'];
					}*/
					if($row['PRIORITAS'] == "1"){
						if($ganjil == "0101" || $ganjil == "0105"){
							if($row['LENKATEGORI'] == 11) $arrdata['sel'][1] = substr($row['KATEGORI'],0,7);
							if($row['LENKATEGORI'] == 13) $arrdata['sel'][1] = substr($row['KATEGORI'],0,7);
						}
						$arrdata['sel'][2] = substr($row['KATEGORI'],0,8);
						if($ganjil == "0101" || $ganjil == "0105"){
							if($row['LENKATEGORI'] == 11) $arrdata['sel'][2] = substr($row['KATEGORI'],0,9);
							if($row['LENKATEGORI'] == 13) $arrdata['sel'][2] = substr($row['KATEGORI'],0,9);
						}
						if($row['LENKATEGORI'] == 13){
							$arrdata['sel'][3] = substr($row['KATEGORI'],0,11);
							$arrdata['sel'][4] = $row['KATEGORI'];
						}else{
							$arrdata['sel'][3] = substr($row['KATEGORI'],0,10);
							$arrdata['sel'][4] = $row['KATEGORI'];	
						}
					}else if($prioritas == "0"){
						$arrdata['sel'][1] = substr($row['KATEGORI'],0,6);
						$arrdata['sel'][2] = substr($row['KATEGORI'],0,8);
						$arrdata['sel'][3] = $row['KATEGORI'];
					}
					
					if($row['PRIORITAS'] == "1"){
						$arrdata['selkategori'][0] = $sipt->main->combobox("SELECT LTRIM(RTRIM(KLASIFIKASI_ID)) AS KLASIFIKASI_ID, KLASIFIKASI FROM M_GOLONGAN_NEW WHERE KLASIFIKASI_ID LIKE '".substr($row['KATEGORI'],0,2)."%__' AND LEN(KLASIFIKASI_ID) = '4' AND KLASIFIKASI <> '' AND STATUS = '1' ORDER BY KLASIFIKASI_ID ASC", "KLASIFIKASI_ID", "KLASIFIKASI", TRUE);
						if($ganjil == "0101" || $ganjil == "0105"){
							$arrdata['selkategori'][1] = $sipt->main->combobox("SELECT (LTRIM(RTRIM(KLASIFIKASI_ID))) AS KLASIFIKASI_ID, LTRIM(RTRIM(KLASIFIKASI)) AS KLASIFIKASI FROM M_GOLONGAN_NEW WHERE KLASIFIKASI_PARENT = '".$ganjil."' AND KLASIFIKASI_ID LIKE '".substr($row['KATEGORI'],0,4)."%__' OR KLASIFIKASI_ID LIKE '".substr($row['KATEGORI'],0,4)."%___' AND (LEN(KLASIFIKASI_ID) = '6' OR  LEN(KLASIFIKASI_ID) = '7')  AND KLASIFIKASI <> '' AND STATUS = '1' ORDER BY KLASIFIKASI ASC", "KLASIFIKASI_ID", "KLASIFIKASI", TRUE);
						}else{
							$arrdata['selkategori'][1] = $sipt->main->combobox("SELECT LTRIM(RTRIM(KLASIFIKASI_ID)) AS KLASIFIKASI_ID, KLASIFIKASI FROM M_GOLONGAN_NEW WHERE KLASIFIKASI_ID LIKE '".substr($row['KATEGORI'],0,4)."%__' AND LEN(KLASIFIKASI_ID) = '6' AND KLASIFIKASI <> '' AND STATUS = '1' ORDER BY KLASIFIKASI_ID ASC", "KLASIFIKASI_ID", "KLASIFIKASI", TRUE);
						}
						if($ganjil == "0101" || $ganjil == "0105"){
							$arrdata['selkategori'][2] = $sipt->main->combobox("SELECT (LTRIM(RTRIM(KLASIFIKASI_ID))) AS KLASIFIKASI_ID, LTRIM(RTRIM(KLASIFIKASI)) AS KLASIFIKASI FROM M_GOLONGAN_NEW WHERE KLASIFIKASI_ID LIKE '".substr($row['KATEGORI'],0,6)."%__' OR KLASIFIKASI_ID LIKE '".substr($row['KATEGORI'],0,6)."%___' AND (LEN(KLASIFIKASI_ID) = '8' OR  LEN(KLASIFIKASI_ID) = '9')  AND KLASIFIKASI <> '' AND STATUS = '1' ORDER BY KLASIFIKASI ASC", "KLASIFIKASI_ID", "KLASIFIKASI", TRUE);
						}else{
							$arrdata['selkategori'][2] = $sipt->main->combobox("SELECT LTRIM(RTRIM(KLASIFIKASI_ID)) AS KLASIFIKASI_ID, KLASIFIKASI FROM M_GOLONGAN_NEW WHERE KLASIFIKASI_ID LIKE '".substr($row['KATEGORI'],0,6)."%__' AND LEN(KLASIFIKASI_ID) = '8' AND KLASIFIKASI <> '' AND STATUS = '1' ORDER BY KLASIFIKASI_ID ASC", "KLASIFIKASI_ID", "KLASIFIKASI", TRUE);
						}
						if($ganjil == "0101" || $ganjil == "0105"){
							$arrdata['selkategori'][3] = $sipt->main->combobox("SELECT (LTRIM(RTRIM(KLASIFIKASI_ID))) AS KLASIFIKASI_ID, LTRIM(RTRIM(KLASIFIKASI)) AS KLASIFIKASI FROM M_GOLONGAN_NEW WHERE KLASIFIKASI_ID LIKE '".substr($row['KATEGORI'],0,8)."%__' OR KLASIFIKASI_ID LIKE '".substr($row['KATEGORI'],0,9)."%___' AND (LEN(KLASIFIKASI_ID) = '10' OR  LEN(KLASIFIKASI_ID) = '11')  AND KLASIFIKASI <> '' AND STATUS = '1' ORDER BY KLASIFIKASI ASC", "KLASIFIKASI_ID", "KLASIFIKASI", TRUE);
						}else{
							$arrdata['selkategori'][3] = $sipt->main->combobox("SELECT LTRIM(RTRIM(KLASIFIKASI_ID)) AS KLASIFIKASI_ID, KLASIFIKASI FROM M_GOLONGAN_NEW WHERE KLASIFIKASI_ID LIKE '".substr($row['KATEGORI'],0,8)."%__' AND LEN(KLASIFIKASI_ID) = '10' ORDER BY KLASIFIKASI_ID ASC", "KLASIFIKASI_ID", "KLASIFIKASI", TRUE);
						}
						if($ganjil == "0101" || $ganjil == "0105"){
							$arrdata['selkategori'][4] = $sipt->main->combobox("SELECT (LTRIM(RTRIM(KLASIFIKASI_ID))) AS KLASIFIKASI_ID, LTRIM(RTRIM(KLASIFIKASI)) AS KLASIFIKASI FROM M_GOLONGAN_NEW WHERE KLASIFIKASI_ID LIKE '".substr($row['KATEGORI'],0,10)."%__' OR KLASIFIKASI_ID LIKE '".substr($row['KATEGORI'],0,11)."%___' AND (LEN(KLASIFIKASI_ID) = '12' OR  LEN(KLASIFIKASI_ID) = '13')  AND KLASIFIKASI <> '' AND STATUS = '1' ORDER BY KLASIFIKASI ASC", "KLASIFIKASI_ID", "KLASIFIKASI", TRUE);
						}else{
							$arrdata['selkategori'][4] = $sipt->main->combobox("SELECT LTRIM(RTRIM(KLASIFIKASI_ID)) AS KLASIFIKASI_ID, KLASIFIKASI FROM M_GOLONGAN_NEW WHERE KLASIFIKASI_ID LIKE '".substr($row['KATEGORI'],0,10)."%__' AND LEN(KLASIFIKASI_ID) = '12' ORDER BY KLASIFIKASI_ID ASC", "KLASIFIKASI_ID", "KLASIFIKASI", TRUE);
						}
					}else if($row['PRIORITAS'] == "0"){
						$arrdata['selkategori'][0] = $sipt->main->combobox("SELECT LTRIM(RTRIM(KLASIFIKASI_ID)) AS KLASIFIKASI_ID, KLASIFIKASI FROM M_GOLONGAN WHERE KLASIFIKASI_ID LIKE '".substr($row['KATEGORI'],0,2)."%__' AND LEN(KLASIFIKASI_ID) = '4' ORDER BY KLASIFIKASI_ID ASC", "KLASIFIKASI_ID", "KLASIFIKASI", TRUE);
						$arrdata['selkategori'][1] = $sipt->main->combobox("SELECT LTRIM(RTRIM(KLASIFIKASI_ID)) AS KLASIFIKASI_ID, KLASIFIKASI FROM M_GOLONGAN WHERE KLASIFIKASI_ID LIKE '".substr($row['KATEGORI'],0,4)."%__' AND LEN(KLASIFIKASI_ID) = '6' ORDER BY KLASIFIKASI_ID ASC", "KLASIFIKASI_ID", "KLASIFIKASI", TRUE);
						$arrdata['selkategori'][2] = $sipt->main->combobox("SELECT LTRIM(RTRIM(KLASIFIKASI_ID)) AS KLASIFIKASI_ID, KLASIFIKASI FROM M_GOLONGAN WHERE KLASIFIKASI_ID LIKE '".substr($row['KATEGORI'],0,6)."%__' AND LEN(KLASIFIKASI_ID) = '8' ORDER BY KLASIFIKASI_ID ASC", "KLASIFIKASI_ID", "KLASIFIKASI", TRUE);
						$arrdata['selkategori'][3] = $sipt->main->combobox("SELECT LTRIM(RTRIM(KLASIFIKASI_ID)) AS KLASIFIKASI_ID, KLASIFIKASI FROM M_GOLONGAN WHERE KLASIFIKASI_ID LIKE '".substr($row['KATEGORI'],0,8)."%__' AND LEN(KLASIFIKASI_ID) = '10' ORDER BY KLASIFIKASI_ID ASC", "KLASIFIKASI_ID", "KLASIFIKASI", TRUE);
					}
					
					if(substr($row['KATEGORI'],0,2) == "01")
						$arrdata['klasifikasi_tambahan'] = $sipt->main->combobox("SELECT NAMA_TAMBAHAN FROM M_GOLONGAN_TAMBAHAN WHERE KLASIFIKASI = '".substr($row['KATEGORI'],0,4)."' ORDER BY 1 ASC", "NAMA_TAMBAHAN", "NAMA_TAMBAHAN", TRUE);
					else 
						$arrdata['klasifikasi_tambahan'] = $sipt->main->combobox("SELECT NAMA_TAMBAHAN FROM M_GOLONGAN_TAMBAHAN WHERE KLASIFIKASI = '".substr($row['KATEGORI'],0,2)."' ORDER BY 1 ASC", "NAMA_TAMBAHAN", "NAMA_TAMBAHAN", TRUE);
						
					if($row['SUB_TUJUAN'] != ""){
						$ko = substr($row['SUB_TUJUAN'], 0,2);
						$tipe = $row['TUJUAN_SAMPLING']; 
						$arrdata['sub_tujuan'] = $sipt->main->combobox("SELECT KODE, URAIAN FROM M_TABEL WHERE JENIS = 'SUB_TUJUAN' AND KODE LIKE '".$ko."%____' AND URAIAN_DETIL = '".$tipe."' ORDER BY 1 ASC", "KODE", "URAIAN", TRUE);
					}
					$arrdata['jml_log'] = $sipt->main->get_uraian("SELECT COUNT(*) AS JML FROM T_SAMPLING_LOG WHERE KODE_SAMPEL = '".$arrid[1]."'","JML");
					$arrdata['selkondisi'] = explode(",", $row['KONDISI_SAMPEL']);
				}
			}
			
			$arrdata['tujuan'] = $sipt->main->referensi("TUJUAN_SAMPLING","",FALSE,TRUE);
			$arrexternal = array('10','11','12');
			if(in_array($row['ASAL_SAMPEL'], $arrexternal)){
				$arrdata['external'] = TRUE;
				$arrdata['anggaran'] = $sipt->main->referensi("ANGGARAN_SAMPLING","'05','06','07'",FALSE,TRUE);
				$arrdata['asal'] = $sipt->main->referensi("ASAL_SAMPLING","'10','11','12'",FALSE,TRUE);
				$arrdata['list_pnbp'] = $this->db->query("SELECT A.PNBP_ID, A.PNBP_TARIF, A.PNBP_JML, C.PNBP_DESCRIPTION, C.PNBP_UNIT, C.PNBP_AMOUNT FROM T_PNBP_SAMPLING A LEFT JOIN T_M_SAMPEL B ON A.KODE_SAMPEL = B.KODE_SAMPEL LEFT JOIN M_PNBP C ON A.PNBP_ID = C.PNBP_ID WHERE A.KODE_SAMPEL = '".$arrid[1]."'")->result_array();
				$arrdata['act'] = site_url().'/post/sampel/sampel_act/edit-admin';
			}else{
				$arrdata['anggaran'] = $sipt->main->referensi("ANGGARAN_SAMPLING","'01','02','03','04','08','09','10','11'",FALSE,TRUE);
				$arrdata['asal'] = $sipt->main->referensi("ASAL_SAMPLING","'01','02','03','04','05','06','07','08','09'",FALSE,TRUE);
				$arrdata['act'] = site_url().'/post/sampel/sampel_act/edit-admin';
			}	
			$arrdata['komoditi'] = $sipt->main->combobox("SELECT KLASIFIKASI_ID, KLASIFIKASI FROM M_GOLONGAN WHERE LEN(KLASIFIKASI_ID) = 2  AND KLASIFIKASI_ID NOT IN ('05','06','20')", "KLASIFIKASI_ID", "KLASIFIKASI", TRUE);
			$arrdata['satuan'] = $sipt->main->combobox("SELECT SATUAN_ID, NAMA_SATUAN FROM M_SATUAN ORDER BY 2 ASC", "NAMA_SATUAN", "NAMA_SATUAN", TRUE);
			$arrdata['kondisi_sampel'] = $sipt->main->referensi("KONDISI_SAMPEL","",TRUE,TRUE);
			$arrdata['segel'] = $sipt->main->referensi("SEGEL_SAMPLING","",TRUE,TRUE);
			$arrdata['label_sampel'] = $sipt->main->referensi("LABEL_SAMPLING","",TRUE,TRUE);
			$arrdata['prevadmin'] = FALSE;
			$arrdata['hasil'] = $sipt->main->combobox("SELECT LTRIM(RTRIM(KODE)) AS KODE, URAIAN FROM M_TABEL WHERE JENIS = 'HASIL' AND KODE IN ('MS','TMS','HPST')","KODE","URAIAN",TRUE);
			$arrdata['prioritas'] = array("" => "", "1" => "Data Prioritas Sampling", "0" => "Bukan Data Prioritas");
			$arrdata['uji_bidang'] = array("" => "Tidak di uji", "1" => "Di uji");
			$arrdata['bulan'] = array('' => '','Januari' => 'Januari',
									  'Februari' => 'Febuari',
									  'Maret' => 'Maret',
									  'April' => 'April',
									  'Mei' => 'Mei',
									  'Juni' => 'Juni',
									  'Juli' => 'Juli',
									  'Agustus' => 'Agustus',
									  'September' => 'September',
									  'Oktober' => 'Oktober',
									  'November' => 'November',
									  'Desember' => 'Desember');
			return $arrdata;
		}
	}
	
	function list_sampel($submenu){
		if($this->newsession->userdata('LOGGED_IN')){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$this->load->library('newtable');
			if($submenu == "draft"){
				$q = " AND A.STATUS_SAMPEL = '20106' AND A.CREATE_BY = '".$this->newsession->userdata('SESS_USER_ID')."'";
			}else if($submenu == "all"){
				if(in_array('01', $this->newsession->userdata('SESS_JENIS_PELAPORAN'))){			
					$q = " AND A.STATUS_SAMPEL NOT IN ('20106','20107','00000') AND A.ANGGARAN NOT IN ('05','06','07')";
				}
			}else if($submenu == "reject"){
				$q = " AND A.STATUS_SAMPEL = '20107' AND A.CREATE_BY = '".$this->newsession->userdata('SESS_USER_ID')."'";
			}
			$query = "SELECT A.PERIKSA_SAMPEL, A.KODE_SAMPEL, B.NOMOR_SURAT +'<div>Tanggal Sampling : ' + CONVERT(VARCHAR(10), A.TANGGAL_SAMPLING, 120) + '</div><div>Bulan Anggaran : '+ A.BULAN_ANGGARAN +'</div><div>Asal Sampel : '+dbo.URAIAN_M_TABEL('ASAL_SAMPLING',A.ASAL_SAMPEL)+'</div>' AS [NOMOR SURAT / PENGANTAR], A.NAMA_SAMPEL + '<div>' + dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) + '</div><div>' + A.BENTUK_SEDIAAN + '</div><div>' + A.PABRIK + '</div><div>' + A.NOMOR_REGISTRASI + ', No Batch  : ' +  A.NO_BETS + '</div><div>'+A.TEMPAT_SAMPLING+'</div><div>Keterangan ED : '+A.KETERANGAN_ED+'</div>' AS [IDENTITAS SAMPEL], CAST(A.JUMLAH_SAMPEL AS VARCHAR) +'&nbsp;'+ A.SATUAN +'<div>&bull;&nbsp;Uji Kimia : '+ CAST(A.JUMLAH_KIMIA AS VARCHAR)+'</div><div>&bull;&nbsp;Uji Mikro : '+CAST(A.JUMLAH_MIKRO AS VARCHAR) +'</div><div>&bull;&nbsp;Sisa Sampel : '+CAST(A.SISA AS VARCHAR) +'</div><div>' +CASE WHEN UJI_KIMIA = '1' AND UJI_MIKRO = '1' THEN 'Uji Kimia - Mikro' WHEN UJI_KIMIA = '1' THEN 'Uji Kimia' WHEN UJI_MIKRO = '1' THEN 'Uji Mikro' END+ '</div>' AS [JUMLAH UJI], dbo.KATEGORI(A.KOMODITI, A.PRIORITAS) + '<div>' + A.NAMA_KATEGORI + '</div>' AS KOMODITI, dbo.URAIAN_M_TABEL('STATUS', A.STATUS_SAMPEL) AS [STATUS], CONVERT(VARCHAR(10), A.TANGGAL_SAMPLING, 120) AS TGL_SAMPLING FROM T_M_SAMPEL A LEFT JOIN T_PERIKSA_SAMPEL B ON A.PERIKSA_SAMPEL = B.PERIKSA_SAMPEL WHERE B.BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' $q";
			$this->newtable->hiddens(array('PERIKSA_SAMPEL','KODE_SAMPEL','TGL_SAMPLING'));
			$this->newtable->search(array(array("B.NOMOR_SURAT", "Nomor Surat Tugas / Pengantar"),array("CONVERT(VARCHAR(10), A.TANGGAL_SAMPLING, 120)", "Tanggal Sampling"),array("A.BULAN_ANGGARAN","Bulan Anggaran"),array("dbo.URAIAN_M_TABEL('ASAL_SAMPLING', A.ASAL_SAMPEL)", "Asal Sampel"),array("A.NAMA_SAMPEL","Nama Sampel"),array("dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL)","Kode Sampel"),array("A.TEMPAT_SAMPLING","Tempat Sampling"),array("dbo.KATEGORI(A.KOMODITI, A.PRIORITAS)","Komoditi"),array("A.NAMA_KATEGORI","Kategori"),array("A.KETERANGAN_ED","Ket.Expired Date"),array("dbo.URAIAN_M_TABEL('STATUS', A.STATUS_SAMPEL)","Status / Proses Sampel")));
			$this->newtable->columns(array("A.PERIKSA_SAMPEL", "A.KODE_SAMPEL", "B.NOMOR_SURAT +'<div>Tanggal Sampling : ' + CONVERT(VARCHAR(10), A.TANGGAL_SAMPLING, 120) + '</div><div>Bulan Anggaran : '+ A.BULAN_ANGGARAN +'</div><div>Asal Sampel : '+dbo.URAIAN_M_TABEL('ASAL_SAMPLING',A.ASAL_SAMPEL)+'</div>'",array("A.NAMA_SAMPEL + '<div>' + dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) + '</div><div>' + A.BENTUK_SEDIAAN + '</div><div>' + A.PABRIK + '</div><div>' + A.NOMOR_REGISTRASI + ', No Batch  : ' +  A.NO_BETS + '</div><div>'+A.TEMPAT_SAMPLING+'</div><div>Keterangan ED : '+A.KETERANGAN_ED+'</div>'",site_url()."/home/sampel/preview/{PERIKSA_SAMPEL}.{KODE_SAMPEL}"),"CAST(A.JUMLAH_SAMPEL AS VARCHAR) +'&nbsp;'+ A.SATUAN +'<div>&bull;&nbsp;Uji Kimia : '+ CAST(A.JUMLAH_KIMIA AS VARCHAR)+'</div><div>&bull;&nbsp;Uji Mikro : '+CAST(A.JUMLAH_MIKRO AS VARCHAR) +'</div><div>&bull;&nbsp;Sisa Sampel : '+CAST(A.SISA AS VARCHAR) +'</div><div>' +CASE WHEN UJI_KIMIA = '1' AND UJI_MIKRO = '1' THEN 'Uji Kimia - Mikro' WHEN UJI_KIMIA = '1' THEN 'Uji Kimia' WHEN UJI_MIKRO = '1' THEN 'Uji Mikro' END+ '</div>'","dbo.KATEGORI(A.KOMODITI, A.PRIORITAS) + '<div>' + A.NAMA_KATEGORI + '</div>'","dbo.URAIAN_M_TABEL('STATUS', A.STATUS_SAMPEL)","CONVERT(VARCHAR(10), A.TANGGAL_SAMPLING, 120)"));
			$this->newtable->width(array('NOMOR SURAT / PENGANTAR' => 200,'IDENTITAS SAMPEL' => 225, 'JUMLAH UJI' => 85, 'KOMODITI' => 75, 'STATUS' => 105));
			$this->newtable->action(site_url()."/home/sampel/list/".$submenu);
			$this->newtable->cidb($this->db);
			$this->newtable->ciuri($this->uri->segment_array());
			$this->newtable->keys(array('PERIKSA_SAMPEL','KODE_SAMPEL'));
			$this->newtable->orderby(8);
			$this->newtable->sortby("DESC");
			if($submenu == "draft"){
				$judul = "Draft Data Sampel";
				$proses['Edit Data Sampel'] = array('GET', site_url().'/home/sampel/new', '1');
				$proses['Hapus Data Sampel'] = array('POST', site_url().'/post/sampel/sampel_act/delete/ajax', 'N');
				$proses['Tambahkan Ke Data SPU'] = array('MPOST', site_url().'/post/sampel/sampel_act/spu/ajax', 'N');
			}else if($submenu == "all"){
				$judul = "Sampel Dalam Proses";
				$proses['Preview Data Sampel'] = array('GET', site_url().'/home/sampel/preview', '1');
			}else if($submenu == "reject"){
				$judul = "Perbaikan Sampel";
				$proses['Edit Data Sampel'] = array('GET', site_url().'/home/sampel/new', '1');
			}
			$this->newtable->menu($proses);
			$arrdata = array('table' => $this->newtable->generate($query),
							 'idjudul' => 'judulmsampel',
							 'caption_header' => $judul,
							 'batal' => '',
							 'cancel' => '');
			return $arrdata;
			
		}
	}

	function detil_sampel($id){
		if($this->newsession->userdata('LOGGED_IN') == "TRUE"){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$arrid = explode(".",$id);
			$query = "SELECT A.PERIKSA_SAMPEL, A.SPU_ID, dbo.FORMAT_NOMOR('SPL', A.KODE_SAMPEL) AS UR_KODE, dbo.FORMAT_NOMOR('SPU', A.SPU_ID) AS UR_SPU, A.KODE_SAMPEL,dbo.KATEGORI(A.KOMODITI, A.PRIORITAS) AS KOMODITI,dbo.KATEGORI(A.KATEGORI, A.PRIORITAS) AS UR_KATEGORIX, A.NAMA_KATEGORI AS UR_KATEGORI, dbo.URAIAN_M_TABEL('SUB_TUJUAN', A.SUB_TUJUAN) AS SUB_TUJUAN, A.KLASIFIKASI_TAMBAHAN,A.NAMA_SAMPEL,A.NOMOR_REGISTRASI,A.PABRIK,IMPORTIR,A.BENTUK_SEDIAAN,A.KEMASAN,A.NO_BETS,A.KETERANGAN_ED,A.JUMLAH_SAMPEL,A.SATUAN,A.HARGA_SAMPEL,A.UJI_KIMIA,A.JUMLAH_KIMIA,A.UJI_MIKRO,A.JUMLAH_MIKRO, RTRIM(LTRIM(A.HASIL_SAMPEL)) AS HASIL_SAMPEL, RTRIM(LTRIM(A.HASIL_KIMIA)) AS HASIL_KIMIA, RTRIM(LTRIM(A.HASIL_MIKRO)) AS HASIL_MIKRO, ISNULL(A.STATUS_KIMIA,'0') AS STATUS_KIMIA, ISNULL(A.STATUS_MIKRO,'0') AS STATUS_MIKRO, A.STATUS_SAMPEL, A.SISA,REPLACE(A.KOMPOSISI,';','<br>') AS KOMPOSISI,A.NETTO,A.KONDISI_SAMPEL,A.EVALUASI_PENANDAAN,A.CARA_PENYIMPANAN, A.LABEL, A.SEGEL,A.CATATAN,A.STATUS_KIMIA,A.STATUS_MIKRO,A.STATUS_SAMPEL,A.LAMPIRAN,B.BBPOM_ID FROM T_M_SAMPEL A LEFT JOIN T_PERIKSA_SAMPEL B ON A.PERIKSA_SAMPEL = B.PERIKSA_SAMPEL WHERE A.PERIKSA_SAMPEL = '".$arrid[0]."' AND A.KODE_SAMPEL = '".$arrid[1]."'"; 
			$data = $sipt->main->get_result($query);
			if($data){
				foreach($query->result_array() as $row){
					$arrdata['sess'] = $row;
				}
				$arrdata['file'] = base_url().'files/sampel/'.md5(trim($row['BBPOM_ID'])).'/'.$row['LAMPIRAN'];
			}
			return $arrdata;
		}
	}
	
	function preview($id){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$arrid = explode(".",$id);
			$asal = $sipt->main->get_uraian("SELECT ASAL_SAMPEL FROM T_M_SAMPEL WHERE KODE_SAMPEL = '".$arrid[1]."'","ASAL_SAMPEL");
			if($asal == "13"){
				$bbpom = '';
			}else{
				$asal = $sipt->main->get_uraian("SELECT LTRIM(RTRIM(BBPOM_ID)) AS BBPOM_ID FROM T_PERIKSA_SAMPEL WHERE PERIKSA_SAMPEL = '".$arrid[0]."'","BBPOM_ID");
				$bbpom = " AND D.BBPOM_ID = '".$asal."'";
			}
			$query = "SELECT dbo.FORMAT_NOMOR('SPL', A.KODE_SAMPEL) AS UR_KODE, dbo.FORMAT_NOMOR('SPU', A.SPU_ID) AS UR_SPU, A.KODE_SAMPEL, A.PERIKSA_SAMPEL, dbo.KATEGORI(A.KOMODITI, A.PRIORITAS) AS KO, A.KOMODITI, dbo.KATEGORI(A.KATEGORI, A.PRIORITAS) AS KATEGORIX, A.NAMA_KATEGORI AS KATEGORI, A.SPU_ID, dbo.URAIAN_M_TABEL('ANGGARAN_SAMPLING', A.ANGGARAN) AS ANGGARAN, A.ANGGARAN AS AG, dbo.URAIAN_M_TABEL('ASAL_SAMPLING',A.ASAL_SAMPEL) AS ASAL_SAMPEL, dbo.URAIAN_M_TABEL('TUJUAN_SAMPLING',A.TUJUAN_SAMPLING) AS TUJUAN_SAMPLING, dbo.URAIAN_M_TABEL('SUB_TUJUAN', A.SUB_TUJUAN) AS SUB_TUJUAN, CONVERT(VARCHAR(10), A.TANGGAL_SAMPLING, 103) AS TANGGAL_SAMPLING, A.BULAN_ANGGARAN, A.SARANA_ID, A.TEMPAT_SAMPLING, A.ALAMAT_SAMPLING, A.KLASIFIKASI_TAMBAHAN, A.NAMA_SAMPEL, A.NOMOR_REGISTRASI, A.PABRIK, A.IMPORTIR, A.BENTUK_SEDIAAN, A.KEMASAN, A.NO_BETS, A.KETERANGAN_ED, A.JUMLAH_SAMPEL, A.SATUAN, A.HARGA_SAMPEL, A.UJI_KIMIA, A.JUMLAH_KIMIA, A.UJI_MIKRO, A.JUMLAH_MIKRO, RTRIM(LTRIM(A.HASIL_SAMPEL)) AS HASIL_SAMPEL, A.SISA, A.KOMPOSISI, A.NETTO, A.KONDISI_SAMPEL, A.EVALUASI_PENANDAAN, A.CARA_PENYIMPANAN, A.LABEL, A.SEGEL, RTRIM(LTRIM(A.HASIL_KIMIA)) AS HASIL_KIMIA, RTRIM(LTRIM(A.HASIL_MIKRO)) AS HASIL_MIKRO, A.UJI_UNGGULAN, A.LAMPIRAN, A.CATATAN AS [CATATAN SAMPEL], ISNULL(A.STATUS_KIMIA,'0') AS STATUS_KIMIA, ISNULL(A.STATUS_MIKRO,'0') AS STATUS_MIKRO, A.STATUS_SAMPEL, A.CATATAN_CP, dbo.URAIAN_M_TABEL('STATUS', A.STATUS_SAMPEL) AS [UR_STATUS_SAMPEL], A.PRIORITAS, B.BBPOM_ID, B.NOMOR_SURAT, CONVERT(VARCHAR(10), TANGGAL_SURAT, 103) AS TANGGAL_SURAT, B.NAMA_PENGIRIM, B.NIP_PENGIRIM, B.SURAT_PENGANTAR, B.NIP_POLISI, B.PANGKAT, B.INSTITUSI, B.ALAMAT, B.KOTA, B.NO_RESI_BANK, CONVERT(VARCHAR(10), B.TANGGAL_RESI_BANK, 103) AS TANGGAL_RESI_BANK, B.BIAYA, B.NO_LP, CONVERT(VARCHAR(10), B.TANGGAL_LP, 103) AS TANGGAL_LP, B.NO_SPDP, CONVERT(VARCHAR(10), B.TANGGAL_SPDP, 103) AS TANGGAL_SPDP, B.SAKSI_POLISI, B.NAMA_TERSANGKA, CONVERT(VARCHAR(10), B.TANGGAL_TERIMA, 103) AS TANGGAL_TERIMA, B.HARI_TERIMA, B.SAKSI_UJI, B.JUMLAH_UJI, B.CATATAN AS [CATATAN SURAT], C.USER_ID, D.NAMA_USER FROM T_M_SAMPEL A LEFT JOIN T_PERIKSA_SAMPEL B ON A.PERIKSA_SAMPEL = B.PERIKSA_SAMPEL LEFT JOIN T_PETUGAS_SAMPEL C ON A.PERIKSA_SAMPEL = C.PERIKSA_SAMPEL LEFT JOIN T_USER D ON C.USER_ID = D.USER_ID WHERE A.KODE_SAMPEL = '".$arrid[1]."' AND A.PERIKSA_SAMPEL = '".$arrid[0]."' $bbpom";
			
			$res = $sipt->main->get_result($query);
			if($res){
				$user_id = array();
				$nama_user = array();
				foreach($query->result_array() as $row){
					if(!array_key_exists($row['USER_ID'], $user_id)) $user_id[] = $row['USER_ID'];
					if(!array_key_exists($row['NAMA_USER'], $nama_user)) $nama_user[] = $row['NAMA_USER'];
					$arrdata = array('sess' => $row,
									 'caption' => 'Ubah',
									 'act' => site_url().'/post/sampel/sampel_act/update',
									 'user_id' => $user_id,
									 'nama_user' => $nama_user);

				}
				if($row['STATUS_SAMPEL'] == "40201"){
					$jmldispo = (int)$sipt->main->get_uraian("SELECT COUNT(*) AS JML FROM T_SAMPEL_MT WHERE SPU_ID = '".$row['SPU_ID']."' AND KODE_SAMPEL = '".$row['KODE_SAMPEL']."'","JML");
					if($jmldispo == 0 && (in_array('1', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('9', $this->newsession->userdata('SESS_KODE_ROLE')))){
						$arrdata['redispo'] = TRUE;
					}
				}
				$arrdata['file'] = base_url().'files/sampel/'.md5(trim($row['BBPOM_ID'])).'/'.$row['LAMPIRAN'];
				$arrdata['jml_log'] = $sipt->main->get_uraian("SELECT COUNT(*) AS JML FROM T_SAMPLING_LOG WHERE KODE_SAMPEL = '".$arrid[1]."'","JML");
				$arrext = array('05','06','07');
				if(in_array($row['AG'], $arrext)){
					redirect(site_url()."/home/sampelx/preview/".$row['PERIKSA_SAMPEL'].".".$row['KODE_SAMPEL']); exit();
				}
			}
			return $arrdata;
		}
	}
	
	function set_sampel($action, $isajax){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE && (in_array('1',$this->newsession->userdata('SESS_KODE_ROLE')) || in_array('9',$this->newsession->userdata('SESS_KODE_ROLE')) || in_array('2',$this->newsession->userdata('SESS_KODE_ROLE')) || in_array('3',$this->newsession->userdata('SESS_KODE_ROLE')) || in_array('4',$this->newsession->userdata('SESS_KODE_ROLE')) || in_array('7',$this->newsession->userdata('SESS_KODE_ROLE')) ||  in_array('9',$this->newsession->userdata('SESS_KODE_ROLE')))){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			if($action=="save"){#Tambah Sampel Baru
				$hasil = FALSE;
				$msgok = "Tambah data sampel baru berhasil";
				$msgerr = "Tambah data sampel baru gagal, Silahkan coba lagi";
				$dtperiksa = $sipt->main->post_to_query($this->input->post('SURAT')); 
				$dtsampel = $sipt->main->post_to_query($this->input->post('SAMPEL'));
				$arr_petugas = $this->input->post('USER_ID');
				$pengirim = $sipt->main->get_uraian("SELECT COUNT(*) AS JML FROM t_user WHERE USER_ID = '".$this->input->post('nip_rutin')."'","JML");
				if($pengirim == 0){
					return "MSG#NO#Maaf, Nama petugas pengirim tidak terdaftar"; die();
				}
				if(!$arr_petugas){
					return "MSG#NO#Anda Belum Memasukan Petugas Pemeriksa";	die();
				}
				
				if(trim($this->input->post('surat_id')) == ""){#Surat Tugas Baru
					$periksa_sampel = (int)$sipt->main->get_uraian("SELECT MAX(PERIKSA_SAMPEL) AS MAXID FROM T_PERIKSA_SAMPEL", "MAXID") + 1;
					$dtperiksa['PERIKSA_SAMPEL'] = $periksa_sampel;
					if($dtsampel['ANGGARAN'] == "05"){
						$dtperiksa['NAMA_PENGIRIM'] = $this->input->post('pengirim_polisi');
						$dtperiksa['NIP'] = $this->input->post('nip_polisi'); 
					}else{
						$dtperiksa['NAMA_PENGIRIM'] = $this->input->post('pengirim_rutin');
						$dtperiksa['NIP_PENGIRIM'] = $this->input->post('nip_rutin'); 
					}
					if(array_key_exists('BIAYA', $dtperiksa)) $dtperiksa['BIAYA'] = (float)$dtperiksa['BIAYA'];
					if(array_key_exists('JUMLAH_UJI', $dtperiksa)) $dtperiksa['JUMLAH_UJI'] = (int)$dtperiksa['JUMLAH_UJI'];
					if($dtperiksa['TANGGAL_LP'] == "") $dtperiksa['TANGGAL_LP'] = null;
					if($dtperiksa['TANGGAL_SPDP'] == "") $dtperiksa['TANGGAL_SPDP'] = null;
					if($dtperiksa['TANGGAL_TERIMA'] == "") $dtperiksa['TANGGAL_TERIMA'] = null;
					if($dtperiksa['TANGGAL_RESI_BANK'] == "") $dtperiksa['TANGGAL_RESI_BANK'] = null;
					$dtperiksa['BBPOM_ID'] = $this->newsession->userdata('SESS_BBPOM_ID');
					$dtperiksa['CREATE_BY'] = $this->newsession->userdata('SESS_USER_ID');
					$dtperiksa['CREATE_DATE'] = 'GETDATE()';
					$res = $this->db->insert('T_PERIKSA_SAMPEL', $dtperiksa);
					if($res){
						$hasil = TRUE;
						foreach($arr_petugas as $a){#Petugas Sampel Rutin
							$petugas_sampel['PERIKSA_SAMPEL'] = $periksa_sampel;
							$petugas_sampel['USER_ID'] = $a;
							$this->db->insert('T_PETUGAS_SAMPEL', $petugas_sampel);
						}
					}else{
						$hasil = FALSE;
					}
				}else{
					$hasil = TRUE;
					$periksa_sampel = $this->input->post('surat_id');
				}
				
				if($hasil){
					$dtsampel['PERIKSA_SAMPEL'] = $periksa_sampel;
					$kategori= array_filter($this->input->post('KOMODITI'));
					$dtsampel['KATEGORI'] = $kategori[count($kategori)-1];
					$dtsampel['KOMODITI'] = substr($dtsampel['KATEGORI'], 0, 2);
					$arrrekap = $this->input->post('KOMODITI');
					$dtsampel['REKAP_KOMODITI'] = $arrrekap[1];
					
					$chk = (int)$sipt->main->get_uraian("SELECT AUTO_RESET FROM M_REF_SAMPEL WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND ANGGARAN = '".$dtsampel['ANGGARAN']."' AND KOMODITI = '".$dtsampel['KOMODITI']."'","AUTO_RESET");
					if($chk == 1)
						$dtsampel['KODE_SAMPEL'] = $sipt->main->set_kode_sampel($dtsampel['TUJUAN_SAMPLING'],$dtsampel['ANGGARAN'],$dtsampel['KOMODITI'], join("",$this->input->post('lab')),$dtsampel['TANGGAL_SAMPLING']);
					else
						$dtsampel['KODE_SAMPEL'] = $sipt->main->set_kode_sampel($dtsampel['TUJUAN_SAMPLING'],$dtsampel['ANGGARAN'],$dtsampel['KOMODITI'], join("",$this->input->post('lab')),$dtsampel['TANGGAL_SAMPLING']);
					$dtsampel['BBPOM_ID'] = $this->newsession->userdata('SESS_BBPOM_ID');
					$dtsampel['NAMA_SAMPEL'] = str_replace("'","",$dtsampel['NAMA_SAMPEL']);
					$dtsampel['PABRIK'] = str_replace("'","",$dtsampel['PABRIK']);
					$dtsampel['IMPORTIR'] = str_replace("'","",$dtsampel['IMPORTIR']);
					$dtsampel['JUMLAH_SAMPEL'] = (float)$dtsampel['JUMLAH_SAMPEL'];
					$dtsampel['JUMLAH_KIMIA'] = (float)$dtsampel['JUMLAH_KIMIA'];
					$dtsampel['JUMLAH_MIKRO'] = (float)$dtsampel['JUMLAH_MIKRO'];
					$dtsampel['SISA'] = (float)$dtsampel['SISA'];
					$dtsampel['HARGA_SAMPEL'] = (float)$dtsampel['HARGA_SAMPEL'];
					$dtsampel['ALAMAT_SAMPLING'] = $sipt->main->get_uraian("SELECT ALAMAT_1 FROM M_SARANA WHERE SARANA_ID = '".$dtsampel['SARANA_ID']."'","ALAMAT_1");
					$dtsampel['KONDISI_SAMPEL'] = join(",", $this->input->post('KONDISI_SAMPEL'));
					if(in_array('M', $this->input->post('lab'))){
						$dtsampel['UJI_KIMIA'] = '0';
						$dtsampel['UJI_MIKRO'] = '1';
					}
					if(in_array('K', $this->input->post('lab'))){
						$dtsampel['UJI_KIMIA'] = '1';
						$dtsampel['UJI_MIKRO'] = '0';
					}
					if(in_array('M', $this->input->post('lab')) && in_array('K', $this->input->post('lab'))){
						$dtsampel['UJI_KIMIA'] = '1';
						$dtsampel['UJI_MIKRO'] = '1';
					}
					$dtsampel['STATUS_SAMPEL'] = '20106';
					$dtsampel['CARA_PENYIMPANAN'] = str_replace("<"," < ",preg_replace('/[^(\x20-\x7F)]*/','',$sipt->main->clean_tags($dtsampel['CARA_PENYIMPANAN'])));
					$dtsampel['KOMPOSISI'] = str_replace(">", " > ", str_replace("<"," < ", preg_replace('/[^(\x20-\x7F)]*/','',$sipt->main->clean_tags($dtsampel['KOMPOSISI']))));
					$dtsampel['CATATAN'] = str_replace("<"," < ", preg_replace('/[^(\x20-\x7F)]*/','',$sipt->main->clean_tags($dtsampel['CATATAN'])));
					$dtsampel['CREATE_BY'] = $this->newsession->userdata('SESS_USER_ID');
					$dtsampel['CREATE_DATE'] = 'GETDATE()';
					
					$dtsampel['NAMA_KATEGORI'] = $sipt->main->get_uraian("SELECT REPLACE(dbo.KATEGORI('".$dtsampel['KATEGORI']."', '".$dtsampel['PRIORITAS']."'), '&raquo;', ' - ') AS NAMA_KATEGORI","NAMA_KATEGORI");
					
					$resampel = $this->db->insert('T_M_SAMPEL', $dtsampel);
					if($resampel){
						$data = array('KODE_SAMPEL' => $dtsampel['KODE_SAMPEL'],
									  'WAKTU' => 'GETDATE()',
									  'USER_ID' => $this->newsession->userdata('SESS_USER_ID'),
									  'KEGIATAN' => 'Simpan data sampel, dengan kode : '. $dtsampel['KODE_SAMPEL'],
									  'CATATAN' => '-');
						$this->db->insert('T_SAMPLING_LOG', $data);
						return "MSG#YES#$msgok#".site_url().'/home/sampel/list/draft';
					}
				}else{
					return "MSG#NO#$msgerr";
				}
				if($isajax!="ajax"){
					redirect(base_url());
					exit();
				}
			}
			else if($action=="update"){#Edit Sampel
				$hasil = FALSE;
				$msgok = "Edit data sampel baru berhasil";
				$msgerr = "Edit data sampel baru gagal, Silahkan coba lagi";
				$dtperiksa = $sipt->main->post_to_query($this->input->post('SURAT')); 
				$dtsampel = $sipt->main->post_to_query($this->input->post('SAMPEL'));
				$arr_petugas = $this->input->post('USER_ID');
				$pengirim = $sipt->main->get_uraian("SELECT COUNT(*) AS JML FROM t_user WHERE USER_ID = '".$this->input->post('nip_rutin')."'","JML");
				if($pengirim == 0){
					return "MSG#NO#Maaf, Nama petugas pengirim tidak terdaftar"; die();
				}
				if(!$arr_petugas){
					return "MSG#NO#Anda Belum Memasukan Petugas Pemeriksa";	die();
				}
				if($dtsampel['ANGGARAN'] == "05"){
					$dtperiksa['NAMA_PENGIRIM'] = $this->input->post('pengirim_polisi');
					$dtperiksa['NIP'] = $this->input->post('nip_polisi'); 
				}else{
					$dtperiksa['NAMA_PENGIRIM'] = $this->input->post('pengirim_rutin');
					$dtperiksa['NIP_PENGIRIM'] = $this->input->post('nip_rutin'); 
				}
				if(array_key_exists('BIAYA', $dtperiksa)) $dtperiksa['BIAYA'] = (float)$dtperiksa['BIAYA'];
				if(array_key_exists('JUMLAH_UJI', $dtperiksa)) $dtperiksa['JUMLAH_UJI'] = (int)$dtperiksa['JUMLAH_UJI'];
				if($dtperiksa['TANGGAL_LP'] == "") $dtperiksa['TANGGAL_LP'] = null;
				if($dtperiksa['TANGGAL_SPDP'] == "") $dtperiksa['TANGGAL_SPDP'] = null;
				if($dtperiksa['TANGGAL_TERIMA'] == "") $dtperiksa['TANGGAL_TERIMA'] = null;
				if($dtperiksa['TANGGAL_RESI_BANK'] == "") $dtperiksa['TANGGAL_RESI_BANK'] = null;
				$this->db->where('PERIKSA_SAMPEL', $this->input->post('periksa_sampel'));
				$res = $this->db->update('T_PERIKSA_SAMPEL', $dtperiksa);
				if($res){
					$hasil = TRUE;
					$this->db->where('PERIKSA_SAMPEL', $this->input->post('periksa_sampel'));
					$this->db->delete('T_PETUGAS_SAMPEL');
					foreach($arr_petugas as $a){#Petugas Sampel Rutin
						$petugas_sampel['PERIKSA_SAMPEL'] = $this->input->post('periksa_sampel');
						$petugas_sampel['USER_ID'] = $a;
						$this->db->insert('T_PETUGAS_SAMPEL', $petugas_sampel);
					}
				}else{
					$hasil = FALSE;
				}
				if($hasil){
					$kategori= array_filter($this->input->post('KOMODITI'));
					$dtsampel['KATEGORI'] = $kategori[count($kategori)-1];
					$dtsampel['KOMODITI'] = substr($dtsampel['KATEGORI'], 0, 2);
					$arrrekap = $this->input->post('KOMODITI');
					$dtsampel['REKAP_KOMODITI'] = $arrrekap[1];
					$dtsampel['NAMA_SAMPEL'] = str_replace("'","",$dtsampel['NAMA_SAMPEL']);
					$dtsampel['PABRIK'] = str_replace("'","",$dtsampel['PABRIK']);
					$dtsampel['IMPORTIR'] = str_replace("'","",$dtsampel['IMPORTIR']);
					$dtsampel['JUMLAH_SAMPEL'] = (float)$dtsampel['JUMLAH_SAMPEL'];
					$dtsampel['JUMLAH_KIMIA'] = (float)$dtsampel['JUMLAH_KIMIA'];
					$dtsampel['JUMLAH_MIKRO'] = (float)$dtsampel['JUMLAH_MIKRO'];
					$dtsampel['SISA'] = (float)$dtsampel['SISA'];
					$dtsampel['HARGA_SAMPEL'] = (float)$dtsampel['HARGA_SAMPEL'];
					$dtsampel['ALAMAT_SAMPLING'] = $sipt->main->get_uraian("SELECT ALAMAT_1 FROM M_SARANA WHERE SARANA_ID = '".$dtsampel['SARANA_ID']."'","ALAMAT_1");
					$dtsampel['KONDISI_SAMPEL'] = join(",", $this->input->post('KONDISI_SAMPEL'));
					if(in_array('M', $this->input->post('lab'))){
						$dtsampel['UJI_KIMIA'] = '0';
						$dtsampel['UJI_MIKRO'] = '1';
					}
					if(in_array('K', $this->input->post('lab'))){
						$dtsampel['UJI_KIMIA'] = '1';
						$dtsampel['UJI_MIKRO'] = '0';
					}
					if(in_array('M', $this->input->post('lab')) && in_array('K', $this->input->post('lab'))){
						$dtsampel['UJI_KIMIA'] = '1';
						$dtsampel['UJI_MIKRO'] = '1';
					}
					$dtsampel['CARA_PENYIMPANAN'] = str_replace("<"," < ",preg_replace('/[^(\x20-\x7F)]*/','',$sipt->main->clean_tags($dtsampel['CARA_PENYIMPANAN'])));
					$dtsampel['KOMPOSISI'] =str_replace(">", " > ", str_replace("<"," < ", preg_replace('/[^(\x20-\x7F)]*/','',$sipt->main->clean_tags($dtsampel['KOMPOSISI']))));
					$dtsampel['CATATAN'] = str_replace("<"," < ",preg_replace('/[^(\x20-\x7F)]*/','',$sipt->main->clean_tags($dtsampel['CATATAN'])));
					$dtsampel['NAMA_KATEGORI'] = $sipt->main->get_uraian("SELECT REPLACE(dbo.KATEGORI('".$dtsampel['KATEGORI']."', '".$dtsampel['PRIORITAS']."'), '&raquo;', ' - ') AS NAMA_KATEGORI","NAMA_KATEGORI");
					$this->db->where('KODE_SAMPEL', $this->input->post('kode_sampel'));
					$resampel = $this->db->update('T_M_SAMPEL', $dtsampel);
					if($resampel){
						if(strlen($this->input->post('SPU_ID')) > 1){
							$kegiatan = $this->input->post('KEGIATAN');
							$last_status = $sipt->main->get_uraian("SELECT STATUS FROM T_SPU WHERE SPU_ID = '".$this->input->post('SPU_ID')."'","STATUS");
							$this->db->simple_query("UPDATE T_M_SAMPEL SET STATUS_SAMPEL = '".$last_status."' WHERE KODE_SAMPEL = '".$this->input->post('kode_sampel')."' AND SPU_ID = '".$this->input->post('SPU_ID')."'");
							$ret = "MSG#YES#$msgok#".site_url().'/home/sampel/list/all';
						}else{
							$kegiatan = "Ubah data sampel ". $this->input->post('kode_sampel');
							$ret = "MSG#YES#$msgok#".site_url().'/home/sampel/list/draft';
						}
						$data = array('KODE_SAMPEL' => $this->input->post('kode_sampel'),
									  'WAKTU' => 'GETDATE()',
									  'USER_ID' => $this->newsession->userdata('SESS_USER_ID'),
									  'KEGIATAN' => $kegiatan,
									  'CATATAN' => '-');
						$this->db->insert('T_SAMPLING_LOG', $data);
						return $ret;
					}
				}else{
					return "MSG#NO#$msgerr";
				}
				if($isajax!="ajax"){
					redirect(base_url());
					exit();
				}
			}
			else if($action=="delete"){#Hapus Sampel
				$msgok  = 'Hapus data sampel berhasil.#';
				$msgerr = 'Hapus data sampel gagal, Silahkan coba lagi.';
				$hasil = FALSE;
				foreach($this->input->post('tb_chk') as $a){
					$id = explode(".",$a);
					$sql = "UPDATE T_M_SAMPEL SET STATUS_SAMPEL = '00000' WHERE KODE_SAMPEL = '".$id[1]."'";
					if($this->db->simple_query($sql)){
						$hasil = TRUE;
						$data = array('KODE_SAMPEL' => $id[1],
									  'WAKTU' => 'GETDATE()',
									  'USER_ID' => $this->newsession->userdata('SESS_USER_ID'),
									  'KEGIATAN' => 'Hapus Data Sampel',
									  'CATATAN' => '-');
						$this->db->insert('T_SAMPLING_LOG', $data);
					}
				}
				if($hasil){
					return "MSG#$msgok";
				}else{
					return "MSG#$msgerr";
				}
			}
			else if($action=="spu"){#Create Data SPU dari Sampel Terpilih
				$kode = "";
				foreach($this->input->post('tb_chk') as $chk){
					$id = explode(".", $chk);
					$kode .= "'".$id[1] . "'" . ",";
				}
				$arrid = substr($kode, 0, -1);
				$cek = $sipt->main->get_uraian("SELECT COUNT(JML) AS JML FROM (SELECT DISTINCT(KOMODITI) AS JML FROM T_M_SAMPEL WHERE KODE_SAMPEL IN ($arrid)) AS DATA","JML");
				if($cek > 1){
					echo "Pembuatan Data SPU Gagal. <br> Hal ini dikarenakan ada satu atau beberapa sampel yang berbeda komoditi. <br> Silahkan untuk melakukan kroscek kembali atau sorting data pada kolom KOMODITI daftar data sampel.";
					die();
				}else{
					$row = $this->db->query("SELECT dbo.FORMAT_NOMOR('SPL', KODE_SAMPEL) AS [KODE SAMPEL], dbo.URAIAN_M_TABEL('ANGGARAN_SAMPLING',ANGGARAN) AS UR_ANGGARAN, ANGGARAN, BULAN_ANGGARAN, ASAL_SAMPEL, dbo.URAIAN_M_TABEL('ASAL_SAMPLING',ASAL_SAMPEL) AS UR_ASAL_SAMPEL, NAMA_SAMPEL, KOMODITI, dbo.KATEGORI(KOMODITI, PRIORITAS) AS [UR_KOMODITIX], NAMA_KATEGORI AS UR_KOMODITI, JUMLAH_SAMPEL, SATUAN, JUMLAH_KIMIA, JUMLAH_MIKRO, CASE WHEN UJI_KIMIA = '1' AND UJI_MIKRO = '1' THEN 'Uji Kimia - Mikro' WHEN UJI_KIMIA = '1' THEN 'Uji Kimia' WHEN UJI_MIKRO = '1' THEN 'Uji Mikro' END AS [JENIS UJI] FROM T_M_SAMPEL WHERE KODE_SAMPEL IN ($arrid)")->result_array();
					$data = array('act' => site_url().'/post/spu/spu_act/save',
								  'row' => $row,
								  'arrid' => $arrid);
					echo $this->load->view('pengujian/spu-pemdik/new', $data);
				}
			}
			else if($action=="reject"){#Penolakan Sampel
				$hasil = FALSE;
				foreach($this->input->post('tb_chk') as $chk){
					$kode = explode(".", $chk);
					$sql = "UPDATE T_M_SAMPEL SET STATUS_SAMPEL = '20107' WHERE KODE_SAMPEL = '".$kode[1]."'";
					if($this->db->simple_query($sql)){
						$hasil = TRUE;
						$data = array('KODE_SAMPEL' => $kode[1],
									  'WAKTU' => 'GETDATE()',
									  'USER_ID' => $this->newsession->userdata('SESS_USER_ID'),
									  'KEGIATAN' => 'Perbaikan data sampel',
									  'CATATAN' => '-');
						$this->db->insert('T_SAMPLING_LOG', $data);
					}
				}
				if($hasil){
					return $ret = "MSG#Proses penolakan sampel berhasil#";
				}else{
					return $ret = "MSG#Proses penolakan sampel gagal.";
				}
			}
			else if($action=="tolak"){
				$hasil = FALSE;
				$msgok = "Proses permintaan perbaikan sampel berhasil dikirim";
				$msgerr = "Proses permintaan perbaikan sampel gagal dikirim, Silahkan coba lagi";
				$res = $this->db->simple_query("UPDATE T_M_SAMPEL SET STATUS_SAMPEL = '20107' WHERE KODE_SAMPEL = '".$this->input->post('KODE_SAMPEL')."'");
				if($res){
					$hasil = TRUE;
					$arrlog = array('KODE_SAMPEL' => $this->input->post('KODE_SAMPEL'),
									'WAKTU' => 'GETDATE()',
									'USER_ID' => $this->newsession->userdata('SESS_USER_ID'),
									'KEGIATAN' => 'Perbaikan data sampel',
									'CATATAN' => $this->input->post('KEGIATAN'));
					$this->db->insert('T_SAMPLING_LOG', $arrlog);
				}
				if($hasil){
					return "MSG#YES#$msgok#".site_url()."/home/spu/preview/".$this->input->post('SPU_ID');
				}else{
					return "MSG##NO#$msgerr";
				}
			}
			else if($action == "edit-kategori"){
				$hasil = FALSE;
				$msgok = "Edit data kategori sampel berhasil";
				$msgerr = "Edit data kategori sampel gagal";
				$kategori= array_filter($this->input->post('KOMODITI'));
				$dtsampel['KATEGORI'] = $kategori[count($kategori)-1];
				//print_r($dtsampel);die();
				if($this->input->post('exist') == "Y")
				{
					$dtsampel['NAMA_KATEGORI'] = $sipt->main->get_uraian("SELECT REPLACE(dbo.KATEGORI('".$dtsampel['KATEGORI']."', '".$this->input->post('prioritas')."'), '&raquo;', ' - ') AS NAMA_KATEGORI","NAMA_KATEGORI");
				}
				else
				{
					$dtsampel['NAMA_KATEGORI'] = $sipt->main->get_uraian("SELECT REPLACE(dbo.KATEGORI_NONEXISTING('".$dtsampel['KATEGORI']."', '".$this->input->post('prioritas')."'), '&raquo;', ' - ') AS NAMA_KATEGORI","NAMA_KATEGORI");
				}
				$this->db->where('KODE_SAMPEL', $this->input->post('kode_sampel'));
				$resampel = $this->db->update('T_M_SAMPEL', $dtsampel);
				if($resampel){
					return "MSG#YES#$msgok#SUKSES";
				}else{
					return "MSG#NO#$msgerr";
				}
			}
			else if($action == "edit-admin"){
				$hasil = FALSE;
				$msgok = "Edit data sampel berhasil";
				$msgerr = "Edit data sampel gagal, Silahkan coba lagi";
				$dtperiksa = $sipt->main->post_to_query($this->input->post('SURAT')); 
				$dtsampel = $sipt->main->post_to_query($this->input->post('SAMPEL'));
				$arr_petugas = $this->input->post('USER_ID');
				$asal = $sipt->main->get_uraian("SELECT RTRIM(LTRIM(ASAL_SAMPEL)) AS  ASAL_SAMPEL FROM T_M_SAMPEL WHERE KODE_SAMPEL = '".$this->input->post('kode_sampel')."'","ASAL_SAMPEL");
				$arrexternal = array('10','11','12');
					
				if(!$this->input->post('external')){
					$pengirim = $sipt->main->get_uraian("SELECT COUNT(*) AS JML FROM t_user WHERE USER_ID = '".$this->input->post('nip_rutin')."'","JML");
					if($pengirim == 0){
						return "MSG#NO#Maaf, Nama petugas pengirim tidak terdaftar"; die();
					}
					if(!in_array($asal, $arrexternal)){
						if(!$arr_petugas){
							return "MSG#NO#Anda Belum Memasukan Petugas Pemeriksa";	die();
						}
					}
				}
				
				if($dtsampel['ANGGARAN'] == "05"){
					$dtperiksa['NAMA_PENGIRIM'] = $this->input->post('pengirim_polisi');
					$dtperiksa['NIP_PENGIRIM'] = $this->input->post('nip_polisi'); 
				}else{
					$dtperiksa['NAMA_PENGIRIM'] = $this->input->post('pengirim_rutin');
					$dtperiksa['NIP_PENGIRIM'] = $this->input->post('nip_rutin'); 
				}
				if(array_key_exists('BIAYA', $dtperiksa)) $dtperiksa['BIAYA'] = (float)$dtperiksa['BIAYA'];
				if(array_key_exists('JUMLAH_UJI', $dtperiksa)) $dtperiksa['JUMLAH_UJI'] = (int)$dtperiksa['JUMLAH_UJI'];
				if($dtperiksa['TANGGAL_LP'] == "") $dtperiksa['TANGGAL_LP'] = null;
				if($dtperiksa['TANGGAL_SPDP'] == "") $dtperiksa['TANGGAL_SPDP'] = null;
				if($dtperiksa['TANGGAL_TERIMA'] == "") $dtperiksa['TANGGAL_TERIMA'] = null;
				if($dtperiksa['TANGGAL_RESI_BANK'] == "") $dtperiksa['TANGGAL_RESI_BANK'] = null;
				$this->db->where('PERIKSA_SAMPEL', $this->input->post('periksa_sampel'));
				$res = $this->db->update('T_PERIKSA_SAMPEL', $dtperiksa);
				if($res){
					$hasil = TRUE;
					if(!in_array($asal, $arrexternal)){
						$this->db->where('PERIKSA_SAMPEL', $this->input->post('periksa_sampel'));
						$this->db->delete('T_PETUGAS_SAMPEL');
						foreach($arr_petugas as $a){#Petugas Sampel Rutin
							$petugas_sampel['PERIKSA_SAMPEL'] = $this->input->post('periksa_sampel');
							$petugas_sampel['USER_ID'] = $a;
							$this->db->insert('T_PETUGAS_SAMPEL', $petugas_sampel);
						}
					}
				}else{
					$hasil = FALSE;
				}
				if($hasil){
					$kategori= array_filter($this->input->post('KOMODITI'));
					$dtsampel['KATEGORI'] = $kategori[count($kategori)-1];
					$dtsampel['KOMODITI'] = substr($dtsampel['KATEGORI'], 0, 2);
					$arrrekap = $this->input->post('KOMODITI');
					$dtsampel['REKAP_KOMODITI'] = $arrrekap[1];
					$dtsampel['NAMA_SAMPEL'] = str_replace("'","",$dtsampel['NAMA_SAMPEL']);
					$dtsampel['PABRIK'] = str_replace("'","",$dtsampel['PABRIK']);
					$dtsampel['IMPORTIR'] = str_replace("'","",$dtsampel['IMPORTIR']);
					$dtsampel['JUMLAH_SAMPEL'] = (float)$dtsampel['JUMLAH_SAMPEL'];
					$dtsampel['JUMLAH_KIMIA'] = (float)$dtsampel['JUMLAH_KIMIA'];
					$dtsampel['JUMLAH_MIKRO'] = (float)$dtsampel['JUMLAH_MIKRO'];
					$dtsampel['SISA'] = (float)$dtsampel['SISA'];
					$dtsampel['HARGA_SAMPEL'] = (float)$dtsampel['HARGA_SAMPEL'];
					$dtsampel['ALAMAT_SAMPLING'] = $sipt->main->get_uraian("SELECT ALAMAT_1 FROM M_SARANA WHERE SARANA_ID = '".$dtsampel['SARANA_ID']."'","ALAMAT_1");
					$dtsampel['KONDISI_SAMPEL'] = join(",", $this->input->post('KONDISI_SAMPEL'));
					if(in_array('M', $this->input->post('lab'))){
						$dtsampel['UJI_KIMIA'] = '0';
						$dtsampel['UJI_MIKRO'] = '1';
					}
					if(in_array('K', $this->input->post('lab'))){
						$dtsampel['UJI_KIMIA'] = '1';
						$dtsampel['UJI_MIKRO'] = '0';
					}
					if(in_array('M', $this->input->post('lab')) && in_array('K', $this->input->post('lab'))){
						$dtsampel['UJI_KIMIA'] = '1';
						$dtsampel['UJI_MIKRO'] = '1';
					}
					$dtsampel['CARA_PENYIMPANAN'] = str_replace("<"," < ",preg_replace('/[^(\x20-\x7F)]*/','',$sipt->main->clean_tags($dtsampel['CARA_PENYIMPANAN'])));
					$dtsampel['KOMPOSISI'] =str_replace(">", " > ", str_replace("<"," < ", preg_replace('/[^(\x20-\x7F)]*/','',$sipt->main->clean_tags($dtsampel['KOMPOSISI']))));
					$dtsampel['CATATAN'] = str_replace("<"," < ",preg_replace('/[^(\x20-\x7F)]*/','',$sipt->main->clean_tags($dtsampel['CATATAN'])));
					$this->db->where('KODE_SAMPEL', $this->input->post('kode_sampel'));
					$resampel = $this->db->update('T_M_SAMPEL', $dtsampel);
					if($resampel){
						if($this->input->post('PNBP')){
							$this->db->where('KODE_SAMPEL', $this->input->post('kode_sampel'));
							$this->db->delete('T_PNBP_SAMPLING');
							$arrpnbp = $this->input->post('PNBP');
							$arrkeys = array_keys($arrpnbp);
							for($i=0;$i<count($arrpnbp[$arrkeys[0]]);$i++){
								$seri = (int)$sipt->main->get_uraian("SELECT MAX(SERI) AS MAXID FROM T_PNBP_SAMPLING WHERE KODE_SAMPEL = '".$this->input->post('kode_sampel')."'", "MAXID") + 1;
								$datapnbp = array('KODE_SAMPEL' => $this->input->post('kode_sampel'),
												  'SERI' => $seri);
								for($j=0;$j<count($arrkeys);$j++){
									$datapnbp[$arrkeys[$j]] = $arrpnbp[$arrkeys[$j]][$i];
								}
								$this->db->insert('T_PNBP_SAMPLING', $datapnbp);
							}
						}
						
						$jml = $sipt->main->get_uraian("SELECT COUNT(*) AS JML FROM T_M_SAMPEL_RILIS WHERE KODE_SAMPEL = '".$this->input->post('kode_sampel') . "'","JML");
						
						if($jml > 0){
							$arrrilis['KOMODITI'] = $dtsampel['KOMODITI'];
							$arrrilis['KATEGORI'] = $dtsampel['KATEGORI'];
							$arrrilis['ANGGARAN'] = $dtsampel['ANGGARAN'];
							$arrrilis['TUJUAN_SAMPLING'] = $dtsampel['TUJUAN_SAMPLING'];
							$arrrilis['SUB_TUJUAN'] = $dtsampel['SUB_TUJUAN'];
							$arrrilis['NAMA_SAMPEL'] = $dtsampel['NAMA_SAMPEL'];
							$arrrilis['ASAL_SAMPEL'] = $dtsampel['ASAL_SAMPEL'];
							$arrrilis['TANGGAL_SAMPLING'] = $dtsampel['TANGGAL_SAMPLING'];
							$arrrilis['SARANA_ID'] = $dtsampel['SARANA_ID'];
							$arrrilis['TEMPAT_SAMPLING'] = $dtsampel['TEMPAT_SAMPLING'];
							$arrrilis['ALAMAT_SAMPLING'] = $dtsampel['ALAMAT_SAMPLING'];
							$arrrilis['NOMOR_REGISTRASI'] = $dtsampel['NOMOR_REGISTRASI'];
							$arrrilis['PABRIK'] = $dtsampel['PABRIK'];
							$arrrilis['IMPORTIR'] = $dtsampel['IMPORTIR'];
							$arrrilis['BENTUK_SEDIAAN'] = $dtsampel['BENTUK_SEDIAAN'];
							$arrrilis['KEMASAN'] = $dtsampel['KEMASAN'];
							$arrrilis['NO_BETS'] = $dtsampel['NO_BETS'];
							$arrrilis['KETERANGAN_ED'] = $dtsampel['KETERANGAN_ED'];
							$arrrilis['JUMLAH_SAMPEL'] = $dtsampel['JUMLAH_SAMPEL'];
							$arrrilis['SATUAN'] = $dtsampel['SATUAN'];
							$arrrilis['HARGA_SAMPEL'] = $dtsampel['HARGA_SAMPEL'];
							$arrrilis['UJI_KIMIA'] = $dtsampel['UJI_KIMIA'];
							$arrrilis['JUMLAH_KIMIA'] = $dtsampel['JUMLAH_KIMIA'];
							$arrrilis['UJI_MIKRO'] = $dtsampel['UJI_MIKRO'];
							$arrrilis['JUMLAH_MIKRO'] = $dtsampel['JUMLAH_MIKRO'];
							$arrrilis['SISA'] = $dtsampel['SISA'];
							$arrrilis['KOMPOSISI'] = $dtsampel['KOMPOSISI'];
							$arrrilis['NETTO'] = $dtsampel['NETTO'];
							$arrrilis['KONDISI_SAMPEL'] = $dtsampel['KONDISI_SAMPEL'];
							$arrrilis['EVALUASI_PENANDAAN'] = $dtsampel['EVALUASI_PENANDAAN'];
							$arrrilis['CARA_PENYIMPANAN'] = $dtsampel['CARA_PENYIMPANAN'];
							$arrrilis['HASIL_KIMIA'] = $dtsampel['HASIL_KIMIA'];
							$arrrilis['HASIL_MIKRO'] = $dtsampel['HASIL_MIKRO'];
							$arrrilis['HASIL_SAMPEL'] = $dtsampel['HASIL_SAMPEL'];
							$this->db->where('KODE_SAMPEL', $this->input->post('kode_sampel'));
							$this->db->update('T_M_SAMPEL_RILIS', $arrrilis);
						}
						
						if(!in_array('1',$this->newsession->userdata('SESS_KODE_ROLE'))){
							$kegiatan = "Ubah data sampel ". $this->input->post('kode_sampel');
							$data = array('KODE_SAMPEL' => $this->input->post('kode_sampel'),
										  'WAKTU' => 'GETDATE()',
										  'USER_ID' => $this->newsession->userdata('SESS_USER_ID'),
										  'KEGIATAN' => $kegiatan,
										  'CATATAN' => '-');
							$this->db->insert('T_SAMPLING_LOG', $data);
						}
						return "MSG#YES#$msgok";
					}
				}else{
					return "MSG#NO#$msgerr";
				}
				if($isajax!="ajax"){
					redirect(base_url());
					exit();
				}
			}
			else if($action == "update-parameter"){
				$hasil = FALSE;
				$msgok = "Edit data hasil parameter uji, hasil bidang pengujian dan hasil sampel berhasil";
				$msgerr = "Edit data hasil parameter uji, hasil bidang pengujian dan hasil sampel gagal disimpan";
				$dtsampel = $sipt->main->post_to_query($this->input->post('SAMPEL'));
				$ada = $sipt->main->get_uraian("SELECT COUNT(*) AS JML FROM T_M_SAMPEL_RILIS WHERE KODE_SAMPEL = '".$this->input->post('KODE_SAMPEL')."'","JML");
				$inc = 0;
				$this->db->where('KODE_SAMPEL', $this->input->post('KODE_SAMPEL'));
				$resampel = $this->db->update('T_M_SAMPEL', $dtsampel);
				if($resampel){
					$parameter = $this->input->post('PARAMETER');
					$arrkeys_params = array_keys($parameter);
					for($i = 0; $i < count($_POST['PARAMETER']['UJI_ID']); $i++){
						for($j=0;$j<count($arrkeys_params);$j++){
							$arr_update[$arrkeys_params[$j]] = $parameter[$arrkeys_params[$j]][$i];
						}
						$this->db->where('UJI_ID', $_POST['PARAMETER']['UJI_ID'][$i]);
						$this->db->where('SPK_ID', $_POST['PARAMETER']['SPK_ID'][$i]);
						$this->db->where('KODE_SAMPEL', $this->input->post('KODE_SAMPEL'));
						if($this->db->update('T_PARAMETER_HASIL_UJI', $arr_update)){
							$inc++;
						}
					}
					if($inc > 0){
						if($ada > 0){
							$this->db->where('KODE_SAMPEL', $this->input->post('KODE_SAMPEL'));
							$rilis = $this->db->update('T_M_SAMPEL_RILIS', $dtsampel);
							if($rilis) $hasil = TRUE;
						}else{
							$hasil = TRUE;
						}
					}
					if($hasil)
					return "MSG#YES#$msgok";
					else return "MSG#YES#$msgok";
				}else{
					return "MSG#NO#$msgerr";
				}
			}else if($action == "update-header"){
				$hasil = FALSE;
				$msgok = "Edit data header sampel berhasil disimpan";
				$msgerr = "Edit data header sampel gagal disimpan";
				$arrsampel = $sipt->main->post_to_query($this->input->post('SAMPEL'));
				$this->db->where('KODE_SAMPEL', $arrsampel['KODE_SAMPEL']);
				$this->db->update('T_M_SAMPEL_RILIS', $arrsampel);
				if($this->db->affected_rows() > 0){
					$hasil = TRUE;
				}
				if($hasil) return "MSG#YES#$msgok#".site_url();
				else return "MSG#NO#$msgerr";
			}
		}
	}
	
	function delete($action, $isajax){
		if(array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('9', $this->newsession->userdata('SESS_KODE_ROLE'))){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			if($action == "delete"){
				$hasil = FALSE;
				foreach($this->input->post('tb_chk') as $a){
					$arrid = explode(".", $a);
					$sql = "SELECT ID, PERIKSA_SAMPEL, KODE_SAMPEL, SPU_ID, KOMODITI, KATEGORI, REKAP_KOMODITI, ANGGARAN, ASAL_SAMPEL, TUJUAN_SAMPLING, SUB_TUJUAN, TANGGAL_SAMPLING, BULAN_ANGGARAN, SARANA_ID, TEMPAT_SAMPLING, ALAMAT_SAMPLING, KLASIFIKASI_TAMBAHAN, NAMA_SAMPEL, NOMOR_REGISTRASI, PABRIK, IMPORTIR, BENTUK_SEDIAAN, KEMASAN, NO_BETS, KETERANGAN_ED, JUMLAH_SAMPEL, SATUAN, HARGA_SAMPEL, UJI_KIMIA, JUMLAH_KIMIA, UJI_MIKRO, JUMLAH_MIKRO, UJI_BIO, JUMLAH_BIO, SISA, SISA_KIMIA, SISA_MIKRO, SISA_BIO, TEMPAT_SISA_KIMIA, TEMPAT_SISA_MIKRO, KOMPOSISI, NETTO, KONDISI_SAMPEL, EVALUASI_PENANDAAN, CARA_PENYIMPANAN, PEMERIAN, SEGEL, LABEL, HASIL_KIMIA, HASIL_MIKRO, HASIL_BIO, HASIL_SAMPEL, UJI_UNGGULAN, UJI_RUJUK, LAMPIRAN, CATATAN, CATATAN_CP, STATUS_KIMIA, STATUS_MIKRO, STATUS_SAMPEL, TEMBUSAN, CREATE_BY, UPDATE_BY, UPDATE_DATE, KODE_SAMPELX, FLAG FROM T_M_SAMPEL WHERE KODE_SAMPEL = '".$arrid[1]."' AND PERIKSA_SAMPEL = '".$arrid[0]."'";
					$data = $sipt->main->get_result($sql);
					if($data){
						foreach($sql->result_array() as $row){
							$arrdel['PERIKSA_SAMPEL'] = $row['PERIKSA_SAMPEL'];
							$arrdel['KODE_SAMPEL'] = $row['KODE_SAMPEL'];
							$arrdel['SPU_ID'] = $row['SPU_ID'];
							$arrdel['KOMODITI'] = $row['KOMODITI'];
							$arrdel['KATEGORI'] = $row['KATEGORI'];
							$arrdel['REKAP_KOMODITI'] = $row['REKAP_KOMODITI'];
							$arrdel['ANGGARAN'] = $row['ANGGARAN'];
							$arrdel['ASAL_SAMPEL'] = $row['ASAL_SAMPEL'];
							$arrdel['TUJUAN_SAMPLING'] = $row['TUJUAN_SAMPLING'];
							$arrdel['SUB_TUJUAN'] = $row['SUB_TUJUAN'];
							$arrdel['TANGGAL_SAMPLING'] = $row['TANGGAL_SAMPLING'];
							$arrdel['BULAN_ANGGARAN'] = $row['BULAN_ANGGARAN'];
							$arrdel['SARANA_ID'] = $row['SARANA_ID'];
							$arrdel['TEMPAT_SAMPLING'] = $row['TEMPAT_SAMPLING'];
							$arrdel['ALAMAT_SAMPLING'] = $row['ALAMAT_SAMPLING'];
							$arrdel['KLASIFIKASI_TAMBAHAN'] = $row['KLASIFIKASI_TAMBAHAN'];
							$arrdel['NAMA_SAMPEL'] = $row['NAMA_SAMPEL'];
							$arrdel['NOMOR_REGISTRASI'] = $row['NOMOR_REGISTRASI'];
							$arrdel['PABRIK'] = $row['PABRIK'];
							$arrdel['IMPORTIR'] = $row['IMPORTIR'];
							$arrdel['BENTUK_SEDIAAN'] = $row['BENTUK_SEDIAAN'];
							$arrdel['KEMASAN'] = $row['KEMASAN'];
							$arrdel['NO_BETS'] = $row['NO_BETS'];
							$arrdel['KETERANGAN_ED'] = $row['KETERANGAN_ED'];
							$arrdel['JUMLAH_SAMPEL'] = $row['JUMLAH_SAMPEL'];
							$arrdel['SATUAN'] = $row['SATUAN'];
							$arrdel['HARGA_SAMPEL'] = $row['HARGA_SAMPEL'];
							$arrdel['UJI_KIMIA'] = $row['UJI_KMIA'];
							$arrdel['JUMLAH_KIMIA'] = $row['JUMLAH_KIMIA'];
							$arrdel['UJI_MIKRO'] = $row['UJI_MIKRO'];
							$arrdel['JUMLAH_MIKRO'] = $row['JUMLAH_MIKRO'];
							$arrdel['UJI_BIO'] = $row['UJI_BIO'];
							$arrdel['JUMLAH_BIO'] = $row['JUMLAH_BIO'];
							$arrdel['SISA'] = $row['SISA'];
							$arrdel['SISA_KIMIA'] = $row['SISA_KIMIA'];
							$arrdel['SISA_MIKRO'] = $row['SISA_MIKRO'];
							$arrdel['SISA_BIO'] = $row['SISA_BIO'];
							$arrdel['TEMPAT_SISA_KIMIA'] = $row['TEMPAT_SISA_KIMIA'];
							$arrdel['TEMPAT_SISA_MIKRO'] = $row['TEMPAT_SISA_MIKRO'];
							$arrdel['KOMPOSISI'] = $row['KOMPOSISI'];
							$arrdel['NETTO'] = $row['NETTO'];
							$arrdel['KONDISI_SAMPEL'] = $row['KONDISI_SAMPEL'];
							$arrdel['EVALUASI_PENANDAAN'] = $row['EVALUASI_PENANDAAN'];
							$arrdel['CARA_PENYIMPANAN'] = $row['CARA_PENYIMPANAN'];
							$arrdel['PEMERIAN'] = $row['PEMERIAN'];
							$arrdel['SEGEL'] = $row['SEGEL'];
							$arrdel['LABEL'] = $row['LABEL'];
							$arrdel['HASIL_KIMIA'] = $row['HASIL_KIMIA'];
							$arrdel['HASIL_MIKRO'] = $row['HASIL_MIKRO'];
							$arrdel['HASIL_BIO'] = $row['HASIL_BIO'];
							$arrdel['HASIL_SAMPEL'] = $row['HASIL_SAMPEL'];
							$arrdel['UJI_RUJUK'] = $row['UJI_RUJUK'];
							$arrdel['UJI_UNGGULAN'] = $row['UJI_UNGGULAN'];
							$arrdel['LAMPIRAN'] = $row['LAMPIRAN'];
							$arrdel['CATATAN'] = $row['CATATAN'];
							$arrdel['CATATAN_CP'] = $row['CATATAN_CP'];
							$arrdel['STATUS_KIMIA'] = $row['STATUS_KIMIA'];
							$arrdel['STATUS_MIKRO'] = $row['STATUS_MIKRO'];
							$arrdel['STATUS_SAMPEL'] = '00000';
							$arrdel['TEMBUSAN'] = $row['TEMBUSAN'];
							$arrdel['CREATE_BY'] = $row['CREATE_BY'];
							$arrdel['UPDATE_BY'] = $this->newsession->userdata('SESS_USER_ID');
							$arrdel['UPDATE_DATE'] = 'GETDATE()';
							$arrdel['KODE_SAMPELX'] = $row['KODE_SAMPELX'];
							$arrdel['FLAG'] = $row['FLAG'];
							if($this->db->insert('T_M_SAMPEL_DELETE', $arrdel)){
								$hasil = TRUE;
							}
						}
					}
					if($hasil){
						$this->db->simple_query("DELETE FROM T_M_SAMPEL WHERE KODE_SAMPEL ='".$arrid[1]."' AND PERIKSA_SAMPEL = '".$arrid[0]."'");
						$this->db->simple_query("DELETE FROM T_SAMPEL_MT WHERE KODE_SAMPEL ='".$arrid[1]."'");
						$this->db->simple_query("DELETE FROM T_SPK WHERE KODE_SAMPEL ='".$arrid[1]."'");
						$this->db->simple_query("DELETE FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL ='".$arrid[1]."'");
						$this->db->simple_query("DELETE FROM T_CP WHERE KODE_SAMPEL ='".$arrid[1]."'");
						$this->db->simple_query("DELETE FROM T_M_SAMPEL_RILIS WHERE KODE_SAMPEL ='".$arrid[1]."'");
						$data = array('KODE_SAMPEL' => $arrid[1],
									  'WAKTU' => 'GETDATE()',
									  'USER_ID' => $this->newsession->userdata('SESS_USER_ID'),
									  'KEGIATAN' => 'Hapus Data Sampel : ' . $arrid[1],
									  'CATATAN' => '-');
						$this->db->insert('T_SAMPLING_LOG', $data);
						$ret = "MSG#Data Sampel Berhasil Dihapus#";
					}
				}
				if($isajax!="ajax"){
					redirect(base_url());
					exit();			  
				}
				return $ret;
			}
		}
	}
	
	function get_kategori($kode,$prioritas){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$query = "SELECT KODE_SAMPEL, dbo.KATEGORI(KOMODITI, PRIORITAS) AS KOMODITIX, NAMA_KATEGORI AS KOMODITI, LTRIM(RTRIM(KATEGORI)) AS KATEGORI, LEN(KATEGORI) AS LENKATEGORI, PRIORITAS, CONVERT(VARCHAR(10), CREATE_DATE, 120) AS CREATE_DATE FROM T_M_SAMPEL WHERE KODE_SAMPEL = '".$kode."'";
			$data = $sipt->main->get_result($query);
			if($data){
				foreach($query->result_array() as $row){
					$arrdata['sess'] = $row;
				}
				$created = strtotime($row['CREATE_DATE']);
				//$batas = strtotime('01-04-2016');
				
					
				$ganjil = substr($row['KATEGORI'],0,4);
				$arrdata['sel'][0] = substr($row['KATEGORI'],0,4);
				$arrdata['sel'][1] = substr($row['KATEGORI'],0,6);
				if($prioritas == "1"){
					if($ganjil == "0101" || $ganjil == "0105"){
						if($row['LENKATEGORI'] == 11) $arrdata['sel'][1] = substr($row['KATEGORI'],0,7);
						if($row['LENKATEGORI'] == 13) $arrdata['sel'][1] = substr($row['KATEGORI'],0,7);
					}
					$arrdata['sel'][2] = substr($row['KATEGORI'],0,8);
					if($ganjil == "0101" || $ganjil == "0105"){
						if($row['LENKATEGORI'] == 11) $arrdata['sel'][2] = substr($row['KATEGORI'],0,9);
						if($row['LENKATEGORI'] == 13) $arrdata['sel'][2] = substr($row['KATEGORI'],0,9);
					}
					if($row['LENKATEGORI'] == 13){
						$arrdata['sel'][3] = substr($row['KATEGORI'],0,11);
						$arrdata['sel'][4] = $row['KATEGORI'];
					}else if($row['LENKATEGORI'] == 11){
						$arrdata['sel'][3] = substr($row['KATEGORI'],0,11);
						$arrdata['sel'][4] = $row['KATEGORI'];
					}
					else{
						$arrdata['sel'][3] = substr($row['KATEGORI'],0,10);
						$arrdata['sel'][4] = $row['KATEGORI'];	
					}
				}else if($prioritas == "0"){
					$arrdata['sel'][1] = substr($row['KATEGORI'],0,6);
					$arrdata['sel'][2] = substr($row['KATEGORI'],0,8);
					$arrdata['sel'][3] = $row['KATEGORI'];
				}
				
				if($prioritas == "0"){
					$arrdata['selkategori'][0] = $sipt->main->combobox("SELECT LTRIM(RTRIM(KLASIFIKASI_ID)) AS KLASIFIKASI_ID, KLASIFIKASI FROM M_GOLONGAN WHERE KLASIFIKASI_ID LIKE '".substr($row['KATEGORI'],0,2)."%__' AND LEN(KLASIFIKASI_ID) = '4' ORDER BY KLASIFIKASI_ID ASC", "KLASIFIKASI_ID", "KLASIFIKASI", TRUE);
					$arrdata['selkategori'][1] = $sipt->main->combobox("SELECT LTRIM(RTRIM(KLASIFIKASI_ID)) AS KLASIFIKASI_ID, KLASIFIKASI FROM M_GOLONGAN WHERE KLASIFIKASI_ID LIKE '".substr($row['KATEGORI'],0,4)."%__' AND LEN(KLASIFIKASI_ID) = '6' ORDER BY KLASIFIKASI_ID ASC", "KLASIFIKASI_ID", "KLASIFIKASI", TRUE);
					$arrdata['selkategori'][2] = $sipt->main->combobox("SELECT LTRIM(RTRIM(KLASIFIKASI_ID)) AS KLASIFIKASI_ID, KLASIFIKASI FROM M_GOLONGAN WHERE KLASIFIKASI_ID LIKE '".substr($row['KATEGORI'],0,6)."%__' AND LEN(KLASIFIKASI_ID) = '8' ORDER BY KLASIFIKASI_ID ASC", "KLASIFIKASI_ID", "KLASIFIKASI", TRUE);
					$arrdata['selkategori'][3] = $sipt->main->combobox("SELECT LTRIM(RTRIM(KLASIFIKASI_ID)) AS KLASIFIKASI_ID, KLASIFIKASI FROM M_GOLONGAN WHERE KLASIFIKASI_ID LIKE '".substr($row['KATEGORI'],0,8)."%__' AND LEN(KLASIFIKASI_ID) = '10' ORDER BY KLASIFIKASI_ID ASC", "KLASIFIKASI_ID", "KLASIFIKASI", TRUE);

				}else if($prioritas == "1"){
					if($created < $batas)
					{
						#Start Kategori Non Existing
						$arrdata['selkategori'][0] = $sipt->main->combobox("SELECT LTRIM(RTRIM(KLASIFIKASI_ID)) AS KLASIFIKASI_ID, KLASIFIKASI FROM M_GOLONGAN_2015 WHERE KLASIFIKASI_ID LIKE '".substr($row['KATEGORI'],0,2)."%__' AND LEN(KLASIFIKASI_ID) = '4' AND KLASIFIKASI <> '' AND STATUS = '1' ORDER BY KLASIFIKASI_ID ASC", "KLASIFIKASI_ID", "KLASIFIKASI", TRUE);
						if($ganjil == "0101" || $ganjil == "0105"){
							$arrdata['selkategori'][1] = $sipt->main->combobox("SELECT (LTRIM(RTRIM(KLASIFIKASI_ID))) AS KLASIFIKASI_ID, LTRIM(RTRIM(KLASIFIKASI)) AS KLASIFIKASI FROM M_GOLONGAN_2015 WHERE KLASIFIKASI_PARENT = '".$ganjil."' AND KLASIFIKASI_ID LIKE '".substr($row['KATEGORI'],0,4)."%__' OR KLASIFIKASI_ID LIKE '".substr($row['KATEGORI'],0,4)."%___' AND (LEN(KLASIFIKASI_ID) = '6' OR  LEN(KLASIFIKASI_ID) = '7')  AND KLASIFIKASI <> '' AND STATUS = '1' ORDER BY KLASIFIKASI ASC", "KLASIFIKASI_ID", "KLASIFIKASI", TRUE);
						}else{
							$arrdata['selkategori'][1] = $sipt->main->combobox("SELECT LTRIM(RTRIM(KLASIFIKASI_ID)) AS KLASIFIKASI_ID, KLASIFIKASI FROM M_GOLONGAN_2015 WHERE KLASIFIKASI_ID LIKE '".substr($row['KATEGORI'],0,4)."%__' AND LEN(KLASIFIKASI_ID) = '6' AND KLASIFIKASI <> '' AND STATUS = '1' ORDER BY KLASIFIKASI_ID ASC", "KLASIFIKASI_ID", "KLASIFIKASI", TRUE);
						}
						if($ganjil == "0101" || $ganjil == "0105"){
							$arrdata['selkategori'][2] = $sipt->main->combobox("SELECT (LTRIM(RTRIM(KLASIFIKASI_ID))) AS KLASIFIKASI_ID, LTRIM(RTRIM(KLASIFIKASI)) AS KLASIFIKASI FROM M_GOLONGAN_2015 WHERE KLASIFIKASI_ID LIKE '".substr($row['KATEGORI'],0,6)."%__' OR KLASIFIKASI_ID LIKE '".substr($row['KATEGORI'],0,6)."%___' AND (LEN(KLASIFIKASI_ID) = '8' OR  LEN(KLASIFIKASI_ID) = '9')  AND KLASIFIKASI <> '' AND STATUS = '1' ORDER BY KLASIFIKASI ASC", "KLASIFIKASI_ID", "KLASIFIKASI", TRUE);
						}else{
							$arrdata['selkategori'][2] = $sipt->main->combobox("SELECT LTRIM(RTRIM(KLASIFIKASI_ID)) AS KLASIFIKASI_ID, KLASIFIKASI FROM M_GOLONGAN_2015 WHERE KLASIFIKASI_ID LIKE '".substr($row['KATEGORI'],0,6)."%__' AND LEN(KLASIFIKASI_ID) = '8' AND KLASIFIKASI <> '' AND STATUS = '1' ORDER BY KLASIFIKASI_ID ASC", "KLASIFIKASI_ID", "KLASIFIKASI", TRUE);
						}
						if($ganjil == "0101" || $ganjil == "0105"){
							$arrdata['selkategori'][3] = $sipt->main->combobox("SELECT (LTRIM(RTRIM(KLASIFIKASI_ID))) AS KLASIFIKASI_ID, LTRIM(RTRIM(KLASIFIKASI)) AS KLASIFIKASI FROM M_GOLONGAN_2015 WHERE KLASIFIKASI_ID LIKE '".substr($row['KATEGORI'],0,8)."%__' OR KLASIFIKASI_ID LIKE '".substr($row['KATEGORI'],0,9)."%___' AND (LEN(KLASIFIKASI_ID) = '10' OR  LEN(KLASIFIKASI_ID) = '11')  AND KLASIFIKASI <> '' AND STATUS = '1' ORDER BY KLASIFIKASI ASC", "KLASIFIKASI_ID", "KLASIFIKASI", TRUE);
						}else{
							$arrdata['selkategori'][3] = $sipt->main->combobox("SELECT LTRIM(RTRIM(KLASIFIKASI_ID)) AS KLASIFIKASI_ID, KLASIFIKASI FROM M_GOLONGAN_2015 WHERE KLASIFIKASI_ID LIKE '".substr($row['KATEGORI'],0,8)."%__' AND LEN(KLASIFIKASI_ID) = '10' ORDER BY KLASIFIKASI_ID ASC", "KLASIFIKASI_ID", "KLASIFIKASI", TRUE);
						}
						if($ganjil == "0101" || $ganjil == "0105"){
							$arrdata['selkategori'][4] = $sipt->main->combobox("SELECT (LTRIM(RTRIM(KLASIFIKASI_ID))) AS KLASIFIKASI_ID, LTRIM(RTRIM(KLASIFIKASI)) AS KLASIFIKASI FROM M_GOLONGAN_NEW WHERE KLASIFIKASI_ID LIKE '".substr($row['KATEGORI'],0,8)."%__' OR KLASIFIKASI_ID LIKE '".substr($row['KATEGORI'],0,9)."%___' AND (LEN(KLASIFIKASI_ID) = '12' OR  LEN(KLASIFIKASI_ID) = '13')  AND KLASIFIKASI <> '' AND STATUS = '1' ORDER BY KLASIFIKASI ASC", "KLASIFIKASI_ID", "KLASIFIKASI", TRUE);
						}else{
							$arrdata['selkategori'][4] = $sipt->main->combobox("SELECT LTRIM(RTRIM(KLASIFIKASI_ID)) AS KLASIFIKASI_ID, KLASIFIKASI FROM M_GOLONGAN_NEW WHERE KLASIFIKASI_ID LIKE '".substr($row['KATEGORI'],0,8)."%__' AND LEN(KLASIFIKASI_ID) = '10' ORDER BY KLASIFIKASI_ID ASC", "KLASIFIKASI_ID", "KLASIFIKASI", TRUE);
						}
						#End Kategori Non Existing
						$arrdata['ext'] = 'N';
					}
					else
					{
						#Start Kategori Existing
						$arrdata['selkategori'][0] = $sipt->main->combobox("SELECT LTRIM(RTRIM(KLASIFIKASI_ID)) AS KLASIFIKASI_ID, KLASIFIKASI FROM M_GOLONGAN_NEW WHERE KLASIFIKASI_ID LIKE '".substr($row['KATEGORI'],0,2)."%__' AND LEN(KLASIFIKASI_ID) = '4' AND KLASIFIKASI <> '' AND STATUS = '1' AND PRIORITAS ='".date(Y)."'  ORDER BY KLASIFIKASI_ID ASC", "KLASIFIKASI_ID", "KLASIFIKASI", TRUE);
						if($ganjil == "0101" || $ganjil == "0105"){
							$arrdata['selkategori'][1] = $sipt->main->combobox("SELECT (LTRIM(RTRIM(KLASIFIKASI_ID))) AS KLASIFIKASI_ID, LTRIM(RTRIM(KLASIFIKASI)) AS KLASIFIKASI FROM M_GOLONGAN_NEW WHERE KLASIFIKASI_PARENT = '".$ganjil."' AND KLASIFIKASI_ID LIKE '".substr($row['KATEGORI'],0,4)."%__' OR KLASIFIKASI_ID LIKE '".substr($row['KATEGORI'],0,4)."%___' AND (LEN(KLASIFIKASI_ID) = '6' OR  LEN(KLASIFIKASI_ID) = '7')  AND KLASIFIKASI <> '' AND STATUS = '1' AND PRIORITAS ='".date(Y)."' ORDER BY KLASIFIKASI ASC", "KLASIFIKASI_ID", "KLASIFIKASI", TRUE);
						}else{
							$arrdata['selkategori'][1] = $sipt->main->combobox("SELECT LTRIM(RTRIM(KLASIFIKASI_ID)) AS KLASIFIKASI_ID, KLASIFIKASI FROM M_GOLONGAN_NEW WHERE KLASIFIKASI_ID LIKE '".substr($row['KATEGORI'],0,4)."%__' AND LEN(KLASIFIKASI_ID) = '6' AND KLASIFIKASI <> '' AND STATUS = '1' AND PRIORITAS ='".date(Y)."' ORDER BY KLASIFIKASI_ID ASC", "KLASIFIKASI_ID", "KLASIFIKASI", TRUE);
						}
						if($ganjil == "0101" || $ganjil == "0105"){
							//echo "SELECT (LTRIM(RTRIM(KLASIFIKASI_ID))) AS KLASIFIKASI_ID, LTRIM(RTRIM(KLASIFIKASI)) AS KLASIFIKASI FROM M_GOLONGAN_NEW WHERE KLASIFIKASI_ID LIKE '".substr($row['KATEGORI'],0,6)."%__' OR KLASIFIKASI_ID LIKE '".substr($row['KATEGORI'],0,7)."%__' AND (LEN(KLASIFIKASI_ID) = '8' OR  LEN(KLASIFIKASI_ID) = '9')  AND KLASIFIKASI <> '' AND STATUS = '1' AND PRIORITAS ='".date(Y)."' ORDER BY KLASIFIKASI ASC";
							$arrdata['selkategori'][2] = $sipt->main->combobox("SELECT (LTRIM(RTRIM(KLASIFIKASI_ID))) AS KLASIFIKASI_ID, LTRIM(RTRIM(KLASIFIKASI)) AS KLASIFIKASI FROM M_GOLONGAN_NEW WHERE KLASIFIKASI_ID LIKE '".substr($row['KATEGORI'],0,7)."%__' AND (LEN(KLASIFIKASI_ID) = '8' OR  LEN(KLASIFIKASI_ID) = '9')  AND KLASIFIKASI <> '' AND STATUS = '1' AND PRIORITAS ='".date(Y)."' ORDER BY KLASIFIKASI ASC", "KLASIFIKASI_ID", "KLASIFIKASI", TRUE);
						}else{
							$arrdata['selkategori'][2] = $sipt->main->combobox("SELECT LTRIM(RTRIM(KLASIFIKASI_ID)) AS KLASIFIKASI_ID, KLASIFIKASI FROM M_GOLONGAN_NEW WHERE KLASIFIKASI_ID LIKE '".substr($row['KATEGORI'],0,6)."%__' AND LEN(KLASIFIKASI_ID) = '8' AND KLASIFIKASI <> '' AND STATUS = '1' AND PRIORITAS ='".date(Y)."' ORDER BY KLASIFIKASI_ID ASC", "KLASIFIKASI_ID", "KLASIFIKASI", TRUE);
						}
						if($ganjil == "0101" || $ganjil == "0105"){
							//echo "SELECT (LTRIM(RTRIM(KLASIFIKASI_ID))) AS KLASIFIKASI_ID, LTRIM(RTRIM(KLASIFIKASI)) AS KLASIFIKASI FROM M_GOLONGAN_NEW WHERE KLASIFIKASI_ID LIKE '".substr($row['KATEGORI'],0,8)."%__' OR KLASIFIKASI_ID LIKE '".substr($row['KATEGORI'],0,9)."%___' AND (LEN(KLASIFIKASI_ID) = '12' OR  LEN(KLASIFIKASI_ID) = '13')  AND KLASIFIKASI <> '' AND STATUS = '1' AND PRIORITAS ='".date(Y)."' ORDER BY KLASIFIKASI ASC";
							$arrdata['selkategori'][3] = $sipt->main->combobox("SELECT (LTRIM(RTRIM(KLASIFIKASI_ID))) AS KLASIFIKASI_ID, LTRIM(RTRIM(KLASIFIKASI)) AS KLASIFIKASI FROM M_GOLONGAN_NEW WHERE KLASIFIKASI_ID LIKE '".substr($row['KATEGORI'],0,8)."%__' OR KLASIFIKASI_ID LIKE '".substr($row['KATEGORI'],0,9)."%___' AND (LEN(KLASIFIKASI_ID) = '12' OR  LEN(KLASIFIKASI_ID) = '13')  AND KLASIFIKASI <> '' AND STATUS = '1' AND PRIORITAS ='".date(Y)."' ORDER BY KLASIFIKASI ASC", "KLASIFIKASI_ID", "KLASIFIKASI", TRUE);
						}else{
							$arrdata['selkategori'][3] = $sipt->main->combobox("SELECT LTRIM(RTRIM(KLASIFIKASI_ID)) AS KLASIFIKASI_ID, KLASIFIKASI FROM M_GOLONGAN_NEW WHERE KLASIFIKASI_ID LIKE '".substr($row['KATEGORI'],0,8)."%__' AND LEN(KLASIFIKASI_ID) = '10' AND STATUS = '1' AND PRIORITAS ='".date(Y)."' ORDER BY KLASIFIKASI_ID ASC", "KLASIFIKASI_ID", "KLASIFIKASI", TRUE);
						}
						if($ganjil == "0101" || $ganjil == "0105"){
							//echo "SELECT (LTRIM(RTRIM(KLASIFIKASI_ID))) AS KLASIFIKASI_ID, LTRIM(RTRIM(KLASIFIKASI)) AS KLASIFIKASI FROM M_GOLONGAN_NEW WHERE KLASIFIKASI_ID LIKE '".substr($row['KATEGORI'],0,10)."%__' OR KLASIFIKASI_ID LIKE '".substr($row['KATEGORI'],0,11)."%___' AND (LEN(KLASIFIKASI_ID) = '12' OR  LEN(KLASIFIKASI_ID) = '13')  AND KLASIFIKASI <> '' AND STATUS = '1' AND PRIORITAS ='".date(Y)."' ORDER BY KLASIFIKASI ASC";die();
							$arrdata['selkategori'][4] = $sipt->main->combobox("SELECT (LTRIM(RTRIM(KLASIFIKASI_ID))) AS KLASIFIKASI_ID, LTRIM(RTRIM(KLASIFIKASI)) AS KLASIFIKASI FROM M_GOLONGAN_NEW WHERE KLASIFIKASI_ID LIKE '".substr($row['KATEGORI'],0,10)."%__' OR KLASIFIKASI_ID LIKE '".substr($row['KATEGORI'],0,11)."%___' AND (LEN(KLASIFIKASI_ID) = '12' OR  LEN(KLASIFIKASI_ID) = '13')  AND KLASIFIKASI <> '' AND STATUS = '1' AND PRIORITAS ='".date(Y)."' ORDER BY KLASIFIKASI ASC", "KLASIFIKASI_ID", "KLASIFIKASI", TRUE);
						}else{
							$arrdata['selkategori'][4] = $sipt->main->combobox("SELECT LTRIM(RTRIM(KLASIFIKASI_ID)) AS KLASIFIKASI_ID, KLASIFIKASI FROM M_GOLONGAN_NEW WHERE KLASIFIKASI_ID LIKE '".substr($row['KATEGORI'],0,10)."%__' AND LEN(KLASIFIKASI_ID) = '12'  AND STATUS = '1' AND PRIORITAS ='".date(Y)."' ORDER BY KLASIFIKASI_ID ASC", "KLASIFIKASI_ID", "KLASIFIKASI", TRUE);
						}
						#End Kategori Existing
						$arrdata['ext'] = 'Y';
					}
					//print_r($arrdata);die();
				}
				$arrdata['klasifikasi_tambahan'] = $sipt->main->combobox("SELECT NAMA_TAMBAHAN FROM M_GOLONGAN_TAMBAHAN WHERE KLASIFIKASI = '".substr($row['KATEGORI'],0,2)."' ORDER BY 1 ASC", "NAMA_TAMBAHAN", "NAMA_TAMBAHAN", TRUE);
				$arrdata['act'] = site_url().'/post/sampel/sampel_act/edit-kategori';
			}
			return $arrdata;
		}
	}
	
	function get_parameter($kode){
		if($this->newsession->userdata('SESS_BBPOM_ID') == "00" || (in_array('9', $this->newsession->userdata('SESS_KODE_ROLE')) && !in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')))){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$query = "SELECT dbo.FORMAT_NOMOR('SPL',KODE_SAMPEL) AS KODE, NAMA_SAMPEL, NOMOR_REGISTRASI, PABRIK, IMPORTIR, BENTUK_SEDIAAN, NO_BETS, NAMA_KATEGORI AS KOMODITI, dbo.KATEGORI(KOMODITI, PRIORITAS) AS KOMODITIX, HASIL_SAMPEL FROM T_M_SAMPEL WHERE KODE_SAMPEL = '".$kode."'";
			$data = $sipt->main->get_result($query);
			if($data){
				foreach($query->result_array() as $row){
					$arrdata['sess'] = $row;
				}
				$arrdata['parameter'] = $this->db->query("SELECT UJI_ID, KODE_SAMPEL, CASE WHEN JENIS_UJI = '01' THEN 'Mikrobiologi' WHEN JENIS_UJI = '02' THEN 'Kimia - Fisika' END AS JENIS_UJI, UJI_ID, SPK_ID, PARAMETER_UJI, METODE, PUSTAKA, SYARAT, RUANG_LINGKUP, HASIL, HASIL_KUALITATIF, LCP, HASIL_PARAMETER FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL = '".$kode."'")->result_array();
				return $arrdata;	
			}
		}
	}
	
	function get_edit_hasil_pu($id){
		if($this->newsession->userdata('SESS_BBPOM_ID') == "00" || (in_array('9', $this->newsession->userdata('SESS_KODE_ROLE')) && !in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')))){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$arrid = explode(".",$id);
			$query = "SELECT A.NAMA_SAMPEL, A.KODE_SAMPEL, dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) AS KODE, dbo.FORMAT_NOMOR('SPU',C.SPU_ID) AS SPU, A.TEMPAT_SAMPLING, CONVERT(VARCHAR(10), A.TANGGAL_SAMPLING, 103) AS TANGGAL_SAMPLING, A.ALAMAT_SAMPLING, A.NOMOR_REGISTRASI, A.PABRIK, A.IMPORTIR, A.KEMASAN, A.BENTUK_SEDIAAN, A.NO_BETS, A.SATUAN, dbo.KATEGORI(A.KOMODITI, A.PRIORITAS) AS KOMODITIX, A.NAMA_KATEGORI AS KOMODITI, dbo.KATEGORI(A.KATEGORI, A.PRIORITAS) AS KATEGORI, A.KETERANGAN_ED, A.JUMLAH_KIMIA, A.JUMLAH_MIKRO, REPLACE(A.KOMPOSISI,';','<br>') AS KOMPOSISI, A.NETTO, B.NOMOR_SURAT, CONVERT(VARCHAR(10), B.TANGGAL_SURAT, 103) AS TANGGAL_SURAT, B.NAMA_PENGIRIM, CONVERT(VARCHAR(10), C.TANGGAL_TERIMA_TPS, 103) AS TANGGAL_TERIMA_TPS, CONVERT(VARCHAR(10), C.TANGGAL, 103) AS TANGGAL_SPU, A.PEMERIAN, A.UJI_MIKRO, A.UJI_KIMIA, A.JUMLAH_SAMPEL, A.JUMLAH_KIMIA, A.JUMLAH_MIKRO, RTRIM(LTRIM(A.HASIL_KIMIA)) AS HASIL_KIMIA, RTRIM(LTRIM(A.HASIL_MIKRO)) AS HASIL_MIKRO, D.HASIL_PPOMN, RTRIM(LTRIM(D.STATUS)) AS STATUS, RTRIM(LTRIM(A.HASIL_SAMPEL)) AS HASIL_SAMPEL FROM T_M_SAMPEL A LEFT JOIN T_PERIKSA_SAMPEL B ON A.PERIKSA_SAMPEL = B.PERIKSA_SAMPEL LEFT JOIN T_SPU C ON A.SPU_ID = C.SPU_ID LEFT JOIN T_M_SAMPEL_RILIS D ON A.KODE_SAMPEL = D.KODE_SAMPEL WHERE A.KODE_SAMPEL = '".$arrid[1]."'";
			$data = $sipt->main->get_result($query);
			if($data){
				$arrdata = array();
				$ada = $sipt->main->get_uraian("SELECT COUNT(*) AS JML FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL = '".$arrid[1]."'","JML");
				foreach($query->result_array() as $row){
					$arrdata['sess'] = $row;
				}
				if($ada > 0){
					$arrdata['parameter'] = $this->db->query("SELECT UJI_ID, KODE_SAMPEL, CASE WHEN JENIS_UJI = '01' THEN 'Mikrobiologi' WHEN JENIS_UJI = '02' THEN 'Kimia - Fisika' END AS JENIS_UJI, UJI_ID, SPK_ID, PARAMETER_UJI, METODE, PUSTAKA, SYARAT, RUANG_LINGKUP, HASIL, HASIL_KUALITATIF, LCP, RTRIM(LTRIM(HASIL_PARAMETER)) AS HASIL_PARAMETER FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL = '".$arrid[1]."'")->result_array();
					$arrdata['tanggaluji'] = $this->db->query("SELECT MIN(CONVERT(VARCHAR(10), AWAL_UJI, 120)) AS MINTGL, MAX(CONVERT(VARCHAR(10), AKHIR_UJI, 120)) AS MAXTGL FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL = '".$arrid[1]."'")->result_array();
					$arrdata['hasil_sampel'] = $sipt->main->combobox("SELECT KODE,URAIAN FROM M_TABEL WHERE JENIS = 'HASIL' AND KODE IN ('HPST','MS','TMS')", "KODE", "URAIAN", TRUE);
					$arrdata['hasil_param'] = $sipt->main->combobox("SELECT KODE FROM M_TABEL WHERE JENIS = 'HASIL' AND KODE IN ('MS','TMS')", "KODE", "KODE", TRUE);
					$arrdata['act'] = site_url().'/post/sampel/sampel_act/update-parameter';
				}else{
					$arrdata['parameter'] = array();
				}
				return $arrdata;	
			}

		}
	}
	function get_detil_parameter($uji, $kode){
		if($this->newsession->userdata('SESS_BBPOM_ID') == "00" || (in_array('9', $this->newsession->userdata('SESS_KODE_ROLE')) && !in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')))){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$query = "SELECT UJI_ID, SPK_ID, KODE_SAMPEL, dbo.FORMAT_NOMOR('SPL', KODE_SAMPEL) AS KODE, KODE_SAMPEL, PARAMETER_UJI, METODE, PUSTAKA, SYARAT, RUANG_LINGKUP, JENIS_UJI, JUMLAH_UJI, SISA_UJI, REAGEN, JUMLAH_REAGEN, HASIL, HASIL_KUALITATIF, CATATAN, CONVERT(VARCHAR(10), AWAL_UJI, 103) AS AWAL_UJI, CONVERT(VARCHAR(10), AKHIR_UJI, 103) AS AKHIR_UJI, LCP, STATUS, PENGUJI, LTRIM(RTRIM(HASIL_PARAMETER)) AS HASIL_PARAMETER FROM T_PARAMETER_HASIL_UJI WHERE UJI_ID = '".$uji."' AND KODE_SAMPEL = '".$kode."'";
			$data = $sipt->main->get_result($query);
			if($data){
				foreach($query->result_array() as $row){
					$arrdata['sess'] = $row;
				}
				$arrdata['act'] = site_url().'/post/uji/penguji_act/update-hasil-parameter';
				$arrdata['hasil_parameter'] = array("" => "", "MS" => "Memenuhi Syarat", "TMS" => "Tidak Memenuhi Syarat");
				return $arrdata;
			}
		}
	}
	
	function update_bidang($bidang, $kode, $val){
		if(in_array('1', $this->newsession->userdata('SESS_KODE_ROLE')) && $this->newsession->userdata('LOGGED_IN')){
			$ret = "";
			$arrbidang = array("01","02");
			if(in_array($bidang, $arrbidang) && $bidang != ""){
				if($bidang == "01"){#Mikro
					$arr = array('STATUS_MIKRO' => ($val == "0" ? 1 : 0));
					$this->db->where('KODE_SAMPEL', $kode);
					$res = $this->db->update('T_M_SAMPEL', $arr);
					if($res) $ret = "MSG#YES#Status uji berhasil di update.#".site_url();
					else $ret = "MSG#NO#Status uji gagal di update."; 
				}else if($bidang == "02"){#Kimia
					$arr = array('STATUS_KIMIA' => ($val == "0" ? 1 : 0));
					$this->db->where('KODE_SAMPEL', $kode);
					$res = $this->db->update('T_M_SAMPEL', $arr);
					if($res) $ret = "MSG#YES#Status uji berhasil di update.#".site_url();
					else $ret = "MSG#NO#Status uji gagal di update.";
				}
			}else{
				$ret = "MSG#NO#Status uji gagal di update.";
			}
			return $ret;
		}
	}
	
	function get_header_spl($kode){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$this->load->library('newtable');
			$query = "SELECT A.NAMA_SAMPEL, A.KODE_SAMPEL, dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) AS KODE, dbo.FORMAT_NOMOR('SPU',C.SPU_ID) AS SPU, A.TEMPAT_SAMPLING, CONVERT(VARCHAR(10), A.TANGGAL_SAMPLING, 103) AS TANGGAL_SAMPLING, A.ALAMAT_SAMPLING, A.NOMOR_REGISTRASI, A.PABRIK, A.IMPORTIR, A.KEMASAN, A.BENTUK_SEDIAAN, A.NO_BETS, A.SATUAN, dbo.KATEGORI(A.KOMODITI,A.PRIORITAS) AS KOMODITIX, A.NAMA_KATEGORI AS KOMODITI, dbo.KATEGORI(A.KATEGORI,A.PRIORITAS) AS KATEGORI, A.KETERANGAN_ED, A.JUMLAH_KIMIA, A.JUMLAH_MIKRO, REPLACE(A.KOMPOSISI,';','<br>') AS KOMPOSISI, A.NETTO, B.NOMOR_SURAT, B.BBPOM_ID, CONVERT(VARCHAR(10), B.TANGGAL_SURAT, 103) AS TANGGAL_SURAT, B.NAMA_PENGIRIM, CONVERT(VARCHAR(10), C.TANGGAL_TERIMA_TPS, 103) AS TANGGAL_TERIMA_TPS, CONVERT(VARCHAR(10), C.TANGGAL, 103) AS TANGGAL_SPU, A.PEMERIAN, A.UJI_MIKRO, A.UJI_KIMIA, A.JUMLAH_SAMPEL, A.JUMLAH_KIMIA, A.JUMLAH_MIKRO, A.HASIL_KIMIA, A.HASIL_MIKRO, A.LAMPIRAN, D.HASIL_PPOMN, RTRIM(LTRIM(D.STATUS)) AS STATUS, A.HASIL_SAMPEL, D.STATUS_PPOMN, CONVERT(VARCHAR(10), D.AKHIR_UJI, 120) AS AKHIR_UJI FROM T_M_SAMPEL A LEFT JOIN T_PERIKSA_SAMPEL B ON A.PERIKSA_SAMPEL = B.PERIKSA_SAMPEL LEFT JOIN T_SPU C ON A.SPU_ID = C.SPU_ID LEFT JOIN T_M_SAMPEL_RILIS D ON A.KODE_SAMPEL = D.KODE_SAMPEL WHERE A.KODE_SAMPEL = '".$kode."'";
			$tanggaluji = $this->db->query("SELECT MIN(CONVERT(VARCHAR(10), AWAL_UJI, 120)) AS MINTGL, MAX(CONVERT(VARCHAR(10), AKHIR_UJI, 120)) AS MAXTGL FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL = '".$kode."'")->result_array();
			$data = $sipt->main->get_result($query);
			if($data){
				foreach($query->result_array() as $row){
					$arrdata = array('sess' => $row,
									 'tanggaluji' => $tanggaluji);
				}
			}
			$arrdata['act'] = site_url().'/post/sampel/sampel_act/update-header';
			return $arrdata;
		}
	}

	
}
?>
