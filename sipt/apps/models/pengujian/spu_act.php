<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR);
class Spu_act extends Model{
	function get_spu($id){
		if(in_array('7', $this->newsession->userdata('SESS_KODE_ROLE')) && $this->newsession->userdata('LOGGED_IN') ==  TRUE){
		}
	}

	function preview($id){
		if((in_array('2', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('3', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('4', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('5', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('7', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('8', $this->newsession->userdata('SESS_KODE_ROLE'))) && $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model('main','main',TRUE);
			$this->load->library('newtable');
			$qspu = "SELECT SPU_ID, dbo.FORMAT_NOMOR('SPU', SPU_ID) AS FORMAT_SPU, CONVERT(VARCHAR(10), TANGGAL, 103) AS TANGGAL, CONVERT(VARCHAR(10), TANGGAL_TERIMA_TPS, 103) AS TANGGAL_TERIMA_TPS, PETUGAS_PENERIMA, dbo.URAIAN_M_TABEL('ANGGARAN_SAMPLING', SUBSTRING(SPU_ID, 7,2)) AS ANGGARAN, dbo.URAIAN_M_TABEL('ASAL_SAMPLING', ASAL_SAMPEL) AS [ASAL SAMPEL], dbo.KATEGORI(SUBSTRING(SPU_ID, 13,2),'0') AS KOMODITI, STATUS FROM T_SPU WHERE SPU_ID = '".$id."'";
			$rspu = $sipt->main->get_result($qspu);
			if($rspu){
				foreach($qspu->result_array() as $row){
					$arrdata = array('sess' => $row);
				}
				$arrdata['id'] = $row['SPU_ID'];
				$stts =  $row['STATUS'];
				$query = "SELECT A.PERIKSA_SAMPEL, A.KODE_SAMPEL, B.NOMOR_SURAT +'<div>Tanggal Sampling : ' + CONVERT(VARCHAR(10), A.TANGGAL_SAMPLING, 120) + '</div><div>Bulan Anggaran : '+ A.BULAN_ANGGARAN +'</div><div>Asal Sampel : '+dbo.URAIAN_M_TABEL('ASAL_SAMPLING',A.ASAL_SAMPEL)+'</div>' AS [NOMOR SURAT / PENGANTAR], A.NAMA_SAMPEL + '<div>' + dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) + '</div><div>' + A.BENTUK_SEDIAAN + '</div><div>' + A.PABRIK + '</div><div>' + A.NOMOR_REGISTRASI + ', No Batch  : ' +  A.NO_BETS + '</div><div>'+A.TEMPAT_SAMPLING+'</div>' AS [IDENTITAS SAMPEL], CAST(A.JUMLAH_SAMPEL AS VARCHAR) +'&nbsp;'+ A.SATUAN +'<div>&bull;&nbsp;Uji Kimia : '+ CAST(A.JUMLAH_KIMIA AS VARCHAR)+'</div><div>&bull;&nbsp;Uji Mikro : '+CAST(A.JUMLAH_MIKRO AS VARCHAR) +'</div><div>&bull;&nbsp;Sisa Sampel : '+CAST(A.SISA AS VARCHAR) +'</div><div>' +CASE WHEN UJI_KIMIA = '1' AND UJI_MIKRO = '1' THEN 'Uji Kimia - Mikro' WHEN UJI_KIMIA = '1' THEN 'Uji Kimia' WHEN UJI_MIKRO = '1' THEN 'Uji Mikro' END+ '</div>' AS [JUMLAH UJI], dbo.KATEGORI(A.KOMODITI,A.PRIORITAS) + '<div>' + A.NAMA_KATEGORI + '</div>' AS KOMODITI, CASE WHEN A.STATUS_SAMPEL = '20107' THEN '<div style=\"color:#FF0000;\">'+dbo.URAIAN_M_TABEL('STATUS', A.STATUS_SAMPEL)+'</div>' ELSE dbo.URAIAN_M_TABEL('STATUS', A.STATUS_SAMPEL) END AS [STATUS] FROM T_M_SAMPEL A LEFT JOIN T_PERIKSA_SAMPEL B ON A.PERIKSA_SAMPEL = B.PERIKSA_SAMPEL WHERE A.SPU_ID = '".$id."' AND A.STATUS_SAMPEL NOT IN ('00000')";
				$this->newtable->hiddens(array('PERIKSA_SAMPEL','KODE_SAMPEL'));
				$this->newtable->search(array(array("B.NOMOR_SURAT", "Nomor Surat Tugas / Pengantar"),array("CONVERT(VARCHAR(10), A.TANGGAL_SAMPLING, 120)", "Tanggal Sampling"),array("A.BULAN_ANGGARAN","Bulan Anggaran"),array("dbo.URAIAN_M_TABEL('ASAL_SAMPLING', A.ASAL_SAMPEL)", "Asal Sampel"),array("A.NAMA_SAMPEL","Nama Sampel"),array("dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL)","Kode Sampel"),array("A.TEMPAT_SAMPLING","Tempat Sampling"),array("dbo.KATEGORI(A.KOMODITI,A.PRIORITAS)","Komoditi"),array("A.NAMA_KATEGORI","Kategori"),array("CASE WHEN A.STATUS_SAMPEL = '20107' THEN '<div style=\"color:#FF0000;\">'+dbo.URAIAN_M_TABEL('STATUS', A.STATUS_SAMPEL)+'</div>' ELSE dbo.URAIAN_M_TABEL('STATUS', A.STATUS_SAMPEL) END","Status / Proses Sampel")));
				$this->newtable->columns(array("A.PERIKSA_SAMPEL", "A.KODE_SAMPEL", "B.NOMOR_SURAT +'<div>Tanggal Sampling : ' + CONVERT(VARCHAR(10), A.TANGGAL_SAMPLING, 120) + '</div><div>Bulan Anggaran : '+ A.BULAN_ANGGARAN +'</div><div>Asal Sampel : '+dbo.URAIAN_M_TABEL('ASAL_SAMPLING',A.ASAL_SAMPEL)+'</div>'",array("A.NAMA_SAMPEL + '<div>' + dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) + '</div><div>' + A.BENTUK_SEDIAAN + '</div><div>' + A.PABRIK + '</div><div>' + A.NOMOR_REGISTRASI + ', No Batch  : ' +  A.NO_BETS + '</div><div>'+A.TEMPAT_SAMPLING+'</div>'",site_url().'/home/sampel/preview/{PERIKSA_SAMPEL}.{KODE_SAMPEL}'),"CAST(A.JUMLAH_SAMPEL AS VARCHAR) +'&nbsp;'+ A.SATUAN +'<div>&bull;&nbsp;Uji Kimia : '+ CAST(A.JUMLAH_KIMIA AS VARCHAR)+'</div><div>&bull;&nbsp;Uji Mikro : '+CAST(A.JUMLAH_MIKRO AS VARCHAR) +'</div><div>&bull;&nbsp;Sisa Sampel : '+CAST(A.SISA AS VARCHAR) +'</div><div>' +CASE WHEN UJI_KIMIA = '1' AND UJI_MIKRO = '1' THEN 'Uji Kimia - Mikro' WHEN UJI_KIMIA = '1' THEN 'Uji Kimia' WHEN UJI_MIKRO = '1' THEN 'Uji Mikro' END+ '</div>'","dbo.KATEGORI(A.KOMODITI,A.PRIORITAS) + '<div>' + A.NAMA_KATEGORI + '</div>'","CASE WHEN A.STATUS_SAMPEL = '20107' THEN '<div style=\"color:#FF0000;\">'+dbo.URAIAN_M_TABEL('STATUS', A.STATUS_SAMPEL)+'</div>' ELSE dbo.URAIAN_M_TABEL('STATUS', A.STATUS_SAMPEL) END"));
				$this->newtable->width(array('NOMOR SURAT / PENGANTAR' => 200,'IDENTITAS SAMPEL' => 225, 'JUMLAH UJI' => 85, 'KOMODITI' => 75, 'STATUS' => 105));
				$this->newtable->action(site_url()."/home/spu/preview/".$id);
				$this->newtable->cidb($this->db);
				$this->newtable->ciuri($this->uri->segment_array());
				$this->newtable->orderby(1);
				$this->newtable->sortby("ASC");
				$this->newtable->keys(array('PERIKSA_SAMPEL','KODE_SAMPEL'));
				if(in_array('3', $this->newsession->userdata('SESS_KODE_ROLE')) && $row['STATUS'] == "30106"){
					$proses['Perbaiki Data Sampel'] = array('POST', site_url().'/post/sampel/sampel_act/reject/ajax', 'N');
					$this->newtable->menu($proses);
				}else if(in_array('4', $this->newsession->userdata('SESS_KODE_ROLE')) && $row['STATUS'] == "40106"){
					$proses['Perbaiki Data Sampel'] = array('POST', site_url().'/post/sampel/sampel_act/reject/ajax', 'N');
					$this->newtable->menu($proses);
				}
				$arrdata['tabel'] = $this->newtable->generate($query);
				$arrdata['jml_log'] = $sipt->main->get_uraian("SELECT COUNT(*) AS JML FROM T_SPU_LOG WHERE SPU_ID ='".$id."'","JML");
				$arrdata['status'] = $sipt->main->set_verifikasi($row['STATUS'], $this->newsession->userdata('SESS_JENIS_PELAPORAN'), $this->newsession->userdata('SESS_KODE_ROLE'));
				$arrdata['showjml'] = $sipt->main->get_uraian("SELECT COUNT(JML) AS JML FROM (SELECT DISTINCT(STATUS_SAMPEL) AS JML FROM T_M_SAMPEL WHERE SPU_ID = '".$id."') AS DATA","JML");
				$arrdata['disverifikasi'] = $row['STATUS'];
				if($stts == "70000" || $stts == "80201"){
					$arrdata['allowed'] = TRUE;
					$arrdata['kabalai'] = explode("|", $sipt->main->get_uraian("SELECT NAMA_USER +'|'+ USER_ID AS KABALAI FROM T_USER WHERE
USER_ID IN (SELECT USER_ID FROM T_USER_ROLE WHERE ROLE IN ('5')) AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND STATUS = 'Aktif'","KABALAI"));
				}else{
					$arrdata['allowed'] = FALSE;
				}
				$arrdata['act'] = site_url().'/post/spu/spu_act/verifikasi';
				$arrdata['back'] = site_url().'/home/spu/list/all';
			}		
			return $arrdata;
		}
	}


	function list_spu($submenu){
		if((in_array('8', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('7', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('4', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('3', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('2', $this->newsession->userdata('SESS_KODE_ROLE'))) && $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$this->load->library('newtable');
			if($submenu == "verifikasi"){
				$judul = "Data Surat Permintaan Uji - Proses Verifikasi";
				if(in_array('3',$this->newsession->userdata('SESS_KODE_ROLE'))){
					$status = "AND STATUS = '30106'";
				}else if(in_array('4',$this->newsession->userdata('SESS_KODE_ROLE'))){
					$status = "AND STATUS = '40106'";
				}else if(in_array('7',$this->newsession->userdata('SESS_KODE_ROLE'))){
					$status = "AND STATUS = '70000'";
				}
			}else if($submenu == "all"){
				$judul = "Data Surat Permintaan Uji - Dalam Proses";
				if(in_array('2',$this->newsession->userdata('SESS_KODE_ROLE'))){
					$status = "";
				}else if(in_array('3',$this->newsession->userdata('SESS_KODE_ROLE'))){
					$status = "AND STATUS NOT IN('30106')";
				}else if(in_array('4',$this->newsession->userdata('SESS_KODE_ROLE'))){
					$status = "AND STATUS NOT IN('40106')";
				}else if(in_array('7',$this->newsession->userdata('SESS_KODE_ROLE'))){
					$status = "AND STATUS NOT IN('30106','40106','70000')";
				}else if(in_array('8',$this->newsession->userdata('SESS_KODE_ROLE'))){
					$status = "AND STATUS NOT IN('30106','40106','70000','80201')";
				}
			}
			$query = "SELECT SPU_ID, dbo.FORMAT_NOMOR('SPU',SPU_ID) +'<div>'+ CONVERT(VARCHAR(10), TANGGAL, 120) +'</div>' AS [NOMOR & TANGGAL], dbo.URAIAN_M_TABEL('ANGGARAN_SAMPLING', SUBSTRING(SPU_ID, 7,2)) +'<div>'+ dbo.URAIAN_M_TABEL('ASAL_SAMPLING', ASAL_SAMPEL) +'</div>' AS [ANGGARAN & ASAL SAMPEL], dbo.KATEGORI(SUBSTRING(SPU_ID, 13,2),'0') AS [KOMODITI], dbo.TOTAL_SAMPEL(SPU_ID) AS [TOTAL SAMPEL], dbo.URAIAN_M_TABEL('STATUS',STATUS) AS STATUS, CONVERT(VARCHAR(10), LAST_UPDATE, 120) AS [UPDATE TERAKHIR] FROM T_SPU WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' $status";
			$this->newtable->columns(array("SPU_ID", array("dbo.FORMAT_NOMOR('SPU',SPU_ID) +'<div>'+ CONVERT(VARCHAR(10), TANGGAL, 120) +'</div>'",site_url()."/home/spu/preview/{SPU_ID}"), "dbo.URAIAN_M_TABEL('ANGGARAN_SAMPLING', SUBSTRING(SPU_ID, 7,2)) +'<div>'+ dbo.URAIAN_M_TABEL('ASAL_SAMPLING', ASAL_SAMPEL)+'</div>'","dbo.KATEGORI(SUBSTRING(SPU_ID, 13,2),'0')","dbo.TOTAL_SAMPEL(SPU_ID)", "dbo.URAIAN_M_TABEL('STATUS',STATUS)","CONVERT(VARCHAR(10), LAST_UPDATE, 120)"));
			$this->newtable->action(site_url()."/home/spu/list/".$submenu);
			$this->newtable->search(array(array("dbo.FORMAT_NOMOR('SPU',SPU_ID)", "Nomor Surat Permintaan Uji"),array("CONVERT(VARCHAR(10), TANGGAL, 120)","Tanggal Surat"),array("dbo.URAIAN_M_TABEL('ANGGARAN_SAMPLING', SUBSTRING(SPU_ID, 7,2))","Anggaran Sampel"),array("dbo.URAIAN_M_TABEL('ASAL_SAMPLING', ASAL_SAMPEL)","Asal Sampel"),array("dbo.KATEGORI(SUBSTRING(SPU_ID, 13,2),'0')","Komoditi"),array("dbo.URAIAN_M_TABEL('STATUS',STATUS)","Status SPU","CONVERT(VARCHAR(10), LAST_UPDATE, 120)","Update Terakhir")));
			$this->newtable->width(array('NOMOR & TANGGAL' => 125, 'ANGGARAN & ASAL SAMPEL' => 200, 'KOMODITI' => 75,'TOTAL SAMPEL' => 50, 'STATUS' => 150, 'UPDATE TERAKHIR' => 80));
			$this->newtable->cidb($this->db);
			$this->newtable->ciuri($this->uri->segment_array());
			$this->newtable->orderby(7);
			$this->newtable->sortby("DESC");
			$this->newtable->hiddens(array('SPU_ID'));
			$this->newtable->keys(array('SPU_ID'));
			$proses['Preview Data'] = array('GET', site_url()."/home/spu/preview", '1');
			if(in_array('2',$this->newsession->userdata('SESS_KODE_ROLE')) || in_array('7',$this->newsession->userdata('SESS_KODE_ROLE'))){
				$proses['Cetak Data SPU'] = array('GETNEW', site_url()."/topdf/spu/prints", '1');
			}
			$this->newtable->menu($proses);
			$tabel = $this->newtable->generate($query);
			$arrdata = array('table' => $tabel,
							 'idjudul' => 'juduluji',
							 'caption_header' => $judul,
							 'batal' => '',
							 'cancel' => '');
			return $arrdata;
		}
	}
	
	function list_sps($submenu){
		if((in_array('7', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('8', $this->newsession->userdata('SESS_KODE_ROLE'))) && $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$this->load->library('newtable');
			if(in_array('7', $this->newsession->userdata('SESS_KODE_ROLE'))){
				if($submenu == "verifikasi"){
					$judul = "Daftar Surat Permintaan Uji - Penerimaan Sampel";
					$query = "SELECT SPU_ID, dbo.FORMAT_NOMOR('SPU',SPU_ID) +'<div>'+ CONVERT(VARCHAR(10), TANGGAL, 120) +'</div>' AS [NOMOR & TANGGAL], dbo.URAIAN_M_TABEL('ANGGARAN_SAMPLING', SUBSTRING(SPU_ID, 7,2)) +'<div>'+ dbo.URAIAN_M_TABEL('ASAL_SAMPLING', ASAL_SAMPEL) +'</div>' AS [ANGGARAN & ASAL SAMPEL], dbo.KATEGORI(SUBSTRING(SPU_ID, 13,2),'0') AS [KOMODITI], dbo.TOTAL_SAMPEL(SPU_ID) AS [TOTAL SAMPEL], dbo.URAIAN_M_TABEL('STATUS',STATUS) AS STATUS, CONVERT(VARCHAR(10), LAST_UPDATE, 120) AS [UPDATE TERAKHIR] FROM T_SPU WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND STATUS = '70000' AND ASAL_SAMPEL NOT IN ('10','11','12')";
					$this->newtable->columns(array("SPU_ID", array("dbo.FORMAT_NOMOR('SPU',SPU_ID) +'<div>'+ CONVERT(VARCHAR(10), TANGGAL, 120) +'</div>'",site_url()."/home/spu/preview/{SPU_ID}"), "dbo.URAIAN_M_TABEL('ANGGARAN_SAMPLING', SUBSTRING(SPU_ID, 7,2)) +'<div>'+ dbo.URAIAN_M_TABEL('ASAL_SAMPLING', ASAL_SAMPEL)+'</div>'","dbo.KATEGORI(SUBSTRING(SPU_ID, 13,2),'0')","dbo.TOTAL_SAMPEL(SPU_ID)", "dbo.URAIAN_M_TABEL('STATUS',STATUS)","CONVERT(VARCHAR(10), LAST_UPDATE, 120)"));
					$this->newtable->search(array(array("dbo.FORMAT_NOMOR('SPU',SPU_ID)", "Nomor Surat Permintaan Uji"),array("CONVERT(VARCHAR(10), TANGGAL, 120)","Tanggal Surat"),array("dbo.URAIAN_M_TABEL('ANGGARAN_SAMPLING', SUBSTRING(SPU_ID, 7,2))","Anggaran Sampel"),array("dbo.URAIAN_M_TABEL('ASAL_SAMPLING', ASAL_SAMPEL)","Asal Sampel"),array("dbo.KATEGORI(SUBSTRING(SPU_ID, 13,2),'0')","Komoditi"),array("dbo.URAIAN_M_TABEL('STATUS',STATUS)","Status SPU"), array("CONVERT(VARCHAR(10), LAST_UPDATE, 120)","Update Terakhir")));
					$this->newtable->width(array('NOMOR & TANGGAL' => 125, 'ANGGARAN & ASAL SAMPEL' => 200, 'KOMODITI' => 75,'TOTAL SAMPEL' => 50, 'STATUS' => 150, 'UPDATE TERAKHIR' => 80));
					$this->newtable->orderby(7);
				}else if($submenu == "terkirim"){
					$judul = "Daftar Surat Permintaan Uji - Penerimaan Sampel";
					$query = "SELECT SPU_ID, dbo.FORMAT_NOMOR('SPU',SPU_ID) +'<div>'+ CONVERT(VARCHAR(10), TANGGAL, 120) +'</div>' AS [NOMOR & TANGGAL], dbo.URAIAN_M_TABEL('ANGGARAN_SAMPLING', SUBSTRING(SPU_ID, 7,2)) +'<div>'+ dbo.URAIAN_M_TABEL('ASAL_SAMPLING', ASAL_SAMPEL) +'</div>' AS [ANGGARAN & ASAL SAMPEL], dbo.KATEGORI(SUBSTRING(SPU_ID, 13,2),'0') AS [KOMODITI], dbo.TOTAL_SAMPEL(SPU_ID) AS [TOTAL SAMPEL], dbo.URAIAN_M_TABEL('STATUS',STATUS) AS STATUS, CONVERT(VARCHAR(10), LAST_UPDATE, 120) AS [UPDATE TERAKHIR] FROM T_SPU WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND STATUS IN ('80201','40201') AND ASAL_SAMPEL NOT IN ('10','11','12')";
					$this->newtable->columns(array("SPU_ID", array("dbo.FORMAT_NOMOR('SPU',SPU_ID) +'<div>'+ CONVERT(VARCHAR(10), TANGGAL, 120) +'</div>'",site_url()."/home/spu/preview/{SPU_ID}"), "dbo.URAIAN_M_TABEL('ANGGARAN_SAMPLING', SUBSTRING(SPU_ID, 7,2)) +'<div>'+ dbo.URAIAN_M_TABEL('ASAL_SAMPLING', ASAL_SAMPEL)+'</div>'","dbo.KATEGORI(SUBSTRING(SPU_ID, 13,2),'0')","dbo.TOTAL_SAMPEL(SPU_ID)", "dbo.URAIAN_M_TABEL('STATUS',STATUS)","CONVERT(VARCHAR(10), LAST_UPDATE, 120)"));
					$this->newtable->search(array(array("dbo.FORMAT_NOMOR('SPU',SPU_ID)", "Nomor Surat Permintaan Uji"),array("CONVERT(VARCHAR(10), TANGGAL, 120)","Tanggal Surat"),array("dbo.URAIAN_M_TABEL('ANGGARAN_SAMPLING', SUBSTRING(SPU_ID, 7,2))","Anggaran Sampel"),array("dbo.URAIAN_M_TABEL('ASAL_SAMPLING', ASAL_SAMPEL)","Asal Sampel"),array("dbo.KATEGORI(SUBSTRING(SPU_ID, 13,2),'0')","Komoditi"),array("dbo.URAIAN_M_TABEL('STATUS',STATUS)","Status SPU"), array("CONVERT(VARCHAR(10), LAST_UPDATE, 120)","Update Terakhir")));
					$this->newtable->width(array('NOMOR & TANGGAL' => 125, 'ANGGARAN & ASAL SAMPEL' => 200, 'KOMODITI' => 75,'TOTAL SAMPEL' => 50, 'STATUS' => 150, 'UPDATE TERAKHIR' => 80));
					$this->newtable->orderby(7);
				}else{
					if($submenu == "all"){
						$judul = "Daftar Surat Permintaan Uji";
						$q = "AND STATUS IN ('80201','40201')";
						$proses['Detail SPU dan SPS'] = array('GET', site_url()."/home/sps/view", '1');
						$proses['Cetak Data Permintaan Uji'] = array('GETNEW', site_url()."/topdf/spu/prints", '1');
						$proses['Cetak Surat Perintah Uji dan SPS'] = array('GETNEW', site_url()."/topdf/sps/prints", '1');
					}else if($submenu == "sp"){
						$judul = "Daftar Surat Permintaan Uji - Disposisi Perintah Uji";
						$q = "AND STATUS IN ('50201')";
					}
					$query = "SELECT SPU_ID, dbo.FORMAT_NOMOR('SPU',SPU_ID) +'<div>'+ CONVERT(VARCHAR(10), TANGGAL, 120) +'</div>' AS [NOMOR & TANGGAL SPU], dbo.FORMAT_NOMOR('SPS',NOMOR_SPS) +'<div>'+ CONVERT(VARCHAR(10), TANGGAL_TERIMA_TPS, 120) +'</div>' AS [NOMOR & TANGGAL SPS], dbo.URAIAN_M_TABEL('ANGGARAN_SAMPLING', SUBSTRING(SPU_ID, 7,2)) +'<div>'+ dbo.URAIAN_M_TABEL('ASAL_SAMPLING', ASAL_SAMPEL) +'</div>' AS [ANGGARAN & ASAL SAMPEL], dbo.KATEGORI(SUBSTRING(SPU_ID, 13,2),'0') AS [KOMODITI], dbo.TOTAL_SAMPEL(SPU_ID) AS [TOTAL SAMPEL], 
					dbo.URAIAN_M_TABEL('STATUS',STATUS)  + (CASE WHEN STATUS = '40201' THEN dbo.VIEW_MT(SPU_ID) ELSE '<div style=\"color:#FFF; font-weight:bold; background:#CE0000; padding:2px;\">Belum dikirim ke Bidang Pengujian</div>' END) AS STATUS,
					CONVERT(VARCHAR(10), LAST_UPDATE, 120) AS [UPDATE TERAKHIR] FROM T_SPU WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' $q AND ASAL_SAMPEL NOT IN ('10','11','12')";
					$this->newtable->columns(array("SPU_ID", array("dbo.FORMAT_NOMOR('SPU',SPU_ID) +'<div>'+ CONVERT(VARCHAR(10), TANGGAL, 120) +'</div>'",site_url()."/home/spu/preview/{SPU_ID}"), "dbo.FORMAT_NOMOR('SPS',NOMOR_SPS) +'<div>'+ CONVERT(VARCHAR(10), TANGGAL_TERIMA_TPS, 120) +'</div>'", "dbo.URAIAN_M_TABEL('ANGGARAN_SAMPLING', SUBSTRING(SPU_ID, 7,2)) +'<div>'+ dbo.URAIAN_M_TABEL('ASAL_SAMPLING', ASAL_SAMPEL)+'</div>'","dbo.KATEGORI(SUBSTRING(SPU_ID, 13,2),'0')","dbo.TOTAL_SAMPEL(SPU_ID)", "dbo.URAIAN_M_TABEL('STATUS',STATUS)  + (CASE WHEN STATUS = '40201' THEN dbo.VIEW_MT(SPU_ID) ELSE '<div style=\"color:#FFF; font-weight:bold; background:#CE0000; padding:2px;\">Belum dikirim ke Bidang Pengujian</div>' END)","CONVERT(VARCHAR(10), LAST_UPDATE, 120)"));
					$this->newtable->search(array(array("dbo.FORMAT_NOMOR('SPU',SPU_ID)", "Nomor Surat Permintaan Uji"),array("CONVERT(VARCHAR(10), TANGGAL, 120)","Tanggal Surat"),array("dbo.FORMAT_NOMOR('SPS',NOMOR_SPS)", "Nomor Surat Penyerahan Sampel"),array("CONVERT(VARCHAR(10), TANGGAL_TERIMA_TPS, 120)","Tanggal Penerimaan Sampel"), array("dbo.URAIAN_M_TABEL('ANGGARAN_SAMPLING', SUBSTRING(SPU_ID, 7,2))","Anggaran Sampel"),array("dbo.URAIAN_M_TABEL('ASAL_SAMPLING', ASAL_SAMPEL)","Asal Sampel"),array("dbo.KATEGORI(SUBSTRING(SPU_ID, 13,2),'0')","Komoditi"),array("CONVERT(VARCHAR(10), LAST_UPDATE, 120)","Update Terakhir")));
					$this->newtable->width(array('NOMOR & TANGGAL SPU' => 125, 'NOMOR & TANGGAL SPS' => 125, 'ANGGARAN & ASAL SAMPEL' => 200, 'KOMODITI' => 75,'TOTAL SAMPEL' => 50, 'STATUS' => 150, 'UPDATE TERAKHIR' => 90));
					$this->newtable->orderby(8);
				}
			}else if(in_array('8', $this->newsession->userdata('SESS_KODE_ROLE'))){
				$judul = "Daftar Surat Permintaan Uji - Verifikasi Penyerahan Sampel";
				if($submenu == "verifikasi"){
					$query = "SELECT SPU_ID, dbo.FORMAT_NOMOR('SPU',SPU_ID) +'<div>'+ CONVERT(VARCHAR(10), TANGGAL, 120) +'</div>' AS [NOMOR & TANGGAL SPU], dbo.FORMAT_NOMOR('SPS',NOMOR_SPS) +'<div>'+ CONVERT(VARCHAR(10), TANGGAL_TERIMA_TPS, 120) +'</div>' AS [NOMOR & TANGGAL SPS], dbo.URAIAN_M_TABEL('ANGGARAN_SAMPLING', SUBSTRING(SPU_ID, 7,2)) +'<div>'+ dbo.URAIAN_M_TABEL('ASAL_SAMPLING', ASAL_SAMPEL) +'</div>' AS [ANGGARAN & ASAL SAMPEL], dbo.KATEGORI(SUBSTRING(SPU_ID, 13,2),'0') AS [KOMODITI], dbo.TOTAL_SAMPEL(SPU_ID) AS [TOTAL SAMPEL], dbo.URAIAN_M_TABEL('STATUS',STATUS) AS STATUS, CONVERT(VARCHAR(10), LAST_UPDATE, 120) AS [UPDATE TERAKHIR] FROM T_SPU WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND STATUS = '80201' AND ASAL_SAMPEL NOT IN ('10','11','12')";
				}else{
					$query = "SELECT SPU_ID, dbo.FORMAT_NOMOR('SPU',SPU_ID) +'<div>'+ CONVERT(VARCHAR(10), TANGGAL, 120) +'</div>' AS [NOMOR & TANGGAL SPU], dbo.FORMAT_NOMOR('SPS',NOMOR_SPS) +'<div>'+ CONVERT(VARCHAR(10), TANGGAL_TERIMA_TPS, 120) +'</div>' AS [NOMOR & TANGGAL SPS], dbo.URAIAN_M_TABEL('ANGGARAN_SAMPLING', SUBSTRING(SPU_ID, 7,2)) +'<div>'+ dbo.URAIAN_M_TABEL('ASAL_SAMPLING', ASAL_SAMPEL) +'</div>' AS [ANGGARAN & ASAL SAMPEL], dbo.KATEGORI(SUBSTRING(SPU_ID, 13,2),'0') AS [KOMODITI], dbo.TOTAL_SAMPEL(SPU_ID) AS [TOTAL SAMPEL], dbo.URAIAN_M_TABEL('STATUS',STATUS) AS STATUS, CONVERT(VARCHAR(10), LAST_UPDATE, 120) AS [UPDATE TERAKHIR] FROM T_SPU WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND STATUS IN ('50201') AND ASAL_SAMPEL NOT IN ('10','11','12')";
				}
				$this->newtable->columns(array("SPU_ID", array("dbo.FORMAT_NOMOR('SPU',SPU_ID) +'<div>'+ CONVERT(VARCHAR(10), TANGGAL, 120) +'</div>'",site_url()."/home/spu/preview/{SPU_ID}"), "dbo.FORMAT_NOMOR('SPS',NOMOR_SPS) +'<div>'+ CONVERT(VARCHAR(10), TANGGAL_TERIMA_TPS, 120) +'</div>'", "dbo.URAIAN_M_TABEL('ANGGARAN_SAMPLING', SUBSTRING(SPU_ID, 7,2)) +'<div>'+ dbo.URAIAN_M_TABEL('ASAL_SAMPLING', ASAL_SAMPEL)+'</div>'","dbo.KATEGORI(SUBSTRING(SPU_ID, 13,2),'0')","dbo.TOTAL_SAMPEL(SPU_ID)", "dbo.URAIAN_M_TABEL('STATUS',STATUS)","CONVERT(VARCHAR(10), LAST_UPDATE, 120)"));
				$this->newtable->search(array(array("dbo.FORMAT_NOMOR('SPU',SPU_ID)", "Nomor Surat Permintaan Uji"),array("CONVERT(VARCHAR(10), TANGGAL, 120)","Tanggal Surat"),array("dbo.FORMAT_NOMOR('SPS',NOMOR_SPS)", "Nomor Surat Penyerahan Sampel"),array("CONVERT(VARCHAR(10), TANGGAL_TERIMA_TPS, 120)","Tanggal Penerimaan Sampel"), array("dbo.URAIAN_M_TABEL('ANGGARAN_SAMPLING', SUBSTRING(SPU_ID, 7,2))","Anggaran Sampel"),array("dbo.URAIAN_M_TABEL('ASAL_SAMPLING', ASAL_SAMPEL)","Asal Sampel"),array("dbo.KATEGORI(SUBSTRING(SPU_ID, 13,2),'0')","Komoditi"),array("dbo.URAIAN_M_TABEL('STATUS',STATUS)","Status SPU"),array("CONVERT(VARCHAR(10), LAST_UPDATE, 120)","Update Terakhir")));
				$this->newtable->width(array('NOMOR & TANGGAL SPU' => 125, 'NOMOR & TANGGAL SPS' => 125, 'ANGGARAN & ASAL SAMPEL' => 200, 'KOMODITI' => 75,'TOTAL SAMPEL' => 50, 'STATUS' => 150, 'UPDATE TERAKHIR' => 90));
				$this->newtable->orderby(8);
			}
			$this->newtable->action(site_url()."/home/sps/list/".$submenu);
			$this->newtable->cidb($this->db);
			$this->newtable->ciuri($this->uri->segment_array());
			$this->newtable->sortby("DESC");
			$this->newtable->hiddens(array('SPU_ID'));
			$this->newtable->keys(array('SPU_ID'));
			$proses['Preview Data'] = array('GET', site_url()."/home/spu/preview", '1');
			if(in_array('7',$this->newsession->userdata('SESS_KODE_ROLE'))){
				if($submenu == "sp"){
					$proses['Cetak Data Permintaan Uji'] = array('GETNEW', site_url()."/topdf/spu/prints", '1');
					$proses['Tambah Surat Perintah Uji'] = array('GET', site_url()."/home/pengujian/spu", '1');
				}
			}
			$this->newtable->menu($proses);
			$tabel = $this->newtable->generate($query);
			$arrdata = array('table' => $tabel,
							 'idjudul' => 'juduluji',
							 'caption_header' => $judul,
							 'batal' => '',
							 'cancel' => '');
			return $arrdata;
		}
	}
	
	function set_spu($action, $isajax){
		if((in_array('1', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('2', $this->newsession->userdata('SESS_KODE_ROLE'))  || in_array('3', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('4', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('5', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('7', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('8', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('9', $this->newsession->userdata('SESS_KODE_ROLE'))) && $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			if($action=="save"){
				$hasil = FALSE;
				$msgok = "Tambah data SPU baru berhasil";
				$msgerr = "Tambah SPU baru gagal, Silahkan coba lagi";
				$kode = explode(",",$this->input->post('KODE_SAMPEL'));
				$komoditi = $this->input->post('KOMODITI');
				$anggaran = $this->input->post('ANGGARAN');
				$dtspu = $sipt->main->post_to_query($this->input->post('SPU'));
				$chk = (int)$sipt->main->get_uraian("SELECT AUTO_RESET FROM M_REF_SPU WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND ANGGARAN = '".$anggaran."' AND KOMODITI = '".$komoditi."'","AUTO_RESET");
				if($chk == 1)
					$dtspu['SPU_ID'] = $sipt->main->set_kode_spu($anggaran,$komoditi,$dtspu['TANGGAL']);
				else
					$dtspu['SPU_ID'] = $sipt->main->set_kode_spu($anggaran,$komoditi,$dtspu['TANGGAL']);
					
				$dtspu['BBPOM_ID'] = $this->newsession->userdata('SESS_BBPOM_ID');
				$dtspu['ASAL_SAMPEL'] = $this->input->post('ASAL_SAMPEL');
				$dtspu['CREATE_BY'] = $this->newsession->userdata('SESS_USER_ID');
				$dtspu['CREATE_DATE'] = 'GETDATE()';
				$dtspu['UPDATE_BY'] = $this->newsession->userdata('SESS_USER_ID');
				$dtspu['LAST_UPDATE'] = 'GETDATE()';
				$dtspu['STATUS'] = '30106';
				if($dtspu['TANGGAL_KIRIM'] == "") $dtspu['TANGGAL_KIRIM'] = null;
				if($dtspu['TANGGAL_TERIMA_TPS'] == "") $dtspu['TANGGAL_TERIMA_TPS'] = null;
				if($dtspu['TANGGAL_PERINTAH'] == "") $dtspu['TANGGAL_PERINTAH'] = null;
				if($this->db->insert('T_SPU',$dtspu)){
					//$sipt->main->set_max('spu',$komoditi);
					$hasil = TRUE;
					$logspu = array('SPU_ID' => $dtspu['SPU_ID'],
									'WAKTU' => 'GETDATE()',
									'USER_ID' => $this->newsession->userdata('SESS_USER_ID'),
									'KEGIATAN' => 'Simpan data Surat Permintaan Uji : '.$dtspu['SPU_ID'],
									'CATATAN' => 'Kode sampel : '.str_replace("'","",$this->input->post('KODE_SAMPEL')));
					$this->db->insert('T_SPU_LOG', $logspu);
					foreach($kode as $a){
						$this->db->simple_query("UPDATE T_M_SAMPEL SET SPU_ID ='".$dtspu['SPU_ID']."', STATUS_SAMPEL = '30106' WHERE KODE_SAMPEL = '".str_replace("'","",$a)."'");
						$logsampel = array('KODE_SAMPEL' => str_replace("'","",$a),
										   'WAKTU' => 'GETDATE()',
										   'USER_ID' => $this->newsession->userdata('SESS_USER_ID'),
										   'KEGIATAN' => 'Berhasil ditambahkan ke data SPU',
										   'CATATAN' => 'Nomor SPU : '.$dtspu['SPU_ID']);
						$this->db->insert('T_SAMPLING_LOG', $logsampel);
					}
				}
				if($hasil){
					return "MSG#YES#$msgok.#".site_url().'/home/spu/list/all';
				}else{
					return "MSG#NO#$msgerror";
				}
				
				if($isajax!="ajax"){
					redirect(base_url());
					exit();
				}
			}else if($action=="verifikasi"){
				$hasil = FALSE;
				$msgok = "Permintaan uji berhasil di verifikasi";
				$msgerr = "Permintaan uji gagal di verifikasi, Silahkan coba lagi";
				$err = 0;
				if($err==0){
					if((in_array('3',$this->newsession->userdata('SESS_KODE_ROLE')) || in_array('4',$this->newsession->userdata('SESS_KODE_ROLE'))) && in_array('01',$this->newsession->userdata('SESS_JENIS_PELAPORAN'))){
						if(in_array('3',$this->newsession->userdata('SESS_KODE_ROLE'))){
							$this->db->simple_query("SET DATEFORMAT DMY UPDATE T_SPU SET STATUS ='".$this->input->post('STATUS')."', TANGGAL_KIRIM = null, TANGGAL_PERINTAH = null, UPDATE_BY = '".$this->newsession->userdata('SESS_USER_ID')."', LAST_UPDATE = GETDATE() WHERE SPU_ID = '".$this->input->post('SPU_ID')."'");
						}
						if(in_array('4',$this->newsession->userdata('SESS_KODE_ROLE'))){
							$this->db->simple_query("SET DATEFORMAT DMY UPDATE T_SPU SET STATUS ='".$this->input->post('STATUS')."', TANGGAL_KIRIM = GETDATE(), TTD_PEMDIK = '".$this->newsession->userdata('SESS_USER_ID')."', TANGGAL_PERINTAH = null, UPDATE_BY = '".$this->newsession->userdata('SESS_USER_ID')."', LAST_UPDATE = GETDATE() WHERE SPU_ID = '".$this->input->post('SPU_ID')."'");
						}
						$catatan = $this->input->post('catatan');
						$kegiatan = 'Verifikasi data Surat Permintaan Uji : '.$this->input->post('SPU_ID');
						$res = $this->db->simple_query("UPDATE T_M_SAMPEL SET STATUS_SAMPEL = '".$this->input->post('STATUS')."' WHERE SPU_ID ='".$this->input->post('SPU_ID')."' AND STATUS_SAMPEL <> '20107'");
					}else if(in_array('7',$this->newsession->userdata('SESS_KODE_ROLE')) || in_array('8',$this->newsession->userdata('SESS_KODE_ROLE'))){
						$cek = $sipt->main->get_uraian("SELECT COUNT(JML) AS JML FROM (SELECT DISTINCT(STATUS_SAMPEL) AS JML 
FROM T_M_SAMPEL WHERE SPU_ID = '".$this->input->post('SPU_ID')."' AND STATUS_SAMPEL NOT IN ('00000')) AS DATA","JML");
						if($cek > 1){
							return "MSG#NO#Masih ada sampel yang diperbaiki.\n Data tidak dapat dikirim karena data belum lengkap.";
							die();
						}
						//$sebelum = $sipt->main->get_uraian("SELECT STATUS FROM T_SPU WHERE SPU_ID = '".$this->input->post('SPU_ID')."'","STATUS");
						if(in_array('7',$this->newsession->userdata('SESS_KODE_ROLE'))){
							
							$chk = (int)$sipt->main->get_uraian("SELECT AUTO_RESET FROM M_REF_SP WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND KOMODITI = '".substr($this->input->post('SPU_ID'),12,2)."'","AUTO_RESET"); 
							
							//$sesudah = $sipt->main->get_uraian("SELECT SESUDAH FROM M_VERIFIKASI WHERE PELAPORAN_ID = '02' AND SEBELUM = '".$sebelum."' AND PROSES = '1' AND ROLE_ID = '7'","SESUDAH");
							$res = $this->db->simple_query("SET DATEFORMAT DMY UPDATE T_M_SAMPEL SET STATUS_SAMPEL = '".$this->input->post('STATUS')."' WHERE SPU_ID ='".$this->input->post('SPU_ID')."'");
							$no_sps = str_replace("SPU","SPS",$this->input->post('SPU_ID'));
							$komoditi = substr($this->input->post('SPU_ID'),12,2);
							
							$tglspu = $sipt->main->get_uraian("SELECT REPLACE(CONVERT(VARCHAR(8), TANGGAL, 4),'.','') AS TANGGAL FROM T_SPU WHERE SPU_ID = '".$this->input->post('SPU_ID')."'","TANGGAL");
							$chk2 = (int)$sipt->main->get_uraian("SELECT AUTO_RESET FROM M_REF_SP WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND KOMODITI = '".$komoditi."'","AUTO_RESET");
							$nomor_sp = $sipt->main->set_kode_sp($komoditi,$tglspu);
							$sql = "SET DATEFORMAT DMY UPDATE T_SPU SET STATUS ='".$this->input->post('STATUS')."', TANGGAL_TERIMA_TPS = '".$this->input->post('TANGGAL_TERIMA_TPS')."', NOMOR_SPS = '".$no_sps."', NOMOR_SP = '".$nomor_sp."', UPDATE_BY = '".$this->newsession->userdata('SESS_USER_ID')."', PETUGAS_PENERIMA = '".$this->input->post('PETUGAS_PENERIMA')."', LAST_UPDATE = GETDATE() WHERE SPU_ID = '".$this->input->post('SPU_ID')."'";
							$this->db->simple_query($sql);
							$catatan = 'Penerimaan Sampel';
							$kegiatan = 'Penerimaan Sampel - Surat Permintaan Uji : '.$this->input->post('SPU_ID');
						}else if(in_array('8',$this->newsession->userdata('SESS_KODE_ROLE'))){
							#$sesudah = $sipt->main->get_uraian("SELECT SESUDAH FROM M_VERIFIKASI WHERE PELAPORAN_ID = '02' AND SEBELUM = '".$sebelum."' AND PROSES = '1' AND ROLE_ID = '8'","SESUDAH");							
							$jml = (int)$sipt->main->get_uraian("SELECT COUNT(*) AS JML FROM T_M_SAMPEL WHERE SPU_ID = '".$this->input->post('SPU_ID')."' AND UJI_UNGGULAN = '1'","JML");
							if($jml > 0){					
								$query = "SELECT KODE_SAMPEL FROM T_M_SAMPEL WHERE SPU_ID = '".$this->input->post('SPU_ID')."' AND UJI_UNGGULAN = '1'";
								$reslt = $sipt->main->get_result($query);
								if($reslt){
									foreach($query->result_array() as $row){										
										$arrkode[] = $row['KODE_SAMPEL'];
										$dttmp = array('KODE_SAMPEL' => $row['KODE_SAMPEL'],
													   'BBPOM_ID' => $this->newsession->userdata('SESS_BBPOM_ID'),
													   'CREATE_BY' => $this->newsession->userdata('SESS_USER_ID'),
													   'CREATE_DATE' => 'GETDATE()',
													   'STATUS' => '70020');
										$this->db->insert('T_SAMPEL_UNGGULAN_TMP', $dttmp);						
									}
								}					
								$notinkode = "'".join("','", $arrkode)."'";				
								$chk = (int)$sipt->main->get_uraian("SELECT COUNT(JML) AS JMLH FROM (SELECT DISTINCT(UJI_UNGGULAN) AS JML FROM T_M_SAMPEL WHERE SPU_ID = '".$this->input->post('SPU_ID')."' AND UJI_UNGGULAN = '1') AS DATA","JMLH");								
								if($chk>1){
									$this->db->simple_query("UPDATE T_M_SAMPEL SET STATUS_SAMPEL = '70020' WHERE SPU_ID = '".$this->input->post('SPU_ID')."' AND KODE_SAMPEL IN(".$notinkode.")");
									$this->db->simple_query("UPDATE T_M_SAMPEL SET STATUS_SAMPEL = '".$this->input->post('STATUS')."' WHERE SPU_ID = '".$this->input->post('SPU_ID')."' AND KODE_SAMPEL NOT IN(".$notinkode.")");
							$sql = "SET DATEFORMAT DMY UPDATE T_SPU SET STATUS = '".$this->input->post('STATUS')."', TTD_MA = '".$this->newsession->userdata('SESS_USER_ID')."', TTD_MP = '".$this->input->post('TTD_MP')."', TANGGAL_PERINTAH = '".$this->input->post('TANGGAL_PERINTAH')."', UPDATE_BY = '".$this->newsession->userdata('SESS_USER_ID')."', LAST_UPDATE = GETDATE() WHERE SPU_ID = '".$this->input->post('SPU_ID')."'";
							$this->db->simple_query($sql);
									$res = TRUE;
								}else if($chk==1){
									$this->db->simple_query("UPDATE T_M_SAMPEL SET STATUS_SAMPEL = '70020' WHERE SPU_ID = '".$this->input->post('SPU_ID')."'");
									$sql = "SET DATEFORMAT DMY UPDATE T_SPU SET STATUS = '70020', TTD_MA = '".$this->newsession->userdata('SESS_USER_ID')."', TTD_MP = '".$this->input->post('TTD_MP')."', TANGGAL_PERINTAH = '".$this->input->post('TANGGAL_PERINTAH')."', UPDATE_BY = '".$this->newsession->userdata('SESS_USER_ID')."', LAST_UPDATE = GETDATE() WHERE SPU_ID = '".$this->input->post('SPU_ID')."'";
									$this->db->simple_query($sql);
									$res = TRUE;
								}					
							}else{
								$sql = "SET DATEFORMAT DMY UPDATE T_SPU SET STATUS = '".$this->input->post('STATUS')."', TTD_MA = '".$this->newsession->userdata('SESS_USER_ID')."', TTD_MP = '".$this->input->post('TTD_MP')."', TANGGAL_PERINTAH = '".$this->input->post('TANGGAL_PERINTAH')."', UPDATE_BY = '".$this->newsession->userdata('SESS_USER_ID')."', LAST_UPDATE = GETDATE() WHERE SPU_ID = '".$this->input->post('SPU_ID')."'";
								$this->db->simple_query($sql);								
								$res = $this->db->simple_query("UPDATE T_M_SAMPEL SET STATUS_SAMPEL = '".$this->input->post('STATUS')."' WHERE SPU_ID ='".$this->input->post('SPU_ID')."'");
							}
							$catatan = '-';
							$kegiatan = 'Verifikasi Penerimaan Sampel - Surat Permintaan Uji : '.$this->input->post('SPU_ID');
							$res = $this->db->simple_query("UPDATE T_M_SAMPEL SET STATUS_SAMPEL = '".$this->input->post('STATUS')."' WHERE SPU_ID ='".$this->input->post('SPU_ID')."'");
						}
					}
					$logspu = array('SPU_ID' => $this->input->post('SPU_ID'),
									'WAKTU' => 'GETDATE()',
									'USER_ID' => $this->newsession->userdata('SESS_USER_ID'),
									'KEGIATAN' => $kegiatan,
									'CATATAN' => $catatan);
					$this->db->insert('T_SPU_LOG', $logspu);
					if($res){
						$hasil = TRUE;
					}
				}
				
				if($hasil){
					if(in_array('8',$this->newsession->userdata('SESS_KODE_ROLE')))
					return "MSG#YES#$msgok#".site_url().'/home/sps/list/all';
					else
					return "MSG#YES#$msgok#".site_url().'/home/spu/list/all';
				}else{
					return "MSG#YES#$msgerr";
				}
				
				if($isajax!="ajax"){
					redirect(base_url());
					exit();
				}
			}
			
			else if($action == "edit-header"){
				$hasil = FALSE;
				$msgok = "Edit data header SPU berhasil";
				$msgerr = "Edit data header SPU gagal";
				$header = $sipt->main->post_to_query($this->input->post('SPU'));
				$this->db->where('SPU_ID', $this->input->post('SPU_ID'));
				$resampel = $this->db->update('T_SPU', $header);
				if($resampel){
					return "MSG#YES#$msgok#SUKSES";
				}else{
					return "MSG#NO#$msgerr";
				}
			}
			
			else if($action == "edit-disposisi"){
				$hasil = FALSE;
				$msgok = "Update disposisi manajer teknis berhasil. \n";
				$msgerr = "Update disposisi manajer teknis gagal";
				$jmld = (int)$sipt->main->get_uraian("SELECT COUNT(*) AS JML FROM T_SAMPEL_MT WHERE SPU_ID = '".$this->input->post('SPU_ID')."' AND USER_ID = '".$this->input->post('USER_IDX')."' AND KODE_SAMPEL = '".$this->input->post('KODE_SAMPEL')."'","JML");
				if($jmld > 0){
					$rd = $this->db->simple_query("UPDATE T_SAMPEL_MT SET USER_ID = '".$this->input->post('USER_ID')."' WHERE SPU_ID = '".$this->input->post('SPU_ID')."' AND USER_ID = '".$this->input->post('USER_IDX')."' AND KODE_SAMPEL = '".$this->input->post('KODE_SAMPEL')."'");
					if($rd){
						$jmls = (int)$sipt->main->get_uraian("SELECT COUNT(*) AS JMLSPK FROM T_SPK WHERE SPU_ID = '".$this->input->post('SPU_ID')."' AND KODE_SAMPEL = '".$this->input->post('KODE_SAMPEL')."' AND CREATE_BY = '".$this->input->post('USER_IDX')."'","JMLSPK");
						if($jmls > 0){
							$rs = $this->db->simple_query("UPDATE T_SPK SET CREATE_BY = '".$this->input->post('USER_ID')."' WHERE SPU_ID = '".$this->input->post('SPU_ID')."' AND KODE_SAMPEL = '".$this->input->post('KODE_SAMPEL')."' AND CREATE_BY = '".$this->input->post('USER_IDX')."'");
							if($rs){
								$msgok .= '1 Data SPK untuk sampel tersebut berhasil diupdate';
								$hasil = TRUE;
							}
						}else{
							$msgok .= 'Tidak terdapat data SPK untuk sampel tersebut.';
							$hasil = TRUE;
						}
					}else{
						$hasil = FALSE;
					}
				}else{
					$hasil = FALSE;
				}
				if($hasil){
					return "MSG#YES#$msgok#SUKSES";
				}else{
					return "MSG#NO#$msgerr";
				}
			}
			else if($action == "update-status"){
				$hasil = FALSE;
				$msgok = "Update status SPU berhasil. \n";
				$msgerr = "Update status SPU gagal";
				$jml = (int)$sipt->main->get_uraian("SELECT COUNT(*) AS JML FROM T_M_SAMPEL WHERE SPU_ID = '".$this->input->post('spuid')."'","JML");
				$ret = $this->db->simple_query("UPDATE T_SPU SET STATUS = '".$this->input->post('status')."' WHERE SPU_ID = '".$this->input->post('spuid')."'");
				if($ret){
					$rsm = $this->db->simple_query("UPDATE T_M_SAMPEL SET STATUS_SAMPEL = '".$this->input->post('status')."' WHERE SPU_ID = '".$this->input->post('spuid')."'");
					if($rsm){
						$msgok .= "Terdapat ".$jml." sampel yang berhasil diupdate";
						$hasil = TRUE;
					}else{
						$hasil = TRUE;
					}
				}
				if($hasil){
					return "MSG#YES#$msgok#SUKSES";
				}else{
					return "MSG#NO#$msgerr";
				}
			}
			else if($action == "delete-spu"){
				foreach($this->input->post('tb_chk') as $chk){
					$sql = "SELECT SPU_ID, NOMOR_SPS, NOMOR_SP, TANGGAL, BBPOM_ID, ASAL_SAMPEL, TANGGAL_KIRIM, TTD_PEMDIK, TANGGAL_TERIMA_TPS, TTD_MA, TTD_MP, PETUGAS_PENERIMA, TANGGAL_PERINTAH, FL_KIMIA, FL_MIKRO, LABEL, SEGEL, JML_SPU, GET_DISPO, CREATE_BY, CREATE_DATE, UPDATE_BY, LAST_UPDATE, STATUS FROM T_SPU WHERE SPU_ID = '".$chk."'";
					$data = $sipt->main->get_result($sql);
					if($data){
						foreach($sql->result_array() as $row){
							$arrdel['SPU_ID'] = $row['SPU_ID'];
							$arrdel['NOMOR_SPS'] = $row['NOMOR_SPS'];
							$arrdel['NOMOR_SP'] = $row['NOMOR_SP'];
							$arrdel['TANGGAL'] = $row['TANGGAL'];
							$arrdel['BBPOM_ID'] = $row['BBPOM_ID'];
							$arrdel['ASAL_SAMPEL'] = $row['ASAL_SAMPEL'];
							$arrdel['TANGGAL_KIRIM'] = $row['TANGGAL_KIRIM'];
							$arrdel['TTD_PEMDIK'] = $row['TTD_PEMDIK'];
							$arrdel['TANGGAL_TERIMA_TPS'] = $row['TANGGAL_TERIMA_TPS'];
							$arrdel['TTD_MA'] = $row['TTD_MA'];
							$arrdel['TTD_MP'] = $row['TTD_MP'];
							$arrdel['PETUGAS_PENERIMA'] = $row['PETUGAS_PENERIMA'];
							$arrdel['TANGGAL_PERINTAH'] = $row['TANGGAL_PERINTAH'];
							$arrdel['FL_KIMIA'] = $row['FL_KIMIA'];
							$arrdel['FL_MIKRO'] = $row['FL_MIKRO'];
							$arrdel['LABEL'] = $row['LABEL'];
							$arrdel['SEGEL'] = $row['SEGEL'];
							$arrdel['JML_SPU'] = $row['JML_SPU'];
							$arrdel['GET_DISPO'] = $row['GET_DISPO'];
							$arrdel['CREATE_BY'] = $row['CREATE_BY'];
							$arrdel['CREATE_DATE'] = $row['CREATE_DATE'];
							$arrdel['UPDATE_BY'] = $row['UPDATE_BY'];
							$arrdel['LAST_UPDATE'] = $row['LAST_UPDATE'];
							$arrdel['STATUS'] = '00000';
							$this->db->insert('T_SPU_DELETE', $arrdel);
						}
					}
					$this->db->where('SPU_ID',$chk);
					if($this->db->delete('T_SPU')){
						#$this->db->where('SPU_ID', $chk);
						//$this->db->delete('T_SPU_LOG');
						$hasil = TRUE;
					}
				}
				if($hasil){
					return $ret = "MSG#SPU berhasil dihapus / dibatalakan#";
				}else{
					return $ret = "MSG#SPU gagal dihapus / dibatalkan";
				}
			}
			
		}
	}
	
	function get_headerspu($spuid){
		if((in_array('1', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('7', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('9', $this->newsession->userdata('SESS_KODE_ROLE'))) && $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$query = "SELECT A.SPU_ID, dbo.FORMAT_NOMOR('SPU',A.SPU_ID) AS UR_SPU, dbo.FORMAT_NOMOR('SPS',A.NOMOR_SPS) AS NOMOR_SPS, dbo.FORMAT_NOMOR('SP',A.NOMOR_SP) AS NOMOR_SP, CONVERT(VARCHAR(10), A.TANGGAL_TERIMA_TPS, 103) AS TANGGAL_TERIMA_TPS, CONVERT(VARCHAR(10), A.TANGGAL, 103) AS TANGGAL_SPU, CONVERT(VARCHAR(10), A.TANGGAL_PERINTAH,103) AS TANGGAL_PERINTAH, B.NAMA_BBPOM, C.NAMA_USER FROM T_SPU A LEFT JOIN M_BBPOM B ON A.BBPOM_ID = B.BBPOM_ID LEFT JOIN T_USER C ON A.TTD_MP = C.USER_ID WHERE A.SPU_ID = '".$spuid."'";
			$data = $sipt->main->get_result($query);
			if($data){
				foreach($query->result_array() as $row){
					$arrdata['sess'] = $row;
				}
				$arrdata['kabid'] = $this->db->query("SELECT DISTINCT A.USER_ID, B.NAMA_USER, B.JABATAN FROM T_SAMPEL_MT A LEFT JOIN T_USER B ON A.USER_ID = B.USER_ID WHERE A.SPU_ID = '".$spuid."'")->result_array();
				$arrdata['act'] = site_url().'/post/spu/spu_act/edit-header';
			}
			return $arrdata;
		}
	}
	
	function get_detil($id){
		if((in_array('1', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('7', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('9', $this->newsession->userdata('SESS_KODE_ROLE'))) && $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$query = "SELECT A.SPU_ID, dbo.FORMAT_NOMOR('SPU',A.SPU_ID) AS UR_SPU, dbo.FORMAT_NOMOR('SPS',A.NOMOR_SPS) AS NOMOR_SPS, dbo.FORMAT_NOMOR('SP',A.NOMOR_SP) AS NOMOR_SP, CONVERT(VARCHAR(10), A.TANGGAL, 103) AS TANGGAL_SPU, CONVERT(VARCHAR(10), A.TANGGAL_PERINTAH,103) AS TANGGAL_PERINTAH, B.NAMA_BBPOM, C.NAMA_USER, CASE WHEN LEN(LTRIM(RTRIM(A.STATUS))) < 2 THEN 'NVAL' END AS STATUS FROM T_SPU A LEFT JOIN M_BBPOM B ON A.BBPOM_ID = B.BBPOM_ID LEFT JOIN T_USER C ON A.TTD_MP = C.USER_ID WHERE A.SPU_ID = '".$id."'";
			$data = $sipt->main->get_result($query);
			if($data){
				foreach($query->result_array() as $row){
					$arrdata['sess'] = $row;
				}
				$arrdata['disposisi'] = $this->db->query("SELECT B.SPU_ID, B.KODE_SAMPEL, B.USER_ID, dbo.KATEGORI(A.KOMODITI,A.PRIORITAS) AS KOMODITI, dbo.FORMAT_NOMOR('SPL', A.KODE_SAMPEL) AS [KODE], A.NAMA_SAMPEL, C.NAMA_USER, dbo.URAIAN_M_TABEL('STATUS', B.STATUS) AS UR_STATUS
FROM T_M_SAMPEL A LEFT JOIN T_SAMPEL_MT B ON A.KODE_SAMPEL = B.KODE_SAMPEL
LEFT JOIN T_USER C ON B.USER_ID = C.USER_ID
WHERE B.SPU_ID = '".$id."' ORDER BY 6")->result_array();
				$arrdata['cbspu'] = $sipt->main->combobox("SELECT KODE, URAIAN FROM M_TABEL WHERE JENIS = 'STATUS' AND URAIAN_DETIL = 'Sampling'
AND KODE IN ('30106', '40106', '50201', '70000', '80201') ORDER BY 1","KODE","URAIAN", TRUE);
			}
			return $arrdata;
		}
	}
	
	function get_disposisi($id){
		if((in_array('1', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('7', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('9', $this->newsession->userdata('SESS_KODE_ROLE'))) && $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$id = explode("-",$id);
			$query = "SELECT B.SPU_ID, B.KODE_SAMPEL, B.USER_ID, dbo.KATEGORI(A.KOMODITI,A.PRIORITAS) AS KOMODITI, dbo.FORMAT_NOMOR('SPU',D.SPU_ID) AS UR_SPU, dbo.FORMAT_NOMOR('SPS',D.NOMOR_SPS) AS NOMOR_SPS, dbo.FORMAT_NOMOR('SP',D.NOMOR_SP) AS NOMOR_SP, CONVERT(VARCHAR(10), D.TANGGAL, 103) AS TANGGAL_SPU, CONVERT(VARCHAR(10), D.TANGGAL_PERINTAH,103) AS TANGGAL_PERINTAH, dbo.FORMAT_NOMOR('SPL', A.KODE_SAMPEL) AS [KODE], A.NAMA_SAMPEL, C.NAMA_USER, dbo.URAIAN_M_TABEL('STATUS', B.STATUS) AS UR_STATUS, D.BBPOM_ID FROM T_M_SAMPEL A LEFT JOIN T_SAMPEL_MT B ON A.KODE_SAMPEL = B.KODE_SAMPEL LEFT JOIN T_USER C ON B.USER_ID = C.USER_ID LEFT JOIN T_SPU D ON A.SPU_ID = D.SPU_ID WHERE B.SPU_ID = '".$id[0]."' AND B.KODE_SAMPEL = '".$id[1]."' AND B.USER_ID = '".$id[2]."'";
			$data = $sipt->main->get_result($query);
			if($data){
				foreach($query->result_array() as $row){
					$arrdata['sess'] = $row;
				}
				$arrdata['kabid'] = $this->db->query("SELECT DISTINCT A.USER_ID, B.NAMA_USER, B.JABATAN FROM T_SAMPEL_MT A LEFT JOIN T_USER B ON A.USER_ID = B.USER_ID WHERE A.SPU_ID = '".$id[0]."'")->result_array();
				if($this->newsession->userdata('SESS_BBPOM_ID') == "00")
					$arrdata['arrmt'] = $sipt->main->combobox("SELECT A.USER_ID, A.NAMA_USER +' - '+ A.JABATAN AS NAMA_USER FROM T_USER A LEFT JOIN T_USER_ROLE B ON A.USER_ID = B.USER_ID WHERE B.ROLE = '4' AND B.JENIS_PELAPORAN = '02' AND A.BBPOM_ID = '".$row['BBPOM_ID']."' GROUP BY A.USER_ID, A.NAMA_USER, A.JABATAN ORDER BY 2 ASC", "USER_ID", "NAMA_USER", TRUE);
				else
					$arrdata['arrmt'] = $sipt->main->combobox("SELECT A.USER_ID, A.NAMA_USER +' - '+ A.JABATAN AS NAMA_USER FROM T_USER A LEFT JOIN T_USER_ROLE B ON A.USER_ID = B.USER_ID WHERE B.ROLE = '4' AND B.JENIS_PELAPORAN = '02' AND A.BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' GROUP BY A.USER_ID, A.NAMA_USER, A.JABATAN ORDER BY 2 ASC", "USER_ID", "NAMA_USER", TRUE);
				$arrdata['act'] = site_url().'/post/spu/spu_act/edit-disposisi';
			}
			return $arrdata;
		}
	}
	
}	
?>