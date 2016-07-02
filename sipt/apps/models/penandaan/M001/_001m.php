<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
error_reporting(E_ERROR);

class _001M extends Model {

    function getFormPenandaan($klasifikasi) {
	if ($this->newsession->userdata('LOGGED_IN') == TRUE) {
	    $sipt = & get_instance();
	    $this->load->model("main", "main", true);
	    $sipt->load->model('penandaan/penandaan_act');
	    $roleOri = $sipt->penandaan_act->getRole();
	    $kodeProvinsi = substr($this->newsession->userdata('SESS_PROP_ID'), 0, 2);
	    $detailProvinsiDef = $sipt->main->combobox("SELECT PROPINSI_ID, NAMA_PROPINSI FROM M_PROPINSI WHERE LEFT(PROPINSI_ID, 2) = '" . $kodeProvinsi . "' AND RIGHT(PROPINSI_ID, 2) != '00'", "NAMA_PROPINSI", "NAMA_PROPINSI", TRUE);
	    $provinsi = $sipt->main->combobox("SELECT PROPINSI_ID, NAMA_PROPINSI FROM M_PROPINSI WHERE LEFT(PROPINSI_ID, 1) <= '9' AND RIGHT(PROPINSI_ID, 2) = '00' AND LEFT(PROPINSI_ID, 2) = '" . $kodeProvinsi . "'", "PROPINSI_ID", "NAMA_PROPINSI");
	    $arrdata = array('provinsi' => $provinsi, 'kabupaten' => $detailProvinsiDef, 'act' => site_url() . '/penandaan/penandaanController/setFormPenandaanLanjutan/pengawasan/' . $klasifikasi, 'batal' => site_url() . '/penandaan/penandaanController/getFormPenandaanLanjutan/' . $klasifikasi, 'histori_petugas' => site_url() . '/load/petugas/get_petugas_2/');
	    $arrdata ['cb_tindakan'] = $sipt->main->referensi("TL_DISTRIBUSI", "01,02", TRUE, FALSE);
	    $arrayTL[''] = NULL;
	    $arrayTL['TL'] = 'Tindak Lanjut';
	    $arrayTL['STL'] = 'Sudah Tindak Lanjut';
	    $arrayTL['TTL'] = 'Tidak Dapat Tindak Lanjut';
	    $arrdata ['cb_tl'] = $arrayTL;
	    $arrdata ['golongan_obat'] = array("" => "", "Bebas" => "Bebas", "Bebas Terbatas" => "Bebas Terbatas", "Keras" => "Keras", "Psikotropika" => "Psikotropika", "Narkotika" => "Narkotika");
	    $arrdata ['klasifikasi_obat'] = array("" => "", "Obat Nama Dagang" => "Obat Nama Dagang", "Obat Generik" => "Obat Generik");
	    $arrdata ['klasifikasi_pendaftar'] = array("" => "", "Lokal" => "Lokal", "Impor" => "Impor");
	    $arrdata ['objStatus'] = 'TO';
	    $arrdata ['labelSimpan'] = 'Simpan Data Pengawasan';
	    $arrdata ['role'] = $roleOri;
	    $arrdata ['klasifikasi'] = $klasifikasi;
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
	$BLarr = array();
	$ASarr = array();
	$ETarr = array();
	$SBarr = array();
	$V1arr = array();
	$V2arr = array();
	$BRarr = array();
	$arr_penandaan = $this->input->post('PENANDAAN');
	$arr_produk = $this->input->post('PENANDAANPRODUK');
	$arr_penandaan_obat_bl = $this->input->post('CHK1');
	$arr_penandaan_obat_as = $this->input->post('CHK2');
	$arr_penandaan_obat_et = $this->input->post('CHK3');
	$arr_penandaan_obat_sb = $this->input->post('CHK4');
	$arr_penandaan_obat_v1 = $this->input->post('CHK5');
	$arr_penandaan_obat_v2 = $this->input->post('CHK6');
	$arr_penandaan_obat_br = $this->input->post('CHK7');
	$lampiran = $this->input->post('PENANDAAN_OBAT');
	$arr_petugas = $this->session->userdata('USER');
	$suratTugas = $this->session->userdata('SURAT');
	$suratId = (int) $sipt->main->get_uraian("SELECT MAX(SURAT_ID) AS MAXID FROM T_SURAT_TUGAS_PENANDAAN", "MAXID") + 1;
	$tanggalSurat = $this->session->userdata('TANGGAL');
	if (empty($this->session->userdata['SURAT'])) {
	    $suratTugas = " ";
	}
	if (empty($this->session->userdata['TANGGAL'])) {
	    $tanggalSurat = null;
	}
	$dataBL = rtrim(join("#", $arr_penandaan_obat_bl), "#");
	$dataAS = rtrim(join("#", $arr_penandaan_obat_as), "#");
	$dataET = rtrim(join("#", $arr_penandaan_obat_et), "#");
	$dataSB = rtrim(join("#", $arr_penandaan_obat_sb), "#");
	$dataV1 = rtrim(join("#", $arr_penandaan_obat_v1), "#");
	$dataV2 = rtrim(join("#", $arr_penandaan_obat_v2), "#");
	$dataBR = rtrim(join("#", $arr_penandaan_obat_br), "#");
	$penandaan_id = (int) $sipt->main->get_uraian("SELECT MAX(PENANDAAN_ID) AS MAXPENANDAAN FROM T_PENANDAAN", "MAXPENANDAAN") + 1;
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
	    $produk = array('PENANDAAN_ID' => $penandaan_id, 'NAMA_PRODUK' => $arr_produk['NAMA_PRODUK'], 'KLASIFIKASI_PRODUK' => $arr_produk['KLASIFIKASI_PRODUK'], 'BENTUK_SEDIAAN' => $arr_produk['BENTUK_SEDIAAN'], 'BESAR_KEMASAN' => $arr_produk['BESAR_KEMASAN'], 'KOMPOSISI' => $arr_produk['KOMPOSISI'], 'KLASIFIKASI_PENDAFTAR' => $arr_produk['KLASIFIKASI_PENDAFTAR'], 'PRODUSEN' => $arr_produk['PRODUSEN'], 'PENDAFTAR' => $arr_produk['PENDAFTAR'], 'NOMOR_IZIN_EDAR' => $arr_produk['NOMOR_IZIN_EDAR'], 'GOLONGAN_PRODUK' => $arr_produk['GOLONGAN_PRODUK'], 'NOMOR_PRODUK' => $arr_produk['NOMOR_PRODUK']);
	}
	$this->db->insert('T_PENANDAAN_PRODUK', $produk);
	if ($this->db->affected_rows() > 0) {
	    if (in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) {
		$sipt->load->model('penandaan/penandaan_act');
		if (in_array('2', $this->newsession->userdata('SESS_KODE_ROLE'))) {
		    $pusatBL = $this->input->post('BL');
		    $pusatAS = $this->input->post('AS');
		    $pusatET = $this->input->post('ET');
		    $pusatSB = $this->input->post('SB');
		    $pusatV1 = $this->input->post('V1');
		    $pusatV2 = $this->input->post('V2');
		    $pusatBR = $this->input->post('BR');
		    $justifikasiBL = "";
		    $justifikasiAS = "";
		    $justifikasiET = "";
		    $justifikasiSB = "";
		    $justifikasiV1 = "";
		    $justifikasiV2 = "";
		    $justifikasiBR = "";
		    if (end($arr_penandaan_obat_bl) != $pusatBL['HASIL_PUSAT'][0])
			$justifikasiBL = $this->input->post('JUSTIFIKASI_BL');
		    if (end($arr_penandaan_obat_as) != $pusatAS['HASIL_PUSAT'][0])
			$justifikasiAS = $this->input->post('JUSTIFIKASI_AS');
		    if (end($arr_penandaan_obat_et) != $pusatET['HASIL_PUSAT'][0])
			$justifikasiET = $this->input->post('JUSTIFIKASI_ET');
		    if (end($arr_penandaan_obat_sb) != $pusatSB['HASIL_PUSAT'][0])
			$justifikasiSB = $this->input->post('JUSTIFIKASI_SB');
		    if (end($arr_penandaan_obat_v1) != $pusatV1['HASIL_PUSAT'][0])
			$justifikasiV1 = $this->input->post('JUSTIFIKASI_V1');
		    if (end($arr_penandaan_obat_v2) != $pusatV2['HASIL_PUSAT'][0])
			$justifikasiV2 = $this->input->post('JUSTIFIKASI_V2');
		    if (end($arr_penandaan_obat_br) != $pusatBR['HASIL_PUSAT'][0])
			$justifikasiBR = $this->input->post('JUSTIFIKASI_BR');
		    if ($pusatBL['HASIL_PUSAT'][0] == "MK")
			$BLarr = array('BUNGKUS_LUAR' => $lampiran['FILE_PENANDAAN_BL'] . "*" . $dataBL . "*" . $this->input->post('detilPelanggaranbL') . "*" . join("*", $pusatBL['HASIL_PUSAT']) . "***" . $justifikasiBL);
		    else if ($pusatBL['HASIL_PUSAT'][0] == "TMK")
			$BLarr = array('BUNGKUS_LUAR' => $lampiran['FILE_PENANDAAN_BL'] . "*" . $dataBL . "*" . $this->input->post('detilPelanggaranbL') . "*" . join("*", $pusatBL['HASIL_PUSAT']) . "*" . rtrim(join("^", $pusatBL['TL_PUSAT']), "^") . "*" . rtrim(join("^", $pusatBL['DETAIL_PUSAT']), "^") . "*" . $justifikasiBL);
		    else
			$BLarr = array('BUNGKUS_LUAR' => '**');
		    if ($pusatAS['HASIL_PUSAT'][0] == "MK")
			$ASarr = array('AMPLOP' => $lampiran['FILE_PENANDAAN_AS'] . "*" . $dataAS . "*" . $this->input->post('detilPelanggaranaS') . "*" . join("*", $pusatAS['HASIL_PUSAT']) . "***" . $justifikasiAS);
		    else if ($pusatAS['HASIL_PUSAT'][0] == "TMK")
			$ASarr = array('AMPLOP' => $lampiran['FILE_PENANDAAN_AS'] . "*" . $dataAS . "*" . $this->input->post('detilPelanggaranaS') . "*" . join("*", $pusatAS['HASIL_PUSAT']) . "*" . rtrim(join("^", $pusatAS['TL_PUSAT']), "^") . "*" . rtrim(join("^", $pusatAS['DETAIL_PUSAT']), "^") . "*" . $justifikasiAS);
		    else
			$ASarr = array('AMPLOP' => '**');
		    if ($pusatET['HASIL_PUSAT'][0] == "MK")
			$ETarr = array('ETIKET' => $lampiran['FILE_PENANDAAN_ET'] . "*" . $dataET . "*" . $this->input->post('detilPelanggaraneT') . "*" . join("*", $pusatET['HASIL_PUSAT']) . "***" . $justifikasiET);
		    else if ($pusatET['HASIL_PUSAT'][0] == "TMK")
			$ETarr = array('ETIKET' => $lampiran['FILE_PENANDAAN_ET'] . "*" . $dataET . "*" . $this->input->post('detilPelanggaraneT') . "*" . join("*", $pusatET['HASIL_PUSAT']) . "*" . rtrim(join("^", $pusatET['TL_PUSAT']), "^") . "*" . rtrim(join("^", $pusatET['DETAIL_PUSAT']), "^") . "*" . $justifikasiET);
		    else
			$ETarr = array('ETIKET' => '**');
		    if ($pusatV1['HASIL_PUSAT'][0] == "MK")
			$V1arr = array('AMPUL_VIAL10ML' => $lampiran['FILE_PENANDAAN_V1'] . "*" . $dataV1 . "*" . $this->input->post('detilPelanggaranv1') . "*" . join("*", $pusatV1['HASIL_PUSAT']) . "***" . $justifikasiV1);
		    else if ($pusatV1['HASIL_PUSAT'][0] == "TMK")
			$V1arr = array('AMPUL_VIAL10ML' => $lampiran['FILE_PENANDAAN_V1'] . "*" . $dataV1 . "*" . $this->input->post('detilPelanggaranv1') . "*" . join("*", $pusatV1['HASIL_PUSAT']) . "*" . rtrim(join("^", $pusatV1['TL_PUSAT']), "^") . "*" . rtrim(join("^", $pusatV1['DETAIL_PUSAT']), "^") . "*" . $justifikasiV1);
		    else
			$V1arr = array('AMPUL_VIAL10ML' => '**');
		    if ($pusatV2['HASIL_PUSAT'][0] == "MK")
			$V2arr = array('AMPUL_VIAL9ML' => $lampiran['FILE_PENANDAAN_V2'] . "*" . $dataV2 . "*" . $this->input->post('detilPelanggaranv2') . "*" . join("*", $pusatV2['HASIL_PUSAT']) . "***" . $justifikasiV2);
		    else if ($pusatV2['HASIL_PUSAT'][0] == "TMK")
			$V2arr = array('AMPUL_VIAL9ML' => $lampiran['FILE_PENANDAAN_V2'] . "*" . $dataV2 . "*" . $this->input->post('detilPelanggaranv2') . "*" . join("*", $pusatV2['HASIL_PUSAT']) . "*" . rtrim(join("^", $pusatV2['TL_PUSAT']), "^") . "*" . rtrim(join("^", $pusatV2['DETAIL_PUSAT']), "^") . "*" . $justifikasiV2);
		    else
			$V2arr = array('AMPUL_VIAL9ML' => '**');
		    if ($pusatBR['HASIL_PUSAT'][0] == "MK")
			$BRarr = array('BROSUR' => $lampiran['FILE_PENANDAAN_BR'] . "*" . $dataBR . "*" . $this->input->post('detilPelanggaranbR') . "*" . join("*", $pusatBR['HASIL_PUSAT']) . "***" . $justifikasiBR);
		    else if ($pusatBR['HASIL_PUSAT'][0] == "TMK")
			$BRarr = array('BROSUR' => $lampiran['FILE_PENANDAAN_BR'] . "*" . $dataBR . "*" . $this->input->post('detilPelanggaranbR') . "*" . join("*", $pusatBR['HASIL_PUSAT']) . "*" . rtrim(join("^", $pusatBR['TL_PUSAT']), "^") . "*" . rtrim(join("^", $pusatBR['DETAIL_PUSAT']), "^") . "*" . $justifikasiBR);
		    else
			$BRarr = array('BROSUR' => '**');
		    if ($pusatSB['HASIL_PUSAT'][0] == "MK")
			$SBarr = array('BLISTER' => $lampiran['FILE_PENANDAAN_SB'] . "*" . $dataSB . "*" . $this->input->post('detilPelanggaransB') . "*" . join("*", $pusatSB['HASIL_PUSAT']) . "***" . $justifikasiSB);
		    else if ($pusatSB['HASIL_PUSAT'][0] == "TMK")
			$SBarr = array('BLISTER' => $lampiran['FILE_PENANDAAN_SB'] . "*" . $dataSB . "*" . $this->input->post('detilPelanggaransB') . "*" . join("*", $pusatSB['HASIL_PUSAT']) . "*" . rtrim(join("^", $pusatSB['TL_PUSAT']), "^") . "*" . rtrim(join("^", $pusatSB['DETAIL_PUSAT']), "^") . "*" . $justifikasiSB);
		    else
			$SBarr = array('BLISTER' => '**');
		    $penandaanObat = array_merge($BLarr, $BRarr, $ASarr, $ETarr, $SBarr, $V1arr, $V2arr, array('PENANDAAN_ID' => $penandaan_id));
		}
	    } else {
		$penandaanObat = array('PENANDAAN_ID' => $penandaan_id, 'BUNGKUS_LUAR' => $lampiran['FILE_PENANDAAN_BL'] . "*" . $dataBL . "*" . $this->input->post('detilPelanggaranbL'), 'ETIKET' => $lampiran['FILE_PENANDAAN_ET'] . "*" . $dataET . "*" . $this->input->post('detilPelanggaraneT'), 'AMPUL_VIAL10ML' => $lampiran['FILE_PENANDAAN_V1'] . "*" . $dataV1 . "*" . $this->input->post('detilPelanggaranv1'), 'AMPUL_VIAL9ML' => $lampiran['FILE_PENANDAAN_V2'] . "*" . $dataV2 . "*" . $this->input->post('detilPelanggaranv2'), 'BROSUR' => $lampiran['FILE_PENANDAAN_BR'] . "*" . $dataBR . "*" . $this->input->post('detilPelanggaranbR'), 'BLISTER' => $lampiran['FILE_PENANDAAN_SB'] . "*" . $dataSB . "*" . $this->input->post('detilPelanggaransB'), 'AMPLOP' => $lampiran['FILE_PENANDAAN_AS'] . "*" . $dataAS . "*" . $this->input->post('detilPelanggaranaS'));
	    }
	}
	$this->db->insert('T_PENANDAAN_OBAT', $penandaanObat);
	if ($this->db->affected_rows() > 0) {
	    $case = 'YESPENANDAANOBAT';
	} else {
	    $case = 'NO';
	}
	if ($case == 'YESPENANDAANOBAT') {
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
	$status = $this->input->post('TO');
	$lampiran = $this->input->post('PENANDAAN_OBAT');
	$arr_penandaan_obat_bl = $this->input->post('CHK1');
	$arr_penandaan_obat_as = $this->input->post('CHK2');
	$arr_penandaan_obat_et = $this->input->post('CHK3');
	$arr_penandaan_obat_sb = $this->input->post('CHK4');
	$arr_penandaan_obat_v1 = $this->input->post('CHK5');
	$arr_penandaan_obat_v2 = $this->input->post('CHK6');
	$arr_penandaan_obat_br = $this->input->post('CHK7');
	$dataBL = rtrim(join("#", $arr_penandaan_obat_bl), "#");
	$dataAS = rtrim(join("#", $arr_penandaan_obat_as), "#");
	$dataET = rtrim(join("#", $arr_penandaan_obat_et), "#");
	$dataSB = rtrim(join("#", $arr_penandaan_obat_sb), "#");
	$dataV1 = rtrim(join("#", $arr_penandaan_obat_v1), "#");
	$dataV2 = rtrim(join("#", $arr_penandaan_obat_v2), "#");
	$dataBR = rtrim(join("#", $arr_penandaan_obat_br), "#");
	$statusUPD = array();
	$saranaUPD = array();
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
		$saranaUPD = array('TANGGAL_MULAI' => $arr_penandaan['TANGGALAWAL'], 'TANGGAL_AKHIR' => $arr_penandaan['TANGGALAKHIR'], 'SARANA_ID' => $arr_penandaan['SARANAID'], 'KOMODITI' => '001');
	    }
	    if ($this->db->affected_rows() > 0) {
		$penandaan = array_merge($statusUPD, $saranaUPD, array('USER_LAST_UPDATE' => $this->newsession->userdata('SESS_USER_ID'), 'LAST_UPDATE' => 'GETDATE()'));
		$this->db->where(array("PENANDAAN_ID" => $penandaan_id, "SERI" => $seri - 1));
		$this->db->update('T_PENANDAAN_PROSES', $arr_update_log);
		$this->db->where(array("PENANDAAN_ID" => $penandaan_id));
		$this->db->update('T_PENANDAAN', $penandaan);
		if ($arr_produk) {
		    $produk = array('NAMA_PRODUK' => $arr_produk['NAMA_PRODUK'], 'KLASIFIKASI_PRODUK' => $arr_produk['KLASIFIKASI_PRODUK'], 'BENTUK_SEDIAAN' => $arr_produk['BENTUK_SEDIAAN'], 'BESAR_KEMASAN' => $arr_produk['BESAR_KEMASAN'], 'KOMPOSISI' => $arr_produk['KOMPOSISI'], 'BESAR_KEMASAN' => $arr_produk['BESAR_KEMASAN'], 'KLASIFIKASI_PENDAFTAR' => $arr_produk['KLASIFIKASI_PENDAFTAR'], 'PRODUSEN' => $arr_produk['PRODUSEN'], 'PENDAFTAR' => $arr_produk['PENDAFTAR'], 'NOMOR_IZIN_EDAR' => $arr_produk['NOMOR_IZIN_EDAR'], 'GOLONGAN_PRODUK' => $arr_produk['GOLONGAN_PRODUK'], 'NOMOR_PRODUK' => $arr_produk['NOMOR_PRODUK']);
		    $this->db->where(array("PENANDAAN_ID" => $penandaan_id));
		    $this->db->update('T_PENANDAAN_PRODUK', $produk);
		}
	    }
	    if (in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) {
		$sipt->load->model('penandaan/penandaan_act');
		$yes = $this->input->post('EDIT');
		$BLarr = array();
		$ASarr = array();
		$ETarr = array();
		$SBarr = array();
		$V1arr = array();
		$V2arr = array();
		$BRarr = array();
		if (in_array('2', $this->newsession->userdata('SESS_KODE_ROLE')) && $yes == 'YES') {
		    $pusatBL = $this->input->post('BL');
		    $pusatAS = $this->input->post('AS');
		    $pusatET = $this->input->post('ET');
		    $pusatSB = $this->input->post('SB');
		    $pusatV1 = $this->input->post('V1');
		    $pusatV2 = $this->input->post('V2');
		    $pusatBR = $this->input->post('BR');
		    $justifikasiBL = "";
		    $justifikasiAS = "";
		    $justifikasiET = "";
		    $justifikasiSB = "";
		    $justifikasiV1 = "";
		    $justifikasiV2 = "";
		    $justifikasiBR = "";
		    if (!$arr_penandaan_obat_bl) {
			$repArrBL1 = explode('*', $this->input->post('VALUE_BL'));
			$repArrBL2 = explode('#', $repArrBL1[1]);
			if (end($repArrBL2) != $pusatBL['HASIL_PUSAT'][0])
			    $justifikasiBL = $this->input->post('JUSTIFIKASI_BL');
			if ($pusatBL['HASIL_PUSAT'][0] == "MK")
			    $BLarr = array('BUNGKUS_LUAR' => $this->input->post('VALUE_BL') . "*" . join("*", $pusatBL['HASIL_PUSAT']) . "***" . $justifikasiBL);
			else if ($pusatBL['HASIL_PUSAT'][0] == "TMK")
			    $BLarr = array('BUNGKUS_LUAR' => $this->input->post('VALUE_BL') . "*" . join("*", $pusatBL['HASIL_PUSAT']) . "*" . rtrim(join("^", $pusatBL['TL_PUSAT']), "^") . "*" . rtrim(join("^", $pusatBL['DETAIL_PUSAT']), "^") . "*" . $justifikasiBL);
		    } else if ($arr_penandaan_obat_bl) {
			if (end($arr_penandaan_obat_bl) != $pusatBL['HASIL_PUSAT'][0])
			    $justifikasiBL = $this->input->post('JUSTIFIKASI_BL');
			if ($pusatBL['HASIL_PUSAT'][0] == "MK")
			    $BLarr = array('BUNGKUS_LUAR' => $lampiran['FILE_PENANDAAN_BL'] . "*" . $dataBL . "*" . $this->input->post('detilPelanggaranbL') . "*" . join("*", $pusatBL['HASIL_PUSAT']) . "***" . $justifikasiBL);
			else if ($pusatBL['HASIL_PUSAT'][0] == "TMK")
			    $BLarr = array('BUNGKUS_LUAR' => $lampiran['FILE_PENANDAAN_BL'] . "*" . $dataBL . "*" . $this->input->post('detilPelanggaranbL') . "*" . join("*", $pusatBL['HASIL_PUSAT']) . "*" . rtrim(join("^", $pusatBL['TL_PUSAT']), "^") . "*" . rtrim(join("^", $pusatBL['DETAIL_PUSAT']), "^") . "*" . $justifikasiBL);
			else
			    $BLarr = array('BUNGKUS_LUAR' => '**');
		    }
		    if (!$arr_penandaan_obat_as) {
			$repArrAS1 = explode('*', $this->input->post('VALUE_AS'));
			$repArrAS2 = explode('#', $repArrAS1[1]);
			if (end($repArrAS2) != $pusatAS['HASIL_PUSAT'][0])
			    $justifikasiAS = $this->input->post('JUSTIFIKASI_AS');
			if ($pusatAS['HASIL_PUSAT'][0] == "MK")
			    $ASarr = array('AMPLOP' => $this->input->post('VALUE_AS') . "*" . join("*", $pusatAS['HASIL_PUSAT']) . "***" . $justifikasiAS);
			else if ($pusatAS['HASIL_PUSAT'][0] == "TMK")
			    $ASarr = array('AMPLOP' => $this->input->post('VALUE_AS') . "*" . join("*", $pusatAS['HASIL_PUSAT']) . "*" . rtrim(join("^", $pusatAS['TL_PUSAT']), "^") . "*" . rtrim(join("^", $pusatAS['DETAIL_PUSAT']), "^") . "*" . $justifikasiAS);
		    } else if ($arr_penandaan_obat_as) {
			if (end($arr_penandaan_obat_as) != $pusatAS['HASIL_PUSAT'][0])
			    $justifikasiAS = $this->input->post('JUSTIFIKASI_AS');
			if ($pusatAS['HASIL_PUSAT'][0] == "MK")
			    $ASarr = array('AMPLOP' => $lampiran['FILE_PENANDAAN_AS'] . "*" . $dataAS . "*" . $this->input->post('detilPelanggaranaS') . "*" . join("*", $pusatAS['HASIL_PUSAT']) . "***" . $justifikasiAS);
			else if ($pusatAS['HASIL_PUSAT'][0] == "TMK")
			    $ASarr = array('AMPLOP' => $lampiran['FILE_PENANDAAN_AS'] . "*" . $dataAS . "*" . $this->input->post('detilPelanggaranaS') . "*" . join("*", $pusatAS['HASIL_PUSAT']) . "*" . rtrim(join("^", $pusatAS['TL_PUSAT']), "^") . "*" . rtrim(join("^", $pusatAS['DETAIL_PUSAT']), "^") . "*" . $justifikasiAS);
			else
			    $ASarr = array('AMPLOP' => '**');
		    }
		    if (!$arr_penandaan_obat_et) {
			$repArrET1 = explode('*', $this->input->post('VALUE_ET'));
			$repArrET2 = explode('#', $repArrET1[1]);
			if (end($repArrET2) != $pusatET['HASIL_PUSAT'][0])
			    $justifikasiET = $this->input->post('JUSTIFIKASI_ET');
			if ($pusatET['HASIL_PUSAT'][0] == "MK")
			    $ETarr = array('ETIKET' => $this->input->post('VALUE_ET') . "*" . join("*", $pusatET['HASIL_PUSAT']) . "***" . $justifikasiET);
			else if ($pusatET['HASIL_PUSAT'][0] == "TMK")
			    $ETarr = array('ETIKET' => $this->input->post('VALUE_ET') . "*" . join("*", $pusatET['HASIL_PUSAT']) . "*" . rtrim(join("^", $pusatET['TL_PUSAT']), "^") . "*" . rtrim(join("^", $pusatET['DETAIL_PUSAT']), "^") . "*" . $justifikasiET);
		    } else if ($arr_penandaan_obat_et) {
			if (end($arr_penandaan_obat_et) != $pusatET['HASIL_PUSAT'][0])
			    $justifikasiET = $this->input->post('JUSTIFIKASI_ET');
			if ($pusatET['HASIL_PUSAT'][0] == "MK")
			    $ETarr = array('ETIKET' => $lampiran['FILE_PENANDAAN_ET'] . "*" . $dataET . "*" . $this->input->post('detilPelanggaraneT') . "*" . join("*", $pusatET['HASIL_PUSAT']) . "***" . $justifikasiET);
			else if ($pusatET['HASIL_PUSAT'][0] == "TMK")
			    $ETarr = array('ETIKET' => $lampiran['FILE_PENANDAAN_ET'] . "*" . $dataET . "*" . $this->input->post('detilPelanggaraneT') . "*" . join("*", $pusatET['HASIL_PUSAT']) . "*" . rtrim(join("^", $pusatET['TL_PUSAT']), "^") . "*" . rtrim(join("^", $pusatET['DETAIL_PUSAT']), "^") . "*" . $justifikasiET);
			else
			    $ETarr = array('ETIKET' => '**');
		    }
		    if (!$arr_penandaan_obat_v1) {
			$repArrV11 = explode('*', $this->input->post('VALUE_V1'));
			$repArrV12 = explode('#', $repArrV11[1]);
			if (end($repArrV12) != $pusatV1['HASIL_PUSAT'][0])
			    $justifikasiV1 = $this->input->post('JUSTIFIKASI_V1');
			if ($pusatV1['HASIL_PUSAT'][0] == "MK")
			    $V1arr = array('AMPUL_VIAL10ML' => $this->input->post('VALUE_V1') . "*" . join("*", $pusatV1['HASIL_PUSAT']) . "***" . $justifikasiV1);
			else if ($pusatV1['HASIL_PUSAT'][0] == "TMK")
			    $V1arr = array('AMPUL_VIAL10ML' => $this->input->post('VALUE_V1') . "*" . join("*", $pusatV1['HASIL_PUSAT']) . "*" . rtrim(join("^", $pusatV1['TL_PUSAT']), "^") . "*" . rtrim(join("^", $pusatV1['DETAIL_PUSAT']), "^") . "*" . $justifikasiV1);
		    } else if ($arr_penandaan_obat_v1) {
			if (end($arr_penandaan_obat_v1) != $pusatV1['HASIL_PUSAT'][0])
			    $justifikasiV1 = $this->input->post('JUSTIFIKASI_V1');
			if ($pusatV1['HASIL_PUSAT'][0] == "MK")
			    $V1arr = array('AMPUL_VIAL10ML' => $lampiran['FILE_PENANDAAN_V1'] . "*" . $dataV1 . "*" . $this->input->post('detilPelanggaranv1') . "*" . join("*", $pusatV1['HASIL_PUSAT']) . "***" . $justifikasiV1);
			else if ($pusatV1['HASIL_PUSAT'][0] == "TMK")
			    $V1arr = array('AMPUL_VIAL10ML' => $lampiran['FILE_PENANDAAN_V1'] . "*" . $dataV1 . "*" . $this->input->post('detilPelanggaranv1') . "*" . join("*", $pusatV1['HASIL_PUSAT']) . "*" . rtrim(join("^", $pusatV1['TL_PUSAT']), "^") . "*" . rtrim(join("^", $pusatV1['DETAIL_PUSAT']), "^") . "*" . $justifikasiV1);
			else
			    $V1arr = array('AMPUL_VIAL10ML' => '**');
		    }
		    if (!$arr_penandaan_obat_v2) {
			$repArrV21 = explode('*', $this->input->post('VALUE_V2'));
			$repArrV22 = explode('#', $repArrV21[1]);
			if (end($repArrV22) != $pusatV2['HASIL_PUSAT'][0])
			    $justifikasiV2 = $this->input->post('JUSTIFIKASI_V2');
			if ($pusatV2['HASIL_PUSAT'][0] == "MK")
			    $V2arr = array('AMPUL_VIAL9ML' => $this->input->post('VALUE_V2') . "*" . join("*", $pusatV2['HASIL_PUSAT']) . "***" . $justifikasiV2);
			else if ($pusatV2['HASIL_PUSAT'][0] == "TMK")
			    $V2arr = array('AMPUL_VIAL9ML' => $this->input->post('VALUE_V2') . "*" . join("*", $pusatV2['HASIL_PUSAT']) . "*" . rtrim(join("^", $pusatV2['TL_PUSAT']), "^") . "*" . rtrim(join("^", $pusatV2['DETAIL_PUSAT']), "^") . "*" . $justifikasiV2);
		    } else if ($arr_penandaan_obat_v2) {
			if (end($arr_penandaan_obat_v2) != $pusatV2['HASIL_PUSAT'][0])
			    $justifikasiV2 = $this->input->post('JUSTIFIKASI_V2');
			if ($pusatV2['HASIL_PUSAT'][0] == "MK")
			    $V2arr = array('AMPUL_VIAL9ML' => $lampiran['FILE_PENANDAAN_V2'] . "*" . $dataV2 . "*" . $this->input->post('detilPelanggaranv2') . "*" . join("*", $pusatV2['HASIL_PUSAT']) . "***" . $justifikasiV2);
			else if ($pusatV2['HASIL_PUSAT'][0] == "TMK")
			    $V2arr = array('AMPUL_VIAL9ML' => $lampiran['FILE_PENANDAAN_V2'] . "*" . $dataV2 . "*" . $this->input->post('detilPelanggaranv2') . "*" . join("*", $pusatV2['HASIL_PUSAT']) . "*" . rtrim(join("^", $pusatV2['TL_PUSAT']), "^") . "*" . rtrim(join("^", $pusatV2['DETAIL_PUSAT']), "^") . "*" . $justifikasiV2);
			else
			    $V2arr = array('AMPUL_VIAL9ML' => '**');
		    }
		    if (!$arr_penandaan_obat_br) {
			$repArrBR1 = explode('*', $this->input->post('VALUE_BR'));
			$repArrBR2 = explode('#', $repArrBR1[1]);
			if (end($repArrBR2) != $pusatBR['HASIL_PUSAT'][0])
			    $justifikasiBR = $this->input->post('JUSTIFIKASI_BR');
			if ($pusatBR['HASIL_PUSAT'][0] == "MK")
			    $BRarr = array('BROSUR' => $this->input->post('VALUE_BR') . "*" . join("*", $pusatBR['HASIL_PUSAT']) . "***" . $justifikasiBR);
			else if ($pusatBR['HASIL_PUSAT'][0] == "TMK")
			    $BRarr = array('BROSUR' => $this->input->post('VALUE_BR') . "*" . join("*", $pusatBR['HASIL_PUSAT']) . "*" . rtrim(join("^", $pusatBR['TL_PUSAT']), "^") . "*" . rtrim(join("^", $pusatBR['DETAIL_PUSAT']), "^") . "*" . $justifikasiBR);
		    } else if ($arr_penandaan_obat_br) {
			if (end($arr_penandaan_obat_br) != $pusatBR['HASIL_PUSAT'][0])
			    $justifikasiBR = $this->input->post('JUSTIFIKASI_BR');
			if ($pusatBR['HASIL_PUSAT'][0] == "MK")
			    $BRarr = array('BROSUR' => $lampiran['FILE_PENANDAAN_BR'] . "*" . $dataBR . "*" . $this->input->post('detilPelanggaranbR') . "*" . join("*", $pusatBR['HASIL_PUSAT']) . "***" . $justifikasiBR);
			else if ($pusatBR['HASIL_PUSAT'][0] == "TMK")
			    $BRarr = array('BROSUR' => $lampiran['FILE_PENANDAAN_BR'] . "*" . $dataBR . "*" . $this->input->post('detilPelanggaranbR') . "*" . join("*", $pusatBR['HASIL_PUSAT']) . "*" . rtrim(join("^", $pusatBR['TL_PUSAT']), "^") . "*" . rtrim(join("^", $pusatBR['DETAIL_PUSAT']), "^") . "*" . $justifikasiBR);
			else
			    $BRarr = array('BROSUR' => '**');
		    }
		    if (!$arr_penandaan_obat_sb) {
			$repArrSB1 = explode('*', $this->input->post('VALUE_SB'));
			$repArrSB2 = explode('#', $repArrSB1[1]);
			if (end($repArrSB2) != $pusatSB['HASIL_PUSAT'][0])
			    $justifikasiSB = $this->input->post('JUSTIFIKASI_SB');
			if ($pusatSB['HASIL_PUSAT'][0] == "MK")
			    $SBarr = array('BLISTER' => $this->input->post('VALUE_SB') . "*" . join("*", $pusatSB['HASIL_PUSAT']) . "***" . $justifikasiSB);
			else if ($pusatSB['HASIL_PUSAT'][0] == "TMK")
			    $SBarr = array('BLISTER' => $this->input->post('VALUE_SB') . "*" . join("*", $pusatSB['HASIL_PUSAT']) . "*" . rtrim(join("^", $pusatSB['TL_PUSAT']), "^") . "*" . rtrim(join("^", $pusatSB['DETAIL_PUSAT']), "^") . "*" . $justifikasiSB);
		    } else if ($arr_penandaan_obat_sb) {
			if (end($arr_penandaan_obat_sb) != $pusatSB['HASIL_PUSAT'][0])
			    $justifikasiSB = $this->input->post('JUSTIFIKASI_SB');
			if ($pusatSB['HASIL_PUSAT'][0] == "MK")
			    $SBarr = array('BLISTER' => $lampiran['FILE_PENANDAAN_SB'] . "*" . $dataSB . "*" . $this->input->post('detilPelanggaransB') . "*" . join("*", $pusatSB['HASIL_PUSAT']) . "***" . $justifikasiSB);
			else if ($pusatSB['HASIL_PUSAT'][0] == "TMK")
			    $SBarr = array('BLISTER' => $lampiran['FILE_PENANDAAN_SB'] . "*" . $dataSB . "*" . $this->input->post('detilPelanggaransB') . "*" . join("*", $pusatSB['HASIL_PUSAT']) . "*" . rtrim(join("^", $pusatSB['TL_PUSAT']), "^") . "*" . rtrim(join("^", $pusatSB['DETAIL_PUSAT']), "^") . "*" . $justifikasiSB);
			else
			    $SBarr = array('BLISTER' => '**');
		    }
		    $penandaanObat = array_merge($BLarr, $BRarr, $ASarr, $ETarr, $SBarr, $V1arr, $V2arr);
		}
	    } else {
		$penandaanObat = array('BUNGKUS_LUAR' => $lampiran['FILE_PENANDAAN_BL'] . "*" . $dataBL . "*" . $this->input->post('detilPelanggaranbL'), 'ETIKET' => $lampiran['FILE_PENANDAAN_ET'] . "*" . $dataET . "*" . $this->input->post('detilPelanggaraneT'), 'AMPUL_VIAL10ML' => $lampiran['FILE_PENANDAAN_V1'] . "*" . $dataV1 . "*" . $this->input->post('detilPelanggaranv1'), 'AMPUL_VIAL9ML' => $lampiran['FILE_PENANDAAN_V2'] . "*" . $dataV2 . "*" . $this->input->post('detilPelanggaranv2'), 'BROSUR' => $lampiran['FILE_PENANDAAN_BR'] . "*" . $dataBR . "*" . $this->input->post('detilPelanggaranbR'), 'BLISTER' => $lampiran['FILE_PENANDAAN_SB'] . "*" . $dataSB . "*" . $this->input->post('detilPelanggaransB'), 'AMPLOP' => $lampiran['FILE_PENANDAAN_AS'] . "*" . $dataAS . "*" . $this->input->post('detilPelanggaranaS'));
	    }
	    $this->db->where(array("PENANDAAN_ID" => $penandaan_id));
	    $this->db->update('T_PENANDAAN_OBAT', $penandaanObat);
	    if ($this->db->affected_rows() > 0) {
		$case = 'YESPENANDAANOBAT';
	    }
	}
	if ($case == 'YESPENANDAANOBAT') {
	    if ($status == '20502' || $status == '20512')
		$ret = "MSG#YES#Data perbaikan penandaan berhasil dikirim#" . site_url() . '/penandaan/penandaanController/setListFormPenandaanLanjutan/1101/' . $this->input->post("TUJUAN");
	    else if ($status == '30504' || $status == '30514' || $status == '30511' || $status == '30501')
		$ret = "MSG#YES#Data perbaikan penandaan berhasil dikirim#" . site_url() . '/penandaan/penandaanController/setListFormPenandaanLanjutan/1212/' . $this->input->post("TUJUAN");
	    else
		$ret = "MSG#YES#Data perbaikan penandaan berhasil disimpan#" . site_url() . '/penandaan/penandaanController/setListFormPenandaanLanjutan/1101/' . $this->input->post("TUJUAN");
	}
	return $ret;
    }

    function deleteData($id) {
	$suratId = $this->db->select('SURAT_ID')->get_where('T_PENANDAAN', array('PENANDAAN_ID' => $id))->row()->SURAT_ID;
	$this->db->where(array("SURAT_ID" => $suratId));
	$this->db->delete('T_SURAT_TUGAS_PENANDAAN');
	$tables = array('T_PENANDAAN_PROSES', 'T_PENANDAAN_OBAT', 'T_PENANDAAN_PRODUK', 'T_PENANDAAN');
	$this->db->where(array("PENANDAAN_ID" => $id));
	$this->db->delete($tables);
	return true;
    }

    function getPreview($klasfikasi, $jenisPelaporan, $idPengawasan) {
	$sipt = & get_instance();
	$this->load->model("main", "main", true);
	$urlId = explode('/', $_SERVER['PATH_INFO']);
	$query = "SELECT TPO.BUNGKUS_LUAR, TPO.ETIKET, TPO.AMPUL_VIAL10ML, TPO.AMPUL_VIAL9ML, TPO.BROSUR, TPO.AMPLOP, TPO.BLISTER, TP.PENANDAAN_ID, TP.BBPOM_ID, CONVERT(VARCHAR(10), TP.TANGGAL_MULAI, 120) AS TANGGAL_MULAI, CONVERT(VARCHAR(10), TP.TANGGAL_AKHIR, 120) AS TANGGAL_AKHIR, TP.SURAT_ID, TP.STATUS FROM T_PENANDAAN TP LEFT JOIN T_PENANDAAN_OBAT TPO ON TPO.PENANDAAN_ID = TP.PENANDAAN_ID WHERE TPO.PENANDAAN_ID = '" . $idPengawasan . "'";
	$data = $sipt->main->get_result($query);
	if ($data) {
	    foreach ($query->result_array() as $row) {
		$arrdata = array('sess' => $row, 'judul' => 'Obat');
	    }
	    $arrdata['tombol'] = 'Lihat Data Pengawasan';
	    $arrdata['yesBtn'] = "YES";
	    $arrdata['act'] = site_url() . '/penandaan/penandaanController/prosesPreview/preview/' . $row['PENANDAAN_ID'] . '/001/' . $row['STATUS'] . '/' . $row['BBPOM_ID'];
	    $arrdata['histori_petugas'] = site_url() . '/load/petugas/get_petugas_2/' . $row['SURAT_ID'] . '/T_SURAT_TUGAS_PENANDAAN';
	}
	return $arrdata;
    }

    function inputPreview($jenis, $penandaanId, $status, $klasifikasi, $subid = "", $user = "", $bbpom = "") {
	$sipt = & get_instance();
	$this->load->model("main", "main", true);
	$sipt->load->model('penandaan/penandaan_act');
	$btn = "N";
	$isEditTLPusat = "NO";
	$urlId = explode('/', $_SERVER['PATH_INFO']);
	if ($urlId[3] == 'prosesEdit' && ((in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')) && in_array($bbpom, $this->config->item('cfg_unit'))) || (!in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')) && !in_array($bbpom, $this->config->item('cfg_unit')))))
	    $tglQuery = "TP.TANGGAL_MULAI, 103) AS TANGGAL_MULAI, CONVERT(VARCHAR(10), TP.TANGGAL_AKHIR, 103) AS TANGGAL_AKHIR";
	else
	    $tglQuery = "TP.TANGGAL_MULAI, 120) AS TANGGAL_MULAI, CONVERT(VARCHAR(10), TP.TANGGAL_AKHIR, 120) AS TANGGAL_AKHIR";
	$query = "SELECT TSTP.SURAT_ID, CONVERT(VARCHAR(10), TSTP.TANGGAL, 103) AS TGL_SURAT, TPO.BUNGKUS_LUAR, TPO.ETIKET, TPO.AMPUL_VIAL10ML, TPO.AMPUL_VIAL9ML, TPO.BROSUR, TPO.AMPLOP, TPO.BLISTER, TP.PENANDAAN_ID, CONVERT(VARCHAR(10), " . $tglQuery . ", TP.STATUS, TP.KOMODITI, TP.SARANA_ID, TP.BBPOM_ID, TPP.NAMA_PRODUK, TPP.KLASIFIKASI_PRODUK, TPP.BENTUK_SEDIAAN, TPP.BESAR_KEMASAN, TPP.KOMPOSISI, TPP.KLASIFIKASI_PENDAFTAR, TPP.PRODUSEN, TPP.PENDAFTAR, TPP.NOMOR_IZIN_EDAR, TPP.GOLONGAN_PRODUK, TPP.NOMOR_PRODUK, MS.NAMA_SARANA, MS.ALAMAT_1, (SELECT MP1.NAMA_PROPINSI FROM M_PROPINSI MP1 WHERE MP1.PROPINSI_ID = MS.PROPINSI) AS PROPINSI, (SELECT MP2.NAMA_PROPINSI FROM M_PROPINSI MP2 WHERE MP2.PROPINSI_ID = MS.KOTA) AS KOTA FROM T_PENANDAAN TP LEFT JOIN T_PENANDAAN_OBAT TPO ON TPO.PENANDAAN_ID = TP.PENANDAAN_ID LEFT JOIN T_PENANDAAN_PRODUK TPP ON TPP.PENANDAAN_ID = TP.PENANDAAN_ID LEFT JOIN T_SURAT_TUGAS_PENANDAAN TSTP ON TSTP.SURAT_ID = TP.SURAT_ID LEFT JOIN M_SARANA MS ON MS.SARANA_ID = TP.SARANA_ID WHERE TP.PENANDAAN_ID = '" . $penandaanId . "'";
	$data = $sipt->main->get_result($query);
	if ($data) {
	    foreach ($query->result_array() as $row) {
		$arrdata = array('sess' => $row, 'judul' => 'Obat');
		$arrdata['asalProduk'] = $sipt->penandaan_act->asalProduk($row['NOMOR_IZIN_EDAR'], "1");
	    }
	    $arrdata['histori_petugas'] = site_url() . '/load/petugas/get_petugas_2/' . $row['SURAT_ID'] . '/T_SURAT_TUGAS_PENANDAAN';
	}
	if (array_key_exists('2', $this->newsession->userdata('SESS_KODE_ROLE')) && ($subid == '0101' || $subid == '1101') && $arrdata['sess']['BBPOM_ID'] && $jenis != 'preview')
	    $isEditTLPusat = "YES";
	else if ($subid == '1111')
	    $isEditTLPusat = "YES";
	if (in_array('2', $this->newsession->userdata('SESS_KODE_ROLE')) && $user == '2') {
	    $arrayClause = array('20501', '20502', '20503', '20511', '20515', '30504', '20512');
	} else if (in_array('3', $this->newsession->userdata('SESS_KODE_ROLE')) && $user == '3') {
	    $arrayClause = array('30501', '30502', '30503', '30504', '30511', '30512', '30513', '30514');
	} else if (in_array('4', $this->newsession->userdata('SESS_KODE_ROLE')) && $user == '4') {
	    $arrayClause = array('40501', '40502', '40503', '40511', '40512', '40513');
	} else if (in_array('5', $this->newsession->userdata('SESS_KODE_ROLE')) && $user == '5') {
	    $arrayClause = array('50501');
	} else if (in_array('6', $this->newsession->userdata('SESS_KODE_ROLE')) && $user == '6') {
	    $arrayClause = array('60511');
	}
	$status = $status;
	$str .= '</table>';
	$arrdata ['sess2'] = $str;
	if ($status == '20502' || $status == '20512' || (($status == '20511' || $status == '20501') && $jenis == 'draft')) {
	    if ((!in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))))
		$arrdata ['act'] = site_url() . "/penandaan/penandaanController/updateStatus/" . $klasifikasi . "/1";
	    else if ((in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) && $status == '20511' && $jenis == 'draft')
		$arrdata ['act'] = site_url() . "/penandaan/penandaanController/updateStatus/" . $klasifikasi . "/1";
	    else
		$arrdata ['act'] = site_url() . "/penandaan/penandaanController/setStatus/1";
	    $arrdata ['subJudul'] = '- OBAT EDIT';
	}
	else
	    $arrdata ['act'] = site_url() . "/penandaan/penandaanController/setStatus/1";
	$arrdata ['status'] = $sipt->main->set_verifikasi($status, $this->newsession->userdata('SESS_JENIS_PELAPORAN'), $this->newsession->userdata('SESS_KODE_ROLE'));
	$arrdata ['disverifikasi'] = $status;
	$arrdata ['objStatus'] = 'TO';
	$arrdata['obj_distribusi'] = 'PENANDAANOBAT';
	$arrdata ['cb_tindakan'] = $sipt->main->referensi("TL_DISTRIBUSI", "01,02", TRUE, FALSE);
	$arrdata ['cancel'] = site_url() . '/penandaan/penandaanController/setListFormPenandaanLanjutan/' . $user;
	$arrdata ['labelSimpan'] = 'Proses Data Perbaikan Pengawasan';
	$arrdata ['icon'] = 'check';
	$arrdata['tujuan'] = $user;
	$arrdata ['editTL'] = $isEditTLPusat;
	if (($subid == '1101' || $subid == '0101') && $jenis != 'preview') {
	    $arrdata ['subJudul'] = '- OBAT EDIT';
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
	$arrayTL[''] = NULL;
	$arrayTL['TL'] = 'Tindak Lanjut';
	$arrayTL['STL'] = 'Sudah Tindak Lanjut';
	$arrayTL['TTL'] = 'Tidak Dapat Tindak Lanjut';
	$arrdata ['cb_tl'] = $arrayTL;
	$arrdata ['golongan_obat'] = array("" => "", "Bebas" => "Bebas", "Bebas Terbatas" => "Bebas Terbatas", "Keras" => "Keras", "Psikotropika" => "Psikotropika", "Narkotika" => "Narkotika");
	$arrdata ['klasifikasi_obat'] = array("" => "", "Obat Nama Dagang" => "Obat Nama Dagang", "Obat Generik" => "Obat Generik");
	$arrdata ['klasifikasi_pendaftar'] = array("" => "", "Lokal" => "Lokal", "Impor" => "Impor");
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
		$filter2 .= " AND DATEDIFF(dy, 0, convert(DATETIME, TP.TANGGAL_AKHIR, 105)) <= DATEDIFF(dy, 0, convert(DATETIME, '" . $this->input->post('AKHIR') . "', 105))";
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
	    $query = "SELECT DISTINCT (REPLACE(REPLACE(MB.NAMA_BBPOM,'BALAI BESAR POM DI ', ''),'BALAI POM DI ','')) AS NAMA_BBPOM, dbo.GET_KOMODITI(TP.KOMODITI) AS KOMODITI, (SUM(CASE WHEN (TPO.BUNGKUS_LUAR LIKE '%#TMK%' AND TPO.BUNGKUS_LUAR LIKE '%*TMK%' AND (TP.BBPOM_ID IN (" . "'" . join("','", $this->config->item('cfg_unit')) . "'" . ") OR TP.STATUS = 60510)) OR (TPO.BUNGKUS_LUAR LIKE '%#MK%' AND TPO.BUNGKUS_LUAR LIKE '%*TMK%' AND (TP.BBPOM_ID IN (" . "'" . join("','", $this->config->item('cfg_unit')) . "'" . ") OR TP.STATUS = 60510)) THEN 1 ELSE 0 END) + SUM(CASE WHEN (TPO.ETIKET LIKE '%#TMK%' AND TPO.ETIKET LIKE '%*TMK%' AND (TP.BBPOM_ID IN ('') OR TP.STATUS = 60510)) OR (TPO.ETIKET LIKE '%#MK%' AND TPO.ETIKET LIKE '%*TMK%' AND (TP.BBPOM_ID IN (" . "'" . join("','", $this->config->item('cfg_unit')) . "'" . ") OR TP.STATUS = 60510)) THEN 1 ELSE 0 END) + SUM(CASE WHEN (TPO.AMPLOP LIKE '%#TMK%' AND TPO.AMPLOP LIKE '%*TMK%' AND (TP.BBPOM_ID IN (" . "'" . join("','", $this->config->item('cfg_unit')) . "'" . ") OR TP.STATUS = 60510)) OR (TPO.AMPLOP LIKE '%#MK%' AND TPO.AMPLOP LIKE '%*TMK%' AND (TP.BBPOM_ID IN (" . "'" . join("','", $this->config->item('cfg_unit')) . "'" . ") OR TP.STATUS = 60510)) THEN 1 ELSE 0 END) + SUM(CASE WHEN (TPO.AMPUL_VIAL10ML LIKE '%#TMK%' AND TPO.AMPUL_VIAL10ML LIKE '%*TMK%' AND (TP.BBPOM_ID IN (" . "'" . join("','", $this->config->item('cfg_unit')) . "'" . ") OR TP.STATUS = 60510)) OR (TPO.AMPUL_VIAL10ML LIKE '%#MK%' AND TPO.AMPUL_VIAL10ML LIKE '%*TMK%' AND (TP.BBPOM_ID IN (" . "'" . join("','", $this->config->item('cfg_unit')) . "'" . ") OR TP.STATUS = 60510)) THEN 1 ELSE 0 END) + SUM(CASE WHEN (TPO.AMPUL_VIAL9ML LIKE '%#TMK%' AND TPO.AMPUL_VIAL9ML LIKE '%*TMK%' AND (TP.BBPOM_ID IN (" . "'" . join("','", $this->config->item('cfg_unit')) . "'" . ") OR TP.STATUS = 60510)) OR (TPO.AMPUL_VIAL9ML LIKE '%#MK%' AND TPO.AMPUL_VIAL9ML LIKE '%*TMK%' AND (TP.BBPOM_ID IN (" . "'" . join("','", $this->config->item('cfg_unit')) . "'" . ") OR TP.STATUS = 60510)) THEN 1 ELSE 0 END) + SUM(CASE WHEN (TPO.BLISTER LIKE '%#TMK%' AND TPO.BLISTER LIKE '%*TMK%' AND (TP.BBPOM_ID IN (" . "'" . join("','", $this->config->item('cfg_unit')) . "'" . ") OR TP.STATUS = 60510)) OR (TPO.BLISTER LIKE '%#MK%' AND TPO.BLISTER LIKE '%*TMK%' AND (TP.BBPOM_ID IN (" . "'" . join("','", $this->config->item('cfg_unit')) . "'" . ") OR TP.STATUS = 60510)) THEN 1 ELSE 0 END) + SUM(CASE WHEN (TPO.BROSUR LIKE '%#TMK%' AND TPO.BROSUR LIKE '%*TMK%' AND (TP.BBPOM_ID IN (" . "'" . join("','", $this->config->item('cfg_unit')) . "'" . ") OR TP.STATUS = 60510)) OR (TPO.BROSUR LIKE '%#MK%' AND TPO.BROSUR LIKE '%*TMK%' AND (TP.BBPOM_ID IN (" . "'" . join("','", $this->config->item('cfg_unit')) . "'" . ") OR TP.STATUS = 60510)) THEN 1 ELSE 0 END)) AS TMK_P, (SUM(CASE WHEN (TPO.BUNGKUS_LUAR LIKE '%#TMK%' AND TPO.BUNGKUS_LUAR LIKE '%*MK%' AND (TP.BBPOM_ID IN (" . "'" . join("','", $this->config->item('cfg_unit')) . "'" . ") OR TP.STATUS = 60510)) OR (TPO.BUNGKUS_LUAR LIKE '%#MK%' AND TPO.BUNGKUS_LUAR LIKE '%*MK%' AND (TP.BBPOM_ID IN (" . "'" . join("','", $this->config->item('cfg_unit')) . "'" . ") OR TP.STATUS = 60510)) THEN 1 ELSE 0 END) + SUM(CASE WHEN(TPO.ETIKET LIKE '%#TMK%' AND TPO.ETIKET LIKE '%*MK%' AND (TP.BBPOM_ID IN (" . "'" . join("','", $this->config->item('cfg_unit')) . "'" . ") OR TP.STATUS = 60510)) OR (TPO.ETIKET LIKE '%#MK%' AND TPO.ETIKET LIKE '%*MK%' AND (TP.BBPOM_ID IN (" . "'" . join("','", $this->config->item('cfg_unit')) . "'" . ") OR TP.STATUS = 60510)) THEN 1 ELSE 0 END) + SUM(CASE WHEN (TPO.AMPLOP LIKE '%#TMK%' AND TPO.AMPLOP LIKE '%*MK%' AND (TP.BBPOM_ID IN (" . "'" . join("','", $this->config->item('cfg_unit')) . "'" . ") OR TP.STATUS = 60510)) OR (TPO.AMPLOP LIKE '%#MK%' AND TPO.AMPLOP LIKE '%*MK%' AND (TP.BBPOM_ID IN (" . "'" . join("','", $this->config->item('cfg_unit')) . "'" . ") OR TP.STATUS = 60510)) THEN 1 ELSE 0 END) + SUM(CASE WHEN (TPO.AMPUL_VIAL10ML LIKE '%#TMK%' AND TPO.AMPUL_VIAL10ML LIKE '%*MK%' AND (TP.BBPOM_ID IN (" . "'" . join("','", $this->config->item('cfg_unit')) . "'" . ") OR TP.STATUS = 60510)) OR (TPO.AMPUL_VIAL10ML LIKE '%#MK%' AND TPO.AMPUL_VIAL10ML LIKE '%*MK%' AND (TP.BBPOM_ID IN (" . "'" . join("','", $this->config->item('cfg_unit')) . "'" . ") OR TP.STATUS = 60510)) THEN 1 ELSE 0 END) + SUM(CASE WHEN (TPO.AMPUL_VIAL9ML LIKE '%#TMK%' AND TPO.AMPUL_VIAL9ML LIKE '%*MK%' AND (TP.BBPOM_ID IN (" . "'" . join("','", $this->config->item('cfg_unit')) . "'" . ") OR TP.STATUS = 60510)) OR (TPO.AMPUL_VIAL9ML LIKE '%#MK%' AND TPO.AMPUL_VIAL9ML LIKE '%*MK%' AND (TP.BBPOM_ID IN (" . "'" . join("','", $this->config->item('cfg_unit')) . "'" . ") OR TP.STATUS = 60510)) THEN 1 ELSE 0 END) + SUM(CASE WHEN (TPO.BLISTER LIKE '%#TMK%' AND TPO.BLISTER LIKE '%*MK%' AND (TP.BBPOM_ID IN (" . "'" . join("','", $this->config->item('cfg_unit')) . "'" . ") OR TP.STATUS = 60510)) OR (TPO.BLISTER LIKE '%#MK%' AND TPO.BLISTER LIKE '%*MK%' AND (TP.BBPOM_ID IN (" . "'" . join("','", $this->config->item('cfg_unit')) . "'" . ") OR TP.STATUS = 60510)) THEN 1 ELSE 0 END) + SUM(CASE WHEN (TPO.BROSUR LIKE '%#TMK%' AND TPO.BROSUR LIKE '%*MK%' AND (TP.BBPOM_ID IN (" . "'" . join("','", $this->config->item('cfg_unit')) . "'" . ") OR TP.STATUS = 60510)) OR (TPO.BROSUR LIKE '%#MK%' AND TPO.BROSUR LIKE '%*MK%' AND (TP.BBPOM_ID IN (" . "'" . join("','", $this->config->item('cfg_unit')) . "'" . ") OR TP.STATUS = 60510)) THEN 1 ELSE 0 END)) AS MK_P, (SUM(CASE WHEN (TPO.BUNGKUS_LUAR LIKE '%#TMK%' AND TP.BBPOM_ID NOT IN (" . "'" . join("','", $this->config->item('cfg_unit')) . "'" . ") AND TP.STATUS <> 60510) THEN 1 ELSE 0 END) + SUM(CASE WHEN (TPO.ETIKET LIKE '%#TMK%' AND TP.BBPOM_ID NOT IN (" . "'" . join("','", $this->config->item('cfg_unit')) . "'" . ") AND TP.STATUS <> 60510) THEN 1 ELSE 0 END) + SUM(CASE WHEN (TPO.AMPLOP LIKE '%#TMK%' AND TP.BBPOM_ID NOT IN (" . "'" . join("','", $this->config->item('cfg_unit')) . "'" . ") AND TP.STATUS <> 60510) THEN 1 ELSE 0 END) + SUM(CASE WHEN (TPO.AMPUL_VIAL10ML LIKE '%#TMK%' AND TP.BBPOM_ID NOT IN (" . "'" . join("','", $this->config->item('cfg_unit')) . "'" . ") AND TP.STATUS <> 60510) THEN 1 ELSE 0 END) + SUM(CASE WHEN (TPO.AMPUL_VIAL9ML LIKE '%#TMK%' AND TP.BBPOM_ID NOT IN (" . "'" . join("','", $this->config->item('cfg_unit')) . "'" . ") AND TP.STATUS <> 60510) THEN 1 ELSE 0 END) + SUM(CASE WHEN (TPO.BLISTER LIKE '%#TMK%' AND TP.BBPOM_ID NOT IN (" . "'" . join("','", $this->config->item('cfg_unit')) . "'" . ") AND TP.STATUS <> 60510) THEN 1 ELSE 0 END) + SUM(CASE WHEN (TPO.BROSUR LIKE '%#TMK%' AND TP.BBPOM_ID NOT IN (" . "'" . join("','", $this->config->item('cfg_unit')) . "'" . ") AND TP.STATUS <> 60510) THEN 1 ELSE 0 END)) AS TMK_B, (SUM(CASE WHEN (TPO.BUNGKUS_LUAR LIKE '%#MK%' AND TP.BBPOM_ID NOT IN (" . "'" . join("','", $this->config->item('cfg_unit')) . "'" . ") AND TP.STATUS <> 60510) THEN 1 ELSE 0 END) + SUM(CASE WHEN(TPO.ETIKET LIKE '%#MK%' AND TP.BBPOM_ID NOT IN (" . "'" . join("','", $this->config->item('cfg_unit')) . "'" . ") AND TP.STATUS <> 60510) THEN 1 ELSE 0 END) + SUM(CASE WHEN (TPO.AMPLOP LIKE '%#MK%' AND TP.BBPOM_ID NOT IN (" . "'" . join("','", $this->config->item('cfg_unit')) . "'" . ") AND TP.STATUS <> 60510) THEN 1 ELSE 0 END) + SUM(CASE WHEN (TPO.AMPUL_VIAL10ML LIKE '%#MK%' AND TP.BBPOM_ID NOT IN (" . "'" . join("','", $this->config->item('cfg_unit')) . "'" . ") AND TP.STATUS <> 60510) THEN 1 ELSE 0 END) + SUM(CASE WHEN (TPO.AMPUL_VIAL9ML LIKE '%#MK%' AND TP.BBPOM_ID NOT IN (" . "'" . join("','", $this->config->item('cfg_unit')) . "'" . ") AND TP.STATUS <> 60510) THEN 1 ELSE 0 END) + SUM(CASE WHEN (TPO.BLISTER LIKE '%#MK%' AND TP.BBPOM_ID NOT IN (" . "'" . join("','", $this->config->item('cfg_unit')) . "'" . ") AND TP.STATUS <> 60510) THEN 1 ELSE 0 END) + SUM(CASE WHEN (TPO.BROSUR LIKE '%#MK%' AND TP.BBPOM_ID NOT IN (" . "'" . join("','", $this->config->item('cfg_unit')) . "'" . ") AND TP.STATUS <> 60510) THEN 1 ELSE 0 END)) AS MK_B, (SUM(CASE WHEN TPO.BUNGKUS_LUAR LIKE '%^Peringatan Keras%' AND (TP.BBPOM_ID IN (" . "'" . join("','", $this->config->item('cfg_unit')) . "'" . ") OR TP.STATUS = 60510) AND TPO.BUNGKUS_LUAR LIKE '%*TL%' THEN 1 ELSE 0 END) + SUM(CASE WHEN TPO.AMPLOP LIKE '%^Peringatan Keras%' AND (TP.BBPOM_ID IN (" . "'" . join("','", $this->config->item('cfg_unit')) . "'" . ") OR TP.STATUS = 60510) AND TPO.AMPLOP LIKE '%*TL%' THEN 1 ELSE 0 END) + SUM(CASE WHEN TPO.ETIKET LIKE '%^Peringatan Keras%' AND (TP.BBPOM_ID IN (" . "'" . join("','", $this->config->item('cfg_unit')) . "'" . ") OR TP.STATUS = 60510) AND TPO.ETIKET LIKE '%*TL%' THEN 1 ELSE 0 END) + SUM(CASE WHEN TPO.AMPUL_VIAL10ML LIKE '%^Peringatan Keras%' AND (TP.BBPOM_ID IN (" . "'" . join("','", $this->config->item('cfg_unit')) . "'" . ") OR TP.STATUS = 60510) AND TPO.AMPUL_VIAL10ML LIKE '%*TL%' THEN 1 ELSE 0 END) + SUM(CASE WHEN TPO.AMPUL_VIAL9ML LIKE '%^Peringatan Keras%' AND (TP.BBPOM_ID IN (" . "'" . join("','", $this->config->item('cfg_unit')) . "'" . ") OR TP.STATUS = 60510) AND TPO.AMPUL_VIAL9ML LIKE '%*TL%' THEN 1 ELSE 0 END) + SUM(CASE WHEN TPO.BLISTER LIKE '%^Peringatan Keras%' AND (TP.BBPOM_ID IN (" . "'" . join("','", $this->config->item('cfg_unit')) . "'" . ") OR TP.STATUS = 60510) AND TPO.BLISTER LIKE '%*TL%' THEN 1 ELSE 0 END) + SUM(CASE WHEN TPO.BROSUR LIKE '%^Peringatan Keras%' AND (TP.BBPOM_ID IN (" . "'" . join("','", $this->config->item('cfg_unit')) . "'" . ") OR TP.STATUS = 60510) AND TPO.BROSUR LIKE '%*TL%' THEN 1 ELSE 0 END)) AS 'KERASTL', (SUM(CASE WHEN ((TPO.BUNGKUS_LUAR LIKE '%^Peringatan%' AND TPO.BUNGKUS_LUAR NOT LIKE '%^Peringatan Keras%') OR (TPO.BUNGKUS_LUAR LIKE '%^Peringatan^%')) AND (TP.BBPOM_ID IN (" . "'" . join("','", $this->config->item('cfg_unit')) . "'" . ") OR TP.STATUS = 60510) AND TPO.BUNGKUS_LUAR LIKE '%*TL%' THEN 1 ELSE 0 END) + SUM(CASE WHEN ((TPO.ETIKET LIKE '%^Peringatan%' AND TPO.ETIKET NOT LIKE '%^Peringatan Keras%') OR (TPO.ETIKET LIKE '%^Peringatan^%')) AND (TP.BBPOM_ID IN (" . "'" . join("','", $this->config->item('cfg_unit')) . "'" . ") OR TP.STATUS = 60510) AND TPO.ETIKET LIKE '%*TL%' THEN 1 ELSE 0 END) + SUM(CASE WHEN ((TPO.AMPLOP LIKE '%^Peringatan%' AND TPO.AMPLOP NOT LIKE '%^Peringatan Keras%') OR (TPO.AMPLOP LIKE '%^Peringatan^%')) AND (TP.BBPOM_ID IN (" . "'" . join("','", $this->config->item('cfg_unit')) . "'" . ") OR TP.STATUS = 60510) AND TPO.AMPLOP LIKE '%*TL%' THEN 1 ELSE 0 END) + SUM(CASE WHEN ((TPO.AMPUL_VIAL10ML LIKE '%^Peringatan%' AND TPO.AMPUL_VIAL10ML NOT LIKE '%^Peringatan Keras%') OR (TPO.AMPUL_VIAL10ML LIKE '%^Peringatan^%')) AND (TP.BBPOM_ID IN (" . "'" . join("','", $this->config->item('cfg_unit')) . "'" . ") OR TP.STATUS = 60510) AND TPO.AMPUL_VIAL10ML LIKE '%*TL%' THEN 1 ELSE 0 END) + SUM(CASE WHEN ((TPO.AMPUL_VIAL9ML LIKE '%^Peringatan%' AND TPO.AMPUL_VIAL9ML NOT LIKE '%^Peringatan Keras%') OR (TPO.AMPUL_VIAL9ML LIKE '%^Peringatan^%')) AND (TP.BBPOM_ID IN (" . "'" . join("','", $this->config->item('cfg_unit')) . "'" . ") OR TP.STATUS = 60510) AND TPO.AMPUL_VIAL9ML LIKE '%*TL%' THEN 1 ELSE 0 END) + SUM(CASE WHEN ((TPO.BLISTER LIKE '%^Peringatan%' AND TPO.BLISTER NOT LIKE '%^Peringatan Keras%') OR (TPO.BLISTER LIKE '%^Peringatan^%')) AND (TP.BBPOM_ID IN (" . "'" . join("','", $this->config->item('cfg_unit')) . "'" . ") OR TP.STATUS = 60510) AND TPO.BLISTER LIKE '%*TL%' THEN 1 ELSE 0 END) + SUM(CASE WHEN ((TPO.BROSUR LIKE '%^Peringatan%' AND TPO.BROSUR NOT LIKE '%^Peringatan Keras%') OR (TPO.BROSUR LIKE '%^Peringatan^%')) AND (TP.BBPOM_ID IN (" . "'" . join("','", $this->config->item('cfg_unit')) . "'" . ") OR TP.STATUS = 60510) AND TPO.BROSUR LIKE '%*TL%' THEN 1 ELSE 0 END)) AS 'PERINGATANTL',(SUM(CASE WHEN TPO.BUNGKUS_LUAR LIKE '%^Peringatan Keras%' AND (TP.BBPOM_ID IN (" . "'" . join("','", $this->config->item('cfg_unit')) . "'" . ") OR TP.STATUS = 60510) AND TPO.BUNGKUS_LUAR LIKE '%*STL%' THEN 1 ELSE 0 END) + SUM(CASE WHEN TPO.AMPLOP LIKE '%^Peringatan Keras%' AND (TP.BBPOM_ID IN (" . "'" . join("','", $this->config->item('cfg_unit')) . "'" . ") OR TP.STATUS = 60510) AND TPO.AMPLOP LIKE '%*STL%' THEN 1 ELSE 0 END) + SUM(CASE WHEN TPO.ETIKET LIKE '%^Peringatan Keras%' AND (TP.BBPOM_ID IN (" . "'" . join("','", $this->config->item('cfg_unit')) . "'" . ") OR TP.STATUS = 60510) AND TPO.ETIKET LIKE '%*STL%' THEN 1 ELSE 0 END) + SUM(CASE WHEN TPO.AMPUL_VIAL10ML LIKE '%^Peringatan Keras%' AND (TP.BBPOM_ID IN (" . "'" . join("','", $this->config->item('cfg_unit')) . "'" . ") OR TP.STATUS = 60510) AND TPO.AMPUL_VIAL10ML LIKE '%*STL%' THEN 1 ELSE 0 END) + SUM(CASE WHEN TPO.AMPUL_VIAL9ML LIKE '%^Peringatan Keras%' AND (TP.BBPOM_ID IN (" . "'" . join("','", $this->config->item('cfg_unit')) . "'" . ") OR TP.STATUS = 60510) AND TPO.AMPUL_VIAL9ML LIKE '%*STL%' THEN 1 ELSE 0 END) + SUM(CASE WHEN TPO.BLISTER LIKE '%^Peringatan Keras%' AND (TP.BBPOM_ID IN (" . "'" . join("','", $this->config->item('cfg_unit')) . "'" . ") OR TP.STATUS = 60510) AND TPO.BLISTER LIKE '%*STL%' THEN 1 ELSE 0 END) + SUM(CASE WHEN TPO.BROSUR LIKE '%^Peringatan Keras%' AND (TP.BBPOM_ID IN (" . "'" . join("','", $this->config->item('cfg_unit')) . "'" . ") OR TP.STATUS = 60510) AND TPO.BROSUR LIKE '%*STL%' THEN 1 ELSE 0 END)) AS 'KERASSTL', (SUM(CASE WHEN ((TPO.BUNGKUS_LUAR LIKE '%^Peringatan%' AND TPO.BUNGKUS_LUAR NOT LIKE '%^Peringatan Keras%') OR (TPO.BUNGKUS_LUAR LIKE '%^Peringatan^%')) AND (TP.BBPOM_ID IN (" . "'" . join("','", $this->config->item('cfg_unit')) . "'" . ") OR TP.STATUS = 60510) AND TPO.BUNGKUS_LUAR LIKE '%*STL%' THEN 1 ELSE 0 END) + SUM(CASE WHEN ((TPO.ETIKET LIKE '%^Peringatan%' AND TPO.ETIKET NOT LIKE '%^Peringatan Keras%') OR (TPO.ETIKET LIKE '%^Peringatan^%')) AND (TP.BBPOM_ID IN (" . "'" . join("','", $this->config->item('cfg_unit')) . "'" . ") OR TP.STATUS = 60510) AND TPO.ETIKET LIKE '%*STL%' THEN 1 ELSE 0 END) + SUM(CASE WHEN ((TPO.AMPLOP LIKE '%^Peringatan%' AND TPO.AMPLOP NOT LIKE '%^Peringatan Keras%') OR (TPO.AMPLOP LIKE '%^Peringatan^%')) AND (TP.BBPOM_ID IN (" . "'" . join("','", $this->config->item('cfg_unit')) . "'" . ") OR TP.STATUS = 60510) AND TPO.AMPLOP LIKE '%*STL%' THEN 1 ELSE 0 END) + SUM(CASE WHEN ((TPO.AMPUL_VIAL10ML LIKE '%^Peringatan%' AND TPO.AMPUL_VIAL10ML NOT LIKE '%^Peringatan Keras%') OR (TPO.AMPUL_VIAL10ML LIKE '%^Peringatan^%')) AND (TP.BBPOM_ID IN (" . "'" . join("','", $this->config->item('cfg_unit')) . "'" . ") OR TP.STATUS = 60510) AND TPO.AMPUL_VIAL10ML LIKE '%*STL%' THEN 1 ELSE 0 END) + SUM(CASE WHEN ((TPO.AMPUL_VIAL9ML LIKE '%^Peringatan%' AND TPO.AMPUL_VIAL9ML NOT LIKE '%^Peringatan Keras%') OR (TPO.AMPUL_VIAL9ML LIKE '%^Peringatan^%')) AND (TP.BBPOM_ID IN (" . "'" . join("','", $this->config->item('cfg_unit')) . "'" . ") OR TP.STATUS = 60510) AND TPO.AMPUL_VIAL9ML LIKE '%*STL%' THEN 1 ELSE 0 END) + SUM(CASE WHEN ((TPO.BLISTER LIKE '%^Peringatan%' AND TPO.BLISTER NOT LIKE '%^Peringatan Keras%') OR (TPO.BLISTER LIKE '%^Peringatan^%')) AND (TP.BBPOM_ID IN (" . "'" . join("','", $this->config->item('cfg_unit')) . "'" . ") OR TP.STATUS = 60510) AND TPO.BLISTER LIKE '%*STL%' THEN 1 ELSE 0 END) + SUM(CASE WHEN ((TPO.BROSUR LIKE '%^Peringatan%' AND TPO.BROSUR NOT LIKE '%^Peringatan Keras%') OR (TPO.BROSUR LIKE '%^Peringatan^%')) AND (TP.BBPOM_ID IN (" . "'" . join("','", $this->config->item('cfg_unit')) . "'" . ") OR TP.STATUS = 60510) AND TPO.BROSUR LIKE '%*STL%' THEN 1 ELSE 0 END)) AS 'PERINGATANSTL', (SUM(CASE WHEN (TP.BBPOM_ID IN (" . "'" . join("','", $this->config->item('cfg_unit')) . "'" . ") OR TP.STATUS = 60510) AND TPO.BUNGKUS_LUAR LIKE '%*TTL%' THEN 1 ELSE 0 END) + SUM(CASE WHEN (TP.BBPOM_ID IN (" . "'" . join("','", $this->config->item('cfg_unit')) . "'" . ") OR TP.STATUS = 60510) AND TPO.AMPLOP LIKE '%*TTL%' THEN 1 ELSE 0 END) + SUM(CASE WHEN (TP.BBPOM_ID IN (" . "'" . join("','", $this->config->item('cfg_unit')) . "'" . ") OR TP.STATUS = 60510) AND TPO.ETIKET LIKE '%*TTL%' THEN 1 ELSE 0 END) + SUM(CASE WHEN (TP.BBPOM_ID IN (" . "'" . join("','", $this->config->item('cfg_unit')) . "'" . ") OR TP.STATUS = 60510) AND TPO.AMPUL_VIAL10ML LIKE '%*TTL%' THEN 1 ELSE 0 END) + SUM(CASE WHEN (TP.BBPOM_ID IN (" . "'" . join("','", $this->config->item('cfg_unit')) . "'" . ") OR TP.STATUS = 60510) AND TPO.AMPUL_VIAL9ML LIKE '%*TTL%' THEN 1 ELSE 0 END) + SUM(CASE WHEN (TP.BBPOM_ID IN (" . "'" . join("','", $this->config->item('cfg_unit')) . "'" . ") OR TP.STATUS = 60510) AND TPO.BLISTER LIKE '%*TTL%' THEN 1 ELSE 0 END) + SUM(CASE WHEN (TP.BBPOM_ID IN (" . "'" . join("','", $this->config->item('cfg_unit')) . "'" . ") OR TP.STATUS = 60510) AND TPO.BROSUR LIKE '%*TTL%' THEN 1 ELSE 0 END)) AS 'TTL' FROM T_PENANDAAN TP LEFT JOIN T_PENANDAAN_OBAT TPO ON TPO.PENANDAAN_ID = TP.PENANDAAN_ID LEFT JOIN M_BBPOM MB ON TP.BBPOM_ID = MB.BBPOM_ID WHERE $filter2 AND TP.KOMODITI = '001' GROUP BY  MB.BBPOM_ID, MB.NAMA_BBPOM, TP.KOMODITI ORDER BY 1";
	    $this->newphpexcel->set_font('Calibri', 10);
	    $this->newphpexcel->setActiveSheetIndex(0);
	    $this->newphpexcel->set_title('RHPK Pengawasan Pengawasan');
	    $this->newphpexcel->mergecell(array(array('A1', 'J1'), array('A2', 'J2'), array('A3', 'J3'), array('A4', 'J4'), array('C6', 'E6'), array('F6', 'G6'), array('H6', 'I6')), TRUE);
	    $this->newphpexcel->mergecell(array(array('B6', 'B7'), array('A6', 'A7'), array('J6', 'J7')), FALSE);
	    $this->newphpexcel->width(array(array('A', 4), array('B', 35), array('C', 11), array('D', 11), array('E', 11), array('F', 11), array('G', 11), array('H', 11), array('I', 11), array('J', 15)));
	    $this->newphpexcel->set_bold(array('A1', 'A2', 'A3', 'A4'));
	    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A1', 'REKAPITULASI HASIL PELAKSANAAN KEGIATAN - PENGAWASAN PENANDAAN - OBAT')->setCellValue('A2', $judul)->setCellValue('A3', strtoupper($balai))->setCellValue('A4', 'PERIODE : ' . $awal . ' s.d ' . $akhir);
	    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A6', 'No.')->setCellValue('B6', 'BBPOM')->setCellValue('C6', 'Total')->setCellValue('F6', 'Tindak Lanjut')->setCellValue('H6', 'Sudah Tindak Lanjut')->setCellValue('J6', 'Tidak Dapat Tindak Lanjut')->setCellValue('C7', 'Diperiksa')->setCellValue('D7', 'MK')->setCellValue('E7', 'TMK')->setCellValue('F7', 'Peringatan')->setCellValue('G7', 'Peringatan Keras')->setCellValue('H7', 'Peringatan')->setCellValue('I7', 'Peringatan Keras');
	    $this->newphpexcel->headings(array('A6', 'B6', 'C6', 'D6', 'E6', 'F6', 'G6', 'H6', 'I6', 'J6'));
	    $this->newphpexcel->headings(array('A7', 'B7', 'C7', 'D7', 'E7', 'F7', 'G7', 'H7', 'I7', 'J7'));
	    $this->newphpexcel->set_wrap(array('B6', 'G7', 'J6', 'J7'));
	    $this->newphpexcel->getActiveSheet()->getStyle('G')->getAlignment()->setWrapText(true);
	    $data = $sipt->main->get_result($query);
	    if ($data) {
		$no = 1;
		$rec = 8;
		foreach ($query->result_array() as $row) {
		    $total = $row['MK_P'] + $row['MK_B'] + $row['TMK_P'] + $row['TMK_B'];
		    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A' . $rec, $no)->setCellValue('B' . $rec, $row["NAMA_BBPOM"])->setCellValue('C' . $rec, $total)->setCellValue('D' . $rec, $row["MK_P"] + $row["MK_B"])->setCellValue('E' . $rec, $row["TMK_P"] + $row["TMK_B"])->setCellValue('F' . $rec, $row["PERINGATANTL"])->setCellValue('G' . $rec, $row["KERASTL"])->setCellValue('H' . $rec, $row["PERINGATANSTL"])->setCellValue('I' . $rec, $row["KERASSTL"])->setCellValue('J' . $rec, $row["TTL"]);
		    $this->newphpexcel->set_detilstyle(array('A' . $rec, 'B' . $rec, 'C' . $rec, 'D' . $rec, 'E' . $rec, 'F' . $rec, 'G' . $rec, 'H' . $rec, 'I' . $rec, 'J' . $rec));
		    $this->newphpexcel->getActiveSheet()->getStyle('G' . $rec)->getAlignment()->setWrapText(true);
		    $rec++;
		    $no++;
		    $total = 0;
		}
	    } else {
		$this->newphpexcel->getActiveSheet()->mergeCells('A8:J8');
		$this->newphpexcel->set_detilstyle(array('A8'));
		$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A8', 'Data Pengawasan Penandaan Tidak Ditemukan');
	    }
	    ob_clean();
	    $file = "REKAPITULASI_PENGAWASAN_PENANDAAN_OBAT_" . str_replace(" ", "_", str_replace("-", "", $judul)) . "_" . date("YmdHis") . ".xls";
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
	    $query = "SELECT DISTINCT TP.PENANDAAN_ID, TP.BBPOM_ID,  (REPLACE(REPLACE(MB.NAMA_BBPOM,'BALAI BESAR POM DI ', ''),'BALAI POM DI ','')) AS BBPOM, MS.NAMA_SARANA, MS.ALAMAT_1, CONVERT(VARCHAR(10), TP.TANGGAL_MULAI, 105) AS TANGGAL_MULAI, CONVERT(VARCHAR(10), TP.TANGGAL_AKHIR, 105) AS TANGGAL_AKHIR, TPP.NAMA_PRODUK, TPP.NOMOR_PRODUK, TPP.KLASIFIKASI_PRODUK, TPP.BENTUK_SEDIAAN, TPP.BESAR_KEMASAN, TPP.KOMPOSISI, TPP.NOMOR_IZIN_EDAR, TPP.GOLONGAN_PRODUK, TPP.PENDAFTAR FROM T_PENANDAAN TP LEFT JOIN M_BBPOM MB ON MB.BBPOM_ID = TP.BBPOM_ID LEFT JOIN M_SARANA MS ON MS.SARANA_ID = TP.SARANA_ID LEFT JOIN T_PENANDAAN_PRODUK TPP ON TPP.PENANDAAN_ID = TP.PENANDAAN_ID LEFT JOIN T_PENANDAAN_OBAT TPO ON TPO.PENANDAAN_ID = TP.PENANDAAN_ID  WHERE $filter2 AND TP.KOMODITI = '001' GROUP BY MB.BBPOM_ID, MB.NAMA_BBPOM, TP.KOMODITI, MS.NAMA_SARANA, MS.ALAMAT_1, TP.PENANDAAN_ID, TP.BBPOM_ID, TP.TANGGAL_MULAI, TP.TANGGAL_AKHIR, TPP.NAMA_PRODUK, TPP.KLASIFIKASI_PRODUK, TPP.BENTUK_SEDIAAN, TPP.BESAR_KEMASAN, TPP.KOMPOSISI, TPP.NOMOR_IZIN_EDAR, TPP.GOLONGAN_PRODUK, TPP.PENDAFTAR, TPP.NOMOR_PRODUK ORDER BY 1";
	    $this->newphpexcel->set_font('Calibri', 10);
	    $this->newphpexcel->setActiveSheetIndex(0);
	    $this->newphpexcel->set_title('LAPORAN PENANDAAN OBAT');
	    $this->newphpexcel->mergecell(array(array('A1', 'D1'), array('A2', 'D2'), array('A3', 'D3'), array('A4', 'D4')), TRUE);
	    if (!in_array($this->input->post('BBPOM_ID'), $this->config->item('cfg_unit'))) {
		$this->newphpexcel->mergecell(array(array('A6', 'A7'), array('B6', 'B7'), array('C6', 'C7'), array('D6', 'D7'),
		    array('E6', 'E7'), array('F6', 'F7'), array('G6', 'G7'), array('H6', 'H7'), array('I6', 'I7'), array('J6', 'J7'),
		    array('K6', 'K7'), array('L6', 'L7'), array('M6', 'M7'), array('N6', 'N7'), array('O6', 'O7'), array('P6', 'P7'),
		    array('Q6', 'Q7'), array('R6', 'R7'), array('S6', 'S7'), array('T6', 'T7'), array('U6', 'U7')), TRUE);
		$this->newphpexcel->set_bold(array('A1', 'A2', 'A3', 'A4'));
		$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A1', 'LAPORAN HASIL PENGAWASAN PENANDAAN OBAT')->setCellValue('A2', $judul)->setCellValue('A3', strtoupper($balai))->setCellValue('A4', 'PERIODE : ' . $awal . ' s.d ' . $akhir);
		$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A6', 'No')->setCellValue('B6', 'Jenis Penandaan')
			->setCellValue('C6', 'Nama Sarana')->setCellValue('D6', 'Alamat Sarana')->setCellValue('E6', 'Tanggal Periksa')
			->setCellValue('F6', 'Nama Produk')->setCellValue('G6', 'Nomor Izin Edar')->setCellValue('H6', 'Klasifikasi Obat')
			->setCellValue('I6', 'Komposisi')->setCellValue('J6', 'Nama Pemilik Izin Edar')->setCellValue('K6', 'Bentuk Sediaan')
			->setCellValue('L6', 'Besar Kemasan')->setCellValue('M6', 'Golongan Obat')->setCellValue('N6', 'Nomor Bets')
			->setCellValue('O6', 'Uraian Pelanggaran')
			->setCellValue('P6', 'Hasil Balai')->setCellValue('Q6', 'Hasil Pusat')->setCellValue('R6', 'Kategori Penilaian')
			->setCellValue('S6', 'Tindak Lanjut Pusat')->setCellValue('T6', 'Justifikasi Pusat')->setCellValue('U6', 'Unit / Balai Pemeriksa');
		$this->newphpexcel->headings(array('A6', 'B6', 'C6', 'D6', 'E6', 'F6', 'G6', 'H6', 'I6', 'J6', 'K6', 'L6', 'M6', 'N6', 'O6',
		    'P6', 'Q6', 'R6', 'S6', 'T6', 'U6'));
		$this->newphpexcel->headings(array('A7', 'B7', 'C7', 'D7', 'E7', 'F7', 'G7', 'H7', 'I7', 'J7', 'K7', 'L7', 'M7', 'N7', 'O7',
		    'P7', 'Q7', 'R7', 'S7', 'T7', 'U7'));
		$this->newphpexcel->set_wrap(array('A6', 'B6', 'C6', 'D6', 'E6', 'F6', 'G6', 'H6', 'I6', 'J6', 'K6', 'L6', 'M6', 'N6', 'O6',
		    'P6', 'Q6', 'R6', 'S6', 'T6', 'U7'));
		$this->newphpexcel->width(array(array('A', 4), array('B', 28), array('C', 30), array('D', 50), array('E', 27), array('F', 27),
		    array('G', 20), array('H', 27), array('I', 27), array('J', 27), array('K', 27), array('L', 27), array('M', 20), array('N', 20),
		    array('O', 50), array('P', 15), array('Q', 15), array('R', 20), array('S', 30), array('T', 30), array('U', 33)));
		$this->newphpexcel->set_bold(array('A1', 'A2', 'A3', 'A4'));
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
			    $filterBL = " AND TPO.BUNGKUS_LUAR LIKE (CASE WHEN TP.BBPOM_ID IN (" . "'" . join("','", $this->config->item('cfg_unit')) . "'" . ") OR TP.STATUS = 60510 THEN '%*" . $filterMKTMK . "%' ELSE '%#" . $filterMKTMK . "%' END) ";
			    $filterET = " AND TPO.ETIKET LIKE (CASE WHEN TP.BBPOM_ID IN (" . "'" . join("','", $this->config->item('cfg_unit')) . "'" . ") OR TP.STATUS = 60510 THEN '%*" . $filterMKTMK . "%' ELSE '%#" . $filterMKTMK . "%' END) ";
			    $filterAV1 = " AND TPO.AMPUL_VIAL10ML LIKE (CASE WHEN TP.BBPOM_ID IN (" . "'" . join("','", $this->config->item('cfg_unit')) . "'" . ") OR TP.STATUS = 60510 THEN '%*" . $filterMKTMK . "%' ELSE '%#" . $filterMKTMK . "%' END) ";
			    $filterAV2 = " AND TPO.AMPUL_VIAL9ML LIKE (CASE WHEN TP.BBPOM_ID IN (" . "'" . join("','", $this->config->item('cfg_unit')) . "'" . ") OR TP.STATUS = 60510 THEN '%*" . $filterMKTMK . "%' ELSE '%#" . $filterMKTMK . "%' END) ";
			    $filterSB = " AND TPO.BLISTER LIKE (CASE WHEN TP.BBPOM_ID IN (" . "'" . join("','", $this->config->item('cfg_unit')) . "'" . ") OR TP.STATUS = 60510 THEN '%*" . $filterMKTMK . "%' ELSE '%#" . $filterMKTMK . "%' END)";
			    $filterBR = " AND TPO.BROSUR LIKE (CASE WHEN TP.BBPOM_ID IN (" . "'" . join("','", $this->config->item('cfg_unit')) . "'" . ") OR TP.STATUS = 60510 THEN '%*" . $filterMKTMK . "%' ELSE '%#" . $filterMKTMK . "%' END) ";
			    $filterAS = " AND TPO.AMPLOP LIKE (CASE WHEN TP.BBPOM_ID IN (" . "'" . join("','", $this->config->item('cfg_unit')) . "'" . ") OR TP.STATUS = 60510 THEN '%*" . $filterMKTMK . "%' ELSE '%#" . $filterMKTMK . "%' END) ";
			} else {
			    $filterBL = "";
			    $filterET = "";
			    $filterAV1 = "";
			    $filterAV2 = "";
			    $filterSB = "";
			    $filterBR = "";
			    $filterAS = "";
			}
			if ($mode == "ALL") {
			    $query1 = "SELECT (SELECT TPO.BUNGKUS_LUAR FROM T_PENANDAAN_OBAT TPO LEFT JOIN T_PENANDAAN TP ON TP.PENANDAAN_ID = TPO.PENANDAAN_ID WHERE TP.PENANDAAN_ID = TP1.PENANDAAN_ID $filterBL) AS 'BL',
				(SELECT TPO.ETIKET FROM T_PENANDAAN_OBAT TPO LEFT JOIN T_PENANDAAN TP ON TP.PENANDAAN_ID = TPO.PENANDAAN_ID WHERE TP.PENANDAAN_ID = TP1.PENANDAAN_ID $filterET) AS 'ET',
				(SELECT TPO.AMPUL_VIAL10ML FROM T_PENANDAAN_OBAT TPO LEFT JOIN T_PENANDAAN TP ON TP.PENANDAAN_ID = TPO.PENANDAAN_ID WHERE TP.PENANDAAN_ID = TP1.PENANDAAN_ID $filterAV1) AS 'AV1',
				(SELECT TPO.AMPUL_VIAL9ML FROM T_PENANDAAN_OBAT TPO LEFT JOIN T_PENANDAAN TP ON TP.PENANDAAN_ID = TPO.PENANDAAN_ID WHERE TP.PENANDAAN_ID = TP1.PENANDAAN_ID $filterAV2) AS 'AV2',
				(SELECT TPO.BROSUR FROM T_PENANDAAN_OBAT TPO LEFT JOIN T_PENANDAAN TP ON TP.PENANDAAN_ID = TPO.PENANDAAN_ID WHERE TP.PENANDAAN_ID = TP1.PENANDAAN_ID $filterBR) AS 'BR',
				(SELECT TPO.AMPLOP FROM T_PENANDAAN_OBAT TPO LEFT JOIN T_PENANDAAN TP ON TP.PENANDAAN_ID = TPO.PENANDAAN_ID WHERE TP.PENANDAAN_ID = TP1.PENANDAAN_ID $filterAS) AS 'AS',
				(SELECT TPO.BLISTER FROM T_PENANDAAN_OBAT TPO LEFT JOIN T_PENANDAAN TP ON TP.PENANDAAN_ID = TPO.PENANDAAN_ID WHERE TP.PENANDAAN_ID = TP1.PENANDAAN_ID $filterSB) AS 'SB'
				FROM T_PENANDAAN TP1 WHERE TP1.PENANDAAN_ID = '" . $row['PENANDAAN_ID'] . "'";
			} else if ($mode == "ONE") {
			    $filterOne = " TPO." . $filterQueryAs[0] . " LIKE (CASE WHEN TP.BBPOM_ID IN (" . "'" . join("','", $this->config->item('cfg_unit')) . "'" . ") OR TP.STATUS = 60510 THEN '%*" . $filterMKTMK . "%' ELSE '%#" . $filterMKTMK . "%' END) AND ";
			    $query1 = "SELECT TPO." . $filterQueryAs[0] . " AS '" . $filterQueryAs[1] . "'
				FROM T_PENANDAAN_OBAT TPO
				LEFT JOIN T_PENANDAAN TP ON TP.PENANDAAN_ID = TPO.PENANDAAN_ID
				WHERE $filterOne TP.PENANDAAN_ID = '" . $row['PENANDAAN_ID'] . "'";
			}
			$data1 = $sipt->main->get_result($query1);
			if ($data1) {
			    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('C' . $rec, $row['NAMA_SARANA'])->setCellValue('D' . $rec, $row['ALAMAT_1'])
				    ->setCellValue('E' . $rec, $row['TANGGAL_MULAI'] . " s/d " . $row['TANGGAL_AKHIR'])->setCellValue('F' . $rec, $row['NAMA_PRODUK'])
				    ->setCellValue('G' . $rec, $row['NOMOR_IZIN_EDAR'])->setCellValue('H' . $rec, $row['KLASIFIKASI_PRODUK'])
				    ->setCellValue('I' . $rec, $row['KOMPOSISI'])->setCellValue('J' . $rec, $row['PENDAFTAR'])->setCellValue('K' . $rec, $row['BENTUK_SEDIAAN'])
				    ->setCellValue('L' . $rec, $row['BESAR_KEMASAN'])->setCellValue('M' . $rec, $row['GOLONGAN_PRODUK'])
				    //->setCellValue('T' . $rec, $row['BBPOM']);
					->setCellValue('U' . $rec, $row['BBPOM']);
			    $this->newphpexcel->getActiveSheet()->getStyle('N' . $rec)->getNumberFormat()->setFormatCode('0000');
			    $this->newphpexcel->getActiveSheet()->setCellValueExplicit('N' . $rec, $row['NOMOR_PRODUK'], PHPExcel_Cell_DataType::TYPE_STRING);
			    if (in_array($row['BBPOM_ID'], $this->config->item('cfg_unit')) || $this->newsession->userdata('SESS_BBPOM_ID') == '00')
				$nonBalai = "YES";
			    else
				$nonBalai = "NO";
			    foreach ($query1->result_array() as $row1) {
				if ($this->input->post('BUNGKUS') != "" && $mode == "ONE") {
				    $AA = explode('*', $row1[$filterQueryAs[1]]);
				    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A' . $rec, $no)->setCellValue('B' . $rec, $filterQueryAs[2]);
				    $rec++;
				    $mergeA++;
				    $x = $rec - 1;
				    if ($nonBalai == "YES")
					$hasilBalai = "-";
				    else
					$hasilBalai = end(explode("#", $AA[1]));
				    $hasilPusat = explode("^", $AA[5]);
				    $tindakLanjut = $sipt->penandaan_act->tlString($AA[4]);
				    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('P' . $x, $hasilBalai);
				    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('Q' . $x, $AA[3]);
				    if ($hasilPusat[0])
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('R' . $x, $hasilPusat[0]);
				    if ($AA[4] != "") {
					if ($AA[4] != "TTL")
					    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('S' . $x, $tindakLanjut . ": " . $hasilPusat[1]);
					else
					    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('S' . $x, $tindakLanjut);
				    }
				    else
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('T' . $x, "-");
				    if ($AA[2] != "")
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('O' . $x, $AA[2]);
				    else
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('O' . $x, "-");
				    if ($AA[7] != "")
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('T' . $x, preg_replace('/(?:<|&lt;)\/?([a-zA-Z]+) *[^<\/]*?(?:>|&gt;)/', '', $AA[7]) . "\n");
				    else
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('T' . $x, "-");
				    $no++;
				    $this->newphpexcel->set_wrap(array('A' . $x, 'B' . $x, 'C' . $x, 'D' . $x, 'E' . $x, 'F' . $x, 'G' . $x, 'H' . $x, 'I' . $x, 'J' . $x, 'K' . $x, 'L' . $x, 'M' . $x, 'N' . $x, 'O' . $x, 'P' . $x, 'Q' . $x, 'R' . $x, 'S' . $x, 'T' . $x, 'U' . $x));
				} else {
				    $BL = explode('*', $row1['BL']);
				    if ($BL[1]) {
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A' . $rec, $no)->setCellValue('B' . $rec, 'Bungkus Luar');
					$rec++;
					$mergeA++;
					$x = $rec - 1;
					if ($nonBalai == "YES")
					    $hasilBalaiBL = "-";
					else
					    $hasilBalaiBL = end(explode("#", $BL[1]));
					$hasilPusatBL = explode("^", $BL[5]);
					$tindakLanjutBL = $sipt->penandaan_act->tlString($BL[4]);
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('P' . $x, $hasilBalaiBL);
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('Q' . $x, $BL[3]);
					if ($hasilPusatBL[0])
					    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('R' . $x, $hasilPusatBL[0]);
					if ($BL[4] != "") {
					    if ($BL[4] != "TTL")
						$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('S' . $x, $tindakLanjutBL . ": " . $hasilPusatBL[1]);
					    else
						$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('S' . $x, $tindakLanjutBL);
					}
					else
					    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('S' . $x, "-");
					if ($BL[2] != "")
					    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('O' . $x, $BL[2]);
					else
					    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('O' . $x, "-");
					if ($BL[7] != "")
					    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('T' . $x, preg_replace('/(?:<|&lt;)\/?([a-zA-Z]+) *[^<\/]*?(?:>|&gt;)/', '', $BL[7]) . "\n");
					else
					    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('T' . $x, "-");
					$no++;
					$this->newphpexcel->set_wrap(array('A' . $x, 'B' . $x, 'C' . $x, 'D' . $x, 'E' . $x, 'F' . $x, 'G' . $x, 'H' . $x,
					    'I' . $x, 'J' . $x, 'K' . $x, 'L' . $x, 'M' . $x, 'N' . $x, 'O' . $x, 'P' . $x, 'Q' . $x, 'R' . $x, 'S' . $x, 'T' . $x, 'U' . $x));
				    }
				    $AS = explode('*', $row1['AS']);
				    if ($AS[1]) {
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A' . $rec, $no)->setCellValue('B' . $rec, 'Amplop / Catch Cover / Sachet');
					$rec++;
					$mergeA++;
					$x = $rec - 1;
					if ($nonBalai == "YES")
					    $hasilBalaiAS = "-";
					else
					    $hasilBalaiAS = end(explode("#", $AS[1]));
					$hasilPusatAS = explode("^", $AS[5]);
					$tindakLanjutAS = $sipt->penandaan_act->tlString($AS[4]);
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('P' . $x, $hasilBalaiAS);
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('R' . $x, $AS[3]);
					if ($hasilPusatAS[0])
					    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('R' . $x, $hasilPusatAS[0]);
					if ($AS[4] != "") {
					    if ($AS[4] != "TTL")
						$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('S' . $x, $tindakLanjutAS . ": " . $hasilPusatAS[1]);
					    else
						$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('S' . $x, $tindakLanjutAS);
					}
					else
					    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('S' . $x, "-");
					if ($AS[2] != "")
					    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('O' . $x, $AS[2]);
					else
					    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('O' . $x, "-");
					if ($AS[7] != "")
					    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('T' . $x, preg_replace('/(?:<|&lt;)\/?([a-zA-Z]+) *[^<\/]*?(?:>|&gt;)/', '', $AS[7]) . "\n");
					else
					    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('T' . $x, "-");
					$no++;
					$this->newphpexcel->set_wrap(array('A' . $x, 'B' . $x, 'C' . $x, 'D' . $x, 'E' . $x, 'F' . $x, 'G' . $x, 'H' . $x,
					    'I' . $x, 'J' . $x, 'K' . $x, 'L' . $x, 'M' . $x, 'N' . $x, 'O' . $x, 'P' . $x, 'Q' . $x, 'R' . $x, 'S' . $x, 'T' . $x, 'U' . $x));
				    }
				    $ET = explode('*', $row1['ET']);
				    if ($ET[1]) {
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A' . $rec, $no)->setCellValue('B' . $rec, 'Etiket');
					$rec++;
					$mergeA++;
					$x = $rec - 1;
					if ($nonBalai == "YES")
					    $hasilBalaiET = "-";
					else
					    $hasilBalaiET = end(explode("#", $ET[1]));
					$hasilPusatET = explode("^", $ET[5]);
					$tindakLanjutET = $sipt->penandaan_act->tlString($ET[4]);
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('P' . $x, $hasilBalaiET);
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('Q' . $x, $ET[3]);
					if ($hasilPusatET[0])
					    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('R' . $x, $hasilPusatET[0]);
					if ($ET[4] != "") {
					    if ($ET[4] != "TTL")
						$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('S' . $x, $tindakLanjutET . ": " . $hasilPusatET[1]);
					    else
						$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('S' . $x, $tindakLanjutET);
					}
					else
					    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('S' . $x, "-");
					if ($ET[2] != "")
					    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('O' . $x, $ET[2]);
					else
					    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('O' . $x, "-");
					if ($ET[7] != "")
					    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('T' . $x, preg_replace('/(?:<|&lt;)\/?([a-zA-Z]+) *[^<\/]*?(?:>|&gt;)/', '', $ET[7]) . "\n");
					else
					    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('T' . $x, "-");
					$no++;
					$this->newphpexcel->set_wrap(array('A' . $x, 'B' . $x, 'C' . $x, 'D' . $x, 'E' . $x, 'F' . $x, 'G' . $x, 'H' . $x,
					    'I' . $x, 'J' . $x, 'K' . $x, 'L' . $x, 'M' . $x, 'N' . $x, 'O' . $x, 'P' . $x, 'Q' . $x, 'R' . $x, 'S' . $x, 'T' . $x, 'U' . $x));
				    }
				    $AV1 = explode('*', $row1['AV1']);
				    if ($AV1[1]) {
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A' . $rec, $no)->setCellValue('B' . $rec, 'Ampul / Vial >= 10 ML');
					$rec++;
					$mergeA++;
					$x = $rec - 1;
					if ($nonBalai == "YES")
					    $hasilBalaiAV1 = "-";
					else
					    $hasilBalaiAV1 = end(explode("#", $AV1[1]));
					$hasilPusatAV1 = explode("^", $AV1[5]);
					$tindakLanjutAV1 = $sipt->penandaan_act->tlString($AV1[4]);
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('P' . $x, $hasilBalaiAV1);
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('Q' . $x, $AV1[3]);
					if ($hasilPusatAV1[0])
					    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('R' . $x, $hasilPusatAV1[0]);
					if ($AV1[4] != "") {
					    if ($AV1[4] != "TTL")
						$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('S' . $x, $tindakLanjutAV1 . ": " . $hasilPusatAV1[1]);
					    else
						$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('S' . $x, $tindakLanjutAV1);
					}
					else
					    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('S' . $x, "-");
					if ($AV1[2] != "")
					    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('O' . $x, $AV1[2]);
					else
					    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('O' . $x, "-");
					if ($AV1[7] != "")
					    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('T' . $x, preg_replace('/(?:<|&lt;)\/?([a-zA-Z]+) *[^<\/]*?(?:>|&gt;)/', '', $AV1[7]) . "\n");
					else
					    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('T' . $x, "-");
					$no++;
					$this->newphpexcel->set_wrap(array('A' . $x, 'B' . $x, 'C' . $x, 'D' . $x, 'E' . $x, 'F' . $x, 'G' . $x, 'H' . $x,
					    'I' . $x, 'J' . $x, 'K' . $x, 'L' . $x, 'M' . $x, 'N' . $x, 'O' . $x, 'P' . $x, 'Q' . $x, 'R' . $x, 'S' . $x, 'T' . $x, 'U' . $x));
				    }
				    $AV2 = explode('*', $row1['AV2']);
				    if ($AV2[1]) {
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A' . $rec, $no)->setCellValue('B' . $rec, 'Ampul / Vial < 10 ML');
					$rec++;
					$mergeA++;
					$x = $rec - 1;
					if ($nonBalai == "YES")
					    $hasilBalaiAV2 = "-";
					else
					    $hasilBalaiAV2 = end(explode("#", $AV2[1]));
					$hasilPusatAV2 = explode("^", $AV2[5]);
					$tindakLanjutAV2 = $sipt->penandaan_act->tlString($AV2[4]);
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('P' . $x, $hasilBalaiAV2);
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('Q' . $x, $AV2[3]);
					if ($hasilPusatAV2[0])
					    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('R' . $x, $hasilPusatAV2[0]);
					if ($AV2[4] != "") {
					    if ($AV2[4] != "TTL")
						$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('S' . $x, $tindakLanjutAV2 . ": " . $hasilPusatAV2[1]);
					    else
						$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('S' . $x, $tindakLanjutAV2);
					}
					else
					    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('S' . $x, "-");
					if ($AV2[2] != "")
					    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('O' . $x, $AV2[2]);
					else
					    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('O' . $x, "-");
					if ($AV2[7] != "")
					    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('T' . $x, preg_replace('/(?:<|&lt;)\/?([a-zA-Z]+) *[^<\/]*?(?:>|&gt;)/', '', $AV2[7]) . "\n");
					else
					    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('T' . $x, "-");
					$no++;
					$this->newphpexcel->set_wrap(array('A' . $x, 'B' . $x, 'C' . $x, 'D' . $x, 'E' . $x, 'F' . $x, 'G' . $x, 'H' . $x,
					    'I' . $x, 'J' . $x, 'K' . $x, 'L' . $x, 'M' . $x, 'N' . $x, 'O' . $x, 'P' . $x, 'Q' . $x, 'R' . $x, 'S' . $x, 'T' . $x, 'U' . $x));
				    }
				    $SB = explode('*', $row1['SB']);
				    if ($SB[1]) {
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A' . $rec, $no)->setCellValue('B' . $rec, 'Strip / Blister');
					$rec++;
					$mergeA++;
					$x = $rec - 1;
					if ($nonBalai == "YES")
					    $hasilBalaiSB = "-";
					else
					    $hasilBalaiSB = end(explode("#", $SB[1]));
					$hasilPusatSB = explode("^", $SB[5]);
					$tindakLanjutSB = $sipt->penandaan_act->tlString($SB[4]);
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('P' . $x, $hasilBalaiSB);
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('Q' . $x, $SB[3]);
					if ($hasilPusatSB[0])
					    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('R' . $x, $hasilPusatSB[0]);
					if ($SB[4] != "") {
					    if ($SB[4] != "TTL")
						$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('S' . $x, $tindakLanjutSB . ": " . $hasilPusatSB[1]);
					    else
						$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('S' . $x, $tindakLanjutSB);
					}
					else
					    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('S' . $x, "-");
					if ($SB[2] != "")
					    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('O' . $x, $SB[2]);
					else
					    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('O' . $x, "-");
					if ($SB[7] != "")
					    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('T' . $x, preg_replace('/(?:<|&lt;)\/?([a-zA-Z]+) *[^<\/]*?(?:>|&gt;)/', '', $SB[7]) . "\n");
					else
					    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('T' . $x, "-");
					$no++;
					$this->newphpexcel->set_wrap(array('A' . $x, 'B' . $x, 'C' . $x, 'D' . $x, 'E' . $x, 'F' . $x, 'G' . $x, 'H' . $x,
					    'I' . $x, 'J' . $x, 'K' . $x, 'L' . $x, 'M' . $x, 'N' . $x, 'O' . $x, 'P' . $x, 'Q' . $x, 'R' . $x, 'S' . $x, 'T' . $x, 'U' . $x));
				    }
				    $BR = explode('*', $row1['BR']);
				    if ($BR[1]) {
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A' . $rec, $no)->setCellValue('B' . $rec, 'Brosur');
					$rec++;
					$mergeA++;
					$x = $rec - 1;
					if ($nonBalai == "YES")
					    $hasilBalaiBR = "-";
					else
					    $hasilBalaiBR = end(explode("#", $BR[1]));
					$hasilPusatBR = explode("^", $BR[5]);
					$tindakLanjutBR = $sipt->penandaan_act->tlString($BR[4]);
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('P' . $x, $hasilBalaiBR);
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('Q' . $x, $BR[3]);
					if ($hasilPusatBR[0])
					    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('R' . $x, $hasilPusatBR[0]);
					if ($BR[4] != "") {
					    if ($BR[4] != "TTL")
						$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('S' . $x, $tindakLanjutBR . ": " . $hasilPusatBR[1]);
					    else
						$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('S' . $x, $tindakLanjutBR);
					}
					else
					    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('S' . $x, "-");
					if ($BR[2] != "")
					    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('O' . $x, $BR[2]);
					else
					    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('O' . $x, "-");
					if ($BR[7] != "")
					    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('T' . $x, preg_replace('/(?:<|&lt;)\/?([a-zA-Z]+) *[^<\/]*?(?:>|&gt;)/', '', $BR[7]) . "\n");
					else
					    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('T' . $x, "-");
					$no++;
					$this->newphpexcel->set_wrap(array('A' . $x, 'B' . $x, 'C' . $x, 'D' . $x, 'E' . $x, 'F' . $x, 'G' . $x, 'H' . $x,
					    'I' . $x, 'J' . $x, 'K' . $x, 'L' . $x, 'M' . $x, 'N' . $x, 'O' . $x, 'P' . $x, 'Q' . $x, 'R' . $x, 'S' . $x, 'T' . $x, 'U' . $x));
				    }
				}
				if ($mergeA == 1) {
				    $ct = $rec - 1;
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
				    $this->newphpexcel->mergeCell(array(array('C' . $ct, 'C' . $ct2), array('D' . $ct, 'D' . $ct2), array('E' . $ct, 'E' . $ct2),
					array('F' . $ct, 'F' . $ct2), array('G' . $ct, 'G' . $ct2), array('H' . $ct, 'H' . $ct2), array('I' . $ct, 'I' . $ct2),
					array('J' . $ct, 'J' . $ct2), array('K' . $ct, 'K' . $ct2), array('L' . $ct, 'L' . $ct2), array('M' . $ct, 'M' . $ct2),
					array('N' . $ct, 'N' . $ct2), array('U' . $ct, 'U' . $ct2)), FALSE);
				for ($i = $ct; $i <= $ct2; $i++) {
				    $this->newphpexcel->set_detilstyle(array('A' . $i, 'B' . $i, 'C' . $i, 'D' . $i, 'E' . $i, 'F' . $i, 'G' . $i, 'H' . $i,
					'I' . $i, 'J' . $i, 'K' . $i, 'L' . $i, 'M' . $i, 'N' . $i, 'O' . $i, 'P' . $i, 'Q' . $i, 'R' . $i, 'S' . $i, 'T' . $i, 'U' . $i));
				}
				$mergeA = 0;
			    }
			} else {
			    $this->newphpexcel->getActiveSheet()->mergeCells('A8:N8');
			    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A8', 'Data Pengawasan Penandaan Tidak Ditemukan');
			}
		    }
		} else {
		    $this->newphpexcel->getActiveSheet()->mergeCells('A8:N8');
		    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A8', 'Data Pengawasan Penandaan Tidak Ditemukan');
		}
	    } else {
		$this->newphpexcel->mergecell(array(array('A6', 'A7'), array('B6', 'B7'), array('C6', 'C7'), array('D6', 'D7'), array('E6', 'E7'),
		    array('F6', 'F7'), array('G6', 'G7'), array('H6', 'H7'), array('I6', 'I7'), array('J6', 'J7'), array('K6', 'K7'), array('L6', 'L7'),
		    array('M6', 'M7'), array('N6', 'N7'), array('O6', 'O7'), array('P6', 'P7'), array('Q6', 'Q7'), array('R6', 'R7'),
		    array('S6', 'S7'), array('T6', 'T7')), TRUE);
		$this->newphpexcel->set_bold(array('A1', 'A2', 'A3', 'A4'));
		$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A1', 'LAPORAN HASIL PENGAWASAN PENANDAAN OBAT')->setCellValue('A2', $judul)->setCellValue('A3', strtoupper($balai))->setCellValue('A4', 'PERIODE : ' . $awal . ' s.d ' . $akhir);
		$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A6', 'No')->setCellValue('B6', 'Jenis Penandaan')->setCellValue('C6', 'Nama Sarana')->setCellValue('D6', 'Alamat Sarana')->setCellValue('E6', 'Tanggal Periksa')->setCellValue('F6', 'Nama Produk')->setCellValue('G6', 'Nomor Izin Edar')->setCellValue('H6', 'Klasifikasi Obat')->setCellValue('I6', 'Komposisi')->setCellValue('J6', 'Nama Pemilik Izin Edar')->setCellValue('K6', 'Bentuk Sediaan')->setCellValue('L6', 'Besar Kemasan')->setCellValue('M6', 'Golongan Obat')->setCellValue('N6', 'Uraian Pelanggaran')->setCellValue('O6', 'Hasil Pusat')->setCellValue('P6', 'Kategori Penilaian')->setCellValue('Q6', 'Tindak Lanjut Pusat')->setCellValue('R6', 'Justifikasi Pusat')->setCellValue('S6', 'Unit / Balai Pemeriksa');
		$this->newphpexcel->headings(array('A6', 'B6', 'C6', 'D6', 'E6', 'F6', 'G6', 'H6', 'I6', 'J6', 'K6', 'L6', 'M6',
		    'N6', 'O6', 'P6', 'Q6', 'R6', 'S6', 'T6'));
		$this->newphpexcel->headings(array('A7', 'B7', 'C7', 'D7', 'E7', 'F7', 'G7', 'H7', 'I7', 'J7', 'K7', 'L7', 'M7',
		    'N7', 'O7', 'P7', 'Q7', 'R7', 'S7', 'T7'));
		$this->newphpexcel->set_wrap(array('A6', 'B6', 'C6', 'D6', 'E6', 'F6', 'G6', 'H6', 'I6', 'J6', 'K6', 'L6', 'M6',
		    'N6', 'O6', 'P6', 'Q6', 'R6', 'S6', 'T6'));
		$this->newphpexcel->width(array(array('A', 4), array('B', 28), array('C', 30), array('D', 50), array('E', 27), array('F', 27), array('G', 27),
		    array('H', 27), array('I', 27), array('J', 27), array('K', 27), array('L', 27), array('M', 27), array('N', 50), array('O', 15), array('P', 20),
		    array('Q', 30), array('R', 30), array('S', 33)));
		$this->newphpexcel->set_bold(array('A1', 'A2', 'A3', 'A4'));
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
			    $filterBL = " AND TPO.BUNGKUS_LUAR LIKE (CASE WHEN TP.BBPOM_ID IN (" . "'" . join("','", $this->config->item('cfg_unit')) . "'" . ") OR TP.STATUS = 60510 THEN '%*" . $filterMKTMK . "%' ELSE '%#" . $filterMKTMK . "%' END) ";
			    $filterET = " AND TPO.ETIKET LIKE (CASE WHEN TP.BBPOM_ID IN (" . "'" . join("','", $this->config->item('cfg_unit')) . "'" . ") OR TP.STATUS = 60510 THEN '%*" . $filterMKTMK . "%' ELSE '%#" . $filterMKTMK . "%' END) ";
			    $filterAV1 = " AND TPO.AMPUL_VIAL10ML LIKE (CASE WHEN TP.BBPOM_ID IN (" . "'" . join("','", $this->config->item('cfg_unit')) . "'" . ") OR TP.STATUS = 60510 THEN '%*" . $filterMKTMK . "%' ELSE '%#" . $filterMKTMK . "%' END) ";
			    $filterAV2 = " AND TPO.AMPUL_VIAL9ML LIKE (CASE WHEN TP.BBPOM_ID IN (" . "'" . join("','", $this->config->item('cfg_unit')) . "'" . ") OR TP.STATUS = 60510 THEN '%*" . $filterMKTMK . "%' ELSE '%#" . $filterMKTMK . "%' END) ";
			    $filterSB = " AND TPO.BLISTER LIKE (CASE WHEN TP.BBPOM_ID IN (" . "'" . join("','", $this->config->item('cfg_unit')) . "'" . ") OR TP.STATUS = 60510 THEN '%*" . $filterMKTMK . "%' ELSE '%#" . $filterMKTMK . "%' END)";
			    $filterBR = " AND TPO.BROSUR LIKE (CASE WHEN TP.BBPOM_ID IN (" . "'" . join("','", $this->config->item('cfg_unit')) . "'" . ") OR TP.STATUS = 60510 THEN '%*" . $filterMKTMK . "%' ELSE '%#" . $filterMKTMK . "%' END) ";
			    $filterAS = " AND TPO.AMPLOP LIKE (CASE WHEN TP.BBPOM_ID IN (" . "'" . join("','", $this->config->item('cfg_unit')) . "'" . ") OR TP.STATUS = 60510 THEN '%*" . $filterMKTMK . "%' ELSE '%#" . $filterMKTMK . "%' END) ";
			} else {
			    $filterBL = "";
			    $filterET = "";
			    $filterAV1 = "";
			    $filterAV2 = "";
			    $filterSB = "";
			    $filterBR = "";
			    $filterAS = "";
			}
			if ($mode == "ALL") {
			    $query1 = "SELECT (SELECT TPO.BUNGKUS_LUAR FROM T_PENANDAAN_OBAT TPO LEFT JOIN T_PENANDAAN TP ON TP.PENANDAAN_ID = TPO.PENANDAAN_ID WHERE TP.PENANDAAN_ID = TP1.PENANDAAN_ID $filterBL) AS 'BL', (SELECT TPO.ETIKET FROM T_PENANDAAN_OBAT TPO LEFT JOIN T_PENANDAAN TP ON TP.PENANDAAN_ID = TPO.PENANDAAN_ID WHERE TP.PENANDAAN_ID = TP1.PENANDAAN_ID $filterET) AS 'ET', (SELECT TPO.AMPUL_VIAL10ML FROM T_PENANDAAN_OBAT TPO LEFT JOIN T_PENANDAAN TP ON TP.PENANDAAN_ID = TPO.PENANDAAN_ID WHERE TP.PENANDAAN_ID = TP1.PENANDAAN_ID $filterAV1) AS 'AV1', (SELECT TPO.AMPUL_VIAL9ML FROM T_PENANDAAN_OBAT TPO LEFT JOIN T_PENANDAAN TP ON TP.PENANDAAN_ID = TPO.PENANDAAN_ID WHERE TP.PENANDAAN_ID = TP1.PENANDAAN_ID $filterAV2) AS 'AV2', (SELECT TPO.BROSUR FROM T_PENANDAAN_OBAT TPO LEFT JOIN T_PENANDAAN TP ON TP.PENANDAAN_ID = TPO.PENANDAAN_ID WHERE TP.PENANDAAN_ID = TP1.PENANDAAN_ID $filterBR) AS 'BR', (SELECT TPO.AMPLOP FROM T_PENANDAAN_OBAT TPO LEFT JOIN T_PENANDAAN TP ON TP.PENANDAAN_ID = TPO.PENANDAAN_ID WHERE TP.PENANDAAN_ID = TP1.PENANDAAN_ID $filterAS) AS 'AS', (SELECT TPO.BLISTER FROM T_PENANDAAN_OBAT TPO LEFT JOIN T_PENANDAAN TP ON TP.PENANDAAN_ID = TPO.PENANDAAN_ID WHERE TP.PENANDAAN_ID = TP1.PENANDAAN_ID $filterSB) AS 'SB' FROM T_PENANDAAN TP1 WHERE TP1.PENANDAAN_ID = '" . $row['PENANDAAN_ID'] . "'";
			} else if ($mode == "ONE") {
			    $filterOne = " TPO." . $filterQueryAs[0] . " LIKE (CASE WHEN TP.BBPOM_ID IN (" . "'" . join("','", $this->config->item('cfg_unit')) . "'" . ") OR TP.STATUS = 60510 THEN '%*" . $filterMKTMK . "%' ELSE '%#" . $filterMKTMK . "%' END) AND ";
			    $query1 = "SELECT TPO." . $filterQueryAs[0] . " AS '" . $filterQueryAs[1] . "' FROM T_PENANDAAN_OBAT TPO LEFT JOIN T_PENANDAAN TP ON TP.PENANDAAN_ID = TPO.PENANDAAN_ID WHERE $filterOne TP.PENANDAAN_ID = '" . $row['PENANDAAN_ID'] . "'";
			}
			$data1 = $sipt->main->get_result($query1);
			if ($data1) {
			    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('C' . $rec, $row['NAMA_SARANA'])->setCellValue('D' . $rec, $row['ALAMAT_1'])
				    ->setCellValue('E' . $rec, $row['TANGGAL_MULAI'] . " s/d " . $row['TANGGAL_AKHIR'])->setCellValue('F' . $rec, $row['NAMA_PRODUK'])
				    ->setCellValue('G' . $rec, $row['NOMOR_IZIN_EDAR'])->setCellValue('H' . $rec, $row['KLASIFIKASI_PRODUK'])
				    ->setCellValue('I' . $rec, $row['KOMPOSISI'])->setCellValue('J' . $rec, $row['PENDAFTAR'])
				    ->setCellValue('K' . $rec, $row['BENTUK_SEDIAAN'])->setCellValue('L' . $rec, $row['BESAR_KEMASAN'])
				    ->setCellValue('M' . $rec, $row['GOLONGAN_PRODUK'])->setCellValue('S' . $rec, $row['BBPOM']);
					//1134
			    $this->newphpexcel->set_wrap(array('C' . $rec, 'D' . $rec, 'F' . $rec, 'G' . $rec, 'I' . $rec, 'J' . $rec, 'K' . $rec, 'L'));
			    foreach ($query1->result_array() as $row1) {
				if ($this->input->post('BUNGKUS') != "" && $mode == "ONE") {
				    $AA = explode('*', $row1[$filterQueryAs[1]]);
				    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A' . $rec, $no)->setCellValue('B' . $rec, $filterQueryAs[2]);
				    $rec++;
				    $mergeA++;
				    $x = $rec - 1;
				    $hasilPusat = explode("^", $AA[5]);
				    $tindakLanjut = $sipt->penandaan_act->tlString($AA[4]);
				    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('P' . $x, $AA[3]);
				    if ($hasilPusat[0])
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('Q' . $x, $hasilPusat[0]);
				    if ($AA[4] != "") {
					if ($AA[4] != "TTL")
					    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('R' . $x, $tindakLanjut . ": " . $hasilPusat[1]);
					else
					    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('R' . $x, $tindakLanjut);
				    }
				    else
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('R' . $x, "-");
				    if ($AA[2] != "")
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('O' . $x, $AA[2]);
				    else
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('O' . $x, "-");
				    if ($AA[7] != "")
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('S' . $x, preg_replace('/(?:<|&lt;)\/?([a-zA-Z]+) *[^<\/]*?(?:>|&gt;)/', '', $AA[7]) . "\n");
				    else
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('S' . $x, "-");
				    $no++;
				    $this->newphpexcel->set_wrap(array('A' . $x, 'B' . $x, 'C' . $x, 'D' . $x, 'E' . $x, 'F' . $x, 'G' . $x, 'H' . $x,
					'I' . $x, 'J' . $x, 'K' . $x, 'L' . $x, 'M' . $x, 'N' . $x, 'O' . $x, 'P' . $x, 'Q' . $x, 'R' . $x, 'S' . $x, 'T' . $x));
				} else {
				    $BL = explode('*', $row1['BL']);
				    if ($BL[1]) {
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A' . $rec, $no)->setCellValue('B' . $rec, 'Bungkus Luar');
					$rec++;
					$mergeA++;
					$x = $rec - 1;
					$hasilPusatBL = explode("^", $BL[5]);
					$tindakLanjutBL = $sipt->penandaan_act->tlString($BL[4]);
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('P' . $x, $BL[3]);
					if ($hasilPusatBL[0])
					    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('Q' . $x, $hasilPusatBL[0]);
					if ($BL[4] != "") {
					    if ($BL[4] != "TTL")
						$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('R' . $x, $tindakLanjutBL . ": " . $hasilPusatBL[1]);
					    else
						$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('R' . $x, $tindakLanjutBL);
					}
					else
					    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('R' . $x, "-");
					if ($BL[2] != "")
					    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('O' . $x, $BL[2]);
					else
					    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('O' . $x, "-");
					if ($BL[7] != "")
					    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('S' . $x, preg_replace('/(?:<|&lt;)\/?([a-zA-Z]+) *[^<\/]*?(?:>|&gt;)/', '', $BL[7]) . "\n");
					else
					    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('S' . $x, "-");
					$no++;
					$this->newphpexcel->set_wrap(array('A' . $x, 'B' . $x, 'C' . $x, 'D' . $x, 'E' . $x, 'F' . $x, 'G' . $x, 'H' . $x,
					    'I' . $x, 'J' . $x, 'K' . $x, 'L' . $x, 'M' . $x, 'N' . $x, 'O' . $x, 'P' . $x, 'Q' . $x, 'R' . $x, 'S' . $x, 'T' . $x));
				    }
				    $AS = explode('*', $row1['AS']);
				    if ($AS[1]) {
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A' . $rec, $no)->setCellValue('B' . $rec, 'Amplop / Catch Cover / Sachet');
					$rec++;
					$mergeA++;
					$x = $rec - 1;
					$hasilPusatAS = explode("^", $AS[5]);
					$tindakLanjutAS = $sipt->penandaan_act->tlString($AS[4]);
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('P' . $x, $AS[3]);
					if ($hasilPusatAS[0])
					    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('Q' . $x, $hasilPusatAS[0]);
					if ($AS[4] != "") {
					    if ($AS[4] != "TTL")
						$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('R' . $x, $tindakLanjutAS . ": " . $hasilPusatAS[1]);
					    else
						$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('R' . $x, $tindakLanjutAS);
					}
					else
					    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('R' . $x, "-");
					if ($AS[2] != "")
					    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('O' . $x, $AS[2]);
					else
					    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('O' . $x, "-");
					if ($AS[7] != "")
					    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('S' . $x, preg_replace('/(?:<|&lt;)\/?([a-zA-Z]+) *[^<\/]*?(?:>|&gt;)/', '', $AS[7]) . "\n");
					else
					    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('R' . $x, "-");
					$no++;
					$this->newphpexcel->set_wrap(array('A' . $x, 'B' . $x, 'C' . $x, 'D' . $x, 'E' . $x, 'F' . $x, 'G' . $x, 'H' . $x,
					    'I' . $x, 'J' . $x, 'K' . $x, 'L' . $x, 'M' . $x, 'N' . $x, 'O' . $x, 'P' . $x, 'Q' . $x, 'R' . $x, 'S' . $x, 'T' . $x));
				    }
				    $ET = explode('*', $row1['ET']);
				    if ($ET[1]) {
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A' . $rec, $no)->setCellValue('B' . $rec, 'Etiket');
					$rec++;
					$mergeA++;
					$x = $rec - 1;
					$hasilPusatET = explode("^", $ET[5]);
					$tindakLanjutET = $sipt->penandaan_act->tlString($ET[4]);
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('P' . $x, $ET[3]);
					if ($hasilPusatET[0])
					    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('Q' . $x, $hasilPusatET[0]);
					if ($ET[4] != "") {
					    if ($ET[4] != "TTL")
						$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('R' . $x, $tindakLanjutET . ": " . $hasilPusatET[1]);
					    else
						$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('R' . $x, $tindakLanjutET);
					}
					else
					    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('R' . $x, "-");
					if ($ET[2] != "")
					    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('O' . $x, $ET[2]);
					else
					    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('O' . $x, "-");
					if ($ET[7] != "")
					    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('S' . $x, preg_replace('/(?:<|&lt;)\/?([a-zA-Z]+) *[^<\/]*?(?:>|&gt;)/', '', $ET[7]) . "\n");
					else
					    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('S' . $x, "-");
					$no++;
					$this->newphpexcel->set_wrap(array('A' . $x, 'B' . $x, 'C' . $x, 'D' . $x, 'E' . $x, 'F' . $x, 'G' . $x, 'H' . $x,
					    'I' . $x, 'J' . $x, 'K' . $x, 'L' . $x, 'M' . $x, 'N' . $x, 'O' . $x, 'P' . $x, 'Q' . $x, 'R' . $x, 'S' . $x, 'T' . $x));
				    }
				    $AV1 = explode('*', $row1['AV1']);
				    if ($AV1[1]) {
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A' . $rec, $no)->setCellValue('B' . $rec, 'Ampul / Vial >= 10 ML');
					$rec++;
					$mergeA++;
					$x = $rec - 1;
					$hasilPusatAV1 = explode("^", $AV1[5]);
					$tindakLanjutAV1 = $sipt->penandaan_act->tlString($AV1[4]);
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('P' . $x, $AV1[3]);
					if ($hasilPusatAV1[0])
					    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('Q' . $x, $hasilPusatAV1[0]);
					if ($AV1[4] != "") {
					    if ($AV1[4] != "TTL")
						$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('R' . $x, $tindakLanjutAV1 . ": " . $hasilPusatAV1[1]);
					    else
						$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('R' . $x, $tindakLanjutAV1);
					}
					else
					    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('R' . $x, "-");
					if ($AV1[2] != "")
					    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('O' . $x, $AV1[2]);
					else
					    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('O' . $x, "-");
					if ($AV1[7] != "")
					    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('S' . $x, preg_replace('/(?:<|&lt;)\/?([a-zA-Z]+) *[^<\/]*?(?:>|&gt;)/', '', $AV1[7]) . "\n");
					else
					    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('S' . $x, "-");
					$no++;
					$this->newphpexcel->set_wrap(array('A' . $x, 'B' . $x, 'C' . $x, 'D' . $x, 'E' . $x, 'F' . $x, 'G' . $x, 'H' . $x,
					    'I' . $x, 'J' . $x, 'K' . $x, 'L' . $x, 'M' . $x, 'N' . $x, 'O' . $x, 'P' . $x, 'Q' . $x, 'R' . $x, 'S' . $x, 'T' . $x));
				    }
				    $AV2 = explode('*', $row1['AV2']);
				    if ($AV2[1]) {
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A' . $rec, $no)->setCellValue('B' . $rec, 'Ampul / Vial < 10 ML');
					$rec++;
					$mergeA++;
					$x = $rec - 1;
					$hasilPusatAV2 = explode("^", $AV2[5]);
					$tindakLanjutAV2 = $sipt->penandaan_act->tlString($AV2[4]);
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('P' . $x, $AV2[3]);
					if ($hasilPusatAV2[0])
					    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('Q' . $x, $hasilPusatAV2[0]);
					if ($AV2[4] != "") {
					    if ($AV2[4] != "TTL")
						$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('R' . $x, $tindakLanjutAV2 . ": " . $hasilPusatAV2[1]);
					    else
						$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('R' . $x, $tindakLanjutAV2);
					}
					else
					    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('R' . $x, "-");
					if ($AV2[2] != "")
					    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('O' . $x, $AV2[2]);
					else
					    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('O' . $x, "-");
					if ($AV2[7] != "")
					    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('S' . $x, preg_replace('/(?:<|&lt;)\/?([a-zA-Z]+) *[^<\/]*?(?:>|&gt;)/', '', $AV2[7]) . "\n");
					else
					    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('S' . $x, "-");
					$no++;
					$this->newphpexcel->set_wrap(array('A' . $x, 'B' . $x, 'C' . $x, 'D' . $x, 'E' . $x, 'F' . $x, 'G' . $x, 'H' . $x,
					    'I' . $x, 'J' . $x, 'K' . $x, 'L' . $x, 'M' . $x, 'N' . $x, 'O' . $x, 'P' . $x, 'Q' . $x, 'R' . $x, 'S' . $x, 'T' . $x));
				    }
				    $SB = explode('*', $row1['SB']);
				    if ($SB[1]) {
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A' . $rec, $no)->setCellValue('B' . $rec, 'Strip / Blister');
					$rec++;
					$mergeA++;
					$x = $rec - 1;
					$hasilPusatSB = explode("^", $SB[5]);
					$tindakLanjutSB = $sipt->penandaan_act->tlString($SB[4]);
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('P' . $x, $SB[3]);
					if ($hasilPusatSB[0])
					    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('Q' . $x, $hasilPusatSB[0]);
					if ($SB[4] != "") {
					    if ($SB[4] != "TTL")
						$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('R' . $x, $tindakLanjutSB . ": " . $hasilPusatSB[1]);
					    else
						$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('R' . $x, $tindakLanjutAV1);
					}
					else
					    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('R' . $x, "-");
					if ($SB[2] != "")
					    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('O' . $x, $SB[2]);
					else
					    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('O' . $x, "-");
					if ($SB[7] != "")
					    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('S' . $x, preg_replace('/(?:<|&lt;)\/?([a-zA-Z]+) *[^<\/]*?(?:>|&gt;)/', '', $SB[7]) . "\n");
					else
					    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('S' . $x, "-");
					$no++;
					$this->newphpexcel->set_wrap(array('A' . $x, 'B' . $x, 'C' . $x, 'D' . $x, 'E' . $x, 'F' . $x, 'G' . $x, 'H' . $x,
					    'I' . $x, 'J' . $x, 'K' . $x, 'L' . $x, 'M' . $x, 'N' . $x, 'O' . $x, 'P' . $x, 'Q' . $x, 'R' . $x, 'S' . $x, 'T' . $x));
				    }
				    $BR = explode('*', $row1['BR']);
				    if ($BR[1]) {
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A' . $rec, $no)->setCellValue('B' . $rec, 'Brosur');
					$rec++;
					$mergeA++;
					$x = $rec - 1;
					$hasilPusatBR = explode("^", $BR[5]);
					$tindakLanjutBR = $sipt->penandaan_act->tlString($BR[4]);
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('P' . $x, $BR[3]);
					if ($hasilPusatBR[0])
					    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('Q' . $x, $hasilPusatBR[0]);
					if ($BR[4] != "") {
					    if ($BR[4] != "TTL")
						$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('R' . $x, $tindakLanjutBR . ": " . $hasilPusatBR[1]);
					    else
						$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('R' . $x, $tindakLanjutBR);
					}
					else
					    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('R' . $x, "-");
					if ($BR[2] != "")
					    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('O' . $x, $BR[2]);
					else
					    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('O' . $x, "-");
					if ($BR[7] != "")
					    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('S' . $x, preg_replace('/(?:<|&lt;)\/?([a-zA-Z]+) *[^<\/]*?(?:>|&gt;)/', '', $BR[7]) . "\n");
					else
					    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('S' . $x, "-");
					$no++;
					$this->newphpexcel->set_wrap(array('A' . $x, 'B' . $x, 'C' . $x, 'D' . $x, 'E' . $x, 'F' . $x, 'G' . $x, 'H' . $x,
					    'I' . $x, 'J' . $x, 'K' . $x, 'L' . $x, 'M' . $x, 'N' . $x, 'O' . $x, 'P' . $x, 'Q' . $x, 'R' . $x, 'S' . $x, 'T' . $x));
				    }
				}
				if ($mergeA == 1) {
				    $ct = $rec - 1;
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
				    $this->newphpexcel->mergeCell(array(array('C' . $ct, 'C' . $ct2), array('D' . $ct, 'D' . $ct2), array('E' . $ct, 'E' . $ct2),
					array('F' . $ct, 'F' . $ct2), array('G' . $ct, 'G' . $ct2), array('H' . $ct, 'H' . $ct2), array('I' . $ct, 'I' . $ct2),
					array('J' . $ct, 'J' . $ct2), array('K' . $ct, 'K' . $ct2), array('L' . $ct, 'L' . $ct2), array('M' . $ct, 'M' . $ct2),
					array('N' . $ct, 'N' . $ct2), array('U' . $ct, 'U' . $ct2)), FALSE);
				for ($i = $ct; $i <= $ct2; $i++) {
				    $this->newphpexcel->set_detilstyle(array('A' . $i, 'B' . $i, 'C' . $i, 'D' . $i, 'E' . $i, 'F' . $i, 'G' . $i, 'H' . $i,
					'I' . $i, 'J' . $i, 'K' . $i, 'L' . $i, 'M' . $i, 'N' . $i, 'O' . $i, 'P' . $i, 'Q' . $i, 'R' . $i, 'S' . $i, 'T' . $i));
				}
				$mergeA = 0;
			    }
			} else {
			    $this->newphpexcel->getActiveSheet()->mergeCells('A8:N8');
			    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A8', 'Data Pengawasan Penandaan Tidak Ditemukan');
			}
		    }
		} else {
		    $this->newphpexcel->getActiveSheet()->mergeCells('A8:N8');
		    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A8', 'Data Pengawasan Penandaan Tidak Ditemukan');
		}
	    }
	    ob_clean();
	    $file = "LAPORAN_PENGAWASAN_PENANDAAN_OBAT_" . str_replace(" ", "_", str_replace("-", "", $judul)) . "_" . date("YmdHis") . ".xls";
	    header("Content-type: application/vnd.ms-excel");
	    header("Content-Disposition: attachment;filename=$file");
	    //header("Cache-Control: max-age=0");
	    //header("Pragma: no-cache");
	    //header("Expires: 0");
	    $objWriter = PHPExcel_IOFactory::createWriter($this->newphpexcel, 'Excel5');
	    $objWriter->save('php://output');
	    exit();
	}
    }

}

?>