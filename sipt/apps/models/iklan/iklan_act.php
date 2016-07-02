<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
error_reporting(E_ERROR);

class iklan_act extends Model {

    function getFormIklanAwal() {
	if ($this->newsession->userdata('LOGGED_IN') == TRUE) {
	    $sipt = & get_instance();
	    $this->load->model("main", "main", true);
	    $disinput = array("JENISDIS", "NAMADIS");
	    $media = $sipt->main->get_jenis_sarana($this->newsession->userdata("SESS_USER_ID"), $disinput);
	    $komoditi = "'" . join("','", $this->newsession->userdata("SESS_KLASIFIKASI_ID")) . "'";
	    $arrayClause = array('demo_1', 'demo_2', 'demo_3', 'demo_4', 'operator-pusat', '1001', '1002', '1003', '1004', '1005', '1006');
	    if (in_array($this->newsession->userdata("SESS_USER_ID"), $arrayClause))
		$klasifikasi = $sipt->main->combobox("SELECT * FROM M_KLASIFIKASI_KATEGORI WHERE LEN(KK_ID) = 3 AND KK_ID IN ($komoditi)", "KK_ID", "NAMA_KK", TRUE);
	    else
		$klasifikasi = $sipt->main->combobox("SELECT * FROM M_KLASIFIKASI_KATEGORI WHERE LEN(KK_ID) = 3 AND KK_ID IN ('001')", "KK_ID", "NAMA_KK", TRUE);
	    $arrdata = array('act' => site_url() . '/iklan/iklanController/setSurat/pemantauan', 'media' => $media, 'disinput' => $disinput, 'klasifikasi' => $klasifikasi, 'selklasifikasi' => '', 'act' => site_url() . '/iklan/iklanController/setSurat/pengawasan', 'batal' => site_url() . '/home/iklan/PengawasanIklan', 'browse' => site_url() . '/load/master/list_sarana');
	    return $arrdata;
	} else {
	    $this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.', '/home');
	}
    }

