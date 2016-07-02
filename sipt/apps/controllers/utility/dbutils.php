<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');  error_reporting(E_ERROR);

class Dbutils extends Controller{
	
	function Dbutils(){
		parent::Controller();
	}
	
	function index(){
	  	$this->fungsi->redirectMessage('Maaf anda tidak bisa mengakses halaman ini.','/home');
	}
	
	function mapping_napza($tahun, $bulan){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE && $this->newsession->userdata('SESS_BBPOM_ID') == "00"){
			$sipt = get_instance();
			$sipt->load->model("main","main", true);
			$query = "SELECT A.PERIKSA_ID, CONVERT(VARCHAR(10), A.AWAL_PERIKSA,103) AS AWAL, CONVERT(VARCHAR(10), A.AKHIR_PERIKSA,103) AS AKHIR, A.BBPOM_ID, A.SARANA_ID, C.NAMA_SARANA, D.NAMA_BBPOM, B.FILE_TL_BALAI, B.FILE_BAP, B.FILE_LAMPIRAN_BAP, B.FILE_TINDAK_LANJUT FROM T_PEMERIKSAAN A LEFT JOIN T_PEMERIKSAAN_NAPZA B ON A.PERIKSA_ID = B.PERIKSA_ID LEFT JOIN M_SARANA C ON A.SARANA_ID = C.SARANA_ID LEFT JOIN M_BBPOM D ON A.BBPOM_ID = D.BBPOM_ID WHERE RIGHT(A.JENIS_SARANA_ID,1) = 'N' AND LEFT(CONVERT(VARCHAR, A.CREATE_DATE, 112), 4) = '".$tahun."' AND SUBSTRING(CONVERT(VARCHAR, A.CREATE_DATE, 112),5,2) = '".$bulan."' AND B.FILE_BAP IS NOT NULL";
			$data = $sipt->main->get_result($query);
			if($data){
				$jmlsarana = 0;
				$jmlsaranafailed = 0;
				$jmlfailed = 0;
				$jmlexist = 0;
				foreach($query->result_array() as $row){
					$dir = './files/'.$row['SARANA_ID'];
					if(is_dir($dir)){
						$files = $dir . '/' . $row['FILE_BAP'];
						if(file_exists($files)){
							echo $row['NAMA_BBPOM']."#" . $row['NAMA_SARANA'] . "#".$row['AWAL']." s.d ".$row['AKHIR']."#" . $row['FILE_BAP'] . "#[ADA] <br>";
							$jmlexist++;
						}else{
							echo $row['NAMA_BBPOM']."#" . $row['NAMA_SARANA'] . "#".$row['AWAL']." s.d ".$row['AKHIR']."#" . $row['FILE_BAP'] . "#[TIDAK ADA] <br>";
							$jmlfailed++;
						}
						$jmlsarana++;
					}else{
						echo $row['NAMA_BBPOM']."#" . $row['NAMA_SARANA'] . "#".$row['AWAL']." s.d ".$row['AKHIR']."#Tidak melampirkan File#Tidak ditemukan <br>";
						$jmlsaranafailed++;
					}
				}
				echo "<hr>";
				echo "Existing folder : ". $jmlsarana . "<br>";
				echo "Data Sarana : ". $jmlsaranafailed . "<br>";
				echo "Existing file: ". $jmlexist . "<br>";
				echo "Failed file : ". $jmlfailed . "<br>";
			}
		}
	}
		
	function simpel(){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE && $this->newsession->userdata('SESS_BBPOM_ID') == "00"){
			$sipt = get_instance();
			$sipt->load->model("main","main", true);
			//$query = "SELECT KODE_SAMPEL FROM T_M_SAMPEL_RILIS WHERE AWAL_UJI IS NULL";
			$query = "SELECT KODE_SAMPEL FROM T_M_SAMPEL WHERE LEFT(KODE_SAMPEL,1) != 1";
			$dbb = $sipt->main->get_result($query);
			$data = array('act' => site_url().'/utility/dbutils/set_utility/simpel', 'judul' => 'Update Query');
			if($dbb){
				foreach($query->result_array() as $row){
					$id[] = $row['KODE_SAMPEL'];
				}
				$data['id'] = join('|', $id);
			}
			$this->load->view('utility/simpel', $data);	
		}else{
			$this->fungsi->redirectMessage('Maaf anda tidak bisa mengakses halaman ini.','/home');
		}
	}
	
	function get_laporan_bb($id){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE && $this->newsession->userdata('SESS_BBPOM_ID') == "00"){
			$this->load->model("admin/tools_act");
			$ret = $this->tools_act->set_laporan_bb($id);
			echo $ret;
		}
	}
	
	function get_spk_bb($id){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE && $this->newsession->userdata('SESS_BBPOM_ID') == "00"){
			$this->load->model("admin/tools_act");
			$ret = $this->tools_act->set_spk_bb($id);
			echo $ret;
		}
	}
	
	function get_terkirim($id){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE && $this->newsession->userdata('SESS_BBPOM_ID') == "00"){
			$this->load->model("admin/tools_act");
			$ret = $this->tools_act->set_rilis_pusat($id);
			echo $ret;
		}
	}
	
	function set_utility($jenis="",$isajax=""){
		if(strtolower($_SERVER['REQUEST_METHOD'])!="post"){
			redirect(base_url());
			exit();
		}else{			
			$ret = "MSG#NO#Query Gagal";
			if($jenis=="simpel"){
				$data = $this->input->post("editor");
				if($query = $this->db->query($data)){
					$ret = "MSG#YES#Query Berhasil#";
				}else{
					$ret = "MSG#NO#Query Gagal#";
				}
			}
		}
		if($isajax!="ajax"){
			redirect(site_url());
			exit();
		}
		echo $ret;
	}

	function get_kode(){
		$data = $this->db->query("SELECT ID FROM T_M_SAMPEL_UPDATE WHERE FLAG = 0");
		if($data->num_rows() > 0){
			$ret = '';
			foreach($data->result_array() as $row){
				$ret .= $row['ID']."|";
			}
			echo $ret;
		}
	}
	
	function resetkode($id){
		$this->load->model('admin/utility_act');
		$ret = $this->utility_act->set_kodesampel($id);
		echo $ret;
	}

	function set_kode($kode){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE && $this->newsession->userdata('SESS_BBPOM_ID') == "00"){
			$sipt =& get_instance();
			$this->load->model("main","main", true);
			$data = $this->db->query("SELECT KODE_SAMPEL, NAMA_SAMPEL, SUBSTRING(KODE_SAMPEL,3,3) AS KBALAI, ANGGARAN, CASE WHEN SUBSTRING(KODE_SAMPEL,6,2) = '99' THEN '99' ELSE TUJUAN_SAMPLING END AS TUJUAN_SAMPLING, KOMODITI, CASE WHEN UJI_KIMIA = 1 AND UJI_MIKRO = 1 THEN 'KM' WHEN UJI_KIMIA = 1 AND UJI_MIKRO = 0 THEN 'K' WHEN UJI_KIMIA = 0 AND UJI_MIKRO = 1 THEN 'M' END AS LAB, TANGGAL_SAMPLING FROM T_M_SAMPEL_UPDATE WHERE KODE_SAMPEL = '".$kode."'");
			if($data->num_rows() > 0){
				$ret = '';
				foreach($data->result_array() as $row){
					$new = $sipt->main->backup_kode($row['TUJUAN_SAMPLING'], $row['ANGGARAN'], $row['KOMODITI'], $row['LAB'], $row['KBALAI']);
					$ret .= 'Kode Sampel Lama : ' . $row['KODE_SAMPEL'].', Kode Baru : '.$new;
					$this->db->simple_query("UPDATE T_M_SAMPEL_UPDATE SET KODE_SAMPEL = '".$new."', FLAG = 1, KODE_SAMPELX = '".$row['KODE_SAMPEL']."' WHERE KODE_SAMPEL = '".$kode."'");
					$arrlog = array("KODE_SAMPEL" => $new,
									"WAKTU" => $row['TANGGAL_SAMPLING'],
									"USER_ID" => "administrator",
									"KEGIATAN " => "Simpan Data Sampel",
									"CATATAN" => "Reset Data Kode Sampel : ".$kode." menjadi ".$new);
					$this->db->insert("T_SAMPLING_LOG", $arrlog);			
				}
				echo $ret;
			}
		}
	}

	function mapping_srl(){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE && $this->newsession->userdata('SESS_BBPOM_ID') == "00"){
			$sipt =& get_instance();
			$this->load->model("main","main", true);
			$insert = FALSE;
			$status = "GAGAL";
			$file = 'download/srl-fix/PANGAN_NEW.csv';
			$csvcontent = file_get_contents($file);
			if(!file_exists($file)){
				$insert = FALSE;
			}
			$baris = explode("\r\n",$csvcontent);
			$header = explode("#",$baris[0]);
			$arrdata = array();
			$arr = array();
			for($i=0;$i<count($baris);$i++){
				$arr = explode("#", $baris[$i+1]);
				for($x=0;$x<count($arr);$x++){
					$insert = TRUE;
					$arrdata[$header[$x]][] = $arr[$x];	
				}
			}
			unset($arrdata[$header[0]][count($baris)-1]);
			unset($arrdata[$header[0]][count($baris)-2]);
			if($insert){
				$sukses = 0;
				$gagal = 0;
				$cek = FALSE;
				$status = "SUKSES";
				$arrkeys = array_keys($arrdata);
				$jml_rec = count($arrdata[$arrkeys[0]]);
				for($i=0;$i<$jml_rec;$i++){
					$id = (int)$sipt->main->get_uraian("SELECT MAX(ID) AS MAXID FROM MAPPING_SRL", "MAXID") + 1;
					$mapping = array('ID' => $id,
										  'CREATE_DATE' => 'GETDATE()',
										  'CREATE_BY' => $this->newsession->userdata('SESS_USER_ID'),
										  'FLAG' => 1);
					for($j=0;$j<count($arrkeys);$j++){
						$mapping[$arrkeys[$j]] = $arrdata[$arrkeys[$j]][$i];
					}
					if(array_key_exists('KATEGORI', $temuan))$mapping['KATEGORI'] = trim($mapping['KATEGORI']);
					if(array_key_exists('SUB_KATEGORI', $temuan))$mapping['SUB_KATEGORI'] = trim($mapping['SUB_KATEGORI']);
					if(array_key_exists('SUB_SUB_KATEGORI', $temuan))$mapping['SUB_SUB_KATEGORI'] = trim($mapping['SUB_SUB_KATEGORI']);
					if(array_key_exists('GOLONGAN', $temuan))$mapping['GOLONGAN'] = trim($mapping['GOLONGAN']);
					if($this->db->insert('MAPPING_SRL', $mapping)){
						$cek = TRUE;
					}else{
						$cek = FALSE;
					}
					if($cek)
						$sukses++;
					else
						$gagal++;
				}
				$ret = "Total : ".$jml_rec." data , Sukses : ".$sukses." , Gagal: ".$gagal;
			}else{
				$ret = "Export SRL Gagal.";
			}
		}
		echo $ret;
	}
	
	function komoditi_sampel(){
		$sipt =& get_instance();
		$this->load->model("main", "main", true);
		$query = "SELECT BBPOM_ID, NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID NOT IN('00','90','91','92','93','94','95','96')";
		$data = $sipt->main->get_result($query);
		$ok = 0;
		$err = 0;
		if($data){
			foreach($query->result_array() as $row){
				$qanggaran = "SELECT KODE FROM M_TABEL WHERE JENIS = 'ANGGARAN_SAMPLING'";
				$dtanggaran = $sipt->main->get_result($qanggaran); 
				if($dtanggaran){
					foreach($qanggaran->result_array() as $ranggaran){
						$arrdata['BBPOM_ID'] = $row['BBPOM_ID'];
						$arrdata['ANGGARAN'] = $ranggaran['KODE'];
						$arrdata['KOMODITI'] = '14';
						$arrdata['NOMOR'] = 0;
						$arrdata['RESET'] = 'Y';
						$arrdata['UPDATED'] = 'GETDATE()';
						if($this->db->insert('M_REF_SAMPEL',$arrdata)){
							$ok++;
						}else{
							$err;
						}
					}
				}
			}
			echo "Berhasil : ".$ok.", Gagal : ".$err;
		}
		
	}
	
	function golongan(){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE && $this->newsession->userdata('SESS_BBPOM_ID') == "00"){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$query = "SELECT KLASIFIKASI_ID, KLASIFIKASI FROM M_GOLONGAN";
			$data = $sipt->main->get_result($query);
			if($data){
				$yes = 0;
				$err = 0;
				foreach($query->result_array() as $row){
					#$res = $this->db->simple_query("UPDATE M_GOLONGAN SET KLASIFIKASI = '".preg_replace('/[^(\x20-\x7F)]*/','',$sipt->main->clean_tags($row['KLASIFIKASI']))."' WHERE KLASIFIKASI_ID = '".$row['KLASIFIKASI_ID']."'");
					#if($res){
						echo "Klasifikasi tanpa filter : ".$row['KLASIFIKASI']." => Klasifikasi dengan filter : " .preg_replace('/[^(\x20-\x7F)]*/','',$sipt->main->clean_tags($row['KLASIFIKASI']))." <br>";
						#$yes++;
					#}else{
						#$err++;
					#}
					#echo "Jumlah update sukses " .$yes." data, jumlah update gagal ".$err;
				}
			}
		}
	}
	
	function chk_query(){
		if(array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE'))){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$query = "SELECT A.KLASIFIKASI, COUNT(*) AS JML
FROM M_GOLONGAN A LEFT JOIN M_SRL B ON A.KLASIFIKASI_ID = SUBSTRING(B.GOLONGAN,1,2)
WHERE LEN(A.KLASIFIKASI_ID) = 2 
GROUP BY KLASIFIKASI ORDER BY 1 ASC"; 
			$data = $sipt->main->get_result($query);
			if($data){
				foreach($query->result_array() as $row){
					echo $row['KLASIFIKASI']." | ".$row['JML'];
					echo '<hr>';
				}
			}
		}
	}

	function get_tmpbb(){
		if(array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE'))){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$query = "SELECT BBPOM_ID, DAERAH_ID FROM T_NOTIF_TMPBBX";
			$data = $sipt->main->get_result($query);
			if($data){
				foreach($query->result_array() as $row){
					print_r($row);
				}
			}
		}
	}

	function get_laporanbb(){
		if(array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE'))){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$query = "SELECT A.PERIKSA_ID, RTRIM(LTRIM(A.PENGADAAN_ID)) AS PENGADAAN_ID, A.PENGADAAN_SARANA, A.PENGADAAN_ALAMAT, RTRIM(LTRIM(A.PENGADAAN_DAERAH_ID)) AS PENGADAAN_DAERAH_ID, RTRIM(LTRIM(A.DISTRIBUSI_ID)) AS DISTRIBUSI_ID, A.DISTRIBUSI_SARANA, A.DISTRIBUSI_ALAMAT, RTRIM(LTRIM(A.DISTRIBUSI_DAERAH_ID)) AS DISTRIBUSI_DAERAH_ID FROM T_PEMERIKSAAN_BB_LAPORAN A WHERE A.PERIKSA_ID = '70796' AND SERI = '1'";
			$data = $sipt->main->get_result($query);
			if($data){
				$ret = "";
				$no = 1;
				foreach($query->result_array() as $row){
					$qheader = "SELECT A.PERIKSA_ID, A.CREATE_BY, A.CREATE_DATE, B.PROPINSI_ID FROM T_PEMERIKSAAN A LEFT JOIN M_BBPOM B ON A.BBPOM_ID = B.BBPOM_ID WHERE A.PERIKSA_ID = '".$row['PERIKSA_ID']."'";
					$dheader = $sipt->main->get_result($qheader);
					if($dheader){
						foreach($qheader->result_array() as $rowx){
							if(strlen($row['PENGADAAN_ID']) == 0 || ($rowx['PROPINSI_ID'] <> $row['PENGADAAN_DAERAH_ID'])){
								$ret .= $row['PENGADAAN_ID']." >> Pengadaan dari Sarana : ".$row['PENGADAAN_SARANA'].", Alamat Sarana : ". $row['PENGADAAN_ALAMAT'] . ", Kode Daerah : ". $row['PENGADAAN_DAERAH_ID']. ", Propinsi : ".$rowx['PROPINSI_ID'].", Dengan Nomor Periksa : ".$rowx['PERIKSA_ID']."<br>";
							}
							if(strlen($row['DISTRIBUSI_ID']) == 0 || ($rowx['PROPINSI_ID'] <> $row['DISTRIBUSI_DAERAH_ID'])){
								$ret .= $row['DISTRIBUSI_ID']." >> Distribusi ke Sarana : ".$row['DISTRIBUSI_SARANA'].", Alamat Sarana : ". $row['DISTRIBUSI_ALAMAT'] . ", Kode Daerah : ". $row['DISTRIBUSI_DAERAH_ID']. ", Propinsi : ".$rowx['PROPINSI_ID'].",  Dengan Nomor Periksa : ".$row['PERIKSA_ID']."<br>";
							}
						}
					}
					$no++;
				}
				echo $ret;
				echo "<hr>";
				echo "Jumlah Data : ".$no;
			}
		}
	}

	function get_result(){
		if(array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE'))){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$query = "SELECT A.UJI_ID, A.STATUS, dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) AS KODE_SAMPEL, A.PARAMETER_UJI, B.NAMA_USER 
FROM T_PARAMETER_HASIL_UJI A LEFT JOIN T_USER B ON A.PENGUJI = B.USER_ID
WHERE dbo.FORMAT_NOMOR('SPL', A.KODE_SAMPEL) = '14.095.02.12.01.0091.K'";
			$data = $sipt->main->get_result($query);
			if($data){
				foreach($query->result_array() as $row){
					$arrdata[] = $row;
				}
				print_r($arrdata);
			}
		}
	}

	function rowq(){
		if(array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE'))){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$this->load->library('table');
			/*$sql = "SELECT DISTINCT(SPU_ID) X FROM T_M_SAMPEL WHERE STATUS_SAMPEL = ''";
			$kosong = $sipt->main->get_result($sql);
			if($kosong){
				foreach($sql->result_array() as $row){
					$id[] = $row['X'];
				}
			}
			$spu_id = "'".join("','", $id)."'";
			$query = "SELECT SPU_ID, STATUS FROM T_SPU WHERE SPU_ID IN (".$spu_id.")";
			$spux = $sipt->main->get_result($query);
			if($spux){
				$err = 0;
				$msg = 0;
				foreach($query->result_array() as $x){
					//echo $x['SPU_ID']."|".$x['STATUS']."<hr>";
					//$res = $this->db->simple_query("UPDATE T_M_SAMPEL SET STATUS = '".."'");
					echo "UPDATE T_M_SAMPEL SET STATUS_SAMPEL = '".$x['STATUS']."' WHERE SPU_ID = '".$x['SPU_ID']."'"."<hr />";
				}
			}*/
			$query = " SELECT A.PERIKSA_ID, RTRIM(LTRIM(A.PENGADAAN_ID)) AS PENGADAAN_ID, A.PENGADAAN_SARANA, A.PENGADAAN_ALAMAT, RTRIM(LTRIM(A.PENGADAAN_DAERAH_ID)) AS PENGADAAN_DAERAH_ID, RTRIM(LTRIM(A.DISTRIBUSI_ID)) AS DISTRIBUSI_ID, A.DISTRIBUSI_SARANA, A.DISTRIBUSI_ALAMAT, RTRIM(LTRIM(A.DISTRIBUSI_DAERAH_ID)) AS DISTRIBUSI_DAERAH_ID FROM T_PEMERIKSAAN_BB_LAPORAN A";
			$data = $sipt->main->get_result($query);
			if($data){
				foreach($query->result_array() as $row){
					print_r($row);
				}
			}
		}
	}
	
	
	function klasifikasi(){
		if(array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE'))){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$query = "SELECT PERIKSA_ID, KK_ID FROM T_PEMERIKSAAN_KLASIFIKASI WHERE KK_ID = ''";
			$data = $sipt->main->get_result($query);
			$inc = 0;
			if($data){
				foreach($query->result_array() as $row){
					$kkid = $this->db->query("SELECT A.PERIKSA_ID, A.JENIS_SARANA_ID, B.KK_ID FROM T_PEMERIKSAAN A LEFT JOIN M_KLASIFIKASI_KATEGORI B ON A.JENIS_SARANA_ID = B.JENIS_SARANA_ID WHERE A.PERIKSA_ID = '".$row['PERIKSA_ID']."' AND LEN(A.JENIS_SARANA_ID) > 2")->row();
					if(strlen($kkid->PERIKSA_ID) > 0 ){
						#echo $kkid->PERIKSA_ID . " | " . $kkid->KK_ID;
						#echo "<hr>";
						$arr = array('KK_ID' => $kkid->KK_ID);
						$this->db->where('PERIKSA_ID', $kkid->PERIKSA_ID);
						if($this->db->update('T_PEMERIKSAAN_KLASIFIKASI', $arr)){
							$inc++;
						}
					}
				}
				echo "Update ".$inc." data sukses";
			}
		}
	}
	
	
	function mapping_spk(){
		if(array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE'))){
			$sipt =& get_instance();
			$this->load->model("main","main", true);
			$file = 'upload/mapping_spk_yogya.csv';
			$csvcontent = file_get_contents($file);
			if(!file_exists($file)){
				$insert = FALSE;
			}
			$baris = explode("\r\n",$csvcontent);
			$arrdata = array();
			$arr = array();
			$no = 1;
			for($i = 0; $i < count($baris); $i++){
				$arr = explode("#", $baris[$i+0]);
				//echo "No. SPK Lama : " . $arr[0] . ", No. SPK Baru : " . $arr[1] . ", Kode Sampel : " . $arr[2] . ", Status SPK : " . $arr[3] . " <br>";		
				$jmlspk = $sipt->main->get_uraian("SELECT COUNT(*) AS JMLSPK FROM T_SPK WHERE SPK_ID = '".$arr[0]."' AND KODE_SAMPEL = '".$arr[2]."'","JMLSPK");
				echo "&bull; Jumlah Data di SPK : " . $jmlspk . " dengan Nomor <b>".$arr[0]."</b> dan Kode Sampel <b>".$arr[2]."</b>. SPK Baru : ".$arr[1]."<br>";
				$arrspk = array('SPK_ID' => $arr[1]);
				$this->db->where('SPK_ID', $arr[0]);
				$this->db->where('KODE_SAMPEL', $arr[2]);
				if($this->db->update('T_SPK', $arrspk)){
					echo $this->db->affected_rows(). ', SPK berhasil di update';
				}
				
				$jmlparam = $sipt->main->get_uraian("SELECT COUNT(*) AS JMLPARAM FROM T_PARAMETER_HASIL_UJI WHERE SPK_ID = '".$arr[0]."' AND KODE_SAMPEL = '".$arr[2]."'","JMLPARAM");
				echo "&bull; Jumlah Data di Parameter Hasil Uji : " . $jmlparam. " dengan Nomor <b>".$arr[0]."</b> dan Kode Sampel <b>".$arr[2]."</b><br>";
				$arrparam = array('SPK_ID' => $arr[1]);
				$this->db->where('SPK_ID', $arr[0]);
				$this->db->where('KODE_SAMPEL', $arr[2]);
				if($this->db->update('T_PARAMETER_HASIL_UJI', $arrparam)){
					echo $this->db->affected_rows(). ', Parameter berhasil di update';
				}
				
				#$jmlspp = $sipt->main->get_uraian("SELECT COUNT(*) AS JMLSPP FROM T_SPP WHERE SPK_ID = '".$arr[0]."'","JMLSPP");
				#echo "&bull; Jumlah Data di Perintah Pengujian : " . $jmlspp. " dengan Nomor <b>".$arr[0]."</b><br>";
				
				$jmlcp = $sipt->main->get_uraian("SELECT COUNT(*) AS JMLCP FROM T_CP WHERE KODE_SAMPEL = '".$arr[2]."'","JMLCP");
				echo "&bull; Jumlah Data di Catatan Pengujian: " . $jmlcp. " dengan Kode Sampel <b>".$arr[2]."</b><br>";
				
				echo "==================================================================================================================================================<br>";  
				$no++;
				
				
			}
		}
	}
	
	
	function recyle_spk(){
		$this->load->library('newphpexcel');
        $file = 'upload/TMP_SPK_DELETE.xls';
		$objPHPExcel = PHPExcel_IOFactory::load($file);
		$objWorksheet   = $objPHPExcel->getActiveSheet();
		$sheetData      = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
		$header = array();
		$detil = array();
		$succ = 0;
		$err = 0;
		$jml = 0;
		for($r=15; $r<=count($sheetData); $r++){
			/*$header['SPK_ID'] = $sheetData[$r]['A'];
			$header['KODE_SAMPEL'] = $sheetData[$r]['B'];
			$header['SPU_ID'] = $sheetData[$r]['C'];
			$header['BBPOM_ID'] = $sheetData[$r]['D'];
			$header['KOMODITI'] = $sheetData[$r]['E'];
			$header['TANGGAL'] = $sheetData[$r]['F'];
			$header['KASIE'] = $sheetData[$r]['G'];
			$header['STATUS'] = $sheetData[$r]['H'];
			$header['CREATE_BY'] = $sheetData[$r]['I'];
			$header['CREATE_DATE'] = $sheetData[$r]['J'];
			$this->db->insert('T_SPK', $header);
			if($this->db->affected_rows() > 0){
				$succ++;
			}else{
				$err++;
			}
			$jml++;*/
			$logs['SPK_ID'] = $sheetData[$r]['A'];
			$logs['WAKTU'] = $sheetData[$r]['B'];
			$logs['USER_ID'] = $sheetData[$r]['C'];
			$logs['KEGIATAN'] = 'Proses pembuatan SPP untuk Nomor SPK : '.$sheetData[$r]['A'];
			$logs['CATATAN'] = 'Kode Sampel : '.$sheetData[$r]['D'];
			$this->db->insert('T_SPK_LOG', $logs);
			if($this->db->affected_rows() > 0){
				$succ++;
			}else{
				$err++;
			}
			$jml++;
		}
		echo "Jumlah Data : " .$jml.",  Sukses : ".$succ." , Error : ". $err;
	}
	
	
}
?>