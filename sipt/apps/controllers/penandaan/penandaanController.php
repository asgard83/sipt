<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class PenandaanController extends Controller {

    var $content = "";

    function PenandaanController() {
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
//        if ($this->newsession->userdata('LOGGED_IN') || in_array('05', $this->newsession->userdata('SESS_JENIS_PELAPORAN') || $this->newsession->userdata('SESS_BBPOM_ID') == "00"))
//            return;
//        else
//            $this->fungsi->redirectMessage('Maaf anda tidak bisa mengakses halaman ini.', '/home');
//        $this->index();
//        return;
    }

    function setFormPenandaanLanjutan($jenispelaporan = "", $klasifikasi = "", $isajax = "") {
        $this->cekLogin();
        if (strtolower($_SERVER['REQUEST_METHOD']) != "post") {
            redirect(base_url());
            exit();
        } else {
            if ($jenispelaporan == "pengawasan") {
                $this->load->model("penandaan/M" . $klasifikasi . "/_" . $klasifikasi . "m");
                $model = '_' . $klasifikasi . 'm';
                $ret = $this->$model->setFormPenandaan($isajax);
            }
            if ($isajax != "ajax") {
                $this->fungsi->redirectMessage('Maaf anda tidak bisa mengakses halaman ini.', '/home');
            }
            echo $ret;
        }
    }

    function getFormPenandaanLanjutan($klasifikasi = "", $jenis = "") {
        $this->cekLogin();
        $this->load->model("penandaan/M" . $klasifikasi . "/_" . $klasifikasi . "m");
        $model = '_' . $klasifikasi . 'm';
        if ($klasifikasi != '013')
            $arrdata = $this->$model->getFormPenandaan($klasifikasi);
        else
            $arrdata = $this->$model->getFormPenandaan($klasifikasi, $jenis);
        if ($klasifikasi == '001') {
            if (in_array("001", $this->newsession->userdata('SESS_KLASIFIKASI_ID')))
                $this->content = $this->load->view('penandaan/penandaanObatDetail', $arrdata, true);
            else
                $this->fungsi->redirectMessage('Maaf anda tidak bisa mengakses halaman ini.', '/home');
        } else if ($klasifikasi == '010') {
            if (in_array("010", $this->newsession->userdata('SESS_KLASIFIKASI_ID')))
                $this->content = $this->load->view('penandaan/penandaanOTDetail', $arrdata, true);
            else
                $this->fungsi->redirectMessage('Maaf anda tidak bisa mengakses halaman ini.', '/home');
        } else if ($klasifikasi == '012') {
            if (in_array("012", $this->newsession->userdata('SESS_KLASIFIKASI_ID')))
                $this->content = $this->load->view('penandaan/penandaanKosmetikDetail', $arrdata, true);
            else
                $this->fungsi->redirectMessage('Maaf anda tidak bisa mengakses halaman ini.', '/home');
        } else if ($klasifikasi == '011') {
            if (in_array("011", $this->newsession->userdata('SESS_KLASIFIKASI_ID')))
                $this->content = $this->load->view('penandaan/penandaanSMDetail', $arrdata, true);
            else
                $this->fungsi->redirectMessage('Maaf anda tidak bisa mengakses halaman ini.', '/home');
        } else if ($klasifikasi == '013') {
            if (in_array("013", $this->newsession->userdata('SESS_KLASIFIKASI_ID')))
                $this->content = $this->load->view('penandaan/penandaanPangan' . $jenis . 'Detail', $arrdata, true);
            else
                $this->fungsi->redirectMessage('Maaf anda tidak bisa mengakses halaman ini.', '/home');
        } else if ($klasifikasi == '007') {
            if (in_array("007", $this->newsession->userdata('SESS_KLASIFIKASI_ID')))
                $this->content = $this->load->view('penandaan/penandaanRokokDetail', $arrdata, true);
            else
                $this->fungsi->redirectMessage('Maaf anda tidak bisa mengakses halaman ini.', '/home');
        } else {
            return $this->fungsi->redirectMessage('Maaf, halaman yang anda maksud tidak ditemukan.', '/home');
        }
        $this->index();
    }

    function setListFormPenandaanLanjutan($jenispelaporan = "", $user = "") {
        $this->cekLogin();
        if ($jenispelaporan != " ") {
            $this->load->model("penandaan/penandaan_act");
            $arrdata = $this->penandaan_act->getListFormPenandaan($jenispelaporan, $user);
            $this->content = $this->load->view('table', $arrdata, true);
        }
        $this->index();
    }

    function setPreview($jenisPelaporan, $idPengawasan, $klasifikasi) {
        $this->cekLogin();
        $this->load->model("penandaan/M" . $klasifikasi . "/_" . $klasifikasi . "m");
        $model = '_' . $klasifikasi . 'm';
        $data = $this->$model->getPreview($klasifikasi, $jenisPelaporan, $idPengawasan);
        if ($klasifikasi == '001') {
            $this->load->view('penandaan/detail/detailPenandaanObat', $data);
        } else if ($klasifikasi == '010') {
            $this->load->view('penandaan/detail/detailPenandaanOT', $data);
        } else if ($klasifikasi == '011') {
            $this->load->view('penandaan/detail/detailPenandaanSM', $data);
        } else if ($klasifikasi == '012') {
            $this->load->view('penandaan/detail/detailPenandaanKosmetika', $data);
        } else if ($klasifikasi == '013') {
            $this->load->view('penandaan/detail/detailPenandaanPangan', $data);
        } else if ($klasifikasi == '007') {
            $this->load->view('penandaan/detail/detailPenandaanRokok', $data);
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
            $this->load->model('penandaan/penandaan_act');
            $getRole = $this->penandaan_act->getRole();
            $pelaporan = "'" . join("', '", array_keys($this->newsession->userdata('SESS_JENIS_PELAPORAN'))) . "'";
            $role = "'" . join("', '", array_keys($this->newsession->userdata('SESS_KODE_ROLE'))) . "'";
            $src = "<form id=\"fset_all\" action=\"" . site_url() . "/penandaan/penandaanController/setStatus/2/$isajax\">";
            $src .= "<div><b>Kirim Data Terpilih</b></div>";
            $src .= "<ul style=\"list-style:decimal; margin-left:17px;\">";
            foreach ($this->input->post('tb_chk') as $a) {
                $split_uri = explode("/", $a);
                $subQuery = "SELECT TP.KOMODITI AS KKKOMODITI, dbo.GET_KOMODITI(TP.KOMODITI) AS KOMODITI, dbo.GET_BUNGKUS('" . $split_uri[0] . "') AS BUNGKUS FROM T_PENANDAAN TP WHERE TP.PENANDAAN_ID ='" . $split_uri[0] . "'";
                $res = $sipt->main->get_result($subQuery);
                if ($res) {
                    foreach ($subQuery->result_array() as $value) {
                        $hasil['BUNGKUS'] = str_replace(", ", ", ", $value['BUNGKUS']);
                        $hasil['KOMODITI'] = $value['KOMODITI'];
                        $hasil['KKKOMODITI'] = $value['KKKOMODITI'];
                    }
                }
                $next = $sipt->main->get_uraian("SELECT SESUDAH FROM M_VERIFIKASI WHERE ROLE_ID IN($role) AND SEBELUM IN('" . $split_uri[2] . "') AND PROSES = '1'", "SESUDAH");
                $query = "SELECT SESUDAH FROM M_VERIFIKASI WHERE ROLE_ID IN($role) AND SEBELUM IN('" . $split_uri[2] . "') AND PROSES = '1'";
                if (trim($hasil['BUNGKUS']) != "")
                    $src .= "<li>(" . $hasil["KOMODITI"] . ") " . $sipt->main->get_uraian("SELECT NAMA_PRODUK FROM T_PENANDAAN_PRODUK WHERE PENANDAAN_ID ='" . $split_uri[0] . "'", "NAMA_PRODUK") . " : " . rtrim($hasil['BUNGKUS'], ", ") . "<input type=\"hidden\" name=\"PENANDAAN_ID[]\" value=\"" . $split_uri[0] . "\"></li>";
                else
                    $src .= "<li>(" . $hasil["KOMODITI"] . ") " . $sipt->main->get_uraian("SELECT NAMA_PRODUK FROM T_PENANDAAN_PRODUK WHERE PENANDAAN_ID ='" . $split_uri[0] . "'", "NAMA_PRODUK") . "<input type=\"hidden\" name=\"PENANDAAN_ID[]\" value=\"" . $split_uri[0] . "\"></li>";
                $src .= "<input type=\"hidden\" name=\"KOMODITI[]\" value=\"" . $hasil['KKKOMODITI'] . "\">";
            }
            $src .= "</ul>";
            $src .= "<div style=\"padding-top:5px;\"><b>Mengirim Ke : " . $sipt->main->get_uraian("SELECT URAIAN FROM M_TABEL WHERE JENIS = 'STATUS' AND KODE = '" . $next . "'", "URAIAN") . "</b></div>";
            $src .= "<div style=\"padding-top:5px;\">Catatan :</div>";
            $src .= "<div style=\"padding-top:5px;\"><textarea class=\"stext catatan\" rel=\"required\" name=\"CATATAN\"></textarea></div>";
            $src .= "<div style=\"padding-top:5px;\"><a href=\"javascript:void(0)\" class=\"button check\" id=\"set_all\"><span><span class=\"icon\"></span>&nbsp; Proses &nbsp;</span></a></div>";
            $src .= "<input type=\"hidden\" name=\"TO\" value=\"" . $next . "\">";
            $src .= "</form";
            echo $src;
        }
    }

    function setStatus($X = "", $isajax = "") {
        $this->cekLogin();
        if (strtolower($_SERVER['REQUEST_METHOD']) != "post") {
            redirect(base_url());
            exit();
        } else {
            $this->load->model("penandaan/penandaan_act");
            $ret = $this->penandaan_act->setStatus($X, $isajax);
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
            $this->load->model("penandaan/M" . $klasifikasi . "/_" . $klasifikasi . "m");
            $model = '_' . $klasifikasi . 'm';
            $ret = $this->$model->updateStatus($X, $isajax);
        }
        if ($isajax != "ajax") {
            redirect(base_url());
            exit();
        }
        echo $ret;
    }

    function prosesEdit($jenis, $penandaanId, $klasifikasi, $status, $subid, $user, $bbpom) {
        $this->cekLogin();
        if ($penandaanId == "")
            return $this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.', '/home');
        if ($jenis == 'suratTugas') {
            $this->load->model('penandaan/penandaan_act');
            $arrdata = $this->penandaan_act->getSurat($penandaanId, $klasifikasi);
            $this->content = $this->load->view('penandaan/penandaan', $arrdata, true);
        } else {
            $this->load->model("penandaan/M" . $klasifikasi . "/_" . $klasifikasi . "m");
            $model = '_' . $klasifikasi . 'm';
            $arrdata = $this->$model->inputPreview($jenis, $penandaanId, $status, $klasifikasi, $subid, $user, $bbpom);
            if ($klasifikasi == '001') {
                if (((!in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) && !in_array($bbpom, $this->config->item('cfg_unit'))) || ((in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) && in_array($bbpom, $this->config->item('cfg_unit'))))
                    $this->content = $this->load->view('penandaan/penandaanObatDetail', $arrdata, true);
                else
                    $this->content = $this->load->view('penandaan/preview/previewPenandaanObat', $arrdata, true);
            } else if ($klasifikasi == '010') {
                if (((!in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) && !in_array($bbpom, $this->config->item('cfg_unit'))) || ((in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) && in_array($bbpom, $this->config->item('cfg_unit'))))
                    $this->content = $this->load->view('penandaan/penandaanOTDetail', $arrdata, true);
                else
                    $this->content = $this->load->view('penandaan/preview/previewPenandaanOT', $arrdata, true);
            } else if ($klasifikasi == '011') {
                if (((!in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) && !in_array($bbpom, $this->config->item('cfg_unit'))) || ((in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) && in_array($bbpom, $this->config->item('cfg_unit'))))
                    $this->content = $this->load->view('penandaan/penandaanSMDetail', $arrdata, true);
                else
                    $this->content = $this->load->view('penandaan/preview/previewPenandaanSM', $arrdata, true);
            } else if ($klasifikasi == '012') {
                if (((!in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) && !in_array($bbpom, $this->config->item('cfg_unit'))) || ((in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) && in_array($bbpom, $this->config->item('cfg_unit'))))
                    $this->content = $this->load->view('penandaan/penandaanKosmetikDetail', $arrdata, true);
                else
                    $this->content = $this->load->view('penandaan/preview/previewPenandaanKosmetika', $arrdata, true);
            } else if ($klasifikasi == '013') {
                $this->load->model("iklan/penandaan_act");
                $jenis = $this->penandaan_act->getJenis($penandaanId);
                if ($jenis == "MD/ML")
                    $jenis = "MDML";
                if (((!in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) && !in_array($bbpom, $this->config->item('cfg_unit'))) || ((in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) && in_array($bbpom, $this->config->item('cfg_unit'))))
                    $this->content = $this->load->view('penandaan/penandaanPangan' . $jenis . 'Detail', $arrdata, true);
                else
                    $this->content = $this->load->view('penandaan/preview/previewPenandaanPangan', $arrdata, true);
            } else if ($klasifikasi == '007') {
                if (((!in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) && !in_array($bbpom, $this->config->item('cfg_unit'))) || ((in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) && in_array($bbpom, $this->config->item('cfg_unit'))))
                    $this->content = $this->load->view('penandaan/penandaanRokokDetail', $arrdata, true);
                else
                    $this->content = $this->load->view('penandaan/preview/previewPenandaanRokok', $arrdata, true);
            }
        }
        $this->index();
    }

    function prosesPreview($jenis, $penandaanId, $klasifikasi, $status, $subid, $user) {
        $this->cekLogin();
        if ($penandaanId == "")
            return $this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.', '/home');
        $this->load->model("penandaan/M" . $klasifikasi . "/_" . $klasifikasi . "m");
        $model = '_' . $klasifikasi . 'm';
        $arrdata = $this->$model->inputPreview($jenis, $penandaanId, $status, $klasifikasi, $subid, $user);
        if ($klasifikasi == '001') {
            $this->content = $this->load->view('penandaan/preview/previewPenandaanObat', $arrdata, true);
        } else if ($klasifikasi == "010") {
            $this->content = $this->load->view('penandaan/preview/previewPenandaanOT', $arrdata, true);
        } else if ($klasifikasi == "011") {
            $this->content = $this->load->view('penandaan/preview/previewPenandaanSM', $arrdata, true);
        } else if ($klasifikasi == "012") {
            $this->content = $this->load->view('penandaan/preview/previewPenandaanKosmetika', $arrdata, true);
        } else if ($klasifikasi == "013") {
            $this->content = $this->load->view('penandaan/preview/previewPenandaanPangan', $arrdata, true);
        } else if ($klasifikasi == "007") {
            $this->content = $this->load->view('penandaan/preview/previewPenandaanRokok', $arrdata, true);
        } $this->index();
    }

    function prosesDelete($jenis) {
        $this->cekLogin();
        $ret = "MSG#Proses Gagal.";
        $i = 0;
        foreach ($this->input->post('tb_chk') as $value) {
            $arrpost = explode("/", $value);
            $penandaanId = $arrpost[0];
            $klasifikasi = $arrpost[1];
            if (trim($penandaanId) == "")
                return $this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.', '/home');
            $this->load->model("penandaan/M" . $klasifikasi . "/_" . $klasifikasi . "m");
            $model = '_' . $klasifikasi . 'm';
            if ($this->$model->deleteData($penandaanId))
                $i++;
        }
        if ($i > 0) {
            $ret = "MSG#Proses Berhasil.#" . site_url() . "/penandaan/penandaanController/monitoring/";
        }
        echo $ret;
    }

    function report($pelaporan = "", $jenis = "") {
        $this->cekLogin();
        if ($pelaporan == "pengawasan") {
            $this->load->model("penandaan/penandaan_act");
            if ($jenis == "penandaanRHPK") {
                $arrdata = $this->penandaan_act->get_reportPengawasanRHPK($jenis);
                $this->content = $this->load->view('penandaan/report/pengawasanPenandaanRHPK', $arrdata, true);
            } else if ($jenis == "penandaanReport") {
                $arrdata = $this->penandaan_act->get_reportPengawasan($jenis);
                $this->content = $this->load->view('penandaan/report/pengawasanPenandaanReport', $arrdata, true);
            } else if ($jenis == "penandaanRekapStatus") {
                $arrdata = $this->penandaan_act->get_reportRekapStatus($jenis);
                $this->content = $this->load->view('penandaan/report/pengawasanPenandaanRekapStatus', $arrdata, true);
            }
        } else {
            return $this->fungsi->redirectMessage('Maaf, halaman yang anda maksud tidak ditemukan.', '/home');
        }
        $this->
                index();
    }

    function cetakPenilaian($jenis, $iklanId, $klasifikasi, $status, $subid, $user) {
        $this->cekLogin();
        $siapik = & get_instance();
        $siapik->load->model("main", "main", true);
        $this->load->library('mpdf');
        $this->load->model("penandaan/M" . $klasifikasi . "/_" . $klasifikasi . "m");
        if ($klasifikasi != "001")
            return $this->fungsi->redirectMessage('Maaf, halaman yang anda maksud masih dalam pengerjaan.', '/penandaan/penandaanController/setListFormPenandaanLanjutan/1122/01');
        $model = '_' . $klasifikasi . 'm';
        $arrdata = $this->$model->inputPreview($jenis, $iklanId, $status, $klasifikasi, $subid, $user);
        $suratId = $arrdata['sess']['SURAT_ID'];
        $query = "SELECT A.NOMOR_SURAT AS [Nomor Surat Tugas], CONVERT(VARCHAR(10), A.TANGGAL, 103) AS [Tanggal Surat], B.NAMA_USER AS [Nama Petugas], C.NAMA_BBPOM AS [Balai / Badan] FROM T_SURAT_TUGAS_PENANDAAN A LEFT JOIN T_USER B ON B.USER_ID = A.PETUGAS LEFT JOIN M_BBPOM C ON C.BBPOM_ID = B.BBPOM_ID WHERE A.SURAT_ID IN ($suratId)";
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
        $mpdf->SetAuthor("Pengawasan Penandaan");
        $mpdf->SetDisplayMode('fullpage');
        $html = $this->load->view('penandaan/cetakan/pengawasanPenandaanPenilaianObat', $arrdata, true);
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
                $this->load->model('penandaan/' . $fld . '/' . $mdl);
                $arrdata = $this->$mdl->RHPK();
            } else if ($laporan == "report") {
                if ($jenis == '013')
                    die('Under maintenance');
                $this->load->model('penandaan/' . $fld . '/' . $mdl);
                $arrdata = $this->$mdl->report();
            } else if ($laporan == "statusDokumen") {
                $this->load->model('penandaan/penandaan_act');
                $arrdata = $this->penandaan_act->rekapStatusDokumen();
            }
            echo $arrdata;
        }
    }

    function setKlasifikasiObat($id = "") {
        $this->cekLogin();
        $sipt = & get_instance();
        $sipt->load->model("main", "main", true);
        $query = "SELECT A.KK_ID, A.NAMA_KK FROM M_KLASIFIKASI_KATEGORI A LEFT JOIN M_JENIS_SARANA B ON A.JENIS_SARANA_ID = B.JENIS_SARANA_ID WHERE A.JENIS_SARANA_ID = '" . $id . "'";
        $res = $sipt->main->get_result($query);
        $hasil = "";
        if ($res) {
            $hasil .= '<option value="">&nbsp;</option>';
            foreach ($query->result_array() as $row) {
                $hasil .= '<option value="' . $row['KK_ID'] . '">' . $row['NAMA_KK'] . '</option>';
            }
        }
        echo $hasil;
    }

    function setSurat($jenispelaporan = "", $isajax = "") {
        $this->cekLogin();
        if (strtolower($_SERVER['REQUEST_METHOD']) != "post") {
            redirect(base_url());
            exit();
        } else {
            if ($jenispelaporan == "penandaan") {
                $this->load->model('penandaan/penandaan_act');
                $ret = $this->penandaan_act->setSurat($isajax);
            }
            if ($jenispelaporan == "penandaanUpd") {
                $this->load->model('penandaan/penandaan_act');
                $ret = $this->penandaan_act->updateSurat($isajax);
            }
        }
        if ($isajax != "ajax") {
            $this->fungsi->redirectMessage('Maaf anda tidak bisa mengakses halaman ini.', '/home');
        }
        echo $ret;
    }

    function monitoring() {
        $this->cekLogin();
        if (in_array('1', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('9', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('10', $this->newsession->userdata('SESS_KODE_ROLE'))) {
            $this->load->model("penandaan/penandaan_act");
            $arrdata = $this->penandaan_act->monitoring();
        } else {
            return $this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.', '/home');
        }
        $this->content = $this->load->view('table', $arrdata, true);
        $this->index();
    }

    function monitoringSrc($cari, $subcari = "") {
        $this->cekLogin();
        if (in_array('1', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('9', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('10', $this->newsession->userdata('SESS_KODE_ROLE'))) {
            $this->load->model("penandaan/penandaan_act");
            $arrdata = $this->penandaan_act->monitoring_act($cari, $subcari);
        } else {
            return $this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.', '/home');
        }
        $this->content = $this->load->view('table', $arrdata, true);
        $this->index();
    }

}

?>