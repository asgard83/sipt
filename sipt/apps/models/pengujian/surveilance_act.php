<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR);
class Surveilance_act extends Model{
	
	function list_surveilance_balai()
	{
		if($this->newsession->userdata('LOGGED_IN')){
			$sipt =& get_instance();
			$this->load->library('newtable');
			$judul = "Sampling Obat Kategori D2";
			$query = "SELECT KODE_SAMPEL, STATUS_SAMPEL, NAMA_SAMPEL + '<div>' + dbo.FORMAT_NOMOR('SPL',KODE_SAMPEL) + '</div><div>' + BENTUK_SEDIAAN + '</div><div>' + PABRIK + '</div><div>' + NOMOR_REGISTRASI + ', No Batch  : ' +  NO_BETS + '</div><div>'+TEMPAT_SAMPLING+'</div>' AS [IDENTITAS SAMPEL], CAST(JUMLAH_SAMPEL AS VARCHAR) +'&nbsp;'+ SATUAN +'<div>&bull;&nbsp;Uji Kimia : '+ CAST(JUMLAH_KIMIA AS VARCHAR)+'</div><div>&bull;&nbsp;Uji Mikro : '+CAST(JUMLAH_MIKRO AS VARCHAR) +'</div><div>&bull;&nbsp;Sisa Sampel : '+CAST(SISA AS VARCHAR) +'</div><div>' +CASE WHEN UJI_KIMIA = '1' AND UJI_MIKRO = '1' THEN 'Uji Kimia - Mikro' WHEN UJI_KIMIA = '1' THEN 'Uji Kimia' WHEN UJI_MIKRO = '1' THEN 'Uji Mikro' END+ '</div>' AS [JUMLAH UJI], dbo.KATEGORI(KOMODITI,PRIORITAS) + '<div>' + NAMA_KATEGORI + '</div>' AS KOMODITI, CASE WHEN CUKUP = 1 THEN 'Sampel Cukup' + '<div>'+CASE WHEN OPSI_D2 = 0 THEN 'Tidak ada Metode Analisis dan Baku Pembanding' WHEN OPSI_D2 = 2 THEN 'Metode Analisis ada dan Baku Pembanding tidak ada' ELSE '' END +'</div>' WHEN CUKUP = 2 THEN 'Sampel Tidak Cukup' END  AS KETERANGAN FROM T_M_SAMPEL WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND STATUS_SAMPEL = '50200'";
			$this->newtable->action(site_url()."/home/pengujian/surveilance");
			$this->newtable->hiddens(array('KODE_SAMPEL','STATUS_SAMPEL'));
			$this->newtable->search(array(array("NAMA_SAMPEL","Nama Sampel"),
										  array("dbo.FORMAT_NOMOR('SPL',KODE_SAMPEL)","Kode Sampel"),
										  array("TEMPAT_SAMPLING","Tempat Sampling"),
										  array("dbo.KATEGORI(KOMODITI,PRIORITAS)","Komoditi"),
										  array("NAMA_KATEGORI","Kategori")));
			$this->newtable->columns(array("KODE_SAMPEL", "STATUS_SAMPEL", array("NAMA_SAMPEL + '<div>' + dbo.FORMAT_NOMOR('SPL',KODE_SAMPEL) + '</div><div>' + BENTUK_SEDIAAN + '</div><div>' + PABRIK + '</div><div>' + NOMOR_REGISTRASI + ', No Batch  : ' +  NO_BETS + '</div><div>'+TEMPAT_SAMPLING+'</div>'",site_url()."/home/pengujian/surveilance/view/{KODE_SAMPEL}.{STATUS_SAMPEL}"),"CAST(JUMLAH_SAMPEL AS VARCHAR) +'&nbsp;'+ SATUAN +'<div>&bull;&nbsp;Uji Kimia : '+ CAST(JUMLAH_KIMIA AS VARCHAR)+'</div><div>&bull;&nbsp;Uji Mikro : '+CAST(JUMLAH_MIKRO AS VARCHAR) +'</div><div>&bull;&nbsp;Sisa Sampel : '+CAST(SISA AS VARCHAR) +'</div><div>' +CASE WHEN UJI_KIMIA = '1' AND UJI_MIKRO = '1' THEN 'Uji Kimia - Mikro' WHEN UJI_KIMIA = '1' THEN 'Uji Kimia' WHEN UJI_MIKRO = '1' THEN 'Uji Mikro' END+ '</div>'", "dbo.KATEGORI(KOMODITI,PRIORITAS) + '<div>' + dbo.KATEGORI(KATEGORI,PRIORITAS) + '</div>'","CASE WHEN CUKUP = 1 THEN 'Sampel Cukup' + '<div>'+CASE WHEN OPSI_D2 = 0 THEN 'Tidak ada Metode Analisis dan Baku Pembanding' WHEN OPSI_D2 = 2 THEN 'Metode Analisis ada dan Baku Pembanding tidak ada' ELSE '' END +'</div>' WHEN CUKUP = 2 THEN 'Sampel Tidak Cukup' END "));
			$this->newtable->width(array('IDENTITAS SAMPEL' => 225, 'JUMLAH UJI' => 85, 'KOMODITI' => 75, 'KETERANGAN' => 105));
			$this->newtable->cidb($this->db);
			$this->newtable->ciuri($this->uri->segment_array());
			$this->newtable->sortby("ASC");
			$this->newtable->keys(array('KODE_SAMPEL','STATUS_SAMPEL'));
			$this->newtable->orderby(1);
			$this->newtable->sortby("ASC");
			$proses['Preview Data'] = array('GET', site_url().'/home/pengujian/surveilance/view', '1');
			$this->newtable->menu($proses);
			$arrdata = array('table' => $this->newtable->generate($query),
							 'idjudul' => 'judulmsampel',
							 'caption_header' => $judul,
							 'batal' => '',
							 'cancel' => '');
			return $arrdata;
		}
	}
	
