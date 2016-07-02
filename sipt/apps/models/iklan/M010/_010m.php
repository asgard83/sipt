<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
error_reporting(E_ERROR);

class _010M extends Model {

    function getFormIklan($klasifikasi = '') {
	if (!$this->session->userdata('BBPOM')) {
	    $this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.', '/home');
	}
	if ($this->newsession->userdata('LOGGED_IN') == TRUE) {
	    $sipt = & get_instance();
	    $this->load->model("main", "main", true);
	    $sipt->load->model('iklan/iklan_act');
	    $suratTugas = $this->session->userdata('SURAT');
	    $roleOri = $sipt->iklan_act->getRole();
	    $kodeProvinsi = substr($this->newsession->userdata('SESS_PROP_ID'), 0, 2);
	    $detailProvinsiDef = $sipt->main->combobox("SELECT PROPINSI_ID, NAMA_PROPINSI FROM M_PROPINSI WHERE LEFT(PROPINSI_ID, 2) = '" . $kodeProvinsi . "' AND RIGHT(PROPINSI_ID, 2) != '00'", "PROPINSI_ID", "NAMA_PROPINSI", TRUE);
	    $provinsi = $sipt->main->combobox("SELECT PROPINSI_ID, NAMA_PROPINSI FROM M_PROPINSI WHERE LEFT(PROPINSI_ID, 1) <= '9' AND RIGHT(PROPINSI_ID, 2) = '00'", "PROPINSI_ID", "NAMA_PROPINSI", TRUE);
	    $arrdata = array('provinsi' => $provinsi, 'kabupaten' => $detailProvinsiDef, 'act' => site_url() . '/iklan/iklanController/setFormIklanLanjutan/pengawasan/' . $klasifikasi, 'batal' => site_url() . '/home/iklan/PengawasanIklan', 'histori_petugas' => site_url() . '/load/petugas/get_petugas_2/');
//   $arrayTDK = array('' => '', 'Peringatan 1' => 'Peringatan 1', 'Peringatan 2' => 'Peringatan 2', 'Peringatan Keras' => 'Peringatan Keras', 'Penghentian Sementara Kegiatan' => 'Penghentian Sementara Kegiatan', 'Pembatalan Nomor Izin Edar' => 'Pembatalan Nomor Izin Edar');
//   $arrdata ['cb_tindakan'] = $arrayTDK;
//   $arrayTDK2 = array('' => '', 'Peringatan 1' => 'Peringatan 1', 'Peringatan 2' => 'Peringatan 2', 'Peringatan Keras' => 'Peringatan Keras', 'Penghentian Sementara Kegiatan' => 'Penghentian Sementara Kegiatan', 'Pembatalan Nomor Izin Edar' => 'Pembatalan Nomor Izin Edar', 'Pemusnahan' => 'Pemusnahan');
//   $arrdata ['cb_tindakan2'] = $arrayTDK2;
	    $arrdata ['cb_tindakan'] = $this->config->item("tl_pusat_iklan_ot");
	    $arrdata ['cb_tindakan2'] = $this->config->item("tl_pusat_iklan_ot2");
	    $arrdata ['cb_tindakan_balai'] = $this->config->item("tl_balai_iklan_ot");
	    $arrdata ['jenisProduk'] = $sipt->main->combobox("SELECT URAIAN, KODE FROM M_TABEL WHERE JENIS = 'JO_OT' ORDER BY KODE ASC", "KODE", "URAIAN", TRUE);
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
	$arr_iklan_OT = $this->input->post('IKLANOT');
	$arr_petugas = $this->session->userdata('USER');
	$lampiran = $this->input->post('IKLAN_OT');
	$suratTugas = $this->session->userdata('SURAT');
	$suratId = (int) $sipt->main->get_uraian("SELECT MAX(SURAT_ID) AS MAXID FROM T_SURAT_TUGAS_IKLAN", "MAXID") + 1;
	$tanggalSurat = $this->session->userdata('TANGGAL');
	if ($this->input->post('MUSNAH'))
	    $pemusnahan = join("^", $this->input->post('MUSNAH'));
	else
	    $pemusnahan = NULL;
	if ($this->input->post('UPELANGGARAN')) {
	    $arrChkUpel = $this->input->post('UPELANGGARAN');
	    for ($i = 0; $i <= count($arrChkUpel); $i++) {
		$arrChkUpelVal[$i] = $arrChkUpel[$i];
	    }
	    $arr_uraian_pelanggaran = join("#", $arrChkUpelVal);
	}
	else
	    $arr_uraian_pelanggaran = NULL;
	if ($this->input->post('MUSNAHPUSAT'))
	    $pemusnahanPusat = join("^", $this->input->post('MUSNAHPUSAT'));
	else
	    $pemusnahanPusat = NULL;
	if (trim($arr_iklan['TL_PUSAT']) != "")
	    $tindakLanjut = $arr_iklan['TL_PUSAT'];
	else
	    $tindakLanjut = NULL;
	if (trim($arr_iklan['DETAIL_PUSAT']) != "")
	    $detailPusat = $arr_iklan['DETAIL_PUSAT'];
	else
	    $detailPusat = NULL;
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
	$iklan = array('SURAT_ID' => $suratId, 'IKLAN_ID' => $iklan_id, 'BBPOM_ID' => $this->newsession->userdata('SESS_BBPOM_ID'), 'TANGGAL_MULAI' => $arr_iklan['TANGGALAWAL'], 'TANGGAL_AKHIR' => $arr_iklan['TANGGALAKHIR'], 'KOMODITI' => $this->input->post('KLASIFIKASIIKLAN'), 'JENIS_IKLAN' => $arr_iklan['JENISIKLAN'], 'MEDIA' => $media, 'NAMA_MEDIA' => $arr_iklan['NAMA'], 'JUDUL_KEGIATAN' => $arr_iklan['JUDUL'], 'TANGGAL' => $tglTugas, 'NAMA_LOKASI_IKLAN' => $arr_iklan['LOKASI'], 'ALAMAT_LOKASI_IKLAN' => $arr_iklan['ALAMAT'], 'KOTA' => $arr_iklan['KOTA'], 'EDISI' => $edisi, 'JAM_TAYANG' => $arr_iklan['TAYANG1'] . ' ' . trim($arr_iklan['TAYANG2']), 'STATUS' => $status, 'HASIL' => $arr_iklan['HASIL'], 'HASIL_PUSAT' => $arr_iklan['HASIL_PUSAT'], 'TL_PUSAT' => $tindakLanjut, 'DETAIL_PUSAT' => $detailPusat, 'JUSTIFIKASI_PUSAT' => $justifikasi, 'USER_LAST_UPDATE' => $this->newsession->userdata('SESS_USER_ID'), 'LAST_UPDATE' => 'GETDATE()', 'CREATE_BY' => $this->newsession->userdata('SESS_USER_ID'));
	$this->db->insert('T_IKLAN', $iklan);
	if ($this->db->affected_rows() > 0) {
	    $seri = (int) $sipt->main->get_uraian("SELECT MAX(SERI) AS MAXID FROM T_IKLAN_PROSES WHERE IKLAN_ID = '" . $iklan_id . "'", "MAXID") + 1;
	    $log = array('IKLAN_ID' => $iklan_id, 'SERI' => $seri, 'STATUS' => $status, 'CATATAN' => '', 'CREATEDBY' => $this->newsession->userdata('SESS_USER_ID'), 'CREATED' => 'GETDATE()', 'UPDATED' => 'GETDATE()');
	    $this->db->insert('T_IKLAN_PROSES', $log);
	    $case = "IKLANPROSES";
	}
	if ($this->db->affected_rows() > 0) {
	    $i = 0;
	    if (in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) {
		foreach ($arr_produk['NAMA'] as $a) {
		    $produk = array('IKLAN_ID' => $iklan_id, 'IKLAN_ID_PRODUK' => $iklan_id . $i, 'NAMA_PRODUK' => $arr_produk['NAMA'][$i], 'BENTUK_SEDIAAN' => $arr_produk['BENTUKSEDIAAN'][$i], 'MERK_PRODUK' => $arr_produk['MERK_PRODUK'][$i], 'NAMA_PEMILIK_IZIN_EDAR' => $arr_produk['NAMAPEMILIKIZINEDAR'][$i], 'NOMOR_IZIN_EDAR' => $arr_produk['NOMORIZINEDAR'][$i], 'GOLONGAN_PRODUK' => $arr_produk['GOLONGAN'][$i], 'JENIS_PRODUK' => $arr_produk['JENIS'][$i]);
		    $this->db->insert('T_IKLAN_PRODUK', $produk);
		    $i++;
		    $case = "IKLANPRODUK";
		}
	    } else {
		foreach ($arr_produk['NAMA'] as $a) {
		    $produk = array('IKLAN_ID' => $iklan_id, 'IKLAN_ID_PRODUK' => $iklan_id . $i, 'NAMA_PRODUK' => $arr_produk['NAMA'][$i], 'BENTUK_SEDIAAN' => $arr_produk['BENTUKSEDIAAN'][$i], 'NAMA_PEMILIK_IZIN_EDAR' => $arr_produk['NAMAPEMILIKIZINEDAR'][$i], 'NOMOR_IZIN_EDAR' => $arr_produk['NOMORIZINEDAR'][$i], 'GOLONGAN_PRODUK' => $arr_produk['GOLONGAN'][$i], 'JENIS_PRODUK' => $arr_produk['JENIS'][$i]);
		    $this->db->insert('T_IKLAN_PRODUK', $produk);
		    $i++;
		    $case = "IKLANPRODUK";
		}
	    }
	}
	if ($this->db->affected_rows() > 0) {
	    $iklanOT = array('IKLAN_ID' => $iklan_id, 'URAIAN_PELANGGARAN' => $arr_uraian_pelanggaran, 'NARASI' => $arr_iklan_OT['NARASI'], 'LAMPIRAN' => $lampiran['FILE_IKLAN'], 'TL_BALAI' => $arr_iklan['TL_BALAI'], 'PEMUSNAHAN' => $pemusnahan, 'PEMUSNAHANPUSAT' => $pemusnahanPusat);
	    $this->db->insert('T_IKLAN_OT', $iklanOT);
	    if ($this->db->affected_rows() > 0) {
		$case = 'YESIKLANOT';
	    } else {
		$case = 'NO';
	    }
	} else {
	    $case = 'NO';
	}
	if ($case == 'YESIKLANOT') {
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
	$query = "SELECT TI.STATUS, TI.SURAT_ID, TI.IKLAN_ID, TI.HASIL, TI.HASIL_PUSAT, TI.JUSTIFIKASI_PUSAT, CONVERT(VARCHAR(10), TI.TANGGAL_MULAI, 120) AS TANGGAL_MULAI, CONVERT(VARCHAR(10), TI.TANGGAL_AKHIR, 120) AS TANGGAL_AKHIR, TIOT.URAIAN_PELANGGARAN FROM T_IKLAN TI RIGHT JOIN T_IKLAN_OT TIOT ON TIOT.IKLAN_ID = TI.IKLAN_ID WHERE TIOT.IKLAN_ID = '" . $idPengawasan . "'";
	$data = $sipt->main->get_result($query);
	if ($data) {
	    foreach ($query->result_array() as $row) {
		$arrdata = array('sess' => $row, 'judul' => 'OT');
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
	$query = "SELECT DISTINCT TSTI.SURAT_ID, CONVERT(VARCHAR(10), TSTI.TANGGAL, 103) AS 'TGL_SURAT', TIOT.LAMPIRAN AS FILE_IKLAN, TIOT.NARASI, TIOT.TL_BALAI, TIOT.URAIAN_PELANGGARAN, CONVERT(VARCHAR(1000),TIOT.PEMUSNAHAN) AS PEMUSNAHAN, CONVERT(VARCHAR(1000),TIOT.PEMUSNAHANPUSAT) AS PEMUSNAHANPUSAT, TIOT.TL_BALAI AS TL_BALAI, TI.IKLAN_ID, CONVERT(VARCHAR(10), " . $tglQuery . ", TI.JENIS_IKLAN, TI.MEDIA, TI.KOMODITI, CASE(SELECT COUNT(MM2.NAMA_MEDIA) AS MEDIA FROM M_MEDIA MM2 WHERE CONVERT(VARCHAR(100),MM2.ID_MEDIA) = TI.NAMA_MEDIA) WHEN 0 THEN CONVERT(VARCHAR(100), TI.NAMA_MEDIA) ELSE MM.NAMA_MEDIA END AS NAMA_MEDIA, CONVERT(VARCHAR(1000),TI.JUSTIFIKASI_PUSAT) AS JUSTIFIKASI_PUSAT, TI.NAMA_MEDIA AS ID_MEDIA, TI.JUDUL_KEGIATAN, TI.NAMA_LOKASI_IKLAN, TI.ALAMAT_LOKASI_IKLAN, TI.KOTA AS IDKAB, MP.NAMA_PROPINSI AS KOTA, TI.EDISI, TI.JAM_TAYANG, TI.STATUS, TI.HASIL, TI.HASIL_PUSAT, TI.DETAIL_PUSAT, TI.TL_PUSAT, TI.DETAIL_PUSAT FROM T_IKLAN TI RIGHT JOIN T_IKLAN_OT TIOT ON TIOT.IKLAN_ID = TI.IKLAN_ID RIGHT JOIN T_SURAT_TUGAS_IKLAN TSTI ON TSTI.SURAT_ID = TI.SURAT_ID LEFT JOIN M_MEDIA MM ON CONVERT(VARCHAR(100),MM.ID_MEDIA) = TI.NAMA_MEDIA LEFT JOIN M_PROPINSI MP ON MP.PROPINSI_ID = TI.KOTA WHERE TIOT.IKLAN_ID = '" . $iklanId . "'";
	$data = $sipt->main->get_result($query);
	if ($data) {
	    foreach ($query->result_array() as $row) {
		$arrdata = array('sess' => $row, 'judul' => 'OT');
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
	    $query2 = "SELECT TIP.NAMA_PRODUK, TIP.BENTUK_SEDIAAN, TIP.NAMA_PEMILIK_IZIN_EDAR, TIP.NOMOR_IZIN_EDAR, TIP.MERK_PRODUK,TIP.GOLONGAN_PRODUK, TIP.JENIS_PRODUK FROM T_IKLAN TI RIGHT JOIN T_IKLAN_PRODUK TIP ON TIP.IKLAN_ID = TI.IKLAN_ID WHERE TIP.IKLAN_ID ='" . $arrdata['sess']['IKLAN_ID'] . "'";
	    $data2 = $sipt->main->get_result($query2);
	    if ($data2) {
		foreach ($query2->result_array() as $row) {
		    $str[] = $row;
		}
	    }
	} else if (($subid == '0101' || $subid == '1101') && in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')) && array_key_exists('2', $this->newsession->userdata('SESS_KODE_ROLE')) && in_array($bbpom, $this->config->item('cfg_unit')) && ($jenis == 'draft' || $jenis == 'edit')) {
	    $query2 = "SELECT TIP.NAMA_PRODUK, TIP.BENTUK_SEDIAAN, TIP.NAMA_PEMILIK_IZIN_EDAR, TIP.NOMOR_IZIN_EDAR, TIP.MERK_PRODUK, TIP.GOLONGAN_PRODUK, TIP.JENIS_PRODUK FROM T_IKLAN TI RIGHT JOIN T_IKLAN_PRODUK TIP ON TIP.IKLAN_ID = TI.IKLAN_ID WHERE TIP.IKLAN_ID ='" . $arrdata['sess']['IKLAN_ID'] . "'";
	    $data2 = $sipt->main->get_result($query2);
	    if ($data2) {
		foreach ($query2->result_array() as $row) {
		    $str[] = $row;
		}
	    }
	} else {
	    $query2 = "SELECT TIP.NAMA_PRODUK, TIP.BENTUK_SEDIAAN, TIP.NAMA_PEMILIK_IZIN_EDAR, TIP.NOMOR_IZIN_EDAR, TIP.MERK_PRODUK, TIP.GOLONGAN_PRODUK, (SELECT URAIAN FROM M_TABEL WHERE KODE = TIP.JENIS_PRODUK AND JENIS = 'JO_OT') AS JENIS FROM T_IKLAN TI RIGHT JOIN T_IKLAN_PRODUK TIP ON TIP.IKLAN_ID = TI.IKLAN_ID WHERE TIP.IKLAN_ID ='" . $arrdata['sess']['IKLAN_ID'] . "'";
	    $premarketArr = array(0 => "Iklan sudah dipre-review", 1 => "Iklan belum dipre-review");
	    $data2 = $sipt->main->get_result($query2);
	    if ($data2) {
		$str = '<table class="tabelajax"><tr class="head"><th>Nama Produk OT</th><th>Bentuk Sediaan</th><th>Nama Pemilik Izin Edar</th><th>Nomor Izin Edar</th><th>Kategori Produk</th><th>Lain - lain</th><th>Evaluasi Premarket</th></tr>';
		foreach ($query2->result_array() as $row) {
		    $lainnya = trim($row['GOLONGAN_PRODUK']) != "" ? $row['GOLONGAN_PRODUK'] : "-";
		    $premarket = trim($row['MERK_PRODUK']) != "" ? $premarketArr[$row['MERK_PRODUK']] : "-";
		    $str .= '<tr><td>' . $row['NAMA_PRODUK'] . '</td><td>' . $row['BENTUK_SEDIAAN'] . '</td><td>' . $row['NAMA_PEMILIK_IZIN_EDAR'] . '</td><td>' . $row['NOMOR_IZIN_EDAR'] . '</td><td>' . $row['JENIS'] . '</td><td>' . $lainnya . '</td><td>' . $premarket . '</td></tr>';
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
	$arrdata ['cb_tindakan'] = $this->config->item("tl_pusat_iklan_ot");
	$arrdata ['cb_tindakan2'] = $this->config->item("tl_pusat_iklan_ot2");
	$arrdata ['cb_tindakan_balai'] = $this->config->item("tl_balai_iklan_ot");
	$arrdata ['asalData'] = $bbpom;
	$arrdata ['kabupaten'] = $detailProvinsiDef;
	$arrdata ['provinsi'] = $provinsi;
	$arrdata ['cancel'] = site_url() . '/iklan/iklanController/setListFormIklanLanjutan/' . $klasifikasi . '/' . $user;
	$arrdata ['klasifikasi'] = $klasifikasi;
	$arrdata ['editTL'] = $isEditTLPusat;
	$arrdata['tujuan'] = $user;
	$arrdata ['jenisProduk'] = $sipt->main->combobox("SELECT URAIAN, KODE FROM M_TABEL WHERE JENIS = 'JO_OT'", "KODE", "URAIAN", TRUE);
	if (($subid == '1101' || $subid == '0101') && $jenis != 'preview') {
	    $arrdata ['subJudul'] = '- OBAT TRADISIONAL EDIT';
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
	    $iklan_id = $this->input->post('IKLAN_ID');
	    $case = '';
	    $status = $this->input->post('TO');
	    $arr_iklan = $this->input->post('IKLAN');
	    $arr_produk = $this->input->post('PRODUK');
	    $arr_iklan_OT = $this->input->post('IKLANOT');
	    if ($this->input->post('MUSNAH'))
		$pemusnahan = join("^", $this->input->post('MUSNAH'));
	    else
		$pemusnahan = NULL;
	    if ($this->input->post('UPELANGGARAN')) {
		$arrChkUpel = $this->input->post('UPELANGGARAN');
		for ($i = 0; $i <= count($arrChkUpel); $i++) {
		    $arrChkUpelVal[$i] = $arrChkUpel[$i];
		}
		$arr_uraian_pelanggaran = join("#", $arrChkUpelVal);
	    }
	    else
		$arr_uraian_pelanggaran = NULL;
	    $lampiran = $this->input->post('IKLAN_OT');
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
			if (trim($arr_iklan['TL_PUSAT']) != "")
			    $tL = $arr_iklan['TL_PUSAT'];
			else
			    $tL = NULL;
			if (trim($arr_iklan['DETAIL_PUSAT']) != "")
			    $detailPusat = $arr_iklan['DETAIL_PUSAT'];
			else
			    $detailPusat = NULL;
			$justifikasi = NULL;
			if (($arr_iklan['HASIL_PUSAT'] != $arr_iklan['HASIL']) && $this->input->post('JUSTIFIKASI'))
			    $justifikasi = $this->input->post('JUSTIFIKASI');
			if ($arr_iklan['HASIL_PUSAT'] == "MK")
			    $tindakH = array('HASIL_PUSAT' => $arr_iklan['HASIL_PUSAT'], 'TL_PUSAT' => $tL, 'JUSTIFIKASI_PUSAT' => $justifikasi);
			else if ($arr_iklan['HASIL_PUSAT'] == "TMK")
			    $tindakH = array('HASIL_PUSAT' => $arr_iklan['HASIL_PUSAT'], 'TL_PUSAT' => $tL, 'DETAIL_PUSAT' => $detailPusat, 'JUSTIFIKASI_PUSAT' => $justifikasi);
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
		if ($arr_produk) {
		    $this->db->where(array("IKLAN_ID" => $id));
		    $this->db->delete('T_IKLAN_PRODUK');
		    $i = 0;
		    if (in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) {
			foreach ($arr_produk['NAMA'] as $a) {
			    $produk = array('IKLAN_ID' => $id, 'IKLAN_ID_PRODUK' => $id . $i, 'NAMA_PRODUK' => $arr_produk['NAMA'][$i], 'BENTUK_SEDIAAN' => $arr_produk['BENTUKSEDIAAN'][$i], 'NAMA_PEMILIK_IZIN_EDAR' => $arr_produk['NAMAPEMILIKIZINEDAR'][$i], 'MERK_PRODUK' => $arr_produk['MERK_PRODUK'][$i], 'NOMOR_IZIN_EDAR' => $arr_produk['NOMORIZINEDAR'][$i], 'GOLONGAN_PRODUK' => $arr_produk['GOLONGAN'][$i], 'JENIS_PRODUK' => $arr_produk['JENIS'][$i]);
			    $this->db->insert('T_IKLAN_PRODUK', $produk);
			    $i++;
			    $case = "YESIKLANPRODUK";
			}
		    } else {
			foreach ($arr_produk['NAMA'] as $a) {
			    $produk = array('IKLAN_ID' => $id, 'IKLAN_ID_PRODUK' => $id . $i, 'NAMA_PRODUK' => $arr_produk['NAMA'][$i], 'BENTUK_SEDIAAN' => $arr_produk['BENTUKSEDIAAN'][$i], 'NAMA_PEMILIK_IZIN_EDAR' => $arr_produk['NAMAPEMILIKIZINEDAR'][$i], 'NOMOR_IZIN_EDAR' => $arr_produk['NOMORIZINEDAR'][$i], 'GOLONGAN_PRODUK' => $arr_produk['GOLONGAN'][$i], 'JENIS_PRODUK' => $arr_produk['JENIS'][$i]);
			    $this->db->insert('T_IKLAN_PRODUK', $produk);
			    $i++;
			    $case = "YESIKLANPRODUK";
			}
		    }
		}
		if ($this->input->post('MUSNAHPUSAT')) {
		    $pemusnahanPusat = join("^", $this->input->post('MUSNAHPUSAT'));
		    $iklanOT = array('PEMUSNAHANPUSAT' => $pemusnahanPusat);
		    $this->db->where(array("IKLAN_ID" => $id));
		    $this->db->update('T_IKLAN_OT', $iklanOT);
		} else {
		    $pemusnahanPusat = NULL;
		    $iklanOT = array('PEMUSNAHANPUSAT' => $pemusnahanPusat);
		    $this->db->where(array("IKLAN_ID" => $id));
		    $this->db->update('T_IKLAN_OT', $iklanOT);
		}
		if ($arr_iklan_OT) {
		    $iklanOT = array('URAIAN_PELANGGARAN' => $arr_uraian_pelanggaran, 'NARASI' => $arr_iklan_OT['NARASI'], 'LAMPIRAN' => $lampiran['FILE_IKLAN'], 'TL_BALAI' => $arr_iklan['TL_BALAI'], 'PEMUSNAHAN' => $pemusnahan);
		    $this->db->where(array("IKLAN_ID" => $id));
		    $this->db->update('T_IKLAN_OT', $iklanOT);
		    if ($this->db->affected_rows() > 0) {
			$case = 'YESIKLANOT';
		    }
		}
	    }
	    if ($case == 'YESIKLANOT' || $case == 'YESIKLAN' || $case == 'YESIKLANPRODUK') {
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
	    $judul = "OBAT TRADISIONAL";
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
	    $query = "SELECT DISTINCT (REPLACE(REPLACE(MB.NAMA_BBPOM,'BALAI BESAR POM DI ', ''),'BALAI POM DI ','')) AS NAMA_BBPOM,  TI.JENIS_IKLAN, (SELECT TI.MEDIA WHERE TI.JENIS_IKLAN = 'Cetak') AS CETAK, (SELECT TI.MEDIA WHERE TI.JENIS_IKLAN = 'Elektronik') AS ELEKTRO, (SELECT TI.MEDIA WHERE TI.JENIS_IKLAN = 'Luar Ruang') AS LUAR, SUM(CASE WHEN TI.HASIL = 'MK' AND TI.STATUS <> 60310 THEN 1 ELSE 0 END) AS MK_B, SUM(CASE WHEN TI.HASIL = 'TMK' AND TI.STATUS <> 60310 THEN 1 ELSE 0 END) AS TMK_B, SUM(CASE WHEN TI.HASIL_PUSAT = 'MK' AND TI.STATUS = 60310 THEN 1 ELSE 0 END) AS MK_P, SUM(CASE WHEN TI.HASIL_PUSAT = 'TMK' AND TI.STATUS = 60310 THEN 1 ELSE 0 END) AS TMK_P, SUM(CASE WHEN TIP.MERK_PRODUK = '0' THEN 1 ELSE 0 END) AS SUDAH, SUM(CASE WHEN TIP.MERK_PRODUK = '1' THEN 1 ELSE 0 END) AS BELUM, SUM(CASE WHEN TIO.URAIAN_PELANGGARAN LIKE '%0#%' THEN 1 ELSE 0 END) AS UR0, SUM(CASE WHEN TIO.URAIAN_PELANGGARAN LIKE '%#1#%' THEN 1 ELSE 0 END) AS UR1, SUM(CASE WHEN TIO.URAIAN_PELANGGARAN LIKE '%#2#%' THEN 1 ELSE 0 END) AS UR2, SUM(CASE WHEN TIO.URAIAN_PELANGGARAN LIKE '%#3#%' THEN 1 ELSE 0 END) AS UR3, SUM(CASE WHEN TIO.URAIAN_PELANGGARAN LIKE '%#4#%' THEN 1 ELSE 0 END) AS UR4, SUM(CASE WHEN TIO.URAIAN_PELANGGARAN LIKE '%#5#%' THEN 1 ELSE 0 END) AS UR5, SUM(CASE WHEN TIO.URAIAN_PELANGGARAN LIKE '%#6#%' THEN 1 ELSE 0 END) AS UR6, SUM(CASE WHEN TIO.URAIAN_PELANGGARAN LIKE '%#7#%' THEN 1 ELSE 0 END) AS UR7, SUM(CASE WHEN TIO.URAIAN_PELANGGARAN LIKE '%#8#%' THEN 1 ELSE 0 END) AS UR8, SUM(CASE WHEN TIO.URAIAN_PELANGGARAN LIKE '%#9#%' THEN 1 ELSE 0 END) AS UR9, SUM(CASE WHEN TIO.URAIAN_PELANGGARAN LIKE '%#10#%' THEN 1 ELSE 0 END) AS UR10, SUM(CASE WHEN TIO.URAIAN_PELANGGARAN LIKE '%#11#%' THEN 1 ELSE 0 END) AS UR11, SUM(CASE WHEN TIO.URAIAN_PELANGGARAN LIKE '%#12#%' THEN 1 ELSE 0 END) AS UR12 FROM T_IKLAN TI LEFT JOIN M_BBPOM MB ON TI.BBPOM_ID = MB.BBPOM_ID LEFT JOIN T_IKLAN_PRODUK TIP ON TIP.IKLAN_ID = TI.IKLAN_ID LEFT JOIN T_IKLAN_OT TIO ON TIO.IKLAN_ID = TI.IKLAN_ID WHERE $filter2 AND TI.KOMODITI = '010' GROUP BY MB.BBPOM_ID, MB.NAMA_BBPOM, TI.MEDIA, TI.JENIS_IKLAN ORDER BY 1";
	    $this->newphpexcel->set_font('Calibri', 10);
	    $this->newphpexcel->setActiveSheetIndex(0);
	    $this->newphpexcel->set_title('RHPK Pengawasan Iklan');
	    $this->newphpexcel->mergecell(array(array('A1', 'F1'), array('A2', 'F2'), array('A3', 'F3'), array('A4', 'F4'), array('C6', 'E6'), array('F6', 'H6'), array('I6', 'K6'), array('O6', 'P6'), array('Q6', 'AC6')), TRUE);
	    $this->newphpexcel->mergecell(array(array('B6', 'B7'), array('A6', 'A7'), array('L6', 'L7'), array('M6', 'M7'), array('N6', 'N7')), TRUE);
	    $this->newphpexcel->width(array(array('A', 4), array('B', 30), array('C', 20), array('D', 5), array('E', 5), array('F', 20), array('G', 5), array('H', 5), array('I', 20), array('J', 5), array('K', 5), array('L', 10), array('M', 5), array('N', 5), array('O', 10), array('P', 10), array('Q', 5), array('R', 5), array('S', 5), array('T', 5), array('U', 5), array('V', 5), array('W', 5), array('X', 5), array('Y', 5), array('Z', 5), array('AA', 5), array('AB', 5), array('AC', 5)));
	    $this->newphpexcel->set_bold(array('A1', 'A2', 'A3', 'A4'));
	    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A1', 'REKAPITULASI HASIL PELAKSANAAN KEGIATAN - PENGAWASAN IKLAN')->setCellValue('A2', $judul)->setCellValue('A3', strtoupper($balai))->setCellValue('A4', 'PERIODE : ' . $awal . ' s.d ' . $akhir);
	    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A6', 'No.')->setCellValue('B6', 'BBPOM')->setCellValue('C6', 'Media Cetak')->setCellValue('F6', 'Media Elektronik')->setCellValue('I6', 'Media Luar Ruang')->setCellValue('L6', 'Jumlah')->setCellValue('M6', 'MK')->setCellValue('N6', 'TMK')->setCellValue('O6', 'Evaluasi Premarket')->setCellValue('Q6', 'Rincian TMK')->setCellValue('C7', 'Jenis Media')->setCellValue('D7', 'MK')->setCellValue('E7', 'TMK')->setCellValue('F7', 'Jenis Media')->setCellValue('G7', 'MK')->setCellValue('H7', 'TMK')->setCellValue('I7', 'Jenis Media')->setCellValue('J7', 'MK')->setCellValue('K7', 'TMK')->setCellValue('O7', 'Sudah pre-view')->setCellValue('P7', 'Belum pre-view')->setCellValue('Q7', '1')->setCellValue('R7', '2')->setCellValue('S7', '3')->setCellValue('T7', '4')->setCellValue('U7', '5')->setCellValue('V7', '6')->setCellValue('W7', '7')->setCellValue('X7', '8')->setCellValue('Y7', '9')->setCellValue('Z7', '10')->setCellValue('AA7', '11')->setCellValue('AB7', '12')->setCellValue('AC7', '13');
	    $this->newphpexcel->headings(array('A6', 'B6', 'C6', 'D6', 'E6', 'F6', 'G6', 'H6', 'I6', 'J6', 'K6', 'L6', 'M6', 'N6', 'O6', 'P6', 'Q6', 'R6', 'S6', 'T6', 'U6', 'V6', 'W6', 'X6', 'Y6', 'Z6', 'AA6', 'AB6', 'AC6'));
	    $this->newphpexcel->headings(array('A7', 'B7', 'C7', 'D7', 'E7', 'F7', 'G7', 'H7', 'I7', 'J7', 'K7', 'L7', 'M7', 'N7', 'O7', 'P7', 'Q7', 'R7', 'S7', 'T7', 'U7', 'V7', 'W7', 'X7', 'Y7', 'Z7', 'AA7', 'AB7', 'AC7'));
	    $this->newphpexcel->set_wrap(array('B6', 'G7', 'H7', 'I7', 'J7', 'K7', 'L7', 'M7', 'N7', 'O7', 'P7', 'Q7', 'R7', 'S7', 'T7', 'U7', 'V7', 'W7', 'X7', 'Y7', 'Z7', 'AA7', 'AB7', 'AC7'));
	    $data = $sipt->main->get_result($query);
	    if ($data) {
		$no = 1;
		$rec = 8;
		$rec2 = 8;
		$rec3 = 8;
		$rec4 = 8;
		$rec5 = 0;
		$recC = 8;
		$recE = 8;
		$recL = 8;
		$recSingle = 0;
		$bbpom = "";
		$recMin = 0;
		$recMax = 0;
		$total = 0;
		$totalMK = 0;
		$totalTMK = 0;
		$totalUR0 = 0;
		$totalUR1 = 0;
		$totalUR2 = 0;
		$totalUR3 = 0;
		$totalUR4 = 0;
		$totalUR5 = 0;
		$totalUR6 = 0;
		$totalUR7 = 0;
		$totalUR8 = 0;
		$totalUR9 = 0;
		$totalUR10 = 0;
		$totalUR11 = 0;
		$totalUR12 = 0;
		$totalSudah = 0;
		$totalBelum = 0;
		foreach ($query->result_array() as $row) {
		    if ($bbpom != $row["NAMA_BBPOM"]) {
			if ($no > 1) {
			    $arrCt = array($recC, $recE, $recL);
			    $arrFilt = array_filter($arrCt);
			    $arrMax = max($arrFilt);
			    $recMin = min($arrFilt);
			    $recMax = $arrMax - 1;
			    $rec = $arrMax;
			    $rec2 = $arrMax;
			    $rec3 = $arrMax;
			    $rec4 = $arrMax;
			    $recC = $arrMax;
			    $recE = $arrMax;
			    $recL = $arrMax;
			}
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A' . $rec4, $no)->setCellValue('B' . $rec4, $row["NAMA_BBPOM"]);
			if ($rec5 > 0) {
			    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('L' . $recMin, $total)->setCellValue('M' . $recMin, $totalMK)->setCellValue('N' . $recMin, $totalTMK)->setCellValue('O' . $recMin, $totalSudah)->setCellValue('P' . $recMin, $totalBelum)->setCellValue('Q' . $recMin, $totalUR0)->setCellValue('R' . $recMin, $totalUR1)->setCellValue('S' . $recMin, $totalUR2)->setCellValue('T' . $recMin, $totalUR3)->setCellValue('U' . $recMin, $totalUR4)->setCellValue('V' . $recMin, $totalUR5)->setCellValue('W' . $recMin, $totalUR6)->setCellValue('X' . $recMin, $totalUR7)->setCellValue('Y' . $recMin, $totalUR8)->setCellValue('Z' . $recMin, $totalUR9)->setCellValue('AA' . $recMin, $totalUR10)->setCellValue('AB' . $recMin, $totalUR11)->setCellValue('AC' . $recMin, $totalUR12);
			    $this->newphpexcel->mergecell(array(array('A' . $recMin, 'A' . $recMax), array('B' . $recMin, 'B' . $recMax), array('L' . $recMin, 'L' . $recMax), array('M' . $recMin, 'M' . $recMax), array('N' . $recMin, 'N' . $recMax), array('O' . $recMin, 'O' . $recMax), array('P' . $recMin, 'P' . $recMax), array('Q' . $recMin, 'Q' . $recMax), array('R' . $recMin, 'R' . $recMax), array('S' . $recMin, 'S' . $recMax), array('T' . $recMin, 'T' . $recMax), array('U' . $recMin, 'U' . $recMax), array('V' . $recMin, 'V' . $recMax), array('W' . $recMin, 'W' . $recMax), array('X' . $recMin, 'X' . $recMax), array('Y' . $recMin, 'Y' . $recMax), array('Z' . $recMin, 'Z' . $recMax), array('AA' . $recMin, 'AA' . $recMax), array('AB' . $recMin, 'AB' . $recMax), array('AC' . $recMin, 'AC' . $recMax)), FALSE);
			} elseif ($rec > 0 && $recSingle < 2) {
			    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('L' . $recMin, $total)->setCellValue('M' . $recMin, $totalMK)->setCellValue('N' . $recMin, $totalTMK)->setCellValue('O' . $recMin, $totalSudah)->setCellValue('P' . $recMin, $totalBelum)->setCellValue('Q' . $recMin, $totalUR0)->setCellValue('R' . $recMin, $totalUR1)->setCellValue('S' . $recMin, $totalUR2)->setCellValue('T' . $recMin, $totalUR3)->setCellValue('U' . $recMin, $totalUR4)->setCellValue('V' . $recMin, $totalUR5)->setCellValue('W' . $recMin, $totalUR6)->setCellValue('X' . $recMin, $totalUR7)->setCellValue('Y' . $recMin, $totalUR8)->setCellValue('Z' . $recMin, $totalUR9)->setCellValue('AA' . $recMin, $totalUR10)->setCellValue('AB' . $recMin, $totalUR11)->setCellValue('AC' . $recMin, $totalUR12);
			}
			$no++;
			$rec5 = 0;
			$total = 0;
			$totalMK = 0;
			$totalTMK = 0;
			$totalUR0 = 0;
			$totalUR1 = 0;
			$totalUR2 = 0;
			$totalUR3 = 0;
			$totalUR4 = 0;
			$totalUR5 = 0;
			$totalUR6 = 0;
			$totalUR7 = 0;
			$totalUR8 = 0;
			$totalUR9 = 0;
			$totalUR10 = 0;
			$totalUR11 = 0;
			$totalUR12 = 0;
			$totalSudah = 0;
			$totalBelum = 0;
			$recSingle = 0;
		    } else {
			$rec5++;
		    }
		    if (trim($row["CETAK"]) != "") {
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('C' . $rec, $row["CETAK"])->setCellValue('D' . $rec, $row["MK_P"] + $row["MK_B"])->setCellValue('E' . $rec, $row["TMK_P"] + $row["TMK_B"]);
			$this->newphpexcel->set_detilstyle(array('A' . $rec, 'B' . $rec, 'C' . $rec, 'D' . $rec, 'E' . $rec, 'F' . $rec, 'G' . $rec, 'H' . $rec, 'I' . $rec, 'J' . $rec, 'K' . $rec, 'L' . $rec, 'M' . $rec, 'N' . $rec, 'O' . $rec, 'P' . $rec, 'Q' . $rec, 'R' . $rec, 'S' . $rec, 'T' . $rec, 'U' . $rec, 'V' . $rec, 'W' . $rec, 'X' . $rec, 'Y' . $rec, 'Z' . $rec, 'AA' . $rec, 'AB' . $rec, 'AC' . $rec));
			$this->newphpexcel->set_wrap(array('G' . $rec));
			$total = $total + $row['MK_P'] + $row['MK_B'] + $row['TMK_P'] + $row['TMK_B'];
			$totalMK = $totalMK + $row['MK_P'] + $row['MK_B'];
			$totalTMK = $totalTMK + $row['TMK_P'] + $row['TMK_B'];
			$totalUR0 = $totalUR0 + $row['UR0'];
			$totalUR1 = $totalUR1 + $row['UR1'];
			$totalUR2 = $totalUR2 + $row['UR2'];
			$totalUR3 = $totalUR3 + $row['UR3'];
			$totalUR4 = $totalUR4 + $row['UR4'];
			$totalUR5 = $totalUR5 + $row['UR5'];
			$totalUR6 = $totalUR6 + $row['UR6'];
			$totalUR7 = $totalUR7 + $row['UR7'];
			$totalUR8 = $totalUR8 + $row['UR8'];
			$totalUR9 = $totalUR9 + $row['UR9'];
			$totalUR10 = $totalUR10 + $row['UR10'];
			$totalUR11 = $totalUR11 + $row['UR11'];
			$totalUR12 = $totalUR12 + $row['UR12'];
			$totalSudah = $row['SUDAH'];
			$totalBelum = $row['BELUM'];
			$rec++;
			$recC++;
			$recSingle++;
		    } else if (trim($row["ELEKTRO"]) != "") {
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('F' . $rec2, $row["ELEKTRO"])->setCellValue('G' . $rec2, $row["MK_P"] + $row["MK_B"])->setCellValue('H' . $rec2, $row["TMK_P"] + $row["TMK_B"]);
			$this->newphpexcel->set_detilstyle(array('A' . $rec2, 'B' . $rec2, 'C' . $rec2, 'D' . $rec2, 'E' . $rec2, 'F' . $rec2, 'G' . $rec2, 'H' . $rec2, 'I' . $rec2, 'J' . $rec2, 'K' . $rec2, 'L' . $rec2, 'M' . $rec2, 'N' . $rec2, 'O' . $rec2, 'P' . $rec2, 'Q' . $rec2, 'R' . $rec2, 'S' . $rec2, 'T' . $rec2, 'U' . $rec2, 'V' . $rec2, 'W' . $rec2, 'X' . $rec2, 'Y' . $rec2, 'Z' . $rec2, 'AA' . $rec2, 'AB' . $rec2, 'AC' . $rec2));
			$this->newphpexcel->set_wrap(array('G' . $rec));
			$total = $total + $row['MK_P'] + $row['MK_B'] + $row['TMK_P'] + $row['TMK_B'];
			$totalMK = $totalMK + $row['MK_P'] + $row['MK_B'];
			$totalTMK = $totalTMK + $row['TMK_P'] + $row['TMK_B'];
			$totalUR0 = $totalUR0 + $row['UR0'];
			$totalUR1 = $totalUR1 + $row['UR1'];
			$totalUR2 = $totalUR2 + $row['UR2'];
			$totalUR3 = $totalUR3 + $row['UR3'];
			$totalUR4 = $totalUR4 + $row['UR4'];
			$totalUR5 = $totalUR5 + $row['UR5'];
			$totalUR6 = $totalUR6 + $row['UR6'];
			$totalUR7 = $totalUR7 + $row['UR7'];
			$totalUR8 = $totalUR8 + $row['UR8'];
			$totalUR9 = $totalUR9 + $row['UR9'];
			$totalUR10 = $totalUR10 + $row['UR10'];
			$totalUR11 = $totalUR11 + $row['UR11'];
			$totalUR12 = $totalUR12 + $row['UR12'];
			$totalSudah = $row['SUDAH'];
			$totalBelum = $row['BELUM'];
			$rec2++;
			$recE++;
			$recSingle++;
		    } else if (trim($row["LUAR"]) != "") {
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('I' . $rec3, $row["LUAR"])->setCellValue('J' . $rec3, $row["MK_P"] + $row["MK_B"])->setCellValue('K' . $rec3, $row["TMK_P"] + $row["TMK_B"]);
			$this->newphpexcel->set_detilstyle(array('A' . $rec3, 'B' . $rec3, 'C' . $rec3, 'D' . $rec3, 'E' . $rec3, 'F' . $rec3, 'G' . $rec3, 'H' . $rec3, 'I' . $rec3, 'J' . $rec3, 'K' . $rec3, 'L' . $rec3, 'M' . $rec3, 'N' . $rec3, 'O' . $rec3, 'P' . $rec3, 'Q' . $rec3, 'R' . $rec3, 'S' . $rec3, 'T' . $rec3, 'U' . $rec3, 'V' . $rec3, 'W' . $rec3, 'X' . $rec3, 'Y' . $rec3, 'Z' . $rec3, 'AA' . $rec3, 'AB' . $rec3, 'AC' . $rec3));
			$total = $total + $row['MK_P'] + $row['MK_B'] + $row['TMK_P'] + $row['TMK_B'];
			$totalMK = $totalMK + $row['MK_P'] + $row['MK_B'];
			$totalTMK = $totalTMK + $row['TMK_P'] + $row['TMK_B'];
			$totalUR0 = $totalUR0 + $row['UR0'];
			$totalUR1 = $totalUR1 + $row['UR1'];
			$totalUR2 = $totalUR2 + $row['UR2'];
			$totalUR3 = $totalUR3 + $row['UR3'];
			$totalUR4 = $totalUR4 + $row['UR4'];
			$totalUR5 = $totalUR5 + $row['UR5'];
			$totalUR6 = $totalUR6 + $row['UR6'];
			$totalUR7 = $totalUR7 + $row['UR7'];
			$totalUR8 = $totalUR8 + $row['UR8'];
			$totalUR9 = $totalUR9 + $row['UR9'];
			$totalUR10 = $totalUR10 + $row['UR10'];
			$totalUR11 = $totalUR11 + $row['UR11'];
			$totalUR12 = $totalUR12 + $row['UR12'];
			$totalSudah = $row['SUDAH'];
			$totalBelum = $row['BELUM'];
			$rec3++;
			$recL++;
			$recSingle++;
		    }
		    $bbpom = $row["NAMA_BBPOM"];
		    $rec4++;
		}
	    } else {
		$this->newphpexcel->getActiveSheet()->mergeCells('A8:O8');
		$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A8', 'Data Pengawasan Iklan Tidak Ditemukan');
	    }
	    if (($rec5 > 0 && $no > 2) || $rec5 == 0) {
		$arrCt = array($recC, $recE, $recL);
		$arrFilt = array_filter($arrCt);
		$arrMax = max($arrFilt);
		$recMin = min($arrFilt);
		$recMax = $arrMax - 1;
		$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('L' . $recMin, $total)->setCellValue('M' . $recMin, $totalMK)->setCellValue('N' . $recMin, $totalTMK)->setCellValue('O' . $recMin, $totalSudah)->setCellValue('P' . $recMin, $totalBelum)->setCellValue('Q' . $recMin, $totalUR0)->setCellValue('R' . $recMin, $totalUR1)->setCellValue('S' . $recMin, $totalUR2)->setCellValue('T' . $recMin, $totalUR3)->setCellValue('U' . $recMin, $totalUR4)->setCellValue('V' . $recMin, $totalUR5)->setCellValue('W' . $recMin, $totalUR6)->setCellValue('X' . $recMin, $totalUR7)->setCellValue('Y' . $recMin, $totalUR8)->setCellValue('Z' . $recMin, $totalUR9)->setCellValue('AA' . $recMin, $totalUR10)->setCellValue('AB' . $recMin, $totalUR11)->setCellValue('AC' . $recMin, $totalUR12);
		$this->newphpexcel->mergecell(array(array('A' . $recMin, 'A' . $recMax), array('B' . $recMin, 'B' . $recMax), array('L' . $recMin, 'L' . $recMax), array('M' . $recMin, 'M' . $recMax), array('N' . $recMin, 'N' . $recMax), array('O' . $recMin, 'O' . $recMax), array('P' . $recMin, 'P' . $recMax), array('Q' . $recMin, 'Q' . $recMax), array('R' . $recMin, 'R' . $recMax), array('S' . $recMin, 'S' . $recMax), array('T' . $recMin, 'T' . $recMax), array('U' . $recMin, 'U' . $recMax), array('V' . $recMin, 'V' . $recMax), array('W' . $recMin, 'W' . $recMax), array('X' . $recMin, 'X' . $recMax), array('Y' . $recMin, 'Y' . $recMax), array('Z' . $recMin, 'Z' . $recMax), array('AA' . $recMin, 'AA' . $recMax), array('AB' . $recMin, 'AB' . $recMax), array('AC' . $recMin, 'AC' . $recMax)), FALSE);
	    } else if ($rec5 > 0 && $no == 2) {
		$arrCt = array($recC, $recE, $recL);
		$arrFilt = array_filter($arrCt);
		$arrMax = max($arrFilt);
		$recMin = 8;
		$recMax = $arrMax - 1;
		$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('L' . $recMin, $total)->setCellValue('M' . $recMin, $totalMK)->setCellValue('N' . $recMin, $totalTMK)->setCellValue('O' . $recMin, $totalSudah)->setCellValue('P' . $recMin, $totalBelum)->setCellValue('Q' . $recMin, $totalUR0)->setCellValue('R' . $recMin, $totalUR1)->setCellValue('S' . $recMin, $totalUR2)->setCellValue('T' . $recMin, $totalUR3)->setCellValue('U' . $recMin, $totalUR4)->setCellValue('V' . $recMin, $totalUR5)->setCellValue('W' . $recMin, $totalUR6)->setCellValue('X' . $recMin, $totalUR7)->setCellValue('Y' . $recMin, $totalUR8)->setCellValue('Z' . $recMin, $totalUR9)->setCellValue('AA' . $recMin, $totalUR10)->setCellValue('AB' . $recMin, $totalUR11)->setCellValue('AC' . $recMin, $totalUR12);
		$this->newphpexcel->mergecell(array(array('A' . $recMin, 'A' . $recMax), array('B' . $recMin, 'B' . $recMax), array('L' . $recMin, 'L' . $recMax), array('M' . $recMin, 'M' . $recMax), array('N' . $recMin, 'N' . $recMax), array('O' . $recMin, 'O' . $recMax), array('P' . $recMin, 'P' . $recMax), array('Q' . $recMin, 'Q' . $recMax), array('R' . $recMin, 'R' . $recMax), array('S' . $recMin, 'S' . $recMax), array('T' . $recMin, 'T' . $recMax), array('U' . $recMin, 'U' . $recMax), array('V' . $recMin, 'V' . $recMax), array('W' . $recMin, 'W' . $recMax), array('X' . $recMin, 'X' . $recMax), array('Y' . $recMin, 'Y' . $recMax), array('Z' . $recMin, 'Z' . $recMax), array('AA' . $recMin, 'AA' . $recMax), array('AB' . $recMin, 'AB' . $recMax), array('AC' . $recMin, 'AC' . $recMax)), FALSE);
	    }
	    $ketInt = 1;
	    $titleRincian = $rec + 5;
	    $arrKet = array(1 => "Iklan produk tanpa izin edar (TIE)", 2 => "Testimoni", 3 => "Menawarkan hadiah/ garansi/ gratis", 4 => "Berlebihan", 5 => "Mengiklankan produk yang perlu diagnosa dan penanganan dokter (kanker, diabetes, liver, TBC, dll)", 6 => "Gambar tidak etis", 7 => "Diperankan oleh tenaga kesehatan/ setting atribut profesi kesehatan/ tokoh agama/ guru/ tokoh masyarakat/ pejabat publik ", 8 => "Iklan dengan pemeran anak-anak dan keputusan diambil oleh anak-anak", 9 => "Mencantumkan grafik hasil penelitian tanpa data pendukung yang kuat ", 10 => "Iklan produk hanya dalam bahasa asing yang tidak dipahami secara umum", 11 => "Mencantumkan gambar organ tubuh bagian dalam", 12 => "Mencantumkan gambar/ tulisan yang tidak terdapat dalam komposisi", 13 => "Tidak mencantumkan spot peringatan");
	    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A' . $titleRincian, "Rincian TMK");
	    $this->newphpexcel->mergecell(array(array('A' . $titleRincian, 'I' . $titleRincian)), FALSE);
	    $this->newphpexcel->headings(array('A' . $titleRincian));
	    $this->newphpexcel->set_detilstyle(array('A' . $titleRincian, 'B' . $titleRincian, 'C' . $titleRincian, 'D' . $titleRincian, 'E' . $titleRincian, 'F' . $titleRincian, 'G' . $titleRincian, 'H' . $titleRincian, 'I' . $titleRincian));
	    for ($ketInt; $ketInt <= 13; $ketInt++) {
		$ketRec = $rec + $ketInt + 5;
		$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A' . $ketRec, $ketInt . " ")->setCellValue('B' . $ketRec, "   " . $arrKet[$ketInt]);
		$this->newphpexcel->set_detilstyle(array('A' . $ketRec, 'B' . $ketRec, 'C' . $ketRec, 'D' . $ketRec, 'E' . $ketRec, 'F' . $ketRec, 'G' . $ketRec, 'H' . $ketRec, 'I' . $ketRec));
		$this->newphpexcel->set_wrap(array('A' . $ketRec, 'B' . $ketRec, 'C' . $ketRec, 'D' . $ketRec, 'E' . $ketRec, 'F' . $ketRec, 'G' . $ketRec, 'H' . $ketRec, 'I' . $ketRec));
		$this->newphpexcel->mergecell(array(array('B' . $ketRec, 'I' . $ketRec)), FALSE);
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
	    $judul = "OBAT TRADISIONAL";
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
		    $kolomBalai = "YES";
		} else {
		    $filter2 .= " AND TI.BBPOM_ID = '" . $this->input->post('BBPOM_ID') . "'";
		    $balai = $sipt->main->get_uraian("SELECT NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID = '" . $this->input->post('BBPOM_ID') . "'", "NAMA_BBPOM");
		    $kolomBalai = "NO";
		}
	    } else {
		$filter2 .= " AND TI.BBPOM_ID = '" . $this->newsession->userdata('SESS_BBPOM_ID') . "'";
		$balai = $sipt->main->get_uraian("SELECT NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID = '" . $this->newsession->userdata('SESS_BBPOM_ID') . "'", "NAMA_BBPOM");
		$kolomBalai = "YES";
	    }
	    if ($this->input->post('HASIL') != "")
		$filterHasil = " AND dbo.GET_DATA_FROM_IKLAN(TI.IKLAN_ID) = '" . $this->input->post('HASIL') . "'";
	    $query = "SELECT DISTINCT TI.IKLAN_ID, (REPLACE(REPLACE(MB.NAMA_BBPOM,'BALAI BESAR POM DI ', ''),'BALAI POM DI ','')) AS NAMA_BBPOM, dbo.GET_KOMODITI(TI.KOMODITI) AS KOMODITI, TI.JENIS_IKLAN, CASE(SELECT COUNT(MM2.NAMA_MEDIA) AS MEDIA FROM M_MEDIA MM2 WHERE CONVERT(VARCHAR(100),MM2.ID_MEDIA) = TI.NAMA_MEDIA) WHEN 0 THEN (CASE CONVERT(VARCHAR(100), TI.NAMA_MEDIA) WHEN '0' THEN '-' ELSE CONVERT(VARCHAR(100), TI.NAMA_MEDIA) END) ELSE MM.NAMA_MEDIA END AS NAMA_MEDIA, TI.MEDIA, TI.ALAMAT_LOKASI_IKLAN, CONVERT(VARCHAR(10), TI.TANGGAL_MULAI, 120) AS TANGGAL_MULAI, CONVERT(VARCHAR(10), TI.TANGGAL_AKHIR, 120) AS TANGGAL_AKHIR, CONVERT(VARCHAR(1000),TI.JUSTIFIKASI_PUSAT) AS JUSTIFIKASI_PUSAT, dbo.GET_PRODUK_PENGAWASAN(TI.IKLAN_ID, 'IKLAN', 'PRODUK') AS NAMA_PRODUK, dbo.GET_PRODUK_PENGAWASAN(TI.IKLAN_ID, 'IKLAN', 'NIE') AS NAMA_PEMILIK_NIE, dbo.GET_PRODUK_PENGAWASAN(TI.IKLAN_ID, 'IKLAN', 'NOMOR') AS NIE, TIO.URAIAN_PELANGGARAN, TIO.NARASI, TIO.TL_BALAI, TI.HASIL, TI.HASIL_PUSAT, TI.DETAIL_PUSAT, TI.TL_PUSAT FROM T_IKLAN TI LEFT JOIN M_BBPOM MB ON TI.BBPOM_ID = MB.BBPOM_ID LEFT JOIN T_IKLAN_OT TIO ON TI.IKLAN_ID = TIO.IKLAN_ID LEFT JOIN M_MEDIA MM ON CONVERT(VARCHAR(MAX),MM.ID_MEDIA) = TI.NAMA_MEDIA  WHERE $filter2 $filterHasil AND TI.KOMODITI = '010' GROUP BY MB.BBPOM_ID, MB.NAMA_BBPOM, TI.KOMODITI, TI.JENIS_IKLAN, MM.NAMA_MEDIA, TI.NAMA_MEDIA, TI.ALAMAT_LOKASI_IKLAN, TI.TANGGAL_MULAI, TI.TANGGAL_AKHIR, TI.IKLAN_ID, TIO.URAIAN_PELANGGARAN, TIO.NARASI, TIO.TL_BALAI, TI.MEDIA, TI.HASIL, TI.HASIL_PUSAT, TI.DETAIL_PUSAT, TI.TL_PUSAT, CONVERT(VARCHAR(1000),TI.JUSTIFIKASI_PUSAT) ORDER BY 1";
	    $this->newphpexcel->set_font('Calibri', 10);
	    $this->newphpexcel->setActiveSheetIndex(0);
	    $this->newphpexcel->set_title('LAPORAN IKLAN OT');
	    $this->newphpexcel->mergecell(array(array('A1', 'D1'), array('A2', 'D2'), array('A3', 'D3'), array('A4', 'D4'), array('K6', 'L6'), array('M6', 'N6')), TRUE);
	    $this->newphpexcel->mergecell(array(array('A6', 'A7'), array('B6', 'B7'), array('C6', 'C7'), array('D6', 'D7'), array('E6', 'E7'), array('F6', 'F7'), array('G6', 'G7'), array('H6', 'H7'), array('I6', 'I7'), array('J6', 'J7'), array('O6', 'O7'), array('P6', 'P7')), FALSE);
	    $this->newphpexcel->width(array(array('A', 4), array('B', 25), array('C', 20), array('D', 23), array('E', 20), array('F', 20), array('G', 25), array('H', 30), array('I', 50), array('J', 50), array('K', 10), array('L', 10), array('M', 20), array('N', 20), array('O', 50), array('P', 32)));
	    $this->newphpexcel->set_bold(array('A1', 'A2', 'A3', 'A4'));
	    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A1', 'LAPORAN HASIL PENGAWASAN IKLAN')->setCellValue('A2', $judul)->setCellValue('A3', strtoupper($balai))->setCellValue('A4', 'PERIODE : ' . $awal . ' s.d ' . $akhir);
	    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A6', 'No')->setCellValue('B6', 'Nama Produk')->setCellValue('C6', 'NIE')->setCellValue('D6', 'Produsen / Distributor')->setCellValue('E6', 'Jenis Media')->setCellValue('F6', 'Media Iklan')->setCellValue('G6', 'Nama Media')->setCellValue('H6', 'Tanggal Periksa')->setCellValue('I6', 'Klaim Iklan')->setCellValue('J6', 'Uraian Pelanggaran')->setCellValue('K6', 'Kesimpulan')->setCellValue('M6', 'Tindak Lanjut')->setCellValue('O6', 'Justifikasi')->setCellValue('P6', 'Unit / Balai')->setCellValue('K7', 'Balai')->setCellValue('L7', 'Pusat')->setCellValue('M7', 'Balai')->setCellValue('N7', 'Pusat');
	    $this->newphpexcel->headings(array('A6', 'B6', 'C6', 'D6', 'E6', 'F6', 'G6', 'H6', 'I6', 'J6', 'K6', 'L6', 'M6', 'N6', 'O6', 'P6'));
	    $this->newphpexcel->headings(array('A7', 'B7', 'C7', 'D7', 'E7', 'F7', 'G7', 'H7', 'I7', 'J7', 'K7', 'L7', 'M7', 'N7', 'O7', 'P7'));
	    $this->newphpexcel->set_wrap(array('B6', 'I7', 'J7', 'K7', 'L7', 'M7', 'N7', 'O7', 'P7'));
	    $data = $sipt->main->get_result($query);
	    if ($data) {
		$no = 1;
		$rec = 8;
		$uraianArr = $this->config->item('uraian_iklan_ot');
		$TLPusatArr = $this->config->item('tl_pusat_iklan_ot2');
		$TLBalaiArr = $this->config->item('tl_balai_iklan_ot');
		foreach ($query->result_array() as $row) {
		    $uraianPelanggaran = explode('#', $row['URAIAN_PELANGGARAN']);
		    $i = 0;
		    $uraianTxt = " - ";
		    foreach ($uraianPelanggaran as $value) {
			if (trim($value) != "") {
			    $uraianTxt = $uraianArr[$i];
			}
			$i++;
		    }
		    if ($kolomBalai == "YES") {
			$hasilBalai = $row["HASIL"];
			$tlBalai = $TLBalaiArr[$row["TL_BALAI"]];
		    } else {
			$hasilBalai = "-";
			$tlBalai = "-";
		    }
		    $justifikasi = preg_replace('/(?:<|&lt;)\/?([a-zA-Z]+) *[^<\/]*?(?:>|&gt;)/', '', $row['JUSTIFIKASI_PUSAT']) . "\n";
		    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A' . $rec, $no)->setCellValue('B' . $rec, $row["NAMA_PRODUK"])->setCellValue('C' . $rec, $row["NIE"])->setCellValue('D' . $rec, $row["NAMA_PEMILIK_NIE"])->setCellValue('E' . $rec, $row["JENIS_IKLAN"])->setCellValue('F' . $rec, $row["MEDIA"])->setCellValue('G' . $rec, $row["NAMA_MEDIA"])->setCellValue('H' . $rec, $row["TANGGAL_MULAI"] . " s/d " . $row["TANGGAL_AKHIR"])->setCellValue('I' . $rec, $row["NARASI"])->setCellValue('J' . $rec, $uraianTxt)->setCellValue('K' . $rec, $hasilBalai)->setCellValue('L' . $rec, $row["HASIL_PUSAT"])->setCellValue('M' . $rec, $tlBalai)->setCellValue('N' . $rec, $TLPusatArr[$row["TL_PUSAT"]])->setCellValue('O' . $rec, $justifikasi)->setCellValue('P' . $rec, $row["NAMA_BBPOM"]);
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