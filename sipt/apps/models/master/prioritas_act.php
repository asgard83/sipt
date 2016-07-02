<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Prioritas_act extends Model{

	function list_01($id){

		if((in_array('1', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('9', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('4', $this->newsession->userdata('SESS_KODE_ROLE'))) && $this->newsession->userdata('LOGGED_IN') ==  TRUE){

			$sipt =& get_instance();

			$sipt->load->model("main", "main", true);

			$this->load->library('newtable');

			if($id == "0101"){

				$query = "SELECT SRL_ID, CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END AS [BIDANG UJI],
						  CASE WHEN LEN(GOLONGAN) = 11 THEN dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,7))
						  ELSE dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,6))
						  END AS [ZAT AKTIF],
						  CASE WHEN LEN(GOLONGAN) = 11 THEN dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,9))
						  ELSE dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,8))
						  END AS [BAHAN AKTIF],
						  CASE
						  WHEN LEN(GOLONGAN) = 11 THEN dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,11))
						  ELSE dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,10))
						  END AS [BENTUK SEDIAAN],
						  PARAMETER_UJI AS [PARAMETER UJI], PUSTAKA, METODE, SYARAT, PRIORITAS_TAHUN AS PRIORITAS 
						  FROM M_PRIORITAS WHERE LEFT(GOLONGAN,4) = '0101' AND STATUS IN ('2','9') AND VERIFI = '01' AND PRIORITAS_TAHUN = '".date("Y")."'";

				$this->newtable->columns(array("SRL_ID", "CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END" ,"CASE WHEN LEN(GOLONGAN) = 11 THEN dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,7)) ELSE dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,6)) END","CASE WHEN LEN(GOLONGAN) = 11 THEN dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,9)) ELSE dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,8)) END","CASE WHEN LEN(GOLONGAN) = 11 THEN dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,11)) ELSE dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,10)) END","PARAMETER_UJI", "PUSTAKA","METODE","SYARAT","PRIORITAS_TAHUN"));

				$this->newtable->width(array('BIDANG UJI' => 75,'ZAT AKTIF' => 200, 'BAHAN AKTIF' => 200, 'BENTUK SEDIAAN' => 200, 'PARAMETER UJI' => 200, 'PUSTAKA' => 150, 'METODE' => 150, 'SYARAT' => 150, 'PRIORITAS' => 50));

				$this->newtable->search(array(array("CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END", "Berdasarkan Bidang Pengujian"), array("CASE WHEN LEN(GOLONGAN) = 11 THEN dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,7)) ELSE dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,6)) END", "Berdasarkan Zat Aktif"), array("CASE WHEN LEN(GOLONGAN) = 11 THEN dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,9)) ELSE dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,8)) END", "Berdasarkan Bahan Aktif"), array("CASE WHEN LEN(GOLONGAN) = 11 THEN dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,11)) ELSE dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,10)) END", "Berdasarkan Bentuk Sediaan"),array("PARAMETER_UJI", "Berdasarkan Parameter Uji"),array("PUSTAKA", "Berdasarkan Pustaka"),array("METODE", "Berdasarkan Metode"),array("SYARAT", "Berdasarkan Syarat"), array("PRIORITAS_TAHUN","Berdasarkan Prioritas")));

			}else if($id == "0102"){

				$query = "SELECT SRL_ID, CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END AS [BIDANG UJI],
						  CASE WHEN LEN(GOLONGAN) = 11 THEN dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,7))
						  ELSE dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,6))
						  END AS [ZAT AKTIF],
						  CASE WHEN LEN(GOLONGAN) = 11 THEN dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,9))
						  ELSE dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,8))
						  END AS [KELOMPOK SEDIAAN],
						  CASE
						  WHEN LEN(GOLONGAN) = 11 THEN dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,11))
						  ELSE dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,10))
						  END AS [BENTUK SEDIAAN],
						  PARAMETER_UJI AS [PARAMETER UJI], PUSTAKA, METODE, SYARAT, PRIORITAS_TAHUN AS PRIORITAS 
						  FROM M_PRIORITAS WHERE LEFT(GOLONGAN,4) = '0102' AND STATUS IN ('2','9') AND VERIFI = '01' AND PRIORITAS_TAHUN = '".date("Y")."'";

				$this->newtable->columns(array("SRL_ID", "CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END" ,"CASE WHEN LEN(GOLONGAN) = 11 THEN dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,7)) ELSE dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,6)) END","CASE WHEN LEN(GOLONGAN) = 11 THEN dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,9)) ELSE dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,8)) END","CASE WHEN LEN(GOLONGAN) = 11 THEN dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,11)) ELSE dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,10)) END","PARAMETER_UJI", "PUSTAKA","METODE","SYARAT","PRIORITAS_TAHUN"));

				$this->newtable->width(array('BIDANG UJI' => 75,'ZAT AKTIF' => 200, 'KELOMPOK SEDIAAN' => 200, 'BENTUK SEDIAAN' => 200, 'PARAMETER UJI' => 200, 'PUSTAKA' => 150, 'METODE' => 150, 'SYARAT' => 150, 'PRIORITAS' => 50));

				$this->newtable->search(array(array("CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END", "Berdasarkan Bidang Pengujian"), array("CASE WHEN LEN(GOLONGAN) = 11 THEN dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,7)) ELSE dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,6)) END", "Berdasarkan Zat Aktif"), array("CASE WHEN LEN(GOLONGAN) = 11 THEN dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,9)) ELSE dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,8)) END", "Berdasarkan Kelompok Sediaan"), array("CASE WHEN LEN(GOLONGAN) = 11 THEN dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,11)) ELSE dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,10)) END", "Berdasarkan Bentuk Sediaan"),array("PARAMETER_UJI", "Berdasarkan Parameter Uji"),array("PUSTAKA", "Berdasarkan Pustaka"),array("METODE", "Berdasarkan Metode"),array("SYARAT", "Berdasarkan Syarat"), array("PRIORITAS_TAHUN","Berdasarkan Prioritas")));

			}else if($id == "0103"){
				$query = "SELECT SRL_ID, CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END AS [BIDANG UJI],
						  CASE WHEN LEN(GOLONGAN) = 11 THEN dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,7))
						  ELSE dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,6))
						  END AS [NAMA OBAT JADI],
						  CASE WHEN LEN(GOLONGAN) = 11 THEN dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,9))
						  ELSE dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,8))
						  END AS [ZAT AKTIF],
						  CASE
						  WHEN LEN(GOLONGAN) = 11 THEN dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,11))
						  ELSE dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,10))
						  END AS [KELOMPOK SEDIAAN],
						  PARAMETER_UJI AS [PARAMETER UJI], PUSTAKA, METODE, SYARAT, PRIORITAS_TAHUN AS PRIORITAS 
						  FROM M_PRIORITAS WHERE LEFT(GOLONGAN,4) = '0103' AND STATUS IN ('2','9') AND VERIFI = '01' AND PRIORITAS_TAHUN = '".date("Y")."'";

				$this->newtable->columns(array("SRL_ID", "CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END" ,"CASE WHEN LEN(GOLONGAN) = 11 THEN dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,7)) ELSE dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,6)) END","CASE WHEN LEN(GOLONGAN) = 11 THEN dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,9)) ELSE dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,8)) END","CASE WHEN LEN(GOLONGAN) = 11 THEN dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,11)) ELSE dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,10)) END","PARAMETER_UJI", "PUSTAKA","METODE","SYARAT","PRIORITAS_TAHUN"));

				$this->newtable->width(array('BIDANG UJI' => 75,'NAMA OBAT JADI' => 200, 'ZAT AKTIF' => 200, 'KELOMPOK SEDIAAN' => 200, 'PARAMETER UJI' => 200, 'PUSTAKA' => 150, 'METODE' => 150, 'SYARAT' => 150, 'PRIORITAS' => 50));

				$this->newtable->search(array(array("CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END", "Berdasarkan Bidang Pengujian"), array("CASE WHEN LEN(GOLONGAN) = 11 THEN dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,7)) ELSE dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,6)) END", "Berdasarkan Nama Obat Jadi"), array("CASE WHEN LEN(GOLONGAN) = 11 THEN dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,9)) ELSE dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,8)) END", "Berdasarkan Zat Aktif"), array("CASE WHEN LEN(GOLONGAN) = 11 THEN dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,11)) ELSE dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,10)) END", "Berdasarkan Kelompok Sediaan"),array("PARAMETER_UJI", "Berdasarkan Parameter Uji"),array("PUSTAKA", "Berdasarkan Pustaka"),array("METODE", "Berdasarkan Metode"),array("SYARAT", "Berdasarkan Syarat"), array("PRIORITAS_TAHUN","Berdasarkan Prioritas")));

			}else if($id == "0104"){

				$query = "SELECT SRL_ID, CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END AS [BIDANG UJI],
						  CASE WHEN LEN(GOLONGAN) = 11 THEN dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,7))
						  ELSE dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,6))
						  END AS [ZAT AKTIF],
						  CASE WHEN LEN(GOLONGAN) = 11 THEN dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,9))
						  ELSE dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,8))
						  END AS [KELOMPOK SEDIAAN],
						  CASE
						  WHEN LEN(GOLONGAN) = 11 THEN dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,11))
						  ELSE dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,10))
						  END AS [BENTUK SEDIAAN],
						  PARAMETER_UJI AS [PARAMETER UJI], PUSTAKA, METODE, SYARAT, PRIORITAS_TAHUN AS PRIORITAS 
						  FROM M_PRIORITAS WHERE LEFT(GOLONGAN,4) = '0104' AND STATUS IN ('2','9') AND VERIFI = '01' AND PRIORITAS_TAHUN = '".date("Y")."'";

				$this->newtable->columns(array("SRL_ID", "CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END" ,"CASE WHEN LEN(GOLONGAN) = 11 THEN dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,7)) ELSE dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,6)) END","CASE WHEN LEN(GOLONGAN) = 11 THEN dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,9)) ELSE dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,8)) END","CASE WHEN LEN(GOLONGAN) = 11 THEN dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,11)) ELSE dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,10)) END","PARAMETER_UJI", "PUSTAKA","METODE","SYARAT","PRIORITAS_TAHUN"));

				$this->newtable->width(array('BIDANG UJI' => 75,'ZAT AKTIF' => 200, 'KELOMPOK SEDIAAN' => 200, 'BENTUK SEDIAAN' => 200, 'PARAMETER UJI' => 200, 'PUSTAKA' => 150, 'METODE' => 150, 'SYARAT' => 150, 'PRIORITAS' => 50));

				$this->newtable->search(array(array("CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END", "Berdasarkan Bidang Pengujian"), array("CASE WHEN LEN(GOLONGAN) = 11 THEN dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,7)) ELSE dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,6)) END", "Berdasarkan Zat Aktif"), array("CASE WHEN LEN(GOLONGAN) = 11 THEN dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,9)) ELSE dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,8)) END", "Berdasarkan Kelompok Sediaan"), array("CASE WHEN LEN(GOLONGAN) = 11 THEN dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,11)) ELSE dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,10)) END", "Berdasarkan Bentuk Sediaan"),array("PARAMETER_UJI", "Berdasarkan Parameter Uji"),array("PUSTAKA", "Berdasarkan Pustaka"),array("METODE", "Berdasarkan Metode"),array("SYARAT", "Berdasarkan Syarat"), array("PRIORITAS_TAHUN","Berdasarkan Prioritas")));

			}else if($id == "0105"){

				$query = "SELECT SRL_ID, CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END AS [BIDANG UJI],
						  CASE WHEN LEN(GOLONGAN) = 11 THEN dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,7))
						  ELSE dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,6))
						  END AS [NAMA OBAT],
						  CASE WHEN LEN(GOLONGAN) = 11 THEN dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,9))
						  ELSE dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,8))
						  END AS [BAHAN AKTIF],
						  CASE
						  WHEN LEN(GOLONGAN) = 11 THEN dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,11))
						  ELSE dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,10))
						  END AS [KELOMPOK SEDIAAN],
						  PARAMETER_UJI AS [PARAMETER UJI], PUSTAKA, METODE, SYARAT, PRIORITAS_TAHUN AS PRIORITAS 
						  FROM M_PRIORITAS WHERE LEFT(GOLONGAN,4) = '0105' AND STATUS IN ('2','9') AND VERIFI = '01' AND PRIORITAS_TAHUN = '".date("Y")."'";

				$this->newtable->columns(array("SRL_ID", "CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END" ,"CASE WHEN LEN(GOLONGAN) = 11 THEN dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,7)) ELSE dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,6)) END","CASE WHEN LEN(GOLONGAN) = 11 THEN dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,9)) ELSE dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,8)) END","CASE WHEN LEN(GOLONGAN) = 11 THEN dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,11)) ELSE dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,10)) END","PARAMETER_UJI", "PUSTAKA","METODE","SYARAT","PRIORITAS_TAHUN"));

				$this->newtable->width(array('BIDANG UJI' => 75,'NAMA OBAT' => 200, 'BAHAN AKTIF' => 200, 'BENTUK SEDIAAN' => 200, 'PARAMETER UJI' => 200, 'PUSTAKA' => 150, 'METODE' => 150, 'SYARAT' => 150, 'PRIORITAS' => 50));

				$this->newtable->search(array(array("CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END", "Berdasarkan Bidang Pengujian"), array("CASE WHEN LEN(GOLONGAN) = 11 THEN dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,7)) ELSE dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,6)) END", "Berdasarkan Nama Obat"), array("CASE WHEN LEN(GOLONGAN) = 11 THEN dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,9)) ELSE dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,8)) END", "Berdasarkan Bahan Aktif"), array("CASE WHEN LEN(GOLONGAN) = 11 THEN dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,11)) ELSE dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,10)) END", "Berdasarkan Kelompok Sediaan"),array("PARAMETER_UJI", "Berdasarkan Parameter Uji"),array("PUSTAKA", "Berdasarkan Pustaka"),array("METODE", "Berdasarkan Metode"),array("SYARAT", "Berdasarkan Syarat"), array("PRIORITAS_TAHUN","Berdasarkan Prioritas")));

			}else if($id == "0106"){

				$query = "SELECT SRL_ID, CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END AS [BIDANG UJI],
						  CASE WHEN LEN(GOLONGAN) = 11 THEN dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,7))
						  ELSE dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,6))
						  END AS [NAMA OBAT],
						  CASE WHEN LEN(GOLONGAN) = 11 THEN dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,9))
						  ELSE dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,8))
						  END AS [BENTUK SEDIAAN],
						  CASE
						  WHEN LEN(GOLONGAN) = 11 THEN dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,11))
						  ELSE dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,10))
						  END AS [KOMPOSISI],
						  PARAMETER_UJI AS [PARAMETER UJI], PUSTAKA, METODE, SYARAT, PRIORITAS_TAHUN AS PRIORITAS 
						  FROM M_PRIORITAS WHERE LEFT(GOLONGAN,4) = '0106' AND STATUS IN ('2','9') AND VERIFI = '01' AND PRIORITAS_TAHUN = '".date("Y")."'";

				$this->newtable->columns(array("SRL_ID", "CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END" ,"CASE WHEN LEN(GOLONGAN) = 11 THEN dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,7)) ELSE dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,6)) END","CASE WHEN LEN(GOLONGAN) = 11 THEN dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,9)) ELSE dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,8)) END","CASE WHEN LEN(GOLONGAN) = 11 THEN dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,11)) ELSE dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,10)) END","PARAMETER_UJI", "PUSTAKA","METODE","SYARAT","PRIORITAS_TAHUN"));

				$this->newtable->width(array('BIDANG UJI' => 75,'NAMA OBAT' => 200, 'BENTUK SEDIAAN' => 200, 'KOMPOSISI' => 200, 'PARAMETER UJI' => 200, 'PUSTAKA' => 150, 'METODE' => 150, 'SYARAT' => 150, 'PRIORITAS' => 50));

				$this->newtable->search(array(array("CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END", "Berdasarkan Bidang Pengujian"), array("CASE WHEN LEN(GOLONGAN) = 11 THEN dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,7)) ELSE dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,6)) END", "Berdasarkan Nama Obat"), array("CASE WHEN LEN(GOLONGAN) = 11 THEN dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,9)) ELSE dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,8)) END", "Berdasarkan Bentuk Sediaan"), array("CASE WHEN LEN(GOLONGAN) = 11 THEN dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,11)) ELSE dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,10)) END", "Berdasarkan Komposisi"),array("PARAMETER_UJI", "Berdasarkan Parameter Uji"),array("PUSTAKA", "Berdasarkan Pustaka"),array("METODE", "Berdasarkan Metode"),array("SYARAT", "Berdasarkan Syarat"), array("PRIORITAS_TAHUN","Berdasarkan Prioritas")));

			}
			
			else if($id == "0107"){

				$query = "SELECT SRL_ID, CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END AS [BIDANG UJI],
						  CASE WHEN LEN(GOLONGAN) = 11 THEN dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,7))
						  ELSE dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,6))
						  END AS [INDUSTRI FARMASI],
						  CASE WHEN LEN(GOLONGAN) = 11 THEN dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,9))
						  ELSE dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,8))
						  END AS [KELOMPOK SEDIAAN],
						  CASE
						  WHEN LEN(GOLONGAN) = 11 THEN dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,11))
						  ELSE dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,10))
						  END AS [BENTUK SEDIAAN],
						  PARAMETER_UJI AS [PARAMETER UJI], PUSTAKA, METODE, SYARAT, PRIORITAS_TAHUN AS PRIORITAS 
						  FROM M_PRIORITAS WHERE LEFT(GOLONGAN,4) = '0107' AND STATUS IN ('2','9') AND VERIFI = '01' AND PRIORITAS_TAHUN = '".date("Y")."'";

				$this->newtable->columns(array("SRL_ID", "CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END" ,"CASE WHEN LEN(GOLONGAN) = 11 THEN dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,7)) ELSE dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,6)) END","CASE WHEN LEN(GOLONGAN) = 11 THEN dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,9)) ELSE dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,8)) END","CASE WHEN LEN(GOLONGAN) = 11 THEN dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,11)) ELSE dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,10)) END","PARAMETER_UJI", "PUSTAKA","METODE","SYARAT","PRIORITAS_TAHUN"));

				$this->newtable->width(array('BIDANG UJI' => 75,'INDUSTRI FARMASI' => 200, 'KELOMPOK SEDIAAN' => 200, 'BENTUK SEDIAAN' => 200, 'PARAMETER UJI' => 200, 'PUSTAKA' => 150, 'METODE' => 150, 'SYARAT' => 150, 'PRIORITAS' => 50));

				$this->newtable->search(array(array("CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END", "Berdasarkan Bidang Pengujian"), array("CASE WHEN LEN(GOLONGAN) = 11 THEN dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,7)) ELSE dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,6)) END", "Berdasarkan Nama Industri Farmasi"), array("CASE WHEN LEN(GOLONGAN) = 11 THEN dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,9)) ELSE dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,8)) END", "Berdasarkan Kelompok Sediaan"), array("CASE WHEN LEN(GOLONGAN) = 11 THEN dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,11)) ELSE dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,10)) END", "Berdasarkan Bentuk Sediaan"),array("PARAMETER_UJI", "Berdasarkan Parameter Uji"),array("PUSTAKA", "Berdasarkan Pustaka"),array("METODE", "Berdasarkan Metode"),array("SYARAT", "Berdasarkan Syarat"), array("PRIORITAS_TAHUN","Berdasarkan Prioritas")));

			}
			
			else if($id == "0108"){

				$query = "SELECT SRL_ID, CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END AS [BIDANG UJI],
						  CASE WHEN LEN(GOLONGAN) = 11 THEN dbo.GOLONGAN_SAMPEL_NEW(SUBSTRING(GOLONGAN,1,7))
						  ELSE dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,6))
						  END AS [NAMA OBAT],
						  CASE WHEN LEN(GOLONGAN) = 11 THEN dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,9))
						  ELSE dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,8))
						  END AS [ZAT AKTIF],
						  CASE
						  WHEN LEN(GOLONGAN) = 11 THEN dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,11))
						  ELSE dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,10))
						  END AS [BENTUK SEDIAAN],
						  PARAMETER_UJI AS [PARAMETER UJI], PUSTAKA, METODE, SYARAT, PRIORITAS_TAHUN AS PRIORITAS 
						  FROM M_PRIORITAS WHERE LEFT(GOLONGAN,4) = '0108' AND STATUS IN ('2','9') AND VERIFI = '01' AND PRIORITAS_TAHUN = '".date("Y")."'";

				$this->newtable->columns(array("SRL_ID", "CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END" ,"CASE WHEN LEN(GOLONGAN) = 11 THEN dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,7)) ELSE dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,6)) END","CASE WHEN LEN(GOLONGAN) = 11 THEN dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,9)) ELSE dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,8)) END","CASE WHEN LEN(GOLONGAN) = 11 THEN dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,11)) ELSE dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,10)) END","PARAMETER_UJI", "PUSTAKA","METODE","SYARAT","PRIORITAS_TAHUN"));

				$this->newtable->width(array('BIDANG UJI' => 75,'NAMA OBAT' => 200, 'ZAT AKTIF' => 200, 'BENTUK SEDIAAN' => 200, 'PARAMETER UJI' => 200, 'PUSTAKA' => 150, 'METODE' => 150, 'SYARAT' => 150, 'PRIORITAS' => 50));

				$this->newtable->search(array(array("CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END", "Berdasarkan Bidang Pengujian"), array("CASE WHEN LEN(GOLONGAN) = 11 THEN dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,7)) ELSE dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,6)) END", "Berdasarkan Nama Obat"), array("CASE WHEN LEN(GOLONGAN) = 11 THEN dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,9)) ELSE dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,8)) END", "Berdasarkan Zat Aktif"), array("CASE WHEN LEN(GOLONGAN) = 11 THEN dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,11)) ELSE dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,10)) END", "Bentuk Sediaan"),array("PARAMETER_UJI", "Berdasarkan Parameter Uji"),array("PUSTAKA", "Berdasarkan Pustaka"),array("METODE", "Berdasarkan Metode"),array("SYARAT", "Berdasarkan Syarat"), array("PRIORITAS_TAHUN","Berdasarkan Prioritas")));

			}else if($id == "0109"){

				$query = "SELECT SRL_ID, CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END AS [BIDANG UJI],
						  CASE WHEN LEN(GOLONGAN) = 11 THEN dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,7))
						  ELSE dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,6))
						  END AS [ZAT AKTIF],
						  CASE WHEN LEN(GOLONGAN) = 11 THEN dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,9))
						  ELSE dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,8))
						  END AS [BENTUK SEDIAAN],
						  CASE
						  WHEN LEN(GOLONGAN) = 11 THEN dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,11))
						  ELSE dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,10))
						  END AS [SEDIAAN PUSTAKA],
						  PARAMETER_UJI AS [PARAMETER UJI], PUSTAKA, METODE, SYARAT, PRIORITAS_TAHUN AS PRIORITAS 
						  FROM M_PRIORITAS WHERE LEFT(GOLONGAN,4) = '0109' AND STATUS IN ('2','9') AND VERIFI = '01' AND PRIORITAS_TAHUN = '".date("Y")."'";

				$this->newtable->columns(array("SRL_ID", "CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END" ,"CASE WHEN LEN(GOLONGAN) = 11 THEN dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,7)) ELSE dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,6)) END","CASE WHEN LEN(GOLONGAN) = 11 THEN dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,9)) ELSE dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,8)) END","CASE WHEN LEN(GOLONGAN) = 11 THEN dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,11)) ELSE dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,10)) END","PARAMETER_UJI", "PUSTAKA","METODE","SYARAT","PRIORITAS_TAHUN"));

				$this->newtable->width(array('BIDANG UJI' => 75,'ZAT AKTIF' => 200, 'BENTUK SEDIAAN' => 200, 'SEDIAAN PUSTAKA' => 200, 'PARAMETER UJI' => 200, 'PUSTAKA' => 150, 'METODE' => 150, 'SYARAT' => 150, 'PRIORITAS' => 50));

				$this->newtable->search(array(array("CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END", "Berdasarkan Bidang Pengujian"), array("CASE WHEN LEN(GOLONGAN) = 11 THEN dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,7)) ELSE dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,6)) END", "Berdasarkan Zat Aktif"), array("CASE WHEN LEN(GOLONGAN) = 11 THEN dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,9)) ELSE dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,8)) END", "Berdasarkan Bentuk Sediaan"), array("CASE WHEN LEN(GOLONGAN) = 11 THEN dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,11)) ELSE dbo.GOLONGAN_SAMPEL_2016(SUBSTRING(GOLONGAN,1,10)) END", "Sediaan Pustaka"),array("PARAMETER_UJI", "Berdasarkan Parameter Uji"),array("PUSTAKA", "Berdasarkan Pustaka"),array("METODE", "Berdasarkan Metode"),array("SYARAT", "Berdasarkan Syarat"), array("PRIORITAS_TAHUN","Berdasarkan Prioritas")));

			}

			else if($id == "0110" || $id == "0111" || $id == "0112"  || $id == "0113"){

				$query = "SELECT SRL_ID, CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END AS [BIDANG UJI],

						  CASE WHEN LEN(GOLONGAN) = 11 THEN dbo.GOLONGAN_SAMPEL_NEW(SUBSTRING(GOLONGAN,1,7))

						  ELSE dbo.GOLONGAN_SAMPEL_NEW(SUBSTRING(GOLONGAN,1,6))

						  END AS [ZAT AKTIF],

						  CASE WHEN LEN(GOLONGAN) = 11 THEN dbo.GOLONGAN_SAMPEL_NEW(SUBSTRING(GOLONGAN,1,9))

						  ELSE dbo.GOLONGAN_SAMPEL_NEW(SUBSTRING(GOLONGAN,1,8))

						  END AS [BENTUK SEDIAAN],

						  CASE

						  WHEN LEN(GOLONGAN) = 11 THEN dbo.GOLONGAN_SAMPEL_NEW(SUBSTRING(GOLONGAN,1,11))

						  ELSE dbo.GOLONGAN_SAMPEL_NEW(SUBSTRING(GOLONGAN,1,10))

						  END AS [SEDIAAN PUSTAKA],

						  PARAMETER_UJI AS [PARAMETER UJI], PUSTAKA, METODE, SYARAT, PRIORITAS_TAHUN AS PRIORITAS 

						  FROM M_PRIORITAS WHERE LEFT(GOLONGAN,4) = '".$id."' AND STATUS IN ('2','9') AND VERIFI = '01' AND PRIORITAS_TAHUN = '".date("Y")."'";

				$this->newtable->columns(array("SRL_ID", "CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END" ,"CASE WHEN LEN(GOLONGAN) = 11 THEN dbo.GOLONGAN_SAMPEL_NEW(SUBSTRING(GOLONGAN,1,7)) ELSE dbo.GOLONGAN_SAMPEL_NEW(SUBSTRING(GOLONGAN,1,6)) END","CASE WHEN LEN(GOLONGAN) = 11 THEN dbo.GOLONGAN_SAMPEL_NEW(SUBSTRING(GOLONGAN,1,9)) ELSE dbo.GOLONGAN_SAMPEL_NEW(SUBSTRING(GOLONGAN,1,8)) END","CASE WHEN LEN(GOLONGAN) = 11 THEN dbo.GOLONGAN_SAMPEL_NEW(SUBSTRING(GOLONGAN,1,11)) ELSE dbo.GOLONGAN_SAMPEL_NEW(SUBSTRING(GOLONGAN,1,10)) END","PARAMETER_UJI", "PUSTAKA","METODE","SYARAT","PRIORITAS_TAHUN"));

				$this->newtable->width(array('BIDANG UJI' => 75,'ZAT AKTIF' => 200, 'BENTUK SEDIAAN' => 200, 'SEDIAAN PUSTAKA' => 200, 'PARAMETER UJI' => 200, 'PUSTAKA' => 150, 'METODE' => 150, 'SYARAT' => 150, 'PRIORITAS' => 50));

				$this->newtable->search(array(array("CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END", "Berdasarkan Bidang Pengujian"), array("CASE WHEN LEN(GOLONGAN) = 11 THEN dbo.GOLONGAN_SAMPEL_NEW(SUBSTRING(GOLONGAN,1,7)) ELSE dbo.GOLONGAN_SAMPEL_NEW(SUBSTRING(GOLONGAN,1,6)) END", "Berdasarkan Zat Aktif"), array("CASE WHEN LEN(GOLONGAN) = 11 THEN dbo.GOLONGAN_SAMPEL_NEW(SUBSTRING(GOLONGAN,1,9)) ELSE dbo.GOLONGAN_SAMPEL_NEW(SUBSTRING(GOLONGAN,1,8)) END", "Berdasarkan Bentuk Sediaan"), array("CASE WHEN LEN(GOLONGAN) = 11 THEN dbo.GOLONGAN_SAMPEL_NEW(SUBSTRING(GOLONGAN,1,11)) ELSE dbo.GOLONGAN_SAMPEL_NEW(SUBSTRING(GOLONGAN,1,10)) END", "Sediaan Pustaka"),array("PARAMETER_UJI", "Berdasarkan Parameter Uji"),array("PUSTAKA", "Berdasarkan Pustaka"),array("METODE", "Berdasarkan Metode"),array("SYARAT", "Berdasarkan Syarat"), array("PRIORITAS_TAHUN","Berdasarkan Prioritas")));

			}
			
			if($this->newsession->userdata('SESS_BBPOM_ID') == '50' || in_array('9', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('4', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('1', $this->newsession->userdata('SESS_KODE_ROLE')))
			{					
				$proses['Parameter Uji Baru'] = array('GET',site_url().'/home/prioritas/parameter-uji/new/'. $id,'0');
				$this->newtable->menu($proses);
			}
			$this->newtable->action(site_url()."/home/prioritas/parameter-uji/".$id);
			$this->newtable->hiddens(array('SRL_ID'));
			$this->newtable->cidb($this->db);
			$this->newtable->ciuri($this->uri->segment_array());
			$this->newtable->orderby(1);
			$this->newtable->sortby("ASC");
			$this->newtable->keys(array('SRL_ID'));
			$tabel = $this->newtable->generate($query);
			$arrdata = array('table' => $tabel,
							 'idjudul' => 'juduluji',
							 'caption_header' => 'Parameter Uji Prioritas Sampling - Obat '.$sipt->main->get_uraian("SELECT dbo.KATEGORI('".$id."','1') AS KATEGORI","KATEGORI"),
							 'batal' => '',
							 'cancel' => '');
			return $arrdata;
		}else{
			$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');
		}
	}

	function list_10($id){

		if((in_array('1', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('9', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('4', $this->newsession->userdata('SESS_KODE_ROLE'))) && $this->newsession->userdata('LOGGED_IN') ==  TRUE){

			$sipt =& get_instance();

			$sipt->load->model("main", "main", true);

			$this->load->library('newtable');

			$query = "SELECT SRL_ID, CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END AS [BIDANG UJI], dbo.GOLONGAN_SAMPEL_NEW(SUBSTRING(GOLONGAN,1,4)) AS KATEGORI, dbo.GOLONGAN_SAMPEL_NEW(SUBSTRING(GOLONGAN,1,6)) AS [SUB KATEGORI], PARAMETER_UJI AS [PARAMETER UJI], PUSTAKA, METODE, SYARAT, PRIORITAS_TAHUN AS PRIORITAS FROM M_PRIORITAS WHERE LEFT(GOLONGAN,2) = '10' AND STATUS IN ('2','9') AND VERIFI = '01'";

			$this->newtable->columns(array("SRL_ID", "CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END", "dbo.GOLONGAN_SAMPEL_NEW(SUBSTRING(GOLONGAN,1,4))","dbo.GOLONGAN_SAMPEL_NEW(SUBSTRING(GOLONGAN,1,6))", "ARAMETER_UJI", "PUSTAKA", "METODE", "SYARAT", "PRIORITAS"));

			$this->newtable->width(array('BIDANG UJI' => 75,'KATEGORI' => 200, 'SUB KATEGORI' => 200, 'PARAMETER UJI' => 200, 'PUSTAKA' => 150, 'METODE' => 150, 'SYARAT' => 150, 'PRIORITAS' => 50));

			$this->newtable->search(array(array("CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END", "Berdasarkan Bidang Pengujian"), array("dbo.GOLONGAN_SAMPEL_NEW(SUBSTRING(GOLONGAN,1,4))", "Berdasarkan Kategori"), array("dbo.GOLONGAN_SAMPEL_NEW(SUBSTRING(GOLONGAN,1,6))", "Berdasarkan Sub Kategori"), array("PARAMETER_UJI", "Berdasarkan Parameter Uji"),array("PUSTAKA", "Berdasarkan Pustaka"),array("METODE", "Berdasarkan Metode"),array("SYARAT", "Berdasarkan Syarat"), array("PRIORITAS","Berdasarkan Prioritas")));

			$this->newtable->action(site_url()."/home/prioritas/parameter-uji/".$id);

			$this->newtable->hiddens(array('SRL_ID'));

			$this->newtable->cidb($this->db);

			$this->newtable->ciuri($this->uri->segment_array());

			$this->newtable->orderby(1);

			$this->newtable->sortby("ASC");

			$this->newtable->keys(array('SRL_ID'));

			#if($this->newsession->userdata('SESS_BBPOM_ID') == '00' ||  in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))){

				$proses['Parameter Uji Baru'] = array('GET',site_url().'/home/prioritas/parameter-uji/new/'. $id,'0');

				$this->newtable->menu($proses);

			#}

			$tabel = $this->newtable->generate($query);

			$arrdata = array('table' => $tabel,

							 'idjudul' => 'juduluji',

							 'caption_header' => 'Parameter Uji Prioritas Sampling - Obat Tradisional',

							 'batal' => '',

							 'cancel' => '');

			return $arrdata;

		}else{

			$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');

		}

	}

	

	function list_11($id){

		if((in_array('1', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('9', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('4', $this->newsession->userdata('SESS_KODE_ROLE'))) && $this->newsession->userdata('LOGGED_IN') ==  TRUE){

			$sipt =& get_instance();

			$sipt->load->model("main", "main", true);

			$this->load->library('newtable');

			$query = "SELECT SRL_ID, CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END AS [BIDANG UJI], dbo.GOLONGAN_SAMPEL_NEW(SUBSTRING(GOLONGAN,1,4)) AS KATEGORI, dbo.GOLONGAN_SAMPEL_NEW(SUBSTRING(GOLONGAN,1,6)) AS [SUB KATEGORI], PARAMETER_UJI AS [PARAMETER UJI], PUSTAKA, METODE, SYARAT, PRIORITAS_TAHUN AS PRIORITAS FROM M_PRIORITAS WHERE LEFT(GOLONGAN,2) = '11' AND STATUS IN ('2','9') AND VERIFI = '01'";

			$this->newtable->columns(array("SRL_ID", "CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END", "dbo.GOLONGAN_SAMPEL_NEW(SUBSTRING(GOLONGAN,1,4))","dbo.GOLONGAN_SAMPEL_NEW(SUBSTRING(GOLONGAN,1,6))", "ARAMETER_UJI", "PUSTAKA", "METODE", "SYARAT", "PRIORITAS"));

			$this->newtable->width(array('BIDANG UJI' => 75,'KATEGORI' => 200, 'SUB KATEGORI' => 200, 'PARAMETER UJI' => 200, 'PUSTAKA' => 150, 'METODE' => 150, 'SYARAT' => 150, 'PRIORITAS' => 50));

			$this->newtable->search(array(array("CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END", "Berdasarkan Bidang Pengujian"), array("dbo.GOLONGAN_SAMPEL_NEW(SUBSTRING(GOLONGAN,1,4))", "Berdasarkan Kategori"), array("dbo.GOLONGAN_SAMPEL_NEW(SUBSTRING(GOLONGAN,1,6))", "Berdasarkan Sub Kategori"), array("PARAMETER_UJI", "Berdasarkan Parameter Uji"),array("PUSTAKA", "Berdasarkan Pustaka"),array("METODE", "Berdasarkan Metode"),array("SYARAT", "Berdasarkan Syarat"), array("PRIORITAS","Berdasarkan Prioritas")));

			$this->newtable->action(site_url()."/home/prioritas/parameter-uji/".$id);

			$this->newtable->hiddens(array('SRL_ID'));

			$this->newtable->cidb($this->db);

			$this->newtable->ciuri($this->uri->segment_array());

			$this->newtable->orderby(1);

			$this->newtable->sortby("ASC");

			$this->newtable->keys(array('SRL_ID'));

			#if($this->newsession->userdata('SESS_BBPOM_ID') == '00' ||  in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))){

				$proses['Parameter Uji Baru'] = array('GET',site_url().'/home/prioritas/parameter-uji/new/'. $id,'0');

				$this->newtable->menu($proses);

			#}

			$tabel = $this->newtable->generate($query);

			$arrdata = array('table' => $tabel,

							 'idjudul' => 'juduluji',

							 'caption_header' => 'Parameter Uji Prioritas Sampling - Suplemen Makanan',

							 'batal' => '',

							 'cancel' => '');

			return $arrdata;

		}else{

			$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');

		}

	}

	

	function list_12($id){

		if((in_array('1', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('9', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('4', $this->newsession->userdata('SESS_KODE_ROLE'))) && $this->newsession->userdata('LOGGED_IN') ==  TRUE){

			$sipt =& get_instance();

			$sipt->load->model("main", "main", true);

			$this->load->library('newtable');

			$query = "SELECT SRL_ID, CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END AS [BIDANG UJI], dbo.GOLONGAN_SAMPEL_NEW(SUBSTRING(GOLONGAN,1,4)) AS KATEGORI, dbo.GOLONGAN_SAMPEL_NEW(SUBSTRING(GOLONGAN,1,6)) AS [SUB KATEGORI], PARAMETER_UJI AS [PARAMETER UJI], PUSTAKA, METODE, SYARAT, PRIORITAS_TAHUN AS PRIORITAS FROM M_PRIORITAS WHERE LEFT(GOLONGAN,2) = '12' AND STATUS IN ('2','9') AND VERIFI = '01'";

			$this->newtable->columns(array("SRL_ID", "CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END", "dbo.GOLONGAN_SAMPEL_NEW(SUBSTRING(GOLONGAN,1,4))","dbo.GOLONGAN_SAMPEL_NEW(SUBSTRING(GOLONGAN,1,6))", "ARAMETER_UJI", "PUSTAKA", "METODE", "SYARAT", "PRIORITAS"));

			$this->newtable->width(array('BIDANG UJI' => 75,'KATEGORI' => 200, 'SUB KATEGORI' => 200, 'PARAMETER UJI' => 200, 'PUSTAKA' => 150, 'METODE' => 150, 'SYARAT' => 150, 'PRIORITAS' => 50));

			$this->newtable->search(array(array("CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END", "Berdasarkan Bidang Pengujian"), array("dbo.GOLONGAN_SAMPEL_NEW(SUBSTRING(GOLONGAN,1,4))", "Berdasarkan Kategori"), array("dbo.GOLONGAN_SAMPEL_NEW(SUBSTRING(GOLONGAN,1,6))", "Berdasarkan Sub Kategori"), array("PARAMETER_UJI", "Berdasarkan Parameter Uji"),array("PUSTAKA", "Berdasarkan Pustaka"),array("METODE", "Berdasarkan Metode"),array("SYARAT", "Berdasarkan Syarat"), array("PRIORITAS","Berdasarkan Prioritas")));

			$this->newtable->action(site_url()."/home/prioritas/parameter-uji/".$id);

			$this->newtable->hiddens(array('SRL_ID'));

			$this->newtable->cidb($this->db);

			$this->newtable->ciuri($this->uri->segment_array());

			$this->newtable->orderby(1);

			$this->newtable->sortby("ASC");

			$this->newtable->keys(array('SRL_ID'));

			#if($this->newsession->userdata('SESS_BBPOM_ID') == '00' ||  in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))){

				$proses['Parameter Uji Baru'] = array('GET',site_url().'/home/prioritas/parameter-uji/new/'. $id,'0');

				$this->newtable->menu($proses);

			#}

			$tabel = $this->newtable->generate($query);

			$arrdata = array('table' => $tabel,

							 'idjudul' => 'juduluji',

							 'caption_header' => 'Parameter Uji Prioritas Sampling - Kosmetika',

							 'batal' => '',

							 'cancel' => '');

			return $arrdata;

		}else{

			$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');

		}

	}

	

	function list_14($id){

		if((in_array('1', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('9', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('4', $this->newsession->userdata('SESS_KODE_ROLE'))) && $this->newsession->userdata('LOGGED_IN') ==  TRUE){

			$sipt =& get_instance();

			$sipt->load->model("main", "main", true);

			$this->load->library('newtable');

			$query = "SELECT SRL_ID, CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END AS [BIDANG UJI], dbo.GOLONGAN_SAMPEL_NEW(SUBSTRING(GOLONGAN,1,4)) AS KATEGORI, dbo.GOLONGAN_SAMPEL_NEW(SUBSTRING(GOLONGAN,1,6)) AS [SUB KATEGORI], PARAMETER_UJI AS [PARAMETER UJI], PUSTAKA, SIMULAN, METODE, SYARAT, PRIORITAS_TAHUN AS PRIORITAS FROM M_PRIORITAS WHERE LEFT(GOLONGAN,2) = '14' AND STATUS IN ('2','9') AND VERIFI = '01'";

			$this->newtable->columns(array("SRL_ID", "CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END", "dbo.GOLONGAN_SAMPEL_NEW(SUBSTRING(GOLONGAN,1,4))","dbo.GOLONGAN_SAMPEL_NEW(SUBSTRING(GOLONGAN,1,6))", "PARAMETER_UJI", "PUSTAKA", "METODE", "SYARAT", "PRIORITAS"));

			$this->newtable->width(array('BIDANG UJI' => 75,'KATEGORI' => 200, 'SUB KATEGORI' => 200, 'PARAMETER UJI' => 200, 'SIMULAN' => 200,'PUSTAKA' => 150, 'METODE' => 150, 'SYARAT' => 150, 'PRIORITAS' => 50));

			$this->newtable->search(array(array("CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END", "Berdasarkan Bidang Pengujian"), array("dbo.GOLONGAN_SAMPEL_NEW(SUBSTRING(GOLONGAN,1,4))", "Berdasarkan Kategori"), array("dbo.GOLONGAN_SAMPEL_NEW(SUBSTRING(GOLONGAN,1,6))", "Berdasarkan Sub Kategori"), array("PARAMETER_UJI", "Berdasarkan Parameter Uji"),array("PUSTAKA", "Berdasarkan Pustaka"),array("METODE", "Berdasarkan Metode"),array("SYARAT", "Berdasarkan Syarat"), array("PRIORITAS","Berdasarkan Prioritas")));

			$this->newtable->action(site_url()."/home/prioritas/parameter-uji/".$id);

			$this->newtable->hiddens(array('SRL_ID'));

			$this->newtable->cidb($this->db);

			$this->newtable->ciuri($this->uri->segment_array());

			$this->newtable->orderby(1);

			$this->newtable->sortby("ASC");

			$this->newtable->keys(array('SRL_ID'));

			if($this->newsession->userdata('SESS_BBPOM_ID') == '00' ||  in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))){

				$proses['Parameter Uji Baru'] = array('GET',site_url().'/home/prioritas/parameter-uji/new/'. $id,'0');

				$this->newtable->menu($proses);

			}

			$tabel = $this->newtable->generate($query);

			$arrdata = array('table' => $tabel,

							 'idjudul' => 'juduluji',

							 'caption_header' => 'Parameter Uji Prioritas Sampling - Kemasan Pangan',

							 'batal' => '',

							 'cancel' => '');

			return $arrdata;

		}else{

			$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');

		}

	}



	

	function list_13($id){

		if((in_array('1', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('9', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('4', $this->newsession->userdata('SESS_KODE_ROLE'))) && $this->newsession->userdata('LOGGED_IN') ==  TRUE){

			$sipt =& get_instance();

			$sipt->load->model("main", "main", true);

			$this->load->library('newtable');

			$query = "SELECT SRL_ID, CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END AS [BIDANG UJI], dbo.GOLONGAN_SAMPEL_NEW(SUBSTRING(GOLONGAN,1,4)) AS KATEGORI, dbo.GOLONGAN_SAMPEL_NEW(SUBSTRING(GOLONGAN,1,6)) AS [SUB KATEGORI],CASE WHEN LEN(LTRIM(RTRIM(GOLONGAN))) > 6 THEN dbo.GOLONGAN_SAMPEL_NEW(SUBSTRING(GOLONGAN,1,8)) ELSE '' END AS [SUB SUB KATEGORI], CASE WHEN LEN(LTRIM(RTRIM(GOLONGAN))) > 8 THEN dbo.GOLONGAN_SAMPEL_NEW(SUBSTRING(GOLONGAN,1,10)) ELSE '' END AS [SUB SUB SUB KATEGORI], PARAMETER_UJI AS [PARAMETER UJI], PUSTAKA, METODE, SYARAT, PRIORITAS_TAHUN AS PRIORITAS FROM M_PRIORITAS WHERE LEFT(GOLONGAN,2) = '13' AND STATUS IN ('2','9') AND VERIFI = '01' AND PRIORITAS_TAHUN='".date('Y')."' ";

			$this->newtable->columns(array("SRL_ID", "CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END", "dbo.GOLONGAN_SAMPEL_NEW(SUBSTRING(GOLONGAN,1,4))","dbo.GOLONGAN_SAMPEL_NEW(SUBSTRING(GOLONGAN,1,6))", "CASE WHEN LEN(LTRIM(RTRIM(GOLONGAN))) > 6 THEN dbo.GOLONGAN_SAMPEL_NEW(SUBSTRING(GOLONGAN,1,8)) ELSE '' END", "CASE WHEN LEN(LTRIM(RTRIM(GOLONGAN))) > 8 THEN dbo.GOLONGAN_SAMPEL_NEW(SUBSTRING(GOLONGAN,1,10)) ELSE '' END" ,"PARAMETER_UJI", "PUSTAKA", "METODE", "SYARAT", "PRIORITAS_TAHUN"));

			$this->newtable->width(array('BIDANG UJI' => 75,'KATEGORI' => 200, 'SUB KATEGORI' => 200, 'SUB SUB KATEGORI' => 200, 'SUB SUB SUB KATEGORI' => 200, 'PARAMETER UJI' => 200, 'PUSTAKA' => 150, 'METODE' => 150, 'SYARAT' => 150, 'PRIORITAS' => 50));

			$this->newtable->search(array(array("CASE WHEN BIDANG_UJI = '01' THEN 'Mikrobiologi' WHEN BIDANG_UJI = '02' THEN 'Kimia' END", "Berdasarkan Bidang Pengujian"), array("dbo.GOLONGAN_SAMPEL_NEW(SUBSTRING(GOLONGAN,1,4))", "Berdasarkan Kategori"), array("dbo.GOLONGAN_SAMPEL_NEW(SUBSTRING(GOLONGAN,1,6))", "Berdasarkan Sub Kategori"), array("CASE WHEN LEN(LTRIM(RTRIM(GOLONGAN))) > 6 THEN dbo.GOLONGAN_SAMPEL_NEW(SUBSTRING(GOLONGAN,1,8)) ELSE '' END", "Berdasarkan Sub Sub Kategori"), array("CASE WHEN LEN(LTRIM(RTRIM(GOLONGAN))) > 8 THEN dbo.GOLONGAN_SAMPEL_NEW(SUBSTRING(GOLONGAN,1,10)) ELSE '' END", "Berdasarkan Sub Sub Sub Kategori"),array("PARAMETER_UJI", "Berdasarkan Parameter Uji"),array("PUSTAKA", "Berdasarkan Pustaka"),array("METODE", "Berdasarkan Metode"),array("SYARAT", "Berdasarkan Syarat"), array("PRIORITAS_TAHUN","Berdasarkan Prioritas")));

			$this->newtable->action(site_url()."/home/prioritas/parameter-uji/".$id);

			$this->newtable->hiddens(array('SRL_ID'));

			$this->newtable->cidb($this->db);

			$this->newtable->ciuri($this->uri->segment_array());

			$this->newtable->orderby(1);

			$this->newtable->sortby("ASC");

			$this->newtable->keys(array('SRL_ID'));

			$tabel = $this->newtable->generate($query);

			if($this->newsession->userdata('SESS_BBPOM_ID') == '00' ||  in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))){

				$proses['Parameter Uji Baru'] = array('GET',site_url().'/home/prioritas/parameter-uji/new/'. $id,'0');

				$this->newtable->menu($proses);

			}

			$arrdata = array('table' => $tabel,

							 'idjudul' => 'juduluji',

							 'caption_header' => 'Parameter Uji Prioritas Sampling - Produk Pangan',

							 'batal' => '',

							 'cancel' => '');

			return $arrdata;

		}else{

			$this->fungsi->redirectMessage('Maaf anda tidak diperkenankan mengakses halaman ini.','/home');

		}

	}

	

	function get_prioritas($kategori,$id){

		if($this->newsession->userdata('LOGGED_IN') == TRUE){
			$sipt =& get_instance();
			$sipt->load->model("main", "main", true);
			$digit = strlen($kategori);
			if($digit == 2){
				$arrdata['komoditi'] = $sipt->main->get_uraian("SELECT KLASIFIKASI FROM M_GOLONGAN_2016 WHERE KLASIFIKASI_ID = '".$kategori."'","KLASIFIKASI");
				$arrdata['kategori'] = $sipt->main->combobox("SELECT LTRIM(RTRIM(KLASIFIKASI_ID)) AS KLASIFIKASI_ID, KLASIFIKASI FROM M_GOLONGAN_2016 WHERE LEFT(KLASIFIKASI_ID,2) = '".$kategori."' AND LEN(KLASIFIKASI_ID) = 4 AND KLASIFIKASI IS NOT NULL ORDER BY 2","KLASIFIKASI_ID","KLASIFIKASI", TRUE);
			}else{
				$arrdata['komoditi'] = $sipt->main->get_uraian("SELECT KLASIFIKASI FROM M_GOLONGAN_2016 WHERE LEFT(KLASIFIKASI_ID,2) = '".substr($kategori,0,2)."'","KLASIFIKASI");
				$arrdata['kategori'] = $sipt->main->combobox("SELECT LTRIM(RTRIM(KLASIFIKASI_ID)) AS KLASIFIKASI_ID, KLASIFIKASI FROM M_GOLONGAN_2016 WHERE KLASIFIKASI_ID = '".$kategori."'","KLASIFIKASI_ID","KLASIFIKASI",TRUE);
			}
			
			if(substr($kategori, 0,2) == "01" && $kategori == "0106"){
				$arrdata['cb_parameter'] = $sipt->main->combobox("SELECT ID, PARAMETER_UJI_KRITIS FROM T_PARAMETER_UJI_KRITIS WHERE KOMODITI = '".substr($kategori,0,2)."' AND KATEGORI = '".$kategori."' ORDER BY 2","ID","PARAMETER_UJI_KRITIS",TRUE);	
			}
			
			
			$arrdata['kategori_tms'] = $sipt->main->combobox("SELECT KATEGORI_PU, NAMA_KATEGORI_PU FROM M_KATEGORI_PU WHERE LEFT(KATEGORI_PU,2) = '".($digit == 2 ? $kategori : substr($kategori,0,2))."' AND LEN(KATEGORI_PU) > 2", "NAMA_KATEGORI_PU","NAMA_KATEGORI_PU",TRUE);
			$arrdata['bidang_uji'] = $sipt->main->combobox("SELECT KODE, URAIAN FROM M_TABEL WHERE JENIS = 'BIDANG_PENGUJIAN' ORDER BY 1 ASC", "KODE","URAIAN",TRUE);
			$arrdata['act'] = site_url().'/post/prioritas/prioritas_act/save';
			$arrdata['kategorix'] = $kategori;
			return $arrdata;

		}

	}

	

	function set_prioritas($action, $isajax){

		if($this->newsession->userdata('LOGGED_IN') == TRUE){

			if($action == "save"){

				$sipt =& get_instance();

				$this->load->model("main", "main", true);

				$hasil = FALSE;

				$msgok = "MSG#YES#Data parameter uji prioritas sampling berhasil disimpan#back";

				$msgerr = "MSG#NO#Data parameter uji  prioritas sampling gagal disimpan. \n Silahkan coba beberapa saat lagi.";

				$arr = $sipt->main->post_to_query($this->input->post('PRIORITAS')); 

				$arrgol = array_filter($this->input->post('GOLONGAN'));

				$golongan = $arrgol[count($arrgol)-1]; 

				$prioritas = $this->input->post('PRIORITAS');

				$arrkeys = array_keys($prioritas);

				#awal

				$parameter = array();

				for($s = 0; $s < count($_POST['PRIORITAS']['BIDANG_UJI']); $s++){							

							$parameter = array('SRL_ID' => ((int)$sipt->main->get_uraian("SELECT MAX(SRL_ID) AS SRL_ID FROM M_PRIORITAS","SRL_ID") + 1),

											   'GOLONGAN' => $golongan,

											   'PRIORITAS_TAHUN' => date("Y"),

											   'CREATE_DATE' => 'GETDATE()',

											   'CREATE_BY' => $this->newsession->userdata('SESS_USER_ID'),

											   'VERIFI' => '01',

											   'BBPOM_ID' => $this->newsession->userdata('SESS_BBPOM_ID'),

											   'STATUS' => '9');

							for($j=0;$j<count($arrkeys);$j++){

								$parameter[$arrkeys[$j]] = $prioritas[$arrkeys[$j]][$s];

							}

							$this->db->insert('M_PRIORITAS', $parameter);

							$hasil = TRUE;

				}

				#akhir

				/*$arr['SRL_ID'] = ((int)$sipt->main->get_uraian("SELECT MAX(SRL_ID) AS SRL_ID FROM M_PRIORITAS","SRL_ID") + 1);

				$arr['GOLONGAN'] = $golongan;

				$arr['PRIORITAS_TAHUN'] = date("Y");

				$arr['CREATE_DATE'] = 'GETDATE()';

				$arr['CREATE_BY'] = $this->newsession->userdata('SESS_USER_ID');

				$arr['VERIFI'] = '01';

				$arr['BBPOM_ID'] = $this->newsession->userdata('SESS_BBPOM_ID');

				$arr['STATUS'] = '9';

				$this->db->insert('M_PRIORITAS', $arr);

				if($this->db->affected_rows() > 0){

            		$hasil = TRUE;

				}*/

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



	function list_prioritas($kategori, $prioritas){

		$this->load->library('newtable31');

		$table = $this->newtable31;

		$query = "SELECT BBPOM_ID, REPLACE(REPLACE(NAMA_BBPOM,'BALAI BESAR POM DI ', ''),'BALAI POM DI ','') AS [BBPOM / BPOM], KODE_BALAI AS [KODE BALAI], TIPE AS [TIPE BALAI], ALAMAT_BALAI AS [ALAMAT], KOTA FROM M_BBPOM WHERE BBPOM_ID NOT IN ('00','91','92','93','94','95','96','99')";

		$table->title("");

		$table->columns(array("BBPOM_ID","REPLACE(REPLACE(NAMA_BBPOM,'BALAI BESAR POM DI ', ''),'BALAI POM DI ','')", "KODE_BALAI","TIPE", "ALAMAT_BALAI", "KOTA"));

		$table->width(array('BBPOM / BPOM' => 250, 'KODE BALAI' => 75, 'TIPE BALAI' => 75, 'ALAMAT' => 400, 'KOTA' => 100));

		/*$this->newtable->search(array(array("SRT_NAMA_SARANA","Nama Sarana"),

									  array("SRT_ALAMAT","Alamat Sarana"),

									  array("SRT_PRODUK","Nama Produk"),

									  array("SRT_JNS_PRODUK","Jenis Produk"),

									  array("DATE_FORMAT(SRT_PERIKSA_AWAL,'%Y-%m-%d')", "Periode Awal Periksa", array('DATERANGE', array('TRUE', 'data-date-format', 'yyyy-mm-dd'))),

									  array("DATE_FORMAT(SRT_PERIKSA_AKHIR,'%d-%m-%Y')", "Tanggal Akhir Periksa", array('DATEPICKER', array('TRUE', 'data-date-format', 'dd-mm-yyyy'))),

									  array("SRT_HASIL", 'Hasil Pemeriksaan', array('ARRAY', $arrcb))

									  ));*/

		$table->search(array(array('NAMA_BBPOM', 'Berdasarkan Nama BBPOM / BPOM'), array('TIPE', 'Berdasarkan Tipe Balai')));

		$table->cidb($this->db);

		$table->ciuri($this->uri->segment_array());

		$table->action(site_url()."index.php/browse/data");

		//$table->detail(site_url()."index.php/browse/expand");

		$table->orderby(2);

		$table->sortby("ASC");

		$table->keys(array("BBPOM_ID"));

		$table->hiddens(array("BBPOM_ID"));

		$table->use_ajax(TRUE);

		$table->show_search(TRUE);

		$table->show_chk(TRUE);

		

		#Extend code

		//$table->addfilter(TRUE);

		//$table->fieldfilter("MONTH(SRT_PERIKSA_AWAL) = '5'");

		$table->single(TRUE);

		$table->dropdown(TRUE);

		$table->expandrow(TRUE);

		//$table->hashids(TRUE);

		$table->postmethod(TRUE);

		$table->tbtarget("tb_bbpom");

		#End Extend code 

		$arrdata = array('tabel' => $table->generate($query));

		if($this->input->post("data-post")) return $table->generate($query);

		else return $arrdata;

	}

	

}

?>