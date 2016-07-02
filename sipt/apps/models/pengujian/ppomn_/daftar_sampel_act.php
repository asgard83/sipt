<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR);
class Daftar_sampel_act extends Model{
	function list_sampel($tipe,$status){
		if($this->newsession->userdata('LOGGED_IN')){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$this->load->library('newtable');
			$query = "SELECT A.KODE_SAMPEL, A.NAMA_SAMPEL + '<div>' + dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) + '</div>' AS [SAMPEL],
					  REPLACE(REPLACE(B.NAMA_BBPOM,'BALAI BESAR POM DI', ''),'BALAI POM DI','') AS [BPOM], dbo.KATEGORI(A.KATEGORI) AS KATEGORI, CASE WHEN A.UJI_KIMIA = '1' AND A.UJI_MIKRO = '1' THEN 'Uji Kimia - Mikro' WHEN A.UJI_KIMIA = '1' THEN 'Uji Kimia' WHEN A.UJI_MIKRO = '1' THEN 'Uji Mikro' END AS [JENIS UJI], A.HASIL_SAMPEL + '<div> K : ' + CASE WHEN A.HASIL_KIMIA <> '' THEN A.HASIL_KIMIA ELSE '-' END + ', M : ' + CASE WHEN A.HASIL_MIKRO <> '' THEN A.HASIL_MIKRO ELSE '-' END+ '</div>' AS HASIL, A.STATUS FROM T_M_SAMPEL_RILIS A LEFT JOIN M_BBPOM B ON A.BBPOM_ID = B.BBPOM_ID ";
			if($tipe == "int"){
				$judul = "Data Hasil Uji Sampel TMS";
				$query .= " WHERE A.STATUS = '80215' AND A.ANGGARAN NOT IN ('05','06','07') AND A.ARSIP_SAMPEL = '0'";
			}else if($tipe == "ext"){
				$judul = "Data Hasil Non Rutin";
				$query .= " WHERE A.STATUS = '80215' AND A.ANGGARAN IN ('05','06','07') AND A.BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'";
			}else if($tipe == "absah"){
				$judul = "Data Hasil Pengujian Yang Diuji Absah";
				$query .= " WHERE A.TINDAK_LANJUT_PPOMN = '9901'";
			}else if($tipe == "respon"){
				$judul = "Data Hasil Pengujian Yang Ditanggapi";
				$query .= " WHERE A.TINDAK_LANJUT_PPOMN = '9902'";
			}else if($tipe == "arsip"){
				$judul = "Arsip Data Hasil Uji Sampel Memenuhi Syarat";
				$query .= " WHERE A.ANGGARAN NOT IN ('05','06','07') AND A.ARSIP_SAMPEL = '1'";
			}
			$this->newtable->hiddens(array('KODE_SAMPEL','STATUS'));
			$this->newtable->search(array(array("NAMA_SAMPEL","Nama Sampel"),array("dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL)","Kode Sampel"),array("dbo.KATEGORI(A.KOMODITI)","Komoditi"),array("dbo.KATEGORI(A.KATEGORI)","Kategori"), array("B.NAMA_BBPOM", "Balai Besar / Balai POM")));
			$this->newtable->columns(array("A.KODE_SAMPEL", array("A.NAMA_SAMPEL + '<div>' + dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) + '</div>'",site_url().'/home/ppomn/preview/sampel/{KODE_SAMPEL}.{STATUS}'),"REPLACE(REPLACE(B.NAMA_BBPOM,'BALAI BESAR POM DI', ''),'BALAI POM DI','')", "dbo.KATEGORI(A.KATEGORI)", "CASE WHEN A.UJI_KIMIA = '1' AND A.UJI_MIKRO = '1' THEN 'Uji Kimia - Mikro' WHEN A.UJI_KIMIA = '1' THEN 'Uji Kimia' WHEN A.UJI_MIKRO = '1' THEN 'Uji Mikro' END", "A.HASIL_SAMPEL + '<div> K : ' + CASE WHEN A.HASIL_KIMIA <> '' THEN A.HASIL_KIMIA ELSE '-' END + ', M : ' + CASE WHEN A.HASIL_MIKRO <> '' THEN A.HASIL_MIKRO ELSE '-' END + '</div>'","A.STATUS"));
			$this->newtable->action(site_url()."/home/ppomn/laporan/".$tipe);
			$this->newtable->width(array('SAMPEL' => 200, 'BPOM' => 85, 'KATEGORI' => 250, 'JENIS UJI' => 75, 'HASIL' => 100));
			$this->newtable->cidb($this->db);
			$this->newtable->ciuri($this->uri->segment_array());
			$this->newtable->sortby("ASC");
			$this->newtable->keys(array('KODE_SAMPEL','STATUS'));
			$this->newtable->orderby(1);
			$proses['Preview Data'] = array('GET', site_url().'/home/ppomn/preview/sampel', '1');
			$this->newtable->menu($proses);
			$arrdata = array('table' => $this->newtable->generate($query),
							 'idjudul' => 'judulmsampel',
							 'caption_header' => $judul,
							 'batal' => '',
							 'cancel' => '');
			return $arrdata;
			
		}
	}
	
