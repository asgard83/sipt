<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Spk extends Controller{
	
	function Spk(){
		parent::Controller();
	}
	
	function index(){
	  	$this->fungsi->redirectMessage('Maaf anda tidak bisa mengakses halaman ini.','/home');
	}
	
	
	function prints($kode){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$this->load->library('mpdf');
			$arrheader = $this->db->query("SELECT dbo.FORMAT_NOMOR('SPK', A.SPK_ID) AS UR_SPK, dbo.FORMAT_NOMOR('SPU',A.SPU_ID) AS SPU, A.SPK_ID,
CONVERT(VARCHAR(10), A.TANGGAL, 103) AS TANGGAL, B.NAMA_USER, B.USER_ID, B.JABATAN, C.KOTA FROM T_SPK A LEFT JOIN T_USER B ON A.CREATE_BY = B.USER_ID LEFT JOIN M_BBPOM C ON A.BBPOM_ID = C.BBPOM_ID WHERE A.SPK_ID IN (SELECT SPK_ID FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL = '".$kode."') AND A.CREATE_BY = '".$this->newsession->userdata('SESS_USER_ID')."'")->result_array();
			$q = "SELECT B.NAMA_USER FROM T_SPK A LEFT JOIN T_USER B ON A.KASIE = B.USER_ID WHERE A.SPK_ID = '".$arrheader[0]['SPK_ID']."'"; 
			$dt = $sipt->main->get_result($q);
			if($dt){
				foreach($q->result_array() as $rq){
					$arrp[] = $rq;
				}
			}else{
				$arrp = array();
			}
			$html = "";
			$html .= '<div class="judul">SURAT PERINTAH KERJA</div>';
			$html .= '<div class="judul">Nomor : '.$arrheader[0]['UR_SPK'].'</div>';
			$html .= '<div style="height:10px;">&nbsp;</div>';
			$html .= '<div>Kepada Yth,</div>';
			$jml = count($arrp);
			if($jml > 0){
				for($i=0; $i<$jml; $i++){
					$html .= '<div> - '.$arrp[$i]['NAMA_USER'].'</div>';
				}
			}
			$html .= '<p>Bersama ini dikirim sampel untuk dilakukan pengujian, sesuai Surat Perintah Uji Nomor : '.$arrheader[0]['SPU'].'</p>';
			if(in_array('B1',$this->newsession->userdata('SESS_SUB_SARANA')) || in_array('B2',$this->newsession->userdata('SESS_SUB_SARANA'))){
				$query = "SELECT dbo.FORMAT_NOMOR('SPL', A.KODE_SAMPEL) AS KODE, A.NAMA_SAMPEL, A.BENTUK_SEDIAAN, B.PARAMETER_UJI, B.METODE, B.PUSTAKA, B.SYARAT FROM T_M_SAMPEL A LEFT JOIN T_PARAMETER_HASIL_UJI B ON A.KODE_SAMPEL = B.KODE_SAMPEL WHERE B.JENIS_UJI = '02' AND B.SPK_ID = '".$arrheader[0]['SPK_ID']."'";
			}else if(in_array('B3',$this->newsession->userdata('SESS_SUB_SARANA'))){
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
			$mpdf=new mPDF('utf-8', array(330,210),10,10,10,10,10,10);
			$stylesheet = file_get_contents('css/mpdf.css');
			$mpdf->mirrorMargins = 1;
			$mpdf->WriteHTML($stylesheet,1);
			$mpdf->WriteHTML($html);
			$mpdf->Output();
			exit;
		}
	}
	
	function printsall($id){
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
				if(in_array('B1',$this->newsession->userdata('SESS_SUB_SARANA')) || in_array('B2',$this->newsession->userdata('SESS_SUB_SARANA'))){
					$query = "SELECT dbo.FORMAT_NOMOR('SPL', A.KODE_SAMPEL) AS KODE, A.NAMA_SAMPEL, A.BENTUK_SEDIAAN, B.PARAMETER_UJI, B.METODE, B.PUSTAKA, B.SYARAT FROM T_M_SAMPEL A LEFT JOIN T_PARAMETER_HASIL_UJI B ON A.KODE_SAMPEL = B.KODE_SAMPEL WHERE B.JENIS_UJI = '02' AND B.SPK_ID = '".$arrheader[0]['SPK_ID']."'";
				}else if(in_array('B3',$this->newsession->userdata('SESS_SUB_SARANA'))){
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
		
}
?>