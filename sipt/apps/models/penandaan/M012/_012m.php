<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
error_reporting(E_ERROR);

class _012M extends Model {

    function getFormPenandaan($klasifikasi = '') {
	if ($this->newsession->userdata('LOGGED_IN') == TRUE) {
	    $sipt = & get_instance();
	    $this->load->model("main", "main", true);
	    $kodeProvinsi = substr($this->newsession->userdata('SESS_PROP_ID'), 0, 2);
	    $detailProvinsiDef = $sipt->main->combobox("SELECT PROPINSI_ID, NAMA_PROPINSI FROM M_PROPINSI WHERE LEFT(PROPINSI_ID, 2) = '" . $kodeProvinsi . "' AND RIGHT(PROPINSI_ID, 2) != '00'", "NAMA_PROPINSI", "NAMA_PROPINSI", TRUE);
	    $provinsi = $sipt->main->combobox("SELECT PROPINSI_ID, NAMA_PROPINSI FROM M_PROPINSI WHERE LEFT(PROPINSI_ID, 1) <= '9' AND RIGHT(PROPINSI_ID, 2) = '00' AND LEFT(PROPINSI_ID, 2) = '" . $kodeProvinsi . "'", "PROPINSI_ID", "NAMA_PROPINSI");
	    $arrdata = array('provinsi' => $provinsi, 'kabupaten' => $detailProvinsiDef, 'act' => site_url() . '/penandaan/penandaanController/setFormPenandaanLanjutan/pengawasan/' . $klasifikasi, 'batal' => site_url() . '/penandaan/penandaanController/getFormPenandaanLanjutan/' . $klasifikasi, 'histori_petugas' => site_url() . '/load/petugas/get_petugas_2/');
	    $arrdata ['cb_tindakan'] = $this->config->item('tl_pusat_penandaan_kos');
	    $arrdata ['cb_tindakan_balai'] = $this->config->item('tl_balai_penandaan_kos');
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
	$arr_penandaan_KOS = join("#", $this->input->post('CHK'));
	$arr_penandaan_URN = join("^", $this->input->post('URN'));
	$lampiran = join("^", $this->input->post('PENANDAAN_KOS'));
	$arr_petugas = $this->session->userdata('USER');
	$suratTugas = $this->session->userdata('SURAT');
	$suratId = (int) $sipt->main->get_uraian("SELECT MAX(SURAT_ID) AS MAXID FROM T_SURAT_TUGAS_PENANDAAN", "MAXID") + 1;
	$tanggalSurat = $this->session->userdata('TANGGAL');
	$hasilSistem = $this->input->post('HASIL');
	$justifikasi = "";
	if (trim($hasilSistem) != "") {
	    if ($arr_penandaan['HASIL_PUSAT'] != $hasilSistem)
		$justifikasi = $this->input->post('JUSTIFIKASI');
	}
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
	    $produk = array('PENANDAAN_ID' => $penandaan_id, 'NAMA_PRODUK' => $arr_produk['NAMA_PRODUK'], 'BENTUK_SEDIAAN' => $arr_produk['BENTUK_SEDIAAN'], 'BESAR_KEMASAN' => $arr_produk['BESAR_KEMASAN'], 'KOMPOSISI' => $arr_produk['KOMPOSISI'], 'PRODUSEN' => $arr_produk['PRODUSEN'], 'PENDAFTAR' => $arr_produk['PENDAFTAR'], 'NOMOR_IZIN_EDAR' => $arr_produk['NIE'], 'ALAMAT_PRODUSEN' => $arr_produk['ALAMAT_PRODUSEN'], 'ALAMAT_PENDAFTAR' => $arr_produk['ALAMAT_PENDAFTAR'], 'GOLONGAN_PRODUK' => $arr_produk['GOLONGAN_PRODUK'], 'IMPORTIR' => $arr_produk['IMPORTIR'], 'LISENSI' => $arr_produk['LISENSI'], 'PENGEMAS' => $arr_produk['PENGEMAS'], 'ALAMAT_IMPORTIR' => $arr_produk['ALAMAT_IMPORTIR'], 'ALAMAT_LISENSI' => $arr_produk['ALAMAT_LISENSI'], 'ALAMAT_PENGEMAS' => $arr_produk['ALAMAT_PENGEMAS']);
	}
	$this->db->insert('T_PENANDAAN_PRODUK', $produk);
	if ($this->db->affected_rows() > 0) {
	    $penandaanKOS = array('PENANDAAN_ID' => $penandaan_id, 'PENILAIAN' => $arr_penandaan_KOS, 'URAIAN' => $arr_penandaan_URN, 'LAMPIRAN' => $lampiran, 'SISTEM' => $hasilSistem, 'PUSAT' => $hasilPusat, "TL_BALAI" => $arr_penandaan["TL_BALAI"]);
	}
	$this->db->insert('T_PENANDAAN_KOSMETIKA', $penandaanKOS);
	if ($this->db->affected_rows() > 0) {
	    $case = 'YESPENANDAANKOS';
	} else {
	    $case = 'NO';
	}
	if ($case == 'YESPENANDAANKOS') {
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
	$arr_penandaan_KOS = join("#", $this->input->post('CHK'));
	$arr_penandaan_URN = join("^", $this->input->post('URN'));
	$lampiran = join("^", $this->input->post('PENANDAAN_KOS'));
	$hasilSistem = $this->input->post('VALUEPENILAIAN');
	$justifikasi = "";
	$statusUPD = array();
	$saranaUPD = array();
	if (trim($hasilSistem) != "") {
	    if ($arr_penandaan['HASIL_PUSAT'] != $hasilSistem)
		$justifikasi = $this->input->post('JUSTIFIKASI');
	}
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
		$saranaUPD = array('TANGGAL_MULAI' => $arr_penandaan['TANGGALAWAL'], 'TANGGAL_AKHIR' => $arr_penandaan['TANGGALAKHIR'], 'SARANA_ID' => $arr_penandaan['SARANAID'], 'KOMODITI' => '012');
	    }
	    $penandaan = array_merge($statusUPD, $saranaUPD, array('USER_LAST_UPDATE' => $this->newsession->userdata('SESS_USER_ID'), 'LAST_UPDATE' => 'GETDATE()'));
	    $this->db->where(array("PENANDAAN_ID" => $penandaan_id, "SERI" => $seri - 1));
	    $this->db->update('T_PENANDAAN_PROSES', $arr_update_log);
	    $this->db->where(array("PENANDAAN_ID" => $penandaan_id));
	    $this->db->update('T_PENANDAAN', $penandaan);
	    if (!empty($arr_produk)) {
		$produk = array('NAMA_PRODUK' => $arr_produk['NAMA_PRODUK'], 'KLASIFIKASI_PRODUK' => $arr_produk['KLASIFIKASI_PRODUK'], 'BENTUK_SEDIAAN' => $arr_produk['BENTUK_SEDIAAN'], 'BESAR_KEMASAN' => $arr_produk['BESAR_KEMASAN'], 'KOMPOSISI' => $arr_produk['KOMPOSISI'], 'BESAR_KEMASAN' => $arr_produk['BESAR_KEMASAN'], 'KLASIFIKASI_PENDAFTAR' => $arr_produk['KLASIFIKASI_PENDAFTAR'], 'PRODUSEN' => $arr_produk['PRODUSEN'], 'PENDAFTAR' => $arr_produk['PENDAFTAR'], 'NOMOR_IZIN_EDAR' => $arr_produk['NIE'], 'ALAMAT_PRODUSEN' => $arr_produk['ALAMAT_PRODUSEN'], 'ALAMAT_PENDAFTAR' => $arr_produk['ALAMAT_PENDAFTAR'], 'GOLONGAN_PRODUK' => $arr_produk['GOLONGAN_PRODUK'], 'IMPORTIR' => $arr_produk['IMPORTIR'], 'LISENSI' => $arr_produk['LISENSI'], 'PENGEMAS' => $arr_produk['PENGEMAS'], 'ALAMAT_IMPORTIR' => $arr_produk['ALAMAT_IMPORTIR'], 'ALAMAT_LISENSI' => $arr_produk['ALAMAT_LISENSI'], 'ALAMAT_PENGEMAS' => $arr_produk['ALAMAT_PENGEMAS']);
		$this->db->where(array("PENANDAAN_ID" => $penandaan_id));
		$this->db->update('T_PENANDAAN_PRODUK', $produk);
	    }
	    if ((!in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')))) {
		$penandaanKOS = array('PENILAIAN' => $arr_penandaan_KOS, 'URAIAN' => $arr_penandaan_URN, 'LAMPIRAN' => $lampiran, 'SISTEM' => $hasilSistem, 'PUSAT' => $hasilPusat, "TL_BALAI" => $arr_penandaan["TL_BALAI"]);
	    } else {
		if (!empty($arr_penandaan_KOS))
		    $penandaanKOS = array('PENILAIAN' => $arr_penandaan_KOS, 'URAIAN' => $arr_penandaan_URN, 'LAMPIRAN' => $lampiran, 'SISTEM' => $hasilSistem, 'PUSAT' => $hasilPusat);
		else
		    $penandaanKOS = array('PUSAT' => $hasilPusat);
	    }
	    $this->db->where(array("PENANDAAN_ID" => $penandaan_id));
	    $this->db->update('T_PENANDAAN_KOSMETIKA', $penandaanKOS);
	    $case = 'YESPENANDAANKOS';
	}
	if ($case == 'YESPENANDAANKOS') {
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
	$query = "SELECT TPKOS.URAIAN, TPKOS.PENILAIAN, TPKOS.PUSAT, TP.PENANDAAN_ID, CONVERT(VARCHAR(10), TP.TANGGAL_MULAI, 120) AS TANGGAL_MULAI, CONVERT(VARCHAR(10), TP.TANGGAL_AKHIR, 120) AS TANGGAL_AKHIR, TP.SURAT_ID, TP.STATUS FROM T_PENANDAAN TP LEFT JOIN T_PENANDAAN_KOSMETIKA TPKOS ON TPKOS.PENANDAAN_ID = TP.PENANDAAN_ID WHERE TPKOS.PENANDAAN_ID = '" . $idPengawasan . "'";
	$data = $sipt->main->get_result($query);
	if ($data) {
	    foreach ($query->result_array() as $row) {
		$arrdata = array('sess' => $row, 'judul' => 'Kosmetika');
	    }
	    if ($row['STATUS'] == '20302' || $row['STATUS'] == '20312') {
		$arrdata['act'] = site_url() . '/penandaan/penandaanController/prosesEdit/edit/' . $row['PENANDAAN_ID'] . '/' . $row['STATUS'] . '/012/' . $jenisPelaporan;
		$arrdata['tombol'] = 'Lihat Data Perbaikan Pengawasan';
	    } else {
		$arrdata['act'] = site_url() . '/penandaan/penandaanController/prosesPreview/preview/' . $row['PENANDAAN_ID'] . '/' . $row['STATUS'] . '/012/' . $jenisPelaporan;
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
	$query = "SELECT TSTP.SURAT_ID, TPKOS.PENILAIAN, TPKOS.URAIAN, CONVERT(VARCHAR(MAX), TPKOS.LAMPIRAN) LAMPIRAN, TPKOS.SISTEM, TPKOS.PUSAT, TPKOS.TL_BALAI, TP.PENANDAAN_ID, CONVERT(VARCHAR(10), " . $tglQuery . ", TP.STATUS, TP.KOMODITI, TP.SARANA_ID, TP.BBPOM_ID, TPP.NAMA_PRODUK, TPP.BENTUK_SEDIAAN, TPP.BESAR_KEMASAN, TPP.KOMPOSISI, TPP.PRODUSEN, TPP.ALAMAT_PRODUSEN, TPP.PENDAFTAR, TPP.ALAMAT_PENDAFTAR, TPP.NOMOR_IZIN_EDAR, TPP.GOLONGAN_PRODUK, TPP.NOMOR_PRODUK, TPP.IMPORTIR, TPP.LISENSI, TPP.PENGEMAS, TPP.ALAMAT_IMPORTIR, TPP.ALAMAT_LISENSI, TPP.ALAMAT_PENGEMAS, MS.NAMA_SARANA, MS.ALAMAT_1, (SELECT MP1.NAMA_PROPINSI FROM M_PROPINSI MP1 WHERE MP1.PROPINSI_ID = MS.PROPINSI) AS PROPINSI, (SELECT MP2.NAMA_PROPINSI FROM M_PROPINSI MP2 WHERE MP2.PROPINSI_ID = MS.KOTA) AS KOTA FROM T_PENANDAAN TP LEFT JOIN T_PENANDAAN_KOSMETIKA TPKOS ON TPKOS.PENANDAAN_ID = TP.PENANDAAN_ID LEFT JOIN T_PENANDAAN_PRODUK TPP ON TPP.PENANDAAN_ID = TP.PENANDAAN_ID LEFT JOIN T_SURAT_TUGAS_PENANDAAN TSTP ON TSTP.SURAT_ID = TP.SURAT_ID LEFT JOIN M_SARANA MS ON MS.SARANA_ID = TP.SARANA_ID WHERE TP.PENANDAAN_ID = '" . $penandaanId . "'";
	$data = $sipt->main->get_result($query);
	if ($data) {
	    foreach ($query->result_array() as $row) {
		$arrdata = array('sess' => $row, 'judul' => 'Kosmetika');
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
	    $arrdata ['subJudul'] = '- KOSMETIKA';
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
	    $arrdata ['subJudul'] = '- KOSMETIKA EDIT';
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
	$arrdata ['cb_tindakan'] = $this->config->item('tl_pusat_penandaan_kos');
	$arrdata ['cb_tindakan_balai'] = $this->config->item('tl_balai_penandaan_kos');
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
	    $query = "SELECT DISTINCT (REPLACE(REPLACE(MB.NAMA_BBPOM,'BALAI BESAR POM DI ', ''),'BALAI POM DI ','')) AS NAMA_BBPOM, dbo.GET_KOMODITI(TP.KOMODITI) AS KOMODITI, (SUM(CASE WHEN (TPKOS.PUSAT LIKE '%TMS*%' AND (TP.BBPOM_ID = 92 OR TP.STATUS = 60510)) THEN 1 ELSE 0 END)) AS TMS_P, (SUM(CASE WHEN (TPKOS.PUSAT LIKE 'MS*%' AND (TP.BBPOM_ID = 92 OR TP.STATUS = 60510)) THEN 1 ELSE 0 END)) AS MS_P, (SUM(CASE WHEN (TPKOS.SISTEM = 'TMS' AND TP.BBPOM_ID <> 92 AND TP.STATUS <> 60510) THEN 1 ELSE 0 END)) AS TMS_B, (SUM(CASE WHEN (TPKOS.SISTEM = 'MS' AND TP.BBPOM_ID <> 92 AND TP.STATUS <> 60510) THEN 1 ELSE 0 END)) AS MS_B, (SUM(CASE WHEN TPKOS.PUSAT LIKE '%*0%' THEN 1 ELSE 0 END)) AS 'PERINGATAN1', (SUM(CASE WHEN TPKOS.PUSAT LIKE '%*1%' THEN 1 ELSE 0 END)) AS 'PERINGATAN2', (SUM(CASE WHEN TPKOS.PUSAT LIKE '%*2%' THEN 1 ELSE 0 END)) AS 'KERAS', (SUM(CASE WHEN TPKOS.PUSAT LIKE '%*3%' THEN 1 ELSE 0 END)) AS 'PRODUKSI', (SUM(CASE WHEN TPKOS.PUSAT LIKE '%*4%' THEN 1 ELSE 0 END)) AS 'IMPORTASI', (SUM(CASE WHEN TPKOS.PUSAT LIKE '%*5%' THEN 1 ELSE 0 END)) AS 'BATAL', (SUM(CASE WHEN TPKOS.PUSAT LIKE '%*6%' AND (TP.BBPOM_ID = 92 OR TP.STATUS = 60510) THEN 1 ELSE 0 END)) AS 'NOTIF', (SUM(CASE WHEN TPKOS.TL_BALAI = '0' THEN 1 ELSE 0 END)) AS 'PENGAWASAN', (SUM(CASE WHEN TPKOS.TL_BALAI = '1' THEN 1 ELSE 0 END)) AS 'LAPOR' FROM T_PENANDAAN TP LEFT JOIN T_PENANDAAN_KOSMETIKA TPKOS ON TPKOS.PENANDAAN_ID = TP.PENANDAAN_ID LEFT JOIN M_BBPOM MB ON TP.BBPOM_ID = MB.BBPOM_ID WHERE $filter2 AND TP.KOMODITI = '012' GROUP BY  MB.BBPOM_ID, MB.NAMA_BBPOM, TP.KOMODITI ORDER BY 1";
	    $this->newphpexcel->set_font('Calibri', 10);
	    $this->newphpexcel->setActiveSheetIndex(0);
	    $this->newphpexcel->set_title('RHPK Pengawasan Pengawasan');
	    $this->newphpexcel->mergecell(array(array('A1', 'F1'), array('A2', 'F2'), array('A3', 'F3'), array('A4', 'F4'), array('C6', 'E6'), array('F6', 'G6'), array('H6', 'M6')), TRUE);
	    $this->newphpexcel->mergecell(array(array('B6', 'B7'), array('A6', 'A7')), FALSE);
	    $this->newphpexcel->width(array(array('A', 4), array('B', 35), array('C', 11), array('D', 11), array('E', 11), array('F', 15), array('G', 25), array('H', 15), array('I', 15), array('J', 15), array('K', 25), array('L', 25), array('M', 15), array('N', 25)));
	    $this->newphpexcel->set_bold(array('A1', 'A2', 'A3', 'A4'));
	    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A1', 'REKAPITULASI HASIL PELAKSANAAN KEGIATAN - PENGAWASAN PENANDAAN - KOSMETIKA')->setCellValue('A2', $judul)->setCellValue('A3', strtoupper($balai))->setCellValue('A4', 'PERIODE : ' . $awal . ' s.d ' . $akhir);
	    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A6', 'No.')->setCellValue('B6', 'BBPOM')->setCellValue('C6', 'Total')->setCellValue('F6', 'Tindak Lanjut Balai')->setCellValue('H6', 'Tindak Lanjut Pusat')->setCellValue('C7', 'Diperiksa')->setCellValue('D7', 'MS')->setCellValue('E7', 'TMS')->setCellValue('F7', 'Lapor Ke Pusat')->setCellValue('G7', 'Produk Dalam Pengawasan Badan POM')->setCellValue('H7', 'Peringatan 1')->setCellValue('I7', 'Peringatan 2')->setCellValue('J7', 'Peringatan Keras')->setCellValue('K7', 'Penghentian Sementara Kegiatan Produksi')->setCellValue('L7', 'Penghentian Sementara Kegiatan Importasi')->setCellValue('M7', 'Pembatalan Izin Edar')->setCellValue('N7', 'Penutupan Sementara Akses Online Pengajuan Permohonan Notifikasi');
	    $this->newphpexcel->headings(array('A6', 'B6', 'C6', 'D6', 'E6', 'F6', 'G6', 'H6', 'I6', 'J6', 'K6', 'L6', 'M6', 'N6'));
	    $this->newphpexcel->headings(array('A7', 'B7', 'C7', 'D7', 'E7', 'F7', 'G7', 'H7', 'I7', 'J7', 'K7', 'L7', 'M7', 'N7'));
	    $this->newphpexcel->set_wrap(array('B6', 'F7', 'G7', 'H7', 'I7', 'J7', 'K7', 'L7', 'M7', 'N7'));
	    $this->newphpexcel->getActiveSheet()->getStyle('G')->getAlignment()->setWrapText(true);
	    $data = $sipt->main->get_result($query);
	    if ($data) {
		$no = 1;
		$rec = 8;
		foreach ($query->result_array() as $row) {
		    $total = $row['MS_P'] + $row['MS_B'] + $row['TMS_P'] + $row['TMS_B'];
		    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A' . $rec, $no)->setCellValue('B' . $rec, $row["NAMA_BBPOM"])->setCellValue('C' . $rec, $total)->setCellValue('D' . $rec, $row["MS_P"] + $row["MS_B"])->setCellValue('E' . $rec, $row["TMS_P"] + $row["TMS_B"])->setCellValue('F' . $rec, $row["LAPOR"])->setCellValue('G' . $rec, $row["PENGAWASAN"])->setCellValue('H' . $rec, $row["PERINGATAN1"])->setCellValue('I' . $rec, $row["PERINGATAN2"])->setCellValue('J' . $rec, $row["KERAS"])->setCellValue('K' . $rec, $row["PRODUKSI"])->setCellValue('L' . $rec, $row["IMPORTASI"])->setCellValue('M' . $rec, $row["BATAL"])->setCellValue('N' . $rec, $row["NOTIF"]);
		    $this->newphpexcel->set_detilstyle(array('A' . $rec, 'B' . $rec, 'C' . $rec, 'D' . $rec, 'E' . $rec, 'F' . $rec, 'G' . $rec, 'H' . $rec, 'I' . $rec, 'J' . $rec, 'K' . $rec, 'L' . $rec, 'M' . $rec, 'N' . $rec));
		    $this->newphpexcel->getActiveSheet()->getStyle('G' . $rec)->getAlignment()->setWrapText(true);
		    $rec++;
		    $no++;
		}
	    } else {
		$this->newphpexcel->getActiveSheet()->mergeCells('A8:N8');
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

    function report() {
	if ($this->newsession->userdata('LOGGED_IN') == TRUE) {
	    $sipt = & get_instance();
	    $this->load->model("main", "main", true);
	    $this->load->library('newphpexcel');
	    $judul = "KOSMETIKA";
	    $filter2 = "";
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
	    if ($this->input->post('HASIL') != "")
		$filterHasil = " AND dbo.GET_DATA_FROM_PENANDAAN_KOS(TP.PENANDAAN_ID) = '" . $this->input->post('HASIL') . "' ";
	    $query = "SELECT DISTINCT TP.PENANDAAN_ID, TP.BBPOM_ID, (REPLACE(REPLACE(MB.NAMA_BBPOM,'BALAI BESAR POM DI ', ''),'BALAI POM DI ','')) AS BBPOM, CONVERT(VARCHAR(10), TP.TANGGAL_MULAI, 105) AS TANGGAL_MULAI, CONVERT(VARCHAR(10), TP.TANGGAL_AKHIR, 105) AS TANGGAL_AKHIR, TPP.NAMA_PRODUK, TPP.KLASIFIKASI_PRODUK, TPP.BENTUK_SEDIAAN, TPP.BESAR_KEMASAN, TPP.KOMPOSISI, TPP.NOMOR_IZIN_EDAR, TPP.GOLONGAN_PRODUK, CONVERT(VARCHAR(MAX), TPK.PENILAIAN) AS PENILAIAN, CONVERT(VARCHAR(MAX), TPK.URAIAN) AS URAIAN, TPK.SISTEM, CONVERT(VARCHAR(MAX), TPK.PUSAT) AS PUSAT, TPK.TL_BALAI, TPP.PENDAFTAR FROM T_PENANDAAN TP LEFT JOIN M_BBPOM MB ON MB.BBPOM_ID = TP.BBPOM_ID LEFT JOIN T_PENANDAAN_PRODUK TPP ON TPP.PENANDAAN_ID = TP.PENANDAAN_ID LEFT JOIN T_PENANDAAN_KOSMETIKA TPK ON TPK.PENANDAAN_ID = TP.PENANDAAN_ID  WHERE $filter2 $filterHasil AND TP.KOMODITI = '012' GROUP BY MB.BBPOM_ID, MB.NAMA_BBPOM, TP.KOMODITI, TP.PENANDAAN_ID, TP.BBPOM_ID, TP.TANGGAL_MULAI, TP.TANGGAL_AKHIR, TPP.NAMA_PRODUK, TPP.KLASIFIKASI_PRODUK, TPP.BENTUK_SEDIAAN, TPP.BESAR_KEMASAN, TPP.KOMPOSISI, TPP.NOMOR_IZIN_EDAR, TPP.GOLONGAN_PRODUK, TPP.PENDAFTAR, CONVERT(VARCHAR(MAX), TPK.PENILAIAN), CONVERT(VARCHAR(MAX), TPK.URAIAN), TPK.SISTEM, CONVERT(VARCHAR(MAX), TPK.PUSAT), TPK.TL_BALAI ";
	    $this->newphpexcel->set_font('Calibri', 10);
	    $this->newphpexcel->setActiveSheetIndex(0);
	    $this->newphpexcel->set_title('LAPORAN PENANDAAN KOSMETIKA');
	    $this->newphpexcel->mergecell(array(array('A1', 'D1'), array('A2', 'D2'), array('A3', 'D3'), array('A4', 'D4'), array('F6', 'I6'), array('Q6', 'S6'), array('U6', 'V6'), array('W6', 'X6')), TRUE);
	    $this->newphpexcel->mergecell(array(array('A6', 'A7'), array('B6', 'B7'), array('C6', 'C7'), array('D6', 'D7'), array('E6', 'E7'), array('J6', 'J7'), array('K6', 'K7'), array('L6', 'L7'), array('M6', 'M7'), array('N6', 'N7'), array('O6', 'O7'), array('P6', 'P7'), array('T6', 'T7'), array('Y6', 'Y7'), array('Z6', 'Z7')), TRUE);
	    $this->newphpexcel->width(array(array('A', 4), array('B', 30), array('C', 30), array('D', 20), array('E', 10), array('F', 30), array('G', 30), array('H', 30), array('I', 30), array('J', 30), array('K', 20), array('L', 30), array('M', 30), array('N', 30), array('O', 30), array('P', 30), array('Q', 15), array('R', 15), array('S', 15), array('T', 100), array('U', 10), array('V', 10), array('W', 30), array('X', 30), array('Y', 40), array('Z', 30)));
	    $this->newphpexcel->set_bold(array('A1', 'A2', 'A3', 'A4'));
	    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A1', 'LAPORAN HASIL PENGAWASAN PENANDAAN')->setCellValue('A2', $judul)->setCellValue('A3', strtoupper($balai))->setCellValue('A4', 'PERIODE : ' . $awal . ' s.d ' . $akhir);
	    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A6', 'No')->setCellValue('B6', 'Tanggal Pengawasan')->setCellValue('C6', 'Nama Produk')->setCellValue('D6', 'No Bets')->setCellValue('E6', 'Netto')->setCellValue('F6', 'Nama dan Alamat')->setCellValue('J6', 'NIE / Nomor Notifikasi')->setCellValue('K6', 'Exp. Date')->setCellValue('L6', 'Komposisi')->setCellValue('M6', 'Kegunaan')->setCellValue('N6', 'Cara Penggunaan')->setCellValue('O6', 'Klaim')->setCellValue('P6', 'Peringatan / Perhatian')->setCellValue('Q6', 'Kemasan Primer (Jika Ada)')->setCellValue('T6', 'Keterangan')->setCellValue('U6', 'Kesimpulan')->setCellValue('W6', 'Tindak Lanjut')->setCellValue('Y6', 'Justifikasi')->setCellValue('Z6', 'Unit / Balai')->setCellValue('F7', 'Produsen')->setCellValue('G7', 'Importir')->setCellValue('H7', 'Distributor')->setCellValue('I7', 'Pemberi Lisensi')->setCellValue('Q7', 'Nama Produk')->setCellValue('R7', 'No Bets')->setCellValue('S7', 'Netto')->setCellValue('U7', 'Balai')->setCellValue('V7', 'Pusat')->setCellValue('W7', 'Balai')->setCellValue('X7', 'Pusat');
	    $this->newphpexcel->headings(array('A6', 'B6', 'C6', 'D6', 'E6', 'F6', 'G6', 'H6', 'I6', 'J6', 'K6', 'L6', 'M6', 'N6', 'O6', 'P6', 'Q6', 'R6', 'S6', 'T6', 'U6', 'V6', 'W6', 'X6', 'Y6', 'Z6'));
	    $this->newphpexcel->headings(array('A7', 'B7', 'C7', 'D7', 'E7', 'F7', 'G7', 'H7', 'I7', 'J7', 'K7', 'L7', 'M7', 'N7', 'O6', 'P7', 'Q7', 'R7', 'S7', 'T7', 'U7', 'V7', 'W7', 'X7', 'Y7', 'Z7'));
	    $this->newphpexcel->set_wrap(array('B6', 'I7', 'J7', 'K7', 'L7', 'M7', 'N7', 'O7', 'P7', 'Q7', 'R7', 'S7', 'T7', 'U7', 'V7', 'W7', 'X7', 'Y7', 'Z7'));
	    $arrSign = array("+" => "Ada / Sesuai", "X" => "Tidak Sesuai", "-" => "Tidak Ada");
	    $arrKet = array("-", "X");
	    $data = $sipt->main->get_result($query);
	    if ($data) {
		$no = 1;
		$rec = 8;
		$TLPusatArr = $this->config->item('tl_pusat_penandaan_kos');
		$TLBalaiArr = $this->config->item('tl_balai_penandaan_kos');
		foreach ($query->result_array() as $row) {
		    $uraianPelanggaran = explode('^', $row['URAIAN']);
		    $chkPelanggaran = explode('#', $row['PENILAIAN']);
		    $kpNama = explode("_", $chkPelanggaran[15]);
		    $kpBets = explode("_", $chkPelanggaran[16]);
		    $kpNetto = explode("_", $chkPelanggaran[17]);
		    $tlPusat = explode("*", $row['PUSAT']);
		    $justifikasi = preg_replace('/(?:<|&lt;)\/?([a-zA-Z]+) *[^<\/]*?(?:>|&gt;)/', '', $tlPusat[2]) . "\n";
		    $i = 0;
		    foreach ($chkPelanggaran as $value) {
			$spl = explode("_", $value);
			if (in_array($spl[0], $arrKet)) {
			    $arrKeterangan[$i] = $spl[1] . " " . $arrSign[$spl[0]];
			    $i++;
			}
		    }
		    $keterangan = rtrim(join(" ; ", $arrKeterangan), " ; ");
		    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A' . $rec, $no)->setCellValue('B' . $rec, $row["TANGGAL_MULAI"] . " s/d " . $row["TANGGAL_AKHIR"])->setCellValue('C' . $rec, $row["NAMA_PRODUK"])->setCellValue('D' . $rec, $uraianPelanggaran[0])->setCellValue('E' . $rec, $uraianPelanggaran[1])->setCellValue('F' . $rec, $uraianPelanggaran[4])->setCellValue('G' . $rec, $uraianPelanggaran[5])->setCellValue('H' . $rec, $uraianPelanggaran[6])->setCellValue('I' . $rec, $uraianPelanggaran[7])->setCellValue('J' . $rec, $uraianPelanggaran[2])->setCellValue('K' . $rec, $uraianPelanggaran[8])->setCellValue('L' . $rec, $uraianPelanggaran[9])->setCellValue('M' . $rec, $uraianPelanggaran[10])->setCellValue('N' . $rec, $uraianPelanggaran[11])->setCellValue('O' . $rec, $uraianPelanggaran[12])->setCellValue('P' . $rec, $uraianPelanggaran[13])->setCellValue('Q' . $rec, $arrSign[$kpNama[0]])->setCellValue('R' . $rec, $arrSign[$kpBets[0]])->setCellValue('S' . $rec, $arrSign[$kpNetto[0]])->setCellValue('T' . $rec, $keterangan)->setCellValue('U' . $rec, $row["SISTEM"])->setCellValue('V' . $rec, $tlPusat[0])->setCellValue('W' . $rec, $TLBalaiArr[$row["TL_BALAI"]])->setCellValue('X' . $rec, $TLPusatArr[$tlPusat[1]])->setCellValue('Y' . $rec, $justifikasi)->setCellValue('Z' . $rec, $row["BBPOM"]);
		    $this->newphpexcel->set_detilstyle(array('A' . $rec, 'B' . $rec, 'C' . $rec, 'D' . $rec, 'E' . $rec, 'F' . $rec, 'G' . $rec, 'H' . $rec, 'I' . $rec, 'J' . $rec, 'K' . $rec, 'L' . $rec, 'M' . $rec, 'N' . $rec, 'O' . $rec, 'P' . $rec, 'Q' . $rec, 'R' . $rec, 'S' . $rec, 'T' . $rec, 'U' . $rec, 'V' . $rec, 'W' . $rec, 'X' . $rec, 'Y' . $rec, 'Z' . $rec));
		    $this->newphpexcel->set_wrap(array('A' . $rec, 'B' . $rec, 'C' . $rec, 'D' . $rec, 'E' . $rec, 'F' . $rec, 'G' . $rec, 'H' . $rec, 'I' . $rec, 'J' . $rec, 'K' . $rec, 'L' . $rec, 'M' . $rec, 'N' . $rec, 'O' . $rec, 'P' . $rec, 'Q' . $rec, 'R' . $rec, 'S' . $rec, 'T' . $rec, 'U' . $rec, 'V' . $rec, 'W' . $rec, 'X' . $rec, 'Y' . $rec, 'Z' . $rec));
		    $rec++;
		    $no++;
		}
	    } else {
		$this->newphpexcel->getActiveSheet()->mergeCells('A8:M8');
		$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A8', 'Data Pengawasan Iklan Tidak Ditemukan');
	    }
	    ob_clean();
	    $file = "LAPORAN_HASIL_PENGAWASAN_IKLAN_" . $judul . "_" . date("YmdHis") . ".xls";
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