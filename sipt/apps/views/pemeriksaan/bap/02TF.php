<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR); ?>
<style>
body {
font-family:font-family: "Times New Roman";
	font-size: 10pt;
}
@page {
	margin-top: 2.5cm;
	margin-bottom: 2.5cm;
	margin-left: 2.5cm;
	margin-right: 2.5cm;
}
h2.judulbap {
	font-size: 14pt;
	font-weight: bold;
	text-decoration: underline;
}
table td {
	vertical-align: top;
	text-align: justify;
}
table.tb_temuan {
	font-size: 8pt;
	border-collapse: collapse;
	border-spacing: 0;
	width: 100%;
	padding: 5px;
}
table.tb_temuan tr.header th {
	border-collapse: collapse;
	text-align: left;
	padding: 5px;
	border: 1px solid #000;
	height: 35px;
	vertical-align: top;
}
table.tb_temuan td {
	padding: 5px;
	vertical-align: top;
	border: 1px solid #000;
}
table.form_tabel {
	font-size: 8pt;
	border-collapse: collapse;
	border-spacing: 0;
	width: 100%;
	padding: 5px;
}
table.form_tabel td {
	padding: 5px;
	vertical-align: top;
	border: 1px solid #000;
}
table.form_tabel td.isi {
	font-weight: bold;
}
table.form_tabel td.td_no {
	width: 20px;
}
table.form_tabel td.td_aspek {
	width: 600px;
}
h2.small {
	font-size: 9pt;
	font-weight: bold;
}
</style>
<div style="text-align:center;">
  <div><img src="<?php echo base_url(); ?>images/logobpom_.jpg" /></div>
  <div>
    <h2 class="judulbap">BERITA ACARA PEMERIKSAAN</h2>
  </div>
</div>
<div style="height:5px;">&nbsp;</div>
<div style="text-align:justify;">Pada hari ini <?php echo $hari; ?> tanggal <?php echo $awal_periksa; ?> kami yang bertanda tangan di bawah ini :</div>
<div style="height:5px;">&nbsp;</div>
<table width="100%">
  <?php 
$jml_petugas = count($petugas);
$no = 1;
for($z=0; $z<$jml_petugas; $z++){ ?>
  <tr>
    <td width="20"><?php echo $no; ?>.</td>
    <td width="120">Nama</td>
    <td width="20">:</td>
    <td><?php echo $petugas[$z]['NAMA_PETUGAS']; ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>NIP</td>
    <td>:</td>
    <td><?php echo $petugas[$z]['NIP']; ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Jabatan</td>
    <td>:</td>
    <td><?php echo $petugas[$z]['JABATAN']; ?></td>
  </tr>
  <?php 
$no++;
} ?>
</table>
<div style="height:20px;"></div>
<div style="text-align:justify">Berdasarkan surat tugas dari Kepala <?php echo ucwords(strtolower($petugas[0]['BADAN'])); ?> Nomor : <?php echo $petugas[0]['NOMOR_SURAT']; ?> tanggal <?php echo $petugas[0]['TANGGAL_SURAT']; ?> telah melakukan pemeriksaan terhadap : </div>
<div style="height:20px;"></div>
<table width="100%">
  <tr>
    <td width="200">Nama Sarana</td>
    <td width="20">:</td>
    <td><?php echo $sess['NAMA_SARANA']; ?></td>
  </tr>
  <tr>
    <td width="200">Alamat</td>
    <td width="20">:</td>
    <td><?php echo $sess['ALAMAT_1']; ?></td>
  </tr>
</table>
<div style="height:20px;"></div>
<div style="text-align:justify;">Adapun hasil pemeriksaan sebagaimana tersebut terlampir. </div>
<div style="height:20px;"></div>
<div style="text-align:justify;">Demikian Berita Acara ini dibuat dengan sesungguhnya untuk dapat dipergunakan sebagaimana mestinya. </div>
<div style="height:40px;"></div>
<table style="width:100%">
  <tr>
    <td style="width:50%;">Mengetahui,</td>
    <td style="width:50%;">Yang membuat Berita Acara</td>
  </tr>
  <tr>
    <td height="150">Penanggung Jawab,</td>
    <td><table width="100%">
        <?php 
    $jml = count($petugas);
    $no = 1;
    for($x=0; $x<$jml; $x++){ ?>
        <tr>
          <td width="20"><?php echo $no; ?>.</td>
          <td><?php echo $petugas[$x]['NAMA_PETUGAS']; ?></td>
        </tr>
        <?php 
    $no++;
    } ?>
      </table></td>
  </tr>
  <tr>
    <td><?php echo $sess['PENANGGUNG_JAWAB']; ?></td>
    <td>&nbsp;</td>
  </tr>
