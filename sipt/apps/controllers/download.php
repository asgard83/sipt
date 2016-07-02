<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Download extends Controller {

    function Download() {
        parent::Controller();
    }

    function index() {

    }

    function data($file) {
        if ($this->newsession->userdata('LOGGED_IN')) {
            $file = str_replace('sys/', '', BASEPATH) . 'download/' . $file;
            $imginfo = getimagesize($file);
            header("Content-type: $imginfo[mime]");
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            ob_clean();
            flush();
            readfile($file);
            exit;
        } else {
            redirect(base_url());
        }
    }

    function lampiran($pelaporan, $sarana_id, $file) {
        if ($this->newsession->userdata('LOGGED_IN')) {
            $file = str_replace('sys/', '', BASEPATH) . 'files/' . $sarana_id . "/" . $file;
            $imginfo = getimagesize($file);
            header("Content-type: $imginfo[mime]");
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            ob_clean();
            flush();
            readfile($file);
            exit;
        } else {
            redirect(base_url());
        }
    }

    function dokumen($tipe, $y, $m, $file) {
        if ($this->newsession->userdata('LOGGED_IN')) {
            switch ($tipe) {
                case 'lcp':
                    $file = str_replace('sys/', '', BASEPATH) . 'lcp/' . $y . '/' . $m . "/" . $file;
                    break;
            }
        }
    }

    function penandaanIklanNoDirPreUpload($jenis = "", $filename, $y = "", $m = "", $loc = "") {
        if ($this->newsession->userdata('LOGGED_IN')) {
            $path = $jenis . "/" . $y . "/" . $m . "/" . $loc . "/" . $filename;
            $file = str_replace('sys/', '', BASEPATH) . 'files/' . $path;
            if (!file_exists($file)) {
                $file = str_replace('sys/', '', BASEPATH) . 'files/' . $jenis . "/" . $filename;
            }
            $imginfo = getimagesize($file);
            header("Content-type: $imginfo[mime]");
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            ob_clean();
            flush();
            readfile($file);
            exit;
        } else {
            redirect(base_url());
        }
    }

    function penandaanIklanNoDirPostUpload($jenis = "", $y = "", $m = "", $loc = "", $filename = "") {
        if ($this->newsession->userdata('LOGGED_IN')) {
            $path = $jenis . "/" . $y . "/" . $m . "/" . $loc . "/" . $filename;
            $file = str_replace('sys/', '', BASEPATH) . 'files/' . $path;
            if (!file_exists($file)) {
                $file = str_replace('sys/', '', BASEPATH) . 'files/' . $jenis . "/" . $filename;
            }
            $imginfo = getimagesize($file);
            header("Content-type: $imginfo[mime]");
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            ob_clean();
            flush();
            readfile($file);
            exit;
        } else {
            redirect(base_url());
        }
    }

    function penandaanIklanSubDirPreUpload($jenis = "", $subdir, $filename, $y = "", $m = "", $loc = "") {
        if ($this->newsession->userdata('LOGGED_IN')) {
            $path = $jenis . "/" . $subdir . "/" . $y . "/" . $m . "/" . $loc . "/" . $filename;
            $file = str_replace('sys/', '', BASEPATH) . 'files/' . $path;
            if (!file_exists($file)) {
                $file = str_replace('sys/', '', BASEPATH) . 'files/' . $jenis . "/" . $subdir . "/" . $filename;
            }
            $imginfo = getimagesize($file);
            header("Content-type: $imginfo[mime]");
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            ob_clean();
            flush();
            readfile($file);
            exit;
        } else {
            redirect(base_url());
        }
    }

    function penandaanIklanSubDirPostUpload($jenis = "", $subdir, $filename, $y = "", $m = "", $loc = "") {
        if ($this->newsession->userdata('LOGGED_IN')) {
            $path = $jenis . "/" . $subdir . "/" . $filename . "/" . $y . "/" . $m . "/" . $loc;
            $file = str_replace('sys/', '', BASEPATH) . 'files/' . $path;
            if (!file_exists($file)) {
                $file = str_replace('sys/', '', BASEPATH) . 'files/' . $jenis . "/" . $subdir . "/" . $filename;
            }
            $imginfo = getimagesize($file);
            header("Content-type: $imginfo[mime]");
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            ob_clean();
            flush();
            readfile($file);
            exit;
        } else {
            redirect(base_url());
        }
    }

}

?>