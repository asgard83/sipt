<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
error_reporting(E_ERROR);

class _011M extends Model {

    function getFormPenandaan($klasifikasi = '') {
	if ($this->newsession->userdata('LOGGED_IN') == TRUE) {
	    $sipt = & get_instance();
	    $this->load->model("main", "main", true);
	    $kodeProvinsi = substr($this->newsession->userdata('SESS_PROP_ID'), 0, 2);
	    $detailProvinsiDef = $sipt->main->combobox("SELECT PROPINSI_ID, NAMA_PROPINSI FROM M_PROPINSI WHERE LEFT(PROPINSI_ID, 2) = '" . $kodeProvinsi . "' AND RIGHT(PROPINSI_ID, 2) != '00'", "NAMA_PROPINSI", "NAMA_PROPINSI", TRUE);
	    $provinsi = $sipt->main->combobox("SELECT PROPINSI_ID, NAMA_PROPINSI FROM M_PROPINSI WHERE LEFT(PROPINSI_ID, 1) <= '9' AND RIGHT(PROPINSI_ID, 2) = '00' AND LEFT(PROPINSI_ID, 2) = '" . $kodeProvinsi . "'", "PROPINSI_ID", "NAMA_PROPINSI");
	    $arrdata = array('provinsi' => $provinsi, 'kabupaten' => $detailProvinsiDef, 'act' => site_url() . '/penandaan/penandaanController/setFormPenandaanLanjutan/pengawasan/' . $klasifikasi, 'batal' => site_url() . '/penandaan/penandaanController/getFormPenandaanLanjutan/' . $klasifikasi, 'histori_petugas' => site_url() . '/load/petugas/get_petugas_2/');
	    $arrdata ['cb_tindakan'] = $this->config->item('tl_pusat_penandaan_smpk');
	    $arrdata ['cb_tindakan_balai'] = $this->config->item('tl_balai_penandaan_smpk');
	    $arrdata['editTL'] = 'YES';
	    $arrdata ['objStatus'] = 'TO';
	    $arrdata ['klasifikasi'] = $klasifikasi;
	    $arrdata ['labelSimpan'] = 'Simpan Data Pengawasan';
	    $arrdata ['icon'] = 'save';
	    return $arrdata;
	} else {
	    $this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.', '/home');
	}
    }

