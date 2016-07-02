<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Kategori_act extends Model{
	function kategori_01($id){
		if((in_array('1', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('9', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('4', $this->newsession->userdata('SESS_KODE_ROLE'))) && $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$sipt->load->model("main", "main", true);
			$this->load->library('newtable');
			if($id == '0101'){
				$query = "SELECT D.KLASIFIKASI_ID, A.KLASIFIKASI AS KATEGORI, B.KLASIFIKASI AS [ZAT AKTIF], C.KLASIFIKASI AS [BAHAN AKTIF],
						  D.KLASIFIKASI AS [BENTUK SEDIAAN]
						  FROM M_GOLONGAN_NEW A
						  JOIN M_GOLONGAN_NEW B ON A.KLASIFIKASI_ID = B.KLASIFIKASI_PARENT
						  JOIN M_GOLONGAN_NEW C ON B.KLASIFIKASI_ID = C.KLASIFIKASI_PARENT
						  JOIN M_GOLONGAN_NEW D ON C.KLASIFIKASI_ID = D.KLASIFIKASI_PARENT
						  WHERE LEFT(A.KLASIFIKASI_ID,2) = '01' AND LEFT(A.KLASIFIKASI_ID,4) = '".$id."'";							  
				$this->newtable->columns(array("D.KLASIFIKASI_ID", "A.KLASIFIKASI", "B.KLASIFIKASI", "C.KLASIFIKASI","D.KLASIFIKASI"));
				$this->newtable->width(array('KATEGORI' => 100, 'ZAT AKTIF' => 150, 'BAHAN AKTIF' => 150, 'BENTUK SEDIAAN' => 150));
				$this->newtable->search(array(array("B.KLASIFIKASI","Zat Aktif"),
											  array("C.KLASIFIKASI","Bahan Aktif"),
											  array("D.KLASIFIKASI","Bentuk Sediaan")));
			}else if($id == '0102'){
				$query = "SELECT D.KLASIFIKASI_ID, A.KLASIFIKASI AS KATEGORI, B.KLASIFIKASI AS [ZAT AKTIF], C.KLASIFIKASI AS [BENTUK SEDIAAN],
						  D.KLASIFIKASI AS [SEDIAAN PUSTAKA]
						  FROM M_GOLONGAN_NEW A
						  JOIN M_GOLONGAN_NEW B ON A.KLASIFIKASI_ID = B.KLASIFIKASI_PARENT
						  JOIN M_GOLONGAN_NEW C ON B.KLASIFIKASI_ID = C.KLASIFIKASI_PARENT
						  JOIN M_GOLONGAN_NEW D ON C.KLASIFIKASI_ID = D.KLASIFIKASI_PARENT
						  WHERE LEFT(A.KLASIFIKASI_ID,2) = '01' AND LEFT(A.KLASIFIKASI_ID,4) = '".$id."'";							  
				$this->newtable->columns(array("D.KLASIFIKASI_ID", "A.KLASIFIKASI", "B.KLASIFIKASI", "C.KLASIFIKASI","D.KLASIFIKASI"));
				$this->newtable->width(array('KATEGORI' => 100, 'ZAT AKTIF' => 150, 'BENTUK SEDIAAN' => 150, 'SEDIAAN PUSTAKA' => 150));
				$this->newtable->search(array(array("B.KLASIFIKASI","Zat Aktif"),
											  array("C.KLASIFIKASI","Bentuk Sediaan"),
											  array("D.KLASIFIKASI","Sediaan Pustaka")));
			}else if($id == '0103'){
				$query = "SELECT D.KLASIFIKASI_ID, A.KLASIFIKASI AS KATEGORI, B.KLASIFIKASI AS [NAMA OBAT],
						  E.SATUAN_KEMASAN AS [SATUAN KEMASAN],
						  C.KLASIFIKASI AS [ZAT AKTIF], D.KLASIFIKASI AS [SEDIAAN PUSTAKA]
						  FROM M_GOLONGAN_NEW A JOIN M_GOLONGAN_NEW B ON A.KLASIFIKASI_ID = B.KLASIFIKASI_PARENT
						  JOIN M_GOLONGAN_NEW C ON B.KLASIFIKASI_ID = C.KLASIFIKASI_PARENT
						  JOIN M_GOLONGAN_NEW D ON C.KLASIFIKASI_ID = D.KLASIFIKASI_PARENT
						  JOIN M_GOLONGAN_KEMASAN E ON D.KLASIFIKASI_ID = E.KLASIFIKASI_ID
						  WHERE LEFT(A.KLASIFIKASI_ID,2) = '01' AND LEFT(A.KLASIFIKASI_ID,4) = '".$id."'";							  
				$this->newtable->columns(array("D.KLASIFIKASI_ID", "A.KLASIFIKASI", "B.KLASIFIKASI", "E.SATUAN_KEMASAN","C.KLASIFIKASI", "D.KLASIFIKASI"));
				$this->newtable->width(array('KATEGORI' => 100, 'NAMA OBAT' => 150, 'SATUAN KEMASAN' => 150, 'ZAT AKTIF' => 150, 'SEDIAAN PUSTAKA' => 150));
				$this->newtable->search(array(array("B.KLASIFIKASI","Nama Obat"),
											  array("E.SATUAN_KEMASAN","Satuan Kemasan"),
											  array("C.KLASIFIKASI","Zat Aktif"),
											  array("D.KLASIFIKASI","Sediaan Pustaka")));
			}else if($id == '0104'){
				$query = "SELECT D.KLASIFIKASI_ID, A.KLASIFIKASI AS KATEGORI, B.KLASIFIKASI AS [ZAT AKTIF], C.KLASIFIKASI AS [BENTUK SEDIAAN],
						  D.KLASIFIKASI AS [SEDIAAN PUSTAKA]
						  FROM M_GOLONGAN_NEW A
						  JOIN M_GOLONGAN_NEW B ON A.KLASIFIKASI_ID = B.KLASIFIKASI_PARENT
						  JOIN M_GOLONGAN_NEW C ON B.KLASIFIKASI_ID = C.KLASIFIKASI_PARENT
						  JOIN M_GOLONGAN_NEW D ON C.KLASIFIKASI_ID = D.KLASIFIKASI_PARENT
						  WHERE LEFT(A.KLASIFIKASI_ID,2) = '01' AND LEFT(A.KLASIFIKASI_ID,4) = '".$id."'";							  
				$this->newtable->columns(array("D.KLASIFIKASI_ID", "A.KLASIFIKASI", "B.KLASIFIKASI", "C.KLASIFIKASI","D.KLASIFIKASI"));
				$this->newtable->width(array('KATEGORI' => 100, 'ZAT AKTIF' => 150, 'BENTUK SEDIAAN' => 150, 'SEDIAAN PUSTAKA' => 150));
				$this->newtable->search(array(array("B.KLASIFIKASI","Zat Aktif"),
											  array("C.KLASIFIKASI","Bentuk Sediaan"),
											  array("D.KLASIFIKASI","Sediaan Pustaka")));
			}else if($id == '0105'){
				$query = "SELECT D.KLASIFIKASI_ID, A.KLASIFIKASI AS KATEGORI, B.KLASIFIKASI AS [NAMA OBAT], C.KLASIFIKASI AS [BAHAN AKTIF],
						  D.KLASIFIKASI AS [BENTUK SEDIAAN], E.KLASIFIKASI AS [NAMA PABRIK]
						  FROM M_GOLONGAN_NEW A
						  JOIN M_GOLONGAN_NEW B ON A.KLASIFIKASI_ID = B.KLASIFIKASI_PARENT
						  JOIN M_GOLONGAN_NEW C ON B.KLASIFIKASI_ID = C.KLASIFIKASI_PARENT
						  JOIN M_GOLONGAN_NEW D ON C.KLASIFIKASI_ID = D.KLASIFIKASI_PARENT
						  JOIN M_GOLONGAN_NEW E ON D.KLASIFIKASI_ID = E.KLASIFIKASI_PARENT
						  WHERE LEFT(A.KLASIFIKASI_ID,2) = '01' AND LEFT(A.KLASIFIKASI_ID,4) = '".$id."'";							  
				$this->newtable->columns(array("D.KLASIFIKASI_ID", "A.KLASIFIKASI", "B.KLASIFIKASI", "C.KLASIFIKASI","D.KLASIFIKASI","E.KLASIFIKASI"));
				$this->newtable->width(array('KATEGORI' => 100, 'NAMA OBAT' => 150, 'BAHAN AKTIF' => 150, 'BENTUK SEDIAAN' => 150, 'NAMA PABRIK' => 150));
				$this->newtable->search(array(array("B.KLASIFIKASI","Nama Obat"),
											  array("C.KLASIFIKASI","Bahan Aktif"),
											  array("D.KLASIFIKASI","Sediaan Pustaka"),
											  array("E.KLASIFIKASI","Nama Pabrik")));
			}else if($id == '0106'){
				$query = "SELECT D.KLASIFIKASI_ID, A.KLASIFIKASI AS KATEGORI, B.KLASIFIKASI AS [NAMA OBAT], C.KLASIFIKASI AS [BENTUK SEDIAAN],
						  D.KLASIFIKASI AS [KOMPOSISI]
						  FROM M_GOLONGAN_NEW A
						  JOIN M_GOLONGAN_NEW B ON A.KLASIFIKASI_ID = B.KLASIFIKASI_PARENT
						  JOIN M_GOLONGAN_NEW C ON B.KLASIFIKASI_ID = C.KLASIFIKASI_PARENT
						  JOIN M_GOLONGAN_NEW D ON C.KLASIFIKASI_ID = D.KLASIFIKASI_PARENT
						  WHERE LEFT(A.KLASIFIKASI_ID,2) = '01' AND LEFT(A.KLASIFIKASI_ID,4) = '".$id."'";							  
				$this->newtable->columns(array("D.KLASIFIKASI_ID", "A.KLASIFIKASI", "B.KLASIFIKASI", "C.KLASIFIKASI","D.KLASIFIKASI"));
				$this->newtable->width(array('KATEGORI' => 100, 'NAMA OBAT' => 150, 'BENTUK SEDIAAN' => 150, 'KOMPOSISI' => 150));
				$this->newtable->search(array(array("B.KLASIFIKASI","Nama Obat"),
											  array("C.KLASIFIKASI","Bentuk Sediaan"),
											  array("D.KLASIFIKASI","Komposisi")));
				$proses['Nama Obat, Bentuk Sediaan atau Komposisi Baru'] = array('GET',site_url().'/home/prioritas/kategori/new/'. $id ,'0');
				$this->newtable->menu($proses);							  
			}else if($id == '0107'){
				$query = "SELECT B.KLASIFIKASI_ID, A.KLASIFIKASI AS KATEGORI, B.KLASIFIKASI AS [INDUSTRI FARMASI]
						  FROM M_GOLONGAN_NEW A JOIN M_GOLONGAN_NEW B ON A.KLASIFIKASI_ID = B.KLASIFIKASI_PARENT
						  WHERE LEFT(A.KLASIFIKASI_ID,2) = '01' AND LEFT(A.KLASIFIKASI_ID,4) = '".$id."'";
				$this->newtable->columns(array("B.KLASIFIKASI_ID", "A.KLASIFIKASI","B.KLASIFIKASI"));
				$this->newtable->width(array('KATEGORI' => 200, 'INDUSTRI FARMASI' => 500));
				$this->newtable->search(array(array("B.KLASIFIKASI","Industri Farmasi")));
			}else if($id == '0108'){
				$query = "SELECT E.KLASIFIKASI_ID, A.KLASIFIKASI AS KATEGORI, B.KLASIFIKASI AS [NAMA OBAT], C.KLASIFIKASI AS [ZAT AKTIF],
						  D.KLASIFIKASI AS [BENTUK SEDIAAN], E.KLASIFIKASI AS [INDUSTRI FARMASI]
						  FROM M_GOLONGAN_NEW A
						  JOIN M_GOLONGAN_NEW B ON A.KLASIFIKASI_ID = B.KLASIFIKASI_PARENT
						  JOIN M_GOLONGAN_NEW C ON B.KLASIFIKASI_ID = C.KLASIFIKASI_PARENT
						  JOIN M_GOLONGAN_NEW D ON C.KLASIFIKASI_ID = D.KLASIFIKASI_PARENT
						  JOIN M_GOLONGAN_NEW E ON D.KLASIFIKASI_ID = E.KLASIFIKASI_PARENT
						  WHERE LEFT(A.KLASIFIKASI_ID,2) = '01' AND LEFT(A.KLASIFIKASI_ID,4) = '".$id."'";							  
				$this->newtable->columns(array("D.KLASIFIKASI_ID", "A.KLASIFIKASI", "B.KLASIFIKASI", "C.KLASIFIKASI","D.KLASIFIKASI","E.KLASIFIKASI"));
				$this->newtable->width(array('KATEGORI' => 100, 'NAMA OBAT' => 150, 'ZAT AKTIF' => 150, 'BENTUK SEDIAAN' => 150, 'INDUSTRI FARMASI' => 150));
				$this->newtable->search(array(array("B.KLASIFIKASI","Nama Obat"),
											  array("C.KLASIFIKASI","Zat Aktif"),
											  array("D.KLASIFIKASI","Bentuk Sediaan"),
											  array("E.KLASIFIKASI","Industri Farmasi")));
			}else if($id == '0109'){
				$query = "SELECT D.KLASIFIKASI_ID, A.KLASIFIKASI AS KATEGORI, B.KLASIFIKASI AS [ZAT AKTIF], C.KLASIFIKASI AS [BENTUK SEDIAAN],
						  D.KLASIFIKASI AS [SEDIAAN PUSTAKA]
						  FROM M_GOLONGAN_NEW A
						  JOIN M_GOLONGAN_NEW B ON A.KLASIFIKASI_ID = B.KLASIFIKASI_PARENT
						  JOIN M_GOLONGAN_NEW C ON B.KLASIFIKASI_ID = C.KLASIFIKASI_PARENT
						  JOIN M_GOLONGAN_NEW D ON C.KLASIFIKASI_ID = D.KLASIFIKASI_PARENT
						  WHERE LEFT(A.KLASIFIKASI_ID,2) = '01' AND LEFT(A.KLASIFIKASI_ID,4) = '".$id."'";							  
				$this->newtable->columns(array("D.KLASIFIKASI_ID", "A.KLASIFIKASI", "B.KLASIFIKASI", "C.KLASIFIKASI","D.KLASIFIKASI"));
				$this->newtable->width(array('KATEGORI' => 100, 'ZAT AKTIF' => 150, 'BENTUK SEDIAAN' => 150, 'SEDIAAN PUSTAKA' => 150));
				$this->newtable->search(array(array("B.KLASIFIKASI","Zat Aktif"),
											  array("C.KLASIFIKASI","Bentuk Sediaan"),
											  array("D.KLASIFIKASI","Sediaan Pustaka")));
			}
			else if($id == '0110'){
				$query = "SELECT D.KLASIFIKASI_ID, A.KLASIFIKASI AS KATEGORI, B.KLASIFIKASI AS [SUB KATEGORI], C.KLASIFIKASI AS [SUB SUB KATEGORI],
						  D.KLASIFIKASI AS [SUB SUB SUB KATEGORI]
						  FROM M_GOLONGAN_NEW A
						  JOIN M_GOLONGAN_NEW B ON A.KLASIFIKASI_ID = B.KLASIFIKASI_PARENT
						  JOIN M_GOLONGAN_NEW C ON B.KLASIFIKASI_ID = C.KLASIFIKASI_PARENT
						  JOIN M_GOLONGAN_NEW D ON C.KLASIFIKASI_ID = D.KLASIFIKASI_PARENT
						  WHERE LEFT(A.KLASIFIKASI_ID,2) = '01' AND LEFT(A.KLASIFIKASI_ID,4) = '".$id."'";							  
				$this->newtable->columns(array("D.KLASIFIKASI_ID", "A.KLASIFIKASI", "B.KLASIFIKASI", "C.KLASIFIKASI","D.KLASIFIKASI"));
				$this->newtable->width(array('KATEGORI' => 100, 'ZAT AKTIF' => 150, 'BENTUK SEDIAAN' => 150, 'SEDIAAN PUSTAKA' => 150));
				$this->newtable->search(array(array("B.KLASIFIKASI","Zat Aktif"),
											  array("C.KLASIFIKASI","Bentuk Sediaan"),
											  array("D.KLASIFIKASI","Sediaan Pustaka")));
				$proses['Zat Aktif Baru'] = array('GET',site_url().'/home/prioritas/kategori/new/'. $id ,'0');
				$this->newtable->menu($proses);							  							  
			}
			else if($id == '0113'){
				$query = "SELECT D.KLASIFIKASI_ID, A.KLASIFIKASI AS KATEGORI, B.KLASIFIKASI AS [SUB KATEGORI], C.KLASIFIKASI AS [SUB SUB KATEGORI],
						  D.KLASIFIKASI AS [SUB SUB SUB KATEGORI]
						  FROM M_GOLONGAN_NEW A
						  JOIN M_GOLONGAN_NEW B ON A.KLASIFIKASI_ID = B.KLASIFIKASI_PARENT
						  JOIN M_GOLONGAN_NEW C ON B.KLASIFIKASI_ID = C.KLASIFIKASI_PARENT
						  JOIN M_GOLONGAN_NEW D ON C.KLASIFIKASI_ID = D.KLASIFIKASI_PARENT
						  WHERE LEFT(A.KLASIFIKASI_ID,2) = '01' AND LEFT(A.KLASIFIKASI_ID,4) = '".$id."'";							  
				$this->newtable->columns(array("D.KLASIFIKASI_ID", "A.KLASIFIKASI", "B.KLASIFIKASI", "C.KLASIFIKASI","D.KLASIFIKASI"));
				$this->newtable->width(array('KATEGORI' => 100, 'ZAT AKTIF' => 150, 'BENTUK SEDIAAN' => 150, 'SEDIAAN PUSTAKA' => 150));
				$this->newtable->search(array(array("B.KLASIFIKASI","Zat Aktif"),
											  array("C.KLASIFIKASI","Bentuk Sediaan"),
											  array("D.KLASIFIKASI","Sediaan Pustaka")));
				$proses['Zat Aktif Baru'] = array('GET',site_url().'/home/prioritas/kategori/new/'. $id ,'0');
				$this->newtable->menu($proses);							  							  
			}
			else if($id == '0111' || $id == '0112' ){
				$query = "SELECT D.KLASIFIKASI_ID, A.KLASIFIKASI AS KATEGORI, B.KLASIFIKASI AS [ZAT AKTIF], C.KLASIFIKASI AS [BENTUK SEDIAAN],
						  D.KLASIFIKASI AS [SEDIAAN PUSTAKA]
						  FROM M_GOLONGAN_NEW A
						  JOIN M_GOLONGAN_NEW B ON A.KLASIFIKASI_ID = B.KLASIFIKASI_PARENT
						  JOIN M_GOLONGAN_NEW C ON B.KLASIFIKASI_ID = C.KLASIFIKASI_PARENT
						  JOIN M_GOLONGAN_NEW D ON C.KLASIFIKASI_ID = D.KLASIFIKASI_PARENT
						  WHERE LEFT(A.KLASIFIKASI_ID,2) = '01' AND LEFT(A.KLASIFIKASI_ID,4) = '".$id."'";							  
				$this->newtable->columns(array("D.KLASIFIKASI_ID", "A.KLASIFIKASI", "B.KLASIFIKASI", "C.KLASIFIKASI","D.KLASIFIKASI"));
				$this->newtable->width(array('KATEGORI' => 100, 'ZAT AKTIF' => 150, 'BENTUK SEDIAAN' => 150, 'SEDIAAN PUSTAKA' => 150));
				$this->newtable->search(array(array("B.KLASIFIKASI","Zat Aktif"),
											  array("C.KLASIFIKASI","Bentuk Sediaan"),
											  array("D.KLASIFIKASI","Sediaan Pustaka")));
				$proses['Zat Aktif Baru'] = array('GET',site_url().'/home/prioritas/kategori/new/'. $id ,'0');
				$this->newtable->menu($proses);							  
			}
			$this->newtable->action(site_url()."/home/prioritas/kategori/01/".$id);
			$this->newtable->hiddens(array('KLASIFIKASI_ID'));
			$this->newtable->cidb($this->db);
			$this->newtable->ciuri($this->uri->segment_array());
			$this->newtable->orderby(1);
			$this->newtable->sortby("ASC");
			$this->newtable->keys(array('KLASIFIKASI_ID'));
			$tabel = $this->newtable->generate($query);
			$arrdata = array('table' => $tabel,
							 'idjudul' => 'juduluji',
							 'caption_header' => 'Kategori Prioritas Sampling - Obat ' . $sipt->main->get_uraian("SELECT KLASIFIKASI FROM M_GOLONGAN_NEW WHERE KLASIFIKASI_ID = '".$id."' AND LEN(KLASIFIKASI_ID) = 4","KLASIFIKASI"),
							 'batal' => '',
							 'cancel' => '');
			return $arrdata;
		}else{
			$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
		}
	}
	
	function kategori_10(){
		if((in_array('1', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('9', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('4', $this->newsession->userdata('SESS_KODE_ROLE'))) && $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$sipt->load->model("main", "main", true);
			$this->load->library('newtable');
			$query = "SELECT C.KLASIFIKASI_ID, A.KLASIFIKASI AS KOMODITI, B.KLASIFIKASI AS [KATEGORI], C.KLASIFIKASI AS [SUB KATEGORI]
					  FROM M_GOLONGAN_NEW A
					  JOIN M_GOLONGAN_NEW B ON A.KLASIFIKASI_ID = B.KLASIFIKASI_PARENT
					  JOIN M_GOLONGAN_NEW C ON B.KLASIFIKASI_ID = C.KLASIFIKASI_PARENT
					  WHERE LEFT(A.KLASIFIKASI_ID,2) = '10'";
			$this->newtable->columns(array("C.KLASIFIKASI_ID", "A.KLASIFIKASI","B.KLASIFIKASI","C.KLASIFIKASI"));
			$this->newtable->width(array('KOMODITI' => 100, 'KATEGORI' => 150, 'SUB KATEGORI' => 150));
			$this->newtable->search(array(array("B.KLASIFIKASI","Kategori"),
										  array("C.KLASIFIKASI","Sub Kategori")));
			$this->newtable->action(site_url()."/home/prioritas/kategori/10");
			$this->newtable->hiddens(array('KLASIFIKASI_ID'));
			$this->newtable->cidb($this->db);
			$this->newtable->ciuri($this->uri->segment_array());
			$this->newtable->orderby(1);
			$this->newtable->sortby("ASC");
			$this->newtable->keys(array('KLASIFIKASI_ID'));
			$tabel = $this->newtable->generate($query);
			$arrdata = array('table' => $tabel,
							 'idjudul' => 'juduluji',
							 'caption_header' => 'Kategori Prioritas Sampling - Obat Tradisional',
							 'batal' => '',
							 'cancel' => '');
			return $arrdata;
		}else{
			$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
		}
	}

	function kategori_11(){
		if((in_array('1', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('9', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('4', $this->newsession->userdata('SESS_KODE_ROLE'))) && $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$sipt->load->model("main", "main", true);
			$this->load->library('newtable');
			$query = "SELECT C.KLASIFIKASI_ID, A.KLASIFIKASI AS KOMODITI, B.KLASIFIKASI AS [KATEGORI], C.KLASIFIKASI AS [SUB KATEGORI]
					  FROM M_GOLONGAN_NEW A
					  JOIN M_GOLONGAN_NEW B ON A.KLASIFIKASI_ID = B.KLASIFIKASI_PARENT
					  JOIN M_GOLONGAN_NEW C ON B.KLASIFIKASI_ID = C.KLASIFIKASI_PARENT
					  WHERE LEFT(A.KLASIFIKASI_ID,2) = '11'";
			$this->newtable->columns(array("C.KLASIFIKASI_ID", "A.KLASIFIKASI","B.KLASIFIKASI","C.KLASIFIKASI"));
			$this->newtable->width(array('KOMODITI' => 100, 'KATEGORI' => 150, 'SUB KATEGORI' => 150));
			$this->newtable->search(array(array("B.KLASIFIKASI","Kategori"),
										  array("C.KLASIFIKASI","Sub Kategori")));
			$this->newtable->action(site_url()."/home/prioritas/kategori/11");
			$this->newtable->hiddens(array('KLASIFIKASI_ID'));
			$this->newtable->cidb($this->db);
			$this->newtable->ciuri($this->uri->segment_array());
			$this->newtable->orderby(1);
			$this->newtable->sortby("ASC");
			$this->newtable->keys(array('KLASIFIKASI_ID'));
			$tabel = $this->newtable->generate($query);
			$arrdata = array('table' => $tabel,
							 'idjudul' => 'juduluji',
							 'caption_header' => 'Kategori Prioritas Sampling - Suplemen Makanan',
							 'batal' => '',
							 'cancel' => '');
			return $arrdata;
		}else{
			$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
		}
	}

	function kategori_12(){
		if((in_array('1', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('9', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('4', $this->newsession->userdata('SESS_KODE_ROLE'))) && $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$sipt->load->model("main", "main", true);
			$this->load->library('newtable');
			$query = "SELECT C.KLASIFIKASI_ID, A.KLASIFIKASI AS KOMODITI, B.KLASIFIKASI AS [KATEGORI], C.KLASIFIKASI AS [SUB KATEGORI]
					  FROM M_GOLONGAN_NEW A
					  JOIN M_GOLONGAN_NEW B ON A.KLASIFIKASI_ID = B.KLASIFIKASI_PARENT
					  JOIN M_GOLONGAN_NEW C ON B.KLASIFIKASI_ID = C.KLASIFIKASI_PARENT
					  WHERE LEFT(A.KLASIFIKASI_ID,2) = '12'";
			$this->newtable->columns(array("C.KLASIFIKASI_ID", "A.KLASIFIKASI","B.KLASIFIKASI","C.KLASIFIKASI"));
			$this->newtable->width(array('KOMODITI' => 100, 'KATEGORI' => 150, 'SUB KATEGORI' => 150));
			$this->newtable->search(array(array("B.KLASIFIKASI","Kategori"),
										  array("C.KLASIFIKASI","Sub Kategori")));
			$this->newtable->action(site_url()."/home/prioritas/kategori/12");
			$this->newtable->hiddens(array('KLASIFIKASI_ID'));
			$this->newtable->cidb($this->db);
			$this->newtable->ciuri($this->uri->segment_array());
			$this->newtable->orderby(1);
			$this->newtable->sortby("ASC");
			$this->newtable->keys(array('KLASIFIKASI_ID'));
			$tabel = $this->newtable->generate($query);
			$arrdata = array('table' => $tabel,
							 'idjudul' => 'juduluji',
							 'caption_header' => 'Kategori Prioritas Sampling - Kosmetika',
							 'batal' => '',
							 'cancel' => '');
			return $arrdata;
		}else{
			$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
		}
	}

	function kategori_13(){
		if((in_array('1', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('9', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('4', $this->newsession->userdata('SESS_KODE_ROLE'))) && $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$sipt->load->model("main", "main", true);
			$this->load->library('newtable');
			$query = "SELECT E.KLASIFIKASI_ID, A.KLASIFIKASI AS KOMODITI, B.KLASIFIKASI AS [KATEGORI], C.KLASIFIKASI AS [SUB KATEGORI], 
					  D.KLASIFIKASI AS [SUB SUB KATEGORI], E.KLASIFIKASI AS [SUB SUB SUB KATEGORI]
					  FROM M_GOLONGAN_NEW A
					  JOIN M_GOLONGAN_NEW B ON A.KLASIFIKASI_ID = B.KLASIFIKASI_PARENT
					  JOIN M_GOLONGAN_NEW C ON B.KLASIFIKASI_ID = C.KLASIFIKASI_PARENT
					  JOIN M_GOLONGAN_NEW D ON C.KLASIFIKASI_ID = D.KLASIFIKASI_PARENT
					  JOIN M_GOLONGAN_NEW E ON D.KLASIFIKASI_ID = E.KLASIFIKASI_PARENT
					  WHERE LEFT(A.KLASIFIKASI_ID,2) = '13'";
			$this->newtable->columns(array("E.KLASIFIKASI_ID","A.KLASIFIKASI","B.KLASIFIKASI","C.KLASIFIKASI","D.KLASIFIKASI","E.KLASIFIKASI"));
			$this->newtable->width(array('KOMODITI' => 100, 'KATEGORI' => 150, 'SUB KATEGORI' => 150, 'SUB SUB KATEGORI' => 150, 'SUB SUB SUB KATEGORI' => 150));
			$this->newtable->search(array(array("B.KLASIFIKASI","Kategori"),
										  array("C.KLASIFIKASI","Sub Kategori"),
										  array("D.KLASIFIKASI","Sub Sub Kategori"),
										  array("E.KLASIFIKASI","Sub Sub Sub Kategori")));
			$this->newtable->action(site_url()."/home/prioritas/kategori/13");
			$this->newtable->hiddens(array('KLASIFIKASI_ID'));
			$this->newtable->cidb($this->db);
			$this->newtable->ciuri($this->uri->segment_array());
			$this->newtable->orderby(1);
			$this->newtable->sortby("ASC");
			$this->newtable->keys(array('KLASIFIKASI_ID'));
			$tabel = $this->newtable->generate($query);
			$arrdata = array('table' => $tabel,
							 'idjudul' => 'juduluji',
							 'caption_header' => 'Kategori Prioritas Sampling - Produk Pangan',
							 'batal' => '',
							 'cancel' => '');
			return $arrdata;
		}else{
			$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
		}
	}


	function kategori_14(){
		if((in_array('1', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('9', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('4', $this->newsession->userdata('SESS_KODE_ROLE'))) && $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$sipt->load->model("main", "main", true);
			$this->load->library('newtable');
			$query = "SELECT C.KLASIFIKASI_ID, A.KLASIFIKASI AS KOMODITI, B.KLASIFIKASI AS [KATEGORI], C.KLASIFIKASI AS [SUB KATEGORI]
					  FROM M_GOLONGAN_NEW A
					  JOIN M_GOLONGAN_NEW B ON A.KLASIFIKASI_ID = B.KLASIFIKASI_PARENT
					  JOIN M_GOLONGAN_NEW C ON B.KLASIFIKASI_ID = C.KLASIFIKASI_PARENT
					  WHERE LEFT(A.KLASIFIKASI_ID,2) = '14'";
			$this->newtable->columns(array("C.KLASIFIKASI_ID", "A.KLASIFIKASI","B.KLASIFIKASI","C.KLASIFIKASI"));
			$this->newtable->width(array('KOMODITI' => 100, 'KATEGORI' => 150, 'SUB KATEGORI' => 150));
			$this->newtable->search(array(array("B.KLASIFIKASI","Kategori"),
										  array("C.KLASIFIKASI","Sub Kategori")));
			$this->newtable->action(site_url()."/home/prioritas/kategori/14");
			$this->newtable->hiddens(array('KLASIFIKASI_ID'));
			$this->newtable->cidb($this->db);
			$this->newtable->ciuri($this->uri->segment_array());
			$this->newtable->orderby(1);
			$this->newtable->sortby("ASC");
			$this->newtable->keys(array('KLASIFIKASI_ID'));
			$tabel = $this->newtable->generate($query);
			$arrdata = array('table' => $tabel,
							 'idjudul' => 'juduluji',
							 'caption_header' => 'Kategori Prioritas Sampling - Kemasan Pangan',
							 'batal' => '',
							 'cancel' => '');
			return $arrdata;
		}else{
			$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
		}
	}

	function get_kategori($kategori){
		if($this->newsession->userdata('LOGGED_IN') == TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			if(strlen($kategori) == 4 && substr($kategori,0,2) == '01'){
				$arrdata['komoditi'] = $sipt->main->get_uraian("SELECT KLASIFIKASI FROM M_GOLONGAN_NEW WHERE KLASIFIKASI_ID = '".substr($kategori,0,2)."'","KLASIFIKASI");
				$arrdata['kategori'] = $sipt->main->combobox("SELECT LTRIM(RTRIM(KLASIFIKASI_ID)) AS KLASIFIKASI_ID, KLASIFIKASI FROM M_GOLONGAN_NEW WHERE KLASIFIKASI_ID = '".$kategori."' AND LEN(KLASIFIKASI_ID) = 4","KLASIFIKASI_ID", "KLASIFIKASI");				
				if($kategori == "0101" || $kategori == "0105"){
					$arrdata['cbkategori'] = $sipt->main->combobox("SELECT LTRIM(RTRIM(KLASIFIKASI_ID)) AS KLASIFIKASI_ID, KLASIFIKASI FROM M_GOLONGAN_NEW WHERE KLASIFIKASI_PARENT = '".$kategori."' AND KLASIFIKASI_ID LIKE '".$kategori."%__' OR KLASIFIKASI_ID LIKE '".$kategori."%___' AND (LEN(KLASIFIKASI_ID) = '6' OR  LEN(KLASIFIKASI_ID) = '7')  AND KLASIFIKASI <> '' AND STATUS = 1 ORDER BY KLASIFIKASI ASC","KLASIFIKASI_ID", "KLASIFIKASI",TRUE);
				}else{ 
					$arrdata['cbkategori'] = $sipt->main->combobox("SELECT LTRIM(RTRIM(KLASIFIKASI_ID)) AS KLASIFIKASI_ID, KLASIFIKASI FROM M_GOLONGAN_NEW WHERE KLASIFIKASI_ID LIKE '" . $kategori. "%__' AND LEN(KLASIFIKASI_ID) = '6' AND KLASIFIKASI <> '' AND STATUS = 1 ORDER BY KLASIFIKASI ASC","KLASIFIKASI_ID", "KLASIFIKASI",TRUE);
				}	
			}
			else{
				$arrdata['ko'] = $kategori;
				$arrdata['komoditi'] = $sipt->main->get_uraian("SELECT KLASIFIKASI FROM M_GOLONGAN_NEW WHERE KLASIFIKASI_ID = '".$kategori."'","KLASIFIKASI");
				$arrdata['kategori'] = $sipt->main->combobox("SELECT LTRIM(RTRIM(KLASIFIKASI_ID)) AS KLASIFIKASI_ID, KLASIFIKASI FROM M_GOLONGAN_NEW WHERE LEFT(KLASIFIKASI_ID,2) = '".$kategori."' AND LEN(KLASIFIKASI_ID) = 4 ORDER BY KLASIFIKASI","KLASIFIKASI_ID", "KLASIFIKASI", TRUE);
			}
			$arrdata['act'] = site_url().'/post/kategori/kategori_act/save';	
			return $arrdata;
		}
	}
	
	function set_kategori($action, $isajax){
		if($this->newsession->userdata('LOGGED_IN') == TRUE){
			if($action == "save"){
				$sipt =& get_instance();
				$this->load->model("main", "main", true);
				$hasil = FALSE;
				$msgok = "MSG#YES#Data prioritas sampling berhasil disimpan#back";
				$msgerr = "MSG#NO#Data prioritas sampling gagal disimpan. \n Silahkan coba beberapa saat lagi.";
				$arrid = array_filter($this->input->post('KLASIFIKASI_ID'));
				$induk = $arrid[count($arrid)-1];
				$length = strlen($induk); 
				$child = $length+2; 
				$no = (int)$sipt->main->get_uraian("SELECT MAX(KLASIFIKASI_ID) AS MAXID FROM M_GOLONGAN_NEW WHERE LEN(KLASIFIKASI_ID) = '".$child."' AND KLASIFIKASI_ID LIKE '".$induk."%__'","MAXID") + 1; 
				$digit = 2;
				$substr = substr($induk, 0,4);
				if($substr == "0101" || $substr == "0105"){
					if($length == 4){
						$no = $sipt->main->get_uraian("SELECT MAX(KLASIFIKASI_ID) AS MAXID FROM M_GOLONGAN_NEW WHERE LEN(KLASIFIKASI_ID) = 7 AND KLASIFIKASI_ID LIKE '".$induk."%___'","MAXID") + 1;	
						$digit = 3;	
					}
				}
				$klasifikasi = substr($induk,0,2);
				if($klasifikasi == '01'){
					$deputi = '1';
				}else if($klasifikasi == '10' || $klasifikasi == '11' || $klasifikasi == '12'){
					$deputi = '2';
				}else if($klasifikasi == '13' || $klasifikasi == '14'){
					$deputi = '3';
				}
				$seri = substr(str_repeat("0", $digit).$no, -$digit);
				$urut = $induk.$seri;
				$arrpusat = array('00','90','92','93','94','95','96','99');
				$arrgolongan = array('KLASIFIKASI_ID' => $urut,
									 'KLASIFIKASI_PARENT' => substr($urut, 0, -$digit),
									 'KLASIFIKASI' => $this->input->post('KLASIFIKASI'),
									 'DEPUTI' => $deputi,
									 'CREATE_DATE' => 'GETDATE()',
									 'CREATE_BY' => $this->newsession->userdata('SESS_USER_ID'),
									 'LOKAL' => (in_array($this->newsession->userdata('SESS_BBPOM_ID'), $arrpusat) ? 0 : 1),
									 'PRIORITAS' => date("Y"));	
				$this->db->insert('M_GOLONGAN_NEW', $arrgolongan);
				if($this->db->affected_rows() > 0){					
            		$hasil = TRUE;
            		if(((substr($urut, 0, 4) == "0111" || substr($urut, 0, 4) == "0112" || substr($urut, 0, 4) == "0113") && strlen($arrgolongan['KLASIFIKASI_PARENT']) ==  8) || (substr($urut, 0, 4) == "0110" && strlen($arrgolongan['KLASIFIKASI_PARENT']) ==  10)){
						$query = "INSERT INTO t_kategori_puk (PARAMETER_KRITIS, GOLONGAN, PUK_ID, PRIORITAS, STATUS, CREATE_BY, CREATE_DATE) SELECT PARAMETER_KRITIS, '".$arrgolongan['KLASIFIKASI_ID']."', PUK_ID, PRIORITAS, STATUS, 'administrator', getdate() FROM t_kategori_puk WHERE golongan = '".$arrgolongan['KLASIFIKASI_PARENT']."'";
						$this->db->query($query);
					}
				}
				if($hasil){
					return $msgok;
				}else{
					return $msgerr;
				}
			}else if($action == "live"){#Edit Live Table
				$hasil = FALSE;
				$retadd = FALSE;
				$msgok = "MSG#YES#Data berhasil di update";
				$msgerr = "MSG#NO#Data gagal di update";
				$arr = array('KLASIFIKASI' => $this->input->post('KLASIFIKASI'));
				$this->db->trans_begin();
				$this->db->where('KLASIFIKASI_ID', $this->input->post('KLASIFIKASI_ID'));
				$this->db->update('M_GOLONGAN_NEW', $arr);
				if($this->db->affected_rows() > 0){
					$retadd = TRUE;
				}
				if($retadd){
					return $msgok;
				}else{
					return $msgerr;
				}
			}
		}
	}
	
}
?>