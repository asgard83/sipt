<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);
class Rhpk_act extends Model{
	
	function get_rphk(){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$this->load->library('newphpexcel');
			$this->newphpexcel->set_font('Calibri',10);
			
			/*$query = "SELECT dbo.KATEGORI(KOMODITI) AS KOMODITI,
					  SUM(CASE WHEN ANGGARAN = '01' OR ANGGARAN = '02' OR ANGGARAN = '03' OR ANGGARAN = '04' OR ANGGARAN = '08' OR ANGGARAN = '09' OR ANGGARAN = '10' OR ANGGARAN = '11' THEN 1 ELSE 0 END) AS JMLDIPA,
					  SUM(CASE WHEN ANGGARAN = '05' OR ANGGARAN = '06' OR ANGGARAN = '07' THEN 1 ELSE 0 END) AS JML3,
					  SUM(CASE WHEN STATUS_SAMPEL = '50202' THEN 1 ELSE 0 END) AS SELESAIUJI,
					  COUNT(*) AS TOTAL,
					  SUM(CASE WHEN HASIL_SAMPEL = 'MS' AND STATUS_SAMPEL = '50202' THEN 1 ELSE 0 END) AS MS,
					  SUM(CASE WHEN HASIL_SAMPEL = 'TMS' AND STATUS_SAMPEL = '50202' THEN 1 ELSE 0 END) AS TMS,
					  SUM(CASE WHEN HASIL_SAMPEL = 'HPST' AND STATUS_SAMPEL = '50202' THEN 1 ELSE 0 END) AS HPST
					  FROM T_M_SAMPEL ";*/
			$query = "SELECT dbo.KATEGORI(KOMODITI,PRIORITAS) AS KOMODITI,
					  SUM(CASE WHEN ANGGARAN = '01' OR ANGGARAN = '02' OR ANGGARAN = '03' OR ANGGARAN = '04' OR ANGGARAN = '08' OR ANGGARAN = '09' OR ANGGARAN = '10' OR ANGGARAN = '11' THEN 1 ELSE 0 END) AS JMLDIPA,
					  SUM(CASE WHEN ANGGARAN = '05' OR ANGGARAN = '06' OR ANGGARAN = '07' THEN 1 ELSE 0 END) AS JML3,
					  COUNT(*) AS TOTAL,
					  SUM(CASE WHEN HASIL_SAMPEL = 'MS' THEN 1 ELSE 0 END) AS MS,
					  SUM(CASE WHEN HASIL_SAMPEL = 'TMS' THEN 1 ELSE 0 END) AS TMS,
					  SUM(CASE WHEN HASIL_SAMPEL = 'HPST' THEN 1 ELSE 0 END) AS HPST
					  FROM T_M_SAMPEL ";		  
			
			if(trim($this->input->post('TUJUAN_SAMPLING')!="")){
				$query .= $sipt->main->find_where($query);
				$query .= " TUJUAN_SAMPLING = '".$this->input->post('TUJUAN_SAMPLING')."' ";
				$tujuan = $sipt->main->get_uraian("SELECT URAIAN FROM M_TABEL WHERE JENIS = 'TUJUAN_SAMPLING' AND KODE = '".$this->input->post('TUJUAN_SAMPLING')."'","URAIAN");
			}else{
				$tujuan = "";
			}
			
			if(trim($this->input->post('ASAL_SAMPLING')!="")){
				$query .= $sipt->main->find_where($query);
				$query .= " ASAL_SAMPEL = '".$this->input->post('ASAL_SAMPLING')."' ";
				$asal = $sipt->main->get_uraian("SELECT URAIAN FROM M_TABEL WHERE JENIS = 'ASAL_SAMPLING' AND KODE = '".$this->input->post('ASAL_SAMPLING')."'","URAIAN");
			}else{
				$asal = "";
			}
			
			if(trim($this->input->post('AWAL')!="")){
				$query .= $sipt->main->find_where($query);
				$query .= " DATEDIFF(dy, 0, convert(DATETIME, TANGGAL_SAMPLING, 105)) >= DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('AWAL')."', 105))";
				$awal = $this->input->post('AWAL');
			}else{
				$query .= $sipt->main->find_where($query);
				$query .= " TANGGAL_SAMPLING > GETDATE() ";
				$awal = date('01/m/Y');
			}
			if(trim($this->input->post('AKHIR')!="")){
				$query .= $sipt->main->find_where($query);
				$query .= " DATEDIFF(dy, 0, convert(DATETIME, TANGGAL_SAMPLING, 105)) <= DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('AKHIR')."', 105))";
				$akhir = $this->input->post('AKHIR');
			}else{
				$query .= $sipt->main->find_where($query);
				$query .= " TANGGAL_SAMPLING < GETDATE() ";
				$akhir = date('t/m/Y');
			}
			
			$kode_balai = $sipt->main->get_uraian("SELECT KODE_BALAI FROM M_NOMOR WHERE BBPOM_ID = '".$this->input->post('BBPOM_ID')."'","KODE_BALAI");
			$query .= $sipt->main->find_where($query);
			$kode_balai = strlen($kode_balai) == "2" ? '0'.$kode_balai : $kode_balai;
			$query .= " SUBSTRING(KODE_SAMPEL, 3,3) = '".$kode_balai."'";
			$query .= $sipt->main->find_where($query);
			$query .= " STATUS_SAMPEL NOT IN ('00000')";
			$query .= "GROUP BY KOMODITI, PRIORITAS ORDER BY 1";
			$balai = $sipt->main->get_uraian("SELECT NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID = '".$this->input->post('BBPOM_ID')."'","NAMA_BBPOM");
			$this->newphpexcel->mergecell(array(array('A1','I1'),array('A3','B3'),array('A4','B4'),array('A5','B5'),array('A6','B6'),array('D3','I3'),array('D4','I4'),array('D5','I5'),array('D6','I6')),FALSE);
			$this->newphpexcel->mergecell(array(array('A8','A9'),array('B8','B9'),array('C8','F8'),array('G8','I8')), TRUE);
			$this->newphpexcel->set_title('RHPK - SAMPLING');
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A1', 'REKAPITULASI HASIL PELAKSANAAN KEGIATAN')->setCellValue('A3', 'BALAI BESAR / BALAI POM')->setCellValue('D3', strtoupper($balai))->setCellValue('A4', 'Periode Sampling')->setCellValue('D4', $awal.' s.d '.$akhir)->setCellValue('A5', 'Tujuan Sampling')->setCellValue('D5', $tujuan)->setCellValue('A6', 'Asal Sampel')->setCellValue('D6', $asal);
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A8','No.')->setCellValue('B8','Komoditi')->setCellValue('C8','Total Sampel')->setCellValue('G8','Hasil Sampel')->setCellValue('C9','DIPA')->setCellValue('D9','Pihak Ketiga')->setCellValue('E9','Selesai Uji')->setCellValue('F9','Total')->setCellValue('G9','MS')->setCellValue('H9','TMS')->setCellValue('I9','HPST');
			$this->newphpexcel->headings(array('A8','B8','C8','D8','E8','F8','G8','H8','I8','A9','B9','C9','D9','E9','F9','G9','H9','I9'));
			$this->newphpexcel->width(array(array('A',7), array('B',40), array('C',8), array('D',13), array('E',12), array('F',12)));
			
			$data = $sipt->main->get_result($query);
			if($data){
				$no=1;
				$rec = 10;
				foreach($query->result_array() as $row){
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A'.$rec,$no)
					->setCellValue('B'.$rec,$row["KOMODITI"])
					->setCellValue('C'.$rec,$row["JMLDIPA"])
					->setCellValue('D'.$rec,$row["JML3"])
					->setCellValue('E'.$rec,'=SUM(G'.$rec.':I'.$rec.')')
					->setCellValue('F'.$rec,$row["TOTAL"])
					->setCellValue('G'.$rec,$row["MS"])
					->setCellValue('H'.$rec,$row["TMS"])
					->setCellValue('I'.$rec,$row["HPST"]);
					$this->newphpexcel->set_detilstyle(array('A'.$rec,'B'.$rec,'C'.$rec,'D'.$rec,'E'.$rec,'F'.$rec,'G'.$rec,'H'.$rec,'I'.$rec));
					$rec++;
					$no++;
				}
				$total = $rec - 1;
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A'.$rec,'')
				->setCellValue('B'.$rec,'Total')
				->setCellValue('C'.$rec,'=SUM(C10:C'.$total.')')
				->setCellValue('D'.$rec,'=SUM(D10:D'.$total.')')
				->setCellValue('E'.$rec,'=SUM(E10:E'.$total.')')
				->setCellValue('F'.$rec,'=SUM(F10:F'.$total.')')
				->setCellValue('G'.$rec,'=SUM(G10:G'.$total.')')
				->setCellValue('H'.$rec,'=SUM(H10:H'.$total.')')
				->setCellValue('I'.$rec,'=SUM(I10:I'.$total.')');
				$this->newphpexcel->set_detilstyle(array('A'.$rec,'B'.$rec,'C'.$rec,'D'.$rec,'E'.$rec,'F'.$rec,'G'.$rec,'H'.$rec,'I'.$rec));
			}else{
				$this->newphpexcel->getActiveSheet()->mergeCells('A10:I10');
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A10','Data Tidak Ditemukan');
				$this->newphpexcel->set_detilstyle(array('A10'));
			}			
			
			ob_clean();
			$file = "RHPK_SAMPLING.xls";
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
	
	function get_rphk_all(){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$this->load->library('newphpexcel');
			$this->newphpexcel->set_font('Calibri',10);
			$query = "SELECT REPLACE(REPLACE(B.NAMA_BBPOM,'BALAI BESAR POM DI ', ''),'BALAI POM DI ','') AS NAMA_BBPOM,
					  SUM(CASE WHEN A.ANGGARAN = '01' OR A.ANGGARAN = '02' OR A.ANGGARAN = '03' OR A.ANGGARAN = '04' OR A.ANGGARAN = '08' OR A.ANGGARAN = '09' OR A.ANGGARAN = '10' OR A.ANGGARAN = '11' THEN 1 ELSE 0 END) AS JMLDIPA,
					  SUM(CASE WHEN A.ANGGARAN = '05' OR A.ANGGARAN = '06' OR A.ANGGARAN = '07' THEN 1 ELSE 0 END) AS JML3,
					  COUNT(*) AS TOTAL,
					  SUM(CASE WHEN A.HASIL_SAMPEL = 'MS' AND A.STATUS_SAMPEL = '80215' THEN 1 ELSE 0 END) AS MS,
					  SUM(CASE WHEN A.HASIL_SAMPEL = 'TMS' AND A.STATUS_SAMPEL = '80215' THEN 1 ELSE 0 END) AS TMS,
					  SUM(CASE WHEN A.HASIL_SAMPEL = 'HPST' AND A.STATUS_SAMPEL = '80215' THEN 1 ELSE 0 END) AS HPST,
					  SUM(CASE WHEN A.STATUS_SAMPEL = '80215'THEN 1 ELSE 0 END) AS HASIL_UJI_BALAI
					  FROM T_M_SAMPEL A LEFT JOIN M_BBPOM B ON SUBSTRING(A.KODE_SAMPEL,3,3) = (CASE WHEN LEN(B.KODE_BALAI) = 2 THEN '0' + B.KODE_BALAI ELSE B.KODE_BALAI END) 
					  WHERE A.KOMODITI = '".$this->input->post('KOMODITI')."'";		  			
			if(trim($this->input->post('TUJUAN_SAMPLING')!="")){
				$query .= $sipt->main->find_where($query);
				$query .= " A.TUJUAN_SAMPLING = '".$this->input->post('TUJUAN_SAMPLING')."' ";
				$tujuan = $sipt->main->get_uraian("SELECT URAIAN FROM M_TABEL WHERE JENIS = 'TUJUAN_SAMPLING' AND KODE = '".$this->input->post('TUJUAN_SAMPLING')."'","URAIAN");
			}else{
				$tujuan = "";
			}
			
			if(trim($this->input->post('ASAL_SAMPLING')!="")){
				$query .= $sipt->main->find_where($query);
				$query .= " A.ASAL_SAMPEL = '".$this->input->post('ASAL_SAMPLING')."' ";
				$asal = $sipt->main->get_uraian("SELECT URAIAN FROM M_TABEL WHERE JENIS = 'ASAL_SAMPLING' AND KODE = '".$this->input->post('ASAL_SAMPLING')."'","URAIAN");
			}else{
				$asal = "";
			}
			
			if(trim($this->input->post('AWAL')!="")){
				$query .= $sipt->main->find_where($query);
				$query .= " DATEDIFF(dy, 0, convert(DATETIME, A.TANGGAL_SAMPLING, 105)) >= DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('AWAL')."', 105))";
				$awal = $this->input->post('AWAL');
			}else{
				$query .= $sipt->main->find_where($query);
				$query .= " A.TANGGAL_SAMPLING > GETDATE() ";
				$awal = date('01/m/Y');
			}
			if(trim($this->input->post('AKHIR')!="")){
				$query .= $sipt->main->find_where($query);
				$query .= " DATEDIFF(dy, 0, convert(DATETIME, A.TANGGAL_SAMPLING, 105)) <= DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('AKHIR')."', 105))";
				$akhir = $this->input->post('AKHIR');
			}else{
				$query .= $sipt->main->find_where($query);
				$query .= " A.TANGGAL_SAMPLING < GETDATE() ";
				$akhir = date('t/m/Y');
			}
			
			if(trim($this->input->post('BBPOM_ID')!="")){
				$kode_balai = $sipt->main->get_uraian("SELECT KODE_BALAI FROM M_NOMOR WHERE BBPOM_ID = '".$this->input->post('BBPOM_ID')."'","KODE_BALAI");
				$query .= $sipt->main->find_where($query);
				$kode_balai = strlen($kode_balai) == "2" ? '0'.$kode_balai : $kode_balai;
				$query .= " SUBSTRING(KODE_SAMPEL, 3,3) = '".$kode_balai."'";
				$balai = $sipt->main->get_uraian("SELECT NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID = '".$this->input->post('BBPOM_ID')."'","NAMA_BBPOM");
			}else{
				$balai = "Seluruh Balai";
			}
			$query .= $sipt->main->find_where($query);
			$query .= " STATUS_SAMPEL NOT IN ('00000')";
			$query .= " GROUP BY NAMA_BBPOM ORDER BY 1";
			
			$komoditi = $sipt->main->get_uraian("SELECT dbo.KATEGORI('".$this->input->post('KOMODITI')."','0') AS KOMODITI","KOMODITI");
			$this->newphpexcel->mergecell(array(array('A1','J1'),array('A3','B3'),array('A4','B4'),array('A5','B5'),array('A6','B6'),array('A7','B7'),array('D3','J3'),array('D4','J4'),array('D5','J5'),array('D6','J6'),array('D7','J7')),FALSE);
			$this->newphpexcel->mergecell(array(array('A9','A10'),array('B9','B10'),array('C9','F9'),array('G9','J9')), TRUE);
			$this->newphpexcel->set_title('RHPK - SAMPLING');
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A1', 'REKAPITULASI HASIL PELAKSANAAN KEGIATAN')->setCellValue('A3', 'BALAI BESAR / BALAI POM')->setCellValue('D3', strtoupper($balai))->setCellValue('A4', 'Komoditi')->setCellValue('D4', $komoditi)->setCellValue('A5', 'Periode Sampling')->setCellValue('D5', $awal.' s.d '.$akhir)->setCellValue('A6', 'Tujuan Sampling')->setCellValue('D6', $tujuan)->setCellValue('A7', 'Asal Sampel')->setCellValue('D7', $asal);
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A9','No.')->setCellValue('B9','Balai Besar / Balai POM')->setCellValue('C9','Total Sampel')->setCellValue('G9','Hasil Sampel')->setCellValue('C10','DIPA')->setCellValue('D10','Pihak Ketiga')->setCellValue('E10','Selesai Uji')->setCellValue('F10','Total')->setCellValue('G10','MS')->setCellValue('H10','TMS')->setCellValue('I10','HPST')->setCellValue('J10','Hasil Uji Balai');
			$this->newphpexcel->headings(array('A9','B9','C9','D9','E9','F9','G9','H9','I9','J9','A10','B10','C10','D10','E10','F10','G10','H10','I10','J10'));
			$this->newphpexcel->width(array(array('A',7), array('B',40), array('C',8), array('D',13), array('E',10), array('F',10), array('J',12)));
			
			$data = $sipt->main->get_result($query);
			$rec = 11;
			if($data){
				$no=1;
				foreach($query->result_array() as $row){
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A'.$rec,$no)
					->setCellValue('B'.$rec,$row["NAMA_BBPOM"])
					->setCellValue('C'.$rec,$row["JMLDIPA"])
					->setCellValue('D'.$rec,$row["JML3"])
					->setCellValue('E'.$rec,'=SUM(G'.$rec.':I'.$rec.')')
					->setCellValue('F'.$rec,$row["TOTAL"])
					->setCellValue('G'.$rec,$row["MS"])
					->setCellValue('H'.$rec,$row["TMS"])
					->setCellValue('I'.$rec,$row["HPST"])
					->setCellValue('J'.$rec,$row["HASIL_UJI_BALAI"]);
					$this->newphpexcel->set_detilstyle(array('A'.$rec,'B'.$rec,'C'.$rec,'D'.$rec,'E'.$rec,'F'.$rec,'G'.$rec,'H'.$rec,'I'.$rec,'J'.$rec));
					$rec++;
					$no++;
				}
				$total = $rec - 1;
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A'.$rec,'')
				->setCellValue('B'.$rec,'Total')
				->setCellValue('C'.$rec,'=SUM(C11:C'.$total.')')
				->setCellValue('D'.$rec,'=SUM(D11:D'.$total.')')
				->setCellValue('E'.$rec,'=SUM(E11:E'.$total.')')
				->setCellValue('F'.$rec,'=SUM(F11:F'.$total.')')
				->setCellValue('G'.$rec,'=SUM(G11:G'.$total.')')
				->setCellValue('H'.$rec,'=SUM(H11:H'.$total.')')
				->setCellValue('I'.$rec,'=SUM(I11:I'.$total.')')
				->setCellValue('J'.$rec,'=SUM(J11:J'.$total.')');
				$this->newphpexcel->set_detilstyle(array('A'.$rec,'B'.$rec,'C'.$rec,'D'.$rec,'E'.$rec,'F'.$rec,'G'.$rec,'H'.$rec,'I'.$rec,'J'.$rec));
			}else{
				$this->newphpexcel->getActiveSheet()->mergeCells('A11:J11');
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A11','Data Tidak Ditemukan');
				$this->newphpexcel->set_detilstyle(array('A11'));
			}			
			
			ob_clean();
			$file = "RHPK_SAMPLING_".str_replace(" ", "_",$komoditi).".xls";
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