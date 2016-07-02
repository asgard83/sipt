<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);
class Hasil_act extends Model{
	
	function get_hasil(){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$this->load->library('newphpexcel');
			
			$query = "SELECT dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) AS UR_KODE_SAMPEL, UPPER(A.NAMA_SAMPEL) AS NAMA_SAMPEL,
			dbo.KATEGORI(A.KATEGORI) AS KATEGORI, PABRIK, IMPORTIR, A.KOMPOSISI, A.NOMOR_REGISTRASI, A.NO_BETS,
			A.KEMASAN, A.KETERANGAN_ED, A.TEMPAT_SAMPLING, CONVERT(VARCHAR(10), A.TANGGAL_SAMPLING,103) AS TANGGAL_SAMPLING,
			dbo.URAIAN_M_TABEL('TUJUAN_SAMPLING',A.TUJUAN_SAMPLING) AS TUJUAN_SAMPLING,
			dbo.URAIAN_M_TABEL('SUB_TUJUAN', A.SUB_TUJUAN) AS SUB_TUJUAN,
			CASE WHEN B.JENIS_UJI = '01' THEN B.PARAMETER_UJI ELSE '' END AS [PARAMMIKRO],
			CASE WHEN B.JENIS_UJI = '01' THEN B.METODE ELSE '' END AS [METODEMIKRO],
			CASE WHEN B.JENIS_UJI = '01' THEN B.PUSTAKA ELSE '' END AS [PUSTAKAMIKRO],
			CASE WHEN B.JENIS_UJI = '01' THEN B.SYARAT ELSE '' END AS [SYARATMIKRO],
			CASE WHEN B.JENIS_UJI = '01' THEN B.HASIL ELSE '' END AS [HASILMIKRO],
			CASE WHEN B.JENIS_UJI = '01' THEN B.HASIL_KUALITATIF ELSE '' END AS [KUALITATIFMIKRO],
			CASE WHEN B.JENIS_UJI = '01' THEN B.HASIL_PARAMETER ELSE '' END AS [PARAMETERMIKRO],
			CASE WHEN B.JENIS_UJI = '02' THEN B.PARAMETER_UJI ELSE '' END AS [PARAMKIMIA],
			CASE WHEN B.JENIS_UJI = '02' THEN B.METODE ELSE '' END AS [METODEKIMIA],
			CASE WHEN B.JENIS_UJI = '02' THEN B.PUSTAKA ELSE '' END AS [PUSTAKAKIMIA],
			CASE WHEN B.JENIS_UJI = '02' THEN B.SYARAT ELSE '' END AS [SYARATKIMIA],
			CASE WHEN B.JENIS_UJI = '02' THEN B.HASIL ELSE '' END AS [HASILKIMIA],
			CASE WHEN B.JENIS_UJI = '02' THEN B.HASIL_KUALITATIF ELSE '' END AS [KUALITATIFKIMIA],
			CASE WHEN B.JENIS_UJI = '02' THEN B.HASIL_PARAMETER ELSE '' END AS [PARAMETERKIMIA],
			A.HASIL_SAMPEL,
			REPLACE(REPLACE(C.NAMA_BBPOM, 'BALAI POM DI ', ''), 'BALAI BESAR POM DI ','') AS BBPOM
			FROM T_M_SAMPEL_RILIS A LEFT JOIN T_PARAMETER_HASIL_UJI B ON A.KODE_SAMPEL = B.KODE_SAMPEL
			LEFT JOIN M_BBPOM C ON A.BBPOM_ID = C.BBPOM_ID
			WHERE B.STATUS = '50202' AND MONTH(A.TANGGAL_SAMPLING) = '".$this->input->post('BULAN')."' AND YEAR(A.TANGGAL_SAMPLING) = '".$this->input->post('TAHUN')."'";
			
			if(trim($this->input->post('KOMODITI')!="")){
				$query .= $sipt->main->find_where($query);
				$query .= " A.KOMODITI = '".$this->input->post('KOMODITI')."' ";
				$komoditi = $sipt->main->get_uraian("SELECT dbo.GOLONGAN_SAMPEL('".$this->input->post('KOMODITI')."') AS KOMODITI","KOMODITI");
			}else{
				$komoditi = 'SELURUH KOMODITI';
			}
			
			if(trim($this->input->post('HASIL_SAMPEL')!="")){
				$query .= $sipt->main->find_where($query);
				$query .= " A.HASIL_SAMPEL = '".$this->input->post('HASIL_SAMPEL')."' ";
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
			
			$arrbulan = array('1' => 'Januari',
							 '2' => 'Februari',
							 '3' => 'Maret',
							 '4' => 'April',
							 '5' => 'Mei',
							 '6' => 'Juni',
							 '7' => 'Juli',
							 '8' => 'Agustus',
							 '9' => 'September',
							 '10' => 'Oktober',
							 '11' => 'November',
							 '12' => 'Desember');
			$bulan = $arrbulan[$this->input->post('BULAN')];
			
			$this->newphpexcel->set_title('Hasil Pengujian Sampel');
			$this->newphpexcel->getDefaultStyle()->getFont()->setName('Calibri')->setSize(10);
			
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A2', 'LAPORAN BULANAN PENGUJIAN '.$komoditi)->setCellValue('A4', 'BADAN PENGAWAS OBAT DAN MAKANAN REPUBLIK INDONESIA')->setCellValue('A5', $balai)->setCellValue('A6', 'Bulan : '.$bulan)->setCellValue('A7', 'Tahun : '.$this->input->post('TAHUN'));
			
			$this->newphpexcel->getActiveSheet()->mergeCells('A2:V2');
			$this->newphpexcel->getActiveSheet()->getStyle('A2:V2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->newphpexcel->getActiveSheet()->mergeCells('A4:V4');
			$this->newphpexcel->getActiveSheet()->getStyle('A4:V4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->newphpexcel->getActiveSheet()->mergeCells('A5:V5');
			$this->newphpexcel->getActiveSheet()->getStyle('A5:V5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->newphpexcel->getActiveSheet()->mergeCells('A6:V6');
			$this->newphpexcel->getActiveSheet()->getStyle('A6:V6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->newphpexcel->getActiveSheet()->mergeCells('A7:V7');
			$this->newphpexcel->getActiveSheet()->getStyle('A7:V7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			
			$this->newphpexcel->getActiveSheet()->mergeCells('A8:A9');
			$this->newphpexcel->getActiveSheet()->getStyle('A8:A9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->newphpexcel->getActiveSheet()->mergeCells('B8:B9');
			$this->newphpexcel->getActiveSheet()->getStyle('B8:B9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->newphpexcel->getActiveSheet()->mergeCells('C8:C9');
			$this->newphpexcel->getActiveSheet()->getStyle('C8:C9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->newphpexcel->getActiveSheet()->mergeCells('D8:D9');
			$this->newphpexcel->getActiveSheet()->getStyle('D8:D9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->newphpexcel->getActiveSheet()->mergeCells('E8:E9');
			$this->newphpexcel->getActiveSheet()->getStyle('E8:E9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->newphpexcel->getActiveSheet()->mergeCells('F8:F9');
			$this->newphpexcel->getActiveSheet()->getStyle('F8:F9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->newphpexcel->getActiveSheet()->mergeCells('G8:G9');
			$this->newphpexcel->getActiveSheet()->getStyle('G8:G9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
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
			$this->newphpexcel->getActiveSheet()->mergeCells('M8:P8');
			$this->newphpexcel->getActiveSheet()->getStyle('M8:P8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->newphpexcel->getActiveSheet()->mergeCells('Q8:T8');
			$this->newphpexcel->getActiveSheet()->getStyle('Q8:T8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->newphpexcel->getActiveSheet()->mergeCells('U8:U9');
			$this->newphpexcel->getActiveSheet()->getStyle('U8:U9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->newphpexcel->getActiveSheet()->mergeCells('V8:V9');
			$this->newphpexcel->getActiveSheet()->getStyle('V8:V9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			
			$this->newphpexcel->getActiveSheet()->getColumnDimension('A')->setWidth(7);
			$this->newphpexcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
			$this->newphpexcel->getActiveSheet()->getColumnDimension('C')->setWidth(50);
			$this->newphpexcel->getActiveSheet()->getColumnDimension('D')->setWidth(17);
			$this->newphpexcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
			$this->newphpexcel->getActiveSheet()->getColumnDimension('F')->setWidth(17);
			$this->newphpexcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
			$this->newphpexcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
			$this->newphpexcel->getActiveSheet()->getColumnDimension('I')->setWidth(30);
			$this->newphpexcel->getActiveSheet()->getColumnDimension('J')->setWidth(40);
			$this->newphpexcel->getActiveSheet()->getColumnDimension('K')->setWidth(40);
			$this->newphpexcel->getActiveSheet()->getColumnDimension('L')->setWidth(40);
			$this->newphpexcel->getActiveSheet()->getColumnDimension('M')->setWidth(40);
			$this->newphpexcel->getActiveSheet()->getColumnDimension('N')->setWidth(30);
			$this->newphpexcel->getActiveSheet()->getColumnDimension('O')->setWidth(30);
			$this->newphpexcel->getActiveSheet()->getColumnDimension('P')->setWidth(30);
			$this->newphpexcel->getActiveSheet()->getColumnDimension('Q')->setWidth(40);
			$this->newphpexcel->getActiveSheet()->getColumnDimension('R')->setWidth(30);
			$this->newphpexcel->getActiveSheet()->getColumnDimension('S')->setWidth(30);
			$this->newphpexcel->getActiveSheet()->getColumnDimension('T')->setWidth(30);
			$this->newphpexcel->getActiveSheet()->getColumnDimension('U')->setWidth(15);
			$this->newphpexcel->getActiveSheet()->getColumnDimension('V')->setWidth(40);
			
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
			$this->newphpexcel->getActiveSheet()->getStyle('N8')->applyFromArray($arrheader);
			$this->newphpexcel->getActiveSheet()->getStyle('O8')->applyFromArray($arrheader);
			$this->newphpexcel->getActiveSheet()->getStyle('P8')->applyFromArray($arrheader);
			$this->newphpexcel->getActiveSheet()->getStyle('Q8')->applyFromArray($arrheader);
			$this->newphpexcel->getActiveSheet()->getStyle('R8')->applyFromArray($arrheader);
			$this->newphpexcel->getActiveSheet()->getStyle('S8')->applyFromArray($arrheader);
			$this->newphpexcel->getActiveSheet()->getStyle('T8')->applyFromArray($arrheader);
			$this->newphpexcel->getActiveSheet()->getStyle('U8')->applyFromArray($arrheader);
			$this->newphpexcel->getActiveSheet()->getStyle('V8')->applyFromArray($arrheader);
			
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
			$this->newphpexcel->getActiveSheet()->getStyle('N9')->applyFromArray($arrheader);
			$this->newphpexcel->getActiveSheet()->getStyle('O9')->applyFromArray($arrheader);
			$this->newphpexcel->getActiveSheet()->getStyle('P9')->applyFromArray($arrheader);
			$this->newphpexcel->getActiveSheet()->getStyle('Q9')->applyFromArray($arrheader);
			$this->newphpexcel->getActiveSheet()->getStyle('R9')->applyFromArray($arrheader);
			$this->newphpexcel->getActiveSheet()->getStyle('S9')->applyFromArray($arrheader);
			$this->newphpexcel->getActiveSheet()->getStyle('T9')->applyFromArray($arrheader);
			$this->newphpexcel->getActiveSheet()->getStyle('U9')->applyFromArray($arrheader);
			$this->newphpexcel->getActiveSheet()->getStyle('V9')->applyFromArray($arrheader);
			
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A8','No.')->setCellValue('B8','Kode Sampel')->setCellValue('C8','Nama Sampel')->setCellValue('D8','Jenis Sampling')->setCellValue('E8','Jenis')->setCellValue('F8','Nomor Izin Edar')->setCellValue('G8','No Bets')->setCellValue('H8','Kemasan')->setCellValue('I8','Kedaluarsa')->setCellValue('J8','Nama dan Alamat Perusahaan')->setCellValue('K8','Komposisi')->setCellValue('L8','Tempat & Tanggal Sampling')->setCellValue('M8','Hasil Pengujian Kimia')->setCellValue('Q8','Hasil Pengujian Mikrobiologi')->setCellValue('U8','Kesimpulan')->setCellValue('M9','Parameter Uji')->setCellValue('N9','Kuantitatif / Kualitatif')->setCellValue('O9','Metode Pemeriksaan / Pustaka')->setCellValue('P9','Syarat')->setCellValue('Q9','Parameter Uji')->setCellValue('R9','Kuantitatif / Kualitatif')->setCellValue('S9','Metode Pemeriksaan / Pustaka')->setCellValue('T9','Syarat')->setCellValue('V8','BBPOM / BPOM');
			
			$data = $sipt->main->get_result($query);
			if($data){
				$no=1;
				$rec = 10;
				$kode = "";
				foreach($query->result_array() as $row){
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A'.$rec,($kode != $row["UR_KODE_SAMPEL"] ? $no++ : ''))
						->setCellValue('B'.$rec,($kode != $row["UR_KODE_SAMPEL"] ? $row["UR_KODE_SAMPEL"] : ''))
						->setCellValue('C'.$rec,($kode != $row["UR_KODE_SAMPEL"] ? $row["NAMA_SAMPEL"] : ''))
						->setCellValue('D'.$rec,($kode != $row["UR_KODE_SAMPEL"] ? $row['TUJUAN_SAMPLING'] : ''))
						->setCellValue('E'.$rec,($kode != $row["UR_KODE_SAMPEL"] ? $row["SUB_TUJUAN"] : ''))
						->setCellValue('F'.$rec,($kode != $row["UR_KODE_SAMPEL"] ? $row["NOMOR_REGISTRASI"] : ''))
						->setCellValue('G'.$rec,($kode != $row["UR_KODE_SAMPEL"] ? $row["NO_BETS"] : ''))
						->setCellValue('H'.$rec,($kode != $row["UR_KODE_SAMPEL"] ? $row["KEMASAN"] : ''))
						->setCellValue('I'.$rec,($kode != $row["UR_KODE_SAMPEL"] ? $row["KETERANGAN_ED"] : ''))
						->setCellValue('J'.$rec,($kode != $row["UR_KODE_SAMPEL"] ? $row["PABRIK"].chr(10).$row["IMPORTIR"] : ''))
						->setCellValue('K'.$rec,($kode != $row["UR_KODE_SAMPEL"] ? $row["KOMPOSISI"] : ''))
						->setCellValue('L'.$rec,($kode != $row["UR_KODE_SAMPEL"] ? $row["TEMPAT_SAMPLING"].chr(10).$row["TANGGAL_SAMPLING"] : ''))
						->setCellValue('M'.$rec,$row["PARAMKIMIA"])
						->setCellValue('N'.$rec,$row["HASILKIMIA"].chr(10).$row["KUALITATIFKIMIA"])
						->setCellValue('O'.$rec,$row["METODEKIMIA"].chr(10).$row["PUSTAKAKIMIA"])
						->setCellValue('P'.$rec,$row["SYARATKIMIA"])
						->setCellValue('Q'.$rec,$row["PARAMMIKRO"])
						->setCellValue('R'.$rec,$row["HASILMIKRO"].chr(10).$row["KUALITATIFMIKRO"])
						->setCellValue('S'.$rec,$row["METODEMIKRO"].chr(10).$row["PUSTAKAMIKRO"])
						->setCellValue('T'.$rec,$row["SYARATMIKRO"])
						->setCellValue('U'.$rec,($kode != $row["UR_KODE_SAMPEL"] ? $row["HASIL_SAMPEL"] : ''))
						->setCellValue('V'.$rec,($kode != $row["UR_KODE_SAMPEL"] ? $row["BBPOM"] : ''));
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
						$this->newphpexcel->getActiveSheet()->getStyle('S'.$rec)->applyFromArray($arrleft);
						$this->newphpexcel->getActiveSheet()->getStyle('T'.$rec)->applyFromArray($arrleft);
						$this->newphpexcel->getActiveSheet()->getStyle('U'.$rec)->applyFromArray($arrleft);
						$this->newphpexcel->getActiveSheet()->getStyle('V'.$rec)->applyFromArray($arrleft);
						$this->newphpexcel->getActiveSheet()->getStyle('H'.$rec)->getAlignment()->setWrapText(true);
						$this->newphpexcel->getActiveSheet()->getStyle('J'.$rec)->getAlignment()->setWrapText(true);
						$this->newphpexcel->getActiveSheet()->getStyle('K'.$rec)->getAlignment()->setWrapText(true);
						$this->newphpexcel->getActiveSheet()->getStyle('L'.$rec)->getAlignment()->setWrapText(true);
						$this->newphpexcel->getActiveSheet()->getStyle('N'.$rec)->getAlignment()->setWrapText(true);
						$this->newphpexcel->getActiveSheet()->getStyle('O'.$rec)->getAlignment()->setWrapText(true);
						$this->newphpexcel->getActiveSheet()->getStyle('P'.$rec)->getAlignment()->setWrapText(true);
						$this->newphpexcel->getActiveSheet()->getStyle('R'.$rec)->getAlignment()->setWrapText(true);
						$this->newphpexcel->getActiveSheet()->getStyle('S'.$rec)->getAlignment()->setWrapText(true);
						$this->newphpexcel->getActiveSheet()->getStyle('T'.$rec)->getAlignment()->setWrapText(true);
					$rec++;
					$kode = $row['UR_KODE_SAMPEL'];
				}
			}else{
				$this->newphpexcel->getActiveSheet()->getStyle('A10:V10')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
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
				$this->newphpexcel->getActiveSheet()->getStyle('T10')->applyFromArray($arrleft);
				$this->newphpexcel->getActiveSheet()->getStyle('U10')->applyFromArray($arrleft);
				$this->newphpexcel->getActiveSheet()->getStyle('V10')->applyFromArray($arrleft);
			}
			
			ob_clean();
			$file = "HASIL_PENGUJIAN_SAMPLING_".$bulan."_".$this->input->post('TAHUN').".xls";
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