<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Sampelx extends Controller{
	
	function Sampel(){
		parent::Controller();
	}
	
	function index(){
	  	$this->fungsi->redirectMessage('Maaf anda tidak bisa mengakses halaman ini.','/home');
	}
	
	function sampelx_act($action="", $isajax=""){
		if(strtolower($_SERVER['REQUEST_METHOD'])!="post"){
			redirect(base_url());
			exit();
		}else{
			$this->load->model('pengujian/sampelx_act');
			$ret = $this->sampelx_act->set_sampel($action, $isajax);
		}
		if($isajax!="ajax"){
	  		$this->fungsi->redirectMessage('Maaf anda tidak bisa mengakses halaman ini.','/home');
		}
		echo $ret;
	}
	
	function kirim_act($action="", $isajax=""){
		if(strtolower($_SERVER['REQUEST_METHOD'])!="post"){
			redirect(base_url());
			exit();
		}else{
			$this->load->model('pengujian/daftar_sampel_act');
			$ret = $this->daftar_sampel_act->set_sampel($action, $isajax);
		}
		if($isajax!="ajax"){
	  		$this->fungsi->redirectMessage('Maaf anda tidak bisa mengakses halaman ini.','/home');
		}
		echo $ret;
	}
	
	function pemdik($action){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			if($action=="spu"){
				$sipt =& get_instance();
				$this->load->model("main", "main", true);
				$kode = "";
				foreach($this->input->post('tb_chk') as $chk){
					$id = explode(".", $chk);
					$surat = $id[0];
					$kode .= "'".$id[1] . "'" . ",";
				}
				$arrid = substr($kode, 0, -1);
				$query = "SELECT A.KODE_SAMPEL, dbo.GOLONGAN_SAMPEL(A.KLASIFIKASI) AS KLASIFIKASIS, 
					  dbo.GOLONGAN_SAMPEL(A.SUB_KLASIFIKASI) AS SUB_KLASIFIKASI, dbo.GOLONGAN_SAMPEL(A.SUB_SUB_KLASIFIKASI) AS SUB_SUB_KLASIFIKASI, 
					  A.KLASIFIKASI_TAMBAHAN, UPPER(A.NAMA_SAMPEL) AS NAMA_SAMPEL, A.NOMOR_REGISTRASI, A.PABRIK, A.IMPORTIR, 
					  A.BENTUK_SEDIAAN, A.KEMASAN, A.NO_BETS, A.KETERANGAN_ED, A.JUMLAH_SAMPEL, A.SATUAN, A.HARGA_SAMPEL, 
					  A.UJI_KIMIA, A.JUMLAH_KIMIA ,A.UJI_MIKRO, A.JUMLAH_MIKRO, A.SISA, A.KOMPOSISI, A.NETTO, A.EVALUASI_PENANDAAN, 
					  A.CARA_PENYIMPANAN, A.CATATAN, dbo.URAIAN_M_TABEL('KONDISI_SAMPEL',A.KONDISI_SAMPEL) AS KONDISI_SAMPEL,
					  dbo.URAIAN_M_TABEL('ANGGARAN_SAMPLING',D.ANGGARAN) AS ANGGARANS,
					  dbo.URAIAN_M_TABEL('ASAL_SAMPLING',B.ASAL_SAMPLING) AS ASAL,
					  E.NAMA_SARANA AS [TEMPAT SAMPLING],
					  CONVERT(VARCHAR(10), B.TANGGAL_AWAL_SAMPLING, 120) +' s.d ' + CONVERT(VARCHAR(10), B.TANGGAL_AKHIR_SAMPLING, 120) AS [TANGGAL SAMPLING],
					  D.BULAN_ANGGARAN AS BULAN,
					  DATENAME(year, B.TANGGAL_AWAL_SAMPLING) AS TAHUN, D.ANGGARAN, B.ASAL_SAMPLING, A.KLASIFIKASI
					  FROM T_SAMPEL A LEFT JOIN T_PEMERIKSAAN_SAMPLING B ON A.PERIKSA_ID = B.PERIKSA_ID
					  LEFT JOIN T_SURAT_SAMPEL_PELAPORAN C ON B.PERIKSA_ID = C.LAPOR_ID
					  LEFT JOIN T_SURAT_SAMPEL D ON C.SURAT_ID = D.SURAT_ID
					  LEFT JOIN M_SARANA E ON B.SARANA_ID = E.SARANA_ID
					  WHERE A.KODE_SAMPEL IN ($arrid)";
				$res = $sipt->main->get_result($query);
				if($res){
					foreach($query->result_array() as $row){
						$sampel[] = $row; 
						$arrdata = array('sess' => $sampel,'arrid' => str_replace("'","",$arrid));
					}
				}
				echo $this->load->view('pengujian/spu-pemdik/new',$arrdata, true);
			}
		}
	}
	
}
?>