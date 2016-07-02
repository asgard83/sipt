<?php if (!defined('BASEPATH'))  exit('No direct script access allowed');

class Home extends Controller
{

    var $content = "";

    function Home()
    {
        parent::Controller();
    }

    function index()
    {
        //print_r($_SESSION);DIE();
        $appname = 'Sistem Informasi Pelaporan Terpadu | versi 1.0';
        if ($this->newsession->userdata('LOGGED_IN') == TRUE) {
            //print_r($_SESSION);die();
            if ($this->content == "")
                $this->content = $this->load->view('welcome_message', '', true);
            $data = array(
                '_appname_' => $appname,
                '_name_' => $this->newsession->userdata('SESS_NAMA_USER'),
                '_header_' => $this->load->view('header/home', '', true),
                '_content_' => $this->content
            );
            $this->parser->parse('home', $data);
        } else {
            $data = array(
                '_appname_' => $appname,
                '_header_' => $this->load->view('header/login', '', true)
            );
            $this->parser->parse('login', $data);
        }
    }

    function pelaporan($jenis = "", $submenu = "", $doc = "", $kk = "", $id = "", $subid = "")
    {
        if (!$this->newsession->userdata('LOGGED_IN')) {
            $this->index();
            return;
        }
        if ($jenis == "pemeriksaan") {
            if ($submenu == "" && array_key_exists('2', $this->newsession->userdata('SESS_KODE_ROLE'))) {
                $this->load->model("pemeriksaan/pemeriksaan_act");
                $arrdata       = $this->pemeriksaan_act->GetFormPemeriksaan();
                $this->content = $this->load->view('pemeriksaan/pemeriksaan', $arrdata, true);
            } else if ($submenu == "view") {
                $this->load->model("pemeriksaan/pemeriksaan_act");
                $arrdata       = $this->pemeriksaan_act->list_pemeriksaan($doc, $kk);
                $this->content = $this->load->view('table', $arrdata, true);
            }
        } else if ($jenis == "pengujian") { #Pengujian
        } else if ($jenis == "sampel") { #Sampel
            $mdl = $submenu . "_act";
            $this->load->model("pengujian/sampel/" . $mdl);
            $arrdata       = $this->$mdl->get_surat($submenu);
            $this->content = $this->load->view('pengujian/sampel/' . $submenu, $arrdata, true);
        } else if ($jenis == "pemantauan") { #Pemantauan Operator
        } else if ($jenis == "rekomendasi") { #Surat Tindak Lanjut
            if ($submenu != "" && $doc != "" && $kk != "") {
                $this->load->model('pemeriksaan/TL_act');
                $arrdata       = $this->TL_act->get_tl($submenu, $doc, $kk, $id, $subid);
                $this->content = $this->load->view('pemeriksaan/tl/surat', $arrdata, true);
            } else {
                return $this->fungsi->redirectMessage('Maaf, halaman yang anda maksud tidak ditemukan.', '/home');
            }
        } else if ($jenis == "petugas") { #Edit Petugas
            if ($submenu != "" && $doc != "" && $kk != "") {
                $this->load->model('pemeriksaan/pemeriksaan_act');
                $arrdata       = $this->pemeriksaan_act->get_petugas($submenu, $doc, $kk, $id, $subid);
                $this->content = $this->load->view('pemeriksaan/petugas', $arrdata, true);
            } else {
                return $this->fungsi->redirectMessage('Maaf, halaman yang anda maksud tidak ditemukan.', '/home');
            }
        } else {
            return $this->fungsi->redirectMessage('Maaf, halaman yang anda maksud tidak ditemukan.', '/home');
        }
        $this->index();
    }

    function pemeriksaan($sarana = "", $jenis = "", $klasifikasi = "", $idperiksa = "")
    {
        
        if (!$this->newsession->userdata('LOGGED_IN')) {
            $this->index();
            return;
        }
        if (array_key_exists('01', $this->newsession->userdata('SESS_JENIS_PELAPORAN')) && (array_key_exists('2', $this->newsession->userdata('SESS_KODE_ROLE')))) { #Pemeriksaan Operator
            if (!in_array($jenis, $this->config->item('m_jenis')))
                return $this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.', '/home');
            $mdl = "F" . $jenis;
            $frm = "GetForm" . $jenis;
            if ($jenis == "01ON" || $jenis == "02MN" || $jenis == "02TN" || $jenis == "03AN" || $jenis == "03BN" || $jenis == "03NN" || $jenis == "03TP" || $jenis == "03RN" || $jenis == "03WN") { #Ditwas Napza
                $this->load->model('pemeriksaan/FNapza');
                $arrdata       = $this->FNapza->GetFormNapza($sarana, $jenis, $klasifikasi, $idperiksa);
                $this->content = $this->load->view('pemeriksaan/NAPZA', $arrdata, true);
            } else if ($jenis == "03TR") {
                $this->load->model('pemeriksaan/F02TR');
                $arrdata       = $this->F02TR->GetForm02TR($sarana, $jenis, $klasifikasi, $idperiksa);
                $this->content = $this->load->view('pemeriksaan/02TR', $arrdata, true);
            } else {
                $this->load->model('pemeriksaan/' . $mdl);
                $arrdata       = $this->$mdl->$frm($sarana, $jenis, $klasifikasi, $idperiksa);
                $this->content = $this->load->view('pemeriksaan/' . $jenis, $arrdata, true);
            }
        } else {
            return $this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.', '/home');
        }
        $this->index();
    }

    function produk($act = "", $sarana = "", $jenis = "", $klasifikasi = "", $idperiksa = "", $subid = "")
    {
        if (!$this->newsession->userdata('LOGGED_IN')) {
            $this->index();
            return;
        }
        if ($idperiksa == "")
            return $this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.', '/home');
        if ($act == "add") {
            $this->load->model("pemeriksaan/tproduk_act");
            $arrdata       = $this->tproduk_act->list_produk($sarana, $jenis, $klasifikasi, $idperiksa, $subid);
            $this->content = $this->load->view('pemeriksaan/produk', $arrdata, true);
        } else if ($act == "view") {
            $this->load->model("pemeriksaan/tproduk_act");
            $arrdata       = $this->tproduk_act->view_produk($sarana, $jenis, $klasifikasi, $idperiksa);
            $this->content = $this->load->view('table', $arrdata, true);
        } else {
            return $this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.', '/home');
        }

        $this->index();
    }

    function proses($sarana = "", $jenis = "", $klasifikasi = "", $idperiksa = "", $subid = "")
    {
        if (!$this->newsession->userdata('LOGGED_IN')) {
            $this->index();
            return;
        }
        if ($idperiksa == "")
            return $this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.', '/home');
        if (!in_array($jenis, $this->config->item('m_jenis')))
            return $this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.', '/home');
        $mdl = "F" . $jenis;
        if ($jenis == "01ON" || $jenis == "02MN" || $jenis == "02TN" || $jenis == "03AN" || $jenis == "03BN" || $jenis == "03NN" || $jenis == "03TP" || $jenis == "03RN" || $jenis == "03WN") {
            $this->load->model('pemeriksaan/FNapza');
            $arrdata       = $this->FNapza->input_preview($sarana, $jenis, $idperiksa, $subid);
            $this->content = $this->load->view('pemeriksaan/preview/napza/proses', $arrdata, true);
        } else if ($jenis == "03TR") {
            $this->load->model('pemeriksaan/F02TR');
            $arrdata       = $this->F02TR->input_preview($sarana, $jenis, $idperiksa, $subid);
            $this->content = $this->load->view('pemeriksaan/preview/02TR/proses', $arrdata, true);
        } else {
            $this->load->model('pemeriksaan/' . $mdl);
            $arrdata       = $this->$mdl->input_preview($sarana, $jenis, $idperiksa, $subid);
            $this->content = $this->load->view('pemeriksaan/preview/' . $jenis . '/proses', $arrdata, true);
        }
        $this->index();
    }

