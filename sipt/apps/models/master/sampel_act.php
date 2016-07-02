<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Sampel_act extends Model{

	function getFormSampel($id){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$sipt->load->model("main", "main", true);
			if($id==""){#Input Mode
				$master_sampel = $sipt->main->get_uraian("SELECT COUNT(*) AS MASTER_SAMPEL FROM M_SAMPEL","MASTER_SAMPEL");
				$arrdata = array('act' => site_url().'/master/master/save/sampel/simpan',
							  'ujiulang_' => '',
							  'produk_' => '',
							  'klasifikasi_' => '',
							  'kkid_' => '',
							  'namaproduk_' => '',
							  'nomorreg_' => '',
							  'kategori_' => '',
							  'namasarana_' => '',
							  'pengirim_' => '',
							  'waktusampling_' => '',
							  'tempatsampling_' => '',
							  'alamatsampling_' => '',
							  'kotasampling_' => '',
							  'asalsampel_' => '',
							  'waktuterima_' => '',
							  'nomorregsampel_' => '',
							  'nomorbets_' => '',
							  'kodeproduksi_' => '',
							  'nomorlab_' => '',
							  'penglabel_' => '',
							  'flaglabel_' => '',
							  'jumlahsampel_' => '',
							  'netto_' => '',
							  'satuan_' => '',
							  'kemasan_' => '',
							  'harga_' => '',
							  'waktuexpired_' => '',
							  'urlback' => current_url(),
							  'master_sampel' => $master_sampel,
							  'urlmaster_sampel' => site_url().'/home/master/sampel/view');
			}
			return $arrdata;
		}
		else
		{
			$this->fungsi->redirectMessage('Maaf, halaman yang anda tuju tidak ditemukan.','/home');
		}
	}

	function getPreview($id){
	}
	
	function SaveForm($setaction, $isajax){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main","main", true);
			if($setaction=="simpan"){#Insert Mode
				return "MSG#YES#Data berhasil disimpan#".site_url().'/home/master/sampel';
			}
			else if($setaction=="update"){#Update Mode
				return "MSG#YES#Data berhasil disimpan";
			}
			
			if($isajax!="ajax"){
				redirect(site_url().'/home/master/sampel');
				exit();
			}
			return "MSG#NO#Data gagal disimpan";
		}
		else{
			$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
		}
	}


	function mastersampel(&$content){
		if(in_array(2, $this->newsession->userdata('SESS_KODE_ROLE')) || in_array(3, $this->newsession->userdata('SESS_KODE_ROLE')) || $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$user_id = $this->newsession->userdata("SESS_USER_ID");
			$sipt =& get_instance();
			$sipt->load->model("main", "main", true);
			$master_sampel = $sipt->main->get_uraian("SELECT COUNT(*) AS MASTER_SAMPEL FROM M_SAMPEL","MASTER_SAMPEL");
			$data = array('act' => site_url().'/sampel/save',
						  'ujiulang_' => '',
						  'produk_' => '',
						  'klasifikasi_' => '',
						  'kkid_' => '',
						  'namaproduk_' => '',
						  'nomorreg_' => '',
						  'kategori_' => '',
						  'namasarana_' => '',
						  'pengirim_' => '',
						  'waktusampling_' => '',
						  'tempatsampling_' => '',
						  'alamatsampling_' => '',
						  'kotasampling_' => '',
						  'asalsampel_' => '',
						  'waktuterima_' => '',
						  'nomorregsampel_' => '',
						  'nomorbets_' => '',
						  'kodeproduksi_' => '',
						  'nomorlab_' => '',
						  'penglabel_' => '',
						  'flaglabel_' => '',
						  'jumlahsampel_' => '',
						  'netto_' => '',
						  'satuan_' => '',
						  'kemasan_' => '',
						  'harga_' => '',
						  'waktuexpired_' => '',
						  'urlback' => current_url(),
						  'urldirection' => site_url().'/home/master/sampel',
						  'master_sampel' => $master_sampel,
						  'urlmaster_sampel' => site_url().'/home/master/sampel/view');
			$content = $this->load->view('master/sampel', $data, true);
			return true;
		}
		else{
			
			$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
		}
	}
	
	function listview(&$content){
		if($this->newsession->userdata('LOGGED_IN') == TRUE){
			if($this->uri->segment(4, "") == "view"){//View Mode
				require_once(APPPATH.'libraries/simpeltabel.php');
				$sipt=& get_instance();
				$sipt->load->model("main","main", true);
				//Search Column
				$getcolumn = $sipt->main->get_celcombo("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'M_SAMPEL'");
				$formsearch = "<form action='".site_url()."/home/search/sampel' autocomplete='off' method='post'>
							   <table cellpadding='0' cellspacing='0' width='100%'>
							   <tr><td width='200'>Pencarian Berdasarkan</td><td>";
				$formsearch .= "<select name='column_' id='column_' class='stext'>";
							   if($getcolumn){
								   foreach($getcolumn as $columname){
				$formsearch .= "<option value='".$columname->COLUMN_NAME."'>".$columname->COLUMN_NAME."</option>";					   
								   }
							   }
				$formsearch .= "</select>";			 

				$formsearch .= "</td></tr>
							   <tr><td>Operator</td><td>
							   <select name='operand_' id='operand_' class='stext'>
							   <option value='' selected='selected'>Operator</option>
							   <option value='='>=</option>
							   <option value='>'>></option>
							   <option value='>='>>=</option>
							   <option value='<'><</option>
							   <option value='<='><=</option>
							   <option value='LIKE'>LIKE</option>
							   </select>
							   </td></tr>
							   <tr><td>Filter Pencarian</td><td><input type='text' class='stext' name='keyword_' id='keyword'></td></tr>
							   <tr><td colspan='2'><input type='submit' name='submitsearch_' id='submitsearch_' value='Cari' class='ui-widget-header ui-state-default'></td></tr>
							   </table>
							   </form>";
				//End Search Column		   
				$count_data = $sipt->main->get_count("M_SAMPEL", "SELECT * FROM M_SAMPEL ORDER BY SAMPEL_ID ASC");
				$total_page = $count_data['results_count'];
				$limit = 10;
				$per_page = 10;
				$this->uri->segment(5, 0) ? $this->uri->segment(5, 0) : 0;
				$list = $sipt->main->paginated($limit, $this->uri->segment(5), "SELECT TOP $limit *, CONVERT(VARCHAR(10), WAKTU_SAMPLING, 103) AS NEW_WAKTU_SAMPLING FROM M_SAMPEL ORDER BY SAMPEL_ID ASC", "SELECT TOP $limit *, CONVERT(VARCHAR(10), WAKTU_SAMPLING, 103) AS NEW_WAKTU_SAMPLING FROM M_SAMPEL WHERE SAMPEL_ID NOT IN( SELECT TOP ".$this->uri->segment(5)." SAMPEL_ID FROM M_SAMPEL ORDER BY SAMPEL_ID ASC) ORDER BY SAMPEL_ID ASC");
				$paging = $sipt->main->getPagination($total_page,10,'/home/master/sampel/view',5);
				$tb = new Simpeltabel();
				$tb->jumKolom = 7;
				$tb->tableWidth = "100%";
				$tb->tabelid = "mytabel";
				$tb->classHeading = "ui-widget-content ui-state-default";				
$tb->classFooter = "ui-widget-content ui-state-default";
				$tb->cellborder = "";
				$tb->cellspacing = 0;
				$tb->cellpadding = 0;
				$tb->colspanfooter = 7;
				$tb->alignfooter = "left";
				$tb->footer = '<div class="nav"><span class="navlink"><span id="loadsmall_" style="display:none;"><img src="'.base_url().'assets/images/loadingsmall_.gif" align="absmiddle"></span> ';
				if($paging){
					$tb->footer .= $paging.'&nbsp;<input type="hidden" id="goto_" url="'.site_url().'/home/master/sampel/view'.'" ></span>';
				}
				else{
					$tb->footer .= '&nbsp';
				}
				$tb->footer .= '</div><div class="jml">Total Data  : &nbsp;'.$total_page.'</div>';
				$tb->headings = array("OPSI", "SAMPEL ID","PENGIRIM", "WAKTU SAMPLING","TEMPAT SAMPLING","ALAMAT", "JUMLAH");
				$tb->lebarKolom = array("6%","auto","auto","auto","auto","auto","auto");
				$tb->alignKolom = array("center", "justify", "justify", "justify", "justify", "justify", "justify");
				if($list){
					  foreach($list as $row){
						  $tb->idTr[] = $row->SAMPEL_ID;
						  $newRow = array($this->fungsi->detail("home/master/sampel/detail", $row->SAMPEL_ID).$this->fungsi->edit("home/master/sampel/edit", $row->SAMPEL_ID).$this->fungsi->hapus("sampel/hapus", $row->SAMPEL_ID), $row->SAMPEL_ID, $row->PENGIRIM, $row->NEW_WAKTU_SAMPLING, $row->TEMPAT_SAMPLING, $row->ALAMAT_SAMPLING, $row->JUMLAH_SAMPEL);
						  $htmltable = $tb->tambahBaris($newRow);
					  }
					$htmltable .= $tb->cetakTabel();
					$htmltable .= '<div id="clear_fix"></div>';
				}else{
					$htmltable = '<p id="not_found" class="ui-corner-all ui-state-error">Not Found 404</p>';
				}
				$data = array('pager' => 'sampel',
							  'formsearch' => $formsearch,
							  'htmltable' => $htmltable,
							  'judul' => 'Master Data Sampel');
				$content = $this->load->view('htmltabel/list', $data, true);
				return true;		
			}
			
			else if($this->uri->segment(4,"") == "edit" && $this->uri->segment(5, 0) > 0){//Edit Mode
				$user_id = $this->newsession->userdata("SESS_USER_ID");
				$sipt =& get_instance();
				$sipt->load->model("main", "main", true);
				$sampel_id = $this->uri->segment(5, "");
				$qdetail = "SELECT M_SAMPEL.*, CONVERT(VARCHAR(10), M_SAMPEL.WAKTU_SAMPLING, 103) AS WAKTU_SAMPLING, CONVERT(VARCHAR(10), M_SAMPEL.WAKTU_TERIMA, 103) AS WAKTU_TERIMA, CONVERT(VARCHAR(10), M_SAMPEL.WAKTU_EXPIRED, 103) AS WAKTU_EXPIRED, M_PRODUK.PRODUK_ID, M_SARANA.SARANA_ID, M_PRODUK.NOMOR_REG AS NOMORREG, M_PRODUK.SARANA_ID, M_PRODUK.NAMA_PRODUK, M_KLASIFIKASI_KATEGORI.KK_ID, M_KLASIFIKASI_KATEGORI.NAMA_KK, M_PRODUK.KK_ID, M_SARANA.NAMA_SARANA FROM M_SAMPEL INNER JOIN M_PRODUK ON M_SAMPEL.PRODUK_ID = M_PRODUK.PRODUK_ID INNER JOIN M_SARANA ON M_PRODUK.SARANA_ID = M_SARANA.SARANA_ID INNER JOIN M_KLASIFIKASI_KATEGORI ON M_PRODUK.KK_ID = M_KLASIFIKASI_KATEGORI.KK_ID WHERE M_SAMPEL.SAMPEL_ID='$sampel_id'";
				if($sipt->main->get_result($qdetail)){
					$rdetail = $qdetail->row();
				}
				$master_sampel = $sipt->main->get_uraian("SELECT COUNT(*) AS MASTER_SAMPEL FROM M_SAMPEL","MASTER_SAMPEL");
				$data = array('act' => site_url().'/sampel/update/'.$sampel_id,
							  'ujiulang_' => $rdetail->UJI_ULANG,
							  'produk_' => $rdetail->PRODUK_ID,
							  'klasifikasi_' => $rdetail->NAMA_KK,
							  'kkid_' => $rdetail->KK_ID,
							  'namaproduk_' => $rdetail->NAMA_PRODUK,
							  'nomorreg_' => $rdetail->NOMORREG,
							  'kategori_' => $rdetail->NAMA_KK,
							  'namasarana_' => $rdetail->NAMA_SARANA,
							  'pengirim_' => $rdetail->PENGIRIM,
							  'waktusampling_' => $rdetail->WAKTU_SAMPLING,
							  'tempatsampling_' => $rdetail->TEMPAT_SAMPLING,
							  'alamatsampling_' => $rdetail->ALAMAT_SAMPLING,
							  'kotasampling_' => $rdetail->KOTA_SAMPLING,
							  'asalsampel_' => $rdetail->ASAL_SAMPEL,
							  'waktuterima_' => $rdetail->WAKTU_TERIMA,
							  'nomorregsampel_' => $rdetail->NOMOR_REG,
							  'nomorbets_' => $rdetail->NOMOR_BETS,
							  'kodeproduksi_' => $rdetail->KODE_PRODUKSI,
							  'nomorlab_' => $rdetail->NOMOR_LAB,
							  'penglabel_' => $rdetail->PENG_LABEL,
							  'flaglabel_' => $rdetail->FLAG_LABEL,
							  'jumlahsampel_' => $rdetail->JUMLAH_SAMPEL,
							  'pengmikro_' => $rdetail->PENG_MIKRO,
							  'pengkimfis_' => $rdetail->PENG_KIM_FIS,
							  'flagmikro_' => $rdetail->FLAG_MIKRO,
							  'flagkimfis_' => $rdetail->FLAG_KIM_FIS,
							  'netto_' => $rdetail->NETTO,
							  'satuan_' => $rdetail->SATUAN,
							  'kemasan_' => $rdetail->KEMASAN,
							  'harga_' => $rdetail->HARGA,
							  'waktuexpired_' => $rdetail->WAKTU_EXPIRED,
							  'urlback' => site_url().'/home/master/sampel',
							  'urldirection' => site_url().'/home/master/sampel',
							  'master_sampel' => $master_sampel,
							  'urlmaster_sampel' => site_url().'/home/master/sampel/view');
				$content = $this->load->view('master/sampel', $data, true);
				return true;
			}
			else if($this->uri->segment(4,"") == "detail" && $this->uri->segment(5, 0) > 0){//Detail Mode
				$user_id = $this->newsession->userdata("SESS_USER_ID");
				$sipt =& get_instance();
				$sipt->load->model("main", "main", true);
				$sampel_id = $this->uri->segment(5, "");
				$qdetail = "SELECT M_SAMPEL.*, CONVERT(VARCHAR(10), M_SAMPEL.WAKTU_SAMPLING, 103) AS WAKTU_SAMPLING, CONVERT(VARCHAR(10), M_SAMPEL.WAKTU_TERIMA, 103) AS WAKTU_TERIMA, CONVERT(VARCHAR(10), M_SAMPEL.WAKTU_EXPIRED, 103) AS WAKTU_EXPIRED, M_PRODUK.PRODUK_ID, M_SARANA.SARANA_ID, M_PRODUK.NOMOR_REG AS NOMORREG, M_PRODUK.SARANA_ID, M_PRODUK.NAMA_PRODUK, M_KLASIFIKASI_KATEGORI.KK_ID, M_KLASIFIKASI_KATEGORI.NAMA_KK, M_PRODUK.KK_ID, M_SARANA.NAMA_SARANA FROM M_SAMPEL INNER JOIN M_PRODUK ON M_SAMPEL.PRODUK_ID = M_PRODUK.PRODUK_ID INNER JOIN M_SARANA ON M_PRODUK.SARANA_ID = M_SARANA.SARANA_ID INNER JOIN M_KLASIFIKASI_KATEGORI ON M_PRODUK.KK_ID = M_KLASIFIKASI_KATEGORI.KK_ID WHERE M_SAMPEL.SAMPEL_ID='$sampel_id'";
				if($sipt->main->get_result($qdetail)){
					$rdetail = $qdetail->row();
				}
				$master_sampel = $sipt->main->get_uraian("SELECT COUNT(*) AS MASTER_SAMPEL FROM M_SAMPEL","MASTER_SAMPEL");
				$data = array('ujiulang_' => $rdetail->UJI_ULANG,
							  'produk_' => $rdetail->PRODUK_ID,
							  'klasifikasi_' => $rdetail->NAMA_KK,
							  'kkid_' => $rdetail->KK_ID,
							  'namaproduk_' => $rdetail->NAMA_PRODUK,
							  'nomorreg_' => $rdetail->NOMORREG,
							  'kategori_' => $rdetail->NAMA_KK,
							  'namasarana_' => $rdetail->NAMA_SARANA,
							  'pengirim_' => $rdetail->PENGIRIM,
							  'waktusampling_' => $rdetail->WAKTU_SAMPLING,
							  'tempatsampling_' => $rdetail->TEMPAT_SAMPLING,
							  'alamatsampling_' => $rdetail->ALAMAT_SAMPLING,
							  'kotasampling_' => $rdetail->KOTA_SAMPLING,
							  'asalsampel_' => $rdetail->ASAL_SAMPEL,
							  'waktuterima_' => $rdetail->WAKTU_TERIMA,
							  'nomorregsampel_' => $rdetail->NOMOR_REG,
							  'nomorbets_' => $rdetail->NOMOR_BETS,
							  'kodeproduksi_' => $rdetail->KODE_PRODUKSI,
							  'nomorlab_' => $rdetail->NOMOR_LAB,
							  'penglabel_' => $rdetail->PENG_LABEL,
							  'flaglabel_' => $rdetail->FLAG_LABEL,
							  'jumlahsampel_' => $rdetail->JUMLAH_SAMPEL,
							  'pengmikro_' => $rdetail->PENG_MIKRO,
							  'pengkimfis_' => $rdetail->PENG_KIM_FIS,
							  'flagmikro_' => $rdetail->FLAG_MIKRO,
							  'flagkimfis_' => $rdetail->FLAG_KIM_FIS,
							  'netto_' => $rdetail->NETTO,
							  'satuan_' => $rdetail->SATUAN,
							  'kemasan_' => $rdetail->KEMASAN,
							  'harga_' => $rdetail->HARGA,
							  'waktuexpired_' => $rdetail->WAKTU_EXPIRED,
							  'urlback' => site_url().'/home/master/sampel',
							  'urldirection' => site_url().'/home/master/sampel',
							  'master_sampel' => $master_sampel,
							  'urlmaster_sampel' => site_url().'/home/master/sampel/view');
				$content = $this->load->view('detail/sampel', $data, true);
				return true;				
			}
			
			
		}
		else{
			
			$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
		}
	}

	function save($isajax){
		if($this->newsession->userdata('LOGGED_IN') == TRUE){
			$sipt =& get_instance();
			$this->load->model("main","main", true);
			$gen = $sipt->main->gen_noid("SELECT SUBSTRING(SAMPEL_ID,9,6) AS MAXI FROM M_SAMPEL", "MAXI", "6", "SPL");
			foreach($this->input->post('pengmikro_') as $valPengmikro){
				$pengmikro = $valPengmikro;
			}
			foreach($this->input->post('pengkimfis_') as $valPengkimfis){
				$pengkimfis = $valPengkimfis;
			}
			foreach($this->input->post('flagmikro_') as $valFlagmikro){
				$flagmikro = $valFlagmikro;
			}
			foreach($this->input->post('flagkimfis_') as $valFlagkimfis){
				$flagkimfis = $valFlagkimfis;
			}
			$data = array('SAMPEL_ID' => $gen,
						  'UJI_ULANG' => $this->input->post('ujiulang_'),
						  'KK_ID' => $this->input->post('kkid_'),
						  'PRODUK_ID' => $this->input->post('produk_'),
						  'PENGIRIM' => $this->input->post('pengirim_'),
						  'WAKTU_SAMPLING' => $this->input->post('waktusampling_'),
						  'TEMPAT_SAMPLING' => $this->input->post('tempatsampling_'),
						  'ALAMAT_SAMPLING' => $this->input->post('alamatsampling_'),
						  'KOTA_SAMPLING' => $this->input->post('kotasampling_'),
						  'WAKTU_TERIMA' => $this->input->post('waktuterima_'),
						  'NOMOR_REG' => $this->input->post('nomorregsampel_'),
						  'NOMOR_BETS' => $this->input->post('nomorbets_'),
						  'NOMOR_LAB' => $this->input->post('nomorlab_'),
						  'KODE_PRODUKSI' => $this->input->post('kodeproduksi_'),
						  'WAKTU_EXPIRED' => $this->input->post('waktuexpired_'),
						  'PENG_MIKRO' => $pengmikro,
						  'PENG_KIM_FIS' => $pengkimfis,
						  'PENG_LABEL' => $this->input->post('penglabel_'),
						  'FLAG_MIKRO' => $flagmikro,
						  'FLAG_KIM_FIS' => $flagkimfis,
						  'FLAG_LABEL' => $this->input->post('flaglabel_'),
						  'JUMLAH_SAMPEL' => $this->input->post('jumlahsampel_'),
						  'BBPOM_ID' => $this->newsession->userdata('SESS_BBPOM_ID'),
						  'ASAL_SAMPEL' => $this->input->post('asalsampel_'),
						  'NETTO' => $this->input->post('netto_'),
						  'SATUAN' => $this->input->post('satuan_'),
						  'KEMASAN' => $this->input->post('kemasan_'),
						  'HARGA' => $this->input->post('harga_'),
						  'CREATE_BY' => $this->newsession->userdata('SESS_USER_ID'),
						  'CREATE_DATE' => "GETDATE()");
			if($this->db->insert('M_SAMPEL', $data)){
				if($isajax!="ajax"){
					//redirect(site_url()."/home/master/sampel");
					//exit();
					$this->fungsi->redirectMessage('','/home/master/sampel');
				}
				return "YES";
			}
			if($isajax!="ajax"){
				//redirect(site_url().'/home/master/sampel');
				//exit();
				$this->fungsi->redirectMessage('','/home/master/sampel');
			}
			return "NO";
		}
		else
		{
			
			$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
		}
	}
	
	function update($id, $isajax){
		if($this->newsession->userdata('LOGGED_IN')==TRUE){
			foreach($this->input->post('pengmikro_') as $valPengmikro){
				$pengmikro = $valPengmikro;
			}
			foreach($this->input->post('pengkimfis_') as $valPengkimfis){
				$pengkimfis = $valPengkimfis;
			}
			foreach($this->input->post('flagmikro_') as $valFlagmikro){
				$flagmikro = $valFlagmikro;
			}
			foreach($this->input->post('flagkimfis_') as $valFlagkimfis){
				$flagkimfis = $valFlagkimfis;
			}
			$data = array('UJI_ULANG' => $this->input->post('ujiulang_'),
						  'KK_ID' => $this->input->post('kkid_'),
						  'PRODUK_ID' => $this->input->post('produk_'),
						  'PENGIRIM' => $this->input->post('pengirim_'),
						  'WAKTU_SAMPLING' => $this->input->post('waktusampling_'),
						  'TEMPAT_SAMPLING' => $this->input->post('tempatsampling_'),
						  'ALAMAT_SAMPLING' => $this->input->post('alamatsampling_'),
						  'KOTA_SAMPLING' => $this->input->post('kotasampling_'),
						  'WAKTU_TERIMA' => $this->input->post('waktuterima_'),
						  'NOMOR_REG' => $this->input->post('nomorregsampel_'),
						  'NOMOR_BETS' => $this->input->post('nomorbets_'),
						  'NOMOR_LAB' => $this->input->post('nomorlab_'),
						  'KODE_PRODUKSI' => $this->input->post('kodeproduksi_'),
						  'WAKTU_EXPIRED' => $this->input->post('waktuexpired_'),
						  'PENG_MIKRO' => $pengmikro,
						  'PENG_KIM_FIS' => $pengkimfis,
						  'PENG_LABEL' => $this->input->post('penglabel_'),
						  'FLAG_MIKRO' => $flagmikro,
						  'FLAG_KIM_FIS' => $flagkimfis,
						  'FLAG_LABEL' => $this->input->post('flaglabel_'),
						  'JUMLAH_SAMPEL' => $this->input->post('jumlahsampel_'),
						  'BBPOM_ID' => $this->newsession->userdata('SESS_BBPOM_ID'),
						  'ASAL_SAMPEL' => $this->input->post('asalsampel_'),
						  'NETTO' => $this->input->post('netto_'),
						  'SATUAN' => $this->input->post('satuan_'),
						  'KEMASAN' => $this->input->post('kemasan_'),
						  'HARGA' => $this->input->post('harga_'),
						  'UPDATE_DATE' => "GETDATE()",
						  'UPDATE_BY' => $this->newsession->userdata('SESS_USER_ID'));
			  $this->db->where('SAMPEL_ID', $id);
			  if($this->db->update('M_SAMPEL', $data)){
				  if($isajax!="ajax"){
					  //redirect(site_url().'/home/pemeriksaan');
					  //exit();
					  $this->fungsi->redirectMessage('','/home/master/sampel');
				  }
				  return "YES";
			  }
			  if($isajax!="ajax"){
				  //redirect(site_url().'/home/pemeriksaan');
				  //exit();
				  $this->fungsi->redirectMessage('','/home/master/sampel');
			  }
			  return "NO";
		}else{
			
			$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
		}
	}
	
	function delete($id, $isajax){
		if($this->newsession->userdata('LOGGED_IN') == TRUE){
			if($this->db->delete('M_SAMPEL', array("SAMPEL_ID" => $id))){
				if($isajax!="ajax"){
					//redirect(site_url().'/home/master/sampel');
					//exit();
					$this->fungsi->redirectMessage('','/home/master/sampel');
				}
			   return "YES";
			}
			if($isajax!="ajax"){
				//redirect(site_url().'/home/master/sampel');
				//exit();
				$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home/master/sampel');
			}
			return "NO";
		}else{
			
			$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
		}
	}
	
}
?>