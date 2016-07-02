<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
error_reporting(E_ERROR);

class _013M extends Model {

    function getFormPenandaan($klasifikasi, $jenis) {
	if ($this->newsession->userdata('LOGGED_IN') == TRUE) {
	    $sipt = & get_instance();
	    $this->load->model("main", "main", true);
	    $kodeProvinsi = substr($this->newsession->userdata('SESS_PROP_ID'), 0, 2);
	    $detailProvinsiDef = $sipt->main->combobox("SELECT PROPINSI_ID, NAMA_PROPINSI FROM M_PROPINSI WHERE LEFT(PROPINSI_ID, 2) = '" . $kodeProvinsi . "' AND RIGHT(PROPINSI_ID, 2) != '00'", "NAMA_PROPINSI", "NAMA_PROPINSI", TRUE);
	    $provinsi = $sipt->main->combobox("SELECT PROPINSI_ID, NAMA_PROPINSI FROM M_PROPINSI WHERE LEFT(PROPINSI_ID, 1) <= '9' AND RIGHT(PROPINSI_ID, 2) = '00' AND LEFT(PROPINSI_ID, 2) = '" . $kodeProvinsi . "'", "PROPINSI_ID", "NAMA_PROPINSI");
	    $arrdata = array('provinsi' => $provinsi, 'kabupaten' => $detailProvinsiDef, 'act' => site_url() . '/penandaan/penandaanController/setFormPenandaanLanjutan/pengawasan/' . $klasifikasi, 'batal' => site_url() . '/penandaan/penandaanController/getFormPenandaanLanjutan/' . $klasifikasi, 'histori_petugas' => site_url() . '/load/petugas/get_petugas_2/');
	    $arrdata['obj_distribusi'] = 'PENANDAANPANGAN';
	    $arrdata['editTL'] = 'YES';
	    if ($jenis == "IRT")
		$arrdata ['cb_tl'] = $this->config->item("tl_pusat_penandaan_pangan_irt");
	    else
		$arrdata ['cb_tl'] = $this->config->item("tl_pusat_penandaan_pangan_mdml");
	    $arrdata ['cb_tindakan_balai'] = $this->config->item("tl_balai_penandaan_pangan");
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
	$arrChk = $this->input->post('CHK');
	$arrUrn = $this->input->post('URN');
	for ($i = 1; $i <= count($arrChk); $i++) {
	    $arrChkVal[$i] = $arrChk[$i];
	}
	$arr_penandaan_Pangan = join("#", $arrChkVal);
	for ($i = 1; $i <= count($arrUrn); $i++) {
	    $arrUrnVal[$i] = $arrUrn[$i];
	}
	$arr_penandaan_URN = join("^", $arrUrnVal);
	$tie = isset($arr_produk['TIE']) && $arr_produk['TIE'] ? "1" : "0";
	$lampiran = $this->input->post('PENANDAAN_PANGAN');
	$arr_petugas = $this->session->userdata('USER');
	$suratTugas = $this->session->userdata('SURAT');
	$suratId = (int) $sipt->main->get_uraian("SELECT MAX(SURAT_ID) AS MAXID FROM T_SURAT_TUGAS_PENANDAAN", "MAXID") + 1;
	$tanggalSurat = $this->session->userdata('TANGGAL');
	$hasilSistem = $this->input->post('HASIL');
	$justifikasi = "";
	if ($arr_penandaan['HASIL_PUSAT'] != $hasilSistem)
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
	    $produk = array('PENANDAAN_ID' => $penandaan_id, 'NAMA_PRODUK' => $arr_produk['NAMA_PRODUK'], 'NOMOR_IZIN_EDAR' => $arr_produk['NIE'], 'MERK_PRODUK' => $arr_produk['MERK_PRODUK'], 'BESAR_KEMASAN' => $arr_produk['BESAR_KEMASAN'], 'PRODUSEN' => $arr_produk['PRODUSEN'], 'IMPORTIR' => $arr_produk['IMPORTIR'], 'GOLONGAN_PRODUK' => $arr_produk['GOLONGAN_PRODUK'], 'ALAMAT_PRODUSEN' => $arr_produk['ALAMAT_PRODUSEN'], 'ALAMAT_IMPORTIR' => $arr_produk['ALAMAT_IMPORTIR'], 'TIE' => $tie);
	}
	$this->db->insert('T_PENANDAAN_PRODUK', $produk);
	if ($this->db->affected_rows() > 0) {
	    $penandaanPangan = array('PENANDAAN_ID' => $penandaan_id, 'PENILAIAN' => $arr_penandaan_Pangan, 'URAIAN' => $arr_penandaan_URN, 'LAMPIRAN' => $lampiran['FILE_PENANDAAN_PANGAN'], 'SISTEM' => $hasilSistem, 'PUSAT' => $hasilPusat, "TL_BALAI" => $arr_penandaan["TL_BALAI"], 'JENIS' => $this->input->post("JENIS"), 'JENIS_PENGAWASAN' => $this->input->post("JENIS_PENGAWASAN"));
	}
	$this->db->insert('T_PENANDAAN_PANGAN', $penandaanPangan);
	if ($this->db->affected_rows() > 0) {
	    $case = 'YESPENANDAANPANGAN';
	} else {
	    $case = 'NO';
	}
	if ($case == 'YESPENANDAANPANGAN') {
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
	$arrChk = $this->input->post('CHK');
	$arrUrn = $this->input->post('URN');
	for ($i = 1; $i <= count($arrChk); $i++) {
	    $arrChkVal[$i] = $arrChk[$i];
	}
	$arr_penandaan_Pangan = join("#", $arrChkVal);
	for ($i = 1; $i <= count($arrUrn); $i++) {
	    $arrUrnVal[$i] = $arrUrn[$i];
	}
	$arr_penandaan_URN = join("^", $arrUrnVal);
	$tie = isset($arr_produk['TIE']) && $arr_produk['TIE'] ? "1" : "0";
	$lampiran = $this->input->post('PENANDAAN_PANGAN');
	$hasilSistem = $this->input->post('HASIL');
	$justifikasi = "";
	$statusUPD = array();
	$saranaUPD = array();
	if ($arr_penandaan['HASIL_PUSAT'] != $hasilSistem)
	    $justifikasi = $this->input->post('JUSTIFIKASI');
	else
	    $justifikasi = "";
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
		$saranaUPD = array('TANGGAL_MULAI' => $arr_penandaan['TANGGALAWAL'], 'TANGGAL_AKHIR' => $arr_penandaan['TANGGALAKHIR'], 'SARANA_ID' => $arr_penandaan['SARANAID'], 'KOMODITI' => '013');
	    }
	    $penandaan = array_merge($statusUPD, $saranaUPD, array('USER_LAST_UPDATE' => $this->newsession->userdata('SESS_USER_ID'), 'LAST_UPDATE' => 'GETDATE()'));
	    $this->db->where(array("PENANDAAN_ID" => $penandaan_id, "SERI" => $seri - 1));
	    $this->db->update('T_PENANDAAN_PROSES', $arr_update_log);
	    $this->db->where(array("PENANDAAN_ID" => $penandaan_id));
	    $this->db->update('T_PENANDAAN', $penandaan);
	    if (!empty($arr_produk)) {
		$produk = array('PENANDAAN_ID' => $penandaan_id, 'NAMA_PRODUK' => $arr_produk['NAMA_PRODUK'], 'NOMOR_IZIN_EDAR' => $arr_produk['NIE'], 'MERK_PRODUK' => $arr_produk['MERK_PRODUK'], 'BESAR_KEMASAN' => $arr_produk['BESAR_KEMASAN'], 'PRODUSEN' => $arr_produk['PRODUSEN'], 'IMPORTIR' => $arr_produk['IMPORTIR'], 'GOLONGAN_PRODUK' => $arr_produk['GOLONGAN_PRODUK'], 'ALAMAT_PRODUSEN' => $arr_produk['ALAMAT_PRODUSEN'], 'ALAMAT_IMPORTIR' => $arr_produk['ALAMAT_IMPORTIR'], 'TIE' => $tie);
		$this->db->where(array("PENANDAAN_ID" => $penandaan_id));
		$this->db->update('T_PENANDAAN_PRODUK', $produk);
	    }
	    if (!in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) {
		$penandaanPangan = array('PENILAIAN' => $arr_penandaan_Pangan, 'URAIAN' => $arr_penandaan_URN, 'LAMPIRAN' => $lampiran['FILE_PENANDAAN_PANGAN'], 'SISTEM' => $hasilSistem, 'PUSAT' => $hasilPusat, "TL_BALAI" => $arr_penandaan["TL_BALAI"], 'JENIS' => $this->input->post("JENIS"), 'JENIS_PENGAWASAN' => $this->input->post("JENIS_PENGAWASAN"));
	    } else {
		if (!empty($arr_penandaan_Pangan))
		    $penandaanPangan = array('PENILAIAN' => $arr_penandaan_Pangan, 'URAIAN' => $arr_penandaan_URN, 'LAMPIRAN' => $lampiran['FILE_PENANDAAN_PANGAN'], 'SISTEM' => $hasilSistem, 'PUSAT' => $hasilPusat, 'JENIS' => $this->input->post("JENIS"), 'JENIS_PENGAWASAN' => $this->input->post("JENIS_PENGAWASAN"));
		else
		    $penandaanPangan = array('PUSAT' => $hasilPusat);
	    }
	    $this->db->where(array("PENANDAAN_ID" => $penandaan_id));
	    $this->db->update('T_PENANDAAN_PANGAN', $penandaanPangan);
	    $case = 'YESPENANDAANPANGAN';
	}
	if ($case == 'YESPENANDAANPANGAN') {
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
	$query = "SELECT TPPN.URAIAN, TPPN.PENILAIAN, TP.PENANDAAN_ID, TPPN.PUSAT, CONVERT(VARCHAR(10), TP.TANGGAL_MULAI, 120) AS TANGGAL_MULAI, CONVERT(VARCHAR(10), TP.TANGGAL_AKHIR, 120) AS TANGGAL_AKHIR, TP.SURAT_ID, TP.STATUS FROM T_PENANDAAN TP RIGHT JOIN T_PENANDAAN_PANGAN TPPN ON TPPN.PENANDAAN_ID = TP.PENANDAAN_ID WHERE TPPN.PENANDAAN_ID = '" . $idPengawasan . "'";
	$data = $sipt->main->get_result($query);
	if ($data) {
	    foreach ($query->result_array() as $row) {
		$arrdata = array('sess' => $row, 'judul' => 'Pangan');
	    }
	    if ($row['STATUS'] == '20302' || $row['STATUS'] == '20312') {
		$arrdata['act'] = site_url() . '/penandaan/penandaanController/prosesEdit/edit/' . $row['PENANDAAN_ID'] . '/' . $row['STATUS'] . '/013/' . $jenisPelaporan;
		$arrdata['tombol'] = 'Lihat Data Perbaikan Pengawasan';
	    } else {
		$arrdata['act'] = site_url() . '/penandaan/penandaanController/prosesPreview/preview/' . $row['PENANDAAN_ID'] . '/' . $row['STATUS'] . '/013/' . $jenisPelaporan;
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
	$isEditTLPusat = "NO";
	$urlId = explode('/', $_SERVER['PATH_INFO']);
	if ($urlId[3] == 'prosesEdit' && ((in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')) && in_array($bbpom, $this->config->item('cfg_unit'))) || (!in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')) && !in_array($bbpom, $this->config->item('cfg_unit')))))
	    $tglQuery = "TP.TANGGAL_MULAI, 103) AS TANGGAL_MULAI, CONVERT(VARCHAR(10), TP.TANGGAL_AKHIR, 103) AS TANGGAL_AKHIR";
	else
	    $tglQuery = "TP.TANGGAL_MULAI, 120) AS TANGGAL_MULAI, CONVERT(VARCHAR(10), TP.TANGGAL_AKHIR, 120) AS TANGGAL_AKHIR";
	$query = "SELECT TSTP.SURAT_ID, TPPN.PENILAIAN, TPPN.URAIAN, TPPN.LAMPIRAN, TPPN.SISTEM, TPPN.PUSAT, TPPN.TL_BALAI, TPPN.JENIS, TPPN.JENIS_PENGAWASAN, TP.PENANDAAN_ID, CONVERT(VARCHAR(10), " . $tglQuery . ", TP.STATUS, TP.KOMODITI, TP.SARANA_ID, TP.BBPOM_ID, TPP.NAMA_PRODUK, TPP.MERK_PRODUK, TPP.BENTUK_SEDIAAN, TPP.BESAR_KEMASAN, TPP.KOMPOSISI, TPP.PRODUSEN, TPP.ALAMAT_PRODUSEN, TPP.PENDAFTAR, TPP.ALAMAT_PENDAFTAR, TPP.NOMOR_IZIN_EDAR, TPP.GOLONGAN_PRODUK, TPP.NOMOR_PRODUK, TPP.IMPORTIR, TPP.LISENSI, TPP.PENGEMAS, TPP.ALAMAT_IMPORTIR, TPP.ALAMAT_LISENSI, TPP.ALAMAT_PENGEMAS, TPP.TIE, MS.NAMA_SARANA, MS.ALAMAT_1, (SELECT MP1.NAMA_PROPINSI FROM M_PROPINSI MP1 WHERE MP1.PROPINSI_ID = MS.PROPINSI) AS PROPINSI, (SELECT MP2.NAMA_PROPINSI FROM M_PROPINSI MP2 WHERE MP2.PROPINSI_ID = MS.KOTA) AS KOTA FROM T_PENANDAAN TP RIGHT JOIN T_PENANDAAN_PANGAN TPPN ON TPPN.PENANDAAN_ID = TP.PENANDAAN_ID RIGHT JOIN T_PENANDAAN_PRODUK TPP ON TPP.PENANDAAN_ID = TP.PENANDAAN_ID RIGHT JOIN T_SURAT_TUGAS_PENANDAAN TSTP ON TSTP.SURAT_ID = TP.SURAT_ID RIGHT JOIN M_SARANA MS ON MS.SARANA_ID = TP.SARANA_ID WHERE TP.PENANDAAN_ID = '" . $penandaanId . "'";
	$data = $sipt->main->get_result($query);
	if ($data) {
	    foreach ($query->result_array() as $row) {
		$arrdata = array('sess' => $row, 'judul' => 'Pangan');
	    }
	    $arrdata['histori_petugas'] = site_url() . '/load/petugas/get_petugas_2/' . $row['SURAT_ID'] . '/T_SURAT_TUGAS_PENANDAAN';
	}
	if (array_key_exists('2', $this->newsession->userdata('SESS_KODE_ROLE')) && ($subid == '0101' || $subid == '1101') && $arrdata['sess']['BBPOM_ID'] && $jenis != 'preview')
	    $isEditTLPusat = "YES";
	else if ($subid == '1111')
	    $isEditTLPusat = "YES";
	if (in_array('2', $this->newsession->userdata('SESS_KODE_ROLE')) && $user == '2') {
	    $arrayClause = array('20501', '20502', '20503', '20511', '20515', '20512');
	} else if (in_array('3', $this->newsession->userdata('SESS_KODE_ROLE')) && $user == '3') {
	    $arrayClause = array('30501', '30502', '30503', '30504', '30511', '30512', '30513', '30514');
	} else if (in_array('4', $this->newsession->userdata('SESS_KODE_ROLE')) && $user == '4') {
	    $arrayClause = array('40501', '40502', '40503', '40511', '40512', '40513');
	} else if (in_array('5', $this->newsession->userdata('SESS_KODE_ROLE')) && $user == '5') {
	    $arrayClause = array('50501');
	} else if (in_array('6', $this->newsession->userdata('SESS_KODE_ROLE')) && $user == '6') {
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
	    $arrdata ['subJudul'] = '- PANGAN';
	}
	else
	    $arrdata ['act'] = site_url() . "/penandaan/penandaanController/setStatus/1";
	$arrdata ['status'] = $sipt->main->set_verifikasi($status, $this->newsession->userdata('SESS_JENIS_PELAPORAN'), $this->newsession->userdata('SESS_KODE_ROLE'));
	$arrdata ['disverifikasi'] = $status;
	$arrdata ['objStatus'] = 'TO';
	$arrdata ['cancel'] = site_url() . '/penandaan/penandaanController/setListFormPenandaanLanjutan/' . $user;
	$arrdata ['labelSimpan'] = 'Proses Data Perbaikan Pengawasan';
	$arrdata ['icon'] = 'check';
	$arrdata ['editTL'] = $isEditTLPusat;
	$arrdata['tujuan'] = $user;
	if (($subid == '1101' || $subid == '0101') && $jenis != 'preview') {
	    $arrdata ['subJudul'] = '- PANGAN EDIT';
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
	if ($arrdata['sess']["JENIS"] == "IRT")
	    $arrdata ['cb_tl'] = $this->config->item("tl_pusat_penandaan_pangan_irt");
	else
	    $arrdata ['cb_tl'] = $this->config->item("tl_pusat_penandaan_pangan_mdml");
	$arrdata ['cb_tindakan_balai'] = $this->config->item("tl_balai_penandaan_pangan");
	if (!in_array($arrdata ['sess']['STATUS'], $arrayClause)) {
	    if ($status != '60510' && ($subid == '1101' || $subid == '0101' || $subid == '0111' || $subid == '1221' || $subid == '1111' || $subid == '1222' || $subid == '0303' || $subid == '0313' || $subid == '0404')) {
		redirect('/penandaan/penandaanController/setListFormPenandaanLanjutan/' . $subid . '/' . $user);
		exit();
	    }
	}
	return $arrdata;
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
		$filter1 .= " AND DATEDIFF(dy, 0, convert(DATETIME, TP.TANGGAL_MULAI, 105)) >= DATEDIFF(dy, 0, convert(DATETIME, '" . $this->input->post('AWAL') . "', 105))";
		$filter2 .= " DATEDIFF(dy, 0, convert(DATETIME, TP.TANGGAL_MULAI, 105)) >= DATEDIFF(dy, 0, convert(DATETIME, '" . $this->input->post('AWAL') . "', 105))";
		$fawal = "DATEDIFF(dy, 0, convert(DATETIME, '" . $this->input->post('AWAL') . "', 105))";
		$awal = $this->input->post('AWAL');
	    } else {
		$filter1 .= " AND TP.TANGGAL_MULAI > GETDATE()";
		$filter2 .= " TP.TANGGAL_MULAI> GETDATE()";
		$fawal = "DATEADD(M, DATEDIFF(M,0,GETDATE()),0)";
		$awal = date('01/m/Y');
	    }
	    if (trim($this->input->post('AKHIR') != "")) {
		$filter1 .= " AND DATEDIFF(dy, 0, convert(DATETIME, TP.TANGGAL_MULAI, 105)) <= DATEDIFF(dy, 0, convert(DATETIME, '" . $this->input->post('AKHIR') . "', 105))";
		$filter2 .= " AND DATEDIFF(dy, 0, convert(DATETIME, TP.TANGGAL_MULAI, 105)) <= DATEDIFF(dy, 0, convert(DATETIME, '" . $this->input->post('AKHIR') . "', 105))";
		$fakhir = "DATEDIFF(dy, 0, convert(DATETIME, '" . $this->input->post('AKHIR') . "', 105))";
		$akhir = $this->input->post('AKHIR');
	    } else {
		$filter1 .= " AND TP.TANGGAL_AKHIR < GETDATE()";
		$filter2 .= " AND TP.TANGGAL_AKHIR < GETDATE()";
		$fakhir = "DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,0,GETDATE())+1,0))";
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