<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class User_activity extends Model{
	function user_login($uid, $pwd, $isadm=FALSE){
		if($isadm){
			$pass = $pwd;
		}else{
			$pass = md5($pwd);
		}
		$data = $this->db->query("SELECT CONVERT(VARCHAR, GETDATE(), 120) AS SEKARANG, A.USER_ID, A.PASSWORD, A.NAMA_USER, A.JABATAN, CONVERT(VARCHAR(19), A.LOGIN, 120) AS LOGIN, CONVERT(VARCHAR(19), A.LOGOUT, 120) AS LOGOUT, A.BBPOM_ID, B.NAMA_BBPOM, B.PROPINSI_ID, B.TIPE, B.WILAYAH, C.ROLE, C.JENIS_PELAPORAN, C.KK_ID, LEFT(C.SARANA_MEDIA_ID, 2) AS SUB_SARANA, C.SARANA_MEDIA_ID, D.NAMA_JENIS_SARANA, E.NAMA_KK, M.URAIAN, U.URAIAN AS UR_ROLE FROM T_USER A LEFT JOIN M_BBPOM B ON A.BBPOM_ID = B.BBPOM_ID LEFT JOIN T_USER_ROLE C ON A.USER_ID = C.USER_ID LEFT JOIN M_JENIS_SARANA D ON C.SARANA_MEDIA_ID = D.JENIS_SARANA_ID LEFT JOIN M_KLASIFIKASI_KATEGORI E ON C.KK_ID = E.KK_ID LEFT JOIN M_TABEL M ON C.ROLE = M.KODE LEFT JOIN M_TABEL U ON C.ROLE = U.KODE WHERE A.USER_ID = '$uid' AND A.PASSWORD = '$pass' AND M.JENIS = 'ROLE' AND U.JENIS='ROLE' AND A.STATUS = 'Aktif'");
		
		if($data->num_rows() > 0){
			$role = array();
			$jenis_pelaporan = array();
			$klasifikasi_kategori = array();
			$sarana_media = array();
			$sub_sarana = array();
			$uraian_sarana = array();
			$uraian_role = array();
			$nama_kk = array();
			foreach($data->result_array() as $row){
				if(!array_key_exists($row['ROLE'], $role)) $role[$row['ROLE']] = $row['ROLE'];
				if(!array_key_exists($row['UR_ROLE'], $uraian_role)) $uraian_role[$row['UR_ROLE']] = $row['UR_ROLE'];
				if(!array_key_exists($row['JENIS_PELAPORAN'], $jenis_pelaporan)) $jenis_pelaporan[$row['JENIS_PELAPORAN']] = $row['JENIS_PELAPORAN'];
				if(!array_key_exists($row['KK_ID'], $klasifikasi_kategori)) $klasifikasi_kategori[$row['KK_ID']] = $row['KK_ID'];
				if(!array_key_exists($row['SARANA_MEDIA_ID'], $sarana_media)) $sarana_media[$row['SARANA_MEDIA_ID']] = $row['SARANA_MEDIA_ID'];
				if(!array_key_exists($row['SUB_SARANA'], $sub_sarana)) $sub_sarana[$row['SUB_SARANA']] = $row['SUB_SARANA'];
				if(!array_key_exists($row['NAMA_JENIS_SARANA'], $uraian_sarana)) $uraian_sarana[$row['NAMA_JENIS_SARANA']] = $row['NAMA_JENIS_SARANA'];
				if(!array_key_exists($row['NAMA_KK'], $nama_kk)) $nama_kk[$row['NAMA_KK']] = $row['NAMA_KK'];
				$datses['SESS_KODE_ROLE'] = $role;
				$datses['SESS_UR_ROLE'] = $uraian_role;
				$datses['SESS_JENIS_PELAPORAN'] = $jenis_pelaporan;
				$datses['SESS_SARANA'] = $sarana_media;
				$datses['SESS_SUB_SARANA'] = $sub_sarana;
				$datses['SESS_URAIAN_SARANA'] = $uraian_sarana;
				$datses['SESS_KLASIFIKASI_ID'] = $klasifikasi_kategori;
				$datses['SESS_URAIAN_KK'] = $nama_kk;
			}
			
			if(in_array('B1',$sub_sarana))
				$datses['SESS_BIDANG_UJI'] = '02';
			else if(in_array('B2',$sub_sarana))
				$datses['SESS_BIDANG_UJI'] = '02';
			else
				$datses['SESS_BIDANG_UJI'] = '01';

			$datses['LOGGED_IN'] = TRUE;
			$datses['SESS_USER_ID'] = $row['USER_ID'];
			$datses['SESS_PASSWORD'] = $row['PASSWORD'];
			$datses['SESS_BBPOM_ID'] = $row['BBPOM_ID'];
			$datses['SESS_TIPE_BBPOM'] = $row['TIPE'];
			$datses['SESS_NAMA_USER'] = $row['NAMA_USER'];
			$datses['SESS_LOGIN'] = $row['LOGIN'];
			$datses['LOGS'] = $row['SEKARANG'];
			$datses['SESS_LOGOUT'] = $row['LOGOUT'];
			$datses['SESS_JABATAN'] = $row['JABATAN'];
			$datses['SESS_BBPOM_ID'] = $row['BBPOM_ID'];
			$datses['SESS_MBBPOM'] = $row['NAMA_BBPOM'];
			$datses['SESS_PROP_ID'] = $row['PROPINSI_ID'];
			$datses['WILAYAH'] = $row['WILAYAH'];
			$datses['SESS_AGENTS'] = $this->get_agents();
			$datses['SESS_IP'] = $_SERVER['REMOTE_ADDR'];
			$data = array('LOGIN' => 'GETDATE()');
			$this->db->where('USER_ID', $uid);
			$this->db->where('PASSWORD', md5($pwd));
			$this->db->update('T_USER', $data);
			$this->newsession->set_userdata($datses);
			$id = $datses['SESS_USER_ID'].date("dmYHis");
			$this->db->simple_query("INSERT INTO T_USER_LOG(ID, USER_ID, KEGIATAN, WAKTU, IP_ADDRESS) VALUES('".$id."','".$datses['SESS_USER_ID']."', 'Login Dari IP ".$_SERVER['REMOTE_ADDR']."',GETDATE(),'".$_SERVER['REMOTE_ADDR']."')");
			return "YES";
		}else{
			return "NO";
		}
	}
	
	function get_agents(){
		$this->load->library('user_agent');		
		$agent = "";
		if($this->agent->is_browser()){
			$agent = $this->agent->browser().' '.$this->agent->version();
		}else if($this->agent->is_robot()){
			$agent = $this->agent->robot();
		}else if($this->agent->is_mobile()){
			$agent = $this->agent->mobile();
		}else{
			$agent = 'Unidentified User Agent';
		}
		return $agent;
	}
}
?>