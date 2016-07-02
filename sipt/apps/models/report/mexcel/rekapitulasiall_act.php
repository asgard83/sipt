<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);
class Rekapitulasiall_act extends Model{
	function get_all(){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$this->load->library('newphpexcel');
			$this->newphpexcel->set_font('Calibri',10);
			$filter = "";
			if(trim($this->input->post('AWAL')!="")){
				$filter .= " AND DATEDIFF(dy, 0, convert(DATETIME, A.AWAL_PERIKSA, 105)) >= DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('AWAL')."', 105))";
				$awal = $this->input->post('AWAL');
			}else{
				$filter .= " AND A.AWAL_PERIKSA > GETDATE()";
				$awal = date('01/m/Y');
			}
			if(trim($this->input->post('AKHIR')!="")){
				$filter .= " AND DATEDIFF(dy, 0, convert(DATETIME, A.AWAL_PERIKSA, 105)) <= DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('AKHIR')."', 105))";
				$akhir = $this->input->post('AKHIR');
			}else{
				$filter .= " AND A.AKHIR_PERIKSA < GETDATE()";
				$akhir = date('t/m/Y');
			}
			if(in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')) || $this->newsession->userdata('SESS_BBPOM_ID') == "00"){
				if(trim($this->input->post('BBPOM_ID'))==""){
					$filter .= "";
					$balai = 'Seluruh Balai';
					$bbpom = "A.BBPOM_ID";
				}else{
					$filter .= " AND A.BBPOM_ID = '".$this->input->post('BBPOM_ID')."'";
					$balai = $sipt->main->get_uraian("SELECT NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID = '".$this->input->post('BBPOM_ID')."'","NAMA_BBPOM");		
					$bbpom = $this->input->post('BBPOM_ID');
				}
			}else{
				$filter .= " AND A.BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'";
				$bbpom = $this->newsession->userdata('SESS_BBPOM_ID');
				$balai = $sipt->main->get_uraian("SELECT NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","NAMA_BBPOM");		
			}				

			if(in_array('01',$this->newsession->userdata('SESS_SUB_SARANA'))){# Sheet Satu
				$query = "SELECT * FROM(SELECT REPLACE(REPLACE(C.NAMA_BBPOM,'BALAI BESAR POM DI ', ''),'BALAI POM DI ','') AS NAMA_BBPOM,
						  CASE
							  WHEN B.JENIS_SARANA_ID = '01OO' AND A.HASIL = 'MK' THEN '01PMK'
							  WHEN B.JENIS_SARANA_ID = '01OO' AND A.HASIL = 'Minor' THEN '01PMN'
							  WHEN B.JENIS_SARANA_ID = '01OO' AND A.HASIL = 'Major' THEN '01PMJ'
							  WHEN B.JENIS_SARANA_ID = '01OO' AND A.HASIL = 'Kritikal' THEN '01PKR'
							  WHEN B.JENIS_SARANA_ID = '01OO' AND A.HASIL = '' OR A.HASIL IS NULL THEN '01PNULL' 
							  WHEN B.JENIS_SARANA_ID = '01ON' AND A.HASIL = 'MK' THEN '01NMK'
							  WHEN B.JENIS_SARANA_ID = '01ON' AND A.HASIL = 'Minor' THEN '01NMN'
							  WHEN B.JENIS_SARANA_ID = '01ON' AND A.HASIL = 'Major' THEN '01NMJ'
							  WHEN B.JENIS_SARANA_ID = '01ON' AND A.HASIL = 'Kritikal' THEN '01NKR'
							  WHEN B.JENIS_SARANA_ID = '01ON' AND A.HASIL = '' OR A.HASIL IS NULL THEN '01NNULL' 
							  WHEN B.JENIS_SARANA_ID = '01HH' AND A.HASIL = 'MK' THEN '02MKOT'
							  WHEN B.JENIS_SARANA_ID = '01HH' AND A.HASIL = 'TMK' THEN '02TMKOT'
							  WHEN B.JENIS_SARANA_ID = '01HH' AND A.HASIL = 'TTP' THEN '02TTPOT'
							  WHEN B.JENIS_SARANA_ID = '01KO' AND A.HASIL = 'MK' THEN '02MKKOS'
							  WHEN B.JENIS_SARANA_ID = '01KO' AND A.HASIL = 'TMK' THEN '02TMKKOS'
							  WHEN B.JENIS_SARANA_ID = '01KO' AND A.HASIL = 'TTP' THEN '02TTPKOS'
							  WHEN B.JENIS_SARANA_ID = '01PK' AND A.HASIL = 'MK' THEN '02MKSM'
							  WHEN B.JENIS_SARANA_ID = '01PK' AND A.HASIL = 'TMK' THEN '02TMKSM'
							  WHEN B.JENIS_SARANA_ID = '01PK' AND A.HASIL = 'TTP' THEN '02TTSM'
							  WHEN B.JENIS_SARANA_ID = '01JJ' AND A.HASIL = 'A' THEN '03A'
							  WHEN B.JENIS_SARANA_ID = '01JJ' AND A.HASIL = 'B' THEN '03B'
							  WHEN B.JENIS_SARANA_ID = '01JJ' AND A.HASIL = 'C' THEN '03C'
							  WHEN B.JENIS_SARANA_ID = '01JJ' AND A.HASIL = 'D' THEN '03D'
							  WHEN B.JENIS_SARANA_ID = '01JJ' AND A.HASIL = 'TTP' THEN '03TTP'
							  WHEN B.JENIS_SARANA_ID = '01JJ' AND A.HASIL = 'TDP' THEN '03X'
							  WHEN B.JENIS_SARANA_ID = '01VV' AND A.HASIL = 'BAIK' THEN '03BAIK'
							  WHEN B.JENIS_SARANA_ID = '01VV' AND A.HASIL = 'CUKUP' THEN '03CUKUP'
							  WHEN B.JENIS_SARANA_ID = '01VV' AND A.HASIL = 'KURANG' THEN '03KURANG'
						  END AS HASIL
						  FROM T_PEMERIKSAAN A LEFT JOIN M_JENIS_SARANA B 
						  ON A.JENIS_SARANA_ID = B.JENIS_SARANA_ID 
						  LEFT JOIN M_BBPOM C ON A.BBPOM_ID = C.BBPOM_ID
						  WHERE LEFT(A.JENIS_SARANA_ID, 2) = '01' AND LEN(A.STATUS) > 2 $filter)DT PIVOT(COUNT(HASIL) 
						  FOR HASIL IN ([01PMK],[01PMN],[01PMJ],[01PKR],[01PNULL],
						  [01NMK],[01NMN],[01NMJ],[01NKR],[01NNULL],
						  [02MKOT],[02TMKOT],[02TTPOT],[02MKKOS],[02TMKKOS],[02TTPKOS],[02MKSM],[02TMKSM],[02TTPSM],
						  [03BAIK],[03CUKUP],[03KURANG],[03A],[03B],[03C],[03D],[03X],[03TTP])) PVT ORDER BY PVT.NAMA_BBPOM ASC";
				$this->newphpexcel->setActiveSheetIndex(0);
				$this->newphpexcel->set_title('Sarana Produksi');
				$this->newphpexcel->mergecell(array(array('A1','AD1'),array('A2','AD2'),array('A3','AD3'),array('A4','AD4'),array('C7','AD7'),array('C8','G8'),array('H8','L8'),array('M8','O8'),array('P8','R8'),array('S8','U8'),array('V8','AA8'),array('AB8','AD8')), TRUE);
				$this->newphpexcel->mergecell(array(array('A6','AC6'),array('A7','A9'),array('B7','B9')), FALSE);
				$this->newphpexcel->width(array(array('A',4), array('B',25)));
				$this->newphpexcel->set_bold(array('A1','A2','A3','A4','A6'));
				
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A1', 'REKAPITULASI HASIL PELAKSANAAN KEGIATAN')->setCellValue('A2', 'BALAI BESAR / BALAI POM')->setCellValue('A3', strtoupper($balai))->setCellValue('A4', 'PERIODE : '.$awal.' s.d '.$akhir)->setCellValue('A6', 'PEMERIKSAAN SARANA PRODUKSI');
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A7','No.')->setCellValue('B7','BB / BPOM')->setCellValue('C7','Jumlah Dalam Hasil')->setCellValue('C8','Produksi Obat')->setCellValue('H8','Produksi Pengawasan Napza')->setCellValue('M8','Produksi Obat Tradisional')->setCellValue('P8','Produksi Kosmetik')->setCellValue('S8','Produksi Suplemen Makanan')->setCellValue('V8','Produksi Pangan MD')->setCellValue('AB8','Produksi Pangan P-IRT')->setCellValue('C9','MK')->setCellValue('D9','Minor')->setCellValue('E9','Major')->setCellValue('F9','Kritikal')->setCellValue('G9','Tidak Ada Hasil')->setCellValue('H9','MK')->setCellValue('I9','Minor')->setCellValue('J9','Major')->setCellValue('K9','Kritikal')->setCellValue('L9','Tidak Ada Hasil')->setCellValue('M9','MK')->setCellValue('N9','TMK')->setCellValue('O9','TTP')->setCellValue('P9','MK')->setCellValue('Q9','TMK')->setCellValue('R9','TTP')->setCellValue('S9','MK')->setCellValue('T9','TMK')->setCellValue('U9','TTP')->setCellValue('V9','A (Baik Sekali)')->setCellValue('W9','B (Baik)')->setCellValue('X9','C (Cukup)')->setCellValue('Y9','D (Jelek)')->setCellValue('Z9','Tutup')->setCellValue('AA9','Tidak Dapat Diperiksa')->setCellValue('AB9','BAIK')->setCellValue('AC9','CUKUP')->setCellValue('AD9','KURANG');
				$this->newphpexcel->headings(array('A7','A8','A9','B7','C7','D7','E7','F7','G7','H7','I7','J7','K7','L7','M7','N7','O7','P7','Q7','R7','S7','T7','U7','V7','W7','X7','Y7','Z7','AA7','AB7','AC7','AD7','C8','D8','E8','F8','G8','H8','I8','J8','K8','L8','M8','N8','O8','P8','Q8','R8','S8','T8','U8','V8','W8','X8','Y8','Z8','AA8','AB8','AC8','AD8','C9','D9','E9','F9','G9','H9','I9','J9','K9','L9','M9','N9','O9','P9','Q9','R9','S9','T9','U9','V9','W9','X9','Y9','Z9','AA9','AB9','AC9','AD9'));
				$data = $sipt->main->get_result($query);
				if($data){
					$no=1;
					$rec = 10;
					foreach($query->result_array() as $row){
						$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A'.$rec,$no)->setCellValue('B'.$rec,strtoupper($row["NAMA_BBPOM"]))->setCellValue('C'.$rec,$row["01PMK"])->setCellValue('D'.$rec,$row["01PMN"])->setCellValue('E'.$rec,$row["01PMJ"])->setCellValue('F'.$rec,$row["01PKR"])->setCellValue('G'.$rec,$row["01PNULL"])->setCellValue('H'.$rec,$row["01NMK"])->setCellValue('I'.$rec,$row["01NMN"])->setCellValue('J'.$rec,$row["01NMJ"])->setCellValue('K'.$rec,$row["01NKR"])->setCellValue('L'.$rec,$row["01NNULL"])->setCellValue('M'.$rec,$row["02MKOT"])->setCellValue('N'.$rec,$row["02TMKOT"])->setCellValue('O'.$rec,$row["02TTPOT"])->setCellValue('P'.$rec,$row["02MKKOS"])->setCellValue('Q'.$rec,$row["02TMKKOS"])->setCellValue('R'.$rec,$row["02TTPKOS"])->setCellValue('S'.$rec,$row["02MKSM"])->setCellValue('T'.$rec,$row["02TMKSM"])->setCellValue('U'.$rec,$row["02TTPSM"])->setCellValue('V'.$rec,$row["03A"])->setCellValue('W'.$rec,$row["03B"])->setCellValue('X'.$rec,$row["03C"])->setCellValue('Y'.$rec,$row["03D"])->setCellValue('Z'.$rec,$row["03TTP"])->setCellValue('AA'.$rec,$row["03X"])->setCellValue('AB'.$rec,$row["03BAIK"])->setCellValue('AC'.$rec,$row["03CUKUP"])->setCellValue('AD'.$rec,$row["03KURANG"]);
						$this->newphpexcel->set_detilstyle(array('A'.$rec,'B'.$rec,'C'.$rec,'D'.$rec,'E'.$rec,'F'.$rec,'G'.$rec,'H'.$rec,'I'.$rec,'J'.$rec,'K'.$rec,'L'.$rec,'M'.$rec,'N'.$rec,'O'.$rec,'P'.$rec,'Q'.$rec,'R'.$rec,'S'.$rec,'T'.$rec,'U'.$rec,'V'.$rec,'W'.$rec,'X'.$rec,'Y'.$rec,'Z'.$rec,'AA'.$rec,'AB'.$rec,'AC'.$rec,'AD'.$rec));
						$rec++;
						$no++;
					}
					$total = $rec - 1;
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A'.$rec,'')
					->setCellValue('B'.$rec,'Jumlah')
					->setCellValue('C'.$rec,'=SUM(C10:C'.$total.')')
					->setCellValue('D'.$rec,'=SUM(D10:D'.$total.')')
					->setCellValue('E'.$rec,'=SUM(E10:E'.$total.')')
					->setCellValue('F'.$rec,'=SUM(F10:F'.$total.')')
					->setCellValue('G'.$rec,'=SUM(G10:G'.$total.')')
					->setCellValue('H'.$rec,'=SUM(H10:H'.$total.')')
					->setCellValue('I'.$rec,'=SUM(I10:I'.$total.')')
					->setCellValue('J'.$rec,'=SUM(J10:J'.$total.')')
					->setCellValue('K'.$rec,'=SUM(K10:K'.$total.')')
					->setCellValue('L'.$rec,'=SUM(L10:L'.$total.')')
					->setCellValue('M'.$rec,'=SUM(M10:M'.$total.')')
					->setCellValue('N'.$rec,'=SUM(N10:N'.$total.')')
					->setCellValue('O'.$rec,'=SUM(O10:O'.$total.')')
					->setCellValue('P'.$rec,'=SUM(P10:P'.$total.')')
					->setCellValue('Q'.$rec,'=SUM(Q10:Q'.$total.')')
					->setCellValue('R'.$rec,'=SUM(R10:R'.$total.')')
					->setCellValue('S'.$rec,'=SUM(S10:S'.$total.')')
					->setCellValue('T'.$rec,'=SUM(T10:T'.$total.')')
					->setCellValue('U'.$rec,'=SUM(U10:U'.$total.')')
					->setCellValue('V'.$rec,'=SUM(V10:V'.$total.')')
					->setCellValue('W'.$rec,'=SUM(W10:W'.$total.')')
					->setCellValue('X'.$rec,'=SUM(X10:X'.$total.')')
					->setCellValue('Y'.$rec,'=SUM(Y10:Y'.$total.')')
					->setCellValue('Z'.$rec,'=SUM(Z10:Z'.$total.')')
					->setCellValue('AA'.$rec,'=SUM(AA10:AA'.$total.')')
					->setCellValue('AB'.$rec,'=SUM(AB10:AB'.$total.')')
					->setCellValue('AC'.$rec,'=SUM(AC10:AC'.$total.')')
					->setCellValue('AD'.$rec,'=SUM(AD10:AD'.$total.')');
					$this->newphpexcel->set_detilstyle(array('A'.$rec,'B'.$rec,'C'.$rec,'D'.$rec,'E'.$rec,'F'.$rec,'G'.$rec,'H'.$rec,'I'.$rec,'J'.$rec,'K'.$rec,'L'.$rec,'M'.$rec,'N'.$rec,'O'.$rec,'P'.$rec,'Q'.$rec,'R'.$rec,'S'.$rec,'T'.$rec,'U'.$rec,'V'.$rec,'W'.$rec,'X'.$rec,'Y'.$rec,'Z'.$rec,'AA'.$rec,'AB'.$rec,'AC'.$rec,'AD'.$rec));
				}else{
					$this->newphpexcel->getActiveSheet()->mergeCells('A10:AD10');
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A10','Data Tidak Ditemukan');
					$this->newphpexcel->set_detilstyle(array('A10'));
				}
			}
			
