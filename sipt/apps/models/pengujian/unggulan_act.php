<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR);
class Unggulan_act extends Model{
	function list_unggulan($status){
		if(in_array('5', $this->newsession->userdata('SESS_KODE_ROLE')) && $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$this->load->library('newtable');
			if($status == "hasil"){
				$judul = "Hasil Uji Unggulan";
				$query = "SELECT A.KODE_SAMPEL, A.NAMA_SAMPEL + '<div>' + dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) + '</div><div>' + A.BENTUK_SEDIAAN + '</div><div>' + A.PABRIK + '</div><div>' + A.NOMOR_REGISTRASI + ', No Batch  : ' +  A.NO_BETS + '</div><div>'+A.TEMPAT_SAMPLING+'</div>' AS [IDENTITAS SAMPEL], CAST(A.JUMLAH_SAMPEL AS VARCHAR) +'&nbsp;'+ A.SATUAN +'<div>&bull;&nbsp;Uji Kimia : '+ CAST(A.JUMLAH_KIMIA AS VARCHAR)+'</div><div>&bull;&nbsp;Uji Mikro : '+CAST(A.JUMLAH_MIKRO AS VARCHAR) +'</div><div>&bull;&nbsp;Sisa Sampel : '+CAST(A.SISA AS VARCHAR) +'</div><div>' +CASE WHEN A.UJI_KIMIA = '1' AND A.UJI_MIKRO = '1' THEN 'Uji Kimia - Mikro' WHEN A.UJI_KIMIA = '1' THEN 'Uji Kimia' WHEN A.UJI_MIKRO = '1' THEN 'Uji Mikro' END+ '</div>' AS [JUMLAH UJI], dbo.KATEGORI(A.KOMODITI,A.PRIORITAS) + '<div>' + dbo.KATEGORI(A.KATEGORI,A.PRIORITAS) + '</div>' AS KOMODITI, '<div>Hasil Uji Kimia : ' + A.HASIL_KIMIA + '</div><div>Hasil Uji Mikro : ' + A.HASIL_MIKRO + '</div><div>Hasil Sampel : ' + A.HASIL_SAMPEL + '</div>' AS HASIL , D.NAMA_BBPOM +'<div>' + dbo.FORMAT_NOMOR('SPL',C.KODE_SAMPEL) + '</div>' [BALAI ASAL] , CONVERT(VARCHAR(10), A.CREATE_DATE, 120) AS SORTTGL FROM T_M_SAMPEL_RILIS A LEFT JOIN T_M_SAMPEL B ON B.KODE_SAMPEL = A.KODE_SAMPEL LEFT JOIN T_M_SAMPEL C ON C.KODE_SAMPEL = B.KODE_UNGGULAN LEFT JOIN M_BBPOM D ON D.BBPOM_ID = C.BBPOM_ID WHERE A.BBPOM_ID='".$this->newsession->userdata('SESS_BBPOM_ID')."' AND A.STATUS='50202' AND A.UJI_UNGGULAN='1'";
				$this->newtable->search(array(array("A.NAMA_SAMPEL","Nama Sampel"),array("dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL)","Kode Sampel"),array("A.TEMPAT_SAMPLING","Tempat Sampling"),array("dbo.KATEGORI(A.KOMODITI,A.PRIORITAS)","Komoditi"),array("dbo.KATEGORI(A.KATEGORI,A.PRIORITAS)","Kategori")));
				$this->newtable->columns(array("A.KODE_SAMPEL", array("A.NAMA_SAMPEL + '<div>' + dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) + '</div><div>' + A.BENTUK_SEDIAAN + '</div><div>' + A.PABRIK + '</div><div>' + A.NOMOR_REGISTRASI + ', No Batch  : ' +  A.NO_BETS + '</div><div>'+A.TEMPAT_SAMPLING+'</div>'",site_url()."/home/unggulan/previewrilis/sampel/{KODE_SAMPEL}"),"CAST(A.JUMLAH_SAMPEL AS VARCHAR) +'&nbsp;'+ A.SATUAN +'<div>&bull;&nbsp;Uji Kimia : '+ CAST(A.JUMLAH_KIMIA AS VARCHAR)+'</div><div>&bull;&nbsp;Uji Mikro : '+CAST(A.JUMLAH_MIKRO AS VARCHAR) +'</div><div>&bull;&nbsp;Sisa Sampel : '+CAST(A.SISA AS VARCHAR) +'</div><div>' +CASE WHEN A.UJI_KIMIA = '1' AND A.UJI_MIKRO = '1' THEN 'Uji Kimia - Mikro' WHEN A.UJI_KIMIA = '1' THEN 'Uji Kimia' WHEN A.UJI_MIKRO = '1' THEN 'Uji Mikro' END+ '</div>'", "dbo.KATEGORI(A.KOMODITI,A.PRIORITAS) + '<div>' + dbo.KATEGORI(A.KATEGORI,A.PRIORITAS) + '</div>'","'<div>Hasil Uji Kimia : ' + A.HASIL_KIMIA + '</div><div>A.Hasil Uji Mikro : ' + A.HASIL_MIKRO + '</div><div>Hasil : ' + A.HASIL_SAMPEL + '</div>'"," CONVERT(VARCHAR(10), A.CREATE_DATE, 120)"));
				$this->newtable->width(array('IDENTITAS SAMPEL' => 225, 'JUMLAH UJI' => 85, 'KOMODITI' => 250, 'HASIL' => 105, 'BALAI ASAL' => 205));
				$proses['Kirim Data Hasil Unggulan'] = array('POST', site_url().'/post/unggulan/kirim_act/unggul/ajax', 'N');
				$proses['Preview Data'] = array('GET', site_url().'/home/unggulan/previewrilis/sampel', '1');
			}else if($status == "rekom"){
				$judul = "Daftar Sampel Unggulan Selesai di proses";
				$query = "SELECT A.KODE_SAMPEL, A.NAMA_SAMPEL + '<div>' + dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) + '</div><div>' + A.BENTUK_SEDIAAN + '</div><div>' + A.PABRIK + '</div><div>' + A.NOMOR_REGISTRASI + ', No Batch  : ' +  A.NO_BETS + '</div><div>'+A.TEMPAT_SAMPLING+'</div>' AS [IDENTITAS SAMPEL], CAST(A.JUMLAH_SAMPEL AS VARCHAR) +'&nbsp;'+ A.SATUAN +'<div>&bull;&nbsp;Uji Kimia : '+ CAST(A.JUMLAH_KIMIA AS VARCHAR)+'</div><div>&bull;&nbsp;Uji Mikro : '+CAST(A.JUMLAH_MIKRO AS VARCHAR) +'</div><div>&bull;&nbsp;Sisa Sampel : '+CAST(A.SISA AS VARCHAR) +'</div><div>' +CASE WHEN A.UJI_KIMIA = '1' AND A.UJI_MIKRO = '1' THEN 'Uji Kimia - Mikro' WHEN A.UJI_KIMIA = '1' THEN 'Uji Kimia' WHEN A.UJI_MIKRO = '1' THEN 'Uji Mikro' END+ '</div>' AS [JUMLAH UJI], dbo.KATEGORI(A.KOMODITI,A.PRIORITAS) + '<div>' + dbo.KATEGORI(A.KATEGORI,A.PRIORITAS) + '</div>' AS KOMODITI, '<div>Hasil Uji Kimia : ' + A.HASIL_KIMIA + '</div><div>Hasil Uji Mikro : ' + A.HASIL_MIKRO + '</div><div>Hasil Sampel : ' + A.HASIL_SAMPEL + '</div><div>&nbsp;</div><div><b>Balai Unggulan</b></div><div>Hasil Uji Kimia : ' + D.HASIL_KIMIA + '</div><div>Hasil Uji Mikro : ' + D.HASIL_MIKRO + '</div><div>Hasil Sampel : ' + D.HASIL_SAMPEL + '</div>' AS HASIL, E.NAMA_BBPOM AS [BALAI UNGGULAN], CONVERT(VARCHAR(10), A.UPDATE_DATE, 120) AS SORTTGL FROM T_M_SAMPEL A LEFT JOIN T_PERIKSA_SAMPEL B ON A.PERIKSA_SAMPEL = B.PERIKSA_SAMPEL LEFT JOIN T_SAMPEL_UNGGULAN C ON C.KODE_SAMPEL = A.KODE_SAMPEL LEFT JOIN T_M_SAMPEL D ON D.KODE_UNGGULAN = C.KODE_SAMPEL LEFT JOIN M_BBPOM E ON E.BBPOM_ID = C.BBPOM_UNGGULAN WHERE C.BBPOM_ASAL = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND C.STATUS IN ('50206') AND C.STATUS_UNGGULAN='2'";
				//echo $query;die();
				$this->newtable->search(array(array("A.NAMA_SAMPEL","Nama Sampel"),array("dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL)","Kode Sampel"),array("A.TEMPAT_SAMPLING","Tempat Sampling"),array("dbo.KATEGORI(A.KOMODITI,A.PRIORITAS)","Komoditi"),array("dbo.KATEGORI(A.KATEGORI,A.PRIORITAS)","Kategori")));
				$this->newtable->columns(array("A.KODE_SAMPEL", array("A.NAMA_SAMPEL + '<div>' + dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) + '</div><div>' + A.BENTUK_SEDIAAN + '</div><div>' + A.PABRIK + '</div><div>' + A.NOMOR_REGISTRASI + ', No Batch  : ' +  A.NO_BETS + '</div><div>'+A.TEMPAT_SAMPLING+'</div>'",site_url()."/home/unggulan/preview/sampel/{KODE_SAMPEL}"),"CAST(A.JUMLAH_SAMPEL AS VARCHAR) +'&nbsp;'+ A.SATUAN +'<div>&bull;&nbsp;Uji Kimia : '+ CAST(A.JUMLAH_KIMIA AS VARCHAR)+'</div><div>&bull;&nbsp;Uji Mikro : '+CAST(A.JUMLAH_MIKRO AS VARCHAR) +'</div><div>&bull;&nbsp;Sisa Sampel : '+CAST(A.SISA AS VARCHAR) +'</div><div>' +CASE WHEN A.UJI_KIMIA = '1' AND A.UJI_MIKRO = '1' THEN 'Uji Kimia - Mikro' WHEN A.UJI_KIMIA = '1' THEN 'Uji Kimia' WHEN A.UJI_MIKRO = '1' THEN 'Uji Mikro' END+ '</div>'", "dbo.KATEGORI(A.KOMODITI,A.PRIORITAS) + '<div>' + dbo.KATEGORI(A.KATEGORI,A.PRIORITAS) + '</div>'","'<div>Hasil Uji Kimia : ' + A.HASIL_KIMIA + '</div><div>A.Hasil Uji Mikro : ' + A.HASIL_MIKRO + '</div><div>Hasil : ' + A.HASIL_SAMPEL + '</div>'"," CONVERT(VARCHAR(10), A.UPDATE_DATE, 120)"));
				$this->newtable->width(array('IDENTITAS SAMPEL' => 225, 'JUMLAH UJI' => 85, 'KOMODITI' => 250, 'HASIL' => 105, 'BALAI UNGGULAN' => 205));
				$proses['Preview Data'] = array('GET', site_url().'/home/unggulan/preview/sampel', '1');
			}
			//echo $query;die();
			$this->newtable->action(site_url()."/home/pengujian/unggulan/".$status);
			$this->newtable->hiddens(array('KODE_SAMPEL','SORTTGL'));
			$this->newtable->cidb($this->db);
			$this->newtable->ciuri($this->uri->segment_array());
			$this->newtable->keys(array('KODE_SAMPEL'));
			$this->newtable->orderby(6);
			$this->newtable->sortby("DESC");
			//$proses['Preview Data'] = array('GET', site_url().'/home/unggulan/previewrilis/sampel', '1');
			//$proses['Preview Data'] = array('GET', site_url().'/home/unggulan/previewrilis/sampel', '1');
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
				$msgok = "Data sampel unggulan berhasil di proses";
				$msgerr = "Data sampel unggulan gagal di proses";
				$hasil = FALSE;
				$id = $this->input->post('KODE_SAMPEL');
				$arrupdate = array('STATUS_SAMPEL' => $this->input->post('STATUS'),
								   'UPDATE_DATE' => 'GETDATE()');
				$this->db->where('KODE_SAMPEL', $id);
				$this->db->update('T_M_SAMPEL', $arrupdate);
				if($this->db->affected_rows() > 0){
					$data = array('KODE_SAMPEL' => $id,
								  'WAKTU' => 'GETDATE()',
								  'USER_ID' => $this->newsession->userdata('SESS_USER_ID'),
								  'KEGIATAN' => $this->input->post('catatan'),
								  'CATATAN' => '-');
					$this->db->insert('T_SAMPLING_LOG', $data);
					
					if($this->input->post('STATUS') == "70021"){
						$lingkupunggulan =  $this->input->post('LINGKUP');
						if($lingkupunggulan=='02' || $lingkupunggulan=='04'){
							$tujuanunggulan =  $this->input->post('TUJUAN');
						}else{
							$tujuanunggulan =  $sipt->main->get_uraian("SELECT BBPOM_ID FROM M_LINGKUP_UNGGULAN WHERE ID = '".$lingkupunggulan."'", "BBPOM_ID");
						}						
						$dataunggulan = array('KODE_SAMPEL' => $id,
											  'BBPOM_ASAL' => $this->newsession->userdata('SESS_BBPOM_ID'),
											  'BBPOM_UNGGULAN' => $tujuanunggulan,
											  'LINGKUP_UNGGULAN' => $lingkupunggulan,
											  'TANGGAL_TERIMA' => '',
											  'PETUGAS_PENERIMA' => '',
											  'TANGGAL_VERIFIKASI' => '',
											  'VERIFIKATOR' => '',
											  'STATUS_UNGGULAN' => '1',
											  'STATUS' =>'70021',
											  'CATATAN' => $this->input->post('catatan'),
											  'CREATE_BY' => $this->newsession->userdata('SESS_USER_ID'),
											  'CREATE_DATE' => 'GETDATE()',
											  'UPDATE_BY' => $this->newsession->userdata('SESS_USER_ID'),
											  'UPDATE_DATE' => 'GETDATE()');
						if($this->db->insert('T_SAMPEL_UNGGULAN', $dataunggulan)){

							if($this->db->affected_rows() > 0)
							{
								/**
								 * Insert Surat Pengantar Unggulan
								 */
								$get_obj_sampel = $this->db->query("SELECT KODE_SAMPEL, NAMA_SAMPEL, PABRIK, NO_BETS FROM T_M_SAMPEL WHERE KODE_SAMPEL = '".$this->input->post('KODE_SAMPEL')."'")->result_array();
								$get_obj_asal = $this->db->query("SELECT KOTA, BBPOM_ID, NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'")->result_array();
								$get_obj_tujuan = $this->db->query("SELECT BBPOM_ID, NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID = '".$tujuanunggulan."'")->result_array();
								$get_obj_kbalai = $this->db->query("SELECT NAMA_USER, USER_ID FROM T_USER WHERE
USER_ID IN (SELECT USER_ID FROM T_USER_ROLE WHERE ROLE IN ('5')) AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND STATUS = 'Aktif'")->result_array();
								$set_obj_surat = array('KODE_SAMPEL' => $get_obj_sampel[0]['KODE_SAMPEL'],
												   'KOTA' => $get_obj_asal[0]['KOTA'],
												   'TANGGAL_SURAT' => 'GETDATE()',
												   'NOMOR_SURAT' => '-',
												   'BBPOM_ID_TUJUAN' => $get_obj_tujuan[0]['BBPOM_ID'],
												   'BBPOM_NAMA_TUJUAN' => $get_obj_tujuan[0]['NAMA_BBPOM'],
												   'BBPOM_ID_PENGIRIM' => $get_obj_asal[0]['BBPOM_ID'],
												   'BBPOM_NAMA_PENGIRIM' => $get_obj_asal[0]['NAMA_BBPOM'],
												   'NAMA_SAMPEL' => $get_obj_sampel[0]['NAMA_SAMPEL'],
												   'PABRIK' => $get_obj_sampel[0]['PABRIK'],
												   'NO_BETS' => $get_obj_sampel[0]['NO_BETS'],
												   'NAMA_KEPALA_BALAI' => $get_obj_kbalai[0]['NAMA_USER'],
												   'NIP_KEPALA_BALAI' => $get_obj_kbalai[0]['USER_ID'],
												   'CREATE_BY' => $this->newsession->userdata('SESS_USER_ID'),
												   'CREATE_DATE' => 'GETDATE()');
								$this->db->insert('T_SURAT_PENGANTAR_UNGGULAN', $set_obj_surat);
								/**
								 * End Insert Surat Pengantar Unggulan
								 */
								if($this->db->affected_rows() > 0 ){
									$hasil = TRUE;
									$this->db->simple_query("UPDATE T_SAMPEL_UNGGULAN_TMP SET STATUS = '".$this->input->post('STATUS')."' WHERE KODE_SAMPEL = '".$id."'");
									$redir = site_url().'/home/unggulan/sampel/draft';
								}
							}
						}
					}else if($this->input->post('STATUS') == "80021"){
						$arrrunggulan = array('TANGGAL_TERIMA' => $this->input->post('TANGGAL_TERIMA'),
											  'PETUGAS_PENERIMA' => $this->newsession->userdata('SESS_NAMA_USER'),
											  'UPDATE_BY' => $this->newsession->userdata('SESS_USER_ID'),
											  'UPDATE_DATE' => 'GETDATE()',
											  'STATUS' => $this->input->post('STATUS'));
						$this->db->where('KODE_SAMPEL', $id);				
						$this->db->update('T_SAMPEL_UNGGULAN', $arrrunggulan);
						$this->db->simple_query("UPDATE T_SAMPEL_UNGGULAN_TMP SET STATUS = '".$this->input->post('STATUS')."' WHERE KODE_SAMPEL = '".$id."'");
						$redir = site_url().'/home/unggulan/sampel/receive';
						$hasil = TRUE;						
					}else if($this->input->post('STATUS') == '70022'){
						if($this->set_copy($id)){
							$arrrunggulan = array('TANGGAL_VERIFIKASI' => $this->input->post('TANGGAL_VERIFIKASI'),
												  'VERIFIKATOR' => $this->newsession->userdata('SESS_NAMA_USER'),
												  'UPDATE_BY' => $this->newsession->userdata('SESS_USER_ID'),
												  'UPDATE_DATE' => 'GETDATE()',
												  'STATUS' => $this->input->post('STATUS'));
							$this->db->where('KODE_SAMPEL', $id);				
							$this->db->update('T_SAMPEL_UNGGULAN', $arrrunggulan);
							$this->db->simple_query("UPDATE T_SAMPEL_UNGGULAN_TMP SET STATUS = '".$this->input->post('STATUS')."' WHERE KODE_SAMPEL = '".$id."'");
							
							$kodesampelbaru = $sipt->main->get_uraian("SELECT KODE_SAMPEL FROM T_M_SAMPEL WHERE KODE_UNGGULAN = '".$id."'", "KODE_SAMPEL");
							$reffspu = $this->db->query("SELECT KOMODITI, ANGGARAN, ASAL_SAMPEL FROM T_M_SAMPEL WHERE KODE_SAMPEL = '".$kodesampelbaru."'")->result_array();
							$reffunggulan = $this->db->query("SELECT CONVERT(VARCHAR(10), TANGGAL_TERIMA, 103) AS TANGGAL_TERIMA, CONVERT(VARCHAR(10), TANGGAL_VERIFIKASI, 103) AS TANGGAL_VERIFIKASI, PETUGAS_PENERIMA FROM T_SAMPEL_UNGGULAN WHERE KODE_SAMPEL = '".$id."' AND BBPOM_UNGGULAN = '".$this->newsession->userdata('SESS_BBPOM_ID')."'")->result_array();
							$dataspu = array();

							$arrdmy = explode("/",$reffunggulan[0]['TANGGAL_VERIFIKASI']);
							$dmy = $arrdmy[0].$arrdmy[1].substr($arrdmy[2],2,4);
							$dataspu['SPU_ID'] = $sipt->main->set_kode_spu($reffspu[0]['ANGGARAN'],$reffspu[0]['ANGGARAN'], $reffunggulan[0]['TANGGAL_VERIFIKASI']);
							$dataspu['NOMOR_SP'] = $sipt->main->set_kode_sp($reffspu[0]['KOMODITI'],date("d").date("m").substr(date("Y"),2,4));
							$dataspu['NOMOR_SP'] = $sipt->main->set_kode_sp($reffspu[0]['KOMODITI'],$dmy);
							$dataspu['NOMOR_SPS'] = str_replace("SPU","SPS",$dataspu['SPU_ID']);
							$dataspu['TANGGAL'] = $reffunggulan[0]['TANGGAL_VERIFIKASI'];
							$dataspu['TANGGAL_PERINTAH'] = $reffunggulan[0]['TANGGAL_VERIFIKASI'];
							$dataspu['TANGGAL_TERIMA_TPS'] = $reffunggulan[0]['TANGGAL_TERIMA'];
							$dataspu['PETUGAS_PENERIMA'] = $reffunggulan[0]['PETUGAS_PENERIMA'];
							$dataspu['BBPOM_ID'] = $this->newsession->userdata('SESS_BBPOM_ID');
							$dataspu['ASAL_SAMPEL'] = $reffspu[0]['ASAL_SAMPEL'];
							$dataspu['CREATE_BY'] = $this->newsession->userdata('SESS_USER_ID');
							$dataspu['CREATE_DATE'] = 'GETDATE()';
							$dataspu['UPDATE_BY'] = $this->newsession->userdata('SESS_USER_ID');
							$dataspu['LAST_UPDATE'] = 'GETDATE()';
							$dataspu['STATUS'] = $this->input->post('STATUS');
							if($this->db->insert('T_SPU', $dataspu)){
								$arrsampel = array('SPU_ID' => $dataspu['SPU_ID']);
								$this->db->where('KODE_SAMPEL', $kodesampelbaru);
								$this->db->update('T_M_SAMPEL', $arrsampel);									
								if($this->db->affected_rows() == 1){
									$logspu = array('SPU_ID' => $dataspu['SPU_ID'],
													'WAKTU' => 'GETDATE()',
													'USER_ID' => $this->newsession->userdata('SESS_USER_ID'),
													'KEGIATAN' => 'Simpan data Surat Permintaan Uji : '.$dataspu['SPU_ID'],
													'CATATAN' => 'Kode sampel : '. $kodesampelbaru);
									$this->db->insert('T_SPU_LOG', $logspu);
								}
								$hasil = TRUE;
							}								
							$redir = site_url().'/home/unggulan/sampel/verifikasi';							
						}else{
							$hasil = FALSE;
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
			}else if($action == "prosesmt"){
				$msgok = "Data sampel unggulan berhasil di proses";
				$msgerr = "Data sampel unggulan gagal di proses";
				$hasil = FALSE;
				$idlama = $this->input->post('KODE_SAMPEL');
				$id = $sipt->main->get_uraian("SELECT KODE_SAMPEL FROM T_M_SAMPEL WHERE KODE_UNGGULAN = '".$idlama."'", "KODE_SAMPEL"); 
				$arrupdate = array('STATUS_SAMPEL' => $this->input->post('STATUS'),
								   'UPDATE_DATE' => 'GETDATE()');
				$this->db->where('KODE_SAMPEL', $id);
				$this->db->update('T_M_SAMPEL', $arrupdate);				
				if($this->db->affected_rows() > 0){
					$this->db->simple_query("UPDATE T_M_SAMPEL SET STATUS = '50000', UPDATE_DATE = GETDATE() WHERE KODE_SAMPEL = '".$idlama."'");
					$this->db->simple_query("UPDATE T_SAMPEL_UNGGULAN_TMP SET STATUS = '50000' WHERE KODE_SAMPEL = '".$idlama."'");
					$arrrunggulan = array('UPDATE_DATE' => 'GETDATE()',
										  'STATUS' => '50000');
					$this->db->where('KODE_SAMPEL', $idlama);				
					$this->db->update('T_SAMPEL_UNGGULAN', $arrrunggulan);
					if($this->input->post('STATUS') == "40201"){
						$arr_petugas = $this->input->post('USER_ID');
						if(!$arr_petugas){
							return "MSG#NO#MT Pengujian belum ditunjuk."; die();
						}
						$jml = count($arr_petugas);
						$chk = $this->input->post('chkjml');
						
						$user = "'".join("','", $this->input->post('USER_ID'))."'"; 
						$jmljabatan = (int)$this->db->query("SELECT DISTINCT(USER_ID), LEFT(SARANA_MEDIA_ID, 2) AS BID FROM T_USER_ROLE WHERE USER_ID IN (".$user.") GROUP BY USER_ID, SARANA_MEDIA_ID")->num_rows(); # 1 | 2 
						$chkuji = FALSE;
						if($jml < $chk){
							if($jmljabatan == $chk)
							$chkuji = TRUE;
							else
							$chkuji = FALSE;
						}else if($jml > $chk){
							$chkuji = FALSE;
						}else if($chk <= $jmljabatan){
							$chkuji = TRUE;
						}
						if($chkuji){
							/**
							 * Blok Insert Penyerahan Sampel Ke Pengujian
							 */
							if(count($arr_petugas)>0){
								$qmt = "SELECT DISTINCT(USER_ID), LEFT(SARANA_MEDIA_ID, 2) AS BID FROM T_USER_ROLE WHERE USER_ID IN (".$user.") GROUP BY USER_ID, SARANA_MEDIA_ID";
								$dmt = $sipt->main->get_result($qmt);
								if($dmt){
									$arrtmpmt = array();
									$arrbid = array();
									$arrkimia = array();
									$arrmikro = array();
									$jmlkmia = 0;
									$jmlmikro = 0;
									foreach($qmt->result_array() as $rmt){
										if(!array_key_exists($rmt['BID'], $arrbid)) $arrbid[$rmt['BID']] = $rmt['BID'];
										if(!array_key_exists($rmt['BID'], $arrtmpmt)) $arrtmpmt[$rmt['USER_ID']] = $rmt['BID'];
									}
									
									foreach($arrtmpmt as $x => $y){
										if($y == "B1" || $y == "B2"){
											$qkimia = "SELECT KODE_SAMPEL, STATUS_SAMPEL FROM T_M_SAMPEL WHERE SPU_ID = '".$this->input->post('SPU_ID')."' AND UJI_KIMIA = '1' ";
											$dtkimia = $sipt->main->get_result($qkimia);
											if($dtkimia){
												foreach($qkimia->result_array() as $rowkimia){
													$arrkimia['SPU_ID'] = $this->input->post('SPU_ID');
													$arrkimia['KODE_SAMPEL'] = $rowkimia['KODE_SAMPEL'];
													$arrkimia['USER_ID'] = $x;
													$arrkimia['STATUS'] = '40201';
													$this->db->insert('T_SAMPEL_MT', $arrkimia);
													$jmlkmia++;
												}
											}
										}
										if($y == "B3"){
											$qmikro = "SELECT KODE_SAMPEL, STATUS_SAMPEL FROM T_M_SAMPEL WHERE SPU_ID = '".$this->input->post('SPU_ID')."' AND UJI_MIKRO = '1' ";
											$dtmikro = $sipt->main->get_result($qmikro);
											if($dtmikro){
												foreach($qmikro->result_array() as $rowmikro){
													$arrmikro['SPU_ID'] = $this->input->post('SPU_ID');
													$arrmikro['KODE_SAMPEL'] = $rowmikro['KODE_SAMPEL'];
													$arrmikro['USER_ID'] = $x;
													$arrmikro['STATUS'] = '40201';
													$this->db->insert('T_SAMPEL_MT', $arrmikro);
													$jmlmikro++;
												}
											}else{
												$qmikrox = "SELECT KODE_SAMPEL, STATUS_SAMPEL FROM T_M_SAMPEL WHERE SPU_ID = '".$this->input->post('SPU_ID')."'";
												$dtmikrox = $sipt->main->get_result($qmikrox);
												if($dtmikrox){
													foreach($qmikrox->result_array() as $rowmikrox){
														$arrmikrox['SPU_ID'] = $this->input->post('SPU_ID');
														$arrmikrox['KODE_SAMPEL'] = $rowmikrox['KODE_SAMPEL'];
														$arrmikrox['USER_ID'] = $x;
														$arrmikrox['STATUS'] = '40201';
														$this->db->insert('T_SAMPEL_MT', $arrmikrox);
														$jmlkimia++;
													}
												}
											}
										}
									}	

									if($jmlkmia > 0 || $jmlmikro > 0)
									{
										$asal = $sipt->main->get_uraian("SELECT ASAL_SAMPEL FROM T_SPU WHERE SPU_ID = '".$this->input->post('SPU_ID')."'","ASAL_SAMPEL");
										$dtsp = $sipt->main->post_to_query($this->input->post('PERINTAH_UJI'));
										$dtsp['UPDATE_BY'] = $this->newsession->userdata('SESS_USER_ID');
										$dtsp['LAST_UPDATE'] = 'GETDATE()';
										$dtsp['STATUS'] = '40201';
										$dtsp['JML_SPU'] = $jml;
										$this->db->where('SPU_ID',$this->input->post('SPU_ID'));
										if($this->db->affected_rows() > 0)
										{
											$logspu = array('SPU_ID' => $this->input->post('SPU_ID'),
														'WAKTU' => 'GETDATE()',
														'USER_ID' => $this->newsession->userdata('SESS_USER_ID'),
														'KEGIATAN' => 'Simpan Surat Perintah Uji, Disposisi ke Bidang Pengujian',
														'CATATAN' => 'Nomor Surat Surat Permintaan Uji : '.$this->input->post('SPU_ID'));
											$this->db->insert('T_SPU_LOG', $logspu);
											$hasil = TRUE;
										}
									}

								}
							}
							/**
							 * End Blok Insert Penyerahan Sampel Ke Pengujian
							 */

							if($hasil){
								$this->db->simple_query("UPDATE T_M_SAMPEL SET STATUS_SAMPEL = '40201' WHERE SPU_ID = '".$this->input->post('SPU_ID')."'");
								$data = array('KODE_SAMPEL' => $id,
											  'WAKTU' => 'GETDATE()',
											  'USER_ID' => $this->newsession->userdata('SESS_USER_ID'),
											  'KEGIATAN' => $this->input->post('catatan'),
											  'CATATAN' => '-');
								$this->db->insert('T_SAMPLING_LOG', $data);
								return "MSG#YES#$msgok.\n Jumlah Sampel dikirim ke Kimia : ".$jmlkmia."\n Jumlah Sampel dikirim ke Mikro :".$jmlmikro." #".site_url().'/home/unggulan/sampel/deliver';
							}else{
								$arrupdate = array('STATUS_SAMPEL' => '70022','UPDATE_DATE' => 'GETDATE()');
								$this->db->where('KODE_SAMPEL', $id);
								$this->db->update('T_M_SAMPEL', $arrupdate);	

								$this->db->simple_query("UPDATE T_M_SAMPEL SET STATUS = '70022', UPDATE_DATE = GETDATE() WHERE KODE_SAMPEL = '".$idlama."'");
								$this->db->simple_query("UPDATE T_SAMPEL_UNGGULAN_TMP SET STATUS = '70022' WHERE KODE_SAMPEL = '".$idlama."'");
								$arrrunggulan = array('UPDATE_DATE' => 'GETDATE()',
													  'STATUS' => '70022');
								$this->db->where('KODE_SAMPEL', $idlama);				
								$this->db->update('T_SAMPEL_UNGGULAN', $arrrunggulan);

								return "MSG#NO#Data sampel unggulan gagal di proses. \n Data gagal dikirim ke pengujian. \n Silahkan dicek kembali jenis pengujian dan Manajer Teknis yang dituju";
							}
						
							if($isajax!="ajax"){
								redirect(base_url());
								exit();
							}


						}else{
							return "MSG#NO#Harap cek kembali jenis pengujian dan manajer teknis yang dituju"; die();
						}
					}
				}else{
					return "MSG#NO#$msgerr";
				}
			}else{
				redirect(base_url());
				exit();
			}
		}
	}
	
	function set_kirim($action, $isajax){
		if(in_array('5',$this->newsession->userdata('SESS_KODE_ROLE')) && $this->newsession->userdata('LOGGED_IN') == TRUE){
			$sipt =& get_instance();
			$sipt->load->model("main","main", true);
			if($action == "unggul"){
				$ret = "MSG#Data Gagal Dikirim.";

				foreach($this->input->post('tb_chk') as $a){
					$this->db->simple_query("UPDATE T_M_SAMPEL_RILIS SET STATUS = '80215', STATUS_KIRIM = 1, MONEV_PPOMN = 1 WHERE KODE_SAMPEL = '".$a."'");

					$sampel_balai_asal = $this->db->query("SELECT KODE_UNGGULAN FROM T_M_SAMPEL WHERE KODE_SAMPEL = '".$a."'")->result_array();

					$this->db->simple_query("UPDATE T_SAMPEL_UNGGULAN SET STATUS_UNGGULAN = 2, STATUS = '50206' WHERE KODE_SAMPEL = '".$sampel_balai_asal[0]['KODE_UNGGULAN']."'");
					$data = array('KODE_SAMPEL' => $a,
								  'WAKTU' => 'GETDATE()',
								  'USER_ID' => $this->newsession->userdata('SESS_USER_ID'),
								  'KEGIATAN' => 'Mengirim data sampel unggulan dengan kode sampel : '. $a,
								  'CATATAN' => '-');
					$this->db->insert('T_SAMPLING_LOG', $data);
					$ret = "MSG#Data Berhasil Dikirim#";
				}
				if($isajax!="ajax"){
					redirect(base_url());
					exit();
				}

			}else if($action == "hasil"){
				
			}
			return $ret;
		}
	}
	
	function set_copy($id){
		$sipt =& get_instance();
		$sipt->load->model('main','main',true);
		$ret = FALSE;
		$query = "SELECT PERIKSA_SAMPEL ,KODE_SAMPEL ,SPU_ID ,KOMODITI ,KATEGORI ,REKAP_KOMODITI ,ANGGARAN ,ASAL_SAMPEL ,TUJUAN_SAMPLING ,SUB_TUJUAN ,PRIORITAS ,CONVERT(VARCHAR(10), TANGGAL_SAMPLING, 103) AS TANGGAL_SAMPLING ,BULAN_ANGGARAN ,SARANA_ID ,TEMPAT_SAMPLING ,ALAMAT_SAMPLING ,KLASIFIKASI_TAMBAHAN ,NAMA_SAMPEL ,NOMOR_REGISTRASI ,PABRIK ,IMPORTIR ,BENTUK_SEDIAAN ,KEMASAN ,NO_BETS ,KETERANGAN_ED ,JUMLAH_SAMPEL ,SATUAN ,HARGA_SAMPEL ,UJI_KIMIA ,JUMLAH_KIMIA ,UJI_MIKRO ,JUMLAH_MIKRO ,UJI_BIO ,JUMLAH_BIO ,SISA ,SISA_KIMIA ,SISA_MIKRO ,SISA_BIO ,TEMPAT_SISA_KIMIA ,TEMPAT_SISA_MIKRO ,KOMPOSISI ,NETTO ,KONDISI_SAMPEL ,EVALUASI_PENANDAAN ,CARA_PENYIMPANAN ,PEMERIAN ,SEGEL ,LABEL ,HASIL_KIMIA ,HASIL_MIKRO ,HASIL_BIO ,HASIL_SAMPEL ,UJI_RUJUK ,BBPOM_ASAL ,BBPOM_RUJUK ,JML_RUJUK ,HASIL_KIMIA_RUJUK ,HASIL_MIKRO_RUJUK ,HASIL_SAMPEL_RUJUK ,LAMPIRAN ,CATATAN ,CATATAN_CP ,CATATAN_CP_RUJUK ,STATUS_KIMIA ,STATUS_MIKRO ,STATUS_SAMPEL ,JML_IRISAN ,KOMODITI_IRISAN ,TEMBUSAN ,CREATE_BY, KODE_RUJUKAN, KODE_UNGGULAN, UJI_UNGGULAN, NAMA_KATEGORI FROM T_M_SAMPEL WHERE KODE_SAMPEL = '".$id."'";
		$data = $sipt->main->get_result($query);
		if($data){
			foreach($query->result_array() as $row){
				$arrdata = $row;
			}
			unset($arrdata['KODE_SAMPEL']);
			unset($arrdata['UJI_KIMIA']);
			unset($arrdata['UJI_MIKRO']);
			unset($arrdata['STATUS_KIMIA']);
			unset($arrdata['STATUS_MIKRO']);
			unset($arrdata['STATUS_SAMPEL']);
			if((int)$row['UJI_KIMIA'] == 1 && (int)$row['UJI_MIKRO'] == 1){
				$lab = 'KM';
				$arrdata['UJI_KIMIA'] = 1;
				$arrdata['UJI_MIKRO'] = 1;
			}else if((int)$row['UJI_KIMIA'] == 1 && (int)$row['UJI_MIKRO'] == 0){
				$lab = 'K';
				$arrdata['UJI_KIMIA'] = 1;
				$arrdata['UJI_MIKRO'] = 0;
			}else if((int)$row['UJI_KIMIA'] == 0 && (int)$row['UJI_MIKRO'] == 1){
				$lab = 'M';
				$arrdata['UJI_KIMIA'] = 0;
				$arrdata['UJI_MIKRO'] = 1;
			}
			$arrdata['KODE_SAMPEL'] = $sipt->main->set_kode_sampel('07', '14', $arrdata['KOMODITI'], $lab,$arrdata['TANGGAL_SAMPLING']);
			$arrdata['SPU_ID'] = 0;
			$arrdata['STATUS_KIMIA'] = 0;
			$arrdata['STATUS_MIKRO'] = 0;
			$arrdata['STATUS_SAMPEL'] = '70022'; 
			$arrdata['HASIL_SAMPEL'] = NULL;
			$arrdata['HASIL_KIMIA'] = NULL;
			$arrdata['HASIL_MIKRO'] = NULL;
			$arrdata['KODE_RUJUKAN'] = '';
			$arrdata['KODE_UNGGULAN'] = $id;
			$arrdata['BBPOM_ID'] = $this->newsession->userdata('SESS_BBPOM_ID');
			$arrdata['CREATE_BY'] = $this->newsession->userdata('SESS_USER_ID');
			$this->db->insert('T_M_SAMPEL', $arrdata);
			if($this->db->affected_rows() > 0){
				$ret = TRUE;
			}
			return $ret;
		}
	}
	
}
?>