    function getListFormIklan($jenisPelaporan = "", $user = "") {
	if ($this->newsession->userdata('LOGGED_IN') == TRUE) {
	    $sipt = & get_instance();
	    $this->load->model("main", "main", true);
	    $sipt->load->model('iklan/iklan_act');
	    $hasilAkhir = "(CASE WHEN dbo.GET_DATA_FROM_IKLAN(TI.IKLAN_ID) = 'MK' THEN 'Memenuhi Ketentuan' ELSE 'Tidak Memenuhi Ketentuan' END)";
	    $created = "AND TIP.SERI = (SELECT MAX (SERI) AS SERI FROM T_IKLAN_PROSES WHERE IKLAN_ID = TI.IKLAN_ID AND TI.USER_LAST_UPDATE = TIP.CREATEDBY)";
	    if ($jenisPelaporan == "1101") {
		$jenis = '1';
		$jenisTxt = 'draft';
		$proses['Proses Data Pengawasan'] = array('GET', site_url() . "/iklan/iklanController/prosesPreview/preview", '1');
	    }
	    if ($jenisPelaporan == "0101") {
		$jenis = '2';
		$jenisTxt = 'draft';
	    }
	    if ($jenisPelaporan == "0303") {
		$jenis = '4';
		$jenisTxt = 'draft';
		$proses['Proses Data Pengawasan'] = array('GET', site_url() . "/iklan/iklanController/prosesPreview/preview", '1');
	    }
	    if ($jenisPelaporan == "0313") {
		$jenis = '4';
		$jenisTxt = 'draft';
	    }
	    if ($jenisPelaporan == "0404") {
		$jenis = '3';
		$jenisTxt = 'draft';
	    }
	    if ($jenisPelaporan == "1111") {
		$jenis = '5';
		$jenisTxt = 'draft';
		$proses['Proses Data Pengawasan'] = array('GET', site_url() . "/iklan/iklanController/prosesPreview/preview", '1');
	    }
	    if (in_array('2', $this->newsession->userdata('SESS_KODE_ROLE')) && $jenisTxt == 'draft' && $user == '2') {
		$status = '2030' . $jenis;
		$statusJudul = $status;
		if (in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')))
		    $status = '2031' . $jenis;
		if ($jenisPelaporan != '0101') {
		    if ($jenisPelaporan == '1101')
			$proses['Kirim Semua Data'] = array('MPOST', site_url() . "/iklan/iklanController/setCheck/ajax", 'N');
		    if ($jenisPelaporan != '1111') {
			$proses['Edit Data Pengawasan'] = array('GET', site_url() . "/iklan/iklanController/prosesEdit/draft", '1');
			$proses['Edit Surat Tugas Pengawasan'] = array('GET', site_url() . "/iklan/iklanController/prosesEdit/suratTugas", '1');
		    }
		}
		else {
		    $proses['Proses Data Perbaikan Pengawasan'] = array('GET', site_url() . "/iklan/iklanController/prosesEdit/draft", '1');
			$proses['Edit Surat Tugas Pengawasan'] = array('GET', site_url() . "/iklan/iklanController/prosesEdit/suratTugas", '1');
		}
		//$where = " TI.STATUS = '" . $status . "' AND TIP.CREATEDBY = TI.USER_LAST_UPDATE AND TIP.STATUS = '" . $status . "' AND CAST(TIP.IKLAN_ID AS VARCHAR) = CAST(TI.IKLAN_ID AS VARCHAR) ";
		
		
		if ((in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))))
			$where = " TI.STATUS = '" . $status . "'";
		else $where = " TI.STATUS = '" . $status . "' AND TI.CREATE_BY = '".$this->newsession->userdata('SESS_USER_ID')."'";
		
		
	    }
	    else if (in_array('3', $this->newsession->userdata('SESS_KODE_ROLE')) && $jenisTxt == 'draft' && $user == '3') {
		$status = '3030' . $jenis;
		if (in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')))
		    $status = '3031' . $jenis;
		if ($jenisPelaporan != '0101')
		    $proses['Kirim Semua Data'] = array('MPOST', site_url() . "/iklan/iklanController/setCheck/ajax", 'N');
		$proses['Proses Data Pengawasan'] = array('GET', site_url() . "/iklan/iklanController/prosesPreview/preview", '1');
		$statusJudul = $status;
		#$where = " TI.STATUS = '" . $status . "' AND TIP.CREATEDBY = TI.USER_LAST_UPDATE AND TIP.STATUS = '" . $status . "' AND CAST(TIP.IKLAN_ID AS VARCHAR) = CAST(TI.IKLAN_ID AS VARCHAR) ";
		$where = " TI.STATUS = '" . $status . "'";
	    }
	    else if (in_array('4', $this->newsession->userdata('SESS_KODE_ROLE')) && $jenisTxt == 'draft' && $user == '4') {
		$status = '4030' . $jenis;
		if (in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')))
		    $status = '4031' . $jenis;
		if ($jenisPelaporan != '0101')
		    $proses['Kirim Semua Data'] = array('MPOST', site_url() . "/iklan/iklanController/setCheck/ajax", 'N');
		$proses['Proses Data Pengawasan'] = array('GET', site_url() . "/iklan/iklanController/prosesPreview/preview", '1');
		$statusJudul = $status;
		//$where = " TI.STATUS = '" . $status . "' AND TIP.CREATEDBY = TI.USER_LAST_UPDATE AND TIP.STATUS = '" . $status . "' AND CAST(TIP.IKLAN_ID AS VARCHAR) = CAST(TI.IKLAN_ID AS VARCHAR) ";
		$where = " TI.STATUS = '" . $status . "'";
	    }
	    else if (in_array('5', $this->newsession->userdata('SESS_KODE_ROLE')) && $jenisTxt == 'draft' && $user == '5') {
		$status = '5030' . $jenis;
		if (in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')))
		    $status = '5031' . $jenis;
		if ($jenisPelaporan != '0101')
		    $proses['Kirim Semua Data'] = array('MPOST', site_url() . "/iklan/iklanController/setCheck/ajax", 'N');
		$proses['Proses Data Pengawasan'] = array('GET', site_url() . "/iklan/iklanController/prosesPreview/preview", '1');
		$statusJudul = $status;
		//$where = " TI.STATUS = '" . $status . "' AND TIP.CREATEDBY = TI.USER_LAST_UPDATE AND TIP.STATUS = '" . $status . "' AND CAST(TIP.IKLAN_ID AS VARCHAR) = CAST(TI.IKLAN_ID AS VARCHAR) ";
		$where = " TI.STATUS = '" . $status . "'";
	    }
	    if ($jenisPelaporan == "1221" || $jenisPelaporan == "1222") {
		if (in_array('6', $this->newsession->userdata('SESS_KODE_ROLE'))) {
		    $status = '60311';
		    $statusJudul = $status;
		    $proses['Tutup Kasus'] = array('MPOST', site_url() . "/iklan/iklanController/setCheck/ajax", 'N');
		    $proses['Lihat Data Pengawasan'] = array('GET', site_url() . "/iklan/iklanController/prosesPreview/preview", '1');
		} else {
		    $this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.', '/home');
		}
		//$where = " TI.STATUS = '" . $status . "' AND TIP.CREATEDBY = TI.USER_LAST_UPDATE AND TIP.STATUS = '" . $status . "' AND CAST(TIP.IKLAN_ID AS VARCHAR) = CAST(TI.IKLAN_ID AS VARCHAR) ";
		$where = " TI.STATUS = '" . $status . "'";
	    }
	    if ($jenisPelaporan == "1212") {
		$status = $sipt->iklan_act->statusSend();
		//$created = " AND TIP.SERI = (SELECT dbo.GET_IKLAN_TERKIRIM(TI.IKLAN_ID, '" . $this->newsession->userdata('SESS_USER_ID') . "'))";
		if (count($this->newsession->userdata('SESS_KODE_ROLE')) > 1) {
		    $judul = "Data - Terkirim";
		    $statusJudul = "data";
		} else {
		    if (in_array('2', $this->newsession->userdata('SESS_KODE_ROLE'))) {
			$statusJudul = '20304';
			if (in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')))
			    $statusJudul = '20314';
		    }
		    if (in_array('3', $this->newsession->userdata('SESS_KODE_ROLE'))) {
			$statusJudul = '30305';
			if (in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')))
			    $statusJudul = '30315';
		    }
		    if (in_array('4', $this->newsession->userdata('SESS_KODE_ROLE'))) {
			$statusJudul = '40304';
			if (in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')))
			    $statusJudul = '40314';
		    }
		    if (in_array('5', $this->newsession->userdata('SESS_KODE_ROLE'))) {
			$statusJudul = '50304';
		    }
		    if (in_array('6', $this->newsession->userdata('SESS_KODE_ROLE'))) {
			$status = '20301';
		    }
		}
		$proses['Lihat Data Pengawasan'] = array('GET', site_url() . "/iklan/iklanController/prosesPreview/preview", '1');
		$where = " TI.STATUS IN (" . $status . ") ";
	    }
	    if ($jenisPelaporan == "1122") {
		$proses['Cetak Hasil Penilaian'] = array('GET', site_url() . "/iklan/iklanController/cetakPenilaian/cetakan", '1');
		$status = '60310';
		$statusJudul = $status;
		$proses['Lihat Data Pengawasan'] = array('GET', site_url() . "/iklan/iklanController/prosesPreview/preview", '1');
		$where = " TI.STATUS = '" . $status . "' AND TIP.CREATEDBY = TI.USER_LAST_UPDATE AND TIP.STATUS = '" . $status . "' AND CAST(TIP.IKLAN_ID AS VARCHAR) = CAST(TI.IKLAN_ID AS VARCHAR) ";
		$hasilAkhir = "(CASE WHEN TI.HASIL_PUSAT = 'MK' THEN 'Memenuhi Ketentuan' else 'Tidak Memenuhi Ketentuan' END)";
	    }
	    if ($jenisPelaporan == "0101") {
		$created = " AND TIP.SERI = (SELECT dbo.GET_IKLAN_TERKIRIM(TI.IKLAN_ID, '" . $this->newsession->userdata('SESS_USER_ID') . "'))";
	    }
	    $this->load->library('newtable');
	    $this->newtable->action(site_url() . "/iklan/iklanController/setListFormIklanLanjutan/" . $jenisPelaporan . "/" . $user);
	    $this->newtable->detail(site_url() . "/iklan/iklanController/setPreview/" . $jenisPelaporan);
	    $this->newtable->cidb($this->db);
	    $this->newtable->ciuri($this->uri->segment_array());
	    if (in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')) && $jenisPelaporan != "1101")
		$this->newtable->hiddens(array('IKLANID', 'LASTUPDATEROW'));
	    else
		$this->newtable->hiddens(array('IKLANID', 'LASTUPDATEROW', 'BB / BPOM'));
	    $this->newtable->keys(array('IKLANID'));
	    $this->newtable->search(array(array('dbo.GET_KOMODITI(TI.KOMODITI)', 'Komoditi'), array("TI.JENIS_IKLAN+' &raquo '+TI.MEDIA+'</div><div><b>'+CASE(SELECT COUNT(MM2.NAMA_MEDIA) AS MEDIA FROM M_MEDIA MM2 WHERE CONVERT(VARCHAR(100),MM2.ID_MEDIA) = TI.NAMA_MEDIA) WHEN 0 THEN (CASE CONVERT(VARCHAR(100), TI.NAMA_MEDIA) WHEN '0' THEN '-' ELSE CONVERT(VARCHAR(100), TI.NAMA_MEDIA) END) ELSE MM.NAMA_MEDIA END+'</b></div>'", 'Media'), array($hasilAkhir, 'Hasil'), array('dbo.GET_PRODUK_PENGAWASAN(TI.IKLAN_ID, "IKLAN", "PRODUK")', 'Nama Produk'), array('{IN}TI.IKLAN_ID IN (SELECT Y.IKLAN_ID FROM T_IKLAN Y WHERE Y.IKLAN_ID IN(SELECT TSTI.IKLAN_ID FROM T_SURAT_TUGAS_IKLAN TSTI WHERE TSTI.IKLAN_ID = Y.IKLAN_ID AND TSTI.NOMOR_SURAT {LIKE}))', 'Nomor Surat Tugas'), array('CONVERT(VARCHAR(10), TI.TANGGAL_MULAI, 120)', 'Tanggal Awal Periksa'), array('CONVERT(VARCHAR(10), TI.TANGGAL_AKHIR, 120)', 'Tanggal Akhir Periksa'), array('C.NAMA_USER', 'Nama Petugas Entri')));
//      $proses['Data Petugas Pemeriksa'] = array('GET', site_url() . "/home/pelaporan/petugas", '1');
//      $proses['Hapus Data Pemeriksaan'] = array('POST', site_url() . "/post/pemeriksaan/hapus_act/delete/ajax", 'N');
	    $query .= "SELECT TI.LAST_UPDATE AS LASTUPDATEROW, (CAST(TI.IKLAN_ID AS VARCHAR)+'/'+TI.KOMODITI+'/'+CAST(TI.STATUS AS VARCHAR))+'/$jenisPelaporan/$user'+'/'+CAST(TI.BBPOM_ID AS VARCHAR) AS IKLANID, dbo.GET_PRODUK_PENGAWASAN(TI.IKLAN_ID, 'IKLAN', 'PRODUK')+'<div><b><a href=\"#\" class=\"row_preview\">Lihat</a></b></div>' AS 'PRODUK',CONVERT(VARCHAR(10), TI.TANGGAL_MULAI, 120)+'<div>Sampai Dengan</div><div>'+CONVERT(VARCHAR(10), TI.TANGGAL_AKHIR, 120)+'</div>' AS 'TANGGAL PENGAWASAN', '<div><b>'+MB.NAMA_BBPOM+'</b></div>' AS 'BB / BPOM', dbo.GET_KOMODITI(TI.KOMODITI) AS KOMODITI,CASE JENIS_IKLAN WHEN '' THEN '-' ELSE + '<div>'+TI.JENIS_IKLAN+' &raquo '+TI.MEDIA+'</div><div><b>'+CASE(SELECT COUNT(MM2.NAMA_MEDIA) AS MEDIA FROM M_MEDIA MM2 WHERE CONVERT(VARCHAR(100),MM2.ID_MEDIA) = TI.NAMA_MEDIA) WHEN 0 THEN (CASE CONVERT(VARCHAR(100), TI.NAMA_MEDIA) WHEN '0' THEN '-' ELSE CONVERT(VARCHAR(100), TI.NAMA_MEDIA) END) ELSE MM.NAMA_MEDIA END+'</b></div>' END AS MEDIA,'<div><b>'+" . $hasilAkhir . "+'</b></div>' AS HASIL, MT.URAIAN AS 'STATUS TERAKHIR', dbo.GET_HISTORY_IKLAN('PENGAWASAN', TI.IKLAN_ID)+'</div><div>'+dbo.GET_HISTORY_IKLAN('CATATAN', TI.IKLAN_ID)+'</div><div><a href=\"#\" class=\"row_riwayat2\" record=\"'+CAST(TI.IKLAN_ID AS VARCHAR)+'#T_IKLAN_PROSES\">Riwayat Pemeriksaan</a></div>' AS [UPDATE TERAKHIR] FROM T_IKLAN TI RIGHT JOIN T_IKLAN_PROSES TIP ON TIP.IKLAN_ID = TI.IKLAN_ID RIGHT JOIN T_USER TU ON TU.USER_ID = TI.USER_LAST_UPDATE LEFT JOIN M_TABEL MT ON MT.KODE = TI.STATUS LEFT JOIN M_MEDIA MM ON CONVERT(VARCHAR(100),MM.ID_MEDIA) = TI.NAMA_MEDIA LEFT JOIN M_BBPOM MB ON TI.BBPOM_ID = MB.BBPOM_ID WHERE" . $where . "AND TI.USER_LAST_UPDATE = TIP.CREATEDBY $created AND TI.KOMODITI IN (" . "'" . join("','", $this->newsession->userdata("SESS_KLASIFIKASI_ID")) . "'" . ")";
	    if (!in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')))
		$query .= " AND TI.BBPOM_ID = " . $this->newsession->userdata('SESS_BBPOM_ID');
	    if ($jenisPelaporan == "1222" && in_array('6', $this->newsession->userdata('SESS_KODE_ROLE'))) {
		$query .= " AND TI.BBPOM_ID = '92'";
		$subJudul = 'Data Pusat';
	    }
	    if ($jenisPelaporan == "1221" && in_array('6', $this->newsession->userdata('SESS_KODE_ROLE'))) {
		$query .= " AND TI.BBPOM_ID <> '92'";
		$subJudul = 'Data Balai';
	    }
	    $this->newtable->columns(array("TI.LAST_UPDATE", "(CAST(TI.IKLAN_ID AS VARCHAR)+'/'+CAST(TI.STATUS AS VARCHAR))+'/TI.KOMODITI/$jenisPelaporan/$user'+'/'+CAST(TI.BBPOM_ID AS VARCHAR)", "dbo.GET_PRODUK_PENGAWASAN(TI.IKLAN_ID, 'IKLAN', 'PRODUK')+'<div><b><a href=\"#\" class=\"row_preview\">Lihat</a></b></div>'", "CONVERT(VARCHAR(10), TANGGAL_MULAI, 120)+'<div>Sampai Dengan</div><div>'+CONVERT(VARCHAR(10), TANGGAL_AKHIR, 120)+'</div>'", "'<div><b>'+MB.NAMA_BBPOM+'</b></div>'", "dbo.GET_KOMODITI(TI.KOMODITI)", "CASE JENIS_IKLAN WHEN '' THEN '-' ELSE + '<div>'+TI.JENIS_IKLAN+' &raquo '+TI.MEDIA+'</div><div><b>'+CASE(SELECT COUNT(MM2.NAMA_MEDIA) AS MEDIA FROM M_MEDIA MM2 WHERE CONVERT(VARCHAR(100),MM2.ID_MEDIA) = TI.NAMA_MEDIA) WHEN 0 THEN (CASE CONVERT(VARCHAR(100), TI.NAMA_MEDIA) WHEN '0' THEN '-' ELSE CONVERT(VARCHAR(100), TI.NAMA_MEDIA) END) ELSE MM.NAMA_MEDIA END+'</b></div>' END", "'<div><b>'+" . $hasilAkhir . "+'</b></div>'", "MT.URAIAN", "dbo.GET_HISTORY_IKLAN('PENGAWASAN', TI.IKLAN_ID)+'</div><div>'+dbo.GET_HISTORY_IKLAN('CATATAN', TI.IKLAN_ID)+'</div><div><a href=\"#\" class=\"row_riwayat2\" record=\"'+CAST(TI.IKLAN_ID AS VARCHAR)+'#T_IKLAN_PROSES\">Riwayat Pemeriksaan</a></div>'"));
	    $this->newtable->width(array('PRODUK' => 250, 'TANGGAL PENGAWASAN' => 150, 'KOMODITI' => 100, 'MEDIA' => 100, 'BB / BPOM' => 100, 'HASIL' => 100, 'STATUS TERAKHIR' => 125, 'UPDATE TERAKHIR' => 125));
	    $this->newtable->orderby(1);
	    $this->newtable->sortby("DESC");
	    $this->newtable->menu($proses);
	    $tabel = $this->newtable->generate($query);
	    if ($statusJudul != 'data')
		$judul = $sipt->main->get_uraian("SELECT URAIAN FROM M_TABEL WHERE JENIS = 'STATUS' AND KODE = '$statusJudul'", "URAIAN");
	    $arrdata = array('table' => $tabel, 'idjudul' => 'judulpmnikl', 'caption_header' => $judul . " " . $subJudul, 'batal' => '', 'cancel' => '');
	    return $arrdata;
	} else {
	    $this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.', '/home');
	}
    }

    function getSurat($iklanId) {
	$sipt = & get_instance();
	$sipt->load->model("main", "main", true);
	$urlId = explode('/', $_SERVER['PATH_INFO']);
	$query = "SELECT TSTI.SURAT_ID, TSTI.PETUGAS, TU.NAMA_USER, TSTI.NOMOR_SURAT, CONVERT(VARCHAR(10), TSTI.TANGGAL, 103) AS TANGGAL, MB.NAMA_BBPOM, TI.KOMODITI FROM T_SURAT_TUGAS_IKLAN TSTI RIGHT JOIN T_USER TU ON TU.USER_ID  = TSTI.PETUGAS LEFT JOIN M_BBPOM MB ON MB.BBPOM_ID  = TU.BBPOM_ID LEFT JOIN T_IKLAN TI ON TI.SURAT_ID  = TSTI.SURAT_ID WHERE TI.IKLAN_ID IN ($iklanId)";
	$data = $sipt->main->get_result($query);
	if ($data) {
	    foreach ($query->result_array() as $row) {
		$arrdata['suratTugas'] = $row['NOMOR_SURAT'];
		$arrdata['tanggalSurat'] = $row['TANGGAL'];
		$arrdata['suratId'] = $row['SURAT_ID'];
		$user[] = $row['NAMA_USER'];
		$userId[] = $row['PETUGAS'];
		$arrdata['selKlasifikasi'] = $row['KOMODITI'];
	    }
	}
	$arrdata['petugas'] = $user;
	$arrdata['petugasId'] = $userId;
	$arrdata['klasifikasi'] = $sipt->main->combobox("SELECT * FROM M_KLASIFIKASI_KATEGORI WHERE LEN(KK_ID) = 3 AND KK_ID IN ('001','007','010','011','012', '013')", "KK_ID", "NAMA_KK", TRUE);
	$arrdata['act'] = site_url() . '/iklan/iklanController/setSurat/pengawasanUpd';
	return $arrdata;
    }

    function setSurat($isajax) {
	$ret = "MSG#NO#Data gagal disimpan";
	$sipt = & get_instance();
	$sipt->load->model("main", "main", true);
	$arr_no = $this->input->post('SURAT');
	$arr_petugas = $this->input->post('USER_ID');
	$arr_bpom = $this->input->post('BBPOM');
	$arr_tanggal = $this->input->post('TANGGAL');
	if (!$arr_petugas)
	    return "MSG#NO#Anda Belum Memasukan Petugas Pemeriksa#";
	if ($arr_tanggal)
	    $SES_SURAT['TANGGAL'] = $arr_tanggal;
	if ($arr_no)
	    $SES_SURAT['SURAT'] = $arr_no;
	else {
	    $SES_SURAT['SURAT'] = '-';
	    $SES_SURAT['TANGGAL'] = '-';
	}
	$SES_SURAT['BBPOM'] = $arr_bpom;
	$SES_SURAT['USER'] = $arr_petugas;
	$klasifikasi = join('-', $this->input->post('klasifikasi'));
	$jenis = $this->input->post('PANGAN');
	$this->session->set_userdata($SES_SURAT);
	$ret = "MSG#YES#Data berhasil disimpan#" . site_url() . '/iklan/iklanController/getFormIklanLanjutan/' . $klasifikasi . "/" . $jenis;
	if ($isajax != "ajax") {
	    redirect(base_url());
	    exit();
	}
	return $ret;
    }

    function updateSurat($isajax) {
	$ret = "MSG#NO#Data gagal disimpan";
	$sipt = & get_instance();
	$sipt->load->model("main", "main", true);
	$arr_no = $this->input->post('SURAT');
	$arr_petugas = $this->input->post('USER_ID');
	$arr_bpom = $this->input->post('BBPOM');
	$arr_tanggal = $this->input->post('TANGGAL');
	$suratId = $this->input->post('SURATIDEDIT');
	if (!$arr_petugas)
	    return "MSG#NO#Anda Belum Memasukan Petugas Pemeriksa#";
	$this->db->where(array("SURAT_ID" => $suratId));
	$this->db->delete('T_SURAT_TUGAS_IKLAN');
	for ($i = 0; $i < count($arr_petugas[0]); $i++) {
	    $surat = array('SURAT_ID' => $suratId, 'NOMOR_SURAT' => $arr_no, 'TANGGAL' => $arr_tanggal, 'BALAI' => $this->newsession->userdata('SESS_BBPOM_ID'), 'PETUGAS' => $arr_petugas[0][$i], 'CREATED_BY' => $this->newsession->userdata('SESS_USER_ID'), 'CREATED' => 'GETDATE()');
	    $this->db->insert('T_SURAT_TUGAS_IKLAN', $surat);
	}
	$ret = "MSG#YES#Data berhasil disimpan#" . site_url() . '/iklan/iklanController/setListFormIklanLanjutan/1101/2';
	if ($isajax != "ajax") {
	    redirect(base_url());
	    exit();
	}
	return $ret;
    }

    function setStatus($X, $isajax) {
	if ($isajax != "ajax") {
	    redirect(base_url());
	    exit();
	}
	if ($this->newsession->userdata('LOGGED_IN') == TRUE) {
	    $sipt = & get_instance();
	    $sipt->load->model("main", "main", true);
	    $ret = "MSG#NO#Data Gagal Dikirim";
	    $status = $this->input->post('TO');
	    $komoditi = $this->input->post('KOMODITI');
	    $arr_update = array('STATUS' => $status, "USER_LAST_UPDATE" => $this->newsession->userdata('SESS_USER_ID'), "LAST_UPDATE" => 'GETDATE()');
	    $arr_update_log = array('UPDATED' => 'GETDATE()');
	    $iklanId = $this->input->post('IKLAN_ID');
	    $i = 0;
	    foreach ($iklanId as $a) {
		$this->db->where(array("IKLAN_ID" => $a));
		$ret = "MSG#NO#Data Gagal Dikirim";
		$this->db->update('T_IKLAN', $arr_update);
		$seri = (int) $sipt->main->get_uraian("SELECT MAX(SERI) AS MAXID FROM T_IKLAN_PROSES WHERE IKLAN_ID = '" . $a . "'", "MAXID") + 1;
		$log = array('IKLAN_ID' => $a, 'SERI' => $seri, 'STATUS' => $status, 'CATATAN' => $this->input->post('CATATAN'), 'CREATEDBY' => $this->newsession->userdata('SESS_USER_ID'), 'CREATED' => 'GETDATE()', 'UPDATED' => 'GETDATE()');
		if ($this->db->insert('T_IKLAN_PROSES', $log)) {
		    $this->db->where(array("IKLAN_ID" => $a, "STATUS" => $status));
		    $this->db->update('T_IKLAN_PROSES', $arr_update_log);
		    $case = 'Log';
		}
		if ($case == 'Log') {
		    if (in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) {
			if ($komoditi[$i] == "010" || $komoditi[$i] == "011") {
			    if ($this->input->post('MUSNAHPUSAT'))
				$pemusnahanPusat = join("^", $this->input->post('MUSNAHPUSAT'));
			    else
				$pemusnahanPusat = NULL;
			}
			if ($komoditi[$i] == "001") {
			    $pusat = $sipt->main->get_uraian("SELECT HASIL_PUSAT FROM T_IKLAN WHERE IKLAN_ID = '" . $a . "'", "HASIL_PUSAT");
			    $yes = $this->input->post('EDIT');
			    if (in_array('2', $this->newsession->userdata('SESS_KODE_ROLE')) && ($pusat == '' || $yes == 'YES')) {
				$arr_iklan = $this->input->post('IKLAN');
				if ($arr_iklan['HASIL_PUSAT'] == "TMK")
				    $tL = join("^", $arr_iklan['TL_PUSAT']);
				else
				    $tL = $arr_iklan['TL_PUSAT'];
				if ($arr_iklan['DETAIL_PUSAT'] != "")
				    $tL2 = join("^", $arr_iklan['DETAIL_PUSAT']);
				else
				    $tL2 = NULL;
				$justifikasi = $this->input->post('JUSTIFIKASI');
				if ($arr_iklan['HASIL_PUSAT'] == "MK")
				    $tindakH = array('HASIL_PUSAT' => $arr_iklan['HASIL_PUSAT'], 'TL_PUSAT' => $tL, 'DETAIL_PUSAT' => NULL, 'JUSTIFIKASI_PUSAT' => $justifikasi);
				else if ($arr_iklan['HASIL_PUSAT'] == "TMK")
				    $tindakH = array('HASIL_PUSAT' => $arr_iklan['HASIL_PUSAT'], 'TL_PUSAT' => $tL, 'DETAIL_PUSAT' => $tL2, 'JUSTIFIKASI_PUSAT' => $justifikasi);
				$this->db->where(array("IKLAN_ID" => $a));
				$this->db->update('T_IKLAN', $tindakH);
			    } else if ($komoditi[$i] == "007") {
				$sipt->load->model('iklan/iklan_act');
				$pusat = $sipt->main->get_uraian("SELECT HASIL_PUSAT FROM T_IKLAN WHERE IKLAN_ID = '" . $a . "'", "HASIL_PUSAT");
//        $yes = $this->input->post('EDIT');
//        if (in_array('2', $this->newsession->userdata('SESS_KODE_ROLE')) && ($pusat == '' || $yes == 'YES')) {
//         $arr_iklan = $this->input->post('IKLAN');
//         $tL = join("^", $arr_iklan['TL_PUSAT']);
//         $tL2 = join("^", $arr_iklan['DETAIL_PUSAT']);
//         $justifikasi = $this->input->post('JUSTIFIKASI');
//         if ($arr_iklan['HASIL_PUSAT'] == "MK")
//          $tindakH = array('HASIL_PUSAT' => $arr_iklan['HASIL_PUSAT'], 'TL_PUSAT' => $tL, 'DETAIL_PUSAT' => NULL, 'JUSTIFIKASI_PUSAT' => $justifikasi);
//         else if ($arr_iklan['HASIL_PUSAT'] == "TMK")
//          $tindakH = array('HASIL_PUSAT' => $arr_iklan['HASIL_PUSAT'], 'TL_PUSAT' => $tL, 'DETAIL_PUSAT' => $tL2, 'JUSTIFIKASI_PUSAT' => $justifikasi);
//         $this->db->where(array("IKLAN_ID" => $a));
//         $this->db->update('T_IKLAN', $tindakH);
//         $iklanRokok = array('PEMUSNAHANPUSAT' => $pemusnahanPusat);
//         $this->db->where(array("IKLAN_ID" => $a));
//         $this->db->update('T_IKLAN_OT', $iklanRokok);
//        }
			    }
			} else if ($komoditi[$i] == "010") {
			    $sipt->load->model('iklan/iklan_act');
			    $pusat = $sipt->main->get_uraian("SELECT HASIL_PUSAT FROM T_IKLAN WHERE IKLAN_ID = '" . $a . "'", "HASIL_PUSAT");
			    $yes = $this->input->post('EDIT');
			    if (in_array('2', $this->newsession->userdata('SESS_KODE_ROLE')) && ($pusat == '' || $yes == 'YES')) {
				$arr_iklan = $this->input->post('IKLAN');
				$tL = $arr_iklan['TL_PUSAT'];
				$tL2 = join("^", $arr_iklan['DETAIL_PUSAT']);
				$justifikasi = $this->input->post('JUSTIFIKASI');
				if ($arr_iklan['HASIL_PUSAT'] == "MK")
				    $tindakH = array('HASIL_PUSAT' => $arr_iklan['HASIL_PUSAT'], 'TL_PUSAT' => $tL, 'DETAIL_PUSAT' => NULL, 'JUSTIFIKASI_PUSAT' => $justifikasi);
				else if ($arr_iklan['HASIL_PUSAT'] == "TMK")
				    $tindakH = array('HASIL_PUSAT' => $arr_iklan['HASIL_PUSAT'], 'TL_PUSAT' => $tL, 'DETAIL_PUSAT' => $tL2, 'JUSTIFIKASI_PUSAT' => $justifikasi);
				$this->db->where(array("IKLAN_ID" => $a));
				$this->db->update('T_IKLAN', $tindakH);
				$iklanOT = array('PEMUSNAHANPUSAT' => $pemusnahanPusat);
				$this->db->where(array("IKLAN_ID" => $a));
				$this->db->update('T_IKLAN_OT', $iklanOT);
			    }
			} else if ($komoditi[$i] == "011") {
			    $sipt->load->model('iklan/iklan_act');
			    $pusat = $sipt->main->get_uraian("SELECT HASIL_PUSAT FROM T_IKLAN WHERE IKLAN_ID = '" . $a . "'", "HASIL_PUSAT");
			    $yes = $this->input->post('EDIT');
			    if (in_array('2', $this->newsession->userdata('SESS_KODE_ROLE')) && ($pusat == '' || $yes == 'YES')) {
				$arr_iklan = $this->input->post('IKLAN');
				$tL = $arr_iklan['TL_PUSAT'];
				$tL2 = join("^", $arr_iklan['DETAIL_PUSAT']);
				$justifikasi = $this->input->post('JUSTIFIKASI');
				if ($arr_iklan['HASIL_PUSAT'] == "MK")
				    $tindakH = array('HASIL_PUSAT' => $arr_iklan['HASIL_PUSAT'], 'TL_PUSAT' => $tL, 'DETAIL_PUSAT' => NULL, 'JUSTIFIKASI_PUSAT' => $justifikasi);
				else if ($arr_iklan['HASIL_PUSAT'] == "TMK")
				    $tindakH = array('HASIL_PUSAT' => $arr_iklan['HASIL_PUSAT'], 'TL_PUSAT' => $tL, 'DETAIL_PUSAT' => $tL2, 'JUSTIFIKASI_PUSAT' => $justifikasi);
				$this->db->where(array("IKLAN_ID" => $a));
				$this->db->update('T_IKLAN', $tindakH);
				$iklanSM = array('PEMUSNAHANPUSAT' => $pemusnahanPusat);
				$this->db->where(array("IKLAN_ID" => $a));
				$this->db->update('T_IKLAN_PK_SM', $iklanSM);
			    }
			} else if ($komoditi[$i] == "012") {
			    $sipt->load->model('iklan/iklan_act');
			    $pusat = $sipt->main->get_uraian("SELECT HASIL_PUSAT FROM T_IKLAN WHERE IKLAN_ID = '" . $a . "'", "HASIL_PUSAT");
			    $yes = $this->input->post('EDIT');
			    if (in_array('2', $this->newsession->userdata('SESS_KODE_ROLE')) && ($pusat == '' || $yes == 'YES')) {
				$arr_iklan = $this->input->post('IKLAN');
				$tL = $arr_iklan['TL_PUSAT'];
				$justifikasi = $this->input->post('JUSTIFIKASI');
				$uraianPusat = $this->input->post('UPELANGGARANPUSAT');
				$tindakH = array('HASIL_PUSAT' => $arr_iklan['HASIL_PUSAT'], 'TL_PUSAT' => $tL, 'JUSTIFIKASI_PUSAT' => $justifikasi);
				$this->db->where(array("IKLAN_ID" => $a));
				$this->db->update('T_IKLAN', $tindakH);
				$updateUraian = array('URAIAN_PELANGGARAN_PUSAT' => join("^", $uraianPusat));
				$this->db->where(array("IKLAN_ID" => $a));
				$this->db->update('T_IKLAN_KOSMETIKA', $updateUraian);
			    }
			} else if ($komoditi[$i] == "013") {
			    $sipt->load->model('iklan/iklan_act');
			    $pusat = $sipt->main->get_uraian("SELECT HASIL_PUSAT FROM T_IKLAN WHERE IKLAN_ID = '" . $a . "'", "HASIL_PUSAT");
			    $yes = $this->input->post('EDIT');
			    if (in_array('2', $this->newsession->userdata('SESS_KODE_ROLE')) && ($pusat == '' || $yes == 'YES')) {
				$arr_iklan = $this->input->post('IKLAN');
				$tL = $arr_iklan['TL_PUSAT'];
				$justifikasi = $this->input->post('JUSTIFIKASI');
				$tindakH = array('HASIL_PUSAT' => $arr_iklan['HASIL_PUSAT'], 'TL_PUSAT' => $tL, 'JUSTIFIKASI_PUSAT' => $justifikasi);
				$this->db->where(array("IKLAN_ID" => $a));
				$this->db->update('T_IKLAN', $tindakH);
			    }
			}
		    }
		    $case = 'Set';
		}
		$i++;
	    }
	    if ($case == 'Set') {
		if ($X == '1')
		    $ret = "MSG#YES#Data Berhasil Dikirim#";
		else if ($X == '2')
		    $ret = "MSG#Data Berhasil Dikirim#";
	    }
	    return $ret;
	}
    }

    function getRole() {
	$sipt = & get_instance();
	$this->load->model("main", "main", true);
	$query = "SELECT ROLE FROM T_USER_ROLE WHERE USER_ID = '" . $this->newsession->userdata('SESS_USER_ID') . "'";
	$data = $sipt->main->get_result($query);
	if ($data) {
	    foreach ($query->result_array() as $row) {
		$arrdata = $row['ROLE'];
	    }
	}
	return $arrdata;
    }

    function getJenis($iklanId) {
	$sipt = & get_instance();
	$this->load->model("main", "main", true);
	$query = "SELECT JENIS FROM T_IKLAN_PANGAN WHERE IKLAN_ID = '$iklanId'";
	$data = $sipt->main->get_result($query);
	if ($data) {
	    foreach ($query->result_array() as $row) {
		$arrdata = $row['JENIS'];
	    }
	}
	return $arrdata;
    }

    function getDataFrom($id) {
	$sipt = & get_instance();
	$this->load->model("main", "main", true);
	$query = "SELECT BBPOM FROM T_IKLAN WHERE IKLAN_ID = '" . $this->newsession->userdata('SESS_USER_ID') . "'";
	$data = $sipt->main->get_result($query);
	if ($data) {
	    foreach ($query->result_array() as $row) {
		$arrdata = $row['ROLE'];
	    }
	}
	return $arrdata;
    }

    function get_petugas($iklanObatId, $status, $iklanId, $klasifikasi, $subid = "") {
	if ($this->newsession->userdata('LOGGED_IN') == TRUE) {
	    $sipt = & get_instance();
	    $sipt->load->model("main", "main", true);
	    if ($iklanId == "")
		return redirect(base_url());
	    if ($subid != "") {
		die($subid);
		$query = "SELECT B.USER_ID, B.NAMA_USER FROM T_SURAT_TUGAS_IKLAN A LEFT JOIN T_USER B ON A.USER_ID = B.USER_ID WHERE A.SURAT_ID = '$iklanId' AND A.USER_ID = '$subid'";
		$data = $sipt->main->get_result($query);
		if ($data) {
		    foreach ($query->result_array() as $row) {
			$arrdata = array('act' => site_url() . '/post/pemeriksaan/set_petugas/update/', 'sess' => $row, 'SURAT_ID' => $surat_id, 'header' => 'Edit Petugas Pemeriksa', 'save' => 'Update', 'cancel' => 'Batal');
		    }
		}
	    } else {
		$arrdata = array('act' => site_url() . '/post/pemeriksaan/set_petugas/save/', 'sess' => '', 'SURAT_ID' => $surat_id, 'header' => 'Tambah Petugas Pemeriksa', 'save' => 'Tambah', 'cancel' => 'Batal');
	    }
	    $query = "SELECT(SELECT (CAST(TI.IKLAN_ID AS VARCHAR) + '/' + TI.IKLAN_ID + '/' + STUFF(dbo.GROUP_KLASIFIKASI(TI.SURAT_ID),1,1,'') + '/' + CAST(TI.SURAT_ID AS VARCHAR) + '.' + TI.STATUS) FROM T_IKLAN TI WHERE TI.SURAT_ID='$surat_id')+'/'+TU.USER_ID AS PERIKSA_ID, TSTI.NOMOR_SURAT AS [Nomor Surat Tugas], CONVERT(VARCHAR(10), TSTI.TANGGAL, 103) AS [Tanggal Surat], TU.NAMA_USER AS [Nama Petugas], MB.NAMA_BBPOM AS [Balai / Badan] FROM T_SURAT_TUGAS_IKLAN TSTI LEFT JOIN T_USER TU ON TU.USER_ID = TSTI.PETUGAS LEFT JOIN M_BBPOM MB ON MB.BBPOM_ID = TU.BBPOM_ID WHERE TI.SURAT_ID = '$surat_id'";
	    $this->load->library('newtable');
	    $this->newtable->search(array(array('', '')));
	    $this->newtable->hiddens(array('PERIKSA_ID'));
	    $proses = array('Edit Petugas' => array('GET', site_url() . "/home/pelaporan/petugas", '1'), 'Hapus Petugas' => array('POST', site_url() . "/post/pemeriksaan/set_petugas/hapus/ajax", 'N'));
	    $this->newtable->action(site_url());
	    $this->newtable->cidb($this->db);
	    $this->newtable->ciuri($this->uri->segment_array());
	    $this->newtable->orderby("1 ASC");
	    $this->newtable->keys("PERIKSA_ID");
	    $this->newtable->rowcount("ALL");
	    $this->newtable->show_search(FALSE);
	    $this->newtable->menu($proses);
	    $tabel = $this->newtable->generate($query);
	    $arrdata['tabel'] = $tabel;
	    $arrdata['url'] = $submenu . "/" . $doc . "/" . $kk . "/" . join(".", $id);
	    $arrdata['bpomid'] = $this->newsession->userdata('SESS_BBPOM_ID');
	    return $arrdata;
	} else {
	    $this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.', '/home');
	}
    }

    function statusSend() {
	$sipt = & get_instance();
	$sipt->load->model("main", "main", true);
	$stat = "";
	if (in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) {#Sent Pusat
	    if (in_array('2', $this->newsession->userdata('SESS_KODE_ROLE'))) {
		$stat .= $sipt->main->get_uraian("SELECT URAIAN FROM M_TABEL WHERE JENIS = 'SENT' AND KODE = '0204'", "URAIAN");
	    }
	    if (in_array('3', $this->newsession->userdata('SESS_KODE_ROLE'))) {
		$stat .= $sipt->main->get_uraian("SELECT URAIAN FROM M_TABEL WHERE JENIS = 'SENT' AND KODE = '0304'", "URAIAN");
	    }
	    if (in_array('4', $this->newsession->userdata('SESS_KODE_ROLE'))) {
		$stat .= $sipt->main->get_uraian("SELECT URAIAN FROM M_TABEL WHERE JENIS = 'SENT' AND KODE = '0404'", "URAIAN");
	    }
	} else {#Sent Balai
	    if (in_array('2', $this->newsession->userdata('SESS_KODE_ROLE'))) {
		$stat .= $sipt->main->get_uraian("SELECT URAIAN FROM M_TABEL WHERE JENIS = 'SENT' AND KODE = '0203'", "URAIAN");
	    }
	    if (in_array('3', $this->newsession->userdata('SESS_KODE_ROLE'))) {
		$stat .= $sipt->main->get_uraian("SELECT URAIAN FROM M_TABEL WHERE JENIS = 'SENT' AND KODE = '0303'", "URAIAN");
	    }
	    if (in_array('4', $this->newsession->userdata('SESS_KODE_ROLE'))) {
		$stat .= $sipt->main->get_uraian("SELECT URAIAN FROM M_TABEL WHERE JENIS = 'SENT' AND KODE = '0403'", "URAIAN");
	    }
	    if (in_array('5', $this->newsession->userdata('SESS_KODE_ROLE'))) {
		$stat .= $sipt->main->get_uraian("SELECT URAIAN FROM M_TABEL WHERE JENIS = 'SENT' AND KODE = '0503'", "URAIAN");
	    }
	}
	$arr = explode(",", $stat);
	if (empty($arr[count($arr) - 1])) {
	    unset($arr[count($arr) - 1]);
	}
	$status = "'" . join("','", array_unique($arr)) . "'";
	return $status;
    }

    function get_reportPengawasanRHPK($jenis = "") {
	if ($this->newsession->userdata('LOGGED_IN') == TRUE) {
	    $sipt = & get_instance();
	    $this->load->model("main", "main", true);
	    $disinput = array("JENISDIS", "NAMADIS");
//            $komoditi = "'" . join("','", $this->newsession->userdata("SESS_KLASIFIKASI_ID")) . "'";
	    $komoditi = "'001','007','010','011','012','013'";
	    $arrayClause = array('demo_1', 'demo_2', 'demo_3', 'demo_4', 'operator-pusat', '1001', '1002', '1003', '1004', '1005', 'administrator');
	    if (in_array($this->newsession->userdata("SESS_USER_ID"), $arrayClause))
		$klasifikasi = $sipt->main->combobox("SELECT * FROM M_KLASIFIKASI_KATEGORI WHERE LEN(KK_ID) = 3 AND KK_ID IN ($komoditi)", "KK_ID", "NAMA_KK", TRUE);
	    else
		$klasifikasi = $sipt->main->combobox("SELECT * FROM M_KLASIFIKASI_KATEGORI WHERE LEN(KK_ID) = 3 AND KK_ID IN ('001')", "KK_ID", "NAMA_KK", TRUE);
	    $kecuali = $sipt->main->remove_element($this->config->item('cfg_unit'), $this->newsession->userdata('SESS_BBPOM_ID'));
	    $unit = "'" . join("','", $kecuali) . "'";
	    if (in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) {
		$ret = "SELECT BBPOM_ID, NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID NOT IN ('00','99',$unit)";
		$bbpom = $sipt->main->combobox("SELECT BBPOM_ID, NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID NOT IN ('00','99',$unit)", "BBPOM_ID", "NAMA_BBPOM", TRUE);
	    } else if ($this->newsession->userdata('SESS_BBPOM_ID') != "00" && !in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) {
		$ret = 'balai';
		$bbpom = $sipt->main->combobox("SELECT BBPOM_ID, NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID ='" . $this->newsession->userdata('SESS_BBPOM_ID') . "'", "BBPOM_ID", "NAMA_BBPOM");
		if ($this->newsession->userdata('SESS_PROP_ID') == '7100') {
		    $kota = $sipt->main->combobox("SELECT PROPINSI_ID, NAMA_PROPINSI FROM M_PROPINSI WHERE PROPINSI_ID LIKE '%71__%' OR PROPINSI_ID LIKE '%82__%' AND RIGHT(PROPINSI_ID, 2) <> '00'", "PROPINSI_ID", "NAMA_PROPINSI", TRUE);
		} else if ($this->newsession->userdata('SESS_PROP_ID') == '7300') {
		    $kota = $sipt->main->combobox("SELECT PROPINSI_ID, NAMA_PROPINSI FROM M_PROPINSI WHERE PROPINSI_ID LIKE '%73__%' OR PROPINSI_ID LIKE '%76__%' AND RIGHT(PROPINSI_ID, 2) <> '00'", "PROPINSI_ID", "NAMA_PROPINSI", TRUE);
		} else {
		    $propinsi = substr($this->newsession->userdata('SESS_PROP_ID'), 0, 2);
		    $kota = $sipt->main->combobox("SELECT PROPINSI_ID, NAMA_PROPINSI FROM M_PROPINSI WHERE PROPINSI_ID LIKE '" . $propinsi . "%' AND RIGHT(PROPINSI_ID, 2) <> '00'", "PROPINSI_ID", "NAMA_PROPINSI", TRUE);
		}
	    } else {
		$ret = 'piom';
		$bbpom = $sipt->main->combobox("SELECT BBPOM_ID, NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID NOT IN ('99','00')", "BBPOM_ID", "NAMA_BBPOM", TRUE);
	    }
	    $arrdata = array('jenisKlasifikasi' => $klasifikasi, 'disinput' => $disinput, 'kota' => $kota, 'bbpom' => $bbpom, 'idjudul' => 'judulpmnikl', 'batal' => site_url());
	    $arrdata['act'] = site_url() . '/iklan/iklanController/rekapitulasi/RHPK';
	    $arrdata['judul'] = 'RHPK Pengawasan Iklan';
	    return $arrdata;
	} else {
	    $this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.', '/home');
	}
    }

    function get_reportPengawasan($jenis = "") {
	if ($this->newsession->userdata('LOGGED_IN') == TRUE) {
	    $sipt = & get_instance();
	    $this->load->model("main", "main", true);
	    $disinput = array("JENISDIS", "NAMADIS");
//            $komoditi = "'" . join("','", $this->newsession->userdata("SESS_KLASIFIKASI_ID")) . "'";
	    $komoditi = "'001','007','010','011','012','013'";
	    $arrayClause = array('demo_1', 'demo_2', 'demo_3', 'demo_4', 'operator-pusat', '1001', '1002', '1003', '1004', '1005', 'administrator', 'opiklan');
	    if (in_array($this->newsession->userdata("SESS_USER_ID"), $arrayClause))
		$klasifikasi = $sipt->main->combobox("SELECT * FROM M_KLASIFIKASI_KATEGORI WHERE LEN(KK_ID) = 3 AND KK_ID IN ($komoditi)", "KK_ID", "NAMA_KK", TRUE);
	    else
		$klasifikasi = $sipt->main->combobox("SELECT * FROM M_KLASIFIKASI_KATEGORI WHERE LEN(KK_ID) = 3 AND KK_ID IN ('001')", "KK_ID", "NAMA_KK", TRUE);
	    $kecuali = $sipt->main->remove_element($this->config->item('cfg_unit'), $this->newsession->userdata('SESS_BBPOM_ID'));
	    $unit = "'" . join("','", $kecuali) . "'";
	    if (in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) {
		$ret = "SELECT BBPOM_ID, NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID NOT IN ('00','99',$unit)";
		$bbpom = $sipt->main->combobox("SELECT BBPOM_ID, NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID NOT IN ('00','99',$unit)", "BBPOM_ID", "NAMA_BBPOM", TRUE);
	    } else if ($this->newsession->userdata('SESS_BBPOM_ID') != "00" && !in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) {
		$ret = 'balai';
		$bbpom = $sipt->main->combobox("SELECT BBPOM_ID, NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID ='" . $this->newsession->userdata('SESS_BBPOM_ID') . "'", "BBPOM_ID", "NAMA_BBPOM");
		if ($this->newsession->userdata('SESS_PROP_ID') == '7100') {
		    $kota = $sipt->main->combobox("SELECT PROPINSI_ID, NAMA_PROPINSI FROM M_PROPINSI WHERE PROPINSI_ID LIKE '%71__%' OR PROPINSI_ID LIKE '%82__%' AND RIGHT(PROPINSI_ID, 2) <> '00'", "PROPINSI_ID", "NAMA_PROPINSI", TRUE);
		} else if ($this->newsession->userdata('SESS_PROP_ID') == '7300') {
		    $kota = $sipt->main->combobox("SELECT PROPINSI_ID, NAMA_PROPINSI FROM M_PROPINSI WHERE PROPINSI_ID LIKE '%73__%' OR PROPINSI_ID LIKE '%76__%' AND RIGHT(PROPINSI_ID, 2) <> '00'", "PROPINSI_ID", "NAMA_PROPINSI", TRUE);
		} else {
		    $propinsi = substr($this->newsession->userdata('SESS_PROP_ID'), 0, 2);
		    $kota = $sipt->main->combobox("SELECT PROPINSI_ID, NAMA_PROPINSI FROM M_PROPINSI WHERE PROPINSI_ID LIKE '" . $propinsi . "%' AND RIGHT(PROPINSI_ID, 2) <> '00'", "PROPINSI_ID", "NAMA_PROPINSI", TRUE);
		}
	    } else {
		$ret = 'piom';
		$bbpom = $sipt->main->combobox("SELECT BBPOM_ID, NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID NOT IN ('99','00')", "BBPOM_ID", "NAMA_BBPOM", TRUE);
	    }
	    $arrdata = array('jenisKlasifikasi' => $klasifikasi, 'disinput' => $disinput, 'kota' => $kota, 'bbpom' => $bbpom, 'idjudul' => 'judulpmnikl', 'batal' => site_url());
	    $arrdata['act'] = site_url() . '/iklan/iklanController/rekapitulasi/report';
	    $arrdata['judul'] = 'Report Pengawasan Iklan';
	    return $arrdata;
	} else {
	    $this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.', '/home');
	}
    }

    function get_reportRekapStatus($jenis = "") {
	if ($this->newsession->userdata('LOGGED_IN') == TRUE) {
	    $sipt = & get_instance();
	    $this->load->model("main", "main", true);
	    $kecuali = $sipt->main->remove_element($this->config->item('cfg_unit'), $this->newsession->userdata('SESS_BBPOM_ID'));
	    $unit = "'" . join("','", $kecuali) . "'";
	    if (in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) {
		$ret = "SELECT BBPOM_ID, NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID NOT IN ('00','99',$unit)";
		$bbpom = $sipt->main->combobox("SELECT BBPOM_ID, NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID NOT IN ('00','99',$unit)", "BBPOM_ID", "NAMA_BBPOM", TRUE);
	    } else if ($this->newsession->userdata('SESS_BBPOM_ID') != "00" && !in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) {
		$ret = 'balai';
		$bbpom = $sipt->main->combobox("SELECT BBPOM_ID, NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID ='" . $this->newsession->userdata('SESS_BBPOM_ID') . "'", "BBPOM_ID", "NAMA_BBPOM");
		if ($this->newsession->userdata('SESS_PROP_ID') == '7100') {
		    $kota = $sipt->main->combobox("SELECT PROPINSI_ID, NAMA_PROPINSI FROM M_PROPINSI WHERE PROPINSI_ID LIKE '%71__%' OR PROPINSI_ID LIKE '%82__%' AND RIGHT(PROPINSI_ID, 2) <> '00'", "PROPINSI_ID", "NAMA_PROPINSI", TRUE);
		} else if ($this->newsession->userdata('SESS_PROP_ID') == '7300') {
		    $kota = $sipt->main->combobox("SELECT PROPINSI_ID, NAMA_PROPINSI FROM M_PROPINSI WHERE PROPINSI_ID LIKE '%73__%' OR PROPINSI_ID LIKE '%76__%' AND RIGHT(PROPINSI_ID, 2) <> '00'", "PROPINSI_ID", "NAMA_PROPINSI", TRUE);
		} else {
		    $propinsi = substr($this->newsession->userdata('SESS_PROP_ID'), 0, 2);
		    $kota = $sipt->main->combobox("SELECT PROPINSI_ID, NAMA_PROPINSI FROM M_PROPINSI WHERE PROPINSI_ID LIKE '" . $propinsi . "%' AND RIGHT(PROPINSI_ID, 2) <> '00'", "PROPINSI_ID", "NAMA_PROPINSI", TRUE);
		}
	    } else {
		$ret = 'piom';
		$bbpom = $sipt->main->combobox("SELECT BBPOM_ID, NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID NOT IN ('99','00')", "BBPOM_ID", "NAMA_BBPOM", TRUE);
	    }
	    $arrdata = array('kota' => $kota, 'bbpom' => $bbpom, 'idjudul' => 'judulpmnikl', 'batal' => site_url());
	    $arrdata['act'] = site_url() . '/iklan/iklanController/rekapitulasi/statusDokumen';
	    $arrdata['judul'] = 'Rekapitulasi Status Pengawasan Iklan';
	    return $arrdata;
	} else {
	    $this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.', '/home');
	}
    }

    function monitoring() {
	if (array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('10', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('9', $this->newsession->userdata('SESS_KODE_ROLE')) || $this->newsession->userdata('LOGGED_IN') == TRUE) {
	    $sipt = & get_instance();
	    $this->load->model("main", "main", true);
	    $this->load->library('newtable');
	    $hasilAkhir = "(CASE WHEN dbo.GET_DATA_FROM_IKLAN(TI.IKLAN_ID) = 'MK' THEN 'Memenuhi Ketentuan' ELSE 'Tidak Memenuhi Ketentuan' END)";
	    $this->newtable->hiddens(array('IKLANID', 'LASTUPDATEROW'));
	    if ($this->newsession->userdata('SESS_BBPOM_ID') == "00") {
		$deleted = "";
		$ditwas = "";
	    } else {
		$deleted = " AND C.STATUS NOT IN ('00')";
		$ditwas = " AND TI.BBPOM_ID = '" . $this->newsession->userdata('SESS_BBPOM_ID') . "' AND TI.KOMODITI IN (" . "'" . join("','", $this->newsession->userdata("SESS_KLASIFIKASI_ID")) . "'" . ")";
	    }
	    if ($this->newsession->userdata('SESS_BBPOM_ID') == "00" || in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) {
		$this->newtable->search(array(array('', '')));
		$query .= "SELECT TI.LAST_UPDATE AS LASTUPDATEROW, (CAST(TI.IKLAN_ID AS VARCHAR)+'/'+CAST(TI.KOMODITI AS VARCHAR)+'/'+CAST(TI.STATUS AS VARCHAR))+'/'+CAST(TI.BBPOM_ID AS VARCHAR) AS IKLANID, dbo.GET_PRODUK_PENGAWASAN(TI.IKLAN_ID, 'IKLAN', 'PRODUK')+'<div><b><a href=\"#\" class=\"row_preview\">Lihat</a></b></div>' AS 'PRODUK IKLAN',CONVERT(VARCHAR(10), TI.TANGGAL_MULAI, 120)+'<div>Sampai Dengan</div><div>'+CONVERT(VARCHAR(10), TI.TANGGAL_AKHIR, 120)+'</div>' AS 'TANGGAL PENGAWASAN', '<div><b>'+MB.NAMA_BBPOM+'</b></div>' AS 'BB / BPOM', dbo.GET_KOMODITI(TI.KOMODITI) AS KOMODITI,CASE JENIS_IKLAN WHEN '' THEN '-' ELSE + '<div>'+TI.JENIS_IKLAN+' &raquo '+TI.MEDIA+'</div><div><b>'+CASE(SELECT COUNT(MM2.NAMA_MEDIA) AS MEDIA FROM M_MEDIA MM2 WHERE CONVERT(VARCHAR(100),MM2.ID_MEDIA) = TI.NAMA_MEDIA) WHEN 0 THEN (CASE CONVERT(VARCHAR(100), TI.NAMA_MEDIA) WHEN '0' THEN '-' ELSE CONVERT(VARCHAR(100), TI.NAMA_MEDIA) END) ELSE MM.NAMA_MEDIA END+'</b></div>' END AS MEDIA,'<div><b>'+" . $hasilAkhir . "+'</b></div>' AS HASIL, MT.URAIAN AS 'STATUS TERAKHIR', dbo.GET_HISTORY_IKLAN('PENGAWASAN', TI.IKLAN_ID)+'</div><div>'+dbo.GET_HISTORY_IKLAN('CATATAN', TI.IKLAN_ID)+'</div><div><a href=\"#\" class=\"row_riwayat2\" record=\"'+CAST(TI.IKLAN_ID AS VARCHAR)+'#T_IKLAN_PROSES\">Riwayat Pemeriksaan</a></div>' AS [UPDATE TERAKHIR] FROM T_IKLAN TI LEFT JOIN T_IKLAN_PROSES TIP ON TIP.IKLAN_ID = TI.IKLAN_ID LEFT JOIN T_USER TU ON TU.USER_ID = TI.USER_LAST_UPDATE LEFT JOIN M_TABEL MT ON MT.KODE = TI.STATUS LEFT JOIN M_MEDIA MM ON CONVERT(VARCHAR(10), MM.ID_MEDIA) = TI.NAMA_MEDIA LEFT JOIN M_BBPOM MB ON TI.BBPOM_ID = MB.BBPOM_ID WHERE TIP.SERI = (SELECT MAX (SERI) AS SERI FROM T_IKLAN_PROSES WHERE IKLAN_ID = TI.IKLAN_ID)";
		$this->newtable->columns(array("TI.LAST_UPDATE", "(CAST(TI.IKLAN_ID AS VARCHAR)+'/'+CAST(TI.KOMODITI AS VARCHAR)+'/'+CAST(TI.STATUS AS VARCHAR))+'/'+CAST(TI.BBPOM_ID AS VARCHAR)", "dbo.GET_PRODUK_PENGAWASAN(TI.IKLAN_ID, 'IKLAN', 'PRODUK')+'<div><b><a href=\"#\" class=\"row_preview\">Lihat</a></b></div>'", "CONVERT(VARCHAR(10), TANGGAL_MULAI, 120)+'<div>Sampai Dengan</div><div>'+CONVERT(VARCHAR(10), TANGGAL_AKHIR, 120)+'</div>'", "'<div><b>'+MB.NAMA_BBPOM+'</b></div>'", "dbo.GET_KOMODITI(TI.KOMODITI)", "CASE JENIS_IKLAN WHEN '' THEN '-' ELSE + '<div>'+TI.JENIS_IKLAN+' &raquo '+TI.MEDIA+'</div><div><b>'+CASE(SELECT COUNT(MM2.NAMA_MEDIA) AS MEDIA FROM M_MEDIA MM2 WHERE CONVERT(VARCHAR(100),MM2.ID_MEDIA) = TI.NAMA_MEDIA) WHEN 0 THEN (CASE CONVERT(VARCHAR(100), TI.NAMA_MEDIA) WHEN '0' THEN '-' ELSE CONVERT(VARCHAR(100), TI.NAMA_MEDIA) END) ELSE MM.NAMA_MEDIA END+'</b></div>' END", "'<div><b>'+" . $hasilAkhir . "+'</b></div>'", "MT.URAIAN", "dbo.GET_HISTORY_IKLAN('PENGAWASAN', TI.IKLAN_ID)+'</div><div>'+dbo.GET_HISTORY_IKLAN('CATATAN', TI.IKLAN_ID)+'</div><div><a href=\"#\" class=\"row_riwayat2\" record=\"'+CAST(TI.IKLAN_ID AS VARCHAR)+'#T_IKLAN_PROSES\">Riwayat Pemeriksaan</a></div>'"));
		$this->newtable->width(array('IKLAN OBAT' => 250, 'TANGGAL PENGAWASAN' => 150, 'KOMODITI' => 100, 'MEDIA' => 100, 'BB / BPOM' => 100, 'HASIL' => 100, 'STATUS TERAKHIR' => 125, 'UPDATE TERAKHIR' => 125));
		$this->newtable->orderby(1);
	    } else {
		$this->newtable->search(array(array('', '')));
		$query .= "SELECT TI.LAST_UPDATE AS LASTUPDATEROW, (CAST(TI.IKLAN_ID AS VARCHAR)+'/'+CAST(TI.KOMODITI AS VARCHAR)+'/'+CAST(TI.STATUS AS VARCHAR))+'/'+CAST(TI.BBPOM_ID AS VARCHAR) AS IKLANID, dbo.GET_PRODUK_PENGAWASAN(TI.IKLAN_ID, 'IKLAN', 'PRODUK')+'<div><b><a href=\"#\" class=\"row_preview\">Lihat</a></b></div>' AS 'PRODUK IKLAN',CONVERT(VARCHAR(10), TI.TANGGAL_MULAI, 120)+'<div>Sampai Dengan</div><div>'+CONVERT(VARCHAR(10), TI.TANGGAL_AKHIR, 120)+'</div>' AS 'TANGGAL PENGAWASAN', '<div><b>'+MB.NAMA_BBPOM+'</b></div>' AS 'BB / BPOM', dbo.GET_KOMODITI(TI.KOMODITI) AS KOMODITI,CASE JENIS_IKLAN WHEN '' THEN '-' ELSE + '<div>'+TI.JENIS_IKLAN+' &raquo '+TI.MEDIA+'</div><div><b>'+CASE(SELECT COUNT(MM2.NAMA_MEDIA) AS MEDIA FROM M_MEDIA MM2 WHERE CONVERT(VARCHAR(100),MM2.ID_MEDIA) = TI.NAMA_MEDIA) WHEN 0 THEN (CASE CONVERT(VARCHAR(100), TI.NAMA_MEDIA) WHEN '0' THEN '-' ELSE CONVERT(VARCHAR(100), TI.NAMA_MEDIA) END) ELSE MM.NAMA_MEDIA END+'</b></div>' END AS MEDIA,'<div><b>'+" . $hasilAkhir . "+'</b></div>' AS HASIL, MT.URAIAN AS 'STATUS TERAKHIR', dbo.GET_HISTORY_IKLAN('PENGAWASAN', TI.IKLAN_ID)+'</div><div>'+dbo.GET_HISTORY_IKLAN('CATATAN', TI.IKLAN_ID)+'</div><div><a href=\"#\" class=\"row_riwayat2\" record=\"'+CAST(TI.IKLAN_ID AS VARCHAR)+'#T_IKLAN_PROSES\">Riwayat Pemeriksaan</a></div>' AS [UPDATE TERAKHIR] FROM T_IKLAN TI LEFT JOIN T_IKLAN_PROSES TIP ON TIP.IKLAN_ID = TI.IKLAN_ID LEFT JOIN T_USER TU ON TU.USER_ID = TI.USER_LAST_UPDATE LEFT JOIN M_TABEL MT ON MT.KODE = TI.STATUS LEFT JOIN M_MEDIA MM ON CONVERT(VARCHAR(100),MM.ID_MEDIA) = TI.NAMA_MEDIA LEFT JOIN M_BBPOM MB ON TI.BBPOM_ID = MB.BBPOM_ID WHERE TIP.SERI = (SELECT MAX (SERI) AS SERI FROM T_IKLAN_PROSES WHERE IKLAN_ID = TI.IKLAN_ID) $ditwas";
		$this->newtable->columns(array("TI.LAST_UPDATE", "(CAST(TI.IKLAN_ID AS VARCHAR)+'/'+CAST(TI.KOMODITI AS VARCHAR)+'/'+CAST(TI.STATUS AS VARCHAR))+'/'+CAST(TI.BBPOM_ID AS VARCHAR)", "dbo.GET_PRODUK_PENGAWASAN(TI.IKLAN_ID, 'IKLAN', 'PRODUK')+'<div><b><a href=\"#\" class=\"row_preview\">Lihat</a></b></div>'", "CONVERT(VARCHAR(10), TANGGAL_MULAI, 120)+'<div>Sampai Dengan</div><div>'+CONVERT(VARCHAR(10), TANGGAL_AKHIR, 120)+'</div>'", "'<div><b>'+MB.NAMA_BBPOM+'</b></div>'", "dbo.GET_KOMODITI(TI.KOMODITI)", "CASE JENIS_IKLAN WHEN '' THEN '-' ELSE + '<div>'+TI.JENIS_IKLAN+' &raquo '+TI.MEDIA+'</div><div><b>'+CASE(SELECT COUNT(MM2.NAMA_MEDIA) AS MEDIA FROM M_MEDIA MM2 WHERE CONVERT(VARCHAR(100),MM2.ID_MEDIA) = TI.NAMA_MEDIA) WHEN 0 THEN (CASE CONVERT(VARCHAR(100), TI.NAMA_MEDIA) WHEN '0' THEN '-' ELSE CONVERT(VARCHAR(100), TI.NAMA_MEDIA) END) ELSE MM.NAMA_MEDIA END+'</b></div>' END", "'<div><b>'+" . $hasilAkhir . "+'</b></div>'", "MT.URAIAN", "dbo.GET_HISTORY_IKLAN('PENGAWASAN', TI.IKLAN_ID)+'</div><div>'+dbo.GET_HISTORY_IKLAN('CATATAN', TI.IKLAN_ID)+'</div><div><a href=\"#\" class=\"row_riwayat2\" record=\"'+CAST(TI.IKLAN_ID AS VARCHAR)+'#T_IKLAN_PROSES\">Riwayat Pemeriksaan</a></div>'"));
		$this->newtable->width(array('IKLAN OBAT' => 250, 'TANGGAL PENGAWASAN' => 150, 'KOMODITI' => 100, 'MEDIA' => 100, 'BB / BPOM' => 100, 'HASIL' => 100, 'STATUS TERAKHIR' => 125, 'UPDATE TERAKHIR' => 125));
		$this->newtable->orderby(1);
	    }
//      $proses['Edit Data Petugas Pemeriksa'] = array('GET', site_url() . "/home/pelaporan/petugas", '1');
//      $proses['Lihat Data Temuan Produk'] = array('GET', site_url() . "/home/produk/view", '1');
	    $proses['Lihat Data Pengawasan'] = array('GET', site_url() . "/iklan/iklanController/prosesPreview/preview", '1');
//      $proses['Cetak Form Pemeriksaan'] = array('GETNEW', site_url() . "/home/bap", '1');
	    if (array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')))
		$proses['Hapus Data Pemeriksaan'] = array('POST', site_url() . "/iklan/iklanController/prosesDelete/delete", 'N');

	    $this->newtable->action(site_url() . "/iklan/iklanController/monitoring");
	    $this->newtable->detail(site_url() . "/iklan/iklanController/setPreview/iklan");
	    $this->newtable->cidb($this->db);
	    $this->newtable->ciuri($this->uri->segment_array());
	    $this->newtable->sortby("DESC");
	    $this->newtable->keys(array('IKLANID'));
	    $this->newtable->menu($proses);
	    $this->newtable->show_search(FALSE);
	    $tabel = $this->newtable->generate($query);
	    $arrdata = array('table' => $tabel, 'search' => TRUE, 'frmsearch' => $sipt->main->_showformiklan(site_url() . '/iklan/iklanController/monitoringSrc', $cari, $subcari), 'idjudul' => 'judulpmnikl', 'caption_header' => 'Trakcing Pengawasan Iklan', 'batal' => '', 'cancel' => '');
	    return $arrdata;
	} else {
	    $this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.', '/home');
	}
    }

    function monitoring_act($cari, $subcari) {
	if (array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('10', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('9', $this->newsession->userdata('SESS_KODE_ROLE')) || $this->newsession->userdata('LOGGED_IN') == TRUE) {
	    $sipt = & get_instance();
	    $this->load->model("main", "main", true);
	    $this->load->library('newtable');
	    $uricari = explode("_", $cari);
	    $urisubcari = explode("_", $subcari);
	    $hasilAkhir = "(CASE WHEN dbo.GET_DATA_FROM_IKLAN(TI.IKLAN_ID) = 'MK' THEN 'Memenuhi Ketentuan' ELSE 'Tidak Memenuhi Ketentuan' END)";
	    $this->newtable->hiddens(array('IKLANID', 'LASTUPDATEROW'));
	    $this->newtable->search(array(array('', '')));
	    if ($this->newsession->userdata('SESS_BBPOM_ID') == "00")
		$deleted = "";
	    else
		$deleted = " AND C.STATUS NOT IN ('00')";
	    if ($this->newsession->userdata('SESS_BBPOM_ID') == "00" || in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) {
		$this->newtable->search(array(array('', '')));
		$query .= "SELECT TI.LAST_UPDATE AS LASTUPDATEROW, (CAST(TI.IKLAN_ID AS VARCHAR)+'/'+CAST(TI.KOMODITI AS VARCHAR)+'/'+CAST(TI.STATUS AS VARCHAR))+'/'+CAST(TI.BBPOM_ID AS VARCHAR) AS IKLANID, dbo.GET_PRODUK_PENGAWASAN(TI.IKLAN_ID, 'IKLAN', 'PRODUK')+'<div><b><a href=\"#\" class=\"row_preview\">Lihat</a></b></div>' AS 'PRODUK IKLAN',CONVERT(VARCHAR(10), TI.TANGGAL_MULAI, 120)+'<div>Sampai Dengan</div><div>'+CONVERT(VARCHAR(10), TI.TANGGAL_AKHIR, 120)+'</div>' AS 'TANGGAL PENGAWASAN', '<div><b>'+MB.NAMA_BBPOM+'</b></div>' AS 'BB / BPOM', dbo.GET_KOMODITI(TI.KOMODITI) AS KOMODITI,CASE JENIS_IKLAN WHEN '' THEN '-' ELSE + '<div>'+TI.JENIS_IKLAN+' &raquo '+TI.MEDIA+'</div><div><b>'+CASE(SELECT COUNT(MM2.NAMA_MEDIA) AS MEDIA FROM M_MEDIA MM2 WHERE CONVERT(VARCHAR(100),MM2.ID_MEDIA) = TI.NAMA_MEDIA) WHEN 0 THEN (CASE CONVERT(VARCHAR(100), TI.NAMA_MEDIA) WHEN '0' THEN '-' ELSE CONVERT(VARCHAR(100), TI.NAMA_MEDIA) END) ELSE MM.NAMA_MEDIA END+'</b></div>' END AS MEDIA,'<div><b>'+" . $hasilAkhir . "+'</b></div>' AS HASIL, MT.URAIAN AS 'STATUS TERAKHIR', dbo.GET_HISTORY_IKLAN('PENGAWASAN', TI.IKLAN_ID)+'</div><div>'+dbo.GET_HISTORY_IKLAN('CATATAN', TI.IKLAN_ID)+'</div><div><a href=\"#\" class=\"row_riwayat2\" record=\"'+CAST(TI.IKLAN_ID AS VARCHAR)+'#T_IKLAN_PROSES\">Riwayat Pemeriksaan</a></div>' AS [UPDATE TERAKHIR] FROM T_IKLAN TI LEFT JOIN T_IKLAN_PROSES TIP ON TIP.IKLAN_ID = TI.IKLAN_ID LEFT JOIN T_USER TU ON TU.USER_ID = TI.USER_LAST_UPDATE LEFT JOIN M_TABEL MT ON MT.KODE = TI.STATUS LEFT JOIN M_MEDIA MM ON CONVERT(VARCHAR(100),MM.ID_MEDIA) = TI.NAMA_MEDIA LEFT JOIN M_BBPOM MB ON TI.BBPOM_ID = MB.BBPOM_ID WHERE TIP.SERI = (SELECT MAX (SERI) AS SERI FROM T_IKLAN_PROSES WHERE IKLAN_ID = TI.IKLAN_ID)";
		$this->newtable->columns(array("TI.LAST_UPDATE", "(CAST(TI.IKLAN_ID AS VARCHAR)+'/'+CAST(TI.KOMODITI AS VARCHAR)+'/'+CAST(TI.STATUS AS VARCHAR))+'/'+CAST(TI.BBPOM_ID AS VARCHAR)", "dbo.GET_PRODUK_PENGAWASAN(TI.IKLAN_ID, 'IKLAN', 'PRODUK')+'<div><b><a href=\"#\" class=\"row_preview\">Lihat</a></b></div>'", "CONVERT(VARCHAR(10), TANGGAL_MULAI, 120)+'<div>Sampai Dengan</div><div>'+CONVERT(VARCHAR(10), TANGGAL_AKHIR, 120)+'</div>'", "'<div><b>'+MB.NAMA_BBPOM+'</b></div>'", "dbo.GET_KOMODITI(TI.KOMODITI)", "CASE JENIS_IKLAN WHEN '' THEN '-' ELSE + '<div>'+TI.JENIS_IKLAN+' &raquo '+TI.MEDIA+'</div><div><b>'+CASE(SELECT COUNT(MM2.NAMA_MEDIA) AS MEDIA FROM M_MEDIA MM2 WHERE CONVERT(VARCHAR(100),MM2.ID_MEDIA) = TI.NAMA_MEDIA) WHEN 0 THEN (CASE CONVERT(VARCHAR(100), TI.NAMA_MEDIA) WHEN '0' THEN '-' ELSE CONVERT(VARCHAR(100), TI.NAMA_MEDIA) END) ELSE MM.NAMA_MEDIA END+'</b></div>' END", "'<div><b>'+" . $hasilAkhir . "+'</b></div>'", "MT.URAIAN", "dbo.GET_HISTORY_IKLAN('PENGAWASAN', TI.IKLAN_ID)+'</div><div>'+dbo.GET_HISTORY_IKLAN('CATATAN', TI.IKLAN_ID)+'</div><div><a href=\"#\" class=\"row_riwayat2\" record=\"'+CAST(TI.IKLAN_ID AS VARCHAR)+'#T_IKLAN_PROSES\">Riwayat Pemeriksaan</a></div>'"));
		$this->newtable->width(array('IKLAN OBAT' => 250, 'TANGGAL PENGAWASAN' => 150, 'KOMODITI' => 100, 'MEDIA' => 100, 'BB / BPOM' => 100, 'HASIL' => 100, 'STATUS TERAKHIR' => 125, 'UPDATE TERAKHIR' => 125));
		$this->newtable->orderby(1);
	    } else {
		$this->newtable->search(array(array('', '')));
		$query .= "SELECT TI.LAST_UPDATE AS LASTUPDATEROW, (CAST(TI.IKLAN_ID AS VARCHAR)+'/'+CAST(TI.KOMODITI AS VARCHAR)+'/'+CAST(TI.STATUS AS VARCHAR))+'/'+CAST(TI.BBPOM_ID AS VARCHAR) AS IKLANID, dbo.GET_PRODUK_PENGAWASAN(TI.IKLAN_ID, 'IKLAN', 'PRODUK')+'<div><b><a href=\"#\" class=\"row_preview\">Lihat</a></b></div>' AS 'PRODUK IKLAN',CONVERT(VARCHAR(10), TI.TANGGAL_MULAI, 120)+'<div>Sampai Dengan</div><div>'+CONVERT(VARCHAR(10), TI.TANGGAL_AKHIR, 120)+'</div>' AS 'TANGGAL PENGAWASAN', '<div><b>'+MB.NAMA_BBPOM+'</b></div>' AS 'BB / BPOM', dbo.GET_KOMODITI(TI.KOMODITI) AS KOMODITI,CASE JENIS_IKLAN WHEN '' THEN '-' ELSE + '<div>'+TI.JENIS_IKLAN+' &raquo '+TI.MEDIA+'</div><div><b>'+CASE(SELECT COUNT(MM2.NAMA_MEDIA) AS MEDIA FROM M_MEDIA MM2 WHERE CONVERT(VARCHAR(100),MM2.ID_MEDIA) = TI.NAMA_MEDIA) WHEN 0 THEN (CASE CONVERT(VARCHAR(100), TI.NAMA_MEDIA) WHEN '0' THEN '-' ELSE CONVERT(VARCHAR(100), TI.NAMA_MEDIA) END) ELSE MM.NAMA_MEDIA END+'</b></div>' END AS MEDIA,'<div><b>'+" . $hasilAkhir . "+'</b></div>' AS HASIL, MT.URAIAN AS 'STATUS TERAKHIR', dbo.GET_HISTORY_IKLAN('PENGAWASAN', TI.IKLAN_ID)+'</div><div>'+dbo.GET_HISTORY_IKLAN('CATATAN', TI.IKLAN_ID)+'</div><div><a href=\"#\" class=\"row_riwayat2\" record=\"'+CAST(TI.IKLAN_ID AS VARCHAR)+'#T_IKLAN_PROSES\">Riwayat Pemeriksaan</a></div>' AS [UPDATE TERAKHIR] FROM T_IKLAN TI LEFT JOIN T_IKLAN_PROSES TIP ON TIP.IKLAN_ID = TI.IKLAN_ID LEFT JOIN T_USER TU ON TU.USER_ID = TI.USER_LAST_UPDATE LEFT JOIN M_TABEL MT ON MT.KODE = TI.STATUS LEFT JOIN M_MEDIA MM ON CONVERT(VARCHAR(100),MM.ID_MEDIA) = TI.NAMA_MEDIA LEFT JOIN M_BBPOM MB ON TI.BBPOM_ID = MB.BBPOM_ID WHERE TIP.SERI = (SELECT MAX (SERI) AS SERI FROM T_IKLAN_PROSES WHERE IKLAN_ID = TI.IKLAN_ID) AND TI.BBPOM_ID = '" . $this->newsession->userdata('SESS_BBPOM_ID') . "'";
		$this->newtable->columns(array("TI.LAST_UPDATE", "(CAST(TI.IKLAN_ID AS VARCHAR)+'/'+CAST(TI.KOMODITI AS VARCHAR)+'/'+CAST(TI.STATUS AS VARCHAR))+'/'+CAST(TI.BBPOM_ID AS VARCHAR)", "dbo.GET_PRODUK_PENGAWASAN(TI.IKLAN_ID, 'IKLAN', 'PRODUK')+'<div><b><a href=\"#\" class=\"row_preview\">Lihat</a></b></div>'", "CONVERT(VARCHAR(10), TANGGAL_MULAI, 120)+'<div>Sampai Dengan</div><div>'+CONVERT(VARCHAR(10), TANGGAL_AKHIR, 120)+'</div>'", "'<div><b>'+MB.NAMA_BBPOM+'</b></div>'", "dbo.GET_KOMODITI(TI.KOMODITI)", "CASE JENIS_IKLAN WHEN '' THEN '-' ELSE + '<div>'+TI.JENIS_IKLAN+' &raquo '+TI.MEDIA+'</div><div><b>'+CASE(SELECT COUNT(MM2.NAMA_MEDIA) AS MEDIA FROM M_MEDIA MM2 WHERE CONVERT(VARCHAR(100),MM2.ID_MEDIA) = TI.NAMA_MEDIA) WHEN 0 THEN (CASE CONVERT(VARCHAR(100), TI.NAMA_MEDIA) WHEN '0' THEN '-' ELSE CONVERT(VARCHAR(100), TI.NAMA_MEDIA) END) ELSE MM.NAMA_MEDIA END+'</b></div>' END", "'<div><b>'+" . $hasilAkhir . "+'</b></div>'", "MT.URAIAN", "dbo.GET_HISTORY_IKLAN('PENGAWASAN', TI.IKLAN_ID)+'</div><div>'+dbo.GET_HISTORY_IKLAN('CATATAN', TI.IKLAN_ID)+'</div><div><a href=\"#\" class=\"row_riwayat2\" record=\"'+CAST(TI.IKLAN_ID AS VARCHAR)+'#T_IKLAN_PROSES\">Riwayat Pemeriksaan</a></div>'"));
		$this->newtable->width(array('IKLAN OBAT' => 250, 'TANGGAL PENGAWASAN' => 150, 'KOMODITI' => 100, 'MEDIA' => 100, 'BB / BPOM' => 100, 'HASIL' => 100, 'STATUS TERAKHIR' => 125, 'UPDATE TERAKHIR' => 125));
		$this->newtable->orderby(1);
	    }
//      $proses['Edit Data Petugas Pemeriksa'] = array('GET', site_url() . "/home/pelaporan/petugas", '1');
//      $proses['Lihat Data Temuan Produk'] = array('GET', site_url() . "/home/produk/view", '1');
	    $proses['Lihat Data Pengawasan'] = array('GET', site_url() . "/iklan/iklanController/prosesPreview/preview", '1');
//      $proses['Cetak Form Pemeriksaan'] = array('GETNEW', site_url() . "/home/bap", '1');
	    if (array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')))
		$proses['Hapus Data Pemeriksaan'] = array('POST', site_url() . "/iklan/iklanController/prosesDelete/delete", 'N');
	    $this->newtable->action(site_url() . "/iklan/iklanController/monitoringSrc/" . $cari . "/" . $subcari);
	    $this->newtable->detail(site_url() . "/iklan/iklanController/setPreview/iklan");
	    $this->newtable->cidb($this->db);
	    $this->newtable->ciuri($this->uri->segment_array());
	    $this->newtable->sortby("DESC");
	    $this->newtable->keys(array('IKLANID'));
	    $this->newtable->menu($proses);
	    $this->newtable->show_search(FALSE);
	    if ($uricari[0] != "ALL")
		$query .= " AND TI.SURAT_ID IN (SELECT TSTI2.SURAT_ID FROM T_SURAT_TUGAS_IKLAN TSTI2 WHERE TSTI2.NOMOR_SURAT = '" . $uricari[0] . "')";
	    if ($uricari[1] != "ALL")
		$query .= " AND DATEDIFF(dy, 0, convert(DATETIME, TI.TANGGAL_MULAI, 105)) >= DATEDIFF(dy, 0, convert(DATETIME, '" . $uricari[1] . "', 105))";
	    if ($uricari[2] != "ALL")
		$query .= " AND DATEDIFF(dy, 0, convert(DATETIME, TI.TANGGAL_AKHIR, 105)) <= DATEDIFF(dy, 0, convert(DATETIME, '" . $uricari[2] . "', 105))";
	    if ($uricari[3] != "ALL")
		$query .= " AND TI.STATUS = '" . $uricari[3] . "'";
	    if ($urisubcari[0] != "ALL")
		$query .= " AND TSTI.CREATED_BY = '" . $urisubcari[0] . "'";
	    if ($urisubcari[1] != "ALL")
		$query .= " AND TI.BBPOM_ID = '" . $urisubcari[1] . "'";
	    if ($urisubcari[2] != "ALL")
		$query .= " AND dbo.GET_DATA_FROM_IKLAN(TI.IKLAN_ID) = '" . $urisubcari[2] . "'";
	    if ($urisubcari[3] != "ALL")
		$query .= " AND TI.KOMODITI = '" . $urisubcari[3] . "'";
	    $tabel = $this->newtable->generate($query);
	    $arrdata = array('table' => $tabel, 'search' => TRUE, 'frmsearch' => $sipt->main->_showformiklan(site_url() . '/iklan/iklanController/monitoringSrc', $cari, $subcari), 'idjudul' => 'judulpmnikl', 'caption_header' => 'Trakcing Pengawasan Iklan', 'batal' => '', 'cancel' => '');
	    return $arrdata;
	} else {
	    $this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.', '/home');
	}
    }

    function rekapStatusDokumen() {
	if ($this->newsession->userdata('LOGGED_IN') == TRUE) {
	    $sipt = & get_instance();
	    $this->load->model("main", "main", true);
	    $this->load->library('newphpexcel');
	    $komoditi = "'" . join("','", $this->newsession->userdata("SESS_KLASIFIKASI_ID")) . "'";
	    $query = "SELECT *, ([OPBALAIDRAFT] + [OPBALAIREJECT] + [OPBALAIREV] + [SPV1BALAITL] + [SPV1BALAIREJECT] + [SPV1BALAIREV] + [SPV2BALAITL] + [SPV2BALAIREJECT] + [SPV2BALAIREV] + [KABALAI] + [TLBALAI] + [OPPUSATDRAFT] + [OPPUSATREJECT] + [OPPUSATREV] + [SPV1PUSATTL] + [SPV1PUSATREJECT] + [SPV1PUSATREV] + [SPV2PUSATTL] + [SPV2PUSATREJECT] + [SPV2PUSATREV] + [DIREKTUR] + [SELESAI]) as TOTAL FROM(SELECT REPLACE(REPLACE(C.NAMA_BBPOM,'BALAI BESAR POM', 'BBPOM'),'BALAI POM','BPOM') AS NAMA_BBPOM, CASE WHEN A.STATUS = '20301' THEN 'OPBALAIDRAFT' WHEN A.STATUS = '20302' THEN 'OPBALAIREJECT' WHEN A.STATUS = '20303' THEN 'OPBALAIREV' WHEN A.STATUS = '30301' THEN 'SPV1BALAITL' WHEN A.STATUS = '30302' THEN 'SPV1BALAIREJECT' WHEN A.STATUS = '30304' THEN 'SPV1BALAIREV' WHEN A.STATUS = '40301' THEN 'SPV2BALAITL' WHEN A.STATUS = '40302' THEN 'SPV2BALAIREJECT' WHEN A.STATUS = '40303' THEN 'SPV2BALAIREV' WHEN A.STATUS = '50301' THEN 'KABALAI' WHEN A.STATUS = '20315' THEN 'TLBALAI' WHEN A.STATUS = '20311' THEN 'OPPUSATDRAFT' WHEN A.STATUS = '20312' THEN 'OPPUSATREJECT' WHEN A.STATUS = '20313' THEN 'OPPUSATREV' WHEN A.STATUS = '30311' THEN 'SPV1PUSATTL' WHEN A.STATUS = '30312' THEN 'SPV1PUSATREJECT' WHEN A.STATUS = '30314' THEN 'SPV1PUSATREV' WHEN A.STATUS = '40311' THEN 'SPV2PUSATTL' WHEN A.STATUS = '40312' THEN 'SPV2PUSATREJECT' WHEN A.STATUS = '40313' THEN 'SPV2PUSATREV' WHEN A.STATUS = '60311' THEN 'DIREKTUR' WHEN A.STATUS = '60310' THEN 'SELESAI' END AS STATUS FROM T_IKLAN A LEFT JOIN T_IKLAN_PROSES TIP ON TIP.IKLAN_ID = A.IKLAN_ID LEFT JOIN M_BBPOM C ON A.BBPOM_ID = C.BBPOM_ID WHERE TIP.SERI = (SELECT MAX (SERI) AS SERI FROM T_IKLAN_PROSES WHERE IKLAN_ID = A.IKLAN_ID) AND A.KOMODITI IN ($komoditi) ";
	    if (trim($this->input->post('AWAL') != "")) {
		$query .= $sipt->main->find_where($query);
		$query .= " DATEDIFF(dy, 0, convert(DATETIME, A.TANGGAL_MULAI, 105)) >= DATEDIFF(dy, 0, convert(DATETIME, '" . $this->input->post('AWAL') . "', 105))";
		$awal = $this->input->post('AWAL');
	    } else {
		$query .= $sipt->main->find_where($query);
		$query .= " A.TANGGAL_MULAI > DATEADD(M, DATEDIFF(M,0,GETDATE()),0)";
		$awal = date('01/m/Y');
	    }
	    if (trim($this->input->post('AKHIR') != "")) {
		$query .= $sipt->main->find_where($query);
		$query .= " DATEDIFF(dy, 0, convert(DATETIME, A.TANGGAL_AKHIR, 105)) <= DATEDIFF(dy, 0, convert(DATETIME, '" . $this->input->post('AKHIR') . "', 105))";
		$akhir = $this->input->post('AKHIR');
	    } else {
		$query .= $sipt->main->find_where($query);
		$query .= " A.TANGGAL_AKHIR < DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,0,GETDATE())+1,0))";
		$akhir = date('t/m/Y');
	    }
	    if (in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')) || $this->newsession->userdata('SESS_BBPOM_ID') == "00") {
		if (trim($this->input->post('BBPOM_ID')) == "") {
		    $query .= "";
		    $balai = 'Seluruh Balai';
		} else {
		    $query .= $sipt->main->find_where($query);
		    $query .= " A.BBPOM_ID = '" . $this->input->post('BBPOM_ID') . "'";
		    $balai = $sipt->main->get_uraian("SELECT NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID = '" . $this->input->post('BBPOM_ID') . "'", "NAMA_BBPOM");
		}
	    } else {
		$query .= $sipt->main->find_where($query);
		$query .= " A.BBPOM_ID = '" . $this->newsession->userdata('SESS_BBPOM_ID') . "'";
		$balai = $sipt->main->get_uraian("SELECT NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID = '" . $this->newsession->userdata('SESS_BBPOM_ID') . "'", "NAMA_BBPOM");
	    }
	    $query .= $sipt->main->find_where($query);
	    $query .= " LEN(A.STATUS) > 2";
	    $query .= ") DT PIVOT(COUNT(STATUS) FOR STATUS IN ([OPBALAIDRAFT], [OPBALAIREJECT], [OPBALAIREV], [SPV1BALAITL], [SPV1BALAIREJECT], [SPV1BALAIREV], [SPV2BALAITL], [SPV2BALAIREJECT], [SPV2BALAIREV], [KABALAI], [TLBALAI], [OPPUSATDRAFT], [OPPUSATREJECT], [OPPUSATREV], [SPV1PUSATTL], [SPV1PUSATREJECT], [SPV1PUSATREV], [SPV2PUSATTL], [SPV2PUSATREJECT], [SPV2PUSATREV], [DIREKTUR], [SELESAI],[DIRETURNKEBALAI])) PVT";
	    $this->newphpexcel->getDefaultStyle()->getFont()->setName('Calibri')->setSize(10);
	    $this->newphpexcel->setActiveSheetIndex(0);
	    $this->newphpexcel->mergecell(array(array('A6', 'A7'), array('B6', 'B7'), array('C6', 'E6'), array('F6', 'H6'), array('I6', 'K6'), array('L6', 'L7'), array('M6', 'P6'), array('Q6', 'S6'), array('T6', 'V6'), array('W6', 'W7'), array('X6', 'X7'), array('Y6', 'Y7')), TRUE);
	    $this->newphpexcel->width(array(array('A', 4), array('B', 30), array('C', 7), array('D', 7), array('E', 9), array('F', 7), array('G', 7), array('H', 9), array('I', 7), array('J', 7), array('K', 9), array('L', 9), array('M', 9), array('N', 9), array('O', 8), array('P', 9), array('Q', 7), array('R', 9), array('S', 9), array('T', 7), array('U', 9), array('V', 9), array('W', 8), array('X', 8), array('Y', 8)));
	    $this->newphpexcel->set_bold(array('A1'));
	    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A1', 'REKAPITULASI STATUS DOKUMEN PENGAWASAN IKLAN')->setCellValue('A3', 'Pemeriksaan Awal')->setCellValue('C3', $awal)->setCellValue('A4', 'Pemeriksaan Akhir')->setCellValue('C4', $akhir)->setCellValue('A5', 'Balai Besar / Balai POM')->setCellValue('C5', $balai);
	    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A6', 'No.')->setCellValue('B6', 'BB / BPOM / UNIT DITWAS')->setCellValue('C6', 'Operator Balai')->setCellValue('F6', 'SPV Satu Balai')->setCellValue('I6', 'SPV Dua Balai')->setCellValue('L6', 'Ka. Balai')->setCellValue('M6', 'Operator Pusat')->setCellValue('Q6', 'SPV Satu Pusat')->setCellValue('T6', 'SPV Dua Pusat')->setCellValue('W6', 'Direktur')->setCellValue('X6', 'Selesai')->setCellValue('Y6', 'Total')->setCellValue('C7', 'Draft')->setCellValue('D7', 'Ditolak')->setCellValue('E7', 'Perbaikan')->setCellValue('F7', 'Tindak Lanjut')->setCellValue('G7', 'Ditolak')->setCellValue('H7', 'Perbaikan')->setCellValue('I7', 'Tindak Lanjut')->setCellValue('J7', 'Ditolak Ka. Balai')->setCellValue('K7', 'Perbaikan')->setCellValue('M7', 'TL Balai')->setCellValue('N7', 'Draft Pusat')->setCellValue('O7', 'Ditolak')->setCellValue('P7', 'Perbaikan')->setCellValue('Q7', 'Tindak Lanjut')->setCellValue('R7', 'Ditolak')->setCellValue('S7', 'Perbaikan')->setCellValue('T7', 'Tindak Lanjut')->setCellValue('U7', 'Ditolak Direktur')->setCellValue('V7', 'Perbaikan');
	    $this->newphpexcel->headings(array('A7', 'B7', 'C7', 'D7', 'E7', 'F7', 'G7', 'H7', 'I7', 'J7', 'K7', 'L7', 'M7', 'N7', 'O7', 'P7', 'Q7', 'R7', 'S7', 'T7', 'U7', 'V7', 'W7', 'X7', 'Y7'));
	    $this->newphpexcel->headings(array('A6', 'B6', 'C6', 'D6', 'E6', 'F6', 'G6', 'H6', 'I6', 'J6', 'K6', 'L6', 'M6', 'N6', 'O6', 'P6', 'Q6', 'R6', 'S6', 'T6', 'U6', 'V6', 'W6', 'X6', 'Y6'));
	    $this->newphpexcel->set_wrap(array('C7', 'D7', 'E7', 'F7', 'G7', 'H7', 'I7', 'J7', 'K7', 'L7', 'M7', 'N7', 'O7', 'P7', 'Q7', 'R7', 'S7', 'T7', 'U7', 'V7', 'W7', 'X7', 'Y6'));
	    $data = $sipt->main->get_result($query);
	    if ($data) {
		$no = 1;
		$rec = 8;
		foreach ($query->result_array() as $row) {
		    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A' . $rec, $no)->setCellValue('B' . $rec, strtoupper($row["NAMA_BBPOM"]))->setCellValue('C' . $rec, $row["OPBALAIDRAFT"])->setCellValue('D' . $rec, $row["OPBALAIREJECT"])->setCellValue('E' . $rec, $row["OPBALAIREV"])->setCellValue('F' . $rec, $row["SPV1BALAITL"])->setCellValue('G' . $rec, $row["SPV1BALAIREJECT"])->setCellValue('H' . $rec, $row["SPV1BALAIREV"])->setCellValue('I' . $rec, $row["SPV2BALAITL"])->setCellValue('J' . $rec, $row["SPV2BALAIREJECT"])->setCellValue('K' . $rec, $row["SPV2BALAIREV"])->setCellValue('L' . $rec, $row["KABALAI"])->setCellValue('M' . $rec, $row["TLBALAI"])->setCellValue('N' . $rec, $row["OPPUSATDRAFT"])->setCellValue('O' . $rec, $row["OPPUSATREJECT"])->setCellValue('P' . $rec, $row["OPPUSATREV"])->setCellValue('Q' . $rec, $row["SPV1PUSATTL"])->setCellValue('R' . $rec, $row["SPV1PUSATREJECT"])->setCellValue('S' . $rec, $row["SPV1PUSATREV"])->setCellValue('T' . $rec, $row["SPV2PUSATTL"])->setCellValue('U' . $rec, $row["SPV2PUSATREJECT"])->setCellValue('V' . $rec, $row["SPV2PUSATREV"])->setCellValue('W' . $rec, $row["DIREKTUR"])->setCellValue('X' . $rec, $row["SELESAI"])->setCellValue('Y' . $rec, '=SUM(C' . $rec . ':X' . $rec . ')');
		    $this->newphpexcel->set_detilstyle(array('A' . $rec, 'B' . $rec, 'C' . $rec, 'D' . $rec, 'E' . $rec, 'F' . $rec, 'G' . $rec, 'H' . $rec, 'I' . $rec, 'J' . $rec, 'K' . $rec, 'L' . $rec, 'M' . $rec, 'N' . $rec, 'O' . $rec, 'P' . $rec, 'Q' . $rec, 'R' . $rec, 'S' . $rec, 'T' . $rec, 'U' . $rec, 'V' . $rec, 'W' . $rec, 'X' . $rec, 'Y' . $rec));
		    $rec++;
		    $no++;
		}
	    } else {
		$this->newphpexcel->getActiveSheet()->mergeCells('A8:Y8');
		$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A8', 'Data Tidak Ditemukan');
	    }
	    ob_clean();
	    $file = "REKAP_STATUS_DOC_" . date("YmdHis") . ".xls";
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