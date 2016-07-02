<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cp extends Controller{
	
	function Cp(){
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
			$arr_sampel = $this->db->query("SELECT A.NAMA_SAMPEL, A.KODE_SAMPEL, dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) AS KODE, A.TEMPAT_SAMPLING, CONVERT(VARCHAR(10), A.TANGGAL_SAMPLING, 103) AS TANGGAL_SAMPLING, A.ALAMAT_SAMPLING, A.NOMOR_REGISTRASI, A.PABRIK, A.IMPORTIR, A.KEMASAN, A.BENTUK_SEDIAAN, A.NO_BETS, dbo.KATEGORI(A.KOMODITI,A.PRIORITAS) AS KOMODITI, dbo.KATEGORI(A.KATEGORI,A.PRIORITAS) AS KATEGORIX, A.NAMA_KATEGORI AS KATEGORI, A.SATUAN, A.KETERANGAN_ED, A.JUMLAH_KIMIA, A.JUMLAH_MIKRO, A.SISA_MIKRO, A.SISA_KIMIA, A.TEMPAT_SISA_MIKRO, A.TEMPAT_SISA_KIMIA, A.HASIL_MIKRO, A.HASIL_KIMIA, REPLACE(A.KOMPOSISI,';',';') AS KOMPOSISI, A.NETTO, A.PEMERIAN, B.NOMOR_SURAT, CONVERT(VARCHAR(10), B.TANGGAL_SURAT, 103) AS TANGGAL_SURAT, B.NAMA_PENGIRIM, CONVERT(VARCHAR(10), C.TANGGAL_TERIMA_TPS, 103) AS TANGGAL_TERIMA_TPS, A.LABEL, A.SEGEL FROM T_M_SAMPEL A LEFT JOIN T_PERIKSA_SAMPEL B ON A.PERIKSA_SAMPEL = B.PERIKSA_SAMPEL LEFT JOIN T_SPU C ON A.SPU_ID = C.SPU_ID WHERE A.KODE_SAMPEL = '".$id."'")->result_array();
			if(in_array('B1',$this->newsession->userdata('SESS_SUB_SARANA')) || in_array('B2',$this->newsession->userdata('SESS_SUB_SARANA'))){
				$arr_tanggal  = $this->db->query("SELECT KODE_SAMPEL, MIN(CONVERT(VARCHAR(10), AWAL_UJI, 120)) AS MINTGL, MAX(CONVERT(VARCHAR(10), AKHIR_UJI, 120)) AS MAXTGL FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL = '".$id."' AND JENIS_UJI = '02' GROUP BY KODE_SAMPEL")->result_array();					
			}else if(in_array('B3',$this->newsession->userdata('SESS_SUB_SARANA'))){
				$arr_tanggal  = $this->db->query("SELECT KODE_SAMPEL, MIN(CONVERT(VARCHAR(10), AWAL_UJI, 120)) AS MINTGL, MAX(CONVERT(VARCHAR(10), AKHIR_UJI, 120)) AS MAXTGL FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL = '".$id."' AND JENIS_UJI = '01' GROUP BY KODE_SAMPEL")->result_array();	
			}else{
				$arr_tanggal  = $this->db->query("SELECT KODE_SAMPEL, MIN(CONVERT(VARCHAR(10), AWAL_UJI, 120)) AS MINTGL, MAX(CONVERT(VARCHAR(10), AKHIR_UJI, 120)) AS MAXTGL FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL = '".$id."' GROUP BY KODE_SAMPEL")->result_array();	
			}
			$arr_penguji = $this->db->query("SELECT A.NAMA_USER FROM T_USER A LEFT JOIN T_PARAMETER_HASIL_UJI B ON A.USER_ID = B.PENGUJI WHERE B.KODE_SAMPEL = '".$id."' AND B.PENYELIA = '".$this->newsession->userdata('SESS_USER_ID')."'")->result_array();
			$arr_penyelia = $this->db->query("SELECT CONVERT(VARCHAR(10), A.CREATE_DATE, 103) AS TANGGAL_PENYELIA, A.CATATAN, B.NAMA_USER AS NAMA, B.USER_ID AS NIP, B.JABATAN, C.KOTA FROM T_CP A LEFT JOIN T_USER B ON A.CREATE_BY = B.USER_ID LEFT JOIN M_BBPOM C ON A.BBPOM_ID = C.BBPOM_ID WHERE A.KODE_SAMPEL = '".$id."' AND A.CREATE_BY = '".$this->newsession->userdata('SESS_USER_ID')."'")->result_array();
			$html = "";
			$html .= '<div style="font-size:11pt; font-weight:bold; text-align:center; font-family:Times New Roman;">CATATAN PENGUJIAN</div>';
			$html .= '<div style="height:5px;">&nbsp;</div>';
			$html .= '<table width="100%" border="0" cellpadding="4" cellspacing="4" class="tablepdf2">
					  <tr>
						<td class="alt2 left top" width="3%">1.</td>
						<td class="alt2 left top" width="30%">Nama Sampel </td>
						<td class="alt2 left top" width="3%">2.</td>
						<td class="alt2 left top" width="30%">Kode Sampel </td>
						<td class="alt2 left top" width="3%">3.</td>
						<td class="alt2 right top" width="30%">Segel</td>
					  </tr>
					  <tr>
						<td class="alt2 left">&nbsp;</td>
						<td class="alt2 left">'.$arr_sampel[0]['NAMA_SAMPEL'].'</td>
						<td class="alt2 left">&nbsp;</td>
						<td class="alt2 left">'.$arr_sampel[0]['KODE'].'</td>
						<td class="alt2 left">&nbsp;</td>
						<td class="alt2 rights">'.$arr_sampel[0]['SEGEL'].'</td>
					  </tr>
					</table>
					
					<table width="100%" border="0" cellpadding="4" cellspacing="4" class="tablepdf2">
					  <tr>
						<td class="alt2 left" width="3%">4.</td>
						<td class="alt2 left" width="47%">Tanggal Terima Penguji </td>
						<td class="alt2 left" width="2%">5.</td>
						<td class="alt2 rights" width="47%">Laboratorium</td>
					  </tr>';
			$arrmin = explode("-",$arr_tanggal[0]['MINTGL']);		  
			$html .= '<tr>
						<td class="alt2 left">&nbsp;</td>
						<td class="alt2 left">'.$arrmin[2].'/'.$arrmin[1].'/'.$arrmin[0].'</td>
						<td class="alt2 left">&nbsp;</td>
						<td class="alt2 rights">';
						if(in_array('B3',$this->newsession->userdata('SESS_SUB_SARANA'))){
							$html .= 'Mikrobiologi';
						}else{
							$html .= 'Kimia - Fisika';
						}
			$html .= '</td>
					  </tr>
					</table>
					
					<table width="100%" border="0" cellpadding="4" cellspacing="4" class="tablepdf2">
					  <tr>
						<td width="3%" class="left">6.</td>
						<td width="31%">Informasi Sampel </td>
						<td width="2%">&nbsp;</td>
						<td width="64%" class="rights">&nbsp;</td>
					  </tr>
					  <tr>
						<td  class="left">&nbsp;</td>
						<td>Kemasan</td>
						<td>&nbsp;</td>
						<td class="rights">'.$arr_sampel[0]['KEMASAN'].'</td>
					  </tr>
					  <tr>
						<td class="left">&nbsp;</td>
						<td>Komposisi</td>
						<td>&nbsp;</td>
						<td class="rights">'.str_replace(">", " > ", str_replace("<"," < ", $arr_sampel[0]['KOMPOSISI'])).'</td>
					  </tr>
					  <tr>
						<td class="left">&nbsp;</td>
						<td>Nama Pabrik / Distributor / Importir </td>
						<td>&nbsp;</td>
						<td class="rights">'.$arr_sampel[0]['PABRIK'].' / ' .$arr_sampel[0]['IMPORTIR'].'</td>
					  </tr>
					  <tr>
						<td class="left">&nbsp;</td>
						<td>No. Bets / Lot </td>
						<td>&nbsp;</td>
						<td class="rights">'.$arr_sampel[0]['NO_BETS'].'</td>
					  </tr>
					  <tr>
						<td class="left">&nbsp;</td>
						<td>No. Registrasi </td>
						<td>&nbsp;</td>
						<td class="rights">'.$arr_sampel[0]['NOMOR_REGISTRASI'].'</td>
					  </tr>
					  <tr>
						<td class="bottom left">&nbsp;</td>
						<td class="bottom">Tanggal Kadaluarsa  </td>
						<td class="bottom">&nbsp;</td>
						<td class="bottom rights">'.$arr_sampel[0]['KETERANGAN_ED'].'</td>
					  </tr>
					</table>
					
					<table width="100%" border="0" cellpadding="4" cellspacing="4" class="tablepdf2">
					  <tr>
						<td width="3%" class="left">7.</td>
						<td width="47%" class="rights">Jumlah sampel yang diterima </td>
						<td width="2%">8.</td>
						<td width="47%" class="rights">Label Sampel </td>
					  </tr>
					  <tr>
						<td class="left bottom">&nbsp;</td>
						<td class="rights bottom">';
						if(in_array('B3',$this->newsession->userdata('SESS_SUB_SARANA'))){
							$html .= $arr_sampel[0]['JUMLAH_MIKRO'] . ' ' . $arr_sampel[0]['SATUAN'];
						}else{
							$html .= $arr_sampel[0]['JUMLAH_KIMIA'] . ' ' . $arr_sampel[0]['SATUAN'];
						}
			$html .= '</td>
						<td class="bottom">&nbsp;</td>
						<td class="rights bottom">'.$arr_sampel[0]['LABEL'].'</td>
					  </tr>
					</table>
					
					<table width="100%" border="0" cellpadding="4" cellspacing="4" class="tablepdf2">
					  <tr>
						<td width="3%" class="left">9.</td>
						<td width="47%">Hasil Pengujian </td>
						<td width="2%">&nbsp;</td>
						<td width="47%" class="rights">&nbsp;</td>
					  </tr>
					  <tr>
						<td width="3%" class="left">&nbsp;</td>
						<td width="47%">Pemerian</td>
						<td width="2%">&nbsp;</td>
						<td width="47%" class="rights">&nbsp;</td>
					  </tr>
					  <tr>
						<td width="3%" class="left">&nbsp;</td>
						<td width="47%">'.$arr_sampel[0]['PEMERIAN'].'</td>
						<td width="2%">&nbsp;</td>
						<td width="47%" class="rights">&nbsp;</td>
					  </tr>
					  </table>';
			if(in_array('B1',$this->newsession->userdata('SESS_SUB_SARANA')) || in_array('B2',$this->newsession->userdata('SESS_SUB_SARANA'))){#Bidang Kimia Fisika
				$parameter = $this->db->query("SELECT SPK_ID, PARAMETER_UJI, METODE, PUSTAKA, SYARAT, RUANG_LINGKUP, HASIL, REPLACE(REPLACE(HASIL_KUALITATIF,'<',' < '),'>',' > ') AS HASIL_KUALITATIF, LCP FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL = '".$id."' AND JENIS_UJI = '02'")->result_array();
			}else if(in_array('B3',$this->newsession->userdata('SESS_SUB_SARANA'))){#Bidang Mikro
				$parameter =  $this->db->query("SELECT SPK_ID, PARAMETER_UJI, METODE, PUSTAKA, SYARAT, RUANG_LINGKUP, HASIL, REPLACE(REPLACE(HASIL_KUALITATIF,'<',' < '),'>',' > ') AS HASIL_KUALITATIF, LCP FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL = '".$id."' AND JENIS_UJI = '01'")->result_array();
			}
			
			$html .= '<table width="100%" border="0" class="tablepdf2">
					  <tr><td class="left top bottom" width="25%">Uji yang dilakukan</td><td class="top bottom" width="10%">Hasil</td><td class="top bottom" width="15%">Syarat</td><td class="top bottom" width="15%">Metode</td><td class="top bottom top" width="15%">Pustaka</td></tr>';
						$jparameter = count($parameter);
						if($jparameter > 0){
							for($x = 0; $x < $jparameter; $x++){
								$html .= '<tr><td class="left rights">'.$parameter[$x]['PARAMETER_UJI'].'</td><td class="left"><div>'.str_replace(">", " > ", str_replace("<"," < ", $parameter[$x]['HASIL'])).'</div><div>'.str_replace(">", " > ", str_replace("<"," < ", $parameter[$x]['HASIL_KUALITATIF'])).'</div></td><td class="left">'.str_replace(">", " > ", str_replace("<"," < ", $parameter[$x]['SYARAT'])).'</td><td class="left">'.$parameter[$x]['METODE'].'</td><td class="left rights">'.$parameter[$x]['PUSTAKA'].'</td></tr>';
							}
						}
			$html .= '</table>';
						
					
			$html .= '<table width="100%" border="0" cellpadding="4" cellspacing="4" class="tablepdf2">
					  <tr>
						<td width="3%" class="left bottom tops">10.</td>
						<td width="31%" class="bottom tops">Kesimpulan</td>
						<td width="2%" class="bottom tops">&nbsp;</td>
						<td width="64%" class="bottom rights tops">';
						if(in_array('B3',$this->newsession->userdata('SESS_SUB_SARANA'))){
							$html .= $arr_sampel[0]['HASIL_MIKRO'];
						}else{
							$html .= $arr_sampel[0]['HASIL_KIMIA'];
						}
			$html .= '</td>
					  </tr>
					  <tr>
						<td class="left bottom">11.</td>
						<td class="bottom">Catatan</td>
						<td class="bottom">&nbsp;</td>
						<td class="bottom rights">'.$arr_penyelia[0]['CATATAN'].'</td>
					  </tr>
					  <tr>
						<td class="bottom left">12.</td>
						<td class="bottom">Sisa Sampel </td>
						<td class="bottom">&nbsp;</td>
						<td class="bottom rights">';
						if(in_array('B3',$this->newsession->userdata('SESS_SUB_SARANA'))){
							if($arr_sampel[0]['SISA_MIKRO'] > 0){
								$html .= 'Disimpan di ' . $arr_sampel[0]['TEMPAT_SISA_MIKRO'];
							}else{
								$html .= 'Habis';
							}
						}else{
							if($arr_sampel[0]['SISA_KIMIA'] > 0){
								$html .= 'Disimpan di ' . $arr_sampel[0]['TEMPAT_SISA_KIMIA'];
							}else{
								$html .= 'Habis';
							}
						}
			$html .= '</td>
					  </tr>
					</table>';
			$arrmax = explode("-",$arr_tanggal[0]['MAXTGL']);		
			$html .= '<table width="100%" border="0" cellpadding="4" cellspacing="4" class="tablepdf2">
					  <tr>
						<td width="3%" class="left">13.</td>
						<td width="47%" class="rights">Tanggal dilaporkan penguji : '.$arrmax[2].'/'.$arrmax[1].'/'.$arrmax[0].'</td>
						<td width="2%">14.</td>
						<td width="47%" class="rights">Catatan Pengujian diperiksa :</td>
					  </tr>
					  <tr>
						<td width="3%" rowspan="5" class="left bottom">&nbsp;</td>
						<td width="47%" rowspan="5" valign="top" class="bottom rights">';
						$jpenguji = count($arr_penguji);
						if($arr_penguji > 0){
							$nama = "";
							for($i = 0; $i < $jpenguji; $i++){
								if($arr_penguji[$i]['NAMA_USER'] != $nama){
									$html .= $arr_penguji[$i]['NAMA_USER'] . "<br>";
								}
								$nama = $arr_penguji[$i]['NAMA_USER'];
							}
						}			
			$html .= '</td>
						<td width="2%" class="left">&nbsp;</td>
						<td width="47%" class="rights">'.$arr_penyelia[0]['KOTA'].', '.$arr_penyelia[0]['TANGGAL_PENYELIA'].'</td>
					  </tr>
					  <tr>
						<td width="2%" class="left">&nbsp;</td>
						<td width="47%" class="rights">'.$arr_penyelia[0]['JABATAN'].'</td>
					  </tr>
					  <tr>
						<td width="2%" height="75" class="left">&nbsp;</td>
						<td width="47%" class="rights">&nbsp;</td>
					  </tr>
					  <tr>
						<td width="2%">&nbsp;</td>
						<td width="47%" class="rights">'.$arr_penyelia[0]['NAMA'].'</td>
					  </tr>
					  <tr>
						<td width="2%" class="bottom">&nbsp;</td>
						<td width="47%" class="bottom rights">'.$arr_penyelia[0]['NIP'].'</td>
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