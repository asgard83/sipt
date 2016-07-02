<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);
class Detil_02PG extends Model{
	function set_excel_sarana(){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$this->load->library('newphpexcel');
			$judul = $sipt->main->get_judul($this->input->post("JENIS"));
			if($this->input->post('KK_ID') != "")
				$klas = " LEFT JOIN T_PEMERIKSAAN_KLASIFIKASI F ON D.PERIKSA_ID = F.PERIKSA_ID ";
			else
				$klas = "";
			$query = "SELECT A.NAMA_SARANA, CAST(A.ALAMAT_1+' '+C.NAMA_PROPINSI+' '+B.NAMA_PROPINSI AS VARCHAR(255)) AS ALAMAT, CONVERT(VARCHAR(10), D.AWAL_PERIKSA, 103) + ' s.d ' + CONVERT(VARCHAR(10), D.AKHIR_PERIKSA, 103) AS [TANGGAL], D.HASIL, X.HASIL_TEMUAN_LAIN, X.KESIMPULAN, X.REKOMENDASI, X.TINDAKAN, X.CAPA, STUFF(dbo.GROUP_PETUGAS(D.PERIKSA_ID),1,0,'') AS PETUGAS FROM M_SARANA A LEFT JOIN M_PROPINSI B ON A.PROPINSI = B.PROPINSI_ID LEFT JOIN M_PROPINSI C ON A.KOTA = C.PROPINSI_ID LEFT JOIN T_PEMERIKSAAN D ON A.SARANA_ID = D.SARANA_ID LEFT JOIN T_PEMERIKSAAN_PANGAN X ON D.PERIKSA_ID = X.PERIKSA_ID $klas WHERE D.JENIS_SARANA_ID ='".$this->input->post('JENIS')."'";
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
			if(trim($this->input->post('HASIL')) != "") $query .= " AND D.HASIL = '".$this->input->post('HASIL')."'";
			if($this->newsession->userdata('SESS_BBPOM_ID') != "95" && $this->newsession->userdata('SESS_BBPOM_ID') != "00"){
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
			#$query .= " AND D.STATUS LIKE '%1_'";			
			$query .= " AND D.STATUS NOT IN ('00')";
			if($this->input->post('TEMUAN') != "") $query .= " AND X.HASIL_TEMUAN_LAIN LIKE '%".$this->input->post('TEMUAN')."%' OR X.KESIMPULAN LIKE '%".$this->input->post('TEMUAN')."%' OR X.REKOMENDASI LIKE '%".$this->input->post('TEMUAN')."%'";
			if($this->input->post('TINDAKAN') != "") $query .= " AND X.TINDAKAN LIKE '%".$this->input->post('TINDAKAN')."%'";
			if($this->input->post('KK_ID') != "") $query .= " AND F.KK_ID = '".$this->input->post('KK_ID')."'";
			if(trim($this->input->post('KOTA')!="")) $query .= " AND A.KOTA  = '".$this->input->post('KOTA')."'";
			$this->newphpexcel->getDefaultStyle()->getFont()->setName('Calibri')->setSize(10);
			$this->newphpexcel->setActiveSheetIndex(0);
			$this->newphpexcel->mergecell(array(array('A1','J1'),array('A2','B2'),array('A3','B3'),array('A4','B4'),array('A5','B5')), FALSE);
			$this->newphpexcel->width(array(array('A',5),array('B',30),array('C',30),array('D',30),array('E',30),array('F',15),array('G',30),array('H',30),array('I',30),array('J',30)));
			$this->newphpexcel->set_bold(array('A1','C2','C5'));
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A1', 'LAPORAN HASIL PEMERIKSAAN SARANA DISTRIBUSI PANGAN')->setCellValue('A2', 'Jenis Sarana')->setCellValue('C2', $judul)->setCellValue('A3', 'Pemeriksaan Awal')->setCellValue('C3', $awal)->setCellValue('A4', 'Pemeriksaan Akhir')->setCellValue('C4', $akhir)->setCellValue('A5', 'Balai Besar / Balai POM')->setCellValue('C5', $balai);
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A7','No.')->setCellValue('B7','Nama Sarana')->setCellValue('C7','Alamat')->setCellValue('D7','Tanggal Periksa')->setCellValue('E7','Hasil Temuan')->setCellValue('F7','Hasil')->setCellValue('G7','Kesimpulan')->setCellValue('H7','Tindakan')->setCellValue('I7','Rekomendasi')->setCellValue('J7','CAPA');
			$this->newphpexcel->headings(array('A7','B7','C7','D7','E7','F7','G7','H7','I7','J7'));
			$this->newphpexcel->set_wrap(array('B','C','D','E','G','H','I','J'));
			$data = $sipt->main->get_result($query);
			if($data){
				$no=1;
				$rec = 8;
				foreach($query->result_array() as $row){
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A'.$rec,$no)
					->setCellValue('B'.$rec,strtoupper($row["NAMA_SARANA"]))
					->setCellValue('C'.$rec,$row["ALAMAT"])
					->setCellValue('D'.$rec,$row["TANGGAL"])
					->setCellValue('E'.$rec,preg_replace('/<[^>]*>/','',html_entity_decode($row["HASIL_TEMUAN_LAIN"])))
					->setCellValue('F'.$rec,$row["HASIL"])
					->setCellValue('G'.$rec,preg_replace('/<[^>]*>/','',html_entity_decode($row["KESIMPULAN"])))
					->setCellValue('H'.$rec,str_replace("#",";",$row["TINDAKAN"]))
					->setCellValue('I'.$rec,preg_replace('/<[^>]*>/','',html_entity_decode($row["REKOMENDASI"])))
					->setCellValue('J'.$rec,preg_replace('/<[^>]*>/','',html_entity_decode($row["CAPA"])));
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
	
	function rekap_02PG(){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$this->load->library('newphpexcel');
			$judul = strtoupper($sipt->main->get_uraian("SELECT dbo.NAMA_JENIS_SARANA('".$this->input->post('JENIS')."') AS JUDUL","JUDUL"));
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
			$query = " SELECT DISTINCT(REPLACE(REPLACE(C.NAMA_BBPOM,'BALAI BESAR POM DI ', ''),'BALAI POM DI ','')) AS NAMA_BBPOM, 
					  (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE JENIS_SARANA_ID = '02PG' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS JMLPERIKSA, (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'BAIK' AND JENIS_SARANA_ID = '02PG' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS BAIK, 
					  (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'CUKUP' AND JENIS_SARANA_ID = '02PG' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS CUKUP, 
					  (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'KURANG' AND JENIS_SARANA_ID = '02PG' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS KURANG,
					  SUM(CASE WHEN E.TINDAKAN LIKE '%Pembinaan%' THEN 1 ELSE 0 END) AS PEMBINAAN,
					  SUM(CASE WHEN E.TINDAKAN LIKE '%Surat Peringatant%' THEN 1 ELSE 0 END) AS SP,
					  SUM(CASE WHEN E.TINDAKAN LIKE '%Pengamanan%' THEN 1 ELSE 0 END) AS PENGAMANAN,
					  SUM(CASE WHEN E.TINDAKAN LIKE '%Pemusnahan Produk%' THEN 1 ELSE 0 END) AS PEMUSNAHAN,
					  SUM(CASE WHEN E.TINDAKAN LIKE '%Pengambilan Sampel%' THEN 1 ELSE 0 END) AS SAMPEL,
					  SUM(CASE WHEN E.TINDAKAN LIKE '%Pemanggilan Resmi%' THEN 1 ELSE 0 END) AS PEMANGGILAN,
					  SUM(CASE WHEN E.TINDAKAN LIKE '%Perintah Pengambilan / Retur%' THEN 1 ELSE 0 END) AS RETUR,
					  SUM(CASE WHEN E.TINDAKAN LIKE '%Projusticia%' THEN 1 ELSE 0 END) AS PROJUSTICIA
					  FROM T_PEMERIKSAAN A LEFT JOIN M_BBPOM C ON A.BBPOM_ID = C.BBPOM_ID
					  LEFT JOIN T_PEMERIKSAAN_PANGAN E ON A.PERIKSA_ID = E.PERIKSA_ID
					  WHERE A.JENIS_SARANA_ID = '02PG' $filter2  AND LEN(A.STATUS) > 2 
					  GROUP BY C.BBPOM_ID, C.NAMA_BBPOM ORDER BY 1";
			$this->newphpexcel->set_font('Calibri',10);
			$this->newphpexcel->setActiveSheetIndex(0);
			$this->newphpexcel->set_title('RHPK Sarana');
			$this->newphpexcel->mergecell(array(array('A1','N1'),array('A2','N2'),array('A3','N3'),array('A4','N4'),array('A6','A7'),array('C6','F6'),array('G6','N6')), TRUE);
			$this->newphpexcel->mergecell(array(array('B6','B7')), FALSE);
			$this->newphpexcel->width(array(array('A',4), array('B',45),array('C',8),array('D',8),array('E',8),array('F',8),array('G',10),array('H',13),array('I',13),array('J',13),array('K',13),array('L',13),array('M',13),array('N',10)));
			$this->newphpexcel->set_bold(array('A1','A2','A3','A4'));
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A1', 'REKAPITULASI HASIL PELAKSANAAN KEGIATAN - PEMERIKSAAN SARANA')->setCellValue('A2',$judul)->setCellValue('A3', strtoupper($balai))->setCellValue('A4', 'PERIODE : '.$awal.' s.d '.$akhir);
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A6','No.')->setCellValue('B6','BB / BPOM')->setCellValue('C6','Jumlah')->setCellValue('G6','Tindak Lanjut')
			->setCellValue('C7','Diperiksa')->setCellValue('D7','Baik')->setCellValue('E7','Cukup')->setCellValue('F7','Kurang')->setCellValue('G7','Pembinaan')->setCellValue('H7','Surat Peringatan')->setCellValue('I7','Pengamanan')->setCellValue('J7','Pemusnahan Produk')->setCellValue('K7','Pengambilan Sampel')->setCellValue('L7','Pemanggilan Resmi')->setCellValue('M7','Pengambilan Retur')->setCellValue('N7','Projusticia');
			$this->newphpexcel->headings(array('A6','B6','C6','D6','E6','F6','G6','H6','I6','J6','K6','L6','M6','N6','B7','C7','D7','E7','F7','G7','H7','I7','J7','K7','L7','M7','N7'));
			$this->newphpexcel->set_wrap(array('F7','G7','H7','I7','J7','K7','L7','M7','N7'));
			$data = $sipt->main->get_result($query);
			if($data){
				$no=1;
				$rec = 8;
				foreach($query->result_array() as $row){
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A'.$rec,$no)
															  ->setCellValue('B'.$rec,$row["NAMA_BBPOM"])
															  ->setCellValue('C'.$rec,$row["JMLPERIKSA"])
															  ->setCellValue('D'.$rec,$row["BAIK"])
															  ->setCellValue('E'.$rec,$row["CUKUP"])
															  ->setCellValue('F'.$rec,$row["KURANG"])
															  ->setCellValue('G'.$rec,$row["PEMBINAAN"])
															  ->setCellValue('H'.$rec,$row["SP"])
															  ->setCellValue('I'.$rec,$row["PENGAMANAN"])
															  ->setCellValue('J'.$rec,$row["PEMUSNAHAN"])
															  ->setCellValue('K'.$rec,$row["SAMPEL"])
															  ->setCellValue('L'.$rec,$row["PEMANGGILAN"])
															  ->setCellValue('M'.$rec,$row["RETUR"])
															  ->setCellValue('N'.$rec,$row["PROJUSTICIA"]);
					$this->newphpexcel->set_detilstyle(array('A'.$rec,'B'.$rec,'C'.$rec,'D'.$rec,'E'.$rec,'F'.$rec,'G'.$rec,'H'.$rec,'I'.$rec,'J'.$rec,'K'.$rec,'L'.$rec,'M'.$rec,'N'.$rec));
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
					->setCellValue('N'.$rec,'=SUM(N8:N'.$total.')');
					$this->newphpexcel->set_detilstyle(array('A'.$rec,'B'.$rec,'C'.$rec,'D'.$rec,'E'.$rec,'F'.$rec,'G'.$rec,'H'.$rec,'I'.$rec,'J'.$rec,'K'.$rec,'L'.$rec,'M'.$rec,'N'.$rec));
			}else{
				$this->newphpexcel->getActiveSheet()->mergeCells('A8:N8');
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A8','Data Tidak Ditemukan');
				$this->newphpexcel->set_detilstyle(array('A8'));
			}
			
			$qproduk = "SELECT DISTINCT(REPLACE(REPLACE(C.NAMA_BBPOM,'BALAI BESAR POM DI ', ''),'BALAI POM DI ','')) AS NAMA_BBPOM, 
					  (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE JENIS_SARANA_ID = '02PG' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS JMLPERIKSA, (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'BAIK' AND JENIS_SARANA_ID = '02PG' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS BAIK, 
					  (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'CUKUP' AND JENIS_SARANA_ID = '02PG' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS CUKUP, 
					  (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'KURANG' AND JENIS_SARANA_ID = '02PG' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS KURANG,
					  SUM(CASE WHEN D.KATEGORI LIKE '%TIE%' THEN 1 ELSE 0 END) AS PRODUKTIE,
					  SUM(CASE WHEN D.KATEGORI LIKE '%Rusak%' THEN 1 ELSE 0 END) AS PRODUKRUSAK,
					  SUM(CASE WHEN D.KATEGORI LIKE '%Expire Date%' THEN 1 ELSE 0 END) AS ED,
					  SUM(CASE WHEN D.KATEGORI LIKE '%TMK%' THEN 1 ELSE 0 END) AS TMKLABEL,
					  SUM(CASE WHEN D.KATEGORI LIKE '%Bahan%' THEN 1 ELSE 0 END) AS BB
					  FROM T_PEMERIKSAAN A LEFT JOIN M_BBPOM C ON A.BBPOM_ID = C.BBPOM_ID
					  LEFT JOIN T_PEMERIKSAAN_PANGAN E ON A.PERIKSA_ID = E.PERIKSA_ID
					  LEFT JOIN T_PEMERIKSAAN_TEMUAN_PRODUK D ON A.PERIKSA_ID = D.PERIKSA_ID
					  WHERE A.JENIS_SARANA_ID = '02PG' AND D.KK_ID = '013' $filter2  AND LEN(A.STATUS) > 2 
					  GROUP BY C.BBPOM_ID, C.NAMA_BBPOM ORDER BY 1";
			$this->newphpexcel->createSheet();
			$this->newphpexcel->setActiveSheetIndex(1);
			$this->newphpexcel->set_title('RHPK Temuan Produk');
			$this->newphpexcel->mergecell(array(array('A1','J1'),array('A2','J2'),array('A3','J3'),array('A4','J4'),array('A6','A7'),array('C6','F6'),array('G6','K6')), TRUE);
			$this->newphpexcel->mergecell(array(array('B6','B7')), FALSE);
			$this->newphpexcel->width(array(array('A',4), array('B',45),array('C',8),array('D',5),array('E',5),array('F',14),array('G',14),array('H',13),array('I',13),array('J',13),array('K',13)));
			$this->newphpexcel->set_bold(array('A1','A2','A3','A4'));
			$this->newphpexcel->setActiveSheetIndex(1)->setCellValue('A1', 'REKAPITULASI HASIL PELAKSANAAN KEGIATAN - TEMUAN PRODUK')->setCellValue('A2',$judul)->setCellValue('A3', strtoupper($balai))->setCellValue('A4', 'PERIODE : '.$awal.' s.d '.$akhir);
			$this->newphpexcel->setActiveSheetIndex(1)->setCellValue('A6','No.')->setCellValue('B6','BB / BPOM')->setCellValue('C6','Jumlah')->setCellValue('F6','Rincian Temuan Produk')
			->setCellValue('C7','Diperiksa')->setCellValue('D7','Baik')->setCellValue('E7','Cukup')->setCellValue('F7','Kurang')->setCellValue('G7','TIE')->setCellValue('H7','Rusak')->setCellValue('I7','Expire Date')->setCellValue('J7','TMK Label')->setCellValue('K7','Bahan Berbahaya');
			$this->newphpexcel->headings(array('A6','B6','C6','D6','E6','F6','G6','H6','I6','J6','K6','B7','C7','D7','E7','F7','G7','H7','I7','J7','K7'));
			$this->newphpexcel->set_wrap(array('F7','G7','H7','I7','J7','K7'));
			$dataproduk = $sipt->main->get_result($qproduk);
			if($dataproduk){
				$no=1;
				$rec = 8;
				foreach($qproduk->result_array() as $rowproduk){
					$this->newphpexcel->setActiveSheetIndex(1)->setCellValue('A'.$rec,$no)
															  ->setCellValue('B'.$rec,$rowproduk["NAMA_BBPOM"])
															  ->setCellValue('C'.$rec,$rowproduk["JMLPERIKSA"])
															  ->setCellValue('D'.$rec,$rowproduk["BAIK"])
															  ->setCellValue('E'.$rec,$rowproduk["CUKUP"])
															  ->setCellValue('F'.$rec,$rowproduk["KURANG"])
															  ->setCellValue('G'.$rec,$rowproduk["PRODUKTIE"])
															  ->setCellValue('H'.$rec,$rowproduk["PRODUKRUSAK"])
															  ->setCellValue('I'.$rec,$rowproduk["ED"])
															  ->setCellValue('J'.$rec,$rowproduk["TMKLABEL"])
															  ->setCellValue('K'.$rec,$rowproduk["BB"]);
					$this->newphpexcel->set_detilstyle(array('A'.$rec,'B'.$rec,'C'.$rec,'D'.$rec,'E'.$rec,'F'.$rec,'G'.$rec,'H'.$rec,'I'.$rec,'J'.$rec,'K'.$rec));
					$rec++;
					$no++;
				}
				$total = $rec - 1;
				$this->newphpexcel->setActiveSheetIndex(1)->setCellValue('A'.$rec,$no)
					->setCellValue('B'.$rec,'Jumlah')
					->setCellValue('C'.$rec,'=SUM(C8:C'.$total.')')
					->setCellValue('D'.$rec,'=SUM(D8:D'.$total.')')
					->setCellValue('E'.$rec,'=SUM(E8:E'.$total.')')
					->setCellValue('F'.$rec,'=SUM(F8:F'.$total.')')
					->setCellValue('G'.$rec,'=SUM(G8:G'.$total.')')
					->setCellValue('H'.$rec,'=SUM(H8:H'.$total.')')
					->setCellValue('I'.$rec,'=SUM(I8:I'.$total.')')
					->setCellValue('J'.$rec,'=SUM(J8:J'.$total.')')
					->setCellValue('K'.$rec,'=SUM(K8:K'.$total.')');
					$this->newphpexcel->set_detilstyle(array('A'.$rec,'B'.$rec,'C'.$rec,'D'.$rec,'E'.$rec,'F'.$rec,'G'.$rec,'H'.$rec,'I'.$rec,'J'.$rec,'K'.$rec));
			}else{
				$this->newphpexcel->getActiveSheet()->mergeCells('A8:K8');
				$this->newphpexcel->setActiveSheetIndex(1)->setCellValue('A8','Data Tidak Ditemukan');
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