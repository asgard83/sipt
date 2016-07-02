<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR);
class Cp_act extends Model{
	function list_cp($id){
		if((in_array('3', $this->newsession->userdata('SESS_KODE_ROLE')) && in_array('02', $this->newsession->userdata('SESS_JENIS_PELAPORAN'))) && $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$this->load->library('newtable');
			if(in_array('B5',$this->newsession->userdata('SESS_SUB_SARANA'))){
				$uji = "AND A.UJI_MIKRO = '1'";
			}else{
				$uji = "AND A.UJI_KIMIA = '1'";
			}
			if($id == "draft"){
				$judul = "Draft Catatan Pengujian";
				$query = "SELECT A.KODE_SAMPEL, C.STATUS, dbo.FORMAT_NOMOR('SPL', A.KODE_SAMPEL) AS [KODE SAMPEL], A.NAMA_SAMPEL + '<div>' + A.KEMASAN + '</div><div>' + A.NOMOR_REGISTRASI + '</div>' AS [IDENTITAS SAMPEL], dbo.KATEGORI(A.KOMODITI) + '<div>' + dbo.KATEGORI(A.KATEGORI) + '</div>' AS KOMODITI FROM T_M_SAMPEL A LEFT JOIN T_SPU B ON A.SPU_ID = B.SPU_ID LEFT JOIN T_SPK C ON B.SPU_ID = C.SPU_ID WHERE C.BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND C.KASIE = '".$this->newsession->userdata('SESS_USER_ID')."' AND C.STATUS = '30202' $uji";
				$this->newtable->columns(array("A.KODE_SAMPEL", "C.STATUS", array("dbo.FORMAT_NOMOR('SPL', A.KODE_SAMPEL)",site_url()."/home/ppomn/cp/new/{KODE_SAMPEL}.{STATUS}"), "A.NAMA_SAMPEL + '<div>' + A.KEMASAN + '</div><div>' + A.NOMOR_REGISTRASI + '</div>'", "dbo.KATEGORI(A.KOMODITI) + '<div>' + dbo.KATEGORI(A.KATEGORI) + '</div>'"));
				$proses['Preview Data'] = array('GET', site_url()."/home/ppomn/cp/new", '1');
			}else{
				$judul = "Catatan Pengujian";
				$query = "SELECT A.KODE_SAMPEL, C.STATUS, dbo.FORMAT_NOMOR('SPL', A.KODE_SAMPEL) AS [KODE SAMPEL], A.NAMA_SAMPEL + '<div>' + A.KEMASAN + '</div><div>' + A.NOMOR_REGISTRASI + '</div>' AS [IDENTITAS SAMPEL], dbo.KATEGORI(A.KOMODITI) + '<div>' + dbo.KATEGORI(A.KATEGORI) + '</div>' AS KOMODITI FROM T_M_SAMPEL A LEFT JOIN T_SPU B ON A.SPU_ID = B.SPU_ID LEFT JOIN T_SPK C ON B.SPU_ID = C.SPU_ID  WHERE C.BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND C.KASIE = '".$this->newsession->userdata('SESS_USER_ID')."' AND C.STATUS NOT IN ('30202') $uji";
				$this->newtable->columns(array("A.KODE_SAMPEL", "C.STATUS","dbo.FORMAT_NOMOR('SPL', A.KODE_SAMPEL)", "A.NAMA_SAMPEL + '<div>' + A.KEMASAN + '</div><div>' + A.NOMOR_REGISTRASI + '</div>'", "dbo.KATEGORI(A.KOMODITI) + '<div>' + dbo.KATEGORI(A.KATEGORI) + '</div>'"));
				$proses['Cetak Data CP'] = array('GETNEW', site_url()."/topdf/cp/prints", '1');
		    }
			$this->newtable->hiddens(array('KODE_SAMPEL','STATUS'));
			$this->newtable->search(array(array("dbo.FORMAT_NOMOR('SPL', A.KODE_SAMPEL)", "Kode Sampel"),array("A.NAMA_SAMPEL","Nama Sampel"), array("dbo.KATEGORI(A.KOMODITI)","Komoditi")));
			$this->newtable->action(site_url()."/home/ppomn/cp/list/".$id);
			$this->newtable->width(array('KODE SAMPEL' => 75, 'IDENTITAS SAMPEL' => 300, 'KOMODITI' => 200));
			$this->newtable->cidb($this->db);
			$this->newtable->ciuri($this->uri->segment_array());
			$this->newtable->orderby(1);
			$this->newtable->sortby("ASC");
			$this->newtable->keys(array('KODE_SAMPEL','STATUS'));
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
			$arrid = explode(".",$id);
			if(in_array('B5',$this->newsession->userdata('SESS_SUB_SARANA'))){#Bidang Mikro
				$isvalid = $sipt->main->get_uraian("SELECT COUNT(JML) AS JML FROM (SELECT DISTINCT(STATUS) AS JML 
FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL = '".$arrid[0]."' AND JENIS_UJI = '01' AND PENYELIA = '".$this->newsession->userdata('SESS_USER_ID')."') AS DATA","JML");
			}else{
				$isvalid = $sipt->main->get_uraian("SELECT COUNT(JML) AS JML FROM (SELECT DISTINCT(STATUS) AS JML 
FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL = '".$arrid[0]."' AND JENIS_UJI = '02' AND PENYELIA = '".$this->newsession->userdata('SESS_USER_ID')."') AS DATA","JML");
			}
			if($isvalid > 1){#Jika data Hasil entri pengujian, maka draft belum bisa dibuka.
				return $this->fungsi->redirectMessage('Maaf, draft catatan pengujian belum bisa diverifikasi. Ada beberapa parameter yang belum dientri','/home/ppomn/cp/list/draft'); die();
			}
			
			
			$query = "SELECT A.NAMA_SAMPEL, A.KODE_SAMPEL, dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) AS KODE, A.TEMPAT_SAMPLING, CONVERT(VARCHAR(10), A.TANGGAL_SAMPLING, 103) AS TANGGAL_SAMPLING, A.ALAMAT_SAMPLING, A.NOMOR_REGISTRASI, A.PABRIK, A.IMPORTIR, A.KEMASAN, A.BENTUK_SEDIAAN, A.NO_BETS, dbo.KATEGORI(A.KOMODITI) AS KOMODITI, dbo.KATEGORI(A.KATEGORI) AS KATEGORI, A.KETERANGAN_ED, A.JUMLAH_KIMIA, A.JUMLAH_MIKRO, REPLACE(A.KOMPOSISI,';','<br>') AS KOMPOSISI, A.NETTO, B.NOMOR_SURAT, CONVERT(VARCHAR(10), B.TANGGAL_SURAT, 103) AS TANGGAL_SURAT, A.PEMERIAN, B.NAMA_PENGIRIM, CONVERT(VARCHAR(10), C.TANGGAL_TERIMA_TPS, 103) AS TANGGAL_TERIMA_TPS, A.LABEL, A.SEGEL, C.SPU_ID FROM T_M_SAMPEL A LEFT JOIN T_PERIKSA_SAMPEL B ON A.PERIKSA_SAMPEL = B.PERIKSA_SAMPEL LEFT JOIN T_SPU C ON A.SPU_ID = C.SPU_ID WHERE A.KODE_SAMPEL = '".$arrid[0]."'";
			$parameter = $this->db->query("SELECT SPK_ID, PARAMETER_UJI, METODE, PUSTAKA, SYARAT, RUANG_LINGKUP, HASIL, HASIL_KUALITATIF, LCP FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL = '".$arrid[0]."' AND PENYELIA = '".$this->newsession->userdata('SESS_USER_ID')."'")->result_array();
			$kabid = $this->db->query("SELECT CREATE_BY AS MT FROM T_SPK WHERE SPK_ID = '".$parameter[0]['SPK_ID']."'")->result_array();
			$penguji = $this->db->query("SELECT A.NAMA_USER FROM T_USER A LEFT JOIN T_PARAMETER_HASIL_UJI B ON A.USER_ID = B.PENGUJI WHERE B.KODE_SAMPEL = '".$arrid[0]."' AND B.PENYELIA = '".$this->newsession->userdata('SESS_USER_ID')."'")->result_array();
			$tanggaluji = $this->db->query("SELECT MIN(CONVERT(VARCHAR(10), AWAL_UJI, 103)) AS MINTGL, MAX(CONVERT(VARCHAR(10), AKHIR_UJI, 103)) AS MAXTGL FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL = '".$arrid[0]."'")->result_array();
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
									 'act' => site_url().'/post/ppomn/cp_act/save');

				}
				if(in_array('B3',$this->newsession->userdata('SESS_SUB_SARANA'))){
					$jml = "SELECT JUMLAH_UJI FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL = '".$arrid[0]."' AND JENIS_UJI = '01'";
					$jsampel = $sipt->main->get_uraian("SELECT JUMLAH_MIKRO FROM T_M_SAMPEL WHERE KODE_SAMPEL = '".$arrid[0]."'","JUMLAH_MIKRO");
				}else{
					$jml = "SELECT JUMLAH_UJI FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL = '".$arrid[0]."' AND JENIS_UJI = '02'";
					$jsampel = $sipt->main->get_uraian("SELECT JUMLAH_KIMIA FROM T_M_SAMPEL WHERE KODE_SAMPEL = '".$arrid[0]."'","JUMLAH_KIMIA");
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
			}
			$arrdata['hasil'] = $sipt->main->combobox("SELECT KODE,URAIAN FROM M_TABEL WHERE JENIS = 'HASIL' AND KODE IN ('HPST','MS','TMS')", "KODE", "URAIAN", TRUE);
			$arrdata['judul'] = "Catatan Pengujian";
			return $arrdata;
		}
	}

	function set_cp($action, $isajax){
		if((in_array('2', $this->newsession->userdata('SESS_KODE_ROLE'))  || in_array('3', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('4', $this->newsession->userdata('SESS_KODE_ROLE'))) && in_array('02', $this->newsession->userdata('SESS_JENIS_PELAPORAN')) && $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			if($action=="save"){
				$hasil = FALSE;
				$msgok = "Catatan Pengujian baru berhasil";
				$msgerr = "Catatan Pengujian baru gagal, Silahkan coba lagi";
				$arr_cp = $this->input->post('CP');
				$arr_cp['KODE_SAMPEL'] = $this->input->post('KODE_SAMPEL');
				$arr_cp['BBPOM_ID'] = $this->newsession->userdata('SESS_BBPOM_ID');
				$arr_cp['MT'] = $this->input->post('MT');
				$arr_cp['CREATE_BY'] = $this->newsession->userdata('SESS_USER_ID');
				$arr_cp['CREATE_DATE'] = 'GETDATE()';
				$arr_cp['STATUS'] = '40202';
				$ko = substr($this->input->post('KODE_SAMPEL'),7,2);
				$arr_cp['CP_ID'] =  $sipt->main->set_kode_cp($ko);
				if($this->db->insert('T_CP',$arr_cp)){
					$hasil = TRUE;
					$sipt->main->set_max('cp',$ko);
					if(in_array('B5',$this->newsession->userdata('SESS_SUB_SARANA'))){
						$this->db->simple_query("UPDATE T_M_SAMPEL SET HASIL_MIKRO = '".$arr_cp['HASIL']."', SISA_MIKRO = '".$this->input->post('SISA')."', TEMPAT_SISA_MIKRO = '".$this->input->post('TEMPAT_SISA')."' WHERE KODE_SAMPEL = '".$this->input->post('KODE_SAMPEL')."'");	
						$this->db->simple_query("UPDATE T_PARAMETER_HASIL_UJI SET STATUS = '40202' WHERE KODE_SAMPEL = '".$this->input->post('KODE_SAMPEL')."' AND JENIS_UJI = '01' AND PENYELIA = '".$this->newsession->userdata('SESS_USER_ID')."'");
					}else{
						$this->db->simple_query("UPDATE T_PARAMETER_HASIL_UJI SET STATUS = '40202' WHERE KODE_SAMPEL = '".$this->input->post('KODE_SAMPEL')."' AND JENIS_UJI = '02' AND PENYELIA = '".$this->newsession->userdata('SESS_USER_ID')."'");
						$this->db->simple_query("UPDATE T_M_SAMPEL SET HASIL_KIMIA = '".$arr_cp['HASIL']."', SISA_KIMIA = '".$this->input->post('SISA')."', TEMPAT_SISA_KIMIA = '".$this->input->post('TEMPAT_SISA')."' WHERE KODE_SAMPEL = '".$this->input->post('KODE_SAMPEL')."'");	
					}
					$this->db->simple_query("UPDATE T_SPK SET STATUS = '40202' WHERE SPK_ID = '".$this->input->post('SPK_ID')."'");	
					
					$jml_spu = (int)$sipt->main->get_uraian("SELECT JML_SPU FROM T_SPU WHERE SPU_ID = '".$this->input->post('SPU_ID')."'","JML_SPU");
					$jml_sp_spu = (int)$sipt->main->get_uraian("SELECT COUNT(*) AS JML FROM T_SPK WHERE SPU_ID = '".$this->input->post('SPU_ID')."'","JML");
					if($jml_spu == $jml_sp_spu){
						$this->db->simple_query("UPDATE T_SPU SET STATUS = '40202' WHERE SPU_ID = '".$this->input->post('SPU_ID')."'");
						$this->db->simple_query("UPDATE T_M_SAMPEL SET STATUS_SAMPEL = '40202' WHERE KODE_SAMPEL = '".$this->input->post('KODE_SAMPEL')."'");
					}
					
					$logcp = array('CP_ID' => $arr_cp['CP_ID'],
								   'WAKTU' => 'GETDATE()',
								   'USER_ID' => $this->newsession->userdata('SESS_USER_ID'),
								   'KEGIATAN' => 'Simpan data CP : '. $arr_cp['CP_ID'],
								   'CATATAN' => $arr_cp['CATATAN']);
					$this->db->insert('T_CP_LOG', $logcp);
				}
				if($hasil){
					return "MSG#YES#$msgok.#".site_url().'/home/ppomn/cp/list/draft';
				}else{
					return "MSG#NO#$msgerror";
				}
				if($isajax!="ajax"){
					redirect(base_url());
					exit();
				}
			}
			
		}
	}

	
}
?>