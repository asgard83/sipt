<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Master extends Controller{

	function Master(){
		parent::Controller();
	}

	function index(){
	  	$this->fungsi->redirectMessage('Maaf anda tidak bisa mengakses halaman ini.','/home');
	}

	function save($jenis="", $setaction="", $isajax=""){#Save Master Data Sarana
		if(strtolower($_SERVER['REQUEST_METHOD'])!="post"){
	  		$this->fungsi->redirectMessage('Maaf anda tidak bisa mengakses halaman ini.','/home');
		}else{
			if($jenis=="sarana"){
				$this->load->model('master/sarana_act');
				$ret = $this->sarana_act->SaveForm($setaction, $isajax);
			}else if($jenis=="produk"){
				$this->load->model('master/produk_act');
				$ret = $this->produk_act->SaveForm($setaction, $isajax);
			}else if($jenis=="sampel"){
				$this->load->model('master/sampel_act');
				$ret = $this->sampel_act->SaveForm($setaction, $isajax);
			}else if($jenis=="pemasaran"){
				$this->load->model('master/sarana_act');
				$ret = $this->sarana_act->SavePemasaran($setaction, $isajax);
			}else if($jenis=="izin"){
				$this->load->model('master/sarana_act');
				$ret = $this->sarana_act->SaveIzin($setaction, $isajax);
			}else if($jenis=="sertifikat"){
				$this->load->model('master/sarana_act');
				$ret = $this->sarana_act->SaveSertifikat($setaction, $isajax);
			}else if($jenis=="pangan"){
				$this->load->model('master/sarana_act');
				$ret = $this->sarana_act->SavePangan($setaction, $isajax);
			}else if($jenis=="jenis"){
				$this->load->model('master/sarana_act');
				$ret = $this->sarana_act->SaveJenisDistribusi($setaction, $isajax);
			}else if($jenis=="petugas"){
				$this->load->model('master/petugas_act');
				$ret = $this->petugas_act->SavePetugas($setaction, $isajax);
			}else if($jenis=="daerah"){
				$this->load->model('master/geo_act');
				$ret = $this->geo_act->SaveDaerah($setaction, $isajax);
			}else if($jenis=="pejabat"){
				$this->load->model('master/pejabat_act');
				$ret = $this->pejabat_act->SavePejabat($setaction, $isajax);
			}else if ($jenis == "media") {
          $this->load->model('master/media_act');
          $ret = $this->media_act->SaveForm($setaction, $isajax);
   }
		}
		if($isajax!="ajax"){
	  		$this->fungsi->redirectMessage('Maaf anda tidak bisa mengakses halaman ini.','/home');
		}
		echo $ret;
	}


	function set_temuan_produk($action="", $isajax=""){#Set Temuan Produk Pemeriksaan
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

	function petugas($action="", $isajax=""){#Master Data Petugas
		if(strtolower($_SERVER['REQUEST_METHOD'])!="post"){
			redirect(base_url());
			exit();
		}else{
			$this->load->model('master/petugas_act');
			$ret = $this->petugas_act->set_petugas($action, $isajax);
		}

		if($isajax!="ajax"){
			redirect(base_url());
			exit();
		}
		echo $ret;
	}

	function set_petugas($action="", $isajax=""){#Set Data Petugas Pemeriksa
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

	function verifikasi($action="", $isajax=""){#Master Verifikasi
		if(strtolower($_SERVER['REQUEST_METHOD'])!="post"){
			redirect(base_url());
			exit();
		}else{
			$this->load->model('admin/verifikasi_act');
			$ret = $this->verifikasi_act->set_verifikasi($action, $isajax);
		}

		if($isajax!="ajax"){
			redirect(base_url());
			exit();
		}
		echo $ret;
	}

	function pelanggaran($action="", $isajax=""){#Master Jenis Pelanggaran
		if(strtolower($_SERVER['REQUEST_METHOD'])!="post"){
			redirect(base_url());
			exit();
		}else{
			$this->load->model('master/pelanggaran_act');
			$ret = $this->pelanggaran_act->set_pelanggaran($action, $isajax);
		}

		if($isajax!="ajax"){
			redirect(base_url());
			exit();
		}
		echo $ret;
	}

	function pejabat($action="", $isajax=""){#Master Pejabat Penanda Tangan
		if(strtolower($_SERVER['REQUEST_METHOD'])!="post"){
			redirect(base_url());
			exit();
		}else{
			$this->load->model('master/pejabat_act');
			$ret = $this->pejabat_act->SavePejabat($action, $isajax);
		}

		if($isajax!="ajax"){
			redirect(base_url());
			exit();
		}
		echo $ret;
	}

	function hapus($jenis="", $isajax=""){#Hapus Master Data
		if(strtolower($_SERVER['REQUEST_METHOD'])!="post"){
	  		$this->fungsi->redirectMessage('Maaf anda tidak bisa mengakses halaman ini.','/home');
		}else{
			if($jenis=="sarana"){
				$this->load->model('master/sarana_act');
				$ret = $this->sarana_act->DeleteSarana($isajax);
			}else if($jenis=="pemasaran"){
				$this->load->model('master/sarana_act');
				$ret = $this->sarana_act->DeletePemasaran($isajax);
			}else if($jenis=="izin"){
				$this->load->model('master/sarana_act');
				$ret = $this->sarana_act->DeleteIzin($isajax);
			}else if($jenis=="serifikat"){
				$this->load->model('master/sarana_act');
				$ret = $this->sarana_act->DeleteSertifikat($isajax);
			}else if($jenis=="pangan"){
				$this->load->model('master/sarana_act');
				$ret = $this->sarana_act->DeletePangan($isajax);
			}else if($jenis=="jenis"){
				$this->load->model('master/sarana_act');
				$ret = $this->sarana_act->DeleteJenisDistribusi($isajax);
			}else if($jenis=="lokal"){
				$this->load->model('master/produk_act');
				$ret = $this->produk_act->DeleteLokal($isajax);
			}
		}
		if($isajax!="ajax"){
	  		$this->fungsi->redirectMessage('Maaf anda tidak bisa mengakses halaman ini.','/home');
		}
		echo $ret;
	}

	function srlpengujian($action="", $isajax=""){#Master SRL Pengujian
		if(strtolower($_SERVER['REQUEST_METHOD'])!="post"){
			redirect(base_url());
			exit();
		}else{
			$this->load->model('master/srlpengujian_act');
			$ret = $this->srlpengujian_act->set_srlpengujian($action, $isajax);
		}

		if($isajax!="ajax"){
			redirect(base_url());
			exit();
		}
		echo $ret;
	}

	function golongan($action="", $isajax=""){#Master SRL Pengujian
		if(strtolower($_SERVER['REQUEST_METHOD'])!="post"){
			redirect(base_url());
			exit();
		}else{
			$this->load->model('master/srlpengujian_act');
			$ret = $this->srlpengujian_act->set_golongan($action, $isajax);
		}

		if($isajax!="ajax"){
			redirect(base_url());
			exit();
		}
		echo $ret;
	}
	function spesifik($action="", $isajax=""){#Master Data Spesifik Lokal
		if(strtolower($_SERVER['REQUEST_METHOD'])!="post"){
			redirect(base_url());
			exit();
		}else{
			$this->load->model('master/spesifik_lokal_act');
			$ret = $this->spesifik_lokal_act->set_golongan($action, $isajax);
		}

		if($isajax!="ajax"){
			redirect(base_url());
			exit();
		}
		echo $ret;
	}

	function spesifik_lokal($action="", $isajax=""){#Master Data Parameter Uji Spesifik Lokal
		if(strtolower($_SERVER['REQUEST_METHOD'])!="post"){
			redirect(base_url());
			exit();
		}else{
			$this->load->model('master/spesifik_lokal_act');
			$ret = $this->spesifik_lokal_act->set_params($action, $isajax);
		}

		if($isajax!="ajax"){
			redirect(base_url());
			exit();
		}
		echo $ret;
	}

	function srl($action="", $isajax){
		if(strtolower($_SERVER['REQUEST_METHOD'])!="post"){
			redirect(base_url());
			exit();
		}else{
			if($action == "view"){
				$id = $_POST['tb_chk'][0];
				$this->load->model('master/srlpengujian_act');
				$arrdata = $this->srlpengujian_act->get_srl($id);
				$ret = $this->load->view('master/pop-up-parameter-uji',$arrdata,true);
			}
		}

		if($isajax!="ajax"){
			redirect(base_url());
			exit();
		}
		echo $ret;
	}

	function bpom($action="", $isajax=""){#Master Verifikasi
		if(strtolower($_SERVER['REQUEST_METHOD'])!="post"){
			redirect(base_url());
			exit();
		}else{
			$this->load->model('admin/bpom_act');
			$ret = $this->bpom_act->set_bpom($action, $isajax);
		}

		if($isajax!="ajax"){
			redirect(base_url());
			exit();
		}
		echo $ret;
	}

}
?>