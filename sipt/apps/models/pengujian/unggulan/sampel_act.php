 <?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR);
class Sampel_act extends Model{
	
	function list_unggulan($status){

		if((in_array('5', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('7', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('8', $this->newsession->userdata('SESS_KODE_ROLE'))) && $this->newsession->userdata('LOGGED_IN') ==  TRUE){

			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$this->load->library('newtable');
			if($status == "draft"){
				$judul = "Draft Penerimaan Sampel Unggulan";
				 $query = "SELECT A.KODE_SAMPEL, A.NAMA_SAMPEL + '<div>' + dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) + '</div><div>' + A.BENTUK_SEDIAAN + '</div><div>' + A.PABRIK + '</div><div>' + A.NOMOR_REGISTRASI + ', No Batch  : ' +  A.NO_BETS + '</div><div>'+A.TEMPAT_SAMPLING+'</div>' AS [IDENTITAS SAMPEL], dbo.KATEGORI(A.KOMODITI,A.PRIORITAS) + '<div>' + dbo.KATEGORI(A.KATEGORI,A.PRIORITAS) + '</div>' AS KOMODITI, CASE WHEN A.UJI_KIMIA = '1' AND A.UJI_MIKRO = '1' THEN 'Uji Kimia - Mikro' WHEN A.UJI_KIMIA = '1' THEN 'Uji Kimia' WHEN A.UJI_MIKRO = '1' THEN 'Uji Mikro' END +'<div> K : ' + CAST(CASE WHEN A.JUMLAH_KIMIA <> 0 THEN CAST(A.JUMLAH_KIMIA AS VARCHAR) ELSE '-' END + ', M : ' + CASE WHEN A.JUMLAH_MIKRO <> 0 THEN CAST(A.JUMLAH_MIKRO AS VARCHAR) ELSE '-' END AS VARCHAR)+ '</div>' AS [JENIS UJI] FROM T_M_SAMPEL A LEFT JOIN T_SAMPEL_UNGGULAN_TMP B ON A.KODE_SAMPEL = B.KODE_SAMPEL WHERE B.BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND B.STATUS = '70020' AND A.UJI_UNGGULAN = '1'";
				$this->newtable->search(array(array("A.NAMA_SAMPEL","Nama Sampel"),array("dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL)","Kode Sampel"),array("dbo.KATEGORI(A.KOMODITI,A.PRIORITAS)","Komoditi")));				
				$this->newtable->columns(array("A.KODE_SAMPEL", array("A.NAMA_SAMPEL + '<div>' + dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) + '</div><div>' + A.BENTUK_SEDIAAN + '</div><div>' + A.PABRIK + '</div><div>' + A.NOMOR_REGISTRASI + ', No Batch  : ' +  A.NO_BETS + '</div><div>'+A.TEMPAT_SAMPLING+'</div>'",site_url()."/home/unggulan/preview/sampel/{KODE_SAMPEL}"),"dbo.KATEGORI(A.KOMODITI,A.PRIORITAS) + '<div>' + dbo.KATEGORI(A.KATEGORI,A.PRIORITAS) + '</div>'", "CASE WHEN A.UJI_KIMIA = '1' AND A.UJI_MIKRO = '1' THEN 'Uji Kimia - Mikro' WHEN A.UJI_KIMIA = '1' THEN 'Uji Kimia' WHEN A.UJI_MIKRO = '1' THEN 'Uji Mikro' END +'<div> K : ' + CAST(CASE WHEN A.JUMLAH_KIMIA <> 0 THEN CAST(A.JUMLAH_KIMIA AS VARCHAR) ELSE '-' END + ', M : ' + CASE WHEN A.JUMLAH_MIKRO <> 0 THEN CAST(A.JUMLAH_MIKRO AS VARCHAR) ELSE '-' END AS VARCHAR)+ '</div>'"));
				$this->newtable->orderby(2);
				$this->newtable->sortby("DESC");
				$this->newtable->width(array('IDENTITAS SAMPEL' => 200, 'KOMODITI' => 75,  'KATEGORI' => 250, 'JENIS UJI' => 75));
				//$proses['Preview Data'] = array('POST', site_url().'/post/rujukan/kirim_act/rujuk/ajax', 'N');
			}
			else if($status == "receive"){
				$judul = "Verifikasi Penerimaan Sampel Unggulan";
				$query = "SELECT A.KODE_SAMPEL, A.NAMA_SAMPEL + '<div>' + dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) + '</div><div>' + A.BENTUK_SEDIAAN + '</div><div>' + A.PABRIK + '</div><div>' + A.NOMOR_REGISTRASI + ', No Batch  : ' +  A.NO_BETS + '</div><div>'+A.TEMPAT_SAMPLING+'</div>' AS [IDENTITAS SAMPEL], CAST(A.JUMLAH_SAMPEL AS VARCHAR) +'&nbsp;'+ A.SATUAN +'<div>&bull;&nbsp;Uji Kimia : '+ CAST(A.JUMLAH_KIMIA AS VARCHAR)+'</div><div>&bull;&nbsp;Uji Mikro : '+CAST(A.JUMLAH_MIKRO AS VARCHAR) +'</div><div>&bull;&nbsp;Sisa Sampel : '+CAST(A.SISA AS VARCHAR) +'</div><div>' +CASE WHEN A.UJI_KIMIA = '1' AND A.UJI_MIKRO = '1' THEN 'Uji Kimia - Mikro' WHEN A.UJI_KIMIA = '1' THEN 'Uji Kimia' WHEN A.UJI_MIKRO = '1' THEN 'Uji Mikro' END+ '</div>' AS [JUMLAH UJI], dbo.KATEGORI(A.KOMODITI,A.PRIORITAS) + '<div>' + dbo.KATEGORI(A.KATEGORI,A.PRIORITAS) + '</div>' AS KOMODITI, '<div>Hasil Uji Kimia : ' + A.HASIL_KIMIA + '</div><div>Hasil Uji Mikro : ' + A.HASIL_MIKRO + '</div><div>Hasil Sampel : ' + A.HASIL_SAMPEL + '</div>' AS HASIL, REPLACE(REPLACE(C.NAMA_BBPOM, 'BALAI POM DI ', ''), 'BALAI BESAR POM DI ','') AS [BALAI PENGIRIM], CONVERT(VARCHAR(10), A.UPDATE_DATE, 120) AS [UPDATE DATE]
				FROM T_M_SAMPEL A 
				LEFT JOIN T_SAMPEL_UNGGULAN B ON A.KODE_SAMPEL = B.KODE_SAMPEL
				LEFT JOIN M_BBPOM C ON B.BBPOM_ASAL = C.BBPOM_ID
				WHERE B.BBPOM_UNGGULAN = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND B.STATUS = '70021' AND A.UJI_UNGGULAN = '1' AND B.STATUS_UNGGULAN = 1";
				
				$this->newtable->search(array(array("A.NAMA_SAMPEL","Nama Sampel"),array("dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL)","Kode Sampel"),array("A.TEMPAT_SAMPLING","Tempat Sampling"),array("dbo.KATEGORI(A.KOMODITI,A.PRIORITAS)","Komoditi"),array("dbo.KATEGORI(A.KATEGORI,A.PRIORITAS)","Kategori"),array("C.NAMA_BBPOM","Balai Pengirim")));
				
				$this->newtable->columns(array("A.KODE_SAMPEL", array("A.NAMA_SAMPEL + '<div>' + dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) + '</div><div>' + A.BENTUK_SEDIAAN + '</div><div>' + A.PABRIK + '</div><div>' + A.NOMOR_REGISTRASI + ', No Batch  : ' +  A.NO_BETS + '</div><div>'+A.TEMPAT_SAMPLING+'</div>'",site_url()."/home/unggulan/preview/sampel/{KODE_SAMPEL}"),"CAST(A.JUMLAH_SAMPEL AS VARCHAR) +'&nbsp;'+ A.SATUAN +'<div>&bull;&nbsp;Uji Kimia : '+ CAST(A.JUMLAH_KIMIA AS VARCHAR)+'</div><div>&bull;&nbsp;Uji Mikro : '+CAST(A.JUMLAH_MIKRO AS VARCHAR) +'</div><div>&bull;&nbsp;Sisa Sampel : '+CAST(A.SISA AS VARCHAR) +'</div><div>' +CASE WHEN A.UJI_KIMIA = '1' AND A.UJI_MIKRO = '1' THEN 'Uji Kimia - Mikro' WHEN A.UJI_KIMIA = '1' THEN 'Uji Kimia' WHEN A.UJI_MIKRO = '1' THEN 'Uji Mikro' END+ '</div>'", "dbo.KATEGORI(A.KOMODITI,A.PRIORITAS) + '<div>' + dbo.KATEGORI(A.KATEGORI,A.PRIORITAS) + '</div>'","'<div>Hasil Uji Kimia : ' + A.HASIL_KIMIA + '</div><div>A.Hasil Uji Mikro : ' + A.HASIL_MIKRO + '</div><div>Hasil : ' + A.HASIL_SAMPEL + '</div>'","REPLACE(REPLACE(C.NAMA_BBPOM, 'BALAI POM DI ', ''), 'BALAI BESAR POM DI ','')"," CONVERT(VARCHAR(10), A.UPDATE_DATE, 120)"));
				$this->newtable->orderby(7);
				$this->newtable->sortby("DESC");
				$this->newtable->width(array('IDENTITAS SAMPEL' => 225, 'JUMLAH UJI' => 85, 'KOMODITI' => 75, 'HASIL' => 105, 'BALAI PENGIRIM' => 100, 'UPDATE DATE' => 75));
				//$proses['Preview Data'] = array('POST', site_url().'/post/rujukan/kirim_act/rujuk/ajax', 'N');
			}
			else if($status == "deliver"){
				$judul = "Data Penyerahan Sampel Ke Bidang ";
				$query = "SELECT A.KODE_SAMPEL, A.NAMA_SAMPEL + '<div>' + dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) + '</div><div>' + A.BENTUK_SEDIAAN + '</div><div>' + A.PABRIK + '</div><div>' + A.NOMOR_REGISTRASI + ', No Batch  : ' +  A.NO_BETS + '</div><div>'+A.TEMPAT_SAMPLING+'</div>' AS [IDENTITAS SAMPEL], CAST(A.JUMLAH_SAMPEL AS VARCHAR) +'&nbsp;'+ A.SATUAN +'<div>&bull;&nbsp;Uji Kimia : '+ CAST(A.JUMLAH_KIMIA AS VARCHAR)+'</div><div>&bull;&nbsp;Uji Mikro : '+CAST(A.JUMLAH_MIKRO AS VARCHAR) +'</div><div>&bull;&nbsp;Sisa Sampel : '+CAST(A.SISA AS VARCHAR) +'</div><div>' +CASE WHEN A.UJI_KIMIA = '1' AND A.UJI_MIKRO = '1' THEN 'Uji Kimia - Mikro' WHEN A.UJI_KIMIA = '1' THEN 'Uji Kimia' WHEN A.UJI_MIKRO = '1' THEN 'Uji Mikro' END+ '</div>' AS [JUMLAH UJI], dbo.KATEGORI(A.KOMODITI,A.PRIORITAS) + '<div>' + dbo.KATEGORI(A.KATEGORI,A.PRIORITAS) + '</div>' AS KOMODITI, '<div>Hasil Uji Kimia : ' + A.HASIL_KIMIA + '</div><div>Hasil Uji Mikro : ' + A.HASIL_MIKRO + '</div><div>Hasil Sampel : ' + A.HASIL_SAMPEL + '</div>' AS HASIL, REPLACE(REPLACE(C.NAMA_BBPOM, 'BALAI POM DI ', ''), 'BALAI BESAR POM DI ','') AS [BALAI PENGIRIM], CONVERT(VARCHAR(10), A.UPDATE_DATE, 120) AS [UPDATE DATE] 
				FROM T_M_SAMPEL A 
				LEFT JOIN T_SAMPEL_UNGGULAN B ON A.KODE_SAMPEL = B.KODE_SAMPEL
				LEFT JOIN M_BBPOM C ON B.BBPOM_ASAL = C.BBPOM_ID
				WHERE B.BBPOM_UNGGULAN = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND B.STATUS = '70022' AND A.UJI_UNGGULAN = '1' AND B.STATUS_UNGGULAN = 1";
				
				$this->newtable->search(array(array("A.NAMA_SAMPEL","Nama Sampel"),array("dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL)","Kode Sampel"),array("A.TEMPAT_SAMPLING","Tempat Sampling"),array("dbo.KATEGORI(A.KOMODITI,A.PRIORITAS)","Komoditi"),array("dbo.KATEGORI(A.KATEGORI,A.PRIORITAS)","Kategori"),array("C.NAMA_BBPOM","Balai Pengirim")));
				
				$this->newtable->columns(array("A.KODE_SAMPEL", array("A.NAMA_SAMPEL + '<div>' + dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) + '</div><div>' + A.BENTUK_SEDIAAN + '</div><div>' + A.PABRIK + '</div><div>' + A.NOMOR_REGISTRASI + ', No Batch  : ' +  A.NO_BETS + '</div><div>'+A.TEMPAT_SAMPLING+'</div>'",site_url()."/home/unggulan/preview/sampel/{KODE_SAMPEL}"),"CAST(A.JUMLAH_SAMPEL AS VARCHAR) +'&nbsp;'+ A.SATUAN +'<div>&bull;&nbsp;Uji Kimia : '+ CAST(A.JUMLAH_KIMIA AS VARCHAR)+'</div><div>&bull;&nbsp;Uji Mikro : '+CAST(A.JUMLAH_MIKRO AS VARCHAR) +'</div><div>&bull;&nbsp;Sisa Sampel : '+CAST(A.SISA AS VARCHAR) +'</div><div>' +CASE WHEN A.UJI_KIMIA = '1' AND A.UJI_MIKRO = '1' THEN 'Uji Kimia - Mikro' WHEN A.UJI_KIMIA = '1' THEN 'Uji Kimia' WHEN A.UJI_MIKRO = '1' THEN 'Uji Mikro' END+ '</div>'", "dbo.KATEGORI(A.KOMODITI,A.PRIORITAS) + '<div>' + dbo.KATEGORI(A.KATEGORI,A.PRIORITAS) + '</div>'","'<div>Hasil Uji Kimia : ' + A.HASIL_KIMIA + '</div><div>A.Hasil Uji Mikro : ' + A.HASIL_MIKRO + '</div><div>Hasil : ' + A.HASIL_SAMPEL + '</div>'","REPLACE(REPLACE(C.NAMA_BBPOM, 'BALAI POM DI ', ''), 'BALAI BESAR POM DI ','')"," CONVERT(VARCHAR(10), A.UPDATE_DATE, 120)"));
				$this->newtable->orderby(7);
				$this->newtable->sortby("DESC");
				$this->newtable->width(array('IDENTITAS SAMPEL' => 225, 'JUMLAH UJI' => 85, 'KOMODITI' => 75, 'HASIL' => 105, 'BALAI PENGIRIM' => 100, 'UPDATE DATE' => 75));
				//$proses['Preview Data'] = array('POST', site_url().'/post/rujukan/kirim_act/rujuk/ajax', 'N');
			}
			else if($status == "verifikasi"){
				$judul = "Verifikasi Penerimaan Sampel Unggulan";
				$query = "SELECT A.KODE_SAMPEL, A.NAMA_SAMPEL + '<div>' + dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) + '</div><div>' + A.BENTUK_SEDIAAN + '</div><div>' + A.PABRIK + '</div><div>' + A.NOMOR_REGISTRASI + ', No Batch  : ' +  A.NO_BETS + '</div><div>'+A.TEMPAT_SAMPLING+'</div>' AS [IDENTITAS SAMPEL], CAST(A.JUMLAH_SAMPEL AS VARCHAR) +'&nbsp;'+ A.SATUAN +'<div>&bull;&nbsp;Uji Kimia : '+ CAST(A.JUMLAH_KIMIA AS VARCHAR)+'</div><div>&bull;&nbsp;Uji Mikro : '+CAST(A.JUMLAH_MIKRO AS VARCHAR) +'</div><div>&bull;&nbsp;Sisa Sampel : '+CAST(A.SISA AS VARCHAR) +'</div><div>' +CASE WHEN A.UJI_KIMIA = '1' AND A.UJI_MIKRO = '1' THEN 'Uji Kimia - Mikro' WHEN A.UJI_KIMIA = '1' THEN 'Uji Kimia' WHEN A.UJI_MIKRO = '1' THEN 'Uji Mikro' END+ '</div>' AS [JUMLAH UJI], dbo.KATEGORI(A.KOMODITI,A.PRIORITAS) + '<div>' + dbo.KATEGORI(A.KATEGORI,A.PRIORITAS) + '</div>' AS KOMODITI, '<div>Hasil Uji Kimia : ' + A.HASIL_KIMIA + '</div><div>Hasil Uji Mikro : ' + A.HASIL_MIKRO + '</div><div>Hasil Sampel : ' + A.HASIL_SAMPEL + '</div>' AS HASIL, REPLACE(REPLACE(C.NAMA_BBPOM, 'BALAI POM DI ', ''), 'BALAI BESAR POM DI ','') AS [BALAI PENGIRIM], CONVERT(VARCHAR(10), A.UPDATE_DATE, 120) AS [UPDATE DATE] 
				FROM T_M_SAMPEL A 
				LEFT JOIN T_SAMPEL_UNGGULAN B ON A.KODE_SAMPEL = B.KODE_SAMPEL
				LEFT JOIN M_BBPOM C ON B.BBPOM_ASAL = C.BBPOM_ID
				WHERE B.BBPOM_UNGGULAN = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND B.STATUS = '80021' AND A.UJI_UNGGULAN = '1' AND B.STATUS_UNGGULAN = 1";
				
				$this->newtable->search(array(array("A.NAMA_SAMPEL","Nama Sampel"),array("dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL)","Kode Sampel"),array("A.TEMPAT_SAMPLING","Tempat Sampling"),array("dbo.KATEGORI(A.KOMODITI,A.PRIORITAS)","Komoditi"),array("dbo.KATEGORI(A.KATEGORI,A.PRIORITAS)","Kategori"),array("C.NAMA_BBPOM","Balai Pengirim")));
				
				$this->newtable->columns(array("A.KODE_SAMPEL", array("A.NAMA_SAMPEL + '<div>' + dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) + '</div><div>' + A.BENTUK_SEDIAAN + '</div><div>' + A.PABRIK + '</div><div>' + A.NOMOR_REGISTRASI + ', No Batch  : ' +  A.NO_BETS + '</div><div>'+A.TEMPAT_SAMPLING+'</div>'",site_url()."/home/unggulan/preview/sampel/{KODE_SAMPEL}"),"CAST(A.JUMLAH_SAMPEL AS VARCHAR) +'&nbsp;'+ A.SATUAN +'<div>&bull;&nbsp;Uji Kimia : '+ CAST(A.JUMLAH_KIMIA AS VARCHAR)+'</div><div>&bull;&nbsp;Uji Mikro : '+CAST(A.JUMLAH_MIKRO AS VARCHAR) +'</div><div>&bull;&nbsp;Sisa Sampel : '+CAST(A.SISA AS VARCHAR) +'</div><div>' +CASE WHEN A.UJI_KIMIA = '1' AND A.UJI_MIKRO = '1' THEN 'Uji Kimia - Mikro' WHEN A.UJI_KIMIA = '1' THEN 'Uji Kimia' WHEN A.UJI_MIKRO = '1' THEN 'Uji Mikro' END+ '</div>'", "dbo.KATEGORI(A.KOMODITI,A.PRIORITAS) + '<div>' + dbo.KATEGORI(A.KATEGORI,A.PRIORITAS) + '</div>'","'<div>Hasil Uji Kimia : ' + A.HASIL_KIMIA + '</div><div>A.Hasil Uji Mikro : ' + A.HASIL_MIKRO + '</div><div>Hasil : ' + A.HASIL_SAMPEL + '</div>'","REPLACE(REPLACE(C.NAMA_BBPOM, 'BALAI POM DI ', ''), 'BALAI BESAR POM DI ','')"," CONVERT(VARCHAR(10), A.UPDATE_DATE, 120)"));
				$this->newtable->orderby(7);
				$this->newtable->sortby("DESC");
				$this->newtable->width(array('IDENTITAS SAMPEL' => 225, 'JUMLAH UJI' => 85, 'KOMODITI' => 75, 'HASIL' => 105, 'BALAI PENGIRIM' => 100, 'UPDATE DATE' => 75));
			}
			else if($status == "done"){
				$judul = "Data Sampel Unggulan Selesai ";
				$query = "SELECT A.KODE_SAMPEL, A.NAMA_SAMPEL + '<div>' + dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) + '</div><div>' + A.BENTUK_SEDIAAN + '</div><div>' + A.PABRIK + '</div><div>' + A.NOMOR_REGISTRASI + ', No Batch  : ' +  A.NO_BETS + '</div><div>'+A.TEMPAT_SAMPLING+'</div>' AS [IDENTITAS SAMPEL], CAST(A.JUMLAH_SAMPEL AS VARCHAR) +'&nbsp;'+ A.SATUAN +'<div>&bull;&nbsp;Uji Kimia : '+ CAST(A.JUMLAH_KIMIA AS VARCHAR)+'</div><div>&bull;&nbsp;Uji Mikro : '+CAST(A.JUMLAH_MIKRO AS VARCHAR) +'</div><div>&bull;&nbsp;Sisa Sampel : '+CAST(A.SISA AS VARCHAR) +'</div><div>' +CASE WHEN A.UJI_KIMIA = '1' AND A.UJI_MIKRO = '1' THEN 'Uji Kimia - Mikro' WHEN A.UJI_KIMIA = '1' THEN 'Uji Kimia' WHEN A.UJI_MIKRO = '1' THEN 'Uji Mikro' END+ '</div>' AS [JUMLAH UJI], dbo.KATEGORI(A.KOMODITI,A.PRIORITAS) + '<div>' + dbo.KATEGORI(A.KATEGORI,A.PRIORITAS) + '</div>' AS KOMODITI, '<div>Hasil Uji Kimia : ' + A.HASIL_KIMIA + '</div><div>Hasil Uji Mikro : ' + A.HASIL_MIKRO + '</div><div>Hasil Sampel : ' + A.HASIL_SAMPEL + '</div>' AS HASIL, REPLACE(REPLACE(C.NAMA_BBPOM, 'BALAI POM DI ', ''), 'BALAI BESAR POM DI ','') AS [BALAI PENGIRIM], CONVERT(VARCHAR(10), A.UPDATE_DATE, 120) AS UPDATE_DATE 
				FROM T_M_SAMPEL A 
				LEFT JOIN T_SAMPEL_UNGGULAN B ON A.KODE_UNGGULAN = B.KODE_SAMPEL
				LEFT JOIN M_BBPOM C ON B.BBPOM_ASAL = C.BBPOM_ID
				WHERE B.BBPOM_UNGGULAN = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND B.STATUS = '50206' AND B.STATUS_UNGGULAN = 2";
				
				$this->newtable->search(array(array("A.NAMA_SAMPEL","Nama Sampel"),array("dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL)","Kode Sampel"),array("A.TEMPAT_SAMPLING","Tempat Sampling"),array("dbo.KATEGORI(A.KOMODITI,A.PRIORITAS)","Komoditi"),array("dbo.KATEGORI(A.KATEGORI,A.PRIORITAS)","Kategori"),array("C.NAMA_BBPOM","Balai Pengirim")));
				
				$this->newtable->columns(array("A.KODE_SAMPEL", array("A.NAMA_SAMPEL + '<div>' + dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) + '</div><div>' + A.BENTUK_SEDIAAN + '</div><div>' + A.PABRIK + '</div><div>' + A.NOMOR_REGISTRASI + ', No Batch  : ' +  A.NO_BETS + '</div><div>'+A.TEMPAT_SAMPLING+'</div>'",site_url()."/home/unggulan/preview/sampel/{KODE_SAMPEL}"),"CAST(A.JUMLAH_SAMPEL AS VARCHAR) +'&nbsp;'+ A.SATUAN +'<div>&bull;&nbsp;Uji Kimia : '+ CAST(A.JUMLAH_KIMIA AS VARCHAR)+'</div><div>&bull;&nbsp;Uji Mikro : '+CAST(A.JUMLAH_MIKRO AS VARCHAR) +'</div><div>&bull;&nbsp;Sisa Sampel : '+CAST(A.SISA AS VARCHAR) +'</div><div>' +CASE WHEN A.UJI_KIMIA = '1' AND A.UJI_MIKRO = '1' THEN 'Uji Kimia - Mikro' WHEN A.UJI_KIMIA = '1' THEN 'Uji Kimia' WHEN A.UJI_MIKRO = '1' THEN 'Uji Mikro' END+ '</div>'", "dbo.KATEGORI(A.KOMODITI,A.PRIORITAS) + '<div>' + dbo.KATEGORI(A.KATEGORI,A.PRIORITAS) + '</div>'","'<div>Hasil Uji Kimia : ' + A.HASIL_KIMIA + '</div><div>A.Hasil Uji Mikro : ' + A.HASIL_MIKRO + '</div><div>Hasil : ' + A.HASIL_SAMPEL + '</div>'","REPLACE(REPLACE(C.NAMA_BBPOM, 'BALAI POM DI ', ''), 'BALAI BESAR POM DI ','')"," CONVERT(VARCHAR(10), A.UPDATE_DATE, 120)"));
				$this->newtable->orderby(7);
				$this->newtable->sortby("DESC");
				$this->newtable->width(array('IDENTITAS SAMPEL' => 225, 'JUMLAH UJI' => 85, 'KOMODITI' => 75, 'HASIL' => 105, 'BALAI PENGIRIM' => 100, 'UPDATE_DATE' => 100));
				//$proses['Preview Data'] = array('POST', site_url().'/post/rujukan/kirim_act/rujuk/ajax', 'N');
			}else if($status == "all"){
				$judul = "Data Sampel Terkirim";
				$query = "SELECT A.KODE_SAMPEL, A.NAMA_SAMPEL + '<div>' + dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) + '</div><div>' + A.BENTUK_SEDIAAN + '</div><div>' + A.PABRIK + '</div><div>' + A.NOMOR_REGISTRASI + ', No Batch  : ' +  A.NO_BETS + '</div><div>'+A.TEMPAT_SAMPLING+'</div>' AS [IDENTITAS SAMPEL], CAST(A.JUMLAH_SAMPEL AS VARCHAR) +'&nbsp;'+ A.SATUAN +'<div>&bull;&nbsp;Uji Kimia : '+ CAST(A.JUMLAH_KIMIA AS VARCHAR)+'</div><div>&bull;&nbsp;Uji Mikro : '+CAST(A.JUMLAH_MIKRO AS VARCHAR) +'</div><div>&bull;&nbsp;Sisa Sampel : '+CAST(A.SISA AS VARCHAR) +'</div><div>' +CASE WHEN A.UJI_KIMIA = '1' AND A.UJI_MIKRO = '1' THEN 'Uji Kimia - Mikro' WHEN A.UJI_KIMIA = '1' THEN 'Uji Kimia' WHEN A.UJI_MIKRO = '1' THEN 'Uji Mikro' END+ '</div>' AS [JUMLAH UJI], dbo.KATEGORI(A.KOMODITI,A.PRIORITAS) + '<div>' + dbo.KATEGORI(A.KATEGORI,A.PRIORITAS) + '</div>' AS KOMODITI, '<div>Hasil Uji Kimia : ' + A.HASIL_KIMIA + '</div><div>Hasil Uji Mikro : ' + A.HASIL_MIKRO + '</div><div>Hasil Sampel : ' + A.HASIL_SAMPEL + '</div>' AS HASIL, REPLACE(REPLACE(C.NAMA_BBPOM, 'BALAI POM DI ', ''), 'BALAI BESAR POM DI ','') AS [BALAI PENGIRIM], CONVERT(VARCHAR(10), A.UPDATE_DATE, 120) AS UPDATE_DATE 
				FROM T_M_SAMPEL A 
				LEFT JOIN T_SAMPEL_UNGGULAN B ON A.KODE_SAMPEL = B.KODE_SAMPEL
				LEFT JOIN M_BBPOM C ON B.BBPOM_ASAL = C.BBPOM_ID
				WHERE B.BBPOM_UNGGULAN = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND B.STATUS = '70022' AND A.UJI_UNGGULAN = '1' AND B.STATUS_UNGGULAN = '1'";
				
				$this->newtable->search(array(array("A.NAMA_SAMPEL","Nama Sampel"),array("dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL)","Kode Sampel"),array("A.TEMPAT_SAMPLING","Tempat Sampling"),array("dbo.KATEGORI(A.KOMODITI,A.PRIORITAS)","Komoditi"),array("dbo.KATEGORI(A.KATEGORI,A.PRIORITAS)","Kategori"),array("C.NAMA_BBPOM","Balai Pengirim")));
				
				$this->newtable->columns(array("A.KODE_SAMPEL", array("A.NAMA_SAMPEL + '<div>' + dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) + '</div><div>' + A.BENTUK_SEDIAAN + '</div><div>' + A.PABRIK + '</div><div>' + A.NOMOR_REGISTRASI + ', No Batch  : ' +  A.NO_BETS + '</div><div>'+A.TEMPAT_SAMPLING+'</div>'",site_url()."/home/unggulan/preview/sampel/{KODE_SAMPEL}"),"CAST(A.JUMLAH_SAMPEL AS VARCHAR) +'&nbsp;'+ A.SATUAN +'<div>&bull;&nbsp;Uji Kimia : '+ CAST(A.JUMLAH_KIMIA AS VARCHAR)+'</div><div>&bull;&nbsp;Uji Mikro : '+CAST(A.JUMLAH_MIKRO AS VARCHAR) +'</div><div>&bull;&nbsp;Sisa Sampel : '+CAST(A.SISA AS VARCHAR) +'</div><div>' +CASE WHEN A.UJI_KIMIA = '1' AND A.UJI_MIKRO = '1' THEN 'Uji Kimia - Mikro' WHEN A.UJI_KIMIA = '1' THEN 'Uji Kimia' WHEN A.UJI_MIKRO = '1' THEN 'Uji Mikro' END+ '</div>'", "dbo.KATEGORI(A.KOMODITI,A.PRIORITAS) + '<div>' + dbo.KATEGORI(A.KATEGORI,A.PRIORITAS) + '</div>'","'<div>Hasil Uji Kimia : ' + A.HASIL_KIMIA + '</div><div>A.Hasil Uji Mikro : ' + A.HASIL_MIKRO + '</div><div>Hasil : ' + A.HASIL_SAMPEL + '</div>'","REPLACE(REPLACE(C.NAMA_BBPOM, 'BALAI POM DI ', ''), 'BALAI BESAR POM DI ','')"," CONVERT(VARCHAR(10), A.UPDATE_DATE, 120)"));
				$this->newtable->orderby(7);
				$this->newtable->sortby("DESC");
				$this->newtable->width(array('IDENTITAS SAMPEL' => 225, 'JUMLAH UJI' => 85, 'KOMODITI' => 75, 'HASIL' => 105, 'BALAI PENGIRIM' => 100));
				//$proses['Preview Data'] = array('POST', site_url().'/post/rujukan/kirim_act/rujuk/ajax', 'N');
			}


			$this->newtable->action(site_url()."/home/rujukan/sampel/".$status);
			$this->newtable->hiddens(array('KODE_SAMPEL'));
			$this->newtable->cidb($this->db);
			$this->newtable->ciuri($this->uri->segment_array());
			$this->newtable->keys(array('KODE_SAMPEL'));
			$proses['Preview Data'] = array('GET', site_url().'/home/unggulan/preview/sampel', '1');
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

			$status = $sipt->main->get_uraian("SELECT STATUS FROM T_SAMPEL_UNGGULAN_TMP WHERE KODE_SAMPEL = '".$id."'","STATUS");
			$arrdata['status_smpl'] = $status;

			if($status=='70022') $arrdata['act'] = site_url() . '/post/unggulan/set_unggulan/prosesmt/';
			else $arrdata['act'] = site_url() . '/post/unggulan/set_unggulan/proses/';
			$arrdata['input'] = $this->get_input($id, $status);

			$arrdata['proses'] = $sipt->main->set_verifikasi($status, $this->newsession->userdata('SESS_JENIS_PELAPORAN'), $this->newsession->userdata('SESS_KODE_ROLE'));
			$arrdata['disproses'] = $status;
			$arrdata['status'] = $status;


			return $arrdata;
		}
	}

	function get_sampel_rilis($id){

		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model('main','main',TRUE);
			$arrdata = array();

			$arrdata['sampel'] = $this->db->query("SELECT  A.KODE_SAMPEL,  dbo.FORMAT_NOMOR('SPL', A.KODE_SAMPEL) AS UR_KODESAMPEL, A.KOMODITI, dbo.KATEGORI(A.KOMODITI,A.PRIORITAS) AS UR_KOMODITI, dbo.KATEGORI(A.KATEGORI,A.PRIORITAS) AS UR_KATEGORI, A.KATEGORI, dbo.URAIAN_M_TABEL('SUB_TUJUAN', A.SUB_TUJUAN) AS SUB_TUJUAN, dbo.URAIAN_M_TABEL('ASAL_SAMPLING',A.ASAL_SAMPEL) AS ASAL_SAMPEL, dbo.URAIAN_M_TABEL('TUJUAN_SAMPLING',A.TUJUAN_SAMPLING) AS TUJUAN_SAMPLING,A.NAMA_SAMPEL,A.NOMOR_REGISTRASI,A.PABRIK,IMPORTIR,A.BENTUK_SEDIAAN,A.KEMASAN,A.NO_BETS,A.KETERANGAN_ED,A.JUMLAH_SAMPEL,A.SATUAN,A.HARGA_SAMPEL,A.UJI_KIMIA,A.JUMLAH_KIMIA,A.UJI_MIKRO,A.JUMLAH_MIKRO,A.SISA,REPLACE(A.KOMPOSISI,';','<br>') AS KOMPOSISI,A.NETTO,A.KONDISI_SAMPEL,A.EVALUASI_PENANDAAN,A.CARA_PENYIMPANAN,A.LAMPIRAN, A.PRIORITAS,  A.PRIORITAS FROM T_M_SAMPEL_RILIS A  WHERE A.KODE_SAMPEL = '".$id."'")->result_array();

			$status = $sipt->main->get_uraian("SELECT STATUS FROM T_M_SAMPEL_RILIS WHERE KODE_SAMPEL = '".$id."'","STATUS");
			$arrdata['status_smpl'] = $status;

			if($status=='50202') $arrdata['act'] = site_url() . '/post/unggulan/set_unggulan/prosesmt/';
			else $arrdata['act'] = site_url() . '/post/unggulan/set_unggulan/proses/';
			$arrdata['input'] = $this->get_input($id, $status);

			$arrdata['proses'] = $sipt->main->set_verifikasi($status, $this->newsession->userdata('SESS_JENIS_PELAPORAN'), $this->newsession->userdata('SESS_KODE_ROLE'));
			$arrdata['disproses'] = $status;
			$arrdata['status'] = $status;


			return $arrdata;
		}
	}
	
	function get_input($kode, $status){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){ 
			$sipt =& get_instance();
			$sipt->load->model("main","main", true);
			$data = "";
			$arrdata = array();
			$arrstts = array('70020','70021','80021','70022');

			$arrdata['row'] = $this->db->query("SELECT *, CONVERT(VARCHAR(10), TANGGAL_TERIMA, 103) AS TGLTERIMA, CONVERT(VARCHAR(10), TANGGAL_VERIFIKASI, 103) AS TGLVERIFIKASI FROM T_SAMPEL_UNGGULAN WHERE KODE_SAMPEL = '".$kode."' AND BBPOM_UNGGULAN = '".$this->newsession->userdata('SESS_BBPOM_ID')."'")->result_array();

			if(in_array($status, $arrstts)){
				
				if($status == "70020"){ 					

					$arrdata['lingkup'] = $sipt->main->combobox("SELECT ID, URAIAN FROM M_LINGKUP_UNGGULAN WHERE STATUS = 1", "ID", "URAIAN", TRUE);

				}else if($status == "70022"){
					$spuid = $sipt->main->get_uraian("SELECT SPU_ID FROM T_M_SAMPEL WHERE KODE_UNGGULAN = '".$kode."'", "SPU_ID");
					$arrdata['mt'] = $sipt->main->combobox("SELECT A.USER_ID, A.NAMA_USER + ' - ' + A.JABATAN AS NAMA FROM T_USER A  WHERE A.USER_ID IN (SELECT USER_ID FROM T_USER_ROLE WHERE ROLE = '4' AND LEFT(SARANA_MEDIA_ID,2) IN ('B1','B2','B3') GROUP BY USER_ID) AND A.BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND A.STATUS = 'Aktif' ORDER BY 2 ASC", "USER_ID", "NAMA", TRUE);
					$arrdata['sess'] = $this->db->query("SELECT SPU_ID, CONVERT(VARCHAR(10), TANGGAL_TERIMA_TPS, 103) AS TANGGAL_TERIMA, dbo.FORMAT_NOMOR('SPU', SPU_ID) AS SPU, SUBSTRING(SPU_ID, 13,2) AS KOMODITI FROM T_SPU WHERE SPU_ID = '".$spuid."'")->result_array();
					
					$chkjml = $this->db->query("SELECT SUM(CASE WHEN UJI_MIKRO = '1' THEN 1 ELSE 0 END) AS JML_MIKRO,SUM(CASE WHEN UJI_KIMIA = '1' THEN 1 ELSE 0 END) AS JML_KIMIA FROM T_M_SAMPEL WHERE SPU_ID = '".$spuid."'")->result_array();
					if($chkjml[0]['JML_MIKRO'] > 0 && $chkjml[0]['JML_KIMIA'] > 0){
						$arrdata['jmlinput'] = 2;
						$arrdata['tipeuji'] = 'Kimia - Mikrobiologi';
					}else if($chkjml[0]['JML_MIKRO'] > 0 && $chkjml[0]['JML_KIMIA'] == 0){
						$arrdata['jmlinput'] = 1;
						$arrdata['tipeuji'] = 'Mikrobiologi';
					}else if($chkjml[0]['JML_MIKRO'] == 0 && $chkjml[0]['JML_KIMIA'] > 0){
						$arrdata['jmlinput'] = 1;
						$arrdata['tipeuji'] = 'Kimia';
					}
				}
	
				$data = $this->load->view('pengujian/unggulan/input/'.$status, $arrdata, true);
			}else{
				$data = "";
			}
		}
		return $data;
	}
}	
?>