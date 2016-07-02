<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
error_reporting(E_ERROR);

class _012M extends Model {

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
	    $arrdata ['cb_tindakan'] = $this->config->item("tl_pusat_iklan_kos");
	    $arrdata ['objStatus'] = 'TO';
	    $arrdata ['role'] = $roleOri;
	    $arrdata ['labelSimpan'] = 'Simpan Data Pengawasan';
	    $arrdata ['icon'] = 'save';
	    $arrdata ['klasifikasi'] = $klasifikasi;
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
	$arr_iklan = $this->input->post('IKLAN');
	$arr_produk = $this->input->post('PRODUK');
	$arr_iklan_KOS = $this->input->post('IKLANKOS');
	$arr_petugas = $this->session->userdata('USER');
	$lampiran = $this->input->post('IKLAN_KOS');
	$suratTugas = $this->session->userdata('SURAT');
	$suratId = (int) $sipt->main->get_uraian("SELECT MAX(SURAT_ID) AS MAXID FROM T_SURAT_TUGAS_IKLAN", "MAXID") + 1;
	$tanggalSurat = $this->session->userdata('TANGGAL');
	if ($this->input->post('UPELANGGARAN'))
	    $arr_uraian_pelanggaran = join("^", $this->input->post('UPELANGGARAN'));
	else
	    $arr_uraian_pelanggaran = NULL;
	if ($arr_iklan['DETAIL_PUSAT'] != "")
	    $dTindakLanjut = join("^", $arr_iklan['DETAIL_PUSAT']);
	else
	    $dTindakLanjut = NULL;
	if ($arr_iklan['TL_PUSAT'] != "")
	    $tindakLanjut = $arr_iklan['TL_PUSAT'];
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
	$iklan_id = (int) $sipt->main->get_uraian("SELECT MAX(IKLAN_ID) AS MAXIKLAN FROM T_IKLAN", "MAXIKLAN") + 1;
	if (count($arr_petugas[0]) > 0) {
	    for ($i = 0; $i < count($arr_petugas[0]); $i++) {
		$surat = array('SURAT_ID' => $suratId, 'NOMOR_SURAT' => $suratTugas, 'TANGGAL' => $tanggalSurat, 'BALAI' => $this->newsession->userdata('SESS_BBPOM_ID'), 'PETUGAS' => $arr_petugas[0][$i], 'CREATED_BY' => $this->newsession->userdata('SESS_USER_ID'), 'CREATED' => 'GETDATE()');
		$this->db->insert('T_SURAT_TUGAS_IKLAN', $surat);
	    }
	}
	foreach ($arr_iklan['MEDIA'] as $a) {
	    $media .= $a;
	}
	if (trim($arr_iklan['EDISI1'] . $arr_iklan['EDISI2']) != '')
	    $edisi = $arr_iklan['EDISI1'] . ' ' . $arr_iklan['EDISI2'] . '^' . $arr_iklan['EDISI3'];
	else
	    $edisi = "-";
	$justifikasi = NULL;
	if (($arr_iklan['HASIL_PUSAT'] != $arr_iklan['HASIL']) && $this->input->post('JUSTIFIKASI'))
	    $justifikasi = $this->input->post('JUSTIFIKASI');
	$iklan = array('SURAT_ID' => $suratId, 'IKLAN_ID' => $iklan_id, 'BBPOM_ID' => $this->newsession->userdata('SESS_BBPOM_ID'), 'TANGGAL_MULAI' => $arr_iklan['TANGGALAWAL'], 'TANGGAL_AKHIR' => $arr_iklan['TANGGALAKHIR'], 'KOMODITI' => $this->input->post('KLASIFIKASIIKLAN'), 'JENIS_IKLAN' => $arr_iklan['JENISIKLAN'], 'MEDIA' => $media, 'NAMA_MEDIA' => $arr_iklan['NAMA'], 'JUDUL_KEGIATAN' => $arr_iklan['JUDUL'], 'TANGGAL' => $tglTugas, 'NAMA_LOKASI_IKLAN' => $arr_iklan['LOKASI'], 'ALAMAT_LOKASI_IKLAN' => $arr_iklan['ALAMAT'], 'KOTA' => $arr_iklan['KOTA'], 'EDISI' => $edisi, 'JAM_TAYANG' => $arr_iklan['TAYANG1'] . ' ' . trim($arr_iklan['TAYANG2']), 'STATUS' => $status, 'HASIL' => $arr_iklan['HASIL'], 'HASIL_PUSAT' => $arr_iklan['HASIL_PUSAT'], 'TL_PUSAT' => $tindakLanjut, 'DETAIL_PUSAT' => $dTindakLanjut, 'JUSTIFIKASI_PUSAT' => $justifikasi, 'USER_LAST_UPDATE' => $this->newsession->userdata('SESS_USER_ID'), 'LAST_UPDATE' => 'GETDATE()', 'CREATE_BY' => $this->newsession->userdata('SESS_USER_ID'));
	if ($this->db->insert('T_IKLAN', $iklan)) {
	    $seri = (int) $sipt->main->get_uraian("SELECT MAX(SERI) AS MAXID FROM T_IKLAN_PROSES WHERE IKLAN_ID = '" . $iklan_id . "'", "MAXID") + 1;
	    $log = array('IKLAN_ID' => $iklan_id, 'SERI' => $seri, 'STATUS' => $status, 'CATATAN' => '', 'CREATEDBY' => $this->newsession->userdata('SESS_USER_ID'), 'CREATED' => 'GETDATE()', 'UPDATED' => 'GETDATE()');
	    if ($this->db->insert('T_IKLAN_PROSES', $log))
		$case = "IKLANPROSES";
	}
	if ($this->db->affected_rows() > 0) {
	    $i = 0;
	    foreach ($arr_produk['NAMA'] as $a) {
		$produk = array('IKLAN_ID' => $iklan_id, 'IKLAN_ID_PRODUK' => $iklan_id . $i, 'NAMA_PRODUK' => $arr_produk['NAMA'][$i], 'MERK_PRODUK' => $arr_produk['MERKDAGANG'][$i], 'BENTUK_SEDIAAN' => $arr_produk['BENTUKSEDIAAN'][$i], 'NAMA_PEMILIK_IZIN_EDAR' => $arr_produk['NAMAPEMILIKIZINEDAR'][$i], 'NOMOR_IZIN_EDAR' => $arr_produk['NOMORIZINEDAR'][$i], 'GOLONGAN_PRODUK' => $arr_produk['GOLONGAN'][$i], 'JENIS_PRODUK' => $arr_produk['JENIS'][$i]);
		$this->db->insert('T_IKLAN_PRODUK', $produk);
		$i++;
		$case = "IKLANPRODUK";
	    }
	}
	if ($this->db->affected_rows() > 0) {
	    $iklanKOS = array('IKLAN_ID' => $iklan_id, 'URAIAN_PELANGGARAN' => $arr_uraian_pelanggaran, 'NARASI' => $arr_iklan_KOS['NARASI'], 'LAMPIRAN' => $lampiran['FILE_IKLAN']);
	    $this->db->insert('T_IKLAN_KOSMETIKA', $iklanKOS);
	    if ($this->db->affected_rows() > 0) {
		$case = 'YESIKLANKOS';
	    } else {
		$case = 'NO';
	    }
	} else {
	    $case = 'NO';
	}
	if ($case == 'YESIKLANKOS') {
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
	$query = "SELECT TIK.URAIAN_PELANGGARAN, TI.STATUS, TI.SURAT_ID, TI.IKLAN_ID, TI.HASIL, TI.HASIL_PUSAT, TI.JUSTIFIKASI_PUSAT, CONVERT(VARCHAR(10), TI.TANGGAL_MULAI, 120) AS TANGGAL_MULAI, CONVERT(VARCHAR(10), TI.TANGGAL_AKHIR, 120) AS TANGGAL_AKHIR FROM T_IKLAN TI RIGHT JOIN T_IKLAN_KOSMETIKA TIK ON TIK.IKLAN_ID = TI.IKLAN_ID WHERE TIK.IKLAN_ID = '" . $idPengawasan . "'";
	$data = $sipt->main->get_result($query);
	if ($data) {
	    foreach ($query->result_array() as $row) {
		$arrdata = array('sess' => $row, 'judul' => 'Kosmetika');
	    }
	    if ($row['STATUS'] == '20302' || $row['STATUS'] == '20312') {
		$arrdata['act'] = site_url() . '/iklan/iklanController/prosesEdit/edit/' . $row['IKLAN_ID'] . '/' . $row['STATUS'] . '/' . $klasfikasi . '/' . $jenisPelaporan;
		$arrdata['tombol'] = 'Lihat Data Perbaikan Pengawasan';
	    } else {
		$arrdata['act'] = site_url() . '/iklan/iklanController/prosesPreview/preview/' . $row['IKLAN_ID'] . '/' . $row['STATUS'] . '/' . $klasfikasi . '/' . $jenisPelaporan;
		$arrdata['tombol'] = 'Lihat Data Pengawasan';
	    }
	    $arrdata['histori_petugas'] = site_url() . '/load/petugas/get_petugas_2/' . $row['SURAT_ID'] . '/T_SURAT_TUGAS_IKLAN';
	}
	return $arrdata;
    }

