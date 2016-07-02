<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);
class Detil_01OO extends Model{
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
			$query = "SELECT LTRIM(RTRIM(UPPER(REPLACE(A.NAMA_SARANA,'-','')))) AS NAMA_SARANA, CAST(A.ALAMAT_1+' '+C.NAMA_PROPINSI+' '+B.NAMA_PROPINSI AS VARCHAR(255)) AS ALAMAT, CONVERT(VARCHAR(10), D.AWAL_PERIKSA, 103) + ' s.d ' + CONVERT(VARCHAR(10), D.AKHIR_PERIKSA, 103) AS [TANGGAL], E.NOMOR_INSPEKSI, E.STANDARD, E.KEPATUHAN_CPOB, E.LATAR_BELAKANG, E.PERUBAHAN_BERMAKNA, E.RUANG_LINGKUP, E.AREA_INSPEKSI, E.DISTRIBUSI_LAPORAN, E.TEMUAN_KRITIKAL, E.TEMUAN_MAJOR, E.TEMUAN_MINOR, E.REKOMENDASI, E.KESIMPULAN, E.TINDAK_LANJUT, E.TIME_LINE, E.STATUS_CAPA, E.CAPA_CLOSED, STUFF(dbo.GROUP_PETUGAS(D.PERIKSA_ID),1,0,'') AS PETUGAS, D.HASIL FROM M_SARANA A LEFT JOIN M_PROPINSI B ON A.PROPINSI = B.PROPINSI_ID LEFT JOIN M_PROPINSI C ON A.KOTA = C.PROPINSI_ID LEFT JOIN T_PEMERIKSAAN D ON A.SARANA_ID = D.SARANA_ID LEFT JOIN T_PEMERIKSAAN_PRODUKSI_CPOB E ON D.PERIKSA_ID = E.PERIKSA_ID $klas WHERE D.JENIS_SARANA_ID = '".$this->input->post('JENIS')."'";
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
			if($this->newsession->userdata('SESS_BBPOM_ID') != "91" && $this->newsession->userdata('SESS_BBPOM_ID') != "00"){
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
			if($this->input->post('TEMUAN') != "") $query .= " AND E.KEPATUHAN_CPOB LIKE '%".$this->input->post('TEMUAN')."%'";
			if($this->input->post('TINDAKAN') != "") $query .= " AND E.TINDAK_LANJUT LIKE '%".$this->input->post('TINDAKAN')."%'";
			if($this->input->post('KK_ID') != "") $query .= " AND F.KK_ID = '".$this->input->post('KK_ID')."'";
			if(trim($this->input->post('KOTA')!="")) $query .= " AND A.KOTA  = '".$this->input->post('KOTA')."'";
			$query .= " ORDER BY 1 ASC";
			$this->newphpexcel->getDefaultStyle()->getFont()->setName('Calibri')->setSize(10);
			$this->newphpexcel->setActiveSheetIndex(0);
			$this->newphpexcel->mergecell(array(array('A1','V1'),array('A2','B2'),array('A3','B3'),array('A4','B4'),array('A5','B5')), FALSE);
			$this->newphpexcel->mergecell(array(array('A7','A8'),array('B7','C7'),array('D7','L7'),array('M7','O7'),array('P7','Q7'),array('R7','T7'),array('U7','V7')), TRUE);
			$this->newphpexcel->width(array(array('A',5),array('B',30),array('C',30),array('D',20),array('E',20),array('F',30),array('G',20),array('H',30),array('I',30),array('J',30),array('K',30),array('L',30),array('M',7),array('N',7),array('O',7),array('P',30),array('Q',30),array('R',20),array('S',20),array('T',20),array('U',20),array('V',20)));
			$this->newphpexcel->set_bold(array('A1','C2','C5'));
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A1', 'LAPORAN HASIL PEMERIKSAAN SARANA PRODUKSI INDUSTRI FARMASI')->setCellValue('A2', 'Jenis Sarana')->setCellValue('C2', $judul)->setCellValue('A3', 'Pemeriksaan Awal')->setCellValue('C3', $awal)->setCellValue('A4', 'Pemeriksaan Akhir')->setCellValue('C4', $akhir)->setCellValue('A5', 'Balai Besar / Balai POM')->setCellValue('C5', $balai);		
			
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A7','No.')->setCellValue('B7','Data Sarana')->setCellValue('D7','Pemeriksaan')->setCellValue('M7','Temuan')->setCellValue('P7','Rekomendasi')->setCellValue('R7','Kesimpulan')->setCellValue('U7','CAPA')->setCellValue('B8','Nama Sarana')->setCellValue('C8','Alamat')->setCellValue('D8','Tanggal')->setCellValue('E8','No Inspeksi')->setCellValue('F8','Standar')->setCellValue('G8','Kepatuhan CPOB')->setCellValue('H8','Latar Belakang')->setCellValue('I8','Perubahan Bermakna')->setCellValue('J8','Ruang Lingkup')->setCellValue('K8','Area Inspeksi')->setCellValue('L8','Distribusi Laporan')->setCellValue('M8','Kritikal')->setCellValue('N8','Major')->setCellValue('O8','Minor')->setCellValue('P8','Rekomendasi')->setCellValue('Q8','Kesimpulan')->setCellValue('R8','Hasil')->setCellValue('S8','Tindak Lanjut')->setCellValue('T8','Timeline')->setCellValue('U8','Status CAPA')->setCellValue('V8','CAPA Closed');
			$this->newphpexcel->headings(array('A7','B7','C7','D7','E7','F7','G7','H7','I7','J7','K7','L7','M7','N7','O7','P7','Q7','R7','S7','T7','U7',"V7"));
			$this->newphpexcel->headings(array('A8','B8','C8','D8','E8','F8','G8','H8','I8','J8','K8','L8','M8','N8','O8','P8','Q8','R8','S8','T8','U8',"V8"));
			$this->newphpexcel->set_wrap(array('B','C','D','E','F','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V'));
			$data = $sipt->main->get_result($query);
			if($data){
				$no=1;
				$rec = 9;
				foreach($query->result_array() as $row){
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A'.$rec,$no)
					->setCellValue('B'.$rec,strtoupper($row["NAMA_SARANA"]))
					->setCellValue('C'.$rec,$row["ALAMAT"])
					->setCellValue('D'.$rec,$row["TANGGAL"])
					->setCellValue('E'.$rec,preg_replace('/<[^>]*>/','',str_replace("&nbsp;","",html_entity_decode($row["NOMOR_INSPEKSI"]))))
					->setCellValue('F'.$rec,preg_replace('/<[^>]*>/','',str_replace("&nbsp;","",html_entity_decode($row["STANDARD"]))))
					->setCellValue('G'.$rec,preg_replace('/<[^>]*>/','',str_replace("&nbsp;","",html_entity_decode($row["KEPATUHAN_CPOB"]))))
					->setCellValue('H'.$rec,preg_replace('/<[^>]*>/','',str_replace("&nbsp;","",html_entity_decode($row["LATAR_BELAKANG"]))))
					->setCellValue('I'.$rec,preg_replace('/<[^>]*>/','',str_replace("&nbsp;","",html_entity_decode($row["PERUBAHAN_BERMAKNA"]))))
					->setCellValue('J'.$rec,preg_replace('/<[^>]*>/','',str_replace("&nbsp;","",html_entity_decode($row["RUANG_LINGKUP"]))))
					->setCellValue('K'.$rec,preg_replace('/<[^>]*>/','',str_replace("&nbsp;","",html_entity_decode($row["AREA_INSPEKSI"]))))
					->setCellValue('L'.$rec,preg_replace('/<[^>]*>/','',str_replace("&nbsp;","",html_entity_decode($row["DISTRIBUSI_LAPORAN"]))))
					->setCellValue('M'.$rec,$row["TEMUAN_KRITIKAL"])
					->setCellValue('N'.$rec,$row["TEMUAN_MAJOR"])
					->setCellValue('O'.$rec,$row["TEMUAN_MINOR"])
					->setCellValue('P'.$rec,preg_replace('/<[^>]*>/','',str_replace("&nbsp;","",html_entity_decode($row["REKOMENDASI"]))))
					->setCellValue('Q'.$rec,preg_replace('/<[^>]*>/','',str_replace("&nbsp;","",html_entity_decode($row["KESIMPULAN"]))))
					->setCellValue('R'.$rec,$row["HASIL"])
					->setCellValue('S'.$rec,$row["TINDAK_LANJUT"])
					->setCellValue('T'.$rec,preg_replace('/<[^>]*>/','',str_replace("&nbsp;","",html_entity_decode($row["TIME_LINE"]))))
					->setCellValue('U'.$rec,$row["STATUS_CAPA"])
					->setCellValue('V'.$rec,$row["CAPA_CLOSED"]);
					$this->newphpexcel->set_detilstyle(array('A'.$rec,'B'.$rec,'C'.$rec,'D'.$rec,'E'.$rec,'F'.$rec,'G'.$rec,'H'.$rec,'I'.$rec,'J'.$rec,'K'.$rec,'L'.$rec,'M'.$rec,'N'.$rec,'O'.$rec,'P'.$rec,'Q'.$rec,'R'.$rec,'S'.$rec,'T'.$rec,'U'.$rec,'V'.$rec));
					$rec++;
					$no++;
				}
			}else{
				$this->newphpexcel->getActiveSheet()->mergeCells('A9:V9');
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
	
	function rekap_01OO(){
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
					 FROM T_PEMERIKSAAN A LEFT JOIN M_BBPOM C ON A.BBPOM_ID = C.BBPOM_ID WHERE A.JENIS_SARANA_ID = '".$this->input->post('JENIS')." ' $filter2 AND LEN(A.STATUS) > 2 ORDER BY 1";
			$this->newphpexcel->set_font('Calibri',10);
			$this->newphpexcel->setActiveSheetIndex(0);
			$this->newphpexcel->mergecell(array(array('A1','O1'),array('A2','O2'),array('A3','O3'),array('A4','O4'),array('A6','A7'),array('C6','H6'),array('I6','O6')), TRUE);
			$this->newphpexcel->mergecell(array(array('B6','B7')), FALSE);
			$this->newphpexcel->width(array(array('A',4), array('B',45),array('C',8),array('D',5),array('E',7),array('F',7),array('G',7),array('H',15),array('I',10),array('J',10),array('K',12),array('L',12),array('M',12),array('N',12),array('O',12)));
			$this->newphpexcel->set_bold(array('A1','A2','A3','A4'));
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A1', 'REKAPITULASI HASIL PEMERIKSAAN SARANA')->setCellValue('A2',$judul)->setCellValue('A3', strtoupper($balai))->setCellValue('A4', 'PERIODE : '.$awal.' s.d '.$akhir);
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A6','No.')->setCellValue('B6','BB / BPOM')->setCellValue('C6','Jumlah')->setCellValue('I6','Tindak Lanjut Terhadap Sarana')			
			->setCellValue('C7','Diperiksa')->setCellValue('D7','MK')->setCellValue('E7','Minor')->setCellValue('F7','Major')->setCellValue('G7','Kritikal')->setCellValue('H7','Tidak Ada Hasil')->setCellValue('I7','Perbaikan')->setCellValue('J7','Peringatan')->setCellValue('K7','Peringatan Keras')->setCellValue('L7','Penghentian Sementara Kegiatan')->setCellValue('M7','Pembekuan Sertifikat CPOB')->setCellValue('N7','Pencabutan Sertifikat')->setCellValue('O7','Penarikan Produk Jadi (Recall)');
			$this->newphpexcel->headings(array('A6','B6','C6','D6','E6','F6','G6','H6','I6','J6','K6','L6','M6','N6','O6','B7','C7','D7','E7','F7','G7','H7','I7','J7','K7','L7','M7','N7','O7'));
			$this->newphpexcel->set_wrap(array('F7','G7','H7','I7','J7','K7','L7','M7','N7','O7'));
			$data = $sipt->main->get_result($query);
			if($data){
				$no=1;
				$rec = 8;
				foreach($query->result_array() as $row){
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A'.$rec,$no)
															  ->setCellValue('B'.$rec,$row["NAMA_BBPOM"])
															  ->setCellValue('C'.$rec,$row["JMLPERIKSA"])
															  ->setCellValue('D'.$rec,$row["JMLMK"])
															  ->setCellValue('E'.$rec,$row["JMLMAJOR"])
															  ->setCellValue('F'.$rec,$row["JMLMINOR"])
															  ->setCellValue('G'.$rec,$row["JMLKRITIKAL"])
															  ->setCellValue('H'.$rec,$row["NULLNYA"])
															  ->setCellValue('I'.$rec,$row["PERBAIKAN"])
															  ->setCellValue('J'.$rec,$row["PERINGATAN"])
															  ->setCellValue('K'.$rec,$row["PK"])
															  ->setCellValue('L'.$rec,$row["PSK"])
															  ->setCellValue('M'.$rec,$row["PEMBEKUAN"])
															  ->setCellValue('N'.$rec,$row["PENCABUTAN"])
															  ->setCellValue('O'.$rec,$row["PENARIKAN"]);
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