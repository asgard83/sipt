<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);

class Pelanggaran_act extends Model{

	function list_pelanggaran(){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE && in_array('1', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('10',$this->newsession->userdata('SESS_KODE_ROLE')) || in_array('9', $this->newsession->userdata('SESS_KODE_ROLE')) && $this->newsession->userdata('SESS_BBPOM_ID') == "93" || $this->newsession->userdata('SESS_BBPOM_ID') == "00"){
			$sipt =& get_instance();
			$sipt->load->model("main", "main", true);
			$this->load->library('newtable');
			$this->newtable->hiddens(array('ASPEK','SERI'));
			$this->newtable->action(site_url()."/home/master/pelanggaran");
			$this->newtable->cidb($this->db);
			$this->newtable->ciuri($this->uri->segment_array());
			$this->newtable->orderby(3);
			$this->newtable->sortby("ASC");
			$this->newtable->keys(array('ASPEK','SERI'));
			$this->newtable->search(array(array('B.NAMA_JENIS_SARANA', 'Berdasarkan Jenis Sarana'), array('A.URAIAN', 'Berdasarkan Aspek Pelanggaran'), array('C.JENIS_PELANGGARAN', 'Berdasarkan Jenis Pelanggaran'), array('C.JENIS_PENYIMPANGAN', 'Berdasarkan Jenis Penyimpangan'),array('C.JENIS_KRITERIA_PELANGGARAN', 'Berdasarkan Kriteria Pelanggaran')));
			$proses['Pelanggaran Baru'] = array('GET',site_url().'/home/master/pelanggaran/new','0');
			$proses['Edit Pelanggaran'] = array('GET',site_url().'/home/master/pelanggaran/new','1');
			$proses['Hapus Pelanggaran'] = array('POST', site_url()."/post/master/pelanggaran/hapus/ajax", 'N');
			$this->newtable->menu($proses);
			$query = "SELECT C.ASPEK, C.SERI, REPLACE(B.NAMA_JENIS_SARANA,'(Pengawasan NAPZA)','') AS [JENIS SARANA], A.URAIAN AS [ASPEK PELANGGARAN], C.JENIS_PELANGGARAN+'<div>Jenis Penyimpangan : '+C.JENIS_PENYIMPANGAN+'</div><div>Kriteria Pelanggaran : '+C.JENIS_KRITERIA_PELANGGARAN AS [PELANGGARAN] FROM M_PELANGGARAN C LEFT JOIN M_TABEL A ON C.ASPEK = A.KODE LEFT JOIN M_JENIS_SARANA B ON C.JENIS_SARANA = B.JENIS_SARANA_ID WHERE A.JENIS = 'ASPEK_KTL'";
			$this->newtable->columns(array("C.ASPEK","C.SERI","REPLACE(B.NAMA_JENIS_SARANA,'(Pengawasan NAPZA)','')","A.URAIAN","C.JENIS_PELANGGARAN+'<div>Jenis Penyimpangan : '+C.JENIS_PENYIMPANGAN+'</div><div>Kriteria Pelanggaran : '+C.JENIS_KRITERIA_PELANGGARAN"));
			$tabel = $this->newtable->generate($query);
			$arrdata = array('table' => $tabel,
							 'idjudul' => 'judulpmnsarana',
							 'caption_header' => 'Master Pelanggaran - Kriteria Tindak Lanjut NAPZA',
							 'batal' => '',
							 'cancel' => '');
			return $arrdata;
		}else{
			$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
		}
	}
	
