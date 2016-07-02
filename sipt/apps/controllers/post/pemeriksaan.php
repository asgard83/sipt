<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pemeriksaan extends Controller{
	
	function Pemeriksaan(){
		parent::Controller();
	}
	
	function index(){
	  	$this->fungsi->redirectMessage('Maaf anda tidak bisa mengakses halaman ini.','/home');
	}
	
	function set_surat($jenispelaporan="", $isajax=""){#Simpan Surat Tugas
		if(strtolower($_SERVER['REQUEST_METHOD'])!="post"){
			redirect(base_url());
			exit();
		}else{
			if($jenispelaporan == "pemeriksaan"){
				$this->load->model('pemeriksaan/pemeriksaan_act');
				$ret = $this->pemeriksaan_act->set_surat($isajax);
			}
		}
		if($isajax!="ajax"){
	  		$this->fungsi->redirectMessage('Maaf anda tidak bisa mengakses halaman ini.','/home');
		}
		echo $ret;
	}	
	
	function set_periksa($jenis="", $action="", $isajax=""){#Simpan Form Pemeriksaan
		if(strtolower($_SERVER['REQUEST_METHOD'])!="post"){
	  		$this->fungsi->redirectMessage('Maaf anda tidak bisa mengakses halaman ini.','/home');
		}else{
			$mdl = "F".$jenis;
			$func = "SaveForm".$jenis;
			if($jenis=="napza"){
				$this->load->model('pemeriksaan/FNapza');
				$ret = $this->FNapza->SaveFormNapza($action, $isajax);
			}else if($jenis=="03TR"){
				$this->load->model('pemeriksaan/F02TR');
				$ret = $this->F02TR->SaveForm02TR($action, $isajax);			  
			}else{
				$this->load->model('pemeriksaan/'.$mdl);
				$ret = $this->$mdl->$func($action, $isajax);			  
			}
		}
		if($isajax!="ajax"){
	  		$this->fungsi->redirectMessage('Maaf anda tidak bisa mengakses halaman ini.','/home');
		}
		echo $ret;
	}
	
	function set_proses($jenis="", $role="", $isajax=""){#Simpan Verifikasi Pemeriksaan
		if(strtolower($_SERVER['REQUEST_METHOD'])!="post"){
	  		$this->fungsi->redirectMessage('Maaf anda tidak bisa mengakses halaman ini.','/home');
		}else{
			$mdl = "F".$jenis;
			if($jenis=="napza"){
				$this->load->model('pemeriksaan/FNapza');
				$ret = $this->FNapza->set_status($role, $isajax);
			}else if($jenis=="03TR"){
				$this->load->model('pemeriksaan/F02TR');
				$ret = $this->F02TR->set_status($role, $isajax);
			}else{
				$this->load->model('pemeriksaan/'.$mdl);
				$ret = $this->$mdl->set_status($role, $isajax);
			}
		}
		if($isajax!="ajax"){
	  		$this->fungsi->redirectMessage('Maaf anda tidak bisa mengakses halaman ini.','/home');
		}
		echo $ret;
	}
	
	function set_kirim($action="",$isajax=""){#Kirim Pemeriksaan Ke Unit Insert/was
		if(strtolower($_SERVER['REQUEST_METHOD'])!="post"){
			redirect(base_url());
			exit();
		}else{
			$this->load->model('pemeriksaan/pemeriksaan_act');
			$ret = $this->pemeriksaan_act->set_kirim($action, $isajax);
		}
		
		if($isajax!="ajax"){
			redirect(base_url());
			exit();
		}
		echo $ret;
	}

	function set_all($isajax = ""){
		if(strtolower($_SERVER['REQUEST_METHOD'])!="post"){
			redirect(base_url());
			exit();
		}else{
			$sipt =& get_instance();
			$sipt->load->model("main", "main", true);
			$pelaporan = "'".join("', '", array_keys($this->newsession->userdata('SESS_JENIS_PELAPORAN')))."'";
			$role = "'".join("', '", array_keys($this->newsession->userdata('SESS_KODE_ROLE')))."'";
			$src = "<form id=\"fset_all\" action=\"".site_url()."/post/pemeriksaan/all_checked/all/ajax\">";
			$src .= "<div><b>Kirim Data Terpilih</b></div>";
			$src .= "<ul style=\"list-style:decimal; margin-left:17px;\">";
			foreach($this->input->post('tb_chk') as $a){
				$split_uri = explode("/", $a);
				$id_uri = explode(".", $split_uri[3]);
				if(array_key_exists('6', $this->newsession->userdata('SESS_KODE_ROLE')))
				$next = "60020";
				else
				$next = $sipt->main->get_uraian("SELECT SESUDAH FROM M_VERIFIKASI WHERE PELAPORAN_ID IN($pelaporan) AND ROLE_ID IN($role) AND SEBELUM IN('".$id_uri[1]."') AND PROSES = '1'","SESUDAH"); 
				$src .= "<li>".$sipt->main->get_uraian("SELECT NAMA_SARANA FROM M_SARANA WHERE SARANA_ID ='".$split_uri[0]."'","NAMA_SARANA")."<input type=\"hidden\" name=\"PERIKSA_ID[]\" value=\"".$id_uri[0]."\"></li>";
			}
			$src .= "</ul>";
			$src .= "<div style=\"padding-top:5px;\"><b>Mengirim Ke : ".$sipt->main->get_uraian("SELECT URAIAN FROM M_TABEL WHERE JENIS = 'STATUS' AND KODE = '".$next."'","URAIAN")."</b></div>";
			$src .= "<div style=\"padding-top:5px;\">Catatan :</div>";
			$src .= "<div style=\"padding-top:5px;\"><textarea class=\"stext catatan\" rel=\"required\" name=\"CATATAN\"></textarea></div>";
			$src .= "<div style=\"padding-top:5px;\"><a href=\"#\" class=\"button check\" id=\"set_all\"><span><span class=\"icon\"></span>&nbsp; Proses &nbsp;</span></a></div>";
			$src .= "<input type=\"hidden\" name=\"HASIL\" value=\"".$next."\">";
			$src .= "</form";
			echo $src;
		}
	}
	
	function all_checked($action="",$isajax=""){
		if(strtolower($_SERVER['REQUEST_METHOD'])!="post"){
			redirect(base_url());
			exit();
		}else{
			$this->load->model('pemeriksaan/pemeriksaan_act');
			$ret = $this->pemeriksaan_act->set_kirim($action, $isajax);
		}
		echo $ret;
	}

	function set_confirm($isajax="", $id="", $catatan=""){
		$this->load->model('pemeriksaan/pemeriksaan_act');
		$ret = $this->pemeriksaan_act->set_confirm($isajax, $id, $catatan);
		if($isajax!="ajax"){
			redirect(base_url());
			exit();
		}
		echo $ret;
	}
	
	function set_petugas($action="", $isajax=""){#Tambah dan Edit Petugas Pemeriksa
		if(strtolower($_SERVER['REQUEST_METHOD'])!="post"){
			redirect(base_url());
			exit();
		}else{
			$this->load->model('pemeriksaan/pemeriksaan_act');
			$ret = $this->pemeriksaan_act->set_petugas($action, $isajax);
		}
		if($isajax!="ajax"){
	  		$this->fungsi->redirectMessage('Maaf anda tidak bisa mengakses halaman ini.','/home');
		}
		echo $ret;
	}

	function set_newsurat($action="", $isajax=""){#Tambah dan Edit Petugas Pemeriksa
		if(strtolower($_SERVER['REQUEST_METHOD'])!="post"){
			redirect(base_url());
			exit();
		}else{
			$this->load->model('pemeriksaan/pemeriksaan_act');
			$ret = $this->pemeriksaan_act->set_newsurat($action, $isajax);
		}
		if($isajax!="ajax"){
	  		$this->fungsi->redirectMessage('Maaf anda tidak bisa mengakses halaman ini.','/home');
		}
		echo $ret;
	}

	
	function set_preview_distribusi(){#Preview Temuan Distribusi
		foreach($this->input->post('PEMERIKSAAN_DISTRIBUSI') as $a => $b){
			$c['PREV'][$a] = $b;
		}
		$str = '';
		$str .= '<b>Preview Hasil Aspek Temuan, Tujuan Pemeriksaan : '.$c['PREV']['TUJUAN_PEMERIKSAAN'].'</b>';
		if($c['PREV']['TUJUAN_PEMERIKSAAN'] == "Rutin"){
		  if(trim($c['PREV']['HASIL_TEMUAN']) != ""){
			  $d = explode('___',$c['PREV']['HASIL_TEMUAN']);
			  if(count($d) > 0){
				  $str .= '<ul style="padding-left:5px; margin-left:15px; list-style-type:decimal;">';
				  foreach($d as $e){
					  $str .= '<li>' .$e. '</li>';
				  }
				  $str .= '</ul>';
				  $str .= '<p><b>Hasil Temuan Lainnya yang Tidak Tercantum dalam Aspek Penilaian</b></p>';
				  $str .= $c['PREV']['HASIL_TEMUAN_LAIN'];
			  }
		  }
		}else if($c['PREV']['TUJUAN_PEMERIKSAAN'] == "Kasus"){
			$str .= '<h4 class="small">A. PROFIL SARANA DAN ORGANISASI</h4><div>'.$c['PREV']['KASUS_POINT_A'].'</div><h4 class="small">B. PERSONALIA</h4><div>'.$c['PREV']['KASUS_POINT_B'].'</div><h4 class="small">C. GUDANG DAN PERLENGKAPAN</h4><div>'.$c['PREV']['KASUS_POINT_C'].'</div><h4 class="small">D. PENGADAAN</h4><div>'.$c['PREV']['KASUS_POINT_D'].'</div><h4 class="small">E. PENYIMPANAN</h4><div>'.$c['PREV']['KASUS_POINT_E'].'</div><h4 class="small">F. PENDISTRIBUSIAN</h4><div>'.$c['PREV']['KASUS_POINT_F'].'</div><h4 class="small">G. DOKUMENTASI</h4><div>'.$c['PREV']['KASUS_POINT_G'].'</div><h4 class="small">H. LAIN-LAIN</h4><div>'.$c['PREV']['KASUS_POINT_H'].'</div>';
		}else{
			$str = "Tujuan Pemeriksaan Belum di Pilih";
		}
		echo $str;
	}
	
	function hapus_act($action="",$isajax=""){#Hapus Pemeriksaan
		if(strtolower($_SERVER['REQUEST_METHOD'])!="post"){
			redirect(base_url());
			exit();
		}else{
			$this->load->model('pemeriksaan/pemeriksaan_act');
			$ret = $this->pemeriksaan_act->set_hapus($action, $isajax);
		}
		
		if($isajax!="ajax"){
			redirect(base_url());
			exit();
		}
		echo $ret;
	}
	
	function set_tl($action="", $isajax){#Surat Tindak Lanjut
		if(strtolower($_SERVER['REQUEST_METHOD'])!="post"){
			redirect(base_url());
			exit();
		}else{
			$this->load->model('pemeriksaan/TL_act');
			$ret = $this->TL_act->set_tl($action, $isajax);
		}
		
		if($isajax!="ajax"){
			redirect(base_url());
			exit();
		}
		echo $ret;
	}
	
	function proses_tl($action="", $isajax){#Proses Surat Tindak Lanjut
		if(strtolower($_SERVER['REQUEST_METHOD'])!="post"){
			redirect(base_url());
			exit();
		}else{
			$this->load->model('pemeriksaan/TL_act');
			$ret = $this->TL_act->proses_tl($action, $isajax);
		}
		
		if($isajax!="ajax"){
			redirect(base_url());
			exit();
		}
		echo $ret;
	}	
	
	function set_produk($action="", $isajax=""){#Set Temuan Produk
		if(strtolower($_SERVER['REQUEST_METHOD'])!="post"){
			redirect(base_url());
			exit();
		}else{
			$this->load->model('pemeriksaan/tproduk_act');
			$ret = $this->tproduk_act->set_produk($action, $isajax);
		}
		
		if($isajax!="ajax"){
			redirect(base_url());
			exit();
		}
		echo $ret;
	}
	
	function set_riwayat($action="",$isajax=""){
		if(strtolower($_SERVER['REQUEST_METHOD'])!="post"){
			redirect(base_url());
			exit();
		}else{
			$this->load->model('pemeriksaan/pemeriksaan_act');
			$ret = $this->pemeriksaan_act->set_riwayat($action, $isajax);
		}
		if($isajax!="ajax"){
			redirect(base_url());
			exit();
		}
		echo $ret;
	}
	
	function set_header($action="",$isajax=""){
		if(strtolower($_SERVER['REQUEST_METHOD'])!="post"){
			redirect(base_url());
			exit();
		}else{
			$this->load->model('pemeriksaan/pemeriksaan_act');
			$ret = $this->pemeriksaan_act->set_header($action, $isajax);
		}
		if($isajax!="ajax"){
			redirect(base_url());
			exit();
		}
		echo $ret;
	}

}
?>