<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);
class Dashboard_act extends Model{
	function get_chart(){
		if(array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('10', $this->newsession->userdata('SESS_KODE_ROLE')) || $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$disinput = array("JENISDIS","NAMADIS");
			$jenis = $sipt->main->get_jenis_sarana($this->newsession->userdata("SESS_USER_ID"), $disinput);
			$arrdata = array('idjudul' => 'judulpmnsarana',
							 'caption_header' => 'Rekapitulasi Grafik Pemeriksaan Sarana',
							 'act' => site_url().'/utility/grafik/pemeriksaan/',
							 'jenis' => $jenis,
							 'disinput' => $disinput);
			return $arrdata;
		}else{
			$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
		}
		
	}
	
	function top_chart($periode){
		if($this->newsession->userdata('LOGGED_IN') && array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('10', $this->newsession->userdata('SESS_KODE_ROLE'))){
			$sipt = get_instance();
			$sipt->load->model("main","main", true);
			$tgl = $this->functions->weekend();
			$filter = "";
			$top = "";
			$cek = FALSE;
			if($periode=="1"){
				$filter = "AND B.AWAL_PERIKSA BETWEEN '".$tgl['awal']."' AND '".$tgl['akhir']."'";
				$top = "TOP 10";
				$judul = "10 Top Pemeriksaan Periode Minggu Ini";
				$cek = TRUE;
			}else if($periode=="2"){
				$filter = "AND B.AWAL_PERIKSA BETWEEN '".date('m-01-Y')."' AND '".date('m-t-Y')."'";
				$top = "TOP 10";
				$judul = "10 Top Pemeriksaan Periode Bulan Ini";
				$cek = TRUE;
			}else if($periode=="3"){
				$filter = "AND YEAR(B.AWAL_PERIKSA) = '".date('Y')."'";
				$top = "TOP 10";
				$judul = "10 Top Pemeriksaan Periode Tahun Ini";
				$cek = TRUE;
			}else if($periode=="all"){
				$filter = "";
				$top = "TOP 10";
				$judul = "10 Top Rekapitulasi Semua Pemeriksaan Sarana";
			}
			$data = "SELECT $top REPLACE(REPLACE(A.NAMA_BBPOM,'BALAI BESAR POM DI', ''),'BALAI POM DI ','') 
AS NAMA_BBPOM, COUNT(B.BBPOM_ID) AS JUMLAH FROM T_PEMERIKSAAN B LEFT JOIN M_BBPOM A ON B.BBPOM_ID = A.BBPOM_ID WHERE LEN(B.STATUS) > 2 AND A.BBPOM_ID NOT IN ('00','99') $filter GROUP BY NAMA_BBPOM, A.BBPOM_ID ORDER BY 2 DESC";
			$data = $this->db->query($data);
			if($data){
				if($data->num_rows()>0){
					$ret = "";
					foreach($data->result_array() as $a => $row){
						if($a==0) $title = $judul;
						$sess['chart'][$title]['status'][] = $row['NAMA_BBPOM'];
						if($exssess = $this->newsession->userdata('chart')){
							if($exssess = $exssess[$title]['data']){
								if($a==0){
									if(array_key_exists($date, $exssess)){
										$exssess[$date] = array();
									}else if(count($exssess)>2){
										$exssess = array_reverse($exssess);
										array_pop($exssess);
										$exssess = array_reverse($exssess);
									}
									$sess['chart'][$title]['data'] = $exssess;
								}
							}
						}
						$sess['chart'][$title]['data'][$date][] = $row['JUMLAH'];
					}
					$this->newsession->set_userdata($sess);
				}
			}
			$sess = $sess['chart'][$title];
			echo $title."|";
			print(join(";", $sess['status'])."|");
			$sess = $sess['data'];
			$temp = "";
			foreach($sess as $a => $b){
				echo "$temp$a;";
				print(join(";", $b));
				$temp = "@";
			}
		}
	}

