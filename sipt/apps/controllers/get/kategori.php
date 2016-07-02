<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR);
class Kategori extends Controller{
	function Kategori(){
		parent::Controller();
	}
	
	function ac_kategori($kategori,$empty=""){
		if($this->newsession->userdata('LOGGED_IN') == TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$length = strlen(trim($kategori));
			$substr = substr($kategori,0,4);
			if($length == 4){
			  if($substr == "0101" || $substr == "0105")
				  $query = "SELECT (LTRIM(RTRIM(KLASIFIKASI_ID))) AS KLASIFIKASI_ID, LTRIM(RTRIM(KLASIFIKASI)) AS KLASIFIKASI FROM M_GOLONGAN_NEW WHERE KLASIFIKASI_PARENT = '".$kategori."' AND KLASIFIKASI_ID LIKE '".$kategori."%__' OR KLASIFIKASI_ID LIKE '".$kategori."%___' AND (LEN(KLASIFIKASI_ID) = '6' OR  LEN(KLASIFIKASI_ID) = '7')  AND KLASIFIKASI <> '' AND STATUS = 1 ORDER BY KLASIFIKASI ASC";
			  else  
				  $query = "SELECT (LTRIM(RTRIM(KLASIFIKASI_ID))) AS KLASIFIKASI_ID, LTRIM(RTRIM(KLASIFIKASI)) AS KLASIFIKASI FROM M_GOLONGAN_NEW WHERE KLASIFIKASI_ID LIKE '" . $kategori . "%__' AND LEN(KLASIFIKASI_ID) = '6' AND KLASIFIKASI <> '' AND STATUS = 1 ORDER BY KLASIFIKASI ASC"; 				
			}else if($length == 6 || $length == 7){
				if($length == 6)
					if($kategori=='011001'){
						$query = "SELECT (LTRIM(RTRIM(KLASIFIKASI_ID))) AS KLASIFIKASI_ID, LTRIM(RTRIM(KLASIFIKASI)) AS KLASIFIKASI FROM M_GOLONGAN_NEW WHERE KLASIFIKASI_ID LIKE '" . $kategori . "%__' AND LEN(KLASIFIKASI_ID) = '8' AND KLASIFIKASI <> '' AND KLASIFIKASI_ID NOT IN('01100101','01100102') AND STATUS = 1 ORDER BY KLASIFIKASI ASC";
					}else{
						
						$query = "SELECT (LTRIM(RTRIM(KLASIFIKASI_ID))) AS KLASIFIKASI_ID, LTRIM(RTRIM(KLASIFIKASI)) AS KLASIFIKASI FROM M_GOLONGAN_NEW WHERE KLASIFIKASI_ID LIKE '" . $kategori . "%__' AND LEN(KLASIFIKASI_ID) = '8' AND KLASIFIKASI <> '' AND STATUS = 1 ORDER BY KLASIFIKASI ASC";	
						
					}
				
				else if($length == 7)
				$query = "SELECT (LTRIM(RTRIM(KLASIFIKASI_ID))) AS KLASIFIKASI_ID, LTRIM(RTRIM(KLASIFIKASI)) AS KLASIFIKASI FROM M_GOLONGAN_NEW WHERE KLASIFIKASI_ID LIKE '" . $kategori . "%__' AND LEN(KLASIFIKASI_ID) = '9' AND KLASIFIKASI <> '' AND STATUS = 1 ORDER BY KLASIFIKASI ASC";
			}else if($length == 8 || $length == 9){
				if($length == 8)
					if($kategori_id = '01100105'){
						
						$query = "SELECT (LTRIM(RTRIM(KLASIFIKASI_ID))) AS KLASIFIKASI_ID, LTRIM(RTRIM(KLASIFIKASI)) AS KLASIFIKASI FROM M_GOLONGAN_NEW WHERE KLASIFIKASI_ID LIKE '" . $kategori . "%__' AND LEN(KLASIFIKASI_ID) = '10' AND KLASIFIKASI <> '' AND KLASIFIKASI_ID <> '0110010501' AND STATUS = 1 ORDER BY KLASIFIKASI ASC";
					}else{
						$query = "SELECT (LTRIM(RTRIM(KLASIFIKASI_ID))) AS KLASIFIKASI_ID, LTRIM(RTRIM(KLASIFIKASI)) AS KLASIFIKASI FROM M_GOLONGAN_NEW WHERE KLASIFIKASI_ID LIKE '" . $kategori . "%__' AND LEN(KLASIFIKASI_ID) = '10' AND KLASIFIKASI <> '' AND STATUS = 1 ORDER BY KLASIFIKASI ASC";
					}
				else if($length == 9)
				$query = "SELECT (LTRIM(RTRIM(KLASIFIKASI_ID))) AS KLASIFIKASI_ID, LTRIM(RTRIM(KLASIFIKASI)) AS KLASIFIKASI FROM M_GOLONGAN_NEW WHERE KLASIFIKASI_ID LIKE '" . $kategori . "%__' AND LEN(KLASIFIKASI_ID) = '11' AND KLASIFIKASI <> '' ORDER BY KLASIFIKASI ASC";
			}
			else if($length == 10 || $length == 11){
				
				if($length == 10)
				{
					
					$arrobat = array('0111','0112','0113'); //f,i,g2 dan trigerred
					if(in_array($substr,$arrobat)){						
						$query = "SELECT (LTRIM(RTRIM(KLASIFIKASI_ID))) AS KLASIFIKASI_ID, LTRIM(RTRIM(KLASIFIKASI)) AS KLASIFIKASI FROM M_GOLONGAN_NEW WHERE KLASIFIKASI_ID LIKE '" . $kategori . "%__' AND LEN(KLASIFIKASI_ID) = '10' AND KLASIFIKASI <> '' AND STATUS='1'  ORDER BY KLASIFIKASI ASC";	
					}else if($substr == '0110'){

						$query = "SELECT (LTRIM(RTRIM(KLASIFIKASI_ID))) AS KLASIFIKASI_ID, LTRIM(RTRIM(KLASIFIKASI)) AS KLASIFIKASI FROM M_GOLONGAN_NEW WHERE KLASIFIKASI_ID LIKE '" . $kategori . "%__' AND LEN(KLASIFIKASI_ID) = '12' AND KLASIFIKASI <> '' AND STATUS='1'  ORDER BY KLASIFIKASI ASC";	
					}else{
						$query = "SELECT (LTRIM(RTRIM(KLASIFIKASI_ID))) AS KLASIFIKASI_ID, LTRIM(RTRIM(KLASIFIKASI)) AS KLASIFIKASI FROM M_GOLONGAN_NEW WHERE KLASIFIKASI_ID LIKE '" . $kategori . "%__' AND LEN(KLASIFIKASI_ID) = '12' AND KLASIFIKASI <> '' AND STATUS='1'  ORDER BY KLASIFIKASI ASC";
					}
					
				}
				else if($length == 11){
					$query = "SELECT (LTRIM(RTRIM(KLASIFIKASI_ID))) AS KLASIFIKASI_ID, LTRIM(RTRIM(KLASIFIKASI)) AS KLASIFIKASI FROM M_GOLONGAN_NEW WHERE KLASIFIKASI_ID LIKE '" . $kategori . "%__' AND LEN(KLASIFIKASI_ID) = '13' AND KLASIFIKASI <> '' ORDER BY KLASIFIKASI ASC";
				}
				
			}else{
				die();
			}
			$data = $sipt->main->get_result($query);
			if($data){
				if($empty!="") $ret .= "<option value=\"\"></option>";	
				else $ret .= "<option value=\"\"> Tambah data baru atau pilih dari daftar di berikut </option>";	
				foreach($query->result_array() as $row){
					$ret .= "<option value=\"".$row['KLASIFIKASI_ID']."\">".$row['KLASIFIKASI']."</option>";
				}
				echo str_replace(chr(10),'',$ret);
			}
		}
	}
	
