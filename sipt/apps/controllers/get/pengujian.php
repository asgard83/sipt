  <?php



if ( ! defined('BASEPATH')) exit('No direct script access allowed');







class Pengujian extends Controller{



	



	function Pengujian(){



		parent::Controller();



	}



	



	function index(){ 	



	  	$this->fungsi->redirectMessage('Maaf anda tidak bisa mengakses halaman ini.','/home');



	}



	



	function sampel($id){



		if($this->newsession->userdata('LOGGED_IN') == "TRUE"){



			$this->load->model('pengujian/sampel_act');



			$arrdata = $this->sampel_act->detil_sampel($id);



			echo $this->load->view('pengujian/sampel/list-resume',$arrdata, true);



		}



	}



	



	function sps($id){



		if($this->newsession->userdata('LOGGED_IN') == "TRUE"){



			$this->load->model('pengujian/sps_act');



			$arrdata = $this->sps_act->get_sps($id);



			echo $this->load->view('pengujian/sps/view',$arrdata, true);



		}



	}



	



	function cp($id){



		if($this->newsession->userdata('LOGGED_IN') == "TRUE"){



			$this->load->model('pengujian/cp_act');



			$arrdata = $this->cp_act->get_popup($id);



			echo $this->load->view('pengujian/cp/detil-pop-up',$arrdata, true);



		}



	}



	



	function preview_sampel($id){



		if($this->newsession->userdata('LOGGED_IN') == "TRUE"){



			$this->load->model("pengujian/sampel_act");



			$data = $this->sampel_act->detil_sampel($id);



			$this->load->view('pengujian/sampel/detail', $data);	



		}else{



			redirect(base_url());



			exit();		  



		}



	}



	



	function status($spuid){



		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){



			if($this->newsession->userdata('SESS_BBPOM_ID') == "99")



				$status = "70001";



			else



				$status = "20107";



			$query = "SELECT KODE_SAMPEL, dbo.FORMAT_NOMOR('SPL', KODE_SAMPEL) AS [KODE SAMPEL], NAMA_SAMPEL AS [NAMA SAMPEL],dbo.URAIAN_M_TABEL('STATUS', STATUS_SAMPEL) AS [STATUS PROSES] FROM T_M_SAMPEL WHERE SPU_ID = '".$spuid."' AND STATUS_SAMPEL = '".$status."'";



			$this->load->library('newtable');



			$this->newtable->search(array(array('', '')));



			$this->newtable->hiddens(array('KODE_SAMPEL'));



			$this->newtable->action(site_url());



			$this->newtable->cidb($this->db);



			$this->newtable->ciuri($this->uri->segment_array());



			$this->newtable->orderby(1);



			$this->newtable->sortby("DESC");



			$this->newtable->keys("KODE_SAMPEL");



			$this->newtable->rowcount("ALL");



			$this->newtable->columns(array("KODE_SAMPEL", "dbo.FORMAT_NOMOR('SPL', KODE_SAMPEL)", "NAMA_SAMPEL","dbo.URAIAN_M_TABEL('STATUS', STATUS_SAMPEL)"));



			$this->newtable->width(array('KODE SAMPEL' => 150, 'STATUS PROSES' => 300));



			$this->newtable->show_chk(FALSE);



			$this->newtable->show_search(FALSE);



			$tabel = $this->newtable->generate($query);



			echo $tabel;



		}



	}



	



	function log_sampel($kode_sampel){



		$query = "SELECT A.WAKTU, +'<b>'+ B.NAMA_USER +'</b><div>@<b>'+ C.NAMA_BBPOM + '</b> <br>&raquo; <i>' + /*(CASE WHEN DATEDIFF(MONTH, A.WAKTU, GETDATE()) = 0 THEN 



(CASE WHEN DATEDIFF(DAY, A.WAKTU, GETDATE()) > 0 THEN CAST(DATEDIFF(DAY, A.WAKTU, GETDATE()) AS VARCHAR) + ' Hari, ' ELSE '' END) + 



(CASE WHEN DATEDIFF(HOUR, A.WAKTU, GETDATE()) > 0 THEN CAST(DATEDIFF(HOUR, A.WAKTU, GETDATE())%24 AS VARCHAR) + ' Jam, ' ELSE '' END) + 



CAST(DATEDIFF(MINUTE, A.WAKTU, GETDATE())%60 AS VARCHAR) + ' Menit Yang Lalu' ELSE 'Lebih Dari 1 Bulan Yang Lalu' END)*/convert(varchar(23),a.waktu,120) + '</i></div>' AS DETIL,



