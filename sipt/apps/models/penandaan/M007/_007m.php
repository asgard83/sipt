<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
error_reporting(E_ERROR);

class _007m extends Model {

// function getListFormPenandaan($klasifikasi, $jenisPelaporan = "", $user = "") {
//  if ($this->newsession->userdata('LOGGED_IN') == TRUE) {
//   $sipt = & get_instance();
//   $this->load->model("main", "main", true);
//   $this->load->model("penandaan/penandaan_act");
//   if ($jenisPelaporan == "1101") {
//    $jenis = '1';
//    $jenisTxt = 'draft';
//    $proses['Proses Data Pengawasan'] = array('GET', site_url() . "/penandaan/penandaanController/prosesPreview/preview", '1');
//   }
//   if ($jenisPelaporan == "0303") {
//    $jenis = '4';
//    $jenisTxt = 'draft';
//    $proses['Proses Data Pengawasan'] = array('GET', site_url() . "/penandaan/penandaanController/prosesPreview/preview", '1');
//   }
//   if ($jenisPelaporan == "0313") {
//    $jenis = '4';
//    $jenisTxt = 'draft';
//    $proses['Proses Data Pengawasan'] = array('GET', site_url() . "/penandaan/penandaanController/prosesPreview/preview", '1');
//   }
//   if ($jenisPelaporan == "0404") {
//    $jenis = '3';
//    $jenisTxt = 'draft';
//    $proses['Proses Data Pengawasan'] = array('GET', site_url() . "/penandaan/penandaanController/prosesPreview/preview", '1');
//   }
//   if ($jenisPelaporan == "0101") {
//    $jenis = '2';
//    $jenisTxt = 'draft';
//   }
//   if ($jenisPelaporan == "1111") {
//    $jenis = '5';
//    $jenisTxt = 'draft';
//    $proses['Proses Data Pengawasan'] = array('GET', site_url() . "/penandaan/penandaanController/prosesPreview/preview", '1');
//   }
//   if (in_array('2', $this->newsession->userdata('SESS_KODE_ROLE')) && $jenisTxt == 'draft' && $user == '2') {
//    $status = '2050' . $jenis;
//    if ((in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))))
//     $status = '2051' . $jenis;
//    if ($jenisPelaporan != '0101') {
//     if ($jenisPelaporan == '1101')
//      $proses['Kirim Semua Data'] = array('MPOST', site_url() . "/penandaan/penandaanController/setCheck/ajax", 'N');
//     if ($jenisPelaporan != '1111') {
//      $proses['Edit Data Pengawasan'] = array('GET', site_url() . "/penandaan/penandaanController/prosesEdit/draft", '1');
//      $proses['Edit Surat Tugas Pengawasan'] = array('GET', site_url() . "/penandaan/penandaanController/prosesEdit/suratTugas", '1');
//     }
//    }
//    else
//     $proses['Proses Data Perbaikan Pengawasan'] = array('GET', site_url() . "/penandaan/penandaanController/prosesEdit/draft", '1');
//    $statusJudul = $status;
//    $where = " TP.STATUS = '" . $status . "' AND TPP2.CREATEDBY = TP.USER_LAST_UPDATE AND TPP2.STATUS = '" . $status . "' AND CAST(TPP2.PENANDAAN_ID AS VARCHAR) = CAST(TP.PENANDAAN_ID AS VARCHAR) ";
//   } else if (in_array('3', $this->newsession->userdata('SESS_KODE_ROLE')) && $jenisTxt == 'draft' && $user == '3') {
//    $status = '3050' . $jenis;
//    if (in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')))
//     $status = '3051' . $jenis;
//    if ($jenisPelaporan != '0101')
//     $proses['Kirim Semua Data'] = array('MPOST', site_url() . "/penandaan/penandaanController/setCheck/ajax", 'N');
//    $proses['Proses Data Pengawasan'] = array('GET', site_url() . "/penandaan/penandaanController/prosesPreview/preview", '1');
//    $statusJudul = $status;
//    $where = " TP.STATUS = '" . $status . "' AND TPP2.CREATEDBY = TP.USER_LAST_UPDATE AND TPP2.STATUS = '" . $status . "' AND CAST(TPP2.PENANDAAN_ID AS VARCHAR) = CAST(TP.PENANDAAN_ID AS VARCHAR) ";
//   } else if (in_array('4', $this->newsession->userdata('SESS_KODE_ROLE')) && $jenisTxt == 'draft' && $user == '4') {
//    $status = '4050' . $jenis;
//    if (in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')))
//     $status = '4051' . $jenis;
//    if ($jenisPelaporan != '0101')
//     $proses['Kirim Semua Data'] = array('MPOST', site_url() . "/penandaan/penandaanController/setCheck/ajax", 'N');
//    $proses['Proses Data Pengawasan'] = array('GET', site_url() . "/penandaan/penandaanController/prosesPreview/preview", '1');
//    $statusJudul = $status;
//    $where = " TP.STATUS = '" . $status . "' AND TPP2.CREATEDBY = TP.USER_LAST_UPDATE AND TPP2.STATUS = '" . $status . "' AND CAST(TPP2.PENANDAAN_ID AS VARCHAR) = CAST(TP.PENANDAAN_ID AS VARCHAR) ";
//   } else if (in_array('5', $this->newsession->userdata('SESS_KODE_ROLE')) && $jenisTxt == 'draft' && $user == '5') {
//    $status = '5050' . $jenis;
//    if ($jenisPelaporan != '0101')
//     $proses['Kirim Semua Data'] = array('MPOST', site_url() . "/penandaan/penandaanController/setCheck/ajax", 'N');
//    $proses['Proses Data Pengawasan'] = array('GET', site_url() . "/penandaan/penandaanController/prosesPreview/preview", '1');
//    $statusJudul = $status;
//    $where = " TP.STATUS = '" . $status . "' AND TPP2.CREATEDBY = TP.USER_LAST_UPDATE AND TPP2.STATUS = '" . $status . "' AND CAST(TPP2.PENANDAAN_ID AS VARCHAR) = CAST(TP.PENANDAAN_ID AS VARCHAR) ";
//   }
//   if ($jenisPelaporan == "1221" || $jenisPelaporan == "1222") {
//    if (in_array('6', $this->newsession->userdata('SESS_KODE_ROLE'))) {
//     $status = '60511';
//     $statusJudul = $status;
//     $proses['Tutup Kasus'] = array('MPOST', site_url() . "/penandaan/penandaanController/setCheck/ajax", 'N');
//     $proses['Proses Data Pengawasan'] = array('GET', site_url() . "/penandaan/penandaanController/prosesPreview/preview", '1');
//    } else {
//     $this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.', '/home');
//    }
//    $where = " TP.STATUS = '" . $status . "' AND TPP2.CREATEDBY = TP.USER_LAST_UPDATE AND TPP2.STATUS = '" . $status . "' AND CAST(TPP2.PENANDAAN_ID AS VARCHAR) = CAST(TP.PENANDAAN_ID AS VARCHAR) ";
//   }
//   if ($jenisPelaporan == "1212") {
//    $status = $sipt->penandaan_act->statusSend();
//    if (count($this->newsession->userdata('SESS_KODE_ROLE')) > 1) {
//     $judul = "Data - Terkirim";
//     $statusJudul = "data";
//    } else {
//     if (in_array('2', $this->newsession->userdata('SESS_KODE_ROLE'))) {
//      $statusJudul = '20504';
//      if (in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')))
//       $statusJudul = '20514';
//     }
//     if (in_array('3', $this->newsession->userdata('SESS_KODE_ROLE'))) {
//      $statusJudul = '30505';
//      if (in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')))
//       $statusJudul = '30515';
//     }
//     if (in_array('4', $this->newsession->userdata('SESS_KODE_ROLE'))) {
//      $statusJudul = '40504';
//      if (in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')))
//       $statusJudul = '40514';
//     }
//     if (in_array('5', $this->newsession->userdata('SESS_KODE_ROLE'))) {
//      $statusJudul = '50504';
//     }
//     if (in_array('6', $this->newsession->userdata('SESS_KODE_ROLE'))) {
//      $status = '20501';
//     }
//    }
//    $proses['Lihat Data Pengawasan'] = array('GET', site_url() . "/penandaan/penandaanController/prosesPreview/preview", '1');
//    $where = " TP.STATUS IN (" . $status . ") ";
//   }
//   if ($jenisPelaporan == "1122") {
//    $status = '60510';
//    $statusJudul = $status;
//    $proses['Lihat Data Pengawasan'] = array('GET', site_url() . "/penandaan/penandaanController/prosesPreview", '1');
//    $where = " TP.STATUS = '" . $status . "' AND TPP2.CREATEDBY = TP.USER_LAST_UPDATE AND TPP2.STATUS = TP.STATUS AND CAST(TPP.PENANDAAN_ID AS VARCHAR) = CAST(TP.PENANDAAN_ID AS VARCHAR) ";
//   }
//   if ($jenisPelaporan == "2111") {
//    if (in_array('3', $this->newsession->userdata('SESS_KODE_ROLE'))) {
//     $status = '30504';
//     $statusJudul = $status;
//    } else if (in_array('4', $this->newsession->userdata('SESS_KODE_ROLE')))
//     $status = '50501';
//    else if (in_array('5', $this->newsession->userdata('SESS_KODE_ROLE')))
//     $status = '60505';
//    else if (in_array('6', $this->newsession->userdata('SESS_KODE_ROLE')))
//     $status = '20501';
//    $role = 'ditolak';
//    $where = " TP.STATUS = '" . $status . "' AND TPP.CREATEDBY = TP.USER_LAST_UPDATE AND TPP.STATUS = '" . $status . "' AND CAST(TPP.PENANDAAN_ID AS VARCHAR) = CAST(TP.PENANDAAN_ID AS VARCHAR) ";
//   }
//   $this->load->library('newtable');
//   $this->newtable->action(site_url() . "/penandaan/penandaanController/setListFormPenandaanLanjutan/" . $jenisPelaporan . "/" . $klasifikasi);
//   $this->newtable->detail(site_url() . "/penandaan/penandaanController/setPreview/" . $klasifikasi . "/" . $jenisPelaporan);
//   $this->newtable->cidb($this->db);
//   $this->newtable->ciuri($this->uri->segment_array());
//   $this->newtable->hiddens(array('PENANDAANID', 'LASTUPDATEROW'));
//   $this->newtable->keys(array('PENANDAANID'));
//   $this->newtable->search(array(array('TPP.NAMA_PRODUK', 'Nama Produk'), array('CONVERT(VARCHAR(10), TP.TANGGAL_MULAI, 120)', 'Tanggal Awal Periksa'), array('CONVERT(VARCHAR(10), TP.TANGGAL_AKHIR, 120)', 'Tanggal Akhir Periksa'), array('{IN}TP.PENANDAAN_ID IN (SELECT Y.PENANDAAN_ID FROM T_PENANDAAN Y WHERE Y.PENANDAAN_ID IN(SELECT TSTP.SURAT_ID FROM T_SURAT_TUGAS_PENANDAAN TSTP WHERE TSTP.SURAT_ID = Y.SURAT_ID AND TSTP.NOMOR_SURAT {LIKE}))', 'Nomor Surat Tugas')));
////      $proses['Data Petugas Pemeriksa'] = array('GET', site_url() . "/home/pelaporan/petugas", '1');
////      $proses['Hapus Data Pemeriksaan'] = array('POST', site_url() . "/post/pemeriksaan/hapus_act/delete/ajax", 'N');
//   $query .= "SELECT TP.LAST_UPDATE AS LASTUPDATEROW,(CAST(TP.PENANDAAN_ID AS VARCHAR)+'/'+CAST(TP.STATUS AS VARCHAR))+'/$klasifikasi/$jenisPelaporan/$user'+'/'+CAST(TP.BBPOM_ID AS VARCHAR) AS PENANDAANID, '<b><a href=\"#\" class=\"row_preview\">'+TPP.NAMA_PRODUK+'</a></b><div>'+TPP.BENTUK_SEDIAAN+'</div><div>'+TPP.PRODUSEN+'</div>' AS 'PENGAWASAN PENANDAAN', CONVERT(VARCHAR(10), TP.TANGGAL_MULAI, 120)+'<div>Sampai Dengan</div><div>'+CONVERT(VARCHAR(10), TP.TANGGAL_AKHIR, 120)+'</div>' AS 'TANGGAL PENGAWASAN', dbo.GET_KOMODITI(TP.KOMODITI) AS KATEGORI, MT.URAIAN AS 'Status Terakhir','<div><b>'+dbo.GET_PROPINSI(MS.PROPINSI)+'</b></div>' AS PROPINSI,TU.NAMA_USER+'<div>'+dbo.GET_SELISIH_WAKTU(TP.LAST_UPDATE)+'</div><div><i>'+TPP2.CATATAN+'</i></div><div><a href=\"#\" class=\"row_riwayat2\" record=\"'+CAST(TP.PENANDAAN_ID AS VARCHAR)+'#T_PENANDAAN_PROSES\">Riwayat Pemeriksaan</a></div>' AS [UPDATE TERAKHIR] FROM T_PENANDAAN TP RIGHT JOIN T_PENANDAAN_KOSMETIKA TPK ON TPK.PENANDAAN_ID = TP.PENANDAAN_ID RIGHT JOIN T_PENANDAAN_PROSES TPP2 ON TPP2.PENANDAAN_ID = TP.PENANDAAN_ID RIGHT JOIN T_PENANDAAN_PRODUK TPP ON TPP.PENANDAAN_ID = TP.PENANDAAN_ID RIGHT JOIN T_USER TU ON TU.USER_ID = TP.USER_LAST_UPDATE LEFT JOIN M_TABEL MT ON MT.KODE = TP.STATUS LEFT JOIN M_SARANA MS ON MS.SARANA_ID = TP.SARANA_ID  WHERE" . $where . "AND TPP2.SERI = (SELECT MAX (SERI) AS SERI FROM T_PENANDAAN_PROSES WHERE PENANDAAN_ID = TP.PENANDAAN_ID)";
//   if ((!in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))))
//    $query .= " AND TP.BBPOM_ID = " . $this->newsession->userdata('SESS_BBPOM_ID');
//   if ($jenisPelaporan == "1222" && in_array('6', $this->newsession->userdata('SESS_KODE_ROLE'))) {
//    $query .= " AND TP.BBPOM_ID = '92'";
//    $subJudul = 'Data Pusat';
//   }
//   if ($jenisPelaporan == "1221" && in_array('6', $this->newsession->userdata('SESS_KODE_ROLE'))) {
//    $query .= " AND TP.BBPOM_ID <> '92'";
//    $subJudul = 'Data Balai';
//   }
//   $this->newtable->columns(array("TP.LAST_UPDATE", "(CAST(TP.PENANDAAN_ID AS VARCHAR)+'/'+CAST(TP.STATUS AS VARCHAR))+'/$klasifikasi/$jenisPelaporan/$user'", "'<b><a href=\"#\" class=\"row_preview\">'+TPP.NAMA_PRODUK+'</a></b><div>'+TPP.BENTUK_SEDIAAN+'</div><div>'+TPP.PRODUSEN+'</div>'", "CONVERT(VARCHAR(10), TP.TANGGAL_MULAI, 120)+'<div>Sampai Dengan</div><div>'+CONVERT(VARCHAR(10), TP.TANGGAL_AKHIR, 120)+'</div>'", "TP.KOMODITI", "'MT.URAIAN AS 'Status Terakhir'", "'<div><b>'+dbo.GET_PROPINSI(MS.PROPINSI)+'</b></div>'", "TU.NAMA_USER+'<div>'+dbo.GET_SELISIH_WAKTU(TP.LAST_UPDATE)+'</div><div><i>'+TPP2.CATATAN+'</i></div><div><a href=\"#\" class=\"row_riwayat2\" record=\"'+CAST(TP.PENANDAAN_ID AS VARCHAR)+'#T_PENANDAAN_PROSES\">Riwayat Pemeriksaan</a></div>'"));
//   $this->newtable->orderby(1);
//   $this->newtable->sortby("DESC");
//   $this->newtable->menu($proses);
//   $tabel = $this->newtable->generate($query);
//   $judul = $sipt->main->get_uraian("SELECT URAIAN FROM M_TABEL WHERE JENIS = 'STATUS' AND KODE = $statusJudul", "URAIAN");
//   $arrdata = array('table' => $tabel,
//       'idjudul' => 'judulpmnpdd',
//       'caption_header' => $judul . " " . $subJudul,
//       'batal' => '',
//       'cancel' => '');
//   return $arrdata;
//  } else {
//   $this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.', '/home');
//  }
// }

