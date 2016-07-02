<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR);
class Rekapnew_act extends Model{	
	function set_produksi(){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$this->load->library('newphpexcel');
			$this->newphpexcel->set_font('Calibri',10);
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

			#Produksi Obat
			$qobat = "SELECT DISTINCT(REPLACE(REPLACE(C.NAMA_BBPOM,'BALAI BESAR POM', 'BBPOM'),'BALAI POM','BPOM')) AS NAMA_BBPOM,
					 (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE JENIS_SARANA_ID = '01OO' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS JMLPERIKSA,
					 (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'MK' AND JENIS_SARANA_ID = '01OO' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS JMLMK,
					 (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'Minor' AND JENIS_SARANA_ID = '01OO' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS JMLMAJOR,
					 (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'Major' AND JENIS_SARANA_ID = '01OO' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS JMLMINOR,
					 (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'Kritikal' AND JENIS_SARANA_ID = '01OO' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS JMLKRITIKAL,
					 (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = '' AND JENIS_SARANA_ID = '01OO' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS NULLNYA,
					 dbo.TL_CPOB('%Perbaikan%', A.BBPOM_ID,".$fawal.",".$fakhir.") AS PERBAIKAN,
					 dbo.TL_CPOB('%Peringatan', A.BBPOM_ID,".$fawal.",".$fakhir.") AS PERINGATAN,
					 dbo.TL_CPOB('%Peringatan Keras%', A.BBPOM_ID,".$fawal.",".$fakhir.") AS PK,
					 dbo.TL_CPOB('%Penghentian%', A.BBPOM_ID,".$fawal.",".$fakhir.") AS PSK,
					 dbo.TL_CPOB('%Pembekuan%', A.BBPOM_ID,".$fawal.",".$fakhir.") AS PEMBEKUAN,
					 dbo.TL_CPOB('%Pencabutan%', A.BBPOM_ID,".$fawal.",".$fakhir.") AS PENCABUTAN,
					 dbo.TL_CPOB('%Penarikan%', A.BBPOM_ID,".$fawal.",".$fakhir.") AS PENARIKAN
					 FROM T_PEMERIKSAAN A LEFT JOIN M_BBPOM C ON A.BBPOM_ID = C.BBPOM_ID WHERE A.JENIS_SARANA_ID = '01OO' $filter2 AND LEN(A.STATUS) > 2 ORDER BY 1";
			$judul = strtoupper($sipt->main->get_uraian("SELECT dbo.NAMA_JENIS_SARANA('01OO') AS JUDUL","JUDUL"));
			$this->newphpexcel->set_font('Calibri',10);
			$this->newphpexcel->setActiveSheetIndex(0);
			$this->newphpexcel->set_title('Produksi Obat');
			$this->newphpexcel->mergecell(array(array('A1','O1'),array('A2','O2'),array('A3','O3'),array('A4','O4'),array('A6','A7'),array('C6','H6'),array('I6','O6')), TRUE);
			$this->newphpexcel->mergecell(array(array('B6','B7')), FALSE);
			$this->newphpexcel->width(array(array('A',4), array('B',45),array('C',8),array('D',5),array('E',7),array('F',7),array('G',7),array('H',15),array('I',10),array('J',10),array('K',12),array('L',12),array('M',12),array('N',12),array('O',12)));
			$this->newphpexcel->set_bold(array('A1','A2','A3','A4'));
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A1', 'REKAPITULASI HASIL PEMERIKSAAN SARANA')->setCellValue('A2',$judul)->setCellValue('A3', strtoupper($balai))->setCellValue('A4', 'PERIODE : '.$awal.' s.d '.$akhir);
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A6','No.')->setCellValue('B6','BB / BPOM')->setCellValue('C6','Jumlah')->setCellValue('I6','Tindak Lanjut Terhadap Sarana')			
			->setCellValue('C7','Diperiksa')->setCellValue('D7','MK')->setCellValue('E7','Minor')->setCellValue('F7','Major')->setCellValue('G7','Kritikal')->setCellValue('H7','Tidak Ada Hasil')->setCellValue('I7','Perbaikan')->setCellValue('J7','Peringatan')->setCellValue('K7','Peringatan Keras')->setCellValue('L7','Penghentian Sementara Kegiatan')->setCellValue('M7','Pembekuan Sertifikat CPOB')->setCellValue('N7','Pencabutan Sertifikat')->setCellValue('O7','Penarikan Produk Jadi (Recall)');
			$this->newphpexcel->headings(array('A6','B6','C6','D6','E6','F6','G6','H6','I6','J6','K6','L6','M6','N6','O6','B7','C7','D7','E7','F7','G7','H7','I7','J7','K7','L7','M7','N7','O7'));
			$this->newphpexcel->set_wrap(array('F7','G7','H7','I7','J7','K7','L7','M7','N7','O7'));
			$dataobat = $sipt->main->get_result($qobat);
			if($dataobat){
				$no=1;
				$rec = 8;
				foreach($qobat->result_array() as $rowobat){
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A'.$rec,$no)
															  ->setCellValue('B'.$rec,$rowobat["NAMA_BBPOM"])
															  ->setCellValue('C'.$rec,$rowobat["JMLPERIKSA"])
															  ->setCellValue('D'.$rec,$rowobat["JMLMK"])
															  ->setCellValue('E'.$rec,$rowobat["JMLMAJOR"])
															  ->setCellValue('F'.$rec,$rowobat["JMLMINOR"])
															  ->setCellValue('G'.$rec,$rowobat["JMLKRITIKAL"])
															  ->setCellValue('H'.$rec,$rowobat["NULLNYA"])
															  ->setCellValue('I'.$rec,$rowobat["PERBAIKAN"])
															  ->setCellValue('J'.$rec,$rowobat["PERINGATAN"])
															  ->setCellValue('K'.$rec,$rowobat["PK"])
															  ->setCellValue('L'.$rec,$rowobat["PSK"])
															  ->setCellValue('M'.$rec,$rowobat["PEMBEKUAN"])
															  ->setCellValue('N'.$rec,$rowobat["PENCABUTAN"])
															  ->setCellValue('O'.$rec,$rowobat["PENARIKAN"]);
					$this->newphpexcel->set_detilstyle(array('A'.$rec,'B'.$rec,'C'.$rec,'D'.$rec,'E'.$rec,'F'.$rec,'G'.$rec,'H'.$rec,'I'.$rec,'J'.$rec,'K'.$rec,'L'.$rec,'M'.$rec,'N'.$rec,'O'.$rec));
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
					->setCellValue('O'.$rec,'=SUM(O8:O'.$total.')');
					$this->newphpexcel->set_detilstyle(array('A'.$rec,'B'.$rec,'C'.$rec,'D'.$rec,'E'.$rec,'F'.$rec,'G'.$rec,'H'.$rec,'I'.$rec,'J'.$rec,'K'.$rec,'L'.$rec,'M'.$rec,'N'.$rec,'O'.$rec));
			}else{
				$this->newphpexcel->getActiveSheet()->mergeCells('A8:N8');
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A8','Data Tidak Ditemukan');
				$this->newphpexcel->set_detilstyle(array('A8','B8','C8','D8','E8','F8','G8','H8','I8','J8','K8','L8','M8','N8','O8'));
			}
			#Akhir Produksi Obat
			
			#Produksi Napza
			$this->newphpexcel->createSheet();
			$qnapza = "SELECT DISTINCT(REPLACE(REPLACE(C.NAMA_BBPOM,'BALAI BESAR POM', 'BBPOM'),'BALAI POM','BPOM')) AS NAMA_BBPOM,(SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE JENIS_SARANA_ID = '01ON' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS JMLPERIKSA, (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'MK' AND JENIS_SARANA_ID = '01ON' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS JMLMK, (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'Minor' AND JENIS_SARANA_ID = '01ON' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS JMLMINOR, (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'Major' AND JENIS_SARANA_ID = '01ON' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS JMLMAJOR, (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'Kritikal' AND JENIS_SARANA_ID = '01ON' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS JMLKRITIKAL, (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = '' AND JENIS_SARANA_ID = '01ON' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS JMLNULL FROM T_PEMERIKSAAN A LEFT JOIN M_BBPOM C ON A.BBPOM_ID = C.BBPOM_ID WHERE A.JENIS_SARANA_ID = '01ON' $filter2 AND LEN(A.STATUS) > 2 ORDER BY 1";
			$judul = strtoupper($sipt->main->get_uraian("SELECT dbo.NAMA_JENIS_SARANA('01ON') AS JUDUL","JUDUL"));
			$this->newphpexcel->set_font('Calibri',10);
			$this->newphpexcel->setActiveSheetIndex(1);
			$this->newphpexcel->set_title('Produksi Obat-Pengawasan Napza');
			$this->newphpexcel->mergecell(array(array('A1','G1'),array('A2','G2'),array('A3','G3'),array('A4','G4'),array('A6','A7'),array('C6','G6')), TRUE);
			$this->newphpexcel->mergecell(array(array('B6','B7')), FALSE);
			$this->newphpexcel->width(array(array('A',4), array('B',45), array('H',15)));
			$this->newphpexcel->set_bold(array('A1','A2','A3','A4'));
			$this->newphpexcel->setActiveSheetIndex(1)->setCellValue('A1', 'REKAPITULASI HASIL PEMERIKSAAN SARANA')->setCellValue('A2',$judul)->setCellValue('A3', strtoupper($balai))->setCellValue('A4', 'PERIODE : '.$awal.' s.d '.$akhir);
			$this->newphpexcel->setActiveSheetIndex(1)->setCellValue('A6','No.')->setCellValue('B6','BB / BPOM')->setCellValue('C6','Jumlah')->setCellValue('C7','Diperiksa')->setCellValue('D7','MK')->setCellValue('E7','Minor')->setCellValue('F7','Major')->setCellValue('G7','Kritikal');
			$this->newphpexcel->headings(array('A6','B6','C6','D6','E6','F6','G6','B7','C7','D7','E7','F7','G7'));
			$datanapza = $sipt->main->get_result($qnapza);
			if($datanapza){
				$no=1;
				$rec = 8;
				foreach($qnapza->result_array() as $rownapza){
					$this->newphpexcel->setActiveSheetIndex(1)->setCellValue('A'.$rec,$no)
															  ->setCellValue('B'.$rec,$rownapza["NAMA_BBPOM"])
															  ->setCellValue('C'.$rec,$rownapza["JMLPERIKSA"])
															  ->setCellValue('D'.$rec,$rownapza["JMLMK"])
															  ->setCellValue('E'.$rec,$rownapza["JMLMINOR"])
															  ->setCellValue('F'.$rec,$rownapza["JMLMAJOR"])
															  ->setCellValue('G'.$rec,$rownapza["JMLKRITIKAL"]);
					$this->newphpexcel->set_detilstyle(array('A'.$rec,'B'.$rec,'C'.$rec,'D'.$rec,'E'.$rec,'F'.$rec,'G'.$rec));
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
					->setCellValue('G'.$rec,'=SUM(G8:G'.$total.')');
					$this->newphpexcel->set_detilstyle(array('A'.$rec,'B'.$rec,'C'.$rec,'D'.$rec,'E'.$rec,'F'.$rec,'G'.$rec));
			}else{
				$this->newphpexcel->getActiveSheet()->mergeCells('A8:G8');
				$this->newphpexcel->setActiveSheetIndex(1)->setCellValue('A8','Data Tidak Ditemukan');
				$this->newphpexcel->set_detilstyle(array('A8','B8','C8','D8','E8','F8','G8'));
			}
			#Akhir Produksi Napza
			
			#Produksi Obat Tradisional
			$this->newphpexcel->createSheet();
			$qot = " SELECT DISTINCT(REPLACE(REPLACE(C.NAMA_BBPOM,'BALAI BESAR POM', 'BBPOM'),'BALAI POM','BPOM')) AS NAMA_BBPOM,
			(SELECT COUNT(JENIS_SARANA_ID) FROM T_PEMERIKSAAN WHERE JENIS_SARANA_ID = '01HH' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS JMLPERIKSA,
			(SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'MK' AND JENIS_SARANA_ID = '01HH' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS MK,
			(SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'TMK' AND JENIS_SARANA_ID = '01HH' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS TMK, 
			(SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'TTP' AND JENIS_SARANA_ID = '01HH' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS TUTUP, 
			dbo.DETIL_TMK_CPOTB('%TIE%',A.BBPOM_ID,".$fawal.",".$fakhir.") AS TMKTIE, 
			dbo.DETIL_TMK_CPOTB('%BKO%',A.BBPOM_ID,".$fawal.",".$fakhir.") AS TMKBKO, 
			dbo.DETIL_TMK_CPOTB('%Penandaan%',A.BBPOM_ID,".$fawal.",".$fakhir.") AS TMKLABEL, 
			dbo.DETIL_TMK_CPOTB('%Aspek CPOTB%',A.BBPOM_ID,".$fawal.",".$fakhir.") AS ASPEKCPTOB, 
			dbo.DETIL_TMK_CPOTB('%Administrasi%',A.BBPOM_ID,".$fawal.",".$fakhir.") AS ADMINISTRASI,  
			dbo.DETIL_TMK_CPOTB('%Kadaluarsai%',A.BBPOM_ID,".$fawal.",".$fakhir.") AS KADALUARSA,  
			dbo.TL_CPOTB('%Pembinaan%', A.BBPOM_ID,".$fawal.",".$fakhir.") AS PEMBINAAN,  
			dbo.TL_CPOTB('%Perbaikan%', A.BBPOM_ID,".$fawal.",".$fakhir.") AS PERBAIKAN,  
			dbo.TL_CPOTB('%Peringatan', A.BBPOM_ID,".$fawal.",".$fakhir.") AS PERINGATAN,  
			dbo.TL_CPOTB('%Peringatan Keras%', A.BBPOM_ID,".$fawal.",".$fakhir.") AS PK,  
			dbo.TL_CPOTB('%Pemberhentian%', A.BBPOM_ID,".$fawal.",".$fakhir.") AS PSK,  
			dbo.TL_CPOTB('%Pembekuan%', A.BBPOM_ID,".$fawal.",".$fakhir.") AS PEMBEKUAN,
			dbo.TL_CPOTB('%NIE%', A.BBPOM_ID,".$fawal.",".$fakhir.") AS CABUT_NIE,    
			dbo.TL_CPOTB('%Izin Produksi%', A.BBPOM_ID,".$fawal.",".$fakhir.") AS PIP,  
			dbo.TL_CPOTB('%Projusticia%', A.BBPOM_ID,".$fawal.",".$fakhir.") AS PROJUSTICIA
			FROM T_PEMERIKSAAN A LEFT JOIN M_BBPOM C ON A.BBPOM_ID = C.BBPOM_ID WHERE A.JENIS_SARANA_ID = '01HH' $filter2  AND LEN(A.STATUS) > 2 ORDER BY 1";
			
			$judul = strtoupper($sipt->main->get_uraian("SELECT dbo.NAMA_JENIS_SARANA('01HH') AS JUDUL","JUDUL"));
			$this->newphpexcel->set_font('Calibri',10);
			$this->newphpexcel->setActiveSheetIndex(2);
			$this->newphpexcel->set_title('Produksi Obat Tradisional');
			$this->newphpexcel->mergecell(array(array('A1','U1'),array('A2','U2'),array('A3','U3'),array('A4','U4'),array('A6','A7'),array('C6','F6'),array('G6','L6'),array('M6','U6')), TRUE);
			$this->newphpexcel->mergecell(array(array('B6','B7')), FALSE);
			$this->newphpexcel->width(array(array('A',4), array('B',45),array('C',8),array('D',5),array('E',5),array('F',6),array('G',6),array('H',6),array('I',8),array('J',11),array('K',11),array('L',10),array('M',10),array('N',10),array('O',10),array('P',13),array('Q',10),array('R',12),array('S',12),array('T',10)));
			$this->newphpexcel->set_bold(array('A1','A2','A3','A4'));
			$this->newphpexcel->setActiveSheetIndex(2)->setCellValue('A1', 'REKAPITULASI HASIL PEMERIKSAAN SARANA')->setCellValue('A2',$judul)->setCellValue('A3', strtoupper($balai))->setCellValue('A4', 'PERIODE : '.$awal.' s.d '.$akhir);
			$this->newphpexcel->setActiveSheetIndex(2)->setCellValue('A6','No.')->setCellValue('B6','BB / BPOM')->setCellValue('C6','Jumlah')->setCellValue('G6','Rincian TMK (Sarana)')->setCellValue('M6','Tindak Lanjut (Sarana)')
			->setCellValue('C7','Diperiksa')->setCellValue('D7','MK')->setCellValue('E7','TMK')->setCellValue('F7','Tutup')->setCellValue('G7','TIE')->setCellValue('H7','BKO')->setCellValue('I7','Aspek CPOTB')->setCellValue('J7','Penandaan')->setCellValue('K7','Administrasi')->setCellValue('L7','Kadaluarsa / Rusak')->setCellValue('M7','Pembinaan')->setCellValue('N7','Perbaikan')->setCellValue('O7','Peringatan')->setCellValue('P7','Peringatan Keras')->setCellValue('Q7','Pemberhentian Sementara Kegiatan')->setCellValue('R7','Pembekuan Sertifikat CPOTB')->setCellValue('S7','Rekomendasi Pencabutan Izin Produksi')->setCellValue('T7','Rekomendasi Pencabutan NIE')->setCellValue('U7','Projusticia');
			$this->newphpexcel->headings(array('A6','B6','C6','D6','E6','F6','G6','H6','I6','J6','K6','L6','M6','N6','O6','P6','Q6','R6','S6','T6','U6','B7','C7','D7','E7','F7','G7','H7','I7','J7','K7','L7','M7','N7','O7','P7','Q7','R7','S7','S7','T7','U7'));
			$this->newphpexcel->set_wrap(array('F7','G7','H7','I7','J7','K7','L7','M7','N7','O7','P7','Q7','R7','S7','T7','U7'));
			$dataot = $sipt->main->get_result($qot);
			if($dataot){
				$no=1;
				$rec = 8;
				foreach($qot->result_array() as $rowot){
					$this->newphpexcel->setActiveSheetIndex(2)->setCellValue('A'.$rec,$no)
															  ->setCellValue('B'.$rec,$rowot["NAMA_BBPOM"])
															  ->setCellValue('C'.$rec,$rowot["JMLPERIKSA"])
															  ->setCellValue('D'.$rec,$rowot["MK"])
															  ->setCellValue('E'.$rec,$rowot["TMK"])
															  ->setCellValue('F'.$rec,$rowot["TUTUP"])
															  ->setCellValue('G'.$rec,$rowot["TMKTIE"])
															  ->setCellValue('H'.$rec,$rowot["TMKBKO"])
															  ->setCellValue('I'.$rec,$rowot["ASPEKCPOTB"])
															  ->setCellValue('J'.$rec,$rowot["TMKLABEL"])
															  ->setCellValue('K'.$rec,$rowot["ADMINISTRASI"])
															  ->setCellValue('L'.$rec,$rowot["KADALUARSA"])
															  ->setCellValue('M'.$rec,$rowot["PEMBINAAN"])
															  ->setCellValue('N'.$rec,$rowot["PERBAIKAN"])
															  ->setCellValue('O'.$rec,$rowot["PERINGATAN"])
															  ->setCellValue('P'.$rec,$rowot["PK"])
															  ->setCellValue('Q'.$rec,$rowot["PSK"])
															  ->setCellValue('R'.$rec,$rowot["PEMBEKUAN"])
															  ->setCellValue('S'.$rec,$rowot["CABUT_NIE"])
															  ->setCellValue('T'.$rec,$rowot["PIP"])
															  ->setCellValue('U'.$rec,$rowot["PROJUSTICIA"]);
					$this->newphpexcel->set_detilstyle(array('A'.$rec,'B'.$rec,'C'.$rec,'D'.$rec,'E'.$rec,'F'.$rec,'G'.$rec,'H'.$rec,'I'.$rec,'J'.$rec,'K'.$rec,'L'.$rec,'M'.$rec,'N'.$rec,'O'.$rec,'P'.$rec,'Q'.$rec,'R'.$rec,'S'.$rec,'T'.$rec,'U'.$rec));
					$rec++;
					$no++;
				}
				$total = $rec - 1;
				$this->newphpexcel->setActiveSheetIndex(2)->setCellValue('A'.$rec,$no)
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
					->setCellValue('T'.$rec,'=SUM(S8:T'.$total.')')
					->setCellValue('U'.$rec,'=SUM(S8:U'.$total.')');
					$this->newphpexcel->set_detilstyle(array('A'.$rec,'B'.$rec,'C'.$rec,'D'.$rec,'E'.$rec,'F'.$rec,'G'.$rec,'H'.$rec,'I'.$rec,'J'.$rec,'K'.$rec,'L'.$rec,'M'.$rec,'N'.$rec,'O'.$rec,'P'.$rec,'Q'.$rec,'R'.$rec,'S'.$rec,'T'.$rec,'U'.$rec));

			}else{
				$this->newphpexcel->getActiveSheet()->mergeCells('A8:U8');
				$this->newphpexcel->setActiveSheetIndex(2)->setCellValue('A8','Data Tidak Ditemukan');
				$this->newphpexcel->set_detilstyle(array('A8','B8','C8','D8','E8','F8','G8','H8','I8','J8','K8','L8','M8','N8','O8','P8','Q8','R8','S8','T8','U8'));
			}
			#Akhir Produksi Obat Tradisional
			
			#Produksi Kosmetik
			$this->newphpexcel->createSheet();
			$qkos = " SELECT DISTINCT(REPLACE(REPLACE(C.NAMA_BBPOM,'BALAI BESAR POM', 'BBPOM'),'BALAI POM','BPOM')) AS NAMA_BBPOM,
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
			$judul = strtoupper($sipt->main->get_uraian("SELECT dbo.NAMA_JENIS_SARANA('01KO') AS JUDUL","JUDUL"));
			$this->newphpexcel->set_font('Calibri',10);
			$this->newphpexcel->setActiveSheetIndex(3);
			$this->newphpexcel->set_title('Produksi Kosmetik');
			$this->newphpexcel->mergecell(array(array('A1','W1'),array('A2','W2'),array('A3','W3'),array('A4','W4'),array('A6','A7'),array('C6','F6'),array('G6','L6'),array('M6','W6')), TRUE);
			$this->newphpexcel->mergecell(array(array('B6','B7')), FALSE);
			$this->newphpexcel->width(array(array('A',4), array('B',45),array('C',8),array('D',5),array('E',5),array('F',7),array('G',14),array('H',13),array('I',10),array('J',13),array('K',12),array('L',10),array('M',10),array('N',10),array('O',10),array('P',14),array('Q',10),array('R',12),array('S',14),array('T',10),array('U',10),array('V',14),array('W',14)));
			$this->newphpexcel->set_bold(array('A1','A2','A3','A4'));
			$this->newphpexcel->setActiveSheetIndex(3)->setCellValue('A1', 'REKAPITULASI HASIL PEMERIKSAAN SARANA')->setCellValue('A2',$judul)->setCellValue('A3', strtoupper($balai))->setCellValue('A4', 'PERIODE : '.$awal.' s.d '.$akhir);
			$this->newphpexcel->setActiveSheetIndex(3)->setCellValue('A6','No.')->setCellValue('B6','BB / BPOM')->setCellValue('C6','Jumlah')->setCellValue('G6','Rincian TMK (Sarana)')->setCellValue('M6','Tindak Lanjut (Sarana)')			
			->setCellValue('C7','Diperiksa')->setCellValue('D7','MK')->setCellValue('E7','TMK')->setCellValue('F7','Tutup')->setCellValue('G7','Memproduksi Produk TIE')->setCellValue('H7','Memproduksi BB')->setCellValue('I7','Aspek CPKB')->setCellValue('J7','Memproduksi TMK Penandaan')->setCellValue('K7','Administrasi Tidak Lengkap')->setCellValue('L7','DIP')->setCellValue('M7','Pembinaan')->setCellValue('N7','Perbaikan')->setCellValue('O7','Peringatan')->setCellValue('P7','Peringatan Keras')->setCellValue('Q7','Pemberhentian Sementara Kegiatan')->setCellValue('R7','Pembekuan')->setCellValue('S7','Penutupan')->setCellValue('T7','Penutupan Sementara Akses Online Kosmetik')->setCellValue('U7','Projusticia')->setCellValue('V7','Pencabutan Sertifikat CPKB')->setCellValue('W7','Rekomendasi Untuk Pencabutan Izin Produksi');
			$this->newphpexcel->headings(array('A6','B6','C6','D6','E6','F6','G6','H6','I6','J6','K6','L6','M6','N6','O6','P6','Q6','R6','S6','T6','U6','V6','W6','B7','C7','D7','E7','F7','G7','H7','I7','J7','K7','L7','M7','N7','O7','P7','Q7','R7','S7','T7','U7','V7','W7'));
			$this->newphpexcel->set_wrap(array('F7','G7','H7','I7','J7','K7','L7','M7','N7','O7','P7','Q7','R7','S7','T7','U7','V7','W7'));
			$datakos = $sipt->main->get_result($qkos);
			if($datakos){
				$no=1;
				$rec = 8;
				foreach($qkos->result_array() as $rowkos){
					$this->newphpexcel->setActiveSheetIndex(3)->setCellValue('A'.$rec,$no)
															  ->setCellValue('B'.$rec,$rowkos["NAMA_BBPOM"])
															  ->setCellValue('C'.$rec,$rowkos["JMLPERIKSA"])
															  ->setCellValue('D'.$rec,$rowkos["MK"])
															  ->setCellValue('E'.$rec,$rowkos["TMK"])
															  ->setCellValue('F'.$rec,$rowkos["TUTUP"])
															  ->setCellValue('G'.$rec,$rowkos["TMKTIE"])
															  ->setCellValue('H'.$rec,$rowkos["TMKBB"])
															  ->setCellValue('I'.$rec,$rowkos["ASEPK_CPKB"])
															  ->setCellValue('J'.$rec,$rowkos["TMKLABEL"])
															  ->setCellValue('K'.$rec,$rowkos["ADMINISTRASI"])
															  ->setCellValue('L'.$rec,$rowkos["DIP"])
															  ->setCellValue('M'.$rec,$rowkos["PEMBINAAN"])
															  ->setCellValue('N'.$rec,$rowkos["PERBAIKAN"])
															  ->setCellValue('O'.$rec,$rowkos["PERINGATAN"])
															  ->setCellValue('P'.$rec,$rowkos["PK"])
															  ->setCellValue('Q'.$rec,$rowkos["PSK"])
															  ->setCellValue('R'.$rec,$rowkos["PEMBEKUAN"])
															  ->setCellValue('S'.$rec,$rowkos["PENUTUPAN"])
															  ->setCellValue('T'.$rec,$rowkos["AKSES_ONLINE"])
															  ->setCellValue('U'.$rec,$rowkos["PROJUSTICIA"])
															  ->setCellValue('V'.$rec,$rowkos["SERT_CPKB"])
															  ->setCellValue('W'.$rec,$rowkos["PIP"]);
					$this->newphpexcel->set_detilstyle(array('A'.$rec,'B'.$rec,'C'.$rec,'D'.$rec,'E'.$rec,'F'.$rec,'G'.$rec,'H'.$rec,'I'.$rec,'J'.$rec,'K'.$rec,'L'.$rec,'M'.$rec,'N'.$rec,'O'.$rec,'P'.$rec,'Q'.$rec,'R'.$rec,'S'.$rec,'T'.$rec,'U'.$rec,'V'.$rec,'W'.$rec));
					$rec++;
					$no++;
				}
				$total = $rec - 1;
				$this->newphpexcel->setActiveSheetIndex(3)->setCellValue('A'.$rec,$no)
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
				$this->newphpexcel->setActiveSheetIndex(3)->setCellValue('A8','Data Tidak Ditemukan');
				$this->newphpexcel->set_detilstyle(array('A8','B8','C8','D8','E8','F8','G8','H8','I8','J8','K8','L8','M8','N8','O8','P8','Q8','R8','S8','T8','U8','V8','W8'));
			}
			#Akhir Produksi Kosmetik
			
			#Produksi SM
			$this->newphpexcel->createSheet();
			$qsm = " SELECT DISTINCT(REPLACE(REPLACE(C.NAMA_BBPOM,'BALAI BESAR POM', 'BBPOM'),'BALAI POM','BPOM')) AS NAMA_BBPOM,
			(SELECT COUNT(JENIS_SARANA_ID) FROM T_PEMERIKSAAN WHERE JENIS_SARANA_ID = '01PK' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS JMLPERIKSA,
			(SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'MK' AND JENIS_SARANA_ID = '01PK' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS MK,
			(SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'TMK' AND JENIS_SARANA_ID = '01PK' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS TMK, 
			(SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'TTP' AND JENIS_SARANA_ID = '01PK' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS TUTUP, 
			dbo.DETIL_TMK_CPPKB('%TIE%',A.BBPOM_ID,".$fawal.",".$fakhir.") AS TMKTIE, 
			dbo.DETIL_TMK_CPPKB('%BKO%',A.BBPOM_ID,".$fawal.",".$fakhir.") AS TMKBKO, 
			dbo.DETIL_TMK_CPPKB('%Penandaan%',A.BBPOM_ID,".$fawal.",".$fakhir.") AS TMKLABEL, 
			dbo.DETIL_TMK_CPPKB('%Aspek CPPKB%',A.BBPOM_ID,".$fawal.",".$fakhir.") AS ASPEKCPTOB, 
			dbo.DETIL_TMK_CPPKB('%Administrasi%',A.BBPOM_ID,".$fawal.",".$fakhir.") AS ADMINISTRASI,  
			dbo.DETIL_TMK_CPPKB('%Kadaluarsai%',A.BBPOM_ID,".$fawal.",".$fakhir.") AS KADALUARSA,  
			dbo.TL_CPPKB('%Pembinaan%', A.BBPOM_ID,".$fawal.",".$fakhir.") AS PEMBINAAN,  
			dbo.TL_CPPKB('%Perbaikan%', A.BBPOM_ID,".$fawal.",".$fakhir.") AS PERBAIKAN,  
			dbo.TL_CPPKB('%Peringatan', A.BBPOM_ID,".$fawal.",".$fakhir.") AS PERINGATAN,  
			dbo.TL_CPPKB('%Peringatan Keras%', A.BBPOM_ID,".$fawal.",".$fakhir.") AS PK,  
			dbo.TL_CPPKB('%Pemberhentian%', A.BBPOM_ID,".$fawal.",".$fakhir.") AS PSK,  
			dbo.TL_CPPKB('%Pembekuan%', A.BBPOM_ID,".$fawal.",".$fakhir.") AS PEMBEKUAN,
			dbo.TL_CPPKB('%NIE%', A.BBPOM_ID,".$fawal.",".$fakhir.") AS CABUT_NIE,    
			dbo.TL_CPPKB('%Izin Produksi%', A.BBPOM_ID,".$fawal.",".$fakhir.") AS PIP,  
			dbo.TL_CPPKB('%Projusticia%', A.BBPOM_ID,".$fawal.",".$fakhir.") AS PROJUSTICIA
			FROM T_PEMERIKSAAN A LEFT JOIN M_BBPOM C ON A.BBPOM_ID = C.BBPOM_ID WHERE A.JENIS_SARANA_ID = '01PK' $filter2  AND LEN(A.STATUS) > 2 ORDER BY 1";
			$judul = strtoupper($sipt->main->get_uraian("SELECT dbo.NAMA_JENIS_SARANA('01PK') AS JUDUL","JUDUL"));
			$this->newphpexcel->set_font('Calibri',10);
			$this->newphpexcel->setActiveSheetIndex(4);
			$this->newphpexcel->set_title('Produksi Suplemen Makanan');
			$this->newphpexcel->mergecell(array(array('A1','U1'),array('A2','U2'),array('A3','U3'),array('A4','U4'),array('A6','A7'),array('C6','F6'),array('G6','L6'),array('M6','U6')), TRUE);
			$this->newphpexcel->mergecell(array(array('B6','B7')), FALSE);
			$this->newphpexcel->width(array(array('A',4), array('B',45),array('C',8),array('D',5),array('E',5),array('F',6),array('G',6),array('H',6),array('I',8),array('J',11),array('K',11),array('L',10),array('M',10),array('N',10),array('O',10),array('P',13),array('Q',10),array('R',12),array('S',12),array('T',10)));
			$this->newphpexcel->set_bold(array('A1','A2','A3','A4'));
			$this->newphpexcel->setActiveSheetIndex(4)->setCellValue('A1', 'REKAPITULASI HASIL PEMERIKSAAN SARANA')->setCellValue('A2',$judul)->setCellValue('A3', strtoupper($balai))->setCellValue('A4', 'PERIODE : '.$awal.' s.d '.$akhir);
			$this->newphpexcel->setActiveSheetIndex(4)->setCellValue('A6','No.')->setCellValue('B6','BB / BPOM')->setCellValue('C6','Jumlah')->setCellValue('G6','Rincian TMK (Sarana)')->setCellValue('L6','Tindak Lanjut (Sarana)')
			->setCellValue('C7','Diperiksa')->setCellValue('D7','MK')->setCellValue('E7','TMK')->setCellValue('F7','Tutup')->setCellValue('G7','TIE')->setCellValue('H7','BKO')->setCellValue('I7','Aspek CPOB / CPOTB / CPMB')->setCellValue('J7','Penandaan')->setCellValue('K7','Administrasi')->setCellValue('L7','Kadaluarsa / Rusak')->setCellValue('M7','Pembinaan')->setCellValue('N7','Perbaikan')->setCellValue('O7','Peringatan')->setCellValue('P7','Peringatan Keras')->setCellValue('Q7','Pemberhentian Sementara Kegiatan')->setCellValue('R7','Pembekuan Sertifikat CPOB / CPOTB / CPMB')->setCellValue('S7','Rekomendasi Pencabutan Izin Produksi')->setCellValue('T7','Rekomendasi Pencabutan NIE')->setCellValue('U7','Projusticia');
			$this->newphpexcel->headings(array('A6','B6','C6','D6','E6','F6','G6','H6','I6','J6','K6','L6','M6','N6','O6','P6','Q6','R6','S6','T6','U6','B7','C7','D7','E7','F7','G7','H7','I7','J7','K7','L7','M7','N7','O7','P7','Q7','R7','S7','S7','T7','U7'));
			$this->newphpexcel->set_wrap(array('F7','G7','H7','I7','J7','K7','L7','M7','N7','O7','P7','Q7','R7','S7','T7','U7'));
			$datasm = $sipt->main->get_result($qsm);
			if($datasm){
				$no=1;
				$rec = 8;
				foreach($qsm->result_array() as $rowsm){
					$this->newphpexcel->setActiveSheetIndex(4)->setCellValue('A'.$rec,$no)
															  ->setCellValue('B'.$rec,$rowsm["NAMA_BBPOM"])
															  ->setCellValue('C'.$rec,$rowsm["JMLPERIKSA"])
															  ->setCellValue('D'.$rec,$rowsm["MK"])
															  ->setCellValue('E'.$rec,$rowsm["TMK"])
															  ->setCellValue('F'.$rec,$rowsm["TUTUP"])
															  ->setCellValue('G'.$rec,$rowsm["TMKTIE"])
															  ->setCellValue('H'.$rec,$rowsm["TMKBKO"])
															  ->setCellValue('I'.$rec,$rowsm["ASPEKCPOTB"])
															  ->setCellValue('J'.$rec,$rowsm["TMKLABEL"])
															  ->setCellValue('K'.$rec,$rowsm["ADMINISTRASI"])
															  ->setCellValue('L'.$rec,$rowsm["KADALUARSA"])
															  ->setCellValue('M'.$rec,$rowsm["PEMBINAAN"])
															  ->setCellValue('N'.$rec,$rowsm["PERBAIKAN"])
															  ->setCellValue('O'.$rec,$rowsm["PERINGATAN"])
															  ->setCellValue('P'.$rec,$rowsm["PK"])
															  ->setCellValue('Q'.$rec,$rowsm["PSK"])
															  ->setCellValue('R'.$rec,$rowsm["PEMBEKUAN"])
															  ->setCellValue('S'.$rec,$rowsm["CABUT_NIE"])
															  ->setCellValue('T'.$rec,$rowsm["PIP"])
															  ->setCellValue('U'.$rec,$rowsm["PROJUSTICIA"]);
					$this->newphpexcel->set_detilstyle(array('A'.$rec,'B'.$rec,'C'.$rec,'D'.$rec,'E'.$rec,'F'.$rec,'G'.$rec,'H'.$rec,'I'.$rec,'J'.$rec,'K'.$rec,'L'.$rec,'M'.$rec,'N'.$rec,'O'.$rec,'P'.$rec,'Q'.$rec,'R'.$rec,'S'.$rec,'T'.$rec,'U'.$rec));
					$rec++;
					$no++;
				}
				$total = $rec - 1;
				$this->newphpexcel->setActiveSheetIndex(4)->setCellValue('A'.$rec,$no)
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
					->setCellValue('U'.$rec,'=SUM(U8:U'.$total.')');
					$this->newphpexcel->set_detilstyle(array('A'.$rec,'B'.$rec,'C'.$rec,'D'.$rec,'E'.$rec,'F'.$rec,'G'.$rec,'H'.$rec,'I'.$rec,'J'.$rec,'K'.$rec,'L'.$rec,'M'.$rec,'N'.$rec,'O'.$rec,'P'.$rec,'Q'.$rec,'R'.$rec,'S'.$rec,'T'.$rec,'U'.$rec));
			}else{
				$this->newphpexcel->getActiveSheet()->mergeCells('A8:U8');
				$this->newphpexcel->setActiveSheetIndex(4)->setCellValue('A8','Data Tidak Ditemukan');
				$this->newphpexcel->set_detilstyle(array('A8','B8','C8','D8','E8','F8','G8','H8','I8','J8','K8','L8','M8','N8','O8','P8','Q8','R8','S8','T8','U8'));
			}
			#Akhir Produksi SM
			
			#Pangan MD
			$this->newphpexcel->createSheet();
			$qmd = "SELECT DISTINCT(REPLACE(REPLACE(C.NAMA_BBPOM,'BALAI BESAR POM', 'BBPOM'),'BALAI POM','BPOM')) AS NAMA_BBPOM, 
					 (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE JENIS_SARANA_ID = '01JJ' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS JMLPERIKSA,
					 (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'A' AND JENIS_SARANA_ID = '01JJ' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS A,
					 (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'B' AND JENIS_SARANA_ID = '01JJ' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS B, 
					 (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'C' AND JENIS_SARANA_ID = '01JJ' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS C,
					 (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'D' AND JENIS_SARANA_ID = '01JJ' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS D,
					 (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'TTP' AND JENIS_SARANA_ID = '01JJ' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS TTP,
					 (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'TDP' AND JENIS_SARANA_ID = '01JJ' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS NOL
					 FROM T_PEMERIKSAAN A LEFT JOIN M_BBPOM C ON A.BBPOM_ID = C.BBPOM_ID WHERE A.JENIS_SARANA_ID = '01JJ' $filter2 AND LEN(A.STATUS) > 2 ORDER BY 1"; 
			$judul = strtoupper($sipt->main->get_uraian("SELECT dbo.NAMA_JENIS_SARANA('01JJ') AS JUDUL","JUDUL"));
			$this->newphpexcel->set_font('Calibri',10);
			$this->newphpexcel->setActiveSheetIndex(5);
			$this->newphpexcel->set_title('Produksi Pangan MD');
			$this->newphpexcel->mergecell(array(array('A1','I1'),array('A2','I2'),array('A3','I3'),array('A4','I4'),array('A6','A7'),array('C6','I6')), TRUE);
			$this->newphpexcel->mergecell(array(array('B6','B7')), FALSE);
			$this->newphpexcel->width(array(array('A',4), array('B',45),array('C',8),array('D',8),array('E',8),array('F',8),array('G',8),array('H',8),array('I',15)));
			$this->newphpexcel->set_bold(array('A1','A2','A3','A4'));
			$this->newphpexcel->setActiveSheetIndex(5)->setCellValue('A1', 'REKAPITULASI HASIL PEMERIKSAAN SARANA')->setCellValue('A2',$judul)->setCellValue('A3', strtoupper($balai))->setCellValue('A4', 'PERIODE : '.$awal.' s.d '.$akhir);
			$this->newphpexcel->setActiveSheetIndex(5)->setCellValue('A6','No.')->setCellValue('B6','BB / BPOM')->setCellValue('C6','Jumlah')->setCellValue('C7','Diperiksa')->setCellValue('D7','A (Baik Sekali)')->setCellValue('E7','B (Baik)')->setCellValue('F7','C (Cukup)')->setCellValue('G7','D (Jelek)')->setCellValue('H7','Tutup')->setCellValue('I7','Tidak Dapat Diperiksa');
			$this->newphpexcel->headings(array('A6','B6','C6','D6','E6','F6','B7','C7','D7','E7','F7','G6','G7','H6','H7','I6','I7'));
			$datamd = $sipt->main->get_result($qmd);
			if($datamd){
				$no=1;
				$rec = 8;
				foreach($qmd->result_array() as $rowmd){
					$this->newphpexcel->setActiveSheetIndex(5)->setCellValue('A'.$rec,$no)
															  ->setCellValue('B'.$rec,$rowmd["NAMA_BBPOM"])
															  ->setCellValue('C'.$rec,$rowmd["JMLPERIKSA"])
															  ->setCellValue('D'.$rec,$rowmd["A"])
															  ->setCellValue('E'.$rec,$rowmd["B"])
															  ->setCellValue('F'.$rec,$rowmd["C"])
															  ->setCellValue('G'.$rec,$rowmd["D"])
															  ->setCellValue('H'.$rec,$rowmd["TTP"])
															  ->setCellValue('I'.$rec,$rowmd["NOL"]);
					$this->newphpexcel->set_detilstyle(array('A'.$rec,'B'.$rec,'C'.$rec,'D'.$rec,'E'.$rec,'F'.$rec,'G'.$rec,'H'.$rec,'I'.$rec));
					$rec++;
					$no++;
				}
				$total = $rec - 1;
				$this->newphpexcel->setActiveSheetIndex(5)->setCellValue('A'.$rec,$no)
					->setCellValue('B'.$rec,'Jumlah')
					->setCellValue('C'.$rec,'=SUM(C8:C'.$total.')')
					->setCellValue('D'.$rec,'=SUM(D8:D'.$total.')')
					->setCellValue('E'.$rec,'=SUM(E8:E'.$total.')')
					->setCellValue('F'.$rec,'=SUM(F8:F'.$total.')')
					->setCellValue('G'.$rec,'=SUM(G8:G'.$total.')')
					->setCellValue('H'.$rec,'=SUM(H8:H'.$total.')')
					->setCellValue('I'.$rec,'=SUM(I8:I'.$total.')');
					$this->newphpexcel->set_detilstyle(array('A'.$rec,'B'.$rec,'C'.$rec,'D'.$rec,'E'.$rec,'F'.$rec,'G'.$rec,'H'.$rec,'I'.$rec));
			}else{
				$this->newphpexcel->getActiveSheet()->mergeCells('A8:I8');
				$this->newphpexcel->setActiveSheetIndex(5)->setCellValue('A8','Data Tidak Ditemukan');
				$this->newphpexcel->set_detilstyle(array('A8','B8','C8','D8','E8','F8','G8','H8','I8'));
			}
			#Akhir Pangan MD
			
			#Pangan IRT
			$this->newphpexcel->createSheet();
			$qirt = "SELECT DISTINCT(REPLACE(REPLACE(C.NAMA_BBPOM,'BALAI BESAR POM', 'BBPOM'),'BALAI POM','BPOM')) AS NAMA_BBPOM, 
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
			$judul = strtoupper($sipt->main->get_uraian("SELECT dbo.NAMA_JENIS_SARANA('01VV') AS JUDUL","JUDUL"));
			$this->newphpexcel->set_font('Calibri',10);
			$this->newphpexcel->setActiveSheetIndex(6);
			$this->newphpexcel->set_title('Produksi Pangan IRT');
			$this->newphpexcel->mergecell(array(array('A1','L1'),array('A2','L2'),array('A3','L3'),array('A4','L4'),array('A6','A7'),array('C6','C7'),array('D6','D7'),array('E6','E7'),array('G6','L6'), array('F6','F7')), TRUE);
			$this->newphpexcel->mergecell(array(array('B6','B7')), FALSE);
			$this->newphpexcel->width(array(array('A',4), array('B',45),array('C',7),array('D',6),array('E',6),array('F',8),array('G',10),array('H',13),array('I',13),array('J',11),array('K',10),array('L',11)));
			$this->newphpexcel->set_bold(array('A1','A2','A3','A4'));
			$this->newphpexcel->setActiveSheetIndex(6)->setCellValue('A1', 'REKAPITULASI HASIL PEMERIKSAAN SARANA')->setCellValue('A2',$judul)->setCellValue('A3', strtoupper($balai))->setCellValue('A4', 'PERIODE : '.$awal.' s.d '.$akhir);
			$this->newphpexcel->setActiveSheetIndex(6)->setCellValue('A6','No.')->setCellValue('B6','BB / BPOM')->setCellValue('C6','Jumlah')->setCellValue('D6','BAIK')->setCellValue('E6','CUKUP')->setCellValue('F6','KURANG')->setCellValue('G6','Tindak Lanjut')->setCellValue('G7','Pembinaan')->setCellValue('H7','Surat Peringatan')->setCellValue('I7','Pencabutan Nomor Pendaftaran')->setCellValue('J7','Pengamanan')->setCellValue('K7','Perintah Penarikan')->setCellValue('L7','Pemusnahan');
			$this->newphpexcel->headings(array('A6','B6','C6','D6','E6','F6','G6','H6','I6','J6','K6','L6','B7','C7','D7','E7','F7','G7','H7','I7','J7','K7','L7'));
			$this->newphpexcel->set_wrap(array('G7','H7','I7','J7','K7','L7'));
			$datairt = $sipt->main->get_result($qirt);
			if($datairt){
				$no=1;
				$rec = 8;
				foreach($qirt->result_array() as $rowirt){
					$this->newphpexcel->setActiveSheetIndex(6)->setCellValue('A'.$rec,$no)
															  ->setCellValue('B'.$rec,$rowirt["NAMA_BBPOM"])
															  ->setCellValue('C'.$rec,$rowirt["JMLPERIKSA"])
															  ->setCellValue('D'.$rec,$rowirt["BAIK"])
															  ->setCellValue('E'.$rec,$rowirt["CUKUP"])
															  ->setCellValue('F'.$rec,$rowirt["KURANG"])
															  ->setCellValue('G'.$rec,$rowirt["PEMBINAAN"])
															  ->setCellValue('H'.$rec,$rowirt["SP"])
															  ->setCellValue('I'.$rec,$rowirt["PNP"])
															  ->setCellValue('J'.$rec,$rowirt["PENGAMANAN"])
															  ->setCellValue('K'.$rec,$rowirt["PP"])
															  ->setCellValue('L'.$rec,$rowirt["PEMUSNAHAN"]);
					$this->newphpexcel->set_detilstyle(array('A'.$rec,'B'.$rec,'C'.$rec,'D'.$rec,'E'.$rec,'F'.$rec,'G'.$rec,'H'.$rec,'I'.$rec,'J'.$rec,'K'.$rec,'L'.$rec));
					$rec++;
					$no++;
				}
				$total = $rec - 1;
				$this->newphpexcel->setActiveSheetIndex(6)->setCellValue('A'.$rec,$no)
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
				$this->newphpexcel->setActiveSheetIndex(6)->setCellValue('A8','Data Tidak Ditemukan');
				$this->newphpexcel->set_detilstyle(array('A8','B8','C8','D8','E8','F8','G8','H8','I8','J8','K8','L8'));
			}
			#Akhir Pangan IRT
			ob_clean();
			$file = "RHPK_DATA_PRODUKSI.xls";
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
	
	function set_distribusi(){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$this->load->library('newphpexcel');
			$this->newphpexcel->set_font('Calibri',10);
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
			
			#Distribusi PBF dan PBBBF
			$arrobat = array("02LL" => "Distribusi PBBBF","02MM" => "Distribusi PBF", "02TF" => "Gudang Farmasi Kabupaten");
			$idxobat = 0;
			foreach($arrobat as $idobat => $urobat){
				$this->newphpexcel->createSheet();
				$qobat = "SELECT (REPLACE(REPLACE(C.NAMA_BBPOM,'BALAI BESAR POM DI ', ''),'BALAI POM DI ','')) AS NAMA_BBPOM,
				(SELECT COUNT(JENIS_SARANA_ID) FROM T_PEMERIKSAAN WHERE JENIS_SARANA_ID = '".$idobat."' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS JMLPERIKSA,
				(SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'MK' AND JENIS_SARANA_ID = '".$idobat."' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS MK,
				(SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'TMK' AND JENIS_SARANA_ID = '".$idobat."' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS TMK, 
				(SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'TTP' AND JENIS_SARANA_ID = '".$idobat."' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS TUTUP, 
				(SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'TDP' AND JENIS_SARANA_ID = '".$idobat."' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS TDP, 
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
				WHERE A.JENIS_SARANA_ID = '".$idobat."' $filter2 AND LEN(A.STATUS) > 2 GROUP BY C.BBPOM_ID, C.NAMA_BBPOM ORDER BY 1";
				$judul = strtoupper($sipt->main->get_uraian("SELECT dbo.NAMA_JENIS_SARANA('".$idobat."') AS JUDUL","JUDUL"));
				$this->newphpexcel->set_font('Calibri',10);
				$this->newphpexcel->setActiveSheetIndex($idxobat);
				$this->newphpexcel->set_title($urobat);
				$this->newphpexcel->mergecell(array(array('A1','S1'),array('A2','S2'),array('A3','S3'),array('A4','S4'),array('A6','A7'),array('B6','B7'),array('C6','G6'),array('H6','M6'),array('N6','S6'),array('T6','Y6')), TRUE);
				$this->newphpexcel->width(array(array('A',4), array('B',45)));
				$this->newphpexcel->set_bold(array('A1','A2','A3','A4'));
				$this->newphpexcel->setActiveSheetIndex($idxobat)->setCellValue('A1', 'REKAPITULASI HASIL PEMERIKSAAN SARANA')->setCellValue('A2',$judul)->setCellValue('A3', strtoupper($balai))->setCellValue('A4', 'PERIODE : '.$awal.' s.d '.$akhir);
				$this->newphpexcel->setActiveSheetIndex($idxobat)->setCellValue('A6','No.')->setCellValue('B6','BB / BPOM')->setCellValue('C6','Jumlah')->setCellValue('H6','Tindak Lanjut Balai Terhadap Sarana')->setCellValue('N6','Tindak Lanjut Pusat Terhadap Sarana')->setCellValue('T6','Kesimpulan Tindak Lanjut Terhadap Sarana')->setCellValue('C7','Diperiksa')->setCellValue('D7','MK')->setCellValue('E7','TMK')->setCellValue('F7','Tutup')->setCellValue('G7','TDP')->setCellValue('H7','Pb')->setCellValue('I7','P')->setCellValue('J7','PK')->setCellValue('K7','PSK')->setCellValue('L7','Pi')->setCellValue('M7','PKe')->setCellValue('N7','Pb')->setCellValue('O7','P')->setCellValue('P7','PK')->setCellValue('Q7','PSK')->setCellValue('R7','Pi')->setCellValue('S7','PKe')->setCellValue('T7','Pb')->setCellValue('U7','P')->setCellValue('V7','PK')->setCellValue('W7','PSK')->setCellValue('X7','Pi')->setCellValue('Y7','PKe');
				$this->newphpexcel->headings(array('A6','B6','C6','D6','E6','F6','G6','H6','I6','J6','K6','L6','M6','N6','O6','P6','Q6','R6','S6','T6','U6','V6','W6','X6','Y6','B7','C7','D7','E7','F7','G7','H7','I7','J7','K7','L7','M7','N7','O7','P7','Q7','R7','S7','T7','U7','V7','W7','X7','Y7'));
				$dataobat = $sipt->main->get_result($qobat);
				if($dataobat){
					$no=1;
					$rec = 8;
					foreach($qobat->result_array() as $rowobat){
						$this->newphpexcel->setActiveSheetIndex($idxobat)->setCellValue('A'.$rec,$no)
																  ->setCellValue('B'.$rec,$rowobat["NAMA_BBPOM"])
																  ->setCellValue('C'.$rec,$rowobat["JMLPERIKSA"])
																  ->setCellValue('D'.$rec,$rowobat["MK"])
																  ->setCellValue('E'.$rec,$rowobat["TMK"])
																  ->setCellValue('F'.$rec,$rowobat["TUTUP"])
																  ->setCellValue('G'.$rec,$rowobat["TDP"])
																  ->setCellValue('H'.$rec,$rowobat["BALAIPB"])
																  ->setCellValue('I'.$rec,$rowobat["BALAIPR"])
																  ->setCellValue('J'.$rec,$rowobat["BALAIPK"])
																  ->setCellValue('K'.$rec,$rowobat["BALAIPSK"])
																  ->setCellValue('L'.$rec,$rowobat["BALAIPIZ"])
																  ->setCellValue('M'.$rec,$rowobat["BALAIPKE"])
																  ->setCellValue('N'.$rec,$rowobat["PB"])
																  ->setCellValue('O'.$rec,$rowobat["PR"])
																  ->setCellValue('P'.$rec,$rowobat["PK"])
																  ->setCellValue('Q'.$rec,$rowobat["PSK"])
																  ->setCellValue('R'.$rec,$rowobat["PIZ"])
																  ->setCellValue('S'.$rec,$rowobat["PKE"])
																  ->setCellValue('T'.$rec,$rowobat["SUMMARYPB"])
																  ->setCellValue('U'.$rec,$rowobat["SUMMARYPR"])
																  ->setCellValue('V'.$rec,$rowobat["SUMMARYPK"])
																  ->setCellValue('W'.$rec,$rowobat["SUMMARYPSK"])
																  ->setCellValue('X'.$rec,$rowobat["SUMMARYPIZ"])
																  ->setCellValue('Y'.$rec,$rowobat["SUMMARYPKE"]);
					$this->newphpexcel->set_detilstyle(array('A'.$rec,'B'.$rec,'C'.$rec,'D'.$rec,'E'.$rec,'F'.$rec,'G'.$rec,'H'.$rec,'I'.$rec,'J'.$rec,'K'.$rec,'L'.$rec,'M'.$rec,'N'.$rec,'O'.$rec,'P'.$rec,'Q'.$rec,'R'.$rec,'S'.$rec, 'T'.$rec, 'U'.$rec, 'V'.$rec, 'W'.$rec, 'X'.$rec, 'Y'.$rec));
						$rec++;
						$no++;
					}
					$total = $rec - 1;
					$this->newphpexcel->setActiveSheetIndex($idxobat)->setCellValue('A'.$rec,$no)
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
					$this->newphpexcel->setActiveSheetIndex($idxobat)->setCellValue('A8','Data Tidak Ditemukan');
					$this->newphpexcel->set_detilstyle(array('A8','B8','C8','D8','E8','F8','G8','H8','I8','J8','K8','L8','M8','N8','O8','P8','Q8','R8','S8'));
				}
				$idxobat++;
			}
			#Akhir Distribusi PFB dan PBBBF
			
			#Distribusi Napza
			$arrnapza = array("02MN" => "PBF - Napza","02TN" => "GFK- Napza");
			$idx = 3;
			foreach($arrnapza as $idxnapza => $urnapza){
				$this->newphpexcel->createSheet();
				$qnapza = "SELECT DISTINCT(REPLACE(REPLACE(C.NAMA_BBPOM,'BALAI BESAR POM', 'BBPOM'),'BALAI POM','BPOM')) AS NAMA_BBPOM,(SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE JENIS_SARANA_ID = '".$idxnapza."' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS JMLPERIKSA, (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'MK' AND JENIS_SARANA_ID = '".$idxnapza."' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS JMLMK, (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'Minor' AND JENIS_SARANA_ID = '".$idxnapza."' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS JMLMINOR, (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'Major' AND JENIS_SARANA_ID = '".$idxnapza."' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS JMLMAJOR, (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'Kritikal' AND JENIS_SARANA_ID = '".$idxnapza."' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS JMLKRITIKAL, (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = '' AND JENIS_SARANA_ID = '".$idxnapza."' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS JMLNULL FROM T_PEMERIKSAAN A LEFT JOIN M_BBPOM C ON A.BBPOM_ID = C.BBPOM_ID WHERE A.JENIS_SARANA_ID = '".$idxnapza."' $filter2 AND LEN(A.STATUS) > 2 ORDER BY 1";
				$judul = strtoupper($sipt->main->get_uraian("SELECT dbo.NAMA_JENIS_SARANA('".$idxnapza."') AS JUDUL","JUDUL"));
				$this->newphpexcel->set_font('Calibri',10);
				$this->newphpexcel->setActiveSheetIndex($idx);
				$this->newphpexcel->set_title($urnapza);
				$this->newphpexcel->mergecell(array(array('A1','G1'),array('A2','G2'),array('A3','G3'),array('A4','G4'),array('A6','A7'),array('C6','G6')), TRUE);
				$this->newphpexcel->mergecell(array(array('B6','B7')), FALSE);
				$this->newphpexcel->width(array(array('A',4), array('B',45), array('H',15)));
				$this->newphpexcel->set_bold(array('A1','A2','A3','A4'));
				$this->newphpexcel->setActiveSheetIndex($idx)->setCellValue('A1', 'REKAPITULASI HASIL PEMERIKSAAN SARANA')->setCellValue('A2',$judul)->setCellValue('A3', strtoupper($balai))->setCellValue('A4', 'PERIODE : '.$awal.' s.d '.$akhir);
				$this->newphpexcel->setActiveSheetIndex($idx)->setCellValue('A6','No.')->setCellValue('B6','BB / BPOM')->setCellValue('C6','Jumlah')->setCellValue('C7','Diperiksa')->setCellValue('D7','MK')->setCellValue('E7','Minor')->setCellValue('F7','Major')->setCellValue('G7','Kritikal');
				$this->newphpexcel->headings(array('A6','B6','C6','D6','E6','F6','G6','B7','C7','D7','E7','F7','G7'));
				$datanapza = $sipt->main->get_result($qnapza);
				if($datanapza){
					$no=1;
					$rec = 8;
					foreach($qnapza->result_array() as $rownapza){
						$this->newphpexcel->setActiveSheetIndex($idx)->setCellValue('A'.$rec,$no)
																  ->setCellValue('B'.$rec,$rownapza["NAMA_BBPOM"])
																  ->setCellValue('C'.$rec,$rownapza["JMLPERIKSA"])
																  ->setCellValue('D'.$rec,$rownapza["JMLMK"])
																  ->setCellValue('E'.$rec,$rownapza["JMLMINOR"])
																  ->setCellValue('F'.$rec,$rownapza["JMLMAJOR"])
																  ->setCellValue('G'.$rec,$rownapza["JMLKRITIKAL"]);
						$this->newphpexcel->set_detilstyle(array('A'.$rec,'B'.$rec,'C'.$rec,'D'.$rec,'E'.$rec,'F'.$rec,'G'.$rec));
						$rec++;
						$no++;
					}
					$total = $rec - 1;
					$this->newphpexcel->setActiveSheetIndex($idx)->setCellValue('A'.$rec,$no)
						->setCellValue('B'.$rec,'Jumlah')
						->setCellValue('C'.$rec,'=SUM(C8:C'.$total.')')
						->setCellValue('D'.$rec,'=SUM(D8:D'.$total.')')
						->setCellValue('E'.$rec,'=SUM(E8:E'.$total.')')
						->setCellValue('F'.$rec,'=SUM(F8:F'.$total.')')
						->setCellValue('G'.$rec,'=SUM(G8:G'.$total.')');
						$this->newphpexcel->set_detilstyle(array('A'.$rec,'B'.$rec,'C'.$rec,'D'.$rec,'E'.$rec,'F'.$rec,'G'.$rec));
				}else{
					$this->newphpexcel->getActiveSheet()->mergeCells('A8:G8');
					$this->newphpexcel->setActiveSheetIndex($idx)->setCellValue('A8','Data Tidak Ditemukan');
					$this->newphpexcel->set_detilstyle(array('A8','B8','C8','D8','E8','F8','G8'));
				}
				$idx++;
			}
			#Akhir Distribusi Napza
			
			#Obat Tradisional
			$qot = " SELECT DISTINCT(REPLACE(REPLACE(C.NAMA_BBPOM,'BALAI BESAR POM DI ', ''),'BALAI POM DI ','')) AS NAMA_BBPOM,
			(SELECT COUNT(JENIS_SARANA_ID) FROM T_PEMERIKSAAN WHERE JENIS_SARANA_ID = '02OT' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS JMLPERIKSA, 
			(SELECT COUNT(JENIS_SARANA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'MK' AND JENIS_SARANA_ID = '02OT' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS MK, 
			(SELECT COUNT(JENIS_SARANA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'TMK' AND JENIS_SARANA_ID = '02OT' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS TMK,
			SUM(CASE WHEN D.KATEGORI LIKE '%TIE%' THEN 1 ELSE 0 END) AS TMKTIE,
			SUM(CASE WHEN D.KATEGORI LIKE '%BKO%' THEN 1 ELSE 0 END) AS TMKBKO,
			SUM(CASE WHEN D.KATEGORI LIKE '%Penandaan%' THEN 1 ELSE 0 END) AS TMKPENANDAAN,
			SUM(CASE WHEN D.KATEGORI LIKE '%Rusak%' THEN 1 ELSE 0 END) AS TMKRUSAK,
			SUM(CASE WHEN D.KATEGORI LIKE '%Kadaluarsa%' THEN 1 ELSE 0 END) AS KADALUARSA,
			SUM(CASE WHEN D.KATEGORI LIKE '%Farmasetik%' THEN 1 ELSE 0 END) AS FARMASETIK,
			SUM(CASE WHEN D.SATUAN LIKE '%botol%' THEN 1 ELSE 0 END) AS BOTOL,
			SUM(CASE WHEN D.SATUAN LIKE '%buah%' THEN 1 ELSE 0 END) AS BUAH,
			SUM(CASE WHEN D.SATUAN LIKE '%bungkus%' THEN 1 ELSE 0 END) AS BUNGKUS,
			SUM(CASE WHEN D.SATUAN LIKE '%cup%' THEN 1 ELSE 0 END) AS CUP,
			SUM(CASE WHEN D.SATUAN LIKE '%kaleng%' THEN 1 ELSE 0 END) AS KALENG,
			SUM(CASE WHEN D.SATUAN LIKE '%karton%' THEN 1 ELSE 0 END) AS KARTON,
			SUM(CASE WHEN D.SATUAN LIKE '%kotak%' THEN 1 ELSE 0 END) AS KOTAK,
			SUM(CASE WHEN D.SATUAN LIKE '%sachet%' THEN 1 ELSE 0 END) AS SACHET,
			SUM(CASE WHEN D.SATUAN LIKE '%tube%' THEN 1 ELSE 0 END) AS TUBE,
			SUM(D.HARGA_TOTAL) AS TOTAL_HARGA
			FROM T_PEMERIKSAAN A LEFT JOIN M_BBPOM C ON A.BBPOM_ID = C.BBPOM_ID 
			LEFT JOIN T_PEMERIKSAAN_TEMUAN_PRODUK D ON D.PERIKSA_ID = A.PERIKSA_ID 
			WHERE A.JENIS_SARANA_ID = '02OT' AND D.KK_ID = '010' $filter2 AND LEN(A.STATUS) > 2 GROUP BY C.BBPOM_ID, C.NAMA_BBPOM
ORDER BY 1";
			$judul = strtoupper($sipt->main->get_uraian("SELECT dbo.NAMA_JENIS_SARANA('02OT') AS JUDUL","JUDUL"));
			$this->newphpexcel->setActiveSheetIndex(5);
			$this->newphpexcel->set_title('Obat Tradisional');
			$this->newphpexcel->mergecell(array(array('A1','U1'),array('A2','U2'),array('A3','U3'),array('A4','U4'),array('A6','A7'),array('C6','E6'),array('F6','K6'),array('L6','T6'), array('U6','U7')), TRUE);
			$this->newphpexcel->mergecell(array(array('B6','B7')), FALSE);
			$this->newphpexcel->width(array(array('A',4), array('B',45),array('C',8),array('D',5),array('E',5),array('F',7),array('G',7),array('H',11),array('I',8),array('J',8),array('K',8),array('L',8),array('M',8),array('N',8),array('O',10),array('P',10),array('Q',10),array('R',10),array('S',10),array('T',10),array('U',10)));
			$this->newphpexcel->set_bold(array('A1','A2','A3','A4'));
			$this->newphpexcel->setActiveSheetIndex(5)->setCellValue('A1', 'REKAPITULASI HASIL PEMERIKSAAN SARANA')->setCellValue('A2',$judul)->setCellValue('A3', strtoupper($balai))->setCellValue('A4', 'PERIODE : '.$awal.' s.d '.$akhir);
			$this->newphpexcel->setActiveSheetIndex(5)->setCellValue('A6','No.')->setCellValue('B6','BB / BPOM')->setCellValue('C6','Jumlah')->setCellValue('F6','Mengedarkan')->setCellValue('L6','Tindak Lanjut (Pemusnahan OT BKO, TIE, Rusak)')->setCellValue('U6','Perkiraaan Harga')			
			->setCellValue('C7','Diperiksa')->setCellValue('D7','MK')->setCellValue('E7','TMK')->setCellValue('F7','BKO')->setCellValue('G7','TIE')->setCellValue('H7','Penandaan')->setCellValue('I7','Rusak')->setCellValue('J7','Kadaluarsa')->setCellValue('K7','Farmasetik')->setCellValue('L7','Botol')->setCellValue('M7','Buah / Pieces')->setCellValue('N7','Bungkus')->setCellValue('O7','Cup')->setCellValue('P7','Kaleng')->setCellValue('Q7','Karton')->setCellValue('R7','Kotak')->setCellValue('S7','Sachet')->setCellValue('T7','Tube');
			$this->newphpexcel->headings(array('A6','B6','C6','D6','E6','F6','G6','H6','I6','J6','K6','L6','M6','N6','O6','P6','Q6','R6','S6','T6','U6','B7','C7','D7','E7','F7','G7','H7','I7','J7','K7','L7','M7','N7','O7','P7','Q7','R7','S7','T7','U7'));
			$this->newphpexcel->set_wrap(array('F7','G7','H7','I7','J7','K7','L7','M7','N7','O7','P7','Q7','R7','S7','T7','U7','P6'));
			$dataot = $sipt->main->get_result($qot);
			if($dataot){
				$no=1;
				$rec = 8;
				foreach($qot->result_array() as $rowot){
					$this->newphpexcel->setActiveSheetIndex(5)->setCellValue('A'.$rec,$no)
															  ->setCellValue('B'.$rec,$rowot["NAMA_BBPOM"])
															  ->setCellValue('C'.$rec,$rowot["JMLPERIKSA"])
															  ->setCellValue('D'.$rec,$rowot["MK"])
															  ->setCellValue('E'.$rec,$rowot["TMK"])
															  ->setCellValue('F'.$rec,$rowot["TMKTIE"])
															  ->setCellValue('G'.$rec,$rowot["TMKBKO"])
															  ->setCellValue('H'.$rec,$rowot["TMKPENANDAAN"])
															  ->setCellValue('I'.$rec,$rowot["TMKRUSAK"])
															  ->setCellValue('J'.$rec,$rowot["KADALUARSA"])
															  ->setCellValue('K'.$rec,$rowot["FARMASETIK"])
															  ->setCellValue('L'.$rec,$rowot["BOTOL"])
															  ->setCellValue('M'.$rec,$rowot["BUAH"])
															  ->setCellValue('N'.$rec,$rowot["BUNGKUS"])
															  ->setCellValue('O'.$rec,$rowot["CUP"])
															  ->setCellValue('P'.$rec,$rowot["KALENG"])
															  ->setCellValue('Q'.$rec,$rowot["KARTON"])
															  ->setCellValue('R'.$rec,$rowot["KOTAK"])
															  ->setCellValue('S'.$rec,$rowot["SACHET"])
															  ->setCellValue('T'.$rec,$rowot["TUBE"])
															  ->setCellValue('U'.$rec,$rowot["TOTAL_HARGA"]);
					$this->newphpexcel->set_detilstyle(array('A'.$rec,'B'.$rec,'C'.$rec,'D'.$rec,'E'.$rec,'F'.$rec,'G'.$rec,'H'.$rec,'I'.$rec,'J'.$rec,'K'.$rec,'L'.$rec,'M'.$rec,'N'.$rec,'O'.$rec,'P'.$rec,'Q'.$rec,'R'.$rec,'S'.$rec,'T'.$rec,'U'.$rec));
					$rec++;
					$no++;
				}
				$total = $rec - 1;
				$this->newphpexcel->setActiveSheetIndex(5)->setCellValue('A'.$rec,$no)
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
					->setCellValue('T'.$rec,'=SUM(S8:T'.$total.')')
					->setCellValue('U'.$rec,'=SUM(S8:U'.$total.')');
					$this->newphpexcel->set_detilstyle(array('A'.$rec,'B'.$rec,'C'.$rec,'D'.$rec,'E'.$rec,'F'.$rec,'G'.$rec,'H'.$rec,'I'.$rec,'J'.$rec,'K'.$rec,'L'.$rec,'M'.$rec,'N'.$rec,'O'.$rec,'P'.$rec,'Q'.$rec,'R'.$rec,'S'.$rec,'T'.$rec,'U'.$rec));
			}else{
				$this->newphpexcel->getActiveSheet()->mergeCells('A8:U8');
				$this->newphpexcel->setActiveSheetIndex(5)->setCellValue('A8','Data Tidak Ditemukan');
				$this->newphpexcel->set_detilstyle(array('A8','B8','C8','D8','E8','F8','G8','H8','I8','J8','K8','L8','M8','N8','O8','P8','Q8','R8','S8','T8','U8'));
			}
			#Akhir Obat Tradisional
			
			#Produk Komplemen
			$qsm = "SELECT DISTINCT(REPLACE(REPLACE(C.NAMA_BBPOM,'BALAI BESAR POM DI ', ''),'BALAI POM DI ','')) AS NAMA_BBPOM,
			(SELECT COUNT(JENIS_SARANA_ID) FROM T_PEMERIKSAAN WHERE JENIS_SARANA_ID = '02PK' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS JMLPERIKSA, 
			(SELECT COUNT(JENIS_SARANA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'MK' AND JENIS_SARANA_ID = '02PK' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS MK, 
			(SELECT COUNT(JENIS_SARANA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'TMK' AND JENIS_SARANA_ID = '02PK' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS TMK,
			SUM(CASE WHEN D.KATEGORI LIKE '%TIE%' THEN 1 ELSE 0 END) AS TMKTIE,
			SUM(CASE WHEN D.KATEGORI LIKE '%BKO%' THEN 1 ELSE 0 END) AS TMKBKO,
			SUM(CASE WHEN D.KATEGORI LIKE '%Penandaan%' THEN 1 ELSE 0 END) AS TMKPENANDAAN,
			SUM(CASE WHEN D.KATEGORI LIKE '%Rusak%' THEN 1 ELSE 0 END) AS TMKRUSAK,
			SUM(CASE WHEN D.KATEGORI LIKE '%Kadaluarsa%' THEN 1 ELSE 0 END) AS KADALUARSA,
			SUM(CASE WHEN D.KATEGORI LIKE '%Farmasetik%' THEN 1 ELSE 0 END) AS FARMASETIK,
			SUM(CASE WHEN D.SATUAN LIKE '%botol%' THEN 1 ELSE 0 END) AS BOTOL,
			SUM(CASE WHEN D.SATUAN LIKE '%buah%' THEN 1 ELSE 0 END) AS BUAH,
			SUM(CASE WHEN D.SATUAN LIKE '%bungkus%' THEN 1 ELSE 0 END) AS BUNGKUS,
			SUM(CASE WHEN D.SATUAN LIKE '%cup%' THEN 1 ELSE 0 END) AS CUP,
			SUM(CASE WHEN D.SATUAN LIKE '%kaleng%' THEN 1 ELSE 0 END) AS KALENG,
			SUM(CASE WHEN D.SATUAN LIKE '%karton%' THEN 1 ELSE 0 END) AS KARTON,
			SUM(CASE WHEN D.SATUAN LIKE '%kotak%' THEN 1 ELSE 0 END) AS KOTAK,
			SUM(CASE WHEN D.SATUAN LIKE '%sachet%' THEN 1 ELSE 0 END) AS SACHET,
			SUM(CASE WHEN D.SATUAN LIKE '%tube%' THEN 1 ELSE 0 END) AS TUBE,
			SUM(D.HARGA_TOTAL) AS TOTAL_HARGA
			FROM T_PEMERIKSAAN A LEFT JOIN M_BBPOM C ON A.BBPOM_ID = C.BBPOM_ID 
			LEFT JOIN T_PEMERIKSAAN_TEMUAN_PRODUK D ON D.PERIKSA_ID = A.PERIKSA_ID 
			WHERE A.JENIS_SARANA_ID = '02PK' AND D.KK_ID = '011' $filter2 AND LEN(A.STATUS) > 2 GROUP BY C.BBPOM_ID, C.NAMA_BBPOM ORDER BY 1";
			$judul = strtoupper($sipt->main->get_uraian("SELECT dbo.NAMA_JENIS_SARANA('02PK') AS JUDUL","JUDUL"));
			$this->newphpexcel->createSheet();
			$this->newphpexcel->set_font('Calibri',10);
			$this->newphpexcel->setActiveSheetIndex(6);
			$this->newphpexcel->set_title('Suplemen Makanan');
			$this->newphpexcel->mergecell(array(array('A1','U1'),array('A2','U2'),array('A3','U3'),array('A4','U4'),array('A6','A7'),array('C6','E6'),array('F6','K6'),array('L6','T6'), array('U6','U7')), TRUE);
			$this->newphpexcel->mergecell(array(array('B6','B7')), FALSE);
			$this->newphpexcel->width(array(array('A',4), array('B',45),array('C',8),array('D',5),array('E',5),array('F',7),array('G',7),array('H',11),array('I',8),array('J',8),array('K',8),array('L',8),array('M',8),array('N',8),array('O',10),array('P',10),array('Q',10),array('R',10),array('S',10),array('T',10),array('U',10)));
			$this->newphpexcel->set_bold(array('A1','A2','A3','A4'));
			$this->newphpexcel->setActiveSheetIndex(6)->setCellValue('A1', 'REKAPITULASI HASIL PEMERIKSAAN SARANA')->setCellValue('A2',$judul)->setCellValue('A3', strtoupper($balai))->setCellValue('A4', 'PERIODE : '.$awal.' s.d '.$akhir);
			$this->newphpexcel->setActiveSheetIndex(6)->setCellValue('A6','No.')->setCellValue('B6','BB / BPOM')->setCellValue('C6','Jumlah')->setCellValue('F6','Mengedarkan')->setCellValue('L6','Tindak Lanjut (Pemusnahan OT BKO, TIE, Rusak)')->setCellValue('U6','Perkiraaan Harga')			
			->setCellValue('C7','Diperiksa')->setCellValue('D7','MK')->setCellValue('E7','TMK')->setCellValue('F7','BKO')->setCellValue('G7','TIE')->setCellValue('H7','Penandaan')->setCellValue('I7','Rusak')->setCellValue('J7','Kadaluarsa')->setCellValue('K7','Farmasetik')->setCellValue('L7','Botol')->setCellValue('M7','Buah / Pieces')->setCellValue('N7','Bungkus')->setCellValue('O7','Cup')->setCellValue('P7','Kaleng')->setCellValue('Q7','Karton')->setCellValue('R7','Kotak')->setCellValue('S7','Sachet')->setCellValue('T7','Tube');
			$this->newphpexcel->headings(array('A6','B6','C6','D6','E6','F6','G6','H6','I6','J6','K6','L6','M6','N6','O6','P6','Q6','R6','S6','T6','U6','B7','C7','D7','E7','F7','G7','H7','I7','J7','K7','L7','M7','N7','O7','P7','Q7','R7','S7','T7','U7'));
			$this->newphpexcel->set_wrap(array('F7','G7','H7','I7','J7','K7','L7','M7','N7','O7','P7','Q7','R7','S7','T7','U7','P6'));
			$datasm = $sipt->main->get_result($qsm);
			if($datasm){
				$no=1;
				$rec = 8;
				foreach($qsm->result_array() as $rowsm){
					$this->newphpexcel->setActiveSheetIndex(6)->setCellValue('A'.$rec,$no)
															  ->setCellValue('B'.$rec,$rowsm["NAMA_BBPOM"])
															  ->setCellValue('C'.$rec,$rowsm["JMLPERIKSA"])
															  ->setCellValue('D'.$rec,$rowsm["MK"])
															  ->setCellValue('E'.$rec,$rowsm["TMK"])
															  ->setCellValue('F'.$rec,$rowsm["TMKTIE"])
															  ->setCellValue('G'.$rec,$rowsm["TMKBKO"])
															  ->setCellValue('H'.$rec,$rowsm["TMKPENANDAAN"])
															  ->setCellValue('I'.$rec,$rowsm["TMKRUSAK"])
															  ->setCellValue('J'.$rec,$rowsm["KADALUARSA"])
															  ->setCellValue('K'.$rec,$rowsm["FARMASETIK"])
															  ->setCellValue('L'.$rec,$rowsm["BOTOL"])
															  ->setCellValue('M'.$rec,$rowsm["BUAH"])
															  ->setCellValue('N'.$rec,$rowsm["BUNGKUS"])
															  ->setCellValue('O'.$rec,$rowsm["CUP"])
															  ->setCellValue('P'.$rec,$rowsm["KALENG"])
															  ->setCellValue('Q'.$rec,$rowsm["KARTON"])
															  ->setCellValue('R'.$rec,$rowsm["KOTAK"])
															  ->setCellValue('S'.$rec,$rowsm["SACHET"])
															  ->setCellValue('T'.$rec,$rowsm["TUBE"])
															  ->setCellValue('U'.$rec,$rowsm["TOTAL_HARGA"]);
					$this->newphpexcel->set_detilstyle(array('A'.$rec,'B'.$rec,'C'.$rec,'D'.$rec,'E'.$rec,'F'.$rec,'G'.$rec,'H'.$rec,'I'.$rec,'J'.$rec,'K'.$rec,'L'.$rec,'M'.$rec,'N'.$rec,'O'.$rec,'P'.$rec,'Q'.$rec,'R'.$rec,'S'.$rec,'T'.$rec,'U'.$rec));
					$rec++;
					$no++;
				}
				$total = $rec - 1;
				$this->newphpexcel->setActiveSheetIndex(6)->setCellValue('A'.$rec,$no)
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
					->setCellValue('T'.$rec,'=SUM(S8:T'.$total.')')
					->setCellValue('U'.$rec,'=SUM(S8:U'.$total.')');
					$this->newphpexcel->set_detilstyle(array('A'.$rec,'B'.$rec,'C'.$rec,'D'.$rec,'E'.$rec,'F'.$rec,'G'.$rec,'H'.$rec,'I'.$rec,'J'.$rec,'K'.$rec,'L'.$rec,'M'.$rec,'N'.$rec,'O'.$rec,'P'.$rec,'Q'.$rec,'R'.$rec,'S'.$rec,'T'.$rec,'U'.$rec));
			}else{
				$this->newphpexcel->getActiveSheet()->mergeCells('A8:U8');
				$this->newphpexcel->setActiveSheetIndex(6)->setCellValue('A8','Data Tidak Ditemukan');
				$this->newphpexcel->set_detilstyle(array('A8','B8','C8','D8','E8','F8','G8','H8','I8','J8','K8','L8','M8','N8','O8','P8','Q8','R8','S8','T8','U8'));

			}
			#Akhir Produk Komplemen
			
			#Kosmetik
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
			$judul = strtoupper($sipt->main->get_uraian("SELECT dbo.NAMA_JENIS_SARANA('02KO') AS JUDUL","JUDUL"));
			$this->newphpexcel->createSheet();
			$this->newphpexcel->set_font('Calibri',10);
			$this->newphpexcel->setActiveSheetIndex(7);
			$this->newphpexcel->set_title('Kosmetik');
			$this->newphpexcel->mergecell(array(array('A1','S1'),array('A2','S2'),array('A3','S3'),array('A4','S4'),array('A6','A7'),array('C6','F6'),array('G6','K6'),array('L6','S6')), TRUE);
			$this->newphpexcel->mergecell(array(array('B6','B7')), FALSE);
			$this->newphpexcel->width(array(array('A',4), array('B',45),array('C',8),array('D',5),array('E',5),array('F',14),array('G',14),array('H',13),array('I',13),array('J',13),array('K',13),array('L',13),array('M',13),array('N',13),array('O',13),array('P',13),array('Q',13),array('R',13),array('S',13)));
			$this->newphpexcel->set_bold(array('A1','A2','A3','A4'));
			$this->newphpexcel->setActiveSheetIndex(7)->setCellValue('A1', 'REKAPITULASI HASIL PELAKSANAAN KEGIATAN - PEMERIKSAAN SARANA')->setCellValue('A2',$judul)->setCellValue('A3', strtoupper($balai))->setCellValue('A4', 'PERIODE : '.$awal.' s.d '.$akhir);
			$this->newphpexcel->setActiveSheetIndex(7)->setCellValue('A6','No.')->setCellValue('B6','BB / BPOM')->setCellValue('C6','Jumlah')->setCellValue('G6','Rincian TMK (Sarana)')->setCellValue('L6','Tindak Lanjut Terhadap Sarana')			
			->setCellValue('C7','Diperiksa')->setCellValue('D7','MK')->setCellValue('E7','TMK')->setCellValue('F7','Tutup')->setCellValue('G7','Mengedarkan Produk TIE')->setCellValue('H7','Mengedarkan Produk BB')->setCellValue('I7','TMK Penandaan')->setCellValue('J7','Administrasi')->setCellValue('K7','Kadaluarsa')->setCellValue('L7','Peringatan')->setCellValue('M7','Pengamanan')->setCellValue('N7','PSK Importasi / Distribusi')->setCellValue('O7','Projusticia')->setCellValue('P7','Rekomendasi PSK / Klinik / Salon / Spa')->setCellValue('Q7','Rekomendasi Pencabuatn Izin Produksi')->setCellValue('R7','Rekomendasi Pencabutan Izin Usaha (Semua)')->setCellValue('S7','Lain-lain');
			$this->newphpexcel->headings(array('A6','B6','C6','D6','E6','F6','G6','H6','I6','J6','K6','L6','M6','N6','O6','P6','Q6','R6','S6','B7','C7','D7','E7','F7','G7','H7','I7','J7','K7','L7','M7','N7','O7','P7','Q7','R7','S7'));
			$this->newphpexcel->set_wrap(array('F7','G7','H7','I7','J7','K7','L7','M7','N7','O7','P7','Q7','R7','S7'));
			$datasarana = $sipt->main->get_result($qsarana);	
			if($datasarana){
				$no=1;
				$rec = 8;
				foreach($qsarana->result_array() as $rowsarana){
					$this->newphpexcel->setActiveSheetIndex(7)->setCellValue('A'.$rec,$no)
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
				$this->newphpexcel->setActiveSheetIndex(7)->setCellValue('A'.$rec,$no)
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
				$this->newphpexcel->setActiveSheetIndex(7)->setCellValue('A8','Data Tidak Ditemukan');
				$this->newphpexcel->set_detilstyle(array('A8','B8','C8','D8','E8','F8','G8','H8','I8','J8','K8','L8','M8','N8','O8','P8','Q8','R8','S8'));
			}
			#Akhir Kosmetik
			
			#Pangan 
			$qpangan = "SELECT DISTINCT(REPLACE(REPLACE(C.NAMA_BBPOM,'BALAI BESAR POM DI ', ''),'BALAI POM DI ','')) AS NAMA_BBPOM, 
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
			$judul = strtoupper($sipt->main->get_uraian("SELECT dbo.NAMA_JENIS_SARANA('02PG') AS JUDUL","JUDUL"));
			$this->newphpexcel->createSheet();
			$this->newphpexcel->set_font('Calibri',10);
			$this->newphpexcel->setActiveSheetIndex(8);
			$this->newphpexcel->set_title('Pangan');
			$this->newphpexcel->mergecell(array(array('A1','N1'),array('A2','N2'),array('A3','N3'),array('A4','N4'),array('A6','A7'),array('C6','F6'),array('G6','N6')), TRUE);
			$this->newphpexcel->mergecell(array(array('B6','B7')), FALSE);
			$this->newphpexcel->width(array(array('A',4), array('B',45),array('C',8),array('D',8),array('E',8),array('F',8),array('G',10),array('H',13),array('I',13),array('J',13),array('K',13),array('L',13),array('M',13),array('N',10)));
			$this->newphpexcel->set_bold(array('A1','A2','A3','A4'));
			$this->newphpexcel->setActiveSheetIndex(8)->setCellValue('A1', 'REKAPITULASI HASIL PELAKSANAAN KEGIATAN - PEMERIKSAAN SARANA')->setCellValue('A2',$judul)->setCellValue('A3', strtoupper($balai))->setCellValue('A4', 'PERIODE : '.$awal.' s.d '.$akhir);
			$this->newphpexcel->setActiveSheetIndex(8)->setCellValue('A6','No.')->setCellValue('B6','BB / BPOM')->setCellValue('C6','Jumlah')->setCellValue('G6','Tindak Lanjut')
			->setCellValue('C7','Diperiksa')->setCellValue('D7','Baik')->setCellValue('E7','Cukup')->setCellValue('F7','Kurang')->setCellValue('G7','Pembinaan')->setCellValue('H7','Surat Peringatan')->setCellValue('I7','Pengamanan')->setCellValue('J7','Pemusnahan Produk')->setCellValue('K7','Pengambilan Sampel')->setCellValue('L7','Pemanggilan Resmi')->setCellValue('M7','Pengambilan Retur')->setCellValue('N7','Projusticia');
			$this->newphpexcel->headings(array('A6','B6','C6','D6','E6','F6','G6','H6','I6','J6','K6','L6','M6','N6','B7','C7','D7','E7','F7','G7','H7','I7','J7','K7','L7','M7','N7'));
			$this->newphpexcel->set_wrap(array('F7','G7','H7','I7','J7','K7','L7','M7','N7'));
			$datapangan = $sipt->main->get_result($qpangan);
			if($datapangan){
				$no=1;
				$rec = 8;
				foreach($qpangan->result_array() as $rowpangan){
					$this->newphpexcel->setActiveSheetIndex(8)->setCellValue('A'.$rec,$no)
															  ->setCellValue('B'.$rec,$rowpangan["NAMA_BBPOM"])
															  ->setCellValue('C'.$rec,$rowpangan["JMLPERIKSA"])
															  ->setCellValue('D'.$rec,$rowpangan["BAIK"])
															  ->setCellValue('E'.$rec,$rowpangan["CUKUP"])
															  ->setCellValue('F'.$rec,$rowpangan["KURANG"])
															  ->setCellValue('G'.$rec,$rowpangan["PEMBINAAN"])
															  ->setCellValue('H'.$rec,$rowpangan["SP"])
															  ->setCellValue('I'.$rec,$rowpangan["PENGAMANAN"])
															  ->setCellValue('J'.$rec,$rowpangan["PEMUSNAHAN"])
															  ->setCellValue('K'.$rec,$rowpangan["SAMPEL"])
															  ->setCellValue('L'.$rec,$rowpangan["PEMANGGILAN"])
															  ->setCellValue('M'.$rec,$rowpangan["RETUR"])
															  ->setCellValue('N'.$rec,$rowpangan["PROJUSTICIA"]);
					$this->newphpexcel->set_detilstyle(array('A'.$rec,'B'.$rec,'C'.$rec,'D'.$rec,'E'.$rec,'F'.$rec,'G'.$rec,'H'.$rec,'I'.$rec,'J'.$rec,'K'.$rec,'L'.$rec,'M'.$rec,'N'.$rec));
					$rec++;
					$no++;
				}
				$total = $rec - 1;
				$this->newphpexcel->setActiveSheetIndex(8)->setCellValue('A'.$rec,$no)
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
				$this->newphpexcel->setActiveSheetIndex(8)->setCellValue('A8','Data Tidak Ditemukan');
				$this->newphpexcel->set_detilstyle(array('A8','B8','C8','D8','E8','F8','G8','H8','I8','J8','K8','L8','M8','N8'));

			}
			#Akhir Pangan
			
			#Intensifikasi Pangan
			$qintens = "SELECT DISTINCT(REPLACE(REPLACE(C.NAMA_BBPOM,'BALAI BESAR POM', 'BBPOM'),'BALAI POM','BPOM')) AS NAMA_BBPOM, 
					  (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE JENIS_SARANA_ID = '02PR' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS JMLPERIKSA,
					  (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'MK' AND JENIS_SARANA_ID = '02PR' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS MK,
					  (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'TMK' AND JENIS_SARANA_ID = '02PR' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS TMK, 
					  SUM(CASE WHEN E.TINDAKAN LIKE '%parcel%' THEN 1 ELSE 0 END) AS PRODUKPARCEL,
					  SUM(CASE WHEN E.TINDAKAN LIKE '%diamankan%' THEN 1 ELSE 0 END) AS DIAMANKAN,
					  SUM(CASE WHEN E.TINDAKAN LIKE '%dimusnahkan%' THEN 1 ELSE 0 END) AS DIMUSNAHKAN,
					  SUM(CASE WHEN E.TINDAKAN LIKE '%penyalur%' THEN 1 ELSE 0 END) AS PENYALUR,
					  SUM(CASE WHEN E.TINDAKAN LIKE '%teguran%' THEN 1 ELSE 0 END) AS TEGURAN,
					  SUM(CASE WHEN E.TINDAKAN LIKE '%projusticia%' THEN 1 ELSE 0 END) AS PROJUSTICIA
					  FROM T_PEMERIKSAAN A LEFT JOIN M_BBPOM C ON A.BBPOM_ID = C.BBPOM_ID
					  LEFT JOIN T_PEMERIKSAAN_PANGAN E ON A.PERIKSA_ID = E.PERIKSA_ID
					  WHERE A.JENIS_SARANA_ID = '02PR' $filter2 AND LEN(A.STATUS) > 2
					  GROUP BY C.BBPOM_ID, C.NAMA_BBPOM ORDER BY 1";
			$judul = strtoupper($sipt->main->get_uraian("SELECT dbo.NAMA_JENIS_SARANA('02PR') AS JUDUL","JUDUL"));
			$this->newphpexcel->createSheet();
			$this->newphpexcel->set_font('Calibri',10);
			$this->newphpexcel->setActiveSheetIndex(9);
			$this->newphpexcel->set_title('Intensifikasi Pangan Khusus');
			$this->newphpexcel->mergecell(array(array('A1','K1'),array('A2','K2'),array('A3','K3'),array('A4','K4'),array('A6','A7'),array('C6','C7'),array('D6','D7'),array('E6','E7'),array('F6','K6')), TRUE);
			$this->newphpexcel->mergecell(array(array('B6','B7')), FALSE);
			$this->newphpexcel->width(array(array('A',4), array('B',45),array('C',7),array('D',4),array('E',4),array('F',10),array('G',10),array('H',13),array('I',13),array('J',10),array('K',10)));
			$this->newphpexcel->set_bold(array('A1','A2','A3','A4'));
			$this->newphpexcel->setActiveSheetIndex(9)->setCellValue('A1', 'REKAPITULASI HASIL PELAKSANAAN KEGIATAN - PEMERIKSAAN SARANA')->setCellValue('A2',$judul)->setCellValue('A3', strtoupper($balai))->setCellValue('A4', 'PERIODE : '.$awal.' s.d '.$akhir);
			$this->newphpexcel->setActiveSheetIndex(9)->setCellValue('A6','No.')->setCellValue('B6','BB / BPOM')->setCellValue('C6','Jumlah')->setCellValue('D6','MK')->setCellValue('E6','TMK')->setCellValue('F6','Tindak Lanjut')->setCellValue('F7','Produk Dikeluarkan Dari Parcel')->setCellValue('G7','Produk Diamankan')->setCellValue('H7','Produk Dimusnahkan')->setCellValue('I7','Produk Dikembalikan ke penyalur')->setCellValue('J7','Teguran Ke Pemilik Sarana')->setCellValue('K7','Projusticia');
			$this->newphpexcel->headings(array('A6','B6','C6','D6','E6','F6','G6','H6','I6','J6','K6','B7','C7','D7','E7','F7','G7','H7','I7','J7','K7'));
			$this->newphpexcel->set_wrap(array('F7','G7','H7','I7','J7','K7'));
			$dataintens = $sipt->main->get_result($qintens);
			if($dataintens){
				$no=1;
				$rec = 8;
				foreach($qintens->result_array() as $rowintens){
					$this->newphpexcel->setActiveSheetIndex(9)->setCellValue('A'.$rec,$no)
															  ->setCellValue('B'.$rec,$rowintens["NAMA_BBPOM"])
															  ->setCellValue('C'.$rec,$rowintens["JMLPERIKSA"])
															  ->setCellValue('D'.$rec,$rowintens["MK"])
															  ->setCellValue('E'.$rec,$rowintens["TMK"])
															  ->setCellValue('F'.$rec,$rowintens["PRODUKPARCEL"])
															  ->setCellValue('G'.$rec,$rowintens["DIAMANKAN"])
															  ->setCellValue('H'.$rec,$rowintens["DIMUSNAHKAN"])
															  ->setCellValue('I'.$rec,$rowintens["PENYALUR"])
															  ->setCellValue('J'.$rec,$rowintens["TEGURAN"])
															  ->setCellValue('K'.$rec,$rowintens["PROJUSTICIA"]);
					$this->newphpexcel->set_detilstyle(array('A'.$rec,'B'.$rec,'C'.$rec,'D'.$rec,'E'.$rec,'F'.$rec,'G'.$rec,'H'.$rec,'I'.$rec,'J'.$rec,'K'.$rec));
					$rec++;
					$no++;
				}
				$total = $rec - 1;
				$this->newphpexcel->setActiveSheetIndex(9)->setCellValue('A'.$rec,$no)
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
				$this->newphpexcel->setActiveSheetIndex(9)->setCellValue('A8','Data Tidak Ditemukan');
				$this->newphpexcel->set_detilstyle(array('A8','B8','C8','D8','E8','F8','G8','H8','I8','J8','K8'));
			}
			#Akhir Intensifikasi Pangan
			
			ob_clean();
			$file = "RHPK_DATA_DISTRIBUSI.xls";
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
	
	function set_pelayanan(){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$this->load->library('newphpexcel');
			$this->newphpexcel->set_font('Calibri',10);
			
			#Apotek#
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
			
			$qapotek = "SELECT (REPLACE(REPLACE(C.NAMA_BBPOM,'BALAI BESAR POM DI ', ''),'BALAI POM DI ','')) AS NAMA_BBPOM,
			(SELECT COUNT(JENIS_SARANA_ID) FROM T_PEMERIKSAAN WHERE JENIS_SARANA_ID = '03AA' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS JMLPERIKSA,
			(SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'MK' AND JENIS_SARANA_ID = '03AA' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS MK,
			(SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'TMK' AND JENIS_SARANA_ID = '03AA' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS TMK, 
			(SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'TTP' AND JENIS_SARANA_ID = '03AA' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS TUTUP, 
			(SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'TDP' AND JENIS_SARANA_ID = '03AA' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS TDP,
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
			WHERE A.JENIS_SARANA_ID = '03AA' $filter2 AND LEN(A.STATUS) > 2 GROUP BY C.BBPOM_ID, C.NAMA_BBPOM ORDER BY 1";
			$judul = strtoupper($sipt->main->get_uraian("SELECT dbo.NAMA_JENIS_SARANA('03AA') AS JUDUL","JUDUL"));
			$this->newphpexcel->set_font('Calibri',10);
			$this->newphpexcel->setActiveSheetIndex(0);
			$this->newphpexcel->set_title('Apotek');
			$this->newphpexcel->mergecell(array(array('A1','S1'),array('A2','S2'),array('A3','S3'),array('A4','S4'),array('A6','A7'),array('B6','B7'),array('C6','G6'),array('H6','M6'),array('N6','S6'),array('T6','Y6')), TRUE);
			$this->newphpexcel->width(array(array('A',4), array('B',45)));
			$this->newphpexcel->set_bold(array('A1','A2','A3','A4'));
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A1', 'REKAPITULASI HASIL PEMERIKSAAN SARANA')->setCellValue('A2',$judul)->setCellValue('A3', strtoupper($balai))->setCellValue('A4', 'PERIODE : '.$awal.' s.d '.$akhir);
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A6','No.')->setCellValue('B6','BB / BPOM')->setCellValue('C6','Jumlah')->setCellValue('H6','Tindak Lanjut Balai Terhadap Sarana')->setCellValue('N6','Tindak Lanjut Pusat Terhadap Sarana')->setCellValue('T6','Kesimpulan Tindak Lanjut Terhadap Sarana')->setCellValue('C7','Diperiksa')->setCellValue('D7','MK')->setCellValue('E7','TMK')->setCellValue('F7','Tutup')->setCellValue('G7','TDP')->setCellValue('H7','Pb')->setCellValue('I7','P')->setCellValue('J7','PK')->setCellValue('K7','PSK')->setCellValue('L7','Pi')->setCellValue('M7','PKe')->setCellValue('N7','Pb')->setCellValue('O7','P')->setCellValue('P7','PK')->setCellValue('Q7','PSK')->setCellValue('R7','Pi')->setCellValue('S7','PKe')->setCellValue('T7','Pb')->setCellValue('U7','P')->setCellValue('V7','PK')->setCellValue('W7','PSK')->setCellValue('X7','Pi')->setCellValue('Y7','PKe');
			$this->newphpexcel->headings(array('A6','B6','C6','D6','E6','F6','G6','H6','I6','J6','K6','L6','M6','N6','O6','P6','Q6','R6','S6','T6','U6','V6','W6','X6','Y6','B7','C7','D7','E7','F7','G7','H7','I7','J7','K7','L7','M7','N7','O7','P7','Q7','R7','S7','T7','U7','V7','W7','X7','Y7'));
			$dataapotek = $sipt->main->get_result($qapotek);
			if($dataapotek){
				$no=1;
				$rec = 8;
				foreach($qapotek->result_array() as $rowapotek){
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A'.$rec,$no)
															  ->setCellValue('B'.$rec,$rowapotek["NAMA_BBPOM"])
															  ->setCellValue('C'.$rec,$rowapotek["JMLPERIKSA"])
															  ->setCellValue('D'.$rec,$rowapotek["MK"])
															  ->setCellValue('E'.$rec,$rowapotek["TMK"])
															  ->setCellValue('F'.$rec,$rowapotek["TUTUP"])
															  ->setCellValue('G'.$rec,$rowapotek["TDP"])
															  ->setCellValue('H'.$rec,$rowapotek["BALAIPB"])
															  ->setCellValue('I'.$rec,$rowapotek["BALAIPR"])
															  ->setCellValue('J'.$rec,$rowapotek["BALAIPK"])
															  ->setCellValue('K'.$rec,$rowapotek["BALAIPSK"])
															  ->setCellValue('L'.$rec,$rowapotek["BALAIPIZ"])
															  ->setCellValue('M'.$rec,$rowapotek["BALAIPKE"])
															  ->setCellValue('N'.$rec,$rowapotek["PB"])
															  ->setCellValue('O'.$rec,$rowapotek["PR"])
															  ->setCellValue('P'.$rec,$rowapotek["PK"])
															  ->setCellValue('Q'.$rec,$rowapotek["PSK"])
															  ->setCellValue('R'.$rec,$rowapotek["PIZ"])
															  ->setCellValue('S'.$rec,$rowapotek["PKE"])
															  ->setCellValue('T'.$rec,$rowapotek["SUMMARYPB"])
															  ->setCellValue('U'.$rec,$rowapotek["SUMMARYPR"])
															  ->setCellValue('V'.$rec,$rowapotek["SUMMARYPK"])
															  ->setCellValue('W'.$rec,$rowapotek["SUMMARYPSK"])
															  ->setCellValue('X'.$rec,$rowapotek["SUMMARYPIZ"])
															  ->setCellValue('Y'.$rec,$rowapotek["SUMMARYPKE"]);
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
				$this->newphpexcel->set_detilstyle(array('A8','B8','C8','D8','E8','F8','G8','H8','I8','J8','K8','L8','M8','N8','O8','P8','Q8','R8','S8','T8'));
			}
			#Akhir Apotek#
			
			#Balai Pengobatan#
			$this->newphpexcel->createSheet();
			$qbp = "SELECT (REPLACE(REPLACE(C.NAMA_BBPOM,'BALAI BESAR POM DI ', ''),'BALAI POM DI ','')) AS NAMA_BBPOM,
			(SELECT COUNT(JENIS_SARANA_ID) FROM T_PEMERIKSAAN WHERE JENIS_SARANA_ID = '03BB' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS JMLPERIKSA,
			(SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'MK' AND JENIS_SARANA_ID = '03BB' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS MK,
			(SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'TMK' AND JENIS_SARANA_ID = '03BB' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS TMK, 
			(SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'TTP' AND JENIS_SARANA_ID = '03BB' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS TUTUP, 
			(SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'TDP' AND JENIS_SARANA_ID = '03BB' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS TDP,
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
			WHERE A.JENIS_SARANA_ID = '03BB' $filter2 AND LEN(A.STATUS) > 2 GROUP BY C.BBPOM_ID, C.NAMA_BBPOM ORDER BY 1";
			$judul = strtoupper($sipt->main->get_uraian("SELECT dbo.NAMA_JENIS_SARANA('03BB') AS JUDUL","JUDUL"));
			$this->newphpexcel->set_font('Calibri',10);
			$this->newphpexcel->setActiveSheetIndex(1);
			$this->newphpexcel->set_title('Balai Pengobatan');
			$this->newphpexcel->mergecell(array(array('A1','S1'),array('A2','S2'),array('A3','S3'),array('A4','S4'),array('A6','A7'),array('B6','B7'),array('C6','G6'),array('H6','M6'),array('N6','S6'),array('T6','Y6')), TRUE);
			$this->newphpexcel->width(array(array('A',4), array('B',45)));
			$this->newphpexcel->set_bold(array('A1','A2','A3','A4'));
			$this->newphpexcel->setActiveSheetIndex(1)->setCellValue('A1', 'REKAPITULASI HASIL PEMERIKSAAN SARANA')->setCellValue('A2',$judul)->setCellValue('A3', strtoupper($balai))->setCellValue('A4', 'PERIODE : '.$awal.' s.d '.$akhir);
			$this->newphpexcel->setActiveSheetIndex(1)->setCellValue('A6','No.')->setCellValue('B6','BB / BPOM')->setCellValue('C6','Jumlah')->setCellValue('H6','Tindak Lanjut Balai Terhadap Sarana')->setCellValue('N6','Tindak Lanjut Pusat Terhadap Sarana')->setCellValue('T6','Kesimpulan Tindak Lanjut Terhadap Sarana')->setCellValue('C7','Diperiksa')->setCellValue('D7','MK')->setCellValue('E7','TMK')->setCellValue('F7','Tutup')->setCellValue('G7','TDP')->setCellValue('H7','Pb')->setCellValue('I7','P')->setCellValue('J7','PK')->setCellValue('K7','PSK')->setCellValue('L7','Pi')->setCellValue('M7','PKe')->setCellValue('N7','Pb')->setCellValue('O7','P')->setCellValue('P7','PK')->setCellValue('Q7','PSK')->setCellValue('R7','Pi')->setCellValue('S7','PKe')->setCellValue('T7','Pb')->setCellValue('U7','P')->setCellValue('V7','PK')->setCellValue('W7','PSK')->setCellValue('X7','Pi')->setCellValue('Y7','PKe');	
			$this->newphpexcel->headings(array('A6','B6','C6','D6','E6','F6','G6','H6','I6','J6','K6','L6','M6','N6','O6','P6','Q6','R6','S6','T6','U6','V6','W6','X6','Y6','B7','C7','D7','E7','F7','G7','H7','I7','J7','K7','L7','M7','N7','O7','P7','Q7','R7','S7','T7','U7','V7','W7','X7','Y7'));
			$databp = $sipt->main->get_result($qbp);
			if($databp){
				$no=1;
				$rec = 8;
				foreach($qbp->result_array() as $rowbp){
					$this->newphpexcel->setActiveSheetIndex(1)->setCellValue('A'.$rec,$no)
															  ->setCellValue('B'.$rec,$rowbp["NAMA_BBPOM"])
															  ->setCellValue('C'.$rec,$rowbp["JMLPERIKSA"])
															  ->setCellValue('D'.$rec,$rowbp["MK"])
															  ->setCellValue('E'.$rec,$rowbp["TMK"])
															  ->setCellValue('F'.$rec,$rowbp["TUTUP"])
															  ->setCellValue('G'.$rec,$rowbp["TDP"])
															  ->setCellValue('H'.$rec,$rowbp["BALAIPB"])
															  ->setCellValue('I'.$rec,$rowbp["BALAIPR"])
															  ->setCellValue('J'.$rec,$rowbp["BALAIPK"])
															  ->setCellValue('K'.$rec,$rowbp["BALAIPSK"])
															  ->setCellValue('L'.$rec,$rowbp["BALAIPIZ"])
															  ->setCellValue('M'.$rec,$rowbp["BALAIPKE"])
															  ->setCellValue('N'.$rec,$rowbp["PB"])
															  ->setCellValue('O'.$rec,$rowbp["PR"])
															  ->setCellValue('P'.$rec,$rowbp["PK"])
															  ->setCellValue('Q'.$rec,$rowbp["PSK"])
															  ->setCellValue('R'.$rec,$rowbp["PIZ"])
															  ->setCellValue('S'.$rec,$rowbp["PKE"])
															  ->setCellValue('T'.$rec,$rowbp["SUMMARYPB"])
															  ->setCellValue('U'.$rec,$rowbp["SUMMARYPR"])
															  ->setCellValue('V'.$rec,$rowbp["SUMMARYPK"])
															  ->setCellValue('W'.$rec,$rowbp["SUMMARYPSK"])
															  ->setCellValue('X'.$rec,$rowbp["SUMMARYPIZ"])
															  ->setCellValue('Y'.$rec,$rowbp["SUMMARYPKE"]);
					$this->newphpexcel->set_detilstyle(array('A'.$rec,'B'.$rec,'C'.$rec,'D'.$rec,'E'.$rec,'F'.$rec,'G'.$rec,'H'.$rec,'I'.$rec,'J'.$rec,'K'.$rec,'L'.$rec,'M'.$rec,'N'.$rec,'O'.$rec,'P'.$rec,'Q'.$rec,'R'.$rec,'S'.$rec,'T'.$rec,'U'.$rec,'V'.$rec,'W'.$rec,'X'.$rec,'Y'.$rec));
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
				$this->newphpexcel->setActiveSheetIndex(1)->setCellValue('A8','Data Tidak Ditemukan');
				$this->newphpexcel->set_detilstyle(array('A8','B8','C8','D8','E8','F8','G8','H8','I8','J8','K8','L8','M8','N8','O8','P8','Q8','R8','S8','T8'));
			}
			#Akhir Balai Pengobatan#
			
			#IFRS
			$this->newphpexcel->createSheet();
			$qifrs = "SELECT (REPLACE(REPLACE(C.NAMA_BBPOM,'BALAI BESAR POM DI ', ''),'BALAI POM DI ','')) AS NAMA_BBPOM,
			(SELECT COUNT(JENIS_SARANA_ID) FROM T_PEMERIKSAAN WHERE JENIS_SARANA_ID = '03TR' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS JMLPERIKSA,
			(SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'MK' AND JENIS_SARANA_ID = '03TR' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS MK,
			(SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'TMK' AND JENIS_SARANA_ID = '03TR' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS TMK, 
			(SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'TTP' AND JENIS_SARANA_ID = '03TR' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS TUTUP, 
			(SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'TDP' AND JENIS_SARANA_ID = '03TR' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS TDP,
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
			WHERE A.JENIS_SARANA_ID = '03TR' $filter2 AND LEN(A.STATUS) > 2 GROUP BY C.BBPOM_ID, C.NAMA_BBPOM ORDER BY 1";
			$judul = strtoupper($sipt->main->get_uraian("SELECT dbo.NAMA_JENIS_SARANA('03TR') AS JUDUL","JUDUL"));
			$this->newphpexcel->set_font('Calibri',10);
			$this->newphpexcel->setActiveSheetIndex(2);
			$this->newphpexcel->set_title('IFRS');
			$this->newphpexcel->mergecell(array(array('A1','S1'),array('A2','S2'),array('A3','S3'),array('A4','S4'),array('A6','A7'),array('B6','B7'),array('C6','G6'),array('H6','M6'),array('N6','S6'),array('T6','Y6')), TRUE);
			$this->newphpexcel->width(array(array('A',4), array('B',45)));
			$this->newphpexcel->set_bold(array('A1','A2','A3','A4'));
			$this->newphpexcel->setActiveSheetIndex(2)->setCellValue('A1', 'REKAPITULASI HASIL PEMERIKSAAN SARANA')->setCellValue('A2',$judul)->setCellValue('A3', strtoupper($balai))->setCellValue('A4', 'PERIODE : '.$awal.' s.d '.$akhir);
			$this->newphpexcel->setActiveSheetIndex(2)->setCellValue('A6','No.')->setCellValue('B6','BB / BPOM')->setCellValue('C6','Jumlah')->setCellValue('H6','Tindak Lanjut Balai Terhadap Sarana')->setCellValue('N6','Tindak Lanjut Pusat Terhadap Sarana')->setCellValue('T6','Kesimpulan Tindak Lanjut Terhadap Sarana')->setCellValue('C7','Diperiksa')->setCellValue('D7','MK')->setCellValue('E7','TMK')->setCellValue('F7','Tutup')->setCellValue('G7','TDP')->setCellValue('H7','Pb')->setCellValue('I7','P')->setCellValue('J7','PK')->setCellValue('K7','PSK')->setCellValue('L7','Pi')->setCellValue('M7','PKe')->setCellValue('N7','Pb')->setCellValue('O7','P')->setCellValue('P7','PK')->setCellValue('Q7','PSK')->setCellValue('R7','Pi')->setCellValue('S7','PKe')->setCellValue('T7','Pb')->setCellValue('U7','P')->setCellValue('V7','PK')->setCellValue('W7','PSK')->setCellValue('X7','Pi')->setCellValue('Y7','PKe');	
			$this->newphpexcel->headings(array('A6','B6','C6','D6','E6','F6','G6','H6','I6','J6','K6','L6','M6','N6','O6','P6','Q6','R6','S6','T6','U6','V6','W6','X6','Y6','B7','C7','D7','E7','F7','G7','H7','I7','J7','K7','L7','M7','N7','O7','P7','Q7','R7','S7','T7','U7','V7','W7','X7','Y7'));
			$dataifrs = $sipt->main->get_result($qifrs);
			if($dataifrs){
				$no=1;
				$rec = 8;
				foreach($qbp->result_array() as $rowbp){
					$this->newphpexcel->setActiveSheetIndex(2)->setCellValue('A'.$rec,$no)
															  ->setCellValue('B'.$rec,$rowbp["NAMA_BBPOM"])
															  ->setCellValue('C'.$rec,$rowbp["JMLPERIKSA"])
															  ->setCellValue('D'.$rec,$rowbp["MK"])
															  ->setCellValue('E'.$rec,$rowbp["TMK"])
															  ->setCellValue('F'.$rec,$rowbp["TUTUP"])
															  ->setCellValue('G'.$rec,$rowbp["TDP"])
															  ->setCellValue('H'.$rec,$rowbp["BALAIPB"])
															  ->setCellValue('I'.$rec,$rowbp["BALAIPR"])
															  ->setCellValue('J'.$rec,$rowbp["BALAIPK"])
															  ->setCellValue('K'.$rec,$rowbp["BALAIPSK"])
															  ->setCellValue('L'.$rec,$rowbp["BALAIPIZ"])
															  ->setCellValue('M'.$rec,$rowbp["BALAIPKE"])
															  ->setCellValue('N'.$rec,$rowbp["PB"])
															  ->setCellValue('O'.$rec,$rowbp["PR"])
															  ->setCellValue('P'.$rec,$rowbp["PK"])
															  ->setCellValue('Q'.$rec,$rowbp["PSK"])
															  ->setCellValue('R'.$rec,$rowbp["PIZ"])
															  ->setCellValue('S'.$rec,$rowbp["PKE"])
															  ->setCellValue('T'.$rec,$rowbp["SUMMARYPB"])
															  ->setCellValue('U'.$rec,$rowbp["SUMMARYPR"])
															  ->setCellValue('V'.$rec,$rowbp["SUMMARYPK"])
															  ->setCellValue('W'.$rec,$rowbp["SUMMARYPSK"])
															  ->setCellValue('X'.$rec,$rowbp["SUMMARYPIZ"])
															  ->setCellValue('Y'.$rec,$rowbp["SUMMARYPKE"]);
					$this->newphpexcel->set_detilstyle(array('A'.$rec,'B'.$rec,'C'.$rec,'D'.$rec,'E'.$rec,'F'.$rec,'G'.$rec,'H'.$rec,'I'.$rec,'J'.$rec,'K'.$rec,'L'.$rec,'M'.$rec,'N'.$rec,'O'.$rec,'P'.$rec,'Q'.$rec,'R'.$rec,'S'.$rec, 'T'.$rec, 'U'.$rec, 'V'.$rec, 'W'.$rec, 'X'.$rec, 'Y'.$rec));
					$rec++;
					$no++;
				}
				$total = $rec - 1;
				$this->newphpexcel->setActiveSheetIndex(2)->setCellValue('A'.$rec,$no)
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
				$this->newphpexcel->setActiveSheetIndex(2)->setCellValue('A8','Data Tidak Ditemukan');
				$this->newphpexcel->set_detilstyle(array('A8','B8','C8','D8','E8','F8','G8','H8','I8','J8','K8','L8','M8','N8','O8','P8','Q8','R8','S8','T8'));
			}
			#Akhir IFRS
			
			#Pusat Kesehatan Masyarakat (PKM)
			$this->newphpexcel->createSheet();
			$qpkm = "SELECT (REPLACE(REPLACE(C.NAMA_BBPOM,'BALAI BESAR POM DI ', ''),'BALAI POM DI ','')) AS NAMA_BBPOM,
			(SELECT COUNT(JENIS_SARANA_ID) FROM T_PEMERIKSAAN WHERE JENIS_SARANA_ID = '03RS' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS JMLPERIKSA,
			(SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'MK' AND JENIS_SARANA_ID = '03RS' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS MK,
			(SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'TMK' AND JENIS_SARANA_ID = '03RS' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS TMK, 
			(SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'TTP' AND JENIS_SARANA_ID = '03RS' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS TUTUP, 
			(SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'TDP' AND JENIS_SARANA_ID = '03RS' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS TDP,
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
			WHERE A.JENIS_SARANA_ID = '03RS' $filter2 AND LEN(A.STATUS) > 2 GROUP BY C.BBPOM_ID, C.NAMA_BBPOM ORDER BY 1";
			$judul = strtoupper($sipt->main->get_uraian("SELECT dbo.NAMA_JENIS_SARANA('03RS') AS JUDUL","JUDUL"));
			$this->newphpexcel->set_font('Calibri',10);
			$this->newphpexcel->setActiveSheetIndex(3);
			$this->newphpexcel->set_title('PKM');
			$this->newphpexcel->mergecell(array(array('A1','S1'),array('A2','S2'),array('A3','S3'),array('A4','S4'),array('A6','A7'),array('B6','B7'),array('C6','G6'),array('H6','M6'),array('N6','S6'),array('T6','Y6')), TRUE);
			$this->newphpexcel->width(array(array('A',4), array('B',45)));
			$this->newphpexcel->set_bold(array('A1','A2','A3','A4'));
			$this->newphpexcel->setActiveSheetIndex(3)->setCellValue('A1', 'REKAPITULASI HASIL PEMERIKSAAN SARANA')->setCellValue('A2',$judul)->setCellValue('A3', strtoupper($balai))->setCellValue('A4', 'PERIODE : '.$awal.' s.d '.$akhir);
			$this->newphpexcel->setActiveSheetIndex(3)->setCellValue('A6','No.')->setCellValue('B6','BB / BPOM')->setCellValue('C6','Jumlah')->setCellValue('H6','Tindak Lanjut Balai Terhadap Sarana')->setCellValue('N6','Tindak Lanjut Pusat Terhadap Sarana')->setCellValue('T6','Kesimpulan Tindak Lanjut Terhadap Sarana')->setCellValue('C7','Diperiksa')->setCellValue('D7','MK')->setCellValue('E7','TMK')->setCellValue('F7','Tutup')->setCellValue('G7','TDP')->setCellValue('H7','Pb')->setCellValue('I7','P')->setCellValue('J7','PK')->setCellValue('K7','PSK')->setCellValue('L7','Pi')->setCellValue('M7','PKe')->setCellValue('N7','Pb')->setCellValue('O7','P')->setCellValue('P7','PK')->setCellValue('Q7','PSK')->setCellValue('R7','Pi')->setCellValue('S7','PKe')->setCellValue('T7','Pb')->setCellValue('U7','P')->setCellValue('V7','PK')->setCellValue('W7','PSK')->setCellValue('X7','Pi')->setCellValue('Y7','PKe');		
			$this->newphpexcel->headings(array('A6','B6','C6','D6','E6','F6','G6','H6','I6','J6','K6','L6','M6','N6','O6','P6','Q6','R6','S6','T6','U6','V6','W6','X6','Y6','B7','C7','D7','E7','F7','G7','H7','I7','J7','K7','L7','M7','N7','O7','P7','Q7','R7','S7','T7','U7','V7','W7','X7','Y7'));
			$datapkm = $sipt->main->get_result($qpkm);
			if($datapkm){
				$no=1;
				$rec = 8;
				foreach($qpkm->result_array() as $rowpkm){
					$this->newphpexcel->setActiveSheetIndex(3)->setCellValue('A'.$rec,$no)
															  ->setCellValue('B'.$rec,$rowpkm["NAMA_BBPOM"])
															  ->setCellValue('C'.$rec,$rowpkm["JMLPERIKSA"])
															  ->setCellValue('D'.$rec,$rowpkm["MK"])
															  ->setCellValue('E'.$rec,$rowpkm["TMK"])
															  ->setCellValue('F'.$rec,$rowpkm["TUTUP"])
															  ->setCellValue('G'.$rec,$rowpkm["TDP"])
															  ->setCellValue('H'.$rec,$rowpkm["BALAIPB"])
															  ->setCellValue('I'.$rec,$rowpkm["BALAIPR"])
															  ->setCellValue('J'.$rec,$rowpkm["BALAIPK"])
															  ->setCellValue('K'.$rec,$rowpkm["BALAIPSK"])
															  ->setCellValue('L'.$rec,$rowpkm["BALAIPIZ"])
															  ->setCellValue('M'.$rec,$rowpkm["BALAIPKE"])
															  ->setCellValue('N'.$rec,$rowpkm["PB"])
															  ->setCellValue('O'.$rec,$rowpkm["PR"])
															  ->setCellValue('P'.$rec,$rowpkm["PK"])
															  ->setCellValue('Q'.$rec,$rowpkm["PSK"])
															  ->setCellValue('R'.$rec,$rowpkm["PIZ"])
															  ->setCellValue('S'.$rec,$rowpkm["PKE"])
															  ->setCellValue('T'.$rec,$rowpkm["SUMMARYPB"])
															  ->setCellValue('U'.$rec,$rowpkm["SUMMARYPR"])
															  ->setCellValue('V'.$rec,$rowpkm["SUMMARYPK"])
															  ->setCellValue('W'.$rec,$rowpkm["SUMMARYPSK"])
															  ->setCellValue('X'.$rec,$rowpkm["SUMMARYPIZ"])
															  ->setCellValue('Y'.$rec,$rowpkm["SUMMARYPKE"]);
					$this->newphpexcel->set_detilstyle(array('A'.$rec,'B'.$rec,'C'.$rec,'D'.$rec,'E'.$rec,'F'.$rec,'G'.$rec,'H'.$rec,'I'.$rec,'J'.$rec,'K'.$rec,'L'.$rec,'M'.$rec,'N'.$rec,'O'.$rec,'P'.$rec,'Q'.$rec,'R'.$rec,'S'.$rec, 'T'.$rec, 'U'.$rec, 'V'.$rec, 'W'.$rec, 'X'.$rec, 'Y'.$rec));
					$rec++;
					$no++;
				}
				$total = $rec - 1;
				$this->newphpexcel->setActiveSheetIndex(3)->setCellValue('A'.$rec,$no)
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
				$this->newphpexcel->setActiveSheetIndex(3)->setCellValue('A8','Data Tidak Ditemukan');
				$this->newphpexcel->set_detilstyle(array('A8','B8','C8','D8','E8','F8','G8','H8','I8','J8','K8','L8','M8','N8','O8','P8','Q8','R8','S8','T8'));
			}
			#Akhir Pusat Kesehatan Masyarakat (PKM)
			
			#Toko Obat
			$this->newphpexcel->createSheet();
			$qto = "SELECT (REPLACE(REPLACE(C.NAMA_BBPOM,'BALAI BESAR POM DI ', ''),'BALAI POM DI ','')) AS NAMA_BBPOM,
			(SELECT COUNT(JENIS_SARANA_ID) FROM T_PEMERIKSAAN WHERE JENIS_SARANA_ID = '03WW' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS JMLPERIKSA,
			(SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'MK' AND JENIS_SARANA_ID = '03WW' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS MK,
			(SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'TMK' AND JENIS_SARANA_ID = '03WW' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS TMK, 
			(SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'TTP' AND JENIS_SARANA_ID = '03WW' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS TUTUP, 
			(SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'TDP' AND JENIS_SARANA_ID = '03WW' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS TDP,
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
			WHERE A.JENIS_SARANA_ID = '03WW' $filter2 AND LEN(A.STATUS) > 2 GROUP BY C.BBPOM_ID, C.NAMA_BBPOM ORDER BY 1";
			$judul = strtoupper($sipt->main->get_uraian("SELECT dbo.NAMA_JENIS_SARANA('03WW') AS JUDUL","JUDUL"));
			$this->newphpexcel->set_font('Calibri',10);
			$this->newphpexcel->setActiveSheetIndex(4);
			$this->newphpexcel->set_title('Toko Obat');
			$this->newphpexcel->mergecell(array(array('A1','S1'),array('A2','S2'),array('A3','S3'),array('A4','S4'),array('A6','A7'),array('B6','B7'),array('C6','G6'),array('H6','M6'),array('N6','S6'),array('T6','Y6')), TRUE);
			$this->newphpexcel->width(array(array('A',4), array('B',45)));
			$this->newphpexcel->set_bold(array('A1','A2','A3','A4'));
			$this->newphpexcel->setActiveSheetIndex(4)->setCellValue('A1', 'REKAPITULASI HASIL PEMERIKSAAN SARANA')->setCellValue('A2',$judul)->setCellValue('A3', strtoupper($balai))->setCellValue('A4', 'PERIODE : '.$awal.' s.d '.$akhir);
			$this->newphpexcel->setActiveSheetIndex(4)->setCellValue('A6','No.')->setCellValue('B6','BB / BPOM')->setCellValue('C6','Jumlah')->setCellValue('H6','Tindak Lanjut Balai Terhadap Sarana')->setCellValue('N6','Tindak Lanjut Pusat Terhadap Sarana')->setCellValue('T6','Kesimpulan Tindak Lanjut Terhadap Sarana')->setCellValue('C7','Diperiksa')->setCellValue('D7','MK')->setCellValue('E7','TMK')->setCellValue('F7','Tutup')->setCellValue('G7','TDP')->setCellValue('H7','Pb')->setCellValue('I7','P')->setCellValue('J7','PK')->setCellValue('K7','PSK')->setCellValue('L7','Pi')->setCellValue('M7','PKe')->setCellValue('N7','Pb')->setCellValue('O7','P')->setCellValue('P7','PK')->setCellValue('Q7','PSK')->setCellValue('R7','Pi')->setCellValue('S7','PKe')->setCellValue('T7','Pb')->setCellValue('U7','P')->setCellValue('V7','PK')->setCellValue('W7','PSK')->setCellValue('X7','Pi')->setCellValue('Y7','PKe');	
			$this->newphpexcel->headings(array('A6','B6','C6','D6','E6','F6','G6','H6','I6','J6','K6','L6','M6','N6','O6','P6','Q6','R6','S6','T6','U6','V6','W6','X6','Y6','B7','C7','D7','E7','F7','G7','H7','I7','J7','K7','L7','M7','N7','O7','P7','Q7','R7','S7','T7','U7','V7','W7','X7','Y7'));
			$datato = $sipt->main->get_result($qto);
			if($datato){
				$no=1;
				$rec = 8;
				foreach($qto->result_array() as $rowpto){
					$this->newphpexcel->setActiveSheetIndex(4)->setCellValue('A'.$rec,$no)
															  ->setCellValue('B'.$rec,$rowpto["NAMA_BBPOM"])
															  ->setCellValue('C'.$rec,$rowpto["JMLPERIKSA"])
															  ->setCellValue('D'.$rec,$rowpto["MK"])
															  ->setCellValue('E'.$rec,$rowpto["TMK"])
															  ->setCellValue('F'.$rec,$rowpto["TUTUP"])
															  ->setCellValue('G'.$rec,$rowpto["TDP"])
															  ->setCellValue('H'.$rec,$rowpto["BALAIPB"])
															  ->setCellValue('I'.$rec,$rowpto["BALAIPR"])
															  ->setCellValue('J'.$rec,$rowpto["BALAIPK"])
															  ->setCellValue('K'.$rec,$rowpto["BALAIPSK"])
															  ->setCellValue('L'.$rec,$rowpto["BALAIPIZ"])
															  ->setCellValue('M'.$rec,$rowpto["BALAIPKE"])
															  ->setCellValue('N'.$rec,$rowpto["PB"])
															  ->setCellValue('O'.$rec,$rowpto["PR"])
															  ->setCellValue('P'.$rec,$rowpto["PK"])
															  ->setCellValue('Q'.$rec,$rowpto["PSK"])
															  ->setCellValue('R'.$rec,$rowpto["PIZ"])
															  ->setCellValue('S'.$rec,$rowpto["PKE"])
															  ->setCellValue('T'.$rec,$rowpto["SUMMARYPB"])
															  ->setCellValue('U'.$rec,$rowpto["SUMMARYPR"])
															  ->setCellValue('V'.$rec,$rowpto["SUMMARYPK"])
															  ->setCellValue('W'.$rec,$rowpto["SUMMARYPSK"])
															  ->setCellValue('X'.$rec,$rowpto["SUMMARYPIZ"])
															  ->setCellValue('Y'.$rec,$rowpto["SUMMARYPKE"]);
					$this->newphpexcel->set_detilstyle(array('A'.$rec,'B'.$rec,'C'.$rec,'D'.$rec,'E'.$rec,'F'.$rec,'G'.$rec,'H'.$rec,'I'.$rec,'J'.$rec,'K'.$rec,'L'.$rec,'M'.$rec,'N'.$rec,'O'.$rec,'P'.$rec,'Q'.$rec,'R'.$rec,'S'.$rec, 'T'.$rec, 'U'.$rec, 'V'.$rec, 'W'.$rec, 'X'.$rec, 'Y'.$rec));
					$rec++;
					$no++;
				}
				$total = $rec - 1;
				$this->newphpexcel->setActiveSheetIndex(4)->setCellValue('A'.$rec,$no)
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
					->setCellValue('T'.$rec,'=SUM(T8:T'.$total.')')
					->setCellValue('U'.$rec,'=SUM(U8:U'.$total.')')
					->setCellValue('V'.$rec,'=SUM(V8:V'.$total.')')
					->setCellValue('W'.$rec,'=SUM(W8:W'.$total.')')
					->setCellValue('X'.$rec,'=SUM(X8:X'.$total.')')
					->setCellValue('Y'.$rec,'=SUM(Y8:Y'.$total.')');
					$this->newphpexcel->set_detilstyle(array('A'.$rec,'B'.$rec,'C'.$rec,'D'.$rec,'E'.$rec,'F'.$rec,'G'.$rec,'H'.$rec,'I'.$rec,'J'.$rec,'K'.$rec,'L'.$rec,'M'.$rec,'N'.$rec,'O'.$rec,'P'.$rec,'Q'.$rec,'R'.$rec,'S'.$rec,'T'.$rec,'U'.$rec,'V'.$rec,'W'.$rec,'X'.$rec,'Y'.$rec));
			}else{
				$this->newphpexcel->getActiveSheet()->mergeCells('A8:S8');
				$this->newphpexcel->setActiveSheetIndex(4)->setCellValue('A8','Data Tidak Ditemukan');
				$this->newphpexcel->set_detilstyle(array('A8','B8','C8','D8','E8','F8','G8','H8','I8','J8','K8','L8','M8','N8','O8','P8','Q8','R8','S8','T8'));

			}
			#Akhir Toko Obat
			
			#Pelayanan Napza
			$arrnapza = array("03AN" => "Apotek - Napza","03BN" => "Balai Pengobatan - Napza","03TP" => "IFRS - Napza","03RN" => "PKM - Napza","03NN" => "Praktek Dokter - Napza","03WN" => "Toko Obat - Napza");
			$idx = 5;
			foreach($arrnapza as $idxnapza => $urnapza){
				$this->newphpexcel->createSheet();
				$qnapza = "SELECT DISTINCT(REPLACE(REPLACE(C.NAMA_BBPOM,'BALAI BESAR POM', 'BBPOM'),'BALAI POM','BPOM')) AS NAMA_BBPOM,(SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE JENIS_SARANA_ID = '".$idxnapza."' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS JMLPERIKSA, (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'MK' AND JENIS_SARANA_ID = '".$idxnapza."' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS JMLMK, (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'Minor' AND JENIS_SARANA_ID = '".$idxnapza."' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS JMLMINOR, (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'Major' AND JENIS_SARANA_ID = '".$idxnapza."' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS JMLMAJOR, (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'Kritikal' AND JENIS_SARANA_ID = '".$idxnapza."' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS JMLKRITIKAL, (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = '' AND JENIS_SARANA_ID = '".$idxnapza."' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS JMLNULL FROM T_PEMERIKSAAN A LEFT JOIN M_BBPOM C ON A.BBPOM_ID = C.BBPOM_ID WHERE A.JENIS_SARANA_ID = '".$idxnapza."' $filter2 AND LEN(A.STATUS) > 2 ORDER BY 1";
				$judul = strtoupper($sipt->main->get_uraian("SELECT dbo.NAMA_JENIS_SARANA('".$idxnapza."') AS JUDUL","JUDUL"));
				$this->newphpexcel->set_font('Calibri',10);
				$this->newphpexcel->setActiveSheetIndex($idx);
				$this->newphpexcel->set_title($urnapza);
				$this->newphpexcel->mergecell(array(array('A1','G1'),array('A2','G2'),array('A3','G3'),array('A4','G4'),array('A6','A7'),array('C6','G6')), TRUE);
				$this->newphpexcel->mergecell(array(array('B6','B7')), FALSE);
				$this->newphpexcel->width(array(array('A',4), array('B',45), array('H',15)));
				$this->newphpexcel->set_bold(array('A1','A2','A3','A4'));
				$this->newphpexcel->setActiveSheetIndex($idx)->setCellValue('A1', 'REKAPITULASI HASIL PEMERIKSAAN SARANA')->setCellValue('A2',$judul)->setCellValue('A3', strtoupper($balai))->setCellValue('A4', 'PERIODE : '.$awal.' s.d '.$akhir);
				$this->newphpexcel->setActiveSheetIndex($idx)->setCellValue('A6','No.')->setCellValue('B6','BB / BPOM')->setCellValue('C6','Jumlah')->setCellValue('C7','Diperiksa')->setCellValue('D7','MK')->setCellValue('E7','Minor')->setCellValue('F7','Major')->setCellValue('G7','Kritikal');
				$this->newphpexcel->headings(array('A6','B6','C6','D6','E6','F6','G6','B7','C7','D7','E7','F7','G7'));
				$datanapza = $sipt->main->get_result($qnapza);
				if($datanapza){
					$no=1;
					$rec = 8;
					foreach($qnapza->result_array() as $rownapza){
						$this->newphpexcel->setActiveSheetIndex($idx)->setCellValue('A'.$rec,$no)
																  ->setCellValue('B'.$rec,$rownapza["NAMA_BBPOM"])
																  ->setCellValue('C'.$rec,$rownapza["JMLPERIKSA"])
																  ->setCellValue('D'.$rec,$rownapza["JMLMK"])
																  ->setCellValue('E'.$rec,$rownapza["JMLMINOR"])
																  ->setCellValue('F'.$rec,$rownapza["JMLMAJOR"])
																  ->setCellValue('G'.$rec,$rownapza["JMLKRITIKAL"]);
						$this->newphpexcel->set_detilstyle(array('A'.$rec,'B'.$rec,'C'.$rec,'D'.$rec,'E'.$rec,'F'.$rec,'G'.$rec));
						$rec++;
						$no++;
					}
					$total = $rec - 1;
					$this->newphpexcel->setActiveSheetIndex($idx)->setCellValue('A'.$rec,$no)
						->setCellValue('B'.$rec,'Jumlah')
						->setCellValue('C'.$rec,'=SUM(C8:C'.$total.')')
						->setCellValue('D'.$rec,'=SUM(D8:D'.$total.')')
						->setCellValue('E'.$rec,'=SUM(E8:E'.$total.')')
						->setCellValue('F'.$rec,'=SUM(F8:F'.$total.')')
						->setCellValue('G'.$rec,'=SUM(G8:G'.$total.')');
						$this->newphpexcel->set_detilstyle(array('A'.$rec,'B'.$rec,'C'.$rec,'D'.$rec,'E'.$rec,'F'.$rec,'G'.$rec));
				}else{
					$this->newphpexcel->getActiveSheet()->mergeCells('A8:G8');
					$this->newphpexcel->setActiveSheetIndex($idx)->setCellValue('A8','Data Tidak Ditemukan');
					$this->newphpexcel->set_detilstyle(array('A8','B8','C8','D8','E8','F8','G8'));
				}
				$idx++;
			}
			#Akhir Pelayanan Napza
			ob_clean();
			$file = "RHPK_DATA_PELAYANAN.xls";
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