    function setFormPenandaan($isajax) {
	if ($isajax != "ajax") {
	    redirect(base_url());
	    exit();
	}
	$ret = "MSG#NO#Data gagal disimpan";
	$sipt = & get_instance();
	$case = "-";
	$sipt->load->model("main", "main", true);
	$arr_penandaan = $this->input->post('PENANDAAN');
	$arr_produk = $this->input->post('PENANDAANPRODUK');
	if ($this->input->post('MUSNAH')) {
	    $X = $this->input->post('MUSNAH');
	    $pemusnahan = $X['JUMLAH'] . "#" . $X['ESTIMASI'] . "^" . $X['SATUAN'] . "^" . $X["FILE"];
	}
	else
	    $pemusnahan = NULL;
	$arrChkBL = $this->input->post('CHKBL');
	$arrUrnBL = $this->input->post('URNBL');
	$arrChkKP = $this->input->post('CHKKP');
	$arrUrnKP = $this->input->post('URNKP');
	for ($i = 1; $i <= count($arrChkBL); $i++) {
	    $arrChkBLVal[$i] = $arrChkBL[$i];
	}
	$arr_penandaan_SM_BL = join("#", $arrChkBLVal);
	for ($i = 1; $i <= count($arrUrnBL); $i++) {
	    $arrUrnBLVal[$i] = $arrUrnBL[$i];
	}
	$arr_penandaan_URN_BL = join("^", $arrUrnBLVal);
	for ($i = 1; $i <= count($arrChkKP); $i++) {
	    $arrChkKPVal[$i] = $arrChkKP[$i];
	}
	$arr_penandaan_SM_KP = join("#", $arrChkKPVal);
	for ($i = 1; $i <= count($arrUrnKP); $i++) {
	    $arrUrnKPVal[$i] = $arrUrnKP[$i];
	}
	$arr_penandaan_URN_KP = join("^", $arrUrnKPVal);
	$lampiran = join("^", $this->input->post('PENANDAAN_SM'));
	$arr_petugas = $this->session->userdata('USER');
	$suratTugas = $this->session->userdata('SURAT');
	$suratId = (int) $sipt->main->get_uraian("SELECT MAX(SURAT_ID) AS MAXID FROM T_SURAT_TUGAS_PENANDAAN", "MAXID") + 1;
	$tanggalSurat = $this->session->userdata('TANGGAL');
	$hasilSistem = $this->input->post('URN');
	$justifikasi = "";
	if ($arr_penandaan['HASIL_PUSAT'] != $hasilSistem['HASIL'])
	    $justifikasi = $this->input->post('JUSTIFIKASI');
	if ($arr_penandaan['HASIL_PUSAT'] != "")
	    $hasilPusat = $arr_penandaan['HASIL_PUSAT'] . "*" . $arr_penandaan['TL_PUSAT'] . "*" . $justifikasi;
	else
	    $hasilPusat = NULL;
	if (empty($this->session->userdata['SURAT']) || $this->session->userdata['SURAT'] == '-') {
	    $suratTugas = "";
	}
	if (empty($this->session->userdata['TANGGAL'])) {
	    $tanggalSurat = NULL;
	}
	$penandaan_id = (int) $sipt->main->get_uraian("SELECT MAX(PENANDAAN_ID) AS MAXIKLAN FROM T_PENANDAAN", "MAXIKLAN") + 1;
	if (in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')))
	    $status = '20511';
	else if (!in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')))
	    $status = '20501';
	if (count($arr_petugas[0]) > 0) {
	    for ($i = 0; $i < count($arr_petugas[0]); $i++) {
		$surat = array('SURAT_ID' => $suratId, 'NOMOR_SURAT' => $suratTugas, 'TANGGAL' => $tanggalSurat, 'BALAI' => $this->newsession->userdata('SESS_BBPOM_ID'), 'PETUGAS' => $arr_petugas[0][$i], 'CREATED_BY' => $this->newsession->userdata('SESS_USER_ID'), 'CREATED' => 'GETDATE()');
		$this->db->insert('T_SURAT_TUGAS_PENANDAAN', $surat);
	    }
	}
	$penandaan = array('SURAT_ID' => $suratId, 'PENANDAAN_ID' => $penandaan_id, 'BBPOM_ID' => $this->newsession->userdata('SESS_BBPOM_ID'), 'TANGGAL_MULAI' => $arr_penandaan['TANGGALAWAL'], 'TANGGAL_AKHIR' => $arr_penandaan['TANGGALAKHIR'], 'SARANA_ID' => $arr_penandaan['SARANAID'], 'KOMODITI' => $this->input->post('KLASIFIKASIPENANDAAN'), 'STATUS' => $status, 'CREATE_BY' => $this->newsession->userdata('SESS_USER_ID'), 'USER_LAST_UPDATE' => $this->newsession->userdata('SESS_USER_ID'), 'LAST_UPDATE' => 'GETDATE()');
	$this->db->insert('T_PENANDAAN', $penandaan);
	if ($this->db->affected_rows() > 0) {
	    $log = array('PENANDAAN_ID' => $penandaan_id, 'SERI' => 1, 'STATUS' => $status, 'CATATAN' => '', 'CREATEDBY' => $this->newsession->userdata('SESS_USER_ID'), 'CREATED' => 'GETDATE()', 'UPDATED' => 'GETDATE()');
	}
	$this->db->insert('T_PENANDAAN_PROSES', $log);
	if ($this->db->affected_rows() > 0) {
	    $produk = array('PENANDAAN_ID' => $penandaan_id, 'NAMA_PRODUK' => $arr_produk['NAMA_PRODUK'], 'BENTUK_SEDIAAN' => $arr_produk['BENTUK_SEDIAAN'], 'BESAR_KEMASAN' => $arr_produk['BESAR_KEMASAN'], 'KOMPOSISI' => $arr_produk['KOMPOSISI'], 'PRODUSEN' => $arr_produk['PRODUSEN'], 'PENDAFTAR' => $arr_produk['PENDAFTAR'], 'NOMOR_IZIN_EDAR' => $arr_produk['NIE'], 'ALAMAT_PRODUSEN' => $arr_produk['ALAMAT_PRODUSEN'], 'ALAMAT_PENDAFTAR' => $arr_produk['ALAMAT_PENDAFTAR']);
	}
	$this->db->insert('T_PENANDAAN_PRODUK', $produk);
	if ($this->db->affected_rows() > 0) {
	    $penandaanSM = array('PENANDAAN_ID' => $penandaan_id, 'PENILAIANBL' => $arr_penandaan_SM_BL, 'PENILAIANKP' => $arr_penandaan_SM_KP, 'URAIANBL' => $arr_penandaan_URN_BL, 'URAIANKP' => $arr_penandaan_URN_KP, 'LAMPIRAN' => $lampiran, 'TL_BALAI' => $arr_penandaan['TL_BALAI'], 'PEMUSNAHAN' => $pemusnahan, 'SISTEM' => $hasilSistem['HASIL'], 'PUSAT' => $hasilPusat);
	}
	$this->db->insert('T_PENANDAAN_PK_SM', $penandaanSM);
	if ($this->db->affected_rows() > 0) {
	    $case = 'YESPENANDAANSM';
	} else {
	    $case = 'NO';
	}
	if ($case == 'YESPENANDAANSM') {
	    $sess_array = array("TANGGAL" => "", "SURAT" => "", "BBPOM" => "");
	    $this->session->unset_userdata($sess_array);
	    $ret = "MSG#YES#Data penandaan berhasil disimpan#" . site_url() . '/penandaan/penandaanController/setListFormPenandaanLanjutan/1101/2';
	}
	return $ret;
    }

    function updateStatus($X, $isajax) {
	if ($isajax != "ajax") {
	    redirect(base_url());
	    exit();
	}
	$ret = "MSG#NO#Data gagal disimpan";
	$sipt = & get_instance();
	$case = "-";
	$sipt->load->model("main", "main", true);
	$arr_penandaan = $this->input->post('PENANDAAN');
	$arr_produk = $this->input->post('PENANDAANPRODUK');
	if ($this->input->post('MUSNAH')) {
	    $x = $this->input->post('MUSNAH');
	    $pemusnahan = $x['JUMLAH'] . "#" . $x['ESTIMASI'] . "^" . $x['SATUAN'] . "^" . $x["FILE"];
	}
	else
	    $pemusnahan = NULL;
	$arrChkBL = $this->input->post('CHKBL');
	$arrUrnBL = $this->input->post('URNBL');
	$arrChkKP = $this->input->post('CHKKP');
	$arrUrnKP = $this->input->post('URNKP');
	for ($i = 1; $i <= count($arrChkBL); $i++) {
	    $arrChkBLVal[$i] = $arrChkBL[$i];
	}
	$arr_penandaan_SM_BL = join("#", $arrChkBLVal);
	for ($i = 1; $i <= count($arrUrnBL); $i++) {
	    $arrUrnBLVal[$i] = $arrUrnBL[$i];
	}
	$arr_penandaan_URN_BL = join("^", $arrUrnBLVal);
	for ($i = 1; $i <= count($arrChkKP); $i++) {
	    $arrChkKPVal[$i] = $arrChkKP[$i];
	}
	$arr_penandaan_SM_KP = join("#", $arrChkKPVal);
	for ($i = 1; $i <= count($arrUrnKP); $i++) {
	    $arrUrnKPVal[$i] = $arrUrnKP[$i];
	}
	$arr_penandaan_URN_KP = join("^", $arrUrnKPVal);
	$lampiran = join("^", $this->input->post('PENANDAAN_SM'));
	$hasilSistem = $this->input->post('URN');
	$justifikasi = "";
	$statusUPD = array();
	$saranaUPD = array();
	if ($arr_penandaan['HASIL_PUSAT'] != $hasilSistem['HASIL'])
	    $justifikasi = $this->input->post('JUSTIFIKASI');
	if ($arr_penandaan['HASIL_PUSAT'] != "")
	    $hasilPusat = $arr_penandaan['HASIL_PUSAT'] . "*" . $arr_penandaan['TL_PUSAT'] . "*" . $justifikasi;
	else
	    $hasilPusat = NULL;
	$status = $this->input->post('TO');
	$arr_update_log = array('UPDATED' => 'GETDATE()');
	$penandaanId = $this->input->post('PENANDAAN_ID');
	foreach ($penandaanId as $penandaan_id) {
	    $seri = (int) $sipt->main->get_uraian("SELECT MAX(SERI) AS MAXID FROM T_PENANDAAN_PROSES WHERE PENANDAAN_ID = '" . $penandaan_id . "'", "MAXID") + 1;
	    if ($status) {
		$statusUPD = array('STATUS' => $status);
		$log = array('PENANDAAN_ID' => $penandaan_id, 'SERI' => $seri, "STATUS" => $status, 'CATATAN' => $this->input->post('CATATAN'), 'CREATEDBY' => $this->newsession->userdata('SESS_USER_ID'), 'CREATED' => 'GETDATE()', 'UPDATED' => 'GETDATE()');
		$this->db->insert('T_PENANDAAN_PROSES', $log);
	    }
	    if ($arr_penandaan['SARANAID']) {
		$saranaUPD = array('TANGGAL_MULAI' => $arr_penandaan['TANGGALAWAL'], 'TANGGAL_AKHIR' => $arr_penandaan['TANGGALAKHIR'], 'SARANA_ID' => $arr_penandaan['SARANAID'], 'KOMODITI' => '011');
	    }
	    $penandaan = array_merge($statusUPD, $saranaUPD, array('USER_LAST_UPDATE' => $this->newsession->userdata('SESS_USER_ID'), 'LAST_UPDATE' => 'GETDATE()'));
	    $this->db->where(array("PENANDAAN_ID" => $penandaan_id, "SERI" => $seri - 1));
	    $this->db->update('T_PENANDAAN_PROSES', $arr_update_log);
	    $this->db->where(array("PENANDAAN_ID" => $penandaan_id));
	    $this->db->update('T_PENANDAAN', $penandaan);
	    if (!empty($arr_produk)) {
		$produk = array('NAMA_PRODUK' => $arr_produk['NAMA_PRODUK'], 'KLASIFIKASI_PRODUK' => $arr_produk['KLASIFIKASI_PRODUK'], 'BENTUK_SEDIAAN' => $arr_produk['BENTUK_SEDIAAN'], 'BESAR_KEMASAN' => $arr_produk['BESAR_KEMASAN'], 'KOMPOSISI' => $arr_produk['KOMPOSISI'], 'BESAR_KEMASAN' => $arr_produk['BESAR_KEMASAN'], 'KLASIFIKASI_PENDAFTAR' => $arr_produk['KLASIFIKASI_PENDAFTAR'], 'PRODUSEN' => $arr_produk['PRODUSEN'], 'PENDAFTAR' => $arr_produk['PENDAFTAR'], 'NOMOR_IZIN_EDAR' => $arr_produk['NOMOR_IZIN_EDAR'], 'GOLONGAN_PRODUK' => $arr_produk['GOLONGAN_PRODUK'], 'NOMOR_PRODUK' => $arr_produk['NOMOR_PRODUK']);
		$this->db->where(array("PENANDAAN_ID" => $penandaan_id));
		$this->db->update('T_PENANDAAN_PRODUK', $produk);
	    }
	    if (!in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) {
		$penandaanSM = array('PENILAIANBL' => $arr_penandaan_SM_BL, 'PENILAIANKP' => $arr_penandaan_SM_KP, 'URAIANBL' => $arr_penandaan_URN_BL, 'URAIANKP' => $arr_penandaan_URN_KP, 'LAMPIRAN' => $lampiran, 'TL_BALAI' => $arr_penandaan['TL_BALAI'], 'PEMUSNAHAN' => $pemusnahan, 'SISTEM' => $hasilSistem['HASIL'], 'PUSAT' => $hasilPusat);
	    } else {
		if (!empty($arr_penandaan_SM_BL))
		    $penandaanSM = array('PENILAIANBL' => $arr_penandaan_SM_BL, 'PENILAIANKP' => $arr_penandaan_SM_KP, 'URAIANBL' => $arr_penandaan_URN_BL, 'URAIANKP' => $arr_penandaan_URN_KP, 'LAMPIRAN' => $lampiran, 'TL_BALAI' => $arr_penandaan['TL_BALAI'], 'PEMUSNAHAN' => $pemusnahan, 'SISTEM' => $hasilSistem['HASIL'], 'PUSAT' => $hasilPusat);
		else
		    $penandaanSM = array('PUSAT' => $hasilPusat);
	    }
	    $this->db->where(array("PENANDAAN_ID" => $penandaan_id));
	    $this->db->update('T_PENANDAAN_PK_SM', $penandaanSM);
	    $case = 'YESPENANDAANSM';
	}
	if ($case == 'YESPENANDAANSM') {
	    if ($status == '20502' || $status == '20512')
		$ret = "MSG#YES#Data perbaikan penandaan berhasil dikirim#" . site_url() . '/penandaan/penandaanController/setListFormPenandaanLanjutan/1101/' . $this->input->post("TUJUAN");
	    else if ($status == '30504' || $status == '30514' || $status == '30511' || $status == '30501')
		$ret = "MSG#YES#Data perbaikan penandaan berhasil dikirim#" . site_url() . '/penandaan/penandaanController/setListFormPenandaanLanjutan/1212/' . $this->input->post("TUJUAN");
	    else
		$ret = "MSG#YES#Data perbaikan penandaan berhasil disimpan#" . site_url() . '/penandaan/penandaanController/setListFormPenandaanLanjutan/1101/' . $this->input->post("TUJUAN");
	}
	return $ret;
    }

    function getPreview($klasfikasi, $jenisPelaporan, $idPengawasan) {
	$sipt = & get_instance();
	$this->load->model("main", "main", true);
	$query = "SELECT TPPS.URAIANBL, TPPS.URAIANKP, TPPS.PENILAIANBL, TPPS.PENILAIANKP, TPPS.PUSAT, TPPS.SISTEM, TP.PENANDAAN_ID, CONVERT(VARCHAR(10), TP.TANGGAL_MULAI, 120) AS TANGGAL_MULAI, CONVERT(VARCHAR(10), TP.TANGGAL_AKHIR, 120) AS TANGGAL_AKHIR, TP.SURAT_ID, TP.STATUS FROM T_PENANDAAN TP RIGHT JOIN T_PENANDAAN_PK_SM TPPS ON TPPS.PENANDAAN_ID = TP.PENANDAAN_ID WHERE TPPS.PENANDAAN_ID = '" . $idPengawasan . "'";
	$data = $sipt->main->get_result($query);
	if ($data) {
	    foreach ($query->result_array() as $row) {
		$arrdata = array('sess' => $row, 'judul' => 'Sulemen Makanan');
	    }
	    if ($row['STATUS'] == '20302' || $row['STATUS'] == '20312') {
		$arrdata['act'] = site_url() . '/penandaan/penandaanController/prosesEdit/edit/' . $row['PENANDAAN_ID'] . '/' . $row['STATUS'] . '/011/' . $jenisPelaporan;
		$arrdata['tombol'] = 'Lihat Data Perbaikan Pengawasan';
	    } else {
		$arrdata['act'] = site_url() . '/penandaan/penandaanController/prosesPreview/preview/' . $row['PENANDAAN_ID'] . '/' . $row['STATUS'] . '/011/' . $jenisPelaporan;
		$arrdata['tombol'] = 'Lihat Data Pengawasan';
	    }
	    $arrdata['histori_petugas'] = site_url() . '/load/petugas/get_petugas_2/' . $row['SURAT_ID'] . '/T_SURAT_TUGAS_PENANDAAN';
	}
	return $arrdata;
    }

    function inputPreview($jenis, $penandaanId, $status, $klasifikasi, $subid = "", $user = "", $bbpom = "") {
	$sipt = & get_instance();
	$this->load->model("main", "main", true);
	$sipt->load->model('penandaan/penandaan_act');
	$roleOri = $sipt->penandaan_act->getRole();
	$role = $roleOri;
	$isEditTLPusat = "NO";
	$urlId = explode('/', $_SERVER['PATH_INFO']);
	if ($urlId[3] == 'prosesEdit' && ((in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')) && in_array($bbpom, $this->config->item('cfg_unit'))) || (!in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')) && !in_array($bbpom, $this->config->item('cfg_unit')))))
	    $tglQuery = "TP.TANGGAL_MULAI, 103) AS TANGGAL_MULAI, CONVERT(VARCHAR(10), TP.TANGGAL_AKHIR, 103) AS TANGGAL_AKHIR";
	else
	    $tglQuery = "TP.TANGGAL_MULAI, 120) AS TANGGAL_MULAI, CONVERT(VARCHAR(10), TP.TANGGAL_AKHIR, 120) AS TANGGAL_AKHIR";
	$query = "SELECT TSTP.SURAT_ID, TPPS.PENILAIANBL, TPPS.PENILAIANKP, TPPS.URAIANBL, TPPS.URAIANKP, CONVERT(VARCHAR(MAX), TPPS.LAMPIRAN) AS LAMPIRAN, TPPS.PUSAT, TPPS.TL_BALAI, TPPS.SISTEM, TPPS.PEMUSNAHAN, TP.PENANDAAN_ID, CONVERT(VARCHAR(10), " . $tglQuery . ", TP.STATUS, TP.KOMODITI, TP.SARANA_ID, TP.BBPOM_ID, TPP.NAMA_PRODUK, TPP.BENTUK_SEDIAAN, TPP.BESAR_KEMASAN, TPP.KOMPOSISI, TPP.PRODUSEN, TPP.ALAMAT_PRODUSEN, TPP.PENDAFTAR, TPP.ALAMAT_PENDAFTAR, TPP.NOMOR_IZIN_EDAR, TPP.GOLONGAN_PRODUK, TPP.NOMOR_PRODUK, MS.NAMA_SARANA, MS.ALAMAT_1, (SELECT MP1.NAMA_PROPINSI FROM M_PROPINSI MP1 WHERE MP1.PROPINSI_ID = MS.PROPINSI) AS PROPINSI, (SELECT MP2.NAMA_PROPINSI FROM M_PROPINSI MP2 WHERE MP2.PROPINSI_ID = MS.KOTA) AS KOTA FROM T_PENANDAAN TP RIGHT JOIN T_PENANDAAN_PK_SM TPPS ON TPPS.PENANDAAN_ID = TP.PENANDAAN_ID RIGHT JOIN T_PENANDAAN_PRODUK TPP ON TPP.PENANDAAN_ID = TP.PENANDAAN_ID RIGHT JOIN T_SURAT_TUGAS_PENANDAAN TSTP ON TSTP.SURAT_ID = TP.SURAT_ID RIGHT JOIN M_SARANA MS ON MS.SARANA_ID = TP.SARANA_ID WHERE TP.PENANDAAN_ID = '" . $penandaanId . "'";
	$data = $sipt->main->get_result($query);
	if ($data) {
	    foreach ($query->result_array() as $row) {
		$arrdata = array('sess' => $row, 'judul' => 'Suplemen Makanan');
	    }
	    $arrdata['histori_petugas'] = site_url() . '/load/petugas/get_petugas_2/' . $row['SURAT_ID'] . '/T_SURAT_TUGAS_PENANDAAN';
	}
	if (array_key_exists('2', $this->newsession->userdata('SESS_KODE_ROLE')) && ($subid == '0101' || $subid == '1101') && $arrdata['sess']['BBPOM_ID'] && $jenis != 'preview')
	    $isEditTLPusat = "YES";
	else if ($subid == '1111')
	    $isEditTLPusat = "YES";
	if ($role == '2') {
	    $arrayClause = array('20501', '20502', '20503', '20511', '20515', '20512');
	} else if ($role == '3') {
	    $arrayClause = array('30501', '30502', '30503', '30504', '30511', '30512', '30513', '30514');
	} else if ($role == '4') {
	    $arrayClause = array('40501', '40502', '40503', '40511', '40512', '40513');
	} else if ($role == '5') {
	    $arrayClause = array('50501');
	} else if ($role == '6') {
	    $arrayClause = array('60511');
	}
	$str .= '</table>';
	$arrdata ['sess2'] = $str;
	if ($status == '20502' || $status == '20512' || (($status == '20511' || $status == '20501') && $jenis == 'draft')) {
	    if ((!in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))))
		$arrdata ['act'] = site_url() . "/penandaan/penandaanController/updateStatus/" . $klasifikasi . "/1";
	    else if ((in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) && $status == '20511' && $jenis == 'draft')
		$arrdata ['act'] = site_url() . "/penandaan/penandaanController/updateStatus/" . $klasifikasi . "/1";
	    else
		$arrdata ['act'] = site_url() . "/penandaan/penandaanController/setStatus/1";
	    $arrdata ['subJudul'] = '- SUPLEMEN MAKANAN';
	}
	else
	    $arrdata ['act'] = site_url() . "/penandaan/penandaanController/setStatus/1";
	$arrdata ['status'] = $sipt->main->set_verifikasi($status, $this->newsession->userdata('SESS_JENIS_PELAPORAN'), $this->newsession->userdata('SESS_KODE_ROLE'));
	$arrdata ['disverifikasi'] = $status;
	$arrdata ['objStatus'] = 'TO';
	$arrdata ['cb_tindakan'] = $sipt->main->referensi("TL_DISTRIBUSI", "01,02", TRUE, FALSE);
	$arrdata ['role'] = $roleOri;
	$arrdata ['cancel'] = site_url() . '/penandaan/penandaanController/setListFormPenandaanLanjutan/' . $user;
	$arrdata ['labelSimpan'] = 'Proses Data Perbaikan Pengawasan';
	$arrdata ['icon'] = 'check';
	$arrdata['tujuan'] = $user;
	$arrdata ['editTL'] = $isEditTLPusat;
	if (($subid == '1101' || $subid == '0101') && $jenis != 'preview') {
	    $arrdata ['subJudul'] = '- SUPLEMEN MAKANAN EDIT';
	    if ($subid == '0101') {
		$arrdata ['formEdit'] = 'check';
		$arrdata ['labelSimpan'] = 'Proses Perbaikan Data Pengawasan';
		$arrdata ['icon'] = 'check';
	    } else {
		$arrdata ['labelSimpan'] = 'Simpan Data Pengawasan';
		$arrdata ['icon'] = 'save';
	    }
	    $arrdata ['act'] = site_url() . "/penandaan/penandaanController/updateStatus/" . $klasifikasi . "/1";
	} else if ($subid != '1212' && $subid != '1122' && !empty($urlId[9])) {
	    if ($subid == '1101' && $jenis == 'preview') {
		$arrdata ['labelSimpan'] = 'Proses Perbaikan Data Pengawasan';
	    }
	    $arrdata ['formEdit'] = 'check';
	    $arrdata ['icon'] = 'check';
	    $arrdata ['act'] = site_url() . "/penandaan/penandaanController/setStatus/1";
	}
	$arrdata ['cb_tindakan'] = $this->config->item('tl_pusat_penandaan_smpk');
	$arrdata ['cb_tindakan_balai'] = $this->config->item('tl_balai_penandaan_smpk');
	if (!in_array($arrdata ['sess']['STATUS'], $arrayClause)) {
	    if ($status != '60510' && ($subid == '1101' || $subid == '0101' || $subid == '0111' || $subid == '1221' || $subid == '1111' || $subid == '1222' || $subid == '0303' || $subid == '0313' || $subid == '0404')) {
		redirect('/penandaan/penandaanController/setListFormPenandaanLanjutan/' . $subid . '/' . $user);
		exit();
	    }
	}
	return $arrdata;
    }

    function report() {
	if ($this->newsession->userdata('LOGGED_IN') == TRUE) {
	    $sipt = & get_instance();
	    $this->load->model("main", "main", true);
	    $sipt->load->model('penandaan/penandaan_act');
	    $this->load->library('newphpexcel');
	    $judul = strtoupper($sipt->main->get_uraian("SELECT dbo.NAMA_JENIS_SARANA('" . $this->input->post('JENIS') . "') AS JUDUL", "JUDUL"));
	    $filter2 = "";
	    $mode = "";
	    $filterQueryAs = explode("+", $this->input->post('BUNGKUS'));
	    if (trim($this->input->post('AWAL') != "")) {
		$filter2 .= " DATEDIFF(dy, 0, CONVERT(DATETIME, TP.TANGGAL_MULAI, 105)) >= DATEDIFF(dy, 0, CONVERT(DATETIME, '" . $this->input->post('AWAL') . "', 105))";
		$awal = $this->input->post('AWAL');
	    } else {
		$filter2 .= " TP.TANGGAL_MULAI > GETDATE()";
		$awal = date('01/m/Y');
	    }
	    if (trim($this->input->post('AKHIR') != "")) {
		$filter2 .= " AND DATEDIFF(dy, 0, CONVERT(DATETIME, TP.TANGGAL_AKHIR, 105)) <= DATEDIFF(dy, 0, CONVERT(DATETIME, '" . $this->input->post('AKHIR') . "', 105))";
		$akhir = $this->input->post('AKHIR');
	    } else {
		$filter2 .= " AND TP.TANGGAL_AKHIR < GETDATE()";
		$akhir = date('t/m/Y');
	    }
	    if (in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')) || $this->newsession->userdata('SESS_BBPOM_ID') == "00") {
		if (trim($this->input->post('BBPOM_ID')) == "") {
		    $filter2 .= "";
		    $balai = 'Seluruh Balai';
		} else {
		    $filter2 .= " AND TP.BBPOM_ID = '" . $this->input->post('BBPOM_ID') . "'";
		    $balai = $sipt->main->get_uraian("SELECT NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID = '" . $this->input->post('BBPOM_ID') . "'", "NAMA_BBPOM");
		}
	    } else {
		$filter2 .= " AND TP.BBPOM_ID = '" . $this->newsession->userdata('SESS_BBPOM_ID') . "'";
		$balai = $sipt->main->get_uraian("SELECT NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID = '" . $this->newsession->userdata('SESS_BBPOM_ID') . "'", "NAMA_BBPOM");
	    }
	    $query = "SELECT DISTINCT TP.PENANDAAN_ID, TP.BBPOM_ID,  (REPLACE(REPLACE(MB.NAMA_BBPOM,'BALAI BESAR POM DI ', ''),'BALAI POM DI ','')) AS BBPOM, MS.ALAMAT_1, CONVERT(VARCHAR(10), TP.TANGGAL_MULAI, 105) AS TANGGAL_MULAI, CONVERT(VARCHAR(10), TP.TANGGAL_AKHIR, 105) AS TANGGAL_AKHIR, TPP.NAMA_PRODUK, TPP.KLASIFIKASI_PRODUK, TPP.BENTUK_SEDIAAN, TPP.BESAR_KEMASAN, TPP.KOMPOSISI, TPP.NOMOR_IZIN_EDAR, TPP.GOLONGAN_PRODUK, TPP.PENDAFTAR FROM T_PENANDAAN TP LEFT JOIN M_BBPOM MB ON MB.BBPOM_ID = TP.BBPOM_ID LEFT JOIN T_PENANDAAN_PRODUK TPP ON TPP.PENANDAAN_ID = TP.PENANDAAN_ID LEFT JOIN M_SARANA MS ON MS.SARANA_ID = TP.SARANA_ID WHERE $filter2 AND TP.KOMODITI = '011' GROUP BY MB.BBPOM_ID, MB.NAMA_BBPOM, TP.KOMODITI, MS.ALAMAT_1, TP.PENANDAAN_ID, TP.BBPOM_ID, TP.TANGGAL_MULAI, TP.TANGGAL_AKHIR, TPP.NAMA_PRODUK, TPP.KLASIFIKASI_PRODUK, TPP.BENTUK_SEDIAAN, TPP.BESAR_KEMASAN, TPP.KOMPOSISI, TPP.NOMOR_IZIN_EDAR, TPP.GOLONGAN_PRODUK, TPP.PENDAFTAR ORDER BY 1";
	    $this->newphpexcel->set_font('Calibri', 10);
	    $this->newphpexcel->setActiveSheetIndex(0);
	    $this->newphpexcel->set_title('LAPORAN PENANDAAN Sm');
	    $this->newphpexcel->mergecell(array(array('A1', 'D1'), array('A2', 'D2'), array('A3', 'D3'), array('A4', 'D4'), array('G6', 'J6'), array('X6', 'Y6')), TRUE);
	    if ((trim($this->input->post('BBPOM_ID')) == "" && !in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) || (trim($this->input->post('BBPOM_ID')) != "" && in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')) && !in_array($this->input->post('BBPOM_ID'), $this->config->item('cfg_unit')))) {
		$this->newphpexcel->mergecell(array(array('A6', 'A7'), array('B6', 'B7'), array('C6', 'C7'), array('D6', 'D7'), array('E6', 'E7'), array('F6', 'F7'), array('K6', 'K7'), array('L6', 'L7'), array('M6', 'M7'), array('N6', 'N7'), array('O6', 'O7'), array('P6', 'P7'), array('Q6', 'Q7'), array('R6', 'R7'), array('S6', 'S7'), array('T6', 'T7'), array('U6', 'U7'), array('V6', 'V7'), array('W6', 'W7'), array('Z6', 'AA6'), array('AB6', 'AB7')), TRUE);
		$this->newphpexcel->set_bold(array('A1', 'A2', 'A3', 'A4'));
		$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A1', 'LAPORAN HASIL PENGAWASAN PENANDAAN OBAT TRADISIONAL')->setCellValue('A2', $judul)->setCellValue('A3', strtoupper($balai))->setCellValue('A4', 'PERIODE : ' . $awal . ' s.d ' . $akhir);
		$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A6', 'No')->setCellValue('B6', 'Nama Produk')->setCellValue('C6', 'Jenis Kemasan')->setCellValue('D6', 'Tanggal Pengawasan')->setCellValue('E6', 'No Bets')->setCellValue('F6', 'Netto')->setCellValue('G6', 'Nama Dan Alamat')->setCellValue('K6', 'NIE')->setCellValue('L6', 'Exp. Date')->setCellValue('M6', 'Komposisi')->setCellValue('N6', 'Cara Penggunaan')->setCellValue('O6', 'Klaim')->setCellValue('P6', 'Peringatan (Jika Ada)')->setCellValue('Q6', 'Cara Penyimpanan')->setCellValue('R6', 'Bentuk Sediaan')->setCellValue('S6', 'Bahasa Indonesia')->setCellValue('T6', 'Tercetak Langsung')->setCellValue('U6', 'Kemasan')->setCellValue('V6', 'Narasi')->setCellValue('W6', 'Keterangan')->setCellValue('X6', 'Kesimpulan')->setCellValue('Z6', 'Tindak Lanjut')->setCellValue('AB6', 'Justifikasi')->setCellValue('G7', 'Produsen')->setCellValue('H7', 'Importir')->setCellValue('I7', 'Distributor')->setCellValue('J7', 'Pemberi Lisensi')->setCellValue('X7', 'Balai')->setCellValue('Y7', 'Pusat')->setCellValue('Z7', 'Balai')->setCellValue('AA7', 'Pusat');
		$this->newphpexcel->headings(array('A6', 'B6', 'C6', 'D6', 'E6', 'F6', 'G6', 'H6', 'I6', 'J6', 'K6', 'L6', 'M6', 'N6', 'O6', 'P6', 'Q6', 'R6', 'S6', 'T6', 'U6', 'V6', 'W6', 'X6', 'Y6', 'Z6', 'AA6', 'AB6'));
		$this->newphpexcel->headings(array('A7', 'B7', 'C7', 'D7', 'E7', 'F7', 'G7', 'H7', 'I7', 'J7', 'K7', 'L7', 'M7', 'N7', 'O7', 'P7', 'Q7', 'R7', 'S7', 'T7', 'U7', 'V7', 'W7', 'X7', 'Y7', 'Z7', 'AA7', 'AB7'));
		$this->newphpexcel->set_wrap(array('A6', 'B6', 'C6', 'D6', 'E6', 'F6', 'G6', 'H6', 'I6', 'J6', 'K6', 'L6', 'M6', 'N6', 'O6', 'P6', 'Q6', 'R6', 'S6', 'T6', 'U6', 'V6', 'W6', 'X6', 'Y7', 'Z6', 'AA6', 'AB6'));
		$this->newphpexcel->width(array(array('A', 4), array('B', 28), array('C', 20), array('D', 30), array('E', 20), array('F', 20), array('G', 30), array('H', 30), array('I', 30), array('J', 30), array('K', 30), array('L', 12), array('M', 30), array('N', 30), array('O', 30), array('P', 30), array('Q', 40), array('R', 30), array('S', 30), array('T', 30), array('U', 30), array('V', 30), array('W', 40), array('X', 10), array('Y', 10), array('Z', 20), array('AA', 20), array('AB', 40)));
		$this->newphpexcel->set_bold(array('A1', 'A2', 'A3', 'A4'));
		$arrSign = $this->config->item('array_sign_penilaian_iklan');
		$arrTLBalai = $this->config->item('tl_balai_penandaan_smpk');
		$arrTLPusat = $this->config->item('tl_pusat_penandaan_smpk');
		$nonTMK = array(5, 6, 12);
		$data = $sipt->main->get_result($query);
		if ($data) {
		    $no = 1;
		    $rec = 8;
		    $mergeA = 1;
		    $i = 0;
		    foreach ($query->result_array() as $row) {
			if ($this->input->post('BUNGKUS') == "")
			    $mode = "ALL";
			else if ($this->input->post('BUNGKUS') != "")
			    $mode = "ONE";
			if ($this->input->post('HASIL') != "") {
			    $filterMKTMK = $this->input->post('HASIL');
			    $filterHasil = " AND (((TP.BBPOM_ID IN (" . "'" . join("','", $this->config->item('cfg_unit')) . "'" . ") OR TP.STATUS = 60510) AND TPK.PUSAT LIKE '%$filterMKTMK%') OR (TP.BBPOM_ID NOT IN (" . "'" . join("','", $this->config->item('cfg_unit')) . "'" . ") AND TP.STATUS <> 60510 AND TPK.SISTEM = '$filterMKTMK')) ";
			} else {
			    $filterHasil = "";
			}
			if ($mode == "ALL") {
			    $query1 = "SELECT TPK.PENILAIANBL, TPK.PENILAIANKP, TPK.URAIANBL, TPK.URAIANKP, TPK.PUSAT, TPK.SISTEM, TPK.TL_BALAI FROM T_PENANDAAN_PK_SM TPK LEFT JOIN T_PENANDAAN TP ON TP.PENANDAAN_ID = TPK.PENANDAAN_ID WHERE TP.PENANDAAN_ID = '" . $row['PENANDAAN_ID'] . "' $filterHasil";
			} else if ($mode == "ONE") {
			    $query1 = "SELECT TPK.PENILAIAN$filterQueryAs[1] AS PENILAIAN, TPK.URAIAN$filterQueryAs[1] AS URAIAN, TPK.PUSAT, TPK.SISTEM, TPK.TL_BALAI FROM T_PENANDAAN_OT TPK LEFT JOIN T_PENANDAAN TP ON TP.PENANDAAN_ID = TPK.PENANDAAN_ID WHERE TP.PENANDAAN_ID = '" . $row['PENANDAAN_ID'] . "' $filterHasil";
			}
			$data1 = $sipt->main->get_result($query1);
			if ($data1) {
			    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('B' . $rec, $row['NAMA_PRODUK'])->setCellValue('C' . $rec, $filterQueryAs[2])->setCellValue('D' . $rec, $row['TANGGAL_MULAI'] . " s/d " . $row['TANGGAL_AKHIR'])->setCellValue('K' . $rec, $row['NOMOR_IZIN_EDAR'])->setCellValue('M' . $rec, $row['KOMPOSISI']);
			    $this->newphpexcel->set_wrap(array('B' . $rec, 'C' . $rec, 'D' . $rec, 'K' . $rec, 'M' . $rec));
			    foreach ($query1->result_array() as $row1) {
				if ($this->input->post('BUNGKUS') != "" && $mode == "ONE") {
				    $arrPenilaian = explode('#', $row1["PENILAIAN"]);
				    $arrUraian = explode('^', $row1["URAIAN"]);
				    $int = 0;
				    $int2 = 0;
				    $penilaian = array();
				    $uraian = array();
				    foreach ($arrPenilaian as $value) {
					$arrValPenilaian = explode("_", $value);
					if (trim($arrValPenilaian[0]) == "X" || trim($arrValPenilaian[0]) == "-") {
					    if (!in_array($int, $nonTMK))
						$penilaian[$int] = $arrValPenilaian[1] . " " . $arrSign[$arrValPenilaian[0]];
					}
					$int++;
				    }
				    foreach ($arrUraian as $value) {
					$uraian[$int2] = $value;
					$int2++;
				    }
				    $hasilPusat = explode("*", $row1["PUSAT"]);
				    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A' . $rec, $no);
				    $rec++;
				    $x = $rec - 1;
				    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('E' . $x, trim($uraian[0]) != "" ? $uraian[0] : "-");
				    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('F' . $x, trim($uraian[1]) != "" ? $uraian[1] : "-");
				    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('G' . $x, trim($uraian[3]) != "" ? $uraian[3] : "-");
				    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('H' . $x, trim($uraian[4]) != "" ? $uraian[4] : "-");
				    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('I' . $x, trim($uraian[5]) != "" ? $uraian[5] : "-");
				    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('J' . $x, trim($uraian[6]) != "" ? $uraian[6] : "-");
				    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('L' . $x, trim($uraian[7]) != "" ? $uraian[7] : "-");
				    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('N' . $x, trim($uraian[9]) != "" ? $uraian[9] : "-");
				    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('O' . $x, trim($uraian[11]) != "" ? $uraian[11] : "-");
				    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('P' . $x, trim($uraian[12]) != "" ? $uraian[12] : "-");
				    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('Q' . $x, trim($uraian[10]) != "" ? $uraian[10] : "-");
				    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('R' . $x, trim($uraian[13]) != "" ? $uraian[13] : "-");
				    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('S' . $x, trim($uraian[14]) != "" ? $uraian[14] : "-");
				    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('T' . $x, trim($uraian[17]) != "" ? $uraian[17] : "-");
				    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('U' . $x, trim($uraian[15]) != "" ? $uraian[15] : "-");
				    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('V' . $x, trim($uraian[16]) != "" ? $uraian[16] : "-");
				    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('W' . $x, trim(join("", $penilaian)) != "" ? " - " . join("\n - ", $penilaian) : " - ");
				    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('X' . $x, $row1["SISTEM"]);
				    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('Y' . $x, trim($hasilPusat[0]) != "" ? $hasilPusat[0] : "-");
				    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('Z' . $x, trim($row1["TL_BALAI"]) != "" ? $arrTLBalai[$row1["TL_BALAI"]] : "-");
				    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('AA' . $x, trim($hasilPusat[1]) != "" ? $arrTLPusat[$hasilPusat[1]] : "-");
				    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('AB' . $x, trim($hasilPusat[2]) != "" ? preg_replace('/(?:<|&lt;)\/?([a-zA-Z]+) *[^<\/]*?(?:>|&gt;)/', '', $hasilPusat[2]) : "-");
				    $no++;
				    $this->newphpexcel->set_wrap(array('A' . $x, 'E' . $x, 'F' . $x, 'G' . $x, 'H' . $x, 'I' . $x, 'J' . $x, 'L' . $x, 'N' . $x, 'O' . $x, 'P' . $x, 'Q' . $x, 'R' . $x, 'S' . $x, 'T' . $x, 'U' . $x, 'V' . $x, 'W' . $x, 'X' . $x, 'Y' . $x, 'Z' . $x, 'AA' . $x, 'AB' . $x));
				} else {
				    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A' . $rec, $no);
				    $hasilPusat = explode("*", $row1["PUSAT"]);
				    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('X' . $rec, $row1["SISTEM"]);
				    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('Y' . $rec, trim($hasilPusat[0]) != "" ? $hasilPusat[0] : "-");
				    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('Z' . $rec, trim($row1["TL_BALAI"]) != "" ? $arrTLBalai[$row1["TL_BALAI"]] : "-");
				    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('AA' . $rec, trim($hasilPusat[1]) != "" ? $arrTLPusat[$hasilPusat[1]] : "-");
				    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('AB' . $rec, trim($hasilPusat[2]) != "" ? preg_replace('/(?:<|&lt;)\/?([a-zA-Z]+) *[^<\/]*?(?:>|&gt;)/', '', $hasilPusat[2]) : "-");
				    $this->newphpexcel->set_wrap(array('X' . $rec, 'Y' . $rec, 'Z' . $rec, 'AA' . $rec, 'AB' . $rec));
				    $no++;
				    $arrPenilaianBL = explode('#', $row1["PENILAIANBL"]);
				    if (trim($arrPenilaianBL[0]) != "") {
					$arrUraianBL = explode('^', $row1["URAIANBL"]);
					$intBL = 0;
					$int2BL = 0;
					$penilaianBL = array();
					$uraianBL = array();
					foreach ($arrPenilaianBL as $value) {
					    $arrValPenilaianBL = explode("_", $value);
					    if (trim($arrValPenilaianBL[0]) == "X" || trim($arrValPenilaianBL[0]) == "-") {
						if (!in_array($intBL, $nonTMK))
						    $penilaianBL[$intBL] = $arrValPenilaianBL[1] . " " . $arrSign[$arrValPenilaianBL[0]];
					    }
					    $intBL++;
					}
					foreach ($arrUraianBL as $value) {
					    $uraianBL[$int2BL] = $value;
					    $int2BL++;
					}
					$rec++;
					$mergeA++;
					$x = $rec - 1;
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('C' . $x, "Bungkus Luar");
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('E' . $x, trim($uraianBL[0]) != "" ? $uraianBL[0] : "-");
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('F' . $x, trim($uraianBL[1]) != "" ? $uraianBL[1] : "-");
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('G' . $x, trim($uraianBL[3]) != "" ? $uraianBL[3] : "-");
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('H' . $x, trim($uraianBL[4]) != "" ? $uraianBL[4] : "-");
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('I' . $x, trim($uraianBL[5]) != "" ? $uraianBL[5] : "-");
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('J' . $x, trim($uraianBL[6]) != "" ? $uraianBL[6] : "-");
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('L' . $x, trim($uraianBL[7]) != "" ? $uraianBL[7] : "-");
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('N' . $x, trim($uraianBL[9]) != "" ? $uraianBL[9] : "-");
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('O' . $x, trim($uraianBL[11]) != "" ? $uraianBL[11] : "-");
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('P' . $x, trim($uraianBL[12]) != "" ? $uraianBL[12] : "-");
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('Q' . $x, trim($uraianBL[10]) != "" ? $uraianBL[10] : "-");
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('R' . $x, trim($uraianBL[13]) != "" ? $uraianBL[13] : "-");
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('S' . $x, trim($uraianBL[14]) != "" ? $uraianBL[14] : "-");
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('T' . $x, trim($uraianBL[17]) != "" ? $uraianBL[17] : "-");
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('U' . $x, trim($uraianBL[15]) != "" ? $uraianBL[15] : "-");
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('V' . $x, trim($uraianBL[16]) != "" ? $uraianBL[16] : "-");
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('W' . $x, trim(join("", $penilaianBL)) != "" ? " - " . join("\n - ", $penilaianBL) : " - ");
					$this->newphpexcel->set_wrap(array('A' . $x, 'E' . $x, 'F' . $x, 'G' . $x, 'H' . $x, 'I' . $x, 'J' . $x, 'L' . $x, 'N' . $x, 'O' . $x, 'P' . $x, 'Q' . $x, 'R' . $x, 'S' . $x, 'T' . $x, 'U' . $x, 'V' . $x, 'W' . $x));
				    }
				    $arrPenilaianKP = explode('#', $row1["PENILAIANKP"]);
				    if (trim($arrPenilaianKP[0]) != "") {
					$arrUraianKP = explode('^', $row1["URAIANKP"]);
					$intKP = 0;
					$int2KP = 0;
					$penilaianKP = array();
					$uraianKP = array();
					foreach ($arrPenilaianKP as $value) {
					    $arrValPenilaianKP = explode("_", $value);
					    if (trim($arrValPenilaianKP[0]) == "X" || trim($arrValPenilaianKP[0]) == "-") {
						if (!in_array($intKP, $nonTMK))
						    $penilaianKP[$intKP] = $arrValPenilaianKP[1] . " " . $arrSign[$arrValPenilaianKP[0]];
					    }
					    $intKP++;
					}
					foreach ($arrUraianKP as $value) {
					    $uraianKP[$int2KP] = $value;
					    $int2KP++;
					}
					$rec++;
					$mergeA++;
					$x = $rec - 1;
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('C' . $x, "Kemasan Primer");
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('E' . $x, trim($uraianKP[0]) != "" ? $uraianKP[0] : "-");
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('F' . $x, trim($uraianKP[1]) != "" ? $uraianKP[1] : "-");
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('G' . $x, trim($uraianKP[3]) != "" ? $uraianKP[3] : "-");
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('H' . $x, trim($uraianKP[4]) != "" ? $uraianKP[4] : "-");
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('I' . $x, trim($uraianKP[5]) != "" ? $uraianKP[5] : "-");
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('J' . $x, trim($uraianKP[6]) != "" ? $uraianKP[6] : "-");
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('L' . $x, trim($uraianKP[7]) != "" ? $uraianKP[7] : "-");
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('N' . $x, trim($uraianKP[9]) != "" ? $uraianKP[9] : "-");
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('O' . $x, trim($uraianKP[11]) != "" ? $uraianKP[11] : "-");
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('P' . $x, trim($uraianKP[12]) != "" ? $uraianKP[12] : "-");
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('Q' . $x, trim($uraianKP[10]) != "" ? $uraianKP[10] : "-");
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('R' . $x, trim($uraianKP[13]) != "" ? $uraianKP[13] : "-");
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('S' . $x, trim($uraianKP[14]) != "" ? $uraianKP[14] : "-");
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('T' . $x, trim($uraianKP[17]) != "" ? $uraianKP[17] : "-");
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('U' . $x, trim($uraianKP[15]) != "" ? $uraianKP[15] : "-");
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('V' . $x, trim($uraianKP[16]) != "" ? $uraianKP[16] : "-");
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('W' . $x, trim(join("", $penilaianKP)) != "" ? " - " . join("\n - ", $penilaianKP) : " - ");
					$this->newphpexcel->set_wrap(array('A' . $x, 'E' . $x, 'F' . $x, 'G' . $x, 'H' . $x, 'I' . $x, 'J' . $x, 'L' . $x, 'N' . $x, 'O' . $x, 'P' . $x, 'Q' . $x, 'R' . $x, 'S' . $x, 'T' . $x, 'U' . $x, 'V' . $x, 'W' . $x));
				    }
				}
				if ($mergeA == 1) {
				    $ct = $rec - 2;
				    $ctt = 0;
				} else if ($rec - $mergeA == 7) {
				    $ct = $rec - $mergeA + 1;
				    $ctt = 1;
				} else {
				    $ct = $rec - $mergeA;
				    $ctt = 1;
				}
				$ct2 = $rec - 1;
				if ($ctt > 0 && $mergeA != 0)
				    $this->newphpexcel->mergeCell(array(array('A' . $ct, 'A' . $ct2), array('B' . $ct, 'B' . $ct2), array('D' . $ct, 'D' . $ct2), array('K' . $ct, 'K' . $ct2), array('X' . $ct, 'X' . $ct2), array('Y' . $ct, 'Y' . $ct2), array('Z' . $ct, 'Z' . $ct2), array('AA' . $ct, 'AA' . $ct2), array('AB' . $ct, 'AB' . $ct2)), FALSE);
				for ($i = $ct; $i <= $ct2; $i++) {
				    $this->newphpexcel->set_detilstyle(array('A' . $i, 'B' . $i, 'C' . $i, 'D' . $i, 'E' . $i, 'F' . $i, 'G' . $i, 'H' . $i, 'I' . $i, 'J' . $i, 'K' . $i, 'L' . $i, 'M' . $i, 'N' . $i, 'O' . $i, 'P' . $i, 'Q' . $i, 'R' . $i, 'S' . $i, 'T' . $i, 'U' . $i, 'V' . $i, 'W' . $i, 'X' . $i, 'Y' . $i, 'Z' . $i, 'AA' . $i, 'AB' . $i));
				}
				$mergeA = 0;
			    }
			} else {
			    $this->newphpexcel->getActiveSheet()->mergeCells('A8:Z8');
			    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A8', 'Data Pengawasan Penandaan Tidak Ditemukan');
			}
		    }
		} else {
		    $this->newphpexcel->getActiveSheet()->mergeCells('A8:Z8');
		    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A8', 'Data Pengawasan Penandaan Tidak Ditemukan');
		}
	    } else {
		$this->newphpexcel->mergecell(array(array('A6', 'A7'), array('B6', 'B7'), array('C6', 'C7'), array('D6', 'D7'), array('E6', 'E7'), array('F6', 'F7'), array('K6', 'K7'), array('L6', 'L7'), array('M6', 'M7'), array('N6', 'N7'), array('O6', 'O7'), array('P6', 'P7'), array('Q6', 'Q7'), array('R6', 'R7'), array('S6', 'S7'), array('T6', 'T7'), array('U6', 'U7'), array('V6', 'V7'), array('W6', 'W7'), array('Z6', 'AA6'), array('AB6', 'AB7'), array('AC6', 'AC7')), TRUE);
		$this->newphpexcel->set_bold(array('A1', 'A2', 'A3', 'A4'));
		$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A1', 'LAPORAN HASIL PENGAWASAN PENANDAAN OBAT TRADISIONAL')->setCellValue('A2', $judul)->setCellValue('A3', strtoupper($balai))->setCellValue('A4', 'PERIODE : ' . $awal . ' s.d ' . $akhir);
		$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A6', 'No')->setCellValue('B6', 'Nama Produk')->setCellValue('C6', 'Jenis Kemasan')->setCellValue('D6', 'Tanggal Pengawasan')->setCellValue('E6', 'No Bets')->setCellValue('F6', 'Netto')->setCellValue('G6', 'Nama Dan Alamat')->setCellValue('K6', 'NIE')->setCellValue('L6', 'Exp. Date')->setCellValue('M6', 'Komposisi')->setCellValue('N6', 'Cara Penggunaan')->setCellValue('O6', 'Klaim')->setCellValue('P6', 'Peringatan (Jika Ada)')->setCellValue('Q6', 'Cara Penyimpanan')->setCellValue('R6', 'Bentuk Sediaan')->setCellValue('S6', 'Bahasa Indonesia')->setCellValue('T6', 'Tercetak Langsung')->setCellValue('U6', 'Kemasan')->setCellValue('V6', 'Narasi')->setCellValue('W6', 'Keterangan')->setCellValue('X6', 'Kesimpulan')->setCellValue('Z6', 'Tindak Lanjut')->setCellValue('AB6', 'Justifikasi')->setCellValue('AC6', 'BBPOM')->setCellValue('G7', 'Produsen')->setCellValue('H7', 'Importir')->setCellValue('I7', 'Distributor')->setCellValue('J7', 'Pemberi Lisensi')->setCellValue('X7', 'Balai')->setCellValue('Y7', 'Pusat')->setCellValue('Z7', 'Balai')->setCellValue('AA7', 'Pusat');
		$this->newphpexcel->headings(array('A6', 'B6', 'C6', 'D6', 'E6', 'F6', 'G6', 'H6', 'I6', 'J6', 'K6', 'L6', 'M6', 'N6', 'O6', 'P6', 'Q6', 'R6', 'S6', 'T6', 'U6', 'V6', 'W6', 'X6', 'Y6', 'Z6', 'AA6', 'AB6', 'AC6'));
		$this->newphpexcel->headings(array('A7', 'B7', 'C7', 'D7', 'E7', 'F7', 'G7', 'H7', 'I7', 'J7', 'K7', 'L7', 'M7', 'N7', 'O7', 'P7', 'Q7', 'R7', 'S7', 'T7', 'U7', 'V7', 'W7', 'X7', 'Y7', 'Z7', 'AA7', 'AB7', 'AC7'));
		$this->newphpexcel->set_wrap(array('A6', 'B6', 'C6', 'D6', 'E6', 'F6', 'G6', 'H6', 'I6', 'J6', 'K6', 'L6', 'M6', 'N6', 'O6', 'P6', 'Q6', 'R6', 'S6', 'T6', 'U6', 'V6', 'W6', 'X6', 'Y7', 'Z6', 'AA6', 'AB6', 'AC6'));
		$this->newphpexcel->width(array(array('A', 4), array('B', 28), array('C', 20), array('D', 30), array('E', 20), array('F', 20), array('G', 30), array('H', 30), array('I', 30), array('J', 30), array('K', 30), array('L', 12), array('M', 30), array('N', 30), array('O', 30), array('P', 30), array('Q', 40), array('R', 30), array('S', 30), array('T', 30), array('U', 30), array('V', 30), array('W', 40), array('X', 10), array('Y', 10), array('Z', 20), array('AA', 20), array('AB', 40), array('AC', 30)));
		$this->newphpexcel->set_bold(array('A1', 'A2', 'A3', 'A4'));
		$arrSign = $this->config->item('array_sign_penilaian_iklan');
		$arrTLBalai = $this->config->item('tl_balai_penandaan_ot');
		$nonTMK = array(5, 6, 12);
		$data = $sipt->main->get_result($query);
		if ($data) {
		    $no = 1;
		    $rec = 8;
		    $mergeA = 1;
		    $i = 0;
		    foreach ($query->result_array() as $row) {
			if ($this->input->post('BUNGKUS') == "")
			    $mode = "ALL";
			else if ($this->input->post('BUNGKUS') != "")
			    $mode = "ONE";
			if ($this->input->post('HASIL') != "") {
			    $filterMKTMK = $this->input->post('HASIL');
			    $filterHasil = " AND (((TP.BBPOM_ID IN (" . "'" . join("','", $this->config->item('cfg_unit')) . "'" . ") OR TP.STATUS = 60510) AND TPK.PUSAT LIKE '%$filterMKTMK%') OR (TP.BBPOM_ID NOT IN (" . "'" . join("','", $this->config->item('cfg_unit')) . "'" . ") AND TP.STATUS <> 60510 AND TPK.SISTEM = '$filterMKTMK')) ";
			} else {
			    $filterHasil = "";
			}
			if ($mode == "ALL") {
			    $query1 = "SELECT TPK.PENILAIANBL, TPK.PENILAIANKP, TPK.URAIANBL, TPK.URAIANKP, TPK.PUSAT, TPK.SISTEM, TPK.TL_BALAI FROM T_PENANDAAN_PK_SM TPK LEFT JOIN T_PENANDAAN TP ON TP.PENANDAAN_ID = TPK.PENANDAAN_ID WHERE TP.PENANDAAN_ID = '" . $row['PENANDAAN_ID'] . "' $filterHasil";
			} else if ($mode == "ONE") {
			    $query1 = "SELECT TPK.PENILAIAN$filterQueryAs[1] AS PENILAIAN, TPK.URAIAN$filterQueryAs[1] AS URAIAN, TPK.PUSAT, TPK.SISTEM, TPK.TL_BALAI FROM T_PENANDAAN_OT TPK LEFT JOIN T_PENANDAAN TP ON TP.PENANDAAN_ID = TPK.PENANDAAN_ID WHERE TP.PENANDAAN_ID = '" . $row['PENANDAAN_ID'] . "' $filterHasil";
			}
			$data1 = $sipt->main->get_result($query1);
			if ($data1) {
			    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('B' . $rec, $row['NAMA_PRODUK'])->setCellValue('C' . $rec, $filterQueryAs[2])->setCellValue('D' . $rec, $row['TANGGAL_MULAI'] . " s/d " . $row['TANGGAL_AKHIR'])->setCellValue('K' . $rec, $row['NOMOR_IZIN_EDAR'])->setCellValue('M' . $rec, $row['KOMPOSISI'])->setCellValue('AC' . $rec, $row['BBPOM']);
			    $this->newphpexcel->set_wrap(array('B' . $rec, 'C' . $rec, 'D' . $rec, 'K' . $rec, 'M' . $rec, 'AC' . $rec));
			    foreach ($query1->result_array() as $row1) {
				if ($this->input->post('BUNGKUS') != "" && $mode == "ONE") {
				    $arrPenilaian = explode('#', $row1["PENILAIAN"]);
				    $arrUraian = explode('^', $row1["URAIAN"]);
				    $int = 0;
				    $int2 = 0;
				    $penilaian = array();
				    $uraian = array();
				    foreach ($arrPenilaian as $value) {
					$arrValPenilaian = explode("_", $value);
					if (trim($arrValPenilaian[0]) == "X" || trim($arrValPenilaian[0]) == "-") {
					    if (!in_array($int, $nonTMK))
						$penilaian[$int] = $arrValPenilaian[1] . " " . $arrSign[$arrValPenilaian[0]];
					}
					$int++;
				    }
				    foreach ($arrUraian as $value) {
					$uraian[$int2] = $value;
					$int2++;
				    }
				    $hasilPusat = explode("*", $row1["PUSAT"]);
				    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A' . $rec, $no);
				    $rec++;
				    $x = $rec - 1;
				    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('E' . $x, trim($uraian[0]) != "" ? $uraian[0] : "-");
				    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('F' . $x, trim($uraian[1]) != "" ? $uraian[1] : "-");
				    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('G' . $x, trim($uraian[3]) != "" ? $uraian[3] : "-");
				    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('H' . $x, trim($uraian[4]) != "" ? $uraian[4] : "-");
				    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('I' . $x, trim($uraian[5]) != "" ? $uraian[5] : "-");
				    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('J' . $x, trim($uraian[6]) != "" ? $uraian[6] : "-");
				    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('L' . $x, trim($uraian[7]) != "" ? $uraian[7] : "-");
				    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('N' . $x, trim($uraian[9]) != "" ? $uraian[9] : "-");
				    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('O' . $x, trim($uraian[11]) != "" ? $uraian[11] : "-");
				    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('P' . $x, trim($uraian[12]) != "" ? $uraian[12] : "-");
				    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('Q' . $x, trim($uraian[10]) != "" ? $uraian[10] : "-");
				    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('R' . $x, trim($uraian[13]) != "" ? $uraian[13] : "-");
				    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('S' . $x, trim($uraian[14]) != "" ? $uraian[14] : "-");
				    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('T' . $x, trim($uraian[17]) != "" ? $uraian[17] : "-");
				    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('U' . $x, trim($uraian[15]) != "" ? $uraian[15] : "-");
				    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('V' . $x, trim($uraian[16]) != "" ? $uraian[16] : "-");
				    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('W' . $x, trim(join("", $penilaian)) != "" ? " - " . join("\n - ", $penilaian) : " - ");
				    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('X' . $x, $row1["SISTEM"]);
				    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('Y' . $x, trim($hasilPusat[0]) != "" ? $hasilPusat[0] : "-");
				    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('Z' . $x, trim($row1["TL_BALAI"]) != "" ? $arrTLBalai[$row1["TL_BALAI"]] : "-");
				    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('AA' . $x, trim($hasilPusat[1]) != "" ? $arrTLPusat[$hasilPusat[1]] : "-");
				    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('AB' . $x, trim($hasilPusat[2]) != "" ? preg_replace('/(?:<|&lt;)\/?([a-zA-Z]+) *[^<\/]*?(?:>|&gt;)/', '', $hasilPusat[2]) : "-");
				    $no++;
				    $this->newphpexcel->set_wrap(array('A' . $x, 'E' . $x, 'F' . $x, 'G' . $x, 'H' . $x, 'I' . $x, 'J' . $x, 'L' . $x, 'N' . $x, 'O' . $x, 'P' . $x, 'Q' . $x, 'R' . $x, 'S' . $x, 'T' . $x, 'U' . $x, 'V' . $x, 'W' . $x, 'X' . $x, 'Y' . $x, 'Z' . $x, 'AA' . $x));
				} else {
				    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A' . $rec, $no);
				    $hasilPusat = explode("*", $row1["PUSAT"]);
				    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('X' . $rec, $row1["SISTEM"]);
				    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('Y' . $rec, trim($hasilPusat[0]) != "" ? $hasilPusat[0] : "-");
				    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('Z' . $rec, trim($row1["TL_BALAI"]) != "" ? $arrTLBalai[$row1["TL_BALAI"]] : "-");
				    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('AA' . $rec, trim($hasilPusat[1]) != "" ? $arrTLPusat[$hasilPusat[1]] : "-");
				    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('AB' . $rec, trim($hasilPusat[2]) != "" ? preg_replace('/(?:<|&lt;)\/?([a-zA-Z]+) *[^<\/]*?(?:>|&gt;)/', '', $hasilPusat[2]) : "-");
				    $this->newphpexcel->set_wrap(array('X' . $rec, 'Y' . $rec, 'Z' . $rec, 'AA' . $rec, 'AB' . $rec));
				    $no++;
				    $arrPenilaianBL = explode('#', $row1["PENILAIANBL"]);
				    if (trim($arrPenilaianBL[0]) != "") {
					$arrUraianBL = explode('^', $row1["URAIANBL"]);
					$intBL = 0;
					$int2BL = 0;
					$penilaianBL = array();
					$uraianBL = array();
					foreach ($arrPenilaianBL as $value) {
					    $arrValPenilaianBL = explode("_", $value);
					    if (trim($arrValPenilaianBL[0]) == "X" || trim($arrValPenilaianBL[0]) == "-") {
						if (!in_array($intBL, $nonTMK))
						    $penilaianBL[$intBL] = $arrValPenilaianBL[1] . " " . $arrSign[$arrValPenilaianBL[0]];
					    }
					    $intBL++;
					}
					foreach ($arrUraianBL as $value) {
					    $uraianBL[$int2BL] = $value;
					    $int2BL++;
					}
					$rec++;
					$mergeA++;
					$x = $rec - 1;
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('C' . $x, "Bungkus Luar");
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('E' . $x, trim($uraianBL[0]) != "" ? $uraianBL[0] : "-");
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('F' . $x, trim($uraianBL[1]) != "" ? $uraianBL[1] : "-");
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('G' . $x, trim($uraianBL[3]) != "" ? $uraianBL[3] : "-");
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('H' . $x, trim($uraianBL[4]) != "" ? $uraianBL[4] : "-");
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('I' . $x, trim($uraianBL[5]) != "" ? $uraianBL[5] : "-");
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('J' . $x, trim($uraianBL[6]) != "" ? $uraianBL[6] : "-");
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('L' . $x, trim($uraianBL[7]) != "" ? $uraianBL[7] : "-");
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('N' . $x, trim($uraianBL[9]) != "" ? $uraianBL[9] : "-");
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('O' . $x, trim($uraianBL[11]) != "" ? $uraianBL[11] : "-");
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('P' . $x, trim($uraianBL[12]) != "" ? $uraianBL[12] : "-");
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('Q' . $x, trim($uraianBL[10]) != "" ? $uraianBL[10] : "-");
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('R' . $x, trim($uraianBL[13]) != "" ? $uraianBL[13] : "-");
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('S' . $x, trim($uraianBL[14]) != "" ? $uraianBL[14] : "-");
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('T' . $x, trim($uraianBL[17]) != "" ? $uraianBL[17] : "-");
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('U' . $x, trim($uraianBL[15]) != "" ? $uraianBL[15] : "-");
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('V' . $x, trim($uraianBL[16]) != "" ? $uraianBL[16] : "-");
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('W' . $x, trim(join("", $penilaianBL)) != "" ? " - " . join("\n - ", $penilaianBL) : " - ");
					$this->newphpexcel->set_wrap(array('A' . $x, 'E' . $x, 'F' . $x, 'G' . $x, 'H' . $x, 'I' . $x, 'J' . $x, 'L' . $x, 'N' . $x, 'O' . $x, 'P' . $x, 'Q' . $x, 'R' . $x, 'S' . $x, 'T' . $x, 'U' . $x, 'V' . $x, 'W' . $x));
				    }
				    $arrPenilaianKP = explode('#', $row1["PENILAIANKP"]);
				    if (trim($arrPenilaianKP[0]) != "") {
					$arrUraianKP = explode('^', $row1["URAIANKP"]);
					$intKP = 0;
					$int2KP = 0;
					$penilaianKP = array();
					$uraianKP = array();
					foreach ($arrPenilaianKP as $value) {
					    $arrValPenilaianKP = explode("_", $value);
					    if (trim($arrValPenilaianKP[0]) == "X" || trim($arrValPenilaianKP[0]) == "-") {
						if (!in_array($intKP, $nonTMK))
						    $penilaianKP[$intKP] = $arrValPenilaianKP[1] . " " . $arrSign[$arrValPenilaianKP[0]];
					    }
					    $intKP++;
					}
					foreach ($arrUraianKP as $value) {
					    $uraianKP[$int2KP] = $value;
					    $int2KP++;
					}
					$rec++;
					$mergeA++;
					$x = $rec - 1;
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('C' . $x, "Kemasan Primer");
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('E' . $x, trim($uraianKP[0]) != "" ? $uraianKP[0] : "-");
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('F' . $x, trim($uraianKP[1]) != "" ? $uraianKP[1] : "-");
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('G' . $x, trim($uraianKP[3]) != "" ? $uraianKP[3] : "-");
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('H' . $x, trim($uraianKP[4]) != "" ? $uraianKP[4] : "-");
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('I' . $x, trim($uraianKP[5]) != "" ? $uraianKP[5] : "-");
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('J' . $x, trim($uraianKP[6]) != "" ? $uraianKP[6] : "-");
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('L' . $x, trim($uraianKP[7]) != "" ? $uraianKP[7] : "-");
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('N' . $x, trim($uraianKP[9]) != "" ? $uraianKP[9] : "-");
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('O' . $x, trim($uraianKP[11]) != "" ? $uraianKP[11] : "-");
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('P' . $x, trim($uraianKP[12]) != "" ? $uraianKP[12] : "-");
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('Q' . $x, trim($uraianKP[10]) != "" ? $uraianKP[10] : "-");
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('R' . $x, trim($uraianKP[13]) != "" ? $uraianKP[13] : "-");
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('S' . $x, trim($uraianKP[14]) != "" ? $uraianKP[14] : "-");
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('T' . $x, trim($uraianKP[17]) != "" ? $uraianKP[17] : "-");
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('U' . $x, trim($uraianKP[15]) != "" ? $uraianKP[15] : "-");
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('V' . $x, trim($uraianKP[16]) != "" ? $uraianKP[16] : "-");
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('W' . $x, trim(join("", $penilaianKP)) != "" ? " - " . join("\n - ", $penilaianKP) : " - ");
					$this->newphpexcel->set_wrap(array('A' . $x, 'E' . $x, 'F' . $x, 'G' . $x, 'H' . $x, 'I' . $x, 'J' . $x, 'L' . $x, 'N' . $x, 'O' . $x, 'P' . $x, 'Q' . $x, 'R' . $x, 'S' . $x, 'T' . $x, 'U' . $x, 'V' . $x, 'W' . $x));
				    }
				}
				if ($mergeA == 1) {
				    $ct = $rec - 2;
				    $ctt = 0;
				} else if ($rec - $mergeA == 7) {
				    $ct = $rec - $mergeA + 1;
				    $ctt = 1;
				} else {
				    $ct = $rec - $mergeA;
				    $ctt = 1;
				}
				$ct2 = $rec - 1;
				if ($ctt > 0 && $mergeA != 0)
				    $this->newphpexcel->mergeCell(array(array('A' . $ct, 'A' . $ct2), array('B' . $ct, 'B' . $ct2), array('D' . $ct, 'D' . $ct2), array('K' . $ct, 'K' . $ct2), array('X' . $ct, 'X' . $ct2), array('Y' . $ct, 'Y' . $ct2), array('Z' . $ct, 'Z' . $ct2), array('AA' . $ct, 'AA' . $ct2), array('AB' . $ct, 'AB' . $ct2), array('AC' . $ct, 'AC' . $ct2)), FALSE);
				for ($i = $ct; $i <= $ct2; $i++) {
				    $this->newphpexcel->set_detilstyle(array('A' . $i, 'B' . $i, 'C' . $i, 'D' . $i, 'E' . $i, 'F' . $i, 'G' . $i, 'H' . $i, 'I' . $i, 'J' . $i, 'K' . $i, 'L' . $i, 'M' . $i, 'N' . $i, 'O' . $i, 'P' . $i, 'Q' . $i, 'R' . $i, 'S' . $i, 'T' . $i, 'U' . $i, 'V' . $i, 'W' . $i, 'X' . $i, 'Y' . $i, 'Z' . $i, 'AA' . $i, 'AB' . $i, 'AC' . $i));
				}
				$mergeA = 0;
			    }
			} else {
			    $this->newphpexcel->getActiveSheet()->mergeCells('A8:AA8');
			    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A8', 'Data Pengawasan Penandaan Tidak Ditemukan');
			}
		    }
		} else {
		    $this->newphpexcel->getActiveSheet()->mergeCells('A8:AA8');
		    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A8', 'Data Pengawasan Penandaan Tidak Ditemukan');
		}
	    }
	    ob_clean();
	    $file = "LAPORAN_PENGAWASAN_PENANDAAN_" . str_replace(" ", "_", str_replace("-", "", $judul)) . "_" . date("YmdHis") . ".xls";
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

    function RHPK() {
	if ($this->newsession->userdata('LOGGED_IN') == TRUE) {
	    $sipt = & get_instance();
	    $this->load->model("main", "main", true);
	    $this->load->library('newphpexcel');
	    $judul = strtoupper($sipt->main->get_uraian("SELECT dbo.NAMA_JENIS_SARANA('" . $this->input->post('JENIS') . "') AS JUDUL", "JUDUL"));
	    $filter2 = "";
	    if (trim($this->input->post('AWAL') != "")) {
		$filter2 .= " DATEDIFF(dy, 0, convert(DATETIME, TP.TANGGAL_MULAI, 105)) >= DATEDIFF(dy, 0, convert(DATETIME, '" . $this->input->post('AWAL') . "', 105))";
		$awal = $this->input->post('AWAL');
	    } else {
		$filter2 .= " TP.TANGGAL_MULAI > GETDATE()";
		$awal = date('01/m/Y');
	    }
	    if (trim($this->input->post('AKHIR') != "")) {
		$filter2 .= " AND DATEDIFF(dy, 0, convert(DATETIME, TP.TANGGAL_MULAI, 105)) <= DATEDIFF(dy, 0, convert(DATETIME, '" . $this->input->post('AKHIR') . "', 105))";
		$akhir = $this->input->post('AKHIR');
	    } else {
		$filter2 .= " AND TP.TANGGAL_AKHIR < GETDATE()";
		$akhir = date('t/m/Y');
	    }
	    if (in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')) || $this->newsession->userdata('SESS_BBPOM_ID') == "00") {
		if (trim($this->input->post('BBPOM_ID')) == "") {
		    $filter2 .= "";
		    $balai = 'Seluruh Balai';
		} else {
		    $filter2 .= " AND TP.BBPOM_ID = '" . $this->input->post('BBPOM_ID') . "'";
		    $balai = $sipt->main->get_uraian("SELECT NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID = '" . $this->input->post('BBPOM_ID') . "'", "NAMA_BBPOM");
		}
	    } else {
		$filter2 .= " AND TP.BBPOM_ID = '" . $this->newsession->userdata('SESS_BBPOM_ID') . "'";
		$balai = $sipt->main->get_uraian("SELECT NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID = '" . $this->newsession->userdata('SESS_BBPOM_ID') . "'", "NAMA_BBPOM");
	    }
	    $query = "SELECT DISTINCT (REPLACE(REPLACE(MB.NAMA_BBPOM,'BALAI BESAR POM DI ', ''),'BALAI POM DI ','')) AS NAMA_BBPOM,dbo.GET_KOMODITI(TP.KOMODITI) AS KOMODITI,(SUM(CASE WHEN (TPP.PUSAT LIKE '%TMK*%' AND (TP.BBPOM_ID = 92 OR TP.STATUS = 60510)) THEN 1 ELSE 0 END)) AS TMK_P,(SUM(CASE WHEN (TPP.PUSAT LIKE 'MK*%' AND (TP.BBPOM_ID = 92 OR TP.STATUS = 60510)) THEN 1 ELSE 0 END)) AS MK_P,(SUM(CASE WHEN (TPP.SISTEM = 'TMK' AND TP.BBPOM_ID <> 92 AND TP.STATUS <> 60510) THEN 1 ELSE 0 END)) AS TMK_B,(SUM(CASE WHEN (TPP.SISTEM = 'MK' AND TP.BBPOM_ID <> 92 AND TP.STATUS <> 60510) THEN 1 ELSE 0 END)) AS MK_B,(SUM(CASE WHEN TPP.PUSAT LIKE '%*0%' THEN 1 ELSE 0 END)) AS 'PERINGATAN1',(SUM(CASE WHEN TPP.PUSAT LIKE '%*1%' THEN 1 ELSE 0 END)) AS 'PERINGATAN2',(SUM(CASE WHEN TPP.PUSAT LIKE '%*2%' THEN 1 ELSE 0 END)) AS 'KERAS',(SUM(CASE WHEN TPP.PUSAT LIKE '%*3%' THEN 1 ELSE 0 END)) AS 'HENTI',(SUM(CASE WHEN TPP.PUSAT LIKE '%*4%' THEN 1 ELSE 0 END)) AS 'BATAL',(SUM(CASE WHEN TPP.TL_BALAI = '0' THEN 1 ELSE 0 END)) AS 'PERINGATANB',(SUM(CASE WHEN TPP.TL_BALAI = '1' THEN 1 ELSE 0 END)) AS 'MUSNAH' FROM T_PENANDAAN TP LEFT JOIN T_PENANDAAN_PK_SM TPP ON TPP.PENANDAAN_ID = TP.PENANDAAN_ID LEFT JOIN M_BBPOM MB ON TP.BBPOM_ID = MB.BBPOM_ID WHERE $filter2 AND TP.KOMODITI = '011' GROUP BY  MB.BBPOM_ID, MB.NAMA_BBPOM, TP.KOMODITI ORDER BY 1";
	    $this->newphpexcel->set_font('Calibri', 10);
	    $this->newphpexcel->setActiveSheetIndex(0);
	    $this->newphpexcel->set_title('RHPK Pengawasan Pengawasan');
	    $this->newphpexcel->mergecell(array(array('A1', 'F1'), array('A2', 'F2'), array('A3', 'F3'), array('A4', 'F4'), array('C6', 'E6'), array('F6', 'G6'), array('H6', 'L6')), TRUE);
	    $this->newphpexcel->mergecell(array(array('B6', 'B7'), array('A6', 'A7')), FALSE);
	    $this->newphpexcel->width(array(array('A', 4), array('B', 35), array('C', 11), array('D', 11), array('E', 11), array('F', 15), array('G', 25), array('H', 15), array('I', 15), array('J', 15), array('K', 25), array('L', 25)));
	    $this->newphpexcel->set_bold(array('A1', 'A2', 'A3', 'A4'));
	    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A1', 'REKAPITULASI HASIL PELAKSANAAN KEGIATAN - PENGAWASAN PENANDAAN - SUPLEMEN MAKANAN')->setCellValue('A2', $judul)->setCellValue('A3', strtoupper($balai))->setCellValue('A4', 'PERIODE : ' . $awal . ' s.d ' . $akhir);
	    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A6', 'No.')->setCellValue('B6', 'BBPOM')->setCellValue('C6', 'Total')->setCellValue('F6', 'Tindak Lanjut Balai')->setCellValue('H6', 'Tindak Lanjut Pusat')->setCellValue('C7', 'Diperiksa')->setCellValue('D7', 'MK')->setCellValue('E7', 'TMK')->setCellValue('F7', 'Peringatan')->setCellValue('G7', 'Pemusnahan')->setCellValue('H7', 'Peringatan 1')->setCellValue('I7', 'Peringatan 2')->setCellValue('J7', 'Peringatan Keras')->setCellValue('K7', 'Penghentian Sementara Kegiatan')->setCellValue('L7', 'Pembatalan Nomor Izin Edar');
	    $this->newphpexcel->headings(array('A6', 'B6', 'C6', 'D6', 'E6', 'F6', 'G6', 'H6', 'I6', 'J6', 'K6', 'L6'));
	    $this->newphpexcel->headings(array('A7', 'B7', 'C7', 'D7', 'E7', 'F7', 'G7', 'H7', 'I7', 'J7', 'K7', 'L7'));
	    $this->newphpexcel->set_wrap(array('B6', 'F7', 'G7', 'H7', 'I7', 'J7', 'K7', 'L7'));
	    $this->newphpexcel->getActiveSheet()->getStyle('G')->getAlignment()->setWrapText(true);
	    $data = $sipt->main->get_result($query);
	    if ($data) {
		$no = 1;
		$rec = 8;
		foreach ($query->result_array() as $row) {
		    $total = $row['MK_P'] + $row['MK_B'] + $row['TMK_P'] + $row['TMK_B'];
		    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A' . $rec, $no)->setCellValue('B' . $rec, $row["NAMA_BBPOM"])->setCellValue('C' . $rec, $total)->setCellValue('D' . $rec, $row["MK_P"] + $row["MK_B"])->setCellValue('E' . $rec, $row["TMK_P"] + $row["TMK_B"])->setCellValue('F' . $rec, $row["PERINGATANB"])->setCellValue('G' . $rec, $row["MUSNAH"])->setCellValue('H' . $rec, $row["PERINGATAN1"])->setCellValue('I' . $rec, $row["PERINGATAN2"])->setCellValue('J' . $rec, $row["KERAS"])->setCellValue('K' . $rec, $row["HENTI"])->setCellValue('L' . $rec, $row["BATAL"]);
		    $this->newphpexcel->set_detilstyle(array('A' . $rec, 'B' . $rec, 'C' . $rec, 'D' . $rec, 'E' . $rec, 'F' . $rec, 'G' . $rec, 'H' . $rec, 'I' . $rec, 'J' . $rec, 'K' . $rec, 'L' . $rec));
		    $this->newphpexcel->getActiveSheet()->getStyle('G' . $rec)->getAlignment()->setWrapText(true);
		    $rec++;
		    $no++;
		}
	    } else {
		$this->newphpexcel->getActiveSheet()->mergeCells('A8:L8');
		$this->newphpexcel->set_detilstyle(array('A8'));
		$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A8', 'Data Pengawasan Penandaan Tidak Ditemukan');
	    }
	    ob_clean();
	    $file = "REKAPITULASI_PENGAWASAN_PENANDAAN_" . str_replace(" ", "_", str_replace("-", "", $judul)) . "_" . date("YmdHis") . ".xls";
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