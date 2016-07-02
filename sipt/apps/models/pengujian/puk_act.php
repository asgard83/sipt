 <?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR);
class Puk_act extends Model{
	
	function list_puk($submenu, $id)
	{
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE)
		{
			$sipt =& get_instance();
			$this->load->model('main','main',TRUE);
			$this->load->library('newtable');
			
			
			if($id == "receive"){
				$query =  "SELECT A.PUK_ID, A.STATUS AS STTS, dbo.FORMAT_NOMOR('SPL', A.KODE_SAMPEL) AS [KODE SAMPEL],
						   A.NAMA_SAMPEL + '<div>' + A.PABRIK + '</div><div>' + A.NOMOR_REGISTRASI + '</div>' AS [IDENTITAS SAMPEL],
						   REPLACE(REPLACE(B.NAMA_BBPOM,'BALAI BESAR POM DI', ''),'BALAI POM DI','') AS [BPOM],
						   CONVERT(VARCHAR(10), A.UPDATE_DATE, 103) AS [UPDATE TERAKHIR],
						   CASE
						   WHEN A.STATUS = '00001' THEN 'Ditwas Produksi - Review PUK'
						   WHEN A.STATUS = '00002' THEN 'MT - Revisi PUK'
						   WHEN A.STATUS = '00003' THEN 'MT - PUK Disetujui'
						   WHEN A.STATUS = '00004' THEN 'PUK Terbit SPK'
						   END AS [STATUS]
						   FROM T_SAMPEL_PUK A LEFT JOIN M_BBPOM B ON A.BBPOM_ID = B.BBPOM_ID";
				
				$this->newtable->search(array(array("dbo.FORMAT_NOMOR('SPL', A.KODE_SAMPEL)", "Kode Sampel"), 
											  array("A.NAMA_SAMPEL", "Nama Sampel"),
											  array("B.NAMA_BBPOM", "BBPOM / BPOM")));
				
				$this->newtable->columns(array("A.PUK_ID", "A.STATUS", array("dbo.FORMAT_NOMOR('SPL', A.KODE_SAMPEL)",site_url()."/home/pengujian/puk/preview/{PUK_ID}.{STTS}"), "A.NAMA_SAMPEL + '<div>' + A.PABRIK + '</div><div>' + A.NOMOR_REGISTRASI + '</div>'","CONVERT(VARCHAR(10), A.UPDATE_DATE, 103)","REPLACE(REPLACE(B.NAMA_BBPOM,'BALAI BESAR POM DI', ''),'BALAI POM DI','')","CASE WHEN A.STATUS = '00001' THEN 'Ditwas Produksi - Review PUK' WHEN A.STATUS = '00002' THEN 'MT - Revisi PUK' WHEN A.STATUS = '00003' THEN 'MT - PUK Disetujui' END"));
				$this->newtable->width(array('KODE SAMPEL' => 135, 'IDENTITAS SAMPEL' => 250, 'BPOM' => 150,'UPDATE TERAKHIR' => 130, 'STATUS' => 225));
				$this->newtable->keys(array('PUK_ID','STTS'));
			}
			
			else if($id == "review")
			{
				$query =  "SELECT A.PUK_ID, A.STATUS AS STTS, dbo.FORMAT_NOMOR('SPL', A.KODE_SAMPEL) AS [KODE SAMPEL],
						   A.NAMA_SAMPEL + '<div>' + A.PABRIK + '</div><div>' + A.NOMOR_REGISTRASI + '</div>' AS [IDENTITAS SAMPEL],
						   CONVERT(VARCHAR(10), A.UPDATE_DATE, 103) AS [UPDATE TERAKHIR],
						   CASE
						   WHEN A.STATUS = '00001' THEN 'Ditwas Produksi - Review PUK'
						   WHEN A.STATUS = '00002' THEN 'MT - Revisi PUK'
						   WHEN A.STATUS = '00003' THEN 'MT - PUK Disetujui'
						   WHEN A.STATUS = '00004' THEN 'PUK Terbit SPK'
						   END AS [STATUS]
						   FROM T_SAMPEL_PUK A WHERE A.CREATE_BY = '".$this->newsession->userdata('SESS_USER_ID')."'";
				
				$this->newtable->search(array(array("dbo.FORMAT_NOMOR('SPL', A.KODE_SAMPEL)", "Kode Sampel"), 
											  array("A.NAMA_SAMPEL", "Nama Sampel")));
				
				$this->newtable->columns(array("A.PUK_ID", "A.STATUS", array("dbo.FORMAT_NOMOR('SPL', A.KODE_SAMPEL)",site_url()."/home/pengujian/puk/preview/{PUK_ID}.{STTS}"), "A.NAMA_SAMPEL + '<div>' + A.PABRIK + '</div><div>' + A.NOMOR_REGISTRASI + '</div>'","CONVERT(VARCHAR(10), A.UPDATE_DATE, 103)","CASE WHEN A.STATUS = '00001' THEN 'Ditwas Produksi - Review PUK' WHEN A.STATUS = '00002' THEN 'MT - Revisi PUK' WHEN A.STATUS = '00003' THEN 'MT - PUK Disetujui' END"));
				$this->newtable->width(array('KODE SAMPEL' => 135, 'IDENTITAS SAMPEL' => 250, 'UPDATE TERAKHIR' => 130, 'STATUS' => 225));
				$this->newtable->keys(array('PUK_ID','STTS'));
			}
			$this->newtable->hiddens(array('PUK_ID','STTS'));
			$this->newtable->action(site_url()."/home/pengujian/puk/list/".$id);
			$this->newtable->cidb($this->db);
			$this->newtable->ciuri($this->uri->segment_array());
			$this->newtable->orderby(1);
			$this->newtable->sortby("ASC");
			$proses['Preview Data'] = array('GET', site_url()."/home/pengujian/puk/preview", '1');
			$this->newtable->menu($proses);
			$tabel = $this->newtable->generate($query);
			$arrdata = array('table' => $tabel,
							 'idjudul' => 'juduluji',
							 'caption_header' => 'Review Parameter Uji Kritis',
							 'batal' => '',
							 'cancel' => '');
			return $arrdata;
		}
	}
	
	function get_puk($id)
	{
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE)
		{
			$sipt =& get_instance();
			$this->load->model('main','main',TRUE);
			$arrdata = array();
			$arr_id = explode(".", $id);
			$query = "SELECT A.PERIKSA_SAMPEL, A.KODE_SAMPEL, A.SPU_ID, dbo.FORMAT_NOMOR('SPL', A.KODE_SAMPEL) AS UR_KODESAMPEL, A.KOMODITI, dbo.KATEGORI(A.KOMODITI,A.PRIORITAS) AS UR_KOMODITI, dbo.KATEGORI(A.KATEGORI,A.PRIORITAS) AS UR_KATEGORIX, A.NAMA_KATEGORI AS UR_KATEGORI, A.KATEGORI, dbo.URAIAN_M_TABEL('SUB_TUJUAN', A.SUB_TUJUAN) AS SUB_TUJUAN, dbo.URAIAN_M_TABEL('ASAL_SAMPLING',A.ASAL_SAMPEL) AS ASAL_SAMPEL, dbo.URAIAN_M_TABEL('TUJUAN_SAMPLING',A.TUJUAN_SAMPLING) AS TUJUAN_SAMPLING, A.KLASIFIKASI_TAMBAHAN,A.NAMA_SAMPEL,A.NOMOR_REGISTRASI,A.PABRIK,IMPORTIR,A.BENTUK_SEDIAAN,A.KEMASAN,A.NO_BETS,A.KETERANGAN_ED,A.JUMLAH_SAMPEL,A.SATUAN,A.HARGA_SAMPEL,A.UJI_KIMIA,A.JUMLAH_KIMIA,A.UJI_MIKRO,A.JUMLAH_MIKRO,A.SISA,REPLACE(A.KOMPOSISI,';','<br>') AS KOMPOSISI,A.NETTO,A.KONDISI_SAMPEL,A.EVALUASI_PENANDAAN,A.CARA_PENYIMPANAN, A.LABEL, A.SEGEL,A.CATATAN,A.STATUS_KIMIA,A.STATUS_MIKRO,A.STATUS_SAMPEL,A.LAMPIRAN, A.PRIORITAS, A.PRIORITAS, B.PUK_ID, B.SPK_ID, B.STATUS, B.CREATE_BY FROM T_M_SAMPEL A LEFT JOIN T_SAMPEL_PUK B ON A.KODE_SAMPEL = B.KODE_SAMPEL WHERE B.PUK_ID = '".$arr_id[0]."' AND B.STATUS = '".$arr_id[1]."'";
			$data = $sipt->main->get_result($query);
			if($data)
			{
				foreach($query->result_array() as $row)
				{
					$arrdata['sess'] = $row;
				}
				$qpuk = "SELECT A.PUK_ID, A.SERI, A.PARAMETER_UJI, A.KETENTUAN_KHUSUS, A.PUSTAKA, 
						 A.METODE, A.SYARAT, A.STATUS, B.KETERANGAN 
						 FROM T_SAMPEL_PUK_DETIL A LEFT JOIN M_PUK B ON A.KETENTUAN_KHUSUS = B.PUK_ID
						 WHERE A.PUK_ID = '".$arr_id[0]."'";
				$dpuk = $sipt->main->get_result($qpuk);
				if($dpuk)
				{
					foreach($qpuk->result_array() as $rpuk)
					{
						$arrdata['puk'][] = $rpuk;
					}
				}
				$arrdata['verifikasi'] = array('' => '', '00002' => 'PUK Di Revisi', '00003' => 'PUK Di Setujui');
				if($row['STATUS'] == '00001' && in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')))
				{
					$arrdata['input'] = TRUE;
					$arrdata['act'] = site_url().'/post/puk/puk_act/verifikasi';
				}
				else if($row['STATUS'] == '00003' && $row['CREATE_BY'] == $this->newsession->userdata('SESS_USER_ID'))
				{
					$arrdata['proses'] = TRUE;
					$arrdata['act'] = site_url().'/post/puk/puk_act/proses_spk';
				}
				else if($row['STATUS'] == '00002' && $row['CREATE_BY'] == $this->newsession->userdata('SESS_USER_ID'))
				{
					$arrdata['proses'] = TRUE;
					$arrdata['revisi'] = TRUE;
					$arrdata['act'] = site_url().'/post/puk/puk_act/revisi';	
				}
				$arrdata['logpuk'] = $sipt->main->get_uraian("SELECT COUNT(*) LOGPUK FROM T_SAMPEL_PUK_LOG WHERE PUK_ID = '".$arr_id[0]."'","LOGPUK"); 
				$arrdata['cbuji'] = array('' => '', '0' => 'Tidak Diuji', '1' => 'Diuji');
			}
			return $arrdata;
		}
	}
	
	function set_puk($action, $isajax){
		$sipt =& get_instance();
		$this->load->model("main", "main", true);
		if($action == "verifikasi")
		{
			
			if($this->input->post('STATUS') == "00003"){
				unset($_POST['PUK']['STATUS']);	
			}
			$hasil = FALSE;
			$arrpuk = array('STATUS' => $this->input->post('STATUS'),
							'UPDATE_DATE' => 'GETDATE()',
							'UPDATE_BY' => $this->newsession->userdata('SESS_USER_ID'));	
			$this->db->where('PUK_ID', $this->input->post('PUK_ID'));
			$this->db->where('KODE_SAMPEL', $this->input->post('KODE_SAMPEL'));
			$this->db->update('T_SAMPEL_PUK', $arrpuk);
			if($this->db->affected_rows() > 0)
			{					
				$arrsampel = $this->input->post('PUK');
				$arrkeys = array_keys($arrsampel);
				for($s = 0; $s < count($_POST['PUK']['PUK_ID']); $s++)
				{
					for($j=0;$j<count($arrkeys);$j++){
						$arrupdate[$arrkeys[$j]] = $arrsampel[$arrkeys[$j]][$s];
					}
					$this->db->where('PUK_ID', $_POST['PUK']['PUK_ID'][$s]);
					$this->db->where('SERI', $_POST['PUK']['SERI'][$s]);
					$this->db->update('T_SAMPEL_PUK_DETIL', $arrupdate);
				}
				$arrlogpuk = array('PUK_ID' => $this->input->post('PUK_ID'),
								   'WAKTU' => 'GETDATE()',
								   'USER_ID' => $this->newsession->userdata('SESS_USER_ID'),
								   'KEGIATAN' => 'Verifikasi PUK',
								   'CATATAN' => $this->input->post('JUSTIFIKASI'));
				$this->db->insert('T_SAMPEL_PUK_LOG', $arrlogpuk);
				$hasil = TRUE;
			}
			if($hasil){
				return "MSG#YES#Data PUK berhasil diverifikasi#".site_url()."/home/pengujian/puk/list/receive";
			}else{
				return "MSG#NO#Data PUK gagal diverifikasi";
			}
			if($isajax!="ajax"){
				redirect(base_url());
				exit();
			}
		}
		
		else if($action == "revisi")
		{
			$hasil = FALSE;
			$arrpuk = array('STATUS' => '00001',
							'UPDATE_DATE' => 'GETDATE()',
							'UPDATE_BY' => $this->newsession->userdata('SESS_USER_ID'));	
			$this->db->where('PUK_ID', $this->input->post('PUK_ID'));
			$this->db->where('KODE_SAMPEL', $this->input->post('KODE_SAMPEL'));
			$this->db->update('T_SAMPEL_PUK', $arrpuk);
			if($this->db->affected_rows() > 0)
			{					
				$arrsampel = $this->input->post('PUK');
				$arrkeys = array_keys($arrsampel);
				for($s = 0; $s < count($_POST['PUK']['PUK_ID']); $s++)
				{
					for($j=0;$j<count($arrkeys);$j++){
						$arrupdate[$arrkeys[$j]] = $arrsampel[$arrkeys[$j]][$s];
					}
					$this->db->where('PUK_ID', $_POST['PUK']['PUK_ID'][$s]);
					$this->db->where('SERI', $_POST['PUK']['SERI'][$s]);
					$this->db->update('T_SAMPEL_PUK_DETIL', $arrupdate);
				}
				$arrlogpuk = array('PUK_ID' => $this->input->post('PUK_ID'),
								   'WAKTU' => 'GETDATE()',
								   'USER_ID' => $this->newsession->userdata('SESS_USER_ID'),
								   'KEGIATAN' => 'Mengajukan Revisi PUK',
								   'CATATAN' => $this->input->post('JUSTIFIKASI'));
				$this->db->insert('T_SAMPEL_PUK_LOG', $arrlogpuk);
				$hasil = TRUE;
			}
			if($hasil){
				return "MSG#YES#Data PUK berhasil Dikirim#".site_url()."/home/pengujian/puk/list/review";
			}else{
				return "MSG#NO#Data PUK gagal Dikirim";
			}
			if($isajax!="ajax"){
				redirect(base_url());
				exit();
			}
		}
		
		else if($action == "proses_spk")
		{
			$hasil = FALSE;
			$counter = 0;
			$arrpuk = array('STATUS' => '00004');	
			$this->db->where('PUK_ID', $this->input->post('PUK_ID'));
			$this->db->where('KODE_SAMPEL', $this->input->post('KODE_SAMPEL'));
			$this->db->update('T_SAMPEL_PUK', $arrpuk);
			if($this->db->affected_rows() > 0){
				$arrspk = array('STATUS' => '30201');
				$this->db->where('SPK_ID', $this->input->post('SPK_ID'));
				$this->db->where('KODE_SAMPEL', $this->input->post('KODE_SAMPEL'));
				$this->db->update('T_SPK', $arrspk);
				if($this->db->affected_rows() > 0)
				{
					$qcopy = "SELECT PARAMETER_UJI, JENIS_UJI, KETENTUAN_KHUSUS, PUSTAKA, METODE, SYARAT 
					FROM T_SAMPEL_PUK_DETIL WHERE PUK_ID = '".$this->input->post('PUK_ID')."' AND STATUS = '1'";
					$dcopy = $sipt->main->get_result($qcopy);
					if($dcopy)
					{
						$tgl_spk = $sipt->main->get_uraian("SELECT CONVERT(VARCHAR(10), TANGGAL, 103) AS TGL_SPK FROM T_SPK WHERE SPK_ID = '".$this->input->post('SPK_ID')."'","TGL_SPK");
						$penyelia = $sipt->main->get_uraian("SELECT KASIE FROM T_SPK WHERE SPK_ID = '".$this->input->post('SPK_ID')."'","KASIE");
						foreach($qcopy->result_array() as $row){
							$chk2 = (int)$sipt->main->get_uraian("SELECT AUTO_RESET FROM M_REF_UJI WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND KOMODITI = '01' AND BIDANG = '02'","AUTO_RESET");
							if($chk2 == 1)
							$uji_id = $sipt->main->set_kode_uji('K','01',$tgl_spk);
							else $uji_id = $sipt->main->set_kode_uji('K','01',$tgl_spk);
							$arr_parameter['UJI_ID'] = $uji_id;
							$arr_parameter['SPK_ID'] = $this->input->post('SPK_ID');
							$arr_parameter['KODE_SAMPEL'] = $this->input->post('KODE_SAMPEL');
							$arr_parameter['GOLONGAN'] = trim($sipt->main->get_uraian("SELECT LTRIM(RTRIM(KATEGORI)) AS KATEGORI FROM T_M_SAMPEL WHERE KODE_SAMPEL = '".$this->input->post('KODE_SAMPEL')."'","KATEGORI"));
							$arr_parameter['PARAMETER_UJI'] = $row['PARAMETER_UJI'];
							$arr_parameter['SIMULAN'] = '';
							$arr_parameter['KATEGORI_PU'] = '';
							$arr_parameter['METODE'] = $row['METODE'];
							$arr_parameter['PUSTAKA'] = $row['PUSTAKA'];
							$arr_parameter['SYARAT'] = $row['SYARAT'];
							$arr_parameter['RUANG_LINGKUP'] = '';
							$arr_parameter['JENIS_UJI'] = $row['JENIS_UJI'];
							$arr_parameter['KETENTUAN_KHUSUS'] = $row['KETENTUAN_KHUSUS'];
							$arr_parameter['PENYELIA'] = $penyelia;
							$this->db->insert('T_PARAMETER_HASIL_UJI', $arr_parameter);
							if($this->db->affected_rows() > 0)
							{
								$counter++;
							}
						}
					}
					if($counter > 0){
						$hasil = TRUE;
					}
					
				}
			}
			if($hasil){
				return "MSG#YES#Data PUK berhasil diproses#".site_url()."/home/pengujian/puk/list/review";
			}else{
				return "MSG#NO#Data PUK gagal diproses";
			}
			if($isajax!="ajax"){
				redirect(base_url());
				exit();
			}
		}
	}
}	
?>