<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Petugas_act extends Model{

	function list_petugas($id){
		if($this->newsession->userdata('LOGGED_IN') || array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('9', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('10', $this->newsession->userdata('SESS_KODE_ROLE'))){
			if($id=="aktif"){
				$status = "A.STATUS='Aktif'";
				$proses = array('Edit Petugas' => array('GET', site_url()."/home/petugas/new", '1'),'Non Aktifkan Petugas' => array('POST', site_url()."/master/master/petugas/non-aktif/ajax", 'N'), 'Kirim Ulang Password Petugas' => array('POST', site_url()."/master/master/petugas/resend/ajax", 'N'));
			}else if($id=="non-aktif"){
				$status = "A.STATUS='Non-Aktif'";
				$proses = array('Aktifkan Petugas' => array('POST', site_url()."/master/master/petugas/aktif/ajax", 'N'),'Hapus Petugas' => array('POST', site_url()."/master/master/petugas/hapus/ajax", 'N'));
			}else{
				$this->fungsi->redirectMessage('Maaf, halaman yang anda tuju tidak ditemukan.','/home');
			}
			
			if(array_key_exists('9', $this->newsession->userdata('SESS_KODE_ROLE'))){
				$sarana = "'".join("','", $this->newsession->userdata('SESS_SARANA'))."'";
				$query = "SELECT A.USER_ID AS NIP, A.NAMA_USER AS [NAMA PETUGAS], A.JABATAN, B.NAMA_BBPOM AS [BADAN POM], A.EMAIL FROM T_USER A LEFT JOIN M_BBPOM B ON A.BBPOM_ID = B.BBPOM_ID WHERE A.BBPOM_ID='".$this->newsession->userdata('SESS_BBPOM_ID')."' AND A.USER_ID IN (SELECT DISTINCT USER_ID FROM T_USER_ROLE WHERE ROLE NOT IN('1','9','10') AND SARANA_MEDIA_ID IN (".$sarana.")) AND $status";
			}else if(array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('10', $this->newsession->userdata('SESS_KODE_ROLE'))){
				$query = "SELECT A.USER_ID AS NIP, A.NAMA_USER AS [NAMA PETUGAS], A.JABATAN, B.NAMA_BBPOM AS [BADAN POM], A.EMAIL FROM T_USER A LEFT JOIN M_BBPOM B ON A.BBPOM_ID = B.BBPOM_ID WHERE $status";
				
			}		
			
			$this->load->library('newtable');
			$this->newtable->hiddens(array(''));
			$this->newtable->search(array(array('A.USER_ID', 'Nama Pengguna'), array('A.NAMA_USER', 'Nama Petugas'), array('B.NAMA_BBPOM', 'Asal Balai Besar / Balai')));
			$this->newtable->action(site_url()."/home/petugas/list/$id");
			$this->newtable->detail(site_url()."/master/master/set_detil/petugas");
			$this->newtable->cidb($this->db);
			$this->newtable->ciuri($this->uri->segment_array());
			$this->newtable->orderby("A.USER_ID ASC");
			$this->newtable->keys(array('NIP'));
			$this->newtable->menu($proses);
			$tabel = $this->newtable->generate($query);
			$arrdata = array('table' => $tabel,
							 'idjudul' => 'judulpetugas',
							 'caption_header' => 'Data Master Petugas SIPT',
							 'batal' => '',
							 'cancel' => '');
			return $arrdata;
		}else{
			$this->fungsi->redirectMessage('Maaf, halaman yang anda tuju tidak ditemukan.','/home');
		}
	}
	
	function get_admin_balai($id){
		if(array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('10', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('9', $this->newsession->userdata('SESS_KODE_ROLE'))){
			$sipt =& get_instance();
			$sipt->load->model("main","main", true);
			if(array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE'))){
				$bbpom = $sipt->main->combobox("SELECT BBPOM_ID, NAMA_BBPOM FROM M_BBPOM ORDER BY BBPOM_ID ASC", "BBPOM_ID", "NAMA_BBPOM", TRUE);
				$role = $sipt->main->combobox("SELECT KODE, URAIAN FROM M_TABEL WHERE JENIS='ROLE' AND KODE IN ('9','10')", "KODE", "URAIAN");
				$jenis = $sipt->main->combobox("SELECT KODE, URAIAN FROM M_TABEL WHERE JENIS='JENIS_PELAPORAN' AND KODE IN ('00')", "KODE", "URAIAN");
				$kk_id = "'".join("','",$this->config->item('jenis_sarana'))."'";
				$klasifikasi = $sipt->main->combobox("SELECT KK_ID, NAMA_KK FROM M_KLASIFIKASI_KATEGORI WHERE LEN(KK_ID)=3 AND KK_ID IN (".$kk_id.")", "KK_ID", "NAMA_KK");
			}else if(array_key_exists('10', $this->newsession->userdata('SESS_KODE_ROLE'))){
				$bbpom = $sipt->main->combobox("SELECT BBPOM_ID, NAMA_BBPOM FROM M_BBPOM ORDER BY BBPOM_ID ASC", "BBPOM_ID", "NAMA_BBPOM", TRUE);
				$role = $sipt->main->combobox("SELECT KODE, URAIAN FROM M_TABEL WHERE JENIS='ROLE' AND KODE NOT IN ('1','10')", "KODE", "URAIAN");			  
				$jenis = $sipt->main->combobox("SELECT KODE, URAIAN FROM M_TABEL WHERE JENIS='JENIS_PELAPORAN' AND KODE NOT IN ('00')", "KODE", "URAIAN", TRUE);
				$kk_id = "'".join("','",$this->config->item('jenis_sarana'))."'";
				$klasifikasi = $sipt->main->combobox("SELECT KK_ID, NAMA_KK FROM M_KLASIFIKASI_KATEGORI WHERE LEN(KK_ID)=3 AND KK_ID IN (".$kk_id.")", "KK_ID", "NAMA_KK");
			}else{
				$bbpom = $sipt->main->combobox("SELECT BBPOM_ID, NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'", "BBPOM_ID", "NAMA_BBPOM");
				$role = $sipt->main->combobox("SELECT KODE, URAIAN FROM M_TABEL WHERE JENIS='ROLE' AND KODE NOT IN ('1','9','10')", "KODE", "URAIAN");			  
				$jenis = $sipt->main->combobox("SELECT KODE, URAIAN FROM M_TABEL WHERE JENIS='JENIS_PELAPORAN' AND KODE NOT IN ('00')", "KODE", "URAIAN", TRUE);
				$kk_id = "'".join("','", $this->newsession->userdata('SESS_SARANA'))."'";
				$klasifikasi = $sipt->main->combobox("SELECT KK_ID, NAMA_KK FROM M_KLASIFIKASI_KATEGORI WHERE LEN(KK_ID)=3 AND JENIS_SARANA_ID IN (".$kk_id.")", "KK_ID", "NAMA_KK");
			}
			if($id==""){
				$arrdata = array('sess' => '',
								 'header' => 'Tambah Petugas Baru',
								 'act' => site_url().'/master/master/save/petugas/simpan',
								 'batal' => site_url().'/home/petugas/list/aktif',
								 'id' => '',
								 'sel_klasifikasi' => '',
								 'save' => 'Simpan',
								 'cancel' => 'Batal');
			}else{
				$query = "SELECT A.USER_ID, A.NAMA_USER, A.JABATAN, A.EMAIL, A.BBPOM_ID, B.ROLE, B.JENIS_PELAPORAN, B.KK_ID, B.SARANA_MEDIA_ID FROM T_USER A LEFT JOIN T_USER_ROLE B ON A.USER_ID = B.USER_ID WHERE A.USER_ID = '$id'";
				$data = $sipt->main->get_result($query);
				$sel_klasifikasi = array();
				if($data){
					foreach($query->result_array() as $row){
						if(!array_key_exists($row['KK_ID'], $sel_klasifikasi)) $sel_klasifikasi[$row['KK_ID']] = $row['KK_ID'];						
						$arrdata = array('sess' => $row,
										 'header' => 'Edit Petugas',
										 'act' => site_url().'/master/master/save/petugas/update',
										 'batal' => site_url().'/home/petugas/list/aktif',
										 'id' => $row['USER_ID'],
										 'sel_klasifikasi' => $sel_klasifikasi,
										 'save' => 'Update',
										 'cancel' => 'Kembali');
					}
				}
			}
			$arrdata['bbpom'] = $bbpom;
			$arrdata['role'] = $role;
			$arrdata['jenis'] = $jenis;
			$arrdata['klasifikasi'] = $klasifikasi;
			return $arrdata;
		}else{
			$this->fungsi->redirectMessage('Maaf, halaman yang anda tuju tidak ditemukan.','/home');
		}
	}
	
	function set_detil($id){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){ 
			$sipt =& get_instance();
			$sipt->load->model("main","main", true);
			$query = "SELECT CAST(SUBSTRING(A.USER_ID, 0, 9)+ ' ' +SUBSTRING(A.USER_ID, 9, 6)+' '+SUBSTRING(A.USER_ID, 15, 1)+' '+SUBSTRING(A.USER_ID, 16, 3) AS VARCHAR) AS NIP, A.NAMA_USER, A.JABATAN, B.NAMA_BBPOM, A.EMAIL, A.STATUS FROM T_USER A LEFT JOIN M_BBPOM B ON A.BBPOM_ID = B.BBPOM_ID WHERE A.USER_ID = '$id'";
			$data = $sipt->main->get_result($query);
			if($data){
				foreach($query->result_array() as $row){
					$arrdata = array('sess' => $row);
				}
			}
			return $arrdata;
		}else{
			$this->fungsi->redirectMessage('Maaf, halaman yang anda tuju tidak ditemukan.','/home');
		}
	}
	
	function SavePetugas($setaction, $isajax){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){ 
			$sipt =& get_instance();
			$sipt->load->model("main","main", true);
			if($setaction=="simpan"){#Insert Petugas Baru
				$ret = "MSG#NO#Data gagal disimpan";
				$arr_user = array('LOGIN' => 'GETDATE()',
								  'LOGOUT' => 'GETDATE()',
								  'STATUS' => 'Aktif');
				foreach($this->input->post('PETUGAS') as $a => $z){
					$arr_user[$a] = $z;
				}
				$inv_user = (int)$sipt->main->get_uraian("SELECT COUNT(*) AS INVALID FROM T_USER WHERE USER_ID = '".$arr_user['USER_ID']."'", "INVALID");
				if($inv_user>0) return "MSG#NO#User ID Tersebut telah digunakan.";
				$eml_user = (int)$sipt->main->get_uraian("SELECT COUNT(*) AS ISEMAIL FROM T_USER WHERE EMAIL = '".$arr_user['EMAIL']."'", "ISEMAIL");
				if($eml_user>0) return "MSG#NO#Email Tersebut telah digunakan";
				$pwd = str_shuffle("0123456789");
				$pwd = substr($pwd, 3, 6);
				$arr_user['PASSWORD'] = md5($pwd);
				$email = $arr_user['EMAIL'];
				$nama = $arr_user['NAMA_USER'];
				if($this->db->insert('T_USER', $arr_user)){
					foreach($this->input->post('ROLE') as $x => $y){
						$arr_role[$x] = $y;
					}
					$kk_id = "'".join("','",$arr_role['KK_ID'])."'";
					$query = "SELECT KK_ID, JENIS_SARANA_ID FROM M_KLASIFIKASI_KATEGORI WHERE LEN(KK_ID) = 3 AND KK_ID IN (".$kk_id.")";
					$data = $sipt->main->get_result($query); 
					$hasil_kk = array();
					if($data){
						foreach($query->result_array() as $row){
							$hasil_kk[] = $row;
						}
						for($a=0;$a<count($hasil_kk);$a++){
							$arr_roles['USER_ID'] = $arr_user['USER_ID'];
							$arr_roles['ROLE'] = $arr_role['ROLE'];
							$arr_roles['JENIS_PELAPORAN'] = $arr_role['JENIS_PELAPORAN'];
							$arr_roles['KK_ID'] = $hasil_kk[$a]['KK_ID'];
							$arr_roles['SARANA_MEDIA_ID'] = $hasil_kk[$a]['JENIS_SARANA_ID'];
							$this->db->insert('T_USER_ROLE', $arr_roles);
						}
					}
					$subject = "Konfirmasi Pendaftaran Petugas SIPT Badan POM RI";
					$isi = 'Selamat, Nama anda telah diverifikasi dan diterima oleh Administrator Sistem Informasi Pelaporan Terpadu (SIPT) Badan Pengawas Obat dan Makanan Republik Indonesia. Untuk login ke Sistem Informasi Pelaporan Terpadu (SIPT) Badan Pengawas Obat dan Makanan Republik Indonesia silahkan login dengan: <table style="margin: 4px 4px 4px 10px; font-family: arial; font-size:12px; font-weight: 700; width:580px;"><tr><td width="65">NIP</td><td>: <b>'.$arr_user['USER_ID'].'</b></td></tr><tr><td>Password</td><td>: <b>'.$pwd.'</b></td></tr></table>Terima kasih.'; 
					if($sipt->main->send_mail($email, $nama, $subject, $isi)){
						$ret = "MSG#YES#Data berhasil disimpan dan konfirmasi telah dikirim ke E-mail#".site_url().'/home/petugas/list/aktif';			
					}else{
						$ret = "MSG#YES#Data berhasil disimpan. Konfirmasi Email gagal Terkirim#".site_url().'/home/petugas/list/aktif';
					}
				}

				if($isajax!="ajax"){
					redirect(site_url().'/home');
					exit();
				}
				return $ret;
			}else if($setaction=="update"){#Update Petugas
				$ret = "MSG#NO#Data gagal disimpan";
				foreach($this->input->post('PETUGAS') as $a => $z){
					$arr_user[$a] = $z;
				}
				//$eml_user = (int)$sipt->main->get_uraian("SELECT COUNT(*) AS ISEMAIL FROM T_USER WHERE EMAIL = '".$arr_user['EMAIL']."'", "ISEMAIL");
				//if($eml_user>0) return "MSG#NO#Email Tersebut telah digunakan.";

				$this->db->where(array("USER_ID" => $this->input->post('USER_ID')));
				if($this->db->update('T_USER', $arr_user)){
					$this->db->where('USER_ID', $this->input->post('USER_ID'));
					$this->db->delete('T_USER_ROLE');
					foreach($this->input->post('ROLE') as $x => $y){
						$arr_role[$x] = $y;
					}
					$kk_id = "'".join("','",$arr_role['KK_ID'])."'";
					$query = "SELECT KK_ID, JENIS_SARANA_ID FROM M_KLASIFIKASI_KATEGORI WHERE LEN(KK_ID) = 3 AND KK_ID IN (".$kk_id.")";
					$data = $sipt->main->get_result($query); 
					$hasil_kk = array();
					if($data){
						foreach($query->result_array() as $row){
							$hasil_kk[] = $row;
						}
						for($a=0;$a<count($hasil_kk);$a++){
							$arr_roles['USER_ID'] = $this->input->post('USER_ID');
							$arr_roles['ROLE'] = $arr_role['ROLE'];
							$arr_roles['JENIS_PELAPORAN'] = $arr_role['JENIS_PELAPORAN'];
							$arr_roles['KK_ID'] = $hasil_kk[$a]['KK_ID'];
							$arr_roles['SARANA_MEDIA_ID'] = $hasil_kk[$a]['JENIS_SARANA_ID'];
							$this->db->insert('T_USER_ROLE', $arr_roles);
						}
					}
					if($isajax!="ajax"){
						redirect(base_url());
						exit();
					}
					$ret = "MSG#YES#Data berhasil disimpan#".site_url()."/home/petugas/list/aktif";
				}
				if($isajax!="ajax"){
					redirect(site_url().'/home');
					exit();
				}
				return $ret;
			}
		}else{
			$this->fungsi->redirectMessage('Maaf, halaman yang anda tuju tidak ditemukan.','/home');
		}
	}
	
	function set_petugas($action, $isajax){
		if($this->newsession->userdata('LOGGED_IN') || array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('9', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('10', $this->newsession->userdata('SESS_KODE_ROLE'))){
			  $sipt =& get_instance();
			  $sipt->load->model("main", "main", true);
			  if($action=="aktif"){#Aktifkan Petugas
				  $ret = "MSG#Petugas Gagal di Aktifkan.";
				  foreach($this->input->post('tb_chk') as $a){
					  $arr_aktif = array("STATUS" => "Aktif");
					  $this->db->where('USER_ID', $a);
					  if($this->db->update('T_USER', $arr_aktif)) $ret = "MSG#Petugas berhasil diaktifkan#".site_url()."/home/petugas/list/aktif"; 
				  }
				  
				  if($isajax!="ajax"){
					  redirect(base_url());
					  exit();
				  }
				  return $ret;
			  }else if($action=="non-aktif"){#Non Aktifkan Petugas
				  $ret = "MSG#Petugas Gagal di Non-aktifkan.";
				  foreach($this->input->post('tb_chk') as $a){
					  $arr_aktif = array("STATUS" => "Non-Aktif");
					  $this->db->where('USER_ID', $a);
					  if($this->db->update('T_USER', $arr_aktif)) $ret = "MSG#Petugas berhasil di non-aktifkan#".site_url()."/home/petugas/list/non-aktif"; 
				  }
				  if($isajax!="ajax"){
					  redirect(base_url());
					  exit();
				  }
				  return $ret;				  
			  }else if($action=="hapus"){#Hapus Data Petugas
				  $ret = "MSG#Petugas Gagal di Hapus.";
				  foreach($this->input->post('tb_chk') as $a){
					  $this->db->where('USER_ID', $a);
					  if($this->db->delete('T_USER')) $ret = "MSG#Petugas berhasil di hapus#".site_url()."/home/petugas/list/non-aktif"; 
				  }
				  if($isajax!="ajax"){
					  redirect(base_url());
					  exit();
				  }
				  return $ret;				  
			  }else if($action=="resend"){#Kirim Ulang Password Petugas
				$ret = "MSG#Kirim Ulang Password Petugas Gagal.";
				foreach($this->input->post('tb_chk') as $chkitem){
					$id[] = $chkitem;
				}
				$id = "'".join("','", $id)."'";
				$query = "SELECT USER_ID, NAMA_USER, EMAIL FROM T_USER WHERE USER_ID IN ($id)";
				$data = $sipt->main->get_result($query);
				if($data){
					foreach($query->result() as $row){
						$user_id = $row->USER_ID;
						$nama = $row->NAMA_USER;
						$email = $row->EMAIL;
						$pwd = str_shuffle("0123456789");
						$pwd = substr($pwd, 3, 6);
						$subject = "Reset Password";
						$isi = 'Password anda di Sistem Informasi Pelaporan Terpadu (SIPT) Badan Pengawas Obat dan Makanan Republik Indonesia telah di ubah oleh Administrator. Untuk login ke Sistem Informasi Pelaporan Terpadu (SIPT) Badan Pengawas Obat dan Makanan Republik Indonesia silahkan login dengan: <table style="margin: 4px 4px 4px 10px; font-family: arial; font-size:12px; font-weight: 700; width:580px;"><tr><td width="65">NIP</td><td>: <b>'.$user_id.'</b></td></tr><tr><td>Password</td><td>: <b>'.$pwd.'</b></td></tr></table>Terima kasih.';
						if($sipt->main->send_mail($email, $nama, $subject, $isi)){
							$this->db->where('USER_ID', $user_id);
							if($this->db->update('T_USER', array("PASSWORD" => md5($pwd)))) $ret = "MSG#Kirim Ulang Password Petugas Berhasil. Konfirmasi E-mail berhasil dikirim#";
						}else{
							$this->db->where('USER_ID', $user_id);
							if($this->db->update('T_USER', array("PASSWORD" => md5($pwd)))) $ret = "MSG#Kirim Ulang Password Petugas Berhasil. Konfirmasi E-mail gagal dikirim#";
						}
					}
						
				}
				if($isajax!="ajax"){
					redirect(base_url());
					exit();
				}
				return $ret;
			  }
		}
	}
	
	
	
}
?>