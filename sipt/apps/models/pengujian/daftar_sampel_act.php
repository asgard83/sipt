<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR);
class Daftar_sampel_act extends Model{
	function list_sampel($tipe,$status){
		if($this->newsession->userdata('LOGGED_IN')){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$this->load->library('newtable');
			if($tipe == "internal"){
				if(in_array('5',$this->newsession->userdata('SESS_KODE_ROLE'))){
					if($status == "pusat")
						$in = " AND STATUS_KIRIM = '1'";
					else
						$in = " AND STATUS_KIRIM = '0'";
					$this->newtable->action(site_url()."/home/pengujian/data/".$tipe."/".$status);
				}else{
					$in = "";
					$this->newtable->action(site_url()."/home/pengujian/data/".$tipe);
				}
				$judul = "Data Hasil Sampel Rutin";
				$query = "SELECT KODE_SAMPEL, NAMA_SAMPEL + '<div>' + dbo.FORMAT_NOMOR('SPL',KODE_SAMPEL) + '</div><div>' + BENTUK_SEDIAAN + '</div><div>' + PABRIK + '</div><div>' + NOMOR_REGISTRASI + ', No Batch  : ' +  NO_BETS + '</div><div>'+TEMPAT_SAMPLING+'</div>' AS [IDENTITAS SAMPEL], CAST(JUMLAH_SAMPEL AS VARCHAR) +'&nbsp;'+ SATUAN +'<div>&bull;&nbsp;Uji Kimia : '+ CAST(JUMLAH_KIMIA AS VARCHAR)+'</div><div>&bull;&nbsp;Uji Mikro : '+CAST(JUMLAH_MIKRO AS VARCHAR) +'</div><div>&bull;&nbsp;Sisa Sampel : '+CAST(SISA AS VARCHAR) +'</div><div>' +CASE WHEN UJI_KIMIA = '1' AND UJI_MIKRO = '1' THEN 'Uji Kimia - Mikro' WHEN UJI_KIMIA = '1' THEN 'Uji Kimia' WHEN UJI_MIKRO = '1' THEN 'Uji Mikro' END+ '</div>' AS [JUMLAH UJI], dbo.KATEGORI(KOMODITI,PRIORITAS) + '<div>' + NAMA_KATEGORI + '</div>' AS KOMODITI, '<div>Hasil Uji Kimia : ' + HASIL_KIMIA + '</div><div>Hasil Uji Mikro : ' + HASIL_MIKRO + '</div><div>Hasil Sampel : ' + HASIL_SAMPEL + '</div>' AS HASIL FROM T_M_SAMPEL_RILIS WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND ANGGARAN NOT IN ('05','06','07') $in";
				if(in_array('5',$this->newsession->userdata('SESS_KODE_ROLE')) && $status == "hasil"){
					$proses['Kirim Ke Pusat'] = array('POST', site_url().'/post/sampel/kirim_act/kirim/ajax', 'N');
				}
			}else if($tipe == "external"){
				if(in_array('5',$this->newsession->userdata('SESS_KODE_ROLE'))){
					if($status == "pusat")
						$in = " AND STATUS_KIRIM = '1'";
					else
						$in = " AND STATUS_KIRIM = '0'";
					$this->newtable->action(site_url()."/home/pengujian/data/".$tipe."/".$status);
				}else{
					$in = "";
					$this->newtable->action(site_url()."/home/pengujian/data/".$tipe);
				}
				$judul = "Data Hasil Sampel Pihak Ke - 3";
				$query = "SELECT KODE_SAMPEL, NAMA_SAMPEL + '<div>' + dbo.FORMAT_NOMOR('SPL',KODE_SAMPEL) + '</div><div>' + BENTUK_SEDIAAN + '</div><div>' + PABRIK + '</div><div>' + NOMOR_REGISTRASI + ', No Batch  : ' +  NO_BETS + '</div><div>'+TEMPAT_SAMPLING+'</div>' AS [IDENTITAS SAMPEL], CAST(JUMLAH_SAMPEL AS VARCHAR) +'&nbsp;'+ SATUAN +'<div>&bull;&nbsp;Uji Kimia : '+ CAST(JUMLAH_KIMIA AS VARCHAR)+'</div><div>&bull;&nbsp;Uji Mikro : '+CAST(JUMLAH_MIKRO AS VARCHAR) +'</div><div>&bull;&nbsp;Sisa Sampel : '+CAST(SISA AS VARCHAR) +'</div><div>' +CASE WHEN UJI_KIMIA = '1' AND UJI_MIKRO = '1' THEN 'Uji Kimia - Mikro' WHEN UJI_KIMIA = '1' THEN 'Uji Kimia' WHEN UJI_MIKRO = '1' THEN 'Uji Mikro' END+ '</div>' AS [JUMLAH UJI], dbo.KATEGORI(KOMODITI,PRIORITAS) + '<div>' + NAMA_KATEGORI + '</div>' AS KOMODITI, '<div>Hasil Kimia : ' + HASIL_KIMIA + '</div><div>Hasil Mikro : ' + HASIL_MIKRO + '</div><div>Hasil Sampel : ' + HASIL_SAMPEL + '</div>' AS HASIL FROM T_M_SAMPEL_RILIS WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND ANGGARAN IN ('05','06','07') $in";
				$this->newtable->action(site_url()."/home/pengujian/data/".$tipe);
				if(in_array('5',$this->newsession->userdata('SESS_KODE_ROLE')) && $status == "hasil"){
					$proses['Kirim Ke Pusat'] = array('POST', site_url().'/post/sampel/kirim_act/kirim/ajax', 'N');
				}
			}
			$this->newtable->hiddens(array('KODE_SAMPEL'));
			$this->newtable->search(array(array("NAMA_SAMPEL","Nama Sampel"),array("dbo.FORMAT_NOMOR('SPL',KODE_SAMPEL)","Kode Sampel"),array("TEMPAT_SAMPLING","Tempat Sampling"),array("dbo.KATEGORI(KOMODITI,PRIORITAS)","Komoditi"),array("NAMA_KATEGORI","Kategori")));
			$this->newtable->columns(array("KODE_SAMPEL", array("NAMA_SAMPEL + '<div>' + dbo.FORMAT_NOMOR('SPL',KODE_SAMPEL) + '</div><div>' + BENTUK_SEDIAAN + '</div><div>' + PABRIK + '</div><div>' + NOMOR_REGISTRASI + ', No Batch  : ' +  NO_BETS + '</div><div>'+TEMPAT_SAMPLING+'</div>'",site_url()."/home/pengujian/data/view/{KODE_SAMPEL}"),"CAST(JUMLAH_SAMPEL AS VARCHAR) +'&nbsp;'+ SATUAN +'<div>&bull;&nbsp;Uji Kimia : '+ CAST(JUMLAH_KIMIA AS VARCHAR)+'</div><div>&bull;&nbsp;Uji Mikro : '+CAST(JUMLAH_MIKRO AS VARCHAR) +'</div><div>&bull;&nbsp;Sisa Sampel : '+CAST(SISA AS VARCHAR) +'</div><div>' +CASE WHEN UJI_KIMIA = '1' AND UJI_MIKRO = '1' THEN 'Uji Kimia - Mikro' WHEN UJI_KIMIA = '1' THEN 'Uji Kimia' WHEN UJI_MIKRO = '1' THEN 'Uji Mikro' END+ '</div>'", "dbo.KATEGORI(KOMODITI,PRIORITAS) + '<div>' + NAMA_KATEGORI + '</div>'","'<div>Hasil Uji Kimia : ' + HASIL_KIMIA + '</div><div>Hasil Uji Mikro : ' + HASIL_MIKRO + '</div><div>Hasil : ' + HASIL_SAMPEL + '</div>'"));
			$this->newtable->width(array('IDENTITAS SAMPEL' => 225, 'JUMLAH UJI' => 85, 'KOMODITI' => 75, 'HASIL' => 105));
			$this->newtable->cidb($this->db);
			$this->newtable->ciuri($this->uri->segment_array());
			$this->newtable->sortby("ASC");
			$this->newtable->keys(array('KODE_SAMPEL'));
			$this->newtable->orderby(1);
			$this->newtable->sortby("ASC");
			$proses['Preview Data'] = array('GET', site_url().'/home/pengujian/data/view', '1');
			if(in_array('7',$this->newsession->userdata('SESS_KODE_ROLE')) && ($status == "row" || $status == "")){
				$proses['Cetak Konsep Laporan / Sertifikat'] = array('GETNEW', site_url()."/topdf/lhu/konsep", '1');
			}
			$this->newtable->menu($proses);
			$arrdata = array('table' => $this->newtable->generate($query),
							 'idjudul' => 'judulmsampel',
							 'caption_header' => $judul,
							 'batal' => '',
							 'cancel' => '');
			return $arrdata;
			
		}
	}
	
