<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Spp extends Controller{
	
	function Spp(){
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
			if(in_array('B1',$this->newsession->userdata('SESS_SUB_SARANA')) || in_array('B2',$this->newsession->userdata('SESS_SUB_SARANA'))){
				$query = "SELECT dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) AS KODE_SAMPEL, A.PARAMETER_UJI, A.METODE, A.PUSTAKA, A.SYARAT, A.RUANG_LINGKUP, B.NAMA_SAMPEL, B.NOMOR_REGISTRASI, B.NO_BETS, B.BENTUK_SEDIAAN, B.KEMASAN,B.KOMPOSISI, B.KETERANGAN_ED, dbo.KATEGORI(B.KOMODITI,B.PRIORITAS) AS KOMODITI, dbo.KATEGORI(B.KATEGORI,B.PRIORITAS) AS KATEGORIX, B.NAMA_KATEGORI AS KATEGORI, C.NAMA_USER AS PENGUJI FROM T_PARAMETER_HASIL_UJI A LEFT JOIN T_M_SAMPEL B ON A.KODE_SAMPEL = B.KODE_SAMPEL LEFT JOIN T_USER C ON A.PENGUJI = C.USER_ID WHERE A.SPK_ID = '".$id."' AND A.JENIS_UJI = '02'";
			}else if(in_array('B3',$this->newsession->userdata('SESS_SUB_SARANA'))){
				$query = "SELECT dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) AS KODE_SAMPEL, A.PARAMETER_UJI, A.METODE, A.PUSTAKA, A.SYARAT, A.RUANG_LINGKUP, B.NAMA_SAMPEL, B.NOMOR_REGISTRASI, B.NO_BETS, B.BENTUK_SEDIAAN, B.KEMASAN, B.KOMPOSISI, B.KETERANGAN_ED, dbo.KATEGORI(B.KOMODITI,B.PRIORITAS) AS KOMODITI, dbo.KATEGORI(B.KATEGORI,B.PRIORITAS) AS KATEGORIX, B.NAMA_KATEGORI AS KATEGORI, C.NAMA_USER AS PENGUJI FROM T_PARAMETER_HASIL_UJI A LEFT JOIN T_M_SAMPEL B ON A.KODE_SAMPEL = B.KODE_SAMPEL LEFT JOIN T_USER C ON A.PENGUJI = C.USER_ID WHERE A.SPK_ID = '".$id."' AND A.JENIS_UJI = '01'";
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
					  				$html .= '<div>'.$row['BENTUK_SEDIAAN'].'</div><div>'.$row['KEMASAN'].'</div><div>'.str_replace(">", " > ", str_replace("<"," < ", $row['KOMPOSISI'])).'</div>';
								//}
					  $html .= '</td><td class="'.$grs.' '.$class.'">';
					  			//if($row['KOMODITI'] != $komoditi){
					  				$html .= '<div>'.$row['KOMODITI'].'</div><div>'.$row['KETERANGAN_ED'].'<div>';
								//}
					  $html .= '</td><td class="'.$grs.' '.$class.'"><div>'.$row['PARAMETER_UJI'].'</div><div>'.$row['RUANG_LINGKUP'].'</div></td>
								<td class="'.$grs.' '.$class.'"><div>'.$row['METODE'].'</div><div>'.$row['PUSTAKA'].'</div></td>
								<td class="'.$grs.' '.$class.'">'.str_replace(">", " > ", str_replace("<"," < ", $row['SYARAT'])).'</td>';
								
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
		
}
?>