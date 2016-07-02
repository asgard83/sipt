<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);
class Distribusi_act extends Model{
	function set_bap($sarana,$jenis,$idperiksa,$subid){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$sipt->load->model("main","main", true);
			$func =& get_instance();
			$func->load->model("functions","functions", true);
			$idperiksa = explode(".", $idperiksa);
			/**
			* Check Data Form Lama / Baru 
			* 0 = Data Form Lama
			* 1 = Data Form Baru
			*/
			$is_distribusi_new = (int)$sipt->main->get_uraian("SELECT IS_DISTRIBUSI_NEW FROM T_PEMERIKSAAN WHERE PERIKSA_ID ='".$idperiksa[0]."'","IS_DISTRIBUSI_NEW");
			/**
			*End Check Data Form Lama / Baru
			*/
			$query = "SELECT (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN_DISTRIBUSI_PERBAIKAN WHERE PERIKSA_ID='$idperiksa[0]') AS JML_PERBAIKAN, (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN_PROSES WHERE PERIKSA_ID = '$idperiksa[0]') AS JML_PROSES, (SELECT COUNT(PERIKSA_ID) FROM T_PEMERIKSAAN_TEMUAN_PRODUK WHERE PERIKSA_ID='$idperiksa[0]') AS JUMLAH_TEMUAN, A.SARANA_ID, A.NAMA_SARANA, A.ALAMAT_1, A.ALAMAT_2, A.TELEPON, A.NOMOR_IZIN, A.TANGGAL_IZIN, A.NO_SIK, A.NAMA_PIMPINAN, A.PENANGGUNG_JAWAB, A.NAMA_APA, A.NAMA_PSA, A.NAMA_APOTEKER_PENDAMPING, B.PERIKSA_ID, B.JENIS_SARANA_ID, B.BBPOM_ID,STUFF(dbo.GROUP_KLASIFIKASI(B.PERIKSA_ID),1,1,'') AS KK_ID, CONVERT(VARCHAR(10), B.AWAL_PERIKSA, 103) AS AWAL_PERIKSA, CONVERT(VARCHAR(10), B.AKHIR_PERIKSA, 103) AS AKHIR_PERIKSA, C.TUJUAN_PEMERIKSAAN, C.ASPEK_PENILAIAN, C.HASIL_TEMUAN, C.HASIL_TEMUAN_LAIN, C.CATATAN_HASIL_PEMERIKSAAN, B.HASIL, C.KASUS_POINT_A, C.KASUS_POINT_B, C.KASUS_POINT_D, C.KASUS_POINT_E, C.KASUS_POINT_F, C.KASUS_POINT_G, C.KASUS_POINT_H, C.KLASIFIKASI_PELANGGARAN_MAJOR AS MAJOR, C.KLASIFIKASI_PELANGGARAN_MINOR AS MINOR, C.KLASIFIKASI_PELANGGARAN_CRITICAL AS CRITICAL, KLASIFIKASI_PELANGGARAN_CRITICAL_ABSOLUTE AS CRITICAL_ABSOLUT, C.TINDAK_LANJUT_BALAI, C.DETAIL_TINDAK_LANJUT_BALAI, C.TINDAK_LANJUT_PUSAT, C.DETIL_TINDAK_LANJUT_PUSAT, STUFF(dbo.GROUP_CONCAT(B.PERIKSA_ID),1,1,'') AS SURAT_ID, E.KATEGORI, E.NAMA_PRODUK, E.NAMA_PABRIK, E.NEGARA_ASAL, E.KEMASAN, E.NOMOR_REGISTRASI, E.NO_BATCH, E.TANGGAL_EXPIRE, E.JUMLAH_TEMUAN, E.SATUAN, E.NAMA_PERUSAHAAN, E.ALAMAT_PERUSAHAAN, E.PEMILIK, E.TINDAKAN_PRODUK, E.KETERANGAN_SUMBER, D.URAIAN AS UR_HASIL, B.BBPOM_ID FROM M_SARANA A LEFT JOIN T_PEMERIKSAAN B ON A.SARANA_ID = B.SARANA_ID LEFT JOIN T_PEMERIKSAAN_DISTRIBUSI C ON B.PERIKSA_ID = C.PERIKSA_ID LEFT JOIN T_PEMERIKSAAN_TEMUAN_PRODUK E ON B.PERIKSA_ID = E.PERIKSA_ID LEFT JOIN M_TABEL D ON B.HASIL = D.KODE WHERE B.SARANA_ID='$sarana' AND B.PERIKSA_ID='$idperiksa[0]' AND D.JENIS='HASIL'";
			$data = $sipt->main->get_result($query);
			$bulan = $this->config->config;
			$bulan = $bulan['bulan'];		
			if($data){
				foreach($query->result_array() as $row){
					$temuan_produk[] = $row;
					$tgl = explode('/', $row['AWAL_PERIKSA']);
					$tgla = (int)$tgl[1];
					$tgla = $bulan[$tgla];
					$hari = "$tgl[2]/$tgl[1]/$tgl[0]";
					$arrdata = array('sess' => $row,
									 'temuan_produk' => $temuan_produk,
									 'petugas' => $sipt->main->bap_petugas($idperiksa[0]), 'hari' => $func->functions->get_hari($hari),
									 'awal_periksa' => "$tgl[0] bulan $tgla tahun $tgl[2]");
					$aspek = explode("#", $row['ASPEK_PENILAIAN']);
					$inisal = array("Y", "T");
					$ganti = array("Ya", "Tidak");
					$arrdata['aspek_penilaian'] = str_replace($inisal, $ganti, $aspek); 			  

				}
			}
			
		}		
		$this->load->library('mpdf');
		$headerO = '<div style="text-align:right;">{PAGENO}   /   {nb}</div>';
		$headerE = '<div style="text-align:right;">{PAGENO}   /   {nb}</div>';
		$mpdf=new mPDF('win-1252',array(210,330));
		$mpdf->SetHTMLFooter($headerO);
		$mpdf->SetHTMLFooter($headerE,'E');
		$mpdf->mirrorMargins = true;
		$mpdf->SetAuthor("Bidang TI PIOM");
		$mpdf->SetDisplayMode('fullpage','two');
		