A.KEGIATAN + '<div> '+ CAST(A.CATATAN AS VARCHAR(MAX)) + '</div>' AS KEGIATAN FROM 



T_SAMPLING_LOG  A LEFT JOIN T_USER B ON A.USER_ID = B.USER_ID



LEFT JOIN M_BBPOM C ON B.BBPOM_ID = C.BBPOM_ID WHERE A.KODE_SAMPEL = '".$kode_sampel."'";



		$this->load->library('newtable');



		$this->newtable->search(array(array('', '')));



		$this->newtable->hiddens(array('WAKTU'));



		$this->newtable->action(site_url());



		$this->newtable->cidb($this->db);



		$this->newtable->ciuri($this->uri->segment_array());



		$this->newtable->orderby(1);



		$this->newtable->sortby("ASC");



		$this->newtable->keys("WAKTU");



		$this->newtable->rowcount("ALL");



		$this->newtable->columns(array("A.WAKTU", "+'<b>'+ B.NAMA_USER +'</b><div>@<b>'+ C.NAMA_BBPOM + '</b> <br>&raquo; <i>' + (CASE WHEN DATEDIFF(MONTH, A.WAKTU, GETDATE()) = 0 THEN (CASE WHEN DATEDIFF(DAY, A.WAKTU, GETDATE()) > 0 THEN CAST(DATEDIFF(DAY, A.WAKTU, GETDATE()) AS VARCHAR) + ' Hari, ' ELSE '' END) + (CASE WHEN DATEDIFF(HOUR, A.WAKTU, GETDATE()) > 0 THEN CAST(DATEDIFF(HOUR, A.WAKTU, GETDATE())%24 AS VARCHAR) + ' Jam, ' ELSE '' END) + CAST(DATEDIFF(MINUTE, A.WAKTU, GETDATE())%60 AS VARCHAR) + ' Menit Yang Lalu' ELSE 'Lebih Dari 1 Bulan Yang Lalu' END) + '</i></div>'","A.KEGIATAN + '<div> '+ CAST(A.CATATAN AS VARCHAR(MAX)) + '</div>'"));



		$this->newtable->width(array('DETIL' => 250));



		$this->newtable->show_chk(FALSE);



		$this->newtable->show_search(FALSE);



		$tabel = $this->newtable->generate($query);



		echo $tabel;



	}



	



	function log_spu($spuid){



		$query = "SELECT A.WAKTU, +'<b>'+ B.NAMA_USER +'</b><div>@<b>'+ C.NAMA_BBPOM + '</b> <br>&raquo; <i>' + /*(CASE WHEN DATEDIFF(MONTH, A.WAKTU, GETDATE()) = 0 THEN 



(CASE WHEN DATEDIFF(DAY, A.WAKTU, GETDATE()) > 0 THEN CAST(DATEDIFF(DAY, A.WAKTU, GETDATE()) AS VARCHAR) + ' Hari, ' ELSE '' END) + 



(CASE WHEN DATEDIFF(HOUR, A.WAKTU, GETDATE()) > 0 THEN CAST(DATEDIFF(HOUR, A.WAKTU, GETDATE())%24 AS VARCHAR) + ' Jam, ' ELSE '' END) + 



CAST(DATEDIFF(MINUTE, A.WAKTU, GETDATE())%60 AS VARCHAR) + ' Menit Yang Lalu' ELSE 'Lebih Dari 1 Bulan Yang Lalu' END) */convert(varchar(23),a.WAKTU,120)+ '</i></div>' AS DETIL, 



A.KEGIATAN + '<div> '+ CAST(A.CATATAN AS VARCHAR(MAX)) + '</div>' AS KEGIATAN FROM 



T_SPU_LOG  A LEFT JOIN T_USER B ON A.USER_ID = B.USER_ID



