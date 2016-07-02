<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Sampel extends Controller{
	function Sampel(){
		parent::Controller();
	}
	function index(){
		redirect(base_url());
		exit();
	}
	
	function lampiran_tps($id){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$query = "SELECT KODE_SAMPEL, dbo.GOLONGAN_SAMPEL(KLASIFIKASI) AS KLASIFIKASI, dbo.GOLONGAN_SAMPEL(SUB_KLASIFIKASI) AS SUB_KLASIFIKASI, dbo.GOLONGAN_SAMPEL(SUB_SUB_KLASIFIKASI) AS SUB_SUB_KLASIFIKASI, KLASIFIKASI_TAMBAHAN, UPPER(NAMA_SAMPEL) AS NAMA_SAMPEL, NOMOR_REGISTRASI, PABRIK, IMPORTIR, BENTUK_SEDIAAN, KEMASAN, NO_BETS, KETERANGAN_ED, JUMLAH_SAMPEL, SATUAN, HARGA_SAMPEL, UJI_KIMIA, JUMLAH_KIMIA ,UJI_MIKRO, JUMLAH_MIKRO, SISA, KOMPOSISI, NETTO, EVALUASI_PENANDAAN, CARA_PENYIMPANAN, CATATAN, dbo.URAIAN_M_TABEL('KONDISI_SAMPEL',KONDISI_SAMPEL) AS KONDISI_SAMPEL FROM T_SAMPEL WHERE PERIKSA_ID = '".$id."'";
			$res = $sipt->main->get_result($query);
			if($res){
				foreach($query->result_array() as $row){
					$sampel[] = $row; 
					$arrdata = array('sess' => $sampel);
				}
				$qsampel = "SELECT A.NAMA_BBPOM, C.KODE_SAMPEL FROM M_BBPOM A LEFT JOIN T_PEMERIKSAAN_SAMPLING B ON A.BBPOM_ID = B.BBPOM_ID LEFT JOIN T_SAMPEL C ON B.PERIKSA_ID = C.PERIKSA_ID WHERE B.PERIKSA_ID = '".$id."'";
				$rssampel = $sipt->main->get_result($qsampel);
				if($rssampel){
					$label = array();
					foreach($qsampel->result() as $row){
						$label['kode'][] = $row->KODE_SAMPEL;
						$label['balai'] = $row->NAMA_BBPOM;
					}
				}
				$arrdata['label'] = $label;
				$this->load->library('mpdf');
				$mpdf=new mPDF('win-1252',array(210,330));
				$mpdf->mirrorMargins = true;
				$mpdf->SetAuthor("Syafrizal");
				$mpdf->SetDisplayMode('fullpage','two');
				$html = $this->load->view('pengujian/cetak/lampiran_sampel', $arrdata, true);
				$lampiran = $this->mpdf->WriteHTML($html);
				$lampiran = $this->mpdf->Output();
				echo $lampiran;
				exit();
			}
		}
	}
	
	function cetak($var){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$ids = explode(",",$var);
			$id = "";
			foreach($ids as $a){
				$chk = explode(".", $a);
				$id .= "'".$chk[2] . "'" . ",";
			}
			$id = substr($id, 0, -1);
			$query = "SELECT A.KODE_SAMPEL, dbo.GOLONGAN_SAMPEL(A.KLASIFIKASI) AS KLASIFIKASI, 
					  dbo.GOLONGAN_SAMPEL(A.SUB_KLASIFIKASI) AS SUB_KLASIFIKASI, dbo.GOLONGAN_SAMPEL(A.SUB_SUB_KLASIFIKASI) AS SUB_SUB_KLASIFIKASI, 
					  A.KLASIFIKASI_TAMBAHAN, UPPER(A.NAMA_SAMPEL) AS NAMA_SAMPEL, A.NOMOR_REGISTRASI, A.PABRIK, A.IMPORTIR, 
					  A.BENTUK_SEDIAAN, A.KEMASAN, A.NO_BETS, A.KETERANGAN_ED, A.JUMLAH_SAMPEL, A.SATUAN, A.HARGA_SAMPEL, 
					  A.UJI_KIMIA, A.JUMLAH_KIMIA ,A.UJI_MIKRO, A.JUMLAH_MIKRO, A.SISA, A.KOMPOSISI, A.NETTO, A.EVALUASI_PENANDAAN, 
					  A.CARA_PENYIMPANAN, A.CATATAN, dbo.URAIAN_M_TABEL('KONDISI_SAMPEL',A.KONDISI_SAMPEL) AS KONDISI_SAMPEL,
					  dbo.URAIAN_M_TABEL('ANGGARAN_SAMPLING',B.ANGGARAN) AS ANGGARAN,
					  dbo.URAIAN_M_TABEL('ASAL_SAMPLING',B.ASAL_SAMPLING) AS ASAL_SAMPLING,
					  E.NAMA_SARANA AS [TEMPAT SAMPLING],
					  CONVERT(VARCHAR(10), B.TANGGAL_AWAL_SAMPLING, 120) +' s.d ' + CONVERT(VARCHAR(10), B.TANGGAL_AKHIR_SAMPLING, 120) AS [TANGGAL SAMPLING],
					  DATENAME(month, B.CREATE_DATE) AS BULAN,
					  DATENAME(year, B.TANGGAL_AWAL_SAMPLING) AS TAHUN
					  FROM T_SAMPEL A LEFT JOIN T_PEMERIKSAAN_SAMPLING B ON A.PERIKSA_ID = B.PERIKSA_ID
					  LEFT JOIN T_SURAT_SAMPEL_PELAPORAN C ON B.PERIKSA_ID = C.LAPOR_ID
					  LEFT JOIN T_SURAT_SAMPEL D ON C.SURAT_ID = D.SURAT_ID
					  LEFT JOIN M_SARANA E ON B.SARANA_ID = E.SARANA_ID
					  WHERE A.KODE_SAMPEL IN ($id)";
			$res = $sipt->main->get_result($query);
			if($res){
				foreach($query->result_array() as $row){
					$sampel[] = $row; 
					$arrdata = array('sess' => $sampel);
				}
				$this->load->library('mpdf');
				//$mpdf=new mPDF('win-1252',array(210,330));
				$mpdf=new mPDF('','', 0, '', 15, 15, 16, 16, 9, 9, 'L');
				$mpdf->mirrorMargins = true;
				$mpdf->SetAuthor("Syafrizal");
				$mpdf->SetDisplayMode('fullpage','two');
				$html = $this->load->view('pengujian/cetak/lps', $arrdata, true);
				$lampiran = $this->mpdf->WriteHTML($html);
				$lampiran = $this->mpdf->Output();
				echo $lampiran;
				exit();
			}
		}
	}
	
	function set_print_cp_lhu_rujukan($id)
	{
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$arr_sampel = $this->db->query("SELECT A.NAMA_SAMPEL, A.KODE_SAMPEL, dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) AS KODE, dbo.FORMAT_NOMOR('SPU',C.SPU_ID) AS SPU, A.TEMPAT_SAMPLING, CONVERT(VARCHAR(10), A.TANGGAL_SAMPLING, 103) AS TANGGAL_SAMPLING, A.ALAMAT_SAMPLING, A.NOMOR_REGISTRASI, A.PABRIK, A.IMPORTIR, A.KEMASAN, A.BENTUK_SEDIAAN, A.NO_BETS, A.SATUAN, dbo.KATEGORI(A.KOMODITI,A.PRIORITAS) AS KOMODITI, dbo.KATEGORI(A.KATEGORI,A.PRIORITAS) AS KATEGORIX, A.NAMA_KATEGORI AS KATEGORI, A.KETERANGAN_ED, A.JUMLAH_KIMIA, A.JUMLAH_MIKRO, A.KOMPOSISI, A.NETTO, A.PEMERIAN, B.NOMOR_SURAT, CONVERT(VARCHAR(10), B.TANGGAL_SURAT, 103) AS TANGGAL_SURAT, B.NAMA_PENGIRIM, CONVERT(VARCHAR(10), C.TANGGAL_TERIMA_TPS, 103) AS TANGGAL_TERIMA_TPS, CONVERT(VARCHAR(10), C.TANGGAL, 103) AS TANGGAL_SPU, A.JUMLAH_KIMIA, A.UJI_KIMIA, A.UJI_MIKRO, A.JUMLAH_MIKRO, CASE WHEN A.HASIL_KIMIA = 'MS' THEN 'Memenuhi Syarat' WHEN A.HASIL_KIMIA = 'TMS' THEN 'Tidak Memenuhi Syarat' ELSE 'Hasil Pengujian Seperti Tersebut' END HASIL_KIMIA, CASE WHEN A.HASIL_MIKRO = 'MS' THEN 'Memenuhi Syarat' WHEN A.HASIL_MIKRO = 'TMS' THEN 'Tidak Memenuhi Syarat' ELSE 'Hasil Pengujian Seperti Tersebut' END HASIL_MIKRO, CASE WHEN A.HASIL_SAMPEL = 'MS' THEN 'Memenuhi Syarat' WHEN A.HASIL_SAMPEL = 'TMS' THEN 'Tidak Memenuhi Syarat' ELSE 'Hasil Pengujian Seperti Tersebut' END HASIL_SAMPEL, A.CATATAN_CP, A.LABEL, A.SEGEL, A.PEMERIAN FROM T_M_SAMPEL A LEFT JOIN T_PERIKSA_SAMPEL B ON A.PERIKSA_SAMPEL = B.PERIKSA_SAMPEL LEFT JOIN T_SPU C ON A.SPU_ID = C.SPU_ID WHERE A.KODE_SAMPEL = '".$id."'")->result_array();
			
			$tanggaluji = $this->db->query("SELECT MIN(CONVERT(VARCHAR(10), AWAL_UJI, 120)) AS MINTGL, MAX(CONVERT(VARCHAR(10), AKHIR_UJI, 120)) AS MAXTGL FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL = '".$id."'")->result_array();
			
			$arr_tanggal  = $this->db->query("SELECT MIN(CONVERT(VARCHAR(10), AWAL_UJI, 120)) AS MINTGL, MAX(CONVERT(VARCHAR(10), AKHIR_UJI, 120)) AS MAXTGL FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL = '".$id."'")->result_array();
			$rowlhu = $this->db->query("SELECT Z.UJI_KIMIA, Z.UJI_MIKRO, Z.STATUS_KIMIA, Z.STATUS_MIKRO, A.CP_ID, dbo.URAIAN_M_TABEL('HASIL',A.HASIL) AS HASIL, A.CREATE_BY, dbo.FORMAT_NOMOR('LHU',B.LHU_ID) AS NOMOR_LHU, SUBSTRING(RTRIM(LTRIM(B.LHU_ID)),7,1) AS UJI FROM T_M_SAMPEL Z LEFT JOIN T_CP A ON Z.KODE_SAMPEL = A.KODE_SAMPEL LEFT JOIN T_LHU B ON A.CP_ID = B.CP_ID WHERE Z.KODE_SAMPEL = '".$id."'")->result_array(); 
			$jmllhu = count($rowlhu);
			if($jmllhu > 0){
				$html .= '<pagebreak sheet-size="210mm 330mm" />';
				$page = 1;
				for($z = 0; $z < $jmllhu; $z++){
					
					$arr_penyelia = $this->db->query("SELECT CONVERT(VARCHAR(10), A.CREATE_DATE, 103) AS TANGGAL_PENYELIA, A.CATATAN, B.NAMA_USER AS NAMA, B.USER_ID AS NIP, B.JABATAN, C.KOTA FROM T_CP A LEFT JOIN T_USER B ON A.CREATE_BY = B.USER_ID LEFT JOIN M_BBPOM C ON A.BBPOM_ID = C.BBPOM_ID WHERE A.KODE_SAMPEL = '".$id."' AND A.CREATE_BY = '".$rowlhu[$z]['CREATE_BY']."'")->result_array();
					
					$arr_penguji = $this->db->query("SELECT A.NAMA_USER FROM T_USER A LEFT JOIN T_PARAMETER_HASIL_UJI B ON A.USER_ID = B.PENGUJI WHERE B.KODE_SAMPEL = '".$id."' AND B.PENYELIA = '".$rowlhu[$z]['CREATE_BY']."'")->result_array();		
					
					$bidang = $sipt->main->get_uraian("SELECT DISTINCT LEFT(SARANA_MEDIA_ID,2) AS BIDANG FROM T_USER_ROLE WHERE USER_ID = '".$rowlhu[$z]['CREATE_BY']."' GROUP BY SARANA_MEDIA_ID","BIDANG");
					
					//if($rowlhu[$z]['UJI'] == "K"){
					if($bidang == 'B1' || $bidang == 'B2'){	
						$parameter = $this->db->query("SELECT CASE WHEN JENIS_UJI = '01' THEN 'Mikrobiologi' WHEN JENIS_UJI = '02' THEN 'Kimia - Fisika' END AS JENIS_UJI, SPK_ID,PARAMETER_UJI, METODE, PUSTAKA, SYARAT, RUANG_LINGKUP, HASIL, REPLACE(REPLACE(HASIL_KUALITATIF,'<',' < '),'>',' > ') AS HASIL_KUALITATIF, LCP FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL = '".$id."' AND JENIS_UJI = '02'")->result_array();
					}else if($bidang = 'B3'){
						$parameter =  $this->db->query("SELECT CASE WHEN JENIS_UJI = '01' THEN 'Mikrobiologi' WHEN JENIS_UJI = '02' THEN 'Kimia - Fisika' END AS JENIS_UJI, SPK_ID,PARAMETER_UJI, METODE, PUSTAKA, SYARAT, RUANG_LINGKUP, HASIL, REPLACE(REPLACE(HASIL_KUALITATIF,'<',' < '),'>',' > ') AS HASIL_KUALITATIF, LCP FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL = '".$id."' AND JENIS_UJI = '01'")->result_array();
					}
					
					$html .= '<div style="font-size:11pt; font-weight:bold; text-align:center; font-family:Times New Roman;">CATATAN PENGUJIAN - RUJUKAN</div>';
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
					$arrmintanggal = explode("-",$arr_tanggal[0]['MINTGL']);
					$arrmaxtanggal = explode("-",$arr_tanggal[0]['MAXTGL']);
					$html .= '<tr>
								<td class="alt2 left">&nbsp;</td>
								<td class="alt2 left">'.$arrmintanggal[2].'/'.$arrmintanggal[1].'/'.$arrmintanggal[0].'</td>
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
								if($rowlhu[$z]['UJI'] == "M"){
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
					$html .= '<table width="100%" border="0" class="tablepdf2">
							  <tr><td class="left top bottom" width="25%">Uji yang dilakukan</td><td class="top bottom" width="10%">Hasil</td><td class="top bottom" width="15%">Syarat</td><td class="top bottom" width="15%">Metode</td><td class="top bottom top" width="15%">Pustaka</td></tr>';
								$jparameter = count($parameter);
								if($jparameter > 0){
									for($x = 0; $x < $jparameter; $x++){
										$html .= '<tr><td class="left rights">'.$parameter[$x]['PARAMETER_UJI'].'</td><td class="left"><div>'.$parameter[$x]['HASIL'].'</div><div>'.$parameter[$x]['HASIL_KUALITATIF'].'</div></td><td class="left">'.$parameter[$x]['SYARAT'].'</td><td class="left">'.$parameter[$x]['METODE'].'</td><td class="left rights">'.$parameter[$x]['PUSTAKA'].'</td></tr>';
									}
								}
					$html .= '</table>';
					
					$html .= '<table width="100%" border="0" cellpadding="4" cellspacing="4" class="tablepdf2">
							  <tr>
								<td width="3%" class="left bottom tops">10.</td>
								<td width="31%" class="bottom tops">Kesimpulan</td>
								<td width="2%" class="bottom tops">&nbsp;</td>
								<td width="64%" class="bottom rights tops">';
								if($rowlhu[$z]['UJI'] == "M")
									$html .= $arr_sampel[0]['HASIL_MIKRO'];
								else
									$html .= $arr_sampel[0]['HASIL_KIMIA'];
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
								if($rowlhu[$z]['UJI'] == "M"){
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
							
					$html .= '<table width="100%" border="0" cellpadding="4" cellspacing="4" class="tablepdf2">
							  <tr>
								<td width="3%" class="left">13.</td>
								<td width="47%" class="rights">Tanggal dilaporkan penguji : '.$arrmaxtanggal[2].'/'.$arrmaxtanggal[1].'/'.$arrmaxtanggal[0].'</td>
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
					
					#----- Batas CP
					#----- Mulai LHU  
					$html .= '<pagebreak sheet-size="210mm 330mm" />';
					
					  
					$html .= '<div style="font-size:11pt; font-weight:bold; text-align:center; font-family:Times New Roman;">LAPORAN HASIL UJI - RUJUKAN</div>';
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
				return $html;
			}
		}
	}

	function rilis($jenis, $id=""){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			if($jenis == "cp-lcp-lhu"){
				$sipt =& get_instance();
				$this->load->model("main", "main", true);
				$this->load->library('mpdf');

				#--- Query Data Sampel
				
				$arr_sampel = $this->db->query("SELECT A.NAMA_SAMPEL, A.KODE_SAMPEL, dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) AS KODE, dbo.FORMAT_NOMOR('SPU',C.SPU_ID) AS SPU, A.TEMPAT_SAMPLING, CONVERT(VARCHAR(10), A.TANGGAL_SAMPLING, 103) AS TANGGAL_SAMPLING, A.ALAMAT_SAMPLING, A.NOMOR_REGISTRASI, A.PABRIK, A.IMPORTIR, A.KEMASAN, A.BENTUK_SEDIAAN, A.NO_BETS, A.SATUAN, dbo.KATEGORI(A.KOMODITI,A.PRIORITAS) AS KOMODITI, dbo.KATEGORI(A.KATEGORI,A.PRIORITAS) AS KATEGORIX, A.NAMA_KATEGORI AS KATEGORI, A.KETERANGAN_ED, A.JUMLAH_KIMIA, A.JUMLAH_MIKRO, A.KOMPOSISI, A.NETTO, A.PEMERIAN, B.NOMOR_SURAT, CONVERT(VARCHAR(10), B.TANGGAL_SURAT, 103) AS TANGGAL_SURAT, B.NAMA_PENGIRIM, CONVERT(VARCHAR(10), C.TANGGAL_TERIMA_TPS, 103) AS TANGGAL_TERIMA_TPS, CONVERT(VARCHAR(10), C.TANGGAL, 103) AS TANGGAL_SPU, A.JUMLAH_KIMIA, A.UJI_KIMIA, A.UJI_MIKRO, A.JUMLAH_MIKRO, CASE WHEN A.HASIL_KIMIA = 'MS' THEN 'Memenuhi Syarat' WHEN A.HASIL_KIMIA = 'TMS' THEN 'Tidak Memenuhi Syarat' ELSE 'Hasil Pengujian Seperti Tersebut' END HASIL_KIMIA, CASE WHEN A.HASIL_MIKRO = 'MS' THEN 'Memenuhi Syarat' WHEN A.HASIL_MIKRO = 'TMS' THEN 'Tidak Memenuhi Syarat' ELSE 'Hasil Pengujian Seperti Tersebut' END HASIL_MIKRO, CASE WHEN A.HASIL_SAMPEL = 'MS' THEN 'Memenuhi Syarat' WHEN A.HASIL_SAMPEL = 'TMS' THEN 'Tidak Memenuhi Syarat' ELSE 'Hasil Pengujian Seperti Tersebut' END HASIL_SAMPEL, A.CATATAN_CP, A.LABEL, A.SEGEL, A.PEMERIAN FROM T_M_SAMPEL A LEFT JOIN T_PERIKSA_SAMPEL B ON A.PERIKSA_SAMPEL = B.PERIKSA_SAMPEL LEFT JOIN T_SPU C ON A.SPU_ID = C.SPU_ID WHERE A.KODE_SAMPEL = '".$id."'")->result_array();
				
				$tanggaluji = $this->db->query("SELECT MIN(CONVERT(VARCHAR(10), AWAL_UJI, 120)) AS MINTGL, MAX(CONVERT(VARCHAR(10), AKHIR_UJI, 120)) AS MAXTGL FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL = '".$id."'")->result_array();
				
				$arr_tanggal  = $this->db->query("SELECT MIN(CONVERT(VARCHAR(10), AWAL_UJI, 120)) AS MINTGL, MAX(CONVERT(VARCHAR(10), AKHIR_UJI, 120)) AS MAXTGL FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL = '".$id."'")->result_array();
				$rowlhu = $this->db->query("SELECT Z.UJI_KIMIA, Z.UJI_MIKRO, Z.STATUS_KIMIA, Z.STATUS_MIKRO, A.CP_ID, dbo.URAIAN_M_TABEL('HASIL',A.HASIL) AS HASIL, A.CREATE_BY, dbo.FORMAT_NOMOR('LHU',B.LHU_ID) AS NOMOR_LHU, SUBSTRING(RTRIM(LTRIM(B.LHU_ID)),7,1) AS UJI FROM T_M_SAMPEL Z LEFT JOIN T_CP A ON Z.KODE_SAMPEL = A.KODE_SAMPEL LEFT JOIN T_LHU B ON A.CP_ID = B.CP_ID WHERE Z.KODE_SAMPEL = '".$id."'")->result_array(); 
				$jmllhu = count($rowlhu);
				if($jmllhu > 0){
					$html = "";
					$page = 1;
					for($z = 0; $z < $jmllhu; $z++){
						
						$arr_penyelia = $this->db->query("SELECT CONVERT(VARCHAR(10), A.CREATE_DATE, 103) AS TANGGAL_PENYELIA, A.CATATAN, B.NAMA_USER AS NAMA, B.USER_ID AS NIP, B.JABATAN, C.KOTA FROM T_CP A LEFT JOIN T_USER B ON A.CREATE_BY = B.USER_ID LEFT JOIN M_BBPOM C ON A.BBPOM_ID = C.BBPOM_ID WHERE A.KODE_SAMPEL = '".$id."' AND A.CREATE_BY = '".$rowlhu[$z]['CREATE_BY']."'")->result_array();
						
						$arr_penguji = $this->db->query("SELECT A.NAMA_USER FROM T_USER A LEFT JOIN T_PARAMETER_HASIL_UJI B ON A.USER_ID = B.PENGUJI WHERE B.KODE_SAMPEL = '".$id."' AND B.PENYELIA = '".$rowlhu[$z]['CREATE_BY']."'")->result_array();		
						
						$bidang = $sipt->main->get_uraian("SELECT DISTINCT LEFT(SARANA_MEDIA_ID,2) AS BIDANG FROM T_USER_ROLE WHERE USER_ID = '".$rowlhu[$z]['CREATE_BY']."' GROUP BY SARANA_MEDIA_ID","BIDANG");
						
						//if($rowlhu[$z]['UJI'] == "K"){
						if($bidang == 'B1' || $bidang == 'B2'){	
							$parameter = $this->db->query("SELECT CASE WHEN JENIS_UJI = '01' THEN 'Mikrobiologi' WHEN JENIS_UJI = '02' THEN 'Kimia - Fisika' END AS JENIS_UJI, SPK_ID,PARAMETER_UJI, METODE, PUSTAKA, SYARAT, RUANG_LINGKUP, HASIL, REPLACE(REPLACE(HASIL_KUALITATIF,'<',' < '),'>',' > ') AS HASIL_KUALITATIF, LCP FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL = '".$id."' AND JENIS_UJI = '02'")->result_array();
						}else if($bidang = 'B3'){
							$parameter =  $this->db->query("SELECT CASE WHEN JENIS_UJI = '01' THEN 'Mikrobiologi' WHEN JENIS_UJI = '02' THEN 'Kimia - Fisika' END AS JENIS_UJI, SPK_ID,PARAMETER_UJI, METODE, PUSTAKA, SYARAT, RUANG_LINGKUP, HASIL, REPLACE(REPLACE(HASIL_KUALITATIF,'<',' < '),'>',' > ') AS HASIL_KUALITATIF, LCP FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL = '".$id."' AND JENIS_UJI = '01'")->result_array();
						}
						
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
						$arrmintanggal = explode("-",$arr_tanggal[0]['MINTGL']);
						$arrmaxtanggal = explode("-",$arr_tanggal[0]['MAXTGL']);
						$html .= '<tr>
									<td class="alt2 left">&nbsp;</td>
									<td class="alt2 left">'.$arrmintanggal[2].'/'.$arrmintanggal[1].'/'.$arrmintanggal[0].'</td>
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
									if($rowlhu[$z]['UJI'] == "M"){
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
						$html .= '<table width="100%" border="0" class="tablepdf2">
								  <tr><td class="left top bottom" width="25%">Uji yang dilakukan</td><td class="top bottom" width="10%">Hasil</td><td class="top bottom" width="15%">Syarat</td><td class="top bottom" width="15%">Metode</td><td class="top bottom top" width="15%">Pustaka</td></tr>';
									$jparameter = count($parameter);
									if($jparameter > 0){
										for($x = 0; $x < $jparameter; $x++){
											$html .= '<tr><td class="left rights">'.$parameter[$x]['PARAMETER_UJI'].'</td><td class="left"><div>'.$parameter[$x]['HASIL'].'</div><div>'.$parameter[$x]['HASIL_KUALITATIF'].'</div></td><td class="left">'.$parameter[$x]['SYARAT'].'</td><td class="left">'.$parameter[$x]['METODE'].'</td><td class="left rights">'.$parameter[$x]['PUSTAKA'].'</td></tr>';
										}
									}
						$html .= '</table>';
						
						$html .= '<table width="100%" border="0" cellpadding="4" cellspacing="4" class="tablepdf2">
								  <tr>
									<td width="3%" class="left bottom tops">10.</td>
									<td width="31%" class="bottom tops">Kesimpulan</td>
									<td width="2%" class="bottom tops">&nbsp;</td>
									<td width="64%" class="bottom rights tops">';
									if($rowlhu[$z]['UJI'] == "M")
										$html .= $arr_sampel[0]['HASIL_MIKRO'];
									else
										$html .= $arr_sampel[0]['HASIL_KIMIA'];
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
									if($rowlhu[$z]['UJI'] == "M"){
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
								
						$html .= '<table width="100%" border="0" cellpadding="4" cellspacing="4" class="tablepdf2">
								  <tr>
									<td width="3%" class="left">13.</td>
									<td width="47%" class="rights">Tanggal dilaporkan penguji : '.$arrmaxtanggal[2].'/'.$arrmaxtanggal[1].'/'.$arrmaxtanggal[0].'</td>
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
						
						#----- Batas CP
						#----- Mulai LHU  
						$html .= '<pagebreak sheet-size="210mm 330mm" />';
						
						  
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


					$bl_page_rujukan = FALSE;
					$sKode_Sampel_Rujukan = $sipt->main->get_uraian("SELECT KODE_SAMPEL FROM T_M_SAMPEL WHERE KODE_RUJUKAN = '".$id."'","KODE_SAMPEL");
					if($sKode_Sampel_Rujukan)
					{
						$bl_page_rujukan = TRUE;
					}
					if($bl_page_rujukan)
					{
						$html .= $this->set_print_cp_lhu_rujukan($sKode_Sampel_Rujukan);
					}
				}else{
					$html = "<p>Data tidak ditemukan</p>";
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
	}
	
}
?>