		if($is_distribusi_new == 0)
			$html = $this->load->view('pemeriksaan/bap/dit0133/'.$jenis, $arrdata, true);
		else 
			$html = $this->load->view('pemeriksaan/bap/'.$jenis, $arrdata, true);
		$bap = $this->mpdf->WriteHTML($html);
		$bap = $this->mpdf->Output();
		echo $bap;
	}
	
	function set_tl($sarana,$id,$jenis,$tl){
		if($this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$id = explode(".", $id);
			$tipe_surat = $sipt->main->get_uraian("SELECT PERIHAL FROM T_SURAT_TINDAK_LANJUT WHERE PERIKSA_ID = '".$id[0]."'","PERIHAL");
			$this->load->library('mpdf');
			$query = "SELECT A.NAMA_SARANA, A.ALAMAT_1, B.BBPOM_ID, C.HASIL_TEMUAN, C.TINDAK_LANJUT_BALAI, C.TINDAK_LANJUT_PUSAT, D.NOMOR_SURAT AS [SURAT TL], CONVERT(VARCHAR, D.TANGGAL_SURAT, 105) AS [TANGGAL TL], D.PERIHAL, D.TEMPAT_TTD AS TEMPAT, D.PEJABAT_TTD AS NIP, D.TEMBUSAN, F.NAMA_USER AS [NAMA TTD], F.JABATAN, E.NOMOR AS NOMOR, CONVERT(VARCHAR, E.TANGGAL, 105) AS TANGGAL, Z.URAIAN AS [PERIHAL SURAT], D.LAMPIRAN FROM M_SARANA A LEFT JOIN T_PEMERIKSAAN B ON A.SARANA_ID = B.SARANA_ID LEFT JOIN T_PEMERIKSAAN_DISTRIBUSI C ON B.PERIKSA_ID = C.PERIKSA_ID LEFT JOIN T_SURAT_TINDAK_LANJUT D ON C.PERIKSA_ID = D.PERIKSA_ID LEFT JOIN T_SURAT_TUGAS_PELAPORAN G ON B.PERIKSA_ID = G.LAPOR_ID LEFT JOIN T_SURAT_TUGAS E ON G.SURAT_ID = E.SURAT_ID LEFT JOIN T_USER F ON D.PEJABAT_TTD = F.USER_ID LEFT JOIN M_TABEL Z ON D.PERIHAL = Z.KODE WHERE B.PERIKSA_ID = '$id[0]' AND Z.JENIS = 'JENIS_SURAT'";
			$data = $sipt->main->get_result($query);
			$bulan = $this->config->config;
			$bulan = $bulan['bulan'];		  
			if($data){
				foreach($query->result_array() as $row){
					$tgl = explode('-', $row['TANGGAL TL']);
					$tgla = (int)$tgl[1];
					$tgla = $bulan[$tgla];
					$row['TANGGAL TL'] = "$tgl[0] $tgla $tgl[2]";
					$tgl = explode('-', $row['TANGGAL']);
					$tgla = (int)$tgl[1];
					$tgla = $bulan[$tgla];
					$row['TANGGAL'] = "$tgl[0] $tgla $tgl[2]";
					$arrdata = array('sess' => $row);
				}
			}
			$mpdf=new mPDF('win-1252',array(210,330));
			$mpdf->useOnlyCoreFonts = true;
			$mpdf->SetProtection(array('print'));
			$mpdf->SetAuthor("Bidang TI PIOM");
			$mpdf->SetDisplayMode('fullpage','two');
			$html = $this->load->view('pemeriksaan/tl/distribusi/'.$tipe_surat, $arrdata, true);
			$ret = $this->mpdf->WriteHTML($html);
			$ret = $this->mpdf->Output();
			return $ret;
		}
	}
		
}

?>