    function prioritas($jenis, $menu, $submenu, $id = ""){
        if (!$this->newsession->userdata('LOGGED_IN')) {
            $this->index();
            return;
        }
        if($jenis == "") $this->fungsi->redirectMessage('Maaf, halaman yang anda tuju tidak ditemukan.', '/home');
        if($jenis == "kategori"){
            $this->load->model('master/kategori_act');
            if($menu== ""){
                $this->content = $this->load->view('master/kategori-sampling', $arrdata, true);
            }else{
                if($menu == "new"){
                    $arrdata = $this->kategori_act->get_kategori($submenu);
                    $arrsubmenu = array('0110','0111','0112','0113');
                    //if($submenu == "0110"){                       
                        //$this->content = $this->load->view('master/form-kategori-i',$arrdata,true);
                    //}else
                    
                    if(in_array($submenu,$arrsubmenu)){
                        if($submenu == "0110"){
                            
                            $this->content = $this->load->view('master/form-kategori-i',$arrdata,true);
                        }else{
                            $this->content = $this->load->view('master/form-kategori-f',$arrdata,true);
                        }
                    }else{ 
                        
                        $this->content = $this->load->view('master/form-kategori-sampling',$arrdata,true);
                    }
                }else{
                    if($menu == "01"){
                        $arrdata = $this->kategori_act->kategori_01($submenu);
                    }else if($menu == "10"){
                        $arrdata = $this->kategori_act->kategori_10();
                    }else if($menu == "11"){
                        $arrdata = $this->kategori_act->kategori_11();
                    }else if($menu == "12"){
                        $arrdata = $this->kategori_act->kategori_12();
                    }else if($menu == "13"){
                        $arrdata = $this->kategori_act->kategori_13();
                    }else if($menu == "14"){
                        $arrdata = $this->kategori_act->kategori_14();
                    }
                    $this->content = $this->load->view('table', $arrdata, true);
                }
            }
        }else if($jenis == "parameter-uji"){
            $this->load->model('master/prioritas_act');
            if($menu== ""){
                $this->content = $this->load->view('master/parameter-uji-prioritas', $arrdata, true);
            }else{
                if($menu == "new"){
                    $arrdata = $this->prioritas_act->get_prioritas($submenu,$id);
                    if(substr($submenu, 0,2) == '01')
                        $this->content = $this->load->view('master/form-prioritas-sampling-obat', $arrdata, true);
                    else
                        $this->content = $this->load->view('master/form-prioritas-sampling', $arrdata, true);
                }else{
                    if(substr($menu,0,2) == "01"){
                        $arrdata = $this->prioritas_act->list_01($menu);
                    }else{
                        if($menu == "10"){
                            $arrdata = $this->prioritas_act->list_10($menu);
                        }else if($menu == "11"){
                            $arrdata = $this->prioritas_act->list_11($menu);
                        }else if($menu == "12"){
                            $arrdata = $this->prioritas_act->list_12($menu);
                        }else if($menu == "13"){
                            $arrdata = $this->prioritas_act->list_13($menu);
                        }else if($menu == "14"){
                            $arrdata = $this->prioritas_act->list_14($menu);
                        }
                    }
                    $this->content = $this->load->view('table', $arrdata, true);
                }
            }
        }
        $this->index();
    }

    function master($jenis = "", $submenu = "", $id = "", $isPrev = FALSE)
    {
        if (!$this->newsession->userdata('LOGGED_IN')) {
            $this->index();
            return;
        }
        if ($jenis == "sarana") {
            if ($submenu == "new") {
                $this->load->model("master/sarana_act");
                $arrdata       = $this->sarana_act->get_sarana($id);
                $this->content = $this->load->view('master/sarana', $arrdata, true);
            } else {
                $this->load->model("master/sarana_act");
                $arrdata       = $this->sarana_act->list_sarana();
                $this->content = $this->load->view('table', $arrdata, true);
            }
        } else if ($jenis == "web") {
            $this->load->model('master/produk_act');
            $arrdata       = $this->produk_act->list_produk_web();
            $this->content = $this->load->view('table', $arrdata, true);
        } else if ($jenis == "lokal") {
            if ($submenu == "new") {
                $this->load->model("master/produk_act");
                $arrdata       = $this->produk_act->get_produk($id, $isPrev);
                $this->content = $this->load->view('master/produk', $arrdata, true);
            } else {
                $this->load->model('master/produk_act');
                $arrdata       = $this->produk_act->list_produk_lokal();
                $this->content = $this->load->view('table', $arrdata, true);
            }
        } else if ($jenis == "negara") {
            $this->load->model('master/geo_act');
            $arrdata       = $this->geo_act->list_negara();
            $this->content = $this->load->view('table', $arrdata, true);
        } else if ($jenis == "daerah") {
            if ($submenu == "new") {
                $this->load->model("master/geo_act");
                $arrdata       = $this->geo_act->get_daerah($id);
                $this->content = $this->load->view('master/daerah', $arrdata, true);
            } else {
                $this->load->model('master/geo_act');
                $arrdata       = $this->geo_act->list_daerah();
                $this->content = $this->load->view('table', $arrdata, true);
            }
        } else if ($jenis == "pverifikasi") {
            if ($submenu == "new") {
                $this->load->model("admin/verifikasi_act");
                $arrdata       = $this->verifikasi_act->get_verifikasi($id);
                $this->content = $this->load->view('master/verifikasi', $arrdata, true);
            } else {
                $this->load->model('admin/verifikasi_act');
                $arrdata       = $this->verifikasi_act->list_verifikasi();
                $this->content = $this->load->view('table', $arrdata, true);
            }
        } else if ($jenis == "pelanggaran") {
            if ($submenu == "new") {
                $this->load->model("master/pelanggaran_act");
                $arrdata       = $this->pelanggaran_act->get_pelanggaran($id);
                $this->content = $this->load->view('master/pelanggaran', $arrdata, true);
            } else {
                $this->load->model('master/pelanggaran_act');
                $arrdata       = $this->pelanggaran_act->list_pelanggaran();
                $this->content = $this->load->view('table', $arrdata, true);
            }
        } else if ($jenis == "pemasaran") {
            if ($submenu == "list" && $id != "") {
                $this->load->model("master/sarana_act");
                $arrdata       = $this->sarana_act->list_pemasaran($id);
                $this->content = $this->load->view('table', $arrdata, true);
            } else if ($submenu == "new" && $id != "") {
                $this->load->model("master/sarana_act");
                $arrdata       = $this->sarana_act->get_pemasaran($id);
                $this->content = $this->load->view('master/sarana/pemasaran', $arrdata, true);
            } else {
                redirect(site_url() . '/home/master/sarana');
            }
        } else if ($jenis == "izin") {
            if ($submenu == "list" && $id != "") {
                $this->load->model("master/sarana_act");
                $arrdata       = $this->sarana_act->list_izin($id);
                $this->content = $this->load->view('table', $arrdata, true);
            } else if ($submenu == "new" && $id != "") {
                $this->load->model("master/sarana_act");
                $arrdata       = $this->sarana_act->get_izin($id);
                $this->content = $this->load->view('master/sarana/izin', $arrdata, true);
            } else {
                redirect(site_url() . '/home/master/sarana');
            }
        } else if ($jenis == "sertifikat") {
            if ($submenu == "list" && $id != "") {
                $this->load->model("master/sarana_act");
                $arrdata       = $this->sarana_act->list_sertifikat($id);
                $this->content = $this->load->view('table', $arrdata, true);
            } else if ($submenu == "new" && $id != "") {
                $this->load->model("master/sarana_act");
                $arrdata       = $this->sarana_act->get_sertifikat($id);
                $this->content = $this->load->view('master/sarana/sertifikat', $arrdata, true);
            } else {
                redirect(site_url() . '/home/master/sarana');
            }
        } else if ($jenis == "pangan") {
            if ($submenu == "list" && $id != "") {
                $this->load->model("master/sarana_act");
                $arrdata       = $this->sarana_act->list_jenis_pangan($id);
                $this->content = $this->load->view('table', $arrdata, true);
            } else if ($submenu == "new" && $id != "") {
                $this->load->model("master/sarana_act");
                $arrdata       = $this->sarana_act->get_jenis_pangan($id);
                $this->content = $this->load->view('master/sarana/jenis_pangan', $arrdata, true);
            } else {
                redirect(site_url() . '/home/master/sarana');
            }
        } else if ($jenis == "jenis") {
            if ($submenu == "list" && $id != "") {
                $this->load->model("master/sarana_act");
                $arrdata       = $this->sarana_act->list_jenis_distribusi($id);
                $this->content = $this->load->view('table', $arrdata, true);
            } else if ($submenu == "new" && $id != "") {
                $this->load->model("master/sarana_act");
                $arrdata       = $this->sarana_act->get_jenis_distribusi($id);
                $this->content = $this->load->view('master/sarana/jenis_distribusi', $arrdata, true);
            } else {
                redirect(site_url() . '/home/master/sarana');
            }
        } else if ($jenis == "srlpengujian") {
            if ($submenu == "new") {
                $this->load->model("master/srlpengujian_act");
                $arrdata       = $this->srlpengujian_act->get_srl($id);
                $this->content = $this->load->view('master/srlpengujian', $arrdata, true);
            } else {
                $this->load->model("master/srlpengujian_act");
                $arrdata       = $this->srlpengujian_act->list_srl();
                $this->content = $this->load->view('table', $arrdata, true);
            }
        }
        #New Tambahan SRL
        else if ($jenis == "parameter-uji") {
            $this->load->model("master/srlpengujian_act");
            if ($submenu == "") {
                $arrdata       = $this->srlpengujian_act->show_srl();
                $this->content = $this->load->view('master/parameter-uji', $arrdata, true);
            } else if ($submenu == "view" || $submenu == "verifikasi") {
                if ($submenu == "view")
                    $arrdata = $this->srlpengujian_act->list_new_srl($id);
                else if ($submenu == "verifikasi")
                    $arrdata = $this->srlpengujian_act->list_verifikasi_srl($id);
                $this->content = $this->load->view('table', $arrdata, true);
            } else if ($submenu == "preview") {
                $arrdata       = $this->srlpengujian_act->preview_srl($id);
                $this->content = $this->load->view('master/parameter-uji-preview', $arrdata, true);
            }
        }
        #End Tambahan
        else if ($jenis == "golongan") {
            $this->load->model("master/srlpengujian_act");
            if ($submenu == "new") {
                $arrdata       = $this->srlpengujian_act->get_golongan($id);
                $this->content = $this->load->view('master/golongan', $arrdata, true);
            } else if ($submenu == "edit") {
                $arrdata       = $this->srlpengujian_act->get_golongan($id);
                $this->content = $this->load->view('master/golongan-edit', $arrdata, true);
            } else {
                $arrdata       = $this->srlpengujian_act->list_golongan();
                $this->content = $this->load->view('table', $arrdata, true);
            }
        }
        #Master Data Spesifik Lokal
        else if ($jenis == "golongan-spesifik") {
            $this->load->model("master/spesifik_lokal_act");
            if ($submenu == "new") {
                $arrdata       = $this->spesifik_lokal_act->get_golongan($id);
                $this->content = $this->load->view('master/golongan-spesifik', $arrdata, true);
            } else if ($submenu == "edit") {
                $arrdata       = $this->spesifik_lokal_act->get_golongan($id);
                $this->content = $this->load->view('master/golongan-spesifik-edit', $arrdata, true);
            } else {
                $arrdata       = $this->spesifik_lokal_act->list_golongan();
                $this->content = $this->load->view('table', $arrdata, true);
            }
        } else if ($jenis == "parameter-uji-spesifik") {
            $this->load->model("master/spesifik_lokal_act");
            if ($submenu == "" || $submenu == "row") {
                $arrdata       = $this->spesifik_lokal_act->show_srl();
                $this->content = $this->load->view('master/parameter-uji-lokal', $arrdata, true);
            } else if ($submenu == "view") {
                $arrdata       = $this->spesifik_lokal_act->list_new_srl($id);
                $this->content = $this->load->view('table', $arrdata, true);
            } else if ($submenu == "new") {
                $arrdata       = $this->spesifik_lokal_act->get_srl($id);
                $this->content = $this->load->view('master/parameter-uji-lokal-input', $arrdata, true);
            } else if ($submenu == "preview") {
                $arrdata       = $this->spesifik_lokal_act->preview_srl($id);
                $this->content = $this->load->view('master/parameter-uji-lokal-preview', $arrdata, true);
            }
        }
        #End Master Data Spesifik Lokal
        #Master Data BBPOM
        else if ($jenis == "bpom") {
            if ($submenu == "new") {
                $this->load->model("admin/bpom_act");
                $arrdata       = $this->bpom_act->get_bpom($id);
                $this->content = $this->load->view('master/bpom', $arrdata, true);
            } else {
                $this->load->model('admin/bpom_act');
                $arrdata       = $this->bpom_act->list_bpom();
                $this->content = $this->load->view('table', $arrdata, true);
            }
        }
        #End Master Data BBPOM
        #Master Data MEDIA
        else if ($jenis == "mediaIklan") {
            if ($submenu == "new") {
                $this->load->model("master/media_act");
                $arrdata       = $this->media_act->get_media($id);
                $this->content = $this->load->view('master/media_iklan', $arrdata, true);
            } else {
                $this->load->model("master/media_act");
                $arrdata       = $this->media_act->list_media();
                $this->content = $this->load->view('table', $arrdata, true);
            }
        }
        #End Master Data MEDIA
        #Master Data Rokok
        else if($jenis == "rokok"){
            if($submenu == "new"){
            }else{
                $this->load->model("master/rokok_act");
                $arrdata       = $this->rokok_act->list_rokok();
                $this->content = $this->load->view('table', $arrdata, true);        
            }
        }
        #End Master Data Rokok
        else {
            $this->fungsi->redirectMessage('Maaf, halaman yang anda tuju tidak ditemukan.', '/home');
        }
        $this->index();
    }

