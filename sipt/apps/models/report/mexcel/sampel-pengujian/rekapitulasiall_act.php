<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);
class Rekapitulasiall_act extends Model{
	
	function get_sampel(){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$this->load->library('newphpexcel');
			$query = "SELECT REPLACE(REPLACE(C.NAMA_BBPOM, 'BALAI POM DI ', ''), 'BALAI BESAR POM DI ','') AS BBPOM, dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) AS KODE_SAMPEL, A.NAMA_SAMPEL, A.NOMOR_REGISTRASI, dbo.KATEGORI(A.KOMODITI,A.PRIORITAS) AS KOMODITI, dbo.KATEGORI(A.KATEGORI,A.PRIORITAS) AS KATEGORIX, A.NAMA_KATEGORI AS KATEGORI, dbo.URAIAN_M_TABEL('TUJUAN_SAMPLING',A.TUJUAN_SAMPLING) AS TUJUAN_SAMPLING, dbo.URAIAN_M_TABEL('ANGGARAN_SAMPLING',A.ANGGARAN) AS ANGGARAN_SAMPLING, dbo.URAIAN_M_TABEL('ASAL_SAMPLING', A.ASAL_SAMPEL) AS ASAL_SAMPEL, dbo.URAIAN_M_TABEL('SUB_TUJUAN', A.SUB_TUJUAN) AS SUB_TUJUAN, CONVERT(VARCHAR(10), A.TANGGAL_SAMPLING,103) AS TANGGAL_SAMPLING, A.TEMPAT_SAMPLING, A.ALAMAT_SAMPLING, A.CATATAN, A.KOMPOSISI, A.NETTO, A.SATUAN, LTRIM(RTRIM(A.NO_BETS)) AS NO_BETS, A.KETERANGAN_ED, A.HARGA_SAMPEL, A.JUMLAH_KIMIA, A.JUMLAH_MIKRO, A.SISA, A.JUMLAH_SAMPEL, A.KONDISI_SAMPEL, A.SEGEL, A.LABEL, A.PABRIK, A.IMPORTIR, A.EVALUASI_PENANDAAN, CONVERT(VARCHAR(10), A.CREATE_DATE, 103) AS CREATE_DATE, CONVERT(VARCHAR(10), A.CREATE_DATE, 120) AS SORTTGL FROM T_M_SAMPEL A LEFT JOIN T_PERIKSA_SAMPEL B ON A.PERIKSA_SAMPEL = B.PERIKSA_SAMPEL LEFT JOIN M_BBPOM C ON B.BBPOM_ID = C.BBPOM_ID WHERE MONTH(A.TANGGAL_SAMPLING) = '".$this->input->post('BULAN')."' AND YEAR(A.TANGGAL_SAMPLING) = '".$this->input->post('TAHUN')."' ";
			if(trim($this->input->post('KOMODITI')!="")){
				$query .= $sipt->main->find_where($query);
				$query .= " A.KOMODITI = '".$this->input->post('KOMODITI')."' ";
			}
			
			if($this->input->post('REKAP_KOMODITI')){
				$query .= $sipt->main->find_where($query);
				$query .= " A.REKAP_KOMODITI = '".$this->input->post('REKAP_KOMODITI')."' ";
			}
			
			if(trim($this->input->post('TUJUAN_SAMPLING')!="")){
				$query .= $sipt->main->find_where($query);
				$query .= " A.TUJUAN_SAMPLING = '".$this->input->post('TUJUAN_SAMPLING')."' ";
				$tujuan = $sipt->main->get_uraian("SELECT URAIAN FROM M_TABEL WHERE JENIS = 'TUJUAN_SAMPLING' AND KODE = '".$this->input->post('TUJUAN_SAMPLING')."'","URAIAN");
			}else{
				$tujuan = "";
			}
			
			if(trim($this->input->post('SUB_TUJUAN')!="")){
				$query .= $sipt->main->find_where($query);
				$query .= " A.SUB_TUJUAN = '".$this->input->post('SUB_TUJUAN')."' ";
				$sub_tujuan = $sipt->main->get_uraian("SELECT URAIAN FROM M_TABEL WHERE JENIS = 'SUB_TUJUAN' AND KODE = '".$this->input->post('TUJUAN_SAMPLING')."'","URAIAN");
			}else{
				$sub_tujuan = "";
			}

			if(trim($this->input->post('ANGGARAN_SAMPLING')!="")){
				$query .= $sipt->main->find_where($query);
				$query .= " A.ANGGARAN = '".$this->input->post('ANGGARAN_SAMPLING')."' ";
				$anggaran = $sipt->main->get_uraian("SELECT URAIAN FROM M_TABEL WHERE JENIS = 'ANGGARAN_SAMPLING' AND KODE = '".$this->input->post('ANGGARAN_SAMPLING')."'","URAIAN");
			}else{
				$anggaran = "";
			}

			if(trim($this->input->post('ASAL_SAMPLING')!="")){
				$query .= $sipt->main->find_where($query);
				$query .= " A.ASAL_SAMPEL = '".$this->input->post('ASAL_SAMPLING')."' ";
				$asal = $sipt->main->get_uraian("SELECT URAIAN FROM M_TABEL WHERE JENIS = 'ASAL_SAMPLING' AND KODE = '".$this->input->post('ASAL_SAMPLING')."'","URAIAN");
			}else{
				$asal = "";
			}
			
			if(in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')) || $this->newsession->userdata('SESS_BBPOM_ID') == "00"){
				if(trim($this->input->post('BBPOM_ID'))==""){
					$query .= "";
					$balai = 'Seluruh Balai';
				}else{
					$query .= $sipt->main->find_where($query);
					$query .= " B.BBPOM_ID = '".$this->input->post('BBPOM_ID')."'";
					$balai = $sipt->main->get_uraian("SELECT REPLACE(REPLACE(NAMA_BBPOM, 'BALAI POM DI ', ''), 'BALAI BESAR POM DI ','') AS NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID = '".$this->input->post('BBPOM_ID')."'","NAMA_BBPOM");		
					$bbpom = $this->input->post('BBPOM_ID');
				}
			}else{
				$query .= $sipt->main->find_where($query);
				$query .= " B.BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND SUBSTRING(A.KODE_SAMPEL,3,3) = (CASE WHEN LEN(C.KODE_BALAI) = 2 THEN '0'+C.KODE_BALAI ELSE C.KODE_BALAI END)";
				$bbpom = $this->newsession->userdata('SESS_BBPOM_ID');
				$balai = $sipt->main->get_uraian("SELECT REPLACE(REPLACE(NAMA_BBPOM, 'BALAI POM DI ', ''), 'BALAI BESAR POM DI ','') AS NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","NAMA_BBPOM");		
			}
			$query .= $sipt->main->find_where($query);
			$query .= " A.STATUS_SAMPEL NOT IN ('00000')";
			//$query .= " ORDER BY A.KODE_SAMPEL, B.BBPOM_ID DESC";
			$query .= " ORDER BY 32 ASC";
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
			
			$this->newphpexcel->set_title('Rekap Sampel');
			$this->newphpexcel->getDefaultStyle()->getFont()->setName('Calibri')->setSize(10);
			
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A1', 'REKAP DATA SAMPEL')->setCellValue('A2', 'BALAI BESAR / BALAI POM')->setCellValue('C2', strtoupper($balai))
			->setCellValue('A3', 'Periode Sampling')->setCellValue('C3', $bulan.' '.$this->input->post('TAHUN'))
			->setCellValue('A4', 'Anggaran Sampling')->setCellValue('C4', $anggaran)
			->setCellValue('A5', 'Tujuan Sampling')->setCellValue('C5', $tujuan)
			->setCellValue('A6', 'Asal Sampel')->setCellValue('C6', $asal);
			
			$this->newphpexcel->getActiveSheet()->mergeCells('A1:B1');
			$this->newphpexcel->getActiveSheet()->mergeCells('A2:B2');
			$this->newphpexcel->getActiveSheet()->mergeCells('A3:B3');
			$this->newphpexcel->getActiveSheet()->mergeCells('A4:B4');
			$this->newphpexcel->getActiveSheet()->mergeCells('A5:B5');
			$this->newphpexcel->getActiveSheet()->mergeCells('A6:B6');
			$this->newphpexcel->getActiveSheet()->mergeCells('A6:B6');
			
			
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
			$this->newphpexcel->getActiveSheet()->mergeCells('M8:M9');
			$this->newphpexcel->getActiveSheet()->getStyle('M8:M9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->newphpexcel->getActiveSheet()->mergeCells('N8:N9');
			$this->newphpexcel->getActiveSheet()->getStyle('N8:N9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->newphpexcel->getActiveSheet()->mergeCells('O8:O9');
			$this->newphpexcel->getActiveSheet()->getStyle('O8:O9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->newphpexcel->getActiveSheet()->mergeCells('P8:P9');
			$this->newphpexcel->getActiveSheet()->getStyle('P8:P9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->newphpexcel->getActiveSheet()->mergeCells('Q8:T8');
			$this->newphpexcel->getActiveSheet()->getStyle('Q8:T8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
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
			$this->newphpexcel->getActiveSheet()->mergeCells('AA8:AA9');
			$this->newphpexcel->getActiveSheet()->getStyle('AA8:AA9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->newphpexcel->getActiveSheet()->mergeCells('AB8:AB9');
			$this->newphpexcel->getActiveSheet()->getStyle('AB8:AB9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->newphpexcel->getActiveSheet()->mergeCells('AC8:AC9');
			$this->newphpexcel->getActiveSheet()->getStyle('AC8:AC9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->newphpexcel->getActiveSheet()->mergeCells('AD8:AD9');
			$this->newphpexcel->getActiveSheet()->getStyle('AD8:AD9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			
			$this->newphpexcel->getActiveSheet()->getColumnDimension('A')->setWidth(7);
			$this->newphpexcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
			$this->newphpexcel->getActiveSheet()->getColumnDimension('C')->setWidth(50);
			$this->newphpexcel->getActiveSheet()->getColumnDimension('D')->setWidth(17);
			$this->newphpexcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
			$this->newphpexcel->getActiveSheet()->getColumnDimension('F')->setWidth(35);
			$this->newphpexcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
			$this->newphpexcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
			$this->newphpexcel->getActiveSheet()->getColumnDimension('I')->setWidth(30);
			$this->newphpexcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
			$this->newphpexcel->getActiveSheet()->getColumnDimension('K')->setWidth(40);
			$this->newphpexcel->getActiveSheet()->getColumnDimension('L')->setWidth(10);
			$this->newphpexcel->getActiveSheet()->getColumnDimension('M')->setWidth(10);
			$this->newphpexcel->getActiveSheet()->getColumnDimension('N')->setWidth(20);
			$this->newphpexcel->getActiveSheet()->getColumnDimension('O')->setWidth(15);
			$this->newphpexcel->getActiveSheet()->getColumnDimension('P')->setWidth(15);
			$this->newphpexcel->getActiveSheet()->getColumnDimension('Q')->setWidth(10);
			$this->newphpexcel->getActiveSheet()->getColumnDimension('R')->setWidth(10);
			$this->newphpexcel->getActiveSheet()->getColumnDimension('S')->setWidth(10);
			$this->newphpexcel->getActiveSheet()->getColumnDimension('T')->setWidth(10);
			$this->newphpexcel->getActiveSheet()->getColumnDimension('U')->setWidth(40);
			$this->newphpexcel->getActiveSheet()->getColumnDimension('V')->setWidth(30);
			$this->newphpexcel->getActiveSheet()->getColumnDimension('W')->setWidth(10);
			$this->newphpexcel->getActiveSheet()->getColumnDimension('X')->setWidth(15);
			$this->newphpexcel->getActiveSheet()->getColumnDimension('Y')->setWidth(30);
			$this->newphpexcel->getActiveSheet()->getColumnDimension('Z')->setWidth(30);
			$this->newphpexcel->getActiveSheet()->getColumnDimension('AA')->setWidth(23);
			$this->newphpexcel->getActiveSheet()->getColumnDimension('AB')->setWidth(50);
			$this->newphpexcel->getActiveSheet()->getColumnDimension('AC')->setWidth(30);
			$this->newphpexcel->getActiveSheet()->getColumnDimension('AD')->setWidth(15);
			
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A8','No.')->setCellValue('B8','Kode Sampel')->setCellValue('C8','Nama Sampel')->setCellValue('D8','Nomor Registrasi')->setCellValue('E8','Komoditi')->setCellValue('F8','Kategori Sampel')->setCellValue('G8','Anggaran')->setCellValue('H8','Tujuan')->setCellValue('I8','Asal Sampel')->setCellValue('J8','Tanggal Sampling')->setCellValue('K8','Komposisi')->setCellValue('L8','Netto')->setCellValue('M8','Harga')->setCellValue('N8','Satuan')->setCellValue('O8','No Bets')->setCellValue('P8','Tanggal Expired')->setCellValue('Q8','Jumlah')->setCellValue('U8','Tempat Sampling')->setCellValue('V8','Kondisi Sampel')->setCellValue('W8','Segel')->setCellValue('X8','Label')->setCellValue('Y8','Pabrik')->setCellValue('Z8','Importir')->setCellValue('AA8','Evaluasi Penandaan')->setCellValue('AB8','Catatan')->setCellValue('AC8','Balai Besar / Balai POM')->setCellValue('AD8','Tanggal Entri')->setCellValue('Q9','Kimia')->setCellValue('R9','Mikro')->setCellValue('S9','Sisa')->setCellValue('T9','Total');
			
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
			$this->newphpexcel->getActiveSheet()->getStyle('AA8')->applyFromArray($arrheader);
			$this->newphpexcel->getActiveSheet()->getStyle('AB8')->applyFromArray($arrheader);
			$this->newphpexcel->getActiveSheet()->getStyle('AC8')->applyFromArray($arrheader);
			$this->newphpexcel->getActiveSheet()->getStyle('AD8')->applyFromArray($arrheader);
			
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
			$this->newphpexcel->getActiveSheet()->getStyle('AA9')->applyFromArray($arrheader);
			$this->newphpexcel->getActiveSheet()->getStyle('AB9')->applyFromArray($arrheader);
			$this->newphpexcel->getActiveSheet()->getStyle('AC9')->applyFromArray($arrheader);
			$this->newphpexcel->getActiveSheet()->getStyle('AD9')->applyFromArray($arrheader);
			
			$data = $sipt->main->get_result($query);
			$rec = 10;
			if($data){
				$no=1;
				foreach($query->result_array() as $row){
					if(trim($this->input->post('BBPOM_ID'))!=""){
						$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A'.$rec,$no)
						->setCellValue('B'.$rec,$row["KODE_SAMPEL"])
						->setCellValue('C'.$rec,$row["NAMA_SAMPEL"])
						->setCellValue('D'.$rec,$row["NOMOR_REGISTRASI"])
						->setCellValue('E'.$rec,$row["KOMODITI"])
						->setCellValue('F'.$rec,str_replace(" &raquo; "," , ",$row["KATEGORI"]))
						->setCellValue('G'.$rec,$row["ANGGARAN_SAMPLING"])
						->setCellValue('H'.$rec,$row["TUJUAN_SAMPLING"] . " " .(strlen($row["SUB_TUJUAN"]) == 0 ? "" : '( '.$row["SUB_TUJUAN"].' )'))
						->setCellValue('I'.$rec,$row["ASAL_SAMPEL"])
						->setCellValue('J'.$rec,$row["TANGGAL_SAMPLING"])
						->setCellValue('K'.$rec,$row["KOMPOSISI"])
						->setCellValue('L'.$rec,$row["NETTO"])
						->setCellValue('M'.$rec,$row["HARGA_SAMPEL"])
						->setCellValue('N'.$rec,$row["SATUAN"])
						->setCellValueExplicit('O'.$rec,$row["NO_BETS"], PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValue('P'.$rec,$row["KETERANGAN_ED"])
						->setCellValue('Q'.$rec,$row["JUMLAH_KIMIA"])
						->setCellValue('R'.$rec,$row["JUMLAH_MIKRO"])
						->setCellValue('S'.$rec,$row["SISA"])
						->setCellValue('T'.$rec,$row["JUMLAH_SAMPEL"])
						->setCellValue('U'.$rec,$row["TEMPAT_SAMPLING"].chr(10).$row["ALAMAT_SAMPLING"])
						->setCellValue('V'.$rec,$row["KONDISI_SAMPEL"])
						->setCellValue('W'.$rec,$row["SEGEL"])
						->setCellValue('X'.$rec,$row["LABEL"])
						->setCellValue('Y'.$rec,$row["PABRIK"])
						->setCellValue('Z'.$rec,$row["IMPORTIR"])
						->setCellValue('AA'.$rec,$row["EVALUASI_PENANDAAN"])
						->setCellValue('AB'.$rec,$row["CATATAN"])
						->setCellValue('AC'.$rec,$row["BBPOM"])
						->setCellValue('AD'.$rec,$row["CREATE_DATE"]);
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
						$this->newphpexcel->getActiveSheet()->getStyle('X'.$rec)->applyFromArray($arrleft);
						$this->newphpexcel->getActiveSheet()->getStyle('Y'.$rec)->applyFromArray($arrleft);
						$this->newphpexcel->getActiveSheet()->getStyle('Z'.$rec)->applyFromArray($arrleft);
						$this->newphpexcel->getActiveSheet()->getStyle('AA'.$rec)->applyFromArray($arrleft);
						$this->newphpexcel->getActiveSheet()->getStyle('AB'.$rec)->applyFromArray($arrleft);
						$this->newphpexcel->getActiveSheet()->getStyle('AC'.$rec)->applyFromArray($arrleft);
						$this->newphpexcel->getActiveSheet()->getStyle('AD'.$rec)->applyFromArray($arrleft);
						$this->newphpexcel->getActiveSheet()->getStyle('C'.$rec)->getAlignment()->setWrapText(true);
						$this->newphpexcel->getActiveSheet()->getStyle('F'.$rec)->getAlignment()->setWrapText(true);
						$this->newphpexcel->getActiveSheet()->getStyle('I'.$rec)->getAlignment()->setWrapText(true);
						$this->newphpexcel->getActiveSheet()->getStyle('R'.$rec)->getAlignment()->setWrapText(true);
						$this->newphpexcel->getActiveSheet()->getStyle('U'.$rec)->getAlignment()->setWrapText(true);
						$this->newphpexcel->getActiveSheet()->getStyle('V'.$rec)->getAlignment()->setWrapText(true);
					}else{
						$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A'.$rec,$no)
						->setCellValue('B'.$rec,$row["KODE_SAMPEL"])
						->setCellValue('C'.$rec,$row["NAMA_SAMPEL"])
						->setCellValue('D'.$rec,$row["NOMOR_REGISTRASI"])
						->setCellValue('E'.$rec,$row["KOMODITI"])
						->setCellValue('F'.$rec,str_replace(" &raquo; "," , ",$row["KATEGORI"]))
						->setCellValue('G'.$rec,$row["ANGGARAN_SAMPLING"])
						->setCellValue('H'.$rec,$row["TUJUAN_SAMPLING"] . " " .(strlen($row["SUB_TUJUAN"]) == 0 ? "" : '( '.$row["SUB_TUJUAN"].' )'))
						->setCellValue('I'.$rec,$row["ASAL_SAMPEL"])
						->setCellValue('J'.$rec,$row["TANGGAL_SAMPLING"])
						->setCellValue('K'.$rec,$row["KOMPOSISI"])
						->setCellValue('L'.$rec,$row["NETTO"])
						->setCellValue('M'.$rec,$row["HARGA_SAMPEL"])
						->setCellValue('N'.$rec,$row["SATUAN"])
						->setCellValueExplicit('O'.$rec,$row["NO_BETS"], PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValue('P'.$rec,$row["KETERANGAN_ED"])
						->setCellValue('Q'.$rec,$row["JUMLAH_KIMIA"])
						->setCellValue('R'.$rec,$row["JUMLAH_MIKRO"])
						->setCellValue('S'.$rec,$row["SISA"])
						->setCellValue('T'.$rec,$row["JUMLAH_SAMPEL"])
						->setCellValue('U'.$rec,$row["TEMPAT_SAMPLING"].chr(10).$row["ALAMAT_SAMPLING"])
						->setCellValue('V'.$rec,$row["KONDISI_SAMPEL"])
						->setCellValue('W'.$rec,$row["SEGEL"])
						->setCellValue('X'.$rec,$row["LABEL"])
						->setCellValue('Y'.$rec,$row["PABRIK"])
						->setCellValue('Z'.$rec,$row["IMPORTIR"])
						->setCellValue('AA'.$rec,$row["EVALUASI_PENANDAAN"])
						->setCellValue('AB'.$rec,$row["CATATAN"])
						->setCellValue('AC'.$rec,$row["BBPOM"])
						->setCellValue('AD'.$rec,$row["CREATE_DATE"]);
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
						$this->newphpexcel->getActiveSheet()->getStyle('X'.$rec)->applyFromArray($arrleft);
						$this->newphpexcel->getActiveSheet()->getStyle('Y'.$rec)->applyFromArray($arrleft);
						$this->newphpexcel->getActiveSheet()->getStyle('Z'.$rec)->applyFromArray($arrleft);
						$this->newphpexcel->getActiveSheet()->getStyle('AA'.$rec)->applyFromArray($arrleft);
						$this->newphpexcel->getActiveSheet()->getStyle('AB'.$rec)->applyFromArray($arrleft);
						$this->newphpexcel->getActiveSheet()->getStyle('AC'.$rec)->applyFromArray($arrleft);
						$this->newphpexcel->getActiveSheet()->getStyle('AD'.$rec)->applyFromArray($arrleft);
						
						$this->newphpexcel->getActiveSheet()->getStyle('C'.$rec)->getAlignment()->setWrapText(true);
						$this->newphpexcel->getActiveSheet()->getStyle('F'.$rec)->getAlignment()->setWrapText(true);
						$this->newphpexcel->getActiveSheet()->getStyle('I'.$rec)->getAlignment()->setWrapText(true);
						$this->newphpexcel->getActiveSheet()->getStyle('R'.$rec)->getAlignment()->setWrapText(true);
						$this->newphpexcel->getActiveSheet()->getStyle('U'.$rec)->getAlignment()->setWrapText(true);
						$this->newphpexcel->getActiveSheet()->getStyle('V'.$rec)->getAlignment()->setWrapText(true);
					}
					$rec++;
					$no++;
				}
			}else{
				if(trim($this->input->post('BBPOM_ID'))==""){
					$this->newphpexcel->getActiveSheet()->getStyle('A10:AD10')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
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
					$this->newphpexcel->getActiveSheet()->getStyle('X'.$rec)->applyFromArray($arrleft);
					$this->newphpexcel->getActiveSheet()->getStyle('Y'.$rec)->applyFromArray($arrleft);
					$this->newphpexcel->getActiveSheet()->getStyle('Z'.$rec)->applyFromArray($arrleft);
					$this->newphpexcel->getActiveSheet()->getStyle('AA'.$rec)->applyFromArray($arrleft);
					$this->newphpexcel->getActiveSheet()->getStyle('AB'.$rec)->applyFromArray($arrleft);
					$this->newphpexcel->getActiveSheet()->getStyle('AC'.$rec)->applyFromArray($arrleft);
					$this->newphpexcel->getActiveSheet()->getStyle('AD'.$rec)->applyFromArray($arrleft);
				}else{
					$this->newphpexcel->getActiveSheet()->getStyle('A10:AD10')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
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
					$this->newphpexcel->getActiveSheet()->getStyle('X'.$rec)->applyFromArray($arrleft);
					$this->newphpexcel->getActiveSheet()->getStyle('Y'.$rec)->applyFromArray($arrleft);
					$this->newphpexcel->getActiveSheet()->getStyle('Z'.$rec)->applyFromArray($arrleft);
					$this->newphpexcel->getActiveSheet()->getStyle('AA'.$rec)->applyFromArray($arrleft);
					$this->newphpexcel->getActiveSheet()->getStyle('AB'.$rec)->applyFromArray($arrleft);
				}
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A10','Data Tidak Ditemukan');
			}			
			ob_clean();
			$file = "REKAPITULASI_SAMPEL_".$bulan."_".$this->input->post('TAHUN').".xls";
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