LEFT JOIN M_BBPOM C ON B.BBPOM_ID = C.BBPOM_ID WHERE A.SPU_ID = '".$spuid."'";



		$this->load->library('newtable');



		$this->newtable->search(array(array('', '')));



		$this->newtable->hiddens(array('WAKTU'));



		$this->newtable->action(site_url());



		$this->newtable->cidb($this->db);



		$this->newtable->ciuri($this->uri->segment_array());



		$this->newtable->orderby(1);



		$this->newtable->sortby("DESC");



		$this->newtable->keys("WAKTU");



		$this->newtable->rowcount("ALL");



		$this->newtable->columns(array("A.WAKTU", "+'<b>'+ B.NAMA_USER +'</b><div>@<b>'+ C.NAMA_BBPOM + '</b> <br>&raquo; <i>' + (CASE WHEN DATEDIFF(MONTH, A.WAKTU, GETDATE()) = 0 THEN (CASE WHEN DATEDIFF(DAY, A.WAKTU, GETDATE()) > 0 THEN CAST(DATEDIFF(DAY, A.WAKTU, GETDATE()) AS VARCHAR) + ' Hari, ' ELSE '' END) + (CASE WHEN DATEDIFF(HOUR, A.WAKTU, GETDATE()) > 0 THEN CAST(DATEDIFF(HOUR, A.WAKTU, GETDATE())%24 AS VARCHAR) + ' Jam, ' ELSE '' END) + CAST(DATEDIFF(MINUTE, A.WAKTU, GETDATE())%60 AS VARCHAR) + ' Menit Yang Lalu' ELSE 'Lebih Dari 1 Bulan Yang Lalu' END) + '</i></div>'","A.KEGIATAN + '<div> '+ CAST(A.CATATAN AS VARCHAR(MAX)) + '</div>'"));



		$this->newtable->width(array('DETIL' => 250));



		$this->newtable->show_chk(FALSE);



		$this->newtable->show_search(FALSE);



		$tabel = $this->newtable->generate($query);



		echo $tabel;



	}







	function log_cp($cpid){



		$query = "SELECT A.WAKTU, +'<b>'+ B.NAMA_USER +'</b><div>@<b>'+ C.NAMA_BBPOM + '</b> <br>&raquo; <i>' + (CASE WHEN DATEDIFF(MONTH, A.WAKTU, GETDATE()) = 0 THEN 



(CASE WHEN DATEDIFF(DAY, A.WAKTU, GETDATE()) > 0 THEN CAST(DATEDIFF(DAY, A.WAKTU, GETDATE()) AS VARCHAR) + ' Hari, ' ELSE '' END) + 



(CASE WHEN DATEDIFF(HOUR, A.WAKTU, GETDATE()) > 0 THEN CAST(DATEDIFF(HOUR, A.WAKTU, GETDATE())%24 AS VARCHAR) + ' Jam, ' ELSE '' END) + 



CAST(DATEDIFF(MINUTE, A.WAKTU, GETDATE())%60 AS VARCHAR) + ' Menit Yang Lalu' ELSE 'Lebih Dari 1 Bulan Yang Lalu' END) + '</i></div>' AS DETIL, 



A.KEGIATAN + '<div> '+ CAST(A.CATATAN AS VARCHAR(MAX)) + '</div>' AS KEGIATAN FROM 



T_CP_LOG  A LEFT JOIN T_USER B ON A.USER_ID = B.USER_ID



