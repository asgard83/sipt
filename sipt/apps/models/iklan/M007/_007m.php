<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
error_reporting(E_ERROR);

class _007M extends Model {

    function getFormIklan($klasifikasi = '') {
	if ($this->newsession->userdata('LOGGED_IN') == TRUE) {
	    $sipt = & get_instance();
	    $this->load->model("main", "main", true);
	    $sipt->load->model('iklan/iklan_act');
	    $roleOri = $sipt->iklan_act->getRole();
	    $kodeProvinsi = substr($this->newsession->userdata('SESS_PROP_ID'), 0, 2);
	    $detailProvinsiDef = $sipt->main->combobox("SELECT PROPINSI_ID, NAMA_PROPINSI FROM M_PROPINSI WHERE LEFT(PROPINSI_ID, 2) = '" . $kodeProvinsi . "' AND RIGHT(PROPINSI_ID, 2) != '00'", "PROPINSI_ID", "NAMA_PROPINSI", TRUE);
	    $provinsi = $sipt->main->combobox("SELECT PROPINSI_ID, NAMA_PROPINSI FROM M_PROPINSI WHERE LEFT(PROPINSI_ID, 1) <= '9' AND RIGHT(PROPINSI_ID, 2) = '00'", "PROPINSI_ID", "NAMA_PROPINSI", TRUE);
	    $arrdata = array('provinsi' => $provinsi, 'kabupaten' => $detailProvinsiDef, 'act' => site_url() . '/iklan/iklanController/setFormIklanLanjutan/pengawasan/' . $klasifikasi, 'batal' => site_url() . '/home/iklan/PengawasanIklan', 'histori_petugas' => site_url() . '/load/petugas/get_petugas_2/');
	    $arrayTDK[''] = NULL;
	    $arrayTDK['Peringatan 1'] = 'Peringatan 1';
	    $arrayTDK['Peringatan 2'] = 'Peringatan 2';
	    $arrayTDK['Peringatan Keras'] = 'Peringatan Keras';
	    $arrayTDK['Penghentian Sementara Kegiatan'] = 'Penghentian Sementara Kegiatan';
	    $arrayTDK['Penghentian Dan Penarikan Iklan'] = 'Penghentian Dan Penarikan Iklan';
	    $arrdata ['cb_tindakan'] = $arrayTDK;
	    $arrayTL[''] = NULL;
	    $arrayTL['TL'] = 'Tindak Lanjut';
	    $arrayTL['STL'] = 'Sudah Tindak Lanjut';
	    $arrayTL['TTL'] = 'Tidak Dapat Tindak Lanjut';
	    $arrdata ['cb_tl'] = $arrayTL;
	    $arrayTDKB = array('' => '', '1' => 'Rekomendasi Ke Dinas Setempat');
	    $arrdata ['cb_tindakan_balai'] = $arrayTDKB;
	    $arrdata ['jenisKmsn'] = $sipt->main->combobox("SELECT URAIAN, KODE FROM M_TABEL WHERE JENIS = 'BK_NPZ'", "KODE", "URAIAN", TRUE);
	    $arrdata ['objStatus'] = 'TO';
	    $arrdata ['role'] = $roleOri;
	    $arrdata ['labelSimpan'] = 'Simpan Data Pengawasan';
	    $arrdata ['icon'] = 'save';
	    $arrdata ['klasifikasi'] = $klasifikasi;
	    $arrdata['romawi1_2'] = array("" => "", "02" => "Sesuai", "12" => "Lengkap", "22" => "Tidak Sesuai", "32" => "Tidak Lengkap");
	    $arrdata['romawi1_4'] = array("" => "", "04" => "Proporsional", "14" => "Tidak proporsional", "24" => "Tidak Mencantumkan");
	    $arrdata['radio_no_2'] = array("" => "", "04" => "Proporsional", "14" => "Tidak proporsional", "21" => "Tidak Memuat");
	    return $arrdata;
	} else {
	    $this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.', '/home');
	}
    }

