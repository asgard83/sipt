<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed'); //error_reporting(E_ERROR);

class Uploads extends Controller {

    function Uploads() {
        parent::Controller();
    }

    function index() {
        $this->fungsi->redirectMessage('Maaf anda tidak bisa mengakses halaman ini.', '/home');
    }

    function new_upload($allowed = "") {
        $allowed = str_replace("-", "|", $allowed);
        $error = "";
        $msg = "";
        $dir = '/home/sipt/data/lcp/' . date('Y') . '/' . date('m');
        if (file_exists($dir) && is_dir($dir)) {
            $config['upload_path'] = $dir;
        } else {
            if (mkdir($dir, 0777, true)) {
                $config['upload_path'] = $dir;
            }
        }
        $config['allowed_types'] = $allowed;
        $config['remove_spaces'] = TRUE;
        $ext = pathinfo($_FILES['userfile']['name'], PATHINFO_EXTENSION);
        $config['file_name'] = "LCP-" . date("Ymdhis") . "-" . substr(str_shuffle(str_repeat('0123456789', 5)), 0, 5) . "." . $ext;
        $this->load->library('upload');
        $this->upload->initialize($config);
        $this->upload->display_errors('', '');
        if (!$this->upload->do_upload("userfile")) {
            $error = $this->upload->display_errors();
        } else {
            $data = $this->upload->data();
            $filename = $data['file_name'];
            $filesize = $data['file_size'];
            $msg = '<a href="' . site_url() . '/download/dokumen/lcp/' . date("Y") . '/' . date("m") . '/' . $filename . '" target="_blank"><b>Klik untuk preview file</b></a> | <a href="javascript:;" onclick="remove_uploads($(this));" id="lampiran-npwp"><b>Hapus atau batalkan?</b></a><input type="hidden" name="trader[LAMPIRAN_NPWP]" value="' . date("Y") . '/' . date("m") . '/' . $filename . '" />#' . $filesize;
        }
        echo "{";
        echo "error: '" . $error . "',\n";
        echo "msg: '" . $msg . "'\n";
        echo "}";
    }

