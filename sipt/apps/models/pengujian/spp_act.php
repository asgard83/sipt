<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR);
class Spp_act extends Model{
	function get_spp($id){
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
				$query = "SELECT A.PERIKSA_SAMPEL, A.KODE_SAMPEL, B.NOMOR_SURAT +'<div>Tanggal Sampling : ' + CONVERT(VARCHAR(10), A.TANGGAL_SAMPLING, 120) + '</div><div>Bulan Anggaran : '+ A.BULAN_ANGGARAN +'</div><div>Asal Sampel : '+dbo.URAIAN_M_TABEL('ASAL_SAMPLING',A.ASAL_SAMPEL)+'</div>' AS [NOMOR SURAT / PENGANTAR], A.NAMA_SAMPEL + '<div>' + dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) + '</div><div>' + A.BENTUK_SEDIAAN + '</div><div>' + A.PABRIK + '</div><div>' + A.NOMOR_REGISTRASI + ', No Batch  : ' +  A.NO_BETS + '</div><div>'+A.TEMPAT_SAMPLING+'</div><div><a href=\"#\" class=\"row_preview\">Detil Sampel</a></div>' AS [IDENTITAS SAMPEL], CAST(A.JUMLAH_SAMPEL AS VARCHAR) +'&nbsp;'+ A.SATUAN +'<div>&bull;&nbsp;Uji Kimia : '+ CAST(A.JUMLAH_KIMIA AS VARCHAR)+'</div><div>&bull;&nbsp;Uji Mikro : '+CAST(A.JUMLAH_MIKRO AS VARCHAR) +'</div><div>&bull;&nbsp;Sisa Sampel : '+CAST(A.SISA AS VARCHAR) +'</div><div>' +CASE WHEN UJI_KIMIA = '1' AND UJI_MIKRO = '1' THEN 'Uji Kimia - Mikro' WHEN UJI_KIMIA = '1' THEN 'Uji Kimia' WHEN UJI_MIKRO = '1' THEN 'Uji Mikro' END+ '</div>' AS [JUMLAH UJI], dbo.KATEGORI(A.KOMODITI,A.PRIORITAS) + '<div>' + A.NAMA_KATEGORI + '</div>' AS KOMODITI, dbo.URAIAN_M_TABEL('STATUS', A.STATUS_SAMPEL) AS [STATUS] FROM T_M_SAMPEL A LEFT JOIN T_PERIKSA_SAMPEL B ON A.PERIKSA_SAMPEL = B.PERIKSA_SAMPEL WHERE A.SPU_ID = '".$id."'";
				$this->newtable->hiddens(array('PERIKSA_SAMPEL','KODE_SAMPEL'));
				$this->newtable->search(array(array("B.NOMOR_SURAT", "Nomor Surat Tugas / Pengantar"),array("CONVERT(VARCHAR(10), A.TANGGAL_SAMPLING, 120)", "Tanggal Sampling"),array("A.BULAN_ANGGARAN","Bulan Anggaran"),array("dbo.URAIAN_M_TABEL('ASAL_SAMPLING', A.ASAL_SAMPEL)", "Asal Sampel"),array("A.NAMA_SAMPEL","Nama Sampel"),array("dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL)","Kode Sampel"),array("A.TEMPAT_SAMPLING","Tempat Sampling"),array("dbo.KATEGORI(A.KOMODITI,A.PRIORITAS)","Komoditi"),array("A.NAMA_KATEGORI","Kategori"),array("dbo.URAIAN_M_TABEL('STATUS', A.STATUS_SAMPEL)","Status / Proses Sampel")));
				$this->newtable->columns(array("A.PERIKSA_SAMPEL", "A.KODE_SAMPEL", "B.NOMOR_SURAT +'<div>Tanggal Sampling : ' + CONVERT(VARCHAR(10), A.TANGGAL_SAMPLING, 120) + '</div><div>Bulan Anggaran : '+ A.BULAN_ANGGARAN +'</div><div>Asal Sampel : '+dbo.URAIAN_M_TABEL('ASAL_SAMPLING',A.ASAL_SAMPEL)+'</div>'","A.NAMA_SAMPEL + '<div>' + dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) + '</div><div>' + A.BENTUK_SEDIAAN + '</div><div>' + A.PABRIK + '</div><div>' + A.NOMOR_REGISTRASI + ', No Batch  : ' +  A.NO_BETS + '</div><div>'+A.TEMPAT_SAMPLING+'</div><div><a href=\"#\" class=\"row_preview\">Detil Sampel</a></div>'","CAST(A.JUMLAH_SAMPEL AS VARCHAR) +'&nbsp;'+ A.SATUAN +'<div>&bull;&nbsp;Uji Kimia : '+ CAST(A.JUMLAH_KIMIA AS VARCHAR)+'</div><div>&bull;&nbsp;Uji Mikro : '+CAST(A.JUMLAH_MIKRO AS VARCHAR) +'</div><div>&bull;&nbsp;Sisa Sampel : '+CAST(A.SISA AS VARCHAR) +'</div><div>' +CASE WHEN UJI_KIMIA = '1' AND UJI_MIKRO = '1' THEN 'Uji Kimia - Mikro' WHEN UJI_KIMIA = '1' THEN 'Uji Kimia' WHEN UJI_MIKRO = '1' THEN 'Uji Mikro' END+ '</div>'","dbo.KATEGORI(A.KOMODITI,A.PRIORITAS) + '<div>' + A.NAMA_KATEGORI + '</div>'","dbo.URAIAN_M_TABEL('STATUS', A.STATUS_SAMPEL)"));
				$this->newtable->width(array('NOMOR SURAT / PENGANTAR' => 200,'IDENTITAS SAMPEL' => 225, 'JUMLAH UJI' => 85, 'KOMODITI' => 75, 'STATUS' => 105));
				$this->newtable->action(site_url()."home/pengujian/spu/".$id);
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
	
	function set_spp($action, $isajax){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			if($action == "save" && in_array('7', $this->newsession->userdata('SESS_KODE_ROLE'))){
				$hasil = FALSE;
				$msgok = "Surat perintah uji baru berhasil";
				$msgerr = "Surat perintah uji baru berhasil, Silahkan coba lagi";
				$arr_petugas = $this->input->post('USER_ID');
				if(!$arr_petugas){
					return "MSG#NO#MT Pengujian belum ditunjuk."; die();
				}
				$jml = 0;
				$fl_kimia = $sipt->main->get_uraian("SELECT COUNT(JMLKIMIA) AS JMLKIMIA FROM (SELECT DISTINCT(UJI_KIMIA) AS JMLKIMIA FROM T_M_SAMPEL WHERE SPU_ID = '".$this->input->post('SPU_ID')."') AS DATA","JMLKIMIA");
				$fl_mikro = $sipt->main->get_uraian("SELECT COUNT(JMLMIKRO) AS JMLMIKRO FROM (SELECT DISTINCT(UJI_MIKRO) AS JMLMIKRO FROM T_M_SAMPEL WHERE SPU_ID = '".$this->input->post('SPU_ID')."') AS DATA","JMLMIKRO");
				$jml = ($fl_kimia > 0 || $fl_mikro > 0 ) ? $jml = "2" : $jml = "1";
				$dtsp = $sipt->main->post_to_query($this->input->post('PERINTAH_UJI'));
				$dtsp['UPDATE_BY'] = $this->newsession->userdata('SESS_USER_ID');
				$dtsp['LAST_UPDATE'] = 'GETDATE()';
				$dtsp['STATUS'] = '40201';
				$dtsp['JML_SPU'] = $jml;
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
					return "MSG#YES#$msgok.#".site_url().'/home/sps/list/all';
				}else{
					return "MSG#NO#$msgerror";
				}
				
				if($isajax!="ajax"){
					redirect(base_url());
					exit();
				}
			}else if($action == "update" && (in_array('3', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('4', $this->newsession->userdata('SESS_KODE_ROLE')))){
				$hasil = FALSE;
				$msgok = "Update detil parameter uji berhasil";
				$msgerr = "Update detil parameter uji gagal";
				$res = $this->db->simple_query("UPDATE T_PARAMETER_HASIL_UJI SET PENGUJI = '".$this->input->post('PENGUJI')."' WHERE SPK_ID = '".$this->input->post('SPK_ID')."' AND UJI_ID = '".$this->input->post('UJI_ID')."'");
				if($res){
					$hasil = TRUE;
				}
				if($hasil){
					return "MSG#YES#$msgok.#".site_url().'/home/pengujian/spp/view/'.$this->input->post('SPK_ID');
				}else{
					return "MSG#NO#$msgerror";
				}
				if($isajax!="ajax"){
					redirect(base_url());
					exit();
				}
			}else if($action == "update-penguji" && (in_array('3', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('4', $this->newsession->userdata('SESS_KODE_ROLE')))){
				$hasil = FALSE;
				$msgok = "Update penentuan ulang penguji berhasil disimpan";
				$msgerr = "Update penentuan ulang penguji gagal disimpan";
				$get_status = $sipt->main->get_uraian("SELECT RTRIM(LTRIM(STATUS)) AS STATUS FROM T_PARAMETER_HASIL_UJI WHERE SPK_ID = '".$this->input->post('SPK_ID')."' AND UJI_ID = '".$this->input->post('UJI_ID')."'","STATUS");
				if(trim($get_status) == "")
					$res = $this->db->simple_query("UPDATE T_PARAMETER_HASIL_UJI SET PENGUJI = '".$this->input->post('PENGUJI')."', STATUS = '20201' WHERE SPK_ID = '".$this->input->post('SPK_ID')."' AND UJI_ID = '".$this->input->post('UJI_ID')."'");
				else
					$res = $this->db->simple_query("UPDATE T_PARAMETER_HASIL_UJI SET PENGUJI = '".$this->input->post('PENGUJI')."' WHERE SPK_ID = '".$this->input->post('SPK_ID')."' AND UJI_ID = '".$this->input->post('UJI_ID')."'");
				if($res){
					$hasil = TRUE;
				}
				if($hasil){
					return "MSG#YES#$msgok.#".site_url().'/home/pengujian/spp/view/'.$this->input->post('SPK_ID');
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
	
	function list_spp($id){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$this->load->library('newtable');
			if($id == "verifikasi"){
				$q = "AND STATUS = '30201'";
				$judul = "Daftar Surat Perintah Uji - Proses Verifikasi";
			}else{
				$judul = "Daftar Surat Perintah Uji";
				$q = "AND STATUS IN ('20201','40201')";
			}
			$query = "SELECT SPU_ID, dbo.FORMAT_NOMOR('SPU',SPU_ID) +'<div>'+ CONVERT(VARCHAR(10), TANGGAL, 120) +'</div>' AS [NOMOR & TANGGAL SPU], dbo.FORMAT_NOMOR('SPS',NOMOR_SPS) +'<div>'+ CONVERT(VARCHAR(10), TANGGAL_TERIMA_TPS, 120) +'</div>' AS [NOMOR & TANGGAL SPS], dbo.FORMAT_NOMOR('SP',NOMOR_SP) +'<div>'+ CONVERT(VARCHAR(10), TANGGAL_PERINTAH, 120) +'</div>' AS [NOMOR & TANGGAL PERINTAH], dbo.URAIAN_M_TABEL('ANGGARAN_SAMPLING', SUBSTRING(SPU_ID, 7,2)) +'<div>'+ dbo.URAIAN_M_TABEL('ASAL_SAMPLING', ASAL_SAMPEL) +'</div>' AS [ANGGARAN & ASAL SAMPEL], dbo.KATEGORI(SUBSTRING(SPU_ID, 13,2),'0') AS [KOMODITI], dbo.URAIAN_M_TABEL('STATUS',STATUS) AS STATUS FROM T_SPU WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' $q";
			$this->newtable->columns(array("SPU_ID", array("dbo.FORMAT_NOMOR('SPU',SPU_ID) +'<div>'+ CONVERT(VARCHAR(10), TANGGAL, 120) +'</div>'",site_url()."/home/spu/preview/{SPU_ID}"), "dbo.FORMAT_NOMOR('SPS',NOMOR_SPS) +'<div>'+ CONVERT(VARCHAR(10), TANGGAL_TERIMA_TPS, 120) +'</div>'", "dbo.FORMAT_NOMOR('SP',NOMOR_SP) +'<div>'+ CONVERT(VARCHAR(10), TANGGAL_PERINTAH, 120) +'</div>'", "dbo.URAIAN_M_TABEL('ANGGARAN_SAMPLING', SUBSTRING(SPU_ID, 7,2)) +'<div>'+ dbo.URAIAN_M_TABEL('ASAL_SAMPLING', ASAL_SAMPEL)+'</div>'","dbo.KATEGORI(SUBSTRING(SPU_ID, 13,2),'0')", "dbo.URAIAN_M_TABEL('STATUS',STATUS)"));
			$this->newtable->search(array(array("dbo.FORMAT_NOMOR('SPU',SPU_ID)", "Nomor Surat Permintaan Uji"),array("CONVERT(VARCHAR(10), TANGGAL, 120)","Tanggal Surat"),array("dbo.FORMAT_NOMOR('SPS',NOMOR_SPS)", "Nomor Surat Penyerahan Sampel"),array("CONVERT(VARCHAR(10), TANGGAL_TERIMA_TPS, 120)","Tanggal Penerimaan Sampel"), array("dbo.URAIAN_M_TABEL('ANGGARAN_SAMPLING', SUBSTRING(SPU_ID, 7,2))","Anggaran Sampel"),array("dbo.URAIAN_M_TABEL('ASAL_SAMPLING', ASAL_SAMPEL)","Asal Sampel"),array("dbo.KATEGORI(SUBSTRING(SPU_ID, 13,2),'0')","Komoditi"),array("dbo.URAIAN_M_TABEL('STATUS',STATUS)","Status SPU")));
			$this->newtable->width(array('NOMOR & TANGGAL SPU' => 125, 'NOMOR & TANGGAL SPS' => 125, 'NOMOR & TANGGAL PERINTAH' => 125, 'ANGGARAN & ASAL SAMPEL' => 200, 'KOMODITI' => 75,'TOTAL SAMPEL' => 50, 'STATUS' => 150));
			$this->newtable->action(site_url()."/home/pengujian/spp/list/".$id);
			$this->newtable->cidb($this->db);
			$this->newtable->ciuri($this->uri->segment_array());
			$this->newtable->orderby(1);
			$this->newtable->sortby("ASC");
			$this->newtable->hiddens(array('SPU_ID'));
			$this->newtable->keys(array('SPU_ID'));
			if($id == "verifikasi"){
				$proses['Tambah SPP Baru'] = array('GET', site_url()."/home/pengujian/spp/new", '1');
			}
			$proses['Preview Data SPU'] = array('GET', site_url()."/home/spu/preview", '1');
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
	
}	
?>