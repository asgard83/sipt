<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);
class Detil_01JJ extends Model{
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
				
			$query = "SELECT LTRIM(RTRIM(UPPER(REPLACE(A.NAMA_SARANA,'-','')))) AS NAMA_SARANA, CAST(A.ALAMAT_1+' '+C.NAMA_PROPINSI+' '+B.NAMA_PROPINSI AS VARCHAR(255)) AS ALAMAT, A.NAMA_PANGAN AS [NAMA PRODUK PANGAN], A.JENIS_PANGAN AS [JENIS PRODUK PANGAN], CONVERT(VARCHAR(10), D.AWAL_PERIKSA, 103) + ' s.d ' + CONVERT(VARCHAR(10), D.AKHIR_PERIKSA, 103) AS [TANGGAL], E.FISIK, E.OPERASIONAL, E.ASPEK_KETERANGAN, E.JUMLAH_MINOR, E.JUMLAH_MAJOR, E.JUMLAH_SERIUS, E.JUMLAH_KRITIS, D.HASIL, E.FISIK_PERBAIKAN, FISIK_TIMELINE, E.OPERASIONAL_PERBAIKAN, E.OPERASIONAL_TIMELINE, E.ADMINISTRATIF, E.ADMINISTRATIF_PERBAIKAN, E.ADMINISTRATIF_TIMELINE, E.LAINLAIN, E.LAINLAIN_PERBAIKAN, E.LAINLAIN_TIMELINE FROM M_SARANA A LEFT JOIN M_PROPINSI B ON A.PROPINSI = B.PROPINSI_ID LEFT JOIN M_PROPINSI C ON A.KOTA = C.PROPINSI_ID LEFT JOIN T_PEMERIKSAAN D ON A.SARANA_ID = D.SARANA_ID LEFT JOIN T_PEMERIKSAAN_PANGAN E ON D.PERIKSA_ID = E.PERIKSA_ID $klas WHERE D.JENIS_SARANA_ID ='".$this->input->post('JENIS')."'";
			
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

			if($this->input->post('TEMUAN') != "") $query .= " AND E.ADMINISTRATIF LIKE '%".$this->input->post('TEMUAN')."%' OR E.FISIK LIKE '%".$this->input->post('TEMUAN')."%' OR E.OPERASIONAL LIKE '%".$this->input->post('TEMUAN')."%' OR E.LAINLAIN LIKE '%".$this->input->post('TEMUAN')."%'";
			if(trim($this->input->post('KOTA')!="")) $query .= " AND A.KOTA  = '".$this->input->post('KOTA')."'";
			if($this->input->post('KK_ID') != "") $query .= " AND F.KK_ID = '".$this->input->post('KK_ID')."'";
			$query .= " ORDER BY 1 ASC";
			$this->newphpexcel->getDefaultStyle()->getFont()->setName('Calibri')->setSize(10);
			$this->newphpexcel->setActiveSheetIndex(0);
			$this->newphpexcel->mergecell(array(array('A1','X1'),array('A2','B2'),array('A3','B3'),array('A4','B4'),array('A5','B5')), FALSE);
			$this->newphpexcel->mergecell(array(array('A7','A8'),array('B7','B8'),array('C7','C8'),array('D7','D8'),array('E7','E8'),array('F7','F8'),array('G7','I7'),array('J7','L7'),array('M7','O7'),array('P7','R7'),array('S7','S8'),array('T7','W7'),array('X7','X8')), TRUE);
			
			$this->newphpexcel->width(array(array('A',5),array('B',30),array('C',30),array('D',30),array('E',30),array('F',25),array('G',30),array('H',30),array('I',30),array('J',30),array('K',30),array('L',30),array('M',30),array('N',30),array('O',30),array('P',30),array('Q',30),array('R',30),array('S',30),array('T',5),array('U',5),array('V',5),array('W',5)));
			$this->newphpexcel->set_bold(array('A1','C2','C5'));
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A1', 'LAPORAN HASIL PEMERIKSAAN SARANA PRODUKSI PANGAN MD')->setCellValue('A2', 'Jenis Sarana')->setCellValue('C2', $judul)->setCellValue('A3', 'Pemeriksaan Awal')->setCellValue('C3', $awal)->setCellValue('A4', 'Pemeriksaan Akhir')->setCellValue('C4', $akhir)->setCellValue('A5', 'Balai Besar / Balai POM')->setCellValue('C5', $balai);
			
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A7','No.')->setCellValue('B7','Nama Sarana')->setCellValue('C7','Alamat')->setCellValue('D7','Nama Produk Pangan')->setCellValue('E7','Jenis Produk Pangan')->setCellValue('F7','Tanggal Periksa')->setCellValue('G7','Penyimpangan Fisik')->setCellValue('J7','Penyimpangan Operasional')->setCellValue('M7','Penyimpangan Operasional')->setCellValue('P7','Penyimpangan Lain-lain')->setCellValue('S7','Keterangan Aspek')->setCellValue('T7','Jumlah Penyimpangan')->setCellValue('X7','Hasil')->setCellValue('G8','Penyimpangan')->setCellValue('H8','Perbaikan')->setCellValue('I8','Timeline')->setCellValue('J8','Penyimpangan')->setCellValue('K8','Perbaikan')->setCellValue('L8','Timeline')->setCellValue('M8','Penyimpangan')->setCellValue('N8','Perbaikan')->setCellValue('O8','Timeline')->setCellValue('P8','Penyimpangan')->setCellValue('Q8','Perbaikan')->setCellValue('R8','Timeline')->setCellValue('T8','Minor')->setCellValue('U8','Major')->setCellValue('V8','Serius')->setCellValue('W8','Kritis');
			
