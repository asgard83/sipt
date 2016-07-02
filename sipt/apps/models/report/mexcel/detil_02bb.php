<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);
class Detil_02BB extends Model{
	
	function set_excel_sarana(){
		if($this->newsession->userdata('LOGGED_IN') == TRUE){
			$sipt =& get_instance();
			$this->load->model("main","main",true);
			$this->load->library("newphpexcel");
			$judul = $sipt->main->get_judul($this->input->post('JENIS'));
			if($this->input->post('KK_ID') != "")
				$klas = " LEFT JOIN T_PEMERIKSAAN_KLASIFIKASI F ON D.PERIKSA_ID = F.PERIKSA_ID ";
			else
				$klas = "";
			$query = "SELECT A.NAMA_SARANA, CAST(A.ALAMAT_1+' '+C.NAMA_PROPINSI+' '+B.NAMA_PROPINSI AS VARCHAR(255)) AS ALAMAT, 
A.NAMA_PIMPINAN,A.PENANGGUNG_JAWAB, CONVERT(VARCHAR(10), D.AWAL_PERIKSA, 103) + ' s.d ' 
+ CONVERT(VARCHAR(10), D.AKHIR_PERIKSA, 103) AS [TANGGAL], 
E.TUJUAN_PEMERIKSAAN, E.PRODUK, E.ASPEK_CHECK, E.ASPEK_KETERANGAN,
E.TINDAK_LANJUT, E.REKOMENDASI, 
CASE WHEN E.REKOMENDASI = '01' THEN 'Peringatan Tertulis' WHEN E.REKOMENDASI = '02' THEN 'Penghentian Sementara Kegiatan' WHEN E.REKOMENDASI = '03' THEN 'Pencabutan Izin Usaha Khusus' WHEN E.REKOMENDASI = '04' THEN 'Rekomendasi Izin Usaha Umum' WHEN E.REKOMENDASI = '05' THEN 'Kebijakan Lain' END AS REKOMENDASI,
E.KEBIJAKAN, E.HASIL_UJI, E.KODE_SAMPEL, E.CATATAN, E.KELOLA_BB,
CASE 
	WHEN A.SARANA_BB = 'DT-B2' THEN 'DT B2'
	WHEN A.SARANA_BB = 'DT-B2C' THEN 'DT B2 Cabang'
	WHEN A.SARANA_BB = 'IP-B2' THEN 'IP B2'
	WHEN A.SARANA_BB = 'IT-B2' THEN 'IT B2'
	WHEN A.SARANA_BB = 'IT-B2C' THEN 'IT B2 Cabang'
	WHEN A.SARANA_BB = 'PRD' THEN 'Produsen'
	WHEN A.SARANA_BB = 'PT-B2' THEN 'PT B2'
	WHEN A.SARANA_BB = 'STA' THEN 'Sarana Tidak Aktif'
	WHEN A.SARANA_BB = 'STB' THEN 'Sarana Tidak Berizin'
	WHEN A.SARANA_BB = 'PLK' THEN 'Pelayanan'
END AS SARANA_BB, 
CASE 
	WHEN A.STATUS_SARANA = '1' THEN 'Aktif'
	WHEN A.STATUS_SARANA = '4' THEN 'Tidak Menyalurkan Bahan Berbahaya Lagi'
	WHEN A.STATUS_SARANA = '0' THEN 'TutuP'
END AS STATUS_SARANA,
STUFF(dbo.GROUP_PETUGAS(E.PERIKSA_ID),1,0,'') AS PETUGAS, 
CASE 
	WHEN RTRIM(LTRIM(D.HASIL)) = 'MK' THEN 'Mememnuhi Ketentuan'
	WHEN RTRIM(LTRIM(D.HASIL)) = 'TMK' THEN 'Tidak Mememnuhi Ketentuan'
	WHEN RTRIM(LTRIM(D.HASIL)) = 'TMBB' THEN 'Tidak Mengedarkan Bahan Berbahaya'
	WHEN RTRIM(LTRIM(D.HASIL)) = 'Tutup' THEN 'Mememnuhi Ketentuan'
END AS HASIL 
FROM M_SARANA A LEFT JOIN M_PROPINSI B ON A.PROPINSI = B.PROPINSI_ID 
LEFT JOIN M_PROPINSI C ON A.KOTA = C.PROPINSI_ID LEFT JOIN T_PEMERIKSAAN D ON A.SARANA_ID = D.SARANA_ID 
LEFT JOIN T_PEMERIKSAAN_BB E ON D.PERIKSA_ID = E.PERIKSA_ID $klas
WHERE D.JENIS_SARANA_ID = '02BB'";
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
			if($this->newsession->userdata('SESS_BBPOM_ID') != "96" && $this->newsession->userdata('SESS_BBPOM_ID') != "00"){
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
			$query .= " AND D.STATUS NOT IN ('00')";
			if($this->newsession->userdata('SESS_BBPOM_ID') == "00"){		
				$query .= " AND D.STATUS LIKE '%1_'";			
			}
			if($this->input->post('TEMUAN') != "") $query .= " AND E.ASPEK_KETERANGAN LIKE  '%".$this->input->post('TEMUAN')."%'";
			if($this->input->post('KK_ID') != "") $query .= " AND F.KK_ID = '".$this->input->post('KK_ID')."'";
			if(trim($this->input->post('KOTA')!="")) $query .= " AND A.KOTA  = '".$this->input->post('KOTA')."'";
			
			$this->newphpexcel->getDefaultStyle()->getFont()->setName('Calibri')->setSize(10);
			$this->newphpexcel->setActiveSheetIndex(0);
			$this->newphpexcel->mergecell(array(array('A1','R1'),array('A2','B2'),array('A3','B3'),array('A4','B4'),array('A5','B5')), FALSE);
			$this->newphpexcel->width(array(array('A',5),array('B',30),array('C',30),array('D',20),array('E',20),array('F',25),array('G',20),array('H',30),array('I',30),array('J',30),array('K',30), array('L',30),array('M',30),array('N',30),array('O',30),array('P',30),array('Q',30),array('R',30)));
			$this->newphpexcel->set_bold(array('A1','C2','C5'));
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A1', 'LAPORAN HASIL PEMERIKSAAN SARANA DISTRIBUSI BAHAN BERBAHAYA')->setCellValue('A2', 'Jenis Sarana')->setCellValue('C2', $judul)->setCellValue('A3', 'Pemeriksaan Awal')->setCellValue('C3', $awal)->setCellValue('A4', 'Pemeriksaan Akhir')->setCellValue('C4', $akhir)->setCellValue('A5', 'Balai Besar / Balai POM')->setCellValue('C5', $balai);
			
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A7','No.')->setCellValue('B7','Nama Sarana')->setCellValue('C7','Alamat')->setCellValue('D7','Pimpinan')->setCellValue('E7','Penanggung Jawab')->setCellValue('F7','Bertindak Sebagai')->setCellValue('G7','Status Sarana')->setCellValue('H7','Tanggal Periksa')->setCellValue('I7','Tujuan Pemeriksaan')->setCellValue('J7','Produk Yang Diperiksa')->setCellValue('K7','Keterangan')->setCellValue('L7','Hasil')->setCellValue('M7','Tindak Lanjut')->setCellValue('N7','Kebijakan')->setCellValue('O7','Hasil Uji')->setCellValue('P7','Kode Sampel')->setCellValue('Q7','Bahan Berbahaya Yang Dikelola')->setCellValue('R7','Petugas Pemeriksa');
			
			$this->newphpexcel->headings(array('A7','B7','C7','D7','E7','F7','G7','H7','I7','J7','K7','L7','M7','N7','O7','P7','Q7','R7'));
			$this->newphpexcel->set_wrap(array('B','C','D','E','H','I','J','K','L','M','N','O','P','Q','R'));
			
			$data = $sipt->main->get_result($query);
			if($data){
				$no=1;
				$rec = 8;
				foreach($query->result_array() as $row){
					$jenis_produk = explode("#", trim($row['PRODUK']));
					$inisal_produk = array("01", "02", "03", "04","05", "06", "07", "08");
					$ganti_produk = array("Formaldehid (formalin)", "Paraformaldehid serbuk", "Paraformaldehid tablet", "Boraks", "Rhodamin B", "Kuning Metanil","Auramin","Amaran");
					$arrproduk = str_replace($inisal_produk, $ganti_produk, $jenis_produk); 
					$produk = join(chr(10), $arrproduk);
					$keterangan = join(chr(10), explode("#", $row['ASPEK_KETERANGAN']));
					
					$aspek = explode("#", $row['TINDAK_LANJUT']);
					$inisal = array("01", "02", "03", "04");
					$ganti = array("Rekomendasi", "Inventarisasi", "Larangan Mengedarkan Sementara", "Pengambilan Contoh");
					$tindak_lanjut = join(",", str_replace($inisal, $ganti, $aspek)); 
					
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A'.$rec,$no)
					->setCellValue('B'.$rec,strtoupper($row["NAMA_SARANA"]))
					->setCellValue('C'.$rec,$row["ALAMAT"])
					->setCellValue('D'.$rec,$row["NAMA_PIMPINAN"])
					->setCellValue('E'.$rec,$row["PENANGGUNG_JAWAB"])
					->setCellValue('F'.$rec,$row["SARANA_BB"])
					->setCellValue('G'.$rec,$row["STATUS_SARANA"])
					->setCellValue('H'.$rec,$row["TANGGAL_PERIKSA"])
					->setCellValue('I'.$rec,$row["TUJUAN_PEMERIKSAAN"])
					->setCellValue('J'.$rec,$produk)
					->setCellValue('K'.$rec,$keterangan)
					->setCellValue('L'.$rec,$row['HASIL'])
					->setCellValue('M'.$rec,$tindak_lanjut.chr(10).$row["REKOMENDASI"])
					->setCellValue('N'.$rec,$row["KEBIJAKAN"])
					->setCellValue('O'.$rec,$row["HASIL_UJI"])
					->setCellValue('P'.$rec,$row["KODE_SAMPEL"])
					->setCellValue('Q'.$rec,$row["KELOLA_BB"])
					->setCellValue('R'.$rec,$row["PETUGAS"]);
					$this->newphpexcel->set_detilstyle(array('A'.$rec,'B'.$rec,'C'.$rec,'D'.$rec,'E'.$rec,'F'.$rec,'G'.$rec,'H'.$rec,'I'.$rec,'J'.$rec,'K'.$rec,'L'.$rec,'M'.$rec,'N'.$rec,'O'.$rec,'P'.$rec,'Q'.$rec,'R'.$rec));
					$rec++;
					$no++;
				}
			}else{
				$this->newphpexcel->getActiveSheet()->mergeCells('A8:R8');
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
	
	function set_excel_sarana_(){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$this->load->library('newphpexcel');
			$judul = $sipt->main->get_judul($this->input->post("JENIS"));
			
			$query = "SELECT DISTINCT(REPLACE(REPLACE(C.NAMA_BBPOM,'BALAI BESAR POM DI ', ''),'BALAI POM DI ','')) AS NAMA_BBPOM,
					  SUM(CASE WHEN RTRIM(LTRIM(A.HASIL)) = 'MK' AND RTRIM(LTRIM(B.TUJUAN_PEMERIKSAAN)) = 'Rutin' THEN 1 ELSE 0 END) AS RUTINMS,
					  SUM(CASE WHEN RTRIM(LTRIM(A.HASIL)) = 'TMK' AND RTRIM(LTRIM(B.TUJUAN_PEMERIKSAAN)) = 'Rutin' THEN 1 ELSE 0 END) AS RUTINTMS,
					  SUM(CASE WHEN RTRIM(LTRIM(A.HASIL)) = 'TMBB' AND RTRIM(LTRIM(B.TUJUAN_PEMERIKSAAN)) = 'Rutin' THEN 1 ELSE 0 END) AS RUTINTMBB,
					  SUM(CASE WHEN RTRIM(LTRIM(A.HASIL)) = 'TTP' AND RTRIM(LTRIM(B.TUJUAN_PEMERIKSAAN)) = 'Rutin' THEN 1 ELSE 0 END) AS RUTINTTP,
					  SUM(CASE WHEN RTRIM(LTRIM(A.HASIL)) = 'MK' AND RTRIM(LTRIM(B.TUJUAN_PEMERIKSAAN)) = 'Penelusuran Jaringan' THEN 1 ELSE 0 END) AS JARINGANMS,
					  SUM(CASE WHEN RTRIM(LTRIM(A.HASIL)) = 'TMK' AND RTRIM(LTRIM(B.TUJUAN_PEMERIKSAAN)) = 'Penelusuran Jaringan' THEN 1 ELSE 0 END) AS JARINGANTMS,
					  SUM(CASE WHEN RTRIM(LTRIM(A.HASIL)) = 'TMBB' AND RTRIM(LTRIM(B.TUJUAN_PEMERIKSAAN)) = 'Penelusuran Jaringan' THEN 1 ELSE 0 END) AS JARINGANTMBB,
					  SUM(CASE WHEN RTRIM(LTRIM(A.HASIL)) = 'TTP' AND RTRIM(LTRIM(B.TUJUAN_PEMERIKSAAN)) = 'Penelusuran Jaringan' THEN 1 ELSE 0 END) AS JARINGANTTP,
					  SUM(CASE WHEN RTRIM(LTRIM(A.HASIL)) = 'MK' AND RTRIM(LTRIM(B.TUJUAN_PEMERIKSAAN)) = 'Kasus' THEN 1 ELSE 0 END) AS KASUSMS,
					  SUM(CASE WHEN RTRIM(LTRIM(A.HASIL)) = 'TMK' AND RTRIM(LTRIM(B.TUJUAN_PEMERIKSAAN)) = 'Kasus' THEN 1 ELSE 0 END) AS KASUSTMS,
					  SUM(CASE WHEN RTRIM(LTRIM(A.HASIL)) = 'TMBB' AND RTRIM(LTRIM(B.TUJUAN_PEMERIKSAAN)) = 'Kasus' THEN 1 ELSE 0 END) AS KASUSTMBB,
					  SUM(CASE WHEN RTRIM(LTRIM(A.HASIL)) = 'TTP' AND RTRIM(LTRIM(B.TUJUAN_PEMERIKSAAN)) = 'Kasus' THEN 1 ELSE 0 END) AS KASUSTTP
					  FROM T_PEMERIKSAAN A LEFT JOIN T_PEMERIKSAAN_BB B ON A.PERIKSA_ID = B.PERIKSA_ID
					  LEFT JOIN M_BBPOM C ON A.BBPOM_ID = C.BBPOM_ID
					  WHERE A.JENIS_SARANA_ID = '02BB'";
			if(trim($this->input->post('AWAL')!="")){
				$query .= " AND DATEDIFF(dy, 0, convert(DATETIME, A.AWAL_PERIKSA, 105)) >= DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('AWAL')."', 105))";
				$awal = $this->input->post('AWAL');
			}else{
				$query .= " AND A.AWAL_PERIKSA > DATEADD(M, DATEDIFF(M,0,GETDATE()),0)";
				$awal = date('01/m/Y');
			}
			if(trim($this->input->post('AKHIR')!="")){
				$query .= " AND DATEDIFF(dy, 0, convert(DATETIME, A.AWAL_PERIKSA, 105)) <= DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('AKHIR')."', 105))";
				$akhir = $this->input->post('AKHIR');
			}else{
				$query .= " AND A.AWAL_PERIKSA < DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,0,GETDATE())+1,0))";
				$akhir = date('t/m/Y');
			}
			
			if($this->newsession->userdata('SESS_BBPOM_ID') != "96" && $this->newsession->userdata('SESS_BBPOM_ID') != "00"){
				$query .= " AND A.BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'";
				$balai = $sipt->main->get_uraian("SELECT NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","NAMA_BBPOM");
			}else{
				if(trim($this->input->post('BBPOM_ID')) == ""){
					$query .= "";
					$balai = "Seluruh Balai";
				}else{
					$query .= " AND A.BBPOM_ID = '".$this->input->post('BBPOM_ID')."'";
					$balai = $sipt->main->get_uraian("SELECT NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID = '".$this->input->post('BBPOM_ID')."'","NAMA_BBPOM");
				}
			}
			$query .= "AND LEN(A.STATUS) > 2 GROUP BY C.BBPOM_ID, C.NAMA_BBPOM ORDER BY 1";
			
			$this->newphpexcel->getDefaultStyle()->getFont()->setName('Calibri')->setSize(10);
			$this->newphpexcel->setActiveSheetIndex(0);
			$this->newphpexcel->mergecell(array(array('A1','N1'),array('A2','B2'),array('A3','B3'),array('A4','B4'),array('A5','B5'),array('C3','N3'),array('C4','N4'),array('C5','N5')), FALSE);
			$this->newphpexcel->mergecell(array(array('A6','A8'),array('B6','B8'),array('C6','N6'),array('C7','F7'),array('G7','J7'),array('K7','N7')), TRUE);
			
			
			$this->newphpexcel->width(array(array('A',5),array('B',30),array('C',5),array('D',5),array('E',7),array('F',8),array('G',5),array('H',5),array('I',7),array('J',8),array('K',5), array('L',5),array('M',7),array('N',8)));
			$this->newphpexcel->set_bold(array('A1','C2','C5'));
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A1', 'REKAP JENIS PEMERIKSAAN YANG DILAKUKAN')->setCellValue('A2', 'Jenis Sarana')->setCellValue('C2', $judul)->setCellValue('A3', 'Pemeriksaan Awal')->setCellValue('C3', $awal)->setCellValue('A4', 'Pemeriksaan Akhir')->setCellValue('C4', $akhir)->setCellValue('A5', 'Balai Besar / Balai POM')->setCellValue('C5', $balai);
			
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A6','No.')->setCellValue('B6','BBPOM / BPOM')->setCellValue('C6','Hasil Pemeriksaan')->setCellValue('C7','Rutin')->setCellValue('G7','Penelusuran Jaringan')->setCellValue('K7','Kasus')->setCellValue('C8','MS')->setCellValue('D8','TMS')->setCellValue('E8','TMBB')->setCellValue('F8','TUTUP')->setCellValue('G8','MS')->setCellValue('H8','TMS')->setCellValue('I8','TMBB')->setCellValue('J8','TUTUP')->setCellValue('K8','MS')->setCellValue('L8','TMS')->setCellValue('M8','TMBB')->setCellValue('N8','TUTUP');
			
			$this->newphpexcel->headings(array('A6','B6','C6','D6','E6','F6','G6','H6','I6','J6','K6','L6','M6','N6','A7','B7','C7','D7','E7','F7','G7','H7','I7','J7','K7','L7','M7','N7','A8','B8','C8','D8','E8','F8','G8','H8','I8','J8','K8','L8','M8','N8'));
			$this->newphpexcel->set_wrap(array('B','C','D','E','H','I','J','K','L','M','N'));
			
			
			$data = $sipt->main->get_result($query);	
			if($data){
				$no=1;
				$rec = 9;
				foreach($query->result_array() as $row){
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A'.$rec,$no)
															  ->setCellValue('B'.$rec,$row["NAMA_BBPOM"])
															  ->setCellValue('C'.$rec,$row["RUTINMS"])
															  ->setCellValue('D'.$rec,$row["RUTINTMS"])
															  ->setCellValue('E'.$rec,$row["RUTINTMBB"])
															  ->setCellValue('F'.$rec,$row["RUTINTTP"])
															  ->setCellValue('G'.$rec,$row["JARINGANMS"])
															  ->setCellValue('H'.$rec,$row["JARINGANTMS"])
															  ->setCellValue('I'.$rec,$row["JARINGANTMBB"])
															  ->setCellValue('J'.$rec,$row["JARINGANTTP"])
															  ->setCellValue('K'.$rec,$row["KASUSMS"])
															  ->setCellValue('L'.$rec,$row["KASUSTMS"])
															  ->setCellValue('M'.$rec,$row["KASUSTMBB"])
															  ->setCellValue('N'.$rec,$row["KASUSTTP"]);
					$this->newphpexcel->set_detilstyle(array('A'.$rec,'B'.$rec,'C'.$rec,'D'.$rec,'E'.$rec,'F'.$rec,'G'.$rec,'H'.$rec,'I'.$rec,'J'.$rec,'K'.$rec,'L'.$rec,'M'.$rec,'N'.$rec));
					$rec++;
					$no++;
				}
				$total = $rec - 1;
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A'.$rec,'')
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
					->setCellValue('N'.$rec,'=SUM(N8:N'.$total.')');
					$this->newphpexcel->set_detilstyle(array('A'.$rec,'B'.$rec,'C'.$rec,'D'.$rec,'E'.$rec,'F'.$rec,'G'.$rec,'H'.$rec,'I'.$rec,'J'.$rec,'K'.$rec,'L'.$rec,'M'.$rec,'N'.$rec));
			}else{
				$this->newphpexcel->getActiveSheet()->mergeCells('A9:N9');
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A9','Data Tidak Ditemukan');
				$this->newphpexcel->set_detilstyle(array('A9','B9','C9','D9','E9','F9','G9','H9','I9','J9','K9','L9','M9','N9'));
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
	
	function rekap_02BB(){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$this->load->library('newphpexcel');
			$judul = $sipt->main->get_judul($this->input->post("JENIS"));
			
			$query = "SELECT DISTINCT(REPLACE(REPLACE(C.NAMA_BBPOM,'BALAI BESAR POM DI ', ''),'BALAI POM DI ','')) AS NAMA_BBPOM,
					  SUM(CASE WHEN RTRIM(LTRIM(A.HASIL)) = 'MK' AND RTRIM(LTRIM(B.TUJUAN_PEMERIKSAAN)) = 'Rutin' THEN 1 ELSE 0 END) AS RUTINMS,
					  SUM(CASE WHEN RTRIM(LTRIM(A.HASIL)) = 'TMK' AND RTRIM(LTRIM(B.TUJUAN_PEMERIKSAAN)) = 'Rutin' THEN 1 ELSE 0 END) AS RUTINTMS,
					  SUM(CASE WHEN RTRIM(LTRIM(A.HASIL)) = 'TMBB' AND RTRIM(LTRIM(B.TUJUAN_PEMERIKSAAN)) = 'Rutin' THEN 1 ELSE 0 END) AS RUTINTMBB,
					  SUM(CASE WHEN RTRIM(LTRIM(A.HASIL)) = 'TTP' AND RTRIM(LTRIM(B.TUJUAN_PEMERIKSAAN)) = 'Rutin' THEN 1 ELSE 0 END) AS RUTINTTP,
					  SUM(CASE WHEN RTRIM(LTRIM(A.HASIL)) = 'MK' AND RTRIM(LTRIM(B.TUJUAN_PEMERIKSAAN)) = 'Penelusuran Jaringan' THEN 1 ELSE 0 END) AS JARINGANMS,
					  SUM(CASE WHEN RTRIM(LTRIM(A.HASIL)) = 'TMK' AND RTRIM(LTRIM(B.TUJUAN_PEMERIKSAAN)) = 'Penelusuran Jaringan' THEN 1 ELSE 0 END) AS JARINGANTMS,
					  SUM(CASE WHEN RTRIM(LTRIM(A.HASIL)) = 'TMBB' AND RTRIM(LTRIM(B.TUJUAN_PEMERIKSAAN)) = 'Penelusuran Jaringan' THEN 1 ELSE 0 END) AS JARINGANTMBB,
					  SUM(CASE WHEN RTRIM(LTRIM(A.HASIL)) = 'TTP' AND RTRIM(LTRIM(B.TUJUAN_PEMERIKSAAN)) = 'Penelusuran Jaringan' THEN 1 ELSE 0 END) AS JARINGANTTP,
					  SUM(CASE WHEN RTRIM(LTRIM(A.HASIL)) = 'MK' AND RTRIM(LTRIM(B.TUJUAN_PEMERIKSAAN)) = 'Kasus' THEN 1 ELSE 0 END) AS KASUSMS,
					  SUM(CASE WHEN RTRIM(LTRIM(A.HASIL)) = 'TMK' AND RTRIM(LTRIM(B.TUJUAN_PEMERIKSAAN)) = 'Kasus' THEN 1 ELSE 0 END) AS KASUSTMS,
					  SUM(CASE WHEN RTRIM(LTRIM(A.HASIL)) = 'TMBB' AND RTRIM(LTRIM(B.TUJUAN_PEMERIKSAAN)) = 'Kasus' THEN 1 ELSE 0 END) AS KASUSTMBB,
					  SUM(CASE WHEN RTRIM(LTRIM(A.HASIL)) = 'TTP' AND RTRIM(LTRIM(B.TUJUAN_PEMERIKSAAN)) = 'Kasus' THEN 1 ELSE 0 END) AS KASUSTTP
					  FROM T_PEMERIKSAAN A LEFT JOIN T_PEMERIKSAAN_BB B ON A.PERIKSA_ID = B.PERIKSA_ID
					  LEFT JOIN M_BBPOM C ON A.BBPOM_ID = C.BBPOM_ID
					  WHERE A.JENIS_SARANA_ID = '02BB'";
			if(trim($this->input->post('AWAL')!="")){
				$query .= " AND DATEDIFF(dy, 0, convert(DATETIME, A.AWAL_PERIKSA, 105)) >= DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('AWAL')."', 105))";
				$awal = $this->input->post('AWAL');
			}else{
				$query .= " AND A.AWAL_PERIKSA > DATEADD(M, DATEDIFF(M,0,GETDATE()),0)";
				$awal = date('01/m/Y');
			}
			if(trim($this->input->post('AKHIR')!="")){
				$query .= " AND DATEDIFF(dy, 0, convert(DATETIME, A.AWAL_PERIKSA, 105)) <= DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('AKHIR')."', 105))";
				$akhir = $this->input->post('AKHIR');
			}else{
				$query .= " AND A.AWAL_PERIKSA < DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,0,GETDATE())+1,0))";
				$akhir = date('t/m/Y');
			}
			
			if($this->newsession->userdata('SESS_BBPOM_ID') != "96" && $this->newsession->userdata('SESS_BBPOM_ID') != "00"){
				$query .= " AND A.BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'";
				$balai = $sipt->main->get_uraian("SELECT NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","NAMA_BBPOM");
			}else{
				if(trim($this->input->post('BBPOM_ID')) == ""){
					$query .= "";
					$balai = "Seluruh Balai";
				}else{
					$query .= " AND A.BBPOM_ID = '".$this->input->post('BBPOM_ID')."'";
					$balai = $sipt->main->get_uraian("SELECT NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID = '".$this->input->post('BBPOM_ID')."'","NAMA_BBPOM");
				}
			}
			$query .= "AND LEN(A.STATUS) > 2 GROUP BY C.BBPOM_ID, C.NAMA_BBPOM ORDER BY 1";
			
			$this->newphpexcel->getDefaultStyle()->getFont()->setName('Calibri')->setSize(10);
			$this->newphpexcel->setActiveSheetIndex(0);
			$this->newphpexcel->mergecell(array(array('A1','N1'),array('A2','B2'),array('A3','B3'),array('A4','B4'),array('A5','B5'),array('C3','N3'),array('C4','N4'),array('C5','N5')), FALSE);
			$this->newphpexcel->mergecell(array(array('A6','A8'),array('B6','B8'),array('C6','N6'),array('C7','F7'),array('G7','J7'),array('K7','N7')), TRUE);
			
			
			$this->newphpexcel->width(array(array('A',5),array('B',30),array('C',5),array('D',5),array('E',7),array('F',8),array('G',5),array('H',5),array('I',7),array('J',8),array('K',5), array('L',5),array('M',7),array('N',8)));
			$this->newphpexcel->set_bold(array('A1','C2','C5'));
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A1', 'REKAP JENIS PEMERIKSAAN YANG DILAKUKAN')->setCellValue('A2', 'Jenis Sarana')->setCellValue('C2', $judul)->setCellValue('A3', 'Pemeriksaan Awal')->setCellValue('C3', $awal)->setCellValue('A4', 'Pemeriksaan Akhir')->setCellValue('C4', $akhir)->setCellValue('A5', 'Balai Besar / Balai POM')->setCellValue('C5', $balai);
			
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A6','No.')->setCellValue('B6','BBPOM / BPOM')->setCellValue('C6','Hasil Pemeriksaan')->setCellValue('C7','Rutin')->setCellValue('G7','Penelusuran Jaringan')->setCellValue('K7','Kasus')->setCellValue('C8','MS')->setCellValue('D8','TMS')->setCellValue('E8','TMBB')->setCellValue('F8','TUTUP')->setCellValue('G8','MS')->setCellValue('H8','TMS')->setCellValue('I8','TMBB')->setCellValue('J8','TUTUP')->setCellValue('K8','MS')->setCellValue('L8','TMS')->setCellValue('M8','TMBB')->setCellValue('N8','TUTUP');
			
			$this->newphpexcel->headings(array('A6','B6','C6','D6','E6','F6','G6','H6','I6','J6','K6','L6','M6','N6','A7','B7','C7','D7','E7','F7','G7','H7','I7','J7','K7','L7','M7','N7','A8','B8','C8','D8','E8','F8','G8','H8','I8','J8','K8','L8','M8','N8'));
			$this->newphpexcel->set_wrap(array('B','C','D','E','H','I','J','K','L','M','N'));
			
			
			$data = $sipt->main->get_result($query);	
			if($data){
				$no=1;
				$rec = 9;
				foreach($query->result_array() as $row){
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A'.$rec,$no)
															  ->setCellValue('B'.$rec,$row["NAMA_BBPOM"])
															  ->setCellValue('C'.$rec,$row["RUTINMS"])
															  ->setCellValue('D'.$rec,$row["RUTINTMS"])
															  ->setCellValue('E'.$rec,$row["RUTINTMBB"])
															  ->setCellValue('F'.$rec,$row["RUTINTTP"])
															  ->setCellValue('G'.$rec,$row["JARINGANMS"])
															  ->setCellValue('H'.$rec,$row["JARINGANTMS"])
															  ->setCellValue('I'.$rec,$row["JARINGANTMBB"])
															  ->setCellValue('J'.$rec,$row["JARINGANTTP"])
															  ->setCellValue('K'.$rec,$row["KASUSMS"])
															  ->setCellValue('L'.$rec,$row["KASUSTMS"])
															  ->setCellValue('M'.$rec,$row["KASUSTMBB"])
															  ->setCellValue('N'.$rec,$row["KASUSTTP"]);
					$this->newphpexcel->set_detilstyle(array('A'.$rec,'B'.$rec,'C'.$rec,'D'.$rec,'E'.$rec,'F'.$rec,'G'.$rec,'H'.$rec,'I'.$rec,'J'.$rec,'K'.$rec,'L'.$rec,'M'.$rec,'N'.$rec));
					$rec++;
					$no++;
				}
				$total = $rec - 1;
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A'.$rec,'')
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
					->setCellValue('N'.$rec,'=SUM(N8:N'.$total.')');
					$this->newphpexcel->set_detilstyle(array('A'.$rec,'B'.$rec,'C'.$rec,'D'.$rec,'E'.$rec,'F'.$rec,'G'.$rec,'H'.$rec,'I'.$rec,'J'.$rec,'K'.$rec,'L'.$rec,'M'.$rec,'N'.$rec));
			}else{
				$this->newphpexcel->getActiveSheet()->mergeCells('A9:N9');
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A9','Data Tidak Ditemukan');
				$this->newphpexcel->set_detilstyle(array('A9','B9','C9','D9','E9','F9','G9','H9','I9','J9','K9','L9','M9','N9'));
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
	
}
?>