<?php

if (!defined('BASEPATH'))
 exit('No direct script access allowed');
error_reporting(E_ERROR);

class Petugas_act extends Model {

 function list_petugas($id) {
  if ($this->newsession->userdata('LOGGED_IN') || array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('9', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('10', $this->newsession->userdata('SESS_KODE_ROLE'))) {
   $sipt = & get_instance();
   $sipt->load->model("main", "main", true);
   $this->load->library('newtable');
   if ($id == "aktif") {
    $status = "A.STATUS='Aktif'";
    if (array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE'))) {
     $proses['Edit Petugas'] = array('GET', site_url() . "/home/petugas/new", '1');
     $proses['Non Aktifkan Petugas'] = array('POST', site_url() . "/post/master/petugas/non-aktif/ajax", 'N');
     $proses['Kirim Ulang Password Petugas Ke e-Mail'] = array('POST', site_url() . "/post/master/petugas/resend/ajax", 'N');
     $proses['Reset Password Default (NIP)'] = array('POST', site_url() . "/post/master/petugas/default/ajax", 'N');
     $proses['Login'] = array('POST', site_url() . "/post/master/petugas/login/ajax", '1');
    } else if (array_key_exists('9', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('10', $this->newsession->userdata('SESS_KODE_ROLE'))) {
     $proses['Edit Petugas'] = array('GET', site_url() . "/home/petugas/new", '1');
     $proses['Non Aktifkan Petugas'] = array('POST', site_url() . "/post/master/petugas/non-aktif/ajax", 'N');
     $proses['Kirim Ulang Password Petugas Ke e-Mail'] = array('POST', site_url() . "/post/master/petugas/resend/ajax", 'N');
     $proses['Reset Password Default (NIP)'] = array('POST', site_url() . "/post/master/petugas/default/ajax", 'N');
    }
   } else if ($id == "non-aktif") {
    $status = "A.STATUS='Non-Aktif'";
    $proses = array('Aktifkan Petugas' => array('POST', site_url() . "/post/master/petugas/aktif/ajax", 'N'), 'Hapus Petugas' => array('POST', site_url() . "/master/master/petugas/hapus/ajax", 'N'));
   } else {
    $this->fungsi->redirectMessage('Maaf, halaman yang anda tuju tidak ditemukan.', '/home');
   }

   if (array_key_exists('9', $this->newsession->userdata('SESS_KODE_ROLE'))) {
    $sarana = "'" . join("','", $this->newsession->userdata('SESS_SARANA')) . "'";
    #$query = "SELECT A.USER_ID AS NIP, A.NAMA_USER AS [NAMA PETUGAS], A.JABATAN + '<div>'+ STUFF(dbo.GROUP_ROLE(A.USER_ID),1,1,'') + '</div>' AS JABATAN, dbo.GROUP_BIDANG(A.USER_ID) AS [PELAPORAN],  A.EMAIL FROM T_USER A LEFT JOIN M_BBPOM B ON A.BBPOM_ID = B.BBPOM_ID WHERE A.BBPOM_ID='".$this->newsession->userdata('SESS_BBPOM_ID')."' AND A.USER_ID IN (SELECT DISTINCT USER_ID FROM T_USER_ROLE WHERE ROLE NOT IN('1','9','10')) AND $status";
    $query = "SELECT A.USER_ID AS NIP, A.NAMA_USER AS [NAMA PETUGAS], A.JABATAN + '<div>'+ STUFF(dbo.GROUP_ROLE(A.USER_ID),1,1,'') + '</div>' AS JABATAN, dbo.GROUP_BIDANG(A.USER_ID) AS [PELAPORAN],  A.EMAIL FROM T_USER A LEFT JOIN M_BBPOM B ON A.BBPOM_ID = B.BBPOM_ID WHERE A.BBPOM_ID='" . $this->newsession->userdata('SESS_BBPOM_ID') . "' AND $status";
    $this->newtable->columns(array("A.USER_ID", "A.NAMA_USER", "A.JABATAN + '<div>'+ STUFF(dbo.GROUP_ROLE(A.USER_ID),1,1,'') + '</div>'", "A.EMAIL"));
    $this->newtable->width(array('NIP' => 100, 'NAMA PETUGAS' => 250, 'JABATAN' => 300, 'PELAPORAN' => 200, 'EMAIL' => 200));
   } else if (array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('10', $this->newsession->userdata('SESS_KODE_ROLE'))) {
    $query = "SELECT A.USER_ID AS NIP, A.NAMA_USER +'<div>'+  B.NAMA_BBPOM + '</div>' AS [NAMA PETUGAS], A.JABATAN + '<div>' + STUFF(dbo.GROUP_ROLE(A.USER_ID),1,1,'') + '</div>' AS JABATAN, dbo.GROUP_BIDANG(A.USER_ID) AS [PELAPORAN], A.EMAIL FROM T_USER A LEFT JOIN M_BBPOM B ON A.BBPOM_ID = B.BBPOM_ID WHERE $status";
    $this->newtable->columns(array("A.USER_ID", "A.NAMA_USER +'<div>'+  B.NAMA_BBPOM + '</div>'", "A.JABATAN + '<div>'+ STUFF(dbo.GROUP_ROLE(A.USER_ID),1,1,'') + '</div>'", "A.EMAIL"));
    $this->newtable->width(array('NIP' => 100, 'NAMA PETUGAS' => 250, 'JABATAN' => 300, 'PELAPORAN' => 200, 'EMAIL' => 200));
   }
   $this->newtable->hiddens(array(''));
   $this->newtable->action(site_url() . "/home/petugas/list/$id");
   $this->newtable->detail(site_url() . "/load/master/set_detil/petugas");
   $this->newtable->cidb($this->db);
   $this->newtable->ciuri($this->uri->segment_array());
   $this->newtable->orderby(2);
   $this->newtable->sortby("ASC");
   $this->newtable->keys(array('NIP'));
   $this->newtable->search(array(array('', '')));
   $this->newtable->show_search(FALSE);
   $this->newtable->menu($proses);
   $tabel = $this->newtable->generate($query);
   $arrdata = array('table' => $tabel,
       'idjudul' => 'judulpetugas',
       'search' => TRUE,
       'frmsearch' => $sipt->main->_fpetugas(site_url() . '/home/cari/petugas/' . $id, $cari, $subcari),
       'caption_header' => 'Data Master Petugas SIPT',
       'batal' => '',
       'cancel' => '');
   return $arrdata;
  } else {
   $this->fungsi->redirectMessage('Maaf, halaman yang anda tuju tidak ditemukan.', '/home');
  }
 }

 function get_admin_balai($id) {
  if (array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('10', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('9', $this->newsession->userdata('SESS_KODE_ROLE'))) {
   $sipt = & get_instance();
   $sipt->load->model("main", "main", true);
   if (array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE'))) {
    $bbpom = $sipt->main->combobox("SELECT BBPOM_ID, REPLACE(REPLACE(NAMA_BBPOM,'BALAI BESAR POM DI ', ''),'BALAI POM DI ','') AS NAMA_BBPOM FROM M_BBPOM ORDER BY BBPOM_ID ASC", "BBPOM_ID", "NAMA_BBPOM", TRUE);
    $role = $sipt->main->combobox("SELECT KODE, URAIAN FROM M_TABEL WHERE JENIS='ROLE' AND KODE NOT IN ('1') ORDER BY URAIAN ASC", "KODE", "URAIAN");
    $jenis = $sipt->main->combobox("SELECT KODE, URAIAN FROM M_TABEL WHERE JENIS='JENIS_PELAPORAN' AND KODE NOT IN ('00','04','10')", "KODE", "URAIAN");
    $klasifikasi = $sipt->main->combobox("SELECT DISTINCT(KK_ID) AS KK_ID, NAMA_KK FROM M_KLASIFIKASI_KATEGORI WHERE JENIS_SARANA_ID <> ''", "KK_ID", "NAMA_KK");
    $klasifikasi2 = $sipt->main->combobox("SELECT DISTINCT(KK_ID) AS KK_ID, NAMA_KK FROM M_KLASIFIKASI_KATEGORI WHERE JENIS_SARANA_ID <> '' AND LEN(KK_ID) = 3 AND KK_ID IN (001,007,010,011,012,013)", "KK_ID", "NAMA_KK");
    $bidang = $sipt->main->combobox("SELECT JENIS_SARANA_ID, NAMA_JENIS_SARANA FROM M_JENIS_SARANA WHERE JENIS_SARANA_ID LIKE 'B%'", "JENIS_SARANA_ID", "NAMA_JENIS_SARANA");
   } else if (array_key_exists('10', $this->newsession->userdata('SESS_KODE_ROLE'))) {
    $bbpom = $sipt->main->combobox("SELECT BBPOM_ID, REPLACE(REPLACE(NAMA_BBPOM,'BALAI BESAR POM DI ', ''),'BALAI POM DI ','') AS NAMA_BBPOM FROM M_BBPOM ORDER BY BBPOM_ID ASC", "BBPOM_ID", "NAMA_BBPOM", TRUE);
    $jenis = $sipt->main->combobox("SELECT KODE, URAIAN FROM M_TABEL WHERE JENIS='JENIS_PELAPORAN' AND KODE NOT IN ('00','04','10')", "KODE", "URAIAN");
    $kk_id = "'" . join("','", $this->config->item('jenis_sarana')) . "'";
    $klasifikasi = $sipt->main->combobox("SELECT KK_ID, NAMA_KK FROM M_KLASIFIKASI_KATEGORI WHERE LEN(KK_ID)=3 AND KK_ID IN (" . $kk_id . ")", "KK_ID", "NAMA_KK");
    $klasifikasi2 = $sipt->main->combobox("SELECT DISTINCT(KK_ID) AS KK_ID, NAMA_KK FROM M_KLASIFIKASI_KATEGORI WHERE JENIS_SARANA_ID <> '' AND LEN(KK_ID) = 3 AND KK_ID IN (001,007,010,011,012,013)", "KK_ID", "NAMA_KK");
    $bidang = $sipt->main->combobox("SELECT JENIS_SARANA_ID, NAMA_JENIS_SARANA FROM M_JENIS_SARANA WHERE JENIS_SARANA_ID LIKE 'B%'", "JENIS_SARANA_ID", "NAMA_JENIS_SARANA");
   } else if (array_key_exists('9', $this->newsession->userdata('SESS_KODE_ROLE'))) {
    $bbpom = $sipt->main->combobox("SELECT BBPOM_ID, REPLACE(REPLACE(NAMA_BBPOM,'BALAI BESAR POM DI ', ''),'BALAI POM DI ','') AS NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID = '" . $this->newsession->userdata('SESS_BBPOM_ID') . "'", "BBPOM_ID", "NAMA_BBPOM");
    if (in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) {
     $role = $sipt->main->combobox("SELECT KODE, URAIAN FROM M_TABEL WHERE JENIS='ROLE' AND KODE NOT IN ('1','5','9','10') ORDER BY URAIAN ASC", "KODE", "URAIAN");
    } else {
     if ($this->newsession->userdata('SESS_BBPOM_ID') == "99") #PPOMN
      $role = $sipt->main->combobox("SELECT KODE, URAIAN FROM M_TABEL WHERE JENIS='ROLE' AND KODE NOT IN ('1','5','9','10') ORDER BY URAIAN ASC", "KODE", "URAIAN");
     else
      $role = $sipt->main->combobox("SELECT KODE, URAIAN FROM M_TABEL WHERE JENIS='ROLE' AND KODE NOT IN ('1','6','9','10','11') ORDER BY URAIAN ASC", "KODE", "URAIAN");
    }
    $kk_id = "'" . join("','", $this->newsession->userdata('SESS_SARANA')) . "'";
    $klasifikasi = $sipt->main->combobox("SELECT KK_ID, NAMA_KK FROM M_KLASIFIKASI_KATEGORI WHERE LEN(KK_ID)=3 AND JENIS_SARANA_ID IN (" . $kk_id . ")", "KK_ID", "NAMA_KK");
    $klasifikasi2 = $sipt->main->combobox("SELECT DISTINCT(KK_ID) AS KK_ID, NAMA_KK FROM M_KLASIFIKASI_KATEGORI WHERE JENIS_SARANA_ID <> '' AND LEN(KK_ID) = 3 AND KK_ID IN (001,007,010,011,012,013)", "KK_ID", "NAMA_KK");
    if ($this->newsession->userdata('SESS_BBPOM_ID') == "99") { #PPOMN
     $jenis = $sipt->main->combobox("SELECT KODE, URAIAN FROM M_TABEL WHERE JENIS='JENIS_PELAPORAN' AND KODE IN ('02')", "KODE", "URAIAN");
     $bidang = $sipt->main->combobox("SELECT JENIS_SARANA_ID, NAMA_JENIS_SARANA FROM M_JENIS_SARANA WHERE JENIS_SARANA_ID LIKE 'B%' AND LEN(JENIS_SARANA_ID) = 3", "JENIS_SARANA_ID", "NAMA_JENIS_SARANA");
    } else {
     $jenis = $sipt->main->combobox("SELECT KODE, URAIAN FROM M_TABEL WHERE JENIS='JENIS_PELAPORAN' AND KODE NOT IN ('00','04','10')", "KODE", "URAIAN");
     $bidang = $sipt->main->combobox("SELECT JENIS_SARANA_ID, NAMA_JENIS_SARANA FROM M_JENIS_SARANA WHERE JENIS_SARANA_ID LIKE 'B%' AND LEN(JENIS_SARANA_ID) = 2", "JENIS_SARANA_ID", "NAMA_JENIS_SARANA");
    }
   }
   if ($id == "") {
    $arrdata = array('sess' => '',
        'header' => 'Tambah Petugas Baru',
        'act' => site_url() . '/post/master/save/petugas/simpan',
        'batal' => site_url() . '/home/petugas/list/aktif',
        'id' => '',
        'sel_klasifikasi' => '',
        'save' => 'Simpan',
        'cancel' => 'Batal');
   } else {
    $query = "SELECT A.USER_ID, A.NAMA_USER, A.JABATAN, A.EMAIL, A.BBPOM_ID, B.ROLE, B.JENIS_PELAPORAN, B.KK_ID, B.SARANA_MEDIA_ID, LEFT(B.SARANA_MEDIA_ID,2) AS BID, LEFT(B.SARANA_MEDIA_ID,3) AS BIDPPOMN  FROM T_USER A LEFT JOIN T_USER_ROLE B ON A.USER_ID = B.USER_ID WHERE A.USER_ID = '$id'";
    $data = $sipt->main->get_result($query);
    $sel_klasifikasi = array();
    $sel_role = array();
    $sel_jenis = array();
    $sel_bidang = array();
    if ($data) {
     foreach ($query->result_array() as $row) {
      if (!array_key_exists($row['KK_ID'], $sel_klasifikasi))
       $sel_klasifikasi[$row['KK_ID']] = $row['KK_ID'];
      if (!array_key_exists($row['JENIS_PELAPORAN'], $sel_jenis))
       $sel_jenis[$row['JENIS_PELAPORAN']] = $row['JENIS_PELAPORAN'];
      if (!array_key_exists($row['ROLE'], $sel_role))
       $sel_role[$row['ROLE']] = $row['ROLE'];

      $arrdata = array('sess' => $row,
          'header' => 'Edit Petugas',
          'act' => site_url() . '/post/master/save/petugas/update',
          'batal' => site_url() . '/home/petugas/list/aktif',
          'id' => $row['USER_ID'],
          'sel_klasifikasi' => $sel_klasifikasi,
          'sel_role' => $sel_role,
          'save' => 'Update',
          'cancel' => 'Kembali');
      if ($row['BBPOM_ID'] == "99") {
       $jenis = $sipt->main->combobox("SELECT KODE, URAIAN FROM M_TABEL WHERE JENIS='JENIS_PELAPORAN' AND KODE IN ('02')", "KODE", "URAIAN");
       $bidang = $sipt->main->combobox("SELECT JENIS_SARANA_ID, NAMA_JENIS_SARANA FROM M_JENIS_SARANA WHERE JENIS_SARANA_ID LIKE 'B%' AND LEN(JENIS_SARANA_ID) = 3", "JENIS_SARANA_ID", "NAMA_JENIS_SARANA");
       if (!array_key_exists($row['BIDPPOMN'], $sel_bidang))
        $sel_bidang[$row['BIDPPOMN']] = $row['BIDPPOMN'];
      }else {
       $jenis = $sipt->main->combobox("SELECT KODE, URAIAN FROM M_TABEL WHERE JENIS='JENIS_PELAPORAN' AND KODE NOT IN ('00','04','10')", "KODE", "URAIAN");
       $bidang = $sipt->main->combobox("SELECT JENIS_SARANA_ID, NAMA_JENIS_SARANA FROM M_JENIS_SARANA WHERE JENIS_SARANA_ID LIKE 'B%' AND LEN(JENIS_SARANA_ID) = 2", "JENIS_SARANA_ID", "NAMA_JENIS_SARANA");
       if (!array_key_exists($row['BID'], $sel_bidang)) {
        $pengujian = strpos($row['BID'], 'B');
        if ($pengujian !== false) {
         $sel_bidang[$row['BID']] = $row['BID'];
         //if(!array_key_exists($row['BID'], $sel_bidang)) $sel_bidang[$row['BID']] = $row['BID'];
        }
       }
      }
      $arrdata['sel_jenis'] = $sel_jenis;
      $arrdata['sel_bidang'] = $sel_bidang;
     }
    }
   }
   $arrdata['bbpom'] = $bbpom;
   $arrdata['role'] = $role;
   $arrdata['jenis'] = $jenis;
   $arrdata['klasifikasi'] = $klasifikasi;
   $arrdata['klasifikasi2'] = $klasifikasi2;
   $arrdata['bidang'] = $bidang;
   return $arrdata;
  } else {
   $this->fungsi->redirectMessage('Maaf, halaman yang anda tuju tidak ditemukan.', '/home');
  }
 }

 function set_detil($id) {
  if ($this->newsession->userdata('LOGGED_IN') == TRUE) {
   $sipt = & get_instance();
   $sipt->load->model("main", "main", true);
   $query = "SELECT CAST(SUBSTRING(A.USER_ID, 0, 9)+ ' ' +SUBSTRING(A.USER_ID, 9, 6)+' '+SUBSTRING(A.USER_ID, 15, 1)+' '+SUBSTRING(A.USER_ID, 16, 3) AS VARCHAR) AS NIP, A.NAMA_USER, A.JABATAN, B.NAMA_BBPOM, A.EMAIL, A.STATUS, STUFF(dbo.GROUP_ROLE(A.USER_ID),1,1,'') AS ROLE FROM T_USER A LEFT JOIN M_BBPOM B ON A.BBPOM_ID = B.BBPOM_ID WHERE A.USER_ID = '$id'";
   $data = $sipt->main->get_result($query);
   $jml_entry = $sipt->main->get_uraian("SELECT COUNT(CREATE_BY) AS JML_ENTRY FROM T_PEMERIKSAAN WHERE CREATE_BY = '$id'", "JML_ENTRY");
   $jml_inspeksi = $sipt->main->get_uraian("SELECT COUNT(USER_ID) AS JML_INSPEKSI FROM T_SURAT_TUGAS_PETUGAS WHERE USER_ID = '$id'", "JML_INSPEKSI");
   $jml_verify = $sipt->main->get_uraian("SELECT COUNT(CREATE_BY) AS JML_VERIFY FROM T_PEMERIKSAAN_PROSES WHERE CREATE_BY = '$id'", "JML_VERIFY");
   if ($data) {
    foreach ($query->result_array() as $row) {
     $arrdata = array('sess' => $row,
         'jml_entry' => $jml_entry,
         'jml_inspeksi' => $jml_inspeksi,
         'jml_verify' => $jml_verify);
    }
   }
   return $arrdata;
  } else {
   $this->fungsi->redirectMessage('Maaf, halaman yang anda tuju tidak ditemukan.', '/home');
  }
 }

 function SavePetugas($setaction, $isajax) {
  if ($this->newsession->userdata('LOGGED_IN') == TRUE) {
   $sipt = & get_instance();
   $sipt->load->model("main", "main", true);
   if ($setaction == "simpan") {#Insert Petugas Baru
    $ret = "MSG#NO#Data gagal disimpan";
    $arr_user = array('LOGIN' => 'GETDATE()',
        'LOGOUT' => 'GETDATE()',
        'STATUS' => 'Aktif');
    foreach ($this->input->post('PETUGAS') as $a => $z) {
     $arr_user[$a] = $z;
    }
    $inv_user = (int) $sipt->main->get_uraian("SELECT COUNT(*) AS INVALID FROM T_USER WHERE USER_ID = '" . $this->input->post('USER_ID') . "'", "INVALID");
    if ($inv_user > 0)
     return "MSG#NO#User ID Tersebut telah digunakan#";
    $pwd = str_shuffle("0123456789");
    $pwd = substr($pwd, 3, 6);
    $arr_user['USER_ID'] = str_replace(' ', '', $this->input->post('USER_ID'));
    $arr_user['PASSWORD'] = md5($pwd);
    $email = $arr_user['EMAIL'];
    $nama = $arr_user['NAMA_USER'];
    $unit_kerja = $sipt->main->get_uraian("SELECT NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID = '" . $arr_user['BBPOM_ID'] . "'", "NAMA_BBPOM");
    if ($this->db->insert('T_USER', $arr_user)) {
     foreach ($this->input->post('ROLE') as $x => $y) {
      $arr_role[$x] = $y;
     }

     if (in_array('01', $arr_role['JENIS_PELAPORAN'])) {
      $kk_id = "'" . join("','", $arr_role['KK_ID']) . "'";
      $query = "SELECT KK_ID, JENIS_SARANA_ID FROM M_KLASIFIKASI_KATEGORI WHERE KK_ID IN (" . $kk_id . ") AND JENIS_SARANA_ID NOT LIKE '%B___'";
      $data = $sipt->main->get_result($query);
      $hasil_kk = array();
      if ($data) {
       foreach ($query->result_array() as $row) {
        $hasil_kk[] = $row;
       }
       $jml_kk = count($hasil_kk);
       for ($a = 0; $a < $jml_kk; $a++) {
        foreach ($arr_role['ROLE'] as $xyz) {
         $arr_roles['USER_ID'] = $arr_user['USER_ID'];
         $arr_roles['ROLE'] = $xyz;
         $arr_roles['JENIS_PELAPORAN'] = '01';
         $arr_roles['KK_ID'] = $hasil_kk[$a]['KK_ID'];
         $arr_roles['SARANA_MEDIA_ID'] = $hasil_kk[$a]['JENIS_SARANA_ID'];
         $this->db->insert('T_USER_ROLE', $arr_roles);
        }
       }
      }
     }


     if (in_array('02', $arr_role['JENIS_PELAPORAN'])) {
      $rolebid = "'" . join("%','", $_POST['BIDANG']) . "%'";
      $arrrolebid = explode(",", $rolebid);
      $jmlarrolebid = count($arrrolebid);
      if ($jmlarrolebid == 1) {
       $query = "SELECT KK_ID, JENIS_SARANA_ID FROM M_KLASIFIKASI_KATEGORI WHERE JENIS_SARANA_ID LIKE " . $arrrolebid[0] . "";
      } else if ($jmlarrolebid == 2) {
       $query = "SELECT KK_ID, JENIS_SARANA_ID FROM M_KLASIFIKASI_KATEGORI WHERE JENIS_SARANA_ID LIKE " . $arrrolebid[0] . " OR JENIS_SARANA_ID LIKE " . $arrrolebid[1] . "";
      } else if ($jmlarrolebid == 3) {
       $query = "SELECT KK_ID, JENIS_SARANA_ID FROM M_KLASIFIKASI_KATEGORI WHERE JENIS_SARANA_ID LIKE " . $arrrolebid[0] . " OR JENIS_SARANA_ID LIKE " . $arrrolebid[1] . " OR JENIS_SARANA_ID LIKE " . $arrrolebid[2] . "";
      } else {
       $rolebid = "'" . join("','", $_POST['BIDANG']) . "'";
       $query = "SELECT KK_ID, SUB_BIDANG_ID AS JENIS_SARANA_ID FROM M_BIDANG WHERE BIDANG_ID IN ($rolebid)";
      }
      $data = $sipt->main->get_result($query);
      $hasil_kk = array();
      if ($data) {
       foreach ($query->result_array() as $row) {
        $hasil_kk[] = $row;
       }
       $jml_kk = count($hasil_kk);
       for ($a = 0; $a < $jml_kk; $a++) {
        foreach ($arr_role['ROLE'] as $xyz) {
         $arr_roles['USER_ID'] = $arr_user['USER_ID'];
         $arr_roles['ROLE'] = $xyz;
         $arr_roles['JENIS_PELAPORAN'] = '02';
         $arr_roles['KK_ID'] = $hasil_kk[$a]['KK_ID'];
         $arr_roles['SARANA_MEDIA_ID'] = $hasil_kk[$a]['JENIS_SARANA_ID'];
         $this->db->insert('T_USER_ROLE', $arr_roles);
        }
       }
      }
     }

     //Pengawasan Iklan dan Penandaan
     if (in_array('03', $arr_role['JENIS_PELAPORAN'])) {
      $kk_id = "'" . join("','", $arr_role['KK_ID']) . "'";
      $query = "SELECT KK_ID, JENIS_SARANA_ID FROM M_KLASIFIKASI_KATEGORI WHERE KK_ID IN (" . $kk_id . ") AND JENIS_SARANA_ID NOT LIKE '%B___'";
      $data = $sipt->main->get_result($query);
      $hasil_kk = array();
      if ($data) {
       foreach ($query->result_array() as $row) {
        $hasil_kk[] = $row;
       }
       $jml_kk = count($hasil_kk);
       for ($a = 0; $a < $jml_kk; $a++) {
        foreach ($arr_role['ROLE'] as $xyz) {
         $arr_roles['USER_ID'] = $arr_user['USER_ID'];
         $arr_roles['ROLE'] = $xyz;
         $arr_roles['JENIS_PELAPORAN'] = '03';
         $arr_roles['KK_ID'] = $hasil_kk[$a]['KK_ID'];
         $arr_roles['SARANA_MEDIA_ID'] = $hasil_kk[$a]['JENIS_SARANA_ID'];
         $this->db->insert('T_USER_ROLE', $arr_roles);
        }
       }
      }
     }

     if (in_array('05', $arr_role['JENIS_PELAPORAN'])) {
      $kk_id = "'" . join("','", $arr_role['KK_ID']) . "'";
      $query = "SELECT KK_ID, JENIS_SARANA_ID FROM M_KLASIFIKASI_KATEGORI WHERE KK_ID IN (" . $kk_id . ") AND JENIS_SARANA_ID NOT LIKE '%B___'";
      $data = $sipt->main->get_result($query);
      $hasil_kk = array();
      if ($data) {
       foreach ($query->result_array() as $row) {
        $hasil_kk[] = $row;
       }
       $jml_kk = count($hasil_kk);
       for ($a = 0; $a < $jml_kk; $a++) {
        foreach ($arr_role['ROLE'] as $xyz) {
         $arr_roles['USER_ID'] = $arr_user['USER_ID'];
         $arr_roles['ROLE'] = $xyz;
         $arr_roles['JENIS_PELAPORAN'] = '05';
         $arr_roles['KK_ID'] = $hasil_kk[$a]['KK_ID'];
         $arr_roles['SARANA_MEDIA_ID'] = $hasil_kk[$a]['JENIS_SARANA_ID'];
         $this->db->insert('T_USER_ROLE', $arr_roles);
        }
       }
      }
     }
//--------------------------------------

     $subject = "Konfirmasi Pendaftaran Petugas SIPT Badan POM RI";
     $isi = 'Selamat, Nama anda telah diverifikasi dan diterima oleh Administrator Sistem Informasi Pelaporan Terpadu (SIPT) Badan Pengawas Obat dan Makanan Republik Indonesia. Untuk login ke Sistem Informasi Pelaporan Terpadu (SIPT) Badan Pengawas Obat dan Makanan Republik Indonesia silahkan login dengan: <table style="margin: 4px 4px 4px 10px; font-family: arial; font-size:12px; font-weight: 700; width:580px;"><tr><td width="65">NIP</td><td>: <b>' . $arr_user['USER_ID'] . '</b></td></tr><tr><td>Password</td><td>: <b>' . $pwd . '</b></td></tr><tr><td>Unit Kerja</td><td>: <b>' . $unit_kerja . '</b></td></tr></table>Terima kasih.';
     if ($sipt->main->send_mail($email, $nama, $subject, $isi)) {
      $ret = "MSG#YES#Data berhasil disimpan dan konfirmasi telah dikirim ke E-mail#" . site_url() . '/home/petugas/list/aktif';
     } else {
      $ret = "MSG#YES#Data berhasil disimpan. Konfirmasi Email gagal Terkirim#" . site_url() . '/home/petugas/list/aktif';
     }
     $sipt->main->get_kegiatan("Menambahkan Petugas : " . $arr_user['NAMA_USER']);
    }
    if ($isajax != "ajax") {
     redirect(site_url() . '/home');
     exit();
    }
    return $ret;
   } else if ($setaction == "update") {#Update Petugas
    $ret = "MSG#NO#Data gagal disimpan";
    foreach ($this->input->post('PETUGAS') as $a => $z) {
     $arr_user[$a] = $z;
    }
	
	
     foreach ($this->input->post('ROLE') as $x => $y) {
      $arr_role[$x] = $y;
     }
	
    $this->db->where(array("USER_ID" => $this->input->post('USER_ID')));
    if ($this->db->update('T_USER', $arr_user)) {
     $this->db->where('USER_ID', $this->input->post('USER_ID'));
     $this->db->delete('T_USER_ROLE');
     foreach ($this->input->post('ROLE') as $x => $y) {
      $arr_role[$x] = $y;
     }
     if (in_array('01', $arr_role['JENIS_PELAPORAN'])) {
      $kk_id = "'" . join("','", $arr_role['KK_ID']) . "'";
      $query = "SELECT KK_ID, JENIS_SARANA_ID FROM M_KLASIFIKASI_KATEGORI WHERE KK_ID IN (" . $kk_id . ") AND JENIS_SARANA_ID NOT LIKE '%B___'";
      $data = $sipt->main->get_result($query);
      $hasil_kk = array();
      if ($data) {
       foreach ($query->result_array() as $row) {
        $hasil_kk[] = $row;
       }
       $jml_kk = count($hasil_kk);
       for ($a = 0; $a < $jml_kk; $a++) {
        foreach ($arr_role['ROLE'] as $xyz) {
         $arrjenis['USER_ID'] = $this->input->post('USER_ID');
         $arrjenis['ROLE'] = $xyz;
         $arrjenis['JENIS_PELAPORAN'] = '01';
         $arrjenis['KK_ID'] = $hasil_kk[$a]['KK_ID'];
         $arrjenis['SARANA_MEDIA_ID'] = $hasil_kk[$a]['JENIS_SARANA_ID'];
         $this->db->insert('T_USER_ROLE', $arrjenis);
        }
       }
      }
     }

     if (in_array('02', $arr_role['JENIS_PELAPORAN'])) {
      $rolebid = "'" . join("%','", $_POST['BIDANG']) . "%'";
      $arrrolebid = explode(",", $rolebid);
      $jmlarrolebid = count($arrrolebid);
      if ($jmlarrolebid == 1) {
       $query = "SELECT KK_ID, JENIS_SARANA_ID FROM M_KLASIFIKASI_KATEGORI WHERE JENIS_SARANA_ID LIKE " . $arrrolebid[0] . "";
      } else if ($jmlarrolebid == 2) {
       $query = "SELECT KK_ID, JENIS_SARANA_ID FROM M_KLASIFIKASI_KATEGORI WHERE JENIS_SARANA_ID LIKE " . $arrrolebid[0] . " OR JENIS_SARANA_ID LIKE " . $arrrolebid[1] . "";
      } else if ($jmlarrolebid == 3) {
       $query = "SELECT KK_ID, JENIS_SARANA_ID FROM M_KLASIFIKASI_KATEGORI WHERE JENIS_SARANA_ID LIKE " . $arrrolebid[0] . " OR JENIS_SARANA_ID LIKE " . $arrrolebid[1] . " OR JENIS_SARANA_ID LIKE " . $arrrolebid[2] . "";
      } else {
       $rolebid = "'" . join("','", $_POST['BIDANG']) . "'";
       $query = "SELECT KK_ID, SUB_BIDANG_ID AS JENIS_SARANA_ID FROM M_BIDANG WHERE BIDANG_ID IN ($rolebid)";
      }
      $data = $sipt->main->get_result($query);
      $kk = array();
      if ($data) {
       foreach ($query->result_array() as $row) {
        $kk[] = $row;
       }
       $jkk = count($kk);
       for ($a = 0; $a < $jkk; $a++) {
        foreach ($arr_role['ROLE'] as $abc) {
         $arr_roles['USER_ID'] = $this->input->post('USER_ID');
         $arr_roles['ROLE'] = $abc;
         $arr_roles['JENIS_PELAPORAN'] = '02';
         $arr_roles['KK_ID'] = $kk[$a]['KK_ID'];
         $arr_roles['SARANA_MEDIA_ID'] = $kk[$a]['JENIS_SARANA_ID'];
         $this->db->insert('T_USER_ROLE', $arr_roles);
        }
       }
      }
     }

     //Pengawasan Penandaan dan Iklan
     if (in_array('03', $arr_role['JENIS_PELAPORAN'])) {
      $kk_id = "'" . join("','", $arr_role['KK_ID']) . "'";
      $query = "SELECT KK_ID, JENIS_SARANA_ID FROM M_KLASIFIKASI_KATEGORI WHERE KK_ID IN (" . $kk_id . ") AND JENIS_SARANA_ID NOT LIKE '%B___'";
      $data = $sipt->main->get_result($query);
      $hasil_kk = array();
      if ($data) {
       foreach ($query->result_array() as $row) {
        $hasil_kk[] = $row;
       }
       $jml_kk = count($hasil_kk);
       for ($a = 0; $a < $jml_kk; $a++) {
        foreach ($arr_role['ROLE'] as $xyz) {
         $arrjenis['USER_ID'] = $this->input->post('USER_ID');
         $arrjenis['ROLE'] = $xyz;
         $arrjenis['JENIS_PELAPORAN'] = '03';
         $arrjenis['KK_ID'] = $hasil_kk[$a]['KK_ID'];
         $arrjenis['SARANA_MEDIA_ID'] = $hasil_kk[$a]['JENIS_SARANA_ID'];
         $this->db->insert('T_USER_ROLE', $arrjenis);
        }
       }
      }
     }

     if (in_array('05', $arr_role['JENIS_PELAPORAN'])) {
      $kk_id = "'" . join("','", $arr_role['KK_ID']) . "'";
      $query = "SELECT KK_ID, JENIS_SARANA_ID FROM M_KLASIFIKASI_KATEGORI WHERE KK_ID IN (" . $kk_id . ") AND JENIS_SARANA_ID NOT LIKE '%B___'";
      $data = $sipt->main->get_result($query);
      $hasil_kk = array();
      if ($data) {
       foreach ($query->result_array() as $row) {
        $hasil_kk[] = $row;
       }
       $jml_kk = count($hasil_kk);
       for ($a = 0; $a < $jml_kk; $a++) {
        foreach ($arr_role['ROLE'] as $xyz) {
         $arrjenis['USER_ID'] = $this->input->post('USER_ID');
         $arrjenis['ROLE'] = $xyz;
         $arrjenis['JENIS_PELAPORAN'] = '05';
         $arrjenis['KK_ID'] = $hasil_kk[$a]['KK_ID'];
         $arrjenis['SARANA_MEDIA_ID'] = $hasil_kk[$a]['JENIS_SARANA_ID'];
         $this->db->insert('T_USER_ROLE', $arrjenis);
        }
       }
      }
     }
//----------------------------

     $sipt->main->get_kegiatan("Melakukan Update Data Petugas : " . $arr_user['NAMA_USER']);
     if ($isajax != "ajax") {
      redirect(base_url());
      exit();
     }
     #$ret = "MSG#YES#Data berhasil disimpan#".site_url().'/home/petugas/list/aktif';
     $ret = "MSG#YES#Data berhasil disimpan#";
    }
    if ($isajax != "ajax") {
     redirect(site_url() . '/home');
     exit();
    }
    return $ret;
   }
  } else {
   $this->fungsi->redirectMessage('Maaf, halaman yang anda tuju tidak ditemukan.', '/home');
  }
 }

 function set_petugas($action, $isajax) {
  if ($this->newsession->userdata('LOGGED_IN') || array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('9', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('10', $this->newsession->userdata('SESS_KODE_ROLE'))) {
   $sipt = & get_instance();
   $sipt->load->model("main", "main", true);
   if ($action == "aktif") {#Aktifkan Petugas
    $ret = "MSG#Petugas Gagal di Aktifkan.";
    foreach ($this->input->post('tb_chk') as $a) {
     $arr_aktif = array("STATUS" => "Aktif");
     $this->db->where('USER_ID', $a);
     if ($this->db->update('T_USER', $arr_aktif))
      $ret = "MSG#Petugas berhasil diaktifkan#" . site_url() . "/home/petugas/list/aktif";
     $sipt->main->get_kegiatan("Mengaktifkan Petugas : " . $a);
    }

    if ($isajax != "ajax") {
     redirect(base_url());
     exit();
    }
    return $ret;
   } else if ($action == "non-aktif") {#Non Aktifkan Petugas
    $ret = "MSG#Petugas Gagal di Non-aktifkan.";
    foreach ($this->input->post('tb_chk') as $a) {
     $arr_aktif = array("STATUS" => "Non-Aktif");
     $this->db->where('USER_ID', $a);
     if ($this->db->update('T_USER', $arr_aktif))
      $ret = "MSG#Petugas berhasil di non-aktifkan#" . site_url() . "/home/petugas/list/non-aktif";
     $sipt->main->get_kegiatan("Menonaktifkan Petugas : " . $a);
    }
    if ($isajax != "ajax") {
     redirect(base_url());
     exit();
    }
    return $ret;
   } else if ($action == "hapus") {#Hapus Data Petugas
    $ret = "MSG#Petugas Gagal di Hapus.";
    foreach ($this->input->post('tb_chk') as $a) {
     $this->db->where('USER_ID', $a);
     if ($this->db->delete('T_USER'))
      $ret = "MSG#Petugas berhasil di hapus#" . site_url() . "/home/petugas/list/non-aktif";
     $sipt->main->get_kegiatan("Menghapus Data Petugas : " . $a);
    }
    if ($isajax != "ajax") {
     redirect(base_url());
     exit();
    }
    return $ret;
   } else if ($action == "resend") {#Kirim Ulang Password Petugas
    $ret = "MSG#Kirim Ulang Password Petugas Gagal.";
    foreach ($this->input->post('tb_chk') as $chkitem) {
     $id[] = $chkitem;
    }
    $id = "'" . join("','", $id) . "'";
    $query = "SELECT USER_ID, NAMA_USER, EMAIL FROM T_USER WHERE USER_ID IN ($id)";
    $data = $sipt->main->get_result($query);
    if ($data) {
     foreach ($query->result() as $row) {
      $user_id = $row->USER_ID;
      $nama = $row->NAMA_USER;
      $email = $row->EMAIL;
      $pwd = str_shuffle("0123456789");
      $pwd = substr($pwd, 3, 6);
      $subject = "Reset Password";
      $isi = 'Password anda di Sistem Informasi Pelaporan Terpadu (SIPT) Badan Pengawas Obat dan Makanan Republik Indonesia telah di ubah oleh Administrator. Untuk login ke Sistem Informasi Pelaporan Terpadu (SIPT) Badan Pengawas Obat dan Makanan Republik Indonesia silahkan login dengan: <table style="margin: 4px 4px 4px 10px; font-family: arial; font-size:12px; font-weight: 700; width:580px;"><tr><td width="65">NIP</td><td>: <b>' . $user_id . '</b></td></tr><tr><td>Password</td><td>: <b>' . $pwd . '</b></td></tr></table>Terima kasih.';
      if ($sipt->main->send_mail($email, $nama, $subject, $isi)) {
       $this->db->where('USER_ID', $user_id);
       if ($this->db->update('T_USER', array("PASSWORD" => md5($pwd))))
        $ret = "MSG#Kirim Ulang Password Petugas Berhasil. Konfirmasi E-mail berhasil dikirim#";
      }else {
       $this->db->where('USER_ID', $user_id);
       if ($this->db->update('T_USER', array("PASSWORD" => md5($pwd))))
        $ret = "MSG#Kirim Ulang Password Petugas Berhasil. Konfirmasi E-mail gagal dikirim#";
      }
      $sipt->main->get_kegiatan("Mereset kata sandi petugas : " . $nama);
     }
    }
    if ($isajax != "ajax") {
     redirect(base_url());
     exit();
    }
    return $ret;
   } else if ($action == "default") {#Reset Password Default Petugas (NIP)
    $ret = "MSG#Reset Password Default Gagal.";
    foreach ($this->input->post('tb_chk') as $chkitem) {
     $id[] = $chkitem;
    }
    $id = "'" . join("','", $id) . "'";
    $query = "SELECT USER_ID FROM T_USER WHERE USER_ID IN ($id)";
    $data = $sipt->main->get_result($query);
    if ($data) {
     foreach ($query->result() as $row) {
      $user_id = $row->USER_ID;
      $this->db->where('USER_ID', $user_id);
      if ($this->db->update('T_USER', array("PASSWORD" => md5($user_id))))
       $ret = "MSG#Reset Password Default Berhasil#";
     }
    }
    $sipt->main->get_kegiatan("Mereset kata sandi Petugas : " . $user_id);
    if ($isajax != "ajax") {
     redirect(base_url());
     exit();
    }
    return $ret;
   } else if ($action == "login" && (array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')))) { #Login
    $id = $this->input->post('tb_chk');
    $query = "SELECT USER_ID, PASSWORD FROM T_USER WHERE USER_ID = '$id[0]'";
    $res = $sipt->main->get_result($query);
    if ($res) {
     foreach ($query->result_array() as $a) {
      $data = $a;
     }
    }
    $uid = $data['USER_ID'];
    $pass = $data['PASSWORD'];
    $login = & get_instance();
    $login->load->model('User_activity');
    $hasil = $login->User_activity->user_login($uid, $pass, TRUE);
    if ($hasil == "YES")
     return "MSG#Login Berhasil.#" . base_url();
    else
     return "MSG#Login Gagal.";
   }
  }
 }

}

?>