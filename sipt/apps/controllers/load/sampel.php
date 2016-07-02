<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Sampel extends Controller{
	
	function Sampel(){
		parent::Controller();
	}
	
	function list_sampel($id){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$this->load->library('newtable');
			$this->newtable->hiddens(array('PERIKSA_ID','SERI'));
			$query = "SELECT A.PERIKSA_ID, A.SERI, A.KODE_SAMPEL AS [KODE SAMPEL],
			A.NAMA_SAMPEL +'<div>&bull;&nbsp;'+A.BENTUK_SEDIAAN+'</div><div>&bull;&nbsp;'+A.PABRIK+'</div><div>&bull;&nbsp;'+A.NOMOR_REGISTRASI+'</div><div>&bull;&nbsp;'+A.NO_BETS+'</div>' AS [SAMPEL],
			dbo.GOLONGAN_SAMPEL(A.KLASIFIKASI)+'<div>&bull;&nbsp;'+dbo.GOLONGAN_SAMPEL(A.SUB_KLASIFIKASI)+'</div><div>&bull;&nbsp;'+dbo.GOLONGAN_SAMPEL(A.SUB_SUB_KLASIFIKASI)+'</div><div>&bull;&nbsp;'+A.KLASIFIKASI_TAMBAHAN+'</div>' AS KOMODITI,
			dbo.URAIAN_M_TABEL('ANGGARAN_SAMPLING',B.ANGGARAN) +'<div>'+D.NOMOR +'</div>' AS [ANGGARAN <br> NOMOR SURAT],
			E.NAMA_SARANA +'<div>'+CONVERT(VARCHAR(10), B.TANGGAL_AWAL_SAMPLING, 120) +' s.d ' + CONVERT(VARCHAR(10), B.TANGGAL_AKHIR_SAMPLING, 120)+'<div>' AS [TEMPAT <br> TANGGAL SAMPLING], dbo.URAIAN_M_TABEL('STATUS', A.STATUS_SAMPEL) AS STATUS
			FROM T_SAMPEL A LEFT JOIN T_PEMERIKSAAN_SAMPLING B ON A.PERIKSA_ID = B.PERIKSA_ID
			LEFT JOIN T_SURAT_SAMPEL_PELAPORAN C ON B.PERIKSA_ID = C.LAPOR_ID
			LEFT JOIN T_SURAT_SAMPEL D ON C.SURAT_ID = D.SURAT_ID
			LEFT JOIN M_SARANA E ON B.SARANA_ID = E.SARANA_ID
			WHERE B.BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND A.KIRIM_ID = '".$id."'";
			$this->newtable->columns(array("A.PERIKSA_ID", "A.SERI", "A.KODE_SAMPEL","A.NAMA_SAMPEL +'<div>&bull;&nbsp;'+A.BENTUK_SEDIAAN+'</div><div>&bull;&nbsp;'+A.PABRIK+'</div><div>&bull;&nbsp;'+A.NOMOR_REGISTRASI+'</div><div>&bull;&nbsp;'+A.NO_BETS+'</div>'","dbo.GOLONGAN_SAMPEL(A.KLASIFIKASI)+'<div>&bull;&nbsp;'+dbo.GOLONGAN_SAMPEL(A.SUB_KLASIFIKASI)+'</div><div>&bull;&nbsp;'+dbo.GOLONGAN_SAMPEL(A.SUB_SUB_KLASIFIKASI)+'</div><div>&bull;&nbsp;'+A.KLASIFIKASI_TAMBAHAN+'</div>'","dbo.URAIAN_M_TABEL('ANGGARAN_SAMPLING',B.ANGGARAN) +'<div>'+D.NOMOR +'</div>'","E.NAMA_SARANA +'<div>'+CONVERT(VARCHAR(10), B.TANGGAL_AWAL_SAMPLING, 120) +' s.d ' + CONVERT(VARCHAR(10), B.TANGGAL_AKHIR_SAMPLING, 120)+'<div>'","dbo.URAIAN_M_TABEL('STATUS', A.STATUS_SAMPEL)"));
			$this->newtable->width(array('KODE SAMPEL' => 75, 'SAMPEL' => 175, 'KOMODITI' => 100, 'ANGGARAN <br> NOMOR SURAT' => 100, 'TEMPAT <br> TANGGAL SAMPLING' => 150, 'STATUS' => 50));
			$this->newtable->keys(array('PERIKSA_ID','SERI','KODE SAMPEL'));
			$this->newtable->columns(array("A.PERIKSA_ID", "A.SERI", "A.KODE_SAMPEL","A.NAMA_SAMPEL +'<div>&bull;&nbsp;'+A.BENTUK_SEDIAAN+'</div><div>&bull;&nbsp;'+A.PABRIK+'</div><div>&bull;&nbsp;'+A.NOMOR_REGISTRASI+'</div><div>&bull;&nbsp;'+A.NO_BETS+'</div>'","dbo.GOLONGAN_SAMPEL(A.KLASIFIKASI)+'<div>&bull;&nbsp;'+dbo.GOLONGAN_SAMPEL(A.SUB_KLASIFIKASI)+'</div><div>&bull;&nbsp;'+dbo.GOLONGAN_SAMPEL(A.SUB_SUB_KLASIFIKASI)+'</div><div>&bull;&nbsp;'+A.KLASIFIKASI_TAMBAHAN+'</div>'","dbo.URAIAN_M_TABEL('ANGGARAN_SAMPLING',B.ANGGARAN) +'<div>'+D.NOMOR +'</div>'","E.NAMA_SARANA +'<div>'+CONVERT(VARCHAR(10), B.TANGGAL_AWAL_SAMPLING, 120) +' s.d ' + CONVERT(VARCHAR(10), B.TANGGAL_AKHIR_SAMPLING, 120)+'<div>'","dbo.URAIAN_M_TABEL('STATUS', A.STATUS_SAMPEL)"));
			$this->newtable->search(array(array('', '')));
			$this->newtable->action(site_url());
			$this->newtable->cidb($this->db);
			$this->newtable->ciuri($this->uri->segment_array());
			$this->newtable->orderby(1);
			$this->newtable->sortby("ASC");
			$this->newtable->rowcount("ALL");
			$this->newtable->show_chk(FALSE);
			$this->newtable->show_search(FALSE);
			$tabel = $this->newtable->generate($query);
			echo $tabel;
		}else{
			$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
		}
	}
	
}
?>