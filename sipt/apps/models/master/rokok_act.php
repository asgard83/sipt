<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR);

class Rokok_act extends Model{
	
	function list_rokok(){
		if ($this->newsession->userdata('LOGGED_IN') == TRUE){
			$this->load->library('newtable');
			$query = "SELECT ID_ROKOK, NAMA_PERUSAHAAN AS 'PERUSAHAAN', MERK AS 'MERK ROKOK', JENIS, ISI FROM M_ROKOK";
			$this->newtable->columns(array("ID_ROKOK","NAMA_PERUSAHHAAN","MERK","JENIS","ISI"));
			$this->newtable->width(array('PERUSAHAAN' => 150,'MERK ROKOK' => 200, 'JENIS' => 75, 'ISI' => 50));
			$this->newtable->search(array(array("NAMA_PERUSAHAAN", "Berdasarkan Nama Perusahaan"), array("MERK", "Berdasarkan Merk Rokok"), array("JENIS", "Berdasarkan Jenis Rokok")));
			$this->newtable->action(site_url()."/home/master/rokok");
			$this->newtable->hiddens(array('ID_ROKOK'));
			$this->newtable->cidb($this->db);
			$this->newtable->ciuri($this->uri->segment_array());
			$this->newtable->orderby(1);
			$this->newtable->sortby("ASC");
			$this->newtable->keys(array('ID_ROKOK'));
			$tabel = $this->newtable->generate($query);
			$arrdata = array('table' => $tabel,
							 'idjudul' => 'juduluji',
							 'caption_header' => 'Master Data Rokok',
							 'batal' => '',
							 'cancel' => '');
			return $arrdata;
		}
	}
	
}
?>