	function ac_ketentuan_khusus($golongan){
		if($this->newsession->userdata('LOGGED_IN') == TRUE)
		{
			$length = strlen(trim($golongan));
			$substr = substr($golongan,0,4);

			//$arrobat = array('0111','0112','0110','0113'); //f,i,g2 dan trigerred
			/*if(in_array($substr,$arrobat)){
				if($length > 8)
					$golongan = substr($golongan,0,8); 
			}*/

			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$query = "SELECT A.PUK_ID, B.KETERANGAN 
					  FROM T_KATEGORI_PUK A LEFT JOIN M_PUK B ON A.PUK_ID = B.PUK_ID
					  WHERE A.GOLONGAN = '".$golongan."' AND A.STATUS='1' AND B.KOMODITI = '01' AND B.STATUS = 1
					  GROUP BY A.PUK_ID, B.KETERANGAN";
			$data = $sipt->main->get_result($query);
			$ret = "";
			if($data)
			{
				$ret .= "<option value=\"\"></option>";	
				foreach($query->result_array() as $row){
					$ret .= "<option value=\"".$row['PUK_ID']."\">".$row['KETERANGAN']."</option>";
				}
				echo str_replace(chr(10),'',$ret);
			}
		}
	}
	
	function ac_parameter($golongan, $puk_id = "")
	{
		if($this->newsession->userdata('LOGGED_IN') == TRUE)
		{
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$substr = substr($golongan, 0,4);
			if($substr == "0106")
			{
				$query = "SELECT A.ID, A.PARAMETER_UJI_KRITIS
						  FROM T_PARAMETER_UJI_KRITIS A
						  WHERE A.KATEGORI = '".$substr."'";

			}
			else
			{
				/*$length = strlen(trim($golongan));
				$arrobat = array('0111','0112','0110','0113'); //f,i,g2 dan trigerred
				if(in_array($substr,$arrobat)){
					if($length > 8)
						$golongan = substr($golongan,0,8); 
				}*/

				$query = "SELECT A.ID, B.PARAMETER_UJI_KRITIS
						  FROM T_KATEGORI_PUK A LEFT JOIN T_PARAMETER_UJI_KRITIS B ON A.PARAMETER_KRITIS = B.ID
						  WHERE A.GOLONGAN = '".$golongan."' AND A.STATUS='1' AND A.PUK_ID = '".$puk_id."'";
			}
			$data = $sipt->main->get_result($query);
			$ret = "";
			if($data)
			{
				$ret .= "<option value=\"\"></option>";	
				foreach($query->result_array() as $row){
					$ret .= "<option value=\"".$row['ID']."\">".$row['PARAMETER_UJI_KRITIS']."</option>";
				}
				echo str_replace(chr(10),'',$ret);
			}
		}
	}
	
	function ac_puk($id){
		if($this->newsession->userdata('LOGGED_IN') == TRUE)
		{
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$ret = $sipt->main->get_uraian("SELECT PARAMETER_KRITIS FROM T_KATEGORI_PUK WHERE ID = '".$id."'","PARAMETER_KRITIS");
			if($ret)
			echo $ret;
			else echo "0";
		}
	}

}