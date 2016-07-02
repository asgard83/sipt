<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);
class Monitoring_act extends Model{
	
	function list_pirt(){
		if($this->newsession->userdata('SESS_BBPOM_ID') == "97" && $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			$sipt =& get_instance();
			$this->load->model("main", "main", true);
			$this->load->library('newtable');
			$this->newtable->hiddens(array('IDPERIKSA','PERIKSA_ID','SARANA_ID','JENIS_SARANA_ID','CREATE_DATE','LAST_UPDATE'));
			$this->newtable->search(array(array('B.NAMA_SARANA', 'Nama Sarana'),array('{IN}A.PERIKSA_ID IN (SELECT K.PERIKSA_ID FROM T_PEMERIKSAAN_KLASIFIKASI K WHERE K.KK_ID IN(SELECT KK_ID FROM M_KLASIFIKASI_KATEGORI WHERE KK_ID = K.KK_ID AND NAMA_KK {LIKE}))', 'Komoditi'),array('H.NAMA_JENIS_SARANA', 'Jenis Sarana'),array('B.ALAMAT_1', 'Alamat Sarana'),array('CONVERT(VARCHAR(10), A.AWAL_PERIKSA, 120)', 'Tanggal Awal Periksa'),array('CONVERT(VARCHAR(10), A.AKHIR_PERIKSA, 120)', 'Tanggal Akhir Periksa'),array('D.NAMA_BBPOM', 'Balai Pemeriksa'), array('A.HASIL', 'Hasil Pemeriksaan'), array('Z.URAIAN', 'Status Pemeriksaan'),array('{IN}A.PERIKSA_ID IN (SELECT Y.LAPOR_ID FROM T_SURAT_TUGAS_PELAPORAN Y WHERE Y.SURAT_ID IN(SELECT SURAT_ID FROM T_SURAT_TUGAS WHERE SURAT_ID = Y.SURAT_ID AND NOMOR {LIKE}))', 'Nomor Surat Tugas'), array('{IN}A.PERIKSA_ID IN (SELECT PERIKSA_ID FROM T_PEMERIKSAAN_TEMUAN_PRODUK WHERE PERIKSA_ID = A.PERIKSA_ID AND NOMOR_REGISTRASI {LIKE} OR NAMA_PRODUK {LIKE} OR PRODUSEN {LIKE} OR NAMA_PERUSAHAAN {LIKE})', 'Identitas Produk Ditemukan'), array('C.NAMA_USER', 'Nama Petugas Entri')));
			$this->newtable->action(site_url()."/home/monitoring/pemeriksaan-pirt");
			$this->newtable->detail(site_url()."/get/pemeriksaan/set_preview");
			$this->newtable->cidb($this->db);
			$this->newtable->ciuri($this->uri->segment_array());
			$this->newtable->keys(array('IDPERIKSA'));
			$proses['Preview Data'] = array('GET', site_url().'/home/proses', '1');
			$query = "SELECT (CAST(A.SARANA_ID AS VARCHAR) + '/' + A.JENIS_SARANA_ID + '/' + STUFF(dbo.GROUP_KLASIFIKASI(A.PERIKSA_ID),1,1,'') + '/' + CAST(A.PERIKSA_ID AS VARCHAR) + '.' + A.STATUS + '/1') AS IDPERIKSA, A.PERIKSA_ID, A.SARANA_ID, A.JENIS_SARANA_ID, '<a href=\"#\" class=\"row_preview\">'+ LTRIM(RTRIM(REPLACE(UPPER(B.NAMA_SARANA),'-',''))) + '</a><div>'+ REPLACE(B.ALAMAT_1,'\n',' ') +' - '+G.NAMA_PROPINSI+'</div><div><a href=\"#\" class=\"row_riwayat\" record=\"'+CAST(A.PERIKSA_ID AS VARCHAR)+'\">Riwayat Pemeriksaan</a></div>' AS [NAMA SARANA], STUFF(dbo.GROUP_KK(A.PERIKSA_ID),1,1,'') +'<div>'+ dbo.NAMA_JENIS_SARANA(A.JENIS_SARANA_ID) +'</div>' AS KOMODITI, CONVERT(VARCHAR(10), A.AWAL_PERIKSA, 120) + '<div> Sampai Dengan </div>' + CONVERT(VARCHAR(10), A.AKHIR_PERIKSA, 120) AS [TANGGAL PERIKSA], REPLACE(REPLACE(D.NAMA_BBPOM,'BALAI BESAR POM DI', ''),'BALAI POM DI','') AS [BB/BPOM], A.HASIL +'<div>Temuan Produk ('+ (SELECT CAST(COUNT(PERIKSA_ID) AS VARCHAR) FROM T_PEMERIKSAAN_TEMUAN_PRODUK WHERE PERIKSA_ID = A.PERIKSA_ID) +')</div>' AS HASIL, REPLACE(Z.URAIAN,' - ', '<div>') AS [STATUS], A.CREATE_DATE, dbo.GET_HISTORY('PERIKSA',A.PERIKSA_ID)+'<div>'+dbo.GET_HISTORY('CATATAN',A.PERIKSA_ID)+'</div>' AS [UPDATE TERAKHIR], A.LAST_UPDATE FROM T_PEMERIKSAAN A LEFT JOIN M_SARANA B ON A.SARANA_ID = B.SARANA_ID LEFT JOIN T_USER C ON A.CREATE_BY = C.USER_ID LEFT JOIN M_TABEL Z ON A.STATUS = Z.KODE LEFT JOIN M_BBPOM D ON A.BBPOM_ID = D.BBPOM_ID LEFT JOIN M_PROPINSI G ON B.PROPINSI = G.PROPINSI_ID LEFT JOIN M_JENIS_SARANA H ON A.JENIS_SARANA_ID = H.JENIS_SARANA_ID WHERE A.JENIS_SARANA_ID = '01VV' AND Z.JENIS = 'STATUS' AND A.STATUS NOT IN ('00')";
			$this->newtable->width(array('NAMA SARANA' => 250,'KOMODITI' => 150, 'TANGGAL PERIKSA' => 110, 'BB/BPOM' => 110, 'HASIL' => 50, 'STATUS' => 125,'UPDATE TERAKHIR' => 125));
			$this->newtable->columns(array("CAST(A.SARANA_ID AS VARCHAR) + '/' + A.JENIS_SARANA_ID + '/' + STUFF(dbo.GROUP_KLASIFIKASI(A.PERIKSA_ID),1,1,'') + '/' + CAST(A.PERIKSA_ID AS VARCHAR) + '.' + A.STATUS + '/1')", "A.PERIKSA_ID", "A.SARANA_ID", "A.JENIS_SARANA_ID", "'<a href=\"#\" class=\"row_preview\">'+ LTRIM(RTRIM(REPLACE(UPPER(B.NAMA_SARANA),'-',''))) + '</a><div>'+ REPLACE(B.ALAMAT_1,'\n',' ') +' - '+G.NAMA_PROPINSI+'</div><div><a href=\"#\" class=\"row_riwayat\" record=\"'+CAST(A.PERIKSA_ID AS VARCHAR)+'\">Riwayat Pemeriksaan</a></div>' ", "STUFF(dbo.GROUP_KK(A.PERIKSA_ID),1,1,'') +'<div>'+ dbo.NAMA_JENIS_SARANA(A.JENIS_SARANA_ID) +'</div>'", "CONVERT(VARCHAR(10), A.AWAL_PERIKSA, 120) + '<div> Sampai Dengan </div>' + CONVERT(VARCHAR(10), A.AKHIR_PERIKSA, 120)", "REPLACE(REPLACE(D.NAMA_BBPOM,'BALAI BESAR POM DI', ''),'BALAI POM DI','')", array("A.HASIL +'<div>Temuan Produk ('+ (SELECT CAST(COUNT(PERIKSA_ID) AS VARCHAR) FROM T_PEMERIKSAAN_TEMUAN_PRODUK WHERE PERIKSA_ID = A.PERIKSA_ID) +')</div>'",site_url().'/home/produk/view/{IDPERIKSA}'), "REPLACE(Z.URAIAN,' - ', '<div>')","A.CREATE_DATE","dbo.GET_HISTORY('PERIKSA',A.PERIKSA_ID)+'<div>'+dbo.GET_HISTORY('CATATAN',A.PERIKSA_ID)+'</div>'","A.LAST_UPDATE"));
			$this->newtable->orderby(13);
			$this->newtable->sortby("ASC");
			$this->newtable->menu($proses);
			$tabel = $this->newtable->generate($query);
			$arrdata = array('table' => $tabel,
							 'idjudul' => 'judulpmnsarana',	
							 'caption_header' => $judul,
							 'batal' => '',
							 'cancel' => '');
			return $arrdata;
		}
	}
		
}
?>