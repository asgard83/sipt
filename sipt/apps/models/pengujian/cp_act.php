<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR);
class Cp_act extends Model{
	function list_cp($id){
		if((in_array('3', $this->newsession->userdata('SESS_KODE_ROLE')) && in_array('02', $this->newsession->userdata('SESS_JENIS_PELAPORAN'))) && $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$this->load->library('newtable');
			
			
			if(in_array('B1',$this->newsession->userdata('SESS_SUB_SARANA')) || in_array('B2',$this->newsession->userdata('SESS_SUB_SARANA'))){
				$uji = "AND UJI_KIMIA = '1'";
			}else if(in_array('B3',$this->newsession->userdata('SESS_SUB_SARANA'))){
				$uji = "AND UJI_MIKRO = '1'";
			}
			
			if($id == "draft"){
				$judul = "Draft Catatan Pengujian";
				$query = "SELECT KODE_SAMPEL, dbo.FORMAT_NOMOR('SPL', KODE_SAMPEL) AS [KODE SAMPEL], NAMA_SAMPEL + '<div>' + KEMASAN + '</div><div>' + NOMOR_REGISTRASI + '</div>' AS [IDENTITAS SAMPEL], dbo.KATEGORI(KOMODITI,PRIORITAS) + '<div>' + NAMA_KATEGORI + '</div>' AS KOMODITI, CASE WHEN KODE_RUJUKAN IS NOT NULL THEN 'Uji Rujuk' WHEN KODE_UNGGULAN IS NOT NULL THEN 'Uji Unggulan' ELSE 'Rutin' END AS [TIPE UJI] FROM T_M_SAMPEL WHERE KODE_SAMPEL IN (SELECT DISTINCT(KODE_SAMPEL)
FROM T_PARAMETER_HASIL_UJI WHERE PENYELIA = '".$this->newsession->userdata('SESS_USER_ID')."' AND STATUS IN('30202')) $uji";
				$this->newtable->columns(array("KODE_SAMPEL", array("dbo.FORMAT_NOMOR('SPL', KODE_SAMPEL)",site_url()."/home/pengujian/cp/new/{KODE_SAMPEL}"), "NAMA_SAMPEL + '<div>' + KEMASAN + '</div><div>' + NOMOR_REGISTRASI + '</div>'", "dbo.KATEGORI(KOMODITI,PRIORITAS) + '<div>' + NAMA_KATEGORI + '</div>'", "CASE WHEN KODE_RUJUKAN IS NOT NULL THEN 'Uji Rujuk' WHEN KODE_UNGGULAN IS NOT NULL THEN 'Uji Unggulan' ELSE 'Rutin' END"));
				$proses['Preview Data'] = array('GET', site_url()."/home/pengujian/cp/new", '1');
			}else{
				$judul = "Catatan Pengujian";
				$query = "SELECT KODE_SAMPEL, dbo.FORMAT_NOMOR('SPL', KODE_SAMPEL) AS [KODE SAMPEL], NAMA_SAMPEL + '<div>' + KEMASAN + '</div><div>' + NOMOR_REGISTRASI + '</div>' AS [IDENTITAS SAMPEL], dbo.KATEGORI(KOMODITI,PRIORITAS) + '<div>' + NAMA_KATEGORI + '</div>' AS KOMODITI, CASE WHEN KODE_RUJUKAN IS NOT NULL THEN 'Uji Rujuk' WHEN KODE_UNGGULAN IS NOT NULL THEN 'Uji Unggulan' ELSE 'Rutin' END AS [TIPE UJI] FROM T_M_SAMPEL WHERE KODE_SAMPEL IN (SELECT DISTINCT(KODE_SAMPEL)
FROM T_PARAMETER_HASIL_UJI WHERE PENYELIA = '".$this->newsession->userdata('SESS_USER_ID')."' AND STATUS NOT IN('30202','20201','20202')) $uji";
				$this->newtable->columns(array("KODE_SAMPEL", "dbo.FORMAT_NOMOR('SPL', KODE_SAMPEL)", "NAMA_SAMPEL + '<div>' + KEMASAN + '</div><div>' + NOMOR_REGISTRASI + '</div>'", "dbo.KATEGORI(KOMODITI,PRIORITAS) + '<div>' + NAMA_KATEGORI + '</div>'", "CASE WHEN KODE_RUJUKAN IS NOT NULL THEN 'Uji Rujuk' WHEN KODE_UNGGULAN IS NOT NULL THEN 'Uji Unggulan' ELSE 'Rutin' END"));
				$proses['Cetak Data CP'] = array('GETNEW', site_url()."/topdf/cp/prints", '1');
			}
			$this->newtable->hiddens(array('KODE_SAMPEL','STATUS'));
			$this->newtable->search(array(array("dbo.FORMAT_NOMOR('SPL', KODE_SAMPEL)", "Kode Sampel"),array("NAMA_SAMPEL","Nama Sampel"), array("NAMA_KATEGORI","Komoditi"), array("CASE WHEN KODE_RUJUKAN IS NOT NULL THEN 'Uji Rujuk' WHEN KODE_UNGGULAN IS NOT NULL THEN 'Uji Unggulan' ELSE 'Rutin' END", "Tipe Uji")));
			$this->newtable->action(site_url()."/home/pengujian/cp/list/".$id);
			$this->newtable->width(array('KODE SAMPEL' => 75, 'IDENTITAS SAMPEL' => 300, 'KOMODITI' => 200, 'TIPE UJI' => 50));
			$this->newtable->cidb($this->db);
			$this->newtable->ciuri($this->uri->segment_array());
			$this->newtable->orderby(1);
			$this->newtable->sortby("ASC");
			$this->newtable->keys(array('KODE_SAMPEL'));
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

