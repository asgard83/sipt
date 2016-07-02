<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

error_reporting(E_ERROR);

class Hasil_act extends Model{

	

	function get_hasil(){

		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){

			$sipt =& get_instance();

			$this->load->model("main", "main", true);

			$this->load->library('newphpexcel');

			

			$query = "SELECT A.KODE_SAMPEL, dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) AS UR_KODE_SAMPEL, UPPER(A.NAMA_SAMPEL) AS NAMA_SAMPEL,

			dbo.KATEGORI(A.KATEGORI,A.PRIORITAS) AS KATEGORIX, A.NAMA_KATEGORI AS KATEGORI, PABRIK, IMPORTIR, CASE WHEN A.PRIORITAS = '0' THEN 'Prioritas Sampling 2014' ELSE 'Prioritas Sampling 2015' END AS [PRIORITAS], A.KOMPOSISI, A.NOMOR_REGISTRASI, A.NO_BETS,

			A.KEMASAN, A.KETERANGAN_ED, REPLACE(A.TEMPAT_SAMPLING,'-','') AS TEMPAT_SAMPLING, CONVERT(VARCHAR(10), A.TANGGAL_SAMPLING,103) AS TANGGAL_SAMPLING,

			dbo.URAIAN_M_TABEL('TUJUAN_SAMPLING',A.TUJUAN_SAMPLING) AS TUJUAN_SAMPLING,

			dbo.URAIAN_M_TABEL('SUB_TUJUAN', A.SUB_TUJUAN) AS SUB_TUJUAN, REPLACE(B.PARAMETER_UJI,'-','') AS PARAMETER_UJI, REPLACE(B.METODE,'-','') AS METODE, B.PUSTAKA, REPLACE(B.SYARAT,'-','') AS SYARAT, REPLACE(B.HASIL,'-','') AS HASIL, REPLACE(B.HASIL_KUALITATIF,'-',' - ') AS HASIL_KUALITATIF, B.HASIL_PARAMETER, 

			CASE WHEN B.JENIS_UJI = '01' THEN 'Mikrobiologi' ELSE 'Kimia-Fisika' END AS [JENIS_UJI],

			A.HASIL_SAMPEL,

			REPLACE(REPLACE(C.NAMA_BBPOM, 'BALAI POM DI ', ''), 'BALAI BESAR POM DI ','') AS BBPOM,

			CONVERT(VARCHAR(10), B.AWAL_UJI, 103) AS AWAL_UJI, CONVERT(VARCHAR(10), A.AKHIR_UJI, 103) AS AKHIR_UJI, D.NAMA_USER,

			CONVERT(VARCHAR(10), A.CREATE_DATE, 103) AS CREATE_DATE, CONVERT(VARCHAR(10), A.CREATE_DATE, 120) AS SORTTGL 

			FROM T_M_SAMPEL_RILIS A LEFT JOIN T_PARAMETER_HASIL_UJI_RILIS B ON A.KODE_SAMPEL = B.KODE_SAMPEL

			LEFT JOIN M_BBPOM C ON A.BBPOM_ID = C.BBPOM_ID

			LEFT JOIN T_USER D ON B.PENGUJI = D.USER_ID ";
#FROM T_M_SAMPEL_RILIS A LEFT JOIN T_PARAMETER_HASIL_UJI B ON A.KODE_SAMPEL = B.KODE_SAMPEL
			if(trim($this->input->post('BULAN_SAMPLING')) != ""){

				$query .= $sipt->main->find_where($query);

				$query .= "SUBSTRING(CONVERT(VARCHAR, A.TANGGAL_SAMPLING, 112),5,2) = '".$this->input->post('BULAN_SAMPLING')."' AND

LEFT(CONVERT(VARCHAR, A.TANGGAL_SAMPLING, 112), 4) = '".$this->input->post('TAHUN_SAMPLING')."'";

			}

			

			if(trim($this->input->post('AKHIR_UJI')) != ""){

				$query .= $sipt->main->find_where($query);

				$query .= "SUBSTRING(CONVERT(VARCHAR, A.AKHIR_UJI, 112),5,2) = '".$this->input->post('AKHIR_UJI')."' AND

LEFT(CONVERT(VARCHAR, A.AKHIR_UJI, 112), 4) = '".$this->input->post('TAHUN_UJI')."'";

			}

			

			if(trim($this->input->post('KOMODITI')!="")){

				$query .= $sipt->main->find_where($query);

				$query .= " A.KOMODITI = '".$this->input->post('KOMODITI')."' ";

				$komoditi = $sipt->main->get_uraian("SELECT dbo.GOLONGAN_SAMPEL('".$this->input->post('KOMODITI')."') AS KOMODITI","KOMODITI");

			}else{

				$komoditi = 'SELURUH KOMODITI';

			}

			

			if($this->input->post('REKAP_KOMODITI')){

				$query .= $sipt->main->find_where($query);

				$query .= " SUBSTRING(A.KATEGORI,1,4) = '".$this->input->post('REKAP_KOMODITI')."' ";

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

			$query .= " ORDER BY 31,1 ASC";

			/*$query .= " AND B.STATUS IN ('50202','40204') ORDER BY A.BBPOM_ID, A.KODE_SAMPEL,";

			if(trim($this->input->post('BULAN_SAMPLING')) != ""){

				$query .= " A.TANGGAL_SAMPLING ASC";

			}

			if(trim($this->input->post('AKHIR_UJI')) != ""){

				$query .= " A.AKHIR_UJI ASC";

			}*/

			//$query = " ORDER BY 

			

			

			$arrbulan = array('01' => 'Januari',

							  '02' => 'Februari',

							  '03' => 'Maret',

							  '04' => 'April',

							  '05' => 'Mei',

							  '06' => 'Juni',

							  '07' => 'Juli',

							  '08' => 'Agustus',

							  '09' => 'September',

							  '10' => 'Oktober',

							  '11' => 'November',

							  '12' => 'Desember');

			if(trim($this->input->post('BULAN_SAMPLING')) != ""){

				$bulan = $arrbulan[$this->input->post('BULAN_SAMPLING')];

				$periode = 'Periode Bulan Sampling : '. $arrbulan[$this->input->post('BULAN_SAMPLING')];

				$tahun = $this->input->post('TAHUN_SAMPLING');

			}else{

				$bulan = $arrbulan[$this->input->post('AKHIR_UJI')];

				$periode = 'Periode Bulan Hasil Uji : '. $arrbulan[$this->input->post('AKHIR_UJI')];

				$tahun = $this->input->post('TAHUN_UJI');

			}

			

			$this->newphpexcel->set_title('Hasil Pengujian Sampel');

			$this->newphpexcel->getDefaultStyle()->getFont()->setName('Calibri')->setSize(10);

			

			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A2', 'LAPORAN BULANAN PENGUJIAN '.$komoditi)->setCellValue('A4', 'BADAN PENGAWAS OBAT DAN MAKANAN REPUBLIK INDONESIA')->setCellValue('A5', $balai)->setCellValue('A6', $periode)->setCellValue('A7', 'Tahun : '.$tahun);

			

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

			$this->newphpexcel->getActiveSheet()->mergeCells('M8:R8');

			$this->newphpexcel->getActiveSheet()->getStyle('M8:R8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$this->newphpexcel->getActiveSheet()->mergeCells('S8:T8');

			$this->newphpexcel->getActiveSheet()->getStyle('S8:T8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$this->newphpexcel->getActiveSheet()->mergeCells('U8:U9');

			$this->newphpexcel->getActiveSheet()->getStyle('U8:U9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$this->newphpexcel->getActiveSheet()->mergeCells('V8:V9');

			$this->newphpexcel->getActiveSheet()->getStyle('V8:V9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$this->newphpexcel->getActiveSheet()->mergeCells('W8:W9');

			$this->newphpexcel->getActiveSheet()->getStyle('W8:W9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$this->newphpexcel->getActiveSheet()->mergeCells('X8:X9');

			$this->newphpexcel->getActiveSheet()->getStyle('X8:X9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$this->newphpexcel->getActiveSheet()->mergeCells('Y8:Y9');

			$this->newphpexcel->getActiveSheet()->getStyle('Y8:Y9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$this->newphpexcel->getActiveSheet()->mergeCells('Z8:Z9');

			$this->newphpexcel->getActiveSheet()->getStyle('Z8:Z9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			

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

			$this->newphpexcel->getActiveSheet()->getColumnDimension('Q')->setWidth(20);

			$this->newphpexcel->getActiveSheet()->getColumnDimension('R')->setWidth(15);

			$this->newphpexcel->getActiveSheet()->getColumnDimension('S')->setWidth(15);

			$this->newphpexcel->getActiveSheet()->getColumnDimension('T')->setWidth(15);

			$this->newphpexcel->getActiveSheet()->getColumnDimension('U')->setWidth(40);

			$this->newphpexcel->getActiveSheet()->getColumnDimension('V')->setWidth(15);

			$this->newphpexcel->getActiveSheet()->getColumnDimension('W')->setWidth(40);

			$this->newphpexcel->getActiveSheet()->getColumnDimension('X')->setWidth(20);

			$this->newphpexcel->getActiveSheet()->getColumnDimension('Y')->setWidth(15);

			$this->newphpexcel->getActiveSheet()->getColumnDimension('Z')->setWidth(15);

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

			$this->newphpexcel->getActiveSheet()->getStyle('W8')->applyFromArray($arrheader);

			$this->newphpexcel->getActiveSheet()->getStyle('X8')->applyFromArray($arrheader);

			$this->newphpexcel->getActiveSheet()->getStyle('Y8')->applyFromArray($arrheader);

			$this->newphpexcel->getActiveSheet()->getStyle('Z8')->applyFromArray($arrheader);

			

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

			$this->newphpexcel->getActiveSheet()->getStyle('W9')->applyFromArray($arrheader);

			$this->newphpexcel->getActiveSheet()->getStyle('X9')->applyFromArray($arrheader);

			$this->newphpexcel->getActiveSheet()->getStyle('Y9')->applyFromArray($arrheader);

			$this->newphpexcel->getActiveSheet()->getStyle('Z9')->applyFromArray($arrheader);

			

			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A8','No.')->setCellValue('B8','Kode Sampel')->setCellValue('C8','Nama Sampel')->setCellValue('D8','Jenis Sampling')->setCellValue('E8','Jenis')->setCellValue('F8','Nomor Izin Edar')->setCellValue('G8','No Bets')->setCellValue('H8','Kemasan')->setCellValue('I8','Kedaluarsa')->setCellValue('J8','Nama dan Alamat Perusahaan')->setCellValue('K8','Komposisi')->setCellValue('L8','Tempat & Tanggal Sampling')->setCellValue('M8','Hasil Pengujian')->setCellValue('S8','Tanggal Pengujian')->setCellValue('U8','Nama Penguji')->setCellValue('V8','Kesimpulan')->setCellValue('W8','BBPOM / BPOM')->setCellValue('M9','Parameter Uji')->setCellValue('N9','Kuantitatif / Kualitatif')->setCellValue('O9','Metode Pemeriksaan / Pustaka')->setCellValue('P9','Syarat')->setCellValue('Q9','Hasil Parameter')->setCellValue('R9','Bidang Uji')->setCellValue('S9','Awal Uji')->setCellValue('T9','Akhir Uji')->setCellValue('X8','PRIORITAS')->setCellValue('Y8','TAHUN')->setCellValue('Z8','Tanggal Entri');

			

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

						->setCellValueExplicit('F'.$rec,($kode != $row["UR_KODE_SAMPEL"] ? $row["NOMOR_REGISTRASI"] : ''), PHPExcel_Cell_DataType::TYPE_STRING)

						->setCellValueExplicit('G'.$rec,($kode != $row["UR_KODE_SAMPEL"] ? $row["NO_BETS"] : ''), PHPExcel_Cell_DataType::TYPE_STRING)

						->setCellValue('H'.$rec,($kode != $row["UR_KODE_SAMPEL"] ? $row["KEMASAN"] : ''))

						->setCellValue('I'.$rec,($kode != $row["UR_KODE_SAMPEL"] ? $row["KETERANGAN_ED"] : ''))

						->setCellValue('J'.$rec,($kode != $row["UR_KODE_SAMPEL"] ? $row["PABRIK"].chr(10).$row["IMPORTIR"] : ''))

						->setCellValueExplicit('K'.$rec,($kode != $row["UR_KODE_SAMPEL"] ? $row["KOMPOSISI"] : ''), PHPExcel_Cell_DataType::TYPE_STRING)

						#->setCellValue('L'.$rec,($kode != $row["UR_KODE_SAMPEL"] ? str_replace('=-','',$row["TEMPAT_SAMPLING"]).chr(10).$row["TANGGAL_SAMPLING"] : ''))

						->setCellValueExplicit('L'.$rec,($kode != $row["UR_KODE_SAMPEL"] ? $row["TEMPAT_SAMPLING"].chr(10).$row["TANGGAL_SAMPLING"] : ''), PHPExcel_Cell_DataType::TYPE_STRING)

						#->setCellValue('M'.$rec,$row["PARAMETER_UJI"])

						->setCellValueExplicit('M'.$rec,$row["PARAMETER_UJI"], PHPExcel_Cell_DataType::TYPE_STRING)

						#->setCellValue('N'.$rec,str_replace("<"," < ",str_replace('=-',' ',$row["HASIL"])).chr(10).str_replace("<"," < ",str_replace('-',' ',$row["HASIL_KUALITATIF"])))

						->setCellValueExplicit('N'.$rec,$row["HASIL"].chr(10).$row["HASIL_KUALITATIF"], PHPExcel_Cell_DataType::TYPE_STRING)

						#->setCellValue('O'.$rec,str_replace("<"," < ",str_replace('=-',' ',$row["METODE"])).chr(10).str_replace("<"," < ",str_replace('-',' ',$row["PUSTAKA"])))

						->setCellValueExplicit('O'.$rec,$row["METODE"].chr(10).$row["PUSTAKA"], PHPExcel_Cell_DataType::TYPE_STRING)

						#->setCellValue('P'.$rec,str_replace("<", " < ", str_replace('=-',' ',$row["SYARAT"])))

						->setCellValueExplicit('P'.$rec,$row["SYARAT"], PHPExcel_Cell_DataType::TYPE_STRING)

						->setCellValue('Q'.$rec,(strlen($row["HASIL_PARAMETER"]) > 0 ? $row["HASIL_PARAMETER"] : ''))

						->setCellValue('R'.$rec,$row["JENIS_UJI"])

						->setCellValue('S'.$rec,$row["AWAL_UJI"])

						->setCellValue('T'.$rec,$row["AKHIR_UJI"])

						->setCellValue('U'.$rec,$row["NAMA_USER"])

						->setCellValue('V'.$rec,($kode != $row["UR_KODE_SAMPEL"] ? $row["HASIL_SAMPEL"] : ''))

						->setCellValue('W'.$rec,($kode != $row["UR_KODE_SAMPEL"] ? $row["BBPOM"] : ''))

						->setCellValue('X'.$rec,$row["PRIORITAS"])

						->setCellValue('Y'.$rec,$tahun)			

						->setCellValue('Z'.$rec,$row["CREATE_DATE"]);					

						#->setCellValue('X'.$rec,($kode != $row["UR_KODE_SAMPEL"] ? $row["PRIORITAS"] : ''))

						#->setCellValue('Y'.$rec,($kode != $row["UR_KODE_SAMPEL"] ? $tahun : ''))

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

						$this->newphpexcel->getActiveSheet()->getStyle('W'.$rec)->applyFromArray($arrleft);

						$this->newphpexcel->getActiveSheet()->getStyle('H'.$rec)->getAlignment()->setWrapText(true);

						$this->newphpexcel->getActiveSheet()->getStyle('J'.$rec)->getAlignment()->setWrapText(true);

						$this->newphpexcel->getActiveSheet()->getStyle('K'.$rec)->getAlignment()->setWrapText(true);

						$this->newphpexcel->getActiveSheet()->getStyle('L'.$rec)->getAlignment()->setWrapText(true);

						$this->newphpexcel->getActiveSheet()->getStyle('N'.$rec)->getAlignment()->setWrapText(true);

						$this->newphpexcel->getActiveSheet()->getStyle('O'.$rec)->getAlignment()->setWrapText(true);

						$this->newphpexcel->getActiveSheet()->getStyle('P'.$rec)->getAlignment()->setWrapText(true);

						$this->newphpexcel->getActiveSheet()->getStyle('R'.$rec)->getAlignment()->setWrapText(true);

						$this->newphpexcel->getActiveSheet()->getStyle('S'.$rec)->getAlignment()->setWrapText(true);

						$this->newphpexcel->getActiveSheet()->getStyle('U'.$rec)->getAlignment()->setWrapText(true);

						$this->newphpexcel->getActiveSheet()->getStyle('W'.$rec)->getAlignment()->setWrapText(true);

						$this->newphpexcel->getActiveSheet()->getStyle('X'.$rec)->applyFromArray($arrleft);

						$this->newphpexcel->getActiveSheet()->getStyle('Y'.$rec)->applyFromArray($arrleft);

						$this->newphpexcel->getActiveSheet()->getStyle('Z'.$rec)->applyFromArray($arrleft);

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

				$this->newphpexcel->getActiveSheet()->getStyle('T10')->applyFromArray($arrleft);

				$this->newphpexcel->getActiveSheet()->getStyle('U10')->applyFromArray($arrleft);

				$this->newphpexcel->getActiveSheet()->getStyle('V10')->applyFromArray($arrleft);

				$this->newphpexcel->getActiveSheet()->getStyle('W10')->applyFromArray($arrleft);

				$this->newphpexcel->getActiveSheet()->getStyle('X10')->applyFromArray($arrleft);

				$this->newphpexcel->getActiveSheet()->getStyle('Y10')->applyFromArray($arrleft);

			}

			

			ob_clean();

			$file = "HASIL_PENGUJIAN_SAMPLING_".$bulan."_".$tahun.".xls";

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