</table>
<pagebreak>
<p><b>Lampiran I</b></p>
<p><b>Sarana yang diperiksa : </b></p>
<table width="100%">
  <tr>
    <td width="200">Nama GFK</td>
    <td width="20">:</td>
    <td><?php echo $sess['NAMA_SARANA']; ?></td>
  </tr>
  <tr>
    <td width="200">Alamat</td>
    <td width="20">:</td>
    <td><?php echo $sess['ALAMAT_1']; ?></td>
  </tr>
  <tr>
    <td width="200">Telepon</td>
    <td width="20">:</td>
    <td><?php if(trim($sess["TELEPON"]) != "") { ?>
      <ul style="list-style-type:decimal; padding-left:20px; margin:0;">
        <?php $telepon = explode(";", $sess['TELEPON']); echo "<li>".join("</li><li>", $telepon)."</li>"; ?>
      </ul>
      <?php } ?></td>
  </tr>
  <tr>
    <td width="200">Nama Pimpinan</td>
    <td width="20">:</td>
    <td><?php echo $sess['NAMA_PIMPINAN']; ?></td>
  </tr>
  <tr>
    <td width="200">Nama Penanggung Jawab</td>
    <td width="20">:</td>
    <td><?php echo $sess['PENANGGUNG_JAWAB']; ?></td>
  </tr>
  <tr>
    <td width="200">No. SIK</td>
    <td width="20">:</td>
    <td><?php echo $sess['NO_SIK']; ?></td>
  </tr>
</table>
<div style="height:5px;"></div>
<p><b>Informasi Pemeriksaan</b></p>
<table width="100%">
  <tr>
    <td width="200">Tanggal Pemeriksaan</td>
    <td width="20">:</td>
    <td><?php echo $sess['AWAL_PERIKSA']; ?>&nbsp; sampai dengan &nbsp; <?php echo $sess['AKHIR_PERIKSA']; ?></td>
  </tr>
  <tr>
    <td width="200">Tujuan Pemeriksaan</td>
    <td width="20">:</td>
    <td><?php echo $sess['TUJUAN_PEMERIKSAAN']; ?></td>
  </tr>
</table>
<p><b>Hasil Pemeriksaan</b></p>
<table width="100%">
  <tr>
    <td width="200">Hasil Kesimpulan</td>
    <td width="20">:</td>
    <td><?php echo $sess['UR_HASIL']; ?></td>
  </tr>
  <tr>
    <td>Kesimpulan Detil Pelanggaran</td>
    <td width="20">:</td>
    <td><ul style="list-style-type:decimal; padding-left:20px;">
        <li>Jumlah Pelanggaran Minor : <b><?php echo $sess['MINOR']; ?></b></li>
        <li>Jumlah Pelanggaran Major : <b><?php echo $sess['MAJOR']; ?></b></li>
        <li>Jumlah Pelanggaran Critical : <b><?php echo $sess['CRITICAL']; ?></b></li>
      </ul></td>
  </tr>
  <tr>
    <td>Hasil Temuan</td>
    <td width="20">:</td>
    <td><?php if(trim($sess['HASIL_TEMUAN']) != ""){ ?>
      <ul style="list-style-type:decimal; padding-left:20px; margin:0;">
        <?php $temuan = explode("___", $sess['HASIL_TEMUAN']); echo "<li>".join("</li><li>", $temuan)."</li>"; ?>
      </ul>
      <?php } ?></td>
  </tr>
  <tr>
    <td>Hasil Temuan diluar Aspek Penilaian</td>
    <td width="20">:</td>
    <td><?php echo $sess['HASIL_TEMUAN_LAIN']; ?></td>
  </tr>
  <tr>
    <td>Catatan Hasil Pemeriksaan</td>
    <td width="20">:</td>
    <td><?php echo preg_replace('/[^(\x20-\x7F)]*/','',html_entity_decode($sess['CATATAN_HASIL_PEMERIKSAAN'])); ?></td>
  </tr>
