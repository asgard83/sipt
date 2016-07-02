<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed'); error_reporting(E_ERROR);

class Autocomplete extends Controller {

    function Autocomplete() {
        parent::Controller();
    }

    function index() {
        
    }

    function get_metode_puk($kategori, $parameter_kritis_id, $ketentuan_khusus) {
        if ($this->newsession->userdata('LOGGED_IN') == TRUE && in_array('02', $this->newsession->userdata('SESS_JENIS_PELAPORAN'))) {
            $key = strtolower($_REQUEST['q']);
            $this->load->model('main');
            //$jml = strlen($kategori);
            //if($jml >= 8)
               // $kategori = substr($kategori,0,8);
            
            $data = "SELECT TOP 20 A.SRL_ID, A.BIDANG_UJI, A.GOLONGAN, A.PUSTAKA, A.METODE, A.SYARAT, A.PARAMETER_KRITIS_ID, A.KETENTUAN_KHUSUS FROM M_PRIORITAS A WHERE A.METODE LIKE '%$key%' AND A.GOLONGAN = '".$kategori."' AND A.PARAMETER_KRITIS_ID = '".$parameter_kritis_id."' AND A.KETENTUAN_KHUSUS = '".$ketentuan_khusus."' AND A.KETENTUAN_KHUSUS IS NOT NULL ORDER BY 4 ASC";
            $res = $this->main->get_result($data);
            if ($res) {
                foreach ($data->result_array() as $row) {
                    echo "<b>" . $row['METODE'] . "|" . $row['SRL_ID'] . "|" . $row['BIDANG_UJI'] . "|" . $row['GOLONGAN'] . "|" . $row['PUSTAKA'] . "|" . $row['METODE'] . "|" . $row['SYARAT'] . "|" . $row['PARAMETER_KRITIS_ID'] . "|" . $row['KETENTUAN_KHUSUS'] . "|" . $row['KATEGORI_PU'] . "\n";
                }
            }
        }
    }
    
    function set_surat($nomor = "") {
        if ($this->newsession->userdata('LOGGED_IN') == TRUE) {
            $key = strtolower($_REQUEST['q']);
            $this->load->model('main');
            $data = "SELECT TOP 10 A.SURAT_ID, A.NOMOR, CONVERT(VARCHAR(10), A.TANGGAL, 103) AS [TANGGAL], B.NAMA_BBPOM AS [ASAL BBPOM], C.NAMA_USER AS [PETUGAS] FROM T_SURAT_TUGAS A LEFT JOIN T_SURAT_TUGAS_PETUGAS Z ON A.SURAT_ID = Z.SURAT_ID LEFT JOIN T_USER C ON Z.USER_ID = C.USER_ID LEFT JOIN M_BBPOM B ON C.BBPOM_ID = B.BBPOM_ID WHERE A.NOMOR LIKE '%$key%'";
            $res = $this->main->get_result($data);
            if ($res) {
                foreach ($data->result_array() as $row) {
                    
                }
            }
        }
    }

    function get_surat($nomor) {
        $key = strtolower($_REQUEST['q']);
        $this->load->model('main');
        if ($nomor == "0") {
            $data = "SELECT DISTINCT(A.PERIKSA_SAMPEL) AS PERIKSA_SAMPEL, A.NOMOR_SURAT, CONVERT(VARCHAR(10), A.TANGGAL_SURAT, 103) AS TANGGAL_SURAT, A.NAMA_PENGIRIM, dbo.URAIAN_M_TABEL('ASAL_SAMPLING',B.ASAL_SAMPEL) AS UR_ASAL_SAMPEL, B.ANGGARAN, B.ASAL_SAMPEL, CONVERT(VARCHAR(10), B.TANGGAL_SAMPLING, 103) AS TANGGAL_SAMPLING, B.BULAN_ANGGARAN, A.NAMA_PENGIRIM, A.NIP_PENGIRIM FROM T_PERIKSA_SAMPEL A LEFT JOIN T_M_SAMPEL B ON A.PERIKSA_SAMPEL = B.PERIKSA_SAMPEL WHERE A.BBPOM_ID = '" . $this->newsession->userdata('SESS_BBPOM_ID') . "' AND YEAR(A.TANGGAL_SURAT) = '".date("Y")."' AND B.ASAL_SAMPEL NOT IN ('10','11','12') AND A.NOMOR_SURAT LIKE '%$key%'";
        } else {
            $data = "SELECT DISTINCT(A.PERIKSA_SAMPEL) AS PERIKSA_SAMPEL, A.NOMOR_SURAT, CONVERT(VARCHAR(10), A.TANGGAL_SURAT, 103) AS TANGGAL_SURAT,A.NAMA_PENGIRIM, dbo.URAIAN_M_TABEL('ASAL_SAMPLING',B.ASAL_SAMPEL) AS ASAL_SAMPEL
FROM T_PERIKSA_SAMPEL A LEFT JOIN T_M_SAMPEL B ON A.PERIKSA_SAMPEL = B.PERIKSA_SAMPEL WHERE A.BBPOM_ID = '" . $this->newsession->userdata('SESS_BBPOM_ID') . "' AND YEAR(A.TANGGAL_SURAT) = '".date("Y")."' AND B.ASAL_SAMPEL IN ('10','11','12') AND A.NOMOR_SURAT LIKE '%$key%'";
        }
        $res = $this->main->get_result($data);
        if ($res) {
            foreach ($data->result_array() as $row) {
                if ($nomor == "0") {
                    echo "<b>Nomor Surat : " . $row['NOMOR_SURAT'] . "</b><br>Tanggal Surat : " . $row['TANGGAL_SURAT'] . "<br>Pengirim : " . $row['NAMA_PENGIRIM'] . "<br>" . $row['UR_ASAL_SAMPEL'] . "<br>Tanggal Sampling : " . $row['TANGGAL_SAMPLING'] . "|" . $row['PERIKSA_SAMPEL'] . "|" . $row['NOMOR_SURAT'] . "|" . $row['TANGGAL_SURAT'] . "|" . $row['ANGGARAN'] . "|" . $row['ASAL_SAMPEL'] . "|" . $row['TANGGAL_SAMPLING'] . "|" . $row['BULAN_ANGGARAN'] . "|" . $row['NAMA_PENGIRIM'] . "|" . $row['NIP_PENGIRIM'] . "\n";
                } else {
                    echo "<b>Nomor Surat : " . $row['NOMOR_SURAT'] . "</b><br>Tanggal Surat : " . $row['TANGGAL_SURAT'] . "<br>Pengirim : " . $row['NAMA_PENGIRIM'] . "<br>" . $row['UR_ASAL_SAMPEL'] . "|" . $row['PERIKSA_SAMPEL'] . "|" . $row['NOMOR_SURAT'] . "\n";
                }
            }
        } else {
            echo "Data tidak ditemukan||||\n";
        }
    }

    function petugas_sampling($surat_id) {
        if ($this->newsession->userdata('LOGGED_IN') == TRUE) {
            if ($surat_id == "") {
                $this->index();
                return;
            }
            $data = "SELECT A.USER_ID, A.NAMA_USER FROM T_USER A LEFT JOIN T_PETUGAS_SAMPEL B ON A.USER_ID = B.USER_ID
WHERE B.PERIKSA_SAMPEL = '" . $surat_id . "'";
            $data = $this->db->query($data);
            if ($data) {
                if ($data->num_rows() > 0) {
                    $ret = "";
                    foreach ($data->result_array() as $a => $row) {
                        echo $ret;
                        echo $row['USER_ID'] . '|' . $row['NAMA_USER'];
                        $ret = ';';
                    }
                }
            }
        }
    }

    function produk_reg($klasifikasi, $sarana="") {
        $key = strtolower($_REQUEST['q']);
        $this->load->model('main');
        if ($klasifikasi == "01") {
            $kode = " LEFT(A.CLASS_ID,2) = '01'";
        } else if ($klasifikasi == "10") {
            $kode = " LEFT(A.CLASS_ID,2) = '10'";
        } else if ($klasifikasi == "12") {
            $kode = " LEFT(A.CLASS_ID,2) = '12'";
        } else if ($klasifikasi == "11") {
            $kode = " LEFT(A.CLASS_ID,2) = '11'";
        } else if ($klasifikasi == "13") {
            $kode = " LEFT(A.CLASS_ID,2) = '13'";
        } else {
            $kode = " A.CLASS_ID = '" . $klasifikasi . "'";
        }
        $pendaftar = "";
        if($sarana != ""){
            $pendaftar = " AND LOWER(D.MANUFACTURER_NAME) LIKE '%".strtolower($sarana)."%'";
        }
        $data = "SELECT TOP 25 A.PRODUCT_ID, A.IMPORTER_ID, CONVERT(VARCHAR, A.SUBMIT_DATE, 105) AS SUBMIT_DATE, RTRIM(LTRIM(A.PRODUCT_REGISTER)) AS PRODUCT_REGISTER, CONVERT(VARCHAR, A.PRODUCT_UPDATE, 105) AS PRODUCT_UPDATE, CONVERT(VARCHAR, A.PRODUCT_DATE, 105) AS PRODUCT_DATE, RTRIM(LTRIM(A.PRODUCT_NAME)) AS PRODUCT_NAME, RTRIM(LTRIM(A.PRODUCT_BRANDS)) AS PRODUCT_BRANDS, CONVERT(VARCHAR, A.PRODUCT_EXPIRED, 105) AS PRODUCT_EXPIRED, RTRIM(LTRIM(A.PRODUCT_FORM)) AS PRODUCT_FORM, RTRIM(LTRIM(A.PRODUCT_PACKAGE)) AS PRODUCT_PACKAGE, A.STATUS, A.APPLICATION, A.APPLICATION_ID, B.CLASS, dbo.GetCategory(A.CLASS_ID) AS CATEGORY, B.DEPARTMENT, C.USER_NAME, A.REGISTRAR_ID, D.MANUFACTURER_NAME AS REGISTRAR, E.MANUFACTURER_ID AS MANUFACTURER_ID, E.MANUFACTURER_NAME AS MANUFACTURER, REPLACE(REPLACE(F.MANUFACTURER_NAME,',', ' '),'\n','') AS IMPORTER, D.MANUFACTURER_ADDRESS AS REGISTRAR_ADD, E.MANUFACTURER_ADDRESS AS MANUFACTURER_ADD, F.MANUFACTURER_ADDRESS AS IMPORTER_ADD, dbo.GetLocation(D.MANUFACTURER_DISTRICT_DETAIL, D.MANUFACTURER_PROVINCE_DETAIL, D.MANUFACTURER_COUNTRY_DETAIL, 0) AS REGISTRAR_PROV, dbo.GetLocation(E.MANUFACTURER_DISTRICT_DETAIL, E.MANUFACTURER_PROVINCE_DETAIL, E.MANUFACTURER_COUNTRY_DETAIL, 0) AS MANUFACTURER_PROV, dbo.GetLocation(F.MANUFACTURER_DISTRICT_DETAIL, F.MANUFACTURER_PROVINCE_DETAIL, F.MANUFACTURER_COUNTRY_DETAIL, 0) AS IMPORTER_PROV, dbo.GetIngredients(A.PRODUCT_ID, A.APPLICATION_ID) AS INGREDIENTS, I.FILE_NAME FROM T_PRODUCT A LEFT JOIN M_CLASS B ON B.CLASS_ID = LEFT(A.CLASS_ID, 2) LEFT JOIN T_USER C ON C.USER_ID = A.USER_ID LEFT JOIN T_MANUFACTURER D ON D.MANUFACTURER_ID = A.REGISTRAR_ID AND D.APPLICATION_ID = A.APPLICATION_ID LEFT JOIN T_PRODUCT_MANUFACTURER H ON H.PRODUCT_ID = A.PRODUCT_ID AND H.APPLICATION_ID = A.APPLICATION_ID LEFT JOIN T_MANUFACTURER E ON E.MANUFACTURER_ID = H.MANUFACTURER_ID AND E.APPLICATION_ID = A.APPLICATION_ID LEFT JOIN T_MANUFACTURER F ON F.MANUFACTURER_ID = A.IMPORTER_ID AND F.APPLICATION_ID = A.APPLICATION_ID LEFT JOIN T_PRODUCT_LABEL I ON I.PRODUCT_ID = A.PRODUCT_ID WHERE $kode AND (A.PRODUCT_REGISTER LIKE '%$key%' OR A.PRODUCT_NAME LIKE '%$key%' OR A.PRODUCT_BRANDS LIKE '%$key%') $pendaftar AND A.STATUS = 'Berlaku' ORDER BY A.PRODUCT_NAME ASC";
        $res = $this->main->get_result_webreg($data);
        if ($res) {
            foreach ($data->result_array() as $row) {
                echo "<b>" . $row['PRODUCT_NAME'] . "</b><br>Merk Dagang : " . $row['PRODUCT_BRANDS'] . "<br><b>Bentuk Sediaan</b> : " . $row['PRODUCT_FORM'] . "<br><b>NIE : " . $row['PRODUCT_REGISTER'] . "</b><br>Pendaftar : " . $row['REGISTRAR'] . "<br>Pabrik : " . $row['MANUFACTURER'] . "<br>Importir : " . $row['IMPORTER'] . "|" . $row['PRODUCT_NAME'] . "|" . $row['PRODUCT_REGISTER'] . "|" . $row['REGISTRAR'] . "|" . $row['PRODUCT_PACKAGE'] . "|" . $row['REGISTRAR_ADD'] . ", " . $row['REGISTRAR_PROV'] . "|" . $row['MANUFACTURER'] . "|" . $row['IMPORTER'] . "|" . $row['MANUFACTURER_PROV'] . "|" . $row['PRODUCT_FORM'] . "|" . $row['PRODUCT_ID'] . "|" . $row['APPLICATION_ID'] . "\n";
            }
        }
        echo "Data tidak ditemukan|||||||||||\n";
    }