    function user($jenis = "")
    {
        if (!$this->newsession->userdata('LOGGED_IN')) {
            $this->index();
            return;
        }
        if ($jenis == "profil") {
            $this->load->model("master/user_act");
            $arrdata       = $this->user_act->getFormProfil();
            $this->content = $this->load->view('user/profil', $arrdata, true);
        } else if ($jenis == "password") {
            $arrdata       = "";
            $this->content = $this->load->view('user/password', $arrdata, true);
        } else {
            $this->fungsi->redirectMessage('Maaf, halaman yang anda tuju tidak ditemukan.', '/home');
        }
        $this->index();
    }

    function utility($jenis = "", $subjenis = "", $id = "", &$prev = "")
    {
        if (!$this->newsession->userdata('LOGGED_IN')) {
            $this->index();
            return;
        }
        $this->load->model('admin/utility_act');
        if ($jenis == "log") {
            $arrdata       = $this->utility_act->log_aktivitas();
            $this->content = $this->load->view('table', $arrdata, true);
        } else if ($jenis == "wslog") {
            $arrdata       = $this->utility_act->ws_logsinkronisasi();
            $this->content = $this->load->view('table', $arrdata, true);
        } else if ($jenis == "session") {
            $arrdata       = $this->utility_act->list_session();
            $this->content = $this->load->view('utility/session', $arrdata, true);
        } else if ($jenis == "sarana") {
            $arrdata       = array(
                'idjudul' => 'judulpmnsarana',
                'caption_header' => 'Grafik Pemeriksaan Sarana'
            );
            $this->content = $this->load->view('utility/chart01', $arrdata, true);
        } else if ($jenis == "grafik") {
            if ($subjenis == "pemeriksaan") {
                $this->load->model('admin/dashboard_act');
                $arrdata       = $this->dashboard_act->get_chart();
                $this->content = $this->load->view('utility/pemeriksaan', $arrdata, true);
            }
        } else if ($jenis == "news") {
            if ($subjenis == "" || $id == "row") {
                $arrdata       = $this->utility_act->list_news();
                $this->content = $this->load->view('table', $arrdata, true);
            } else if ($subjenis == "new") {
                $arrdata       = $this->utility_act->get_news($id);
                $this->content = $this->load->view('utility/news', $arrdata, true);
            }
        } else if ($jenis == "faq") {
            if ($subjenis == "new") {
                $prev          = FALSE;
                $arrdata       = $this->utility_act->get_faq($id, $prev);
                $this->content = $this->load->view('utility/faq', $arrdata, true);
            } else {
                $arrdata       = $this->utility_act->list_faq($subjenis);
                $this->content = $this->load->view('table', $arrdata, true);
            }
        } else if ($jenis == "reference") {
            if ($subjenis == "new") {
                $prev          = FALSE;
                $arrdata       = $this->utility_act->get_reference($id, $prev);
                $this->content = $this->load->view('utility/reference', $arrdata, true);
            }
        } else {
            $this->fungsi->redirectMessage('Maaf, halaman yang anda tuju tidak ditemukan.', '/home');
        }
        $this->index();
    }

    function bap($sarana = "", $jenis = "", $klasifikasi = "", $idperiksa = "")
    {
        if (!$this->newsession->userdata('LOGGED_IN')) {
            redirect(base_url());
            return;
        }
        if ($idperiksa == "")
            return $this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.', '/home');
        if (!in_array($jenis, $this->config->item('m_jenis')))
            return $this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.', '/home');
        $mdl   = "F" . $jenis;
        $ffile = "";
        if ($jenis == "01ON" || $jenis == "02MN" || $jenis == "02TN" || $jenis == "03AN" || $jenis == "03BN" || $jenis == "03NN" || $jenis == "03TP" || $jenis == "03RN" || $jenis == "03WN") {
            $this->load->model('pemeriksaan/FNapza');
            $bap = $this->FNapza->set_bap($sarana, $jenis, $idperiksa, $subid);
        } else if ($jenis == "02LL" || $jenis == "02MM" || $jenis == "02TF" || $jenis == "03AA" || $jenis == "03BB" || $jenis == "03RS" || $jenis == "03TR" || $jenis == "03WW") {
            $this->load->model('pemeriksaan/distribusi_act');
            $bap = $this->distribusi_act->set_bap($sarana, $jenis, $idperiksa, $subid);
        } else {
            $this->load->model('pemeriksaan/' . $mdl);
            $bap = $this->$mdl->set_bap($sarana, $jenis, $idperiksa, $subid);
        }
        echo $bap;
    }

    function petugas($jenis = "", $id = "")
    {
        if (!$this->newsession->userdata('LOGGED_IN')) {
            $this->index();
            return;
        }
        if ($jenis == "list") {
            $this->load->model('master/petugas_act');
            $arrdata       = $this->petugas_act->list_petugas($id);
            $this->content = $this->load->view('table', $arrdata, true);
        } else if ($jenis == "new") {
            $this->load->model('master/petugas_act');
            $arrdata       = $this->petugas_act->get_admin_balai($id);
            $this->content = $this->load->view('master/petugas', $arrdata, true);
        }
        $this->index();
    }

