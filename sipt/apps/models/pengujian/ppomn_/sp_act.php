<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR);
class Sp_act extends Model{
	function list_sp($submenu){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$this->load->library('newtable');
			if($submenu == "verifikasi"){
				if(in_array('B5',$this->newsession->userdata('SESS_SUB_SARANA')))
				$q = "AND STATUS = '40201' AND GET_DISPO = '2'";
				else
				$q = "AND STATUS = '40201'";
				$judul = "Daftar Surat Perintah Uji - Proses Verifikasi";
			}else{
				$judul = "Daftar Surat Perintah Uji";
				if(in_array('B5',$this->newsession->userdata('SESS_SUB_SARANA')))
				$q = "AND STATUS NOT IN('40201') AND GET_DISPO = '2'";
				else
				$q = "AND STATUS NOT IN ('40201')";
			}
			$query = "SELECT SPU_ID, STATUS, dbo.FORMAT_NOMOR('SPU', SPU_ID) AS [NOMOR SPU], dbo.FORMAT_NOMOR('SPS', NOMOR_SPS) AS [NOMOR SPS],
dbo.KATEGORI(SUBSTRING(SPU_ID, 13,2)) AS [KOMODITI], dbo.URAIAN_M_TABEL('ASAL_SAMPLING', ASAL_SAMPEL) AS [ASAL SAMPEL], CONVERT(VARCHAR(10), TANGGAL_TERIMA_TPS, 120) AS [TANGGAL TERIMA] FROM T_SPU WHERE SPU_ID IN (SELECT SPU_ID FROM T_SP_PETUGAS WHERE USER_ID = '".$this->newsession->userdata('SESS_USER_ID')."') AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' $q";
			$this->newtable->columns(array("SPU_ID", "STATUS", array("dbo.FORMAT_NOMOR('SPU', SPU_ID)",site_url()."/home/ppomn/spux/preview/{SPU_ID}.{STATUS}"), "dbo.FORMAT_NOMOR('SPS', NOMOR_SPS)","dbo.KATEGORI(SUBSTRING(SPU_ID, 13,2))", "dbo.URAIAN_M_TABEL('ASAL_SAMPLING', ASAL_SAMPEL)", "CONVERT(VARCHAR(10), TANGGAL_TERIMA_TPS, 120)"));
			$this->newtable->search(array(array("dbo.FORMAT_NOMOR('SPU',SPU_ID)", "Nomor SPU"),array("CONVERT(VARCHAR(10), TANGGAL_TERIMA_TPS, 120)","Tanggal Terima"),array("dbo.URAIAN_M_TABEL('ASAL_SAMPLING', ASAL_SAMPEL) AS [ASAL SAMPEL]","Asam Sampel"),array("dbo.KATEGORI(SUBSTRING(SPU_ID, 13,2))","Komoditi")));
			$this->newtable->width(array('NOMOR SPU' => 125, 'NOMOR SPS' => 125, 'ASAL SAMPEL' => 200, 'TANGGAL TERIMA' => 100));
			$this->newtable->action(site_url()."/home/ppomn/sp/list/".$submenu);
			$this->newtable->cidb($this->db);
			$this->newtable->ciuri($this->uri->segment_array());
			$this->newtable->orderby(1);
			$this->newtable->sortby("ASC");
			$this->newtable->hiddens(array('SPU_ID','STATUS'));
			$this->newtable->keys(array('SPU_ID','STATUS'));
			if($submenu == "verifikasi"){
				$proses['Tambah SPK Baru'] = array('GET', site_url()."/home/ppomn/spk/new", '1');
			}
			$proses['Preview Data'] = array('GET', site_url()."/home/ppomn/spux/preview", '1');
			//else{
				//$proses['Cetak Surat Perintah Kerja'] = array('GETNEW', site_url()."/topdf/spk/prints", '1');
			//}
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

	function get_spp($id){
		if((in_array('3', $this->newsession->userdata('SESS_KODE_ROLE')) && in_array('02', $this->newsession->userdata('SESS_JENIS_PELAPORAN'))) && $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$params = explode(".",$id);
			$jml = count($params);
			if($jml < 2){
				return redirect(base_url());
			}
			$arrdata = array();
			if(in_array('B5',$this->newsession->userdata('SESS_SUB_SARANA'))){
				$arrdata['jenis_uji'] = "02";
				$bidang = "B.UJI_MIKRO = '1'";
			}else{
				$arrdata['jenis_uji'] = "01";
				$bidang = "B.UJI_KIMIA = '1'";
			}		  
			$query = "SELECT A.UJI_ID, A.PARAMETER_UJI AS PARAM, A.METODE, A.PUSTAKA, dbo.FORMAT_NOMOR('SPL',B.KODE_SAMPEL) AS KODE_SAMPEL, B.NAMA_SAMPEL, dbo.KATEGORI(B.KATEGORI) AS KOMODITI FROM T_PARAMETER_HASIL_UJI A LEFT JOIN T_M_SAMPEL B ON A.KODE_SAMPEL = B.KODE_SAMPEL WHERE A.SPK_ID = '".$params[1]."' AND $bidang ORDER BY 5 ASC";
			$data = $sipt->main->get_result($query);
			if($data){
				foreach($query->result_array() as $row){
					$arr [] = $row;
					$arrdata['arr'] = $arr;
					$arrdata['act'] = site_url().'/post/ppomn/spk_act/spp-save';
				}
				$arrdata['dtspk'] = $this->db->query("SELECT dbo.FORMAT_NOMOR('SPK', A.SPK_ID) UR_SPK, dbo.FORMAT_NOMOR('SPU', A.SPU_ID) UR_SPU, CONVERT(VARCHAR(10), B.TANGGAL, 105) AS TANGGAL_SPU, CONVERT(VARCHAR(10), A.TANGGAL, 105) AS TANGGAL_SPK, C.NAMA_USER FROM T_SPK A LEFT JOIN T_SPU B ON A.SPU_ID = B.SPU_ID LEFT JOIN T_USER C ON A.CREATE_BY = C.USER_ID WHERE SPK_ID = '".$params[1]."'")->result_array();
			} 
			$arrdata['spuid'] = $id;
			$arrdata['nospu'] = $params[0];
			$arrdata['batal'] = site_url().'/home/pengujian/spp/list/verifikasi';
			return $arrdata;
		}
	}

	function get_disposp($id){
		if(in_array('7', $this->newsession->userdata('SESS_KODE_ROLE')) && $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model('main','main', true);
			$this->load->library('newtable');
			if($id=="") return redirect(base_url());
			$query = "SELECT SPU_ID, CONVERT(VARCHAR(10), TANGGAL_TERIMA_TPS, 103) AS TANGGAL_TERIMA, dbo.FORMAT_NOMOR('SPU', SPU_ID) AS SPU, SUBSTRING(SPU_ID, 13,2) AS KOMODITI FROM T_SPU WHERE SPU_ID = '".$id."'";
			$rspu = $sipt->main->get_result($query);
			if($query){
				foreach($query->result_array() as $row){
					$arrdata = array('sess' => $row);
				}
				$query = "SELECT A.PERIKSA_SAMPEL, A.KODE_SAMPEL, B.NOMOR_SURAT +'<div>Tanggal Sampling : ' + CONVERT(VARCHAR(10), A.TANGGAL_SAMPLING, 120) + '</div><div>Bulan Anggaran : '+ A.BULAN_ANGGARAN +'</div><div>Asal Sampel : '+dbo.URAIAN_M_TABEL('ASAL_SAMPLING',A.ASAL_SAMPEL)+'</div>' AS [NOMOR SURAT / PENGANTAR], A.NAMA_SAMPEL + '<div>' + dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) + '</div><div>' + A.BENTUK_SEDIAAN + '</div><div>' + A.PABRIK + '</div><div>' + A.NOMOR_REGISTRASI + ', No Batch  : ' +  A.NO_BETS + '</div><div>'+A.TEMPAT_SAMPLING+'</div>' AS [IDENTITAS SAMPEL], CAST(A.JUMLAH_SAMPEL AS VARCHAR) +'&nbsp;'+ A.SATUAN +'<div>&bull;&nbsp;Uji Kimia : '+ CAST(A.JUMLAH_KIMIA AS VARCHAR)+'</div><div>&bull;&nbsp;Uji Mikro : '+CAST(A.JUMLAH_MIKRO AS VARCHAR) +'</div><div>&bull;&nbsp;Sisa Sampel : '+CAST(A.SISA AS VARCHAR) +'</div><div>' +CASE WHEN UJI_KIMIA = '1' AND UJI_MIKRO = '1' THEN 'Uji Kimia - Mikro' WHEN UJI_KIMIA = '1' THEN 'Uji Kimia' WHEN UJI_MIKRO = '1' THEN 'Uji Mikro' END+ '</div>' AS [JUMLAH UJI], dbo.KATEGORI(A.KATEGORI) AS KOMODITI, dbo.URAIAN_M_TABEL('STATUS', A.STATUS_SAMPEL) AS [STATUS] FROM T_M_SAMPEL A LEFT JOIN T_PERIKSA_SAMPEL B ON A.PERIKSA_SAMPEL = B.PERIKSA_SAMPEL WHERE A.SPU_ID = '".$id."'";
				$this->newtable->hiddens(array('PERIKSA_SAMPEL','KODE_SAMPEL'));
				$this->newtable->search(array(array("B.NOMOR_SURAT", "Nomor Surat Tugas / Pengantar"),array("CONVERT(VARCHAR(10), A.TANGGAL_SAMPLING, 120)", "Tanggal Sampling"),array("A.BULAN_ANGGARAN","Bulan Anggaran"),array("dbo.URAIAN_M_TABEL('ASAL_SAMPLING', A.ASAL_SAMPEL)", "Asal Sampel"),array("A.NAMA_SAMPEL","Nama Sampel"),array("dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL)","Kode Sampel"),array("A.TEMPAT_SAMPLING","Tempat Sampling"),array("dbo.KATEGORI(A.KOMODITI)","Komoditi"),array("dbo.KATEGORI(A.KATEGORI)","Kategori"),array("dbo.URAIAN_M_TABEL('STATUS', A.STATUS_SAMPEL)","Status / Proses Sampel")));
				$this->newtable->columns(array("A.PERIKSA_SAMPEL", "A.KODE_SAMPEL", "B.NOMOR_SURAT +'<div>Tanggal Sampling : ' + CONVERT(VARCHAR(10), A.TANGGAL_SAMPLING, 120) + '</div><div>Bulan Anggaran : '+ A.BULAN_ANGGARAN +'</div><div>Asal Sampel : '+dbo.URAIAN_M_TABEL('ASAL_SAMPLING',A.ASAL_SAMPEL)+'</div>'",array("A.NAMA_SAMPEL + '<div>' + dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) + '</div><div>' + A.BENTUK_SEDIAAN + '</div><div>' + A.PABRIK + '</div><div>' + A.NOMOR_REGISTRASI + ', No Batch  : ' +  A.NO_BETS + '</div><div>'+A.TEMPAT_SAMPLING+'</div><div>'",site_url()."/home/sampel/preview/{PERIKSA_SAMPEL}.{KODE_SAMPEL}"),"CAST(A.JUMLAH_SAMPEL AS VARCHAR) +'&nbsp;'+ A.SATUAN +'<div>&bull;&nbsp;Uji Kimia : '+ CAST(A.JUMLAH_KIMIA AS VARCHAR)+'</div><div>&bull;&nbsp;Uji Mikro : '+CAST(A.JUMLAH_MIKRO AS VARCHAR) +'</div><div>&bull;&nbsp;Sisa Sampel : '+CAST(A.SISA AS VARCHAR) +'</div><div>' +CASE WHEN UJI_KIMIA = '1' AND UJI_MIKRO = '1' THEN 'Uji Kimia - Mikro' WHEN UJI_KIMIA = '1' THEN 'Uji Kimia' WHEN UJI_MIKRO = '1' THEN 'Uji Mikro' END+ '</div>'","dbo.KATEGORI(A.KATEGORI)","dbo.URAIAN_M_TABEL('STATUS', A.STATUS_SAMPEL)"));
				$this->newtable->width(array('NOMOR SURAT / PENGANTAR' => 200,'IDENTITAS SAMPEL' => 225, 'JUMLAH UJI' => 85, 'KOMODITI' => 75, 'STATUS' => 105));
				$this->newtable->action(site_url()."/home/pengujian/spu/".$id);
				$this->newtable->detail(site_url()."/get/pengujian/preview_sampel");
				$this->newtable->cidb($this->db);
				$this->newtable->ciuri($this->uri->segment_array());
				$this->newtable->orderby(1);
				$this->newtable->sortby("ASC");
				$this->newtable->keys(array('PERIKSA_SAMPEL','KODE_SAMPEL'));
				if(in_array('3', $this->newsession->userdata('SESS_KODE_ROLE')) && $row['STATUS'] == "30106"){
					$proses['Perbaiki Data Sampel'] = array('POST', site_url().'/post/sampel/sampel_act/reject/ajax', 'N');
					$this->newtable->menu($proses);
				}else if(in_array('4', $this->newsession->userdata('SESS_KODE_ROLE')) && $row['STATUS'] == "40106"){
					$proses['Perbaiki Data Sampel'] = array('POST', site_url().'/post/sampel/sampel_act/reject/ajax', 'N');
					$this->newtable->menu($proses);
				}
				$arrdata['tabel'] = $this->newtable->generate($query);
				$arrdata['act'] = site_url().'/post/sp/dispo_act/save';
				$arrdata['back'] = site_url().'/home/sps/list/sp';
				
			}
			return $arrdata;			
		}
	}
	
	function set_disposp($action, $isajax){
		if(in_array('7', $this->newsession->userdata('SESS_KODE_ROLE')) && $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			if($action == "save"){
				$hasil = FALSE;
				$msgok = "Tambah data surat perintah uji baru berhasil";
				$msgerr = "Tambah data surat perintah uji baru berhasil, Silahkan coba lagi";
				$arr_petugas = $this->input->post('USER_ID');
				if(!$arr_petugas){
					return "MSG#NO#MT Pengujian belum ditunjuk."; die();
				}
				/*$jml = 0;
				$fl_kimia = $sipt->main->get_uraian("SELECT COUNT(JMLKIMIA) AS JMLKIMIA FROM (SELECT DISTINCT(UJI_KIMIA) AS JMLKIMIA FROM T_M_SAMPEL WHERE SPU_ID = '".$this->input->post('SPU_ID')."'  AND UJI_KIMIA > 0) AS DATA","JMLKIMIA");
				$fl_mikro = $sipt->main->get_uraian("SELECT COUNT(JMLMIKRO) AS JMLMIKRO FROM (SELECT DISTINCT(UJI_MIKRO) AS JMLMIKRO FROM T_M_SAMPEL WHERE SPU_ID = '".$this->input->post('SPU_ID')."'  AND UJI_MIKRO > 0) AS DATA","JMLMIKRO");
				if($fl_kimia > 0 && $fl_mikro > 0){
					$jml = "2";
				}else{
					$jml = "1";
				}*/
				$asal = $sipt->main->get_uraian("SELECT ASAL_SAMPEL FROM T_SPU WHERE SPU_ID = '".$this->input->post('SPU_ID')."'","ASAL_SAMPEL");
				$dtsp = $sipt->main->post_to_query($this->input->post('PERINTAH_UJI'));
				$dtsp['UPDATE_BY'] = $this->newsession->userdata('SESS_USER_ID');
				$dtsp['LAST_UPDATE'] = 'GETDATE()';
				$dtsp['STATUS'] = '40201';
				$dtsp['JML_SPU'] = count($arr_petugas);
				$this->db->where('SPU_ID',$this->input->post('SPU_ID'));
				if($this->db->update('T_SPU',$dtsp)){
					$hasil = TRUE;
					if(count($arr_petugas)>0){
						foreach($arr_petugas as $a){
							$spetugas['SPU_ID'] = $this->input->post('SPU_ID');
							$spetugas['USER_ID'] = $a;
							$this->db->insert('T_SP_PETUGAS', $spetugas);
						}
						$logspu = array('SPU_ID' => $this->input->post('SPU_ID'),
										'WAKTU' => 'GETDATE()',
										'USER_ID' => $this->newsession->userdata('SESS_USER_ID'),
										'KEGIATAN' => 'Simpan Surat Perintah Uji',
										'CATATAN' => 'Nomor Surat Surat Permintaan Uji : '.$this->input->post('SPU_ID'));
						$this->db->insert('T_SPU_LOG', $logspu);
					}else{
						$hasil = FALSE;
						$this->db->where('SPU_ID', $this->input->post('SPU_ID'));
						$this->db->delete('T_SP_PETUGAS');
						$sql = "UPDATE T_SPU SET STATUS = '50201' WHERE SPU_ID = '".$this->input->post('SPU_ID')."'";
						$this->db->simple_query($sql);
					}
				}
				if($hasil){
					$this->db->simple_query("UPDATE T_M_SAMPEL SET STATUS_SAMPEL = '40201' WHERE SPU_ID = '".$this->input->post('SPU_ID')."'");
					$arrext = array('10','11','12');
					if(in_array($asal, $arrext))
						return "MSG#YES#$msgok.#".site_url().'/home/spsx/list/all';
					else
						return "MSG#YES#$msgok.#".site_url().'/home/sps/list/all';
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