    function get_komposisi($product, $app) {
        if ($this->newsession->userdata('LOGGED_IN') == TRUE) {
            $this->load->model('main');
            $query = "SELECT dbo.GetIngredients('" . str_replace("-", " ", $product) . "', '" . $app . "') AS KOMPOSISI";
            $data = $this->main->get_result_webreg($query);
            if ($data) {
                foreach ($query->result_array() as $row) {
                    $res = str_replace("<br>", "", str_replace("- ", "|", $row['KOMPOSISI']));
                    $arrdata = explode("|", $res);
                    $arrdata = array_slice($arrdata, 1);
                    $ret = join(";", $arrdata);
                }
            }
            echo trim($ret);
        }
    }

    function ref_produk($klasifikasi = "") {#Get Detil Produk Web Registrasi
        $key = strtolower($_REQUEST['q']);
        $this->load->model('main');
        $kode = " a.kode_klasifikasi = '$klasifikasi' AND ";
        $data = "SELECT TOP 25 a.no_registrasi, a.nama_produk, a.bentuk_sediaan, a.kemasan, a.indikasi,c.namabahan as komposisi,
b.nama_sarana, b.noizin_Sarana, b.alamat, b.alamat1, b.kota, b.kodepos, b.telp, b.fax, b.e_mail, b.propinsi, d.nama_katagori
FROM registrasi a LEFT JOIN sarana b ON a.kode_produsen = b.kode_sarana
LEFT JOIN komposisi c ON a.nomor_permohonan = c.nomorpermohonan AND a.kode_klasifikasi = c.kode_klasifikasi LEFT JOIN master_katagori d ON a.kode_katagori = d.kode_katagori
WHERE $kode a.nomor_permohonan LIKE '%$key%' OR a.nama_produk LIKE '%$key%' OR a.no_registrasi LIKE '%$key%'";
        $res = $this->main->get_result_webreg($data);
        if ($res) {
            foreach ($data->result_array() as $row) {
                echo "<b>" . $row['nama_produk'] . "</b><br>" . $row['no_registrasi'] . "<br>" . $row['nama_sarana'] . "<br>" . $row['alamat'] . "&nbsp;" . $row['alamat1'] . "&nbsp;" . $row['kota'] . "-" . $row['kodepos'] . "|" . $row['nama_produk'] . "|" . $row['no_registrasi'] . "|" . $row['bentuk_sediaan'] . "|" . $row['kemasan'] . "|" . $row['indikasi'] . "|" . $row['komposisi'] . "|" . $row['nama_sarana'] . "|" . $row['noizin_Sarana'] . "|" . $row['alamat'] . "|" . $row['alamat1'] . "|" . $row['kota'] . "|" . $row['kodepos'] . "|" . $row['telp'] . "|" . $row['fax'] . "|" . $row['e_mail'] . "|" . $row['propinsi'] . "|" . $row['nama_katagori'] . "\n";
            }
        }
        echo "Data tidak ditemukan|||||||||||||||||\n";
    }

    function negara() {
        if ($this->newsession->userdata('LOGGED_IN') == TRUE) {
            $key = strtolower($_REQUEST['q']);
            $this->load->model('main');
            $data = "SELECT TOP 10 * FROM M_NEGARA WHERE KODE_NEGARA LIKE '%$key%' OR URAIAN_NEGARA LIKE '%$key%'";
            $res = $this->main->get_result($data);
            if ($res) {
                foreach ($data->result_array() as $row) {
                    echo "<b>" . ucwords($row['URAIAN_NEGARA']) . "</b><br>" . $row['KODE_NEGARA'] . "|" . $row['KODE_NEGARA'] . "|" . $row['URAIAN_NEGARA'] . "\n";
                }
            }
        }
    }

    function get_sarana($nama = "") {#Cek Data Sarana
        if ($this->newsession->userdata('LOGGED_IN') == TRUE) {
            $this->load->model('main');
            $nama = str_replace("-", ", ", $nama);
            $nama = str_replace("_", " ", $nama);
            $jml = (int) $this->main->get_uraian("SELECT COUNT(*) AS JML FROM M_SARANA WHERE NAMA_SARANA = '" . $nama . "'", "JML");
            if ($jml == 0) {
                $tabel = "Tersedia";
            } else {
                $query = "SELECT B.NAMA_JENIS_SARANA AS [JENIS SARANA], A.NAMA_SARANA AS [NAMA SARANA], A.ALAMAT_1 AS ALAMAT FROM M_SARANA A LEFT JOIN M_JENIS_SARANA B ON A.JENIS_SARANA = B.JENIS_SARANA_ID WHERE A.NAMA_SARANA LIKE '%$nama%'";
                $this->load->library('newtable');
                $this->newtable->search(array(array('', '')));
                $this->newtable->action(site_url());
                $this->newtable->cidb($this->db);
                $this->newtable->ciuri($this->uri->segment_array());
                $this->newtable->orderby("NAMA_SARANA");
                $this->newtable->keys("NAMA_SARANA");
                $this->newtable->rowcount("ALL");
                $this->newtable->show_chk(FALSE);
                $this->newtable->show_search(FALSE);
                $tabel = "<div style=\"padding-top:5px; padding-bottom:5px; color:#3c7faf; margin-left:5px;\">Nama sarana yang mengandung kata : <b>" . $nama . "</b></div>";
                $tabel .= $this->newtable->generate($query);
            }
            echo $tabel;
        }
    }

    function sarana() {#Get Master Sarana
        if ($this->newsession->userdata('LOGGED_IN') == TRUE) {
            $key = strtolower($_REQUEST['q']);
            $this->load->model('main');
            $sarana = "'" . join("','", $this->newsession->userdata('SESS_SARANA')) . "'";
            if (!in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) {
                if ($this->newsession->userdata('SESS_PROP_ID') == '7100') {
                    $prop = "'7100','8200'";
                } else if ($this->newsession->userdata('SESS_PROP_ID') == '7300') {
                    $prop = "'7300','7600'";
                } else {
                    $prop = $this->newsession->userdata('SESS_PROP_ID');
                }

                if ($this->newsession->userdata('SESS_BBPOM_ID') == '50' || $this->newsession->userdata('SESS_BBPOM_ID') == '51') {
                    $data = "SELECT TOP 20 A.SARANA_ID, UPPER(REPLACE(REPLACE(A.NAMA_SARANA,',', ' '),'\n','')) AS NAMA_SARANA, REPLACE(REPLACE(A.ALAMAT_1,',', ' '),'\n','') AS ALAMAT, B.NAMA_JENIS_SARANA AS URAIAN_JENIS, C.NAMA_PROPINSI AS PROP, D.NAMA_PROPINSI AS KOTA FROM M_SARANA A LEFT JOIN M_JENIS_SARANA B ON A.JENIS_SARANA = B.JENIS_SARANA_ID LEFT JOIN M_PROPINSI C ON A.PROPINSI = C.PROPINSI_ID LEFT JOIN M_PROPINSI D ON A.KOTA = D.PROPINSI_ID WHERE A.SARANA_ID LIKE '%$key%' OR A.NAMA_SARANA LIKE '%$key%' AND A.FLAG = '0'";
                } else {
                    $data = "SELECT TOP 20 A.SARANA_ID, UPPER(REPLACE(REPLACE(A.NAMA_SARANA,',', ' '),'\n','')) AS NAMA_SARANA, REPLACE(REPLACE(A.ALAMAT_1,',', ' '),'\n','') AS ALAMAT, B.NAMA_JENIS_SARANA AS URAIAN_JENIS, C.NAMA_PROPINSI AS PROP, D.NAMA_PROPINSI AS KOTA FROM M_SARANA A LEFT JOIN M_JENIS_SARANA B ON A.JENIS_SARANA = B.JENIS_SARANA_ID LEFT JOIN M_PROPINSI C ON A.PROPINSI = C.PROPINSI_ID LEFT JOIN M_PROPINSI D ON A.KOTA = D.PROPINSI_ID WHERE A.SARANA_ID LIKE '%$key%' OR A.NAMA_SARANA LIKE '%$key%' AND A.PROPINSI IN($prop) AND A.FLAG = '0'";
                }
            } else {
                if ($this->newsession->userdata('SESS_BBPOM_ID') == "93") {
                    $sarana .= "'01OO','02MM','02LL','03AA'";
                }
                $data = "SELECT TOP 20 A.SARANA_ID, UPPER(REPLACE(REPLACE(A.NAMA_SARANA,',', ' '),'\n','')) AS NAMA_SARANA, REPLACE(REPLACE(A.ALAMAT_1,',', ' '),'\n','') AS ALAMAT, B.NAMA_JENIS_SARANA AS URAIAN_JENIS, C.NAMA_PROPINSI AS PROP, D.NAMA_PROPINSI AS KOTA FROM M_SARANA A LEFT JOIN M_JENIS_SARANA B ON A.JENIS_SARANA = B.JENIS_SARANA_ID LEFT JOIN M_PROPINSI C ON A.PROPINSI = C.PROPINSI_ID LEFT JOIN M_PROPINSI D ON A.KOTA = D.PROPINSI_ID WHERE A.SARANA_ID LIKE '%$key%' OR A.NAMA_SARANA LIKE '%$key%' AND A.JENIS_SARANA IN (" . $sarana . ") AND A.FLAG = '0'";
            }
            $res = $this->main->get_result($data);
            if ($res) {
                foreach ($data->result_array() as $row) {
                    echo "<b>" . $row['NAMA_SARANA'] . "</b><br>" . $row['ALAMAT'] . "<br>" . $row['KOTA'] . " - " . $row['PROP'] . "<br>Jenis Sarana : " . $row['URAIAN_JENIS'] . "|" . strtoupper($row['SARANA_ID']) . "|" . strtoupper($row['NAMA_SARANA']) . "|" . $row['ALAMAT'] . "\n";
                }
            }
            echo "<a href=\"#\" url=\"" . site_url() . "/home/master/sarana/new\" class=\"newsarana_\" onclick=\"sarana_baru($(this).attr('url')); return false;\" title=\"Form Tambah Sarana Baru\">Masukkan Data Baru<br/>Jika Belum Ada Pada Daftar Di Atas</a>|||\n";
        }
    }

    function jenis_pelanggaran($jenis = "", $klasifikasi = "") {
        if ($this->newsession->userdata('LOGGED_IN') == TRUE) {
            if ($klasifikasi == "") {
                $this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.', '/home');
            }
            $key = strtolower($_REQUEST['q']);
            $this->load->model('main');
            $klasifikasi = explode("-", $klasifikasi);
            $klasifikasi = join(",", $klasifikasi);
            $data = "SELECT A.SERI, A.JENIS_PELANGGARAN, A.JENIS_PENYIMPANGAN, A.JENIS_KRITERIA_PELANGGARAN AS TINGKAT_KRITIS, B.KK_ID, CASE B.KK_ID WHEN '005' THEN 'Narktotika' WHEN '006' THEN 'Psikotropika' WHEN '009' THEN 'Prekursor' END AS [KLASIFIKASI PELANGGARAN] FROM M_PELANGGARAN A LEFT JOIN M_PELANGGARAN_KLASIFIKASI B ON A.ASPEK = B.ASPEK AND A.SERI = B.SERI WHERE A.JENIS_SARANA = '$jenis' AND A.JENIS_PELANGGARAN LIKE '%$key%' AND B.KK_ID IN ($klasifikasi)";
            $res = $this->main->get_result($data);
            if ($res) {
                foreach ($data->result_array() as $row) {
                    echo "<b>" . $row['JENIS_PELANGGARAN'] . "</b><br>" . $row['KLASIFIKASI PELANGGARAN'] . "&nbsp;(" . $row['TINGKAT_KRITIS'] . ")" . "|" . $row['JENIS_PELANGGARAN'] . "|" . $row['KLASIFIKASI PELANGGARAN'] . "|" . $row['TINGKAT_KRITIS'] . "|" . $row['JENIS_PENYIMPANGAN'] . "|" . $row['KK_ID'] . "|" . $row['KLASIFIKASI PELANGGARAN'] . "\n";
                }
            }
        }
    }

    function jenis_pangan() {
        if ($this->newsession->userdata('LOGGED_IN') == TRUE) {
            $key = strtolower($_REQUEST['q']);
            $this->load->model('main');
            $data = "SELECT TOP 10 * FROM M_JENIS_PANGAN WHERE JENIS_PANGAN LIKE '%$key%' OR NAMA LIKE '%$key%'";
            $res = $this->main->get_result($data);
            if ($res) {
                foreach ($data->result_array() as $row) {
                    echo "<b>" . ucwords(strtolower($row['NAMA'])) . "</b><br>" . $row['JENIS_PANGAN'] . "|" . $row['JENIS_PANGAN'] . "|" . ucwords(strtolower($row['NAMA'])) . "\n";
                }
            }
        }
    }

    function set_jenis_pangan($id) {
        if ($this->newsession->userdata('LOGGED_IN') == TRUE) {
          $sipt = & get_instance();
          $this->load->model("main", "main", true);
          $query = "SELECT (LTRIM(RTRIM(KODE))) AS KODE, dbo.FIRST_CAPITAL(JENIS_PANGAN) AS JENIS_PANGAN FROM M_JENIS_PANGAN_NEW WHERE KODE LIKE '" . $id . "%__' AND LEN(KODE) = '4' ORDER BY JENIS_PANGAN ASC";
          $res = $sipt->main->get_result($query);
          $hasil = "";
          if ($res) {
            $hasil .= '<option value="">&nbsp;</option>';
            foreach ($query->result_array() as $row) {
              $hasil .= '<option value="' . $row['KODE'] . '">' . str_replace("\n", "", $row['JENIS_PANGAN']) . '</option>';
            }
          }
          echo $hasil;
        }
      }