LEFT JOIN M_BBPOM C ON B.BBPOM_ID = C.BBPOM_ID WHERE A.CP_ID = '".$cpid."'";



		$this->load->library('newtable');



		$this->newtable->search(array(array('', '')));



		$this->newtable->hiddens(array('WAKTU'));



		$this->newtable->action(site_url());



		$this->newtable->cidb($this->db);



		$this->newtable->ciuri($this->uri->segment_array());



		$this->newtable->orderby(1);



		$this->newtable->sortby("DESC");



		$this->newtable->keys("WAKTU");



		$this->newtable->rowcount("ALL");



		$this->newtable->columns(array("A.WAKTU", "+'<b>'+ B.NAMA_USER +'</b><div>@<b>'+ C.NAMA_BBPOM + '</b> <br>&raquo; <i>' + (CASE WHEN DATEDIFF(MONTH, A.WAKTU, GETDATE()) = 0 THEN (CASE WHEN DATEDIFF(DAY, A.WAKTU, GETDATE()) > 0 THEN CAST(DATEDIFF(DAY, A.WAKTU, GETDATE()) AS VARCHAR) + ' Hari, ' ELSE '' END) + (CASE WHEN DATEDIFF(HOUR, A.WAKTU, GETDATE()) > 0 THEN CAST(DATEDIFF(HOUR, A.WAKTU, GETDATE())%24 AS VARCHAR) + ' Jam, ' ELSE '' END) + CAST(DATEDIFF(MINUTE, A.WAKTU, GETDATE())%60 AS VARCHAR) + ' Menit Yang Lalu' ELSE 'Lebih Dari 1 Bulan Yang Lalu' END) + '</i></div>'","A.KEGIATAN + '<div> '+ CAST(A.CATATAN AS VARCHAR(MAX)) + '</div>'"));



		$this->newtable->width(array('DETIL' => 250));



		$this->newtable->show_chk(FALSE);



		$this->newtable->show_search(FALSE);



		$tabel = $this->newtable->generate($query);



		echo $tabel;



	}







	function log_spk($spkid){



		$query = "SELECT A.WAKTU, +'<b>'+ B.NAMA_USER +'</b><div>@<b>'+ C.NAMA_BBPOM + '</b> <br>&raquo; <i>' + /*(CASE WHEN DATEDIFF(MONTH, A.WAKTU, GETDATE()) = 0 THEN 



(CASE WHEN DATEDIFF(DAY, A.WAKTU, GETDATE()) > 0 THEN CAST(DATEDIFF(DAY, A.WAKTU, GETDATE()) AS VARCHAR) + ' Hari, ' ELSE '' END) + 



(CASE WHEN DATEDIFF(HOUR, A.WAKTU, GETDATE()) > 0 THEN CAST(DATEDIFF(HOUR, A.WAKTU, GETDATE())%24 AS VARCHAR) + ' Jam, ' ELSE '' END) + 



CAST(DATEDIFF(MINUTE, A.WAKTU, GETDATE())%60 AS VARCHAR) + ' Menit Yang Lalu' ELSE 'Lebih Dari 1 Bulan Yang Lalu' END)*/ CONVERT(VARCHAR(23),A.WAKTU,120) + '</i></div>' AS DETIL, 



A.KEGIATAN + '<div> '+ CAST(A.CATATAN AS VARCHAR(MAX)) + '</div>' AS KEGIATAN FROM 



T_SPK_LOG  A LEFT JOIN T_USER B ON A.USER_ID = B.USER_ID



LEFT JOIN M_BBPOM C ON B.BBPOM_ID = C.BBPOM_ID WHERE A.SPK_ID = '".$spkid."'";



		$this->load->library('newtable');



		$this->newtable->search(array(array('', '')));



		$this->newtable->hiddens(array('WAKTU'));



		$this->newtable->action(site_url());



		$this->newtable->cidb($this->db);



		$this->newtable->ciuri($this->uri->segment_array());



		$this->newtable->orderby(1);



		$this->newtable->sortby("DESC");



		$this->newtable->keys("WAKTU");



		$this->newtable->rowcount("ALL");



		$this->newtable->columns(array("A.WAKTU", "+'<b>'+ B.NAMA_USER +'</b><div>@<b>'+ C.NAMA_BBPOM + '</b> <br>&raquo; <i>' + (CASE WHEN DATEDIFF(MONTH, A.WAKTU, GETDATE()) = 0 THEN (CASE WHEN DATEDIFF(DAY, A.WAKTU, GETDATE()) > 0 THEN CAST(DATEDIFF(DAY, A.WAKTU, GETDATE()) AS VARCHAR) + ' Hari, ' ELSE '' END) + (CASE WHEN DATEDIFF(HOUR, A.WAKTU, GETDATE()) > 0 THEN CAST(DATEDIFF(HOUR, A.WAKTU, GETDATE())%24 AS VARCHAR) + ' Jam, ' ELSE '' END) + CAST(DATEDIFF(MINUTE, A.WAKTU, GETDATE())%60 AS VARCHAR) + ' Menit Yang Lalu' ELSE 'Lebih Dari 1 Bulan Yang Lalu' END) + '</i></div>'","A.KEGIATAN + '<div> '+ CAST(A.CATATAN AS VARCHAR(MAX)) + '</div>'"));



		$this->newtable->width(array('DETIL' => 250));



		$this->newtable->show_chk(FALSE);



		$this->newtable->show_search(FALSE);



		$tabel = $this->newtable->generate($query);



		echo $tabel;



	}



	
	function log_puk($puk_id){

		$query = "SELECT A.WAKTU, +'<b>'+ B.NAMA_USER +'</b><div>@<b>'+ C.NAMA_BBPOM + '</b> <br>&raquo; <i>' + /*(CASE WHEN DATEDIFF(MONTH, A.WAKTU, GETDATE()) = 0 THEN 



(CASE WHEN DATEDIFF(DAY, A.WAKTU, GETDATE()) > 0 THEN CAST(DATEDIFF(DAY, A.WAKTU, GETDATE()) AS VARCHAR) + ' Hari, ' ELSE '' END) + 



(CASE WHEN DATEDIFF(HOUR, A.WAKTU, GETDATE()) > 0 THEN CAST(DATEDIFF(HOUR, A.WAKTU, GETDATE())%24 AS VARCHAR) + ' Jam, ' ELSE '' END) + 



CAST(DATEDIFF(MINUTE, A.WAKTU, GETDATE())%60 AS VARCHAR) + ' Menit Yang Lalu' ELSE 'Lebih Dari 1 Bulan Yang Lalu' END)*/ CONVERT(VARCHAR(23),A.WAKTU,120) + '</i></div>' AS DETIL, 