			$this->newphpexcel->headings(array('A7','B7','C7','D7','E7','F7','G7','H7','I7','J7','K7','L7','M7','N7','O7','P7','Q7','R7','S7','T7','U7','V7','W7','X7'));
			$this->newphpexcel->headings(array('A8','B8','C8','D8','E8','F8','G8','H8','I8','J8','K8','L8','M8','N8','O8','P8','Q8','R8','S8','T8','U8','V8','W8','X8'));
			$this->newphpexcel->set_wrap(array('B','C','D','E','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X'));
			$data = $sipt->main->get_result($query);
			if($data){
				$no=1;
				$rec = 9;
				foreach($query->result_array() as $row){
					$arr = explode("#",str_replace("|",". ",$row['ASPEK_KETERANGAN']));
					$ket = $this->aspek_keterangan($arr);
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A'.$rec,$no)
					->setCellValue('B'.$rec,strtoupper($row["NAMA_SARANA"]))
					->setCellValue('C'.$rec,$row["ALAMAT"])
					->setCellValue('D'.$rec,$row["NAMA PRODUK PANGAN"])
					->setCellValue('E'.$rec,$row["JENIS PRODUK PANGAN"])
					->setCellValue('F'.$rec,$row["TANGGAL"])
					->setCellValue('G'.$rec,preg_replace('/<[^>]*>/',' ',str_replace("&nbsp;","",html_entity_decode($row["FISIK"]))))
					->setCellValue('H'.$rec,preg_replace('/<[^>]*>/',' ',str_replace("&nbsp;","",html_entity_decode($row["FISIK_PERBAIKAN"]))))
					->setCellValue('I'.$rec,preg_replace('/<[^>]*>/',' ',str_replace("&nbsp;","",html_entity_decode(str_replace("|", ", ", $row["FISIK_TIMELINE"])))))
					->setCellValue('J'.$rec,preg_replace('/<[^>]*>/',' ',str_replace("&nbsp;","",html_entity_decode($row["OPERASIONAL"]))))
					->setCellValue('K'.$rec,preg_replace('/<[^>]*>/',' ',str_replace("&nbsp;","",html_entity_decode($row["OPERASIONAL_PERBAIKAN"]))))
					->setCellValue('L'.$rec,preg_replace('/<[^>]*>/',' ',str_replace("&nbsp;","",html_entity_decode(str_replace("|", ", ", $row["OPERASIONAL_TIMELINE"])))))
					->setCellValue('M'.$rec,preg_replace('/<[^>]*>/',' ',str_replace("&nbsp;","",html_entity_decode($row["ADMINISTRTIF"]))))
					->setCellValue('N'.$rec,preg_replace('/<[^>]*>/',' ',str_replace("&nbsp;","",html_entity_decode($row["ADMINISTRATIF_PERBAIKAN"]))))
					->setCellValue('O'.$rec,preg_replace('/<[^>]*>/',' ',str_replace("&nbsp;","",html_entity_decode($row["ADMINISTRATIF_TIMELINE"]))))
					->setCellValue('P'.$rec,preg_replace('/<[^>]*>/',' ',str_replace("&nbsp;","",html_entity_decode($row["LAINLAIN"]))))
					->setCellValue('Q'.$rec,preg_replace('/<[^>]*>/',' ',str_replace("&nbsp;","",html_entity_decode($row["LAINLAIN_PERBAIKAN"]))))
					->setCellValue('R'.$rec,preg_replace('/<[^>]*>/',' ',str_replace("&nbsp;","",html_entity_decode(str_replace("|", ", ", $row["LAINLAIN_TIMELINE"])))))
					->setCellValue('S'.$rec,$ket)
					->setCellValue('T'.$rec,$row["JUMLAH_MINOR"])
					->setCellValue('U'.$rec,$row["JUMLAH_MAJOR"])
					->setCellValue('V'.$rec,$row["JUMLAH_SERIUS"])
					->setCellValue('W'.$rec,$row["JUMLAH_KRITIS"])
					->setCellValue('X'.$rec,$row["HASIL"]);
					$this->newphpexcel->set_detilstyle(array('A'.$rec,'B'.$rec,'C'.$rec,'D'.$rec,'E'.$rec,'F'.$rec,'G'.$rec,'H'.$rec,'I'.$rec,'J'.$rec,'K'.$rec,'L'.$rec,'M'.$rec,'N'.$rec,'O'.$rec,'P'.$rec,'Q'.$rec,'R'.$rec,'S'.$rec,'T'.$rec,'U'.$rec,'V'.$rec,'W'.$rec,'X'.$rec));
					$rec++;
					$no++;
				}
			}else{
				$this->newphpexcel->getActiveSheet()->mergeCells('A9:X9');
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
	
	function aspek_keterangan($aspek = NULL){
		$keterangan = "";
		if(!is_array($aspek)){
			return $keterangan;
		}
		foreach($aspek as $a){
			if(strlen($a) > 5) $keterangan .= $a.";";
		}
		return $keterangan;
	}
	
	function rekap_01JJ(){
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
				$filter1 .= " AND DATEDIFF(dy, 0, convert(DATETIME, AWAL_PERIKSA, 105)) <= DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('AKHIR')."', 105))  AND LEN(STATUS) > 2";
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
			$query = "SELECT DISTINCT(REPLACE(REPLACE(C.NAMA_BBPOM,'BALAI BESAR POM', 'BBPOM'),'BALAI POM','BPOM')) AS NAMA_BBPOM, 
					 (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE JENIS_SARANA_ID = '01JJ' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS JMLPERIKSA,
					 (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'A' AND JENIS_SARANA_ID = '01JJ' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS A,
					 (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'B' AND JENIS_SARANA_ID = '01JJ' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS B, 
					 (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'C' AND JENIS_SARANA_ID = '01JJ' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS C,
					 (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'D' AND JENIS_SARANA_ID = '01JJ' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS D,
					 (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'TTP' AND JENIS_SARANA_ID = '01JJ' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS TTP,
					 (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'TDP' AND JENIS_SARANA_ID = '01JJ' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS NOL
					 FROM T_PEMERIKSAAN A LEFT JOIN M_BBPOM C ON A.BBPOM_ID = C.BBPOM_ID WHERE A.JENIS_SARANA_ID = '01JJ' $filter2 AND LEN(A.STATUS) > 2 ORDER BY 1"; 
			$this->newphpexcel->set_font('Calibri',10);

			$this->newphpexcel->setActiveSheetIndex(0);
			$this->newphpexcel->mergecell(array(array('A1','I1'),array('A2','I2'),array('A3','I3'),array('A4','I4'),array('A6','A7'),array('C6','I6')), TRUE);
			$this->newphpexcel->mergecell(array(array('B6','B7')), FALSE);
			$this->newphpexcel->width(array(array('A',4), array('B',45),array('C',8),array('D',8),array('E',8),array('F',8),array('G',8),array('H',8),array('I',15)));
			$this->newphpexcel->set_bold(array('A1','A2','A3','A4'));
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A1', 'REKAPITULASI HASIL PEMERIKSAAN SARANA')->setCellValue('A2',$judul)->setCellValue('A3', strtoupper($balai))->setCellValue('A4', 'PERIODE : '.$awal.' s.d '.$akhir);
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A6','No.')->setCellValue('B6','BB / BPOM')->setCellValue('C6','Jumlah')->setCellValue('C7','Diperiksa')->setCellValue('D7','A (Baik Sekali)')->setCellValue('E7','B (Baik)')->setCellValue('F7','C (Cukup)')->setCellValue('G7','D (Jelek)')->setCellValue('H7','Tutup')->setCellValue('I7','Tidak Dapat Diperiksa');
			$this->newphpexcel->headings(array('A6','B6','C6','D6','E6','F6','B7','C7','D7','E7','F7','G6','G7','H6','H7','I6','I7'));
			$data = $sipt->main->get_result($query);
			if($data){
				$no=1;
				$rec = 8;
				foreach($query->result_array() as $row){
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A'.$rec,$no)
															  ->setCellValue('B'.$rec,$row["NAMA_BBPOM"])
															  ->setCellValue('C'.$rec,$row["JMLPERIKSA"])
															  ->setCellValue('D'.$rec,$row["A"])
															  ->setCellValue('E'.$rec,$row["B"])
															  ->setCellValue('F'.$rec,$row["C"])
															  ->setCellValue('G'.$rec,$row["D"])
															  ->setCellValue('H'.$rec,$row["TTP"])
															  ->setCellValue('I'.$rec,$row["NOL"]);
					$this->newphpexcel->set_detilstyle(array('A'.$rec,'B'.$rec,'C'.$rec,'D'.$rec,'E'.$rec,'F'.$rec,'G'.$rec,'H'.$rec,'I'.$rec));
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
					->setCellValue('I'.$rec,'=SUM(I8:I'.$total.')');
					$this->newphpexcel->set_detilstyle(array('A'.$rec,'B'.$rec,'C'.$rec,'D'.$rec,'E'.$rec,'F'.$rec,'G'.$rec,'H'.$rec,'I'.$rec));
			}else{
				$this->newphpexcel->getActiveSheet()->mergeCells('A8:I8');
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