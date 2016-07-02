<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);
class Detil_01KO extends Model{
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
			$query = "SELECT LTRIM(RTRIM(UPPER(REPLACE(A.NAMA_SARANA,'-','')))) AS NAMA_SARANA, CAST(A.ALAMAT_1+' '+C.NAMA_PROPINSI+' '+B.NAMA_PROPINSI AS VARCHAR(255)) AS ALAMAT, A.NAMA_PIMPINAN,A.PENANGGUNG_JAWAB, CONVERT(VARCHAR(10), D.AWAL_PERIKSA, 103) + ' s.d ' + CONVERT(VARCHAR(10), D.AKHIR_PERIKSA, 103) AS [TANGGAL], E.KEPATUHAN_CPKB, D.HASIL, E.TEMUAN_KRITIKAL, E.TEMUAN_MAJOR, E.TEMUAN_MINOR, E.DETIL_HASIL, E.KESIMPULAN_DETIL_TMK, E.REKOMENDASI, E.KESIMPULAN, E.TINDAK_LANJUT, E.TIME_LINE, E.STATUS_CAPA, E.CAPA_CLOSED, STUFF(dbo.GROUP_PETUGAS(D.PERIKSA_ID),1,0,'') AS PETUGAS FROM M_SARANA A LEFT JOIN M_PROPINSI B ON A.PROPINSI = B.PROPINSI_ID LEFT JOIN M_PROPINSI C ON A.KOTA = C.PROPINSI_ID LEFT JOIN T_PEMERIKSAAN D ON A.SARANA_ID = D.SARANA_ID LEFT JOIN T_PEMERIKSAAN_PRODUKSI_CPKB E ON D.PERIKSA_ID = E.PERIKSA_ID $klas WHERE D.JENIS_SARANA_ID ='".$this->input->post('JENIS')."'";
			
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
			if($this->input->post('TEMUAN') != "") $query .= " AND E.KEPATUHAN_CPKB LIKE '%".$this->input->post('TEMUAN')."%'";
			if($this->input->post('TINDAKAN') != "") $query .= " AND E.TINDAKAN_OBSERVASI LIKE '%".$this->input->post('TINDAKAN')."%' OR E.TINDAK_LANJUT_DIP LIKE '%".$this->input->post('TINDAKAN')."%' OR E.TINDAK_LANJUT LIKE '%".$this->input->post('TINDAKAN')."%'";
			if($this->input->post('KK_ID') != "") $query .= " AND F.KK_ID = '".$this->input->post('KK_ID')."'";
			if(trim($this->input->post('KOTA')!="")) $query .= " AND A.KOTA  = '".$this->input->post('KOTA')."'";
			$query .= " ORDER BY 1 ASC";
			$this->newphpexcel->getDefaultStyle()->getFont()->setName('Calibri')->setSize(10);
			$this->newphpexcel->setActiveSheetIndex(0);
			$this->newphpexcel->mergecell(array(array('A1','T1'),array('A2','B2'),array('A3','B3'),array('A4','B4'),array('A5','B5')), FALSE);
			$this->newphpexcel->mergecell(array(array('A7','A8'),array('B7','E7'),array('F7','I7'),array('J7','L7'),array('M7','P7'),array('Q7','R7'),array('S7','T7')), TRUE);
			$this->newphpexcel->width(array(array('A',5),array('B',30),array('C',30),array('D',20),array('E',20),array('F',25),array('G',20),array('H',30),array('I',5),array('J',7),array('K',7),array('L',7),array('M',20),array('N',20),array('O',20),array('P',20),array('Q',20),array('R',20),array('S',20),array('T',20)));
			$this->newphpexcel->set_bold(array('A1','C2','C5'));
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A1', 'LAPORAN HASIL PEMERIKSAAN SARANA PRODUKSI KOSMETIKA')->setCellValue('A2', 'Jenis Sarana')->setCellValue('C2', $judul)->setCellValue('A3', 'Pemeriksaan Awal')->setCellValue('C3', $awal)->setCellValue('A4', 'Pemeriksaan Akhir')->setCellValue('C4', $akhir)->setCellValue('A5', 'Balai Besar / Balai POM')->setCellValue('C5', $balai);		
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A7','No.')->setCellValue('B7','Data Sarana')->setCellValue('F7','Pemeriksaan')->setCellValue('J7','Klasifikasi Temuan')->setCellValue('M7','Kesimpulan')->setCellValue('Q7','Tindak Lanjut')->setCellValue('S7','CAPA')->setCellValue('B8','Nama Sarana')->setCellValue('C8','Alamat')->setCellValue('D8','Pimpinan')->setCellValue('E8','Penanggung Jawab')->setCellValue('F8','Tanggal')->setCellValue('G8','Tujuan')->setCellValue('H8','Kepatuhan CPOTB')->setCellValue('I8','Hasil')->setCellValue('J8','Kritikal')->setCellValue('K8','Major')->setCellValue('L8','Minor')->setCellValue('M8','Detil Hasil')->setCellValue('N8','Detil TMK')->setCellValue('O8','Rekomendasi')->setCellValue('P8','Kesimpulan')->setCellValue('Q8','Tindak Lanjut')->setCellValue('R8','Timeline')->setCellValue('S8','Status CAPA')->setCellValue('T8','CAPA Closed');
			$this->newphpexcel->headings(array('A7','B7','C7','D7','E7','F7','G7','H7','I7','J7','K7','L7','M7','N7','O7','P7','Q7','R7','S7','T7'));
			$this->newphpexcel->headings(array('A8','B8','C8','D8','E8','F8','G8','H8','I8','J8','K8','L8','M8','N8','O8','P8','Q8','R8','S8','T8'));
			$this->newphpexcel->set_wrap(array('B','C','D','E','H','I','J','K','L','M','N','O','P','Q','R','S','T'));
			$data = $sipt->main->get_result($query);
			if($data){
				$no=1;
				$rec = 9;
				foreach($query->result_array() as $row){
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A'.$rec,$no)
					->setCellValue('B'.$rec,strtoupper($row["NAMA_SARANA"]))
					->setCellValue('C'.$rec,$row["ALAMAT"])
					->setCellValue('D'.$rec,$row["NAMA_PIMPINAN"])
					->setCellValue('E'.$rec,$row["PENANGGUNG_JAWAB"])
					->setCellValue('F'.$rec,$row["TANGGAL"])
					->setCellValue('G'.$rec,$row["TUJUAN_PEMERIKSAAN"])
					->setCellValue('H'.$rec,preg_replace('/<[^>]*>/','',str_replace("&nbsp;","",html_entity_decode($row["KEPATUHAN_CPKB"]))))
					->setCellValue('I'.$rec,$row["HASIL"])
					->setCellValue('J'.$rec,$row["TEMUAN_KRITIKAL"])
					->setCellValue('K'.$rec,$row["TEMUAN_MAJOR"])
					->setCellValue('L'.$rec,$row["TEMUAN_MINOR"])
					->setCellValue('M'.$rec,str_replace('#',';',$row["DETIL_HASIL"]))
					->setCellValue('N'.$rec,preg_replace('/<[^>]*>/','',html_entity_decode($row["KESIMPULAN_DETIL_TMK"])))
					->setCellValue('O'.$rec,preg_replace('/<[^>]*>/','',html_entity_decode($row["REKOMENDASI"])))
					->setCellValue('P'.$rec,preg_replace('/<[^>]*>/','',html_entity_decode($row["KESIMPULAN"])))
					->setCellValue('Q'.$rec,preg_replace('/<[^>]*>/','',html_entity_decode($row["TINDAK_LANJUT"])))
					->setCellValue('R'.$rec,preg_replace('/<[^>]*>/','',html_entity_decode($row["TIME_LINE"])))
					->setCellValue('S'.$rec,preg_replace('/<[^>]*>/','',html_entity_decode($row["STATUS_CAPA"])))
					->setCellValue('T'.$rec,preg_replace('/<[^>]*>/','',html_entity_decode($row["CAPA_CLOSE"])));
					$this->newphpexcel->set_detilstyle(array('A'.$rec,'B'.$rec,'C'.$rec,'D'.$rec,'E'.$rec,'F'.$rec,'G'.$rec,'H'.$rec,'I'.$rec,'J'.$rec,'K'.$rec,'L'.$rec,'M'.$rec,'N'.$rec,'O'.$rec,'P'.$rec,'Q'.$rec,'R'.$rec,'S'.$rec,'T'.$rec));
					$rec++;
					$no++;
				}
			}else{
				$this->newphpexcel->getActiveSheet()->mergeCells('A9:T9');
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
	
	function rekap_01KO(){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$this->load->library('newphpexcel');
			$judul = strtoupper($sipt->main->get_uraian("SELECT dbo.NAMA_JENIS_SARANA('".$this->input->post('JENIS')."') AS JUDUL","JUDUL"));
			$filter1 = "";
			$filter2 = "";
			if(trim($this->input->post('AWAL')!="")){
				$filter1 .= " AND DATEDIFF(dy, 0, convert(DATETIME, AWAL_PERIKSA, 105)) >= DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('AWAL')."', 105)) AND LEN(STATUS) > 2";
				$filter2 .= " AND DATEDIFF(dy, 0, convert(DATETIME, A.AWAL_PERIKSA, 105)) >= DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('AWAL')."', 105))";
				$fawal = "DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('AWAL')."', 105))";
				$awal = $this->input->post('AWAL');
			}else{
				$filter1 .= " AND AWAL_PERIKSA > GETDATE() AND LEN(STATUS) > 2";
				$filter2 .= " AND A.AWAL_PERIKSA > GETDATE()";
				$fawal = "DATEADD(M, DATEDIFF(M,0,GETDATE()),0)";
				$awal = date('01/m/Y');
			}
			if(trim($this->input->post('AKHIR')!="")){
				$filter1 .= " AND DATEDIFF(dy, 0, convert(DATETIME, AWAL_PERIKSA, 105)) <= DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('AKHIR')."', 105)) AND LEN(STATUS) > 2";
				$filter2 .= " AND DATEDIFF(dy, 0, convert(DATETIME, A.AWAL_PERIKSA, 105)) <= DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('AKHIR')."', 105))";
				$fakhir = "DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('AKHIR')."', 105))";
				$akhir = $this->input->post('AKHIR');
			}else{
				$filter1 .= " AND AKHIR_PERIKSA < GETDATE() AND LEN(STATUS) > 2";
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
			$query = " SELECT DISTINCT(REPLACE(REPLACE(C.NAMA_BBPOM,'BALAI BESAR POM', 'BBPOM'),'BALAI POM','BPOM')) AS NAMA_BBPOM,
			(SELECT COUNT(JENIS_SARANA_ID) FROM T_PEMERIKSAAN WHERE JENIS_SARANA_ID = '01KO' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS JMLPERIKSA,
			(SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'MK' AND JENIS_SARANA_ID = '01KO' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS MK,
			(SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'TMK' AND JENIS_SARANA_ID = '01KO' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS TMK, 
			(SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'TTP' AND JENIS_SARANA_ID = '01KO' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS TUTUP, 
			dbo.DETIL_TMK_CPKB('%Memproduksi TIE%',A.BBPOM_ID,".$fawal.",".$fakhir.") AS TMKTIE, 
			dbo.DETIL_TMK_CPKB('%Memproduksi MGB Berbahaya%',A.BBPOM_ID,".$fawal.",".$fakhir.") AS TMKBB, 
			dbo.DETIL_TMK_CPKB('%Aspek CPKB%',A.BBPOM_ID,".$fawal.",".$fakhir.") AS ASPEK_CPKB, 
			dbo.DETIL_TMK_CPKB('%TMK Penandaan%',A.BBPOM_ID,".$fawal.",".$fakhir.") AS TMKLABEL, 
			dbo.DETIL_TMK_CPKB('%Administrasi%',A.BBPOM_ID,".$fawal.",".$fakhir.") AS ADMINISTRASI,  
			dbo.DETIL_TMK_CPKB('%DIP%',A.BBPOM_ID,".$fawal.",".$fakhir.") AS DIP,  
			dbo.TL_CPKB('%Pembinaan%', A.BBPOM_ID,".$fawal.",".$fakhir.") AS PEMBINAAN,  
			dbo.TL_CPKB('%Perbaikan%', A.BBPOM_ID,".$fawal.",".$fakhir.") AS PERBAIKAN,  
			dbo.TL_CPKB('%Peringatan', A.BBPOM_ID,".$fawal.",".$fakhir.") AS PERINGATAN,  
			dbo.TL_CPKB('%Peringatan Keras%', A.BBPOM_ID,".$fawal.",".$fakhir.") AS PK,  
			dbo.TL_CPKB('%Pemberhentian%', A.BBPOM_ID,".$fawal.",".$fakhir.") AS PSK,  
			dbo.TL_CPKB('%Pembekuan%', A.BBPOM_ID,".$fawal.",".$fakhir.") AS PEMBEKUAN,  
			dbo.TL_CPKB('%Penutupan%', A.BBPOM_ID,".$fawal.",".$fakhir.") AS PENUTUPAN,  
			dbo.TL_CPKB('%Akses Online%', A.BBPOM_ID,".$fawal.",".$fakhir.") AS AKSES_ONLINE,  
			dbo.TL_CPKB('%Projusticia%', A.BBPOM_ID,".$fawal.",".$fakhir.") AS PROJUSTICIA,  
			dbo.TL_CPKB('%Sertifikat CPKB%', A.BBPOM_ID,".$fawal.",".$fakhir.") AS SERT_CPKB,  
			dbo.TL_CPKB('%Izin Produksi%', A.BBPOM_ID,".$fawal.",".$fakhir.") AS PIP
			FROM T_PEMERIKSAAN A LEFT JOIN M_BBPOM C ON A.BBPOM_ID = C.BBPOM_ID WHERE A.JENIS_SARANA_ID = '01KO' $filter2 AND LEN(A.STATUS) > 2 ORDER BY 1";
			$this->newphpexcel->set_font('Calibri',10);
			$this->newphpexcel->setActiveSheetIndex(0);
			$this->newphpexcel->mergecell(array(array('A1','W1'),array('A2','W2'),array('A3','W3'),array('A4','W4'),array('A6','A7'),array('C6','F6'),array('G6','L6'),array('M6','W6')), TRUE);
			$this->newphpexcel->mergecell(array(array('B6','B7')), FALSE);
			$this->newphpexcel->width(array(array('A',4), array('B',45),array('C',8),array('D',5),array('E',5),array('F',7),array('G',14),array('H',13),array('I',10),array('J',13),array('K',12),array('L',10),array('M',10),array('N',10),array('O',10),array('P',14),array('Q',10),array('R',12),array('S',14),array('T',10),array('U',10),array('V',14),array('W',14)));
			$this->newphpexcel->set_bold(array('A1','A2','A3','A4'));
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A1', 'REKAPITULASI HASIL PEMERIKSAAN SARANA')->setCellValue('A2',$judul)->setCellValue('A3', strtoupper($balai))->setCellValue('A4', 'PERIODE : '.$awal.' s.d '.$akhir);
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A6','No.')->setCellValue('B6','BB / BPOM')->setCellValue('C6','Jumlah')->setCellValue('G6','Rincian TMK (Sarana)')->setCellValue('M6','Tindak Lanjut (Sarana)')			
			->setCellValue('C7','Diperiksa')->setCellValue('D7','MK')->setCellValue('E7','TMK')->setCellValue('F7','Tutup')->setCellValue('G7','Memproduksi Produk TIE')->setCellValue('H7','Memproduksi BB')->setCellValue('I7','Aspek CPKB')->setCellValue('J7','Memproduksi TMK Penandaan')->setCellValue('K7','Administrasi Tidak Lengkap')->setCellValue('L7','DIP')->setCellValue('M7','Pembinaan')->setCellValue('N7','Perbaikan')->setCellValue('O7','Peringatan')->setCellValue('P7','Peringatan Keras')->setCellValue('Q7','Pemberhentian Sementara Kegiatan')->setCellValue('R7','Pembekuan')->setCellValue('S7','Penutupan')->setCellValue('T7','Penutupan Sementara Akses Online Kosmetik')->setCellValue('U7','Projusticia')->setCellValue('V7','Pencabutan Sertifikat CPKB')->setCellValue('W7','Rekomendasi Untuk Pencabutan Izin Produksi');
			$this->newphpexcel->headings(array('A6','B6','C6','D6','E6','F6','G6','H6','I6','J6','K6','L6','M6','N6','O6','P6','Q6','R6','S6','T6','U6','V6','W6','B7','C7','D7','E7','F7','G7','H7','I7','J7','K7','L7','M7','N7','O7','P7','Q7','R7','S7','T7','U7','V7','W7'));
			$this->newphpexcel->set_wrap(array('F7','G7','H7','I7','J7','K7','L7','M7','N7','O7','P7','Q7','R7','S7','T7','U7','V7','W7'));
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
															  ->setCellValue('G'.$rec,$row["TMKTIE"])
															  ->setCellValue('H'.$rec,$row["TMKBB"])
															  ->setCellValue('I'.$rec,$row["ASEPK_CPKB"])
															  ->setCellValue('J'.$rec,$row["TMKLABEL"])
															  ->setCellValue('K'.$rec,$row["ADMINISTRASI"])
															  ->setCellValue('L'.$rec,$row["DIP"])
															  ->setCellValue('M'.$rec,$row["PEMBINAAN"])
															  ->setCellValue('N'.$rec,$row["PERBAIKAN"])
															  ->setCellValue('O'.$rec,$row["PERINGATAN"])
															  ->setCellValue('P'.$rec,$row["PK"])
															  ->setCellValue('Q'.$rec,$row["PSK"])
															  ->setCellValue('R'.$rec,$row["PEMBEKUAN"])
															  ->setCellValue('S'.$rec,$row["PENUTUPAN"])
															  ->setCellValue('T'.$rec,$row["AKSES_ONLINE"])
															  ->setCellValue('U'.$rec,$row["PROJUSTICIA"])
															  ->setCellValue('V'.$rec,$row["SERT_CPKB"])
															  ->setCellValue('W'.$rec,$row["PIP"]);
					$this->newphpexcel->set_detilstyle(array('A'.$rec,'B'.$rec,'C'.$rec,'D'.$rec,'E'.$rec,'F'.$rec,'G'.$rec,'H'.$rec,'I'.$rec,'J'.$rec,'K'.$rec,'L'.$rec,'M'.$rec,'N'.$rec,'O'.$rec,'P'.$rec,'Q'.$rec,'R'.$rec,'S'.$rec,'T'.$rec,'U'.$rec,'V'.$rec,'W'.$rec));
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
					->setCellValue('W'.$rec,'=SUM(W8:W'.$total.')');
					$this->newphpexcel->set_detilstyle(array('A'.$rec,'B'.$rec,'C'.$rec,'D'.$rec,'E'.$rec,'F'.$rec,'G'.$rec,'H'.$rec,'I'.$rec,'J'.$rec,'K'.$rec,'L'.$rec,'M'.$rec,'N'.$rec,'O'.$rec,'P'.$rec,'Q'.$rec,'R'.$rec,'S'.$rec,'T'.$rec,'U'.$rec,'V'.$rec,'W'.$rec));
			}else{
				$this->newphpexcel->getActiveSheet()->mergeCells('A8:W8');
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