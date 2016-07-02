<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR);
class Rujukan_act extends Model{
	
	function list_rujukan($status){
		if(in_array('5', $this->newsession->userdata('SESS_KODE_ROLE')) && $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$this->load->library('newtable');
			if($status == "draft"){
				$judul = "Draft Sampel Rujukan";
				$query = "SELECT A.KODE_SAMPEL, A.NAMA_SAMPEL + '<div>' + dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) + '</div><div>' + A.BENTUK_SEDIAAN + '</div><div>' + A.PABRIK + '</div><div>' + A.NOMOR_REGISTRASI + ', No Batch  : ' +  A.NO_BETS + '</div><div>'+A.TEMPAT_SAMPLING+'</div>' AS [IDENTITAS SAMPEL], CAST(A.JUMLAH_SAMPEL AS VARCHAR) +'&nbsp;'+ A.SATUAN +'<div>&bull;&nbsp;Uji Kimia : '+ CAST(A.JUMLAH_KIMIA AS VARCHAR)+'</div><div>&bull;&nbsp;Uji Mikro : '+CAST(A.JUMLAH_MIKRO AS VARCHAR) +'</div><div>&bull;&nbsp;Sisa Sampel : '+CAST(A.SISA AS VARCHAR) +'</div><div>' +CASE WHEN A.UJI_KIMIA = '1' AND A.UJI_MIKRO = '1' THEN 'Uji Kimia - Mikro' WHEN A.UJI_KIMIA = '1' THEN 'Uji Kimia' WHEN A.UJI_MIKRO = '1' THEN 'Uji Mikro' END+ '</div>' AS [JUMLAH UJI], dbo.KATEGORI(A.KOMODITI,A.PRIORITAS) + '<div>' + dbo.KATEGORI(A.KATEGORI,A.PRIORITAS) + '</div>' AS KOMODITI, '<div>Hasil Uji Kimia : ' + A.HASIL_KIMIA + '</div><div>Hasil Uji Mikro : ' + A.HASIL_MIKRO + '</div><div>Hasil Sampel : ' + A.HASIL_SAMPEL + '</div>' AS HASIL, CONVERT(VARCHAR(10), A.UPDATE_DATE, 120) AS SORTTGL FROM T_M_SAMPEL A LEFT JOIN T_PERIKSA_SAMPEL B ON A.PERIKSA_SAMPEL = B.PERIKSA_SAMPEL WHERE B.BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND A.STATUS_SAMPEL = '50203' AND A.UJI_RUJUK = '1'";
				$this->newtable->search(array(array("A.NAMA_SAMPEL","Nama Sampel"),array("dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL)","Kode Sampel"),array("A.TEMPAT_SAMPLING","Tempat Sampling"),array("dbo.KATEGORI(A.KOMODITI,A.PRIORITAS)","Komoditi"),array("dbo.KATEGORI(A.KATEGORI,A.PRIORITAS)","Kategori")));
				$this->newtable->columns(array("A.KODE_SAMPEL", array("A.NAMA_SAMPEL + '<div>' + dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) + '</div><div>' + A.BENTUK_SEDIAAN + '</div><div>' + A.PABRIK + '</div><div>' + A.NOMOR_REGISTRASI + ', No Batch  : ' +  A.NO_BETS + '</div><div>'+A.TEMPAT_SAMPLING+'</div>'",site_url()."/home/rujukan/preview/sampel/{KODE_SAMPEL}"),"CAST(A.JUMLAH_SAMPEL AS VARCHAR) +'&nbsp;'+ A.SATUAN +'<div>&bull;&nbsp;Uji Kimia : '+ CAST(A.JUMLAH_KIMIA AS VARCHAR)+'</div><div>&bull;&nbsp;Uji Mikro : '+CAST(A.JUMLAH_MIKRO AS VARCHAR) +'</div><div>&bull;&nbsp;Sisa Sampel : '+CAST(A.SISA AS VARCHAR) +'</div><div>' +CASE WHEN A.UJI_KIMIA = '1' AND A.UJI_MIKRO = '1' THEN 'Uji Kimia - Mikro' WHEN A.UJI_KIMIA = '1' THEN 'Uji Kimia' WHEN A.UJI_MIKRO = '1' THEN 'Uji Mikro' END+ '</div>'", "dbo.KATEGORI(A.KOMODITI,A.PRIORITAS) + '<div>' + dbo.KATEGORI(A.KATEGORI,A.PRIORITAS) + '</div>'","'<div>Hasil Uji Kimia : ' + A.HASIL_KIMIA + '</div><div>A.Hasil Uji Mikro : ' + A.HASIL_MIKRO + '</div><div>Hasil : ' + A.HASIL_SAMPEL + '</div>'"," CONVERT(VARCHAR(10), A.UPDATE_DATE, 120)"));
				$proses['Kirim Data Sampel Rujukan'] = array('POST', site_url().'/post/rujukan/kirim_act/rujuk/ajax', 'N');
			}else if($status == "proses"){
				$judul = "Daftar Sampel Rujukan Dalam Proses (Terkirim)";
				$query = "SELECT A.KODE_SAMPEL, A.NAMA_SAMPEL + '<div>' + dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) + '</div><div>' + A.BENTUK_SEDIAAN + '</div><div>' + A.PABRIK + '</div><div>' + A.NOMOR_REGISTRASI + ', No Batch  : ' +  A.NO_BETS + '</div><div>'+A.TEMPAT_SAMPLING+'</div>' AS [IDENTITAS SAMPEL], CAST(A.JUMLAH_SAMPEL AS VARCHAR) +'&nbsp;'+ A.SATUAN +'<div>&bull;&nbsp;Uji Kimia : '+ CAST(A.JUMLAH_KIMIA AS VARCHAR)+'</div><div>&bull;&nbsp;Uji Mikro : '+CAST(A.JUMLAH_MIKRO AS VARCHAR) +'</div><div>&bull;&nbsp;Sisa Sampel : '+CAST(A.SISA AS VARCHAR) +'</div><div>' +CASE WHEN A.UJI_KIMIA = '1' AND A.UJI_MIKRO = '1' THEN 'Uji Kimia - Mikro' WHEN A.UJI_KIMIA = '1' THEN 'Uji Kimia' WHEN A.UJI_MIKRO = '1' THEN 'Uji Mikro' END+ '</div>' AS [JUMLAH UJI], dbo.KATEGORI(A.KOMODITI,A.PRIORITAS) + '<div>' + dbo.KATEGORI(A.KATEGORI,A.PRIORITAS) + '</div>' AS KOMODITI, '<div>Hasil Uji Kimia : ' + A.HASIL_KIMIA + '</div><div>Hasil Uji Mikro : ' + A.HASIL_MIKRO + '</div><div>Hasil Sampel : ' + A.HASIL_SAMPEL + '</div>' AS HASIL, CONVERT(VARCHAR(10), A.UPDATE_DATE, 120) AS SORTTGL FROM T_M_SAMPEL A LEFT JOIN T_PERIKSA_SAMPEL B ON A.PERIKSA_SAMPEL = B.PERIKSA_SAMPEL WHERE B.BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND A.STATUS_SAMPEL IN ('70011', '80011', '70012', '40209', '50204') AND A.UJI_RUJUK = '1'";
				$this->newtable->search(array(array("A.NAMA_SAMPEL","Nama Sampel"),array("dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL)","Kode Sampel"),array("A.TEMPAT_SAMPLING","Tempat Sampling"),array("dbo.KATEGORI(A.KOMODITI,A.PRIORITAS)","Komoditi"),array("dbo.KATEGORI(A.KATEGORI,A.PRIORITAS)","Kategori")));
				$this->newtable->columns(array("A.KODE_SAMPEL", array("A.NAMA_SAMPEL + '<div>' + dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) + '</div><div>' + A.BENTUK_SEDIAAN + '</div><div>' + A.PABRIK + '</div><div>' + A.NOMOR_REGISTRASI + ', No Batch  : ' +  A.NO_BETS + '</div><div>'+A.TEMPAT_SAMPLING+'</div>'",site_url()."/home/rujukan/preview/sampel/{KODE_SAMPEL}"),"CAST(A.JUMLAH_SAMPEL AS VARCHAR) +'&nbsp;'+ A.SATUAN +'<div>&bull;&nbsp;Uji Kimia : '+ CAST(A.JUMLAH_KIMIA AS VARCHAR)+'</div><div>&bull;&nbsp;Uji Mikro : '+CAST(A.JUMLAH_MIKRO AS VARCHAR) +'</div><div>&bull;&nbsp;Sisa Sampel : '+CAST(A.SISA AS VARCHAR) +'</div><div>' +CASE WHEN A.UJI_KIMIA = '1' AND A.UJI_MIKRO = '1' THEN 'Uji Kimia - Mikro' WHEN A.UJI_KIMIA = '1' THEN 'Uji Kimia' WHEN A.UJI_MIKRO = '1' THEN 'Uji Mikro' END+ '</div>'", "dbo.KATEGORI(A.KOMODITI,A.PRIORITAS) + '<div>' + dbo.KATEGORI(A.KATEGORI,A.PRIORITAS) + '</div>'","'<div>Hasil Uji Kimia : ' + A.HASIL_KIMIA + '</div><div>A.Hasil Uji Mikro : ' + A.HASIL_MIKRO + '</div><div>Hasil : ' + A.HASIL_SAMPEL + '</div>'"," CONVERT(VARCHAR(10), A.UPDATE_DATE, 120)"));
			}else if($status == "hasil"){
				$judul = "Daftar Hasil Sampel Rujukan";
				$query = "SELECT A.KODE_SAMPEL, A.NAMA_SAMPEL + '<div>' + dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) + '</div><div>' + A.BENTUK_SEDIAAN + '</div><div>' + A.PABRIK + '</div><div>' + A.NOMOR_REGISTRASI + ', No Batch  : ' +  A.NO_BETS + '</div><div>'+A.TEMPAT_SAMPLING+'</div>' AS [IDENTITAS SAMPEL], CAST(A.JUMLAH_SAMPEL AS VARCHAR) +'&nbsp;'+ A.SATUAN +'<div>&bull;&nbsp;Uji Kimia : '+ CAST(A.JUMLAH_KIMIA AS VARCHAR)+'</div><div>&bull;&nbsp;Uji Mikro : '+CAST(A.JUMLAH_MIKRO AS VARCHAR) +'</div><div>&bull;&nbsp;Sisa Sampel : '+CAST(A.SISA AS VARCHAR) +'</div><div>' +CASE WHEN A.UJI_KIMIA = '1' AND A.UJI_MIKRO = '1' THEN 'Uji Kimia - Mikro' WHEN A.UJI_KIMIA = '1' THEN 'Uji Kimia' WHEN A.UJI_MIKRO = '1' THEN 'Uji Mikro' END+ '</div>' AS [JUMLAH UJI], dbo.KATEGORI(A.KOMODITI,A.PRIORITAS) + '<div>' + dbo.KATEGORI(A.KATEGORI,A.PRIORITAS) + '</div>' AS KOMODITI, '<div>Hasil Uji Kimia : ' + A.HASIL_KIMIA + '</div><div>Hasil Uji Mikro : ' + A.HASIL_MIKRO + '</div><div>Hasil Sampel : ' + A.HASIL_SAMPEL + '</div>' AS HASIL, CONVERT(VARCHAR(10), A.UPDATE_DATE, 120) AS SORTTGL FROM T_M_SAMPEL A LEFT JOIN T_PERIKSA_SAMPEL B ON A.PERIKSA_SAMPEL = B.PERIKSA_SAMPEL LEFT JOIN T_SAMPEL_RUJUKAN C ON A.KODE_SAMPEL = C.KODE_SAMPEL WHERE C.BBPOM_RUJUK = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND A.STATUS_SAMPEL = '50204' AND A.UJI_RUJUK = '1'";
				$this->newtable->search(array(array("A.NAMA_SAMPEL","Nama Sampel"),array("dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL)","Kode Sampel"),array("A.TEMPAT_SAMPLING","Tempat Sampling"),array("dbo.KATEGORI(A.KOMODITI,A.PRIORITAS)","Komoditi"),array("dbo.KATEGORI(A.KATEGORI,A.PRIORITAS)","Kategori")));
				$this->newtable->columns(array("A.KODE_SAMPEL", array("A.NAMA_SAMPEL + '<div>' + dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) + '</div><div>' + A.BENTUK_SEDIAAN + '</div><div>' + A.PABRIK + '</div><div>' + A.NOMOR_REGISTRASI + ', No Batch  : ' +  A.NO_BETS + '</div><div>'+A.TEMPAT_SAMPLING+'</div>'",site_url()."/home/rujukan/preview/sampel/{KODE_SAMPEL}"),"CAST(A.JUMLAH_SAMPEL AS VARCHAR) +'&nbsp;'+ A.SATUAN +'<div>&bull;&nbsp;Uji Kimia : '+ CAST(A.JUMLAH_KIMIA AS VARCHAR)+'</div><div>&bull;&nbsp;Uji Mikro : '+CAST(A.JUMLAH_MIKRO AS VARCHAR) +'</div><div>&bull;&nbsp;Sisa Sampel : '+CAST(A.SISA AS VARCHAR) +'</div><div>' +CASE WHEN A.UJI_KIMIA = '1' AND A.UJI_MIKRO = '1' THEN 'Uji Kimia - Mikro' WHEN A.UJI_KIMIA = '1' THEN 'Uji Kimia' WHEN A.UJI_MIKRO = '1' THEN 'Uji Mikro' END+ '</div>'", "dbo.KATEGORI(A.KOMODITI,A.PRIORITAS) + '<div>' + dbo.KATEGORI(A.KATEGORI,A.PRIORITAS) + '</div>'","'<div>Hasil Uji Kimia : ' + A.HASIL_KIMIA + '</div><div>A.Hasil Uji Mikro : ' + A.HASIL_MIKRO + '</div><div>Hasil : ' + A.HASIL_SAMPEL + '</div>'"," CONVERT(VARCHAR(10), A.UPDATE_DATE, 120)"));
			}
			$this->newtable->action(site_url()."/home/pengujian/rujukan/".$status);
			$this->newtable->hiddens(array('KODE_SAMPEL','SORTTGL'));
			$this->newtable->cidb($this->db);
			$this->newtable->ciuri($this->uri->segment_array());
			$this->newtable->keys(array('KODE_SAMPEL'));
			$this->newtable->orderby(6);
			$this->newtable->sortby("DESC");
			$this->newtable->width(array('IDENTITAS SAMPEL' => 225, 'JUMLAH UJI' => 85, 'KOMODITI' => 250, 'HASIL' => 105));
			$proses['Preview Data'] = array('GET', site_url().'/home/rujukan/preview/sampel', '1');
			$this->newtable->menu($proses);
			$arrdata = array('table' => $this->newtable->generate($query),
							 'idjudul' => 'judulmsampel',
							 'caption_header' => $judul,
							 'batal' => '',
							 'cancel' => '');
			return $arrdata;

		}
	}
	