	function all_jenis(){
		if(array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('10', $this->newsession->userdata('SESS_KODE_ROLE')) || $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$filter = "";
			if(trim($this->input->post('sarana-awal')!=""))
				$filter .= " AND DATEDIFF(dy, 0, convert(DATETIME, AWAL_PERIKSA, 105)) >= DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('sarana-awal')."', 105))";
			else
				$filter .= " AND AWAL_PERIKSA > DATEADD(M, DATEDIFF(M,0,GETDATE()),0)";
				
			if(trim($this->input->post('sarana-akhir')!=""))
				$filter .= " AND DATEDIFF(dy, 0, convert(DATETIME, AKHIR_PERIKSA, 105)) >= DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('sarana-awal')."', 105))";
			else
				$filter .= " AND AKHIR_PERIKSA < DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,0,GETDATE())+1,0))";
			$query = "SELECT(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE LEFT(JENIS_SARANA_ID, 2) = '01' AND 
LEN(STATUS) > 2 AND BBPOM_ID LIKE '%9_' $filter) AS PRODUKSI_PUSAT,
(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE LEFT(JENIS_SARANA_ID, 2) = '01' AND 
LEN(STATUS) > 2  AND BBPOM_ID NOT LIKE '%9_' $filter) AS PRODUKSI_BALAI,
(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE LEFT(JENIS_SARANA_ID, 2) = '02' AND 
LEN(STATUS) > 2  AND BBPOM_ID LIKE '%9_' $filter) AS DISTRIBUSI_PUSAT,
(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE LEFT(JENIS_SARANA_ID, 2) = '02' AND 
LEN(STATUS) > 2  AND BBPOM_ID NOT LIKE '%9_' $filter) AS DISTRIBUSI_BALAI,
(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE LEFT(JENIS_SARANA_ID, 2) = '03' AND 
LEN(STATUS) > 2  AND BBPOM_ID LIKE '%9_' $filter) AS PELAYANAN_PUSAT,
(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE LEFT(JENIS_SARANA_ID, 2) = '03' AND 
LEN(STATUS) > 2  AND BBPOM_ID NOT LIKE '%9_' $filter) AS PELAYANAN_BALAI";
			$data = $sipt->main->get_result($query);
			if($data){
				$ret [] = array("","Produksi - Pusat","Produksi - Balai","Distribusi - Pusat","Distribusi - Balai","Pelayanan - Pusat","Pelayanan - Balai");
				foreach($query->result_array() as $row){
					$ret[] = array("",$row['PRODUKSI_PUSAT'],$row['PRODUKSI_BALAI'],$row['DISTRIBUSI_PUSAT'],$row['DISTRIBUSI_BALAI'],$row['PELAYANAN_PUSAT'],$row['PELAYANAN_BALAI']);
				}
				echo json_encode($ret);
			}
		}
	}
	
	function detil($jenis){
		if(array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('10', $this->newsession->userdata('SESS_KODE_ROLE')) || $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$func = "chart_".$jenis;
			$cek_napza = substr($jenis, 3, 4);
			if($cek_napza != "N")
				$ret = $this->$func($jenis, $this->input->post('sarana-awal'), $this->input->post('sarana-akhir'));
			else
				$ret = $this->napza($jenis, $this->input->post('sarana-awal'), $this->input->post('sarana-akhir'));
			echo json_encode($ret);
		}
	}
	
	
	function chart_01OO($jsarana, $awal, $akhir){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$filter = "";
			$filter2 = "";
			if(trim($awal)!=""){
				$filter .= " AND DATEDIFF(dy, 0, convert(DATETIME, AWAL_PERIKSA, 105)) >= DATEDIFF(dy, 0, convert(DATETIME, '".$awal."', 105))";
				$filter2 .= " AND DATEDIFF(dy, 0, convert(DATETIME, A.AWAL_PERIKSA, 105)) >= DATEDIFF(dy, 0, convert(DATETIME, '".$awal."', 105))";
			}
			else{
				$filter .= " AND AWAL_PERIKSA > DATEADD(M, DATEDIFF(M,0,GETDATE()),0)";
				$filter2 .= " AND A.AWAL_PERIKSA > DATEADD(M, DATEDIFF(M,0,GETDATE()),0)";
			}
				
			if(trim($akhir)!=""){
				$filter .= " AND DATEDIFF(dy, 0, convert(DATETIME, AKHIR_PERIKSA, 105)) <= DATEDIFF(dy, 0, convert(DATETIME, '".$akhir."', 105))";
				$filter2 .= " AND DATEDIFF(dy, 0, convert(DATETIME, A.AKHIR_PERIKSA, 105)) <= DATEDIFF(dy, 0, convert(DATETIME, '".$akhir."', 105))";
			}else{
				$filter .= " AND AKHIR_PERIKSA < DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,0,GETDATE())+1,0))";
				$filter2 .= " AND A.AKHIR_PERIKSA < DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,0,GETDATE())+1,0))";
			}
			$query = "SELECT DISTINCT(B.NAMA_JENIS_SARANA) AS [JENIS SARANA], 
	(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE JENIS_SARANA_ID = '".$jsarana."' $filter) AS JMLPERIKSA,
	(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'MK' AND JENIS_SARANA_ID = '".$jsarana."' $filter) AS MK,
	(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'Major' AND JENIS_SARANA_ID = '".$jsarana."' $filter) AS MAJOR,
	(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'Minor' AND JENIS_SARANA_ID = '".$jsarana."' $filter) AS MINOR,
	(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'Kritikal' AND JENIS_SARANA_ID = '".$jsarana."' $filter) AS KRITIKAL
	FROM T_PEMERIKSAAN A LEFT JOIN M_JENIS_SARANA B ON A.JENIS_SARANA_ID = B.JENIS_SARANA_ID WHERE A.JENIS_SARANA_ID = '".$jsarana."' $filter2";
			$data = $sipt->main->get_result($query);
			if($data){
				$arrdata[] = array("", "Diperiksa", "MK", "Major", "Minor","Kritikal");
				foreach($query->result_array() as $row){
					$arrdata[] = array($row["JENIS SARANA"],$row["JMLPERIKSA"],$row["MK"],$row["MAJOR"],$row["MINOR"],$row["KRITIKAL"]);
				}
			}else{
				$arrdata [] = array("","Diperiksa","MK","Major","Minor","Kritikal");
				$arrdata [] = array("",0,0,0,0,0);
			}
			return $arrdata;
		}
	}
	
	function chart_01HH($jsarana, $awal, $akhir){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$filter = "";
			$filter2 = "";
			if(trim($awal)!=""){
				$filter .= " AND DATEDIFF(dy, 0, convert(DATETIME, AWAL_PERIKSA, 105)) >= DATEDIFF(dy, 0, convert(DATETIME, '".$awal."', 105))";
				$filter2 .= " AND DATEDIFF(dy, 0, convert(DATETIME, A.AWAL_PERIKSA, 105)) >= DATEDIFF(dy, 0, convert(DATETIME, '".$awal."', 105))";
			}
			else{
				$filter .= " AND AWAL_PERIKSA > DATEADD(M, DATEDIFF(M,0,GETDATE()),0)";
				$filter2 .= " AND A.AWAL_PERIKSA > DATEADD(M, DATEDIFF(M,0,GETDATE()),0)";
			}
				
			if(trim($akhir)!=""){
				$filter .= " AND DATEDIFF(dy, 0, convert(DATETIME, AKHIR_PERIKSA, 105)) <= DATEDIFF(dy, 0, convert(DATETIME, '".$akhir."', 105))";
				$filter2 .= " AND DATEDIFF(dy, 0, convert(DATETIME, A.AKHIR_PERIKSA, 105)) <= DATEDIFF(dy, 0, convert(DATETIME, '".$akhir."', 105))";
			}else{
				$filter .= " AND AKHIR_PERIKSA < DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,0,GETDATE())+1,0))";
				$filter2 .= " AND A.AKHIR_PERIKSA < DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,0,GETDATE())+1,0))";
			}
			$query = "SELECT DISTINCT(B.NAMA_JENIS_SARANA) AS [JENIS SARANA], (SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE JENIS_SARANA_ID = '".$jsarana."' $filter) AS JMLPERIKSA,
	(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'MK' AND JENIS_SARANA_ID = '".$jsarana."' $filter) AS MK,
	(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'TMK' AND JENIS_SARANA_ID = '".$jsarana."' $filter) AS TMK,
	(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'TTP' AND JENIS_SARANA_ID = '".$jsarana."' $filter) AS TUTUP FROM T_PEMERIKSAAN A LEFT JOIN M_JENIS_SARANA B ON A.JENIS_SARANA_ID = B.JENIS_SARANA_ID WHERE A.JENIS_SARANA_ID = '".$jsarana."' $filter2";
			$data = $sipt->main->get_result($query);
			if($data){
				$arrdata [] = array("","Diperiksa","MK","TMK","TUTUP");
				foreach($query->result_array() as $row){
					$arrdata[] = array($row["JENIS SARANA"],$row['JMLPERIKSA'],$row['MK'],$row['TMK'],$row['TUTUP']);
				}
			}else{
				$arrdata [] = array("","Diperiksa","MK","TMK","TUTUP");
				$arrdata [] = array("",0,0,0,0);
			}
			return $arrdata;
		}
	}
	
	
	function chart_01PK($jsarana, $awal, $akhir){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$filter = "";
			$filter2 = "";
			if(trim($awal)!=""){
				$filter .= " AND DATEDIFF(dy, 0, convert(DATETIME, AWAL_PERIKSA, 105)) >= DATEDIFF(dy, 0, convert(DATETIME, '".$awal."', 105))";
				$filter2 .= " AND DATEDIFF(dy, 0, convert(DATETIME, A.AWAL_PERIKSA, 105)) >= DATEDIFF(dy, 0, convert(DATETIME, '".$awal."', 105))";
			}
			else{
				$filter .= " AND AWAL_PERIKSA > DATEADD(M, DATEDIFF(M,0,GETDATE()),0)";
				$filter2 .= " AND A.AWAL_PERIKSA > DATEADD(M, DATEDIFF(M,0,GETDATE()),0)";
			}
				
			if(trim($akhir)!=""){
				$filter .= " AND DATEDIFF(dy, 0, convert(DATETIME, AKHIR_PERIKSA, 105)) <= DATEDIFF(dy, 0, convert(DATETIME, '".$akhir."', 105))";
				$filter2 .= " AND DATEDIFF(dy, 0, convert(DATETIME, A.AKHIR_PERIKSA, 105)) <= DATEDIFF(dy, 0, convert(DATETIME, '".$akhir."', 105))";
			}else{
				$filter .= " AND AKHIR_PERIKSA < DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,0,GETDATE())+1,0))";
				$filter2 .= " AND A.AKHIR_PERIKSA < DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,0,GETDATE())+1,0))";
			}
			$query = "SELECT DISTINCT(B.NAMA_JENIS_SARANA) AS [JENIS SARANA], (SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE JENIS_SARANA_ID = '".$jsarana."' $filter) AS JMLPERIKSA,
	(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'MK' AND JENIS_SARANA_ID = '".$jsarana."' $filter) AS MK,
	(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'TMK' AND JENIS_SARANA_ID = '".$jsarana."' $filter) AS TMK,
	(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'TTP' AND JENIS_SARANA_ID = '".$jsarana."' $filter) AS TUTUP FROM T_PEMERIKSAAN A LEFT JOIN M_JENIS_SARANA B ON A.JENIS_SARANA_ID = B.JENIS_SARANA_ID WHERE A.JENIS_SARANA_ID = '".$jsarana."' $filter2";
			$data = $sipt->main->get_result($query);
			if($data){
				$arrdata [] = array("","Diperiksa","MK","TMK","TUTUP");
				foreach($query->result_array() as $row){
					$arrdata[] = array($row["JENIS SARANA"],$row['JMLPERIKSA'],$row['MK'],$row['TMK'],$row['TUTUP']);
				}
			}else{
				$arrdata [] = array("","Diperiksa","MK","TMK","TUTUP");
				$arrdata [] = array("",0,0,0,0);
			}
			return $arrdata;
		}
	}
	
	function chart_01KO($jsarana, $awal, $akhir){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$filter = "";
			$filter2 = "";
			if(trim($awal)!=""){
				$filter .= " AND DATEDIFF(dy, 0, convert(DATETIME, AWAL_PERIKSA, 105)) >= DATEDIFF(dy, 0, convert(DATETIME, '".$awal."', 105))";
				$filter2 .= " AND DATEDIFF(dy, 0, convert(DATETIME, A.AWAL_PERIKSA, 105)) >= DATEDIFF(dy, 0, convert(DATETIME, '".$awal."', 105))";
			}
			else{
				$filter .= " AND AWAL_PERIKSA > DATEADD(M, DATEDIFF(M,0,GETDATE()),0)";
				$filter2 .= " AND A.AWAL_PERIKSA > DATEADD(M, DATEDIFF(M,0,GETDATE()),0)";
			}
				
			if(trim($akhir)!=""){
				$filter .= " AND DATEDIFF(dy, 0, convert(DATETIME, AKHIR_PERIKSA, 105)) <= DATEDIFF(dy, 0, convert(DATETIME, '".$akhir."', 105))";
				$filter2 .= " AND DATEDIFF(dy, 0, convert(DATETIME, A.AKHIR_PERIKSA, 105)) <= DATEDIFF(dy, 0, convert(DATETIME, '".$akhir."', 105))";
			}else{
				$filter .= " AND AKHIR_PERIKSA < DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,0,GETDATE())+1,0))";
				$filter2 .= " AND A.AKHIR_PERIKSA < DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,0,GETDATE())+1,0))";
			}
			$query = "SELECT DISTINCT(B.NAMA_JENIS_SARANA) AS [JENIS SARANA], (SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE JENIS_SARANA_ID = '".$jsarana."' $filter) AS JMLPERIKSA,
	(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'MK' AND JENIS_SARANA_ID = '".$jsarana."' $filter) AS MK,
	(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'TMK' AND JENIS_SARANA_ID = '".$jsarana."' $filter) AS TMK,
	(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'TTP' AND JENIS_SARANA_ID = '".$jsarana."' $filter) AS TUTUP FROM T_PEMERIKSAAN A LEFT JOIN M_JENIS_SARANA B ON A.JENIS_SARANA_ID = B.JENIS_SARANA_ID WHERE A.JENIS_SARANA_ID = '".$jsarana."' $filter2";
			$data = $sipt->main->get_result($query);
			if($data){
				$arrdata [] = array("","Diperiksa","MK","TMK","TUTUP");
				foreach($query->result_array() as $row){
					$arrdata[] = array($row["JENIS SARANA"],$row['JMLPERIKSA'],$row['MK'],$row['TMK'],$row['TUTUP']);
				}
			}else{
				$arrdata [] = array("","Diperiksa","MK","TMK","TUTUP");
				$arrdata [] = array("",0,0,0,0);
			}
			return $arrdata;
		}
	}
	
	function chart_01JJ($jsarana, $awal, $akhir){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$filter = "";
			$filter2 = "";
			if(trim($awal)!=""){
				$filter .= " AND DATEDIFF(dy, 0, convert(DATETIME, AWAL_PERIKSA, 105)) >= DATEDIFF(dy, 0, convert(DATETIME, '".$awal."', 105))";
				$filter2 .= " AND DATEDIFF(dy, 0, convert(DATETIME, A.AWAL_PERIKSA, 105)) >= DATEDIFF(dy, 0, convert(DATETIME, '".$awal."', 105))";
			}
			else{
				$filter .= " AND AWAL_PERIKSA > DATEADD(M, DATEDIFF(M,0,GETDATE()),0)";
				$filter2 .= " AND A.AWAL_PERIKSA > DATEADD(M, DATEDIFF(M,0,GETDATE()),0)";
			}
				
			if(trim($akhir)!=""){
				$filter .= " AND DATEDIFF(dy, 0, convert(DATETIME, AKHIR_PERIKSA, 105)) <= DATEDIFF(dy, 0, convert(DATETIME, '".$akhir."', 105))";
				$filter2 .= " AND DATEDIFF(dy, 0, convert(DATETIME, A.AKHIR_PERIKSA, 105)) <= DATEDIFF(dy, 0, convert(DATETIME, '".$akhir."', 105))";
			}else{
				$filter .= " AND AKHIR_PERIKSA < DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,0,GETDATE())+1,0))";
				$filter2 .= " AND A.AKHIR_PERIKSA < DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,0,GETDATE())+1,0))";
			}

			$query = "SELECT DISTINCT(B.NAMA_JENIS_SARANA) AS [JENIS SARANA], 
(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE JENIS_SARANA_ID = '".$jsarana."' AND JENIS_SARANA_ID = A.JENIS_SARANA_ID $filter) AS JMLPERIKSA,
(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'A' AND JENIS_SARANA_ID = '".$jsarana."' AND JENIS_SARANA_ID = A.JENIS_SARANA_ID $filter) AS [BAIK SEKALI],
(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'B' AND JENIS_SARANA_ID = '".$jsarana."' AND JENIS_SARANA_ID = A.JENIS_SARANA_ID $filter) AS [BAIK],
(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'C' AND JENIS_SARANA_ID = '".$jsarana."' AND JENIS_SARANA_ID = A.JENIS_SARANA_ID $filter) AS KURANG,
(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'D' AND JENIS_SARANA_ID = '".$jsarana."' AND JENIS_SARANA_ID = A.JENIS_SARANA_ID $filter) AS JELEK
FROM T_PEMERIKSAAN A LEFT JOIN M_JENIS_SARANA B ON A.JENIS_SARANA_ID = B.JENIS_SARANA_ID
WHERE A.JENIS_SARANA_ID = '".$jsarana."' $filter2";
			$data = $sipt->main->get_result($query);
			if($data){
				$arrdata[] = array("", "Diperiksa", "BAIK SEKALI", "BAIK", "KURANG","JELEK");
				foreach($query->result_array() as $row){
					  $arrdata[] = array($row["JENIS SARANA"],$row["JMLPERIKSA"],$row["BAIK SEKALI"],$row["BAIK"],$row["KURANG"],$row["JELEK"]);
				}
			}else{
				$arrdata[] = array("", "Diperiksa", "BAIK SEKALI", "BAIK", "KURANG","JELEK");
				$arrdata[] = array("", 0, 0, 0, 0,0);
			}
			return $arrdata;
		}
	}
	
	function chart_02PG($jsarana, $awal, $akhir){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$filter = "";
			$filter2 = "";
			if(trim($awal)!=""){
				$filter .= " AND DATEDIFF(dy, 0, convert(DATETIME, AWAL_PERIKSA, 105)) >= DATEDIFF(dy, 0, convert(DATETIME, '".$awal."', 105))";
				$filter2 .= " AND DATEDIFF(dy, 0, convert(DATETIME, A.AWAL_PERIKSA, 105)) >= DATEDIFF(dy, 0, convert(DATETIME, '".$awal."', 105))";
			}
			else{
				$filter .= " AND AWAL_PERIKSA > DATEADD(M, DATEDIFF(M,0,GETDATE()),0)";
				$filter2 .= " AND A.AWAL_PERIKSA > DATEADD(M, DATEDIFF(M,0,GETDATE()),0)";
			}
				
			if(trim($akhir)!=""){
				$filter .= " AND DATEDIFF(dy, 0, convert(DATETIME, AKHIR_PERIKSA, 105)) <= DATEDIFF(dy, 0, convert(DATETIME, '".$akhir."', 105))";
				$filter2 .= " AND DATEDIFF(dy, 0, convert(DATETIME, A.AKHIR_PERIKSA, 105)) <= DATEDIFF(dy, 0, convert(DATETIME, '".$akhir."', 105))";
			}else{
				$filter .= " AND AKHIR_PERIKSA < DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,0,GETDATE())+1,0))";
				$filter2 .= " AND A.AKHIR_PERIKSA < DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,0,GETDATE())+1,0))";
			}

			$query = "SELECT DISTINCT(B.NAMA_JENIS_SARANA) AS [JENIS SARANA], 
(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE JENIS_SARANA_ID = '".$jsarana."' AND JENIS_SARANA_ID = A.JENIS_SARANA_ID $filter) AS JMLPERIKSA,
(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'BAIK' AND JENIS_SARANA_ID = '".$jsarana."' AND JENIS_SARANA_ID = A.JENIS_SARANA_ID $filter) AS BAIK,
(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'CUKUP' AND JENIS_SARANA_ID = '".$jsarana."' AND JENIS_SARANA_ID = A.JENIS_SARANA_ID $filter) AS CUKUP,
(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'KURANG' AND JENIS_SARANA_ID = '".$jsarana."' AND JENIS_SARANA_ID = A.JENIS_SARANA_ID $filter) AS KURANG
FROM T_PEMERIKSAAN A LEFT JOIN M_JENIS_SARANA B ON A.JENIS_SARANA_ID = B.JENIS_SARANA_ID
WHERE A.JENIS_SARANA_ID = '".$jsarana."' $filter2";
			$data = $sipt->main->get_result($query);
			if($data){
				$arrdata[] = array("", "Diperiksa", "BAIK", "CUKUP", "KURANG");
				foreach($query->result_array() as $row){
					  $arrdata[] = array($row["JENIS SARANA"],$row["JMLPERIKSA"],$row["BAIK"],$row["CUKUP"],$row["KURANG"]);
				}
			}else{
				$arrdata[] = array("", "Diperiksa", "BAIK", "CUKUP", "KURANG");
				$arrdata[] = array("",0,0,0,0);
			}
			return $arrdata;
		}
	}
	
	function chart_02PR($jsarana, $awal, $akhir){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$filter = "";
			$filter2 = "";
			if(trim($awal)!=""){
				$filter .= " AND DATEDIFF(dy, 0, convert(DATETIME, AWAL_PERIKSA, 105)) >= DATEDIFF(dy, 0, convert(DATETIME, '".$awal."', 105))";
				$filter2 .= " AND DATEDIFF(dy, 0, convert(DATETIME, A.AWAL_PERIKSA, 105)) >= DATEDIFF(dy, 0, convert(DATETIME, '".$awal."', 105))";
			}
			else{
				$filter .= " AND AWAL_PERIKSA > DATEADD(M, DATEDIFF(M,0,GETDATE()),0)";
				$filter2 .= " AND A.AWAL_PERIKSA > DATEADD(M, DATEDIFF(M,0,GETDATE()),0)";
			}
				
			if(trim($akhir)!=""){
				$filter .= " AND DATEDIFF(dy, 0, convert(DATETIME, AKHIR_PERIKSA, 105)) <= DATEDIFF(dy, 0, convert(DATETIME, '".$akhir."', 105))";
				$filter2 .= " AND DATEDIFF(dy, 0, convert(DATETIME, A.AKHIR_PERIKSA, 105)) <= DATEDIFF(dy, 0, convert(DATETIME, '".$akhir."', 105))";
			}else{
				$filter .= " AND AKHIR_PERIKSA < DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,0,GETDATE())+1,0))";
				$filter2 .= " AND A.AKHIR_PERIKSA < DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,0,GETDATE())+1,0))";
			}

			$query = "SELECT DISTINCT(B.NAMA_JENIS_SARANA) AS [JENIS SARANA], 
(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE JENIS_SARANA_ID = '".$jsarana."' AND JENIS_SARANA_ID = A.JENIS_SARANA_ID $filter) AS JMLPERIKSA,
(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'MK' AND JENIS_SARANA_ID = '".$jsarana."' AND JENIS_SARANA_ID = A.JENIS_SARANA_ID $filter) AS MK,
(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'TMK' AND JENIS_SARANA_ID = '".$jsarana."' AND JENIS_SARANA_ID = A.JENIS_SARANA_ID $filter) AS TMK
FROM T_PEMERIKSAAN A LEFT JOIN M_JENIS_SARANA B ON A.JENIS_SARANA_ID = B.JENIS_SARANA_ID
WHERE A.JENIS_SARANA_ID = '".$jsarana."' $filter2";
			$data = $sipt->main->get_result($query);
			if($data){
				$arrdata[] = array("", "Diperiksa", "MK", "TMK");
				foreach($query->result_array() as $row){
					  $arrdata[] = array($row["JENIS SARANA"],$row["JMLPERIKSA"],$row["MK"],$row["TMK"]);
				}
			}else{
				$arrdata[] = array("", "Diperiksa", "MK", "TMK");
				$arrdata[] = array("",0,0,0);
			}
			return $arrdata;
		}
	}
	
	function chart_01VV($jsarana, $awal, $akhir){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$filter = "";
			$filter2 = "";
			if(trim($awal)!=""){
				$filter .= " AND DATEDIFF(dy, 0, convert(DATETIME, AWAL_PERIKSA, 105)) >= DATEDIFF(dy, 0, convert(DATETIME, '".$awal."', 105))";
				$filter2 .= " AND DATEDIFF(dy, 0, convert(DATETIME, A.AWAL_PERIKSA, 105)) >= DATEDIFF(dy, 0, convert(DATETIME, '".$awal."', 105))";
			}
			else{
				$filter .= " AND AWAL_PERIKSA > DATEADD(M, DATEDIFF(M,0,GETDATE()),0)";
				$filter2 .= " AND A.AWAL_PERIKSA > DATEADD(M, DATEDIFF(M,0,GETDATE()),0)";
			}
				
			if(trim($akhir)!=""){
				$filter .= " AND DATEDIFF(dy, 0, convert(DATETIME, AKHIR_PERIKSA, 105)) <= DATEDIFF(dy, 0, convert(DATETIME, '".$akhir."', 105))";
				$filter2 .= " AND DATEDIFF(dy, 0, convert(DATETIME, A.AKHIR_PERIKSA, 105)) <= DATEDIFF(dy, 0, convert(DATETIME, '".$akhir."', 105))";
			}else{
				$filter .= " AND AKHIR_PERIKSA < DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,0,GETDATE())+1,0))";
				$filter2 .= " AND A.AKHIR_PERIKSA < DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,0,GETDATE())+1,0))";
			}

			$query = "SELECT DISTINCT(B.NAMA_JENIS_SARANA) AS [JENIS SARANA], 
(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE JENIS_SARANA_ID = '".$jsarana."' AND JENIS_SARANA_ID = A.JENIS_SARANA_ID $filter) AS JMLPERIKSA,
(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'BAIK' AND JENIS_SARANA_ID = '".$jsarana."' AND JENIS_SARANA_ID = A.JENIS_SARANA_ID $filter) AS BAIK,
(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'CUKUP' AND JENIS_SARANA_ID = '".$jsarana."' AND JENIS_SARANA_ID = A.JENIS_SARANA_ID $filter) AS CUKUP,
(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'KURANG' AND JENIS_SARANA_ID = '".$jsarana."' AND JENIS_SARANA_ID = A.JENIS_SARANA_ID $filter) AS KURANG
FROM T_PEMERIKSAAN A LEFT JOIN M_JENIS_SARANA B ON A.JENIS_SARANA_ID = B.JENIS_SARANA_ID
WHERE A.JENIS_SARANA_ID = '".$jsarana."' $filter2";
			$data = $sipt->main->get_result($query);
			if($data){
				$arrdata[] = array("", "Diperiksa", "BAIK", "CUKUP", "KURANG");
				foreach($query->result_array() as $row){
					  $arrdata[] = array($row["JENIS SARANA"],$row["JMLPERIKSA"],$row["BAIK"],$row["CUKUP"],$row["KURANG"]);
				}
			}else{
				$arrdata[] = array("", "Diperiksa", "BAIK", "CUKUP", "KURANG");
				$arrdata[] = array("",0,0,0,0);
			}
			return $arrdata;
		}
	}
	
	function napza($jsarana, $awal, $akhir){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$filter = "";
			$filter2 = "";
			if(trim($awal)!=""){
				$filter .= " AND DATEDIFF(dy, 0, convert(DATETIME, AWAL_PERIKSA, 105)) >= DATEDIFF(dy, 0, convert(DATETIME, '".$awal."', 105))";
				$filter2 .= " AND DATEDIFF(dy, 0, convert(DATETIME, A.AWAL_PERIKSA, 105)) >= DATEDIFF(dy, 0, convert(DATETIME, '".$awal."', 105))";
			}
			else{
				$filter .= " AND AWAL_PERIKSA > DATEADD(M, DATEDIFF(M,0,GETDATE()),0)";
				$filter2 .= " AND A.AWAL_PERIKSA > DATEADD(M, DATEDIFF(M,0,GETDATE()),0)";
			}
				
			if(trim($akhir)!=""){
				$filter .= " AND DATEDIFF(dy, 0, convert(DATETIME, AKHIR_PERIKSA, 105)) <= DATEDIFF(dy, 0, convert(DATETIME, '".$akhir."', 105))";
				$filter2 .= " AND DATEDIFF(dy, 0, convert(DATETIME, A.AKHIR_PERIKSA, 105)) <= DATEDIFF(dy, 0, convert(DATETIME, '".$akhir."', 105))";
			}else{
				$filter .= " AND AKHIR_PERIKSA < DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,0,GETDATE())+1,0))";
				$filter2 .= " AND A.AKHIR_PERIKSA < DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,0,GETDATE())+1,0))";
			}

			$query = "SELECT DISTINCT(B.NAMA_JENIS_SARANA) AS [JENIS SARANA], 
(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE JENIS_SARANA_ID = '".$jsarana."' AND JENIS_SARANA_ID = A.JENIS_SARANA_ID $filter) AS JMLPERIKSA,
(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'MK' AND JENIS_SARANA_ID = '".$jsarana."' AND JENIS_SARANA_ID = A.JENIS_SARANA_ID $filter) AS MK,
(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'Major' AND JENIS_SARANA_ID = '".$jsarana."' AND JENIS_SARANA_ID = A.JENIS_SARANA_ID $filter) AS MAJOR,
(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'Minor' AND JENIS_SARANA_ID = '".$jsarana."' AND JENIS_SARANA_ID = A.JENIS_SARANA_ID $filter) AS MINOR,
(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'Kritikal' AND JENIS_SARANA_ID = '".$jsarana."' AND JENIS_SARANA_ID = A.JENIS_SARANA_ID $filter) AS KRITIKAL
FROM T_PEMERIKSAAN A LEFT JOIN M_JENIS_SARANA B ON A.JENIS_SARANA_ID = B.JENIS_SARANA_ID
WHERE A.JENIS_SARANA_ID = '".$jsarana."' $filter2";
			$data = $sipt->main->get_result($query);
			if($data){
				$arrdata[] = array("Sarana Napza", "Diperiksa", "MK", "Major", "Minor", "Kritikal");
				foreach($query->result_array() as $row){
					  $arrdata[] = array($row["JENIS SARANA"],$row["JMLPERIKSA"],$row["MK"],$row["MAJOR"],$row["MINOR"],$row["KRITIKAL"]);
				}
			}else{
				$arrdata[] = array("Sarana Napza", "Diperiksa", "MK", "Major", "Minor", "Kritikal");
				$arrdata[] = array("", 0, 0, 0, 0, 0);
			}
			return $arrdata;
		}
	}
	
	function chart_03TP($jsarana, $awal, $akhir){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$filter = "";
			$filter2 = "";
			if(trim($awal)!=""){
				$filter .= " AND DATEDIFF(dy, 0, convert(DATETIME, AWAL_PERIKSA, 105)) >= DATEDIFF(dy, 0, convert(DATETIME, '".$awal."', 105))";
				$filter2 .= " AND DATEDIFF(dy, 0, convert(DATETIME, A.AWAL_PERIKSA, 105)) >= DATEDIFF(dy, 0, convert(DATETIME, '".$awal."', 105))";
			}
			else{
				$filter .= " AND AWAL_PERIKSA > DATEADD(M, DATEDIFF(M,0,GETDATE()),0)";
				$filter2 .= " AND A.AWAL_PERIKSA > DATEADD(M, DATEDIFF(M,0,GETDATE()),0)";
			}
				
			if(trim($akhir)!=""){
				$filter .= " AND DATEDIFF(dy, 0, convert(DATETIME, AKHIR_PERIKSA, 105)) <= DATEDIFF(dy, 0, convert(DATETIME, '".$akhir."', 105))";
				$filter2 .= " AND DATEDIFF(dy, 0, convert(DATETIME, A.AKHIR_PERIKSA, 105)) <= DATEDIFF(dy, 0, convert(DATETIME, '".$akhir."', 105))";
			}else{
				$filter .= " AND AKHIR_PERIKSA < DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,0,GETDATE())+1,0))";
				$filter2 .= " AND A.AKHIR_PERIKSA < DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,0,GETDATE())+1,0))";
			}

			$query = "SELECT DISTINCT(B.NAMA_JENIS_SARANA) AS [JENIS SARANA], 
(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE JENIS_SARANA_ID = '".$jsarana."' AND JENIS_SARANA_ID = A.JENIS_SARANA_ID $filter) AS JMLPERIKSA,
(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'MK' AND JENIS_SARANA_ID = '".$jsarana."' AND JENIS_SARANA_ID = A.JENIS_SARANA_ID $filter) AS MK,
(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'Major' AND JENIS_SARANA_ID = '".$jsarana."' AND JENIS_SARANA_ID = A.JENIS_SARANA_ID $filter) AS MAJOR,
(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'Minor' AND JENIS_SARANA_ID = '".$jsarana."' AND JENIS_SARANA_ID = A.JENIS_SARANA_ID $filter) AS MINOR,
(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'Kritikal' AND JENIS_SARANA_ID = '".$jsarana."' AND JENIS_SARANA_ID = A.JENIS_SARANA_ID $filter) AS KRITIKAL
FROM T_PEMERIKSAAN A LEFT JOIN M_JENIS_SARANA B ON A.JENIS_SARANA_ID = B.JENIS_SARANA_ID
WHERE A.JENIS_SARANA_ID = '".$jsarana."' $filter2";
			$data = $sipt->main->get_result($query);
			if($data){
				$arrdata[] = array("Sarana Napza", "Diperiksa", "MK", "Major", "Minor", "Kritikal");
				foreach($query->result_array() as $row){
					  $arrdata[] = array($row["JENIS SARANA"],$row["JMLPERIKSA"],$row["MK"],$row["MAJOR"],$row["MINOR"],$row["KRITIKAL"]);
				}
			}else{
				$arrdata[] = array("Sarana Napza", "Diperiksa", "MK", "Major", "Minor", "Kritikal");
				$arrdata[] = array("", 0, 0, 0, 0, 0);
			}
			return $arrdata;
		}
	}
	
	function chart_02KO($jsarana, $awal, $akhir){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$filter = "";
			$filter2 = "";
			if(trim($awal)!=""){
				$filter .= " AND DATEDIFF(dy, 0, convert(DATETIME, AWAL_PERIKSA, 105)) >= DATEDIFF(dy, 0, convert(DATETIME, '".$awal."', 105))";
				$filter2 .= " AND DATEDIFF(dy, 0, convert(DATETIME, A.AWAL_PERIKSA, 105)) >= DATEDIFF(dy, 0, convert(DATETIME, '".$awal."', 105))";
			}
			else{
				$filter .= " AND AWAL_PERIKSA > DATEADD(M, DATEDIFF(M,0,GETDATE()),0)";
				$filter2 .= " AND A.AWAL_PERIKSA > DATEADD(M, DATEDIFF(M,0,GETDATE()),0)";
			}
				
			if(trim($akhir)!=""){
				$filter .= " AND DATEDIFF(dy, 0, convert(DATETIME, AKHIR_PERIKSA, 105)) <= DATEDIFF(dy, 0, convert(DATETIME, '".$akhir."', 105))";
				$filter2 .= " AND DATEDIFF(dy, 0, convert(DATETIME, A.AKHIR_PERIKSA, 105)) <= DATEDIFF(dy, 0, convert(DATETIME, '".$akhir."', 105))";
			}else{
				$filter .= " AND AKHIR_PERIKSA < DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,0,GETDATE())+1,0))";
				$filter2 .= " AND A.AKHIR_PERIKSA < DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,0,GETDATE())+1,0))";
			}
			$query = "SELECT DISTINCT(B.NAMA_JENIS_SARANA) AS [JENIS SARANA], (SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE JENIS_SARANA_ID = '".$jsarana."' $filter) AS JMLPERIKSA,
	(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'MK' AND JENIS_SARANA_ID = '".$jsarana."' $filter) AS MK,
	(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'TMK' AND JENIS_SARANA_ID = '".$jsarana."' $filter) AS TMK
	FROM T_PEMERIKSAAN A LEFT JOIN M_JENIS_SARANA B ON A.JENIS_SARANA_ID = B.JENIS_SARANA_ID WHERE A.JENIS_SARANA_ID = '".$jsarana."' $filter2";
			$data = $sipt->main->get_result($query);
			if($data){
				$arrdata [] = array("","Diperiksa","MK","TMK");
				foreach($query->result_array() as $row){
					$arrdata[] = array($row["JENIS SARANA"],$row['JMLPERIKSA'],$row['MK'],$row['TMK']);
				}
			}else{
				$arrdata [] = array("","Diperiksa","MK","TMK");
				$arrdata [] = array("",0,0,0);
			}
			return $arrdata;
		}
	}
	
	function chart_02OT($jsarana, $awal, $akhir){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$filter = "";
			$filter2 = "";
			if(trim($awal)!=""){
				$filter .= " AND DATEDIFF(dy, 0, convert(DATETIME, AWAL_PERIKSA, 105)) >= DATEDIFF(dy, 0, convert(DATETIME, '".$awal."', 105))";
				$filter2 .= " AND DATEDIFF(dy, 0, convert(DATETIME, A.AWAL_PERIKSA, 105)) >= DATEDIFF(dy, 0, convert(DATETIME, '".$awal."', 105))";
			}
			else{
				$filter .= " AND AWAL_PERIKSA > DATEADD(M, DATEDIFF(M,0,GETDATE()),0)";
				$filter2 .= " AND A.AWAL_PERIKSA > DATEADD(M, DATEDIFF(M,0,GETDATE()),0)";
			}
				
			if(trim($akhir)!=""){
				$filter .= " AND DATEDIFF(dy, 0, convert(DATETIME, AKHIR_PERIKSA, 105)) <= DATEDIFF(dy, 0, convert(DATETIME, '".$akhir."', 105))";
				$filter2 .= " AND DATEDIFF(dy, 0, convert(DATETIME, A.AKHIR_PERIKSA, 105)) <= DATEDIFF(dy, 0, convert(DATETIME, '".$akhir."', 105))";
			}else{
				$filter .= " AND AKHIR_PERIKSA < DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,0,GETDATE())+1,0))";
				$filter2 .= " AND A.AKHIR_PERIKSA < DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,0,GETDATE())+1,0))";
			}
			$query = "SELECT DISTINCT(B.NAMA_JENIS_SARANA) AS [JENIS SARANA], (SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE JENIS_SARANA_ID = '".$jsarana."' $filter) AS JMLPERIKSA,
	(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'MK' AND JENIS_SARANA_ID = '".$jsarana."' $filter) AS MK,
	(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'TMK' AND JENIS_SARANA_ID = '".$jsarana."' $filter) AS TMK
	FROM T_PEMERIKSAAN A LEFT JOIN M_JENIS_SARANA B ON A.JENIS_SARANA_ID = B.JENIS_SARANA_ID WHERE A.JENIS_SARANA_ID = '".$jsarana."' $filter2";
			$data = $sipt->main->get_result($query);
			if($data){
				$arrdata [] = array("","Diperiksa","MK","TMK");
				foreach($query->result_array() as $row){
					$arrdata[] = array($row["JENIS SARANA"],$row['JMLPERIKSA'],$row['MK'],$row['TMK']);
				}
			}else{
				$arrdata [] = array("","Diperiksa","MK","TMK");
				$arrdata [] = array("",0,0,0);
			}
			return $arrdata;
		}
	}	
		
	function chart_02PK($jsarana, $awal, $akhir){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$filter = "";
			$filter2 = "";
			if(trim($awal)!=""){
				$filter .= " AND DATEDIFF(dy, 0, convert(DATETIME, AWAL_PERIKSA, 105)) >= DATEDIFF(dy, 0, convert(DATETIME, '".$awal."', 105))";
				$filter2 .= " AND DATEDIFF(dy, 0, convert(DATETIME, A.AWAL_PERIKSA, 105)) >= DATEDIFF(dy, 0, convert(DATETIME, '".$awal."', 105))";
			}
			else{
				$filter .= " AND AWAL_PERIKSA > DATEADD(M, DATEDIFF(M,0,GETDATE()),0)";
				$filter2 .= " AND A.AWAL_PERIKSA > DATEADD(M, DATEDIFF(M,0,GETDATE()),0)";
			}
				
			if(trim($akhir)!=""){
				$filter .= " AND DATEDIFF(dy, 0, convert(DATETIME, AKHIR_PERIKSA, 105)) <= DATEDIFF(dy, 0, convert(DATETIME, '".$akhir."', 105))";
				$filter2 .= " AND DATEDIFF(dy, 0, convert(DATETIME, A.AKHIR_PERIKSA, 105)) <= DATEDIFF(dy, 0, convert(DATETIME, '".$akhir."', 105))";
			}else{
				$filter .= " AND AKHIR_PERIKSA < DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,0,GETDATE())+1,0))";
				$filter2 .= " AND A.AKHIR_PERIKSA < DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,0,GETDATE())+1,0))";
			}
			$query = "SELECT DISTINCT(B.NAMA_JENIS_SARANA) AS [JENIS SARANA], (SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE JENIS_SARANA_ID = '".$jsarana."' $filter) AS JMLPERIKSA,
	(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'MK' AND JENIS_SARANA_ID = '".$jsarana."' $filter) AS MK,
	(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'TMK' AND JENIS_SARANA_ID = '".$jsarana."' $filter) AS TMK
	FROM T_PEMERIKSAAN A LEFT JOIN M_JENIS_SARANA B ON A.JENIS_SARANA_ID = B.JENIS_SARANA_ID WHERE A.JENIS_SARANA_ID = '".$jsarana."' $filter2";
			$data = $sipt->main->get_result($query);
			if($data){
				$arrdata [] = array("","Diperiksa","MK","TMK");
				foreach($query->result_array() as $row){
					$arrdata[] = array($row["JENIS SARANA"],$row['JMLPERIKSA'],$row['MK'],$row['TMK']);
				}
			}else{
				$arrdata [] = array("","Diperiksa","MK","TMK");
				$arrdata [] = array("",0,0,0);
			}
			return $arrdata;
		}
	}
	
	function chart_02MM($jsarana, $awal, $akhir){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$filter = "";
			$filter2 = "";
			if(trim($awal)!=""){
				$filter .= " AND DATEDIFF(dy, 0, convert(DATETIME, AWAL_PERIKSA, 105)) >= DATEDIFF(dy, 0, convert(DATETIME, '".$awal."', 105))";
				$filter2 .= " AND DATEDIFF(dy, 0, convert(DATETIME, A.AWAL_PERIKSA, 105)) >= DATEDIFF(dy, 0, convert(DATETIME, '".$awal."', 105))";
			}
			else{
				$filter .= " AND AWAL_PERIKSA > DATEADD(M, DATEDIFF(M,0,GETDATE()),0)";
				$filter2 .= " AND A.AWAL_PERIKSA > DATEADD(M, DATEDIFF(M,0,GETDATE()),0)";
			}
				
			if(trim($akhir)!=""){
				$filter .= " AND DATEDIFF(dy, 0, convert(DATETIME, AKHIR_PERIKSA, 105)) <= DATEDIFF(dy, 0, convert(DATETIME, '".$akhir."', 105))";
				$filter2 .= " AND DATEDIFF(dy, 0, convert(DATETIME, A.AKHIR_PERIKSA, 105)) <= DATEDIFF(dy, 0, convert(DATETIME, '".$akhir."', 105))";
			}else{
				$filter .= " AND AKHIR_PERIKSA < DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,0,GETDATE())+1,0))";
				$filter2 .= " AND A.AKHIR_PERIKSA < DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,0,GETDATE())+1,0))";
			}
			$query = "SELECT DISTINCT(B.NAMA_JENIS_SARANA) AS [JENIS SARANA], (SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE JENIS_SARANA_ID = '".$jsarana."' $filter) AS JMLPERIKSA,
	(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'MK' AND JENIS_SARANA_ID = '".$jsarana."' $filter) AS MK,
	(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'TMK' AND JENIS_SARANA_ID = '".$jsarana."' $filter) AS TMK,
	(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'TTP' AND JENIS_SARANA_ID = '".$jsarana."' $filter) AS TUTUP,
	(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'TDP' AND JENIS_SARANA_ID = '".$jsarana."' $filter) AS TDP
	FROM T_PEMERIKSAAN A LEFT JOIN M_JENIS_SARANA B ON A.JENIS_SARANA_ID = B.JENIS_SARANA_ID WHERE A.JENIS_SARANA_ID = '".$jsarana."' $filter2";
			$data = $sipt->main->get_result($query);
			if($data){
				$arrdata [] = array("","Diperiksa","MK","TMK","TUTUP","Tidak Dapat Diperiksa");
				foreach($query->result_array() as $row){
					$arrdata[] = array($row["JENIS SARANA"],$row['JMLPERIKSA'],$row['MK'],$row['TMK'],$row['TUTUP'],$row['TDP']);
				}
			}else{
				$arrdata [] = array("","Diperiksa","MK","TMK","TUTUP","Tidak Dapat Diperiksa");
				$arrdata [] = array("",0,0,0,0,0);
			}
			return $arrdata;
		}
	}			

	function chart_02LL($jsarana, $awal, $akhir){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$filter = "";
			$filter2 = "";
			if(trim($awal)!=""){
				$filter .= " AND DATEDIFF(dy, 0, convert(DATETIME, AWAL_PERIKSA, 105)) >= DATEDIFF(dy, 0, convert(DATETIME, '".$awal."', 105))";
				$filter2 .= " AND DATEDIFF(dy, 0, convert(DATETIME, A.AWAL_PERIKSA, 105)) >= DATEDIFF(dy, 0, convert(DATETIME, '".$awal."', 105))";
			}
			else{
				$filter .= " AND AWAL_PERIKSA > DATEADD(M, DATEDIFF(M,0,GETDATE()),0)";
				$filter2 .= " AND A.AWAL_PERIKSA > DATEADD(M, DATEDIFF(M,0,GETDATE()),0)";
			}
				
			if(trim($akhir)!=""){
				$filter .= " AND DATEDIFF(dy, 0, convert(DATETIME, AKHIR_PERIKSA, 105)) <= DATEDIFF(dy, 0, convert(DATETIME, '".$akhir."', 105))";
				$filter2 .= " AND DATEDIFF(dy, 0, convert(DATETIME, A.AKHIR_PERIKSA, 105)) <= DATEDIFF(dy, 0, convert(DATETIME, '".$akhir."', 105))";
			}else{
				$filter .= " AND AKHIR_PERIKSA < DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,0,GETDATE())+1,0))";
				$filter2 .= " AND A.AKHIR_PERIKSA < DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,0,GETDATE())+1,0))";
			}
			$query = "SELECT DISTINCT(B.NAMA_JENIS_SARANA) AS [JENIS SARANA], (SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE JENIS_SARANA_ID = '".$jsarana."' $filter) AS JMLPERIKSA,
	(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'MK' AND JENIS_SARANA_ID = '".$jsarana."' $filter) AS MK,
	(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'TMK' AND JENIS_SARANA_ID = '".$jsarana."' $filter) AS TMK,
	(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'TTP' AND JENIS_SARANA_ID = '".$jsarana."' $filter) AS TUTUP,
	(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'TDP' AND JENIS_SARANA_ID = '".$jsarana."' $filter) AS TDP
	FROM T_PEMERIKSAAN A LEFT JOIN M_JENIS_SARANA B ON A.JENIS_SARANA_ID = B.JENIS_SARANA_ID WHERE A.JENIS_SARANA_ID = '".$jsarana."' $filter2";
			$data = $sipt->main->get_result($query);
			if($data){
				$arrdata [] = array("","Diperiksa","MK","TMK","TUTUP","Tidak Dapat Diperiksa");
				foreach($query->result_array() as $row){
					$arrdata[] = array($row["JENIS SARANA"],$row['JMLPERIKSA'],$row['MK'],$row['TMK'],$row['TUTUP'],$row['TDP']);
				}
			}else{
				$arrdata [] = array("","Diperiksa","MK","TMK","TUTUP","Tidak Dapat Diperiksa");
				$arrdata [] = array("",0,0,0,0,0);
			}
			return $arrdata;
		}
	}	
	
	function chart_02TF($jsarana, $awal, $akhir){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$filter = "";
			$filter2 = "";
			if(trim($awal)!=""){
				$filter .= " AND DATEDIFF(dy, 0, convert(DATETIME, AWAL_PERIKSA, 105)) >= DATEDIFF(dy, 0, convert(DATETIME, '".$awal."', 105))";
				$filter2 .= " AND DATEDIFF(dy, 0, convert(DATETIME, A.AWAL_PERIKSA, 105)) >= DATEDIFF(dy, 0, convert(DATETIME, '".$awal."', 105))";
			}
			else{
				$filter .= " AND AWAL_PERIKSA > DATEADD(M, DATEDIFF(M,0,GETDATE()),0)";
				$filter2 .= " AND A.AWAL_PERIKSA > DATEADD(M, DATEDIFF(M,0,GETDATE()),0)";
			}
				
			if(trim($akhir)!=""){
				$filter .= " AND DATEDIFF(dy, 0, convert(DATETIME, AKHIR_PERIKSA, 105)) <= DATEDIFF(dy, 0, convert(DATETIME, '".$akhir."', 105))";
				$filter2 .= " AND DATEDIFF(dy, 0, convert(DATETIME, A.AKHIR_PERIKSA, 105)) <= DATEDIFF(dy, 0, convert(DATETIME, '".$akhir."', 105))";
			}else{
				$filter .= " AND AKHIR_PERIKSA < DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,0,GETDATE())+1,0))";
				$filter2 .= " AND A.AKHIR_PERIKSA < DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,0,GETDATE())+1,0))";
			}
			$query = "SELECT DISTINCT(B.NAMA_JENIS_SARANA) AS [JENIS SARANA], (SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE JENIS_SARANA_ID = '".$jsarana."' $filter) AS JMLPERIKSA,
	(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'MK' AND JENIS_SARANA_ID = '".$jsarana."' $filter) AS MK,
	(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'TMK' AND JENIS_SARANA_ID = '".$jsarana."' $filter) AS TMK,
	(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'TTP' AND JENIS_SARANA_ID = '".$jsarana."' $filter) AS TUTUP,
	(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'TDP' AND JENIS_SARANA_ID = '".$jsarana."' $filter) AS TDP
	FROM T_PEMERIKSAAN A LEFT JOIN M_JENIS_SARANA B ON A.JENIS_SARANA_ID = B.JENIS_SARANA_ID WHERE A.JENIS_SARANA_ID = '".$jsarana."' $filter2";
			$data = $sipt->main->get_result($query);
			if($data){
				$arrdata [] = array("","Diperiksa","MK","TMK","TUTUP","Tidak Dapat Diperiksa");
				foreach($query->result_array() as $row){
					$arrdata[] = array($row["JENIS SARANA"],$row['JMLPERIKSA'],$row['MK'],$row['TMK'],$row['TUTUP'],$row['TDP']);
				}
			}else{
				$arrdata [] = array("","Diperiksa","MK","TMK","TUTUP","Tidak Dapat Diperiksa");
				$arrdata [] = array("",0,0,0,0,0);
			}
			return $arrdata;
		}
	}			

	function chart_03AA($jsarana, $awal, $akhir){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$filter = "";
			$filter2 = "";
			if(trim($awal)!=""){
				$filter .= " AND DATEDIFF(dy, 0, convert(DATETIME, AWAL_PERIKSA, 105)) >= DATEDIFF(dy, 0, convert(DATETIME, '".$awal."', 105))";
				$filter2 .= " AND DATEDIFF(dy, 0, convert(DATETIME, A.AWAL_PERIKSA, 105)) >= DATEDIFF(dy, 0, convert(DATETIME, '".$awal."', 105))";
			}
			else{
				$filter .= " AND AWAL_PERIKSA > DATEADD(M, DATEDIFF(M,0,GETDATE()),0)";
				$filter2 .= " AND A.AWAL_PERIKSA > DATEADD(M, DATEDIFF(M,0,GETDATE()),0)";
			}
				
			if(trim($akhir)!=""){
				$filter .= " AND DATEDIFF(dy, 0, convert(DATETIME, AKHIR_PERIKSA, 105)) <= DATEDIFF(dy, 0, convert(DATETIME, '".$akhir."', 105))";
				$filter2 .= " AND DATEDIFF(dy, 0, convert(DATETIME, A.AKHIR_PERIKSA, 105)) <= DATEDIFF(dy, 0, convert(DATETIME, '".$akhir."', 105))";
			}else{
				$filter .= " AND AKHIR_PERIKSA < DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,0,GETDATE())+1,0))";
				$filter2 .= " AND A.AKHIR_PERIKSA < DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,0,GETDATE())+1,0))";
			}
			$query = "SELECT DISTINCT(B.NAMA_JENIS_SARANA) AS [JENIS SARANA], (SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE JENIS_SARANA_ID = '".$jsarana."' $filter) AS JMLPERIKSA,
	(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'MK' AND JENIS_SARANA_ID = '".$jsarana."' $filter) AS MK,
	(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'TMK' AND JENIS_SARANA_ID = '".$jsarana."' $filter) AS TMK,
	(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'TTP' AND JENIS_SARANA_ID = '".$jsarana."' $filter) AS TUTUP,
	(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'TDP' AND JENIS_SARANA_ID = '".$jsarana."' $filter) AS TDP
	FROM T_PEMERIKSAAN A LEFT JOIN M_JENIS_SARANA B ON A.JENIS_SARANA_ID = B.JENIS_SARANA_ID WHERE A.JENIS_SARANA_ID = '".$jsarana."' $filter2";
			$data = $sipt->main->get_result($query);
			if($data){
				$arrdata [] = array("","Diperiksa","MK","TMK","TUTUP","Tidak Dapat Diperiksa");
				foreach($query->result_array() as $row){
					$arrdata[] = array($row["JENIS SARANA"],$row['JMLPERIKSA'],$row['MK'],$row['TMK'],$row['TUTUP'],$row['TDP']);
				}
			}else{
				$arrdata [] = array("","Diperiksa","MK","TMK","TUTUP","Tidak Dapat Diperiksa");
				$arrdata [] = array("",0,0,0,0,0);
			}
			return $arrdata;
		}
	}	
	
	function chart_03BB($jsarana, $awal, $akhir){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$filter = "";
			$filter2 = "";
			if(trim($awal)!=""){
				$filter .= " AND DATEDIFF(dy, 0, convert(DATETIME, AWAL_PERIKSA, 105)) >= DATEDIFF(dy, 0, convert(DATETIME, '".$awal."', 105))";
				$filter2 .= " AND DATEDIFF(dy, 0, convert(DATETIME, A.AWAL_PERIKSA, 105)) >= DATEDIFF(dy, 0, convert(DATETIME, '".$awal."', 105))";
			}
			else{
				$filter .= " AND AWAL_PERIKSA > DATEADD(M, DATEDIFF(M,0,GETDATE()),0)";
				$filter2 .= " AND A.AWAL_PERIKSA > DATEADD(M, DATEDIFF(M,0,GETDATE()),0)";
			}
				
			if(trim($akhir)!=""){
				$filter .= " AND DATEDIFF(dy, 0, convert(DATETIME, AKHIR_PERIKSA, 105)) <= DATEDIFF(dy, 0, convert(DATETIME, '".$akhir."', 105))";
				$filter2 .= " AND DATEDIFF(dy, 0, convert(DATETIME, A.AKHIR_PERIKSA, 105)) <= DATEDIFF(dy, 0, convert(DATETIME, '".$akhir."', 105))";
			}else{
				$filter .= " AND AKHIR_PERIKSA < DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,0,GETDATE())+1,0))";
				$filter2 .= " AND A.AKHIR_PERIKSA < DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,0,GETDATE())+1,0))";
			}
			$query = "SELECT DISTINCT(B.NAMA_JENIS_SARANA) AS [JENIS SARANA], (SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE JENIS_SARANA_ID = '".$jsarana."' $filter) AS JMLPERIKSA,
	(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'MK' AND JENIS_SARANA_ID = '".$jsarana."' $filter) AS MK,
	(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'TMK' AND JENIS_SARANA_ID = '".$jsarana."' $filter) AS TMK,
	(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'TTP' AND JENIS_SARANA_ID = '".$jsarana."' $filter) AS TUTUP,
	(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'TDP' AND JENIS_SARANA_ID = '".$jsarana."' $filter) AS TDP
	FROM T_PEMERIKSAAN A LEFT JOIN M_JENIS_SARANA B ON A.JENIS_SARANA_ID = B.JENIS_SARANA_ID WHERE A.JENIS_SARANA_ID = '".$jsarana."' $filter2";
			$data = $sipt->main->get_result($query);
			if($data){
				$arrdata [] = array("","Diperiksa","MK","TMK","TUTUP","Tidak Dapat Diperiksa");
				foreach($query->result_array() as $row){
					$arrdata[] = array($row["JENIS SARANA"],$row['JMLPERIKSA'],$row['MK'],$row['TMK'],$row['TUTUP'],$row['TDP']);
				}
			}else{
				$arrdata [] = array("","Diperiksa","MK","TMK","TUTUP","Tidak Dapat Diperiksa");
				$arrdata [] = array("",0,0,0,0,0);
			}
			return $arrdata;
		}
	}			
	
	function chart_03RS($jsarana, $awal, $akhir){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$filter = "";
			$filter2 = "";
			if(trim($awal)!=""){
				$filter .= " AND DATEDIFF(dy, 0, convert(DATETIME, AWAL_PERIKSA, 105)) >= DATEDIFF(dy, 0, convert(DATETIME, '".$awal."', 105))";
				$filter2 .= " AND DATEDIFF(dy, 0, convert(DATETIME, A.AWAL_PERIKSA, 105)) >= DATEDIFF(dy, 0, convert(DATETIME, '".$awal."', 105))";
			}
			else{
				$filter .= " AND AWAL_PERIKSA > DATEADD(M, DATEDIFF(M,0,GETDATE()),0)";
				$filter2 .= " AND A.AWAL_PERIKSA > DATEADD(M, DATEDIFF(M,0,GETDATE()),0)";
			}
				
			if(trim($akhir)!=""){
				$filter .= " AND DATEDIFF(dy, 0, convert(DATETIME, AKHIR_PERIKSA, 105)) <= DATEDIFF(dy, 0, convert(DATETIME, '".$akhir."', 105))";
				$filter2 .= " AND DATEDIFF(dy, 0, convert(DATETIME, A.AKHIR_PERIKSA, 105)) <= DATEDIFF(dy, 0, convert(DATETIME, '".$akhir."', 105))";
			}else{
				$filter .= " AND AKHIR_PERIKSA < DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,0,GETDATE())+1,0))";
				$filter2 .= " AND A.AKHIR_PERIKSA < DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,0,GETDATE())+1,0))";
			}
			$query = "SELECT DISTINCT(B.NAMA_JENIS_SARANA) AS [JENIS SARANA], (SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE JENIS_SARANA_ID = '".$jsarana."' $filter) AS JMLPERIKSA,
	(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'MK' AND JENIS_SARANA_ID = '".$jsarana."' $filter) AS MK,
	(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'TMK' AND JENIS_SARANA_ID = '".$jsarana."' $filter) AS TMK,
	(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'TTP' AND JENIS_SARANA_ID = '".$jsarana."' $filter) AS TUTUP,
	(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'TDP' AND JENIS_SARANA_ID = '".$jsarana."' $filter) AS TDP
	FROM T_PEMERIKSAAN A LEFT JOIN M_JENIS_SARANA B ON A.JENIS_SARANA_ID = B.JENIS_SARANA_ID WHERE A.JENIS_SARANA_ID = '".$jsarana."' $filter2";
			$data = $sipt->main->get_result($query);
			if($data){
				$arrdata [] = array("","Diperiksa","MK","TMK","TUTUP","Tidak Dapat Diperiksa");
				foreach($query->result_array() as $row){
					$arrdata[] = array($row["JENIS SARANA"],$row['JMLPERIKSA'],$row['MK'],$row['TMK'],$row['TUTUP'],$row['TDP']);
				}
			}else{
				$arrdata [] = array("","Diperiksa","MK","TMK","TUTUP","Tidak Dapat Diperiksa");
				$arrdata [] = array("",0,0,0,0,0);
			}
			return $arrdata;
		}
	}
	
	function chart_03TR($jsarana, $awal, $akhir){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$filter = "";
			$filter2 = "";
			if(trim($awal)!=""){
				$filter .= " AND DATEDIFF(dy, 0, convert(DATETIME, AWAL_PERIKSA, 105)) >= DATEDIFF(dy, 0, convert(DATETIME, '".$awal."', 105))";
				$filter2 .= " AND DATEDIFF(dy, 0, convert(DATETIME, A.AWAL_PERIKSA, 105)) >= DATEDIFF(dy, 0, convert(DATETIME, '".$awal."', 105))";
			}
			else{
				$filter .= " AND AWAL_PERIKSA > DATEADD(M, DATEDIFF(M,0,GETDATE()),0)";
				$filter2 .= " AND A.AWAL_PERIKSA > DATEADD(M, DATEDIFF(M,0,GETDATE()),0)";
			}
				
			if(trim($akhir)!=""){
				$filter .= " AND DATEDIFF(dy, 0, convert(DATETIME, AKHIR_PERIKSA, 105)) <= DATEDIFF(dy, 0, convert(DATETIME, '".$akhir."', 105))";
				$filter2 .= " AND DATEDIFF(dy, 0, convert(DATETIME, A.AKHIR_PERIKSA, 105)) <= DATEDIFF(dy, 0, convert(DATETIME, '".$akhir."', 105))";
			}else{
				$filter .= " AND AKHIR_PERIKSA < DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,0,GETDATE())+1,0))";
				$filter2 .= " AND A.AKHIR_PERIKSA < DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,0,GETDATE())+1,0))";
			}
			$query = "SELECT DISTINCT(B.NAMA_JENIS_SARANA) AS [JENIS SARANA], (SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE JENIS_SARANA_ID = '".$jsarana."' $filter) AS JMLPERIKSA,
	(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'MK' AND JENIS_SARANA_ID = '".$jsarana."' $filter) AS MK,
	(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'TMK' AND JENIS_SARANA_ID = '".$jsarana."' $filter) AS TMK,
	(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'TTP' AND JENIS_SARANA_ID = '".$jsarana."' $filter) AS TUTUP,
	(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'TDP' AND JENIS_SARANA_ID = '".$jsarana."' $filter) AS TDP
	FROM T_PEMERIKSAAN A LEFT JOIN M_JENIS_SARANA B ON A.JENIS_SARANA_ID = B.JENIS_SARANA_ID WHERE A.JENIS_SARANA_ID = '".$jsarana."' $filter2";
			$data = $sipt->main->get_result($query);
			if($data){
				$arrdata [] = array("","Diperiksa","MK","TMK","TUTUP","Tidak Dapat Diperiksa");
				foreach($query->result_array() as $row){
					$arrdata[] = array($row["JENIS SARANA"],$row['JMLPERIKSA'],$row['MK'],$row['TMK'],$row['TUTUP'],$row['TDP']);
				}
			}else{
				$arrdata [] = array("","Diperiksa","MK","TMK","TUTUP","Tidak Dapat Diperiksa");
				$arrdata [] = array("",0,0,0,0,0);
			}
			return $arrdata;
		}
	}			
	
	function chart_03WW($jsarana, $awal, $akhir){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$filter = "";
			$filter2 = "";
			if(trim($awal)!=""){
				$filter .= " AND DATEDIFF(dy, 0, convert(DATETIME, AWAL_PERIKSA, 105)) >= DATEDIFF(dy, 0, convert(DATETIME, '".$awal."', 105))";
				$filter2 .= " AND DATEDIFF(dy, 0, convert(DATETIME, A.AWAL_PERIKSA, 105)) >= DATEDIFF(dy, 0, convert(DATETIME, '".$awal."', 105))";
			}
			else{
				$filter .= " AND AWAL_PERIKSA > DATEADD(M, DATEDIFF(M,0,GETDATE()),0)";
				$filter2 .= " AND A.AWAL_PERIKSA > DATEADD(M, DATEDIFF(M,0,GETDATE()),0)";
			}
				
			if(trim($akhir)!=""){
				$filter .= " AND DATEDIFF(dy, 0, convert(DATETIME, AKHIR_PERIKSA, 105)) <= DATEDIFF(dy, 0, convert(DATETIME, '".$akhir."', 105))";
				$filter2 .= " AND DATEDIFF(dy, 0, convert(DATETIME, A.AKHIR_PERIKSA, 105)) <= DATEDIFF(dy, 0, convert(DATETIME, '".$akhir."', 105))";
			}else{
				$filter .= " AND AKHIR_PERIKSA < DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,0,GETDATE())+1,0))";
				$filter2 .= " AND A.AKHIR_PERIKSA < DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,0,GETDATE())+1,0))";
			}
			$query = "SELECT DISTINCT(B.NAMA_JENIS_SARANA) AS [JENIS SARANA], (SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE JENIS_SARANA_ID = '".$jsarana."' $filter) AS JMLPERIKSA,
	(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'MK' AND JENIS_SARANA_ID = '".$jsarana."' $filter) AS MK,
	(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'TMK' AND JENIS_SARANA_ID = '".$jsarana."' $filter) AS TMK,
	(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'TTP' AND JENIS_SARANA_ID = '".$jsarana."' $filter) AS TUTUP,
	(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'TDP' AND JENIS_SARANA_ID = '".$jsarana."' $filter) AS TDP
	FROM T_PEMERIKSAAN A LEFT JOIN M_JENIS_SARANA B ON A.JENIS_SARANA_ID = B.JENIS_SARANA_ID WHERE A.JENIS_SARANA_ID = '".$jsarana."' $filter2";
			$data = $sipt->main->get_result($query);
			if($data){
				$arrdata [] = array("","Diperiksa","MK","TMK","TUTUP","Tidak Dapat Diperiksa");
				foreach($query->result_array() as $row){
					$arrdata[] = array($row["JENIS SARANA"],$row['JMLPERIKSA'],$row['MK'],$row['TMK'],$row['TUTUP'],$row['TDP']);
				}
			}else{
				$arrdata [] = array("","Diperiksa","MK","TMK","TUTUP","Tidak Dapat Diperiksa");
				$arrdata [] = array("",0,0,0,0,0);
			}
			return $arrdata;
		}
	}			
	
}
?>