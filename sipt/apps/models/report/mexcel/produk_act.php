<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);
class Produk_act extends Model{	
	function deputi1(){#---- Produk Obat
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$this->load->library('newphpexcel');
			$judul = $sipt->main->get_uraian("SELECT DISTINCT(NAMA_KK) AS NAMA_KK  FROM M_KLASIFIKASI_KATEGORI WHERE KK_ID ='".$this->input->post('PRODUK_KLASIFIKASI')."'","NAMA_KK");
			/*if($this->input->post('KOTA') != "")
				$kota = " LEFT JOIN M_SARANA M ON M.SARANA_ID = B.SARANA_ID ";
			else
				$kota = "";*/
			$query = "SELECT A.KATEGORI, A.NAMA_PRODUK, A.NAMA_PABRIK, A.NEGARA_ASAL, A.KEMASAN, A.NOMOR_REGISTRASI, A.NO_BATCH, A.TANGGAL_EXPIRE, A.JUMLAH_TEMUAN, A.SATUAN, A.NAMA_PERUSAHAAN, A.ALAMAT_PERUSAHAAN, A.PEMILIK, A.TINDAKAN_PRODUK, A.KETERANGAN_SUMBER, REPLACE(REPLACE(C.NAMA_BBPOM,'BALAI BESAR POM DI ', ''),'BALAI POM DI ','') AS NAMA_BBPOM, M.NAMA_SARANA, M.ALAMAT_1, M.NAMA_PIMPINAN, A.HARGA_SATUAN, A.HARGA_TOTAL FROM T_PEMERIKSAAN_TEMUAN_PRODUK A LEFT JOIN T_PEMERIKSAAN B ON A.PERIKSA_ID = B.PERIKSA_ID LEFT JOIN M_BBPOM C ON B.BBPOM_ID = C.BBPOM_ID LEFT JOIN M_SARANA M ON M.SARANA_ID = B.SARANA_ID WHERE A.KK_ID = '".$this->input->post('PRODUK_KLASIFIKASI')."' AND A.NAMA_PRODUK IS NOT NULL";
			if(trim($this->input->post('PRODUK_AWAL')!="")){
				$query .= " AND DATEDIFF(dy, 0, convert(DATETIME, B.AWAL_PERIKSA, 105)) >= DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('PRODUK_AWAL')."', 105))";
				$awal = $this->input->post('PRODUK_AWAL');
			}else{
				$query .= " AND B.AWAL_PERIKSA > DATEADD(M, DATEDIFF(M,0,GETDATE()),0)";
				$awal = date('01/m/Y');
			}
			if(trim($this->input->post('PRODUK_AKHIR')!="")){
				$query .= " AND DATEDIFF(dy, 0, convert(DATETIME, B.AKHIR_PERIKSA, 105)) <= DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('PRODUK_AKHIR')."', 105))";
				$akhir = $this->input->post('PRODUK_AKHIR');
			}else{
				$query .= " AND B.AWAL_PERIKSA < DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,0,GETDATE())+1,0))";
				$akhir = date('t/m/Y');
			}
			if(trim($this->input->post('PRODUK_NAMAPRODUK')) != "") $query .= " AND A.NAMA_PRODUK LIKE '%".$this->input->post('PRODUK_NAMAPRODUK')."%'";
			if(trim($this->input->post('PRODUK_NOREGISTRASI')) != "") $query .= " AND A.NOMOR_REGISTRASI LIKE '%".$this->input->post('PRODUK_NOREGISTRASI')."%'";
			if(trim($this->input->post('PRODUK_NO_BATCH')) != "") $query .= " AND A.NO_BATCH LIKE '%".$this->input->post('PRODUK_NO_BATCH')."%'";
			if(trim($this->input->post('PRODUK_KATEGORI')) != "") $query .= " AND A.KATEGORI LIKE '%".$this->input->post('PRODUK_KATEGORI')."%'";
			if(trim($this->input->post('PRODUK_TINDAKAN')) != "") $query .= " AND A.TINDAKAN_PRODUK LIKE '%".$this->input->post('PRODUK_TINDAKAN')."%'";
			if(trim($this->input->post('KOTA')!="")) $query .= " AND M.KOTA  = '".$this->input->post('KOTA')."'";
			if(in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')) || $this->newsession->userdata('SESS_BBPOM_ID') == "00"){
				if(trim($this->input->post('PRODUK_BBPOM_ID'))==""){
					$query .= "";
					$balai = 'Seluruh Balai';
				}else{
					$query .= " AND B.BBPOM_ID = '".$this->input->post('PRODUK_BBPOM_ID')."'";
					$balai = $sipt->main->get_uraian("SELECT NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID = '".$this->input->post('PRODUK_BBPOM_ID')."'","NAMA_BBPOM");		
				}
			}else{
				$query .= " AND B.BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'";
				$balai = $sipt->main->get_uraian("SELECT NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","NAMA_BBPOM");		
			}
			#$query .= " AND B.STATUS LIKE '%1_' ";
			$query .= " ORDER BY A.NAMA_PRODUK ASC";
			$this->newphpexcel->getDefaultStyle()->getFont()->setName('Calibri')->setSize(10);
			$this->newphpexcel->setActiveSheetIndex(0);
			$this->newphpexcel->mergecell(array(array('A1','P1'),array('A2','B2'),array('A3','B3'),array('A4','B4'),array('A5','B5')), FALSE);
			$this->newphpexcel->mergecell(array(array('A7','A8'),array('B7','N7'),array('O7','Q7'),array('R7','R8')), TRUE);
			$this->newphpexcel->width(array(array('A',5),array('B',45),array('C',15),array('D',30),array('E',30),array('F',20),array('G',20),array('H',8),array('I',15),array('J',15),array('K',40),array('L',20),array('M',20),array('N',20),array('O',40),array('P',40),array('Q',40),array('R',15)));
			$this->newphpexcel->set_bold(array('A1','C2','C5'));
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A1', 'LAPORAN BB/B POM TERKAIT OBAT PALSU DAN TIE SERTA OBAT KERAS')->setCellValue('A2', 'Komoditi')->setCellValue('C2', $judul)->setCellValue('A3', 'Pemeriksaan Awal')->setCellValue('C3', $awal)->setCellValue('A4', 'Pemeriksaan Akhir')->setCellValue('C4', $akhir)->setCellValue('A5', 'Balai Besar / Balai POM')->setCellValue('C5', $balai);
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A7','No.')->setCellValue('B7','Informasi Produk')->setCellValue('O7','Informasi Sarana')->setCellValue('R7','Balai Pemeriksa')->setCellValue('B8','Nama Produk')->setCellValue('C8','Kategori')->setCellValue('D8','Kemasan')->setCellValue('E8','NIE')->setCellValue('F8','No. Lot / Bets')->setCellValue('G8','Exp Date')->setCellValue('H8','Jumlah')->setCellValue('I8','Harga Satuan')->setCellValue('J8','Harga Total')->setCellValue('K8','Tindakan')->setCellValue('L8','Keterangan')->setCellValue('M8','Pabrik')->setCellValue('N8','Negara Asal')->setCellValue('O8','Nama')->setCellValue('P8','Alamat')->setCellValue('Q8','Pemilik');
			$this->newphpexcel->headings(array('A7','B7','C7','D7','E7','F7','G7','H7','I7','J7','K7','L7','M7','N7','O7','P7','Q7','R7'));
			$this->newphpexcel->headings(array('B8','C8','D8','E8','F8','G8','H8','I8','J8','K8','L8','M8','N8','O8','P8','Q8','R8'));
			$this->newphpexcel->set_wrap(array('B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R'));
			$data = $sipt->main->get_result($query);
			$no=1;
			$rec = 9;
			if($data){
				foreach($query->result_array() as $row){
				   $total = $row["HARGA_SATUAN"] * $row["HARGA_TOTAL"];
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A'.$rec,$no)
					->setCellValue('B'.$rec,$row["NAMA_PRODUK"])
					->setCellValue('C'.$rec,$row["KATEGORI"])
					->setCellValue('D'.$rec,$row["KEMASAN"])
					->setCellValue('E'.$rec,$row["NOMOR_REGISTRASI"])
					->setCellValue('F'.$rec,$row["NO_BATCH"])
					->setCellValue('G'.$rec,$row["TANGGAL_EXPIRE"])
					->setCellValue('H'.$rec,$row["JUMLAH_TEMUAN"])
					->setCellValue('I'.$rec,$row["HARGA_SATUAN"] == "" ? "0" : $row["HARGA_SATUAN"])
					->setCellValue('J'.$rec,$row["HARGA_TOTAL"] == "" ? "0" : $total)
					->setCellValue('K'.$rec,$row["TINDAKAN_PRODUK"])
					->setCellValue('L'.$rec,$row["KETERANGAN_SUMBER"])
					->setCellValue('M'.$rec,$row["NAMA_PABRIK"])
					->setCellValue('N'.$rec,$row["NEGARA_ASAL"])
					->setCellValue('O'.$rec,$row["NAMA_SARANA"])
					->setCellValue('P'.$rec,$row["ALAMAT_1"])
					->setCellValue('Q'.$rec,$row["NAMA_PIMPINAN"])
					->setCellValue('R'.$rec,$row["NAMA_BBPOM"]);
					$this->newphpexcel->set_detilstyle(array('A'.$rec,'B'.$rec,'C'.$rec,'D'.$rec,'E'.$rec,'F'.$rec,'G'.$rec,'H'.$rec,'I'.$rec,'J'.$rec,'K'.$rec,'L'.$rec,'M'.$rec,'N'.$rec,'O'.$rec,'P'.$rec,'Q'.$rec,'R'.$rec));
					$rec++;
					$no++;
				}
			}else{
				$this->newphpexcel->getActiveSheet()->mergeCells('A9:R9');
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A9','Data Tidak Ditemukan');
				$this->newphpexcel->set_detilstyle(array('A9'));
			}
			ob_clean();
			$file = "TEMUAN_PRODUK_".str_replace(" ","_",str_replace("-","",$judul))."_".date("YmdHis").".xls";
			header("Content-type: application/x-msdownload");
			header("Content-Disposition: attachment;filename=$file");
			header("Cache-Control: max-age=0");
			header("Pragma: no-cache");
			header("Expires: 0");
			$objWriter = PHPExcel_IOFactory::createWriter($this->newphpexcel, 'Excel5'); 
			$objWriter->save('php://output');
			exit();		
		}
	}
		
	function deputi2(){#---- Produk OT, KOS, SM
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$this->load->library('newphpexcel');
			$judul = $sipt->main->get_uraian("SELECT DISTINCT(NAMA_KK) AS NAMA_KK  FROM M_KLASIFIKASI_KATEGORI WHERE KK_ID ='".$this->input->post('PRODUK_KLASIFIKASI')."'","NAMA_KK");
			/*if($this->input->post('KOTA') != "")
				$kota = " LEFT JOIN M_SARANA M ON M.SARANA_ID = B.SARANA_ID ";
			else
				$kota = "";*/
			$query = "SELECT A.NAMA_PRODUK, A.KLASIFIKASI_PRODUK, A.NETTO, A.NOMOR_REGISTRASI, A.SATUAN, A.NO_BATCH, A.TANGGAL_EXPIRE, A.NAMA_PERUSAHAAN, A.ALAMAT_PERUSAHAAN, A.KATEGORI, A.JUMLAH_TEMUAN, A.HARGA_SATUAN, (A.JUMLAH_TEMUAN * A.HARGA_SATUAN) AS HARGA_TOTAL, A.TINDAKAN_PRODUK, A.KETERANGAN_SUMBER, A.JENIS_PELANGGARAN, A.TINDAKAN_PRODUK, M.NAMA_SARANA, M.ALAMAT_1, M.NAMA_PIMPINAN, REPLACE(REPLACE(C.NAMA_BBPOM,'BALAI BESAR POM DI ', ''),'BALAI POM DI ','') AS NAMA_BBPOM FROM T_PEMERIKSAAN_TEMUAN_PRODUK A LEFT JOIN T_PEMERIKSAAN B ON A.PERIKSA_ID = B.PERIKSA_ID LEFT JOIN M_BBPOM C ON B.BBPOM_ID = C.BBPOM_ID LEFT JOIN M_SARANA M ON M.SARANA_ID = B.SARANA_ID WHERE A.KK_ID = '".$this->input->post('PRODUK_KLASIFIKASI')."' AND A.NAMA_PRODUK IS NOT NULL";
			if(trim($this->input->post('PRODUK_AWAL')!="")){
				$query .= " AND DATEDIFF(dy, 0, convert(DATETIME, B.AWAL_PERIKSA, 105)) >= DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('PRODUK_AWAL')."', 105))";
				$awal = $this->input->post('PRODUK_AWAL');
			}else{
				$query .= " AND B.AWAL_PERIKSA > DATEADD(M, DATEDIFF(M,0,GETDATE()),0)";
				$awal = date('01/m/Y');
			}
			if(trim($this->input->post('PRODUK_AKHIR')!="")){
				$query .= " AND DATEDIFF(dy, 0, convert(DATETIME, B.AKHIR_PERIKSA, 105)) <= DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('PRODUK_AKHIR')."', 105))";
				$akhir = $this->input->post('PRODUK_AKHIR');
			}else{
				$query .= " AND B.AWAL_PERIKSA < DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,0,GETDATE())+1,0))";
				$akhir = date('t/m/Y');
			}
			if(trim($this->input->post('PRODUK_NAMAPRODUK')) != "") $query .= " AND A.NAMA_PRODUK LIKE '%".$this->input->post('PRODUK_NAMAPRODUK')."%'";
			if(trim($this->input->post('PRODUK_NOREGISTRASI')) != "") $query .= " AND A.NOMOR_REGISTRASI LIKE '%".$this->input->post('PRODUK_NOREGISTRASI')."%'";
			if(trim($this->input->post('PRODUK_NO_BATCH')) != "") $query .= " AND A.NO_BATCH LIKE '%".$this->input->post('PRODUK_NO_BATCH')."%'";
			if(trim($this->input->post('PRODUK_KLASIFIKASIPRODUK')) != "") $query .= " AND A.KLASIFIKASI_PRODUK LIKE '%".$this->input->post('PRODUK_KLASIFIKASIPRODUK')."%'";
			if(trim($this->input->post('PRODUK_KATEGORI')) != "") $query .= " AND A.KATEGORI LIKE '%".$this->input->post('PRODUK_KATEGORI')."%'";
			if(trim($this->input->post('PRODUK_JENISPELANGGARAN')) != "") $query .= " AND A.JENIS_PELANGGARAN LIKE '%".$this->input->post('PRODUK_JENISPELANGGARAN')."%'";
			if(trim($this->input->post('PRODUK_TINDAKAN')) != "") $query .= " AND A.TINDAKAN_PRODUK LIKE '%".$this->input->post('PRODUK_TINDAKAN')."%'";
			if(trim($this->input->post('KOTA')!="")) $query .= " AND M.KOTA  = '".$this->input->post('KOTA')."'";
			if(in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')) || $this->newsession->userdata('SESS_BBPOM_ID') == "00"){
				if(trim($this->input->post('PRODUK_BBPOM_ID'))==""){
					$query .= "";
					$balai = 'Seluruh Balai';
				}else{
					$query .= " AND B.BBPOM_ID = '".$this->input->post('PRODUK_BBPOM_ID')."'";
					$balai = $sipt->main->get_uraian("SELECT NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID = '".$this->input->post('PRODUK_BBPOM_ID')."'","NAMA_BBPOM");		
				}
			}else{
				$query .= " AND B.BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'";
				$balai = $sipt->main->get_uraian("SELECT NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","NAMA_BBPOM");		
			}
			#$query .= " AND B.STATUS LIKE '%1_' ";
			$query .= " ORDER BY A.NAMA_PRODUK ASC";
			$this->newphpexcel->getDefaultStyle()->getFont()->setName('Calibri')->setSize(10);
			$this->newphpexcel->setActiveSheetIndex(0);
			$this->newphpexcel->mergecell(array(array('A1','Q1'),array('A2','B2'),array('A3','B3'),array('A4','B4'),array('A5','B5')), FALSE);
			$this->newphpexcel->mergecell(array(array('A7','A8'),array('B7','G7'),array('H7','N7'),array('O7','P7'),array('Q7','Q8'),array('R7','R8'),array('S7','S8')), TRUE);
			$this->newphpexcel->width(array(array('A',5),array('B',45),array('C',30),array('D',30),array('E',30),array('F',20),array('G',20),array('H',20),array('I',8),array('J',15),array('K',15),array('L',30),array('M',20),array('N',40),array('O',30),array('P',30),array('Q',40),array('R',40),array('S',15)));
			$this->newphpexcel->set_bold(array('A1','C2','C5'));
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A1', 'LAPORAN BB/B POM TERKAIT TEMUAN PRODUK '.strtoupper($judul))->setCellValue('A2', 'Komoditi')->setCellValue('C2', $judul)->setCellValue('A3', 'Pemeriksaan Awal')->setCellValue('C3', $awal)->setCellValue('A4', 'Pemeriksaan Akhir')->setCellValue('C4', $akhir)->setCellValue('A5', 'Balai Besar / Balai POM')->setCellValue('C5', $balai);
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A7','No.')->setCellValue('B7','Informasi Produk')->setCellValue('H7','Keterangan Temuan')->setCellValue('O7','Identitas Perusahaan')->setCellValue('Q7','Nama Sarana')->setCellValue('R7','Alamat Sarana')->setCellValue('S7','Balai Pemeriksa')->setCellValue('B8','Nama Produk')->setCellValue('C8','Nomor Registrasi')->setCellValue('D8','No Batch')->setCellValue('E8','Netto')->setCellValue('F8','Tanggal Expire')->setCellValue('G8','Klasifikasi Produk')->setCellValue('H8','Kategori')->setCellValue('I8','Jumlah')->setCellValue('J8','Harga Satuan')->setCellValue('K8','Harga Total')->setCellValue('L8','Jenis Pelanggaran')->setCellValue('M8','Tindakan Produk')->setCellValue('N8','Keterangan Sumber')->setCellValue('O8','Nama Perusahaan')->setCellValue('P8','Alamat Perusahaan');
			$this->newphpexcel->headings(array('A7','B7','C7','D7','E7','F7','G7','H7','I7','J7','K7','L7','M7','N7','O7','P7','Q7','R7','S7'));
			$this->newphpexcel->headings(array('B8','C8','D8','E8','F8','G8','H8','I8','J8','K8','L8','M8','N8','O8','P8','Q8','R8','S7'));
			$this->newphpexcel->set_wrap(array('B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S'));
			$data = $sipt->main->get_result($query);
			$no=1;
			$rec = 9;
			if($data){
				foreach($query->result_array() as $row){
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A'.$rec,$no)
					->setCellValue('B'.$rec,str_replace('=', ' ', $row["NAMA_PRODUK"]))
					->setCellValue('C'.$rec,str_replace('=', ' ', $row["NOMOR_REGISTRASI"]))
					->setCellValue('D'.$rec,str_replace('=', ' ', $row["NO_BATCH"]))
					->setCellValue('E'.$rec,str_replace('=', ' ', $row["NETTO"]))
					->setCellValue('F'.$rec,$row["TANGGAL_EXPIRE"])
					->setCellValue('G'.$rec,$row["KLASIFIKASI_PRODUK"])
					->setCellValue('H'.$rec,str_replace('=', ' ', $row["KATEGORI"]))
					->setCellValue('I'.$rec,str_replace('=', ' ', $row["JUMLAH_TEMUAN"]))
					->setCellValue('J'.$rec,$row["HARGA_SATUAN"])
					->setCellValue('K'.$rec,$row["HARGA_TOTAL"])
					->setCellValue('L'.$rec,str_replace('=', ' ', $row["JENIS_PELANGGARAN"]))
					->setCellValue('M'.$rec,str_replace('=', ' ', $row["TINDAKAN_PRODUK"]))
					->setCellValue('N'.$rec,str_replace('=', ' ', $row["KETERANGAN_SUMBER"]))
					->setCellValue('O'.$rec,str_replace('=', ' ', $row["NAMA_PERUSAHAAN"]))
					->setCellValue('P'.$rec,str_replace('=', ' ', $row["ALAMAT_PERUSAHAAN"]))
					->setCellValue('Q'.$rec,$row["NAMA_SARANA"])
					->setCellValue('R'.$rec,$row["ALAMAT_1"])
					->setCellValue('S'.$rec,$row["NAMA_BBPOM"]);
					$this->newphpexcel->set_detilstyle(array('A'.$rec,'B'.$rec,'C'.$rec,'D'.$rec,'E'.$rec,'F'.$rec,'G'.$rec,'H'.$rec,'I'.$rec,'J'.$rec,'K'.$rec,'L'.$rec,'M'.$rec,'N'.$rec,'O'.$rec,'P'.$rec,'Q'.$rec,'R'.$rec,'S'.$rec));
					$rec++;
					$no++;
				}
			}else{
				$this->newphpexcel->getActiveSheet()->mergeCells('A9:Q9');
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A9','Data Tidak Ditemukan');
				$this->newphpexcel->set_detilstyle(array('A9'));
			}
			ob_clean();
			$file = "TEMUAN_PRODUK_".str_replace(" ","_",str_replace("-","",$judul))."_".date("YmdHis").".xls";
			header("Content-type: application/x-msdownload");
			header("Content-Disposition: attachment;filename=$file");
			header("Cache-Control: max-age=0");
			header("Pragma: no-cache");
			header("Expires: 0");
			$objWriter = PHPExcel_IOFactory::createWriter($this->newphpexcel, 'Excel5'); 
			$objWriter->save('php://output');
			exit();		
		}
	}
		
	function deputi3(){#---- Produk Pangan
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$this->load->library('newphpexcel');
			$judul = $sipt->main->get_uraian("SELECT DISTINCT(NAMA_KK) AS NAMA_KK  FROM M_KLASIFIKASI_KATEGORI WHERE KK_ID ='".$this->input->post('PRODUK_KLASIFIKASI')."'","NAMA_KK");
			/*if($this->input->post('KOTA') != "")
				$kota = " LEFT JOIN M_SARANA M ON M.SARANA_ID = B.SARANA_ID ";
			else
				$kota = "";*/
			$query = "SELECT A.NAMA_PRODUK, A.PRODUSEN, A.REGISTRASI, A.NOMOR_REGISTRASI, A.KEMASAN, A.SATUAN, A.KATEGORI, A.HARGA, REPLACE(REPLACE(C.NAMA_BBPOM,'BALAI BESAR POM DI ', ''),'BALAI POM DI ','') AS NAMA_BBPOM, M.NAMA_SARANA, M.ALAMAT_1, M.NAMA_PIMPINAN FROM T_PEMERIKSAAN_TEMUAN_PRODUK A LEFT JOIN T_PEMERIKSAAN B ON A.PERIKSA_ID = B.PERIKSA_ID LEFT JOIN M_BBPOM C ON B.BBPOM_ID = C.BBPOM_ID LEFT JOIN M_SARANA M ON M.SARANA_ID = B.SARANA_ID WHERE A.KK_ID = '".$this->input->post('PRODUK_KLASIFIKASI')."' AND A.NAMA_PRODUK IS NOT NULL";
			if(trim($this->input->post('PRODUK_AWAL')!="")){
				$query .= " AND DATEDIFF(dy, 0, convert(DATETIME, B.AWAL_PERIKSA, 105)) >= DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('PRODUK_AWAL')."', 105))";
				$awal = $this->input->post('PRODUK_AWAL');
			}else{
				$query .= " AND B.AWAL_PERIKSA > DATEADD(M, DATEDIFF(M,0,GETDATE()),0)";
				$awal = date('01/m/Y');
			}
			if(trim($this->input->post('PRODUK_AKHIR')!="")){
				$query .= " AND DATEDIFF(dy, 0, convert(DATETIME, B.AKHIR_PERIKSA, 105)) <= DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('PRODUK_AKHIR')."', 105))";
				$akhir = $this->input->post('PRODUK_AKHIR');
			}else{
				$query .= " AND B.AWAL_PERIKSA < DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,0,GETDATE())+1,0))";
				$akhir = date('t/m/Y');
			}
			if(trim($this->input->post('PRODUK_NAMAPRODUK')) != "") $query .= " AND A.NAMA_PRODUK LIKE '%".$this->input->post('PRODUK_NAMAPRODUK')."%'";
			if(trim($this->input->post('PRODUK_NOREGISTRASI')) != "") $query .= " AND A.NOMOR_REGISTRASI LIKE '%".$this->input->post('PRODUK_NOREGISTRASI')."%'";
			if(trim($this->input->post('PRODUK_NO_BATCH')) != "") $query .= " AND A.NO_BATCH LIKE '%".$this->input->post('PRODUK_NO_BATCH')."%'";
			if(trim($this->input->post('PRODUK_KATEGORI')) != "") $query .= " AND A.KATEGORI LIKE '%".$this->input->post('PRODUK_KATEGORI')."%'";
			if(trim($this->input->post('KOTA')!="")) $query .= " AND M.KOTA  = '".$this->input->post('KOTA')."'";
			if(in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')) || $this->newsession->userdata('SESS_BBPOM_ID') == "00"){
				if(trim($this->input->post('PRODUK_BBPOM_ID'))==""){
					$query .= "";
					$balai = 'Seluruh Balai';
				}else{
					$query .= " AND B.BBPOM_ID = '".$this->input->post('PRODUK_BBPOM_ID')."'";
					$balai = $sipt->main->get_uraian("SELECT NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID = '".$this->input->post('PRODUK_BBPOM_ID')."'","NAMA_BBPOM");		
				}
			}else{
				$query .= " AND B.BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'";
				$balai = $sipt->main->get_uraian("SELECT NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","NAMA_BBPOM");		
			}
			#$query .= " AND B.STATUS LIKE '%1_' ";
			$query .= " ORDER BY A.NAMA_PRODUK ASC";
			$this->newphpexcel->getDefaultStyle()->getFont()->setName('Calibri')->setSize(10);
			$this->newphpexcel->setActiveSheetIndex(0);
			$this->newphpexcel->mergecell(array(array('A1','J1'),array('A2','B2'),array('A3','B3'),array('A4','B4'),array('A5','B5')), FALSE);
			$this->newphpexcel->width(array(array('A',5),array('B',45),array('C',30),array('D',30),array('E',30),array('F',8),array('G',20),array('H',30),array('I',15),array('J',15)));
			$this->newphpexcel->set_bold(array('A1','C2','C5'));
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A1', 'LAPORAN BB/B POM TERKAIT TEMUAN PRODUK '.strtoupper($judul))->setCellValue('A2', 'Komoditi')->setCellValue('C2', $judul)->setCellValue('A3', 'Pemeriksaan Awal')->setCellValue('C3', $awal)->setCellValue('A4', 'Pemeriksaan Akhir')->setCellValue('C4', $akhir)->setCellValue('A5', 'Balai Besar / Balai POM')->setCellValue('C5', $balai);
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A7','No.')->setCellValue('B7','Nama Produk')->setCellValue('C7','Produsen')->setCellValue('D7','Jenis Registrasi')->setCellValue('E7','Nomor Registrasi')->setCellValue('F7','Kemasan')->setCellValue('G7','Satuan')->setCellValue('H7','Kategori')->setCellValue('I7','Harga')->setCellValue('J7','Balai Pemeriksa');
			$this->newphpexcel->headings(array('A7','B7','C7','D7','E7','F7','G7','H7','I7','J7'));
			$this->newphpexcel->set_wrap(array('B','C','D','E','F','G','H','I','J'));
			$this->newphpexcel->set_number(array('E'));
			$data = $sipt->main->get_result($query);
			$no=1;
			$rec = 8;
			if($data){
				foreach($query->result_array() as $row){
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A'.$rec,$no)
					->setCellValue('B'.$rec,$row["NAMA_PRODUK"])
					->setCellValue('C'.$rec,$row["PRODUSEN"])
					->setCellValue('D'.$rec,$row["REGISTRASI"])
					->setCellValue('E'.$rec,$row["NOMOR_REGISTRASI"])
					->setCellValue('F'.$rec,$row["KEMASAN"])
					->setCellValue('G'.$rec,$row["SATUAN"])
					->setCellValue('H'.$rec,$row["KATEGORI"])
					->setCellValue('I'.$rec,$row["HARGA"])
					->setCellValue('J'.$rec,$row["NAMA_BBPOM"]);
					$this->newphpexcel->set_detilstyle(array('A'.$rec,'B'.$rec,'C'.$rec,'D'.$rec,'E'.$rec,'F'.$rec,'G'.$rec,'H'.$rec,'I'.$rec,'J'.$rec));
					$rec++;
					$no++;
				}
			}else{
				$this->newphpexcel->getActiveSheet()->mergeCells('A8:J8');
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A8','Data Tidak Ditemukan');
				$this->newphpexcel->set_detilstyle(array('A8'));
			}
			ob_clean();
			$file = "TEMUAN_PRODUK_".str_replace(" ","_",str_replace("-","",$judul))."_".date("YmdHis").".xls";
			header("Content-type: application/x-msdownload");
			header("Content-Disposition: attachment;filename=$file");
			header("Cache-Control: max-age=0");
			header("Pragma: no-cache");
			header("Expires: 0");
			$objWriter = PHPExcel_IOFactory::createWriter($this->newphpexcel, 'Excel5'); 
			$objWriter->save('php://output');
			exit();		
		}
	}
	
	function produkbb(){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$this->load->library('newphpexcel');
			$judul = $sipt->main->get_uraian("SELECT DISTINCT(NAMA_KK) AS NAMA_KK  FROM M_KLASIFIKASI_KATEGORI WHERE KK_ID ='".$this->input->post('PRODUK_KLASIFIKASI')."'","NAMA_KK");
			
			$query = "SELECT B.SARANA_ID, A.PERIKSA_ID, A.SERI, A.NAMA_BB, A.NAMA_PRODUK, A.KEMASAN, A.KLASIFIKASI_PRODUK, A.SUMBER_PENGADAAN, A.NAMA_PERUSAHAAN, A.ALAMAT_PERUSAHAAN, A.TELEPON, A.CARA_PEMBELIAN, A.STATUS_REPACKING, A.LAMPIRAN, REPLACE(REPLACE(C.NAMA_BBPOM,'BALAI BESAR POM DI ', ''),'BALAI POM DI ','') AS NAMA_BBPOM FROM T_PEMERIKSAAN_TEMUAN_PRODUK A LEFT JOIN T_PEMERIKSAAN B ON A.PERIKSA_ID = B.PERIKSA_ID LEFT JOIN M_BBPOM C ON B.BBPOM_ID = C.BBPOM_ID
WHERE  A.KK_ID = '".$this->input->post('PRODUK_KLASIFIKASI')."' ";
			if(trim($this->input->post('PRODUK_AWAL')!="")){
				$query .= " AND DATEDIFF(dy, 0, convert(DATETIME, B.AWAL_PERIKSA, 105)) >= DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('PRODUK_AWAL')."', 105))";
				$awal = $this->input->post('PRODUK_AWAL');
			}else{
				$query .= " AND B.AWAL_PERIKSA > DATEADD(M, DATEDIFF(M,0,GETDATE()),0)";
				$awal = date('01/m/Y');
			}
			if(trim($this->input->post('PRODUK_AKHIR')!="")){
				$query .= " AND DATEDIFF(dy, 0, convert(DATETIME, B.AKHIR_PERIKSA, 105)) <= DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('PRODUK_AKHIR')."', 105))";
				$akhir = $this->input->post('PRODUK_AKHIR');
			}else{
				$query .= " AND B.AWAL_PERIKSA < DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,0,GETDATE())+1,0))";
				$akhir = date('t/m/Y');
			}
			if(trim($this->input->post('PRODUK_NAMAPRODUK')) != "") $query .= " AND A.NAMA_PRODUK LIKE '%".$this->input->post('PRODUK_NAMAPRODUK')."%'";
			if(trim($this->input->post('PRODUK_NOREGISTRASI')) != "") $query .= " AND A.NOMOR_REGISTRASI LIKE '%".$this->input->post('PRODUK_NOREGISTRASI')."%'";
			if(trim($this->input->post('PRODUK_NO_BATCH')) != "") $query .= " AND A.NO_BATCH LIKE '%".$this->input->post('PRODUK_NO_BATCH')."%'";
			if(trim($this->input->post('PRODUK_KATEGORI')) != "") $query .= " AND A.KATEGORI LIKE '%".$this->input->post('PRODUK_KATEGORI')."%'";
			if(trim($this->input->post('KOTA')!="")) $query .= " AND M.KOTA  = '".$this->input->post('KOTA')."'";
			if(in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')) || $this->newsession->userdata('SESS_BBPOM_ID') == "00"){
				if(trim($this->input->post('PRODUK_BBPOM_ID'))==""){
					$query .= "";
					$balai = 'Seluruh Balai';
				}else{
					$query .= " AND B.BBPOM_ID = '".$this->input->post('PRODUK_BBPOM_ID')."'";
					$balai = $sipt->main->get_uraian("SELECT NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID = '".$this->input->post('PRODUK_BBPOM_ID')."'","NAMA_BBPOM");		
				}
			}else{
				$query .= " AND B.BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'";
				$balai = $sipt->main->get_uraian("SELECT NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","NAMA_BBPOM");		
			}
			
			$query .= " ORDER BY A.NAMA_PRODUK ASC";
			$this->newphpexcel->getDefaultStyle()->getFont()->setName('Calibri')->setSize(10);
			$this->newphpexcel->setActiveSheetIndex(0);
			$this->newphpexcel->mergecell(array(array('A1','M1'),array('A2','B2'),array('A3','B3'),array('A4','B4'),array('A5','B5')), FALSE);
			$this->newphpexcel->width(array(array('A',5),array('B',45),array('C',30),array('D',30),array('E',30),array('F',8),array('G',20),array('H',30),array('I',15),array('J',15),array('K',25),array('L',25),array('M',30)));
			$this->newphpexcel->set_bold(array('A1','C2','C5'));
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A1', 'LAPORAN BB/B POM TERKAIT TEMUAN PRODUK '.strtoupper($judul))->setCellValue('A2', 'Komoditi')->setCellValue('C2', $judul)->setCellValue('A3', 'Pemeriksaan Awal')->setCellValue('C3', $awal)->setCellValue('A4', 'Pemeriksaan Akhir')->setCellValue('C4', $akhir)->setCellValue('A5', 'Balai Besar / Balai POM')->setCellValue('C5', $balai);
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A7','No.')->setCellValue('B7','Nama Bahan Berbahaya')->setCellValue('C7','Nama Dagang')->setCellValue('D7','Kemasan')->setCellValue('E7','Klasifikasi Produk')->setCellValue('F7','Sumber Pengadaan')->setCellValue('G7','Nama Sarana')->setCellValue('H7','Alamat Sarana')->setCellValue('I7','Telepon')->setCellValue('J7','Cara Pembelian')->setCellValue('K7','Repacking')->setCellValue('L7','Photo')->setCellValue('M7','BBPOM / BPOM');
			$this->newphpexcel->headings(array('A7','B7','C7','D7','E7','F7','G7','H7','I7','J7','K7','L7','M7'));
			$this->newphpexcel->set_wrap(array('B','C','D','E','F','G','H','I','J','K','L','M'));
			$this->newphpexcel->set_number(array('E'));
			$data = $sipt->main->get_result($query);
			$no=1;
			$rec = 8;
			if($data){
				foreach($query->result_array() as $row){
					
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A'.$rec,$no)
					->setCellValue('B'.$rec,$row["NAMA_BB"])
					->setCellValue('C'.$rec,$row["NAMA_PRODUK"])
					->setCellValue('D'.$rec,$row["KEMASAN"])
					->setCellValue('E'.$rec,$row["KLASIFIKASI_PRODUK"])
					->setCellValue('F'.$rec,$row["SUMBER_PENGADAAN"])
					->setCellValue('G'.$rec,$row["NAMA_PERUSAHAAN"])
					->setCellValue('H'.$rec,$row["ALAMAT_PERUSAHAAN"])
					->setCellValue('I'.$rec,$row["TELEPON"])
					->setCellValue('J'.$rec,$row["CARA_PEMBELIAN"])
					->setCellValue('K'.$rec,($row["STATUS_REPACKING"] == "0" ? "Kemasan Original" : "Hasil Repacking"))
					->setCellValue('L'.$rec,(trim($row["LAMPIRAN"]) == 0 ? 'Tidak Ada Lampiran': base_url().'files/'.$row['SARANA_ID'].'/'.$row["LAMPIRAN"]))
					->setCellValue('M'.$rec,$row["NAMA_BBPOM"]);
					$this->newphpexcel->set_detilstyle(array('A'.$rec,'B'.$rec,'C'.$rec,'D'.$rec,'E'.$rec,'F'.$rec,'G'.$rec,'H'.$rec,'I'.$rec,'J'.$rec,'K'.$rec,'L'.$rec,'M'.$rec));
					$this->newphpexcel->setActiveSheetIndex(0)->getCell("L".$rec)->getHyperlink()->setUrl((trim($row["LAMPIRAN"]) == 0 ? 'Tidak Ada Lampiran': base_url().'files/'.$row['SARANA_ID'].'/'.$row["LAMPIRAN"]));
					$rec++;
					$no++;
				}
			}else{
				$this->newphpexcel->getActiveSheet()->mergeCells('A8:M8');
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A8','Data Tidak Ditemukan');
				$this->newphpexcel->set_detilstyle(array('A8'));
			}
			ob_clean();
			$file = "TEMUAN_PRODUK_".str_replace(" ","_",str_replace("-","",$judul))."_".date("YmdHis").".xls";
			header("Content-type: application/x-msdownload");
			header("Content-Disposition: attachment;filename=$file");
			header("Cache-Control: max-age=0");
			header("Pragma: no-cache");
			header("Expires: 0");
			$objWriter = PHPExcel_IOFactory::createWriter($this->newphpexcel, 'Excel5'); 
			$objWriter->save('php://output');
			exit();		
		}
	}
	
}
?>