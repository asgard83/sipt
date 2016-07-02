<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Chart extends Controller{
	function Chart(){
		parent::Controller();
	}

	function index(){
		$this->load->view('chart');
	}
	
	function sarana(){
		$sipt =& get_instance();
		$this->load->model("main", "main", true);
		$query = "SELECT  (SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE LEFT(JENIS_SARANA_ID, 2) = '01') AS PRODUKSI, (SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE LEFT(JENIS_SARANA_ID, 2) = '02' ) AS DISTRIBUSI, (SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE LEFT(JENIS_SARANA_ID, 2) = '03' AND AWAL_PERIKSA > '01/01/2012' AND AKHIR_PERIKSA < '06/09/2012') AS PELAYANAN";
		$data = $sipt->main->get_result($query);
		if($data){
			$ret [] = array("","Produksi","Distribusi","Pelayanan");
			foreach($query->result_array() as $row){
				$ret[] = array("",$row['PRODUKSI'],$row['DISTRIBUSI'],$row['PELAYANAN']);
			}
		}
		echo json_encode($ret);
	}
	
	function hari(){
		$sipt =& get_instance();
		$this->load->model("main", "main", true);
		$query = "SELECT * FROM ( SELECT REPLACE(REPLACE(B.NAMA_BBPOM,'BALAI BESAR POM DI ', ''),'BALAI POM DI ','') AS [BBPOMDI], A.PERIKSA_ID,  CASE DATENAME(dw, A.AWAL_PERIKSA) WHEN 'Monday' THEN 'Senin' WHEN 'Tuesday' THEN 'Selasa' WHEN 'Wednesday' THEN 'Rabu' WHEN 'Thursday' THEN 'Kamis' WHEN 'Friday' THEN 'Jumat' WHEN 'Saturday' THEN 'Sabtu' WHEN 'Sunday' THEN 'Minggu' END AS HARI FROM T_PEMERIKSAAN A LEFT JOIN M_BBPOM B ON A.BBPOM_ID = B.BBPOM_ID WHERE A.BBPOM_ID = '12') AS DT PIVOT (COUNT(PERIKSA_ID) FOR HARI IN ([Senin], [Selasa], [Rabu], [Kamis], [Jumat], [Sabtu], [Minggu]) ) AS PVT ORDER BY PVT.BBPOMDI ASC";
		$data = $sipt->main->get_result($query);
		if($data){
			$ret [] = array("BBPOM DI","Senin","Selasa","Rabu","Kamis","Jumat");
			foreach($query->result_array() as $row){
				$ret[] = array($row['BBPOMDI'],$row['Senin'],$row['Selasa'],$row['Rabu'],$row['Kamis'],$row['Jumat']);
			}
		}			
		echo json_encode($ret);
	}
	
	function distribusi(){
		$sipt =& get_instance();
		$this->load->model("main", "main", true);
		$query = "SELECT * FROM(SELECT 
	CASE JENIS_SARANA_ID 
		WHEN '02MM' THEN 'PBF' 
		WHEN '02LL' THEN 'PBBBF' 
		WHEN '02TF' THEN 'GFK' 
		WHEN '02MN' THEN 'PBF - Napza' 
		WHEN '02TN' THEN 'GFK - Napza' 
		WHEN '02OT' THEN 'Obat Tradisional' 
		WHEN '02KO' THEN 'Kosmetika' 
		WHEN '02PK' THEN 'Suplemen Makanan' 
		WHEN '02PG' THEN 'Pangan' 
		WHEN '02PR' THEN 'Pangan - Parcel' 
		END AS JENIS_SARANA 
	FROM T_PEMERIKSAAN WHERE STATUS NOT IN ('00')
)DT PIVOT(COUNT(JENIS_SARANA) FOR JENIS_SARANA
	IN ([PBF],[PBBBF],[GFK],[PBF - Napza],[GFK - Napza],[Obat Tradisional],[Kosmetika],
		[Suplemen Makanan],[Pangan],[Pangan - Parcel])) PVT";
		$data = $sipt->main->get_result($query);
		if($data){
			$ret [] = array("","PBF","PBBF","GFK","PBF - Napza", "GFK - Napza","Obat Tradisional","Kosmetika","Suplemen Makanan","Pangan","Intensifikasi Pengawasan Khusus");
			foreach($query->result_array() as $row){
				$ret[] = array("",$row['PBF'],$row['PBBBF'],$row['GFK'],$row['PBF - Napza'],$row['GFK - Napza'],$row['Obat Tradisional'],$row['Kosmetika'],$row['Suplemen Makanan'],$row['Pangan'],$row['Pangan - Parcel']);
			}
		}			
		echo json_encode($ret);

	}
	
	function dist($deputi="deputi", $id=""){
		$sipt =& get_instance();
		$this->load->model("main", "main", true);
		if($id == "2"){			
			$arrdata[] = array("Distribusi", "Diperiksa", "Hasil MK", "Hasil TMK");
			$dist_ot = "SELECT DISTINCT(B.NAMA_JENIS_SARANA) AS [JENIS SARANA], 
(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE JENIS_SARANA_ID IN ('02OT','02KO','02PK') AND JENIS_SARANA_ID = A.JENIS_SARANA_ID) AS JMLPERIKSA,
(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'MK' AND JENIS_SARANA_ID IN ('02OT','02KO','02PK') AND JENIS_SARANA_ID = A.JENIS_SARANA_ID) AS MK,
(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'TMK' AND JENIS_SARANA_ID IN ('02OT','02KO','02PK') AND JENIS_SARANA_ID = A.JENIS_SARANA_ID) AS TMK
FROM T_PEMERIKSAAN A LEFT JOIN M_JENIS_SARANA B ON A.JENIS_SARANA_ID = B.JENIS_SARANA_ID
WHERE A.JENIS_SARANA_ID IN ('02OT','02KO','02PK')";
			$data_ot = $sipt->main->get_result($dist_ot);
			if($data_ot){
				foreach($dist_ot->result_array() as $row_ot){
					$arrdata[] = array($row_ot['JENIS SARANA'],$row_ot['JMLPERIKSA'],$row_ot['MK'],$row_ot['TMK']);
				}
			}			

			echo json_encode($arrdata);			
		}else if($id == "1"){			
			$arrdata[] = array("Distribusi", "Diperiksa", "Hasil MK", "Hasil TMK", "Tutup", "Tidak Dapat Diperiksa");
			$dist_pbf = "SELECT DISTINCT(B.NAMA_JENIS_SARANA) AS [JENIS SARANA], 
(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE JENIS_SARANA_ID IN ('02MM','02LL','02TF') AND JENIS_SARANA_ID = A.JENIS_SARANA_ID) AS JMLPERIKSA,
(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'MK' AND JENIS_SARANA_ID IN ('02MM','02LL','02TF') AND JENIS_SARANA_ID = A.JENIS_SARANA_ID) AS MK,
(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'TMK' AND JENIS_SARANA_ID IN ('02MM','02LL','02TF') AND JENIS_SARANA_ID = A.JENIS_SARANA_ID) AS TMK,
(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'TTP' AND JENIS_SARANA_ID IN ('02MM','02LL','02TF') AND JENIS_SARANA_ID = A.JENIS_SARANA_ID) AS TUTUP,
(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'TDP' AND JENIS_SARANA_ID IN ('02MM','02LL','02TF') AND JENIS_SARANA_ID = A.JENIS_SARANA_ID) AS TDP
FROM T_PEMERIKSAAN A LEFT JOIN M_JENIS_SARANA B ON A.JENIS_SARANA_ID = B.JENIS_SARANA_ID
WHERE A.JENIS_SARANA_ID IN ('02MM','02LL','02TF')";
			$data_pbf = $sipt->main->get_result($dist_pbf);
			if($data_pbf){
				foreach($dist_pbf->result_array() as $row_pbf){
					$arrdata[] = array($row_pbf['JENIS SARANA'],$row_pbf['JMLPERIKSA'],$row_pbf['MK'],$row_pbf['TMK'],$row_pbf['TUTUP'],$row_pbf['TDP']);
				}
			}				
			echo json_encode($arrdata);
		}else if($id=="3"){
			$arrdata[] = array("Distribusi Pangan","Diperiksa", "Baik", "Cukup", "Kurang","TMK","MK");
			$dist_pg = "SELECT DISTINCT(B.NAMA_JENIS_SARANA) AS [JENIS SARANA], 
(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE JENIS_SARANA_ID IN ('02PG','02PR') AND JENIS_SARANA_ID = A.JENIS_SARANA_ID) AS JMLPERIKSA,
(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'MK' AND JENIS_SARANA_ID IN ('02PR') AND JENIS_SARANA_ID = A.JENIS_SARANA_ID) AS MK,
(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'TMK' AND JENIS_SARANA_ID IN ('02PR') AND JENIS_SARANA_ID = A.JENIS_SARANA_ID) AS TMK,
(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'BAIK' AND JENIS_SARANA_ID IN ('02PG') AND JENIS_SARANA_ID = A.JENIS_SARANA_ID) AS BAIK,
(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'CUKUP' AND JENIS_SARANA_ID IN ('02PG') AND JENIS_SARANA_ID = A.JENIS_SARANA_ID) AS CUKUP,
(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'KURANG' AND JENIS_SARANA_ID IN ('02PG') AND JENIS_SARANA_ID = A.JENIS_SARANA_ID) AS KURANG
FROM T_PEMERIKSAAN A LEFT JOIN M_JENIS_SARANA B ON A.JENIS_SARANA_ID = B.JENIS_SARANA_ID
WHERE A.JENIS_SARANA_ID IN ('02PG','02PR')";
			$data_pg = $sipt->main->get_result($dist_pg);
			if($data_pg){
				foreach($dist_pg->result_array() as $row_pg){
					$arrdata[] = array($row_pg['JENIS SARANA'],$row_pg['JMLPERIKSA'],$row_pg['BAIK'],$row_pg['CUKUP'],$row_pg['KURANG'],$row_pg['TMK'],$row_pg['MK']);
				}
			}			
			echo json_encode($arrdata);
		}
		
	}
	
	function pelayanan($deputi="1", $id=""){
		$sipt =& get_instance();
		$this->load->model("main", "main", true);
		if($id == "2"){
			$arrdata[] = array("Pelayanan", "Diperiksa", "Hasil MK", "Hasil TMK", "Tutup", "Tidak Dapat Diperiksa");
			$qapotek = "SELECT DISTINCT(B.NAMA_JENIS_SARANA) AS [JENIS SARANA], 
(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE JENIS_SARANA_ID = '03AA') AS JMLPERIKSA,
(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'MK' AND JENIS_SARANA_ID = '03AA') AS MK,
(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'TMK' AND JENIS_SARANA_ID = '03AA') AS TMK,
(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'TTP' AND JENIS_SARANA_ID = '03AA') AS TUTUP,
(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'TDP' AND JENIS_SARANA_ID = '03AA') AS TDP
FROM T_PEMERIKSAAN A LEFT JOIN M_JENIS_SARANA B ON A.JENIS_SARANA_ID = B.JENIS_SARANA_ID
WHERE A.JENIS_SARANA_ID = '03AA'";
			$dapotek = $sipt->main->get_result($qapotek);
			if($dapotek){
				foreach($qapotek->result_array() as $row_apotek){
					$arrdata[] = array($row_apotek['JENIS SARANA'],$row_apotek['JMLPERIKSA'],$row_apotek['MK'],$row_apotek['TMK'],$row_apotek['TUTUP'],$row_apotek['TDP']);
				}
			}
			$qbb = "SELECT DISTINCT(B.NAMA_JENIS_SARANA) AS [JENIS SARANA], 
(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE JENIS_SARANA_ID = '03BB') AS JMLPERIKSA,
(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'MK' AND JENIS_SARANA_ID = '03BB') AS MK,
(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'TMK' AND JENIS_SARANA_ID = '03BB') AS TMK,
(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'TTP' AND JENIS_SARANA_ID = '03BB') AS TUTUP,
(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'TDP' AND JENIS_SARANA_ID = '03BB') AS TDP
FROM T_PEMERIKSAAN A LEFT JOIN M_JENIS_SARANA B ON A.JENIS_SARANA_ID = B.JENIS_SARANA_ID
WHERE A.JENIS_SARANA_ID = '03BB'";
			$dbb = $sipt->main->get_result($qbb);
			if($dbb){
				foreach($qbb->result_array() as $row_bb){
					$arrdata[] = array($row_bb['JENIS SARANA'],$row_bb['JMLPERIKSA'],$row_bb['MK'],$row_bb['TMK'],$row_bb['TUTUP'],$row_bb['TDP']);
				}
			}
			$qrs = "SELECT DISTINCT(B.NAMA_JENIS_SARANA) AS [JENIS SARANA], 
(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE JENIS_SARANA_ID = '03RS') AS JMLPERIKSA,
(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'MK' AND JENIS_SARANA_ID = '03RS') AS MK,
(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'TMK' AND JENIS_SARANA_ID = '03RS') AS TMK,
(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'TTP' AND JENIS_SARANA_ID = '03RS') AS TUTUP,
(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'TDP' AND JENIS_SARANA_ID = '03RS') AS TDP
FROM T_PEMERIKSAAN A LEFT JOIN M_JENIS_SARANA B ON A.JENIS_SARANA_ID = B.JENIS_SARANA_ID
WHERE A.JENIS_SARANA_ID = '03RS'";
			$drs = $sipt->main->get_result($qrs);
			if($drs){
				foreach($qrs->result_array() as $row_rs){
					$arrdata[] = array($row_rs['JENIS SARANA'],$row_rs['JMLPERIKSA'],$row_rs['MK'],$row_rs['TMK'],$row_rs['TUTUP'],$row_rs['TDP']);
				}
			}
			$qtr = "SELECT DISTINCT(B.NAMA_JENIS_SARANA) AS [JENIS SARANA], 
(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE JENIS_SARANA_ID = '03TR') AS JMLPERIKSA,
(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'MK' AND JENIS_SARANA_ID = '03TR') AS MK,
(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'TMK' AND JENIS_SARANA_ID = '03TR') AS TMK,
(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'TTP' AND JENIS_SARANA_ID = '03TR') AS TUTUP,
(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'TDP' AND JENIS_SARANA_ID = '03TR') AS TDP
FROM T_PEMERIKSAAN A LEFT JOIN M_JENIS_SARANA B ON A.JENIS_SARANA_ID = B.JENIS_SARANA_ID
WHERE A.JENIS_SARANA_ID = '03TR'";
			$dtr = $sipt->main->get_result($qtr);
			if($dtr){
				foreach($qtr->result_array() as $row_tr){
					$arrdata[] = array($row_tr['JENIS SARANA'],$row_tr['JMLPERIKSA'],$row_tr['MK'],$row_tr['TMK'],$row_tr['TUTUP'],$row_tr['TDP']);
				}
			}
			$qww = "SELECT DISTINCT(B.NAMA_JENIS_SARANA) AS [JENIS SARANA], 
(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE JENIS_SARANA_ID = '03WW') AS JMLPERIKSA,
(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'MK' AND JENIS_SARANA_ID = '03WW') AS MK,
(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'TMK' AND JENIS_SARANA_ID = '03WW') AS TMK,
(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'TTP' AND JENIS_SARANA_ID = '03WW') AS TUTUP,
(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'TDP' AND JENIS_SARANA_ID = '03WW') AS TDP
FROM T_PEMERIKSAAN A LEFT JOIN M_JENIS_SARANA B ON A.JENIS_SARANA_ID = B.JENIS_SARANA_ID
WHERE A.JENIS_SARANA_ID = '03WW'";
			$dww = $sipt->main->get_result($qww);
			if($dww){
				foreach($qww->result_array() as $row_ww){
					$arrdata[] = array($row_ww['JENIS SARANA'],$row_ww['JMLPERIKSA'],$row_ww['MK'],$row_ww['TMK'],$row_ww['TUTUP'],$row_ww['TDP']);
				}
			}
			echo json_encode($arrdata);			
		}
	}
	
	function wasza(){
		$sipt =& get_instance();
		$this->load->model("main", "main", true);
		$query = "SELECT DISTINCT(REPLACE(B.NAMA_JENIS_SARANA,'(Pengawasan NAPZA)','')) AS [JENIS SARANA], 
(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE JENIS_SARANA_ID LIKE '___N' AND JENIS_SARANA_ID = A.JENIS_SARANA_ID) AS JMLPERIKSA,
(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'MK' AND JENIS_SARANA_ID LIKE '___N' AND JENIS_SARANA_ID = A.JENIS_SARANA_ID) AS 'MK',
(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'Major' AND JENIS_SARANA_ID LIKE '___N' AND JENIS_SARANA_ID = A.JENIS_SARANA_ID) AS 'Major',
(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'Minor' AND JENIS_SARANA_ID LIKE '___N' AND JENIS_SARANA_ID = A.JENIS_SARANA_ID) AS 'Minor',
(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'Kritikal' AND JENIS_SARANA_ID LIKE '___N' AND JENIS_SARANA_ID = A.JENIS_SARANA_ID) AS 'Kritikal'
FROM T_PEMERIKSAAN A LEFT JOIN M_JENIS_SARANA B ON A.JENIS_SARANA_ID = B.JENIS_SARANA_ID
WHERE A.JENIS_SARANA_ID LIKE '___N'";
		$data = $sipt->main->get_result($query);
		if($data){
			$arrdata[] = array("Sarana Napza", "Diperiksa", "MK", "Major", "Minor", "Kritikal");
			foreach($query->result_array() as $row){
				  $arrdata[] = array($row["JENIS SARANA"],$row["JMLPERIKSA"],$row["MK"],$row["Major"],$row["Minor"],$row["Kritikal"]);
			}
			echo json_encode($arrdata);
		}
	}
	
	function produksi($deputi=""){
		$sipt =& get_instance();
		$this->load->model("main", "main", true);
		if($deputi=="1"){
			$query = "SELECT DISTINCT(B.NAMA_JENIS_SARANA) AS [JENIS SARANA], 
(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE JENIS_SARANA_ID = '01OO' AND JENIS_SARANA_ID = A.JENIS_SARANA_ID) AS JMLPERIKSA,
(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'MK' AND JENIS_SARANA_ID = '01OO' AND JENIS_SARANA_ID = A.JENIS_SARANA_ID) AS MK,
(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'Major' AND JENIS_SARANA_ID = '01OO' AND JENIS_SARANA_ID = A.JENIS_SARANA_ID) AS Major,
(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'Minor' AND JENIS_SARANA_ID = '01OO' AND JENIS_SARANA_ID = A.JENIS_SARANA_ID) AS Minor,
(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'Kritikal' AND JENIS_SARANA_ID = '01OO' AND JENIS_SARANA_ID = A.JENIS_SARANA_ID) AS Kritikal
FROM T_PEMERIKSAAN A LEFT JOIN M_JENIS_SARANA B ON A.JENIS_SARANA_ID = B.JENIS_SARANA_ID
WHERE A.JENIS_SARANA_ID = '01OO'";
			$data = $sipt->main->get_result($query);
			if($data){
				$arrdata[] = array("Produksi", "Diperiksa", "MK", "Major", "Minor","Kritikal");
				foreach($query->result_array() as $row){
					  $arrdata[] = array($row["JENIS SARANA"],$row["JMLPERIKSA"],$row["MK"],$row["Major"],$row["Minor"],$row["Kritikal"]);
				}
				echo json_encode($arrdata);
			}
		}else if($deputi=="2"){
			$query = "SELECT DISTINCT(B.NAMA_JENIS_SARANA) AS [JENIS SARANA], 
(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE JENIS_SARANA_ID IN ('01HH','01KO','01PK') AND JENIS_SARANA_ID = A.JENIS_SARANA_ID) AS JMLPERIKSA,
(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'MK' AND JENIS_SARANA_ID IN ('01HH','01KO','01PK') AND JENIS_SARANA_ID = A.JENIS_SARANA_ID) AS MK,
(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'TMK' AND JENIS_SARANA_ID IN ('01HH','01KO','01PK') AND JENIS_SARANA_ID = A.JENIS_SARANA_ID) AS TMK,
(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'TTP' AND JENIS_SARANA_ID IN ('01HH','01KO','01PK') AND JENIS_SARANA_ID = A.JENIS_SARANA_ID) AS TUTUP
FROM T_PEMERIKSAAN A LEFT JOIN M_JENIS_SARANA B ON A.JENIS_SARANA_ID = B.JENIS_SARANA_ID
WHERE A.JENIS_SARANA_ID IN ('01HH','01KO','01PK')";
			$data = $sipt->main->get_result($query);
			if($data){
				$arrdata[] = array("Produksi", "Diperiksa", "MK", "TMK", "Tutup");
				foreach($query->result_array() as $row){
					  $arrdata[] = array($row["JENIS SARANA"],$row["JMLPERIKSA"],$row["MK"],$row["TMK"],$row["TUTUP"]);
				}
				echo json_encode($arrdata);
			}
		}else if($deputi=="3"){
			$query = "SELECT DISTINCT(B.NAMA_JENIS_SARANA) AS [JENIS SARANA], 
(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE JENIS_SARANA_ID IN ('01JJ','01VV') AND JENIS_SARANA_ID = A.JENIS_SARANA_ID) AS JMLPERIKSA,
(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'BAIK' AND JENIS_SARANA_ID IN ('01JJ','01VV') AND JENIS_SARANA_ID = A.JENIS_SARANA_ID) AS BAIK,
(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'CUKUP' AND JENIS_SARANA_ID IN ('01JJ','01VV') AND JENIS_SARANA_ID = A.JENIS_SARANA_ID) AS CUKUP,
(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'KURANG' AND JENIS_SARANA_ID IN ('01JJ','01VV') AND JENIS_SARANA_ID = A.JENIS_SARANA_ID) AS KURANG,
(SELECT COUNT(*) FROM T_PEMERIKSAAN WHERE HASIL = 'JELEK' AND JENIS_SARANA_ID IN ('01JJ','01VV') AND JENIS_SARANA_ID = A.JENIS_SARANA_ID) AS JELEK
FROM T_PEMERIKSAAN A LEFT JOIN M_JENIS_SARANA B ON A.JENIS_SARANA_ID = B.JENIS_SARANA_ID
WHERE A.JENIS_SARANA_ID IN ('01JJ','01VV')";
			$data = $sipt->main->get_result($query);
			if($data){
				$arrdata[] = array("Produksi", "Diperiksa", "BAIK", "CUKUP", "KURANG","JELEK");
				foreach($query->result_array() as $row){
					  $arrdata[] = array($row["JENIS SARANA"],$row["JMLPERIKSA"],$row["BAIK"],$row["CUKUP"],$row["KURANG"],$row["JELEK"]);
				}
				echo json_encode($arrdata);
			}
		}
	}
	
	function produk(){
		$sipt =& get_instance();
		$this->load->model("main", "main", true);
		$query = "SELECT * FROM(SELECT CASE A.KK_ID 
WHEN '001' THEN 'Obat' WHEN '010' THEN 'Obat Tradisional' WHEN '011' THEN 'Produk Komplemen' 
WHEN '012' THEN 'Kosmetika' WHEN '013' THEN 'Produk Pangan'
END AS KK_ID 
FROM T_PEMERIKSAAN_TEMUAN_PRODUK A LEFT JOIN T_PEMERIKSAAN B ON A.PERIKSA_ID = B.PERIKSA_ID 
WHERE B.STATUS NOT IN ('00'))DT PIVOT(COUNT(KK_ID) FOR KK_ID IN ([Obat],[Narkotika],[Psikotropika],[Prekursor],[Obat Tradisional],[Produk Komplemen],[Kosmetika],[Produk Pangan])) PVT";
		$data = $sipt->main->get_result($query);
		if($data){
			$arrdata[] = array('','Obat','Obat Tradisional','Produk Komplemen','Kosmetika','Produk Pangan');
			foreach($query->result_array() as $row){
				$arrdata[] = array('',$row['Obat'],$row['Obat Tradisional'],$row['Produk Komplemen'],$row['Kosmetika'],$row['Produk Pangan']);
			}
			echo json_encode($arrdata);
		}
	}
	
	
}
?>