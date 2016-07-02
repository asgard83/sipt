<?php
class Uploads extends Controller {
	function Uploads(){
		parent::Controller();	
	}
	
	function set_img(){
		if($this->newsession->userdata('LOGGED_IN') && array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('10', $this->newsession->userdata('SESS_KODE_ROLE'))){
			$config['allowed_types'] = "png|jpg|gif|jpeg|pjegp";
			$config['upload_path'] = "./upload/img/";	
			$config['remove_spaces'] = TRUE;
			$config['file_name'] = date("Ymd")."_".date("His")."_".".jpg";
			$this->load->library('upload' , $config);
			$this->upload->display_errors('' ,'' );
			if(!$this->upload->do_upload("userfile")){
				$array = array('filelink' =>$this->upload->display_errors());
			}else{
				$data = $this->upload->data();
				$filename = $data['file_name'];
				$array = array('filelink' => base_url().'upload/img/'.$filename);
			}
			echo stripslashes(json_encode($array));
		}
	}
}

