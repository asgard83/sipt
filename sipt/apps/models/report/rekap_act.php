<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);
class Rekap_act extends Model{
	
	function rekap_01OO(){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$filter1 = "";
			$filter2 = "";
			if(trim($this->input->post('AWAL')!="")){
				$filter1 .= " AND DATEDIFF(dy, 0, convert(DATETIME, AWAL_PERIKSA, 105)) >= DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('AWAL')."', 105))";
				$filter2 .= " AND DATEDIFF(dy, 0, convert(DATETIME, A.AWAL_PERIKSA, 105)) >= DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('AWAL')."', 105))";
				$fawal = "DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('AWAL')."', 105))";
				$awal = $this->input->post('AWAL');
			}else{
				$filter1 .= " AND AWAL_PERIKSA > GETDATE()";
				$filter2 .= " AND A.AWAL_PERIKSA > GETDATE()";
				$fawal = "DATEADD(M, DATEDIFF(M,0,GETDATE()),0)";
				$awal = date('01/m/Y');
			}
			if(trim($this->input->post('AKHIR')!="")){
				$filter1 .= " AND DATEDIFF(dy, 0, convert(DATETIME, AWAL_PERIKSA, 105)) <= DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('AKHIR')."', 105))";
				$filter2 .= " AND DATEDIFF(dy, 0, convert(DATETIME, A.AWAL_PERIKSA, 105)) <= DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('AKHIR')."', 105))";
				$fakhir = "DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('AKHIR')."', 105))";
				$akhir = $this->input->post('AKHIR');
			}else{
				$filter1 .= " AND AKHIR_PERIKSA < GETDATE()";
				$filter2 .= " AND A.AKHIR_PERIKSA < GETDATE()";
				$fakhir =  "DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,0,GETDATE())+1,0))";
				$akhir = date('t/m/Y');
			}
			if(in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')) || $this->newsession->userdata('SESS_BBPOM_ID') == "00"){
				if(trim($this->input->post('BBPOM_ID'))==""){
					$filter2 .= "";
					$balai = 'Seluruh Balai';
				}else{
					$filter2 .= " AND A.BBPOM_ID = '".$this->input->post('BBPOM_ID')."'";
					$balai = $sipt->main->get_uraian("SELECT NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID = '".$this->input->post('BBPOM_ID')."'","NAMA_BBPOM");		
				}
			}else{
				$filter2 .= " AND A.BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'";
				$balai = $sipt->main->get_uraian("SELECT NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","NAMA_BBPOM");		
			}
			
			$query = "SELECT DISTINCT(REPLACE(REPLACE(C.NAMA_BBPOM,'BALAI BESAR POM', 'BBPOM'),'BALAI POM','BPOM')) AS NAMA_BBPOM,
					 (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE JENIS_SARANA_ID = '01OO' AND BBPOM_ID = C.BBPOM_ID) AS JMLPERIKSA,
					 (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'MK' AND JENIS_SARANA_ID = '01OO' AND BBPOM_ID = C.BBPOM_ID) AS JMLMK,
					 (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'Minor' AND JENIS_SARANA_ID = '01OO' AND BBPOM_ID = C.BBPOM_ID) AS JMLMAJOR,
					 (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'Major' AND JENIS_SARANA_ID = '01OO' AND BBPOM_ID = C.BBPOM_ID) AS JMLMINOR,
					 (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'Kritikal' AND JENIS_SARANA_ID = '01OO' AND BBPOM_ID = C.BBPOM_ID) AS JMLKRITIKAL,
					 dbo.TL_CPKB('%Perbaikan%', A.BBPOM_ID,".$fawal.",".$fakhir.") AS PERBAIKAN,
					 dbo.TL_CPKB('%Peringatan', A.BBPOM_ID,".$fawal.",".$fakhir.") AS PERINGATAN,
					 dbo.TL_CPKB('%Peringatan Keras%', A.BBPOM_ID,".$fawal.",".$fakhir.") AS PK,
					 dbo.TL_CPKB('%Penghentian%', A.BBPOM_ID,".$fawal.",".$fakhir.") AS PSK,
					 dbo.TL_CPKB('%Pembekuan%', A.BBPOM_ID,".$fawal.",".$fakhir.") AS PEMBEKUAN,
					 dbo.TL_CPKB('%Pencabutan%', A.BBPOM_ID,".$fawal.",".$fakhir.") AS PENCABUTAN,
					 dbo.TL_CPKB('%Penarikan%', A.BBPOM_ID,".$fawal.",".$fakhir.") AS PENARIKAN
					 FROM T_PEMERIKSAAN A LEFT JOIN M_BBPOM C ON A.BBPOM_ID = C.BBPOM_ID WHERE A.JENIS_SARANA_ID = '".$this->input->post('JENIS')." ' $filter2 ORDER BY 1";
			$data = $sipt->main->get_result($query);
			$kolom = array();
			if($data){
				foreach($query->result_array() as $row){
					$kolom[] = $row;
					$arrdata = array('kolom' => $kolom);
				}
			}
			$arrdata['judul'] = strtoupper($sipt->main->get_uraian("SELECT dbo.NAMA_JENIS_SARANA('".$this->input->post('JENIS')."') AS JUDUL","JUDUL"));
			$arrdata['awal'] = $awal;
			$arrdata['akhir'] = $akhir;
			$arrdata['balai'] = $balai;
			return $arrdata;
		}
	}
	
	function rekap_distribusi(){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$filter1 = "";
			$filter2 = "";
			if(trim($this->input->post('AWAL')!="")){
				$filter1 .= " AND DATEDIFF(dy, 0, convert(DATETIME, AWAL_PERIKSA, 105)) >= DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('AWAL')."', 105))";
				$filter2 .= " AND DATEDIFF(dy, 0, convert(DATETIME, A.AWAL_PERIKSA, 105)) >= DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('AWAL')."', 105))";
				$fawal = "DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('AWAL')."', 105))";
				$awal = $this->input->post('AWAL');
			}else{
				$filter1 .= " AND AWAL_PERIKSA > GETDATE()";
				$filter2 .= " AND A.AWAL_PERIKSA > GETDATE()";
				$fawal = "DATEADD(M, DATEDIFF(M,0,GETDATE()),0)";
				$awal = date('01/m/Y');
			}
			if(trim($this->input->post('AKHIR')!="")){
				$filter1 .= " AND DATEDIFF(dy, 0, convert(DATETIME, AWAL_PERIKSA, 105)) <= DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('AKHIR')."', 105))";
				$filter2 .= " AND DATEDIFF(dy, 0, convert(DATETIME, A.AWAL_PERIKSA, 105)) <= DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('AKHIR')."', 105))";
				$fakhir = "DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('AKHIR')."', 105))";
				$akhir = $this->input->post('AKHIR');
			}else{
				$filter1 .= " AND AKHIR_PERIKSA < GETDATE()";
				$filter2 .= " AND A.AKHIR_PERIKSA < GETDATE()";
				$fakhir =  "DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,0,GETDATE())+1,0))";
				$akhir = date('t/m/Y');
			}
			if(in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')) || $this->newsession->userdata('SESS_BBPOM_ID') == "00"){
				if(trim($this->input->post('BBPOM_ID'))==""){
					$filter2 .= "";
					$balai = 'Seluruh Balai';
				}else{
					$filter2 .= " AND A.BBPOM_ID = '".$this->input->post('BBPOM_ID')."'";
					$balai = $sipt->main->get_uraian("SELECT NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID = '".$this->input->post('BBPOM_ID')."'","NAMA_BBPOM");		
				}
			}else{
				$filter2 .= " AND A.BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'";
				$balai = $sipt->main->get_uraian("SELECT NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","NAMA_BBPOM");		
			}
			
			if(in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))){
				$sts = " AND STATUS LIKE '%___1_%' ";
				$sts2 = "%___1_%";
			}else{
				$sts = " AND STATUS LIKE '%_____%' ";
				$sts2 = "%_____%";
			}
			
			
			$query = "SELECT DISTINCT(REPLACE(REPLACE(C.NAMA_BBPOM,'BALAI BESAR POM', 'BBPOM'),'BALAI POM','BPOM')) AS NAMA_BBPOM,
			(SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE JENIS_SARANA_ID = '".$this->input->post('JENIS')."' AND BBPOM_ID = C.BBPOM_ID $sts $filter1) AS JMLPERIKSA, 
			(SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'MK' AND JENIS_SARANA_ID = '".$this->input->post('JENIS')."' AND BBPOM_ID = C.BBPOM_ID $sts $filter1) AS MK, 
			(SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'TMK' AND JENIS_SARANA_ID = '".$this->input->post('JENIS')."' AND BBPOM_ID = C.BBPOM_ID $sts $filter1) AS TMK, 
			(SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'TTP' AND JENIS_SARANA_ID = '".$this->input->post('JENIS')."' AND BBPOM_ID = C.BBPOM_ID $sts $filter1) AS TUTUP,
			(SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'TDP' AND JENIS_SARANA_ID = '".$this->input->post('JENIS')."' AND BBPOM_ID = C.BBPOM_ID $sts $filter1) AS TDP,
			dbo.TINDAKAN_SARANA_DISTRIBUSI('".$this->input->post('JENIS')."',".$fawal.",".$fakhir.",C.BBPOM_ID,'".$sts2."','%Pembinaan') AS PEMBINAAN, 
			dbo.TINDAKAN_SARANA_DISTRIBUSI('".$this->input->post('JENIS')."',".$fawal.",".$fakhir.",C.BBPOM_ID,'".$sts2."','%Peringatan') AS PERINGATAN, 
			dbo.TINDAKAN_SARANA_DISTRIBUSI('".$this->input->post('JENIS')."',".$fawal.",".$fakhir.",C.BBPOM_ID,'".$sts2."','%Keras') AS PERINGATANKERAS, 
			dbo.TINDAKAN_SARANA_DISTRIBUSI('".$this->input->post('JENIS')."',".$fawal.",".$fakhir.",C.BBPOM_ID,'".$sts2."','%Sementara') AS PSK, 
			dbo.TINDAKAN_SARANA_DISTRIBUSI('".$this->input->post('JENIS')."',".$fawal.",".$fakhir.",C.BBPOM_ID,'".$sts2."','%Izin') AS PIZIN, 
			dbo.TINDAKAN_SARANA_DISTRIBUSI('".$this->input->post('JENIS')."',".$fawal.",".$fakhir.",C.BBPOM_ID,'".$sts2."','%Kegiatan') AS PKE
			FROM T_PEMERIKSAAN A LEFT JOIN M_BBPOM C ON A.BBPOM_ID = C.BBPOM_ID WHERE A.JENIS_SARANA_ID = '".$this->input->post('JENIS')." ' $filter2 ORDER BY 1";
			$data = $sipt->main->get_result($query);
			$kolom = array();
			if($data){
				foreach($query->result_array() as $row){
					$kolom[] = $row;
					$arrdata = array('kolom' => $kolom);
				}
			}
			$arrdata['judul'] = strtoupper($sipt->main->get_uraian("SELECT dbo.NAMA_JENIS_SARANA('".$this->input->post('JENIS')."') AS JUDUL","JUDUL"));
			$arrdata['awal'] = $awal;
			$arrdata['akhir'] = $akhir;
			$arrdata['balai'] = $balai;
			return $arrdata;
		}
	}
	
	function rekap_napza(){
		if($this->newsession->userdata('LOGGED_IN') == TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$filter1 = "";
			$filter2 = "";
			if(trim($this->input->post('AWAL')!="")){
				$filter1 .= " AND DATEDIFF(dy, 0, convert(DATETIME, AWAL_PERIKSA, 105)) >= DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('AWAL')."', 105))";
				$filter2 .= " AND DATEDIFF(dy, 0, convert(DATETIME, A.AWAL_PERIKSA, 105)) >= DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('AWAL')."', 105))";
				$awal = $this->input->post('AWAL');
			}else{
				$filter1 .= " AND AWAL_PERIKSA > GETDATE()";
				$filter2 .= " AND A.AWAL_PERIKSA > GETDATE()";
				$awal = date('01/m/Y');
			}
			if(trim($this->input->post('AKHIR')!="")){
				$filter1 .= " AND DATEDIFF(dy, 0, convert(DATETIME, AWAL_PERIKSA, 105)) <= DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('AKHIR')."', 105))";
				$filter2 .= " AND DATEDIFF(dy, 0, convert(DATETIME, A.AWAL_PERIKSA, 105)) <= DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('AKHIR')."', 105))";
				$akhir = $this->input->post('AKHIR');
			}else{
				$filter1 .= " AND AKHIR_PERIKSA < GETDATE()";
				$filter2 .= " AND A.AKHIR_PERIKSA < GETDATE()";
				$akhir = date('t/m/Y');
			}
			if(in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')) || $this->newsession->userdata('SESS_BBPOM_ID') == "00"){
				if(trim($this->input->post('BBPOM_ID'))==""){
					$filter2 .= "";
					$balai = 'Seluruh Balai';
				}else{
					$filter2 .= " AND A.BBPOM_ID = '".$this->input->post('BBPOM_ID')."'";
					$balai = $sipt->main->get_uraian("SELECT NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID = '".$this->input->post('BBPOM_ID')."'","NAMA_BBPOM");		
				}
			}else{
				$filter2 .= " AND A.BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'";
				$balai = $sipt->main->get_uraian("SELECT NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","NAMA_BBPOM");		
			}
			$query = "SELECT DISTINCT(REPLACE(REPLACE(C.NAMA_BBPOM,'BALAI BESAR POM', 'BBPOM'),'BALAI POM','BPOM')) AS NAMA_BBPOM, 
					 (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE JENIS_SARANA_ID = '".$this->input->post('JENIS')."' AND BBPOM_ID = C.BBPOM_ID $filter1) AS JMLPERIKSA,
					 (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'MK' AND JENIS_SARANA_ID = '".$this->input->post('JENIS')."' AND BBPOM_ID = C.BBPOM_ID $filter1) AS JMLMK,
					 (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'Minor' AND JENIS_SARANA_ID = '".$this->input->post('JENIS')."' AND BBPOM_ID = C.BBPOM_ID $filter1) AS JMLMINOR,
					 (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'Major' AND JENIS_SARANA_ID = '".$this->input->post('JENIS')."' AND BBPOM_ID = C.BBPOM_ID $filter1) AS JMLMAJOR,
					 (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'Kritikal' AND JENIS_SARANA_ID = '".$this->input->post('JENIS')."' AND BBPOM_ID = C.BBPOM_ID $filter1) AS JMLKRITIKAL,
					 (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL IS NULL AND JENIS_SARANA_ID = '".$this->input->post('JENIS')."' AND BBPOM_ID = C.BBPOM_ID $filter1) AS JMLNULL
					 FROM T_PEMERIKSAAN A LEFT JOIN M_BBPOM C ON A.BBPOM_ID = C.BBPOM_ID WHERE A.JENIS_SARANA_ID = '".$this->input->post('JENIS')."' $filter2 ORDER BY 1";
			$data = $sipt->main->get_result($query);
			$kolom = array();
			if($data){
				foreach($query->result_array() as $row){
					$kolom[] = $row;
					$arrdata = array('kolom' => $kolom);
				}
			}
			$arrdata['judul'] = strtoupper($sipt->main->get_uraian("SELECT dbo.NAMA_JENIS_SARANA('".$this->input->post('JENIS')."') AS JUDUL","JUDUL"));
			$arrdata['awal'] = $awal;
			$arrdata['akhir'] = $akhir;
			$arrdata['balai'] = $balai;
			return $arrdata;
		}
	}
	
	function rekap_01KO(){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$filter1 = "";
			$filter2 = "";
			if(trim($this->input->post('AWAL')!="")){
				$filter1 .= " AND DATEDIFF(dy, 0, convert(DATETIME, AWAL_PERIKSA, 105)) >= DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('AWAL')."', 105))";
				$filter2 .= " AND DATEDIFF(dy, 0, convert(DATETIME, A.AWAL_PERIKSA, 105)) >= DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('AWAL')."', 105))";
				$fawal = "DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('AWAL')."', 105))";
				$awal = $this->input->post('AWAL');
			}else{
				$filter1 .= " AND AWAL_PERIKSA > GETDATE()";
				$filter2 .= " AND A.AWAL_PERIKSA > GETDATE()";
				$fawal = "DATEADD(M, DATEDIFF(M,0,GETDATE()),0)";
				$awal = date('01/m/Y');
			}
			if(trim($this->input->post('AKHIR')!="")){
				$filter1 .= " AND DATEDIFF(dy, 0, convert(DATETIME, AWAL_PERIKSA, 105)) <= DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('AKHIR')."', 105))";
				$filter2 .= " AND DATEDIFF(dy, 0, convert(DATETIME, A.AWAL_PERIKSA, 105)) <= DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('AKHIR')."', 105))";
				$fakhir = "DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('AKHIR')."', 105))";
				$akhir = $this->input->post('AKHIR');
			}else{
				$filter1 .= " AND AKHIR_PERIKSA < GETDATE()";
				$filter2 .= " AND A.AKHIR_PERIKSA < GETDATE()";
				$fakhir =  "DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,0,GETDATE())+1,0))";
				$akhir = date('t/m/Y');
			}
			if(in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')) || $this->newsession->userdata('SESS_BBPOM_ID') == "00"){
				if(trim($this->input->post('BBPOM_ID'))==""){
					$filter2 .= "";
					$balai = 'Seluruh Balai';
				}else{
					$filter2 .= " AND A.BBPOM_ID = '".$this->input->post('BBPOM_ID')."'";
					$balai = $sipt->main->get_uraian("SELECT NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID = '".$this->input->post('BBPOM_ID')."'","NAMA_BBPOM");		
				}
			}else{
				$filter2 .= " AND A.BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'";
				$balai = $sipt->main->get_uraian("SELECT NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","NAMA_BBPOM");		
			}
			
			$query = " SELECT DISTINCT(REPLACE(REPLACE(C.NAMA_BBPOM,'BALAI BESAR POM', 'BBPOM'),'BALAI POM','BPOM')) AS NAMA_BBPOM,
			(SELECT COUNT(JENIS_SARANA_ID) FROM T_PEMERIKSAAN WHERE JENIS_SARANA_ID = '01KO' AND BBPOM_ID = C.BBPOM_ID $filter1) AS JMLPERIKSA,
			(SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'MK' AND JENIS_SARANA_ID = '01KO' AND BBPOM_ID = C.BBPOM_ID $filter1) AS MK,
			(SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'TMK' AND JENIS_SARANA_ID = '01KO' AND BBPOM_ID = C.BBPOM_ID $filter1) AS TMK, 
			(SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'TTP' AND JENIS_SARANA_ID = '01KO' AND BBPOM_ID = C.BBPOM_ID $filter1) AS TUTUP, 
			dbo.DETIL_TMK_CPKB('%Memproduksi TIE%',A.BBPOM_ID,".$fawal.",".$fakhir.") AS TMKTIE, 
			dbo.DETIL_TMK_CPKB('%Memproduksi MGB Berbahaya%',A.BBPOM_ID,".$fawal.",".$fakhir.") AS TMKBB, 
			dbo.DETIL_TMK_CPKB('%Aspek CPKB%',A.BBPOM_ID,".$fawal.",".$fakhir.") AS ASPEK_CPKB, 
			dbo.DETIL_TMK_CPKB('%TMK Penandaan%',A.BBPOM_ID,".$fawal.",".$fakhir.") AS TMKLABEL, 
			dbo.DETIL_TMK_CPKB('%Administrasi%',A.BBPOM_ID,".$fawal.",".$fakhir.") AS ADMINISTRASI,  
			dbo.TL_CPKB('%Pembinaan%', A.BBPOM_ID,".$fawal.",".$fakhir.") AS PEMBINAAN,  
			dbo.TL_CPKB('%Perbaikan%', A.BBPOM_ID,".$fawal.",".$fakhir.") AS PERBAIKAN,  
			dbo.TL_CPKB('%Peringatan', A.BBPOM_ID,".$fawal.",".$fakhir.") AS PERINGATAN,  
			dbo.TL_CPKB('%Peringatan Keras%', A.BBPOM_ID,".$fawal.",".$fakhir.") AS PK,  
			dbo.TL_CPKB('%Pemberhentian%', A.BBPOM_ID,".$fawal.",".$fakhir.") AS PSK,  
			dbo.TL_CPKB('%Pembekuan%', A.BBPOM_ID,".$fawal.",".$fakhir.") AS PEMBEKUAN,  
			dbo.TL_CPKB('%Penutupan%', A.BBPOM_ID,".$fawal.",".$fakhir.") AS PENUTUPAN,  
			dbo.TL_CPKB('%Akses Online%', A.BBPOM_ID,".$fawal.",".$fakhir.") AS AKSES_ONLINE,  
			dbo.TL_CPKB('%Projusticia%', A.BBPOM_ID,".$fawal.",".$fakhir.") AS PROJUSTICIA,  
			dbo.TL_CPKB('%Sertifikat CPKB%', A.BBPOM_ID,".$fawal.",".$fakhir.") AS SERT_CPKB,  
			dbo.TL_CPKB('%Izin Produksi%', A.BBPOM_ID,".$fawal.",".$fakhir.") AS PIP
			FROM T_PEMERIKSAAN A LEFT JOIN M_BBPOM C ON A.BBPOM_ID = C.BBPOM_ID WHERE A.JENIS_SARANA_ID = '01KO' $filter2 ORDER BY 1";
			$data = $sipt->main->get_result($query);
			$kolom = array();
			if($data){
				foreach($query->result_array() as $row){
					$kolom[] = $row;
					$arrdata = array('kolom' => $kolom);
				}
			}
			$arrdata['judul'] = strtoupper($sipt->main->get_uraian("SELECT dbo.NAMA_JENIS_SARANA('".$this->input->post('JENIS')."') AS JUDUL","JUDUL"));
			$arrdata['awal'] = $awal;
			$arrdata['akhir'] = $akhir;
			$arrdata['balai'] = $balai;
			return $arrdata;
		}
	}
	
	function rekap_02KO(){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$filter1 = "";
			$filter2 = "";
			if(trim($this->input->post('AWAL')!="")){
				$filter1 .= " AND DATEDIFF(dy, 0, convert(DATETIME, AWAL_PERIKSA, 105)) >= DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('AWAL')."', 105))";
				$filter2 .= " AND DATEDIFF(dy, 0, convert(DATETIME, A.AWAL_PERIKSA, 105)) >= DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('AWAL')."', 105))";
				$fawal = "DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('AWAL')."', 105))";
				$awal = $this->input->post('AWAL');
			}else{
				$filter1 .= " AND AWAL_PERIKSA > GETDATE()";
				$filter2 .= " AND A.AWAL_PERIKSA > GETDATE()";
				$fawal = "DATEADD(M, DATEDIFF(M,0,GETDATE()),0)";
				$awal = date('01/m/Y');
			}
			if(trim($this->input->post('AKHIR')!="")){
				$filter1 .= " AND DATEDIFF(dy, 0, convert(DATETIME, AWAL_PERIKSA, 105)) <= DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('AKHIR')."', 105))";
				$filter2 .= " AND DATEDIFF(dy, 0, convert(DATETIME, A.AWAL_PERIKSA, 105)) <= DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('AKHIR')."', 105))";
				$fakhir = "DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('AKHIR')."', 105))";
				$akhir = $this->input->post('AKHIR');
			}else{
				$filter1 .= " AND AKHIR_PERIKSA < GETDATE()";
				$filter2 .= " AND A.AKHIR_PERIKSA < GETDATE()";
				$fakhir =  "DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,0,GETDATE())+1,0))";
				$akhir = date('t/m/Y');
			}
			if(in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')) || $this->newsession->userdata('SESS_BBPOM_ID') == "00"){
				if(trim($this->input->post('BBPOM_ID'))==""){
					$filter2 .= "";
					$balai = 'Seluruh Balai';
				}else{
					$filter2 .= " AND A.BBPOM_ID = '".$this->input->post('BBPOM_ID')."'";
					$balai = $sipt->main->get_uraian("SELECT NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID = '".$this->input->post('BBPOM_ID')."'","NAMA_BBPOM");		
				}
			}else{
				$filter2 .= " AND A.BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'";
				$balai = $sipt->main->get_uraian("SELECT NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","NAMA_BBPOM");		
			}
			
			$query = " SELECT DISTINCT(REPLACE(REPLACE(C.NAMA_BBPOM,'BALAI BESAR POM', 'BBPOM'),'BALAI POM','BPOM')) AS NAMA_BBPOM,
			(SELECT COUNT(JENIS_SARANA_ID) FROM T_PEMERIKSAAN WHERE JENIS_SARANA_ID = '02KO' AND BBPOM_ID = C.BBPOM_ID $filter1) AS JMLPERIKSA,
			(SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'MK' AND JENIS_SARANA_ID = '02KO' AND BBPOM_ID = C.BBPOM_ID $filter1) AS MK,
			(SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'TMK' AND JENIS_SARANA_ID = '02KO' AND BBPOM_ID = C.BBPOM_ID $filter1) AS TMK, 
			dbo.DETIL_TMK_DISKOS('%Mengedarkan TIE%',A.BBPOM_ID,".$fawal.",".$fakhir.") AS TMKTIE, 
			dbo.DETIL_TMK_DISKOS('%Bahan Baku Dilarang%',A.BBPOM_ID,".$fawal.",".$fakhir.") AS TMKBB, 
			dbo.DETIL_TMK_DISKOS('%Administrasi%',A.BBPOM_ID,".$fawal.",".$fakhir.") AS TMKADMINISTRASI, 
			dbo.DETIL_TMK_DISKOS('%Kadaluarsa%',A.BBPOM_ID,".$fawal.",".$fakhir.") AS TMKED, 
			dbo.KAT_TMKKOS('%TIE%',A.BBPOM_ID,'012',".$fawal.",".$fakhir.") AS PRODUKTIE, 
			dbo.KAT_TMKKOS('%Bahan Baku%',A.BBPOM_ID,'012',".$fawal.",".$fakhir.") AS PRODUKBB, 
			dbo.KAT_TMKKOS('%Penandaan%',A.BBPOM_ID,'012',".$fawal.",".$fakhir.") AS PRODUKPENANDAAN, 
			dbo.TINDAKAN_SARANA_KOSMETIK('%Pembinaan%', A.BBPOM_ID,".$fawal.",".$fakhir.") AS PEMBINAAN, 
			dbo.TINDAKAN_SARANA_KOSMETIK('%Pengamanan%', A.BBPOM_ID,".$fawal.",".$fakhir.") AS PENGAMANAN, 
			dbo.TINDAKAN_SARANA_KOSMETIK('%Projusticia', A.BBPOM_ID,".$fawal.",".$fakhir.") AS PROJUSTICIA, 
			dbo.TINDAKAN_SARANA_KOSMETIK('%Lain-Lain%', A.BBPOM_ID,".$fawal.",".$fakhir.") AS LAINLAIN, 
			dbo.TINDAKAN_SARANA_KOSMETIK('%Rekomendasi PSK%', A.BBPOM_ID,".$fawal.",".$fakhir.") AS REKOMENDASIPSK, 
			dbo.TINDAKAN_PRODUK_KOSMETIK('Pengamanan',A.BBPOM_ID,'012','02KO',".$fawal.",".$fakhir.") AS PENGAMANANPRODUK, 
			dbo.TINDAKAN_PRODUK_KOSMETIK('Pemusnahan',A.BBPOM_ID,'012','02KO',".$fawal.",".$fakhir.") AS PEMUSNAHANPRODUK, 
			dbo.TINDAKAN_PRODUK_KOSMETIK('Penarikan',A.BBPOM_ID,'012','02KO',".$fawal.",".$fakhir.") AS PENARIKANPRODUK, 
			dbo.TINDAKAN_PRODUK_KOSMETIK('Pendataan',A.BBPOM_ID,'012','02KO',".$fawal.",".$fakhir.") AS PENDATAANPRODUK 
			FROM T_PEMERIKSAAN A LEFT JOIN M_BBPOM C ON A.BBPOM_ID = C.BBPOM_ID WHERE A.JENIS_SARANA_ID = '02KO' $filter2 ORDER BY 1 ";
			$data = $sipt->main->get_result($query);
			$kolom = array();
			if($data){
				foreach($query->result_array() as $row){
					$kolom[] = $row;
					$arrdata = array('kolom' => $kolom);
				}
			}
			$arrdata['judul'] = strtoupper($sipt->main->get_uraian("SELECT dbo.NAMA_JENIS_SARANA('".$this->input->post('JENIS')."') AS JUDUL","JUDUL"));
			$arrdata['awal'] = $awal;
			$arrdata['akhir'] = $akhir;
			$arrdata['balai'] = $balai;
			return $arrdata;
		}
	}
	
	function rekap_01HH(){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$filter1 = "";
			$filter2 = "";
			if(trim($this->input->post('AWAL')!="")){
				$filter1 .= " AND DATEDIFF(dy, 0, convert(DATETIME, AWAL_PERIKSA, 105)) >= DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('AWAL')."', 105))";
				$filter2 .= " AND DATEDIFF(dy, 0, convert(DATETIME, A.AWAL_PERIKSA, 105)) >= DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('AWAL')."', 105))";
				$fawal = "DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('AWAL')."', 105))";
				$awal = $this->input->post('AWAL');
			}else{
				$filter1 .= " AND AWAL_PERIKSA > GETDATE()";
				$filter2 .= " AND A.AWAL_PERIKSA > GETDATE()";
				$fawal = "DATEADD(M, DATEDIFF(M,0,GETDATE()),0)";
				$awal = date('01/m/Y');
			}
			if(trim($this->input->post('AKHIR')!="")){
				$filter1 .= " AND DATEDIFF(dy, 0, convert(DATETIME, AWAL_PERIKSA, 105)) <= DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('AKHIR')."', 105))";
				$filter2 .= " AND DATEDIFF(dy, 0, convert(DATETIME, A.AWAL_PERIKSA, 105)) <= DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('AKHIR')."', 105))";
				$fakhir = "DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('AKHIR')."', 105))";
				$akhir = $this->input->post('AKHIR');
			}else{
				$filter1 .= " AND AKHIR_PERIKSA < GETDATE()";
				$filter2 .= " AND A.AKHIR_PERIKSA < GETDATE()";
				$fakhir =  "DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,0,GETDATE())+1,0))";
				$akhir = date('t/m/Y');
			}
			if(in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')) || $this->newsession->userdata('SESS_BBPOM_ID') == "00"){
				if(trim($this->input->post('BBPOM_ID'))==""){
					$filter2 .= "";
					$balai = 'Seluruh Balai';
				}else{
					$filter2 .= " AND A.BBPOM_ID = '".$this->input->post('BBPOM_ID')."'";
					$balai = $sipt->main->get_uraian("SELECT NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID = '".$this->input->post('BBPOM_ID')."'","NAMA_BBPOM");		
				}
			}else{
				$filter2 .= " AND A.BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'";
				$balai = $sipt->main->get_uraian("SELECT NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","NAMA_BBPOM");		
			}
			
			$query = " SELECT DISTINCT(REPLACE(REPLACE(C.NAMA_BBPOM,'BALAI BESAR POM', 'BBPOM'),'BALAI POM','BPOM')) AS NAMA_BBPOM,
			(SELECT COUNT(JENIS_SARANA_ID) FROM T_PEMERIKSAAN WHERE JENIS_SARANA_ID = '01HH' AND BBPOM_ID = C.BBPOM_ID $filter1) AS JMLPERIKSA,
			(SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'MK' AND JENIS_SARANA_ID = '01HH' AND BBPOM_ID = C.BBPOM_ID $filter1) AS MK,
			(SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'TMK' AND JENIS_SARANA_ID = '01HH' AND BBPOM_ID = C.BBPOM_ID $filter1) AS TMK, 
			(SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'TTP' AND JENIS_SARANA_ID = '01HH' AND BBPOM_ID = C.BBPOM_ID $filter1) AS TUTUP, 
			dbo.DETIL_TMK_CPPKB('%TIE%',A.BBPOM_ID,".$fawal.",".$fakhir.") AS TMKTIE, 
			dbo.DETIL_TMK_CPPKB('%BKO%',A.BBPOM_ID,".$fawal.",".$fakhir.") AS TMKBKO, 
			dbo.DETIL_TMK_CPPKB('%Penandaan%',A.BBPOM_ID,".$fawal.",".$fakhir.") AS TMKLABEL, 
			dbo.DETIL_TMK_CPPKB('%Aspek CPOTB%',A.BBPOM_ID,".$fawal.",".$fakhir.") AS ASPEKCPTOB, 
			dbo.DETIL_TMK_CPPKB('%Administrasi%',A.BBPOM_ID,".$fawal.",".$fakhir.") AS ADMINISTRASI,  
			dbo.TL_CPOTB('%Pembinaan%', A.BBPOM_ID,".$fawal.",".$fakhir.") AS PEMBINAAN,  
			dbo.TL_CPOTB('%Perbaikan%', A.BBPOM_ID,".$fawal.",".$fakhir.") AS PERBAIKAN,  
			dbo.TL_CPOTB('%Peringatan', A.BBPOM_ID,".$fawal.",".$fakhir.") AS PERINGATAN,  
			dbo.TL_CPOTB('%Peringatan Keras%', A.BBPOM_ID,".$fawal.",".$fakhir.") AS PK,  
			dbo.TL_CPOTB('%Pemberhentian%', A.BBPOM_ID,".$fawal.",".$fakhir.") AS PSK,  
			dbo.TL_CPOTB('%Pembekuan%', A.BBPOM_ID,".$fawal.",".$fakhir.") AS PEMBEKUAN,
			dbo.TL_CPOTB('%NIE%', A.BBPOM_ID,".$fawal.",".$fakhir.") AS CABUT_NIE,    
			dbo.TL_CPOTB('%Izin Produksi%', A.BBPOM_ID,".$fawal.",".$fakhir.") AS PIP,  
			dbo.TL_CPOTB('%Projusticia%', A.BBPOM_ID,".$fawal.",".$fakhir.") AS PROJUSTICIA
			FROM T_PEMERIKSAAN A LEFT JOIN M_BBPOM C ON A.BBPOM_ID = C.BBPOM_ID WHERE A.JENIS_SARANA_ID = '01HH' $filter2 ORDER BY 1";
			$data = $sipt->main->get_result($query);
			$kolom = array();
			if($data){
				foreach($query->result_array() as $row){
					$kolom[] = $row;
					$arrdata = array('kolom' => $kolom);
				}
			}
			$arrdata['judul'] = strtoupper($sipt->main->get_uraian("SELECT dbo.NAMA_JENIS_SARANA('".$this->input->post('JENIS')."') AS JUDUL","JUDUL"));
			$arrdata['awal'] = $awal;
			$arrdata['akhir'] = $akhir;
			$arrdata['balai'] = $balai;
			return $arrdata;
		}
	}
	
	function rekap_02OT(){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$filter1 = "";
			$filter2 = "";
			if(trim($this->input->post('AWAL')!="")){
				$filter1 .= " AND DATEDIFF(dy, 0, convert(DATETIME, AWAL_PERIKSA, 105)) >= DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('AWAL')."', 105))";
				$filter2 .= " AND DATEDIFF(dy, 0, convert(DATETIME, A.AWAL_PERIKSA, 105)) >= DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('AWAL')."', 105))";
				$fawal = "DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('AWAL')."', 105))";
				$awal = $this->input->post('AWAL');
			}else{
				$filter1 .= " AND AWAL_PERIKSA > GETDATE()";
				$filter2 .= " AND A.AWAL_PERIKSA > GETDATE()";
				$fawal = "DATEADD(M, DATEDIFF(M,0,GETDATE()),0)";
				$awal = date('01/m/Y');
			}
			if(trim($this->input->post('AKHIR')!="")){
				$filter1 .= " AND DATEDIFF(dy, 0, convert(DATETIME, AWAL_PERIKSA, 105)) <= DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('AKHIR')."', 105))";
				$filter2 .= " AND DATEDIFF(dy, 0, convert(DATETIME, A.AWAL_PERIKSA, 105)) <= DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('AKHIR')."', 105))";
				$fakhir = "DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('AKHIR')."', 105))";
				$akhir = $this->input->post('AKHIR');
			}else{
				$filter1 .= " AND AKHIR_PERIKSA < GETDATE()";
				$filter2 .= " AND A.AKHIR_PERIKSA < GETDATE()";
				$fakhir =  "DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,0,GETDATE())+1,0))";
				$akhir = date('t/m/Y');
			}
			if(in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')) || $this->newsession->userdata('SESS_BBPOM_ID') == "00"){
				if(trim($this->input->post('BBPOM_ID'))==""){
					$filter2 .= "";
					$balai = 'Seluruh Balai';
				}else{
					$filter2 .= " AND A.BBPOM_ID = '".$this->input->post('BBPOM_ID')."'";
					$balai = $sipt->main->get_uraian("SELECT NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID = '".$this->input->post('BBPOM_ID')."'","NAMA_BBPOM");		
				}
			}else{
				$filter2 .= " AND A.BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'";
				$balai = $sipt->main->get_uraian("SELECT NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","NAMA_BBPOM");		
			}
			$query = " SELECT DISTINCT(REPLACE(REPLACE(C.NAMA_BBPOM,'BALAI BESAR POM', 'BBPOM'),'BALAI POM','BPOM')) AS NAMA_BBPOM,
			(SELECT COUNT(JENIS_SARANA_ID) FROM T_PEMERIKSAAN WHERE JENIS_SARANA_ID = '02OT' AND BBPOM_ID = C.BBPOM_ID $filter1) AS JMLPERIKSA, 
			(SELECT COUNT(JENIS_SARANA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'MK' AND JENIS_SARANA_ID = '02OT' AND BBPOM_ID = C.BBPOM_ID $filter1) AS MK, 
			(SELECT COUNT(JENIS_SARANA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'TMK' AND JENIS_SARANA_ID = '02OT' AND BBPOM_ID = C.BBPOM_ID $filter1) AS TMK,
			dbo.HITUNG_SATUAN('kotak','010',C.BBPOM_ID,".$fawal.",".$fakhir.") AS KOTAK, 
			dbo.HITUNG_SATUAN('bungkus','010',C.BBPOM_ID,".$fawal.",".$fakhir.") AS BUNGKUS, 
			dbo.HITUNG_SATUAN('kapsul','010',C.BBPOM_ID,".$fawal.",".$fakhir.") AS KAPSUL, 
			dbo.HITUNG_SATUAN('botol','010',C.BBPOM_ID,".$fawal.",".$fakhir.") AS BOTOL, 
			dbo.HITUNG_SATUAN('buah','010',C.BBPOM_ID,".$fawal.",".$fakhir.") AS BUAH, 
			dbo.HITUNG_SATUAN('tube','010',C.BBPOM_ID,".$fawal.",".$fakhir.") AS TUBE, 
			dbo.TOT_HARGA('010',C.BBPOM_ID,".$fawal.",".$fakhir.") AS TOTAL_HARGA 
			FROM T_PEMERIKSAAN A LEFT JOIN M_BBPOM C ON A.BBPOM_ID = C.BBPOM_ID 
			WHERE A.JENIS_SARANA_ID = '".$this->input->post('JENIS')."' $filter2 ORDER BY 1";
			$data = $sipt->main->get_result($query);
			$kolom = array();
			if($data){
				foreach($query->result_array() as $row){
					$kolom[] = $row;
					$arrdata = array('kolom' => $kolom);
				}
			}
			$arrdata['judul'] = strtoupper($sipt->main->get_uraian("SELECT dbo.NAMA_JENIS_SARANA('".$this->input->post('JENIS')."') AS JUDUL","JUDUL"));
			$arrdata['awal'] = $awal;
			$arrdata['akhir'] = $akhir;
			$arrdata['balai'] = $balai;
			return $arrdata;
		}
	}
	
	function rekap_01PK(){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$filter1 = "";
			$filter2 = "";
			if(trim($this->input->post('AWAL')!="")){
				$filter1 .= " AND DATEDIFF(dy, 0, convert(DATETIME, AWAL_PERIKSA, 105)) >= DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('AWAL')."', 105))";
				$filter2 .= " AND DATEDIFF(dy, 0, convert(DATETIME, A.AWAL_PERIKSA, 105)) >= DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('AWAL')."', 105))";
				$fawal = "DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('AWAL')."', 105))";
				$awal = $this->input->post('AWAL');
			}else{
				$filter1 .= " AND AWAL_PERIKSA > GETDATE()";
				$filter2 .= " AND A.AWAL_PERIKSA > GETDATE()";
				$fawal = "DATEADD(M, DATEDIFF(M,0,GETDATE()),0)";
				$awal = date('01/m/Y');
			}
			if(trim($this->input->post('AKHIR')!="")){
				$filter1 .= " AND DATEDIFF(dy, 0, convert(DATETIME, AWAL_PERIKSA, 105)) <= DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('AKHIR')."', 105))";
				$filter2 .= " AND DATEDIFF(dy, 0, convert(DATETIME, A.AWAL_PERIKSA, 105)) <= DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('AKHIR')."', 105))";
				$fakhir = "DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('AKHIR')."', 105))";
				$akhir = $this->input->post('AKHIR');
			}else{
				$filter1 .= " AND AKHIR_PERIKSA < GETDATE()";
				$filter2 .= " AND A.AKHIR_PERIKSA < GETDATE()";
				$fakhir =  "DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,0,GETDATE())+1,0))";
				$akhir = date('t/m/Y');
			}
			if(in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')) || $this->newsession->userdata('SESS_BBPOM_ID') == "00"){
				if(trim($this->input->post('BBPOM_ID'))==""){
					$filter2 .= "";
					$balai = 'Seluruh Balai';
				}else{
					$filter2 .= " AND A.BBPOM_ID = '".$this->input->post('BBPOM_ID')."'";
					$balai = $sipt->main->get_uraian("SELECT NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID = '".$this->input->post('BBPOM_ID')."'","NAMA_BBPOM");		
				}
			}else{
				$filter2 .= " AND A.BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'";
				$balai = $sipt->main->get_uraian("SELECT NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","NAMA_BBPOM");		
			}
			
			$query = " SELECT DISTINCT(REPLACE(REPLACE(C.NAMA_BBPOM,'BALAI BESAR POM', 'BBPOM'),'BALAI POM','BPOM')) AS NAMA_BBPOM,
			(SELECT COUNT(JENIS_SARANA_ID) FROM T_PEMERIKSAAN WHERE JENIS_SARANA_ID = '01PK' AND BBPOM_ID = C.BBPOM_ID $filter1) AS JMLPERIKSA,
			(SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'MK' AND JENIS_SARANA_ID = '01PK' AND BBPOM_ID = C.BBPOM_ID $filter1) AS MK,
			(SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'TMK' AND JENIS_SARANA_ID = '01PK' AND BBPOM_ID = C.BBPOM_ID $filter1) AS TMK, 
			(SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'TTP' AND JENIS_SARANA_ID = '01PK' AND BBPOM_ID = C.BBPOM_ID $filter1) AS TUTUP, 
			dbo.DETIL_TMK_CPOTB('%TIE%',A.BBPOM_ID,".$fawal.",".$fakhir.") AS TMKTIE, 
			dbo.DETIL_TMK_CPOTB('%BKO%',A.BBPOM_ID,".$fawal.",".$fakhir.") AS TMKBKO, 
			dbo.DETIL_TMK_CPOTB('%Penandaan%',A.BBPOM_ID,".$fawal.",".$fakhir.") AS TMKLABEL, 
			dbo.DETIL_TMK_CPOTB('%Aspek CPOTB%',A.BBPOM_ID,".$fawal.",".$fakhir.") AS ASPEKCPTOB, 
			dbo.DETIL_TMK_CPOTB('%Administrasi%',A.BBPOM_ID,".$fawal.",".$fakhir.") AS ADMINISTRASI,  
			dbo.TL_CPPKB('%Pembinaan%', A.BBPOM_ID,".$fawal.",".$fakhir.") AS PEMBINAAN,  
			dbo.TL_CPPKB('%Perbaikan%', A.BBPOM_ID,".$fawal.",".$fakhir.") AS PERBAIKAN,  
			dbo.TL_CPPKB('%Peringatan', A.BBPOM_ID,".$fawal.",".$fakhir.") AS PERINGATAN,  
			dbo.TL_CPPKB('%Peringatan Keras%', A.BBPOM_ID,".$fawal.",".$fakhir.") AS PK,  
			dbo.TL_CPPKB('%Pemberhentian%', A.BBPOM_ID,".$fawal.",".$fakhir.") AS PSK,  
			dbo.TL_CPPKB('%Pembekuan%', A.BBPOM_ID,".$fawal.",".$fakhir.") AS PEMBEKUAN,
			dbo.TL_CPPKB('%NIE%', A.BBPOM_ID,".$fawal.",".$fakhir.") AS CABUT_NIE,    
			dbo.TL_CPPKB('%Izin Produksi%', A.BBPOM_ID,".$fawal.",".$fakhir.") AS PIP,  
			dbo.TL_CPPKB('%Projusticia%', A.BBPOM_ID,".$fawal.",".$fakhir.") AS PROJUSTICIA
			FROM T_PEMERIKSAAN A LEFT JOIN M_BBPOM C ON A.BBPOM_ID = C.BBPOM_ID WHERE A.JENIS_SARANA_ID = '01PK' $filter2 ORDER BY 1";
			$data = $sipt->main->get_result($query);
			$kolom = array();
			if($data){
				foreach($query->result_array() as $row){
					$kolom[] = $row;
					$arrdata = array('kolom' => $kolom);
				}
			}
			$arrdata['judul'] = strtoupper($sipt->main->get_uraian("SELECT dbo.NAMA_JENIS_SARANA('".$this->input->post('JENIS')."') AS JUDUL","JUDUL"));
			$arrdata['awal'] = $awal;
			$arrdata['akhir'] = $akhir;
			$arrdata['balai'] = $balai;
			return $arrdata;
		}
	
	}
	
	function rekap_02PK(){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$filter1 = "";
			$filter2 = "";
			if(trim($this->input->post('AWAL')!="")){
				$filter1 .= " AND DATEDIFF(dy, 0, convert(DATETIME, AWAL_PERIKSA, 105)) >= DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('AWAL')."', 105))";
				$filter2 .= " AND DATEDIFF(dy, 0, convert(DATETIME, A.AWAL_PERIKSA, 105)) >= DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('AWAL')."', 105))";
				$fawal = "DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('AWAL')."', 105))";
				$awal = $this->input->post('AWAL');
			}else{
				$filter1 .= " AND AWAL_PERIKSA > GETDATE()";
				$filter2 .= " AND A.AWAL_PERIKSA > GETDATE()";
				$fawal = "DATEADD(M, DATEDIFF(M,0,GETDATE()),0)";
				$awal = date('01/m/Y');
			}
			if(trim($this->input->post('AKHIR')!="")){
				$filter1 .= " AND DATEDIFF(dy, 0, convert(DATETIME, AWAL_PERIKSA, 105)) <= DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('AKHIR')."', 105))";
				$filter2 .= " AND DATEDIFF(dy, 0, convert(DATETIME, A.AWAL_PERIKSA, 105)) <= DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('AKHIR')."', 105))";
				$fakhir = "DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('AKHIR')."', 105))";
				$akhir = $this->input->post('AKHIR');
			}else{
				$filter1 .= " AND AKHIR_PERIKSA < GETDATE()";
				$filter2 .= " AND A.AKHIR_PERIKSA < GETDATE()";
				$fakhir =  "DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,0,GETDATE())+1,0))";
				$akhir = date('t/m/Y');
			}
			if(in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')) || $this->newsession->userdata('SESS_BBPOM_ID') == "00"){
				if(trim($this->input->post('BBPOM_ID'))==""){
					$filter2 .= "";
					$balai = 'Seluruh Balai';
				}else{
					$filter2 .= " AND A.BBPOM_ID = '".$this->input->post('BBPOM_ID')."'";
					$balai = $sipt->main->get_uraian("SELECT NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID = '".$this->input->post('BBPOM_ID')."'","NAMA_BBPOM");		
				}
			}else{
				$filter2 .= " AND A.BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'";
				$balai = $sipt->main->get_uraian("SELECT NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","NAMA_BBPOM");		
			}
			$query = " SELECT DISTINCT(REPLACE(REPLACE(C.NAMA_BBPOM,'BALAI BESAR POM', 'BBPOM'),'BALAI POM','BPOM')) AS NAMA_BBPOM,
			(SELECT COUNT(JENIS_SARANA_ID) FROM T_PEMERIKSAAN WHERE JENIS_SARANA_ID = '02PK' AND BBPOM_ID = C.BBPOM_ID $filter1) AS JMLPERIKSA, 
			(SELECT COUNT(JENIS_SARANA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'MK' AND JENIS_SARANA_ID = '02PK' AND BBPOM_ID = C.BBPOM_ID $filter1) AS MK, 
			(SELECT COUNT(JENIS_SARANA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'TMK' AND JENIS_SARANA_ID = '02PK' AND BBPOM_ID = C.BBPOM_ID $filter1) AS TMK,
			dbo.HITUNG_SATUAN('kotak','011',C.BBPOM_ID,".$fawal.",".$fakhir.") AS KOTAK, 
			dbo.HITUNG_SATUAN('bungkus','011',C.BBPOM_ID,".$fawal.",".$fakhir.") AS BUNGKUS, 
			dbo.HITUNG_SATUAN('kapsul','011',C.BBPOM_ID,".$fawal.",".$fakhir.") AS KAPSUL, 
			dbo.HITUNG_SATUAN('botol','011',C.BBPOM_ID,".$fawal.",".$fakhir.") AS BOTOL, 
			dbo.HITUNG_SATUAN('buah','011',C.BBPOM_ID,".$fawal.",".$fakhir.") AS BUAH, 
			dbo.HITUNG_SATUAN('tube','011',C.BBPOM_ID,".$fawal.",".$fakhir.") AS TUBE, 
			dbo.TOT_HARGA('011',C.BBPOM_ID,".$fawal.",".$fakhir.") AS TOTAL_HARGA 
			FROM T_PEMERIKSAAN A LEFT JOIN M_BBPOM C ON A.BBPOM_ID = C.BBPOM_ID 
			WHERE A.JENIS_SARANA_ID = '".$this->input->post('JENIS')."' $filter2 ORDER BY 1";
			$data = $sipt->main->get_result($query);
			$kolom = array();
			if($data){
				foreach($query->result_array() as $row){
					$kolom[] = $row;
					$arrdata = array('kolom' => $kolom);
				}
			}
			$arrdata['judul'] = strtoupper($sipt->main->get_uraian("SELECT dbo.NAMA_JENIS_SARANA('".$this->input->post('JENIS')."') AS JUDUL","JUDUL"));
			$arrdata['awal'] = $awal;
			$arrdata['akhir'] = $akhir;
			$arrdata['balai'] = $balai;
			return $arrdata;
		}
	}
	
	function rekap_01JJ(){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$filter1 = "";
			$filter2 = "";
			if(trim($this->input->post('AWAL')!="")){
				$filter1 .= " AND DATEDIFF(dy, 0, convert(DATETIME, AWAL_PERIKSA, 105)) >= DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('AWAL')."', 105))";
				$filter2 .= " AND DATEDIFF(dy, 0, convert(DATETIME, A.AWAL_PERIKSA, 105)) >= DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('AWAL')."', 105))";
				$awal = $this->input->post('AWAL');
			}else{
				$filter1 .= " AND AWAL_PERIKSA > GETDATE()";
				$filter2 .= " AND A.AWAL_PERIKSA > GETDATE()";
				$awal = date('01/m/Y');
			}
			if(trim($this->input->post('AKHIR')!="")){
				$filter1 .= " AND DATEDIFF(dy, 0, convert(DATETIME, AWAL_PERIKSA, 105)) <= DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('AKHIR')."', 105))";
				$filter2 .= " AND DATEDIFF(dy, 0, convert(DATETIME, A.AWAL_PERIKSA, 105)) <= DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('AKHIR')."', 105))";
				$akhir = $this->input->post('AKHIR');
			}else{
				$filter1 .= " AND AKHIR_PERIKSA < GETDATE()";
				$filter2 .= " AND A.AKHIR_PERIKSA < GETDATE()";
				$akhir = date('t/m/Y');
			}
			if(in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')) || $this->newsession->userdata('SESS_BBPOM_ID') == "00"){
				if(trim($this->input->post('BBPOM_ID'))==""){
					$filter2 .= "";
					$balai = 'Seluruh Balai';
				}else{
					$filter2 .= " AND A.BBPOM_ID = '".$this->input->post('BBPOM_ID')."'";
					$balai = $sipt->main->get_uraian("SELECT NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID = '".$this->input->post('BBPOM_ID')."'","NAMA_BBPOM");		
				}
			}else{
				$filter2 .= " AND A.BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'";
				$balai = $sipt->main->get_uraian("SELECT NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","NAMA_BBPOM");		
			}
			$query = "SELECT DISTINCT(REPLACE(REPLACE(C.NAMA_BBPOM,'BALAI BESAR POM', 'BBPOM'),'BALAI POM','BPOM')) AS NAMA_BBPOM, 
					 (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE JENIS_SARANA_ID = '01JJ' AND BBPOM_ID = C.BBPOM_ID $filter1) AS JMLPERIKSA,
					 (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'BAIK SEKALI' AND JENIS_SARANA_ID = '01JJ' AND BBPOM_ID = C.BBPOM_ID $filter1) AS JMLBAIKSEKALI,
					 (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'BAIK' AND JENIS_SARANA_ID = '01JJ' AND BBPOM_ID = C.BBPOM_ID $filter1) AS JMLBAIK,
					 (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'KURANG' AND JENIS_SARANA_ID = '01JJ' AND BBPOM_ID = C.BBPOM_ID $filter1) AS JMLKURANG,
					 (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'JELEK' AND JENIS_SARANA_ID = '01JJ' AND BBPOM_ID = C.BBPOM_ID $filter1) AS JMLJELEK
					 FROM T_PEMERIKSAAN A LEFT JOIN M_BBPOM C ON A.BBPOM_ID = C.BBPOM_ID WHERE A.JENIS_SARANA_ID = '01JJ' $filter2 ORDER BY 1";
			$data = $sipt->main->get_result($query);
			$kolom = array();
			if($data){
				foreach($query->result_array() as $row){
					$kolom[] = $row;
					$arrdata = array('kolom' => $kolom);
				}
			}
			$arrdata['judul'] = strtoupper($sipt->main->get_uraian("SELECT dbo.NAMA_JENIS_SARANA('".$this->input->post('JENIS')."') AS JUDUL","JUDUL"));
			$arrdata['awal'] = $awal;
			$arrdata['akhir'] = $akhir;
			$arrdata['balai'] = $balai;
			return $arrdata;
		}
	
	}
	
	function rekap_01VV(){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$filter1 = "";
			$filter2 = "";
			if(trim($this->input->post('AWAL')!="")){
				$filter1 .= " AND DATEDIFF(dy, 0, convert(DATETIME, AWAL_PERIKSA, 105)) >= DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('AWAL')."', 105))";
				$filter2 .= " AND DATEDIFF(dy, 0, convert(DATETIME, A.AWAL_PERIKSA, 105)) >= DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('AWAL')."', 105))";
				$fawal = "DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('AWAL')."', 105))";
				$awal = $this->input->post('AWAL');
			}else{
				$filter1 .= " AND AWAL_PERIKSA > GETDATE()";
				$filter2 .= " AND A.AWAL_PERIKSA > GETDATE()";
				$fawal = "DATEADD(M, DATEDIFF(M,0,GETDATE()),0)";
				$awal = date('01/m/Y');
			}
			if(trim($this->input->post('AKHIR')!="")){
				$filter1 .= " AND DATEDIFF(dy, 0, convert(DATETIME, AWAL_PERIKSA, 105)) <= DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('AKHIR')."', 105))";
				$filter2 .= " AND DATEDIFF(dy, 0, convert(DATETIME, A.AWAL_PERIKSA, 105)) <= DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('AKHIR')."', 105))";
				$fakhir = "DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('AKHIR')."', 105))";
				$akhir = $this->input->post('AKHIR');
			}else{
				$filter1 .= " AND AKHIR_PERIKSA < GETDATE()";
				$filter2 .= " AND A.AKHIR_PERIKSA < GETDATE()";
				$fakhir =  "DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,0,GETDATE())+1,0))";
				$akhir = date('t/m/Y');
			}
			if(in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')) || $this->newsession->userdata('SESS_BBPOM_ID') == "00"){
				if(trim($this->input->post('BBPOM_ID'))==""){
					$filter2 .= "";
					$balai = 'Seluruh Balai';
				}else{
					$filter2 .= " AND A.BBPOM_ID = '".$this->input->post('BBPOM_ID')."'";
					$balai = $sipt->main->get_uraian("SELECT NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID = '".$this->input->post('BBPOM_ID')."'","NAMA_BBPOM");		
				}
			}else{
				$filter2 .= " AND A.BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'";
				$balai = $sipt->main->get_uraian("SELECT NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","NAMA_BBPOM");		
			}
			$query = "SELECT DISTINCT(REPLACE(REPLACE(C.NAMA_BBPOM,'BALAI BESAR POM', 'BBPOM'),'BALAI POM','BPOM')) AS NAMA_BBPOM, 
					 (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE JENIS_SARANA_ID = '01VV' AND BBPOM_ID = C.BBPOM_ID $filter1) AS JMLPERIKSA,
					 (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'BAIK' AND JENIS_SARANA_ID = '01VV' AND BBPOM_ID = C.BBPOM_ID $filter1) AS BAIK, 
					 (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'CUKUP' AND JENIS_SARANA_ID = '01VV' AND BBPOM_ID = C.BBPOM_ID $filter1) AS CUKUP, 
					 (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'KURANG' AND JENIS_SARANA_ID = '01VV' AND BBPOM_ID = C.BBPOM_ID $filter1) AS KURANG, 
					 dbo.TINDAKAN_SARANA_PANGAN('%Pembinaan%',C.BBPOM_ID, '01VV',".$fawal.",".$fakhir.") AS PEMBINAAN, 
					 dbo.TINDAKAN_SARANA_PANGAN('%Surat Peringatan%',C.BBPOM_ID, '01VV',".$fawal.",".$fakhir.") AS SP,
					 dbo.TINDAKAN_SARANA_PANGAN('%Pencabutan Nomor Pendaftaran (Usul)%',C.BBPOM_ID, '01VV',".$fawal.",".$fakhir.") AS PNP,
					 dbo.TINDAKAN_SARANA_PANGAN('%Pengamanan%',C.BBPOM_ID, '01VV',".$fawal.",".$fakhir.") AS PENGAMANAN,
					 dbo.TINDAKAN_SARANA_PANGAN('%Perintah Penarikan%',C.BBPOM_ID, '01VV',".$fawal.",".$fakhir.") AS PP,
					 dbo.TINDAKAN_SARANA_PANGAN('%Pemusnahan Produk%',C.BBPOM_ID, '01VV',".$fawal.",".$fakhir.") AS PEMUSNAHAN 
					 FROM T_PEMERIKSAAN A LEFT JOIN M_BBPOM C ON A.BBPOM_ID = C.BBPOM_ID WHERE A.JENIS_SARANA_ID = '01VV' $filter2 ORDER BY 1";
			$data = $sipt->main->get_result($query);
			$kolom = array();
			if($data){
				foreach($query->result_array() as $row){
					$kolom[] = $row;
					$arrdata = array('kolom' => $kolom);
				}
			}
			$arrdata['judul'] = strtoupper($sipt->main->get_uraian("SELECT dbo.NAMA_JENIS_SARANA('".$this->input->post('JENIS')."') AS JUDUL","JUDUL"));
			$arrdata['awal'] = $awal;
			$arrdata['akhir'] = $akhir;
			$arrdata['balai'] = $balai;
			return $arrdata;
		}
	}
	
	function rekap_02PG(){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$filter1 = "";
			$filter2 = "";
			if(trim($this->input->post('AWAL')!="")){
				$filter1 .= " AND DATEDIFF(dy, 0, convert(DATETIME, AWAL_PERIKSA, 105)) >= DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('AWAL')."', 105))";
				$filter2 .= " AND DATEDIFF(dy, 0, convert(DATETIME, A.AWAL_PERIKSA, 105)) >= DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('AWAL')."', 105))";
				$fawal = "DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('AWAL')."', 105))";
				$awal = $this->input->post('AWAL');
			}else{
				$filter1 .= " AND AWAL_PERIKSA > GETDATE()";
				$filter2 .= " AND A.AWAL_PERIKSA > GETDATE()";
				$fawal = "DATEADD(M, DATEDIFF(M,0,GETDATE()),0)";
				$awal = date('01/m/Y');
			}
			if(trim($this->input->post('AKHIR')!="")){
				$filter1 .= " AND DATEDIFF(dy, 0, convert(DATETIME, AWAL_PERIKSA, 105)) <= DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('AKHIR')."', 105))";
				$filter2 .= " AND DATEDIFF(dy, 0, convert(DATETIME, A.AWAL_PERIKSA, 105)) <= DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('AKHIR')."', 105))";
				$fakhir = "DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('AKHIR')."', 105))";
				$akhir = $this->input->post('AKHIR');
			}else{
				$filter1 .= " AND AKHIR_PERIKSA < GETDATE()";
				$filter2 .= " AND A.AKHIR_PERIKSA < GETDATE()";
				$fakhir =  "DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,0,GETDATE())+1,0))";
				$akhir = date('t/m/Y');
			}
			if(in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')) || $this->newsession->userdata('SESS_BBPOM_ID') == "00"){
				if(trim($this->input->post('BBPOM_ID'))==""){
					$filter2 .= "";
					$balai = 'Seluruh Balai';
				}else{
					$filter2 .= " AND A.BBPOM_ID = '".$this->input->post('BBPOM_ID')."'";
					$balai = $sipt->main->get_uraian("SELECT NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID = '".$this->input->post('BBPOM_ID')."'","NAMA_BBPOM");		
				}
			}else{
				$filter2 .= " AND A.BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'";
				$balai = $sipt->main->get_uraian("SELECT NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","NAMA_BBPOM");		
			}
			$query = " SELECT DISTINCT(REPLACE(REPLACE(C.NAMA_BBPOM,'BALAI BESAR POM', 'BBPOM'),'BALAI POM','BPOM')) AS NAMA_BBPOM, 
					  (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE JENIS_SARANA_ID = '02PG' AND BBPOM_ID = C.BBPOM_ID $filter1) AS JMLPERIKSA, (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'BAIK' AND JENIS_SARANA_ID = '02PG' AND BBPOM_ID = C.BBPOM_ID $filter1) AS BAIK, 
					  (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'CUKUP' AND JENIS_SARANA_ID = '02PG' AND BBPOM_ID = C.BBPOM_ID $filter1) AS CUKUP, 
					  (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'KURANG' AND JENIS_SARANA_ID = '02PG' AND BBPOM_ID = C.BBPOM_ID $filter1) AS KURANG, 
					  dbo.TINDAKAN_SARANA_PANGAN('%Pembinaan%',C.BBPOM_ID, '02PG',".$fawal.",".$fakhir.") AS PEMBINAAN, 
					  dbo.TINDAKAN_SARANA_PANGAN('%Surat Peringatan%',C.BBPOM_ID, '02PG',".$fawal.",".$fakhir.") AS SP,
					  dbo.TINDAKAN_SARANA_PANGAN('%Pengamanan%',C.BBPOM_ID, '02PG',".$fawal.",".$fakhir.") AS PENGAMANAN,
					  dbo.TINDAKAN_SARANA_PANGAN('%Pemusnahan Produk%',C.BBPOM_ID, '02PG',".$fawal.",".$fakhir.") AS PEMUSNAHAN,
					  dbo.TINDAKAN_SARANA_PANGAN('%Pengambilan Sampel%',C.BBPOM_ID, '02PG',".$fawal.",".$fakhir.") AS SAMPEL,
					  dbo.TINDAKAN_SARANA_PANGAN('%Pemanggilan Resmi%',C.BBPOM_ID, '02PG',".$fawal.",".$fakhir.") AS PEMANGGILAN,
					  dbo.TINDAKAN_SARANA_PANGAN('%Perintah Pengambilan / Retur%',C.BBPOM_ID, '02PG',".$fawal.",".$fakhir.") AS RETUR,
					  dbo.TINDAKAN_SARANA_PANGAN('%Projusticia%',C.BBPOM_ID, '02PG',".$fawal.",".$fakhir.") AS PROJUSTICIA,
					  dbo.TEMUAN_PRODUK_PANGAN('%TIE%',C.BBPOM_ID, '013','02PG',".$fawal.",".$fakhir.") AS PRODUKTIE,
					  dbo.TEMUAN_PRODUK_PANGAN('%Rusak%',C.BBPOM_ID, '013','02PG',".$fawal.",".$fakhir.") AS PRODUKRUSAK,
					  dbo.TEMUAN_PRODUK_PANGAN('%Expire Date%',C.BBPOM_ID, '013','02PG',".$fawal.",".$fakhir.") AS ED,
					  dbo.TEMUAN_PRODUK_PANGAN('%TMK%',C.BBPOM_ID, '013','02PG',".$fawal.",".$fakhir.") AS TMKLABEL,
					  dbo.TEMUAN_PRODUK_PANGAN('%Bahan%',C.BBPOM_ID, '013','02PG',".$fawal.",".$fakhir.") AS BB 
					  FROM T_PEMERIKSAAN A LEFT JOIN M_BBPOM C ON A.BBPOM_ID = C.BBPOM_ID WHERE A.JENIS_SARANA_ID = '02PG' $filter2 ORDER BY 1";
			$data = $sipt->main->get_result($query);
			$kolom = array();
			if($data){
				foreach($query->result_array() as $row){
					$kolom[] = $row;
					$arrdata = array('kolom' => $kolom);
				}
			}
			$arrdata['judul'] = strtoupper($sipt->main->get_uraian("SELECT dbo.NAMA_JENIS_SARANA('".$this->input->post('JENIS')."') AS JUDUL","JUDUL"));
			$arrdata['awal'] = $awal;
			$arrdata['akhir'] = $akhir;
			$arrdata['balai'] = $balai;
			return $arrdata;
		}
	}
	
	function rekap_02PR(){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$filter1 = "";
			$filter2 = "";
			if(trim($this->input->post('AWAL')!="")){
				$filter1 .= " AND DATEDIFF(dy, 0, convert(DATETIME, AWAL_PERIKSA, 105)) >= DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('AWAL')."', 105))";
				$filter2 .= " AND DATEDIFF(dy, 0, convert(DATETIME, A.AWAL_PERIKSA, 105)) >= DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('AWAL')."', 105))";
				$fawal = "DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('AWAL')."', 105))";
				$awal = $this->input->post('AWAL');
			}else{
				$filter1 .= " AND AWAL_PERIKSA > GETDATE()";
				$filter2 .= " AND A.AWAL_PERIKSA > GETDATE()";
				$fawal = "DATEADD(M, DATEDIFF(M,0,GETDATE()),0)";
				$awal = date('01/m/Y');
			}
			if(trim($this->input->post('AKHIR')!="")){
				$filter1 .= " AND DATEDIFF(dy, 0, convert(DATETIME, AWAL_PERIKSA, 105)) <= DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('AKHIR')."', 105))";
				$filter2 .= " AND DATEDIFF(dy, 0, convert(DATETIME, A.AWAL_PERIKSA, 105)) <= DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('AKHIR')."', 105))";
				$fakhir = "DATEDIFF(dy, 0, convert(DATETIME, '".$this->input->post('AKHIR')."', 105))";
				$akhir = $this->input->post('AKHIR');
			}else{
				$filter1 .= " AND AKHIR_PERIKSA < GETDATE()";
				$filter2 .= " AND A.AKHIR_PERIKSA < GETDATE()";
				$fakhir =  "DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,0,GETDATE())+1,0))";
				$akhir = date('t/m/Y');
			}
			if(in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')) || $this->newsession->userdata('SESS_BBPOM_ID') == "00"){
				if(trim($this->input->post('BBPOM_ID'))==""){
					$filter2 .= "";
					$balai = 'Seluruh Balai';
				}else{
					$filter2 .= " AND A.BBPOM_ID = '".$this->input->post('BBPOM_ID')."'";
					$balai = $sipt->main->get_uraian("SELECT NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID = '".$this->input->post('BBPOM_ID')."'","NAMA_BBPOM");		
				}
			}else{
				$filter2 .= " AND A.BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'";
				$balai = $sipt->main->get_uraian("SELECT NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","NAMA_BBPOM");		
			}
			$query = " SELECT DISTINCT(REPLACE(REPLACE(C.NAMA_BBPOM,'BALAI BESAR POM', 'BBPOM'),'BALAI POM','BPOM')) AS NAMA_BBPOM, 
					  (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE JENIS_SARANA_ID = '02PR' AND BBPOM_ID = C.BBPOM_ID $filter1) AS JMLPERIKSA,
					  (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'MK' AND JENIS_SARANA_ID = '02PR' AND BBPOM_ID = C.BBPOM_ID $filter1) AS MK,
					  (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'TMK' AND JENIS_SARANA_ID = '02PR' AND BBPOM_ID = C.BBPOM_ID $filter1) AS TMK, 
					  dbo.TINDAKAN_SARANA_PANGAN('%parcel%',C.BBPOM_ID, '02PR',".$fawal.",".$fakhir.") AS PRODUKPARCEL,
					  dbo.TINDAKAN_SARANA_PANGAN('%diamankan%',C.BBPOM_ID, '02PR',".$fawal.",".$fakhir.") AS DIAMANKAN,
					  dbo.TINDAKAN_SARANA_PANGAN('%dimusnhakan%',C.BBPOM_ID, '02PR',".$fawal.",".$fakhir.") AS DISMUNAHKAN,
					  dbo.TINDAKAN_SARANA_PANGAN('%penyalur%',C.BBPOM_ID, '02PR',".$fawal.",".$fakhir.") AS PENYALUR,
					  dbo.TINDAKAN_SARANA_PANGAN('%teguran%',C.BBPOM_ID, '02PR',".$fawal.",".$fakhir.") AS TEGURAN,
					  dbo.TINDAKAN_SARANA_PANGAN('%Projusticia',C.BBPOM_ID, '02PR',".$fawal.",".$fakhir.") AS PROJUSTICIA,
					  dbo.TEMUAN_PRODUK_PANGAN('%TIE%',C.BBPOM_ID, '013','02PR',".$fawal.",".$fakhir.") AS PRODUKTIE,
					  dbo.TEMUAN_PRODUK_PANGAN('%Rusak%',C.BBPOM_ID, '013','02PR',".$fawal.",".$fakhir.") AS PRODUKRUSAK, 
					  dbo.TEMUAN_PRODUK_PANGAN('%Expire Date%',C.BBPOM_ID, '013','02PR',".$fawal.",".$fakhir.") AS ED,
					  dbo.TEMUAN_PRODUK_PANGAN('%TMK%',C.BBPOM_ID, '013','02PR',".$fawal.",".$fakhir.") AS TMKLABEL,
					  dbo.TEMUAN_PRODUK_PANGAN('%Bahan%',C.BBPOM_ID, '013','02PR',".$fawal.",".$fakhir.") AS BB 
					  FROM T_PEMERIKSAAN A LEFT JOIN M_BBPOM C ON A.BBPOM_ID = C.BBPOM_ID WHERE A.JENIS_SARANA_ID = '02PR' $filter2 ORDER BY 1";
			$data = $sipt->main->get_result($query);
			$kolom = array();
			if($data){
				foreach($query->result_array() as $row){
					$kolom[] = $row;
					$arrdata = array('kolom' => $kolom);
				}
			}
			$arrdata['judul'] = strtoupper($sipt->main->get_uraian("SELECT dbo.NAMA_JENIS_SARANA('".$this->input->post('JENIS')."') AS JUDUL","JUDUL"));
			$arrdata['awal'] = $awal;
			$arrdata['akhir'] = $akhir;
			$arrdata['balai'] = $balai;
			return $arrdata;
		}
	}

}
?>