	function get_cp($id){
		if((in_array('3', $this->newsession->userdata('SESS_KODE_ROLE')) && in_array('02', $this->newsession->userdata('SESS_JENIS_PELAPORAN'))) && $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$this->load->library('newtable');
			if(in_array('B1',$this->newsession->userdata('SESS_SUB_SARANA')) || in_array('B2',$this->newsession->userdata('SESS_SUB_SARANA'))){#Bidang Kimia Fisik
				$isvalid = $sipt->main->get_uraian("SELECT COUNT(JML) AS JML FROM (SELECT DISTINCT(STATUS) AS JML 
FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL = '".$id."' AND UJI_MAMPU = '1' AND JENIS_UJI = '02' AND PENYELIA = '".$this->newsession->userdata('SESS_USER_ID')."') AS DATA","JML");
			}else if(in_array('B3',$this->newsession->userdata('SESS_SUB_SARANA'))){#Bidang Mikro
				$isvalid = $sipt->main->get_uraian("SELECT COUNT(JML) AS JML FROM (SELECT DISTINCT(STATUS) AS JML 
FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL = '".$id."' AND UJI_MAMPU = '1' AND JENIS_UJI = '01' AND PENYELIA = '".$this->newsession->userdata('SESS_USER_ID')."') AS DATA","JML");
			}
			if($isvalid > 1){#Jika data Hasil entri pengujian, maka draft belum bisa dibuka.
				return $this->fungsi->redirectMessage('Maaf, draft catatan pengujian belum bisa diverifikasi. Ada beberapa parameter uji yang belum di entri hasilnya atau ditolak hasilnya','/home/pengujian/cp/list/draft'); die();
			}
			$query = "SELECT A.NAMA_SAMPEL, A.KODE_SAMPEL, dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) AS KODE, A.TEMPAT_SAMPLING, CONVERT(VARCHAR(10), A.TANGGAL_SAMPLING, 103) AS TANGGAL_SAMPLING, A.ALAMAT_SAMPLING, A.NOMOR_REGISTRASI, A.PABRIK, A.IMPORTIR, A.KEMASAN, A.BENTUK_SEDIAAN, A.NO_BETS, dbo.KATEGORI(A.KOMODITI,A.PRIORITAS) AS KOMODITI, dbo.KATEGORI(A.KATEGORI,A.PRIORITAS) AS KATEGORI, A.KETERANGAN_ED, A.JUMLAH_KIMIA, A.JUMLAH_MIKRO, REPLACE(A.KOMPOSISI,';','<br>') AS KOMPOSISI, A.NETTO, B.NOMOR_SURAT, CONVERT(VARCHAR(10), B.TANGGAL_SURAT, 103) AS TANGGAL_SURAT, A.PEMERIAN, B.NAMA_PENGIRIM, CONVERT(VARCHAR(10), C.TANGGAL_TERIMA_TPS, 103) AS TANGGAL_TERIMA_TPS, A.LABEL, A.SEGEL, C.SPU_ID, RTRIM(LTRIM(A.KODE_RUJUKAN)) AS KDLAMA, A.UJI_UNGGULAN, A.KODE_UNGGULAN, A.KODE_RUJUKAN FROM T_M_SAMPEL A LEFT JOIN T_PERIKSA_SAMPEL B ON A.PERIKSA_SAMPEL = B.PERIKSA_SAMPEL LEFT JOIN T_SPU C ON A.SPU_ID = C.SPU_ID WHERE A.KODE_SAMPEL = '".$id."'";
			$parameter = $this->db->query("SELECT SPK_ID, UJI_ID, PARAMETER_UJI, METODE, PUSTAKA, SYARAT, RUANG_LINGKUP, HASIL, HASIL_KUALITATIF, LCP, STATUS FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL = '".$id."' AND UJI_MAMPU = '1' AND PENYELIA = '".$this->newsession->userdata('SESS_USER_ID')."'")->result_array();
			$kabid = $this->db->query("SELECT CREATE_BY AS MT FROM T_SPK WHERE SPK_ID = '".$parameter[0]['SPK_ID']."'")->result_array();
			$penguji = $this->db->query("SELECT A.NAMA_USER FROM T_USER A LEFT JOIN T_PARAMETER_HASIL_UJI B ON A.USER_ID = B.PENGUJI WHERE B.KODE_SAMPEL = '".$id."' AND B.PENYELIA = '".$this->newsession->userdata('SESS_USER_ID')."'")->result_array();
			$tanggaluji = $this->db->query("SELECT KODE_SAMPEL, MIN(CONVERT(VARCHAR(10), AWAL_UJI, 120)) AS MINTGL, MAX(CONVERT(VARCHAR(10), AKHIR_UJI, 120)) AS MAXTGL FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL = '".$id."' GROUP BY KODE_SAMPEL")->result_array();
			$data = $sipt->main->get_result($query);
			if($data){
				foreach($query->result_array() as $row){
					$arrdata = array('sess' => $row,
									 'parameter' => $parameter,
									 'kabid' => $kabid,
									 'penguji' => $penguji,
									 'tanggaluji' => $tanggaluji,
									 'SPK_ID' => $parameter[0]['SPK_ID'],
									 'SPU_ID' => $row['SPU_ID'],
									 'act' => site_url().'/post/cp/cp_act/save');

				}
				
				
				$arrdata['data_asal'] = 0;
				$arrdata['asal'] = array();
				if($arrdata['sess']['KODE_UNGGULAN'] != ''){				
					$arrdata['asal'] = $this->db->query("SELECT dbo.FORMAT_NOMOR('SPL', A.KODE_SAMPEL) AS UR_KODESAMPEL, B.NAMA_BBPOM FROM T_M_SAMPEL A LEFT JOIN M_BBPOM B ON B.BBPOM_ID = A.BBPOM_ID WHERE A.KODE_SAMPEL='".$arrdata['sess']['KODE_UNGGULAN']."' AND A.UJI_UNGGULAN='1' ")->result_array();
					$arrdata['data_asal'] = 1;
					$arrdata['tipe'] = 'Unggulan';
				}else if($arrdata['sess']['KODE_RUJUKAN'] != ''){
					$arrdata['asal'] = $this->db->query("SELECT dbo.FORMAT_NOMOR('SPL', A.KODE_SAMPEL) AS UR_KODESAMPEL, B.NAMA_BBPOM FROM T_M_SAMPEL A LEFT JOIN M_BBPOM B ON B.BBPOM_ID = A.BBPOM_ID WHERE A.KODE_SAMPEL='".$arrdata['sess']['KODE_RUJUKAN']."' AND A.UJI_RUJUK='1' ")->result_array();
					$arrdata['data_asal'] = 1;
					$arrdata['tipe'] = 'Rujukan';
				}


				if(in_array('B3',$this->newsession->userdata('SESS_SUB_SARANA'))){
					$jml = "SELECT JUMLAH_UJI FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL = '".$id."' AND JENIS_UJI = '01'";
					$jsampel = $sipt->main->get_uraian("SELECT JUMLAH_MIKRO FROM T_M_SAMPEL WHERE KODE_SAMPEL = '".$id."'","JUMLAH_MIKRO");
				}else{
					$jml = "SELECT JUMLAH_UJI FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL = '".$id."' AND JENIS_UJI = '02'";
					$jsampel = $sipt->main->get_uraian("SELECT JUMLAH_KIMIA FROM T_M_SAMPEL WHERE KODE_SAMPEL = '".$id."'","JUMLAH_KIMIA");
				}
				$dtjml = $sipt->main->get_result($jml);
				$jmlakhir = 0;
				if($dtjml){
					foreach($jml->result_array() as $row){
						$jmlakhir = $jmlakhir + $row['JUMLAH_UJI'];
					}
				}else{
					$jmlakhir = 0;
				}
				$arrdata['sisa_uji'] = $jsampel - $jmlakhir;
				$arrdata['arrmt'] = $sipt->main->combobox("SELECT A.USER_ID, A.NAMA_USER +' - '+ A.JABATAN AS NAMA_USER FROM T_USER A LEFT JOIN T_USER_ROLE B ON A.USER_ID = B.USER_ID WHERE B.ROLE = '4' AND B.JENIS_PELAPORAN = '02' AND A.BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND LEFT(B.SARANA_MEDIA_ID,2) = 'B2' AND A.STATUS = 'Aktif' GROUP BY A.USER_ID, A.NAMA_USER, A.JABATAN ORDER BY 2 ASC", "USER_ID", "NAMA_USER");

			}
			$arrdata['hasil'] = $sipt->main->combobox("SELECT KODE,URAIAN FROM M_TABEL WHERE JENIS = 'HASIL' AND KODE IN ('HPST','MS','TMS')", "KODE", "URAIAN", TRUE);
			$arrdata['judul'] = "Catatan Pengujian";
			$arrdata['hasil_pu'] = $sipt->main->combobox("SELECT KODE FROM M_TABEL WHERE JENIS = 'HASIL' AND KODE IN ('MS','TMS')", "KODE", "KODE", TRUE);
			return $arrdata;
		}
	}
	