    function setFormIklan($isajax) {
	if ($isajax != "ajax") {
	    redirect(base_url());
	    exit();
	}
	$sipt = & get_instance();
	$sipt->load->model("main", "main", true);
	$ret = "MSG#NO#Data gagal disimpan";
	$case = "";
	$cause = "";
	$arr_iklan = $this->input->post('IKLAN');
	$arr_iklan_ct = $this->input->post('CETAK');
	$arr_iklan_rd = $this->input->post('RADIO');
	$arr_iklan_tv = $this->input->post('TV');
	$arr_iklan_ti = $this->input->post('TI');
	$arr_iklan_lr = $this->input->post('LUARRUANG');
	$arr_iklan_napza = $this->input->post('IKLANNAPZA');
	$lampiran = $this->input->post('IKLAN_NAPZA');
	$arr_produk = $this->input->post('PRODUK');
	$arr_petugas = $this->session->userdata('USER');
	$suratTugas = $this->session->userdata('SURAT');
	$iklan_id = (int) $sipt->main->get_uraian("SELECT MAX(IKLAN_ID) AS MAXIKLAN FROM T_IKLAN", "MAXIKLAN") + 1;
	$suratId = (int) $sipt->main->get_uraian("SELECT MAX(SURAT_ID) AS MAXID FROM T_SURAT_TUGAS_IKLAN", "MAXID") + 1;
	if (trim($arr_iklan_ct[1]) != "") {
	    $cause = "CT";
	    for ($i = 1; $i <= count($arr_iklan_ct); $i++) {
		if ($i == 7)
		    $arrUraian[$i] = join("^", $arr_iklan_ct[$i]);
		else
		    $arrUraian[$i] = $arr_iklan_ct[$i];
	    }
	    $arr_penilaian = join("#", $arrUraian);
	} else if (trim($arr_iklan_rd[2]) != "") {
	    $cause = "RD";
	    for ($i = 1; $i <= count($arr_iklan_rd); $i++) {
		if ($i == 1)
		    $arrUraian[$i] = join("^", $arr_iklan_rd[$i]);
		else
		    $arrUraian[$i] = $arr_iklan_rd[$i];
	    }
	    $arr_penilaian = join("#", $arrUraian);
	} else if (trim($arr_iklan_tv[1]) != "") {
	    $cause = "TV";
	    for ($i = 1; $i <= count($arr_iklan_tv); $i++) {
		if ($i == 7 || $i == 10)
		    $arrUraian[$i] = join("^", $arr_iklan_tv[$i]);
		else
		    $arrUraian[$i] = $arr_iklan_tv[$i];
	    }
	    $arr_penilaian = join("#", $arrUraian);
	} else if (trim($arr_iklan_ti[1]) != "") {
	    $cause = "TI";
	    for ($i = 1; $i <= count($arr_iklan_ti); $i++) {
		if ($i == 7)
		    $arrUraian[$i] = join("^", $arr_iklan_ti[$i]);
		else
		    $arrUraian[$i] = $arr_iklan_ti[$i];
	    }
	    $arr_penilaian = join("#", $arrUraian);
	} else if (trim($arr_iklan_lr[1]) != "") {
	    $cause = "LR";
	    for ($i = 1; $i <= count($arr_iklan_lr); $i++) {
		if ($i == 7)
		    $arrUraian[$i] = join("^", $arr_iklan_lr[$i]);
		else
		    $arrUraian[$i] = $arr_iklan_lr[$i];
	    }
	    $arr_penilaian = join("#", $arrUraian);
	}
	$tanggalSurat = $this->session->userdata('TANGGAL');
	if ($arr_iklan['DETAIL_PUSAT'][0] != "")
	    $dTindakLanjut = join("^", $arr_iklan['DETAIL_PUSAT']);
	else
	    $dTindakLanjut = NULL;
	if ($arr_iklan['TL_PUSAT'][0] != "")
	    $tindakLanjut = join("^", $arr_iklan['TL_PUSAT']);
	else
	    $tindakLanjut = NULL;
	if (empty($this->session->userdata['SURAT']) || $this->session->userdata['SURAT'] == '-') {
	    $suratTugas = "";
	}
	if (empty($this->session->userdata['TANGGAL'])) {
	    $tanggalSurat = NULL;
	}
	if (in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')))
	    $status = '20311';
	else if (!in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')))
	    $status = '20301';
	if ($arr_iklan['TANGGAL'] != "")
	    $tglTugas = $arr_iklan['TANGGAL'];
	else
	    $tglTugas = NULL;
	if (count($arr_petugas[0]) > 0) {
	    for ($i = 0; $i < count($arr_petugas[0]); $i++) {
		$surat = array('SURAT_ID' => $suratId, 'NOMOR_SURAT' => $suratTugas, 'TANGGAL' => $tanggalSurat, 'BALAI' => $this->newsession->userdata('SESS_BBPOM_ID'), 'PETUGAS' => $arr_petugas[0][$i], 'CREATED_BY' => $this->newsession->userdata('SESS_USER_ID'), 'CREATED' => 'GETDATE()');
		$this->db->insert('T_SURAT_TUGAS_IKLAN', $surat);
	    }
	}
	foreach ($arr_iklan['MEDIA'] as $a) {
	    $media .= $a;
	}
	$justifikasi = NULL;
	if (trim($arr_iklan_lr[1]) != "") {
	    $edisi = $arr_iklan['EDISI'];
	} else {
	    if (trim($arr_iklan['EDISI1'] . $arr_iklan['EDISI2']) != '')
		$edisi = $arr_iklan['EDISI1'] . '^' . $arr_iklan['EDISI2'];
	    else
		$edisi = "-";
	}
	if (($arr_iklan['HASIL_PUSAT'] != $arr_iklan['HASIL']) && $this->input->post('JUSTIFIKASI'))
	    $justifikasi = $this->input->post('JUSTIFIKASI');
	$iklan = array('SURAT_ID' => $suratId, 'IKLAN_ID' => $iklan_id, 'BBPOM_ID' => $this->newsession->userdata('SESS_BBPOM_ID'), 'TANGGAL_MULAI' => $arr_iklan['TANGGALAWAL'], 'TANGGAL_AKHIR' => $arr_iklan['TANGGALAKHIR'], 'KOMODITI' => $this->input->post('KLASIFIKASIIKLAN'), 'JENIS_IKLAN' => $arr_iklan['JENISIKLAN'], 'MEDIA' => $media, 'NAMA_MEDIA' => $arr_iklan['NAMA'], 'JUDUL_KEGIATAN' => $arr_iklan['JUDUL'], 'TANGGAL' => $tglTugas, 'NAMA_LOKASI_IKLAN' => $arr_iklan['LOKASI'], 'ALAMAT_LOKASI_IKLAN' => $arr_iklan['ALAMAT'], 'KOTA' => $arr_iklan['KOTA'], 'EDISI' => $edisi, 'JAM_TAYANG' => $arr_iklan['TAYANG1'] . ' ' . trim($arr_iklan['TAYANG2']), 'STATUS' => $status, 'HASIL' => $arr_iklan['HASIL'], 'HASIL_PUSAT' => $arr_iklan['HASIL_PUSAT'], 'TL_PUSAT' => $tindakLanjut, 'DETAIL_PUSAT' => $dTindakLanjut, 'JUSTIFIKASI_PUSAT' => $justifikasi, 'USER_LAST_UPDATE' => $this->newsession->userdata('SESS_USER_ID'), 'LAST_UPDATE' => 'GETDATE()', 'CREATE_BY' => $this->newsession->userdata('SESS_USER_ID'));
	$this->db->insert('T_IKLAN', $iklan);
	if ($this->db->affected_rows() > 0) {
	    $seri = (int) $sipt->main->get_uraian("SELECT MAX(SERI) AS MAXID FROM T_IKLAN_PROSES WHERE IKLAN_ID = '" . $iklan_id . "'", "MAXID") + 1;
	    $log = array('IKLAN_ID' => $iklan_id, 'SERI' => $seri, 'STATUS' => $status, 'CATATAN' => '', 'CREATEDBY' => $this->newsession->userdata('SESS_USER_ID'), 'CREATED' => 'GETDATE()', 'UPDATED' => 'GETDATE()');
	}
	$this->db->insert('T_IKLAN_PROSES', $log);
	$case = "IKLANPROSES";
	if ($this->db->affected_rows() > 0) {
	    $i = 0;
	    foreach ($arr_produk['NAMA'] as $a) {
		$produk = array('IKLAN_ID' => $iklan_id, 'IKLAN_ID_PRODUK' => $iklan_id . $i, 'NAMA_PRODUK' => $arr_produk['NAMA'][$i], 'NOMOR_IZIN_EDAR' => '-', 'NAMA_PEMILIK_IZIN_EDAR' => $arr_produk['NAMAPEMILIKIZINEDAR'][$i], 'JENIS_PRODUK' => $arr_produk['JENIS'][$i]);
		$this->db->insert('T_IKLAN_PRODUK', $produk);
		$i++;
	    }
	}
	if ($this->db->affected_rows() > 0) {
	    $iklanNapza = array('IKLAN_ID' => $iklan_id, 'KELOMPOK_IKLAN' => $arr_iklan_napza['KELOMPOK'], 'PENILAIAN' => $arr_penilaian, 'LAMPIRAN' => $lampiran['FILE_IKLAN'], 'JENIS' => $cause);
	    $this->db->insert('T_IKLAN_NAPZA', $iklanNapza);
	    if ($this->db->affected_rows() > 0) {
		$case = 'YESIKLANNAPZA';
	    } else {
		$case = 'NO';
	    }
	} else {
	    $case = 'NO';
	}
	if ($case == 'YESIKLANNAPZA') {
	    $sess_array = array("TANGGAL" => "", "SURAT" => "", "BBPOM" => "");
	    $this->session->unset_userdata($sess_array);
	    $ret = "MSG#YES#Data iklan berhasil disimpan#" . site_url() . '/iklan/iklanController/setListFormIklanLanjutan/1101/2';
	} else if ($case == 'NO') {
	    redirect(base_url());
	    exit();
	}
	return $ret;
    }

    function getPreview($klasfikasi, $jenisPelaporan, $idPengawasan) {
	$sipt = & get_instance();
	$this->load->model("main", "main", true);
	$query = "SELECT TIPN.PENILAIAN, TIPN.KELOMPOK_IKLAN ,TI.STATUS, TIPN.JENIS, TI.SURAT_ID, TI.IKLAN_ID, TI.HASIL, CONVERT(VARCHAR(10), TI.TANGGAL_MULAI, 120) AS TANGGAL_MULAI, CONVERT(VARCHAR(10), TI.TANGGAL_AKHIR, 120) AS TANGGAL_AKHIR FROM T_IKLAN TI LEFT JOIN T_IKLAN_NAPZA TIPN ON TIPN.IKLAN_ID = TI.IKLAN_ID WHERE TIPN.IKLAN_ID = '" . $idPengawasan . "'";
	$data = $sipt->main->get_result($query);
	if ($data) {
	    foreach ($query->result_array() as $row) {
		$arrdata = array('sess' => $row, 'judul' => 'Rokok');
	    }
	    $arrdata['histori_petugas'] = site_url() . '/load/petugas/get_petugas_2/' . $row['SURAT_ID'] . '/T_SURAT_TUGAS_IKLAN';
	}
	return $arrdata;
    }

    function inputPreview($jenis, $iklanId, $status, $klasifikasi, $subid = "", $user = "", $bbpom = "") {
	$sipt = & get_instance();
	$this->load->model("main", "main", true);
	$sipt->load->model('iklan/iklan_act');
	$roleOri = $sipt->iklan_act->getRole();
	$isEditTLPusat = "NO";
	$role = $roleOri;
	$kodeProvinsi = substr($this->newsession->userdata('SESS_PROP_ID'), 0, 2);
	$detailProvinsiDef = $sipt->main->combobox("SELECT PROPINSI_ID, NAMA_PROPINSI FROM M_PROPINSI WHERE LEFT(PROPINSI_ID, 2) = '" . $kodeProvinsi . "' AND RIGHT(PROPINSI_ID, 2) != '00'", "PROPINSI_ID", "NAMA_PROPINSI", TRUE);
	$provinsi = $sipt->main->combobox("SELECT PROPINSI_ID, NAMA_PROPINSI FROM M_PROPINSI WHERE LEFT(PROPINSI_ID, 1) <= '9' AND RIGHT(PROPINSI_ID, 2) = '00'", "PROPINSI_ID", "NAMA_PROPINSI", TRUE);
	$urlId = explode('/', $_SERVER['PATH_INFO']);
	if ($urlId[3] == 'prosesEdit' && ((in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')) && $bbpom == '92') || (!in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')) && $bbpom != '92')))
	    $tglQuery = "TI.TANGGAL_MULAI, 103) AS TANGGAL_MULAI, CONVERT(VARCHAR(10), TI.TANGGAL_AKHIR, 103) AS TANGGAL_AKHIR, CONVERT(VARCHAR(10), TI.TANGGAL, 103) AS TANGGAL";
	else
	    $tglQuery = "TI.TANGGAL_MULAI, 120) AS TANGGAL_MULAI, CONVERT(VARCHAR(10), TI.TANGGAL_AKHIR, 120) AS TANGGAL_AKHIR, CONVERT(VARCHAR(10), TI.TANGGAL, 120) AS TANGGAL";
	$query = "SELECT DISTINCT TSTI.SURAT_ID, TIPN.LAMPIRAN AS FILE_IKLAN, TIPN.KELOMPOK_IKLAN, CONVERT(VARCHAR(MAX), TIPN.PENILAIAN) AS PENILAIAN, TIPN.JENIS, TI.IKLAN_ID, CONVERT(VARCHAR(10), " . $tglQuery . ", TI.JENIS_IKLAN, TI.MEDIA, TI.KOMODITI, CASE(SELECT COUNT(MM2.NAMA_MEDIA) AS MEDIA FROM M_MEDIA MM2 WHERE CONVERT(VARCHAR(100),MM2.ID_MEDIA) = TI.NAMA_MEDIA) WHEN 0 THEN CONVERT(VARCHAR(100), TI.NAMA_MEDIA) ELSE MM.NAMA_MEDIA END AS NAMA_MEDIA, CONVERT(VARCHAR(1000),TI.JUSTIFIKASI_PUSAT) AS JUSTIFIKASI_PUSAT, TI.NAMA_MEDIA AS ID_MEDIA, TI.JUDUL_KEGIATAN, TI.NAMA_LOKASI_IKLAN, TI.ALAMAT_LOKASI_IKLAN, TI.KOTA AS IDKAB, MP.NAMA_PROPINSI AS KOTA, TI.EDISI, TI.JAM_TAYANG, TI.STATUS, TI.HASIL, TI.HASIL_PUSAT, TI.DETAIL_PUSAT, TI.TL_PUSAT FROM T_IKLAN TI LEFT JOIN T_IKLAN_NAPZA TIPN ON TIPN.IKLAN_ID = TI.IKLAN_ID LEFT JOIN T_SURAT_TUGAS_IKLAN TSTI ON TSTI.SURAT_ID = TI.SURAT_ID LEFT JOIN M_MEDIA MM ON CONVERT(VARCHAR(100),MM.ID_MEDIA) = TI.NAMA_MEDIA LEFT JOIN M_PROPINSI MP ON MP.PROPINSI_ID = TI.KOTA WHERE TIPN.IKLAN_ID = '" . $iklanId . "'";
	$data = $sipt->main->get_result($query);
	if ($data) {
	    foreach ($query->result_array() as $row) {
		$arrdata = array('sess' => $row, 'judul' => 'PANGAN');
		$kodeProvinsi = substr($row['IDKAB'], 0, 2);
	    }
	    $arrdata['histori_petugas'] = site_url() . '/load/petugas/get_petugas_2/' . $row['SURAT_ID'] . '/T_SURAT_TUGAS_IKLAN';
	}
	$queryKab = "SELECT PROPINSI_ID FROM M_PROPINSI WHERE PROPINSI_ID = '" . $row['IDKAB'] . "'";
	$queryProv = "SELECT PROPINSI_ID, NAMA_PROPINSI FROM M_PROPINSI WHERE LEFT(PROPINSI_ID, 1) <= '9' AND LEFT(PROPINSI_ID, 2) = '" . $kodeProvinsi . "' AND RIGHT(PROPINSI_ID, 2) = '00'";
	$data = $sipt->main->get_result($queryKab);
	if ($data) {
	    foreach ($queryKab->result_array() as $row) {
		$arrdata['kabupatenVal'] = $row['PROPINSI_ID'];
	    }
	}
	$data = $sipt->main->get_result($queryProv);
	if ($data) {
	    foreach ($queryProv->result_array() as $row) {
		$arrdata['provinsiVal'] = $row['PROPINSI_ID'];
		$arrdata['provinsiVal2'] = $row['NAMA_PROPINSI'];
	    }
	}
	if (($subid == '0101' || $subid == '1101') && $this->newsession->userdata('SESS_BBPOM_ID') != '92' && array_key_exists('2', $this->newsession->userdata('SESS_KODE_ROLE')) && $bbpom != '92' && ($jenis == 'draft' || $jenis == 'edit')) {
	    $query2 = "SELECT TIP.NAMA_PRODUK, TIP.NAMA_PEMILIK_IZIN_EDAR, TIP.JENIS_PRODUK FROM T_IKLAN TI LEFT JOIN T_IKLAN_PRODUK TIP ON TIP.IKLAN_ID = TI.IKLAN_ID WHERE TIP.IKLAN_ID ='" . $arrdata['sess']['IKLAN_ID'] . "'";
	    $data2 = $sipt->main->get_result($query2);
	    if ($data2) {
		foreach ($query2->result_array() as $row) {
		    $str[] = $row;
		}
	    }
	} else if (($subid == '0101' || $subid == '1101') && $this->newsession->userdata('SESS_BBPOM_ID') == '92' && array_key_exists('2', $this->newsession->userdata('SESS_KODE_ROLE')) && $bbpom == '92' && ($jenis == 'draft' || $jenis == 'edit')) {
	    $query2 = "SELECT TIP.NAMA_PRODUK, TIP.NAMA_PEMILIK_IZIN_EDAR, TIP.JENIS_PRODUK FROM T_IKLAN TI LEFT JOIN T_IKLAN_PRODUK TIP ON TIP.IKLAN_ID = TI.IKLAN_ID WHERE TIP.IKLAN_ID ='" . $arrdata['sess']['IKLAN_ID'] . "'";
	    $data2 = $sipt->main->get_result($query2);
	    if ($data2) {
		foreach ($query2->result_array() as $row) {
		    $str[] = $row;
		}
	    }
	} else {
	    $query2 = "SELECT TIP.NAMA_PRODUK, TIP.NAMA_PEMILIK_IZIN_EDAR, (SELECT URAIAN FROM M_TABEL WHERE JENIS = 'BK_NPZ' AND KODE = TIP.JENIS_PRODUK) AS JENIS FROM T_IKLAN TI LEFT JOIN T_IKLAN_PRODUK TIP ON TIP.IKLAN_ID = TI.IKLAN_ID WHERE TIP.IKLAN_ID ='" . $arrdata['sess']['IKLAN_ID'] . "'";
	    $data2 = $sipt->main->get_result($query2);
	    if ($data2) {
		$str = '<table class="tabelajax"><tr class="head"><th>Nama Produk Pangan</th><th>Nama Pemilik Izin Edar</th><th>Bentuk Kemasan Produk Tembakau</th></tr>';
		foreach ($query2->result_array() as $row) {
		    $str .= '<tr><td>' . $row['NAMA_PRODUK'] . '</td><td>' . $row['NAMA_PEMILIK_IZIN_EDAR'] . '</td><td>' . $row['JENIS'] . '</td></tr>';
		}
		$str .= '</table>';
	    }
	}
	if (array_key_exists('2', $this->newsession->userdata('SESS_KODE_ROLE')) && ($subid == '0101' || $subid == '1101') && $jenis != 'preview') {#Operator
	    $isEditTLPusat = "YES";
	}
	if (in_array('2', $this->newsession->userdata('SESS_KODE_ROLE')) && $user == '2') {
	    $arrayClause = array('20301', '20302', '20303', '20311', '20315', '30304', '20312');
	} else if (in_array('3', $this->newsession->userdata('SESS_KODE_ROLE')) && $user == '3') {
	    $arrayClause = array('30301', '30302', '30303', '30304', '30311', '30312', '30313', '30314');
	} else if (in_array('4', $this->newsession->userdata('SESS_KODE_ROLE')) && $user == '4') {
	    $arrayClause = array('40301', '40302', '40303', '40311', '40312', '40313');
	} else if (in_array('5', $this->newsession->userdata('SESS_KODE_ROLE')) && $user == '5') {
	    $arrayClause = array('50301');
	} else if (in_array('6', $this->newsession->userdata('SESS_KODE_ROLE')) && $user == '6') {
	    $arrayClause = array('60311');
	}
	$status2 = $status;
	$arrdata ['sess2'] = $str;
	$arrdata ['status'] = $sipt->main->set_verifikasi($status, $this->newsession->userdata('SESS_JENIS_PELAPORAN'), $this->newsession->userdata('SESS_KODE_ROLE'));
	$arrdata ['disverifikasi'] = $status;
	$arrdata ['objStatus'] = 'TO';
	$jenisKms = array("" => "", "KPP" => "Kotak persegi panjang", "KSL" => "Kotak dengan sisi lebar yang sama", "SLN" => "Silinder", "BLL" => "Bentuk lainnya");
	$arrdata['jenisKmsn'] = $jenisKms;
	$arrayTDK[''] = NULL;
	$arrayTDK['Peringatan 1'] = 'Peringatan 1';
	$arrayTDK['Peringatan 2'] = 'Peringatan 2';
	$arrayTDK['Peringatan Keras'] = 'Peringatan Keras';
	$arrayTDK['Penghentian Sementara Kegiatan'] = 'Penghentian Sementara Kegiatan';
	$arrayTDK['Penghentian Dan Penarikan Iklan'] = 'Penghentian Dan Penarikan Iklan';
	$arrdata ['cb_tindakan'] = $arrayTDK;
	$arrayTDKB = array('' => '', '1' => 'Rekomendasi Ke Dinas Setempat');
	$arrdata ['cb_tindakan_balai'] = $arrayTDKB;
	$arrayTL[''] = NULL;
	$arrayTL['TL'] = 'Tindak Lanjut';
	$arrayTL['STL'] = 'Sudah Tindak Lanjut';
	$arrayTL['TTL'] = 'Tidak Dapat Tindak Lanjut';
	$arrdata ['cb_tl'] = $arrayTL;
	$arrdata ['role'] = $roleOri;
	$arrdata ['kabupaten'] = $detailProvinsiDef;
	$arrdata ['provinsi'] = $provinsi;
	$arrdata ['cancel'] = site_url() . '/iklan/iklanController/setListFormIklanLanjutan/' . $klasifikasi . '/' . $user;
	$arrdata ['klasifikasi'] = $klasifikasi;
	$arrdata ['editTL'] = $isEditTLPusat;
	$arrdata['tujuan'] = $user;
	$arrdata['romawi1_2'] = array("" => "", "02" => "Sesuai", "12" => "Lengkap", "22" => "Tidak Sesuai", "32" => "Tidak Lengkap");
	$arrdata['romawi1_4'] = array("" => "", "04" => "Proporsional", "14" => "Tidak proporsional", "24" => "Tidak Mencantumkan");
	$arrdata['radio_no_2'] = array("" => "", "04" => "Proporsional", "14" => "Tidak proporsional", "21" => "Tidak Memuat");
	if (($subid == '1101' || $subid == '0101') && $jenis != 'preview') {
	    $arrdata ['subJudul'] = '- PANGAN';
	    if ($subid == '0101') {
		$arrdata ['formEdit'] = 'check';
		$arrdata ['labelSimpan'] = 'Proses Perbaikan Data Pengawasan';
		$arrdata ['icon'] = 'check';
		$arrdata ['act'] = site_url() . "/iklan/iklanController/setStatus/1";
	    } else {
		$arrdata ['labelSimpan'] = 'Simpan Data Pengawasan';
		$arrdata ['icon'] = 'save';
	    }
	    $arrdata ['act'] = site_url() . "/iklan/iklanController/updateStatus/" . $klasifikasi . "/1";
	} else if ($subid != '1212' && $subid != '1122' && !empty($urlId[9])) {
	    if ($subid == '1101' && $jenis == 'preview') {
		$arrdata ['labelSimpan'] = 'Proses Perbaikan Data Pengawasan';
	    }
	    $arrdata ['formEdit'] = 'check';
	    $arrdata ['icon'] = 'check';
	    $arrdata ['act'] = site_url() . "/iklan/iklanController/setStatus/1";
	}
	if (!in_array($arrdata ['sess']['STATUS'], $arrayClause)) {
	    if ($status2 != '60310' && ($subid == '1101' || $subid == '0101' || $subid == '0111' || $subid == '1221' || $subid == '1111' || $subid == '1222' || $subid == '0303' || $subid == '0313' || $subid == '0404')) {
		redirect('/iklan/iklanController/setListFormIklanLanjutan/' . $subid . '/' . $user);
		exit();
	    }
	}
	return $arrdata;
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
	$ret = "MSG#YES#Data berhasil disimpan#" . site_url() . '/iklan/iklanController/setListFormIklanLanjutan/1101/013';
	if ($isajax != "ajax") {
	    redirect(base_url());
	    exit();
	}
	return $ret;
    }

