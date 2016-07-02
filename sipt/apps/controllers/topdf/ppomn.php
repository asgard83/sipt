<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Ppomn extends Controller{
	
	function Ppomn(){
		parent::Controller();
	}
	
	function index(){
	  	$this->fungsi->redirectMessage('Maaf anda tidak bisa mengakses halaman ini.','/home');
	}
	
	function cetak($jenis, $id=""){
		if($jenis == "spu"){
			echo $this->spu($id);
		}else if($jenis == "sps"){
			echo $this->sps($id);
		}else if($jenis == "spk"){
			echo $this->spk($id);
		}else if($jenis == "spp"){
			echo $this->spp($id);
		}else if($jenis == "cp"){
			echo $this->cp($id);
		}else if($jenis == "lhu"){
			echo $this->lhu($id);
		}else if($jenis == "konsep"){
			echo $this->konsep($id);
		}
	}
	
	
	function spu($spuid){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$this->load->library('mpdf');
			$arr_header = explode("|",$sipt->main->get_uraian("SELECT dbo.FORMAT_NOMOR('SPU',SPU_ID) +'|'+ dbo.URAIAN_M_TABEL('ANGGARAN_SAMPLING', SUBSTRING(SPU_ID, 7,2)) + '|' + dbo.URAIAN_M_TABEL('ASAL_SAMPLING', ASAL_SAMPEL) +'|'+ dbo.KATEGORI(SUBSTRING(SPU_ID, 13,2,'0')) +'|'+ STATUS AS [HEADER] FROM T_SPU WHERE SPU_ID = '".$spuid."'","HEADER"));
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
			$detil = "SELECT dbo.FORMAT_NOMOR('SPL', A.KODE_SAMPEL) AS KODE, A.NAMA_SAMPEL, A.NOMOR_REGISTRASI, A.BENTUK_SEDIAAN, A.PABRIK, A.IMPORTIR, dbo.KATEGORI(A.KOMODITI,A.PRIORITAS) AS KOMODITI, dbo.KATEGORI(A.KATEGORI,A.PRIORITAS) AS KATEGORI, REPLACE(A.KOMPOSISI,';','<br>') AS KOMPOSISI, A.KEMASAN, A.KETERANGAN_ED, A.NO_BETS, A.NETTO, A.TEMPAT_SAMPLING, CONVERT(VARCHAR(10), A.TANGGAL_SAMPLING, 103) AS TANGGAL_SAMPLING, A.JUMLAH_SAMPEL, A.JUMLAH_KIMIA, A.JUMLAH_MIKRO, A.SISA, A.EVALUASI_PENANDAAN, A.KETERANGAN_ED, A.CARA_PENYIMPANAN, A.KONDISI_SAMPEL, A.KLASIFIKASI_TAMBAHAN, B.NOMOR_SURAT, dbo.PETUGAS_SAMPLING(A.PERIKSA_SAMPEL) AS PETUGAS_SAMPLING, A.CATATAN, A.UJI_KIMIA, A.UJI_MIKRO, B.NAMA_PENGIRIM, B.NIP_PENGIRIM FROM T_PERIKSA_SAMPEL B LEFT JOIN T_M_SAMPEL A  ON A.PERIKSA_SAMPEL = B.PERIKSA_SAMPEL WHERE A.SPU_ID= '".$spuid."' ORDER BY A.KODE_SAMPEL ASC";
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
								<td class="'.$grs.' '.$class.'">'.$dt['KOMPOSISI'].'</td>
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
					  <tr><td></td><td>&nbsp;</td><td>Ka. PPOMN</td></tr>
					  <tr><td height="75">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
					  <tr><td></td><td>NIP.</td><td>NIP. </td></tr></table>';
			}else{
				$kabid = explode("|", $sipt->main->get_uraian("SELECT A.NAMA_USER +'|'+ A.USER_ID +'|'+ CONVERT(VARCHAR(10), B.TANGGAL_KIRIM, 103) AS KABID FROM T_USER A LEFT JOIN T_SPU B ON A.USER_ID = B.TTD_PEMDIK WHERE SPU_ID = '".$spuid."'","KABID"));
				$ma = explode("|", $sipt->main->get_uraian("SELECT A.NAMA_USER +'|'+ A.USER_ID +'|'+ CONVERT(VARCHAR(10), B.TANGGAL_TERIMA_TPS, 103)  AS MA FROM T_USER A LEFT JOIN T_SPU B ON A.USER_ID = B.TTD_MA WHERE SPU_ID = '".$spuid."'","MA"));
				$mp = explode("|", $sipt->main->get_uraian("SELECT A.NAMA_USER +'|'+ A.USER_ID  +'|'+ CONVERT(VARCHAR(10), B.TANGGAL_PERINTAH, 103) AS MP FROM T_USER A LEFT JOIN T_SPU B ON A.USER_ID = B.TTD_MP WHERE SPU_ID = '".$spuid."'","MP"));
				$html .= '<table width="100%">
					  <tr><td width="33%">&nbsp;</td><td width="33%">Tanggal, '.$ma[2].'</td><td width="33%">Tanggal, '.$mp[2].'</td></tr>
					  <tr><td>&nbsp;</td><td>Penerima Sampel</td><td>Mengetahui </td></tr>
					  <tr><td>Pemohon / Pengirim Sampel</td><td>&nbsp;</td><td>Ka. PPOMN</td></tr>
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
							  <tr><td>Komposisi</td><td class="kotak">'.$sess[$i]['KOMPOSISI'].'</td><td>Catatan</td><td class="kotak">'.$sess[$i]['CATATAN'].'</td></tr>
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
	
	function sps($spuid){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$this->load->library('mpdf');
			$arr_header = $this->db->query("SELECT dbo.FORMAT_NOMOR('SPU',SPU_ID) AS SPU, dbo.FORMAT_NOMOR('SPS',NOMOR_SPS) AS SPS, dbo.FORMAT_NOMOR('SP',NOMOR_SP) AS SP, dbo.URAIAN_M_TABEL('ASAL_SAMPLING', ASAL_SAMPEL) AS ASAL, dbo.URAIAN_M_TABEL('ANGGARAN_SAMPLING', SUBSTRING(SPU_ID, 7,2)) AS ANGGARAN, dbo.KATEGORI(SUBSTRING(SPU_ID, 13,2),'0') AS KOMODITI, CONVERT(VARCHAR(10), TANGGAL_PERINTAH, 103) AS TANGGAL_PERINTAH FROM T_SPU WHERE SPU_ID = '".$spuid."'")->result_array();
			$kbalai = explode("|",$sipt->main->get_uraian("SELECT USER_ID +'|'+ NAMA_USER AS NAMA FROM T_USER WHERE USER_ID
IN(SELECT USER_ID FROM T_USER_ROLE WHERE ROLE IN('6')) AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND STATUS = 'Aktif'","NAMA"));
			$chk_uji = $this->db->query("SELECT SUM(CASE WHEN UJI_KIMIA = '1' THEN 1 ELSE 0 END) AS KIMIA, SUM(CASE WHEN UJI_MIKRO = '1' THEN 1 ELSE 0 END) AS MIKRO FROM T_M_SAMPEL WHERE SPU_ID = '".$spuid."'")->result_array();
			
			$html = "";
			//------------------------------------------- Surat Perintah Uji ----------------------------------
			$qmt = "SELECT DISTINCT B.NAMA_USER, B.JABATAN FROM T_SAMPEL_MT A LEFT JOIN T_USER B ON A.USER_ID = B.USER_ID WHERE A.SPU_ID = '".$spuid."'";
			$resmt = $sipt->main->get_result($qmt);
			if($resmt){
				foreach($qmt->result_array() as $rowmt){
					$html .= '<div class="judul">Surat Perintah Uji</div>';
					$html .= '<div class="judul">'.$arr_header[0]['SP'].'</div>';
					$html .= '<div style="height:10px;">&nbsp;</div>';
					$html .= '<div>Kepada Yth,</div>';
					$html .= '<div style="height:10px;">&nbsp;</div>';
					$html .= '<div></div>';
					$html .= '<div>'.$rowmt['NAMA_USER'].'</div>';
					$html .= '<div>'.$rowmt['JABATAN'].'</div>';
					$html .= '<div>'.$sipt->main->get_uraian("SELECT NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."'","NAMA_BBPOM").'</div>';
					$html .= '<div style="height:10px;">&nbsp;</div>';
					$html .= '<p>Bersama ini disampaikan sampel untuk dilakukan Pengujian dengan daftar terlampir</p><p>Setelah mendapatkan surat perintah ini agar Saudara melakukan pengujian dan segera melaporkan hasilnya</p>';
					$html .= '<div style="height:20px;">&nbsp;</div>';
					$html .= '<center><table width="100%">
							  <tr><td width="50%">&nbsp;</td><td width="50%">Tanggal, '.$arr_header[0]['TANGGAL_PERINTAH'].'</td></tr>
							  <tr><td></td><td>Ka. PPOMN</td></tr>
							  <tr><td height="75">&nbsp;</td><td>&nbsp;</td></tr>
							  <tr><td></td><td>'.$kbalai[1].'</td></tr>
							  <tr><td></td><td>NIP. '.$kbalai[0].'</td></tr></table></center>';
					//$html .= '<pagebreak sheet-size="210mm 330mm"/>';
					
					$html .= '<div style="height:10000px;">&nbsp;</div>';
				}
			}
			
			//------------------------------------------- Penyerahan Sampel Kimia -----------------------------
			if($chk_uji[0]['KIMIA'] > 0){
				$html .= '<pagebreak sheet-size="330mm 210mm"/>';
				$html .= '<div class="judul">Lampiran Penyerahan Sampel Kimia</div>';
				$html .= '<div class="judul">'.$arr_header[0]['SPS'].'</div>';
				$html .= '<div style="height:5px;">&nbsp;</div>';
				$html .= '<p>Sesuai Surat Permintaan Uji No : '.$arr_header[0]['SPU'].' bersama ini disampaikan sampel ('.$arr_header[0]['KOMODITI'].') sebagai berikut : </p>';
				$html .= '<div>&nbsp;</div>';	
				$kimia = "SELECT dbo.FORMAT_NOMOR('SPL', A.KODE_SAMPEL) AS KODE, A.NAMA_SAMPEL, A.NOMOR_REGISTRASI, A.BENTUK_SEDIAAN, A.PABRIK,
						  A.IMPORTIR, dbo.KATEGORI(A.KOMODITI,A.PRIORITAS) AS KOMODITI, dbo.KATEGORI(A.KATEGORI,A.PRIORITAS) AS KATEGORI, A.KOMPOSISI,
						  A.KEMASAN, A.KETERANGAN_ED, A.NO_BETS, A.NETTO, A.TEMPAT_SAMPLING, CONVERT(VARCHAR(10), A.TANGGAL_SAMPLING, 103) AS TANGGAL_SAMPLING, A.JUMLAH_SAMPEL, A.JUMLAH_KIMIA, A.JUMLAH_MIKRO, A.SISA, A.EVALUASI_PENANDAAN, A.KETERANGAN_ED, A.CARA_PENYIMPANAN, 
						  A.KONDISI_SAMPEL, A.KLASIFIKASI_TAMBAHAN, B.NOMOR_SURAT, A.CATATAN, A.UJI_KIMIA, A.UJI_MIKRO
						  FROM T_PERIKSA_SAMPEL B LEFT JOIN T_M_SAMPEL A  ON A.PERIKSA_SAMPEL = B.PERIKSA_SAMPEL WHERE A.SPU_ID= '".$spuid."'
						  AND A.UJI_KIMIA = '1' AND A.STATUS_SAMPEL NOT IN ('00000') ORDER BY A.KODE_SAMPEL ASC";
				$res_kimia = $sipt->main->get_result($kimia);
				if($res_kimia){
					$html .= '<table width="100%" class="tablepdf" id="tablepdf" >
						  <tr>
							<th class="header rows left" width="1%">No.</th>
							<th class="header" >Kode Sampel</th>
							<th class="header" colspan="3">Identitas Sampel</th>
							<th class="header">Keterangan Sampling</th>
							<th class="header">Jumlah Sampel</th>
							<th class="header">Keterangan Tambahan</th>
							<th class="header">Anggaran & <br> Nomor Surat Tugas</th>
							<th class="header">Catatan</th>
						  </tr>';
					  $grs="alt2";
					  $class="left";
					  $no = 1;
					  foreach($kimia->result_array() as $row_kimia){
						  $html .= '<tr>
									<td class="'.$grs.' '.$class.'">'.$no.'</td>
									<td class="'.$grs.' '.$class.'">'.$row_kimia['KODE'].'</td>
									<td class="'.$grs.' '.$class.'"><div class="uline">'.$row_kimia['NAMA_SAMPEL'].'</div><div class="uline">&bull; '.$row_kimia['NOMOR_REGISTRASI'].'</div><div class="uline">&bull; '.$row_kimia['BENTUK_SEDIAAN'].'</div><div class="uline">&bull; '.$row_kimia['KOMODITI'].'</div><div class="uline">'.$row_kimia['KATEGORI'].'</div><div class="uline">&bull; '.$row_kimia['PABRIK'].'</div><div class="uline">&bull; '.$row_kimia['IMPORTIR'].'</div></td>
									<td class="'.$grs.' '.$class.'">'.preg_replace('/[^(\x20-\x7F)]*/','',$sipt->main->clean_tags($row_kimia['KOMPOSISI'])).'</td>
									<td class="'.$grs.' '.$class.'">'.$row_kimia['KEMASAN'].'</td>
									<td class="'.$grs.' '.$class.'"><div class="uline">&bull; '.$row_kimia['TEMPAT_SAMPLING'].'</div><div class="uline">&bull; '.$row_kimia['TANGGAL_SAMPLING'].'</div></td>
									<td class="'.$grs.' '.$class.'">'.$row_kimia['JUMLAH_KIMIA'].'</td>
									<td class="'.$grs.' '.$class.'">'.$row_kimia['EVALUASI_PENANDAAN'].'<div class="uline">&bull; '.$row_kimia['KETERANGAN_ED'].'</div></td>
									<td class="'.$grs.' '.$class.'">'.$arr_header[0]['ANGGARAN'].'<div>'.$row_kimia['NOMOR_SURAT'].'</div></td>
									<td class="'.$grs.' right">'.$row_kimia['CATATAN'].'</td>
								  </tr>';
								  $no++;
					  }
					  $html .= '</table>';
					  /*if((($no+1) % 3) == 0) {
						  $html .= '<pagebreak />';
					  }*/
				}else{
					$html .= '<table width="100%" class="tablepdf" id="tablepdf" >
						  <tr>
							<th class="header rows left" width="1%">No.</th>
							<th class="header" >Kode Sampel</th>
							<th class="header" colspan="3">Identitas Sampel</th>
							<th class="header">Keterangan Sampling</th>
							<th class="header">Jumlah Sampel</th>
							<th class="header">Keterangan Tambahan</th>
							<th class="header">Anggaran & <br> Nomor Surat Tugas</th>
							<th class="header">Catatan</th>
						  </tr>';
					$html .= '<tr><td colspan="13" class="'.$grs.' right">Tidak ada data untuk no SPU : '.$spuid.'</td></tr></table>';
				}
			}
			//--------------------------- Akhir Penyerahan Sampel Kimia ----------------------------------------------
			
			if($chk_uji['0']['MIKRO'] > 0){
				$html .= '<pagebreak sheet-size="330mm 210mm"/>';
				$html .= '<div class="judul">Lampiran Penyerahan Sampel Mikro</div>';
				$html .= '<div class="judul">'.$arr_header[0]['SPS'].'</div>';
				$html .= '<div style="height:5px;">&nbsp;</div>';
				$html .= '<p>Sesuai Surat Permintaan Uji No : '.$arr_header[0]['SPU'].' bersama ini disampaikan sampel ('.$arr_header[0]['KOMODITI'].') sebagai berikut : </p>';
				$html .= '<div>&nbsp;</div>';	
				$kimia = "SELECT dbo.FORMAT_NOMOR('SPL', A.KODE_SAMPEL) AS KODE, A.NAMA_SAMPEL, A.NOMOR_REGISTRASI, A.BENTUK_SEDIAAN, A.PABRIK,
						  A.IMPORTIR, dbo.KATEGORI(A.KOMODITI,A.PRIORITAS) AS KOMODITI, dbo.KATEGORI(A.KATEGORI,A.PRIORITAS) AS KATEGORI, A.KOMPOSISI,
						  A.KEMASAN, A.KETERANGAN_ED, A.NO_BETS, A.NETTO, A.TEMPAT_SAMPLING, CONVERT(VARCHAR(10), A.TANGGAL_SAMPLING, 103) AS TANGGAL_SAMPLING, A.JUMLAH_SAMPEL, A.JUMLAH_KIMIA, A.JUMLAH_MIKRO, A.SISA, A.EVALUASI_PENANDAAN, A.KETERANGAN_ED, A.CARA_PENYIMPANAN, 
						  A.KONDISI_SAMPEL, A.KLASIFIKASI_TAMBAHAN, B.NOMOR_SURAT, A.CATATAN, A.UJI_KIMIA, A.UJI_MIKRO
						  FROM T_PERIKSA_SAMPEL B LEFT JOIN T_M_SAMPEL A  ON A.PERIKSA_SAMPEL = B.PERIKSA_SAMPEL WHERE A.SPU_ID= '".$spuid."'
						  AND A.UJI_MIKRO = '1' AND A.STATUS_SAMPEL NOT IN ('00000') ORDER BY A.KODE_SAMPEL ASC";		  
				$res_kimia = $sipt->main->get_result($kimia);
				if($res_kimia){
					$html .= '<table width="100%" class="tablepdf" id="tablepdf" >
						  <tr>
							<th class="header rows left" width="1%">No.</th>
							<th class="header" >Kode Sampel</th>
							<th class="header" colspan="3">Identitas Sampel</th>
							<th class="header">Keterangan Sampling</th>
							<th class="header">Jumlah Sampel</th>
							<th class="header">Keterangan Tambahan</th>
							<th class="header">Anggaran & <br> Nomor Surat Tugas</th>
							<th class="header">Catatan</th>
						  </tr>';
					  $grs="alt2";
					  $class="left";
					  $no = 1;
					  foreach($kimia->result_array() as $row_kimia){
						  $html .= '<tr>
									<td class="'.$grs.' '.$class.'">'.$no.'</td>
									<td class="'.$grs.' '.$class.'">'.$row_kimia['KODE'].'</td>
									<td class="'.$grs.' '.$class.'"><div class="uline">'.$row_kimia['NAMA_SAMPEL'].'</div><div class="uline">&bull; '.$row_kimia['NOMOR_REGISTRASI'].'</div><div class="uline">&bull; '.$row_kimia['BENTUK_SEDIAAN'].'</div><div class="uline">&bull; '.$row_kimia['KOMODITI'].'</div><div class="uline">'.$row_kimia['KATEGORI'].'</div><div class="uline">&bull; '.$row_kimia['PABRIK'].'</div><div class="uline">&bull; '.$row_kimia['IMPORTIR'].'</div></td>
									<td class="'.$grs.' '.$class.'">'.preg_replace('/[^(\x20-\x7F)]*/','',$sipt->main->clean_tags($row_kimia['KOMPOSISI'])).'</td>
									<td class="'.$grs.' '.$class.'">'.$row_kimia['KEMASAN'].'</td>
									<td class="'.$grs.' '.$class.'"><div class="uline">&bull; '.$row_kimia['TEMPAT_SAMPLING'].'</div><div class="uline">&bull; '.$row_kimia['TANGGAL_SAMPLING'].'</div></td>
									<td class="'.$grs.' '.$class.'">'.$row_kimia['JUMLAH_MIKRO'].'</td>
									<td class="'.$grs.' '.$class.'">'.$row_kimia['EVALUASI_PENANDAAN'].'<div class="uline">&bull; '.$row_kimia['KETERANGAN_ED'].'</div></td>
									<td class="'.$grs.' '.$class.'">'.$arr_header[0]['ANGGARAN'].'<div>'.$row_kimia['NOMOR_SURAT'].'</div></td>
									<td class="'.$grs.' right">'.$row_kimia['CATATAN'].'</td>
								  </tr>';
								  $no++;
					  }
					  $html .= '</table>';
					  /*if((($no+1) % 3) == 0) {
						  $html .= '<pagebreak />';
					  }*/
				}else{
					$html .= '<table width="100%" class="tablepdf" id="tablepdf" >
						  <tr>
							<th class="header rows left" width="1%">No.</th>
							<th class="header" >Kode Sampel</th>
							<th class="header" colspan="3">Identitas Sampel</th>
							<th class="header">Keterangan Sampling</th>
							<th class="header">Jumlah Sampel</th>
							<th class="header">Keterangan Tambahan</th>
							<th class="header">Anggaran & <br> Nomor Surat Tugas</th>
							<th class="header">Catatan</th>
						  </tr>';
					$html .= '<tr><td colspan="12" class="'.$grs.' right">Tidak ada data untuk no SPU : '.$spuid.'</td></tr></table>';
				}
			}
			//--------------------------- Akhir Penyerahan Sampel Mikro ----------------------------------------------

			$mpdf=new mPDF('utf-8', array(210,330),10,10,10,10,10,10);
			$stylesheet = file_get_contents('css/mpdf.css');
			$mpdf->mirrorMargins = 1;
			$mpdf->WriteHTML($stylesheet,1);
			$mpdf->WriteHTML($html);
			$mpdf->Output();
			exit;
		}
	}
	
	function spk($id){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$this->load->library('mpdf');
			$chk = explode(",", $id);
			$idx = count($chk);
			$html = "";
			$page = 1;
			for($x = 0; $x < $idx; $x++){
				$arrheader = $this->db->query("SELECT dbo.FORMAT_NOMOR('SPK', A.SPK_ID) AS UR_SPK, dbo.FORMAT_NOMOR('SPU',A.SPU_ID) AS SPU, A.SPK_ID,
CONVERT(VARCHAR(10), A.TANGGAL, 103) AS TANGGAL, B.NAMA_USER, B.USER_ID, B.JABATAN, C.KOTA FROM T_SPK A LEFT JOIN T_USER B ON A.CREATE_BY = B.USER_ID LEFT JOIN M_BBPOM C ON A.BBPOM_ID = C.BBPOM_ID WHERE A.SPK_ID IN (SELECT SPK_ID FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL = '".$chk[$x]."') AND A.CREATE_BY = '".$this->newsession->userdata('SESS_USER_ID')."'")->result_array();
				$q = "SELECT B.NAMA_USER FROM T_SPK A LEFT JOIN T_USER B ON A.KASIE = B.USER_ID WHERE A.SPK_ID = '".$arrheader[0]['SPK_ID']."' AND CREATE_BY = '".$this->newsession->userdata('SESS_USER_ID')."' AND KODE_SAMPEL = '".$chk[$x]."'"; 
				$dt = $sipt->main->get_result($q);
				if($dt){
					foreach($q->result_array() as $rq){
						$arrp[$x][] = $rq;
					}
				}else{
					$arrp[$x] = array();
				}
				$html .= '<div class="judul">SURAT PERINTAH KERJA</div>';
				$html .= '<div class="judul">Nomor : '.$arrheader[0]['UR_SPK'].'</div>';
				$html .= '<div style="height:10px;">&nbsp;</div>';
				$html .= '<div>Kepada Yth,</div>';
				$jml = count($arrp[$x]);
				if($jml > 0){
					for($i=0; $i<$jml; $i++){
						$html .= '<div> - '.$arrp[$x][$i]['NAMA_USER'].'</div>';
					}
				}
				$html .= '<p>Bersama ini dikirim sampel untuk dilakukan pengujian, sesuai Surat Perintah Uji Nomor : '.$arrheader[0]['SPU'].'</p>';
				if(in_array('B1',$this->newsession->userdata('SESS_SUB_SARANA')) || in_array('B2',$this->newsession->userdata('SESS_SUB_SARANA')) || in_array('B3',$this->newsession->userdata('SESS_SUB_SARANA')) || in_array('B4',$this->newsession->userdata('SESS_SUB_SARANA'))){
					$query = "SELECT dbo.FORMAT_NOMOR('SPL', A.KODE_SAMPEL) AS KODE, A.NAMA_SAMPEL, A.BENTUK_SEDIAAN, B.PARAMETER_UJI, B.METODE, B.PUSTAKA, B.SYARAT FROM T_M_SAMPEL A LEFT JOIN T_PARAMETER_HASIL_UJI B ON A.KODE_SAMPEL = B.KODE_SAMPEL WHERE B.JENIS_UJI = '02' AND B.SPK_ID = '".$arrheader[0]['SPK_ID']."'";
				}else if(in_array('B5',$this->newsession->userdata('SESS_SUB_SARANA'))){
					$query = "SELECT dbo.FORMAT_NOMOR('SPL', A.KODE_SAMPEL) AS KODE, A.NAMA_SAMPEL, A.BENTUK_SEDIAAN, B.PARAMETER_UJI, B.METODE, B.PUSTAKA, B.SYARAT FROM T_M_SAMPEL A LEFT JOIN T_PARAMETER_HASIL_UJI B ON A.KODE_SAMPEL = B.KODE_SAMPEL WHERE B.JENIS_UJI = '01' AND B.SPK_ID = '".$arrheader[0]['SPK_ID']."'";
				}
				$data = $sipt->main->get_result($query);
				$html .= '<table width="100%" class="tablepdf" id="tablepdf" >
						  <tr>
							<th class="header">Kode Sampel</th>
							<th class="header">Nama Sampel</th>
							<th class="header">Bentuk Sediaan</th>
							<th class="header">Parameter Uji</th>
							<th class="header">Metode</th>
							<th class="header">Pustaka</th>
							<th class="header">Syarat</th>
						  </tr>';
				if($data){
					  $grs="alt2";
					  $class="left";
					  $no = 1;
					  $kode = "";
					  $nama = "";
					  $bentuk = "";
					  foreach($query->result_array() as $row){
						  $html .= '<tr><td class="'.$grs.' '.$class.'">';
									if($row['KODE'] != $kode){
										$html .= $row['KODE'];
									}
						  $html .= '</td><td class="'.$grs.' '.$class.'">';
									if($row['NAMA_SAMPEL'] != $nama){
										$html .= $row['NAMA_SAMPEL'];
									}
						  $html .= '</td><td class="'.$grs.' '.$class.'">';
									if($row['BENTUK_SEDIAAN'] != $bentuk){
										$html .= $row['BENTUK_SEDIAAN'];
									}
						  $html .= '</td>
									<td class="'.$grs.' '.$class.'">'.$row['PARAMETER_UJI'].'</td>
									<td class="'.$grs.' '.$class.'">'.$row['METODE'].'</td>
									<td class="'.$grs.' '.$class.'">'.$row['PUSTAKA'].'</td>
									<td class="'.$grs.' right">'.$row['SYARAT'].'</td>';
						  $html .= '</tr>';
						  $kode = $row['KODE'];
						  $nama = $row['NAMA_SAMPEL'];
						  $bentuk = $row['BENTUK_SEDIAAN'];
						  $no++;
					  }
				}else{
					$html .= '<tr><td colspan="7" class="'.$grs.'">Tidak ada data untuk no SPU : '.$arrheader[0]['SPU'].'</td></tr>';
				}
				$html .= '</table>';
				
				$html .= '<p>Hasil pengujian agar segera dilaporkan. Atas kerjasamanya, diucapkan terima kasih.';
				$html .= '<table width="100%">
						  <tr><td width="70%">&nbsp;</td><td width="30%">'.$arrheader[0]['KOTA'].', '.$arrheader[0]['TANGGAL'].'</td></tr>
						  <tr><td>&nbsp;</td><td>'.$arrheader[0]['JABATAN'].'</td></tr>
						  <tr><td height="75" valign="top">&nbsp;</td><td valign="top"></td></tr>
						  <tr><td>&nbsp;</td><td>'.$arrheader[0]['NAMA_USER'].'</td></tr>
						  <tr><td>&nbsp;</td><td>NIP. '.$arrheader[0]['USER_ID'].'</td></tr>
						  </table>';
				$page++;
				if($page <= $idx){		  
					$html .= '<pagebreak sheet-size="330mm 210mm" />';		  
				}
			}
			$mpdf=new mPDF('utf-8', array(330,210),10,10,10,10,10,10);
			$stylesheet = file_get_contents('css/mpdf.css');
			$mpdf->mirrorMargins = 1;
			$mpdf->WriteHTML($stylesheet,1);
			$mpdf->WriteHTML($html);
			$mpdf->Output();
			exit;
		}
	}

	function spp($id){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$this->load->library('mpdf');
			$dataspk = $this->db->query("SELECT CONVERT(VARCHAR(10), A.TANGGAL, 103) AS TANGGAL_SPK, B.NAMA_USER, B.USER_ID, B.JABATAN AS PENYELIA, C.KOTA, dbo.FORMAT_NOMOR('SPK', A.SPK_ID) AS NOMOR_SPK, dbo.FORMAT_NOMOR('SPP', D.SPP_ID) AS NOMOR_SPP, CONVERT(VARCHAR(10), D.TANGGAL, 103) AS TANGGAL_SPP FROM T_SPK A LEFT JOIN T_USER B ON A.KASIE = B.USER_ID LEFT JOIN M_BBPOM C ON B.BBPOM_ID = C.BBPOM_ID LEFT JOIN T_SPP D ON A.SPK_ID = D.SPK_ID WHERE A.SPK_ID = '".$id."'")->result_array();
			$html = "";
			$html .= '<div class="judul">Surat Perintah Pengujian</div>';
			$html .= '<div class="judul">Nomor : '.$dataspk[0]['NOMOR_SPP'].'</div>';
			$html .= '<div>&nbsp;</div>';
			$html .= '<div>Kepada Yth. : </div>';
			$penguji = $this->db->query("SELECT A.NAMA_USER FROM T_USER A LEFT JOIN T_PARAMETER_HASIL_UJI B ON A.USER_ID = B.PENGUJI WHERE B.SPK_ID = '".$id."' GROUP BY A.NAMA_USER")->result_array();
			$jpenguji = count($penguji);
			if($jpenguji > 0){
				for($i=0; $i<$jpenguji; $i++){
					$html .= '<div> - '.$penguji[$i]['NAMA_USER'].'</div>';
				}
			}
			$html .= '<div>&nbsp;</div>';
			$html .= '<div>Berdasarkan Nomor Surat Perintah Kerja '.$dataspk[0]['NOMOR_SPK'].' tertanggal '.$dataspk[0]['TANGGAL_SPK'].'</div>';
			$html .= '<p>Agar dilakukan pengujian terhadap sampel berikut : </p>';
			if(in_array('B1',$this->newsession->userdata('SESS_SUB_SARANA')) || in_array('B2',$this->newsession->userdata('SESS_SUB_SARANA')) || in_array('B3',$this->newsession->userdata('SESS_SUB_SARANA')) || in_array('B4',$this->newsession->userdata('SESS_SUB_SARANA'))){
				$query = "SELECT dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) AS KODE_SAMPEL, A.PARAMETER_UJI, A.METODE, A.PUSTAKA, A.SYARAT, A.RUANG_LINGKUP, B.NAMA_SAMPEL, B.NOMOR_REGISTRASI, B.NO_BETS, B.BENTUK_SEDIAAN, B.KEMASAN,B.KOMPOSISI, B.KETERANGAN_ED, dbo.KATEGORI(B.KOMODITI,B.PRIORITAS) AS KOMODITI, dbo.KATEGORI(B.KATEGORI,B.PRIORITAS) AS KATEGORI, C.NAMA_USER AS PENGUJI FROM T_PARAMETER_HASIL_UJI A LEFT JOIN T_M_SAMPEL B ON A.KODE_SAMPEL = B.KODE_SAMPEL LEFT JOIN T_USER C ON A.PENGUJI = C.USER_ID WHERE A.SPK_ID = '".$id."' AND A.JENIS_UJI = '02'";
			}else if(in_array('B5',$this->newsession->userdata('SESS_SUB_SARANA'))){
				$query = "SELECT dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) AS KODE_SAMPEL, A.PARAMETER_UJI, A.METODE, A.PUSTAKA, A.SYARAT, A.RUANG_LINGKUP, B.NAMA_SAMPEL, B.NOMOR_REGISTRASI, B.NO_BETS, B.BENTUK_SEDIAAN, B.KEMASAN, B.KOMPOSISI, B.KETERANGAN_ED, dbo.KATEGORI(B.KOMODITI,B.PRIORITAS) AS KOMODITI, dbo.KATEGORI(B.KATEGORI,B.PRIORITAS) AS KATEGORI, C.NAMA_USER AS PENGUJI FROM T_PARAMETER_HASIL_UJI A LEFT JOIN T_M_SAMPEL B ON A.KODE_SAMPEL = B.KODE_SAMPEL LEFT JOIN T_USER C ON A.PENGUJI = C.USER_ID WHERE A.SPK_ID = '".$id."' AND A.JENIS_UJI = '01'";
			}
			$data = $sipt->main->get_result($query);
			$html .= '<table width="100%" class="tablepdf" id="tablepdf" >
					  <tr>
						<th class="header rows left" width="1%">No.</th>
						<th class="header"><div>Nama Sampel</div><div>Kode Sampel</div><div>No. Reg</div><div>No Batch</div></th>
						<th class="header"><div>Bentuk</div><div>Kemasan</div><div>Komposisi</div></th>
						<th class="header"><div>Komoditi</div><div>Keterangan ED</div></th>
						<th class="header">Parameter Pengujian</th>
						<th class="header"><div>Metode</div><div>Pustaka</div></th>
						<th class="header">Syarat</th>
					  </tr>';
			if($data){
				  $grs="alt2";
				  $class="";
				  $no = 1;
				  $kode = "";
				  $bentuk = "";
				  $komoditi = "";
				  foreach($query->result_array() as $row){
					  $html .= '<tr><td class="'.$grs.'">';
								if($row['KODE_SAMPEL'] != $kode){
					  $html .= 		$no;
									$no++;
								}
					  $html .= '</td><td class="'.$grs.' '.$class.'">';
								if($row['KODE_SAMPEL'] != $kode){
									$html .= '<div>'.$row['NAMA_SAMPEL'].'</div><div>'.$row['KODE_SAMPEL'].'</div><div>'.$row['NOMOR_REGISTRASI'].'</div><div>'.$row['NO_BETS'].'</div>';
								}
								
					  $html .= '</td><td class="'.$grs.' '.$class.'">';
					  			//if($row['BENTUK_SEDIAAN'] != $bentuk){
					  				$html .= '<div>'.$row['BENTUK_SEDIAAN'].'</div><div>'.$row['KEMASAN'].'</div><div>'.$row['KOMPOSISI'].'</div>';
								//}
					  $html .= '</td><td class="'.$grs.' '.$class.'">';
					  			//if($row['KOMODITI'] != $komoditi){
					  				$html .= '<div>'.$row['KOMODITI'].'</div><div>'.$row['KETERANGAN_ED'].'<div>';
								//}
					  $html .= '</td><td class="'.$grs.' '.$class.'"><div>'.$row['PARAMETER_UJI'].'</div><div>'.$row['RUANG_LINGKUP'].'</div></td>
								<td class="'.$grs.' '.$class.'"><div>'.$row['METODE'].'</div><div>'.$row['PUSTAKA'].'</div></td>
								<td class="'.$grs.' '.$class.'">'.$row['SYARAT'].'</td>';
								
					  $html .= '</tr>';
					  $kode = $row['KODE_SAMPEL'];
					  $bentuk = $row['BENTUK_SEDIAAN'];
					  $komoditi = $row['KOMODITI'];
				  }
			}else{
				$html .= '<tr><td colspan="7" class="'.$grs.'">Tidak ada data</td></tr>';
			}
			$html .= '</table>';
			$html .= '<p>&nbsp;</p>';
			$html .= '<table width="100%">
					  <tr><td width="70%">&nbsp;</td><td width="30%">'.$dataspk[0]['KOTA'].', '.$dataspk[0]['TANGGAL_SPP'].'</td></tr>
					  <tr><td width="70%">&nbsp;</td><td>'.$dataspk[0]['JABATAN'].'</td></tr>
					  <tr><td width="70%">&nbsp;</td><td height="75">&nbsp;</td></tr>
					  <tr><td width="70%">&nbsp;</td><td>'.$dataspk[0]['NAMA_USER'].'</td></tr>
					  <tr><td width="70%">&nbsp;</td><td>NIP. '.$dataspk[0]['USER_ID'].'</td></tr>
					  </table>';
			$mpdf=new mPDF('utf-8', array(330,210),10,10,10,10,10,10);
			$stylesheet = file_get_contents('css/mpdf.css');
			$mpdf->mirrorMargins = 1;
			$mpdf->WriteHTML($stylesheet,1);
			$mpdf->WriteHTML($html);
			$mpdf->Output();
			exit;
		}
	}
	
	function cp($id){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$this->load->library('mpdf');
			$arr_sampel = $this->db->query("SELECT A.NAMA_SAMPEL, A.KODE_SAMPEL, dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) AS KODE, A.TEMPAT_SAMPLING, CONVERT(VARCHAR(10), A.TANGGAL_SAMPLING, 103) AS TANGGAL_SAMPLING, A.ALAMAT_SAMPLING, A.NOMOR_REGISTRASI, A.PABRIK, A.IMPORTIR, A.KEMASAN, A.BENTUK_SEDIAAN, A.NO_BETS, dbo.KATEGORI(A.KOMODITI,A.PRIORITAS) AS KOMODITI, dbo.KATEGORI(A.KATEGORI,A.PRIORITAS) AS KATEGORI, A.SATUAN, A.KETERANGAN_ED, A.JUMLAH_KIMIA, A.JUMLAH_MIKRO, A.SISA_MIKRO, A.SISA_KIMIA, A.TEMPAT_SISA_MIKRO, A.TEMPAT_SISA_KIMIA, A.HASIL_MIKRO, A.HASIL_KIMIA, REPLACE(A.KOMPOSISI,';','<br>') AS KOMPOSISI, A.NETTO, A.PEMERIAN, B.NOMOR_SURAT, CONVERT(VARCHAR(10), B.TANGGAL_SURAT, 103) AS TANGGAL_SURAT, B.NAMA_PENGIRIM, CONVERT(VARCHAR(10), C.TANGGAL_TERIMA_TPS, 103) AS TANGGAL_TERIMA_TPS, A.LABEL, A.SEGEL FROM T_M_SAMPEL A LEFT JOIN T_PERIKSA_SAMPEL B ON A.PERIKSA_SAMPEL = B.PERIKSA_SAMPEL LEFT JOIN T_SPU C ON A.SPU_ID = C.SPU_ID WHERE A.KODE_SAMPEL = '".$id."'")->result_array();
			$arr_tanggal  = $this->db->query("SELECT MIN(CONVERT(VARCHAR(10), AWAL_UJI, 103)) AS MINTGL, MAX(CONVERT(VARCHAR(10), AKHIR_UJI, 103)) AS MAXTGL FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL = '".$id."'")->result_array();		
			
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
					  </tr>
					  <tr>
						<td class="alt2 left">&nbsp;</td>
						<td class="alt2 left">'.$arr_tanggal[0]['MINTGL'].'</td>
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
						<td class="rights">'.$arr_sampel[0]['KOMPOSISI'].'</td>
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
			if(in_array('B1',$this->newsession->userdata('SESS_SUB_SARANA')) || in_array('B2',$this->newsession->userdata('SESS_SUB_SARANA')) || in_array('B3',$this->newsession->userdata('SESS_SUB_SARANA')) || in_array('B4',$this->newsession->userdata('SESS_SUB_SARANA'))){#Bidang Kimia Fisika
				$parameter = $this->db->query("SELECT SPK_ID, PARAMETER_UJI, METODE, PUSTAKA, SYARAT, RUANG_LINGKUP, HASIL, HASIL_KUALITATIF, LCP FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL = '".$id."' AND JENIS_UJI = '02'")->result_array();
			}else if(in_array('B5',$this->newsession->userdata('SESS_SUB_SARANA'))){#Bidang Mikro
				$parameter =  $this->db->query("SELECT SPK_ID, PARAMETER_UJI, METODE, PUSTAKA, SYARAT, RUANG_LINGKUP, HASIL, HASIL_KUALITATIF, LCP FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL = '".$id."' AND JENIS_UJI = '01'")->result_array();
			}
			
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
						if(in_array('B5',$this->newsession->userdata('SESS_SUB_SARANA'))){
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
						<td width="47%" class="rights">Tanggal dilaporkan penguji : '.$arr_tanggal[0]['MAXTGL'].'</td>
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
	
	function lhu($id){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$this->load->library('mpdf');
			$arrid = explode(".",$id);
			$nomor = "";
			$html = "";
			$html .= '<div style="font-size:11pt; font-weight:bold; text-align:center; font-family:Times New Roman;">LAPORAN PENGUJIAN</div>';
			$html .= '<div style="font-size:11pt; text-align:center; font-family:Times New Roman;">Nomor : '.$nomor.'</div>';
			$arr_sampel = $this->db->query("SELECT A.NAMA_SAMPEL, A.KODE_SAMPEL, dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) AS KODE, dbo.FORMAT_NOMOR('SPU',C.SPU_ID) AS SPU, A.TEMPAT_SAMPLING, CONVERT(VARCHAR(10), A.TANGGAL_SAMPLING, 103) AS TANGGAL_SAMPLING, A.ALAMAT_SAMPLING, A.NOMOR_REGISTRASI, A.PABRIK, A.IMPORTIR, A.KEMASAN, A.BENTUK_SEDIAAN, A.NO_BETS, A.SATUAN, dbo.KATEGORI(A.KOMODITI,A.PRIORITAS) AS KOMODITI, dbo.KATEGORI(A.KATEGORI,A.PRIORITAS) AS KATEGORI, A.KETERANGAN_ED, A.JUMLAH_KIMIA, A.JUMLAH_MIKRO, REPLACE(A.KOMPOSISI,';','<br>') AS KOMPOSISI, A.NETTO, A.PEMERIAN, B.NOMOR_SURAT, CONVERT(VARCHAR(10), B.TANGGAL_SURAT, 103) AS TANGGAL_SURAT, B.NAMA_PENGIRIM, CONVERT(VARCHAR(10), C.TANGGAL_TERIMA_TPS, 103) AS TANGGAL_TERIMA_TPS, CONVERT(VARCHAR(10), C.TANGGAL, 103) AS TANGGAL_SPU, A.JUMLAH_KIMIA, A.UJI_KIMIA, A.UJI_MIKRO, A.JUMLAH_MIKRO, A.HASIL_KIMIA, A.HASIL_MIKRO, A.HASIL_SAMPEL, CONVERT(VARCHAR(10), A.UPDATE_DATE, 103) AS UPDATE_DATE, D.USER_ID AS NIP, D.NAMA_USER, D.JABATAN, E.NAMA_BBPOM, E.KOTA, A.CATATAN_CP FROM T_M_SAMPEL A LEFT JOIN T_PERIKSA_SAMPEL B ON A.PERIKSA_SAMPEL = B.PERIKSA_SAMPEL LEFT JOIN T_SPU C ON A.SPU_ID = C.SPU_ID LEFT JOIN T_USER D ON A.UPDATE_BY = D.USER_ID LEFT JOIN M_BBPOM E ON E.KODE_BALAI = (
CASE WHEN LEFT(SUBSTRING(A.KODE_SAMPEL,3,3),1) = '0' THEN SUBSTRING(A.KODE_SAMPEL,4,2)
ELSE SUBSTRING(A.KODE_SAMPEL,3,3) END) WHERE A.KODE_SAMPEL = '".$arrid[0]."'")->result_array();
			$tanggaluji = $this->db->query("SELECT MIN(CONVERT(VARCHAR(10), AWAL_UJI, 103)) AS MINTGL, MAX(CONVERT(VARCHAR(10), AKHIR_UJI, 103)) AS MAXTGL FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL = '".$arrid[0]."'")->result_array();
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
							if(in_array('B1',$this->newsession->userdata('SESS_SUB_SARANA')) || in_array('B2',$this->newsession->userdata('SESS_SUB_SARANA')) || in_array('B3',$this->newsession->userdata('SESS_SUB_SARANA')) || in_array('B4',$this->newsession->userdata('SESS_SUB_SARANA'))){
								$html .= $arr_sampel[0]['JUMLAH_KIMIA'];
							}else if(in_array('B5',$this->newsession->userdata('SESS_SUB_SARANA'))){
								$html .= $arr_sampel[0]['JUMLAH_MIKRO'];
							}
			$html .= '&nbsp;'.$arr_sampel[0]['SATUAN'];
			$html .= '</td>
					  </tr>
					  <tr>
						<td>Tanggal Mulai Pengujian</td>
						<td>&nbsp;</td>
						<td>'.$tanggaluji[0]['MINTGL'].'</td>
					  </tr>
					  <tr>
						<td class="bottom">Tanggal Selesai Pengujian</td>
						<td class="bottom">&nbsp;</td>
						<td class="bottom">'.$tanggaluji[0]['MAXTGL'].'</td>
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
					  if(in_array('B1',$this->newsession->userdata('SESS_SUB_SARANA')) || in_array('B2',$this->newsession->userdata('SESS_SUB_SARANA')) || in_array('B3',$this->newsession->userdata('SESS_SUB_SARANA')) || in_array('B4',$this->newsession->userdata('SESS_SUB_SARANA'))){
						  $parameter = $this->db->query("SELECT CASE WHEN JENIS_UJI = '01' THEN 'Mikrobiologi' WHEN JENIS_UJI = '02' THEN 'Kimia - Fisika' END AS JENIS_UJI, SPK_ID,PARAMETER_UJI, METODE, PUSTAKA, SYARAT, RUANG_LINGKUP, HASIL, HASIL_KUALITATIF, HASIL_PARAMETER, LCP FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL = '".$arrid[0]."' AND JENIS_UJI = '02'")->result_array();
					  }else if(in_array('B5',$this->newsession->userdata('SESS_SUB_SARANA'))){
						  $parameter = $this->db->query("SELECT CASE WHEN JENIS_UJI = '01' THEN 'Mikrobiologi' WHEN JENIS_UJI = '02' THEN 'Kimia - Fisika' END AS JENIS_UJI, SPK_ID,PARAMETER_UJI, METODE, PUSTAKA, SYARAT, RUANG_LINGKUP, HASIL, HASIL_KUALITATIF, HASIL_PARAMETER, LCP FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL = '".$arrid[0]."' AND JENIS_UJI = '01'")->result_array();
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
	
	function konsep($id){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$this->load->library('mpdf');
			$arrid = explode(".",$id);
			#$nomor = $sipt->main->get_uraian("SELECT dbo.FORMAT_NOMOR('LHU',LHU_ID) AS KODE FROM T_LHU WHERE CP_ID = '".$arrid[0]."'","KODE");
			$nomor = "";
			$html = "";
			$html .= '<div style="font-size:11pt; font-weight:bold; text-align:center; font-family:Times New Roman;">LAPORAN PENGUJIAN</div>';
			$html .= '<div style="font-size:11pt; text-align:center; font-family:Times New Roman;">Nomor : '.$nomor.'</div>';
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
					  $parameter = $this->db->query("SELECT CASE WHEN JENIS_UJI = '01' THEN 'Mikrobiologi' WHEN JENIS_UJI = '02' THEN 'Kimia - Fisika' END AS JENIS_UJI, SPK_ID,PARAMETER_UJI, METODE, PUSTAKA, SYARAT, RUANG_LINGKUP, HASIL, HASIL_KUALITATIF, HASIL_PARAMETER, LCP FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL = '".$arrid[0]."'")->result_array();
			
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