	function list_surveilance(){
		if($this->newsession->userdata('LOGGED_IN'))
		{
			$sipt =& get_instance();
			$this->load->library('newtable');
			$judul = "Sampling Obat Kategori D2  - Verifikasi";
			
			if(in_array('2', $this->newsession->userdata('SESS_KODE_ROLE')))
			{
				$stts = "20200";
			}
			else if(in_array('3', $this->newsession->userdata('SESS_KODE_ROLE')))
			{
				$stts = "30200";
			}
			else if(in_array('4', $this->newsession->userdata('SESS_KODE_ROLE')))
			{
				$stts = "40200";
			}
			else if(in_array('6', $this->newsession->userdata('SESS_KODE_ROLE')))
			{
				$stts = "60200";
			}
				 
			$query = "SELECT A.KODE_SAMPEL, A.STATUS_SAMPEL, A.NAMA_SAMPEL + '<div>' + dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) + '</div><div>' + A.BENTUK_SEDIAAN + '</div><div>' + A.PABRIK + '</div><div>' + A.NOMOR_REGISTRASI + ', No Batch  : ' +  A.NO_BETS + '</div><div>'+A.TEMPAT_SAMPLING+'</div>' AS [IDENTITAS SAMPEL], CAST(A.JUMLAH_SAMPEL AS VARCHAR) +'&nbsp;'+ A.SATUAN +'<div>&bull;&nbsp;Uji Kimia : '+ CAST(A.JUMLAH_KIMIA AS VARCHAR)+'</div><div>&bull;&nbsp;Uji Mikro : '+CAST(A.JUMLAH_MIKRO AS VARCHAR) +'</div><div>&bull;&nbsp;Sisa Sampel : '+CAST(A.SISA AS VARCHAR) +'</div><div>' +CASE WHEN A.UJI_KIMIA = '1' AND A.UJI_MIKRO = '1' THEN 'Uji Kimia - Mikro' WHEN A.UJI_KIMIA = '1' THEN 'Uji Kimia' WHEN A.UJI_MIKRO = '1' THEN 'Uji Mikro' END+ '</div>' AS [JUMLAH UJI], dbo.KATEGORI(A.KOMODITI,A.PRIORITAS) + '<div>' + A.NAMA_KATEGORI + '</div>' AS KOMODITI, REPLACE(REPLACE(B.NAMA_BBPOM,'BALAI BESAR POM DI', ''),'BALAI POM DI','') AS [BBPOM / BPOM], CASE WHEN A.CUKUP = 1 THEN 'Sampel Cukup' + '<div>'+CASE WHEN A.OPSI_D2 = 0 THEN 'Tidak ada Metode Analisis dan Baku Pembanding' WHEN A.OPSI_D2 = 2 THEN 'Metode Analisis ada dan Baku Pembanding tidak ada' ELSE '' END +'</div>' WHEN A.CUKUP = 2 THEN 'Sampel Tidak Cukup' END  AS KETERANGAN FROM T_M_SAMPEL A LEFT JOIN M_BBPOM B ON A.BBPOM_ID = B.BBPOM_ID WHERE A.STATUS_SAMPEL = $stts";
			$this->newtable->action(site_url()."/home/pengujian/surveilance");
			$this->newtable->hiddens(array('KODE_SAMPEL','STATUS_SAMPEL'));
			$this->newtable->search(array(array("NAMA_SAMPEL","Nama Sampel"),
										  array("dbo.FORMAT_NOMOR('SPL',KODE_SAMPEL)","Kode Sampel"),
										  array("TEMPAT_SAMPLING","Tempat Sampling"),
										  array("dbo.KATEGORI(KOMODITI,PRIORITAS)","Komoditi"),
										  array("NAMA_KATEGORI","Kategori"),
										  array("B.NAMA_BBPOM","BBPOM / BPOM")));
			$this->newtable->columns(array("A.KODE_SAMPEL", "A.STATUS_SAMPEL", array("A.NAMA_SAMPEL + '<div>' + dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) + '</div><div>' + A.BENTUK_SEDIAAN + '</div><div>' + A.PABRIK + '</div><div>' + A.NOMOR_REGISTRASI + ', No Batch  : ' +  A.NO_BETS + '</div><div>'+A.TEMPAT_SAMPLING+'</div>'",site_url()."/home/pengujian/surveilance/view/{KODE_SAMPEL}.{STATUS_SAMPEL}"),"CAST(A.JUMLAH_SAMPEL AS VARCHAR) +'&nbsp;'+ A.SATUAN +'<div>&bull;&nbsp;Uji Kimia : '+ CAST(A.JUMLAH_KIMIA AS VARCHAR)+'</div><div>&bull;&nbsp;Uji Mikro : '+CAST(A.JUMLAH_MIKRO AS VARCHAR) +'</div><div>&bull;&nbsp;Sisa Sampel : '+CAST(A.SISA AS VARCHAR) +'</div><div>' +CASE WHEN A.UJI_KIMIA = '1' AND A.UJI_MIKRO = '1' THEN 'Uji Kimia - Mikro' WHEN A.UJI_KIMIA = '1' THEN 'Uji Kimia' WHEN A.UJI_MIKRO = '1' THEN 'Uji Mikro' END+ '</div>'", "dbo.KATEGORI(A.KOMODITI,A.PRIORITAS) + '<div>' + dbo.KATEGORI(A.KATEGORI,A.PRIORITAS) + '</div>'","REPLACE(REPLACE(B.NAMA_BBPOM,'BALAI BESAR POM DI', ''),'BALAI POM DI','')","CASE WHEN A.CUKUP = 1 THEN 'Sampel Cukup' + '<div>'+CASE WHEN A.OPSI_D2 = 0 THEN 'Tidak ada Metode Analisis dan Baku Pembanding' WHEN A.OPSI_D2 = 2 THEN 'Metode Analisis ada dan Baku Pembanding tidak ada' ELSE '' END +'</div>' WHEN A.CUKUP = 2 THEN 'Sampel Tidak Cukup' END"));
			$this->newtable->width(array('IDENTITAS SAMPEL' => 225, 'JUMLAH UJI' => 85, 'KOMODITI' => 75, 'BBPOM / BPOM' => 100, 'KETERANGAN' => 105));
			$this->newtable->cidb($this->db);
			$this->newtable->ciuri($this->uri->segment_array());
			$this->newtable->sortby("ASC");
			$this->newtable->keys(array('KODE_SAMPEL','STATUS_SAMPEL'));
			$this->newtable->orderby(1);
			$this->newtable->sortby("ASC");
			$proses['Preview Data'] = array('GET', site_url().'/home/pengujian/surveilance/view', '1');
			$this->newtable->menu($proses);
			$arrdata = array('table' => $this->newtable->generate($query),
							 'idjudul' => 'judulmsampel',
							 'caption_header' => $judul,
							 'batal' => '',
							 'cancel' => '');
			return $arrdata;
			
		}
	}

