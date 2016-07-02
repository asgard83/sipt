<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Main extends Model{
	var $webreg;
	function get_uraian($query, $select){
		$data = $this->db->query($query);
		if($data->num_rows() > 0){
			$row = $data->row();
			return $row->$select;
		}else{
			return "";
		}
		return 1;
	}

	function get_result(&$query){
		$data = $this->db->query($query);
		if($data->num_rows() > 0){
			$query = $data;
		}else{
			return false;
		}
		return true;
	}

	function get_result_webreg(&$query){
		$this->webreg = $this->load->database('registrasi', TRUE);
		$data = $this->webreg->query($query);
		if($data->num_rows() > 0){
			$query = $data;
		}else{
			return false;
		}
		return true;
	}

	function combobox($query, $key, $value, $empty = FALSE, &$disable = ""){
		$combobox = array();
		$data = $this->db->query($query);
		if($empty) $combobox[""] = "&nbsp;";
		if($data->num_rows() > 0){
			$kodedis = "";
			$arrdis = array();
			foreach($data->result_array() as $row){
				if(is_array($disable)){
					if($kodedis==$row[$disable[0]]){
						if(!array_key_exists($row[$key], $combobox)) $combobox[$row[$key]] = "&nbsp; &nbsp;&nbsp;&nbsp;".$row[$value];
					}else{
						if(!array_key_exists($row[$disable[0]], $combobox)) $combobox[$row[$disable[0]]] = $row[$disable[1]];
						if(!array_key_exists($row[$key], $combobox)) $combobox[$row[$key]] = "&nbsp; &nbsp;&nbsp;&nbsp;".$row[$value];
					}
					$kodedis = $row[$disable[0]];
					if(!in_array($kodedis, $arrdis)) $arrdis[] = $kodedis;
				}else{
					$combobox[$row[$key]] = str_replace("'", "\'", $row[$value]);
				}
			}
			$disable = $arrdis;
		}
		return $combobox;
	}

	function get_combobox($query, $key, $value){
		$combobox = "";
		$data = $this->db->query($query);
		if($data->num_rows() > 0){
			foreach($data->result_array() as $row){
				$combobox[$row[$key]] = $row[$value];
			}
		}else{
			return false;
		}
		return $combobox;
	}

	function set_verifikasi(&$status, $laporan, $roleid){
		$combobox[""] = "&nbsp;";
		$pelaporan = "'".join("', '", array_keys($laporan))."'";
		$role = "'".join("', '", array_keys($roleid))."'";
		$query = "SELECT A.PROSES, A.SESUDAH, B.URAIAN, C.URAIAN AS STATUS FROM M_VERIFIKASI A LEFT JOIN M_TABEL B ON A.PROSES = B.KODE LEFT JOIN M_TABEL C ON A.SESUDAH = C.KODE WHERE A.ROLE_ID IN ($role) AND A.SEBELUM = '$status' AND B.JENIS = 'PROSES' AND C.JENIS = 'STATUS' AND A.PELAPORAN_ID IN ($pelaporan) ORDER BY A.PROSES ASC";
		$data = $this->db->query($query);
		if($data->num_rows() > 0){
			$proses = array("", "");
			$arrsts = array("", "");
			foreach($data->result_array() as $row){
				$arrsts[0] = $row['SESUDAH'];
				$arrsts[1] = $row['STATUS'];
				$proses[1] = $row['URAIAN'];
				if($proses[0]==$row['PROSES']){
					$combobox[$arrsts[0]] = "&nbsp;&nbsp;&nbsp;&nbsp;".$arrsts[1];
				}else{
					$combobox[$row['PROSES']] = $proses[1];
					$combobox[$arrsts[0]] = "&nbsp;&nbsp;&nbsp;&nbsp;".$arrsts[1];
				}
				$proses[0] = $row['PROSES'];
				$arrdis[] = $proses[0];
			}
			$status = $arrdis;
		}
		return $combobox;
	}

	function verifikasi_direktur(&$status, $laporan, $roleid){
		$combobox[""] = "&nbsp;";
		$pelaporan = "'".join("', '", array_keys($laporan))."'";
		$role = "'".join("', '", array_keys($roleid))."'";
		$query = "SELECT A.PROSES, A.SESUDAH, B.URAIAN, C.URAIAN AS STATUS FROM M_VERIFIKASI A LEFT JOIN M_TABEL B ON A.PROSES = B.KODE LEFT JOIN M_TABEL C ON A.SESUDAH = C.KODE WHERE A.ROLE_ID IN ($role) AND A.SEBELUM = '$status' AND B.JENIS = 'PROSES' AND C.JENIS = 'STATUS' AND A.PELAPORAN_ID IN ($pelaporan) AND SESUDAH IN ('40112','60010','60020') ORDER BY A.PROSES ASC";
		$data = $this->db->query($query);
		if($data->num_rows() > 0){
			$proses = array("", "");
			$arrsts = array("", "");
			foreach($data->result_array() as $row){
				$arrsts[0] = $row['SESUDAH'];
				$arrsts[1] = $row['STATUS'];
				$proses[1] = $row['URAIAN'];
				if($proses[0]==$row['PROSES']){
					$combobox[$arrsts[0]] = "&nbsp;&nbsp;&nbsp;&nbsp;".$arrsts[1];
				}else{
					$combobox[$row['PROSES']] = $proses[1];
					$combobox[$arrsts[0]] = "&nbsp;&nbsp;&nbsp;&nbsp;".$arrsts[1];
				}
				$proses[0] = $row['PROSES'];
				$arrdis[] = $proses[0];
			}
			$status = $arrdis;
		}
		return $combobox;
	}

	function find_where($query){
		if(strpos($query,"WHERE")===FALSE){
			$query = " WHERE ";
		}else{
			$query = " AND ";
		}
		return $query;
	}

	function status_send(){
		$stat = "";
		if(in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))){#Sent Pusat
			if(in_array('2', $this->newsession->userdata('SESS_KODE_ROLE'))){
				$stat .= $this->get_uraian("SELECT URAIAN FROM M_TABEL WHERE JENIS = 'SENT' AND KODE = '0202'","URAIAN");
			}
			if(in_array('3', $this->newsession->userdata('SESS_KODE_ROLE'))){
				$stat .= $this->get_uraian("SELECT URAIAN FROM M_TABEL WHERE JENIS = 'SENT' AND KODE = '0302'","URAIAN");
			}
			if(in_array('4', $this->newsession->userdata('SESS_KODE_ROLE'))){
				$stat .= $this->get_uraian("SELECT URAIAN FROM M_TABEL WHERE JENIS = 'SENT' AND KODE = '0402'","URAIAN");
			}
			if(in_array('6', $this->newsession->userdata('SESS_KODE_ROLE'))){
				$stat .= $this->get_uraian("SELECT URAIAN FROM M_TABEL WHERE JENIS = 'SENT' AND KODE = '0601'","URAIAN");
			}
		}else{#Sent Balai
			if(in_array('2', $this->newsession->userdata('SESS_KODE_ROLE'))){
				$stat .= $this->get_uraian("SELECT URAIAN FROM M_TABEL WHERE JENIS = 'SENT' AND KODE = '0201'","URAIAN");
			}
			if(in_array('3', $this->newsession->userdata('SESS_KODE_ROLE'))){
				$stat .= $this->get_uraian("SELECT URAIAN FROM M_TABEL WHERE JENIS = 'SENT' AND KODE = '0301'","URAIAN");
			}
			if(in_array('4', $this->newsession->userdata('SESS_KODE_ROLE'))){
				$stat .= $this->get_uraian("SELECT URAIAN FROM M_TABEL WHERE JENIS = 'SENT' AND KODE = '0401'","URAIAN");
			}
			if(in_array('5', $this->newsession->userdata('SESS_KODE_ROLE'))){
				$stat .= $this->get_uraian("SELECT URAIAN FROM M_TABEL WHERE JENIS = 'SENT' AND KODE = '0501'","URAIAN");
			}
		}
		$arr = explode(",",$stat);
		if(empty($arr[count($arr)-1])){
			unset($arr[count($arr)-1]);
		}
		$status = "'".join("','", array_unique($arr))."'";
		return $status;

	}

	function get_judul($params){
		$judul = "";
		$judul = $this->get_uraian("SELECT (B.NAMA_JENIS_SARANA + ' - ' + A.NAMA_JENIS_SARANA) AS JUDUL FROM M_JENIS_SARANA A LEFT JOIN M_JENIS_SARANA B ON LEFT(A.JENIS_SARANA_ID, 2) = B.JENIS_SARANA_ID WHERE A.JENIS_SARANA_ID = '".$params."'","JUDUL");
		return $judul;
	}

	function get_jenis_sarana($sess_user, &$inputan=""){
		$jenis_sarana = "";
		$sarana = "'".join("','", $this->newsession->userdata('SESS_SARANA'))."'";
		if(in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')))
			$filter = "(SELECT SARANA_MEDIA_ID FROM T_USER_ROLE WHERE A.JENIS_SARANA_ID IN (".$sarana.") AND USER_ID='".$sess_user."')";
		else
			$filter = "(SELECT SARANA_MEDIA_ID FROM T_USER_ROLE WHERE USER_ID='".$sess_user."')";
		$jenis_sarana = $this->combobox("SELECT A.JENIS_SARANA_ID, A.NAMA_JENIS_SARANA, B.JENIS_SARANA_ID AS JENISDIS, B.NAMA_JENIS_SARANA AS NAMADIS FROM M_JENIS_SARANA A LEFT JOIN M_JENIS_SARANA B ON LEFT(A.JENIS_SARANA_ID, 2) = B.JENIS_SARANA_ID WHERE A.JENIS_SARANA_ID IN $filter ORDER BY A.JENIS_SARANA_ID ASC","JENIS_SARANA_ID","NAMA_JENIS_SARANA", TRUE, $inputan);
		return $jenis_sarana;
	}

	function get_klasifikasi(){
		$klasifikasi = "";
		$klasifikasi = $this->combobox("SELECT KK_ID, NAMA_KK FROM M_KLASIFIKASI_KATEGORI","KK_ID","NAMA_KK", TRUE);
		return $klasifikasi;
	}

	function get_kegiatan($kegiatan=""){
		$id = $this->newsession->userdata('SESS_USER_ID').date("dmYHis");
		$dat = $this->db->simple_query("INSERT INTO T_USER_LOG(ID, USER_ID, KEGIATAN, WAKTU, IP_ADDRESS) VALUES('".$id."','".$this->newsession->userdata('SESS_USER_ID')."', '".$kegiatan."',GETDATE(),'".$_SERVER['REMOTE_ADDR']."')");
		return $dat;
	}

	function get_observasi($id, $insert, $params){
		if($insert=="") return FALSE;
		if($insert=="KOS"){
			if($params=="")
				$filter = "";
			else
				$filter = " AND A.TEMUAN_KRITERIA = '".$params."'";

				$query = "SELECT B.URAIAN, A.TEMUAN_TEKS, A.TEMUAN_KRITERIA, A.TEMUAN_OBSERVASI FROM T_PEMERIKSAAN_PRODUKSI_CPKB_TEMUAN A LEFT JOIN M_TABEL B ON A.TEMUAN_OBSERVASI = B.KODE WHERE A.PERIKSA_ID = '$id' $filter AND B.JENIS = 'TEMUAN_OBSERVASI_CPKP' ORDER BY A.TEMUAN_OBSERVASI ASC";
		}

		else if($insert=="OT"){
			if($params=="")
				$filter = "";
			else
				$filter = " AND A.TEMUAN_KRITERIA = '".$params."'";

				$query = "SELECT B.URAIAN, A.TEMUAN_TEKS, A.TEMUAN_KRITERIA, A.TEMUAN_OBSERVASI FROM T_PEMERIKSAAN_PRODUKSI_CPOTB_TEMUAN A LEFT JOIN M_TABEL B ON A.TEMUAN_OBSERVASI = B.KODE WHERE A.PERIKSA_ID = '$id' $filter AND B.JENIS = 'TEMUAN_OBSERVASI_CPOTB' ORDER BY A.TEMUAN_OBSERVASI ASC";
		}

		else if($insert=="PK"){
			if($params=="")
				$filter = "";
			else
				$filter = " AND A.TEMUAN_KRITERIA = '".$params."'";

				$query = "SELECT B.URAIAN, A.TEMUAN_TEKS, A.TEMUAN_KRITERIA, A.TEMUAN_OBSERVASI FROM T_PEMERIKSAAN_PRODUKSI_CPPKB_TEMUAN A LEFT JOIN M_TABEL B ON A.TEMUAN_OBSERVASI = B.KODE WHERE A.PERIKSA_ID = '$id' $filter AND B.JENIS = 'TEMUAN_OBSERVASI_CPOTB' ORDER BY A.TEMUAN_OBSERVASI ASC";
		}

		else if($insert=="PR"){
			if($params=="")
				$filter = "";
			else
				$filter = " AND A.TEMUAN_KRITERIA = '".$params."'";

				$query = "SELECT B.URAIAN, A.TEMUAN_TEKS, A.OBSERVASI, A.TEMUAN_KRITERIA, A.TEMUAN_OBSERVASI FROM T_PEMERIKSAAN_PRODUKSI_CPOB_TEMUAN A LEFT JOIN M_TABEL B ON A.TEMUAN_OBSERVASI = B.KODE WHERE A.PERIKSA_ID = '$id' $filter AND B.JENIS = 'TEMUAN_OBSERVASI' ORDER BY A.TEMUAN_OBSERVASI ASC";
		}

		$data = $this->get_result($query);
		if($data){
			foreach($query->result_array() as $row){
				$result[] = $row;
			}
		}else{
			$result = array('');
		}
		return $result;
	}

	function send_mail($to, $nama, $subject, $isi){
		$this->load->library('email');
		$mailconfig = $this->config->config;
		$mailconfig = $mailconfig['mail_config'];
		$this->email->set_newline("\r\n");
		$this->email->from($mailconfig['FROM'], $mailconfig['NAME']);
		$email = str_replace(';', ',', $to);
		$this->email->to($email);
		$bcc = str_replace(';', ',', $mailconfig['BCC']);
		$this->email->bcc($bcc);
		$this->email->subject($subject);
		$body = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"><html xml:lang="en" lang="en"><meta content="text/html; charset=utf-8" http-equiv="Content-type"><head><title> '.$subject.'</title></head><body style="background: #ffffff; color: #000000; font-family: arial; font-size: 13px; margin: 20px; color: #363636;"><table style="margin-bottom: 2px"><tr style="font-size: 13px; color: #0b1d90; font-weight: 700; font-family: arial;"><td width="41" style="margin: 0 0 6px 10px;"><img src="'.base_url().'images/bpom_small.png" style="vertical-align: middle;"/></td><td style="font-family: arial; vertical-align: middle; color: #153f6f;">Sistem Informasi Pelaporan Terpadu (SIPT) <br> Badan Pengawas Obat dan Makanan Republik Indonesia<br/>'.$subject.'<br><span style="color: #858585; font-size: 10px; text-decoration: none;">sipt.pom.go.id</span></td></tr></table><div style="background-color: #dee8f4; margin-top: 4px; margin-bottom: 10px; padding: 5px; font-family: Verdana; font-size: 11px; width:600px; text-align:justify;">'.$isi.'</div><div style="border-top: 1px solid #dcdcdc; clear: both; font-size: 11px; margin-top: 10px; padding-top: 5px;"><div style="font-family: arial; font-size: 10px; color: #a7aaab;">Sistem Informasi Pelaporan Terpadu (SIPT) Badan Pengawas Obat dan Makanan Republik Indonesia</div><a style="text-decoration: none; font-family: arial; font-size: 10px; font-weight: normal;" href="http://www.pom.go.id/">Website Badan Pengawas Obat dan Makanan Republik Indonesia</a> | <a style="text-decoration: none; font-family: arial; font-size: 10px; font-weight: normal;" href="'.site_url().'">Sistem Informasi Pelaporan Terpadu (SIPT) Badan Pengawas Obat dan Makanan Republik Indonesia</a></div></body></html>';
		$this->email->message($body);

		return $this->email->send();
	}

 	function array_in_array($needle, $haystack){
		if(!is_array($needle)) $needle = array($needle);
		foreach($needle as $pin)
			if(in_array($pin, $haystack)) return TRUE;
		return FALSE;
	}

	function remove_element($arr, $val){
		foreach($arr as $key => $value){
			if($arr[$key] == $val){
				unset($arr[$key]);
			}
		}
		return $arr = array_values($arr);
	}

	function hasil_array($array){
		$jml_KRITIKAL = "";
	    $jml_MAYOR = "";
		$jml_minor = "";
		if(array_key_exists('KRITIKAL', $array)){
			$jml_KRITIKAL = $array['KRITIKAL'];
			if(count($jml_KRITIKAL) > 0) $hasil = "Kritikal";
		}else if(array_key_exists('MAYOR', $array)){
			$jml_MAYOR = $array['MAYOR'];
			if(count($jml_MAYOR) > 0) $hasil = "Major";
		}else if(array_key_exists('minor', $array)){
			$jml_minor = $array['minor'];
			if(count($jml_minor) > 0) $hasil = "Minor";
		}else{
			$hasil = "MK";
		}
		return $hasil;
	}

	function _showformperiksa($action, $cari, $subcari){
		$uricari = explode("_",$cari);
		$urisubcari = explode("_",$subcari);
		$status = $this->combobox("SELECT KODE,URAIAN FROM M_TABEL WHERE JENIS = 'STATUS' AND LEN(KODE) > 2 AND URAIAN_DETIL = 'Sarana' ORDER BY KODE ASC","KODE","URAIAN", TRUE);
		$hasil = array("" => "", "TMK"=> "TMK", "MK" => "MK", "KRITIKAL" => "KRITIKAL", "MAJOR" => "MAJOR", "MINOR" => "MINOR", "BAIK SEKALI" => "BAIK SEKALI","BAIK" => "BAIK", "CUKUP" => "CUKUP", "KURANG" => "KURANG", "JELEK" => "JELEK", "TTP" => "TUTUP", "TDP" => "Tidak Dapat Diperiksa", "A" => "Baik Sekali", "B" => "Baik", "C" => "Kurang", "D" => "Jelek");
		$kecuali = $this->remove_element($this->config->item('cfg_unit'), $this->newsession->userdata('SESS_BBPOM_ID'));
		
		$tujuan_pemeriksaan = array("" => "", "Rutin" => "Rutin", "Kasus" => "Kasus", "Mapping" => "Mapping");
		
		$unit = "'".join("','", $kecuali)."'";
		if(in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))){
			$balai = $this->combobox("SELECT BBPOM_ID, REPLACE(REPLACE(NAMA_BBPOM, 'BALAI POM DI ', ''), 'BALAI BESAR POM DI ','') AS NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID NOT IN ('00','99',$unit) ORDER BY 2","BBPOM_ID","NAMA_BBPOM", TRUE);
			$sel_balai = '';
			$klas_komoditi = "'".join("','", $this->config->item('jenis_sarana'))."'";
			$komoditi = $this->combobox("SELECT DISTINCT(KK_ID) AS KK_ID, NAMA_KK FROM M_KLASIFIKASI_KATEGORI
WHERE KK_ID IN (".$klas_komoditi.")","KK_ID","NAMA_KK",TRUE);
		}else if($this->newsession->userdata('SESS_BBPOM_ID') != "00" && !in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))){
			$sel_balai = $this->newsession->userdata('SESS_BBPOM_ID');
			$balai = $this->combobox("SELECT BBPOM_ID, REPLACE(REPLACE(NAMA_BBPOM, 'BALAI POM DI ', ''), 'BALAI BESAR POM DI ','') AS NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID ='".$this->newsession->userdata('SESS_BBPOM_ID')."'","BBPOM_ID","NAMA_BBPOM");
			$klas_komoditi = "'".join("','", $this->config->item('jenis_sarana'))."'";
			$komoditi = $this->combobox("SELECT DISTINCT(KK_ID) AS KK_ID, NAMA_KK FROM M_KLASIFIKASI_KATEGORI
WHERE KK_ID IN (".$klas_komoditi.")","KK_ID","NAMA_KK",TRUE);
		}else{
			$balai = $this->combobox("SELECT BBPOM_ID, REPLACE(REPLACE(NAMA_BBPOM, 'BALAI POM DI ', ''), 'BALAI BESAR POM DI ','') AS NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID NOT IN ('99','00') ORDER BY 2","BBPOM_ID","NAMA_BBPOM", TRUE);
			$sel_balai = '';
			$klas_komoditi = "'".join("','", $this->config->item('jenis_sarana'))."'";
			$komoditi = $this->combobox("SELECT DISTINCT(KK_ID) AS KK_ID, NAMA_KK FROM M_KLASIFIKASI_KATEGORI
WHERE KK_ID IN (".$klas_komoditi.")","KK_ID","NAMA_KK",TRUE);
		}
		$disinput = array("JENISDIS","NAMADIS");
		$jenis = $this->get_jenis_sarana($this->newsession->userdata("SESS_USER_ID"), $disinput);
		$str .= '<form action="'.$action.'" id="fs_periksa">';
		$str .= '<table class="form_temuan" style="width:100%">';
		$str .= '<tr><td class="temuan_left">Nomor Surat Tugas</td><td class="temuan_right"><input type="text" name="no_surat" class="stext" id="no_surat" title="Nomor Surat Tugas" value="'.$uricari[0].'" /></td><td class="temuan_pemisah">&nbsp;</td><td class="temuan_left">NIP</td><td class="temuan_right"><input type="text" name="petugas" class="stext" id="petugas" title="Nama Petugas" value="'.$urisubcari[0].'" /></td></tr>';
		$str .= '<tr><td class="temuan_left">Nama Sarana</td><td class="temuan_right"><input type="text" name="nama_sarana" class="stext" id="nama_sarana" title="Nama Sarana" value="'.$uricari[1].'" url="'.site_url().'/autocompletes/autocomplete/get_carisarana" /></td><td class="temuan_pemisah">&nbsp;</td><td class="temuan_left"> Balai Besar / Balai POM</td><td class="temuan_right">';
		$str .= form_dropdown('bbpom',$balai,($urisubcari[1])?$urisubcari[1]:$selbalai,'class="stext" id="bbpomid" title="Asal Balai Besar / Balai POM"');
		$str .= '</td></tr>';
		if(strlen($uricari[2]) != 0){
			if($uricari[2] != "ALL"){
				$awal = explode("-",$uricari[2]);
				$awal = $awal[0]."/".$awal[1]."/".$awal[2];
			}else{
				$awal = "ALL";
			}
		}else{
			$awal = "";
		}

		if(strlen($uricari[3]) != 0){
			if($uricari[3] != "ALL"){
				$akhir = explode("-",$uricari[3]);
				$akhir = $akhir[0]."/".$akhir[1]."/".$akhir[2];
			}else{
				$akhir = "ALL";
			}
		}else{
			$akhir = "";
		}
		$str .= '<tr><td class="temuan_left">Tanggal Pemeriksaan</td><td class="temuan_right"><input type="text" class="sdate" id="awal" title="Periode Tanggal Pemeriksaan Awal" name="awal" value="'.$awal.'" />&nbsp; sampai dengan &nbsp;<input type="text" class="sdate" name="akhir" id="akhir" title="Periode Tanggal Pemeriksaan Akhir" value="'.$akhir.'" /></td><td class="temuan_pemisah">&nbsp;</td><td class="temuan_left">Hasil</td><td class="temuan_right">';
		$str .= form_dropdown('hasil',$hasil,($urisubcari[2])?$urisubcari[2]:'','class="stext" id="hasil" title="Hasil Pemeriksaan"');
		$str .= '</td></tr>';
		$str .= '<tr><td class="temuan_left">Status Pemeriksaan</td><td class="temuan_right">';
		$str .= form_dropdown('status',$status,($uricari[4])?$uricari[4]:'','class="stext" id="status" title="Status Pemeriksaan"');
		$str .= '</td><td class="temuan_pemisah">&nbsp;</td><td class="temuan_left">Jenis Sarana</td><td class="temuan_right">';
		$str .= form_dropdown('jenis',$jenis,($urisubcari[3])?$urisubcari[3]:'','class="stext" id="jenis" title="Jenis Sarana"',$disinput);
		$str .= '</td></tr>';
		$str .= '<tr><td class="temuan_left">Tujuan Pemeriksaan</td><td class="temuan_right">';
		
		$str .= form_dropdown('tujuan_pemeriksaan',$tujuan_pemeriksaan,($uricari[5])?$uricari[5]:'','class="stext" id="tujuan_pemeriksaan" title="Tujuan Pemeriksaan"');
		
		$str .= '</td><td class="temuan_pemisah">&nbsp;</td><td class="temuan_left">Komoditi</td><td class="temuan_right">';
		$str .= form_dropdown('komoditi',$komoditi,($urisubcari[4])?$urisubcari[4]:'','class="stext" id="komoditi" title="Komoditi"');
		$str .= '</td></tr>';
		$str .= '<tr><td colspan="5" style="padding:5px;"><a href="#" class="button reload" onclick="search_sarana(\'#fs_periksa\',\'#no_surat\',\'#petugas\', \'#nama_sarana\',\'#bbpomid\',\'#awal\',\'#akhir\',\'#hasil\',\'#status\',\'#jenis\',\'#komoditi\',\'#tujuan_pemeriksaan\'); return false;"><span><span class="icon"></span>&nbsp; Cari &nbsp;</span></a></td></tr>';
		$str .= '</table>';
		$str .= '</form>';
		return $str;
	}

	function _showformproduk($action, $cari, $subcari){
		$uricari = explode("_",$cari);
		$urisubcari = explode("_",$subcari);
		$arrkategori = array('' => '',
							 'TIE' => 'Tidak Izin Edar (TIE)',
							 'BKO' => 'Bahan Kimia Obat (BKO)',
							 'Kadaluarsa' => 'Kadaluarsa',
							 'Penandaan' => 'TMK Penandaan',
							 'Label' => 'TMK Label',
							 'Rusak' => 'Rusak',
							 'Dilarang' => 'Dilarang',
							 'Palsu' => 'Obat Palsu',
							 'Keras' => 'Obat Keras',
							 'Daftar' => 'Obat Daftar G');

		$kecuali = $this->remove_element($this->config->item('cfg_unit'), $this->newsession->userdata('SESS_BBPOM_ID'));
		$unit = "'".join("','", $kecuali)."'";
		if(in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))){
			$balai = $this->combobox("SELECT BBPOM_ID, REPLACE(REPLACE(NAMA_BBPOM, 'BALAI POM DI ', ''), 'BALAI BESAR POM DI ','') AS NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID NOT IN ('00','99',$unit) ORDER BY 2","BBPOM_ID","NAMA_BBPOM", TRUE);
			$sel_balai = '';
			$klas_komoditi = "'".join("','", $this->config->item('jenis_sarana'))."'";
			$komoditi = $this->combobox("SELECT DISTINCT(KK_ID) AS KK_ID, NAMA_KK FROM M_KLASIFIKASI_KATEGORI
WHERE KK_ID IN (".$klas_komoditi.")","KK_ID","NAMA_KK",TRUE);
		}else if($this->newsession->userdata('SESS_BBPOM_ID') != "00" && !in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))){
			$sel_balai = $this->newsession->userdata('SESS_BBPOM_ID');
			$balai = $this->combobox("SELECT BBPOM_ID, REPLACE(REPLACE(NAMA_BBPOM, 'BALAI POM DI ', ''), 'BALAI BESAR POM DI ','') AS NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID ='".$this->newsession->userdata('SESS_BBPOM_ID')."'","BBPOM_ID","NAMA_BBPOM");
			$klas_komoditi = "'".join("','", $this->config->item('jenis_sarana'))."'";
			$komoditi = $this->combobox("SELECT DISTINCT(KK_ID) AS KK_ID, NAMA_KK FROM M_KLASIFIKASI_KATEGORI
WHERE KK_ID IN (".$klas_komoditi.")","KK_ID","NAMA_KK",TRUE);
		}else{
			$balai = $this->combobox("SELECT BBPOM_ID, REPLACE(REPLACE(NAMA_BBPOM, 'BALAI POM DI ', ''), 'BALAI BESAR POM DI ','') AS NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID NOT IN ('99','00') ORDER BY 2","BBPOM_ID","NAMA_BBPOM", TRUE);
			$sel_balai = '';
			$klas_komoditi = "'".join("','", $this->config->item('jenis_sarana'))."'";
			$komoditi = $this->combobox("SELECT DISTINCT(KK_ID) AS KK_ID, NAMA_KK FROM M_KLASIFIKASI_KATEGORI
WHERE KK_ID IN (".$klas_komoditi.")","KK_ID","NAMA_KK",TRUE);
		}

		$str .= '<form action="'.$action.'" id="fs_produk">';
		$str .= '<table class="form_temuan" style="width:100%">';
		$str .= '<tr><td class="temuan_left">Nama Produk</td><td class="temuan_right"><input type="text" class="stext" id="nama_produk" title="Nama Produk" value="'.$uricari[0].'" /></td><td class="temuan_pemisah">&nbsp;</td><td class="temuan_left">Perusahaan</td><td class="temuan_right"><input typ="text" id="nama_perusahaan" class="stext" title="Nama Perusahaan" value="'.$uricari[1].'"></td></tr>';
		$str .= '<tr><td class="temuan_left">Asal Balai Besar / Balai POM</td><td class="temuan_right">';
		$str .= form_dropdown('bbpom',$balai,($uricari[2])?$uricari[2]:$selbalai,'class="stext" id="bbpomid" title="Asal Balai Besar / Balai POM"');
		$str .= '</td><td class="temuan_pemisah">&nbsp;</td><td class="temuan_left">Kategori Temuan</td><td class="temuan_right">';
		$str .= form_dropdown('kategori',$arrkategori,($uricari[3])?$uricari[3]:'','class="stext" id="kategori" title="Kategori temuan produk"');
		$str .= '</td></tr>';
		if(strlen($urisubcari[0]) != 0){
			if($urisubcari[0] != "ALL"){
				$awal = explode("-",$urisubcari[0]);
				$awal = $awal[0]."/".$awal[1]."/".$awal[2];
			}else{
				$awal = "ALL";
			}
		}else{
			$awal = "";
		}

		if(strlen($urisubcari[1]) != 0){
			if($urisubcari[1] != "ALL"){
				$akhir = explode("-",$urisubcari[1]);
				$akhir = $akhir[0]."/".$akhir[1]."/".$akhir[2];
			}else{
				$akhir = "ALL";
			}
		}else{
			$akhir = "";
		}

		$str .= '<tr><td class="temuan_left">Tanggal Pemeriksaan</td><td class="temuan_right"><input type="text" class="sdate" id="awal" title="Periode Tanggal Pemeriksaan Awal" name="awal" value="'.$awal.'" />&nbsp; sampai dengan &nbsp;<input type="text" class="sdate" name="akhir" id="akhir" title="Periode Tanggal Pemeriksaan Akhir" value="'.$akhir.'" /></td><td class="temuan_pemisah">&nbsp;</td><td class="temuan_left">Komoditi</td><td class="temuan_right">';
		$str .= form_dropdown('komoditi',$komoditi,($urisubcari[2])?$urisubcari[2]:'','class="stext" id="komoditi" title="Hasil Pemeriksaan"');
		$str .= '</td></tr>';

		$str .= '<tr><td class="temuan_left">Nomor Registrasi / NIE</td><td class="temuan_right"><input type="text" class="stext" id="nomor_registrasi_prod" title="Nomor Registrasi" value="'.$urisubcari[3].'" /></td><td class="temuan_pemisah">&nbsp;</td><td class="temuan_left">No. Bets</td><td class="temuan_right"><input type="text" class="stext" id="no_bets_prod" title="Nomor Bets Produk" value="'.$urisubcari[4].'" /></td></tr>';

		$str .= '<tr><td colspan="5" style="padding:5px;"><a href="#" class="button reload" onclick="search_produk(\'#fs_produk\',\'#nama_produk\',\'#nama_perusahaan\',\'#bbpomid\',\'#kategori\',\'#awal\',\'#akhir\',\'#komoditi\',\'#nomor_registrasi_prod\',\'#no_bets_prod\'); return false;"><span><span class="icon"></span>&nbsp; Cari &nbsp;</span></a></td></tr>';
		$str .= '</table>';
		$str .= '</form>';
		return $str;
	}

	function _showformsampling($action, $cari, $subcari){
		$uricari = explode("_",$cari);
		$urisubcari = explode("_",$subcari);
		$status = $this->combobox("SELECT KODE,URAIAN FROM M_TABEL WHERE JENIS = 'STATUS' AND URAIAN_DETIL = 'Sampling' ORDER BY 2 ASC","KODE","URAIAN", TRUE);
		$kecuali = $this->remove_element($this->config->item('cfg_unit'), $this->newsession->userdata('SESS_BBPOM_ID'));
		$unit = "'".join("','", $kecuali)."'";
		if(in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))){
			$balai = $this->combobox("SELECT BBPOM_ID, REPLACE(REPLACE(NAMA_BBPOM, 'BALAI POM DI ', ''), 'BALAI BESAR POM DI ','') AS NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID NOT IN ('00','99',$unit) ORDER BY 2","BBPOM_ID","NAMA_BBPOM", TRUE);
			$sel_balai = '';
			$klas_komoditi = "'".join("','", $this->config->item('jenis_sarana'))."'";
			$tmp = "";
			foreach($this->newsession->userdata('SESS_KLASIFIKASI_ID') as $komoditi){
				$tmp  .= "'".substr($komoditi,-2). "',";
			}
			$kk = substr($tmp,0,-1);
			$komoditi = $this->combobox("SELECT KLASIFIKASI_ID, KLASIFIKASI FROM M_GOLONGAN WHERE LEN(KLASIFIKASI_ID) = 2 AND KLASIFIKASI_ID IN ($kk) AND KLASIFIKASI_ID NOT IN ('05','06')","KLASIFIKASI_ID","KLASIFIKASI",TRUE);
		}else if($this->newsession->userdata('SESS_BBPOM_ID') != "00" && !in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))){
			$sel_balai = $this->newsession->userdata('SESS_BBPOM_ID');
			$balai = $this->combobox("SELECT BBPOM_ID, REPLACE(REPLACE(NAMA_BBPOM, 'BALAI POM DI ', ''), 'BALAI BESAR POM DI ','') AS NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID ='".$this->newsession->userdata('SESS_BBPOM_ID')."'","BBPOM_ID","NAMA_BBPOM");
			$klas_komoditi = "'".join("','", $this->config->item('jenis_sarana'))."'";
			$komoditi = $this->combobox("SELECT KLASIFIKASI_ID, KLASIFIKASI FROM M_GOLONGAN WHERE LEN(KLASIFIKASI_ID) = 2  AND KLASIFIKASI_ID NOT IN ('05','06')","KLASIFIKASI_ID","KLASIFIKASI",TRUE);
		}else{
			$balai = $this->combobox("SELECT BBPOM_ID, REPLACE(REPLACE(NAMA_BBPOM, 'BALAI POM DI ', ''), 'BALAI BESAR POM DI ','') AS NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID NOT IN ('99','00') ORDER BY 2","BBPOM_ID","NAMA_BBPOM", TRUE);
			$sel_balai = '';
			$klas_komoditi = "'".join("','", $this->config->item('jenis_sarana'))."'";
			$komoditi = $this->combobox("SELECT KLASIFIKASI_ID, KLASIFIKASI FROM M_GOLONGAN WHERE LEN(KLASIFIKASI_ID) = 2  AND KLASIFIKASI_ID NOT IN ('05','06')","KLASIFIKASI_ID","KLASIFIKASI",TRUE);
		}
		$asal_sampel = $this->combobox("SELECT KODE, URAIAN FROM M_TABEL WHERE JENIS = 'ASAL_SAMPLING'","KODE","URAIAN", TRUE);
		$bulan = array('' => '','Januari' => 'Januari','Februari' => 'Febuari','Maret' => 'Maret','April' => 'April','Mei' => 'Mei','Juni' => 'Juni','Juli' => 'Juli','Agustus' => 'Agustus','September' => 'September','Oktober' => 'Oktober','November' => 'November','Desember' => 'Desember');
		$jenis_uji = array('' => '','Mikro' => 'Uji Mikro','Kimia' => 'Uji Kimia');
		$str .= '<form action="'.$action.'" id="fs_sampling">';
		$str .= '<table class="form_temuan" style="width:100%">';
		$str .= '<tr><td class="temuan_left">Nama Sampel</td><td class="temuan_right"><input type="text" class="stext" id="nama_sampel" title="Nama Sampel" value="'.$uricari[0].'" /></td><td class="temuan_pemisah">&nbsp;</td><td class="temuan_left">Kode Sampel</td><td class="temuan_right"><input typ="text" id="kode_sampel" class="stext" title="Kode Sampel" value="'.$urisubcari[0].'"></td></tr>';
		$str .= '<tr><td class="temuan_left">Asal Sampel</td><td class="temuan_right">';
		$str .= form_dropdown('asal_sampel',$asal_sampel,($uricari[1])?$uricari[1]:'','class="stext" id="asal_sampel" title="Asal Sampel"');
		$str .= '</td><td class="temuan_pemisah">&nbsp;</td><td class="temuan_left">Balai Besar / Balai POM</td><td class="temuan_right">';
		$str .= form_dropdown('bbpom',$balai,($urisubcari[1])?$urisubcari[1]:$selbalai,'class="stext" id="bbpomid" title="Asal Balai Besar / Balai POM"');
		$str .= '</td></tr>';
		$str .= '<tr><td class="temuan_left">Komoditi</td><td class="temuan_right">';
		$str .= form_dropdown('komoditi',$komoditi,($uricari[2])?$uricari[2]:'','class="stext" id="komoditi" title="Komoditi"');
		$str .= '</td><td class="temuan_pemisah">&nbsp;</td><td class="temuan_left">Jenis Uji</td><td class="temuan_right">';
		$str .= form_dropdown('jenisuji',$jenis_uji,($urisubcari[2])?$urisubcari[2]:'','class="stext" id="jenis_uji" title="Jenis Uji"');
		$str .= '</td></tr>';
		if(strlen($uricari[3]) != 0){
			if($uricari[3] != "ALL"){
				$awal = explode("-",$uricari[3]);
				$awal = $awal[0]."/".$awal[1]."/".$awal[2];
			}else{
				$awal = "ALL";
			}
		}else{
			$awal = "";
		}
		if(strlen($uricari[4]) != 0){
			if($uricari[4] != "ALL"){
				$akhir = explode("-",$uricari[4]);
				$akhir = $akhir[0]."/".$akhir[1]."/".$akhir[2];
			}else{
				$akhir = "ALL";
			}
		}else{
			$akhir = "";
		}
		$str .= '<tr><td class="temuan_left">Tanggal Sampling</td><td class="temuan_right"><input type="text" class="sdate" id="awal" title="Periode awal tanggal sampling" name="awal" value="'.$awal.'" />&nbsp; sampai dengan &nbsp;<input type="text" class="sdate" name="akhir" id="akhir" title="Periode tanggal akhir sampling" value="'.$akhir.'" /></td><td class="temuan_pemisah">&nbsp;</td><td class="temuan_left">Bulan Anggaran</td><td class="temuan_right">';
		$str .= form_dropdown('anggaran',$bulan,($urisubcari[3])?$urisubcari[3]:'','class="stext" id="anggaran" title="Bulan anggaran"');
		$str .= '</td></tr>';

		$str .= '<tr><td class="temuan_left">Status</td><td class="temuan_right">';
		$str .= form_dropdown('status',$status,($uricari[5])?$uricari[5]:'','class="stext" id="status" title="Status Sampling"');
		$str .= '</td><td class="temuan_pemisah">&nbsp;</td><td class="temuan_left">Nomor SPU</td><td class="temuan_right">';
		$str .= '<input type="text" class="stext" id="spuid" title="Nomor Surat Perintah Uji" name="spuid" value="'.$urisubcari[4].'" />';
		$str .= '</td></tr>';

		$str .= '<tr><td class="temuan_left">No. Bets</td><td class="temuan_right">';
		$str .= '<input type="text" class="stext" id="nobets" title="No. Bets" name="nobets" value="'.$uricari[6].'" />';
		$str .= '</td><td class="temuan_pemisah">&nbsp;</td><td class="temuan_left">&nbsp;</td><td class="temuan_right">&nbsp;</td></tr>';

		$str .= '<tr><td colspan="5" style="padding:5px;"><a href="#" class="button reload" onclick="search_sampel(\'#fs_sampling\',\'#nama_sampel\',\'#asal_sampel\',\'#komoditi\',\'#awal\',\'#akhir\',\'#status\',\'#nobets\', \'#kode_sampel\',\'#bbpomid\',\'#jenis_uji\',\'#anggaran\',\'#spuid\'); return false;"><span><span class="icon"></span>&nbsp; Cari &nbsp;</span></a></td></tr>';
		$str .= '</table>';
		$str .= '</form>';
		return $str;
	}

	function _showformuji($action, $cari, $subcari){
		$uricari = explode("_",$cari);
		$urisubcari = explode("_",$subcari);
		$kecuali = $this->remove_element($this->config->item('cfg_unit'), $this->newsession->userdata('SESS_BBPOM_ID'));
		$unit = "'".join("','", $kecuali)."'";
		if(in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))){
			$balai = $this->combobox("SELECT BBPOM_ID, REPLACE(REPLACE(NAMA_BBPOM, 'BALAI POM DI ', ''), 'BALAI BESAR POM DI ','') AS NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID NOT IN ('00','99',$unit) ORDER BY 2","BBPOM_ID","NAMA_BBPOM", TRUE);
			$sel_balai = '';
			$klas_komoditi = "'".join("','", $this->config->item('jenis_sarana'))."'";
			$tmp = "";
			foreach($this->newsession->userdata('SESS_KLASIFIKASI_ID') as $komoditi){
				$tmp  .= "'".substr($komoditi,-2). "',";
			}
			$kk = substr($tmp,0,-1);
			$komoditi = $this->combobox("SELECT KLASIFIKASI_ID, KLASIFIKASI FROM M_GOLONGAN WHERE LEN(KLASIFIKASI_ID) = 2 AND KLASIFIKASI_ID IN ($kk) AND KLASIFIKASI_ID NOT IN ('05','06')","KLASIFIKASI_ID","KLASIFIKASI",TRUE);
		}else if($this->newsession->userdata('SESS_BBPOM_ID') != "00" && !in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))){
			$sel_balai = $this->newsession->userdata('SESS_BBPOM_ID');
			$balai = $this->combobox("SELECT BBPOM_ID, REPLACE(REPLACE(NAMA_BBPOM, 'BALAI POM DI ', ''), 'BALAI BESAR POM DI ','') AS NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID ='".$this->newsession->userdata('SESS_BBPOM_ID')."'","BBPOM_ID","NAMA_BBPOM");
			$klas_komoditi = "'".join("','", $this->config->item('jenis_sarana'))."'";
			$komoditi = $this->combobox("SELECT KLASIFIKASI_ID, KLASIFIKASI FROM M_GOLONGAN WHERE LEN(KLASIFIKASI_ID) = 2  AND KLASIFIKASI_ID NOT IN ('05','06')","KLASIFIKASI_ID","KLASIFIKASI",TRUE);
		}else{
			$balai = $this->combobox("SELECT BBPOM_ID, REPLACE(REPLACE(NAMA_BBPOM, 'BALAI POM DI ', ''), 'BALAI BESAR POM DI ','') AS NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID NOT IN ('99','00') ORDER BY 2","BBPOM_ID","NAMA_BBPOM", TRUE);
			$sel_balai = '';
			$klas_komoditi = "'".join("','", $this->config->item('jenis_sarana'))."'";
			$komoditi = $this->combobox("SELECT KLASIFIKASI_ID, KLASIFIKASI FROM M_GOLONGAN WHERE LEN(KLASIFIKASI_ID) = 2  AND KLASIFIKASI_ID NOT IN ('05','06')","KLASIFIKASI_ID","KLASIFIKASI",TRUE);
		}
		$hasiluji = $this->combobox("SELECT KODE, URAIAN FROM M_TABEL WHERE JENIS = 'HASIL' AND KODE IN ('MS','TMS','HPST')","KODE","URAIAN",TRUE);
		$jenis_uji = array('' => '','1' => 'Terkirim','0' => 'Di Kepala Balai');
		if(strlen($urisubcari[0]) != 0){
			if($urisubcari[0] != "ALL"){
				$awal = explode("-",$urisubcari[0]);
				$awal = $awal[0]."/".$awal[1]."/".$awal[2];
			}else{
				$awal = "ALL";
			}
		}else{
			$awal = "";
		}
		if(strlen($urisubcari[1]) != 0){
			if($urisubcari[1] != "ALL"){
				$akhir = explode("-",$urisubcari[1]);
				$akhir = $akhir[0]."/".$akhir[1]."/".$akhir[2];
			}else{
				$akhir = "ALL";
			}
		}else{
			$akhir = "";
		}
		$str .= '<form action="'.$action.'" id="fs_hasiluji">';
		$str .= '<table class="form_temuan" style="width:100%">';
		$str .= '<tr><td class="temuan_left">Balai Besar / Balai POM</td><td class="temuan_right">';
		$str .= form_dropdown('bbpom',$balai,($uricari[0])?$uricari[0]:$selbalai,'class="stext" id="bbpomid" title="Asal Balai Besar / Balai POM"');
		$str .= '</td><td class="temuan_pemisah">&nbsp;</td><td class="temuan_left">Periode Sampling</td><td class="temuan_right">';
		$str .= '<input type="text" class="sdate" id="awal" title="Periode awal tanggal sampling" name="awal" value="'.$awal.'" />&nbsp; sampai dengan &nbsp;<input type="text" class="sdate" name="akhir" id="akhir" title="Periode tanggal akhir sampling" value="'.$akhir.'" /></td></tr>';
		$str .= '<tr><td class="temuan_left">Kode Sampel</td><td class="temuan_right"><input typ="text" id="kode_sampel" class="stext" title="Kode Sampel" value="'.$uricari[1].'">';
		$str .= '</td><td class="temuan_pemisah">&nbsp;</td><td class="temuan_left">Nama Sampel</td><td class="temuan_right"><input type="text" class="stext" id="nama_sampel" title="Nama Sampel" value="'.$urisubcari[2].'" /></td></tr>';
		$str .= '<tr><td class="temuan_left">Komoditi</td><td class="temuan_right">';
		$str .= form_dropdown('komoditi',$komoditi,($uricari[2])?$uricari[2]:'','class="stext" id="komoditi" title="Komoditi"');
		$str .= '</td><td class="temuan_pemisah">&nbsp;</td><td class="temuan_left">Hasil Pengujian</td><td class="temuan_right">';
		$str .= form_dropdown('hasil',$hasiluji,($urisubcari[3])?$urisubcari[3]:'','class="stext" id="hasil_uji" title="Hasil Pengujian"');
		$str .= '</td></tr>';

		$str .= '<tr><td class="temuan_left">No Bets</td><td class="temuan_right">';
		$str .= '<input type="text" class="stext" id="no_bets" title="Nomor Bets" value="'.$uricari[3].'" />';
		$str .= '</td><td class="temuan_pemisah">&nbsp;</td><td class="temuan_left">&nbsp;</td><td class="temuan_right"></td></tr>';

		$str .= '<tr><td colspan="5" style="padding:5px;"><a href="#" class="button reload" onclick="serach_hasiluji(\'#fs_hasiluji\',\'#bbpomid\',\'#kode_sampel\',\'#komoditi\',\'#no_bets\',\'#awal\',\'#akhir\',\'#nama_sampel\',\'#hasil_uji\'); return false;"><span><span class="icon"></span>&nbsp; Cari &nbsp;</span></a></td></tr>';
		$str .= '</table>';
		$str .= '</form>';
		return $str;
	}

	function _showformspu($action, $cari, $subcari){
		$uricari = explode("_",$cari);
		$urisubcari = explode("_",$subcari);
		$kecuali = $this->remove_element($this->config->item('cfg_unit'), $this->newsession->userdata('SESS_BBPOM_ID'));
		$unit = "'".join("','", $kecuali)."'";
		if(in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))){
			$balai = $this->combobox("SELECT BBPOM_ID, REPLACE(REPLACE(NAMA_BBPOM, 'BALAI POM DI ', ''), 'BALAI BESAR POM DI ','') AS NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID NOT IN ('00','99',$unit) ORDER BY 2","BBPOM_ID","NAMA_BBPOM", TRUE);
			$sel_balai = '';
			$klas_komoditi = "'".join("','", $this->config->item('jenis_sarana'))."'";
			$tmp = "";
			foreach($this->newsession->userdata('SESS_KLASIFIKASI_ID') as $komoditi){
				$tmp  .= "'".substr($komoditi,-2). "',";
			}
			$kk = substr($tmp,0,-1);
			$komoditi = $this->combobox("SELECT KLASIFIKASI_ID, KLASIFIKASI FROM M_GOLONGAN WHERE LEN(KLASIFIKASI_ID) = 2 AND KLASIFIKASI_ID IN ($kk) AND KLASIFIKASI_ID NOT IN ('05','06')","KLASIFIKASI_ID","KLASIFIKASI",TRUE);
		}else if($this->newsession->userdata('SESS_BBPOM_ID') != "00" && !in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))){
			$sel_balai = $this->newsession->userdata('SESS_BBPOM_ID');
			$balai = $this->combobox("SELECT BBPOM_ID, REPLACE(REPLACE(NAMA_BBPOM, 'BALAI POM DI ', ''), 'BALAI BESAR POM DI ','') AS NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID ='".$this->newsession->userdata('SESS_BBPOM_ID')."'","BBPOM_ID","NAMA_BBPOM");
			$klas_komoditi = "'".join("','", $this->config->item('jenis_sarana'))."'";
			$komoditi = $this->combobox("SELECT KLASIFIKASI_ID, KLASIFIKASI FROM M_GOLONGAN WHERE LEN(KLASIFIKASI_ID) = 2  AND KLASIFIKASI_ID NOT IN ('05','06')","KLASIFIKASI_ID","KLASIFIKASI",TRUE);
		}else{
			$balai = $this->combobox("SELECT BBPOM_ID, REPLACE(REPLACE(NAMA_BBPOM, 'BALAI POM DI ', ''), 'BALAI BESAR POM DI ','') AS NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID NOT IN ('99','00') ORDER BY 2","BBPOM_ID","NAMA_BBPOM", TRUE);
			$sel_balai = '';
			$klas_komoditi = "'".join("','", $this->config->item('jenis_sarana'))."'";
			$komoditi = $this->combobox("SELECT KLASIFIKASI_ID, KLASIFIKASI FROM M_GOLONGAN WHERE LEN(KLASIFIKASI_ID) = 2  AND KLASIFIKASI_ID NOT IN ('05','06')","KLASIFIKASI_ID","KLASIFIKASI",TRUE);
		}
		if(strlen($urisubcari[0]) != 0){
			if($urisubcari[0] != "ALL"){
				$awal = explode("-",$urisubcari[0]);
				$awal = $awal[0]."/".$awal[1]."/".$awal[2];
			}else{
				$awal = "ALL";
			}
		}else{
			$awal = "";
		}
		if(strlen($urisubcari[1]) != 0){
			if($urisubcari[1] != "ALL"){
				$akhir = explode("-",$urisubcari[1]);
				$akhir = $akhir[0]."/".$akhir[1]."/".$akhir[2];
			}else{
				$akhir = "ALL";
			}
		}else{
			$akhir = "";
		}
		$str .= '<form action="'.$action.'" id="fs_spu">';
		$str .= '<table class="form_temuan" style="width:100%">';
		$str .= '<tr><td class="temuan_left">Balai Besar / Balai POM</td><td class="temuan_right">';
		$str .= form_dropdown('bbpom',$balai,($uricari[0])?$uricari[0]:$selbalai,'class="stext" id="bbpomid" title="Asal Balai Besar / Balai POM"');
		$str .= '</td><td class="temuan_pemisah">&nbsp;</td><td class="temuan_left">Tanggal Surat Permintaan Uji</td><td class="temuan_right">';
		$str .= '<input type="text" class="sdate" id="awal" title="Periode awal tanggal spu" name="awal" value="'.$awal.'" />&nbsp; sampai dengan &nbsp;<input type="text" class="sdate" name="akhir" id="akhir" title="Periode tanggal akhir spu" value="'.$akhir.'" /></td></tr>';
		$str .= '<tr><td class="temuan_left">Komoditi</td><td class="temuan_right">';
		$str .= form_dropdown('komoditi',$komoditi,($uricari[1])?$uricari[1]:'','class="stext" id="komoditi" title="Komoditi"');
		$str .= '</td><td class="temuan_pemisah">&nbsp;</td><td class="temuan_left">Nomor Surat Permintaan Uji</td><td class="temuan_right"><input type="text" class="stext" id="no_spu" title="Nomor SPU" value="'.$urisubcari[2].'" /></td></tr>';

		$str .= '<tr><td colspan="5" style="padding:5px;"><a href="#" class="button reload" onclick="serach_hasilspu(\'#fs_spu\',\'#bbpomid\',\'#komoditi\',\'#awal\',\'#akhir\',\'#no_spu\'); return false;"><span><span class="icon"></span>&nbsp; Cari &nbsp;</span></a></td></tr>';
		$str .= '</table>';
		$str .= '</form>';
		return $str;
	}

	function _showformspk($action, $cari, $subcari){
		$uricari = explode("_",$cari);
		$urisubcari = explode("_",$subcari);
		$kecuali = $this->remove_element($this->config->item('cfg_unit'), $this->newsession->userdata('SESS_BBPOM_ID'));
		$unit = "'".join("','", $kecuali)."'";
		if(in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))){
			$balai = $this->combobox("SELECT BBPOM_ID, REPLACE(REPLACE(NAMA_BBPOM, 'BALAI POM DI ', ''), 'BALAI BESAR POM DI ','') AS NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID NOT IN ('00','99',$unit) ORDER BY 2","BBPOM_ID","NAMA_BBPOM", TRUE);
			$sel_balai = '';
			$klas_komoditi = "'".join("','", $this->config->item('jenis_sarana'))."'";
			$tmp = "";
			foreach($this->newsession->userdata('SESS_KLASIFIKASI_ID') as $komoditi){
				$tmp  .= "'".substr($komoditi,-2). "',";
			}
			$kk = substr($tmp,0,-1);
			$komoditi = $this->combobox("SELECT KLASIFIKASI_ID, KLASIFIKASI FROM M_GOLONGAN WHERE LEN(KLASIFIKASI_ID) = 2 AND KLASIFIKASI_ID IN ($kk) AND KLASIFIKASI_ID NOT IN ('05','06')","KLASIFIKASI_ID","KLASIFIKASI",TRUE);
		}else if($this->newsession->userdata('SESS_BBPOM_ID') != "00" && !in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))){
			$sel_balai = $this->newsession->userdata('SESS_BBPOM_ID');
			$balai = $this->combobox("SELECT BBPOM_ID, REPLACE(REPLACE(NAMA_BBPOM, 'BALAI POM DI ', ''), 'BALAI BESAR POM DI ','') AS NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID ='".$this->newsession->userdata('SESS_BBPOM_ID')."'","BBPOM_ID","NAMA_BBPOM");
			$klas_komoditi = "'".join("','", $this->config->item('jenis_sarana'))."'";
			$komoditi = $this->combobox("SELECT KLASIFIKASI_ID, KLASIFIKASI FROM M_GOLONGAN WHERE LEN(KLASIFIKASI_ID) = 2  AND KLASIFIKASI_ID NOT IN ('05','06')","KLASIFIKASI_ID","KLASIFIKASI",TRUE);
		}else{
			$balai = $this->combobox("SELECT BBPOM_ID, REPLACE(REPLACE(NAMA_BBPOM, 'BALAI POM DI ', ''), 'BALAI BESAR POM DI ','') AS NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID NOT IN ('99','00') ORDER BY 2","BBPOM_ID","NAMA_BBPOM", TRUE);
			$sel_balai = '';
			$klas_komoditi = "'".join("','", $this->config->item('jenis_sarana'))."'";
			$komoditi = $this->combobox("SELECT KLASIFIKASI_ID, KLASIFIKASI FROM M_GOLONGAN WHERE LEN(KLASIFIKASI_ID) = 2  AND KLASIFIKASI_ID NOT IN ('05','06')","KLASIFIKASI_ID","KLASIFIKASI",TRUE);
		}
		if(strlen($urisubcari[0]) != 0){
			if($urisubcari[0] != "ALL"){
				$awal = explode("-",$urisubcari[0]);
				$awal = $awal[0]."/".$awal[1]."/".$awal[2];
			}else{
				$awal = "ALL";
			}
		}else{
			$awal = "";
		}
		if(strlen($urisubcari[1]) != 0){
			if($urisubcari[1] != "ALL"){
				$akhir = explode("-",$urisubcari[1]);
				$akhir = $akhir[0]."/".$akhir[1]."/".$akhir[2];
			}else{
				$akhir = "ALL";
			}
		}else{
			$akhir = "";
		}
		$str .= '<form action="'.$action.'" id="fs_spk">';
		$str .= '<table class="form_temuan" style="width:100%">';
		$str .= '<tr><td class="temuan_left">Balai Besar / Balai POM</td><td class="temuan_right">';
		$str .= form_dropdown('bbpom',$balai,($uricari[0])?$uricari[0]:$selbalai,'class="stext" id="bbpomid" title="Asal Balai Besar / Balai POM"');
		$str .= '</td><td class="temuan_pemisah">&nbsp;</td><td class="temuan_left">Tanggal Surat Perintah Kerja</td><td class="temuan_right">';
		$str .= '<input type="text" class="sdate" id="awal" title="Periode awal tanggal spu" name="awal" value="'.$awal.'" />&nbsp; sampai dengan &nbsp;<input type="text" class="sdate" name="akhir" id="akhir" title="Periode tanggal akhir spu" value="'.$akhir.'" /></td></tr>';
		$str .= '<tr><td class="temuan_left">Komoditi</td><td class="temuan_right">';
		$str .= form_dropdown('komoditi',$komoditi,($uricari[1])?$uricari[1]:'','class="stext" id="komoditi" title="Komoditi"');
		$str .= '</td><td class="temuan_pemisah">&nbsp;</td><td class="temuan_left">Nomor Surat Perintah Kerja</td><td class="temuan_right"><input type="text" class="stext" id="no_spk" title="Nomor SPK" value="'.$urisubcari[2].'" /></td></tr>';
		$str .= '<tr><td class="temuan_left">Kode Sampel</td><td class="temuan_right">';
		$str .= '<input type="text" class="stext" id="kode_sampel" title="Kode Sampel" name="kode_sampel" value="'.$uricari[2].'" />';
		$str .= '</td><td class="temuan_pemisah">&nbsp;</td><td class="temuan_left">Nomor Surat Permintaan Uji</td><td class="temuan_right"><input type="text" class="stext" id="spu" title="Nomor Surat Permintaan Uji" name="no_spu" value="'.$uricari[3].'" /></td></tr>';

		$str .= '<tr><td colspan="5" style="padding:5px;"><a href="#" class="button reload" onclick="serach_hasilspk(\'#fs_spk\',\'#bbpomid\',\'#komoditi\',\'#kode_sampel\',\'#spu\', \'#awal\',\'#akhir\',\'#no_spk\'); return false;"><span><span class="icon"></span>&nbsp; Cari &nbsp;</span></a></td></tr>';
		$str .= '</table>';
		$str .= '</form>';
		return $str;
	}

	function _showformsps($action, $cari, $subcari){
		$uricari = explode("_",$cari);
		$urisubcari = explode("_",$subcari);
		$kecuali = $this->remove_element($this->config->item('cfg_unit'), $this->newsession->userdata('SESS_BBPOM_ID'));
		$unit = "'".join("','", $kecuali)."'";
		if(in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))){
			$balai = $this->combobox("SELECT BBPOM_ID, REPLACE(REPLACE(NAMA_BBPOM, 'BALAI POM DI ', ''), 'BALAI BESAR POM DI ','') AS NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID NOT IN ('00','99',$unit) ORDER BY 2","BBPOM_ID","NAMA_BBPOM", TRUE);
		}else{
			$balai = $this->combobox("SELECT BBPOM_ID, REPLACE(REPLACE(NAMA_BBPOM, 'BALAI POM DI ', ''), 'BALAI BESAR POM DI ','') AS NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID NOT IN ('99','00') ORDER BY 2","BBPOM_ID","NAMA_BBPOM", TRUE);
			$sel_balai = '';
		}
		if(strlen($urisubcari[0]) != 0){
			if($urisubcari[0] != "ALL"){
				$awal = explode("-",$urisubcari[0]);
				$awal = $awal[0]."/".$awal[1]."/".$awal[2];
			}else{
				$awal = "ALL";
			}
		}else{
			$awal = "";
		}
		if(strlen($urisubcari[1]) != 0){
			if($urisubcari[1] != "ALL"){
				$akhir = explode("-",$urisubcari[1]);
				$akhir = $akhir[0]."/".$akhir[1]."/".$akhir[2];
			}else{
				$akhir = "ALL";
			}
		}else{
			$akhir = "";
		}
		$str .= '<form action="'.$action.'" id="fs_sps">';
		$str .= '<table class="form_temuan" style="width:100%">';
		$str .= '<tr><td class="temuan_left">Balai Besar / Balai POM</td><td class="temuan_right">';
		$str .= form_dropdown('bbpom',$balai,($uricari[0])?$uricari[0]:$selbalai,'class="stext" id="bbpomid" title="Asal Balai Besar / Balai POM"');
		$str .= '</td><td class="temuan_pemisah">&nbsp;</td><td class="temuan_left">Tanggal Surat Perintah</td><td class="temuan_right">';
		$str .= '<input type="text" class="sdate" id="awal" title="Periode awal tanggal spu" name="awal" value="'.$awal.'" />&nbsp; sampai dengan &nbsp;<input type="text" class="sdate" name="akhir" id="akhir" title="Periode tanggal akhir spu" value="'.$akhir.'" /></td></tr>';
		$str .= '<tr><td class="temuan_left">Nomor Surat Permintaan Uji</td><td class="temuan_right"><input type="text" class="stext" id="no_spu" title="Nomor Surat Permintaan Uji" value="'.$uricari[1].'" /></td><td class="temuan_pemisah">&nbsp;</td><td class="temuan_left">Kode Sampel</td><td class="temuan_right"><input type="text" class="stext" id="kode_sampel" title="Kode Sampel" value="'.$urisubcari[2].'" /></td></tr>';

		$str .= '<tr><td colspan="5" style="padding:5px;"><a href="#" class="button reload" onclick="serach_hasilsps(\'#fs_sps\',\'#bbpomid\',\'#no_spu\',\'#awal\',\'#akhir\',\'#kode_sampel\'); return false;"><span><span class="icon"></span>&nbsp; Cari &nbsp;</span></a></td></tr>';
		$str .= '</table>';
		$str .= '</form>';
		return $str;
	}


	function _fsarana($action, $cari, $subcari){
		$uricari = explode("_",$cari);
		$urisubcari = explode("_",$subcari);
		$disinput = array("JENISDIS","NAMADIS");
		$jenis_sarana = $this->get_jenis_sarana($this->newsession->userdata("SESS_USER_ID"), $disinput);
		if(in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))){
			$sel_prop = '';
			$prop = $this->combobox("SELECT PROPINSI_ID, NAMA_PROPINSI FROM M_PROPINSI WHERE RIGHT(PROPINSI_ID, 2) = '00'","PROPINSI_ID","NAMA_PROPINSI", TRUE);
		}else if($this->newsession->userdata('SESS_BBPOM_ID') != "00" && !in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))){
			$sel_prop = $this->newsession->userdata('SESS_PROP_ID');

			if($this->newsession->userdata('SESS_PROP_ID') == '7100'){
				$propid = "'7100','8200'";
			}else if($this->newsession->userdata('SESS_PROP_ID') == '7300'){
				$propid = "'7300','7600'";
			}else{
				$propid = "'".$this->newsession->userdata('SESS_PROP_ID')."'";
			}

			$prop = $this->combobox("SELECT PROPINSI_ID, NAMA_PROPINSI FROM M_PROPINSI WHERE RIGHT(PROPINSI_ID, 2) = '00' AND PROPINSI_ID IN ($propid)","PROPINSI_ID","NAMA_PROPINSI");
		}else{
			$sel_prop = '';
			$prop = $this->combobox("SELECT PROPINSI_ID, NAMA_PROPINSI FROM M_PROPINSI WHERE RIGHT(PROPINSI_ID, 2) = '00'","PROPINSI_ID","NAMA_PROPINSI", TRUE);
		}
		$str .= '<form action="'.$action.'" id="fs_sarana">';
		$str .= '<table class="form_temuan" style="width:100%">';
		$str .= '<tr><td class="temuan_left">Jenis Sarana</td><td class="temuan_right">';
		$str .= form_dropdown('jsarana',$jenis_sarana,($uricari[0])?$uricari[0]:'','class="stext" id="jenis_sarana" title="Jenis Sarana"',$disinput);
		$str .= '</td><td class="temuan_pemisah">&nbsp;</td><td class="temuan_left">Nama Sarana</td><td class="temuan_right"><input typ="text" id="nama_sarana" class="stext" title="Nama Sarana" value="'.$uricari[1].'"></td></tr>';
		$str .= '<tr><td class="temuan_left">Alamat</td><td class="temuan_right"><input type="text" class="stext" id="alamat" title="Alamat Sarana" value="'.$urisubcari[0].'"></td><td class="temuan_pemisah">&nbsp;</td><td class="temuan_left">Propinsi</td><td class="temuan_right">';
		$str .= form_dropdown('propinsi',$prop,($urisubcari[1])?$urisubcari[1]:$sel_prop,'class="stext" id="propinsi" title="Asal Propinsi"');
		$str .= '	</td></tr>';
		$str .= '<tr><td colspan="5" style="padding:5px;"><a href="#" class="button reload" onclick="search_msarana(\'#fs_sarana\',\'#jenis_sarana\',\'#nama_sarana\',\'#alamat\',\'#propinsi\'); return false;"><span><span class="icon"></span>&nbsp; Cari &nbsp;</span></a></td></tr>';
		$str .= '</table>';
		$str .= '</form>';
		return $str;
	}

	function _showformspp($action, $cari, $subcari){
		$uricari = explode("_",$cari);
		$urisubcari = explode("_",$subcari);
		$kecuali = $this->remove_element($this->config->item('cfg_unit'), $this->newsession->userdata('SESS_BBPOM_ID'));
		$unit = "'".join("','", $kecuali)."'";
		$pelaporan = $this->combobox("SELECT KODE, URAIAN FROM M_TABEL WHERE JENIS = 'JENIS_PELAPORAN' AND KODE IN ('01','02','03','05')","KODE","URAIAN",TRUE);
		if(in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))){
			$balai = $this->combobox("SELECT BBPOM_ID, REPLACE(REPLACE(NAMA_BBPOM, 'BALAI POM DI ', ''), 'BALAI BESAR POM DI ','') AS NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID ='".$this->newsession->userdata('SESS_BBPOM_ID')."'","BBPOM_ID","NAMA_BBPOM");
			$sel_balai = $this->newsession->userdata('SESS_BBPOM_ID');
		}else if($this->newsession->userdata('SESS_BBPOM_ID') != "00" && !in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))){
			$sel_balai = $this->newsession->userdata('SESS_BBPOM_ID');
			$balai = $this->combobox("SELECT BBPOM_ID, REPLACE(REPLACE(NAMA_BBPOM, 'BALAI POM DI ', ''), 'BALAI BESAR POM DI ','') AS NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID ='".$this->newsession->userdata('SESS_BBPOM_ID')."'","BBPOM_ID","NAMA_BBPOM");
		}else{
			$balai = $this->combobox("SELECT BBPOM_ID, REPLACE(REPLACE(NAMA_BBPOM, 'BALAI POM DI ', ''), 'BALAI BESAR POM DI ','') AS NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID NOT IN ('00') ORDER BY 2 ASC","BBPOM_ID","NAMA_BBPOM", TRUE);
			$sel_balai = '';
		}

		if($this->newsession->userdata('SESS_BBPOM_ID') == "00"){
			$role = $this->combobox("SELECT KODE, URAIAN FROM M_TABEL WHERE JENIS = 'ROLE' AND KODE NOT IN('1') ORDER BY KODE DESC","KODE","URAIAN", TRUE);
		}
		else if(in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))){
			$role = $this->combobox("SELECT KODE, URAIAN FROM M_TABEL WHERE JENIS = 'ROLE' AND KODE NOT IN('1','5','9','10') ORDER BY KODE DESC","KODE","URAIAN", TRUE);
		}
		else{
			$role = $this->combobox("SELECT KODE, URAIAN FROM M_TABEL WHERE JENIS = 'ROLE' AND KODE NOT IN('1','6','9','10') ORDER BY KODE DESC","KODE","URAIAN", TRUE);
		}
		$selrole = '';
		$str .= '<form action="'.$action.'" id="fsearchspp">';
		$str .= '<table class="form_temuan" style="width:100%">';
		$str .= '<tr><td class="temuan_left">Balai Besar /  Balai POM</td><td class="temuan_right">';
		$str .= form_dropdown('bbpom',$balai,($uricari[0])?$uricari[0]:$selbalai,'class="stext" id="bbpomid" title="Asal Balai Besar / Balai POM"');
		$str .= '</td><td class="temuan_pemisah">&nbsp;</td><td class="temuan_left">Kode Sampel</td><td class="temuan_right"><input typ="text" id="kode_sampel" class="stext" title="Kode Sampel" value="'.$uricari[1].'"></td></tr>';
		$str .= '<tr><td class="temuan_left">Nomor SPP</td><td class="temuan_right"><input typ="text" id="no_spp" class="stext" title="Nomor SPP" value="'.$urisubcari[0].'">';
		$str .= '</td><td class="temuan_pemisah">&nbsp;</td><td class="temuan_left">Penyelia</td><td class="temuan_right"><input typ="text" id="penyelia" class="stext" title="Penyelia" value="'.$urisubcari[1].'"></td></tr>';
		$str .= '<tr><td colspan="5" style="padding:5px;"><a href="#" class="button reload" onclick="serach_hasilspp(\'#fsearchspp\', \'#bbpomid\',\'#kode_sampel\',\'#no_spp\',\'#penyelia\'); return false;"><span><span class="icon"></span>&nbsp; Cari &nbsp;</span></a></td></tr>';
		$str .= '</table>';
		$str .= '</form>';
		return $str;
	}


	function _showformcp($action, $cari, $subcari){
		$uricari = explode("_",$cari);
		$urisubcari = explode("_",$subcari);
		$kecuali = $this->remove_element($this->config->item('cfg_unit'), $this->newsession->userdata('SESS_BBPOM_ID'));
		$unit = "'".join("','", $kecuali)."'";
		$pelaporan = $this->combobox("SELECT KODE, URAIAN FROM M_TABEL WHERE JENIS = 'JENIS_PELAPORAN' AND KODE IN ('01','02','03','05')","KODE","URAIAN",TRUE);
		if(in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))){
			$balai = $this->combobox("SELECT BBPOM_ID, REPLACE(REPLACE(NAMA_BBPOM, 'BALAI POM DI ', ''), 'BALAI BESAR POM DI ','') AS NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID ='".$this->newsession->userdata('SESS_BBPOM_ID')."'","BBPOM_ID","NAMA_BBPOM");
			$sel_balai = $this->newsession->userdata('SESS_BBPOM_ID');
		}else if($this->newsession->userdata('SESS_BBPOM_ID') != "00" && !in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))){
			$sel_balai = $this->newsession->userdata('SESS_BBPOM_ID');
			$balai = $this->combobox("SELECT BBPOM_ID, REPLACE(REPLACE(NAMA_BBPOM, 'BALAI POM DI ', ''), 'BALAI BESAR POM DI ','') AS NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID ='".$this->newsession->userdata('SESS_BBPOM_ID')."'","BBPOM_ID","NAMA_BBPOM");
		}else{
			$balai = $this->combobox("SELECT BBPOM_ID, REPLACE(REPLACE(NAMA_BBPOM, 'BALAI POM DI ', ''), 'BALAI BESAR POM DI ','') AS NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID NOT IN ('00') ORDER BY 2 ASC","BBPOM_ID","NAMA_BBPOM", TRUE);
			$sel_balai = '';
		}

		if($this->newsession->userdata('SESS_BBPOM_ID') == "00"){
			$role = $this->combobox("SELECT KODE, URAIAN FROM M_TABEL WHERE JENIS = 'ROLE' AND KODE NOT IN('1') ORDER BY KODE DESC","KODE","URAIAN", TRUE);
		}
		else if(in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))){
			$role = $this->combobox("SELECT KODE, URAIAN FROM M_TABEL WHERE JENIS = 'ROLE' AND KODE NOT IN('1','5','9','10') ORDER BY KODE DESC","KODE","URAIAN", TRUE);
		}
		else{
			$role = $this->combobox("SELECT KODE, URAIAN FROM M_TABEL WHERE JENIS = 'ROLE' AND KODE NOT IN('1','6','9','10') ORDER BY KODE DESC","KODE","URAIAN", TRUE);
		}
		$selrole = '';
		$str .= '<form action="'.$action.'" id="fsearchcp">';
		$str .= '<table class="form_temuan" style="width:100%">';
		$str .= '<tr><td class="temuan_left">Balai Besar /  Balai POM</td><td class="temuan_right">';
		$str .= form_dropdown('bbpom',$balai,($uricari[0])?$uricari[0]:$selbalai,'class="stext" id="bbpomid" title="Asal Balai Besar / Balai POM"');
		$str .= '</td><td class="temuan_pemisah">&nbsp;</td><td class="temuan_left">Kode Sampel</td><td class="temuan_right"><input typ="text" id="kode_sampel" class="stext" title="Kode Sampel" value="'.$uricari[1].'"></td></tr>';
		$str .= '<tr><td class="temuan_left">Manager Teknis</td><td class="temuan_right"><input typ="text" id="mt" class="stext" title="Manager Teknis" value="'.$urisubcari[0].'">';
		$str .= '</td><td class="temuan_pemisah">&nbsp;</td><td class="temuan_left">Penyelia</td><td class="temuan_right"><input typ="text" id="penyelia" class="stext" title="Penyelia" value="'.$urisubcari[1].'"></td></tr>';
		$str .= '<tr><td colspan="5" style="padding:5px;"><a href="#" class="button reload" onclick="serach_hasilcp(\'#fsearchcp\', \'#bbpomid\',\'#kode_sampel\',\'#mt\',\'#penyelia\'); return false;"><span><span class="icon"></span>&nbsp; Cari &nbsp;</span></a></td></tr>';
		$str .= '</table>';
		$str .= '</form>';
		return $str;
	}

	function _fpetugas($action, $cari, $subcari){
		$uricari = explode("_",$cari);
		$urisubcari = explode("_",$subcari);
		$kecuali = $this->remove_element($this->config->item('cfg_unit'), $this->newsession->userdata('SESS_BBPOM_ID'));
		$unit = "'".join("','", $kecuali)."'";
		$pelaporan = $this->combobox("SELECT KODE, URAIAN FROM M_TABEL WHERE JENIS = 'JENIS_PELAPORAN' AND KODE IN ('01','02','03','05')","KODE","URAIAN",TRUE);
		if(in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))){
			$balai = $this->combobox("SELECT BBPOM_ID, REPLACE(REPLACE(NAMA_BBPOM, 'BALAI POM DI ', ''), 'BALAI BESAR POM DI ','') AS NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID ='".$this->newsession->userdata('SESS_BBPOM_ID')."'","BBPOM_ID","NAMA_BBPOM");
			$sel_balai = $this->newsession->userdata('SESS_BBPOM_ID');
		}else if($this->newsession->userdata('SESS_BBPOM_ID') != "00" && !in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))){
			$sel_balai = $this->newsession->userdata('SESS_BBPOM_ID');
			$balai = $this->combobox("SELECT BBPOM_ID, REPLACE(REPLACE(NAMA_BBPOM, 'BALAI POM DI ', ''), 'BALAI BESAR POM DI ','') AS NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID ='".$this->newsession->userdata('SESS_BBPOM_ID')."'","BBPOM_ID","NAMA_BBPOM");
		}else{
			$balai = $this->combobox("SELECT BBPOM_ID, REPLACE(REPLACE(NAMA_BBPOM, 'BALAI POM DI ', ''), 'BALAI BESAR POM DI ','') AS NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID NOT IN ('00') ORDER BY 2 ASC","BBPOM_ID","NAMA_BBPOM", TRUE);
			$sel_balai = '';
		}

		if($this->newsession->userdata('SESS_BBPOM_ID') == "00"){
			$role = $this->combobox("SELECT KODE, URAIAN FROM M_TABEL WHERE JENIS = 'ROLE' AND KODE NOT IN('1') ORDER BY KODE DESC","KODE","URAIAN", TRUE);
		}
		else if(in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))){
			$role = $this->combobox("SELECT KODE, URAIAN FROM M_TABEL WHERE JENIS = 'ROLE' AND KODE NOT IN('1','5','9','10') ORDER BY KODE DESC","KODE","URAIAN", TRUE);
		}
		else{
			$role = $this->combobox("SELECT KODE, URAIAN FROM M_TABEL WHERE JENIS = 'ROLE' AND KODE NOT IN('1','6','9','10') ORDER BY KODE DESC","KODE","URAIAN", TRUE);
		}
		$selrole = '';
		$str .= '<form action="'.$action.'" id="fpetugas">';
		$str .= '<table class="form_temuan" style="width:100%">';
		$str .= '<tr><td class="temuan_left">Nomor Induk Pegawai</td><td class="temuan_right"><input typ="text" id="nip" class="stext" title="Nomor Induk Pegawai" value="'.$uricari[0].'">';
		$str .= '</td><td class="temuan_pemisah">&nbsp;</td><td class="temuan_left">Nama Petugas</td><td class="temuan_right"><input typ="text" id="nama" class="stext" title="Nama Petugas" value="'.$uricari[1].'"></td></tr>';
		$str .= '<tr><td class="temuan_left">Role SIPT</td><td class="temuan_right">';
		$str .= form_dropdown('role',$role,($urisubcari[0])?$urisubcari[0]:$selrole,'class="stext" id="role" title="Role Petugas SIPT"');
		$str .= '</td><td class="temuan_pemisah">&nbsp;</td><td class="temuan_left">Balai Besar / Balai POM</td><td class="temuan_right">';
		$str .= form_dropdown('bbpom',$balai,($urisubcari[1])?$urisubcari[1]:$selbalai,'class="stext" id="bbpomid" title="Asal Balai Besar / Balai POM"');
		$str .= '	</td></tr>';
		$str .= '<tr><td class="temuan_left">Jenis Pelaporan</td><td class="temuan_right">';
		$str .= form_dropdown('pelaporan',$pelaporan,($uricari[2])?$uricari[2]:'','class="stext" id="pelaporan" title="Jenis Pelaporan"');
		$str .= '</td><td class="temuan_pemisah">&nbsp;</td><td class="temuan_left">&nbsp;</td><td class="temuan_right">&nbsp;</td></tr>';
		$str .= '<tr><td colspan="5" style="padding:5px;"><a href="#" class="button reload" onclick="search_mpetugas(\'#fpetugas\', \'#nip\',\'#nama\',\'#role\',\'#bbpomid\',\'#pelaporan\'); return false;"><span><span class="icon"></span>&nbsp; Cari &nbsp;</span></a></td></tr>';
		$str .= '</table>';
		$str .= '</form>';
		return $str;
	}


	function redir($message,$url,$segment=NULL){
		$data = array("pesan" => $message,
					  "url" => $url,
					  "seg" => $segment);
        $this->load->view('redirect',$data);
	}

	function bap_petugas($periksa){
		$query = "SELECT A.NOMOR AS [NOMOR_SURAT], CONVERT(VARCHAR(10), A.TANGGAL, 103) AS [TANGGAL_SURAT], CAST(SUBSTRING(B.USER_ID, 0, 9)+ ' ' +SUBSTRING(B.USER_ID, 9, 6)+' '+SUBSTRING(B.USER_ID, 15, 1)+' '+SUBSTRING(B.USER_ID, 16, 3) AS VARCHAR) AS NIP, B.NAMA_USER AS [NAMA_PETUGAS], B.JABATAN AS JABATAN, REPLACE(REPLACE(C.NAMA_BBPOM,'BALAI BESAR POM', 'Balai Besar Pengawas Obat dan Makanan'),'BALAI POM','Balai Pengawas Obat dan Makanan') AS [BADAN] FROM T_SURAT_TUGAS A LEFT JOIN T_SURAT_TUGAS_PETUGAS D ON A.SURAT_ID = D.SURAT_ID LEFT JOIN T_USER B ON B.USER_ID = D.USER_ID LEFT JOIN M_BBPOM C ON C.BBPOM_ID = B.BBPOM_ID LEFT JOIN T_SURAT_TUGAS_PELAPORAN E ON A.SURAT_ID = E.SURAT_ID WHERE E.LAPOR_ID IN ($periksa)";
		$data = $this->get_result($query);
		if($data){
			foreach($query->result_array() as $row){
				$petugas[] = $row;
			}
		}
		return $petugas;
	}

	function petugas_terakhir($surat){
		if($surat==""){
			$terakhir = "";
		}
		$query = "SELECT B.NAMA_USER FROM T_SURAT_TUGAS_PETUGAS A LEFT JOIN T_USER B ON A.USER_ID = B.USER_ID WHERE SURAT_ID = '".$surat."'";
		$data = $this->get_result($query);
		if($data){
			foreach($query->result() as $row){
				$terakhir[] = $row->NAMA_USER;
			}
		}
		return $terakhir;
	}

	function set_notif(){
		$sarana = "'".join("','", $this->newsession->userdata('SESS_SARANA'))."'";
		$note = "<ul class=\"notifikasi\">";
		if(in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))){#Pusat
			if(in_array('2', $this->newsession->userdata('SESS_KODE_ROLE'))){#Operator
				$note .=  "<li class=\"notifikasi-icon draft\"><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/20111\">Terdapat ".$this->get_uraian("SELECT COUNT(STATUS) AS DRAFT FROM T_PEMERIKSAAN WHERE STATUS = '20111' AND JENIS_SARANA_ID IN ($sarana) AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND CREATE_BY = '".$this->newsession->userdata('SESS_USER_ID')."'","DRAFT")." Dokumen Draft</a></li>";
				$note .=  "<li class=\"notifikasi-icon draft\"><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/20115\">Terdapat ".$this->get_uraian("SELECT COUNT(STATUS) AS BALAI FROM T_PEMERIKSAAN WHERE STATUS = '20115' AND JENIS_SARANA_ID IN ($sarana)","BALAI")." Dokumen Diterima Dari Balai</a></li>";
				$note .=  "<li class=\"notifikasi-icon reject\"><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/20112\">Terdapat ".$this->get_uraian("SELECT COUNT(STATUS) AS REJECT FROM T_PEMERIKSAAN WHERE STATUS = '20112' AND JENIS_SARANA_ID IN ($sarana)","REJECT")." Dokumen Ditolak Supervisor Satu</a></li>";

			}
			if(in_array('3', $this->newsession->userdata('SESS_KODE_ROLE'))){#Supervisor Satu
				$note .=  "<li class=\"notifikasi-icon tl\"><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/30111\">Terdapat ".$this->get_uraian("SELECT COUNT(STATUS) AS TL FROM T_PEMERIKSAAN WHERE STATUS = '30111' AND JENIS_SARANA_ID IN ($sarana)","TL")." Dokumen Tindak Lanjut</a></li>";
				$note .=  "<li class=\"notifikasi-icon reject\"><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/30112\">Terdapat ".$this->get_uraian("SELECT COUNT(STATUS) AS REJECT FROM T_PEMERIKSAAN WHERE STATUS = '30112' AND JENIS_SARANA_ID IN ($sarana)","REJECT")." Dokumen Ditolak Supervisor Dua</a></li>";
				$note .=  "<li class=\"notifikasi-icon review\"><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/30114\">Terdapat ".$this->get_uraian("SELECT COUNT(STATUS) AS REVIEW FROM T_PEMERIKSAAN WHERE STATUS = '30114' AND JENIS_SARANA_ID IN ($sarana)","REVIEW")." Dokumen Perbaikan Oleh Operator</a></li>";
			}
			if(in_array('4', $this->newsession->userdata('SESS_KODE_ROLE'))){#Supervisor Dua
				$note .=  "<li class=\"notifikasi-icon tl\"><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/40111\">Terdapat ".$this->get_uraian("SELECT COUNT(STATUS) AS TL FROM T_PEMERIKSAAN WHERE STATUS = '40111' AND JENIS_SARANA_ID IN ($sarana)","TL")." Dokumen Tindak Lanjut</a></li>";
				$note .=  "<li class=\"notifikasi-icon review\"><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/40113\">Terdapat ".$this->get_uraian("SELECT COUNT(STATUS) AS REVIEW FROM T_PEMERIKSAAN WHERE STATUS = '40113' AND JENIS_SARANA_ID IN ($sarana)","REVIEW")." Dokumen Review Perbaikan Supervisor Satu</a></li>";
			}
			if(in_array('6', $this->newsession->userdata('SESS_KODE_ROLE'))){#Direktur
				$note .=  "<li class=\"notifikasi-icon tl\"><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/pusat\">Terdapat ".$this->get_uraian("SELECT COUNT(STATUS) AS PUSAT FROM T_PEMERIKSAAN WHERE STATUS = '60111' AND JENIS_SARANA_ID IN ($sarana) AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","PUSAT")." Tindak Lanjut Pemeriksaan Pusat</a></li>";
				$note .=  "<li class=\"notifikasi-icon tl\"><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/balai\">Terdapat ".$this->get_uraian("SELECT COUNT(STATUS) AS BALAI FROM T_PEMERIKSAAN WHERE STATUS = '60111' AND JENIS_SARANA_ID IN ($sarana) AND BBPOM_ID <> '".$this->newsession->userdata('SESS_BBPOM_ID')."'","BALAI")." Tindak Lanjut Pemeriksaan Balai</a></li>";
			}

			$note .=  "<li class=\"notifikasi-icon send\"><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/send\">Terdapat ".$this->get_uraian("SELECT COUNT(STATUS) AS SENT FROM T_PEMERIKSAAN WHERE JENIS_SARANA_ID IN ($sarana) AND STATUS IN (".$this->status_send().")","SENT")." Dokumen Terkirim</a></li>";
		}else{
			if(in_array('2', $this->newsession->userdata('SESS_KODE_ROLE'))){#Operator
				$note .=  "<li class=\"notifikasi-icon draft\"><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/20101\">Terdapat ".$this->get_uraian("SELECT COUNT(STATUS) AS DRAFT FROM T_PEMERIKSAAN WHERE STATUS = '20101' AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND CREATE_BY = '".$this->newsession->userdata('SESS_USER_ID')."'","DRAFT")." Dokumen Draft</a></li>";
				$note .=  "<li class=\"notifikasi-icon reject\"><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/20102\">Terdapat ".$this->get_uraian("SELECT COUNT(STATUS) AS REJECT FROM T_PEMERIKSAAN WHERE STATUS = '20102' AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND CREATE_BY = '".$this->newsession->userdata('SESS_USER_ID')."'","REJECT")." Dokumen Ditolak Supervisor Satu</a></li>";
				$note .=  "<li class=\"notifikasi-icon review\"><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/20103\">Terdapat ".$this->get_uraian("SELECT COUNT(STATUS) AS REVIEW FROM T_PEMERIKSAAN WHERE STATUS = '20103' AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND CREATE_BY = '".$this->newsession->userdata('SESS_USER_ID')."'","REVIEW")." Dokumen Perbaikan</a></li>";
			}

			if(in_array('3', $this->newsession->userdata('SESS_KODE_ROLE'))){#Supervisor Satu
				$note .=  "<li class=\"notifikasi-icon tl\"><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/30101\">Terdapat ".$this->get_uraian("SELECT COUNT(STATUS) AS TL FROM T_PEMERIKSAAN WHERE STATUS = '30101' AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","TL")." Dokumen Tindak Lanjut</a></li>";
				$note .=  "<li class=\"notifikasi-icon reject\"><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/30102\">Terdapat ".$this->get_uraian("SELECT COUNT(STATUS) AS REJECT FROM T_PEMERIKSAAN WHERE STATUS = '30102' AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","REJECT")." Dokumen Ditolak Supervisor Dua</li>";
				$note .=  "<li class=\"notifikasi-icon review\"><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/30104\">Terdapat ".$this->get_uraian("SELECT COUNT(STATUS) AS REVIEW FROM T_PEMERIKSAAN WHERE STATUS = '30104' AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","REVIEW")." Dokumen Perbaikan Operator</a></li>";
			}

			if(in_array('4', $this->newsession->userdata('SESS_KODE_ROLE'))){#Supervisor Dua
				$note .=  "<li class=\"notifikasi-icon tl\"><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/40101\">Terdapat ".$this->get_uraian("SELECT COUNT(STATUS) AS TL FROM T_PEMERIKSAAN WHERE STATUS = '40101' AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","TL")." Dokumen Tindak Lanjut</a></li>";
				$note .=  "<li class=\"notifikasi-icon review\"><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/40103\">Terdapat ".$this->get_uraian("SELECT COUNT(STATUS) AS REVIEW FROM T_PEMERIKSAAN WHERE STATUS = '40103' AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","REVIEW")." Dokumen Review Perbaikan Supervisor Satu</a></li>";
			}

			if(in_array('5', $this->newsession->userdata('SESS_KODE_ROLE'))){#Kepala Balai
				$note .=  "<li class=\"notifikasi-icon tl\"><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/50101\">Terdapat ".$this->get_uraian("SELECT COUNT(STATUS) AS TL FROM T_PEMERIKSAAN WHERE STATUS = '50101' AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","TL")." Dokumen Tindak Lanjut</a></li>";
			}

			$note .=  "<li class=\"notifikasi-icon send\"><a href=\"".site_url()."/home/pelaporan/pemeriksaan/view/send\">Terdapat ".$this->get_uraian("SELECT COUNT(STATUS) AS SENT FROM T_PEMERIKSAAN WHERE STATUS IN (".$this->status_send().") AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","SENT")." Dokumen Terkirim</a></li>";
		}
		$note .= "</ul>";
		return $note;
	}

	function referensi($jenis="", $kodein="", $isuraian=FALSE, $isnbsp=FALSE){
		$ref = "";
		if($jenis=="") return "Missing Parameters";
		if($isnbsp) $space = TRUE;
		if(!$isuraian){
			if($kodein!="")
				$ref = $this->combobox("SELECT KODE, URAIAN FROM M_TABEL WHERE JENIS='".$jenis."' AND KODE IN(".$kodein.")","KODE","URAIAN", $space);
			else
				$ref = $this->combobox("SELECT KODE, URAIAN FROM M_TABEL WHERE JENIS='".$jenis."'","KODE","URAIAN", $space);
		}else{
			if($kodein!=="")
				$ref = $this->combobox("SELECT URAIAN FROM M_TABEL WHERE JENIS='".$jenis."' AND KODE IN(".$kodein.")","URAIAN","URAIAN", $space);
			else
				$ref = $this->combobox("SELECT URAIAN FROM M_TABEL WHERE JENIS='".$jenis."'","URAIAN","URAIAN", $space);
		}
		return $ref;
	}

	function clean_tags($html){
		$html = ereg_replace("<(/)?(font|span|del|ins)[^>]*>","",$html);
		$html = ereg_replace("<([^>]*)(class|lang|style|size|face)=(\"[^\"]*\"|'[^']*'|[^>]+)([^>]*)>","",$html);
		$html = ereg_replace("<([^>]*)(class|lang|style|size|face)=(\"[^\"]*\"|'[^']*'|[^>]+)([^>]*)>","",$html);
		return $html;
	}

	function set_kode_spu($anggaran,$ko, $tahun=""){
		$chk = (int)$this->get_uraian("SELECT AUTO_RESET FROM M_REF_SPU WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND ANGGARAN = '".$anggaran."' AND KOMODITI = '".$ko."'","AUTO_RESET");
		if($chk == 1){
			$kode_balai = $this->get_uraian("SELECT KODE_BALAI FROM M_NOMOR WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","KODE_BALAI");
			$kode = strlen($kode_balai) == "2" ? '0'.$kode_balai : $kode_balai;
			$this->db->simple_query("IF NOT EXISTS (SELECT BBPOM_ID, ANGGARAN, KOMODITI, NOMOR, RESET, UPDATED FROM M_REF_SPU WHERE ANGGARAN = '$anggaran' AND KOMODITI = '$ko' AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND (CASE [RESET] WHEN 'D' THEN CONVERT(VARCHAR, UPDATED, 112) WHEN 'M' THEN LEFT(CONVERT(VARCHAR, UPDATED, 112), 6) + RIGHT('0' + CAST(DAY(GETDATE()) AS VARCHAR), 2) WHEN 'Y' THEN LEFT(CONVERT(VARCHAR, UPDATED, 112), 4) + RIGHT('0' + CAST(MONTH(GETDATE()) AS VARCHAR), 2) + RIGHT('0' + CAST(DAY(GETDATE()) AS VARCHAR), 2) END) = CONVERT(VARCHAR, GETDATE(), 112)) UPDATE M_REF_SPU SET NOMOR = 1, UPDATED = GETDATE() WHERE ANGGARAN = '$anggaran' AND KOMODITI = '$ko' AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' ELSE UPDATE M_REF_SPU SET NOMOR = NOMOR + 1, UPDATED = GETDATE() WHERE ANGGARAN = '$anggaran' AND KOMODITI = '$ko' AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'");
			$query = "SELECT URAIAN AS FORMAT FROM M_TABEL WHERE JENIS = 'NOMOR' AND KODE = 'SPU'";
			$res = $this->get_result($query);
			if($res){
				$row = $query->row();
				$nomor = $this->get_uraian("SELECT NOMOR FROM M_REF_SPU WHERE ANGGARAN = '$anggaran' AND KOMODITI = '$ko' AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","NOMOR");
				$format = $row->FORMAT;
				$arrfor = explode("%", $format);
				foreach($arrfor as $a){
					$b = explode(";", $a);
					if(substr($b[0], 0, 1)=="_"){
						$digit = (int)$b[1];
						if($b[0]=="_KB"){
							$tmp = substr(str_repeat("0", $digit).$kode, -$digit);
							$format = str_replace($a, $tmp, $format);
						}else if($b[0]=="_A"){
							$tmp = substr(str_repeat("0", $digit).$anggaran, -$digit);
							$format = str_replace($a, $tmp, $format);
						}else if($b[0]=="_YEAR"){
							$tmp = substr(str_repeat("0", $digit).date("Y"), -$digit);
							$format = str_replace($a, $tmp, $format);
						}else if($b[0]=="_MONTH"){
							$tmp = substr(str_repeat("0", $digit).date("m"), -$digit);
							$format = str_replace($a, $tmp, $format);
						}else if($b[0]=="_K"){
							$tmp = substr(str_repeat("0", $digit).$ko, -$digit);
							$format = str_replace($a, $tmp, $format);
						}else if($b[0]=="_#"){
							$tmp = substr(str_repeat("0", $digit).(int)$nomor, -$digit);
							$format = str_replace($a, $tmp, $format);
						}
					}else{
						$format = str_replace("%".$b[0], $b[0], $format);
					}
				}
				return 'SPU'.$format;
			}
		}else{
			$query = "SELECT SPU_$ko AS URUT_SPU FROM M_NOMOR WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'";
			$format = (int)$this->get_uraian($query,"URUT_SPU") + 1;
			$kode_balai = $this->get_uraian("SELECT KODE_BALAI FROM M_NOMOR WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'",'KODE_BALAI');
			$time = explode("/",$tahun);
			$year = substr($time[2],2,4);
			$month = $time[1];
			$kode = strlen($kode_balai) == "2" ? '0'.$kode_balai : $kode_balai;
			$format = sprintf("%04d", $format);
			$format = 'SPU'.$kode.$anggaran.$year.$month.$ko.$format;
			$this->db->simple_query("UPDATE M_NOMOR SET SPU_$ko = SPU_$ko + 1 WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'");
			return $format;
		}
	}

	function set_kode_sp($ko,$dmy){
		$chk = (int)$this->get_uraian("SELECT AUTO_RESET FROM M_REF_SP WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND KOMODITI = '".$ko."'","AUTO_RESET");
		if($chk == 1){
			$kode_balai = $this->get_uraian("SELECT KODE_BALAI FROM M_NOMOR WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","KODE_BALAI");
			$kode = strlen($kode_balai) == "2" ? '0'.$kode_balai : $kode_balai;
			$this->db->simple_query("IF NOT EXISTS (SELECT BBPOM_ID, KOMODITI, NOMOR, RESET, UPDATED FROM M_REF_SP WHERE KOMODITI = '$ko' AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND (CASE [RESET] WHEN 'D' THEN CONVERT(VARCHAR, UPDATED, 112) WHEN 'M' THEN LEFT(CONVERT(VARCHAR, UPDATED, 112), 6) + RIGHT('0' + CAST(DAY(GETDATE()) AS VARCHAR), 2) WHEN 'Y' THEN LEFT(CONVERT(VARCHAR, UPDATED, 112), 4) + RIGHT('0' + CAST(MONTH(GETDATE()) AS VARCHAR), 2) + RIGHT('0' + CAST(DAY(GETDATE()) AS VARCHAR), 2) END) = CONVERT(VARCHAR, GETDATE(), 112)) UPDATE M_REF_SP SET NOMOR = 1, UPDATED = GETDATE() WHERE KOMODITI = '$ko' AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' ELSE UPDATE M_REF_SP SET NOMOR = NOMOR + 1, UPDATED = GETDATE() WHERE KOMODITI = '$ko' AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'");
			$query = "SELECT URAIAN AS FORMAT FROM M_TABEL WHERE JENIS = 'NOMOR' AND KODE = 'SP'";
			$res = $this->get_result($query);
			if($res){
				$row = $query->row();
				$nomor = $this->get_uraian("SELECT NOMOR FROM M_REF_SP WHERE KOMODITI = '$ko' AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","NOMOR");
				$format = $row->FORMAT;
				$arrfor = explode("%", $format);
				foreach($arrfor as $a){
					$b = explode(";", $a);
					if(substr($b[0], 0, 1)=="_"){
						$digit = (int)$b[1];
						if($b[0]=="_KB"){
							$tmp = substr(str_repeat("0", $digit).$kode, -$digit);
							$format = str_replace($a, $tmp, $format);
						}else if($b[0]=="_YEAR"){
							$tmp = substr(str_repeat("0", $digit).date("Y"), -$digit);
							$format = str_replace($a, $tmp, $format);
						}else if($b[0]=="_MONTH"){
							$tmp = substr(str_repeat("0", $digit).date("m"), -$digit);
							$format = str_replace($a, $tmp, $format);
						}else if($b[0]=="_DATE"){
							$tmp = substr(str_repeat("0", $digit).date("d"), -$digit);
							$format = str_replace($a, $tmp, $format);
						}else if($b[0]=="_K"){
							$tmp = substr(str_repeat("0", $digit).$ko, -$digit);
							$format = str_replace($a, $tmp, $format);
						}else if($b[0]=="_#"){
							$tmp = substr(str_repeat("0", $digit).(int)$nomor, -$digit);
							$format = str_replace($a, $tmp, $format);
						}
					}else{
						$format = str_replace("%".$b[0], $b[0], $format);
					}
				}
				return 'SP'.$format;
			}
		}else{
			$query = "SELECT SP_$ko AS URUT_SP FROM M_NOMOR WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'";
			$format = (int)$this->get_uraian($query,"URUT_SP") + 1;
			$kode_balai = $this->get_uraian("SELECT KODE_BALAI FROM M_NOMOR WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'",'KODE_BALAI');
			$kode = strlen($kode_balai) == "2" ? '0'.$kode_balai : $kode_balai;
			$format = sprintf("%04d", $format);
			$format = 'SP'.$kode.$dmy.$ko.$format;
			$query = "UPDATE M_NOMOR SET SP_$ko = SP_$ko + 1 WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'";
			$this->db->simple_query($query);
			return $format;
		}

	}

	function set_kode_spk($ko,$lab,$tahun=""){
		$chk = (int)$this->get_uraian("SELECT AUTO_RESET FROM M_REF_SPK WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND KOMODITI = '".$ko."' AND BIDANG = '".$lab."'","AUTO_RESET");
		if($chk == 1){
			$kode_balai = $this->get_uraian("SELECT KODE_BALAI FROM M_NOMOR WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","KODE_BALAI");
			$kode = strlen($kode_balai) == "2" ? '0'.$kode_balai : $kode_balai;
			$this->db->simple_query("IF NOT EXISTS (SELECT BBPOM_ID, KOMODITI, BIDANG, NOMOR, RESET, UPDATED FROM M_REF_SPK WHERE KOMODITI = '$ko' AND BIDANG = '$lab' AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND (CASE [RESET] WHEN 'D' THEN CONVERT(VARCHAR, UPDATED, 112) WHEN 'M' THEN LEFT(CONVERT(VARCHAR, UPDATED, 112), 6) + RIGHT('0' + CAST(DAY(GETDATE()) AS VARCHAR), 2) WHEN 'Y' THEN LEFT(CONVERT(VARCHAR, UPDATED, 112), 4) + RIGHT('0' + CAST(MONTH(GETDATE()) AS VARCHAR), 2) + RIGHT('0' + CAST(DAY(GETDATE()) AS VARCHAR), 2) END) = CONVERT(VARCHAR, GETDATE(), 112)) UPDATE M_REF_SPK SET NOMOR = 1, UPDATED = GETDATE() WHERE KOMODITI = '$ko' AND BIDANG = '$lab' AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' ELSE UPDATE M_REF_SPK SET NOMOR = NOMOR + 1, UPDATED = GETDATE() WHERE KOMODITI = '$ko' AND BIDANG = '$lab' AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'");
			$query = "SELECT URAIAN AS FORMAT FROM M_TABEL WHERE JENIS = 'NOMOR' AND KODE = 'SPK'";
			$res = $this->get_result($query);
			if($res){
				$row = $query->row();
				$nomor = $this->get_uraian("SELECT NOMOR FROM M_REF_SPK WHERE KOMODITI = '$ko' AND BIDANG = '$lab' AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","NOMOR");
				$format = $row->FORMAT;
				$arrfor = explode("%", $format);
				foreach($arrfor as $a){
					$b = explode(";", $a);
					if(substr($b[0], 0, 1)=="_"){
						$digit = (int)$b[1];
						if($b[0]=="_KB"){
							$tmp = substr(str_repeat("0", $digit).$kode, -$digit);
							$format = str_replace($a, $tmp, $format);
						}else if($b[0]=="_YEAR"){
							$tmp = substr(str_repeat("0", $digit).date("Y"), -$digit);
							$format = str_replace($a, $tmp, $format);
						}else if($b[0]=="_MONTH"){
							$tmp = substr(str_repeat("0", $digit).date("m"), -$digit);
							$format = str_replace($a, $tmp, $format);
						}else if($b[0]=="_K"){
							$tmp = substr(str_repeat("0", $digit).$ko, -$digit);
							$format = str_replace($a, $tmp, $format);
						}else if($b[0]=="_L"){
							$tmp = substr(str_repeat("0", $digit).$lab, -$digit);
							$format = str_replace($a, $tmp, $format);
						}else if($b[0]=="_#"){
							$tmp = substr(str_repeat("0", $digit).(int)$nomor, -$digit);
							$format = str_replace($a, $tmp, $format);
						}#SPK08114 0512K0552 SPK07120K0001
					}else{
						$format = str_replace("%".$b[0], $b[0], $format);
					}
				}
				return 'SPK'.$format;
			}
		}else{
			$query = "SELECT SPK_$ko AS URUT_SPK FROM M_NOMOR WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'";
			$format = (int)$this->get_uraian($query,"URUT_SPK") + 1;
			$kode_balai = $this->get_uraian("SELECT KODE_BALAI FROM M_NOMOR WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'",'KODE_BALAI');
			$kode = strlen($kode_balai) == "2" ? '0'.$kode_balai : $kode_balai;
			$format = sprintf("%04d", $format);
			$time = explode("/",$tahun);
			$year = substr($time[2],2,4);
			$month = $time[1];
			$date = $time[0];
			$format = 'SPK'.$kode.$year.$month.$ko.$lab.$format;
			$query = "UPDATE M_NOMOR SET SPK_$ko = SPK_$ko + 1 WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'";
			$this->db->simple_query($query);
			return $format;
		}
	}

	function set_kode_spp($ko,$lab,$tahun=""){
		$chk = (int)$this->get_uraian("SELECT AUTO_RESET FROM M_REF_SPP WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND KOMODITI = '".$ko."' AND BIDANG = '".$lab."'","AUTO_RESET");
		if($chk == 1){
			$kode_balai = $this->get_uraian("SELECT KODE_BALAI FROM M_NOMOR WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","KODE_BALAI");
			$kode = strlen($kode_balai) == "2" ? '0'.$kode_balai : $kode_balai;
			$this->db->simple_query("IF NOT EXISTS (SELECT BBPOM_ID, KOMODITI, BIDANG, NOMOR, RESET, UPDATED FROM M_REF_SPP WHERE KOMODITI = '$ko' AND BIDANG = '$lab' AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND (CASE [RESET] WHEN 'D' THEN CONVERT(VARCHAR, UPDATED, 112) WHEN 'M' THEN LEFT(CONVERT(VARCHAR, UPDATED, 112), 6) + RIGHT('0' + CAST(DAY(GETDATE()) AS VARCHAR), 2) WHEN 'Y' THEN LEFT(CONVERT(VARCHAR, UPDATED, 112), 4) + RIGHT('0' + CAST(MONTH(GETDATE()) AS VARCHAR), 2) + RIGHT('0' + CAST(DAY(GETDATE()) AS VARCHAR), 2) END) = CONVERT(VARCHAR, GETDATE(), 112)) UPDATE M_REF_SPP SET NOMOR = 1, UPDATED = GETDATE() WHERE KOMODITI = '$ko' AND BIDANG = '$lab' AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' ELSE UPDATE M_REF_SPP SET NOMOR = NOMOR + 1, UPDATED = GETDATE() WHERE KOMODITI = '$ko' AND BIDANG = '$lab' AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'");
			$query = "SELECT URAIAN AS FORMAT FROM M_TABEL WHERE JENIS = 'NOMOR' AND KODE = 'SPP'";
			$res = $this->get_result($query);
			if($res){
				$row = $query->row();
				$nomor = $this->get_uraian("SELECT NOMOR FROM M_REF_SPP WHERE KOMODITI = '$ko' AND BIDANG = '$lab' AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","NOMOR");
				$format = $row->FORMAT;
				$arrfor = explode("%", $format);
				foreach($arrfor as $a){
					$b = explode(";", $a);
					if(substr($b[0], 0, 1)=="_"){
						$digit = (int)$b[1];
						if($b[0]=="_KB"){
							$tmp = substr(str_repeat("0", $digit).$kode, -$digit);
							$format = str_replace($a, $tmp, $format);
						}else if($b[0]=="_YEAR"){
							$tmp = substr(str_repeat("0", $digit).date("Y"), -$digit);
							$format = str_replace($a, $tmp, $format);
						}else if($b[0]=="_MONTH"){
							$tmp = substr(str_repeat("0", $digit).date("m"), -$digit);
							$format = str_replace($a, $tmp, $format);
						}else if($b[0]=="_K"){
							$tmp = substr(str_repeat("0", $digit).$ko, -$digit);
							$format = str_replace($a, $tmp, $format);
						}else if($b[0]=="_L"){
							$tmp = substr(str_repeat("0", $digit).$lab, -$digit);
							$format = str_replace($a, $tmp, $format);
						}else if($b[0]=="_#"){
							$tmp = substr(str_repeat("0", $digit).(int)$nomor, -$digit);
							$format = str_replace($a, $tmp, $format);
						}
					}else{
						$format = str_replace("%".$b[0], $b[0], $format);
					}
				}
				return 'SPP'.$format;
			}
		}else{
			$query = "SELECT SPP_$ko AS URUT_SPP FROM M_NOMOR WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'";
			$format = (int)$this->get_uraian($query,"URUT_SPP") + 1;
			$kode_balai = $this->get_uraian("SELECT KODE_BALAI FROM M_NOMOR WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'",'KODE_BALAI');
			$kode = strlen($kode_balai) == "2" ? '0'.$kode_balai : $kode_balai;
			$time = explode("/",$tahun);
			$year = substr($time[2],2,4);
			$month = $time[1];
			$date = $time[0];
			$format = sprintf("%04d", $format);
			$format = 'SPP'.$kode.$year.$month.$ko.$format;
			$query = "UPDATE M_NOMOR SET SPP_$ko = SPP_$ko + 1 WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'";
			$this->db->simple_query($query);
			return $format;
		}
	}

	function set_kode_uji($lab,$ko,$tahun=""){
		$chk = (int)$this->get_uraian("SELECT AUTO_RESET FROM M_REF_UJI WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND KOMODITI = '".$ko."' AND BIDANG = '".$lab."'","AUTO_RESET");
		if($chk == 1){
			$kode_balai = $this->get_uraian("SELECT KODE_BALAI FROM M_NOMOR WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","KODE_BALAI");
			$kode = strlen($kode_balai) == "2" ? '0'.$kode_balai : $kode_balai;
			$this->db->simple_query("IF NOT EXISTS (SELECT BBPOM_ID, KOMODITI, BIDANG, NOMOR, RESET, UPDATED FROM M_REF_UJI WHERE KOMODITI = '$ko' AND BIDANG = '$lab' AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND (CASE [RESET] WHEN 'D' THEN CONVERT(VARCHAR, UPDATED, 112) WHEN 'M' THEN LEFT(CONVERT(VARCHAR, UPDATED, 112), 6) + RIGHT('0' + CAST(DAY(GETDATE()) AS VARCHAR), 2) WHEN 'Y' THEN LEFT(CONVERT(VARCHAR, UPDATED, 112), 4) + RIGHT('0' + CAST(MONTH(GETDATE()) AS VARCHAR), 2) + RIGHT('0' + CAST(DAY(GETDATE()) AS VARCHAR), 2) END) = CONVERT(VARCHAR, GETDATE(), 112)) UPDATE M_REF_UJI SET NOMOR = 1, UPDATED = GETDATE() WHERE KOMODITI = '$ko' AND BIDANG = '$lab' AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' ELSE UPDATE M_REF_UJI SET NOMOR = NOMOR + 1, UPDATED = GETDATE() WHERE KOMODITI = '$ko' AND BIDANG = '$lab' AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'");
			$query = "SELECT URAIAN AS FORMAT FROM M_TABEL WHERE JENIS = 'NOMOR' AND KODE = 'UJI'";
			$res = $this->get_result($query);
			if($res){
				$row = $query->row();
				$nomor = $this->get_uraian("SELECT NOMOR FROM M_REF_UJI WHERE KOMODITI = '$ko' AND BIDANG = '$lab' AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","NOMOR");
				$format = $row->FORMAT;
				$arrfor = explode("%", $format);
				foreach($arrfor as $a){
					$b = explode(";", $a);
					if(substr($b[0], 0, 1)=="_"){
						$digit = (int)$b[1];
						if($b[0]=="_KB"){
							$tmp = substr(str_repeat("0", $digit).$kode, -$digit);
							$format = str_replace($a, $tmp, $format);
						}else if($b[0]=="_L"){
							$tmp = substr(str_repeat("0", $digit).$lab, -$digit);
							$format = str_replace($a, $tmp, $format);
						}else if($b[0]=="_K"){
							$tmp = substr(str_repeat("0", $digit).$ko, -$digit);
							$format = str_replace($a, $tmp, $format);
						}else if($b[0]=="_YEAR"){
							$tmp = substr(str_repeat("0", $digit).date("Y"), -$digit);
							$format = str_replace($a, $tmp, $format);
						}else if($b[0]=="_#"){
							$tmp = substr(str_repeat("0", $digit).(int)$nomor, -$digit);
							$format = str_replace($a, $tmp, $format);
						}
					}else{
						$format = str_replace("%".$b[0], $b[0], $format);
					}
				}
				return 'LAB'.$format;
			}
		}else{
			$query = "SELECT UJI_$ko AS URUT_UJI FROM M_NOMOR WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'";
			$format = (int)$this->get_uraian($query,"URUT_UJI") + 1;
			$kode_balai = $this->get_uraian("SELECT KODE_BALAI FROM M_NOMOR WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'",'KODE_BALAI');
			$kode = strlen($kode_balai) == "2" ? '0'.$kode_balai : $kode_balai;
			$time = explode("/",$tahun);
			$year = substr($time[0],2,4);
			$format = sprintf("%04d", $format);
			$format = 'LAB'.$kode.$lab.$ko.$year.$format;
			$query = "UPDATE M_NOMOR SET UJI_$ko = UJI_$ko + 1 WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'";
			$this->db->simple_query($query);
			return $format;
		}
	}


	function set_kode_cp($ko,$tahun=""){
		$chk = (int)$this->get_uraian("SELECT AUTO_RESET FROM M_REF_CP WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND KOMODITI = '".$ko."'","AUTO_RESET");
		if($chk == 1){
			$kode_balai = $this->get_uraian("SELECT KODE_BALAI FROM M_NOMOR WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","KODE_BALAI");
			$kode = strlen($kode_balai) == "2" ? '0'.$kode_balai : $kode_balai;
			$this->db->simple_query("IF NOT EXISTS (SELECT BBPOM_ID, KOMODITI, NOMOR, RESET, UPDATED FROM M_REF_CP WHERE KOMODITI = '$ko' AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND (CASE [RESET] WHEN 'D' THEN CONVERT(VARCHAR, UPDATED, 112) WHEN 'M' THEN LEFT(CONVERT(VARCHAR, UPDATED, 112), 6) + RIGHT('0' + CAST(DAY(GETDATE()) AS VARCHAR), 2) WHEN 'Y' THEN LEFT(CONVERT(VARCHAR, UPDATED, 112), 4) + RIGHT('0' + CAST(MONTH(GETDATE()) AS VARCHAR), 2) + RIGHT('0' + CAST(DAY(GETDATE()) AS VARCHAR), 2) END) = CONVERT(VARCHAR, GETDATE(), 112)) UPDATE M_REF_CP SET NOMOR = 1, UPDATED = GETDATE() WHERE KOMODITI = '$ko' AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' ELSE UPDATE M_REF_CP SET NOMOR = NOMOR + 1, UPDATED = GETDATE() WHERE KOMODITI = '$ko' AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'");
			$query = "SELECT URAIAN AS FORMAT FROM M_TABEL WHERE JENIS = 'NOMOR' AND KODE = 'CP'";
			$res = $this->get_result($query);
			if($res){
				$row = $query->row();
				$nomor = $this->get_uraian("SELECT NOMOR FROM M_REF_CP WHERE KOMODITI = '$ko' AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","NOMOR");
				$format = $row->FORMAT;
				$arrfor = explode("%", $format);
				foreach($arrfor as $a){
					$b = explode(";", $a);
					if(substr($b[0], 0, 1)=="_"){
						$digit = (int)$b[1];
						if($b[0]=="_KB"){
							$tmp = substr(str_repeat("0", $digit).$kode, -$digit);
							$format = str_replace($a, $tmp, $format);
						}else if($b[0]=="_K"){
							$tmp = substr(str_repeat("0", $digit).$ko, -$digit);
							$format = str_replace($a, $tmp, $format);
						}else if($b[0]=="_YEAR"){
							$tmp = substr(str_repeat("0", $digit).date("Y"), -$digit);
							$format = str_replace($a, $tmp, $format);
						}else if($b[0]=="_#"){
							$tmp = substr(str_repeat("0", $digit).(int)$nomor, -$digit);
							$format = str_replace($a, $tmp, $format);
						}
					}else{
						$format = str_replace("%".$b[0], $b[0], $format);
					}
				}
				return 'CP'.$format;
			}
		}else{
			$query = "SELECT CP_$ko AS URUT_CP FROM M_NOMOR WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'";
			$format = (int)$this->get_uraian($query,"URUT_CP") + 1;
			$kode_balai = $this->get_uraian("SELECT KODE_BALAI FROM M_NOMOR WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'",'KODE_BALAI');
			$kode = strlen($kode_balai) == "2" ? '0'.$kode_balai : $kode_balai;
			$time = explode("/",$tahun);
			$year = substr($time[2],2,4);
			$format = sprintf("%04d", $format);
			$format = 'CP'.$kode.$ko.$year.$format;
			$query = "UPDATE M_NOMOR SET CP_$ko = CP_$ko + 1 WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'";
			$this->db->simple_query($query);
			return $format;
		}
	}

	function set_kode_lhu($lab,$anggaran,$ko,$tahun=""){
		$chk = (int)$this->get_uraian("SELECT AUTO_RESET FROM M_REF_LHU WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND KOMODITI = '".$ko."' AND ANGGARAN = '".$anggaran."' AND BIDANG = '".$lab."'","AUTO_RESET");
		if($chk == 1){
			$kode_balai = $this->get_uraian("SELECT KODE_BALAI FROM M_NOMOR WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","KODE_BALAI");
			$kode = strlen($kode_balai) == "2" ? '0'.$kode_balai : $kode_balai;
			$this->db->simple_query("IF NOT EXISTS (SELECT BBPOM_ID, KOMODITI, ANGGARAN, BIDANG, NOMOR, RESET, UPDATED FROM M_REF_LHU WHERE KOMODITI = '$ko' AND ANGGARAN = '$anggaran' AND BIDANG = '$lab' AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND (CASE [RESET] WHEN 'D' THEN CONVERT(VARCHAR, UPDATED, 112) WHEN 'M' THEN LEFT(CONVERT(VARCHAR, UPDATED, 112), 6) + RIGHT('0' + CAST(DAY(GETDATE()) AS VARCHAR), 2) WHEN 'Y' THEN LEFT(CONVERT(VARCHAR, UPDATED, 112), 4) + RIGHT('0' + CAST(MONTH(GETDATE()) AS VARCHAR), 2) + RIGHT('0' + CAST(DAY(GETDATE()) AS VARCHAR), 2) END) = CONVERT(VARCHAR, GETDATE(), 112)) UPDATE M_REF_LHU SET NOMOR = 1, UPDATED = GETDATE() WHERE KOMODITI = '$ko' AND ANGGARAN = '$anggaran' AND BIDANG = '$lab' AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' ELSE UPDATE M_REF_LHU SET NOMOR = NOMOR + 1, UPDATED = GETDATE() WHERE KOMODITI = '$ko' AND ANGGARAN = '$anggaran' AND BIDANG = '$lab' AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'");
			$query = "SELECT URAIAN AS FORMAT FROM M_TABEL WHERE JENIS = 'NOMOR' AND KODE = 'LHU'";
			$res = $this->get_result($query);
			if($res){
				$row = $query->row();
				$nomor = $this->get_uraian("SELECT NOMOR FROM M_REF_LHU WHERE KOMODITI = '$ko' AND ANGGARAN = '$anggaran' AND BIDANG = '$lab' AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","NOMOR");
				$format = $row->FORMAT;
				$arrfor = explode("%", $format);
				foreach($arrfor as $a){
					$b = explode(";", $a);
					if(substr($b[0], 0, 1)=="_"){
						$digit = (int)$b[1];
						if($b[0]=="_KB"){
							$tmp = substr(str_repeat("0", $digit).$kode, -$digit);
							$format = str_replace($a, $tmp, $format);
						}else if($b[0]=="_L"){
							$tmp = substr(str_repeat("0", $digit).$lab, -$digit);
							$format = str_replace($a, $tmp, $format);
						}else if($b[0]=="_A"){
							$tmp = substr(str_repeat("0", $digit).$anggaran, -$digit);
							$format = str_replace($a, $tmp, $format);
						}else if($b[0]=="_K"){
							$tmp = substr(str_repeat("0", $digit).$ko, -$digit);
							$format = str_replace($a, $tmp, $format);
						}else if($b[0]=="_YEAR"){
							$tmp = substr(str_repeat("0", $digit).date("Y"), -$digit);
							$format = str_replace($a, $tmp, $format);
						}else if($b[0]=="_#"){
							$tmp = substr(str_repeat("0", $digit).(int)$nomor, -$digit);
							$format = str_replace($a, $tmp, $format);
						}
					}else{
						$format = str_replace("%".$b[0], $b[0], $format);
					}
				}
				return 'LHU'.$format;
			}
		}else{
			$query = "SELECT LHU_$ko AS URUT_LHU FROM M_NOMOR WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'";
			$format = (int)$this->get_uraian($query,"URUT_LHU") + 1;
			$kode_balai = $this->get_uraian("SELECT KODE_BALAI FROM M_NOMOR WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'",'KODE_BALAI');
			$kode = strlen($kode_balai) == "2" ? '0'.$kode_balai : $kode_balai;
			$time = explode("/",$tahun);
			$year = substr($time[2],2,4);
			$format = sprintf("%04d", $format);
			$format = 'LHU'.$kode.$lab.$anggaran.$ko.$year.$format;
			$query = "UPDATE M_NOMOR SET LHU_$ko = LHU_$ko + 1 WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'";
			$this->db->simple_query($query);
			return $format;
		}
	}

	function set_max($params,$ko){
		if($params==""){
			return FALSE;
		}
		if($params=="spu"){
			$query = "UPDATE M_NOMOR SET SPU_$ko = SPU_$ko + 1 WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'";
		}else if($params=="sp"){
			$query = "UPDATE M_NOMOR SET SP_$ko = SP_$ko + 1 WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'";
		}else if($params=="spk"){
			$query = "UPDATE M_NOMOR SET SPK_$ko = SPK_$ko + 1 WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'";
		}else if($params=="spp"){
			$query = "UPDATE M_NOMOR SET SPP_$ko = SPP_$ko + 1 WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'";
		}else if($params=="uji"){
			$query = "UPDATE M_NOMOR SET UJI_$ko = UJI_$ko + 1 WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'";
		}else if($params=="cp"){
			$query = "UPDATE M_NOMOR SET CP_$ko = CP_$ko + 1 WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'";
		}else if($params=="lhu"){
			$query = "UPDATE M_NOMOR SET LHU_$ko = LHU_$ko + 1 WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'";
		}
		$hasil = $this->db->simple_query($query);
		if($hasil)
		return TRUE;
		else
		return FALSE;
	}

	function post_to_query($array, $except=""){
		$data = array();
		foreach($array as $a => $b){
			if(is_array($except)){
				if(!in_array($a, $except)) $data[$a] = $b;
			}else{
				$data[$a] = $b;
			}
		}
		return $data;
	}

	function backup_kode($ts, $as, $ko, $lab, $bbpomid){
		$kode_balai = $this->get_uraian("SELECT KODE_BALAI FROM M_NOMOR WHERE BBPOM_ID = '".$bbpomid."'","KODE_BALAI");
		$kode = strlen($kode_balai) == "2" ? '0'.$kode_balai : $kode_balai;
		$this->db->simple_query("IF NOT EXISTS (SELECT BBPOM_ID, ANGGARAN, KOMODITI, NOMOR, RESET, UPDATED FROM M_REF_SAMPEL WHERE ANGGARAN = '$as' AND KOMODITI = '$ko' AND BBPOM_ID = '".$bbpomid."' AND (CASE [RESET] WHEN 'D' THEN CONVERT(VARCHAR, UPDATED, 112) WHEN 'M' THEN LEFT(CONVERT(VARCHAR, UPDATED, 112), 6) + RIGHT('0' + CAST(DAY(GETDATE()) AS VARCHAR), 2) WHEN 'Y' THEN LEFT(CONVERT(VARCHAR, UPDATED, 112), 4) + RIGHT('0' + CAST(MONTH(GETDATE()) AS VARCHAR), 2) + RIGHT('0' + CAST(DAY(GETDATE()) AS VARCHAR), 2) END) = CONVERT(VARCHAR, GETDATE(), 112)) UPDATE M_REF_SAMPEL SET NOMOR = 1, UPDATED = GETDATE() WHERE ANGGARAN = '$as' AND KOMODITI = '$ko' AND BBPOM_ID = '".$bbpomid."' ELSE UPDATE M_REF_SAMPEL SET NOMOR = NOMOR + 1, UPDATED = GETDATE() WHERE ANGGARAN = '$as' AND KOMODITI = '$ko' AND BBPOM_ID = '".$bbpomid."'");
		$query = "SELECT URAIAN AS FORMAT FROM M_TABEL WHERE JENIS = 'NOMOR' AND KODE = 'SPL'";
		$res = $this->get_result($query);
		if($res){
			$row = $query->row();
			$nomor = $this->get_uraian("SELECT NOMOR FROM M_REF_SAMPEL WHERE ANGGARAN = '$as' AND KOMODITI = '$ko' AND BBPOM_ID = '$bbpomid'","NOMOR");
			$format = $row->FORMAT;
			$arrfor = explode("%", $format);
			foreach($arrfor as $a){
				$b = explode(";", $a);
				if(substr($b[0], 0, 1)=="_"){
					$digit = (int)$b[1];
					if($b[0]=="_YEAR"){
						$tmp = substr(str_repeat("0", $digit).date("Y"), -$digit);
						$format = str_replace($a, $tmp, $format);
					}else if($b[0]=="_KB"){
						$tmp = substr(str_repeat("0", $digit).$kode, -$digit);
						$format = str_replace($a, $tmp, $format);
					}else if($b[0]=="_T"){
						$tmp = substr(str_repeat("0", $digit).$ts, -$digit);
						$format = str_replace($a, $tmp, $format);
					}else if($b[0]=="_K"){
						$tmp = substr(str_repeat("0", $digit).$ko, -$digit);
						$format = str_replace($a, $tmp, $format);
					}else if($b[0]=="_A"){
						$tmp = substr(str_repeat("0", $digit).$as, -$digit);
						$format = str_replace($a, $tmp, $format);
					}else if($b[0]=="_#"){
						$tmp = substr(str_repeat("0", $digit).(int)$nomor, -$digit);
						$format = str_replace($a, $tmp, $format);
					}
				}else{
					$format = str_replace("%".$b[0], $b[0], $format);
				}
			}
			return $format.$lab;
		}
	}


	function set_kode_sampel($ts, $as, $ko, $lab, $tahun=""){
		$sipt =& get_instance();
		$sipt->load->model("main", "main", true);
		$kode_balai = $this->get_uraian("SELECT KODE_BALAI FROM M_NOMOR WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'",'KODE_BALAI');
		$kode = strlen($kode_balai) == "2" ? '0'.$kode_balai : $kode_balai;
		$chk = (int)$this->get_uraian("SELECT AUTO_RESET FROM M_REF_SAMPEL WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND ANGGARAN = '".$as."' AND KOMODITI = '".$ko."'","AUTO_RESET");
		if($chk == 1)
			$this->db->simple_query("IF NOT EXISTS (SELECT BBPOM_ID, ANGGARAN, KOMODITI, NOMOR, RESET, UPDATED FROM M_REF_SAMPEL WHERE ANGGARAN = '$as' AND KOMODITI = '$ko' AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND (CASE [RESET] WHEN 'D' THEN CONVERT(VARCHAR, UPDATED, 112) WHEN 'M' THEN LEFT(CONVERT(VARCHAR, UPDATED, 112), 6) + RIGHT('0' + CAST(DAY(GETDATE()) AS VARCHAR), 2) WHEN 'Y' THEN LEFT(CONVERT(VARCHAR, UPDATED, 112), 4) + RIGHT('0' + CAST(MONTH(GETDATE()) AS VARCHAR), 2) + RIGHT('0' + CAST(DAY(GETDATE()) AS VARCHAR), 2) END) = CONVERT(VARCHAR, GETDATE(), 112)) UPDATE M_REF_SAMPEL SET NOMOR = 1, UPDATED = GETDATE() WHERE ANGGARAN = '$as' AND KOMODITI = '$ko' AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' ELSE UPDATE M_REF_SAMPEL SET NOMOR = NOMOR + 1, UPDATED = GETDATE() WHERE ANGGARAN = '$as' AND KOMODITI = '$ko' AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'");
		else
			$this->db->simple_query("UPDATE M_REF_SAMPEL SET NOMOR = NOMOR + 1 WHERE ANGGARAN = '$as' AND KOMODITI = '$ko' AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'");
		$query = "SELECT URAIAN AS FORMAT FROM M_TABEL WHERE JENIS = 'NOMOR' AND KODE = 'SPL'";
		$res = $this->get_result($query);
		if($res){
			$row = $query->row();
			$nomor = $this->get_uraian("SELECT NOMOR FROM M_REF_SAMPEL WHERE ANGGARAN = '$as' AND KOMODITI = '$ko' AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","NOMOR");
			$format = $row->FORMAT;
			$arrfor = explode("%", $format);
			if($tahun==""){
				$year = date("Y");
			}else{
				$time = explode("/",$tahun);
				$year = $time[2];
			}
			foreach($arrfor as $a){
				$b = explode(";", $a);
				if(substr($b[0], 0, 1)=="_"){
					$digit = (int)$b[1];
					if($b[0]=="_YEAR"){
						$tmp = substr(str_repeat("0", $digit).$year, -$digit);
						$format = str_replace($a, $tmp, $format);
					}else if($b[0]=="_KB"){
						$tmp = substr(str_repeat("0", $digit).$kode, -$digit);
						$format = str_replace($a, $tmp, $format);
					}else if($b[0]=="_T"){
						$tmp = substr(str_repeat("0", $digit).$ts, -$digit);
						$format = str_replace($a, $tmp, $format);
					}else if($b[0]=="_K"){
						$tmp = substr(str_repeat("0", $digit).$ko, -$digit);
						$format = str_replace($a, $tmp, $format);
					}else if($b[0]=="_A"){
						$tmp = substr(str_repeat("0", $digit).$as, -$digit);
						$format = str_replace($a, $tmp, $format);
					}else if($b[0]=="_#"){
						$tmp = substr(str_repeat("0", $digit).(int)$nomor, -$digit);
						$format = str_replace($a, $tmp, $format);
					}
				}else{
					$format = str_replace("%".$b[0], $b[0], $format);
				}
			}
			return $format.$lab;
		}
	}//14.095.01.12.01.1128.KM

	// Pengawasan Iklan dan Penandaan
 function _showformiklan($action, $cari, $subcari) {
  $uricari = explode("_", $cari);
  $urisubcari = explode("_", $subcari);
  $status = $this->combobox("SELECT KODE,URAIAN FROM M_TABEL WHERE JENIS = 'STATUS' AND LEN(KODE) > 2 AND SUBSTRING(KODE, 3, 1) = '3' ORDER BY KODE ASC", "KODE", "URAIAN", TRUE);
  $hasil = array("" => "", "TMK" => "Tidak Memenuhi Ketentuan", "MK" => "Memenuhi Ketentuan");
  $kecuali = $this->remove_element($this->config->item('cfg_unit'), $this->newsession->userdata('SESS_BBPOM_ID'));
  $unit = "'" . join("','", $kecuali) . "'";
  $klasifikasi = "'" . join("','", $this->newsession->userdata("SESS_KLASIFIKASI_ID")) . "'";
  $arrayKom[''] = NULL;
  $arrayKom['001'] = 'Obat';
  $arrayKom['010'] = 'Obat Tradisional';
  $arrayKom['011'] = 'Suplemen Makanan';
  $arrayKom['012'] = 'Kosmetika';
  $arrayKom['013'] = 'Pangan';
  $orderByBPOM = "ORDER BY NAMA_BBPOM ASC";
  if (in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) {
   $balai = $this->combobox("SELECT BBPOM_ID, REPLACE(REPLACE(NAMA_BBPOM, 'BALAI POM DI ', ''), 'BALAI BESAR POM DI ','') AS NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID NOT IN ('00','99',$unit) $orderByBPOM", "BBPOM_ID", "NAMA_BBPOM", TRUE);
   $sel_balai = '';
//      $komoditi = $arrayKom;
   $komoditi = $this->combobox("SELECT * FROM M_KLASIFIKASI_KATEGORI WHERE LEN(KK_ID) = 3 AND KK_ID IN ('001')", "KK_ID", "NAMA_KK", TRUE);
  } else if ($this->newsession->userdata('SESS_BBPOM_ID') != "00" && !in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) {
   $sel_balai = $this->newsession->userdata('SESS_BBPOM_ID');
   $balai = $this->combobox("SELECT BBPOM_ID, REPLACE(REPLACE(NAMA_BBPOM, 'BALAI POM DI ', ''), 'BALAI BESAR POM DI ','') AS NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID ='" . $this->newsession->userdata('SESS_BBPOM_ID') . "' $orderByBPOM", "BBPOM_ID", "NAMA_BBPOM");
//      $komoditi = $arrayKom;
   $komoditi = $this->combobox("SELECT * FROM M_KLASIFIKASI_KATEGORI WHERE LEN(KK_ID) = 3 AND KK_ID IN ('001')", "KK_ID", "NAMA_KK", TRUE);
  } else {
   $balai = $this->combobox("SELECT BBPOM_ID, REPLACE(REPLACE(NAMA_BBPOM, 'BALAI POM DI ', ''), 'BALAI BESAR POM DI ','') AS NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID NOT IN ('99','00') $orderByBPOM", "BBPOM_ID", "NAMA_BBPOM", TRUE);
//      $komoditi = $arrayKom;
   $komoditi = $this->combobox("SELECT * FROM M_KLASIFIKASI_KATEGORI WHERE LEN(KK_ID) = 3 AND KK_ID IN ('001')", "KK_ID", "NAMA_KK", TRUE);
  }
//  $komoditi = $this->main->combobox("SELECT * FROM M_KLASIFIKASI_KATEGORI WHERE LEN(KK_ID) = 3 AND KK_ID IN ($klasifikasi)", "KK_ID", "NAMA_KK", TRUE);
  if (strlen($uricari[1]) != 0) {
   if ($uricari[1] != "ALL") {
    $awal = explode("-", $uricari[1]);
    $awal = $awal[0] . "/" . $awal[1] . "/" . $awal[2];
   } else {
    $awal = "ALL";
   }
  } else {
   $awal = "";
  }
  if (strlen($uricari[2]) != 0) {
   if ($uricari[2] != "ALL") {
    $akhir = explode("-", $uricari[2]);
    $akhir = $akhir[0] . "/" . $akhir[1] . "/" . $akhir[2];
   } else {
    $akhir = "ALL";
   }
  } else {
   $akhir = "";
  }
  $str .= '<form action="' . $action . '" id="fs_iklan">';
  $str .= '<table class="form_temuan" style="width:100%">';
  $str .= '<tr><td class="temuan_left">Nomor Surat Tugas</td><td class="temuan_right"><input type="text" name="no_surat" class="stext" id="no_surat" title="Nomor Surat Tugas" value="' . $uricari[0] . '" /></td><td class="temuan_pemisah">&nbsp;</td><td class="temuan_left">NIP</td><td class="temuan_right"><input type="text" name="petugas" class="stext" id="petugas" title="Nama Petugas" value="' . $urisubcari[0] . '" /></td></tr>';
  $str .= '<tr><td class="temuan_left">Tanggal Pemeriksaan</td><td class="temuan_right"><input type="text" class="sdate" id="awal" title="Periode Tanggal Pemeriksaan Awal" name="awal" value="' . $awal . '" />&nbsp; sampai dengan &nbsp;<input type="text" class="sdate" name="akhir" id="akhir" title="Periode Tanggal Pemeriksaan Akhir" value="' . $akhir . '" /></td><td class="temuan_pemisah">&nbsp;</td><td class="temuan_left"> Balai Besar / Balai POM</td><td class="temuan_right">';
  $str .= form_dropdown('bbpom', $balai, ($urisubcari[1]) ? $urisubcari[1] : $selbalai, 'class="stext" id="bbpomid" title="Asal Balai Besar / Balai POM"');
  $str .= '</td></tr>';
  $str .= '<tr><td class="temuan_left">Status Pemeriksaan</td><td class="temuan_right">';
  $str .= form_dropdown('status', $status, ($uricari[3]) ? $uricari[3] : '', 'class="stext" id="status" title="Status Pemeriksaan"');
  $str .= '</td><td class="temuan_pemisah">&nbsp;</td><td class="temuan_left">Hasil</td><td class="temuan_right">';
  $str .= form_dropdown('hasil', $hasil, ($urisubcari[2]) ? $urisubcari[2] : '', 'class="stext" id="hasil" title="Hasil Pemeriksaan"');
  $str .= '</td></tr>';
  $str .= '<tr><td class="temuan_left">&nbsp;</td><td class="temuan_right"></td><td class="temuan_pemisah">&nbsp;</td><td class="temuan_left">Komoditi</td><td class="temuan_right">';
  $str .= form_dropdown('komoditi', $komoditi, ($urisubcari[3]) ? $urisubcari[3] : '', 'class="stext" id="komoditi" title="Komoditi"');
  $str .= '</td></tr>';
  $str .= '<tr><td colspan="5" style="padding:5px;"><a href="#" class="button reload" onclick="search_iklan(\'#fs_iklan\',\'#no_surat\',\'#petugas\',\'#bbpomid\',\'#awal\',\'#akhir\',\'#hasil\',\'#status\',\'#komoditi\'); return false;"><span><span class="icon"></span>&nbsp; Cari &nbsp;</span></a></td></tr>';
  $str .= '</table>';
  $str .= '</form>';
  return $str;
 }

 function _showformpenandaan($action, $cari, $subcari) {
  $uricari = explode("_", $cari);
  $urisubcari = explode("_", $subcari);
  $status = $this->combobox("SELECT KODE,URAIAN FROM M_TABEL WHERE JENIS = 'STATUS' AND LEN(KODE) > 2 AND SUBSTRING(KODE, 3, 1) = '5' ORDER BY KODE ASC", "KODE", "URAIAN", TRUE);
  $kecuali = $this->remove_element($this->config->item('cfg_unit'), $this->newsession->userdata('SESS_BBPOM_ID'));
  $unit = "'" . join("','", $kecuali) . "'";
  $klasifikasi = "'" . join("','", $this->newsession->userdata("SESS_KLASIFIKASI_ID")) . "'";
  $orderByBPOM = "ORDER BY NAMA_BBPOM ASC";
  if (in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) {
   $balai = $this->combobox("SELECT BBPOM_ID, REPLACE(REPLACE(NAMA_BBPOM, 'BALAI POM DI ', ''), 'BALAI BESAR POM DI ','') AS NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID NOT IN ('00','99',$unit) $orderByBPOM", "BBPOM_ID", "NAMA_BBPOM", TRUE);
   $sel_balai = '';
   $klas_komoditi = "'" . join("','", $this->config->item('jenis_sarana')) . "'";
//      $komoditi = $this->combobox("SELECT DISTINCT(KK_ID) AS KK_ID, NAMA_KK FROM M_KLASIFIKASI_KATEGORI WHERE KK_ID IN (" . $klas_komoditi . ")", "KK_ID", "NAMA_KK", TRUE);
//   $komoditi = $this->combobox("SELECT * FROM M_KLASIFIKASI_KATEGORI WHERE LEN(KK_ID) = 3 AND KK_ID IN ('001')", "KK_ID", "NAMA_KK", TRUE);
  } else if ($this->newsession->userdata('SESS_BBPOM_ID') != "00" && !in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) {
   $sel_balai = $this->newsession->userdata('SESS_BBPOM_ID');
   $balai = $this->combobox("SELECT BBPOM_ID, REPLACE(REPLACE(NAMA_BBPOM, 'BALAI POM DI ', ''), 'BALAI BESAR POM DI ','') AS NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID ='" . $this->newsession->userdata('SESS_BBPOM_ID') . "' $orderByBPOM", "BBPOM_ID", "NAMA_BBPOM");
   $klas_komoditi = "'" . join("','", $this->config->item('jenis_sarana')) . "'";
//      $komoditi = $this->combobox("SELECT DISTINCT(KK_ID) AS KK_ID, NAMA_KK FROM M_KLASIFIKASI_KATEGORI WHERE KK_ID IN (" . $klas_komoditi . ")", "KK_ID", "NAMA_KK", TRUE);
   $komoditi = $this->combobox("SELECT * FROM M_KLASIFIKASI_KATEGORI WHERE LEN(KK_ID) = 3 AND KK_ID IN ('001')", "KK_ID", "NAMA_KK", TRUE);
  } else {
   $balai = $this->combobox("SELECT BBPOM_ID, REPLACE(REPLACE(NAMA_BBPOM, 'BALAI POM DI ', ''), 'BALAI BESAR POM DI ','') AS NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID NOT IN ('99','00') $orderByBPOM", "BBPOM_ID", "NAMA_BBPOM", TRUE);
   $sel_balai = '';
   $klas_komoditi = "'" . join("','", $this->config->item('jenis_sarana')) . "'";
//      $komoditi = $this->combobox("SELECT DISTINCT(KK_ID) AS KK_ID, NAMA_KK FROM M_KLASIFIKASI_KATEGORI WHERE KK_ID IN (" . $klas_komoditi . ")", "KK_ID", "NAMA_KK", TRUE);
   $komoditi = $this->combobox("SELECT * FROM M_KLASIFIKASI_KATEGORI WHERE LEN(KK_ID) = 3 AND KK_ID IN ('001')", "KK_ID", "NAMA_KK", TRUE);
  }
//  $komoditi = $this->main->combobox("SELECT * FROM M_KLASIFIKASI_KATEGORI WHERE LEN(KK_ID) = 3 AND KK_ID IN ($klasifikasi)", "KK_ID", "NAMA_KK", TRUE);
  $disinput = array("JENISDIS", "NAMADIS");
  $jenis = $this->get_jenis_sarana($this->newsession->userdata("SESS_USER_ID"), $disinput);
  $str .= '<form action="' . $action . '" id="fs_periksa">';
  $str .= '<table class="form_temuan" style="width:100%">';
  $str .= '<tr><td class="temuan_left">Nomor Surat Tugas</td><td class="temuan_right"><input type="text" name="no_surat" class="stext" id="no_surat" title="Nomor Surat Tugas" value="' . $uricari[0] . '" /></td><td class="temuan_pemisah">&nbsp;</td><td class="temuan_left">NIP</td><td class="temuan_right"><input type="text" name="petugas" class="stext" id="petugas" title="Nama Petugas" value="' . $urisubcari[0] . '" /></td></tr>';
  $str .= '<tr><td class="temuan_left">Nama Produk</td><td class="temuan_right"><input type="text" name="nama_produk" class="stext" id="nama_produk" title="Nama Produk" value="' . $uricari[1] . '"/></td><td class="temuan_pemisah">&nbsp;</td><td class="temuan_left"> Balai Besar / Balai POM</td><td class="temuan_right">';
  $str .= form_dropdown('bbpom', $balai, ($urisubcari[1]) ? $urisubcari[1] : $selbalai, 'class="stext" id="bbpomid" title="Asal Balai Besar / Balai POM"');
  $str .= '</td></tr>';
  if (strlen($uricari[2]) != 0) {
   if ($uricari[2] != "ALL") {
    $awal = explode("-", $uricari[2]);
    $awal = $awal[0] . "/" . $awal[1] . "/" . $awal[2];
   } else {
    $awal = "ALL";
   }
  } else {
   $awal = "";
  }
  if (strlen($uricari[3]) != 0) {
   if ($uricari[3] != "ALL") {
    $akhir = explode("-", $uricari[3]);
    $akhir = $akhir[0] . "/" . $akhir[1] . "/" . $akhir[2];
   } else {
    $akhir = "ALL";
   }
  } else {
   $akhir = "";
  }
  $str .= '<tr><td class="temuan_left">Tanggal Pemeriksaan</td><td class="temuan_right"><input type="text" class="sdate" id="awal" title="Periode Tanggal Pemeriksaan Awal" name="awal" value="' . $awal . '" />&nbsp; sampai dengan &nbsp;<input type="text" class="sdate" name="akhir" id="akhir" title="Periode Tanggal Pemeriksaan Akhir" value="' . $akhir . '" /></td><td class="temuan_pemisah">&nbsp;</td><td class="temuan_left">Komoditi</td><td class="temuan_right">';
  $str .= form_dropdown('komoditi', $komoditi, ($urisubcari[2]) ? $urisubcari[2] : '', 'class="stext" id="komoditi" title="Komoditi"');
  $str .= '</td></tr>';
  $str .= '<tr><td class="temuan_left">Status Pemeriksaan</td><td class="temuan_right">';
  $str .= form_dropdown('status', $status, ($uricari[4]) ? $uricari[4] : '', 'class="stext" id="status" title="Status Pemeriksaan"');
  $str .= '</td></tr>';
  $str .= '<tr><td colspan="5" style="padding:5px;"><a href="#" class="button reload" onclick="search_penandaan(\'#fs_periksa\',\'#no_surat\',\'#petugas\', \'#nama_produk\',\'#bbpomid\',\'#awal\',\'#akhir\',\'#status\',\'#komoditi\'); return false;"><span><span class="icon"></span>&nbsp; Cari &nbsp;</span></a></td></tr>';
  $str .= '</table>';
  $str .= '</form>';
  return $str;
 }

 function _fmedia($action, $cari) {
  $sipt = & get_instance();
  $sipt->load->model("main", "main", true);
  $uricari = explode("_", $cari);
  $jenisEmpt = array(" " => "");
  $jenis = $sipt->main->combobox("SELECT URAIAN FROM M_TABEL WHERE JENIS='MEDIA_IKLAN' ORDER BY URAIAN ASC", "URAIAN", "URAIAN");
  $jenis = array_merge($jenisEmpt, $jenis);
//  if (in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')) || $this->newsession->userdata('SESS_BBPOM_ID') == "50") {
//   $prop = $sipt->main->combobox("SELECT PROPINSI_ID, NAMA_PROPINSI FROM M_PROPINSI WHERE LEFT(PROPINSI_ID, 1) <= '9' AND RIGHT(PROPINSI_ID, 2) = '00'", "PROPINSI_ID", "NAMA_PROPINSI", TRUE);
//   $selProp = "";
//  } else {
//   $prop = $sipt->main->combobox("SELECT PROPINSI_ID, NAMA_PROPINSI FROM M_PROPINSI WHERE PROPINSI_ID = '" . $this->newsession->userdata('SESS_PROP_ID') . "'", "PROPINSI_ID", "NAMA_PROPINSI", TRUE);
//   $selProp = $this->newsession->userdata('SESS_PROP_ID');
//  }
  $str .= '<form action="' . $action . '" id="fs_media">';
  $str .= '<table class="form_temuan" style="width:100%">';
  $str .= '<tr><td class="temuan_left">Jenis Media</td><td class="temuan_right">';
  $str .= form_dropdown('jmedia', $jenis, ($uricari[0]) ? $uricari[0] : '', 'class="sjenis" id="jenis_media" title="Jenis Media"', '');
  $str .= '</td><td class="temuan_pemisah">&nbsp;</td><td class="temuan_left">Nama Media</td><td class="temuan_right"><input typ="text" id="nama_media" class="stext" title="Nama Media" value="' . $uricari[1] . '"></td></tr>';
//  $str .= '<tr><td class="temuan_left"></td><td class="temuan_right"></td><td class="temuan_pemisah">&nbsp;</td><td class="temuan_left">Propinsi</td><td class="temuan_right">' . form_dropdown('propinsi', $prop, ($urisubcari[0]) ? $urisubcari[0] : $selProp, 'class="stext" id="propinsi" title="Asal Propinsi"') . '</td></tr>';
//  $str .= '<tr><td colspan="5" style="padding:5px;"><a href="#" class="button reload" onclick="search_mmedia(\'#fs_media\',\'#jenis_media\',\'#nama_media\',\'#propinsi\'); return false;"><span><span class="icon"></span>&nbsp; Cari &nbsp;</span></a></td></tr>';
  $str .= '<tr><td colspan="5" style="padding:5px;"><a href="#" class="button reload" onclick="search_mmedia(\'#fs_media\',\'#jenis_media\',\'#nama_media\'); return false;"><span><span class="icon"></span>&nbsp; Cari &nbsp;</span></a></td></tr>';
  $str .= '</table>';
  $str .= '</form>';
  return $str;
 }

 function get_media_prov($query, $key) {
  $combobox = "";
  $data = $this->db->query($query);
  if ($data->num_rows() > 0) {
   foreach ($data->result_array() as $row) {
    $combobox[] = $row[$key];
   }
  } else {
   return false;
  }
  return "'" . join("','", $combobox) . "'";
 }
}
?>