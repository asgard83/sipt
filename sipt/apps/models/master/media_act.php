<?php

if (!defined('BASEPATH'))
  exit('No direct script access allowed');
error_reporting(E_ERROR);

class Media_act extends Model {

  function list_media() {
    if ($this->newsession->userdata('LOGGED_IN') == TRUE) {
      $sipt = & get_instance();
      $sipt->load->model("main", "main", true);
      $this->load->library('newtable');
      $this->newtable->hiddens(array('ID_MEDIA'));
      $this->newtable->action(site_url() . "/home/master/mediaIklan");
      $this->newtable->cidb($this->db);
      $this->newtable->ciuri($this->uri->segment_array());
      $this->newtable->orderby(3);
      $this->newtable->sortby("ASC");
      $this->newtable->keys(array('ID_MEDIA'));
      $this->newtable->search(array(array('', '')));
      $this->newtable->show_search(FALSE);
      $proses['Tambah Media Iklan Baru'] = array('GET', site_url() . "/home/master/mediaIklan/new", '0');
      $this->newtable->menu($proses);
      $query = "SELECT  MM.ID_MEDIA, UPPER(MM.NAMA_MEDIA) AS 'Nama Media', MT.URAIAN AS 'Jenis Media' FROM M_MEDIA MM LEFT JOIN M_TABEL MT ON MT.KODE = MM.KODE_JENIS_IKLAN WHERE MT.JENIS = 'MEDIA_IKLAN'";
      $this->newtable->columns(array("MM.ID_MEDIA", "UPPER(MM.NAMA_MEDIA)", "MT.URAIAN"));
      $this->newtable->width(array('Nama Media' => 500, 'Jenis Media' => 200));
      $tabel = $this->newtable->generate($query);
      $arrdata = array('table' => $tabel, 'idjudul' => '', 'search' => TRUE, 'frmsearch' => $sipt->main->_fmedia(site_url() . '/iklan/iklanController/mediaSrc', $cari), 'caption_header' => 'Master Media Iklan', 'batal' => '', 'cancel' => '');
      return $arrdata;
    } else {
      $this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.', '/home');
    }
  }

  function list_media_act($cari) {
    if ($this->newsession->userdata('LOGGED_IN') == TRUE) {
      $sipt = & get_instance();
      $sipt->load->model("main", "main", true);
      $this->load->library('newtable');
      $uricari = explode("_", $cari);
      $this->newtable->hiddens(array('ID_MEDIA'));
      $this->newtable->action(site_url() . "/home/master/mediaIklan");
      $this->newtable->cidb($this->db);
      $this->newtable->ciuri($this->uri->segment_array());
      $this->newtable->orderby(3);
      $this->newtable->sortby("ASC");
      $this->newtable->keys(array('ID_MEDIA'));
      $this->newtable->search(array(array('', '')));
      $this->newtable->show_search(FALSE);
      $proses['Tambah Media Iklan Baru'] = array('GET', site_url() . "/home/master/mediaIklan/new", '0');
      $this->newtable->menu($proses);
//   $query = "SELECT  MM.ID_MEDIA, UPPER(MM.NAMA_MEDIA) AS 'Nama Media', MT.URAIAN AS 'Jenis Media', MD.NAMA_PROPINSI AS 'Provinsi' FROM M_MEDIA MM LEFT JOIN M_TABEL MT ON MT.KODE = MM.KODE_JENIS_IKLAN LEFT JOIN M_DAERAH MD ON MD.PROPINSI_ID = MM.PROPINSI WHERE MT.JENIS = 'MEDIA_IKLAN'";
//   $this->newtable->columns(array("MM.ID_MEDIA", "UPPER(MM.NAMA_MEDIA)", "MT.URAIAN", "MM.PROPINSI"));
//   $this->newtable->width(array('Nama Media' => 500, 'Jenis Media' => 200, 'Provinsi' => 500));
      $query = "SELECT  MM.ID_MEDIA, UPPER(MM.NAMA_MEDIA) AS 'Nama Media', MT.URAIAN AS 'Jenis Media' FROM M_MEDIA MM LEFT JOIN M_TABEL MT ON MT.KODE = MM.KODE_JENIS_IKLAN WHERE MT.JENIS = 'MEDIA_IKLAN'";
      $this->newtable->columns(array("MM.ID_MEDIA", "UPPER(MM.NAMA_MEDIA)", "MT.URAIAN"));
      $this->newtable->width(array('Nama Media' => 500, 'Jenis Media' => 200));
      if ($uricari[0] != "ALL")
        $query .= " AND MT.URAIAN = '" . $uricari[0] . "'";
      if ($uricari[1] != "ALL")
        $query .= " AND MM.NAMA_MEDIA LIKE '%" . $uricari[1] . "%'";
//   if ($urisubcari[0] != "ALL")
//    $query .= " AND MD.PROPINSI_ID = '" . $urisubcari[0] . "'";
      $tabel = $this->newtable->generate($query);
      $arrdata = array('table' => $tabel, 'search' => TRUE, 'frmsearch' => $sipt->main->_fmedia(site_url() . '/iklan/iklanController/mediaSrc', $cari), 'idjudul' => 'judulpmnikl', 'caption_header' => 'Master Media Iklan', 'batal' => '', 'cancel' => '');
      return $arrdata;
    } else {
      $this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.', '/home');
    }
  }