    function inputPreview($jenis, $iklanId, $status, $klasifikasi, $subid = "", $user = "", $bbpom = "") {
	$sipt = & get_instance();
	$this->load->model("main", "main", true);
	$sipt->load->model('iklan/iklan_act');
	$isEditTLPusat = "NO";
	$kodeProvinsi = substr($this->newsession->userdata('SESS_PROP_ID'), 0, 2);
	$detailProvinsiDef = $sipt->main->combobox("SELECT PROPINSI_ID, NAMA_PROPINSI FROM M_PROPINSI WHERE LEFT(PROPINSI_ID, 2) = '" . $kodeProvinsi . "' AND RIGHT(PROPINSI_ID, 2) != '00'", "PROPINSI_ID", "NAMA_PROPINSI", TRUE);
	$provinsi = $sipt->main->combobox("SELECT PROPINSI_ID, NAMA_PROPINSI FROM M_PROPINSI WHERE LEFT(PROPINSI_ID, 1) <= '9' AND RIGHT(PROPINSI_ID, 2) = '00'", "PROPINSI_ID", "NAMA_PROPINSI", TRUE);
	$urlId = explode('/', $_SERVER['PATH_INFO']);
	if ($urlId[3] == 'prosesEdit' && ((in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')) && in_array($bbpom, $this->config->item('cfg_unit'))) || (!in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')) && !in_array($bbpom, $this->config->item('cfg_unit')))))
	    $tglQuery = "TI.TANGGAL_MULAI, 103) AS TANGGAL_MULAI, CONVERT(VARCHAR(10), TI.TANGGAL_AKHIR, 103) AS TANGGAL_AKHIR, CONVERT(VARCHAR(10), TI.TANGGAL, 103) AS TANGGAL";
	else
	    $tglQuery = "TI.TANGGAL_MULAI, 120) AS TANGGAL_MULAI, CONVERT(VARCHAR(10), TI.TANGGAL_AKHIR, 120) AS TANGGAL_AKHIR, CONVERT(VARCHAR(10), TI.TANGGAL, 120) AS TANGGAL";
	$query = "SELECT DISTINCT TSTI.SURAT_ID, TIK.LAMPIRAN AS FILE_IKLAN, TIK.NARASI, CONVERT(VARCHAR(1000),TIK.URAIAN_PELANGGARAN) AS URAIAN_PELANGGARAN, CONVERT(VARCHAR(1000),TIK.URAIAN_PELANGGARAN_PUSAT) AS URAIAN_PELANGGARAN_PUSAT, TI.IKLAN_ID, CONVERT(VARCHAR(10), " . $tglQuery . ", TI.JENIS_IKLAN, TI.MEDIA, TI.KOMODITI, CASE(SELECT COUNT(MM2.NAMA_MEDIA) AS MEDIA FROM M_MEDIA MM2 WHERE CONVERT(VARCHAR(100),MM2.ID_MEDIA) = TI.NAMA_MEDIA) WHEN 0 THEN CONVERT(VARCHAR(100), TI.NAMA_MEDIA) ELSE MM.NAMA_MEDIA END AS NAMA_MEDIA, CONVERT(VARCHAR(1000),TI.JUSTIFIKASI_PUSAT) AS JUSTIFIKASI_PUSAT, TI.NAMA_MEDIA AS ID_MEDIA, TI.JUDUL_KEGIATAN, TI.NAMA_LOKASI_IKLAN, TI.ALAMAT_LOKASI_IKLAN, TI.KOTA AS IDKAB, MP.NAMA_PROPINSI AS KOTA, TI.EDISI, TI.JAM_TAYANG, TI.STATUS, TI.HASIL, TI.HASIL_PUSAT, TI.DETAIL_PUSAT, TI.TL_PUSAT FROM T_IKLAN TI RIGHT JOIN T_IKLAN_KOSMETIKA TIK ON TIK.IKLAN_ID = TI.IKLAN_ID RIGHT JOIN T_SURAT_TUGAS_IKLAN TSTI ON TSTI.SURAT_ID = TI.SURAT_ID LEFT JOIN M_MEDIA MM ON CONVERT(VARCHAR(100),MM.ID_MEDIA) = TI.NAMA_MEDIA LEFT JOIN M_PROPINSI MP ON MP.PROPINSI_ID = TI.KOTA WHERE TIK.IKLAN_ID = '" . $iklanId . "'";
	$data = $sipt->main->get_result($query);
	if ($data) {
	    foreach ($query->result_array() as $row) {
		$arrdata = array('sess' => $row, 'judul' => 'KOSMETIKA');
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
	if (($subid == '0101' || $subid == '1101') && !in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')) && array_key_exists('2', $this->newsession->userdata('SESS_KODE_ROLE')) && !in_array($bbpom, $this->config->item('cfg_unit')) && ($jenis == 'draft' || $jenis == 'edit')) {
	    $query2 = "SELECT TIP.NAMA_PRODUK, TIP.MERK_PRODUK, TIP.BENTUK_SEDIAAN, TIP.NAMA_PEMILIK_IZIN_EDAR, TIP.NOMOR_IZIN_EDAR, TIP.GOLONGAN_PRODUK, TIP.JENIS_PRODUK FROM T_IKLAN TI RIGHT JOIN T_IKLAN_PRODUK TIP ON TIP.IKLAN_ID = TI.IKLAN_ID WHERE TIP.IKLAN_ID ='" . $arrdata['sess']['IKLAN_ID'] . "'";
	    $data2 = $sipt->main->get_result($query2);
	    if ($data2) {
		foreach ($query2->result_array() as $row) {
		    $str[] = $row;
		}
	    }
	} else if (($subid == '0101' || $subid == '1101') && in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')) && array_key_exists('2', $this->newsession->userdata('SESS_KODE_ROLE')) && in_array($bbpom, $this->config->item('cfg_unit')) && ($jenis == 'draft' || $jenis == 'edit')) {
	    $query2 = "SELECT TIP.NAMA_PRODUK, TIP.MERK_PRODUK, TIP.BENTUK_SEDIAAN, TIP.NAMA_PEMILIK_IZIN_EDAR, TIP.NOMOR_IZIN_EDAR, TIP.GOLONGAN_PRODUK, TIP.JENIS_PRODUK FROM T_IKLAN TI RIGHT JOIN T_IKLAN_PRODUK TIP ON TIP.IKLAN_ID = TI.IKLAN_ID WHERE TIP.IKLAN_ID ='" . $arrdata['sess']['IKLAN_ID'] . "'";
	    $data2 = $sipt->main->get_result($query2);
	    if ($data2) {
		foreach ($query2->result_array() as $row) {
		    $str[] = $row;
		}
	    }
	} else {
	    $query2 = "SELECT TIP.NAMA_PRODUK, TIP.MERK_PRODUK, TIP.BENTUK_SEDIAAN, TIP.NAMA_PEMILIK_IZIN_EDAR, TIP.NOMOR_IZIN_EDAR, TIP.JENIS_PRODUK FROM T_IKLAN TI RIGHT JOIN T_IKLAN_PRODUK TIP ON TIP.IKLAN_ID = TI.IKLAN_ID WHERE TIP.IKLAN_ID ='" . $arrdata['sess']['IKLAN_ID'] . "'";
	    $data2 = $sipt->main->get_result($query2);
	    if ($data2) {
		$str = '<table class="tabelajax"><tr class="head"><th>Nama Produk Kosmetika</th><th>Merk Produk</th><th>Nomor Izin Edar</th><th>Nama Pemilik Izin Edar</th><th>Kategori Produk</th></tr>';
		foreach ($query2->result_array() as $row) {
		    $str .= '<tr><td>' . $row['NAMA_PRODUK'] . '</td><td>' . $row['MERK_PRODUK'] . '</td><td>' . $row['NOMOR_IZIN_EDAR'] . '</td><td>' . $row['NAMA_PEMILIK_IZIN_EDAR'] . '</td><td>' . $row['JENIS_PRODUK'] . '</td></tr>';
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
	$arrdata ['sess2'] = $str;
	$arrdata ['status'] = $sipt->main->set_verifikasi($status, $this->newsession->userdata('SESS_JENIS_PELAPORAN'), $this->newsession->userdata('SESS_KODE_ROLE'));
	$arrdata ['disverifikasi'] = $status;
	$arrdata ['objStatus'] = 'TO';
	$arrdata ['cb_tindakan'] = $this->config->item("tl_pusat_iklan_kos");
	$arrdata ['kabupaten'] = $detailProvinsiDef;
	$arrdata ['provinsi'] = $provinsi;
	$arrdata ['cancel'] = site_url() . '/iklan/iklanController/setListFormIklanLanjutan/' . $klasifikasi . '/' . $user;
	$arrdata ['klasifikasi'] = $klasifikasi;
	$arrdata ['editTL'] = $isEditTLPusat;
	$arrdata['tujuan'] = $user;
	if (($subid == '1101' || $subid == '0101') && $jenis != 'preview') {
	    $arrdata ['subJudul'] = '- KOSMETIKA EDIT';
	    if ($subid == '0101') {
		$arrdata ['formEdit'] = 'check';
		$arrdata ['labelSimpan'] = 'Proses Perbaikan Data Pengawasan';
		$arrdata ['icon'] = 'check';
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
	    if ($status != '60310' && ($subid == '1101' || $subid == '0101' || $subid == '0111' || $subid == '1221' || $subid == '1111' || $subid == '1222' || $subid == '0303' || $subid == '0313' || $subid == '0404')) {
		redirect('/iklan/iklanController/setListFormIklanLanjutan/' . $subid . '/' . $user);
		exit();
	    }
	}
	return $arrdata;
    }

    function updateStatus($X, $isajax) {
	if ($isajax != "ajax") {
	    redirect(base_url());
	    exit();
	}
	if ($this->newsession->userdata('LOGGED_IN') == TRUE) {
	    $sipt = & get_instance();
	    $sipt->load->model("main", "main", true);
	    $ret = "MSG#NO#Data Gagal Dikirim";
	    $tL = $this->input->post('PEMERIKSAAN_DISTRIBUSI_PUSAT');
	    $iklan_id = $this->input->post('IKLAN_ID');
	    $case = '';
	    $status = $this->input->post('TO');
	    $arr_iklan = $this->input->post('IKLAN');
	    $arr_produk = $this->input->post('PRODUK');
	    $arr_iklan_KOS = $this->input->post('IKLANKOS');
	    if (count(array_unique($this->input->post('UPELANGGARAN'))) > 1)
		$arr_uraian_pelanggaran = join('^', $this->input->post('UPELANGGARAN'));
	    else
		$arr_uraian_pelanggaran = NULL;
	    $lampiran = $this->input->post('IKLAN_KOS');
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
		if (in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) {
		    $yes = $this->input->post('EDIT');
		    if (in_array('2', $this->newsession->userdata('SESS_KODE_ROLE')) && $yes == 'YES') {
			$arr_iklan = $this->input->post('IKLAN');
			if ($arr_iklan['TL_PUSAT'] != "")
			    $tL = $arr_iklan['TL_PUSAT'];
			else
			    $tL = NULL;
			$justifikasi = NULL;
			if (($arr_iklan['HASIL_PUSAT'] != $arr_iklan['HASIL']) && $this->input->post('JUSTIFIKASI'))
			    $justifikasi = $this->input->post('JUSTIFIKASI');
			$tindakH = array('HASIL_PUSAT' => $arr_iklan['HASIL_PUSAT'], 'TL_PUSAT' => $tL, 'JUSTIFIKASI_PUSAT' => $justifikasi);
			$uraianPusat = $this->input->post('UPELANGGARANPUSAT');
		    }
		}
		if ($arr_iklan['TANGGALAWAL']) {
		    if (trim($arr_iklan['EDISI1'] . $arr_iklan['EDISI2']) != '')
			$edisi = $arr_iklan['EDISI1'] . ' ' . $arr_iklan['EDISI2'] . '^' . $arr_iklan['EDISI3'];
		    else
			$edisi = "-";
		    $detailH = array('HASIL' => $arr_iklan['HASIL'], 'TANGGAL_MULAI' => $arr_iklan['TANGGALAWAL'], 'TANGGAL_AKHIR' => $arr_iklan['TANGGALAKHIR'], 'KOMODITI' => $this->input->post('KLASIFIKASIIKLAN'), 'JENIS_IKLAN' => $arr_iklan['JENISIKLAN'], 'MEDIA' => $media, 'NAMA_MEDIA' => $arr_iklan['NAMA'], 'JUDUL_KEGIATAN' => $arr_iklan['JUDUL'], 'TANGGAL' => $tglTugas, 'NAMA_LOKASI_IKLAN' => $arr_iklan['LOKASI'], 'ALAMAT_LOKASI_IKLAN' => $arr_iklan['ALAMAT'], 'KOTA' => $arr_iklan['KOTA'], 'EDISI' => $edisi, 'JAM_TAYANG' => $arr_iklan['TAYANG1'] . ' ' . trim($arr_iklan['TAYANG2']));
		}
		$iklan = array_merge($statusUPD, $tindakH, $detailH, array('USER_LAST_UPDATE' => $this->newsession->userdata('SESS_USER_ID'), 'LAST_UPDATE' => 'GETDATE()'));
		$this->db->where(array("IKLAN_ID" => $id));
		$this->db->update('T_IKLAN', $iklan);
		if ($this->db->affected_rows() > 0)
		    $case = "YESIKLAN";
		$this->db->where(array("IKLAN_ID" => $id, "STATUS" => $this->input->post('UPDATE')));
		$this->db->update('T_IKLAN_PROSES', $arr_update_log);
		if (in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) {
		    $updateUraian = array('URAIAN_PELANGGARAN_PUSAT' => join("^", $uraianPusat));
		    $this->db->where(array("IKLAN_ID" => $id));
		    $this->db->update('T_IKLAN_KOSMETIKA', $updateUraian);
		    if ($this->db->affected_rows() > 0)
			$case = "YESIKLANPUSAT";
		}
		if ($arr_produk) {
		    $this->db->where(array("IKLAN_ID" => $id));
		    $this->db->delete('T_IKLAN_PRODUK');
		    $i = 0;
		    foreach ($arr_produk['NAMA'] as $a) {
			$produk = array('IKLAN_ID' => $id, 'IKLAN_ID_PRODUK' => $id . $i, 'NAMA_PRODUK' => $arr_produk['NAMA'][$i], 'MERK_PRODUK' => $arr_produk['MERKDAGANG'][$i], 'BENTUK_SEDIAAN' => $arr_produk['BENTUKSEDIAAN'][$i], 'NAMA_PEMILIK_IZIN_EDAR' => $arr_produk['NAMAPEMILIKIZINEDAR'][$i], 'NOMOR_IZIN_EDAR' => $arr_produk['NOMORIZINEDAR'][$i], 'GOLONGAN_PRODUK' => $arr_produk['GOLONGAN'][$i], 'JENIS_PRODUK' => $arr_produk['JENIS'][$i]);
			$this->db->insert('T_IKLAN_PRODUK', $produk);
			$i++;
			$case = "YESIKLANPRODUK";
		    }
		}
		if ($arr_iklan_KOS) {
		    $iklanKOS = array('URAIAN_PELANGGARAN' => $arr_uraian_pelanggaran, 'NARASI' => $arr_iklan_KOS['NARASI'], 'LAMPIRAN' => $lampiran['FILE_IKLAN']);
		    $this->db->where(array("IKLAN_ID" => $id));
		    $this->db->update('T_IKLAN_KOSMETIKA', $iklanKOS);
		    if ($this->db->affected_rows() > 0) {
			$case = 'YESIKLANKOS';
		    }
		}
	    }
	    if ($case == 'YESIKLANKOS' || $case == 'YESIKLAN' || $case == 'YESIKLANPRODUK' || $case == 'YESIKLANPUSAT') {
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
	    $judul = "KOSMETIKA";
	    $filter2 = "";
	    if (trim($this->input->post('AWAL') != "")) {
		$filter2 .= " DATEDIFF(dy, 0, convert(DATETIME, TI.TANGGAL_MULAI, 105)) >= DATEDIFF(dy, 0, convert(DATETIME, '" . $this->input->post('AWAL') . "', 105))";
		$awal = $this->input->post('AWAL');
	    } else {
		$filter2 .= " TI.TANGGAL_MULAI > GETDATE()";
		$awal = date('01/m/Y');
	    }
	    if (trim($this->input->post('AKHIR') != "")) {
		$filter2 .= " AND DATEDIFF(dy, 0, convert(DATETIME, TI.TANGGAL_MULAI, 105)) <= DATEDIFF(dy, 0, convert(DATETIME, '" . $this->input->post('AKHIR') . "', 105))";
		$akhir = $this->input->post('AKHIR');
	    } else {
		$filter2 .= " AND TI.TANGGAL_AKHIR < GETDATE()";
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
	    $query = "SELECT DISTINCT (REPLACE(REPLACE(MB.NAMA_BBPOM,'BALAI BESAR POM DI ', ''),'BALAI POM DI ','')) AS NAMA_BBPOM, SUM(CASE WHEN (TI.HASIL_PUSAT = 'MK') AND (TI.BBPOM_ID IN  (" . "'" . join("','", $this->newsession->userdata("SESS_BBPOM_ID")) . "'" . ") OR TI.STATUS = 60310) THEN 1 ELSE 0 END) AS 'MK_P', SUM(CASE WHEN (TI.HASIL_PUSAT = 'TMK') AND (TI.BBPOM_ID IN  (" . "'" . join("','", $this->newsession->userdata("SESS_BBPOM_ID")) . "'" . ")  OR TI.STATUS = 60310) THEN 1 ELSE 0 END) AS 'TMK_P', SUM(CASE WHEN (TI.HASIL = 'MK') AND (TI.BBPOM_ID NOT IN  (" . "'" . join("','", $this->newsession->userdata("SESS_BBPOM_ID")) . "'" . ")  AND TI.STATUS <> 60310) THEN 1 ELSE 0 END) AS 'MK_B', SUM(CASE WHEN (TI.HASIL = 'TMK') AND (TI.BBPOM_ID NOT IN  (" . "'" . join("','", $this->newsession->userdata("SESS_BBPOM_ID")) . "'" . ")  AND TI.STATUS <> 60310) THEN 1 ELSE 0 END) AS 'TMK_B', TI.KOMODITI AS KOMODITI, COUNT(TI.HASIL) AS JUMLAH_PERIKSA, SUM(CASE WHEN TI.TL_PUSAT = '0' THEN 1 ELSE 0 END) AS 'PERINGATAN1', SUM(CASE WHEN TI.TL_PUSAT = '1' THEN 1 ELSE 0 END) AS 'PERINGATAN2', SUM(CASE WHEN TI.TL_PUSAT = '2' THEN 1 ELSE 0 END) AS 'PERINGATANKERAS', SUM(CASE WHEN TI.TL_PUSAT = '3' THEN 1 ELSE 0 END) AS 'PENGHENTIANPRODUKSI', SUM(CASE WHEN TI.TL_PUSAT = '4' THEN 1 ELSE 0 END) AS 'PENGHENTIANIMPORTASI', SUM(CASE WHEN TI.TL_PUSAT = '5' THEN 1 ELSE 0 END) AS 'PEMBATALAN', SUM(CASE WHEN TI.TL_PUSAT = '6' THEN 1 ELSE 0 END) AS 'PENUTUPAN' FROM T_IKLAN TI LEFT JOIN T_IKLAN_PK_SM TIPS ON TI.IKLAN_ID = TIPS.IKLAN_ID LEFT JOIN M_BBPOM MB ON TI.BBPOM_ID = MB.BBPOM_ID WHERE $filter2 AND TI.KOMODITI = '012' GROUP BY  MB.BBPOM_ID, MB.NAMA_BBPOM, TI.KOMODITI ORDER BY 1";
	    $this->newphpexcel->set_font('Calibri', 10);
	    $this->newphpexcel->setActiveSheetIndex(0);
	    $this->newphpexcel->set_title('RHPK Pengawasan Iklan');
	    $this->newphpexcel->mergecell(array(array('A1', 'F1'), array('A2', 'F2'), array('A3', 'F3'), array('A4', 'F4'), array('C6', 'E6'), array('F6', 'L6')), TRUE);
	    $this->newphpexcel->mergecell(array(array('B6', 'B7'), array('A6', 'A7')), FALSE);
	    $this->newphpexcel->width(array(array('A', 4), array('B', 30), array('C', 11), array('D', 11), array('E', 11), array('F', 15), array('G', 15), array('H', 25), array('I', 25), array('J', 25), array('K', 25), array('L', 45)));
	    $this->newphpexcel->set_bold(array('A1', 'A2', 'A3', 'A4'));
	    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A1', 'REKAPITULASI HASIL PELAKSANAAN KEGIATAN - PENGAWASAN IKLAN')->setCellValue('A2', $judul)->setCellValue('A3', strtoupper($balai))->setCellValue('A4', 'PERIODE : ' . $awal . ' s.d ' . $akhir);
	    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A6', 'No.')->setCellValue('B6', 'BBPOM')->setCellValue('C6', 'Total')->setCellValue('F6', 'Tindak Lanjut Pusat')->setCellValue('C7', 'Diperiksa')->setCellValue('D7', 'MK')->setCellValue('E7', 'TMK')->setCellValue('F7', 'Peringatan 1')->setCellValue('G7', 'Peringatan 2')->setCellValue('H7', 'Peringatan Keras')->setCellValue('I7', 'Penghentian Sementara Kegiatan Produksi')->setCellValue('J7', 'Penghentian Sementara Kegiatan Importasi')->setCellValue('K7', 'Pembatalan Izin Edar')->setCellValue('L7', 'Penutupan Sementara Akses Online Pengajuan Permohonan Notifikasi ');
	    $this->newphpexcel->headings(array('A6', 'B6', 'C6', 'D6', 'E6', 'F6', 'G6', 'H6', 'I6', 'J6', 'K6', 'L6'));
	    $this->newphpexcel->headings(array('A7', 'B7', 'C7', 'D7', 'E7', 'F7', 'G7', 'H7', 'I7', 'J7', 'K7', 'L7'));
	    $this->newphpexcel->set_wrap(array('B6', 'G7', 'H7', 'I7', 'J7', 'K7', 'L7'));
	    $data = $sipt->main->get_result($query);
	    if ($data) {
		$no = 1;
		$rec = 8;
		foreach ($query->result_array() as $row) {
		    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A' . $rec, $no)->setCellValue('B' . $rec, $row["NAMA_BBPOM"])->setCellValue('C' . $rec, $row['JUMLAH_PERIKSA'])->setCellValue('D' . $rec, $row["MK_P"] + $row["MK_B"])->setCellValue('E' . $rec, $row["TMK_P"] + $row["TMK_B"])->setCellValue('F' . $rec, $row["PERINGATAN1"])->setCellValue('G' . $rec, $row["PERINGATAN2"])->setCellValue('H' . $rec, $row["PERINGATANKERAS"])->setCellValue('I' . $rec, $row["PENGHENTIANPRODUKSI"])->setCellValue('J' . $rec, $row["PENGHENTIANIMPORTASI"])->setCellValue('K' . $rec, $row["PEMBATALAN"])->setCellValue('L' . $rec, $row["PENUTUPAN"]);
		    $this->newphpexcel->set_detilstyle(array('A' . $rec, 'B' . $rec, 'C' . $rec, 'D' . $rec, 'E' . $rec, 'F' . $rec, 'G' . $rec, 'H' . $rec, 'I' . $rec, 'J' . $rec, 'K' . $rec, 'L' . $rec));
		    $this->newphpexcel->set_wrap(array('G' . $rec));
		    $rec++;
		    $no++;
		}
	    } else {
		$this->newphpexcel->getActiveSheet()->mergeCells('A8:L8');
		$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A8', 'Data Pengawasan Iklan Tidak Ditemukan');
	    }
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

    function report() {
	if ($this->newsession->userdata('LOGGED_IN') == TRUE) {
	    $sipt = & get_instance();
	    $this->load->model("main", "main", true);
	    $this->load->library('newphpexcel');
	    $judul = "KOSMETIKA";
	    $filterHasil = "";
	    $filter2 = "";
	    if (trim($this->input->post('AWAL') != "")) {
		$filter2 .= " DATEDIFF(dy, 0, convert(DATETIME, TI.TANGGAL_MULAI, 105)) >= DATEDIFF(dy, 0, convert(DATETIME, '" . $this->input->post('AWAL') . "', 105))";
		$awal = $this->input->post('AWAL');
	    } else {
		$filter2 .= " TI.TANGGAL_MULAI> GETDATE()";
		$awal = date('01/m/Y');
	    }
	    if (trim($this->input->post('AKHIR') != "")) {
		$filter2 .= " AND DATEDIFF(dy, 0, convert(DATETIME, TI.TANGGAL_MULAI, 105)) <= DATEDIFF(dy, 0, convert(DATETIME, '" . $this->input->post('AKHIR') . "', 105))";
		$akhir = $this->input->post('AKHIR');
	    } else {
		$filter2 .= " AND TI.TANGGAL_AKHIR < GETDATE()";
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
	    if ($this->input->post('HASIL') != "")
		$filterHasil = " AND dbo.GET_DATA_FROM_IKLAN(TI.IKLAN_ID) = '" . $this->input->post('HASIL') . "'";
	    $query = "SELECT DISTINCT TI.IKLAN_ID, (REPLACE(REPLACE(MB.NAMA_BBPOM,'BALAI BESAR POM DI ', ''),'BALAI POM DI ','')) AS NAMA_BBPOM, dbo.GET_KOMODITI(TI.KOMODITI) AS KOMODITI, TI.JENIS_IKLAN, CASE(SELECT COUNT(MM2.NAMA_MEDIA) AS MEDIA FROM M_MEDIA MM2 WHERE CONVERT(VARCHAR(100),MM2.ID_MEDIA) = TI.NAMA_MEDIA) WHEN 0 THEN (CASE CONVERT(VARCHAR(100), TI.NAMA_MEDIA) WHEN '0' THEN '-' ELSE CONVERT(VARCHAR(100), TI.NAMA_MEDIA) END) ELSE MM.NAMA_MEDIA END AS NAMA_MEDIA, TI.MEDIA, TI.ALAMAT_LOKASI_IKLAN, CONVERT(VARCHAR(10), TI.TANGGAL_MULAI, 120) AS TANGGAL_MULAI, CONVERT(VARCHAR(10), TI.TANGGAL_AKHIR, 120) AS TANGGAL_AKHIR, CONVERT(VARCHAR(1000),TI.JUSTIFIKASI_PUSAT) AS JUSTIFIKASI_PUSAT, dbo.GET_PRODUK_PENGAWASAN(TI.IKLAN_ID, 'IKLAN', 'PRODUK') AS NAMA_PRODUK, dbo.GET_PRODUK_PENGAWASAN(TI.IKLAN_ID, 'IKLAN', 'NIE') AS NAMA_PEMILIK_NIE, dbo.GET_PRODUK_PENGAWASAN(TI.IKLAN_ID, 'IKLAN', 'NOMOR') AS NIE, CONVERT(VARCHAR(1000),TIK.URAIAN_PELANGGARAN) AS URAIAN_PELANGGARAN, CONVERT(VARCHAR(1000),TIK.URAIAN_PELANGGARAN_PUSAT) AS URAIAN_PELANGGARAN_PUSAT, TIK.NARASI, TI.HASIL, TI.HASIL_PUSAT, TI.DETAIL_PUSAT, TI.TL_PUSAT FROM T_IKLAN TI LEFT JOIN M_BBPOM MB ON TI.BBPOM_ID = MB.BBPOM_ID LEFT JOIN T_IKLAN_KOSMETIKA TIK ON TI.IKLAN_ID = TIK.IKLAN_ID LEFT JOIN M_MEDIA MM ON CONVERT(VARCHAR(MAX),MM.ID_MEDIA) = TI.NAMA_MEDIA  WHERE $filter2 $filterHasil AND TI.KOMODITI = '012' GROUP BY MB.BBPOM_ID, MB.NAMA_BBPOM, TI.KOMODITI, TI.JENIS_IKLAN, MM.NAMA_MEDIA, TI.NAMA_MEDIA, TI.ALAMAT_LOKASI_IKLAN, TI.TANGGAL_MULAI, TI.TANGGAL_AKHIR, TI.IKLAN_ID, CONVERT(VARCHAR(1000),TIK.URAIAN_PELANGGARAN), CONVERT(VARCHAR(1000),TIK.URAIAN_PELANGGARAN_PUSAT), TIK.NARASI, TI.MEDIA, TI.HASIL, TI.HASIL_PUSAT, TI.DETAIL_PUSAT, TI.TL_PUSAT, CONVERT(VARCHAR(1000),TI.JUSTIFIKASI_PUSAT) ORDER BY 1";
	    $this->newphpexcel->set_font('Calibri', 10);
	    $this->newphpexcel->setActiveSheetIndex(0);
	    $this->newphpexcel->set_title('LAPORAN IKLAN KOSMETIKA');
	    $this->newphpexcel->mergecell(array(array('A1', 'D1'), array('A2', 'D2'), array('A3', 'D3'), array('A4', 'D4'), array('J6', 'K6'), array('N6', 'O6')), TRUE);
	    $this->newphpexcel->mergecell(array(array('A6', 'A7'), array('B6', 'B7'), array('C6', 'C7'), array('D6', 'D7'), array('E6', 'E7'), array('F6', 'F7'), array('G6', 'G7'), array('H6', 'H7'), array('I6', 'I7'), array('L6', 'L7'), array('M6', 'M7'), array('P6', 'P7')), FALSE);
	    $this->newphpexcel->width(array(array('A', 4), array('B', 35), array('C', 20), array('D', 25), array('E', 25), array('F', 20), array('G', 25), array('H', 30), array('I', 60), array('J', 10), array('K', 10), array('L', 50), array('M', 20), array('N', 50), array('O', 50), array('P', 32)));
	    $this->newphpexcel->set_bold(array('A1', 'A2', 'A3', 'A4'));
	    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A1', 'LAPORAN HASIL PENGAWASAN IKLAN')->setCellValue('A2', $judul)->setCellValue('A3', strtoupper($balai))->setCellValue('A4', 'PERIODE : ' . $awal . ' s.d ' . $akhir);
	    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A6', 'No')->setCellValue('B6', 'Nama Produk')->setCellValue('C6', 'NIE')->setCellValue('D6', 'Produsen / Distributor')->setCellValue('E6', 'Jenis Media')->setCellValue('F6', 'Media Iklan')->setCellValue('G6', 'Nama Media')->setCellValue('H6', 'Tanggal Periksa')->setCellValue('I6', 'Klaim Iklan')->setCellValue('J6', 'Kesimpulan')->setCellValue('L6', 'Justifikasi')->setCellValue('M6', 'Tindak Lanjut Pusat')->setCellValue('N6', 'Uraian Pelanggaran')->setCellValue('P6', 'Unit / Balai')->setCellValue('J7', 'Balai')->setCellValue('K7', 'Pusat')->setCellValue('N7', 'Balai')->setCellValue('O7', 'Pusat');
	    $this->newphpexcel->headings(array('A6', 'B6', 'C6', 'D6', 'E6', 'F6', 'G6', 'H6', 'I6', 'J6', 'K6', 'L6', 'M6', 'N6', 'O6', 'P6'));
	    $this->newphpexcel->headings(array('A7', 'B7', 'C7', 'D7', 'E7', 'F7', 'G7', 'H7', 'I7', 'J7', 'K7', 'L7', 'M7', 'N7', 'O7', 'P7'));
	    $this->newphpexcel->set_wrap(array('B6', 'I7', 'J7', 'K7', 'L7', 'M7', 'N7', 'O7', 'P7'));
	    $data = $sipt->main->get_result($query);
	    if ($data) {
		$no = 1;
		$rec = 8;
		$uraianArr = $this->config->item('uraian_iklan_kos');
		$TLPusatArr = $this->config->item('tl_pusat_iklan_kos');
		foreach ($query->result_array() as $row) {
		    $uraianPelanggaran = explode('^', $row['URAIAN_PELANGGARAN']);
		    $uraianPelanggaranPusat = explode('^', $row['URAIAN_PELANGGARAN_PUSAT']);
		    $i = 0;
		    $i2 = 0;
		    $uraiannya = " - ";
		    $uraiannyaPusat = " - ";
		    foreach ($uraianPelanggaran as $value) {
			if (trim($value) != "") {
			    $uraianTxt = $uraianArr[$i];
			    $uraianVal = $value;
			    $uraiannya = $uraianTxt . " : " . $uraianVal;
			}
			$i++;
		    }
		    foreach ($uraianPelanggaranPusat as $value) {
			if (trim($value) != "") {
			    $uraianTxtPusat = $uraianArr[$i2];
			    $uraianValPusat = $value;
			    $uraiannyaPusat = $uraianTxtPusat . " : " . $uraianValPusat;
			}
			$i2++;
		    }
		    $justifikasi = preg_replace('/(?:<|&lt;)\/?([a-zA-Z]+) *[^<\/]*?(?:>|&gt;)/', '', $row['JUSTIFIKASI_PUSAT']) . "\n";
		    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A' . $rec, $no)->setCellValue('B' . $rec, $row["NAMA_PRODUK"])->setCellValue('C' . $rec, $row["NIE"])->setCellValue('D' . $rec, $row["NAMA_PEMILIK_NIE"])->setCellValue('E' . $rec, $row["JENIS_IKLAN"])->setCellValue('F' . $rec, $row["MEDIA"])->setCellValue('G' . $rec, $row["NAMA_MEDIA"])->setCellValue('H' . $rec, $row["TANGGAL_MULAI"] . " s/d " . $row["TANGGAL_AKHIR"])->setCellValue('I' . $rec, $row["NARASI"])->setCellValue('J' . $rec, $row["HASIL"])->setCellValue('K' . $rec, $row["HASIL_PUSAT"])->setCellValue('L' . $rec, $justifikasi)->setCellValue('M' . $rec, $TLPusatArr[$row["TL_PUSAT"]])->setCellValue('N' . $rec, $uraiannya)->setCellValue('O' . $rec, $uraiannyaPusat)->setCellValue('P' . $rec, $row["NAMA_BBPOM"]);
		    $this->newphpexcel->set_detilstyle(array('A' . $rec, 'B' . $rec, 'C' . $rec, 'D' . $rec, 'E' . $rec, 'F' . $rec, 'G' . $rec, 'H' . $rec, 'I' . $rec, 'J' . $rec, 'K' . $rec, 'L' . $rec, 'M' . $rec, 'N' . $rec, 'O' . $rec, 'P' . $rec));
		    $this->newphpexcel->set_wrap(array('A' . $rec, 'B' . $rec, 'C' . $rec, 'D' . $rec, 'E' . $rec, 'F' . $rec, 'G' . $rec, 'H' . $rec, 'I' . $rec, 'J' . $rec, 'K' . $rec, 'L' . $rec, 'M' . $rec, 'N' . $rec, 'O' . $rec, 'P' . $rec));
		    $rec++;
		    $no++;
		}
	    } else {
		$this->newphpexcel->getActiveSheet()->mergeCells('A8:M8');
		$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A8', 'Data Pengawasan Iklan Tidak Ditemukan');
	    }
	    ob_clean();
	    $file = "LAPORAN_HASIL_PENGAWASAN_IKLAN_" . str_replace(" ", "_", str_replace("-", "", $judul)) . "_" . date("YmdHis") . ".xls";
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