    function getFormPenandaan($klasifikasi = '') {
	if ($this->newsession->userdata('LOGGED_IN') == TRUE) {
	    $sipt = & get_instance();
	    $this->load->model("main", "main", true);
	    $kodeProvinsi = substr($this->newsession->userdata('SESS_PROP_ID'), 0, 2);
	    $detailProvinsiDef = $sipt->main->combobox("SELECT PROPINSI_ID, NAMA_PROPINSI FROM M_PROPINSI WHERE LEFT(PROPINSI_ID, 2) = '" . $kodeProvinsi . "' AND RIGHT(PROPINSI_ID, 2) != '00'", "NAMA_PROPINSI", "NAMA_PROPINSI", TRUE);
	    $provinsi = $sipt->main->combobox("SELECT PROPINSI_ID, NAMA_PROPINSI FROM M_PROPINSI WHERE LEFT(PROPINSI_ID, 1) <= '9' AND RIGHT(PROPINSI_ID, 2) = '00' AND LEFT(PROPINSI_ID, 2) = '" . $kodeProvinsi . "'", "PROPINSI_ID", "NAMA_PROPINSI");
	    $arrdata = array('provinsi' => $provinsi, 'kabupaten' => $detailProvinsiDef, 'act' => site_url() . '/penandaan/penandaanController/setFormPenandaanLanjutan/pengawasan/' . $klasifikasi, 'batal' => site_url() . '/penandaan/penandaanController/getFormPenandaanLanjutan/' . $klasifikasi, 'histori_petugas' => site_url() . '/load/petugas/get_petugas_2/');
	    $arrayTL[''] = NULL;
	    $arrayTL['Peringatan 1'] = 'Peringatan 1';
	    $arrayTL['Peringatan 2'] = 'Peringatan 2';
	    $arrayTL['Peringatan keras'] = 'Peringatan keras';
	    $arrayTL['Penghentian sementara kegiatan produksi'] = 'Penghentian sementara kegiatan produksi';
	    $arrayTL['Penghentian sementara kegiatan importasi'] = 'Penghentian sementara kegiatan importasi';
	    $arrayTL['Pembatalan izin edar'] = 'Pembatalan izin edar';
	    $arrayTL['Penutupan sementara akses online pengajuan permohonan notifikasi'] = 'Penutupan sementara akses online pengajuan permohonan notifikasi';
	    $arrdata ['cb_tl'] = $arrayTL;
	    $arrdata['editTL'] = 'YES';
	    $jenis = array("" => "", "CRT" => "CRT", "SKT" => "SKT", "SKM" => "SKM", "SPM" => "SPM", "SKTF" => "TIS");
	    $arrdata['jenisTmbk'] = $jenis;
	    $jenisKms = array("" => "", "KPP" => "Kotak persegi panjang", "KSL" => "Kotak dengan sisi lebar yang sama", "SLN" => "Silinder", "BLL" => "Bentuk lainnya");
	    $arrdata['jenisKmsn'] = $jenisKms;
	    $arrdata ['objStatus'] = 'TO';
	    $arrdata ['klasifikasi'] = $klasifikasi;
	    $arrdata ['labelSimpan'] = 'Simpan Data Pengawasan';
	    $arrdata ['icon'] = 'save';
	    return $arrdata;
	} else {
	    $this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.', '/home');
	}
    }