    function pejabat($jenis = "", $id = "")
    {
        if (!$this->newsession->userdata('LOGGED_IN')) {
            $this->index();
            return;
        }
        if ($jenis == "list") {
            $this->load->model('master/pejabat_act');
            $arrdata       = $this->pejabat_act->list_pejabat();
            $this->content = $this->load->view('table', $arrdata, true);
        } else if ($jenis == "new") {
            $this->load->model('master/pejabat_act');
            $arrdata       = $this->pejabat_act->get_pejabat($id);
            $this->content = $this->load->view('master/pejabat', $arrdata, true);
        }
        $this->index();
    }

    function tracking($jenis = "", $sub = "", $id = "")
    {
        if (!$this->newsession->userdata('LOGGED_IN')) {
            $this->index();
            return;
        }
        if ($jenis == "")
            return $this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.', '/home');
        $this->load->model('admin/tracking_act');
        if ($jenis == "pemeriksaan") {
            if ($sub == "" || $sub == "row") {
                $arrdata = $this->tracking_act->list_pemeriksaan();
            }
        } else if ($jenis == "produk") {
            if ($sub == "" || $sub == "row") {
                $arrdata = $this->tracking_act->list_produk();
            }
        } else if ($jenis == "sampling") {
            if ($sub == "" || $sub == "row") {
                $arrdata = $this->tracking_act->list_sampling();
            }
        } else if ($jenis == "sampel-deleted") {
            if ($sub == "" || $sub == "row") {
                $arrdata = $this->tracking_act->list_sampling_deleted();
            }
        } else if ($jenis == "rujukan-sent") {
            $this->load->model('admin/trans_act');
            if ($sub == "" || $sub == "row") {
                $arrdata = $this->trans_act->list_rujukan_sent();
            }
        } else if ($jenis == "rujukan-receive") {
            $this->load->model('admin/trans_act');
            if ($sub == "" || $sub == "row") {
                $arrdata = $this->trans_act->list_rujukan_receive();
            }
        } else if ($jenis == "unggulan-sent") {
            $this->load->model('admin/trans_act');
            if ($sub == "" || $sub == "row") {
                $arrdata = $this->trans_act->list_unggulan_sent();
            }
        } else if ($jenis == "unggulan-receive") {
            $this->load->model('admin/trans_act');
            if ($sub == "" || $sub == "row") {
                $arrdata = $this->trans_act->list_unggulan_receive();
            }
        } else if ($jenis == "rujukan-admin") {
            $this->load->model('admin/trans_act');
            if ($sub == "" || $sub == "row") {
                $arrdata = $this->trans_act->list_rujukan_admin();
            }
        } else if ($jenis == "rujukan-receive") {
            if ($sub == "" || $sub == "row") {
                $arrdata = $this->tracking_act->list_sampling_deleted();
            }
        } else if ($jenis == "unggulan-admin") {
            $this->load->model('admin/trans_act');
            if ($sub == "" || $sub == "row") {
                $arrdata = $this->trans_act->list_unggulan_admin();
            }
        } 
        else if($jenis == "spu"){
            if($sub == "" || $sub == "row"){
                $this->load->model('admin/trans_act');
                $arrdata = $this->trans_act->list_spu();
            }
        } else if($jenis == "sps"){
            if($sub == "" || $sub == "row"){
                $this->load->model('admin/trans_act');
                $arrdata = $this->trans_act->list_sps();
            }
        } else if($jenis == "spk"){
            if($sub == "" || $sub == "row"){
                $this->load->model('admin/trans_act');
                $arrdata = $this->trans_act->list_spk();
            }
        } else if($jenis == "spp"){
            if($sub == "" || $sub == "row"){
                $this->load->model('admin/trans_act');
                $arrdata = $this->trans_act->list_spp();
            }
        } else if($jenis == "cp"){
            if($sub == "" || $sub == "row"){
                $this->load->model('admin/trans_act');
                $arrdata = $this->trans_act->list_cp();
            }
        }else if ($jenis == "hasil-uji") {
            if ($sub == "balai" || $sub == "terkirim") {
                if ($id == "" || $id == "row") {
                    $arrdata = $this->tracking_act->list_hasil_uji($sub);
                }
            }
        } else {
            return $this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.', '/home');
        }
        $this->content = $this->load->view('table', $arrdata, true);
        $this->index();
    }

    function cari($jenis, $subjenis, $cari, &$subcari = "")
    {
        if (!$this->newsession->userdata('LOGGED_IN')) {
            $this->index();
            return;
        }
        $this->load->model('admin/tracking_act');
        if ($jenis == "pemeriksaan") {
            $arrdata = $this->tracking_act->tracking_sarana($subjenis, $cari);
        } else if ($jenis == "produk") {
            $arrdata = $this->tracking_act->tracking_produk($subjenis, $cari);
        } else if ($jenis == "sampling") {
            $arrdata = $this->tracking_act->tracking_sampling($subjenis, $cari);
        } else if ($jenis == "sampel-deleted") {
            $arrdata = $this->tracking_act->tracking_sampling_deleted($subjenis, $cari);
        } else if ($jenis == "hasil-uji") {
            $arrdata = $this->tracking_act->tracking_hasiluji($subjenis, $cari, $subcari);
        } else if ($jenis == "spu") {
            $this->load->model('admin/trans_act');
            $arrdata = $this->trans_act->tracking_spu($subjenis, $cari);
        } else if ($jenis == "sps") {
            $this->load->model('admin/trans_act');
            $arrdata = $this->trans_act->tracking_sps($subjenis, $cari);
        } else if ($jenis == "spk") {
            $this->load->model('admin/trans_act');
            $arrdata = $this->trans_act->tracking_spk($subjenis, $cari);
        }else if ($jenis == "spp") {
            $this->load->model('admin/trans_act');
            $arrdata = $this->trans_act->tracking_spp($subjenis, $cari);
        }else if ($jenis == "cp") {
            $this->load->model('admin/trans_act');
            $arrdata = $this->trans_act->tracking_cp($subjenis, $cari);
        }else if ($jenis == "rujukan-sent") {
            $this->load->model('admin/trans_act');
            $arrdata = $this->trans_act->tracking_rujukan_sent($subjenis, $cari);
        }else if ($jenis == "rujukan-receive") {
            $this->load->model('admin/trans_act');
            $arrdata = $this->trans_act->tracking_rujukan_receive($subjenis, $cari);
        }else if ($jenis == "unggulan-sent") {
            $this->load->model('admin/trans_act');
            $arrdata = $this->trans_act->tracking_unggulan_sent($subjenis, $cari);
        }else if ($jenis == "unggulan-receive") {
            $this->load->model('admin/trans_act');
            $arrdata = $this->trans_act->tracking_unggulan_receive($subjenis, $cari);
        }else if ($jenis == "rujukan-admin") {
            $this->load->model('admin/trans_act');
            $arrdata = $this->trans_act->tracking_rujukan_admin($subjenis, $cari);
        }else if ($jenis == "unggulan-admin") {
            $this->load->model('admin/trans_act');
            $arrdata = $this->trans_act->tracking_unggulan_admin($subjenis, $cari);
        }
        else if ($jenis == "sarana") {
            $arrdata = $this->tracking_act->master_sarana($subjenis, $cari);
        } else if ($jenis == "petugas") {
            $arrdata = $this->tracking_act->master_petugas($subjenis, $cari, $subcari);
        }
        $this->content = $this->load->view('table', $arrdata, true);
        $this->index();
    }

    function surveilance($menu = "", $submenu = "", $id = "", $subid = "")
    {
        if ($menu == "") return $this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.', '/home');    
        if($menu == "preview")
        {
            $this->load->model('pengujian/sampel_act');
            $arrdata       = $this->sampel_act->preview($submenu);
            $this->content = $this->load->view('pengujian/sampel/data', $arrdata, true);
        }       
        $this->index();
        
    }
    #--- Data Sampel di Pemdik
    