A.KEGIATAN + '<div> '+ CAST(A.CATATAN AS VARCHAR(MAX)) + '</div>' AS KEGIATAN FROM 



T_SAMPEL_PUK_LOG  A LEFT JOIN T_USER B ON A.USER_ID = B.USER_ID



LEFT JOIN M_BBPOM C ON B.BBPOM_ID = C.BBPOM_ID WHERE A.PUK_ID = '".$puk_id."'";



		$this->load->library('newtable');



		$this->newtable->search(array(array('', '')));



		$this->newtable->hiddens(array('WAKTU'));



		$this->newtable->action(site_url());



		$this->newtable->cidb($this->db);



		$this->newtable->ciuri($this->uri->segment_array());



		$this->newtable->orderby(1);



		$this->newtable->sortby("DESC");



		$this->newtable->keys("WAKTU");



		$this->newtable->rowcount("ALL");



		$this->newtable->columns(array("A.WAKTU", "+'<b>'+ B.NAMA_USER +'</b><div>@<b>'+ C.NAMA_BBPOM + '</b> <br>&raquo; <i>' + (CASE WHEN DATEDIFF(MONTH, A.WAKTU, GETDATE()) = 0 THEN (CASE WHEN DATEDIFF(DAY, A.WAKTU, GETDATE()) > 0 THEN CAST(DATEDIFF(DAY, A.WAKTU, GETDATE()) AS VARCHAR) + ' Hari, ' ELSE '' END) + (CASE WHEN DATEDIFF(HOUR, A.WAKTU, GETDATE()) > 0 THEN CAST(DATEDIFF(HOUR, A.WAKTU, GETDATE())%24 AS VARCHAR) + ' Jam, ' ELSE '' END) + CAST(DATEDIFF(MINUTE, A.WAKTU, GETDATE())%60 AS VARCHAR) + ' Menit Yang Lalu' ELSE 'Lebih Dari 1 Bulan Yang Lalu' END) + '</i></div>'","A.KEGIATAN + '<div> '+ CAST(A.CATATAN AS VARCHAR(MAX)) + '</div>'"));



		$this->newtable->width(array('DETIL' => 250));



		$this->newtable->show_chk(FALSE);



		$this->newtable->show_search(FALSE);



		$tabel = $this->newtable->generate($query);



		echo $tabel;



	}


	function get_kategori($kode,$prioritas){



		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){



			$this->load->model('pengujian/sampel_act');



			$arrdata = $this->sampel_act->get_kategori($kode,$prioritas);



			echo $this->load->view('pengujian/sampel/edit-kategori',$arrdata, true);



		}



	}



	



	function get_penyelia($id){



		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){



			$this->load->model('pengujian/spk_act');



			$arrdata = $this->spk_act->get_penyelia($id);



			echo $this->load->view('pengujian/spk/edit-penyelia',$arrdata, true);



		}



	}	



	



	function params_act($uji_id){



		if($uji_id == ""){



			return false;



		}else{



			$res = $this->db->simple_query("DELETE FROM T_PARAMETER_HASIL_UJI WHERE UJI_ID = '".$uji_id."'");



			if($res)



				echo "MSG#YES#".$uji_id;



			else



				echo "MSG#NO";



		}



		



	}



	



	function get_parameter($id){



		if($this->newsession->userdata('LOGGED_IN')){



			$this->load->model('pengujian/sp_act');



			$arrdata = $this->sp_act->get_parameters($id);



			echo $this->load->view('pengujian/spp/view-params',$arrdata, true);



		}



	}



	



	function get_penguji($id){



		if($this->newsession->userdata('LOGGED_IN')){



			$this->load->model('pengujian/sp_act');



			$arrdata = $this->sp_act->get_parameters($id);



			echo $this->load->view('pengujian/spp/view-penguji',$arrdata, true);



		}



	}



	



	function get_dispo($spuid, $userid){



		if($this->newsession->userdata('LOGGED_IN')){



			$this->load->model('pengujian/sp_act');



			$arrdata = $this->sp_act->get_mt($spuid, $userid);



			echo $this->load->view('pengujian/sp/edit-mt',$arrdata, true);



		}



	}



	



	function get_statusmt($kode, $spu){



		if($this->newsession->userdata('LOGGED_IN')){



			$this->load->model('pengujian/sp_act');



			$arrdata = $this->sp_act->get_statusmt($kode, $spu);



			echo $this->load->view('pengujian/sp/status-mt',$arrdata, true);



		}



	}



	



	function get_headerspu($spuid){



		if($this->newsession->userdata('LOGGED_IN')){



			$this->load->model('pengujian/spu_act');



			$arrdata = $this->spu_act->get_headerspu($spuid);



			echo $this->load->view('pengujian/sp/edit-tanggal-disposisi',$arrdata, true);



		}



	}



	



	function get_header_spl($kode){



		if($this->newsession->userdata('LOGGED_IN')){



			$this->load->model('pengujian/sampel_act');



			$arrdata = $this->sampel_act->get_header_spl($kode);



			echo $this->load->view('pengujian/sampel/edit-header-sampling',$arrdata, true);



		}



	}



	



	function detail_dispo($id){



		if($this->newsession->userdata('LOGGED_IN')){



			$this->load->model('pengujian/spu_act');



			$arrdata = $this->spu_act->get_disposisi($id);



			echo $this->load->view('pengujian/spu/edit-disposisi',$arrdata, true);



		}



	}



	



	function get_addmt($spuid){



		if($this->newsession->userdata('LOGGED_IN')){



			$this->load->model('pengujian/sp_act');



			$arrdata = $this->sp_act->get_add($spuid);



			echo $this->load->view('pengujian/sp/add-mt',$arrdata, true);



		}



	}



	



	function get_review_params($id){



		if($this->newsession->userdata('LOGGED_IN')){



			$this->load->model('pengujian/penguji_act');



			$arrdata = $this->penguji_act->get_edit_params($id);



			echo $this->load->view('pengujian/uji/edit-params',$arrdata, true);



		}



	}



	



	function get_koreksi_params($id){



		if($this->newsession->userdata('LOGGED_IN')){



			$this->load->model('pengujian/cp_act');



			$arrdata = $this->cp_act->get_koreksi($id);



			echo $this->load->view('pengujian/cp/koreksi-params',$arrdata, true);



		}



	}



	



	function del_sampel_mt($spu_id, $user_id, $isajax){



		if((in_array('07',$this->newsession->userdata('SESS_KODE_ROLE')) && in_array('02', $this->newsession->userdata('SESS_JENIS_PELAPORAN'))) && $this->newsession->userdata('LOGGED_IN') ==  TRUE){



			$this->load->model('pengujian/sp_act');



			$ret = $this->sp_act->del_spu_mt($spu_id, $user_id, $isajax);



			echo $ret;



		}



	}



	



	function revisi_spk($spkid){


		if((in_array('1',$this->newsession->userdata('SESS_KODE_ROLE')) || in_array('9', $this->newsession->userdata('SESS_KODE_ROLE'))) && $this->newsession->userdata('LOGGED_IN') ==  TRUE){



			$this->load->model('pengujian/spk_act');
			$arrdata = $this->spk_act->get_revdispospk($spkid);



			echo $this->load->view('pengujian/spk/revisi-disposisi-spk', $arrdata, true);



		}



	}



	



	function reupload_lcp($kode_sampel,$uji_id){



		if($this->newsession->userdata('LOGGED_IN')){



			$this->load->model('pengujian/penguji_act');



			$arrdata = $this->penguji_act->get_reupload($kode_sampel,$uji_id);			  



			echo $this->load->view('pengujian/uji/reupload-lcp',$arrdata, true);



		}



	}



	



	function delete_lcp($uji_id){



		if($this->newsession->userdata('LOGGED_IN')){



			$hasil = FALSE;



			$ret = "MSG#NO#File LCP gagal dihapus";



			$arr = array('LCP' => '');



			$this->db->where('UJI_ID', $uji_id);



			$this->db->update('T_PARAMETER_HASIL_UJI', $arr);



			if($this->db->affected_rows() > 0){



				$arr = array('LCP' => '');



				$this->db->where('UJI_ID', $uji_id);



				$this->db->update('T_PARAMETER_HASIL_UJI_RILIS', $arr);



				$hasil = TRUE;



			}



			if($hasil){



				$ret = "MSG#YES#File LCP berhasil dihapus";



			}



			echo $ret;



		}



	}



	



	function params($kode){



		if($this->newsession->userdata('SESS_BBPOM_ID') == "00" || (in_array('9', $this->newsession->userdata('SESS_KODE_ROLE')) && !in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')))){



			$this->load->model('pengujian/sampel_act');



			$arrdata = $this->sampel_act->get_parameter($kode);			  



			echo $this->load->view('pengujian/sampel/parameter-uji',$arrdata, true);



		}



	}



	



	function get_hasil($uji, $kode){



		if($this->newsession->userdata('SESS_BBPOM_ID') == "00" || (in_array('9', $this->newsession->userdata('SESS_KODE_ROLE')) && !in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')))){



			$this->load->model('pengujian/sampel_act');



			$arrdata = $this->sampel_act->get_detil_parameter($uji, $kode);			  



			echo $this->load->view('pengujian/sampel/detail-parameter-uji',$arrdata, true);



		}



	}



	



	function get_hapuslcp($spk,$uji,$kode, $file){



		$path = "./files/LCP/".$kode."/".$file;



		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){



			if(file_exists($path)){



				$res = $this->db->simple_query("UPDATE T_PARAMETER_HASIL_UJI SET LCP = NULL WHERE UJI_ID = '".$uji."' AND SPK_ID = '".$spk."' AND KODE_SAMPEL = '".$kode."'");



				if($res){



				  if(unlink($path)){



					  $ret = "MSG#YES#File lampiran LCP / CP berhasil di hapus";



				  }else{



					  $ret = "MSG#NO#Hapus File Lampiran CP / LCP gagal";



				  }



				}



			}else{



				$ret = "MSG#NO#Hapus File Lampiran CP / LCP gagal";



			}



		}else{



			$ret = "MSG#NO#Hapus File Lampiran CP / LCP gagal";



		}



		echo $ret;



	}



	



	function set_params($spk,$uji,$kode){



		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){



			$res = $this->db->simple_query("DELETE FROM T_PARAMETER_HASIL_UJI WHERE UJI_ID = '".$uji."' AND SPK_ID = '".$spk."' AND KODE_SAMPEL = '".$kode."'");



			if($res)



			$ret = "MSG#YES#Parameter uji berhasil dihapus";



			else $ret = "MSG#NO#Parameter uji gagal dihapus";



		}



		echo $ret;



	}



	#---------------------- New PPOMN



	function del_sampel_mt_ppomn($spu_id, $user_id, $isajax){



		if((in_array('07',$this->newsession->userdata('SESS_KODE_ROLE')) && in_array('02', $this->newsession->userdata('SESS_JENIS_PELAPORAN'))) && $this->newsession->userdata('LOGGED_IN') ==  TRUE){



			$this->load->model('pengujian/ppomn/sp_act');



			$ret = $this->sp_act->del_spu_mt($spu_id, $user_id, $isajax);



			echo $ret;



		}



	}



	function get_dispo_ppomn($spuid, $userid){



		if($this->newsession->userdata('LOGGED_IN')){



			$this->load->model('pengujian/ppomn/sp_act');



			$arrdata = $this->sp_act->get_mt($spuid, $userid);



			echo $this->load->view('pengujian/ppomn/sp/edit-mt',$arrdata, true);



		}



	}



	function get_addmt_ppomn($spuid){



		if($this->newsession->userdata('LOGGED_IN')){



			$this->load->model('pengujian/ppomn/sp_act');



			$arrdata = $this->sp_act->get_add($spuid);



			echo $this->load->view('pengujian/ppomn/sp/add-mt',$arrdata, true);



		}



	}



	#End New PPOMN



	



	#Detil Transaksi Sampel



	function status_act($jenis,$params,$id,$val){



		if(in_array('1', $this->newsession->userdata('SESS_KODE_ROLE')) && $this->newsession->userdata('LOGGED_IN')){



			if($jenis == "bidang"){



				$this->load->model('pengujian/sampel_act');



				$ret = $this->sampel_act->update_bidang($params,$id,$val);



			}



			echo $ret;



		}



	}



	function trans_act($trx, $kode){



			if((in_array('1', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('9', $this->newsession->userdata('SESS_KODE_ROLE')))  && $this->newsession->userdata('LOGGED_IN')){



			$this->load->model('admin/trans_act');



			if($trx == "sps"){



				$arrdata = $this->trans_act->get_sps($kode);



				echo $this->load->view('pengujian/sampel/transaksi/sps', $arrdata, true);



			}else if($trx == "spk"){



				$arrdata = $this->trans_act->get_spk($kode);



				echo $this->load->view('pengujian/sampel/transaksi/spk', $arrdata, true);



			}else if($trx == "spp"){



				$arrdata = $this->trans_act->get_spp($kode);



				echo $this->load->view('pengujian/sampel/transaksi/spp', $arrdata, true);



			}else if($trx == "parameter"){



				$arrdata = $this->trans_act->get_parameter($kode);



				echo $this->load->view('pengujian/sampel/transaksi/parameter', $arrdata, true);



			}else if($trx == "cp"){



				$arrdata = $this->trans_act->get_cp($kode);



				echo $this->load->view('pengujian/sampel/transaksi/cp', $arrdata, true);



			}



		}



	}



	#End Detil Transaksi Sampel



	



	function prioritas($kategori){



		if($this->newsession->userdata('LOGGED_IN')){



			$this->load->model('master/kategori_act');



			$arrdata = $this->kategori_act->get_kategori($kategori);



			echo $this->load->view('master/master-prioritas-fi',$arrdata, true);



		}



	}

	

	function get_prioritas($id){

		if($this->newsession->userdata('LOGGED_IN')){

			$this->load->model('main');

			$data = "SELECT LTRIM(RTRIM(SRL_ID)) AS SRL_ID, LTRIM(RTRIM(REPLACE(PARAMETER_UJI,'\n',''))) AS PARAMETER_UJI, SIMULAN, KATEGORI_PU, REPLACE(METODE,'\n',' ') AS METODE, REPLACE(PUSTAKA,'\n','') AS PUSTAKA, REPLACE(SYARAT,'\n','') AS SYARAT, REPLACE(RUANG_LINGKUP,'\n','') AS RUANG_LINGKUP, BIDANG_UJI, GOLONGAN, dbo.KATEGORI(GOLONGAN, '1') AS UR_KLASIFIKASI FROM M_PRIORITAS WHERE SRL_ID = '".$id."'";

			$res = $this->main->get_result($data);

			if ($res){

				foreach ($data->result_array() as $row){

					echo $row['PARAMETER_UJI'] . "|" . $row['METODE'] . "|" . $row['PUSTAKA'] . "|" . $row['SYARAT'] . "|" . $row['RUANG_LINGKUP'] . "|" . $row['BIDANG_UJI'] . "|" . $row['GOLONGAN'] . "|" . $row['SRL_ID'] . "|". $row['SIMULAN'] . "|". $row['KATEGORI_PU'];

				}

			}else{

				echo "Data tidak ditemukan";

			}

		}

	}



}



?>