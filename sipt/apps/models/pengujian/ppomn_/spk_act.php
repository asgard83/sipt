<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR);
class Spk_act extends Model{
	function get_spk($id,$subid){
		if((in_array('3', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('4', $this->newsession->userdata('SESS_KODE_ROLE'))) && in_array('02', $this->newsession->userdata('SESS_JENIS_PELAPORAN')) && $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model('main','main',TRUE);
			$arrdata = array();
			$arrid = explode(".", $id);
			if(in_array('B5',$this->newsession->userdata('SESS_SUB_SARANA'))){
				$query = "SELECT dbo.FORMAT_NOMOR('SPL', KODE_SAMPEL) AS KODE, KODE_SAMPEL, KOMODITI, KATEGORI, dbo.KATEGORI(KOMODITI) AS UR_KOMODITI, dbo.KATEGORI(KATEGORI) AS UR_KATEGORI, NAMA_SAMPEL, BENTUK_SEDIAAN FROM T_M_SAMPEL WHERE UJI_MIKRO = '1' AND STATUS_SAMPEL = '40201' AND SPU_ID = '".$arrid[0]."' ORDER BY 1 ASC";
				$arrdata['jenis_uji'] = "01";
			}else{
				$query = "SELECT dbo.FORMAT_NOMOR('SPL', KODE_SAMPEL) AS KODE, KODE_SAMPEL, KOMODITI, KATEGORI, dbo.KATEGORI(KOMODITI) AS UR_KOMODITI, dbo.KATEGORI(KATEGORI) AS UR_KATEGORI, NAMA_SAMPEL, BENTUK_SEDIAAN FROM T_M_SAMPEL WHERE UJI_KIMIA = '1' AND STATUS_SAMPEL = '40201' AND SPU_ID = '".$arrid[0]."' ORDER BY 1 ASC";
				$arrdata['jenis_uji'] = "02";
			}
			$data = $sipt->main->get_result($query);
			if($data){
				foreach($query->result_array() as $row){
					$arr [] = $row;
					$arrdata['arr'] = $arr;
					$arrdata['act'] = site_url().'/post/ppomn/spk_act/save';
				}
				$arrdata['komoditi'] = $row['KOMODITI'];
				$arrdata['dtspu'] = $this->db->query("SELECT dbo.FORMAT_NOMOR('SPU', SPU_ID) AS UR_FORMAT, CONVERT(VARCHAR(10), TANGGAL, 103) AS TANGGAL FROM T_SPU WHERE SPU_ID = '".$arrid[0]."'")->result_array();
			} 
			$arrdata['spuid'] = $arrid[0];
			$arrdata['batal'] = site_url().'/home/pengujian/sp/list/verifikasi';
			$arrdata['existing'] = $sipt->main->get_uraian("SELECT COUNT(*) AS JML FROM T_SPK WHERE SPU_ID = '".$arrid[0]."' AND CREATE_BY = '".$this->newsession->userdata('SESS_USER_ID')."'","JML");
			$arrdata['chkmikro'] = $sipt->main->get_uraian("SELECT COUNT(UJI_MIKRO) AS JML FROM T_M_SAMPEL WHERE SPU_ID = '".$arrid[0]."' AND UJI_MIKRO = '1'","JML");
			return $arrdata;
		}
	}
	
	function list_spk($id){
		if((in_array('3', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('4', $this->newsession->userdata('SESS_KODE_ROLE'))) && in_array('02', $this->newsession->userdata('SESS_JENIS_PELAPORAN')) && $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model('main','main',TRUE);
			$this->load->library('newtable');
			if($id=="all")
				$status = " AND B.STATUS NOT IN('30201')";
			else
				$status = " AND B.STATUS = '30201'";
			$this->newtable->hiddens(array('SPK_ID','SPU_ID','NOMOR_SP'));
			$this->newtable->search(array(array("B.SPK_ID", "Nomor SPK"),
										  array("CONVERT(VARCHAR(10), B.TANGGAL, 120)", "Tanggal SPK"),
										  array("A.SPU_ID", "Nomor SPU"),
										  array("CONVERT(VARCHAR(10), B.TANGGAL, 120)", "Tanggal SPU"),
										  array("dbo.KATEGORI(SUBSTRING(A.SPU_ID, 13,2))", "Komoditi")));	
			
			$query = "SELECT B.SPK_ID, A.SPU_ID, A.NOMOR_SP, dbo.FORMAT_NOMOR('SPU',A.SPU_ID) AS [NOMOR SPU], dbo.FORMAT_NOMOR('SP',A.NOMOR_SP) AS [NOMOR SP], dbo.FORMAT_NOMOR('SPK',B.SPK_ID) AS [NOMOR SPK], dbo.KATEGORI(SUBSTRING(A.SPU_ID, 13,2)) AS KOMODITI FROM T_SPK B LEFT JOIN T_SPU A ON B.SPU_ID = A.SPU_ID WHERE A.BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND B.KASIE = '".$this->newsession->userdata('SESS_USER_ID')."' $status";
			$this->newtable->columns(array("B.SPK_ID", "A.SPU_ID", "A.NOMOR_SP","dbo.FORMAT_NOMOR('SPU',A.SPU_ID)","dbo.FORMAT_NOMOR('SP',A.NOMOR_SP)","dbo.FORMAT_NOMOR('SPK',B.SPK_ID)","dbo.KATEGORI(SUBSTRING(A.SPU_ID, 13,2))"));
			$this->newtable->action(site_url()."/home/ppomn/spp/list/".$id);
			$this->newtable->width(array('NOMOR SPU' => 200, 'NOMOR SP' => 200, 'NOMOR SPK' => 200, 'KOMODITI' => 150));
			$this->newtable->cidb($this->db);
			$this->newtable->ciuri($this->uri->segment_array());
			$this->newtable->orderby(1);
			$this->newtable->sortby("ASC");
			$this->newtable->keys(array('SPU_ID','SPK_ID'));
			if($id=="verifikasi"){
				$proses['Tambah Surat Perintah Pengujian Baru'] = array('GET', site_url()."/home/ppomn/spp/new", '1');
				$judul = 'Data Perintah Kerja';
			}else{
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
	
	function set_spk($action, $isajax){
		if((in_array('2', $this->newsession->userdata('SESS_KODE_ROLE'))  || in_array('3', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('4', $this->newsession->userdata('SESS_KODE_ROLE'))) && in_array('02', $this->newsession->userdata('SESS_JENIS_PELAPORAN')) && $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			if($action=="save"){
				$msgok = "Tambah data SPK baru berhasil";
				$msgerr = "Tambah SPK baru gagal, Silahkan coba lagi";
				$arr_petugas = $this->input->post('USER_ID');
				$arr_slr = $this->input->post('SRL_ID');
				$hasil = FALSE;
				$next = FALSE;
				$chkmikro = FALSE;
				
				if($this->input->post('chkmikro')){#Jika Disposisi ke Mikrobiologi
					if($this->input->post('SP_PETUGAS') == ""){
						$next = FALSE;
						return "MSG#NO#Data SPK baru gagal disimpan.\n Anda belum memasukan nama petugas untuk disposisi. \n Mohon periksa kembali Permohonan Uji Ke Bidang Mikro."; die();
					}else{
						$next = TRUE;
						$jml = (int)$sipt->main->get_uraian("SELECT JML_SPU FROM T_SPU WHERE SPU_ID = '".$this->input->post('spuid')."'","JML_SPU") + 1;
						$this->db->simple_query("UPDATE T_SPU SET JML_SPU = '".$jml."', GET_DISPO = '1' WHERE SPU_ID = '".$this->input->post('spuid')."'");
						$this->db->simple_query("INSERT INTO T_SP_PETUGAS(SPU_ID, USER_ID) VALUES('".$this->input->post('spuid')."','".$this->input->post('SP_PETUGAS')."')");
					}
					$chkmikro = FALSE;
				}else{#Jika tidak disposisi ke mikro bi
					$next = TRUE;
					$chkmikro = TRUE;
				}
				
				if($next){
					if(!$arr_petugas){
						$this->db->simple_query("UPDATE T_SPU WHERE JML_SPU = '1', GET_DISPO = '0' WHERE SPU_ID = '".$this->input->post('spuid')."'");
						$this->db->simple_query("DELETE FROM T_SP_PETUGAS WHERE SPU_ID = '".$this->input->post('spuid')."' AND USER_ID = '".$this->input->post('SP_PETUGAS')."'");
						return "MSG#NO#Penyelia Pengujian belum ditunjuk."; die();
					}
					if(array_search("", $arr_slr) !== false){
						$this->db->simple_query("UPDATE T_SPU WHERE JML_SPU = '1', GET_DISPO = '0' WHERE SPU_ID = '".$this->input->post('spuid')."'");
						$this->db->simple_query("DELETE FROM T_SP_PETUGAS WHERE SPU_ID = '".$this->input->post('spuid')."' AND USER_ID = '".$this->input->post('SP_PETUGAS')."'");
						return "MSG#NO#Data SPK baru gagal disimpan.\n Ada salah satu atau beberapa parameter uji yang tidak ada dalam SRL. \n Mohon periksa kembali parameter uji yang di entri."; die();
					}else if(!$this->input->post('SRL_ID')){
						$this->db->simple_query("UPDATE T_SPU WHERE JML_SPU = '1', GET_DISPO = '0' WHERE SPU_ID = '".$this->input->post('spuid')."'");
						$this->db->simple_query("DELETE FROM T_SP_PETUGAS WHERE SPU_ID = '".$this->input->post('spuid')."' AND USER_ID = '".$this->input->post('SP_PETUGAS')."'");
						return "MSG#NO#Data SPK baru gagal disimpan.\n Ada salah satu atau beberapa parameter uji yang tidak ada dalam SRL. \n Mohon periksa kembali parameter uji yang di entri."; die();
					}else{
						$ins = 0;
						foreach($arr_petugas as $a){
							$arr_spk['SPU_ID'] = $this->input->post('spuid');
							$arr_spk['BBPOM_ID'] = $this->newsession->userdata('SESS_BBPOM_ID');
							$arr_spk['KOMODITI'] = $this->input->post('komoditi');
							$arr_spk['TANGGAL'] = $this->input->post('TANGGAL');
							$arr_spk['KASIE'] = $a;
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
						}
						if($ins > 0){
							$arrsampel = $this->input->post('UJI');
							$arrkeys = array_keys($arrsampel);
							if($this->input->post('jenis_uji') == "01"){
								$uji = '01'; //Mikrobiologi
							}else if($this->input->post('jenis_uji') == "02"){
								$uji = '02'; //Kimia-Fisika
							}else{
								$uji = '03';
							}
							for($s = 0; $s < count($_POST['UJI']['PARAMETER_UJI']); $s++){
								$cp = $sipt->main->set_kode_uji($lab,substr($this->input->post('spuid'), 12, 2));
								$parameter = array('UJI_ID' => $cp,
												   'SPK_ID' => $arr_spk['SPK_ID'],
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
					}
				}
				
				if($hasil){
					$jml_spu = (int)$sipt->main->get_uraian("SELECT JML_SPU FROM T_SPU WHERE SPU_ID = '".$this->input->post('spuid')."'","JML_SPU");
					$jml_sp_spu = (int)$sipt->main->get_uraian("SELECT COUNT(*) AS JML FROM T_SPK WHERE SPU_ID = '".$this->input->post('spuid')."'","JML");
					if(($jml_spu == $jml_sp_spu) && $chkmikro){
						$this->db->simple_query("UPDATE T_SPU SET STATUS = '30201' WHERE SPU_ID = '".$this->input->post('spuid')."'");
						$this->db->simple_query("UPDATE T_M_SAMPEL SET STATUS_SAMPEL = '30201' WHERE SPU_ID = '".$this->input->post('spuid')."'");
					}
					$logspu = array('SPU_ID' => $this->input->post('spuid'),
									'WAKTU' => 'GETDATE()',
									'USER_ID' => $this->newsession->userdata('SESS_USER_ID'),
									'KEGIATAN' => 'Simpan Surat Perintah Kerja : '.$arr_spk['SPK_ID'],
									'CATATAN' => '-');
					$this->db->insert('T_SPU_LOG', $logspu);
					return "MSG#YES#$msgok#".site_url()."/home/ppomn/sp/list/all";
				}else{
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
				$idpost = explode(".",$this->input->post('spuid'));
				$ko = substr($idpost[0],12,2);
				if(!$arr_petugas){
					return "MSG#NO#Petugas Pengujian belum ditunjuk."; die();
				}
				$arr_spp = array('SPK_ID' => $idpost[1],
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
					$this->db->simple_query("UPDATE T_SPK SET STATUS = '20201' WHERE SPK_ID = '".$idpost[1]."'");
					$logsp = array('SPP_ID' => $arr_spp['SPP_ID'],
								    'WAKTU' => 'GETDATE()',
									'USER_ID' => $this->newsession->userdata('SESS_USER_ID'),
									'KEGIATAN' => 'Simpan Surat Perintah Pengujian : '.$arr_spp['SPP_ID'],
									'CATATAN' => '-');
					$this->db->insert('T_SP_LOG', $logsp);
				}
				if($hasil){
					$jml_spu = (int)$sipt->main->get_uraian("SELECT JML_SPU FROM T_SPU WHERE SPU_ID = '".$idpost[0]."'","JML_SPU");
					$jml_sp_spu = (int)$sipt->main->get_uraian("SELECT COUNT(*) AS JML FROM T_SPK WHERE SPU_ID = '".$idpost[0]."'","JML");
					if($jml_spu == $jml_sp_spu){
						$this->db->simple_query("UPDATE T_SPU SET STATUS = '20201' WHERE SPU_ID = '".$idpost[0]."'");
						$this->db->simple_query("UPDATE T_M_SAMPEL SET STATUS_SAMPEL = '20201' WHERE SPU_ID = '".$idpost[0]."'");
					}
					return "MSG#YES#$msgok#".site_url()."/home/ppomn/spp/list/all";
				}else{
					return "MSG#YES#$msgok";
				}
				if($isajax!="ajax"){
					redirect(base_url());
					exit();
				}
			}#Akhir - SPP
		}
	}	
}	
?>