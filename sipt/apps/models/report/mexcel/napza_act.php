<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);
class Napza_act extends Model{
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
			$query = "SELECT LTRIM(RTRIM(UPPER(REPLACE(A.NAMA_SARANA,'-','')))) AS NAMA_SARANA, CAST(A.ALAMAT_1+' '+C.NAMA_PROPINSI+' '+B.NAMA_PROPINSI AS VARCHAR(255)) AS ALAMAT, CONVERT(VARCHAR(10), D.AWAL_PERIKSA, 103) + ' s.d ' + CONVERT(VARCHAR(10), D.AKHIR_PERIKSA, 103) AS [TANGGAL], E.TUJUAN_PEMERIKSAAN, E.DASAR_PEMERIKSAAN,E.DETAIL_TINDAKAN_BALAI,E.DETAIL_TINDAKAN_PUSAT FROM M_SARANA A LEFT JOIN M_PROPINSI B ON A.PROPINSI = B.PROPINSI_ID LEFT JOIN M_PROPINSI C ON A.KOTA = C.PROPINSI_ID LEFT JOIN T_PEMERIKSAAN D ON A.SARANA_ID = D.SARANA_ID LEFT JOIN T_PEMERIKSAAN_NAPZA E ON D.PERIKSA_ID = E.PERIKSA_ID $klas WHERE D.JENIS_SARANA_ID ='".$this->input->post('JENIS')."'";
			if(trim($this->input->post('HASIL'))!="")$query .= " AND D.HASIL = '".$this->input->post('HASIL')."'";
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
			if($this->newsession->userdata('SESS_BBPOM_ID') != "93" && $this->newsession->userdata('SESS_BBPOM_ID') != "00"){
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
			if($this->input->post('TINDAKAN') != "") $query .= " AND E.DETAIL_TINDAKAN_BALAI LIKE '%".$this->input->post('TINDAKAN')."%' OR E.DETAIL_TINDAKAN_PUSAT LIKE '%".$this->input->post('TINDAKAN')."%'";
			if($this->input->post('KK_ID') != "") $query .= " AND F.KK_ID = '".$this->input->post('KK_ID')."'";
			if(trim($this->input->post('KOTA')!="")) $query .= " AND A.KOTA  = '".$this->input->post('KOTA')."'";
			$query .= " ORDER BY 1 ASC";
			$this->newphpexcel->getDefaultStyle()->getFont()->setName('Calibri')->setSize(10);
			$this->newphpexcel->setActiveSheetIndex(0);
			$this->newphpexcel->mergecell(array(array('A1','H1'),array('A2','B2'),array('A3','B3'),array('A4','B4'),array('A5','B5')), FALSE);
			$this->newphpexcel->width(array(array('A',5),array('B',30),array('C',30),array('D',25),array('E',30),array('F',30),array('G',30),array('H',30)));
			$this->newphpexcel->set_bold(array('A1','C2','C5'));
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A1', 'LAPORAN HASIL PEMERIKSAAN SARANA PENGAWASAN NAPZA')->setCellValue('A2', 'Jenis Sarana')->setCellValue('C2', $judul)->setCellValue('A3', 'Pemeriksaan Awal')->setCellValue('C3', $awal)->setCellValue('A4', 'Pemeriksaan Akhir')->setCellValue('C4', $akhir)->setCellValue('A5', 'Balai Besar / Balai POM')->setCellValue('C5', $balai);
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A7','No.')->setCellValue('B7','Nama Sarana')->setCellValue('C7','Alamat')->setCellValue('D7','Tanggal Periksa')->setCellValue('E7','Tujuan Periksa')->setCellValue('F7','Dasar Pemeriksaan')->setCellValue('G7','Tindakan Balai')->setCellValue('H7','Tindakan Pusat');
			$this->newphpexcel->headings(array('A7','B7','C7','D7','E7','F7','G7','H7'));
			$this->newphpexcel->set_wrap(array('B','C','F','G','H'));
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
					->setCellValue('F'.$rec,$row["DASAR_PEMERIKSAAN"])
					->setCellValue('G'.$rec,$row["DETAIL_TINDAKAN_BALAI"])
					->setCellValue('H'.$rec,$row["DETAIL_TINDAKAN_PUSAT"]);
					$this->newphpexcel->set_detilstyle(array('A'.$rec,'B'.$rec,'C'.$rec,'D'.$rec,'E'.$rec,'F'.$rec,'G'.$rec,'H'.$rec));
					$rec++;
					$no++;
				}
			}else{
				$this->newphpexcel->getActiveSheet()->mergeCells('A8:H8');
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
	
	function rekap_napza(){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$this->load->library('newphpexcel');
						
			$filter1 = "";
			$filter2 = "";
			if(trim($this->input->post('AWAL')!="")){
				$filter1 .= " AND DATEDIFF(dy, 0, convert(DATETIME, AWAL_PERIKSA, 105)) >= DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('AWAL')."', 105))";
				$filter2 .= " AND DATEDIFF(dy, 0, convert(DATETIME, A.AWAL_PERIKSA, 105)) >= DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('AWAL')."', 105))";
				$awal = $this->input->post('AWAL');
			}else{
				$filter1 .= " AND AWAL_PERIKSA > GETDATE()";
				$filter2 .= " AND A.AWAL_PERIKSA > GETDATE()";
				$awal = date('01/m/Y');
			}
			if(trim($this->input->post('AKHIR')!="")){
				$filter1 .= " AND DATEDIFF(dy, 0, convert(DATETIME, AWAL_PERIKSA, 105)) <= DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('AKHIR')."', 105))";
				$filter2 .= " AND DATEDIFF(dy, 0, convert(DATETIME, A.AWAL_PERIKSA, 105)) <= DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('AKHIR')."', 105))";
				$akhir = $this->input->post('AKHIR');
			}else{
				$filter1 .= " AND AKHIR_PERIKSA < GETDATE()";
				$filter2 .= " AND A.AKHIR_PERIKSA < GETDATE()";
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
			$query = "SELECT DISTINCT(REPLACE(REPLACE(C.NAMA_BBPOM,'BALAI BESAR POM', 'BBPOM'),'BALAI POM','BPOM')) AS NAMA_BBPOM,(SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE JENIS_SARANA_ID = '".$this->input->post('JENIS')."' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS JMLPERIKSA, (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'MK' AND JENIS_SARANA_ID = '".$this->input->post('JENIS')."' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS JMLMK, (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'Minor' AND JENIS_SARANA_ID = '".$this->input->post('JENIS')."' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS JMLMINOR, (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'Major' AND JENIS_SARANA_ID = '".$this->input->post('JENIS')."' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS JMLMAJOR, (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'Kritikal' AND JENIS_SARANA_ID = '".$this->input->post('JENIS')."' AND BBPOM_ID = C.BBPOM_ID $filter1 AND LEN(STATUS) > 2) AS JMLKRITIKAL FROM T_PEMERIKSAAN A LEFT JOIN M_BBPOM C ON A.BBPOM_ID = C.BBPOM_ID WHERE A.JENIS_SARANA_ID = '".$this->input->post('JENIS')."' $filter2 AND LEN(A.STATUS) > 2 ORDER BY 1";
			$judul = strtoupper($sipt->main->get_uraian("SELECT dbo.NAMA_JENIS_SARANA('".$this->input->post('JENIS')."') AS JUDUL","JUDUL"));
			$this->newphpexcel->set_font('Calibri',10);
			$this->newphpexcel->setActiveSheetIndex(0);
			$this->newphpexcel->mergecell(array(array('A1','G1'),array('A2','G2'),array('A3','G3'),array('A4','G4'),array('A6','A7'),array('C6','G6')), TRUE);
			$this->newphpexcel->mergecell(array(array('B6','B7')), FALSE);
			$this->newphpexcel->width(array(array('A',4), array('B',45)));
			$this->newphpexcel->set_bold(array('A1','A2','A3','A4'));
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A1', 'REKAPITULASI HASIL PEMERIKSAAN SARANA')->setCellValue('A2',$judul)->setCellValue('A3', strtoupper($balai))->setCellValue('A4', 'PERIODE : '.$awal.' s.d '.$akhir);
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A6','No.')->setCellValue('B6','BB / BPOM')->setCellValue('C6','Jumlah')->setCellValue('C7','Diperiksa')->setCellValue('D7','MK')->setCellValue('E7','Minor')->setCellValue('F7','Major')->setCellValue('G7','Kritikal');
			$this->newphpexcel->headings(array('A6','B6','C6','D6','E6','F6','G6','B7','C7','D7','E7','F7','G7'));
			$data = $sipt->main->get_result($query);
			if($data){
				$no=1;
				$rec = 8;
				foreach($query->result_array() as $row){
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A'.$rec,$no)
															  ->setCellValue('B'.$rec,$row["NAMA_BBPOM"])
															  ->setCellValue('C'.$rec,$row["JMLPERIKSA"])
															  ->setCellValue('D'.$rec,$row["JMLMK"])
															  ->setCellValue('E'.$rec,$row["JMLMINOR"])
															  ->setCellValue('F'.$rec,$row["JMLMAJOR"])
															  ->setCellValue('G'.$rec,$row["JMLKRITIKAL"]);
					$this->newphpexcel->set_detilstyle(array('A'.$rec,'B'.$rec,'C'.$rec,'D'.$rec,'E'.$rec,'F'.$rec,'G'.$rec));
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
					->setCellValue('G'.$rec,'=SUM(G8:G'.$total.')');
					$this->newphpexcel->set_detilstyle(array('A'.$rec,'B'.$rec,'C'.$rec,'D'.$rec,'E'.$rec,'F'.$rec,'G'.$rec));
			}else{
				$this->newphpexcel->getActiveSheet()->mergeCells('A8:G8');
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