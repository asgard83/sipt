<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR); ?>
<style>
body {font-family:font-family: "Times New Roman"; font-size:10pt;}
@page {margin-top: 2.5cm; margin-bottom: 2.5cm; margin-left: 2.5cm; margin-right: 2.5cm;}
h2.judulbap{font-size:14pt; font-weight:bold; text-decoration:underline;}
table td{vertical-align:top; text-align:justify;}
table.tb_temuan{font-size:8pt; border-collapse:collapse; border-spacing:0; width:100%; padding:5px;}
table.tb_temuan tr.header th{border-collapse:collapse; text-align:left; padding:5px; border:1px solid #000; height:35px; vertical-align:top;}
table.tb_temuan td{padding:5px;vertical-align:top; border:1px solid #000;}
table.form_tabel{font-size:8pt; border-collapse:collapse; border-spacing:0; width:100%; padding:5px;}
table.form_tabel td{padding:5px;vertical-align:top; border:1px solid #000;}
table.form_tabel td.isi{font-weight:bold;}
table.form_tabel td.td_no{width:20px;}
table.form_tabel td.td_aspek{width:600px;}
h2.small{font-size:9pt; font-weight:bold;}
</style>
<div style="text-align:center;">
	<div><img src="<?php echo base_url(); ?>images/logobpom_.jpg" /></div>
	<div><h2 class="judulbap">BERITA ACARA PEMERIKSAAN</h2></div>
</div>

<div style="height:5px;">&nbsp;</div>
<div style="text-align:justify;">Pada hari ini <?php echo $hari; ?> tanggal <?php echo $awal_periksa; ?> kami yang bertanda tangan di bawah ini :</div>
<div style="height:5px;">&nbsp;</div>
<table width="100%">
<?php 
$jml_petugas = count($petugas);
$no = 1;
for($z=0; $z<$jml_petugas; $z++){ ?>  
  <tr><td width="20"><?php echo $no; ?>.</td><td width="120">Nama</td><td width="20">:</td><td><?php echo $petugas[$z]['NAMA_PETUGAS']; ?></td></tr>
  <tr><td>&nbsp;</td><td>NIP</td><td>:</td><td><?php echo $petugas[$z]['NIP']; ?></td></tr>
  <tr><td>&nbsp;</td><td>Jabatan</td><td>:</td><td><?php echo $petugas[$z]['JABATAN']; ?></td></tr>
<?php 
$no++;
} ?>
</table>
<div style="height:20px;"></div>
<div style="text-align:justify">Berdasarkan surat tugas dari Kepala <?php echo ucwords(strtolower($petugas[0]['BADAN'])); ?> Nomor : <?php echo $petugas[0]['NOMOR_SURAT']; ?> tanggal <?php echo $petugas[0]['TANGGAL_SURAT']; ?> telah melakukan pemeriksaan terhadap : </div>
<div style="height:20px;"></div>
<table width="100%">
	<tr><td width="200">Nama Sarana</td><td width="20">:</td><td><?php echo $sess['NAMA_SARANA']; ?></td></tr>
	<tr><td width="200">Alamat</td><td width="20">:</td><td><?php echo $sess['ALAMAT_1']; ?></td></tr>
</table>
<div style="height:20px;"></div>
<div style="text-align:justify;">Adapun hasil pemeriksaan sebagaimana tersebut terlampir. </div>
<div style="height:20px;"></div>
<div style="text-align:justify;">Demikian Berita Acara ini dibuat dengan sesungguhnya untuk dapat dipergunakan sebagaimana mestinya. </div>
<div style="height:40px;"></div>
<table style="width:100%">
	<tr><td style="width:50%;">Mengetahui,</td><td style="width:50%;">Yang membuat Berita Acara</td></tr>
	<tr><td height="150">Penanggung Jawab,</td><td>
    <table width="100%">
    <?php 
    $jml = count($petugas);
    $no = 1;
    for($x=0; $x<$jml; $x++){ ?>  
      <tr><td width="20"><?php echo $no; ?>.</td><td><?php echo $petugas[$x]['NAMA_PETUGAS']; ?></td></tr>
    <?php 
    $no++;
    } ?>
    </table></td></tr>
	<tr><td><?php echo $sess['PENANGGUNG_JAWAB']; ?></td><td>&nbsp;</td></tr>
</table>

<pagebreak>
<p><b>Lampiran I</b></p>
<p><b>Sarana yang diperiksa : </b></p>
<table width="100%">
	<tr><td width="200">Nama GFK</td><td width="20">:</td><td><?php echo $sess['NAMA_SARANA']; ?></td></tr>
	<tr><td width="200">Alamat</td><td width="20">:</td><td><?php echo $sess['ALAMAT_1']; ?></td></tr>
	<tr><td width="200">Telepon</td><td width="20">:</td><td><?php if(trim($sess["TELEPON"]) != "") { ?><ul style="list-style-type:decimal; padding-left:20px; margin:0;"><?php $telepon = explode(";", $sess['TELEPON']); echo "<li>".join("</li><li>", $telepon)."</li>"; ?></ul><?php } ?></td></tr>
	<tr><td width="200">Nama Pimpinan</td><td width="20">:</td><td><?php echo $sess['NAMA_PIMPINAN']; ?></td></tr>
	<tr><td width="200">Nama Penanggung Jawab</td><td width="20">:</td><td><?php echo $sess['PENANGGUNG_JAWAB']; ?></td></tr>
	<tr><td width="200">No. SIK</td><td width="20">:</td><td><?php echo $sess['NO_SIK']; ?></td></tr>
</table>
<div style="height:5px;"></div>
<p><b>Informasi Pemeriksaan</b></p>
<table width="100%">
	<tr><td width="200">Tanggal Pemeriksaan</td><td width="20">:</td><td><?php echo $sess['AWAL_PERIKSA']; ?>&nbsp; sampai dengan &nbsp; <?php echo $sess['AKHIR_PERIKSA']; ?></td></tr>
	<tr><td width="200">Tujuan Pemeriksaan</td><td width="20">:</td><td><?php echo $sess['TUJUAN_PEMERIKSAAN']; ?></td></tr>
</table>

<p><b>Hasil Pemeriksaan</b></p>
<table width="100%">
<tr><td width="200">Hasil Kesimpulan</td><td width="20">:</td><td><?php echo $sess['UR_HASIL']; ?></td></tr>
<tr><td>Kesimpulan Detil Pelanggaran</td><td width="20">:</td><td>
<ul style="list-style-type:decimal; padding-left:20px;">
    <li>Jumlah Pelanggaran Minor : <b><?php echo $sess['MINOR']; ?></b></li>
    <li>Jumlah Pelanggaran Major : <b><?php echo $sess['MAJOR']; ?></b></li>
    <li>Jumlah Pelanggaran Critical : <b><?php echo $sess['CRITICAL']; ?></b></li>
</ul>
</td></tr>
<tr><td>Hasil Temuan</td><td width="20">:</td><td>
<?php if(trim($sess['HASIL_TEMUAN']) != ""){ ?><ul style="list-style-type:decimal; padding-left:20px; margin:0;"><?php $temuan = explode("___", $sess['HASIL_TEMUAN']); echo "<li>".join("</li><li>", $temuan)."</li>"; ?></ul><?php } ?>
</td></tr>
<tr><td>Hasil Temuan diluar Aspek Penilaian</td><td width="20">:</td><td><?php echo $sess['HASIL_TEMUAN_LAIN']; ?></td></tr>
<tr><td>Catatan Hasil Pemeriksaan</td><td width="20">:</td><td><?php echo preg_replace('/[^(\x20-\x7F)]*/','',html_entity_decode($sess['CATATAN_HASIL_PEMERIKSAAN'])); ?></td></tr>
</table>

<?php
if(in_array($sess['BBPOM_ID'], $this->config->item('cfg_unit'))){
}else{
	?>
    <p><b>Tindakan Balai</b></p>
<table width="100%">
<tr><td width="200">Saran Tindak Lanjut</td><td width="20">:</td><td><?php if(trim($sess['TINDAK_LANJUT_BALAI']) != ""){ ?><ul style="list-style-type:decimal; padding-left:20px; margin:0;"><?php $tl_balai= explode("#", $sess['TINDAK_LANJUT_BALAI']); echo "<li>".join("</li><li>", $tl_balai)."</li>"; ?></ul><?php } ?></td></tr>
<tr><td>Detail Tindak Lanjut</td><td width="20">:</td><td><?php echo preg_replace('/[^(\x20-\x7F)]*/','',html_entity_decode($sess['DETAIL_TINDAK_LANJUT_BALAI'])); ?></td></tr>
</table>

    <?php
}
?>


<?php if(trim($sess['TINDAK_LANJUT_PUSAT']) != ""){ ?>
<p><b>Tindakan Pusat</b></p>
<table width="100%">
<tr><td width="200">Tindak Lanjut</td><td width="20">:</td><td><?php if(trim($sess['TINDAK_LANJUT_PUSAT']) != ""){ ?><ul style="list-style-type:decimal; padding-left:20px; margin:0;"><?php $tl_pusat = explode("#", $sess['TINDAK_LANJUT_PUSAT']); echo "<li>".join("</li><li>", $tl_pusat)."</li>"; ?></ul><?php } ?></td></tr>
<tr><td>Detail Tindak Lanjut</td><td width="20">:</td><td><?php echo preg_replace('/[^(\x20-\x7F)]*/','',html_entity_decode($sess['DETIL_TINDAK_LANJUT_PUSAT'])); ?></td></tr>
</table>
<?php } ?>

<?php
if($sess['TUJUAN_PEMERIKSAAN'] == "Rutin"){#Tujuan Pemeriksaan Rutin
	if($sess['HASIL'] == "TMK"){#Jika hasil TMK 
		?>
        <pagebreak sheet-size="330mm 210mm" />
        <p><b>Lampiran II</b></p>
        <p>Checklist Aspek Penilaian</p>
                          <h2 class="small">1. Profil Sarana</h2>
                      <table class="form_tabel" group="1. Profil Sarana">
                          <tr><td class="td_no isi">&nbsp;</td><td class="td_aspek isi">ASPEK DAN DETAIL</td><td class="td_kritis isi">TINGKAT KEKRITISAN</td><td class="td_kriteria isi">YA / TIDAK / NA</td></tr>
                          <tr id="point1suba" y="Mempunyai Pedoman CDOB dan Peraturan Perundang-undangan di bidang farmasi (UU Kesehatan, Permenkes terkait, Farmakope Indonesia) terbaru." t="Tidak mempunyai Pedoman CDOB dan Peraturan Perundang-undangan di bidang farmasi (UU Kesehatan, Permenkes terkait, Farmakope Indonesia) terbaru.">
                              <td class="td_no">a.&nbsp;</td><td class="td_aspek">Apakah mempunyai Pedoman CDOB dan Peraturan Perundang-undangan di bidang farmasi (UU Kesehatan, Permenkes terkait, Farmakope Indonesia) terbaru?</td>
                              <td class="td_kritis">Tingkat Kekritisan (M)</td><td class="td_kritis"><?php echo $aspek_penilaian[0]; ?></td>
                          </tr>
                          <tr id="point1subb" y="GFK telah menerapkan sistem mutu (tersedia Protap dari semua aspek CDOB)." t="GFK belum menerapkan sistem mutu (tidak ada Protap dari semua aspek CDOB atau protap belum lengkap).">
                              <td class="td_no">b.&nbsp;</td><td class="td_aspek">Apakah GFK telah menerapkan sistem mutu (tersedia Protap dari semua aspek CDOB)?</td>
                              <td class="td_kritis">Tingkat Kekritisan (M)</td><td class="td_kritis"><?php echo $aspek_penilaian[1]; ?></td>
                          </tr>
                      </table>
                      
                      <h2 class="small">2. Organisasi</h2>
                      <table class="form_tabel" group="2. Organisasi">
                          <tr><td class="td_no isi">&nbsp;</td><td class="td_aspek isi">ASPEK DAN DETAIL</td><td class="td_kritis isi">TINGKAT KEKRITISAN</td><td class="td_kriteria isi">YA / TIDAK / NA</td></tr>
                          <tr id="point2suba" y="Memiliki penanggung jawab yang kualifikasinya sesuai dengan ketentuan ." t="Tidak memiliki penanggung jawab yang kualifikasinya sesuai dengan ketentuan.">
                              <td class="td_no">a.&nbsp;</td><td class="td_aspek">Apakah ada penanggung jawab yang kualifikasinya sesuai dengan ketentuan?</td>
                              <td class="td_kritis">Tingkat Kekritisan (C)</td>
                              <td class="td_kritis"><?php echo $aspek_penilaian[2]; ?></td>
                          </tr>
                          <tr id="point2subb" y="Penanggung jawab bekerja full time di GFK." t="Penanggung jawab tidak bekerja full time di GFK.">
                              <td class="td_no">b.&nbsp;</td><td class="td_aspek">Apakah penanggung jawab bekerja full time di GFK?</td>
                              <td class="td_kritis">Tingkat Kekritisan (C)</td>
                              <td class="td_kritis"><?php echo $aspek_penilaian[3]; ?></td>
                          </tr>
                          <tr id="point2subc" y="Memiliki program pelatihan untuk pegawai sesuai tugas dan fungsinya serta dievaluasi efektifitasnya dan didokumentasikan." t="Tidak memiliki program pelatihan untuk pegawai sesuai tugas dan fungsinya serta tidak dievaluasi efektifitasnya dan didokumentasikan.">
                              <td class="td_no">c.&nbsp;</td><td class="td_aspek">Apakah ada program pelatihan sesuai tugas dan fungsinya serta dievaluasi efektifitasnya dan didokumentasikan?</td>
                              <td class="td_kritis">Tingkat Kekritisan (m)</td>
                              <td class="td_kritis"><?php echo $aspek_penilaian[4]; ?></td>
                          </tr>
                          <tr id="point2subd" y="Pegawai (PJ, bagian gudang, administrasi distribusi obat) pernah mengikuti pelatihan yang sesuai dengan tanggung jawabnya." t="Semua atau sebagian pegawai (PJ, bagian gudang, administrasi distribusi obat) tidak pernah mengikuti pelatihan yang sesuai dengan tanggung jawabnya.">
                              <td class="td_no">d.&nbsp;</td><td class="td_aspek">Apakah personil (PJ, bagian gudang, administrasi distribusi obat) pernah mengikuti pelatihan yang sesuai dengan tanggung jawabnya?</td>
                              <td class="td_kritis">Tingkat Kekritisan (m)</td>
                              <td class="td_kritis"><?php echo $aspek_penilaian[5]; ?></td>
                          </tr>
                      </table>
                      
                      <h2 class="small">3. Bangunan dan Peralatan</h2>
                      <table class="form_tabel" group="3. Bangunan dan Peralatan">
                          <tr><td class="td_no isi">&nbsp;</td><td class="td_aspek isi">ASPEK DAN DETAIL</td><td class="td_kritis isi">TINGKAT KEKRITISAN</td><td class="td_kriteria isi">YA / TIDAK / NA</td></tr>
                          <tr id="point3suba" y="Kebersihan dan kerapian bangunan dijaga serta dipelihara." t="Kebersihan dan kerapian bangunan tidak dijaga serta dipelihara.">
                              <td class="td_no">a.&nbsp;</td><td class="td_aspek">Apakah kebersihan dan kerapian bangunan dijaga serta dipelihara?</td>
                              <td class="td_kritis">Tingkat Kekritisan (m)</td>
                              <td class="td_kritis"><?php echo $aspek_penilaian[6]; ?></td>
                          </tr>
                          <tr id="point3subb" y="Ventilasi di gudang non AC memadai." t="Ventilasi di gudang non AC tidak memadai.">
                              <td class="td_no">b.&nbsp;</td><td class="td_aspek">Apakah ventilasi di ruangan non AC memadai ? </td>
                              <td class="td_kritis">Tingkat Kekritisan (m)</td>
                              <td class="td_kritis"><?php echo $aspek_penilaian[7]; ?></td>
                          </tr>
                          <tr id="point3subc" y="Ruang penyimpanan dilengkapi dengan alat pencatat suhu yang terkalibrasi serta dilakukan monitoring sesuai dengan persyaratan masing-masing produk." t="Ruang penyimpanan tidak dilengkapi dengan alat pencatat suhu yang terkalibrasi serta tidak dilakukan monitoring sesuai dengan persyaratan masing-masing produk.">
                              <td class="td_no">c.&nbsp;</td><td class="td_aspek">Apakah ruang penyimpanan dilengkapi dengan alat pencatat suhu yang terkalibrasi serta dilakukan monitoring sesuai dengan persyaratan masing-masing produk?</td>
                              <td class="td_kritis">Tingkat Kekritisan (M)</td>
                              <td class="td_kritis"><?php echo $aspek_penilaian[8]; ?></td>
                          </tr>
                          <tr id="point3subd" y="Luas ruang penyimpanan dan penerangan memadai." t="Luas ruang penyimpanan dan penerangan tidak memadai.">
                              <td class="td_no">d.&nbsp;</td><td class="td_aspek">Apakah luas ruang penyimpanan dan penerangan memadai?</td>
                              <td class="td_kritis">Tingkat Kekritisan (M)</td>
                              <td class="td_kritis"><?php echo $aspek_penilaian[9]; ?></td>
                          </tr>
                          
                          <tr id="point3sube" y="Tersedia program dan peralatan pengendalian hama dan tikus (pest control) serta didokumentasi." t="Tidak tersedia program dan peralatan pengendalian hama dan tikus (pest control) serta didokumentasi.">
                              <td class="td_no">e.&nbsp;</td><td class="td_aspek">Apakah ada program dan peralatan pengendalian hama dan tikus (pest control) serta didokumentasi? </td>
                              <td class="td_kritis">Tingkat Kekritisan (M)</td>
                              <td class="td_kritis"><?php echo $aspek_penilaian[10]; ?></td>
                          </tr>
                          <tr id="point3subf" y="Tersedia palet atau peralatan lain yang menjamin obat tidak bersentuhan langsung dengan lantai." t="Tidak tersedia palet atau peralatan lain yang menjamin obat tidak bersentuhan langsung dengan lantai.">
                              <td class="td_no">f.&nbsp;</td><td class="td_aspek">Apakah tersedia palet atau peralatan lain yang menjamin obat tidak bersentuhan langsung dengan lantai?</td>
                              <td class="td_kritis">Tingkat Kekritisan (M)</td>
                              <td class="td_kritis"><?php echo $aspek_penilaian[11]; ?></td>
                          </tr>
                          <tr id="point3subg" y="Tersedia peralatan yang memadai untuk memindahkan barang." t="Tidak tersedia peralatan yang memadai untuk memindahkan barang.">
                              <td class="td_no">g.&nbsp;</td><td class="td_aspek">Apakah tersedia peralatan yang memadai untuk memindahkan barang?</td>
                              <td class="td_kritis">Tingkat Kekritisan (m)</td>
                              <td class="td_kritis"><?php echo $aspek_penilaian[12]; ?></td>
                          </tr>
                      </table>
                      
                      <h2 class="small">4. Pengadaan</h2>
                      <table class="form_tabel" group="4. Pengadaan">
                          <tr><td class="td_no isi">&nbsp;</td><td class="td_aspek isi">ASPEK DAN DETAIL</td><td class="td_kritis isi">TINGKAT KEKRITISAN</td><td class="td_kriteria isi">YA / TIDAK / NA</td></tr>
                          <tr id="point4suba" y="Pengadaan dari sumber yang sah." t="Pengadaan bukan dari sumber yang sah.">
                              <td class="td_no">a.&nbsp;</td><td class="td_aspek">Apakah pengadaan dari sumber yang sah?</td>
                              <td class="td_kritis">Tingkat Kekritisan (C)</td>
                              <td class="td_kritis"><?php echo $aspek_penilaian[13]; ?></td>
                          </tr>
                          <tr id="point4subb" y="Memiliki surat pesanan." t="Tidak memiliki surat pesanan.">
                              <td class="td_no">b.&nbsp;</td><td class="td_aspek">Apakah ada surat pesanan? </td>
                              <td class="td_kritis">Tingkat Kekritisan (M)</td>
                              <td class="td_kritis"><?php echo $aspek_penilaian[14]; ?></td>
                          </tr>
                          <tr id="point4subc" y="Surat pesanan ditandatangani oleh penanggung jawab, mencantumkan nama jelas, nomor SIK/SP/NIP dan distempel " t="Surat pesanan tidak ditandatangani oleh penanggung jawab, mencantumkan nama jelas, nomor SIK/SP/NIP dan distempel ">
                              <td class="td_no">c.&nbsp;</td><td class="td_aspek">Apakah surat pesanan ditandatangani oleh penanggung jawab, mencantumkan nama jelas dan nomor SIK/SP/NIP dan distempel?</td>
                              <td class="td_kritis">Tingkat Kekritisan (M)</td>
                              <td class="td_kritis"><?php echo $aspek_penilaian[15]; ?></td>
                          </tr>
                          <tr id="point4subd" y="Surat pesanan diarsipkan berdasarkan nomor urut dan tanggal pemesanan " t="Surat pesanan tidak diarsipkan berdasarkan nomor urut dan tanggal pemesanan ">
                              <td class="td_no">d.&nbsp;</td><td class="td_aspek">Apakah surat pesanan diarsipkan berdasarkan nomor urut dan tanggal pemesanan?</td>
                              <td class="td_kritis">Tingkat Kekritisan (M)</td>
                              <td class="td_kritis"><?php echo $aspek_penilaian[16]; ?></td>
                          </tr>
                          
                          <tr id="point4sube" y="Faktur atau Surat Penyerahan Barang (SPB) diarsipkan berdasarkan tanggal penerimaan oleh penanggung jawab dan atau bagian administrasi." t="Faktur atau Surat Penyerahan Barang (SPB) tidak diarsipkan berdasarkan tanggal penerimaan oleh penanggung jawab dan atau bagian administrasi.">
                              <td class="td_no">e.&nbsp;</td><td class="td_aspek">Apakah faktur atau Surat Penyerahan Barang (SPB), diarsipkan berdasarkan tanggal penerimaan oleh penanggung jawab dan atau bagian administrasi?</td>
                              <td class="td_kritis">Tingkat Kekritisan (M)</td>
                              <td class="td_kritis"><?php echo $aspek_penilaian[17]; ?></td>
                          </tr>
                      </table>
                      
                      <h2 class="small">5. Penerimaan dan Penyimpanan</h2>
                      <table class="form_tabel" group="5. Penerimaan dan Penyimpanan">
                          <tr><td class="td_no isi">&nbsp;</td><td class="td_aspek isi">ASPEK DAN DETAIL</td><td class="td_kritis isi">TINGKAT KEKRITISAN</td><td class="td_kriteria isi">YA / TIDAK / NA</td></tr>
                          <tr id="point5suba" y="Penanggung jawab menandatangani faktur pembelian pada saat barang diterima." t="Penanggung jawab tidak menandatangani faktur pembelian pada saat barang diterima.">
                              <td class="td_no">a.&nbsp;</td><td class="td_aspek">Apakah penanggung jawab menandatangani faktur pengadaan/SPB pada saat barang diterima?</td>
                              <td class="td_kritis">Tingkat Kekritisan (M)</td>
                              <td class="td_kritis"><?php echo $aspek_penilaian[18]; ?></td>
                          </tr>
                          <tr id="point5subb" y="Setiap penerimaan barang dilakukan pemeriksaan terhadap barang tersebut meliputi :  nomor izin edar, nomor bets, tanggal kadaluarsa, kebenaran kemasan, mutu produk secara fisik." t="Setiap penerimaan barang tidak dilakukan pemeriksaan terhadap barang tersebut meliputi :  nomor izin edar, nomor bets, tanggal kadaluarsa, kebenaran kemasan, mutu produk secara fisik.">
                              <td class="td_no">b.&nbsp;</td><td class="td_aspek">Apakah setiap penerimaan barang dilakukan pemeriksaan dan penelitian terhadap barang tersebut meliputi :  nomor izin edar, nomor bets, tanggal kadaluarsa, kebenaran kemasan, mutu produk secara fisik</td>
                              <td class="td_kritis">Tingkat Kekritisan (M)</td>
                              <td class="td_kritis"><?php echo $aspek_penilaian[19]; ?></td>
                          </tr>
                          <tr id="point5subc" y="Setiap penerimaan barang dicatat pada dokumen penerimaan barang/buku pembelian, kartu persediaan barang/kartu gudang dan kartu barang " t="Setiap penerimaan barang tidak dicatat pada dokumen penerimaan barang/buku pembelian, kartu persediaan barang/kartu gudang dan kartu barang ">
                              <td class="td_no">c.&nbsp;</td><td class="td_aspek">Apakah setiap penerimaan barang dicatat pada dokumen penerimaan barang, kartu persediaan barang/kartu gudang dan kartu barang?</td>
                              <td class="td_kritis">Tingkat Kekritisan (M)</td>
                              <td class="td_kritis"><?php echo $aspek_penilaian[20]; ?></td>
                          </tr>
                          <tr id="point5subd" y="Pengisian dokumen penerimaan barang/buku pembelian, kartu persediaan barang/kartu gudang dan kartu barang sesuai dengan ketentuan CDOB." t="Pengisian dokumen penerimaan barang/buku pembelian, kartu persediaan barang/kartu gudang dan kartu barang tidak sesuai dengan ketentuan CDOB.">
                              <td class="td_no">d.&nbsp;</td><td class="td_aspek">Apakah pengisian dokumen penerimaan barang, kartu persediaan barang/kartu gudang dan kartu barang sesuai dengan ketentuan CDOB?</td>
                              <td class="td_kritis">Tingkat Kekritisan (M)</td>
                              <td class="td_kritis"><?php echo $aspek_penilaian[21]; ?></td>
                          </tr>
                          
                          <tr id="point5sube" y="Mempunyai sistem yang menjamin first in and first out / first exp first out." t="Tidak mempunyai sistem yang menjamin first in and first out / first exp first out.">
                              <td class="td_no">e.&nbsp;</td><td class="td_aspek">Apakah mempunyai sistem yang menjamin first in and first out / first exp first out ? </td>
                              <td class="td_kritis">Tingkat Kekritisan (M)</td>
                              <td class="td_kritis"><?php echo $aspek_penilaian[22]; ?></td>
                          </tr>
                          <tr id="point5subf" y="Semua obat disimpan pada kondisi sesuai dengan yang tercantum dalam kemasan obat serta terpisah dari komoditi lainnya?" t="Semua atau sebagian obat tidak disimpan pada kondisi sesuai dengan yang tercantum dalam kemasan obat serta tidak terpisah dari komoditi lainnya.">
                              <td class="td_no">f.&nbsp;</td><td class="td_aspek">Apakah obat disimpan pada kondisi sesuai dengan yang tercantum dalam kemasan obat serta terpisah dari komoditi lainnya?</td>
                              <td class="td_kritis">Tingkat Kekritisan (M)</td>
                              <td class="td_kritis"><?php echo $aspek_penilaian[23]; ?></td>
                          </tr>
                          <tr id="point5subg" y="Obat yang mendekati kadaluarsa, telah kadaluarsa, mengalami kerusakan kemasan, tutup atau yang diduga kemungkinan mengalami kontaminasi dan yang akan dimusnahkan diinventarisir, dipisahkan penyimpanannya dan terkunci." t="Obat yang mendekati kadaluarsa, telah kadaluarsa, mengalami kerusakan kemasan, tutup atau yang diduga kemungkinan mengalami kontaminasi dan yang akan dimusnahkan tidak diinventarisir, tidak dipisahkan penyimpanannya dan tidak terkunci.">
                              <td class="td_no">g.&nbsp;</td><td class="td_aspek">Apakah obat yang mendekati kadaluarsa, telah kadaluarsa, mengalami kerusakan kemasan, tutup atau yang diduga kemungkinan mengalami kontaminasi dan yang akan dimusnahkan diinventarisir, dipisahkan penyimpanannya dan terkunci?</td>
                              <td class="td_kritis">Tingkat Kekritisan (M)</td>
                              <td class="td_kritis"><?php echo $aspek_penilaian[24]; ?></td>
                          </tr>
                          <tr id="point5subh" y="Jumlah dalam kartu barang sesuai dengan jumlah fisik di gudang." t="Jumlah dalam kartu barang tidak sesuai dengan jumlah fisik di gudang.">
                              <td class="td_no">h.&nbsp;</td><td class="td_aspek">Apakah jumlah dalam kartu barang sesuai dengan jumlah fisik di gudang?</td>
                              <td class="td_kritis">Tingkat Kekritisan (M)</td>
                              <td class="td_kritis"><?php echo $aspek_penilaian[25]; ?></td>
                          </tr>
                      </table>
                      
                      <h2 class="small">6. Penyaluran</h2>
                      <table class="form_tabel" group="6. Penyaluran">
                          <tr><td class="td_no isi">&nbsp;</td><td class="td_aspek isi">ASPEK DAN DETAIL</td><td class="td_kritis isi">TINGKAT KEKRITISAN</td><td class="td_kriteria isi">YA / TIDAK / NA</td></tr>
                          <tr id="point6suba" y="Semua penyaluran berdasarkan Surat Pesanan/LPLPO  yang ditandatangani oleh penanggung jawab dan distempel." t="Semua atau sebagian penyaluran tidak berdasarkan Surat Pesanan/LPLPO yang ditandatangani oleh penanggung jawab dan distempel.">
                              <td class="td_no">a.&nbsp;</td><td class="td_aspek">Apakah setiap penyaluran berdasarkan Surat Pesanan/LPLPO yang ditandatangani oleh penanggung jawab dan distempel?</td>
                              <td class="td_kritis">Tingkat Kekritisan (C)</td>
                              <td class="td_kritis"><?php echo $aspek_penilaian[26]; ?></td>
                          </tr>
                          <tr id="point6subb" y="Penanggung Jawab membubuhkan tanda tangan atau paraf terhadap pesanan " t="Penanggung Jawab tidak membubuhkan tanda tangan atau paraf terhadap pesanan ">
                              <td class="td_no">b.&nbsp;</td><td class="td_aspek">Apakah Penanggung Jawab membubuhkan tanda tangan atau paraf terhadap pesanan?</td>
                              <td class="td_kritis">Tingkat Kekritisan (M)</td>
                              <td class="td_kritis"><?php echo $aspek_penilaian[27]; ?></td>
                          </tr>
                          <tr id="point6subc" y="Obat yang dikirimkan disertai faktur atau SPB yang sesuai dengan ketentuan pada pedoman CDOB serta ditandatangani oleh Penanggung Jawab." t="Obat yang dikirimkan tidak disertai faktur atau SPB yang sesuai dengan ketentuan pada pedoman CDOB serta tidak ditandatangani oleh Penanggung Jawab.">
                              <td class="td_no">c.&nbsp;</td><td class="td_aspek">Apakah obat yang dikirimkan disertai faktur atau SPB yang sesuai dengan ketentuan pada pedoman CDOB serta ditandatangani oleh Penanggung Jawab?</td>
                              <td class="td_kritis">Tingkat Kekritisan (M)</td>
                              <td class="td_kritis"><?php echo $aspek_penilaian[28]; ?></td>
                          </tr>
                          <tr id="point6subd" y="Faktur atau SPB diarsipkan berdasarkan nomor urut dan tanggal pengeluaran." t="Faktur atau SPB tidak diarsipkan berdasarkan nomor urut dan tanggal pengeluaran.">
                              <td class="td_no">d.&nbsp;</td><td class="td_aspek">Apakah faktur atau SPB diarsipkan berdasarkan nomor urut dan tanggal pengeluaran? </td>
                              <td class="td_kritis">Tingkat Kekritisan (M)</td>
                              <td class="td_kritis"><?php echo $aspek_penilaian[29]; ?></td>
                          </tr>
                          <tr id="point6sube" y="Semua tanda terima faktur atau surat penyerahan barang dibubuhi stempel sarana penerima (sesuai surat pesanan), diberi tanda tangan, nama terang dan No. SIK Penanggung Jawab sarana/petugas teknis kefarmasian yang diberi kewenangan." t="Semua tanda terima faktur atau surat penyerahan barang tidak dibubuhi stempel sarana penerima (sesuai surat pesanan), diberi tanda tangan, nama terang dan No. SIK Penanggung Jawab sarana/petugas teknis kefarmasian yang diberi kewenangan.">
                              <td class="td_no">e.&nbsp;</td>
                              <td class="td_aspek">Apakah semua tanda terima faktur atau surat penyerahan barang dibubuhi stempel sarana penerima (sesuai surat pesanan), diberi tanda tangan, nama terang dan No. SIK Penanggung Jawab sarana/petugas teknis kefarmasian yang diberi kewenangan?</td>
                              <td class="td_kritis">Tingkat Kekritisan (M)</td>
                              <td class="td_kritis"><?php echo $aspek_penilaian[30]; ?></td>
                          </tr>
                          <tr id="point6subf" y="Obat yang disalurkan dikontrol oleh Kepala Gudang atau petugas yang ditunjuk sesuai faktur atau SPB yang diketahui (ditanda tangani atau diparaf) Penanggung Jawab." t="Obat yang disalurkan tidak dikontrol oleh Kepala Gudang atau petugas yang ditunjuk sesuai faktur atau SPB yang diketahui (ditanda tangani atau diparaf) Penanggung Jawab.">
                              <td class="td_no">f.&nbsp;</td>
                              <td class="td_aspek">Apakah obat yang disalurkan dikontrol oleh Kepala Gudang atau petugas yang ditunjuk sesuai faktur atau SPB yang diketahui (ditanda tangani atau diparaf) Penanggung Jawab ? </td>
                              <td class="td_kritis">Tingkat Kekritisan (M)</td>
                              <td class="td_kritis"><?php echo $aspek_penilaian[31]; ?></td>
                          </tr>
                          <tr id="point6subg" y="Obat-obat yang disalurkan adalah obat-obat yang terdaftar" t="Obat-obat yang disalurkan adalah obat-obat yang tidak terdaftar.">
                              <td class="td_no">g.&nbsp;</td>
                              <td class="td_aspek">Apakah  obat-obat yang disalurkan adalah obat-obat yang terdaftar?</td>
                              <td class="td_kritis">Tingkat Kekritisan (C)</td>
                              <td class="td_kritis"><?php echo $aspek_penilaian[32]; ?></td>
                          </tr>
                      
                      </table>
                      
                      <h2 class="small">7. Penarikan Kembali Obat (Recall)</h2>
                      <table class="form_tabel" group="7. Penarikan Kembali Obat (Recall)">
                          <tr><td class="td_no isi">&nbsp;</td><td class="td_aspek isi">ASPEK DAN DETAIL</td><td class="td_kritis isi">TINGKAT KEKRITISAN</td><td class="td_kriteria isi">YA / TIDAK / NA</td></tr>
                          <tr id="point7suba" y="Recall dilakukan segera setelah diterima permintaan/perintah untuk penarikan kembali, dilakukan secara menyeluruh dan tuntas sampai tingkat sarana pelayanan." t="Recall tidak dilakukan segera setelah diterima permintaan/perintah untuk penarikan kembali dan tidak dilakukan secara menyeluruh dan tuntas sampai tingkat sarana pelayanan.">
                              <td class="td_no">a.&nbsp;</td><td class="td_aspek">Apakah recall dilakukan segera setelah diterima permintaan/perintah untuk penarikan kembali dilakukan secara menyeluruh dan tuntas sampai tingkat sarana pelayanan?</td>
                              <td class="td_kritis">Tingkat Kekritisan (M)</td>
                              <td class="td_kritis"><?php echo $aspek_penilaian[33]; ?></td>
                          </tr>
                          <tr id="point7subb" y="Sistem dokumentasi mendukung pelaksanaan recall secara efektif, cepat dan tuntas." t="Sistem dokumentasi tidak mendukung pelaksanaan recall secara efektif, cepat dan tuntas.">
                              <td class="td_no">b.&nbsp;</td><td class="td_aspek">Apakah sistem dokumentasi mendukung pelaksanaan recall secara efektif, cepat dan tuntas ?</td>
                              <td class="td_kritis">Tingkat Kekritisan (M)</td>
                              <td class="td_kritis"><?php echo $aspek_penilaian[34]; ?></td>
                          </tr>
                          <tr id="point7subc" y="Produk recall dicatat dalam Buku Penerimaan Pengembalian Barang kemudian diamankan di tempat terpisah dan terkunci sampai obat tersebut dikembalikan sesuai instruksi dari pihak yang berwenang." t="Produk recall tidak dicatat dalam Buku Penerimaan Pengembalian Barang, tidak diamankan di tempat terpisah dan terkunci sampai obat tersebut dikembalikan sesuai instruksi dari pihak yang berwenang.">
                              <td class="td_no">c.&nbsp;</td><td class="td_aspek">Apakah produk recall dicatat dalam Buku Penerimaan Pengembalian Barang kemudian diamankan di tempat terpisah dan terkunci sampai obat tersebut dikembalikan sesuai instruksi dari pihak yang berwenang?</td>
                              <td class="td_kritis">Tingkat Kekritisan (M)</td>
                              <td class="td_kritis"><?php echo $aspek_penilaian[35]; ?></td>
                          </tr>
                          <tr id="point7subd" y="Pelaksanaan penarikan atau hasil penarikan termasuk permintaan penghentian penyaluran serta Laporan Pengembalian Barang yang Ditarik dari Peredaran dilaporkan kepada Badan POM." t="Pelaksanaan penarikan atau hasil penarikan termasuk permintaan penghentian penyaluran serta Laporan Pengembalian Barang yang Ditarik dari Peredaran tidak dilaporkan kepada Badan POM.">
                              <td class="td_no">d.&nbsp;</td>
                              <td class="td_aspek">Apakah pelaksanaan penarikan atau hasil penarikan termasuk permintaan penghentian penyaluran serta Laporan Pengembalian Barang yang Ditarik dari Peredaran dilaporkan kepada Badan POM?</td>
                              <td class="td_kritis">Tingkat Kekritisan (M)</td>
                              <td class="td_kritis"><?php echo $aspek_penilaian[36]; ?></td>
                          </tr>
                      </table>
                      
                      <h2 class="small">8. Penanganan Produk Ilegal</h2>
                      <table class="form_tabel" group="8. Penanganan Produk Ilegal">
                          <tr><td class="td_no isi">&nbsp;</td><td class="td_aspek isi">ASPEK DAN DETAIL</td><td class="td_kritis isi">TINGKAT KEKRITISAN</td><td class="td_kriteria isi">YA / TIDAK / NA</td></tr>
                          <tr id="point8suba" y="Obat palsu/diduga palsu yang ditemukan dalam jaringan distribusi obat diamankan terpisah dari obat lain, terkunci dan diberi penandaan tidak untuk disalurkan." t="Obat palsu/diduga palsu yang ditemukan dalam jaringan distribusi obat tidak diamankan terpisah dari obat lain, terkunci dan diberi penandaan tidak untuk disalurkan.">
                              <td class="td_no">a.&nbsp;</td><td class="td_aspek">Apakah obat palsu/diduga palsu yang ditemukan dalam jaringan distribusi obat diamankan terpisah dari obat lain, terkunci dan diberi penandaan tidak untuk disalurkan? </td>
                              <td class="td_kritis">Tingkat Kekritisan (C)</td>
                              <td class="td_kritis"><?php echo $aspek_penilaian[37]; ?></td>
                          </tr>
                          <tr id="point8subb" y="Gudang farmasi menghubungi produsen obat melaporkan ke Badan POM atau Balai Besar/Balai POM setempat bila ditemukan obat palsu/diduga palsu." t="Gudang farmasi tidak menghubungi produsen obat, melaporkan ke Badan POM atau Balai Besar/Balai POM setempat bila ditemukan obat palsu/diduga palsu.">
                              <td class="td_no">b.&nbsp;</td><td class="td_aspek">Apakah gudang farmasi menghubungi produsen obat melaporkan ke Badan POM atau Balai Besar/Balai POM setempat bila ditemukan obat palsu/diduga palsu?</td>
                              <td class="td_kritis">Tingkat Kekritisan (M)</td>
                              <td class="td_kritis"><?php echo $aspek_penilaian[38]; ?></td>
                          </tr>
                      </table>
                      
                      <h2 class="small">9. Penanganan Produk Kembalian dan Kadaluarsa</h2>
                      <table class="form_tabel" group="9. Penanganan Produk Kembalian dan Kadaluarsa">
                          <tr><td class="td_no isi">&nbsp;</td><td class="td_aspek isi">ASPEK DAN DETAIL</td><td class="td_kritis isi">TINGKAT KEKRITISAN</td><td class="td_kriteria isi">YA / TIDAK / NA</td></tr>
                          <tr id="point9suba" y="Jumlah dan identifikasi obat kembalian dicatat dalam Buku Penerimaan Pengembalian Barang berdasarkan bukti pengembalian dari sarana yang mengembalikan." t="Jumlah dan identifikasi obat kembalian tidak dicatat dalam Buku Penerimaan Pengembalian Barang berdasarkan bukti pengembalian dari sarana yang mengembalikan.">
                              <td class="td_no">a.&nbsp;</td><td class="td_aspek">Apakah jumlah dan identifikasi obat kembalian dicatat dalam Buku Penerimaan Pengembalian Barang berdasarkan bukti pengembalian dari sarana yang mengembalikan?</td>
                              <td class="td_kritis">Tingkat Kekritisan (M)</td>
                              <td class="td_kritis"><?php echo $aspek_penilaian[39]; ?></td>
                          </tr>
                          <tr id="point9subb" y="Obat kembalian yang diterima karena tidak memenuhi syarat mutu dan yang mengalami kerusakan penandaan, dikarantina dan terkunci." t="Obat kembalian yang diterima karena tidak memenuhi syarat mutu dan yang mengalami kerusakan penandaan tidak dikarantina dan tidak terkunci.">
                              <td class="td_no">b.&nbsp;</td><td class="td_aspek">Apakah obat kembalian yang diterima karena tidak memenuhi syarat mutu dan yang mengalami kerusakan penandaan, dikarantina dan terkunci?</td>
                              <td class="td_kritis">Tingkat Kekritisan (M)</td>
                              <td class="td_kritis"><?php echo $aspek_penilaian[40]; ?></td>
                          </tr>
                      </table>
                      
                      <h2 class="small">10. Pengembalian Obat Ke Sumber Pengadaan</h2>
                      <table class="form_tabel" group="10. Pengembalian Obat Ke Sumber Pengadaan">
                          <tr><td class="td_no isi">&nbsp;</td><td class="td_aspek isi">ASPEK DAN DETAIL</td><td class="td_kritis isi">TINGKAT KEKRITISAN</td><td class="td_kriteria isi">YA / TIDAK / NA</td></tr>
                          <tr id="point10" y="Pengembalian obat kepada sumber pengadaan menggunakan Surat Penyerahan Barang dan didokumentasikan." t="Pengembalian obat kepada sumber pengadaan tidak menggunakan Surat Penyerahan Barang dan tidak didokumentasikan.">
                              <td class="td_no">a.&nbsp;</td><td class="td_aspek">Apakah pengembalian obat kepada sumber pengadaan menggunakan Surat Penyerahan Barang dan didokumentasikan?</td>
                              <td class="td_kritis">Tingkat Kekritisan (M)</td>
                              <td class="td_kritis"><?php echo $aspek_penilaian[41]; ?></td>
                          </tr>
                      </table>
                      
                      <h2 class="small">11. Pemusnahan</h2>
                      <table class="form_tabel" group="11. Pemusnahan">
                          <tr><td class="td_no isi">&nbsp;</td><td class="td_aspek isi">ASPEK DAN DETAIL</td><td class="td_kritis isi">TINGKAT KEKRITISAN</td><td class="td_kriteria isi">YA / TIDAK / NA</td></tr>
                          <tr id="point11suba" y="Pemusnahan obat dilaksanakan sesuai dengan ketentuan." t="Pemusnahan obat tidak dilaksanakan sesuai dengan ketentuan.">
                              <td class="td_no">a.&nbsp;</td><td class="td_aspek">Apakah pemusnahan obat dilaksanakan sesuai dengan ketentuan?</td>
                              <td class="td_kritis">Tingkat Kekritisan (M)</td>
                              <td class="td_kritis"><?php echo $aspek_penilaian[42]; ?></td>
                          </tr>
                          <tr id="point11subb" y="Perencanaan dan pelaksanaan pemusnahan dilaporkan kepada Badan POM atau Balai Besar/Balai POM setempat dengan melampirkan Berita Acara Pelaksanaan Pemusnahan." t="Perencanaan dan pelaksanaan pemusnahan tidak dilaporkan kepada Badan POM atau Balai Besar/Balai POM setempat dengan melampirkan Berita Acara Pelaksanaan Pemusnahan.">
                              <td class="td_no">b.&nbsp;</td><td class="td_aspek">Apakah perencanaan dan pelaksanaan pemusnahan dilaporkan kepada Badan POM atau Balai Besar/Balai POM setempat dengan melampirkan Berita Acara Pelaksanaan Pemusnahan ? </td>
                              <td class="td_kritis">Tingkat Kekritisan (M)</td>
                              <td class="td_kritis"><?php echo $aspek_penilaian[43]; ?></td>
                          </tr>
                          <tr id="point11subc" y="Setiap pemusnahan obat dibuatkan Berita Acara Pelaksanaan Pemusnahan yang ditandatangani oleh pelaksana pemusnahan dan saksi dari instansi pemerintah yang berwenang" t="Setiap pemusnahan obat tidak dibuatkan Berita Acara Pelaksanaan Pemusnahan yang ditandatangani oleh pelaksana pemusnahan dan saksi dari instansi pemerintah yang berwenang">
                              <td class="td_no">c.&nbsp;</td><td class="td_aspek">Apakah untuk tiap pemusnahan obat dibuatkan Berita Acara Pelaksanaan Pemusnahan yang ditandatangani oleh pelaksana pemusnahan dan saksi dari instansi pemerintah yang berwenang?</td>
                              <td class="td_kritis">Tingkat Kekritisan (M)</td>
                              <td class="td_kritis"><?php echo $aspek_penilaian[44]; ?></td>
                          </tr>
                      
                      </table>
                      
                      <h2 class="small">12. Pengelolaan Vaksin</h2>
                  <h2 class="small" style="margin-left:20px;">Personalia</h2>
                      <table class="form_tabel" group="Personalia">
                          <tr><td class="td_no isi">&nbsp;</td><td class="td_aspek isi">ASPEK DAN DETAIL</td><td class="td_kritis isi">TINGKAT KEKRITISAN</td><td class="td_kriteria isi">YA / TIDAK / NA</td></tr>
                          <tr id="point12seri1a" y="Petugas yang menangani vaksin/CCP mendapatkan pelatihan sesuai tanggung jawabnya." t="Petugas yang menangani vaksin/CCP tidak mendapatkan pelatihan sesuai tanggung jawabnya.">
                              <td class="td_no">a.&nbsp;</td><td class="td_aspek">Apakah petugas yang menangani vaksin/CCP mendapatkan pelatihan sesuai tanggung jawabnya?</td>
                              <td class="td_kritis">Tingkat Kekritisan (M)</td>
                              <td class="td_kritis"><?php echo $aspek_penilaian[45]; ?></td>
                          </tr>
                          <tr id="point12seri1b" y="Pelatihan yang dilakukan terdokumentasi." t="Pelatihan yang dilakukan tidak terdokumentasi">
                              <td class="td_no">b.&nbsp;</td><td class="td_aspek">Apakah  pelatihan yang dilakukan terdokumentasi?</td>
                              <td class="td_kritis">Tingkat Kekritisan (M)</td>
                              <td class="td_kritis"><?php echo $aspek_penilaian[46]; ?></td>
                          </tr>
                      
                      </table>
                      
                      <h2 class="small" style="margin-left:20px;">Bangunan dan Penyimpanan Vaksin / CCP </h2>
                      <table class="form_tabel" group="Bangunan dan Penyimpanan Vaksin / CCP">
                          <tr><td class="td_no isi">&nbsp;</td><td class="td_aspek isi">ASPEK DAN DETAIL</td><td class="td_kritis isi">TINGKAT KEKRITISAN</td><td class="td_kriteria isi">YA / TIDAK / NA</td></tr>
                          <tr id="point12seri2a" y="Tersedia tempat terpisah untuk penyimpanan produk vaksin/CCP sesuai dengan spesifikasi produk." t="Tidak tersedia tempat terpisah untuk penyimpanan produk vaksin/CCP sesuai dengan spesifikasi produk.">
                              <td class="td_no">a.&nbsp;</td><td class="td_aspek">Apakah tersedia tempat terpisah untuk penyimpanan produk vaksin/CCP sesuai dengan spesifikasi produk?</td>
                              <td class="td_kritis">Tingkat Kekritisan (C)</td>
                              <td class="td_kritis"><?php echo $aspek_penilaian[47]; ?></td>
                          </tr>
                          <tr id="point12seri2b" y="Mempunyai freezer untuk penyimpanan ice pack." t="Tidak mempunyai freezer untuk penyimpanan ice pack.">
                              <td class="td_no">b.&nbsp;</td><td class="td_aspek">Apakah mempunyai freezer untuk penyimpanan ice pack?</td>
                              <td class="td_kritis">Tingkat Kekritisan (M)</td>
                              <td class="td_kritis"><?php echo $aspek_penilaian[48]; ?></td>
                          </tr>
                          <tr id="point12seri2c" y="Dilakukan validasi terhadap tempat penyimpanan khusus untuk vaksin/CCP secara berkala minimal satu tahun satu kali." t="Tidak dilakukan validasi terhadap tempat penyimpanan khusus untuk vaksin/CCP secara berkala minimal satu tahun satu kali.">
                              <td class="td_no">c.&nbsp;</td><td class="td_aspek">Apakah dilakukan validasi terhadap tempat penyimpanan khusus untuk vaksin/CCP secara berkala minimal satu tahun satu kali?</td>
                              <td class="td_kritis">Tingkat Kekritisan (M)</td>
                              <td class="td_kritis"><?php echo $aspek_penilaian[49]; ?></td>
                          </tr>
                          <tr id="point12seri2d" y="Dilengkapi dengan temperature data logger yang dapat memberi informasi bahwa vaksin tidak pernah mengalami perubahan suhu yang merusak mutunya" t="Tidak dilengkapi dengan temperature data logger yang dapat memberi informasi bahwa vaksin tidak pernah mengalami perubahan suhu yang merusak mutunya.">
                              <td class="td_no">d.&nbsp;</td><td class="td_aspek">Apakah dilengkapi dengan temperature data logger yang dapat memberi informasi bahwa vaksin tidak pernah mengalami perubahan suhu yang merusak mutunya?</td>
                              <td class="td_kritis">Tingkat Kekritisan (M)</td>
                              <td class="td_kritis"><?php echo $aspek_penilaian[50]; ?></td>
                          </tr>
                          <tr id="point12serie" y="Tempat penyimpanan dilengkapi dengan alat pemantau suhu (termometer) dan dilakukan monitoring suhu serta pencatatan secara berkala (minimal sehari tiga kali dengan interval yang memadai)." t="Tempat penyimpanan dilengkapi dengan alat pemantau suhu (termometer) dan dilakukan monitoring suhu serta pencatatan tidak secara berkala (minimal sehari tiga kali dengan interval yang memadai)">
                              <td class="td_no">e.&nbsp;</td>
                              <td class="td_aspek">Apakah  tempat penyimpanan dilengkapi dengan alat pemantau suhu (termometer) dan  dilakukan monitoring suhu serta pencatatan secara berkala (minimal sehari tiga  kali dengan interval yang memadai)?</td>
                              <td class="td_kritis">Tingkat Kekritisan (C)</td>
                              <td class="td_kritis"><?php echo $aspek_penilaian[51]; ?></td>
                          </tr>
                          <tr id="point12seri2f" y="Tempat penyimpanan dilengkapi dengan alat yang dapat memberi peringatan suhu kritis dan secara rutin dilakukan pengecekan." t="Tempat penyimpanan tidak dilengkapi dengan alat yang dapat memberi peringatan suhu kritis dan secara rutin dilakukan pengecekan.">
                              <td class="td_no">f.&nbsp;</td>
                              <td class="td_aspek">Apakah tempat penyimpanan dilengkapi dengan alat yang dapat memberi peringatan suhu kritis dan secara rutin dilakukan pengecekan? </td>
                              <td class="td_kritis">Tingkat Kekritisan (M)</td>
                              <td class="td_kritis"><?php echo $aspek_penilaian[52]; ?></td>
                          </tr>
                          <tr id="point12seri2g" y="Mempunyai generator otomatis yang berfungsi dengan baik atau mempunyai petugas  yang dapat menjamin generator yang tidak otomatis berfungsi dengan baik selama 24 jam." t="Tidak mempunyai generator otomatis yang berfungsi dengan baik atau tidak mempunyai petugas  yang dapat menjamin generator yang tidak otomatis berfungsi dengan baik selama 24 jam.">
                              <td class="td_no">g.&nbsp;</td>
                              <td class="td_aspek">Apakah mempunyai generator otomatis yang berfungsi dengan baik? Atau Apakah mempunyai petugas  yang dapat menjamin generator yang tidak otomatis berfungsi dengan baik selama 24 jam?</td>
                              <td class="td_kritis">Tingkat Kekritisan (C)</td>
                              <td class="td_kritis"><?php echo $aspek_penilaian[53]; ?></td>
                          </tr>
                          <tr id="point12seri2h" y="Terdapat sistem penanganan produk vaksin / CCP apabila tempat penyimpanan mengalami gangguan/kerusakan (contingency plan)." t="Tidak terdapat sistem penanganan produk vaksin / CCP apabila tempat penyimpanan mengalami gangguan/kerusakan (contingency plan).">
                              <td class="td_no">h.&nbsp;</td>
                              <td class="td_aspek">Apakah terdapat sistem penanganan produk vaksin / CCP apabila tempat penyimpanan mengalami gangguan/kerusakan (contingency plan)?</td>
                              <td class="td_kritis">Tingkat Kekritisan (M)</td>
                              <td class="td_kritis"><?php echo $aspek_penilaian[54]; ?></td>
                          </tr>
                          <tr id="point12seri2i" y="Ada sistem tertentu yang dapat menjamin produk vaksin tidak hilang identitas, tidak mencemari dan tercemari produk/zat lain." t="Tidak ada sistem tertentu yang dapat menjamin produk vaksin tidak hilang identitas, tidak mencemari dan tercemari produk/zat lain.">
                              <td class="td_no">i.&nbsp;</td>
                              <td class="td_aspek">Apakah ada sistem tertentu yang dapat menjamin produk vaksin tidak hilang identitas, tidak mencemari dan tercemari produk/zat lain? </td>
                              <td class="td_kritis">Tingkat Kekritisan (M)</td>
                              <td class="td_kritis"><?php echo $aspek_penilaian[55]; ?></td>
                          </tr>
                          <tr id="poin12seri2j" y="Ada pemisahan dengan tanda khusus terhadap produk vaksin/CCP yang sudah tidak layak jual (rusak, kadaluarsa)." t="Tidak ada pemisahan dengan tanda khusus terhadap produk vaksin/CCP yang sudah tidak layak jual (rusak, kadaluarsa).">
                              <td class="td_no">j.&nbsp;</td>
                              <td class="td_aspek">Apakah ada pemisahan dengan tanda khusus terhadap produk vaksin/CCP yang sudah tidak disalurkan (rusak, kadaluarsa)?</td>
                              <td class="td_kritis">Tingkat Kekritisan (M)</td>
                              <td class="td_kritis"><?php echo $aspek_penilaian[56]; ?></td>
                          </tr>
                          <tr id="poin12seri2k" y="Termometer terkalibrasi" t="Termometer tidak terkalibrasi">
                              <td class="td_no">k.&nbsp;</td>
                              <td class="td_aspek">Apakah termometer terkalibrasi?</td>
                              <td class="td_kritis">Tingkat Kekritisan (M)</td>
                              <td class="td_kritis"><?php echo $aspek_penilaian[57]; ?></td>
                          </tr>
                      </table>
                      
                      <h2 class="small" style="margin-left:20px;">Penyaluran Vaksin / CCP</h2>
                    <table class="form_tabel" group="Penyaluran Vaksin / CCP">
                          <tr><td class="td_no isi">&nbsp;</td><td class="td_aspek isi">ASPEK DAN DETAIL</td><td class="td_kritis isi">TINGKAT KEKRITISAN</td><td class="td_kriteria isi">YA / TIDAK / NA</td></tr>
                        <tr id="point12seri3a" y="Penyaluran vaksin/CCP menggunakan wadah kedap yang dilengkapi ice pack/dry ice sedemikian rupa sehingga mencapai temperatur yang sesuai dengan vaksin tersebut." t="Penyaluran vaksin/CCP tidak menggunakan wadah kedap yang dilengkapi ice pack/dry ice sedemikian rupa sehingga mencapai temperatur yang sesuai dengan vaksin tersebut.">
                            <td class="td_no">a.&nbsp;</td><td class="td_aspek">Apakah penyaluran vaksin menggunakan wadah kedap yang dilengkapi ice pack/dry ice sedemikian rupa sehingga mencapai temperatur yang sesuai dengan vaksin tersebut?</td>
                            <td class="td_kritis">Tingkat Kekritisan (C)</td>
                            <td class="td_kritis"><?php echo $aspek_penilaian[58]; ?></td>
                        </tr>
                        <tr id="point12seri3b" y="Penyaluran vaksin dilengkapi dengan  alat monitor suhu yang menjamin bahwa vaksin tidak pernah mengalami suhu ekstrim." t="Penyaluran vaksin tidak dilengkapi dengan  alat monitor suhu yang menjamin bahwa vaksin tidak pernah mengalami suhu ekstrim.">
                            <td class="td_no">b.&nbsp;</td><td class="td_aspek">Apakah penyaluran vaksin dilengkapi dengan  alat monitor suhu yang menjamin bahwa vaksin tidak pernah mengalami suhu ekstrim?</td>
                            <td class="td_kritis">Tingkat Kekritisan (M)</td>
                            <td class="td_kritis"><?php echo $aspek_penilaian[59]; ?></td>
                        </tr>
                      
                    </table>

        <?php
	}
	
}else{#Tujuan Pemeriksaan Kasus
	?>
<p><b>Lampiran II</b></p>
    <p>Tujuan Pemeriksaan Kasus</p>
    <h2 class="small">A. PROFIL SARANA DAN ORGANISASI</h2>
    <div><?php echo preg_replace('/[^(\x20-\x7F)]*/','',html_entity_decode($sess['KASUS_POINT_A'])); ?></div>
    <h2 class="small">B. PERSONALIA</h2>
    <div><?php echo preg_replace('/[^(\x20-\x7F)]*/','',html_entity_decode($sess['KASUS_POINT_B'])); ?></div>
    <h2 class="small">C. GUDANG DAN PERLENGKAPAN</h2>
    <div><?php echo preg_replace('/[^(\x20-\x7F)]*/','',html_entity_decode($sess['KASUS_POINT_C'])); ?></div>
    <h2 class="small">D. PENGADAAN</h2>
    <div><?php echo preg_replace('/[^(\x20-\x7F)]*/','',html_entity_decode($sess['KASUS_POINT_D'])); ?></div>
    <h2 class="small">E. PENYIMPANAN</h2>
    <div><?php echo preg_replace('/[^(\x20-\x7F)]*/','',html_entity_decode($sess['KASUS_POINT_E'])); ?></div>
    <h2 class="small">F. PENDISTRIBUSIAN</h2>
    <div><?php echo preg_replace('/[^(\x20-\x7F)]*/','',html_entity_decode($sess['KASUS_POINT_F'])); ?></div>
    <h2 class="small">G. DOKUMENTASI</h2>
    <div><?php echo preg_replace('/[^(\x20-\x7F)]*/','',html_entity_decode($sess['KASUS_POINT_G'])); ?></div>
    <h2 class="small">H. LAIN-LAIN</h2>
    <div><?php echo preg_replace('/[^(\x20-\x7F)]*/','',html_entity_decode($sess['KASUS_POINT_H'])); ?></div>    
	<?php
}
?>

<?php if($sess['JUMLAH_TEMUAN'] != 0) { ?>
<pagebreak sheet-size="330mm 210mm" />
<p><b>Lampiran III </b></p>
<p>Temuan Produk</p>
<table class="tb_temuan">
<tr class="header"><th>Detil Produk</th><th>Detil Perusahaan</th><th>Temuan</th><th>Tindakan</th><th>Keterangan</th></tr>
<?php
if($sess['JUMLAH_TEMUAN'] != 0){
	for($i=0; $i<count($temuan_produk); $i++){
		?>
		<tr><td>Nama Produk : <?php echo $temuan_produk[$i]['NAMA_PRODUK']; ?><br>Nama Pabrik : <?php echo $temuan_produk[$i]['NAMA_PABRIK']; ?><br>Negara Asal : <?php echo $temuan_produk[$i]['NEGARA_ASAL']; ?><br>Kemasan : <?php echo $temuan_produk[$i]['KEMASAN']; ?><br>NIE : <?php echo $temuan_produk[$i]['NOMOR_REGISTRASI']; ?><br>No. Lot / Bets : <?php echo $temuan_produk[$i]['NO_BATCH']; ?><br>Tanggal Expire : <?php echo $temuan_produk[$i]['TANGGAL_EXPIRE']; ?></td><td>Produsen : <?php echo $temuan_produk[$i]['NAMA_PERUSAHAAN']; ?><br>Pendaftar : <?php echo $temuan_produk[$i]['PEMILIK']; ?><br />Alamat : <?php echo $temuan_produk[$i]['ALAMAT_PERUSAHAAN']; ?></td><td>Kategori Temuan : <?php echo $temuan_produk[$i]['KATEGORI']; ?><br>Jumlah Temuan : <?php echo $temuan_produk[$i]['JUMLAH_TEMUAN']; ?></td><td><?php echo $temuan_produk[$i]['TINDAKAN_PRODUK']; ?></td><td><?php echo $temuan_produk[$i]['KETERANGAN_SUMBER']; ?></td></tr>
		<?php
	}
}else{
	$temuan_produk = "";
} ?>                  
</table>
<?php } ?>