    function sampel($menu = "", $submenu = "", $id = "", $subid = "")
    {
        if (!$this->newsession->userdata('LOGGED_IN')) {
            $this->index();
            return;
        }
        if ($menu == "")
            return $this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.', '/home');
        if ($menu == "new") {
            $this->load->model('pengujian/sampel_act');
            $arrdata       = $this->sampel_act->get_sampel($submenu);
            $this->content = $this->load->view('pengujian/sampel/new', $arrdata, true);
        }else if($menu == "edit"){
            $this->load->model('pengujian/sampel_act');
            $arrdata       = $this->sampel_act->get_edit($submenu);
            $this->content = $this->load->view('pengujian/sampel/edit', $arrdata, true);
        }else if ($menu == "preview") {
            if (in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) {
                $this->load->model('pengujian/daftar_sampel_act');
                $arrdata       = $this->daftar_sampel_act->get_sampel($submenu);
                $this->content = $this->load->view('pengujian/sampel/tlabsah', $arrdata, true);
            } else {
                $this->load->model('pengujian/sampel_act');
                $arrdata       = $this->sampel_act->preview($submenu);
                $this->content = $this->load->view('pengujian/sampel/data', $arrdata, true);
            }
        }else if($menu == "parameter"){
            $this->load->model('pengujian/sampel_act');
            $arrdata       = $this->sampel_act->get_edit_hasil_pu($submenu);
            $this->content = $this->load->view('pengujian/sampel/edit-hasil-parameter-uji', $arrdata, true);
        }else if($menu == "detil"){
             $this->load->model('pengujian/sampel_act');
             $arrdata       = $this->sampel_act->preview($submenu);
             $this->content = $this->load->view('pengujian/sampel/data', $arrdata, true);
        }else if ($menu == "list") {
            $this->load->model('pengujian/sampel_act');
            $arrdata       = $this->sampel_act->list_sampel($submenu);
            $this->content = $this->load->view('table', $arrdata, true);
        } else if ($menu == "absah") {
            if (in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) {
                $this->load->model('pengujian/daftar_sampel_act');
                $arrdata       = $this->daftar_sampel_act->list_absah($submenu);
                $this->content = $this->load->view('table', $arrdata, true);
            }
        } else {
            return $this->fungsi->redirectMessage('Maaf, halaman yang anda tuju tidak ditemukan.', '/home');
        }
        $this->index();
    }

    #--- Akhir Data Sampel di Pemdik
    #--- Data Sampel Pihak Ke - 3

    function sampelx($menu = "", $submenu = "", $id = "", $subid = "")
    {
        if (!$this->newsession->userdata('LOGGED_IN')) {
            $this->index();
            return;
        }
        if ($menu == "")
            return $this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.', '/home');
        if ($menu == "new") {
            $this->load->model('pengujian/sampelx_act');
            $arrdata       = $this->sampelx_act->get_sampel($submenu);
            $this->content = $this->load->view('pengujian/sampel/newx', $arrdata, true);
        } else if ($menu == "preview") {
            $this->load->model('pengujian/sampelx_act');
            $arrdata       = $this->sampelx_act->preview($submenu);
            $this->content = $this->load->view('pengujian/sampel/datax', $arrdata, true);
        } else if ($menu == "list") {
            $this->load->model('pengujian/sampelx_act');
            $arrdata       = $this->sampelx_act->list_sampel($submenu);
            $this->content = $this->load->view('table', $arrdata, true);
        } else {
            return $this->fungsi->redirectMessage('Maaf, halaman yang anda tuju tidak ditemukan.', '/home');
        }
        $this->index();
    }

    #--- Akhir Data Sampel Sampel Ke - 3
    #--- SPU ---

    function spu($menu = "", $submenu = "", $id = "", $subid = "")
    {
        if (!$this->newsession->userdata('LOGGED_IN')) {
            $this->index();
            return;
        }
        if ($menu == "")
            return $this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.', '/home');
        if ($menu == "list") {
            $this->load->model('pengujian/spu_act');
            $arrdata       = $this->spu_act->list_spu($submenu);
            $this->content = $this->load->view('table', $arrdata, true);
        } else if ($menu == "preview") {
            $this->load->model('pengujian/spu_act');
            $arrdata       = $this->spu_act->preview($submenu);
            $this->content = $this->load->view('pengujian/spu/preview', $arrdata, true);
        } else if ($menu == "detil") {
            $this->load->model('pengujian/spu_act');
            $arrdata       = $this->spu_act->get_detil($submenu);
            $this->content = $this->load->view('pengujian/spu/detail', $arrdata, true);
        } else {
            return $this->fungsi->redirectMessage('Maaf, halaman yang anda tuju tidak ditemukan.', '/home');
        }
        $this->index();
    }

    function spux($menu = "", $submenu = "", $id = "", $subid = "")
    {
        if (!$this->newsession->userdata('LOGGED_IN')) {
            $this->index();
            return;
        }
        if ($menu == "")
            return $this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.', '/home');
        if ($menu == "list") {
            $this->load->model('pengujian/spux_act');
            $arrdata       = $this->spux_act->list_spu($submenu);
            $this->content = $this->load->view('table', $arrdata, true);
        } else if ($menu == "preview") {
            $this->load->model('pengujian/spux_act');
            $arrdata       = $this->spux_act->preview($submenu);
            $this->content = $this->load->view('pengujian/spu/preview', $arrdata, true);
        } else {
            return $this->fungsi->redirectMessage('Maaf, halaman yang anda tuju tidak ditemukan.', '/home');
        }
        $this->index();
    }

    #--- Akhir SPU ---
    #--- SPS ----

    function sps($menu = "", $submenu = "", $id = "", $subid = "")
    {
        if (!$this->newsession->userdata('LOGGED_IN')) {
            $this->index();
            return;
        }
        if ($menu == "")
            return $this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.', '/home');
        if ($menu == "list") {
            $this->load->model('pengujian/spu_act');
            $arrdata       = $this->spu_act->list_sps($submenu);
            $this->content = $this->load->view('table', $arrdata, true);
        } else if ($menu == "view") {
            $this->load->model('pengujian/sp_act');
            $arrdata       = $this->sp_act->get_sp($submenu);
            $this->content = $this->load->view('pengujian/sp/detail', $arrdata, true);
        } else if($menu == "detil"){
            echo $submenu; die();
        }else {
            return $this->fungsi->redirectMessage('Maaf, halaman yang anda tuju tidak ditemukan.', '/home');
        }
        $this->index();
    }

    function spsx($menu = "", $submenu = "", $id = "", $subid = "")
    {
        if (!$this->newsession->userdata('LOGGED_IN')) {
            $this->index();
            return;
        }
        if ($menu == "")
            return $this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.', '/home');
        if ($menu == "list") {
            $this->load->model('pengujian/spux_act');
            $arrdata       = $this->spux_act->list_sps($submenu);
            $this->content = $this->load->view('table', $arrdata, true);
        } else {
            return $this->fungsi->redirectMessage('Maaf, halaman yang anda tuju tidak ditemukan.', '/home');
        }
        $this->index();
    }

    #--- Akhir SPS ---
    #--- Pengujian ---