    function updateStatus($X, $isajax) {
	if ($isajax != "ajax") {
	    redirect(base_url());
	    exit();
	}
	if ($this->newsession->userdata('LOGGED_IN') == TRUE) {
	    $sipt = & get_instance();
	    $sipt->load->model("main", "main", true);
//   return "MSG#NO#Under maintenance";
	    $ret = "MSG#NO#Data gagal disimpan";
	    $case = "";
	    $cause = "";
	    $iklan_id = $this->input->post('IKLAN_ID');
	    $status = $this->input->post('TO');
	    $arr_iklan = $this->input->post('IKLAN');
	    $arr_iklan_ct = $this->input->post('CETAK');
	    $arr_iklan_rd = $this->input->post('RADIO');
	    $arr_iklan_tv = $this->input->post('TV');
	    $arr_iklan_ti = $this->input->post('TI');
	    $arr_iklan_lr = $this->input->post('LUARRUANG');
	    $arr_iklan_napza = $this->input->post('IKLANNAPZA');
	    $lampiran = $this->input->post('IKLAN_NAPZA');
	    $arr_produk = $this->input->post('PRODUK');
	    $status = $this->input->post('TO');
	    if (trim($arr_iklan_ct[1]) != "") {
		$cause = "CT";
		for ($i = 1; $i <= count($arr_iklan_ct); $i++) {
		    if ($i == 7)
			$arrUraian[$i] = join("^", $arr_iklan_ct[$i]);
		    else
			$arrUraian[$i] = $arr_iklan_ct[$i];
		}
		$arr_penilaian = join("#", $arrUraian);
	    } else if (trim($arr_iklan_rd[7]) != "") {
		$cause = "RD";
		for ($i = 1; $i <= count($arr_iklan_rd); $i++) {
		    if ($i == 1)
			$arrUraian[$i] = join("^", $arr_iklan_rd[$i]);
		    else
			$arrUraian[$i] = $arr_iklan_rd[$i];
		}
		$arr_penilaian = join("#", $arrUraian);
	    } else if (trim($arr_iklan_tv[1]) != "") {
		$cause = "TV";
		for ($i = 1; $i <= count($arr_iklan_tv); $i++) {
		    if ($i == 7 || $i == 10)
			$arrUraian[$i] = join("^", $arr_iklan_tv[$i]);
		    else
			$arrUraian[$i] = $arr_iklan_tv[$i];
		}
		$arr_penilaian = join("#", $arrUraian);
	    } else if (trim($arr_iklan_ti[1]) != "") {
		$cause = "TI";
		for ($i = 1; $i <= count($arr_iklan_ti); $i++) {
		    if ($i == 7)
			$arrUraian[$i] = join("^", $arr_iklan_ti[$i]);
		    else
			$arrUraian[$i] = $arr_iklan_ti[$i];
		}
		$arr_penilaian = join("#", $arrUraian);
	    } else if (trim($arr_iklan_lr[1]) != "") {
		$cause = "LR";
		for ($i = 1; $i <= count($arr_iklan_lr); $i++) {
		    if ($i == 7)
			$arrUraian[$i] = join("^", $arr_iklan_lr[$i]);
		    else
			$arrUraian[$i] = $arr_iklan_lr[$i];
		}
		$arr_penilaian = join("#", $arrUraian);
	    }
	    if ($arr_iklan['DETAIL_PUSAT'][0] != "")
		$dTindakLanjut = join("^", $arr_iklan['DETAIL_PUSAT']);
	    else
		$dTindakLanjut = NULL;
	    if ($arr_iklan['TL_PUSAT'][0] != "")
		$tindakLanjut = join("^", $arr_iklan['TL_PUSAT']);
	    else
		$tindakLanjut = NULL;
	    $arr_update_log = array('UPDATED' => 'GETDATE()');
	    $tindakH = array();
	    $detailH = array();
	    $statusUPD = array();
	    foreach ($iklan_id as $id) {
		$seri = (int) $sipt->main->get_uraian("SELECT MAX(SERI) AS MAXID FROM T_IKLAN_PROSES WHERE IKLAN_ID = '" . $id . "'", "MAXID") + 1;
		if ($status) {
		    $statusUPD = array('STATUS' => $status);
		    $log = array('IKLAN_ID' => $id, 'SERI' => $seri, "STATUS" => $status, 'CATATAN' => $this->input->post('CATATAN'), 'CREATEDBY' => $this->newsession->userdata('SESS_USER_ID'), 'CREATED' => 'GETDATE()', 'UPDATED' => 'GETDATE()');
		    $this->db->insert('T_IKLAN_PROSES', $log);
		}
		if ($arr_iklan['TANGGAL'] != "")
		    $tglTugas = $arr_iklan['TANGGAL'];
		else
		    $tglTugas = NULL;
		foreach ($arr_iklan['MEDIA'] as $a) {
		    $media .= $a;
		}
		if (trim($arr_iklan_lr[1]) != "") {
		    $edisi = $arr_iklan['EDISI'];
		} else {
		    if (trim($arr_iklan['EDISI1'] . $arr_iklan['EDISI2']) != '')
			$edisi = $arr_iklan['EDISI1'] . '^' . $arr_iklan['EDISI2'];
		    else
			$edisi = "-";
		}
		if (($arr_iklan['HASIL_PUSAT'] != $arr_iklan['HASIL']) && $this->input->post('JUSTIFIKASI'))
		    $justifikasi = $this->input->post('JUSTIFIKASI');
//        if (in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) {
//          $yes = $this->input->post('EDIT');
//          if (in_array('2', $this->newsession->userdata('SESS_KODE_ROLE')) && $yes == 'YES') {
//            $arr_iklan = $this->input->post('IKLAN');
//            $tL = join("^", $arr_iklan['TL_PUSAT']);
//            if ($arr_iklan['DETAIL_PUSAT'] != "")
//              $tL2 = join("^", $arr_iklan['DETAIL_PUSAT']);
//            else
//              $tL2 = NULL;
//            $justifikasi = NULL;
//            if ($arr_iklan['HASIL_PUSAT'] != $arr_iklan['HASIL'])
//              $justifikasi = $this->input->post('JUSTIFIKASI');
//            if ($arr_iklan['HASIL_PUSAT'] == "MK")
//              $tindakH = array('HASIL_PUSAT' => $arr_iklan['HASIL_PUSAT'], 'TL_PUSAT' => $tL, 'DETAIL_PUSAT' => NULL, 'JUSTIFIKASI_PUSAT' => $justifikasi);
//            else if ($arr_iklan['HASIL_PUSAT'] == "TMK")
//              $tindakH = array('HASIL_PUSAT' => $arr_iklan['HASIL_PUSAT'], 'TL_PUSAT' => $tL, 'DETAIL_PUSAT' => $tL2, 'JUSTIFIKASI_PUSAT' => $justifikasi);
//          }
//        }
		if ($arr_iklan['TANGGALAWAL']) {
		    $detailH = array_merge($statusUPD, array('TANGGAL_MULAI' => $arr_iklan['TANGGALAWAL'], 'TANGGAL_AKHIR' => $arr_iklan['TANGGALAKHIR'], 'KOMODITI' => $this->input->post('KLASIFIKASIIKLAN'), 'JENIS_IKLAN' => $arr_iklan['JENISIKLAN'], 'MEDIA' => $media, 'NAMA_MEDIA' => $arr_iklan['NAMA'], 'JUDUL_KEGIATAN' => $arr_iklan['JUDUL'], 'TANGGAL' => $tglTugas, 'NAMA_LOKASI_IKLAN' => $arr_iklan['LOKASI'], 'ALAMAT_LOKASI_IKLAN' => $arr_iklan['ALAMAT'], 'KOTA' => $arr_iklan['KOTA'], 'EDISI' => $edisi, 'JAM_TAYANG' => $arr_iklan['TAYANG1'] . ' ' . trim($arr_iklan['TAYANG2']), 'HASIL' => $arr_iklan['HASIL'], 'HASIL_PUSAT' => $arr_iklan['HASIL_PUSAT'], 'TL_PUSAT' => $tindakLanjut, 'DETAIL_PUSAT' => $dTindakLanjut, 'JUSTIFIKASI_PUSAT' => $justifikasi, 'USER_LAST_UPDATE' => $this->newsession->userdata('SESS_USER_ID'), 'LAST_UPDATE' => 'GETDATE()'));
		}
		$iklan = array_merge($statusUPD, $tindakH, $detailH, array('USER_LAST_UPDATE' => $this->newsession->userdata('SESS_USER_ID'), 'LAST_UPDATE' => 'GETDATE()'));
		$this->db->where(array("IKLAN_ID" => $id));
		$this->db->update('T_IKLAN', $iklan);
		if ($this->db->affected_rows() > 0)
		    $case = "YESIKLAN";
		$this->db->where(array("IKLAN_ID" => $id, "STATUS" => $this->input->post('UPDATE')));
		$this->db->update('T_IKLAN_PROSES', $arr_update_log);
		if ($arr_produk) {
		    $this->db->where(array("IKLAN_ID" => $id));
		    $this->db->delete('T_IKLAN_PRODUK');
		    $i = 0;
		    foreach ($arr_produk['NAMA'] as $a) {
			$produk = array('IKLAN_ID' => $id, 'IKLAN_ID_PRODUK' => $id . $i, 'NAMA_PRODUK' => $arr_produk['NAMA'][$i], 'NOMOR_IZIN_EDAR' => '-', 'NAMA_PEMILIK_IZIN_EDAR' => $arr_produk['NAMAPEMILIKIZINEDAR'][$i], 'JENIS_PRODUK' => $arr_produk['JENIS'][$i]);
			$this->db->insert('T_IKLAN_PRODUK', $produk);
			$i++;
		    }
		}
		if ($arr_iklan_napza) {
		    $iklanNapza = array('KELOMPOK_IKLAN' => $arr_iklan_napza['KELOMPOK'], 'PENILAIAN' => $arr_penilaian, 'LAMPIRAN' => $lampiran['FILE_IKLAN'], 'JENIS' => $cause);
		    $this->db->where(array("IKLAN_ID" => $id));
		    $this->db->update('T_IKLAN_NAPZA', $iklanNapza);
		    if ($this->db->affected_rows() > 0) {
			$case = 'YESIKLANNAPZA';
		    } else {
			$case = 'NO';
		    }
		}
	    }
	    if ($case == 'YESIKLANNAPZA' || $case == 'YESIKLAN') {
		if ($status == '20302' || $status == '20312')
		    $ret = "MSG#YES#Data perbaikan iklan berhasil dikirim#" . site_url() . '/iklan/iklanController/setListFormIklanLanjutan/1101/' . $this->input->post("TUJUAN");
		else if ($status == '30304' || $status == '30314' || $status == '30311' || $status == '30301')
		    $ret = "MSG#YES#Data perbaikan iklan berhasil dikirim#" . site_url() . '/iklan/iklanController/setListFormIklanLanjutan/1212/' . $this->input->post("TUJUAN");
		else
		    $ret = "MSG#YES#Data perbaikan iklan berhasil disimpan#" . site_url() . '/iklan/iklanController/setListFormIklanLanjutan/1101/' . $this->input->post("TUJUAN");
	    } else if ($case == 'NO') {
		redirect(base_url());
		exit();
	    }
	    return $ret;
	}
    }

