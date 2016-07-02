<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);
class Detil_01VV extends Model{
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
			$query = "SELECT LTRIM(RTRIM(UPPER(REPLACE(C.NAMA_SARANA,'-','')))) AS NAMA_SARANA,  CAST(C.ALAMAT_1+' '+D.NAMA_PROPINSI+' '+E.NAMA_PROPINSI AS VARCHAR(255)) AS ALAMAT,  CONVERT(VARCHAR(10), B.AWAL_PERIKSA, 103) + ' s.d ' + CONVERT(VARCHAR(10), B.AKHIR_PERIKSA, 103) AS [TANGGAL],  A.JENIS_PANGAN, A.NO_PIRT,  CASE WHEN A.STATUS_SARANA = '0' THEN 'Tutup' WHEN A.STATUS_SARANA = '1' THEN 'Aktif' WHEN A.STATUS_SARANA = '2' THEN 'Tidak Produksi Saat Diperiksa' WHEN A.STATUS_SARANA = '3' THEN 'Menolak Diperiksa' END AS UR_STATUS_SARANA, A.STATUS_SARANA, A.CATATAN, A.RINCIAN_NOMOR, A.RINCIAN_KETIDAKSESUAIAN, A.RINCIAN_KRITERIA, A.RINCIAN_TIMELINE, A.JML_KRITIS, A.JML_SERIUS, A.JML_MAJOR, A.JML_MINOR, A.LEVEL_IRTP, STUFF(dbo.GROUP_PETUGAS(B.PERIKSA_ID),1,0,'') AS PETUGAS FROM T_PEMERIKSAAN_PIRT A LEFT JOIN T_PEMERIKSAAN B ON A.PERIKSA_ID = B.PERIKSA_ID LEFT JOIN M_SARANA C ON B.SARANA_ID = C.SARANA_ID LEFT JOIN M_PROPINSI D ON C.PROPINSI = D.PROPINSI_ID LEFT JOIN M_PROPINSI E ON C.KOTA = E.PROPINSI_ID WHERE B.JENIS_SARANA_ID = '01VV'";
			