	function list_surveilance_sent(){
		if($this->newsession->userdata('LOGGED_IN'))
		{
			$sipt =& get_instance();
			$this->load->library('newtable');
			$judul = "Sampling Obat Kategori D2 - Terkirim";
			
			if(in_array('2', $this->newsession->userdata('SESS_KODE_ROLE')))
			{
				$stts = " IN('30200','40200','60200','60299')";
			}
			else if(in_array('3', $this->newsession->userdata('SESS_KODE_ROLE')))
			{
				$stts = " IN('40200','60200','60299')";
			}
			else if(in_array('4', $this->newsession->userdata('SESS_KODE_ROLE')))
			{
				$stts = " IN('60200','60299')";
			}
			else if(in_array('6', $this->newsession->userdata('SESS_KODE_ROLE')))
			{
				$stts = " IN('60299')";
			}
				 
			$query = "SELECT A.KODE_SAMPEL, A.STATUS_SAMPEL, A.NAMA_SAMPEL + '<div>' + dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) + '</div><div>' + A.BENTUK_SEDIAAN + '</div><div>' + A.PABRIK + '</div><div>' + A.NOMOR_REGISTRASI + ', No Batch  : ' +  A.NO_BETS + '</div><div>'+A.TEMPAT_SAMPLING+'</div>' AS [IDENTITAS SAMPEL], CAST(A.JUMLAH_SAMPEL AS VARCHAR) +'&nbsp;'+ A.SATUAN +'<div>&bull;&nbsp;Uji Kimia : '+ CAST(A.JUMLAH_KIMIA AS VARCHAR)+'</div><div>&bull;&nbsp;Uji Mikro : '+CAST(A.JUMLAH_MIKRO AS VARCHAR) +'</div><div>&bull;&nbsp;Sisa Sampel : '+CAST(A.SISA AS VARCHAR) +'</div><div>' +CASE WHEN A.UJI_KIMIA = '1' AND A.UJI_MIKRO = '1' THEN 'Uji Kimia - Mikro' WHEN A.UJI_KIMIA = '1' THEN 'Uji Kimia' WHEN A.UJI_MIKRO = '1' THEN 'Uji Mikro' END+ '</div>' AS [JUMLAH UJI], dbo.KATEGORI(A.KOMODITI,A.PRIORITAS) + '<div>' + A.NAMA_KATEGORI + '</div>' AS KOMODITI, REPLACE(REPLACE(B.NAMA_BBPOM,'BALAI BESAR POM DI', ''),'BALAI POM DI','') AS [BBPOM / BPOM], CASE WHEN A.CUKUP = 1 THEN 'Sampel Cukup' WHEN A.CUKUP = 2 THEN 'Sampel Tidak Cukup' END + '<div>'+CASE WHEN A.OPSI_D2 = 0 THEN 'Tidak ada Metode Analisis dan Baku Pembanding' WHEN A.OPSI_D2 = 2 THEN 'Metode Analisis ada dan Baku Pembanding tidak ada' WHEN A.OPSI_D2 = 1 THEN 'Metode Analisis ada dan Baku Pembanding ada' END +'</div>' AS KETERANGAN FROM T_M_SAMPEL A LEFT JOIN M_BBPOM B ON A.BBPOM_ID = B.BBPOM_ID WHERE A.STATUS_SAMPEL $stts";
			$this->newtable->action(site_url()."/home/pengujian/surveilance/sent");
			$this->newtable->hiddens(array('KODE_SAMPEL','STATUS_SAMPEL'));
			$this->newtable->search(array(array("NAMA_SAMPEL","Nama Sampel"),
										  array("dbo.FORMAT_NOMOR('SPL',KODE_SAMPEL)","Kode Sampel"),
										  array("TEMPAT_SAMPLING","Tempat Sampling"),
										  array("dbo.KATEGORI(KOMODITI,PRIORITAS)","Komoditi"),
										  array("NAMA_KATEGORI","Kategori"),
										  array("B.NAMA_BBPOM","BBPOM / BPOM")));
			$this->newtable->columns(array("A.KODE_SAMPEL", "A.STATUS_SAMPEL", array("A.NAMA_SAMPEL + '<div>' + dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) + '</div><div>' + A.BENTUK_SEDIAAN + '</div><div>' + A.PABRIK + '</div><div>' + A.NOMOR_REGISTRASI + ', No Batch  : ' +  A.NO_BETS + '</div><div>'+A.TEMPAT_SAMPLING+'</div>'",site_url()."/home/pengujian/surveilance/view/{KODE_SAMPEL}.{STATUS_SAMPEL}"),"CAST(A.JUMLAH_SAMPEL AS VARCHAR) +'&nbsp;'+ A.SATUAN +'<div>&bull;&nbsp;Uji Kimia : '+ CAST(A.JUMLAH_KIMIA AS VARCHAR)+'</div><div>&bull;&nbsp;Uji Mikro : '+CAST(A.JUMLAH_MIKRO AS VARCHAR) +'</div><div>&bull;&nbsp;Sisa Sampel : '+CAST(A.SISA AS VARCHAR) +'</div><div>' +CASE WHEN A.UJI_KIMIA = '1' AND A.UJI_MIKRO = '1' THEN 'Uji Kimia - Mikro' WHEN A.UJI_KIMIA = '1' THEN 'Uji Kimia' WHEN A.UJI_MIKRO = '1' THEN 'Uji Mikro' END+ '</div>'", "dbo.KATEGORI(A.KOMODITI,A.PRIORITAS) + '<div>' + dbo.KATEGORI(A.KATEGORI,A.PRIORITAS) + '</div>'","REPLACE(REPLACE(B.NAMA_BBPOM,'BALAI BESAR POM DI', ''),'BALAI POM DI','')","CASE WHEN A.CUKUP = 1 THEN 'Sampel Cukup' WHEN A.CUKUP = 0 THEN 'Sampel Tidak Cukup' END + '<div>'+CASE WHEN A.OPSI_D2 = 0 THEN 'Tidak ada Metode Analisis dan Baku Pembanding' WHEN A.OPSI_D2 = 2 THEN 'Metode Analisis ada dan Baku Pembanding tidak ada' WHEN A.OPSI_D2 = 1 THEN 'Metode Analisis ada dan Baku Pembanding ada' END +'</div>'"));
			$this->newtable->width(array('IDENTITAS SAMPEL' => 225, 'JUMLAH UJI' => 85, 'KOMODITI' => 75, 'BBPOM / BPOM' => 100, 'KETERANGAN' => 105));
			$this->newtable->cidb($this->db);
			$this->newtable->ciuri($this->uri->segment_array());
			$this->newtable->sortby("ASC");
			$this->newtable->keys(array('KODE_SAMPEL','STATUS_SAMPEL'));
			$this->newtable->orderby(1);
			$this->newtable->sortby("ASC");
			$proses['Preview Data'] = array('GET', site_url().'/home/pengujian/surveilance/view', '1');
			$this->newtable->menu($proses);
			$arrdata = array('table' => $this->newtable->generate($query),
							 'idjudul' => 'judulmsampel',
							 'caption_header' => $judul,
							 'batal' => '',
							 'cancel' => '');
			return $arrdata;
			
		}
	}
	