			if(in_array('02',$this->newsession->userdata('SESS_SUB_SARANA'))){#Sheet Dua
				$query = "SELECT * FROM(SELECT REPLACE(REPLACE(C.NAMA_BBPOM,'BALAI BESAR POM DI ', ''),'BALAI POM DI ','') AS NAMA_BBPOM,
						  CASE
							  WHEN B.JENIS_SARANA_ID = '02LL' AND A.HASIL = 'MK' THEN '01PBBBFMK'
							  WHEN B.JENIS_SARANA_ID = '02LL' AND A.HASIL = 'TMK' THEN '01PBBBFTMK'
							  WHEN B.JENIS_SARANA_ID = '02LL' AND A.HASIL = 'TTP' THEN '01PBBBFTTP'
							  WHEN B.JENIS_SARANA_ID = '02LL' AND A.HASIL = 'TDP' THEN '01PBBBFTDP'
							  WHEN B.JENIS_SARANA_ID = '02MM' AND A.HASIL = 'MK' THEN '01PBFMK'
							  WHEN B.JENIS_SARANA_ID = '02MM' AND A.HASIL = 'TMK' THEN '01PBFTMK'
							  WHEN B.JENIS_SARANA_ID = '02MM' AND A.HASIL = 'TTP' THEN '01PBFTTP'
							  WHEN B.JENIS_SARANA_ID = '02MM' AND A.HASIL = 'TDP' THEN '01PBFTDP'
							  WHEN B.JENIS_SARANA_ID = '02TF' AND A.HASIL = 'MK' THEN '01GFKMK'
							  WHEN B.JENIS_SARANA_ID = '02TF' AND A.HASIL = 'TMK' THEN '01GFKTMK'
							  WHEN B.JENIS_SARANA_ID = '02TF' AND A.HASIL = 'TTP' THEN '01GFKTTP'
							  WHEN B.JENIS_SARANA_ID = '02TF' AND A.HASIL = 'TDP' THEN '01GFKTDP'
							  WHEN B.JENIS_SARANA_ID = '02MN' AND A.HASIL = 'MK' THEN '01PBFNMK'
							  WHEN B.JENIS_SARANA_ID = '02MN' AND A.HASIL = 'Minor' THEN '01PBFMN'
							  WHEN B.JENIS_SARANA_ID = '02MN' AND A.HASIL = 'Major' THEN '01PBFNMJ'
							  WHEN B.JENIS_SARANA_ID = '02MN' AND A.HASIL = 'Kritikal' THEN '01PBFNKR'
							  WHEN B.JENIS_SARANA_ID = '02MN' AND A.HASIL = '' OR A.HASIL IS NULL THEN '01PBFNNULL' 
							  WHEN B.JENIS_SARANA_ID = '02TN' AND A.HASIL = 'MK' THEN '01GFKNMK'
							  WHEN B.JENIS_SARANA_ID = '02TN' AND A.HASIL = 'Minor' THEN '01GFKNMN'
							  WHEN B.JENIS_SARANA_ID = '02TN' AND A.HASIL = 'Major' THEN '01GFKNMJ'
							  WHEN B.JENIS_SARANA_ID = '02TN' AND A.HASIL = 'Kritikal' THEN '01GFKNKR'
							  WHEN B.JENIS_SARANA_ID = '02TN' AND A.HASIL = '' OR A.HASIL IS NULL THEN '01GFKNNULL' 
							  WHEN B.JENIS_SARANA_ID = '02OT' AND A.HASIL = 'MK' THEN '02MKOT'
							  WHEN B.JENIS_SARANA_ID = '02OT' AND A.HASIL = 'TMK' THEN '02TMKOT'
							  WHEN B.JENIS_SARANA_ID = '02KO' AND A.HASIL = 'MK' THEN '02MKKOS'
							  WHEN B.JENIS_SARANA_ID = '02KO' AND A.HASIL = 'TMK' THEN '02TMKKOS'
							  WHEN B.JENIS_SARANA_ID = '02PK' AND A.HASIL = 'MK' THEN '02MKSM'
							  WHEN B.JENIS_SARANA_ID = '02PK' AND A.HASIL = 'TMK' THEN '02TMKSM'
							  WHEN B.JENIS_SARANA_ID = '02PG' AND A.HASIL = 'BAIK' THEN '03BAIK'
							  WHEN B.JENIS_SARANA_ID = '02PG' AND A.HASIL = 'CUKUP' THEN '03CUKUP'
							  WHEN B.JENIS_SARANA_ID = '02PG' AND A.HASIL = 'KURANG' THEN '03KURANG'
							  WHEN B.JENIS_SARANA_ID = '02PG' AND A.HASIL = '' OR A.HASIL IS NULL THEN '03NULL'
							  WHEN B.JENIS_SARANA_ID = '02PR' AND A.HASIL = 'MK' THEN '03MKPR'
							  WHEN B.JENIS_SARANA_ID = '02PR' AND A.HASIL = 'TMK' THEN '03TMKPR'
						  END AS HASIL
						  FROM T_PEMERIKSAAN A LEFT JOIN M_JENIS_SARANA B 
						  ON A.JENIS_SARANA_ID = B.JENIS_SARANA_ID 
						  LEFT JOIN M_BBPOM C ON A.BBPOM_ID = C.BBPOM_ID
						  WHERE LEFT(A.JENIS_SARANA_ID, 2) = '02' AND LEN(A.STATUS) > 2 $filter)DT PIVOT(COUNT(HASIL) 
						  FOR HASIL IN ([01PBBBFMK],[01PBBBFTMK],[01PBBBFTTP],[01PBBBFTDP],[01PBFMK],[01PBFTMK],[01PBFTTP],[01PBFTDP],[01GFKMK],[01GFKTMK],[01GFKTTP],[01GFKTDP],[01PBFNMK],[01PBFMN],[01PBFNMJ],[01PBFNKR],[01PBFNNULL],[01GFKNMK],[01GFKNMN],[01GFKNMJ],[01GFKNKR],[01GFKNNULL],[02MKOT],[02TMKOT],[02MKKOS],[02TMKKOS],[02MKSM],[02TMKSM],[03BAIK],[03CUKUP],[03KURANG],[03NULL],[03MKPR],[03TMKPR])) PVT ORDER BY PVT.NAMA_BBPOM ASC";
				$this->newphpexcel->createSheet();
				$this->newphpexcel->setActiveSheetIndex(1);
				$this->newphpexcel->set_title('Sarana Distribusi');
				$this->newphpexcel->mergecell(array(array('A1','AI1'),array('A2','AI2'),array('A3','AI3'),array('A4','AI4'),array('C7','AI7'),array('C8','F8'),array('G8','J8'),array('K8','N8'),array('O8','S8'),array('T8','X8'),array('Y8','Z8'),array('AA8','AB8'),array('AC8','AD8'),array('AE8','AG8'),array('AH8','AI8')), TRUE);
				$this->newphpexcel->mergecell(array(array('A6','AC6'),array('A7','A9'),array('B7','B9')), FALSE);
				$this->newphpexcel->width(array(array('A',4), array('B',25)));
				$this->newphpexcel->set_bold(array('A1','A2','A3','A4','A6'));
				
