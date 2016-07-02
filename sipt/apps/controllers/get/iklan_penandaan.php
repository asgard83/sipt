<?php

if (!defined('BASEPATH'))
  exit('No direct script access allowed');

class Iklan_penandaan extends Controller {

  function Iklan_penandaan() {
    parent::Controller();
  }

  function index() {
    $this->fungsi->redirectMessage('Maaf anda tidak bisa mengakses halaman ini.', '/home');
  }

  function get_log($periksa_id = "") {#Log Pengguna
    $query = "SELECT A.CREATE_DATE, +'<b>'+ B.NAMA_USER +'</b><div>@<b>'+ D.NAMA_BBPOM + '</b> <br>&raquo; <i>' + (CASE WHEN DATEDIFF(MONTH, A.CREATE_DATE, GETDATE()) = 0 THEN (CASE WHEN DATEDIFF(DAY, A.CREATE_DATE, GETDATE()) > 0 THEN CAST(DATEDIFF(DAY, A.CREATE_DATE, GETDATE()) AS VARCHAR) + ' Hari, ' ELSE '' END) + (CASE WHEN DATEDIFF(HOUR, A.CREATE_DATE, GETDATE()) > 0 THEN CAST(DATEDIFF(HOUR, A.CREATE_DATE, GETDATE())%24 AS VARCHAR) + ' Jam, ' ELSE '' END) + CAST(DATEDIFF(MINUTE, A.CREATE_DATE, GETDATE())%60 AS VARCHAR) + ' Menit Yang Lalu' ELSE 'Lebih Dari 1 Bulan Yang Lalu' END) + '</i></div>' AS DETIL, CAST(A.CATATAN AS VARCHAR(MAX))+ '<div> Status Pemeriksaan : '+ CAST(C.URAIAN AS VARCHAR(50)) + '</div>' AS CATATAN FROM T_PEMERIKSAAN_PROSES A LEFT JOIN T_USER B ON A.CREATE_BY = B.USER_ID LEFT JOIN M_TABEL C ON A.HASIL = C.KODE LEFT JOIN M_BBPOM D ON B.BBPOM_ID = D.BBPOM_ID WHERE A.PERIKSA_ID = '$periksa_id' AND C.JENIS = 'STATUS'";
    $this->load->library('newtable');
    $this->newtable->search(array(array('', '')));
    $this->newtable->hiddens(array('CREATE_DATE'));
    $this->newtable->action(site_url());
    $this->newtable->cidb($this->db);
    $this->newtable->ciuri($this->uri->segment_array());
    $this->newtable->orderby(1);
    $this->newtable->sortby("DESC");
    $this->newtable->keys("CREATE_DATE");
    $this->newtable->rowcount("ALL");
    $this->newtable->columns(array("A.CREATE_DATE", "+'<b>'+ B.NAMA_USER +'</b><div>@<b>'+ D.NAMA_BBPOM + '</b> <br>&raquo; <i>' + (CASE WHEN DATEDIFF(MONTH, A.CREATE_DATE, GETDATE()) = 0 THEN (CASE WHEN DATEDIFF(DAY, A.CREATE_DATE, GETDATE()) > 0 THEN CAST(DATEDIFF(DAY, A.CREATE_DATE, GETDATE()) AS VARCHAR) + ' Hari, ' ELSE '' END) + (CASE WHEN DATEDIFF(HOUR, A.CREATE_DATE, GETDATE()) > 0 THEN CAST(DATEDIFF(HOUR, A.CREATE_DATE, GETDATE())%24 AS VARCHAR) + ' Jam, ' ELSE '' END) + CAST(DATEDIFF(MINUTE, A.CREATE_DATE, GETDATE())%60 AS VARCHAR) + ' Menit Yang Lalu' ELSE 'Lebih Dari 1 Bulan Yang Lalu' END) + '</i></div>'", "CAST(A.CATATAN AS VARCHAR(MAX))+ '<div> Status Pemeriksaan : '+ CAST(C.URAIAN AS VARCHAR(50)) + '</div>'"));
    $this->newtable->width(array('DETIL' => 250));
    $this->newtable->show_chk(FALSE);
    $this->newtable->show_search(FALSE);
    $tabel = $this->newtable->generate($query);
    echo $tabel;
  }

