<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

error_reporting(E_ERROR);

class Status_act extends Model{

	

	function get_status(){

		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){

			$sipt =& get_instance();

			$this->load->model("main", "main", true);

			$this->load->library('newphpexcel');

			/*$query = "SELECT REPLACE(REPLACE(B.NAMA_BBPOM,'BALAI BESAR POM DI ', ''),'BALAI POM DI ','') AS NAMA_BBPOM,
					 SUM(CASE WHEN A.STATUS_SAMPEL = '20106' THEN 1 ELSE 0 END) AS DRAFTSAMPEL,
					 SUM(CASE WHEN A.STATUS_SAMPEL = '20107' THEN 1 ELSE 0 END) AS REJECTSAMPEL,
					 SUM(CASE WHEN A.STATUS_SAMPEL = '30106' THEN 1 ELSE 0 END) AS SPUSPV1VER,
					 SUM(CASE WHEN A.STATUS_SAMPEL = '40106' THEN 1 ELSE 0 END) AS SPUSPV2VER,
					 SUM(CASE WHEN A.STATUS_SAMPEL = '70000' THEN 1 ELSE 0 END) AS TPS,
					 SUM(CASE WHEN A.STATUS_SAMPEL = '50201' THEN 1 ELSE 0 END) AS TPSCETAKSPU,
					 SUM(CASE WHEN A.STATUS_SAMPEL = '70001' THEN 1 ELSE 0 END) AS TPSTOLAKBIDANG,
					 SUM(CASE WHEN A.STATUS_SAMPEL = '80201' THEN 1 ELSE 0 END) AS MA,
					 SUM(CASE WHEN A.STATUS_SAMPEL = '50202' THEN 1 ELSE 0 END) AS HASIL_PENGUJIAN,
					 SUM(CASE WHEN A.STATUS_SAMPEL = '80215' THEN 1 ELSE 0 END) AS TERKIRIM_KEPUSAT,
					 SUM(CASE WHEN A.STATUS_SAMPEL = '40201' THEN 1 ELSE 0 END) AS PERINTAH_UJI,
					 SUM(CASE WHEN A.STATUS_SAMPEL = '40202' THEN 1 ELSE 0 END) AS KONSEP_LAPORAN,
					 SUM(CASE WHEN A.STATUS_SAMPEL = '40204' THEN 1 ELSE 0 END) AS VERIFIKASI_LHU,
					 SUM(CASE WHEN A.STATUS_SAMPEL = '30201' THEN 1 ELSE 0 END) AS SPK_BARU,
					 SUM(CASE WHEN A.STATUS_SAMPEL = '20201'THEN 1 ELSE 0 END) AS SPP_BARU,
					 SUM(CASE WHEN A.STATUS_SAMPEL = '30202' THEN 1 ELSE 0 END) AS DRAFT_CP
					 FROM T_M_SAMPEL A
					 LEFT JOIN M_BBPOM B ON SUBSTRING(A.KODE_SAMPEL,3,3) = (CASE WHEN LEN(B.KODE_BALAI) = 2 THEN '0' + B.KODE_BALAI ELSE B.KODE_BALAI END)
					 WHERE A.STATUS_SAMPEL NOT IN ('00000')";*/
			$query = "SELECT REPLACE(REPLACE(B.NAMA_BBPOM,'BALAI BESAR POM DI ', ''),'BALAI POM DI ','') AS NAMA_BBPOM,
					 SUM(CASE WHEN A.STATUS_SAMPEL = '20106' THEN 1 ELSE 0 END) AS DRAFTSAMPEL,
					 SUM(CASE WHEN A.STATUS_SAMPEL = '20107' THEN 1 ELSE 0 END) AS REJECTSAMPEL,
					 SUM(CASE WHEN A.STATUS_SAMPEL = '30106' THEN 1 ELSE 0 END) AS SPUSPV1VER,
					 SUM(CASE WHEN A.STATUS_SAMPEL = '40106' THEN 1 ELSE 0 END) AS SPUSPV2VER,
					 SUM(CASE WHEN A.STATUS_SAMPEL = '70000' THEN 1 ELSE 0 END) AS TPS,
					 SUM(CASE WHEN A.STATUS_SAMPEL = '50201' THEN 1 ELSE 0 END) AS TPSCETAKSPU,
					 SUM(CASE WHEN A.STATUS_SAMPEL = '70001' THEN 1 ELSE 0 END) AS TPSTOLAKBIDANG,
					 SUM(CASE WHEN A.STATUS_SAMPEL = '80201' THEN 1 ELSE 0 END) AS MA,
					 SUM(CASE WHEN A.STATUS_SAMPEL = '50202' THEN 1 ELSE 0 END) AS HASIL_PENGUJIAN,
					 SUM(CASE WHEN A.STATUS_SAMPEL = '80215' THEN 1 ELSE 0 END) AS TERKIRIM_KEPUSAT,
					 SUM(CASE WHEN A.STATUS_SAMPEL = '40201' THEN 1 ELSE 0 END) AS PERINTAH_UJI,
					 SUM(CASE WHEN A.STATUS_SAMPEL = '40202' THEN 1 ELSE 0 END) AS KONSEP_LAPORAN,
					 SUM(CASE WHEN A.STATUS_SAMPEL = '40204' THEN 1 ELSE 0 END) AS VERIFIKASI_LHU,
					 SUM(CASE WHEN A.STATUS_SAMPEL = '30201' THEN 1 ELSE 0 END) AS SPK_BARU,
					 SUM(CASE WHEN A.STATUS_SAMPEL = '20201'THEN 1 ELSE 0 END) AS SPP_BARU,
					 SUM(CASE WHEN A.STATUS_SAMPEL = '30202' THEN 1 ELSE 0 END) AS DRAFT_CP
					 FROM T_M_SAMPEL A
					 LEFT JOIN M_BBPOM B ON 
					 A.BBPOM_ID = B.BBPOM_ID
					 WHERE A.STATUS_SAMPEL NOT IN ('00000')";
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

			

			if(in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')) || $this->newsession->userdata('SESS_BBPOM_ID') == "00"){

				if(trim($this->input->post('BBPOM_ID'))==""){

					$query .= "";

					$balai = 'Seluruh Balai';

				}else{

					$query .= $sipt->main->find_where($query);

					$query .= " B.BBPOM_ID = '".$this->input->post('BBPOM_ID')."'";

					$balai = $sipt->main->get_uraian("SELECT NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID = '".$this->input->post('BBPOM_ID')."'","NAMA_BBPOM");		

				}

				if($this->newsession->userdata('SESS_BBPOM_ID') != "00"){

					if($this->newsession->userdata('SESS_BBPOM_ID') == '91'){#Ditwas Produksi

						$query .= $sipt->main->find_where($query);

						$query .= " LEFT(A.KATEGORI,2) = '01'";

					}else if($this->newsession->userdata('SESS_BBPOM_ID') == '92'){#Ditwas Distribusi

					$query .= $sipt->main->find_where($query);

						$query .= " LEFT(A.KATEGORI,2) = '01' AND A.TUJUAN_SAMPLING IN ('02')";

					}else if($this->newsession->userdata('SESS_BBPOM_ID') == '93'){#Ditwas NAPZA

						$query .= $sipt->main->find_where($query);

						$query .= " LEFT(A.KATEGORI,2) = '07' AND LEFT(A.KATEGORI,2) = '20'";

					}else if($this->newsession->userdata('SESS_BBPOM_ID') == '94'){#Insert OTKOS

						$query .= $sipt->main->find_where($query);

						$tmp = "";

						foreach($this->newsession->userdata('SESS_KLASIFIKASI_ID') as $a){

							$tmp  .= "'".substr($a,-2). "',";

						}

						$komoditi = substr($tmp,0,-1);

						$query .= " A.KOMODITI IN (".$komoditi.")";

						

					}else if($this->newsession->userdata('SESS_BBPOM_ID') == '95'){#Insert Pangan

						$query .= $sipt->main->find_where($query);

						$query .= " A.KOMODITI = '13'";

					}else if($this->newsession->userdata('SESS_BBPOM_ID') == '96'){#Ditwas BB

						$query .= $sipt->main->find_where($query);

						$query .= " A.KOMODITI = '14'";

					}

				}else{

						$query .= $sipt->main->find_where($query);

						$query .= " A.KOMODITI in ('01','10','11','12','13','14','20')"; //sesuai pilihan komoditi pada RHKP
						
					}

			}else{

				$query .= $sipt->main->find_where($query);

				$query .= " B.BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'";

				$balai = $sipt->main->get_uraian("SELECT NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","NAMA_BBPOM");		

			}

			$query .= "GROUP BY B.NAMA_BBPOM ORDER BY 1";
			

			$this->newphpexcel->set_title('Rekap Sampel');

			$this->newphpexcel->getDefaultStyle()->getFont()->setName('Calibri')->setSize(10);

			

			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A1', 'REKAPITULASI STATUS SAMPEL')->setCellValue('A3', 'Periode Sampling')->setCellValue('C3', $awal. ' s.d '. $akhir)

			->setCellValue('A4', 'Balai Besar / Balai POM')->setCellValue('C4', $balai);

			

			$this->newphpexcel->getActiveSheet()->mergeCells('A1:R1');

			$this->newphpexcel->getActiveSheet()->getStyle('A1:R1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$this->newphpexcel->getActiveSheet()->mergeCells('A3:B3');

			$this->newphpexcel->getActiveSheet()->mergeCells('A4:B4');

			$this->newphpexcel->getActiveSheet()->mergeCells('C3:Q3');

			$this->newphpexcel->getActiveSheet()->mergeCells('C4:Q4');

			$this->newphpexcel->getActiveSheet()->mergeCells('A6:A8');

			$this->newphpexcel->getActiveSheet()->getStyle('A6:A8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$this->newphpexcel->getActiveSheet()->mergeCells('B6:B8');

			$this->newphpexcel->getActiveSheet()->getStyle('B6:B8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$this->newphpexcel->getActiveSheet()->mergeCells('C6:F6');

			$this->newphpexcel->getActiveSheet()->getStyle('C6:F6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$this->newphpexcel->getActiveSheet()->mergeCells('G6:I6');

			$this->newphpexcel->getActiveSheet()->getStyle('G6:I6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$this->newphpexcel->getActiveSheet()->mergeCells('K6:P6');

			$this->newphpexcel->getActiveSheet()->getStyle('K6:P6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$this->newphpexcel->getActiveSheet()->mergeCells('C7:D7');

			$this->newphpexcel->getActiveSheet()->getStyle('C7:D7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$this->newphpexcel->getActiveSheet()->mergeCells('J6:J7');

			$this->newphpexcel->getActiveSheet()->getStyle('J6:J7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$this->newphpexcel->getActiveSheet()->mergeCells('G7:H7');

			$this->newphpexcel->getActiveSheet()->getStyle('G7:H7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$this->newphpexcel->getActiveSheet()->mergeCells('K7:L7');

			$this->newphpexcel->getActiveSheet()->getStyle('K7:L7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$this->newphpexcel->getActiveSheet()->mergeCells('M7:O7');

			$this->newphpexcel->getActiveSheet()->getStyle('M7:O7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$this->newphpexcel->getActiveSheet()->mergeCells('Q6:Q8');

			$this->newphpexcel->getActiveSheet()->getStyle('Q6:Q8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$this->newphpexcel->getActiveSheet()->mergeCells('R6:R8');

			$this->newphpexcel->getActiveSheet()->getStyle('R6:R8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			

			

			$this->newphpexcel->getActiveSheet()->getColumnDimension('A')->setWidth(4);

			$this->newphpexcel->getActiveSheet()->getColumnDimension('B')->setWidth(25); 

			$this->newphpexcel->getActiveSheet()->getColumnDimension('C')->setWidth(8); 

			$this->newphpexcel->getActiveSheet()->getColumnDimension('D')->setWidth(8); 

			$this->newphpexcel->getActiveSheet()->getColumnDimension('E')->setWidth(8); 

			$this->newphpexcel->getActiveSheet()->getColumnDimension('F')->setWidth(9); 

			$this->newphpexcel->getActiveSheet()->getColumnDimension('G')->setWidth(11); 

			$this->newphpexcel->getActiveSheet()->getColumnDimension('H')->setWidth(10); 

			$this->newphpexcel->getActiveSheet()->getColumnDimension('I')->setWidth(8); 

			$this->newphpexcel->getActiveSheet()->getColumnDimension('J')->setWidth(9); 

			$this->newphpexcel->getActiveSheet()->getColumnDimension('K')->setWidth(10); 

			$this->newphpexcel->getActiveSheet()->getColumnDimension('L')->setWidth(9); 

			$this->newphpexcel->getActiveSheet()->getColumnDimension('M')->setWidth(10); 

			$this->newphpexcel->getActiveSheet()->getColumnDimension('N')->setWidth(9); 

			$this->newphpexcel->getActiveSheet()->getColumnDimension('O')->setWidth(9); 

			$this->newphpexcel->getActiveSheet()->getColumnDimension('P')->setWidth(9); 

			$this->newphpexcel->getActiveSheet()->getColumnDimension('Q')->setWidth(9); 

			$this->newphpexcel->getActiveSheet()->getColumnDimension('R')->setWidth(9); 

			

			

			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A6','No.')

								->setCellValue('B6','BBPOM / BPOM')

								->setCellValue('C6','Bidang Pemdik')

								->setCellValue('G6','Tata Usaha')

								->setCellValue('J6','Ka. Balai')

								->setCellValue('K6','Bidang Pengujian')

								->setCellValue('Q6','Hasil Pengujian Balai')

								->setCellValue('R6','Total')

								->setCellValue('C7','Operator')

								->setCellValue('E7','Ka. Seksi')

								->setCellValue('F7','Ka. Bidang')

								->setCellValue('G7','TPS')

								->setCellValue('I7','MA')

								->setCellValue('K7','Manager Teknis')

								->setCellValue('M7','Penyelia')

								->setCellValue('P7','Penguji')

								->setCellValue('C8','Draft')

								->setCellValue('D8','Ditolak')

								->setCellValue('E8','Verifikasi Sampel')

								->setCellValue('F8','Verifikasi Sampel')

								->setCellValue('G8','Penerimaan Sampel')

								->setCellValue('H8','Penyerahan Sampel')

								->setCellValue('I8','Verifikasi Sampel')

								->setCellValue('J8','Hasil Pengujian')

								->setCellValue('K8','Pembuatan SPK')

								->setCellValue('L8','Verifikasi LHU')

								->setCellValue('M8','Pembuatan SPP')

								->setCellValue('N8','Draft CP / LCP')

								->setCellValue('O8','Konsep Laporan')

								->setCellValue('P8','Entri Pengujian');

			$arrheader = array('font' => array('bold' => true),

							   'borders' => array('top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),

												  'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),

												  'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)),

								'fill' => array('type' => (PHPExcel_Style_Fill::FILL_SOLID), 

								'color' => array('rgb' => 'C0C0C0')),

								'alignment'	=> 	array('vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP));

			$arrleft = array('alignment' => array('vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP),

							 'borders' => array('top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),

							 'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),

											  'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN),

											  'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));

			$arright = array('alignment' => array('vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP),

							 'borders' => array('top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),

												'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),

												'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN),

												'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));	

												

			$this->newphpexcel->getActiveSheet()->getStyle('A6')->applyFromArray($arrheader);

			$this->newphpexcel->getActiveSheet()->getStyle('B6')->applyFromArray($arrheader);

			$this->newphpexcel->getActiveSheet()->getStyle('C6')->applyFromArray($arrheader);

			$this->newphpexcel->getActiveSheet()->getStyle('D6')->applyFromArray($arrheader);

			$this->newphpexcel->getActiveSheet()->getStyle('E6')->applyFromArray($arrheader);

			$this->newphpexcel->getActiveSheet()->getStyle('F6')->applyFromArray($arrheader);

			$this->newphpexcel->getActiveSheet()->getStyle('G6')->applyFromArray($arrheader);

			$this->newphpexcel->getActiveSheet()->getStyle('H6')->applyFromArray($arrheader);

			$this->newphpexcel->getActiveSheet()->getStyle('I6')->applyFromArray($arrheader);

			$this->newphpexcel->getActiveSheet()->getStyle('J6')->applyFromArray($arrheader);

			$this->newphpexcel->getActiveSheet()->getStyle('K6')->applyFromArray($arrheader);

			$this->newphpexcel->getActiveSheet()->getStyle('L6')->applyFromArray($arrheader);

			$this->newphpexcel->getActiveSheet()->getStyle('M6')->applyFromArray($arrheader);

			$this->newphpexcel->getActiveSheet()->getStyle('N6')->applyFromArray($arrheader);

			$this->newphpexcel->getActiveSheet()->getStyle('O6')->applyFromArray($arrheader);

			$this->newphpexcel->getActiveSheet()->getStyle('P6')->applyFromArray($arrheader);

			$this->newphpexcel->getActiveSheet()->getStyle('Q6')->applyFromArray($arrheader);

			$this->newphpexcel->getActiveSheet()->getStyle('R6')->applyFromArray($arrheader);

			

			$this->newphpexcel->getActiveSheet()->getStyle('A7')->applyFromArray($arrheader);

			$this->newphpexcel->getActiveSheet()->getStyle('B7')->applyFromArray($arrheader);

			$this->newphpexcel->getActiveSheet()->getStyle('C7')->applyFromArray($arrheader);

			$this->newphpexcel->getActiveSheet()->getStyle('D7')->applyFromArray($arrheader);

			$this->newphpexcel->getActiveSheet()->getStyle('E7')->applyFromArray($arrheader);

			$this->newphpexcel->getActiveSheet()->getStyle('F7')->applyFromArray($arrheader);

			$this->newphpexcel->getActiveSheet()->getStyle('G7')->applyFromArray($arrheader);

			$this->newphpexcel->getActiveSheet()->getStyle('H7')->applyFromArray($arrheader);

			$this->newphpexcel->getActiveSheet()->getStyle('I7')->applyFromArray($arrheader);

			$this->newphpexcel->getActiveSheet()->getStyle('J7')->applyFromArray($arrheader);

			$this->newphpexcel->getActiveSheet()->getStyle('K7')->applyFromArray($arrheader);

			$this->newphpexcel->getActiveSheet()->getStyle('L7')->applyFromArray($arrheader);

			$this->newphpexcel->getActiveSheet()->getStyle('M7')->applyFromArray($arrheader);

			$this->newphpexcel->getActiveSheet()->getStyle('N7')->applyFromArray($arrheader);

			$this->newphpexcel->getActiveSheet()->getStyle('O7')->applyFromArray($arrheader);

			$this->newphpexcel->getActiveSheet()->getStyle('P7')->applyFromArray($arrheader);

			$this->newphpexcel->getActiveSheet()->getStyle('Q7')->applyFromArray($arrheader);

			$this->newphpexcel->getActiveSheet()->getStyle('R7')->applyFromArray($arrheader);

			

			$this->newphpexcel->getActiveSheet()->getStyle('A8')->applyFromArray($arrheader);

			$this->newphpexcel->getActiveSheet()->getStyle('B8')->applyFromArray($arrheader);

			$this->newphpexcel->getActiveSheet()->getStyle('C8')->applyFromArray($arrheader);

			$this->newphpexcel->getActiveSheet()->getStyle('D8')->applyFromArray($arrheader);

			$this->newphpexcel->getActiveSheet()->getStyle('E8')->applyFromArray($arrheader);

			$this->newphpexcel->getActiveSheet()->getStyle('F8')->applyFromArray($arrheader);

			$this->newphpexcel->getActiveSheet()->getStyle('G8')->applyFromArray($arrheader);

			$this->newphpexcel->getActiveSheet()->getStyle('H8')->applyFromArray($arrheader);

			$this->newphpexcel->getActiveSheet()->getStyle('I8')->applyFromArray($arrheader);

			$this->newphpexcel->getActiveSheet()->getStyle('J8')->applyFromArray($arrheader);

			$this->newphpexcel->getActiveSheet()->getStyle('K8')->applyFromArray($arrheader);

			$this->newphpexcel->getActiveSheet()->getStyle('L8')->applyFromArray($arrheader);

			$this->newphpexcel->getActiveSheet()->getStyle('M8')->applyFromArray($arrheader);

			$this->newphpexcel->getActiveSheet()->getStyle('N8')->applyFromArray($arrheader);

			$this->newphpexcel->getActiveSheet()->getStyle('O8')->applyFromArray($arrheader);

			$this->newphpexcel->getActiveSheet()->getStyle('P8')->applyFromArray($arrheader);

			$this->newphpexcel->getActiveSheet()->getStyle('Q8')->applyFromArray($arrheader);

			$this->newphpexcel->getActiveSheet()->getStyle('R8')->applyFromArray($arrheader);

			

			$this->newphpexcel->getActiveSheet()->getStyle('E8')->getAlignment()->setWrapText(true);

			$this->newphpexcel->getActiveSheet()->getStyle('F8')->getAlignment()->setWrapText(true);

			$this->newphpexcel->getActiveSheet()->getStyle('G8')->getAlignment()->setWrapText(true);

			$this->newphpexcel->getActiveSheet()->getStyle('H8')->getAlignment()->setWrapText(true);

			$this->newphpexcel->getActiveSheet()->getStyle('I8')->getAlignment()->setWrapText(true);

			$this->newphpexcel->getActiveSheet()->getStyle('J8')->getAlignment()->setWrapText(true);

			$this->newphpexcel->getActiveSheet()->getStyle('K8')->getAlignment()->setWrapText(true);

			$this->newphpexcel->getActiveSheet()->getStyle('L8')->getAlignment()->setWrapText(true);

			$this->newphpexcel->getActiveSheet()->getStyle('M8')->getAlignment()->setWrapText(true);

			$this->newphpexcel->getActiveSheet()->getStyle('N8')->getAlignment()->setWrapText(true);

			$this->newphpexcel->getActiveSheet()->getStyle('O8')->getAlignment()->setWrapText(true);

			$this->newphpexcel->getActiveSheet()->getStyle('P8')->getAlignment()->setWrapText(true);

			$this->newphpexcel->getActiveSheet()->getStyle('Q6')->getAlignment()->setWrapText(true);

			

			$data = $sipt->main->get_result($query);

			$rec = 9;

			if($data){

				$no=1;

				foreach($query->result_array() as $row){

					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A'.$rec,$no)

									  ->setCellValue('B'.$rec,$row["NAMA_BBPOM"])

									  ->setCellValue('C'.$rec,$row["DRAFTSAMPEL"])

									  ->setCellValue('D'.$rec,$row["REJECTSAMPEL"])

									  ->setCellValue('E'.$rec,$row["SPUSPV1VER"])

									  ->setCellValue('F'.$rec,$row["SPUSPV2VER"])

									  ->setCellValue('G'.$rec,$row["TPS"])

									  ->setCellValue('H'.$rec,$row["TPSCETAKSPU"])

									  ->setCellValue('I'.$rec,$row["MA"])

									  ->setCellValue('J'.$rec,$row["HASIL_PENGUJIAN"])

									  ->setCellValue('K'.$rec,$row["PERINTAH_UJI"])

									  ->setCellValue('L'.$rec,$row["VERIFIKASI_LHU"])

									  ->setCellValue('M'.$rec,$row["SPK_BARU"])

									  ->setCellValue('N'.$rec,$row["DRAFT_CP"])

									  ->setCellValue('O'.$rec,$row["KONSEP_LAPORAN"])

									  ->setCellValue('P'.$rec,$row["SPP_BARU"])

									  ->setCellValue('Q'.$rec,$row["TERKIRIM_KEPUSAT"])

									  ->setCellValue('R'.$rec,'=SUM(C'.$rec.':Q'.$rec.')');

									  

					$this->newphpexcel->getActiveSheet()->getStyle('A'.$rec)->applyFromArray($arrleft);

					$this->newphpexcel->getActiveSheet()->getStyle('B'.$rec)->applyFromArray($arrleft);

					$this->newphpexcel->getActiveSheet()->getStyle('C'.$rec)->applyFromArray($arrleft);

					$this->newphpexcel->getActiveSheet()->getStyle('D'.$rec)->applyFromArray($arrleft);

					$this->newphpexcel->getActiveSheet()->getStyle('E'.$rec)->applyFromArray($arrleft);

					$this->newphpexcel->getActiveSheet()->getStyle('F'.$rec)->applyFromArray($arrleft);

					$this->newphpexcel->getActiveSheet()->getStyle('G'.$rec)->applyFromArray($arrleft);

					$this->newphpexcel->getActiveSheet()->getStyle('H'.$rec)->applyFromArray($arrleft);

					$this->newphpexcel->getActiveSheet()->getStyle('I'.$rec)->applyFromArray($arrleft);

					$this->newphpexcel->getActiveSheet()->getStyle('J'.$rec)->applyFromArray($arrleft);

					$this->newphpexcel->getActiveSheet()->getStyle('K'.$rec)->applyFromArray($arrleft);

					$this->newphpexcel->getActiveSheet()->getStyle('L'.$rec)->applyFromArray($arrleft);

					$this->newphpexcel->getActiveSheet()->getStyle('M'.$rec)->applyFromArray($arrleft);

					$this->newphpexcel->getActiveSheet()->getStyle('N'.$rec)->applyFromArray($arrleft);

					$this->newphpexcel->getActiveSheet()->getStyle('N'.$rec)->applyFromArray($arrleft);

					$this->newphpexcel->getActiveSheet()->getStyle('O'.$rec)->applyFromArray($arrleft);

					$this->newphpexcel->getActiveSheet()->getStyle('P'.$rec)->applyFromArray($arrleft);

					$this->newphpexcel->getActiveSheet()->getStyle('Q'.$rec)->applyFromArray($arrleft);

					$this->newphpexcel->getActiveSheet()->getStyle('R'.$rec)->applyFromArray($arrleft);

					$rec++;

					$no++;

				}

			}else{

				$this->newphpexcel->getActiveSheet()->getStyle('A9:R9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$this->newphpexcel->getActiveSheet()->getStyle('A'.$rec)->applyFromArray($arrleft);

				$this->newphpexcel->getActiveSheet()->getStyle('B'.$rec)->applyFromArray($arrleft);

				$this->newphpexcel->getActiveSheet()->getStyle('C'.$rec)->applyFromArray($arrleft);

				$this->newphpexcel->getActiveSheet()->getStyle('D'.$rec)->applyFromArray($arrleft);

				$this->newphpexcel->getActiveSheet()->getStyle('E'.$rec)->applyFromArray($arrleft);

				$this->newphpexcel->getActiveSheet()->getStyle('F'.$rec)->applyFromArray($arrleft);

				$this->newphpexcel->getActiveSheet()->getStyle('G'.$rec)->applyFromArray($arrleft);

				$this->newphpexcel->getActiveSheet()->getStyle('H'.$rec)->applyFromArray($arrleft);

				$this->newphpexcel->getActiveSheet()->getStyle('I'.$rec)->applyFromArray($arrleft);

				$this->newphpexcel->getActiveSheet()->getStyle('J'.$rec)->applyFromArray($arrleft);

				$this->newphpexcel->getActiveSheet()->getStyle('K'.$rec)->applyFromArray($arrleft);

				$this->newphpexcel->getActiveSheet()->getStyle('L'.$rec)->applyFromArray($arrleft);

				$this->newphpexcel->getActiveSheet()->getStyle('M'.$rec)->applyFromArray($arrleft);

				$this->newphpexcel->getActiveSheet()->getStyle('N'.$rec)->applyFromArray($arrleft);

				$this->newphpexcel->getActiveSheet()->getStyle('N'.$rec)->applyFromArray($arrleft);

				$this->newphpexcel->getActiveSheet()->getStyle('O'.$rec)->applyFromArray($arrleft);

				$this->newphpexcel->getActiveSheet()->getStyle('P'.$rec)->applyFromArray($arrleft);

				$this->newphpexcel->getActiveSheet()->getStyle('Q'.$rec)->applyFromArray($arrleft);

				$this->newphpexcel->getActiveSheet()->getStyle('R'.$rec)->applyFromArray($arrleft);

				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A10','Data Tidak Ditemukan');

			}

			

			

			

			ob_clean();

			$file = "REKAP_STATUS_SAMPEL.xls";

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