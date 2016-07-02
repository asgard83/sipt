<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pemeriksaan extends Controller{
	
	function Pemeriksaan(){
		parent::Controller();
	}
	
	function index(){ 	
	  	$this->fungsi->redirectMessage('Maaf anda tidak bisa mengakses halaman ini.','/home');
	}
	
	function set_detail_periksa($sarana="",$jenis=""){
		if($jenis=="01ON" || $jenis=="02MN" || $jenis=="02TN" || $jenis=="03AN" || $jenis=="03BN" || $jenis=="03NN" || $jenis=="03TP" || $jenis=="03RN" || $jenis=="03WN"){
			$this->load->model('pemeriksaan/FNapza');
			$ret = $this->FNapza->get_history($sarana);
		}else if($jenis=="01JJ"){
			$this->load->model('pemeriksaan/F01JJ');
			$ret = $this->F01JJ->get_history($sarana);
		}else if($jenis=="01VV"){
			$this->load->model('pemeriksaan/F01VV');
			$ret = $this->F01VV->get_history($sarana);
		}else if($jenis=="02PG"){
			$this->load->model('pemeriksaan/F02PG');
			$ret = $this->F02PG->get_history($sarana);
		}else if($jenis=="02BB"){
			$this->load->model('pemeriksaan/F02BB');
			$ret = $this->F02BB->get_history($sarana);
		}
		echo $ret;
	}
	
	function set_preview($sarana="",$jenis="",$klasifikasi="",$idperiksa=""){
		if($this->newsession->userdata('LOGGED_IN') == "TRUE"){
			$mdl = "F".$jenis;
			if($jenis=="01ON" || $jenis=="02MN" || $jenis=="02TN" || $jenis=="03AN" || $jenis=="03BN" || $jenis=="03NN" || $jenis=="03TP" || $jenis=="03RN" || $jenis=="03WN"){
				$this->load->model("pemeriksaan/FNapza");
				$data = $this->FNapza->get_preview($sarana,$idperiksa, $jenis);
				$this->load->view('pemeriksaan/preview/napza/preview', $data);			  
			}else if($jenis=="03TR"){
				$this->load->model("pemeriksaan/F02TR");
				$data = $this->F02TR->get_preview($sarana,$idperiksa, $jenis);
				$this->load->view('pemeriksaan/preview/02TR/preview', $data);			  
			}else{				
				$this->load->model("pemeriksaan/".$mdl);
				$data = $this->$mdl->get_preview($sarana,$idperiksa, $jenis);				
				$this->load->view('pemeriksaan/preview/'.$jenis.'/preview', $data);			  				
			}
		}else{
			redirect(base_url());
			exit();		  
		}
	}
		
	function get_log($periksa_id=""){#Log Pengguna
		$query = "SELECT A.CREATE_DATE, +'<b>'+ B.NAMA_USER +'</b><div>@<b>'+ D.NAMA_BBPOM + '</b> <br>&raquo; <i>' + (CASE WHEN DATEDIFF(MONTH, A.CREATE_DATE, GETDATE()) = 0 THEN (CASE WHEN DATEDIFF(DAY, A.CREATE_DATE, GETDATE()) > 0 THEN CAST(DATEDIFF(DAY, A.CREATE_DATE, GETDATE()) AS VARCHAR) + ' Hari, ' ELSE '' END) + (CASE WHEN DATEDIFF(HOUR, A.CREATE_DATE, GETDATE()) > 0 THEN CAST(DATEDIFF(HOUR, A.CREATE_DATE, GETDATE())%24 AS VARCHAR) + ' Jam, ' ELSE '' END) + CAST(DATEDIFF(MINUTE, A.CREATE_DATE, GETDATE())%60 AS VARCHAR) + ' Menit Yang Lalu' ELSE 'Lebih Dari 1 Bulan Yang Lalu' END) + '</i></div>' AS DETIL, CAST(A.CATATAN AS VARCHAR(MAX))+ '<div> Status Pemeriksaan : '+ CAST(C.URAIAN AS VARCHAR(50)) + '</div>' AS CATATAN FROM T_PEMERIKSAAN_PROSES A LEFT JOIN T_USER B ON A.CREATE_BY = B.USER_ID LEFT JOIN M_TABEL C ON A.HASIL = C.KODE LEFT JOIN M_BBPOM D ON B.BBPOM_ID = D.BBPOM_ID WHERE A.PERIKSA_ID = '$periksa_id' AND C.JENIS = 'STATUS'";
		$this->load->library('newtable');
		$this->newtable->search(array(array('', '')));
		$this->newtable->hiddens(array('CREATE_DATE'));
		$this->newtable->action(site_url());
		$this->newtable->cidb($this->db);
		$this->newtable->ciuri($this->uri->segment_array());
		$this->newtable->orderby(1);
		$this->newtable->sortby("DESC");
		$this->newtable->keys("CREATE_DATE");
		$this->newtable->rowcount("ALL");
		$this->newtable->columns(array("A.CREATE_DATE","+'<b>'+ B.NAMA_USER +'</b><div>@<b>'+ D.NAMA_BBPOM + '</b> <br>&raquo; <i>' + (CASE WHEN DATEDIFF(MONTH, A.CREATE_DATE, GETDATE()) = 0 THEN (CASE WHEN DATEDIFF(DAY, A.CREATE_DATE, GETDATE()) > 0 THEN CAST(DATEDIFF(DAY, A.CREATE_DATE, GETDATE()) AS VARCHAR) + ' Hari, ' ELSE '' END) + (CASE WHEN DATEDIFF(HOUR, A.CREATE_DATE, GETDATE()) > 0 THEN CAST(DATEDIFF(HOUR, A.CREATE_DATE, GETDATE())%24 AS VARCHAR) + ' Jam, ' ELSE '' END) + CAST(DATEDIFF(MINUTE, A.CREATE_DATE, GETDATE())%60 AS VARCHAR) + ' Menit Yang Lalu' ELSE 'Lebih Dari 1 Bulan Yang Lalu' END) + '</i></div>'","CAST(A.CATATAN AS VARCHAR(MAX))+ '<div> Status Pemeriksaan : '+ CAST(C.URAIAN AS VARCHAR(50)) + '</div>'"));
		$this->newtable->width(array('DETIL' => 250));
		$this->newtable->show_chk(FALSE);
		$this->newtable->show_search(FALSE);
		$tabel = $this->newtable->generate($query);
		echo $tabel;
	}
	
	function set_detail_inspeksi($jenis="", $sarana=""){
		$mdl = "F".$jenis;
		$frm = "get_inspeksi";
		$this->load->model('pemeriksaan/'.$mdl);
		$arrdata = $this->$mdl->$frm($sarana);
		$this->load->view('pemeriksaan/preview/'.$jenis.'/inspeksi', $arrdata);
	}
	
	function set_temuan($jenis="", $sarana="", $periksa="",$isprev=""){
		if($this->newsession->userdata('LOGGED_IN') == "TRUE"){
			$mdl = "F".$jenis;
			$this->load->model("pemeriksaan/".$mdl);
			$data = $this->$mdl->get_temuan($sarana,$periksa,$isprev);
			$this->load->view('pemeriksaan/preview/'.$jenis.'/data_temuan', $data);			  
		}
	}

	function get_riwayat($periksa){#Log Pengguna echo $periksaA.CATATAN AS VARCHAR(100))
		$query = "SELECT Z.NAMA_USER AS [NAMA], STUFF(dbo.GROUP_ROLE(Z.USER_ID),1,1,'') AS ROLE,(CASE WHEN DATEDIFF(DAY, A.CREATE_DATE, GETDATE()) > 0 THEN CONVERT(VARCHAR(10), A.CREATE_DATE, 105)+'<div>'+CONVERT(VARCHAR(10), CREATE_DATE, 108)+'</div>' ELSE (CASE WHEN DATEDIFF(HOUR, CREATE_DATE, GETDATE()) > 0 THEN CAST(DATEDIFF(HOUR, A.CREATE_DATE, GETDATE())%24 AS VARCHAR) + ' Jam, ' ELSE '' END) + CAST(DATEDIFF(MINUTE, A.CREATE_DATE, GETDATE())%60 AS VARCHAR) + ' Menit Yang Lalu' END) AS WAKTU,'<div> Status Pemeriksaan : '+ C.URAIAN+'</div><div>'+CAST(A.CATATAN AS VARCHAR(MAX))+'</div>' AS CATATAN FROM T_PEMERIKSAAN_PROSES A LEFT JOIN T_USER Z ON A.CREATE_BY = Z.USER_ID LEFT JOIN M_TABEL C ON A.HASIL = C.KODE LEFT JOIN M_BBPOM D ON Z.BBPOM_ID = D.BBPOM_ID WHERE A.PERIKSA_ID = '$periksa' AND C.JENIS = 'STATUS'";
		$this->load->library('newtable');
		$this->newtable->search(array(array('', '')));
		$this->newtable->hiddens(array('CREATE_DATE'));
		$this->newtable->action(site_url());
		$this->newtable->cidb($this->db);
		$this->newtable->ciuri($this->uri->segment_array());
		$this->newtable->orderby(3);
		$this->newtable->sortby("DESC");
		$this->newtable->keys("CREATE_DATE");
		$this->newtable->rowcount("ALL");
		$this->newtable->columns(array("Z.NAMA_USER","STUFF(dbo.GROUP_ROLE(Z.USER_ID),1,1,'')","(CASE WHEN DATEDIFF(DAY, A.CREATE_DATE, GETDATE()) > 0 THEN CONVERT(VARCHAR(10), A.CREATE_DATE, 105)+'<div>'+CONVERT(VARCHAR(10), CREATE_DATE, 108)+'</div>' ELSE (CASE WHEN DATEDIFF(HOUR, CREATE_DATE, GETDATE()) > 0 THEN CAST(DATEDIFF(HOUR, A.CREATE_DATE, GETDATE())%24 AS VARCHAR) + ' Jam, ' ELSE '' END) + CAST(DATEDIFF(MINUTE, A.CREATE_DATE, GETDATE())%60 AS VARCHAR) + ' Menit Yang Lalu' END)","CAST(A.CATATAN AS VARCHAR(MAX))+ '<div> Status Pemeriksaan : '+ CAST(C.URAIAN AS VARCHAR(50)) + '</div>'"));
		$this->newtable->width(array('NAMA' => 150, 'ROLE' => 100, 'WAKTU' => '75', 'CATATAN' => '250'));
		$this->newtable->show_chk(FALSE);
		$this->newtable->show_search(FALSE);
		$tabel = $this->newtable->generate($query);
		echo $tabel;
	}
	
	function set_perbaikan($periksa_id="", $jenis=""){
		$mdl = "F".$jenis;
		if($jenis=="03TR"){
			$this->load->model('pemeriksaan/F02TR');
			$ret = $this->F02TR->get_perbaikan($periksa_id, $jenis);
		}else if($jenis=="01ON" || $jenis=="02MN" || $jenis=="02TN" || $jenis=="03AN" || $jenis=="03BN" || $jenis=="03NN" || $jenis=="03TP" || $jenis=="03RN" || $jenis=="03WN"){
			$this->load->model('pemeriksaan/FNapza');
			$ret = $this->FNapza->get_perbaikan($periksa_id);
		}else{
			$this->load->model('pemeriksaan/'.$mdl);
			$ret = $this->$mdl->get_perbaikan($periksa_id, $jenis);
		}
		echo $ret;
	}
	
	function get_perbaikan($sarana="",$jenis="",$periksa="",$id=""){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$this->load->model('pemeriksaan/TL_act');
			$arrdata = $this->TL_act->get_perbaikan($sarana,$jenis,$periksa,$id);
			$ret = $this->load->view('pemeriksaan/tl/perbaikan',$arrdata,true);
			echo $ret;
		}
	}
	
	function set_prev_surat($sarana="",$jenis="", $kk="",$periksa="",$sid=""){
		if($this->newsession->userdata('LOGGED_IN') == "TRUE"){
			$mdl = "F".$jenis;
			if($jenis=="03TR") $mdl = "F02TR";
			$this->load->model("pemeriksaan/".$mdl);
			$ret = $this->$mdl->prev_surat_tl($periksa);
			echo $ret;
		}
	}
	
	function set_surat_tl($sarana="",$jenis="",$periksa="",$id=""){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$this->load->model('pemeriksaan/TL_act');
			$arrdata = $this->TL_act->get_perbaikan($sarana,$jenis,$periksa,$id);
			$ret = $this->load->view('pemeriksaan/tl/perbaikan',$arrdata,true);
			echo $ret;
		}
	}


	function set_klasifikasi_sarana($jenis_sarana=""){#Klasifikasi Jenis Sarana
	  if($this->newsession->userdata('LOGGED_IN')){
			$sipt =& get_instance();
			$sipt->load->model("main","main", true);
			$query = "SELECT A.KK_ID, A.NAMA_KK FROM M_KLASIFIKASI_KATEGORI A LEFT JOIN M_JENIS_SARANA B ON A.JENIS_SARANA_ID = B.JENIS_SARANA_ID WHERE A.JENIS_SARANA_ID = '".$jenis_sarana."'";
			$res = $sipt->main->get_result($query);
			$hasil = "";
			if($res){
				$hasil .= '<option value="">&nbsp;</option>';
				foreach($query->result_array() as $row){
					$hasil .= '<option value="'.$row['KK_ID'].'">'.$row['NAMA_KK'].'</option>';
				}
			}
			echo $hasil;
		}else{
			redirect(base_url());
		}	  
	}

	function get_lap_bb($periksa_id){
		if($this->newsession->userdata('LOGGED_IN')){
			$sipt =& get_instance();
			$sipt->load->model("main","main", true);
			$query = "SELECT CASE WHEN PRODUK_BB = '01' THEN 'Larutan Formaldehid (Formalin)'
					  WHEN PRODUK_BB = '02' THEN 'Paraformaldehid serbuk'
					  WHEN PRODUK_BB = '03' THEN 'Paraformaldehidtablet'
					  WHEN PRODUK_BB = '04' THEN 'Boraks'
					  WHEN PRODUK_BB = '05' THEN 'Rhodamin B'
					  WHEN PRODUK_BB = '06' THEN 'Kuning Metanil'
					  WHEN PRODUK_BB = '07' THEN 'Auramin'
					  WHEN PRODUK_BB = '08' THEN 'Amaran' END AS PRODUK_BB,
					  PENGADAAN_SARANA, PENGADAAN_ALAMAT, dbo.GET_PROPINSI(PENGADAAN_DAERAH_ID) AS PENGADAAN_DAERAH_ID, PENGADAAN_STATUS, PENGADAAN_KEMASAN,
					  DISTRIBUSI_SARANA, DISTRIBUSI_ALAMAT, dbo.GET_PROPINSI(DISTRIBUSI_DAERAH_ID) AS DISTRIBUSI_DAERAH_ID, DISTRIBUSI_JENIS, DISTRIBUSI_TUJUAN,
					  KEMASAN, CASE WHEN REPACKING = 'T' THEN 'Tidak' WHEN REPACKING = 'Y' THEN 'Ya' END AS REPACKING, PENGADAAN_STATUS 
					  FROM T_PEMERIKSAAN_BB_LAPORAN WHERE PERIKSA_ID = '".$periksa_id."'";
			$data = $sipt->main->get_result($query);
			$ret = '<table class="tabelajax">';
			$ret .= '<tr class="head"><th>Bahan Berbahaya</th><th colspan="2">Kemasan</th><th colspan="3">Pengadaan</th><th colspan="3">Distribusi</th></tr>
					<tr class="head"><th>&nbsp;</th><th>Ukuran</th><th>Repacking</th><th>Nama <br />Alamat Pemasok</th><th>Status <br />Pemasok</th><th>Ukuran <br />Kemasan</th><th>Nama <br /> Alamat Pembeli</th><th>Jenis <br /> Sarana</th><th>Tujuan <br />Penggunaan</th></tr>';
			if($data){
				foreach($query->result_array() as $row){
					$ret .= '<tr><td>'.$row['PRODUK_BB'].'</td><td>'.$row['KEMASAN'].'</td><td>'.$row['REPACKING'].'</td><td>'.$row['PENGADAAN_SARANA'].'<br />'.$row['PENGADAAN_ALAMAT'].'<br>'.$row['PENGADAAN_DAERAH_ID'].'</td><td>'.$row['PENGADAAN_STATUS'].'</td><td>'.$row['PENGADAAN_KEMASAN'].'</td><td>'.$row['DISTRIBUSI_SARANA'].'<br />'.$row['DISTRIBUSI_ALAMAT'].'<br>'.$row['DISTRIBUSI_DAERAH_ID'].'</td><td>'.$row['DISTRIBUSI_JENIS'].'</td><td>'.$row['DISTRIBUSI_TUJUAN'].'</td></tr>';
					
				}
			}else{
				$ret .= '<tr><td colspan="9">Data tidak ditemukan</td></tr>';
			}
			$ret .= '</table>';
			echo $ret;
		}
	}
	
	function get_temuan_bb($periksa_id){
		if($this->newsession->userdata('LOGGED_IN')){
			$sipt =& get_instance();
			$sipt->load->model("main","main", true);
			$query = "SELECT PERIKSA_ID, SERI, NAMA_BB, NAMA_PRODUK, KEMASAN, KLASIFIKASI_PRODUK, SUMBER_PENGADAAN, NAMA_PERUSAHAAN, ALAMAT_PERUSAHAAN, TELEPON, CARA_PEMBELIAN, STATUS_REPACKING, LAMPIRAN FROM T_PEMERIKSAAN_TEMUAN_PRODUK WHERE PERIKSA_ID = '".$periksa_id."'";
			$data = $sipt->main->get_result($query);
			$ret = '<table class="tabelajax">';
			$ret .= '<tr class="head"><th>Bahan Berbahaya</th><th>Nama Sarana</th><th>Ukuran & <br /> Asal Bahan Berbahaya</th><th>Sumber Pengadaan</th><th>Cara Pembelian & <br />Status Produk</th></tr>';
			if($data){
				foreach($query->result_array() as $row){
					$ret .= '<tr><td>'.$row['NAMA_BB'].'</td><td>'.$row['NAMA_PERUSAHAAN'].'<br>'.$row['ALAMAT_PERUSAHAAN'].'<br>'.$row['TELEPON'].'</td><td>'.$row['KEMASAN'].'<br />'.$row['KLASIFIKASI_PRODUK'].'</td><td>'.$row['SUMBER_PENGADAAN'].'</td><td>'.$row['CARA_PEMBELIAN'].'<br />'.$row['STATUS'].'</td></tr>';		
				}
			}else{
				$ret .= '<tr><td colspan="5">Data tidak ditemukan</td></tr>';
			}
			$ret .= '</table>';
			echo $ret;
		}
	}	
	
	function get_periksa($periksa,$sarana){
		if(array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('9', $this->newsession->userdata('SESS_KODE_ROLE'))){
			$this->load->model('pemeriksaan/pemeriksaan_act');
			$arrdata = $this->pemeriksaan_act->get_header($periksa,$sarana);
			echo $this->load->view('pemeriksaan/edit-header',$arrdata, true);
		}
	}
	
	function get_tl_balai($periksa){
		if($this->newsession->userdata('LOGGED_IN')){
			$sipt =& get_instance();
			$sipt->load->model("main","main", true);
			$this->load->model('pemeriksaan/fnapza');
			$arrdata = $this->fnapza->get_tindakan($periksa);
			echo $this->load->view('pemeriksaan/preview/napza/edit-tindak-lanjut-balai',$arrdata, true);
		}
	}
	
	function input($perbaikan, $sarana, $periksa){
		if($this->newsession->userdata('LOGGED_IN')){
			$sipt =& get_instance();
			$sipt->load->model("main","main", true);
			$this->load->model('pemeriksaan/fnapza');
			$arrdata = $this->fnapza->input_perbaikan($periksa);
			echo $this->load->view('pemeriksaan/preview/napza/input-perbaikan-balai',$arrdata, true);
		}
	}
	
	function reupload_mapping($periksa, $jenis){
		if($this->newsession->userdata('LOGGED_IN')){
			$modul = 'f'.$jenis;
			$this->load->model('pemeriksaan/'.$modul);
			$arrdata = $this->$modul->get_reupload($periksa, $jenis);			  
			echo $this->load->view('pemeriksaan/reupload-mapping',$arrdata, true);
		}
	}
	
	function get_histori_pirt($periksaid){
		if($this->newsession->userdata('LOGGED_IN')){
			$this->load->model('pemeriksaan/f01vv');
			$arrdata = $this->f01vv->set_histori($periksaid);
			echo $this->load->view('pemeriksaan/preview/01VV/detil-histori',$arrdata,true);
		}
	}
	
	function del_pirt($id){
		if($this->newsession->userdata('LOGGED_IN')){
			$arrid = explode("-",$id);
			$this->db->where('SARANA_ID', $arrid[0]);
			$this->db->where('SERI', $arrid[1]);
			$this->db->delete('T_SARANA_JENIS_PANGAN');
			if($this->db->affected_rows() > 0){
				echo "MSG#YES#Data jenis pangan berhasil dihapus";
			}else{
				echo "MSG#NO#Data jenis pangan gagal dihapus";
			}
		}
	}
	
	function jenis_pangan($sarana){
		if($this->newsession->userdata('LOGGED_IN')){
			$this->load->model('pemeriksaan/f01vv');
			$arrdata = $this->f01vv->get_jenis_pangan($sarana);
			echo $this->load->view('master/jenis_pangan',$arrdata,true);
				
		}
	}
	
}
?>