    function RHPK() {
	if ($this->newsession->userdata('LOGGED_IN') == TRUE) {
	    $sipt = & get_instance();
	    $this->load->model("main", "main", true);
	    $this->load->library('newphpexcel');
	    $judul = strtoupper($sipt->main->get_uraian("SELECT dbo.NAMA_JENIS_SARANA('" . $this->input->post('JENIS') . "') AS JUDUL", "JUDUL"));
	    $filter1 = "";
	    $filter2 = "";
	    if (trim($this->input->post('AWAL') != "")) {
		$filter1 .= " AND DATEDIFF(dy, 0, convert(DATETIME, TI.TANGGAL_MULAI, 105)) >= DATEDIFF(dy, 0, convert(DATETIME, '" . $this->input->post('AWAL') . "', 105))";
		$filter2 .= " DATEDIFF(dy, 0, convert(DATETIME, TI.TANGGAL_MULAI, 105)) >= DATEDIFF(dy, 0, convert(DATETIME, '" . $this->input->post('AWAL') . "', 105))";
		$fawal = "DATEDIFF(dy, 0, convert(DATETIME, '" . $this->input->post('AWAL') . "', 105))";
		$awal = $this->input->post('AWAL');
	    } else {
		$filter1 .= " AND TANGGAL_MULAI > GETDATE()";
		$filter2 .= " TI.TANGGAL_MULAI> GETDATE()";
		$fawal = "DATEADD(M, DATEDIFF(M,0,GETDATE()),0)";
		$awal = date('01/m/Y');
	    }
	    if (trim($this->input->post('AKHIR') != "")) {
		$filter1 .= " AND DATEDIFF(dy, 0, convert(DATETIME, TI.TANGGAL_MULAI, 105)) <= DATEDIFF(dy, 0, convert(DATETIME, '" . $this->input->post('AKHIR') . "', 105))";
		$filter2 .= " AND DATEDIFF(dy, 0, convert(DATETIME, TI.TANGGAL_MULAI, 105)) <= DATEDIFF(dy, 0, convert(DATETIME, '" . $this->input->post('AKHIR') . "', 105))";
		$fakhir = "DATEDIFF(dy, 0, convert(DATETIME, '" . $this->input->post('AKHIR') . "', 105))";
		$akhir = $this->input->post('AKHIR');
	    } else {
		$filter1 .= " AND TI.TANGGAL_AKHIR < GETDATE()";
		$filter2 .= " AND TI.TANGGAL_AKHIR < GETDATE()";
		$fakhir = "DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,0,GETDATE())+1,0))";
		$akhir = date('t/m/Y');
	    }
	    if (in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')) || $this->newsession->userdata('SESS_BBPOM_ID') == "00") {
		if (trim($this->input->post('BBPOM_ID')) == "") {
		    $filter2 .= "";
		    $balai = 'Seluruh Balai';
		} else {
		    $filter2 .= " AND TI.BBPOM_ID = '" . $this->input->post('BBPOM_ID') . "'";
		    $balai = $sipt->main->get_uraian("SELECT NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID = '" . $this->input->post('BBPOM_ID') . "'", "NAMA_BBPOM");
		}
	    } else {
		$filter2 .= " AND TI.BBPOM_ID = '" . $this->newsession->userdata('SESS_BBPOM_ID') . "'";
		$balai = $sipt->main->get_uraian("SELECT NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID = '" . $this->newsession->userdata('SESS_BBPOM_ID') . "'", "NAMA_BBPOM");
	    }
	    $query = "SELECT DISTINCT(REPLACE(REPLACE(MB.NAMA_BBPOM,'BALAI BESAR POM DI ', ''),'BALAI POM DI ','')) AS NAMA_BBPOM, SUM(CASE WHEN TI.HASIL = 'Memenuhi Ketentuan' THEN 1 ELSE 0 END) AS 'MK', SUM(CASE WHEN TI.HASIL = 'Tidak Memenuhi Ketentuan' THEN 1 ELSE 0 END) AS 'TMK', TI.KOMODITI AS KOMODITI FROM T_IKLAN TI LEFT JOIN M_BBPOM MB ON TI.BBPOM_ID = MB.BBPOM_ID LEFT JOIN T_IKLAN_OBAT TIO ON TI.IKLAN_ID = TIO.IKLAN_ID WHERE $filter2 GROUP BY MB.BBPOM_ID, MB.NAMA_BBPOM, TI.KOMODITI ORDER BY 1";
	    $this->newphpexcel->set_font('Calibri', 10);
	    $this->newphpexcel->setActiveSheetIndex(0);
	    $this->newphpexcel->set_title('RHPK Pengawasan Iklan');
	    $this->newphpexcel->mergecell(array(array('A1', 'D1'), array('A2', 'D2'), array('A3', 'D3'), array('A4', 'D4'), array('C6', 'D6')), TRUE);
	    $this->newphpexcel->mergecell(array(array('B6', 'B7'), array('A6', 'A7')), FALSE);
	    $this->newphpexcel->width(array(array('A', 12), array('B', 45), array('C', 8), array('D', 8)));
	    $this->newphpexcel->set_bold(array('A1', 'A2', 'A3', 'A4'));
	    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A1', 'REKAPITULASI HASIL PELAKSANAAN KEGIATAN - PENGAWASAN IKLAN')->setCellValue('A2', $judul)->setCellValue('A3', strtoupper($balai))->setCellValue('A4', 'PERIODE : ' . $awal . ' s.d ' . $akhir);
	    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A6', 'Komoditi')->setCellValue('B6', 'BBPOM')->setCellValue('C6', 'Total')->setCellValue('C7', 'MK')->setCellValue('D7', 'TMK');
	    $this->newphpexcel->headings(array('A6', 'B6', 'C6', 'D6'));
	    $this->newphpexcel->set_wrap(array('B6'));
	    $data = $sipt->main->get_result($query);
	    if ($data) {
		$no = 1;
		$rec = 8;
		foreach ($query->result_array() as $row) {
		    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A' . $rec, $row["KOMODITI"])->setCellValue('B' . $rec, $row["NAMA_BBPOM"])->setCellValue('C' . $rec, $row["MK"])->setCellValue('D' . $rec, $row["TMK"]);
		    $this->newphpexcel->set_detilstyle(array('A' . $rec, 'B' . $rec, 'C' . $rec, 'D' . $rec));
		    $rec++;
		    $no++;
		}
	    } else {
		$this->newphpexcel->getActiveSheet()->mergeCells('A8:N8');
		$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A8', 'Data Pengawasan Iklan Tidak Ditemukan');
	    }
//      $qproduk = "SELECT DISTINCT(REPLACE(REPLACE(C.NAMA_BBPOM,'BALAI BESAR POM DI ', ''),'BALAI POM DI ','')) AS NAMA_BBPOM,
//					  (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE JENIS_SARANA_ID = '02PG' AND BBPOM_ID = C.BBPOM_ID $filter1 AND STATUS LIKE '%1_') AS JMLPERIKSA, (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'BAIK' AND JENIS_SARANA_ID = '02PG' AND BBPOM_ID = C.BBPOM_ID $filter1 AND STATUS LIKE '%1_') AS BAIK,
//					  (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'CUKUP' AND JENIS_SARANA_ID = '02PG' AND BBPOM_ID = C.BBPOM_ID $filter1 AND STATUS LIKE '%1_') AS CUKUP,
//					  (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN WHERE HASIL = 'KURANG' AND JENIS_SARANA_ID = '02PG' AND BBPOM_ID = C.BBPOM_ID $filter1 AND STATUS LIKE '%1_') AS KURANG,
//					  SUM(CASE WHEN D.KATEGORI LIKE '%TIE%' THEN 1 ELSE 0 END) AS PRODUKTIE,
//					  SUM(CASE WHEN D.KATEGORI LIKE '%Rusak%' THEN 1 ELSE 0 END) AS PRODUKRUSAK,
//					  SUM(CASE WHEN D.KATEGORI LIKE '%Expire Date%' THEN 1 ELSE 0 END) AS ED,
//					  SUM(CASE WHEN D.KATEGORI LIKE '%TMK%' THEN 1 ELSE 0 END) AS TMKLABEL,
//					  SUM(CASE WHEN D.KATEGORI LIKE '%Bahan%' THEN 1 ELSE 0 END) AS BB
//					  FROM T_PEMERIKSAAN A LEFT JOIN M_BBPOM C ON A.BBPOM_ID = C.BBPOM_ID
//					  LEFT JOIN T_PEMERIKSAAN_PANGAN E ON A.PERIKSA_ID = E.PERIKSA_ID
//					  LEFT JOIN T_PEMERIKSAAN_TEMUAN_PRODUK D ON A.PERIKSA_ID = D.PERIKSA_ID
//					  WHERE A.JENIS_SARANA_ID = '02PG' AND D.KK_ID = '013' $filter2  AND A.STATUS LIKE '%1_'
//					  GROUP BY C.BBPOM_ID, C.NAMA_BBPOM ORDER BY 1";
//      $this->newphpexcel->createSheet();
//      $this->newphpexcel->setActiveSheetIndex(1);
//      $this->newphpexcel->set_title('RHPK Temuan Produk');
//      $this->newphpexcel->mergecell(array(array('A1', 'J1'), array('A2', 'J2'), array('A3', 'J3'), array('A4', 'J4'), array('A6', 'A7'), array('C6', 'F6'), array('G6', 'K6')), TRUE);
//      $this->newphpexcel->mergecell(array(array('B6', 'B7')), FALSE);
//      $this->newphpexcel->width(array(array('A', 4), array('B', 45), array('C', 8), array('D', 5), array('E', 5), array('F', 14), array('G', 14), array('H', 13), array('I', 13), array('J', 13), array('K', 13)));
//      $this->newphpexcel->set_bold(array('A1', 'A2', 'A3', 'A4'));
//      $this->newphpexcel->setActiveSheetIndex(1)->setCellValue('A1', 'REKAPITULASI HASIL PELAKSANAAN KEGIATAN - TEMUAN PRODUK')->setCellValue('A2', $judul)->setCellValue('A3', strtoupper($balai))->setCellValue('A4', 'PERIODE : ' . $awal . ' s.d ' . $akhir);
//      $this->newphpexcel->setActiveSheetIndex(1)->setCellValue('A6', 'No.')->setCellValue('B6', 'BB / BPOM')->setCellValue('C6', 'Jumlah')->setCellValue('F6', 'Rincian Temuan Produk')
//              ->setCellValue('C7', 'Diperiksa')->setCellValue('D7', 'Baik')->setCellValue('E7', 'Cukup')->setCellValue('F7', 'Kurang')->setCellValue('G7', 'TIE')->setCellValue('H7', 'Rusak')->setCellValue('I7', 'Expire Date')->setCellValue('J7', 'TMK Label')->setCellValue('K7', 'Bahan Berbahaya');
//      $this->newphpexcel->headings(array('A6', 'B6', 'C6', 'D6', 'E6', 'F6', 'G6', 'H6', 'I6', 'J6', 'K6', 'B7', 'C7', 'D7', 'E7', 'F7', 'G7', 'H7', 'I7', 'J7', 'K7'));
//      $this->newphpexcel->set_wrap(array('F7', 'G7', 'H7', 'I7', 'J7', 'K7'));
//      $dataproduk = $sipt->main->get_result($qproduk);
//      if ($dataproduk) {
//        $no = 1;
//        $rec = 8;
//        foreach ($qproduk->result_array() as $rowproduk) {
//          $this->newphpexcel->setActiveSheetIndex(1)->setCellValue('A' . $rec, $no)
//                  ->setCellValue('B' . $rec, $rowproduk["NAMA_BBPOM"])
//                  ->setCellValue('C' . $rec, $rowproduk["JMLPERIKSA"])
//                  ->setCellValue('D' . $rec, $rowproduk["BAIK"])
//                  ->setCellValue('E' . $rec, $rowproduk["CUKUP"])
//                  ->setCellValue('F' . $rec, $rowproduk["KURANG"])
//                  ->setCellValue('G' . $rec, $rowproduk["PRODUKTIE"])
//                  ->setCellValue('H' . $rec, $rowproduk["PRODUKRUSAK"])
//                  ->setCellValue('I' . $rec, $rowproduk["ED"])
//                  ->setCellValue('J' . $rec, $rowproduk["TMKLABEL"])
//                  ->setCellValue('K' . $rec, $rowproduk["BB"]);
//          $this->newphpexcel->set_detilstyle(array('A' . $rec, 'B' . $rec, 'C' . $rec, 'D' . $rec, 'E' . $rec, 'F' . $rec, 'G' . $rec, 'H' . $rec, 'I' . $rec, 'J' . $rec, 'K' . $rec));
//          $rec++;
//          $no++;
//        }
//      } else {
//        $this->newphpexcel->getActiveSheet()->mergeCells('A8:K8');
//        $this->newphpexcel->setActiveSheetIndex(1)->setCellValue('A8', 'Data Tidak Ditemukan');
//        $this->newphpexcel->set_detilstyle(array('A8'));
//      }


	    ob_clean();
	    $file = "REKAPITULASI_PENGAWASAN_IKLAN_" . str_replace(" ", "_", str_replace("-", "", $judul)) . "_" . date("YmdHis") . ".xls";
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