    function setStatus($X, $isajax) {
	if ($this->newsession->userdata('LOGGED_IN') == TRUE) {
	    $sipt = & get_instance();
	    $sipt->load->model("main", "main", true);
	    $ret = "MSG#NO#Data Gagal Dikirim.";
	    $status = $this->input->post('TO');
	    $arr_update = array('STATUS' => $status, "USER_LAST_UPDATE" => $this->newsession->userdata('SESS_USER_ID'), "LAST_UPDATE" => 'GETDATE()');
	    $arr_update_log = array('UPDATED' => 'GETDATE()');
	    $penandaanId = $this->input->post('PENANDAAN_ID');
	    $case = '';
	    foreach ($penandaanId as $a) {
		$this->db->where(array("PENANDAAN_ID" => $a));
		$this->db->update('T_PENANDAAN', $arr_update);
		$seri = (int) $sipt->main->get_uraian("SELECT MAX(SERI) AS MAXID FROM T_PENANDAAN_PROSES WHERE PENANDAAN_ID = '" . $a . "'", "MAXID") + 1;
		$log = array('PENANDAAN_ID' => $a, 'SERI' => $seri, 'STATUS' => $status, 'CATATAN' => $this->input->post('CATATAN'), 'CREATEDBY' => $this->newsession->userdata('SESS_USER_ID'), 'CREATED' => 'GETDATE()', 'UPDATED' => 'GETDATE()');
		if ($this->db->insert('T_PENANDAAN_PROSES', $log)) {
		    $this->db->where(array("PENANDAAN_ID" => $a, "STATUS" => $this->input->post('UPDATE')));
		    $this->db->update('T_PENANDAAN_PROSES', $arr_update_log);
		    $case = 'Log';
		}
		if ($case == 'Log') {
		    if (in_array('2', $this->newsession->userdata('SESS_KODE_ROLE'))) {
			$yes = $this->input->post('EDIT');
			$arr_penandaan = $this->input->post('PENANDAAN');
			$valPenilaian = $this->input->post('VALUEPENILAIAN');
			if (in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')) && $yes == 'YES' && $arr_penandaan) {
			    if ($valPenilaian != $arr_penandaan['HASIL_PUSAT'])
				$justifikasi = $this->input->post('JUSTIFIKASI');
			    if ($arr_penandaan['HASIL_PUSAT'] == "MS") {
				$arrUpdate = array('PUSAT' => $arr_penandaan['HASIL_PUSAT'] . "**" . $justifikasi);
			    } else if ($arr_penandaan['HASIL_PUSAT'] == "TMS") {
				$arrUpdate = array('PUSAT' => $arr_penandaan['HASIL_PUSAT'] . "*" . join("^", $arr_penandaan['TL_PUSAT']) . "*" . $justifikasi);
			    }
			    $this->db->where(array("PENANDAAN_ID" => $a));
			    $this->db->update('T_PENANDAAN_KOSMETIKA', $arrUpdate);
			}
		    }
		    $case = 'Set';
		}
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
	$lampiran = $this->input->post('PENANDAAN_NAPZA');
	$arr_chk = $this->input->post('CHK');
	for ($i = 1; $i <= count($arr_chk['SATU']); $i++) {
	    $arrUraian1[$i] = $arr_chk['SATU'][$i];
	}
	$arr_chk1 = join("^", $arrUraian1);
	for ($i = 1; $i <= count($arr_chk['DUA']); $i++) {
	    $arrUraian2[$i] = $arr_chk['DUA'][$i];
	}
	$arr_chk2 = join("^", $arrUraian2);
	$arr_petugas = $this->session->userdata('USER');
	$suratTugas = $this->session->userdata('SURAT');
	$suratId = (int) $sipt->main->get_uraian("SELECT MAX(SURAT_ID) AS MAXID FROM T_SURAT_TUGAS_PENANDAAN", "MAXID") + 1;
	$tanggalSurat = $this->session->userdata('TANGGAL');
	$hasilSistem = $this->input->post('HASIL');
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
	$penandaan = array('SURAT_ID' => $suratId, 'PENANDAAN_ID' => $penandaan_id, 'BBPOM_ID' => $this->newsession->userdata('SESS_BBPOM_ID'), 'TANGGAL_MULAI' => $arr_penandaan['TANGGALAWAL'], 'TANGGAL_AKHIR' => $arr_penandaan['TANGGALAKHIR'], 'SARANA_ID' => $arr_penandaan['SARANAID'], 'KOMODITI' => $this->input->post('KLASIFIKASIPENANDAAN'), 'STATUS' => $status, 'CREATE_BY' => $this->newsession->userdata('SESS_USER_ID'),  'USER_LAST_UPDATE' => $this->newsession->userdata('SESS_USER_ID'), 'LAST_UPDATE' => 'GETDATE()');
	$this->db->insert('T_PENANDAAN', $penandaan);
	if ($this->db->affected_rows() > 0) {
	    $log = array('PENANDAAN_ID' => $penandaan_id, 'SERI' => 1, 'STATUS' => $status, 'CATATAN' => '', 'CREATEDBY' => $this->newsession->userdata('SESS_USER_ID'), 'CREATED' => 'GETDATE()', 'UPDATED' => 'GETDATE()');
	}
	$this->db->insert('T_PENANDAAN_PROSES', $log);
	if ($this->db->affected_rows() > 0) {
	    $produk = array('PENANDAAN_ID' => $penandaan_id, 'NOMOR_IZIN_EDAR' => '-', 'NAMA_PRODUK' => $arr_produk['NAMA_PRODUK'], 'KLASIFIKASI_PRODUK' => $arr_produk['JENIS'], 'PRODUSEN' => $arr_produk['PRODUSEN'], 'ALAMAT_PRODUSEN' => $arr_produk['ALAMAT_PRODUSEN']);
	    $this->db->insert('T_PENANDAAN_PRODUK', $produk);
	}
	if ($this->db->affected_rows() > 0) {
	    $penandaanNapza = array('PENANDAAN_ID' => $penandaan_id, 'PENILAIAN1' => $arr_chk1, 'PENILAIAN2' => $arr_chk2, 'LAMPIRAN' => $lampiran['FILE_PENANDAAN'], 'SISTEM' => $hasilSistem);
	    $this->db->insert('T_PENANDAAN_NAPZA', $penandaanNapza);
	}
	if ($this->db->affected_rows() > 0) {
	    $case = 'YESPENANDAANNAPZA';
	} else {
	    $case = 'NO';
	}
	if ($case == 'YESPENANDAANNAPZA') {
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
	$lampiran = $this->input->post('PENANDAAN_NAPZA');
	$arr_chk = $this->input->post('CHK');
	for ($i = 1; $i <= count($arr_chk['SATU']); $i++) {
	    $arrUraian1[$i] = $arr_chk['SATU'][$i];
	}
	$arr_chk1 = join("^", $arrUraian1);
	for ($i = 1; $i <= count($arr_chk['DUA']); $i++) {
	    $arrUraian2[$i] = $arr_chk['DUA'][$i];
	}
	$arr_chk2 = join("^", $arrUraian2);
	$hasilSistem = $this->input->post('HASIL');
	$justifikasi = "";
	$detailPusat = "";
	$tLPusat = "";
	$statusUPD = array();
	$saranaUPD = array();
	if ($arr_penandaan["DETAIL_PUSAT"][0] != "")
	    $detailPusat = join("^", $arr_penandaan['DETAIL_PUSAT']);
	if ($arr_penandaan["TL_PUSAT"][0] != "")
	    $tLPusat = join("^", $arr_penandaan['TL_PUSAT']);
	if ($arr_penandaan['HASIL_PUSAT'] != $hasilSistem)
	    $justifikasi = $this->input->post('JUSTIFIKASI');
	if ($arr_penandaan['HASIL_PUSAT'] != "")
	    $hasilPusat = $arr_penandaan['HASIL_PUSAT'] . "*" . $detailPusat . "*" . $tLPusat . "*" . $justifikasi;
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
		$saranaUPD = array('TANGGAL_MULAI' => $arr_penandaan['TANGGALAWAL'], 'TANGGAL_AKHIR' => $arr_penandaan['TANGGALAKHIR'], 'SARANA_ID' => $arr_penandaan['SARANAID'], 'KOMODITI' => '007');
	    }
	    $penandaan = array_merge($statusUPD, $saranaUPD, array('USER_LAST_UPDATE' => $this->newsession->userdata('SESS_USER_ID'), 'LAST_UPDATE' => 'GETDATE()'));
	    $this->db->where(array("PENANDAAN_ID" => $penandaan_id, "SERI" => $seri - 1));
	    $this->db->update('T_PENANDAAN_PROSES', $arr_update_log);
	    $this->db->where(array("PENANDAAN_ID" => $penandaan_id));
	    $this->db->update('T_PENANDAAN', $penandaan);
	    if ($arr_produk) {
		$produk = array('NOMOR_IZIN_EDAR' => '-', 'NAMA_PRODUK' => $arr_produk['NAMA_PRODUK'], 'KLASIFIKASI_PRODUK' => $arr_produk['JENIS'], 'PRODUSEN' => $arr_produk['PRODUSEN'], 'ALAMAT_PRODUSEN' => $arr_produk['ALAMAT_PRODUSEN']);
		$this->db->where(array("PENANDAAN_ID" => $penandaan_id));
		$this->db->update('T_PENANDAAN_PRODUK', $produk);
	    }
	    $penandaanNapza = array('PENILAIAN1' => $arr_chk1, 'PENILAIAN2' => $arr_chk2, 'LAMPIRAN' => $lampiran['FILE_PENANDAAN'], 'SISTEM' => $hasilSistem);
	    $this->db->where(array("PENANDAAN_ID" => $penandaan_id));
	    $this->db->update('T_PENANDAAN_NAPZA', $penandaanNapza);
	    $case = 'YESPENANDAANNAPZA';
	}
	if ($case == 'YESPENANDAANNAPZA') {
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
	$query = "SELECT TPN.PENILAIAN1, TPN.PENILAIAN2, TPN.PENILAIAN3, TP.PENANDAAN_ID, CONVERT(VARCHAR(10), TP.TANGGAL_MULAI, 120) AS TANGGAL_MULAI, CONVERT(VARCHAR(10), TP.TANGGAL_AKHIR, 120) AS TANGGAL_AKHIR, TP.SURAT_ID, TP.STATUS FROM T_PENANDAAN TP LEFT JOIN T_PENANDAAN_NAPZA TPN ON TPN.PENANDAAN_ID = TP.PENANDAAN_ID WHERE TPN.PENANDAAN_ID = '" . $idPengawasan . "'";
	$data = $sipt->main->get_result($query);
	if ($data) {
	    foreach ($query->result_array() as $row) {
		$arrdata = array('sess' => $row, 'judul' => 'Rokok');
	    }
	    if ($row['STATUS'] == '20302' || $row['STATUS'] == '20312') {
		$arrdata['act'] = site_url() . '/penandaan/penandaanController/prosesEdit/edit/' . $row['PENANDAAN_ID'] . '/' . $row['STATUS'] . '/' . $jenisPelaporan;
		$arrdata['tombol'] = 'Lihat Data Perbaikan Pengawasan';
	    } else {
		$arrdata['act'] = site_url() . '/penandaan/penandaanController/prosesPreview/preview/' . $row['PENANDAAN_ID'] . '/' . $row['STATUS'] . '/' . $jenisPelaporan;
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
	$query = "SELECT TSTP.SURAT_ID, TPN.PENILAIAN1, TPN.PENILAIAN2, TPN.LAMPIRAN, TPN.SISTEM, TP.PENANDAAN_ID, CONVERT(VARCHAR(10), " . $tglQuery . ", TP.STATUS, TP.KOMODITI, TP.SARANA_ID, TP.BBPOM_ID, TPP.NAMA_PRODUK, TPP.KLASIFIKASI_PRODUK, TPP.PRODUSEN, TPP.ALAMAT_PRODUSEN, MS.NAMA_SARANA, MS.ALAMAT_1, (SELECT MP1.NAMA_PROPINSI FROM M_PROPINSI MP1 WHERE MP1.PROPINSI_ID = MS.PROPINSI) AS PROPINSI, (SELECT MP2.NAMA_PROPINSI FROM M_PROPINSI MP2 WHERE MP2.PROPINSI_ID = MS.KOTA) AS KOTA FROM T_PENANDAAN TP LEFT JOIN T_PENANDAAN_NAPZA TPN ON TPN.PENANDAAN_ID = TP.PENANDAAN_ID LEFT JOIN T_PENANDAAN_PRODUK TPP ON TPP.PENANDAAN_ID = TP.PENANDAAN_ID LEFT JOIN T_SURAT_TUGAS_PENANDAAN TSTP ON TSTP.SURAT_ID = TP.SURAT_ID LEFT JOIN M_SARANA MS ON MS.SARANA_ID = TP.SARANA_ID WHERE TP.PENANDAAN_ID = '" . $penandaanId . "'";
	$data = $sipt->main->get_result($query);
	if ($data) {
	    foreach ($query->result_array() as $row) {
		$arrdata = array('sess' => $row, 'judul' => 'Rokok');
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
	$status2 = $status;
	$str .= '</table>';
	$arrdata ['sess2'] = $str;
	if ($status == '20502' || $status == '20512' || (($status == '20511' || $status == '20501') && $jenis == 'draft')) {
	    if ((!in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))))
		$arrdata ['act'] = site_url() . "/penandaan/penandaanController/updateStatus/" . $klasifikasi . "/1";
	    else if ((in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) && $status == '20511' && $jenis == 'draft')
		$arrdata ['act'] = site_url() . "/penandaan/penandaanController/updateStatus/" . $klasifikasi . "/1";
	    else
		$arrdata ['act'] = site_url() . "/penandaan/penandaanController/setStatus/1";
	    $arrdata ['subJudul'] = '- ROKOK';
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
	$jenisTmbk = array("" => "", "CRT" => "CRT", "SKT" => "SKT", "SKM" => "SKM", "SPM" => "SPM", "SKTF" => "TIS");
	$arrdata['jenisTmbk'] = $jenisTmbk;
	$jenisKms = array("" => "", "KPP" => "Kotak persegi panjang", "KSL" => "Kotak dengan sisi lebar yang sama", "SLN" => "Silinder", "BLL" => "Bentuk lainnya");
	$arrdata['jenisKmsn'] = $jenisKms;
	if (($subid == '1101' || $subid == '0101') && $jenis != 'preview') {
	    $arrdata ['subJudul'] = '- ROKOK EDIT';
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
	$arrayTL['Peringatan 1'] = 'Peringatan 1';
	$arrayTL['Peringatan 2'] = 'Peringatan 2';
	$arrayTL['Peringatan keras'] = 'Peringatan keras';
	$arrayTL['Penghentian sementara kegiatan produksi'] = 'Penghentian sementara kegiatan produksi';
	$arrayTL['Penghentian sementara kegiatan importasi'] = 'Penghentian sementara kegiatan importasi';
	$arrayTL['Pembatalan izin edar'] = 'Pembatalan izin edar';
	$arrayTL['Penutupan sementara akses online pengajuan permohonan notifikasi'] = 'Penutupan sementara akses online pengajuan permohonan notifikasi';
	$arrdata ['cb_tl'] = $arrayTL;
	$arrayTDKB = array('' => '', '1' => 'Lapor Ke Pusat', '2' => 'Produk Dalam Pengawasan Badan POM');
	$arrdata ['cb_tindakan_balai'] = $arrayTDKB;
	if (!in_array($arrdata ['sess']['STATUS'], $arrayClause)) {
	    if ($status2 != '60510' && ($subid == '1101' || $subid == '0101' || $subid == '0111' || $subid == '1221' || $subid == '1111' || $subid == '1222' || $subid == '0303' || $subid == '0313' || $subid == '0404')) {
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
	    $query = "SELECT DISTINCT (REPLACE(REPLACE(MB.NAMA_BBPOM,'BALAI BESAR POM DI ', ''),'BALAI POM DI ','')) AS NAMA_BBPOM, dbo.GET_KOMODITI(TP.KOMODITI) AS KOMODITI, (SUM(CASE WHEN (TPKOS.PUSAT LIKE '%TMK*%' AND (TP.BBPOM_ID = 92 OR TP.STATUS = 60510)) THEN 1 ELSE 0 END)) AS TMK_P, (SUM(CASE WHEN (TPKOS.PUSAT LIKE 'MK*%' AND (TP.BBPOM_ID = 92 OR TP.STATUS = 60510)) THEN 1 ELSE 0 END)) AS MK_P, (SUM(CASE WHEN (TPKOS.URAIAN LIKE '%#TMK%' AND TP.BBPOM_ID <> 92 AND TP.STATUS <> 60510) THEN 1 ELSE 0 END)) AS TMK_B, (SUM(CASE WHEN (TPKOS.URAIAN LIKE '%#MK%' AND TP.BBPOM_ID <> 92 AND TP.STATUS <> 60510) THEN 1 ELSE 0 END)) AS MK_B, (SUM(CASE WHEN TPKOS.PUSAT LIKE '%^Peringatan Keras%' AND (TP.BBPOM_ID = 92 OR TP.STATUS = 60510) THEN 1 ELSE 0 END)) AS 'KERAS', (SUM(CASE WHEN ((TPKOS.PUSAT LIKE '%^Peringatan%' AND TPKOS.PUSAT NOT LIKE '%^Peringatan Keras%') OR (TPKOS.PUSAT LIKE '%^Peringatan^%')) AND (TP.BBPOM_ID = 92 OR TP.STATUS = 60510)  THEN 1 ELSE 0 END)) AS 'PERINGATAN' FROM T_PENANDAAN TP LEFT JOIN T_PENANDAAN_KOSMETIKA TPKOS ON TPKOS.PENANDAAN_ID = TP.PENANDAAN_ID LEFT JOIN M_BBPOM MB ON TP.BBPOM_ID = MB.BBPOM_ID WHERE $filter2 AND TP.KOMODITI = '012' GROUP BY  MB.BBPOM_ID, MB.NAMA_BBPOM, TP.KOMODITI ORDER BY 1";
	    $this->newphpexcel->set_font('Calibri', 10);
	    $this->newphpexcel->setActiveSheetIndex(0);
	    $this->newphpexcel->set_title('RHPK Pengawasan Pengawasan');
	    $this->newphpexcel->mergecell(array(array('A1', 'F1'), array('A2', 'F2'), array('A3', 'F3'), array('A4', 'F4'), array('C6', 'E6'), array('F6', 'G6')), TRUE);
	    $this->newphpexcel->mergecell(array(array('B6', 'B7'), array('A6', 'A7')), FALSE);
	    $this->newphpexcel->width(array(array('A', 4), array('B', 35), array('C', 11), array('D', 11), array('E', 11), array('F', 11), array('G', 11)));
	    $this->newphpexcel->set_bold(array('A1', 'A2', 'A3', 'A4'));
	    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A1', 'REKAPITULASI HASIL PELAKSANAAN KEGIATAN - PENGAWASAN PENANDAAN - KOSMETIKA')->setCellValue('A2', $judul)->setCellValue('A3', strtoupper($balai))->setCellValue('A4', 'PERIODE : ' . $awal . ' s.d ' . $akhir);
	    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A6', 'No.')->setCellValue('B6', 'BBPOM')->setCellValue('C6', 'Total')->setCellValue('F6', 'Tindak Lanjut')->setCellValue('C7', 'Diperiksa')->setCellValue('D7', 'MK')->setCellValue('E7', 'TMK')->setCellValue('F7', 'Peringatan')->setCellValue('G7', 'Peringatan Keras');
	    $this->newphpexcel->headings(array('A6', 'B6', 'C6', 'D6', 'E6', 'F6', 'G6'));
	    $this->newphpexcel->headings(array('A7', 'B7', 'C7', 'D7', 'E7', 'F7', 'G7'));
	    $this->newphpexcel->set_wrap(array('B6', 'G7'));
	    $this->newphpexcel->getActiveSheet()->getStyle('G')->getAlignment()->setWrapText(true);
	    $data = $sipt->main->get_result($query);
	    if ($data) {
		$no = 1;
		$rec = 8;
		foreach ($query->result_array() as $row) {
		    $total = $row['MK_P'] + $row['MK_B'] + $row['TMK_P'] + $row['TMK_B'];
		    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A' . $rec, $no)->setCellValue('B' . $rec, $row["NAMA_BBPOM"])->setCellValue('C' . $rec, $total)->setCellValue('D' . $rec, $row["MK_P"] + $row["MK_B"])->setCellValue('E' . $rec, $row["TMK_P"] + $row["TMK_B"])->setCellValue('F' . $rec, $row["PERINGATAN"])->setCellValue('G' . $rec, $row["KERAS"]);
		    $this->newphpexcel->set_detilstyle(array('A' . $rec, 'B' . $rec, 'C' . $rec, 'D' . $rec, 'E' . $rec, 'F' . $rec, 'G' . $rec));
		    $this->newphpexcel->getActiveSheet()->getStyle('G' . $rec)->getAlignment()->setWrapText(true);
		    $rec++;
		    $no++;
		    $total = 0;
		}
	    } else {
		$this->newphpexcel->getActiveSheet()->mergeCells('A8:G8');
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