    function pengujian($menu = "", $submenu = "", $id = "", $subid = "")
    {
        if (!$this->newsession->userdata('LOGGED_IN')) {
            $this->index();
            return;
        }
        if ($menu == "")
            return $this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.', '/home');
        if ($menu == "spu") {
            $this->load->model('pengujian/sp_act');
            $arrdata       = $this->sp_act->get_disposp($submenu);
            $this->content = $this->load->view('pengujian/sp/dispo', $arrdata, true);
        } else if ($menu == "sp") {
            if ($submenu == "list") {
                $this->load->model('pengujian/sp_act');
                $arrdata       = $this->sp_act->list_sp($id);
                $this->content = $this->load->view('table', $arrdata, true);
            } else if ($submenu == "new") {
                $this->load->model('pengujian/sp_act');
                $arrdata       = $this->sp_act->get_sp($id);
                $this->content = $this->load->view('pengujian/sp/new', $arrdata, true);
            }
        } else if ($menu == "spk") {
            if ($submenu == "new") {
                $this->load->model('pengujian/spk_act');
                $arrdata       = $this->spk_act->get_spk($id);
                $this->content = $this->load->view('pengujian/spk/new', $arrdata, true);
            } else if ($submenu == "review") {
                $this->load->model('pengujian/spk_act');
                $arrdata       = $this->spk_act->get_review($id);
                $this->content = $this->load->view('pengujian/spk/review', $arrdata, true);
            } else if ($submenu == "view") {
                $this->load->model('pengujian/spk_act');
                $arrdata       = $this->spk_act->get_view($id);
                $this->content = $this->load->view('pengujian/spk/view', $arrdata, true);
            } else if ($submenu == "detil") {
                $this->load->model('pengujian/spk_act');
                $arrdata       = $this->spk_act->get_detil($id);
                $this->content = $this->load->view('pengujian/spk/detil', $arrdata, true);
            } else if ($submenu == "rujukan") {
                $this->load->model('pengujian/spk_act');
                $arrdata       = $this->spk_act->get_rujukan($id);
                $this->content = $this->load->view('pengujian/spk/new-rujukan', $arrdata, true);
            }
        } else if ($menu == "spp") {
            if ($submenu == "list") {
                $this->load->model('pengujian/spk_act');
                $arrdata       = $this->spk_act->list_spk($id);
                $this->content = $this->load->view('table', $arrdata, true);
            } else if ($submenu == "new") {
                $this->load->model('pengujian/sp_act');
                $arrdata       = $this->sp_act->get_spp($id);
                $this->content = $this->load->view('pengujian/spp/new', $arrdata, true);
            } else if ($submenu == "view") {
                $this->load->model('pengujian/sp_act');
                $arrdata       = $this->sp_act->view_spp($id);
                $this->content = $this->load->view('pengujian/spp/view', $arrdata, true);
            }
        } else if ($menu == "uji") {
            if ($submenu == "list") {
                $this->load->model('pengujian/penguji_act');
                $arrdata       = $this->penguji_act->list_uji($id);
                $this->content = $this->load->view('table', $arrdata, true);
            } else if ($submenu == "new" || $submenu == "view" || $submenu == "review") {
                $this->load->model('pengujian/penguji_act');
                $arrdata = $this->penguji_act->get_uji($id);
                if ($submenu == "new") {
                    $this->content = $this->load->view('pengujian/uji/new', $arrdata, true);
                } else if ($submenu == "review") {
                    $this->content = $this->load->view('pengujian/uji/review', $arrdata, true);
                } else {
                    $this->content = $this->load->view('pengujian/uji/view', $arrdata, true);
                }
            }
        } else if ($menu == "cp") {
            if ($submenu == "new") {
                $this->load->model('pengujian/cp_act');
                $arrdata       = $this->cp_act->get_cp($id);
                $this->content = $this->load->view('pengujian/cp/new', $arrdata, true);
            } else {
                $this->load->model('pengujian/cp_act');
                $arrdata       = $this->cp_act->list_cp($id);
                $this->content = $this->load->view('table', $arrdata, true);
            }
        } else if ($menu == "lhu") {
            if ($submenu == "new") {
                $this->load->model('pengujian/lhu_act');
                $arrdata       = $this->lhu_act->get_lhu($id);
                $this->content = $this->load->view('pengujian/lhu/new', $arrdata, true);
            } else if ($submenu == "konsep") {
                $this->load->model('pengujian/lhu_act');
                $arrdata       = $this->lhu_act->get_lhu($id);
                //print_r($arrdata);die();
                $this->content = $this->load->view('pengujian/lhu/konsep', $arrdata, true);
            } else {
                $this->load->model('pengujian/lhu_act');
                $arrdata       = $this->lhu_act->list_lhu($id);
                $this->content = $this->load->view('table', $arrdata, true);
            }
        } else if ($menu == "data") {
            $this->load->model('pengujian/daftar_sampel_act');
            if ($submenu == "view") {
                $arrdata       = $this->daftar_sampel_act->get_sampel($id);
                $this->content = $this->load->view('pengujian/sampel/rilis', $arrdata, true);
            } else {
                $arrdata       = $this->daftar_sampel_act->list_sampel($submenu, $id);
                $this->content = $this->load->view('table', $arrdata, true);
            }
        } else if($menu == "rujukan"){#data sampel rujukan di kepala balai
            $this->load->model('pengujian/rujukan_act');
            $arrdata       = $this->rujukan_act->list_rujukan($submenu);
            $this->content = $this->load->view('table', $arrdata, true);            
        } else if($menu == "unggulan"){#data sampel unggulan di kepala balai
            $this->load->model('pengujian/unggulan_act');
            $arrdata       = $this->unggulan_act->list_unggulan($submenu);
            $this->content = $this->load->view('table', $arrdata, true);            
        } else if ($menu == "puk") {
            $this->load->model('pengujian/puk_act');
            if ($submenu == "preview") {
                $arrdata       = $this->puk_act->get_puk($id);
                $this->content = $this->load->view('pengujian/puk/preview', $arrdata, true);
            } else {
                $arrdata       = $this->puk_act->list_puk($submenu, $id);
                $this->content = $this->load->view('table', $arrdata, true);
            }
        }  else if ($menu == "surveilance") {
            $this->load->model('pengujian/surveilance_act');
            if($submenu == "view")
            {
                $arrdata       = $this->surveilance_act->get_sampel($id);
                $this->content = $this->load->view('pengujian/surveilance/data', $arrdata, true);
            }
            else if($submenu == "feed-back")
            {
                $arrdata       = $this->surveilance_act->list_feed_back();
                $this->content = $this->load->view('table', $arrdata, true);
            }
            else
            {
                if($this->newsession->userdata('SESS_BBPOM_ID') == '92')
                {
                    if($submenu == "")
                    {
                        $arrdata       = $this->surveilance_act->list_surveilance();
                    }
                    else if($submenu == "sent")
                    {
                        $arrdata       = $this->surveilance_act->list_surveilance_sent();
                    }
                }
                else
                {
                    $arrdata       = $this->surveilance_act->list_surveilance_balai();
                }
                $this->content = $this->load->view('table', $arrdata, true);
            }
        } else {
            return $this->fungsi->redirectMessage('Maaf, halaman yang anda tuju tidak ditemukan.', '/home');
        }
        $this->index();
    }

    #--- Akhir Pengujian ---
    #--- PPOM ----

    function ppomn($act = "", $menu = "", $submenu = "", $id = "", $subid = "")
    {
        if (!$this->newsession->userdata('LOGGED_IN')) {
            $this->index();
            return;
        }
        if ($this->newsession->userdata('SESS_BBPOM_ID') == "99") {
            if ($act == "laporan") {
                $this->load->model('pengujian/ppomn/daftar_sampel_act');
                $arrdata       = $this->daftar_sampel_act->list_sampel($menu, $submenu);
                $this->content = $this->load->view('table', $arrdata, true);
            } else if ($act == "preview" && $menu == "sampel") {
                $this->load->model('pengujian/ppomn/daftar_sampel_act');
                $arrdata       = $this->daftar_sampel_act->get_sampel($submenu);
                $this->content = $this->load->view('pengujian/ppomn/preview/splhasil', $arrdata, true);
            } else if ($act == "sampelx") { #Entri sample di TU PPOMN
                $this->load->model('pengujian/ppomn/sampelx_act');
                if ($menu == "new") {
                    $arrdata       = $this->sampelx_act->get_sampel($submenu);
                    $this->content = $this->load->view('pengujian/ppomn/sampel/newx', $arrdata, true);
                } else if ($menu == "list") {
                    $arrdata       = $this->sampelx_act->list_sampel($submenu);
                    $this->content = $this->load->view('table', $arrdata, true);
                } else if ($menu == "preview") {
                    $arrdata       = $this->sampelx_act->preview($submenu);
                    $this->content = $this->load->view('pengujian/ppomn/sampel/datax', $arrdata, true);
                }
                #Akhir Entri Sampel di TU PPMON
            } else if ($act == "spux") { #Penerimaan Sampel di TPS Bidang
                $this->load->model('pengujian/ppomn/spux_act');
                if ($menu == "preview" && $submenu != "") {
                    $arrdata       = $this->spux_act->preview($submenu);
                    $this->content = $this->load->view('pengujian/ppomn/preview/spu', $arrdata, true);
                } else {
                    $arrdata       = $this->spux_act->list_spu($menu);
                    $this->content = $this->load->view('table', $arrdata, true);
                }
            } else if ($act == "sps") {
                if ($menu == "view") {
                    $this->load->model('pengujian/ppomn/sp_act');
                    $arrdata       = $this->sp_act->get_sp($submenu);
                    $this->content = $this->load->view('pengujian/ppomn/sp/detail', $arrdata, true);
                }
            } else if ($act == "spsx") {
                if ($menu == "list") {
                    $this->load->model('pengujian/ppomn/spux_act');
                    $arrdata       = $this->spux_act->list_sps($submenu);
                    $this->content = $this->load->view('table', $arrdata, true);
                } else {
                    return $this->fungsi->redirectMessage('Maaf, halaman yang anda tuju tidak ditemukan.', '/home');
                } #Proses SPU (Ka. TU dan TPS, Bidang)
            } else if ($act == "pengujian") { #Tambah Surat Perintah Uji
                $this->load->model('pengujian/ppomn/sp_act');
                $arrdata       = $this->sp_act->get_disposp($submenu);
                $this->content = $this->load->view('pengujian/ppomn/sp/dispo', $arrdata, true);
            } else if ($act == "sp") { #MT Verifikasi SPU -> Surat Perintah Kerja
                if ($menu == "list") {
                    $this->load->model('pengujian/ppomn/sp_act');
                    $arrdata       = $this->sp_act->list_sp($submenu);
                    $this->content = $this->load->view('table', $arrdata, true);
                } else if ($menu == "new") {
                    $this->load->model('pengujian/ppomn/sp_act');
                    $arrdata       = $this->sp_act->get_sp($submenu);
                    $this->content = $this->load->view('pengujian/ppomn/sp/new', $arrdata, true);
                }
                #Akhir Menu MT Bidang -> Verifikasi SP
            } else if ($act == "spk") { #Penyelia Penerimaan SPK
                if ($menu == "new") {
                    $this->load->model('pengujian/ppomn/spk_act');
                    $arrdata       = $this->spk_act->get_spk($submenu);
                    $this->content = $this->load->view('pengujian/ppomn/spk/new', $arrdata, true);
                } else if ($menu == "review") {
                    $this->load->model('pengujian/ppomn/spk_act');
                    $arrdata       = $this->spk_act->get_review($submenu);
                    $this->content = $this->load->view('pengujian/ppomn/spk/review', $arrdata, true);
                } else if ($menu == "view") {
                    $this->load->model('pengujian/ppomn/spk_act');
                    $arrdata       = $this->spk_act->get_view($submenu);
                    $this->content = $this->load->view('pengujian/ppomn/spk/view', $arrdata, true);
                }
                #Akhir Penyelia Penerimaan SPK
            } else if ($act == "spp") { #SPP di Penyelia
                if ($menu == "list") {
                    $this->load->model('pengujian/ppomn/spk_act');
                    $arrdata       = $this->spk_act->list_spk($submenu);
                    $this->content = $this->load->view('table', $arrdata, true);
                } else if ($menu == "new") {
                    $this->load->model('pengujian/ppomn/sp_act');
                    $arrdata       = $this->sp_act->get_spp($submenu);
                    $this->content = $this->load->view('pengujian/ppomn/spp/new', $arrdata, true);
                } else if ($menu == "view") {
                    $this->load->model('pengujian/ppomn/sp_act');
                    $arrdata       = $this->sp_act->view_spp($submenu);
                    $this->content = $this->load->view('pengujian/ppomn/spp/view', $arrdata, true);
                }
                #Akhir Penguji Penerimaan SPP
            } else if ($act == "uji") { #Penguji -> Entri, Update Hasil Uji
                $this->load->model('pengujian/ppomn/penguji_act');
                if ($menu == "list") {
                    $arrdata       = $this->penguji_act->list_uji($submenu);
                    $this->content = $this->load->view('table', $arrdata, true);
                } else if ($menu == "new" || $menu == "view" || $menu == "review") {
                    $arrdata = $this->penguji_act->get_uji($submenu);
                    if ($menu == "new") {
                        $this->content = $this->load->view('pengujian/ppomn/uji/new', $arrdata, true);
                    } else if ($menu == "review") {
                        $this->content = $this->load->view('pengujian/ppomn/uji/review', $arrdata, true);
                    } else {
                        $this->content = $this->load->view('pengujian/ppomn/uji/view', $arrdata, true);
                    }
                }
                #End Penguji -> Entri, Update Hasil Uji
            } else if ($act == "cp") {
                $this->load->model('pengujian/ppomn/cp_act');
                if ($menu == "new") {
                    $arrdata       = $this->cp_act->get_cp($submenu);
                    $this->content = $this->load->view('pengujian/ppomn/cp/new', $arrdata, true);
                } else {
                    $arrdata       = $this->cp_act->list_cp($submenu);
                    $this->content = $this->load->view('table', $arrdata, true);
                }
            } else if ($act == "lhu") {
                $this->load->model('pengujian/ppomn/lhu_act');
                if ($menu == "new") {
                    $arrdata       = $this->lhu_act->get_lhu($submenu);
                    $this->content = $this->load->view('pengujian/ppomn/lhu/new', $arrdata, true);
                } else if ($menu == "konsep") {
                    $arrdata       = $this->lhu_act->get_lhu($submenu);
                    $this->content = $this->load->view('pengujian/ppomn/lhu/konsep', $arrdata, true);
                } else {
                    $arrdata       = $this->lhu_act->list_lhu($submenu);
                    $this->content = $this->load->view('table', $arrdata, true);
                }
            } else {
                return $this->fungsi->redirectMessage('Maaf, anda tidak diperkenankan mengakses halaman ini.', '/home');
            }
        } else {
            return $this->fungsi->redirectMessage('Maaf, anda tidak diperkenankan mengakses halaman ini.', '/home');
        }
        $this->index();
    }

