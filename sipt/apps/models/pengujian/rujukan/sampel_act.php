 <?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR);
class Sampel_act extends Model{
	
	function list_rujukan($status){
		if((in_array('5', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('7', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('8', $this->newsession->userdata('SESS_KODE_ROLE'))) && $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$this->load->library('newtable');
			if($status == "draft"){
				$judul = "Draft Penerimaan Sampel Rujukan";
				$query = "SELECT A.KODE_SAMPEL, A.NAMA_SAMPEL + '<div>' + dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) + '</div><div>' + A.BENTUK_SEDIAAN + '</div><div>' + A.PABRIK + '</div><div>' + A.NOMOR_REGISTRASI + ', No Batch  : ' +  A.NO_BETS + '</div><div>'+A.TEMPAT_SAMPLING+'</div>' AS [IDENTITAS SAMPEL], CAST(A.JUMLAH_SAMPEL AS VARCHAR) +'&nbsp;'+ A.SATUAN +'<div>&bull;&nbsp;Uji Kimia : '+ CAST(A.JUMLAH_KIMIA AS VARCHAR)+'</div><div>&bull;&nbsp;Uji Mikro : '+CAST(A.JUMLAH_MIKRO AS VARCHAR) +'</div><div>&bull;&nbsp;Sisa Sampel : '+CAST(A.SISA AS VARCHAR) +'</div><div>' +CASE WHEN A.UJI_KIMIA = '1' AND A.UJI_MIKRO = '1' THEN 'Uji Kimia - Mikro' WHEN A.UJI_KIMIA = '1' THEN 'Uji Kimia' WHEN A.UJI_MIKRO = '1' THEN 'Uji Mikro' END+ '</div>' AS [JUMLAH UJI], dbo.KATEGORI(A.KOMODITI,A.PRIORITAS) + '<div>' + dbo.KATEGORI(A.KATEGORI,A.PRIORITAS) + '</div>' AS KOMODITI, '<div>Hasil Uji Kimia : ' + A.HASIL_KIMIA + '</div><div>Hasil Uji Mikro : ' + A.HASIL_MIKRO + '</div><div>Hasil Sampel : ' + A.HASIL_SAMPEL + '</div>' AS HASIL, REPLACE(REPLACE(C.NAMA_BBPOM, 'BALAI POM DI ', ''), 'BALAI BESAR POM DI ','') AS [BALAI PENGIRIM], CONVERT(VARCHAR(10), A.UPDATE_DATE, 120) AS UPDATE_DATE 
				FROM T_M_SAMPEL A 
				LEFT JOIN T_SAMPEL_RUJUKAN B ON A.KODE_SAMPEL = B.KODE_SAMPEL
				LEFT JOIN M_BBPOM C ON B.BBPOM_ASAL = C.BBPOM_ID
				WHERE B.BBPOM_RUJUK = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND B.STATUS = '70011' AND A.UJI_RUJUK = '1' AND B.STATUS_RUJUKAN = 1";
				
				$this->newtable->search(array(array("A.NAMA_SAMPEL","Nama Sampel"),array("dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL)","Kode Sampel"),array("A.TEMPAT_SAMPLING","Tempat Sampling"),array("dbo.KATEGORI(A.KOMODITI,A.PRIORITAS)","Komoditi"),array("dbo.KATEGORI(A.KATEGORI,A.PRIORITAS)","Kategori"),array("C.NAMA_BBPOM","Balai Pengirim")));
				
				$this->newtable->columns(array("A.KODE_SAMPEL", array("A.NAMA_SAMPEL + '<div>' + dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) + '</div><div>' + A.BENTUK_SEDIAAN + '</div><div>' + A.PABRIK + '</div><div>' + A.NOMOR_REGISTRASI + ', No Batch  : ' +  A.NO_BETS + '</div><div>'+A.TEMPAT_SAMPLING+'</div>'",site_url()."/home/rujukan/preview/sampel/{KODE_SAMPEL}"),"CAST(A.JUMLAH_SAMPEL AS VARCHAR) +'&nbsp;'+ A.SATUAN +'<div>&bull;&nbsp;Uji Kimia : '+ CAST(A.JUMLAH_KIMIA AS VARCHAR)+'</div><div>&bull;&nbsp;Uji Mikro : '+CAST(A.JUMLAH_MIKRO AS VARCHAR) +'</div><div>&bull;&nbsp;Sisa Sampel : '+CAST(A.SISA AS VARCHAR) +'</div><div>' +CASE WHEN A.UJI_KIMIA = '1' AND A.UJI_MIKRO = '1' THEN 'Uji Kimia - Mikro' WHEN A.UJI_KIMIA = '1' THEN 'Uji Kimia' WHEN A.UJI_MIKRO = '1' THEN 'Uji Mikro' END+ '</div>'", "dbo.KATEGORI(A.KOMODITI,A.PRIORITAS) + '<div>' + dbo.KATEGORI(A.KATEGORI,A.PRIORITAS) + '</div>'","'<div>Hasil Uji Kimia : ' + A.HASIL_KIMIA + '</div><div>A.Hasil Uji Mikro : ' + A.HASIL_MIKRO + '</div><div>Hasil : ' + A.HASIL_SAMPEL + '</div>'","REPLACE(REPLACE(C.NAMA_BBPOM, 'BALAI POM DI ', ''), 'BALAI BESAR POM DI ','')"," CONVERT(VARCHAR(10), A.UPDATE_DATE, 120)"));
				$this->newtable->orderby(7);
				$this->newtable->sortby("DESC");
				$this->newtable->width(array('IDENTITAS SAMPEL' => 225, 'JUMLAH UJI' => 85, 'KOMODITI' => 75, 'HASIL' => 105, 'BALAI PENGIRIM' => 100));
				//$proses['Preview Data'] = array('POST', site_url().'/post/rujukan/kirim_act/rujuk/ajax', 'N');
			}
			else if($status == "verifikasi"){
				$judul = "Verifikasi Penerimaan Sampel Rujukan";
				$query = "SELECT A.KODE_SAMPEL, A.NAMA_SAMPEL + '<div>' + dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) + '</div><div>' + A.BENTUK_SEDIAAN + '</div><div>' + A.PABRIK + '</div><div>' + A.NOMOR_REGISTRASI + ', No Batch  : ' +  A.NO_BETS + '</div><div>'+A.TEMPAT_SAMPLING+'</div>' AS [IDENTITAS SAMPEL], CAST(A.JUMLAH_SAMPEL AS VARCHAR) +'&nbsp;'+ A.SATUAN +'<div>&bull;&nbsp;Uji Kimia : '+ CAST(A.JUMLAH_KIMIA AS VARCHAR)+'</div><div>&bull;&nbsp;Uji Mikro : '+CAST(A.JUMLAH_MIKRO AS VARCHAR) +'</div><div>&bull;&nbsp;Sisa Sampel : '+CAST(A.SISA AS VARCHAR) +'</div><div>' +CASE WHEN A.UJI_KIMIA = '1' AND A.UJI_MIKRO = '1' THEN 'Uji Kimia - Mikro' WHEN A.UJI_KIMIA = '1' THEN 'Uji Kimia' WHEN A.UJI_MIKRO = '1' THEN 'Uji Mikro' END+ '</div>' AS [JUMLAH UJI], dbo.KATEGORI(A.KOMODITI,A.PRIORITAS) + '<div>' + dbo.KATEGORI(A.KATEGORI,A.PRIORITAS) + '</div>' AS KOMODITI, '<div>Hasil Uji Kimia : ' + A.HASIL_KIMIA + '</div><div>Hasil Uji Mikro : ' + A.HASIL_MIKRO + '</div><div>Hasil Sampel : ' + A.HASIL_SAMPEL + '</div>' AS HASIL, REPLACE(REPLACE(C.NAMA_BBPOM, 'BALAI POM DI ', ''), 'BALAI BESAR POM DI ','') AS [BALAI PENGIRIM], CONVERT(VARCHAR(10), A.UPDATE_DATE, 120) AS UPDATE_DATE 
				FROM T_M_SAMPEL A 
				LEFT JOIN T_SAMPEL_RUJUKAN B ON A.KODE_SAMPEL = B.KODE_SAMPEL
				LEFT JOIN M_BBPOM C ON B.BBPOM_ASAL = C.BBPOM_ID
				WHERE B.BBPOM_RUJUK = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND B.STATUS = '80011' AND A.UJI_RUJUK = '1' AND B.STATUS_RUJUKAN = 1";
				
				$this->newtable->search(array(array("A.NAMA_SAMPEL","Nama Sampel"),array("dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL)","Kode Sampel"),array("A.TEMPAT_SAMPLING","Tempat Sampling"),array("dbo.KATEGORI(A.KOMODITI,A.PRIORITAS)","Komoditi"),array("dbo.KATEGORI(A.KATEGORI,A.PRIORITAS)","Kategori"),array("C.NAMA_BBPOM","Balai Pengirim")));
				
				$this->newtable->columns(array("A.KODE_SAMPEL", array("A.NAMA_SAMPEL + '<div>' + dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) + '</div><div>' + A.BENTUK_SEDIAAN + '</div><div>' + A.PABRIK + '</div><div>' + A.NOMOR_REGISTRASI + ', No Batch  : ' +  A.NO_BETS + '</div><div>'+A.TEMPAT_SAMPLING+'</div>'",site_url()."/home/rujukan/preview/sampel/{KODE_SAMPEL}"),"CAST(A.JUMLAH_SAMPEL AS VARCHAR) +'&nbsp;'+ A.SATUAN +'<div>&bull;&nbsp;Uji Kimia : '+ CAST(A.JUMLAH_KIMIA AS VARCHAR)+'</div><div>&bull;&nbsp;Uji Mikro : '+CAST(A.JUMLAH_MIKRO AS VARCHAR) +'</div><div>&bull;&nbsp;Sisa Sampel : '+CAST(A.SISA AS VARCHAR) +'</div><div>' +CASE WHEN A.UJI_KIMIA = '1' AND A.UJI_MIKRO = '1' THEN 'Uji Kimia - Mikro' WHEN A.UJI_KIMIA = '1' THEN 'Uji Kimia' WHEN A.UJI_MIKRO = '1' THEN 'Uji Mikro' END+ '</div>'", "dbo.KATEGORI(A.KOMODITI,A.PRIORITAS) + '<div>' + dbo.KATEGORI(A.KATEGORI,A.PRIORITAS) + '</div>'","'<div>Hasil Uji Kimia : ' + A.HASIL_KIMIA + '</div><div>A.Hasil Uji Mikro : ' + A.HASIL_MIKRO + '</div><div>Hasil : ' + A.HASIL_SAMPEL + '</div>'","REPLACE(REPLACE(C.NAMA_BBPOM, 'BALAI POM DI ', ''), 'BALAI BESAR POM DI ','')"," CONVERT(VARCHAR(10), A.UPDATE_DATE, 120)"));
				$this->newtable->orderby(7);
				$this->newtable->sortby("DESC");
				$this->newtable->width(array('IDENTITAS SAMPEL' => 225, 'JUMLAH UJI' => 85, 'KOMODITI' => 75, 'HASIL' => 105, 'BALAI PENGIRIM' => 100));
				//$proses['Preview Data'] = array('POST', site_url().'/post/rujukan/kirim_act/rujuk/ajax', 'N');
			}

			else if($status == "none"){ 
				$judul = "Data Sampel Rujukan Tidak Di Uji ";
				$query = "SELECT A.KODE_SAMPEL, A.NAMA_SAMPEL + '<div>' + dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) + '</div><div>' + A.BENTUK_SEDIAAN + '</div><div>' + A.PABRIK + '</div><div>' + A.NOMOR_REGISTRASI + ', No Batch  : ' +  A.NO_BETS + '</div><div>'+A.TEMPAT_SAMPLING+'</div>' AS [IDENTITAS SAMPEL], CAST(A.JUMLAH_SAMPEL AS VARCHAR) +'&nbsp;'+ A.SATUAN +'<div>&bull;&nbsp;Uji Kimia : '+ CAST(A.JUMLAH_KIMIA AS VARCHAR)+'</div><div>&bull;&nbsp;Uji Mikro : '+CAST(A.JUMLAH_MIKRO AS VARCHAR) +'</div><div>&bull;&nbsp;Sisa Sampel : '+CAST(A.SISA AS VARCHAR) +'</div><div>' +CASE WHEN A.UJI_KIMIA = '1' AND A.UJI_MIKRO = '1' THEN 'Uji Kimia - Mikro' WHEN A.UJI_KIMIA = '1' THEN 'Uji Kimia' WHEN A.UJI_MIKRO = '1' THEN 'Uji Mikro' END+ '</div>' AS [JUMLAH UJI], dbo.KATEGORI(A.KOMODITI,A.PRIORITAS) + '<div>' + dbo.KATEGORI(A.KATEGORI,A.PRIORITAS) + '</div>' AS KOMODITI, '<div><b>Balai Asal</b></div><div>Hasil Uji Kimia : ' + A.HASIL_KIMIA + '</div><div>Hasil Uji Mikro : ' + A.HASIL_MIKRO + '</div><div>Hasil Sampel : ' + A.HASIL_SAMPEL + '</div><div>&nbsp;</div><div><b>Balai Rujukan</b></div><div>' + dbo.FORMAT_NOMOR('SPL',D.KODE_SAMPEL) + '</div><div>Tidak Di Uji</div>' AS HASIL, REPLACE(REPLACE(C.NAMA_BBPOM, 'BALAI POM DI ', ''), 'BALAI BESAR POM DI ','') AS [BALAI PENGIRIM], CONVERT(VARCHAR(10), A.UPDATE_DATE, 120) AS UPDATE_DATE 
				FROM T_M_SAMPEL A 
				LEFT JOIN T_SAMPEL_RUJUKAN B ON A.KODE_SAMPEL = B.KODE_SAMPEL
				LEFT JOIN M_BBPOM C ON B.BBPOM_ASAL = C.BBPOM_ID
				LEFT JOIN T_M_SAMPEL D ON D.KODE_RUJUKAN = A.KODE_SAMPEL
				WHERE B.BBPOM_RUJUK = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND A.STATUS_SAMPEL = '50205' AND A.UJI_RUJUK = '1' AND B.STATUS_RUJUKAN = 2";
				$this->newtable->search(array(array("A.NAMA_SAMPEL","Nama Sampel"),array("dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL)","Kode Sampel"),array("A.TEMPAT_SAMPLING","Tempat Sampling"),array("dbo.KATEGORI(A.KOMODITI,A.PRIORITAS)","Komoditi"),array("dbo.KATEGORI(A.KATEGORI,A.PRIORITAS)","Kategori"),array("C.NAMA_BBPOM","Balai Pengirim")));
				
				$this->newtable->columns(array("A.KODE_SAMPEL", array("A.NAMA_SAMPEL + '<div>' + dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) + '</div><div>' + A.BENTUK_SEDIAAN + '</div><div>' + A.PABRIK + '</div><div>' + A.NOMOR_REGISTRASI + ', No Batch  : ' +  A.NO_BETS + '</div><div>'+A.TEMPAT_SAMPLING+'</div>'",site_url()."/home/rujukan/preview/sampel/{KODE_SAMPEL}"),"CAST(A.JUMLAH_SAMPEL AS VARCHAR) +'&nbsp;'+ A.SATUAN +'<div>&bull;&nbsp;Uji Kimia : '+ CAST(A.JUMLAH_KIMIA AS VARCHAR)+'</div><div>&bull;&nbsp;Uji Mikro : '+CAST(A.JUMLAH_MIKRO AS VARCHAR) +'</div><div>&bull;&nbsp;Sisa Sampel : '+CAST(A.SISA AS VARCHAR) +'</div><div>' +CASE WHEN A.UJI_KIMIA = '1' AND A.UJI_MIKRO = '1' THEN 'Uji Kimia - Mikro' WHEN A.UJI_KIMIA = '1' THEN 'Uji Kimia' WHEN A.UJI_MIKRO = '1' THEN 'Uji Mikro' END+ '</div>'", "dbo.KATEGORI(A.KOMODITI,A.PRIORITAS) + '<div>' + dbo.KATEGORI(A.KATEGORI,A.PRIORITAS) + '</div>'","'<div>Hasil Uji Kimia : ' + A.HASIL_KIMIA + '</div><div>Tidak Di Uji</div>'","REPLACE(REPLACE(C.NAMA_BBPOM, 'BALAI POM DI ', ''), 'BALAI BESAR POM DI ','')"," CONVERT(VARCHAR(10), A.UPDATE_DATE, 120)"));
				$this->newtable->orderby(7);
				$this->newtable->sortby("DESC");
				$this->newtable->width(array('IDENTITAS SAMPEL' => 225, 'JUMLAH UJI' => 85, 'KOMODITI' => 75, 'HASIL' => 105, 'BALAI PENGIRIM' => 100));
				$proses['Kirim Data'] = array('POST', site_url().'/post/rujukan/kirim_act/feed-back/ajax', 'N');
			}

			else if($status == "deliver"){
				$judul = "Data Penyerahan Sampel Ke Bidang ";
				$query = "SELECT A.KODE_SAMPEL, A.NAMA_SAMPEL + '<div>' + dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) + '</div><div>' + A.BENTUK_SEDIAAN + '</div><div>' + A.PABRIK + '</div><div>' + A.NOMOR_REGISTRASI + ', No Batch  : ' +  A.NO_BETS + '</div><div>'+A.TEMPAT_SAMPLING+'</div>' AS [IDENTITAS SAMPEL], CAST(A.JUMLAH_SAMPEL AS VARCHAR) +'&nbsp;'+ A.SATUAN +'<div>&bull;&nbsp;Uji Kimia : '+ CAST(A.JUMLAH_KIMIA AS VARCHAR)+'</div><div>&bull;&nbsp;Uji Mikro : '+CAST(A.JUMLAH_MIKRO AS VARCHAR) +'</div><div>&bull;&nbsp;Sisa Sampel : '+CAST(A.SISA AS VARCHAR) +'</div><div>' +CASE WHEN A.UJI_KIMIA = '1' AND A.UJI_MIKRO = '1' THEN 'Uji Kimia - Mikro' WHEN A.UJI_KIMIA = '1' THEN 'Uji Kimia' WHEN A.UJI_MIKRO = '1' THEN 'Uji Mikro' END+ '</div>' AS [JUMLAH UJI], dbo.KATEGORI(A.KOMODITI,A.PRIORITAS) + '<div>' + dbo.KATEGORI(A.KATEGORI,A.PRIORITAS) + '</div>' AS KOMODITI, '<div>Hasil Uji Kimia : ' + A.HASIL_KIMIA + '</div><div>Hasil Uji Mikro : ' + A.HASIL_MIKRO + '</div><div>Hasil Sampel : ' + A.HASIL_SAMPEL + '</div>' AS HASIL, REPLACE(REPLACE(C.NAMA_BBPOM, 'BALAI POM DI ', ''), 'BALAI BESAR POM DI ','') AS [BALAI PENGIRIM], CONVERT(VARCHAR(10), A.UPDATE_DATE, 120) AS UPDATE_DATE 
				FROM T_M_SAMPEL A 
				LEFT JOIN T_SAMPEL_RUJUKAN B ON A.KODE_SAMPEL = B.KODE_SAMPEL
				LEFT JOIN M_BBPOM C ON B.BBPOM_ASAL = C.BBPOM_ID
				WHERE B.BBPOM_RUJUK = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND B.STATUS = '70012' AND A.UJI_RUJUK = '1' AND B.STATUS_RUJUKAN = 1";
				
				$this->newtable->search(array(array("A.NAMA_SAMPEL","Nama Sampel"),array("dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL)","Kode Sampel"),array("A.TEMPAT_SAMPLING","Tempat Sampling"),array("dbo.KATEGORI(A.KOMODITI,A.PRIORITAS)","Komoditi"),array("dbo.KATEGORI(A.KATEGORI,A.PRIORITAS)","Kategori"),array("C.NAMA_BBPOM","Balai Pengirim")));
				
				$this->newtable->columns(array("A.KODE_SAMPEL", array("A.NAMA_SAMPEL + '<div>' + dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) + '</div><div>' + A.BENTUK_SEDIAAN + '</div><div>' + A.PABRIK + '</div><div>' + A.NOMOR_REGISTRASI + ', No Batch  : ' +  A.NO_BETS + '</div><div>'+A.TEMPAT_SAMPLING+'</div>'",site_url()."/home/rujukan/preview/sampel/{KODE_SAMPEL}"),"CAST(A.JUMLAH_SAMPEL AS VARCHAR) +'&nbsp;'+ A.SATUAN +'<div>&bull;&nbsp;Uji Kimia : '+ CAST(A.JUMLAH_KIMIA AS VARCHAR)+'</div><div>&bull;&nbsp;Uji Mikro : '+CAST(A.JUMLAH_MIKRO AS VARCHAR) +'</div><div>&bull;&nbsp;Sisa Sampel : '+CAST(A.SISA AS VARCHAR) +'</div><div>' +CASE WHEN A.UJI_KIMIA = '1' AND A.UJI_MIKRO = '1' THEN 'Uji Kimia - Mikro' WHEN A.UJI_KIMIA = '1' THEN 'Uji Kimia' WHEN A.UJI_MIKRO = '1' THEN 'Uji Mikro' END+ '</div>'", "dbo.KATEGORI(A.KOMODITI,A.PRIORITAS) + '<div>' + dbo.KATEGORI(A.KATEGORI,A.PRIORITAS) + '</div>'","'<div>Hasil Uji Kimia : ' + A.HASIL_KIMIA + '</div><div>A.Hasil Uji Mikro : ' + A.HASIL_MIKRO + '</div><div>Hasil : ' + A.HASIL_SAMPEL + '</div>'","REPLACE(REPLACE(C.NAMA_BBPOM, 'BALAI POM DI ', ''), 'BALAI BESAR POM DI ','')"," CONVERT(VARCHAR(10), A.UPDATE_DATE, 120)"));
				$this->newtable->orderby(7);
				$this->newtable->sortby("DESC");
				$this->newtable->width(array('IDENTITAS SAMPEL' => 225, 'JUMLAH UJI' => 85, 'KOMODITI' => 75, 'HASIL' => 105, 'BALAI PENGIRIM' => 100));
				//$proses['Preview Data'] = array('POST', site_url().'/post/rujukan/kirim_act/rujuk/ajax', 'N');
			}
			else if($status == "sent"){ 
				$judul = "Data Sampel Rujukan Terkirim Ke Pusat ";
				$query = "SELECT A.KODE_SAMPEL, A.NAMA_SAMPEL + '<div>' + dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) + '</div><div>' + A.BENTUK_SEDIAAN + '</div><div>' + A.PABRIK + '</div><div>' + A.NOMOR_REGISTRASI + ', No Batch  : ' +  A.NO_BETS + '</div><div>'+A.TEMPAT_SAMPLING+'</div>' AS [IDENTITAS SAMPEL], CAST(A.JUMLAH_SAMPEL AS VARCHAR) +'&nbsp;'+ A.SATUAN +'<div>&bull;&nbsp;Uji Kimia : '+ CAST(A.JUMLAH_KIMIA AS VARCHAR)+'</div><div>&bull;&nbsp;Uji Mikro : '+CAST(A.JUMLAH_MIKRO AS VARCHAR) +'</div><div>&bull;&nbsp;Sisa Sampel : '+CAST(A.SISA AS VARCHAR) +'</div><div>' +CASE WHEN A.UJI_KIMIA = '1' AND A.UJI_MIKRO = '1' THEN 'Uji Kimia - Mikro' WHEN A.UJI_KIMIA = '1' THEN 'Uji Kimia' WHEN A.UJI_MIKRO = '1' THEN 'Uji Mikro' END+ '</div>' AS [JUMLAH UJI], dbo.KATEGORI(A.KOMODITI,A.PRIORITAS) + '<div>' + dbo.KATEGORI(A.KATEGORI,A.PRIORITAS) + '</div>' AS KOMODITI, '<div><b>Balai Asal</b></div><div>Hasil Uji Kimia : ' + A.HASIL_KIMIA + '</div><div>Hasil Uji Mikro : ' + A.HASIL_MIKRO + '</div><div>Hasil Sampel : ' + A.HASIL_SAMPEL + '</div><div>&nbsp;</div><div><b>Balai Rujukan</b></div><div>' + dbo.FORMAT_NOMOR('SPL',D.KODE_SAMPEL) + '</div>' + CASE WHEN D.HASIL_SAMPEL IS NOT NULL THEN '<div>Hasil Uji Kimia : ' + D.HASIL_KIMIA + '</div><div>Hasil Uji Mikro : ' + D.HASIL_MIKRO + '</div><div>Hasil Sampel : ' + D.HASIL_SAMPEL + '</div>' ELSE '<div><b>Tidak Di Uji</b></div>' END AS HASIL, REPLACE(REPLACE(C.NAMA_BBPOM, 'BALAI POM DI ', ''), 'BALAI BESAR POM DI ','') AS [BALAI PENGIRIM], CONVERT(VARCHAR(10), A.UPDATE_DATE, 120) AS UPDATE_DATE 
				FROM T_M_SAMPEL A 
				LEFT JOIN T_SAMPEL_RUJUKAN B ON A.KODE_SAMPEL = B.KODE_SAMPEL
				LEFT JOIN M_BBPOM C ON B.BBPOM_ASAL = C.BBPOM_ID
				LEFT JOIN T_M_SAMPEL D ON D.KODE_RUJUKAN = A.KODE_SAMPEL
				WHERE B.BBPOM_RUJUK = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND A.STATUS_SAMPEL = '80215' AND A.UJI_RUJUK = '1' AND B.STATUS_RUJUKAN = 2";
				//echo $query;die();
				$this->newtable->search(array(array("A.NAMA_SAMPEL","Nama Sampel"),array("dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL)","Kode Sampel"),array("A.TEMPAT_SAMPLING","Tempat Sampling"),array("dbo.KATEGORI(A.KOMODITI,A.PRIORITAS)","Komoditi"),array("dbo.KATEGORI(A.KATEGORI,A.PRIORITAS)","Kategori"),array("C.NAMA_BBPOM","Balai Pengirim")));
				
				$this->newtable->columns(array("A.KODE_SAMPEL", array("A.NAMA_SAMPEL + '<div>' + dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) + '</div><div>' + A.BENTUK_SEDIAAN + '</div><div>' + A.PABRIK + '</div><div>' + A.NOMOR_REGISTRASI + ', No Batch  : ' +  A.NO_BETS + '</div><div>'+A.TEMPAT_SAMPLING+'</div>'",site_url()."/home/rujukan/preview/sampel/{KODE_SAMPEL}"),"CAST(A.JUMLAH_SAMPEL AS VARCHAR) +'&nbsp;'+ A.SATUAN +'<div>&bull;&nbsp;Uji Kimia : '+ CAST(A.JUMLAH_KIMIA AS VARCHAR)+'</div><div>&bull;&nbsp;Uji Mikro : '+CAST(A.JUMLAH_MIKRO AS VARCHAR) +'</div><div>&bull;&nbsp;Sisa Sampel : '+CAST(A.SISA AS VARCHAR) +'</div><div>' +CASE WHEN A.UJI_KIMIA = '1' AND A.UJI_MIKRO = '1' THEN 'Uji Kimia - Mikro' WHEN A.UJI_KIMIA = '1' THEN 'Uji Kimia' WHEN A.UJI_MIKRO = '1' THEN 'Uji Mikro' END+ '</div>'", "dbo.KATEGORI(A.KOMODITI,A.PRIORITAS) + '<div>' + dbo.KATEGORI(A.KATEGORI,A.PRIORITAS) + '</div>'","'<div>Hasil Uji Kimia : ' + A.HASIL_KIMIA + '</div><div>A.Hasil Uji Mikro : ' + A.HASIL_MIKRO + '</div><div>Hasil : ' + A.HASIL_SAMPEL + '</div>'","REPLACE(REPLACE(C.NAMA_BBPOM, 'BALAI POM DI ', ''), 'BALAI BESAR POM DI ','')"," CONVERT(VARCHAR(10), A.UPDATE_DATE, 120)"));
				$this->newtable->orderby(7);
				$this->newtable->sortby("DESC");
				$this->newtable->width(array('IDENTITAS SAMPEL' => 225, 'JUMLAH UJI' => 85, 'KOMODITI' => 75, 'HASIL' => 105, 'BALAI PENGIRIM' => 100));
				//$proses['Preview Data'] = array('POST', site_url().'/post/rujukan/kirim_act/rujuk/ajax', 'N');
			}
			else if($status == "done"){
				$judul = "Data Sampel Rujukan Selesai ";
				$query = "SELECT A.KODE_SAMPEL, A.NAMA_SAMPEL + '<div>' + dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) + '</div><div>' + A.BENTUK_SEDIAAN + '</div><div>' + A.PABRIK + '</div><div>' + A.NOMOR_REGISTRASI + ', No Batch  : ' +  A.NO_BETS + '</div><div>'+A.TEMPAT_SAMPLING+'</div>' AS [IDENTITAS SAMPEL], CAST(A.JUMLAH_SAMPEL AS VARCHAR) +'&nbsp;'+ A.SATUAN +'<div>&bull;&nbsp;Uji Kimia : '+ CAST(A.JUMLAH_KIMIA AS VARCHAR)+'</div><div>&bull;&nbsp;Uji Mikro : '+CAST(A.JUMLAH_MIKRO AS VARCHAR) +'</div><div>&bull;&nbsp;Sisa Sampel : '+CAST(A.SISA AS VARCHAR) +'</div><div>' +CASE WHEN A.UJI_KIMIA = '1' AND A.UJI_MIKRO = '1' THEN 'Uji Kimia - Mikro' WHEN A.UJI_KIMIA = '1' THEN 'Uji Kimia' WHEN A.UJI_MIKRO = '1' THEN 'Uji Mikro' END+ '</div>' AS [JUMLAH UJI], dbo.KATEGORI(A.KOMODITI,A.PRIORITAS) + '<div>' + dbo.KATEGORI(A.KATEGORI,A.PRIORITAS) + '</div>' AS KOMODITI, '<div><b>Balai Asal</b></div><div>Hasil Uji Kimia : ' + A.HASIL_KIMIA + '</div><div>Hasil Uji Mikro : ' + A.HASIL_MIKRO + '</div><div>Hasil Sampel : ' + A.HASIL_SAMPEL + '</div><div>&nbsp;</div><div><b>Balai Rujukan</b></div>' + CASE WHEN D.HASIL_SAMPEL IS NOT NULL  THEN '<div>Hasil Uji Kimia : ' + D.HASIL_KIMIA + '</div><div>Hasil Uji Mikro : ' + D.HASIL_MIKRO + '</div><div>Hasil Sampel : ' + D.HASIL_SAMPEL + '</div>' ELSE '<div><b>Tidak Di Uji</b></div>' END AS HASIL, REPLACE(REPLACE(C.NAMA_BBPOM, 'BALAI POM DI ', ''), 'BALAI BESAR POM DI ','') AS [BALAI PENGIRIM], CONVERT(VARCHAR(10), A.UPDATE_DATE, 120) AS UPDATE_DATE 
				FROM T_M_SAMPEL A 
				LEFT JOIN T_SAMPEL_RUJUKAN B ON A.KODE_SAMPEL = B.KODE_SAMPEL
				LEFT JOIN M_BBPOM C ON B.BBPOM_RUJUK = C.BBPOM_ID
				LEFT JOIN T_M_SAMPEL D ON D.KODE_RUJUKAN = A.KODE_SAMPEL
				WHERE B.BBPOM_ASAL = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND A.STATUS_SAMPEL = '80215' AND A.UJI_RUJUK = '1' AND B.STATUS_RUJUKAN = 2";
				
				$this->newtable->search(array(array("A.NAMA_SAMPEL","Nama Sampel"),array("dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL)","Kode Sampel"),array("A.TEMPAT_SAMPLING","Tempat Sampling"),array("dbo.KATEGORI(A.KOMODITI,A.PRIORITAS)","Komoditi"),array("dbo.KATEGORI(A.KATEGORI,A.PRIORITAS)","Kategori"),array("C.NAMA_BBPOM","Balai Pengirim")));
				
				$this->newtable->columns(array("A.KODE_SAMPEL", array("A.NAMA_SAMPEL + '<div>' + dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) + '</div><div>' + A.BENTUK_SEDIAAN + '</div><div>' + A.PABRIK + '</div><div>' + A.NOMOR_REGISTRASI + ', No Batch  : ' +  A.NO_BETS + '</div><div>'+A.TEMPAT_SAMPLING+'</div>'",site_url()."/home/rujukan/preview/sampel/{KODE_SAMPEL}"),"CAST(A.JUMLAH_SAMPEL AS VARCHAR) +'&nbsp;'+ A.SATUAN +'<div>&bull;&nbsp;Uji Kimia : '+ CAST(A.JUMLAH_KIMIA AS VARCHAR)+'</div><div>&bull;&nbsp;Uji Mikro : '+CAST(A.JUMLAH_MIKRO AS VARCHAR) +'</div><div>&bull;&nbsp;Sisa Sampel : '+CAST(A.SISA AS VARCHAR) +'</div><div>' +CASE WHEN A.UJI_KIMIA = '1' AND A.UJI_MIKRO = '1' THEN 'Uji Kimia - Mikro' WHEN A.UJI_KIMIA = '1' THEN 'Uji Kimia' WHEN A.UJI_MIKRO = '1' THEN 'Uji Mikro' END+ '</div>'", "dbo.KATEGORI(A.KOMODITI,A.PRIORITAS) + '<div>' + dbo.KATEGORI(A.KATEGORI,A.PRIORITAS) + '</div>'","'<div>Hasil Uji Kimia : ' + A.HASIL_KIMIA + '</div><div>A.Hasil Uji Mikro : ' + A.HASIL_MIKRO + '</div><div>Hasil : ' + A.HASIL_SAMPEL + '</div>'","REPLACE(REPLACE(C.NAMA_BBPOM, 'BALAI POM DI ', ''), 'BALAI BESAR POM DI ','')"," CONVERT(VARCHAR(10), A.UPDATE_DATE, 120)"));
				$this->newtable->orderby(7);
				$this->newtable->sortby("DESC");
				$this->newtable->width(array('IDENTITAS SAMPEL' => 225, 'JUMLAH UJI' => 85, 'KOMODITI' => 75, 'HASIL' => 105, 'BALAI PENGIRIM' => 100));
				//$proses['Preview Data'] = array('POST', site_url().'/post/rujukan/kirim_act/rujuk/ajax', 'N');
			}
			else if($status == "all"){
				$judul = "Data Sampel Rujukan Terkirim";
				$query = "SELECT A.KODE_SAMPEL, A.NAMA_SAMPEL + '<div>' + dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) + '</div><div>' + A.BENTUK_SEDIAAN + '</div><div>' + A.PABRIK + '</div><div>' + A.NOMOR_REGISTRASI + ', No Batch  : ' +  A.NO_BETS + '</div><div>'+A.TEMPAT_SAMPLING+'</div>' AS [IDENTITAS SAMPEL], CAST(A.JUMLAH_SAMPEL AS VARCHAR) +'&nbsp;'+ A.SATUAN +'<div>&bull;&nbsp;Uji Kimia : '+ CAST(A.JUMLAH_KIMIA AS VARCHAR)+'</div><div>&bull;&nbsp;Uji Mikro : '+CAST(A.JUMLAH_MIKRO AS VARCHAR) +'</div><div>&bull;&nbsp;Sisa Sampel : '+CAST(A.SISA AS VARCHAR) +'</div><div>' +CASE WHEN A.UJI_KIMIA = '1' AND A.UJI_MIKRO = '1' THEN 'Uji Kimia - Mikro' WHEN A.UJI_KIMIA = '1' THEN 'Uji Kimia' WHEN A.UJI_MIKRO = '1' THEN 'Uji Mikro' END+ '</div>' AS [JUMLAH UJI], dbo.KATEGORI(A.KOMODITI,A.PRIORITAS) + '<div>' + dbo.KATEGORI(A.KATEGORI,A.PRIORITAS) + '</div>' AS KOMODITI, '<div>Hasil Uji Kimia : ' + A.HASIL_KIMIA + '</div><div>Hasil Uji Mikro : ' + A.HASIL_MIKRO + '</div><div>Hasil Sampel : ' + A.HASIL_SAMPEL + '</div>' AS HASIL, REPLACE(REPLACE(C.NAMA_BBPOM, 'BALAI POM DI ', ''), 'BALAI BESAR POM DI ','') AS [BALAI PENGIRIM], CONVERT(VARCHAR(10), A.UPDATE_DATE, 120) AS UPDATE_DATE 
				FROM T_M_SAMPEL A 
				LEFT JOIN T_SAMPEL_RUJUKAN B ON A.KODE_SAMPEL = B.KODE_SAMPEL
				LEFT JOIN M_BBPOM C ON B.BBPOM_ASAL = C.BBPOM_ID
				WHERE B.BBPOM_RUJUK = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND A.STATUS_SAMPEL = '70012' AND A.UJI_RUJUK = '1'";
				
				$this->newtable->search(array(array("A.NAMA_SAMPEL","Nama Sampel"),array("dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL)","Kode Sampel"),array("A.TEMPAT_SAMPLING","Tempat Sampling"),array("dbo.KATEGORI(A.KOMODITI,A.PRIORITAS)","Komoditi"),array("dbo.KATEGORI(A.KATEGORI,A.PRIORITAS)","Kategori"),array("C.NAMA_BBPOM","Balai Pengirim")));
				
				$this->newtable->columns(array("A.KODE_SAMPEL", array("A.NAMA_SAMPEL + '<div>' + dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) + '</div><div>' + A.BENTUK_SEDIAAN + '</div><div>' + A.PABRIK + '</div><div>' + A.NOMOR_REGISTRASI + ', No Batch  : ' +  A.NO_BETS + '</div><div>'+A.TEMPAT_SAMPLING+'</div>'",site_url()."/home/rujukan/preview/sampel/{KODE_SAMPEL}"),"CAST(A.JUMLAH_SAMPEL AS VARCHAR) +'&nbsp;'+ A.SATUAN +'<div>&bull;&nbsp;Uji Kimia : '+ CAST(A.JUMLAH_KIMIA AS VARCHAR)+'</div><div>&bull;&nbsp;Uji Mikro : '+CAST(A.JUMLAH_MIKRO AS VARCHAR) +'</div><div>&bull;&nbsp;Sisa Sampel : '+CAST(A.SISA AS VARCHAR) +'</div><div>' +CASE WHEN A.UJI_KIMIA = '1' AND A.UJI_MIKRO = '1' THEN 'Uji Kimia - Mikro' WHEN A.UJI_KIMIA = '1' THEN 'Uji Kimia' WHEN A.UJI_MIKRO = '1' THEN 'Uji Mikro' END+ '</div>'", "dbo.KATEGORI(A.KOMODITI,A.PRIORITAS) + '<div>' + dbo.KATEGORI(A.KATEGORI,A.PRIORITAS) + '</div>'","'<div>Hasil Uji Kimia : ' + A.HASIL_KIMIA + '</div><div>A.Hasil Uji Mikro : ' + A.HASIL_MIKRO + '</div><div>Hasil : ' + A.HASIL_SAMPEL + '</div>'","REPLACE(REPLACE(C.NAMA_BBPOM, 'BALAI POM DI ', ''), 'BALAI BESAR POM DI ','')"," CONVERT(VARCHAR(10), A.UPDATE_DATE, 120)"));
				$this->newtable->orderby(7);
				$this->newtable->sortby("DESC");
				$this->newtable->width(array('IDENTITAS SAMPEL' => 225, 'JUMLAH UJI' => 85, 'KOMODITI' => 75, 'HASIL' => 105, 'BALAI PENGIRIM' => 100));
				//$proses['Preview Data'] = array('POST', site_url().'/post/rujukan/kirim_act/rujuk/ajax', 'N');
			}
			$this->newtable->action(site_url()."/home/rujukan/sampel/".$status);
			$this->newtable->hiddens(array('KODE_SAMPEL','UPDATE_DATE'));
			$this->newtable->cidb($this->db);
			$this->newtable->ciuri($this->uri->segment_array());
			$this->newtable->keys(array('KODE_SAMPEL'));
			$proses['Preview Data'] = array('GET', site_url().'/home/rujukan/preview/sampel', '1');
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
			$this->load->model('main','main',TRUE);
			$arrdata = array();
			$arrdata['sampel'] = $this->db->query("SELECT A.PERIKSA_SAMPEL, A.KODE_SAMPEL, A.SPU_ID, dbo.FORMAT_NOMOR('SPL', A.KODE_SAMPEL) AS UR_KODESAMPEL, A.KOMODITI, dbo.KATEGORI(A.KOMODITI,A.PRIORITAS) AS UR_KOMODITI, dbo.KATEGORI(A.KATEGORI,A.PRIORITAS) AS UR_KATEGORI, A.KATEGORI, dbo.URAIAN_M_TABEL('SUB_TUJUAN', A.SUB_TUJUAN) AS SUB_TUJUAN, dbo.URAIAN_M_TABEL('ASAL_SAMPLING',A.ASAL_SAMPEL) AS ASAL_SAMPEL, dbo.URAIAN_M_TABEL('TUJUAN_SAMPLING',A.TUJUAN_SAMPLING) AS TUJUAN_SAMPLING, A.KLASIFIKASI_TAMBAHAN,A.NAMA_SAMPEL,A.NOMOR_REGISTRASI,A.PABRIK,IMPORTIR,A.BENTUK_SEDIAAN,A.KEMASAN,A.NO_BETS,A.KETERANGAN_ED,A.JUMLAH_SAMPEL,A.SATUAN,A.HARGA_SAMPEL,A.UJI_KIMIA,A.JUMLAH_KIMIA,A.UJI_MIKRO,A.JUMLAH_MIKRO,A.SISA,REPLACE(A.KOMPOSISI,';','<br>') AS KOMPOSISI,A.NETTO,A.KONDISI_SAMPEL,A.EVALUASI_PENANDAAN,A.CARA_PENYIMPANAN, A.LABEL, A.SEGEL,A.CATATAN,A.STATUS_KIMIA,A.STATUS_MIKRO,A.STATUS_SAMPEL,A.LAMPIRAN, A.PRIORITAS, B.BBPOM_ID, dbo.FORMAT_NOMOR('SP', C.NOMOR_SP) AS UR_SPP, CONVERT(VARCHAR(10), C.TANGGAL, 103) AS TGL_SPP, A.PRIORITAS FROM T_M_SAMPEL A LEFT JOIN T_PERIKSA_SAMPEL B ON A.PERIKSA_SAMPEL = B.PERIKSA_SAMPEL LEFT JOIN T_SPU C ON A.SPU_ID = C.SPU_ID WHERE A.KODE_SAMPEL = '".$id."'")->result_array();
			$arrdata['capafile'] = $this->db->query("SELECT CAPA_FILE FROM T_SAMPEL_RUJUKAN_CAPA WHERE KODE_SAMPEL = '".$id."'")->result_array();
			$query = "SELECT CASE WHEN A.JENIS_UJI = '01' THEN 'Mikrobiologi' WHEN A.JENIS_UJI = '02' THEN 'Kimia-Fisika' END AS BIDANG_UJI, A.PARAMETER_UJI, A.METODE, A.PUSTAKA, A.SYARAT, B.URAIAN AS LINGKUP_UJI, REPLACE(REPLACE(C.NAMA_BBPOM, 'BALAI POM DI ', ''), 'BALAI BESAR POM DI ','') AS [BALAI_TUJUAN], A.LCP, A.JUMLAH_SAMPEL FROM T_SAMPEL_RUJUKAN_DETIL A LEFT JOIN M_LINGKUP_RUJUKAN B ON A.LINGKUP_UJI = B.ID LEFT JOIN M_BBPOM C ON A.BBPOM_ID = C.BBPOM_ID WHERE A.KODE_SAMPEL = '".$id."'";
			$data = $sipt->main->get_result($query);
			if($data){
				foreach($query->result_array() as $row){
					$arrdata['data'][] = $row;
				}
				$arrdata['act'] = site_url() . '/post/rujukan/set_rujukan/proses/';

			}
			if($arrdata['sampel'][0]['STATUS_SAMPEL'] == '80215'){
				$status = '80215';
				$arrdata['KODE_RUJUKAN'] = $sipt->main->get_uraian("SELECT KODE_SAMPEL FROM T_M_SAMPEL WHERE KODE_RUJUKAN = '".$id."'","KODE_SAMPEL");
			}else if($arrdata['sampel'][0]['STATUS_SAMPEL'] == '70011'){
				$status = '70011';
			}else{
				$status = $sipt->main->get_uraian("SELECT STATUS FROM T_SAMPEL_RUJUKAN WHERE KODE_SAMPEL = '".$id."' AND BBPOM_RUJUK = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","STATUS");
			}

			
			$arrdata['input'] = $this->get_input($id, $status);
			$arrdata['proses'] = $sipt->main->set_verifikasi($status, $this->newsession->userdata('SESS_JENIS_PELAPORAN'), $this->newsession->userdata('SESS_KODE_ROLE'));
			
			$arrdata['disproses'] = $status;
			
			$arrdata['status'] = $status;
			$arrdata['status_sampel'] = $arrdata['sampel'][0]['STATUS_SAMPEL'];
			//print_r($arrdata);die();
			return $arrdata;
		}
	}
	
	function get_input($kode, $status){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){ 
			$sipt =& get_instance();
			$sipt->load->model("main","main", true);
			$data = "";
			$arrdata = array();
			$arrdata['row'] = $this->db->query("SELECT *, CONVERT(VARCHAR(10), TANGGAL_TERIMA, 103) AS TGLTERIMA, CONVERT(VARCHAR(10), TANGGAL_VERIFIKASI, 103) AS TGLVERIFIKASI FROM T_SAMPEL_RUJUKAN WHERE KODE_SAMPEL = '".$kode."' AND BBPOM_RUJUK = '".$this->newsession->userdata('SESS_BBPOM_ID')."'")->result_array();
			$arrstts = array('70011','70012','80011','50204','80215');
			if(in_array($status, $arrstts)){
				if($status == "70012"){ 
					$substr = $sipt->main->get_uraian("SELECT CASE WHEN LEN(LTRIM(RTRIM(KODE_BALAI))) = 2 THEN '0' + KODE_BALAI ELSE KODE_BALAI END AS KODE_BALAI FROM M_BBPOM WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","KODE_BALAI");
					$arrdata['data'] = $this->db->query("SELECT A.UJI_ID, A.JENIS_UJI, CASE WHEN A.JENIS_UJI = '01' THEN 'Mikrobiologi' WHEN A.JENIS_UJI = '02' THEN 'Kimia-Fisika' END AS BIDANG_UJI, A.PARAMETER_UJI, A.METODE, A.PUSTAKA, A.SYARAT, B.URAIAN AS LINGKUP_UJI, REPLACE(REPLACE(C.NAMA_BBPOM, 'BALAI POM DI ', ''), 'BALAI BESAR POM DI ','') AS [BALAI_TUJUAN], dbo.FORMAT_NOMOR('SPL', D.KODE_SAMPEL) AS KODE_SAMPEL_BARU, dbo.FORMAT_NOMOR('SPL',D.KODE_RUJUKAN) AS KODE_SAMPEL_ASAL, D.KODE_SAMPEL FROM T_SAMPEL_RUJUKAN_DETIL A LEFT JOIN M_LINGKUP_RUJUKAN B ON A.LINGKUP_UJI = B.ID LEFT JOIN M_BBPOM C ON A.BBPOM_ID = C.BBPOM_ID LEFT JOIN T_M_SAMPEL D ON A.KODE_SAMPEL = D.KODE_RUJUKAN WHERE A.KODE_SAMPEL = '".$kode."' AND A.BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND SUBSTRING(D.KODE_SAMPEL,3,3) = '".$substr."'")->result_array();
					$chkuji = $this->db->query("SELECT A.UJI_KIMIA, A.UJI_MIKRO, A.KOMODITI FROM T_M_SAMPEL A LEFT JOIN T_SAMPEL_RUJUKAN B ON A.KODE_RUJUKAN = B.KODE_SAMPEL WHERE A.KODE_RUJUKAN = '".$kode."' AND B.BBPOM_RUJUK = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND SUBSTRING(A.KODE_SAMPEL,3,3) = '".$substr."'")->result_array();
					if($chkuji[0]['UJI_KIMIA'] == 1 && $chkuji[0]['UJI_MIKRO'] == 1){#Diuji Kimia dan Mikro
						$arrdata['mt'] = $sipt->main->combobox("SELECT A.USER_ID, A.NAMA_USER + ' - ' + A.JABATAN AS NAMA FROM T_USER A  WHERE A.USER_ID IN (SELECT USER_ID FROM T_USER_ROLE WHERE ROLE = '4' AND LEFT(SARANA_MEDIA_ID,2) IN ('B1','B2','B3') GROUP BY USER_ID) AND A.BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND A.STATUS = 'Aktif' ORDER BY 2 ASC", "USER_ID", "NAMA", TRUE);
					}else if($chkuji[0]['UJI_KIMIA'] == 1 && $chkuji[0]['UJI_MIKRO'] == 0){#Diuji Kimia
						$arrdata['mt'] = $sipt->main->combobox("SELECT A.USER_ID, A.NAMA_USER + ' - ' + A.JABATAN AS NAMA FROM T_USER A  WHERE A.USER_ID IN (SELECT USER_ID FROM T_USER_ROLE WHERE ROLE = '4' AND LEFT(SARANA_MEDIA_ID,2) IN ('B1','B2') GROUP BY USER_ID) AND A.BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND A.STATUS = 'Aktif' ORDER BY 2 ASC", "USER_ID", "NAMA", TRUE);
					}else if($chkuji[0]['UJI_KIMIA'] == 0 && $chkuji[0]['UJI_MIKRO'] == 1){#Diuji Mikro
						$arrdata['mt'] = $sipt->main->combobox("SELECT A.USER_ID, A.NAMA_USER + ' - ' + A.JABATAN AS NAMA FROM T_USER A  WHERE A.USER_ID IN (SELECT USER_ID FROM T_USER_ROLE WHERE ROLE = '4' AND LEFT(SARANA_MEDIA_ID,2) IN ('B3') GROUP BY USER_ID) AND A.BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND A.STATUS = 'Aktif' ORDER BY 2 ASC", "USER_ID", "NAMA", TRUE);
					}
					$arrdata['newkode'] = $sipt->main->get_uraian("SELECT B.KODE_SAMPEL
FROM T_SAMPEL_RUJUKAN A LEFT JOIN T_M_SAMPEL B ON A.KODE_SAMPEL = B.KODE_RUJUKAN
WHERE A.BBPOM_RUJUK = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND A.KODE_SAMPEL = '".$kode."' GROUP BY B.KODE_SAMPEL
","KODE_SAMPEL");
					$sql_jumlah_sampel = "SELECT JUMLAH_SAMPEL FROM T_SAMPEL_RUJUKAN_DETIL WHERE KODE_SAMPEL = '".$kode."'";
					$obj_jumlah_sampel = $sipt->main->get_result($sql_jumlah_sampel);
					if($obj_jumlah_sampel){
						$ijml_sampel = 0;
						foreach($sql_jumlah_sampel->result_array() as $row_jumlah_sampel)
						{
							$ijml_sampel = $ijml_sampel + $row_jumlah_sampel['JUMLAH_SAMPEL'];
						}
						$arrdata['jml_sampel'] = $ijml_sampel;
					}
				}else if($status == "50204" || $status == "80215"){
					if($status == "50204"){
						$substr = $sipt->main->get_uraian("SELECT CASE WHEN LEN(LTRIM(RTRIM(KODE_BALAI))) = 2 THEN '0' + KODE_BALAI ELSE KODE_BALAI END AS KODE_BALAI FROM M_BBPOM WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","KODE_BALAI");
						$kode_sampel = $sipt->main->get_uraian("SELECT KODE_SAMPEL FROM T_M_SAMPEL WHERE KODE_RUJUKAN = '".$kode."' AND SUBSTRING(KODE_SAMPEL,3,3) = '".$substr."'","KODE_SAMPEL"); 
						$arrdata['dtrujukan'] = $this->db->query("SELECT CATATAN FROM T_SAMPEL_RUJUKAN WHERE KODE_SAMPEL = '".$kode_sampel."' AND BBPOM_RUJUK = '".$this->newsession->userdata('SESS_BBPOM_ID')."'")->result_array();
						$arrdata['parameter'] = $this->db->query("SELECT KODE_SAMPEL, CASE WHEN JENIS_UJI = '01' THEN 'Mikrobiologi' WHEN JENIS_UJI = '02' THEN 'Kimia - Fisika' END AS JENIS_UJI, SPK_ID,PARAMETER_UJI, METODE, PUSTAKA, SYARAT, RUANG_LINGKUP, HASIL, HASIL_KUALITATIF, LCP, HASIL_PARAMETER FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL = '".$kode_sampel."'")->result_array();
					}else{
						$qkode = "SELECT KODE_SAMPEL FROM T_M_SAMPEL WHERE KODE_RUJUKAN = '".$kode."'";
						$dkode = $sipt->main->get_result($qkode);
						if($dkode){
							$arrkode = array();
							foreach($qkode->result_array() as $rkode){
								$arrkode[] = $rkode['KODE_SAMPEL'];
							}
							$inkode = "'".join("','", $arrkode)."'";
							$arrdata['parameter'] = $this->db->query("SELECT KODE_SAMPEL, CASE WHEN JENIS_UJI = '01' THEN 'Mikrobiologi' WHEN JENIS_UJI = '02' THEN 'Kimia - Fisika' END AS JENIS_UJI, SPK_ID,PARAMETER_UJI, METODE, PUSTAKA, SYARAT, RUANG_LINGKUP, HASIL, HASIL_KUALITATIF, LCP, HASIL_PARAMETER FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL IN (".$inkode.")")->result_array();
						}
					}
				}
				$data = $this->load->view('pengujian/rujukan/input/'.$status, $arrdata, true);
			}else{
				$data = "";
			}
		}
		return $data;
	}
}	
?>