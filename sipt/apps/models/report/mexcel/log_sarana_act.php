<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);
class Log_sarana_act extends Model{
	
	function set_log_sarana(){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$this->load->library('newphpexcel');
			$sarana = "'".join("','", $this->newsession->userdata('SESS_SARANA'))."'";
			if($this->input->post('KK_ID') != "")
				$klas = " LEFT JOIN T_PEMERIKSAAN_KLASIFIKASI E ON E.PERIKSA_ID = B.PERIKSA_ID ";
			else
				$klas = "";
			$query = "SELECT LTRIM(RTRIM(UPPER(REPLACE(A.NAMA_SARANA,'-','')))) AS [NAMA SARANA], A.ALAMAT_1+' - '+C.NAMA_PROPINSI AS [ALAMAT], STUFF(dbo.GROUP_KK(B.PERIKSA_ID),1,1,'') AS KOMODITI, dbo.NAMA_JENIS_SARANA(B.JENIS_SARANA_ID) AS JENIS_SARANA, CONVERT(VARCHAR(10), B.AWAL_PERIKSA, 103) + ' s.d ' + CONVERT(VARCHAR(10), B.AKHIR_PERIKSA, 103) AS [TANGGAL PERIKSA], REPLACE(REPLACE(D.NAMA_BBPOM,'BALAI BESAR POM', 'BBPOM '),'BALAI POM','BPOM ') AS [BB/BPOM], B.HASIL FROM M_SARANA A LEFT JOIN T_PEMERIKSAAN B ON B.SARANA_ID = A.SARANA_ID LEFT JOIN M_PROPINSI C ON A.PROPINSI = C.PROPINSI_ID LEFT JOIN M_BBPOM D ON B.BBPOM_ID = D.BBPOM_ID $klas WHERE B.JENIS_SARANA_ID IN ($sarana)";
			if(trim($this->input->post('NAMA_SARANA')!="")){
				$query .= " AND A.NAMA_SARANA LIKE '%".$this->input->post('NAMA_SARANA')."%'";
			}
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
			if(trim($this->input->post('HASIL')) != "") $query .= " AND B.HASIL = '".$this->input->post('HASIL')."'";
			if(in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')) || $this->newsession->userdata('SESS_BBPOM_ID') == "00"){
				if(trim($this->input->post('BBPOM_ID'))==""){
					$query .= "";
					$balai = 'Seluruh Balai';
				}else{
					$query .= " AND B.BBPOM_ID = '".$this->input->post('BBPOM_ID')."'";
					$balai = $sipt->main->get_uraian("SELECT NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID = '".$this->input->post('BBPOM_ID')."'","NAMA_BBPOM");		
				}
			}else{
				$query .= " AND B.BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'";
				$balai = $sipt->main->get_uraian("SELECT NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","NAMA_BBPOM");		
			}
			$query .= " ORDER BY 1 ASC";
			$this->newphpexcel->getDefaultStyle()->getFont()->setName('Calibri')->setSize(10);
			$this->newphpexcel->setActiveSheetIndex(0);
			$this->newphpexcel->mergecell(array(array('A1','H1'),array('A2','B2'),array('A3','B3'),array('A4','B4'),array('A5','B5')), FALSE);
			$this->newphpexcel->width(array(array('A',5),array('B',30),array('C',30),array('D',20),array('E',20),array('F',25),array('G',20),array('H',10)));
			$this->newphpexcel->set_bold(array('A1','C2','C5'));
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A1', 'LAPORAN LOG PEMERIKSAAN SARANA')->setCellValue('C2', $judul)->setCellValue('A3', 'Pemeriksaan Awal')->setCellValue('C3', $awal)->setCellValue('A4', 'Pemeriksaan Akhir')->setCellValue('C4', $akhir)->setCellValue('A5', 'Balai Besar / Balai POM')->setCellValue('C5', $balai);		
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A7','No.')->setCellValue('B7','Nama Sarana')->setCellValue('C7','Alamat')->setCellValue('D7','Komoditi')->setCellValue('E7','Jenis Sarana')->setCellValue('F7','Tanggal Periksa')->setCellValue('G7','Balai Pemeriksa')->setCellValue('H7','Hasil');
			$this->newphpexcel->headings(array('A7','B7','C7','D7','E7','F7','G7','H7'));
			$this->newphpexcel->set_wrap(array('B','C','D','E','F','G','H'));
			$data = $sipt->main->get_result($query);
			if($data){
				$no=1;
				$rec = 8;
				foreach($query->result_array() as $row){
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A'.$rec,$no)
					->setCellValue('B'.$rec,$row["NAMA SARANA"])
					->setCellValue('C'.$rec,$row["ALAMAT"])
					->setCellValue('D'.$rec,$row["KOMODITI"])
					->setCellValue('E'.$rec,$row["JENIS_SARANA"])
					->setCellValue('F'.$rec,$row["TANGGAL PERIKSA"])
					->setCellValue('G'.$rec,$row["BB/BPOM"])
					->setCellValue('H'.$rec,$row["HASIL"]);
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
			$file = "LOG_REPORT_SARANA.xls";
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