    #--- Akhir PPOMN --

    function report($pelaporan = "", $jenis = "")
    {
        if (!$this->newsession->userdata('LOGGED_IN')) {
            $this->index();
            return;
        }
        if ($pelaporan == "pemeriksaan") {
            $this->load->model("report/report_act");
            $arrdata       = $this->report_act->get_pemeriksaan($jenis);
            $this->content = $this->load->view('report/pemeriksaan/' . $jenis, $arrdata, true);
        } else if ($pelaporan == "pengujian") {
            $this->load->model("report/report_act");
            $arrdata       = $this->report_act->get_pengujian($jenis);
            $this->content = $this->load->view('report/pengujian/' . $jenis, $arrdata, true);
        } else {
            return $this->fungsi->redirectMessage('Maaf, halaman yang anda maksud tidak ditemukan.', '/home');
        }
        $this->index();
    }

    function berita($id = "")
    {
        if (!$this->newsession->userdata('LOGGED_IN')) {
            $this->index();
            return;
        }
        $this->load->model('admin/utility_act');
        $arrdata       = $this->utility_act->preview_news($id);
        $this->content = $this->load->view('utility/news_preview', $arrdata, true);
        $this->index();
    }

    function notifikasi($menu = "", $submenu = "", $id = "")
    {
        if (!$this->newsession->userdata('LOGGED_IN')) {
            $this->index();
            return;
        }
        if ($menu == "bahan-berbahaya") {
            if ($submenu == "new" || $id == "row") {
                $this->load->model('pemeriksaan/f02bb');
                $arrdata       = $this->f02bb->notif($submenu);
                $this->content = $this->load->view('table', $arrdata, true);
            } else if ($submenu == "view") {
                $this->load->model('pemeriksaan/f02bb');
                $arrdata       = $this->f02bb->preview_notifikasi($id);
                $this->content = $this->load->view('pemeriksaan/preview/02BB/view-notifikasi', $arrdata, true);
            }
        } else if ($menu == "cetak-form") {
            $this->load->model('pemeriksaan/f02bb');
            $arrdata = $this->f02bb->pdf_notifikasi($submenu);
            echo $arrdata;
            die();
        }
        $this->index();
    }

