<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);
class Rekaptimeline_act extends Model{
	
	function get_hasil(){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$this->load->library('newphpexcel');
			
			$query = "SELECT dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) AS UR_KODE_SAMPEL,
						A.NAMA_SAMPEL, REPLACE(REPLACE(B.NAMA_BBPOM, 'BALAI POM DI ', ''), 'BALAI BESAR POM DI ','') AS NAMA_BBPOM,
						CONVERT(VARCHAR(10), A.TANGGAL_SAMPLING, 103) AS TANGGAL_SAMPLING,
						CONVERT(VARCHAR(10), A.TANGGAL_SPU, 103) AS TANGGAL_SPU,
						CONVERT(VARCHAR(10), A.TANGGAL_KIRIM_PEMDIK, 103) AS TANGGAL_KIRIM_PEMDIK,
						CONVERT(VARCHAR(10), A.TANGGAL_TERIMA_TPS, 103) AS TANGGAL_TERIMA_TPS,
						CONVERT(VARCHAR(10), A.TANGGAL_PERINTAH, 103) AS TANGGAL_PERINTAH,
						CONVERT(VARCHAR(10), A.TANGGAL_SPK, 103) AS TANGGAL_SPK,
						CONVERT(VARCHAR(10), A.TANGGAL_SPP, 103) AS TANGGAL_SPP,
						CONVERT(VARCHAR(10), A.TANGGAL_CP, 103) AS TANGGAL_CP,
						CONVERT(VARCHAR(10), A.TANGGAL_LHU, 103) AS TANGGAL_LHU,
						CONVERT(VARCHAR(10), A.TANGGAL_PEJABAT, 103) AS TANGGAL_PEJABAT,
						(CASE A.BIDANG WHEN 'K' THEN 'Kimia' ELSE 'Mikrobiologi' END) AS BIDANG, 
						CONVERT(VARCHAR(10), A.AWAL_UJI_BIDANG, 103) AS AWAL_UJI_BIDANG,
						CONVERT(VARCHAR(10), A.AKHIR_UJI_BIDANG, 103) AS AKHIR_UJI_BIDANG,
						DATEDIFF(DAY, A.AWAL_UJI_BIDANG,A.AKHIR_UJI_BIDANG) AS SELISIH_AWAL,
						CONVERT(VARCHAR(10), A.AWAL_UJI, 103) AS AWAL_UJI,
						CONVERT(VARCHAR(10), A.AKHIR_UJI, 103) AS AKHIR_UJI,
						DATEDIFF(DAY, A.AWAL_UJI,A.AKHIR_UJI) AS SELISIH_AKHIR
						FROM T_REKAP_TGL_PENGUJIAN A
						LEFT JOIN M_BBPOM B
						ON A.BBPOM_ID = B.BBPOM_ID";
					
			if(trim($this->input->post('KOMODITI')!="")){
				$query .= $sipt->main->find_where($query);
				$query .= " A.KOMODITI = '".$this->input->post('KOMODITI')."' ";
				$komoditi = $sipt->main->get_uraian("SELECT dbo.GOLONGAN_SAMPEL('".$this->input->post('KOMODITI')."') AS KOMODITI","KOMODITI");
			}else{
				$komoditi = 'SELURUH KOMODITI';
			}
			$tanggal_awal = $this->input->post('AWAL');
			$tgl_awal = explode("/",$tanggal_awal);
			$tanggal_akhir = $this->input->post('AKHIR');
			$tgl_akhir = explode("/",$tanggal_akhir);
			if($this->input->post('FILTERTANGGAL')){
				$parameter = $this->input->post('FILTERTANGGAL');
				$query .= $sipt->main->find_where($query);				
				$query .= "(A.".$parameter." >=  CONVERT(datetime,'".$tgl_awal[2].$tgl_awal[1].$tgl_awal[0]."') AND A.".$parameter." <= CONVERT(datetime,'".$tgl_akhir[2].$tgl_akhir[1].$tgl_akhir[0]."'))";
			}
						
			if(in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')) || $this->newsession->userdata('SESS_BBPOM_ID') == "00"){
				if(trim($this->input->post('BBPOM_ID'))==""){
					$query .= "";
					$balai = 'Seluruh Balai';
				}else{
					$query .= $sipt->main->find_where($query);
					$query .= " A.BBPOM_ID = '".$this->input->post('BBPOM_ID')."'";
					$balai = $sipt->main->get_uraian("SELECT REPLACE(REPLACE(NAMA_BBPOM, 'BALAI POM DI ', ''), 'BALAI BESAR POM DI ','') AS NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID = '".$this->input->post('BBPOM_ID')."'","NAMA_BBPOM");		
					$bbpom = $this->input->post('BBPOM_ID');
				}
			}else{
				$query .= $sipt->main->find_where($query);
				$query .= " A.BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'";
				$bbpom = $this->newsession->userdata('SESS_BBPOM_ID');
				$balai = $sipt->main->get_uraian("SELECT REPLACE(REPLACE(NAMA_BBPOM, 'BALAI POM DI ', ''), 'BALAI BESAR POM DI ','') AS NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","NAMA_BBPOM");		
			}
			
			$this->newphpexcel->set_title('Rekapitulasi Timeline Sampling');
			$this->newphpexcel->getDefaultStyle()->getFont()->setName('Calibri')->setSize(10);
			
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A2', 'Rekapitulasi Timeline Sampling Pengujian')->setCellValue('A4', 'Balai Besar/ Balai POM '.$balai)->setCellValue('A5', 'Komoditi '.$komoditi)->setCellValue('A6', 'Berdasarkan '.$parameter)->setCellValue('A7', 'Periode Tanggal'.$tanggal_awal.' - '.$tanggal_akhir);
			
			$this->newphpexcel->getActiveSheet()->mergeCells('A2:W2');
			$this->newphpexcel->getActiveSheet()->getStyle('A2:W2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->newphpexcel->getActiveSheet()->mergeCells('A4:W4');
			$this->newphpexcel->getActiveSheet()->getStyle('A4:W4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->newphpexcel->getActiveSheet()->mergeCells('A5:W5');
			$this->newphpexcel->getActiveSheet()->getStyle('A5:W5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->newphpexcel->getActiveSheet()->mergeCells('A6:W6');
			$this->newphpexcel->getActiveSheet()->getStyle('A6:T6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->newphpexcel->getActiveSheet()->mergeCells('A7:W7');
			$this->newphpexcel->getActiveSheet()->getStyle('A7:W7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			
			$this->newphpexcel->getActiveSheet()->mergeCells('A8:A9');
			$this->newphpexcel->getActiveSheet()->getStyle('A8:A9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->newphpexcel->getActiveSheet()->mergeCells('B8:B9');
			$this->newphpexcel->getActiveSheet()->getStyle('B8:B9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->newphpexcel->getActiveSheet()->mergeCells('C8:C9');
			$this->newphpexcel->getActiveSheet()->getStyle('C8:C9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->newphpexcel->getActiveSheet()->mergeCells('D8:D9');
			$this->newphpexcel->getActiveSheet()->getStyle('D8:D9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->newphpexcel->getActiveSheet()->mergeCells('E8:G8');
			$this->newphpexcel->getActiveSheet()->getStyle('E8:G8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			
			$this->newphpexcel->getActiveSheet()->mergeCells('H8:H9');
			$this->newphpexcel->getActiveSheet()->getStyle('H8:H9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->newphpexcel->getActiveSheet()->mergeCells('I8:I9');
			$this->newphpexcel->getActiveSheet()->getStyle('I8:I9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->newphpexcel->getActiveSheet()->mergeCells('J8:J9');
			$this->newphpexcel->getActiveSheet()->getStyle('J8:J9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->newphpexcel->getActiveSheet()->mergeCells('K8:K9');
			$this->newphpexcel->getActiveSheet()->getStyle('K8:K9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->newphpexcel->getActiveSheet()->mergeCells('L8:L9');
			$this->newphpexcel->getActiveSheet()->getStyle('L8:L9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->newphpexcel->getActiveSheet()->mergeCells('M8:O8');
			$this->newphpexcel->getActiveSheet()->getStyle('M8:O8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->newphpexcel->getActiveSheet()->mergeCells('P8:R8');
			$this->newphpexcel->getActiveSheet()->getStyle('P8:R8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			
			$this->newphpexcel->getActiveSheet()->mergeCells('S8:S9');
			$this->newphpexcel->getActiveSheet()->getStyle('S8:S9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			
			$this->newphpexcel->getActiveSheet()->getColumnDimension('A')->setWidth(7);
			$this->newphpexcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
			$this->newphpexcel->getActiveSheet()->getColumnDimension('C')->setWidth(50);
			$this->newphpexcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
			$this->newphpexcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
			$this->newphpexcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
			$this->newphpexcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
			$this->newphpexcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
			$this->newphpexcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
			$this->newphpexcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
			$this->newphpexcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
			$this->newphpexcel->getActiveSheet()->getColumnDimension('L')->setWidth(20);
			$this->newphpexcel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
			$this->newphpexcel->getActiveSheet()->getColumnDimension('N')->setWidth(15);
			$this->newphpexcel->getActiveSheet()->getColumnDimension('O')->setWidth(15);
			$this->newphpexcel->getActiveSheet()->getColumnDimension('P')->setWidth(15);
			$this->newphpexcel->getActiveSheet()->getColumnDimension('Q')->setWidth(15);
			$this->newphpexcel->getActiveSheet()->getColumnDimension('R')->setWidth(15);
			$this->newphpexcel->getActiveSheet()->getColumnDimension('S')->setWidth(40);
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
			$this->newphpexcel->getActiveSheet()->getStyle('S8')->applyFromArray($arrheader);
			
			$this->newphpexcel->getActiveSheet()->getStyle('A9')->applyFromArray($arrheader);
			$this->newphpexcel->getActiveSheet()->getStyle('B9')->applyFromArray($arrheader);
			$this->newphpexcel->getActiveSheet()->getStyle('C9')->applyFromArray($arrheader);
			$this->newphpexcel->getActiveSheet()->getStyle('D9')->applyFromArray($arrheader);
			$this->newphpexcel->getActiveSheet()->getStyle('E9')->applyFromArray($arrheader);
			$this->newphpexcel->getActiveSheet()->getStyle('F9')->applyFromArray($arrheader);
			$this->newphpexcel->getActiveSheet()->getStyle('G9')->applyFromArray($arrheader);
			$this->newphpexcel->getActiveSheet()->getStyle('H9')->applyFromArray($arrheader);
			$this->newphpexcel->getActiveSheet()->getStyle('I9')->applyFromArray($arrheader);
			$this->newphpexcel->getActiveSheet()->getStyle('J9')->applyFromArray($arrheader);
			$this->newphpexcel->getActiveSheet()->getStyle('K9')->applyFromArray($arrheader);
			$this->newphpexcel->getActiveSheet()->getStyle('L9')->applyFromArray($arrheader);
			$this->newphpexcel->getActiveSheet()->getStyle('M9')->applyFromArray($arrheader);
			$this->newphpexcel->getActiveSheet()->getStyle('N9')->applyFromArray($arrheader);
			$this->newphpexcel->getActiveSheet()->getStyle('O9')->applyFromArray($arrheader);
			$this->newphpexcel->getActiveSheet()->getStyle('P9')->applyFromArray($arrheader);
			$this->newphpexcel->getActiveSheet()->getStyle('Q9')->applyFromArray($arrheader);
			$this->newphpexcel->getActiveSheet()->getStyle('R9')->applyFromArray($arrheader);
			$this->newphpexcel->getActiveSheet()->getStyle('S9')->applyFromArray($arrheader);
			
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A8','No.')->setCellValue('B8','Kode Sampel')->setCellValue('C8','Nama Sampel')->setCellValue('D8','Tanggal Sampling')->setCellValue('E8','Surat Perintah Uji')->setCellValue('E9','Tanggal Verifikasi Pemdik')->setCellValue('F9','Tanggal Terima TPS')->setCellValue('G9','Tanggal Perintah')->setCellValue('H8','Tanggal SPK')->setCellValue('I8','Tanggal CP')->setCellValue('J8','Tanggal LHU')->setCellValue('K8','Tanggal TTD LHU')->setCellValue('L8','Bidang Uji')->setCellValue('M8','Awal Uji')->setCellValue('M9','Bidang')->setCellValue('N9','Akumulasi')->setCellValue('O9','Selisih')->setCellValue('P8','Akhir Uji')->setCellValue('P9','Bidang')->setCellValue('Q9','Akumulasi')->setCellValue('R9','Selisih')->setCellValue('S8','BBPOM/ BPOM');
			
			$data = $sipt->main->get_result($query);
			if($data){
				$no=1;
				$rec = 10;
				$kode = "";
				foreach($query->result_array() as $row){
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A'.$rec,($kode != $row["UR_KODE_SAMPEL"] ? $no++ : ''))
						->setCellValue('B'.$rec,($kode != $row["UR_KODE_SAMPEL"] ? $row["UR_KODE_SAMPEL"] : ''))
						->setCellValue('C'.$rec,($kode != $row["UR_KODE_SAMPEL"] ? $row["NAMA_SAMPEL"] : ''))
						->setCellValue('D'.$rec,($kode != $row["UR_KODE_SAMPEL"] ? $row['TANGGAL_SAMPLING'] : ''))
						->setCellValue('E'.$rec,($kode != $row["UR_KODE_SAMPEL"] ? $row["TANGGAL_KIRIM_PEMDIK"] : ''))
						->setCellValue('F'.$rec,($kode != $row["UR_KODE_SAMPEL"] ? $row["TANGGAL_TERIMA_TPS"] : ''))
						->setCellValue('G'.$rec,($kode != $row["UR_KODE_SAMPEL"] ? $row["TANGGAL_PERINTAH"] : ''))
						->setCellValue('H'.$rec,$row["TANGGAL_SPK"])
						->setCellValue('I'.$rec,$row["TANGGAL_CP"])
						->setCellValue('J'.$rec,$row["TANGGAL_LHU"])
						->setCellValue('K'.$rec,$row["TANGGAL_PEJABAT"])
						->setCellValue('L'.$rec,$row["BIDANG"])
						->setCellValue('M'.$rec,$row["AWAL_UJI_BIDANG"])
						->setCellValue('N'.$rec,$row["AKHIR_UJI_BIDANG"])
						->setCellValue('O'.$rec,$row["SELISIH_AWAL"])
						->setCellValue('P'.$rec,$row["AWAL_UJI"])
						->setCellValue('Q'.$rec,$row["AKHIR_UJI"])
						->setCellValue('R'.$rec,$row["SELISIH_AKHIR"])
						->setCellValue('S'.$rec,$row["NAMA_BBPOM"]);
						
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
						$this->newphpexcel->getActiveSheet()->getStyle('O'.$rec)->applyFromArray($arrleft);
						$this->newphpexcel->getActiveSheet()->getStyle('P'.$rec)->applyFromArray($arrleft);
						$this->newphpexcel->getActiveSheet()->getStyle('Q'.$rec)->applyFromArray($arrleft);
						$this->newphpexcel->getActiveSheet()->getStyle('R'.$rec)->applyFromArray($arrleft);
						$this->newphpexcel->getActiveSheet()->getStyle('S'.$rec)->applyFromArray($arrleft);
						$this->newphpexcel->getActiveSheet()->getStyle('H'.$rec)->getAlignment()->setWrapText(true);
						$this->newphpexcel->getActiveSheet()->getStyle('I'.$rec)->getAlignment()->setWrapText(true);
						$this->newphpexcel->getActiveSheet()->getStyle('J'.$rec)->getAlignment()->setWrapText(true);
						$this->newphpexcel->getActiveSheet()->getStyle('K'.$rec)->getAlignment()->setWrapText(true);
						$this->newphpexcel->getActiveSheet()->getStyle('L'.$rec)->getAlignment()->setWrapText(true);
						$this->newphpexcel->getActiveSheet()->getStyle('N'.$rec)->getAlignment()->setWrapText(true);
						$this->newphpexcel->getActiveSheet()->getStyle('O'.$rec)->getAlignment()->setWrapText(true);
						$this->newphpexcel->getActiveSheet()->getStyle('P'.$rec)->getAlignment()->setWrapText(true);
						$this->newphpexcel->getActiveSheet()->getStyle('R'.$rec)->getAlignment()->setWrapText(true);
						$this->newphpexcel->getActiveSheet()->getStyle('S'.$rec)->getAlignment()->setWrapText(true);
					$rec++;
					$kode = $row['UR_KODE_SAMPEL'];
				}
			}else{
				$this->newphpexcel->getActiveSheet()->getStyle('A10:W10')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$this->newphpexcel->getActiveSheet()->getStyle('A10')->applyFromArray($arrleft);
				$this->newphpexcel->getActiveSheet()->getStyle('B10')->applyFromArray($arrleft);
				$this->newphpexcel->getActiveSheet()->getStyle('C10')->applyFromArray($arrleft);
				$this->newphpexcel->getActiveSheet()->getStyle('D10')->applyFromArray($arrleft);
				$this->newphpexcel->getActiveSheet()->getStyle('E10')->applyFromArray($arrleft);
				$this->newphpexcel->getActiveSheet()->getStyle('F10')->applyFromArray($arrleft);
				$this->newphpexcel->getActiveSheet()->getStyle('G10')->applyFromArray($arrleft);
				$this->newphpexcel->getActiveSheet()->getStyle('H10')->applyFromArray($arrleft);
				$this->newphpexcel->getActiveSheet()->getStyle('I10')->applyFromArray($arrleft);
				$this->newphpexcel->getActiveSheet()->getStyle('J10')->applyFromArray($arrleft);
				$this->newphpexcel->getActiveSheet()->getStyle('K10')->applyFromArray($arrleft);
				$this->newphpexcel->getActiveSheet()->getStyle('L10')->applyFromArray($arrleft);
				$this->newphpexcel->getActiveSheet()->getStyle('M10')->applyFromArray($arrleft);
				$this->newphpexcel->getActiveSheet()->getStyle('N10')->applyFromArray($arrleft);
				$this->newphpexcel->getActiveSheet()->getStyle('N10')->applyFromArray($arrleft);
				$this->newphpexcel->getActiveSheet()->getStyle('O10')->applyFromArray($arrleft);
				$this->newphpexcel->getActiveSheet()->getStyle('P10')->applyFromArray($arrleft);
				$this->newphpexcel->getActiveSheet()->getStyle('Q10')->applyFromArray($arrleft);
				$this->newphpexcel->getActiveSheet()->getStyle('R10')->applyFromArray($arrleft);
				$this->newphpexcel->getActiveSheet()->getStyle('S10')->applyFromArray($arrleft);
			}
			
			ob_clean();
			$file = "Rekapitulasi Timeline Sampling Pengujian.xls";
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