	function get_sampel($id){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$arrid = explode(".",$id);
			$query = "SELECT A.NAMA_SAMPEL, A.KODE_SAMPEL, dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) AS KODE, dbo.FORMAT_NOMOR('SPU',C.SPU_ID) AS SPU, A.TEMPAT_SAMPLING, CONVERT(VARCHAR(10), A.TANGGAL_SAMPLING, 103) AS TANGGAL_SAMPLING, A.ALAMAT_SAMPLING, A.NOMOR_REGISTRASI, A.PABRIK, A.IMPORTIR, A.KEMASAN, A.BENTUK_SEDIAAN, A.NO_BETS, A.SATUAN, dbo.KATEGORI(A.KOMODITI) AS KOMODITI, dbo.KATEGORI(A.KATEGORI) AS KATEGORI, A.KETERANGAN_ED, A.JUMLAH_KIMIA, A.JUMLAH_MIKRO, REPLACE(A.KOMPOSISI,';','<br>') AS KOMPOSISI, A.NETTO, B.NOMOR_SURAT, CONVERT(VARCHAR(10), B.TANGGAL_SURAT, 103) AS TANGGAL_SURAT, B.NAMA_PENGIRIM, CONVERT(VARCHAR(10), C.TANGGAL_TERIMA_TPS, 103) AS TANGGAL_TERIMA_TPS, CONVERT(VARCHAR(10), C.TANGGAL, 103) AS TANGGAL_SPU, A.PEMERIAN, A.UJI_MIKRO, A.UJI_KIMIA, A.JUMLAH_KIMIA, A.JUMLAH_MIKRO, A.HASIL_KIMIA, A.HASIL_MIKRO, A.HASIL_SAMPEL, D.STATUS FROM T_M_SAMPEL A LEFT JOIN T_PERIKSA_SAMPEL B ON A.PERIKSA_SAMPEL = B.PERIKSA_SAMPEL LEFT JOIN T_SPU C ON A.SPU_ID = C.SPU_ID LEFT JOIN T_M_SAMPEL_RILIS D ON A.KODE_SAMPEL = D.KODE_SAMPEL WHERE A.KODE_SAMPEL = '".$arrid[0]."'";
			$tanggaluji = $this->db->query("SELECT MIN(CONVERT(VARCHAR(10), AWAL_UJI, 103)) AS MINTGL, MAX(CONVERT(VARCHAR(10), AKHIR_UJI, 103)) AS MAXTGL FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL = '".$arrid[0]."'")->result_array();
			$data = $sipt->main->get_result($query);
			if($data){
				foreach($query->result_array() as $row){
					$arrdata = array('sess' => $row,
									 'tanggaluji' => $tanggaluji);

				}
				$arrdata['act'] = site_url().'/post/ppomn/hasil_act/rilis-absah';
				$arrdata['jml_log'] = $sipt->main->get_uraian("SELECT COUNT(*) AS JML FROM T_SAMPLING_LOG WHERE KODE_SAMPEL ='".$arrid[0]."'","JML");
				if((in_array('7',$this->newsession->userdata('SESS_KODE_ROLE')) || in_array('9',$this->newsession->userdata('SESS_KODE_ROLE'))) && $this->newsession->userdata('SESS_BBPOM_ID') == "99" && $row['STATUS'] == "80215"){
					$cekhasil = $sipt->main->get_uraian("SELECT RTRIM(LTRIM(HASIL_SAMPEL)) AS HASIL_SAMPEL FROM T_M_SAMPEL_RILIS WHERE KODE_SAMPEL = '".$arrid[0]."'","HASIL_SAMPEL");
					$arrboleh = array("TMS");
					if(in_array($cekhasil, $arrboleh)) $arrdata['boleh'] = TRUE;
					else $arrdata['boleh'] = FALSE;
					$arrdata['input'] = $this->get_input($arrid[0], $row['STATUS']);
				}else{
					$arrdata['boleh'] = FALSE;
					$arrdata['input'] = "";
				}
			}
			$arrdata['hasil'] = $sipt->main->combobox("SELECT KODE,URAIAN FROM M_TABEL WHERE JENIS = 'HASIL' AND KODE IN ('MS','TMS')", "KODE", "URAIAN", TRUE);
			$arrdata['parameter'] = $this->db->query("SELECT CASE WHEN JENIS_UJI = '01' THEN 'Mikrobiologi' WHEN JENIS_UJI = '02' THEN 'Kimia - Fisika' END AS JENIS_UJI, SPK_ID,PARAMETER_UJI, METODE, PUSTAKA, SYARAT, RUANG_LINGKUP, HASIL, HASIL_KUALITATIF, LCP, HASIL_PARAMETER FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL = '".$arrid[0]."'")->result_array();
			return $arrdata;
		}
	}
	
	function get_input($kodesampel, $status){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$sipt->load->model("main","main", true);
			$data = "";
			$arrdata = array();
			$arrdata['row'] = $this->db->query("SELECT * FROM T_M_SAMPEL_RILIS WHERE KODE_SAMPEL = '".$kodesampel."'")->result_array();
			$arrstts = array('80215');
			if(in_array($status, $arrstts)){
				$arrdata['tindak_lanjut_ppomn'] = $sipt->main->combobox("SELECT KODE, URAIAN FROM M_TL_SAMPEL WHERE FLAG = 'Y' AND KODE NOT IN ('9999')","KODE","URAIAN", TRUE);
				$data = $this->load->view('pengujian/ppomn/input/80215', $arrdata, true);
			}else{
				$data = "";
			}
		}
		return $data;
	}
	
	
	function set_rilis($action, $isajax){
		if(in_array('7',$this->newsession->userdata('SESS_KODE_ROLE')) && $this->newsession->userdata('LOGGED_IN') == TRUE ){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			if($action == "rilis-absah"){
				$msgok = "Proses sampel berhasil";
				$msgerr = "Proses sampel gagal, Silahkan coba lagi";
				if($this->input->post('HASIL_PPOMN') == "MS"){
					$res = $this->db->simple_query("SET DATEFORMAT DMY UPDATE T_M_SAMPEL_RILIS SET HASIL_PPOMN = '".$this->input->post('HASIL_PPOMN')."', STATUS_PPOMN = '1', STATUS_WASDIS = '1', ARSIP_SAMPEL = '1', STATUS = '20210', LAST_UPDATE = GETDATE(), UPDATE_BY = '".$this->newsession->userdata('SESS_USER_ID')."' WHERE KODE_SAMPEL = '".$this->input->post('KODE_SAMPEL')."'");	
				}else{
					if($this->input->post('TINDAK_LANJUT_PPOMN') == '9903'){
						$res = $this->db->simple_query("UPDATE T_M_SAMPEL_RILIS SET HASIL_PPOMN = '".$this->input->post('HASIL_PPOMN')."', STATUS_PPOMN = '1', STATUS = '20210', ARSIP_SAMPEL = '1', TINDAK_LANJUT_PPOMN = '".$this->input->post('TINDAK_LANJUT_PPOMN')."', LAST_UPDATE = GETDATE(), UPDATE_BY = '".$this->newsession->userdata('SESS_USER_ID')."' WHERE KODE_SAMPEL = '".$this->input->post('KODE_SAMPEL')."'");	
					}else{
						if($this->input->post('TINDAK_LANJUT_PPOMN') == '9901'){#UjiAbsah
							$stts = '11901';
						}else if($this->input->post('TINDAK_LANJUT_PPOMN') == '9902'){#Ditanggapi
							$stts = '11902';
						}
						$res = $this->db->simple_query("UPDATE T_M_SAMPEL_RILIS SET HASIL_PPOMN = '".$this->input->post('HASIL_PPOMN')."', STATUS_PPOMN = '1', STATUS = '".$stts."', ARSIP_SAMPEL = '0', TINDAK_LANJUT_PPOMN = '".$this->input->post('TINDAK_LANJUT_PPOMN')."', LAST_UPDATE = GETDATE(), UPDATE_BY = '".$this->newsession->userdata('SESS_USER_ID')."' WHERE KODE_SAMPEL = '".$this->input->post('KODE_SAMPEL')."'");	
					}
					
				}
				if($res){
					if($this->input->post('TINDAK_LANJUT_PPOMN') == '9903'){
						$this->db->simple_query("UPDATE T_M_SAMPEL SET STATUS_SAMPEL = '20210' WHERE KODE_SAMPEL = '".$this->input->post('KODE_SAMPEL')."'");
					}else{
						if($this->input->post('TINDAK_LANJUT_PPOMN') == '9901'){#UjiAbsah
							$sttsx = '11901';
						}else if($this->input->post('TINDAK_LANJUT_PPOMN') == '9902'){#Ditanggapi
							$sttsx = '11902';
						}
						$this->db->simple_query("UPDATE T_M_SAMPEL SET STATUS_SAMPEL = '".$sttsx."' WHERE KODE_SAMPEL = '".$this->input->post('KODE_SAMPEL')."'");
					}
					$data = array('KODE_SAMPEL' => $this->input->post('KODE_SAMPEL'),
								  'WAKTU' => 'GETDATE()',
								  'USER_ID' => $this->newsession->userdata('SESS_USER_ID'),
								  'KEGIATAN' => $this->input->post('CATATAN'),
								  'CATATAN' => '-');
					$this->db->insert('T_SAMPLING_LOG', $data);
					return "MSG#YES#$msgok#".site_url().'/home/ppomn/laporan/int';
				}else{
					return "MSG#NO#$msgerr";
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