	function list_feed_back(){
		if($this->newsession->userdata('LOGGED_IN')){
			$sipt =& get_instance();
			$this->load->library('newtable');
			$judul = "Sampling Obat Kategori D2";
			$query = "SELECT KODE_SAMPEL, STATUS_SAMPEL, NAMA_SAMPEL + '<div>' + dbo.FORMAT_NOMOR('SPL',KODE_SAMPEL) + '</div><div>' + BENTUK_SEDIAAN + '</div><div>' + PABRIK + '</div><div>' + NOMOR_REGISTRASI + ', No Batch  : ' +  NO_BETS + '</div><div>'+TEMPAT_SAMPLING+'</div>' AS [IDENTITAS SAMPEL], CAST(JUMLAH_SAMPEL AS VARCHAR) +'&nbsp;'+ SATUAN +'<div>&bull;&nbsp;Uji Kimia : '+ CAST(JUMLAH_KIMIA AS VARCHAR)+'</div><div>&bull;&nbsp;Uji Mikro : '+CAST(JUMLAH_MIKRO AS VARCHAR) +'</div><div>&bull;&nbsp;Sisa Sampel : '+CAST(SISA AS VARCHAR) +'</div><div>' +CASE WHEN UJI_KIMIA = '1' AND UJI_MIKRO = '1' THEN 'Uji Kimia - Mikro' WHEN UJI_KIMIA = '1' THEN 'Uji Kimia' WHEN UJI_MIKRO = '1' THEN 'Uji Mikro' END+ '</div>' AS [JUMLAH UJI], dbo.KATEGORI(KOMODITI,PRIORITAS) + '<div>' + NAMA_KATEGORI + '</div>' AS KOMODITI, CASE WHEN CUKUP = 1 THEN 'Sampel Cukup' + '<div>'+CASE WHEN OPSI_D2 = 0 THEN 'Tidak ada Metode Analisis dan Baku Pembanding' WHEN OPSI_D2 = 2 THEN 'Metode Analisis ada dan Baku Pembanding tidak ada' ELSE '' END +'</div>' WHEN CUKUP = 2 THEN 'Sampel Tidak Cukup' END  AS KETERANGAN FROM T_M_SAMPEL WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND STATUS_SAMPEL = '60299'";
			$this->newtable->action(site_url()."/home/pengujian/surveilance");
			$this->newtable->hiddens(array('KODE_SAMPEL','STATUS_SAMPEL'));
			$this->newtable->search(array(array("NAMA_SAMPEL","Nama Sampel"),
										  array("dbo.FORMAT_NOMOR('SPL',KODE_SAMPEL)","Kode Sampel"),
										  array("TEMPAT_SAMPLING","Tempat Sampling"),
										  array("dbo.KATEGORI(KOMODITI,PRIORITAS)","Komoditi"),
										  array("NAMA_KATEGORI","Kategori")));
			$this->newtable->columns(array("KODE_SAMPEL", "STATUS_SAMPEL", array("NAMA_SAMPEL + '<div>' + dbo.FORMAT_NOMOR('SPL',KODE_SAMPEL) + '</div><div>' + BENTUK_SEDIAAN + '</div><div>' + PABRIK + '</div><div>' + NOMOR_REGISTRASI + ', No Batch  : ' +  NO_BETS + '</div><div>'+TEMPAT_SAMPLING+'</div>'",site_url()."/home/pengujian/surveilance/view/{KODE_SAMPEL}.{STATUS_SAMPEL}"),"CAST(JUMLAH_SAMPEL AS VARCHAR) +'&nbsp;'+ SATUAN +'<div>&bull;&nbsp;Uji Kimia : '+ CAST(JUMLAH_KIMIA AS VARCHAR)+'</div><div>&bull;&nbsp;Uji Mikro : '+CAST(JUMLAH_MIKRO AS VARCHAR) +'</div><div>&bull;&nbsp;Sisa Sampel : '+CAST(SISA AS VARCHAR) +'</div><div>' +CASE WHEN UJI_KIMIA = '1' AND UJI_MIKRO = '1' THEN 'Uji Kimia - Mikro' WHEN UJI_KIMIA = '1' THEN 'Uji Kimia' WHEN UJI_MIKRO = '1' THEN 'Uji Mikro' END+ '</div>'", "dbo.KATEGORI(KOMODITI,PRIORITAS) + '<div>' + dbo.KATEGORI(KATEGORI,PRIORITAS) + '</div>'","CASE WHEN CUKUP = 1 THEN 'Sampel Cukup' + '<div>'+CASE WHEN OPSI_D2 = 0 THEN 'Tidak ada Metode Analisis dan Baku Pembanding' WHEN OPSI_D2 = 2 THEN 'Metode Analisis ada dan Baku Pembanding tidak ada' ELSE '' END +'</div>' WHEN CUKUP = 2 THEN 'Sampel Tidak Cukup' END "));
			$this->newtable->width(array('IDENTITAS SAMPEL' => 225, 'JUMLAH UJI' => 85, 'KOMODITI' => 75, 'KETERANGAN' => 105));
			$this->newtable->cidb($this->db);
			$this->newtable->ciuri($this->uri->segment_array());
			$this->newtable->sortby("ASC");
			$this->newtable->keys(array('KODE_SAMPEL','STATUS_SAMPEL'));
			$this->newtable->orderby(1);
			$this->newtable->sortby("ASC");
			$proses['Preview Data'] = array('GET', site_url().'/home/pengujian/surveilance/view', '1');
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
			$query = "SELECT dbo.FORMAT_NOMOR('SPL', A.KODE_SAMPEL) AS UR_KODE, dbo.FORMAT_NOMOR('SPU', A.SPU_ID) AS UR_SPU, A.KODE_SAMPEL, A.PERIKSA_SAMPEL, dbo.KATEGORI(A.KOMODITI, A.PRIORITAS) AS KO, A.KOMODITI, dbo.KATEGORI(A.KATEGORI, A.PRIORITAS) AS KATEGORIX, A.NAMA_KATEGORI AS KATEGORI, A.SPU_ID, dbo.URAIAN_M_TABEL('ANGGARAN_SAMPLING', A.ANGGARAN) AS ANGGARAN, A.ANGGARAN AS AG, dbo.URAIAN_M_TABEL('ASAL_SAMPLING',A.ASAL_SAMPEL) AS ASAL_SAMPEL, dbo.URAIAN_M_TABEL('TUJUAN_SAMPLING',A.TUJUAN_SAMPLING) AS TUJUAN_SAMPLING, dbo.URAIAN_M_TABEL('SUB_TUJUAN', A.SUB_TUJUAN) AS SUB_TUJUAN, CONVERT(VARCHAR(10), A.TANGGAL_SAMPLING, 103) AS TANGGAL_SAMPLING, A.BULAN_ANGGARAN, A.SARANA_ID, A.TEMPAT_SAMPLING, A.ALAMAT_SAMPLING, A.KLASIFIKASI_TAMBAHAN, A.NAMA_SAMPEL, A.NOMOR_REGISTRASI, A.PABRIK, A.IMPORTIR, A.BENTUK_SEDIAAN, A.KEMASAN, A.NO_BETS, A.KETERANGAN_ED, A.JUMLAH_SAMPEL, A.SATUAN, A.HARGA_SAMPEL, A.UJI_KIMIA, A.JUMLAH_KIMIA, A.UJI_MIKRO, A.JUMLAH_MIKRO, RTRIM(LTRIM(A.HASIL_SAMPEL)) AS HASIL_SAMPEL, A.SISA, A.KOMPOSISI, A.NETTO, A.KONDISI_SAMPEL, A.EVALUASI_PENANDAAN, A.CARA_PENYIMPANAN, A.LABEL, A.SEGEL, RTRIM(LTRIM(A.HASIL_KIMIA)) AS HASIL_KIMIA, RTRIM(LTRIM(A.HASIL_MIKRO)) AS HASIL_MIKRO, A.UJI_UNGGULAN, A.LAMPIRAN, A.CATATAN AS [CATATAN SAMPEL], ISNULL(A.STATUS_KIMIA,'0') AS STATUS_KIMIA, ISNULL(A.STATUS_MIKRO,'0') AS STATUS_MIKRO, A.STATUS_SAMPEL, A.CATATAN_CP, dbo.URAIAN_M_TABEL('STATUS', A.STATUS_SAMPEL) AS [UR_STATUS_SAMPEL], A.PRIORITAS, B.BBPOM_ID, B.NOMOR_SURAT, CONVERT(VARCHAR(10), TANGGAL_SURAT, 103) AS TANGGAL_SURAT, B.NAMA_PENGIRIM, B.NIP_PENGIRIM, B.SURAT_PENGANTAR, B.NIP_POLISI, B.PANGKAT, B.INSTITUSI, B.ALAMAT, B.KOTA, B.NO_RESI_BANK, CONVERT(VARCHAR(10), B.TANGGAL_RESI_BANK, 103) AS TANGGAL_RESI_BANK, B.BIAYA, B.NO_LP, CONVERT(VARCHAR(10), B.TANGGAL_LP, 103) AS TANGGAL_LP, B.NO_SPDP, CONVERT(VARCHAR(10), B.TANGGAL_SPDP, 103) AS TANGGAL_SPDP, B.SAKSI_POLISI, B.NAMA_TERSANGKA, CONVERT(VARCHAR(10), B.TANGGAL_TERIMA, 103) AS TANGGAL_TERIMA, B.HARI_TERIMA, B.SAKSI_UJI, B.JUMLAH_UJI, B.CATATAN AS [CATATAN SURAT], C.USER_ID, D.NAMA_USER, A.HASIL_EVALUASI_D2 FROM T_M_SAMPEL A LEFT JOIN T_PERIKSA_SAMPEL B ON A.PERIKSA_SAMPEL = B.PERIKSA_SAMPEL LEFT JOIN T_PETUGAS_SAMPEL C ON A.PERIKSA_SAMPEL = C.PERIKSA_SAMPEL LEFT JOIN T_USER D ON C.USER_ID = D.USER_ID WHERE A.KODE_SAMPEL = '".$arrid[0]."' AND A.STATUS_SAMPEL = '".$arrid[1]."'";
			$data = $sipt->main->get_result($query);
			if($data){
				foreach($query->result_array() as $row){
					$arrdata = array('sess' => $row);

				}
				$arrdata['file'] = base_url().'files/sampel/'.md5(trim($row['BBPOM_ID'])).'/'.$row['LAMPIRAN'];
			}
			$arrdata['act'] = site_url().'/post/sampel/surveilance_act/disposisi';
			if (in_array('5', $this->newsession->userdata('SESS_KODE_ROLE')))
			{
				$arrdata['proses'] = $sipt->main->set_verifikasi($row['STATUS_SAMPEL'], $this->newsession->userdata('SESS_JENIS_PELAPORAN'), $this->newsession->userdata('SESS_KODE_ROLE'));
			}
			else
			{
				$pelaporan['01'] = '01';
				$arrdata['proses'] = $sipt->main->set_verifikasi($row['STATUS_SAMPEL'], $pelaporan, $this->newsession->userdata('SESS_KODE_ROLE'));
			}
			$arrdata['disproses'] = $row['STATUS_SAMPEL'];
			$arrdata['jml_log'] = $sipt->main->get_uraian("SELECT COUNT(*) AS JML FROM T_SAMPLING_LOG WHERE KODE_SAMPEL = '".$arrid[0]."'","JML");
			return $arrdata;
		}
	}
	
