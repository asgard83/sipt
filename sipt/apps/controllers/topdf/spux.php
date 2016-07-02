<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Spux extends Controller{
	
	function Spux(){
		parent::Controller();
	}
	
	function index(){
	  	$this->fungsi->redirectMessage('Maaf anda tidak bisa mengakses halaman ini.','/home');
	}
	
	function prints($spuid){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$this->load->library('mpdf');
			$arr_header = explode("|",$sipt->main->get_uraian("SELECT dbo.FORMAT_NOMOR('SPU',SPU_ID) +'|'+ dbo.URAIAN_M_TABEL('ANGGARAN_SAMPLING', SUBSTRING(SPU_ID, 7,2)) + '|' + dbo.URAIAN_M_TABEL('ASAL_SAMPLING', ASAL_SAMPEL) +'|'+ dbo.KATEGORI(SUBSTRING(SPU_ID, 13,2),'0') +'|'+ STATUS AS [HEADER] FROM T_SPU WHERE SPU_ID = '".$spuid."'","HEADER"));
			$html = "";
			$html .= '<div class="judul">Surat Permintaan Uji</div>';
			$html .= '<div class="judul">'.$arr_header[0].'</div>';
			$html .= '<div style="height:5px;">&nbsp;</div>';
			$html .= '<p>Bersama ini disampaikan daftar sampel : </p>';
			$html .= '<table>';
			$html .= '<tr><td width="100px">Komoditi</td><td width="10px">:</td><td>'.$arr_header[3].'</td></tr>';
			$html .= '<tr><td>Anggaran</td><td>:</td><td>'.$arr_header[1].'</td></tr>';
			$html .= '<tr><td>Asal Sampling</td><td>:</td><td>'.$arr_header[2].'</td></tr>';
			$html .= '</table>';
			$html .= '<p>Untuk dilakukan pengujian sesuai ruang lingkup.</p>';
			$detil = "SELECT dbo.FORMAT_NOMOR('SPL', A.KODE_SAMPEL) AS KODE, A.NAMA_SAMPEL, A.NOMOR_REGISTRASI, A.BENTUK_SEDIAAN, A.PABRIK, A.IMPORTIR, dbo.KATEGORI(A.KOMODITI,A.PRIORITAS) AS KOMODITI, dbo.KATEGORI(A.KATEGORI,A.PRIORITAS) AS KATEGORIX, A.NAMA_KATEGORI AS KATEGORI, REPLACE(A.KOMPOSISI,';','<br>') AS KOMPOSISI, A.KEMASAN, A.KETERANGAN_ED, A.NO_BETS, A.NETTO, A.TEMPAT_SAMPLING, CONVERT(VARCHAR(10), A.TANGGAL_SAMPLING, 103) AS TANGGAL_SAMPLING, A.JUMLAH_SAMPEL, A.JUMLAH_KIMIA, A.JUMLAH_MIKRO, A.SISA, A.EVALUASI_PENANDAAN, A.KETERANGAN_ED, A.CARA_PENYIMPANAN, A.KONDISI_SAMPEL, A.KLASIFIKASI_TAMBAHAN, B.NOMOR_SURAT, dbo.PETUGAS_SAMPLING(A.PERIKSA_SAMPEL) AS PETUGAS_SAMPLING, A.CATATAN, A.UJI_KIMIA, A.UJI_MIKRO, B.NAMA_PENGIRIM, B.NIP_PENGIRIM , A.PERIKSA_SAMPEL FROM T_PERIKSA_SAMPEL B LEFT JOIN T_M_SAMPEL A  ON A.PERIKSA_SAMPEL = B.PERIKSA_SAMPEL WHERE A.SPU_ID= '".$spuid."' ORDER BY A.KODE_SAMPEL ASC";
			$res = $sipt->main->get_result($detil);
			if($res){
				  $grs="alt2";
				  $class="left";
				  $no = 1;
				  $html .= '<table width="100%" class="tablepdf" id="tablepdf" >
					  <tr>
						<th rowspan="2" class="header rows left" width="1%">No.</th>
						<th class="header" rowspan="2">Kode Sampel</th>
						<th class="header" colspan="3" rowspan="2">Identitas Sampel</th>
						<th class="header" rowspan="2">Pengirim Sampel</th>
						<th class="header" colspan="4">Jumlah Sampel</th>
						<th class="header" rowspan="2">Keterangan Tambahan</th>
						<th class="header" rowspan="2">Nomor Surat <br> Petugas Penerima Sampel</th>
						<th class="header" rowspan="2">Catatan</th>
					  </tr>
					  <tr>
						<th class="header">T</th>
						<th class="header">K</th>
						<th class="header">M</th>
						<th class="header">S</th>
					  </tr>';
				  foreach($detil->result_array() as $dt){
					  $sess[] = $dt;  		  
					  $html .= '<tr>
								<td class="'.$grs.' '.$class.'">'.$no.'</td>
								<td class="'.$grs.' '.$class.'">'.$dt['KODE'].'</td>
								<td class="'.$grs.' '.$class.'"><div class="uline">'.$dt['NAMA_SAMPEL'].'</div><div class="uline">&bull; '.$dt['NOMOR_REGISTRASI'].'</div><div class="uline">&bull; '.$dt['BENTUK_SEDIAAN'].'</div><div class="uline">&bull; '.$dt['KOMODITI'].'</div><div class="uline">'.$dt['KATEGORI'].'</div><div class="uline">&bull; '.$dt['PABRIK'].'</div><div class="uline">&bull; '.$dt['IMPORTIR'].'</div></td>
								<td class="'.$grs.' '.$class.'">'.str_replace(">", " > ", str_replace("<"," < ", $dt['KOMPOSISI'])).'</td>
								<td class="'.$grs.' '.$class.'">'.$dt['KEMASAN'].'</td>
								<td class="'.$grs.' '.$class.'">'.$dt['TEMPAT_SAMPLING'].'</td>
								<td class="'.$grs.' '.$class.'">'.$dt['JUMLAH_SAMPEL'].'</td>
								<td class="'.$grs.' '.$class.'">'.$dt['JUMLAH_KIMIA'].'</td>
								<td class="'.$grs.' '.$class.'">'.$dt['JUMLAH_MIKRO'].'</td>
								<td class="'.$grs.' '.$class.'">'.$dt['SISA'].'</td>
								<td class="'.$grs.' '.$class.'">'.$dt['EVALUASI_PENANDAAN'].'<div>Keterangan ED : </div><div class="uline">'.$dt['KETERANGAN_ED'].'</div></td>
								<td class="'.$grs.' '.$class.'"><div>'.$dt['NOMOR_SURAT'].'</div><div>';
								$arr_petugas = explode("|",ltrim($dt['PETUGAS_SAMPLING'],'|'));
								$html .= '<ul style="list-style:none; margin:0px;">';
								$html .= '<li>'.join('</li><li>', $arr_petugas).'</li>';
								$html .= '</ul><div></td>
								<td class="'.$grs.' right">'.$dt['CATATAN'].'</td>
							  </tr>';
							  $no++;
				  }
				  $html .= '</table>';
			}else{
				$html .= '<table width="100%" class="tablepdf" id="tablepdf" >
					  <tr>
						<th rowspan="2" class="header rows left" width="1%">No.</th>
						<th class="header" rowspan="2">Kode Sampel</th>
						<th class="header" colspan="3" rowspan="2">Identitas Sampel</th>
						<th class="header" rowspan="2">Keterangan Sampling</th>
						<th class="header" colspan="4">Jumlah Sampel</th>
						<th class="header" rowspan="2">Keterangan Tambahan</th>
						<th class="header" rowspan="2">Nomor Surat <br> Petugas Sampling</th>
						<th class="header" rowspan="2">Catatan</th>
					  </tr>
					  <tr>
						<th class="header">T</th>
						<th class="header">K</th>
						<th class="header">M</th>
						<th class="header">S</th>
					  </tr>';
				$html .= '<tr><td colspan="13" class="'.$grs.' right">Tidak ada data untuk no SPU : '.$arr_header[0].'</td></tr>';
				$html .= '</table>';
			}
			
			$html .= '<div style="height:10px;">&nbsp;</div>';
			$html .= '<div><b>Keterangan Jumlah Sampel</b></div>';
			$html .= '<div>Jumlah T = Jumlah Total Sampel, Jumlah K = Jumlah Sampel Kimia, Jumlah M = Jumlah Sampel Mikro, Jumlah S = Jumlah Sisa Sampel</div>';
			$html .= '<div style="height:5px;">&nbsp;</div>';
			if(!$arr_header[4] == "50201"){
				$html .= '<table width="100%">
					  <tr><td width="33%">Pemohon / Pengirim Sampel</td><td width="33%">Tanggal, </td><td width="33%">Tanggal, </td></tr>
					  <tr><td>&nbsp;</td><td>Penerima Sampel</td><td>Mengetahui </td></tr>
					  <tr><td></td><td>(Manager Administrasi)</td><td>(Kepala Balai)</td></tr>
					  <tr><td height="75">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
					  <tr><td></td><td>NIP.</td><td>NIP. </td></tr></table>';
			}else{
				$kabid = explode("|", $sipt->main->get_uraian("SELECT A.NAMA_USER +'|'+ A.USER_ID +'|'+ CONVERT(VARCHAR(10), B.TANGGAL_KIRIM, 103) AS KABID FROM T_USER A LEFT JOIN T_SPU B ON A.USER_ID = B.TTD_PEMDIK WHERE SPU_ID = '".$spuid."'","KABID"));
				$ma = explode("|", $sipt->main->get_uraian("SELECT A.NAMA_USER +'|'+ A.USER_ID +'|'+ CONVERT(VARCHAR(10), B.TANGGAL_TERIMA_TPS, 103)  AS MA FROM T_USER A LEFT JOIN T_SPU B ON A.USER_ID = B.TTD_MA WHERE SPU_ID = '".$spuid."'","MA"));
				$mp = explode("|", $sipt->main->get_uraian("SELECT A.NAMA_USER +'|'+ A.USER_ID  +'|'+ CONVERT(VARCHAR(10), B.TANGGAL_PERINTAH, 103) AS MP FROM T_USER A LEFT JOIN T_SPU B ON A.USER_ID = B.TTD_MP WHERE SPU_ID = '".$spuid."'","MP"));
				$html .= '<table width="100%">
					  <tr><td width="33%">&nbsp;</td><td width="33%">Tanggal, '.$ma[2].'</td><td width="33%">Tanggal, '.$mp[2].'</td></tr>
					  <tr><td>&nbsp;</td><td>Penerima Sampel</td><td>Mengetahui </td></tr>
					  <tr><td>Pemohon / Pengirim Sampel</td><td>(Manager Administrasi)</td><td>(Kepala Balai)</td></tr>
					  <tr><td height="75">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
					  <tr><td>'.$dt['NAMA_PENGIRIM'].'</td><td>'.$ma[0].'</td><td>'.$mp[0].'</td></tr>
					  <tr><td>NIP. '.$dt['NIP_PENGIRIM'].'</td><td>NIP. '.$ma[1].'</td><td>NIP. '.$mp[1].'</td></tr></table>';
			}
			#--- Lampiran Daftar Sampel dan Label Kode Sampel		  
			$jml = count($sess);
			if($jml > 0){
				$html .= '<pagebreak sheet-size="210mm 330mm" />';
				$html .= '<p><b>DAFTAR LAMPIRAN SAMPEL</b></p>';
				$z = 0;
				for($i=0; $i<$jml; $i++){
					$tambahan = trim($sess[$i]['KLASIFIKASI_TAMBAHAN']) != "" ? $sess[$i]['KLASIFIKASI_TAMBAHAN'] : "-";
					$chkkimia = $sess[$i]['UJI_KIMIA'] > 0 ? "checked='checked'" : "";
					$chkmikro = $sess[$i]['UJI_MIKRO'] > 0 ? "checked='checked'" : "";
					$html .= '<table class="form_tabel" width="100%">
							  <tr><td width="15%">Kode Sampel</td><td class="kotak" colspan="3"><b>'.$sess[$i]['KODE'].'</b></td></tr>    
							  <tr><td width="15%">Komoditi</td><td class="kotak" width="35%">'.$sess[$i]['KOMODITI'].'</td><td width="15%">Identitas Tambahan</td><td class="kotak" width="35%">'.$tambahan.'</td></tr>
							  <tr><td>Kategori</td><td class="kotak">'.$sess[$i]['KATEGORI'].'</td><td>Sub Kategori</td><td class="kotak">'.$sess[$i]['SUB_KATEGORI'].'</td></tr>
							  <tr><td>Nama Sampel</td><td class="kotak">'.$sess[$i]['NAMA_SAMPEL'].'</td><td>Pabrik</td><td class="kotak">'.$sess[$i]['IMPORTIR'].'</td></tr>    
							  <tr><td>Importir</td><td class="kotak">'.$sess[$i]['PABRIK'].'</td><td>Bentuk Sediaan</td><td class="kotak">'.$sess[$i]['BENTUK_SEDIAAN'].'</td></tr>
							  <tr><td>Kemasan</td><td class="kotak">'.$sess[$i]['KEMASAN'].'</td><td>No. Bets</td><td class="kotak">'.$sess[$i]['NO_BETS'].'</td></tr>
							  <tr><td>Keterangan ED</td><td class="kotak">'.$sess[$i]['KETERANGAN_ED'].'</td><td>Netto</td><td class="kotak">'.$sess[$i]['NETTO'].'</td></tr>
							  <tr><td>Evaluasi Penandaan</td><td class="kotak">'.$sess[$i]['EVALUASI_PENANDAAN'].'</td><td>Cara Penyimpanan</td><td class="kotak">'.$sess[$i]['CARA_PENYIMPANAN'].'</td></tr>
							  <tr><td>Jumlah Sampel</td><td class="kotak">'.$sess[$i]['JUMLAH_SAMPEL'].' '.$sess[$i]['SATUAN'].'</td><td>Kondisi Sampel</td><td class="kotak">'.$sess[$i]['KONDISI_SAMPEL'].'</td></tr>
							  <tr><td>Pengujian</td><td class="kotak">
							  <div><span style="float:left;"><input type="checkbox" '.$chkkimia.' />&nbsp;Kimia</span>&nbsp;<span style="float:right; margin-right:2px;"><input type="text" style="width:20px; text-align:center;" value="'.$sess[$i]['JUMLAH_KIMIA'].'"/></span></div>
							  <div><span style="float:left;"><input type="checkbox" '.$chkmikro.' />&nbsp;Mikro</span>&nbsp;<span style="float:right; margin-right:2px;"><input type="text" style="width:20px; text-align:center;" value="'.$sess[$i]['JUMLAH_MIKRO'].'"/></span></div>
							  </td><td>Sisa Sampel</td><td class="kotak">'.$sess[$i]['SISA'].'</td></tr>
							  <tr><td>Komposisi</td><td class="kotak">'.str_replace(">", " > ", str_replace("<"," < ", $sess[$i]['KOMPOSISI'])).'</td><td>Catatan</td><td class="kotak">'.$sess[$i]['CATATAN'].'</td></tr>
							  </table>
							  <div style="height:5px; border-bottom:1px solid #ccc;">&nbsp;</div>';
							  if((($z+1) % 3) == 0) {
								  $html .= '<pagebreak />';
								  $html .= '<p><b>DAFTAR LAMPIRAN SAMPEL</b></p>';
							  }
							  $z++;
				}
				$html .= '<pagebreak sheet-size="210mm 300mm"/>';
				$html .= '<div><b>LABEL KODE SAMPEL</b></div>';
				$html .= '<div style="height:5px;">&nbsp;</div>';
				$balai = $sipt->main->get_uraian("SELECT REPLACE(REPLACE(NAMA_BBPOM,'BALAI BESAR POM DI ', 'BBPOM '),'BALAI POM DI ','BPOM ') AS NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","NAMA_BBPOM");
				$html .= '<table width="100%">';
				//$y = 0;
				for($x=0; $x<$jml; $x++){
					//$y++;
					//if((($y+1) % 1) == 0){
						//$html .= "</tr><tr>";
					//}
					$html .= '<tr>';
					for($b=0; $b < 3; $b++){
						$html .= '<td>';
						$html .= '<table width="300" cellpadding="0" cellspacing="0">
									  <tr>
										  <td rowspan="2" width="60" height="60" style="border-left:1px solid #000;border-top:1px solid #000;border-bottom:1px solid #000;"><img src="images/bpom_small.png" /></td>
										  <td style="border-left:1px solid #000;border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000; text-align:center;"><b>'.$sess[$x]['KODE'].'</b></td>
									  </tr>
									  <tr>
										  <td style="border-left:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000; text-align:center;">'.$balai.'</td>
									  </tr>';
						$html .= '</table>'; 
						$html .= '</td>';
					}
					$html .= '</tr>';
				}
				$html .= '</table>';
			}
			
			$mpdf=new mPDF('utf-8', array(330,210),10,10,10,10,10,10);
			$stylesheet = file_get_contents('css/mpdf.css');
			$mpdf->mirrorMargins = 1;
			if(!$arr_header[4] == "50201"){
				$mpdf->SetWatermarkText('DRAFT PENYERAHAN SAMPEL');
				$mpdf->watermark_font = 'DejaVuSansCondensed';
				$mpdf->showWatermarkText = true;
			}
			$mpdf->WriteHTML($stylesheet,1);
			$mpdf->WriteHTML($html);
			$mpdf->Output();
			exit;
		}
	}
		
}
?>