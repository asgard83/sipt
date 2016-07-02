<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);
class Distribusi_act extends Model{
	function set_excel_sarana(){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$this->load->library('newphpexcel');
			$judul = $sipt->main->get_judul($this->input->post("JENIS"));
			if($this->input->post('KK_ID') != "")
				$klas = " LEFT JOIN T_PEMERIKSAAN_KLASIFIKASI F ON E.PERIKSA_ID = F.PERIKSA_ID ";
			else
				$klas = "";

			$query = "SELECT LTRIM(RTRIM(UPPER(REPLACE(A.NAMA_SARANA,'-','')))) AS NAMA_SARANA, CAST(A.ALAMAT_1+' '+C.NAMA_PROPINSI+' '+B.NAMA_PROPINSI AS VARCHAR(255)) AS ALAMAT, CONVERT(VARCHAR(10), D.AWAL_PERIKSA, 103) + ' s.d ' + CONVERT(VARCHAR(10), D.AKHIR_PERIKSA, 103) AS [TANGGAL], E.TUJUAN_PEMERIKSAAN, E.HASIL_TEMUAN, D.HASIL, D.HASIL_PUSAT, E.KLASIFIKASI_PELANGGARAN_MAJOR AS MAJOR, E.KLASIFIKASI_PELANGGARAN_MINOR AS MINOR, E.KLASIFIKASI_PELANGGARAN_CRITICAL AS KRITIKAL, E.KLASIFIKASI_PELANGGARAN_CRITICAL_ABSOLUTE AS CA, E.KASUS_POINT_A, E.KASUS_POINT_B, E.KASUS_POINT_D, E.KASUS_POINT_E, E.KASUS_POINT_F, E.KASUS_POINT_G, E.KASUS_POINT_H, E.TINDAK_LANJUT_BALAI, E.DETAIL_TINDAK_LANJUT_BALAI, E.TINDAK_LANJUT_PUSAT, E.DETIL_TINDAK_LANJUT_PUSAT, STUFF(dbo.GROUP_PETUGAS(E.PERIKSA_ID),1,0,'') AS PETUGAS, G.NAMA_BBPOM FROM M_SARANA A LEFT JOIN M_PROPINSI B ON A.PROPINSI = B.PROPINSI_ID LEFT JOIN M_PROPINSI C ON A.KOTA = C.PROPINSI_ID LEFT JOIN T_PEMERIKSAAN D ON A.SARANA_ID = D.SARANA_ID LEFT JOIN T_PEMERIKSAAN_DISTRIBUSI E ON D.PERIKSA_ID = E.PERIKSA_ID LEFT JOIN M_BBPOM G ON D.BBPOM_ID = G.BBPOM_ID $klas WHERE D.JENIS_SARANA_ID ='".$this->input->post('JENIS')."'";			
			if(trim($this->input->post('HASIL'))==""){
				$query .= "";
			}else{
				$query .= " AND D.HASIL = '".$this->input->post('HASIL')."'";
			}
			if(trim($this->input->post('AWAL')!="")){
				$query .= " AND DATEDIFF(dy, 0, convert(DATETIME, D.AWAL_PERIKSA, 105)) >= DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('AWAL')."', 105))";
				$awal = $this->input->post('AWAL');
			}else{
				$query .= " AND D.AWAL_PERIKSA > DATEADD(M, DATEDIFF(M,0,GETDATE()),0)";
				$awal = date('01/m/Y');
			}
			if(trim($this->input->post('AKHIR')!="")){
				$query .= " AND DATEDIFF(dy, 0, convert(DATETIME, D.AWAL_PERIKSA, 105)) <= DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('AKHIR')."', 105))";
				$akhir = $this->input->post('AKHIR');
			}else{
				$query .= " AND D.AWAL_PERIKSA < DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,0,GETDATE())+1,0))";
				$akhir = date('t/m/Y');
			}
			if(trim($this->input->post('KOTA')!="")) $query .= " AND A.KOTA  = '".$this->input->post('KOTA')."'";
			if($this->newsession->userdata('SESS_BBPOM_ID') != "92" && $this->newsession->userdata('SESS_BBPOM_ID') != "00"){
				$query .= " AND D.BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'";
				$balai = $sipt->main->get_uraian("SELECT NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","NAMA_BBPOM");
			}else{
				if(trim($this->input->post('BBPOM_ID')) == ""){
					$query .= "";
					$balai = "Seluruh Balai";
				}else{
					$query .= " AND D.BBPOM_ID = '".$this->input->post('BBPOM_ID')."'";
					$balai = $sipt->main->get_uraian("SELECT NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID = '".$this->input->post('BBPOM_ID')."'","NAMA_BBPOM");
				}
			}
			$query .= " AND D.STATUS NOT IN ('00')";
			if($this->newsession->userdata('SESS_BBPOM_ID') == "00"){		
				$query .= " AND D.STATUS LIKE '%1_'";			
			}
			if($this->input->post('TEMUAN') != ""){
				$query .= " AND E.HASIL_TEMUAN LIKE '%".$this->input->post('TEMUAN')."%' OR E.HASIL_TEMUAN_LAIN LIKE '%".$this->input->post('TEMUAN')."%'";
			}else{
				$query .= "";
			}

			if($this->input->post('TINDAKAN') != ""){
				$query .= " AND E.TINDAK_LANJUT_BALAI LIKE '%".$this->input->post('TINDAKAN')."%' OR E.TINDAK_LANJUT_PUSAT LIKE '%".$this->input->post('TINDAKAN')."%'";
			}else{
				$query .= "";
			}

			if($this->input->post('KK_ID') != ""){
				$query .= " AND F.KK_ID = '".$this->input->post('KK_ID')."'";
			}else{
				$query .= "";
			}
			$query .= " ORDER BY 1 ASC";
			$this->newphpexcel->getDefaultStyle()->getFont()->setName('Calibri')->setSize(10);
			$this->newphpexcel->setActiveSheetIndex(0);
			$this->newphpexcel->mergecell(array(array('A1','O1'),array('A2','B2'),array('A3','B3'),array('A4','B4'),array('A5','B5')), FALSE);
			$this->newphpexcel->width(array(array('A',5),array('B',30),array('C',30),array('D',25),array('E',20),array('F',60),array('G',5),array('H',5),array('I',5),array('J',5),array('K',20),array('L',30),array('M',5),array('M',30),array('N',30),array('O',30)));
			$this->newphpexcel->set_bold(array('A1','C2','C5'));
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A1', 'LAPORAN HASIL PEMERIKSAAN SARANA DISTRIBUSI OBAT PT DAN PKRT')->setCellValue('A2', 'Jenis Sarana')->setCellValue('C2', $judul)->setCellValue('A3', 'Pemeriksaan Awal')->setCellValue('C3', $awal)->setCellValue('A4', 'Pemeriksaan Akhir')->setCellValue('C4', $akhir)->setCellValue('A5', 'Balai Besar / Balai POM')->setCellValue('C5', $balai);
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A7','No.')->setCellValue('B7','Nama Sarana')->setCellValue('C7','Alamat')->setCellValue('D7','Tanggal Periksa')->setCellValue('E7','Tujuan Periksa')->setCellValue('F7','Hasil Temuan')->setCellValue('G7','M')->setCellValue('H7','m')->setCellValue('I7','C')->setCellValue('J7','CA')->setCellValue('K7','Hasil Balai')->setCellValue('L7','Tindak Lanjut Balai')->setCellValue('M7','Hasil Pusat')->setCellValue('N7','Tindak Lanjut Pusat')->setCellValue('O7','Unit / Balai Pemeriksa');
			$this->newphpexcel->headings(array('A7','B7','C7','D7','E7','F7','G7','H7','I7','J7','K7','L7','M7','N7','O7'));
			$this->newphpexcel->set_wrap(array('B','F','C'));
			$data = $sipt->main->get_result($query);
			$no=1;
			$rec = 8;
			if($data){
				foreach($query->result_array() as $row){
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A'.$rec,$no)
					->setCellValue('B'.$rec,strtoupper($row["NAMA_SARANA"]))
					->setCellValue('C'.$rec,$row["ALAMAT"])
					->setCellValue('D'.$rec,$row["TANGGAL"])
					->setCellValue('E'.$rec,$row["TUJUAN_PEMERIKSAAN"])
					->setCellValue('F'.$rec,str_replace("___","; ",$row["HASIL_TEMUAN"]))
					->setCellValue('G'.$rec,$row["MAJOR"])
					->setCellValue('H'.$rec,$row["MINOR"])
					->setCellValue('I'.$rec,$row["KRITIKAL"])
					->setCellValue('J'.$rec,$row["CA"])
					->setCellValue('K'.$rec,$row["HASIL"])
					->setCellValue('L'.$rec,str_replace("#","; ",$row["TINDAK_LANJUT_BALAI"]))
					->setCellValue('M'.$rec,$row["HASIL_PUSAT"])
					->setCellValue('N'.$rec,str_replace("#","; ",$row["TINDAK_LANJUT_PUSAT"]))
					->setCellValue('O'.$rec,$row["NAMA_BBPOM"]);
					$this->newphpexcel->set_detilstyle(array('A'.$rec,'B'.$rec,'C'.$rec,'D'.$rec,'E'.$rec,'F'.$rec,'G'.$rec,'H'.$rec,'I'.$rec,'J'.$rec,'K'.$rec,'L'.$rec,'M'.$rec,'N'.$rec,'O'.$rec));
					$rec++;
					$no++;
				}
			}else{
				$this->newphpexcel->getActiveSheet()->mergeCells('A8:O8');
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A8','Data Tidak Ditemukan');
				$this->newphpexcel->set_detilstyle(array('A8'));
			}
			ob_clean();
			$file = "PEMERIKSAAN_SARANA_".str_replace(" ","_",str_replace("-","",$judul))."_".date("YmdHis").".xls";
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
	
	function rekap_distribusi(){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$this->load->library('newphpexcel');
			$filter1 = "";
			$filter2 = "";
			if(trim($this->input->post('AWAL')!="")){
				$filter1 .= " AND DATEDIFF(dy, 0, convert(DATETIME, AWAL_PERIKSA, 105)) >= DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('AWAL')."', 105))";
				$filter2 .= " AND DATEDIFF(dy, 0, convert(DATETIME, A.AWAL_PERIKSA, 105)) >= DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('AWAL')."', 105))";
				$fawal = "DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('AWAL')."', 105))";
				$awal = $this->input->post('AWAL');
			}else{
				$filter1 .= " AND AWAL_PERIKSA > GETDATE()";
				$filter2 .= " AND A.AWAL_PERIKSA > GETDATE()";
				$fawal = "DATEADD(M, DATEDIFF(M,0,GETDATE()),0)";
				$awal = date('01/m/Y');
			}
			if(trim($this->input->post('AKHIR')!="")){
				$filter1 .= " AND DATEDIFF(dy, 0, convert(DATETIME, AWAL_PERIKSA, 105)) <= DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('AKHIR')."', 105))";
				$filter2 .= " AND DATEDIFF(dy, 0, convert(DATETIME, A.AWAL_PERIKSA, 105)) <= DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('AKHIR')."', 105))";
				$fakhir = "DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('AKHIR')."', 105))";
				$akhir = $this->input->post('AKHIR');
			}else{
				$filter1 .= " AND AKHIR_PERIKSA < GETDATE()";
				$filter2 .= " AND A.AKHIR_PERIKSA < GETDATE()";
				$fakhir =  "DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,0,GETDATE())+1,0))";
				$akhir = date('t/m/Y');
			}
			if(in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')) || $this->newsession->userdata('SESS_BBPOM_ID') == "00"){
				if(trim($this->input->post('BBPOM_ID'))==""){
					$filter2 .= "";
					$balai = 'Seluruh Balai';
				}else{
					$filter2 .= " AND A.BBPOM_ID = '".$this->input->post('BBPOM_ID')."'";
					$balai = $sipt->main->get_uraian("SELECT NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID = '".$this->input->post('BBPOM_ID')."'","NAMA_BBPOM");		
				}
			}else{
				$filter2 .= " AND A.BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'";
				$balai = $sipt->main->get_uraian("SELECT NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","NAMA_BBPOM");		
			}
			$query = "SELECT (REPLACE(REPLACE(C.NAMA_BBPOM,'BALAI BESAR POM DI ', ''),'BALAI POM DI ','')) AS NAMA_BBPOM,
			(SELECT COUNT(JENIS_SARANA_ID) FROM T_PEMERIKSAAN WHERE JENIS_SARANA_ID = '".$this->input->post('JENIS')."' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS JMLPERIKSA,
			(SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'MK' AND JENIS_SARANA_ID = '".$this->input->post('JENIS')."' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS MK,
			(SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'TMK' AND JENIS_SARANA_ID = '".$this->input->post('JENIS')."' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS TMK, 
			(SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'TTP' AND JENIS_SARANA_ID = '".$this->input->post('JENIS')."' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS TUTUP, 
			(SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'TDP' AND JENIS_SARANA_ID = '".$this->input->post('JENIS')."' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS TDP,
			SUM(CASE WHEN D.TINDAK_LANJUT_BALAI LIKE '%Pembinaan%' THEN 1 ELSE 0 END) AS BALAIPB,
			SUM(CASE WHEN D.TINDAK_LANJUT_BALAI = 'Peringatan' OR D.TINDAK_LANJUT_BALAI LIKE '%Peringatan#%' THEN 1 ELSE 0 END) AS BALAIPR,
			SUM(CASE WHEN D.TINDAK_LANJUT_BALAI LIKE '%Peringatan Keras%' THEN 1 ELSE 0 END) AS BALAIPK,
			SUM(CASE WHEN D.TINDAK_LANJUT_BALAI LIKE '%Sementara%' THEN 1 ELSE 0 END) AS BALAIPSK,
			SUM(CASE WHEN D.TINDAK_LANJUT_BALAI LIKE '%Izin%' THEN 1 ELSE 0 END) AS BALAIPIZ,
			SUM(CASE WHEN D.TINDAK_LANJUT_BALAI LIKE '%Penghentian%' THEN 1 ELSE 0 END) AS BALAIPKE,
			SUM(CASE WHEN D.TINDAK_LANJUT_PUSAT LIKE '%Pembinaan%' THEN 1 ELSE 0 END) AS PB,
			SUM(CASE WHEN D.TINDAK_LANJUT_PUSAT = 'Peringatan' OR D.TINDAK_LANJUT_PUSAT LIKE '%Peringatan#%' THEN 1 ELSE 0 END) AS PR,
			SUM(CASE WHEN D.TINDAK_LANJUT_PUSAT LIKE '%Peringatan Keras%' THEN 1 ELSE 0 END) AS PK,
			SUM(CASE WHEN D.TINDAK_LANJUT_PUSAT LIKE '%Sementara%' THEN 1 ELSE 0 END) AS PSK,
			SUM(CASE WHEN D.TINDAK_LANJUT_PUSAT LIKE '%Izin%' THEN 1 ELSE 0 END) AS PIZ,
			SUM(CASE WHEN D.TINDAK_LANJUT_PUSAT LIKE '%Penghentian%' THEN 1 ELSE 0 END) AS PKE,
			SUM(CASE WHEN (D.TINDAK_LANJUT_BALAI LIKE '%Pembinaan%' AND D.TINDAK_LANJUT_PUSAT IS NULL) OR (D.TINDAK_LANJUT_PUSAT LIKE '%Pembinaan%' AND D.TINDAK_LANJUT_PUSAT IS NOT NULL) THEN 1 ELSE 0 END) AS SUMMARYPB, 
			SUM(CASE WHEN ((D.TINDAK_LANJUT_BALAI = 'Peringatan' OR D.TINDAK_LANJUT_BALAI LIKE '%Peringatan#%') AND D.TINDAK_LANJUT_PUSAT IS NULL) OR ((D.TINDAK_LANJUT_PUSAT = 'Peringatan' OR D.TINDAK_LANJUT_PUSAT LIKE '%Peringatan#%') AND D.TINDAK_LANJUT_PUSAT IS NOT NULL) THEN 1 ELSE 0 END) AS SUMMARYPR, 
			SUM(CASE WHEN (D.TINDAK_LANJUT_BALAI LIKE '%Peringatan Keras%' AND D.TINDAK_LANJUT_PUSAT IS NULL) OR (D.TINDAK_LANJUT_PUSAT LIKE '%peringatan Keras%' AND D.TINDAK_LANJUT_PUSAT IS NOT NULL) THEN 1 ELSE 0 END) AS SUMMARYPK, 
			SUM(CASE WHEN (D.TINDAK_LANJUT_BALAI LIKE '%Sementara%' AND D.TINDAK_LANJUT_PUSAT IS NULL) OR (D.TINDAK_LANJUT_PUSAT LIKE '%Sementara%' AND D.TINDAK_LANJUT_PUSAT IS NOT NULL) THEN 1 ELSE 0 END) AS SUMMARYPSK, 
			SUM(CASE WHEN (D.TINDAK_LANJUT_BALAI LIKE '%Izin%' AND D.TINDAK_LANJUT_PUSAT IS NULL) OR (D.TINDAK_LANJUT_PUSAT LIKE '%Izin%' AND D.TINDAK_LANJUT_PUSAT IS NOT NULL) THEN 1 ELSE 0 END) AS SUMMARYPIZ, 
			SUM(CASE WHEN (D.TINDAK_LANJUT_BALAI LIKE '%Penghentian%' AND D.TINDAK_LANJUT_PUSAT IS NULL) OR (D.TINDAK_LANJUT_PUSAT LIKE '%Penghentian%' AND D.TINDAK_LANJUT_PUSAT IS NOT NULL) THEN 1 ELSE 0 END) AS SUMMARYPKE
			FROM T_PEMERIKSAAN A LEFT JOIN T_PEMERIKSAAN_DISTRIBUSI D ON A.PERIKSA_ID = D.PERIKSA_ID 
			LEFT JOIN M_BBPOM C ON A.BBPOM_ID = C.BBPOM_ID
			WHERE A.JENIS_SARANA_ID = '".$this->input->post('JENIS')."' $filter2 AND LEN(A.STATUS) > 2 GROUP BY C.BBPOM_ID, C.NAMA_BBPOM ORDER BY 1";
			$judul = strtoupper($sipt->main->get_uraian("SELECT dbo.NAMA_JENIS_SARANA('".$this->input->post('JENIS')."') AS JUDUL","JUDUL"));
			$this->newphpexcel->set_font('Calibri',10);
			$this->newphpexcel->setActiveSheetIndex(0);
			$this->newphpexcel->mergecell(array(array('A1','S1'),array('A2','S2'),array('A3','S3'),array('A4','S4'),array('A6','A7'),array('B6','B7'),array('C6','G6'),array('H6','M6'),array('N6','S6'),array('T6','Y6')), TRUE);
			$this->newphpexcel->width(array(array('A',4), array('B',45)));
			$this->newphpexcel->set_bold(array('A1','A2','A3','A4'));
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A1', 'REKAPITULASI HASIL PEMERIKSAAN SARANA')->setCellValue('A2',$judul)->setCellValue('A3', strtoupper($balai))->setCellValue('A4', 'PERIODE : '.$awal.' s.d '.$akhir);
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A6','No.')->setCellValue('B6','BB / BPOM')->setCellValue('C6','Jumlah')->setCellValue('H6','Tindak Lanjut Balai Terhadap Sarana')->setCellValue('N6','Tindak Lanjut Pusat Terhadap Sarana')->setCellValue('T6','Kesimpulan Tindak Lanjut Terhadap Sarana')->setCellValue('C7','Diperiksa')->setCellValue('D7','MK')->setCellValue('E7','TMK')->setCellValue('F7','Tutup')->setCellValue('G7','TDP')->setCellValue('H7','Pb')->setCellValue('I7','P')->setCellValue('J7','PK')->setCellValue('K7','PSK')->setCellValue('L7','Pi')->setCellValue('M7','PKe')->setCellValue('N7','Pb')->setCellValue('O7','P')->setCellValue('P7','PK')->setCellValue('Q7','PSK')->setCellValue('R7','Pi')->setCellValue('S7','PKe')->setCellValue('T7','Pb')->setCellValue('U7','P')->setCellValue('V7','PK')->setCellValue('W7','PSK')->setCellValue('X7','Pi')->setCellValue('Y7','PKe');
			$this->newphpexcel->headings(array('A6','B6','C6','D6','E6','F6','G6','H6','I6','J6','K6','L6','M6','N6','O6','P6','Q6','R6','S6','T6','U6','V6','W6','X6','Y6','B7','C7','D7','E7','F7','G7','H7','I7','J7','K7','L7','M7','N7','O7','P7','Q7','R7','S7','T7','U7','V7','W7','X7','Y7'));
			$data = $sipt->main->get_result($query);
			if($data){
				$no=1;
				$rec = 8;
				foreach($query->result_array() as $row){
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A'.$rec,$no)
															  ->setCellValue('B'.$rec,$row["NAMA_BBPOM"])
															  ->setCellValue('C'.$rec,$row["JMLPERIKSA"])
															  ->setCellValue('D'.$rec,$row["MK"])
															  ->setCellValue('E'.$rec,$row["TMK"])
															  ->setCellValue('F'.$rec,$row["TUTUP"])
															  ->setCellValue('G'.$rec,$row["TDP"])
															  ->setCellValue('H'.$rec,$row["BALAIPB"])
															  ->setCellValue('I'.$rec,$row["BALAIPR"])
															  ->setCellValue('J'.$rec,$row["BALAIPK"])
															  ->setCellValue('K'.$rec,$row["BALAIPSK"])
															  ->setCellValue('L'.$rec,$row["BALAIPIZ"])
															  ->setCellValue('M'.$rec,$row["BALAIPKE"])
															  ->setCellValue('N'.$rec,$row["PB"])
															  ->setCellValue('O'.$rec,$row["PR"])
															  ->setCellValue('P'.$rec,$row["PK"])
															  ->setCellValue('Q'.$rec,$row["PSK"])
															  ->setCellValue('R'.$rec,$row["PIZ"])
															  ->setCellValue('S'.$rec,$row["PKE"])
															  ->setCellValue('T'.$rec,$row["SUMMARYPB"])
															  ->setCellValue('U'.$rec,$row["SUMMARYPR"])
															  ->setCellValue('V'.$rec,$row["SUMMARYPK"])
															  ->setCellValue('W'.$rec,$row["SUMMARYPSK"])
															  ->setCellValue('X'.$rec,$row["SUMMARYPIZ"])
															  ->setCellValue('Y'.$rec,$row["SUMMARYPKE"]);
					$this->newphpexcel->set_detilstyle(array('A'.$rec,'B'.$rec,'C'.$rec,'D'.$rec,'E'.$rec,'F'.$rec,'G'.$rec,'H'.$rec,'I'.$rec,'J'.$rec,'K'.$rec,'L'.$rec,'M'.$rec,'N'.$rec,'O'.$rec,'P'.$rec,'Q'.$rec,'R'.$rec,'S'.$rec, 'T'.$rec, 'U'.$rec, 'V'.$rec, 'W'.$rec, 'X'.$rec, 'Y'.$rec));
					$rec++;
					$no++;
				}
				$total = $rec - 1;
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A'.$rec,$no)
					->setCellValue('B'.$rec,'Jumlah')
					->setCellValue('C'.$rec,'=SUM(C8:C'.$total.')')
					->setCellValue('D'.$rec,'=SUM(D8:D'.$total.')')
					->setCellValue('E'.$rec,'=SUM(E8:E'.$total.')')
					->setCellValue('F'.$rec,'=SUM(F8:F'.$total.')')
					->setCellValue('G'.$rec,'=SUM(G8:G'.$total.')')
					->setCellValue('H'.$rec,'=SUM(H8:H'.$total.')')
					->setCellValue('I'.$rec,'=SUM(I8:I'.$total.')')
					->setCellValue('J'.$rec,'=SUM(J8:J'.$total.')')
					->setCellValue('K'.$rec,'=SUM(K8:K'.$total.')')
					->setCellValue('L'.$rec,'=SUM(L8:L'.$total.')')
					->setCellValue('M'.$rec,'=SUM(M8:M'.$total.')')
					->setCellValue('N'.$rec,'=SUM(N8:N'.$total.')')
					->setCellValue('O'.$rec,'=SUM(O8:O'.$total.')')
					->setCellValue('P'.$rec,'=SUM(P8:P'.$total.')')
					->setCellValue('Q'.$rec,'=SUM(Q8:Q'.$total.')')
					->setCellValue('R'.$rec,'=SUM(R8:R'.$total.')')
					->setCellValue('S'.$rec,'=SUM(S8:S'.$total.')')
					->setCellValue('T'.$rec,'=SUM(T8:T'.$total.')')
					->setCellValue('U'.$rec,'=SUM(U8:U'.$total.')')
					->setCellValue('V'.$rec,'=SUM(V8:V'.$total.')')
					->setCellValue('W'.$rec,'=SUM(W8:W'.$total.')')
					->setCellValue('X'.$rec,'=SUM(X8:X'.$total.')')
					->setCellValue('Y'.$rec,'=SUM(Y8:Y'.$total.')');
					$this->newphpexcel->set_detilstyle(array('A'.$rec,'B'.$rec,'C'.$rec,'D'.$rec,'E'.$rec,'F'.$rec,'G'.$rec,'H'.$rec,'I'.$rec,'J'.$rec,'K'.$rec,'L'.$rec,'M'.$rec,'N'.$rec,'O'.$rec,'P'.$rec,'Q'.$rec,'R'.$rec,'S'.$rec,'T'.$rec,'U'.$rec,'V'.$rec,'W'.$rec,'X'.$rec,'Y'.$rec));
			}else{
				$this->newphpexcel->getActiveSheet()->mergeCells('A8:S8');
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A8','Data Tidak Ditemukan');
				$this->newphpexcel->set_detilstyle(array('A8'));
			}
			ob_clean();
			$file = "REKAPITULASI_PEMERIKSAAN_SARANA_".str_replace(" ","_",str_replace("-","",$judul))."_".date("YmdHis").".xls";
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