    function surat($menu = "", $sarana = "", $jenis = "", $komoditi = "", $periksa = "", $id = "")
    {
        if ((array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('2', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('9', $this->newsession->userdata('SESS_KODE_ROLE'))) && $this->newsession->userdata('LOGGED_IN') == TRUE) {
            $this->load->model('admin/utility_act');
            if ($menu == "list") {
                $arrdata       = $this->utility_act->list_surat($menu, $sarana, $jenis, $komoditi, $periksa);
                $this->content = $this->load->view('table', $arrdata, true);
            } else if ($menu == "new") {
                $arrdata       = $this->utility_act->get_surat($menu, $sarana, $jenis, $komoditi, $periksa, $id);
                $this->content = $this->load->view('pemeriksaan/surat', $arrdata, true);
            } else if ($menu == "data") {
                $arrdata       = $this->utility_act->get_new_surat($menu, $sarana, $jenis, $komoditi, $periksa);
                $this->content = $this->load->view('pemeriksaan/detil_surat', $arrdata, true);
            }
        }
        $this->index();
    }

    function riwayat($menu = "", $sarana = "", $jenis = "", $komoditi = "", $periksa = "")
    {
        if ((array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('9', $this->newsession->userdata('SESS_KODE_ROLE'))) && $this->newsession->userdata('LOGGED_IN') == TRUE) {
            $this->load->model('admin/utility_act');
            if ($menu == "pemeriksaan") {
                $arrdata       = $this->utility_act->get_riwayat($sarana, $jenis, $komoditi, $periksa);
                $this->content = $this->load->view('pemeriksaan/riwayat', $arrdata, true);
            }
        }
        $this->index();
    }

    function tools($menu = "", $submenu = "")
    {
        if (array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('9', $this->newsession->userdata('SESS_KODE_ROLE'))) {
            $this->load->model('admin/tools_act');
            if ($menu == "target") {
                echo $menu;
            } else if ($menu == "pemeriksaan-sarana") {
                $arrdata       = $this->tools_act->get_pemeriksaan();
                $this->content = $this->load->view('admin/pemeriksaan/tools', $arrdata, true);
            } else if ($menu == "sampling-pengujian") {
                $arrdata       = $this->tools_act->get_pengujian();
                $this->content = $this->load->view('admin/sampling-pengujian/tools', $arrdata, true);
            }
        }
        $this->index();
    }

    function setting($menu){
        if (array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('9', $this->newsession->userdata('SESS_KODE_ROLE'))){
            if($menu == "sampel"){
                $this->load->model('admin/setting_act');
                $arrdata = $this->setting_act->kode_sampel();
                $this->content = $this->load->view('admin/setting/form-sampel', $arrdata, true);
            }else if($menu == "spu"){
                $this->load->model('admin/setting_act');
                $arrdata = $this->setting_act->spu();
                $this->content = $this->load->view('admin/setting/form-spu', $arrdata, true);
            }else if($menu == "sps"){
                $this->load->model('admin/setting_act');
                $arrdata = $this->setting_act->sps();
                $this->content = $this->load->view('admin/setting/form-sps', $arrdata, true);
            }else if($menu == "spk"){
                $this->load->model('admin/setting_act');
                $arrdata = $this->setting_act->spk();
                $this->content = $this->load->view('admin/setting/form-spk', $arrdata, true);
            }else if($menu == "spp"){
                $this->load->model('admin/setting_act');
                $arrdata = $this->setting_act->spp();
                $this->content = $this->load->view('admin/setting/form-spp', $arrdata, true);
            }else if($menu == "uji"){
                $this->load->model('admin/setting_act');
                $arrdata = $this->setting_act->uji();
                $this->content = $this->load->view('admin/setting/form-uji', $arrdata, true);
            }else if($menu == "cp"){
                $this->load->model('admin/setting_act');
                $arrdata = $this->setting_act->cp();
                $this->content = $this->load->view('admin/setting/form-cp', $arrdata, true);
            }else if($menu == "lhu"){
                $this->load->model('admin/setting_act');
                $arrdata = $this->setting_act->lhu();
                $this->content = $this->load->view('admin/setting/form-lhu', $arrdata, true);
            }else{
                return $this->fungsi->redirectMessage('Maaf, halaman yang anda maksud tidak ditemukan.', '/home');
            }

        }
        $this->index();
    }


    function nomor()
    {
        if (array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE'))) {
            $this->load->model("admin/utility_act");
            $arrdata       = $this->utility_act->get_sampel();
            $this->content = $this->load->view('utility/reset-nomor', $arrdata, true);
            $this->index();
        }
    }

    function logout()
    {
        $data = array(
            'LOGOUT' => 'GETDATE()'
        );
        $this->db->where('USER_ID', $this->newsession->userdata('SESS_USER_ID'));
        $this->db->update('T_USER', $data);
        $id = $this->newsession->userdata('SESS_USER_ID') . date("dmYHis");
        $this->db->simple_query("INSERT INTO T_USER_LOG(ID, USER_ID, KEGIATAN, WAKTU, IP_ADDRESS) VALUES('" . $id . "','" . $this->newsession->userdata('SESS_USER_ID') . "', 'Logout Dari IP " . $_SERVER['REMOTE_ADDR'] . "',GETDATE(),'" . $_SERVER['REMOTE_ADDR'] . "')");
        $this->newsession->sess_destroy();
        redirect(base_url());
    }

    //    Penandaan Obat
    function penandaan($penandaan = "")
    {
        if (!$this->newsession->userdata('LOGGED_IN') && !in_array('05', $this->newsession->userdata('SESS_JENIS_PELAPORAN'))) {
            $this->fungsi->redirectMessage('Maaf anda tidak bisa mengakses halaman ini.', '/home');
            $this->index();
            return;
        }
        if ($penandaan == "penandaan") {
            $this->load->model("penandaan/penandaan_act");
            $arrdata       = $this->penandaan_act->getFormPenandaanAwal();
            $this->content = $this->load->view('penandaan/penandaan', $arrdata, true);
        } else {
            return $this->fungsi->redirectMessage('Maaf, halaman yang anda maksud tidak ditemukan.', '/home');
        }
        $this->index();
    }

    //   Pemantauan Iklan
    function iklan($pemantauan = "")
    {
        if (!$this->newsession->userdata('LOGGED_IN') && !in_array('03', $this->newsession->userdata('SESS_JENIS_PELAPORAN'))) {
            $this->fungsi->redirectMessage('Maaf anda tidak bisa mengakses halaman ini.', '/home');
            $this->index();
            return;
        }
        if ($pemantauan == "PengawasanIklan") {
            $this->load->model("iklan/iklan_act");
            $arrdata       = $this->iklan_act->getFormIklanAwal();
            $this->content = $this->load->view('iklan/pengawasanIklan', $arrdata, true);
        } else {
            return $this->fungsi->redirectMessage('Maaf, halaman yang anda maksud tidak ditemukan.', '/home');
        }
        $this->index();
    }
    
    function monitoring($pelaporan){
        if($this->newsession->userdata('SESS_BBPOM_ID') == "97"){
            if($pelaporan == "pemeriksaan-pirt"){
                $this->load->model("pemeriksaan/monitoring_act");
                $arrdata       = $this->monitoring_act->list_pirt();
                $this->content = $this->load->view('table', $arrdata, true);
            }else{
                return $this->fungsi->redirectMessage('Maaf, halaman yang anda maksud tidak ditemukan.', '/home');
            }
        }
        $this->index();
    }
    
    #Sampel Rujukan
    function rujukan($menu = "", $submenu = "", $id = "", $subid = ""){
        if (!$this->newsession->userdata('LOGGED_IN')) {
            $this->index();
            return;
        }
        if ($menu == "") return $this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.', '/home');
        if ($menu == "sampel"){
            if($submenu == "draft" || $submenu == "verifikasi" || $submenu == "deliver" || $submenu == "done" || $submenu == "none"  || $submenu == "sent" || $submenu == "all"){
                $this->load->model('pengujian/rujukan/sampel_act');
                $arrdata       = $this->sampel_act->list_rujukan($submenu);
                $this->content = $this->load->view('table', $arrdata, true);
            }else{
                return $this->fungsi->redirectMessage('Maaf, halaman yang anda maksud tidak ditemukan.', '/home');
            }
        }
        else if($menu == "preview"){
            if($submenu == "sampel"){
                $this->load->model('pengujian/rujukan/sampel_act');
                $arrdata = $this->sampel_act->get_sampel($id);
                $this->content = $this->load->view('pengujian/rujukan/data', $arrdata, true);
            }   
        }
        
        $this->index(); 
    }
    #Akhir Sampel Rujukan
    
    #Sampel Unggulan
    function unggulan($menu = "", $submenu = "", $id = "", $subid = ""){
        if (!$this->newsession->userdata('LOGGED_IN')) {
            $this->index();
            return;
        }
        if ($menu == "") return $this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.', '/home');
        if ($menu == "sampel"){
            if($submenu == "draft" || $submenu == "receive"  || $submenu == "verifikasi" || $submenu == "deliver" || $submenu == "done"){

                $this->load->model('pengujian/unggulan/sampel_act');

                $arrdata       = $this->sampel_act->list_unggulan($submenu);
                
                $this->content = $this->load->view('table', $arrdata, true);
            }else{
                return $this->fungsi->redirectMessage('Maaf, halaman yang anda maksud tidak ditemukan.', '/home');
            }
        }
        else if($menu == "preview"){
            if($submenu == "sampel"){
                $this->load->model('pengujian/unggulan/sampel_act');
                $arrdata = $this->sampel_act->get_sampel($id);
                $this->content = $this->load->view('pengujian/unggulan/data', $arrdata, true);
            }   
    }else if($menu == "previewrilis"){
            if($submenu == "sampel"){
                $this->load->model('pengujian/unggulan/sampel_act');
                $arrdata = $this->sampel_act->get_sampel_rilis($id);
                $this->content = $this->load->view('pengujian/unggulan/data', $arrdata, true);
            } 
    }
    
        $this->index(); 
	}
    #Akhir Sampel Unggulan
    
	/**
	* Form Distribusi Lama
	*/
	function distribusi($tipe = "", $sarana = "", $jenis = "", $klasifikasi = "", $idperiksa = "", $subid = "")
    { 
        if (!$this->newsession->userdata('LOGGED_IN')) {
            $this->index();
            return;
        }
        if ($idperiksa == "") return $this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.', '/home');
		
		$arr_distribusi = array('02MM','02LL','02TF','03AA','03BB','03RS','03TR','03WW');
		
		if(!in_array($jenis, $arr_distribusi)) return $this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.', '/home');
		
        $mdl = "F" . $jenis;
		
		if($tipe == "checklist")
		{
            $frm = "GetForm" . $jenis;
			if ($jenis == "03TR") {
                $this->load->model('pemeriksaan/dit0133/F02TR');
                $arrdata       = $this->F02TR->GetForm02TR($sarana, $jenis, $klasifikasi, $idperiksa);
                $this->content = $this->load->view('pemeriksaan/dit0133/02TR', $arrdata, true);
            } else {
                $this->load->model('pemeriksaan/dit0133/' . $mdl);
                $arrdata       = $this->$mdl->$frm($sarana, $jenis, $klasifikasi, $idperiksa);
                $this->content = $this->load->view('pemeriksaan/dit0133/' . $jenis, $arrdata, true);
            }
		}
		else if($tipe == "proses")
		{
			if ($jenis == "03TR") {
				$this->load->model('pemeriksaan/dit0133/F02TR');
				$arrdata       = $this->F02TR->input_preview($sarana, $jenis, $idperiksa, $subid);
				$this->content = $this->load->view('pemeriksaan/dit0133/preview/02TR/proses', $arrdata, true);
			} else {
				$this->load->model('pemeriksaan/dit0133/' . $mdl);
				$arrdata       = $this->$mdl->input_preview($sarana, $jenis, $idperiksa, $subid);
				$this->content = $this->load->view('pemeriksaan/dit0133/preview/' . $jenis . '/proses', $arrdata, true);
			}
		}
		else
		{
			return $this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.', '/home');
		}
        $this->index();
    }
	/**
	* End Form Distribusi Lama
	*/
	

}

?>