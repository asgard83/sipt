<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR);

class Penandaan_act extends Model {
	function getFormPenandaanAwal(){
        if ($this->newsession->userdata('LOGGED_IN') == TRUE) {
            $sipt =& get_instance();
            $this->load->model("main", "main", true);
            $disinput = array("JENISDIS", "NAMADIS");
            $media       = $sipt->main->get_jenis_sarana($this->newsession->userdata("SESS_USER_ID"), $disinput);
            $komoditi    = "'" . join("','", $this->newsession->userdata("SESS_KLASIFIKASI_ID")) . "'";
            $arrayClause = array('demo_1', 'demo_2', 'demo_3', 'demo_4', 'operator-pusat', '1001', '1002', '1003', '1004', '1005', '1006' );
            if (in_array($this->newsession->userdata("SESS_USER_ID"), $arrayClause))
                $klasifikasi = $sipt->main->combobox("SELECT * FROM M_KLASIFIKASI_KATEGORI WHERE LEN(KK_ID) = 3 AND KK_ID IN ($komoditi)", "KK_ID", "NAMA_KK", TRUE);
            else
                $klasifikasi = $sipt->main->combobox("SELECT * FROM M_KLASIFIKASI_KATEGORI WHERE LEN(KK_ID) = 3 AND KK_ID IN ('001')", "KK_ID", "NAMA_KK", TRUE);
            $arrdata = array('act' => site_url() . '/penandaan/penandaanController/setSurat/penandaan',
							 'media' => $media,
							 'disinput' => $disinput,
							 'klasifikasi' => $klasifikasi,
							 'selklasifikasi' => '',
							 'batal' => site_url() . '/home/penandaan/penandaan',
							 'browse' => site_url() . '/load/master/list_sarana'
            );
            return $arrdata;
        } else {
            $this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.', '/home');
        }
    }
    
    function getListFormPenandaan($jenisPelaporan = "", $user = "") {
        if ($this->newsession->userdata('LOGGED_IN') == TRUE) {
            $sipt =& get_instance();
            $this->load->model("main", "main", true);
            $sipt->load->model('penandaan/penandaan_act');
            //$created = "AND TPP2.SERI = (SELECT MAX (SERI) AS SERI FROM T_PENANDAAN_PROSES WHERE PENANDAAN_ID = TP.PENANDAAN_ID AND TP.USER_LAST_UPDATE = TPP2.CREATEDBY)";
            $created = "AND TP.CREATE_BY = '" . $this->newsession->userdata('SESS_USER_ID') . "'";
            if ($jenisPelaporan == "1101"){
                $jenis                            = '1';
                $jenisTxt                         = 'draft';
                $proses['Proses Data Pengawasan'] = array('GET', site_url() . "/penandaan/penandaanController/prosesPreview/preview", '1');
            }
            if ($jenisPelaporan == "0303"){
                $jenis                            = '4';
                $jenisTxt                         = 'draft';
                $proses['Proses Data Pengawasan'] = array('GET', site_url() . "/penandaan/penandaanController/prosesPreview/preview", '1');
            }
            if ($jenisPelaporan == "0313"){
                $jenis                            = '4';
                $jenisTxt                         = 'draft';
                $proses['Proses Data Pengawasan'] = array('GET', site_url() . "/penandaan/penandaanController/prosesPreview/preview", '1');
            }
            if ($jenisPelaporan == "0404"){
                $jenis                            = '3';
                $jenisTxt                         = 'draft';
                $proses['Proses Data Pengawasan'] = array('GET', site_url() . "/penandaan/penandaanController/prosesPreview/preview", '1');
            }
            if ($jenisPelaporan == "0101"){
                $jenis    = '2';
                $jenisTxt = 'draft';
            }
            if ($jenisPelaporan == "1111"){
                $jenis                            = '5';
                $jenisTxt                         = 'draft';
                $proses['Proses Data Pengawasan'] = array('GET', site_url() . "/penandaan/penandaanController/prosesPreview/preview", '1');
            }
            if (in_array('2', $this->newsession->userdata('SESS_KODE_ROLE')) && $jenisTxt == 'draft' && $user == '2') {
                $status = '2050' . $jenis;
                if ((in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))))
                    $status = '2051' . $jenis;
                if ($jenisPelaporan != '0101') {
                    if ($jenisPelaporan == '1101')
                        $proses['Kirim Semua Data'] = array('MPOST', site_url() . "/penandaan/penandaanController/setCheck/ajax", 'N');
                    if ($jenisPelaporan != '1111') {
                        $proses['Edit Data Pengawasan']        = array('GET', site_url() . "/penandaan/penandaanController/prosesEdit/draft", '1');
                        $proses['Edit Surat Tugas Pengawasan'] = array('GET', site_url() . "/penandaan/penandaanController/prosesEdit/suratTugas", '1');
                    }
                } else {
                    $proses['Proses Data Perbaikan Pengawasan'] = array('GET', site_url() . "/penandaan/penandaanController/prosesEdit/draft", '1' );
                    $proses['Edit Surat Tugas Pengawasan']      = array('GET', site_url() . "/penandaan/penandaanController/prosesEdit/suratTugas", '1' );
                }
                $statusJudul = $status;
                
				$where       = " TP.STATUS = '" . $status . "' AND TPP2.CREATEDBY = TP.USER_LAST_UPDATE AND TPP2.STATUS = '" . $status . "' AND CAST(TPP2.PENANDAAN_ID AS VARCHAR) = CAST(TP.PENANDAAN_ID AS VARCHAR) ";
				
				#Created By Disini
            } 
			#Supervisor Satu
			else if (in_array('3', $this->newsession->userdata('SESS_KODE_ROLE')) && $jenisTxt == 'draft' && $user == '3') {
                $status = '3050' . $jenis;
                if (in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) $status = '3051' . $jenis;
                if ($jenisPelaporan != '0101') $proses['Kirim Semua Data'] = array('MPOST', site_url() . "/penandaan/penandaanController/setCheck/ajax", 'N' );
                $proses['Proses Data Pengawasan'] = array('GET', site_url() . "/penandaan/penandaanController/prosesPreview/preview", '1');
                $statusJudul                      = $status;
                //$where = " TP.STATUS = '" . $status . "' AND TPP2.CREATEDBY = TP.USER_LAST_UPDATE AND TPP2.STATUS = '" . $status . "' AND CAST(TPP2.PENANDAAN_ID AS VARCHAR) = CAST(TP.PENANDAAN_ID AS VARCHAR) ";
                $where                            = " TP.STATUS = '" . $status . "'";
            } 
			#Supervisor Dua
			else if (in_array('4', $this->newsession->userdata('SESS_KODE_ROLE')) && $jenisTxt == 'draft' && $user == '4') {
                $status = '4050' . $jenis;
                if (in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) $status = '4051' . $jenis;
                if ($jenisPelaporan != '0101') $proses['Kirim Semua Data'] = array('MPOST', site_url() . "/penandaan/penandaanController/setCheck/ajax", 'N');
                $proses['Proses Data Pengawasan'] = array('GET', site_url() . "/penandaan/penandaanController/prosesPreview/preview", '1');
                $statusJudul                      = $status;
                //$where = " TP.STATUS = '" . $status . "' AND TPP2.CREATEDBY = TP.USER_LAST_UPDATE AND TPP2.STATUS = '" . $status . "' AND CAST(TPP2.PENANDAAN_ID AS VARCHAR) = CAST(TP.PENANDAAN_ID AS VARCHAR) ";
                $where                            = " TP.STATUS = '" . $status . "'";
            } 
			#Kepala Balai
			else if (in_array('5', $this->newsession->userdata('SESS_KODE_ROLE')) && $jenisTxt == 'draft' && $user == '5') {
                $status = '5050' . $jenis;
                if ($jenisPelaporan != '0101') $proses['Kirim Semua Data'] = array('MPOST', site_url() . "/penandaan/penandaanController/setCheck/ajax", 'N');
                $proses['Proses Data Pengawasan'] = array('GET', site_url() . "/penandaan/penandaanController/prosesPreview/preview", '1');
                $statusJudul                      = $status;
                //$where = " TP.STATUS = '" . $status . "' AND TPP2.CREATEDBY = TP.USER_LAST_UPDATE AND TPP2.STATUS = '" . $status . "' AND CAST(TPP2.PENANDAAN_ID AS VARCHAR) = CAST(TP.PENANDAAN_ID AS VARCHAR) ";
                $where                            = " TP.STATUS = '" . $status . "'";
            }
			