    function bahan_tambahan() {
        if ($this->newsession->userdata('LOGGED_IN') == TRUE) {
            $key = strtolower($_REQUEST['q']);
            $this->load->model('main');
            $data = "SELECT TOP 10 * FROM M_JENIS_PANGAN WHERE JENIS_PANGAN LIKE '%$key%' OR NAMA LIKE '%$key%' AND KETERANGAN='BTP'";
            $res = $this->main->get_result($data);
            if ($res) {
                foreach ($data->result_array() as $row) {
                    echo ucwords(strtolower($row['NAMA'])) . "\n";
                }
            }
        }
    }

    function operator($bbpomid = "", $pejabat = "") {#Get Petugas Pemeriksa
        if ($this->newsession->userdata('LOGGED_IN') == TRUE) {
            $key = strtolower($_REQUEST['q']);
            $this->load->model('main');
            $sarana = "'" . join("','", $this->newsession->userdata('SESS_SARANA')) . "'";
            $isgabungan = FALSE;
            /* if($bbpomid=="" && (!array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')))){
              echo "Pilih Balai Besar / Balai POM Terlebih dahulu";
              } */
            if (array_key_exists('9', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('2', $this->newsession->userdata('SESS_KODE_ROLE'))) {
                $bbpomid = $this->newsession->userdata('SESS_BBPOM_ID');
                if($pejabat=='13'){
                    $bbpomid = '94';
                }
            }//echo $pejabat; die(); 
            if (in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) {
                $isgabungan = TRUE;
                $data = "SELECT TOP 20 A.USER_ID, A.NAMA_USER, A.JABATAN, B.NAMA_BBPOM FROM T_USER A LEFT JOIN M_BBPOM B ON A.BBPOM_ID = B.BBPOM_ID WHERE A.NAMA_USER LIKE '%$key%' AND A.USER_ID IN (SELECT DISTINCT USER_ID FROM T_USER_ROLE WHERE SARANA_MEDIA_ID IN (" . $sarana . ")) AND A.STATUS = 'Aktif' ORDER BY 2 ASC";
            } else {
                if (array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE'))) {
                    $data = "SELECT TOP 20 USER_ID, NAMA_USER, JABATAN FROM T_USER WHERE NAMA_USER LIKE '%$key%' AND STATUS = 'Aktif' ORDER BY 2 ASC";
                } else {
                    $data = "SELECT TOP 20 USER_ID, NAMA_USER, JABATAN FROM T_USER WHERE NAMA_USER LIKE '%$key%' AND BBPOM_ID = '" . $bbpomid . "' AND STATUS = 'Aktif' ORDER BY 2 ASC";
                }
            }//echo $data; die();
            $res = $this->main->get_result($data);
            if ($res) {
                foreach ($data->result_array() as $row) {
                    if ($isgabungan)
                        echo "<b>" . $row['NAMA_USER'] . "</b><br>NIP : " . $row['USER_ID'] . "<br>Jabatan : " . $row['JABATAN'] . "<br>" . $row['NAMA_BBPOM'] . "|" . $row['USER_ID'] . "|" . $row['NAMA_USER'] . "\n";
                    else
                        echo "<b>" . $row['NAMA_USER'] . "</b><br>NIP : " . $row['USER_ID'] . "<br>Jabatan : " . $row['JABATAN'] . "|" . $row['USER_ID'] . "|" . $row['NAMA_USER'] . "\n";
                }
            }
        }
    }

    function bbpomid() {#Get BBPOM Pemeriksaan Sarana
        if ($this->newsession->userdata('LOGGED_IN') == TRUE) {
            $key = strtolower($_REQUEST['q']);
            $this->load->model('main');
            $data = "SELECT TOP 10 * FROM M_BBPOM WHERE BBPOM_ID LIKE '%$key%' OR NAMA_BBPOM LIKE '%$key%' OR KOTA LIKE '%$key%'";
            $res = $this->main->get_result($data);
            if ($res) {
                foreach ($data->result_array() as $row) {
                    echo "<b>" . $row['NAMA_BBPOM'] . "</b><br>" . $row['KOTA'] . "|" . $row['BBPOM_ID'] . "|" . $row['NAMA_BBPOM'] . "\n";
                }
            }
        }
    }

    function set_kota($propinsi = "") {#Get Kota Master Sarana
        $this->load->model('main');
        $propinsi = substr($propinsi, 0, 2);
        $query = "SELECT PROPINSI_ID, NAMA_PROPINSI FROM M_PROPINSI WHERE PROPINSI_ID LIKE '" . $propinsi . "%' AND RIGHT(PROPINSI_ID, 2) <> '00'";
        $data = $this->main->get_result($query);
        echo '<option value="">&nbsp;</option>';
        if ($data) {
            foreach ($query->result_array() as $row) {
                echo '<option value="' . $row['PROPINSI_ID'] . '">' . $row['NAMA_PROPINSI'] . '</option>';
            }
        }
    }

    function get_carisarana() {
        if ($this->newsession->userdata('LOGGED_IN') == TRUE) {
            $key = strtolower($_REQUEST['q']);
            $this->load->model('main');
            $sarana = "'" . join("','", $this->newsession->userdata('SESS_SARANA')) . "'";
            if (!in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) {
                if ($this->newsession->userdata('SESS_PROP_ID') == '7100') {
                    $prop = "AND A.PROPINSI IN('7100','8200')";
                } else if ($this->newsession->userdata('SESS_PROP_ID') == '7300') {
                    $prop = "AND A.PROPINSI IN('7300','7600')";
                } else if ($this->newsession->userdata('SESS_PROP_ID') == '0000') {
                    $prop = "";
                } else {
                    $prop = "AND A.PROPINSI IN('" . $this->newsession->userdata('SESS_PROP_ID') . "')";
                }
                $data = "SELECT TOP 20 REPLACE(REPLACE(A.NAMA_SARANA,'\n',''),'-','') AS NAMA_SARANA FROM M_SARANA A LEFT JOIN T_PEMERIKSAAN B ON A.SARANA_ID = B.SARANA_ID LEFT JOIN M_PROPINSI C ON A.PROPINSI = C.PROPINSI_ID LEFT JOIN M_PROPINSI D ON A.KOTA = D.PROPINSI_ID WHERE A.NAMA_SARANA LIKE '%$key%' $prop AND A.FLAG = '0'";
            } else {
                if ($this->newsession->userdata('SESS_BBPOM_ID') == "93") {
                    $sarana .= "'01OO','02MM','02LL','03AA'";
                }
                $data = "SELECT TOP 20 REPLACE(REPLACE(A.NAMA_SARANA,'\n',''),'-','') AS NAMA_SARANA FROM M_SARANA A LEFT JOIN T_PEMERIKSAAN B ON A.JENIS_SARANA = B.JENIS_SARANA_ID LEFT JOIN M_PROPINSI C ON A.PROPINSI = C.PROPINSI_ID LEFT JOIN M_PROPINSI D ON A.KOTA = D.PROPINSI_ID WHERE A.NAMA_SARANA LIKE '%$key%' AND A.JENIS_SARANA IN (" . $sarana . ") AND A.FLAG = '0'";
            }
            $res = $this->main->get_result($data);
            if ($res) {
                foreach ($data->result_array() as $row) {
                    echo "<b>" . $row['NAMA_SARANA'] . "</b>" . "|" . $row['NAMA_SARANA'] . "\n";
                }
            }
        }
    }

  function get_kategori($kategori_id = "", $prioritas = "", $tujuan = "", $sub = "") {
    if ($this->newsession->userdata('LOGGED_IN') == TRUE) {
      $sipt = & get_instance();
      $this->load->model("main", "main", true);
      $panjang = strlen(trim($kategori_id));
      if($prioritas == "0"){
          if ($panjang == "2") {
                if ($kategori_id == "01" && $tujuan != "") {
                    if ($tujuan == "01") {
                        $query = "SELECT (LTRIM(RTRIM(KLASIFIKASI_ID))) AS KLASIFIKASI_ID, LTRIM(RTRIM(KLASIFIKASI)) AS KLASIFIKASI FROM M_GOLONGAN WHERE KLASIFIKASI_ID LIKE '" . $kategori_id . "%__' AND LEN(KLASIFIKASI_ID) = '4' AND KLASIFIKASI_ID NOT IN ('0107') ORDER BY KLASIFIKASI ASC";
                    } else if ($tujuan == "02") {
                        $query = "SELECT (LTRIM(RTRIM(KLASIFIKASI_ID))) AS KLASIFIKASI_ID, LTRIM(RTRIM(KLASIFIKASI)) AS KLASIFIKASI FROM M_GOLONGAN WHERE KLASIFIKASI_ID LIKE '" . $kategori_id . "%_7' AND LEN(KLASIFIKASI_ID) = '4' ORDER BY KLASIFIKASI ASC";
                    }
                } else if ($kategori_id == "05" || $kategori_id == "06") {
                    $query = "SELECT (LTRIM(RTRIM(KLASIFIKASI_ID))) AS KLASIFIKASI_ID, LTRIM(RTRIM(KLASIFIKASI)) AS KLASIFIKASI FROM M_GOLONGAN WHERE KLASIFIKASI_ID LIKE '20%__' AND LEN(KLASIFIKASI_ID) = '4' ORDER BY KLASIFIKASI ASC";
                } else if ($kategori_id == "10") {
                    $query = "SELECT (LTRIM(RTRIM(KLASIFIKASI_ID))) AS KLASIFIKASI_ID, LTRIM(RTRIM(KLASIFIKASI)) AS KLASIFIKASI FROM M_GOLONGAN WHERE KLASIFIKASI_ID LIKE '" . $kategori_id . "%__' AND LEN(KLASIFIKASI_ID) = '4' ORDER BY KLASIFIKASI ASC";                                    
                } else if ($kategori_id == "11") {
                    $query = "SELECT (LTRIM(RTRIM(KLASIFIKASI_ID))) AS KLASIFIKASI_ID, LTRIM(RTRIM(KLASIFIKASI)) AS KLASIFIKASI FROM M_GOLONGAN WHERE KLASIFIKASI_ID LIKE '" . $kategori_id . "%__' AND LEN(KLASIFIKASI_ID) = '4' ORDER BY KLASIFIKASI ASC";                    
                } else if ($kategori_id == "12") {
                    $query = "SELECT (LTRIM(RTRIM(KLASIFIKASI_ID))) AS KLASIFIKASI_ID, LTRIM(RTRIM(KLASIFIKASI)) AS KLASIFIKASI FROM M_GOLONGAN WHERE KLASIFIKASI_ID LIKE '" . $kategori_id . "%__' AND LEN(KLASIFIKASI_ID) = '4' ORDER BY KLASIFIKASI ASC";                    
                } else if ($kategori_id == "13") {
                    $query = "SELECT (LTRIM(RTRIM(KLASIFIKASI_ID))) AS KLASIFIKASI_ID, LTRIM(RTRIM(KLASIFIKASI)) AS KLASIFIKASI FROM M_GOLONGAN WHERE KLASIFIKASI_ID LIKE '" . $kategori_id . "%__' AND LEN(KLASIFIKASI_ID) = '4' ORDER BY KLASIFIKASI ASC";
                } else {
                    $query = "SELECT (LTRIM(RTRIM(KLASIFIKASI_ID))) AS KLASIFIKASI_ID, LTRIM(RTRIM(KLASIFIKASI)) AS KLASIFIKASI FROM M_GOLONGAN WHERE KLASIFIKASI_ID LIKE '" . $kategori_id . "%__' AND LEN(KLASIFIKASI_ID) = '4' ORDER BY KLASIFIKASI ASC";
                }
            } else if ($panjang == "4") {
                if ($kategori_id == "0105" || $kategori_id == "0108" || $kategori_id == "0110")
                    $query = "SELECT (LTRIM(RTRIM(KLASIFIKASI_ID))) AS KLASIFIKASI_ID, dbo.GOLONGAN_SAMPEL(SUBSTRING(KLASIFIKASI_ID,1,4)) + ' - '+ KLASIFIKASI AS KLASIFIKASI FROM M_GOLONGAN WHERE KLASIFIKASI_ID LIKE '0101__' OR KLASIFIKASI_ID LIKE '0102__' OR KLASIFIKASI_ID LIKE '0103__' OR KLASIFIKASI_ID  LIKE '0105__' OR KLASIFIKASI_ID  LIKE '0108__' AND LEN(KLASIFIKASI_ID) = '6' ORDER BY KLASIFIKASI ASC";
                else
                    $query = "SELECT (LTRIM(RTRIM(KLASIFIKASI_ID))) AS KLASIFIKASI_ID, LTRIM(RTRIM(KLASIFIKASI)) AS KLASIFIKASI FROM M_GOLONGAN WHERE KLASIFIKASI_ID LIKE '" . $kategori_id . "%__' AND LEN(KLASIFIKASI_ID) = '6' ORDER BY KLASIFIKASI ASC";
            }else if ($panjang == "6") {
                $query = "SELECT (LTRIM(RTRIM(KLASIFIKASI_ID))) AS KLASIFIKASI_ID, LTRIM(RTRIM(KLASIFIKASI)) AS KLASIFIKASI FROM M_GOLONGAN WHERE KLASIFIKASI_ID LIKE '" . $kategori_id . "%__' AND LEN(KLASIFIKASI_ID) = '8' ORDER BY KLASIFIKASI ASC";
            } else if ($panjang == "8") {
                $query = "SELECT (LTRIM(RTRIM(KLASIFIKASI_ID))) AS KLASIFIKASI_ID, LTRIM(RTRIM(KLASIFIKASI)) AS KLASIFIKASI FROM M_GOLONGAN WHERE KLASIFIKASI_ID LIKE '" . $kategori_id . "%__' AND LEN(KLASIFIKASI_ID) = '10' ORDER BY KLASIFIKASI ASC";
            } else {
                die();
            }
      }else if($prioritas == "1"){
          if($panjang == 2){
              if ($kategori_id == "05" || $kategori_id == "06"){
                  $query = "SELECT (LTRIM(RTRIM(KLASIFIKASI_ID))) AS KLASIFIKASI_ID, LTRIM(RTRIM(KLASIFIKASI)) AS KLASIFIKASI FROM M_GOLONGAN_NEW WHERE KLASIFIKASI_ID LIKE '20%__' AND LEN(KLASIFIKASI_ID) = '4' AND KLASIFIKASI <> '' AND STATUS = '1' ORDER BY KLASIFIKASI ASC";
              }else if($kategori_id == "10") {#1001, 1004, 1005, 1007, 1008
                if($tujuan == "01"){
                    if($sub == "100112")
                    {
                        $query = "SELECT (LTRIM(RTRIM(KLASIFIKASI_ID))) AS KLASIFIKASI_ID, LTRIM(RTRIM(KLASIFIKASI)) AS KLASIFIKASI FROM M_GOLONGAN_NEW WHERE KLASIFIKASI_ID IN ('1004') AND LEN(KLASIFIKASI_ID) = '4' AND KLASIFIKASI <> '' AND STATUS = '1' ORDER BY KLASIFIKASI ASC";
                    }
                    else if($sub == "100117")
                    {
                        $query = "SELECT (LTRIM(RTRIM(KLASIFIKASI_ID))) AS KLASIFIKASI_ID, LTRIM(RTRIM(KLASIFIKASI)) AS KLASIFIKASI FROM M_GOLONGAN_NEW WHERE KLASIFIKASI_ID IN ('1005','1006','1007') AND LEN(KLASIFIKASI_ID) = '4' AND KLASIFIKASI <> '' AND STATUS = '1' ORDER BY KLASIFIKASI ASC";   
                    }
                    else
                    {
                        $query = "SELECT (LTRIM(RTRIM(KLASIFIKASI_ID))) AS KLASIFIKASI_ID, LTRIM(RTRIM(KLASIFIKASI)) AS KLASIFIKASI FROM M_GOLONGAN_NEW WHERE KLASIFIKASI_ID NOT IN ('1004','1005','1006','1007') AND LEN(KLASIFIKASI_ID) = '4' AND KLASIFIKASI <> '' AND KLASIFIKASI_PARENT='10' AND STATUS = '1' ORDER BY KLASIFIKASI ASC";   

                    }
                }else{
                    $query = "SELECT (LTRIM(RTRIM(KLASIFIKASI_ID))) AS KLASIFIKASI_ID, LTRIM(RTRIM(KLASIFIKASI)) AS KLASIFIKASI FROM M_GOLONGAN_NEW WHERE KLASIFIKASI_ID LIKE '" . $kategori_id . "%__' AND LEN(KLASIFIKASI_ID) = '4'  AND KLASIFIKASI <> '' AND STATUS = '1' ORDER BY KLASIFIKASI ASC";
                }
            }else if($kategori_id == "12"){
                # Surveilance = 02, Compliance = 01;
                if($tujuan == "01"){
                    if($sub =="120102"){
                        $query = "SELECT (LTRIM(RTRIM(KLASIFIKASI_ID))) AS KLASIFIKASI_ID, LTRIM(RTRIM(KLASIFIKASI)) AS KLASIFIKASI FROM M_GOLONGAN_NEW WHERE LEFT(KLASIFIKASI_ID,2) = '12' AND LEN(KLASIFIKASI_ID) = 4 AND KLASIFIKASI_ID IN ('1203','1204','1210','1213') AND STATUS = '1' ORDER BY KLASIFIKASI ASC";
                    }else if($sub =="120108"){
                        $query = "SELECT (LTRIM(RTRIM(KLASIFIKASI_ID))) AS KLASIFIKASI_ID, LTRIM(RTRIM(KLASIFIKASI)) AS KLASIFIKASI FROM M_GOLONGAN_NEW WHERE LEFT(KLASIFIKASI_ID,2) = '12' AND LEN(KLASIFIKASI_ID) = 4 AND KLASIFIKASI_ID IN ('1202','1205','1206','1210') AND STATUS = '1' ORDER BY KLASIFIKASI ASC";
                    }else if($sub =="120109"){
                        $query = "SELECT (LTRIM(RTRIM(KLASIFIKASI_ID))) AS KLASIFIKASI_ID, LTRIM(RTRIM(KLASIFIKASI)) AS KLASIFIKASI FROM M_GOLONGAN_NEW WHERE LEFT(KLASIFIKASI_ID,2) = '12' AND LEN(KLASIFIKASI_ID) = 4 AND KLASIFIKASI_ID IN ('1202','1205','1206','1210') AND STATUS = '1' ORDER BY KLASIFIKASI ASC";
                    }
                }else if($tujuan == "02"){
                    if($sub == "120201"){
                        $query = "SELECT (LTRIM(RTRIM(KLASIFIKASI_ID))) AS KLASIFIKASI_ID, LTRIM(RTRIM(KLASIFIKASI)) AS KLASIFIKASI FROM M_GOLONGAN_NEW WHERE LEFT(KLASIFIKASI_ID,2) = '12' AND LEN(KLASIFIKASI_ID) = 4 AND KLASIFIKASI_ID IN ('1201','1208','1209','1210','1212') AND STATUS = '1' ORDER BY KLASIFIKASI ASC";
                    }else if($sub == "120202"){
                        $query = "SELECT (LTRIM(RTRIM(KLASIFIKASI_ID))) AS KLASIFIKASI_ID, LTRIM(RTRIM(KLASIFIKASI)) AS KLASIFIKASI FROM M_GOLONGAN_NEW WHERE LEFT(KLASIFIKASI_ID,2) = '12' AND LEN(KLASIFIKASI_ID) = 4 AND KLASIFIKASI_ID IN ('1208','1209','1210') AND STATUS = '1' ORDER BY KLASIFIKASI ASC";
                    }else if($sub == "120203"){
                        $query = "SELECT (LTRIM(RTRIM(KLASIFIKASI_ID))) AS KLASIFIKASI_ID, LTRIM(RTRIM(KLASIFIKASI)) AS KLASIFIKASI FROM M_GOLONGAN_NEW WHERE LEFT(KLASIFIKASI_ID,2) = '12' AND LEN(KLASIFIKASI_ID) = 4 AND KLASIFIKASI_ID IN ('1202','1209','1210','1212') AND STATUS = '1' ORDER BY KLASIFIKASI ASC";
                    }else if($sub == "120204"){
                        $query = "SELECT (LTRIM(RTRIM(KLASIFIKASI_ID))) AS KLASIFIKASI_ID, LTRIM(RTRIM(KLASIFIKASI)) AS KLASIFIKASI FROM M_GOLONGAN_NEW WHERE LEFT(KLASIFIKASI_ID,2) = '12' AND LEN(KLASIFIKASI_ID) = 4 AND KLASIFIKASI_ID IN ('1208','1209','1210','1213') AND STATUS = '1' ORDER BY KLASIFIKASI ASC";
                    }else if($sub == "120205"){
                        $query = "SELECT (LTRIM(RTRIM(KLASIFIKASI_ID))) AS KLASIFIKASI_ID, LTRIM(RTRIM(KLASIFIKASI)) AS KLASIFIKASI FROM M_GOLONGAN_NEW WHERE LEFT(KLASIFIKASI_ID,2) = '12' AND LEN(KLASIFIKASI_ID) = 4 AND KLASIFIKASI_ID IN ('1207','1210','1211') AND STATUS = '1' ORDER BY KLASIFIKASI ASC";
                    }else if($sub == "120206"){
                        $query = "SELECT (LTRIM(RTRIM(KLASIFIKASI_ID))) AS KLASIFIKASI_ID, LTRIM(RTRIM(KLASIFIKASI)) AS KLASIFIKASI FROM M_GOLONGAN_NEW WHERE LEFT(KLASIFIKASI_ID,2) = '12' AND LEN(KLASIFIKASI_ID) = 4 AND KLASIFIKASI_ID IN ('1207','1208','1209','1210') AND STATUS = '1' ORDER BY KLASIFIKASI ASC";
                    }else if($sub == "120207"){
                        $query = "SELECT (LTRIM(RTRIM(KLASIFIKASI_ID))) AS KLASIFIKASI_ID, LTRIM(RTRIM(KLASIFIKASI)) AS KLASIFIKASI FROM M_GOLONGAN_NEW WHERE LEFT(KLASIFIKASI_ID,2) = '12' AND LEN(KLASIFIKASI_ID) = 4 AND KLASIFIKASI_ID IN ('1208','1209','1210') AND STATUS = '1' ORDER BY KLASIFIKASI ASC";
                    }
                }else{
                    $query = "SELECT (LTRIM(RTRIM(KLASIFIKASI_ID))) AS KLASIFIKASI_ID, LTRIM(RTRIM(KLASIFIKASI)) AS KLASIFIKASI FROM M_GOLONGAN_NEW WHERE KLASIFIKASI_ID LIKE '" . $kategori_id . "%__' AND LEN(KLASIFIKASI_ID) = '4'  AND KLASIFIKASI <> '' AND STATUS = '1' ORDER BY KLASIFIKASI ASC";
                }
            }else{
                $addsql = '';
                if($kategori_id=='01' and $tujuan=='04')
                    $addsql .= " AND KLASIFIKASI_ID = '0113' ";

                $query = "SELECT (LTRIM(RTRIM(KLASIFIKASI_ID))) AS KLASIFIKASI_ID, LTRIM(RTRIM(KLASIFIKASI)) AS KLASIFIKASI FROM M_GOLONGAN_NEW WHERE KLASIFIKASI_ID LIKE '" . $kategori_id . "%__' AND LEN(KLASIFIKASI_ID) = '4'  AND KLASIFIKASI <> '' AND STATUS = '1' ".$addsql." ORDER BY KLASIFIKASI ASC";
            }
          }else if($panjang == 4){
            if($kategori_id == "0101" || $kategori_id == "0105")
                $query = "SELECT (LTRIM(RTRIM(KLASIFIKASI_ID))) AS KLASIFIKASI_ID, LTRIM(RTRIM(KLASIFIKASI)) AS KLASIFIKASI FROM M_GOLONGAN_NEW 
    WHERE KLASIFIKASI_PARENT = '".$kategori_id."' AND KLASIFIKASI_ID LIKE '".$kategori_id."%__' OR KLASIFIKASI_ID LIKE '".$kategori_id."%___' AND (LEN(KLASIFIKASI_ID) = '6' OR  LEN(KLASIFIKASI_ID) = '7')  AND KLASIFIKASI <> '' AND STATUS = '1' ORDER BY KLASIFIKASI ASC";
            else  
                $query = "SELECT (LTRIM(RTRIM(KLASIFIKASI_ID))) AS KLASIFIKASI_ID, LTRIM(RTRIM(KLASIFIKASI)) AS KLASIFIKASI FROM M_GOLONGAN_NEW WHERE KLASIFIKASI_ID LIKE '" . $kategori_id . "%__' AND LEN(KLASIFIKASI_ID) = '6' AND KLASIFIKASI <> '' AND STATUS = '1' ORDER BY KLASIFIKASI ASC"; 
          }else if($panjang == 6 || $panjang == 7) {
              if($panjang == 6)
                if($kategori_id=='011001'){
                    // $query = "SELECT (LTRIM(RTRIM(KLASIFIKASI_ID))) AS KLASIFIKASI_ID, LTRIM(RTRIM(KLASIFIKASI)) AS KLASIFIKASI FROM M_GOLONGAN_NEW WHERE KLASIFIKASI_ID LIKE '" . $kategori_id . "%__' AND LEN(KLASIFIKASI_ID) = '8' AND KLASIFIKASI <> '' AND STATUS = '1' AND KLASIFIKASI_ID NOT IN('01100101','01100102') ORDER BY KLASIFIKASI ASC";
                    $query = "SELECT (LTRIM(RTRIM(KLASIFIKASI_ID))) AS KLASIFIKASI_ID, LTRIM(RTRIM(KLASIFIKASI)) AS KLASIFIKASI FROM M_GOLONGAN_NEW WHERE KLASIFIKASI_ID LIKE '" . $kategori_id . "%__' AND LEN(KLASIFIKASI_ID) = '8' AND KLASIFIKASI <> '' AND STATUS = '1'  ORDER BY KLASIFIKASI ASC";
                }else{
                    $query = "SELECT (LTRIM(RTRIM(KLASIFIKASI_ID))) AS KLASIFIKASI_ID, LTRIM(RTRIM(KLASIFIKASI)) AS KLASIFIKASI FROM M_GOLONGAN_NEW WHERE KLASIFIKASI_ID LIKE '" . $kategori_id . "%__' AND LEN(KLASIFIKASI_ID) = '8' AND KLASIFIKASI <> '' AND STATUS = '1' ORDER BY KLASIFIKASI ASC";
                } 
              else if($panjang == 7)
                $query = "SELECT (LTRIM(RTRIM(KLASIFIKASI_ID))) AS KLASIFIKASI_ID, LTRIM(RTRIM(KLASIFIKASI)) AS KLASIFIKASI FROM M_GOLONGAN_NEW WHERE KLASIFIKASI_ID LIKE '" . $kategori_id . "%__' AND LEN(KLASIFIKASI_ID) = '9' AND KLASIFIKASI <> '' AND STATUS = '1' ORDER BY KLASIFIKASI ASC";
          }else if($panjang == 8 || $panjang == 9) {
              if($panjang == 8)
                if($kategori_id=='01100105'){
                    $query = "SELECT (LTRIM(RTRIM(KLASIFIKASI_ID))) AS KLASIFIKASI_ID, LTRIM(RTRIM(KLASIFIKASI)) AS KLASIFIKASI FROM M_GOLONGAN_NEW WHERE KLASIFIKASI_ID LIKE '" . $kategori_id . "%__' AND LEN(KLASIFIKASI_ID) = '10' AND KLASIFIKASI <> '' AND STATUS = '1' AND KLASIFIKASI_ID <> '0110010501' ORDER BY KLASIFIKASI ASC";
                }else{  
                    $query = "SELECT (LTRIM(RTRIM(KLASIFIKASI_ID))) AS KLASIFIKASI_ID, LTRIM(RTRIM(KLASIFIKASI)) AS KLASIFIKASI FROM M_GOLONGAN_NEW WHERE KLASIFIKASI_ID LIKE '" . $kategori_id . "%__' AND LEN(KLASIFIKASI_ID) = '10' AND KLASIFIKASI <> '' AND STATUS = '1' ORDER BY KLASIFIKASI ASC";
                }
              else if($panjang == 9)
                $query = "SELECT (LTRIM(RTRIM(KLASIFIKASI_ID))) AS KLASIFIKASI_ID, LTRIM(RTRIM(KLASIFIKASI)) AS KLASIFIKASI FROM M_GOLONGAN_NEW WHERE KLASIFIKASI_ID LIKE '" . $kategori_id . "%__' AND LEN(KLASIFIKASI_ID) = '11' AND KLASIFIKASI <> '' AND STATUS = '1' ORDER BY KLASIFIKASI ASC";
          }else if($panjang == 10 || $panjang == 11) {
              if($panjang == 10)
                $query = "SELECT (LTRIM(RTRIM(KLASIFIKASI_ID))) AS KLASIFIKASI_ID, LTRIM(RTRIM(KLASIFIKASI)) AS KLASIFIKASI FROM M_GOLONGAN_NEW WHERE KLASIFIKASI_ID LIKE '" . $kategori_id . "%__' AND LEN(KLASIFIKASI_ID) = '12' AND KLASIFIKASI <> '' AND STATUS = '1' ORDER BY KLASIFIKASI ASC";
              else if($panjang == 11)
                $query = "SELECT (LTRIM(RTRIM(KLASIFIKASI_ID))) AS KLASIFIKASI_ID, LTRIM(RTRIM(KLASIFIKASI)) AS KLASIFIKASI FROM M_GOLONGAN_NEW WHERE KLASIFIKASI_ID LIKE '" . $kategori_id . "%__' AND LEN(KLASIFIKASI_ID) = '13' AND KLASIFIKASI <> '' AND STATUS = '1' ORDER BY KLASIFIKASI ASC";
          
          
          }else{
              die();
          }
          
      }
      $res = $sipt->main->get_result($query);
      $hasil = "";
      if($res){
          $hasil .= '<option value="">&nbsp;</option>';
          foreach ($query->result_array() as $row){
              $hasil .= '<option value="' . $row['KLASIFIKASI_ID'] . '">' . str_replace("\n", "", $row['KLASIFIKASI']) . '</option>';
          }
      }
      echo $hasil;
    }
  }

    /* Kategori atau golongan spesifik lokal */

    function get_kategori_spesifik($kategori_id = "") {
        if ($this->newsession->userdata('LOGGED_IN') == TRUE) {
            $sipt = & get_instance();
            $this->load->model("main", "main", true);
            $panjang = strlen(trim($kategori_id));
            if ($panjang == "2") {
                $query = "SELECT (LTRIM(RTRIM(KLASIFIKASI_ID))) AS KLASIFIKASI_ID, KLASIFIKASI FROM M_GOLONGAN_SPESIFIK WHERE KLASIFIKASI_ID LIKE '" . $kategori_id . "%__' AND LEN(KLASIFIKASI_ID) = '4' ORDER BY KLASIFIKASI ASC";
            } else if ($panjang == "4") {
                $query = "SELECT (LTRIM(RTRIM(KLASIFIKASI_ID))) AS KLASIFIKASI_ID, KLASIFIKASI FROM M_GOLONGAN_SPESIFIK WHERE KLASIFIKASI_ID LIKE '" . $kategori_id . "%__' AND LEN(KLASIFIKASI_ID) = '6' ORDER BY KLASIFIKASI ASC";
            } else if ($panjang == "6") {
                $query = "SELECT (LTRIM(RTRIM(KLASIFIKASI_ID))) AS KLASIFIKASI_ID, KLASIFIKASI FROM M_GOLONGAN_SPESIFIK WHERE KLASIFIKASI_ID LIKE '" . $kategori_id . "%__' AND LEN(KLASIFIKASI_ID) = '8' ORDER BY KLASIFIKASI ASC";
            } else if ($panjang == "8") {
                $query = "SELECT (LTRIM(RTRIM(KLASIFIKASI_ID))) AS KLASIFIKASI_ID, KLASIFIKASI FROM M_GOLONGAN_SPESIFIK WHERE KLASIFIKASI_ID LIKE '" . $kategori_id . "%__' AND LEN(KLASIFIKASI_ID) = '10' ORDER BY KLASIFIKASI ASC";
            } else {
                die();
            }
            $res = $sipt->main->get_result($query);
            $hasil = "";
            if ($res) {
                $hasil .= '<option value="">&nbsp;</option>';
                foreach ($query->result_array() as $row) {
                    $hasil .= '<option value="' . $row['KLASIFIKASI_ID'] . '">' . str_replace("\n", "", $row['KLASIFIKASI']) . '</option>';
                }
            }
            echo $hasil;
        }
    }

    /* End Kategori atau golongan spesifik lokal */

    function get_kk_tambahan($kk = "") {
        if ($this->newsession->userdata('LOGGED_IN') == TRUE) {
            $sipt = & get_instance();
            $this->load->model("main", "main", true);
            $query = "SELECT NAMA_TAMBAHAN FROM M_GOLONGAN_TAMBAHAN WHERE KLASIFIKASI = '" . $kk . "' AND STATUS = 1 ORDER BY 1 ASC";
            $res = $sipt->main->get_result($query);
            $hasil = "";
            if ($res) {
                $hasil .= '<option value="">&nbsp;</option>';
                foreach ($query->result_array() as $row) {
                    $hasil .= '<option value="' . $row['NAMA_TAMBAHAN'] . '">' . str_replace("\n", "", $row['NAMA_TAMBAHAN']) . '</option>';
                }
            }
            echo $hasil;
        }
    }

    function get_petugas_pengujian($role, $spu) {
        if ($this->newsession->userdata('LOGGED_IN') == TRUE && in_array('02', $this->newsession->userdata('SESS_JENIS_PELAPORAN'))) {
            $key = strtolower($_REQUEST['q']);
            $this->load->model('main');
            if ($spu != "") {
                $chk = $this->db->query("SELECT SUM(CASE WHEN UJI_KIMIA = '1' THEN 1 ELSE 0 END) AS KIMIA, SUM(CASE WHEN UJI_MIKRO = '1' THEN 1 ELSE 0 END) AS MIKRO FROM T_M_SAMPEL WHERE SPU_ID = '" . $spu . "'")->result_array();

                if (in_array('7', $this->newsession->userdata('SESS_KODE_ROLE'))) {
                    $ko = $this->db->query("SELECT DISTINCT(KOMODITI) AS KOMODITI FROM T_M_SAMPEL WHERE SPU_ID = '" . $spu . "'")->result_array();
                    if ($chk[0]['KIMIA'] > 0 && $chk[0]['MIKRO'] > 0) {#Semua MT
                        $bidang = "";
                    } else if ($chk[0]['KIMIA'] > 0 && $chk[0]['MIKRO'] == 0) {#MT Pangan dan Teranokoko
                        $bidang = "AND LEFT(SARANA_MEDIA_ID,2) = 'B1' OR LEFT(SARANA_MEDIA_ID,2) = 'B2' AND SUBSTRING(KK_ID,2,3) = '" . $ko[0]['KOMODITI'] . "'";
                    } else if ($chk[0]['MIKRO'] > 0 && $chk[0]['KIMIA'] == 0) {#MT Mikro
                        $bidang = "AND LEFT(SARANA_MEDIA_ID,2) = 'B3' AND SUBSTRING(KK_ID,2,3) = '" . $ko[0]['KOMODITI'] . "'";
                    }
                } else if (in_array('4', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('3', $this->newsession->userdata('SESS_KODE_ROLE'))) {
                    /* if($chk[0]['KIMIA'] > 0){
                      if(in_array('B1',$this->newsession->userdata('SESS_SUB_SARANA')))
                      $bidang = "AND LEFT(SARANA_MEDIA_ID,2) = 'B1'";
                      else if(in_array('B2', $this->newsession->userdata('SESS_SUB_SARANA')))
                      $bidang = "AND LEFT(SARANA_MEDIA_ID,2) = 'B2'";
                      }else if($chk[0]['MIKRO'] > 0){
                      $bidang = "AND LEFT(SARANA_MEDIA_ID,2) = 'B3'";
                      } */
                    $kategori = "'" . join("','", $this->newsession->userdata('SESS_SARANA')) . "'";
                    if ($this->newsession->userdata('SESS_BBPOM_ID') == '11')
                        $bidang = "";
                    else
                        $bidang = " AND SARANA_MEDIA_ID IN ($kategori)";
                }
                $data = "SELECT A.USER_ID, A.NAMA_USER, A.JABATAN, B.NAMA_BBPOM FROM T_USER A LEFT JOIN M_BBPOM B ON A.BBPOM_ID = B.BBPOM_ID WHERE A.USER_ID IN (SELECT DISTINCT USER_ID FROM T_USER_ROLE WHERE JENIS_PELAPORAN IN ('02') AND ROLE IN ('" . $role . "') $bidang) AND A.NAMA_USER LIKE '%$key%' AND A.BBPOM_ID = '" . $this->newsession->userdata('SESS_BBPOM_ID') . "' AND A.STATUS = 'Aktif' ORDER BY 2 ASC";
            }else {
                $data = "SELECT A.USER_ID, A.NAMA_USER, A.JABATAN, B.NAMA_BBPOM FROM T_USER A LEFT JOIN M_BBPOM B ON A.BBPOM_ID = B.BBPOM_ID WHERE A.NAMA_USER LIKE '%$key%' AND A.USER_ID IN (SELECT DISTINCT USER_ID FROM T_USER_ROLE WHERE JENIS_PELAPORAN IN ('02') AND ROLE IN ('" . $role . "')) AND A.BBPOM_ID = '" . $this->newsession->userdata('SESS_BBPOM_ID') . "' AND A.STATUS = 'Aktif' ORDER BY 2 ASC";
            }
            $res = $this->main->get_result($data);
            if ($res) {
                foreach ($data->result_array() as $row) {
                    echo "<b>" . $row['NAMA_USER'] . "</b><br>NIP : " . $row['USER_ID'] . "<br>Jabatan : " . $row['JABATAN'] . "<br>" . $row['NAMA_BBPOM'] . "|" . $row['USER_ID'] . "|" . $row['NAMA_USER'] . "\n";
                }
            }
        }
    }

    function get_penyelia($role, $bidang) {
        if ($this->newsession->userdata('LOGGED_IN') == TRUE && in_array('02', $this->newsession->userdata('SESS_JENIS_PELAPORAN'))) {
            if ($bidang == "") {
                return "Mohon pilih salah tujuan Bidang Pengujian";
                die();
            }
            $key = strtolower($_REQUEST['q']);
            $this->load->model('main');
            $data = "SELECT TOP 20 A.USER_ID, A.NAMA_USER, A.JABATAN, B.NAMA_BBPOM FROM T_USER A LEFT JOIN M_BBPOM B ON A.BBPOM_ID = B.BBPOM_ID WHERE A.NAMA_USER LIKE '%$key%' AND A.USER_ID IN (SELECT DISTINCT USER_ID FROM T_USER_ROLE WHERE JENIS_PELAPORAN IN ('02') AND ROLE IN ('" . $role . "') AND SARANA_MEDIA_ID LIKE '%" . $bidang . "_%') AND A.BBPOM_ID = '" . $this->newsession->userdata('SESS_BBPOM_ID') . "' ORDER BY 2 ASC";
            $res = $this->main->get_result($data);
            if ($res) {
                foreach ($data->result_array() as $row) {
                    echo "<b>" . $row['NAMA_USER'] . "</b><br>NIP : " . $row['USER_ID'] . "<br>Jabatan : " . $row['JABATAN'] . "<br>" . $row['NAMA_BBPOM'] . "|" . $row['USER_ID'] . "|" . $row['NAMA_USER'] . "\n";
                }
            }
        }
    }

    function get_bidang($id = "") {
        if ($this->newsession->userdata('LOGGED_IN') == TRUE) {
            $sipt = & get_instance();
            $this->load->model("main", "main", true);
            $bidang = $sipt->main->get_uraian("SELECT DISTINCT(LEFT(SARANA_MEDIA_ID, 2)) AS BIDANG FROM T_USER_ROLE WHERE USER_ID = '" . $id . "'", "BIDANG");
            $query = "SELECT JENIS_SARANA_ID, NAMA_JENIS_SARANA FROM M_JENIS_SARANA WHERE JENIS_SARANA_ID = '" . $bidang . "'";
            $res = $sipt->main->get_result($query);
            $hasil = "";
            if ($res) {
                $hasil .= '<option value="">&nbsp;</option>';
                foreach ($query->result_array() as $row) {
                    $hasil .= '<option value="' . $row['JENIS_SARANA_ID'] . '">' . $row['NAMA_JENIS_SARANA'] . '</option>';
                }
            }
            echo $hasil;
        }
    }

    #Update autocomplete paramete uji terkait data prioritas sampling tahunan
    function get_jenis_pengujian_($kategori) {
        if ($this->newsession->userdata('LOGGED_IN') == TRUE){
            $key = strtolower($_REQUEST['q']);
            $this->load->model('main');
            if ($kategori == "") {
                return $this->index();
            }
            $jmljabatan = (int) $this->db->query("SELECT DISTINCT(USER_ID), LEFT(SARANA_MEDIA_ID, 2) AS BID FROM T_USER_ROLE WHERE USER_ID = '" . $this->newsession->userdata('SESS_USER_ID') . "' GROUP BY USER_ID, SARANA_MEDIA_ID")->num_rows();
            if ($this->newsession->userdata('SESS_BBPOM_ID') != "99"){
                if (in_array('B1', $this->newsession->userdata('SESS_SUB_SARANA')) || in_array('B2', $this->newsession->userdata('SESS_SUB_SARANA'))) {#Bidang Kimia Fisika
                    $bidang = " AND BIDANG_UJI = '02'";
                }else if(in_array('B3', $this->newsession->userdata('SESS_SUB_SARANA'))) {#Bidang Mikro
                    $bidang = " AND BIDANG_UJI = '01'";
                }
            }else{
                if (in_array('B5', $this->newsession->userdata('SESS_SUB_SARANA'))) {#Bidang Mikrobiologi PPOMN
                    $bidang = " AND BIDANG_UJI = '01'";
                }else{#Selain Bidang Mikrobiologi PPOMN
                    $bidang = " AND BIDANG_UJI = '02'";
                }
            }
            /* Default search parameter uji ke tabel M_PRIORITAS,
               Jika di tabel M_PRIORITAS tidak ditemukan
               Maka akan di arahkan ke tabel M_SRL (data sebelum 2015)   
            */
            $data = "SELECT SRL_ID, LTRIM(RTRIM(REPLACE(PARAMETER_UJI,'\n',''))) AS PARAMETER_UJI, SIMULAN, KATEGORI_PU, REPLACE(METODE,'\n',' ') AS METODE, REPLACE(PUSTAKA,'\n','') AS PUSTAKA, REPLACE(SYARAT,'\n','') AS SYARAT, REPLACE(RUANG_LINGKUP,'\n','') AS RUANG_LINGKUP, BIDANG_UJI, GOLONGAN, KATEGORI_PU, SIMULAN FROM M_PRIORITAS WHERE GOLONGAN = '" . $kategori . "' $bidang AND PARAMETER_UJI LIKE '%$key%' AND VERIFI = '01' AND STATUS IN ('2','9')";
            $res = $this->main->get_result($data);
            if ($res){
                foreach ($data->result_array() as $row){
                    echo "<b>" . $row['PARAMETER_UJI'] . "</b><br>&bull; Metode : " . $row['METODE'] . "<br>&bull; Pustaka : " . $row['PUSTAKA'] . "<br>&bull; Syarat : " . $row['SYARAT'] . "<br>&bull; Ruang Lingkup : " . $row['RUANG_LINGKUP'] . "|" . $row['SRL_ID'] . "|" . $row['PARAMETER_UJI'] . "|" . $row['METODE'] . "|" . $row['PUSTAKA'] . "|" . $row['SYARAT'] . "|" . $row['RUANG_LINGKUP'] . "|" . $row['BIDANG_UJI'] . "|" . $row['GOLONGAN'] . "|" . "|" . $row['SRL_ID'] . "|". $row['SIMULAN'] . "|". $row['KATEGORI_PU'] ."\n";
                }
            }else{
                $qsrl = "SELECT SRL_ID, LTRIM(RTRIM(REPLACE(PARAMETER_UJI,'\n',''))) AS PARAMETER_UJI, SIMULAN, '' AS KATEGORI_PU, REPLACE(METODE,'\n',' ') AS METODE, REPLACE(PUSTAKA,'\n','') AS PUSTAKA, REPLACE(SYARAT,'\n','') AS SYARAT, REPLACE(RUANG_LINGKUP,'\n','') AS RUANG_LINGKUP, BIDANG_UJI, GOLONGAN, KATEGORI_PU, '' AS SIMULAN FROM M_SRL WHERE GOLONGAN = '" . $kategori . "' $bidang AND PARAMETER_UJI LIKE '%$key%' AND VERIFI = '01' AND STATUS IN ('2','9')";
                $rsrl = $this->main->get_result($qsrl);
                if($rsrl){
                    foreach ($qsrl->result_array() as $row){
                        echo "<b>" . $row['PARAMETER_UJI'] . "</b><br>&bull; Metode : " . $row['METODE'] . "<br>&bull; Pustaka : " . $row['PUSTAKA'] . "<br>&bull; Syarat : " . $row['SYARAT'] . "<br>&bull; Ruang Lingkup : " . $row['RUANG_LINGKUP'] . "|" . $row['SRL_ID'] . "|" . $row['PARAMETER_UJI'] . "|" . $row['METODE'] . "|" . $row['PUSTAKA'] . "|" . $row['SYARAT'] . "|" . $row['RUANG_LINGKUP'] . "|" . $row['BIDANG_UJI'] . "|" . $row['GOLONGAN'] . "|" . "|" . $row['SRL_ID'] . "|". $row['SIMULAN'] . "|". $row['KATEGORI_PU'] ."\n";
                    }
                }else{
                    echo "Data tidak ditemukan|||||||||\n";
                }
            }
        }
    }
    
    function get_jenis_pengujian($kategori, $prioritas){
        if ($this->newsession->userdata('LOGGED_IN') == TRUE){
            $key = strtolower($_REQUEST['q']);
            $this->load->model('main');
            if ($kategori == "") {
                return $this->index();
            }
            $jmljabatan = (int) $this->db->query("SELECT DISTINCT(USER_ID), LEFT(SARANA_MEDIA_ID, 2) AS BID FROM T_USER_ROLE WHERE USER_ID = '" . $this->newsession->userdata('SESS_USER_ID') . "' GROUP BY USER_ID, SARANA_MEDIA_ID")->num_rows();
            if ($this->newsession->userdata('SESS_BBPOM_ID') != "99"){
                if (in_array('B1', $this->newsession->userdata('SESS_SUB_SARANA')) || in_array('B2', $this->newsession->userdata('SESS_SUB_SARANA'))) {#Bidang Kimia Fisika
                    $bidang = " AND BIDANG_UJI = '02'";
                }else if(in_array('B3', $this->newsession->userdata('SESS_SUB_SARANA'))) {#Bidang Mikro
                    $bidang = " AND BIDANG_UJI = '01'";
                }
            }else{
                if (in_array('B5', $this->newsession->userdata('SESS_SUB_SARANA'))) {#Bidang Mikrobiologi PPOMN
                    $bidang = " AND BIDANG_UJI = '01'";
                }else{#Selain Bidang Mikrobiologi PPOMN
                    $bidang = " AND BIDANG_UJI = '02'";
                }
            }
            if($prioritas == "1"){
                $substr = substr($kategori, 0,4); #Obat Kategori E
                if($substr == "0107"){
                    $data = "SELECT TOP 100 SRL_ID, LTRIM(RTRIM(REPLACE(PARAMETER_UJI,'\n',''))) AS PARAMETER_UJI, SIMULAN, KATEGORI_PU, REPLACE(METODE,'\n',' ') AS METODE, REPLACE(PUSTAKA,'\n','') AS PUSTAKA, REPLACE(SYARAT,'\n','') AS SYARAT, REPLACE(RUANG_LINGKUP,'\n','') AS RUANG_LINGKUP, BIDANG_UJI, GOLONGAN, dbo.KATEGORI(GOLONGAN, '1') AS UR_KLASIFIKASI FROM M_PRIORITAS WHERE LEFT(GOLONGAN,2) = '01' $bidang AND PARAMETER_UJI LIKE '%$key%' AND PRIORITAS_TAHUN = '".date("Y")."'";
                }else{
                    $data = "SELECT TOP 100 SRL_ID, LTRIM(RTRIM(REPLACE(PARAMETER_UJI,'\n',''))) AS PARAMETER_UJI, SIMULAN, KATEGORI_PU, REPLACE(METODE,'\n',' ') AS METODE, REPLACE(PUSTAKA,'\n','') AS PUSTAKA, REPLACE(SYARAT,'\n','') AS SYARAT, REPLACE(RUANG_LINGKUP,'\n','') AS RUANG_LINGKUP, BIDANG_UJI, GOLONGAN, '' AS UR_KLASIFIKASI FROM M_PRIORITAS WHERE GOLONGAN = '" . $kategori . "' $bidang AND PARAMETER_UJI LIKE '%$key%' AND PRIORITAS_TAHUN = '".date("Y")."'";
                }
            }else if($prioritas == "0"){
                $data = "SELECT TOP 100 SRL_ID, LTRIM(RTRIM(REPLACE(PARAMETER_UJI,'\n',''))) AS PARAMETER_UJI, SIMULAN, '' AS KATEGORI_PU, REPLACE(METODE,'\n',' ') AS METODE, REPLACE(PUSTAKA,'\n','') AS PUSTAKA, REPLACE(SYARAT,'\n','') AS SYARAT, REPLACE(RUANG_LINGKUP,'\n','') AS RUANG_LINGKUP, BIDANG_UJI, GOLONGAN, '' AS UR_KLASIFIKASI FROM M_SRL WHERE GOLONGAN = '" . $kategori . "' $bidang AND PARAMETER_UJI LIKE '%$key%' AND VERIFI = '01' AND STATUS IN ('2','9')";
            }
            //echo $data;
            $res = $this->main->get_result($data);
            if ($res){
                foreach ($data->result_array() as $row){
                    echo "<b>" . $row['PARAMETER_UJI'] . "</b><br>&bull; Metode : " . $row['METODE'] . "<br>&bull; Pustaka : " . $row['PUSTAKA'] . "<br>&bull; Syarat : " . $row['SYARAT'] . "<br>&bull; Ruang Lingkup : " . $row['RUANG_LINGKUP'] . ($substr == "0107" ? "<hr>" . $row['UR_KLASIFIKASI'] : "") . "|" . $row['SRL_ID'] . "|" . $row['PARAMETER_UJI'] . "|" . $row['METODE'] . "|" . $row['PUSTAKA'] . "|" . $row['SYARAT'] . "|" . $row['RUANG_LINGKUP'] . "|" . $row['BIDANG_UJI'] . "|" . $row['GOLONGAN'] . "|" . "|" . $row['SRL_ID'] . "|". $row['SIMULAN'] . "|". $row['KATEGORI_PU'] ."\n";
                }
            }else{
                echo "Data tidak ditemukan|||||||||\n";
            }
        }
    }

    function get_penguji() {
        if ($this->newsession->userdata('LOGGED_IN') == TRUE && in_array('02', $this->newsession->userdata('SESS_JENIS_PELAPORAN'))) {
            $key = strtolower($_REQUEST['q']);
            $this->load->model('main');
            $klasifikasi = "'" . join("','", $this->newsession->userdata('SESS_SARANA')) . "'";
            $data = "SELECT TOP 20 A.USER_ID, A.NAMA_USER, A.JABATAN, B.NAMA_BBPOM FROM T_USER A LEFT JOIN M_BBPOM B ON A.BBPOM_ID = B.BBPOM_ID WHERE A.NAMA_USER LIKE '%$key%' AND A.USER_ID IN (SELECT USER_ID FROM T_USER_ROLE WHERE SARANA_MEDIA_ID IN($klasifikasi) AND ROLE IN ('2') AND JENIS_PELAPORAN = '02') AND A.BBPOM_ID = '" . $this->newsession->userdata('SESS_BBPOM_ID') . "' ORDER BY 2 ASC";
            $res = $this->main->get_result($data);
            if ($res) {
                foreach ($data->result_array() as $row) {
                    echo "<b>" . $row['NAMA_USER'] . "</b><br>NIP : " . $row['USER_ID'] . "<br>Jabatan : " . $row['JABATAN'] . "<br>" . $row['NAMA_BBPOM'] . "|" . $row['USER_ID'] . "|" . $row['NAMA_USER'] . "\n";
                }
            }
        }
    }

    function get_dispo() {
        if ($this->newsession->userdata('LOGGED_IN') == TRUE && in_array('02', $this->newsession->userdata('SESS_JENIS_PELAPORAN'))) {
            $key = strtolower($_REQUEST['q']);
            $this->load->model('main');
            if ($this->newsession->userdata('SESS_BBPOM_ID') == "99") {
                $bidang = "AND LEFT(SARANA_MEDIA_ID,2) = 'B5'";
            }
            $data = "SELECT TOP 20 A.USER_ID, A.NAMA_USER, A.JABATAN, B.NAMA_BBPOM FROM T_USER A LEFT JOIN M_BBPOM B ON A.BBPOM_ID = B.BBPOM_ID WHERE A.USER_ID IN (SELECT DISTINCT USER_ID FROM T_USER_ROLE WHERE JENIS_PELAPORAN IN ('02') AND ROLE IN ('4') $bidang) AND A.NAMA_USER LIKE '%$key%' AND A.BBPOM_ID = '" . $this->newsession->userdata('SESS_BBPOM_ID') . "' ORDER BY 2 ASC";
            $res = $this->main->get_result($data);
            if ($res) {
                foreach ($data->result_array() as $row) {
                    echo "<b>" . $row['NAMA_USER'] . "</b><br>NIP : " . $row['USER_ID'] . "<br>Jabatan : " . $row['JABATAN'] . "<br>" . $row['NAMA_BBPOM'] . "|" . $row['USER_ID'] . "|" . $row['NAMA_USER'] . "\n";
                }
            }
        }
    }

    function get_metode($komoditi) {
        if ($this->newsession->userdata('LOGGED_IN') == TRUE && in_array('02', $this->newsession->userdata('SESS_JENIS_PELAPORAN'))) {
            $key = strtolower($_REQUEST['q']);
            $this->load->model('main');
            if (in_array('B1', $this->newsession->userdata('SESS_SUB_SARANA')) || in_array('B2', $this->newsession->userdata('SESS_SUB_SARANA'))) {#Bidang Kimia Fisika
                $bidang = "02";
            } else if (in_array('B3', $this->newsession->userdata('SESS_SUB_SARANA'))) {#Bidang Mikro
                $bidang = "01";
            }
            $data = "SELECT UPPER(METODE) AS METODE FROM T_SRL_PENGUJIAN WHERE BIDANG_UJI = '" . $bidang . "' AND GOLONGAN_ID = '" . $komoditi . "' AND METODE LIKE '%$key%'";
            $res = $this->main->get_result($data);
            if ($res) {
                foreach ($data->result_array() as $row) {
                    echo $row['METODE'] . "\n";
                }
            }
        }
    }

    function operator_tps() {
        if ($this->newsession->userdata('LOGGED_IN') == TRUE) {
            $key = strtolower($_REQUEST['q']);
            $this->load->model('main');
            $data = "SELECT TOP 10 A.USER_ID, A.NAMA_USER, A.JABATAN, B.NAMA_BBPOM FROM T_USER A LEFT JOIN M_BBPOM B ON A.BBPOM_ID = B.BBPOM_ID WHERE A.NAMA_USER LIKE '%$key%' AND A.USER_ID IN (SELECT DISTINCT USER_ID FROM T_USER_ROLE WHERE ROLE IN ('7') AND A.BBPOM_ID = '" . $this->newsession->userdata('SESS_BBPOM_ID') . "') ORDER BY 2 ASC";
            $res = $this->main->get_result($data);
            if ($res) {
                foreach ($data->result_array() as $row) {
                    echo $row['NAMA_USER'] . "\n\n";
                }
            }
        }
    }

    function sarana_bb() {
        if ($this->newsession->userdata('LOGGED_IN') == TRUE) {
            $key = strtolower($_REQUEST['q']);
            $this->load->model('main');
            $sarana = "'" . join("','", $this->newsession->userdata('SESS_SARANA')) . "'";
            if (!in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) {
                $data = "SELECT TOP 30 A.SARANA_ID, UPPER(REPLACE(REPLACE(A.NAMA_SARANA,',', ' '),'\n','')) AS NAMA_SARANA, REPLACE(REPLACE(A.ALAMAT_1,',', ' '),'\n','') AS ALAMAT, A.PROPINSI, A.SARANA_BB, B.NAMA_JENIS_SARANA AS URAIAN_JENIS, C.NAMA_PROPINSI AS PROP, D.NAMA_PROPINSI AS KOTA FROM M_SARANA A LEFT JOIN M_JENIS_SARANA B ON A.JENIS_SARANA = B.JENIS_SARANA_ID LEFT JOIN M_PROPINSI C ON A.PROPINSI = C.PROPINSI_ID LEFT JOIN M_PROPINSI D ON A.KOTA = D.PROPINSI_ID WHERE A.NAMA_SARANA LIKE '%$key%' AND A.FLAG = '0'";
            } else {
                if ($this->newsession->userdata('SESS_BBPOM_ID') == "93") {
                    $sarana .= "'01OO','02MM','02LL','03AA'";
                }
                $data = "SELECT TOP 30 A.SARANA_ID, UPPER(REPLACE(REPLACE(A.NAMA_SARANA,',', ' '),'\n','')) AS NAMA_SARANA, REPLACE(REPLACE(A.ALAMAT_1,',', ' '),'\n','') AS ALAMAT, A.PROPINSI, A.SARANA_BB, B.NAMA_JENIS_SARANA AS URAIAN_JENIS, C.NAMA_PROPINSI AS PROP, D.NAMA_PROPINSI AS KOTA FROM M_SARANA A LEFT JOIN M_JENIS_SARANA B ON A.JENIS_SARANA = B.JENIS_SARANA_ID LEFT JOIN M_PROPINSI C ON A.PROPINSI = C.PROPINSI_ID LEFT JOIN M_PROPINSI D ON A.KOTA = D.PROPINSI_ID WHERE A.NAMA_SARANA LIKE '%$key%' AND A.FLAG = '0'";
            }
            $res = $this->main->get_result($data);
            if ($res) {
                foreach ($data->result_array() as $row) {
                    echo "<b>" . $row['NAMA_SARANA'] . "</b><br>" . $row['ALAMAT'] . "<br>" . $row['KOTA'] . " - " . $row['PROP'] . "|" . strtoupper($row['SARANA_ID']) . "|" . strtoupper($row['NAMA_SARANA']) . "|" . $row['ALAMAT'] . "|" . $row['PROPINSI'] . "|" . $row['SARANA_BB'] . "\n";
                }
            }
            echo "<a href=\"#\" url=\"" . site_url() . "/home/master/sarana/new\" class=\"newsarana_\" onclick=\"sarana_baru($(this).attr('url')); return false;\" title=\"Form Tambah Sarana Baru\">Masukkan Data Baru<br/>Jika Belum Ada Pada Daftar Di Atas</a>|||\n";
        }
    }

    function get_kemasanbb($id) {
        if ($this->newsession->userdata('LOGGED_IN') == TRUE) {
            $sipt = & get_instance();
            $this->load->model("main", "main", true);
            echo $sipt->main->get_uraian("SELECT RTRIM(LTRIM(JUMLAH)) +' '+ SATUAN AS KEMASAN FROM M_KEMASAN_BB WHERE KEMASAN_ID = '" . $id . "'", "KEMASAN");
        }
    }

    function get_tujuan_sampling($id = "", $tipe) {
        if ($this->newsession->userdata('LOGGED_IN') == TRUE) {
            $sipt = & get_instance();
            $this->load->model("main", "main", true);
            $query = "SELECT KODE, URAIAN FROM M_TABEL WHERE LEFT(KODE,2) = '" . $id . "' AND URAIAN_DETIL = '" . $tipe . "' AND JENIS = 'SUB_TUJUAN' ORDER BY 1 ASC";
            $res = $sipt->main->get_result($query);
            $hasil = "";
            if ($res) {
                $hasil .= '<option value="">&nbsp;</option>';
                foreach ($query->result_array() as $row) {
                    $hasil .= '<option value="' . $row['KODE'] . '">' . $row['URAIAN'] . '</option>';
                }
            }
            echo $hasil;
        }
    }

    function get_pnbp() {
        if ($this->newsession->userdata('LOGGED_IN') == TRUE) {
            $key = strtolower($_REQUEST['q']);
            $this->load->model('main');
            $data = "SELECT PNBP_ID, PNBP_DESCRIPTION, PNBP_AMOUNT, PNBP_UNIT FROM M_PNBP WHERE PNBP_DESCRIPTION LIKE '%$key%'";
            $res = $this->main->get_result($data);
            if ($res) {
                foreach ($data->result_array() as $row) {
                    echo "<b>" . $row['PNBP_DESCRIPTION'] . "</b><br>&bull; Satuan : " . $row['PNBP_AMOUNT'] . "<br>&bull; Tarif : " . $row['PNBP_UNIT'] . "|" . $row['PNBP_ID'] . "|" . $row['PNBP_DESCRIPTION'] . "|" . $row['PNBP_AMOUNT'] . "|" . $row['PNBP_UNIT'] . "\n";
                }
            } else {
                echo "Data tidak ditemukan||||\n";
            }
        }
    }

    function get_tipebidang($bbpom = "") {
        if ($this->newsession->userdata('LOGGED_IN') == TRUE) {
            $sipt = & get_instance();
            $this->load->model("main", "main", true);
            if ($bbpom == "99")
                $query = "SELECT JENIS_SARANA_ID, NAMA_JENIS_SARANA FROM M_JENIS_SARANA WHERE JENIS_SARANA_ID LIKE 'B%' AND LEN(JENIS_SARANA_ID) = 3";
            else
                $query = "SELECT JENIS_SARANA_ID, NAMA_JENIS_SARANA FROM M_JENIS_SARANA WHERE JENIS_SARANA_ID LIKE 'B%' AND LEN(JENIS_SARANA_ID) = 2";
            $res = $sipt->main->get_result($query);
            $hasil = "";
            if ($res) {
                foreach ($query->result_array() as $row) {
                    $hasil .= '<option value="' . $row['JENIS_SARANA_ID'] . '">' . $row['NAMA_JENIS_SARANA'] . '</option>';
                }
            }
            echo $hasil;
        }
    }

    function get_list_param() {
        if ($this->newsession->userdata('LOGGED_IN') == TRUE) {
            $key = strtolower($_REQUEST['q']);
            $this->load->model('main');
            $data = "SELECT TOP 10 * FROM T_LIST_PARAMETER WHERE PARAMETER LIKE '%$key%'";
            $res = $this->main->get_result($data);
            if ($res) {
                foreach ($data->result_array() as $row) {
                    echo $row['PARAMETER'] . "\n";
                }
            }
        }
    }
    
  function set_prioritas($tipe, $allowed=""){
      if($this->newsession->userdata('LOGGED_IN') == TRUE) {
          $sipt = & get_instance();
          $this->load->model("main", "main", true);
          if($tipe == "0"){
              $query = "SELECT (LTRIM(RTRIM(KLASIFIKASI_ID))) AS KLASIFIKASI_ID, LTRIM(RTRIM(KLASIFIKASI)) AS KLASIFIKASI FROM M_GOLONGAN WHERE  LEN(KLASIFIKASI_ID) = '2' AND KLASIFIKASI <> '' ORDER BY KLASIFIKASI_ID ASC";
          }else{
              if($allowed == "external")
              $query = "SELECT (LTRIM(RTRIM(KLASIFIKASI_ID))) AS KLASIFIKASI_ID, LTRIM(RTRIM(KLASIFIKASI)) AS KLASIFIKASI FROM M_GOLONGAN_NEW WHERE LEN(KLASIFIKASI_ID) = '2' AND KLASIFIKASI <> '' AND STATUS = '1' ORDER BY KLASIFIKASI_ID ASC";
              else
              $query = "SELECT (LTRIM(RTRIM(KLASIFIKASI_ID))) AS KLASIFIKASI_ID, LTRIM(RTRIM(KLASIFIKASI)) AS KLASIFIKASI FROM M_GOLONGAN_NEW WHERE LEN(KLASIFIKASI_ID) = '2' AND KLASIFIKASI <> '' AND STATUS = '1' AND KLASIFIKASI_ID NOT IN ('20') ORDER BY KLASIFIKASI_ID ASC";
          }
          $res = $sipt->main->get_result($query);
          $hasil = "";
          if($res){
              $hasil .= '<option value="">&nbsp;</option>';
              foreach ($query->result_array() as $row){
                  $hasil .= '<option value="' . $row['KLASIFIKASI_ID'] . '">' . str_replace("\n", "", $row['KLASIFIKASI']) . '</option>';
              }
          }
          echo $hasil;
      }
  }

  function get_rokok($jenis){
      $key = strtolower($_REQUEST['q']);
      $this->load->model('main');
      if($jenis=="")
      $data = "SELECT ID_ROKOK, NAMA_PERUSAHAAN, MERK, JENIS, ISI, JENIS + ' ' + CAST(ISI AS VARCHAR) AS KOMPOSISI FROM M_ROKOK WHERE MERK LIKE '%$key%' OR NAMA_PERUSAHAAN LIKE '%$key%'";
      else
      $data = "SELECT ID_ROKOK, NAMA_PERUSAHAAN, MERK, JENIS, ISI, JENIS + '  ' + CAST(ISI AS VARCHAR) AS KOMPOSISI FROM M_ROKOK WHERE MERK LIKE '%$key%' OR NAMA_PERUSAHAAN LIKE '%$key%' AND JENIS = '".$jenis."'";
      $res = $this->main->get_result($data);
      if ($res){
          foreach ($data->result_array() as $row){
              echo "<b>" . trim($row['MERK']) . "</b><br>Perusahaan : " . trim($row['NAMA_PERUSAHAAN']) . "<br>Jenis : " . trim($row['JENIS']) . "<br>Isi : " . trim($row['ISI']) . "|" . trim($row['MERK']) . "|" . trim($row['NAMA_PERUSAHAAN']) . "|" . trim($row['KOMPOSISI']) . "||||||||\n";

          }
      }else{
        echo "Data tidak ditemukan|||||||||||\n";
      }
  }

    function set_balai_unggulan($id) {
        if ($this->newsession->userdata('LOGGED_IN') == TRUE) {
          $sipt = & get_instance();
          $this->load->model("main", "main", true);
          if($id=='04'){
              $query = "SELECT BBPOM_ID AS KODE, NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID IN('11','13','99')";
          }else{
              if($this->newsession->userdata('SESS_BBPOM_ID')=='50') $bbpom_id = "AND BBPOM_ASAL IN('01','15','18')";
              else $bbpom_id = "AND BBPOM_ASAL = '".$this->newsession->userdata('SESS_BBPOM_ID')."'";
              $bbpom_unggulan = $this->main->get_uraian("SELECT BBPOM_UNGGULAN FROM M_LINGKUP_UNGGULAN_DETIL WHERE ID_UNGGULAN = '".$id."' $bbpom_id", "BBPOM_UNGGULAN"); 
              $query = "SELECT BBPOM_ID AS KODE, NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID = '".$bbpom_unggulan."'";
          }
          $res = $sipt->main->get_result($query);
          $hasil = "";
          if ($res) {
            $hasil .= '<option value="">&nbsp;</option>';
            foreach ($query->result_array() as $row) {
              $hasil .= '<option value="' . $row['KODE'] . '">' . str_replace("\n", "", $row['NAMA_BBPOM']) . '</option>';
            }
          }
          echo $hasil;
        }
    }
  
//Pengawasan Iklan dan Penandaan

    function produk_reg_2($klasifikasi) {
        $key = strtolower($_REQUEST['q']);
        $this->load->model('main');
        if ($klasifikasi == "1") {
            $kode = "LEFT(A.CLASS_ID,2) = '01'";
        } else if ($klasifikasi == "ot") {
            $kode = "LEFT(A.CLASS_ID,2) = '10'";
        } else if ($klasifikasi == "pk") {
            $kode = "LEFT(A.CLASS_ID,2) = '11'";
        } else if ($klasifikasi == "kos") {
            $kode = "LEFT(A.CLASS_ID,2) = '12'";
        } else if ($klasifikasi == "3") {
            $kode = "LEFT(A.CLASS_ID,2) = '13'";
        } else {
            $kode = " A.CLASS_ID = '" . $klasifikasi . "'";
        }
        $data = "SELECT TOP 25 A.PRODUCT_ID, A.IMPORTER_ID, CONVERT(VARCHAR, A.SUBMIT_DATE, 105) AS SUBMIT_DATE, A.PRODUCT_REGISTER, CONVERT(VARCHAR, A.PRODUCT_UPDATE, 105) AS PRODUCT_UPDATE, CONVERT(VARCHAR, A.PRODUCT_DATE, 105) AS PRODUCT_DATE, A.PRODUCT_NAME, A.PRODUCT_BRANDS, CONVERT(VARCHAR, A.PRODUCT_EXPIRED, 105) AS PRODUCT_EXPIRED, A.PRODUCT_FORM, A.PRODUCT_PACKAGE, A.STATUS, A.APPLICATION, A.APPLICATION_ID, B.CLASS, dbo.GetCategory(A.CLASS_ID) AS CATEGORY, B.DEPARTMENT, C.USER_NAME, A.REGISTRAR_ID, D.MANUFACTURER_NAME AS REGISTRAR, E.MANUFACTURER_ID AS MANUFACTURER_ID, E.MANUFACTURER_NAME AS MANUFACTURER, REPLACE(REPLACE(F.MANUFACTURER_NAME,',', ' '),'\n','') AS IMPORTER, D.MANUFACTURER_ADDRESS AS REGISTRAR_ADD, E.MANUFACTURER_ADDRESS AS MANUFACTURER_ADD, F.MANUFACTURER_ADDRESS AS IMPORTER_ADD, dbo.GetLocation(D.MANUFACTURER_DISTRICT_DETAIL, D.MANUFACTURER_PROVINCE_DETAIL, D.MANUFACTURER_COUNTRY_DETAIL, 0) AS REGISTRAR_PROV, dbo.GetLocation(E.MANUFACTURER_DISTRICT_DETAIL, E.MANUFACTURER_PROVINCE_DETAIL, E.MANUFACTURER_COUNTRY_DETAIL, 0) AS MANUFACTURER_PROV, dbo.GetLocation(F.MANUFACTURER_DISTRICT_DETAIL, F.MANUFACTURER_PROVINCE_DETAIL, F.MANUFACTURER_COUNTRY_DETAIL, 0) AS IMPORTER_PROV, dbo.GetIngredients(A.PRODUCT_ID, A.APPLICATION_ID) AS INGREDIENTS, I.FILE_NAME, P.INGREDIENTS FROM T_PRODUCT A LEFT JOIN M_CLASS B ON B.CLASS_ID = LEFT(A.CLASS_ID, 2) LEFT JOIN T_USER C ON C.USER_ID = A.USER_ID LEFT JOIN T_MANUFACTURER D ON D.MANUFACTURER_ID = A.REGISTRAR_ID AND D.APPLICATION_ID = A.APPLICATION_ID LEFT JOIN T_PRODUCT_MANUFACTURER H ON H.PRODUCT_ID = A.PRODUCT_ID AND H.APPLICATION_ID = A.APPLICATION_ID LEFT JOIN T_MANUFACTURER E ON E.MANUFACTURER_ID = H.MANUFACTURER_ID AND E.APPLICATION_ID = A.APPLICATION_ID LEFT JOIN T_MANUFACTURER F ON F.MANUFACTURER_ID = A.IMPORTER_ID AND F.APPLICATION_ID = A.APPLICATION_ID LEFT JOIN T_PRODUCT_LABEL I ON I.PRODUCT_ID = A.PRODUCT_ID LEFT JOIN T_PRODUCT_INGREDIENTS P ON P.PRODUCT_ID = A.PRODUCT_ID WHERE $kode AND A.STATUS NOT LIKE '%Tidak%' AND (A.PRODUCT_REGISTER LIKE '%$key%' OR A.PRODUCT_NAME LIKE '%$key%' OR A.PRODUCT_BRANDS LIKE '%$key%') ORDER BY A.PRODUCT_NAME ASC";
        $res = $this->main->get_result_webreg($data);
        if ($res) {
            foreach ($data->result_array() as $row) {
                echo "<b>" . trim($row['PRODUCT_NAME']) . "</b><br>Merk Dagang : " . trim($row['PRODUCT_BRANDS']) . "<br><b>NIE : " . trim($row['PRODUCT_REGISTER']) . "</b><br>Pendaftar : " . trim($row['REGISTRAR']) . "<br>Pabrik : " . trim($row['MANUFACTURER']) . "<br>Importir : " . trim($row['IMPORTER']) . "<br>Bentuk Sediaan : " . trim($row['PRODUCT_FORM']) . "<br>Besar Kemasan : " . trim($row['PRODUCT_PACKAGE']) . "|" . trim($row['PRODUCT_NAME']) . "|" . trim($row['PRODUCT_REGISTER']) . "|" . trim($row['REGISTRAR']) . "|" . trim($row['PRODUCT_PACKAGE']) . "|" . str_replace('\n', '&raquo;', trim($row['REGISTRAR_ADD'])) . ", " . trim($row['REGISTRAR_PROV']) . "|" . trim($row['MANUFACTURER']) . "|" . trim($row['IMPORTER']) . "|" . trim($row['MANUFACTURER_PROV']) . "|" . trim($row['PRODUCT_FORM']) . "|" . trim($row['INGREDIENTS']) . "|" . trim($row['MANUFACTURER_ADD']) . ", " . trim($row['MANUFACTURER_PROV']) . "|" . str_replace('&raquo;', ' - ', trim($row['CATEGORY'])) . "|" . trim($row['PRODUCT_BRANDS']) . "|" . trim($row['PRODUCT_ID']) . "|" . trim($row['APPLICATION_ID']) . "\n";
            }
        }
        echo "Data tidak ditemukan||||||||\n";
    }

    function nama_media($klasifikasi, $nama = "") {
        if (trim($nama) == "") {
            if ($klasifikasi == "TV")
                $klasifikasi = "Televisi";
            $data = $this->db->query("SELECT URAIAN FROM M_TABEL WHERE JENIS = 'MEDIA_IKLAN'")->result();
            foreach ($data as $row) {
                $arr[] = $row->URAIAN;
            }
        } else {
            $data = $this->db->query("SELECT DISTINCT KODE_JENIS_IKLAN FROM M_MEDIA")->result();
            foreach ($data as $row) {
                $arr[] = $row->KODE_JENIS_IKLAN;
            }
        }
        $this->load->model('main');
        if (!in_array($klasifikasi, $arr)) {
            exit();
        } else {
            $kodeProvinsi = substr($this->newsession->userdata('SESS_PROP_ID'), 0, 2);
//   $prov = $this->main->get_media_prov("SELECT PROPINSI_ID FROM M_PROPINSI WHERE LEFT(PROPINSI_ID, 2) = '" . $kodeProvinsi . "' AND RIGHT(PROPINSI_ID, 2) != '00'", "PROPINSI_ID");
            if (trim($nama) != "") {
//    if (!in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')) && $this->newsession->userdata('SESS_BBPOM_ID') != '00') {
//     if ($this->newsession->userdata('SESS_PROP_ID') == '7100') {
//      $prop = "'7100','8200'";
//     } else if ($this->newsession->userdata('SESS_PROP_ID') == '7300') {
//      $prop = "'7300','7600'";
//     } else {
//      $prop = "'" . $this->newsession->userdata('SESS_PROP_ID') . "'";
//     }
//     $jml = (int) $this->main->get_uraian("SELECT COUNT(*) AS JML FROM M_MEDIA WHERE NAMA_MEDIA LIKE '%" . $nama . "%' AND KODE_JENIS_IKLAN = $klasifikasi AND PROPINSI IN ($prop)", "JML");
//    }
//    else
                $jml = (int) $this->main->get_uraian("SELECT COUNT(*) AS JML FROM M_MEDIA WHERE NAMA_MEDIA = '" . $nama . "' AND KODE_JENIS_IKLAN = $klasifikasi", "JML");
                if ($jml > 0)
                    echo "Y";
            } else {
                if (trim($klasifikasi) != "") {
                    $key = strtolower($_REQUEST['q']);
//     if (!in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')) && $this->newsession->userdata('SESS_BBPOM_ID') != '00') {
//      if ($this->newsession->userdata('SESS_PROP_ID') == '7100') {
//       $prop = "'7100','8200'";
//      } else if ($this->newsession->userdata('SESS_PROP_ID') == '7300') {
//       $prop = "'7300','7600'";
//      } else {
//       $prop = "'" . $this->newsession->userdata('SESS_PROP_ID') . "'";
//      }
//      $data = "SELECT TOP 25 MM.NAMA_MEDIA, MM.ID_MEDIA, MJM.NAMA_JENIS_MEDIA FROM M_MEDIA MM LEFT JOIN M_JENIS_MEDIA MJM ON MJM.JENIS_MEDIA_ID = MM.KODE_JENIS_IKLAN WHERE MM.KODE_JENIS_IKLAN = $klasifikasi AND (MM.NAMA_MEDIA LIKE '%$key%') AND PROPINSI IN ($prop)";
//     }
//     else
                    $data = "SELECT TOP 25 MM.NAMA_MEDIA, MM.ID_MEDIA, MJM.NAMA_JENIS_MEDIA FROM M_MEDIA MM LEFT JOIN M_JENIS_MEDIA MJM ON MJM.JENIS_MEDIA_ID = MM.KODE_JENIS_IKLAN WHERE MM.KODE_JENIS_IKLAN = (SELECT KODE FROM M_TABEL WHERE URAIAN = '$klasifikasi') AND  MM.NAMA_MEDIA LIKE '%$key%'";
                    $res = $this->main->get_result($data);
                    if ($res) {
                        foreach ($data->result_array() as $row) {
                            echo "<b>" . $row['NAMA_MEDIA'] . "</b><br>Jenis : " . $row['NAMA_JENIS_MEDIA'] . "|" . $row['NAMA_MEDIA'] . "|" . $row['ID_MEDIA'] . "\n";
                        }
                    } else {
                        echo "<a href=\"#\" url=\"" . site_url() . "/home/master/mediaIklan/new\" class=\"newsarana_\" onclick=\"sarana_baru($(this).attr('url')); return false;\" title=\"Form Tambah Sarana Baru\">Data tidak ditemukan &raquo;  Masukkan Data Baru<br/>Jika Belum Ada Pada Daftar Di Atas</a>|||\n";
                    }
                }
            }
        }
    }

    /* function get_komposisi($product, $app) {
      if ($this->newsession->userdata('LOGGED_IN') == TRUE) {
      $this->load->model('main');
      $query = "SELECT dbo.GetIngredients('" . str_replace("-", " ", $product) . "', '" . $app . "') AS KOMPOSISI";
      $data = $this->main->get_result_webreg($query);
      if ($data) {
      foreach ($query->result_array() as $row) {
      $res = str_replace("<br>", "", str_replace("- ", "|", $row['KOMPOSISI']));
      $arrdata = explode("|", $res);
      $arrdata = array_slice($arrdata, 1);
      $ret = join(";", $arrdata);
      }
      }
      echo trim($ret);
      }
      } */

    function get_surat_2($nomor) {
        $key = strtolower($_REQUEST['q']);
        $this->load->model('main');
        $data = "SELECT TSTI.SURAT_ID, TSTI.NOMOR, CONVERT(VARCHAR(10), TSTI.TANGGAL, 103) AS TANGGAL FROM T_SURAT_TUGAS_IKLAN TSTI WHERE TSTI.NOMOR LIKE '%$key%'";
        $res = $this->main->get_result($data);
        if ($res) {
            foreach ($data->result_array() as $row) {
                echo "<b>Nomor Surat : " . $row['NOMOR'] . "</b><br>Tanggal Surat : " . $row['TANGGAL'] . "<br>Anggaran Sampling - " . $row['UR_ANGGARAN'] . "|" . $row['SURAT_ID'] . "|" . $row['NOMOR'] . "|" . $row['TANGGAL'] . "|" . $row['ANGGARAN'] . "|" . $row['BULAN_ANGGARAN'] . "\n";
            }
        }
        echo "Data tidak ditemukan||||\n";
    }

    function pom_rujukan($id){
        $sipt = & get_instance();
        $this->load->model("main", "main", true);
        $query = "SELECT A.BBPOM_TUJUAN AS KODE, C.NAMA_BBPOM AS URAIAN FROM M_LINGKUP_RUJUKAN_DETIL A LEFT JOIN M_LINGKUP_RUJUKAN B ON A.ID = B.ID LEFT JOIN M_BBPOM C ON A.BBPOM_TUJUAN = C.BBPOM_ID WHERE B.ID = $id AND A.ASAL_WILAYAH = '".$this->newsession->userdata('WILAYAH')."'";     
        $ret = '';
        $data = $sipt->main->get_result($query);
            if($data){
                $ret .= "<option value=\"\"></option>";                     
                foreach($query->result_array() as $row){
                    $ret .= "<option value=\"".$row['KODE']."\">".$row['URAIAN']."</option>";
                }
            }
            echo str_replace(chr(10),'',$ret);
    }

//------------------------------------------------------------
}