<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR);
class Tools_act extends Model{
	function get_pemeriksaan(){
		if((array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('9', $this->newsession->userdata('SESS_KODE_ROLE'))) && $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt = get_instance();
			$sipt->load->model("main","main", true);
			$query = "SELECT (CAST(PERIKSA_ID AS VARCHAR) + '.' + BBPOM_ID) AS ID FROM T_PEMERIKSAAN WHERE YEAR(AWAL_PERIKSA) = '".date("Y")."' AND LEN(STATUS) > 2";
			$data = $sipt->main->get_result($query);
			if($data){
				foreach($query->result_array() as $row){
					$periksaid[] = $row['ID'];
				}
			}
			$arrdata = array('periksaid' => join('|', $periksaid));

			return $arrdata;
		}
	}
	
	function set_timelinesarana($id){
		if(array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt = get_instance();
			$sipt->load->model("main","main", true);
			$arrid = explode(".",$id);
			$query = "WITH CTE AS ( SELECT A.SERI, A.CREATE_DATE, B.NAMA_USER, B.JABATAN,
					  CASE
					  WHEN A.HASIL = '20101' OR A.HASIL = '20102' OR A.HASIL = '20103' OR A.HASIL = '30101' OR A.HASIL = '30102' THEN 'OPERATOR'
					  WHEN A.HASIL = '40101' OR A.HASIL = '40103' OR A.HASIL = '30103' OR A.HASIL = '30104' THEN 'KASIE'
					  WHEN A.HASIL = '50101' OR A.HASIL = '40102' THEN 'KABID'
					  WHEN A.HASIL = '20115' THEN 'KABALAI' END AS KET, A.HASIL, ROW_NUMBER() OVER (ORDER BY SERI) AS sn
					  FROM T_PEMERIKSAAN_PROSES A LEFT JOIN T_USER B ON A.CREATE_BY = B.USER_ID 
					  WHERE A.PERIKSA_ID = '".$arrid[0]."' AND A.HASIL IN ('20101','20102','20103', '30101','30102','30103','40101','40102','40103','50101','20115') AND A.FLAG = '0')
					  SELECT m.NAMA_USER, m.CREATE_DATE, sLead.CREATE_DATE AS SEBELUM, ISNULL(sLeg.CREATE_DATE,NULL) AS SESUDAH,
					  ISNULL(DATEDIFF(DD, sLead.CREATE_DATE, m.CREATE_DATE),0) AS SELISIH, m.HASIL, m.KET
					  FROM CTE AS m LEFT OUTER JOIN CTE AS sLead ON sLead.sn = m.sn-1 LEFT OUTER JOIN CTE AS sLeg ON sLeg.sn = m.sn+1
					  WHERE m.sn > 1 ORDER BY m.SERI";
			$data = $sipt->main->get_result($query);
			if($data){
				$tmprow = $this->db->query("SELECT * FROM T_TIME_LINE_SARANA WHERE BBPOM_ID = '".$arrid[1]."' AND TAHUN = '".date("Y")."'")->result_array();
				
				$lamaoperator = $tmprow[0]['LAMA_OPERATOR'];
				$lamakasie = $tmprow[0]['LAMA_SPV_SATU'];
				$lamakabid = $tmprow[0]['LAMA_SPV_DUA'];
				$lamakabalai = $tmprow[0]['LAMA_KEPALA_BALAI'];
				
				$jmloperator = $tmprow[0]['JML_OPERATOR'];
				$jmlkasie = $tmprow[0]['JML_SPV_SATU'];
				$jmlkabid = $tmprow[0]['JML_SPV_DUA'];
				$jmlkabalai = $tmprow[0]['JML_KEPALA_BALAI'];
				$jmldok = $tmprow[0]['JML_DOKUMEN'];
				
				$arroperator = array();
				$arrkasie = array();
				$arrkabid = array();
				$arrkabalai = array();
				
				$ret .= "OK#<li>";
				$ret .= "<ul style=\"list-style:none; padding:0px; margin-left:5px;\">";
				foreach($query->result_array() as $row){
					$ret .= "<li>User : ".$row['NAMA_USER'].", Tanggal Dokumen : ".$row['SESUDAH'].", Tanggal Proses : ".$row['CREATE_DATE'].", Selisih Waktu : ".$row['SELISIH']." Hari. Level Akses : ".$row['KET']."</li>";
					if($row['KET'] == "OPERATOR"){
						$lamaoperator = $lamaoperator + $row['SELISIH'];
						$arroperator[] = $row['KET'];
					}
					if($row['KET'] == "KASIE"){
						$lamakasie = $lamakasie + $row['SELISIH'];
						$arrkasie[] = $row['KET'];
					}
					if($row['KET'] == "KABID"){
						$lamakabid = $lamakabid + $row['SELISIH'];
						$arrkabid[] = $row['KET'];
					}
					if($row['KET'] == "KABALAI"){
						$lamakabalai = $lamakabalai+ $row['SELISIH'];
						$arrkabalai[] = $row['KET'];
					}
				}
				$jmloperator = $jmloperator + (count($arroperator));
				$jmlkasie = $jmlkasie + (count($arrkasie));
				$jmlkabid = $jmlkabid + (count($arrkabid));
				$jmlkabalai = $jmlkabalai + (count($arrkabalai));
				$arrtimeline = array('LAMA_OPERATOR' => (int)$lamaoperator,
									 'LAMA_SPV_SATU' => (int)$lamakasie,
									 'LAMA_SPV_DUA' => (int)$lamakabid,
									 'LAMA_KEPALA_BALAI' => (int)$lamakabalai, 	
									 'JML_OPERATOR' => (int)$jmloperator,
									 'JML_SPV_SATU' => (int)$jmlkasie,
									 'JML_SPV_DUA' => (int)$jmlkabid,
									 'JML_KEPALA_BALAI' => (int)$jmlkabalai,
									 'JML_DOKUMEN' => ((int)$jmldok + 1),
									 'UPDATED' => 'GETDATE()');
				$this->db->where('BBPOM_ID', $arrid[1]);
				$this->db->where('TAHUN', date("Y"));					 
				$this->db->update('T_TIME_LINE_SARANA',$arrtimeline);
				$this->db->simple_query("UPDATE T_PEMERIKSAAN_PROSES SET FLAG = 1 WHERE PERIKSA_ID = '".$arrid[0]."'");					 
				$ret .= "<li><hr></li>";
				$ret .= "<li><b>".$sipt->main->get_uraian("SELECT NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID = '".$arrid[1]."'","NAMA_BBPOM")."</b></li>";
				$ret .= "<li>Total Hari : Operator ".$jmloperator.", Kepala Seksi : ".$jmlkasie.", Kepala Bidang : ".$jmlkabid.", Kepala Balai : ".$jmlkabalai."</li>";
				$ret .= "</ul></li>#SUKSES";
			}
			return $ret;
		}
	}

	
	function set_laporan_bb($id){
		if(array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt = get_instance();
			$sipt->load->model("main","main", true);
			$arrid = explode(".",$id);
			$query = "SELECT A.PERIKSA_ID, RTRIM(LTRIM(A.PENGADAAN_ID)) AS PENGADAAN_ID, A.PENGADAAN_SARANA, A.PENGADAAN_ALAMAT, RTRIM(LTRIM(A.PENGADAAN_DAERAH_ID)) AS PENGADAAN_DAERAH_ID, RTRIM(LTRIM(A.DISTRIBUSI_ID)) AS DISTRIBUSI_ID, A.DISTRIBUSI_SARANA, A.DISTRIBUSI_ALAMAT, RTRIM(LTRIM(A.DISTRIBUSI_DAERAH_ID)) AS DISTRIBUSI_DAERAH_ID FROM T_PEMERIKSAAN_BB_LAPORAN A WHERE A.PERIKSA_ID = '".$arrid[0]."' AND SERI = '".$arrid[1]."'";
			$data = $sipt->main->get_result($query);
			if($data){
				foreach($query->result_array() as $row){
					$qheader = "SELECT A.PERIKSA_ID, A.CREATE_BY, CONVERT(VARCHAR(10), A.CREATE_DATE, 103) AS CREATE_DATE, B.PROPINSI_ID, A.BBPOM_ID FROM T_PEMERIKSAAN A LEFT JOIN M_BBPOM B ON A.BBPOM_ID = B.BBPOM_ID WHERE A.PERIKSA_ID = '".$row['PERIKSA_ID']."'";
					$dheader = $sipt->main->get_result($qheader);
					if($dheader){
						$id_tmp = (int)$sipt->main->get_uraian("SELECT MAX(ID_TMP) AS MAXID FROM T_NOTIF_TMPBBX", "MAXID") + 1;
						foreach($qheader->result_array() as $rowx){
							if(strlen($row['PENGADAAN_ID']) == 0 || ($rowx['PROPINSI_ID'] <> $row['PENGADAAN_DAERAH_ID'])){
								$arrtmp = array('ID_TMP' => $id_tmp,
												'PERIKSA_ID' => $arrid[0],
												'SARANA_ID' => $row['PENGADAAN_ID'],
												'ISPERIKSA' => 1,
												'NAMA_SARANA' => $row['PENGADAAN_SARANA'],
												'ALAMAT_SARANA' => $row['PENGADAAN_ALAMAT'],
												'DAERAH_ID' => $row['PENGADAAN_DAERAH_ID'],
												'BBPOM_ID' => $rowx['BBPOM_ID'],
												'CREATED' => $rowx['CREATE_DATE'],
												'CREATE_BY' => $rowx['CREATE_BY']);
								$res = $this->db->insert('T_NOTIF_TMPBBX', $arrtmp);
								if($res){
									$ret = "OK#<li>".$row['PENGADAAN_ID']." >> Pengadaan dari Sarana : ".$row['PENGADAAN_SARANA'].", Alamat Sarana : ". $row['PENGADAAN_ALAMAT'] . ", Kode Daerah : ". $row['PENGADAAN_DAERAH_ID']. ", Propinsi : ".$rowx['PROPINSI_ID'].", Dengan Nomor Periksa : ".$rowx['PERIKSA_ID']."</li>#Sukses";
								}
							}
							if(strlen($row['DISTRIBUSI_ID']) == 0 || ($rowx['PROPINSI_ID'] <> $row['DISTRIBUSI_DAERAH_ID'])){
								$arrtmp = array('ID_TMP' => $id_tmp,
												'PERIKSA_ID' => $arrid[0],
												'SARANA_ID' => $row['DISTRIBUSI_ID'],
												'ISPERIKSA' => 1,
												'NAMA_SARANA' => $row['DISTRIBUSI_SARANA'],
												'ALAMAT_SARANA' => $row['DISTRIBUSI_ALAMAT'],
												'DAERAH_ID' => $row['DISTRIBUSI_DAERAH_ID'],
												'BBPOM_ID' => $rowx['BBPOM_ID'],
												'CREATED' => $rowx['CREATE_DATE'],
												'CREATE_BY' => $rowx['CREATE_BY']);
								$res = $this->db->insert('T_NOTIF_TMPBBX', $arrtmp);
								if($res){
									$ret = "OK#<li>".$row['DISTRIBUSI_ID']." >> Distribusi ke Sarana : ".$row['DISTRIBUSI_SARANA'].", Alamat Sarana : ". $row['DISTRIBUSI_ALAMAT'] . ", Kode Daerah : ". $row['DISTRIBUSI_DAERAH_ID']. ", Propinsi : ".$rowx['PROPINSI_ID'].",  Dengan Nomor Periksa : ".$row['PERIKSA_ID']."</li>#Sukses";
								}
							}
						}
					}
				}
			}else{
				$ret .= "OK<li>Not Found</li>#GAGAL";
			}
			return $ret;
		}
	}

	function get_pengujian(){
		if(array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt = get_instance();
			$sipt->load->model("main","main", true);
			$arrdata = array();
			$arrdata['balai'] = $sipt->main->combobox("SELECT BBPOM_ID, REPLACE(REPLACE(NAMA_BBPOM,'BALAI BESAR POM DI ', ''),'BALAI POM DI ','') AS NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID NOT IN('00') ORDER BY 2 ASC","BBPOM_ID","NAMA_BBPOM", TRUE);
			$arrdata['komoditi'] = $sipt->main->combobox("SELECT KLASIFIKASI_ID, KLASIFIKASI FROM M_GOLONGAN WHERE LEN(KLASIFIKASI_ID) = 2","KLASIFIKASI_ID","KLASIFIKASI",TRUE);
			$arrdata['anggaran'] = $sipt->main->combobox("SELECT KODE, URAIAN FROM M_TABEL WHERE JENIS = 'ANGGARAN_SAMPLING'","KODE","URAIAN",TRUE);
			return $arrdata;
		}
	}
	
	function get_mapping_pu(){
		if(array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt = get_instance();
			$sipt->load->model("main","main", true);
			$query = "SELECT ID FROM MAPPING_SRL WHERE FLAG = 2 AND KATEGORI_PU IS NOT NULL";
			$data = $sipt->main->get_result($query);
			if($data){
				foreach($query->result_array() as $row){
					$id[] = $row['ID'];
				}
			}
			$arrdata = array('srlid' => join('|', $id));
			return $arrdata;
		}
	}
	
	function get_mapping_kode(){
		if(array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$arrdata['kode'] = "140830112010055K.140830112010140K.140830112010072K.140830112010091K.140830112010097K.140830112010078K.140830112010138K.140830112010023K.140830112010027K.140830112010052K.140830112010054K.140830112010084K.140830112010095K.140830112010109K.140830112010096K.140830112010086K.140830112010103K.140830112010108K.140830112010080K.140830112010118K.140830112010153K.140830112010032K.140830112010128K.140830112010069K.140830112010087K.140830112010126K.140830112010139K.140830112010158K.140830112010168K.140830112010156K.140830112010106K.140830112010101K.140830112010119K.140830112010082K.140830112010068K.140830112010105K.140830112010147K.140830112010160K.140830112010174K.140830112010179K.140830112010172K.140830112010205K.140830112010188K.140830112010201K.140830112010199K.140830112010190K.140830112010181K.140830112010113K.140830112010161K.140830112010159K.140830112010327K.140830112010386K.140830112010353K.140830112010204K.140830112010271K.140830112010353K.140830112010246K.140830112010305K.140830112010309K.140830112010329K.140830112010319K.140830112010491K.140830112010494K.140830112010490K.140830112010489K.140830112010403K.140830112010407K.140830112010413K.140830112010326K.140830112010325K.140830112010419K.140830112010443K.140830112010356K.140830112010358K.140830112010360K.140830112010370K.140830112010378K.140830112010304K.140830112010396K.140830112010354K.140830112010431K.140830112010432K.140830112010450K.140830112010463K.140830112010466K.140830112010453K.140830112010452K.140830112010456K.140830112010405K.140830112010441K.140830112010391K.140830112010385K.140830112010361K.140830112010454K.140830112010447K.140830112010445K.140830112010438K.140830112010435K.140830112010423K.140830112010426K.140830112010421K.140830112010301K.140830112010284K.140830112010444K.140830112010442K.140830112010461K.140830112010480K.140830112010458K.140830112010424K.140830112010417K.140830112010328K.140830112010343K.140830112010384K.140830112010411K.140830112010415K.140830112010207K.140830112010141K.140830112010170K.140830112010154K.140830112010194K.140830112010146K.140830112010065K.140830112010085K.140830112010177K.140830112010081K.140830112010225K.140830112010257K.140830112010277K.140830112010270K.140830112010294K.140830112010268K.140830112010255K.140830112010252K.140830112010229K.140830112010209K.140830112010234K.140830112010281K.140830112010269K.140830112010286K.140830112010249K.140830112010337K.140830112010276K.140830112010251K.140830112010236K.140830112010318K.140830112010336K.140830112010366K.140830112010364K.140830112010311K.140830112010226K.140830112010335K.140830112010215K.140830112010206K.140830112010206K.140830112010288K.140830112010273K.140830112010235K.140830112010214K.140830112010217K.140830112010237K.140830112010260K.140830112010184K.140830112010243K.140830112010334K.140830112010219K.140830112010254K.140830112010449K.140830112010380K.140830112010292K.140830112010451K.140830112010233K.140830112010352K.140830112010228K.140830112010261K.140830112010289K.140830112010279K.140830112010436K.140830112010283K.140830112010300K.140830112010340K.140830112010372K.140830112010272K.140830112010293K.140830112010274K.140830112010262K.140830112010195K.140830112010220K.140830112010376K.140830112010278K.140830112010133K.140830112010116K.140830112010187K.140830112010193K.140830112010299K.140830112010196K.140830112010227K.140830112010250K.140830112010499K.140830112010322K.140830112010259K.140830112010381K.140830112010457K.140830112010312K.140830112010348K.140830112010331K.140830112010246K.140830112010230K.140830112010571K.140830112010512K.140830112010559K.140830112010213K.140830112010474K.140830112010527K.140830112010507K.140830112010526K.140830112010593K.140830112010532K.140830112010520K.140830112010565K.140830112010538K.140830112010517K.140830112010572K.140830112010626K.140830112010716K.140830112010701K.140830112010751K.140830112010768K.140830112010715K.140830112010557K.140830112010680K.140830112010684K.140830112010624K.140830112010770K.140830112010706K.140830112010754K.140830112010788K.140830112010760K.140830112010781K.140830112010687K.140830112010767K.140830112010755K.140830112010542K.140830112010582K.140830112010749K.140830112010694K.140830112010750K.140830112010753K.140830112010647K.140830112010657K.140830112010715K.140830112010664K.140830112010679K.140830112010686K.140830112010690K.140830112010699K.140830112010702K.140830112010656K.140830112010765K.140830112010734K.140830112010707K.140830112010748K.140830112010667K.140830112010638K.140830112010674K.140830112010669K.140830112010662K.140830112010649K.140830112010644K.140830112010640K.140830112010596K.140830112010739K.140830112010696K.140830112010700K.140830112010743K.140830112010695K.140830112010697K.140830112010673K.140830112010691K.140830112010641K.140830112010639K.140830112010641K.140830112010654K.140830112010652K.140830112010671K.140830112010655K.140830112010208K.140830112010524K.140830112010792K.140830112010632K.140830112010653K.140830112010721K.140830112010595K.140830112010633K.140830112010720K.140830112010787K.140830112010772K.140830112010576K.140830112010510K.140830112010521K.140830112010637K.140830112010786K.140830112010719K.140830112010728K.140830112010773K.140830112010705K.140830112010746K.140830112010588K.140830112010677K.140830112010591K.140830112010745K.140830112010729K.140830112010722K.140830112010725K.140830112010663K.140830112010713K.140830112010727K.140830112010709K.140830112010676K.140830112010643K.140830112010718K.140830112010650K.140830112010692K.140830112010587K.140830112010590K.140830112010689K.140830112010683K.140830112010747K.140830112010784K.140830112010775K.140830112010763K.140830112010785K.140830112010777K.140830112010711K.140830112010774K.140830112010761K.140830112010712K.140830112010698K.140830112010634K.140830112010730K.140830112010708K.140830112010703K.140830112010693K.140830112010682K.140830112010681K.140830112010672K.140830112010766K.140830112010658K.140830112010659K.140830112010651K.140830112010646K.140830112010594K.140830112010579K.140830112010628K.140830112010642K.140830112010645K.140830112010598K.140830112010592K.140830112010580K.140830112010685K.140830112010670K.140830112010678K.140830112010675K.140830112010668K.140830112010815K.140830112010635K.140830112010648K.140830112010636K.140830112010631K.140830112010803K.140830112010835K.140830112010816K.140830112010636K.140830112010797K.140830112010891K.140830112010846K.140830112010710K.140830112010841K.140830112010814K.140830112010882K.140830112010848K.140830112010794K.140830112010845K.140830112010721K.140830112010723K.140830112010714K.140830112010806K.140830112010511K.140830112010800K.140830112010818K.140830112010884K.140830112010866K.140830112010895K.140830112010836K.140830112010808K.140830112010893K.140830112010892K.140830112010799K.140830112010589K.140830112010795K.140830112010854K.140830112010868K.140830112010894K.140830112010778K.140830112010849K.140830112010832K.140830112010880K.140830112010889K.140830112010812K.140830112010802K.140830112010888K.140830112010879K.140830112010850K.140830112010851K.140830112010726K.140830112010724K.140830112010756K.140830112010838K.140830112010871K.140830112010883K.140830112010862K.140830112010885K.140830112010809K.140830112010766K.140830112010856K.140830112010867K.140830112010833K.140830112010813K.140830112010793K.140830112010789K.140830112010783K.140830112010664K.140830112010872K.140830112010870K.140830112010874K.140830112010807K.140830112010810K.140830112010828K.140830112010863K.140830112010864K.140830112010762K.140830112010790K.140830112010855K.140830112010886K.140830112010875K.140830112010873K.140830112010860K.140830112010890K.140830112010887K.140830112010844K.140830112010953K.140830112010920K.140830112010907K.140830112010698K.140830112010995K.140830112011006K.140830112010961K.140830112010925K.140830112010947K.140830112010934K.140830112010861K.140830112010869K.140830112010928K.140830112010923K.140830112010943K.140830112010949K.140830112010945K.140830112010908K.140830112011007K.140830112010948K.140830112010964K.140830112010992K.140830112010960K.140830112010912K.140830112010915K.140830112010896K.140830112010730K.140830112010985K.140830112010942K.140830112010994K.140830112010696K.140830112010909K.140830112010904K.140830112010913K.140830112010916K.140830112010905K.140830112011011K.140830112010958K.140830112010990K.140830112010998K.140830112010974K.140830112010979K.140830112010977K.140830112010919K.140830112010982K.140830112010955K.140830112010926K.140830112010932K.140830112010965K.140830112010921K.140830112010922K.140830112010902K.140830112010981K.140830112011001K.140830112011003K.140830112010980K.140830112010877K.140830112010937K.140830112010936K.140830112010899K.140830112010976K.140830112010858K.140830112010665K.140830112010978K.140830112010950K";
			return $arrdata;
		}
	}
	
	function set_mapping_kode($id){
		if(array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt = get_instance();
			$sipt->load->model("main","main", true);
			$ret = "";
			$query = "SELECT KODE_SAMPEL, dbo.FORMAT_NOMOR('SPL', KODE_SAMPEL) AS UR_KODE, KODE_SAMPEL, UJI_KIMIA, JUMLAH_KIMIA, UJI_MIKRO, JUMLAH_MIKRO, JUMLAH_SAMPEL, SISA, dbo.FORMAT_NOMOR('SPL',SUBSTRING(KODE_SAMPEL,1,16)) AS UR_NEW_KODE, SUBSTRING(KODE_SAMPEL,1,16) AS NEW_KODE FROM T_M_SAMPEL WHERE KODE_SAMPEL = '".$id."'";
			$data = $sipt->main->get_result($query);
			$ret = "";
			if($data){
				/*foreach($query->result_array() as $row){
					$kodesampel = $row['KODE_SAMPEL'];
					$newkodesampel = $row['NEW_KODE'];
					$jmlsetelah = $row['JUMLAH_KIMIA'] + $row['JUMLAH_MIKRO'];
					$ret = "OK#<li>";
					$ret .= "<h2 class=\"small garis\">Data Sampel</h2>";
					$ret .= "<table class=\"form_tabel\">";
					$ret .= "<tr><td class=\"td_left\">Kode Sampel</td><td class=\"td_right\">".$row['UR_KODE']."</td></tr>";
					$ret .= "<tr><td class=\"td_left\">Kode Sampel Baru</td><td class=\"td_right\">".$row['UR_NEW_KODE']."</td></tr>";
					$ret .= "<tr><td class=\"td_left\">Jumlah Kimia</td><td class=\"td_right\">".$row['JUMLAH_KIMIA']."</td></tr>";
					$ret .= "<tr><td class=\"td_left\">Jumlah Kimia Setelah Direvisi</td><td class=\"td_right\">".$jmlsetelah."</td></tr>";
					$ret .= "<tr><td class=\"td_left\">Uji Kimia</td><td class=\"td_right\">".($row['UJI_KIMIA'] == 1 ? '&radic; Diuji Kimia' : 'Tidak Diuji Kimia')."</td></tr>";
					$ret .= "<tr><td class=\"td_left\">Jumlah Mikro</td><td class=\"td_right\">".$row['JUMLAH_MIKRO']."</td></tr>";
					$ret .= "<tr><td class=\"td_left\">Uji Mikro</td><td class=\"td_right\">".($row['UJI_MIKRO'] == 1 ? '&radic; Diuji Mikro' : 'Tidak Diuji Mikro')."</td></tr>";
					$ret .= "<tr><td class=\"td_left\">Jumlah Sampel</td><td class=\"td_right\">".$row['JUMLAH_SAMPEL']."</td></tr>";
					$ret .= "</table>";
					$ret .= "<div style=\"height:5px;\">&nbsp;</div>";
					
					$arrsampel = array("KODE_SAMPEL" => $newkodesampel,
									   "UJI_MIKRO" => "0",
									   "STATUS_MIKRO" => "0",
									   "JUMLAH_MIKRO" => "0",
									   "HASIL_MIKRO" => "",
									   "JUMLAH_KIMIA" => $jmlsetelah); 
					$this->db->where("KODE_SAMPEL", $kodesampel);
					$retspl = $this->db->update('T_M_SAMPEL', $arrsampel);
					if($retspl){
						$ret .= "<div>".$this->db->affected_rows().", affected rows [Sampel - Updated]</div>";
						$arrsampellog = array("KODE_SAMPEL" => $newkodesampel);
						$this->db->where("KODE_SAMPEL", $kodesampel);
						$retspllog = $this->db->update("T_SAMPLING_LOG", $arrsampellog);
						if($retspllog){
							$ret .= "<div>".$this->db->affected_rows().", affected rows [Sampling Log - Updated]</div>";
						}
					}				   
					
					$qsps = "SELECT dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) AS UR_KODE, A.KODE_SAMPEL, A.SPU_ID, A.USER_ID, A.STATUS, B.NAMA_USER FROM T_SAMPEL_MT A LEFT JOIN T_USER B ON A.USER_ID = B.USER_ID WHERE A.KODE_SAMPEL = '".$row['KODE_SAMPEL']."'";					
					$dtsps = $sipt->main->get_result($qsps);
					if($dtsps){
						$ret .= "<h2 class=\"small garis\">Data Disposisi Sampel</h2>";
						$arrmt = array();
						foreach($qsps->result_array() as $rsps){
							if(!array_key_exists($rsps['BID'], $arrmt)) $arrmt[$rsps['USER_ID']] = $rsps['USER_ID'];
							$ret .= "<table class=\"form_tabel\">";
							$ret .= "<tr><td class=\"td_left\">Kode Sampel</td><td class=\"td_right\">".$rsps['UR_KODE']."</td></tr>";
							$ret .= "<tr><td class=\"td_left\">Manager Teknis</td><td class=\"td_right\">".$rsps['NAMA_USER']."</td></tr>";
							$ret .= "</table>";
						}
						$spu = $rsps['SPU_ID'];
						$user = "'".join("','", $arrmt)."'"; 
						$ret .= "<div style=\"height:5px;\">&nbsp;</div>";
						$qnewsps = "SELECT DISTINCT(USER_ID) AS USER_ID, LEFT(SARANA_MEDIA_ID, 2) AS BID FROM T_USER_ROLE WHERE USER_ID IN (".$user.") AND LEFT(SARANA_MEDIA_ID, 2) = 'B1' GROUP BY USER_ID, SARANA_MEDIA_ID";
						$dtnewsps = $sipt->main->get_result($qnewsps);
						if($dtnewsps){
							$ret .= "<h2 class=\"small garis\">Data Baru Disposisi Sampel</h2>";
							foreach($qnewsps->result_array() as $rnewsps){
								$ret .= "<div>Record Baru</div>";
								$ret .= "<table class=\"form_tabel\">";
								$ret .= "<tr><td class=\"td_left\">Kode Sampel</td><td class=\"td_right\">".$newkodesampel."</td></tr>";
								$ret .= "<tr><td class=\"td_left\">Nomor SPU</td><td class=\"td_right\">".$spu."</td></tr>";
								$ret .= "<tr><td class=\"td_left\">User ID</td><td class=\"td_right\">".$rnewsps['USER_ID']."</td></tr>";
								$ret .= "<tr><td class=\"td_left\">Status</td><td class=\"td_right\">".$rsps['STATUS']."</td></tr>";
								$ret .= "</table>";
								$mt = $rnewsps['USER_ID'];
								$arrsps = array("SPU_ID" => $spu,
												"KODE_SAMPEL" => $newkodesampel,
												"USER_ID" => $rnewsps['USER_ID'],
												"STATUS" => $rnewsps['STATUS']);
								$retsps = $this->db->insert("T_SAMPEL_MT", $arrsps);
								if($retsps){
									$ret .= "<div>".$this->db->affected_rows().", affected rows [Disposisi Sampel - Updated]</div>";
								}
								
							}
							$this->db->where('KODE_SAMPEL', $kodesampel);
							$retdsps = $this->db->delete('T_SAMPEL_MT');
							if($retdsps){
								$ret .= "<div>".$this->db->affected_rows().", affected rows [Disposisi Sampel - Deleted]</div>";
							}
							$ret .= "<table class=\"form_tabel\">";
							$ret .= "<tr><td class=\"td_left\">Kode Sampel Sebelum</td><td class=\"td_right\">".$kodesampel."</td></tr>";
							$ret .= "</table>";
							
							$spkm = $sipt->main->get_uraian("SELECT SPK_ID FROM T_SPK WHERE KODE_SAMPEL = '".$kodesampel."' AND SUBSTRING(SPK_ID,13,1) = 'M'","SPK_ID");
							$qspk = "SELECT SPK_ID, KODE_SAMPEL, SPU_ID, BBPOM_ID, KOMODITI, CONVERT(VARCHAR(10), TANGGAL, 103) AS TANGGAL, KASIE, STATUS, CREATE_BY, CONVERT(VARCHAR(10), CREATE_DATE, 103) AS CREATE_DATE FROM T_SPK WHERE KODE_SAMPEL = '".$kodesampel."' AND SUBSTRING(SPK_ID,13,1) = 'K'";
							$dtspk = $sipt->main->get_result($qspk);
							if($dtspk){
								$ret .= "<h2 class=\"small garis\">Data SPK Baru</h2>";
								foreach($qspk->result_array() as $rspk){
									$ret .= "<table class=\"form_tabel\">";
									$ret .= "<tr><td class=\"td_left\">Kode Sampel</td><td class=\"td_right\">".$newkodesampel."</td></tr>";
									$ret .= "<tr><td class=\"td_left\">SPK</td><td class=\"td_right\">".$rspk['SPK_ID']."</td></tr>";
									$ret .= "<tr><td class=\"td_left\">Nomor SPU</td><td class=\"td_right\">".$rspk['SPU_ID']."</td></tr>";
									$ret .= "<tr><td class=\"td_left\">BBPOM ID</td><td class=\"td_right\">".$rspk['BBPOM_ID']."</td></tr>";
									$ret .= "<tr><td class=\"td_left\">Komoditi</td><td class=\"td_right\">".$rspk['KOMODITI']."</td></tr>";
									$ret .= "<tr><td class=\"td_left\">Tanggal</td><td class=\"td_right\">".$rspk['TANGGAL']."</td></tr>";
									$ret .= "<tr><td class=\"td_left\">Kasie</td><td class=\"td_right\">".$rspk['KASIE']."</td></tr>";
									$ret .= "<tr><td class=\"td_left\">Status</td><td class=\"td_right\">".$rspk['STATUS']."</td></tr>";
									$ret .= "<tr><td class=\"td_left\">Create By</td><td class=\"td_right\">".$rspk['CREATE_BY']."</td></tr>";
									$ret .= "<tr><td class=\"td_left\">Create Date</td><td class=\"td_right\">".$rspk['CREATE_DATE']."</td></tr>";
									$ret .= "</table>";
									$arrspk = array("SPK_ID" => $rspk['SPK_ID'],
													"KODE_SAMPEL" => $newkodesampel,
													"SPU_ID" => $spu,
													"BBPOM_ID" => $rspk['BBPOM_ID'],
													"KOMODITI" => $rspk['KOMODITI'],
													"TANGGAL" => $rspk['TANGGAL'],
													"KASIE" => $rspk['KASIE'],
													"STATUS" => $rspk['STATUS'],
													"CREATE_BY" => $rspk['CREATE_BY'],
													"CREATE_DATE" => $rspk['CREATE_DATE']);
									$retspk = $this->db->insert('T_SPK', $arrspk);
									if($retspk){
										$ret .= "<div>".$this->db->affected_rows().", affected rows [Surat Perintah Kerja - Inserted]</div>";
									}				
								}
								
								$this->db->where('KODE_SAMPEL', $kodesampel);
								$retdsps = $this->db->delete('T_SPK');
								if($retdsps){
									$ret .= "<div>".$this->db->affected_rows().", affected rows [Surat Perintah Kerja - Deleted]</div>";
								}
								
								$qjparameter = $sipt->main->get_uraian("SELECT COUNT(*) JMLPARAMETER FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL = '".$kodesampel."'","JMLPARAMETER");
								$jpkimia = $sipt->main->get_uraian("SELECT COUNT(*) JMLPARAMETER FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL = '".$kodesampel."' AND SUBSTRING(SPK_ID,13,1) = 'K'","JMLPARAMETER");
								$jpmikro = $sipt->main->get_uraian("SELECT COUNT(*) JMLPARAMETER FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL = '".$kodesampel."' AND SUBSTRING(SPK_ID,13,1) = 'M'","JMLPARAMETER");
								$ret .= "<h2 class=\"small garis\">Parameter Uji</h2>";
								$ret .= "<table class=\"form_tabel\">";
								$ret .= "<tr><td class=\"td_left\">Jumlah Parameter yang diuji</td><td class=\"td_right\">".$qjparameter."</td></tr>";
								$ret .= "<tr><td class=\"td_left\">Parameter Uji Kimia</td><td class=\"td_right\">".$jpkimia."</td></tr>";
								$ret .= "<tr><td class=\"td_left\">Parameter Uji Mikro</td><td class=\"td_right\">".$jpmikro."</td></tr>";
								$ret .= "</table>";
								
								$arrparameter = array("KODE_SAMPEL" => $newkodesampel);
								$this->db->where('SPK_ID' , $rspk['SPK_ID']);
								$this->db->where('KODE_SAMPEL' , $kodesampel);
								$retparam = $this->db->update('T_PARAMETER_HASIL_UJI', $arrparameter);
								if($retparam){
									$ret .= "<div>".$this->db->affected_rows().", affected rows [Parameter Hasil Uji - Inserted]</div>";
								}
								
								$sqlparams = "DELETE FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL = '".$kodesampel."' AND SUBSTRING(SPK_ID, 13,1) = 'M'";
								if($this->db->simple_query($sqlparams)){
									$ret .= "<div>".$this->db->affected_rows().", affected rows [Parameter Hasil Uji - Deleted]</div>";
								}
								
								$ret .= "<table class=\"form_tabel\">";
								$ret .= "<tr><td class=\"td_left\">SPK Mikro</td><td class=\"td_right\">".$spkm."</td></tr>";
								$ret .= "</table>";	
								
								$qcp = "SELECT DISTINCT A.CP_ID, A.KODE_SAMPEL, A.BBPOM_ID, A.HASIL, A.CATATAN, A.MT, CONVERT(VARCHAR(10), A.PEJABAT_TANGGAL,103) AS PEJABAT_TANGGAL, A.CREATE_BY, CONVERT(VARCHAR(10), A.CREATE_DATE, 103) AS CREATE_DATE, A.UPDATE_BY, CONVERT(VARCHAR(10), A.LAST_UPDATE,103) AS LAST_UPDATE, A.STATUS, B.NAMA_USER FROM T_CP A LEFT JOIN T_USER B ON A.MT = B.USER_ID WHERE A.KODE_SAMPEL = '".$kodesampel."' AND A.MT = '".$mt."'";
								$dtcp = $sipt->main->get_result($qcp);
								if($dtcp){
									$ret .= "<h2 class=\"small garis\">Data Catatan Pengujian</h2>";
									foreach($qcp->result_array() as $rcp){
										$ret .= "<table class=\"form_tabel\">";
										$ret .= "<tr><td class=\"td_left\">CP ID</td><td class=\"td_right\">".$rcp['CP_ID']."</td></tr>";
										$ret .= "<tr><td class=\"td_left\">Kode Sampel</td><td class=\"td_right\">".$newkodesampel."</td></tr>";
										$ret .= "<tr><td class=\"td_left\">BBPOM ID</td><td class=\"td_right\">".$rcp['BBPOM_ID']."</td></tr>";
										$ret .= "<tr><td class=\"td_left\">Hasil</td><td class=\"td_right\">".$rcp['HASIL']."</td></tr>";
										$ret .= "<tr><td class=\"td_left\">Catatan</td><td class=\"td_right\">".$rcp['CATATAN']."</td></tr>";
										$ret .= "<tr><td class=\"td_left\">Manager Teknis</td><td class=\"td_right\">".$rcp['MT']."</td></tr>";
										$ret .= "<tr><td class=\"td_left\">Nama Manager Teknis</td><td class=\"td_right\">".$rcp['NAMA_USER']."</td></tr>";
										$ret .= "<tr><td class=\"td_left\">Pejabat Tanggal</td><td class=\"td_right\">".$rcp['PEJABAT_TANGGAL']."</td></tr>";
										$ret .= "<tr><td class=\"td_left\">Create By</td><td class=\"td_right\">".$rcp['CREATE_BY']."</td></tr>";
										$ret .= "<tr><td class=\"td_left\">Create Date</td><td class=\"td_right\">".$rcp['CREATE_DATE']."</td></tr>";
										$ret .= "<tr><td class=\"td_left\">Update By</td><td class=\"td_right\">".$rcp['UPDATE_BY']."</td></tr>";
										$ret .= "<tr><td class=\"td_left\">Last Update</td><td class=\"td_right\">".$rcp['LAST_UPDATE']."</td></tr>";								
										$ret .= "<tr><td class=\"td_left\">Status</td><td class=\"td_right\">".$rcp['STATUS']."</td></tr>";
										$ret .= "</table>";
										$arrcp = array("CP_ID" => $rcp['CP_ID'],
													   "KODE_SAMPEL" => $newkodesampel,
													   "BBPOM_ID" => $rcp['BBPOM_ID'],
													   "HASIL" => $rcp['HASIL'],
													   "CATATAN" => $rcp['CATATAN'],
													   "MT" => $rcp['CATATAN'],
													   "PEJABAT_TANGGAL" => $rcp['PEJABAT_TANGGAL'],
													   "CREATE_BY" => $rcp['CREATE_BY'],
													   "CREATE_DATE" => $rcp['CREATE_DATE'],
													   "UPDATE_BY" => $rcp['UPDATE_BY'],
													   "LAST_UPDATE" => $rcp['LAST_UPDATE'],
													   "STATUS" => $rcp['STATUS']);
										if($this->db->insert('T_CP', $arrcp)){
											$ret .= "<div>".$this->db->affected_rows().", affected rows [Catatan Pengujian - Inserted]</div>";
										}		   
									}
									$sqlcp = "DELETE FROM T_CP WHERE KODE_SAMPEL = '".$kodesampel."'";
									if($this->db->simple_query($sqlcp)){
										$ret .= "<div>".$this->db->affected_rows().", affected rows [Catatan Pengujian - Deleted]</div>";
									}
									
									$qlhu = "SELECT A.LHU_ID, CP_ID, A.CREATE_BY, CONVERT(VARCHAR(10), A.CREATE_DATE,103) AS CREATE_DATE, B.NAMA_USER FROM T_LHU A LEFT JOIN T_USER B ON A.CREATE_BY = B.USER_ID WHERE A.CP_ID = '".$rcp['CP_ID']."' AND CREATE_BY = '".$rcp['MT']."'";
									$dtlhu = $sipt->main->get_result($qlhu);
									if($dtlhu){
										$ret .= "<h2 class=\"small garis\">Data Laporan Hasil Uji</h2>";
										foreach($qlhu->result_array() as $rlhu){
											$ret .= "<table class=\"form_tabel\">";
											$ret .= "<tr><td class=\"td_left\">LHU ID</td><td class=\"td_right\">".$rlhu['LHU_ID']."</td></tr>";
											$ret .= "<tr><td class=\"td_left\">CP ID</td><td class=\"td_right\">".$rlhu['CP_ID']."</td></tr>";
											$ret .= "<tr><td class=\"td_left\">Create By</td><td class=\"td_right\">".$rlhu['CREATE_BY']."</td></tr>";
											$ret .= "<tr><td class=\"td_left\">Create Date</td><td class=\"td_right\">".$rlhu['CREATE_DATE']."</td></tr>";
											$ret .= "<tr><td class=\"td_left\">Nama Manajer Teknis</td><td class=\"td_right\">".$rlhu['NAMA_USER']."</td></tr>";
											$ret .= "</table>";
											
											$sqlcp = "DELETE FROM T_LHU WHERE CP_ID = '".$rcp['CP_ID']."'";
											if($this->db->simple_query($sqlcp)){
												$ret .= "<div>".$this->db->affected_rows().", affected rows [Catatan Pengujian - Deleted]</div>";
											}
											$arrlhu = array("LHU_ID" => $rlhu['LHU_ID'],
															"CP_ID" => $rlhu['CP_ID'],
															"CREATE_BY" => $rlhu['CREATE_BY'],
															"CREATE_DATE" => $rlhu['CREATE_DATE']);
											if($this->db->insert('T_LHU', $arrlhu)){
												$ret .= "<div>".$this->db->affected_rows().", affected rows [Laporan Hasil Pengujian - Inserted]</div>";
											}				
										}
									}

								}
								
							}
						}
						
					}
					$ret .= "</li><li>__________________________________________________________________________________________________________________________________________________________________________________________________</li>#SUKSES";
				}*/
				
				$ret .= "YES#<li>&nbsp;</li>#SUKSES";
			}else{
				$spl = $this->db->query("SELECT dbo.FORMAT_NOMOR('SPL','".$id."') AS UR_KODE FROM T_M_SAMPEL WHERE KODE_SAMPEL = '".$id."'")->row();
				$ret .= "NO#<li>".$id."</li>#GAGAL";
			}
			return $ret;
		}
	}
	
	function get_mapping_attachment(){
		if(array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt = get_instance();
			$sipt->load->model("main","main", true);
			$query = "SELECT KODE_SAMPEL FROM T_M_SAMPEL_RILIS WHERE LAMPIRAN IS NOT NULL";
			$data = $sipt->main->get_result($query);
			if($data){
				foreach($query->result_array() as $row){
					$id[] = $row['KODE_SAMPEL'];
				}
			}
			$arrdata = array('kode' => join('|', $id));
			return $arrdata;
		}
	}
	
	function set_mapping_attachment($id){
		if(array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt = get_instance();
			$sipt->load->model("main","main", true);
			$ret = "";
			$query = "SELECT KODE_SAMPEL, dbo.FORMAT_NOMOR('SPL',KODE_SAMPEL) AS UR_KODE, LAMPIRAN, LTRIM(RTRIM(LAMPIRAN)) AS PJG FROM T_M_SAMPEL WHERE KODE_SAMPEL = '".$id."'";
			$data = $sipt->main->get_result($query);
			$ret = "";
			if($data){
				foreach($query->result_array() as $row){
					if(trim(strlen($row['LAMPIRAN'])) > 0){
						$arr = array('LAMPIRAN' => $row['LAMPIRAN']);
						$this->db->where('KODE_SAMPEL', $id);
						if($this->db->update('T_M_SAMPEL_RILIS', $arr))
						$ret .= "OK#<li>Kode Sampel : ".$row['UR_KODE'].", Lampiran File : ".$row['LAMPIRAN']."</li>#SUKSES";
						else $ret .= "NO#<li>Kode Sampel : ".$row['UR_KODE'].", Tidak terdapat lampiran</li>#GAGAL";
					}else{
						$ret .= "NO#<li>Kode Sampel : ".$row['UR_KODE'].", Tidak terdapat lampiran</li>#GAGAL";
					}
				}
			}else{
				$spl = $this->db->query("SELECT dbo.FORMAT_NOMOR('SPL', KODE_SAMPEL) AS UR_KODE FROM T_M_SAMPEL WHERE KODE_SAMPEL = '".$id."'")->row();
				$ret .= "NO#<li>Tidak ditemukan kode sampel : ".$spl->UR_KODE.", pada disposisi bidang</li>#GAGAL";
			}
			return $ret;
		}
	}
	
	
	function get_mapping_sampel_deleted(){
		if(array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt = get_instance();
			$sipt->load->model("main","main", true);
			$query = "SELECT KODE_SAMPEL FROM T_M_SAMPEL WHERE STATUS_SAMPEL = '00000'";
			$data = $sipt->main->get_result($query);
			if($data){
				foreach($query->result_array() as $row){
					$id[] = $row['KODE_SAMPEL'];
				}
			}
			$arrdata = array('kode' => join('|', $id));
			return $arrdata;
		}
	}
	
	function set_mapping_sampel_deleted($id){
		if(array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt = get_instance();
			$sipt->load->model("main","main", true);
			$ret = "";
			$query = "SELECT A.KODE_SAMPEL, dbo.FORMAT_NOMOR('SPL', A.KODE_SAMPEL) AS UR_KODE, B.NAMA_USER FROM T_SAMPEL_MT A LEFT JOIN T_USER B ON A.USER_ID = B.USER_ID WHERE A.KODE_SAMPEL = '".$id."'";
			$data = $sipt->main->get_result($query);
			$ret = "";
			if($data){
				foreach($query->result_array() as $row){
					$this->db->simple_query("DELETE FROM T_SAMPEL_MT WHERE KODE_SAMPEL ='".$row['KODE_SAMPEL']."'");
					#$this->db->simple_query("DELETE FROM T_SPK WHERE KODE_SAMPEL ='".$row['KODE_SAMPEL']."'");
					#$this->db->simple_query("DELETE FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL ='".$row['KODE_SAMPEL']."'");
					#$this->db->simple_query("DELETE FROM T_CP WHERE KODE_SAMPEL ='".$row['KODE_SAMPEL']."'");
					#$this->db->simple_query("DELETE FROM T_M_SAMPEL_RILIS WHERE KODE_SAMPEL ='".$row['KODE_SAMPEL']."'");
				}
				$ret .= "OK#<li>Kode Sampel : ".$row['UR_KODE'].", Manajer Teknis : ".$row['NAMA_USER']."</li>#SUKSES";
			}else{
				$spl = $this->db->query("SELECT dbo.FORMAT_NOMOR('SPL', KODE_SAMPEL) AS UR_KODE FROM T_M_SAMPEL WHERE KODE_SAMPEL = '".$id."'")->row();
				$ret .= "NO#<li>Tidak ditemukan kode sampel : ".$spl->UR_KODE.", pada disposisi bidang</li>#GAGAL";
			}
			return $ret;
		}
	}
	
	function get_spmt(){
		if(array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt = get_instance();
			$sipt->load->model("main","main", true);
			$query = "SELECT DISTINCT(SPU_ID) AS SPU_ID FROM T_SP_PETUGAS WHERE STATUS = '0'";
			$data = $sipt->main->get_result($query);
			if($data){
				foreach($query->result_array() as $row){
					$id[] = $row['SPU_ID'];
				}
			}
			$arrdata = array('spuid' => join('|', $id));
			return $arrdata;
		}
	}
	
	function get_datadummy(){
		if(array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt = get_instance();
			$sipt->load->model("main","main", true);
			$query = "SELECT KODE_SAMPEL FROM T_KODE_SAMPEL WHERE DOWNLOADED = 0";
			$data = $sipt->main->get_result($query);
			if($data){
				foreach($query->result_array() as $row){
					$id[] = $row['KODE_SAMPEL'];
				}
			}
			$arrdata = array('kode_sampel' => join('|', $id));
			return $arrdata;
		}
	}
	
	function set_spmt($id){
		if(array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt = get_instance();
			$sipt->load->model("main","main", true);
			$petugas = $this->db->query("SELECT USER_ID FROM T_SP_PETUGAS WHERE SPU_ID = '".$id."'")->result_array();
			$qpetugas = "SELECT USER_ID FROM T_SP_PETUGAS WHERE SPU_ID = '".$id."'";
			$dpetugas = $sipt->main->get_result($qpetugas);
			if($dpetugas){
				foreach($qpetugas->result_array() as $rpetugas){
					$arrpetugas [] = $rpetugas['USER_ID'];
				}
			}
			$inuser = "'".join("','", $arrpetugas)."'";
			$qmt = "SELECT DISTINCT(USER_ID), LEFT(SARANA_MEDIA_ID, 2) AS BID FROM T_USER_ROLE WHERE USER_ID IN (".$inuser.") GROUP BY USER_ID, SARANA_MEDIA_ID";
			$dmt = $sipt->main->get_result($qmt);
			$hasil = FALSE;
			if($dmt){
				$arrtmpmt = array();
				$arrbid = array();
				$arrkimia = array();
				$arrmikro = array();
				$jmlkmia = 0;
				$jmlmikro = 0;
				$ret = "";
				foreach($qmt->result_array() as $rmt){
					if(!array_key_exists($rmt['BID'], $arrbid)) $arrbid[$rmt['BID']] = $rmt['BID'];
					if(!array_key_exists($rmt['USER_ID'], $arrtmpmt)) $arrtmpmt[$rmt['USER_ID']] = $rmt['BID'];
				}
				foreach($arrtmpmt as $x => $y){
					if($y == "B1" || $y == "B2"){
						$qkimia = "SELECT KODE_SAMPEL, STATUS_SAMPEL FROM T_M_SAMPEL WHERE SPU_ID = '".$id."' AND UJI_KIMIA = '1'";
						$dtkimia = $sipt->main->get_result($qkimia);
						if($dtkimia){
							foreach($qkimia->result_array() as $rowkimia){
								$spkkimia = $sipt->main->get_uraian("SELECT COUNT(*) AS JML FROM T_SPK WHERE KODE_SAMPEL = '".$rowkimia['KODE_SAMPEL']."' AND SPU_ID = '".$id."' AND CREATE_BY = '".$x."'","JML");
								if($spkkimia > 0)
									$arrstatuskimia = '30201';
								else
									$arrstatuskimia = '40201';
								$arrkimia['SPU_ID'] = $id;
								$arrkimia['KODE_SAMPEL'] = $rowkimia['KODE_SAMPEL'];
								$arrkimia['USER_ID'] = $x;
								$arrkimia['STATUS'] = $arrstatuskimia;
								$jmlkimia++;
								if($this->db->insert('T_SAMPEL_MT', $arrkimia)){
									$hasil = TRUE;
									$ret .= "<li>SPU ID : ".$id.", Kode Sampel : ".$arrkimia['KODE_SAMPEL'].", Manager Teknis : ".$x.", Status Surat Perintah : ".$arrstatuskimia."</li>";
								}
							}
						}else{
							$ret .= "<li>Tidak ditemukan Sampel untuk SPU ID : ".$id.", Bidang Uji Kimia / Fisika</li>";
						}
					}else if($y == "B3"){
						$qmikro = "SELECT KODE_SAMPEL, STATUS_SAMPEL FROM T_M_SAMPEL WHERE SPU_ID = '".$id."' AND UJI_MIKRO = '1'";
						$dtmikro = $sipt->main->get_result($qmikro);
						if($dtmikro){
							foreach($qmikro->result_array() as $rowmikro){
								$spkmikro = $sipt->main->get_uraian("SELECT COUNT(*) AS JML FROM T_SPK WHERE KODE_SAMPEL = '".$rowmikro['KODE_SAMPEL']."' AND SPU_ID = '".$id."' AND CREATE_BY = '".$x."'","JML");
								if($spkmikro > 0)
									$arrstatusmikro = '30201';
								else
									$arrstatusmikro = '40201';
									
								$arrmikro['SPU_ID'] = $id;
								$arrmikro['KODE_SAMPEL'] = $rowmikro['KODE_SAMPEL'];
								$arrmikro['USER_ID'] = $x;
								$arrmikro['STATUS'] = $arrstatusmikro;
								$jmlmikro++;
								if($this->db->insert('T_SAMPEL_MT', $arrmikro)){
									$hasil = TRUE;
									$ret .= "<li>SPU ID : ".$id.", Kode Sampel : ".$arrkimia['KODE_SAMPEL'].", Manager Teknis : ".$x.", Status Surat Perintah : ".$arrstatusmikro."</li>";
								}
							}
						}else{
							$ret .= "<li>Tidak ditemukan Sampel untuk SPU ID : ".$id.", Bidang Uji Mikrobiologi</li>";
						}
					}
				}
			}
			if($hasil){
				$sql = $this->db->query("UPDATE T_SP_PETUGAS SET STATUS = 1 WHERE SPU_ID = '".$id."'");
				return "OK#".$ret."#Sukses";
			}else{
				return "OK#<li>Insert Data :".$id.", Gagal</li>#Gagal";
			}
		}
	}
	
	function get_roolbackspu(){
		if(array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt = get_instance();
			$sipt->load->model("main","main", true);
			$query = "SELECT DISTINCT(SPU_ID) AS SPU_ID FROM T_SP_PETUGAS WHERE USER_ID = ''";
			$data = $sipt->main->get_result($query);
			$arrdata = array();
			if($data){
				foreach($query->result_array() as $row){
					$id[] = $row['SPU_ID'];
				}
				$arrdata['spuid'] = join('|', $id);
			}
			$arrdata['tujuan'] = $sipt->main->combobox("SELECT KODE, URAIAN FROM M_TABEL WHERE JENIS = 'STATUS' AND KODE IN ('50201') ORDER BY 1 DESC","KODE","URAIAN", TRUE);
			return $arrdata;
		}
	}
	
	function set_roolbackspu($id){
		if(array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt = get_instance();
			$sipt->load->model("main","main", true);
			$hasil = FALSE;
			$delete = $this->db->simple_query("DELETE FROM T_SP_PETUGAS WHERE SPU_ID = '".$id."'");
			if($delete){
				$edit = $this->db->simple_query("UPDATE T_SPU SET STATUS = '50201' WHERE SPU_ID = '".$id."'");
				if($edit){
					$this->db->simple_query("UPDATE T_M_SAMPEL SET STATUS_SAMPEL = '50201' WHERE SPU_ID = '".$id."'");
					$hasil = TRUE;
				}
			}
			if($hasil){
				return "OK#".$id.", Berhasil di restore#Sukses";
			}else{
				return "OK#".$id.", Gagal di restore#Gagal";
			}
		}
	}

	function get_spkmt(){
		if(array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt = get_instance();
			$sipt->load->model("main","main", true);
			$query = "SELECT DISTINCT(SPU_ID) FROM T_SAMPEL_MT WHERE DOWNLOADED = '0'";
			$data = $sipt->main->get_result($query);
			if($data){
				foreach($query->result_array() as $row){
					$id[] = $row['SPU_ID'];
				}
			}
			$arrdata = array('spuid' => join('|', $id));
			return $arrdata;
		}
	}

	function get_akhir_uji(){
		if(array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt = get_instance();
			$sipt->load->model("main","main", true);
			$query = "SELECT KODE_SAMPEL FROM T_M_SAMPEL_RILIS WHERE AKHIR_UJI IS NULL";
			$data = $sipt->main->get_result($query);
			if($data){
				foreach($query->result_array() as $row){
					$id[] = $row['KODE_SAMPEL'];
				}
			}
			$arrdata = array('kodesampel' => join('|', $id));
			return $arrdata;
		}
	}
	
	function set_awal_uji($id){
		if(array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt = get_instance();
			$sipt->load->model("main","main", true);
			$query = "SELECT MIN(CONVERT(VARCHAR(10), AWAL_UJI, 103)) AS MINTGL FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL = '".$id."'";
			$tgl = $sipt->main->get_uraian("SELECT MIN(CONVERT(VARCHAR(10), AWAL_UJI, 103)) AS MINTGL FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL = '".$id."'","MINTGL");
			$kode_sampel = $sipt->main->get_uraian("SELECT dbo.FORMAT_NOMOR('SPL','".$id."') AS KODE_SAMPEL","KODE_SAMPEL");
			$this->db->simple_query("SET DATEFORMAT DMY UPDATE T_M_SAMPEL_RILIS SET AWAL_UJI = '".$tgl."' WHERE KODE_SAMPEL = '".$id."'");
			if($this->db->affected_rows() > 0){
				$ret .= "OK#<li>Kode Sampel : ".$kode_sampel.", Awal Uji : ".$tgl."</li>#Sukses ";
			}else{
				$ret .= "NO#<li>Kode Sampel : ".$kode_sampel.", gagal diupdate</li>#Gagal";
			}
			return $ret;
		}
	}

	function set_akhir_uji($id){
		if(array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt = get_instance();
			$sipt->load->model("main","main", true);
			$query = "SELECT MAX(CONVERT(VARCHAR(10), AKHIR_UJI, 103)) AS MAXTGL FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL = '".$id."'";
			$tgl = $sipt->main->get_uraian("SELECT MAX(CONVERT(VARCHAR(10), AKHIR_UJI, 103)) AS MAXTGL FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL = '".$id."'","MAXTGL");
			$kode_sampel = $sipt->main->get_uraian("SELECT dbo.FORMAT_NOMOR('SPL','".$id."') AS KODE_SAMPEL","KODE_SAMPEL");
			$res = $this->db->simple_query("SET DATEFORMAT DMY UPDATE T_M_SAMPEL_RILIS SET AKHIR_UJI = '".$tgl."' WHERE KODE_SAMPEL = '".$id."'");
			if($res){
				$ret .= "OK#<li>Kode Sampel : ".$kode_sampel.", Akhir Uji : ".$tgl."</li>#Sukses";
			}else{
				$ret .= "NO#<li>Kode Sampel : ".$kode_sampel.", gagal diupdate</li>#Gagal";
			}
			return $ret;
		}
	}

	function set_salah_kode($id){
		if(array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt = get_instance();
			$sipt->load->model("main","main", true);
			
			$_1 = FALSE;
			$_2 = FALSE;
			$_3 = FALSE;
			$_4 = FALSE;
			$_5 = FALSE;
			$_6 = FALSE;
			
			$affected = "";
			$query = "SELECT CASE WHEN LEN(KODE_SAMPEL) = 16 THEN SUBSTRING(LEFT(CONVERT(VARCHAR, TANGGAL_SAMPLING, 112), 4),3,4) + SUBSTRING(KODE_SAMPEL,3,17) WHEN LEN(KODE_SAMPEL) = 17 THEN SUBSTRING(LEFT(CONVERT(VARCHAR, TANGGAL_SAMPLING, 112), 4),3,4) + SUBSTRING(KODE_SAMPEL,3,16) END AS NEW_KODE, KODE_SAMPEL FROM T_M_SAMPEL WHERE KODE_SAMPEL = '".$id."'";
			$data = $sipt->main->get_result($query);
			if($data){
				foreach($query->result_array() as $row){
					$old_kode = $row['KODE_SAMPEL'];
					$new_kode = $row['NEW_KODE'];
				}
				
				$affected .= "Update Kode Sampel : " . $old_kode;
				$jmltmsampel = (int)$sipt->main->get_uraian("SELECT COUNT(*) AS JML FROM T_M_SAMPEL WHERE KODE_SAMPEL = '".$old_kode."'","JML");
				if($jmltmsampel > 0){
					$arrtmsampel = array("KODE_SAMPEL" => $new_kode,
										 "KODE_SAMPELX" => $old_kode);
					$this->db->where('KODE_SAMPEL', $id);
					$this->db->update('T_M_SAMPEL', $arrtmsampel);
					if($this->db->affected_rows() == 1){
						$_1 = TRUE;
						$affected .= " => Ada ". $jmltmsampel . " di T_M_SAMPEL";
					}
				}
				
				if($_1){
					$jmltsamplinglog = (int)$sipt->main->get_uraian("SELECT COUNT(*) AS JML FROM T_SAMPLING_LOG WHERE KODE_SAMPEL = '".$id."'","JML");
					if($jmltsamplinglog > 0){
						$arrtsamplinglog = array("KODE_SAMPEL" => $new_kode);
						$this->db->where('KODE_SAMPEL', $id);
						$this->db->update('T_SAMPLING_LOG', $arrtsamplinglog);
						if($this->db->affected_rows() > 0){
							$_2 = TRUE;
							$affected .= "Ada ". $jmltsamplinglog . " di T_SAMPLING_LOG";
						}
					}
				}
				
				if($_2){
					$jmlsampelmt = (int)$sipt->main->get_uraian("SELECT COUNT(*) AS JML FROM T_SAMPEL_MT WHERE KODE_SAMPEL = '".$id."'","JML");
					if($jmlsampelmt > 0){
						$arrtsampelmt = array("KODE_SAMPEL" => $new_kode);
						$this->db->where('KODE_SAMPEL', $id);
						$this->db->update('T_SAMPEL_MT', $arrtsampelmt);
						if($this->db->affected_rows() > 0){
							$_3 = TRUE;
							$affected .= "Ada ". $jmlsampelmt . " di T_SAMPEL_MT";
						}
					}
				}
				
				if($_3){
					$jmltspk = (int)$sipt->main->get_uraian("SELECT COUNT(*) AS JML FROM T_SPK WHERE KODE_SAMPEL = '".$id."'","JML");
					if($jmltspk > 0){
						$arrtspk = array('KODE_SAMPEL' => $new_kode);
						$this->db->where('KODE_SAMPEL', $id);
						$this->db->update('T_SPK', $arrtspk);
						if($this->db->affected_rows() > 0){
							$_4 = TRUE;
							$affected .= "Ada ". $jmltspk . " di T_SAMPLING_LOG";
						}
					}
				}
				
				if($_4){
					$jmltparameteruji = (int)$sipt->main->get_uraian("SELECT COUNT(*) AS JML FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL = '".$id."'","JML");
					if($jmltparameteruji > 0){
						$arrtparameteruji = array('KODE_SAMPEL' => $new_kode);
						$this->db->where('KODE_SAMPEL', $id);
						$this->db->update('T_PARAMETER_HASIL_UJI', $arrtparameteruji);
						if($this->db->affected_rows() > 0){
							$_5 = TRUE;
							$affected .= "Ada ". $jmltparameteruji . " di T_PARAMETER_HASIL_UJI";
						}
					}
				}
				
				if($_5){
					$jmltcp = (int)$sipt->main->get_uraian("SELECT COUNT(*) AS JML FROM T_CP WHERE KODE_SAMPEL = '".$id."'","JML");
					if($jmltcp > 0){
						$arrtcp = array('KODE_SAMPEL' => $new_kode);
						$this->db->where('KODE_SAMPEL', $id);
						$this->db->update('T_CP', $arrtcp);
						if($this->db->affected_rows() > 0){
							$_6 = TRUE;
							$affected .= "Ada ". $jmltcp . " di T_CP";
						}
					}
				}
				
				if($_6){
					$jmltsampelrilis = (int)$sipt->main->get_uraian("SELECT COUNT(*) AS JML FROM T_M_SAMPEL_RILIS WHERE KODE_SAMPEL = '".$id."'","JML");
					if($jmltsampelrilis > 0){
						$arrtmsampelrilis = array('KODE_SAMPEL' => $new_kode);
						$this->db->where('KODE_SAMPEL', $id);
						$this->db->update('T_M_SAMPEL_RILIS', $arrtmsampelrilis);
						if($this->db->affected_rows() > 0){
							$_6 = TRUE;
							$affected .= " , Ada ". $jmltsampelrilis . " di T_M_SAMPEL_RILIS";
						}
					}
				}
				
				
				
				return "OK#<li>".$affected."</li>#Sukses";
			}
			return $ret;
		}
	}

	function set_spkmt($id){
		if(array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt = get_instance();
			$sipt->load->model("main","main", true);
			$ret = "";
			$query = "SELECT SPU_ID, KODE_SAMPEL, USER_ID FROM T_SAMPEL_MT WHERE SPU_ID = '".$id."'";
			$data = $sipt->main->get_result($query);
			if($data){
				foreach($query->result_array() as $row){
					$qspk = $sipt->main->get_uraian("SELECT COUNT(*) AS JML FROM T_SPK WHERE SPU_ID = '".$row['SPU_ID']."' AND KODE_SAMPEL = '".$row['KODE_SAMPEL']."' AND CREATE_BY = '".$row['USER_ID']."'","JML");
					if($qspk > 0){ 
						$sql = "UPDATE T_SAMPEL_MT SET STATUS = '30201', DOWNLOADED = 1 WHERE SPU_ID = '".$row['SPU_ID']."' AND KODE_SAMPEL = '".$row['KODE_SAMPEL']."' AND USER_ID = '".$row['USER_ID']."'";
						$res = $this->db->simple_query($sql);
						if($res){
							$ret .= "<li>Nomor SPU : ".$id.", Kode Sampel : ".$row['KODE_SAMPEL'].", MT : ".$row['USER_ID']." &raquo; syncronized</li>";
						}else{
							$ret .= "<li>Nomor SPU : ".$id.", Kode Sampel : ".$row['KODE_SAMPEL'].", MT : ".$row['USER_ID']." &raquo; update failed</li>";
						}
					}else{
						$ret .= "<li>Nomor SPU : ".$id.", Kode Sampel : ".$row['KODE_SAMPEL'].", MT : ".$row['USER_ID']." &raquo; not syncronized</li>";
					}
				}
			}
			return "OK#".$ret."#Sukses";
		}
	}

	function set_reset($step, $isajax, $id){
		if(array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt = get_instance();
			$sipt->load->model("main","main", true);
			if($step == "first"){
				$kode_balai = $sipt->main->get_uraian("SELECT KODE_BALAI FROM M_NOMOR WHERE BBPOM_ID = '".$this->input->post('cbbalai')."'","KODE_BALAI");
				$kode = strlen($kode_balai) == "2" ? '0'.$kode_balai : $kode_balai; 
				$k = $this->input->post('cbkomoditi');
				if(trim($this->input->post('cbkomoditi'))!=""){
					$komoditi = $sipt->main->get_uraian("SELECT KLASIFIKASI FROM M_GOLONGAN WHERE KLASIFIKASI_ID = '".$this->input->post('cbkomoditi')."'","KLASIFIKASI");
					$ko = $this->input->post('cbkomoditi');	
					$this->db->simple_query("UPDATE M_NOMOR SET SPU_".$k." = 0, SP_".$k." = 0,SPK_".$k." = 0,SPP_".$k." = 0, UJI_".$k." = 0 ,CP_".$k." = 0, LHU_".$k." = 0 WHERE BBPOM_ID = '".$this->input->post('cbbalai')."'");
				}else{
					$komoditi = "SELURUH KOMODITI";
					$ko = "ALL";
					$this->db->simple_query("UPDATE M_NOMOR SET SPU_01 = 0,SPU_03 = 0,SPU_05 = 0,SPU_06 = 0,SPU_07 = 0,SPU_10 = 0,SPU_11 = 0,SPU_12 = 0,SPU_13 = 0, SPU_14 = 0, SPU_20 = 0,SP_01 = 0,SP_03 = 0,SP_05 = 0,SP_06 = 0,SP_07 = 0,SP_10 = 0,SP_11 = 0,SP_12 = 0,SP_13 = 0, SP_14 = 0, SP_20 = 0,SPK_01 = 0,SPK_03 = 0,SPK_05 = 0,SPK_06 = 0,SPK_07 = 0,SPK_10 = 0,SPK_11 = 0,SPK_12 = 0,SPK_13 = 0, SPK_14 = 0, SPK_20 = 0,SPP_01 = 0,SPP_03 = 0,SPP_05 = 0,SPP_06 = 0,SPP_07 = 0,SPP_10 = 0,SPP_11 = 0,SPP_12 = 0,SPP_13 = 0, SPP_14 = 0, SPP_20 = 0,UJI_01 = 0,UJI_03 = 0,UJI_05 = 0,UJI_06 = 0,UJI_07 = 0,UJI_10 = 0,UJI_11 = 0,UJI_12 = 0,UJI_13 = 0, UJI_14 = 0, UJI_20 = 0,CP_01 = 0,CP_03 = 0,CP_05 = 0,CP_06 = 0,CP_07 = 0,CP_10 = 0,CP_11 = 0,CP_12 = 0,CP_13 = 0, CP_14 = 0, CP_20 = 0,LHU_01 = 0,LHU_03 = 0,LHU_05 = 0,LHU_06 = 0,LHU_07 = 0,LHU_10 = 0,LHU_11 = 0,LHU_12 = 0,LHU_13 = 0, LHU_14 = 0, LHU_20 = 0 WHERE BBPOM_ID = '".$this->input->post('cbbalai')."'");
				}
				if(trim($this->input->post('cbanggaran'))!=""){
					$anggaran = $sipt->main->get_uraian("SELECT URAIAN FROM M_TABEL WHERE JENIS = 'ANGGARAN_SAMPLING' AND KODE = '".$this->input->post('cbanggaran')."'","URAIAN");	
					$as = $this->input->post('cbanggaran');
				}else{
					$anggaran = "SELURUH ANGGARAN";
					$as = "KO";
				}
				
				if(trim($this->input->post('cbkomoditi'))=="" && trim($this->input->post('cbanggaran')) == ""){
					$jml = $sipt->main->get_uraian("SELECT COUNT(*) AS JML FROM T_M_SAMPEL WHERE SUBSTRING(KODE_SAMPEL,1,2) = '".substr($this->input->post('ta'),2,4)."' AND SUBSTRING(KODE_SAMPEL,3,3) = '".$kode."'","JML");
					$query = "SELECT KODE_SAMPEL FROM T_M_SAMPEL WHERE SUBSTRING(KODE_SAMPEL,1,2) = '".substr($this->input->post('ta'),2,4)."' AND SUBSTRING(KODE_SAMPEL,3,3) = '".$kode."'";
					$this->db->simple_query("SET DATEFORMAT DMY UPDATE M_REF_SAMPEL SET NOMOR = 0, UPDATED = GETDATE() WHERE BBPOM_ID = '".$this->input->post('cbbalai')."'");
					
				}else if(trim($this->input->post('cbkomoditi')) !="" && trim($this->input->post('cbanggaran')) == ""){
					$jml = $sipt->main->get_uraian("SELECT COUNT(*) AS JML FROM T_M_SAMPEL WHERE SUBSTRING(KODE_SAMPEL,1,2) = '".substr($this->input->post('ta'),2,4)."' AND SUBSTRING(KODE_SAMPEL,3,3) = '".$kode."' AND KOMODITI = '".$this->input->post('cbkomoditi')."'","JML");
					$query = "SELECT KODE_SAMPEL FROM T_M_SAMPEL WHERE SUBSTRING(KODE_SAMPEL,1,2) = '".substr($this->input->post('ta'),2,4)."' AND SUBSTRING(KODE_SAMPEL,3,3) = '".$kode."' AND KOMODITI = '".$this->input->post('cbkomoditi')."'";
					$this->db->simple_query("SET DATEFORMAT DMY UPDATE M_REF_SAMPEL SET NOMOR = 0, UPDATED = GETDATE() WHERE BBPOM_ID = '".$this->input->post('cbbalai')."' AND KOMODITI = '".$this->input->post('cbkomoditi')."'");	
				}else if(trim($this->input->post('cbkomoditi')) =="" && trim($this->input->post('cbanggaran')) != ""){
					$jml = $sipt->main->get_uraian("SELECT COUNT(*) AS JML FROM T_M_SAMPEL WHERE SUBSTRING(KODE_SAMPEL,1,2) = '".substr($this->input->post('ta'),2,4)."' AND SUBSTRING(KODE_SAMPEL,3,3) = '".$kode."' AND ANGGARAN = '".$this->input->post('cbanggaran')."'","JML");
					$query = "SELECT KODE_SAMPEL FROM T_M_SAMPEL WHERE SUBSTRING(KODE_SAMPEL,1,2) = '".substr($this->input->post('ta'),2,4)."' AND SUBSTRING(KODE_SAMPEL,3,3) = '".$kode."' AND ANGGARAN = '".$this->input->post('cbanggaran')."'";
					$this->db->simple_query("SET DATEFORMAT DMY UPDATE M_REF_SAMPEL SET NOMOR = 0, UPDATED = GETDATE() WHERE BBPOM_ID = '".$this->input->post('cbbalai')."' AND ANGGARAN = '".$this->input->post('cbanggaran')."'");	
				}else{
					$jml = $sipt->main->get_uraian("SELECT COUNT(*) AS JML FROM T_M_SAMPEL WHERE SUBSTRING(KODE_SAMPEL,1,2) = '".substr($this->input->post('ta'),2,4)."' AND SUBSTRING(KODE_SAMPEL,3,3) = '".$kode."' AND KOMODITI = '".$this->input->post('cbkomoditi')."' AND ANGGARAN = '".$this->input->post('cbanggaran')."'","JML");
					$query = "SELECT KODE_SAMPEL FROM T_M_SAMPEL WHERE SUBSTRING(KODE_SAMPEL,1,2) = '".substr($this->input->post('ta'),2,4)."' AND SUBSTRING(KODE_SAMPEL,3,3) = '".$kode."' AND KOMODITI = '".$this->input->post('cbkomoditi')."' AND ANGGARAN = '".$this->input->post('cbanggaran')."'";
					$this->db->simple_query("SET DATEFORMAT DMY UPDATE M_REF_SAMPEL SET NOMOR = 0, UPDATED = GETDATE() WHERE BBPOM_ID = '".$this->input->post('cbbalai')."' AND ANGGARAN = '".$this->input->post('cbanggaran')."' AND KOMODITI = '".$this->input->post('cbkomoditi')."'");	
				}
				$data = $sipt->main->get_result($query);
				if($data){
					foreach($query->result_array() as $row){
						$kode_sampel[] = $row['KODE_SAMPEL'];
					}
					$arrdata['kode_sampel'] = join('|', $kode_sampel);
				}
				$arrdata['kodebalai'] = $kode;
				$arrdata['bbpom_id'] = $this->input->post('cbbalai');
				$arrdata['ko'] = $ko;
				$arrdata['ur_ko'] = $komoditi;
				$arrdata['as'] = $as;
				$arrdata['ur_as'] = $anggaran;
				$arrdata['jml'] = $jml;
				$arrdata['ur_ta'] = $this->input->post('ta');
				$arrdata['ta'] = substr($this->input->post('ta'),2,4);
				echo $this->load->view('admin/sampling-pengujian/reset-nomor',$arrdata,true);
			}
			#Step Kedua
			else if($step == "second"){
				$ret = "";
				$spuid = $sipt->main->get_uraian("SELECT SPU_ID FROM T_M_SAMPEL WHERE KODE_SAMPEL = '".$id."'","SPU_ID");
				$del_spu = $this->db->simple_query("DELETE FROM T_SPU WHERE SPU_ID = '".$spuid."'");
				if($del_spu){
					$ret .= "<li>".$this->db->affected_rows().", SPU affected rows</li>";
					$this->db->simple_query("DELETE FROM T_SPU_LOG WHERE SPU_ID = '".$spuid."'");
					$this->db->simple_query("DELETE FROM T_SAMPEL_MT WHERE SPU_ID = '".$spuid."'");
					$this->db->simple_query("DELETE FROM T_SP_PETUGAS WHERE SPU_ID = '".$spuid."'");
				}
				
				$spkid = $sipt->main->get_uraian("SELECT SPK_ID FROM T_SPK WHERE KODE_SAMPEL = '".$id."'","SPK_ID");
				$del_spk = $this->db->simple_query("DELETE FROM T_SPK WHERE KODE_SAMPEL = '".$id."'");
				if($del_spk){
					$ret .= "<li>".$this->db->affected_rows().", SPK / SPP affected rows</li>";
					$this->db->simple_query("DELETE FROM T_SPK_LOG WHERE SPU_ID = '".$spkid."'");
					$this->db->simple_query("DELETE FROM T_SPP WHERE SPK_ID = '".$spkid."'");
				}
				
				
				$cp_id = $sipt->main->get_uraian("SELECT CP_ID FROM T_CP WHERE KODE_SAMPEL = '".$id."'","CP_ID");
				$del_cp = $this->db->simple_query("DELETE FROM T_CP WHERE KODE_SAMPEL = '".$id."'");
				if($del_cp){
					$ret .= "<li>".$this->db->affected_rows().", CP / LCP affected rows</li>";
					$this->db->simple_query("DELETE FROM T_CP_LOG WHERE CP_ID = '".$cp_id."'");
					$this->db->simple_query("DELETE FROM T_LHU WHERE CP_ID = '".$cp_id."'");
				}
				
				$del_pu = $this->db->simple_query("DELETE FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL = '".$id."'");
				if($del_pu){
					$ret .= "<li>".$this->db->affected_rows().", Parameter Uji affected rows</li>";
				}
				
				$del_pnbp = $this->db->simple_query("DELETE FROM T_PNBP_SAMPLING WHERE KODE_SAMPEL = '".$id."'");
				if($del_pnbp){
					$ret .= "<li>".$this->db->affected_rows().", Data PNBP Sampling affected rows</li>";
				}
				$data = $this->db->query("SELECT A.KODE_SAMPEL, A.TUJUAN_SAMPLING, A.KOMODITI, A.ANGGARAN, CASE WHEN SUBSTRING(KODE_SAMPEL,6,2) = '99' THEN '99' ELSE TUJUAN_SAMPLING END AS TUJUAN_SAMPLING, CASE WHEN UJI_KIMIA = 1 AND UJI_MIKRO = 1 THEN 'KM' WHEN UJI_KIMIA = 1 AND UJI_MIKRO = 0 THEN 'K' WHEN UJI_KIMIA = 0 AND UJI_MIKRO = 1 THEN 'M' END AS LAB, A.CREATE_BY, RTRIM(LTRIM(B.BBPOM_ID)) AS BBPOM_ID, A.TANGGAL_SAMPLING FROM T_M_SAMPEL A LEFT JOIN T_PERIKSA_SAMPEL B ON A.PERIKSA_SAMPEL = B.PERIKSA_SAMPEL WHERE KODE_SAMPEL = '".$id."'");
				if($data->num_rows() > 0){
					foreach($data->result_array() as $row){
						$arrtujuan = array("01","02","03","04","05"); 
						if(in_array($row["TUJUAN_SAMPLING"],$arrtujuan)){
							$tujuan = $row["TUJUAN_SAMPLING"];
							$status = "20106";
						}else{
							$tujuan = "99";
							$status = "70000";
						}
						$new = $sipt->main->backup_kode($tujuan, $row['ANGGARAN'], $row['KOMODITI'], $row['LAB'], $row['BBPOM_ID']);
						$sql = $this->db->simple_query("UPDATE T_M_SAMPEL SET KODE_SAMPEL = '".$new."', SPU_ID = '0', STATUS_SAMPEL = '".$status."' WHERE KODE_SAMPEL = '".$id."'");
						if($sql){
							$ret .= '<li>Kode Sampel Lama : ' . $row['KODE_SAMPEL'].', Kode Baru : '.$new.'</li>';
							$arrlog = array("KODE_SAMPEL" => $new,
											"WAKTU" => $row['TANGGAL_SAMPLING'],
											"USER_ID" => $row['CREATE_BY'],
											"KEGIATAN " => "Simpan Data Sampel",
											"CATATAN" => "Simpan data sampel : ".$new);
							$this->db->insert("T_SAMPLING_LOG", $arrlog);			
							$del_log = $this->db->simple_query("DELETE FROM T_M_SAMPEL_LOG WHERE KODE_SAMPEL = '".$id."'");
							if($del_log){
								$ret .= "<li>".$this->db->affected_rows().", Data Log Sampel affected rows</li>";
							}
						}
					}
				}
				return "OK#".$ret."#Sukses";
			}
		}
	}
	
	function set_revisi_nomor($step, $tipe, $isajax){
		if(array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt = get_instance();
			$sipt->load->model("main","main", true);
			if($step == "first"){
				if($tipe == "sampel"){
					$arrdata = array();
					$query = "SELECT dbo.FORMAT_NOMOR('SPL',KODE_SAMPEL) AS KODE_LAMA, KODE_SAMPEL, CASE WHEN UJI_KIMIA = '1' AND UJI_MIKRO = '1' THEN 'Uji Kimia - Mikro' WHEN UJI_KIMIA = '1' THEN 'Uji Kimia' WHEN UJI_MIKRO = '1' THEN 'Uji Mikro' END AS UJI_SAMPEL, JUMLAH_KIMIA, JUMLAH_MIKRO, JUMLAH_SAMPEL, SISA, SATUAN FROM T_M_SAMPEL WHERE dbo.FORMAT_NOMOR('SPL',KODE_SAMPEL) = '".$this->input->post("KODE_SAMPEL")."'";
					$data = $sipt->main->get_result($query);
					if($data){
						foreach($query->result_array() as $row){
							$arrdata['sess'] = $row;
						}
						$arrdata["result"] = TRUE;
					}else{
						$arrdata["result"] = FALSE;
					}
					$arrdata['satuan'] = $sipt->main->combobox("SELECT SATUAN_ID, NAMA_SATUAN FROM M_SATUAN ORDER BY 2 ASC", "NAMA_SATUAN", "NAMA_SATUAN", TRUE);
					echo $this->load->view("admin/sampling-pengujian/setrevisi-kode-sampel",$arrdata, true);
				}
			}else if($step == "second"){
				if($tipe == "sampel"){
					$dtsampel = $sipt->main->post_to_query($this->input->post('REVISI')); 
					$query = "SELECT dbo.FORMAT_NOMOR('SPL',KODE_SAMPEL) AS KODE_LAMA, dbo.FORMAT_NOMOR('SPL',SUBSTRING(KODE_SAMPEL, 1,15)) AS FORMAT_KODE, SUBSTRING(KODE_SAMPEL, 1,15) AS KODE FROM T_M_SAMPEL WHERE KODE_SAMPEL = '".$this->input->post("OLD_KODE")."'";
					$data = $sipt->main->get_result($query);
					$ret = "";
					if($data){
						$ret .= "<ul style=\"list-style:none;\">";
						foreach($query->result_array() as $row){
							if(in_array('M', $this->input->post('lab'))){
								$dtsampel['UJI_KIMIA'] = '0';
								$dtsampel['UJI_MIKRO'] = '1';
							}
							if(in_array('K', $this->input->post('lab'))){
								$dtsampel['UJI_KIMIA'] = '1';
								$dtsampel['UJI_MIKRO'] = '0';
							}
							if(in_array('M', $this->input->post('lab')) && in_array('K', $this->input->post('lab'))){
								$dtsampel['UJI_KIMIA'] = '1';
								$dtsampel['UJI_MIKRO'] = '1';
							}
							$newkode = $row["KODE"].join("",$this->input->post('lab'));
							$dtsampel["KODE_SAMPEL"] = $newkode;
							$this->db->where("KODE_SAMPEL",$this->input->post("OLD_KODE"));
							if($this->db->update("T_M_SAMPEL",$dtsampel)){
								$ret .= "<li><b>Hasil Proses Revisi</b></li>";
								$ret .= "<li>Kode sampel lama : ".$row["KODE_LAMA"]."</li>";
								$ret .= "<li>Kode sampel baru : ".$row["FORMAT_KODE"].join("",$this->input->post('lab'))."</li>";
								$dsampling_log = $this->db->simple_query("UPDATE T_SAMPLING_LOG SET KODE_SAMPEL = '".$newkode."' WHERE KODE_SAMPEL = '".$this->input->post("OLD_KODE")."'");
								if($dsampling_log){
									$ret .= "<li>".$this->db->affected_rows().", Sampling Log affected rows</li>";
								}
								$dpnbp = $this->db->simple_query("UPDATE T_PNBP_SAMPLING SET KODE_SAMPEL = '".$newkode."' WHERE KODE_SAMPEL = '".$this->input->post("OLD_KODE")."'");
								if($dpnbp){
									$ret .= "<li>".$this->db->affected_rows().", PNBP affected rows</li>";
								}
								$dspumt = $this->db->simple_query("UPDATE T_SAMPEL_MT SET KODE_SAMPEL = '".$newkode."' WHERE KODE_SAMPEL = '".$this->input->post("OLD_KODE")."'");
								if($dspumt ){
									$ret .= "<li>".$this->db->affected_rows().", SPU Manajer Teknis affected rows</li>";
								}
								$dspk = $this->db->simple_query("UPDATE T_SPK SET KODE_SAMPEL = '".$newkode."' WHERE KODE_SAMPEL = '".$this->input->post("OLD_KODE")."'");
								if($dspk){
									$ret .= "<li>".$this->db->affected_rows().", SPK affected rows</li>";
								}
								$dparams = $this->db->simple_query("UPDATE T_PARAMETER_HASIL_UJI SET KODE_SAMPEL = '".$newkode."' WHERE KODE_SAMPEL = '".$this->input->post("OLD_KODE")."'");
								if($dparams){
									$ret .= "<li>".$this->db->affected_rows().", Parameter Hasil Uji affected rows</li>";
								}
								$dcp = $this->db->simple_query("UPDATE T_CP SET KODE_SAMPEL = '".$newkode."' WHERE KODE_SAMPEL = '".$this->input->post("OLD_KODE")."'");
								if($dcp){
									$ret .= "<li>".$this->db->affected_rows().", Catatan Hasil Uji affected rows</li>";
								}
							}
						}
						$ret .= "</ul>";
						return $ret;
					}
				}
			}
		}
	}
	
	function set_migrasidummy($kodesampel){
		if(array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt = get_instance();
			$sipt->load->model("main","main", true);
			$query = "SELECT A.*, CASE WHEN SUBSTRING(KODE_SAMPEL,6,2) = '99' THEN '99' ELSE TUJUAN_SAMPLING END AS FTUJUAN_SAMPLING, 
CASE WHEN UJI_KIMIA = 1 AND UJI_MIKRO = 1 THEN 'KM' WHEN UJI_KIMIA = 1 AND UJI_MIKRO = 0 THEN 'K' WHEN UJI_KIMIA = 0 AND UJI_MIKRO = 1 THEN 'M' END AS LAB, LTRIM(RTRIM(B.BBPOM_ID)) AS BBPOM_ID, C.NAMA_BBPOM FROM T_M_SAMPEL_TMP A LEFT JOIN T_PERIKSA_SAMPEL B ON A.PERIKSA_SAMPEL = B.PERIKSA_SAMPEL LEFT JOIN M_BBPOM C ON B.BBPOM_ID = C.BBPOM_ID WHERE KODE_SAMPEL = '".$kodesampel."'";
			$data = $sipt->main->get_result($query);
			$ret = "";
			if($data){
				foreach($query->result_array() as $row){
					$arrtujuan = array("01","02","03","04","05"); 
					if(in_array($row["TUJUAN_SAMPLING"],$arrtujuan)){
						$tujuan = $row["TUJUAN_SAMPLING"];
						$status = "20106";
					}else{
						$tujuan = "99";
						$status = "70000";
					}
					$new = $sipt->main->backup_kode($tujuan, $row['ANGGARAN'], $row['KOMODITI'], $row['LAB'], $row['BBPOM_ID']);
					$arrsampel["PERIKSA_SAMPEL"]= $row["PERIKSA_SAMPEL"]; 
					$arrsampel["KODE_SAMPEL"]= $new; 
					$arrsampel["SPU_ID"]= "0"; 
					$arrsampel["KOMODITI"]= $row["KOMODITI"]; 
					$arrsampel["KATEGORI"] = $row["KATEGORI"]; 
					$arrsampel["ANGGARAN"] = $row["ANGGARAN"]; 
					$arrsampel["ASAL_SAMPEL"] = $row["ASAL_SAMPEL"]; 
					$arrsampel["TUJUAN_SAMPLING"] = $row["TUJUAN_SAMPLING"]; 
					$arrsampel["SUB_TUJUAN"] = $row["SUB_TUJUAN"]; 
					$arrsampel["TANGGAL_SAMPLING"] = $row["TANGGAL_SAMPLING"]; 
					$arrsampel["BULAN_ANGGARAN"] = $row["BULAN_ANGGARAN"]; 
					$arrsampel["SARANA_ID"] = $row["SARANA_ID"]; 
					$arrsampel["TEMPAT_SAMPLING"] = $row["TEMPAT_SAMPLING"]; 
					$arrsampel["ALAMAT_SAMPLING"] = $row["ALAMAT_SAMPLING"]; 
					$arrsampel["KLASIFIKASI_TAMBAHAN"] = $row["KLASIFIKASI_TAMBAHAN"]; 
					$arrsampel["NAMA_SAMPEL"] = $row["NAMA_SAMPEL"]; 
					$arrsampel["NOMOR_REGISTRASI"] = $row["NOMOR_REGISTRASI"]; 
					$arrsampel["PABRIK"] = $row["PABRIK"]; 
					$arrsampel["IMPORTIR"] = $row["IMPORTIR"]; 
					$arrsampel["BENTUK_SEDIAAN"] = $row["BENTUK_SEDIAAN"];
					$arrsampel["KEMASAN"] = $row["KEMASAN"]; 
					$arrsampel["NO_BETS"] = $row["NO_BETS"]; 
					$arrsampel["KETERANGAN_ED"] = $row["KETERANGAN_ED"]; 
					$arrsampel["JUMLAH_SAMPEL"] = $row["JUMLAH_SAMPEL"]; 
					$arrsampel["SATUAN"] = $row["SATUAN"]; 
					$arrsampel["HARGA_SAMPEL"] = $row["HARGA_SAMPEL"]; 
					$arrsampel["UJI_KIMIA"] = $row["UJI_KIMIA"]; 
					$arrsampel["JUMLAH_KIMIA"] = $row["JUMLAH_KIMIA"]; 
					$arrsampel["UJI_MIKRO"] = $row["UJI_MIKRO"]; 
					$arrsampel["JUMLAH_MIKRO"] = $row["JUMLAH_MIKRO"]; 
					$arrsampel["UJI_BIO"] = $row["UJI_BIO"]; 
					$arrsampel["JUMLAH_BIO"] = $row["JUMLAH_BIO"]; 
					$arrsampel["SISA"] = $row["SISA"]; 
					$arrsampel["SISA_KIMIA"] = $row["SISA_KIMIA"]; 
					$arrsampel["SISA_MIKRO"] = $row["SISA_MIKRO"]; 
					$arrsampel["SISA_BIO"] = $row["SISA_BIO"]; 
					$arrsampel["TEMPAT_SISA_KIMIA"] = $row["TEMPAT_SISA_KIMIA"]; 
					$arrsampel["TEMPAT_SISA_MIKRO"] = $row["TEMPAT_SISA_MIKRO"]; 
					$arrsampel["KOMPOSISI"] = $row["KOMPOSISI"]; 
					$arrsampel["NETTO"] = $row["NETTO"]; 
					$arrsampel["KONDISI_SAMPEL"] = $row["KONDISI_SAMPEL"]; 
					$arrsampel["EVALUASI_PENANDAAN"] = $row["EVALUASI_PENANDAAN"];
					$arrsampel["CARA_PENYIMPANAN"] = $row["CARA_PENYIMPANAN"];
					$arrsampel["PEMERIAN"] = $row["PEMERIAN"];
					$arrsampel["SEGEL"] = $row["SEGEL"];
					$arrsampel["LABEL"] = $row["LABEL"];
					$arrsampel["HASIL_KIMIA"] = $row["HASIL_KIMIA"];
					$arrsampel["HASIL_MIKRO"] = $row["HASIL_MIKRO"];
					$arrsampel["HASIL_BIO"] = $row["HASIL_BIO"];
					$arrsampel["HASIL_SAMPEL"] = $row["HASIL_SAMPEL"];
					$arrsampel["UJI_ULANG"] = $row["UJI_ULANG"];
					$arrsampel["LAMPIRAN"] = $row["LAMPIRAN"];
					$arrsampel["CATATAN"] = $row["CATATAN"];
					$arrsampel["CATATAN_CP"] = $row["CATATAN_CP"];
					$arrsampel["STATUS_KIMIA"] = $row["STATUS_KIMIA"];
					$arrsampel["STATUS_MIKRO"] = $row["STATUS_MIKRO"];
					$arrsampel["STATUS_SAMPEL"] = $status;
					$arrsampel["CREATE_BY"] = $row["CREATE_BY"];
					$arrsampel["UPDATE_BY"] = $row["UPDATE_BY"];
					$arrsampel["UPDATE_DATE"] = $row["UPDATE_DATE"];
					$arrsampel["KODE_SAMPELX"] = $row["KODE_SAMPEL"];
					$arrsampel["FLAG"] = 1;
					if($this->db->insert("T_M_SAMPEL", $arrsampel)){
						$ret .= "OK#<li>".$this->db->affected_rows().", Data Sampel affected rows</li>";
						$arrlog = array("KODE_SAMPEL" => $new,
										"WAKTU" => $row['TANGGAL_SAMPLING'],
										"USER_ID" => $row['CREATE_BY'],
										"KEGIATAN " => "Simpan Data Sampel",
										"CATATAN" => "Simpan data sampel : ".$new);
						$this->db->insert("T_SAMPLING_LOG", $arrlog);
						$ret .= "<li>".$this->db->affected_rows().", Data Log Sampel affected rows</li>";
						$this->db->simple_query("UPDATE T_KODE_SAMPEL SET DOWNLOADED = 1 WHERE KODE_SAMPEL = '".$kodesampel."'");
						$ret .= "<li>".$this->db->affected_rows().", Data Dummy affected rows</li>";
						$ret .= "<li>Migrasi Data Sampel : <b>".$kodesampel."</b>, Asal : ".$row["NAMA_BBPOM"]."</li>#Sukses";
						
					}
				}
			}else{
				$query = "SELECT A.*, CASE WHEN SUBSTRING(KODE_SAMPEL,6,2) = '99' THEN '99' ELSE TUJUAN_SAMPLING END AS FTUJUAN_SAMPLING,CASE WHEN UJI_KIMIA = 1 AND UJI_MIKRO = 1 THEN 'KM' WHEN UJI_KIMIA = 1 AND UJI_MIKRO = 0 THEN 'K' WHEN UJI_KIMIA = 0 AND UJI_MIKRO = 1 THEN 'M' END AS LAB, LTRIM(RTRIM(B.BBPOM_ID)) AS BBPOM_ID, C.NAMA_BBPOM FROM T_DUMMY A LEFT JOIN T_PERIKSA_SAMPEL B ON A.PERIKSA_SAMPEL = B.PERIKSA_SAMPEL LEFT JOIN M_BBPOM C ON B.BBPOM_ID = C.BBPOM_ID WHERE KODE_SAMPEL = '".$kodesampel."'";
				$data = $sipt->main->get_result($query);
				if($data){
					foreach($query->result_array() as $row){
						$arrtujuan = array("01","02","03","04","05"); 
						if(in_array($row["TUJUAN_SAMPLING"],$arrtujuan)){
							$tujuan = $row["TUJUAN_SAMPLING"];
							$status = "20106";
						}else{
							$tujuan = "99";
							$status = "70000";
						}
						$new = $sipt->main->backup_kode($tujuan, $row['ANGGARAN'], $row['KOMODITI'], $row['LAB'], $row['BBPOM_ID']);
						$arrsampel["PERIKSA_SAMPEL"]= $row["PERIKSA_SAMPEL"]; 
						$arrsampel["KODE_SAMPEL"]= $new; 
						$arrsampel["SPU_ID"]= "0"; 
						$arrsampel["KOMODITI"]= $row["KOMODITI"]; 
						$arrsampel["KATEGORI"] = $row["KATEGORI"]; 
						$arrsampel["ANGGARAN"] = $row["ANGGARAN"]; 
						$arrsampel["ASAL_SAMPEL"] = $row["ASAL_SAMPEL"]; 
						$arrsampel["TUJUAN_SAMPLING"] = $row["TUJUAN_SAMPLING"]; 
						$arrsampel["SUB_TUJUAN"] = $row["SUB_TUJUAN"]; 
						$arrsampel["TANGGAL_SAMPLING"] = $row["TANGGAL_SAMPLING"]; 
						$arrsampel["BULAN_ANGGARAN"] = $row["BULAN_ANGGARAN"]; 
						$arrsampel["SARANA_ID"] = $row["SARANA_ID"]; 
						$arrsampel["TEMPAT_SAMPLING"] = $row["TEMPAT_SAMPLING"]; 
						$arrsampel["ALAMAT_SAMPLING"] = $row["ALAMAT_SAMPLING"]; 
						$arrsampel["KLASIFIKASI_TAMBAHAN"] = $row["KLASIFIKASI_TAMBAHAN"]; 
						$arrsampel["NAMA_SAMPEL"] = $row["NAMA_SAMPEL"]; 
						$arrsampel["NOMOR_REGISTRASI"] = $row["NOMOR_REGISTRASI"]; 
						$arrsampel["PABRIK"] = $row["PABRIK"]; 
						$arrsampel["IMPORTIR"] = $row["IMPORTIR"]; 
						$arrsampel["BENTUK_SEDIAAN"] = $row["BENTUK_SEDIAAN"];
						$arrsampel["KEMASAN"] = $row["KEMASAN"]; 
						$arrsampel["NO_BETS"] = $row["NO_BETS"]; 
						$arrsampel["KETERANGAN_ED"] = $row["KETERANGAN_ED"]; 
						$arrsampel["JUMLAH_SAMPEL"] = $row["JUMLAH_SAMPEL"]; 
						$arrsampel["SATUAN"] = $row["SATUAN"]; 
						$arrsampel["HARGA_SAMPEL"] = $row["HARGA_SAMPEL"]; 
						$arrsampel["UJI_KIMIA"] = $row["UJI_KIMIA"]; 
						$arrsampel["JUMLAH_KIMIA"] = $row["JUMLAH_KIMIA"]; 
						$arrsampel["UJI_MIKRO"] = $row["UJI_MIKRO"]; 
						$arrsampel["JUMLAH_MIKRO"] = $row["JUMLAH_MIKRO"]; 
						$arrsampel["UJI_BIO"] = $row["UJI_BIO"]; 
						$arrsampel["JUMLAH_BIO"] = $row["JUMLAH_BIO"]; 
						$arrsampel["SISA"] = $row["SISA"]; 
						$arrsampel["SISA_KIMIA"] = $row["SISA_KIMIA"]; 
						$arrsampel["SISA_MIKRO"] = $row["SISA_MIKRO"]; 
						$arrsampel["SISA_BIO"] = $row["SISA_BIO"]; 
						$arrsampel["TEMPAT_SISA_KIMIA"] = $row["TEMPAT_SISA_KIMIA"]; 
						$arrsampel["TEMPAT_SISA_MIKRO"] = $row["TEMPAT_SISA_MIKRO"]; 
						$arrsampel["KOMPOSISI"] = $row["KOMPOSISI"]; 
						$arrsampel["NETTO"] = $row["NETTO"]; 
						$arrsampel["KONDISI_SAMPEL"] = $row["KONDISI_SAMPEL"]; 
						$arrsampel["EVALUASI_PENANDAAN"] = $row["EVALUASI_PENANDAAN"];
						$arrsampel["CARA_PENYIMPANAN"] = $row["CARA_PENYIMPANAN"];
						$arrsampel["PEMERIAN"] = $row["PEMERIAN"];
						$arrsampel["SEGEL"] = $row["SEGEL"];
						$arrsampel["LABEL"] = $row["LABEL"];
						$arrsampel["HASIL_KIMIA"] = $row["HASIL_KIMIA"];
						$arrsampel["HASIL_MIKRO"] = $row["HASIL_MIKRO"];
						$arrsampel["HASIL_BIO"] = $row["HASIL_BIO"];
						$arrsampel["HASIL_SAMPEL"] = $row["HASIL_SAMPEL"];
						$arrsampel["UJI_ULANG"] = $row["UJI_ULANG"];
						$arrsampel["LAMPIRAN"] = $row["LAMPIRAN"];
						$arrsampel["CATATAN"] = $row["CATATAN"];
						$arrsampel["CATATAN_CP"] = $row["CATATAN_CP"];
						$arrsampel["STATUS_KIMIA"] = $row["STATUS_KIMIA"];
						$arrsampel["STATUS_MIKRO"] = $row["STATUS_MIKRO"];
						$arrsampel["STATUS_SAMPEL"] = $status;
						$arrsampel["CREATE_BY"] = $row["CREATE_BY"];
						$arrsampel["UPDATE_BY"] = $row["UPDATE_BY"];
						$arrsampel["UPDATE_DATE"] = $row["UPDATE_DATE"];
						$arrsampel["KODE_SAMPELX"] = $row["KODE_SAMPEL"];
						$arrsampel["FLAG"] = 1;
						if($this->db->insert("T_M_SAMPEL", $arrsampel)){
							$ret .= "OK#<li>".$this->db->affected_rows().", Data Sampel affected rows</li>";
							$arrlog = array("KODE_SAMPEL" => $new,
											"WAKTU" => $row['TANGGAL_SAMPLING'],
											"USER_ID" => $row['CREATE_BY'],
											"KEGIATAN " => "Simpan Data Sampel",
											"CATATAN" => "Simpan data sampel : ".$new);
							$this->db->insert("T_SAMPLING_LOG", $arrlog);
							$ret .= "<li>".$this->db->affected_rows().", Data Log Sampel affected rows</li>";
							$this->db->simple_query("UPDATE T_KODE_SAMPEL SET DOWNLOADED = 1 WHERE KODE_SAMPEL = '".$kodesampel."'");
							$ret .= "<li>".$this->db->affected_rows().", Data Dummy affected rows</li>";
							$ret .= "<li>Migrasi Data Sampel : <b>".$kodesampel."</b>, Asal : ".$row["NAMA_BBPOM"]."</li>#Sukses";
							
						}
					}
				}else{
					$ret = "OK#<li>Tidak ditemukan data dengan Kode Sampel : <b>".$kodesampel."</b></li>#Gagal";
				}
			}
			return $ret;
		}
	}
	
	function set_tps($step, $isajax){
		if(array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt = get_instance();
			$sipt->load->model("main","main", true);
			$hasil = FALSE;
			if($step == "first"){
				$query = "SELECT A.SPU_ID, dbo.FORMAT_NOMOR('SPU', A.SPU_ID) AS F_SPU FROM T_SPU A WHERE dbo.FORMAT_NOMOR('SPU',A.SPU_ID) = '".$this->input->post('spu_id')."'";
				$data = $sipt->main->get_result($query);
				if($data){
					foreach($query->result_array() as $row){
						$arrdata['sess'] = $row;
					}
					$arrdata["result"] = TRUE;
					$arrdata['SPU_ID'] = str_replace(".","",$this->input->post('spu_id'));
					$arrdata['STATUS'] = $this->input->post('cbspu');
					$arrdata['ur_stat'] = $sipt->main->get_uraian("SELECT URAIAN FROM M_TABEL WHERE JENIS = 'STATUS' AND KODE = '".$this->input->post('cbspu')."'","URAIAN");
				}else{
					$arrdata["result"] = FALSE;
				}
				echo $this->load->view('admin/sampling-pengujian/setroolback-spu-tps',$arrdata, true);
			}else if($step == "second"){
				$hasil = FALSE;
				$tujuan = $sipt->main->get_uraian("SELECT URAIAN FROM M_TABEL WHERE JENIS = 'STATUS' AND KODE = '".$this->input->post('STATUS')."'","URAIAN");
				$msgok = "Data SPU berhasil dikembalikan ke : ";
				$msgerr = "Data SPU gagal dikembalikan ke : ";
				$res = $this->db->simple_query("UPDATE T_SPU SET STATUS = '".$this->input->post('STATUS')."' WHERE SPU_ID = '".$this->input->post('SPU_ID')."'");
				if($res){
					$this->db->simple_query("DELETE FROM T_SP_PETUGAS WHERE SPU_ID = '".$this->input->post('SPU_ID')."'");
					$this->db->simple_query("DELETE FROM T_SAMPEL_MT WHERE SPU_ID = '".$this->input->post('SPU_ID')."'");
					$this->db->simple_query("UPDATE T_M_SAMPEL SET STATUS_SAMPEL = '".$this->input->post('STATUS')."' WHERE SPU_ID = '".$this->input->post('SPU_ID')."'");
					$hasil = TRUE;
				}else{
					$hasil = FALSE;
				}
				if($hasil){
					echo $msgok."<b>".$tujuan."</b>";
				}else{
					echo $msgerr."<b>".$tujuan."</b>";
				}
			}
		}
	}
	
	function get_rilis(){
		if(array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt = get_instance();
			$sipt->load->model("main","main", true);
			$query = "SELECT KODE_SAMPEL FROM T_M_SAMPEL_RILIS";
			$data = $sipt->main->get_result($query);
			if($data){
				foreach($query->result_array() as $row){
					$id[] = $row['KODE_SAMPEL'];
				}
			}
			$arrdata = array('kode_sampel' => join('|', $id));
			return $arrdata;
		}
	}
	
	function set_rilis($id){
		if(array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt = get_instance();
			$sipt->load->model("main","main", true);
			$ada = $sipt->main->get_uraian("SELECT COUNT(*) AS JML FROM T_M_SAMPEL WHERE KODE_SAMPEL = '".$id."'","JML");
			if($ada > 0){
				$query = "SELECT dbo.FORMAT_NOMOR('SPL',KODE_SAMPEL) AS UR_KODE, KODE_SAMPEL, STATUS FROM T_M_SAMPEL_RILIS WHERE KODE_SAMPEL = '".$id."'";
				$data = $sipt->main->get_result($query);
				if($data){
					/*$row = $query->row_array(); 
					$sql = "UPDATE T_M_SAMPEL SET STATUS_SAMPEL = '".$row['STATUS']."' WHERE KODE_SAMPEL = '".$id."'";
					$res = $this->db->simple_query($sql);
					if($res){
						$ret .= "OK#<li>".$this->db->affected_rows().", Data Sampel affected rows</li>";
						$ret .= "<li>Kode Sampel <b>".$row['UR_KODE']."</li>#Sukses";
					}else{
						$ret .= "OK#<li>Kode Sampel <b>".$row['UR_KODE']."</li>#GAGAL";
					}*/
					$ret .= "OK#<li>Kode Sampel <b>".$row['UR_KODE']."</li>#Sukses";
				}
			}else{
				$ret .= "OK<li>".$id." Not Found</li>#GAGAL";
			}
			return $ret;
		}
	}

	function get_resort(){
		if(array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt = get_instance();
			$sipt->load->model("main","main", true);
			$arrdata['balai'] = $sipt->main->combobox("SELECT BBPOM_ID, REPLACE(REPLACE(NAMA_BBPOM,'BALAI BESAR POM DI ', ''),'BALAI POM DI ','') AS NAMA_BBPOM FROM M_BBPOM WHERE BBPOM_ID NOT IN('00','91','92','93','94','95','96') ORDER BY 2 ASC","BBPOM_ID","NAMA_BBPOM", TRUE);
			return $arrdata;
		}
	}
	
	function set_sort($step, $isajax, $id){
		if(array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt = get_instance();
			$sipt->load->model("main","main", true);
			$hasil = FALSE;
			if($step == "first"){
				$resno = $this->db->simple_query("UPDATE M_REF_SAMPEL SET NOMOR = 0 WHERE BBPOM_ID = '".$this->input->post('balai')."'");
				if($resno){
					$arrdata['aktif'] = substr(date("Y"),2,4);
					$query = "SELECT A.ID, B.PERIKSA_SAMPEL FROM T_M_SAMPEL A LEFT JOIN T_PERIKSA_SAMPEL B ON A.PERIKSA_SAMPEL = B.PERIKSA_SAMPEL WHERE B.BBPOM_ID = '".$this->input->post('balai')."' AND LEFT(KODE_SAMPEL,2) = '".substr(date("Y"),2,4)."'";
					$data = $sipt->main->get_result($query);
					if($data){
						foreach($query->result_array() as $row){
							$id[] = $row['ID'];
						}
					}
					$arrdata['id'] = join('|', $id);
					echo $this->load->view('admin/sampling-pengujian/set-resort',$arrdata, true);
				}
			}else if($step == "second"){
				$data = $this->db->query("SELECT A.KODE_SAMPEL, A.TUJUAN_SAMPLING, A.KOMODITI, A.ANGGARAN, CASE WHEN SUBSTRING(KODE_SAMPEL,6,2) = '99' THEN '99' ELSE TUJUAN_SAMPLING END AS TUJUAN_SAMPLING, CASE WHEN UJI_KIMIA = 1 AND UJI_MIKRO = 1 THEN 'KM' WHEN UJI_KIMIA = 1 AND UJI_MIKRO = 0 THEN 'K' WHEN UJI_KIMIA = 0 AND UJI_MIKRO = 1 THEN 'M' END AS LAB, RTRIM(LTRIM(B.BBPOM_ID)) AS BBPOM_ID FROM T_M_SAMPEL A LEFT JOIN T_PERIKSA_SAMPEL B ON A.PERIKSA_SAMPEL = B.PERIKSA_SAMPEL WHERE ID = '".$id."'");
				if($data->num_rows() > 0){
					foreach($data->result_array() as $row){
						$arrtujuan = array("01","02","03","04","05"); 
						if(in_array($row["TUJUAN_SAMPLING"],$arrtujuan)){
							$tujuan = $row["TUJUAN_SAMPLING"];
						}else{
							$tujuan = "99";
						}
						$new = $sipt->main->backup_kode($tujuan, $row['ANGGARAN'], $row['KOMODITI'], $row['LAB'], $row['BBPOM_ID']);
						$sql = $this->db->simple_query("UPDATE T_M_SAMPEL SET KODE_SAMPEL = '".$new."', KODE_SAMPELX = '".$row['KODE_SAMPEL']."' WHERE ID = '".$id."'");
						if($sql){
							$ret .= '<li>Kode Sampel Lama : '.$row['KODE_SAMPEL'].', Kode Baru : '.$new.'</li>';
						}
					}
				}
				return "OK#".$ret."#Sukses";
			}
		}
	}
	
	function get_srl(){
		if(array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt = get_instance();
			$sipt->load->model("main","main", true);
			$query = "SELECT ID FROM MAPPING_SRL WHERE FLAG = 1";
			$data = $sipt->main->get_result($query);
			if($data){
				foreach($query->result_array() as $row){
					$id[] = $row['ID'];
				}
			}
			$arrdata = array('id' => join('|', $id));
			return $arrdata;
		}
	}
	
	function set_srl($id){
		if(array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt = get_instance();
			$sipt->load->model("main","main", true);
			$ret = "";
			$query = "SELECT BIDANG_UJI, RTRIM(LTRIM(GOLONGAN)) AS GOLONGAN, KATEGORI_PU, dbo.FIRST_CAPITAL(LTRIM(RTRIM(PARAMETER_UJI))) AS PARAMETER_UJI, PUSTAKA, LTRIM(RTRIM(METODE)) AS METODE, LTRIM(RTRIM(METODE_ANALISA)) AS METODE_ANALISA, SYARAT, RUANG_LINGKUP, REFERENSI, PRIORITAS, PRIORITAS_TAHUN FROM MAPPING_SRL WHERE ID = '".$id."'";
			$data = $this->db->query($query)->result_array();
			if($data){
				$max = (int)$sipt->main->get_uraian("SELECT MAX(SRL_ID) AS MAXID FROM M_SRL","MAXID") + 1;
				$data[0]['SRL_ID'] = $max;
				$data[0]['PARAMETER_UJI'] = str_replace('"','',$data[0]['PARAMETER_UJI']);
				$data[0]['METODE'] = str_replace('"','',$data[0]['METODE']);
				$data[0]['METODE_ANALISA'] = str_replace('"','',$data[0]['METODE_ANALISA']);
				$data[0]['CREATE_DATE'] = 'GETDATE()';
				$data[0]['CREATE_BY'] = 'administrator';
				$data[0]['BBPOM_ID'] = '00';
				$data[0]['STATUS'] = '2';
				if(strlen($data[0]['KATEGORI_PU']) == 0){
					$data[0]['KATEGORI_PU'] = '0';
				}
				$res = $this->db->insert('M_SRL', $data[0]);
				if($res){
					$ret .= "OK#<li>".$this->db->affected_rows().", Data SRL affected rows</li>#SUKSES";
					$this->db->simple_query("UPDATE MAPPING_SRL SET FLAG = '2' WHERE ID = '".$id."'");
				}else{
					$ret .= "OK#<li>Gagal Insert Data SRL</li>#GAGAL";
				}
			}else{
				$ret .= "OK<li>Not Found</li>#GAGAL";
			}
			return $ret;
		}
	}
	
	function set_mutasi($tipe,$action,$isajax){
		if((array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('9', $this->newsession->userdata('SESS_KODE_ROLE'))) && $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt = get_instance();
			$sipt->load->model("main","main", true);
			$hasil = FALSE;
			if($tipe == "mutasi-sarana"){
				$msgok = "Mutasi data pemeriksaan berhasil";
				$msgerr = "Mutasi data pemeriksaan gagal";
				$query = "UPDATE T_PEMERIKSAAN SET CREATE_BY = '".$this->input->post('newnip')."' WHERE CREATE_BY = '".$this->input->post('nip')."' AND BBPOM_ID = '".$this->input->post('bbpomid')."'";
				$res = $this->db->simple_query($query);
				if($res){
					$hasil = TRUE;
				}
				if($hasil)
					return "MSG#YES#$msgok#".site_url().'/home/tools/pemeriksaan-sarana';
				else
					return "MSG#NO#$msgerr";
				
			}
		}
	}
	
	function set_spk_bb($id){
		if(array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt = get_instance();
			$sipt->load->model("main","main", true);
			$arrid = explode(".",$id);
			$qmt = "SELECT DISTINCT(USER_ID), LEFT(SARANA_MEDIA_ID, 2) AS BID FROM T_USER_ROLE WHERE USER_ID IN ('".$arrid[5]."') GROUP BY USER_ID, SARANA_MEDIA_ID";
			$dmt = $sipt->main->get_result($qmt);
			if($dmt){
				$arrbid = array();
				foreach($qmt->result_array() as $rmt){
					if(!array_key_exists($rmt['BID'], $arrbid)) $arrbid[$rmt['BID']] = $rmt['BID'];
				}
			}
			if(in_array('B1',$arrbid) || in_array('B2',$arrbid)){
				$lab = "K";
			}else if(in_array('B3',$arrid)){
				$lab = "M";
			}
			$spk_id = $this->set_kode_spk($arrid[3], $arrid[2], $lab, $arrid[6]);
			if($spk_id){
				$query = "UPDATE T_SPK SET SPK_ID = '".$spk_id."', SPK_OLD = '".$arrid[0]."' WHERE SPK_ID = '".$arrid[0]."' AND KODE_SAMPEL = '".$arrid[1]."' AND BBPOM_ID = '".$arrid[3]."' AND KOMODITI = '".$arrid[2]."' AND CREATE_BY = '".$arrid[5]."' AND CONVERT(VARCHAR(10),CREATE_DATE,105) = '".$arrid[4]."'";
				$hasil = $this->db->simple_query($query);
				if($hasil){
					$this->set_max_spk($arrid[3],$arrid[2]);
					$qparams = "UPDATE T_PARAMETER_HASIL_UJI SET SPK_ID = '".$spk_id."', SPK_OLD = '".$arrid[0]."'  WHERE SPK_ID = '".$arrid[0]."' AND KODE_SAMPEL = '".$arrid[1]."' AND PENYELIA = '".$arrid[7]."'";
					$hparams = $this->db->simple_query($qparams);
					if($hparams){
						$this->db->simple_query("UPDATE T_SPK_LOG SET SPK_ID = '".$spk_id."' WHERE SPK_ID = '".$arrid[0]."' AND USER_ID = '".$arrid[5]."'");
						$this->db->simple_query("UPDATE T_SPK_LOG SET SPK_ID = '".$spk_id."' WHERE SPK_ID = '".$arrid[0]."' AND USER_ID = '".$arrid[7]."'");
					}
					$ret = "OK#<li>SPK ID LAMA : ".$arrid[0].", SPK ID Baru : ".$spk_id."</li>";
				}else{
					$ret = "NO#<li>GAGAL : KODE SAMPEL ".$arrid[1]."</li>";
				}
			}else{
				$ret = "NO#<li>GAGAL : KODE SAMPEL ".$arrid[1]."</li>";
			}
			return $ret;
		}
	}
	
	function set_kode_spk($bbpom,$ko,$lab,$bulan){
		$sipt = get_instance();
		$sipt->load->model("main","main", true);
		$query = "SELECT SPK_$ko AS URUT_SPK FROM M_NOMOR WHERE BBPOM_ID = '".$bbpom."'";
		$urut = (int)$sipt->main->get_uraian($query,"URUT_SPK") + 1;
		$kode_balai = $sipt->main->get_uraian("SELECT KODE_BALAI FROM M_NOMOR WHERE BBPOM_ID = '".$bbpom."'",'KODE_BALAI');
		$kode = strlen($kode_balai) == "2" ? '0'.$kode_balai : $kode_balai;
		$urut = sprintf("%04d", $urut);
		$urut = 'SPK'.$kode.substr(date("Y"),2,4).$bulan.$ko.$lab.$urut;
		return $urut;
	}
	
	function set_max_spk($bbpom,$ko){
		$query = "UPDATE M_NOMOR SET SPK_$ko = SPK_$ko + 1 WHERE BBPOM_ID = '".$bbpom."'";
		$hasil = $this->db->simple_query($query);
		if($hasil)
		return TRUE;
		else 
		return FALSE;
	}
	
	function set_rilis_pusat($id){
		if(array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt = get_instance();
			$sipt->load->model("main","main", true);
			$res = $this->db->simple_query("UPDATE T_M_SAMPEL_RILIS SET STATUS_KIRIM = '1', STATUS_PPOMN = '1', ARSIP_SAMPEL = '1' WHERE STATUS = '80215' AND LTRIM(RTRIM(HASIL_SAMPEL)) = 'MS' AND ARSIP_SAMPEL = '0' AND KODE_SAMPEL = '".$id."'");
			if($res){
				$ret = "OK#<li>".$id." Berhasil diarsipkan</li>#Sukses";
			}else{
				$ret = "NO#<li>".$id.", Gagal diarsipkan</li>#Gagal";
			}
			return $ret;
		}
	}
	
	function set_mapping_sampel($step, $tipe, $isajax){
		if(array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt = get_instance();
			$sipt->load->model("main","main", true);
			if($step == "first"){
				if($tipe == "sampel"){
					$arrdata = array();
					$query = "SELECT dbo.FORMAT_NOMOR('SPL',KODE_SAMPEL) AS KODE_LAMA, KODE_SAMPEL, CASE WHEN UJI_KIMIA = '1' AND UJI_MIKRO = '1' THEN 'Uji Kimia - Mikro' WHEN UJI_KIMIA = '1' THEN 'Uji Kimia' WHEN UJI_MIKRO = '1' THEN 'Uji Mikro' END AS UJI_SAMPEL, KOMODITI, dbo.KATEGORI(KATEGORI) AS UR_KOMODITI, KATEGORI FROM T_M_SAMPEL WHERE dbo.FORMAT_NOMOR('SPL',KODE_SAMPEL) = '".$this->input->post("KODE_SAMPEL")."'";
					$data = $sipt->main->get_result($query);
					if($data){
						foreach($query->result_array() as $row){
							$arrdata['sess'] = $row;
						}
						$arrdata['komoditi'] = $sipt->main->combobox("SELECT KLASIFIKASI_ID, KLASIFIKASI FROM M_GOLONGAN WHERE LEN(KLASIFIKASI_ID) = 2  AND KLASIFIKASI_ID NOT IN ('05','06')", "KLASIFIKASI_ID", "KLASIFIKASI", TRUE);
						$arrdata["result"] = TRUE;
					}else{
						$arrdata["result"] = FALSE;
					}
					echo $this->load->view("admin/sampling-pengujian/result-mapping-sampel",$arrdata, true);
				}
			}else if($step == "second"){
				if($tipe == "sampel"){
					$data = $this->db->query("SELECT A.KODE_SAMPEL, A.TUJUAN_SAMPLING, A.KOMODITI, A.ANGGARAN, CASE WHEN SUBSTRING(KODE_SAMPEL,6,2) = '99' THEN '99' ELSE TUJUAN_SAMPLING END AS TUJUAN_SAMPLING, CASE WHEN UJI_KIMIA = 1 AND UJI_MIKRO = 1 THEN 'KM' WHEN UJI_KIMIA = 1 AND UJI_MIKRO = 0 THEN 'K' WHEN UJI_KIMIA = 0 AND UJI_MIKRO = 1 THEN 'M' END AS LAB, RTRIM(LTRIM(B.BBPOM_ID)) AS BBPOM_ID FROM T_M_SAMPEL A LEFT JOIN T_PERIKSA_SAMPEL B ON A.PERIKSA_SAMPEL = B.PERIKSA_SAMPEL WHERE A.KODE_SAMPEL = '".$this->input->post("OLD_KODE")."'");
					if($data->num_rows() > 0){
						foreach($data->result_array() as $row){
							$arrtujuan = array("01","02","03","04","05"); 
							if(in_array($row["TUJUAN_SAMPLING"],$arrtujuan)){
								$tujuan = $row["TUJUAN_SAMPLING"];
							}else{
								$tujuan = "99";
							}
							$arrkategori = array_filter($this->input->post('KOMODITI'));
							$kategori = $arrkategori[count($arrkategori)-1];
							$komoditi = substr($kategori, 0, 2);
							$arrrekap = $this->input->post('KOMODITI');
							$rekap_komoditi = $arrrekap[1];
							$new = $sipt->main->backup_kode($tujuan, $row['ANGGARAN'], $komoditi, $row['LAB'], $row['BBPOM_ID']);
							$sql = $this->db->simple_query("UPDATE T_M_SAMPEL SET KODE_SAMPEL = '".$new."', KOMODITI = '".$komoditi."', KATEGORI = '".$kategori."', REKAP_KOMODITI = '".$rekap_komoditi."',  KODE_SAMPELX = '".$row['KODE_SAMPEL']."' WHERE KODE_SAMPEL = '".$this->input->post('OLD_KODE')."'");
							if($sql){
								$ret .= '<p>Kode Sampel Lama : '.$row['KODE_SAMPEL'].', Kode Baru : '.$new.'</p>';
								
								$log = $this->db->simple_query("UPDATE T_SAMPLING_LOG SET KODE_SAMPEL = '".$new."' WHERE KODE_SAMPEL = '".$this->input->post('OLD_KODE')."'");
								if($log){
									$ret .= "<p>".$this->db->affected_rows().", Sampel Log affected rows</p>";
								}
								
								$mt = $this->db->simple_query("UPDATE T_SAMPEL_MT SET KODE_SAMPEL = '".$new."' WHERE KODE_SAMPEL = '".$this->input->post('OLD_KODE')."'");
								if($mt){
									$ret .= "<p>".$this->db->affected_rows().", Manajer Teknis affected rows</p>";
								}
								
								$spk = $this->db->simple_query("UPDATE T_SPK SET KODE_SAMPEL = '".$new."' WHERE KODE_SAMPEL = '".$this->input->post('OLD_KODE')."'");
								if($spk){
									$ret .= "<p>".$this->db->affected_rows().", Surat Perintah Kerja affected rows</p>";
								}
								
								$params = $this->db->simple_query("UPDATE T_PARAMETER_HASIL_UJI SET KODE_SAMPEL = '".$new."' WHERE KODE_SAMPEL = '".$this->input->post('OLD_KODE')."'");
								if($params){
									$ret .= "<p>".$this->db->affected_rows().", Parameter Uji affected rows</p>";
								}
								
							}
						}
					}
					return $ret;
				}
			}
		}
	}
	
	function set_mapping_pu($id){
		if(array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt = get_instance();
			$sipt->load->model("main","main", true);
			$ret = "";
			$query = "SELECT ID, RTRIM(LTRIM(GOLONGAN)) AS GOLONGAN, RTRIM(LTRIM(KATEGORI_PU)) AS KATEGORI_PU, RTRIM(LTRIM(PARAMETER_UJI)) AS PARAMETER_UJI, RTRIM(LTRIM(PUSTAKA)) AS PUSTAKA, RTRIM(LTRIM(METODE)) AS METODE FROM MAPPING_SRL WHERE ID = '".$id."'";
			$data = $sipt->main->get_result($query);
			$ret = "";
			if($data){
				foreach($query->result_array() as $row){
					$ret .= "OK#<li>Golongan : ".$row['GOLONGAN'].", Kategori PU : ".$row['KATEGORI_PU'].", Parameter Uji : ".$row['PARAMETER_UJI'].", Pustaka : ".$row['PUSTAKA'].", Metode : ".$row['METODE']."<br>";
					if($row['KATEGORI_PU'] != ""){
						$srl_id = $this->get_existing_srl($row['GOLONGAN'], $row['PARAMETER_UJI'],$row['PUSTAKA'],$row['METODE']);
						$res = $this->db->simple_query("UPDATE M_SRL SET KATEGORI_PU = '".$row['KATEGORI_PU']."' WHERE SRL_ID = '".$srl_id."'");
						if($res)
						$ret .= "SRL ID : ".$srl_id.", New Kategori PU : ".$row['KATEGORI_PU'];
						else $ret .= " Kategori PU : ".$row['KATEGORI_PU'].", Gagal di update";
					}
					$ret .= "</li>#SUKSES";
				}
			}else{
				$ret .= "OK<li>Not Found</li>#GAGAL";
			}
			return $ret;
		}
	}
	
	function get_existing_srl($golongan, $parameter, $pustaka, $metode){
		$sipt = get_instance();
		$sipt->load->model("main","main", true);
		$ret = $sipt->main->get_uraian("SELECT SRL_ID FROM M_SRL WHERE RTRIM(LTRIM(GOLONGAN)) = '".$golongan."' AND RTRIM(LTRIM(PARAMETER_UJI)) = '".$parameter."' AND RTRIM(LTRIM(PUSTAKA)) = '".$pustaka."' AND RTRIM(LTRIM(METODE)) = '".$metode."'","SRL_ID");
		return $ret;
	}
	
	function get_kategori_pu($kategori){
		$sipt = get_instance();
		$sipt->load->model("main","main", true);
		$ret = $sipt->main->get_uraian("SELECT KATEGORI_PU FROM M_KATEGORI_PU WHERE RTRIM(LTRIM(NAMA_KATEGORI_PU)) = '".$kategori."'","KATEGORI_PU");
		return $ret;
	}
	
	function get_rekap(){
		if(array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt = get_instance();
			$sipt->load->model("main","main", true);
			$query = "SELECT TOP 10000 KODE_SAMPEL FROM T_M_SAMPEL_RILIS WHERE REKAP = 0";
			//$query = "SELECT KODE_SAMPEL FROM (SELECT KODE_SAMPEL, COUNT(KODE_SAMPEL) AS JML FROM T_REKAP_TGL_PENGUJIAN GROUP BY KODE_SAMPEL) AS DATA WHERE LEN(DATA.KODE_SAMPEL) = 16 AND DATA.JML = 2";
			$data = $sipt->main->get_result($query);
			if($data){
				foreach($query->result_array() as $row){
					$id[] = $row['KODE_SAMPEL'];
				}
			}
			$arrdata = array('kode' => join('|', $id));
			return $arrdata;
		}
	}
	
	function set_rekap($kode){
		if(array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt = get_instance();
			$sipt->load->model("main","main", true);
			$query = "SELECT A.KODE_SAMPEL, dbo.FORMAT_NOMOR('SPL',A.KODE_SAMPEL) AS UR_KODE_SAMPEL,
				  A.NAMA_SAMPEL, A.KOMODITI, A.BBPOM_ID, 
				  CONVERT(VARCHAR(10), A.TANGGAL_SAMPLING, 103) AS TANGGAL_SAMPLING,
				  CONVERT(VARCHAR(10), C.TANGGAL, 103) AS TGL_SPU,
				  CONVERT(VARCHAR(10), C.TANGGAL_KIRIM, 103) AS TGL_KIRIM_PEMDIK,
				  CONVERT(VARCHAR(10), C.TANGGAL_TERIMA_TPS, 103) AS TGL_TERIMA_TPS,
				  CONVERT(VARCHAR(10), C.TANGGAL_PERINTAH, 103) AS TGL_PERINTAH,
				  CONVERT(VARCHAR(10), C.CREATE_DATE, 103) AS CREATE_SPU,
				  CONVERT(VARCHAR(10), D.TANGGAL, 103) AS TGL_SPK,
				  CONVERT(VARCHAR(10), D.CREATE_DATE, 103) AS CREATE_SPK,
				  CONVERT(VARCHAR(10), E.TANGGAL, 103) AS TGL_SPP,
				  D.SPK_ID, LEFT(RIGHT(D.SPK_ID,5),1) AS BIDANG,
				  CONVERT(VARCHAR(10), A.AWAL_UJI, 103) AS AWAL_UJI,CONVERT(VARCHAR(10), A.AKHIR_UJI, 103) AS AKHIR_UJI
				  FROM T_M_SAMPEL_RILIS A
				  LEFT JOIN T_M_SAMPEL B ON A.KODE_SAMPEL = B.KODE_SAMPEL
				  LEFT JOIN T_SPU C ON B.SPU_ID = C.SPU_ID
				  LEFT JOIN T_SPK D ON B.KODE_SAMPEL = D.KODE_SAMPEL
				  LEFT JOIN T_SPP E ON D.SPK_ID = E.SPK_ID
				  WHERE A.KODE_SAMPEL = '".$kode."'";
			$data = $sipt->main->get_result($query);
			$affected = 0;
			$error = 0;
			$ret = "";
			if($data){
				foreach($query->result_array() as $row){
					$arrdata['SERI'] = (int)$sipt->main->get_uraian("SELECT COUNT(*) AS SERI FROM T_REKAP_TGL_PENGUJIAN WHERE KODE_SAMPEL = '".$row['KODE_SAMPEL']."'","SERI") + 1;
					$arrdata['KODE_SAMPEL'] = $row['KODE_SAMPEL'];
					$arrdata['NAMA_SAMPEL'] = $row['NAMA_SAMPEL'];
					$arrdata['KOMODITI'] = $row['KOMODITI'];
					$arrdata['BBPOM_ID'] = $row['BBPOM_ID'];
					$arrdata['TANGGAL_SAMPLING'] = $row['TANGGAL_SAMPLING'];
					$arrdata['TANGGAL_SPU'] = $row['TGL_SPU'];
					$arrdata['TANGGAL_KIRIM_PEMDIK'] = $row['TGL_KIRIM_PEMDIK'];
					$arrdata['TANGGAL_TERIMA_TPS'] = $row['TGL_TERIMA_TPS'];
					$arrdata['TANGGAL_PERINTAH'] = $row['TGL_PERINTAH'];
					$arrdata['TANGGAL_SPK'] = $row['TGL_SPK'];
					$arrdata['TANGGAL_SPP'] = $row['TGL_SPP'];
					$arrdata['BIDANG'] = $row['BIDANG'];
					$arrdata['AWAL_UJI'] = $row['AWAL_UJI'];
					$arrdata['AKHIR_UJI'] = $row['AKHIR_UJI'];
					
					$queryx = "SELECT CONVERT(VARCHAR(10), A.PEJABAT_TANGGAL, 103) AS TGL_TTD,
							  CONVERT(VARCHAR(10), A.CREATE_DATE, 103) AS CREATE_CP,
							  CONVERT(VARCHAR(10), A.CREATE_DATE, 103) AS TGL_LHU
							  FROM T_CP A 
							  LEFT JOIN T_LHU B ON A.CP_ID = B.CP_ID
							  WHERE A.KODE_SAMPEL = '".$row['KODE_SAMPEL']."'";
					if($sipt->main->get_result($queryx)){
						foreach($queryx->result_array() as $rowx){
							$arrdata['TANGGAL_PEJABAT'] = $rowx['TGL_TTD'];
							$arrdata['TANGGAL_CP'] = $rowx['CREATE_CP'];
							$arrdata['TANGGAL_LHU'] = $rowx['TGL_LHU'];
						}
					}
					
					$ujibidang = $this->db->query("SELECT SPK_ID, MIN(CONVERT(VARCHAR(10),AWAL_UJI,120)) AS AWAL_UJI_BIDANG, MAX(CONVERT(VARCHAR(10),AKHIR_UJI,120)) AS AKHIR_UJI_BIDANG FROM T_PARAMETER_HASIL_UJI WHERE KODE_SAMPEL = '".$row['KODE_SAMPEL']."' AND SPK_ID = '".$row['SPK_ID']."' GROUP BY SPK_ID")->row();
					$awal = explode("-",$ujibidang->AWAL_UJI_BIDANG);
					$awal = $awal[2]."/".$awal[1]."/".$awal[0];
					$akhir = explode("-",$ujibidang->AKHIR_UJI_BIDANG);
					$akhir = $akhir[2]."/".$akhir[1]."/".$akhir[0];
					$arrdata['AWAL_UJI_BIDANG'] = $awal;
					$arrdata['AKHIR_UJI_BIDANG'] = $akhir;
					$this->db->insert('T_REKAP_TGL_PENGUJIAN', $arrdata);
					if($this->db->affected_rows() > 0){
						$affected++;
					}else{
						$error++;
					}
				}
			}
			if($affected > 0){
				$arrupdate = array('REKAP' => 1);
				$this->db->where("KODE_SAMPEL", $kode);
				$this->db->update('T_M_SAMPEL_RILIS', $arrupdate);
				$ret .= "OK#<li>".$row['UR_KODE_SAMPEL']." - ".$affected.", Data kode sampel berhasil di rekap</li>#SUKSES";
			}else{
				$ret .= "OK#<li>Data kode sampel gagal di rekap</li>#GAGAL";
			}
			/*$jml = (int)$sipt->main->get_uraian("SELECT COUNT(*) AS JML FROM T_REKAP_TGL_PENGUJIAN WHERE KODE_SAMPEL = '".$kode."'","JML");
			if($jml > 0){
				$this->db->where('KODE_SAMPEL', $kode);
				$this->db->where('SERI','2');
				$this->db->delete('T_REKAP_TGL_PENGUJIAN');
				if($this->db->affected_rows() > 0){
					$affected = 1;
					$ret .= "OK#<li>".$affected." data double dengan kode sampel ".$kode." berhasil di hapus</li>#SUKSES";
				}else{
					$affected = 0;
					$ret .= "OK#<li>".$affected." data double dengan kode sampel ".$kode." gagal di hapus</li>#GAGAL";
				}
			}*/
			return $ret;
		}
	}

	


}
?>