				$this->newphpexcel->setActiveSheetIndex(1)->setCellValue('A1', 'REKAPITULASI HASIL PELAKSANAAN KEGIATAN')->setCellValue('A2', 'BALAI BESAR / BALAI POM')->setCellValue('A3', strtoupper($balai))->setCellValue('A4', 'PERIODE : '.$awal.' s.d '.$akhir)->setCellValue('A6', 'PEMERIKSAAN SARANA DISTRIBUSI');
				$this->newphpexcel->setActiveSheetIndex(1)->setCellValue('A7','No.')->setCellValue('B7','BB / BPOM')->setCellValue('C7','Jumlah Dalam Hasil')->setCellValue('C8','Distribusi Obat PBBBF')->setCellValue('G8','Distribusi Obat PBF')->setCellValue('K8','Distribusi Obat GFK')->setCellValue('O8','PBF Pengawasan Napza')->setCellValue('T8','GFK Pengawasan Napza')->setCellValue('Y8','Obat Tradisional')->setCellValue('AA8','Kosmetika')->setCellValue('AC8','Suplemen Makanan')->setCellValue('AE8','Distribusi Pangan')->setCellValue('AH8','Parcel')
				->setCellValue('C9','MK')->setCellValue('D9','TMK')->setCellValue('E9','TDP')->setCellValue('F9','TTP')->setCellValue('G9','MK')->setCellValue('H9','TMK')->setCellValue('I9','TTP')->setCellValue('J9','TDP')->setCellValue('K9','MK')->setCellValue('L9','TMK')->setCellValue('M9','TDP')->setCellValue('N9','TTP')->setCellValue('O9','MK')->setCellValue('P9','Minor')->setCellValue('Q9','Major')->setCellValue('R9','Kritikal')->setCellValue('S9','Tidak Ada Hasil')->setCellValue('T9','MK')->setCellValue('U9','Minor')->setCellValue('V9','Major')->setCellValue('W9','Kritikal')->setCellValue('X9','Tidak Ada Hasil')->setCellValue('Y9','MK')->setCellValue('Z9','TMK')->setCellValue('AA9','MK')->setCellValue('AB9','TMK')->setCellValue('AC9','MK')->setCellValue('AD9','TMK')->setCellValue('AE9','BAIK')->setCellValue('AF9','CUKUP')->setCellValue('AG9','KURANG')->setCellValue('AH9','MK')->setCellValue('AI9','TMK');				
				$this->newphpexcel->headings(array('A7','A8','A9','B7','C7','D7','E7','F7','G7','H7','I7','J7','K7','L7','M7','N7','O7','P7','Q7','R7','S7','T7','U7','V7','W7','X7','Y7','Z7','AA7','AB7','AC7','AD7','AE7','AF7','AG7','AH7','AI7','C8','D8','E8','F8','G8','H8','I8','J8','K8','L8','M8','N8','O8','P8','Q8','R8','S8','T8','U8','V8','W8','X8','Y8','Z8','AA8','AB8','AC8','AD8','AE8','AF8','AG8','AH8','AI8','C9','D9','E9','F9','G9','H9','I9','J9','K9','L9','M9','N9','O9','P9','Q9','R9','S9','T9','U9','V9','W9','X9','Y9','Z9','AA9','AB9','AC9','AD9','AE9','AF9','AG9','AH9','AI9'));
				$data = $sipt->main->get_result($query);
				if($data){
					$no=1;
					$rec = 10;
					foreach($query->result_array() as $row){
						$this->newphpexcel->setActiveSheetIndex(1)->setCellValue('A'.$rec,$no)->setCellValue('B'.$rec,strtoupper($row["NAMA_BBPOM"]))->setCellValue('C'.$rec,$row["01PBBBFMK"])->setCellValue('D'.$rec,$row["01PBBBFTMK"])->setCellValue('E'.$rec,$row["01PBBBFTTP"])->setCellValue('F'.$rec,$row["01PBBBFTDP"])->setCellValue('G'.$rec,$row["01PBFMK"])->setCellValue('H'.$rec,$row["01PBFTMK"])->setCellValue('I'.$rec,$row["01PBFTTP"])->setCellValue('J'.$rec,$row["01PBFTDP"])->setCellValue('K'.$rec,$row["01GFKMK"])->setCellValue('L'.$rec,$row["01GFKTMK"])->setCellValue('M'.$rec,$row["01GFKTTP"])->setCellValue('N'.$rec,$row["01GFKTDP"])->setCellValue('O'.$rec,$row["01PBFNMK"])->setCellValue('P'.$rec,$row["01PBFMN"])->setCellValue('Q'.$rec,$row["01PBFNMJ"])->setCellValue('R'.$rec,$row["01PBFNKR"])->setCellValue('S'.$rec,$row["01PBFNNULL"])->setCellValue('T'.$rec,$row["01GFKNMK"])->setCellValue('U'.$rec,$row["01GFKNMN"])->setCellValue('V'.$rec,$row["01GFKNMJ"])->setCellValue('W'.$rec,$row["01GFKNKR"])->setCellValue('X'.$rec,$row["01GFKNNULL"])->setCellValue('Y'.$rec,$row["02MKOT"])->setCellValue('Z'.$rec,$row["02TMKOT"])->setCellValue('AA'.$rec,$row["02MKKOS"])->setCellValue('AB'.$rec,$row["02TMKKOS"])->setCellValue('AC'.$rec,$row["02MKSM"])->setCellValue('AD'.$rec,$row["02TMKSM"])->setCellValue('AE'.$rec,$row["03BAIK"])->setCellValue('AF'.$rec,$row["03CUKUP"])->setCellValue('AG'.$rec,$row["03KURANG"])->setCellValue('AH'.$rec,$row["03MKPR"])->setCellValue('AI'.$rec,$row["03TMKPR"]);
						
						$this->newphpexcel->set_detilstyle(array('A'.$rec,'B'.$rec,'C'.$rec,'D'.$rec,'E'.$rec,'F'.$rec,'G'.$rec,'H'.$rec,'I'.$rec,'J'.$rec,'K'.$rec,'L'.$rec,'M'.$rec,'N'.$rec,'O'.$rec,'P'.$rec,'Q'.$rec,'R'.$rec,'S'.$rec,'T'.$rec,'U'.$rec,'V'.$rec,'W'.$rec,'X'.$rec,'Y'.$rec,'Z'.$rec,'AA'.$rec,'AB'.$rec,'AC'.$rec,'AD'.$rec,'AE'.$rec,'AF'.$rec,'AG'.$rec,'AH'.$rec,'AI'.$rec));
						$rec++;
						$no++;
					}
					$total = $rec - 1;
					$this->newphpexcel->setActiveSheetIndex(1)->setCellValue('A'.$rec,'')
					->setCellValue('B'.$rec,'Jumlah')
					->setCellValue('C'.$rec,'=SUM(C10:C'.$total.')')
					->setCellValue('D'.$rec,'=SUM(D10:D'.$total.')')
					->setCellValue('E'.$rec,'=SUM(E10:E'.$total.')')
					->setCellValue('F'.$rec,'=SUM(F10:F'.$total.')')
					->setCellValue('G'.$rec,'=SUM(G10:G'.$total.')')
					->setCellValue('H'.$rec,'=SUM(H10:H'.$total.')')
					->setCellValue('I'.$rec,'=SUM(I10:I'.$total.')')
					->setCellValue('J'.$rec,'=SUM(J10:J'.$total.')')
					->setCellValue('K'.$rec,'=SUM(K10:K'.$total.')')
					->setCellValue('L'.$rec,'=SUM(L10:L'.$total.')')
					->setCellValue('M'.$rec,'=SUM(M10:M'.$total.')')
					->setCellValue('N'.$rec,'=SUM(N10:N'.$total.')')
					->setCellValue('O'.$rec,'=SUM(O10:O'.$total.')')
					->setCellValue('P'.$rec,'=SUM(P10:P'.$total.')')
					->setCellValue('Q'.$rec,'=SUM(Q10:Q'.$total.')')
					->setCellValue('R'.$rec,'=SUM(R10:R'.$total.')')
					->setCellValue('S'.$rec,'=SUM(S10:S'.$total.')')
					->setCellValue('T'.$rec,'=SUM(T10:T'.$total.')')
					->setCellValue('U'.$rec,'=SUM(U10:U'.$total.')')
					->setCellValue('V'.$rec,'=SUM(V10:V'.$total.')')
					->setCellValue('W'.$rec,'=SUM(W10:W'.$total.')')
					->setCellValue('X'.$rec,'=SUM(X10:X'.$total.')')
					->setCellValue('Y'.$rec,'=SUM(Y10:Y'.$total.')')
					->setCellValue('Z'.$rec,'=SUM(Z10:Z'.$total.')')
					->setCellValue('AA'.$rec,'=SUM(AA10:AA'.$total.')')
					->setCellValue('AB'.$rec,'=SUM(AB10:AB'.$total.')')
					->setCellValue('AC'.$rec,'=SUM(AC10:AC'.$total.')')
					->setCellValue('AD'.$rec,'=SUM(AD10:AD'.$total.')')
					->setCellValue('AE'.$rec,'=SUM(AE10:AE'.$total.')')
					->setCellValue('AF'.$rec,'=SUM(AF10:AF'.$total.')')
					->setCellValue('AG'.$rec,'=SUM(AG10:AG'.$total.')')
					->setCellValue('AH'.$rec,'=SUM(AH10:AH'.$total.')')
					->setCellValue('AI'.$rec,'=SUM(AI10:AI'.$total.')');
					$this->newphpexcel->set_detilstyle(array('A'.$rec,'B'.$rec,'C'.$rec,'D'.$rec,'E'.$rec,'F'.$rec,'G'.$rec,'H'.$rec,'I'.$rec,'J'.$rec,'K'.$rec,'L'.$rec,'M'.$rec,'N'.$rec,'O'.$rec,'P'.$rec,'Q'.$rec,'R'.$rec,'S'.$rec,'T'.$rec,'U'.$rec,'V'.$rec,'W'.$rec,'X'.$rec,'Y'.$rec,'Z'.$rec,'AA'.$rec,'AB'.$rec,'AC'.$rec,'AD'.$rec,'AE'.$rec,'AF'.$rec,'AG'.$rec,'AH'.$rec,'AI'.$rec));
				}else{
					$this->newphpexcel->getActiveSheet()->mergeCells('A10:AH10');
					$this->newphpexcel->setActiveSheetIndex(1)->setCellValue('A10','Data Tidak Ditemukan');
					$this->newphpexcel->set_detilstyle(array('A10'));
				}
			}
			
			if(in_array('03',$this->newsession->userdata('SESS_SUB_SARANA'))){#Sheet Tiga
				$query = "SELECT * FROM(SELECT REPLACE(REPLACE(C.NAMA_BBPOM,'BALAI BESAR POM DI ', ''),'BALAI POM DI ','') AS NAMA_BBPOM,
						  CASE
							  WHEN B.JENIS_SARANA_ID = '03AA' AND A.HASIL = 'MK' THEN '01AAFMK'
							  WHEN B.JENIS_SARANA_ID = '03AA' AND A.HASIL = 'TMK' THEN '01AATMK'
							  WHEN B.JENIS_SARANA_ID = '03AA' AND A.HASIL = 'TTP' THEN '01AATTP'
							  WHEN B.JENIS_SARANA_ID = '03AA' AND A.HASIL = 'TDP' THEN '01AATDP'
							  WHEN B.JENIS_SARANA_ID = '03BB' AND A.HASIL = 'MK' THEN '01BBMK'
							  WHEN B.JENIS_SARANA_ID = '03BB' AND A.HASIL = 'TMK' THEN '01BBTMK'
							  WHEN B.JENIS_SARANA_ID = '03BB' AND A.HASIL = 'TTP' THEN '01BBTTP'
							  WHEN B.JENIS_SARANA_ID = '03BB' AND A.HASIL = 'TDP' THEN '01BBTDP'
							  WHEN B.JENIS_SARANA_ID = '03RS' AND A.HASIL = 'MK' THEN '01RSMK'
							  WHEN B.JENIS_SARANA_ID = '03RS' AND A.HASIL = 'TMK' THEN '01RSTMK'
							  WHEN B.JENIS_SARANA_ID = '03RS' AND A.HASIL = 'TTP' THEN '01RSTTP'
							  WHEN B.JENIS_SARANA_ID = '03RS' AND A.HASIL = 'TDP' THEN '01RSTDP'
							  WHEN B.JENIS_SARANA_ID = '03TR' AND A.HASIL = 'MK' THEN '01TRMK'
							  WHEN B.JENIS_SARANA_ID = '03TR' AND A.HASIL = 'TMK' THEN '01TRTMK'
							  WHEN B.JENIS_SARANA_ID = '03TR' AND A.HASIL = 'TTP' THEN '01TRTTP'
							  WHEN B.JENIS_SARANA_ID = '03TR' AND A.HASIL = 'TDP' THEN '01TRTDP'
							  WHEN B.JENIS_SARANA_ID = '03WW' AND A.HASIL = 'MK' THEN '01WWMK'
							  WHEN B.JENIS_SARANA_ID = '03WW' AND A.HASIL = 'TMK' THEN '01WWTMK'
							  WHEN B.JENIS_SARANA_ID = '03WW' AND A.HASIL = 'TTP' THEN '01WWTTP'
							  WHEN B.JENIS_SARANA_ID = '03WW' AND A.HASIL = 'TDP' THEN '01WWTDP'
							  WHEN B.JENIS_SARANA_ID = '03AN' AND A.HASIL = 'MK' THEN '01ANMK'
							  WHEN B.JENIS_SARANA_ID = '03AN' AND A.HASIL = 'Minor' THEN '01ANMN'
							  WHEN B.JENIS_SARANA_ID = '03AN' AND A.HASIL = 'Major' THEN '01ANMJ'
							  WHEN B.JENIS_SARANA_ID = '03AN' AND A.HASIL = 'Kritikal' THEN '01ANKR'
							  WHEN B.JENIS_SARANA_ID = '03AN' AND A.HASIL = '' OR A.HASIL IS NULL THEN '01ANNULL'
							  WHEN B.JENIS_SARANA_ID = '03BN' AND A.HASIL = 'MK' THEN '01BNMK'
							  WHEN B.JENIS_SARANA_ID = '03BN' AND A.HASIL = 'Minor' THEN '01BNMN'
							  WHEN B.JENIS_SARANA_ID = '03BN' AND A.HASIL = 'Major' THEN '01BNMJ'
							  WHEN B.JENIS_SARANA_ID = '03BN' AND A.HASIL = 'Kritikal' THEN '01BNKR'
							  WHEN B.JENIS_SARANA_ID = '03BN' AND A.HASIL = '' OR A.HASIL IS NULL THEN '01BNNULL'	
							  WHEN B.JENIS_SARANA_ID = '03NN' AND A.HASIL = 'MK' THEN '01NNMK'
							  WHEN B.JENIS_SARANA_ID = '03NN' AND A.HASIL = 'Minor' THEN '01NNMN'
							  WHEN B.JENIS_SARANA_ID = '03NN' AND A.HASIL = 'Major' THEN '01NNMJ'
							  WHEN B.JENIS_SARANA_ID = '03NN' AND A.HASIL = 'Kritikal' THEN '01NNKR'
							  WHEN B.JENIS_SARANA_ID = '03NN' AND A.HASIL = '' OR A.HASIL IS NULL THEN '01NNNULL'
							  WHEN B.JENIS_SARANA_ID = '03RN' AND A.HASIL = 'MK' THEN '01RNMK'
							  WHEN B.JENIS_SARANA_ID = '03RN' AND A.HASIL = 'Minor' THEN '01RNMN'
							  WHEN B.JENIS_SARANA_ID = '03RN' AND A.HASIL = 'Major' THEN '01RNMJ'
							  WHEN B.JENIS_SARANA_ID = '03RN' AND A.HASIL = 'Kritikal' THEN '01RNKR'
							  WHEN B.JENIS_SARANA_ID = '03RN' AND A.HASIL = '' OR A.HASIL IS NULL THEN '01RNNULL'
							  WHEN B.JENIS_SARANA_ID = '03WN' AND A.HASIL = 'MK' THEN '01WNMK'
							  WHEN B.JENIS_SARANA_ID = '03WN' AND A.HASIL = 'Minor' THEN '01WNMN'
							  WHEN B.JENIS_SARANA_ID = '03WN' AND A.HASIL = 'Major' THEN '01WNMJ'
							  WHEN B.JENIS_SARANA_ID = '03WN' AND A.HASIL = 'Kritikal' THEN '01WNKR'
							  WHEN B.JENIS_SARANA_ID = '03WN' AND A.HASIL = '' OR A.HASIL IS NULL THEN '01WNNULL'
						  END AS HASIL
						  FROM T_PEMERIKSAAN A LEFT JOIN M_JENIS_SARANA B 
						  ON A.JENIS_SARANA_ID = B.JENIS_SARANA_ID 
						  LEFT JOIN M_BBPOM C ON A.BBPOM_ID = C.BBPOM_ID
						  WHERE LEFT(A.JENIS_SARANA_ID, 2) = '03' AND LEN(A.STATUS) > 2 $filter)DT PIVOT(COUNT(HASIL) 
						  FOR HASIL IN ([01AAFMK],[01AATMK],[01AATTP],[01AATDP],[01BBMK],[01BBTMK],[01BBTTP],[01BBTDP],[01RSMK],[01RSTMK],[01RSTTP],[01RSTDP],[01TRMK],[01TRTMK],[01TRTTP],[01TRTDP],[01WWMK],[01WWTMK],[01WWTTP],[01WWTDP],[01ANMK],[01ANMN],[01ANMJ],[01ANKR],[01ANNULL],[01BNMK],[01BNMN],[01BNMJ],[01BNKR],[01BNNULL],[01NNMK],[01NNMN],[01NNMJ],[01NNKR],[01NNNULL],[01RNMK],[01RNMN],[01RNMJ],[01RNKR],[01RNNULL],[01WNMK],[01WNMN],[01WNMJ],[01WNKR],[01WNNULL])) PVT ORDER BY PVT.NAMA_BBPOM ASC";
				$this->newphpexcel->createSheet();
				$this->newphpexcel->setActiveSheetIndex(2);
				$this->newphpexcel->set_title('Sarana Pelayanan');
				$this->newphpexcel->mergecell(array(array('A1','AU1'),array('A2','AU2'),array('A3','AU3'),array('A4','AU4'),array('C7','AU7'),array('C8','F8'),array('G8','J8'),array('K8','N8'),array('O8','R8'),array('S8','V8'),array('W8','AA8'),array('AB8','AF8'),array('AG8','AK8'),array('AL8','AP8'),array('AQ8','AU8')), TRUE);
				$this->newphpexcel->mergecell(array(array('A6','AC6'),array('A7','A9'),array('B7','B9')), FALSE);
				$this->newphpexcel->width(array(array('A',4), array('B',25)));
				$this->newphpexcel->set_bold(array('A1','A2','A3','A4','A6'));
				$this->newphpexcel->setActiveSheetIndex(2)->setCellValue('A1', 'REKAPITULASI HASIL PELAKSANAAN KEGIATAN')->setCellValue('A2', 'BALAI BESAR / BALAI POM')->setCellValue('A3', strtoupper($balai))->setCellValue('A4', 'PERIODE : '.$awal.' s.d '.$akhir)->setCellValue('A6', 'PEMERIKSAAN SARANA PELAYANAN');
				$this->newphpexcel->setActiveSheetIndex(2)->setCellValue('A7','No.')->setCellValue('B7','BB / BPOM')->setCellValue('C7','Jumlah Dalam Hasil')->setCellValue('C8','Apotek')->setCellValue('G8','Balai Pengobatan')->setCellValue('K8','Pusat Kesehatan Masyarakat')->setCellValue('O8','Installasi Farmasi Rumah Sakit')->setCellValue('S8','Toko Obat')->setCellValue('W8','Apotek Pengawasan Napza')->setCellValue('AB8','Balai Pengobatan Pengawasan Napza')->setCellValue('AG8','Praktek Dokter Pengawasan Napza')->setCellValue('AL8','PKM Pengawasan Napza')->setCellValue('AQ8','Toko Obat Pengawasan Napza')->setCellValue('C9','MK')->setCellValue('D9','TMK')->setCellValue('E9','TDP')->setCellValue('F9','TTP')->setCellValue('G9','MK')->setCellValue('H9','TMK')->setCellValue('I9','TTP')->setCellValue('J9','TDP')->setCellValue('K9','MK')->setCellValue('L9','TMK')->setCellValue('M9','TDP')->setCellValue('N9','TTP')->setCellValue('O9','MK')->setCellValue('P9','TMK')->setCellValue('Q9','TDP')->setCellValue('R9','TTP')->setCellValue('S9','MK')->setCellValue('T9','TMK')->setCellValue('U9','TDP')->setCellValue('V9','TTP')->setCellValue('W9','MK')->setCellValue('X9','Minor')->setCellValue('Y9','Major')->setCellValue('Z9','Kritikal')->setCellValue('AA9','Tidak Ada Hasil')->setCellValue('AB9','MK')->setCellValue('AC9','Minor')->setCellValue('AD9','Major')->setCellValue('AE9','Kritikal')->setCellValue('AF9','Tidak Ada Hasil')->setCellValue('AG9','MK')->setCellValue('AH9','Minor')->setCellValue('AI9','Major')->setCellValue('AJ9','Kritikal')->setCellValue('AK9','Tidak Ada Hasil')->setCellValue('AL9','MK')->setCellValue('AM9','Minor')->setCellValue('AN9','Major')->setCellValue('AO9','Kritikal')->setCellValue('AP9','Tidak Ada Hasil')->setCellValue('AQ9','MK')->setCellValue('AR9','Minor')->setCellValue('AS9','Major')->setCellValue('AT9','Kritikal')->setCellValue('AU9','Tidak Ada Hasil');
				$this->newphpexcel->headings(array('A7','A8','A9','B7','C7','D7','E7','F7','G7','H7','I7','J7','K7','L7','M7','N7','O7','P7','Q7','R7','S7','T7','U7','V7','W7','X7','Y7','Z7','AA7','AB7','AC7','AD7','AE7','AF7','AG7','AH7','AI7','AJ7','AK7','AL7','AM7','AN7','AO7','AP7','AQ7','AR7','AS7','AT7','AU7','C8','D8','E8','F8','G8','H8','I8','J8','K8','L8','M8','N8','O8','P8','Q8','R8','S8','T8','U8','V8','W8','X8','Y8','Z8','AA8','AB8','AC8','AD8','AE8','AF8','AG8','AH8','AI8','AJ8','AK8','AL8','AM8','AN8','AO8','AP8','AQ8','AR8','AS8','AT8','AU8','C9','D9','E9','F9','G9','H9','I9','J9','K9','L9','M9','N9','O9','P9','Q9','R9','S9','T9','U9','V9','W9','X9','Y9','Z9','AA9','AB9','AC9','AD9','AE9','AF9','AG9','AH9','AI9','AJ9','AK9','AL9','AM9','AN9','AO9','AP9','AQ9','AR9','AS9','AT9','AU9'));
				$data = $sipt->main->get_result($query);
				if($data){
					$no=1;
					$rec = 10;
					foreach($query->result_array() as $row){
						$this->newphpexcel->setActiveSheetIndex(2)->setCellValue('A'.$rec,$no)->setCellValue('B'.$rec,strtoupper($row["NAMA_BBPOM"]))->setCellValue('C'.$rec,$row["01AAFMK"])->setCellValue('D'.$rec,$row["01AATMK"])->setCellValue('E'.$rec,$row["01AATTP"])->setCellValue('F'.$rec,$row["01AATDP"])->setCellValue('G'.$rec,$row["01BBMK"])->setCellValue('H'.$rec,$row["01BBTMK"])->setCellValue('I'.$rec,$row["01BBTTP"])->setCellValue('J'.$rec,$row["01BBTDP"])->setCellValue('K'.$rec,$row["01RSMK"])->setCellValue('L'.$rec,$row["01RSTMK"])->setCellValue('M'.$rec,$row["01RSTTP"])->setCellValue('N'.$rec,$row["01RSTDP"])->setCellValue('O'.$rec,$row["01TRMK"])->setCellValue('P'.$rec,$row["01TRTMK"])->setCellValue('Q'.$rec,$row["01TRTTP"])->setCellValue('R'.$rec,$row["01TRTDP"])->setCellValue('S'.$rec,$row["01WWMK"])->setCellValue('T'.$rec,$row["01WWTMK"])->setCellValue('U'.$rec,$row["01WWTTP"])->setCellValue('V'.$rec,$row["01WWTDP"])->setCellValue('W'.$rec,$row["01ANMK"])->setCellValue('X'.$rec,$row["01ANMN"])->setCellValue('Y'.$rec,$row["01ANMJ"])->setCellValue('Z'.$rec,$row["01ANKR"])->setCellValue('AA'.$rec,$row["01ANNULL"])->setCellValue('AB'.$rec,$row["01BNMK"])->setCellValue('AC'.$rec,$row["01BNMN"])->setCellValue('AD'.$rec,$row["01BNMJ"])->setCellValue('AE'.$rec,$row["01BNKR"])->setCellValue('AF'.$rec,$row["01BNNULL"])->setCellValue('AG'.$rec,$row["01NNMK"])->setCellValue('AH'.$rec,$row["01NNMN"])->setCellValue('AI'.$rec,$row["01NNMJ"])->setCellValue('AJ'.$rec,$row["01NNKR"])->setCellValue('AK'.$rec,$row["01NNNULL"])->setCellValue('AL'.$rec,$row["01RNMK"])->setCellValue('AM'.$rec,$row["01RNMN"])->setCellValue('AN'.$rec,$row["01RNMJ"])->setCellValue('AO'.$rec,$row["01RNKR"])->setCellValue('AP'.$rec,$row["01RNNULL"])->setCellValue('AQ'.$rec,$row["01WNMK"])->setCellValue('AR'.$rec,$row["01WNMN"])->setCellValue('AS'.$rec,$row["01WNMJ"])->setCellValue('AT'.$rec,$row["01WNKR"])->setCellValue('AU'.$rec,$row["01WNNULL"]);
						
						$this->newphpexcel->set_detilstyle(array('A'.$rec,'B'.$rec,'C'.$rec,'D'.$rec,'E'.$rec,'F'.$rec,'G'.$rec,'H'.$rec,'I'.$rec,'J'.$rec,'K'.$rec,'L'.$rec,'M'.$rec,'N'.$rec,'O'.$rec,'P'.$rec,'Q'.$rec,'R'.$rec,'S'.$rec,'T'.$rec,'U'.$rec,'V'.$rec,'W'.$rec,'X'.$rec,'Y'.$rec,'Z'.$rec,'AA'.$rec,'AB'.$rec,'AC'.$rec,'AD'.$rec,'AE'.$rec,'AF'.$rec,'AG'.$rec,'AH'.$rec,'AI'.$rec,'AJ'.$rec,'AK'.$rec,'AL'.$rec,'AM'.$rec,'AN'.$rec,'AO'.$rec,'AP'.$rec,'AQ'.$rec,'AR'.$rec,'AS'.$rec,'AT'.$rec,'AU'.$rec));
						$rec++;
						$no++;
					}
					$total = $rec - 1;
					$this->newphpexcel->setActiveSheetIndex(2)->setCellValue('A'.$rec,'')
					->setCellValue('B'.$rec,'Jumlah')
					->setCellValue('C'.$rec,'=SUM(C10:C'.$total.')')
					->setCellValue('D'.$rec,'=SUM(D10:D'.$total.')')
					->setCellValue('E'.$rec,'=SUM(E10:E'.$total.')')
					->setCellValue('F'.$rec,'=SUM(F10:F'.$total.')')
					->setCellValue('G'.$rec,'=SUM(G10:G'.$total.')')
					->setCellValue('H'.$rec,'=SUM(H10:H'.$total.')')
					->setCellValue('I'.$rec,'=SUM(I10:I'.$total.')')
					->setCellValue('J'.$rec,'=SUM(J10:J'.$total.')')
					->setCellValue('K'.$rec,'=SUM(K10:K'.$total.')')
					->setCellValue('L'.$rec,'=SUM(L10:L'.$total.')')
					->setCellValue('M'.$rec,'=SUM(M10:M'.$total.')')
					->setCellValue('N'.$rec,'=SUM(N10:N'.$total.')')
					->setCellValue('O'.$rec,'=SUM(O10:O'.$total.')')
					->setCellValue('P'.$rec,'=SUM(P10:P'.$total.')')
					->setCellValue('Q'.$rec,'=SUM(Q10:Q'.$total.')')
					->setCellValue('R'.$rec,'=SUM(R10:R'.$total.')')
					->setCellValue('S'.$rec,'=SUM(S10:S'.$total.')')
					->setCellValue('T'.$rec,'=SUM(T10:T'.$total.')')
					->setCellValue('U'.$rec,'=SUM(U10:U'.$total.')')
					->setCellValue('V'.$rec,'=SUM(V10:V'.$total.')')
					->setCellValue('W'.$rec,'=SUM(W10:W'.$total.')')
					->setCellValue('X'.$rec,'=SUM(X10:X'.$total.')')
					->setCellValue('Y'.$rec,'=SUM(Y10:Y'.$total.')')
					->setCellValue('Z'.$rec,'=SUM(Z10:Z'.$total.')')
					->setCellValue('AA'.$rec,'=SUM(AA10:AA'.$total.')')
					->setCellValue('AB'.$rec,'=SUM(AB10:AB'.$total.')')
					->setCellValue('AC'.$rec,'=SUM(AC10:AC'.$total.')')
					->setCellValue('AD'.$rec,'=SUM(AD10:AD'.$total.')')
					->setCellValue('AE'.$rec,'=SUM(AE10:AE'.$total.')')
					->setCellValue('AF'.$rec,'=SUM(AF10:AF'.$total.')')
					->setCellValue('AG'.$rec,'=SUM(AG10:AG'.$total.')')
					->setCellValue('AH'.$rec,'=SUM(AH10:AH'.$total.')')
					->setCellValue('AI'.$rec,'=SUM(AI10:AI'.$total.')')
					->setCellValue('AJ'.$rec,'=SUM(AJ10:AJ'.$total.')')
					->setCellValue('AK'.$rec,'=SUM(AK10:AK'.$total.')')
					->setCellValue('AL'.$rec,'=SUM(AL10:AL'.$total.')')
					->setCellValue('AM'.$rec,'=SUM(AM10:AM'.$total.')')
					->setCellValue('AN'.$rec,'=SUM(AN10:AN'.$total.')')
					->setCellValue('AO'.$rec,'=SUM(AO10:AO'.$total.')')
					->setCellValue('AP'.$rec,'=SUM(AP10:AP'.$total.')')
					->setCellValue('AQ'.$rec,'=SUM(AQ10:AQ'.$total.')')
					->setCellValue('AR'.$rec,'=SUM(AR10:AR'.$total.')')
					->setCellValue('AS'.$rec,'=SUM(AS10:AS'.$total.')')
					->setCellValue('AT'.$rec,'=SUM(AT10:AT'.$total.')')
					->setCellValue('AU'.$rec,'=SUM(AU10:AU'.$total.')');
						$this->newphpexcel->set_detilstyle(array('A'.$rec,'B'.$rec,'C'.$rec,'D'.$rec,'E'.$rec,'F'.$rec,'G'.$rec,'H'.$rec,'I'.$rec,'J'.$rec,'K'.$rec,'L'.$rec,'M'.$rec,'N'.$rec,'O'.$rec,'P'.$rec,'Q'.$rec,'R'.$rec,'S'.$rec,'T'.$rec,'U'.$rec,'V'.$rec,'W'.$rec,'X'.$rec,'Y'.$rec,'Z'.$rec,'AA'.$rec,'AB'.$rec,'AC'.$rec,'AD'.$rec,'AE'.$rec,'AF'.$rec,'AG'.$rec,'AH'.$rec,'AI'.$rec,'AJ'.$rec,'AK'.$rec,'AL'.$rec,'AM'.$rec,'AN'.$rec,'AO'.$rec,'AP'.$rec,'AQ'.$rec,'AR'.$rec,'AS'.$rec,'AT'.$rec,'AU'.$rec));
				}else{
					$this->newphpexcel->getActiveSheet()->mergeCells('A10:AU10');
					$this->newphpexcel->setActiveSheetIndex(2)->setCellValue('A10','Data Tidak Ditemukan');
					$this->newphpexcel->set_detilstyle(array('A10'));
				}
			}
			ob_clean();
			$file = "REKAPITULASI_PEMERIKSAAN_SARANA".str_replace(" ","_",str_replace("-","",$judul))."_".date("YmdHis").".xls";
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
	
	function get_statdoc(){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$this->load->library('newphpexcel');
			$sarana = "'".join("','", $this->newsession->userdata('SESS_SARANA'))."'";
			//$query = "SELECT *, ([OPBALAIDRAFT] + [OPBALAIREJECT] + [OPBALAIREV] + [SPV1BALAITL] + [SPV1BALAIREJECT] + [SPV1BALAIREV] + [SPV2BALAITL] + [SPV2BALAIREJECT] + [SPV2BALAIREV] + [KABALAI] + [TLBALAI] + [OPPUSATDRAFT] + [OPPUSATREJECT] + [OPPUSATREV] + [SPV1PUSATTL] + [SPV1PUSATREJECT] + [SPV1PUSATREV] + [SPV2PUSATTL] + [SPV2PUSATREJECT] + [SPV2PUSATREV] + [DIREKTUR] + [SELESAI]) as TOTAL FROM(SELECT REPLACE(REPLACE(C.NAMA_BBPOM,'BALAI BESAR POM', 'BBPOM'),'BALAI POM','BPOM') AS NAMA_BBPOM, CASE WHEN A.STATUS = '20101' THEN 'OPBALAIDRAFT' WHEN A.STATUS = '20102' THEN 'OPBALAIREJECT' WHEN A.STATUS = '20103' THEN 'OPBALAIREV' WHEN A.STATUS = '30101' THEN 'SPV1BALAITL' WHEN A.STATUS = '30102' THEN 'SPV1BALAIREJECT' WHEN A.STATUS IN ('30103','30104') THEN 'SPV1BALAIREV' WHEN A.STATUS = '40101' THEN 'SPV2BALAITL' WHEN A.STATUS = '40102' THEN 'SPV2BALAIREJECT' WHEN A.STATUS = '40103' THEN 'SPV2BALAIREV' WHEN A.STATUS = '50101' THEN 'KABALAI' WHEN A.STATUS = '20115' THEN 'TLBALAI' WHEN A.STATUS = '20111' THEN 'OPPUSATDRAFT' WHEN A.STATUS = '20112' THEN 'OPPUSATREJECT' WHEN A.STATUS = '20113' THEN 'OPPUSATREV' WHEN A.STATUS = '30111' THEN 'SPV1PUSATTL' WHEN A.STATUS = '30112' THEN 'SPV1PUSATREJECT' WHEN A.STATUS IN ('30113','30114') THEN 'SPV1PUSATREV' WHEN A.STATUS = '40111' THEN 'SPV2PUSATTL' WHEN A.STATUS = '40112' THEN 'SPV2PUSATREJECT' WHEN A.STATUS = '40113' THEN 'SPV2PUSATREV' WHEN A.STATUS = '60111' THEN 'DIREKTUR' WHEN A.STATUS = '60010' THEN 'SELESAI' WHEN A.STATUS = '60020' THEN 'DIRETURNKEBALAI' END AS STATUS FROM T_PEMERIKSAAN A LEFT JOIN M_BBPOM C ON A.BBPOM_ID = C.BBPOM_ID WHERE A.JENIS_SARANA_ID IN ($sarana) ";
			$query = "SELECT *, ([OPBALAIDRAFT] + [OPBALAIREJECT] + [OPBALAIREV] + [SPV1BALAITL] + [SPV1BALAIREJECT] + [SPV1BALAIREV] + [SPV2BALAITL] + [SPV2BALAIREJECT] + [SPV2BALAIREV] + [KABALAI] + [TLBALAI] + [OPPUSATDRAFT] + [OPPUSATREJECT] + [OPPUSATREV] + [SPV1PUSATTL] + [SPV1PUSATREJECT] + [SPV1PUSATREV] + [SPV2PUSATTL] + [SPV2PUSATREJECT] + [SPV2PUSATREV] + [DIREKTUR] + [SELESAI] + [DIRETURNKEBALAI]) as TOTAL FROM(SELECT REPLACE(REPLACE(C.NAMA_BBPOM,'BALAI BESAR POM', 'BBPOM'),'BALAI POM','BPOM') AS NAMA_BBPOM, CASE WHEN A.STATUS = '20101' THEN 'OPBALAIDRAFT' WHEN A.STATUS = '20102' THEN 'OPBALAIREJECT' WHEN A.STATUS = '20103' THEN 'OPBALAIREV' WHEN A.STATUS = '30101' THEN 'SPV1BALAITL' WHEN A.STATUS = '30102' THEN 'SPV1BALAIREJECT' WHEN A.STATUS = '30104' THEN 'SPV1BALAIREV' WHEN A.STATUS = '40101' THEN 'SPV2BALAITL' WHEN A.STATUS = '40102' THEN 'SPV2BALAIREJECT' WHEN A.STATUS = '40103' THEN 'SPV2BALAIREV' WHEN A.STATUS = '50101' THEN 'KABALAI' WHEN A.STATUS = '20115' THEN 'TLBALAI' WHEN A.STATUS = '20111' THEN 'OPPUSATDRAFT' WHEN A.STATUS = '20112' THEN 'OPPUSATREJECT' WHEN A.STATUS = '20113' THEN 'OPPUSATREV' WHEN A.STATUS = '30111' THEN 'SPV1PUSATTL' WHEN A.STATUS = '30112' THEN 'SPV1PUSATREJECT' WHEN A.STATUS = '30114' THEN 'SPV1PUSATREV' WHEN A.STATUS = '40111' THEN 'SPV2PUSATTL' WHEN A.STATUS = '40112' THEN 'SPV2PUSATREJECT' WHEN A.STATUS = '40113' THEN 'SPV2PUSATREV' WHEN A.STATUS = '60111' THEN 'DIREKTUR' WHEN A.STATUS = '60010' THEN 'SELESAI' WHEN A.STATUS = '60020' THEN 'DIRETURNKEBALAI' END AS STATUS FROM T_PEMERIKSAAN A LEFT JOIN M_BBPOM C ON A.BBPOM_ID = C.BBPOM_ID WHERE A.JENIS_SARANA_ID IN ($sarana) ";
			if(trim($this->input->post('STATUS_AWAL')!="")){
				$query .= $sipt->main->find_where($query);
				$query .= " DATEDIFF(dy, 0, convert(DATETIME, A.AWAL_PERIKSA, 105)) >= DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('STATUS_AWAL')."', 105))";
				$awal = $this->input->post('STATUS_AWAL');
			}else{
				$query .= $sipt->main->find_where($query);
				$query .= " A.AWAL_PERIKSA > DATEADD(M, DATEDIFF(M,0,GETDATE()),0)";
				$awal = date('01/m/Y');
			}
			if(trim($this->input->post('STATUS_AKHIR')!="")){
				$query .= $sipt->main->find_where($query);
				$query .= " DATEDIFF(dy, 0, convert(DATETIME, A.AKHIR_PERIKSA, 105)) <= DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('STATUS_AKHIR')."', 105))";
				$akhir = $this->input->post('STATUS_AKHIR');
			}else{
				$query .= $sipt->main->find_where($query);
				$query .= " A.AKHIR_PERIKSA < DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,0,GETDATE())+1,0))";
				$akhir = date('t/m/Y');
			}
			if(in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')) || $this->newsession->userdata('SESS_BBPOM_ID') == "00"){
				if(trim($this->input->post('BBPOM_ID'))==""){
					$query .= "";
					$balai = 'Seluruh Balai';
				}else{
					$query .= $sipt->main->find_where($query);
					$query .= " A.BBPOM_ID = '".$this->input->post('BBPOM_ID')."'";
					$balai = $sipt->main->get_uraian("SELECT NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID = '".$this->input->post('BBPOM_ID')."'","NAMA_BBPOM");		
				}
			}else{
				$query .= $sipt->main->find_where($query);
				$query .= " A.BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'";
				$balai = $sipt->main->get_uraian("SELECT NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","NAMA_BBPOM");		
			}
			
			$query .= $sipt->main->find_where($query);
			$query .= " LEN(A.STATUS) > 2"; 
			
			$query .= ") DT PIVOT(COUNT(STATUS) FOR STATUS IN ([OPBALAIDRAFT], [OPBALAIREJECT], [OPBALAIREV], [SPV1BALAITL], [SPV1BALAIREJECT], [SPV1BALAIREV], [SPV2BALAITL], [SPV2BALAIREJECT], [SPV2BALAIREV], [KABALAI], [TLBALAI], [OPPUSATDRAFT], [OPPUSATREJECT], [OPPUSATREV], [SPV1PUSATTL], [SPV1PUSATREJECT], [SPV1PUSATREV], [SPV2PUSATTL], [SPV2PUSATREJECT], [SPV2PUSATREV], [DIREKTUR], [SELESAI],[DIRETURNKEBALAI])) PVT";
			$this->newphpexcel->getDefaultStyle()->getFont()->setName('Calibri')->setSize(10);
			$this->newphpexcel->setActiveSheetIndex(0);
			$this->newphpexcel->mergecell(array(array('A1','Y1')), FALSE);
			$this->newphpexcel->mergecell(array(array('A6','A7'),array('B6','B7'),array('C6','E6'),array('F6','H6'),array('I6','K6'),array('L6','L7'),array('M6','P6'),array('Q6','S6'),array('T6','V6'),array('W6','W7'),array('X6','X7'),array('Y6','Y7'),array('Z6','Z7')), TRUE);
			$this->newphpexcel->width(array(array('A',4),array('B',30),array('C',7),array('D',7),array('E',9),array('F',7),array('G',7),array('H',9),array('I',7),array('J',7),array('K',9),array('L',9),array('M',9),array('N',9),array('O',8),array('P',9),array('Q',7),array('R',9),array('S',9),array('T',7),array('U',9),array('V',9),array('W',8),array('X',8),array('Y',12),array('Z',8)));
			$this->newphpexcel->set_bold(array('A1'));
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A1', 'REKAPITULASI STATUS DOKUMEN PEMERIKSAAN SARANA')->setCellValue('A3', 'Pemeriksaan Awal')->setCellValue('C3', $awal)->setCellValue('A4', 'Pemeriksaan Akhir')->setCellValue('C4', $akhir)->setCellValue('A5', 'Balai Besar / Balai POM')->setCellValue('C5', $balai);
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A6','No.')->setCellValue('B6','BB / BPOM / UNIT DITWAS')->setCellValue('C6','Operator Balai')->setCellValue('F6','SPV Satu Balai')->setCellValue('I6','SPV Dua Balai')->setCellValue('L6','Ka. Balai')->setCellValue('M6','Operator Pusat')->setCellValue('Q6','SPV Satu Pusat')->setCellValue('T6','SPV Dua Pusat')->setCellValue('W6','Direktur')->setCellValue('X6','Selesai')->setCellValue('Y6','Feedback Pusat')->setCellValue('Z6','Total')
				->setCellValue('C7','Draft')->setCellValue('D7','Ditolak')->setCellValue('E7','Perbaikan')->setCellValue('F7','Tindak Lanjut')->setCellValue('G7','Ditolak')->setCellValue('H7','Perbaikan')->setCellValue('I7','Tindak Lanjut')->setCellValue('J7','Ditolak Ka. Balai')->setCellValue('K7','Perbaikan')->setCellValue('M7','TL Balai')->setCellValue('N7','Draft Pusat')->setCellValue('O7','Ditolak')->setCellValue('P7','Perbaikan')->setCellValue('Q7','Tindak Lanjut')->setCellValue('R7','Ditolak')->setCellValue('S7','Perbaikan')->setCellValue('T7','Tindak Lanjut')->setCellValue('U7','Ditolak Direktur')->setCellValue('V7','Perbaikan');
			$this->newphpexcel->headings(array('A7','B7','C7','D7','E7','F7','G7','H7','I7','J7','K7','L7','M7','N7','O7','P7','Q7','R7','S7','T7','U7','V7','W7','X7','Y7','Z7'));
			$this->newphpexcel->headings(array('A6','B6','C6','D6','E6','F6','G6','H6','I6','J6','K6','L6','M6','N6','O6','P6','Q6','R6','S6','T6','U6','V6','W6','X6','Y6','Z6'));
			$this->newphpexcel->set_wrap(array('C7','D7','E7','F7','G7','H7','I7','J7','K7','L7','M7','N7','O7','P7','Q7','R7','S7','T7','U7','V7','W7','X7','Y6'));
			$data = $sipt->main->get_result($query);
			if($data){
				$no=1;
				$rec = 8;
				foreach($query->result_array() as $row){
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A'.$rec,$no)
					->setCellValue('B'.$rec,strtoupper($row["NAMA_BBPOM"]))
					->setCellValue('C'.$rec,$row["OPBALAIDRAFT"])
					->setCellValue('D'.$rec,$row["OPBALAIREJECT"])
					->setCellValue('E'.$rec,$row["OPBALAIREV"])
					->setCellValue('F'.$rec,$row["SPV1BALAITL"])
					->setCellValue('G'.$rec,$row["SPV1BALAIREJECT"])
					->setCellValue('H'.$rec,$row["SPV1BALAIREV"])
					->setCellValue('I'.$rec,$row["SPV2BALAITL"])
					->setCellValue('J'.$rec,$row["SPV2BALAIREJECT"])
					->setCellValue('K'.$rec,$row["SPV2BALAIREV"])
					->setCellValue('L'.$rec,$row["KABALAI"])
					->setCellValue('M'.$rec,$row["TLBALAI"])
					->setCellValue('N'.$rec,$row["OPPUSATDRAFT"])
					->setCellValue('O'.$rec,$row["OPPUSATREJECT"])
					->setCellValue('P'.$rec,$row["OPPUSATREV"])
					->setCellValue('Q'.$rec,$row["SPV1PUSATTL"])
					->setCellValue('R'.$rec,$row["SPV1PUSATREJECT"])
					->setCellValue('S'.$rec,$row["SPV1PUSATREV"])
					->setCellValue('T'.$rec,$row["SPV2PUSATTL"])
					->setCellValue('U'.$rec,$row["SPV2PUSATREJECT"])
					->setCellValue('V'.$rec,$row["SPV2PUSATREV"])
					->setCellValue('W'.$rec,$row["DIREKTUR"])
					->setCellValue('X'.$rec,$row["SELESAI"])
					->setCellValue('Y'.$rec,$row["DIRETURNKEBALAI"])
					->setCellValue('Z'.$rec,'=SUM(C'.$rec.':Y'.$rec.')');
					$this->newphpexcel->set_detilstyle(array('A'.$rec,'B'.$rec,'C'.$rec,'D'.$rec,'E'.$rec,'F'.$rec,'G'.$rec,'H'.$rec,'I'.$rec,'J'.$rec,'K'.$rec,'L'.$rec,'M'.$rec,'N'.$rec,'O'.$rec,'P'.$rec,'Q'.$rec,'R'.$rec,'S'.$rec,'T'.$rec,'U'.$rec,'V'.$rec,'W'.$rec,'X'.$rec,'Y'.$rec,'Z'.$rec));
					$rec++;
					$no++;
				}
			}else{
				$this->newphpexcel->getActiveSheet(0)->mergeCells('A8:Z8');
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A8','Data Tidak Ditemukan');
				$this->newphpexcel->set_detilstyle(array('A8'));
			}	
			ob_clean();
			$file = "REKAP_STATUS_DOC_".date("YmdHis").".xls";
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
	
	function get_statdocunit(){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$this->load->library('newphpexcel');
			$sarana = "'".join("','", $this->newsession->userdata('SESS_SARANA'))."'";
			$filter = "";
			if(trim($this->input->post('STATUS_AWAL')!="")){
				$filter .= " AND DATEDIFF(dy, 0, convert(DATETIME, A.AWAL_PERIKSA, 105)) >= DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('STATUS_AWAL')."', 105))";
				$awal = $this->input->post('STATUS_AWAL');
			}else{
				$filter .= " AND A.AWAL_PERIKSA > DATEADD(M, DATEDIFF(M,0,GETDATE()),0)";
				$awal = date('01/m/Y');
			}
			if(trim($this->input->post('STATUS_AKHIR')!="")){
				$filter .= " AND DATEDIFF(dy, 0, convert(DATETIME, A.AKHIR_PERIKSA, 105)) <= DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('STATUS_AKHIR')."', 105))";
				$akhir = $this->input->post('STATUS_AKHIR');
			}else{
				$filter .= " AND A.AKHIR_PERIKSA < DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,0,GETDATE())+1,0))";
				$akhir = date('t/m/Y');
			}
			if(in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')) || $this->newsession->userdata('SESS_BBPOM_ID') == "00"){
				if(trim($this->input->post('BBPOM_ID'))==""){
					$filter .= "";
					$balai = 'Seluruh Balai';
				}else{
					$filter .= " AND A.BBPOM_ID = '".$this->input->post('BBPOM_ID')."'";
					$balai = $sipt->main->get_uraian("SELECT NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID = '".$this->input->post('BBPOM_ID')."'","NAMA_BBPOM");		
				}
			}else{
				$filter .= " AND A.BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'";
				$balai = $sipt->main->get_uraian("SELECT NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","NAMA_BBPOM");		
			}#A.STATUS LIKE '%1_'
			$query = "SELECT *, ([TLBALAI] + [OPPUSATDRAFT] + [OPPUSATREJECT] + [OPPUSATREV] + [SPV1PUSATTL] + [SPV1PUSATREJECT] + [SPV1PUSATREV] + [SPV2PUSATTL] + [SPV2PUSATREJECT] + [SPV2PUSATREV] + [DIREKTUR] + [SELESAI]) as TOTAL FROM(SELECT REPLACE(REPLACE(C.NAMA_BBPOM,'BALAI BESAR POM', 'BBPOM'),'BALAI POM','BPOM') AS NAMA_BBPOM,(SELECT COUNT(Y.STATUS) FROM T_PEMERIKSAAN Y WHERE Y.BBPOM_ID = A.BBPOM_ID AND Y.STATUS LIKE '%___0_%' AND Y.JENIS_SARANA_ID IN ($sarana) $filter AND LEN(Y.STATUS) > 2) AS TOTBALAI, CASE WHEN A.STATUS = '20115' THEN 'TLBALAI' WHEN A.STATUS = '20111' THEN 'OPPUSATDRAFT' WHEN A.STATUS = '20112' THEN 'OPPUSATREJECT' WHEN A.STATUS = '20113' THEN 'OPPUSATREV' WHEN A.STATUS = '30111' THEN 'SPV1PUSATTL' WHEN A.STATUS = '30112' THEN 'SPV1PUSATREJECT' WHEN A.STATUS = '30114' THEN 'SPV1PUSATREV' WHEN A.STATUS = '40111' THEN 'SPV2PUSATTL' WHEN A.STATUS = '40112' THEN 'SPV2PUSATREJECT' WHEN A.STATUS = '40113' THEN 'SPV2PUSATREV' WHEN A.STATUS = '60111' THEN 'DIREKTUR' WHEN A.STATUS = '60010' THEN 'SELESAI' END AS STATUS FROM T_PEMERIKSAAN A LEFT JOIN M_BBPOM C ON A.BBPOM_ID = C.BBPOM_ID WHERE A.JENIS_SARANA_ID IN ($sarana) $filter AND A.STATUS LIKE '%1_' ) DT PIVOT(COUNT(STATUS) FOR STATUS IN ([TLBALAI], [OPPUSATDRAFT], [OPPUSATREJECT], [OPPUSATREV], [SPV1PUSATTL], [SPV1PUSATREJECT], [SPV1PUSATREV], [SPV2PUSATTL], [SPV2PUSATREJECT], [SPV2PUSATREV], [DIREKTUR], [SELESAI])) PVT ORDER BY PVT.NAMA_BBPOM ASC";
			$this->newphpexcel->getDefaultStyle()->getFont()->setName('Calibri')->setSize(10);
			$this->newphpexcel->setActiveSheetIndex(0);
			$this->newphpexcel->mergecell(array(array('A1','Y1')), FALSE);
			$this->newphpexcel->mergecell(array(array('A6','A7'),array('B6','B7'),array('C6','F6'),array('G6','I6'),array('J6','L6'),array('M6','M7'),array('N6','N7'),array('O6','O7'),array('P6','P7')), TRUE);
			$this->newphpexcel->width(array(array('A',4),array('B',30),array('C',7),array('D',7),array('E',9),array('F',9),array('G',7),array('H',9),array('I',9),array('J',7),array('K',9),array('L',9),array('M',9),array('N',9),array('O',8),array('P',9)));
			$this->newphpexcel->set_bold(array('A1'));
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A1', 'REKAPITULASI STATUS DOKUMEN PEMERIKSAAN SARANA')->setCellValue('A3', 'Pemeriksaan Awal')->setCellValue('C3', $awal)->setCellValue('A4', 'Pemeriksaan Akhir')->setCellValue('C4', $akhir)->setCellValue('A5', 'Balai Besar / Balai POM')->setCellValue('C5', $balai);
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A6','No.')->setCellValue('B6','BB / BPOM / UNIT DITWAS')->setCellValue('C6','Operator Pusat')->setCellValue('G6','SPV Satu Pusat')->setCellValue('J6','SPV Dua Pusat')->setCellValue('M6','Direktur')->setCellValue('N6','Selesai')->setCellValue('O6','Proses di Pusat')->setCellValue('P6','Proses di Balai')->setCellValue('C7','TL Balai')->setCellValue('D7','Draft Pusat')->setCellValue('E7','Ditolak')->setCellValue('F7','Perbaikan')->setCellValue('G7','Tindak Lanjut')->setCellValue('H7','Ditolak')->setCellValue('I7','Perbaikan')->setCellValue('J7','Tindak Lanjut')->setCellValue('K7','Ditolak direktur')->setCellValue('L7','Perbaikan');
			$this->newphpexcel->headings(array('A7','B7','C7','D7','E7','F7','G7','H7','I7','J7','K7','L7','M7','N7','O7','P7'));
			$this->newphpexcel->headings(array('A6','B6','C6','D6','E6','F6','G6','H6','I6','J6','K6','L6','M6','N6','O6','P6'));
			$this->newphpexcel->set_wrap(array('C7','D7','E7','F7','G7','H7','I7','J7','K7','L7','M7','N7','O6','P6'));
			$data = $sipt->main->get_result($query);
			if($data){
				$no=1;
				$rec = 8;
				foreach($query->result_array() as $row){
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A'.$rec,$no)
					->setCellValue('B'.$rec,strtoupper($row["NAMA_BBPOM"]))
					->setCellValue('C'.$rec,$row["TLBALAI"])
					->setCellValue('D'.$rec,$row["OPPUSATDRAFT"])
					->setCellValue('E'.$rec,$row["OPPUSATREJECT"])
					->setCellValue('F'.$rec,$row["OPPUSATREV"])
					->setCellValue('G'.$rec,$row["SPV1PUSATTL"])
					->setCellValue('H'.$rec,$row["SPV1PUSATREJECT"])
					->setCellValue('I'.$rec,$row["SPV1PUSATREV"])
					->setCellValue('J'.$rec,$row["SPV2PUSATTL"])
					->setCellValue('K'.$rec,$row["SPV2PUSATREJECT"])
					->setCellValue('L'.$rec,$row["SPV2PUSATREV"])
					->setCellValue('M'.$rec,$row["DIREKTUR"])
					->setCellValue('N'.$rec,$row["SELESAI"])
					->setCellValue('O'.$rec,'=SUM(C'.$rec.':M'.$rec.')')
					->setCellValue('P'.$rec,$row["TOTBALAI"]);
					$this->newphpexcel->set_detilstyle(array('A'.$rec,'B'.$rec,'C'.$rec,'D'.$rec,'E'.$rec,'F'.$rec,'G'.$rec,'H'.$rec,'I'.$rec,'J'.$rec,'K'.$rec,'L'.$rec,'M'.$rec,'N'.$rec,'O'.$rec,'P'.$rec));
					$rec++;
					$no++;
				}
			}else{
				$this->newphpexcel->getActiveSheet()->mergeCells('A8:P8');
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A8','Data Tidak Ditemukan');
				$this->newphpexcel->set_detilstyle(array('A8'));
			}
			ob_clean();
			$file = "REKAP_STATUS_DOC_".date("YmdHis").".xls";
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
	
	function get_statkomoditi(){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$this->load->library('newphpexcel');
			$query = "SELECT *, ([OPBALAIDRAFT] + [OPBALAIREJECT] + [OPBALAIREV] + [SPV1BALAITL] + [SPV1BALAIREJECT] + [SPV1BALAIREV] + [SPV2BALAITL] + [SPV2BALAIREJECT] + [SPV2BALAIREV] + [KABALAI] + [TLBALAI] + [OPPUSATDRAFT] + [OPPUSATREJECT] + [OPPUSATREV] + [SPV1PUSATTL] + [SPV1PUSATREJECT] + [SPV1PUSATREV] + [SPV2PUSATTL] + [SPV2PUSATREJECT] + [SPV2PUSATREV] + [DIREKTUR] + [SELESAI]) as TOTAL FROM(SELECT REPLACE(REPLACE(C.NAMA_BBPOM,'BALAI BESAR POM', 'BBPOM'),'BALAI POM','BPOM') AS NAMA_BBPOM, CASE WHEN A.STATUS = '20101' THEN 'OPBALAIDRAFT' WHEN A.STATUS = '20102' THEN 'OPBALAIREJECT' WHEN A.STATUS = '20103' THEN 'OPBALAIREV' WHEN A.STATUS = '30101' THEN 'SPV1BALAITL' WHEN A.STATUS = '30102' THEN 'SPV1BALAIREJECT' WHEN A.STATUS IN ('30103','30104') THEN 'SPV1BALAIREV' WHEN A.STATUS = '40101' THEN 'SPV2BALAITL' WHEN A.STATUS = '40102' THEN 'SPV2BALAIREJECT' WHEN A.STATUS = '40103' THEN 'SPV2BALAIREV' WHEN A.STATUS = '50101' THEN 'KABALAI' WHEN A.STATUS = '20115' THEN 'TLBALAI' WHEN A.STATUS = '20111' THEN 'OPPUSATDRAFT' WHEN A.STATUS = '20112' THEN 'OPPUSATREJECT' WHEN A.STATUS = '20113' THEN 'OPPUSATREV' WHEN A.STATUS = '30111' THEN 'SPV1PUSATTL' WHEN A.STATUS = '30112' THEN 'SPV1PUSATREJECT' WHEN A.STATUS IN ('30113','30114') THEN 'SPV1PUSATREV' WHEN A.STATUS = '40111' THEN 'SPV2PUSATTL' WHEN A.STATUS = '40112' THEN 'SPV2PUSATREJECT' WHEN A.STATUS = '40113' THEN 'SPV2PUSATREV' WHEN A.STATUS = '60111' THEN 'DIREKTUR' WHEN A.STATUS = '60010' THEN 'SELESAI' END AS STATUS FROM T_PEMERIKSAAN A LEFT JOIN M_BBPOM C ON A.BBPOM_ID = C.BBPOM_ID LEFT JOIN T_PEMERIKSAAN_KLASIFIKASI Z ON A.PERIKSA_ID = Z.PERIKSA_ID ";
			if(trim($this->input->post('STATUS_AWAL')!="")){
				$query .= $sipt->main->find_where($query);
				$query .= " DATEDIFF(dy, 0, convert(DATETIME, A.AWAL_PERIKSA, 105)) >= DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('STATUS_AWAL')."', 105))";
				$awal = $this->input->post('STATUS_AWAL');
			}else{
				$query .= $sipt->main->find_where($query);
				$query .= " A.AWAL_PERIKSA > DATEADD(M, DATEDIFF(M,0,GETDATE()),0)";
				$awal = date('01/m/Y');
			}
			if(trim($this->input->post('STATUS_AKHIR')!="")){
				$query .= $sipt->main->find_where($query);
				$query .= " DATEDIFF(dy, 0, convert(DATETIME, A.AKHIR_PERIKSA, 105)) <= DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('STATUS_AKHIR')."', 105))";
				$akhir = $this->input->post('STATUS_AKHIR');
			}else{
				$query .= $sipt->main->find_where($query);
				$query .= " A.AKHIR_PERIKSA < DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,0,GETDATE())+1,0))";
				$akhir = date('t/m/Y');
			}
			
			if(trim($this->input->post('KLASIFIKASI')!="")){
				$query .= $sipt->main->find_where($query);
				$query .= " Z.KK_ID = '".$this->input->post('KLASIFIKASI')."'";
			}
			
			if(in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')) || $this->newsession->userdata('SESS_BBPOM_ID') == "00"){
				if(trim($this->input->post('BBPOM_ID'))==""){
					$query .= "";
					$balai = 'Seluruh Balai';
				}else{
					$query .= $sipt->main->find_where($query);
					$query .= " A.BBPOM_ID = '".$this->input->post('BBPOM_ID')."'";
					$balai = $sipt->main->get_uraian("SELECT NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID = '".$this->input->post('BBPOM_ID')."'","NAMA_BBPOM");		
				}
			}else{
				$query .= $sipt->main->find_where($query);
				$query .= " A.BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'";
				$balai = $sipt->main->get_uraian("SELECT NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","NAMA_BBPOM");		
			}
			$query .= $sipt->main->find_where($query);
			$query .= " LEN(A.STATUS) > 2";
			$query .= ") DT PIVOT(COUNT(STATUS) FOR STATUS IN ([OPBALAIDRAFT], [OPBALAIREJECT], [OPBALAIREV], [SPV1BALAITL], [SPV1BALAIREJECT], [SPV1BALAIREV], [SPV2BALAITL], [SPV2BALAIREJECT], [SPV2BALAIREV], [KABALAI], [TLBALAI], [OPPUSATDRAFT], [OPPUSATREJECT], [OPPUSATREV], [SPV1PUSATTL], [SPV1PUSATREJECT], [SPV1PUSATREV], [SPV2PUSATTL], [SPV2PUSATREJECT], [SPV2PUSATREV], [DIREKTUR], [SELESAI])) PVT ORDER BY PVT.NAMA_BBPOM ASC";
			$judul = $sipt->main->get_uraian("SELECT NAMA_KK FROM M_KLASIFIKASI_KATEGORI WHERE KK_ID ='".$this->input->post('KLASIFIKASI')."'","NAMA_KK");
			$this->newphpexcel->getDefaultStyle()->getFont()->setName('Calibri')->setSize(10);
			$this->newphpexcel->setActiveSheetIndex(0);
			$this->newphpexcel->mergecell(array(array('A1','Y1')), FALSE);
			$this->newphpexcel->mergecell(array(array('A6','A7'),array('B6','B7'),array('C6','E6'),array('F6','H6'),array('I6','K6'),array('L6','L7'),array('M6','P6'),array('Q6','S6'),array('T6','V6'),array('W6','W7'),array('X6','X7'),array('Y6','Y7')), TRUE);
			$this->newphpexcel->width(array(array('A',4),array('B',30),array('C',7),array('D',7),array('E',9),array('F',7),array('G',7),array('H',9),array('I',7),array('J',7),array('K',9),array('L',9),array('M',9),array('N',9),array('O',8),array('P',9),array('Q',7),array('R',9),array('S',9),array('T',7),array('U',9),array('V',9),array('W',8),array('X',8),array('Y',8)));
			$this->newphpexcel->set_bold(array('A1'));
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A1', 'REKAPITULASI JUMLAH STATUS KOMODITI')->setCellValue('A2', 'Komoditi')->setCellValue('C2', $judul)->setCellValue('A3', 'Pemeriksaan Awal')->setCellValue('C3', $awal)->setCellValue('A4', 'Pemeriksaan Akhir')->setCellValue('C4', $akhir)->setCellValue('A5', 'Balai Besar / Balai POM')->setCellValue('C5', $balai);
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A6','No.')->setCellValue('B6','BB / BPOM / UNIT DITWAS')->setCellValue('C6','Operator Balai')->setCellValue('F6','SPV Satu Balai')->setCellValue('I6','SPV Dua Balai')->setCellValue('L6','Ka. Balai')->setCellValue('M6','Operator Pusat')->setCellValue('Q6','SPV Satu Pusat')->setCellValue('T6','SPV Dua Pusat')->setCellValue('W6','Direktur')->setCellValue('X6','Selesai')->setCellValue('Y6','Total')
				->setCellValue('C7','Draft')->setCellValue('D7','Ditolak')->setCellValue('E7','Perbaikan')->setCellValue('F7','Tindak Lanjut')->setCellValue('G7','Ditolak')->setCellValue('H7','Perbaikan')->setCellValue('I7','Tindak Lanjut')->setCellValue('J7','Ditolak Ka. Balai')->setCellValue('K7','Perbaikan')->setCellValue('M7','TL Balai')->setCellValue('N7','Draft Pusat')->setCellValue('O7','Ditolak')->setCellValue('P7','Perbaikan')->setCellValue('Q7','Tindak Lanjut')->setCellValue('R7','Ditolak')->setCellValue('S7','Perbaikan')->setCellValue('T7','Tindak Lanjut')->setCellValue('U7','Ditolak Direktur')->setCellValue('V7','Perbaikan');
			$this->newphpexcel->headings(array('A7','B7','C7','D7','E7','F7','G7','H7','I7','J7','K7','L7','M7','N7','O7','P7','Q7','R7','S7','T7','U7','V7','W7','X7','Y7'));
			$this->newphpexcel->headings(array('A6','B6','C6','D6','E6','F6','G6','H6','I6','J6','K6','L6','M6','N6','O6','P6','Q6','R6','S6','T6','U6','V6','W6','X6','Y6'));
			$this->newphpexcel->set_wrap(array('C7','D7','E7','F7','G7','H7','I7','J7','K7','L7','M7','N7','O7','P7','Q7','R7','S7','T7','U7','V7','W7','X7','Y7'));
			$data = $sipt->main->get_result($query);
			if($data){
				$no=1;
				$rec = 8;
				foreach($query->result_array() as $row){
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A'.$rec,$no)
					->setCellValue('B'.$rec,strtoupper($row["NAMA_BBPOM"]))
					->setCellValue('C'.$rec,$row["OPBALAIDRAFT"])
					->setCellValue('D'.$rec,$row["OPBALAIREJECT"])
					->setCellValue('E'.$rec,$row["OPBALAIREV"])
					->setCellValue('F'.$rec,$row["SPV1BALAITL"])
					->setCellValue('G'.$rec,$row["SPV1BALAIREJECT"])
					->setCellValue('H'.$rec,$row["SPV1BALAIREV"])
					->setCellValue('I'.$rec,$row["SPV2BALAITL"])
					->setCellValue('J'.$rec,$row["SPV2BALAIREJECT"])
					->setCellValue('K'.$rec,$row["SPV2BALAIREV"])
					->setCellValue('L'.$rec,$row["KABALAI"])
					->setCellValue('M'.$rec,$row["TLBALAI"])
					->setCellValue('N'.$rec,$row["OPPUSATDRAFT"])
					->setCellValue('O'.$rec,$row["OPPUSATREJECT"])
					->setCellValue('P'.$rec,$row["OPPUSATREV"])
					->setCellValue('Q'.$rec,$row["SPV1PUSATTL"])
					->setCellValue('R'.$rec,$row["SPV1PUSATREJECT"])
					->setCellValue('S'.$rec,$row["SPV1PUSATREV"])
					->setCellValue('T'.$rec,$row["SPV2PUSATTL"])
					->setCellValue('U'.$rec,$row["SPV2PUSATREJECT"])
					->setCellValue('V'.$rec,$row["SPV2PUSATREV"])
					->setCellValue('W'.$rec,$row["DIREKTUR"])
					->setCellValue('X'.$rec,$row["SELESAI"])
					->setCellValue('Y'.$rec,'=SUM(C'.$rec.':X'.$rec.')');
					$this->newphpexcel->set_detilstyle(array('A'.$rec,'B'.$rec,'C'.$rec,'D'.$rec,'E'.$rec,'F'.$rec,'G'.$rec,'H'.$rec,'I'.$rec,'J'.$rec,'K'.$rec,'L'.$rec,'M'.$rec,'N'.$rec,'O'.$rec,'P'.$rec,'Q'.$rec,'R'.$rec,'S'.$rec,'T'.$rec,'U'.$rec,'V'.$rec,'W'.$rec,'X'.$rec,'Y'.$rec));
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
					->setCellValue('I'.$rec,'=SUM(I8:I'.$total.')')
					->setCellValue('J'.$rec,'=SUM(J8:J'.$total.')')
					->setCellValue('K'.$rec,'=SUM(K8:K'.$total.')')
					->setCellValue('L'.$rec,'=SUM(L8:L'.$total.')')
					->setCellValue('M'.$rec,'=SUM(M8:M'.$total.')')
					->setCellValue('N'.$rec,'=SUM(N8:N'.$total.')')
					->setCellValue('O'.$rec,'=SUM(O8:O'.$total.')')
					->setCellValue('P'.$rec,'=SUM(P8:P'.$total.')')
					->setCellValue('Q'.$rec,'=SUM(Q8:Q'.$total.')')
					->setCellValue('R'.$rec,'=SUM(R8:R'.$total.')')
					->setCellValue('S'.$rec,'=SUM(S8:S'.$total.')')
					->setCellValue('T'.$rec,'=SUM(T8:T'.$total.')')
					->setCellValue('U'.$rec,'=SUM(U8:U'.$total.')')
					->setCellValue('V'.$rec,'=SUM(V8:V'.$total.')')
					->setCellValue('W'.$rec,'=SUM(W8:W'.$total.')')
					->setCellValue('X'.$rec,'=SUM(X8:X'.$total.')')
					->setCellValue('Y'.$rec,'=SUM(Y8:Y'.$total.')');
					$this->newphpexcel->set_detilstyle(array('A'.$rec,'B'.$rec,'C'.$rec,'D'.$rec,'E'.$rec,'F'.$rec,'G'.$rec,'H'.$rec,'I'.$rec,'J'.$rec,'K'.$rec,'L'.$rec,'M'.$rec,'N'.$rec,'O'.$rec,'P'.$rec,'Q'.$rec,'R'.$rec,'S'.$rec,'T'.$rec,'U'.$rec,'V'.$rec,'W'.$rec,'X'.$rec,'Y'.$rec));
			}else{
				$this->newphpexcel->getActiveSheet()->mergeCells('A8:Y8');
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A8','Data Tidak Ditemukan');
				$this->newphpexcel->set_detilstyle(array('A8'));
			}	
			ob_clean();
			$file = "REKAP_STATUS_KOMODITI_".date("YmdHis").".xls";
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
	
	function get_rekapkomoditi(){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$this->load->library('newphpexcel');
			$query = "SELECT * FROM(SELECT REPLACE(REPLACE(C.NAMA_BBPOM,'BALAI BESAR POM', 'BBPOM'),'BALAI POM','BPOM') 
AS NAMA_BBPOM, CASE B.KK_ID WHEN '001' THEN 'Obat' WHEN '005' THEN 'Narkotika' WHEN '006' THEN 'Psikotropika' WHEN '009' THEN 'Prekursor' WHEN '010' THEN 'Obat Tradisional' WHEN '011' THEN 'Produk Komplemen' WHEN '012' THEN 'Kosmetika' WHEN '013' THEN 'Produk Pangan' WHEN '015' THEN 'Bahan Berbahaya' WHEN '018' THEN 'Obat dan Produk Biologi' WHEN '019' THEN 'Bahan Obat' END AS KK_ID FROM T_PEMERIKSAAN A LEFT JOIN T_PEMERIKSAAN_KLASIFIKASI B ON A.PERIKSA_ID = B.PERIKSA_ID LEFT JOIN M_BBPOM C ON A.BBPOM_ID = C.BBPOM_ID AND A.STATUS NOT IN ('00') WHERE A.STATUS NOT IN ('00') ";
			if(trim($this->input->post('KOMODITI_AWAL')!="")){
				$query .= $sipt->main->find_where($query);
				$query .= " DATEDIFF(dy, 0, convert(DATETIME, A.AWAL_PERIKSA, 105)) >= DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('KOMODITI_AWAL')."', 105))";
				$awal = $this->input->post('KOMODITI_AWAL');
			}else{
				$query .= $sipt->main->find_where($query);
				$query .= " A.AWAL_PERIKSA > DATEADD(M, DATEDIFF(M,0,GETDATE()),0)";
				$awal = date('01/m/Y');
			}
			if(trim($this->input->post('KOMODITI_AKHIR')!="")){
				$query .= $sipt->main->find_where($query);
				$query .= " DATEDIFF(dy, 0, convert(DATETIME, A.AKHIR_PERIKSA, 105)) <= DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('KOMODITI_AKHIR')."', 105))";
				$akhir = $this->input->post('KOMODITI_AKHIR');
			}else{
				$query .= $sipt->main->find_where($query);
				$query .= " A.AKHIR_PERIKSA < DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,0,GETDATE())+1,0))";
				$akhir = date('t/m/Y');
			}
			if(in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')) || $this->newsession->userdata('SESS_BBPOM_ID') == "00"){
				if(trim($this->input->post('BBPOM_ID'))==""){
					$query .= "";
					$balai = 'Seluruh Balai';
				}else{
					$query .= $sipt->main->find_where($query);
					$query .= " A.BBPOM_ID = '".$this->input->post('BBPOM_ID')."'";
					$balai = $sipt->main->get_uraian("SELECT NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID = '".$this->input->post('BBPOM_ID')."'","NAMA_BBPOM");		
				}
			}else{
				$query .= $sipt->main->find_where($query);
				$query .= " A.BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'";
				$balai = $sipt->main->get_uraian("SELECT NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","NAMA_BBPOM");		
			}	  
			$query .= $sipt->main->find_where($query);
			$query .= " LEN(A.STATUS) > 2";
			$query .= ")DT PIVOT(COUNT(KK_ID) FOR KK_ID IN ([Obat],[Narkotika],[Psikotropika],[Prekursor],[Obat Tradisional],[Produk Komplemen],[Kosmetika],[Produk Pangan],[Bahan Berbahaya],[Obat dan Produk Biologi],[Bahan Obat])) PVT";
			$this->newphpexcel->getDefaultStyle()->getFont()->setName('Calibri')->setSize(10);
			$this->newphpexcel->setActiveSheetIndex(0);
			$this->newphpexcel->mergecell(array(array('A1','M1')), FALSE);
			$this->newphpexcel->mergecell(array(array('A6','A7'),array('B6','B7'),array('C6','M6')), TRUE);
			$this->newphpexcel->width(array(array('A',4),array('B',30),array('C',7),array('D',9),array('E',11),array('F',10),array('G',10),array('H',11),array('I',10),array('J',10),array('K',9),array('L',9)));
			$this->newphpexcel->set_bold(array('A1'));
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A1', 'REKAPITULASI JUMLAH PEMERIKSAAN KOMODITI')->setCellValue('A3', 'Pemeriksaan Awal')->setCellValue('C3', $awal)->setCellValue('A4', 'Pemeriksaan Akhir')->setCellValue('C4', $akhir)->setCellValue('A5', 'Balai Besar / Balai POM')->setCellValue('C5', $balai);
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A6','No.')->setCellValue('B6','BB / BPOM / UNIT DITWAS')->setCellValue('C6','Komoditi')->setCellValue('C7','Obat')->setCellValue('D7','Narkotika')->setCellValue('E7','Psikotropika')->setCellValue('F7','Prekursor')->setCellValue('G7','Obat Tradisional')->setCellValue('H7','Produk Komplemen')->setCellValue('I7','Kosmetika')->setCellValue('J7','Produk Pangan')->setCellValue('K7','Obat dan Produk Biologi')->setCellValue('L7','Bahan Obat')->setCellValue('M7','Bahan Berbahaya');
			$this->newphpexcel->headings(array('A7','B7','C7','D7','E7','F7','G7','H7','I7','J7','K7','L7','M7'));
			$this->newphpexcel->headings(array('A6','B6','C6','D6','E6','F6','G6','H6','I6','J6','K6','L6','M6'));
			$this->newphpexcel->set_wrap(array('C7','D7','E7','F7','G7','H7','I7','J7','K7','L7','M7'));
			$data = $sipt->main->get_result($query);
			if($data){
				$no=1;
				$rec = 8;
				foreach($query->result_array() as $row){
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A'.$rec,$no)
					->setCellValue('B'.$rec,strtoupper($row["NAMA_BBPOM"]))
					->setCellValue('C'.$rec,$row["Obat"])
					->setCellValue('D'.$rec,$row["Narkotika"])
					->setCellValue('E'.$rec,$row["Psikotropika"])
					->setCellValue('F'.$rec,$row["Prekursor"])
					->setCellValue('G'.$rec,$row["Obat Tradisional"])
					->setCellValue('H'.$rec,$row["Produk Komplemen"])
					->setCellValue('I'.$rec,$row["Kosmetika"])
					->setCellValue('J'.$rec,$row["Produk Pangan"])
					->setCellValue('K'.$rec,$row["Obat dan Produk Biologi"])
					->setCellValue('L'.$rec,$row["Bahan Obat"])
					->setCellValue('M'.$rec,$row["Bahan Berbahaya"]);
					$this->newphpexcel->set_detilstyle(array('A'.$rec,'B'.$rec,'C'.$rec,'D'.$rec,'E'.$rec,'F'.$rec,'G'.$rec,'H'.$rec,'I'.$rec,'J'.$rec,'K'.$rec,'L'.$rec,'M'.$rec));
					$rec++;
					$no++;
				}
				$total = $rec - 1;
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('B'.$rec,'Jumlah')
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
					->setCellValue('M'.$rec,'=SUM(M8:M'.$total.')');
					$this->newphpexcel->set_detilstyle(array('A'.$rec,'B'.$rec,'C'.$rec,'D'.$rec,'E'.$rec,'F'.$rec,'G'.$rec,'H'.$rec,'I'.$rec,'J'.$rec,'K'.$rec,'L'.$rec,'M'.$rec));
			}else{
				$this->newphpexcel->getActiveSheet()->mergeCells('A8:M8');
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A8','Data Tidak Ditemukan');
				$this->newphpexcel->set_detilstyle(array('A8'));
			}
			ob_clean();
			$file = "REKAP_KOMODITI_".date("YmdHis").".xls";
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
	
	function get_selesai(){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$this->load->library('newphpexcel');
			$sarana = "'".join("','", $this->newsession->userdata('SESS_SARANA'))."'";
			if($this->input->post('KK_ID') != "")
				$klas = " LEFT JOIN T_PEMERIKSAAN_KLASIFIKASI E ON E.PERIKSA_ID = B.PERIKSA_ID ";
			else
				$klas = "";
			$query = "SELECT LTRIM(RTRIM(UPPER(REPLACE(A.NAMA_SARANA,'-','')))) AS [NAMA SARANA], A.ALAMAT_1+' - '+C.NAMA_PROPINSI AS [ALAMAT], STUFF(dbo.GROUP_KK(B.PERIKSA_ID),1,1,'') AS KOMODITI, dbo.NAMA_JENIS_SARANA(B.JENIS_SARANA_ID) AS JENIS_SARANA, CONVERT(VARCHAR(10), B.AWAL_PERIKSA, 103) + ' s.d ' + CONVERT(VARCHAR(10), B.AKHIR_PERIKSA, 103) AS [TANGGAL PERIKSA], REPLACE(REPLACE(D.NAMA_BBPOM,'BALAI BESAR POM', 'BBPOM '),'BALAI POM','BPOM ') AS [BB/BPOM], B.HASIL FROM M_SARANA A LEFT JOIN T_PEMERIKSAAN B ON B.SARANA_ID = A.SARANA_ID LEFT JOIN M_PROPINSI C ON A.PROPINSI = C.PROPINSI_ID LEFT JOIN M_BBPOM D ON B.BBPOM_ID = D.BBPOM_ID $klas WHERE B.STATUS = '60010' AND B.JENIS_SARANA_ID IN ($sarana)";
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
			if(trim($this->input->post('KOTA')!="")) $query .= " AND A.KOTA  = '".$this->input->post('KOTA')."'";
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
			if($this->input->post('KK_ID') != "") $query .= " AND E.KK_ID = '".$this->input->post('KK_ID')."'";
			$query .= " ORDER BY 1 ASC";
			$this->newphpexcel->getDefaultStyle()->getFont()->setName('Calibri')->setSize(10);
			$this->newphpexcel->setActiveSheetIndex(0);
			$this->newphpexcel->mergecell(array(array('A1','H1'),array('A2','B2'),array('A3','B3'),array('A4','B4'),array('A5','B5')), FALSE);
			$this->newphpexcel->width(array(array('A',5),array('B',30),array('C',30),array('D',20),array('E',20),array('F',25),array('G',20),array('H',10)));
			$this->newphpexcel->set_bold(array('A1','C2','C5'));
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A1', 'LAPORAN PEMERIKSAAN SELESAI')->setCellValue('C2', $judul)->setCellValue('A3', 'Pemeriksaan Awal')->setCellValue('C3', $awal)->setCellValue('A4', 'Pemeriksaan Akhir')->setCellValue('C4', $akhir)->setCellValue('A5', 'Balai Besar / Balai POM')->setCellValue('C5', $balai);		
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
			$file = "PEMERIKSAAN_SELESAI_".date("YmdHis").".xls";
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
	
	function get_jmlsarana(){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$this->load->library('newphpexcel');
			$judul = $sipt->main->get_judul($this->input->post("JENIS"));
			$query = "SELECT LTRIM(RTRIM(UPPER(REPLACE(A.NAMA_SARANA,'-','')))) AS NAMA_SARANA, A.ALAMAT_1, A.ALAMAT_2, COUNT(B.PERIKSA_ID) AS JML FROM M_SARANA A LEFT JOIN T_PEMERIKSAAN B ON A.SARANA_ID = B.SARANA_ID WHERE B.JENIS_SARANA_ID = '".$this->input->post('JENIS') ."'";
			#$query = "SELECT UPPER(REPLACE(A.NAMA_SARANA,'-','')) AS NAMA_SARANA, CAST(CASE WHEN B.AWAL_PERIKSA = B.AWAL_PERIKSA THEN COUNT(B.PERIKSA_ID) ELSE COUNT(B.PERIKSA_ID) END AS bit) AS JML FROM M_SARANA A LEFT JOIN T_PEMERIKSAAN B ON A.SARANA_ID = B.SARANA_ID WHERE B.JENIS_SARANA_ID = '".$this->input->post('JENIS') ."'";
			
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
			if($this->input->post('NAMA_SARANA') != ""){
				$query .= " AND A.NAMA_SARANA LIKE '%".$this->input->post('NAMA_SARANA')."%'";
				$nama = $this->input->post('NAMA_SARANA');
			}else{
				$nama = "Seluruh Sarana pada Jenis Sarana : " . $judul;
			}
			$query .= " AND B.STATUS NOT IN ('00') ";
			$query .= " GROUP BY A.NAMA_SARANA, A.ALAMAT_1, A.ALAMAT_2 ORDER BY 1 ASC";
			$this->newphpexcel->getDefaultStyle()->getFont()->setName('Calibri')->setSize(10);
			$this->newphpexcel->setActiveSheetIndex(0);
			$this->newphpexcel->mergecell(array(array('A1','D1'),array('C6','H6')), FALSE);
			$this->newphpexcel->width(array(array('A',5),array('B',50),array('C',75),array('D',17)));
			$this->newphpexcel->set_bold(array('A1','C2','C5'));
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A1', 'REKAP JUMLAH SARANA YANG DIPERIKSA')->setCellValue('C1','Jenis Sarana')->setCellValue('C2', $judul)->setCellValue('A3', 'Pemeriksaan Awal')->setCellValue('C3', $awal)->setCellValue('A4', 'Pemeriksaan Akhir')->setCellValue('C4', $akhir)->setCellValue('A5', 'Balai Besar / Balai POM')->setCellValue('C5', $balai)->setCellValue('A6', 'Berdasarkan Kata Kunci Sarana')->setCellValue('C6', $nama);		
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A8','No.')->setCellValue('B8','Nama Sarana Yang Diperiksa')->setCellValue('C8','Alamat Sarana')->setCellValue('D8','Jumlah Diperiksa');
			$this->newphpexcel->headings(array('A8','B8','C8','D8'));
			$this->newphpexcel->set_wrap(array('B','C','D'));
			$data = $sipt->main->get_result($query);
			if($data){
				$no=1;
				$rec = 9;
				foreach($query->result_array() as $row){
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A'.$rec,$no)
					->setCellValue('B'.$rec,$row["NAMA_SARANA"])
					->setCellValue('C'.$rec,$row["ALAMAT_1"])
					->setCellValue('D'.$rec,$row["JML"]);
					$this->newphpexcel->set_detilstyle(array('A'.$rec,'B'.$rec,'C'.$rec,'D'.$rec));
					$rec++;
					$no++;
				}
			}else{
				$this->newphpexcel->getActiveSheet()->mergeCells('A9:D9');
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A9','Data Tidak Ditemukan');
				$this->newphpexcel->set_detilstyle(array('A9'));
			}
			ob_clean();
			$file = "REKAP_PERIKSA_SARANA".date("YmdHis").".xls";
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
	
	function get_rhpkjenis(){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$this->load->library('newphpexcel');
			$query = "SELECT *, ([PRODUKSI] + [DISTRIBUSI] + [PELAYANAN]) as TOTAL 
					 FROM(SELECT REPLACE(REPLACE(C.NAMA_BBPOM,'BALAI BESAR POM', 'BBPOM'),'BALAI POM','BPOM') AS NAMA_BBPOM, 
					 CASE WHEN LEFT(A.JENIS_SARANA_ID,2) = '01' THEN 'PRODUKSI' 
					 WHEN LEFT(A.JENIS_SARANA_ID,2) = '02' THEN 'DISTRIBUSI'
	 				 WHEN LEFT(A.JENIS_SARANA_ID,2) = '03' THEN 'PELAYANAN'
	 				 END AS JENIS_SARANA FROM T_PEMERIKSAAN A LEFT JOIN M_BBPOM C ON A.BBPOM_ID = C.BBPOM_ID ";
			if(trim($this->input->post('STATUS_AWAL')!="")){
				$query .= $sipt->main->find_where($query);
				$query .= " DATEDIFF(dy, 0, convert(DATETIME, A.AWAL_PERIKSA, 105)) >= DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('STATUS_AWAL')."', 105))";
				$awal = $this->input->post('STATUS_AWAL');
			}else{
				$query .= $sipt->main->find_where($query);
				$query .= " A.AWAL_PERIKSA > DATEADD(M, DATEDIFF(M,0,GETDATE()),0)";
				$awal = date('01/m/Y');
			}
			if(trim($this->input->post('STATUS_AKHIR')!="")){
				$query .= $sipt->main->find_where($query);
				$query .= " DATEDIFF(dy, 0, convert(DATETIME, A.AKHIR_PERIKSA, 105)) <= DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('STATUS_AKHIR')."', 105))";
				$akhir = $this->input->post('STATUS_AKHIR');
			}else{
				$query .= $sipt->main->find_where($query);
				$query .= " A.AKHIR_PERIKSA < DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,0,GETDATE())+1,0))";
				$akhir = date('t/m/Y');
			}
			if(in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')) || $this->newsession->userdata('SESS_BBPOM_ID') == "00"){
				if(trim($this->input->post('BBPOM_ID'))==""){
					$query .= "";
					$balai = 'Seluruh Balai';
				}else{
					$query .= $sipt->main->find_where($query);
					$query .= " A.BBPOM_ID = '".$this->input->post('BBPOM_ID')."'";
					$balai = $sipt->main->get_uraian("SELECT NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID = '".$this->input->post('BBPOM_ID')."'","NAMA_BBPOM");		
				}
			}else{
				$query .= $sipt->main->find_where($query);
				$query .= " A.BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'";
				$balai = $sipt->main->get_uraian("SELECT NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","NAMA_BBPOM");		
			}
			
			$query .= $sipt->main->find_where($query);
			$query .= " LEN(A.STATUS) > 2";
			
			$query .= ") DT PIVOT(COUNT(JENIS_SARANA) FOR JENIS_SARANA IN ([PRODUKSI], [DISTRIBUSI], [PELAYANAN])) PVT";
			$this->newphpexcel->getDefaultStyle()->getFont()->setName('Calibri')->setSize(10);
			$this->newphpexcel->setActiveSheetIndex(0);
			$this->newphpexcel->mergecell(array(array('A1','F1')), FALSE);
			$this->newphpexcel->mergecell(array(array('A6','A7'),array('B6','B7'),array('C6','F6')), TRUE);
			$this->newphpexcel->width(array(array('A',4),array('B',30),array('C',10),array('D',10),array('E',10),array('F',10)));
			$this->newphpexcel->set_bold(array('A1'));
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A1', 'RHPK PER JENIS SARANA')->setCellValue('A3', 'Pemeriksaan Awal')->setCellValue('C3', $awal)->setCellValue('A4', 'Pemeriksaan Akhir')->setCellValue('C4', $akhir)->setCellValue('A5', 'Balai Besar / Balai POM')->setCellValue('C5', $balai);
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A6','No.')->setCellValue('B6','BB / BPOM / UNIT DITWAS')->setCellValue('C6','Jenis Sarana')->setCellValue('C7','Produksi')->setCellValue('D7','Distribusi')->setCellValue('E7','Pelayanan')->setCellValue('F7','Total');
			$this->newphpexcel->headings(array('A7','B7','C7','D7','E7','F7'));
			$this->newphpexcel->headings(array('A6','B6','C6','D6','E6','F6'));
			$this->newphpexcel->set_wrap(array('C7','D7','E7'));
			$data = $sipt->main->get_result($query);
			if($data){
				$no=1;
				$rec = 8;
				foreach($query->result_array() as $row){
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A'.$rec,$no)
					->setCellValue('B'.$rec,strtoupper($row["NAMA_BBPOM"]))
					->setCellValue('C'.$rec,$row["PRODUKSI"])
					->setCellValue('D'.$rec,$row["DISTRIBUSI"])
					->setCellValue('E'.$rec,$row["PELAYANAN"])
					->setCellValue('F'.$rec,$row["TOTAL"]);
					$this->newphpexcel->set_detilstyle(array('A'.$rec,'B'.$rec,'C'.$rec,'D'.$rec,'E'.$rec,'F'.$rec));
					$rec++;
					$no++;
				}
				$total = $rec - 1;
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A'.$rec,$no)
					->setCellValue('B'.$rec,'Jumlah')
					->setCellValue('C'.$rec,'=SUM(C8:C'.$total.')')
					->setCellValue('D'.$rec,'=SUM(D8:D'.$total.')')
					->setCellValue('E'.$rec,'=SUM(E8:E'.$total.')')
					->setCellValue('F'.$rec,'=SUM(F8:F'.$total.')');
					$this->newphpexcel->set_detilstyle(array('A'.$rec,'B'.$rec,'C'.$rec,'D'.$rec,'E'.$rec,'F'.$rec));
			}else{
				$this->newphpexcel->getActiveSheet()->mergeCells('A8:F8');
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A8','Data Tidak Ditemukan');
				$this->newphpexcel->set_detilstyle(array('A8','B8','C8','D8','E8','F8'));
			}	
			ob_clean();
			$file = "RHPK_PER_JENIS_SARANA_".date("YmdHis").".xls";
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