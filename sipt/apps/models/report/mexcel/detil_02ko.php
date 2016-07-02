<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);
class Detil_02KO extends Model{
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
			$query = "SELECT A.NAMA_SARANA, CAST(A.ALAMAT_1+' '+C.NAMA_PROPINSI+' '+B.NAMA_PROPINSI AS VARCHAR(255)) AS ALAMAT, A.NAMA_PIMPINAN,A.PENANGGUNG_JAWAB, CONVERT(VARCHAR(10), D.AWAL_PERIKSA, 103) + ' s.d ' + CONVERT(VARCHAR(10), D.AKHIR_PERIKSA, 103) AS [TANGGAL], E.TUJUAN_PEMERIKSAAN, E.KLASIFIKASI_PEMERIKSAAN, E.HASIL_TEMUAN_LAIN, E.PEMANTAUAN_HASIL, D.HASIL, D.HASIL_PUSAT, E.DETIL_HASIL, E.KESIMPULAN_DETIL_TMK, E.TINDAKAN_SARANA, E.CATATAN, STUFF(dbo.GROUP_PETUGAS(E.PERIKSA_ID),1,0,'') AS PETUGAS FROM M_SARANA A LEFT JOIN M_PROPINSI B ON A.PROPINSI = B.PROPINSI_ID LEFT JOIN M_PROPINSI C ON A.KOTA = C.PROPINSI_ID LEFT JOIN T_PEMERIKSAAN D ON A.SARANA_ID = D.SARANA_ID LEFT JOIN T_PEMERIKSAAN_KOSMETIK E ON D.PERIKSA_ID = E.PERIKSA_ID $klas WHERE D.JENIS_SARANA_ID ='".$this->input->post('JENIS')."'";
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
			if($this->newsession->userdata('SESS_BBPOM_ID') != "94" && $this->newsession->userdata('SESS_BBPOM_ID') != "00"){
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
			if($this->newsession->userdata('SESS_BBPOM_ID') == "00"){		
				$query .= " AND D.STATUS LIKE '%1_'";			
			}
			if($this->input->post('TEMUAN') != "") $query .= " AND E.HASIL_TEMUAN_LAIN LIKE  '%".$this->input->post('TEMUAN')."%'";
			if($this->input->post('TINDAKAN') != "") $query .= " AND E.TINDAKAN_SARANA LIKE '%".$this->input->post('TINDAKAN')."%'";
			if($this->input->post('KK_ID') != "") $query .= " AND F.KK_ID = '".$this->input->post('KK_ID')."'";
			if(trim($this->input->post('KOTA')!="")) $query .= " AND A.KOTA  = '".$this->input->post('KOTA')."'";
			
			$this->newphpexcel->getDefaultStyle()->getFont()->setName('Calibri')->setSize(10);
			$this->newphpexcel->setActiveSheetIndex(0);
			$this->newphpexcel->mergecell(array(array('A1','O1'),array('A2','B2'),array('A3','B3'),array('A4','B4'),array('A5','B5')), FALSE);
			$this->newphpexcel->width(array(array('A',5),array('B',30),array('C',30),array('D',20),array('E',20),array('F',25),array('G',20),array('H',30),array('I',30),array('J',30),array('K',30), array('L',30),array('M',30),array('N',30),array('O',30)));
			$this->newphpexcel->set_bold(array('A1','C2','C5'));
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A1', 'LAPORAN HASIL PEMERIKSAAN SARANA DISTRIBUSI KOSMETIKA')->setCellValue('A2', 'Jenis Sarana')->setCellValue('C2', $judul)->setCellValue('A3', 'Pemeriksaan Awal')->setCellValue('C3', $awal)->setCellValue('A4', 'Pemeriksaan Akhir')->setCellValue('C4', $akhir)->setCellValue('A5', 'Balai Besar / Balai POM')->setCellValue('C5', $balai);
			
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A7','No.')->setCellValue('B7','Nama Sarana')->setCellValue('C7','Alamat')->setCellValue('D7','Pimpinan')->setCellValue('E7','Penanggung Jawab')->setCellValue('F7','Tanggal Periksa')->setCellValue('G7','Tujuan Pemeriksaan')->setCellValue('H7','Klasifikasi')->setCellValue('I7','Temuan')->setCellValue('J7','Hasil')->setCellValue('K7','Hasil Pusat')->setCellValue('L7','Detil TMK')->setCellValue('M7','Kesimpulan TMK')->setCellValue('N7','Tindakan')->setCellValue('O7','Catatan');
			
			$this->newphpexcel->headings(array('A7','B7','C7','D7','E7','F7','G7','H7','I7','J7','K7','L7','M7','N7','O7'));
			$this->newphpexcel->set_wrap(array('B','C','D','E','H','I','J','K','L','M','N','O'));
			
			$data = $sipt->main->get_result($query);
			if($data){
				$no=1;
				$rec = 8;
				foreach($query->result_array() as $row){
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A'.$rec,$no)
					->setCellValue('B'.$rec,strtoupper($row["NAMA_SARANA"]))
					->setCellValue('C'.$rec,$row["ALAMAT"])
					->setCellValue('D'.$rec,$row["NAMA_PIMPINAN"])
					->setCellValue('E'.$rec,$row["PENANGGUNG_JAWAB"])
					->setCellValue('F'.$rec,$row["TANGGAL"])
					->setCellValue('G'.$rec,$row["TUJUAN_PEMERIKSAAN"])
					->setCellValue('H'.$rec,$row["KLASIFIKASI_PEMERIKSAAN"])
					->setCellValue('I'.$rec,preg_replace('/<[^>]*>/','',html_entity_decode($row["HASIL_TEMUAN_LAIN"])))
					->setCellValue('J'.$rec,$row["HASIL"])
					->setCellValue('K'.$rec,$row["HASIL_PUSAT"])
					->setCellValue('L'.$rec,str_replace("#",";",$row["DETIL_HASIL"]))
					->setCellValue('M'.$rec,preg_replace('/<[^>]*>/','',html_entity_decode($row["KESIMPULAN_DETIL_TMK"])))
					->setCellValue('N'.$rec,str_replace("#",";",html_entity_decode($row["TINDAKAN_SARANA"])))
					->setCellValue('O'.$rec,preg_replace('/<[^>]*>/','',html_entity_decode($row["CATATAN"])));
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
	
	function rekap_02KO(){
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
			$qsarana = "SELECT DISTINCT(REPLACE(REPLACE(C.NAMA_BBPOM,'BALAI BESAR POM DI ', ''),'BALAI POM DI ','')) AS NAMA_BBPOM,
			(SELECT COUNT(JENIS_SARANA_ID) FROM T_PEMERIKSAAN WHERE JENIS_SARANA_ID = '02KO' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS JMLPERIKSA,
			(SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'MK' AND JENIS_SARANA_ID = '02KO' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS MK,
			(SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'TMK' AND JENIS_SARANA_ID = '02KO' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS TMK, 
			(SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'TTP' AND JENIS_SARANA_ID = '02KO' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS TTP, 
			SUM(CASE WHEN E.DETIL_HASIL LIKE '%TIE%' THEN 1 ELSE 0 END) AS MENGEDARKANTIE,
			SUM(CASE WHEN E.DETIL_HASIL LIKE '%Dilarang%' THEN 1 ELSE 0 END) AS MENGEDARKANBB,
			SUM(CASE WHEN E.DETIL_HASIL LIKE '%Penandaan%' THEN 1 ELSE 0 END) AS TMKPENANDAAN,
			SUM(CASE WHEN E.DETIL_HASIL LIKE '%Administrasi%' THEN 1 ELSE 0 END) AS ADMINISTRASI,
			SUM(CASE WHEN E.DETIL_HASIL LIKE '%Kadaluarsa%' THEN 1 ELSE 0 END) AS KADALUARSA,
			SUM(CASE WHEN E.TINDAKAN_SARANA LIKE '%peringatan%' THEN 1 ELSE 0 END) AS PR,
			SUM(CASE WHEN E.TINDAKAN_SARANA LIKE '%pengamanan%' THEN 1 ELSE 0 END) AS PB,
			SUM(CASE WHEN E.TINDAKAN_SARANA LIKE '%Importasi%' THEN 1 ELSE 0 END) AS IMPORTASI,
			SUM(CASE WHEN E.TINDAKAN_SARANA LIKE '%projusticia%' THEN 1 ELSE 0 END) AS PJ,
			SUM(CASE WHEN E.TINDAKAN_SARANA LIKE '%salon%' THEN 1 ELSE 0 END) AS SALON,
			SUM(CASE WHEN E.TINDAKAN_SARANA LIKE '%produksi%' THEN 1 ELSE 0 END) AS PRODUKSI,
			SUM(CASE WHEN E.TINDAKAN_SARANA LIKE '%usaha%' THEN 1 ELSE 0 END) AS SEMUA,
			SUM(CASE WHEN E.TINDAKAN_SARANA LIKE '%lain-lain%' THEN 1 ELSE 0 END) AS LAIN
			FROM T_PEMERIKSAAN A LEFT JOIN M_BBPOM C ON A.BBPOM_ID = C.BBPOM_ID
			LEFT JOIN T_PEMERIKSAAN_KOSMETIK E ON A.PERIKSA_ID = E.PERIKSA_ID WHERE A.JENIS_SARANA_ID = '02KO' $filter2 AND LEN(A.STATUS) > 2 GROUP BY C.BBPOM_ID, C.NAMA_BBPOM ORDER BY 1";
			$this->newphpexcel->set_font('Calibri',10);
			$this->newphpexcel->setActiveSheetIndex(0);
			$this->newphpexcel->set_title('RHPK Sarana');
			$this->newphpexcel->mergecell(array(array('A1','S1'),array('A2','S2'),array('A3','S3'),array('A4','S4'),array('A6','A7'),array('C6','F6'),array('G6','K6'),array('L6','S6')), TRUE);
			$this->newphpexcel->mergecell(array(array('B6','B7')), FALSE);
			$this->newphpexcel->width(array(array('A',4), array('B',45),array('C',8),array('D',5),array('E',5),array('F',14),array('G',14),array('H',13),array('I',13),array('J',13),array('K',13),array('L',13),array('M',13),array('N',13),array('O',13),array('P',13),array('Q',13),array('R',13),array('S',13)));
			$this->newphpexcel->set_bold(array('A1','A2','A3','A4'));
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A1', 'REKAPITULASI HASIL PELAKSANAAN KEGIATAN - PEMERIKSAAN SARANA')->setCellValue('A2',$judul)->setCellValue('A3', strtoupper($balai))->setCellValue('A4', 'PERIODE : '.$awal.' s.d '.$akhir);
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A6','No.')->setCellValue('B6','BB / BPOM')->setCellValue('C6','Jumlah')->setCellValue('G6','Rincian TMK (Sarana)')->setCellValue('L6','Tindak Lanjut Terhadap Sarana')			
			->setCellValue('C7','Diperiksa')->setCellValue('D7','MK')->setCellValue('E7','TMK')->setCellValue('F7','Tutup')->setCellValue('G7','Mengedarkan Produk TIE')->setCellValue('H7','Mengedarkan Produk BB')->setCellValue('I7','TMK Penandaan')->setCellValue('J7','Administrasi')->setCellValue('K7','Kadaluarsa')->setCellValue('L7','Peringatan')->setCellValue('M7','Pengamanan')->setCellValue('N7','PSK Importasi / Distribusi')->setCellValue('O7','Projusticia')->setCellValue('P7','Rekomendasi PSK / Klinik / Salon / Spa')->setCellValue('Q7','Rekomendasi Pencabuatn Izin Produksi')->setCellValue('R7','Rekomendasi Pencabutan Izin Usaha (Semua)')->setCellValue('S7','Lain-lain');
			$this->newphpexcel->headings(array('A6','B6','C6','D6','E6','F6','G6','H6','I6','J6','K6','L6','M6','N6','O6','P6','Q6','R6','S6','B7','C7','D7','E7','F7','G7','H7','I7','J7','K7','L7','M7','N7','O7','P7','Q7','R7','S7'));
			$this->newphpexcel->set_wrap(array('F7','G7','H7','I7','J7','K7','L7','M7','N7','O7','P7','Q7','R7','S7'));
			$datasarana = $sipt->main->get_result($qsarana);	
			if($datasarana){
				$no=1;
				$rec = 8;
				foreach($qsarana->result_array() as $rowsarana){
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A'.$rec,$no)
															  ->setCellValue('B'.$rec,$rowsarana["NAMA_BBPOM"])
															  ->setCellValue('C'.$rec,$rowsarana["JMLPERIKSA"])
															  ->setCellValue('D'.$rec,$rowsarana["MK"])
															  ->setCellValue('E'.$rec,$rowsarana["TMK"])
															  ->setCellValue('F'.$rec,$rowsarana["TTP"])
															  ->setCellValue('G'.$rec,$rowsarana["MENGEDARKANTIE"])
															  ->setCellValue('H'.$rec,$rowsarana["MENGEDARKANBB"])
															  ->setCellValue('I'.$rec,$rowsarana["TMKPENANDAAN"])
															  ->setCellValue('J'.$rec,$rowsarana["ADMINISTRASI"])
															  ->setCellValue('K'.$rec,$rowsarana["KADALUARSA"])
															  ->setCellValue('L'.$rec,$rowsarana["PR"])
															  ->setCellValue('M'.$rec,$rowsarana["PB"])
															  ->setCellValue('N'.$rec,$rowsarana["IMPORTASI"])
															  ->setCellValue('O'.$rec,$rowsarana["PJ"])
															  ->setCellValue('P'.$rec,$rowsarana["SALON"])
															  ->setCellValue('Q'.$rec,$rowsarana["PRODUKSI"])
															  ->setCellValue('R'.$rec,$rowsarana["SEMUA"])
															  ->setCellValue('S'.$rec,$rowsarana["LAIN"]);
					$this->newphpexcel->set_detilstyle(array('A'.$rec,'B'.$rec,'C'.$rec,'D'.$rec,'E'.$rec,'F'.$rec,'G'.$rec,'H'.$rec,'I'.$rec,'J'.$rec,'K'.$rec,'L'.$rec,'M'.$rec,'N'.$rec,'O'.$rec,'P'.$rec,'Q'.$rec,'R'.$rec,'S'.$rec));
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
					->setCellValue('S'.$rec,'=SUM(S8:S'.$total.')');
					$this->newphpexcel->set_detilstyle(array('A'.$rec,'B'.$rec,'C'.$rec,'D'.$rec,'E'.$rec,'F'.$rec,'G'.$rec,'H'.$rec,'I'.$rec,'J'.$rec,'K'.$rec,'L'.$rec,'M'.$rec,'N'.$rec,'O'.$rec,'P'.$rec,'Q'.$rec,'R'.$rec,'S'.$rec));
			}else{
				$this->newphpexcel->getActiveSheet()->mergeCells('A8:S8');
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A8','Data Tidak Ditemukan');
				$this->newphpexcel->set_detilstyle(array('A8'));
			}
			$qproduk = "SELECT DISTINCT(REPLACE(REPLACE(C.NAMA_BBPOM,'BALAI BESAR POM DI ', ''),'BALAI POM DI ','')) AS NAMA_BBPOM,
			(SELECT COUNT(JENIS_SARANA_ID) FROM T_PEMERIKSAAN WHERE JENIS_SARANA_ID = '02KO' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS JMLPERIKSA,
			(SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'MK' AND JENIS_SARANA_ID = '02KO' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS MK,
			(SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'TMK' AND JENIS_SARANA_ID = '02KO' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS TMK, 
			SUM(CASE WHEN D.KATEGORI LIKE '%TIE%' THEN 1 ELSE 0 END) AS TIE,
			SUM(CASE WHEN D.KATEGORI LIKE '%Rusak%' THEN 1 ELSE 0 END) AS RUSAK,
			SUM(CASE WHEN D.KATEGORI LIKE '%Dilarang%' THEN 1 ELSE 0 END) AS DILARANG,
			SUM(CASE WHEN D.KATEGORI LIKE '%Penandaan%' THEN 1 ELSE 0 END) AS TMKPENANDAAN,
			SUM(CASE WHEN D.KATEGORI LIKE '%Kadaluarsa%' THEN 1 ELSE 0 END) AS TMKKADALUARSA,
			SUM(CASE WHEN D.TINDAKAN_PRODUK LIKE '%Pengamanan%' THEN 1 ELSE 0 END) AS PENGAMANAN,
			SUM(CASE WHEN D.TINDAKAN_PRODUK LIKE '%Pemusnahan%' THEN 1 ELSE 0 END) AS PEMUSNAHAN,
			SUM(CASE WHEN D.TINDAKAN_PRODUK LIKE '%Penarikan%' THEN 1 ELSE 0 END) AS PENARIKAN,
			SUM(CASE WHEN D.TINDAKAN_PRODUK LIKE '%Pendataan%' THEN 1 ELSE 0 END) AS PENDATAAN
			FROM T_PEMERIKSAAN A LEFT JOIN M_BBPOM C ON A.BBPOM_ID = C.BBPOM_ID
			LEFT JOIN T_PEMERIKSAAN_TEMUAN_PRODUK D ON A.PERIKSA_ID = D.PERIKSA_ID 
			WHERE A.JENIS_SARANA_ID = '02KO' AND D.KK_ID = '012' $filter2 AND LEN(A.STATUS) > 2 GROUP BY C.BBPOM_ID, C.NAMA_BBPOM ORDER BY 1";
			$this->newphpexcel->createSheet();
			$this->newphpexcel->setActiveSheetIndex(1);
			$this->newphpexcel->set_title('RHPK Temuan Produk');
			$this->newphpexcel->mergecell(array(array('A1','N1'),array('A2','N2'),array('A3','N3'),array('A4','N4'),array('A6','A7'),array('C6','E6'),array('F6','J6'),array('K6','N6')), TRUE);
			$this->newphpexcel->mergecell(array(array('B6','B7')), FALSE);
			$this->newphpexcel->width(array(array('A',4), array('B',45),array('C',8),array('D',5),array('E',5),array('F',14),array('G',14),array('H',13),array('I',13),array('J',13),array('K',13),array('L',13),array('M',13),array('M',13)));
			$this->newphpexcel->set_bold(array('A1','A2','A3','A4'));
			$this->newphpexcel->setActiveSheetIndex(1)->setCellValue('A1', 'REKAPITULASI HASIL PELAKSANAAN KEGIATAN - TEMUAN PRODUK')->setCellValue('A2',$judul)->setCellValue('A3', strtoupper($balai))->setCellValue('A4', 'PERIODE : '.$awal.' s.d '.$akhir);
			$this->newphpexcel->setActiveSheetIndex(1)->setCellValue('A6','No.')->setCellValue('B6','BB / BPOM')->setCellValue('C6','Jumlah')->setCellValue('F6','Rincian Temuan Produk')->setCellValue('K6','Tindak Lanjut Terhadap Produk')			
			->setCellValue('C7','Diperiksa')->setCellValue('D7','MK')->setCellValue('E7','TMK')->setCellValue('F7','Produk TIE')->setCellValue('G7','Rusak')->setCellValue('H7','Dilarang')->setCellValue('I7','Penandaan')->setCellValue('J7','Kadaluarsa')->setCellValue('K7','Pengamanan')->setCellValue('L7','Pemusnahan')->setCellValue('M7','Penarikan')->setCellValue('N7','Penandaan');
			$this->newphpexcel->headings(array('A6','B6','C6','D6','E6','F6','G6','H6','I6','J6','K6','L6','M6','N6','B7','C7','D7','E7','F7','G7','H7','I7','J7','K7','L7','M7','N7'));
			$this->newphpexcel->set_wrap(array('F7','G7','H7','I7','J7','K7','L7','M7','N7'));
			$dataproduk = $sipt->main->get_result($qproduk);
			if($dataproduk){
				$no=1;
				$rec = 8;
				foreach($qproduk->result_array() as $rowproduk){
					$this->newphpexcel->setActiveSheetIndex(1)->setCellValue('A'.$rec,$no)
															  ->setCellValue('B'.$rec,$rowproduk["NAMA_BBPOM"])
															  ->setCellValue('C'.$rec,$rowproduk["JMLPERIKSA"])
															  ->setCellValue('D'.$rec,$rowproduk["MK"])
															  ->setCellValue('E'.$rec,$rowproduk["TMK"])
															  ->setCellValue('F'.$rec,$rowproduk["TIE"])
															  ->setCellValue('G'.$rec,$rowproduk["RUSAK"])
															  ->setCellValue('H'.$rec,$rowproduk["DILARANG"])
															  ->setCellValue('I'.$rec,$rowproduk["TMKPENANDAAN"])
															  ->setCellValue('J'.$rec,$rowproduk["TMKKADALUARSA"])
															  ->setCellValue('K'.$rec,$rowproduk["PENGAMANAN"])
															  ->setCellValue('L'.$rec,$rowproduk["PEMUSNAHAN"])
															  ->setCellValue('M'.$rec,$rowproduk["PENARIKAN"])
															  ->setCellValue('N'.$rec,$rowproduk["PENDATAAN"]);
					$this->newphpexcel->set_detilstyle(array('A'.$rec,'B'.$rec,'C'.$rec,'D'.$rec,'E'.$rec,'F'.$rec,'G'.$rec,'H'.$rec,'I'.$rec,'J'.$rec,'K'.$rec,'L'.$rec,'M'.$rec,'N'.$rec));
					$rec++;
					$no++;
				}
				$total2 = $rec - 1;
				$this->newphpexcel->setActiveSheetIndex(1)->setCellValue('A'.$rec,$no)
					->setCellValue('B'.$rec,'Jumlah')
					->setCellValue('C'.$rec,'=SUM(C8:C'.$total2.')')
					->setCellValue('D'.$rec,'=SUM(D8:D'.$total2.')')
					->setCellValue('E'.$rec,'=SUM(E8:E'.$total2.')')
					->setCellValue('F'.$rec,'=SUM(F8:F'.$total2.')')
					->setCellValue('G'.$rec,'=SUM(G8:G'.$total2.')')
					->setCellValue('H'.$rec,'=SUM(H8:H'.$total2.')')
					->setCellValue('I'.$rec,'=SUM(I8:I'.$total2.')')
					->setCellValue('J'.$rec,'=SUM(J8:J'.$total2.')')
					->setCellValue('K'.$rec,'=SUM(K8:K'.$total2.')')
					->setCellValue('L'.$rec,'=SUM(L8:L'.$total2.')')
					->setCellValue('M'.$rec,'=SUM(M8:M'.$total2.')')
					->setCellValue('N'.$rec,'=SUM(N8:N'.$total2.')');
					$this->newphpexcel->set_detilstyle(array('A'.$rec,'B'.$rec,'C'.$rec,'D'.$rec,'E'.$rec,'F'.$rec,'G'.$rec,'H'.$rec,'I'.$rec,'J'.$rec,'K'.$rec,'L'.$rec,'M'.$rec,'N'.$rec));
			}else{
				$this->newphpexcel->getActiveSheet()->mergeCells('A8:N8');
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