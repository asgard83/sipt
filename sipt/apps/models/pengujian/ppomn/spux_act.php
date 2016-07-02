<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR);
class Spux_act extends Model{
	function preview($id){
		if((in_array('2', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('3', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('4', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('6', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('7', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('8', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('11', $this->newsession->userdata('SESS_KODE_ROLE'))) && ($this->newsession->userdata('SESS_BBPOM_ID') == '99' && $this->newsession->userdata('LOGGED_IN') ==  TRUE)){
			$sipt =& get_instance();
			$this->load->model('main','main',TRUE);
			$this->load->library('newtable');
			$qspu = "SELECT SPU_ID, dbo.FORMAT_NOMOR('SPU', SPU_ID) AS FORMAT_SPU, CONVERT(VARCHAR(10), TANGGAL, 103) AS TANGGAL, CONVERT(VARCHAR(10), TANGGAL_TERIMA_TPS, 103) AS TANGGAL_TERIMA_TPS, PETUGAS_PENERIMA, dbo.URAIAN_M_TABEL('ANGGARAN_SAMPLING', SUBSTRING(SPU_ID, 7,2)) AS ANGGARAN, dbo.URAIAN_M_TABEL('ASAL_SAMPLING', ASAL_SAMPEL) AS [ASAL SAMPEL], dbo.KATEGORI(SUBSTRING(SPU_ID, 13,2)'0') AS KOMODITI, RTRIM(LTRIM(STATUS)) AS STATUS FROM T_SPU WHERE SPU_ID = '".$id."'";
			$rspu = $sipt->main->get_result($qspu);
			if($rspu){
				foreach($qspu->result_array() as $row){
					$arrdata = array('sess' => $row);
				}
				$arrdata['id'] = $row['SPU_ID'];
				$stts =  $row['STATUS'];
				$query = "SELECT A.PERIKSA_SAMPEL, A.KODE_SAMPEL, B.NOMOR_SURAT +'<div>Tanggal Terima : ' + CONVERT(VARCHAR(10), A.TANGGAL_SAMPLING, 120) + '</div><div>Asal Sampel : '+A.TEMPAT_SAMPLING+'</div>' AS [NOMOR SURAT / PENGANTAR], A.NAMA_SAMPEL + '<div>' + dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) + '</div><div>' + A.BENTUK_SEDIAAN + '</div><div>' + A.PABRIK + '</div><div>' + A.NOMOR_REGISTRASI + ', No Batch  : ' +  A.NO_BETS + '</div>' AS [IDENTITAS SAMPEL], CAST(A.JUMLAH_SAMPEL AS VARCHAR) +'&nbsp;'+ A.SATUAN +'<div>&bull;&nbsp;Uji Kimia : '+ CAST(A.JUMLAH_KIMIA AS VARCHAR)+'</div><div>&bull;&nbsp;Uji Mikro : '+CAST(A.JUMLAH_MIKRO AS VARCHAR) +'</div><div>&bull;&nbsp;Sisa Sampel : '+CAST(A.SISA AS VARCHAR) +'</div><div>' +CASE WHEN UJI_KIMIA = '1' AND UJI_MIKRO = '1' THEN 'Uji Kimia - Mikro' WHEN UJI_KIMIA = '1' THEN 'Uji Kimia' WHEN UJI_MIKRO = '1' THEN 'Uji Mikro' END+ '</div>' AS [JUMLAH UJI], dbo.KATEGORI(A.KOMODITI,A.PRIORITAS) + '<div>' + dbo.KATEGORI(A.KATEGORI,A.PRIORITAS) + '</div>' AS KOMODITI, dbo.URAIAN_M_TABEL('STATUS', A.STATUS_SAMPEL) AS [STATUS] FROM T_M_SAMPEL A LEFT JOIN T_PERIKSA_SAMPEL B ON A.PERIKSA_SAMPEL = B.PERIKSA_SAMPEL WHERE A.SPU_ID = '".$id."'";
				$this->newtable->hiddens(array('PERIKSA_SAMPEL','KODE_SAMPEL'));
				$this->newtable->search(array(array("B.NOMOR_SURAT", "Nomor Surat Tugas / Pengantar"),array("CONVERT(VARCHAR(10), A.TANGGAL_SAMPLING, 120)", "Tanggal Terima"),array("dbo.URAIAN_M_TABEL('ASAL_SAMPLING', A.ASAL_SAMPEL)", "Asal Sampel"),array("A.NAMA_SAMPEL","Nama Sampel"),array("dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL)","Kode Sampel"),array("A.TEMPAT_SAMPLING","Tempat Sampling"),array("dbo.KATEGORI(A.KOMODITI,A.PRIORITAS)","Komoditi"),array("dbo.KATEGORI(A.KATEGORI,A.PRIORITAS)","Kategori"),array("dbo.URAIAN_M_TABEL('STATUS', A.STATUS_SAMPEL)","Status / Proses Sampel")));
				$this->newtable->columns(array("A.PERIKSA_SAMPEL", "A.KODE_SAMPEL", "B.NOMOR_SURAT +'<div>Tanggal Terima : ' + CONVERT(VARCHAR(10), A.TANGGAL_SAMPLING, 120) + '</div><div>Asal Sampel : '+A.TEMPAT_SAMPLING+'</div>'",array("A.NAMA_SAMPEL + '<div>' + dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) + '</div><div>' + A.BENTUK_SEDIAAN + '</div><div>' + A.PABRIK + '</div><div>' + A.NOMOR_REGISTRASI + ', No Batch  : ' +  A.NO_BETS + '</div>'",site_url().'/home/ppomn/sampelx/preview/{PERIKSA_SAMPEL}.{KODE_SAMPEL}'),"CAST(A.JUMLAH_SAMPEL AS VARCHAR) +'&nbsp;'+ A.SATUAN +'<div>&bull;&nbsp;Uji Kimia : '+ CAST(A.JUMLAH_KIMIA AS VARCHAR)+'</div><div>&bull;&nbsp;Uji Mikro : '+CAST(A.JUMLAH_MIKRO AS VARCHAR) +'</div><div>&bull;&nbsp;Sisa Sampel : '+CAST(A.SISA AS VARCHAR) +'</div><div>' +CASE WHEN UJI_KIMIA = '1' AND UJI_MIKRO = '1' THEN 'Uji Kimia - Mikro' WHEN UJI_KIMIA = '1' THEN 'Uji Kimia' WHEN UJI_MIKRO = '1' THEN 'Uji Mikro' END+ '</div>'","dbo.KATEGORI(A.KOMODITI,A.PRIORITAS) + '<div>' + dbo.KATEGORI(A.KATEGORI,A.PRIORITAS) + '</div>'","dbo.URAIAN_M_TABEL('STATUS', A.STATUS_SAMPEL)"));
				$this->newtable->width(array('NOMOR SURAT / PENGANTAR' => 200,'IDENTITAS SAMPEL' => 225, 'JUMLAH UJI' => 85, 'KOMODITI' => 75, 'STATUS' => 105));
				$this->newtable->action(site_url()."/home/ppomn/spux/preview/".$id);
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
				$arrdata['disverifikasi'] = $row['STATUS'];
				$arrdata['showjml'] = $sipt->main->get_uraian("SELECT COUNT(JML) AS JML FROM (SELECT DISTINCT(STATUS_SAMPEL) AS JML FROM T_M_SAMPEL WHERE SPU_ID = '".$id."') AS DATA","JML");
				$arrdata['act'] = site_url().'/post/ppomn/spux_act/verifikasi';
				$arrdata['chkmikro'] = $sipt->main->get_uraian("SELECT COUNT(UJI_MIKRO) AS JML FROM T_M_SAMPEL WHERE SPU_ID = '".$id."' AND UJI_MIKRO = '1'","JML");
				$allowed = $sipt->main->get_uraian("SELECT GET_DISPO FROM T_SPU WHERE SPU_ID = '".$id."'","GET_DISPO");
				$arrdata['kabalai'] = explode("|", $sipt->main->get_uraian("SELECT NAMA_USER +'|'+ USER_ID AS KABALAI FROM T_USER WHERE
USER_ID IN (SELECT USER_ID FROM T_USER_ROLE WHERE ROLE IN ('6')) AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND STATUS = 'Aktif'","KABALAI"));
				if(in_array('B5',$this->newsession->userdata('SESS_SUB_SARANA'))){
					if($allowed == "2")
					$arrdata['allowed'] = FALSE;
					else
					$arrdata['allowed'] = TRUE;
					$arrdata['get_dispo'] = 1;
				}else{
					$arrdata['allowed'] = TRUE;
					$arrdata['get_dispo'] = 0;
				}
			}		
			return $arrdata;
		}
	}


	function list_spu($menu){
		if((in_array('11', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('7', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('5', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('4', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('3', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('2', $this->newsession->userdata('SESS_KODE_ROLE'))) && ($this->newsession->userdata('SESS_BBPOM_ID') == '99' && $this->newsession->userdata('LOGGED_IN') ==  TRUE)){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$this->load->library('newtable');
			$tmp = "";
			foreach($this->newsession->userdata('SESS_KLASIFIKASI_ID') as $komoditi){
				$tmp  .= "'".substr($komoditi,-2). "',";
			}
			$komoditi = substr($tmp,0,-1);
			
			if($menu == "konsep"){
				$judul = "Draft Konsep SPU";
				if(in_array('B5', $this->newsession->userdata('SESS_SUB_SARANA')))
				$status = " AND STATUS IN ('40201') AND SPU_ID IN (SELECT SPU_ID FROM T_M_SAMPEL WHERE KOMODITI IN ($komoditi)) AND GET_DISPO = '1'";
				else
				$status = " AND STATUS IN ('11001') AND SPU_ID IN (SELECT SPU_ID FROM T_M_SAMPEL WHERE KOMODITI IN ($komoditi))";
			}else if($menu == "all"){
				$judul = "Data Konsep SPU";
				
				if(in_array('B5', $this->newsession->userdata('SESS_SUB_SARANA')))
				$status = " AND STATUS NOT IN ('11001','70001') AND SPU_ID IN (SELECT SPU_ID FROM T_M_SAMPEL WHERE KOMODITI IN ($komoditi)) AND GET_DISPO <> '1'";
				else
				$status = " AND STATUS NOT IN ('11001','70001') AND SPU_ID IN (SELECT SPU_ID FROM T_M_SAMPEL WHERE KOMODITI IN ($komoditi))";
			}
			
			$query = "SELECT SPU_ID, STATUS, dbo.FORMAT_NOMOR('SPU', SPU_ID) AS [NOMOR SPU], dbo.FORMAT_NOMOR('SPS', NOMOR_SPS) AS [NOMOR SPS],
dbo.KATEGORI(SUBSTRING(SPU_ID, 13,2),'0') AS [KOMODITI], dbo.URAIAN_M_TABEL('ASAL_SAMPLING', ASAL_SAMPEL) AS [ASAL SAMPEL], CONVERT(VARCHAR(10), TANGGAL_TERIMA_TPS, 120) AS [TANGGAL TERIMA] FROM T_SPU WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' $status";
			$this->newtable->columns(array("SPU_ID", "STATUS", array("dbo.FORMAT_NOMOR('SPU', SPU_ID)",site_url()."/home/ppomn/spux/preview/{SPU_ID}.{STATUS}"), "dbo.FORMAT_NOMOR('SPS', NOMOR_SPS)","dbo.KATEGORI(SUBSTRING(SPU_ID, 13,2),'0')", "dbo.URAIAN_M_TABEL('ASAL_SAMPLING', ASAL_SAMPEL)", "CONVERT(VARCHAR(10), TANGGAL_TERIMA_TPS, 120)"));
			$this->newtable->action(site_url()."/home/ppomn/spux/".$menu);
			$this->newtable->search(array(array("dbo.FORMAT_NOMOR('SPU',SPU_ID)", "Nomor SPU"),array("CONVERT(VARCHAR(10), TANGGAL_TERIMA_TPS, 120)","Tanggal Terima"),array("dbo.URAIAN_M_TABEL('ASAL_SAMPLING', ASAL_SAMPEL) AS [ASAL SAMPEL]","Asam Sampel"),array("dbo.KATEGORI(SUBSTRING(SPU_ID, 13,2),'0')","Komoditi")));
			$this->newtable->width(array('NOMOR SPU' => 125, 'NOMOR SPS' => 125, 'ASAL SAMPEL' => 200, 'TANGGAL TERIMA' => 100));
			$this->newtable->cidb($this->db);
			$this->newtable->ciuri($this->uri->segment_array());
			$this->newtable->orderby(1);
			$this->newtable->sortby("ASC");
			$this->newtable->hiddens(array('SPU_ID','STATUS'));
			$this->newtable->keys(array('SPU_ID','STATUS'));
			$proses['Preview Data'] = array('GET', site_url()."/home/ppomn/spux/preview", '1');
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
					$query = "SELECT SPU_ID, dbo.FORMAT_NOMOR('SPU',SPU_ID) +'<div>'+ CONVERT(VARCHAR(10), TANGGAL, 120) +'</div>' AS [NOMOR & TANGGAL], dbo.URAIAN_M_TABEL('ANGGARAN_SAMPLING', SUBSTRING(SPU_ID, 7,2)) +'<div>'+ dbo.URAIAN_M_TABEL('ASAL_SAMPLING', ASAL_SAMPEL) +'</div>' AS [ANGGARAN & ASAL SAMPEL], dbo.KATEGORI(SUBSTRING(SPU_ID, 13,2),'0') AS [KOMODITI], dbo.TOTAL_SAMPEL(SPU_ID) AS [TOTAL SAMPEL], dbo.URAIAN_M_TABEL('STATUS',STATUS) AS STATUS, CONVERT(VARCHAR(10), LAST_UPDATE, 120) AS [UPDATE TERAKHIR] FROM T_SPU WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND STATUS = '70000' AND ASAL_SAMPEL IN ('10','11','12')";
					$this->newtable->columns(array("SPU_ID", array("dbo.FORMAT_NOMOR('SPU',SPU_ID) +'<div>'+ CONVERT(VARCHAR(10), TANGGAL, 120) +'</div>'",site_url()."/home/spu/preview/{SPU_ID}"), "dbo.URAIAN_M_TABEL('ANGGARAN_SAMPLING', SUBSTRING(SPU_ID, 7,2)) +'<div>'+ dbo.URAIAN_M_TABEL('ASAL_SAMPLING', ASAL_SAMPEL)+'</div>'","dbo.KATEGORI(SUBSTRING(SPU_ID, 13,2),'0')","dbo.TOTAL_SAMPEL(SPU_ID)", "dbo.URAIAN_M_TABEL('STATUS',STATUS)","CONVERT(VARCHAR(10), LAST_UPDATE, 120)"));
					$this->newtable->search(array(array("dbo.FORMAT_NOMOR('SPU',SPU_ID)", "Nomor Surat Permintaan Uji"),array("CONVERT(VARCHAR(10), TANGGAL, 120)","Tanggal Surat"),array("dbo.URAIAN_M_TABEL('ANGGARAN_SAMPLING', SUBSTRING(SPU_ID, 7,2))","Anggaran Sampel"),array("dbo.URAIAN_M_TABEL('ASAL_SAMPLING', ASAL_SAMPEL)","Asal Sampel"),array("dbo.KATEGORI(SUBSTRING(SPU_ID, 13,2),'0')","Komoditi"),array("dbo.URAIAN_M_TABEL('STATUS',STATUS)","Status SPU"), array("CONVERT(VARCHAR(10), LAST_UPDATE, 120)","Update Terakhir")));
					$this->newtable->width(array('NOMOR & TANGGAL' => 125, 'ANGGARAN & ASAL SAMPEL' => 200, 'KOMODITI' => 75,'TOTAL SAMPEL' => 50, 'STATUS' => 150, 'UPDATE TERAKHIR' => 80));
					$this->newtable->orderby(7);
					
				}else{
					if($submenu == "all"){
						$judul = "Daftar Surat Permintaan Uji";
						$q = "AND STATUS IN ('80291','40201')";
						$proses['Detail SPU dan SPS'] = array('GET', site_url()."/home/ppomn/sps/view", '1');
						$proses['Cetak Surat Perintah Uji dan SPS'] = array('GETNEW', site_url()."/topdf/ppomn/cetak/sps", '1');
					}else if($submenu == "sp"){
						$judul = "Daftar Surat Permintaan Uji - Disposisi Perintah Uji";
						$q = "AND STATUS IN ('50201')";
					}
					$query = "SELECT SPU_ID, dbo.FORMAT_NOMOR('SPU',SPU_ID) +'<div>'+ CONVERT(VARCHAR(10), TANGGAL, 120) +'</div>' AS [NOMOR & TANGGAL SPU], dbo.FORMAT_NOMOR('SPS',NOMOR_SPS) +'<div>'+ CONVERT(VARCHAR(10), TANGGAL_TERIMA_TPS, 120) +'</div>' AS [NOMOR & TANGGAL SPS], dbo.URAIAN_M_TABEL('ANGGARAN_SAMPLING', SUBSTRING(SPU_ID, 7,2)) +'<div>'+ dbo.URAIAN_M_TABEL('ASAL_SAMPLING', ASAL_SAMPEL) +'</div>' AS [ANGGARAN & ASAL SAMPEL], dbo.KATEGORI(SUBSTRING(SPU_ID, 13,2),'0') AS [KOMODITI], dbo.TOTAL_SAMPEL(SPU_ID) AS [TOTAL SAMPEL], 
					dbo.URAIAN_M_TABEL('STATUS',STATUS)  + (CASE WHEN STATUS = '40201' THEN dbo.VIEW_MT(SPU_ID) ELSE '<div style=\"color:#FFF; font-weight:bold; background:#CE0000; padding:2px;\">Belum dikirim ke Bidang Pengujian</div>' END) AS STATUS,
					CONVERT(VARCHAR(10), LAST_UPDATE, 120) AS [UPDATE TERAKHIR] FROM T_SPU WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' $q AND ASAL_SAMPEL IN ('10','11','12')";
					$this->newtable->columns(array("SPU_ID", array("dbo.FORMAT_NOMOR('SPU',SPU_ID) +'<div>'+ CONVERT(VARCHAR(10), TANGGAL, 120) +'</div>'",site_url()."/home/ppomn/spux/preview/{SPU_ID}"), "dbo.FORMAT_NOMOR('SPS',NOMOR_SPS) +'<div>'+ CONVERT(VARCHAR(10), TANGGAL_TERIMA_TPS, 120) +'</div>'", "dbo.URAIAN_M_TABEL('ANGGARAN_SAMPLING', SUBSTRING(SPU_ID, 7,2)) +'<div>'+ dbo.URAIAN_M_TABEL('ASAL_SAMPLING', ASAL_SAMPEL)+'</div>'","dbo.KATEGORI(SUBSTRING(SPU_ID, 13,2),'0')","dbo.TOTAL_SAMPEL(SPU_ID)", "dbo.URAIAN_M_TABEL('STATUS',STATUS)  + (CASE WHEN STATUS = '40201' THEN dbo.VIEW_MT(SPU_ID) ELSE '<div style=\"color:#FFF; font-weight:bold; background:#CE0000; padding:2px;\">Belum dikirim ke Bidang Pengujian</div>' END)","CONVERT(VARCHAR(10), LAST_UPDATE, 120)"));
					$this->newtable->search(array(array("dbo.FORMAT_NOMOR('SPU',SPU_ID)", "Nomor Surat Permintaan Uji"),array("CONVERT(VARCHAR(10), TANGGAL, 120)","Tanggal Surat"),array("dbo.FORMAT_NOMOR('SPS',NOMOR_SPS)", "Nomor Surat Penyerahan Sampel"),array("CONVERT(VARCHAR(10), TANGGAL_TERIMA_TPS, 120)","Tanggal Penerimaan Sampel"), array("dbo.URAIAN_M_TABEL('ANGGARAN_SAMPLING', SUBSTRING(SPU_ID, 7,2))","Anggaran Sampel"),array("dbo.URAIAN_M_TABEL('ASAL_SAMPLING', ASAL_SAMPEL)","Asal Sampel"),array("dbo.KATEGORI(SUBSTRING(SPU_ID, 13,2),'0')","Komoditi"),array("CONVERT(VARCHAR(10), LAST_UPDATE, 120)","Update Terakhir")));
					$this->newtable->width(array('NOMOR & TANGGAL SPU' => 125, 'NOMOR & TANGGAL SPS' => 125, 'ANGGARAN & ASAL SAMPEL' => 200, 'KOMODITI' => 75,'TOTAL SAMPEL' => 50, 'STATUS' => 150, 'UPDATE TERAKHIR' => 90));
					$this->newtable->orderby(8);
				}
			}else if(in_array('8', $this->newsession->userdata('SESS_KODE_ROLE'))){
				$judul = "Daftar Surat Permintaan Uji - Verifikasi Penyerahan Sampel";
				if($submenu == "verifikasi"){
					$query = "SELECT SPU_ID, dbo.FORMAT_NOMOR('SPU',SPU_ID) +'<div>'+ CONVERT(VARCHAR(10), TANGGAL, 120) +'</div>' AS [NOMOR & TANGGAL SPU], dbo.FORMAT_NOMOR('SPS',NOMOR_SPS) +'<div>'+ CONVERT(VARCHAR(10), TANGGAL_TERIMA_TPS, 120) +'</div>' AS [NOMOR & TANGGAL SPS], dbo.URAIAN_M_TABEL('ANGGARAN_SAMPLING', SUBSTRING(SPU_ID, 7,2)) +'<div>'+ dbo.URAIAN_M_TABEL('ASAL_SAMPLING', ASAL_SAMPEL) +'</div>' AS [ANGGARAN & ASAL SAMPEL], dbo.KATEGORI(SUBSTRING(SPU_ID, 13,2),'0') AS [KOMODITI], dbo.TOTAL_SAMPEL(SPU_ID) AS [TOTAL SAMPEL], dbo.URAIAN_M_TABEL('STATUS',STATUS) AS STATUS FROM T_SPU WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND STATUS = '80291' AND ASAL_SAMPEL IN ('10','11','12')";
				}else{
					$query = "SELECT SPU_ID, dbo.FORMAT_NOMOR('SPU',SPU_ID) +'<div>'+ CONVERT(VARCHAR(10), TANGGAL, 120) +'</div>' AS [NOMOR & TANGGAL SPU], dbo.FORMAT_NOMOR('SPS',NOMOR_SPS) +'<div>'+ CONVERT(VARCHAR(10), TANGGAL_TERIMA_TPS, 120) +'</div>' AS [NOMOR & TANGGAL SPS], dbo.URAIAN_M_TABEL('ANGGARAN_SAMPLING', SUBSTRING(SPU_ID, 7,2)) +'<div>'+ dbo.URAIAN_M_TABEL('ASAL_SAMPLING', ASAL_SAMPEL) +'</div>' AS [ANGGARAN & ASAL SAMPEL], dbo.KATEGORI(SUBSTRING(SPU_ID, 13,2),'0') AS [KOMODITI], dbo.TOTAL_SAMPEL(SPU_ID) AS [TOTAL SAMPEL], dbo.URAIAN_M_TABEL('STATUS',STATUS) AS STATUS FROM T_SPU WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND STATUS IN ('50201') AND ASAL_SAMPEL IN ('10','11','12')";
				}
				$this->newtable->columns(array("SPU_ID", array("dbo.FORMAT_NOMOR('SPU',SPU_ID) +'<div>'+ CONVERT(VARCHAR(10), TANGGAL, 120) +'</div>'",site_url()."/home/ppomn/spux/preview/{SPU_ID}"), "dbo.FORMAT_NOMOR('SPS',NOMOR_SPS) +'<div>'+ CONVERT(VARCHAR(10), TANGGAL_TERIMA_TPS, 120) +'</div>'", "dbo.URAIAN_M_TABEL('ANGGARAN_SAMPLING', SUBSTRING(SPU_ID, 7,2)) +'<div>'+ dbo.URAIAN_M_TABEL('ASAL_SAMPLING', ASAL_SAMPEL)+'</div>'","dbo.KATEGORI(SUBSTRING(SPU_ID, 13,2),'0')","dbo.TOTAL_SAMPEL(SPU_ID)", "dbo.URAIAN_M_TABEL('STATUS',STATUS)"));
				$this->newtable->search(array(array("dbo.FORMAT_NOMOR('SPU',SPU_ID)", "Nomor Surat Permintaan Uji"),array("CONVERT(VARCHAR(10), TANGGAL, 120)","Tanggal Surat"),array("dbo.FORMAT_NOMOR('SPS',NOMOR_SPS)", "Nomor Surat Penyerahan Sampel"),array("CONVERT(VARCHAR(10), TANGGAL_TERIMA_TPS, 120)","Tanggal Penerimaan Sampel"), array("dbo.URAIAN_M_TABEL('ANGGARAN_SAMPLING', SUBSTRING(SPU_ID, 7,2))","Anggaran Sampel"),array("dbo.URAIAN_M_TABEL('ASAL_SAMPLING', ASAL_SAMPEL)","Asal Sampel"),array("dbo.KATEGORI(SUBSTRING(SPU_ID, 13,2),'0')","Komoditi"),array("dbo.URAIAN_M_TABEL('STATUS',STATUS)","Status SPU")));
				$this->newtable->width(array('NOMOR & TANGGAL SPU' => 125, 'NOMOR & TANGGAL SPS' => 125, 'ANGGARAN & ASAL SAMPEL' => 200, 'KOMODITI' => 75,'TOTAL SAMPEL' => 50, 'STATUS' => 150));
			}
			$this->newtable->action(site_url()."/home/spsx/list/".$submenu);
			$this->newtable->cidb($this->db);
			$this->newtable->ciuri($this->uri->segment_array());
			$this->newtable->orderby(1);
			$this->newtable->sortby("ASC");
			$this->newtable->hiddens(array('SPU_ID'));
			$this->newtable->keys(array('SPU_ID'));
			$proses['Preview Data'] = array('GET', site_url()."/home/ppomn/spux/preview", '1');
			if(in_array('7',$this->newsession->userdata('SESS_KODE_ROLE'))){
				if($submenu == "sp"){
					$proses['Cetak Data Permintaan Uji'] = array('GETNEW', site_url()."/topdf/ppomn/cetak/spu", '1');
					$proses['Tambah Surat Perintah Uji'] = array('GET', site_url()."/home/ppomn/pengujian/spu", '1');
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
		if((in_array('7', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('8', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('11', $this->newsession->userdata('SESS_KODE_ROLE'))) && $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			if($action=="save"){
				$hasil = FALSE;
				$msgok = "Draft Konsep SPU berhasil disimpan";
				$msgerr = "Draft Konsep SPU gagal disimpan";
				$kode = explode(",",$this->input->post('KODE_SAMPEL'));
				$komoditi = $this->input->post('KOMODITI');
				$anggaran = $this->input->post('ANGGARAN');
				$dtspu = $sipt->main->post_to_query($this->input->post('SPU'));
				//$dtspu['SPU_ID'] = $sipt->main->set_kode_spu($anggaran,$komoditi);
				
				$chk = (int)$sipt->main->get_uraian("SELECT AUTO_RESET FROM M_REF_SPU WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND ANGGARAN = '".$anggaran."' AND KOMODITI = '".$komoditi."'","AUTO_RESET");
				if($chk == 1)
					$dtspu['SPU_ID'] = $sipt->main->set_kode_spu($anggaran,$komoditi);
				else
					$dtspu['SPU_ID'] = $sipt->main->set_kode_spu($anggaran,$komoditi,$dtspu['TANGGAL']);
					
				$chk2 = (int)$sipt->main->get_uraian("SELECT AUTO_RESET FROM M_REF_SP WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND KOMODITI = '".$komoditi."'","AUTO_RESET");
				if($chk2 == 1){
					$dtspu['NOMOR_SP'] = $sipt->main->set_kode_sp($komoditi,date("d").date("m").substr(date("Y"),2,4));
				}else{
					$arrdmy = explode("/",$dtspu['TANGGAL']);
					$dmy = $arrdmy[0].$arrdmy[1].substr($arrdmy[2],2,4);
					$dtspu['NOMOR_SP'] = $sipt->main->set_kode_sp($komoditi,$dmy);
				}
				
				
				$dtspu['BBPOM_ID'] = $this->newsession->userdata('SESS_BBPOM_ID');
				$dtspu['ASAL_SAMPEL'] = $this->input->post('ASAL_SAMPEL');
				$dtspu['CREATE_BY'] = $this->newsession->userdata('SESS_USER_ID');
				$dtspu['CREATE_DATE'] = 'GETDATE()';
				$dtspu['UPDATE_BY'] = $this->newsession->userdata('SESS_USER_ID');
				$dtspu['LAST_UPDATE'] = 'GETDATE()';
				$dtspu['STATUS'] = '80291';
				$dtspu['NOMOR_SPS'] = str_replace("SPU","SPS",$dtspu['SPU_ID']);
				$dtspu['TANGGAL_TERIMA_TPS'] = $dtspu['TANGGAL'];
				$dtspu['PETUGAS_PENERIMA'] = $this->newsession->userdata('SESS_USER_ID');
				$dtspu['LAST_UPDATE'] = 'GETDATE()';
				$dtspu['JML_SPU'] = count($arr_petugas);
				$dtspu['TANGGAL_KIRIM'] = 'GETDATE()';
				if($dtspu['TANGGAL_PERINTAH'] == "") $dtspu['TANGGAL_PERINTAH'] = null;
				if($this->db->insert('T_SPU',$dtspu)){
					$sipt->main->set_max('spu',$komoditi);
					$hasil = TRUE;
					$logspu = array('SPU_ID' => $dtspu['SPU_ID'],
									'WAKTU' => 'GETDATE()',
									'USER_ID' => $this->newsession->userdata('SESS_USER_ID'),
									'KEGIATAN' => 'Simpan data Surat Permintaan Uji : '.$dtspu['SPU_ID'],
									'CATATAN' => 'Kode sampel : '.str_replace("'","",$this->input->post('KODE_SAMPEL')));
					$this->db->insert('T_SPU_LOG', $logspu);
					foreach($kode as $a){
						$this->db->simple_query("UPDATE T_M_SAMPEL SET SPU_ID ='".$dtspu['SPU_ID']."', STATUS_SAMPEL = '80291' WHERE KODE_SAMPEL = '".str_replace("'","",$a)."'");
						$logsampel = array('KODE_SAMPEL' => str_replace("'","",$a),
										   'WAKTU' => 'GETDATE()',
										   'USER_ID' => $this->newsession->userdata('SESS_USER_ID'),
										   'KEGIATAN' => 'Berhasil ditambahkan ke data SPU',
										   'CATATAN' => 'Nomor SPU : '.$dtspu['SPU_ID']);
						$this->db->insert('T_SAMPLING_LOG', $logsampel);
					}
				}
				if($hasil){
					return "MSG#YES#$msgok.#".site_url().'/home/sampelx/list/all';
				}else{
					return "MSG#NO#$msgerror";
				}
				
				if($isajax!="ajax"){
					redirect(base_url());
					exit();
				}
			}else if($action == "verifikasi"){
				$hasil = FALSE;
				$msgok = "Permintaan uji berhasil di verifikasi";
				$msgerr = "Permintaan uji gagal di verifikasi, Silahkan coba lagi";
				$sebelum = $sipt->main->get_uraian("SELECT STATUS FROM T_SPU WHERE SPU_ID = '".$this->input->post('SPU_ID')."'","STATUS");
				$sesudah = $sipt->main->get_uraian("SELECT SESUDAH FROM M_VERIFIKASI WHERE PELAPORAN_ID = '02' AND SEBELUM = '".$sebelum."' AND PROSES = '1'","SESUDAH");
				$sql = "SET DATEFORMAT DMY UPDATE T_SPU SET STATUS = '".$sesudah."', TTD_MA = '".$this->newsession->userdata('SESS_USER_ID')."', TTD_MP = '".$this->input->post('TTD_MP')."', TANGGAL_PERINTAH= GETDATE(), UPDATE_BY = '".$this->newsession->userdata('SESS_USER_ID')."', LAST_UPDATE = GETDATE() WHERE SPU_ID = '".$this->input->post('SPU_ID')."'";
				$this->db->simple_query($sql);
				$kegiatan = 'Verifikasi Penerimaan Sampel - Surat Permintaan Uji : '.$this->input->post('SPU_ID');
				$res = $this->db->simple_query("UPDATE T_M_SAMPEL SET STATUS_SAMPEL = '".$sesudah."' WHERE SPU_ID ='".$this->input->post('SPU_ID')."'");
				$logspu = array('SPU_ID' => $this->input->post('SPU_ID'),
								'WAKTU' => 'GETDATE()',
								'USER_ID' => $this->newsession->userdata('SESS_USER_ID'),
								'KEGIATAN' => $kegiatan,
								'CATATAN' => $this->input->post('catatan'));
				$this->db->insert('T_SPU_LOG', $logspu);
				if($res){
					$hasil = TRUE;
				}
				
				if($hasil){
					if(in_array('8',$this->newsession->userdata('SESS_KODE_ROLE')))
					return "MSG#YES#$msgok#".site_url().'/home/ppomn/spsx/list/all';
					else
					return "MSG#YES#$msgok#".site_url().'/home/ppomn/spux/list/all';
				}else{
					return "MSG#YES#$msgerr";
				}
				if($isajax!="ajax"){
					redirect(base_url());
					exit();
				}

			}
			/*else if($action=="verifikasi"){
				$hasil = FALSE;
				$msgok = "Permintaan uji berhasil di verifikasi";
				$msgerr = "Permintaan uji gagal di verifikasi, Silahkan coba lagi";
				$cek = $sipt->main->get_uraian("SELECT COUNT(JML) AS JML FROM (SELECT DISTINCT(STATUS_SAMPEL) AS JML FROM T_M_SAMPEL WHERE SPU_ID = '".$this->input->post('SPU_ID')."') AS DATA","JML");
				if($cek > 1){
					return "MSG#NO#Harap dipastikan bahwa semua status proses sampel tidak ada yang ditolak.\n Hal ini untuk menghindari sampel yang akan dikirim ke bidang pengujian,\n benar-benar tidak ada kesalahan secara administrasi ataupun data.\n Agar dengan segera melakukan konfirmasi data kepada pengirim sampel.";
					die();
				}else{
					$catatan = $this->input->post('catatan');
					$kegiatan = 'Verifikasi data Surat Permintaan Uji : '.$this->input->post('SPU_ID');
					if($this->input->post('GET_DISPO') == "1")
						$this->db->simple_query("SET DATEFORMAT DMY UPDATE T_SPU SET STATUS ='".$this->input->post('STATUS')."', UPDATE_BY = '".$this->newsession->userdata('SESS_USER_ID')."', LAST_UPDATE = GETDATE(), GET_DISPO = '2' WHERE SPU_ID = '".$this->input->post('SPU_ID')."'");
					else
						$this->db->simple_query("SET DATEFORMAT DMY UPDATE T_SPU SET STATUS ='".$this->input->post('STATUS')."', TANGGAL_KIRIM = GETDATE(), UPDATE_BY = '".$this->newsession->userdata('SESS_USER_ID')."', LAST_UPDATE = GETDATE() WHERE SPU_ID = '".$this->input->post('SPU_ID')."'");
					$res = $this->db->simple_query("UPDATE T_M_SAMPEL SET STATUS_SAMPEL = '".$this->input->post('STATUS')."' WHERE SPU_ID ='".$this->input->post('SPU_ID')."' AND STATUS_SAMPEL <> '70001'");
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
					if(in_array('11',$this->newsession->userdata('SESS_KODE_ROLE')))
					return "MSG#YES#$msgok#".site_url().'/home/ppomn/spux/all';
					else
					return "MSG#YES#$msgok#".site_url().'/home/ppomn/spsx/all';
				}else{
					return "MSG#YES#$msgerr";
				}
				if($isajax!="ajax"){
					redirect(base_url());
					exit();
				}
			}*/
		}
	}
	
}	
?>