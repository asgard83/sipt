<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR);
class Sampelx_act extends Model{
	function get_sampel($submenu){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE && in_array('7',$this->newsession->userdata('SESS_KODE_ROLE'))){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$arrdata = array('act' => site_url().'/post/sampelx/sampelx_act/save', 'caption' => 'Simpan', 'kode_sampel' => '', 'periksa_sampel' => '');
			$arrdata['komoditi'] = $sipt->main->combobox("SELECT KLASIFIKASI_ID, KLASIFIKASI FROM M_GOLONGAN_NEW WHERE LEN(KLASIFIKASI_ID) = 2  AND KLASIFIKASI_ID NOT IN ('05','06','13') ORDER BY KLASIFIKASI_ID", "KLASIFIKASI_ID", "KLASIFIKASI", TRUE);
			if($submenu!=""){
				$arrid = explode(".",$submenu);
				$query = "SELECT dbo.FORMAT_NOMOR('SPL', A.KODE_SAMPEL) AS UR_KODE, A.KODE_SAMPEL, dbo.FORMAT_NOMOR('SPU', A.SPU_ID) AS FR_SPUID, A.SPU_ID, A.PERIKSA_SAMPEL, dbo.KATEGORI(A.KOMODITI,A.PRIORITAS) AS KO, A.KOMODITI, LEN(A.KATEGORI) AS LENKATEGORI, A.KATEGORI, A.SPU_ID, A.ANGGARAN, A.ASAL_SAMPEL, A.TUJUAN_SAMPLING, A.PRIORITAS, CONVERT(VARCHAR(10), A.TANGGAL_SAMPLING, 103) AS TANGGAL_SAMPLING, A.BULAN_ANGGARAN, A.SARANA_ID, A.TEMPAT_SAMPLING, A.ALAMAT_SAMPLING, A.KLASIFIKASI_TAMBAHAN, A.NAMA_SAMPEL, A.NOMOR_REGISTRASI, A.PABRIK, A.IMPORTIR, A.BENTUK_SEDIAAN, A.KEMASAN, A.NO_BETS, A.KETERANGAN_ED, A.JUMLAH_SAMPEL, A.SATUAN, A.HARGA_SAMPEL, A.UJI_KIMIA, A.JUMLAH_KIMIA, A.UJI_MIKRO, A.JUMLAH_MIKRO, A.SISA, A.KOMPOSISI, A.NETTO, A.KONDISI_SAMPEL, A.EVALUASI_PENANDAAN, A.LABEL, A.SEGEL, A.CARA_PENYIMPANAN, A.HASIL_KIMIA, A.HASIL_MIKRO, A.UJI_UNGGULAN, A.LAMPIRAN, A.CATATAN AS [CATATAN SAMPEL], A.STATUS_KIMIA, A.STATUS_MIKRO, A.STATUS_SAMPEL, B.BBPOM_ID, B.NOMOR_SURAT, CONVERT(VARCHAR(10), TANGGAL_SURAT, 103) AS TANGGAL_SURAT, B.NAMA_PENGIRIM, B.NIP_PENGIRIM, B.SURAT_PENGANTAR, B.NIP_POLISI, B.PANGKAT, B.INSTITUSI, B.ALAMAT, B.KOTA, B.NO_RESI_BANK, CONVERT(VARCHAR(10), B.TANGGAL_RESI_BANK, 103) AS TANGGAL_RESI_BANK, B.BIAYA, B.NO_LP, CONVERT(VARCHAR(10), B.TANGGAL_LP, 103) AS TANGGAL_LP, B.NO_SPDP, CONVERT(VARCHAR(10), B.TANGGAL_SPDP, 103) AS TANGGAL_SPDP, B.SAKSI_POLISI, B.NAMA_TERSANGKA, CONVERT(VARCHAR(10), B.TANGGAL_TERIMA, 103) AS TANGGAL_TERIMA, B.HARI_TERIMA, B.SAKSI_UJI, B.JUMLAH_UJI, B.CATATAN AS [CATATAN SURAT], C.USER_ID, D.NAMA_USER FROM T_M_SAMPEL A LEFT JOIN T_PERIKSA_SAMPEL B ON A.PERIKSA_SAMPEL = B.PERIKSA_SAMPEL LEFT JOIN T_PETUGAS_SAMPEL C ON A.PERIKSA_SAMPEL = C.PERIKSA_SAMPEL LEFT JOIN T_USER D ON C.USER_ID = D.USER_ID WHERE A.KODE_SAMPEL = '".$arrid[1]."' AND A.PERIKSA_SAMPEL = '".$arrid[0]."'";
				$res = $sipt->main->get_result($query);
				if($res){
					$user_id = array();
					$nama_user = array();
					foreach($query->result_array() as $row){
						if(!array_key_exists($row['USER_ID'], $user_id)) $user_id[] = $row['USER_ID'];
						if(!array_key_exists($row['NAMA_USER'], $nama_user)) $nama_user[] = $row['NAMA_USER'];
						$arrdata = array('sess' => $row,
						                 'act' => site_url().'/post/sampelx/sampelx_act/update',
										 'user_id' => $user_id,
										 'nama_user' => $nama_user);

					}
					if(strlen($row['SPU_ID']) > 1)
						$arrdata['caption'] = "Proses Sampel";
					else
						$arrdata['caption'] = "Ubah";
					$ganjil = substr($row['KATEGORI'],0,4);
					$arrdata['kode_sampel'] = $row['KODE_SAMPEL'];
					$arrdata['periksa_sampel'] = $row['PERIKSA_SAMPEL'];
					$arrdata['sel'][0] = substr($row['KATEGORI'],0,4);
					$arrdata['sel'][1] = substr($row['KATEGORI'],0,6);
					if($row['PRIORITAS'] == "1"){
						if($ganjil == "0101" || $ganjil == "0105"){
							if($row['LENKATEGORI'] == 11) $arrdata['sel'][1] = substr($row['KATEGORI'],0,7);
						}
						$arrdata['sel'][2] = substr($row['KATEGORI'],0,8);
						if($ganjil == "0101" || $ganjil == "0105"){
							if($row['LENKATEGORI'] == 11) $arrdata['sel'][2] = substr($row['KATEGORI'],0,9);
						}
					}else if($row['PRIORITAS'] == "0"){
						$arrdata['sel'][1] = substr($row['KATEGORI'],0,6);
						$arrdata['sel'][2] = substr($row['KATEGORI'],0,8);
					}
					$arrdata['sel'][3] = $row['KATEGORI'];
					
					if($row['PRIORITAS'] == "1"){
						$arrdata['selkategori'][0] = $sipt->main->combobox("SELECT LTRIM(RTRIM(KLASIFIKASI_ID)) AS KLASIFIKASI_ID, KLASIFIKASI FROM M_GOLONGAN_NEW WHERE KLASIFIKASI_ID LIKE '".substr($row['KATEGORI'],0,2)."%__' AND LEN(KLASIFIKASI_ID) = '4' AND KLASIFIKASI <> '' ORDER BY KLASIFIKASI_ID ASC", "KLASIFIKASI_ID", "KLASIFIKASI", TRUE);
						if($ganjil == "0101" || $ganjil == "0105"){
							$arrdata['selkategori'][1] = $sipt->main->combobox("SELECT (LTRIM(RTRIM(KLASIFIKASI_ID))) AS KLASIFIKASI_ID, LTRIM(RTRIM(KLASIFIKASI)) AS KLASIFIKASI FROM M_GOLONGAN_NEW WHERE KLASIFIKASI_PARENT = '".$ganjil."' AND KLASIFIKASI_ID LIKE '".substr($row['KATEGORI'],0,4)."%__' OR KLASIFIKASI_ID LIKE '".substr($row['KATEGORI'],0,4)."%___' AND (LEN(KLASIFIKASI_ID) = '6' OR  LEN(KLASIFIKASI_ID) = '7')  AND KLASIFIKASI <> '' ORDER BY KLASIFIKASI ASC", "KLASIFIKASI_ID", "KLASIFIKASI", TRUE);
						}else{
							$arrdata['selkategori'][1] = $sipt->main->combobox("SELECT LTRIM(RTRIM(KLASIFIKASI_ID)) AS KLASIFIKASI_ID, KLASIFIKASI FROM M_GOLONGAN_NEW WHERE KLASIFIKASI_ID LIKE '".substr($row['KATEGORI'],0,4)."%__' AND LEN(KLASIFIKASI_ID) = '6' AND KLASIFIKASI <> '' ORDER BY KLASIFIKASI_ID ASC", "KLASIFIKASI_ID", "KLASIFIKASI", TRUE);
						}
						if($ganjil == "0101" || $ganjil == "0105"){
							$arrdata['selkategori'][2] = $sipt->main->combobox("SELECT (LTRIM(RTRIM(KLASIFIKASI_ID))) AS KLASIFIKASI_ID, LTRIM(RTRIM(KLASIFIKASI)) AS KLASIFIKASI FROM M_GOLONGAN_NEW WHERE KLASIFIKASI_ID LIKE '".substr($row['KATEGORI'],0,6)."%__' OR KLASIFIKASI_ID LIKE '".substr($row['KATEGORI'],0,6)."%___' AND (LEN(KLASIFIKASI_ID) = '8' OR  LEN(KLASIFIKASI_ID) = '9')  AND KLASIFIKASI <> '' ORDER BY KLASIFIKASI ASC", "KLASIFIKASI_ID", "KLASIFIKASI", TRUE);
						}else{
							$arrdata['selkategori'][2] = $sipt->main->combobox("SELECT LTRIM(RTRIM(KLASIFIKASI_ID)) AS KLASIFIKASI_ID, KLASIFIKASI FROM M_GOLONGAN_NEW WHERE KLASIFIKASI_ID LIKE '".substr($row['KATEGORI'],0,6)."%__' AND LEN(KLASIFIKASI_ID) = '8' AND KLASIFIKASI <> '' ORDER BY KLASIFIKASI_ID ASC", "KLASIFIKASI_ID", "KLASIFIKASI", TRUE);
						}
						if($ganjil == "0101" || $ganjil == "0105"){
							$arrdata['selkategori'][3] = $sipt->main->combobox("SELECT (LTRIM(RTRIM(KLASIFIKASI_ID))) AS KLASIFIKASI_ID, LTRIM(RTRIM(KLASIFIKASI)) AS KLASIFIKASI FROM M_GOLONGAN_NEW WHERE KLASIFIKASI_ID LIKE '".substr($row['KATEGORI'],0,8)."%__' OR KLASIFIKASI_ID LIKE '".substr($row['KATEGORI'],0,9)."%___' AND (LEN(KLASIFIKASI_ID) = '10' OR  LEN(KLASIFIKASI_ID) = '11')  AND KLASIFIKASI <> '' ORDER BY KLASIFIKASI ASC", "KLASIFIKASI_ID", "KLASIFIKASI", TRUE);
						}else{
							$arrdata['selkategori'][3] = $sipt->main->combobox("SELECT LTRIM(RTRIM(KLASIFIKASI_ID)) AS KLASIFIKASI_ID, KLASIFIKASI FROM M_GOLONGAN_NEW WHERE KLASIFIKASI_ID LIKE '".substr($row['KATEGORI'],0,8)."%__' AND LEN(KLASIFIKASI_ID) = '10' ORDER BY KLASIFIKASI_ID ASC", "KLASIFIKASI_ID", "KLASIFIKASI", TRUE);
						}
						if($ganjil == "0101" || $ganjil == "0105"){
							$arrdata['selkategori'][4] = $sipt->main->combobox("SELECT (LTRIM(RTRIM(KLASIFIKASI_ID))) AS KLASIFIKASI_ID, LTRIM(RTRIM(KLASIFIKASI)) AS KLASIFIKASI FROM M_GOLONGAN_NEW WHERE KLASIFIKASI_ID LIKE '".substr($row['KATEGORI'],0,10)."%__' OR KLASIFIKASI_ID LIKE '".substr($row['KATEGORI'],0,11)."%___' AND (LEN(KLASIFIKASI_ID) = '12' OR  LEN(KLASIFIKASI_ID) = '13')  AND KLASIFIKASI <> '' ORDER BY KLASIFIKASI ASC", "KLASIFIKASI_ID", "KLASIFIKASI", TRUE);
						}else{
							$arrdata['selkategori'][4] = $sipt->main->combobox("SELECT LTRIM(RTRIM(KLASIFIKASI_ID)) AS KLASIFIKASI_ID, KLASIFIKASI FROM M_GOLONGAN_NEW WHERE KLASIFIKASI_ID LIKE '".substr($row['KATEGORI'],0,10)."%__' AND LEN(KLASIFIKASI_ID) = '12' ORDER BY KLASIFIKASI_ID ASC", "KLASIFIKASI_ID", "KLASIFIKASI", TRUE);
						}
					}else if($row['PRIORITAS'] == "0"){
						$arrdata['selkategori'][0] = $sipt->main->combobox("SELECT LTRIM(RTRIM(KLASIFIKASI_ID)) AS KLASIFIKASI_ID, KLASIFIKASI FROM M_GOLONGAN WHERE KLASIFIKASI_ID LIKE '".substr($row['KATEGORI'],0,2)."%__' AND LEN(KLASIFIKASI_ID) = '4' ORDER BY KLASIFIKASI_ID ASC", "KLASIFIKASI_ID", "KLASIFIKASI", TRUE);
						$arrdata['selkategori'][1] = $sipt->main->combobox("SELECT LTRIM(RTRIM(KLASIFIKASI_ID)) AS KLASIFIKASI_ID, KLASIFIKASI FROM M_GOLONGAN WHERE KLASIFIKASI_ID LIKE '".substr($row['KATEGORI'],0,4)."%__' AND LEN(KLASIFIKASI_ID) = '6' ORDER BY KLASIFIKASI_ID ASC", "KLASIFIKASI_ID", "KLASIFIKASI", TRUE);
						$arrdata['selkategori'][2] = $sipt->main->combobox("SELECT LTRIM(RTRIM(KLASIFIKASI_ID)) AS KLASIFIKASI_ID, KLASIFIKASI FROM M_GOLONGAN WHERE KLASIFIKASI_ID LIKE '".substr($row['KATEGORI'],0,6)."%__' AND LEN(KLASIFIKASI_ID) = '8' ORDER BY KLASIFIKASI_ID ASC", "KLASIFIKASI_ID", "KLASIFIKASI", TRUE);
						$arrdata['selkategori'][3] = $sipt->main->combobox("SELECT LTRIM(RTRIM(KLASIFIKASI_ID)) AS KLASIFIKASI_ID, KLASIFIKASI FROM M_GOLONGAN WHERE KLASIFIKASI_ID LIKE '".substr($row['KATEGORI'],0,8)."%__' AND LEN(KLASIFIKASI_ID) = '10' ORDER BY KLASIFIKASI_ID ASC", "KLASIFIKASI_ID", "KLASIFIKASI", TRUE);
					}
					
					if(substr($row['KATEGORI'],0,2) == "01")
						$arrdata['klasifikasi_tambahan'] = $sipt->main->combobox("SELECT NAMA_TAMBAHAN FROM M_GOLONGAN_TAMBAHAN WHERE KLASIFIKASI = '".substr($row['KATEGORI'],0,4)."' ORDER BY 1 ASC", "NAMA_TAMBAHAN", "NAMA_TAMBAHAN", TRUE);
					else 
						$arrdata['klasifikasi_tambahan'] = $sipt->main->combobox("SELECT NAMA_TAMBAHAN FROM M_GOLONGAN_TAMBAHAN WHERE KLASIFIKASI = '".substr($row['KATEGORI'],0,2)."' ORDER BY 1 ASC", "NAMA_TAMBAHAN", "NAMA_TAMBAHAN", TRUE);
					
					if($row['SUB_TUJUAN'] != ""){
						$ko = substr($row['SUB_TUJUAN'], 0,2);
						$tipe = $row['TUJUAN_SAMPLING']; 
						$arrdata['sub_tujuan'] = $sipt->main->combobox("SELECT KODE, URAIAN FROM M_TABEL WHERE JENIS = 'SUB_TUJUAN' AND KODE LIKE '".$ko."%____' AND URAIAN_DETIL = '".$tipe."' ORDER BY 1 ASC", "KODE", "URAIAN", TRUE);
					}
					$arrdata['jml_log'] = $sipt->main->get_uraian("SELECT COUNT(*) AS JML FROM T_SAMPLING_LOG WHERE KODE_SAMPEL = '".$arrid[1]."'","JML");
					$arrdata['selkondisi'] = explode(",", $row['KONDISI_SAMPEL']);
					if((int)$row['PRIORITAS'] == 0){
						$arrdata['komoditi'] = $sipt->main->combobox("SELECT KLASIFIKASI_ID, KLASIFIKASI FROM M_GOLONGAN WHERE LEN(KLASIFIKASI_ID) = 2  AND KLASIFIKASI_ID NOT IN ('05','06') ORDER BY KLASIFIKASI_ID", "KLASIFIKASI_ID", "KLASIFIKASI", TRUE);
					}
					$arrdata['list_pnbp'] = $this->db->query("SELECT A.PNBP_ID, A.PNBP_TARIF, A.PNBP_JML, C.PNBP_DESCRIPTION, C.PNBP_UNIT, C.PNBP_AMOUNT FROM T_PNBP_SAMPLING A LEFT JOIN T_M_SAMPEL B ON A.KODE_SAMPEL = B.KODE_SAMPEL LEFT JOIN M_PNBP C ON A.PNBP_ID = C.PNBP_ID WHERE A.KODE_SAMPEL = '".$arrid[1]."'")->result_array();
				}
			}
			$arrdata['prioritas'] = array("" => "", "1" => "Data Prioritas Sampling", "0" => "Bukan Data Prioritas ");
			$arrdata['anggaran'] = $sipt->main->referensi("ANGGARAN_SAMPLING","'05','06','07'",FALSE,TRUE);
			$arrdata['asal'] = $sipt->main->referensi("ASAL_SAMPLING","'10','11','12'",FALSE,TRUE);
			$arrdata['satuan'] = $sipt->main->combobox("SELECT SATUAN_ID, NAMA_SATUAN FROM M_SATUAN ORDER BY 2 ASC", "NAMA_SATUAN", "NAMA_SATUAN", TRUE);
			$arrdata['kondisi_sampel'] = $sipt->main->referensi("KONDISI_SAMPEL","",TRUE,TRUE);
			$arrdata['segel'] = $sipt->main->referensi("SEGEL_SAMPLING","",TRUE,TRUE);
			$arrdata['label_sampel'] = $sipt->main->referensi("LABEL_SAMPLING","",TRUE,TRUE);
			$arrdata['unggulan'] = array('0'=>'Tidak', '1'=>'Ya');
			return $arrdata;
		}
	}
	
	function list_sampel($submenu){
		if($this->newsession->userdata('LOGGED_IN')){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$this->load->library('newtable');
			if($submenu == "draft"){
				$q = " AND A.STATUS_SAMPEL = '70000' AND A.CREATE_BY = '".$this->newsession->userdata('SESS_USER_ID')."'";
			}else if($submenu == "all"){
				$q = " AND A.STATUS_SAMPEL NOT IN ('70000')";
			}else if($submenu == "reject"){
				$q = " AND A.STATUS_SAMPEL = '70002' AND A.CREATE_BY = '".$this->newsession->userdata('SESS_USER_ID')."'";
			}
			$query = "SELECT A.PERIKSA_SAMPEL, A.KODE_SAMPEL, B.NOMOR_SURAT +'<div>Tanggal Surat : ' + CONVERT(VARCHAR(10), B.TANGGAL_SURAT, 120) + '</div><div>Asal Sampel : '+dbo.URAIAN_M_TABEL('ASAL_SAMPLING',A.ASAL_SAMPEL)+'</div><div>'+A.TEMPAT_SAMPLING+'</div>' AS [NOMOR SURAT / PENGANTAR], A.NAMA_SAMPEL + '<div>' + dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) + '</div><div>' + A.BENTUK_SEDIAAN + '</div><div>' + A.PABRIK + '</div><div>' + A.NOMOR_REGISTRASI + ', No Batch  : ' +  A.NO_BETS + '<div>Keterangan ED : '+A.KETERANGAN_ED+'</div></div>' AS [IDENTITAS SAMPEL], CAST(A.JUMLAH_SAMPEL AS VARCHAR) +'&nbsp;'+ A.SATUAN +'<div>&bull;&nbsp;Uji Kimia : '+ CAST(A.JUMLAH_KIMIA AS VARCHAR)+'</div><div>&bull;&nbsp;Uji Mikro : '+CAST(A.JUMLAH_MIKRO AS VARCHAR) +'</div><div>&bull;&nbsp;Sisa Sampel : '+CAST(A.SISA AS VARCHAR) +'</div><div>' +CASE WHEN UJI_KIMIA = '1' AND UJI_MIKRO = '1' THEN 'Uji Kimia - Mikro' WHEN UJI_KIMIA = '1' THEN 'Uji Kimia' WHEN UJI_MIKRO = '1' THEN 'Uji Mikro' END+ '</div>' AS [JUMLAH UJI], dbo.KATEGORI(A.KOMODITI, A.PRIORITAS) + '<div>' + A.NAMA_KATEGORI + '</div>' AS KOMODITI, dbo.URAIAN_M_TABEL('STATUS', A.STATUS_SAMPEL) AS [STATUS] FROM T_M_SAMPEL A LEFT JOIN T_PERIKSA_SAMPEL B ON A.PERIKSA_SAMPEL = B.PERIKSA_SAMPEL WHERE B.BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' $q AND A.ANGGARAN IN ('05','06','07')";
			$this->newtable->hiddens(array('PERIKSA_SAMPEL','KODE_SAMPEL'));
			$this->newtable->search(array(array("B.NOMOR_SURAT", "Nomor Surat Tugas / Pengantar"),array("CONVERT(VARCHAR(10), B.TANGGAL_SURAT, 120)", "Tanggal Surat"),array("A.TEMPAT_SAMPLING", "Asal Sampel"),array("A.NAMA_SAMPEL","Nama Sampel"),array("dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL)","Kode Sampel"),array("A.TEMPAT_SAMPLING","Tempat Sampling"),array("dbo.KATEGORI(A.KOMODITI, A.PRIORITAS)","Komoditi"),array("A.NAMA_KATEGORI","Kategori"),array("A.KETERANGAN_ED","Ket.Expired Date"),array("dbo.URAIAN_M_TABEL('STATUS', A.STATUS_SAMPEL)","Status / Proses Sampel")));
			$this->newtable->columns(array("A.PERIKSA_SAMPEL", "A.KODE_SAMPEL", "B.NOMOR_SURAT +'<div>Tanggal Surat : ' + CONVERT(VARCHAR(10), B.TANGGAL_SURAT, 120) + '</div><div>Asal Sampel : '+dbo.URAIAN_M_TABEL('ASAL_SAMPLING',A.ASAL_SAMPEL)+'</div><div>'+A.TEMPAT_SAMPLING+'</div>'",array("A.NAMA_SAMPEL + '<div>' + dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) + '</div><div>' + A.BENTUK_SEDIAAN + '</div><div>' + A.PABRIK + '</div><div>' + A.NOMOR_REGISTRASI + ', No Batch  : ' +  A.NO_BETS + '</div><div>Keterangan ED : '+A.KETERANGAN_ED+'</div>'",site_url()."/home/sampelx/preview/{PERIKSA_SAMPEL}.{KODE_SAMPEL}"),"CAST(A.JUMLAH_SAMPEL AS VARCHAR) +'&nbsp;'+ A.SATUAN +'<div>&bull;&nbsp;Uji Kimia : '+ CAST(A.JUMLAH_KIMIA AS VARCHAR)+'</div><div>&bull;&nbsp;Uji Mikro : '+CAST(A.JUMLAH_MIKRO AS VARCHAR) +'</div><div>&bull;&nbsp;Sisa Sampel : '+CAST(A.SISA AS VARCHAR) +'</div><div>' +CASE WHEN UJI_KIMIA = '1' AND UJI_MIKRO = '1' THEN 'Uji Kimia - Mikro' WHEN UJI_KIMIA = '1' THEN 'Uji Kimia' WHEN UJI_MIKRO = '1' THEN 'Uji Mikro' END+ '</div>'","dbo.KATEGORI(A.KOMODITI,A.PRIORITAS) + '<div>' + A.NAMA_KATEGORI + '</div>'","dbo.URAIAN_M_TABEL('STATUS', A.STATUS_SAMPEL)"));
			$this->newtable->width(array('NOMOR SURAT / PENGANTAR' => 200,'IDENTITAS SAMPEL' => 225, 'JUMLAH UJI' => 85, 'KOMODITI' => 75, 'STATUS' => 105));
			$this->newtable->action(site_url()."/home/sampelx/list/".$submenu);
			$this->newtable->cidb($this->db);
			$this->newtable->ciuri($this->uri->segment_array());
			$this->newtable->sortby("ASC");
			$this->newtable->keys(array('PERIKSA_SAMPEL','KODE_SAMPEL'));
			$this->newtable->orderby(1);
			$this->newtable->sortby("ASC");
			if($submenu == "draft"){
				$judul = "Draft Data Sampel";
				$proses['Tambah Data Sampel'] = array('GET', site_url().'/home/sampelx/new', '0');
				$proses['Edit Data Sampel'] = array('GET', site_url().'/home/sampelx/new', '1');
				$proses['Hapus Data Sampel'] = array('POST', site_url().'/post/sampelx/sampelx_act/delete/ajax', 'N');
				$proses['Tambahkan Ke Data SPU'] = array('MPOST', site_url().'/post/sampelx/sampelx_act/spu/ajax', 'N');
			}else if($submenu == "all"){
				$judul = "Sampel Dalam Proses";
				$proses['Preview Data Sampel'] = array('GET', site_url().'/home/sampelx/preview', '1');
			}else if($submenu == "reject"){
				$judul = "Perbaikan Sampel";
				$proses['Edit Data Sampel'] = array('GET', site_url().'/home/sampelx/new', '1');
			}
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
			$query = "SELECT A.PERIKSA_SAMPEL, A.KODE_SAMPEL,dbo.KATEGORI(A.KOMODITI,A.PRIORITAS) AS KOMODITI,dbo.KATEGORI(A.KATEGORI,A.PRIORITAS) AS UR_KATEGORIX, A.NAMA_KATEGORI AS UR_KATEGORI, A.KLASIFIKASI_TAMBAHAN,A.NAMA_SAMPEL,A.NOMOR_REGISTRASI,A.PABRIK,IMPORTIR,A.BENTUK_SEDIAAN,A.KEMASAN,A.NO_BETS,A.KETERANGAN_ED,A.JUMLAH_SAMPEL,A.SATUAN,A.HARGA_SAMPEL,A.LABEL, A.SEGEL, A.UJI_KIMIA,A.JUMLAH_KIMIA,A.UJI_MIKRO,A.JUMLAH_MIKRO,A.SISA,REPLACE(A.KOMPOSISI,';','<br>') AS KOMPOSISI,A.NETTO,A.KONDISI_SAMPEL,A.EVALUASI_PENANDAAN,A.CARA_PENYIMPANAN,A.CATATAN,A.STATUS_KIMIA,A.STATUS_MIKRO,A.STATUS_SAMPEL,A.LAMPIRAN,B.BBPOM_ID FROM T_M_SAMPEL A LEFT JOIN T_PERIKSA_SAMPEL B ON A.PERIKSA_SAMPEL = B.PERIKSA_SAMPEL WHERE A.PERIKSA_SAMPEL = '".$arrid[0]."' AND A.KODE_SAMPEL = '".$arrid[1]."'"; 
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
			$query = "SELECT A.KODE_SAMPEL, A.PERIKSA_SAMPEL, dbo.KATEGORI(A.KOMODITI,A.PRIORITAS) AS KO, A.KOMODITI, dbo.KATEGORI(A.KATEGORI,A.PRIORITAS) AS KATEGORIX, A.NAMA_KATEGORI AS KATEGORI, A.SPU_ID, A.ANGGARAN, dbo.URAIAN_M_TABEL('ANGGARAN_SAMPLING', A.ANGGARAN) AS UR_ANGGARAN, dbo.URAIAN_M_TABEL('ASAL_SAMPLING',A.ASAL_SAMPEL) AS ASAL_SAMPEL, dbo.URAIAN_M_TABEL('TUJUAN_SAMPLING',A.TUJUAN_SAMPLING) AS TUJUAN_SAMPLING, CONVERT(VARCHAR(10), A.TANGGAL_SAMPLING, 103) AS TANGGAL_SAMPLING, A.BULAN_ANGGARAN, A.SARANA_ID, A.TEMPAT_SAMPLING, A.ALAMAT_SAMPLING, A.KLASIFIKASI_TAMBAHAN, A.NAMA_SAMPEL, A.NOMOR_REGISTRASI, A.PABRIK, A.IMPORTIR, A.BENTUK_SEDIAAN, A.KEMASAN, A.NO_BETS, A.KETERANGAN_ED, A.JUMLAH_SAMPEL, A.LABEL, A.SEGEL, A.SATUAN, A.HARGA_SAMPEL, A.UJI_KIMIA, A.JUMLAH_KIMIA, A.UJI_MIKRO, A.JUMLAH_MIKRO, A.SISA, A.KOMPOSISI, A.NETTO, A.KONDISI_SAMPEL, A.EVALUASI_PENANDAAN, A.CARA_PENYIMPANAN,  RTRIM(LTRIM(A.HASIL_KIMIA)) AS HASIL_KIMIA, RTRIM(LTRIM(A.HASIL_MIKRO)) AS HASIL_MIKRO, A.UJI_UNGGULAN, A.LAMPIRAN, A.CATATAN AS [CATATAN SAMPEL], ISNULL(A.STATUS_KIMIA,'0') AS STATUS_KIMIA, ISNULL(A.STATUS_MIKRO,'0') AS STATUS_MIKRO, A.STATUS_SAMPEL, A.CATATAN_CP, A.PRIORITAS, B.BBPOM_ID, B.NOMOR_SURAT, CONVERT(VARCHAR(10), TANGGAL_SURAT, 103) AS TANGGAL_SURAT, B.NAMA_PENGIRIM, B.NIP_PENGIRIM, B.SURAT_PENGANTAR, B.NIP_POLISI, B.PANGKAT, B.INSTITUSI, B.ALAMAT, B.KOTA, B.NO_RESI_BANK, CONVERT(VARCHAR(10), B.TANGGAL_RESI_BANK, 103) AS TANGGAL_RESI_BANK, B.BIAYA, B.NO_LP, CONVERT(VARCHAR(10), B.TANGGAL_LP, 103) AS TANGGAL_LP, B.NO_SPDP, CONVERT(VARCHAR(10), B.TANGGAL_SPDP, 103) AS TANGGAL_SPDP, B.SAKSI_POLISI, B.NAMA_TERSANGKA, CONVERT(VARCHAR(10), B.TANGGAL_TERIMA, 103) AS TANGGAL_TERIMA, B.HARI_TERIMA, B.SAKSI_UJI, B.JUMLAH_UJI, B.CATATAN AS [CATATAN SURAT], C.USER_ID, D.NAMA_USER FROM T_M_SAMPEL A LEFT JOIN T_PERIKSA_SAMPEL B ON A.PERIKSA_SAMPEL = B.PERIKSA_SAMPEL LEFT JOIN T_PETUGAS_SAMPEL C ON A.PERIKSA_SAMPEL = C.PERIKSA_SAMPEL LEFT JOIN T_USER D ON C.USER_ID = D.USER_ID WHERE A.KODE_SAMPEL = '".$arrid[1]."' AND A.PERIKSA_SAMPEL = '".$arrid[0]."'";
			$res = $sipt->main->get_result($query);
			if($res){
				$user_id = array();
				$nama_user = array();
				foreach($query->result_array() as $row){
					if(!array_key_exists($row['USER_ID'], $user_id)) $user_id[] = $row['USER_ID'];
					if(!array_key_exists($row['NAMA_USER'], $nama_user)) $nama_user[] = $row['NAMA_USER'];
					$arrdata = array('sess' => $row,
									 'caption' => 'Ubah',
									 'act' => site_url().'/post/sampel/sampel_act/update',
									 'user_id' => $user_id,
									 'nama_user' => $nama_user);

				}
				$arrdata['jml_log'] = $sipt->main->get_uraian("SELECT COUNT(*) AS JML FROM T_SAMPLING_LOG WHERE KODE_SAMPEL = '".$arrid[1]."'","JML");
				$arrdata['list_pnbp'] = $this->db->query("SELECT A.PNBP_ID, A.PNBP_TARIF, A.PNBP_JML, C.PNBP_DESCRIPTION, C.PNBP_UNIT FROM T_PNBP_SAMPLING A LEFT JOIN T_M_SAMPEL B ON A.KODE_SAMPEL = B.KODE_SAMPEL LEFT JOIN M_PNBP C ON A.PNBP_ID = C.PNBP_ID WHERE A.KODE_SAMPEL = '".$arrid[1]."'")->result_array();
				$arrdata['file'] = base_url().'files/sampel/'.md5(trim($row['BBPOM_ID'])).'/'.$row['LAMPIRAN'];
				if($row['STATUS_SAMPEL'] == "40201"){
					$jmldispo = (int)$sipt->main->get_uraian("SELECT COUNT(*) AS JML FROM T_SAMPEL_MT WHERE SPU_ID = '".$row['SPU_ID']."' AND KODE_SAMPEL = '".$row['KODE_SAMPEL']."'","JML");
					if($jmldispo == 0 && (in_array('1', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('9', $this->newsession->userdata('SESS_KODE_ROLE')))){
						$arrdata['redispo'] = TRUE;
					}
				}
			}
			return $arrdata;
		}
	}
	
	function set_sampel($action, $isajax){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE && in_array('7',$this->newsession->userdata('SESS_KODE_ROLE'))){
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
					$arrrekap = $this->input->post('KOMODITI');
					$dtsampel['REKAP_KOMODITI'] = $arrrekap[1];
					$chk = (int)$sipt->main->get_uraian("SELECT AUTO_RESET FROM M_REF_SAMPEL WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND ANGGARAN = '".$dtsampel['ANGGARAN']."' AND KOMODITI = '".$dtsampel['KOMODITI']."'","AUTO_RESET");
					if($chk == 1)
						$dtsampel['KODE_SAMPEL'] = $sipt->main->set_kode_sampel('99',$dtsampel['ANGGARAN'],substr($dtsampel['KATEGORI'], 0, 2), join("",$this->input->post('lab')),$dtsampel['TANGGAL_SAMPLING']);
					else
						$dtsampel['KODE_SAMPEL'] = $sipt->main->set_kode_sampel('99',$dtsampel['ANGGARAN'],substr($dtsampel['KATEGORI'], 0, 2), join("",$this->input->post('lab')),$dtsampel['TANGGAL_SAMPLING']);
					$dtsampel['BBPOM_ID'] = $this->newsession->userdata('SESS_BBPOM_ID');
					$dtsampel['NAMA_SAMPEL'] = str_replace("'","",$dtsampel['NAMA_SAMPEL']);
					$dtsampel['PABRIK'] = str_replace("'","",$dtsampel['PABRIK']);
					$dtsampel['IMPORTIR'] = str_replace("'","",$dtsampel['IMPORTIR']);
					$dtsampel['JUMLAH_SAMPEL'] = (float)$dtsampel['JUMLAH_SAMPEL'];
					$dtsampel['JUMLAH_KIMIA'] = (float)$dtsampel['JUMLAH_KIMIA'];
					$dtsampel['JUMLAH_MIKRO'] = (float)$dtsampel['JUMLAH_MIKRO'];
					$dtsampel['SISA'] = (float)$dtsampel['SISA'];
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
					$dtsampel['CARA_PENYIMPANAN'] = str_replace("<"," < ",preg_replace('/[^(\x20-\x7F)]*/','',$sipt->main->clean_tags($dtsampel['CARA_PENYIMPANAN'])));
					$dtsampel['KOMPOSISI'] = str_replace(">", " > ", str_replace("<"," < ", preg_replace('/[^(\x20-\x7F)]*/','',$sipt->main->clean_tags($dtsampel['KOMPOSISI']))));
					$dtsampel['CATATAN'] = str_replace("<"," < ",preg_replace('/[^(\x20-\x7F)]*/','',$sipt->main->clean_tags($dtsampel['CATATAN'])));
					$dtsampel['CREATE_BY'] = $this->newsession->userdata('SESS_USER_ID');
					$dtsampel['CREATE_DATE'] = 'GETDATE()';
					$dtsampel['NAMA_KATEGORI'] = $sipt->main->get_uraian("SELECT REPLACE(dbo.KATEGORI('".$dtsampel['KATEGORI']."', '".$dtsampel['PRIORITAS']."'), '&raquo;', ' - ') AS NAMA_KATEGORI","NAMA_KATEGORI");
					$resampel = $this->db->insert('T_M_SAMPEL', $dtsampel);
					if($resampel){						
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
						return "MSG#YES#$msgok#".site_url().'/home/sampelx/list/draft';
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
					$arrrekap = $this->input->post('KOMODITI');
					$dtsampel['REKAP_KOMODITI'] = $arrrekap[1];
					$dtsampel['NAMA_SAMPEL'] = str_replace("'","",$dtsampel['NAMA_SAMPEL']);
					$dtsampel['PABRIK'] = str_replace("'","",$dtsampel['PABRIK']);
					$dtsampel['IMPORTIR'] = str_replace("'","",$dtsampel['IMPORTIR']);
					$dtsampel['JUMLAH_SAMPEL'] = (float)$dtsampel['JUMLAH_SAMPEL'];
					$dtsampel['JUMLAH_KIMIA'] = (float)$dtsampel['JUMLAH_KIMIA'];
					$dtsampel['JUMLAH_MIKRO'] = (float)$dtsampel['JUMLAH_MIKRO'];
					$dtsampel['SISA'] = (float)$dtsampel['SISA'];
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
					
					$dtsampel['CARA_PENYIMPANAN'] = str_replace("<"," < ",preg_replace('/[^(\x20-\x7F)]*/','',$sipt->main->clean_tags($dtsampel['CARA_PENYIMPANAN'])));
					$dtsampel['KOMPOSISI'] = str_replace(">", " > ", str_replace("<"," < ", preg_replace('/[^(\x20-\x7F)]*/','',$sipt->main->clean_tags($dtsampel['KOMPOSISI']))));
					$dtsampel['CATATAN'] = str_replace("<"," < ",preg_replace('/[^(\x20-\x7F)]*/','',$sipt->main->clean_tags($dtsampel['CATATAN'])));
					$dtsampel['NAMA_KATEGORI'] = $sipt->main->get_uraian("SELECT REPLACE(dbo.KATEGORI('".$dtsampel['KATEGORI']."', '".$dtsampel['PRIORITAS']."'), '&raquo;', ' - ') AS NAMA_KATEGORI","NAMA_KATEGORI");
					$this->db->where('KODE_SAMPEL', $this->input->post('kode_sampel'));
					$resampel = $this->db->update('T_M_SAMPEL', $dtsampel);
					if($resampel){
						//$sipt->main->set_max('sampel',substr($dtsampel['KATEGORI'], 0, 2));
						$this->db->where('KODE_SAMPEL', $this->input->post('kode_sampel'));
						$this->db->delete('T_PNBP_SAMPLING');
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
						
						$data = array('KODE_SAMPEL' => $dtsampel['KODE_SAMPEL'],
									  'WAKTU' => 'GETDATE()',
									  'USER_ID' => $this->newsession->userdata('SESS_USER_ID'),
									  'KEGIATAN' => 'Ubah data sampel',
									  'CATATAN' => '-');
						$this->db->insert('T_SAMPLING_LOG', $data);
						return "MSG#YES#$msgok#".site_url().'/home/sampelx/list/draft';
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
			else if($action=="spu"){#Create Data SPU dari Sampel Terpilih
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
					$row = $this->db->query("SELECT dbo.FORMAT_NOMOR('SPL', KODE_SAMPEL) AS [KODE SAMPEL], dbo.URAIAN_M_TABEL('ANGGARAN_SAMPLING',ANGGARAN) AS UR_ANGGARAN, ANGGARAN, BULAN_ANGGARAN, ASAL_SAMPEL, dbo.URAIAN_M_TABEL('ASAL_SAMPLING',ASAL_SAMPEL) AS UR_ASAL_SAMPEL, NAMA_SAMPEL, KOMODITI, dbo.KATEGORI(KOMODITI,PRIORITAS) AS [UR_KOMODITI], JUMLAH_SAMPEL, SATUAN, JUMLAH_KIMIA, JUMLAH_MIKRO, CASE WHEN UJI_KIMIA = '1' AND UJI_MIKRO = '1' THEN 'Uji Kimia - Mikro' WHEN UJI_KIMIA = '1' THEN 'Uji Kimia' WHEN UJI_MIKRO = '1' THEN 'Uji Mikro' END AS [JENIS UJI] FROM T_M_SAMPEL WHERE KODE_SAMPEL IN ($arrid)")->result_array();
					$data = array('act' => site_url().'/post/spux/spux_act/save',
								  'row' => $row,
								  'arrid' => $arrid,
								  'segel' => $sipt->main->referensi("SEGEL_SAMPLING","",TRUE,TRUE),
								  'label_sampel' => $sipt->main->referensi("LABEL_SAMPLING","",TRUE,TRUE));
					echo $this->load->view('pengujian/spu-external/new', $data);
				}
			}
			else if($action=="reject"){#Penolakan Sampel
				//print_r($_POST); die();
				//1.130920401120025KM
			}
		}
	}
	
}
?>