	function set_proses($action, $isajax){
		if($this->newsession->userdata('LOGGED_IN') == TRUE){
			$sipt =& get_instance();
			$sipt->load->model('main','main',true);
			if($action == "proses"){ 
				$msgok = "Data sampel rujukan berhasil di proses";
				$msgerr = "Data sampel rujukan gagal di proses";
				$hasil = FALSE;
				$id = $this->input->post('KODE_SAMPEL');
				
				$arrupdate = array('STATUS_SAMPEL' => $this->input->post('STATUS'),
								   'UPDATE_DATE' => 'GETDATE()');
				$this->db->where('KODE_SAMPEL', $this->input->post('KODE_SAMPEL'));
				$this->db->update('T_M_SAMPEL', $arrupdate);				   
				if($this->db->affected_rows() > 0){
					$hasil = TRUE;
					$data = array('KODE_SAMPEL' => $a,
								  'WAKTU' => 'GETDATE()',
								  'USER_ID' => $this->newsession->userdata('SESS_USER_ID'),
								  'KEGIATAN' => $this->input->post('catatan'),
								  'CATATAN' => '-');
					$this->db->insert('T_SAMPLING_LOG', $data);
					
					if($this->input->post('STATUS') == "80011"){
						$arrrujukan = array('TANGGAL_TERIMA' => $this->input->post('TANGGAL_TERIMA'),
											'PETUGAS_PENERIMA' => $this->newsession->userdata('SESS_NAMA_USER'),
											'UPDATE_BY' => $this->newsession->userdata('SESS_USER_ID'),
											'UPDATE_DATE' => 'GETDATE()',
											'STATUS' => $this->input->post('STATUS'));
						$this->db->where('KODE_SAMPEL', $this->input->post('KODE_SAMPEL'));					
						$this->db->where('BBPOM_RUJUK', $this->newsession->userdata('SESS_BBPOM_ID'));					
						$this->db->update('T_SAMPEL_RUJUKAN', $arrrujukan);
						$redir = site_url().'/home/rujukan/sampel/draft';
					}
					
					else if($this->input->post('STATUS') == "70012"){
						if($this->set_copy($id)){ #Copy sampel ke balai tujuan
							$arrrujukan = array('TANGGAL_VERIFIKASI' => $this->input->post('TANGGAL_VERIFIKASI'),
												'VERIFIKATOR' => $this->newsession->userdata('SESS_NAMA_USER'),
												'UPDATE_BY' => $this->newsession->userdata('SESS_USER_ID'),
												'UPDATE_DATE' => 'GETDATE()',
												'STATUS' => $this->input->post('STATUS'));
							$this->db->where('KODE_SAMPEL', $this->input->post('KODE_SAMPEL'));					
							$this->db->where('BBPOM_RUJUK', $this->newsession->userdata('SESS_BBPOM_ID'));					
							$this->db->update('T_SAMPEL_RUJUKAN', $arrrujukan);
							$redir = site_url().'/home/rujukan/sampel/verifikasi';
						}else{
							$hasil = FALSE;
						}
					}else if($this->input->post('STATUS') == '40209'){
						$arrrujukan = $this->input->post('RUJUKAN');
						$arrkeys_sampel = array_keys($arrrujukan);
						$jmlrujukan = count($arrrujukan['UJI_ID']);
						$jmlinsert = 0;
						for($i = 0; $i < count($_POST['RUJUKAN']['UJI_ID']); $i++){
							for($j=0;$j<count($arrkeys_sampel);$j++){
								$arr_update[$arrkeys_sampel[$j]] = $arrrujukan[$arrkeys_sampel[$j]][$i];
							}
							$arr_update['STATUS'] = $this->input->post('STATUS');
							$this->db->where('UJI_ID', $_POST['RUJUKAN']['UJI_ID'][$i]);
							$this->db->update('T_SAMPEL_RUJUKAN_DETIL', $arr_update);
							if($this->db->affected_rows() > 0){
								$jmlinsert++;
							}
						}
						if($jmlrujukan == $jmlinsert){
							$reffspu = $this->db->query("SELECT KOMODITI, ANGGARAN, ASAL_SAMPEL FROM T_M_SAMPEL WHERE KODE_SAMPEL = '".$this->input->post('KODE_SAMPEL_BARU')."'")->result_array();
							$reffrujukan = $this->db->query("SELECT CONVERT(VARCHAR(10), TANGGAL_TERIMA, 103) AS TANGGAL_TERIMA, CONVERT(VARCHAR(10), TANGGAL_VERIFIKASI, 103) AS TANGGAL_VERIFIKASI, PETUGAS_PENERIMA FROM T_SAMPEL_RUJUKAN WHERE KODE_SAMPEL = '".$this->input->post('KODE_SAMPEL')."' AND BBPOM_RUJUK = '".$this->newsession->userdata('SESS_BBPOM_ID')."'")->result_array();
							$dataspu = array();
							$tahun = date('d/m/Y');
							$dataspu['SPU_ID'] = $sipt->main->set_kode_spu($reffspu[0]['ANGGARAN'],$reffspu[0]['KOMODITI'], $tahun);

							$dataspu['NOMOR_SP'] = $sipt->main->set_kode_sp($reffspu[0]['KOMODITI'],date("d").date("m").substr(date("Y"),2,4));
							$arrdmy = explode("/",$reffrujukan[0]['TANGGAL_VERIFIKASI']);
							$dmy = $arrdmy[0].$arrdmy[1].substr($arrdmy[2],2,4);
							$dataspu['NOMOR_SP'] = $sipt->main->set_kode_sp($reffspu[0]['KOMODITI'],$dmy);
							$dataspu['NOMOR_SPS'] = str_replace("SPU","SPS",$dataspu['SPU_ID']);
							$dataspu['TANGGAL'] = $reffrujukan[0]['TANGGAL_VERIFIKASI'];
							$dataspu['TANGGAL_PERINTAH'] = $reffrujukan[0]['TANGGAL_VERIFIKASI'];
							$dataspu['TANGGAL_TERIMA_TPS'] = $reffrujukan[0]['TANGGAL_TERIMA'];
							$dataspu['PETUGAS_PENERIMA'] = $reffrujukan[0]['PETUGAS_PENERIMA'];
							$dataspu['BBPOM_ID'] = $this->newsession->userdata('SESS_BBPOM_ID');
							$dataspu['ASAL_SAMPEL'] = $reffspu[0]['ASAL_SAMPEL'];
							$dataspu['CREATE_BY'] = $this->newsession->userdata('SESS_USER_ID');
							$dataspu['CREATE_DATE'] = 'GETDATE()';
							$dataspu['UPDATE_BY'] = $this->newsession->userdata('SESS_USER_ID');
							$dataspu['LAST_UPDATE'] = 'GETDATE()';
							$dataspu['STATUS'] = $this->input->post('STATUS');
							$this->db->insert('T_SPU', $dataspu);
							if($this->db->affected_rows() > 0){
								$group = array();
								for($y = 0; $y < count($arrrujukan['USER_ID']); $y++){
									if(!array_key_exists($arrrujukan['USER_ID'][$y], $group)) $group[$arrrujukan['USER_ID'][$y]] = $arrrujukan['USER_ID'][$y];
								}
								$jmlspu = 0;
								foreach($group as $user){
									$arrmt['USER_ID'] = $user;
									$arrmt['KODE_SAMPEL'] = $this->input->post('KODE_SAMPEL_BARU');
									$arrmt['SPU_ID'] = $dataspu['SPU_ID'];
									$arrmt['STATUS'] = $this->input->post('STATUS');
									$this->db->insert('T_SAMPEL_MT', $arrmt);
									if($this->db->affected_rows() > 0){
										$jmlspu++;
									}
								}
								if($jmlspu > 0){
									$arrsampel = array('SPU_ID' => $dataspu['SPU_ID']);
									$this->db->where('KODE_SAMPEL', $this->input->post('KODE_SAMPEL_BARU'));
									$this->db->update('T_M_SAMPEL', $arrsampel);
									if($this->db->affected_rows() == 1){
										/**
										 * Update jumlah sampel yang dikirim ke bidang pengujian 
										 */
										$dtsampel = $sipt->main->post_to_query($this->input->post('SAMPEL'));
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
										$this->db->where('KODE_SAMPEL', $this->input->post('KODE_SAMPEL_BARU'));
										$this->db->update('T_M_SAMPEL', $dtsampel);
										if($this->db->affected_rows() == 1){
											$logspu = array('SPU_ID' => $dtspu['SPU_ID'],
														'WAKTU' => 'GETDATE()',
														'USER_ID' => $this->newsession->userdata('SESS_USER_ID'),
														'KEGIATAN' => 'Simpan data Surat Permintaan Uji : '.$dataspu['SPU_ID'],
														'CATATAN' => 'Kode sampel : '. $this->input->post('KODE_SAMPEL_BARU'));
											$this->db->insert('T_SPU_LOG', $logspu);				
											$arrrujukan = array('STATUS' => $this->input->post('STATUS'));
											$this->db->where('KODE_SAMPEL', $this->input->post('KODE_SAMPEL'));					
											$this->db->where('BBPOM_RUJUK', $this->newsession->userdata('SESS_BBPOM_ID'));					
											$this->db->update('T_SAMPEL_RUJUKAN', $arrrujukan);
											$hasil = TRUE;
											$redir = site_url().'/home/rujukan/sampel/deliver';
										}
									}
								}
							}
						}else{
							$hasil = FALSE;
						}
						
					}
					
					else if($this->input->post('STATUS') == '50205'){
						$substrkodebalai = substr($this->input->post('KODE_SAMPEL'), 2,3);
						$retkodebalai = substr($substrkodebalai, 0,1);
						if((int)$retkodebalai == 0){
							$bbpom_id = $sipt->main->get_uraian("SELECT BBPOM_ID FROM M_BBPOM WHERE KODE_BALAI = '".substr($substrkodebalai, 1, 2)."'","BBPOM_ID");
						}else{
							$bbpom_id = $sipt->main->get_uraian("SELECT BBPOM_ID FROM M_BBPOM WHERE KODE_BALAI = '".$substrkodebalai."'","BBPOM_ID");
						}
						$hasil = FALSE;
						$msgok = "Laporan berhasil dikirim";
						$msgerror = "Laporan gagal dikirim, Silahkan coba lagi";
						
						$awal_uji = $sipt->main->get_uraian("SELECT MIN(CONVERT(VARCHAR(10), AWAL_UJI, 120)) AS MINTGL FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL = '".$this->input->post('KODE_SAMPEL')."' GROUP BY KODE_SAMPEL","MINTGL");
						$akhir_uji = $sipt->main->get_uraian("SELECT MAX(CONVERT(VARCHAR(10), AKHIR_UJI, 120)) AS MAXTGL FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL = '".$this->input->post('KODE_SAMPEL')."' GROUP BY KODE_SAMPEL","MAXTGL");
						$query = "SELECT KODE_SAMPEL,KOMODITI,KATEGORI,ANGGARAN,ASAL_SAMPEL,CONVERT(VARCHAR(10), TANGGAL_SAMPLING, 103) AS TUJUAN_SAMPLING, SUB_TUJUAN, PRIORITAS, TANGGAL_SAMPLING,SARANA_ID,TEMPAT_SAMPLING,ALAMAT_SAMPLING,NAMA_SAMPEL,NOMOR_REGISTRASI,PABRIK,IMPORTIR,BENTUK_SEDIAAN,KEMASAN,NO_BETS,KETERANGAN_ED,JUMLAH_SAMPEL,SATUAN,HARGA_SAMPEL,UJI_KIMIA,JUMLAH_KIMIA,UJI_MIKRO,JUMLAH_MIKRO,SISA,KOMPOSISI,NETTO,KONDISI_SAMPEL,EVALUASI_PENANDAAN,CARA_PENYIMPANAN,HASIL_KIMIA,HASIL_MIKRO,HASIL_SAMPEL,PEMERIAN, LAMPIRAN, CATATAN_CP, UJI_RUJUK, BBPOM_RUJUK, JML_RUJUK, HASIL_KIMIA_RUJUK, HASIL_MIKRO_RUJUK, HASIL_SAMPEL_RUJUK, CATATAN_CP_RUJUK, JML_IRISAN, KOMODITI_IRISAN FROM T_M_SAMPEL WHERE KODE_SAMPEL = '".$this->input->post('KODE_SAMPEL')."'";
						$data = $sipt->main->get_result($query);
						if($data){
							$obj_hasil_rujukan = $this->db->query("SELECT LTRIM(RTRIM(HASIL_KIMIA)) AS HASIL_KIMIA, LTRIM(RTRIM(HASIL_MIKRO)) AS HASIL_MIKRO, LTRIM(RTRIM(HASIL_SAMPEL)) AS HASIL_SAMPEL FROM T_M_SAMPEL WHERE KODE_RUJUKAN = '".$this->input->post('KODE_SAMPEL')."'")->result_array();
							foreach($query->result_array() as $row){						
								$arrrilis['KODE_SAMPEL'] = $row['KODE_SAMPEL'];
								$arrrilis['BBPOM_ID'] = $bbpom_id;
								$arrrilis['KOMODITI'] = $row['KOMODITI'];
								$arrrilis['KATEGORI'] = $row['KATEGORI'];
								$arrrilis['ANGGARAN'] = $row['ANGGARAN'];
								$arrrilis['TUJUAN_SAMPLING'] = $row['TUJUAN_SAMPLING'];
								$arrrilis['AWAL_UJI'] = $awal_uji;
								$arrrilis['AKHIR_UJI'] = $akhir_uji;
								$arrrilis['SUB_TUJUAN'] = $row['SUB_TUJUAN'];
								$arrrilis['PRIORITAS'] = $row['PRIORITAS'];
								$arrrilis['NAMA_SAMPEL'] = $row['NAMA_SAMPEL'];
								$arrrilis['ASAL_SAMPEL'] = $row['ASAL_SAMPEL'];
								$arrrilis['TANGGAL_SAMPLING'] = $row['TANGGAL_SAMPLING'];
								$arrrilis['SARANA_ID'] = $row['SARANA_ID'];
								$arrrilis['TEMPAT_SAMPLING'] = $row['TEMPAT_SAMPLING'];
								$arrrilis['ALAMAT_SAMPLING'] = $row['ALAMAT_SAMPLING'];
								$arrrilis['NOMOR_REGISTRASI'] = $row['NOMOR_REGISTRASI'];
								$arrrilis['PABRIK'] = $row['PABRIK'];
								$arrrilis['IMPORTIR'] = $row['IMPORTIR'];
								$arrrilis['BENTUK_SEDIAAN'] = $row['BENTUK_SEDIAAN'];
								$arrrilis['KEMASAN'] = $row['KEMASAN'];
								$arrrilis['NO_BETS'] = $row['NO_BETS'];
								$arrrilis['KETERANGAN_ED'] = $row['KETERANGAN_ED'];
								$arrrilis['JUMLAH_SAMPEL'] = $row['JUMLAH_SAMPEL'];
								$arrrilis['SATUAN'] = $row['SATUAN'];
								$arrrilis['HARGA_SAMPEL'] = $row['HARGA_SAMPEL'];
								$arrrilis['UJI_KIMIA'] = $row['UJI_KIMIA'];
								$arrrilis['JUMLAH_KIMIA'] = $row['JUMLAH_KIMIA'];
								$arrrilis['UJI_MIKRO'] = $row['UJI_MIKRO'];
								$arrrilis['JUMLAH_MIKRO'] = $row['JUMLAH_MIKRO'];
								$arrrilis['SISA'] = $row['SISA'];
								$arrrilis['KOMPOSISI'] = $row['KOMPOSISI'];
								$arrrilis['NETTO'] = $row['NETTO'];
								$arrrilis['KONDISI_SAMPEL'] = $row['KONDISI_SAMPEL'];
								$arrrilis['EVALUASI_PENANDAAN'] = $row['EVALUASI_PENANDAAN'];
								$arrrilis['CARA_PENYIMPANAN'] = $row['CARA_PENYIMPANAN'];
								$arrrilis['HASIL_KIMIA'] = $row['HASIL_KIMIA'];
								$arrrilis['HASIL_MIKRO'] = $row['HASIL_MIKRO'];
								$arrrilis['HASIL_SAMPEL'] = $obj_hasil_rujukan[0]['HASIL_SAMPEL'];
								$arrrilis['UJI_RUJUK'] = $row['UJI_RUJUK'];
								$arrrilis['BBPOM_RUJUK'] = $row['BBPOM_RUJUK'];
								$arrrilis['JML_RUJUK'] = $row['JML_RUJUK'];
								$arrrilis['HASIL_KIMIA_RUJUK'] = $obj_hasil_rujukan[0]['HASIL_KIMIA'];
								$arrrilis['HASIL_MIKRO_RUJUK'] = $obj_hasil_rujukan[0]['HASIL_MIKRO'];
								$arrrilis['HASIL_SAMPEL_RUJUK'] = $obj_hasil_rujukan[0]['HASIL_SAMPEL'];
								$arrrilis['CATATAN_CP_RUJUK'] = $row['CATATAN_CP_RUJUK'];
								$arrrilis['JML_IRISAN'] = $row['JML_IRISAN'];
								$arrrilis['KOMODITI_IRISAN'] = $row['KOMODITI_IRISAN'];
								$arrrilis['PEMERIAN'] = $row['PEMERIAN'];
								$arrrilis['LAMPIRAN'] = $row['LAMPIRAN'];
								$arrrilis['CATATAN_CP'] = $row['CATATAN_CP'];
								$arrrilis['CREATE_BY'] = $this->newsession->userdata('SESS_USER_ID');
								$arrrilis['CREATE_DATE'] = 'GETDATE()';
								$arrrilis['STATUS'] = '80215';
								$this->db->insert('T_M_SAMPEL_RILIS',$arrrilis);
								if($this->db->affected_rows() > 0){
									$this->db->simple_query("SET DATEFORMAT DMY  UPDATE T_M_SAMPEL SET STATUS_SAMPEL = '80215', UPDATE_BY = '".$this->newsession->userdata('SESS_USER_ID')."', UPDATE_DATE = GETDATE() WHERE KODE_SAMPEL = '".$this->input->post('KODE_SAMPEL')."'");	
									$hasil = $sipt->main->get_uraian("SELECT RTRIM(LTRIM(HASIL_SAMPEL)) AS HASIL_SAMPEL FROM T_M_SAMPEL_RILIS WHERE KODE_SAMPEL = '".$this->input->post('KODE_SAMPEL')."'","HASIL_SAMPEL");
									if($hasil == "MS") $this->db->simple_query("UPDATE T_M_SAMPEL_RILIS SET STATUS_KIRIM = '1', STATUS_PPOMN = '1', ARSIP_SAMPEL = '1', STATUS = '80215', MONEV_PPOMN = '3' WHERE KODE_SAMPEL = '".$this->input->post('KODE_SAMPEL')."'");
									else  $this->db->simple_query("UPDATE T_M_SAMPEL_RILIS SET STATUS_KIRIM = '1', MONEV_PPOMN = '1', STATUS = '80215' WHERE KODE_SAMPEL = '".$this->input->post('KODE_SAMPEL')."'");
									
									$this->db->simple_query("UPDATE T_PARAMETER_HASIL_UJI SET STATUS = '80215' WHERE KODE_SAMPEL = '".$this->input->post('KODE_SAMPEL')."'");
									$param = "SELECT UJI_ID, SPK_ID, KODE_SAMPEL, GOLONGAN, PARAMETER_UJI, SIMULAN, KATEGORI_PU, METODE, PUSTAKA, SYARAT, RUANG_LINGKUP, PEMERIAN, IDENTIFIKASI, JENIS_UJI, SYARAT_UJI, JUMLAH_UJI, SISA_UJI, REAGEN, JUMLAH_REAGEN, HASIL, HASIL_KUALITATIF, HASIL_PARAMETER, CATATAN, PENYELIA, PENGUJI, AWAL_UJI, AKHIR_UJI, LCP, STATUS, UJI_MAMPU FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL = '".$this->input->post('KODE_SAMPEL')."'";
									$dparam = $sipt->main->get_result($param);
									if($dparam){
										foreach($param->result_array() as $rparam){
											$arrparam['UJI_ID'] = $rparam['UJI_ID'];
											$arrparam['SPK_ID'] = $rparam['SPK_ID'];
											$arrparam['KODE_SAMPEL'] = $rparam['KODE_SAMPEL'];
											$arrparam['GOLONGAN'] = $rparam['GOLONGAN'];
											$arrparam['PARAMETER_UJI'] = $rparam['PARAMETER_UJI'];
											$arrparam['SIMULAN'] = $rparam['SIMULAN'];
											$arrparam['KATEGORI_PU'] = $rparam['KATEGORI_PU'];
											$arrparam['METODE'] = $rparam['METODE'];
											$arrparam['PUSTAKA'] = $rparam['PUSTAKA'];
											$arrparam['SYARAT'] = $rparam['SYARAT'];
											$arrparam['RUANG_LINGKUP'] = $rparam['RUANG_LINGKUP'];
											$arrparam['PEMERIAN'] = $rparam['PEMERIAN'];
											$arrparam['IDENTIFIKASI'] = $rparam['IDENTIFIKASI'];
											$arrparam['JENIS_UJI'] = $rparam['JENIS_UJI'];
											$arrparam['SYARAT_UJI'] = $rparam['SYARAT_UJI'];
											$arrparam['JUMLAH_UJI'] = $rparam['JUMLAH_UJI'];
											$arrparam['SISA_UJI'] = $rparam['SISA_UJI'];
											$arrparam['REAGEN'] = $rparam['REAGEN'];
											$arrparam['JUMLAH_REAGEN'] = $rparam['JUMLAH_REAGEN'];
											$arrparam['HASIL'] = $rparam['HASIL'];
											$arrparam['HASIL_KUALITATIF'] = $rparam['HASIL_KUALITATIF'];
											$arrparam['HASIL_PARAMETER'] = $rparam['HASIL_PARAMETER'];
											$arrparam['CATATAN'] = $rparam['CATATAN'];
											$arrparam['PENYELIA'] = $rparam['PENYELIA'];
											$arrparam['PENGUJI'] = $rparam['PENGUJI'];
											$arrparam['AWAL_UJI'] = $rparam['AWAL_UJI'];
											$arrparam['AKHIR_UJI'] = $rparam['AKHIR_UJI'];
											$arrparam['LCP'] = $rparam['LCP'];
											$arrparam['UJI_MAMPU'] = $rparam['UJI_MAMPU'];
											$arrparam['STATUS'] = $rparam['STATUS'];
											$this->db->insert('T_PARAMETER_HASIL_UJI_RILIS',$arrparam);
										}
									}
									$hasil = TRUE;
									$redir = site_url().'/home/pengujian/rujukan/hasil';
								}
							}
						}
					}
					
				}
				if($hasil){
					return "MSG#YES#$msgok#".$redir;
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
	
	function set_kirim($action, $isajax){
		if(in_array('5',$this->newsession->userdata('SESS_KODE_ROLE')) && $this->newsession->userdata('LOGGED_IN') == TRUE){
			$sipt =& get_instance();
			$sipt->load->model("main","main", true);
			if($action == "rujuk"){
				$ret = "MSG#Data Gagal Dikirim.";
				foreach($this->input->post('tb_chk') as $a){
					$get_obj_surat = $this->db->query("SELECT A.KODE_SAMPEL, dbo.KATEGORI(A.KOMODITI, A.PRIORITAS) AS KOMODITI, A.NAMA_SAMPEL, A.NOMOR_REGISTRASI, A.IMPORTIR, A.PABRIK, A.KEMASAN, A.NO_BETS, A.KETERANGAN_ED, CONVERT(VARCHAR(10), A.TANGGAL_SAMPLING, 103) AS TANGGAL_SAMPLING, A.TEMPAT_SAMPLING, A.KOMPOSISI, A.SATUAN, B.JUMLAH_SAMPEL, C.BBPOM_ID AS BBPOM_ID_TUJUAN, C.NAMA_BBPOM AS BBPOM_NAMA_TUJUAN, D.BBPOM_ID AS BBPOM_ID_PENGIRIM, D.NAMA_BBPOM AS BBPOM_NAMA_PENGIRIM, D.KOTA
						FROM T_M_SAMPEL A LEFT JOIN T_SAMPEL_RUJUKAN B ON A.KODE_SAMPEL = B.KODE_SAMPEL
						LEFT JOIN M_BBPOM C ON B.BBPOM_RUJUK = C.BBPOM_ID
						LEFT JOIN M_BBPOM D ON B.BBPOM_ASAL = D.BBPOM_ID
						WHERE A.KODE_SAMPEL = '".$a."'")->result_array();
					$get_obj_kbalai = $this->db->query("SELECT NAMA_USER, USER_ID FROM T_USER WHERE
USER_ID IN (SELECT USER_ID FROM T_USER_ROLE WHERE ROLE IN ('5')) AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND STATUS = 'Aktif'")->result_array();
					$get_obj_tanggal_selesai = $this->db->query("SELECT MAX(CONVERT(VARCHAR(10), AKHIR_UJI, 120)) AS MAXTGL FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL = '".$a."' GROUP BY KODE_SAMPEL")->result_array();
					$arr_tgl_selesai = explode("-", $get_obj_tanggal_selesai[0]['MAXTGL']);
					$arr_tgl_selesai = $arr_tgl_selesai[2] . '/' . $arr_tgl_selesai[1] . '/' . $arr_tgl_selesai[0];
					$arr_surat = array( 'KODE_SAMPEL' => $get_obj_surat[0]['KODE_SAMPEL'],
										'SERI' => (int)$sipt->main->get_uraian("SELECT MAX(SERI) AS SERI FROM T_SURAT_PENGANTAR_RUJUKAN WHERE KODE_SAMPEL = '".$a."'","SERI") + 1,
										'KOTA' => $get_obj_surat[0]['KOTA'],
										'TANGGAL_SURAT' => 'GETDATE()',
										'NOMOR_SURAT' => '-',
										'BBPOM_ID_TUJUAN' => $get_obj_surat[0]['BBPOM_ID_TUJUAN'],
										'BBPOM_NAMA_TUJUAN' => $get_obj_surat[0]['BBPOM_NAMA_TUJUAN'],
										'BBPOM_ID_PENGIRIM' => $get_obj_surat[0]['BBPOM_ID_PENGIRIM'],
										'BBPOM_NAMA_PENGIRIM' => $get_obj_surat[0]['BBPOM_NAMA_PENGIRIM'],
										'TANGGAL_SELESAI_UJI' => $arr_tgl_selesai,
										'KOMODITI' => $get_obj_surat[0]['KOMODITI'],
										'NAMA_SAMPEL' => $get_obj_surat[0]['NAMA_SAMPEL'],
										'NOMOR_REGISTRASI' => $get_obj_surat[0]['NOMOR_REGISTRASI'],
										'PABRIK' => $get_obj_surat[0]['PABRIK'],
										'IMPORTIR' => $get_obj_surat[0]['IMPORTIR'],
										'KEMASAN' => $get_obj_surat[0]['KEMASAN'],
										'NO_BETS' => $get_obj_surat[0]['NO_BETS'],
										'KETERANGAN_ED' => $get_obj_surat[0]['KETERANGAN_ED'],
										'TANGGAL_SAMPLING' => $get_obj_surat[0]['TANGGAL_SAMPLING'],
										'TEMPAT_SAMPLING' => $get_obj_surat[0]['TEMPAT_SAMPLING'],
										'KOMPOSISI' => $get_obj_surat[0]['KOMPOSISI'],
										'JUMLAH_SAMPEL' => (float)$get_obj_surat[0]['JUMLAH_SAMPEL'],
										'SATUAN' => $get_obj_surat[0]['SATUAN'],
										'NAMA_KEPALA_BALAI' => $get_obj_kbalai[0]['NAMA_USER'],
										'NIP_KEPALA_BALAI' => $get_obj_kbalai[0]['USER_ID'],
										'CREATE_BY' => $this->newsession->userdata('SESS_USER_ID'),
										'CREATE_DATE' => 'GETDATE()' );
					$this->db->insert('T_SURAT_PENGANTAR_RUJUKAN', $arr_surat);
					if($this->db->affected_rows() > 0)
					{
						$this->db->simple_query("UPDATE T_M_SAMPEL SET STATUS_SAMPEL = '70011' WHERE KODE_SAMPEL = '".$a."'");
						$this->db->simple_query("UPDATE T_SAMPEL_RUJUKAN SET STATUS_RUJUKAN = 1, STATUS = '70011' WHERE KODE_SAMPEL = '".$a."'");
						$data = array('KODE_SAMPEL' => $a,
									  'WAKTU' => 'GETDATE()',
									  'USER_ID' => $this->newsession->userdata('SESS_USER_ID'),
									  'KEGIATAN' => 'Mengirim data sampel rujukan dengan kode sampel : '. $a,
									  'CATATAN' => '-');
						$this->db->insert('T_SAMPLING_LOG', $data);
						$ret = "MSG#Data Berhasil Dikirim#";
					}

				}
				if($isajax!="ajax"){
					redirect(base_url());
					exit();
				}
			}
			else if($action == "hasil")
			{
				
			}
			else if($action == "feed-back")
			{
				$ret = "MSG#Data Gagal Dikirim.";
				foreach($this->input->post('tb_chk') as $a){
					$awal_uji = $sipt->main->get_uraian("SELECT MIN(CONVERT(VARCHAR(10), AWAL_UJI, 120)) AS MINTGL FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL = '".$a."' GROUP BY KODE_SAMPEL","MINTGL");
					$akhir_uji = $sipt->main->get_uraian("SELECT MAX(CONVERT(VARCHAR(10), AKHIR_UJI, 120)) AS MAXTGL FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL = '".$a."' GROUP BY KODE_SAMPEL","MAXTGL");
					$query = "SELECT KODE_SAMPEL, BBPOM_ID, KOMODITI,KATEGORI, NAMA_KATEGORI, ANGGARAN,ASAL_SAMPEL,CONVERT(VARCHAR(10), TANGGAL_SAMPLING, 103) AS TANGGAL_SAMPLING, SUB_TUJUAN, PRIORITAS, TUJUAN_SAMPLING, SARANA_ID,TEMPAT_SAMPLING,ALAMAT_SAMPLING,NAMA_SAMPEL,NOMOR_REGISTRASI,PABRIK,IMPORTIR,BENTUK_SEDIAAN,KEMASAN,NO_BETS,KETERANGAN_ED,JUMLAH_SAMPEL,SATUAN,HARGA_SAMPEL,UJI_KIMIA,JUMLAH_KIMIA,UJI_MIKRO,JUMLAH_MIKRO,SISA,KOMPOSISI,NETTO,KONDISI_SAMPEL,EVALUASI_PENANDAAN,CARA_PENYIMPANAN,HASIL_KIMIA,HASIL_MIKRO, RTRIM(LTRIM(HASIL_SAMPEL)) AS HASIL_SAMPEL,PEMERIAN, LAMPIRAN, CATATAN_CP, CASE WHEN UJI_RUJUK IS NOT NULL THEN UJI_RUJUK ELSE 0 END AS UJI_RUJUK, CASE WHEN UJI_UNGGULAN IS NOT NULL THEN UJI_UNGGULAN ELSE 0 END AS UJI_UNGGULAN, BBPOM_RUJUK, JML_RUJUK, HASIL_KIMIA_RUJUK, HASIL_MIKRO_RUJUK, HASIL_SAMPEL_RUJUK, CATATAN_CP_RUJUK, JML_IRISAN, KOMODITI_IRISAN, CREATE_BY FROM T_M_SAMPEL WHERE KODE_SAMPEL = '".$a."'";
					$data = $sipt->main->get_result($query);
					if($data){
						foreach($query->result_array() as $row){						
							$arrrilis['KODE_SAMPEL'] = $row['KODE_SAMPEL'];
							$arrrilis['BBPOM_ID'] = $row['BBPOM_ID'];
							$arrrilis['KOMODITI'] = $row['KOMODITI'];
							$arrrilis['KATEGORI'] = $row['KATEGORI'];
							$arrrilis['NAMA_KATEGORI'] = $row['NAMA_KATEGORI'];
							$arrrilis['ANGGARAN'] = $row['ANGGARAN'];
							$arrrilis['TUJUAN_SAMPLING'] = $row['TUJUAN_SAMPLING'];
							$arrrilis['AWAL_UJI'] = $awal_uji;
							$arrrilis['AKHIR_UJI'] = $akhir_uji;
							$arrrilis['SUB_TUJUAN'] = $row['SUB_TUJUAN'];
							$arrrilis['PRIORITAS'] = $row['PRIORITAS'];
							$arrrilis['NAMA_SAMPEL'] = $row['NAMA_SAMPEL'];
							$arrrilis['ASAL_SAMPEL'] = $row['ASAL_SAMPEL'];
							$arrrilis['TANGGAL_SAMPLING'] = $row['TANGGAL_SAMPLING'];
							$arrrilis['SARANA_ID'] = $row['SARANA_ID'];
							$arrrilis['TEMPAT_SAMPLING'] = $row['TEMPAT_SAMPLING'];
							$arrrilis['ALAMAT_SAMPLING'] = $row['ALAMAT_SAMPLING'];
							$arrrilis['NOMOR_REGISTRASI'] = $row['NOMOR_REGISTRASI'];
							$arrrilis['PABRIK'] = $row['PABRIK'];
							$arrrilis['IMPORTIR'] = $row['IMPORTIR'];
							$arrrilis['BENTUK_SEDIAAN'] = $row['BENTUK_SEDIAAN'];
							$arrrilis['KEMASAN'] = $row['KEMASAN'];
							$arrrilis['NO_BETS'] = $row['NO_BETS'];
							$arrrilis['KETERANGAN_ED'] = $row['KETERANGAN_ED'];
							$arrrilis['JUMLAH_SAMPEL'] = $row['JUMLAH_SAMPEL'];
							$arrrilis['SATUAN'] = $row['SATUAN'];
							$arrrilis['HARGA_SAMPEL'] = $row['HARGA_SAMPEL'];
							$arrrilis['UJI_KIMIA'] = (int)$row['UJI_KIMIA'];
							$arrrilis['JUMLAH_KIMIA'] = (float)$row['JUMLAH_KIMIA'];
							$arrrilis['UJI_MIKRO'] = (int)$row['UJI_MIKRO'];
							$arrrilis['JUMLAH_MIKRO'] = (float)$row['JUMLAH_MIKRO'];
							$arrrilis['SISA'] = (float)$row['SISA'];
							$arrrilis['KOMPOSISI'] = $row['KOMPOSISI'];
							$arrrilis['NETTO'] = $row['NETTO'];
							$arrrilis['KONDISI_SAMPEL'] = $row['KONDISI_SAMPEL'];
							$arrrilis['EVALUASI_PENANDAAN'] = $row['EVALUASI_PENANDAAN'];
							$arrrilis['CARA_PENYIMPANAN'] = $row['CARA_PENYIMPANAN'];
							$arrrilis['HASIL_KIMIA'] = $row['HASIL_KIMIA'];
							$arrrilis['HASIL_MIKRO'] = $row['HASIL_MIKRO'];
							$arrrilis['UJI_UNGGULAN'] = $row['UJI_UNGGULAN'];
							$arrrilis['HASIL_SAMPEL'] = $row['HASIL_SAMPEL'];
							if($row['HASIL_SAMPEL'] == "MS")
							{
								$arrrilis['STATUS_PPOMN'] = 1;
								$arrrilis['ARSIP_SAMPEL'] = 1;
								$arrrilis['MONEV_PPOMN'] = 3;
							}
							else
							{
								$arrrilis['MONEV_PPOMN'] = 1;
							}
							$arrrilis['UJI_RUJUK'] = (int)$row['UJI_RUJUK'];
							$arrrilis['UJI_UNGGULAN'] = (int)$row['UJI_UNGGULAN'];
							$arrrilis['BBPOM_RUJUK'] = $row['BBPOM_RUJUK'];
							$arrrilis['JML_RUJUK'] = $row['JML_RUJUK'];
							$arrrilis['HASIL_KIMIA_RUJUK'] = $row['HASIL_KIMIA_RUJUK'];
							$arrrilis['HASIL_MIKRO_RUJUK'] = $row['HASIL_MIKRO_RUJUK'];
							$arrrilis['HASIL_SAMPEL_RUJUK'] = $row['HASIL_SAMPEL_RUJUK'];
							$arrrilis['CATATAN_CP_RUJUK'] = $row['CATATAN_CP_RUJUK'];
							$arrrilis['JML_IRISAN'] = $row['JML_IRISAN'];
							$arrrilis['KOMODITI_IRISAN'] = $row['KOMODITI_IRISAN'];
							$arrrilis['PEMERIAN'] = $row['PEMERIAN'];
							$arrrilis['LAMPIRAN'] = $row['LAMPIRAN'];
							$arrrilis['CATATAN_CP'] = $row['CATATAN_CP'];
							$arrrilis['CREATE_BY'] = $row['CREATE_BY'];
							$arrrilis['CREATE_DATE'] = 'GETDATE()';
							$arrrilis['STATUS'] = '80215';
							$arrrilis['STATUS_KIRIM'] = 1;
							$arrrilis['TANGGAL_KIRIM'] = 'GETDATE()';
							$this->db->insert('T_M_SAMPEL_RILIS',$arrrilis);
							if($this->db->affected_rows() > 0)
							{
								insert_rkpsampel_helper($a);
								$this->db->simple_query("UPDATE T_M_SAMPEL SET STATUS_SAMPEL = '80215' WHERE KODE_SAMPEL = '".$a."'");
								$data = array('KODE_SAMPEL' => $a,
											  'WAKTU' => 'GETDATE()',
											  'USER_ID' => $this->newsession->userdata('SESS_USER_ID'),
											  'KEGIATAN' => 'Mengirim data sampel rujukan ke balai asal dengan kode sampel : '. $a,
											  'CATATAN' => '-');
								$this->db->insert('T_SAMPLING_LOG', $data);
								$ret = "MSG#Data Berhasil Dikirim#";
							}
							
						}
					}
				}
				if($isajax!="ajax"){
					redirect(base_url());
					exit();
				}
			}
			return $ret;
		}
	}
	
	function set_copy($id){
		$sipt =& get_instance();
		$sipt->load->model('main','main',true);
		$ret = FALSE;
		$sql_surat =  "SELECT CONVERT(VARCHAR(10), A.TANGGAL_SURAT, 103) AS TANGGAL_SURAT, A.NOMOR_SURAT, A.BBPOM_ID_TUJUAN, A.BBPOM_NAMA_PENGIRIM, B.PETUGAS_PENERIMA
					  FROM T_SURAT_PENGANTAR_RUJUKAN A LEFT JOIN T_SAMPEL_RUJUKAN B ON A.KODE_SAMPEL = B.KODE_SAMPEL
					  WHERE A.KODE_SAMPEL = '".$id."'";
		$obj_surat = $sipt->main->get_result($sql_surat);
		if($obj_surat)
		{
			foreach($sql_surat->result_array() as $row_surat)
			{
				$arr_surat_tugas['PERIKSA_SAMPEL'] = (int)$sipt->main->get_uraian("SELECT MAX(PERIKSA_SAMPEL) AS MAXID FROM T_PERIKSA_SAMPEL", "MAXID") + 1;
				$arr_surat_tugas['BBPOM_ID'] = $row_surat['BBPOM_ID_TUJUAN'];
				$arr_surat_tugas['NOMOR_SURAT'] = $row_surat['NOMOR_SURAT'];
				$arr_surat_tugas['TANGGAL_SURAT'] = $row_surat['TANGGAL_SURAT'];
				$arr_surat_tugas['NAMA_PENGIRIM'] = $row_surat['BBPOM_NAMA_PENGIRIM'];
				$arr_surat_tugas['TANGGAL_SPDP'] = null;
				$arr_surat_tugas['TANGGAL_TERIMA'] = null;
				$arr_surat_tugas['TANGGAL_RESI_BANK'] = null;
				$arr_surat_tugas['CREATE_BY'] = $row_surat['PETUGAS_PENERIMA'];
				$arr_surat_tugas['CREATE_DATE'] = 'GETDATE()';
			}
			$this->db->insert('T_PERIKSA_SAMPEL', $arr_surat_tugas);
			if($this->db->affected_rows() > 0 )
			{
				$arr_petugas['PERIKSA_SAMPEL'] = $arr_surat_tugas['PERIKSA_SAMPEL'];
				$arr_petugas['USER_ID'] = $arr_surat_tugas['CREATE_BY'];
				$this->db->insert('T_PETUGAS_SAMPEL', $arr_petugas);
				if($this->db->affected_rows() > 0)
				{
					$query = "SELECT KODE_SAMPEL ,SPU_ID ,KOMODITI ,KATEGORI, NAMA_KATEGORI, REKAP_KOMODITI ,ANGGARAN ,ASAL_SAMPEL ,TUJUAN_SAMPLING ,SUB_TUJUAN ,PRIORITAS ,CONVERT(VARCHAR(10), TANGGAL_SAMPLING, 103) AS TANGGAL_SAMPLING ,BULAN_ANGGARAN ,SARANA_ID ,TEMPAT_SAMPLING ,ALAMAT_SAMPLING ,KLASIFIKASI_TAMBAHAN ,NAMA_SAMPEL ,NOMOR_REGISTRASI ,PABRIK ,IMPORTIR ,BENTUK_SEDIAAN ,KEMASAN ,NO_BETS ,KETERANGAN_ED ,JUMLAH_SAMPEL ,SATUAN ,HARGA_SAMPEL ,UJI_KIMIA ,JUMLAH_KIMIA ,UJI_MIKRO ,JUMLAH_MIKRO ,UJI_BIO ,JUMLAH_BIO ,SISA ,SISA_KIMIA ,SISA_MIKRO ,SISA_BIO ,TEMPAT_SISA_KIMIA ,TEMPAT_SISA_MIKRO ,KOMPOSISI ,NETTO ,KONDISI_SAMPEL ,EVALUASI_PENANDAAN ,CARA_PENYIMPANAN ,PEMERIAN ,SEGEL ,LABEL ,HASIL_KIMIA ,HASIL_MIKRO ,HASIL_BIO ,HASIL_SAMPEL ,UJI_RUJUK ,BBPOM_ASAL ,BBPOM_RUJUK ,JML_RUJUK ,HASIL_KIMIA_RUJUK ,HASIL_MIKRO_RUJUK ,HASIL_SAMPEL_RUJUK ,LAMPIRAN ,CATATAN ,CATATAN_CP ,CATATAN_CP_RUJUK ,STATUS_KIMIA ,STATUS_MIKRO ,STATUS_SAMPEL ,JML_IRISAN ,KOMODITI_IRISAN ,TEMBUSAN ,CREATE_BY, KODE_RUJUKAN, NAMA_KATEGORI FROM T_M_SAMPEL WHERE KODE_SAMPEL = '".$id."'";
					$data = $sipt->main->get_result($query);
					if($data)
					{
						foreach($query->result_array() as $row){
							$arrdata = $row;
						}
						
						$labs = $this->db->query("SELECT CASE WHEN JENIS_UJI = '01' THEN 1 END AS MIKRO, CASE WHEN JENIS_UJI = '02' THEN 1 END AS KIMIA FROM (SELECT DISTINCT(JENIS_UJI) AS JENIS_UJI, BBPOM_ID FROM T_SAMPEL_RUJUKAN_DETIL WHERE KODE_SAMPEL = '".$id."' AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."') AS DATA ")->result_array();
						
						$jmlsampel = $this->db->query("SELECT KODE_SAMPEL, SUM((CASE WHEN JENIS_UJI='01' THEN JUMLAH_SAMPEL ELSE 0 END)) JML_SAMPLE_01, SUM((CASE WHEN JENIS_UJI='02' THEN JUMLAH_SAMPEL ELSE 0 END)) JML_SAMPLE_02 FROM T_SAMPEL_RUJUKAN_DETIL WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND KODE_SAMPEL ='".$id."' GROUP BY  KODE_SAMPEL")->result_array();
						unset($arrdata['KODE_SAMPEL']);
						unset($arrdata['UJI_KIMIA']);
						unset($arrdata['UJI_MIKRO']);
						unset($arrdata['STATUS_KIMIA']);
						unset($arrdata['STATUS_MIKRO']);
						unset($arrdata['STATUS_SAMPEL']);
						unset($arrdata['UJI_RUJUK']);
						if((int)$labs[0]['KIMIA'] == 1 && (int)$labs[0]['MIKRO'] == 1){
							$lab = 'KM';
							$arrdata['UJI_KIMIA'] = 1;
							$arrdata['UJI_MIKRO'] = 1;
							$arrdata['JUMLAH_KIMIA'] = $jmlsampel[0]['JML_SAMPLE_02'];
							$arrdata['JUMLAH_MIKRO'] = $jmlsampel[0]['JML_SAMPLE_01'];
							$arrdata['SISA_KIMIA'] = 0;
							$arrdata['SISA_MIKRO'] = 0;
						}else if((int)$labs[0]['KIMIA'] == 1 && (int)$labs[0]['MIKRO'] == 0){
							$lab = 'K';
							$arrdata['UJI_KIMIA'] = 1;				
							$arrdata['UJI_MIKRO'] = 0;
							$arrdata['JUMLAH_KIMIA'] = $jmlsampel[0]['JML_SAMPLE_02'];
							$arrdata['JUMLAH_MIKRO'] = 0;
							$arrdata['SISA_KIMIA'] = 0;
							$arrdata['SISA_MIKRO'] = 0;
						}else if((int)$labs[0]['KIMIA'] == 0 && (int)$labs[0]['MIKRO'] == 1){
							$lab = 'M';
							$arrdata['UJI_KIMIA'] = 0;
							$arrdata['UJI_MIKRO'] = 1;
							$arrdata['JUMLAH_MIKRO'] = $jmlsampel[0]['JML_SAMPLE_01'];
							$arrdata['JUMLAH_KIMIA'] = 0;
							$arrdata['SISA_KIMIA'] = 0;
							$arrdata['SISA_MIKRO'] = 0;
						}
						/**
						 *  @06 : Tujuan Sampling => Rujukan / Uji Absah
						 *  @12 : Anggaran Sampling => Rujukan / Uji Absah
						 */
						$arrdata['PERIKSA_SAMPEL'] = $arr_surat_tugas['PERIKSA_SAMPEL'];
						$arrdata['KODE_SAMPEL'] = $sipt->main->set_kode_sampel('06', '12', $arrdata['KOMODITI'], $lab,$arrdata['TANGGAL_SAMPLING']);
						$arrdata['SPU_ID'] = 0;
						$arrdata['STATUS_KIMIA'] = 0;
						$arrdata['STATUS_MIKRO'] = 0;
						$arrdata['UJI_RUJUK'] = 0;
						$arrdata['STATUS_SAMPEL'] = '70012'; 
						$arrdata['HASIL_SAMPEL'] = NULL;
						$arrdata['HASIL_KIMIA'] = NULL;
						$arrdata['HASIL_MIKRO'] = NULL;
						$arrdata['KODE_RUJUKAN'] = $id;
						$arrdata['BBPOM_ID'] = $this->newsession->userdata('SESS_BBPOM_ID');
						$arrdata['CREATE_BY'] = $this->newsession->userdata('SESS_USER_ID');
						$this->db->insert('T_M_SAMPEL', $arrdata);
						if($this->db->affected_rows() > 0){
							$ret = TRUE;
						}
					}
				}
			}
		}
		return $ret;
	}
	
}
?>