	function list_absah($status){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE & (in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')))){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$this->load->library('newtable');
			$tmp = "";
			foreach($this->newsession->userdata('SESS_KLASIFIKASI_ID') as $a){
				$tmp  .= "'".substr($a,-2). "',";
			}
			$komoditi = substr($tmp,0,-1);
			$query = "SELECT A.KODE_SAMPEL, A.NAMA_SAMPEL + '<div>' + dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) + '</div>' AS [SAMPEL],REPLACE(REPLACE(B.NAMA_BBPOM,'BALAI BESAR POM DI', ''),'BALAI POM DI','') AS [BPOM], REPLACE(dbo.KATEGORI(SUBSTRING(A.KATEGORI, 1,4), A.PRIORITAS),'&raquo;',' - ') AS KATEGORI, CASE WHEN A.UJI_KIMIA = '1' AND A.UJI_MIKRO = '1' THEN 'Uji Kimia - Mikro' WHEN A.UJI_KIMIA = '1' THEN 'Uji Kimia' WHEN A.UJI_MIKRO = '1' THEN 'Uji Mikro' END +'<div> K : ' + CASE WHEN A.HASIL_KIMIA <> '' THEN A.HASIL_KIMIA ELSE '-' END + ', M : ' + CASE WHEN A.HASIL_MIKRO <> '' THEN A.HASIL_MIKRO ELSE '-' END+ '</div>' AS [JENIS UJI], A.HASIL_SAMPEL +'<div>'+ CONVERT(VARCHAR(10), A.CREATE_DATE, 120) +'</div>' AS BALAI, A.HASIL_PPOMN +'<div>'+ CONVERT(VARCHAR(10), A.MONEV_UPDATE_DATE, 120) +'</div>' AS [PPOMN],  CASE WHEN A.UJI_RUJUK = 1  THEN 'Uji Rujuk' WHEN A.UJI_UNGGULAN = 1 THEN 'Uji Unggulan' ELSE 'Rutin' END AS [TIPE UJI], A.STATUS FROM T_M_SAMPEL_RILIS A LEFT JOIN M_BBPOM B ON A.BBPOM_ID = B.BBPOM_ID ";
			
			if($this->newsession->userdata('SESS_BBPOM_ID') == '91'){#Ditwas Produksi
				$query .= $sipt->main->find_where($query);
				$query .= " LEFT(A.KATEGORI,2) = '01'";
			}else if($this->newsession->userdata('SESS_BBPOM_ID') == '92'){#Ditwas Distribusi
			$query .= $sipt->main->find_where($query);
				$query .= " LEFT(A.KATEGORI,2) = '01' AND A.TUJUAN_SAMPLING IN ('02')";
			}else if($this->newsession->userdata('SESS_BBPOM_ID') == '93'){#Ditwas NAPZA
				$query .= $sipt->main->find_where($query);
				//$query .= " LEFT(A.KATEGORI,2) = '07' OR LEFT(A.KATEGORI,2) = '20'";
				$query .= " LEFT(A.KATEGORI,2) = '20'";
			}else if($this->newsession->userdata('SESS_BBPOM_ID') == '94'){#Insert OTKOS
				$query .= $sipt->main->find_where($query);
				$query .= " A.KOMODITI IN (".$komoditi.")";
				
			}else if($this->newsession->userdata('SESS_BBPOM_ID') == '95'){#Insert Pangan
				$query .= $sipt->main->find_where($query);
				$query .= " A.KOMODITI = '13'";
			}else if($this->newsession->userdata('SESS_BBPOM_ID') == '96'){#Ditwas BB
				$query .= $sipt->main->find_where($query);
				$query .= " A.KOMODITI = '14'";
			}
			if($status == "ms"){
				$query .= $sipt->main->find_where($query);
				if(in_array('2',$this->newsession->userdata('SESS_KODE_ROLE'))){
					$query .= " RTRIM(LTRIM(A.HASIL_SAMPEL)) = 'MS' AND A.ARSIP_SAMPEL = '1' AND A.STATUS_KIRIM = '1' AND A.STATUS = '80215'";
				}else if(in_array('3',$this->newsession->userdata('SESS_KODE_ROLE'))){
					$query .= " RTRIM(LTRIM(A.HASIL_SAMPEL)) = 'MS' AND A.STATUS_KIRIM = '1' AND A.STATUS = '30210'";
				}else if(in_array('4',$this->newsession->userdata('SESS_KODE_ROLE'))){
					$query .= " RTRIM(LTRIM(A.HASIL_SAMPEL)) = 'MS' AND A.STATUS_KIRIM = '1' AND A.STATUS = '40210'";
				}else if(in_array('6',$this->newsession->userdata('SESS_KODE_ROLE'))){
					$query .= " RTRIM(LTRIM(A.HASIL_SAMPEL)) = 'MS' AND A.STATUS_KIRIM = '1' AND A.STATUS = '60210'";
				}
			}else if($status == "hpst"){
				$query .= $sipt->main->find_where($query);
				if(in_array('2',$this->newsession->userdata('SESS_KODE_ROLE'))){
					$query .= " RTRIM(LTRIM(A.HASIL_SAMPEL)) = 'HPST' AND A.STATUS_KIRIM = '1' AND A.STATUS = '80215'";
				}else if(in_array('3',$this->newsession->userdata('SESS_KODE_ROLE'))){
					$query .= " RTRIM(LTRIM(A.HASIL_SAMPEL)) = 'HPST' AND A.STATUS_KIRIM = '1' AND A.STATUS = '30210'";
				}else if(in_array('4',$this->newsession->userdata('SESS_KODE_ROLE'))){
					$query .= " RTRIM(LTRIM(A.HASIL_SAMPEL)) = 'HPST' AND A.STATUS_KIRIM = '1' AND A.STATUS = '40210'";
				}else if(in_array('6',$this->newsession->userdata('SESS_KODE_ROLE'))){
					$query .= " RTRIM(LTRIM(A.HASIL_SAMPEL)) = 'HPST' AND A.STATUS_KIRIM = '1' AND A.STATUS = '60210'";
				}
			}else if($status == "tms"){
				$query .= $sipt->main->find_where($query);
				if(in_array('2',$this->newsession->userdata('SESS_KODE_ROLE'))){
					$query .= " RTRIM(LTRIM(A.HASIL_SAMPEL)) = '".strtoupper($status)."' AND A.STATUS_KIRIM = '1' AND A.STATUS = '80215'";
				}else if(in_array('3',$this->newsession->userdata('SESS_KODE_ROLE'))){
					$query .= " RTRIM(LTRIM(A.HASIL_SAMPEL)) = '".strtoupper($status)."' AND A.STATUS_KIRIM = '1' AND A.STATUS = '30210'";
				}else if(in_array('4',$this->newsession->userdata('SESS_KODE_ROLE'))){
					$query .= " RTRIM(LTRIM(A.HASIL_SAMPEL)) = '".strtoupper($status)."' AND A.STATUS_KIRIM = '1' AND A.STATUS = '40210'";
				}else if(in_array('6',$this->newsession->userdata('SESS_KODE_ROLE'))){
					$query .= " RTRIM(LTRIM(A.HASIL_SAMPEL)) = '".strtoupper($status)."' AND A.STATUS_KIRIM = '1' AND A.STATUS = '60210'";
				}
			}else if($status == "send"){
				$query .= $sipt->main->find_where($query);
				if(in_array('2',$this->newsession->userdata('SESS_KODE_ROLE'))){
					$query .= " A.STATUS IN ('30210','40210')";
				}else if(in_array('3',$this->newsession->userdata('SESS_KODE_ROLE'))){
					$query .= " A.STATUS IN ('40210','60210')";
				}else if(in_array('4',$this->newsession->userdata('SESS_KODE_ROLE'))){
					$query .= " A.STATUS IN ('60210')";
				}else if(in_array('6',$this->newsession->userdata('SESS_KODE_ROLE'))){
					$query .= " A.STATUS = '60210'";
				}
			}
			$this->newtable->hiddens(array('KODE_SAMPEL','STATUS'));
			$this->newtable->search(array(array("A.NAMA_SAMPEL","Nama Sampel"),array("dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL)","Kode Sampel"),array("dbo.KATEGORI(A.KOMODITI)","Komoditi"),array("REPLACE(dbo.KATEGORI(SUBSTRING(A.KATEGORI, 1,4), A.PRIORITAS),'&raquo;',' - ')","Kategori"),array("B.NAMA_BBPOM", "Balai Besar / Balai POM"),
			array("CASE WHEN A.UJI_KIMIA = '1' AND A.UJI_MIKRO = '1' THEN 'Uji Kimia - Mikro' WHEN A.UJI_KIMIA = '1' THEN 'Uji Kimia' WHEN A.UJI_MIKRO = '1' THEN 'Uji Mikro' END +'<div> K : ' + CASE WHEN A.HASIL_KIMIA <> '' THEN A.HASIL_KIMIA ELSE '-' END + ', M : ' + CASE WHEN A.HASIL_MIKRO <> '' THEN A.HASIL_MIKRO ELSE '-' END+ '</div>'","Jenis Uji"),
			array("A.HASIL_SAMPEL +'<div>'+ CONVERT(VARCHAR(10), A.CREATE_DATE, 120) +'</div>'","Hasil Balai"), 
			array("A.HASIL_PPOMN +'<div>'+ CONVERT(VARCHAR(10), A.MONEV_UPDATE_DATE, 120) +'</div>'","Hasil PPOMN"),
			array("CASE WHEN A.UJI_RUJUK = 1 THEN 'Uji Rujuk' WHEN A.UJI_UNGGULAN = 1 THEN 'Uji Unggulan' ELSE 'Rutin' END", "Tipe Uji")));
			$this->newtable->columns(array("A.KODE_SAMPEL", array("A.NAMA_SAMPEL + '<div>' + dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) + '</div>'",site_url().'/home/sampel/preview/{KODE_SAMPEL}.{STATUS}'),"REPLACE(REPLACE(B.NAMA_BBPOM,'BALAI BESAR POM DI', ''),'BALAI POM DI','')", "REPLACE(dbo.KATEGORI(SUBSTRING(A.KATEGORI, 1,4)),'&raquo;',' - ')", "CASE WHEN A.UJI_KIMIA = '1' AND A.UJI_MIKRO = '1' THEN 'Uji Kimia - Mikro' WHEN A.UJI_KIMIA = '1' THEN 'Uji Kimia' WHEN A.UJI_MIKRO = '1' THEN 'Uji Mikro' END +'<div> K : ' + CASE WHEN A.HASIL_KIMIA <> '' THEN A.HASIL_KIMIA ELSE '-' END + ', M : ' + CASE WHEN A.HASIL_MIKRO <> '' THEN A.HASIL_MIKRO ELSE '-' END+ '</div>'", "A.HASIL_SAMPEL +'<div>'+ CONVERT(VARCHAR(10), A.CREATE_DATE, 120) +'</div>'", "A.HASIL_PPOMN +'<div>'+ CONVERT(VARCHAR(10), A.MONEV_UPDATE_DATE, 120) +'</div>'", "CASE WHEN A.UJI_RUJUK = 1 THEN 'Uji Rujuk' WHEN A.UJI_UNGGULAN = 1 THEN 'Uji Unggulan' ELSE 'Rutin' END", "A.STATUS"));
			$this->newtable->action(site_url()."/home/sampel/absah/".$status);
			$this->newtable->width(array('SAMPEL' => 200, 'BPOM' => 85, 'KATEGORI' => 250, 'JENIS UJI' => 75, 'BALAI' => 100, 'PPOMN' => 100, 'TIPE UJI' => 75));
			$this->newtable->cidb($this->db);
			$this->newtable->ciuri($this->uri->segment_array());
			$this->newtable->sortby("ASC");
			$this->newtable->keys(array('KODE_SAMPEL','STATUS'));
			$this->newtable->orderby(1);
			if(in_array('2',$this->newsession->userdata('SESS_KODE_ROLE')) && $this->newsession->userdata('SESS_BBPOM_ID') == '94'){
				if($status == "send"){
					$proses['Preview Data'] = array('GET', site_url().'/home/sampel/preview', '1');
				}else{
					$proses['Preview Data'] = array('GET', site_url().'/home/sampel/preview', '1');
					$proses['Kirim Semua Data'] = array('MPOST', site_url()."/post/sampel/set_all/ajax", 'N');
				}				
			}else{
				$proses['Preview Data'] = array('GET', site_url().'/home/sampel/preview', '1');
			}
			$this->newtable->menu($proses);
			$arrdata = array('table' => $this->newtable->generate($query),
							 'idjudul' => 'judulmsampel',
							 'caption_header' => $judul,
							 'batal' => '',
							 'cancel' => '');
			return $arrdata;
		}
	}
	
	
	function get_sampel($id){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$this->load->library('newtable');
			$arrid = explode(".",$id);
			$query = "SELECT A.NAMA_SAMPEL, A.KODE_SAMPEL, dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) AS KODE, dbo.FORMAT_NOMOR('SPU',C.SPU_ID) AS SPU, A.TEMPAT_SAMPLING, CONVERT(VARCHAR(10), A.TANGGAL_SAMPLING, 103) AS TANGGAL_SAMPLING, A.ALAMAT_SAMPLING, A.NOMOR_REGISTRASI, A.PABRIK, A.IMPORTIR, A.KEMASAN, A.BENTUK_SEDIAAN, A.NO_BETS, A.SATUAN, dbo.KATEGORI(A.KOMODITI,A.PRIORITAS) AS KOMODITI, dbo.KATEGORI(A.KATEGORI,A.PRIORITAS) AS KATEGORIX, A.NAMA_KATEGORI AS KATEGORI, A.KETERANGAN_ED, A.JUMLAH_KIMIA, A.JUMLAH_MIKRO, REPLACE(A.KOMPOSISI,';','<br>') AS KOMPOSISI, A.NETTO, B.NOMOR_SURAT, B.BBPOM_ID, CONVERT(VARCHAR(10), B.TANGGAL_SURAT, 103) AS TANGGAL_SURAT, B.NAMA_PENGIRIM, CONVERT(VARCHAR(10), C.TANGGAL_TERIMA_TPS, 103) AS TANGGAL_TERIMA_TPS, CONVERT(VARCHAR(10), C.TANGGAL, 103) AS TANGGAL_SPU, A.PEMERIAN, A.UJI_MIKRO, A.UJI_KIMIA, A.JUMLAH_SAMPEL, A.JUMLAH_KIMIA, A.JUMLAH_MIKRO, A.HASIL_KIMIA, A.HASIL_MIKRO, A.LAMPIRAN, D.HASIL_PPOMN, RTRIM(LTRIM(D.STATUS)) AS STATUS, A.HASIL_SAMPEL, D.STATUS_PPOMN, CONVERT(VARCHAR(10), D.AKHIR_UJI, 120) AS AKHIR_UJI, A.UJI_RUJUK FROM T_M_SAMPEL A LEFT JOIN T_PERIKSA_SAMPEL B ON A.PERIKSA_SAMPEL = B.PERIKSA_SAMPEL LEFT JOIN T_SPU C ON A.SPU_ID = C.SPU_ID LEFT JOIN T_M_SAMPEL_RILIS D ON A.KODE_SAMPEL = D.KODE_SAMPEL WHERE A.KODE_SAMPEL = '".$arrid[0]."'";
			$tanggaluji = $this->db->query("SELECT MIN(CONVERT(VARCHAR(10), AWAL_UJI, 120)) AS MINTGL, MAX(CONVERT(VARCHAR(10), AKHIR_UJI, 120)) AS MAXTGL FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL = '".$arrid[0]."'")->result_array();
			$data = $sipt->main->get_result($query);
			if($data){
				foreach($query->result_array() as $row){
					$arrdata = array('sess' => $row,
									 'tanggaluji' => $tanggaluji);

				}
				$arrdata['file'] = base_url().'files/sampel/'.md5(trim($row['BBPOM_ID'])).'/'.$row['LAMPIRAN'];
			}
			if(in_array('5', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('7', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('8', $this->newsession->userdata('SESS_KODE_ROLE'))){
				$arrdata['parameter'] = $this->db->query("SELECT CASE WHEN JENIS_UJI = '01' THEN 'Mikrobiologi' WHEN JENIS_UJI = '02' THEN 'Kimia - Fisika' END AS JENIS_UJI, SPK_ID,PARAMETER_UJI, METODE, PUSTAKA, SYARAT, RUANG_LINGKUP, HASIL, HASIL_KUALITATIF, LCP, HASIL_PARAMETER FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL = '".$arrid[0]."'")->result_array();
			}else{
				if(in_array('B1',$this->newsession->userdata('SESS_SUB_SARANA')) || in_array('B2',$this->newsession->userdata('SESS_SUB_SARANA'))){#Bidang Kimia Fisika
					$arrdata['parameter'] = $this->db->query("SELECT CASE WHEN JENIS_UJI = '01' THEN 'Mikrobiologi' WHEN JENIS_UJI = '02' THEN 'Kimia - Fisika' END AS JENIS_UJI, SPK_ID,PARAMETER_UJI, METODE, PUSTAKA, SYARAT, RUANG_LINGKUP, HASIL, HASIL_KUALITATIF, LCP, HASIL_PARAMETER FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL = '".$arrid[0]."' AND JENIS_UJI = '02'")->result_array();
				}else if(in_array('B3',$this->newsession->userdata('SESS_SUB_SARANA'))){#Bidang Mikro
					$arrdata['parameter'] = $this->db->query("SELECT CASE WHEN JENIS_UJI = '01' THEN 'Mikrobiologi' WHEN JENIS_UJI = '02' THEN 'Kimia - Fisika' END AS JENIS_UJI, SPK_ID,PARAMETER_UJI, METODE, PUSTAKA, SYARAT, RUANG_LINGKUP, HASIL, HASIL_KUALITATIF, LCP, HASIL_PARAMETER FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL = '".$arrid[0]."' AND JENIS_UJI = '01'")->result_array();
				}else{
					$arrdata['parameter'] = $this->db->query("SELECT CASE WHEN JENIS_UJI = '01' THEN 'Mikrobiologi' WHEN JENIS_UJI = '02' THEN 'Kimia - Fisika' END AS JENIS_UJI, SPK_ID,PARAMETER_UJI, METODE, PUSTAKA, SYARAT, RUANG_LINGKUP, HASIL, HASIL_KUALITATIF, LCP, HASIL_PARAMETER FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL = '".$arrid[0]."'")->result_array();
				}		
			}

			/**
			 * Parameter Uji Rujukan
			 */
			if((int)$row['UJI_RUJUK'] == 1){
				$sKode_Sampel_Rujukan = $sipt->main->get_uraian("SELECT KODE_SAMPEL FROM T_M_SAMPEL WHERE KODE_RUJUKAN = '".$arrid[0]."'","KODE_SAMPEL");
				$sql_rujukan = "SELECT dbo.FORMAT_NOMOR('SPL', A.KODE_SAMPEL) AS UR_KODE_SAMPEL_RUJUKAN, A.HASIL_KIMIA,
								A.HASIL_MIKRO, RTRIM(LTRIM(A.HASIL_SAMPEL)) AS HASIL_SAMPEL, C.NAMA_BBPOM AS BALAI_TUJUAN,
								A.UJI_KIMIA, A.UJI_MIKRO
								FROM T_M_SAMPEL A
								LEFT JOIN T_SAMPEL_RUJUKAN B ON A.KODE_RUJUKAN = B.KODE_SAMPEL
								LEFT JOIN M_BBPOM C ON C.BBPOM_ID = B.BBPOM_RUJUK
								WHERE A.KODE_RUJUKAN = '".$arrid[0]."'";
				$obj_sql_rujukan = $sipt->main->get_result($sql_rujukan);
				if($obj_sql_rujukan) 
				{
					foreach($sql_rujukan->result_array() as $row_rujukan)
					{
						$arrdata['sess_rujukan'] = $row_rujukan;
					}
				}
				$arrdata['parameter_rujukan'] = $this->db->query("SELECT CASE WHEN JENIS_UJI = '01' THEN 'Mikrobiologi' WHEN JENIS_UJI = '02' THEN 'Kimia - Fisika' END AS JENIS_UJI, SPK_ID,PARAMETER_UJI, METODE, PUSTAKA, SYARAT, RUANG_LINGKUP, HASIL, HASIL_KUALITATIF, LCP, HASIL_PARAMETER, KODE_SAMPEL FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL = '".$sKode_Sampel_Rujukan."'")->result_array();
			}
			/**
			 * End Parameter Uji Rujukan
			 */
			$arrdata['act'] = site_url().'/post/sampel/kirim_act/disposisi';
			$arrdata['input'] = $this->get_input($arrid[0], $row['STATUS']);
			$arrdata['proses'] = $sipt->main->set_verifikasi($row['STATUS'], $this->newsession->userdata('SESS_JENIS_PELAPORAN'), $this->newsession->userdata('SESS_KODE_ROLE'));
			$arrdata['disproses'] = $row['STATUS'];
			$arrdata['jml_log'] = $sipt->main->get_uraian("SELECT COUNT(*) AS JML FROM T_SAMPLING_LOG WHERE KODE_SAMPEL = '".$arrid[0]."'","JML");
			return $arrdata;
		}
	}
	
	function get_input($kodesampel, $status){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$sipt->load->model("main","main", true);
			$data = "";
			$arrdata = array();
			$arrdata['row'] = $this->db->query("SELECT * FROM T_M_SAMPEL_RILIS WHERE KODE_SAMPEL = '".$kodesampel."'")->result_array();
			$arrstts = array('20210','30210','40210','60210','80215');
			if(in_array($status, $arrstts)){
				$komoditi = $sipt->main->get_uraian("SELECT KOMODITI FROM T_M_SAMPEL_RILIS WHERE KODE_SAMPEL = '".$kodesampel."'","KOMODITI");
				$arrdata['tindak_lanjut'] = $sipt->main->combobox("SELECT KODE, URAIAN FROM M_TL_SAMPEL WHERE KOMODITI = '".$komoditi."' ORDER BY 2","KODE","URAIAN", TRUE);
				$data = $this->load->view('pengujian/input/'.substr($status,0,3), $arrdata, true);
			}else{
				$data = "";
			}
		}
		return $data;
	}
	