	function get_pelanggaran($id){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE && in_array('1', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('10',$this->newsession->userdata('SESS_KODE_ROLE')) || in_array('9', $this->newsession->userdata('SESS_KODE_ROLE')) && $this->newsession->userdata('SESS_BBPOM_ID') == "93" || $this->newsession->userdata('SESS_BBPOM_ID') == "00"){
			$sipt =& get_instance();
			$sipt->load->model("main", "main", true);
			$disinput = array("JENISDIS","NAMADIS");
			$jenis_sarana = $sipt->main->combobox("SELECT A.JENIS_SARANA_ID, REPLACE(A.NAMA_JENIS_SARANA,'(Pengawasan NAPZA)','') AS NAMA_JENIS_SARANA, B.JENIS_SARANA_ID AS JENISDIS, B.NAMA_JENIS_SARANA AS NAMADIS FROM M_JENIS_SARANA A LEFT JOIN M_JENIS_SARANA B ON LEFT(A.JENIS_SARANA_ID, 2) = B.JENIS_SARANA_ID WHERE A.JENIS_SARANA_ID IN ('01ON','02MN','02TN','03AN','03BN','03NN','03RN','03TP','03WN') ORDER BY A.JENIS_SARANA_ID ASC", "JENIS_SARANA_ID", "NAMA_JENIS_SARANA", TRUE, $disinput);
			$aspek = $sipt->main->combobox("SELECT KODE, URAIAN FROM M_TABEL WHERE JENIS = 'ASPEK_KTL'", "KODE", "URAIAN", TRUE);
			$kriteria = $sipt->main->combobox("SELECT KODE, URAIAN FROM M_TABEL WHERE JENIS = 'KRITERIA_KTL'", "URAIAN", "URAIAN", TRUE);
			$kk_id = $sipt->main->combobox("SELECT DISTINCT(KK_ID) AS KK_ID, NAMA_KK FROM M_KLASIFIKASI_KATEGORI WHERE KK_ID IN ('005','006','009')","KK_ID","NAMA_KK", TRUE);
			if($id==""){
				$arrdata = array('act' => site_url().'/post/master/pelanggaran/simpan',				
								 'batal' => site_url().'/home/master/pelanggaran',
								 'sess' => '',
								 'id' => '',
								 'sess' => '',
								 'save' => 'Simpan',
								 'cancel' => 'Batal');
			}else{
				$id = explode(".", $id);
				$query = "SELECT A.ASPEK, A.SERI, A.JENIS_SARANA, B.KK_ID, A.JENIS_PELANGGARAN, A.JENIS_PENYIMPANGAN, A.JENIS_KRITERIA_PELANGGARAN FROM M_PELANGGARAN A LEFT JOIN M_PELANGGARAN_KLASIFIKASI B ON A.ASPEK = B.ASPEK AND A.SERI = B.SERI WHERE A.ASPEK = '$id[0]' AND A.SERI = '$id[1]'";
				$data = $sipt->main->get_result($query);
				if($data){
					foreach($query->result_array() as $row){
						$sel_kk[] = $row['KK_ID'];
						$arrdata = array('sess' => $row,
										 'act' => site_url().'/post/master/pelanggaran/update',
										 'batal' => site_url().'/home/master/pelanggaran',
										 'id' => join(".",$id),
										 'sel_kk' => $sel_kk,
										 'save' => 'Update',
										 'cancel' => 'Kembali');
					}
				}
			}
			$arrdata['jenis_sarana'] = $jenis_sarana;
			$arrdata['aspek'] = $aspek;
			$arrdata['kriteria'] = $kriteria;
			$arrdata['kk_id'] = $kk_id;
			$arrdata['disinput'] = $disinput;
			return $arrdata;
		}else{
			$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
		}
	}
	
	function set_pelanggaran($action, $isajax){
		if(array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('10', $this->newsession->userdata('SESS_KODE_ROLE')) || $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main","main", true);
			if($action=="simpan"){
				foreach($this->input->post('PELANGGARAN') as $a => $b){
					$pelanggaran[$a] = $b;
				}
				$seri = (int)$sipt->main->get_uraian("SELECT MAX(SERI) AS MAXID FROM M_PELANGGARAN WHERE ASPEK = '".$pelanggaran['ASPEK']."'", "MAXID") + 1;
				$pelanggaran['SERI'] = $seri;
				if($this->db->insert('M_PELANGGARAN', $pelanggaran)){
					$kk_id = $this->input->post('KLASIFIKASI');
					for($i=0;$i<count($this->input->post('KLASIFIKASI'));$i++){			
						$arr_klasifikasi = array('ASPEK' => $pelanggaran['ASPEK'],'SERI' => $seri, 'KK_ID' => $kk_id[$i]);
						$this->db->insert('M_PELANGGARAN_KLASIFIKASI', $arr_klasifikasi);
					}
					 return "MSG#YES#Data berhasil disimpan#".site_url().'/home/master/pelanggaran';
				}
				if($isajax!="ajax"){
					redirect(site_url().'/home/master/pelanggaran');
					exit();
				}
			}
			else if($action=="update"){
				$id = explode(".", $this->input->post('ID'));
				foreach($this->input->post('PELANGGARAN') as $a => $b){
					$pelanggaran[$a] = $b;
				}
				$this->db->where(array("ASPEK" => $id[0], "SERI" => $id[1]));
				if($this->db->update('M_PELANGGARAN', $pelanggaran)){
					$this->db->where(array("ASPEK" => $id[0], "SERI" => $id[1]));
					$this->db->delete('M_PELANGGARAN_KLASIFIKASI');					
					$kk_id = $this->input->post('KLASIFIKASI');
					for($i=0;$i<count($this->input->post('KLASIFIKASI'));$i++){			
						$arr_klasifikasi = array('ASPEK' => $id[0],'SERI' => $id[1], 'KK_ID' => $kk_id[$i]);
						$this->db->insert('M_PELANGGARAN_KLASIFIKASI', $arr_klasifikasi);
					}
					return "MSG#YES#Data berhasil disimpan#".site_url().'/home/master/pelanggaran';
				}
				if($isajax!="ajax"){
					redirect(base_url());
					exit();
				}
			}
			else if($action=="hapus"){
				$ret = "MSG#Hapus Data Pelanggaran Gagal.";
				foreach($this->input->post('tb_chk') as $chkitem){
					$id = explode(".", $chkitem);
					$this->db->where(array("ASPEK" => $id[0], "SERI" => $id[1]));
					if($this->db->delete('M_PELANGGARAN')){
						 $ret = "MSG#Hapus Pelanggaran Berhasil.#".site_url().'/home/master/pelanggaran';
						 $this->db->where(array("ASPEK" => $id[0], "SERI" => $id[1]));
						 $this->db->delete('M_PELANGGARAN_KLASIFIKASI');
					}
				}
				if($isajax!="ajax"){
					redirect(base_url());
					exit();			  
				}
				return $ret;
			}
		}
		
		else{
			$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
		}		
	}

}
?>