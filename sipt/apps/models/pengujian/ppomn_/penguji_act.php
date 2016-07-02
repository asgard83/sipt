<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR);
class Penguji_act extends Model{
	function list_uji($id){
		if((in_array('2', $this->newsession->userdata('SESS_KODE_ROLE')) && in_array('02', $this->newsession->userdata('SESS_JENIS_PELAPORAN'))) && $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model('main','main',TRUE);
			$this->load->library('newtable');
			if($id!="all")
				$status = " AND STATUS = '$id'";
			else
				$status = " AND STATUS NOT IN ('20101')";
			$this->newtable->hiddens(array('UJI_ID','KODE_SAMPEL'));
			/*if(in_array('B1',$this->newsession->userdata('SESS_SUB_SARANA')) || in_array('B2',$this->newsession->userdata('SESS_SUB_SARANA'))){
				$query = "SELECT A.UJI_ID, A.KODE_SAMPEL, dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) AS [KODE SAMPEL], A.PARAMETER_UJI AS [PARAMETER UJI], A.METODE +'<div>'+A.PUSTAKA+'</div>' AS [METODE & PUSTAKA], A.SYARAT +'<div>'+A.RUANG_LINGKUP+'</div>' AS [SYARAT & RL],C.URAIAN AS STATUS FROM T_PARAMETER_HASIL_UJI A LEFT JOIN T_M_SAMPEL B ON A.KODE_SAMPEL = B.KODE_SAMPEL LEFT JOIN M_TABEL C ON A.STATUS = C.KODE WHERE A.PENGUJI = '".$this->newsession->userdata('SESS_USER_ID')."' AND C.JENIS = 'STATUS' $status";
			}else if(in_array('B3',$this->newsession->userdata('SESS_SUB_SARANA'))){
				$query = "SELECT A.UJI_ID, A.KODE_SAMPEL, dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) AS [KODE SAMPEL], A.PARAMETER_UJI AS [PARAMETER UJI], A.METODE +'<div>'+A.PUSTAKA+'</div>' AS [METODE & PUSTAKA], A.SYARAT +'<div>'+A.RUANG_LINGKUP+'</div>' AS [SYARAT & RL],C.URAIAN AS STATUS FROM T_PARAMETER_HASIL_UJI A LEFT JOIN T_M_SAMPEL B ON A.KODE_SAMPEL = B.KODE_SAMPEL LEFT JOIN M_TABEL C ON A.STATUS = C.KODE WHERE A.PENGUJI = '".$this->newsession->userdata('SESS_USER_ID')."' AND C.JENIS = 'STATUS' $status";
			}*/
			$query = "SELECT A.KODE_SAMPEL, dbo.FORMAT_NOMOR('SPL', A.KODE_SAMPEL) AS [KODE SAMPEL], dbo.KATEGORI(A.KOMODITI) AS KOMODITI, STUFF(dbo.PARAMUJI(A.KODE_SAMPEL,'".$this->newsession->userdata('SESS_USER_ID')."'),1,1,'') AS [PARAMETER UJI] FROM T_M_SAMPEL A 
WHERE A.KODE_SAMPEL IN (SELECT KODE_SAMPEL FROM T_PARAMETER_HASIL_UJI WHERE PENGUJI = '".$this->newsession->userdata('SESS_USER_ID')."' $status GROUP BY KODE_SAMPEL, PENGUJI)";
			$this->newtable->search(array(array("dbo.FORMAT_NOMOR('SPL', A.KODE_SAMPEL)", "Kode Sampel"),
										  array("dbo.KATEGORI(A.KOMODITI)", "Komoditi"),
										  array("STUFF(dbo.PARAMUJI(A.KODE_SAMPEL,'".$this->newsession->userdata('SESS_USER_ID')."'),1,1,'')", "Parameter Uji")));
			$this->newtable->columns(array("A.KODE_SAMPEL", "dbo.FORMAT_NOMOR('SPL', A.KODE_SAMPEL)", "dbo.KATEGORI(A.KOMODITI)","STUFF(dbo.PARAMUJI(A.KODE_SAMPEL,'".$this->newsession->userdata('SESS_USER_ID')."'),1,1,'')"));	
			$this->newtable->action(site_url()."/home/ppomn/uji/list/".$id);
			$this->newtable->width(array('KODE SAMPEL' => 175, 'KOMODITI' => 150));
			$this->newtable->cidb($this->db);
			$this->newtable->ciuri($this->uri->segment_array());
			$this->newtable->orderby(1);
			$this->newtable->sortby("ASC");
			$this->newtable->keys(array('KODE_SAMPEL'));
			if($id!="all")
				$proses['Entri Uji Sampel'] = array('GET', site_url()."/home/ppomn/uji/new", '1');
			else
				$proses['Edit Sampel'] = array('GET', site_url()."/home/ppomn/uji/new", '1');
			$this->newtable->menu($proses);
			$tabel = $this->newtable->generate($query);
			$arrdata = array('table' => $tabel,
							 'idjudul' => 'juduluji',
							 'caption_header' => 'Data Perintah Pengujian',
							 'batal' => '',
							 'cancel' => '');
			return $arrdata;
		}
	}
	
	
	function get_uji($id){
		if((in_array('2', $this->newsession->userdata('SESS_KODE_ROLE')) && in_array('02', $this->newsession->userdata('SESS_JENIS_PELAPORAN'))) && $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model('main','main',TRUE);
			$arrdata = array();
			$boleh = array('20201','20202');
			
			#$isboleh = $sipt->main->get_uraian("SELECT STATUS AS DATA FROM T_PARAMETER_HASIL_UJI WHERE UJI_ID = '".$currid[0]."'","DATA");
			#if(!in_array($isboleh, $boleh)) return $this->fungsi->redirectMessage('Maaf, status sampel tidak bisa diedit. Sampel telah masuk ke dalam draft pembuatan CP / LCP','/home/pengujian/spp/penguji/all');
			
			#$query = "SELECT dbo.FORMAT_NOMOR('LAB',A.UJI_ID) AS KODE_UJI, A.UJI_ID, A.SPK_ID, dbo.FORMAT_NOMOR('SPL', A.KODE_SAMPEL) AS KODE, A.KODE_SAMPEL, A.PARAMETER_UJI, A.METODE, A.PUSTAKA, A.SYARAT, A.RUANG_LINGKUP, A.IDENTIFIKASI, A.JENIS_UJI, A.SYARAT_UJI, ISNULL(A.JUMLAH_UJI,'0') AS JUMLAH_UJI, A.SISA_UJI, A.REAGEN, A.JUMLAH_REAGEN, A.HASIL, A.HASIL_KUALITATIF, A.CATATAN, CONVERT(VARCHAR(10), A.AWAL_UJI, 103) AS AWAL_UJI, CONVERT(VARCHAR(10), A.AKHIR_UJI, 103) AS AKHIR_UJI, dbo.KATEGORI(B.KOMODITI) AS KOMODITI, dbo.KATEGORI(B.KATEGORI) AS KATEGORI, B.KLASIFIKASI_TAMBAHAN, B.NAMA_SAMPEL, B.NOMOR_REGISTRASI, B.PABRIK, B.IMPORTIR, B.BENTUK_SEDIAAN, B.KEMASAN, B.NO_BETS, B.KETERANGAN_ED, B.JUMLAH_SAMPEL, B.JUMLAH_KIMIA, B.JUMLAH_MIKRO, B.SISA, ISNULL(B.SISA_KIMIA,'0') AS SISA_KIMIA, ISNULL(B.SISA_MIKRO,'0') AS SISA_MIKRO, B.UJI_KIMIA, B.UJI_MIKRO, B.KOMPOSISI, B.EVALUASI_PENANDAAN, B.CARA_PENYIMPANAN, B.PEMERIAN, B.KONDISI_SAMPEL, B.NETTO, B.SATUAN FROM T_PARAMETER_HASIL_UJI A LEFT JOIN T_M_SAMPEL B ON A.KODE_SAMPEL = B.KODE_SAMPEL WHERE A.UJI_ID = '".$currid[0]."' AND B.KODE_SAMPEL = '".$currid[1]."'";
			$query = "SELECT UJI_ID, SPK_ID, dbo.FORMAT_NOMOR('SPL', KODE_SAMPEL) AS KODE, KODE_SAMPEL, PARAMETER_UJI, METODE, PUSTAKA, SYARAT, RUANG_LINGKUP,
JENIS_UJI, JUMLAH_UJI, SISA_UJI, REAGEN, JUMLAH_REAGEN, HASIL, HASIL_KUALITATIF, CATATAN, CONVERT(VARCHAR(10), AWAL_UJI, 103) AS AWAL_UJI, CONVERT(VARCHAR(10), AKHIR_UJI, 103) AS AKHIR_UJI, LCP, STATUS FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL = '".$id."' AND PENGUJI = '".$this->newsession->userdata('SESS_USER_ID')."'";
			$data = $sipt->main->get_result($query);
			if($data){
				foreach($query->result_array() as $row){
					$arrdata['sess'][] = $row;
				}
				$arrdata['act'] = site_url().'/post/ppomn/penguji_act/save';
				$arrdata['sp'] = $this->db->query("SELECT dbo.FORMAT_NOMOR('SPK', A.SPK_ID) AS UR_SPK, CONVERT(VARCHAR(10), A.TANGGAL, 103) AS TGL_SPK, dbo.FORMAT_NOMOR('SPP',B.SPP_ID) AS UR_SPP, CONVERT(VARCHAR(10), B.TANGGAL, 103) AS TGL_SPP FROM T_SPK A LEFT JOIN T_SPP B ON A.SPK_ID = B.SPK_ID WHERE A.SPK_ID = '".$row['SPK_ID']."'")->result_array();
				$arrdata['jml'] = $this->db->query("SELECT JUMLAH_SAMPEL, JUMLAH_KIMIA, JUMLAH_MIKRO, SISA, ISNULL(SISA_KIMIA,'0') AS SISA_KIMIA, ISNULL(SISA_MIKRO,'0') AS SISA_MIKRO, UJI_KIMIA, UJI_MIKRO, SATUAN FROM T_M_SAMPEL WHERE KODE_SAMPEL = '".$id."'")->result_array();
				$arrdata['kode_sampel'] = $id;
				$arrdata['spk_id'] = $row['SPK_ID'];
				
			}
			$arrdata['sampel'] = $this->db->query("SELECT A.PERIKSA_SAMPEL, dbo.FORMAT_NOMOR('SPL', A.KODE_SAMPEL) AS UR_KODESAMPEL,dbo.KATEGORI(A.KOMODITI) AS KOMODITI,dbo.KATEGORI(A.KATEGORI) AS UR_KATEGORI,dbo.URAIAN_M_TABEL('SUB_TUJUAN', A.SUB_TUJUAN) AS SUB_TUJUAN, A.KLASIFIKASI_TAMBAHAN,A.NAMA_SAMPEL,A.NOMOR_REGISTRASI,A.PABRIK,IMPORTIR,A.BENTUK_SEDIAAN,A.KEMASAN,A.NO_BETS,A.KETERANGAN_ED,A.JUMLAH_SAMPEL,A.SATUAN,A.HARGA_SAMPEL,A.UJI_KIMIA,A.JUMLAH_KIMIA,A.UJI_MIKRO,A.JUMLAH_MIKRO,A.SISA,REPLACE(A.KOMPOSISI,';','<br>') AS KOMPOSISI,A.NETTO,A.KONDISI_SAMPEL,A.PEMERIAN,A.EVALUASI_PENANDAAN,A.CARA_PENYIMPANAN, A.LABEL, A.SEGEL,A.CATATAN,A.STATUS_KIMIA,A.STATUS_MIKRO,A.STATUS_SAMPEL,A.LAMPIRAN,B.BBPOM_ID FROM T_M_SAMPEL A LEFT JOIN T_PERIKSA_SAMPEL B ON A.PERIKSA_SAMPEL = B.PERIKSA_SAMPEL WHERE A.KODE_SAMPEL = '".$id."'")->result_array(); 
			$arrdata['file'] = base_url().'files/sampel/'.md5(trim($arrdata['sampel'][0]['BBPOM_ID'])).'/'.$arrdata['sampel'][0]['LAMPIRAN'];
			$arrdata['hasil'] = $sipt->main->referensi("HASIL","'MS','TMS'",FALSE,TRUE);
			$arrdata['batal'] = site_url().'/home/ppomn/uji/list/20201';
			return $arrdata;
		}
	}
	