    function upload_produk($periksa = "", $allowed = "") {
        $sipt = & get_instance();
        $this->load->model("main", "main", true);
        $this->load->library('newphpexcel');
        $file = 'upload/excel/';
        $allowed = str_replace("-", "|", $allowed);
        $periksa_id = explode(".", $periksa);
        $error = "";
        $msg = "";
        $arr_komoditi = array("001", "010", "011", "012", "013");
        $config['upload_path'] = $file;
        $config['allowed_types'] = $allowed;
        $config['max_size'] = '20000';
        $this->load->library('upload', $config);
        $this->upload->display_errors('', '');
        if (!$this->upload->do_upload("userfile")) {
            $error = $this->upload->display_errors();
        } else {
            $data = $this->upload->data();
            $kk_id = explode(".", $data['orig_name']);
            if (!in_array($kk_id[0], $arr_komoditi)) {
                $error = "Kode format dokumen tidak dikenali";
                $file = $file . $data['file_name'];
                unlink($file);
            } else {
                $file = $file . $data['file_name'];
                $objPHPExcel = PHPExcel_IOFactory::load($file);
                $insert = FALSE;
                foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
                    $highestRow = $worksheet->getHighestRow();
                    $highestColumn = $worksheet->getHighestColumn();
                    $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
                    for ($a = 0; $a <= ($highestColumnIndex - 2); $a++) {
                        $title = $worksheet->getCellByColumnAndRow($a, 1);
                        $header[$title->getValue()] = array();
                        for ($row = 2; $row <= $highestRow; $row++) {
                            $insert = TRUE;
                            $cell = $worksheet->getCellByColumnAndRow($a, $row);
                            $val = $cell->getValue();
                            $header[$title->getValue()][] = $val;
                        }
                    }
                    if ($insert) {
                        $sukses = 0;
                        $gagal = 0;
                        $cek = FALSE;
                        $arrkeys = array_keys($header);
                        for ($i = 0; $i < count($header[$arrkeys[0]]); $i++) {
                            $seri = (int) $sipt->main->get_uraian("SELECT MAX(SERI) AS MAXID FROM T_PEMERIKSAAN_TEMUAN_PRODUK WHERE PERIKSA_ID = '$periksa_id[0]'", "MAXID") + 1;
                            $temuan = array('PERIKSA_ID' => $periksa_id[0],
                                'SERI' => $seri,
                                'KK_ID' => $kk_id[0]);
                            for ($j = 0; $j < count($arrkeys); $j++) {
                                $temuan[$arrkeys[$j]] = $header[$arrkeys[$j]][$i];
                            }

                            if (array_key_exists('NAMA_PRODUK', $temuan))
                            {
                                $temuan['NAMA_PRODUK'] = str_replace(">", " > ", str_replace("<"," < ", preg_replace('/[^(\x20-\x7F)]*/','',$sipt->main->clean_tags($temuan['NAMA_PRODUK']))));
                            }    
                            if (array_key_exists('NO_BATCH', $temuan))
                                $temuan['NO_BATCH'] = str_replace("'", "", $temuan['NO_BATCH']);
                            if (array_key_exists('JUMLAH_TEMUAN', $temuan))
                                $temuan['JUMLAH_TEMUAN'] = (int) $temuan['JUMLAH_TEMUAN'];
                            if (array_key_exists('HARGA', $temuan))
                                $temuan['HARGA'] = (float) $temuan['HARGA'];
                            if (array_key_exists('HARGA_SATUAN', $temuan))
                                $temuan['HARGA_SATUAN'] = (float) $temuan['HARGA_SATUAN'];
                            if (array_key_exists('HARGA_TOTAL', $temuan))
                                $temuan['HARGA_TOTAL'] = (float) $temuan['HARGA_TOTAL'];
                            if ($this->db->insert('T_PEMERIKSAAN_TEMUAN_PRODUK', $temuan)) {
                                $cek = TRUE;
                            }
                            if ($cek) {
                                $sukses++;
                            } else {
                                $gagal++;
                                unlink($file);
                            }
                        }
                        $msg = "YES#Ada " . $sukses . " Data Berhasil di Upload. Ada " . $gagal . " Data Gagal di Upload";
                    } else {
                        unlink($file);
                        $error = "NO#Data Kosong";
                    }
                }
                unlink($file);
            }
        }
        echo "{";
        echo "error: '" . $error . "',\n";
        echo "msg: '" . $msg . "'\n";
        echo "}";
    }

    function get_upload($periksa = "", $jns = "", $allowed = "") {
        $allowed = str_replace("-", "|", $allowed);
        $error = "";
        $msg = ""; #$dir = '../../uploads/files/'.$periksa;
        $dir = 'files/' . $periksa;
        if (file_exists($dir) && is_dir($dir)) {
            //$config['upload_path'] = "./files/$periksa/";
            $targetpath = "./files/$periksa/";
            //$config['upload_path'] = "./files/$periksa/";
            #if (chmod($dir, 0777)) {
            #$config['upload_path'] = "./files/$periksa/";
            $config['upload_path'] = $dir;
            #}
        } else {
            //if(mkdir(str_replace('//','/',$targetPath), 0777, true)){
            //mkdir("./files/$periksa", 0777);
            if (mkdir($dir, 0777, true)) {
                //$targetpath = "./files/$periksa/";
                //$config['upload_path'] = "./files/$periksa/";
                $config['upload_path'] = $dir;
            }
        }
        $config['allowed_types'] = $allowed;
        $config['remove_spaces'] = TRUE;
        $ext = pathinfo($_FILES['userfile']['name'], PATHINFO_EXTENSION);
        $config['file_name'] = date("Ymd") . "_" . date("His") . "_" . str_replace(".", "_", $periksa) . "." . $ext;
        $this->load->library('upload', $config);
        $this->upload->display_errors('', '');
        if (!$this->upload->do_upload("userfile")) {
			print_r($this->upload->display_errors()); die();
            $error = $this->upload->display_errors();
        } else {
            $data = $this->upload->data();
            $filename = $data['file_name'];
            $filesize = $data['file_size'];
            $msg = $filename . "#" . $filesize . "#" . $jns . "#" . $periksa;
        }
        echo "{";
        echo "error: '" . $error . "',\n";
        echo "msg: '" . $msg . "'\n";
        echo "}";
    }

    function del_upload($dir, $file) {
        $ret = $file . "#File Berhasil dihapus";
        unlink("./files/" . $dir . "/" . $file);
        echo $ret;
    }

    // Penandaan dan Iklan
    function get_upload_s($jenis = "", $jns = "", $allowed = "") {
        ini_set('upload_max_filesize', '10M');
        $allowed = str_replace("-", "|", $allowed);
        $error = "";
        $msg = "";
//    $dir = 'files/' . $periksa;
        $dir = 'files/' . $jenis . "/" . date("Y") . "/" . date("m") . "/" . trim(str_replace(" ", "_", $this->newsession->userdata("SESS_MBBPOM")));
        $mkdir = './files/' . $jenis . "/" . date("Y") . "/" . date("m") . "/" . trim(str_replace(" ", "_", $this->newsession->userdata("SESS_MBBPOM"))) . "/";
        $fileData = date("Y") . "/" . date("m") . "/" . trim(str_replace(" ", "_", $this->newsession->userdata("SESS_MBBPOM")));
//        if (file_exists($dir) && is_dir($dir)) {
//            $config['upload_path'] = $mkdir;
//        } else {
//            mkdir($mkdir, 0700);
//            $config['upload_path'] = $mkdir;
//        }
        if (file_exists($dir) && is_dir($dir)) {
            //$config['upload_path'] = "./files/$periksa/";
            $targetpath = $mkdir;
            //$config['upload_path'] = "./files/$periksa/";
            if (chmod($targetpath, 0777)) {
                $config['upload_path'] = $mkdir;
            }
        } else {
            //if(mkdir(str_replace('//','/',$targetPath), 0777, true)){
            //mkdir("./files/$periksa", 0777);
            if (mkdir($mkdir, 0777, true)) {
                $targetpath = $mkdir;
                //$config['upload_path'] = "./files/$periksa/";
                if (chmod($targetpath, 0777)) {
                    $config['upload_path'] = $mkdir;
                }
                $myfile = fopen($dir . "/index.php", "w");
                $txt = "<?php if(!defined('BASEPATH'))exit('Mohon maaf, anda tidak bisa mengakses halaman ini'); ?>";
                fwrite($myfile, $txt);
                fclose($myfile);
            }
        }
        $config['allowed_types'] = $allowed;
        $config['remove_spaces'] = TRUE;
        $ext = pathinfo($_FILES['userfile']['name'], PATHINFO_EXTENSION);
        $config['file_name'] = date("d") . "_" . date("His") . "_" . trim(str_replace(" ", "", $this->newsession->userdata("SESS_USER_ID"))) . "." . $ext;
        $this->load->library('upload', $config);
        $this->upload->display_errors('', '');
        if (!$this->upload->do_upload("userfile")) {
            $error = $this->upload->display_errors();
        } else {
            $data = $this->upload->data();
            $filename = $data['file_name'];
            $filesize = $data['file_size'];
            $msg = $filename . "/" . $fileData . "#" . $filesize . "#" . $jns . "#" . $jenis . "#" . $fileData . "/" . $filename;
        }
        echo "{";
        echo "error: '" . $error . "',\n";
        echo "msg: '" . $msg . "'\n";
        echo "}";
    }

    function del_upload_s($jenis = "", $filename, $y = "", $m = "", $loc = "") {
        $ret = $filename . "#File Berhasil dihapus";
        $path = $jenis . "/" . $y . "/" . $m . "/" . $loc . "/" . $filename;
        unlink("./files/" . $path);
        echo $ret;
    }

    function get_upload_m($jenis = "", $subDir = "", $jns = "", $allowed = "") {
        ini_set('upload_max_filesize', '10M');
        $allowed = str_replace("-", "|", $allowed);
        $error = "";
        $msg = "";
        $dir = 'files/' . $jenis . '/' . $subDir . "/" . date("Y") . "/" . date("m") . "/" . trim(str_replace(" ", "_", $this->newsession->userdata("SESS_MBBPOM")));
        $mkdir = './files/' . $jenis . "/" . $subDir . "/" . date("Y") . "/" . date("m") . "/" . trim(str_replace(" ", "_", $this->newsession->userdata("SESS_MBBPOM"))) . "/";
        $fileData = date("Y") . "/" . date("m") . "/" . trim(str_replace(" ", "_", $this->newsession->userdata("SESS_MBBPOM")));
        if (file_exists($dir) && is_dir($dir)) {
            //$config['upload_path'] = "./files/$periksa/";
            $targetpath = $mkdir;
            //$config['upload_path'] = "./files/$periksa/";
            if (chmod($targetpath, 0777)) {
                $config['upload_path'] = $mkdir;
            }
        } else {
            //if(mkdir(str_replace('//','/',$targetPath), 0777, true)){
            //mkdir("./files/$periksa", 0777);
            if (mkdir($mkdir, 0777, true)) {
                $targetpath = $mkdir;
                //$config['upload_path'] = "./files/$periksa/";
                if (chmod($targetpath, 0777)) {
                    $config['upload_path'] = $mkdir;
                }
                $myfile = fopen($dir . "/index.php", "w");
                $txt = "<?php if(!defined('BASEPATH'))exit('Mohon maaf, anda tidak bisa mengakses halaman ini'); ?>";
                fwrite($myfile, $txt);
                fclose($myfile);
            }
        }
        $config['allowed_types'] = $allowed;
        $config['remove_spaces'] = TRUE;
        $ext = pathinfo($_FILES['userfile']['name'], PATHINFO_EXTENSION);
        $config['file_name'] = date("d") . "_" . date("His") . "_" . trim(str_replace(" ", "", $this->newsession->userdata("SESS_USER_ID"))) . "." . $ext;
        $this->load->library('upload', $config);
        $this->upload->display_errors('', '');
        if (!$this->upload->do_upload("userfile")) {
            $error = $this->upload->display_errors();
        } else {
            $data = $this->upload->data();
            $filename = $data['file_name'];
            $filesize = $data['file_size'];
            $msg = $filename . "/" . $fileData . "#" . $filesize . "#" . $jns . "#" . $jenis . "#" . $subDir . "#" . $fileData . "/" . $filename;
        }
        echo "{";
        echo "error: '" . $error . "',\n";
        echo "msg: '" . $msg . "'\n";
        echo "}";
    }

    function del_upload_m($jenis = "", $subDir, $filename, $y = "", $m = "", $loc = "") {
        $ret = $filename . "#File Berhasil dihapus";
        $path = $jenis . "/" . $subDir . "/" . $y . "/" . $m . "/" . $loc . "/" . $filename;
        unlink("./files/" . $path);
        echo $ret;
    }

    function get_upload_tabel($set_jenis = "", $periksa = "", $isajax = "", $allowed = "", $attach_as = "") {
        if (strtolower($_SERVER['REQUEST_METHOD']) != "post") {
            $this->fungsi->redirectMessage('Maaf anda tidak bisa mengakses halaman ini.', '/home');
        } else {
            ini_set('upload_max_filesize', '10M');
            $allowed = str_replace("-", "|", $allowed);
            $error = "";
            $msg = "";
            $dir = 'files/' . $periksa;
            if (file_exists($dir) && is_dir($dir)) {
                //$config['upload_path'] = "./files/$periksa/";
                #$targetpath = "./files/$periksa/";
                //$config['upload_path'] = "./files/$periksa/";
                #if (chmod($targetpath, 0777)) {
                #$config['upload_path'] = "./files/$periksa/";
                #}
                $config['upload_path'] = $dir;
            } else {
                //if(mkdir(str_replace('//','/',$targetPath), 0777, true)){
                //mkdir("./files/$periksa", 0777);
                if (mkdir($dir, 0777, true)) {
                    //$targetpath = "./files/$periksa/";
                    //$config['upload_path'] = "./files/$periksa/";
                    //if (chmod($targetpath, 0777)) {
                    //$config['upload_path'] = "./files/$periksa/";
                    //}
                    $config['upload_path'] = $dir;
                }
            }
            $config['allowed_types'] = $allowed;
            $config['remove_spaces'] = TRUE;
            if ($set_jenis == "temuan") {
                $ftype = explode(".", $_FILES['userfile']['name']);
            } else if ($set_jenis == "perbaikan") {
                $ftype = explode(".", $_FILES['userfile']['name']);
            }
            $ext = pathinfo($_FILES['userfile']['name'], PATHINFO_EXTENSION);
            $config['file_name'] = date("Ymd") . "_" . date("His") . "_" . str_replace(".", "_", $periksa) . "." . $ext;
            $this->load->library('upload', $config);
            $this->upload->display_errors('', '');
            if (!$this->upload->do_upload('userfile')) {
                $error = $this->upload->display_errors();
            } else {
                $data = $this->upload->data();
                $filename = $data['file_name'];
                $filesize = $data['file_size'];
                if ($set_jenis == "temuan") {
                    $msg = $filename . "#" . $filesize . "#" . $attach_as . "#" . $periksa;
                } else if ($set_jenis == "perbaikan") {
                    $msg = $filename . "#" . $filesize . "#" . $periksa;
                }
            }
            echo "{";
            echo "error: '" . $error . "',\n";
            echo "msg: '" . $msg . "'\n";
            echo "}";
            if ($isajax != "ajax") {
                $this->fungsi->redirectMessage('Maaf anda tidak bisa mengakses halaman ini.', '/home');
            }
        }
    }

    function set_lcp($kode = "", $allowed = "") {
        ini_set('upload_max_filesize', '10M');
        $allowed = str_replace("-", "|", $allowed);
        $error = "";
        $msg = "";
        $dir = 'files/LCP/' . $kode;
        if (file_exists($dir) && is_dir($dir)) {
            $config['upload_path'] = "./files/LCP/$kode/";
        } else {
            mkdir("./files/LCP/$kode", 0700);
            $config['upload_path'] = "./files/LCP/$kode/";
        }
        $config['allowed_types'] = $allowed;
        $config['remove_spaces'] = TRUE;
        $ext = pathinfo($_FILES['userfile']['name'], PATHINFO_EXTENSION);
        $config['file_name'] = "LCP_" . date("Ymd") . "_" . date("His") . "_" . str_replace(".", "_", $kode) . "." . $ext;
        $this->load->library('upload', $config);
        $this->upload->display_errors('', '');
        if (!$this->upload->do_upload("userfile")) {
            $error = $this->upload->display_errors();
        } else {
            $data = $this->upload->data();
            $filename = $data['file_name'];
            $filesize = $data['file_size'];
            $msg = $filename . "#" . $filesize . "#" . $kode;
        }
        echo "{";
        echo "error: '" . $error . "',\n";
        echo "msg: '" . $msg . "'\n";
        echo "}";
    }

    function set_relcp($kode = "", $uji = "", $spk = "", $allowed = "") {
        ini_set('upload_max_filesize', '10M');
        $allowed = str_replace("-", "|", $allowed);
        $error = "";
        $msg = "";
        $dir = 'files/LCP/' . $kode;
        if (file_exists($dir) && is_dir($dir)) {
            $config['upload_path'] = "./files/LCP/$kode/";
        } else {
            mkdir("./files/LCP/$kode", 0700);
            $config['upload_path'] = "./files/LCP/$kode/";
        }
        $config['allowed_types'] = $allowed;
        $config['remove_spaces'] = TRUE;
        $ext = pathinfo($_FILES['userfile']['name'], PATHINFO_EXTENSION);
        $config['file_name'] = "LCP_" . date("Ymd") . "_" . date("His") . "_" . str_replace(".", "_", $kode) . "." . $ext;
        $this->load->library('upload', $config);
        $this->upload->display_errors('', '');
        if (!$this->upload->do_upload("userfile")) {
            $error = $this->upload->display_errors();
        } else {
            $data = $this->upload->data();
            $filename = $data['file_name'];
            $filesize = $data['file_size'];
            $msg = $filename . "#" . $filesize . "#" . $kode;
            $res = $this->db->simple_query("UPDATE T_PARAMETER_HASIL_UJI SET LCP = '" . $filename . "' WHERE UJI_ID = '" . $uji . "' AND SPK_ID = '" . $spk . "' AND KODE_SAMPEL = '" . $kode . "'");
        }
        echo "{";
        echo "error: '" . $error . "',\n";
        echo "msg: '" . $msg . "'\n";
        echo "}";
    }

    function set_photosampel($jns = "", $allowed = "") {
        ini_set('upload_max_filesize', '10M');
        $allowed = str_replace("-", "|", $allowed);
        $error = "";
        $msg = "";
        $balai = md5($this->newsession->userdata('SESS_BBPOM_ID'));
        $dir = 'files/sampel/' . $balai;
        if (file_exists($dir) && is_dir($dir)) {
            $config['upload_path'] = "./files/sampel/" . $balai . "/";
        } else {
            mkdir("./files/sampel/" . $balai, 0700);
            $config['upload_path'] = "./files/sampel/" . $balai . "/";
        }
        $config['allowed_types'] = $allowed;
        $config['remove_spaces'] = TRUE;
        $ext = pathinfo($_FILES['userfile']['name'], PATHINFO_EXTENSION);
        $config['file_name'] = $this->newsession->userdata('SESS_BBPOM_ID') . "_" . date("Ymd") . "_" . date("His") . "." . $ext;
        $this->load->library('upload', $config);
        $this->upload->display_errors('', '');
        if (!$this->upload->do_upload("userfile")) {
            $error = $this->upload->display_errors();
        } else {
            $data = $this->upload->data();
            $filename = $data['file_name'];
            $filesize = $data['file_size'];
            $msg = $filename . "#" . $filesize . "#" . $balai . "#" . $jns;
        }
        echo "{";
        echo "error: '" . $error . "',\n";
        echo "msg: '" . $msg . "'\n";
        echo "}";
    }

    function set_capa($kode = "", $allowed = "") {
        ini_set('upload_max_filesize', '10M');
        $allowed = str_replace("-", "|", $allowed);
        $error = "";
        $msg = "";
        $dir = 'files/CAPA/' . $kode;
        if (file_exists($dir) && is_dir($dir)) {
            $config['upload_path'] = "./files/CAPA/$kode/";
        } else {
            mkdir("./files/CAPA/$kode", 0700);
            $config['upload_path'] = "./files/CAPA/$kode/";
        }
        $config['allowed_types'] = $allowed;
        $config['remove_spaces'] = TRUE;
        $ext = pathinfo($_FILES['userfile']['name'], PATHINFO_EXTENSION);
        $config['file_name'] = "CAPA_" . date("Ymd") . "_" . date("His") . "_" . str_replace(".", "_", $kode) . "." . $ext;
        $this->load->library('upload', $config);
        $this->upload->display_errors('', '');
        if (!$this->upload->do_upload("userfile")) {
            $error = $this->upload->display_errors();
        } else {
            $data = $this->upload->data();
            $filename = $data['file_name'];
            $filesize = $data['file_size'];
            $msg = $filename . "#" . $filesize . "#" . $kode;
        }
        echo "{";
        echo "error: '" . $error . "',\n";
        echo "msg: '" . $msg . "'\n";
        echo "}";
    }

}

?>