  function get_riwayat($periksa, $tabel) {#Log Pengguna
    if ($tabel == 'T_PENANDAAN_PROSES')
      $field = 'Penandaan';
    if ($tabel == 'T_IKLAN_PROSES')
      $field = 'Iklan';
    $query = "SELECT TU.NAMA_USER AS [NAMA], STUFF(dbo.GROUP_ROLE(TU.USER_ID),1,1,'') AS ROLE,(CASE WHEN DATEDIFF(DAY, A.CREATED, GETDATE()) > 0 THEN CONVERT(VARCHAR(10), A.CREATED, 105)+'<div>'+CONVERT(VARCHAR(10), CREATED, 108)+'</div>' ELSE (CASE WHEN DATEDIFF(HOUR, CREATED, GETDATE()) > 0 THEN CAST(DATEDIFF(HOUR, A.CREATED, GETDATE())%24 AS VARCHAR) + ' Jam, ' ELSE '' END) + CAST(DATEDIFF(MINUTE, A.CREATED, GETDATE())%60 AS VARCHAR) + ' Menit Yang Lalu' END) AS WAKTU,CAST(A.CATATAN AS VARCHAR(MAX))+ '<div> Status Pemeriksaan : '+ CAST(MT.URAIAN AS VARCHAR(50)) + '</div>' AS CATATAN FROM $tabel A LEFT JOIN T_USER TU ON A.CREATEDBY = TU.USER_ID LEFT JOIN M_TABEL MT ON MT.KODE = A.STATUS LEFT JOIN M_BBPOM MB ON MB.BBPOM_ID = TU.BBPOM_ID WHERE A." . $field . "_ID = '$periksa' AND MT.JENIS = 'STATUS'";
    $this->load->library('newtable');
    $this->newtable->search(array(array('', '')));
    $this->newtable->hiddens(array('CREATED'));
    $this->newtable->action(site_url());
    $this->newtable->cidb($this->db);
    $this->newtable->ciuri($this->uri->segment_array());
    $this->newtable->orderby(3);
    $this->newtable->sortby("DESC");
    $this->newtable->keys("CREATED");
    $this->newtable->rowcount("ALL");
    $this->newtable->columns(array("SELECT TU.NAMA_USER, STUFF(dbo.GROUP_ROLE(TU.USER_ID),1,1,''),(CASE WHEN DATEDIFF(DAY, A.CREATED, GETDATE()) > 0 THEN CONVERT(VARCHAR(10), A.CREATED, 105)+'<div>'+CONVERT(VARCHAR(10), CREATED, 108)+'</div>' ELSE (CASE WHEN DATEDIFF(HOUR, CREATED, GETDATE()) > 0 THEN CAST(DATEDIFF(HOUR, A.CREATED, GETDATE())%24 AS VARCHAR) + ' Jam, ' ELSE '' END) + CAST(DATEDIFF(MINUTE, A.CREATED, GETDATE())%60 AS VARCHAR) + ' Menit Yang Lalu' END),CAST(A.CATATAN AS VARCHAR(MAX))+ '<div> Status Pemeriksaan : '+ CAST(MT.URAIAN AS VARCHAR(50)) + '</div>'"));
    $this->newtable->width(array('NAMA' => 150, 'ROLE' => 100, 'WAKTU' => '75'));
    $this->newtable->show_chk(FALSE);
    $this->newtable->show_search(FALSE);
    $tabel = $this->newtable->generate($query);
    echo $tabel;
  }

  function set_prev_surat($sarana = "", $jenis = "", $kk = "", $periksa = "", $sid = "") {
    if ($this->newsession->userdata('LOGGED_IN') == "TRUE") {
      $mdl = "F" . $jenis;
      if ($jenis == "03TR")
        $mdl = "F02TR";
      $this->load->model("pemeriksaan/" . $mdl);
      $ret = $this->$mdl->prev_surat_tl($periksa);
      echo $ret;
    }
  }

  function set_surat_tl($sarana = "", $jenis = "", $periksa = "", $id = "") {
    if ($this->newsession->userdata('LOGGED_IN') == TRUE) {
      $this->load->model('pemeriksaan/TL_act');
      $arrdata = $this->TL_act->get_perbaikan($sarana, $jenis, $periksa, $id);
      $ret = $this->load->view('pemeriksaan/tl/perbaikan', $arrdata, true);
      echo $ret;
    }
  }

  function set_provinsi($id = "") {#Klasifikasi Jenis Sarana
    if ($this->newsession->userdata('LOGGED_IN')) {
      $sipt = & get_instance();
      $sipt->load->model("main", "main", true);
      $kodeProvinsi = substr($id, 0, 2);
      $query = "SELECT PROPINSI_ID, NAMA_PROPINSI FROM M_PROPINSI WHERE LEFT(PROPINSI_ID, 2) = '" . $kodeProvinsi . "' AND RIGHT(PROPINSI_ID, 2) != '00'";
      $res = $sipt->main->get_result($query);
      $hasil = "";
      if ($res) {
        $hasil .= '<option value="">&nbsp;</option>';
        foreach ($query->result_array() as $row) {
          $hasil .= '<option value="' . $row['PROPINSI_ID'] . '">' . $row['NAMA_PROPINSI'] . '</option>';
        }
      }
      echo $hasil;
    } else {
      redirect(base_url());
    }
  }

}

?>