			#Direktur 
            if ($jenisPelaporan == "1221" || $jenisPelaporan == "1222") {
                if (in_array('6', $this->newsession->userdata('SESS_KODE_ROLE'))) {
                    $status                           = '60511';
                    $statusJudul                      = $status;
                    $proses['Tutup Kasus']            = array('MPOST', site_url() . "/penandaan/penandaanController/setCheck/ajax", 'N');
                    $proses['Proses Data Pengawasan'] = array('GET', site_url() . "/penandaan/penandaanController/prosesPreview/preview", '1');
                } else {
                    $this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.', '/home');
                }
                //$where = " TP.STATUS = '" . $status . "' AND TPP2.CREATEDBY = TP.USER_LAST_UPDATE AND TPP2.STATUS = '" . $status . "' AND CAST(TPP2.PENANDAAN_ID AS VARCHAR) = CAST(TP.PENANDAAN_ID AS VARCHAR) ";
                $where = " TP.STATUS = '" . $status . "'";
            }
            if ($jenisPelaporan == "1212") {
                $status  = $sipt->penandaan_act->statusSend();
                $created = " AND TPP2.SERI = (SELECT dbo.GET_PENANDAAN_TERKIRIM(TP.PENANDAAN_ID, '" . $this->newsession->userdata('SESS_USER_ID') . "'))";
                if (count($this->newsession->userdata('SESS_KODE_ROLE')) > 1) {
                    $judul       = "Data - Terkirim";
                    $statusJudul = "data";
                } else {
                    if (in_array('2', $this->newsession->userdata('SESS_KODE_ROLE'))) {
                        $statusJudul = '20504';
                        if (in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')))
                            $statusJudul = '20514';
                    }
                    if (in_array('3', $this->newsession->userdata('SESS_KODE_ROLE'))) {
                        $statusJudul = '30505';
                        if (in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')))
                            $statusJudul = '30515';
                    }
                    if (in_array('4', $this->newsession->userdata('SESS_KODE_ROLE'))) {
                        $statusJudul = '40504';
                        if (in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')))
                            $statusJudul = '40514';
                    }
                    if (in_array('5', $this->newsession->userdata('SESS_KODE_ROLE'))) {
                        $statusJudul = '50504';
                    }
                    if (in_array('6', $this->newsession->userdata('SESS_KODE_ROLE'))) {
                        $status = '20501';
                    }
                }
                $proses['Lihat Data Pengawasan'] = array('GET', site_url() . "/penandaan/penandaanController/prosesPreview/preview", '1');
                $where                           = " TP.STATUS IN (" . $status . ") ";
            }
            if ($jenisPelaporan == "1122") {
                $proses['Cetak Hasil Penilaian'] = array('GET', site_url() . "/penandaan/penandaanController/cetakPenilaian/cetakan", '1');
                $status                          = '60510';
                $statusJudul                     = $status;
                $proses['Lihat Data Pengawasan'] = array('GET', site_url() . "/penandaan/penandaanController/prosesPreview/preview", '1');
                //$where = " TP.STATUS = '" . $status . "' AND TPP2.CREATEDBY = TP.USER_LAST_UPDATE AND TPP2.STATUS = TP.STATUS AND CAST(TPP.PENANDAAN_ID AS VARCHAR) = CAST(TP.PENANDAAN_ID AS VARCHAR) ";
                $where                           = " TP.STATUS = '" . $status . "'";
            }
            if ($jenisPelaporan == "2111") {
                if (in_array('3', $this->newsession->userdata('SESS_KODE_ROLE'))) {
                    $status      = '30504';
                    $statusJudul = $status;
                } else if (in_array('4', $this->newsession->userdata('SESS_KODE_ROLE')))
                    $status = '50501';
                else if (in_array('5', $this->newsession->userdata('SESS_KODE_ROLE')))
                    $status = '60505';
                else if (in_array('6', $this->newsession->userdata('SESS_KODE_ROLE')))
                    $status = '20501';
                $role  = 'ditolak';
                //$where = " TP.STATUS = '" . $status . "' AND TPP.CREATEDBY = TP.USER_LAST_UPDATE AND TPP.STATUS = '" . $status . "' AND CAST(TPP.PENANDAAN_ID AS VARCHAR) = CAST(TP.PENANDAAN_ID AS VARCHAR) ";
                $where = " TP.STATUS = '" . $status . "'";
            }
			
            /*if ($jenisPelaporan == "0101") {
                $created = " AND TPP2.SERI = (SELECT dbo.GET_PENANDAAN_TERKIRIM(TP.PENANDAAN_ID, '" . $this->newsession->userdata('SESS_USER_ID') . "'))";
            }*/
			
            $this->load->library('newtable');
            $this->newtable->action(site_url() . "/penandaan/penandaanController/setListFormPenandaanLanjutan/" . $jenisPelaporan . "/" . $user);
            $this->newtable->detail(site_url() . "/penandaan/penandaanController/setPreview/" . $jenisPelaporan);
            $this->newtable->cidb($this->db);
            $this->newtable->ciuri($this->uri->segment_array());
            if ((in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) && $jenisPelaporan != "1101")
                $this->newtable->hiddens(array('PENANDAANID','LASTUPDATEROW'));
            else
                $this->newtable->hiddens(array('PENANDAANID', 'LASTUPDATEROW', 'BB / BPOM'));
            $this->newtable->keys(array('PENANDAANID'));
            $this->newtable->search(array(
                array(
                    "(CASE WHEN TP.KOMODITI = '013' THEN '<div>'+dbo.GET_KOMODITI(TP.KOMODITI)+'<b> &raquo '+(SELECT A.JENIS + ' (' + A.JENIS_PENGAWASAN + ')' FROM T_PENANDAAN_PANGAN A WHERE A.PENANDAAN_ID = TP.PENANDAAN_ID)+'</b></div>' ELSE dbo.GET_KOMODITI(TP.KOMODITI) END)",
                    'Komoditi'
                ),
                array(
                    'TPP.NAMA_PRODUK',
                    'Nama Produk'
                ),
                array(
                    'CONVERT(VARCHAR(10), TP.TANGGAL_MULAI, 120)',
                    'Tanggal Awal Periksa'
                ),
                array(
                    'CONVERT(VARCHAR(10), TP.TANGGAL_AKHIR, 120)',
                    'Tanggal Akhir Periksa'
                ),
                array(
                    '{IN}TP.PENANDAAN_ID IN (SELECT Y.PENANDAAN_ID FROM T_PENANDAAN Y WHERE Y.PENANDAAN_ID IN(SELECT TSTP.SURAT_ID FROM T_SURAT_TUGAS_PENANDAAN TSTP WHERE TSTP.SURAT_ID = Y.SURAT_ID AND TSTP.NOMOR_SURAT {LIKE}))',
                    'Nomor Surat Tugas'
                )
            ));
            //      $proses['Data Petugas Pemeriksa'] = array('GET', site_url() . "/home/pelaporan/petugas", '1');
            //      $proses['Hapus Data Pemeriksaan'] = array('POST', site_url() . "/post/pemeriksaan/hapus_act/delete/ajax", 'N');
            $query .= "SELECT TP.LAST_UPDATE AS LASTUPDATEROW, (CAST(TP.PENANDAAN_ID AS VARCHAR)+'/'+TP.KOMODITI+'/'+CAST(TP.STATUS AS VARCHAR))+'/$jenisPelaporan/$user'+'/'+CAST(TP.BBPOM_ID AS VARCHAR) AS PENANDAANID,
                TPP.NAMA_PRODUK+'<div>'+TPP.BENTUK_SEDIAAN+'</div><div>'+TPP.PRODUSEN+'</div><div><b><a href=\"#\" class=\"row_preview\">Lihat Data</a></b><div>' AS 'PENGAWASAN PENANDAAN',
                CONVERT(VARCHAR(10), TP.TANGGAL_MULAI, 120)+'<div>Sampai Dengan</div><div>'+CONVERT(VARCHAR(10), TP.TANGGAL_AKHIR, 120)+'</div>' AS 'TANGGAL PENGAWASAN',  '<div><b>'+MB.NAMA_BBPOM+'</b></div>' AS 'BB / BPOM',
                (CASE WHEN TP.KOMODITI = '013' THEN '<div>'+dbo.GET_KOMODITI(TP.KOMODITI)+'<b> &raquo '+(SELECT A.JENIS + ' (' + A.JENIS_PENGAWASAN + ')' FROM T_PENANDAAN_PANGAN A WHERE A.PENANDAAN_ID = TP.PENANDAAN_ID)+'</b></div>' ELSE dbo.GET_KOMODITI(TP.KOMODITI) END) AS KOMODITI,
                MT.URAIAN AS 'STATUS TERAKHIR', '<div><b>'+dbo.GET_PROPINSI(MS.PROPINSI)+'</b></div>' AS PROPINSI,
                dbo.GET_HISTORY_PENANDAAN('PENGAWASAN', TP.PENANDAAN_ID)+'<div>'+dbo.GET_HISTORY_PENANDAAN('CATATAN', TP.PENANDAAN_ID)+'</div><div><a href=\"#\" class=\"row_riwayat2\" record=\"'+CAST(TP.PENANDAAN_ID AS VARCHAR)+'#T_PENANDAAN_PROSES\">Riwayat Pemeriksaan</a></div>' AS [UPDATE TERAKHIR]
                FROM T_PENANDAAN TP
                LEFT JOIN T_PENANDAAN_PROSES TPP2 ON TPP2.PENANDAAN_ID = TP.PENANDAAN_ID
                LEFT JOIN T_PENANDAAN_PRODUK TPP ON TPP.PENANDAAN_ID = TP.PENANDAAN_ID
                LEFT JOIN T_USER TU ON TU.USER_ID = TP.USER_LAST_UPDATE
                LEFT JOIN M_TABEL MT ON MT.KODE = TP.STATUS
                LEFT JOIN M_SARANA MS ON MS.SARANA_ID = TP.SARANA_ID
                LEFT JOIN M_BBPOM MB ON TP.BBPOM_ID = MB.BBPOM_ID
                WHERE " . $where . " $created AND TP.KOMODITI IN(" . "'" . join("','", $this->newsession->userdata("SESS_KLASIFIKASI_ID")) . "'" . ")";
            if (!in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) {
                $query .= " AND TP.BBPOM_ID = '" . $this->newsession->userdata('SESS_BBPOM_ID') . "'";
                //if ($jenisPelaporan != "1212") {
                //	$query .= "AND TP.USER_LAST_UPDATE = '".$this->newsession->userdata('SESS_USER_ID') . "'";
                //}
            }
            if ($jenisPelaporan == "1222" && in_array('6', $this->newsession->userdata('SESS_KODE_ROLE'))) {
                $query .= " AND TP.BBPOM_ID = '92'";
                $subJudul = 'Data Pusat';
            }
            if ($jenisPelaporan == "1221" && in_array('6', $this->newsession->userdata('SESS_KODE_ROLE'))) {
                $query .= " AND TP.BBPOM_ID <> '92'";
                $subJudul = 'Data Balai';
            } //echo $query;
            $this->newtable->columns(array(
                "TP.LAST_UPDATE",
                "(CAST(TP.PENANDAAN_ID AS VARCHAR)+'/'+TP.KOMODITI+'/'+CAST(TP.STATUS AS VARCHAR))+'/$jenisPelaporan/$user'+'/'+CAST(TP.BBPOM_ID AS VARCHAR)",
                "'<b><a href=\"#\" class=\"row_preview\">'+TPP.NAMA_PRODUK+'</a></b><div>'+TPP.BENTUK_SEDIAAN+'</div><div>'+TPP.PRODUSEN+'</div>'",
                "CONVERT(VARCHAR(10), TP.TANGGAL_MULAI, 120)+'<div>Sampai Dengan</div><div>'+CONVERT(VARCHAR(10), TP.TANGGAL_AKHIR, 120)+'</div>'",
                "MB.NAMA_BBPOM",
                "(CASE WHEN TP.KOMODITI = '013' THEN '<div>'+dbo.GET_KOMODITI(TP.KOMODITI)+'<b> &raquo '+(SELECT A.JENIS + ' (' + A.JENIS_PENGAWASAN + ')' FROM T_PENANDAAN_PANGAN A WHERE A.PENANDAAN_ID = TP.PENANDAAN_ID)+'</b></div>' ELSE dbo.GET_KOMODITI(TP.KOMODITI) END)",
                "MT.URAIAN",
                "'<div><b>'+dbo.GET_PROPINSI(MS.PROPINSI)+'</b></div>'",
                "dbo.GET_HISTORY_PENANDAAN('PENGAWASAN', TP.PENANDAAN_ID)+'<div>'+dbo.GET_HISTORY_PENANDAAN('CATATAN', TP.PENANDAAN_ID)+'</div><div><a href=\"#\" class=\"row_riwayat2\" record=\"'+CAST(TP.PENANDAAN_ID AS VARCHAR)+'#T_PENANDAAN_PROSES\">Riwayat Pemeriksaan</a></div>'"
            ));
            $this->newtable->width(array(
                'PENGAWASAN PENANDAAN' => 300,
                'TANGGAL PENGAWASAN' => 150,
                'KOMODITI' => 80,
                'BB / BPOM' => 70,
                'STATUS TERAKHIR' => 135,
                'PROPINSI' => 115,
                'UPDATE TERAKHIR' => 135
            ));
            $this->newtable->orderby(1);
            $this->newtable->sortby("DESC");
            $this->newtable->menu($proses);
            $tabel = $this->newtable->generate($query);
            if ($statusJudul != 'data')
                $judul = $sipt->main->get_uraian("SELECT URAIAN FROM M_TABEL WHERE JENIS = 'STATUS' AND KODE = $statusJudul", "URAIAN");
            $arrdata = array(
                'table' => $tabel,
                'idjudul' => 'judulpmnpdd',
                'caption_header' => $judul . " " . $subJudul,
                'batal' => '',
                'cancel' => ''
            );
            return $arrdata;
        } else {
            $this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.', '/home');
        }
    }
    
    function getSurat($penandaanId, $klasifikasiSel) {
        $sipt =& get_instance();
        $sipt->load->model("main", "main", true);
        $query = "SELECT TSTP.SURAT_ID, TSTP.PETUGAS, TU.NAMA_USER, TSTP.NOMOR_SURAT, CONVERT(VARCHAR(10), TSTP.TANGGAL, 103) AS TANGGAL, MB.NAMA_BBPOM, TP.KOMODITI FROM T_SURAT_TUGAS_PENANDAAN TSTP LEFT JOIN T_USER TU ON TU.USER_ID  = TSTP.PETUGAS LEFT JOIN M_BBPOM MB ON MB.BBPOM_ID  = TU.BBPOM_ID LEFT JOIN T_PENANDAAN TP ON TP.SURAT_ID  = TSTP.SURAT_ID WHERE TP.PENANDAAN_ID IN ($penandaanId)";
        $data  = $sipt->main->get_result($query);
        if ($data) {
            foreach ($query->result_array() as $row) {
                $arrdata['suratTugas']     = $row['NOMOR_SURAT'];
                $arrdata['tanggalSurat']   = $row['TANGGAL'];
                $arrdata['suratId']        = $row['SURAT_ID'];
                $user[]                    = $row['NAMA_USER'];
                $userId[]                  = $row['PETUGAS'];
                $arrdata['selKlasifikasi'] = $row['KOMODITI'];
            }
        }
        $arrdata['petugas']     = $user;
        $arrdata['petugasId']   = $userId;
        $arrdata['klasifikasi'] = $sipt->main->combobox("SELECT * FROM M_KLASIFIKASI_KATEGORI WHERE LEN(KK_ID) = 3 AND KK_ID IN ('001', '007', '010','011','012', '013')", "KK_ID", "NAMA_KK", TRUE);
        $arrdata['act']         = site_url() . '/penandaan/penandaanController/setSurat/penandaanUpd';
        return $arrdata;
    }
    
    function updateSurat($isajax) {
        $ret = "MSG#NO#Data gagal disimpan";
        $sipt =& get_instance();
        $sipt->load->model("main", "main", true);
        $arr_no      = $this->input->post('SURAT');
        $arr_petugas = $this->input->post('USER_ID');
        $arr_tanggal = $this->input->post('TANGGAL');
        $suratId     = $this->input->post('SURATIDEDIT');
        if (!$arr_petugas)
            return "MSG#NO#Anda Belum Memasukan Petugas Pemeriksa#";
        $this->db->where(array(
            "SURAT_ID" => $suratId
        ));
        $this->db->delete('T_SURAT_TUGAS_PENANDAAN');
        for ($i = 0; $i < count($arr_petugas[0]); $i++) {
            
            $surat = array(
                'SURAT_ID' => $suratId,
                'NOMOR_SURAT' => $arr_no,
                'TANGGAL' => ($arr_tanggal == "" ? $arr_tanggal : null),
                'BALAI' => $this->newsession->userdata('SESS_BBPOM_ID'),
                'PETUGAS' => $arr_petugas[0][$i],
                'CREATED_BY' => $this->newsession->userdata('SESS_USER_ID'),
                'CREATED' => 'GETDATE()'
            );
            $this->db->insert('T_SURAT_TUGAS_PENANDAAN', $surat);
        }
        $ret = "MSG#YES#Data berhasil disimpan#" . site_url() . '/penandaan/penandaanController/setListFormPenandaanLanjutan/1101/2';
        if ($isajax != "ajax") {
            redirect(base_url());
            exit();
        }
        return $ret;
    }
    
    function updDbPenandaan($id, $namaDb, $namaField, $isi) {
        $sql = "UPDATE $namaDb SET " . $namaField . " = CAST ( " . $namaField . " AS NVARCHAR(MAX)) + CAST (? AS NVARCHAR(MAX)) WHERE (PENANDAAN_ID = ?)";
        $this->db->query($sql, array(
            $isi,
            $id
        ));
    }
    
    function setStatus($X, $isajax) {
        if ($isajax != "ajax") {
            redirect(base_url());
            exit();
        }
        if ($this->newsession->userdata('LOGGED_IN') == TRUE) {
            $sipt =& get_instance();
            $sipt->load->model("main", "main", true);
            $ret            = "MSG#NO#Data gagal disimpan";
            $status         = $this->input->post('TO');
            $komoditi       = $this->input->post('KOMODITI');
            $arr_update     = array(
                'STATUS' => $status,
                "USER_LAST_UPDATE" => $this->newsession->userdata('SESS_USER_ID'),
                "LAST_UPDATE" => 'GETDATE()'
            );
            $arr_update_log = array(
                'UPDATED' => 'GETDATE()'
            );
            $penandaanId    = $this->input->post('PENANDAAN_ID');
            $case           = '';
            $i              = 0;
            foreach ($penandaanId as $a) {
                //    if ($komoditi[$i] != "010") {
                $this->db->where(array(
                    "PENANDAAN_ID" => $a
                ));
                $this->db->update('T_PENANDAAN', $arr_update);
                $seri = (int) $sipt->main->get_uraian("SELECT MAX(SERI) AS MAXID FROM T_PENANDAAN_PROSES WHERE PENANDAAN_ID = '" . $a . "'", "MAXID") + 1;
                $log  = array(
                    'PENANDAAN_ID' => $a,
                    'SERI' => $seri,
                    'STATUS' => $status,
                    'CATATAN' => $this->input->post('CATATAN'),
                    'CREATEDBY' => $this->newsession->userdata('SESS_USER_ID'),
                    'CREATED' => 'GETDATE()',
                    'UPDATED' => 'GETDATE()'
                );
                if ($this->db->insert('T_PENANDAAN_PROSES', $log)) {
                    $this->db->where(array(
                        "PENANDAAN_ID" => $a,
                        "STATUS" => $this->input->post('UPDATE')
                    ));
                    $this->db->update('T_PENANDAAN_PROSES', $arr_update_log);
                    $case = 'Log';
                }
                //    }
                $case = 'Log';
                if ($case == 'Log') {
                    if (in_array('2', $this->newsession->userdata('SESS_KODE_ROLE'))) {
                        $yes = $this->input->post('EDIT');
                        if ($yes == "YES") {
                            if ($komoditi[$i] == '001') {
                                $BLarr   = "";
                                $ASarr   = "";
                                $ETarr   = "";
                                $SBarr   = "";
                                $V1arr   = "";
                                $V2arr   = "";
                                $BRarr   = "";
                                $pusatBL = $this->input->post('BL');
                                $pusatAS = $this->input->post('AS');
                                $pusatET = $this->input->post('ET');
                                $pusatSB = $this->input->post('SB');
                                $pusatV1 = $this->input->post('V1');
                                $pusatV2 = $this->input->post('V2');
                                $pusatBR = $this->input->post('BR');
                                $valBL   = $this->input->post('VALUEBL');
                                $valAS   = $this->input->post('VALUEAS');
                                $valET   = $this->input->post('VALUEET');
                                $valSB   = $this->input->post('VALUESB');
                                $valV1   = $this->input->post('VALUEV1');
                                $valV2   = $this->input->post('VALUEV2');
                                $valBR   = $this->input->post('VALUEBR');
                                if (in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')) && $yes == 'YES' && ($pusatBL || $pusatAS || $pusatBR || $pusatET || $pusatSB || $pusatV1 || $pusatV2)) {
                                    $justifikasiBL = "";
                                    $justifikasiAS = "";
                                    $justifikasiET = "";
                                    $justifikasiSB = "";
                                    $justifikasiV1 = "";
                                    $justifikasiV2 = "";
                                    $justifikasiBR = "";
                                    if ($valBL != $pusatBL['HASIL_PUSAT'][0])
                                        $justifikasiBL = $this->input->post('JUSTIFIKASI_BL');
                                    if ($valAS != $pusatAS['HASIL_PUSAT'][0])
                                        $justifikasiAS = $this->input->post('JUSTIFIKASI_AS');
                                    if ($valET != $pusatET['HASIL_PUSAT'][0])
                                        $justifikasiET = $this->input->post('JUSTIFIKASI_ET');
                                    if ($valSB != $pusatSB['HASIL_PUSAT'][0])
                                        $justifikasiSB = $this->input->post('JUSTIFIKASI_SB');
                                    if ($valV1 != $pusatV1['HASIL_PUSAT'][0])
                                        $justifikasiV1 = $this->input->post('JUSTIFIKASI_V1');
                                    if ($valV2 != $pusatV2['HASIL_PUSAT'][0])
                                        $justifikasiV2 = $this->input->post('JUSTIFIKASI_V2');
                                    if ($valBR != $pusatBR['HASIL_PUSAT'][0])
                                        $justifikasiBR = $this->input->post('JUSTIFIKASI_BR');
                                    if ($pusatBL['HASIL_PUSAT'][0] == "MK") {
                                        $BLarr = "*" . join("*", $pusatBL['HASIL_PUSAT']) . "***" . $justifikasiBL;
                                        $this->updDbPenandaan($a, "T_PENANDAAN_OBAT", "BUNGKUS_LUAR", $BLarr);
                                    } else if ($pusatBL['HASIL_PUSAT'][0] == "TMK") {
                                        $BLarr = "*" . join("*", $pusatBL['HASIL_PUSAT']) . "*" . rtrim(join("^", $pusatBL['TL_PUSAT']), "^") . "*" . rtrim(join("^", $pusatBL['DETAIL_PUSAT']), "^") . "*" . $justifikasiBL;
                                        $this->updDbPenandaan($a, "T_PENANDAAN_OBAT", "BUNGKUS_LUAR", $BLarr);
                                    }
                                    if ($pusatAS['HASIL_PUSAT'][0] == "MK") {
                                        $ASarr = "*" . join("*", $pusatAS['HASIL_PUSAT']) . "***" . $justifikasiAS;
                                        $this->updDbPenandaan($a, "T_PENANDAAN_OBAT", "AMPLOP", $ASarr);
                                    } else if ($pusatAS['HASIL_PUSAT'][0] == "TMK") {
                                        $ASarr = "*" . join("*", $pusatAS['HASIL_PUSAT']) . "*" . rtrim(join("^", $pusatAS['TL_PUSAT']), "^") . "*" . rtrim(join("^", $pusatAS['DETAIL_PUSAT']), "^") . "*" . $justifikasiAS;
                                        $this->updDbPenandaan($a, "T_PENANDAAN_OBAT", "AMPLOP", $ASarr);
                                    }
                                    if ($pusatET['HASIL_PUSAT'][0] == "MK") {
                                        $ETarr = "*" . join("*", $pusatET['HASIL_PUSAT']) . "***" . $justifikasiET;
                                        $this->updDbPenandaan($a, "T_PENANDAAN_OBAT", "ETIKET", $ETarr);
                                    } else if ($pusatET['HASIL_PUSAT'][0] == "TMK") {
                                        $ETarr = "*" . join("*", $pusatET['HASIL_PUSAT']) . "*" . rtrim(join("^", $pusatET['TL_PUSAT']), "^") . "*" . rtrim(join("^", $pusatET['DETAIL_PUSAT']), "^") . "*" . $justifikasiET;
                                        $this->updDbPenandaan($a, "T_PENANDAAN_OBAT", "ETIKET", $ETarr);
                                    }
                                    if ($pusatV1['HASIL_PUSAT'][0] == "MK") {
                                        $V1arr = "*" . join("*", $pusatV1['HASIL_PUSAT']) . "***" . $justifikasiV1;
                                        $this->updDbPenandaan($a, "T_PENANDAAN_OBAT", "AMPUL_VIAL10ML", $V1arr);
                                    } else if ($pusatV1['HASIL_PUSAT'][0] == "TMK") {
                                        $V1arr = "*" . join("*", $pusatV1['HASIL_PUSAT']) . "*" . rtrim(join("^", $pusatV1['TL_PUSAT']), "^") . "*" . rtrim(join("^", $pusatV1['DETAIL_PUSAT']), "^") . "*" . $justifikasiV1;
                                        $this->updDbPenandaan($a, "T_PENANDAAN_OBAT", "AMPUL_VIAL10ML", $V1arr);
                                    }
                                    if ($pusatV2['HASIL_PUSAT'][0] == "MK") {
                                        $V2arr = "*" . join("*", $pusatV2['HASIL_PUSAT']) . "***" . $justifikasiV2;
                                        $this->updDbPenandaan($a, "T_PENANDAAN_OBAT", "AMPUL_VIAL9ML", $V2arr);
                                    } else if ($pusatV2['HASIL_PUSAT'][0] == "TMK") {
                                        $V2arr = "*" . join("*", $pusatV2['HASIL_PUSAT']) . "*" . rtrim(join("^", $pusatV2['TL_PUSAT']), "^") . "*" . rtrim(join("^", $pusatV2['DETAIL_PUSAT']), "^") . "*" . $justifikasiV2;
                                        $this->updDbPenandaan($a, "T_PENANDAAN_OBAT", "AMPUL_VIAL9ML", $V2arr);
                                    }
                                    if ($pusatBR['HASIL_PUSAT'][0] == "MK") {
                                        $BRarr = "*" . join("*", $pusatBR['HASIL_PUSAT']) . "***" . $justifikasiBR;
                                        $this->updDbPenandaan($a, "T_PENANDAAN_OBAT", "BROSUR", $BRarr);
                                    } else if ($pusatBR['HASIL_PUSAT'][0] == "TMK") {
                                        $BRarr = "*" . join("*", $pusatBR['HASIL_PUSAT']) . "*" . rtrim(join("^", $pusatBR['TL_PUSAT']), "^") . "*" . rtrim(join("^", $pusatBR['DETAIL_PUSAT']), "^") . "*" . $justifikasiBR;
                                        $this->updDbPenandaan($a, "T_PENANDAAN_OBAT", "BROSUR", $BRarr);
                                    }
                                    if ($pusatSB['HASIL_PUSAT'][0] == "MK") {
                                        $SBarr = "*" . join("*", $pusatSB['HASIL_PUSAT']) . "***" . $justifikasiSB;
                                        $this->updDbPenandaan($a, "T_PENANDAAN_OBAT", "BLISTER", $SBarr);
                                    } else if ($pusatSB['HASIL_PUSAT'][0] == "TMK") {
                                        $SBarr = "*" . join("*", $pusatSB['HASIL_PUSAT']) . "*" . rtrim(join("^", $pusatSB['TL_PUSAT']), "^") . "*" . rtrim(join("^", $pusatSB['DETAIL_PUSAT']), "^") . "*" . $justifikasiSB;
                                        $this->updDbPenandaan($a, "T_PENANDAAN_OBAT", "BLISTER", $SBarr);
                                    }
                                }
                            } else if ($komoditi[$i] == "007" && in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) {
                                //        $arr_penandaan = $this->input->post('PENANDAAN');
                                //        $valPenilaian = $this->input->post('VALUEPENILAIAN');
                                //        if ($valPenilaian != $arr_penandaan['HASIL_PUSAT'])
                                //         $justifikasi = $this->input->post('JUSTIFIKASI');
                                //        if ($arr_penandaan['HASIL_PUSAT'] == "MK") {
                                //         $arrUpdate = array('PUSAT' => $arr_penandaan['HASIL_PUSAT'] . "**" . $justifikasi);
                                //        } else if ($arr_penandaan['HASIL_PUSAT'] == "TMK") {
                                //         $arrUpdate = array('PUSAT' => $arr_penandaan['HASIL_PUSAT'] . "*" . $arr_penandaan['TL_PUSAT'] . "*" . $justifikasi);
                                //        }
                                //        $this->db->where(array("PENANDAAN_ID" => $a));
                                //        $this->db->update('T_PENANDAAN_PANGAN', $arrUpdate);
                            } else if ($komoditi[$i] == "010" && in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) {
                                $arr_penandaan = $this->input->post('PENANDAAN');
                                $valPenilaian  = $this->input->post('VALUEPENILAIAN');
                                $justifikasi   = "";
                                if ($valPenilaian != $arr_penandaan['HASIL_PUSAT'])
                                    $justifikasi = $this->input->post('JUSTIFIKASI');
                                if ($arr_penandaan['HASIL_PUSAT'] == "MK") {
                                    $arrUpdate = array(
                                        'PUSAT' => $arr_penandaan['HASIL_PUSAT'] . "**" . $justifikasi
                                    );
                                } else if ($arr_penandaan['HASIL_PUSAT'] == "TMK") {
                                    $arrUpdate = array(
                                        'PUSAT' => $arr_penandaan['HASIL_PUSAT'] . "*" . $arr_penandaan['TL_PUSAT'] . "*" . $justifikasi
                                    );
                                }
                                $this->db->where(array(
                                    "PENANDAAN_ID" => $a
                                ));
                                $this->db->update('T_PENANDAAN_OT', $arrUpdate);
                            } else if ($komoditi[$i] == "011" && in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) {
                                $arr_penandaan = $this->input->post('PENANDAAN');
                                $valPenilaian  = $this->input->post('VALUEPENILAIAN');
                                $justifikasi   = "";
                                if ($valPenilaian != $arr_penandaan['HASIL_PUSAT'])
                                    $justifikasi = $this->input->post('JUSTIFIKASI');
                                if ($arr_penandaan['HASIL_PUSAT'] == "MK") {
                                    $arrUpdate = array(
                                        'PUSAT' => $arr_penandaan['HASIL_PUSAT'] . "**" . $justifikasi
                                    );
                                } else if ($arr_penandaan['HASIL_PUSAT'] == "TMK") {
                                    $arrUpdate = array(
                                        'PUSAT' => $arr_penandaan['HASIL_PUSAT'] . "*" . $arr_penandaan['TL_PUSAT'] . "*" . $justifikasi
                                    );
                                }
                                $this->db->where(array(
                                    "PENANDAAN_ID" => $a
                                ));
                                $this->db->update('T_PENANDAAN_PK_SM', $arrUpdate);
                            } else if ($komoditi[$i] == "012" && in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) {
                                $arr_penandaan = $this->input->post('PENANDAAN');
                                $valPenilaian  = $this->input->post('VALUEPENILAIAN');
                                $justifikasi   = "";
                                if (trim($valPenilaian) != "") {
                                    if ($valPenilaian != $arr_penandaan['HASIL_PUSAT'])
                                        $justifikasi = $this->input->post('JUSTIFIKASI');
                                }
                                if ($arr_penandaan['HASIL_PUSAT'] == "MS" || $arr_penandaan['HASIL_PUSAT'] == "TIE") {
                                    $arrUpdate = array(
                                        'PUSAT' => $arr_penandaan['HASIL_PUSAT'] . "**" . $justifikasi
                                    );
                                } else if ($arr_penandaan['HASIL_PUSAT'] == "TMS") {
                                    $arrUpdate = array(
                                        'PUSAT' => $arr_penandaan['HASIL_PUSAT'] . "*" . $arr_penandaan['TL_PUSAT'] . "*" . $justifikasi
                                    );
                                }
                                $this->db->where(array(
                                    "PENANDAAN_ID" => $a
                                ));
                                $this->db->update('T_PENANDAAN_KOSMETIKA', $arrUpdate);
                            } else if ($komoditi[$i] == "013" && in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) {
                                $arr_penandaan = $this->input->post('PENANDAAN');
                                $valPenilaian  = $this->input->post('VALUEPENILAIAN');
                                $justifikasi   = "";
                                if ($valPenilaian != $arr_penandaan['HASIL_PUSAT'])
                                    $justifikasi = $this->input->post('JUSTIFIKASI');
                                if ($arr_penandaan['HASIL_PUSAT'] == "MK") {
                                    $arrUpdate = array(
                                        'PUSAT' => $arr_penandaan['HASIL_PUSAT'] . "**" . $justifikasi
                                    );
                                } else if ($arr_penandaan['HASIL_PUSAT'] == "TMK") {
                                    $arrUpdate = array(
                                        'PUSAT' => $arr_penandaan['HASIL_PUSAT'] . "*" . $arr_penandaan['TL_PUSAT'] . "*" . $justifikasi
                                    );
                                }
                                $this->db->where(array(
                                    "PENANDAAN_ID" => $a
                                ));
                                $this->db->update('T_PENANDAAN_PANGAN', $arrUpdate);
                            }
                        }
                    }
                    $case = 'Set';
                }
                $i++;
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
    
    function setSurat($isajax) {
        $ret = "MSG#NO#Data gagal disimpan";
        $sipt =& get_instance();
        $sipt->load->model("main", "main", true);
        $arr_no      = $this->input->post('SURAT');
        $arr_petugas = $this->input->post('USER_ID');
        $arr_bpom    = $this->input->post('BBPOM');
        $arr_tanggal = $this->input->post('TANGGAL');
        if (!$arr_petugas)
            return "MSG#NO#Anda Belum Memasukan Petugas Pemeriksa#";
        if ($arr_tanggal)
            $SES_SURAT['TANGGAL'] = $arr_tanggal;
        else
            $SES_SURAT['TANGGAL'] = '-';
        if ($arr_no)
            $SES_SURAT['SURAT'] = $arr_no;
        else
            $SES_SURAT['SURAT'] = '-';
        $SES_SURAT['BBPOM'] = $arr_bpom;
        $SES_SURAT['USER']  = $arr_petugas;
        $klasifikasi        = join('-', $this->input->post('klasifikasi'));
        $jenis              = $this->input->post('PANGAN');
        $this->session->set_userdata($SES_SURAT);
        $ret = "MSG#YES#Data berhasil disimpan#" . site_url() . '/penandaan/penandaanController/getFormPenandaanLanjutan/' . $klasifikasi . "/" . $jenis;
        if ($isajax != "ajax") {
            redirect(base_url());
            exit();
        }
        return $ret;
    }
    
    function getRole() {
        $sipt =& get_instance();
        $this->load->model("main", "main", true);
        $query = "SELECT ROLE FROM T_USER_ROLE WHERE USER_ID = '" . $this->newsession->userdata('SESS_USER_ID') . "'";
        $data  = $sipt->main->get_result($query);
        if ($data) {
            foreach ($query->result_array() as $row) {
                $arrdata = $row['ROLE'];
            }
        }
        return $arrdata;
    }
    
    function getJenis($penandaanId) {
        $sipt =& get_instance();
        $this->load->model("main", "main", true);
        $query = "SELECT JENIS FROM T_PENANDAAN_PANGAN WHERE PENANDAAN_ID = '$penandaanId'";
        $data  = $sipt->main->get_result($query);
        if ($data) {
            foreach ($query->result_array() as $row) {
                $arrdata = $row['JENIS'];
            }
        }
        return $arrdata;
    }
    
    function statusSend() {
        $sipt =& get_instance();
        $sipt->load->model("main", "main", true);
        $stat = "";
        if (in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) { #Sent Pusat
            if (in_array('2', $this->newsession->userdata('SESS_KODE_ROLE'))) {
                $stat .= $sipt->main->get_uraian("SELECT URAIAN FROM M_TABEL WHERE JENIS = 'SENT' AND KODE = '0206'", "URAIAN");
            }
            if (in_array('3', $this->newsession->userdata('SESS_KODE_ROLE'))) {
                $stat .= $sipt->main->get_uraian("SELECT URAIAN FROM M_TABEL WHERE JENIS = 'SENT' AND KODE = '0306'", "URAIAN");
            }
            if (in_array('4', $this->newsession->userdata('SESS_KODE_ROLE'))) {
                $stat .= $sipt->main->get_uraian("SELECT URAIAN FROM M_TABEL WHERE JENIS = 'SENT' AND KODE = '0406'", "URAIAN");
            }
        } else { #Sent Balai
            if (in_array('2', $this->newsession->userdata('SESS_KODE_ROLE'))) {
                $stat .= $sipt->main->get_uraian("SELECT URAIAN FROM M_TABEL WHERE JENIS = 'SENT' AND KODE = '0205'", "URAIAN");
            }
            if (in_array('3', $this->newsession->userdata('SESS_KODE_ROLE'))) {
                $stat .= $sipt->main->get_uraian("SELECT URAIAN FROM M_TABEL WHERE JENIS = 'SENT' AND KODE = '0305'", "URAIAN");
            }
            if (in_array('4', $this->newsession->userdata('SESS_KODE_ROLE'))) {
                $stat .= $sipt->main->get_uraian("SELECT URAIAN FROM M_TABEL WHERE JENIS = 'SENT' AND KODE = '0405'", "URAIAN");
            }
            if (in_array('5', $this->newsession->userdata('SESS_KODE_ROLE'))) {
                $stat .= $sipt->main->get_uraian("SELECT URAIAN FROM M_TABEL WHERE JENIS = 'SENT' AND KODE = '0505'", "URAIAN");
            }
        }
        $arr = explode(",", $stat);
        if (empty($arr[count($arr) - 1])) {
            unset($arr[count($arr) - 1]);
        }
        $status = "'" . join("','", array_unique($arr)) . "'";
        //    print_r($arr);
        //    die($status);
        return $status;
    }
    
    function get_reportPengawasanRHPK($jenis = "") {
        if ($this->newsession->userdata('LOGGED_IN') == TRUE) {
            $sipt =& get_instance();
            $this->load->model("main", "main", true);
            $tipe        = array(
                "" => "",
                "0" => "Pemeriksaan Sarana",
                "1" => "Temuan Produk"
            );
            $disinput    = array(
                "JENISDIS",
                "NAMADIS"
            );
            //            $komoditi = "'" . join("','", $this->newsession->userdata("SESS_KLASIFIKASI_ID")) . "'";
            $komoditi    = "'001','007','010','011','012','013'";
            $arrayClause = array(
                'demo_1',
                'demo_2',
                'demo_3',
                'demo_4',
                'operator-pusat',
                '1001',
                '1002',
                '1003',
                '1004',
                '1005',
                'administrator'
            );
            if (in_array($this->newsession->userdata("SESS_USER_ID"), $arrayClause))
                $klasifikasi = $sipt->main->combobox("SELECT * FROM M_KLASIFIKASI_KATEGORI WHERE LEN(KK_ID) = 3 AND KK_ID IN ($komoditi)", "KK_ID", "NAMA_KK", TRUE);
            else
                $klasifikasi = $sipt->main->combobox("SELECT * FROM M_KLASIFIKASI_KATEGORI WHERE LEN(KK_ID) = 3 AND KK_ID IN ('001')", "KK_ID", "NAMA_KK", TRUE);
            $kecuali = $sipt->main->remove_element($this->config->item('cfg_unit'), $this->newsession->userdata('SESS_BBPOM_ID'));
            $unit    = "'" . join("','", $kecuali) . "'";
            if (in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) {
                $ret   = "SELECT BBPOM_ID, NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID NOT IN ('00','99',$unit)";
                $bbpom = $sipt->main->combobox("SELECT BBPOM_ID, NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID NOT IN ('00','99',$unit)", "BBPOM_ID", "NAMA_BBPOM", TRUE);
            } else if ($this->newsession->userdata('SESS_BBPOM_ID') != "00" && !in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) {
                $ret   = 'balai';
                $bbpom = $sipt->main->combobox("SELECT BBPOM_ID, NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID ='" . $this->newsession->userdata('SESS_BBPOM_ID') . "'", "BBPOM_ID", "NAMA_BBPOM");
                if ($this->newsession->userdata('SESS_PROP_ID') == '7100') {
                    $kota = $sipt->main->combobox("SELECT PROPINSI_ID, NAMA_PROPINSI FROM M_PROPINSI WHERE PROPINSI_ID LIKE '%71__%' OR PROPINSI_ID LIKE '%82__%' AND RIGHT(PROPINSI_ID, 2) <> '00'", "PROPINSI_ID", "NAMA_PROPINSI", TRUE);
                } else if ($this->newsession->userdata('SESS_PROP_ID') == '7300') {
                    $kota = $sipt->main->combobox("SELECT PROPINSI_ID, NAMA_PROPINSI FROM M_PROPINSI WHERE PROPINSI_ID LIKE '%73__%' OR PROPINSI_ID LIKE '%76__%' AND RIGHT(PROPINSI_ID, 2) <> '00'", "PROPINSI_ID", "NAMA_PROPINSI", TRUE);
                } else {
                    $propinsi = substr($this->newsession->userdata('SESS_PROP_ID'), 0, 2);
                    $kota     = $sipt->main->combobox("SELECT PROPINSI_ID, NAMA_PROPINSI FROM M_PROPINSI WHERE PROPINSI_ID LIKE '" . $propinsi . "%' AND RIGHT(PROPINSI_ID, 2) <> '00'", "PROPINSI_ID", "NAMA_PROPINSI", TRUE);
                }
            } else {
                $ret   = 'piom';
                $bbpom = $sipt->main->combobox("SELECT BBPOM_ID, NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID NOT IN ('99','00')", "BBPOM_ID", "NAMA_BBPOM", TRUE);
            }
            $arrdata          = array(
                'jenisKlasifikasi' => $klasifikasi,
                'disinput' => $disinput,
                'kota' => $kota,
                'tipe' => $tipe,
                'bbpom' => $bbpom,
                'hasil' => $hasil,
                'idjudul' => 'judulpmnpdd',
                'batal' => site_url()
            );
            $arrdata['act']   = site_url() . '/penandaan/penandaanController/rekapitulasi/RHPK';
            $arrdata['judul'] = 'RHPK Pengawasan Penandaan';
            return $arrdata;
        } else {
            $this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.', '/home');
        }
    }
    
    function get_reportPengawasan($jenis = "") {
        if ($this->newsession->userdata('LOGGED_IN') == TRUE) {
            $sipt =& get_instance();
            $this->load->model("main", "main", true);
            $tipe        = array(
                "" => "",
                "0" => "Pemeriksaan Sarana",
                "1" => "Temuan Produk"
            );
            $disinput    = array(
                "JENISDIS",
                "NAMADIS"
            );
            //            $komoditi = "'" . join("','", $this->newsession->userdata("SESS_KLASIFIKASI_ID")) . "'";
            $komoditi    = "'001','007','010','011','012','013'";
            $arrayClause = array(
                'demo_1',
                'demo_2',
                'demo_3',
                'demo_4',
                'operator-pusat',
                '1001',
                '1002',
                '1003',
                '1004',
                '1005',
                'administrator'
            );
            if (in_array($this->newsession->userdata("SESS_USER_ID"), $arrayClause))
                $klasifikasi = $sipt->main->combobox("SELECT * FROM M_KLASIFIKASI_KATEGORI WHERE LEN(KK_ID) = 3 AND KK_ID IN ($komoditi)", "KK_ID", "NAMA_KK", TRUE);
            else
                $klasifikasi = $sipt->main->combobox("SELECT * FROM M_KLASIFIKASI_KATEGORI WHERE LEN(KK_ID) = 3 AND KK_ID IN ('001')", "KK_ID", "NAMA_KK", TRUE);
            $kecuali = $sipt->main->remove_element($this->config->item('cfg_unit'), $this->newsession->userdata('SESS_BBPOM_ID'));
            $unit    = "'" . join("','", $kecuali) . "'";
            if (in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) {
                $ret   = "SELECT BBPOM_ID, NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID NOT IN ('00','99',$unit)";
                $bbpom = $sipt->main->combobox("SELECT BBPOM_ID, NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID NOT IN ('00','99',$unit)", "BBPOM_ID", "NAMA_BBPOM", TRUE);
            } else if ($this->newsession->userdata('SESS_BBPOM_ID') != "00" && !in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) {
                $ret   = 'balai';
                $bbpom = $sipt->main->combobox("SELECT BBPOM_ID, NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID ='" . $this->newsession->userdata('SESS_BBPOM_ID') . "'", "BBPOM_ID", "NAMA_BBPOM");
                if ($this->newsession->userdata('SESS_PROP_ID') == '7100') {
                    $kota = $sipt->main->combobox("SELECT PROPINSI_ID, NAMA_PROPINSI FROM M_PROPINSI WHERE PROPINSI_ID LIKE '%71__%' OR PROPINSI_ID LIKE '%82__%' AND RIGHT(PROPINSI_ID, 2) <> '00'", "PROPINSI_ID", "NAMA_PROPINSI", TRUE);
                } else if ($this->newsession->userdata('SESS_PROP_ID') == '7300') {
                    $kota = $sipt->main->combobox("SELECT PROPINSI_ID, NAMA_PROPINSI FROM M_PROPINSI WHERE PROPINSI_ID LIKE '%73__%' OR PROPINSI_ID LIKE '%76__%' AND RIGHT(PROPINSI_ID, 2) <> '00'", "PROPINSI_ID", "NAMA_PROPINSI", TRUE);
                } else {
                    $propinsi = substr($this->newsession->userdata('SESS_PROP_ID'), 0, 2);
                    $kota     = $sipt->main->combobox("SELECT PROPINSI_ID, NAMA_PROPINSI FROM M_PROPINSI WHERE PROPINSI_ID LIKE '" . $propinsi . "%' AND RIGHT(PROPINSI_ID, 2) <> '00'", "PROPINSI_ID", "NAMA_PROPINSI", TRUE);
                }
            } else {
                $ret   = 'piom';
                $bbpom = $sipt->main->combobox("SELECT BBPOM_ID, NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID NOT IN ('99','00')", "BBPOM_ID", "NAMA_BBPOM", TRUE);
            }
            $arrdata          = array(
                'jenisKlasifikasi' => $klasifikasi,
                'disinput' => $disinput,
                'kota' => $kota,
                'tipe' => $tipe,
                'bbpom' => $bbpom,
                'hasil' => $hasil,
                'idjudul' => 'judulpmnpdd',
                'batal' => site_url()
            );
            $arrdata['act']   = site_url() . '/penandaan/penandaanController/rekapitulasi/report';
            $arrdata['judul'] = 'Report Pengawasan Penandaan';
            return $arrdata;
        } else {
            $this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.', '/home');
        }
    }
    
    function tlString($string) {
        if ($string == "TL")
            $tindakLanjut = "Tindak Lanjut";
        else if ($string == "STL")
            $tindakLanjut = "Sudah Tindak Lanjut";
        else if ($string == "TTL")
            $tindakLanjut = "Tidak Dapat Tindak Lanjut";
        return $tindakLanjut;
    }
    
    function get_reportRekapStatus($jenis = "") {
        if ($this->newsession->userdata('LOGGED_IN') == TRUE) {
            $sipt =& get_instance();
            $this->load->model("main", "main", true);
            $kecuali = $sipt->main->remove_element($this->config->item('cfg_unit'), $this->newsession->userdata('SESS_BBPOM_ID'));
            $unit    = "'" . join("','", $kecuali) . "'";
            if (in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) {
                $ret   = "SELECT BBPOM_ID, NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID NOT IN ('00','99',$unit)";
                $bbpom = $sipt->main->combobox("SELECT BBPOM_ID, NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID NOT IN ('00','99',$unit)", "BBPOM_ID", "NAMA_BBPOM", TRUE);
            } else if ($this->newsession->userdata('SESS_BBPOM_ID') != "00" && !in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) {
                $ret   = 'balai';
                $bbpom = $sipt->main->combobox("SELECT BBPOM_ID, NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID ='" . $this->newsession->userdata('SESS_BBPOM_ID') . "'", "BBPOM_ID", "NAMA_BBPOM");
                if ($this->newsession->userdata('SESS_PROP_ID') == '7100') {
                    $kota = $sipt->main->combobox("SELECT PROPINSI_ID, NAMA_PROPINSI FROM M_PROPINSI WHERE PROPINSI_ID LIKE '%71__%' OR PROPINSI_ID LIKE '%82__%' AND RIGHT(PROPINSI_ID, 2) <> '00'", "PROPINSI_ID", "NAMA_PROPINSI", TRUE);
                } else if ($this->newsession->userdata('SESS_PROP_ID') == '7300') {
                    $kota = $sipt->main->combobox("SELECT PROPINSI_ID, NAMA_PROPINSI FROM M_PROPINSI WHERE PROPINSI_ID LIKE '%73__%' OR PROPINSI_ID LIKE '%76__%' AND RIGHT(PROPINSI_ID, 2) <> '00'", "PROPINSI_ID", "NAMA_PROPINSI", TRUE);
                } else {
                    $propinsi = substr($this->newsession->userdata('SESS_PROP_ID'), 0, 2);
                    $kota     = $sipt->main->combobox("SELECT PROPINSI_ID, NAMA_PROPINSI FROM M_PROPINSI WHERE PROPINSI_ID LIKE '" . $propinsi . "%' AND RIGHT(PROPINSI_ID, 2) <> '00'", "PROPINSI_ID", "NAMA_PROPINSI", TRUE);
                }
            } else {
                $ret   = 'piom';
                $bbpom = $sipt->main->combobox("SELECT BBPOM_ID, NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID NOT IN ('99','00')", "BBPOM_ID", "NAMA_BBPOM", TRUE);
            }
            $arrdata          = array(
                'kota' => $kota,
                'bbpom' => $bbpom,
                'idjudul' => 'judulpmnpdd',
                'batal' => site_url()
            );
            $arrdata['act']   = site_url() . '/penandaan/penandaanController/rekapitulasi/statusDokumen';
            $arrdata['judul'] = 'Rekapitulasi Status Pengawasan Penandaan';
            return $arrdata;
        } else {
            $this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.', '/home');
        }
    }
    
    function monitoring() {
        if (array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('10', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('9', $this->newsession->userdata('SESS_KODE_ROLE')) || $this->newsession->userdata('LOGGED_IN') == TRUE) {
            $sipt =& get_instance();
            $this->load->model("main", "main", true);
            $this->load->library('newtable');
            $sarana = "'" . join("','", $this->newsession->userdata('SESS_SARANA')) . "'";
            $this->newtable->hiddens(array(
                'LASTUPDATEROW',
                'PENANDAANID'
            ));
            if ($this->newsession->userdata('SESS_BBPOM_ID') == "00")
                $deleted = "";
            else
                $deleted = " AND C.STATUS NOT IN ('00')";
            if ($this->newsession->userdata('SESS_BBPOM_ID') == "00" || in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) {
                $this->newtable->search(array(
                    array(
                        '',
                        ''
                    )
                ));
                $query .= "SELECT TP.LAST_UPDATE AS LASTUPDATEROW, (CAST(TP.PENANDAAN_ID AS VARCHAR)+'/'+CAST(TP.KOMODITI AS VARCHAR)+'/'+CAST(TP.STATUS AS VARCHAR))+'/'+CAST(TP.BBPOM_ID AS VARCHAR) AS PENANDAANID,
                    '<b><a href=\"#\" class=\"row_preview\">'+TPP.NAMA_PRODUK+'</a></b><div>'+TPP.BENTUK_SEDIAAN+'</div><div>'+TPP.PRODUSEN+'</div>' AS 'PENGAWASAN PENANDAAN',
                    CONVERT(VARCHAR(10), TP.TANGGAL_MULAI, 120)+'<div>Sampai Dengan</div><div>'+CONVERT(VARCHAR(10), TP.TANGGAL_AKHIR, 120)+'</div>' AS 'TANGGAL PENGAWASAN', '<div><b>'+MB.NAMA_BBPOM+'</b></div>' AS 'BB / BPOM',
                    (CASE WHEN TP.KOMODITI = '013' THEN '<div>'+dbo.GET_KOMODITI(TP.KOMODITI)+'<b> &raquo '+(SELECT A.JENIS + ' (' + A.JENIS_PENGAWASAN + ')' FROM T_PENANDAAN_PANGAN A WHERE A.PENANDAAN_ID = TP.PENANDAAN_ID)+'</b></div>' ELSE dbo.GET_KOMODITI(TP.KOMODITI) END) AS KOMODITI,
                    MT.URAIAN AS 'STATUS TERAKHIR', '<div><b>'+dbo.GET_PROPINSI(MS.PROPINSI)+'</b></div>' AS PROPINSI,
                    dbo.GET_HISTORY_PENANDAAN('PENGAWASAN', TP.PENANDAAN_ID)+'<div>'+dbo.GET_HISTORY_PENANDAAN('CATATAN', TP.PENANDAAN_ID)+'</div><div><a href=\"#\" class=\"row_riwayat2\" record=\"'+CAST(TP.PENANDAAN_ID AS VARCHAR)+'#T_PENANDAAN_PROSES\">Riwayat Pemeriksaan</a></div>' AS [UPDATE TERAKHIR]
                    FROM T_PENANDAAN TP
                    LEFT JOIN T_PENANDAAN_PROSES TPP2 ON TPP2.PENANDAAN_ID = TP.PENANDAAN_ID
                    LEFT JOIN T_PENANDAAN_PRODUK TPP ON TPP.PENANDAAN_ID = TP.PENANDAAN_ID
                    LEFT JOIN T_USER TU ON TU.USER_ID = TP.USER_LAST_UPDATE
                    LEFT JOIN M_TABEL MT ON MT.KODE = TP.STATUS
                    LEFT JOIN M_SARANA MS ON MS.SARANA_ID = TP.SARANA_ID
                    LEFT JOIN M_BBPOM MB ON TP.BBPOM_ID = MB.BBPOM_ID
                    WHERE TPP2.SERI = (SELECT MAX (SERI) AS SERI FROM T_PENANDAAN_PROSES WHERE PENANDAAN_ID = TP.PENANDAAN_ID)
                    AND MS.JENIS_SARANA IN (" . $sarana . ")";
                
                #WHERE TPP2.SERI = (SELECT MAX (SERI) AS SERI FROM T_PENANDAAN_PROSES WHERE PENANDAAN_ID = TP.PENANDAAN_ID AND TP.USER_LAST_UPDATE = TPP2.CREATEDBY)
                
                $this->newtable->columns(array(
                    "TP.LAST_UPDATE",
                    "(CAST(TP.PENANDAAN_ID AS VARCHAR)+'/'+CAST(TP.KOMODITI AS VARCHAR)++'/'+CAST(TP.STATUS AS VARCHAR))'/'+CAST(TP.BBPOM_ID AS VARCHAR)",

                    "'<b><a href=\"#\" class=\"row_preview\">'+TPP.NAMA_PRODUK+'</a></b><div>'+TPP.BENTUK_SEDIAAN+'</div><div>'+TPP.PRODUSEN+'</div>'",
                    "CONVERT(VARCHAR(10), TP.TANGGAL_MULAI, 120)+'<div>Sampai Dengan</div><div>'+CONVERT(VARCHAR(10), TP.TANGGAL_AKHIR, 120)+'</div>'",
                    "MB.NAMA_BBPOM",
                    "(CASE WHEN TP.KOMODITI = '013' THEN '<div>'+dbo.GET_KOMODITI(TP.KOMODITI)+'<b> &raquo '+(SELECT A.JENIS + ' (' + A.JENIS_PENGAWASAN + ')' FROM T_PENANDAAN_PANGAN A WHERE A.PENANDAAN_ID = TP.PENANDAAN_ID)+'</b></div>' ELSE dbo.GET_KOMODITI(TP.KOMODITI) END)",
                    "MT.URAIAN",
                    "'<div><b>'+dbo.GET_PROPINSI(MS.PROPINSI)+'</b></div>'",
                    "dbo.GET_HISTORY_PENANDAAN('PENGAWASAN', TP.PENANDAAN_ID)+'<div>'+dbo.GET_HISTORY_PENANDAAN('CATATAN', TP.PENANDAAN_ID)+'</div><div><a href=\"#\" class=\"row_riwayat2\" record=\"'+CAST(TP.PENANDAAN_ID AS VARCHAR)+'#T_PENANDAAN_PROSES\">Riwayat Pemeriksaan</a></div>'"
                ));
                $this->newtable->width(array(
                    'PENGAWASAN PENANDAAN' => 200,
                    'TANGGAL PENGAWASAN' => 150,
                    'KOMODITI' => 80,
                    'BB / BPOM' => 90,
                    'STATUS TERAKHIR' => 135,
                    'PROPINSI' => 115,
                    'UPDATE TERAKHIR' => 135
                ));
                $this->newtable->orderby(1);
            } else {
                $this->newtable->search(array(
                    array(
                        '',
                        ''
                    )
                ));
                $query .= "SELECT TP.LAST_UPDATE AS LASTUPDATEROW, (CAST(TP.PENANDAAN_ID AS VARCHAR)+'/'+CAST(TP.KOMODITI AS VARCHAR)+'/'+CAST(TP.STATUS AS VARCHAR))+'/'+CAST(TP.BBPOM_ID AS VARCHAR) AS PENANDAANID,
                    '<b><a href=\"#\" class=\"row_preview\">'+TPP.NAMA_PRODUK+'</a></b><div>'+TPP.BENTUK_SEDIAAN+'</div><div>'+TPP.PRODUSEN+'</div>' AS 'PENGAWASAN PENANDAAN',
                    CONVERT(VARCHAR(10), TP.TANGGAL_MULAI, 120)+'<div>Sampai Dengan</div><div>'+CONVERT(VARCHAR(10), TP.TANGGAL_AKHIR, 120)+'</div>' AS 'TANGGAL PENGAWASAN', '<div><b>'+MB.NAMA_BBPOM+'</b></div>' AS 'BB / BPOM',
                    (CASE WHEN TP.KOMODITI = '013' THEN '<div>'+dbo.GET_KOMODITI(TP.KOMODITI)+'<b> &raquo '+(SELECT A.JENIS + ' (' + A.JENIS_PENGAWASAN + ')' FROM T_PENANDAAN_PANGAN A WHERE A.PENANDAAN_ID = TP.PENANDAAN_ID)+'</b></div>' ELSE dbo.GET_KOMODITI(TP.KOMODITI) END) AS KOMODITI,
                    MT.URAIAN AS 'STATUS TERAKHIR', '<div><b>'+dbo.GET_PROPINSI(MS.PROPINSI)+'</b></div>' AS PROPINSI,
                    dbo.GET_HISTORY_PENANDAAN('PENGAWASAN', TP.PENANDAAN_ID)+'<div>'+dbo.GET_HISTORY_PENANDAAN('CATATAN', TP.PENANDAAN_ID)+'</div><div><a href=\"#\" class=\"row_riwayat2\" record=\"'+CAST(TP.PENANDAAN_ID AS VARCHAR)+'#T_PENANDAAN_PROSES\">Riwayat Pemeriksaan</a></div>' AS [UPDATE TERAKHIR]
                    FROM T_PENANDAAN TP
                    LEFT JOIN T_PENANDAAN_PROSES TPP2 ON TPP2.PENANDAAN_ID = TP.PENANDAAN_ID
                    LEFT JOIN T_PENANDAAN_PRODUK TPP ON TPP.PENANDAAN_ID = TP.PENANDAAN_ID
                    LEFT JOIN T_USER TU ON TU.USER_ID = TP.USER_LAST_UPDATE
                    LEFT JOIN M_TABEL MT ON MT.KODE = TP.STATUS
                    LEFT JOIN M_SARANA MS ON MS.SARANA_ID = TP.SARANA_ID
                    LEFT JOIN M_BBPOM MB ON TP.BBPOM_ID = MB.BBPOM_ID
                    WHERE TPP2.SERI = (SELECT MAX (SERI) AS SERI FROM T_PENANDAAN_PROSES WHERE PENANDAAN_ID = TP.PENANDAAN_ID)
                    AND MS.JENIS_SARANA IN (" . $sarana . ") AND TP.BBPOM_ID ='" . $this->newsession->userdata('SESS_BBPOM_ID') . "'";
                # WHERE TPP2.SERI = (SELECT MAX (SERI) AS SERI FROM T_PENANDAAN_PROSES WHERE PENANDAAN_ID = TP.PENANDAAN_ID AND TP.USER_LAST_UPDATE = TPP2.CREATEDBY)
                $this->newtable->columns(array(
                    "TP.LAST_UPDATE",
                    "(CAST(TP.PENANDAAN_ID AS VARCHAR)+'/'+CAST(TP.KOMODITI AS VARCHAR)+'/'+CAST(TP.STATUS AS VARCHAR))+'/'+CAST(TP.BBPOM_ID AS VARCHAR)",
                    "'<b><a href=\"#\" class=\"row_preview\">'+TPP.NAMA_PRODUK+'</a></b><div>'+TPP.BENTUK_SEDIAAN+'</div><div>'+TPP.PRODUSEN+'</div>'",
                    "CONVERT(VARCHAR(10), TP.TANGGAL_MULAI, 120)+'<div>Sampai Dengan</div><div>'+CONVERT(VARCHAR(10), TP.TANGGAL_AKHIR, 120)+'</div>'",
                    "MB.NAMA_BBPOM",
                    "(CASE WHEN TP.KOMODITI = '013' THEN '<div>'+dbo.GET_KOMODITI(TP.KOMODITI)+'<b> &raquo '+(SELECT A.JENIS + ' (' + A.JENIS_PENGAWASAN + ')' FROM T_PENANDAAN_PANGAN A WHERE A.PENANDAAN_ID = TP.PENANDAAN_ID)+'</b></div>' ELSE dbo.GET_KOMODITI(TP.KOMODITI) END)",
                    "MT.URAIAN",
                    "'<div><b>'+dbo.GET_PROPINSI(MS.PROPINSI)+'</b></div>'",
                    "dbo.GET_HISTORY_PENANDAAN('PENGAWASAN', TP.PENANDAAN_ID)+'<div>'+dbo.GET_HISTORY_PENANDAAN('CATATAN', TP.PENANDAAN_ID)+'</div><div><a href=\"#\" class=\"row_riwayat2\" record=\"'+CAST(TP.PENANDAAN_ID AS VARCHAR)+'#T_PENANDAAN_PROSES\">Riwayat Pemeriksaan</a></div>'"
                ));
                $this->newtable->width(array(
                    'PENGAWASAN PENANDAAN' => 200,
                    'TANGGAL PENGAWASAN' => 150,
                    'KOMODITI' => 80,
                    'BB / BPOM' => 90,
                    'STATUS TERAKHIR' => 135,
                    'PROPINSI' => 115,
                    'UPDATE TERAKHIR' => 135
                ));
                $this->newtable->orderby(1);
            }
            //      $proses['Edit Data Petugas Pemeriksa'] = array('GET', site_url() . "/home/pelaporan/petugas", '1');
            //      $proses['Lihat Data Temuan Produk'] = array('GET', site_url() . "/home/produk/view", '1');
            $proses['Lihat Data Pengawasan'] = array(
                'GET',
                site_url() . "/penandaan/penandaanController/prosesPreview/preview",
                '1'
            );
            //      $proses['Cetak Form Pemeriksaan'] = array('GETNEW', site_uha[rl() . "/home/bap", '1');
            if (array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')))
                $proses['Hapus Data Pemeriksaan'] = array(
                    'POST',
                    site_url() . "/penandaan/penandaanController/prosesDelete/delete",
                    'N'
                );
            $this->newtable->action(site_url() . "/penandaan/penandaanController/monitoring");
            $this->newtable->detail(site_url() . "/penandaan/penandaanController/setPreview/penandaan");
            $this->newtable->cidb($this->db);
            $this->newtable->ciuri($this->uri->segment_array());
            $this->newtable->sortby("DESC");
            $this->newtable->keys(array(
                'PENANDAANID'
            ));
            $this->newtable->menu($proses);
            $this->newtable->show_search(FALSE);
            $tabel   = $this->newtable->generate($query);
            $arrdata = array(
                'table' => $tabel,
                'search' => TRUE,
                'frmsearch' => $sipt->main->_showformpenandaan(site_url() . '/penandaan/penandaanController/monitoringSrc', $cari, $subcari),
                'idjudul' => 'judulpmnpdd',
                'caption_header' => 'Trakcing Pengawasan Penandaan',
                'batal' => '',
                'cancel' => ''
            );
            return $arrdata;
        } else {
            $this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.', '/home');
        }
    }
    
    function monitoring_act($cari, $subcari) {
        if (array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('10', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('9', $this->newsession->userdata('SESS_KODE_ROLE')) || $this->newsession->userdata('LOGGED_IN') == TRUE) {
            $sipt =& get_instance();
            $this->load->model("main", "main", true);
            $this->load->library('newtable');
            $uricari    = explode("_", $cari);
            $urisubcari = explode("_", $subcari);
            $sarana     = "'" . join("','", $this->newsession->userdata('SESS_SARANA')) . "'";
            $this->newtable->hiddens(array(
                'LASTUPDATEROW',
                'PENANDAANID'
            ));
            $this->newtable->search(array(
                array(
                    '',
                    ''
                )
            ));
            if ($this->newsession->userdata('SESS_BBPOM_ID') == "00")
                $deleted = "";
            else
                $deleted = " AND C.STATUS NOT IN ('00')";
            if ($this->newsession->userdata('SESS_BBPOM_ID') == "00" || in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) {
                $this->newtable->search(array(
                    array(
                        '',
                        ''
                    )
                ));
                $query .= "SELECT TP.LAST_UPDATE AS LASTUPDATEROW, (CAST(TP.PENANDAAN_ID AS VARCHAR)+'/'+CAST(TP.KOMODITI AS VARCHAR)+'/'+CAST(TP.STATUS AS VARCHAR))+'/'+CAST(TP.BBPOM_ID AS VARCHAR) AS PENANDAANID,
                    '<b><a href=\"#\" class=\"row_preview\">'+TPP.NAMA_PRODUK+'</a></b><div>'+TPP.BENTUK_SEDIAAN+'</div><div>'+TPP.PRODUSEN+'</div>' AS 'PENGAWASAN PENANDAAN',
                    CONVERT(VARCHAR(10), TP.TANGGAL_MULAI, 120)+'<div>Sampai Dengan</div><div>'+CONVERT(VARCHAR(10), TP.TANGGAL_AKHIR, 120)+'</div>' AS 'TANGGAL PENGAWASAN', '<div><b>'+MB.NAMA_BBPOM+'</b></div>' AS 'BB / BPOM',
                    (CASE WHEN TP.KOMODITI = '013' THEN '<div>'+dbo.GET_KOMODITI(TP.KOMODITI)+'<b> &raquo '+(SELECT A.JENIS + ' (' + A.JENIS_PENGAWASAN + ')' FROM T_PENANDAAN_PANGAN A WHERE A.PENANDAAN_ID = TP.PENANDAAN_ID)+'</b></div>' ELSE dbo.GET_KOMODITI(TP.KOMODITI) END) AS KOMODITI,
                    MT.URAIAN AS 'STATUS TERAKHIR', '<div><b>'+dbo.GET_PROPINSI(MS.PROPINSI)+'</b></div>' AS PROPINSI,
                    dbo.GET_HISTORY_PENANDAAN('PENGAWASAN', TP.PENANDAAN_ID)+'<div>'+dbo.GET_HISTORY_PENANDAAN('CATATAN', TP.PENANDAAN_ID)+'</div><div><a href=\"#\" class=\"row_riwayat2\" record=\"'+CAST(TP.PENANDAAN_ID AS VARCHAR)+'#T_PENANDAAN_PROSES\">Riwayat Pemeriksaan</a></div>' AS [UPDATE TERAKHIR]
                    FROM T_PENANDAAN TP
                    LEFT JOIN T_PENANDAAN_PROSES TPP2 ON TPP2.PENANDAAN_ID = TP.PENANDAAN_ID
                    LEFT JOIN T_PENANDAAN_PRODUK TPP ON TPP.PENANDAAN_ID = TP.PENANDAAN_ID
                    LEFT JOIN T_USER TU ON TU.USER_ID = TP.USER_LAST_UPDATE
                    LEFT JOIN M_TABEL MT ON MT.KODE = TP.STATUS
                    LEFT JOIN M_SARANA MS ON MS.SARANA_ID = TP.SARANA_ID
                    LEFT JOIN M_BBPOM MB ON TP.BBPOM_ID = MB.BBPOM_ID
                    WHERE TPP2.SERI = (SELECT MAX (SERI) AS SERI FROM T_PENANDAAN_PROSES WHERE PENANDAAN_ID = TP.PENANDAAN_ID)";
                #WHERE TPP2.SERI = (SELECT MAX (SERI) AS SERI FROM T_PENANDAAN_PROSES WHERE PENANDAAN_ID = TP.PENANDAAN_ID AND TP.USER_LAST_UPDATE = TPP2.CREATEDBY)";
                $this->newtable->columns(array(
                    "TP.LAST_UPDATE",
                    "(CAST(TP.PENANDAAN_ID AS VARCHAR)+'/'+CAST(TP.KOMODITI AS VARCHAR)+'/'+CAST(TP.STATUS AS VARCHAR))+'/'+CAST(TP.BBPOM_ID AS VARCHAR)",
                    "'<b><a href=\"#\" class=\"row_preview\">'+TPP.NAMA_PRODUK+'</a></b><div>'+TPP.BENTUK_SEDIAAN+'</div><div>'+TPP.PRODUSEN+'</div>'",
                    "CONVERT(VARCHAR(10), TP.TANGGAL_MULAI, 120)+'<div>Sampai Dengan</div><div>'+CONVERT(VARCHAR(10), TP.TANGGAL_AKHIR, 120)+'</div>'",
                    "MB.NAMA_BBPOM",
                    "(CASE WHEN TP.KOMODITI = '013' THEN '<div>'+dbo.GET_KOMODITI(TP.KOMODITI)+'<b> &raquo '+(SELECT A.JENIS + ' (' + A.JENIS_PENGAWASAN + ')' FROM T_PENANDAAN_PANGAN A WHERE A.PENANDAAN_ID = TP.PENANDAAN_ID)+'</b></div>' ELSE dbo.GET_KOMODITI(TP.KOMODITI) END)",
                    "MT.URAIAN",
                    "'<div><b>'+dbo.GET_PROPINSI(MS.PROPINSI)+'</b></div>'",
                    "dbo.GET_HISTORY_PENANDAAN('PENGAWASAN', TP.PENANDAAN_ID)+'<div>'+dbo.GET_HISTORY_PENANDAAN('CATATAN', TP.PENANDAAN_ID)+'</div><div><a href=\"#\" class=\"row_riwayat2\" record=\"'+CAST(TP.PENANDAAN_ID AS VARCHAR)+'#T_PENANDAAN_PROSES\">Riwayat Pemeriksaan</a></div>'"
                ));
                $this->newtable->width(array(
                    'PENGAWASAN PENANDAAN' => 200,
                    'TANGGAL PENGAWASAN' => 150,
                    'KOMODITI' => 80,
                    'BB / BPOM' => 90,
                    'STATUS TERAKHIR' => 135,
                    'PROPINSI' => 115,
                    'UPDATE TERAKHIR' => 135
                ));
                $this->newtable->orderby(1);
            } else {
                $this->newtable->search(array(
                    array(
                        '',
                        ''
                    )
                ));
                $query .= "SELECT TP.LAST_UPDATE AS LASTUPDATEROW, (CAST(TP.PENANDAAN_ID AS VARCHAR)+'/'+CAST(TP.KOMODITI AS VARCHAR)+'/'+CAST(TP.STATUS AS VARCHAR))+'/'+CAST(TP.BBPOM_ID AS VARCHAR) AS PENANDAANID,
                    '<b><a href=\"#\" class=\"row_preview\">'+TPP.NAMA_PRODUK+'</a></b><div>'+TPP.BENTUK_SEDIAAN+'</div><div>'+TPP.PRODUSEN+'</div>' AS 'PENGAWASAN PENANDAAN', CONVERT(VARCHAR(10), TP.TANGGAL_MULAI, 120)+'<div>Sampai Dengan</div><div>'+CONVERT(VARCHAR(10), TP.TANGGAL_AKHIR, 120)+'</div>' AS 'TANGGAL PENGAWASAN',
                    '<div><b>'+MB.NAMA_BBPOM+'</b></div>' AS 'BB / BPOM',
                    (CASE WHEN TP.KOMODITI = '013' THEN '<div>'+dbo.GET_KOMODITI(TP.KOMODITI)+'<b> &raquo '+(SELECT A.JENIS + ' (' + A.JENIS_PENGAWASAN + ')' FROM T_PENANDAAN_PANGAN A WHERE A.PENANDAAN_ID = TP.PENANDAAN_ID)+'</b></div>' ELSE dbo.GET_KOMODITI(TP.KOMODITI) END) AS KOMODITI,
                    MT.URAIAN AS 'STATUS TERAKHIR', '<div><b>'+dbo.GET_PROPINSI(MS.PROPINSI)+'</b></div>' AS PROPINSI,
                    dbo.GET_HISTORY_PENANDAAN('PENGAWASAN', TP.PENANDAAN_ID)+'<div>'+dbo.GET_HISTORY_PENANDAAN('CATATAN', TP.PENANDAAN_ID)+'</div><div><a href=\"#\" class=\"row_riwayat2\" record=\"'+CAST(TP.PENANDAAN_ID AS VARCHAR)+'#T_PENANDAAN_PROSES\">Riwayat Pemeriksaan</a></div>' AS [UPDATE TERAKHIR]
                    FROM T_PENANDAAN TP
                    LEFT JOIN T_PENANDAAN_PROSES TPP2 ON TPP2.PENANDAAN_ID = TP.PENANDAAN_ID
                    LEFT JOIN T_PENANDAAN_PRODUK TPP ON TPP.PENANDAAN_ID = TP.PENANDAAN_ID
                    LEFT JOIN T_USER TU ON TU.USER_ID = TP.USER_LAST_UPDATE
                    LEFT JOIN M_TABEL MT ON MT.KODE = TP.STATUS
                    LEFT JOIN M_SARANA MS ON MS.SARANA_ID = TP.SARANA_ID
                    LEFT JOIN M_BBPOM MB ON TP.BBPOM_ID = MB.BBPOM_ID
                    WHERE TPP2.SERI = (SELECT MAX (SERI) AS SERI FROM T_PENANDAAN_PROSES WHERE PENANDAAN_ID = TP.PENANDAAN_ID AND TP.USER_LAST_UPDATE = TPP2.CREATEDBY)
                    AND TP.BBPOM_ID ='" . $this->newsession->userdata('SESS_BBPOM_ID') . "'";
                $this->newtable->columns(array(
                    "TP.LAST_UPDATE",
                    "(CAST(TP.PENANDAAN_ID AS VARCHAR)+'/'+CAST(TP.KOMODITI AS VARCHAR)+'/'+CAST(TP.STATUS AS VARCHAR))+'/'+CAST(TP.BBPOM_ID AS VARCHAR)",
                    "'<b><a href=\"#\" class=\"row_preview\">'+TPP.NAMA_PRODUK+'</a></b><div>'+TPP.BENTUK_SEDIAAN+'</div><div>'+TPP.PRODUSEN+'</div>'",
                    "CONVERT(VARCHAR(10), TP.TANGGAL_MULAI, 120)+'<div>Sampai Dengan</div><div>'+CONVERT(VARCHAR(10), TP.TANGGAL_AKHIR, 120)+'</div>'",
                    "MB.NAMA_BBPOM",
                    "(CASE WHEN TP.KOMODITI = '013' THEN '<div>'+dbo.GET_KOMODITI(TP.KOMODITI)+'<b> &raquo '+(SELECT A.JENIS + ' (' + A.JENIS_PENGAWASAN + ')' FROM T_PENANDAAN_PANGAN A WHERE A.PENANDAAN_ID = TP.PENANDAAN_ID)+'</b></div>' ELSE dbo.GET_KOMODITI(TP.KOMODITI) END)",
                    "MT.URAIAN",
                    "'<div><b>'+dbo.GET_PROPINSI(MS.PROPINSI)+'</b></div>'",
                    "dbo.GET_HISTORY_PENANDAAN('PENGAWASAN', TP.PENANDAAN_ID)+'<div>'+dbo.GET_HISTORY_PENANDAAN('CATATAN', TP.PENANDAAN_ID)+'</div><div><a href=\"#\" class=\"row_riwayat2\" record=\"'+CAST(TP.PENANDAAN_ID AS VARCHAR)+'#T_PENANDAAN_PROSES\">Riwayat Pemeriksaan</a></div>'"
                ));
                $this->newtable->width(array(
                    'PENGAWASAN PENANDAAN' => 200,
                    'TANGGAL PENGAWASAN' => 150,
                    'KOMODITI' => 80,
                    'BB / BPOM' => 90,
                    'STATUS TERAKHIR' => 135,
                    'PROPINSI' => 115,
                    'UPDATE TERAKHIR' => 135
                ));
                $this->newtable->orderby(1);
            }
            //      $proses['Edit Data Petugas Pemeriksa'] = array('GET', site_url() . "/home/pelaporan/petugas", '1');
            //      $proses['Lihat Data Temuan Produk'] = array('GET', site_url() . "/home/produk/view", '1');
            $proses['Lihat Data Pengawasan'] = array(
                'GET',
                site_url() . "/penandaan/penandaanController/prosesPreview/preview",
                '1'
            );
            //      $proses['Cetak Form Pemeriksaan'] = array('GETNEW', site_url() . "/home/bap", '1');
            if (array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')))
                $proses['Hapus Data Pemeriksaan'] = array(
                    'POST',
                    site_url() . "/penandaan/penandaanController/prosesDelete/delete",
                    'N'
                );
            $this->newtable->action(site_url() . "/penandaan/penandaanController/monitoringSrc/" . $cari . "/" . $subcari);
            $this->newtable->detail(site_url() . "/penandaan/penandaanController/setPreview/penandaan");
            $this->newtable->cidb($this->db);
            $this->newtable->ciuri($this->uri->segment_array());
            $this->newtable->sortby("DESC");
            $this->newtable->keys(array(
                'PENANDAANID'
            ));
            $this->newtable->menu($proses);
            $this->newtable->show_search(FALSE);
            if ($uricari[0] != "ALL")
                $query .= " AND TP.SURAT_ID IN (SELECT TSTP2.SURAT_ID FROM T_SURAT_TUGAS_PENANDAAN TSTP2 WHERE TSTP2.NOMOR_SURAT = '" . $uricari[0] . "')";
            if ($uricari[1] != "ALL") {
                $uricari[1] = str_replace(".", ",", str_replace("-", " ", $uricari[1]));
                $query .= " AND TPP.NAMA_PRODUK LIKE '%" . $uricari[1] . "%'";
            }
            if ($uricari[2] != "ALL")
                $query .= " AND DATEDIFF(dy, 0, convert(DATETIME, TP.TANGGAL_MULAI, 105)) >= DATEDIFF(dy, 0, convert(DATETIME, '" . $uricari[2] . "', 105))";
            if ($uricari[3] != "ALL")
                $query .= " AND DATEDIFF(dy, 0, convert(DATETIME, TP.TANGGAL_AKHIR, 105)) <= DATEDIFF(dy, 0, convert(DATETIME, '" . $uricari[3] . "', 105))";
            if ($uricari[4] != "ALL")
                $query .= " AND TP.STATUS = '" . $uricari[4] . "'";
            if ($urisubcari[0] != "ALL")
                $query .= " AND TSTP.CREATED_BY = '" . $urisubcari[0] . "'";
            if ($urisubcari[1] != "ALL")
                $query .= " AND TP.BBPOM_ID = '" . $urisubcari[1] . "'";
            if ($urisubcari[2] != "ALL")
                $query .= " AND TP.KOMODITI = '" . $urisubcari[2] . "'";
            $tabel   = $this->newtable->generate($query);
            $arrdata = array(
                'table' => $tabel,
                'search' => TRUE,
                'frmsearch' => $sipt->main->_showformpenandaan(site_url() . '/penandaan/penandaanController/monitoringSrc', $cari, $subcari),
                'idjudul' => 'judulpmnpdd',
                'caption_header' => 'Trakcing Pengawasan Penandaan',
                'batal' => '',
                'cancel' => ''
            );
            return $arrdata;
        } else {
            $this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.', '/home');
        }
    }
    
    function rekapStatusDokumen() {
        if ($this->newsession->userdata('LOGGED_IN') == TRUE) {
            $sipt =& get_instance();
            $this->load->model("main", "main", true);
            $this->load->library('newphpexcel');
            $komoditi = "'" . join("','", $this->newsession->userdata("SESS_KLASIFIKASI_ID")) . "'";
            $query    = "SELECT *, ([OPBALAIDRAFT] + [OPBALAIREJECT] + [OPBALAIREV] + [SPV1BALAITL] + [SPV1BALAIREJECT] + [SPV1BALAIREV] + [SPV2BALAITL] + [SPV2BALAIREJECT] + [SPV2BALAIREV] + [KABALAI] + [TLBALAI] + [OPPUSATDRAFT] + [OPPUSATREJECT] + [OPPUSATREV] + [SPV1PUSATTL] + [SPV1PUSATREJECT] + [SPV1PUSATREV] + [SPV2PUSATTL] + [SPV2PUSATREJECT] + [SPV2PUSATREV] + [DIREKTUR] + [SELESAI]) as TOTAL FROM(SELECT REPLACE(REPLACE(C.NAMA_BBPOM,'BALAI BESAR POM DI ', ''),'BALAI POM DI ','') AS NAMA_BBPOM, CASE WHEN A.STATUS = '20501' THEN 'OPBALAIDRAFT' WHEN A.STATUS = '20502' THEN 'OPBALAIREJECT' WHEN A.STATUS = '20503' THEN 'OPBALAIREV' WHEN A.STATUS = '30501' THEN 'SPV1BALAITL' WHEN A.STATUS = '30502' THEN 'SPV1BALAIREJECT' WHEN A.STATUS = '30504' THEN 'SPV1BALAIREV' WHEN A.STATUS = '40501' THEN 'SPV2BALAITL' WHEN A.STATUS = '40502' THEN 'SPV2BALAIREJECT' WHEN A.STATUS = '40503' THEN 'SPV2BALAIREV' WHEN A.STATUS = '50501' THEN 'KABALAI' WHEN A.STATUS = '20515' THEN 'TLBALAI' WHEN A.STATUS = '20511' THEN 'OPPUSATDRAFT' WHEN A.STATUS = '20512' THEN 'OPPUSATREJECT' WHEN A.STATUS = '20513' THEN 'OPPUSATREV' WHEN A.STATUS = '30511' THEN 'SPV1PUSATTL' WHEN A.STATUS = '30512' THEN 'SPV1PUSATREJECT' WHEN A.STATUS = '30514' THEN 'SPV1PUSATREV' WHEN A.STATUS = '40511' THEN 'SPV2PUSATTL' WHEN A.STATUS = '40512' THEN 'SPV2PUSATREJECT' WHEN A.STATUS = '40513' THEN 'SPV2PUSATREV' WHEN A.STATUS = '60511' THEN 'DIREKTUR' WHEN A.STATUS = '60510' THEN 'SELESAI' END AS STATUS FROM T_PENANDAAN A LEFT JOIN T_PENANDAAN_PROSES TPP2 ON TPP2.PENANDAAN_ID = A.PENANDAAN_ID LEFT JOIN M_BBPOM C ON A.BBPOM_ID = C.BBPOM_ID WHERE TPP2.SERI = (SELECT MAX (SERI) AS SERI FROM T_PENANDAAN_PROSES WHERE PENANDAAN_ID = A.PENANDAAN_ID AND A.USER_LAST_UPDATE = TPP2.CREATEDBY) AND A.KOMODITI IN ($komoditi) ";
            if (trim($this->input->post('AWAL') != "")) {
                $query .= $sipt->main->find_where($query);
                $query .= " DATEDIFF(dy, 0, convert(DATETIME, A.TANGGAL_MULAI, 105)) >= DATEDIFF(dy, 0, convert(DATETIME, '" . $this->input->post('AWAL') . "', 105))";
                $awal = $this->input->post('AWAL');
            } else {
                $query .= $sipt->main->find_where($query);
                $query .= " A.TANGGAL_MULAI > DATEADD(M, DATEDIFF(M,0,GETDATE()),0)";
                $awal = date('01/m/Y');
            }
            if (trim($this->input->post('AKHIR') != "")) {
                $query .= $sipt->main->find_where($query);
                $query .= " DATEDIFF(dy, 0, convert(DATETIME, A.TANGGAL_AKHIR, 105)) <= DATEDIFF(dy, 0, convert(DATETIME, '" . $this->input->post('AKHIR') . "', 105))";
                $akhir = $this->input->post('AKHIR');
            } else {
                $query .= $sipt->main->find_where($query);
                $query .= " A.TANGGAL_AKHIR < DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,0,GETDATE())+1,0))";
                $akhir = date('t/m/Y');
            }
            if (in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')) || $this->newsession->userdata('SESS_BBPOM_ID') == "00") {
                if (trim($this->input->post('BBPOM_ID')) == "") {
                    $query .= "";
                    $balai = 'Seluruh Balai';
                } else {
                    $query .= $sipt->main->find_where($query);
                    $query .= " A.BBPOM_ID = '" . $this->input->post('BBPOM_ID') . "'";
                    $balai = $sipt->main->get_uraian("SELECT NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID = '" . $this->input->post('BBPOM_ID') . "'", "NAMA_BBPOM");
                }
            } else {
                $query .= $sipt->main->find_where($query);
                $query .= " A.BBPOM_ID = '" . $this->newsession->userdata('SESS_BBPOM_ID') . "'";
                $balai = $sipt->main->get_uraian("SELECT NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID = '" . $this->newsession->userdata('SESS_BBPOM_ID') . "'", "NAMA_BBPOM");
            }
            $query .= $sipt->main->find_where($query);
            $query .= " LEN(A.STATUS) > 2";
            $query .= ") DT PIVOT(COUNT(STATUS) FOR STATUS IN ([OPBALAIDRAFT], [OPBALAIREJECT], [OPBALAIREV], [SPV1BALAITL], [SPV1BALAIREJECT], [SPV1BALAIREV], [SPV2BALAITL], [SPV2BALAIREJECT], [SPV2BALAIREV], [KABALAI], [TLBALAI], [OPPUSATDRAFT], [OPPUSATREJECT], [OPPUSATREV], [SPV1PUSATTL], [SPV1PUSATREJECT], [SPV1PUSATREV], [SPV2PUSATTL], [SPV2PUSATREJECT], [SPV2PUSATREV], [DIREKTUR], [SELESAI],[DIRETURNKEBALAI])) PVT";
            $this->newphpexcel->getDefaultStyle()->getFont()->setName('Calibri')->setSize(10);
            $this->newphpexcel->setActiveSheetIndex(0);
            $this->newphpexcel->mergecell(array(
                array(
                    'A6',
                    'A7'
                ),
                array(
                    'B6',
                    'B7'
                ),
                array(
                    'C6',
                    'E6'
                ),
                array(
                    'F6',
                    'H6'
                ),
                array(
                    'I6',
                    'K6'
                ),
                array(
                    'L6',
                    'L7'
                ),
                array(
                    'M6',
                    'P6'
                ),
                array(
                    'Q6',
                    'S6'
                ),
                array(
                    'T6',
                    'V6'
                ),
                array(
                    'W6',
                    'W7'
                ),
                array(
                    'X6',
                    'X7'
                ),
                array(
                    'Y6',
                    'Y7'
                )
            ), TRUE);
            $this->newphpexcel->width(array(
                array(
                    'A',
                    4
                ),
                array(
                    'B',
                    30
                ),
                array(
                    'C',
                    7
                ),
                array(
                    'D',
                    7
                ),
                array(
                    'E',
                    9
                ),
                array(
                    'F',
                    7
                ),
                array(
                    'G',
                    7
                ),
                array(
                    'H',
                    9
                ),
                array(
                    'I',
                    7
                ),
                array(
                    'J',
                    7
                ),
                array(
                    'K',
                    9
                ),
                array(
                    'L',
                    9
                ),
                array(
                    'M',
                    9
                ),
                array(
                    'N',
                    9
                ),
                array(
                    'O',
                    8
                ),
                array(
                    'P',
                    9
                ),
                array(
                    'Q',
                    7
                ),
                array(
                    'R',
                    9
                ),
                array(
                    'S',
                    9
                ),
                array(
                    'T',
                    7
                ),
                array(
                    'U',
                    9
                ),
                array(
                    'V',
                    9
                ),
                array(
                    'W',
                    8
                ),
                array(
                    'X',
                    8
                ),
                array(
                    'Y',
                    8
                )
            ));
            $this->newphpexcel->set_bold(array(
                'A1'
            ));
            $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A1', 'REKAPITULASI STATUS DOKUMEN PENGAWASAN PENANDAAN')->setCellValue('A3', 'Pemeriksaan Awal')->setCellValue('C3', $awal)->setCellValue('A4', 'Pemeriksaan Akhir')->setCellValue('C4', $akhir)->setCellValue('A5', 'Balai Besar / Balai POM')->setCellValue('C5', $balai);
            $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A6', 'No.')->setCellValue('B6', 'BB / BPOM / UNIT DITWAS')->setCellValue('C6', 'Operator Balai')->setCellValue('F6', 'SPV Satu Balai')->setCellValue('I6', 'SPV Dua Balai')->setCellValue('L6', 'Ka. Balai')->setCellValue('M6', 'Operator Pusat')->setCellValue('Q6', 'SPV Satu Pusat')->setCellValue('T6', 'SPV Dua Pusat')->setCellValue('W6', 'Direktur')->setCellValue('X6', 'Selesai')->setCellValue('Y6', 'Total')->setCellValue('C7', 'Draft')->setCellValue('D7', 'Ditolak')->setCellValue('E7', 'Perbaikan')->setCellValue('F7', 'Tindak Lanjut')->setCellValue('G7', 'Ditolak')->setCellValue('H7', 'Perbaikan')->setCellValue('I7', 'Tindak Lanjut')->setCellValue('J7', 'Ditolak Ka. Balai')->setCellValue('K7', 'Perbaikan')->setCellValue('M7', 'TL Balai')->setCellValue('N7', 'Draft Pusat')->setCellValue('O7', 'Ditolak')->setCellValue('P7', 'Perbaikan')->setCellValue('Q7', 'Tindak Lanjut')->setCellValue('R7', 'Ditolak')->setCellValue('S7', 'Perbaikan')->setCellValue('T7', 'Tindak Lanjut')->setCellValue('U7', 'Ditolak Direktur')->setCellValue('V7', 'Perbaikan');
            $this->newphpexcel->headings(array(
                'A7',
                'B7',
                'C7',
                'D7',
                'E7',
                'F7',
                'G7',
                'H7',
                'I7',
                'J7',
                'K7',
                'L7',
                'M7',
                'N7',
                'O7',
                'P7',
                'Q7',
                'R7',
                'S7',
                'T7',
                'U7',
                'V7',
                'W7',
                'X7',
                'Y7'
            ));
            $this->newphpexcel->headings(array(
                'A6',
                'B6',
                'C6',
                'D6',
                'E6',
                'F6',
                'G6',
                'H6',
                'I6',
                'J6',
                'K6',
                'L6',
                'M6',
                'N6',
                'O6',
                'P6',
                'Q6',
                'R6',
                'S6',
                'T6',
                'U6',
                'V6',
                'W6',
                'X6',
                'Y6'
            ));
            $this->newphpexcel->set_wrap(array(
                'C7',
                'D7',
                'E7',
                'F7',
                'G7',
                'H7',
                'I7',
                'J7',
                'K7',
                'L7',
                'M7',
                'N7',
                'O7',
                'P7',
                'Q7',
                'R7',
                'S7',
                'T7',
                'U7',
                'V7',
                'W7',
                'X7',
                'Y6'
            ));
            $data = $sipt->main->get_result($query);
            if ($data) {
                $no  = 1;
                $rec = 8;
                foreach ($query->result_array() as $row) {
                    $this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A' . $rec, $no)->setCellValue('B' . $rec, strtoupper($row["NAMA_BBPOM"]))->setCellValue('C' . $rec, $row["OPBALAIDRAFT"])->setCellValue('D' . $rec, $row["OPBALAIREJECT"])->setCellValue('E' . $rec, $row["OPBALAIREV"])->setCellValue('F' . $rec, $row["SPV1BALAITL"])->setCellValue('G' . $rec, $row["SPV1BALAIREJECT"])->setCellValue('H' . $rec, $row["SPV1BALAIREV"])->setCellValue('I' . $rec, $row["SPV2BALAITL"])->setCellValue('J' . $rec, $row["SPV2BALAIREJECT"])->setCellValue('K' . $rec, $row["SPV2BALAIREV"])->setCellValue('L' . $rec, $row["KABALAI"])->setCellValue('M' . $rec, $row["TLBALAI"])->setCellValue('N' . $rec, $row["OPPUSATDRAFT"])->setCellValue('O' . $rec, $row["OPPUSATREJECT"])->setCellValue('P' . $rec, $row["OPPUSATREV"])->setCellValue('Q' . $rec, $row["SPV1PUSATTL"])->setCellValue('R' . $rec, $row["SPV1PUSATREJECT"])->setCellValue('S' . $rec, $row["SPV1PUSATREV"])->setCellValue('T' . $rec, $row["SPV2PUSATTL"])->setCellValue('U' . $rec, $row["SPV2PUSATREJECT"])->setCellValue('V' . $rec, $row["SPV2PUSATREV"])->setCellValue('W' . $rec, $row["DIREKTUR"])->setCellValue('X' . $rec, $row["SELESAI"])->setCellValue('Y' . $rec, '=SUM(C' . $rec . ':X' . $rec . ')');
                    $this->newphpexcel->set_detilstyle(array(
                        'A' . $rec,
                        'B' . $rec,
                        'C' . $rec,
                        'D' . $rec,
                        'E' . $rec,
                        'F' . $rec,
                        'G' . $rec,
                        'H' . $rec,
                        'I' . $rec,
                        'J' . $rec,
                        'K' . $rec,
                        'L' . $rec,
                        'M' . $rec,
                        'N' . $rec,
                        'O' . $rec,
                        'P' . $rec,
                        'Q' . $rec,
                        'R' . $rec,
                        'S' . $rec,
                        'T' . $rec,
                        'U' . $rec,
                        'V' . $rec,
                        'W' . $rec,
                        'X' . $rec,
                        'Y' . $rec
                    ));
                    $rec++;
                    $no++;
                }
            } else {
                $this->newphpexcel->getActiveSheet()->mergeCells('A8:Y8');
                $this->newphpexcel->setActiveSheetIndex(1)->setCellValue('A8', 'Data Tidak Ditemukan');
            }
            ob_clean();
            $file = "REKAP_STATUS_DOC_" . date("YmdHis") . ".xls";
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
    
    function asalProduk($nie, $klasifikasi) {
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
        $data = "SELECT A.PRODUCT_ID FROM T_PRODUCT A  WHERE $kode AND A.PRODUCT_REGISTER = '$nie'";
        $res  = $this->main->get_result_webreg($data);
        if ($res) {
            return "OK";
        }
        return "NO";
    }
    
}

?>