	function set_sampel($action, $isajax){
		if($this->newsession->userdata('LOGGED_IN') == TRUE){
			$sipt =& get_instance();
			$sipt->load->model("main","main", true);
			if($action == "kirim" && in_array('5',$this->newsession->userdata('SESS_KODE_ROLE'))){
				$ret = "MSG#Data Gagal Dikirim.";
				foreach($this->input->post('tb_chk') as $a){
					$hasil = $sipt->main->get_uraian("SELECT RTRIM(LTRIM(HASIL_SAMPEL)) AS HASIL_SAMPEL FROM T_M_SAMPEL_RILIS WHERE KODE_SAMPEL = '".$a."'","HASIL_SAMPEL");
					if($hasil == "MS") $this->db->simple_query("UPDATE T_M_SAMPEL_RILIS SET STATUS_KIRIM = '1', STATUS_PPOMN = '1', ARSIP_SAMPEL = '1', STATUS = '80215', MONEV_PPOMN = '3', TANGGAL_KIRIM = GETDATE() WHERE KODE_SAMPEL = '".$a."'");
					else  $this->db->simple_query("UPDATE T_M_SAMPEL_RILIS SET STATUS_KIRIM = '1', TANGGAL_KIRIM = GETDATE(), MONEV_PPOMN = '1', STATUS = '80215' WHERE KODE_SAMPEL = '".$a."'");
					
					$this->db->simple_query("UPDATE T_M_SAMPEL SET STATUS_SAMPEL = '80215', TANGGAL_KIRIM = GETDATE() WHERE KODE_SAMPEL = '".$a."'");
					$data = array('KODE_SAMPEL' => $a,
								  'WAKTU' => 'GETDATE()',
								  'USER_ID' => $this->newsession->userdata('SESS_USER_ID'),
								  'KEGIATAN' => 'Mengirim hasil pengujian ke PPOMN dengan kode sampel : '. $a,
								  'CATATAN' => '-');
					$this->db->insert('T_SAMPLING_LOG', $data);
					$ret = "MSG#Data Berhasil Dikirim#";
				}
				if($isajax!="ajax"){
					redirect(base_url());
					exit();
				}
			}else if($action == "kirim_all"){
				$ret = "MSG#NO#Proses sampel gagal, Silahkan coba lagi#";
				foreach($this->input->post('KODE_SAMPEL') as $a){
					$res = $this->db->simple_query("UPDATE T_M_SAMPEL_RILIS SET STATUS = '".$this->input->post('HASIL')."', UPDATE_BY= '". $this->newsession->userdata('SESS_USER_ID'). "' WHERE KODE_SAMPEL = '".$a."'");
					if($res){
						$data = array('KODE_SAMPEL' => $a,
								  'WAKTU' => 'GETDATE()',
								  'USER_ID' => $this->newsession->userdata('SESS_USER_ID'),
								  'KEGIATAN' => 'Mengirim ke'.$sipt->main->get_uraian("SELECT URAIAN FROM M_TABEL WHERE JENIS = 'STATUS' AND KODE = '".$this->input->post('HASIL')."'","URAIAN").' dengan kode sampel : '. $a,
								  'CATATAN' => '-');
						$this->db->insert('T_SAMPLING_LOG', $data);
					}
				}
				$ret = "MSG#YES#Proses sampel berhasil#";
				if($isajax!="ajax"){
					redirect(base_url());
					exit();
				}
			}else if($action == "disposisi"){
				$msgok = "Proses sampel berhasil";
				$msgerr = "Proses sampel gagal, Silahkan coba lagi";
				if($this->input->post('TINDAK_LANJUT'))
					$res = $this->db->simple_query("UPDATE T_M_SAMPEL_RILIS SET TINDAK_LANJUT = '".$this->input->post('TINDAK_LANJUT')."', STATUS = '".$this->input->post('STATUS')."', UPDATE_BY= '". $this->newsession->userdata('SESS_USER_ID'). "' WHERE KODE_SAMPEL = '".$this->input->post('KODE_SAMPEL')."'");
				else
					$res = $this->db->simple_query("UPDATE T_M_SAMPEL_RILIS SET STATUS = '".$this->input->post('STATUS')."', UPDATE_BY= '". $this->newsession->userdata('SESS_USER_ID'). "' WHERE KODE_SAMPEL = '".$this->input->post('KODE_SAMPEL')."'");
				if($res){
					$data = array('KODE_SAMPEL' => $this->input->post('KODE_SAMPEL'),
								  'WAKTU' => 'GETDATE()',
								  'USER_ID' => $this->newsession->userdata('SESS_USER_ID'),
								  'KEGIATAN' => 'Tindak lanjut hasil sampling',
								  'CATATAN' => $this->input->post('catatan'));
					$this->db->insert('T_SAMPLING_LOG', $data);
					$ret = "MSG#YES#$msgok#";
				}else{
					$ret = "MSG#NO#$msgerr";
				}
				if($isajax!="ajax"){
					redirect(base_url());
					exit();
				}
			}
			return $ret;
		}
	}
}
?>