<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR);
class Daftar_sampel_act extends Model{
	function list_sampel($tipe,$status){
		if($this->newsession->userdata('LOGGED_IN') && $this->newsession->userdata('SESS_BBPOM_ID') == "99"){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$this->load->library('newtable');
			$query = "SELECT A.KODE_SAMPEL, A.NAMA_SAMPEL + '<div>' + dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) + '</div>' AS [SAMPEL],
					  REPLACE(REPLACE(B.NAMA_BBPOM,'BALAI BESAR POM DI', ''),'BALAI POM DI','') AS [BPOM], dbo.KATEGORI(A.KATEGORI,A.PRIORITAS) AS KATEGORI, CASE WHEN A.UJI_KIMIA = '1' AND A.UJI_MIKRO = '1' THEN 'Uji Kimia - Mikro' WHEN A.UJI_KIMIA = '1' THEN 'Uji Kimia' WHEN A.UJI_MIKRO = '1' THEN 'Uji Mikro' END AS [JENIS UJI], A.HASIL_SAMPEL + '<div> K : ' + CASE WHEN A.HASIL_KIMIA <> '' THEN A.HASIL_KIMIA ELSE '-' END + ', M : ' + CASE WHEN A.HASIL_MIKRO <> '' THEN A.HASIL_MIKRO ELSE '-' END+ '</div>' AS HASIL, CASE WHEN A.UJI_RUJUK = 1  THEN 'Uji Rujuk' WHEN A.UJI_UNGGULAN = 1 THEN 'Uji Unggulan' ELSE 'Rutin' END AS [TIPE UJI], A.STATUS FROM T_M_SAMPEL_RILIS A LEFT JOIN M_BBPOM B ON A.BBPOM_ID = B.BBPOM_ID ";
			if(in_array('4', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('11', $this->newsession->userdata('SESS_KODE_ROLE'))){
				foreach($this->newsession->userdata('SESS_KLASIFIKASI_ID') as $a){
					$tmp  .= "'".substr($a,-2). "',";
				}
				$komoditi = substr($tmp,0,-1);
				$query .= $sipt->main->find_where($query);
				$query .= " A.KOMODITI IN (".$komoditi.")";
			}
			
			if($tipe == "ms"){
				$judul = "Data Hasil Uji Sampel MS";
				$query .= $sipt->main->find_where($query);
				$query .= " RTRIM(LTRIM(A.HASIL_SAMPEL)) = 'MS' AND A.STATUS_KIRIM = '1'";
			}else if($tipe == "hpst"){
				$judul = "Data Hasil Uji Sampel HPST";
				$query .= $sipt->main->find_where($query);
				$query .= " RTRIM(LTRIM(A.HASIL_SAMPEL)) = 'HPST' AND A.STATUS_KIRIM = '1' AND A.STATUS = '80215' AND A.MONEV_PPOMN = '1'";
			}else if($tipe == "tms"){
				$judul = "Data Hasil Uji Sampel TMS";
				$query .= $sipt->main->find_where($query);
				#if(in_array('4', $this->newsession->userdata('SESS_KODE_ROLE'))){
					#$query .= " RTRIM(LTRIM(A.HASIL_SAMPEL)) = 'TMS' AND A.STATUS_KIRIM = '1' AND A.STATUS = '40290'";
				#}else if(in_array('7', $this->newsession->userdata('SESS_KODE_ROLE'))){
					$query .= " RTRIM(LTRIM(A.HASIL_SAMPEL)) = 'TMS' AND A.STATUS_KIRIM = '1' AND A.STATUS = '80215' AND A.MONEV_PPOMN = '1'";
				#}else if(in_array('11', $this->newsession->userdata('SESS_KODE_ROLE'))){
					#$query .= " RTRIM(LTRIM(A.HASIL_SAMPEL)) = 'TMS' AND A.STATUS_KIRIM = '1' AND A.STATUS = '11902'";
				#}
			}else if($tipe == "absah"){
				$judul = "Data Hasil Pengujian Yang Diuji Absah";
				$query .= $sipt->main->find_where($query);
				$query .= " A.TINDAK_LANJUT_PPOMN = '9901'";
			}else if($tipe == "respon"){
				$judul = "Data Hasil Pengujian Yang Ditanggapi";
				if(in_array('4', $this->newsession->userdata('SESS_KODE_ROLE'))){
					$query .= $sipt->main->find_where($query);
					$query .= " A.STATUS = '40290'";
				}else if(in_array('11', $this->newsession->userdata('SESS_KODE_ROLE'))){
					$query .= $sipt->main->find_where($query);
					$query .= " A.STATUS = '11902'"; 
				}else{
					$query .= $sipt->main->find_where($query);
					$query .= " A.TINDAK_LANJUT_PPOMN = '9902'";
				}
			}else if($tipe == "arsip"){
				$judul = "Arsip Data Hasil Uji Sampel Memenuhi Syarat";
				$query .= $sipt->main->find_where($query);
				$query .= " A.ARSIP_SAMPEL = '1'";
			}else if($tipe == "monev"){
				$judul = "Sampel Dalam Proses Evaluasi dan Monitoring PPOMN";
				$query .= $sipt->main->find_where($query);
				$query .= " A.MONEV_PPOMN = '2'";
			}else if($tipe == "insert"){
				$judul = "Sampel Selesai Evaluasi dan Monitoring PPOMN";
				$query .= $sipt->main->find_where($query);
				$query .= " A.MONEV_PPOMN = '3'";
			} 
			$this->newtable->hiddens(array('KODE_SAMPEL','STATUS'));
			$this->newtable->search(array(array("NAMA_SAMPEL","Nama Sampel"),array("dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL)","Kode Sampel"),array("dbo.KATEGORI(A.KOMODITI,A.PRIORITAS)","Komoditi"),array("dbo.KATEGORI(A.KATEGORI,A.PRIORITAS)","Kategori"), array("B.NAMA_BBPOM", "Balai Besar / Balai POM"), array("CASE WHEN A.UJI_RUJUK = 1 THEN 'Uji Rujuk' WHEN A.UJI_UNGGULAN = 1 THEN 'Uji Unggulan' ELSE 'Rutin' END", "Tipe Uji")));
			$this->newtable->columns(array("A.KODE_SAMPEL", array("A.NAMA_SAMPEL + '<div>' + dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) + '</div>'",site_url().'/home/ppomn/preview/sampel/{KODE_SAMPEL}.{STATUS}'),"REPLACE(REPLACE(B.NAMA_BBPOM,'BALAI BESAR POM DI', ''),'BALAI POM DI','')", "dbo.KATEGORI(A.KATEGORI,A.PRIORITAS)", "CASE WHEN A.UJI_KIMIA = '1' AND A.UJI_MIKRO = '1' THEN 'Uji Kimia - Mikro' WHEN A.UJI_KIMIA = '1' THEN 'Uji Kimia' WHEN A.UJI_MIKRO = '1' THEN 'Uji Mikro' END", "A.HASIL_SAMPEL + '<div> K : ' + CASE WHEN A.HASIL_KIMIA <> '' THEN A.HASIL_KIMIA ELSE '-' END + ', M : ' + CASE WHEN A.HASIL_MIKRO <> '' THEN A.HASIL_MIKRO ELSE '-' END + '</div>'","CASE WHEN A.UJI_RUJUK = 1  THEN 'Uji Rujuk' WHEN A.UJI_UNGGULAN = 1 THEN 'Uji Unggulan' ELSE 'Rutin' END","A.STATUS"));
			$this->newtable->action(site_url()."/home/ppomn/laporan/".$tipe);
			$this->newtable->width(array('SAMPEL' => 200, 'BPOM' => 85, 'KATEGORI' => 250, 'JENIS UJI' => 75, 'HASIL' => 100, 'TIPE UJI' => 75));
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
			$query = "SELECT A.NAMA_SAMPEL, A.KODE_SAMPEL, dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) AS KODE, dbo.FORMAT_NOMOR('SPU',C.SPU_ID) AS SPU, A.TEMPAT_SAMPLING, CONVERT(VARCHAR(10), A.TANGGAL_SAMPLING, 103) AS TANGGAL_SAMPLING, A.ALAMAT_SAMPLING, A.NOMOR_REGISTRASI, A.PABRIK, A.IMPORTIR, A.KEMASAN, A.BENTUK_SEDIAAN, A.NO_BETS, A.SATUAN, dbo.KATEGORI(A.KOMODITI,A.PRIORITAS) AS KOMODITI, dbo.KATEGORI(A.KATEGORI,A.PRIORITAS) AS KATEGORI, A.KETERANGAN_ED, A.JUMLAH_KIMIA, A.JUMLAH_MIKRO, REPLACE(A.KOMPOSISI,';','<br>') AS KOMPOSISI, A.NETTO, B.NOMOR_SURAT, B.BBPOM_ID, CONVERT(VARCHAR(10), B.TANGGAL_SURAT, 103) AS TANGGAL_SURAT, B.NAMA_PENGIRIM, CONVERT(VARCHAR(10), C.TANGGAL_TERIMA_TPS, 103) AS TANGGAL_TERIMA_TPS, CONVERT(VARCHAR(10), C.TANGGAL, 103) AS TANGGAL_SPU, A.PEMERIAN, A.UJI_MIKRO, A.UJI_KIMIA, A.JUMLAH_KIMIA, A.JUMLAH_MIKRO, A.HASIL_KIMIA, A.HASIL_MIKRO, RTRIM(LTRIM(A.HASIL_SAMPEL)) AS HASIL_SAMPEL, RTRIM(LTRIM(D.STATUS)) AS STATUS, A.LAMPIRAN, RTRIM(LTRIM(D.HASIL_PPOMN)) AS HASIL_PPOMN, D.TINDAK_LANJUT_PPOMN, D.MONEV_PPOMN, D.MONEV_BY, A.UJI_RUJUK FROM T_M_SAMPEL A LEFT JOIN T_PERIKSA_SAMPEL B ON A.PERIKSA_SAMPEL = B.PERIKSA_SAMPEL LEFT JOIN T_SPU C ON A.SPU_ID = C.SPU_ID LEFT JOIN T_M_SAMPEL_RILIS D ON A.KODE_SAMPEL = D.KODE_SAMPEL WHERE A.KODE_SAMPEL = '".$arrid[0]."'";
			$tanggaluji = $this->db->query("SELECT MIN(CONVERT(VARCHAR(10), AWAL_UJI, 103)) AS MINTGL, MAX(CONVERT(VARCHAR(10), AKHIR_UJI, 103)) AS MAXTGL FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL = '".$arrid[0]."'")->result_array();
			$data = $sipt->main->get_result($query);
			if($data){
				foreach($query->result_array() as $row){
					$arrdata = array('sess' => $row,
									 'tanggaluji' => $tanggaluji);

				}
				if(in_array('7',$this->newsession->userdata('SESS_KODE_ROLE')) && $row['MONEV_PPOMN'] == '1'){
					$arrdata['act'] = site_url().'/post/ppomn/hasil_act/proses-monev';
					$arrdata['monev'] = array('' => '', '2' => 'Monitoring dan Evaluasi');
				}
				if(in_array('7',$this->newsession->userdata('SESS_KODE_ROLE')) && $row['MONEV_PPOMN'] == '2'){
					$arrdata['act'] = site_url().'/post/ppomn/hasil_act/proses-insert';
					$arrdata['monev'] = array('' => '', '3' => 'Kirim hasil evaluasi PPOMN ke Ditwas / Insert');
				}
				$arrdata['jml_log'] = $sipt->main->get_uraian("SELECT COUNT(*) AS JML FROM T_SAMPLING_LOG WHERE KODE_SAMPEL ='".$arrid[0]."'","JML");
				$arrdata['input'] = $this->get_input($arrid[0], $row['STATUS']);
				
				$arrdata['file'] = base_url().'files/sampel/'.md5(trim($row['BBPOM_ID'])).'/'.$row['LAMPIRAN'];
			}
			$arrdata['hasil'] = $sipt->main->combobox("SELECT KODE,URAIAN FROM M_TABEL WHERE JENIS = 'HASIL' AND KODE IN ('MS','TMS','TSPK','HPST')", "KODE", "URAIAN", TRUE);
			$arrdata['parameter'] = $this->db->query("SELECT CASE WHEN JENIS_UJI = '01' THEN 'Mikrobiologi' WHEN JENIS_UJI = '02' THEN 'Kimia - Fisika' END AS JENIS_UJI, SPK_ID,PARAMETER_UJI, METODE, PUSTAKA, SYARAT, RUANG_LINGKUP, HASIL, HASIL_KUALITATIF, LCP, HASIL_PARAMETER FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL = '".$arrid[0]."'")->result_array();
			/**
			 * Parameter Uji Rujukan
			 */
			if((int)$row['UJI_RUJUK'] == 1){
				$sKode_Sampel_Rujukan = $sipt->main->get_uraian("SELECT KODE_SAMPEL FROM T_M_SAMPEL WHERE KODE_RUJUKAN = '".$arrid[0]."'","KODE_SAMPEL");
				$sql_rujukan = "SELECT dbo.FORMAT_NOMOR('SPL', A.KODE_SAMPEL) AS UR_KODE_SAMPEL_RUJUKAN, A.HASIL_KIMIA,
								A.HASIL_MIKRO, RTRIM(LTRIM(A.HASIL_SAMPEL)) AS HASIL_SAMPEL, C.NAMA_BBPOM AS BALAI_TUJUAN,
								A.UJI_KIMIA, A.UJI_MIKRO
								FROM T_M_SAMPEL A
								LEFT JOIN T_SAMPEL_RUJUKAN B ON A.KODE_RUJUKAN = B.KODE_SAMPEL
								LEFT JOIN M_BBPOM C ON C.BBPOM_ID = B.BBPOM_RUJUK
								WHERE A.KODE_RUJUKAN = '".$arrid[0]."'";
				$obj_sql_rujukan = $sipt->main->get_result($sql_rujukan);
				if($obj_sql_rujukan) 
				{
					foreach($sql_rujukan->result_array() as $row_rujukan)
					{
						$arrdata['sess_rujukan'] = $row_rujukan;
					}
				}
				$arrdata['parameter_rujukan'] = $this->db->query("SELECT CASE WHEN JENIS_UJI = '01' THEN 'Mikrobiologi' WHEN JENIS_UJI = '02' THEN 'Kimia - Fisika' END AS JENIS_UJI, SPK_ID,PARAMETER_UJI, METODE, PUSTAKA, SYARAT, RUANG_LINGKUP, HASIL, HASIL_KUALITATIF, LCP, HASIL_PARAMETER, KODE_SAMPEL FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL = '".$sKode_Sampel_Rujukan."'")->result_array();
			}
			/**
			 * End Parameter Uji Rujukan
			 */

			$arrdata['proses'] = $sipt->main->set_verifikasi($row['STATUS'], $this->newsession->userdata('SESS_JENIS_PELAPORAN'), $this->newsession->userdata('SESS_KODE_ROLE'));
			$arrdata['disproses'] = $row['STATUS'];
			$arrdata['jml_log'] = $sipt->main->get_uraian("SELECT COUNT(*) AS JML FROM T_SAMPLING_LOG WHERE KODE_SAMPEL = '".$arrid[0]."'","JML");
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
			$arrstts = array('80215','11902','40290');
			if(in_array($status, $arrstts)){
				$arrdata['tindak_lanjut_ppomn'] = $sipt->main->combobox("SELECT KODE, URAIAN FROM M_TL_SAMPEL WHERE FLAG = 'Y' AND KODE NOT IN ('9999','9901')","KODE","URAIAN", TRUE);
				$data = $this->load->view('pengujian/ppomn/input/'.$status, $arrdata, true);
			}else{
				$data = "";
			}
		}
		return $data;
	}
	
	function set_rilis($action, $isajax){
		if((in_array('4',$this->newsession->userdata('SESS_KODE_ROLE')) || in_array('7',$this->newsession->userdata('SESS_KODE_ROLE')) || in_array('11',$this->newsession->userdata('SESS_KODE_ROLE'))) && ($this->newsession->userdata('LOGGED_IN') == TRUE && $this->newsession->userdata('SESS_BBPOM_ID') == "99")){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			if($action == "proses-monev"){
				$msgok = "Sampel berhasil disimpan dalam proses monitoring dan evaluasi";
				$msgerr = "Sampel gagal disimpan dalam proses monitoring dan evaluasi";
				$arr = array('MONEV_PPOMN' => $this->input->post('MONEV_PPOMN'),
							 'MONEV_BY' => $this->newsession->userdata('SESS_USER_ID'),
							 'MONEV_DATE' => 'GETDATE()');
				$this->db->where('KODE_SAMPEL', $this->input->post('KODE_SAMPEL'));
				$this->db->update('T_M_SAMPEL_RILIS', $arr);
				if($this->db->affected_rows() > 0){
					$data = array('KODE_SAMPEL' => $this->input->post('KODE_SAMPEL'),
								  'WAKTU' => 'GETDATE()',
								  'USER_ID' => $this->newsession->userdata('SESS_USER_ID'),
								  'KEGIATAN' => 'Proses monitoring dan evaluasi Sampel di PPOMN',
								  'CATATAN' => $this->input->post('catatan'));
					$this->db->insert('T_SAMPLING_LOG', $data);
					return "MSG#YES#$msgok#".site_url().'/home/ppomn/laporan/tms';
				}else{
					return "MSG#NO#$msgerr";
				}
				if($isajax!="ajax"){
					redirect(base_url());
					exit();
				}
			}else if($action == "proses-insert"){
				$msgok = "Sampel berhasil dikirim ke Ditwas / Insert sebagai bahan tindak lanjut";
				$msgerr = "Sampel gagal dikirim ke Ditwas / Insert";
				if($this->input->post('TEMBUSAN'))$tembusan = join(",",$this->input->post('TEMBUSAN'));
				else $tembusan = '';
				$arr = array('HASIL_PPOMN' => $this->input->post('HASIL_PPOMN'),
							 'MONEV_PPOMN' => $this->input->post('MONEV_PPOMN'),
							 'MONEV_UPDATE_BY' => $this->newsession->userdata('SESS_USER_ID'),
							 'MONEV_UPDATE_DATE' => 'GETDATE()',
							 'TEMBUSAN' => $tembusan);
				$this->db->where('KODE_SAMPEL', $this->input->post('KODE_SAMPEL'));
				$this->db->update('T_M_SAMPEL_RILIS', $arr);
				if($this->db->affected_rows() > 0){
					$data = array('KODE_SAMPEL' => $this->input->post('KODE_SAMPEL'),
								  'WAKTU' => 'GETDATE()',
								  'USER_ID' => $this->newsession->userdata('SESS_USER_ID'),
								  'KEGIATAN' => 'Proses hasil monitoring dan evaluasi',
								  'CATATAN' => $this->input->post('catatan'));
					$this->db->insert('T_SAMPLING_LOG', $data);
					return "MSG#YES#$msgok#".site_url().'/home/ppomn/laporan/monev';
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
	
	function set_rilis_($action, $isajax){
		if((in_array('4',$this->newsession->userdata('SESS_KODE_ROLE')) || in_array('7',$this->newsession->userdata('SESS_KODE_ROLE')) || in_array('11',$this->newsession->userdata('SESS_KODE_ROLE'))) && ($this->newsession->userdata('LOGGED_IN') == TRUE && $this->newsession->userdata('SESS_BBPOM_ID') == "99")){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			if($action == "rilis-absah"){
				$msgok = "Proses sampel berhasil";
				$msgerr = "Proses sampel gagal, Silahkan coba lagi";
				if($this->input->post('HASIL_PPOMN') == "MS"){
					$res = $this->db->simple_query("SET DATEFORMAT DMY UPDATE T_M_SAMPEL_RILIS SET HASIL_PPOMN = '".$this->input->post('HASIL_PPOMN')."', STATUS_PPOMN = '1', STATUS_WASDIS = '1', ARSIP_SAMPEL = '1', STATUS = '20210', LAST_UPDATE = GETDATE(), UPDATE_BY = '".$this->newsession->userdata('SESS_USER_ID')."' WHERE KODE_SAMPEL = '".$this->input->post('KODE_SAMPEL')."'");	
				}else{ 
					if($this->input->post('TINDAK_LANJUT_PPOMN')){
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
					}else{
						$res = $this->db->simple_query("UPDATE T_M_SAMPEL_RILIS SET STATUS_PPOMN = '1', STATUS = '".$this->input->post('STATUS')."', TINDAK_LANJUT_PPOMN = '9902', LAST_UPDATE = GETDATE(), UPDATE_BY = '".$this->newsession->userdata('SESS_USER_ID')."' WHERE KODE_SAMPEL = '".$this->input->post('KODE_SAMPEL')."'");	
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
								  'KEGIATAN' => 'Verifikasi tindak lanjut hasil pengujian',
								  'CATATAN' => $this->input->post('catatan'));
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
			else if($action == "disposisi"){
				$msgok = "Proses sampel berhasil";
				$msgerr = "Proses sampel gagal, Silahkan coba lagi";
				if($this->input->post('STATUS') == "40299"){
					$sttsnew = '20210';
					if($this->input->post('TEMBUSAN')){
						$tembusan = join(",",$this->input->post('TEMBUSAN'));
						$res = $this->db->simple_query("UPDATE T_M_SAMPEL_RILIS SET STATUS = '".$sttsnew."', TINDAK_LANJUT_PPOMN = '9903', ARSIP_SAMPEL = '1', TEMBUSAN = '".$tembusan."', UPDATE_BY= '". $this->newsession->userdata('SESS_USER_ID'). "' WHERE KODE_SAMPEL = '".$this->input->post('KODE_SAMPEL')."'");
						$catatan = $this->input->post('catatan')."<br>Tembusan : ".$tembusan;
					}else{
						$res = $this->db->simple_query("UPDATE T_M_SAMPEL_RILIS SET STATUS = '".$sttsnew."', TINDAK_LANJUT_PPOMN = '9903', ARSIP_SAMPEL = '1', UPDATE_BY= '". $this->newsession->userdata('SESS_USER_ID'). "' WHERE KODE_SAMPEL = '".$this->input->post('KODE_SAMPEL')."'");
						$catatan = $this->input->post('catatan');
					}
				}else{
					if($this->input->post('STATUS') == "11901")
						$res = $this->db->simple_query("UPDATE T_M_SAMPEL_RILIS SET STATUS = '".$this->input->post('STATUS')."', TINDAK_LANJUT_PPOMN = '9901', UPDATE_BY= '". $this->newsession->userdata('SESS_USER_ID'). "' WHERE KODE_SAMPEL = '".$this->input->post('KODE_SAMPEL')."'");
					else 
						$res = $this->db->simple_query("UPDATE T_M_SAMPEL_RILIS SET STATUS = '".$this->input->post('STATUS')."', UPDATE_BY= '". $this->newsession->userdata('SESS_USER_ID'). "' WHERE KODE_SAMPEL = '".$this->input->post('KODE_SAMPEL')."'");
					$sttsnew = $this->input->post('STATUS');
					$catatan = $this->input->post('catatan');
				}
				if($res){
					//$this->db->simple_query("UPDATE T_M_SAMPEL SET STATUS_SAMPEL = '".$sttsnew."' WHERE KODE_SAMPEL = '".$this->input->post('KODE_SAMPEL')."'");
					$data = array('KODE_SAMPEL' => $this->input->post('KODE_SAMPEL'),
								  'WAKTU' => 'GETDATE()',
								  'USER_ID' => $this->newsession->userdata('SESS_USER_ID'),
								  'KEGIATAN' => 'Verifikasi tindak lanjut hasil pengujian',
								  'CATATAN' => $catatan);
					$this->db->insert('T_SAMPLING_LOG', $data);
					return "MSG#YES#$msgok#";
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