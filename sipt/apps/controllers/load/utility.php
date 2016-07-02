<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Utility extends Controller{
	
	function Utility(){
		parent::Controller();
	}
	
	function index(){
	  	$this->fungsi->redirectMessage('Maaf anda tidak bisa mengakses halaman ini.','/home');
	}

	function set_notif(){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$sipt->load->model("main", "main", true);
			$qinfo = "SELECT TOP 1 NEWS_ID, JUDUL FROM T_NEWS_UPDATE ORDER BY NEWS_ID DESC";
			$resinfo = $sipt->main->get_result($qinfo);
			$ret = "";
			if($resinfo){
				foreach($qinfo->result() as $row){
					$judul = str_replace(" ", "-",$row->JUDUL);
					$ret .= "<li><a href=\"".site_url()."/home/berita/".$row->NEWS_ID."/".$judul."\" class=\"urgen\">".$row->JUDUL." <span>&nbsp;</span></a></li>";
				}
			}else{
				$ret .= "<li><a href=\"#\">Tidak Update Terbaru<span>0</span></a></li>";
			}
			$sarana = "'".join("','", $this->newsession->userdata('SESS_SARANA'))."'";
			
			if(!in_array('1', $this->newsession->userdata('SESS_KODE_ROLE')) || !in_array('9', $this->newsession->userdata('SESS_KODE_ROLE')) || !in_array('10', $this->newsession->userdata('SESS_KODE_ROLE'))){#Selain Admin Balai
			
				if(in_array('01',$this->newsession->userdata('SESS_SUB_SARANA'))){#Produksi
					if(in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))){#Pusat
						if(in_array('2', $this->newsession->userdata('SESS_KODE_ROLE'))){#Operator
							$ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/01/20111\">Draft Sarana Produksi <span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS DRAFT FROM T_PEMERIKSAAN WHERE STATUS = '20111' AND LEFT(JENIS_SARANA_ID, 2) = '01' AND JENIS_SARANA_ID IN ($sarana) AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND CREATE_BY = '".$this->newsession->userdata('SESS_USER_ID')."'","DRAFT")."</span></a></li>";
							$ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/01/20115\">Sarana Produksi Diterima Dari Balai <span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS BALAI FROM T_PEMERIKSAAN WHERE STATUS = '20115' AND LEFT(JENIS_SARANA_ID, 2) = '01' AND JENIS_SARANA_ID IN ($sarana)","BALAI")."</span></a></li>";
							$ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/01/20112\">Sarana Produksi Ditolak Supervisor Satu <span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS REJECT FROM T_PEMERIKSAAN WHERE STATUS = '20112' AND LEFT(JENIS_SARANA_ID, 2) = '01' AND JENIS_SARANA_ID IN ($sarana)","REJECT")."</span></a></li>";
						}
						if(in_array('3', $this->newsession->userdata('SESS_KODE_ROLE'))){#Spv 1 Pusat
							$ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/01/30111\">Tindak Lanjut Sarana Produksi <span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS TL FROM T_PEMERIKSAAN WHERE STATUS = '30111' AND LEFT(JENIS_SARANA_ID, 2) = '01' AND JENIS_SARANA_ID IN ($sarana)","TL")."</span></a></li>";
							$ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/01/30112\">Sarana Produksi Ditolak Supervisor Dua <span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS REJECT FROM T_PEMERIKSAAN WHERE STATUS = '30112' AND LEFT(JENIS_SARANA_ID, 2) = '01' AND JENIS_SARANA_ID IN ($sarana)","REJECT")."</span></a></li>";
							$ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/01/30114\">Sarana Produksi Perbaikan Oleh Operator <span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS REVIEW FROM T_PEMERIKSAAN WHERE STATUS = '30114' AND LEFT(JENIS_SARANA_ID, 2) = '01' AND JENIS_SARANA_ID IN ($sarana)","REVIEW")."</span></a></li>";
						}
						if(in_array('4', $this->newsession->userdata('SESS_KODE_ROLE'))){#Spv 2 Pusat
							$ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/01/40111\">Tindak Lanjut Sarana Produksi <span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS TL FROM T_PEMERIKSAAN WHERE STATUS = '40111' AND LEFT(JENIS_SARANA_ID, 2) = '01' AND JENIS_SARANA_ID IN ($sarana)","TL")."</span></a></li>";
							$ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/01/40112\">Sarana Produksi Ditolak Direktur <span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS REJECT FROM T_PEMERIKSAAN WHERE STATUS = '40112' AND LEFT(JENIS_SARANA_ID, 2) = '01' AND JENIS_SARANA_ID IN ($sarana)","REJECT")."</span></a></li>";
							$ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/01/40113\">Sarana Produksi Perbaikan Supervisor Satu".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS REVIEW FROM T_PEMERIKSAAN WHERE STATUS = '40113' AND LEFT(JENIS_SARANA_ID, 2) = '01' AND JENIS_SARANA_ID IN ($sarana)","REVIEW")."</a></li>";
						}
						if(in_array('6', $this->newsession->userdata('SESS_KODE_ROLE'))){#Direktur
							$ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/01/pusat\">Sarana Produksi Pemeriksaan Pusat <span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS TLPUSAT FROM T_PEMERIKSAAN WHERE STATUS = '60111' AND LEFT(JENIS_SARANA_ID, 2) = '01' AND BBPOM_ID = ".$this->newsession->userdata('SESS_BBPOM_ID')." AND JENIS_SARANA_ID IN ($sarana)","TLPUSAT")."</span></a></li>";
							$ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/01/balai\">Sarana Produksi Pemeriksaan Balai <span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS TLBALAI FROM T_PEMERIKSAAN WHERE STATUS = '60111' AND LEFT(JENIS_SARANA_ID, 2) = '01' AND BBPOM_ID != ".$this->newsession->userdata('SESS_BBPOM_ID')." AND JENIS_SARANA_ID IN ($sarana)","TLBALAI")."</span></a></li>";
						}
					}else{
						if(in_array('2', $this->newsession->userdata('SESS_KODE_ROLE'))){#Operator Balai
							$ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/01/20101\">Draft Sarana Produksi <span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS DRAFT FROM T_PEMERIKSAAN WHERE STATUS = '20101' AND LEFT(JENIS_SARANA_ID, 2) = '01' AND JENIS_SARANA_ID IN ($sarana) AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND CREATE_BY = '".$this->newsession->userdata('SESS_USER_ID')."'","DRAFT")."</span></a></li>";
							$ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/01/20102\">Sarana Produksi Ditolak Supervisor Satu <span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS REJECT FROM T_PEMERIKSAAN WHERE STATUS = '20102' AND LEFT(JENIS_SARANA_ID, 2) = '01' AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND CREATE_BY = '".$this->newsession->userdata('SESS_USER_ID')."'","REJECT")."</span></a></li>";
							$ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/01/20103\">Perbaikan Sarana Produksi <span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS REVIEW FROM T_PEMERIKSAAN WHERE STATUS = '20103' AND LEFT(JENIS_SARANA_ID, 2) = '01' AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND CREATE_BY = '".$this->newsession->userdata('SESS_USER_ID')."'","REVIEW")."</span></a></li>";
						}
						if(in_array('3', $this->newsession->userdata('SESS_KODE_ROLE'))){#Spv 1 Balai
							$ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/01/30101\">Tindak Lanjut Sarana Produksi <span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS TL FROM T_PEMERIKSAAN WHERE STATUS = '30101' AND LEFT(JENIS_SARANA_ID, 2) = '01' AND JENIS_SARANA_ID IN ($sarana) AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","TL")."</span></a></li>";
							$ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/01/30102\">Sarana Produksi Ditolak Supervisor Dua".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS REJECT FROM T_PEMERIKSAAN WHERE STATUS = '30102' AND LEFT(JENIS_SARANA_ID, 2) = '01' AND JENIS_SARANA_ID IN ($sarana) AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","REJECT")."</a></li>";
							$ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/01/30104\">Sarana Produksi Perbaikan Oleh Operator <span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS REVIEW FROM T_PEMERIKSAAN WHERE STATUS = '30104' AND LEFT(JENIS_SARANA_ID, 2) = '01' AND JENIS_SARANA_ID IN ($sarana) AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","REVIEW")."</span></a></li>";
						}
						if(in_array('4', $this->newsession->userdata('SESS_KODE_ROLE'))){#Spv 2 Balai
							$ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/01/40101\">Tindak Lanjut Sarana Produksi <span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS TL FROM T_PEMERIKSAAN WHERE STATUS = '40101' AND LEFT(JENIS_SARANA_ID, 2) = '01' AND JENIS_SARANA_ID IN ($sarana) AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","TL")."</span></a></li>";
							$ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/01/40102\">Sarana Produksi Ditolak Kepala Balai <span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS REJECT FROM T_PEMERIKSAAN WHERE STATUS = '40102' AND LEFT(JENIS_SARANA_ID, 2) = '01' AND JENIS_SARANA_ID IN ($sarana) AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","REJECT")."</span></a></li>";
							$ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/01/40103\">Sarana Produksi Perbaikan Supervisor Satu <span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS REVIEW FROM T_PEMERIKSAAN WHERE STATUS = '40103' AND LEFT(JENIS_SARANA_ID, 2) = '01' AND JENIS_SARANA_ID IN ($sarana) AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","REVIEW")."</span></a></li>";	
						}
						if(in_array('5', $this->newsession->userdata('SESS_KODE_ROLE'))){#Kepala Balai
							$ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/01/50101\">Sarana Produksi Diterima Kepala Balai <span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS KABALAI FROM T_PEMERIKSAAN WHERE STATUS = '50101' AND LEFT(JENIS_SARANA_ID, 2) = '01' AND JENIS_SARANA_ID IN ($sarana) AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","KABALAI")."</span></a></li>";
						}
					}
				}#Akhir Produksi

				if(in_array('02',$this->newsession->userdata('SESS_SUB_SARANA'))){#Distribusi
					if(in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))){#Pusat
						if(in_array('2', $this->newsession->userdata('SESS_KODE_ROLE'))){#Operator
							$ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/02/20111\">Draft Sarana Distribusi <span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS DRAFT FROM T_PEMERIKSAAN WHERE STATUS = '20111' AND LEFT(JENIS_SARANA_ID, 2) = '02' AND JENIS_SARANA_ID IN ($sarana) AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND CREATE_BY = '".$this->newsession->userdata('SESS_USER_ID')."'","DRAFT")."</span></a></li>";
							$ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/02/20115\">Sarana Distribusi Diterima Dari Balai <span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS BALAI FROM T_PEMERIKSAAN WHERE STATUS = '20115' AND LEFT(JENIS_SARANA_ID, 2) = '02' AND JENIS_SARANA_ID IN ($sarana)","BALAI")."</span></a></li>";
							$ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/02/20112\">Sarana Distribusi Ditolak Supervisor Satu <span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS REJECT FROM T_PEMERIKSAAN WHERE STATUS = '20112' AND LEFT(JENIS_SARANA_ID, 2) = '02' AND JENIS_SARANA_ID IN ($sarana)","REJECT")."</span></a></li>";
						}
						if(in_array('3', $this->newsession->userdata('SESS_KODE_ROLE'))){#Spv 1 Pusat
							$ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/02/30111\">Tindak Lanjut Sarana Distribusi <span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS TL FROM T_PEMERIKSAAN WHERE STATUS = '30111' AND LEFT(JENIS_SARANA_ID, 2) = '02' AND JENIS_SARANA_ID IN ($sarana)","TL")."</span></a></li>";
							$ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/02/30112\">Sarana Distribusi Ditolak Supervisor Dua <span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS REJECT FROM T_PEMERIKSAAN WHERE STATUS = '30112' AND LEFT(JENIS_SARANA_ID, 2) = '02' AND JENIS_SARANA_ID IN ($sarana)","REJECT")."</span></a></li>";
							$ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/02/30114\">Sarana Distribusi Perbaikan Oleh Operator <span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS REVIEW FROM T_PEMERIKSAAN WHERE STATUS = '30114' AND LEFT(JENIS_SARANA_ID, 2) = '02' AND JENIS_SARANA_ID IN ($sarana)","REVIEW")."</span></a></li>";
						}
						if(in_array('4', $this->newsession->userdata('SESS_KODE_ROLE'))){#Spv 2 Pusat
							$ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/02/40111\">Tindak Lanjut Sarana Distribusi <span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS TL FROM T_PEMERIKSAAN WHERE STATUS = '40111' AND LEFT(JENIS_SARANA_ID, 2) = '02' AND JENIS_SARANA_ID IN ($sarana)","TL")."</span></a></li>";
							$ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/02/40112\">Sarana Distribusi Ditolak Direktur <span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS REJECT FROM T_PEMERIKSAAN WHERE STATUS = '40112' AND LEFT(JENIS_SARANA_ID, 2) = '02' AND JENIS_SARANA_ID IN ($sarana)","REJECT")."</span></a></li>";
							$ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/02/40113\">Sarana Distribusi Perbaikan Supervisor Satu".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS REVIEW FROM T_PEMERIKSAAN WHERE STATUS = '40113' AND LEFT(JENIS_SARANA_ID, 2) = '02' AND JENIS_SARANA_ID IN ($sarana)","REVIEW")."</a></li>";
						}
						if(in_array('6', $this->newsession->userdata('SESS_KODE_ROLE'))){#Direktur
							$ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/02/pusat\">Sarana Distribusi Pemeriksaan Pusat <span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS TLPUSAT FROM T_PEMERIKSAAN WHERE STATUS = '60111' AND LEFT(JENIS_SARANA_ID, 2) = '02' AND BBPOM_ID = ".$this->newsession->userdata('SESS_BBPOM_ID')." AND JENIS_SARANA_ID IN ($sarana)","TLPUSAT")."</span></a></li>";
							$ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/02/balai\">Sarana Distribusi Pemeriksaan Balai <span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS TLBALAI FROM T_PEMERIKSAAN WHERE STATUS = '60111' AND LEFT(JENIS_SARANA_ID, 2) = '02' AND BBPOM_ID != ".$this->newsession->userdata('SESS_BBPOM_ID')." AND JENIS_SARANA_ID IN ($sarana)","TLBALAI")."</span></a></li>";
						}
					}else{
						if(in_array('2', $this->newsession->userdata('SESS_KODE_ROLE'))){#Operator Balai
							$ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/02/20101\">Draft Sarana Distribusi <span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS DRAFT FROM T_PEMERIKSAAN WHERE STATUS = '20101' AND LEFT(JENIS_SARANA_ID, 2) = '02' AND JENIS_SARANA_ID IN ($sarana) AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND CREATE_BY = '".$this->newsession->userdata('SESS_USER_ID')."'","DRAFT")."</span></a></li>";
							$ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/02/20102\">Sarana Distribusi Ditolak Supervisor Satu <span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS REJECT FROM T_PEMERIKSAAN WHERE STATUS = '20102' AND LEFT(JENIS_SARANA_ID, 2) = '02' AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND CREATE_BY = '".$this->newsession->userdata('SESS_USER_ID')."'","REJECT")."</span></a></li>";
							$ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/02/20103\">Perbaikan Sarana Distribusi <span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS REVIEW FROM T_PEMERIKSAAN WHERE STATUS = '20103' AND LEFT(JENIS_SARANA_ID, 2) = '02' AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND CREATE_BY = '".$this->newsession->userdata('SESS_USER_ID')."'","REVIEW")."</span></a></li>";
						}
						if(in_array('3', $this->newsession->userdata('SESS_KODE_ROLE'))){#Spv 1 Balai
							$ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/02/30101\">Tindak Lanjut Sarana Distribusi <span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS TL FROM T_PEMERIKSAAN WHERE STATUS = '30101' AND LEFT(JENIS_SARANA_ID, 2) = '02' AND JENIS_SARANA_ID IN ($sarana) AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","TL")."</span></a></li>";
							$ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/02/30102\">Sarana DistribusiDitolak Supervisor Dua".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS REJECT FROM T_PEMERIKSAAN WHERE STATUS = '30102' AND LEFT(JENIS_SARANA_ID, 2) = '02' AND JENIS_SARANA_ID IN ($sarana) AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","REJECT")."</a></li>";
							$ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/02/30104\">Perbaikan Oleh Operator <span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS REVIEW FROM T_PEMERIKSAAN WHERE STATUS = '30104' AND LEFT(JENIS_SARANA_ID, 2) = '02' AND JENIS_SARANA_ID IN ($sarana) AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","REVIEW")."</span></a></li>";
						}
						if(in_array('4', $this->newsession->userdata('SESS_KODE_ROLE'))){#Spv 2 Balai
							$ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/02/40101\">Tindak Lanjut Sarana Distribusi <span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS TL FROM T_PEMERIKSAAN WHERE STATUS = '40101' AND LEFT(JENIS_SARANA_ID, 2) = '02' AND JENIS_SARANA_ID IN ($sarana) AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","TL")."</span></a></li>";
							$ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/02/40102\">Sarana Distribusi Ditolak Kepala Balai <span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS REJECT FROM T_PEMERIKSAAN WHERE STATUS = '40102' AND LEFT(JENIS_SARANA_ID, 2) = '02' AND JENIS_SARANA_ID IN ($sarana) AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","REJECT")."</span></a></li>";
							$ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/02/40103\">Sarana Distribusi Perbaikan Supervisor Satu <span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS REVIEW FROM T_PEMERIKSAAN WHERE STATUS = '40103' AND LEFT(JENIS_SARANA_ID, 2) = '02' AND JENIS_SARANA_ID IN ($sarana) AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","REVIEW")."</span></a></li>";	
						}
						if(in_array('5', $this->newsession->userdata('SESS_KODE_ROLE'))){#Kepala Balai
							$ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/02/50101\">Sarana Distribusi Diterima Kepala Balai <span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS KABALAI FROM T_PEMERIKSAAN WHERE STATUS = '50101' AND LEFT(JENIS_SARANA_ID, 2) = '02' AND JENIS_SARANA_ID IN ($sarana) AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","KABALAI")."</span></a></li>";
						}
					}
				}#Akhir Distribusi

				if(in_array('03',$this->newsession->userdata('SESS_SUB_SARANA'))){#Pelayanan
					if(in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))){#Pusat
						if(in_array('2', $this->newsession->userdata('SESS_KODE_ROLE'))){#Operator
							$ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/03/20111\">Draft Sarana Pelayanan <span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS DRAFT FROM T_PEMERIKSAAN WHERE STATUS = '20111' AND LEFT(JENIS_SARANA_ID, 2) = '03' AND JENIS_SARANA_ID IN ($sarana) AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND CREATE_BY = '".$this->newsession->userdata('SESS_USER_ID')."'","DRAFT")."</span></a></li>";
							$ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/03/20115\">Sarana Pelayanan Diterima Dari Balai <span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS BALAI FROM T_PEMERIKSAAN WHERE STATUS = '20115' AND LEFT(JENIS_SARANA_ID, 2) = '03' AND JENIS_SARANA_ID IN ($sarana)","BALAI")."</span></a></li>";
							$ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/03/20112\">Sarana Pelayanan Ditolak Supervisor Satu <span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS REJECT FROM T_PEMERIKSAAN WHERE STATUS = '20112' AND LEFT(JENIS_SARANA_ID, 2) = '03' AND JENIS_SARANA_ID IN ($sarana)","REJECT")."</span></a></li>";
						}
						if(in_array('3', $this->newsession->userdata('SESS_KODE_ROLE'))){#Spv 1 Pusat
							$ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/03/30111\">Tindak Lanjut Sarana Pelayanan<span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS TL FROM T_PEMERIKSAAN WHERE STATUS = '30111' AND LEFT(JENIS_SARANA_ID, 2) = '03' AND JENIS_SARANA_ID IN ($sarana)","TL")."</span></a></li>";
							$ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/03/30112\">Sarana Pelayanan Ditolak Supervisor Dua <span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS REJECT FROM T_PEMERIKSAAN WHERE STATUS = '30112' AND LEFT(JENIS_SARANA_ID, 2) = '03' AND JENIS_SARANA_ID IN ($sarana)","REJECT")."</span></a></li>";
							$ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/03/30114\">Sarana Pelayanan Perbaikan Oleh Operator <span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS REVIEW FROM T_PEMERIKSAAN WHERE STATUS = '30114' AND LEFT(JENIS_SARANA_ID, 2) = '03' AND JENIS_SARANA_ID IN ($sarana)","REVIEW")."</span></a></li>";
						}
						if(in_array('4', $this->newsession->userdata('SESS_KODE_ROLE'))){#Spv 2 Pusat
							$ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/03/40111\">Tindak Lanjut Sarana Pelayanan <span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS TL FROM T_PEMERIKSAAN WHERE STATUS = '40111' AND LEFT(JENIS_SARANA_ID, 2) = '03' AND JENIS_SARANA_ID IN ($sarana)","TL")."</span></a></li>";
							$ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/03/40112\">Sarana Pelayanan Ditolak Direktur <span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS REJECT FROM T_PEMERIKSAAN WHERE STATUS = '40112' AND LEFT(JENIS_SARANA_ID, 2) = '03' AND JENIS_SARANA_ID IN ($sarana)","REJECT")."</span></a></li>";
							$ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/03/40113\">Sarana Pelayanan Perbaikan Supervisor Satu".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS REVIEW FROM T_PEMERIKSAAN WHERE STATUS = '40113' AND LEFT(JENIS_SARANA_ID, 2) = '03' AND JENIS_SARANA_ID IN ($sarana)","REVIEW")."</a></li>";
						}
						if(in_array('6', $this->newsession->userdata('SESS_KODE_ROLE'))){#Direktur
							$ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/03/pusat\">Sarana Pelayanan Pemeriksaan Pusat <span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS TLPUSAT FROM T_PEMERIKSAAN WHERE STATUS = '60111' AND LEFT(JENIS_SARANA_ID, 2) = '03' AND BBPOM_ID = ".$this->newsession->userdata('SESS_BBPOM_ID')." AND JENIS_SARANA_ID IN ($sarana)","TLPUSAT")."</span></a></li>";
							$ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/03/balai\">Sarana Pelayanan Pemeriksaan Balai <span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS TLBALAI FROM T_PEMERIKSAAN WHERE STATUS = '60111' AND LEFT(JENIS_SARANA_ID, 2) = '03' AND BBPOM_ID != ".$this->newsession->userdata('SESS_BBPOM_ID')." AND JENIS_SARANA_ID IN ($sarana)","TLBALAI")."</span></a></li>";
						}
					}else{
						if(in_array('2', $this->newsession->userdata('SESS_KODE_ROLE'))){#Operator Balai
							$ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/03/20101\">Draft Sarana Pelayanan <span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS DRAFT FROM T_PEMERIKSAAN WHERE STATUS = '20101' AND LEFT(JENIS_SARANA_ID, 2) = '03' AND JENIS_SARANA_ID IN ($sarana) AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND CREATE_BY = '".$this->newsession->userdata('SESS_USER_ID')."'","DRAFT")."</span></a></li>";
							$ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/03/20102\">Sarana Pelayanan Ditolak Supervisor Satu <span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS REJECT FROM T_PEMERIKSAAN WHERE STATUS = '20102' AND LEFT(JENIS_SARANA_ID, 2) = '03' AND BBPOM_ID != '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND CREATE_BY = '".$this->newsession->userdata('SESS_USER_ID')."'","REJECT")."</span></a></li>";
							$ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/03/20103\">Perbaikan Sarana Pelayanan<span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS REVIEW FROM T_PEMERIKSAAN WHERE STATUS = '20103' AND LEFT(JENIS_SARANA_ID, 2) = '03' AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND CREATE_BY = '".$this->newsession->userdata('SESS_USER_ID')."'","REVIEW")."</span></a></li>";
						}
						if(in_array('3', $this->newsession->userdata('SESS_KODE_ROLE'))){#Spv 1 Balai
							$ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/03/30101\">Tindak Lanjut Sarana Pelayanan <span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS TL FROM T_PEMERIKSAAN WHERE STATUS = '30101' AND LEFT(JENIS_SARANA_ID, 2) = '03' AND JENIS_SARANA_ID IN ($sarana) AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","TL")."</span></a></li>";
							$ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/03/30102\">Sarana Pelayanan Ditolak Supervisor Dua".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS REJECT FROM T_PEMERIKSAAN WHERE STATUS = '30102' AND LEFT(JENIS_SARANA_ID, 2) = '03' AND JENIS_SARANA_ID IN ($sarana) AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","REJECT")."</a></li>";
							$ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/03/30104\">Sarana Pelayanan Perbaikan Oleh Operator <span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS REVIEW FROM T_PEMERIKSAAN WHERE STATUS = '30104' AND LEFT(JENIS_SARANA_ID, 2) = '03' AND JENIS_SARANA_ID IN ($sarana) AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","REVIEW")."</span></a></li>";
						}
						if(in_array('4', $this->newsession->userdata('SESS_KODE_ROLE'))){#Spv 2 Balai
							$ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/03/40101\">Tindak Lanjut Sarana Pelayanan <span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS TL FROM T_PEMERIKSAAN WHERE STATUS = '40101' AND LEFT(JENIS_SARANA_ID, 2) = '03' AND JENIS_SARANA_ID IN ($sarana) AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","TL")."</span></a></li>";
							$ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/03/40102\">Sarana Pelayanan Ditolak Kepala Balai <span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS REJECT FROM T_PEMERIKSAAN WHERE STATUS = '40102' AND LEFT(JENIS_SARANA_ID, 2) = '03' AND JENIS_SARANA_ID IN ($sarana) AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","REJECT")."</span></a></li>";
							$ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/03/40103\">Sarana Pelayanan Perbaikan Supervisor Satu <span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS REVIEW FROM T_PEMERIKSAAN WHERE STATUS = '40103' AND LEFT(JENIS_SARANA_ID, 2) = '03' AND JENIS_SARANA_ID IN ($sarana) AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","REVIEW")."</span></a></li>";	
						}
						if(in_array('5', $this->newsession->userdata('SESS_KODE_ROLE'))){#Kepala Balai
							$ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/03/50101\">Sarana Pelayanan Diterima Kepala Balai <span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS KABALAI FROM T_PEMERIKSAAN WHERE STATUS = '50101' AND LEFT(JENIS_SARANA_ID, 2) = '03' AND JENIS_SARANA_ID IN ($sarana) AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","KABALAI")."</span></a></li>";
						}
					}
				}#Akhir Pelayanan
			}
		}
		echo $ret;
	}
	
	function get_all(){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$sipt->load->model("main", "main", true);
			$sarana = "'".join("','", $this->newsession->userdata('SESS_SARANA'))."'";
			$ret = "";
			if(!in_array('1', $this->newsession->userdata('SESS_KODE_ROLE')) || !in_array('9', $this->newsession->userdata('SESS_KODE_ROLE')) || !in_array('10', $this->newsession->userdata('SESS_KODE_ROLE'))){#Selain Admin Balai
				if(in_array('01',$this->newsession->userdata('SESS_SUB_SARANA'))){#Produksi
				  $ret .= '<li><a href="#"><b>&bull; Sarana Produksi</b></a></li>';
				  if(in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))){#Pusat
					  if(in_array('2', $this->newsession->userdata('SESS_KODE_ROLE'))){#Operator
						  $ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/01/20111\">Draft Sarana Produksi <span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS DRAFT FROM T_PEMERIKSAAN WHERE STATUS = '20111' AND LEFT(JENIS_SARANA_ID, 2) = '01' AND JENIS_SARANA_ID IN ($sarana) AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND CREATE_BY = '".$this->newsession->userdata('SESS_USER_ID')."'","DRAFT")."</span></a></li>";
						  $ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/01/20115\">Sarana Produksi Diterima Dari Balai <span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS BALAI FROM T_PEMERIKSAAN WHERE STATUS = '20115' AND LEFT(JENIS_SARANA_ID, 2) = '01' AND JENIS_SARANA_ID IN ($sarana)","BALAI")." </span></a></li>";
						  $ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/01/20112\">Sarana Produksi Ditolak Supervisor Satu <span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS REJECT FROM T_PEMERIKSAAN WHERE STATUS = '20112' AND LEFT(JENIS_SARANA_ID, 2) = '01' AND JENIS_SARANA_ID IN ($sarana)","REJECT")." </span></a></li>";
					  }
					  if(in_array('3', $this->newsession->userdata('SESS_KODE_ROLE'))){#Spv 1 Pusat
						  $ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/01/30111\">Tindak Lanjut Sarana Produksi <span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS TL FROM T_PEMERIKSAAN WHERE STATUS = '30111' AND LEFT(JENIS_SARANA_ID, 2) = '01' AND JENIS_SARANA_ID IN ($sarana)","TL")." </span></a></li>";
						  $ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/01/30112\">Sarana Produksi Ditolak Supervisor Dua <span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS REJECT FROM T_PEMERIKSAAN WHERE STATUS = '30112' AND LEFT(JENIS_SARANA_ID, 2) = '01' AND JENIS_SARANA_ID IN ($sarana)","REJECT")." </span> </a></li>";
						  $ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/01/30114\">Sarana Produksi Perbaikan Oleh Operator <span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS REVIEW FROM T_PEMERIKSAAN WHERE STATUS = '30114' AND LEFT(JENIS_SARANA_ID, 2) = '01' AND JENIS_SARANA_ID IN ($sarana)","REVIEW")." </span> </a></li>";
					  }
					  if(in_array('4', $this->newsession->userdata('SESS_KODE_ROLE'))){#Spv 2 Pusat
						  $ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/01/40111\">Tindak Lanjut Sarana Produksi <span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS TL FROM T_PEMERIKSAAN WHERE STATUS = '40111' AND LEFT(JENIS_SARANA_ID, 2) = '01' AND JENIS_SARANA_ID IN ($sarana)","TL")." </span> </a></li>";
						  $ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/01/40112\">Sarana Produksi Ditolak Direktur ".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS REJECT FROM T_PEMERIKSAAN WHERE STATUS = '40112' AND LEFT(JENIS_SARANA_ID, 2) = '01' AND JENIS_SARANA_ID IN ($sarana)","REJECT")." </span> </a></li>";
						  $ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/01/40113\">Sarana Produksi Perbaikan Supervisor Satu<span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS REVIEW FROM T_PEMERIKSAAN WHERE STATUS = '40113' AND LEFT(JENIS_SARANA_ID, 2) = '01' AND JENIS_SARANA_ID IN ($sarana)","REVIEW")." </span></a></li>";
					  }
					  if(in_array('6', $this->newsession->userdata('SESS_KODE_ROLE'))){#Direktur
						  $ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/01/pusat\">Sarana Produksi Pemeriksaan Pusat <span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS TLPUSAT FROM T_PEMERIKSAAN WHERE STATUS = '60111' AND LEFT(JENIS_SARANA_ID, 2) = '01' AND BBPOM_ID = ".$this->newsession->userdata('SESS_BBPOM_ID')." AND JENIS_SARANA_ID IN ($sarana)","TLPUSAT")." </span></a></li>";
						  $ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/01/balai\">Sarana Produksi Pemeriksaan Balai <span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS TLBALAI FROM T_PEMERIKSAAN WHERE STATUS = '60111' AND LEFT(JENIS_SARANA_ID, 2) = '01' AND BBPOM_ID != ".$this->newsession->userdata('SESS_BBPOM_ID')." AND JENIS_SARANA_ID IN ($sarana)","TLBALAI")." </span></a></li>";
					  }
				  }else{
					  if(in_array('2', $this->newsession->userdata('SESS_KODE_ROLE'))){#Operator Balai
						  $ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/01/20101\">Draft Sarana Produksi <span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS DRAFT FROM T_PEMERIKSAAN WHERE STATUS = '20101' AND LEFT(JENIS_SARANA_ID, 2) = '01' AND JENIS_SARANA_ID IN ($sarana) AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND CREATE_BY = '".$this->newsession->userdata('SESS_USER_ID')."'","DRAFT")." </span></a></li>";
						  $ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/01/20102\">Sarana Produksi Ditolak Supervisor Satu <span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS REJECT FROM T_PEMERIKSAAN WHERE STATUS = '20102' AND LEFT(JENIS_SARANA_ID, 2) = '01' AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND CREATE_BY = '".$this->newsession->userdata('SESS_USER_ID')."'","REJECT")." </span></a></li>";
						  $ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/01/20103\">Perbaikan Sarana Produksi <span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS REVIEW FROM T_PEMERIKSAAN WHERE STATUS = '20103' AND LEFT(JENIS_SARANA_ID, 2) = '01' AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND CREATE_BY = '".$this->newsession->userdata('SESS_USER_ID')."'","REVIEW")." </span></a></li>";
					  }
					  if(in_array('3', $this->newsession->userdata('SESS_KODE_ROLE'))){#Spv 1 Balai
						  $ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/01/30101\">Tindak Lanjut Sarana Produksi <span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS TL FROM T_PEMERIKSAAN WHERE STATUS = '30101' AND LEFT(JENIS_SARANA_ID, 2) = '01' AND JENIS_SARANA_ID IN ($sarana) AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","TL")." </span></a></li>";
						  $ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/01/30102\">Sarana Produksi Ditolak Supervisor Dua<span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS REJECT FROM T_PEMERIKSAAN WHERE STATUS = '30102' AND LEFT(JENIS_SARANA_ID, 2) = '01' AND JENIS_SARANA_ID IN ($sarana) AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","REJECT")." </span></a></li>";
						  $ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/01/30104\">Sarana Produksi Perbaikan Oleh Operator <span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS REVIEW FROM T_PEMERIKSAAN WHERE STATUS = '30104' AND LEFT(JENIS_SARANA_ID, 2) = '01' AND JENIS_SARANA_ID IN ($sarana) AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","REVIEW")." </span></a></li>";
					  }
					  if(in_array('4', $this->newsession->userdata('SESS_KODE_ROLE'))){#Spv 2 Balai
						  $ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/01/40101\">Tindak Lanjut Sarana Produksi <span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS TL FROM T_PEMERIKSAAN WHERE STATUS = '40101' AND LEFT(JENIS_SARANA_ID, 2) = '01' AND JENIS_SARANA_ID IN ($sarana) AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","TL")." </span></a></li>";
						  $ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/01/40102\">Sarana Produksi Ditolak Kepala Balai <span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS REJECT FROM T_PEMERIKSAAN WHERE STATUS = '40102' AND LEFT(JENIS_SARANA_ID, 2) = '01' AND JENIS_SARANA_ID IN ($sarana) AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","REJECT")." </span></a></li>";
						  $ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/01/40103\">Sarana Produksi Perbaikan Supervisor Satu <span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS REVIEW FROM T_PEMERIKSAAN WHERE STATUS = '40103' AND LEFT(JENIS_SARANA_ID, 2) = '01' AND JENIS_SARANA_ID IN ($sarana) AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","REVIEW")." </span></a></li>";	
					  }
					  if(in_array('5', $this->newsession->userdata('SESS_KODE_ROLE'))){#Kepala Balai
						  $ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/01/50101\">Sarana Produksi Diterima Kepala Balai <span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS KABALAI FROM T_PEMERIKSAAN WHERE STATUS = '50101' AND LEFT(JENIS_SARANA_ID, 2) = '01' AND JENIS_SARANA_ID IN ($sarana) AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","KABALAI")." </span></a></li>";
					  }
					}
				}
				
				if(in_array('02',$this->newsession->userdata('SESS_SUB_SARANA'))){#Distribusi
					$ret .= '<li><a href="#"><b>&bull; Sarana Distribusi</b></a></li>';
					if(in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))){#Pusat
						if(in_array('2', $this->newsession->userdata('SESS_KODE_ROLE'))){#Operator
							$ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/02/20111\">Draft Sarana Distribusi <span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS DRAFT FROM T_PEMERIKSAAN WHERE STATUS = '20111' AND LEFT(JENIS_SARANA_ID, 2) = '02' AND JENIS_SARANA_ID IN ($sarana) AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND CREATE_BY = '".$this->newsession->userdata('SESS_USER_ID')."'","DRAFT")." </span></a></li>";
							$ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/02/20115\">Sarana Distribusi Diterima Dari Balai <span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS BALAI FROM T_PEMERIKSAAN WHERE STATUS = '20115' AND LEFT(JENIS_SARANA_ID, 2) = '02' AND JENIS_SARANA_ID IN ($sarana)","BALAI")." </span></a></li>";
							$ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/02/20112\">Sarana Distribusi Ditolak Supervisor Satu <span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS REJECT FROM T_PEMERIKSAAN WHERE STATUS = '20112' AND LEFT(JENIS_SARANA_ID, 2) = '02' AND JENIS_SARANA_ID IN ($sarana)","REJECT")." </span></a></li>";
						}
						if(in_array('3', $this->newsession->userdata('SESS_KODE_ROLE'))){#Spv 1 Pusat
							$ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/02/30111\">Tindak Lanjut Sarana Distribusi <span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS TL FROM T_PEMERIKSAAN WHERE STATUS = '30111' AND LEFT(JENIS_SARANA_ID, 2) = '02' AND JENIS_SARANA_ID IN ($sarana)","TL")." </span></a></li>";
							$ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/02/30112\">Sarana Distribusi Ditolak Supervisor Dua <span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS REJECT FROM T_PEMERIKSAAN WHERE STATUS = '30112' AND LEFT(JENIS_SARANA_ID, 2) = '02' AND JENIS_SARANA_ID IN ($sarana)","REJECT")." </span></a></li>";
							$ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/02/30114\">Sarana Distribusi Perbaikan Oleh Operator <span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS REVIEW FROM T_PEMERIKSAAN WHERE STATUS = '30114' AND LEFT(JENIS_SARANA_ID, 2) = '02' AND JENIS_SARANA_ID IN ($sarana)","REVIEW")." </span></a></li>";
						}
						if(in_array('4', $this->newsession->userdata('SESS_KODE_ROLE'))){#Spv 2 Pusat
							$ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/02/40111\">Tindak Lanjut Sarana Distribusi <span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS TL FROM T_PEMERIKSAAN WHERE STATUS = '40111' AND LEFT(JENIS_SARANA_ID, 2) = '02' AND JENIS_SARANA_ID IN ($sarana)","TL")." </span></a></li>";
							$ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/02/40112\">Sarana Distribusi Ditolak Direktur <span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS REJECT FROM T_PEMERIKSAAN WHERE STATUS = '40112' AND LEFT(JENIS_SARANA_ID, 2) = '02' AND JENIS_SARANA_ID IN ($sarana)","REJECT")." </span></a></li>";
							$ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/02/40113\">Sarana Distribusi Perbaikan Supervisor Satu<span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS REVIEW FROM T_PEMERIKSAAN WHERE STATUS = '40113' AND LEFT(JENIS_SARANA_ID, 2) = '02' AND JENIS_SARANA_ID IN ($sarana)","REVIEW")." </span></a></li>";
						}
						if(in_array('6', $this->newsession->userdata('SESS_KODE_ROLE'))){#Direktur
							$ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/02/pusat\">Sarana Distribusi Pemeriksaan Pusat <span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS TLPUSAT FROM T_PEMERIKSAAN WHERE STATUS = '60111' AND LEFT(JENIS_SARANA_ID, 2) = '02' AND BBPOM_ID = ".$this->newsession->userdata('SESS_BBPOM_ID')." AND JENIS_SARANA_ID IN ($sarana)","TLPUSAT")." </span></a></li>";
							$ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/02/balai\">Sarana Distribusi Pemeriksaan Balai <span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS TLBALAI FROM T_PEMERIKSAAN WHERE STATUS = '60111' AND LEFT(JENIS_SARANA_ID, 2) = '02' AND BBPOM_ID != ".$this->newsession->userdata('SESS_BBPOM_ID')." AND JENIS_SARANA_ID IN ($sarana)","TLBALAI")." </span></a></li>";
						}
					}else{
						if(in_array('2', $this->newsession->userdata('SESS_KODE_ROLE'))){#Operator Balai
							$ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/02/20101\">Draft Sarana Distribusi <span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS DRAFT FROM T_PEMERIKSAAN WHERE STATUS = '20101' AND LEFT(JENIS_SARANA_ID, 2) = '02' AND JENIS_SARANA_ID IN ($sarana) AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND CREATE_BY = '".$this->newsession->userdata('SESS_USER_ID')."'","DRAFT")." </span></a></li>";
							$ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/02/20102\">Sarana Distribusi Ditolak Supervisor Satu <span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS REJECT FROM T_PEMERIKSAAN WHERE STATUS = '20102' AND LEFT(JENIS_SARANA_ID, 2) = '02' AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND CREATE_BY = '".$this->newsession->userdata('SESS_USER_ID')."'","REJECT")." </span></a></li>";
							$ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/02/20103\">Perbaikan Sarana Distribusi <span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS REVIEW FROM T_PEMERIKSAAN WHERE STATUS = '20103' AND LEFT(JENIS_SARANA_ID, 2) = '02' AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND CREATE_BY = '".$this->newsession->userdata('SESS_USER_ID')."'","REVIEW")." </span></a></li>";
						}
						if(in_array('3', $this->newsession->userdata('SESS_KODE_ROLE'))){#Spv 1 Balai
							$ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/02/30101\">Tindak Lanjut Sarana Distribusi <span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS TL FROM T_PEMERIKSAAN WHERE STATUS = '30101' AND LEFT(JENIS_SARANA_ID, 2) = '02' AND JENIS_SARANA_ID IN ($sarana) AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","TL")." </span></a></li>";
							$ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/02/30102\">Sarana DistribusiDitolak Supervisor Dua<span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS REJECT FROM T_PEMERIKSAAN WHERE STATUS = '30102' AND LEFT(JENIS_SARANA_ID, 2) = '02' AND JENIS_SARANA_ID IN ($sarana) AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","REJECT")." </span></a></li>";
							$ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/02/30104\">Perbaikan Oleh Operator <span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS REVIEW FROM T_PEMERIKSAAN WHERE STATUS = '30104' AND LEFT(JENIS_SARANA_ID, 2) = '02' AND JENIS_SARANA_ID IN ($sarana) AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","REVIEW")." </span></a></li>";
						}
						if(in_array('4', $this->newsession->userdata('SESS_KODE_ROLE'))){#Spv 2 Balai
							$ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/02/40101\">Tindak Lanjut Sarana Distribusi <span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS TL FROM T_PEMERIKSAAN WHERE STATUS = '40101' AND LEFT(JENIS_SARANA_ID, 2) = '02' AND JENIS_SARANA_ID IN ($sarana) AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","TL")." </span></a></li>";
							$ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/02/40102\">Sarana Distribusi Ditolak Kepala Balai <span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS REJECT FROM T_PEMERIKSAAN WHERE STATUS = '40102' AND LEFT(JENIS_SARANA_ID, 2) = '02' AND JENIS_SARANA_ID IN ($sarana) AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","REJECT")." </span></a></li>";
							$ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/02/40103\">Sarana Distribusi Perbaikan Supervisor Satu <span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS REVIEW FROM T_PEMERIKSAAN WHERE STATUS = '40103' AND LEFT(JENIS_SARANA_ID, 2) = '02' AND JENIS_SARANA_ID IN ($sarana) AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","REVIEW")." </span></a></li>";	
						}
						if(in_array('5', $this->newsession->userdata('SESS_KODE_ROLE'))){#Kepala Balai
							$ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/02/50101\">Sarana Distribusi Diterima Kepala Balai <span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS KABALAI FROM T_PEMERIKSAAN WHERE STATUS = '50101' AND LEFT(JENIS_SARANA_ID, 2) = '02' AND JENIS_SARANA_ID IN ($sarana) AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","KABALAI")." </span></a></li>";
						}
					}
				}
				
				if(in_array('03',$this->newsession->userdata('SESS_SUB_SARANA'))){#Pelayanan
					$ret .= '<li><a href="#"><b>&bull; Sarana Pelayanan</b></a></li>';
					if(in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))){#Pusat
						if(in_array('2', $this->newsession->userdata('SESS_KODE_ROLE'))){#Operator
							$ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/03/20111\">Draft Sarana Pelayanan <span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS DRAFT FROM T_PEMERIKSAAN WHERE STATUS = '20111' AND LEFT(JENIS_SARANA_ID, 2) = '03' AND JENIS_SARANA_ID IN ($sarana) AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND CREATE_BY = '".$this->newsession->userdata('SESS_USER_ID')."'","DRAFT")." </span></a></li>";
							$ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/03/20115\">Sarana Pelayanan Diterima Dari Balai <span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS BALAI FROM T_PEMERIKSAAN WHERE STATUS = '20115' AND LEFT(JENIS_SARANA_ID, 2) = '03' AND JENIS_SARANA_ID IN ($sarana)","BALAI")." </span></a></li>";
							$ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/03/20112\">Sarana Pelayanan Ditolak Supervisor Satu <span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS REJECT FROM T_PEMERIKSAAN WHERE STATUS = '20112' AND LEFT(JENIS_SARANA_ID, 2) = '03' AND JENIS_SARANA_ID IN ($sarana)","REJECT")." </span></a></li>";
						}
						if(in_array('3', $this->newsession->userdata('SESS_KODE_ROLE'))){#Spv 1 Pusat
							$ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/03/30111\">Tindak Lanjut Sarana Pelayanan<span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS TL FROM T_PEMERIKSAAN WHERE STATUS = '30111' AND LEFT(JENIS_SARANA_ID, 2) = '03' AND JENIS_SARANA_ID IN ($sarana)","TL")." </span></a></li>";
							$ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/03/30112\">Sarana Pelayanan Ditolak Supervisor Dua <span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS REJECT FROM T_PEMERIKSAAN WHERE STATUS = '30112' AND LEFT(JENIS_SARANA_ID, 2) = '03' AND JENIS_SARANA_ID IN ($sarana)","REJECT")." </span></a></li>";
							$ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/03/30114\">Sarana Pelayanan Perbaikan Oleh Operator <span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS REVIEW FROM T_PEMERIKSAAN WHERE STATUS = '30114' AND LEFT(JENIS_SARANA_ID, 2) = '03' AND JENIS_SARANA_ID IN ($sarana)","REVIEW")." </span></a></li>";
						}
						if(in_array('4', $this->newsession->userdata('SESS_KODE_ROLE'))){#Spv 2 Pusat
							$ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/03/40111\">Tindak Lanjut Sarana Pelayanan <span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS TL FROM T_PEMERIKSAAN WHERE STATUS = '40111' AND LEFT(JENIS_SARANA_ID, 2) = '03' AND JENIS_SARANA_ID IN ($sarana)","TL")." </span></a></li>";
							$ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/03/40112\">Sarana Pelayanan Ditolak Direktur <span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS REJECT FROM T_PEMERIKSAAN WHERE STATUS = '40112' AND LEFT(JENIS_SARANA_ID, 2) = '03' AND JENIS_SARANA_ID IN ($sarana)","REJECT")." </span></a></li>";
							$ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/03/40113\">Sarana Pelayanan Perbaikan Supervisor Satu<span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS REVIEW FROM T_PEMERIKSAAN WHERE STATUS = '40113' AND LEFT(JENIS_SARANA_ID, 2) = '03' AND JENIS_SARANA_ID IN ($sarana)","REVIEW")." </span></a></li>";
						}
						if(in_array('6', $this->newsession->userdata('SESS_KODE_ROLE'))){#Direktur
							$ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/03/pusat\">Sarana Pelayanan Pemeriksaan Pusat <span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS TLPUSAT FROM T_PEMERIKSAAN WHERE STATUS = '60111' AND LEFT(JENIS_SARANA_ID, 2) = '03' AND BBPOM_ID = ".$this->newsession->userdata('SESS_BBPOM_ID')." AND JENIS_SARANA_ID IN ($sarana)","TLPUSAT")." </span></a></li>";
							$ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/03/balai\">Sarana Pelayanan Pemeriksaan Balai <span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS TLBALAI FROM T_PEMERIKSAAN WHERE STATUS = '60111' AND LEFT(JENIS_SARANA_ID, 2) = '03' AND BBPOM_ID != ".$this->newsession->userdata('SESS_BBPOM_ID')." AND JENIS_SARANA_ID IN ($sarana)","TLBALAI")." </span></a></li>";
						}
					}else{
						if(in_array('2', $this->newsession->userdata('SESS_KODE_ROLE'))){#Operator Balai
							$ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/03/20101\">Draft Sarana Pelayanan <span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS DRAFT FROM T_PEMERIKSAAN WHERE STATUS = '20101' AND LEFT(JENIS_SARANA_ID, 2) = '03' AND JENIS_SARANA_ID IN ($sarana) AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND CREATE_BY = '".$this->newsession->userdata('SESS_USER_ID')."'","DRAFT")." </span></a></li>";
							$ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/03/20102\">Sarana Pelayanan Ditolak Supervisor Satu <span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS REJECT FROM T_PEMERIKSAAN WHERE STATUS = '20102' AND LEFT(JENIS_SARANA_ID, 2) = '03' AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND CREATE_BY = '".$this->newsession->userdata('SESS_USER_ID')."'","REJECT")." </span></a></li>";
							$ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/03/20103\">Perbaikan Sarana Pelayanan<span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS REVIEW FROM T_PEMERIKSAAN WHERE STATUS = '20103' AND LEFT(JENIS_SARANA_ID, 2) = '03' AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND CREATE_BY = '".$this->newsession->userdata('SESS_USER_ID')."'","REVIEW")." </span></a></li>";
						}
						if(in_array('3', $this->newsession->userdata('SESS_KODE_ROLE'))){#Spv 1 Balai
							$ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/03/30101\">Tindak Lanjut Sarana Pelayanan <span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS TL FROM T_PEMERIKSAAN WHERE STATUS = '30101' AND LEFT(JENIS_SARANA_ID, 2) = '03' AND JENIS_SARANA_ID IN ($sarana) AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","TL")." </span></a></li>";
							$ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/03/30102\">Sarana Pelayanan Ditolak Supervisor Dua<span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS REJECT FROM T_PEMERIKSAAN WHERE STATUS = '30102' AND LEFT(JENIS_SARANA_ID, 2) = '03' AND JENIS_SARANA_ID IN ($sarana) AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","REJECT")." </span></a></li>";
							$ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/03/30104\">Sarana Pelayanan Perbaikan Oleh Operator <span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS REVIEW FROM T_PEMERIKSAAN WHERE STATUS = '30104' AND LEFT(JENIS_SARANA_ID, 2) = '03' AND JENIS_SARANA_ID IN ($sarana) AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","REVIEW")." </span></a></li>";
						}
						if(in_array('4', $this->newsession->userdata('SESS_KODE_ROLE'))){#Spv 2 Balai
							$ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/03/40101\">Tindak Lanjut Sarana Pelayanan <span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS TL FROM T_PEMERIKSAAN WHERE STATUS = '40101' AND LEFT(JENIS_SARANA_ID, 2) = '03' AND JENIS_SARANA_ID IN ($sarana) AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","TL")." </span></a></li>";
							$ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/03/40102\">Sarana Pelayanan Ditolak Kepala Balai <span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS REJECT FROM T_PEMERIKSAAN WHERE STATUS = '40102' AND LEFT(JENIS_SARANA_ID, 2) = '03' AND JENIS_SARANA_ID IN ($sarana) AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","REJECT")." </span></a></li>";
							$ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/03/40103\">Sarana Pelayanan Perbaikan Supervisor Satu <span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS REVIEW FROM T_PEMERIKSAAN WHERE STATUS = '40103' AND LEFT(JENIS_SARANA_ID, 2) = '03' AND JENIS_SARANA_ID IN ($sarana) AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","REVIEW")." </span></a></li>";	
						}
						if(in_array('5', $this->newsession->userdata('SESS_KODE_ROLE'))){#Kepala Balai
							$ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/03/50101\">Sarana Pelayanan Diterima Kepala Balai <span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS KABALAI FROM T_PEMERIKSAAN WHERE STATUS = '50101' AND LEFT(JENIS_SARANA_ID, 2) = '03' AND JENIS_SARANA_ID IN ($sarana) AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","KABALAI")." </span></a></li>";
						}
					}
				}
				$ret .= '<li><a href="#"><b>&bull; Selesai</b></a></li>';
				if(in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))){#Pusat
					$ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/all/60010\">Selesai <span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS FINISH FROM T_PEMERIKSAAN WHERE STATUS = '60010' AND JENIS_SARANA_ID IN ($sarana)","FINISH")." </span></a></li>";
				}else if($this->newsession->userdata('SESS_BBPOM_ID') == "00"){
					$ret.="";
				}else{
					$ret .=  "<li><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/all/60010\">Selesai<span>".$sipt->main->get_uraian("SELECT COUNT(PERIKSA_ID) AS FINISH FROM T_PEMERIKSAAN WHERE STATUS = '60010' AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","FINISH")." </span></a></li>";
				}
				if(in_array('01', $this->newsession->userdata('SESS_JENIS_PELAPORAN'))){
					$notallowed = array('91','92','93','94','95');
					if(!in_array($this->newsession->userdata('SESS_BBPOM_ID'), $notallowed)){
						$ret .= '<li><a href="#"><b>&bull; Distribusi dan Pengadaan Bahan Berbahaya</b></a></li>';
						if($this->newsession->userdata('SESS_PROP_ID') == '7100'){
							$prop = "'7100','8200'";
						}else if($this->newsession->userdata('SESS_PROP_ID') == '7300'){
							$prop = "'7300','7600'";
						}else{
							$prop = $this->newsession->userdata('SESS_PROP_ID');
						}
						if($this->newsession->userdata('SESS_BBPOM_ID') == '96')
						$ret .=  "<li><a href=\"".site_url()."/home/notifikasi/bahan-berbahaya/new\">Tindak Lanjut Sarana BB<span>".$sipt->main->get_uraian("SELECT COUNT(*) AS JMLNOTIF FROM T_NOTIF_TMPBBX WHERE ISPERIKSA = '1'","JMLNOTIF")."</span></a></li>";
						else
						$ret .=  "<li><a href=\"".site_url()."/home/notifikasi/bahan-berbahaya/new\">Tindak Lanjut Sarana BB<span>".$sipt->main->get_uraian("SELECT COUNT(*) AS JMLNOTIF FROM T_NOTIF_TMPBBX WHERE ISPERIKSA = '1' AND DAERAH_ID IN($prop)","JMLNOTIF")."</span></a></li>";
					}
				}
				echo $ret;
			}		
		}
	}
		
	function get_klasifikasi_produk($kk,$id=""){#Klasifikasi Form Temuan Produk
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$this->load->model('pemeriksaan/tproduk_act');
			$arrdata = $this->tproduk_act->get_klasifikasi($kk,$id);
			$this->load->view('pemeriksaan/produk/'.$kk, $arrdata);
			return;
		}else{
			$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
		}
	}
	
	function set_log($action="", $isajax=""){
		if(strtolower($_SERVER['REQUEST_METHOD'])!="post"){
			redirect(base_url());
			exit();
		}else{
			$this->load->model('admin/utility_act');
			$ret = $this->utility_act->set_log($action, $isajax);
		}
		
		if($isajax!="ajax"){
			redirect(base_url());
			exit();
		}
		echo $ret;
	}
	
	function get_jml_srl($verifi, $id){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$sipt->load->model("main", "main", true);
			$left = strlen(trim($id));
			if($verifi == "01"){
				$jml = (int)$sipt->main->get_uraian("SELECT JML FROM (SELECT STATUS, COUNT(*) AS JML FROM M_SRL WHERE LEFT(GOLONGAN,".$left.") = '".$id."' AND STATUS = 2 AND VERIFI = '01' GROUP BY STATUS) AS DATA","JML");
			}else{ 
				$jml = (int)$sipt->main->get_uraian("SELECT JML FROM (SELECT STATUS, COUNT(*) AS JML FROM M_SRL WHERE LEFT(GOLONGAN,".$left.") = '".$id."' AND STATUS = 2 AND VERIFI = '00' GROUP BY STATUS) AS DATA","JML");
			}
			echo $jml;
		}
	}

	function get_prioritas($id){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$sipt->load->model("main", "main", true);
			$left = strlen(trim($id)); 
			#$jml = (int)$sipt->main->get_uraian("SELECT JML FROM (SELECT STATUS, COUNT(*) AS JML FROM M_PRIORITAS WHERE LEFT(GOLONGAN,".$left.") = '".$id."' AND STATUS IN('2','9') AND VERIFI = '01' GROUP BY STATUS) AS DATA","JML");
			$jml = (int)$sipt->main->get_uraian("SELECT JML FROM (SELECT COUNT(*) AS JML FROM M_PRIORITAS WHERE LEFT(GOLONGAN,".$left.") = '".$id."' AND STATUS IN ('2','9') AND VERIFI = '01' AND PRIORITAS_TAHUN = '".date("Y")."') AS DATA","JML");
			echo $jml;
		}
	}
			
}
?>