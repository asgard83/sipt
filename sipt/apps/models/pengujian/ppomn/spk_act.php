 <?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR);
class Spk_act extends Model{
	
	function get_spk($id){
		if((in_array('3', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('4', $this->newsession->userdata('SESS_KODE_ROLE'))) && in_array('02', $this->newsession->userdata('SESS_JENIS_PELAPORAN')) && $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model('main','main',TRUE);
			$arrdata = array();
			if(in_array('B1',$this->newsession->userdata('SESS_SUB_SARANA')) || in_array('B2',$this->newsession->userdata('SESS_SUB_SARANA')) || in_array('B3',$this->newsession->userdata('SESS_SUB_SARANA')) || in_array('B4',$this->newsession->userdata('SESS_SUB_SARANA'))){
				$arrdata['jenis_uji'] = "02";
			}else if(in_array('B5',$this->newsession->userdata('SESS_SUB_SARANA'))){
				$arrdata['jenis_uji'] = "01";
			}
			$arrdata['sampel'] = $this->db->query("SELECT A.PERIKSA_SAMPEL, A.KODE_SAMPEL, A.SPU_ID, dbo.FORMAT_NOMOR('SPL', A.KODE_SAMPEL) AS UR_KODESAMPEL, A.KOMODITI, dbo.KATEGORI(A.KOMODITI, A.PRIORITAS) AS UR_KOMODITI, dbo.KATEGORI(A.KATEGORI,A.PRIORITAS) AS UR_KATEGORI, A.KATEGORI, dbo.URAIAN_M_TABEL('SUB_TUJUAN', A.SUB_TUJUAN) AS SUB_TUJUAN, A.KLASIFIKASI_TAMBAHAN,A.NAMA_SAMPEL,A.NOMOR_REGISTRASI,A.PABRIK,IMPORTIR,A.BENTUK_SEDIAAN,A.KEMASAN,A.NO_BETS,A.KETERANGAN_ED,A.JUMLAH_SAMPEL,A.SATUAN,A.HARGA_SAMPEL,A.UJI_KIMIA,A.JUMLAH_KIMIA,A.UJI_MIKRO,A.JUMLAH_MIKRO,A.SISA,REPLACE(A.KOMPOSISI,';','<br>') AS KOMPOSISI,A.NETTO,A.KONDISI_SAMPEL,A.EVALUASI_PENANDAAN,A.CARA_PENYIMPANAN, A.LABEL, A.SEGEL,A.CATATAN,A.STATUS_KIMIA,A.STATUS_MIKRO,A.STATUS_SAMPEL,A.LAMPIRAN,B.BBPOM_ID, dbo.FORMAT_NOMOR('SP', C.NOMOR_SP) AS UR_SPP, CONVERT(VARCHAR(10), C.TANGGAL, 103) AS TGL_SPP FROM T_M_SAMPEL A LEFT JOIN T_PERIKSA_SAMPEL B ON A.PERIKSA_SAMPEL = B.PERIKSA_SAMPEL LEFT JOIN T_SPU C ON A.SPU_ID = C.SPU_ID WHERE A.KODE_SAMPEL = '".$id."'")->result_array(); 
			$arrdata['act'] = site_url().'/post/ppomn/spk_act/save';
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
				return $this->fungsi->redirectMessage('Maaf, SPK : '.$inboleh[0]['SPK_ID'].', tidak termasuk dalam revisi SPK."','/home/ppomn/sp/list/review'); exit();
			}
			$arrdata = array();
			$arrdata['act'] = site_url().'/post/ppomn/spk_act/review';
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
				$query =  "SELECT B.SPK_ID, A.SPU_ID, A.NOMOR_SP, C.KODE_SAMPEL, C.PERIKSA_SAMPEL, dbo.FORMAT_NOMOR('SPL', C.KODE_SAMPEL) AS [KODE SAMPEL], dbo.FORMAT_NOMOR('SPU',A.SPU_ID) AS [NOMOR SPU], dbo.FORMAT_NOMOR('SPK',B.SPK_ID) AS [NOMOR SPK], CONVERT(VARCHAR(10), B.TANGGAL, 120) AS [TANGGAL SPK], C.NAMA_SAMPEL +'<div>Komoditi : '+ dbo.KATEGORI(SUBSTRING(A.SPU_ID, 13,2),'0') +'</div>' AS [NAMA SAMPEL], dbo.URAIAN_M_TABEL('ASAL_SAMPLING',A.ASAL_SAMPEL) AS [ASAL SAMPLING] FROM T_SPK B LEFT JOIN T_SPU A ON B.SPU_ID = A.SPU_ID LEFT JOIN T_M_SAMPEL C ON B.KODE_SAMPEL = C.KODE_SAMPEL WHERE A.BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND B.KASIE = '".$this->newsession->userdata('SESS_USER_ID')."' AND B.STATUS = '30201'";
				
				$this->newtable->search(array(array("dbo.FORMAT_NOMOR('SPL', C.KODE_SAMPEL)", "Kode Sampel"), array("C.NAMA_SAMPEL", "Nama Sampel"),array("dbo.FORMAT_NOMOR('SPU',A.SPU_ID)", "Nomor SPU"),
										  array("CONVERT(VARCHAR(10), B.TANGGAL, 120)", "Tanggal SPU"),
										  array("dbo.FORMAT_NOMOR('SPU',B.SPK_ID)", "Nomor SPK"),
										  array("CONVERT(VARCHAR(10), B.TANGGAL, 120)", "Tanggal SPK"),
										  array("CONVERT(VARCHAR(10), A.TANGGAL_PERINTAH, 120)", "Tanggal SP"),
										  array("dbo.KATEGORI(SUBSTRING(A.SPU_ID, 13,2),'0')", "Komoditi"),
										  array("dbo.URAIAN_M_TABEL('ASAL_SAMPLING',A.ASAL_SAMPEL)", "Asal Sampling")));
				
				$this->newtable->columns(array("B.SPK_ID", "A.SPU_ID", "A.NOMOR_SP", "C.KODE_SAMPEL", "C.PERIKSA_SAMPEL", array("dbo.FORMAT_NOMOR('SPL', C.KODE_SAMPEL)",site_url()."/home/sampel/preview/{PERIKSA_SAMPEL}.{KODE_SAMPEL}"), "dbo.FORMAT_NOMOR('SPU',A.SPU_ID)","dbo.FORMAT_NOMOR('SPK',B.SPK_ID)", "CONVERT(VARCHAR(10), B.TANGGAL, 120)","C.NAMA_SAMPEL +'<div>Komoditi : '+ dbo.KATEGORI(SUBSTRING(A.SPU_ID, 13,2),'0') +'</div>'","dbo.URAIAN_M_TABEL('ASAL_SAMPLING',A.ASAL_SAMPEL)"));
				$this->newtable->width(array('KODE SAMPEL' => 135, 'NOMOR SPU' => 130, 'NOMOR SPK' => 130, 'TANGGAL SPK' => 80, 'NAMA SAMPEL' => 225));
				$this->newtable->keys(array('SPU_ID','SPK_ID'));
			}else if($id == "all"){#SPK Terkirim
				$query =  "SELECT B.SPK_ID, A.SPU_ID, A.NOMOR_SP, C.KODE_SAMPEL, C.PERIKSA_SAMPEL, dbo.FORMAT_NOMOR('SPL', C.KODE_SAMPEL) AS [KODE SAMPEL], dbo.FORMAT_NOMOR('SPU',A.SPU_ID) AS [NOMOR SPU], dbo.FORMAT_NOMOR('SPK',B.SPK_ID) AS [NOMOR SPK], CONVERT(VARCHAR(10), B.TANGGAL, 120) AS [TANGGAL SPK], dbo.FORMAT_NOMOR('SPP',D.SPP_ID) AS [NOMOR SPP], C.NAMA_SAMPEL +'<div>Komoditi : '+ dbo.KATEGORI(SUBSTRING(A.SPU_ID, 13,2),'0') +'</div>' AS [NAMA SAMPEL], dbo.URAIAN_M_TABEL('ASAL_SAMPLING',A.ASAL_SAMPEL) AS [ASAL SAMPLING] FROM T_SPK B LEFT JOIN T_SPU A ON B.SPU_ID = A.SPU_ID LEFT JOIN T_M_SAMPEL C ON B.KODE_SAMPEL = C.KODE_SAMPEL LEFT JOIN T_SPP D ON B.SPK_ID = D.SPK_ID WHERE A.BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND B.KASIE = '".$this->newsession->userdata('SESS_USER_ID')."' AND B.STATUS NOT IN ('30201')";
				
				$this->newtable->search(array(array("dbo.FORMAT_NOMOR('SPL', C.KODE_SAMPEL)", "Kode Sampel"), array("C.NAMA_SAMPEL", "Nama Sampel"),array("dbo.FORMAT_NOMOR('SPU',A.SPU_ID)", "Nomor SPU"),
										  array("CONVERT(VARCHAR(10), B.TANGGAL, 120)", "Tanggal SPU"),
										  array("dbo.FORMAT_NOMOR('SPU',B.SPK_ID)", "Nomor SPK"),
										  array("CONVERT(VARCHAR(10), B.TANGGAL, 120)", "Tanggal SPK"),
										  array("dbo.FORMAT_NOMOR('SPP',D.SPP_ID)", "Nomor SPP"),
										  array("dbo.KATEGORI(SUBSTRING(A.SPU_ID, 13,2),'0')", "Komoditi"),
										  array("dbo.URAIAN_M_TABEL('ASAL_SAMPLING',A.ASAL_SAMPEL)", "Asal Sampling")));
				
				$this->newtable->columns(array("B.SPK_ID", "A.SPU_ID", "A.NOMOR_SP", "C.KODE_SAMPEL", "C.PERIKSA_SAMPEL", array("dbo.FORMAT_NOMOR('SPL', C.KODE_SAMPEL)",site_url()."/home/ppomn/spp/view/{SPK_ID}"), "dbo.FORMAT_NOMOR('SPU',A.SPU_ID)","dbo.FORMAT_NOMOR('SPK',B.SPK_ID)", "CONVERT(VARCHAR(10), B.TANGGAL, 120)","dbo.FORMAT_NOMOR('SPP',D.SPP_ID)","C.NAMA_SAMPEL +'<div>Komoditi : '+ dbo.KATEGORI(SUBSTRING(A.SPU_ID, 13,2),'0') +'</div>'","dbo.URAIAN_M_TABEL('ASAL_SAMPLING',A.ASAL_SAMPEL)"));
				$this->newtable->hiddens(array('SPK_ID','SPU_ID','NOMOR_SP','KODE_SAMPEL','PERIKSA_SAMPEL'));
				$this->newtable->width(array('KODE SAMPEL' => 135, 'NOMOR SPU' => 130, 'NOMOR SPK' => 130, 'TANGGAL SPK' => 80, 'NOMOR SPP' => 130,'NAMA SAMPEL' => 225));
				$this->newtable->keys(array('SPK_ID'));
			}
			$this->newtable->hiddens(array('SPK_ID','SPU_ID','NOMOR_SP','KODE_SAMPEL','PERIKSA_SAMPEL'));
			$this->newtable->action(site_url()."/home/ppomn/spp/list/".$id);
			$this->newtable->cidb($this->db);
			$this->newtable->ciuri($this->uri->segment_array());
			$this->newtable->orderby(1);
			$this->newtable->sortby("ASC");
			if($id=="verifikasi"){
				$proses['Tambah Surat Perintah Pengujian Baru'] = array('GET', site_url()."/home/ppomn/spp/new", '1');
				$judul = 'Data Perintah Kerja';
			}else{
				$proses['Detail Surat Perintah Pengujian'] = array('GET', site_url()."/home/ppomn/spp/view", '1');
				$proses['Cetak Surat Perintah Pengujian'] = array('GETNEW', site_url()."/topdf/ppomn/cetak/spp", '1');
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
			$arrdata['act'] = site_url().'/post/ppomn/spk_act/view';
			$spk_id = $sipt->main->get_uraian("SELECT SPK_ID FROM T_SPK WHERE KODE_SAMPEL = '".$id."' AND CREATE_BY = '".$this->newsession->userdata('SESS_USER_ID')."'","SPK_ID"); 
			$query = "SELECT A.SPU_ID, A.KODE_SAMPEL, A.SPK_ID, dbo.FORMAT_NOMOR('SPU', A.SPU_ID) AS UR_SPU, dbo.FORMAT_NOMOR('SPK', A.SPK_ID) AS UR_SPK, dbo.FORMAT_NOMOR('SPL', A.KODE_SAMPEL) AS UR_KODE, A.CREATE_BY, CONVERT(VARCHAR(10), A.TANGGAL, 103) AS TANGGAL_SPK, A.KASIE, B.NAMA_USER, B.JABATAN FROM T_SPK A LEFT JOIN T_USER B ON A.KASIE = B.USER_ID WHERE A.SPK_ID = '".$spk_id."'";
			$data = $sipt->main->get_result($query);
			if($data){
				foreach($query->result_array() as $row){
					$arrdata['sess'] = $row;
				}
				$arrdata['parameter'] = $this->db->query("SELECT A.UJI_ID, A.PARAMETER_UJI, A.METODE, A.PUSTAKA, A.SYARAT, A.RUANG_LINGKUP, B.KATEGORI, C.NAMA_USER AS PENYELIA, A.PENGUJI, D.NAMA_USER AS UR_PENGUJI FROM T_PARAMETER_HASIL_UJI A LEFT JOIN T_M_SAMPEL B ON A.KODE_SAMPEL = B.KODE_SAMPEL LEFT JOIN T_USER C ON A.PENYELIA = C.USER_ID LEFT JOIN T_USER D ON A.PENGUJI = D.USER_ID WHERE A.SPK_ID = '".$spk_id."'")->result_array();
				$arrdata['logspk'] = $sipt->main->get_uraian("SELECT COUNT(*) LOGSPK FROM T_SPK_LOG WHERE SPK_ID = '".$spk_id."'","LOGSPK"); 
				$arrdata['sampel'] = $this->db->query("SELECT A.PERIKSA_SAMPEL, A.KODE_SAMPEL, A.SPU_ID, dbo.FORMAT_NOMOR('SPL', A.KODE_SAMPEL) AS UR_KODESAMPEL, A.KOMODITI, dbo.KATEGORI(A.KOMODITI,A.PRIORITAS) AS UR_KOMODITI, dbo.KATEGORI(A.KATEGORI,A.PRIORITAS) AS UR_KATEGORI, A.KATEGORI, dbo.URAIAN_M_TABEL('SUB_TUJUAN', A.SUB_TUJUAN) AS SUB_TUJUAN, A.KLASIFIKASI_TAMBAHAN,A.NAMA_SAMPEL,A.NOMOR_REGISTRASI,A.PABRIK,IMPORTIR,A.BENTUK_SEDIAAN,A.KEMASAN,A.NO_BETS,A.KETERANGAN_ED,A.JUMLAH_SAMPEL,A.SATUAN,A.HARGA_SAMPEL,A.UJI_KIMIA,A.JUMLAH_KIMIA,A.UJI_MIKRO,A.JUMLAH_MIKRO,A.SISA,A.KOMPOSISI,A.NETTO,A.KONDISI_SAMPEL,A.EVALUASI_PENANDAAN,A.CARA_PENYIMPANAN, A.LABEL, A.SEGEL,A.CATATAN,A.STATUS_KIMIA,A.STATUS_MIKRO,A.STATUS_SAMPEL,A.LAMPIRAN,B.BBPOM_ID, dbo.FORMAT_NOMOR('SP', C.NOMOR_SP) AS UR_SPP, CONVERT(VARCHAR(10), C.TANGGAL, 103) AS TGL_SPP FROM T_M_SAMPEL A LEFT JOIN T_PERIKSA_SAMPEL B ON A.PERIKSA_SAMPEL = B.PERIKSA_SAMPEL LEFT JOIN T_SPU C ON A.SPU_ID = C.SPU_ID WHERE A.KODE_SAMPEL = '".$id."'")->result_array(); 
				$arrdata['arrpenguji'] = $sipt->main->combobox("SELECT USER_ID, NAMA_USER FROM T_USER WHERE USER_ID IN (SELECT USER_ID FROM T_USER_ROLE WHERE ROLE = '2' AND JENIS_PELAPORAN = '02') AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","USER_ID","NAMA_USER",TRUE);
				if(in_array('B1',$this->newsession->userdata('SESS_SUB_SARANA')) || in_array('B2',$this->newsession->userdata('SESS_SUB_SARANA')) || in_array('B3',$this->newsession->userdata('SESS_SUB_SARANA')) || in_array('B4',$this->newsession->userdata('SESS_SUB_SARANA'))){
					$arrdata['jenis_uji'] = "02";
				}else if(in_array('B5',$this->newsession->userdata('SESS_SUB_SARANA'))){
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
			$arrdata['act'] = site_url().'/post/ppomn/spk_act/edit-penyelia';
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
		if((in_array('2', $this->newsession->userdata('SESS_KODE_ROLE'))  || in_array('3', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('4', $this->newsession->userdata('SESS_KODE_ROLE'))) && in_array('02', $this->newsession->userdata('SESS_JENIS_PELAPORAN')) && $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			if($action=="save"){
				$hasil = FALSE;
				$msgok = "Tambah data SPK baru berhasil";
				$msgerr = "Tambah SPK baru gagal, Silahkan coba lagi";
				$arr_petugas = $this->input->post('USER_ID');
				$ins = 0;
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
				$arr_spk['SPK_ID'] = $sipt->main->set_kode_spk($this->input->post('komoditi'),$lab);
				if($this->db->insert('T_SPK', $arr_spk)){
					$sipt->main->set_max('spk',$this->input->post('komoditi'));
					$ins++;
				}else{
					$this->db->simple_query("DELETE FROM T_SPK WHERE SPK_ID ='".$arr_spk['SPK_ID']."'");
					$this->db->simple_query("DELETE FROM T_PARAMETER_HASIL_UJI WHERE SPK_ID ='".$arr_spk['SPK_ID']."'");
				}
				if($ins > 0){
					$arrsampel = $this->input->post('UJI');
					$arrkeys = array_keys($arrsampel);
					if($this->input->post('jenis_uji') == "01"){
						$uji = '01'; //Mikrobiologi
					}else{
						$uji = '02'; //Kimia-Fisika
					}
					for($s = 0; $s < count($_POST['UJI']['PARAMETER_UJI']); $s++){
						$cp = $sipt->main->set_kode_uji($lab,substr($this->input->post('spuid'), 12, 2));
						$parameter = array('UJI_ID' => $cp,
										   'SPK_ID' => $arr_spk['SPK_ID'],
										   'KODE_SAMPEL' => $this->input->post('kode_sampel'),
										   'JENIS_UJI' => $uji,
										   'AWAL_UJI' => null,
										   'AKHIR_UJI' => null);
						for($j=0;$j<count($arrkeys);$j++){
							$parameter[$arrkeys[$j]] = $arrsampel[$arrkeys[$j]][$s];

						}
						$this->db->insert('T_PARAMETER_HASIL_UJI', $parameter);
						$sipt->main->set_max('uji',substr($this->input->post('spuid'), 12, 2));
						$hasil = TRUE;
					}
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
					return "MSG#YES#$msgok#".site_url()."/home/ppomn/sp/list/send";
				}else{
					$this->db->simple_query("UPDATE T_SAMPEL_MT SET STATUS = '40201' WHERE SPU_ID = '".$this->input->post('spuid')."' AND KODE_SAMPEL = '".$this->input->post('KODE_SAMPEL')."'");
					$this->db->simple_query("UPDATE T_M_SAMPEL SET STATUS_SAMPEL = '40201' WHERE KODE_SAMPEL = '".$this->input->post('kode_sampel')."'");
					$this->db->simple_query("DELETE FROM T_SPK WHERE SPK_ID ='".$arr_spk['SPK_ID']."'");
					$this->db->simple_query("DELETE FROM T_PARAMETER_HASIL_UJI WHERE SPK_ID ='".$arr_spk['SPK_ID']."'");
					return "MSG#YES#$msgerr";
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
				$arr_spp['SPP_ID'] = $sipt->main->set_kode_spp($ko);
				$ins = 0;
				if($this->db->insert('T_SPP',$arr_spp)){
					$sipt->main->set_max('spp',$ko);
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
					return "MSG#YES#$msgok#".site_url()."/home/ppomn/spp/list/all";
				}else{
					return "MSG#YES#$msgerr";
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
					return "MSG#YES#$msgok#".site_url()."/home/ppomn/spp/list/verifikasi";
				}else{
					return "MSG#YES#$msgerr";
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
					return "MSG#YES#$msgok#".site_url()."/home/ppomn/sp/list/send";
				}else{
					return "MSG#YES#$msgerr";
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
				if(in_array('B1',$this->newsession->userdata('SESS_SUB_SARANA')) || in_array('B2',$this->newsession->userdata('SESS_SUB_SARANA')) || in_array('B3',$this->newsession->userdata('SESS_SUB_SARANA')) || in_array('B4',$this->newsession->userdata('SESS_SUB_SARANA'))){
					$lab = "K";
				}else if(in_array('B5',$this->newsession->userdata('SESS_SUB_SARANA'))){
					$lab = "M";
				}
				for($s = 0; $s < count($_POST['UJI']['PARAMETER_UJI']); $s++){
					$cp = $sipt->main->set_kode_uji($lab,substr($this->input->post('SPU_ID'), 12, 2));
					$parameter = array('UJI_ID' => $cp,
								   'SPK_ID' => $this->input->post('SPK_ID'),
								   'KODE_SAMPEL' => $this->input->post('KODE_SAMPEL'),
								   'AWAL_UJI' => 'GETDATE()',
								   'AKHIR_UJI' => null,
								   'STATUS' => '20201');
					for($j=0;$j<count($arrkeys);$j++){
						$parameter[$arrkeys[$j]] = $arrsampel[$arrkeys[$j]][$s];
	
					}
					if($this->db->insert('T_PARAMETER_HASIL_UJI', $parameter)){
						$sipt->main->set_max('uji',substr($this->input->post('SPU_ID'), 12, 2));
						$hasil = TRUE;
					}
				}
				if($hasil){
					return "MSG#YES#$msgok#".site_url()."/home/ppomn/spk/view/".$this->input->post('KODE_SAMPEL');
				}else{
					return "MSG#YES#$msgerr";
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
		}
	}	
}	
?>