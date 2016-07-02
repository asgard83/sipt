 <?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR);
class Spk_act extends Model{
	
	function get_spk($id){
		//print_r($_SESSION);die();
		if((in_array('3', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('4', $this->newsession->userdata('SESS_KODE_ROLE'))) && in_array('02', $this->newsession->userdata('SESS_JENIS_PELAPORAN')) && $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model('main','main',TRUE);
			$arrdata = array();
			if(in_array('B1',$this->newsession->userdata('SESS_SUB_SARANA')) || in_array('B2',$this->newsession->userdata('SESS_SUB_SARANA'))){
				$arrdata['jenis_uji'] = "02";
			}else if(in_array('B3',$this->newsession->userdata('SESS_SUB_SARANA'))){
				$arrdata['jenis_uji'] = "01";
			}
			$arrdata['sampel'] = $this->db->query("SELECT A.PERIKSA_SAMPEL, A.KODE_SAMPEL, A.SPU_ID, dbo.FORMAT_NOMOR('SPL', A.KODE_SAMPEL) AS UR_KODESAMPEL, A.KOMODITI, dbo.KATEGORI(A.KOMODITI,A.PRIORITAS) AS UR_KOMODITI, dbo.KATEGORI(A.KATEGORI,A.PRIORITAS) AS UR_KATEGORIX, A.NAMA_KATEGORI AS UR_KATEGORI, A.KATEGORI, SUBSTRING(KATEGORI,1,4) AS KAT, dbo.URAIAN_M_TABEL('SUB_TUJUAN', A.SUB_TUJUAN) AS SUB_TUJUAN, dbo.URAIAN_M_TABEL('ASAL_SAMPLING',A.ASAL_SAMPEL) AS ASAL_SAMPEL, dbo.URAIAN_M_TABEL('TUJUAN_SAMPLING',A.TUJUAN_SAMPLING) AS TUJUAN_SAMPLING, A.KLASIFIKASI_TAMBAHAN,A.NAMA_SAMPEL,A.NOMOR_REGISTRASI,A.PABRIK,IMPORTIR,A.BENTUK_SEDIAAN,A.KEMASAN,A.NO_BETS,A.KETERANGAN_ED,A.JUMLAH_SAMPEL,A.SATUAN,A.HARGA_SAMPEL,A.UJI_KIMIA,A.JUMLAH_KIMIA,A.UJI_MIKRO,A.JUMLAH_MIKRO,A.SISA,REPLACE(A.KOMPOSISI,';','<br>') AS KOMPOSISI,A.NETTO,A.KONDISI_SAMPEL,A.EVALUASI_PENANDAAN,A.CARA_PENYIMPANAN, A.LABEL, A.SEGEL,A.CATATAN,A.STATUS_KIMIA,A.STATUS_MIKRO,A.STATUS_SAMPEL,A.LAMPIRAN, A.PRIORITAS, B.BBPOM_ID, dbo.FORMAT_NOMOR('SP', C.NOMOR_SP) AS UR_SPP, CONVERT(VARCHAR(10), C.TANGGAL, 103) AS TGL_SPP, A.PRIORITAS, A.KATEGORI AS GOLONGAN, A.KODE_UNGGULAN, A.KODE_RUJUKAN FROM T_M_SAMPEL A LEFT JOIN T_PERIKSA_SAMPEL B ON A.PERIKSA_SAMPEL = B.PERIKSA_SAMPEL LEFT JOIN T_SPU C ON A.SPU_ID = C.SPU_ID WHERE A.KODE_SAMPEL = '".$id."'")->result_array(); 
			
			$arrdata['data_asal'] = 0;
			$arrdata['asal'] = array();
			if($arrdata['sampel'][0]['KODE_UNGGULAN'] != ''){
				$arrdata['asal'] = $this->db->query("SELECT dbo.FORMAT_NOMOR('SPL', A.KODE_SAMPEL) AS UR_KODESAMPEL, B.NAMA_BBPOM FROM T_M_SAMPEL A LEFT JOIN M_BBPOM B ON B.BBPOM_ID = A.BBPOM_ID WHERE A.KODE_SAMPEL='".$arrdata['sampel'][0]['KODE_UNGGULAN']."' AND A.UJI_UNGGULAN='1' ")->result_array();
				$arrdata['data_asal'] = 1;
				$arrdata['tipe'] = 'Unggulan';
			}else if($arrdata['sampel'][0]['KODE_RUJUKAN'] != ''){
				$arrdata['asal'] = $this->db->query("SELECT dbo.FORMAT_NOMOR('SPL', A.KODE_SAMPEL) AS UR_KODESAMPEL, B.NAMA_BBPOM FROM T_M_SAMPEL A LEFT JOIN M_BBPOM B ON B.BBPOM_ID = A.BBPOM_ID WHERE A.KODE_SAMPEL='".$arrdata['sampel'][0]['KODE_RUJUKAN']."' AND A.UJI_RUJUK='1' ")->result_array();
				$arrdata['data_asal'] = 1;
				$arrdata['tipe'] = 'Rujukan';
			}

			$arrdata['act'] = site_url().'/post/spk/spk_act/save';
			$arrdata['file'] = base_url().'files/sampel/'.md5(trim($arrdata['sampel'][0]['BBPOM_ID'])).'/'.$arrdata['sampel'][0]['LAMPIRAN'];
			if($arrdata['sampel'][0]['KOMODITI'] == "01"){
				//$query = "SELECT B.METODE, B.PUSTAKA, B.SYARAT, B.PARAMETER_UJI, B.ID, C.KETERANGAN, B.KETENTUAN_KHUSUS FROM t_m_sampel A LEFT JOIN m_prioritas_temp B ON B.GOLONGAN = A.KATEGORI LEFT JOIN m_puk C ON C.KOMODITI = A.KOMODITI AND C.PUK_ID = B.KETENTUAN_KHUSUS WHERE A.KODE_SAMPEL = '".$id."'";
				
				if(substr($arrdata['sampel'][0]['KATEGORI'], 0, 4) == "0106"){					
					$query = "SELECT ID AS PARAMETER_KRITIS, '0' AS PUK_ID, PARAMETER_UJI_KRITIS, '-' AS KETERANGAN FROM T_PARAMETER_UJI_KRITIS WHERE KATEGORI = '0106' AND STATUS = 1";
				}else{					
					$query = "SELECT B.PUK_ID, B.PARAMETER_KRITIS, C.PARAMETER_UJI_KRITIS, B.ID, D.KETERANGAN FROM t_m_sampel A LEFT JOIN T_KATEGORI_PUK B ON B.GOLONGAN =  A.KATEGORI  LEFT JOIN T_PARAMETER_UJI_KRITIS C ON B.PARAMETER_KRITIS = C.ID LEFT JOIN m_puk D ON D.KOMODITI = A.KOMODITI AND D.PUK_ID = B.PUK_ID WHERE A.KODE_SAMPEL = '".$id."' AND B.STATUS = '1' AND C.BIDANG_UJI='".$this->newsession->userdata('SESS_BIDANG_UJI')."'";
				}
				//echo $query;die();
				
				$sel = $this->db->query($query)->result_array();
				foreach($sel as $keysel => $valuesel){
					$arrdata['param']['val'][$valuesel['PUK_ID']] = $valuesel['KETERANGAN'];
					$arrdata['param'][$valuesel['PUK_ID']][$valuesel['PARAMETER_KRITIS']] = $valuesel['PARAMETER_UJI_KRITIS'];
				}
				
			}
			$jml = $sipt->main->get_uraian("SELECT COUNT(*) AS JML FROM T_SPK WHERE SPK_ID IN (SELECT SPK_ID FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL = '".$id."') AND CREATE_BY = '".$this->newsession->userdata('SESS_USER_ID')."'","JML");
			if($jml > 0){
				$arrdata['notallowed'] = TRUE;
				$query = "SELECT dbo.FORMAT_NOMOR('SPK', A.SPK_ID) UR_SPK, CONVERT(VARCHAR(10), A.TANGGAL, 103) AS TANGGAL,
B.NAMA_USER, C.PARAMETER_UJI, C.METODE, C.PUSTAKA, C.SYARAT, C.RUANG_LINGKUP FROM T_SPK A LEFT JOIN T_USER B ON A.KASIE = B.USER_ID
LEFT JOIN T_PARAMETER_HASIL_UJI C ON A.SPK_ID = C.SPK_ID WHERE C.KODE_SAMPEL = '".$id."' AND A.CREATE_BY = '".$this->newsession->userdata('SESS_USER_ID')."'";
				$data = $sipt->main->get_result($query);
				if($data){
					foreach($query->result_array() as $row){
						$parameter[] = $row;
						$arrdata['sess'] = $row;
						$arrdata['parameter'] = $parameter;
					}
				}
			}else{
				$arrdata['notallowed'] = FALSE;
			}
			return $arrdata;
		}
	}
	
	function get_review($id){
		if((in_array('3', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('4', $this->newsession->userdata('SESS_KODE_ROLE'))) && in_array('02', $this->newsession->userdata('SESS_JENIS_PELAPORAN')) && $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model('main','main',TRUE);
			$arrboleh = array('40205');
			$inboleh = $this->db->query("SELECT dbo.FORMAT_NOMOR('SPK',SPK_ID) AS SPK_ID, STATUS FROM T_SPK WHERE SPK_ID = '".$id."'")->result_array();
			if(!in_array($inboleh[0]['STATUS'], $arrboleh)){
				return $this->fungsi->redirectMessage('Maaf, SPK : '.$inboleh[0]['SPK_ID'].', tidak termasuk dalam revisi SPK."','/home/pengujian/sp/list/review'); exit();
			}
			$arrdata = array();
			$arrdata['act'] = site_url().'/post/spk/spk_act/review';
			$query = "SELECT A.SPU_ID, A.KODE_SAMPEL, A.SPK_ID, dbo.FORMAT_NOMOR('SPU', A.SPU_ID) AS UR_SPU, dbo.FORMAT_NOMOR('SPK', A.SPK_ID) AS UR_SPK, dbo.FORMAT_NOMOR('SPL', A.KODE_SAMPEL) AS UR_KODE, A.CREATE_BY, CONVERT(VARCHAR(10), A.TANGGAL, 103) AS TANGGAL_SPK, B.NAMA_USER, B.JABATAN FROM T_SPK A LEFT JOIN T_USER B ON A.KASIE = B.USER_ID WHERE A.SPK_ID = '".$id."'";
			$data = $sipt->main->get_result($query);
			if($data){
				foreach($query->result_array() as $row){
					$arrdata['sess'] = $row;
				}
				$arrdata['parameter'] = $this->db->query("SELECT A.UJI_ID, A.PARAMETER_UJI, A.METODE, A.PUSTAKA, A.SYARAT, A.RUANG_LINGKUP, A.STATUS, B.KATEGORI FROM T_PARAMETER_HASIL_UJI A LEFT JOIN T_M_SAMPEL B ON A.KODE_SAMPEL = B.KODE_SAMPEL WHERE A.SPK_ID = '".$id."'")->result_array();
				$arrdata['logspk'] = $sipt->main->get_uraian("SELECT COUNT(*) LOGSPK FROM T_SPK_LOG WHERE SPK_ID = '".$id."'","LOGSPK"); 
			}
			return $arrdata;
		}
	}
	
	function list_spk($id){
		if((in_array('3', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('4', $this->newsession->userdata('SESS_KODE_ROLE'))) && in_array('02', $this->newsession->userdata('SESS_JENIS_PELAPORAN')) && $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model('main','main',TRUE);
			$this->load->library('newtable');
			
			
			if($id == "verifikasi"){#SPK Baru
				$query =  "SELECT B.SPK_ID, A.SPU_ID, A.NOMOR_SP, C.KODE_SAMPEL, C.PERIKSA_SAMPEL, dbo.FORMAT_NOMOR('SPL', C.KODE_SAMPEL) AS [KODE SAMPEL], dbo.FORMAT_NOMOR('SPU',A.SPU_ID) AS [NOMOR SPU], dbo.FORMAT_NOMOR('SPK',B.SPK_ID) AS [NOMOR SPK], CONVERT(VARCHAR(10), B.TANGGAL, 120) AS [TANGGAL SPK], C.NAMA_SAMPEL +'<div>Komoditi : '+ dbo.KATEGORI(SUBSTRING(A.SPU_ID, 13,2),'0') +'</div>' AS [NAMA SAMPEL], dbo.URAIAN_M_TABEL('ASAL_SAMPLING',A.ASAL_SAMPEL) AS [ASAL SAMPLING], CASE WHEN C.UJI_RUJUK = 1  THEN 'Uji Rujuk' WHEN C.UJI_UNGGULAN=1 THEN 'Uji Unggulan' ELSE 'Rutin' END AS [TIPE UJI] FROM T_SPK B LEFT JOIN T_SPU A ON B.SPU_ID = A.SPU_ID LEFT JOIN T_M_SAMPEL C ON B.KODE_SAMPEL = C.KODE_SAMPEL WHERE A.BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND B.KASIE = '".$this->newsession->userdata('SESS_USER_ID')."' AND B.STATUS = '30201'";
				
				$this->newtable->search(array(array("dbo.FORMAT_NOMOR('SPL', C.KODE_SAMPEL)", "Kode Sampel"), array("C.NAMA_SAMPEL", "Nama Sampel"),array("dbo.FORMAT_NOMOR('SPU',A.SPU_ID)", "Nomor SPU"),
										  array("CONVERT(VARCHAR(10), B.TANGGAL, 120)", "Tanggal SPU"),
										  array("dbo.FORMAT_NOMOR('SPK',B.SPK_ID)", "Nomor SPK"),
										  array("CONVERT(VARCHAR(10), B.TANGGAL, 120)", "Tanggal SPK"),
										  array("CONVERT(VARCHAR(10), A.TANGGAL_PERINTAH, 120)", "Tanggal SP"),
										  array("dbo.KATEGORI(SUBSTRING(A.SPU_ID, 13,2),'0')", "Komoditi"),
										  array("dbo.URAIAN_M_TABEL('ASAL_SAMPLING',A.ASAL_SAMPEL)", "Asal Sampling"),
										  array("CASE WHEN C.UJI_RUJUK = 1  THEN 'Uji Rujuk' WHEN C.UJI_UNGGULAN=1 THEN 'Uji Unggulan' ELSE 'Rutin' ENDD", "Tipe Uji")));
				
				$this->newtable->columns(array("B.SPK_ID", "A.SPU_ID", "A.NOMOR_SP", "C.KODE_SAMPEL", "C.PERIKSA_SAMPEL", array("dbo.FORMAT_NOMOR('SPL', C.KODE_SAMPEL)",site_url()."/home/sampel/preview/{PERIKSA_SAMPEL}.{KODE_SAMPEL}"), "dbo.FORMAT_NOMOR('SPU',A.SPU_ID)","dbo.FORMAT_NOMOR('SPK',B.SPK_ID)", "CONVERT(VARCHAR(10), B.TANGGAL, 120)","C.NAMA_SAMPEL +'<div>Komoditi : '+ dbo.KATEGORI(SUBSTRING(A.SPU_ID, 13,2),'0') +'</div>'","dbo.URAIAN_M_TABEL('ASAL_SAMPLING',A.ASAL_SAMPEL)", "CASE WHEN C.UJI_RUJUK = 1  THEN 'Uji Rujuk' WHEN C.UJI_UNGGULAN=1 THEN 'Uji Unggulan' ELSE 'Rutin' END"));
				$this->newtable->width(array('KODE SAMPEL' => 135, 'NOMOR SPU' => 130, 'NOMOR SPK' => 130, 'TANGGAL SPK' => 80, 'NAMA SAMPEL' => 225, 'TIPE UJI' => 75));
				$this->newtable->keys(array('SPU_ID','SPK_ID'));
			}else if($id == "all"){#SPK Terkirim
				$query =  "SELECT B.SPK_ID, A.SPU_ID, A.NOMOR_SP, C.KODE_SAMPEL, C.PERIKSA_SAMPEL, dbo.FORMAT_NOMOR('SPL', C.KODE_SAMPEL) AS [KODE SAMPEL], dbo.FORMAT_NOMOR('SPU',A.SPU_ID) AS [NOMOR SPU], dbo.FORMAT_NOMOR('SPK',B.SPK_ID) AS [NOMOR SPK], CONVERT(VARCHAR(10), B.TANGGAL, 120) AS [TANGGAL SPK], dbo.FORMAT_NOMOR('SPP',D.SPP_ID) AS [NOMOR SPP], C.NAMA_SAMPEL +'<div>Komoditi : '+ dbo.KATEGORI(SUBSTRING(A.SPU_ID, 13,2),'0') +'</div>' AS [NAMA SAMPEL], dbo.URAIAN_M_TABEL('ASAL_SAMPLING',A.ASAL_SAMPEL) AS [ASAL SAMPLING], CASE WHEN C.UJI_RUJUK = 1  THEN 'Uji Rujuk' WHEN C.UJI_UNGGULAN=1 THEN 'Uji Unggulan' ELSE 'Rutin' END AS [TIPE UJI] FROM T_SPK B LEFT JOIN T_SPU A ON B.SPU_ID = A.SPU_ID LEFT JOIN T_M_SAMPEL C ON B.KODE_SAMPEL = C.KODE_SAMPEL LEFT JOIN T_SPP D ON B.SPK_ID = D.SPK_ID WHERE A.BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND B.KASIE = '".$this->newsession->userdata('SESS_USER_ID')."' AND B.STATUS NOT IN ('30201','30209')";
				
				$this->newtable->search(array(array("dbo.FORMAT_NOMOR('SPL', C.KODE_SAMPEL)", "Kode Sampel"), array("C.NAMA_SAMPEL", "Nama Sampel"),array("dbo.FORMAT_NOMOR('SPU',A.SPU_ID)", "Nomor SPU"),
										  array("CONVERT(VARCHAR(10), B.TANGGAL, 120)", "Tanggal SPU"),
										  array("dbo.FORMAT_NOMOR('SPK',B.SPK_ID)", "Nomor SPK"),
										  array("CONVERT(VARCHAR(10), B.TANGGAL, 120)", "Tanggal SPK"),
										  array("dbo.FORMAT_NOMOR('SPP',D.SPP_ID)", "Nomor SPP"),
										  array("dbo.KATEGORI(SUBSTRING(A.SPU_ID, 13,2),'0')", "Komoditi"),
										  array("dbo.URAIAN_M_TABEL('ASAL_SAMPLING',A.ASAL_SAMPEL)", "Asal Sampling"),
										  array("CASE WHEN C.UJI_RUJUK = 1  THEN 'Uji Rujuk' WHEN C.UJI_UNGGULAN=1 THEN 'Uji Unggulan' ELSE 'Rutin' END", "Tipe Uji")));
				
				$this->newtable->columns(array("B.SPK_ID", "A.SPU_ID", "A.NOMOR_SP", "C.KODE_SAMPEL", "C.PERIKSA_SAMPEL", array("dbo.FORMAT_NOMOR('SPL', C.KODE_SAMPEL)",site_url()."/home/pengujian/spp/view/{SPK_ID}"), "dbo.FORMAT_NOMOR('SPU',A.SPU_ID)","dbo.FORMAT_NOMOR('SPK',B.SPK_ID)", "CONVERT(VARCHAR(10), B.TANGGAL, 120)","dbo.FORMAT_NOMOR('SPP',D.SPP_ID)","C.NAMA_SAMPEL +'<div>Komoditi : '+ dbo.KATEGORI(SUBSTRING(A.SPU_ID, 13,2),'0') +'</div>'","dbo.URAIAN_M_TABEL('ASAL_SAMPLING',A.ASAL_SAMPEL)", "CASE WHEN C.UJI_RUJUK = 1  THEN 'Uji Rujuk' WHEN C.UJI_UNGGULAN=1 THEN 'Uji Unggulan' ELSE 'Rutin' END"));
				$this->newtable->hiddens(array('SPK_ID','SPU_ID','NOMOR_SP','KODE_SAMPEL','PERIKSA_SAMPEL'));
				$this->newtable->width(array('KODE SAMPEL' => 135, 'NOMOR SPU' => 130, 'NOMOR SPK' => 130, 'TANGGAL SPK' => 80, 'NOMOR SPP' => 130,'NAMA SAMPEL' => 225, 'TIPE UJI' => 75));
				$this->newtable->keys(array('SPK_ID'));
			}
			$this->newtable->hiddens(array('SPK_ID','SPU_ID','NOMOR_SP','KODE_SAMPEL','PERIKSA_SAMPEL'));
			$this->newtable->action(site_url()."/home/pengujian/spp/list/".$id);
			$this->newtable->cidb($this->db);
			$this->newtable->ciuri($this->uri->segment_array());
			$this->newtable->orderby(1);
			$this->newtable->sortby("ASC");
			if($id=="verifikasi"){
				$proses['Tambah Surat Perintah Pengujian Baru'] = array('GET', site_url()."/home/pengujian/spp/new", '1');
				$judul = 'Data Perintah Kerja';
			}else{
				#$proses['Detail Surat Perintah Pengujian'] = array('NEW', site_url()."/home/pengujian/spp/view", '1');
				$proses['Detail Surat Perintah Pengujian'] = array('GET', site_url()."/home/pengujian/spp/view", '1');
				$proses['Cetak Surat Perintah Pengujian'] = array('GETNEW', site_url()."/topdf/spp/prints", '1');
				$judul = 'Data Perintah Pengujian';
			}
			$this->newtable->menu($proses);
			$tabel = $this->newtable->generate($query);
			$arrdata = array('table' => $tabel,
							 'idjudul' => 'juduluji',
							 'caption_header' => $judul,
							 'batal' => '',
							 'cancel' => '');
			return $arrdata;
			

		}
	}
	
	function get_view($id){
		if((in_array('3', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('4', $this->newsession->userdata('SESS_KODE_ROLE'))) && in_array('02', $this->newsession->userdata('SESS_JENIS_PELAPORAN')) && $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model('main','main',TRUE);
			$arrdata = array();
			$arrdata['act'] = site_url().'/post/spk/spk_act/view';
			$spk_id = $sipt->main->get_uraian("SELECT SPK_ID FROM T_SPK WHERE KODE_SAMPEL = '".$id."' AND CREATE_BY = '".$this->newsession->userdata('SESS_USER_ID')."'","SPK_ID");
			$query = "SELECT A.SPU_ID, A.KODE_SAMPEL, A.SPK_ID, dbo.FORMAT_NOMOR('SPU', A.SPU_ID) AS UR_SPU, dbo.FORMAT_NOMOR('SPK', A.SPK_ID) AS UR_SPK, dbo.FORMAT_NOMOR('SPL', A.KODE_SAMPEL) AS UR_KODE, A.CREATE_BY, CONVERT(VARCHAR(10), A.TANGGAL, 103) AS TANGGAL_SPK, A.KASIE, B.NAMA_USER, B.JABATAN FROM T_SPK A LEFT JOIN T_USER B ON A.KASIE = B.USER_ID WHERE A.SPK_ID = '".$spk_id."'";
			$data = $sipt->main->get_result($query);
			if($data){
				foreach($query->result_array() as $row){
					$arrdata['sess'] = $row;
				}
				$arrdata['parameter'] = $this->db->query("SELECT A.UJI_ID, A.PARAMETER_UJI, A.METODE, A.PUSTAKA, A.SYARAT, A.RUANG_LINGKUP, B.KATEGORI, C.NAMA_USER AS PENYELIA, A.PENGUJI, D.NAMA_USER AS UR_PENGUJI FROM T_PARAMETER_HASIL_UJI A LEFT JOIN T_M_SAMPEL B ON A.KODE_SAMPEL = B.KODE_SAMPEL LEFT JOIN T_USER C ON A.PENYELIA = C.USER_ID LEFT JOIN T_USER D ON A.PENGUJI = D.USER_ID WHERE A.SPK_ID = '".$spk_id."'")->result_array();
				$arrdata['logspk'] = $sipt->main->get_uraian("SELECT COUNT(*) LOGSPK FROM T_SPK_LOG WHERE SPK_ID = '".$spk_id."'","LOGSPK"); 
				$arrdata['sampel'] = $this->db->query("SELECT A.PERIKSA_SAMPEL, A.KODE_SAMPEL, A.SPU_ID, dbo.FORMAT_NOMOR('SPL', A.KODE_SAMPEL) AS UR_KODESAMPEL, A.KOMODITI, dbo.KATEGORI(A.KOMODITI,A.PRIORITAS) AS UR_KOMODITI, dbo.KATEGORI(A.KATEGORI,A.PRIORITAS) AS UR_KATEGORIX, A.NAMA_KATEGORI AS UR_KATEGORI, A.KATEGORI, dbo.URAIAN_M_TABEL('SUB_TUJUAN', A.SUB_TUJUAN) AS SUB_TUJUAN, A.KLASIFIKASI_TAMBAHAN,A.NAMA_SAMPEL,A.NOMOR_REGISTRASI,A.PABRIK,IMPORTIR,A.BENTUK_SEDIAAN,A.KEMASAN,A.NO_BETS,A.KETERANGAN_ED,A.JUMLAH_SAMPEL,A.SATUAN,A.HARGA_SAMPEL,A.UJI_KIMIA,A.JUMLAH_KIMIA,A.UJI_MIKRO,A.JUMLAH_MIKRO,A.SISA,A.KOMPOSISI,A.NETTO,A.KONDISI_SAMPEL,A.EVALUASI_PENANDAAN,A.CARA_PENYIMPANAN, A.LABEL, A.SEGEL,A.CATATAN,A.STATUS_KIMIA,A.STATUS_MIKRO,A.STATUS_SAMPEL,A.LAMPIRAN, A.PRIORITAS, B.BBPOM_ID, dbo.FORMAT_NOMOR('SP', C.NOMOR_SP) AS UR_SPP, CONVERT(VARCHAR(10), C.TANGGAL, 103) AS TGL_SPP FROM T_M_SAMPEL A LEFT JOIN T_PERIKSA_SAMPEL B ON A.PERIKSA_SAMPEL = B.PERIKSA_SAMPEL LEFT JOIN T_SPU C ON A.SPU_ID = C.SPU_ID WHERE A.KODE_SAMPEL = '".$id."'")->result_array(); 
				$arrdata['arrpenguji'] = $sipt->main->combobox("SELECT USER_ID, NAMA_USER FROM T_USER WHERE USER_ID IN (SELECT USER_ID FROM T_USER_ROLE WHERE ROLE = '2' AND JENIS_PELAPORAN = '02') AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","USER_ID","NAMA_USER",TRUE);
				if(in_array('B1',$this->newsession->userdata('SESS_SUB_SARANA')) || in_array('B2',$this->newsession->userdata('SESS_SUB_SARANA'))){
					$arrdata['jenis_uji'] = "02";
				}else if(in_array('B3',$this->newsession->userdata('SESS_SUB_SARANA'))){
					$arrdata['jenis_uji'] = "01";
				}
			}
			return $arrdata;
		}
	}
	
	function get_detil($id){
		if((in_array('1', $this->newsession->userdata('SESS_KODE_ROLE'))  || in_array('9', $this->newsession->userdata('SESS_KODE_ROLE'))) && $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model('main','main',TRUE);
			$arrdata = array();
			$arrdata['act'] = site_url().'/post/spk/spk_act/detil';
			$arrid = explode(".",$id);
			$spk_id = $sipt->main->get_uraian("SELECT SPK_ID FROM T_SPK WHERE KODE_SAMPEL = '".$arrid[1]."' AND CREATE_BY = '".$arrid[2]."'","SPK_ID");
			$query = "SELECT A.SPU_ID, A.KODE_SAMPEL, A.SPK_ID, dbo.FORMAT_NOMOR('SPU', A.SPU_ID) AS UR_SPU, dbo.FORMAT_NOMOR('SPK', A.SPK_ID) AS UR_SPK, dbo.FORMAT_NOMOR('SPL', A.KODE_SAMPEL) AS UR_KODE, A.CREATE_BY, C.NAMA_USER AS MT, C.JABATAN AS JABATAN_MT, CONVERT(VARCHAR(10), A.TANGGAL, 103) AS TANGGAL_SPK, A.KASIE, B.NAMA_USER, B.JABATAN AS JABATAN_PENYELIA FROM T_SPK A LEFT JOIN T_USER B ON A.KASIE = B.USER_ID LEFT JOIN T_USER C ON A.CREATE_BY = C.USER_ID WHERE A.SPK_ID = '".$arrid[0]."'";
			$data = $sipt->main->get_result($query);
			if($data){
				foreach($query->result_array() as $row){
					$arrdata['sess'] = $row;
				}
				$arrdata['parameter'] = $this->db->query("SELECT A.UJI_ID,A.PARAMETER_UJI, A.METODE, A.PUSTAKA, A.SYARAT, A.RUANG_LINGKUP, B.KATEGORI, CASE WHEN A.JENIS_UJI = '01' THEN 'Mikrobiologi' WHEN A.JENIS_UJI = '02' THEN 'Kimia' END AS UR_JENIS_UJI, C.NAMA_USER AS PENYELIA, C.JABATAN, A.PENGUJI, D.NAMA_USER AS UR_PENGUJI FROM T_PARAMETER_HASIL_UJI A LEFT JOIN T_M_SAMPEL B ON A.KODE_SAMPEL = B.KODE_SAMPEL LEFT JOIN T_USER C ON A.PENYELIA = C.USER_ID LEFT JOIN T_USER D ON A.PENGUJI = D.USER_ID WHERE A.SPK_ID = '".$arrid[0]."'")->result_array();
				$arrdata['logspk'] = $sipt->main->get_uraian("SELECT COUNT(*) LOGSPK FROM T_SPK_LOG WHERE SPK_ID = '".$arrid[0]."'","LOGSPK"); 
				$arrdata['sampel'] = $this->db->query("SELECT A.PERIKSA_SAMPEL, A.KODE_SAMPEL, A.SPU_ID, dbo.FORMAT_NOMOR('SPL', A.KODE_SAMPEL) AS UR_KODESAMPEL, A.KOMODITI, dbo.KATEGORI(A.KOMODITI,A.PRIORITAS) AS UR_KOMODITI, dbo.KATEGORI(A.KATEGORI,A.PRIORITAS) AS UR_KATEGORIX, A.NAMA_KATEGORI AS UR_KATEGORI, A.KATEGORI, dbo.URAIAN_M_TABEL('SUB_TUJUAN', A.SUB_TUJUAN) AS SUB_TUJUAN, A.KLASIFIKASI_TAMBAHAN,A.NAMA_SAMPEL,A.NOMOR_REGISTRASI,A.PABRIK,IMPORTIR,A.BENTUK_SEDIAAN,A.KEMASAN,A.NO_BETS,A.KETERANGAN_ED,A.JUMLAH_SAMPEL,A.SATUAN,A.HARGA_SAMPEL,A.UJI_KIMIA,A.JUMLAH_KIMIA,A.UJI_MIKRO,A.JUMLAH_MIKRO,A.SISA,A.KOMPOSISI,A.NETTO,A.KONDISI_SAMPEL,A.EVALUASI_PENANDAAN,A.CARA_PENYIMPANAN, A.LABEL, A.SEGEL,A.CATATAN,A.STATUS_KIMIA,A.STATUS_MIKRO,A.STATUS_SAMPEL,A.LAMPIRAN,B.BBPOM_ID, dbo.FORMAT_NOMOR('SP', C.NOMOR_SP) AS UR_SPP, CONVERT(VARCHAR(10), C.TANGGAL, 103) AS TGL_SPP FROM T_M_SAMPEL A LEFT JOIN T_PERIKSA_SAMPEL B ON A.PERIKSA_SAMPEL = B.PERIKSA_SAMPEL LEFT JOIN T_SPU C ON A.SPU_ID = C.SPU_ID WHERE A.KODE_SAMPEL = '".$arrid[1]."'")->result_array(); 
				$arrdata['arrpenguji'] = $sipt->main->combobox("SELECT USER_ID, NAMA_USER FROM T_USER WHERE USER_ID IN (SELECT USER_ID FROM T_USER_ROLE WHERE ROLE = '2' AND JENIS_PELAPORAN = '02') AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","USER_ID","NAMA_USER",TRUE);
				if(in_array('B1',$this->newsession->userdata('SESS_SUB_SARANA')) || in_array('B2',$this->newsession->userdata('SESS_SUB_SARANA'))){
					$arrdata['jenis_uji'] = "02";
				}else if(in_array('B3',$this->newsession->userdata('SESS_SUB_SARANA'))){
					$arrdata['jenis_uji'] = "01";
				}
			}
			return $arrdata;
		}
	}
	
	function get_penyelia($id){
		if((in_array('2', $this->newsession->userdata('SESS_KODE_ROLE'))  || in_array('3', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('4', $this->newsession->userdata('SESS_KODE_ROLE'))) && in_array('02', $this->newsession->userdata('SESS_JENIS_PELAPORAN')) && $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model('main','main',TRUE);
			$arrdata = array();
			$arrid = explode(".",$id);
			$arrdata['act'] = site_url().'/post/spk/spk_act/edit-penyelia';
			$query = "SELECT A.SPU_ID, A.KODE_SAMPEL, A.SPK_ID, dbo.FORMAT_NOMOR('SPU', A.SPU_ID) AS UR_SPU, dbo.FORMAT_NOMOR('SPK', A.SPK_ID) AS UR_SPK, dbo.FORMAT_NOMOR('SPL', A.KODE_SAMPEL) AS UR_KODE, A.CREATE_BY, CONVERT(VARCHAR(10), A.TANGGAL, 103) AS TANGGAL_SPK, A.KASIE, B.NAMA_USER, B.JABATAN FROM T_SPK A LEFT JOIN T_USER B ON A.KASIE = B.USER_ID WHERE A.SPK_ID = '".$arrid[1]."' AND A.KODE_SAMPEL = '".$arrid[0]."'";
			$data = $sipt->main->get_result($query);
			if($data){
				foreach($query->result_array() as $row){
					$arrdata['sess'] = $row;
				}
				$arrdata['penyelia'] = $sipt->main->combobox("SELECT A.USER_ID, A.NAMA_USER +' - '+ A.JABATAN AS NAMA_USER FROM T_USER A LEFT JOIN T_USER_ROLE B ON A.USER_ID = B.USER_ID WHERE B.ROLE = '3' AND B.JENIS_PELAPORAN = '02' AND A.BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' GROUP BY A.USER_ID, A.NAMA_USER, A.JABATAN ORDER BY 2 ASC", "USER_ID", "NAMA_USER", TRUE);
			}
			return $arrdata;
		}
	}
		
	function set_spk($action, $isajax){
		$sipt =& get_instance();
		$this->load->model("main", "main", true);

		if($action == "redispospk"){
			if((in_array('1', $this->newsession->userdata('SESS_KODE_ROLE'))  || in_array('9', $this->newsession->userdata('SESS_KODE_ROLE'))) && $this->newsession->userdata('LOGGED_IN') ==  TRUE){
				$hasil = FALSE;
				$chk = FALSE;
				$msgok = "Revisi disposisi Surat Permintaan Kerja (SPK) berhasil disimpan";
				$msgerr = "Revisi disposisi Surat Permintaan Kerja (SPK) gagal disimpan";
				
				$mtsebelum = $sipt->main->get_uraian("SELECT CREATE_BY FROM T_SPK WHERE SPK_ID = '".$this->input->post('SPK_ID'). "' AND KODE_SAMPEL = '".$this->input->post('KODE_SAMPEL')."'","CREATE_BY");
				
				$jml = (int)$sipt->main->get_uraian("SELECT COUNT(*) AS JML FROM T_CP WHERE KODE_SAMPEL = '".$this->input->post('KODE_SAMPEL')."' AND MT = '".$mtsebelum."'","JML");
				
				$arrspk = array('CREATE_BY' => $this->input->post('CREATE_BY'),
								'KASIE' => $this->input->post('KASIE'),
								'TANGGAL' => $this->input->post('TANGGAL_SPK'));
				$this->db->where('SPK_ID', $this->input->post('SPK_ID'));
				$this->db->where('KODE_SAMPEL', $this->input->post('KODE_SAMPEL'));
				$resspk = $this->db->update('T_SPK', $arrspk);
				if($resspk){
					$chk = TRUE;
					if($chk){
						$arrpenyelia = array('PENYELIA' => $this->input->post('KASIE'));
						$this->db->where('SPK_ID', $this->input->post('SPK_ID'));
						$this->db->where('KODE_SAMPEL', $this->input->post('KODE_SAMPEL'));
						$respenyelia = $this->db->update('T_PARAMETER_HASIL_UJI', $arrpenyelia);
						if($respenyelia){
							if($jml > 0)
							{
								$arrupdatecp = array('MT' => $this->input->post('CREATE_BY'));
								$this->db->where('KODE_SAMPEL', $this->input->post('KODE_SAMPEL'));
								$this->db->where('MT', $mtsebelum);
								$this->db->update('T_CP', $arrupdatecp);
							}
							$hasil = TRUE;
						}
					}
				}
				if($hasil) return "MSG#YES#$msgok#".site_url();
				else return "MSG#NO#$msgerr";
			}
		}else{
			if((in_array('2', $this->newsession->userdata('SESS_KODE_ROLE'))  || in_array('3', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('4', $this->newsession->userdata('SESS_KODE_ROLE'))) && in_array('02', $this->newsession->userdata('SESS_JENIS_PELAPORAN')) && $this->newsession->userdata('LOGGED_IN') ==  TRUE){
				
				if($action=="save"){
					$hasil = FALSE;
					$yes_puk = false;
					$msgok = "Tambah data SPK baru berhasil";
					$msgerr = "Tambah SPK baru gagal, Silahkan coba lagi";
					$arr_petugas = $this->input->post('USER_ID');
					$ins = 0;
					$jmlspk = 0;
					$arr_spk['SPU_ID'] = $this->input->post('spuid');
					$arr_spk['BBPOM_ID'] = $this->newsession->userdata('SESS_BBPOM_ID');
					$arr_spk['KODE_SAMPEL'] = $this->input->post('kode_sampel');
					$arr_spk['KOMODITI'] = $this->input->post('komoditi');
					$arr_spk['TANGGAL'] = $this->input->post('TANGGAL');
					$arr_spk['KASIE'] = $this->input->post('KASIE');
					$arr_spk['CREATE_BY'] = $this->newsession->userdata('SESS_USER_ID');
					$arr_spk['CREATE_DATE'] = 'GETDATE()';
					$arr_spk['STATUS'] = '30201';
					if($this->input->post('jenis_uji') == "01"){
						$lab = "M";
					}else{
						$lab = "K";
					}
					
					
					$cekspk = $this->db->query("SELECT UJI_KIMIA, UJI_MIKRO FROM T_M_SAMPEL WHERE KODE_SAMPEL = '".$this->input->post('kode_sampel')."'")->row();
					
					if($cekspk->UJI_KIMIA == 1 && $cekspk->UJI_MIKRO == 1){
						$jmlspk = $sipt->main->get_uraian("SELECT COUNT(KODE_SAMPEL) AS JML FROM T_SPK WHERE KODE_SAMPEL = '".$this->input->post('kode_sampel')."' AND CREATE_BY = '".$this->newsession->userdata('SESS_USER_ID')."'","JML");
						if($jmlspk == 2){
							return "MSG#YES#Data SPK Kimia dan SPK Mikro sudah terdapat di dalam database. \n Silahkan mereload atau merefresh halaman input data SPK"; die();
						}
					}
					
					
					$chk = (int)$sipt->main->get_uraian("SELECT AUTO_RESET FROM M_REF_SPK WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND KOMODITI = '".$this->input->post('komoditi')."' AND BIDANG = '".$lab."'","AUTO_RESET");
					if($chk == 1)
					$arr_spk['SPK_ID'] = $sipt->main->set_kode_spk($this->input->post('komoditi'),$lab, $arr_spk['TANGGAL']);
					else $arr_spk['SPK_ID'] = $sipt->main->set_kode_spk($this->input->post('komoditi'),$lab, $arr_spk['TANGGAL']); 
					
					if($this->db->insert('T_SPK', $arr_spk)){
						$ins++;
					}else{
						$this->db->simple_query("DELETE FROM T_SPK WHERE SPK_ID ='".$arr_spk['SPK_ID']."'");
						#$this->db->simple_query("DELETE FROM T_PARAMETER_HASIL_UJI WHERE SPK_ID ='".$arr_spk['SPK_ID']."'");
					}
					if($ins > 0){
						$arrsampel = $this->input->post('UJI');
						$arrkeys = array_keys($arrsampel);
						if($this->input->post('jenis_uji') == "01"){
							$uji = '01'; //Mikrobiologi
						}else{
							$uji = '02'; //Kimia-Fisika
						}
						$kat = $sipt->main->get_uraian("SELECT LEFT(KATEGORI, 4) AS KATEGORI FROM T_M_SAMPEL WHERE KODE_SAMPEL = '".$this->input->post('kode_sampel')."'", "KATEGORI");
						
						if($kat != "0106" && $arr_spk['KOMODITI'] == "01" && count($arrsampel['KETENTUAN_KHUSUS']) != count($this->input->post('chkdt'))){			
							$arr_puk['PUK_ID'] = str_replace('SPK', 'PUK', $arr_spk['SPK_ID']);
							$arr_puk['SPK_ID'] = $arr_spk['SPK_ID'];
							$arr_puk['KODE_SAMPEL'] = $arr_spk['KODE_SAMPEL'];
							$arr_puk['BBPOM_ID'] = $arr_spk['BBPOM_ID'];
							$arrdata2 = $this->db->query("SELECT NAMA_SAMPEL, BENTUK_SEDIAAN, PABRIK, NOMOR_REGISTRASI, NO_BETS FROM T_M_SAMPEL WHERE KODE_SAMPEL = '$arr_spk[KODE_SAMPEL]'")->row_array();
							$arr_puk['NAMA_SAMPEL'] = $arrdata2['NAMA_SAMPEL'];
							$arr_puk['BENTUK_SEDIAAN'] = $arrdata2['BENTUK_SEDIAAN'];
							$arr_puk['PABRIK'] = $arrdata2['PABRIK'];
							$arr_puk['NOMOR_REGISTRASI'] = $arrdata2['NOMOR_REGISTRASI'];
							$arr_puk['NO_BETS'] = $arrdata2['NO_BETS'];
							$arr_puk['JUSTIFIKASI'] = $this->input->post('JUSTIFIKASI');
							$arr_puk['STATUS'] = '00001';
							$arr_puk['CREATE_BY'] = $this->newsession->userdata('SESS_USER_ID');
							$arr_puk['CREATE_DATE'] = 'GETDATE()';
							$arr_puk['UPDATE_BY'] = $this->newsession->userdata('SESS_USER_ID');
							$arr_puk['UPDATE_DATE'] = 'GETDATE()';
							$this->db->insert('T_SAMPEL_PUK', $arr_puk);								

							$ik = 1;
							$chkdt = $this->input->post('chkdt');
							$idk = $this->input->post('idk');
							foreach($arrsampel['KETENTUAN_KHUSUS'] as $key => $val){
								$arr_puk_det['PUK_ID'] = $arr_puk['PUK_ID'];
								$arr_puk_det['SERI'] = $ik;
								if($arr_puk_det['KETENTUAN_KHUSUS'] == 'new'){
									$arr_puk_det['KETENTUAN_KHUSUS'] = '-';
								}else{
									$arr_puk_det['KETENTUAN_KHUSUS'] = $val;
								}
								$arr_puk_det['PARAMETER_UJI'] = $arrsampel['PARAMETER_UJI'][$key];
								$arr_puk_det['PUSTAKA'] = $arrsampel['PUSTAKA'][$key];
								$arr_puk_det['METODE'] = $arrsampel['METODE'][$key];
								$arr_puk_det['SYARAT'] = $arrsampel['SYARAT'][$key];
								$arr_puk_det['JENIS_UJI'] = $arrsampel['JENIS_UJI'][$key];
								$arr_puk_det['GOLONGAN'] = $arrsampel['GOLONGAN'][$key];
								$arr_puk_det['STATUS'] = ($chkdt[$idk[$key]] == '1')?"1":"0";
								$this->db->insert('T_SAMPEL_PUK_DETIL', $arr_puk_det);
								$ik++;
							}
							$arrlogpuk = array('PUK_ID' => $arr_puk['PUK_ID'],
											   'WAKTU' => 'GETDATE()',
											   'USER_ID' => $this->newsession->userdata('SESS_USER_ID'),
											   'KEGIATAN' => 'Mengajukan Review PUK',
											   'CATATAN' => $this->input->post('JUSTIFIKASI'));
							$this->db->insert('T_SAMPEL_PUK_LOG', $arrlogpuk);
							if($kat != "0106"){
								$this->db->simple_query("UPDATE T_SPK SET STATUS = '30209' WHERE SPK_ID ='".$arr_spk['SPK_ID']."'");
								$yes_puk = true;
							}
								
							$hasil = TRUE;
							$msgok = "Pengajuan Review PUK berhasil dikirim";
							
						}else{
						for($s = 0; $s < count($_POST['UJI']['PARAMETER_UJI']); $s++){
							$chk2 = (int)$sipt->main->get_uraian("SELECT AUTO_RESET FROM M_REF_UJI WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND KOMODITI = '".$this->input->post('komoditi')."' AND BIDANG = '".$lab."'","AUTO_RESET");
							if($chk2 == 1)
								$cp = $sipt->main->set_kode_uji($lab,$this->input->post('komoditi'),$arr_spk['TANGGAL']);
							else $cp = $sipt->main->set_kode_uji($lab,$this->input->post('komoditi'),$arr_spk['TANGGAL']);
							$parameter = array('UJI_ID' => $cp,
											   'SPK_ID' => $arr_spk['SPK_ID'],
											   'KODE_SAMPEL' => $this->input->post('kode_sampel'),
											   'JENIS_UJI' => $uji,
											   'AWAL_UJI' => null,
											   'AKHIR_UJI' => null);
							for($j=0;$j<count($arrkeys);$j++){
								$parameter[$arrkeys[$j]] = $arrsampel[$arrkeys[$j]][$s];
								}
								if($parameter['KETENTUAN_KHUSUS'] == 'new'){
									$parameter['KETENTUAN_KHUSUS'] = '-';
							}
							$this->db->insert('T_PARAMETER_HASIL_UJI', $parameter);
							$hasil = TRUE;
						}
					}
					}
					
					if($hasil){
						$cek_uji = $this->db->query("SELECT UJI_KIMIA, UJI_MIKRO FROM T_M_SAMPEL WHERE KODE_SAMPEL = '".$this->input->post('kode_sampel')."'")->result_array();
						if($yes_puk){
							$this->db->simple_query("UPDATE T_SAMPEL_MT SET STATUS = '30201' WHERE SPU_ID = '".$this->input->post('spuid')."' AND KODE_SAMPEL = '".$this->input->post('kode_sampel')."'");
							$this->db->simple_query("UPDATE T_M_SAMPEL SET STATUS_SAMPEL = '30209' WHERE KODE_SAMPEL = '".$this->input->post('kode_sampel')."'");
						}else{
							if($cek_uji[0]['UJI_KIMIA'] == 1 && $cek_uji[0]['UJI_MIKRO'] == 1){
								$jmldiuji = (int)$sipt->main->get_uraian("SELECT COUNT(KODE_SAMPEL) AS JML FROM T_SAMPEL_MT WHERE KODE_SAMPEL = '".$this->input->post('kode_sampel')."'","JML");
								$jmlspk = (int)$sipt->main->get_uraian("SELECT COUNT(KODE_SAMPEL) AS JML FROM T_SPK WHERE KODE_SAMPEL = '".$this->input->post('kode_sampel')."'","JML");
								if($jmlspk >= $jmldiuji){
									$this->db->simple_query("UPDATE T_M_SAMPEL SET STATUS_SAMPEL = '30201' WHERE KODE_SAMPEL = '".$this->input->post('kode_sampel')."'");
								}
								$this->db->simple_query("UPDATE T_SAMPEL_MT SET STATUS = '30201' WHERE SPU_ID = '".$this->input->post('spuid')."' AND KODE_SAMPEL = '".$this->input->post('kode_sampel')."' AND USER_ID = '".$this->newsession->userdata('SESS_USER_ID')."'");
							}else{
								$this->db->simple_query("UPDATE T_SAMPEL_MT SET STATUS = '30201' WHERE SPU_ID = '".$this->input->post('spuid')."' AND KODE_SAMPEL = '".$this->input->post('kode_sampel')."'");
								$this->db->simple_query("UPDATE T_M_SAMPEL SET STATUS_SAMPEL = '30201' WHERE KODE_SAMPEL = '".$this->input->post('kode_sampel')."'");
							}
						}

						$logspk = array('SPK_ID' => $arr_spk['SPK_ID'],
										'WAKTU' => 'GETDATE()',
										'USER_ID' => $this->newsession->userdata('SESS_USER_ID'),
										'KEGIATAN' => 'Simpan Surat Perintah Kerja : '.$arr_spk['SPK_ID'],
										'CATATAN' => '-');
						$this->db->insert('T_SPK_LOG', $logspk);
						return "MSG#YES#$msgok#".site_url()."/home/pengujian/sp/list/send";
					}else{
						$this->db->simple_query("UPDATE T_SAMPEL_MT SET STATUS = '40201' WHERE SPU_ID = '".$this->input->post('spuid')."' AND KODE_SAMPEL = '".$this->input->post('KODE_SAMPEL')."'");
						$this->db->simple_query("UPDATE T_M_SAMPEL SET STATUS_SAMPEL = '40201' WHERE KODE_SAMPEL = '".$this->input->post('kode_sampel')."'");
						$this->db->simple_query("DELETE FROM T_SPK WHERE SPK_ID ='".$arr_spk['SPK_ID']."'");
						#$this->db->simple_query("DELETE FROM T_PARAMETER_HASIL_UJI WHERE SPK_ID ='".$arr_spk['SPK_ID']."'");
						return "MSG#NO#$msgerr";
					}
					if($isajax!="ajax"){
						redirect(base_url());
						exit();
					}
				}#Akhir Save - SPK
				else if($action=="spp-save"){
					$arr_petugas = $_POST['SPP_SAMPEL']['PENGUJI'];
					$hasil = FALSE;
					$msgok = "Tambah data Surat Perintah Pengujian baru berhasil";
					$msgerr = "Tambah Surat Perintah Pengujian baru gagal, Silahkan coba lagi";
					$ko = substr($this->input->post('spuid'),12,2);
					if(!$arr_petugas){
						return "MSG#NO#Petugas Pengujian belum ditunjuk."; die();
					}
					$arr_spp = array('SPK_ID' => $this->input->post('spkid'),
									 'BBPOM_ID' => $this->newsession->userdata('SESS_BBPOM_ID'),
									 'CREATE_BY' => $this->newsession->userdata('SESS_USER_ID'),
									 'CREATE_DATE' => 'GETDATE()',
									 'STATUS' => '20201');
					foreach($this->input->post('SPP') as $a => $b){
						$arr_spp[$a] = $b;
					}
					$lab = $this->input->post('jenis_uji') == "01" ? "K" : "M";
					$chk = (int)$sipt->main->get_uraian("SELECT AUTO_RESET FROM M_REF_SPP WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND KOMODITI = '".$ko."' AND BIDANG = '".$lab."'","AUTO_RESET");
					if($chk == 1)
					$arr_spp['SPP_ID'] = $sipt->main->set_kode_spp($ko,$lab,$arr_spp['TANGGAL']);
					else $arr_spp['SPP_ID'] = $sipt->main->set_kode_spp($ko,$lab,$arr_spp['TANGGAL']);
					$ins = 0;
					if($this->db->insert('T_SPP',$arr_spp)){
						//$sipt->main->set_max('spp',$ko);
						$hasil = TRUE;
						$arr_sampel = $this->input->post('SPP_SAMPEL');
						$arrkeys_sampel = array_keys($arr_sampel);
						for($i = 0; $i < count($_POST['SPP_SAMPEL']['UJI_ID']); $i++){
							for($j=0;$j<count($arrkeys_sampel);$j++){
								$arr_update[$arrkeys_sampel[$j]] = $arr_sampel[$arrkeys_sampel[$j]][$i];
							}
							$arr_update['PENYELIA'] = $this->newsession->userdata('SESS_USER_ID');
							$arr_update['STATUS'] = '20201';
							$arr_update['AWAL_UJI'] = 'GETDATE()';
							$this->db->where('UJI_ID', $_POST['SPP_SAMPEL']['UJI_ID'][$i]);
							$this->db->update('T_PARAMETER_HASIL_UJI', $arr_update);
						}
						$this->db->simple_query("UPDATE T_SPK SET STATUS = '20201' WHERE SPK_ID = '".$this->input->post('spkid')."'");
						$logspk = array('SPK_ID' => $this->input->post('spkid'),
										'WAKTU' => 'GETDATE()',
										'USER_ID' => $this->newsession->userdata('SESS_USER_ID'),
										'KEGIATAN' => 'Proses pembuatan SPP untuk Nomor SPK : '.$this->input->post('spkid'),
										'CATATAN' => 'Kode Sampel : '.$this->input->post('kode_sampel'));
						$this->db->insert('T_SPK_LOG', $logspk);
						$logsp = array('SPP_ID' => $arr_spp['SPP_ID'],
									   'WAKTU' => 'GETDATE()',
									   'USER_ID' => $this->newsession->userdata('SESS_USER_ID'),
									   'KEGIATAN' => 'Simpan Surat Perintah Pengujian : '.$arr_spp['SPP_ID'],
									   'CATATAN' => '-');
						$this->db->insert('T_SP_LOG', $logsp);
					}
					if($hasil){
						$cek_uji = $this->db->query("SELECT UJI_KIMIA, UJI_MIKRO FROM T_M_SAMPEL WHERE KODE_SAMPEL = '".$this->input->post('kode_sampel')."'")->result_array();
						if($cek_uji[0]['UJI_KIMIA'] == 1 && $cek_uji[0]['UJI_MIKRO'] == 1){
							$jmldiuji = (int)$sipt->main->get_uraian("SELECT COUNT(KODE_SAMPEL) AS JML FROM T_SAMPEL_MT WHERE KODE_SAMPEL = '".$this->input->post('kode_sampel')."'","JML");
							$jmlspk = (int)$sipt->main->get_uraian("SELECT COUNT(KODE_SAMPEL) AS JML FROM T_SPK WHERE KODE_SAMPEL = '".$this->input->post('kode_sampel')."'","JML");
							if($jmlspk >= $jmldiuji){
								$this->db->simple_query("UPDATE T_M_SAMPEL SET STATUS_SAMPEL = '20201' WHERE KODE_SAMPEL = '".$this->input->post('kode_sampel')."'");
							}
						}else{
							$this->db->simple_query("UPDATE T_M_SAMPEL SET STATUS_SAMPEL = '20201' WHERE KODE_SAMPEL = '".$this->input->post('kode_sampel')."'");
						}
						return "MSG#YES#$msgok#".site_url()."/home/pengujian/spp/list/all";
					}else{
						return "MSG#NO#$msgerr";
					}
					if($isajax!="ajax"){
						redirect(base_url());
						exit();
					}
				}#Akhir - SPP
				else if($action == "spk-tolak"){
					$hasil = FALSE;
					$msgok = "Permohonan permintaan review SPK (Penentuan Parameter Uji) berhasil";
					$msgerr = "Permohonan permintaan review SPK (Penentuan Parameter Uji) gagal, Silahkan coba lagi";
					$arrchk = $this->input->post('chk_uji');
					if(!$arrchk){
						return "MSG#NO#Mohon maaf, tidak ada Parameter Uji yang akan di review.\n Silahkan pilih kembali parameter uji yang akan di review"; die();
					}
					$chk = $this->db->query("SELECT A.SPU_ID, B.CREATE_BY FROM T_SAMPEL_MT A LEFT JOIN T_SPK B ON A.KODE_SAMPEL = B.KODE_SAMPEL WHERE A.KODE_SAMPEL = '".$this->input->post('kode_sampel')."' AND KASIE = '".$this->newsession->userdata('SESS_USER_ID')."'")->result_array();
					$sql = "UPDATE T_SAMPEL_MT SET STATUS = '40205' WHERE SPU_ID = '".$chk[0]['SPU_ID']."' AND KODE_SAMPEL = '".$this->input->post('kode_sampel')."' AND USER_ID = '".$chk[0]['CREATE_BY']."'";
					$res = $this->db->simple_query($sql);
					if($res){
						$hasil = TRUE;
						$this->db->simple_query("UPDATE T_SPK SET STATUS = '40205' WHERE SPK_ID = '".$this->input->post('spkid')."'");
						if($this->input->post('chk_uji')){
							foreach($this->input->post('chk_uji') as $x){
								$arrpu = array('STATUS' => '40205');
								$this->db->where('UJI_ID', $x);
								$this->db->update('T_PARAMETER_HASIL_UJI', $arrpu);
							}
						}
						$logspk = array('SPK_ID' => $this->input->post('spkid'),
										'WAKTU' => 'GETDATE()',
										'USER_ID' => $this->newsession->userdata('SESS_USER_ID'),
										'KEGIATAN' => 'Permohonan Review Ulang penentuan parameter uji untuk kode sampel: '.$this->input->post('spkid'),
										'CATATAN' => $this->input->post('CATATAN'));
						$this->db->insert('T_SPK_LOG', $logspk);
					}
					
					if($hasil){
						return "MSG#YES#$msgok#".site_url()."/home/pengujian/spp/list/verifikasi";
					}else{
						return "MSG#NO#$msgerr";
					}
					if($isajax!="ajax"){
						redirect(base_url());
						exit();
					}				
				}#Akhir Penolakan SPK
				#Review SPK
				else if($action == "review"){
					$hasil = FALSE;
					$msgok = "Review SPK berhasil dikirim ulang";
					$msgerr = "Review SPK gagal dikirim ulang, Silahkan coba lagi";
					$sql = "UPDATE T_SAMPEL_MT SET STATUS = '30201' WHERE SPU_ID = '".$this->input->post('SPU_ID')."' AND KODE_SAMPEL = '".$this->input->post('KODE_SAMPEL')."' AND USER_ID = '".$this->newsession->userdata('SESS_USER_ID')."'";
					$res = $this->db->simple_query($sql);
					if($res){
						$hasil = TRUE;
						
						$arrpu = $this->input->post('PU');
						$arrkeys_pu = array_keys($arrpu);
						for($i = 0; $i < count($_POST['PU']['UJI_ID']); $i++){
							for($j=0;$j<count($arrkeys_pu);$j++){
								$arrupdate[$arrkeys_pu[$j]] = $arrpu[$arrkeys_pu[$j]][$i];
							}
							$arrupdate['STATUS'] = '30201';
							$this->db->where('UJI_ID', $_POST['PU']['UJI_ID'][$i]);
							$this->db->update('T_PARAMETER_HASIL_UJI', $arrupdate);
						}
						
						$this->db->simple_query("UPDATE T_SPK SET STATUS = '30201' WHERE SPK_ID = '".$this->input->post('SPK_ID')."'");
						$logspk = array('SPK_ID' => $this->input->post('SPK_ID'),
											'WAKTU' => 'GETDATE()',
											 'USER_ID' => $this->newsession->userdata('SESS_USER_ID'),
											 'KEGIATAN' => 'Revisi Parameter Uji',
											 'CATATAN' => $this->input->post('CATATAN'));
						$this->db->insert('T_SPK_LOG', $logspk);
					}
					
					if($hasil){
						return "MSG#YES#$msgok#".site_url()."/home/pengujian/sp/list/send";
					}else{
						return "MSG#NO#$msgerr";
					}
					if($isajax!="ajax"){
						redirect(base_url());
						exit();
					}
				}#End Review SPK
				else if($action == "add-params"){
					$hasil = FALSE;
					$msgok = "Penambahan parameter uji berhasil disimpan";
					$msgerr = "Penambahan parameter uji gagal disimpan, silahkan coba lagi.";
					$arrsampel = $this->input->post('UJI');
					$arrkeys = array_keys($arrsampel);
					if(in_array('B1',$this->newsession->userdata('SESS_SUB_SARANA')) || in_array('B2',$this->newsession->userdata('SESS_SUB_SARANA'))){
						$lab = "K";
					}else if(in_array('B3',$this->newsession->userdata('SESS_SUB_SARANA'))){
						$lab = "M";
					}
					
					for($s = 0; $s < count($_POST['UJI']['PARAMETER_UJI']); $s++){
						$chk2 = (int)$sipt->main->get_uraian("SELECT AUTO_RESET FROM M_REF_UJI WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND KOMODITI = '".substr($this->input->post('SPU_ID'), 12, 2)."' AND BIDANG = '".$lab."'","AUTO_RESET");
						if($chk2 == 1)
						$cp = $sipt->main->set_kode_uji($lab,substr($this->input->post('SPU_ID'), 12, 2),$this->input->post('TANGGAL_SPK'));
						else $cp= $sipt->main->set_kode_uji($lab,substr($this->input->post('SPU_ID'), 12, 2),$this->input->post('TANGGAL_SPK'));
						$parameter = array('UJI_ID' => $cp,
									   'SPK_ID' => $this->input->post('SPK_ID'),
									   'KODE_SAMPEL' => $this->input->post('KODE_SAMPEL'),
									   'AWAL_UJI' => 'GETDATE()',
									   'STATUS' => '20201',
									   'AKHIR_UJI' => null);
						for($j=0;$j<count($arrkeys);$j++){
							$parameter[$arrkeys[$j]] = $arrsampel[$arrkeys[$j]][$s];
		
						}
						/*if(array_key_exists('PENGUJI', $parameter)){
							if(trim($parameter['PENGUJI']) != "")
								$parameter['STATUS'] = '20201';
							else
								$parameter['STATUS'] = '';
						}*/
						
						if($this->db->insert('T_PARAMETER_HASIL_UJI', $parameter)){
							//$sipt->main->set_max('uji',substr($this->input->post('SPU_ID'), 12, 2));
							$hasil = TRUE;
						}
					}
					if($hasil){
						return "MSG#YES#$msgok#".site_url()."/home/pengujian/spk/view/".$this->input->post('KODE_SAMPEL');
					}else{
						return "MSG#NO#$msgerr";
					}
					if($isajax!="ajax"){
						redirect(base_url());
						exit();
					}
				}
				else if($action == "edit-penyelia"){
					$no_spk = $sipt->main->get_uraian("SELECT dbo.FORMAT_NOMOR('SPK','".$this->input->post('SPK_ID')."') AS SPK","SPK");
					$asal = $sipt->main->get_uraian("SELECT NAMA_USER FROM T_USER WHERE USER_ID = '".$this->input->post('USER')."'","NAMA_USER");
					$ke = $sipt->main->get_uraian("SELECT NAMA_USER FROM T_USER WHERE USER_ID = '".$this->input->post('PENYELIA')."'","NAMA_USER");
					$hasil = FALSE;
					$msgok = "Edit data penyelia untuk nomor ".$no_spk." berhasil";
					$msgerr = "Edit data penyelia nomor ".$no_spk." gagal";
					$arrspk = array('KASIE' => $this->input->post('PENYELIA'));
					$this->db->where(array('KODE_SAMPEL' => $this->input->post('KODE_SAMPEL'), 'SPK_ID' => $this->input->post('SPK_ID'), 'SPU_ID' => $this->input->post('SPU_ID'), 'CREATE_BY' => $this->newsession->userdata('SESS_USER_ID')));
					$respk = $this->db->update('T_SPK', $arrspk);
					if($respk){
						$resparam = $this->db->simple_query("UPDATE T_PARAMETER_HASIL_UJI SET PENYELIA = '".$this->input->post('PENYELIA')."' WHERE SPK_ID = '".$this->input->post('SPK_ID')."' AND KODE_SAMPEL = '".$this->input->post('KODE_SAMPEL')."'");
						$rescp = $this->db->simple_query("UPDATE T_CP SET CREATE_BY = '".$this->input->post('PENYELIA')."' WHERE CREATE_BY = '".$this->input->post('USER')."' AND KODE_SAMPEL = '".$this->input->post('KODE_SAMPEL')."'");
						$logspk = array('SPK_ID' => $this->input->post('SPK_ID'),
										'WAKTU' => 'GETDATE()',
										'USER_ID' => $this->newsession->userdata('SESS_USER_ID'),
										'KEGIATAN' => 'Edit Data Penyelia dari '.$asal.' ke '.$ke,
										'CATATAN' => '');
						$this->db->insert('T_SPK_LOG', $logspk);
						$hasil = TRUE;
					}
					if($hasil) return "MSG#YES#$msgok#SUKSES";
					else return "MSG#NO#$msgerr";
				}
				
				else if($action=="surveilance")
				{
					$hasil = FALSE;
					$msgok = "Data sampel berhasil diproses";
					$msgerr = "Data sampel gagal diproses";
					$arr_update_sampel = array('STATUS_SAMPEL' => '50200',
											   'CUKUP' => $this->input->post('CUKUP'),
											   'OPSI_D2' => $this->input->post('OPSI_D2'));
					$this->db->where('KODE_SAMPEL', $this->input->post('kode_sampel'));
					$this->db->where('SPU_ID', $this->input->post('spuid'));
					$this->db->update('T_M_SAMPEL', $arr_update_sampel);
					if($this->db->affected_rows() > 0)
					{
						$arr_update_sampel_mt = array('STATUS' => '50200');
						$this->db->where('KODE_SAMPEL', $this->input->post('kode_sampel'));
						$this->db->where('SPU_ID', $this->input->post('spuid'));
						$this->db->where('USER_ID', $this->newsession->userdata('SESS_USER_ID'));
						$this->db->update('T_SAMPEL_MT', $arr_update_sampel_mt);
						if($this->db->affected_rows() > 0)
						{
							$hasil = TRUE;
							$arr_sampling_log = array('KODE_SAMPEL' => $this->input->post('kode_sampel'),
													  'WAKTU' => 'GETDATE()',
													  'USER_ID' => $this->newsession->userdata('SESS_USER_ID'),
													  'KEGIATAN' => 'Mengirim data sampel ke Kepala Balai (Alur Surveilance Obat Kategori D2)',
													  'CATATAN' => $this->input->post('JUSTIFIKASI'));
							$this->db->insert('T_SAMPLING_LOG', $arr_sampling_log);
						}
						else
						{
							$arr_update_sampel = array('STATUS_SAMPEL' => '40201');
							$this->db->where('KODE_SAMPEL', $this->input->post('kode_sampel'));
							$this->db->where('SPU_ID', $this->input->post('spuid'));
							$this->db->update('T_M_SAMPEL', $arr_update_sampel);
						}
					}
					if($hasil) return "MSG#YES#$msgok#".site_url()."/home/pengujian/sp/list/verifikasi";
					else return "MSG#NO#$msgerr";
				}
				
				else if($action == "verifikasi-rujukan"){					
					if($this->input->post('verifikasi') == "1"){#Jika sampel dilanjutkan ke bidang pengujian
						$hasil = FALSE;
						$msgok = "Tambah data SPK baru berhasil";
						$msgerr = "Tambah SPK baru gagal, Silahkan coba lagi";
						$arr_petugas = $this->input->post('USER_ID');
						$ins = 0;
						$jmlspk = 0;
						$arr_spk['SPU_ID'] = $this->input->post('spuid');
						$arr_spk['BBPOM_ID'] = $this->newsession->userdata('SESS_BBPOM_ID');
						$arr_spk['KODE_SAMPEL'] = $this->input->post('kode_sampel');
						$arr_spk['KOMODITI'] = $this->input->post('komoditi');
						$arr_spk['TANGGAL'] = $this->input->post('TANGGAL');
						$arr_spk['KASIE'] = $this->input->post('KASIE');
						$arr_spk['CREATE_BY'] = $this->newsession->userdata('SESS_USER_ID');
						$arr_spk['CREATE_DATE'] = 'GETDATE()';
						$arr_spk['STATUS'] = '30201';
						if($this->input->post('jenis_uji') == "01"){
							$lab = "M";
						}else{
							$lab = "K";
						}
						$cekspk = $this->db->query("SELECT UJI_KIMIA, UJI_MIKRO FROM T_M_SAMPEL WHERE KODE_SAMPEL = '".$this->input->post('kode_sampel')."'")->row();
						
						if($cekspk->UJI_KIMIA == 1 && $cekspk->UJI_MIKRO == 1){
							$jmlspk = $sipt->main->get_uraian("SELECT COUNT(KODE_SAMPEL) AS JML FROM T_SPK WHERE KODE_SAMPEL = '".$this->input->post('kode_sampel')."' AND CREATE_BY = '".$this->newsession->userdata('SESS_USER_ID')."'","JML");
							if($jmlspk == 2){
								return "MSG#YES#Data SPK Kimia dan SPK Mikro sudah terdapat di dalam database. \n Silahkan mereload atau merefresh halaman input data SPK"; die();
							}
						}
						$chk = (int)$sipt->main->get_uraian("SELECT AUTO_RESET FROM M_REF_SPK WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND KOMODITI = '".$this->input->post('komoditi')."' AND BIDANG = '".$lab."'","AUTO_RESET");
						if($chk == 1)
						$arr_spk['SPK_ID'] = $sipt->main->set_kode_spk($this->input->post('komoditi'),$lab);
						else $arr_spk['SPK_ID'] = $sipt->main->set_kode_spk($this->input->post('komoditi'),$lab, $arr_spk['TANGGAL']); 
						
						$this->db->insert('T_SPK', $arr_spk);
						if($this->db->affected_rows() > 0){
							$jml = 0;
							foreach($_POST['UJI_ID'] as $val){
							  $query = "SELECT GOLONGAN, PARAMETER_UJI, SIMULAN, KATEGORI_PU, METODE, PUSTAKA, SYARAT, RUANG_LINGKUP, PEMERIAN, IDENTIFIKASI, JENIS_UJI, SYARAT_UJI FROM T_PARAMETER_HASIL_UJI WHERE UJI_ID = '".$val."'"; 
							  $data = $sipt->main->get_result($query);
							  if($data){
								  $arrcopy = array();
								  foreach($query->result_array() as $row){
									  $arrcopy = $row;
								  }
								  $chk2 = (int)$sipt->main->get_uraian("SELECT AUTO_RESET FROM M_REF_UJI WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND KOMODITI = '".$this->input->post('komoditi')."' AND BIDANG = '".$lab."'","AUTO_RESET");
								  if($chk2 == 1)
									  $cp = $sipt->main->set_kode_uji($lab,$this->input->post('komoditi'));
								  else $cp = $sipt->main->set_kode_uji($lab,$this->input->post('komoditi'),$arr_spk['TANGGAL']);
								  $arrcopy['UJI_ID'] = $cp;
								  $arrcopy['SPK_ID'] = $arr_spk['SPK_ID'];
								  $arrcopy['KODE_SAMPEL'] = $this->input->post('kode_sampel');
								  $arrcopy['AWAL_UJI'] = null;
								  $arrcopy['AKHIR_UJI'] = null;
								  $arrcopy['UJI_MAMPU'] = '1';
								  $this->db->insert('T_PARAMETER_HASIL_UJI', $arrcopy);
								  if($this->db->affected_rows() > 0){
									  $jml++;
								  }
							   }
							}
							if($jml > 0){
								$hasil = TRUE;
							}
							
							if($hasil){
								$cek_uji = $this->db->query("SELECT UJI_KIMIA, UJI_MIKRO FROM T_M_SAMPEL WHERE KODE_SAMPEL = '".$this->input->post('kode_sampel')."'")->result_array();
								if($cek_uji[0]['UJI_KIMIA'] == 1 && $cek_uji[0]['UJI_MIKRO'] == 1){
									$jmldiuji = (int)$sipt->main->get_uraian("SELECT COUNT(KODE_SAMPEL) AS JML FROM T_SAMPEL_MT WHERE KODE_SAMPEL = '".$this->input->post('kode_sampel')."'","JML");
									$jmlspk = (int)$sipt->main->get_uraian("SELECT COUNT(KODE_SAMPEL) AS JML FROM T_SPK WHERE KODE_SAMPEL = '".$this->input->post('kode_sampel')."'","JML");
									if($jmlspk >= $jmldiuji){
										$this->db->simple_query("UPDATE T_M_SAMPEL SET STATUS_SAMPEL = '30201' WHERE KODE_SAMPEL = '".$this->input->post('kode_sampel')."'");
									}
									$this->db->simple_query("UPDATE T_SAMPEL_MT SET STATUS = '30201' WHERE SPU_ID = '".$this->input->post('spuid')."' AND KODE_SAMPEL = '".$this->input->post('kode_sampel')."' AND USER_ID = '".$this->newsession->userdata('SESS_USER_ID')."'");
								}else{
									$this->db->simple_query("UPDATE T_SAMPEL_MT SET STATUS = '30201' WHERE SPU_ID = '".$this->input->post('spuid')."' AND KODE_SAMPEL = '".$this->input->post('kode_sampel')."'");
									$this->db->simple_query("UPDATE T_M_SAMPEL SET STATUS_SAMPEL = '30201' WHERE KODE_SAMPEL = '".$this->input->post('kode_sampel')."'");
								}
								$logspk = array('SPK_ID' => $arr_spk['SPK_ID'],
												'WAKTU' => 'GETDATE()',
												'USER_ID' => $this->newsession->userdata('SESS_USER_ID'),
												'KEGIATAN' => 'Simpan Surat Perintah Kerja : '.$arr_spk['SPK_ID'],
												'CATATAN' => '-');
								$this->db->insert('T_SPK_LOG', $logspk);
								return "MSG#YES#$msgok#".site_url()."/home/pengujian/sp/list/send";
							}else{
								$this->db->simple_query("UPDATE T_SAMPEL_MT SET STATUS = '40201' WHERE SPU_ID = '".$this->input->post('spuid')."' AND KODE_SAMPEL = '".$this->input->post('KODE_SAMPEL')."'");
								$this->db->simple_query("UPDATE T_M_SAMPEL SET STATUS_SAMPEL = '40201' WHERE KODE_SAMPEL = '".$this->input->post('kode_sampel')."'");
								$this->db->simple_query("DELETE FROM T_SPK WHERE SPK_ID ='".$arr_spk['SPK_ID']."'");
								return "MSG#NO#$msgerr";
							}
							
						}
					}
					
					else{#Jika Sampel tidak dilanjutkan ke pengujian 
						$hasil = FALSE;
						$msgok = "Verifikasi sampel rujukan berhasil di proses";
						$msgerr = "Verifikasi sampel rujukan gagal di proses";	
						
						
						$get_obj_surat = $this->db->query("SELECT A.KODE_SAMPEL, B.KODE_SAMPEL AS KODE_SAMPEL_LAMA, A.NAMA_SAMPEL, A.NOMOR_REGISTRASI, A.PABRIK, A.NOMOR_REGISTRASI, A.KEMASAN, A.NO_BETS, B.BBPOM_ID_TUJUAN AS BBPOM_ID_PENGIRIM, B.BBPOM_NAMA_TUJUAN AS BBPOM_NAMA_PENGIRIM, B.BBPOM_ID_PENGIRIM AS BBPOM_ID_TUJUAN, B.BBPOM_NAMA_PENGIRIM AS BBPOM_NAMA_TUJUAN,
							B.NOMOR_SURAT AS NOMOR_SURAT_PENGANTAR, CONVERT(VARCHAR(10), B.TANGGAL_SURAT, 103) AS TANGGAL_SURAT_PENGANTAR
							FROM T_M_SAMPEL A LEFT JOIN T_SURAT_PENGANTAR_RUJUKAN B ON A.KODE_RUJUKAN = B.KODE_SAMPEL
							WHERE A.KODE_SAMPEL = '".$this->input->post('kode_sampel')."'")->result_array();

						$get_obj_kbalai = $this->db->query("SELECT NAMA_USER, USER_ID FROM T_USER WHERE
USER_ID IN (SELECT USER_ID FROM T_USER_ROLE WHERE ROLE IN ('5')) AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND STATUS = 'Aktif'")->result_array();

					
						$arr_surat = array( 'KODE_SAMPEL' => $get_obj_surat[0]['KODE_SAMPEL'],
											'KODE_SAMPEL_LAMA' => $get_obj_surat[0]['KODE_SAMPEL_LAMA'],
											'KOTA' => $sipt->main->get_uraian("SELECT KOTA FROM M_BBPOM WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","KOTA"),
											'TANGGAL_SURAT' => 'GETDATE()',
											'NOMOR_SURAT' => '-',
											'NOMOR_SURAT_PENGANTAR' => $get_obj_surat[0]['NOMOR_SURAT_PENGANTAR'],
											'TANGGAL_SURAT_PENGANTAR' => $get_obj_surat[0]['TANGGAL_SURAT_PENGANTAR'],
											'BBPOM_ID_TUJUAN' => $get_obj_surat[0]['BBPOM_ID_PENGIRIM'],
											'BBPOM_NAMA_TUJUAN' => $get_obj_surat[0]['BBPOM_NAMA_PENGIRIM'],
											'BBPOM_ID_PENGIRIM' => $get_obj_surat[0]['BBPOM_ID_TUJUAN'],
											'BBPOM_NAMA_PENGIRIM' => $get_obj_surat[0]['BBPOM_NAMA_TUJUAN'],
											'NAMA_SAMPEL' => $get_obj_surat[0]['NAMA_SAMPEL'],
											'NOMOR_REGISTRASI' => $get_obj_surat[0]['NOMOR_REGISTRASI'],
											'PABRIK' => $get_obj_surat[0]['PABRIK'],
											'KEMASAN' => $get_obj_surat[0]['KEMASAN'],
											'NO_BETS' => $get_obj_surat[0]['NO_BETS'],
											'TANGGAPAN' => $this->input->post('CATATAN_VERIFIKASI'),
											'NAMA_KEPALA_BALAI' => $get_obj_kbalai[0]['NAMA_USER'],
											'NIP_KEPALA_BALAI' => $get_obj_kbalai[0]['USER_ID'],
											'CREATE_BY' => $this->newsession->userdata('SESS_USER_ID'),
											'CREATE_DATE' => 'GETDATE()' ); 
						$this->db->insert('T_SURAT_TANGGAPAN_RUJUKAN', $arr_surat);
						if($this->db->affected_rows() > 0)
						{
							$status_rujukan = array('STATUS_RUJUKAN' => '2','STATUS' => '50205', 'CATATAN' => $this->input->post('CATATAN_VERIFIKASI'));
							$this->db->where('KODE_SAMPEL', $this->input->post('KODE_RUJUKAN'));
							$this->db->where('BBPOM_RUJUK', $this->newsession->userdata('SESS_BBPOM_ID'));
							$this->db->update('T_SAMPEL_RUJUKAN', $status_rujukan);
							if($this->db->affected_rows() > 0){
								$chkstatusrujukan = $sipt->main->get_uraian("SELECT COUNT(*) AS JML FROM (SELECT DISTINCT(STATUS_RUJUKAN) AS JML FROM T_SAMPEL_RUJUKAN WHERE KODE_SAMPEL = '".$this->input->post('KODE_RUJUKAN')."') AS DATA","JML");
								if((int)$chkstatusrujukan == 1){
									$arrstatus = array('STATUS_SAMPEL' => '50205');
									$this->db->where('KODE_SAMPEL', $this->input->post('KODE_RUJUKAN'));
									$this->db->update('T_M_SAMPEL', $arrstatus);
								}
								$this->db->simple_query("SET DATEFORMAT DMY  UPDATE T_M_SAMPEL SET STATUS_SAMPEL = '50205', UPDATE_BY = '".$this->newsession->userdata('SESS_USER_ID')."', UPDATE_DATE = GETDATE() WHERE KODE_SAMPEL = '".$this->input->post('KODE_SAMPEL')."'");
								$this->db->simple_query("UPDATE T_SAMPEL_MT SET STATUS = '50205' WHERE SPU_ID = '".$this->input->post('spuid')."' AND KODE_SAMPEL = '".$this->input->post('kode_sampel')."'");
								
								$this->db->simple_query("UPDATE T_PARAMETER_HASIL_UJI SET STATUS = '50205' WHERE KODE_SAMPEL = '".$this->input->post('KODE_SAMPEL')."'");
								$hasil = TRUE;	
							}
						}
						if($hasil){
							return "MSG#YES#$msgok#".site_url()."/home/pengujian/sp/list/rujukan";
						}else{
							return "MSG#NO#$msgerr";
						}
						
					}
								
					if($isajax!="ajax"){
						redirect(base_url());
						exit();
					}
					
					
				}
			}
			
		}
	}
	
	function set_spk_admin($action, $isajax){
		if((in_array('1', $this->newsession->userdata('SESS_KODE_ROLE'))  || in_array('9', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('4', $this->newsession->userdata('SESS_KODE_ROLE'))) && $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			if($action == "delete"){
				$hasil = FALSE;
				$msgok = "Data SPK berhasil di hapus. \n";
				$msgerr = "Data SPK gagal di hapus";
				$err = 0;
				$ret = 0;
				foreach($this->input->post('tb_chk') as $a){
					$arr = explode(".",$a);
					$query = "SELECT SPK_ID, KODE_SAMPEL, SPU_ID, BBPOM_ID, KOMODITI, TANGGAL, KASIE, STATUS, CREATE_BY, CREATE_DATE FROM T_SPK WHERE SPK_ID = '".$arr[0]."'";
					$data = $sipt->main->get_result($query);
					if($data){
						foreach($query->result_array() as $row){
							$arrdel['SPK_ID'] = $row['SPK_ID'];
							$arrdel['KODE_SAMPEL'] = $row['KODE_SAMPEL'];
							$arrdel['SPU_ID'] = $row['SPU_ID'];
							$arrdel['BBPOM_ID'] = $row['BBPOM_ID'];
							$arrdel['KOMODITI'] = $row['KOMODITI'];
							$arrdel['TANGGAL'] = $row['TANGGAL'];
							$arrdel['KASIE'] = $row['KASIE'];
							$arrdel['STATUS'] = $row['STATUS'];
							$arrdel['CREATE_BY'] = $row['CREATE_BY'];
							$arrdel['CREATE_DATE'] = $row['CREATE_DATE'];
							$this->db->insert('T_SPK_DELETE', $arrdel);
						}
						$this->db->where('SPK_ID',$arr[0]);
						$this->db->delete('T_SPK');
						if($this->db->affected_rows() > 0){
							$hasil = TRUE;
						}
					}
				}
				if($hasil){
					return "MSG#$msgok#";
				}else{
					return "MSG#$msgerr";
				}
			}
		}
	}
	
	function get_revdispospk($spkid){
		if((in_array('1', $this->newsession->userdata('SESS_KODE_ROLE'))  || in_array('9', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('4', $this->newsession->userdata('SESS_KODE_ROLE'))) && $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$query = "SELECT A.SPK_ID, A.KODE_SAMPEL, A.SPU_ID, A.BBPOM_ID, dbo.FORMAT_NOMOR('SPU', A.SPU_ID) AS UR_SPU, dbo.FORMAT_NOMOR('SPK', A.SPK_ID) AS UR_SPK, dbo.FORMAT_NOMOR('SPL', A.KODE_SAMPEL) AS  UR_KODE_SAMPEL, dbo.GOLONGAN_SAMPEL(A.KOMODITI) AS UR_KOMODITI, CASE WHEN SUBSTRING(A.SPK_ID,13,1) = 'K' THEN 'SPK - Kimia' WHEN SUBSTRING(A.SPK_ID,13,1) = 'M' THEN 'SPK - Mikro' END AS JENIS_SPK, CONVERT(VARCHAR(10), A.TANGGAL, 103) AS TANGGAL_SPK, A.CREATE_BY, A.KASIE, B.NAMA_USER AS MT, B.JABATAN AS JABATAN_MT, C.NAMA_USER AS PENYELIA, C.JABATAN AS JABATAN_PENYELIA, D.NAMA_BBPOM FROM T_SPK A LEFT JOIN T_USER B ON A.CREATE_BY = B.USER_ID LEFT JOIN T_USER C ON A.KASIE = C.USER_ID LEFT JOIN M_BBPOM D ON A.BBPOM_ID = D.BBPOM_ID WHERE A.SPK_ID = '".$spkid."'";
			$data = $sipt->main->get_result($query);
			if($data){
				foreach($query->result_array() as $row){
					$arrdata['sess'] = $row;
				}
				$arrdata['act'] = site_url().'/post/spk/spk_act/redispospk';
				$arrdata['mt'] = $sipt->main->combobox("SELECT A.USER_ID, A.NAMA_USER +' - '+ A.JABATAN AS NAMA_USER FROM T_USER A LEFT JOIN T_USER_ROLE B ON A.USER_ID = B.USER_ID WHERE B.ROLE = '4' AND B.JENIS_PELAPORAN = '02' AND A.BBPOM_ID = '".$row['BBPOM_ID']."' AND A.STATUS = 'Aktif' GROUP BY A.USER_ID, A.NAMA_USER, A.JABATAN ORDER BY 2 ASC", "USER_ID", "NAMA_USER");
				$arrdata['penyelia']= $sipt->main->combobox("SELECT A.USER_ID, A.NAMA_USER +' - '+ A.JABATAN AS NAMA_USER FROM T_USER A LEFT JOIN T_USER_ROLE B ON A.USER_ID = B.USER_ID WHERE B.ROLE = '3' AND B.JENIS_PELAPORAN = '02' AND A.BBPOM_ID = '".$row['BBPOM_ID']."' AND A.STATUS = 'Aktif' GROUP BY A.USER_ID, A.NAMA_USER, A.JABATAN ORDER BY 2 ASC", "USER_ID", "NAMA_USER");
			}
			return $arrdata;
		}
	}
	
	
	function get_rujukan($id){
		if((in_array('3', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('4', $this->newsession->userdata('SESS_KODE_ROLE'))) && in_array('02', $this->newsession->userdata('SESS_JENIS_PELAPORAN')) && $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model('main','main',TRUE);
			$arrdata = array();
			if(in_array('B1',$this->newsession->userdata('SESS_SUB_SARANA')) || in_array('B2',$this->newsession->userdata('SESS_SUB_SARANA'))){
				$arrdata['jenis_uji'] = "02";
			}else if(in_array('B3',$this->newsession->userdata('SESS_SUB_SARANA'))){
				$arrdata['jenis_uji'] = "01";
			}
			$arrdata['sampel'] = $this->db->query("SELECT A.PERIKSA_SAMPEL, A.KODE_SAMPEL, A.SPU_ID, dbo.FORMAT_NOMOR('SPL', A.KODE_SAMPEL) AS UR_KODESAMPEL, A.KOMODITI, dbo.KATEGORI(A.KOMODITI,A.PRIORITAS) AS UR_KOMODITI, dbo.KATEGORI(A.KATEGORI,A.PRIORITAS) AS UR_KATEGORI, A.KATEGORI, dbo.URAIAN_M_TABEL('SUB_TUJUAN', A.SUB_TUJUAN) AS SUB_TUJUAN, dbo.URAIAN_M_TABEL('ASAL_SAMPLING',A.ASAL_SAMPEL) AS ASAL_SAMPEL, dbo.URAIAN_M_TABEL('TUJUAN_SAMPLING',A.TUJUAN_SAMPLING) AS TUJUAN_SAMPLING, A.KLASIFIKASI_TAMBAHAN,A.NAMA_SAMPEL,A.NOMOR_REGISTRASI,A.PABRIK,IMPORTIR,A.BENTUK_SEDIAAN,A.KEMASAN,A.NO_BETS,A.KETERANGAN_ED,A.JUMLAH_SAMPEL,A.SATUAN,A.HARGA_SAMPEL,A.UJI_KIMIA,A.JUMLAH_KIMIA,A.UJI_MIKRO,A.JUMLAH_MIKRO,A.SISA,REPLACE(A.KOMPOSISI,';','<br>') AS KOMPOSISI,A.NETTO,A.KONDISI_SAMPEL,A.EVALUASI_PENANDAAN,A.CARA_PENYIMPANAN, A.LABEL, A.SEGEL,A.CATATAN,A.STATUS_KIMIA,A.STATUS_MIKRO,A.STATUS_SAMPEL,A.LAMPIRAN, A.PRIORITAS, B.BBPOM_ID, dbo.FORMAT_NOMOR('SP', C.NOMOR_SP) AS UR_SPP, CONVERT(VARCHAR(10), C.TANGGAL, 103) AS TGL_SPP, A.PRIORITAS, A.KODE_RUJUKAN FROM T_M_SAMPEL A LEFT JOIN T_PERIKSA_SAMPEL B ON A.PERIKSA_SAMPEL = B.PERIKSA_SAMPEL LEFT JOIN T_SPU C ON A.SPU_ID = C.SPU_ID WHERE A.KODE_SAMPEL = '".$id."'")->result_array(); 
			$arrdata['act'] = site_url().'/post/spk/spk_act/verifikasi-rujukan';
			$jml = $sipt->main->get_uraian("SELECT COUNT(*) AS JML FROM T_SPK WHERE SPK_ID IN (SELECT SPK_ID FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL = '".$id."') AND CREATE_BY = '".$this->newsession->userdata('SESS_USER_ID')."'","JML");
			if($jml > 0){
				$arrdata['notallowed'] = TRUE;
				$query = "SELECT dbo.FORMAT_NOMOR('SPK', A.SPK_ID) UR_SPK, CONVERT(VARCHAR(10), A.TANGGAL, 103) AS TANGGAL,B.NAMA_USER, C.PARAMETER_UJI, C.METODE, C.PUSTAKA, C.SYARAT, C.RUANG_LINGKUP, CASE WHEN C.UJI_MAMPU = '0' THEN 'Tidak' ELSE 'YA' END AS UJI_MAMPU FROM T_SPK A LEFT JOIN T_USER B ON A.KASIE = B.USER_ID LEFT JOIN T_PARAMETER_HASIL_UJI C ON A.SPK_ID = C.SPK_ID WHERE C.KODE_SAMPEL = '".$id."' AND A.CREATE_BY = '".$this->newsession->userdata('SESS_USER_ID')."'";
				$data = $sipt->main->get_result($query);
				if($data){
					foreach($query->result_array() as $row){
						$parameter[] = $row;
						$arrdata['sess'] = $row;
						$arrdata['parameter'] = $parameter;
					}
				}
			}else{
				$kode_rujukan = $sipt->main->get_uraian("SELECT KODE_RUJUKAN FROM T_M_SAMPEL WHERE KODE_SAMPEL = '".$id."'","KODE_RUJUKAN");
				$substr = $sipt->main->get_uraian("SELECT CASE WHEN LEN(LTRIM(RTRIM(KODE_BALAI))) = 2 THEN '0' + KODE_BALAI ELSE KODE_BALAI END AS KODE_BALAI FROM M_BBPOM WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","KODE_BALAI");
				$arrdata['paramrujuk'] = $this->db->query("SELECT A.UJI_ID, A.JENIS_UJI, CASE WHEN A.JENIS_UJI = '01' THEN 'Mikrobiologi' WHEN A.JENIS_UJI = '02' THEN 'Kimia-Fisika' END AS BIDANG_UJI, A.PARAMETER_UJI, A.METODE, A.PUSTAKA, A.SYARAT, B.URAIAN AS LINGKUP_UJI, REPLACE(REPLACE(C.NAMA_BBPOM, 'BALAI POM DI ', ''), 'BALAI BESAR POM DI ','') AS [BALAI_TUJUAN], dbo.FORMAT_NOMOR('SPL', D.KODE_SAMPEL) AS KODE_SAMPEL_BARU, dbo.FORMAT_NOMOR('SPL',D.KODE_RUJUKAN) AS KODE_SAMPEL_ASAL, D.KODE_SAMPEL, A.LCP, A.JUMLAH_SAMPEL FROM T_SAMPEL_RUJUKAN_DETIL A LEFT JOIN M_LINGKUP_RUJUKAN B ON A.LINGKUP_UJI = B.ID LEFT JOIN M_BBPOM C ON A.BBPOM_ID = C.BBPOM_ID LEFT JOIN T_M_SAMPEL D ON A.KODE_SAMPEL = D.KODE_RUJUKAN WHERE A.KODE_SAMPEL = '".$kode_rujukan."' AND A.USER_ID = '".$this->newsession->userdata('SESS_USER_ID')."' AND A.BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND SUBSTRING(D.KODE_SAMPEL,3,3) = '".$substr."'")->result_array();
				$arrdata['notallowed'] = FALSE;
			}
			return $arrdata;
		}
	}
}	
?>