<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR);
class Sampelx_act extends Model{
	function get_sampel($submenu){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE && in_array('7',$this->newsession->userdata('SESS_KODE_ROLE'))){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$arrdata = array('act' => site_url().'/post/ppomn/sampelx_act/save', 'caption' => 'Simpan', 'kode_sampel' => '', 'periksa_sampel' => '');
			if($submenu!=""){
				$arrid = explode(".",$submenu);
				$query = "SELECT dbo.FORMAT_NOMOR('SPL', A.KODE_SAMPEL) AS UR_KODE, A.KODE_SAMPEL, A.PERIKSA_SAMPEL, dbo.FORMAT_NOMOR('SPU', A.SPU_ID) AS FR_SPUID, A.SPU_ID, dbo.KATEGORI(A.KOMODITI) AS KO, A.KOMODITI, A.KATEGORI, A.SPU_ID, A.ANGGARAN, A.ASAL_SAMPEL, A.TUJUAN_SAMPLING, CONVERT(VARCHAR(10), A.TANGGAL_SAMPLING, 103) AS TANGGAL_SAMPLING, A.BULAN_ANGGARAN, A.SARANA_ID, A.TEMPAT_SAMPLING, A.ALAMAT_SAMPLING, A.KLASIFIKASI_TAMBAHAN, A.NAMA_SAMPEL, A.NOMOR_REGISTRASI, A.PABRIK, A.IMPORTIR, A.BENTUK_SEDIAAN, A.KEMASAN, A.NO_BETS, A.KETERANGAN_ED, A.JUMLAH_SAMPEL, A.SATUAN, A.HARGA_SAMPEL, A.UJI_KIMIA, A.JUMLAH_KIMIA, A.UJI_MIKRO, A.JUMLAH_MIKRO, A.UJI_BIO, A.JUMLAH_BIO, A.SISA, A.KOMPOSISI, A.NETTO, A.KONDISI_SAMPEL, A.EVALUASI_PENANDAAN, A.CARA_PENYIMPANAN, A.HASIL_KIMIA, A.HASIL_MIKRO, A.HASIL_BIO, A.UJI_ULANG, A.LAMPIRAN, A.SEGEL, A.LABEL, A.CATATAN AS [CATATAN SAMPEL], A.STATUS_KIMIA, A.STATUS_MIKRO, A.STATUS_SAMPEL, B.BBPOM_ID, B.NOMOR_SURAT, CONVERT(VARCHAR(10), TANGGAL_SURAT, 103) AS TANGGAL_SURAT, B.NAMA_PENGIRIM, B.NIP_PENGIRIM, B.SURAT_PENGANTAR, B.NIP_POLISI, B.PANGKAT, B.INSTITUSI, B.ALAMAT, B.KOTA, B.NO_RESI_BANK, CONVERT(VARCHAR(10), B.TANGGAL_RESI_BANK, 103) AS TANGGAL_RESI_BANK, B.BIAYA, B.NO_LP, CONVERT(VARCHAR(10), B.TANGGAL_LP, 103) AS TANGGAL_LP, B.NO_SPDP, CONVERT(VARCHAR(10), B.TANGGAL_SPDP, 103) AS TANGGAL_SPDP, B.SAKSI_POLISI, B.NAMA_TERSANGKA, CONVERT(VARCHAR(10), B.TANGGAL_TERIMA, 103) AS TANGGAL_TERIMA, B.HARI_TERIMA, B.SAKSI_UJI, B.JUMLAH_UJI, B.CATATAN AS [CATATAN SURAT], C.USER_ID, D.NAMA_USER FROM T_M_SAMPEL A LEFT JOIN T_PERIKSA_SAMPEL B ON A.PERIKSA_SAMPEL = B.PERIKSA_SAMPEL LEFT JOIN T_PETUGAS_SAMPEL C ON A.PERIKSA_SAMPEL = C.PERIKSA_SAMPEL LEFT JOIN T_USER D ON C.USER_ID = D.USER_ID WHERE A.KODE_SAMPEL = '".$arrid[1]."' AND A.PERIKSA_SAMPEL = '".$arrid[0]."'"; 
				$res = $sipt->main->get_result($query);
				if($res){
					$user_id = array();
					$nama_user = array();
					foreach($query->result_array() as $row){
						if(!array_key_exists($row['USER_ID'], $user_id)) $user_id[] = $row['USER_ID'];
						if(!array_key_exists($row['NAMA_USER'], $nama_user)) $nama_user[] = $row['NAMA_USER'];
						$arrdata = array('sess' => $row,
						                 'act' => site_url().'/post/ppomn/sampelx_act/update',
										 'user_id' => $user_id,
										 'nama_user' => $nama_user);

					}
					if(strlen($row['SPU_ID']) > 0)
						$arrdata['caption'] = "Proses Sampel";
					else
						$arrdata['caption'] = "Ubah";
					$arrdata['kode_sampel'] = $row['KODE_SAMPEL'];
					$arrdata['periksa_sampel'] = $row['PERIKSA_SAMPEL'];
					$arrdata['sel'][0] = substr($row['KATEGORI'],0,4);
					$arrdata['sel'][1] = substr($row['KATEGORI'],0,6);
					$arrdata['sel'][2] = $row['KATEGORI'];  
					
					$arrdata['selkategori'][0] = $sipt->main->combobox("SELECT KLASIFIKASI_ID, KLASIFIKASI FROM M_GOLONGAN WHERE KLASIFIKASI_ID LIKE '%".substr($row['KATEGORI'],0,2)."%__' AND LEN(KLASIFIKASI_ID) = '4' ORDER BY KLASIFIKASI_ID ASC", "KLASIFIKASI_ID", "KLASIFIKASI", TRUE);
					$arrdata['selkategori'][1] = $sipt->main->combobox("SELECT KLASIFIKASI_ID, KLASIFIKASI FROM M_GOLONGAN WHERE KLASIFIKASI_ID LIKE '%".substr($row['KATEGORI'],0,4)."%__' AND LEN(KLASIFIKASI_ID) = '6' ORDER BY KLASIFIKASI_ID ASC", "KLASIFIKASI_ID", "KLASIFIKASI", TRUE);
					$arrdata['selkategori'][2] = $sipt->main->combobox("SELECT KLASIFIKASI_ID, KLASIFIKASI FROM M_GOLONGAN WHERE KLASIFIKASI_ID LIKE '%".substr($row['KATEGORI'],0,6)."%__' AND LEN(KLASIFIKASI_ID) = '8' ORDER BY KLASIFIKASI_ID ASC", "KLASIFIKASI_ID", "KLASIFIKASI", TRUE);
					$arrdata['klasifikasi_tambahan'] = $sipt->main->combobox("SELECT NAMA_TAMBAHAN FROM M_GOLONGAN_TAMBAHAN WHERE KLASIFIKASI = '".substr($row['KATEGORI'],0,2)."' ORDER BY 1 ASC", "NAMA_TAMBAHAN", "NAMA_TAMBAHAN", TRUE);
					
					$arrdata['jml_log'] = $sipt->main->get_uraian("SELECT COUNT(*) AS JML FROM T_SAMPLING_LOG WHERE KODE_SAMPEL = '".$arrid[1]."'","JML");
					$arrdata['selkondisi'] = explode(",", $row['KONDISI_SAMPEL']);
					$arrdata['list_pnbp'] = $this->db->query("SELECT A.PNBP_ID, A.PNBP_TARIF, A.PNBP_JML, C.PNBP_DESCRIPTION, C.PNBP_UNIT, C.PNBP_AMOUNT FROM T_PNBP_SAMPLING A LEFT JOIN T_M_SAMPEL B ON A.KODE_SAMPEL = B.KODE_SAMPEL LEFT JOIN M_PNBP C ON A.PNBP_ID = C.PNBP_ID WHERE A.KODE_SAMPEL = '".$arrid[1]."'")->result_array();
				}
			}
			$arrdata['anggaran'] = $sipt->main->referensi("ANGGARAN_SAMPLING","'05','06','07'",FALSE,TRUE);
			$arrdata['asal'] = $sipt->main->referensi("ASAL_SAMPLING","'10','11','12'",FALSE,TRUE);
			$arrdata['komoditi'] = $sipt->main->combobox("SELECT KLASIFIKASI_ID, KLASIFIKASI FROM M_GOLONGAN WHERE LEN(KLASIFIKASI_ID) = 2", "KLASIFIKASI_ID", "KLASIFIKASI", TRUE);
			$arrdata['satuan'] = $sipt->main->combobox("SELECT SATUAN_ID, NAMA_SATUAN FROM M_SATUAN ORDER BY 2 ASC", "NAMA_SATUAN", "NAMA_SATUAN", TRUE);
			$arrdata['kondisi_sampel'] = $sipt->main->referensi("KONDISI_SAMPEL","",TRUE,TRUE);
			$arrdata['segel'] = $sipt->main->referensi("SEGEL_SAMPLING","",TRUE,TRUE);
			$arrdata['label_sampel'] = $sipt->main->referensi("LABEL_SAMPLING","",TRUE,TRUE);
			return $arrdata;
		}
	}
	
	function list_sampel($submenu){
		if($this->newsession->userdata('LOGGED_IN')){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$this->load->library('newtable');
			if($submenu == "draft"){
				$stts = " AND A.STATUS_SAMPEL = '70000' ";
			}else if($submenu == "all"){
				$stts = " AND A.STATUS_SAMPEL NOT IN ('70000','70001')";
			}else if($submenu == "reject"){
				$stts = " AND A.STATUS_SAMPEL = '70001'";
			}else{
				$stts = " AND A.STATUS_SAMPEL = '".$submenu."'";
			}
			if($this->newsession->userdata('SESS_BBPOM_ID') == "99" && (
			in_array('2', $this->newsession->userdata('SESS_KODE_ROLE')) || 
			in_array('3', $this->newsession->userdata('SESS_KODE_ROLE')) || 
			in_array('4', $this->newsession->userdata('SESS_KODE_ROLE')) || 
			in_array('11', $this->newsession->userdata('SESS_KODE_ROLE')))){
				foreach($this->newsession->userdata('SESS_KLASIFIKASI_ID') as $komoditi){
					$tmp  .= "'".substr($komoditi,-2). "',";
				}
				$tmps = substr($tmp,0,-1);
				$kk = " AND A.KOMODITI IN($tmps) ";
			}else{
				$kk = "";
			}
			$query = "SELECT A.PERIKSA_SAMPEL, A.KODE_SAMPEL, B.NOMOR_SURAT +'<div>Tanggal Surat : ' + CONVERT(VARCHAR(10), B.TANGGAL_SURAT, 120) + '</div><div>Asal Sampel : '+dbo.URAIAN_M_TABEL('ASAL_SAMPLING',A.ASAL_SAMPEL)+'</div><div>'+A.TEMPAT_SAMPLING+'</div>' AS [NOMOR SURAT / PENGANTAR], A.NAMA_SAMPEL + '<div>' + dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) + '</div><div>' + A.BENTUK_SEDIAAN + '</div><div>' + A.PABRIK + '</div><div>' + A.NOMOR_REGISTRASI + ', No Batch  : ' +  A.NO_BETS + '</div>' AS [IDENTITAS SAMPEL], CAST(A.JUMLAH_SAMPEL AS VARCHAR) +'&nbsp;'+ A.SATUAN +'<div>&bull;&nbsp;Uji Kimia : '+ CAST(A.JUMLAH_KIMIA AS VARCHAR)+'</div><div>&bull;&nbsp;Uji Mikro : '+CAST(A.JUMLAH_MIKRO AS VARCHAR) +'</div><div>&bull;&nbsp;Sisa Sampel : '+CAST(A.SISA AS VARCHAR) +'</div><div>' +CASE WHEN UJI_KIMIA = '1' AND UJI_MIKRO = '1' THEN 'Uji Kimia - Mikro' WHEN UJI_KIMIA = '1' THEN 'Uji Kimia' WHEN UJI_MIKRO = '1' THEN 'Uji Mikro' END+ '</div>' AS [JUMLAH UJI], dbo.KATEGORI(A.KOMODITI) + '<div>' + dbo.KATEGORI(A.KATEGORI) + '</div>' AS KOMODITI, dbo.URAIAN_M_TABEL('STATUS', A.STATUS_SAMPEL) AS [STATUS] FROM T_M_SAMPEL A LEFT JOIN T_PERIKSA_SAMPEL B ON A.PERIKSA_SAMPEL = B.PERIKSA_SAMPEL WHERE B.BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' $kk $stts AND A.ANGGARAN IN ('05','06','07')";
			$this->newtable->hiddens(array('PERIKSA_SAMPEL','KODE_SAMPEL'));
			$this->newtable->search(array(array("A.TEMPAT_SAMPLING", "Asal Sampel"),array("A.NAMA_SAMPEL","Nama Sampel"),array("dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL)","Kode Sampel"),array("A.TEMPAT_SAMPLING","Tempat Sampling"),array("dbo.KATEGORI(A.KOMODITI)","Komoditi"),array("dbo.KATEGORI(A.KATEGORI)","Kategori"),array("dbo.URAIAN_M_TABEL('STATUS', A.STATUS_SAMPEL)","Status / Proses Sampel")));
			$this->newtable->columns(array("A.PERIKSA_SAMPEL", "A.KODE_SAMPEL", "B.NOMOR_SURAT +'<div>Tanggal Surat : ' + CONVERT(VARCHAR(10), B.TANGGAL_SURAT, 120) + '</div><div>Asal Sampel : '+dbo.URAIAN_M_TABEL('ASAL_SAMPLING',A.ASAL_SAMPEL)+'</div><div>'+A.TEMPAT_SAMPLING+'</div>'",array("A.NAMA_SAMPEL + '<div>' + dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) + '</div><div>' + A.BENTUK_SEDIAAN + '</div><div>' + A.PABRIK + '</div><div>' + A.NOMOR_REGISTRASI + ', No Batch  : ' +  A.NO_BETS + '</div>'",site_url()."/home/ppomn/sampelx/preview/{PERIKSA_SAMPEL}.{KODE_SAMPEL}"),"CAST(A.JUMLAH_SAMPEL AS VARCHAR) +'&nbsp;'+ A.SATUAN +'<div>&bull;&nbsp;Uji Kimia : '+ CAST(A.JUMLAH_KIMIA AS VARCHAR)+'</div><div>&bull;&nbsp;Uji Mikro : '+CAST(A.JUMLAH_MIKRO AS VARCHAR) +'</div><div>&bull;&nbsp;Sisa Sampel : '+CAST(A.SISA AS VARCHAR) +'</div><div>' +CASE WHEN UJI_KIMIA = '1' AND UJI_MIKRO = '1' THEN 'Uji Kimia - Mikro' WHEN UJI_KIMIA = '1' THEN 'Uji Kimia' WHEN UJI_MIKRO = '1' THEN 'Uji Mikro' END+ '</div>'","dbo.KATEGORI(A.KOMODITI) + '<div>' + dbo.KATEGORI(A.KATEGORI) + '</div>'","dbo.URAIAN_M_TABEL('STATUS', A.STATUS_SAMPEL)"));
			$this->newtable->width(array('NOMOR SURAT / PENGANTAR' => 200,'IDENTITAS SAMPEL' => 225, 'JUMLAH UJI' => 85, 'KOMODITI' => 75, 'STATUS' => 105));
			$this->newtable->action(site_url()."/home/ppomn/sampelx/list/".$submenu);
			$this->newtable->cidb($this->db);
			$this->newtable->ciuri($this->uri->segment_array());
			$this->newtable->sortby("ASC");
			$this->newtable->keys(array('PERIKSA_SAMPEL','KODE_SAMPEL'));
			$this->newtable->orderby(1);
			$this->newtable->sortby("ASC");
			if($submenu == "draft"){
				$judul = "Draft Data Sampel";
				$proses['Edit Data Sampel'] = array('GET', site_url().'/home/ppomn/sampelx/new', '1');
				$proses['Hapus Data Sampel'] = array('POST', site_url().'/post/ppomn/sampelx_act/delete/ajax', 'N');
				//$proses['Kirim Ke Bidang Pengujian'] = array('POST', site_url().'/post/ppomn/sampelx_act/tps-bidang/ajax', 'N');
				$proses['Kirim Ke Bidang Pengujian'] = array('MPOST', site_url().'/post/ppomn/sampelx_act/tps-spk/ajax', 'N');
			}else if($submenu == "all"){
				$judul = "Sampel Dalam Proses";
			}else if($submenu == "reject"){
				$judul = "Perbaikan Sampel";
				$proses['Edit Data Sampel'] = array('GET', site_url().'/home/ppomn/sampelx/new', '1');
			}else if($submenu == "11001"){
				$judul = "Penerimaan Sampel di Bidang Pengujian";
				$proses['Tambahkan sebagai Konsep SPK Baru'] = array('MPOST', site_url().'/post/ppomn/sampelx_act/tps-spk/ajax', 'N');
			}
			$proses['Preview Data Sampel'] = array('GET', site_url().'/home/ppomn/sampelx/preview', '1');
			$this->newtable->menu($proses);
			$arrdata = array('table' => $this->newtable->generate($query),
							 'idjudul' => 'judulmsampel',
							 'caption_header' => $judul,
							 'batal' => '',
							 'cancel' => '');
			return $arrdata;
		}
	}

	function detil_sampel($id){
		if($this->newsession->userdata('LOGGED_IN') == "TRUE"){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$arrid = explode(".",$id);
			$query = "SELECT A.PERIKSA_SAMPEL, A.KODE_SAMPEL,dbo.KATEGORI(A.KOMODITI) AS KOMODITI,dbo.KATEGORI(A.KATEGORI) AS UR_KATEGORI,A.KLASIFIKASI_TAMBAHAN,A.NAMA_SAMPEL,A.NOMOR_REGISTRASI,A.PABRIK,IMPORTIR,A.BENTUK_SEDIAAN,A.KEMASAN,A.NO_BETS,A.KETERANGAN_ED,A.JUMLAH_SAMPEL,A.SATUAN,A.HARGA_SAMPEL,A.UJI_KIMIA,A.JUMLAH_KIMIA,A.UJI_MIKRO,A.SEGEL, A.LABEL,A.JUMLAH_MIKRO,A.SISA,REPLACE(A.KOMPOSISI,';','<br>') AS KOMPOSISI,A.NETTO,A.KONDISI_SAMPEL,A.EVALUASI_PENANDAAN,A.CARA_PENYIMPANAN,A.CATATAN,A.STATUS_KIMIA,A.STATUS_MIKRO,A.STATUS_SAMPEL,A.LAMPIRAN,B.BBPOM_ID FROM T_M_SAMPEL A LEFT JOIN T_PERIKSA_SAMPEL B ON A.PERIKSA_SAMPEL = B.PERIKSA_SAMPEL WHERE A.PERIKSA_SAMPEL = '".$arrid[0]."' AND A.KODE_SAMPEL = '".$arrid[1]."'"; 
			$data = $sipt->main->get_result($query);
			if($data){
				foreach($query->result_array() as $row){
					$arrdata['sess'] = $row;
				}
			}
			return $arrdata;
		}
	}
	
	function preview($id){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$arrid = explode(".",$id);
			$query = "SELECT dbo.FORMAT_NOMOR('SPL', A.KODE_SAMPEL) AS UR_KODE, A.KODE_SAMPEL, dbo.FORMAT_NOMOR('SPU', A.SPU_ID) AS FR_SPUID, A.SPU_ID, A.PERIKSA_SAMPEL, dbo.KATEGORI(A.KOMODITI) AS KO, A.KOMODITI, dbo.KATEGORI(A.KATEGORI) AS KATEGORI, A.SPU_ID, A.ANGGARAN, dbo.URAIAN_M_TABEL('ANGGARAN_SAMPLING', A.ANGGARAN) AS UR_ANGGARAN, dbo.URAIAN_M_TABEL('ASAL_SAMPLING',A.ASAL_SAMPEL) AS ASAL_SAMPEL, dbo.URAIAN_M_TABEL('TUJUAN_SAMPLING',A.TUJUAN_SAMPLING) AS TUJUAN_SAMPLING, CONVERT(VARCHAR(10), A.TANGGAL_SAMPLING, 103) AS TANGGAL_SAMPLING, A.BULAN_ANGGARAN, A.SARANA_ID, A.TEMPAT_SAMPLING, A.ALAMAT_SAMPLING, A.KLASIFIKASI_TAMBAHAN, A.NAMA_SAMPEL, A.NOMOR_REGISTRASI, A.PABRIK, A.IMPORTIR, A.BENTUK_SEDIAAN, A.KEMASAN, A.NO_BETS, A.KETERANGAN_ED, A.JUMLAH_SAMPEL, A.SATUAN, A.HARGA_SAMPEL, A.UJI_KIMIA, A.JUMLAH_KIMIA, A.UJI_MIKRO, A.JUMLAH_MIKRO, A.UJI_BIO, A.JUMLAH_BIO, A.SISA, A.KOMPOSISI, A.NETTO, A.KONDISI_SAMPEL, A.EVALUASI_PENANDAAN, A.CARA_PENYIMPANAN, A.HASIL_KIMIA, A.HASIL_MIKRO, A.HASIL_BIO, A.UJI_ULANG, A.LAMPIRAN, A.SEGEL, A.LABEL, A.CATATAN AS [CATATAN SAMPEL], A.STATUS_KIMIA, A.STATUS_MIKRO, A.STATUS_SAMPEL, B.BBPOM_ID, B.NOMOR_SURAT, CONVERT(VARCHAR(10), TANGGAL_SURAT, 103) AS TANGGAL_SURAT, B.NAMA_PENGIRIM, B.NIP_PENGIRIM, B.SURAT_PENGANTAR, B.NIP_POLISI, B.PANGKAT, B.INSTITUSI, B.ALAMAT, B.KOTA, B.NO_RESI_BANK, CONVERT(VARCHAR(10), B.TANGGAL_RESI_BANK, 103) AS TANGGAL_RESI_BANK, B.BIAYA, B.NO_LP, CONVERT(VARCHAR(10), B.TANGGAL_LP, 103) AS TANGGAL_LP, B.NO_SPDP, CONVERT(VARCHAR(10), B.TANGGAL_SPDP, 103) AS TANGGAL_SPDP, B.SAKSI_POLISI, B.NAMA_TERSANGKA, CONVERT(VARCHAR(10), B.TANGGAL_TERIMA, 103) AS TANGGAL_TERIMA, B.HARI_TERIMA, B.SAKSI_UJI, B.JUMLAH_UJI, B.CATATAN AS [CATATAN SURAT], C.USER_ID, D.NAMA_USER FROM T_M_SAMPEL A LEFT JOIN T_PERIKSA_SAMPEL B ON A.PERIKSA_SAMPEL = B.PERIKSA_SAMPEL LEFT JOIN T_PETUGAS_SAMPEL C ON A.PERIKSA_SAMPEL = C.PERIKSA_SAMPEL LEFT JOIN T_USER D ON C.USER_ID = D.USER_ID WHERE A.KODE_SAMPEL = '".$arrid[1]."' AND A.PERIKSA_SAMPEL = '".$arrid[0]."'";
			$res = $sipt->main->get_result($query);
			if($res){
				$user_id = array();
				$nama_user = array();
				foreach($query->result_array() as $row){
					if(!array_key_exists($row['USER_ID'], $user_id)) $user_id[] = $row['USER_ID'];
					if(!array_key_exists($row['NAMA_USER'], $nama_user)) $nama_user[] = $row['NAMA_USER'];
					$arrdata = array('sess' => $row,
									 'caption' => 'Ubah',
									 'act' => site_url().'/post/ppomn/sampelx_act/update',
									 'user_id' => $user_id,
									 'nama_user' => $nama_user);

				}
				$arrdata['jml_log'] = $sipt->main->get_uraian("SELECT COUNT(*) AS JML FROM T_SAMPLING_LOG WHERE KODE_SAMPEL = '".$arrid[1]."'","JML");
				$arrdata['status_spu'] = $sipt->main->get_uraian("SELECT STATUS FROM T_SPU WHERE SPU_ID = '".$row['SPU_ID']."'","STATUS");
				$arrdata['list_pnbp'] = $this->db->query("SELECT A.PNBP_ID, A.PNBP_TARIF, A.PNBP_JML, C.PNBP_DESCRIPTION, C.PNBP_UNIT FROM T_PNBP_SAMPLING A LEFT JOIN T_M_SAMPEL B ON A.KODE_SAMPEL = B.KODE_SAMPEL LEFT JOIN M_PNBP C ON A.PNBP_ID = C.PNBP_ID WHERE A.KODE_SAMPEL = '".$arrid[1]."'")->result_array();
			}
			return $arrdata;
		}
	}
	
	function set_sampel($action, $isajax){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE && (in_array('7',$this->newsession->userdata('SESS_KODE_ROLE')) || in_array('11',$this->newsession->userdata('SESS_KODE_ROLE')))){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			if($action=="save"){#Tambah Sampel Baru
				$hasil = FALSE;
				$msgok = "Tambah data sampel baru berhasil";
				$msgerr = "Tambah data sampel baru gagal, Silahkan coba lagi";
				$dtperiksa = $sipt->main->post_to_query($this->input->post('SURAT')); 
				$dtsampel = $sipt->main->post_to_query($this->input->post('SAMPEL'));
				if(trim($this->input->post('surat_id')) == ""){#Surat Pengantar Baru
					$periksa_sampel = (int)$sipt->main->get_uraian("SELECT MAX(PERIKSA_SAMPEL) AS MAXID FROM T_PERIKSA_SAMPEL", "MAXID") + 1;
					$dtperiksa['PERIKSA_SAMPEL'] = $periksa_sampel;
					if($dtsampel['ANGGARAN'] == "05"){
						$dtperiksa['NAMA_PENGIRIM'] = $this->input->post('pengirim_polisi');
						$dtperiksa['NIP_PENGIRIM'] = $this->input->post('nip_polisi'); 
					}else{
						$dtperiksa['NAMA_PENGIRIM'] = $this->input->post('pengirim_rutin');
						$dtperiksa['NIP_PENGIRIM'] = $this->input->post('nip_rutin'); 
					}
					if(array_key_exists('BIAYA', $dtperiksa)) $dtperiksa['BIAYA'] = (float)$dtperiksa['BIAYA'];
					if(array_key_exists('JUMLAH_UJI', $dtperiksa)) $dtperiksa['JUMLAH_UJI'] = (int)$dtperiksa['JUMLAH_UJI'];
					if($dtperiksa['TANGGAL_LP'] == "") $dtperiksa['TANGGAL_LP'] = null;
					if($dtperiksa['TANGGAL_SPDP'] == "") $dtperiksa['TANGGAL_SPDP'] = null;
					if($dtperiksa['TANGGAL_TERIMA'] == "") $dtperiksa['TANGGAL_TERIMA'] = null;
					if($dtperiksa['TANGGAL_RESI_BANK'] == "") $dtperiksa['TANGGAL_RESI_BANK'] = null;
					$dtperiksa['BBPOM_ID'] = $this->newsession->userdata('SESS_BBPOM_ID');
					$dtperiksa['CREATE_BY'] = $this->newsession->userdata('SESS_USER_ID');
					$dtperiksa['CREATE_DATE'] = 'GETDATE()';
					$res = $this->db->insert('T_PERIKSA_SAMPEL', $dtperiksa);
					if($res){
						$hasil = TRUE;
						$petugas_sampel['PERIKSA_SAMPEL'] = $periksa_sampel;
						$petugas_sampel['USER_ID'] = $this->newsession->userdata('SESS_USER_ID');
						$this->db->insert('T_PETUGAS_SAMPEL', $petugas_sampel);
					}else{
						$hasil = FALSE;
					}
				}else{
					$hasil = TRUE;
					$periksa_sampel = $this->input->post('surat_id');
				}
				
				if($hasil){
					$dtsampel['PERIKSA_SAMPEL'] = $periksa_sampel;
					$kategori= array_filter($this->input->post('KOMODITI'));
					$dtsampel['KATEGORI'] = $kategori[count($kategori)-1];
					$dtsampel['KOMODITI'] = substr($dtsampel['KATEGORI'], 0, 2);
					$dtsampel['KODE_SAMPEL'] = $sipt->main->set_kode_sampel('99',$dtsampel['ANGGARAN'],substr($dtsampel['KATEGORI'], 0, 2), join("",$this->input->post('lab')));
					$dtsampel['NAMA_SAMPEL'] = str_replace("'","",$dtsampel['NAMA_SAMPEL']);
					$dtsampel['PABRIK'] = str_replace("'","",$dtsampel['PABRIK']);
					$dtsampel['IMPORTIR'] = str_replace("'","",$dtsampel['IMPORTIR']);
					$dtsampel['JUMLAH_SAMPEL'] = (int)$dtsampel['JUMLAH_SAMPEL'];
					$dtsampel['JUMLAH_KIMIA'] = (int)$dtsampel['JUMLAH_KIMIA'];
					$dtsampel['JUMLAH_MIKRO'] = (int)$dtsampel['JUMLAH_MIKRO'];
					$dtsampel['SISA'] = (int)$dtsampel['SISA'];
					$dtsampel['HARGA_SAMPEL'] = 0;
					$dtsampel['KONDISI_SAMPEL'] = join(",", $this->input->post('KONDISI_SAMPEL'));
					if(in_array('M', $this->input->post('lab'))){
						$dtsampel['UJI_KIMIA'] = '0';
						$dtsampel['UJI_MIKRO'] = '1';
					}
					if(in_array('K', $this->input->post('lab'))){
						$dtsampel['UJI_KIMIA'] = '1';
						$dtsampel['UJI_MIKRO'] = '0';
					}
					if(in_array('M', $this->input->post('lab')) && in_array('K', $this->input->post('lab'))){
						$dtsampel['UJI_KIMIA'] = '1';
						$dtsampel['UJI_MIKRO'] = '1';
					}
					$dtsampel['STATUS_SAMPEL'] = '70000';
					$dtsampel['CREATE_BY'] = $this->newsession->userdata('SESS_USER_ID');
					$resampel = $this->db->insert('T_M_SAMPEL', $dtsampel);
					if($resampel){
						$sipt->main->set_max('sampel',substr($dtsampel['KATEGORI'], 0, 2));
						$arrpnbp = $this->input->post('PNBP');
						$arrkeys = array_keys($arrpnbp);
						for($i=0;$i<count($arrpnbp[$arrkeys[0]]);$i++){
							$seri = (int)$sipt->main->get_uraian("SELECT MAX(SERI) AS MAXID FROM T_PNBP_SAMPLING WHERE KODE_SAMPEL = '".$dtsampel['KODE_SAMPEL']."'", "MAXID") + 1;
							$datapnbp = array('KODE_SAMPEL' => $dtsampel['KODE_SAMPEL'],
											  'SERI' => $seri);
							for($j=0;$j<count($arrkeys);$j++){
								$datapnbp[$arrkeys[$j]] = $arrpnbp[$arrkeys[$j]][$i];
							}
							$this->db->insert('T_PNBP_SAMPLING', $datapnbp);
						}
						$data = array('KODE_SAMPEL' => $dtsampel['KODE_SAMPEL'],
									  'WAKTU' => 'GETDATE()',
									  'USER_ID' => $this->newsession->userdata('SESS_USER_ID'),
									  'KEGIATAN' => 'Simpan data sampel, dengan kode : '. $dtsampel['KODE_SAMPEL'],
									  'CATATAN' => '-');
						$this->db->insert('T_SAMPLING_LOG', $data);
						return "MSG#YES#$msgok#".site_url().'/home/ppomn/sampelx/list/draft';
					}
				}else{
					return "MSG#NO#$msgerr";
				}
				if($isajax!="ajax"){
					redirect(base_url());
					exit();
				}
			}
			else if($action=="update"){#Edit Sampel
				$hasil = FALSE;
				$msgok = "Edit data sampel baru berhasil";
				$msgerr = "Edit data sampel baru gagal, Silahkan coba lagi";
				$dtperiksa = $sipt->main->post_to_query($this->input->post('SURAT')); 
				$dtsampel = $sipt->main->post_to_query($this->input->post('SAMPEL'));
				if($dtsampel['ANGGARAN'] == "05"){
					$dtperiksa['NAMA_PENGIRIM'] = $this->input->post('pengirim_polisi');
					$dtperiksa['NIP_PENGIRIM'] = $this->input->post('nip_polisi'); 
				}else{
					$dtperiksa['NAMA_PENGIRIM'] = $this->input->post('pengirim_rutin');
					$dtperiksa['NIP_PENGIRIM'] = $this->input->post('nip_rutin'); 
				}
				if(array_key_exists('BIAYA', $dtperiksa)) $dtperiksa['BIAYA'] = (float)$dtperiksa['BIAYA'];
				if(array_key_exists('JUMLAH_UJI', $dtperiksa)) $dtperiksa['JUMLAH_UJI'] = (int)$dtperiksa['JUMLAH_UJI'];
				if($dtperiksa['TANGGAL_LP'] == "") $dtperiksa['TANGGAL_LP'] = null;
				if($dtperiksa['TANGGAL_SPDP'] == "") $dtperiksa['TANGGAL_SPDP'] = null;
				if($dtperiksa['TANGGAL_TERIMA'] == "") $dtperiksa['TANGGAL_TERIMA'] = null;
				if($dtperiksa['TANGGAL_RESI_BANK'] == "") $dtperiksa['TANGGAL_RESI_BANK'] = null;
				$this->db->where('PERIKSA_SAMPEL', $this->input->post('periksa_sampel'));
				$res = $this->db->update('T_PERIKSA_SAMPEL', $dtperiksa);
				if($res){
					$hasil = TRUE;
					$this->db->where('PERIKSA_SAMPEL', $this->input->post('periksa_sampel'));
					$this->db->delete('T_PETUGAS_SAMPEL');
					$petugas_sampel['PERIKSA_SAMPEL'] = $this->input->post('periksa_sampel');
					$petugas_sampel['USER_ID'] = $this->newsession->userdata('SESS_USER_ID');
					$this->db->insert('T_PETUGAS_SAMPEL', $petugas_sampel);
				}else{
					$hasil = FALSE;
				}
				if($hasil){
					$kategori= array_filter($this->input->post('KOMODITI'));
					$dtsampel['KATEGORI'] = $kategori[count($kategori)-1];
					$dtsampel['KOMODITI'] = substr($dtsampel['KATEGORI'], 0, 2);
					//$dtsampel['KODE_SAMPEL'] = $sipt->main->set_kode_sampel('99',$dtsampel['ANGGARAN'],substr($dtsampel['KATEGORI'], 0, 2), join("",$this->input->post('lab')));
					$dtsampel['NAMA_SAMPEL'] = str_replace("'","",$dtsampel['NAMA_SAMPEL']);
					$dtsampel['PABRIK'] = str_replace("'","",$dtsampel['PABRIK']);
					$dtsampel['IMPORTIR'] = str_replace("'","",$dtsampel['IMPORTIR']);
					$dtsampel['JUMLAH_SAMPEL'] = (int)$dtsampel['JUMLAH_SAMPEL'];
					$dtsampel['JUMLAH_KIMIA'] = (int)$dtsampel['JUMLAH_KIMIA'];
					$dtsampel['JUMLAH_MIKRO'] = (int)$dtsampel['JUMLAH_MIKRO'];
					$dtsampel['SISA'] = (int)$dtsampel['SISA'];
					$dtsampel['HARGA_SAMPEL'] = 0;
					$dtsampel['ALAMAT_SAMPLING'] = $sipt->main->get_uraian("SELECT ALAMAT_1 FROM M_SARANA WHERE SARANA_ID = '".$dtsampel['SARANA_ID']."'","ALAMAT_1");
					$dtsampel['KONDISI_SAMPEL'] = join(",", $this->input->post('KONDISI_SAMPEL'));
					if(in_array('M', $this->input->post('lab'))){
						$dtsampel['UJI_KIMIA'] = '0';
						$dtsampel['UJI_MIKRO'] = '1';
					}
					if(in_array('K', $this->input->post('lab'))){
						$dtsampel['UJI_KIMIA'] = '1';
						$dtsampel['UJI_MIKRO'] = '0';
					}
					if(in_array('M', $this->input->post('lab')) && in_array('K', $this->input->post('lab'))){
						$dtsampel['UJI_KIMIA'] = '1';
						$dtsampel['UJI_MIKRO'] = '1';
					}
					$this->db->where('KODE_SAMPEL', $this->input->post('kode_sampel'));
					$resampel = $this->db->update('T_M_SAMPEL', $dtsampel);
					if($resampel){
						//$sipt->main->set_max('sampel',substr($dtsampel['KATEGORI'], 0, 2));
						if(strlen($this->input->post('SPU_ID')) > 1){
							$kegiatan = $this->input->post('KEGIATAN');
							$last_status = $sipt->main->get_uraian("SELECT STATUS FROM T_SPU WHERE SPU_ID = '".$this->input->post('SPU_ID')."'","STATUS");
							$this->db->simple_query("UPDATE T_M_SAMPEL SET STATUS_SAMPEL = '".$last_status."' WHERE KODE_SAMPEL = '".$this->input->post('kode_sampel')."' AND SPU_ID = '".$this->input->post('SPU_ID')."'");
							$ret = "MSG#YES#$msgok#".site_url().'/home/ppomn/sampelx/list/all';
						}else{
							$kegiatan = "Ubah data sampel ". $this->input->post('kode_sampel');
							$ret = "MSG#YES#$msgok#".site_url().'/home/ppomn/sampelx/list/draft';
						}
						$this->db->where('KODE_SAMPEL', $this->input->post('kode_sampel'));
						$this->db->delete('T_PNBP_SAMPLING');
						$arrtemuan = $this->input->post('TEMUAN_PRODUK');
						$arrpnbp = $this->input->post('PNBP');
						$arrkeys = array_keys($arrpnbp);
						for($i=0;$i<count($arrpnbp[$arrkeys[0]]);$i++){
							$seri = (int)$sipt->main->get_uraian("SELECT MAX(SERI) AS MAXID FROM T_PNBP_SAMPLING WHERE KODE_SAMPEL = '".$this->input->post('kode_sampel')."'", "MAXID") + 1;
							$datapnbp = array('KODE_SAMPEL' => $this->input->post('kode_sampel'),
											  'SERI' => $seri);
							for($j=0;$j<count($arrkeys);$j++){
								$datapnbp[$arrkeys[$j]] = $arrpnbp[$arrkeys[$j]][$i];
							}
							$this->db->insert('T_PNBP_SAMPLING', $datapnbp);
						}
						$data = array('KODE_SAMPEL' => $this->input->post('kode_sampel'),
									  'WAKTU' => 'GETDATE()',
									  'USER_ID' => $this->newsession->userdata('SESS_USER_ID'),
									  'KEGIATAN' => $kegiatan,
									  'CATATAN' => '-');
						$this->db->insert('T_SAMPLING_LOG', $data);
						return $ret;
					}
				}else{
					return "MSG#NO#$msgerr";
				}
				if($isajax!="ajax"){
					redirect(base_url());
					exit();
				}
			}
			else if($action=="delete"){#Hapus Sampel
				$msgok  = 'Hapus data sampel berhasil.#';
				$msgerr = 'Hapus data sampel gagal, Silahkan coba lagi.';
				$hasil = FALSE;
				foreach($this->input->post('tb_chk') as $a){
					$id = explode(".",$a);
					$this->db->where('KODE_SAMPEL', $id[1]);
					$this->db->delete('T_M_SAMPEL');
					$data = array('KODE_SAMPEL' => $id[1],
								  'WAKTU' => 'GETDATE()',
								  'USER_ID' => $this->newsession->userdata('SESS_USER_ID'),
								  'KEGIATAN' => 'Hapus Data Sampel',
								  'CATATAN' => '-');
					$this->db->insert('T_SAMPLING_LOG', $data);
				}
				if($hasil){
					return "MSG#$msgok";
				}else{
					return "MSG#$msgerr";
				}
			}
			else if($action == "tolak"){
				$hasil = FALSE;
				$msgok = "Proses permintaan perbaikan sampel berhasil dikirim";
				$msgerr = "Proses permintaan perbaikan sampel gagal dikirim, Silahkan coba lagi";
				$res = $this->db->simple_query("UPDATE T_M_SAMPEL SET STATUS_SAMPEL = '70001' WHERE KODE_SAMPEL = '".$this->input->post('KODE_SAMPEL')."'");
				if($res){
					$hasil = TRUE;
					$data = array('KODE_SAMPEL' => $this->input->post('KODE_SAMPEL'),
								  'WAKTU' => 'GETDATE()',
								  'USER_ID' => $this->newsession->userdata('SESS_USER_ID'),
								  'KEGIATAN' => 'Perbaikan Sampel',
								  'CATATAN' => $this->input->post('KEGIATAN'));
					$this->db->insert('T_SAMPLING_LOG', $data);
				}
				if($hasil){
					return "MSG#YES#$msgok#".site_url()."/home/ppomn/spux/preview/".$this->input->post('SPU_ID').".".$this->input->post('STATUS_SPU');
				}else{
					return "MSG##NO#$msgerr";
				}
			}
			else if($action == "tps-spk"){#Konsep SPU / SPK di Bidang Pengujian
				$kode = ""; 
				foreach($this->input->post('tb_chk') as $chk){
					$id = explode(".", $chk);
					$kode .= "'".$id[1] . "'" . ",";
				}
				$arrid = substr($kode, 0, -1);
				$cek = $sipt->main->get_uraian("SELECT COUNT(JML) AS JML FROM (SELECT DISTINCT(KOMODITI) AS JML FROM T_M_SAMPEL WHERE KODE_SAMPEL IN ($arrid)) AS DATA","JML");
				if($cek > 1){
					echo "Pembuatan Data SPU Gagal. <br> Hal ini dikarenakan ada satu atau beberapa sampel yang berbeda komoditi. <br> Silahkan untuk melakukan kroscek kembali atau sorting data pada kolom KOMODITI daftar data sampel.";
					die();
				}else{
					$row = $this->db->query("SELECT KODE_SAMPEL, dbo.FORMAT_NOMOR('SPL', KODE_SAMPEL) AS [KODE SAMPEL], dbo.URAIAN_M_TABEL('ANGGARAN_SAMPLING',ANGGARAN) AS UR_ANGGARAN, ANGGARAN, BULAN_ANGGARAN, ASAL_SAMPEL, dbo.URAIAN_M_TABEL('ASAL_SAMPLING',ASAL_SAMPEL) AS UR_ASAL_SAMPEL, NAMA_SAMPEL, KOMODITI, dbo.KATEGORI(KOMODITI) AS [UR_KOMODITI], JUMLAH_SAMPEL, SATUAN, JUMLAH_KIMIA, JUMLAH_MIKRO, CASE WHEN UJI_KIMIA = '1' AND UJI_MIKRO = '1' THEN 'Uji Kimia - Mikro' WHEN UJI_KIMIA = '1' THEN 'Uji Kimia' WHEN UJI_MIKRO = '1' THEN 'Uji Mikro' END AS [JENIS UJI] FROM T_M_SAMPEL WHERE KODE_SAMPEL IN ($arrid)")->result_array();
					$bidang = $sipt->main->combobox("SELECT JENIS_SARANA_ID, NAMA_JENIS_SARANA FROM M_JENIS_SARANA WHERE JENIS_SARANA_ID LIKE 'B_1%'","JENIS_SARANA_ID","NAMA_JENIS_SARANA", TRUE);
					$data = array('act' => site_url().'/post/ppomn/spux_act/save',
								  'row' => $row,
								  'arrid' => $arrid,
								  'bidang' => $bidang);
					echo $this->load->view('pengujian/ppomn/spu-spk/new', $data);
				}
			}
			
		}
	}
	
}
?>