	function get_popup($id){
		if(array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('10', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('9', $this->newsession->userdata('SESS_KODE_ROLE')) || $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$arrid = explode(".",$id);
			$query = "SELECT A.CP_ID, A.KODE_SAMPEL, dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) AS UR_KODE, B.NAMA_BBPOM, B.BBPOM_ID, A.HASIL, A.CATATAN, C.NAMA_USER AS MT, C.JABATAN AS JABATAN_MT, D.NAMA_USER AS PENYELIA, E.NAMA_USER AS VERIFIKATOR, E.JABATAN AS JABATAN_VERIFIKATOR FROM T_CP A LEFT JOIN M_BBPOM B ON A.BBPOM_ID = B.BBPOM_ID LEFT JOIN T_USER C ON A.MT = C.USER_ID  LEFT JOIN T_USER D ON A.CREATE_BY = D.USER_ID LEFT JOIN T_USER E ON A.UPDATE_BY = E.USER_ID WHERE A.CP_ID = '".$arrid[0]."' AND A.KODE_SAMPEL = '".$arrid[1]."'";
			$data = $sipt->main->get_result($query);
			if($data){
				foreach($query->result_array() as $row){
					$arrdata['sess'] = $row;
				}
				$arrdata['act'] = site_url().'/post/cp/cp_act/replace-manager';
				$arrdata['lhu'] = $this->db->query("SELECT dbo.FORMAT_NOMOR('LHU',A.LHU_ID) AS UR_LHU, A.LHU_ID, A.CP_ID, A.CREATE_BY, B.NAMA_USER FROM T_LHU A LEFT JOIN T_USER B ON A.CREATE_BY = B.USER_ID WHERE A.CP_ID = '".$row['CP_ID']."'")->result_array();
				$arrdata['arrmt'] = $sipt->main->combobox("SELECT A.USER_ID, A.NAMA_USER +' - '+ A.JABATAN AS NAMA_USER FROM T_USER A LEFT JOIN T_USER_ROLE B ON A.USER_ID = B.USER_ID WHERE B.ROLE = '4' AND B.JENIS_PELAPORAN = '02' AND A.BBPOM_ID = '".$row['BBPOM_ID']."' AND A.STATUS = 'Aktif' GROUP BY A.USER_ID, A.NAMA_USER, A.JABATAN ORDER BY 2 ASC", "USER_ID", "NAMA_USER", TRUE);
				return $arrdata;
			}
		}
	}
	
	function get_koreksi($id){
		if((in_array('2', $this->newsession->userdata('SESS_KODE_ROLE'))  || in_array('3', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('4', $this->newsession->userdata('SESS_KODE_ROLE'))) && in_array('02', $this->newsession->userdata('SESS_JENIS_PELAPORAN')) && $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$query = "SELECT UJI_ID, SPK_ID, KODE_SAMPEL, dbo.FORMAT_NOMOR('SPL', KODE_SAMPEL) AS KODE, KODE_SAMPEL, PARAMETER_UJI, METODE, PUSTAKA, SYARAT, RUANG_LINGKUP, JENIS_UJI, JUMLAH_UJI, SISA_UJI, REAGEN, JUMLAH_REAGEN, HASIL, HASIL_KUALITATIF, RTRIM(LTRIM(HASIL_PARAMETER)) AS HASIL_PARAMETER, CATATAN, CONVERT(VARCHAR(10), AWAL_UJI, 103) AS AWAL_UJI, CONVERT(VARCHAR(10), AKHIR_UJI, 103) AS AKHIR_UJI, LCP, STATUS, PENGUJI FROM T_PARAMETER_HASIL_UJI WHERE UJI_ID = '".$id."'";
			$data = $sipt->main->get_result($query);
			if($data){
				foreach($query->result_array() as $row){
					$arrdata['sess'] = $row;
				}
				$arrdata['hasil'] = $sipt->main->combobox("SELECT KODE,URAIAN FROM M_TABEL WHERE JENIS = 'HASIL' AND KODE IN ('HPST','MS','TMS')", "KODE", "KODE", TRUE);
				$arrdata['act'] = site_url().'/post/cp/cp_act/koreksi-params';
				return $arrdata;
			}
		}
	}
	
	function set_cp($action, $isajax){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			if($action=="save"){
				$hasil = FALSE;
				$msgok = "Catatan Pengujian baru berhasil";
				$msgerr = "Catatan Pengujian baru gagal, Silahkan coba lagi";
				$arr_cp = $this->input->post('CP');
				$kdlama = $this->input->post('KODE_LAMA');
				$arr_cp['KODE_SAMPEL'] = $this->input->post('KODE_SAMPEL');
				$arr_cp['BBPOM_ID'] = $this->newsession->userdata('SESS_BBPOM_ID');
				$arr_cp['MT'] = $this->input->post('MT');
				$arr_cp['CREATE_BY'] = $this->newsession->userdata('SESS_USER_ID');
				//$arr_cp['CREATE_DATE'] = 'GETDATE()';
				$arr_cp['STATUS'] = '40202';
				$ko = substr($this->input->post('KODE_SAMPEL'),7,2);
				//$arr_cp['CP_ID'] =  $sipt->main->set_kode_cp($ko);
				$chk = (int)$sipt->main->get_uraian("SELECT AUTO_RESET FROM M_REF_CP WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND KOMODITI = '".$ko."'","AUTO_RESET");
				if($chk == 1)
					$arr_cp['CP_ID'] =  $sipt->main->set_kode_cp($ko, $arr_cp['CREATE_DATE']);
				else $arr_cp['CP_ID'] =  $sipt->main->set_kode_cp($ko, $arr_cp['CREATE_DATE']);
				if($this->db->insert('T_CP',$arr_cp)){
					$hasil = TRUE;
					//$sipt->main->set_max('cp',$ko);
					$arrpu = $this->input->post('PU');
					$arrkeys_pu = array_keys($arrpu);
					for($i = 0; $i < count($_POST['PU']['UJI_ID']); $i++){
						for($j=0;$j<count($arrkeys_pu);$j++){
							$arrupdatepu[$arrkeys_pu[$j]] = $arrpu[$arrkeys_pu[$j]][$i];
						}
						$this->db->where('UJI_ID', $_POST['PU']['UJI_ID'][$i]);
						$this->db->update('T_PARAMETER_HASIL_UJI', $arrupdatepu);
					}

					if(in_array('B3',$this->newsession->userdata('SESS_SUB_SARANA'))){
						$this->db->simple_query("UPDATE T_M_SAMPEL SET HASIL_MIKRO = '".$arr_cp['HASIL']."', SISA_MIKRO = '".$this->input->post('SISA')."', TEMPAT_SISA_MIKRO = '".$this->input->post('TEMPAT_SISA')."' WHERE KODE_SAMPEL = '".$this->input->post('KODE_SAMPEL')."'");	
						$this->db->simple_query("UPDATE T_PARAMETER_HASIL_UJI SET STATUS = '40202' WHERE KODE_SAMPEL = '".$this->input->post('KODE_SAMPEL')."' AND JENIS_UJI = '01' AND PENYELIA = '".$this->newsession->userdata('SESS_USER_ID')."'");
					}else{
						$this->db->simple_query("UPDATE T_PARAMETER_HASIL_UJI SET STATUS = '40202' WHERE KODE_SAMPEL = '".$this->input->post('KODE_SAMPEL')."' AND JENIS_UJI = '02' AND PENYELIA = '".$this->newsession->userdata('SESS_USER_ID')."'");
						$this->db->simple_query("UPDATE T_M_SAMPEL SET HASIL_KIMIA = '".$arr_cp['HASIL']."', SISA_KIMIA = '".$this->input->post('SISA')."', TEMPAT_SISA_KIMIA = '".$this->input->post('TEMPAT_SISA')."' WHERE KODE_SAMPEL = '".$this->input->post('KODE_SAMPEL')."'");	
					}
					
					$this->db->simple_query("UPDATE T_SPK SET STATUS = '40202' WHERE SPK_ID = '".$this->input->post('SPK_ID')."'");	
					$cek_uji = $this->db->query("SELECT UJI_KIMIA, UJI_MIKRO FROM T_M_SAMPEL WHERE KODE_SAMPEL = '".$this->input->post('KODE_SAMPEL')."'")->result_array();
					if($cek_uji[0]['UJI_KIMIA'] == 1 && $cek_uji[0]['UJI_MIKRO'] == 1){
						$jmlpu = $sipt->main->get_uraian("SELECT COUNT(JML) AS JML FROM (SELECT DISTINCT(STATUS) AS JML FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL = '".$this->input->post('KODE_SAMPEL')."') AS DATA","JML");
						if($jmlpu == 1){
							$this->db->simple_query("UPDATE T_M_SAMPEL SET STATUS_SAMPEL = '40202' WHERE KODE_SAMPEL = '".$this->input->post('KODE_SAMPEL')."'");
						}
					}else{
						$this->db->simple_query("UPDATE T_M_SAMPEL SET STATUS_SAMPEL = '40202' WHERE KODE_SAMPEL = '".$this->input->post('KODE_SAMPEL')."'");
					}
					if($kdlama!='' && $this->input->post('FILE_CAPA')!=''){
						$datacapa = array('KODE_SAMPEL' => $kdlama,
										  'SERI' => (int)$sipt->main->get_uraian("SELECT MAX(SERI) AS MAXSERI FROM T_SAMPEL_RUJUKAN_CAPA WHERE KODE_SAMPEL='".$kdlama."'","MAXSERI")+1,
										  'CAPA_FILE' => $this->input->post('FILE_CAPA'),
										  'CREATED_DATE' => 'GETDATE()',
										  'CREATED_BY' => $this->newsession->userdata('SESS_USER_ID'));
						$this->db->insert('T_SAMPEL_RUJUKAN_CAPA', $datacapa);
					}
					
					$logcp = array('CP_ID' => $arr_cp['CP_ID'],
								   'WAKTU' => 'GETDATE()',
								   'USER_ID' => $this->newsession->userdata('SESS_USER_ID'),
								   'KEGIATAN' => 'Simpan data CP : '. $arr_cp['CP_ID'],
								   'CATATAN' => $arr_cp['CATATAN']);
					$this->db->insert('T_CP_LOG', $logcp);
					
					$logsampel = array('KODE_SAMPEL' => $this->input->post('KODE_SAMPEL'),
								   'WAKTU' => 'GETDATE()',
								   'USER_ID' => $this->newsession->userdata('SESS_USER_ID'),
								   'KEGIATAN' => 'Verifikasi CP dengan hasil : '.$arr_cp['HASIL'],
								   'CATATAN' => $arr_cp['CATATAN']);
					$this->db->insert('T_SAMPLING_LOG', $logsampel);
				}
				if($hasil){
					return "MSG#YES#$msgok.#".site_url().'/home/pengujian/cp/list/draft';
				}else{
					return "MSG#NO#$msgerror";
				}
				if($isajax!="ajax"){
					redirect(base_url());
					exit();
				}
			}
			else if($action == "tolak"){
				$hasil = FALSE;
				$msgok = "Penolakan data pengujian berhasil dikirimkan ke penguji";
				$msgerr = "Penolakan data pengujian gagal dikirimkan ke penguji";
				$arr_cp = $this->input->post('CP');
				$arrpu = $this->input->post('PU');
				$arrkeys_pu = array_keys($arrpu);
				for($i = 0; $i < count($_POST['PU']['UJI_ID']); $i++){
					for($j=0;$j<count($arrkeys_pu);$j++){
						$arrupdatepu[$arrkeys_pu[$j]] = $arrpu[$arrkeys_pu[$j]][$i];
					}
					$this->db->where('UJI_ID', $_POST['PU']['UJI_ID'][$i]);
					if($this->db->update('T_PARAMETER_HASIL_UJI', $arrupdatepu)){
						$hasil = TRUE;
					}
				}
				if($hasil){
					$logsampel = array('KODE_SAMPEL' => $this->input->post('KODE_SAMPEL'),
									   'WAKTU' => 'GETDATE()',
									   'USER_ID' => $this->newsession->userdata('SESS_USER_ID'),
									   'KEGIATAN' => 'Penolakan Data Pengujian',
									   'CATATAN' => $arr_cp['CATATAN']);
					$this->db->insert('T_SAMPLING_LOG', $logsampel);
					return "MSG#YES#$msgok.#".site_url().'/home/pengujian/cp/list/draft';
				}else{
					return "MSG#NO#$msgerror";
				}
				if($isajax!="ajax"){
					redirect(base_url());
					exit();
				}
			}
			else if($action == "koreksi-params"){
				$hasil = FALSE;
				$msgok = "Koreksi data parameter uji hasil pengujian berhasil disimpan";
				$msgerr = "Koreksi data parameter uji hasil pengujian berhasil gagal disimpan";
				$dtparams = $sipt->main->post_to_query($this->input->post('UJI'));
				$this->db->where(array('SPK_ID' => $this->input->post('SPK_ID'),'UJI_ID' => $this->input->post('UJI_ID')));
				$res = $this->db->update('T_PARAMETER_HASIL_UJI', $dtparams);
				if($res){
					$hasil = TRUE;
				}
				if($hasil){
					return "MSG#YES#$msgok#".site_url();
				}else{
					return "MSG#YES#$msgerr";
				}
				if($isajax!="ajax"){
					redirect(base_url());
					exit();
				}
			}
			else if($action == "replace-manager"){
				print_r($_POST); die();
			}
			else if($action == "delete-cp"){
				$retcp = FALSE;
				$retlhu = FALSE;
				foreach($this->input->post('tb_chk') as $chk){
					$id = explode(".", $chk);
					$query = "SELECT CP_ID, KODE_SAMPEL, BBPOM_ID, HASIL, CATATAN, MT, PEJABAT_TANGGAL, CREATE_BY, CREATE_DATE, UPDATE_BY, LAST_UPDATE, STATUS FROM T_CP WHERE CP_ID = '".$id[0]."' AND KODE_SAMPEL = '".$id[1]."'";
					$data = $sipt->main->get_result($query);
					if($data){
						foreach($query->result_array() as $row){
							$arrdel['CP_ID'] = $row['CP_ID'];
							$arrdel['KODE_SAMPEL'] = $row['KODE_SAMPEL'];
							$arrdel['BBPOM_ID'] = $row['BBPOM_ID'];
							$arrdel['HASIL'] = $row['HASIL'];
							$arrdel['CATATAN'] = $row['CATATAN'];
							$arrdel['MT'] = $row['MT'];
							$arrdel['PEJABAT_TANGGAL'] = $row['PEJABAT_TANGGAL'];
							$arrdel['CREATE_BY'] = $row['CREATE_BY'];
							$arrdel['CREATE_DATE'] = $row['CREATE_DATE'];
							$arrdel['UPDATE_BY'] = $row['UPDATE_BY'];
							$arrdel['LAST_UPDATE'] = $row['LAST_UPDATE'];
							$arrdel['STATUS'] = $row['STATUS'];
							if($this->db->insert('T_CP_DELETE', $arrdel)){
								$this->db->where('CP_ID',$id[0]);
								$this->db->where('KODE_SAMPEL',$id[1]);
								if($this->db->delete('T_CP')){
									$retcp = TRUE;
								}
							}
						}
						if($retcp){
							$qlhu = "SELECT LHU_ID, CP_ID, CREATE_BY, CREATE_DATE FROM T_LHU WHERE CP_ID = '".$id[0]."'";
							$dlhu = $sipt->main->get_result($qlhu);
							if($dlhu){
								foreach($qlhu->result_array() as $rlhu){
									$arrdlhu['LHU_ID'] = $rlhu['LHU_ID'];
									$arrdlhu['CP_ID'] = $rlhu['CP_ID'];
									$arrdlhu['CREATE_BY'] = $rlhu['CREATE_BY'];
									$arrdlhu['CREATE_DATE'] = $rlhu['CREATE_DATE'];
									if($this->db->insert('T_LHU_DELETE', $arrdlhu)){
										$this->db->where('CP_ID', $id[0]);
										$this->db->delete('T_LHU');
										$retlhu = TRUE;
									}
								}
							}
						}
					}
				}
				if($retcp || $retlhu){
					return $ret = "MSG#CP dan LCP berhasil dibatalkan#";
				}else{
					return $ret = "MSG#CP dan LCP gagal dibatalkan";
				}
			}
		}
	}

	
}
?>