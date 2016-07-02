<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Sps extends Controller{
	
	function Sps(){
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
			$arr_header = $this->db->query("SELECT dbo.FORMAT_NOMOR('SPU',SPU_ID) AS SPU, dbo.FORMAT_NOMOR('SPS',NOMOR_SPS) AS SPS, dbo.FORMAT_NOMOR('SP',NOMOR_SP) AS SP, dbo.URAIAN_M_TABEL('ASAL_SAMPLING', ASAL_SAMPEL) AS ASAL, dbo.URAIAN_M_TABEL('ANGGARAN_SAMPLING', SUBSTRING(SPU_ID, 7,2)) AS ANGGARAN, dbo.KATEGORI(SUBSTRING(SPU_ID, 13,2),'0') AS KOMODITI, CONVERT(VARCHAR(10), TANGGAL_PERINTAH, 103) AS TANGGAL_PERINTAH FROM T_SPU WHERE SPU_ID = '".$spuid."'")->result_array();
			$kbalai = explode("|",$sipt->main->get_uraian("SELECT USER_ID +'|'+ NAMA_USER AS NAMA FROM T_USER WHERE USER_ID
IN(SELECT USER_ID FROM T_USER_ROLE WHERE ROLE IN('5')) AND BBPOM_ID = '".$this->newsession->userdata('SESS_BBPOM_ID')."' AND STATUS = 'Aktif'","NAMA"));
			$chk_uji = $this->db->query("SELECT SUM(CASE WHEN UJI_KIMIA = '1' THEN 1 ELSE 0 END) AS KIMIA, SUM(CASE WHEN UJI_MIKRO = '1' THEN 1 ELSE 0 END) AS MIKRO FROM T_M_SAMPEL WHERE SPU_ID = '".$spuid."'")->result_array();
			
			
			$html = "";
			//------------------------------------------- Surat Perintah Uji ----------------------------------
			
			$qmt = "SELECT DISTINCT B.NAMA_USER, B.JABATAN FROM T_SAMPEL_MT A LEFT JOIN T_USER B ON A.USER_ID = B.USER_ID WHERE A.SPU_ID = '".$spuid."'";
			$resmt = $sipt->main->get_result($qmt);
			if($resmt){
				foreach($qmt->result_array() as $rowmt){
					$html .= '<div class="judul">Surat Perintah Uji</div>';
					$html .= '<div class="judul">'.$arr_header[0]['SP'].'</div>';
					$html .= '<div style="padding-top:5px; text-align:center;">Nomor : '.$arr_header[0]['SPS'].'</div>';
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
							  <tr><td></td><td>Kepala Balai</td></tr>
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
						  A.IMPORTIR, dbo.KATEGORI(A.KOMODITI,A.PRIORITAS) AS KOMODITI, dbo.KATEGORI(A.KATEGORI,A.PRIORITAS) AS KATEGORIX, A.NAMA_KATEGORI AS KATEGORI, A.KOMPOSISI,
						  A.KEMASAN, A.KETERANGAN_ED, A.NO_BETS, A.NETTO, A.TEMPAT_SAMPLING, CONVERT(VARCHAR(10), A.TANGGAL_SAMPLING, 103) AS TANGGAL_SAMPLING, A.JUMLAH_SAMPEL, A.JUMLAH_KIMIA, A.JUMLAH_MIKRO, A.SISA, A.EVALUASI_PENANDAAN, A.KETERANGAN_ED, A.CARA_PENYIMPANAN, 
						  A.KONDISI_SAMPEL, A.KLASIFIKASI_TAMBAHAN, B.NOMOR_SURAT, A.CATATAN, A.UJI_KIMIA, A.UJI_MIKRO
						  FROM T_PERIKSA_SAMPEL B LEFT JOIN T_M_SAMPEL A  ON A.PERIKSA_SAMPEL = B.PERIKSA_SAMPEL WHERE A.SPU_ID= '".$spuid."'
						  AND A.UJI_KIMIA = '1' AND A.STATUS_SAMPEL NOT IN ('00000') ORDER BY A.KODE_SAMPEL ASC";
				$res_kimia = $sipt->main->get_result($kimia);
				if($res_kimia){
					$html .= '<table width="100%" class="tablepdf" id="tablepdf" >
						  <tr>
							<th class="header rows left" width="1%">No.</th>
							<th class="header">Kode Sampel</th>
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
									<td class="'.$grs.' '.$class.'"><div class="uline">'.$row_kimia['NAMA_SAMPEL'].'</div><div class="uline">&bull; '.$row_kimia['NOMOR_REGISTRASI'].'</div><div class="uline">&bull; '.$row_kimia['BENTUK_SEDIAAN'].'</div><div class="uline">&bull; No Bets :'.$row_kimia['NO_BETS'].'</div><div class="uline">&bull; '.$row_kimia['KOMODITI'].'</div><div class="uline">'.$row_kimia['KATEGORI'].'</div><div class="uline">&bull; '.$row_kimia['PABRIK'].'</div><div class="uline">&bull; '.$row_kimia['IMPORTIR'].'</div></td>
									<td class="'.$grs.' '.$class.'">'.str_replace(">", " > ", str_replace("<"," < ", preg_replace('/[^(\x20-\x7F)]*/','',$sipt->main->clean_tags($row_kimia['KOMPOSISI'])))).'</td>
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
						  A.IMPORTIR, dbo.KATEGORI(A.KOMODITI,A.PRIORITAS) AS KOMODITI, dbo.KATEGORI(A.KATEGORI,A.PRIORITAS) AS KATEGORIX, A.NAMA_KATEGORI AS KATEGORI, A.KOMPOSISI,
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
									<td class="'.$grs.' '.$class.'"><div class="uline">'.$row_kimia['NAMA_SAMPEL'].'</div><div class="uline">&bull; '.$row_kimia['NOMOR_REGISTRASI'].'</div><div class="uline">&bull; '.$row_kimia['BENTUK_SEDIAAN'].'</div><div class="uline">&bull; No Bets :'.$row_kimia['NO_BETS'].'</div><div class="uline">&bull; '.$row_kimia['KOMODITI'].'</div><div class="uline">'.$row_kimia['KATEGORI'].'</div><div class="uline">&bull; '.$row_kimia['PABRIK'].'</div><div class="uline">&bull; '.$row_kimia['IMPORTIR'].'</div></td>
									<td class="'.$grs.' '.$class.'">'.str_replace(">", " > ", str_replace("<"," < ", preg_replace('/[^(\x20-\x7F)]*/','',$sipt->main->clean_tags($row_kimia['KOMPOSISI'])))).'</td>
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
		
}
?>