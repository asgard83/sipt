<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Excels extends Controller{
	function Excels(){
		parent::Controller();
	}
	function index(){
		redirect(base_url());
		exit();
	}
	
	function pemeriksaan($rpt){
		if(strtolower($_SERVER['REQUEST_METHOD'])!="post"){
			redirect(base_url());
			exit();
		}else{
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$jenis = $this->input->post('JENIS');
			if($this->input->post('SELESAI') == "1"){
				$this->load->model('report/mexcel/rekapitulasiall_act');
				$arrdata = $this->rekapitulasiall_act->get_selesai();
			}else{
				if($rpt == "detil"){
					$mdl = "detil_".$jenis;
					$distribusi = array('02MM','02LL','02TF','03AA','03BB','03RS','03TR','03WW');
					$napza = array('01ON','02MN','02TN','03AN','03BN','03NN','03RN','03TP','03WN');
					if(in_array($this->input->post('JENIS'), $distribusi)){
						$this->load->model('report/mexcel/distribusi_act');
						$arrdata = $this->distribusi_act->set_excel_sarana();
					}else if(in_array($this->input->post('JENIS'),$napza)){
						$this->load->model('report/mexcel/napza_act');
						$arrdata = $this->napza_act->set_excel_sarana();	
					}else{												
						$this->load->model('report/mexcel/'.$mdl);
						if($this->input->post('PIRTLAMA')=='pirt2014'){
							$arrdata = $this->$mdl->set_excel_sarana_2014();
						}else {
							$arrdata =  $this->$mdl->set_excel_sarana();
						}										
					}
					echo $arrdata;
				}
			}
		}
	}
	
	function produk(){
		if(strtolower($_SERVER['REQUEST_METHOD'])!="post"){
			redirect(base_url());
			exit();
		}else{
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$this->load->model('report/mexcel/produk_act');
			$jenis = $this->input->post('PRODUK_KLASIFIKASI');
			if($jenis == "001"){
				$arrdata = $this->produk_act->deputi1();
			}else if($jenis == "013"){
				$arrdata = $this->produk_act->deputi3();
			}else if($jenis == "015"){
				$arrdata = $this->produk_act->produkbb();
			}else{
				$arrdata = $this->produk_act->deputi2();
			}
			echo $arrdata;
		}
	}
	
	function rekapitulasi(){
		if(strtolower($_SERVER['REQUEST_METHOD'])!="post"){
			redirect(base_url());
			exit();
		}else{
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			if($this->input->post('chkjenis')){
				$jenis = $this->input->post('JENIS');
				if($jenis==""){
					$this->load->model('report/mexcel/rekapitulasiall_act');
					$arrdata = $this->rekapitulasiall_act->get_all();
				}else{
					$mdl = "detil_".$jenis;
					$func = "rekap_".$jenis;
					$distribusi = array('02MM','02LL','02TF','03AA','03BB','03RS','03TR','03WW');
					$napza = array('01ON','02MN','02TN','03AN','03BN','03NN','03RN','03TP','03WN');
					if(in_array($this->input->post('JENIS'), $distribusi)){
						$this->load->model('report/mexcel/distribusi_act');
						$arrdata = $this->distribusi_act->rekap_distribusi();	
					}else if(in_array($this->input->post('JENIS'),$napza)){
						$this->load->model('report/mexcel/napza_act');
						$arrdata = $this->napza_act->rekap_napza();	
					}else{
						$this->load->model('report/mexcel/'.$mdl);
						$arrdata = $this->$mdl->$func();
					}
				}
			}else{
				$this->load->model('report/mexcel/rekapnew_act');
				if($this->input->post('SARANA') == "01"){
					$func = "set_produksi";
				}else if($this->input->post('SARANA') == "02"){
					$func = "set_distribusi";
				}else if($this->input->post('SARANA') == "03"){
					$func = "set_pelayanan";
				}
				$arrdata = $this->rekapnew_act->$func();
			}
			echo $arrdata;
		}
	}
	
	function status_doc(){
		if(strtolower($_SERVER['REQUEST_METHOD'])!="post"){
			redirect(base_url());
			exit();
		}else{
			$this->load->model('report/mexcel/rekapitulasiall_act');
			if(array_key_exists('10', $this->newsession->userdata('SESS_KODE_ROLE'))){
				$arrdata = $this->rekapitulasiall_act->get_rhpkjenis();
			}else{
				if(!in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))){
					if($this->input->post('isjenis') == "1"){
						$arrdata = $this->rekapitulasiall_act->get_rhpkjenis();
					}else{
						$arrdata = $this->rekapitulasiall_act->get_statdoc();
					}
				}else{
					$arrdata = $this->rekapitulasiall_act->get_statdocunit();
				}
			}
			echo $arrdata;
		}
	}
	
	function status_komoditi(){
		if(strtolower($_SERVER['REQUEST_METHOD'])!="post"){
			redirect(base_url());
			exit();
		}else{
			$this->load->model('report/mexcel/rekapitulasiall_act');
			$arrdata = $this->rekapitulasiall_act->get_statkomoditi();
			echo $arrdata;
		}
	}
	
	function rekap_komoditi(){
		if(strtolower($_SERVER['REQUEST_METHOD'])!="post"){
			redirect(base_url());
			exit();
		}else{
			$this->load->model('report/mexcel/rekapitulasiall_act');
			$arrdata = $this->rekapitulasiall_act->get_rekapkomoditi();
			echo $arrdata;
		}
	}
	
	function rekap_jml(){
		if(strtolower($_SERVER['REQUEST_METHOD'])!="post"){
			redirect(base_url());
			exit();
		}else{
			$this->load->model('report/mexcel/rekapitulasiall_act');
			$arrdata = $this->rekapitulasiall_act->get_jmlsarana();
			echo $arrdata;
		}
	}
	
	function log_sarana(){
		if(strtolower($_SERVER['REQUEST_METHOD'])!="post"){
			redirect(base_url());
			exit();
		}else{
			$this->load->model('report/mexcel/log_sarana_act');
			$arrdata = $this->log_sarana_act->set_log_sarana();
			echo $arrdata;
		}
	} 
	
	## ---------------------- Pengujian 
	function sampel($jenis){
		if(strtolower($_SERVER['REQUEST_METHOD'])!="post"){
			redirect(base_url());
			exit();
		}else{
			if($jenis == "rekap"){
				$this->load->model('report/mexcel/sampel-pengujian/rekapitulasiall_act');
				$arrdata = $this->rekapitulasiall_act->get_sampel();
			}else if($jenis == "rhpk"){
				$this->load->model('report/mexcel/sampel-pengujian/rhpk_act');
				if($this->input->post('all') == "0"){
					$arrdata = $this->rhpk_act->get_rphk();
				}else{
					$arrdata = $this->rhpk_act->get_rphk_all();
				}
			}else if($jenis == "status"){
				$this->load->model('report/mexcel/sampel-pengujian/status_act');
				$arrdata = $this->status_act->get_status();
			}else if($jenis == "hasil-uji"){
				$this->load->model('report/mexcel/sampel-pengujian/hasil_act');
				$arrdata = $this->hasil_act->get_hasil();
			}else if($jenis == "rekap-timeline"){
				$this->load->model('report/mexcel/sampel-pengujian/rekaptimeline_act');
				$arrdata = $this->rekaptimeline_act->get_hasil();
			}
			
			echo $arrdata;
		}
	}

	
}

?>