</table>
<?php
if(in_array($sess['BBPOM_ID'], $this->config->item('cfg_unit'))){
}else{
	?>
<p><b>Tindakan Balai</b></p>
<table width="100%">
  <tr>
    <td width="200">Saran Tindak Lanjut</td>
    <td width="20">:</td>
    <td><?php if(trim($sess['TINDAK_LANJUT_BALAI']) != ""){ ?>
      <ul style="list-style-type:decimal; padding-left:20px; margin:0;">
        <?php $tl_balai= explode("#", $sess['TINDAK_LANJUT_BALAI']); echo "<li>".join("</li><li>", $tl_balai)."</li>"; ?>
      </ul>
      <?php } ?></td>
  </tr>
  <tr>
    <td>Detail Tindak Lanjut</td>
    <td width="20">:</td>
    <td><?php echo preg_replace('/[^(\x20-\x7F)]*/','',html_entity_decode($sess['DETAIL_TINDAK_LANJUT_BALAI'])); ?></td>
  </tr>
</table>
<?php
}
?>
<?php if(trim($sess['TINDAK_LANJUT_PUSAT']) != ""){ ?>
<p><b>Tindakan Pusat</b></p>
<table width="100%">
  <tr>
    <td width="200">Tindak Lanjut</td>
    <td width="20">:</td>
    <td><?php if(trim($sess['TINDAK_LANJUT_PUSAT']) != ""){ ?>
      <ul style="list-style-type:decimal; padding-left:20px; margin:0;">
        <?php $tl_pusat = explode("#", $sess['TINDAK_LANJUT_PUSAT']); echo "<li>".join("</li><li>", $tl_pusat)."</li>"; ?>
      </ul>
      <?php } ?></td>
  </tr>
  <tr>
    <td>Detail Tindak Lanjut</td>
    <td width="20">:</td>
    <td><?php echo preg_replace('/[^(\x20-\x7F)]*/','',html_entity_decode($sess['DETIL_TINDAK_LANJUT_PUSAT'])); ?></td>
  </tr>
</table>
<?php } ?>
<?php
if($sess['TUJUAN_PEMERIKSAAN'] == "Rutin"){#Tujuan Pemeriksaan Rutin
	if($sess['HASIL'] == "TMK"){#Jika hasil TMK 
		?>
<pagebreak sheet-size="330mm 210mm" />
<p><b>Lampiran II</b></p>
<p>Checklist Aspek Penilaian</p>
<h2 class="small">1. Bangunan dan Peralatan</h2>
<table class="form_tabel" group="1. Bangunan dan Peralatan">
  <tr>
    <td class="td_no isi">&nbsp;</td>
    <td class="td_aspek isi">ASPEK DAN DETAIL</td>
    <td class="td_kritis isi">TINGKAT KEKRITISAN</td>
    <td class="td_kriteria isi">YA / TIDAK / NA</td>
  </tr>
  <tr id="point3suba" y="Mempunyai sistem pengendalian hama (pest control) dan tidak terdokumentasi." t="Tidak mempunyai sistem pengendalian hama (pest control) dan tidak terdokumentasi.">
    <td class="td_no">a.&nbsp;</td>
    <td class="td_aspek">Apakah mempunyai sistem pengendalian hama (pest control) dan terdokumentasi?</td>
    <td class="td_kritis">Tingkat Kekritisan (M)</td>
    <td class="td_kritis"><?php echo $aspek_penilaian[0]; ?></td>
  </tr>
  <tr id="point3subb" y="Tersedia palet atau peralatan lain yang menjamin obat tidak bersentuhan langsung dengan lantai." t="Tidak tersedia palet atau peralatan lain yang menjamin obat tidak bersentuhan langsung dengan lantai.">
    <td class="td_no">b.&nbsp;</td>
    <td class="td_aspek">Apakah tersedia palet atau peralatan lain yang menjamin obat tidak bersentuhan langsung dengan lantai?</td>
    <td class="td_kritis">Tingkat Kekritisan (M)</td>
    <td class="td_kritis"><?php echo $aspek_penilaian[1]; ?></td>
  </tr>
  <tr id="point3subc" y="Tersedia peralatan yang memadai untuk memindahkan barang." t="Tidak tersedia peralatan yang memadai untuk memindahkan barang.">
    <td class="td_no">c.&nbsp;</td>
    <td class="td_aspek">Apakah tersedia peralatan yang memadai untuk memindahkan barang?</td>
    <td class="td_kritis">Tingkat Kekritisan (m)</td>
    <td class="td_kritis"><?php echo $aspek_penilaian[2]; ?></td>
  </tr>
</table>
<h2 class="small">2. Pengadaan</h2>
<table class="form_tabel" group="2. Pengadaan">
  <tr>
    <td class="td_no isi">&nbsp;</td>
    <td class="td_aspek isi">ASPEK DAN DETAIL</td>
    <td class="td_kritis isi">TINGKAT KEKRITISAN</td>
    <td class="td_kriteria isi">YA / TIDAK / NA</td>
  </tr>
  <tr id="point4suba" y="Pengadaan dari sumber yang sah." t="Pengadaan bukan dari sumber yang sah.">
    <td class="td_no">a.&nbsp;</td>
    <td class="td_aspek">Apakah pengadaan dari sumber yang sah?</td>
    <td class="td_kritis">Tingkat Kekritisan (C)</td>
    <td class="td_kritis"><?php echo $aspek_penilaian[3]; ?></td>
  </tr>
</table>
<h2 class="small">3. Penerimaan dan Penyimpanan</h2>
<table class="form_tabel" group="3. Penerimaan dan Penyimpanan">
  <tr>
    <td class="td_no isi">&nbsp;</td>
    <td class="td_aspek isi">ASPEK DAN DETAIL</td>
    <td class="td_kritis isi">TINGKAT KEKRITISAN</td>
    <td class="td_kriteria isi">YA / TIDAK / NA</td>
  </tr>
  <tr id="point5suba" y="Setiap penerimaan obat dilakukan pemeriksaan kesesuaian antara fisik dan dokumen (meliputi :  item, jumlah, nomor bets, tanggal kadaluarsa) serta pemeriksaan kebenaran/kondisi kemasan." t="Setiap penerimaan obat tidak dilakukan pemeriksaan kesesuaian antara fisik dan dokumen (meliputi :  item, jumlah, nomor bets, tanggal kadaluarsa) serta pemeriksaan kebenaran/kondisi kemasan.">
    <td class="td_no">a.&nbsp;</td>
    <td class="td_aspek">Apakah setiap penerimaan obat dilakukan pemeriksaan kesesuaian antara fisik dan dokumen (meliputi :  item, jumlah, nomor bets, tanggal kadaluarsa) serta pemeriksaan kebenaran/kondisi kemasan?</td>
    <td class="td_kritis">Tingkat Kekritisan (M)</td>
    <td class="td_kritis"><?php echo $aspek_penilaian[4]; ?></td>
  </tr>
  <tr id="point5subb" y="Setiap penerimaan obat dicatat pada kartu stok (secara manual atau elektronik)." t="Setiap penerimaan obat tidak dicatat pada kartu stok (secara manual atau elektronik).">
    <td class="td_no">b.&nbsp;</td>
    <td class="td_aspek">Apakah setiap penerimaan obat dicatat pada kartu stok (secara manual atau elektronik)?</td>
    <td class="td_kritis">Tingkat Kekritisan (M)</td>
    <td class="td_kritis"><?php echo $aspek_penilaian[5]; ?></td>
  </tr>
  <tr id="point5subc" y="Pengisian kartu stok sesuai dengan mencantumkan nomor bets dan kedaluwarsa obat." t="Pengisian kartu stok sesuai dengan tidak mencantumkan nomor bets dan kedaluwarsa obat.">
    <td class="td_no">c.&nbsp;</td>
    <td class="td_aspek">Apakah pengisian kartu stok sesuai dengan mencantumkan nomor bets dan kedaluwarsa obat?</td>
    <td class="td_kritis">Tingkat Kekritisan (M)</td>
    <td class="td_kritis"><?php echo $aspek_penilaian[6]; ?></td>
  </tr>
  <tr id="point5subd" y="Mempunyai sistem yang menjamin first in and first out / first exp first out." t="Tidak mempunyai sistem yang menjamin first in and first out / first exp first out.">
    <td class="td_no">d.&nbsp;</td>
    <td class="td_aspek">Apakah mempunyai sistem yang menjamin first in and first out / first exp first out ? </td>
    <td class="td_kritis">Tingkat Kekritisan (M)</td>
    <td class="td_kritis"><?php echo $aspek_penilaian[7]; ?></td>
  </tr>
  <tr id="point5subf" y="Semua obat disimpan pada kondisi sesuai dengan yang tercantum dalam kemasan obat serta terpisah dari komoditi lainnya?" t="Semua atau sebagian obat tidak disimpan pada kondisi sesuai dengan yang tercantum dalam kemasan obat serta tidak terpisah dari komoditi lainnya.">
    <td class="td_no">e.&nbsp;</td>
    <td class="td_aspek">Apakah obat disimpan pada kondisi sesuai dengan yang tercantum dalam kemasan obat serta terpisah dari komoditi lainnya?</td>
    <td class="td_kritis">Tingkat Kekritisan (M)</td>
    <td class="td_kritis"><?php echo $aspek_penilaian[8]; ?></td>
  </tr>
  <tr id="point5subf" y="Obat yang mendekati kadaluarsa, telah kadaluarsa, mengalami kerusakan kemasan, tutup atau yang diduga kemungkinan mengalami kontaminasi dan yang akan dimusnahkan diinventarisir, dipisahkan penyimpanannya dan terkunci." t="Obat yang mendekati kadaluarsa, telah kadaluarsa, mengalami kerusakan kemasan, tutup atau yang diduga kemungkinan mengalami kontaminasi dan yang akan dimusnahkan tidak diinventarisir, tidak dipisahkan penyimpanannya dan tidak terkunci.">
    <td class="td_no">f.&nbsp;</td>
    <td class="td_aspek">Apakah obat yang mendekati kadaluarsa, telah kadaluarsa, mengalami kerusakan kemasan, tutup atau yang diduga kemungkinan mengalami kontaminasi dan yang akan dimusnahkan diinventarisir, dipisahkan penyimpanannya dan terkunci?</td>
    <td class="td_kritis">Tingkat Kekritisan (M)</td>
    <td class="td_kritis"><?php echo $aspek_penilaian[9]; ?></td>
  </tr>
  <tr id="point5subg" y="Jumlah dalam kartu stok sesuai dengan jumlah fisik" t="Jumlah dalam kartu stok tidak sesuai dengan jumlah fisik">
    <td class="td_no">g.&nbsp;</td>
    <td class="td_aspek">Apakah jumlah dalam kartu stok sesuai dengan jumlah fisik?</td>
    <td class="td_kritis">Tingkat Kekritisan (M)</td>
    <td class="td_kritis"><?php echo $aspek_penilaian[10]; ?></td>
  </tr>
</table>
<h2 class="small">4. Penyaluran</h2>
<table class="form_tabel" group="4. Penyaluran">
  <tr>
    <td class="td_no isi">&nbsp;</td>
    <td class="td_aspek isi">ASPEK DAN DETAIL</td>
    <td class="td_kritis isi">TINGKAT KEKRITISAN</td>
    <td class="td_kriteria isi">YA / TIDAK / NA</td>
  </tr>
  <tr id="point6suba" y="Semua penyaluran berdasarkan Surat Pesanan/LPLPO  yang ditandatangani oleh penanggung jawab dan distempel." t="Semua atau sebagian penyaluran tidak berdasarkan Surat Pesanan/LPLPO yang ditandatangani oleh penanggung jawab dan distempel.">
    <td class="td_no">a.&nbsp;</td>
    <td class="td_aspek">Apakah setiap penyaluran berdasarkan Surat Pesanan/LPLPO yang ditandatangani oleh penanggung jawab dan distempel?</td>
    <td class="td_kritis">Tingkat Kekritisan (M)</td>
    <td class="td_kritis"><?php echo $aspek_penilaian[11]; ?></td>
  </tr>
  <tr id="point6subb" y="Obat yang dikirimkan disertai LPLPO/SPB yang ditandatangani oleh Penanggung Jawab" t="Obat yang dikirimkan tidak disertai LPLPO/SPB yang ditandatangani oleh Penanggung Jawab">
    <td class="td_no">b.&nbsp;</td>
    <td class="td_aspek">Apakah obat yang dikirimkan disertai LPLPO/SPB yang ditandatangani oleh Penanggung Jawab?</td>
    <td class="td_kritis">Tingkat Kekritisan (M)</td>
    <td class="td_kritis"><?php echo $aspek_penilaian[12]; ?></td>
  </tr>
  <tr id="point6subc" y="Dilakukan pengarsipan dokkumen penyaluran (LPLPO/SPB) dan mampu telusur?" t="Tidak dilakukan pengarsipan dokkumen penyaluran (LPLPO/SPB) dan mampu telusur">
    <td class="td_no">c.&nbsp;</td>
    <td class="td_aspek">Apakah dilakukan pengarsipan dokkumen penyaluran (LPLPO/SPB) dan mampu telusur?</td>
    <td class="td_kritis">Tingkat Kekritisan (M)</td>
    <td class="td_kritis"><?php echo $aspek_penilaian[13]; ?></td>
  </tr>
  <tr id="point6subd" y="Semua tanda terima LPLPO/surat penyerahan barang dibubuhi diberi tanda tangan, nama terang dan No. nomor SIPA/SIKTTK atau SIK tenaga kesehatan lain yang diberikan kewenangan dan distempel puskesmas?" t="Semua tanda terima LPLPO/surat penyerahan barang tidak dibubuhi diberi tanda tangan, nama terang dan No. nomor SIPA/SIKTTK atau SIK tenaga kesehatan lain yang diberikan kewenangan dan distempel puskesmas">
    <td class="td_no">d.&nbsp;</td>
    <td class="td_aspek">Apakah semua tanda terima LPLPO/surat penyerahan barang dibubuhi diberi tanda tangan, nama terang dan No. nomor SIPA/SIKTTK atau SIK tenaga kesehatan lain yang diberikan kewenangan dan distempel puskesmas?</td>
    <td class="td_kritis">Tingkat Kekritisan (M)</td>
    <td class="td_kritis"><?php echo $aspek_penilaian[14]; ?></td>
  </tr>
  <tr id="point6sube" y="Obat-obat yang disalurkan adalah obat-obat yang terdaftar" t="Obat-obat yang disalurkan adalah obat-obat yang tidak terdaftar.">
    <td class="td_no">e.&nbsp;</td>
    <td class="td_aspek">Apakah  obat-obat yang disalurkan adalah obat-obat yang terdaftar?</td>
    <td class="td_kritis">Tingkat Kekritisan (C)</td>
    <td class="td_kritis"><?php echo $aspek_penilaian[15]; ?></td>
  </tr>
</table>
<h2 class="small">5. Penarikan Kembali Obat (Recall)</h2>
<table class="form_tabel" group="5. Penarikan Kembali Obat (Recall)">
  <tr>
    <td class="td_no isi">&nbsp;</td>
    <td class="td_aspek isi">ASPEK DAN DETAIL</td>
    <td class="td_kritis isi">TINGKAT KEKRITISAN</td>
    <td class="td_kriteria isi">YA / TIDAK / NA</td>
  </tr>
  <tr id="point7suba" y="Recall dilakukan segera setelah diterima permintaan/perintah untuk penarikan kembali dilakukan secara menyeluruh dan tuntas" t="Recall tidak dilakukan segera setelah diterima permintaan/perintah untuk penarikan kembali dilakukan secara menyeluruh dan tuntas">
    <td class="td_no">a.&nbsp;</td>
    <td class="td_aspek">Apakah recall dilakukan segera setelah diterima permintaan/perintah untuk penarikan kembali dilakukan secara menyeluruh dan tuntas?</td>
    <td class="td_kritis">Tingkat Kekritisan (M)</td>
    <td class="td_kritis"><?php echo $aspek_penilaian[16]; ?></td>
  </tr>
  <tr id="point7subb" y="Sistem dokumentasi mendukung pelaksanaan recall secara efektif, cepat dan tuntas." t="Sistem dokumentasi tidak mendukung pelaksanaan recall secara efektif, cepat dan tuntas.">
    <td class="td_no">b.&nbsp;</td>
    <td class="td_aspek">Apakah sistem dokumentasi mendukung pelaksanaan recall secara efektif, cepat dan tuntas ?</td>
    <td class="td_kritis">Tingkat Kekritisan (M)</td>
    <td class="td_kritis"><?php echo $aspek_penilaian[17]; ?></td>
  </tr>
  <tr id="point7subc" y="Produk recall dicatat dalam Buku Penerimaan Pengembalian Barang kemudian diamankan di tempat terpisah dan terkunci sampai obat tersebut dikembalikan sesuai instruksi dari pihak yang berwenang." t="Produk recall tidak dicatat dalam Buku Penerimaan Pengembalian Barang, tidak diamankan di tempat terpisah dan terkunci sampai obat tersebut dikembalikan sesuai instruksi dari pihak yang berwenang.">
    <td class="td_no">c.&nbsp;</td>
    <td class="td_aspek">Apakah produk recall dicatat dalam Buku Penerimaan Pengembalian Barang kemudian diamankan di tempat terpisah dan terkunci sampai obat tersebut dikembalikan sesuai instruksi dari pihak yang berwenang?</td>
    <td class="td_kritis">Tingkat Kekritisan (M)</td>
    <td class="td_kritis"><?php echo $aspek_penilaian[18]; ?></td>
  </tr>
  <tr id="point7subd" y="Pelaksanaan penarikan atau hasil penarikan termasuk permintaan penghentian penyaluran serta Laporan Pengembalian Barang yang Ditarik dari Peredaran dilaporkan kepada Badan POM." t="Pelaksanaan penarikan atau hasil penarikan termasuk permintaan penghentian penyaluran serta Laporan Pengembalian Barang yang Ditarik dari Peredaran tidak dilaporkan kepada Badan POM.">
    <td class="td_no">d.&nbsp;</td>
    <td class="td_aspek">Apakah pelaksanaan penarikan atau hasil penarikan termasuk permintaan penghentian penyaluran serta Laporan Pengembalian Barang yang Ditarik dari Peredaran dilaporkan kepada Badan POM?</td>
    <td class="td_kritis">Tingkat Kekritisan (M)</td>
    <td class="td_kritis"><?php echo $aspek_penilaian[19]; ?></td>
  </tr>
</table>
<h2 class="small">6. Penanganan Produk Ilegal</h2>
<table class="form_tabel" group="6. Penanganan Produk Ilegal">
  <tr>
    <td class="td_no isi">&nbsp;</td>
    <td class="td_aspek isi">ASPEK DAN DETAIL</td>
    <td class="td_kritis isi">TINGKAT KEKRITISAN</td>
    <td class="td_kriteria isi">YA / TIDAK / NA</td>
  </tr>
  <tr id="point8suba" y="Obat palsu/diduga palsu yang ditemukan dalam jaringan distribusi obat diamankan terpisah dari obat lain, terkunci dan diberi penandaan tidak untuk disalurkan." t="Obat palsu/diduga palsu yang ditemukan dalam jaringan distribusi obat tidak diamankan terpisah dari obat lain, terkunci dan diberi penandaan tidak untuk disalurkan.">
    <td class="td_no">a.&nbsp;</td>
    <td class="td_aspek">Apakah obat palsu/diduga palsu yang ditemukan dalam jaringan distribusi obat diamankan terpisah dari obat lain, terkunci dan diberi penandaan tidak untuk disalurkan? </td>
    <td class="td_kritis">Tingkat Kekritisan (M)</td>
    <td class="td_kritis"><?php echo $aspek_penilaian[20]; ?></td>
  </tr>
  <tr id="point8subb" y="Instalasi Farmasi menghubungi produsen obat dan melaporkan ke Badan POM jika ditemukan obat palsu/diduga palsu." t="Instalasi Farmasi tidak menghubungi produsen obat dan melaporkan ke Badan POM jika ditemukan obat palsu/diduga palsu.">
    <td class="td_no">b.&nbsp;</td>
    <td class="td_aspek">Apakah instalasi farmasi menghubungi produsen obat dan melaporkan ke Badan POM jika ditemukan obat palsu/diduga palsu?</td>
    <td class="td_kritis">Tingkat Kekritisan (M)</td>
    <td class="td_kritis"><?php echo $aspek_penilaian[21]; ?></td>
  </tr>
</table>
<h2 class="small">7. Penanganan Produk Kembalian dan Kadaluarsa</h2>
<table class="form_tabel" group="7. Penanganan Produk Kembalian dan Kadaluarsa">
  <tr>
    <td class="td_no isi">&nbsp;</td>
    <td class="td_aspek isi">ASPEK DAN DETAIL</td>
    <td class="td_kritis isi">TINGKAT KEKRITISAN</td>
    <td class="td_kriteria isi">YA / TIDAK / NA</td>
  </tr>
  <tr id="point9suba" y="Jumlah dan identitas obat yang dikembalikan sesuai dengan bukti penyaluran dan pengembalian." t="Jumlah dan identitas obat yang dikembalikan tidak sesuai dengan bukti penyaluran dan pengembalian.">
    <td class="td_no">a.&nbsp;</td>
    <td class="td_aspek">Apakah jumlah dan identitas obat yang dikembalikan sesuai dengan bukti penyaluran dan pengembalian?</td>
    <td class="td_kritis">Tingkat Kekritisan (M)</td>
    <td class="td_kritis"><?php echo $aspek_penilaian[22]; ?></td>
  </tr>
  <tr id="point9subb" y="Obat kembalian yang diterima karena tidak memenuhi syarat mutu dan yang mengalami kerusakan penandaan, dikarantina dan terkunci." t="Obat kembalian yang diterima karena tidak memenuhi syarat mutu dan yang mengalami kerusakan penandaan tidak dikarantina dan tidak terkunci.">
    <td class="td_no">b.&nbsp;</td>
    <td class="td_aspek">Apakah obat kembalian yang diterima karena tidak memenuhi syarat mutu dan yang mengalami kerusakan penandaan, dikarantina dan terkunci?</td>
    <td class="td_kritis">Tingkat Kekritisan (M)</td>
    <td class="td_kritis"><?php echo $aspek_penilaian[23]; ?></td>
  </tr>
</table>
<h2 class="small">8. Pengembalian Obat Ke Sumber Pengadaan</h2>
<table class="form_tabel" group="8. Pengembalian Obat Ke Sumber Pengadaan">
  <tr>
    <td class="td_no isi">&nbsp;</td>
    <td class="td_aspek isi">ASPEK DAN DETAIL</td>
    <td class="td_kritis isi">TINGKAT KEKRITISAN</td>
    <td class="td_kriteria isi">YA / TIDAK / NA</td>
  </tr>
  <tr id="point10" y="Pengembalian obat kepada sumber pengadaan menggunakan Surat Penyerahan Barang dan didokumentasikan." t="Pengembalian obat kepada sumber pengadaan tidak menggunakan Surat Penyerahan Barang dan tidak didokumentasikan.">
    <td class="td_no">a.&nbsp;</td>
    <td class="td_aspek">Apakah pengembalian obat kepada sumber pengadaan menggunakan Surat Penyerahan Barang dan didokumentasikan?</td>
    <td class="td_kritis">Tingkat Kekritisan (M)</td>
    <td class="td_kritis"><?php echo $aspek_penilaian[24]; ?></td>
  </tr>
</table>
<h2 class="small">9. Pemusnahan</h2>
<table class="form_tabel" group="9. Pemusnahan">
  <tr>
    <td class="td_no isi">&nbsp;</td>
    <td class="td_aspek isi">ASPEK DAN DETAIL</td>
    <td class="td_kritis isi">TINGKAT KEKRITISAN</td>
    <td class="td_kriteria isi">YA / TIDAK / NA</td>
  </tr>
  <tr id="point11suba" y="Pemusnahan obat dilaksanakan sesuai dengan ketentuan." t="Pemusnahan obat tidak dilaksanakan sesuai dengan ketentuan.">
    <td class="td_no">a.&nbsp;</td>
    <td class="td_aspek">Apakah pemusnahan obat dilaksanakan sesuai dengan ketentuan?</td>
    <td class="td_kritis">Tingkat Kekritisan (M)</td>
    <td class="td_kritis"><?php echo $aspek_penilaian[25]; ?></td>
  </tr>
  <tr id="point11subb" y="Pelaksanaan pemusnahan dilaporkan kepada Badan POM atau Balai Besar/Balai POM setempat dengan melampirkan Berita Acara Pelaksanaan Pemusnahan yang ditandatangani oleh pelaksana pemusnahan dan saksi." t="Pelaksanaan pemusnahan tidak dilaporkan kepada Badan POM atau Balai Besar/Balai POM setempat dengan melampirkan Berita Acara Pelaksanaan Pemusnahan yang ditandatangani oleh pelaksana pemusnahan dan saksi.">
    <td class="td_no">b.&nbsp;</td>
    <td class="td_aspek">Apakah pelaksanaan pemusnahan dilaporkan kepada Badan POM atau Balai Besar/Balai POM setempat dengan melampirkan Berita Acara Pelaksanaan Pemusnahan yang ditandatangani oleh pelaksana pemusnahan dan saksi ?</td>
    <td class="td_kritis">Tingkat Kekritisan (M)</td>
    <td class="td_kritis"><?php echo $aspek_penilaian[26]; ?></td>
  </tr>
</table>
<h2 class="small">10. Pengelolaan Vaksin</h2>
<h2 class="small" style="margin-left:20px;">Personalia</h2>
<table class="form_tabel" group="Personalia">
  <tr>
    <td class="td_no isi">&nbsp;</td>
    <td class="td_aspek isi">ASPEK DAN DETAIL</td>
    <td class="td_kritis isi">TINGKAT KEKRITISAN</td>
    <td class="td_kriteria isi">YA / TIDAK / NA</td>
  </tr>
  <tr id="point12seri1a" y="Petugas yang menangani vaksin/CCP mendapatkan pelatihan sesuai tanggung jawabnya dan tidak terdokumentasi." t="Petugas yang menangani vaksin/CCP tidak mendapatkan pelatihan sesuai tanggung jawabnya dan tidak terdokumentasi.">
    <td class="td_no">a.&nbsp;</td>
    <td class="td_aspek">Apakah petugas yang menangani vaksin/CCP mendapatkan pelatihan sesuai tanggung jawabnya dan terdokumentasi?</td>
    <td class="td_kritis">Tingkat Kekritisan (M)</td>
    <td class="td_kritis"><?php echo $aspek_penilaian[27]; ?></td>
  </tr>
</table>
<h2 class="small" style="margin-left:20px;">Bangunan dan Penyimpanan Vaksin / CCP </h2>
<table class="form_tabel" group="Bangunan dan Penyimpanan Vaksin / CCP">
  <tr>
    <td class="td_no isi">&nbsp;</td>
    <td class="td_aspek isi">ASPEK DAN DETAIL</td>
    <td class="td_kritis isi">TINGKAT KEKRITISAN</td>
    <td class="td_kriteria isi">YA / TIDAK / NA</td>
  </tr>
  <tr id="point12seri2a" y="Tersedia tempat terpisah untuk penyimpanan produk vaksin/CCP sesuai dengan spesifikasi produk." t="Tidak tersedia tempat terpisah untuk penyimpanan produk vaksin/CCP sesuai dengan spesifikasi produk.">
    <td class="td_no">a.&nbsp;</td>
    <td class="td_aspek">Apakah tersedia tempat terpisah untuk penyimpanan produk vaksin/CCP sesuai dengan spesifikasi produk?</td>
    <td class="td_kritis">Tingkat Kekritisan (C)</td>
    <td class="td_kritis"><?php echo $aspek_penilaian[28]; ?></td>
  </tr>
  <tr id="point12serie" y="Tempat penyimpanan vaksin/CCP dilengkapi dengan alat pemantau suhu (termometer) yang terkalibrasi dan tidak dilakukan monitoring suhu serta pencatatan secara berkala (minimal sehari tiga kali dengan interval yang memadai)" t="Tempat penyimpanan vaksin/CCP tidak dilengkapi dengan alat pemantau suhu (termometer) yang terkalibrasi dan tidak dilakukan monitoring suhu serta pencatatan secara berkala (minimal sehari tiga kali dengan interval yang memadai)">
    <td class="td_no">b.&nbsp;</td>
    <td class="td_aspek">Apakah tempat penyimpanan dilengkapi dengan alat pemantau suhu (termometer) yang terkalibrasi dan dilakukan monitoring suhu serta pencatatan secara berkala (minimal sehari tiga kali dengan interval yang memadai)?</td>
    <td class="td_kritis">Tingkat Kekritisan (M)</td>
    <td class="td_kritis"><?php echo $aspek_penilaian[29]; ?></td>
  </tr>
  <tr id="point12seri2c" y="Mempunyai generator otomatis yang berfungsi dengan baik atau mempunyai petugas  yang dapat menjamin generator yang tidak otomatis berfungsi dengan baik selama 24 jam." t="Tidak mempunyai generator otomatis yang berfungsi dengan baik atau tidak mempunyai petugas  yang dapat menjamin generator yang tidak otomatis berfungsi dengan baik selama 24 jam.">
    <td class="td_no">c.&nbsp;</td>
    <td class="td_aspek">Apakah mempunyai generator otomatis yang berfungsi dengan baik? Atau Apakah mempunyai petugas  yang dapat menjamin generator yang tidak otomatis berfungsi dengan baik selama 24 jam?</td>
    <td class="td_kritis">Tingkat Kekritisan (C)</td>
    <td class="td_kritis"><?php echo $aspek_penilaian[30]; ?></td>
  </tr>
</table>
<h2 class="small" style="margin-left:20px;">Penyaluran Vaksin / CCP</h2>
<table class="form_tabel" group="Penyaluran Vaksin / CCP">
  <tr>
    <td class="td_no isi">&nbsp;</td>
    <td class="td_aspek isi">ASPEK DAN DETAIL</td>
    <td class="td_kritis isi">TINGKAT KEKRITISAN</td>
    <td class="td_kriteria isi">YA / TIDAK / NA</td>
  </tr>
  <tr id="point12seri3a" y="Penyaluran vaksin/CCP menggunakan wadah kedap yang dilengkapi ice pack/dry ice sedemikian rupa sehingga mencapai temperatur yang sesuai dengan vaksin tersebut." t="Penyaluran vaksin/CCP tidak menggunakan wadah kedap yang dilengkapi ice pack/dry ice sedemikian rupa sehingga mencapai temperatur yang sesuai dengan vaksin tersebut.">
    <td class="td_no">a.&nbsp;</td>
    <td class="td_aspek">Apakah penyaluran vaksin menggunakan wadah kedap yang dilengkapi ice pack/dry ice sedemikian rupa sehingga mencapai temperatur yang sesuai dengan vaksin tersebut?</td>
    <td class="td_kritis">Tingkat Kekritisan (C)</td>
    <td class="td_kritis"><?php echo $aspek_penilaian[31]; ?></td>
  </tr>
</table>
<h2 class="small">Hasil Temuan Lainnya yang Tidak Tercantum dalam Aspek Penilaian</h2>
<table id="form_tabel">
  <tr>
    <td class="td_left">&nbsp;</td>
    <td class="td_right"><?php echo array_key_exists('HASIL_TEMUAN_LAIN', $sess)?preg_replace('/[^(\x20-\x7F)]*/','',html_entity_decode($sess['HASIL_TEMUAN_LAIN'])):'';?></td>
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
  <tr class="header">
    <th>Detil Produk</th>
    <th>Detil Perusahaan</th>
    <th>Temuan</th>
    <th>Tindakan</th>
    <th>Keterangan</th>
  </tr>
  <?php
if($sess['JUMLAH_TEMUAN'] != 0){
	for($i=0; $i<count($temuan_produk); $i++){
		?>
  <tr>
    <td>Nama Produk : <?php echo $temuan_produk[$i]['NAMA_PRODUK']; ?><br>
      Nama Pabrik : <?php echo $temuan_produk[$i]['NAMA_PABRIK']; ?><br>
      Negara Asal : <?php echo $temuan_produk[$i]['NEGARA_ASAL']; ?><br>
      Kemasan : <?php echo $temuan_produk[$i]['KEMASAN']; ?><br>
      NIE : <?php echo $temuan_produk[$i]['NOMOR_REGISTRASI']; ?><br>
      No. Lot / Bets : <?php echo $temuan_produk[$i]['NO_BATCH']; ?><br>
      Tanggal Expire : <?php echo $temuan_produk[$i]['TANGGAL_EXPIRE']; ?></td>
    <td>Produsen : <?php echo $temuan_produk[$i]['NAMA_PERUSAHAAN']; ?><br>
      Pendaftar : <?php echo $temuan_produk[$i]['PEMILIK']; ?><br />
      Alamat : <?php echo $temuan_produk[$i]['ALAMAT_PERUSAHAAN']; ?></td>
    <td>Kategori Temuan : <?php echo $temuan_produk[$i]['KATEGORI']; ?><br>
      Jumlah Temuan : <?php echo $temuan_produk[$i]['JUMLAH_TEMUAN']; ?></td>
    <td><?php echo $temuan_produk[$i]['TINDAKAN_PRODUK']; ?></td>
    <td><?php echo $temuan_produk[$i]['KETERANGAN_SUMBER']; ?></td>
  </tr>
  <?php
	}
}else{
	$temuan_produk = "";
} ?>
</table>
<?php } ?>
