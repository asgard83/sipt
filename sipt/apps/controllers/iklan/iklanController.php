<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class IklanController extends Controller {

    var $content = "";

    function IklanController() {
        parent::Controller();
    }

    function index() {
        $appname = 'Sistem Informasi Pelaporan Terpadu | versi 1.0';
        if ($this->newsession->userdata('LOGGED_IN') == TRUE) {
            if ($this->content == "")
                $this->content = $this->load->view('welcome_message', '', true);
            $data = array('_appname_' => $appname,
                '_name_' => $this->newsession->userdata('SESS_NAMA_USER'),
                '_header_' => $this->load->view('header/home', '', true),
                '_content_' => $this->content);
            $this->parser->parse('home', $data);
        }else {
            $data = array('_appname_' => $appname,
                '_header_' => $this->load->view('header/login', '', true));
            $this->parser->parse('login', $data);
        }
    }

    function cekLogin() {
//        if ($this->newsession->userdata('LOGGED_IN') || in_array('03', $this->newsession->userdata('SESS_JENIS_PELAPORAN') || in_array('1', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('9', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('10', $this->newsession->userdata('SESS_KODE_ROLE'))))
//            return;
//        else
//            $this->fungsi->redirectMessage('Maaf anda tidak bisa mengakses halaman ini.', '/home');
//        $this->index();
//        return;
    }

    function getFormIklanLanjutan($klasifikasi = "", $jenis = "") {
        $this->cekLogin();
        $this->load->model("iklan/M" . $klasifikasi . "/_" . $klasifikasi . "m");
        $model = '_' . $klasifikasi . 'm';
        $arrdata = $this->$model->getFormIklan($klasifikasi);
        if ($klasifikasi == '001') {
            if (in_array("001", $this->newsession->userdata('SESS_KLASIFIKASI_ID')))
                $this->content = $this->load->view('iklan/pengawasanIklanObatDetail', $arrdata, true);
            else
                $this->fungsi->redirectMessage('Maaf anda tidak bisa mengakses halaman ini.', '/home');
        } else if ($klasifikasi == '012') {
            if (in_array("012", $this->newsession->userdata('SESS_KLASIFIKASI_ID')))
                $this->content = $this->load->view('iklan/pengawasanIklanKosmetikDetail', $arrdata, true);
            else
                $this->fungsi->redirectMessage('Maaf anda tidak bisa mengakses halaman ini.', '/home');
        } else if ($klasifikasi == '010') {
            if (in_array("010", $this->newsession->userdata('SESS_KLASIFIKASI_ID')))
                $this->content = $this->load->view('iklan/pengawasanIklanOTDetail', $arrdata, true);
            else
                $this->fungsi->redirectMessage('Maaf anda tidak bisa mengakses halaman ini.', '/home');
        } else if ($klasifikasi == '011') {
            if (in_array("011", $this->newsession->userdata('SESS_KLASIFIKASI_ID')))
                $this->content = $this->load->view('iklan/pengawasanIklanSMDetail', $arrdata, true);
            else
                $this->fungsi->redirectMessage('Maaf anda tidak bisa mengakses halaman ini.', '/home');
        } else if ($klasifikasi == '013') {
            if (trim($jenis) == "")
                redirect(site_url());
            if (in_array("007", $this->newsession->userdata('SESS_KLASIFIKASI_ID')))
                $this->content = $this->load->view('iklan/pengawasanIklanPangan' . $jenis . 'Detail', $arrdata, true);
            else
                $this->fungsi->redirectMessage('Maaf anda tidak bisa mengakses halaman ini.', '/home');
        } else if ($klasifikasi == '007') {
            if (in_array("007", $this->newsession->userdata('SESS_KLASIFIKASI_ID')))
                $this->content = $this->load->view('iklan/pengawasanIklanRokokDetail', $arrdata, true);
            else
                $this->fungsi->redirectMessage('Maaf anda tidak bisa mengakses halaman ini.', '/home');
        }
        $this->index();
    }

    function setFormIklanLanjutan($jenispelaporan = "", $klasifikasi = "", $isajax = "") {
        $this->cekLogin();
        if (strtolower($_SERVER['REQUEST_METHOD']) != "post") {
            redirect(base_url());
            exit();
        } else {
            if ($jenispelaporan == "pengawasan") {
                $this->load->model("iklan/M" . $klasifikasi . "/_" . $klasifikasi . "m");
                $model = '_' . $klasifikasi . 'm';
                $ret = $this->$model->setFormIklan($isajax);
            }
            if ($isajax != "ajax") {
                $this->fungsi->redirectMessage('Maaf anda tidak bisa mengakses halaman ini.', '/home');
            }
            echo $ret;
        }
    }

    function setListFormIklanLanjutan($jenispelaporan = "", $user = "") {
        $this->cekLogin();
        if (trim($jenispelaporan) != "") {
            $this->load->model("iklan/iklan_act");
            $arrdata = $this->iklan_act->getListFormIklan($jenispelaporan, $user);
            $this->content = $this->load->view('table', $arrdata, true);
        }
        $this->index();
    }

    function setSurat($jenispelaporan = "", $isajax = "") {
        $this->cekLogin();
        if (strtolower($_SERVER['REQUEST_METHOD']) != "post") {
            redirect(base_url());
            exit();
        } else {
            if ($jenispelaporan == "pengawasan") {
                $this->load->model('iklan/iklan_act');
                $ret = $this->iklan_act->setSurat($isajax);
            }
            if ($jenispelaporan == "pengawasanUpd") {
                $this->load->model("iklan/iklan_act");
                $ret = $this->iklan_act->updateSurat($isajax);
            }
        }
        if ($isajax != "ajax") {
            $this->fungsi->redirectMessage('Maaf anda tidak bisa mengakses halaman ini.', '/home');
        }
        echo $ret;
    }

    function setPreview($jenisPelaporan, $idPengawasan, $klasifikasi) {
        $this->cekLogin();
        $this->load->model("iklan/M" . $klasifikasi . "/_" . $klasifikasi . "m");
        $model = '_' . $klasifikasi . 'm';
        $arrdata = $this->$model->getPreview($klasifikasi, $jenisPelaporan, $idPengawasan);
        if ($klasifikasi == '001') {
            $this->load->view('iklan/detail/detailIklanObat', $arrdata);
        }
        if ($klasifikasi == '010') {
            $this->load->view('iklan/detail/detailIklanOT', $arrdata);
        }
        if ($klasifikasi == '011') {
            $this->load->view('iklan/detail/detailIklanSM', $arrdata);
        }
        if ($klasifikasi == '012') {
            $this->load->view('iklan/detail/detailIklanKosmetika', $arrdata);
        }
        if ($klasifikasi == '013') {
            $this->load->view('iklan/detail/detailIklanPangan', $arrdata);
        }
        if ($klasifikasi == '007') {
            $this->load->view('iklan/detail/detailIklanRokok', $arrdata);
        }
    }

    function setCheck($isajax = "") {
        $this->cekLogin();
        if (strtolower($_SERVER['REQUEST_METHOD']) != "post") {
            redirect(base_url());
            exit();
        } else {
            $sipt = & get_instance();
            $sipt->load->model("main", "main", true);
            $this->load->model('iklan/iklan_act');
            $role = "'" . join("', '", array_keys($this->newsession->userdata('SESS_KODE_ROLE'))) . "'";
            $src = "<form id=\"fset_all\" action=\"" . site_url() . "/iklan/iklanController/setStatus/2/$isajax\">";
            $src .= "<div><b>Kirim Data Terpilih</b></div>";
            $src .= "<ul style=\"list-style:decimal; margin-left:17px;\">";
            foreach ($this->input->post('tb_chk') as $a) {
                $split_uri = explode("/", $a);
                $subQuery = "SELECT TI.KOMODITI AS KKKOMODITI, dbo.GET_KOMODITI(TI.KOMODITI) AS KOMODITI, dbo.GET_PRODUK_PENGAWASAN(TI.IKLAN_ID, 'IKLAN', 'PRODUK') AS PRODUK FROM T_IKLAN TI WHERE IKLAN_ID ='" . $split_uri[0] . "'";
                $data = $sipt->main->get_result($subQuery);
                if ($data) {
                    foreach ($subQuery->result_array() as $row) {
                        $produk['PRODUK'] = $row['PRODUK'];
                        $produk['KOMODITI'] = $row['KOMODITI'];
                        $produk['KKKOMODITI'] = $row['KKKOMODITI'];
                    }
                }
                $namaMedia = $sipt->main->get_uraian("SELECT CASE(SELECT COUNT(MM2.NAMA_MEDIA) AS MEDIA FROM M_MEDIA MM2 WHERE CONVERT(VARCHAR(100),MM2.ID_MEDIA) = TI.NAMA_MEDIA) WHEN 0 THEN (CASE CONVERT(VARCHAR(100), TI.NAMA_MEDIA) WHEN '0' THEN '-' ELSE CONVERT(VARCHAR(100), TI.NAMA_MEDIA) END) ELSE MM.NAMA_MEDIA END AS NAMA_MEDIA FROM T_IKLAN TI LEFT JOIN M_MEDIA MM ON CONVERT(VARCHAR(100),MM.ID_MEDIA) = TI.NAMA_MEDIA WHERE IKLAN_ID ='" . $split_uri[0] . "'", "NAMA_MEDIA");
                $media = $sipt->main->get_uraian("SELECT MEDIA FROM T_IKLAN WHERE IKLAN_ID ='" . $split_uri[0] . "'", "MEDIA");
                $next = $sipt->main->get_uraian("SELECT SESUDAH FROM M_VERIFIKASI WHERE ROLE_ID IN($role) AND SEBELUM IN('" . $split_uri[2] . "') AND PROSES = '1'", "SESUDAH");
                $query = "SELECT SESUDAH FROM M_VERIFIKASI WHERE ROLE_ID IN($role) AND SEBELUM IN('" . $split_uri[2] . "') AND PROSES = '1'";
                if (trim($namaMedia) != '')
                    $src .= "<li>(" . $produk['KOMODITI'] . ") " . $produk['PRODUK'] . " : " . $media . " (" . $namaMedia . ")<input type=\"hidden\" name=\"IKLAN_ID[]\" value=\"" . $split_uri[0] . "\"></li>";
                else
                    $src .= "<li>(" . $produk['KOMODITI'] . ") " . $produk['PRODUK'] . " : " . $media . "<input type=\"hidden\" name=\"IKLAN_ID[]\" value=\"" . $split_uri[0] . "\"></li>";
                $src .= "<input type=\"hidden\" name=\"KOMODITI[]\" value=\"" . $produk['KKKOMODITI'] . "\">";
            }
            $src .= "</ul>";
            $src .= "<div style=\"padding-top:5px;\"><b>Mengirim Ke : " . $sipt->main->get_uraian("SELECT URAIAN FROM M_TABEL WHERE JENIS = 'STATUS' AND KODE = '" . $next . "'", "URAIAN") . "</b></div>";
            $src .= "<div style=\"padding-top:5px;\">Catatan :</div>";
            $src .= "<div style=\"padding-top:5px;\"><textarea class=\"stext catatan\" rel=\"required\" name=\"CATATAN\"></textarea></div>";
            $src .= "<div style=\"padding-top:5px;\"><a href=\"javascript:void(0)\" class=\"button check\" id=\"set_all\"><span><span class=\"icon\"></span>&nbsp; Proses &nbsp;</span></a></div>";
            $src .= "<input type=\"hidden\" name=\"TO\" value=\"" . $next . "\">";
            $src .= "</form>";
            echo $src;
        }
    }

    function setStatus($X = "", $isajax = "") {
        $this->cekLogin();
        if (strtolower($_SERVER['REQUEST_METHOD']) != "post") {
            redirect(base_url());
            exit();
        } else {
            $this->load->model("iklan/iklan_act");
            $ret = $this->iklan_act->setStatus($X, $isajax);
        }
        if ($isajax != "ajax") {
            redirect(base_url());
            exit();
        }
        echo $ret;
    }

    function updateStatus($klasifikasi = "", $X = "", $isajax = "") {
        $this->cekLogin();
        if (strtolower($_SERVER['REQUEST_METHOD']) != "post") {
            redirect(base_url());
            exit();
        } else {
            $this->load->model("iklan/M" . $klasifikasi . "/_" . $klasifikasi . "m");
            $model = '_' . $klasifikasi . 'm';
            $ret = $this->$model->updateStatus($X, $isajax);
        }
        if ($isajax != "ajax") {
            redirect(base_url());
            exit();
        }
        echo $ret;
    }

    function petugas($jenis = "", $iklanObatId = "", $status = "", $iklanId = "", $klasifikasi) {
        $this->cekLogin();
        if ($jenis == "petugas") {
            if ($status != "" && $iklanObatId != "" && $iklanId != "") {
                $this->load->model('iklan/iklan_act');
                $arrdata = $this->iklan_act->get_petugas($iklanObatId, $status, $iklanId, $klasifikasi);
                $this->content = $this->load->view('pemeriksaan/petugas', $arrdata, true);
            } else {
                return $this->fungsi->redirectMessage('Maaf, halaman yang anda maksud tidak ditemukan.', '/home');
            }
        } else {
            return $this->fungsi->redirectMessage('Maaf, halaman yang anda maksud tidak ditemukan.', '/home');
        }
        $this->index();
    }

    function prosesPreview($jenis, $iklanId, $klasifikasi, $status, $subid, $user) {
        $this->cekLogin();
        if (trim($iklanId) == "")
            return $this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.', '/home');
        $this->load->model("iklan/M" . $klasifikasi . "/_" . $klasifikasi . "m");
        $model = '_' . $klasifikasi . 'm';
        $arrdata = $this->$model->inputPreview($jenis, $iklanId, $status, $klasifikasi, $subid, $user);
        if ($klasifikasi == '001') {
            $this->content = $this->load->view('iklan/preview/previewIklanObat', $arrdata, true);
        } else if ($klasifikasi == '010') {
            $this->content = $this->load->view('iklan/preview/previewIklanOT', $arrdata, true);
        } else if ($klasifikasi == '011') {
            $this->content = $this->load->view('iklan/preview/previewIklanSM', $arrdata, true);
        } else if ($klasifikasi == '012') {
            $this->content = $this->load->view('iklan/preview/previewIklanKosmetika', $arrdata, true);
        } else if ($klasifikasi == '013') {
            $this->content = $this->load->view('iklan/preview/previewIklanPangan', $arrdata, true);
        } else if ($klasifikasi == '007') {
            $this->content = $this->load->view('iklan/preview/previewIklanRokok', $arrdata, true);
        }
        $this->index();
    }

    function prosesDelete($jenis) {
        $this->cekLogin();
        $ret = "MSG#Proses Gagal.";
        $i = 0;
        foreach ($this->input->post('tb_chk') as $value) {
            $arrpost = explode("/", $value);
            $iklanId = $arrpost[0];
            $klasifikasi = $arrpost[1];
            if (trim($iklanId) == "")
                return $this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.', '/home');
            $this->load->model("iklan/M" . $klasifikasi . "/_" . $klasifikasi . "m");
            $model = '_' . $klasifikasi . 'm';
            if ($this->$model->deleteData($iklanId))
                $i++;
        }
        if ($i > 0) {
            $ret = "MSG#Proses Berhasil.#" . site_url() . "/iklan/iklanController/monitoring/";
        }
        echo $ret;
    }

    function prosesEdit($jenis, $iklanId, $klasifikasi, $status, $subid, $user, $bbpom) {
        $this->cekLogin();
        if ($iklanId == "")
            return $this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.', '/home');
        if ($jenis == 'suratTugas') {
            $this->load->model('iklan/iklan_act');
            $arrdata = $this->iklan_act->getSurat($iklanId);
            $this->content = $this->load->view('iklan/pengawasanIklan', $arrdata, true);
        } else {
            $this->load->model("iklan/M" . $klasifikasi . "/_" . $klasifikasi . "m");
            $model = '_' . $klasifikasi . 'm';
            $arrdata = $this->$model->inputPreview($jenis, $iklanId, $status, $klasifikasi, $subid, $user, $bbpom);
            if ($klasifikasi == '001') {
                if (((!in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) && !in_array($bbpom, $this->config->item('cfg_unit'))) || ((in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) && in_array($bbpom, $this->config->item('cfg_unit'))))
                    $this->content = $this->load->view('iklan/pengawasanIklanObatDetail', $arrdata, true);
                else
                    $this->content = $this->load->view('iklan/preview/previewIklanObat', $arrdata, true);
            } else if ($klasifikasi == '010') {
                if (((!in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) && !in_array($bbpom, $this->config->item('cfg_unit'))) || ((in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) && in_array($bbpom, $this->config->item('cfg_unit'))))
                    $this->content = $this->load->view('iklan/pengawasanIklanOTDetail', $arrdata, true);
                else
                    $this->content = $this->load->view('iklan/preview/previewIklanOT', $arrdata, true);
            } else if ($klasifikasi == '011') {
                if (((!in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) && !in_array($bbpom, $this->config->item('cfg_unit'))) || ((in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) && in_array($bbpom, $this->config->item('cfg_unit'))))
                    $this->content = $this->load->view('iklan/pengawasanIklanSMDetail', $arrdata, true);
                else
                    $this->content = $this->load->view('iklan/preview/previewIklanSM', $arrdata, true);
            } else if ($klasifikasi == '012') {
                if (((!in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) && !in_array($bbpom, $this->config->item('cfg_unit'))) || ((in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) && in_array($bbpom, $this->config->item('cfg_unit'))))
                    $this->content = $this->load->view('iklan/pengawasanIklanKosmetikDetail', $arrdata, true);
                else
                    $this->content = $this->load->view('iklan/preview/previewIklanKosmetika', $arrdata, true);
            } else if ($klasifikasi == '013') {
                $this->load->model("iklan/iklan_act");
                $jenis = $this->iklan_act->getJenis($iklanId);
                if ($jenis == "MD/ML")
                    $jenis = "MDML";
                if (((!in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) && !in_array($bbpom, $this->config->item('cfg_unit'))) || ((in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) && in_array($bbpom, $this->config->item('cfg_unit'))))
                    $this->content = $this->load->view('iklan/pengawasanIklanPangan' . $jenis . 'Detail', $arrdata, true);
                else
                    $this->content = $this->load->view('iklan/preview/previewIklanPangan', $arrdata, true);
            } else if ($klasifikasi == '007') {
                if (((!in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) && !in_array($bbpom, $this->config->item('cfg_unit'))) || ((in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) && in_array($bbpom, $this->config->item('cfg_unit'))))
                    $this->content = $this->load->view('iklan/pengawasanIklanRokokDetail', $arrdata, true);
                else
                    $this->content = $this->load->view('iklan/preview/previewIklanRokok', $arrdata, true);
            }
        }
        $this->index();
    }

    function report($pelaporan = "", $jenis = "") {
        $this->cekLogin();
        if ($pelaporan == "pengawasan") {
            $this->load->model("iklan/iklan_act");
            if ($jenis == "iklanRHPK") {
                $arrdata = $this->iklan_act->get_reportPengawasanRHPK($jenis);
                $this->content = $this->load->view('iklan/report/pengawasanIklanRHPK', $arrdata, true);
            } else if ($jenis == "iklanReport") {
                $arrdata = $this->iklan_act->get_reportPengawasan($jenis);
                $this->content = $this->load->view('iklan/report/pengawasanIklanReport', $arrdata, true);
            } else if ($jenis == "iklanRekapStatus") {
                $arrdata = $this->iklan_act->get_reportRekapStatus($jenis);
                $this->content = $this->load->view('iklan/report/pengawasanIklanRekapStatus', $arrdata, true);
            }
        } else {
            return $this->fungsi->redirectMessage('Maaf, halaman yang anda maksud tidak ditemukan.', '/home');
        }
        $this->index();
    }

    function cetakPenilaian($jenis, $iklanId, $klasifikasi, $status, $subid, $user) {
        $this->cekLogin();
        $siapik = & get_instance();
        $siapik->load->model("main", "main", true);
        $this->load->library('mpdf');
        $this->load->model("iklan/M" . $klasifikasi . "/_" . $klasifikasi . "m");
        if ($klasifikasi != "001")
            return $this->fungsi->redirectMessage('Maaf, halaman yang anda maksud masih dalam pengerjaan.', '/iklan/iklanController/setListFormIklanLanjutan/1122/01');
        $model = '_' . $klasifikasi . 'm';
        $arrdata = $this->$model->inputPreview($jenis, $iklanId, $status, $klasifikasi, $subid, $user);
        $suratId = $arrdata['sess']['SURAT_ID'];
        $query = "SELECT A.NOMOR_SURAT AS [Nomor Surat Tugas], CONVERT(VARCHAR(10), A.TANGGAL, 103) AS [Tanggal Surat], B.NAMA_USER AS [Nama Petugas], C.NAMA_BBPOM AS [Balai / Badan] FROM T_SURAT_TUGAS_IKLAN A LEFT JOIN T_USER B ON B.USER_ID = A.PETUGAS LEFT JOIN M_BBPOM C ON C.BBPOM_ID = B.BBPOM_ID WHERE A.SURAT_ID IN ($suratId)";
        $data = $this->main->get_result($query);
        if ($data) {
            $str = '<table class="tabelajax"><tr class="head"><th>Nomor Surat Tugas</th><th>Tanggal Surat</th><th>Nama Petugas</th><th>Balai / Badan POM</th></tr>';
            foreach ($query->result_array() as $row) {
                if (trim($row['Nomor Surat Tugas']) == "")
                    $nomorSurat = "-";
                else
                    $nomorSurat = $row['Nomor Surat Tugas'];
                if (trim($row['Tanggal Surat']) == "")
                    $tglSurat = "-";
                else
                    $tglSurat = $row['Tanggal Surat'];
                $str .= '<tr><td>' . $nomorSurat . '</td><td>' . $tglSurat . '</td><td>' . $row['Nama Petugas'] . '</td><td>' . $row['Balai / Badan'] . '</td></tr>';
            }
            $str .= '</table>';
        }
        $petugas['histori'] = $str;
        $arrdata = array_merge($petugas, $arrdata);
        $mpdf = new mPDF('win-1252', array(210, 330));
        $mpdf->useOnlyCoreFonts = true;
        $mpdf->SetProtection(array('print'));
        $mpdf->SetAuthor("Pengawasan Iklan");
        $mpdf->SetDisplayMode('fullpage');
        $html = $this->load->view('iklan/cetakan/pengawasanIklanPenilaianObat', $arrdata, true);
        $this->mpdf->WriteHTML($html);
        $this->mpdf->Output();
        return $html;
    }

    function rekapitulasi($laporan) {
        $this->cekLogin();
        if (strtolower($_SERVER['REQUEST_METHOD']) != "post") {
            redirect(base_url());
            exit();
        } else {
            $sipt = & get_instance();
            $this->load->model("main", "main", true);
            $jenis = $this->input->post('JENIS');
            $mdl = "_" . $jenis . "m";
            $fld = "M" . $jenis;
            if ($laporan == "RHPK") {
                $this->load->model('iklan/' . $fld . '/' . $mdl);
                $arrdata = $this->$mdl->RHPK();
            } else if ($laporan == "report") {
                $this->load->model('iklan/' . $fld . '/' . $mdl);
                $arrdata = $this->$mdl->report();
            } else if ($laporan == "statusDokumen") {
                $this->load->model('iklan/iklan_act');
                $arrdata = $this->iklan_act->rekapStatusDokumen();
            }
            echo $arrdata;
        }
    }

    function master($metode) {
        $this->cekLogin();
        $this->load->model("master/sarana_act");
        $arrdata = $this->sarana_act->get_sarana($id);
        $this->content = $this->load->view('master/sarana', $arrdata, true);
    }

    function monitoring() {
        $this->cekLogin();
        if (in_array('1', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('9', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('10', $this->newsession->userdata('SESS_KODE_ROLE'))) {
            $this->load->model("iklan/iklan_act");
            $arrdata = $this->iklan_act->monitoring();
        } else {
            return $this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.', '/home');
        }
        $this->content = $this->load->view('table', $arrdata, true);
        $this->index();
    }

    function monitoringSrc($cari, $subcari = "") {
        $this->cekLogin();
        if (in_array('1', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('9', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('10', $this->newsession->userdata('SESS_KODE_ROLE'))) {
            $this->load->model("iklan/iklan_act");
            $arrdata = $this->iklan_act->monitoring_act($cari, $subcari);
        } else {
            return $this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.', '/home');
        }
        $this->content = $this->load->view('table', $arrdata, true);
        $this->index();
    }

    function mediaSrc($cari, &$subcari = "") {
        if (!$this->newsession->userdata('LOGGED_IN')) {
            $this->index();
            return;
        }
        $this->load->model('master/media_act');
        $arrdata = $this->media_act->list_media_act($cari, $subcari);
        $this->content = $this->load->view('table', $arrdata, true);
        $this->index();
    }

}

?>