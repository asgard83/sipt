<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Lhu extends Controller{
	
	function Lhu(){
		parent::Controller();
	}
	
	function index(){
	  	$this->fungsi->redirectMessage('Maaf anda tidak bisa mengakses halaman ini.','/home');
	}
	
	function prints($id){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$this->load->library('mpdf');
			$arrid = explode(".",$id);


			$arr_sampel = $this->db->query("SELECT A.NAMA_SAMPEL, A.KODE_SAMPEL, dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) AS KODE, dbo.FORMAT_NOMOR('SPU',C.SPU_ID) AS SPU, A.TEMPAT_SAMPLING, CONVERT(VARCHAR(10), A.TANGGAL_SAMPLING, 103) AS TANGGAL_SAMPLING, A.ALAMAT_SAMPLING, A.NOMOR_REGISTRASI, A.PABRIK, A.IMPORTIR, A.KEMASAN, A.BENTUK_SEDIAAN, A.NO_BETS, A.SATUAN, dbo.KATEGORI(A.KOMODITI,A.PRIORITAS) AS KOMODITI, dbo.KATEGORI(A.KATEGORI,A.PRIORITAS) AS KATEGORI, A.KETERANGAN_ED, A.JUMLAH_SAMPEL, A.JUMLAH_KIMIA, A.JUMLAH_MIKRO, REPLACE(A.KOMPOSISI,';','<br>') AS KOMPOSISI, A.NETTO, A.PEMERIAN, B.NOMOR_SURAT, CONVERT(VARCHAR(10), B.TANGGAL_SURAT, 103) AS TANGGAL_SURAT, B.NAMA_PENGIRIM, CONVERT(VARCHAR(10), C.TANGGAL_TERIMA_TPS, 103) AS TANGGAL_TERIMA_TPS, CONVERT(VARCHAR(10), C.TANGGAL, 103) AS TANGGAL_SPU, A.JUMLAH_KIMIA, A.UJI_KIMIA, A.UJI_MIKRO, A.JUMLAH_MIKRO, CASE WHEN A.HASIL_KIMIA = 'MS' THEN 'Memenuhi Syarat' WHEN A.HASIL_KIMIA = 'TMS' THEN 'Tidak Memenuhi Syarat' ELSE 'Hasil Pengujian Seperti Tersebut' END HASIL_KIMIA, CASE WHEN A.HASIL_MIKRO = 'MS' THEN 'Memenuhi Syarat' WHEN A.HASIL_MIKRO = 'TMS' THEN 'Tidak Memenuhi Syarat' ELSE 'Hasil Pengujian Seperti Tersebut' END HASIL_MIKRO, CASE WHEN A.HASIL_SAMPEL = 'MS' THEN 'Memenuhi Syarat' WHEN A.HASIL_SAMPEL = 'TMS' THEN 'Tidak Memenuhi Syarat' ELSE 'Hasil Pengujian Seperti Tersebut' END HASIL_SAMPEL, A.CATATAN_CP FROM T_M_SAMPEL A LEFT JOIN T_PERIKSA_SAMPEL B ON A.PERIKSA_SAMPEL = B.PERIKSA_SAMPEL LEFT JOIN T_SPU C ON A.SPU_ID = C.SPU_ID WHERE A.KODE_SAMPEL = '".$arrid[1]."'")->result_array();

			$chkjml = (int)$sipt->main->get_uraian("SELECT COUNT(A.LHU_ID) AS JML FROM T_LHU A LEFT JOIN T_CP B ON A.CP_ID = B.CP_ID WHERE B.KODE_SAMPEL = '".$arrid[1]."' AND A.CREATE_BY = '".$this->newsession->userdata('SESS_USER_ID')."'","JML");	

			if($chkjml == 1)
			{#LHU Pangan Tipe A dan Komoditi selain Pangan Tipe B
			$nomor = $sipt->main->get_uraian("SELECT dbo.FORMAT_NOMOR('LHU',LHU_ID) AS KODE FROM T_LHU WHERE CP_ID = '".$arrid[0]."'","KODE");
			$html = "";
			$html .= '<div style="font-size:11pt; font-weight:bold; text-align:center; font-family:Times New Roman;">LAPORAN HASIL UJI</div>';
			$html .= '<div style="font-size:11pt; text-align:center; font-family:Times New Roman;">Nomor : '.$nomor.'</div>';
			
			$chk = $this->db->query("SELECT  UJI_KIMIA, UJI_MIKRO, STATUS_KIMIA, STATUS_MIKRO FROM T_M_SAMPEL WHERE KODE_SAMPEL = '".$arrid[1]."'")->result_array();
			
			if(in_array('B1',$this->newsession->userdata('SESS_SUB_SARANA')) || in_array('B2',$this->newsession->userdata('SESS_SUB_SARANA'))){
				if($chk[0]['UJI_KIMIA'] == 1 && $chk[0]['UJI_MIKRO'] == 1 && $chk[0]['STATUS_KIMIA'] == 1 && $chk[0]['STATUS_MIKRO'] == 1){
					$bidang = "";
				}else if($chk[0]['UJI_KIMIA'] == 1 && $chk[0]['UJI_MIKRO'] == 0 && $chk[0]['STATUS_KIMIA'] == 1 && $chk[0]['STATUS_MIKRO'] == 0){
					$bidang = " AND JENIS_UJI = '02'";
				}else if($chk[0]['UJI_KIMIA'] == 0 && $chk[0]['UJI_MIKRO'] == 1 && $chk[0]['STATUS_KIMIA'] == 0 && $chk[0]['STATUS_MIKRO'] == 1){
					$bidang = " AND JENIS_UJI = '01'";
				}else{
					$bidang = " AND JENIS_UJI = '02'";
				}
				$tanggaluji  = $this->db->query("SELECT KODE_SAMPEL, MIN(CONVERT(VARCHAR(10), AWAL_UJI, 120)) AS MINTGL, MAX(CONVERT(VARCHAR(10), AKHIR_UJI, 120)) AS MAXTGL FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL = '".$arrid[1]."' $bidang GROUP BY KODE_SAMPEL")->result_array();					
			}else if(in_array('B3',$this->newsession->userdata('SESS_SUB_SARANA'))){
				$tanggaluji  = $this->db->query("SELECT KODE_SAMPEL, MIN(CONVERT(VARCHAR(10), AWAL_UJI, 120)) AS MINTGL, MAX(CONVERT(VARCHAR(10), AKHIR_UJI, 120)) AS MAXTGL FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL = '".$arrid[1]."' AND JENIS_UJI = '01' GROUP BY KODE_SAMPEL")->result_array();	
			}else{
				$tanggaluji  = $this->db->query("SELECT KODE_SAMPEL, MIN(CONVERT(VARCHAR(10), AWAL_UJI, 120)) AS MINTGL, MAX(CONVERT(VARCHAR(10), AKHIR_UJI, 120)) AS MAXTGL FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL = '".$arrid[1]."' GROUP BY KODE_SAMPEL")->result_array();	
			}
			
			$rowcp = $this->db->query("SELECT dbo.URAIAN_M_TABEL('HASIL',HASIL) AS HASIL, CATATAN FROM T_CP WHERE CP_ID = '".$arrid[0]."'")->result_array();
			
			$html .= '<div style="height:5px;">&nbsp;</div>';
			$html .= '<table width="100%" border="0" cellpadding="4" cellspacing="4" class="tablepdf2">
					  <tr>
						<td class="tops" width="31%">Nama Sampel</td>
						<td class="tops" width="2%">&nbsp;</td>
						<td class="tops" width="64%">'.$arr_sampel[0]['NAMA_SAMPEL'].'</td>
					  </tr>
					  <tr>
						<td>No. Kode Sampel</td>
						<td>&nbsp;</td>
						<td>'.$arr_sampel[0]['KODE'].'</td>
					  </tr>
					  <tr>
						<td>Pengirim Sampel</td>
						<td>&nbsp;</td>
						<td>'.$arr_sampel[0]['NAMA_PENGIRIM'].'</td>
					  </tr>
					  <tr>
						<td>Tempat Sampling</td>
						<td>&nbsp;</td>
						<td>'.$arr_sampel[0]['TEMPAT_SAMPLING'].'</td>
					  </tr>
					  <tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>'.$arr_sampel[0]['ALAMAT_SAMPLING'].'</td>
					  </tr>
					  <tr>
						<td>Tanggal Sampling</td>
						<td>&nbsp;</td>
						<td>'.$arr_sampel[0]['TANGGAL_SAMPLING'].'</td>
					  </tr>
					  <tr>
						<td>Nomor Surat Permintaan Uji</td>
						<td>&nbsp;</td>
						<td>'.$arr_sampel[0]['SPU'].'</td>
					  </tr>
					  <tr>
						<td class="bottom">Tanggal Surat Permintaan Uji</td>
						<td class="bottom">&nbsp;</td>
						<td class="bottom">'.$arr_sampel[0]['TANGGAL_SPU'].'</td>
					  </tr>
					  </table>';
			$html .= '<div style="height:5px;">&nbsp;</div>';
			$html .= '<table width="100%" border="0" cellpadding="4" cellspacing="4" class="tablepdf2">
					  <tr>
						<td class="tops" width="31%">Nama Pabrik / Distributor / Importir </td>
						<td class="tops" width="2%">&nbsp;</td>
						<td class="tops" width="64%">'.$arr_sampel[0]['PABRIK'].' / ' .$arr_sampel[0]['IMPORTIR'].'</td>
					  </tr>
					  <tr>
						<td>No. Registrasi </td>
						<td>&nbsp;</td>
						<td>'.$arr_sampel[0]['NOMOR_REGISTRASI'].'</td>
					  </tr>
					  <tr>
						<td>No. Bets / Lot </td>
						<td>&nbsp;</td>
						<td>'.$arr_sampel[0]['NO_BETS'].'</td>
					  </tr>
					  <tr>
						<td>Tanggal Kadaluarsa  </td>
						<td>&nbsp;</td>
						<td>'.$arr_sampel[0]['KETERANGAN_ED'].'</td>
					  </tr>
					  <tr>
						<td>Kemasan</td>
						<td>&nbsp;</td>
						<td>'.$arr_sampel[0]['KEMASAN'].'</td>
					  </tr>
					  <tr>
						<td>Jumlah Sampel</td>
						<td>&nbsp;</td>
						<td>';
						if(in_array('7',$this->newsession->userdata('SESS_KODE_ROLE')) || in_array('8',$this->newsession->userdata('SESS_KODE_ROLE'))){
							$html .= $arr_sampel[0]['JUMLAH_SAMPEL'];
						}else{
							if(in_array('B1',$this->newsession->userdata('SESS_SUB_SARANA')) || in_array('B2',$this->newsession->userdata('SESS_SUB_SARANA'))){
								$html .= $arr_sampel[0]['JUMLAH_KIMIA'];
							}else if(in_array('B3',$this->newsession->userdata('SESS_SUB_SARANA'))){
								$html .= $arr_sampel[0]['JUMLAH_MIKRO'];
							}else{
								$html .= $arr_sampel[0]['JUMLAH_SAMPEL'];
							}
						}
			$html .= '&nbsp;'.$arr_sampel[0]['SATUAN'];
			$arrmin = explode("-",$tanggaluji[0]['MINTGL']);
			$arrmax = explode("-",$tanggaluji[0]['MAXTGL']);
			$html .= '</td>
					  </tr>
					  <tr>
						<td>Tanggal Mulai Pengujian</td>
						<td>&nbsp;</td>
						<td>'.$arrmin[2]."/".$arrmin[1]."/".$arrmin[0].'</td>
					  </tr>
					  <tr>
						<td class="bottom">Tanggal Selesai Pengujian</td>
						<td class="bottom">&nbsp;</td>
						<td class="bottom">'.$arrmax[2]."/".$arrmax[1]."/".$arrmax[0].'</td>
					  </tr>
					</table>';
			$html .= '<div style="height:5px;">&nbsp;</div>';
			$html .= '<table width="100%" border="0" cellpadding="4" cellspacing="4" class="tablepdf2">
					  <tr>
						<td width="31%">HASIL PENGUJIAN</td>
						<td width="2%">&nbsp;</td>
						<td width="64%"></td>
					  </tr>
					  <tr>
						<td width="31%">Pemerian</td>
						<td width="2%">&nbsp;</td>
						<td width="64%"></td>
					  </tr>
					  <tr>
						<td width="31%">'.$arr_sampel[0]['PEMERIAN'].'</td>
						<td width="2%">&nbsp;</td>
						<td width="64%">&nbsp;</td>
					  </tr>
					  </table>';
			if(in_array('B1',$this->newsession->userdata('SESS_SUB_SARANA')) || in_array('B2',$this->newsession->userdata('SESS_SUB_SARANA'))){#Bidang Kimia Fisika
				if($chk[0]['UJI_KIMIA'] == 1 && $chk[0]['UJI_MIKRO'] == 1 && $chk[0]['STATUS_KIMIA'] == 1 && $chk[0]['STATUS_MIKRO'] == 1){
					$bidang = "" ;
				}else if($chk[0]['UJI_KIMIA'] == 1 && $chk[0]['UJI_MIKRO'] == 0 && $chk[0]['STATUS_KIMIA'] == 1 && $chk[0]['STATUS_MIKRO'] == 0){
					$bidang = " AND JENIS_UJI = '02'";
				}else if($chk[0]['UJI_KIMIA'] == 0 && $chk[0]['UJI_MIKRO'] == 1 && $chk[0]['STATUS_KIMIA'] == 0 && $chk[0]['STATUS_MIKRO'] == 1){
					$bidang = " AND JENIS_UJI = '01'";
				}else{
					$bidang = " AND JENIS_UJI = '02'";
				}
				$parameter = $this->db->query("SELECT CASE WHEN JENIS_UJI = '01' THEN 'Mikrobiologi' WHEN JENIS_UJI = '02' THEN 'Kimia - Fisika' END AS JENIS_UJI, SPK_ID,PARAMETER_UJI, METODE, PUSTAKA, SYARAT, RUANG_LINGKUP, HASIL, REPLACE(REPLACE(HASIL_KUALITATIF,'<',' < '),'>',' > ') AS HASIL_KUALITATIF, LCP FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL = '".$arrid[1]."' $bidang")->result_array();
			}else if(in_array('B3',$this->newsession->userdata('SESS_SUB_SARANA'))){#Bidang Mikro
				$parameter =  $this->db->query("SELECT CASE WHEN JENIS_UJI = '01' THEN 'Mikrobiologi' WHEN JENIS_UJI = '02' THEN 'Kimia - Fisika' END AS JENIS_UJI, SPK_ID,PARAMETER_UJI, METODE, PUSTAKA, SYARAT, RUANG_LINGKUP, HASIL, REPLACE(REPLACE(HASIL_KUALITATIF,'<',' < '),'>',' > ') AS HASIL_KUALITATIF, LCP FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL = '".$arrid[1]."' AND JENIS_UJI = '01'")->result_array();
			}else{
				$parameter = $this->db->query("SELECT CASE WHEN JENIS_UJI = '01' THEN 'Mikrobiologi' WHEN JENIS_UJI = '02' THEN 'Kimia - Fisika' END AS JENIS_UJI, SPK_ID,PARAMETER_UJI, METODE, PUSTAKA, SYARAT, RUANG_LINGKUP, HASIL, REPLACE(REPLACE(HASIL_KUALITATIF,'<',' < '),'>',' > ') AS HASIL_KUALITATIF, LCP FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL = '".$arrid[1]."'")->result_array();
			}
			$html .= '<table width="100%" border="0" class="tablepdf2">
					  <tr><td class="left top bottom" width="25%">Uji yang dilakukan</td><td class="top bottom" width="10%">Hasil</td><td class="top bottom" width="15%">Syarat</td><td class="top bottom" width="15%">Metode</td><td class="top bottom rights" width="15%">Pustaka</td></tr>';
						$jparameter = count($parameter);
						if($jparameter > 0){
							for($x = 0; $x < $jparameter; $x++){
								$html .= '<tr><td class="left rights">'.$parameter[$x]['PARAMETER_UJI'].'</td><td class="left"><div>'.$parameter[$x]['HASIL'].'</div><div>'.$parameter[$x]['HASIL_KUALITATIF'].'</div></td><td class="left">'.$parameter[$x]['SYARAT'].'</td><td class="left">'.$parameter[$x]['METODE'].'</td><td class="left rights">'.$parameter[$x]['PUSTAKA'].'</td></tr>';
							}
						}
			$html .= '</table>';
			$html .= '<table width="100%" border="0" cellpadding="4" cellspacing="4" class="tablepdf2">
					  <tr>
						<td class="tops" width="31%"></td>
						<td class="tops" width="2%">&nbsp;</td>
						<td class="tops" width="64%"></td>
					  </tr>';
				if(in_array('B1',$this->newsession->userdata('SESS_SUB_SARANA')) || in_array('B2',$this->newsession->userdata('SESS_SUB_SARANA'))){#Bidang Kimia Fisika

					if($chk[0]['UJI_KIMIA'] == 1 && $chk[0]['UJI_MIKRO'] == 1 && $chk[0]['STATUS_KIMIA'] == 1 && $chk[0]['STATUS_MIKRO'] == 1){
						$html .= '<tr>
							<td class="tops" width="31%">Kesimpulan</td>
							<td class="tops" width="2%">&nbsp;</td>
							<td class="tops" width="64%">'.$arr_sampel[0]['HASIL_SAMPEL'].'</td>
						</tr>';
					}
					else{

				$arrkimia = array($arr_sampel['HASIL_KIMIA']);
				$hasilkimia = str_replace($arrurhasil, $arrhasil, $arrkimia);
			$html .= '<tr>
						<td class="tops" width="31%">Kesimpulan</td>
						<td class="tops" width="2%">&nbsp;</td>
						<td class="tops" width="64%">'.$arr_sampel[0]['HASIL_KIMIA'].'</td>
					  </tr>'; }
				}else if(in_array('B3',$this->newsession->userdata('SESS_SUB_SARANA'))){#Bidang Mikro
			$html .= '<tr>
						<td class="tops" width="31%">Kesimpulan</td>
						<td class="tops" width="2%">&nbsp;</td>
						<td class="tops" width="64%">'.$arr_sampel[0]['HASIL_MIKRO'].'</td>
					  </tr>';
			}else{
			$html .= '<tr>
						<td class="tops" width="31%">Kesimpulan Kimia</td>
						<td class="tops" width="2%">&nbsp;</td>
						<td class="tops" width="64%">'.$arr_sampel[0]['HASIL_KIMIA'].'</td>
					  </tr>';
			$html .= '<tr>
						<td class="tops" width="31%">Kesimpulan Mikro</td>
						<td class="tops" width="2%">&nbsp;</td>
						<td class="tops" width="64%">'.$arr_sampel[0]['HASIL_MIKRO'].'</td>
					  </tr>';
			$html .= '<tr>
						<td class="tops" width="31%">Kesimpulan</td>
						<td class="tops" width="2%">&nbsp;</td>
						<td class="tops" width="64%">'.$arr_sampel[0]['HASIL_SAMPEL'].'</td>
					  </tr>';

			}
			$html .= '</table>';		  
					  
			$footer = $this->db->query("SELECT CONVERT(VARCHAR(10), D.PEJABAT_TANGGAL, 103) AS TANGGAL, A.JABATAN AS JABATAN_MT, A.NAMA_USER AS NAMA_MT, A.USER_ID AS NIP_MT, B.JABATAN AS JABATAN_PENYELIA, B.NAMA_USER AS NAMA_PENYELIA, B.USER_ID AS NIP_PENYELIA, C.KOTA FROM T_CP D LEFT JOIN T_USER A ON D.MT = A.USER_ID LEFT JOIN T_USER B ON D.CREATE_BY =  B.USER_ID LEFT JOIN M_BBPOM C ON D.BBPOM_ID = C.BBPOM_ID WHERE D.CP_ID = '".$arrid[0]."'")->result_array();
			$html .= '<div style="height:5px;">&nbsp;</div>';
			$html .= '<table width="100%" border="0" cellpadding="4" cellspacing="4" class="tablepdf2">
					  <tr>
						<td width="50%" class="left tops">Menyetujui</td>
						<td width="50%" class="left rights tops">'.$footer[0]['KOTA'].', '.$footer[0]['TANGGAL'].'</td>
					  </tr>
					  <tr>
						<td class="left rights">'.$footer[0]['JABATAN_MT'].'</td>
						<td class="rights">'.$footer[0]['JABATAN_PENYELIA'].'</td>
					  </tr>
					  <tr>
						<td height="75" class="left right">&nbsp;</td>
						<td height="75" class="rights">&nbsp;</td>
					  </tr>
					  <tr>
						<td class="left right">'.$footer[0]['NAMA_MT'].'</td>
						<td class="rights">'.$footer[0]['NAMA_PENYELIA'].'</td>
					  </tr>
					  <tr>
						<td class="left bottom rights">'.$footer[0]['NIP_MT'].'</td>
						<td class="rights bottom">'.$footer[0]['NIP_PENYELIA'].'</td>
					  </tr>
					</table>';
			}
			else
			{#Lhu Pangan Tipe B jika kimia mikro
				#if($this->newsession->userdata('SESS_USER_ID') == "197411102000121001")
				#{

				#}
				#die();
				$rowlhu = $this->db->query("SELECT A.CP_ID, dbo.URAIAN_M_TABEL('HASIL',A.HASIL) AS HASIL, A.CREATE_BY, dbo.FORMAT_NOMOR('LHU',B.LHU_ID) AS NOMOR_LHU FROM T_M_SAMPEL Z LEFT JOIN T_CP A ON Z.KODE_SAMPEL = A.KODE_SAMPEL LEFT JOIN T_LHU B ON A.CP_ID = B.CP_ID WHERE Z.KODE_SAMPEL = '".$arrid[1]."'")->result_array(); 
				$tanggaluji = $this->db->query("SELECT MIN(CONVERT(VARCHAR(10), AWAL_UJI, 120)) AS MINTGL, MAX(CONVERT(VARCHAR(10), AKHIR_UJI, 120)) AS MAXTGL FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL = '".$arrid[1]."'")->result_array();
				
				$arr_tanggal  = $this->db->query("SELECT MIN(CONVERT(VARCHAR(10), AWAL_UJI, 120)) AS MINTGL, MAX(CONVERT(VARCHAR(10), AKHIR_UJI, 120)) AS MAXTGL FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL = '".$arrid[1]."'")->result_array();
				$jmllhu = count($rowlhu);
				if($jmllhu > 0){
					$html = "";
					$page = 1;
					for($z = 0; $z < $jmllhu; $z++){
						$arr_penyelia = $this->db->query("SELECT CONVERT(VARCHAR(10), A.CREATE_DATE, 103) AS TANGGAL_PENYELIA, A.CATATAN, B.NAMA_USER AS NAMA, B.USER_ID AS NIP, B.JABATAN, C.KOTA FROM T_CP A LEFT JOIN T_USER B ON A.CREATE_BY = B.USER_ID LEFT JOIN M_BBPOM C ON A.BBPOM_ID = C.BBPOM_ID WHERE A.KODE_SAMPEL = '".$arrid[1]."' AND A.CREATE_BY = '".$rowlhu[$z]['CREATE_BY']."'")->result_array();
						$parameter =  $this->db->query("SELECT CASE WHEN JENIS_UJI = '01' THEN 'Mikrobiologi' WHEN JENIS_UJI = '02' THEN 'Kimia - Fisika' END AS JENIS_UJI, SPK_ID,PARAMETER_UJI, METODE, PUSTAKA, SYARAT, RUANG_LINGKUP, HASIL, REPLACE(REPLACE(HASIL_KUALITATIF,'<',' < '),'>',' > ') AS HASIL_KUALITATIF, LCP FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL = '".$arrid[1]."' AND PENYELIA = '".$rowlhu[$z]['CREATE_BY']."'")->result_array();

						$arr_penguji = $this->db->query("SELECT A.NAMA_USER FROM T_USER A LEFT JOIN T_PARAMETER_HASIL_UJI B ON A.USER_ID = B.PENGUJI WHERE B.KODE_SAMPEL = '".$arrid[1]."' AND B.PENYELIA = '".$rowlhu[$z]['CREATE_BY']."'")->result_array();
						$html .= '<div style="font-size:11pt; font-weight:bold; text-align:center; font-family:Times New Roman;">LAPORAN HASIL UJI</div>';
						$html .= '<div style="font-size:11pt; text-align:center; font-family:Times New Roman;">Nomor : '.$rowlhu[$z]['NOMOR_LHU'].'</div>';
						$html .= '<div style="height:5px;">&nbsp;</div>';
						$html .= '<table width="100%" border="0" cellpadding="4" cellspacing="4" class="tablepdf2">
								  <tr>
									<td class="tops" width="31%">Nama Sampel</td>
									<td class="tops" width="2%">&nbsp;</td>
									<td class="tops" width="64%">'.$arr_sampel[0]['NAMA_SAMPEL'].'</td>
								  </tr>
								  <tr>
									<td>No. Kode Sampel</td>
									<td>&nbsp;</td>
									<td>'.$arr_sampel[0]['KODE'].'</td>
								  </tr>
								  <tr>
									<td>Pengirim Sampel</td>
									<td>&nbsp;</td>
									<td>'.$arr_sampel[0]['NAMA_PENGIRIM'].'</td>
								  </tr>
								  <tr>
									<td>Tempat Sampling</td>
									<td>&nbsp;</td>
									<td>'.$arr_sampel[0]['TEMPAT_SAMPLING'].'</td>
								  </tr>
								  <tr>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>'.$arr_sampel[0]['ALAMAT_SAMPLING'].'</td>
								  </tr>
								  <tr>
									<td>Tanggal Sampling</td>
									<td>&nbsp;</td>
									<td>'.$arr_sampel[0]['TANGGAL_SAMPLING'].'</td>
								  </tr>
								  <tr>
									<td>Nomor Surat Permintaan Uji</td>
									<td>&nbsp;</td>
									<td>'.$arr_sampel[0]['SPU'].'</td>
								  </tr>
								  <tr>
									<td class="bottom">Tanggal Surat Permintaan Uji</td>
									<td class="bottom">&nbsp;</td>
									<td class="bottom">'.$arr_sampel[0]['TANGGAL_SPU'].'</td>
								  </tr>
								  </table>';
						$html .= '<div style="height:5px;">&nbsp;</div>';
						$html .= '<table width="100%" border="0" cellpadding="4" cellspacing="4" class="tablepdf2">
								  <tr>
									<td class="tops" width="31%">Nama Pabrik / Distributor / Importir </td>
									<td class="tops" width="2%">&nbsp;</td>
									<td class="tops" width="64%">'.$arr_sampel[0]['PABRIK'].' / ' .$arr_sampel[0]['IMPORTIR'].'</td>
								  </tr>
								  <tr>
									<td>No. Registrasi </td>
									<td>&nbsp;</td>
									<td>'.$arr_sampel[0]['NOMOR_REGISTRASI'].'</td>
								  </tr>
								  <tr>
									<td>No. Bets / Lot </td>
									<td>&nbsp;</td>
									<td>'.$arr_sampel[0]['NO_BETS'].'</td>
								  </tr>
								  <tr>
									<td>Tanggal Kadaluarsa  </td>
									<td>&nbsp;</td>
									<td>'.$arr_sampel[0]['KETERANGAN_ED'].'</td>
								  </tr>
								  <tr>
									<td>Kemasan</td>
									<td>&nbsp;</td>
									<td>'.$arr_sampel[0]['KEMASAN'].'</td>
								  </tr>
								  <tr>
									<td>Jumlah Sampel</td>
									<td>&nbsp;</td>
									<td>';
										if($rowlhu[$z]['UJI'] == "K")
											$html .= $arr_sampel[0]['JUMLAH_KIMIA'];
										else 
											$html .= $arr_sampel[0]['JUMLAH_MIKRO'];
						$html .= '&nbsp;'.$arr_sampel[0]['SATUAN'];
						$arrtglmin = explode("-",$tanggaluji[0]['MINTGL']);
						$arrtglmax = explode("-",$tanggaluji[0]['MAXTGL']);
						$html .= '</td>
								  </tr>
								  <tr>
									<td>Tanggal Mulai Pengujian</td>
									<td>&nbsp;</td>
									<td>'.$arrtglmin[2].'/'.$arrtglmin[1].'/'.$arrtglmin[0].'</td>
								  </tr>
								  <tr>
									<td class="bottom">Tanggal Selesai Pengujian</td>
									<td class="bottom">&nbsp;</td>
									<td class="bottom">'.$arrtglmax[2].'/'.$arrtglmax[1].'/'.$arrtglmax[0].'</td>
								  </tr>
								</table>';
						$html .= '<div style="height:5px;">&nbsp;</div>';
						$html .= '<table width="100%" border="0" cellpadding="4" cellspacing="4" class="tablepdf2">
								  <tr>
									<td width="31%">HASIL PENGUJIAN</td>
									<td width="2%">&nbsp;</td>
									<td width="64%"></td>
								  </tr>
								  <tr>
									<td width="31%">Pemerian</td>
									<td width="2%">&nbsp;</td>
									<td width="64%"></td>
								  </tr>
								  <tr>
									<td width="31%">'.$arr_sampel[0]['PEMERIAN'].'</td>
									<td width="2%">&nbsp;</td>
									<td width="64%">&nbsp;</td>
								  </tr>
								  </table>';
						$html .= '<table width="100%" border="0" class="tablepdf2">
								  <tr><td class="left top bottom" width="25%">Uji yang dilakukan</td><td class="top bottom" width="10%">Hasil</td><td class="top bottom" width="15%">Syarat</td><td class="top bottom" width="15%">Metode</td><td class="top bottom rights" width="15%">Pustaka</td></tr>';
									$jparameter = count($parameter);
									if($jparameter > 0){
										for($x = 0; $x < $jparameter; $x++){
											$html .= '<tr><td class="left rights">'.$parameter[$x]['PARAMETER_UJI'].'</td><td class="left"><div>'.$parameter[$x]['HASIL'].'</div><div>'.$parameter[$x]['HASIL_KUALITATIF'].'</div></td><td class="left">'.$parameter[$x]['SYARAT'].'</td><td class="left">'.$parameter[$x]['METODE'].'</td><td class="left rights">'.$parameter[$x]['PUSTAKA'].'</td></tr>';
										}
									}
						$html .= '</table>';
						$html .= '<table width="100%" border="0" cellpadding="4" cellspacing="4" class="tablepdf2">
								  <tr>
									<td class="tops" width="31%"></td>
									<td class="tops" width="2%">&nbsp;</td>
									<td class="tops" width="64%"></td>
								  </tr>';
						if($rowlhu[$z]['UJI'] == "K"){
						$html .= '<tr>
									<td class="tops" width="31%">Kesimpulan</td>
									<td class="tops" width="2%">&nbsp;</td>
									<td class="tops" width="64%">'.$rowlhu[$z]['HASIL'].'</td>
								  </tr>';
						}else{
						$html .= '<tr>
									<td class="tops" width="31%">Kesimpulan</td>
									<td class="tops" width="2%">&nbsp;</td>
									<td class="tops" width="64%">'.$rowlhu[$z]['HASIL'].'</td>
								  </tr>';
						}
						$html .= '</table>';
						
						$footer = $this->db->query("SELECT CONVERT(VARCHAR(10), D.PEJABAT_TANGGAL, 103) AS TANGGAL, A.JABATAN AS JABATAN_MT, A.NAMA_USER AS NAMA_MT, A.USER_ID AS NIP_MT, B.JABATAN AS JABATAN_PENYELIA, B.NAMA_USER AS NAMA_PENYELIA, B.USER_ID AS NIP_PENYELIA, C.KOTA FROM T_CP D LEFT JOIN T_USER A ON D.MT = A.USER_ID LEFT JOIN T_USER B ON D.CREATE_BY =  B.USER_ID LEFT JOIN M_BBPOM C ON D.BBPOM_ID = C.BBPOM_ID WHERE D.CP_ID = '".$rowlhu[$z]['CP_ID']."'")->result_array();
						$html .= '<div style="height:5px;">&nbsp;</div>';
						$html .= '<table width="100%" border="0" cellpadding="4" cellspacing="4" class="tablepdf2">
								  <tr>
									<td width="50%" class="left tops">Menyetujui</td>
									<td width="50%" class="left rights tops">'.$footer[0]['KOTA'].', '.$footer[0]['TANGGAL'].'</td>
								  </tr>
								  <tr>
									<td class="left rights">'.$footer[0]['JABATAN_MT'].'</td>
									<td class="rights">'.$footer[0]['JABATAN_PENYELIA'].'</td>
								  </tr>
								  <tr>
									<td height="75" class="left right">&nbsp;</td>
									<td height="75" class="rights">&nbsp;</td>
								  </tr>
								  <tr>
									<td class="left right">'.$footer[0]['NAMA_MT'].'</td>
									<td class="rights">'.$footer[0]['NAMA_PENYELIA'].'</td>
								  </tr>
								  <tr>
									<td class="left bottom rights">'.$footer[0]['NIP_MT'].'</td>
									<td class="rights bottom">'.$footer[0]['NIP_PENYELIA'].'</td>
								  </tr>
								</table>';
						$page++;
						if($page <= $jmllhu){
							$html .= '<pagebreak sheet-size="210mm 330mm" />';
						}	
					}	
				}

			}

			
			$mpdf=new mPDF('utf-8', array(210,330),10,10,10,10,10,10);
			$stylesheet = file_get_contents('css/mpdf.css');
			$mpdf->mirrorMargins = 1;
			$mpdf->WriteHTML($stylesheet,1);
			$mpdf->WriteHTML($html);
			$mpdf->Output();
			exit;
		}
	}
	
	function konsep($id){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$this->load->library('mpdf');
			$arrid = explode(".",$id);
			//$nomor = $sipt->main->get_uraian("SELECT dbo.FORMAT_NOMOR('LHU',LHU_ID) AS KODE FROM T_LHU WHERE CP_ID = '".$arrid[0]."'","KODE");
			//$nomor = "";
			$html = "";
			$html .= '<div style="font-size:11pt; font-weight:bold; text-align:center; font-family:Times New Roman;">LAPORAN PENGUJIAN</div>';
			//$html .= '<div style="font-size:11pt; text-align:center; font-family:Times New Roman;">Nomor : '.$nomor.'</div>';
			$arr_sampel = $this->db->query("SELECT A.NAMA_SAMPEL, A.KODE_SAMPEL, dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) AS KODE, dbo.FORMAT_NOMOR('SPU',C.SPU_ID) AS SPU, A.TEMPAT_SAMPLING, CONVERT(VARCHAR(10), A.TANGGAL_SAMPLING, 103) AS TANGGAL_SAMPLING, A.ALAMAT_SAMPLING, A.NOMOR_REGISTRASI, A.PABRIK, A.IMPORTIR, A.KEMASAN, A.BENTUK_SEDIAAN, A.NO_BETS, A.SATUAN, dbo.KATEGORI(A.KOMODITI,A.PRIORITAS) AS KOMODITI, dbo.KATEGORI(A.KATEGORI,A.PRIORITAS) AS KATEGORI, A.KETERANGAN_ED, A.JUMLAH_SAMPEL, A.JUMLAH_KIMIA, A.JUMLAH_MIKRO, REPLACE(A.KOMPOSISI,';','<br>') AS KOMPOSISI, A.NETTO, A.PEMERIAN, B.NOMOR_SURAT, CONVERT(VARCHAR(10), B.TANGGAL_SURAT, 103) AS TANGGAL_SURAT, B.NAMA_PENGIRIM, CONVERT(VARCHAR(10), C.TANGGAL_TERIMA_TPS, 103) AS TANGGAL_TERIMA_TPS, CONVERT(VARCHAR(10), C.TANGGAL, 103) AS TANGGAL_SPU, A.JUMLAH_KIMIA, A.UJI_KIMIA, A.UJI_MIKRO, A.JUMLAH_MIKRO, A.HASIL_KIMIA, A.HASIL_MIKRO, A.HASIL_SAMPEL, CONVERT(VARCHAR(10), A.UPDATE_DATE, 103) AS UPDATE_DATE, D.USER_ID AS NIP, D.NAMA_USER, D.JABATAN, E.NAMA_BBPOM, E.KOTA, A.CATATAN_CP FROM T_M_SAMPEL A LEFT JOIN T_PERIKSA_SAMPEL B ON A.PERIKSA_SAMPEL = B.PERIKSA_SAMPEL LEFT JOIN T_SPU C ON A.SPU_ID = C.SPU_ID LEFT JOIN T_USER D ON A.UPDATE_BY = D.USER_ID LEFT JOIN M_BBPOM E ON E.KODE_BALAI = (
CASE WHEN LEFT(SUBSTRING(A.KODE_SAMPEL,3,3),1) = '0' THEN SUBSTRING(A.KODE_SAMPEL,4,2)
ELSE SUBSTRING(A.KODE_SAMPEL,3,3) END) WHERE A.KODE_SAMPEL = '".$arrid[0]."'")->result_array();
			$tanggaluji = $this->db->query("SELECT MIN(CONVERT(VARCHAR(10), AWAL_UJI, 120)) AS MINTGL, MAX(CONVERT(VARCHAR(10), AKHIR_UJI, 120)) AS MAXTGL FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL = '".$arrid[0]."'")->result_array();
			$html .= '<div style="height:5px;">&nbsp;</div>';
			$html .= '<table width="100%" border="0" cellpadding="4" cellspacing="4" class="tablepdf2">
					  <tr>
						<td class="tops" width="31%">Nama Sampel</td>
						<td class="tops" width="2%">&nbsp;</td>
						<td class="tops" width="64%">'.$arr_sampel[0]['NAMA_SAMPEL'].'</td>
					  </tr>
					  <tr>
						<td>No. Kode Sampel</td>
						<td>&nbsp;</td>
						<td>'.$arr_sampel[0]['KODE'].'</td>
					  </tr>
					  <tr>
						<td>Pengirim Sampel</td>
						<td>&nbsp;</td>
						<td>'.$arr_sampel[0]['NAMA_PENGIRIM'].'</td>
					  </tr>
					  <tr>
						<td>Tempat Sampling</td>
						<td>&nbsp;</td>
						<td>'.$arr_sampel[0]['TEMPAT_SAMPLING'].'</td>
					  </tr>
					  <tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>'.$arr_sampel[0]['ALAMAT_SAMPLING'].'</td>
					  </tr>
					  <tr>
						<td>Tanggal Sampling</td>
						<td>&nbsp;</td>
						<td>'.$arr_sampel[0]['TANGGAL_SAMPLING'].'</td>
					  </tr>
					  <tr>
						<td>Nomor Surat Permintaan Uji</td>
						<td>&nbsp;</td>
						<td>'.$arr_sampel[0]['SPU'].'</td>
					  </tr>
					  <tr>
						<td class="bottom">Tanggal Surat Permintaan Uji</td>
						<td class="bottom">&nbsp;</td>
						<td class="bottom">'.$arr_sampel[0]['TANGGAL_SPU'].'</td>
					  </tr>
					  </table>';
			$html .= '<div style="height:5px;">&nbsp;</div>';
			$html .= '<table width="100%" border="0" cellpadding="4" cellspacing="4" class="tablepdf2">
					  <tr>
						<td class="tops" width="31%">Nama Pabrik / Distributor / Importir </td>
						<td class="tops" width="2%">&nbsp;</td>
						<td class="tops" width="64%">'.$arr_sampel[0]['PABRIK'].' / ' .$arr_sampel[0]['IMPORTIR'].'</td>
					  </tr>
					  <tr>
						<td>No. Registrasi </td>
						<td>&nbsp;</td>
						<td>'.$arr_sampel[0]['NOMOR_REGISTRASI'].'</td>
					  </tr>
					  <tr>
						<td>No. Bets / Lot </td>
						<td>&nbsp;</td>
						<td>'.$arr_sampel[0]['NO_BETS'].'</td>
					  </tr>
					  <tr>
						<td>Tanggal Kadaluarsa  </td>
						<td>&nbsp;</td>
						<td>'.$arr_sampel[0]['KETERANGAN_ED'].'</td>
					  </tr>
					  <tr>
						<td>Kemasan</td>
						<td>&nbsp;</td>
						<td>'.$arr_sampel[0]['KEMASAN'].'</td>
					  </tr>
					  <tr>
						<td>Jumlah Sampel</td>
						<td>&nbsp;</td>
						<td>';
						if(in_array('7',$this->newsession->userdata('SESS_KODE_ROLE')) || in_array('8',$this->newsession->userdata('SESS_KODE_ROLE'))){
							$html .= $arr_sampel[0]['JUMLAH_SAMPEL'];
						}else{
							if(in_array('B1',$this->newsession->userdata('SESS_SUB_SARANA')) || in_array('B2',$this->newsession->userdata('SESS_SUB_SARANA'))){
								$html .= $arr_sampel[0]['JUMLAH_KIMIA'];
							}else if(in_array('B3',$this->newsession->userdata('SESS_SUB_SARANA'))){
								$html .= $arr_sampel[0]['JUMLAH_MIKRO'];
							}else{
								$html .= $arr_sampel[0]['JUMLAH_SAMPEL'];
							}
						}
			$html .= '&nbsp;'.$arr_sampel[0]['SATUAN'];
			$arrmin = explode("-",$tanggaluji[0]['MINTGL']);
			$arrmax = explode("-",$tanggaluji[0]['MAXTGL']);
			$html .= '</td>
					  </tr>
					  <tr>
						<td>Tanggal Mulai Pengujian</td>
						<td>&nbsp;</td>
						<td>'.$arrmin[2]."/".$arrmin[1]."/".$arrmin[0].'</td>
					  </tr>
					  <tr>
						<td class="bottom">Tanggal Selesai Pengujian</td>
						<td class="bottom">&nbsp;</td>
						<td class="bottom">'.$arrmax[2]."/".$arrmax[1]."/".$arrmax[0].'</td>
					  </tr>
					</table>';
			$html .= '<div style="height:5px;">&nbsp;</div>';
			$html .= '<table width="100%" border="0" cellpadding="4" cellspacing="4" class="tablepdf2">
					  <tr>
						<td width="31%">HASIL PENGUJIAN</td>
						<td width="2%">&nbsp;</td>
						<td width="64%"></td>
					  </tr>
					  <tr>
						<td width="31%">Pemerian</td>
						<td width="2%">&nbsp;</td>
						<td width="64%"></td>
					  </tr>
					  <tr>
						<td width="31%">'.$arr_sampel[0]['PEMERIAN'].'</td>
						<td width="2%">&nbsp;</td>
						<td width="64%">&nbsp;</td>
					  </tr>
					  </table>';
					  $parameter = $this->db->query("SELECT CASE WHEN JENIS_UJI = '01' THEN 'Mikrobiologi' WHEN JENIS_UJI = '02' THEN 'Kimia - Fisika' END AS JENIS_UJI, SPK_ID,PARAMETER_UJI, METODE, PUSTAKA, SYARAT, RUANG_LINGKUP, HASIL, REPLACE(REPLACE(HASIL_KUALITATIF,'<',' < '),'>',' > ') AS HASIL_KUALITATIF, HASIL_PARAMETER, LCP FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL = '".$arrid[0]."'")->result_array();
			
			$html .= '<table width="100%" border="0" class="tablepdf2">
					  <tr><td class="left top bottom" width="25%">Uji yang dilakukan</td><td class="top bottom" width="10%">Hasil</td><td class="top bottom" width="15%">Syarat</td><td class="top bottom" width="15%">Metode</td><td class="top bottom rights" width="15%">Pustaka</td></tr>';
						$jparameter = count($parameter);
						if($jparameter > 0){
							for($x = 0; $x < $jparameter; $x++){
								$html .= '<tr><td class="left rights">'.$parameter[$x]['PARAMETER_UJI'].'</td><td class="left"><div>'.$parameter[$x]['HASIL'].'</div><div>'.$parameter[$x]['HASIL_KUALITATIF'].'</div></td><td class="left">'.$parameter[$x]['SYARAT'].'</td><td class="left">'.$parameter[$x]['METODE'].'</td><td class="left rights">'.$parameter[$x]['PUSTAKA'].'</td></tr>';
							}
						}
			$html .= '</table>';

			$html .= '<table width="100%" border="0" cellpadding="4" cellspacing="4" class="tablepdf2">
					  <tr>
						<td class="tops" width="31%"></td>
						<td class="tops" width="2%">&nbsp;</td>
						<td class="tops" width="64%"></td>
					  </tr>';
			$html .= '<tr>
						<td class="bottom" width="31%">Kesimpulan</td>
						<td class="bottom" width="2%">&nbsp;</td>
						<td class="bottom" width="64%">'.$arr_sampel[0]['HASIL_SAMPEL'].'</td>
					  </tr>
					  </table>';
			$bulan = $this->config->config;
			$bulan = $bulan['bulan'];		
			$tgl = explode('/', $arr_sampel[0]['UPDATE_DATE']);
			$tgla = (int)$tgl[1];
			$tgla = $bulan[$tgla];
			$html .= '<div style="height:5px;">&nbsp;</div>';
			$html .= '<table width="100%" border="0" cellpadding="4" cellspacing="4" class="tablepdf2">
					  <tr>
						<td width="50%">Laporan Pengujian ini hanya</td>
						<td width="50%">Dikeluarkan di : '.$arr_sampel[0]['KOTA'].'</td>
					  </tr>
					  <tr>
						<td>Berlaku untuk sampel yang diuji</td>
						<td>Pada tanggal : '.$tgl[0].' '.$tgla.' '.$tgl[2].'</td>
					  </tr>
					  <tr>
						<td>&nbsp;</td>
						<td>a.n. Kepala '.ucwords($arr_sampel[0]['NAMA_BBPOM']).'</td>
					  </tr>
					  <tr>
						<td>&nbsp;</td>
						<td e>'.$arr_sampel[0]['JABATAN'].'</td>
					  </tr>

					  <tr>
						<td height="75">&nbsp;</td>
						<td height="75">&nbsp;</td>
					  </tr>
					  <tr>
						<td>&nbsp;</td>
						<td>'.$arr_sampel[0]['NAMA_USER'].'</td>
					  </tr>
					  <tr>
						<td>&nbsp;</td>
						<td>'.$arr_sampel[0]['NIP'].'</td>
					  </tr>
					</table>';
			$mpdf=new mPDF('utf-8', array(210,330),10,10,10,10,10,10);
			$stylesheet = file_get_contents('css/mpdf.css');
			$mpdf->mirrorMargins = 1;
			$mpdf->WriteHTML($stylesheet,1);
			$mpdf->WriteHTML($html);
			$mpdf->Output();
			exit;
		}
	}
		
}
?>