	function set_sampel($action, $isajax){
		if($this->newsession->userdata('LOGGED_IN') == TRUE){
			$sipt =& get_instance();
			$sipt->load->model("main","main", true);
			if($action == "disposisi"){
				$hasil = FALSE;
				$msgok = "Proses sampel berhasil";
				$msgerr = "Proses sampel gagal, Silahkan coba lagi";
				$arr_sampel = array('STATUS_SAMPEL' => $this->input->post('STATUS_SAMPEL'),
									'UPDATE_BY' => $this->newsession->userdata('SESS_USER_ID'));
				if($this->input->post('HASIL_EVALUASI_D2')){
					$arr_sampel['HASIL_EVALUASI_D2'] = $this->input->post('HASIL_EVALUASI_D2');
				}
				$this->db->where('KODE_SAMPEL', $this->input->post('KODE_SAMPEL'));
				$this->db->where('STATUS_SAMPEL', $this->input->post('STATUS'));
				$this->db->update('T_M_SAMPEL', $arr_sampel);
				if($this->db->affected_rows() > 0)
				{
					$hasil = TRUE;
					$data = array('KODE_SAMPEL' => $this->input->post('KODE_SAMPEL'),
								  'WAKTU' => 'GETDATE()',
								  'USER_ID' => $this->newsession->userdata('SESS_USER_ID'),
								  'KEGIATAN' => 'Tindak Lanjut Sampling - Obat Kategori D2',
								  'CATATAN' => $this->input->post('catatan'));
					$this->db->insert('T_SAMPLING_LOG', $data);
				}
				if($hasil)
				{	
					$ret = "MSG#YES#$msgok#".site_url()."/home/pengujian/surveilance";
				}
				else
				{
					$ret = "MSG#NO#$msgerr";
				}
				if($isajax!="ajax"){
					redirect(base_url());
					exit();
				}
				return $ret;
			}
			else if($action == "kirim_all")
			{
				$ret = "MSG#NO#Proses sampel gagal, Silahkan coba lagi#";
				foreach($this->input->post('KODE_SAMPEL') as $a){
					$res = $this->db->simple_query("UPDATE T_M_SAMPEL SET STATUS = '".$this->input->post('HASIL')."', UPDATE_BY = '". $this->newsession->userdata('SESS_USER_ID'). "' WHERE KODE_SAMPEL = '".$a."'");
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
				return $ret;
			}
		}
	}
	
}
?>
