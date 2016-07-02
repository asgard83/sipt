<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Tools extends Controller{
	
	function Tools(){
		parent::Controller();
	}
	
	function index(){
	  	$this->fungsi->redirectMessage('Maaf anda tidak bisa mengakses halaman ini.','/home');
	}
	
	function get_nama($bbpom=""){
		if($this->newsession->userdata('LOGGED_IN')){
			$key = strtolower($_REQUEST['q']);
			if(in_array('1', $this->newsession->userdata('SESS_KODE_ROLE'))){
				if($bbpom=="")
					$data = "SELECT A.*, B.NAMA_BBPOM FROM T_USER A LEFT JOIN M_BBPOM B ON A.BBPOM_ID = B.BBPOM_ID WHERE A.STATUS = 'Aktif' AND A.USER_ID IN (SELECT DISTINCT USER_ID FROM T_USER_ROLE WHERE JENIS_PELAPORAN IN('01','03')) AND A.NAMA_USER LIKE '%$key%'";
				else
					$data = "SELECT A.*, B.NAMA_BBPOM FROM T_USER A LEFT JOIN M_BBPOM B ON A.BBPOM_ID = B.BBPOM_ID WHERE A.STATUS = 'Aktif' AND A.USER_ID IN (SELECT DISTINCT USER_ID FROM T_USER_ROLE WHERE JENIS_PELAPORAN IN('01','03')) AND A.BBPOM_ID = '".$bbpom."' AND A.NAMA_USER LIKE '%$key%'";
			}else{
					$data = "SELECT A.*, B.NAMA_BBPOM FROM T_USER A LEFT JOIN M_BBPOM B ON A.BBPOM_ID = B.BBPOM_ID WHERE A.STATUS = 'Aktif' AND A.USER_ID IN (SELECT DISTINCT USER_ID FROM T_USER_ROLE WHERE JENIS_PELAPORAN IN('01','03')) AND A.BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND A.NAMA_USER LIKE '%$key%'";
			}
			$this->load->model('main');
			$res = $this->main->get_result($data);
			if($res){
				foreach($data->result_array() as $row){
					echo "<b>Nama : ".$row['NAMA_USER']."</b><br>N.I.P : ".$row['USER_ID']."<br>Jabatan : ".$row['JABATAN']."<br>".$row['NAMA_BBPOM']."|".$row['NAMA_USER']."|".$row['USER_ID']."|".$row['JABATAN']."|".$row['BBPOM_ID']."\n";
				}
			}else{
				echo "Data tidak ditemukan||||\n"; 	
			}
		}
	}
	
	function get_timelinesarana($id){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE && $this->newsession->userdata('SESS_BBPOM_ID') == "00"){
			$this->load->model("admin/tools_act");
			$ret = $this->tools_act->set_timelinesarana($id);
			echo $ret;
		}
	}

	
	function get_createpemeriksaan($user){	
		if((array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('9', $this->newsession->userdata('SESS_KODE_ROLE'))) && $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt = get_instance();
			$sipt->load->model("main","main", true);
			$query = "SELECT COUNT(*) AS JML, A.BBPOM_ID, B.NAMA_BBPOM FROM T_PEMERIKSAAN A LEFT JOIN M_BBPOM B ON A.BBPOM_ID = B.BBPOM_ID
WHERE A.CREATE_BY = '".$user."' GROUP BY A.BBPOM_ID, B.NAMA_BBPOM";
			$data = $sipt->main->get_result($query);
			if($data){
				foreach($query->result_array() as $row){
					echo $row['NAMA_BBPOM']."#".$row['JML']."#".$row['BBPOM_ID'];
				}
			}
		}
	}
	
	function mutasi_act($tipe="",$action="",$isajax){
		if(strtolower($_SERVER['REQUEST_METHOD'])!="post" && $step == "first"){
			redirect(base_url());
			exit();
		}else{
			$this->load->model('admin/tools_act');
			$ret = $this->tools_act->set_mutasi($tipe,$action,$isajax);
		}
		if($isajax!="ajax"){
	  		$this->fungsi->redirectMessage('Maaf anda tidak bisa mengakses halaman ini.','/home');
		}
		echo $ret;
	}
	
	function get_spmt($id){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE && $this->newsession->userdata('SESS_BBPOM_ID') == "00"){
			$this->load->model("admin/tools_act");
			$ret = $this->tools_act->set_spmt($id);
			echo $ret;
		}
	}
	
	function get_roolbackspu($id){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE && $this->newsession->userdata('SESS_BBPOM_ID') == "00"){
			$this->load->model("admin/tools_act");
			$ret = $this->tools_act->set_roolbackspu($id);
			echo $ret;
		}
	}
	
	function get_migrasi($kode){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE && $this->newsession->userdata('SESS_BBPOM_ID') == "00"){
			$this->load->model("admin/tools_act");
			$ret = $this->tools_act->set_migrasidummy($kode);
			echo $ret;
		}
	}

	function get_spkmt($id){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE && $this->newsession->userdata('SESS_BBPOM_ID') == "00"){
			$this->load->model("admin/tools_act");
			$ret = $this->tools_act->set_spkmt($id);
			echo $ret;
		}
	}
	
	function get_rilis($id){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE && $this->newsession->userdata('SESS_BBPOM_ID') == "00"){
			$this->load->model("admin/tools_act");
			$ret = $this->tools_act->set_rilis($id);
			echo $ret;
		}
	}	
	
	
	function get_sort($id){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE && $this->newsession->userdata('SESS_BBPOM_ID') == "00"){
			$this->load->model("admin/tools_act");
			$ret = $this->tools_act->set_sort($id);
			echo $ret;
		}
	}
	
	function get_srl($id){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE && $this->newsession->userdata('SESS_BBPOM_ID') == "00"){
			$this->load->model("admin/tools_act");
			$ret = $this->tools_act->set_srl($id);
			echo $ret;
		}
	}
	
	function get_akhir_uji($id){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE && $this->newsession->userdata('SESS_BBPOM_ID') == "00"){
			$this->load->model("admin/tools_act");
			$ret = $this->tools_act->set_akhir_uji($id);
			echo $ret;
		}
	}

	function get_awal_uji($id){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE && $this->newsession->userdata('SESS_BBPOM_ID') == "00"){
			$this->load->model("admin/tools_act");
			$ret = $this->tools_act->set_awal_uji($id);
			echo $ret;
		}
	}
	
	function get_salah_kode($id){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE && $this->newsession->userdata('SESS_BBPOM_ID') == "00"){
			$this->load->model("admin/tools_act");
			$ret = $this->tools_act->set_salah_kode($id);
			echo $ret;
		}
	}
	
	function get_mapping_pu($id){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE && $this->newsession->userdata('SESS_BBPOM_ID') == "00"){
			$this->load->model("admin/tools_act");
			$ret = $this->tools_act->set_mapping_pu($id);
			echo $ret;
		}
	}
	
	function set_mapping_sampel_deleted($id){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE && $this->newsession->userdata('SESS_BBPOM_ID') == "00"){
			$this->load->model("admin/tools_act");
			$ret = $this->tools_act->set_mapping_sampel_deleted($id);
			echo $ret;
		}
	}
	
	function set_mapping_attachment($id){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE && $this->newsession->userdata('SESS_BBPOM_ID') == "00"){
			$this->load->model("admin/tools_act");
			$ret = $this->tools_act->set_mapping_attachment($id);
			echo $ret;
		}
	}
	
	function set_mapping_kode($id){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE && $this->newsession->userdata('SESS_BBPOM_ID') == "00"){
			$this->load->model("admin/tools_act");
			$ret = $this->tools_act->set_mapping_kode($id);
			echo $ret;
		}
	}
	
	function get_rekap($kode){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE && $this->newsession->userdata('SESS_BBPOM_ID') == "00"){
			$this->load->model("admin/tools_act");
			$ret = $this->tools_act->set_rekap($kode);
			echo $ret;
		}
	}


	function bidang_pengujian($val){
		if($this->newsession->userdata('LOGGED_IN')){
			if($val == "download-mt"){
				$this->load->model("admin/tools_act");
				$arrdata = $this->tools_act->get_spmt();
			}else if($val == "roolback-tps"){
				$this->load->model("admin/tools_act");
				$arrdata = $this->tools_act->get_roolbackspu();
			}else if($val == "migrasi"){
				$this->load->model("admin/tools_act");
				$arrdata = $this->tools_act->get_datadummy();
			}else if($val == "sinkronisasi-spk"){
				$this->load->model("admin/tools_act");
				$arrdata = $this->tools_act->get_spkmt();
			}else if($val == "rilis"){
				$this->load->model("admin/tools_act");
				$arrdata = $this->tools_act->get_rilis();
			}else if($val == "resort"){
				$this->load->model("admin/tools_act");
				$arrdata = $this->tools_act->get_resort();
			}else if($val == "mapping-srl"){
				$this->load->model("admin/tools_act");
				$arrdata = $this->tools_act->get_srl();
			}else if($val == "akhir-uji"){
				$this->load->model("admin/tools_act");
				$arrdata = $this->tools_act->get_akhir_uji();
			}else if($val == "mapping-kategori-pu"){
				$this->load->model("admin/tools_act");
				$arrdata = $this->tools_act->get_mapping_pu();
			}else if($val == "mapping-sampel-deleted"){
				$this->load->model("admin/tools_act");
				$arrdata = $this->tools_act->get_mapping_sampel_deleted();
			}else if($val == "mapping-attachment"){
				$this->load->model("admin/tools_act");
				$arrdata = $this->tools_act->get_mapping_attachment();
			}else if($val == "mapping-kode"){
				$this->load->model("admin/tools_act");
				$arrdata = $this->tools_act->get_mapping_kode();
			}else if($val == "rekap-timeline-sampel"){
				$this->load->model("admin/tools_act");
				$arrdata = $this->tools_act->get_rekap();
			}
			else{
				$arrdata = array();
			}
			echo $this->load->view("admin/sampling-pengujian/".$val, $arrdata, true);
		}
	}
	
	function step_reset($step, $isajax, $id=""){
		if(strtolower($_SERVER['REQUEST_METHOD'])!="post" && $step == "first"){
			redirect(base_url());
			exit();
		}else{
			$this->load->model('admin/tools_act');
			$ret = $this->tools_act->set_reset($step,$isajax,$id);
		}
		if($isajax!="ajax"){
	  		$this->fungsi->redirectMessage('Maaf anda tidak bisa mengakses halaman ini.','/home');
		}
		echo $ret;
	}
	
	function revisi_nomor($step, $tipe, $isajax){
		if(strtolower($_SERVER['REQUEST_METHOD'])!="post"){
			redirect(base_url());
			exit();
		}else{
			$this->load->model('admin/tools_act');
			$ret = $this->tools_act->set_revisi_nomor($step, $tipe,$isajax);
		}
		if($isajax!="ajax"){
	  		$this->fungsi->redirectMessage('Maaf anda tidak bisa mengakses halaman ini.','/home');
		}
		echo $ret;	
	}
	
	function set_tps($step, $isajax){
		if(strtolower($_SERVER['REQUEST_METHOD'])!="post"){
			redirect(base_url());
			exit();
		}else{
			$this->load->model('admin/tools_act');
			$ret = $this->tools_act->set_tps($step,$isajax);
		}
		if($isajax!="ajax"){
	  		$this->fungsi->redirectMessage('Maaf anda tidak bisa mengakses halaman ini.','/home');
		}
		echo $ret;	
	}
	
	function resort($step, $isajax, $id=""){
		if(strtolower($_SERVER['REQUEST_METHOD'])!="post" && $step == "first"){
			redirect(base_url());
			exit();
		}else{
			$this->load->model('admin/tools_act');
			$ret = $this->tools_act->set_sort($step,$isajax,$id);
		}
		if($isajax!="ajax"){
	  		$this->fungsi->redirectMessage('Maaf anda tidak bisa mengakses halaman ini.','/home');
		}
		echo $ret;
	}
	
	function mapping_sampel($step, $tipe, $isajax){
		if(strtolower($_SERVER['REQUEST_METHOD'])!="post"){
			redirect(base_url());
			exit();
		}else{
			$this->load->model('admin/tools_act');
			$ret = $this->tools_act->set_mapping_sampel($step, $tipe,$isajax);
		}
		if($isajax!="ajax"){
	  		$this->fungsi->redirectMessage('Maaf anda tidak bisa mengakses halaman ini.','/home');
		}
		echo $ret;	
	}

}
?>