			if(trim($this->input->post('AWAL')!="")){
				$query .= " AND DATEDIFF(dy, 0, convert(DATETIME, B.AWAL_PERIKSA, 105)) >= DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('AWAL')."', 105))";
				$awal = $this->input->post('AWAL');
			}else{
				$query .= " AND B.AWAL_PERIKSA > DATEADD(M, DATEDIFF(M,0,GETDATE()),0)";
				$awal = date('01/m/Y');
			}
			if(trim($this->input->post('AKHIR')!="")){
				$query .= " AND DATEDIFF(dy, 0, convert(DATETIME, B.AWAL_PERIKSA, 105)) <= DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('AKHIR')."', 105))";
				$akhir = $this->input->post('AKHIR');
			}else{
				$query .= " AND B.AWAL_PERIKSA < DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,0,GETDATE())+1,0))";
				$akhir = date('t/m/Y');
			}
			if(trim($this->input->post('HASIL')) != "") $query .= " AND D.HASIL = '".$this->input->post('HASIL')."'";
			if($this->newsession->userdata('SESS_BBPOM_ID') != "95" && $this->newsession->userdata('SESS_BBPOM_ID') != "00"){
				$query .= " AND B.BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'";
				$balai = $sipt->main->get_uraian("SELECT NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","NAMA_BBPOM");
			}else{
				if(trim($this->input->post('BBPOM_ID')) == ""){
					$query .= "";
					$balai = "Seluruh Balai";
				}else{
					$query .= " AND B.BBPOM_ID = '".$this->input->post('BBPOM_ID')."'";
					$balai = $sipt->main->get_uraian("SELECT NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID = '".$this->input->post('BBPOM_ID')."'","NAMA_BBPOM");
				}
			}
			#$query .= " AND D.STATUS LIKE '%1_'";			
			$query .= " AND B.STATUS NOT IN ('00')";			
			#if($this->input->post('TEMUAN') != "") $query .= " AND X.HASIL_TEMUAN_LAIN LIKE '%".$this->input->post('TEMUAN')."%' OR X.KESIMPULAN LIKE '%".$this->input->post('TEMUAN')."%' OR X.REKOMENDASI LIKE '%".$this->input->post('TEMUAN')."%'";
			#if($this->input->post('TINDAKAN') != "") $query .= " AND X.TINDAKAN LIKE '%".$this->input->post('TINDAKAN')."%'";
			#if($this->input->post('KK_ID') != "") $query .= " AND F.KK_ID = '".$this->input->post('KK_ID')."'";
			if(trim($this->input->post('KOTA')!="")) $query .= " AND E.KOTA  = '".$this->input->post('KOTA')."'";			
			$query .= " ORDER BY 1 ASC";
			$this->newphpexcel->getDefaultStyle()->getFont()->setName('Calibri')->setSize(10);
			$this->newphpexcel->setActiveSheetIndex(0);
			$this->newphpexcel->mergecell(array(array('A1','J1'),array('A2','B2'),array('A3','B3'),array('A4','B4'),array('A5','B5'),array('A7','A8'),array('B7','B8'),array('C7','C8'),array('D7','D8'),array('E7','E8'),array('F7','F8'),array('G7','G8'),array('H7','H8'),array('I7','I8'),array('J7','J8'),array('K7','N7'),array('O7','O8')), FALSE);
			$this->newphpexcel->width(array(array('A',5),array('B',30),array('C',30),array('D',30),array('E',30),array('F',30),array('G',30),array('H',30),array('I',30),array('J',30),array('K',9),array('L',9),array('M',9),array('N',9),array('O',9)));
			$this->newphpexcel->set_bold(array('A1','C2','C5'));
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A1', 'LAPORAN HASIL PEMERIKSAAN SARANA PRODUKSI PANGAN IRT')->setCellValue('A2', 'Jenis Sarana')->setCellValue('C2', $judul)->setCellValue('A3', 'Pemeriksaan Awal')->setCellValue('C3', $awal)->setCellValue('A4', 'Pemeriksaan Akhir')->setCellValue('C4', $akhir)->setCellValue('A5', 'Balai Besar / Balai POM')->setCellValue('C5', $balai);
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A7','No.')
							                          ->setCellValue('B7','Nama Sarana')
													  ->setCellValue('C7','Alamat')
													  ->setCellValue('D7','Jenis Pangan')
													  ->setCellValue('E7','No. PIRT')
													  ->setCellValue('F7','Tanggal Periksa')
													  ->setCellValue('G7','Status Sarana')
													  ->setCellValue('H7','Penyimpangan')
													  ->setCellValue('I7','Kriteria')
													  ->setCellValue('J7','Timeline')
													  ->setCellValue('K7','Jumlah Penyimpangan')
													  ->setCellValue('O7','Level IRTP')
													  ->setCellValue('K8','Kritis')
													  ->setCellValue('L8','Serius')
													  ->setCellValue('M8','Major')
													  ->setCellValue('N8','Minor');
			$this->newphpexcel->headings(array('A7','B7','C7','D7','E7','F7','G7','H7','I7','J7','K7','L7','M7','N7','O7','A8','B8','C8','D8','E8','F8','G8','H8','I8','J8','K8','L8','M8','N8','O8'));
			$this->newphpexcel->set_wrap(array('B','C','D','E','G','H','I','J','K','L','M','N','O'));
			$data = $sipt->main->get_result($query);
			if($data){
				$no=1;
				$rec = 9; //html_entity_decode
				foreach($query->result_array() as $row){
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A'.$rec,$no)
					->setCellValue('B'.$rec,strtoupper($row["NAMA_SARANA"]))
					->setCellValue('C'.$rec,$row["ALAMAT"])
					->setCellValue('D'.$rec,str_replace(",",chr(10),$row["JENIS_PANGAN"]))
					->setCellValue('E'.$rec,str_replace(",",chr(10),$row["NO_PIRT"]))
					->setCellValue('F'.$rec,$row["TANGGAL"])
					->setCellValue('G'.$rec,$row['UR_STATUS_SARANA']. ($row['STATUS_SARANA'] == "1" ? chr(10).$row['CATATAN'] : ''))
					->setCellValue('H'.$rec,str_replace("#",chr(10),$row["RINCIAN_NOMOR"]))
					->setCellValue('I'.$rec,str_replace("#",chr(10),$row["RINCIAN_KRITERIA"]))
					->setCellValue('J'.$rec,str_replace("#",chr(10),$row["RINCIAN_TIMELINE"]))
					->setCellValue('K'.$rec,$row["JML_KRITIS"])
					->setCellValue('L'.$rec,$row["JML_SERIUS"])
					->setCellValue('M'.$rec,$row["JML_MAJOR"])
					->setCellValue('N'.$rec,$row["JML_SERIUS"])
					->setCellValue('O'.$rec,$row["LEVEL_IRTP"]);
					$this->newphpexcel->set_detilstyle(array('A'.$rec,'B'.$rec,'C'.$rec,'D'.$rec,'E'.$rec,'F'.$rec,'G'.$rec,'H'.$rec,'I'.$rec,'J'.$rec,'K'.$rec,'L'.$rec,'M'.$rec,'N'.$rec,'O'.$rec));
					$rec++;
					$no++;
				}
			}else{
				$this->newphpexcel->getActiveSheet()->mergeCells('A9:O9');
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A9','Data Tidak Ditemukan');
				$this->newphpexcel->set_detilstyle(array('A9'));
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
	
	function set_excel_sarana_2014(){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$this->load->library('newphpexcel');
			$judul = $sipt->main->get_judul($this->input->post("JENIS"));
			if($this->input->post('KK_ID') != "")
				$klas = " LEFT JOIN T_PEMERIKSAAN_KLASIFIKASI F ON D.PERIKSA_ID = F.PERIKSA_ID ";
			else
				$klas = "";
			$query = "SELECT LTRIM(RTRIM(UPPER(REPLACE(A.NAMA_SARANA,'-','')))) AS NAMA_SARANA, CAST(A.ALAMAT_1+' '+C.NAMA_PROPINSI+' '+B.NAMA_PROPINSI AS VARCHAR(255)) AS ALAMAT, CONVERT(VARCHAR(10), D.AWAL_PERIKSA, 103) + ' s.d ' + CONVERT(VARCHAR(10), D.AKHIR_PERIKSA, 103) AS [TANGGAL], X.HASIL_TEMUAN_LAIN, D.HASIL, X.TINDAKAN, X.KESIMPULAN, X.REKOMENDASI, X.CAPA, STUFF(dbo.GROUP_PETUGAS(D.PERIKSA_ID),1,0,'') AS PETUGAS FROM M_SARANA A LEFT JOIN M_PROPINSI B ON A.PROPINSI = B.PROPINSI_ID LEFT JOIN M_PROPINSI C ON A.KOTA = C.PROPINSI_ID LEFT JOIN T_PEMERIKSAAN D ON A.SARANA_ID = D.SARANA_ID LEFT JOIN T_PEMERIKSAAN_PANGAN X ON D.PERIKSA_ID = X.PERIKSA_ID $klas WHERE D.JENIS_SARANA_ID ='".$this->input->post('JENIS')."'";
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
			$query .= " ORDER BY 1 ASC";
			$this->newphpexcel->getDefaultStyle()->getFont()->setName('Calibri')->setSize(10);
			$this->newphpexcel->setActiveSheetIndex(0);
			$this->newphpexcel->mergecell(array(array('A1','J1'),array('A2','B2'),array('A3','B3'),array('A4','B4'),array('A5','B5')), FALSE);
			$this->newphpexcel->width(array(array('A',5),array('B',30),array('C',30),array('D',30),array('E',30),array('F',15),array('G',30),array('H',30),array('I',30),array('J',30)));
			$this->newphpexcel->set_bold(array('A1','C2','C5'));
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A1', 'LAPORAN HASIL PEMERIKSAAN SARANA PRODUKSI PANGAN IRT')->setCellValue('A2', 'Jenis Sarana')->setCellValue('C2', $judul)->setCellValue('A3', 'Pemeriksaan Awal')->setCellValue('C3', $awal)->setCellValue('A4', 'Pemeriksaan Akhir')->setCellValue('C4', $akhir)->setCellValue('A5', 'Balai Besar / Balai POM')->setCellValue('C5', $balai);
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A7','No.')->setCellValue('B7','Nama Sarana')->setCellValue('C7','Alamat')->setCellValue('D7','Tanggal Periksa')->setCellValue('E7','Hasil Temuan')->setCellValue('F7','Hasil')->setCellValue('G7','Kesimpulan')->setCellValue('H7','Tindakan')->setCellValue('I7','Rekomendasi')->setCellValue('J7','CAPA');
			$this->newphpexcel->headings(array('A7','B7','C7','D7','E7','F7','G7','H7','I7','J7'));
			$this->newphpexcel->set_wrap(array('B','C','D','E','G','H','I','J'));
			$data = $sipt->main->get_result($query);
			if($data){
				$no=1;
				$rec = 8; //html_entity_decode
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
	
	function rekap_01VV(){
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
			$query = "SELECT DISTINCT(REPLACE(REPLACE(C.NAMA_BBPOM,'BALAI BESAR POM', 'BBPOM'),'BALAI POM','BPOM')) AS NAMA_BBPOM, 
					 (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE JENIS_SARANA_ID = '01VV' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS JMLPERIKSA,
					 (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'BAIK' AND JENIS_SARANA_ID = '01VV' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS BAIK, 
					 (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'CUKUP' AND JENIS_SARANA_ID = '01VV' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS CUKUP, 
					 (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'KURANG' AND JENIS_SARANA_ID = '01VV' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS KURANG, 
					 SUM(CASE WHEN D.TINDAKAN LIKE '%Pembinaan%' THEN 1 ELSE 0 END) AS PEMBINAAN,
					 SUM(CASE WHEN D.TINDAKAN LIKE '%Surat Peringatan%' THEN 1 ELSE 0 END) AS SP,
					 SUM(CASE WHEN D.TINDAKAN LIKE '%Pencabutan Nomor Pendaftaran (Usul)%' THEN 1 ELSE 0 END) AS PNP,
					 SUM(CASE WHEN D.TINDAKAN LIKE '%Pengamanan%' THEN 1 ELSE 0 END) AS PENGAMANAN,
					 SUM(CASE WHEN D.TINDAKAN LIKE '%Perintah Penarikan%' THEN 1 ELSE 0 END) AS PP,
					 SUM(CASE WHEN D.TINDAKAN LIKE '%Pemusnahan Produk%' THEN 1 ELSE 0 END) AS PEMUSNAHAN
					 FROM T_PEMERIKSAAN A LEFT JOIN M_BBPOM C ON A.BBPOM_ID = C.BBPOM_ID
					 LEFT JOIN T_PEMERIKSAAN_PANGAN D ON A.PERIKSA_ID = D.PERIKSA_ID
					 WHERE A.JENIS_SARANA_ID = '01VV' $filter2 AND LEN(A.STATUS) > 2 
					 GROUP BY C.BBPOM_ID, C.NAMA_BBPOM ORDER BY 1";
			$this->newphpexcel->set_font('Calibri',10);
			$this->newphpexcel->setActiveSheetIndex(0);
			$this->newphpexcel->mergecell(array(array('A1','L1'),array('A2','L2'),array('A3','L3'),array('A4','L4'),array('A6','A7'),array('C6','C7'),array('D6','D7'),array('E6','E7'),array('G6','L6'), array('F6','F7')), TRUE);
			$this->newphpexcel->mergecell(array(array('B6','B7')), FALSE);
			$this->newphpexcel->width(array(array('A',4), array('B',45),array('C',7),array('D',6),array('E',6),array('F',8),array('G',10),array('H',13),array('I',13),array('J',11),array('K',10),array('L',11)));
			$this->newphpexcel->set_bold(array('A1','A2','A3','A4'));
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A1', 'REKAPITULASI HASIL PEMERIKSAAN SARANA')->setCellValue('A2',$judul)->setCellValue('A3', strtoupper($balai))->setCellValue('A4', 'PERIODE : '.$awal.' s.d '.$akhir);
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A6','No.')->setCellValue('B6','BB / BPOM')->setCellValue('C6','Jumlah')->setCellValue('D6','BAIK')->setCellValue('E6','CUKUP')->setCellValue('F6','KURANG')->setCellValue('G6','Tindak Lanjut')->setCellValue('G7','Pembinaan')->setCellValue('H7','Surat Peringatan')->setCellValue('I7','Pencabutan Nomor Pendaftaran')->setCellValue('J7','Pengamanan')->setCellValue('K7','Perintah Penarikan')->setCellValue('L7','Pemusnahan');
			$this->newphpexcel->headings(array('A6','B6','C6','D6','E6','F6','G6','H6','I6','J6','K6','L6','B7','C7','D7','E7','F7','G7','H7','I7','J7','K7','L7'));
			$this->newphpexcel->set_wrap(array('G7','H7','I7','J7','K7','L7'));
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
															  ->setCellValue('I'.$rec,$row["PNP"])
															  ->setCellValue('J'.$rec,$row["PENGAMANAN"])
															  ->setCellValue('K'.$rec,$row["PP"])
															  ->setCellValue('L'.$rec,$row["PEMUSNAHAN"]);
					$this->newphpexcel->set_detilstyle(array('A'.$rec,'B'.$rec,'C'.$rec,'D'.$rec,'E'.$rec,'F'.$rec,'G'.$rec,'H'.$rec,'I'.$rec,'J'.$rec,'K'.$rec,'L'.$rec));
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
					->setCellValue('L'.$rec,'=SUM(L8:L'.$total.')');
					$this->newphpexcel->set_detilstyle(array('A'.$rec,'B'.$rec,'C'.$rec,'D'.$rec,'E'.$rec,'F'.$rec,'G'.$rec,'H'.$rec,'I'.$rec,'J'.$rec,'K'.$rec,'L'.$rec));
			}else{
				$this->newphpexcel->getActiveSheet()->mergeCells('A8:L8');
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