	function set_uji($action, $isajax){
		if((in_array('2', $this->newsession->userdata('SESS_KODE_ROLE'))) && in_array('02', $this->newsession->userdata('SESS_JENIS_PELAPORAN')) && $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			if($action=="save"){
				$hasil = FALSE;
				$msgok = "Entri Hasil Pengujian berhasil";
				$msgerr = "Entri Hasil Pengujian gagal, Silahkan coba lagi";
				$terpakai = 0;
				$arr_sampel = $this->input->post('UJI');
				$arrkeys_sampel = array_keys($arr_sampel);
				$pemerian = $sipt->main->get_uraian("SELECT PEMERIAN FROM T_M_SAMPEL WHERE KODE_SAMPEL = '".$this->input->post('KODE_SAMPEL')."'","PEMERIAN");
				if(trim($pemerian) == ""){
					$this->db->simple_query("UPDATE T_M_SAMPEL SET PEMERIAN = '".str_replace("'","",$this->input->post('PEMERIAN'))."' WHERE KODE_SAMPEL = '".$this->input->post('KODE_SAMPEL')."'");
				}
				for($i = 0; $i < count($_POST['UJI']['UJI_ID']); $i++){
					$arr_update = array('STATUS' => '30202');
					for($j=0;$j<count($arrkeys_sampel);$j++){
						$arr_update[$arrkeys_sampel[$j]] = $arr_sampel[$arrkeys_sampel[$j]][$i];
					}
					$this->db->where('UJI_ID', $_POST['UJI']['UJI_ID'][$i]);
					if($this->db->update('T_PARAMETER_HASIL_UJI', $arr_update)){
						$hasil = TRUE;
						$terpakai = $terpakai + (int)$_POST['UJI']['JUMLAH_UJI'][$i];
					}
				}
				if($hasil){
					if(in_array('B5',$this->newsession->userdata('SESS_SUB_SARANA'))){#Bidang Mikro
						$jml = $sipt->main->get_uraian("SELECT JUMLAH_MIKRO FROM T_M_SAMPEL WHERE KODE_SAMPEL = '".$this->input->post('KODE_SAMPEL')."'","JUMLAH_MIKRO");
						$this->db->simple_query("UPDATE T_M_SAMPEL SET SISA_MIKRO = '".($jml-$terpakai)."' WHERE KODE_SAMPEL = '".$this->input->post('KODE_SAMPEL')."'");
					}else{
						$jml = $sipt->main->get_uraian("SELECT JUMLAH_KIMIA FROM T_M_SAMPEL WHERE KODE_SAMPEL = '".$this->input->post('KODE_SAMPEL')."'","JUMLAH_KIMIA");
						$this->db->simple_query("UPDATE T_M_SAMPEL SET SISA_KIMIA = '".($jml-$terpakai)."' WHERE KODE_SAMPEL = '".$this->input->post('KODE_SAMPEL')."'");
					}
					$this->db->simple_query("UPDATE T_SPK SET STATUS = '30202' WHERE SPK_ID = '".$this->input->post('SPK_ID')."'");
					$this->db->simple_query("UPDATE T_M_SAMPEL SET STATUS_SAMPEL = '30202' WHERE SPU_ID = '".$this->input->post('KODE_SAMPEL')."'");
					return "MSG#YES#$msgok.#".site_url()."/home/ppomn/uji/list/20201";
				}else{
					return "MSG#YES#$msgerr";
				}
				
				if($isajax!="ajax"){
					redirect(base_url());
					exit();
				}
			}
			else{
			}
		}
	}
}
?>