  function get_media($id) {
    if ($this->newsession->userdata('LOGGED_IN') == TRUE) {
      $sipt = & get_instance();
      $sipt->load->model("main", "main", true);
      $jenisEmpt = array("" => "");
      $jenis = $sipt->main->combobox("SELECT KODE, URAIAN FROM M_TABEL WHERE JENIS='MEDIA_IKLAN' ORDER BY URAIAN ASC", "KODE", "URAIAN");
      $kodeProvinsi = substr($this->newsession->userdata('SESS_PROP_ID'), 0, 2);
//   $detailProvinsiDef = $sipt->main->combobox("SELECT PROPINSI_ID, NAMA_PROPINSI FROM M_PROPINSI WHERE LEFT(PROPINSI_ID, 2) = '" . $kodeProvinsi . "' AND RIGHT(PROPINSI_ID, 2) != '00'", "PROPINSI_ID", "NAMA_PROPINSI", TRUE);
//   $provinsi = $sipt->main->combobox("SELECT PROPINSI_ID, NAMA_PROPINSI FROM M_PROPINSI WHERE LEFT(PROPINSI_ID, 1) <= '9' AND RIGHT(PROPINSI_ID, 2) = '00'", "PROPINSI_ID", "NAMA_PROPINSI", TRUE);
      if ($id == "") {#Insert Mode
//    $arrdata = array('sess' => '', 'act' => site_url() . '/post/master/save/media/simpan', 'batal' => site_url() . '/home/master/media', 'id' => '', 'sel_jenis' => '', 'sel_nama' => '', 'save' => 'Simpan', 'cancel' => 'Batal', 'provinsi' => $provinsi, 'kabupaten' => $detailProvinsiDef);
        $arrdata = array('sess' => '', 'act' => site_url() . '/post/master/save/media/simpan', 'batal' => site_url() . '/home/master/media', 'id' => '', 'sel_jenis' => '', 'sel_nama' => '', 'save' => 'Simpan', 'cancel' => 'Batal');
      } else {#Edit Mode
        $qsarana = "SELECT SARANA_ID, JENIS_SARANA, NAMA_SARANA, NPWP FROM M_SARANA WHERE SARANA_ID='$id'";
        $dt_sarana = $sipt->main->get_result($qsarana);
        if ($dt_sarana) {
          foreach ($qsarana->result_array() as $row) {
            $arrdata = array('sess' => $row, 'act' => site_url() . '/post/master/save/sarana/update', 'batal' => site_url() . '/home/master/sarana', 'id' => $row['SARANA_ID'], 'sel_nama' => explode(",", $row['NAMA_SARANA']), 'sel_jenis' => $row['JENIS_SARANA'], 'save' => 'Update', 'cancel' => 'Kembali');
          }
        }
      }
      $arrdata['jenis'] = array_merge($jenisEmpt, $jenis);
      return $arrdata;
    } else {
      $this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.', '/home');
    }
  }

  function SaveForm($setaction, $isajax) {
    #print_r($_POST); die();
    if ($isajax != "ajax") {
      redirect(site_url() . '/home/master/media');
      exit();
    }
    if ($this->newsession->userdata('LOGGED_IN') == TRUE) {
      $sipt = & get_instance();
      $ret = "MSG#NO#Data gagal disimpan";
      $this->load->model("main", "main", true);
      $form = $this->input->post('MEDIA');
      $klasifikasi = $form['JENIS_MEDIA'];
      if ($setaction == "simpan") {#Insert Mode
        $id = (int) $sipt->main->get_uraian("SELECT MAX(ID_MEDIA) AS MAXID FROM M_MEDIA", "MAXID") + 1;
        if (trim($form['PROPINSI']) != "")
          $media = array('ID_MEDIA' => $id, 'KODE_JENIS_IKLAN' => $klasifikasi, 'NAMA_MEDIA' => $form['NAMA_MEDIA']);
        else
          $media = array('ID_MEDIA' => $id, 'KODE_JENIS_IKLAN' => $klasifikasi, 'NAMA_MEDIA' => $form['NAMA_MEDIA'], 'PROPINSI' => $this->newsession->userdata('SESS_PROP_ID'));
        if ($this->db->insert('M_MEDIA', $media))
          $ret = "MSG#YES#Data berhasil disimpan.#" . site_url() . '/home/master/mediaIklan';
      } else if ($setaction == "update") {#Update Mode
      }
      return $ret;
    } else {
      $this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.', '/home');
    }
  }

  function DeleteSarana($isajax) {
    if ($this->newsession->userdata('LOGGED_IN') == TRUE) {
      $ret = "MSG#Hapus Sarana Gagal.";
      foreach ($this->input->post('tb_chk') as $chkitem) {
        $arrchk = explode(".", $chkitem);
        $this->db->where('SARANA_ID', $arrchk[0]);
        if ($this->db->delete('T_PEMERIKSAAN')) {
          $this->db->where('SARANA_ID', $arrchk[0]);
          $this->db->delete('M_SARANA');
          $ret = "MSG#Data Sarana Berhasil Di Hapus.#";
        }
      }
      if ($isajax != "ajax") {
        redirect(base_url());
        exit();
      }
      return $ret;
    }
    $this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.', '/home');
  }

}

?>