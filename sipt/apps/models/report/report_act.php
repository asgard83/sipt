<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

error_reporting(E_ERROR);

class Report_act extends Model{



	function get_pemeriksaan($jenis=""){

		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){

			$sipt =& get_instance();

			$this->load->model("main", "main", true);

			$tipe = array("" => "","0" => "Pemeriksaan Sarana", "1" => "Temuan Produk");

			$disinput = array("JENISDIS","NAMADIS");

			$jenis_sarana = $sipt->main->get_jenis_sarana($this->newsession->userdata("SESS_USER_ID"), $disinput);

			$kecuali = $sipt->main->remove_element($this->config->item('cfg_unit'), $this->newsession->userdata('SESS_BBPOM_ID'));

			$unit = "'".join("','", $kecuali)."'";

			$jsarana = $sipt->main->combobox("SELECT JENIS_SARANA_ID, NAMA_JENIS_SARANA FROM M_JENIS_SARANA WHERE LEN(JENIS_SARANA_ID) = '2' AND LEFT(JENIS_SARANA_ID, 1) = '0' ORDER BY 1","JENIS_SARANA_ID","NAMA_JENIS_SARANA", TRUE);

			if(in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))){

				$ret = "SELECT BBPOM_ID, NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID NOT IN ('00','99',$unit)";

				$bbpom = $sipt->main->combobox("SELECT BBPOM_ID, REPLACE(REPLACE(NAMA_BBPOM,'BALAI BESAR POM DI ', ''),'BALAI POM DI ','') AS NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID NOT IN ('00','99',$unit)","BBPOM_ID","NAMA_BBPOM", TRUE);

			}else if($this->newsession->userdata('SESS_BBPOM_ID') != "00" && !in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))){

				$ret = 'balai';

				$bbpom = $sipt->main->combobox("SELECT BBPOM_ID, REPLACE(REPLACE(NAMA_BBPOM,'BALAI BESAR POM DI ', ''),'BALAI POM DI ','') AS NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID ='".$this->newsession->userdata('SESS_BBPOM_ID')."'","BBPOM_ID","NAMA_BBPOM");

				if($this->newsession->userdata('SESS_PROP_ID') == '7100'){

					$kota = $sipt->main->combobox("SELECT PROPINSI_ID, NAMA_PROPINSI FROM M_PROPINSI WHERE PROPINSI_ID LIKE '%71__%' OR PROPINSI_ID LIKE '%82__%' AND RIGHT(PROPINSI_ID, 2) <> '00'","PROPINSI_ID","NAMA_PROPINSI", TRUE);

				}else if($this->newsession->userdata('SESS_PROP_ID') == '7300'){

					$kota = $sipt->main->combobox("SELECT PROPINSI_ID, NAMA_PROPINSI FROM M_PROPINSI WHERE PROPINSI_ID LIKE '%73__%' OR PROPINSI_ID LIKE '%76__%' AND RIGHT(PROPINSI_ID, 2) <> '00'","PROPINSI_ID","NAMA_PROPINSI", TRUE);

				}else{

					$propinsi = substr($this->newsession->userdata('SESS_PROP_ID'), 0, 2);

					$kota = $sipt->main->combobox("SELECT PROPINSI_ID, NAMA_PROPINSI FROM M_PROPINSI WHERE PROPINSI_ID LIKE '".$propinsi."%' AND RIGHT(PROPINSI_ID, 2) <> '00'","PROPINSI_ID","NAMA_PROPINSI", TRUE);

				}

			}else{

				$ret = 'piom';			

				$bbpom = $sipt->main->combobox("SELECT BBPOM_ID, REPLACE(REPLACE(NAMA_BBPOM,'BALAI BESAR POM DI ', ''),'BALAI POM DI ','') AS NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID NOT IN ('99','00')","BBPOM_ID","NAMA_BBPOM", TRUE);

			}

			$arrdata = array('jenis_sarana' => $jenis_sarana,

							 'disinput' => $disinput,

							 'kota' => $kota,

							 'tipe' => $tipe,

							 'bbpom' => $bbpom,

							 'jsarana' => $jsarana,

							 'idjudul' => 'judulpmnsarana',

							 'batal' => site_url());

			$arrdata['hasil'] = array('' => '',

									  'MK' => 'Memenuhi Ketentuan',

									  'TMK' => 'Tidak Memenuhi Ketentuan',

									  'Minor' => 'Minor',

									  'Major' => 'Major',

									  'Kritikal' => 'Kritikal',

									  'A' => 'Baik Sekali (Pangan - MD)',

									  'B' => 'Baik (Pangan - MD)',

									  'C' => 'Kurang (Pangan - MD)',

									  'D' => 'Jelek (Pangan - MD)',

									  'BAIK' => 'Baik (Pangan - IRT)',

									  'CUKUP' => 'Cukup (Pangan - IRT)',

									  'KURANG' => 'Kurang (Pangan - IRT)',

									  'TMBB' => 'Tidak Menyalurkan Bahan Berbahaya Lagi',

									  'TDP' => 'Tidak Dapat Diperiksa',

									  'TTP' => 'Tutup');				 

			if($jenis == "sarana"){

			    $sarana = "'".join("','", $this->newsession->userdata('SESS_KLASIFIKASI_ID'))."'";

				$arrdata['act'] = site_url().'/toexcel/excels/pemeriksaan/detil';

				$arrdata['judul'] = 'Laporan Pemeriksaan Sarana';

				$arrdata['klasifikasi'] = $sipt->main->combobox("SELECT KK_ID, NAMA_KK FROM M_KLASIFIKASI_KATEGORI WHERE LEN(KK_ID) = 3 AND KK_ID IN ($sarana)", "KK_ID", "NAMA_KK", TRUE);				

			}else if($jenis == "produk"){

				if($this->newsession->userdata('SESS_BBPOM_ID') == "91" || $this->newsession->userdata('SESS_BBPOM_ID') == "93"){

					$arrdata['klasifikasi'] =  $sipt->main->combobox("SELECT KK_ID, NAMA_KK FROM M_KLASIFIKASI_KATEGORI WHERE LEN(KK_ID) = 3 AND KK_ID IN ('001')", "KK_ID", "NAMA_KK", TRUE);

				}else if($this->newsession->userdata('SESS_BBPOM_ID') == "00" && !in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))){

					$arrdata['klasifikasi'] = $sipt->main->combobox("SELECT KK_ID, NAMA_KK FROM M_KLASIFIKASI_KATEGORI WHERE LEN(KK_ID) = 3 AND KK_ID IN ('001','010','011','012','013','015')", "KK_ID", "NAMA_KK", TRUE);

				}else{

					$sarana = "'".join("','", $this->newsession->userdata('SESS_KLASIFIKASI_ID'))."'"; 

					$arrdata['klasifikasi'] = $sipt->main->combobox("SELECT KK_ID, NAMA_KK FROM M_KLASIFIKASI_KATEGORI WHERE LEN(KK_ID) = 3 AND KK_ID IN ($sarana)", "KK_ID", "NAMA_KK", TRUE);

				}

				$arrdata['act'] = site_url().'/toexcel/excels/produk';

				$arrdata['judul'] = 'Laporan Temuan Produk';

			}else if($jenis == "rekapsarana"){

				$arrdata['act'] = site_url().'/toexcel/excels/rekapitulasi';

				$arrdata['judul'] = 'RHPK Sarana';

			}else if($jenis == "rekapkomoditi"){

				$arrdata['act'] = site_url().'/toexcel/excels/rekap_komoditi';

				$arrdata['judul'] = 'Rekapitulasi Pemeriksaan Komoditi';

			}else if($jenis == "rekapstatus"){

				$arrdata['act'] = site_url().'/toexcel/excels/status_doc';

				if(array_key_exists('10', $this->newsession->userdata('SESS_KODE_ROLE')))

				$arrdata['judul'] = 'RHPK Per Jenis Sarana';

				else

				$arrdata['judul'] = 'Rekapitulasi Status Dokumen';

			}else if($jenis == "statuskomoditi"){

				$sarana = "'".join("','", $this->newsession->userdata('SESS_KLASIFIKASI_ID'))."'";

				$arrdata['klasifikasi'] = $sipt->main->combobox("SELECT KK_ID, NAMA_KK FROM M_KLASIFIKASI_KATEGORI WHERE LEN(KK_ID) = 3 AND KK_ID IN ($sarana)", "KK_ID", "NAMA_KK", TRUE);

				$arrdata['act'] = site_url().'/toexcel/excels/status_komoditi';

				$arrdata['judul'] = 'Rekapitulasi Status Komoditi';

			}else if($jenis == "rekapperiksa"){

				$arrdata['act'] = site_url().'/toexcel/excels/rekap_jml';

				$arrdata['judul'] = 'Rekap Jumlah Sarana yang Diperiksa';

			}else if($jenis == "log-sarana"){

				$arrdata['act'] = site_url().'/toexcel/excels/log_sarana';

				$arrdata['judul'] = 'Laporan Log Sarana';

				$arrdata['hasil'] = array('' => '',

										  'MK' => 'Memenuhi Ketentuan',

										  'TMK' => 'Tidak Memenuhi Ketentuan',

										  'Minor' => 'Minor',

										  'Major' => 'Major',

										  'Kritikal' => 'Kritikal',

										  'A' => 'Baik Sekali (Pangan - MD)',

										  'B' => 'Baik (Pangan - MD)',

										  'C' => 'Kurang (Pangan - MD)',

										  'D' => 'Jelek (Pangan - MD)',

										  'BAIK' => 'Baik (Pangan - IRT)',

										  'CUKUP' => 'Cukup (Pangan - IRT)',

										  'KURANG' => 'Kurang (Pangan - IRT)',

										  'TMBB' => 'Tidak Menyalurkan Bahan Berbahaya Lagi',

										  'TDP' => 'Tidak Dapat Diperiksa',

										  'TTP' => 'Tutup');

			}

			$arrdata['sarana'] = $sipt->main->combobox("SELECT JENIS_SARANA_ID, NAMA_JENIS_SARANA FROM M_JENIS_SARANA WHERE LEFT(JENIS_SARANA_ID,1) = '0' AND LEN(JENIS_SARANA_ID) = 2 ORDER BY 1 ASC","JENIS_SARANA_ID","NAMA_JENIS_SARANA",TRUE);

			return $arrdata;

		}else{

			$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');

		}

	}

	

	function get_pengujian($jenis=""){

		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){

			$sipt =& get_instance();

			$this->load->model("main", "main", true);

			$kecuali = $sipt->main->remove_element($this->config->item('cfg_unit'), $this->newsession->userdata('SESS_BBPOM_ID'));

			$unit = "'".join("','", $kecuali)."'";

			if(in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))){

				$ret = "SELECT BBPOM_ID, REPLACE(REPLACE(NAMA_BBPOM,'BALAI BESAR POM DI ', ''),'BALAI POM DI ','') AS NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID NOT IN ('00','99',$unit)";

				$bbpom = $sipt->main->combobox("SELECT BBPOM_ID, NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID NOT IN ('00','99',$unit)","BBPOM_ID","NAMA_BBPOM", TRUE);

			}else if($this->newsession->userdata('SESS_BBPOM_ID') != "00" && !in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))){

				$ret = 'balai';

				$bbpom = $sipt->main->combobox("SELECT BBPOM_ID, REPLACE(REPLACE(NAMA_BBPOM,'BALAI BESAR POM DI ', ''),'BALAI POM DI ','') AS NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID ='".$this->newsession->userdata('SESS_BBPOM_ID')."'","BBPOM_ID","NAMA_BBPOM");

				if($this->newsession->userdata('SESS_PROP_ID') == '7100'){

					$kota = $sipt->main->combobox("SELECT PROPINSI_ID, NAMA_PROPINSI FROM M_PROPINSI WHERE PROPINSI_ID LIKE '%71__%' OR PROPINSI_ID LIKE '%82__%' AND RIGHT(PROPINSI_ID, 2) <> '00'","PROPINSI_ID","NAMA_PROPINSI", TRUE);

				}else if($this->newsession->userdata('SESS_PROP_ID') == '7300'){

					$kota = $sipt->main->combobox("SELECT PROPINSI_ID, NAMA_PROPINSI FROM M_PROPINSI WHERE PROPINSI_ID LIKE '%73__%' OR PROPINSI_ID LIKE '%76__%' AND RIGHT(PROPINSI_ID, 2) <> '00'","PROPINSI_ID","NAMA_PROPINSI", TRUE);

				}else{

					$propinsi = substr($this->newsession->userdata('SESS_PROP_ID'), 0, 2);

					$kota = $sipt->main->combobox("SELECT PROPINSI_ID, NAMA_PROPINSI FROM M_PROPINSI WHERE PROPINSI_ID LIKE '".$propinsi."%' AND RIGHT(PROPINSI_ID, 2) <> '00'","PROPINSI_ID","NAMA_PROPINSI", TRUE);

				}

			}else{

				$ret = 'piom';			

				$bbpom = $sipt->main->combobox("SELECT BBPOM_ID, REPLACE(REPLACE(NAMA_BBPOM,'BALAI BESAR POM DI ', ''),'BALAI POM DI ','') AS NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID NOT IN ('99','00','91','92','93','94','95','96')","BBPOM_ID","NAMA_BBPOM", TRUE);

			}

			

			$arrdata = array('bbpom' => $bbpom,

							 'idjudul' => 'judulmsampel',

							 'batal' => site_url());

			if($jenis=="sampel"){

				$arrdata['judul'] = 'Rekap Laporan Data Sampling';

				$arrdata['act'] = site_url().'/toexcel/excels/sampel/rekap';

				$arrdata['bulan'] = array('' => '',

										  '1' => 'Januari',

										  '2' => 'Februari',

										  '3' => 'Maret',

										  '4' => 'April',

										  '5' => 'Mei',

										  '6' => 'Juni',

										  '7' => 'Juli',

										  '8' => 'Agustus',

										  '9' => 'September',

										  '10' => 'Oktober',

										  '11' => 'November',

										  '12' => 'Desember');

				for($i = (date("Y") - 5) ; $i <= (date("Y")+1); $i++){ 

				 	$arrtahun[$i] = $i;

				}

				$arrdata['tahun'] = $arrtahun;

			}else if($jenis == "hasil-uji"){

				$arrdata['judul'] = 'Rekap Laporan Hasil Pengujian Sampel';

				$arrdata['act'] = site_url().'/toexcel/excels/sampel/hasil-uji';

				$arrdata['hasil'] = $sipt->main->combobox("SELECT KODE, URAIAN FROM M_TABEL WHERE JENIS = 'HASIL' AND KODE IN ('MS','TMS','HPST') ORDER BY 1","KODE","URAIAN",TRUE);

				$arrdata['bulan'] = array('' => '',

										  '01' => 'Januari',

										  '02' => 'Februari',

										  '03' => 'Maret',

										  '04' => 'April',

										  '05' => 'Mei',

										  '06' => 'Juni',

										  '07' => 'Juli',

										  '08' => 'Agustus',

										  '09' => 'September',

										  '10' => 'Oktober',

										  '11' => 'November',

										  '12' => 'Desember');

				for($i = (date("Y") - 1) ; $i <= (date("Y")+1); $i++){ 

				 	$arrtahun[$i] = $i;

				 }

				 $arrdata['tahun'] = $arrtahun;

			}else if($jenis=="rekapsampel"){

				$klas_komoditi = "'".join("','", $this->config->item('jenis_sarana'))."'";

				$tmp = "";

				foreach($this->newsession->userdata('SESS_KLASIFIKASI_ID') as $komoditi){

					$tmp  .= "'".substr($komoditi,-2). "',";

				}

				$tmp = $tmp."'02','07',";

				$kk = substr($tmp,0,-1);

				//$arrdata['komoditi'] = $sipt->main->combobox("SELECT KLASIFIKASI_ID, KLASIFIKASI FROM M_GOLONGAN WHERE LEN(KLASIFIKASI_ID) = 2 AND KLASIFIKASI_ID IN ($kk) AND KLASIFIKASI_ID NOT IN ('05','06')","KLASIFIKASI_ID","KLASIFIKASI",TRUE);

				$arrdata['judul'] = 'RHPK Data Sampling';

				$arrdata['act'] = site_url().'/toexcel/excels/sampel/rhpk';

				if(in_array('1', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('10', $this->newsession->userdata('SESS_KODE_ROLE'))){

					$arrdata['all'] = '1';

				}else{

					$arrdata['all'] = '0';

				}

			}else if($jenis=="rekap-pnbp"){

				$arrdata['judul'] = 'Rekapitulasi Data PNBP Sampel Pihak Ketiga';

				$arrdata['act'] = '#';

			}else if($jenis=="rekap-status"){

				$arrdata['judul'] = 'Rekapitulasi Status Data Sampel';

				$arrdata['act'] = site_url().'/toexcel/excels/sampel/status';

			}

			else if($jenis=="rekap-timeline"){

				$arrdata['judul'] = 'Rekapitulasi Timeline Sampling Pengujian';

				$arrdata['act'] = site_url().'/toexcel/excels/sampel/rekap-timeline';

				$arrdata['filter_tanggal'] = array(''=>'','TANGGAL_SAMPLING'=>'Sampling', 'TANGGAL_SPU' => 'SPU', 'AWAL_UJI'=>'Awal Uji', 'AKHIR_UJI'=>'Akhir Uji');

			}

			if(in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))){

				foreach($this->newsession->userdata('SESS_KLASIFIKASI_ID') as $komoditi){

					$tmp  .= "'".substr($komoditi,-2). "',";

				}

				$kk = substr($tmp,0,-1);

				if($this->newsession->userdata('SESS_BBPOM_ID') == '91'){#Ditwas Produksi

					$arrdata['komoditi'] = $sipt->main->combobox("SELECT KLASIFIKASI_ID, KLASIFIKASI FROM M_GOLONGAN_NEW WHERE LEN(KLASIFIKASI_ID) = 2 AND KLASIFIKASI_ID = '01'","KLASIFIKASI_ID","KLASIFIKASI",TRUE);

				}else if($this->newsession->userdata('SESS_BBPOM_ID') == '93'){#Ditwas Napza

					$arrdata['komoditi'] = $sipt->main->combobox("SELECT KLASIFIKASI_ID, KLASIFIKASI FROM M_GOLONGAN_NEW WHERE KLASIFIKASI_ID IN ('07','20')","KLASIFIKASI_ID","KLASIFIKASI",TRUE);

				}else if($this->newsession->userdata('SESS_BBPOM_ID') == '96'){#Ditwas BB

					$arrdata['komoditi'] = $sipt->main->combobox("SELECT KLASIFIKASI_ID, KLASIFIKASI FROM M_GOLONGAN_NEW WHERE LEN(KLASIFIKASI_ID) = 2 AND KLASIFIKASI_ID = '14'","KLASIFIKASI_ID","KLASIFIKASI",TRUE);

				}else{

					$arrdata['komoditi'] = $sipt->main->combobox("SELECT KLASIFIKASI_ID, KLASIFIKASI FROM M_GOLONGAN_NEW WHERE LEN(KLASIFIKASI_ID) = 2 AND KLASIFIKASI_ID IN ($kk) AND KLASIFIKASI_ID NOT IN ('05','06')","KLASIFIKASI_ID","KLASIFIKASI",TRUE);

				}

			}else{

				$arrdata['komoditi'] = $sipt->main->combobox("SELECT KLASIFIKASI_ID, KLASIFIKASI FROM M_GOLONGAN_NEW WHERE LEN(KLASIFIKASI_ID) = 2 AND KLASIFIKASI_ID NOT IN ('05','06')","KLASIFIKASI_ID","KLASIFIKASI",TRUE);

			}

			$arrdata['anggaran'] = $sipt->main->combobox("SELECT KODE, URAIAN FROM M_TABEL WHERE JENIS = 'ANGGARAN_SAMPLING'", "KODE", "URAIAN", TRUE);

			$arrdata['tujuan'] = $sipt->main->combobox("SELECT KODE, URAIAN FROM M_TABEL WHERE JENIS = 'TUJUAN_SAMPLING'", "KODE", "URAIAN", TRUE);

			$arrdata['asal'] = $sipt->main->combobox("SELECT KODE, URAIAN FROM M_TABEL WHERE JENIS = 'ASAL_SAMPLING'", "KODE", "URAIAN", TRUE);

			$arrdata['kategori'] = array();

			return $arrdata;

		}

	}

	

	function set_rekap_unit(){

		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){

			$sipt =& get_instance();

			$this->load->model("main", "main", true);			

			$sarana = "'".join("','", $this->newsession->userdata('SESS_SARANA'))."'";

			$filter = "";

			if(trim($this->input->post('STATUS_AWAL')!="")){

				$filter .= " AND DATEDIFF(dy, 0, convert(DATETIME, A.AWAL_PERIKSA, 105)) >= DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('STATUS_AWAL')."', 105))";

				$awal = $this->input->post('STATUS_AWAL');

			}else{

				$filter .= " AND A.AWAL_PERIKSA > DATEADD(M, DATEDIFF(M,0,GETDATE()),0)";

				$awal = date('01/m/Y');
			}

			if(trim($this->input->post('STATUS_AKHIR')!="")){

				$filter .= " AND DATEDIFF(dy, 0, convert(DATETIME, A.AKHIR_PERIKSA, 105)) <= DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('STATUS_AKHIR')."', 105))";

				$akhir = $this->input->post('STATUS_AKHIR');

			}else{

				$filter .= " AND A.AKHIR_PERIKSA < DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,0,GETDATE())+1,0))";

				$akhir = date('t/m/Y');

			}

			if(in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')) || $this->newsession->userdata('SESS_BBPOM_ID') == "00"){

				if(trim($this->input->post('BBPOM_ID'))==""){

					$filter .= "";

					$balai = 'Seluruh Balai';

				}else{

					$filter .= " AND A.BBPOM_ID = '".$this->input->post('BBPOM_ID')."'";

					$balai = $sipt->main->get_uraian("SELECT NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID = '".$this->input->post('BBPOM_ID')."'","NAMA_BBPOM");		

				}

			}else{

				$filter .= " AND A.BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'";

				$balai = $sipt->main->get_uraian("SELECT NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","NAMA_BBPOM");		

			}



			$query = "SELECT *, ([TLBALAI] + [OPPUSATDRAFT] + [OPPUSATREJECT] + [OPPUSATREV] + [SPV1PUSATTL] + [SPV1PUSATREJECT] + [SPV1PUSATREV] + [SPV2PUSATTL] + [SPV2PUSATREJECT] + [SPV2PUSATREV] + [DIREKTUR] + [SELESAI]) as TOTAL FROM(SELECT REPLACE(REPLACE(C.NAMA_BBPOM,'BALAI BESAR POM', 'BBPOM'),'BALAI POM','BPOM') AS NAMA_BBPOM,(SELECT COUNT(Y.STATUS) FROM T_PEMERIKSAAN Y WHERE Y.BBPOM_ID = A.BBPOM_ID AND Y.STATUS LIKE '%___0_%' AND Y.JENIS_SARANA_ID IN ($sarana) $filter) AS TOTBALAI, CASE WHEN A.STATUS = '20115' THEN 'TLBALAI' WHEN A.STATUS = '20111' THEN 'OPPUSATDRAFT' WHEN A.STATUS = '20112' THEN 'OPPUSATREJECT' WHEN A.STATUS = '20113' THEN 'OPPUSATREV' WHEN A.STATUS = '30111' THEN 'SPV1PUSATTL' WHEN A.STATUS = '30112' THEN 'SPV1PUSATREJECT' WHEN A.STATUS IN ('30113','30114') THEN 'SPV1PUSATREV' WHEN A.STATUS = '40111' THEN 'SPV2PUSATTL' WHEN A.STATUS = '40112' THEN 'SPV2PUSATREJECT' WHEN A.STATUS = '40113' THEN 'SPV2PUSATREV' WHEN A.STATUS = '60111' THEN 'DIREKTUR' WHEN A.STATUS = '20' THEN 'SELESAI' END AS STATUS FROM T_PEMERIKSAAN A LEFT JOIN M_BBPOM C ON A.BBPOM_ID = C.BBPOM_ID WHERE A.JENIS_SARANA_ID IN ($sarana) $filter AND A.STATUS NOT IN('00')) DT PIVOT(COUNT(STATUS) FOR STATUS IN ([TLBALAI], [OPPUSATDRAFT], [OPPUSATREJECT], [OPPUSATREV], [SPV1PUSATTL], [SPV1PUSATREJECT], [SPV1PUSATREV], [SPV2PUSATTL], [SPV2PUSATREJECT], [SPV2PUSATREV], [DIREKTUR], [SELESAI])) PVT ORDER BY PVT.NAMA_BBPOM ASC";

			$data = $sipt->main->get_result($query);

			$kolom = array();

			if($data){

				foreach($query->result_array() as $row){

					$kolom[] = $row;

					$arrdata = array('kolom' => $kolom, 'judul' => 'Rekapitulasi Status Dokumen Pemeriksaan');

				}

			}

			$arrdata['awal'] = $awal;

			$arrdata['akhir'] = $akhir;

			$arrdata['balai'] = $balai;

			return $arrdata;

		}

	}

}

?>