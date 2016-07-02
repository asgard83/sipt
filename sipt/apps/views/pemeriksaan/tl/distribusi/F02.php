<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);
?>
<style>
body {font-family:Georgia, "Times New Roman", Times, serif; font-size:12px;}
@page {margin-top: 3.5cm; margin-bottom: 3.5cm; margin-left: 2.3cm; margin-right: 2.3cm;}
td{vertical-align:top;}
table.kop {left;border:1px solid #000;border-collapse:collapse;}
table.kop td{vertical-align:top; border-bottom:1px solid #000;border-left:1px solid #000; padding-left:5px;}
</style>
<htmlpageheader name="myHTMLHeaderOdd" style="display:none">
<div>
<table class="kop" width="100%" cellpadding="0" cellspacing="0">
  <tr>
    <td width="111" rowspan="5" align="center"><img src="<?php echo base_url(); ?>images/kop.jpg" /></td>
    <td width="202">Nomor Formulir</td>
    <td width="374">POM-03.SOP.14.IK.01(34)/F.02</td>
  </tr>
  <tr>
    <td>Nama Formulir</td>
    <td>Penghentian Sementara Kegiatan/Penghentian Kegiatan Sarana</td>
  </tr>
  <tr>
    <td>Nomor / Tanggal Revisi</td>
    <td>0</td>
  </tr>
  <tr>
    <td>Tanggal Efektif</td>
    <td>10 Oktober 2011</td>
  </tr>
  <tr>
    <td>Halaman</td>
    <td>{PAGENO} / {nb}</td>
  </tr>
</table>
</div>
</htmlpageheader>
<sethtmlpageheader name="myHTMLHeaderOdd" page="O" value="on" show-this-page="1" />
<table width="100%" style="font-size:12px;">
  <tr>
    <td width="14%">Nomor</td>
    <td width="3%">:</td>
    <td width="47%"><?php echo $sess['SURAT TL']; ?></td>
    <td width="36%"><?php echo $sess['TEMPAT']; ?>, <?php echo $sess['TANGGAL TL']; ?></td>
  </tr>
  <tr>
    <td>Lampiran</td>
    <td>:</td>
    <td><?php echo $sess['LAMPIRAN']; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Perihal</td>
    <td>:</td>
    <td><?php echo $sess['PERIHAL SURAT']; ?><br /><?php echo $sess['NAMA_SARANA']; ?><br><?php echo $sess['ALAMAT_1']; ?><br></td>
    <td></td>
  </tr>
</table>
<div style="height:30px;"></div>
<div style="text-align:justify">
Sehubungan dengan Pemeriksaan Sarana Nomor Surat : <?php echo $sess['NOMOR']; ?> dan Tanggal Surat <?php echo $sess['TANGGAL']; ?>, ditemukan data bahwa <?php echo $sess['NAMA_SARANA']; ?>.<br>
Bahwa kegiatan <?php echo $sess['NAMA_SARANA']; ?> tersebut telah melanggar : <br>
<ul style="list-style-type:decimal; padding-left:30px; margin:0;"><?php $hasil_temuan = explode("___", $sess['HASIL_TEMUAN']); echo "<li>".join("</li><li>", $hasil_temuan)."</li>"; ?></ul>
</div>

<div style="height:30px;"></div>
<div style="text-align:justify">
Bahwa berdasarkan hal tersebut di atas, dengan ini kami menetapkan dan memberikan sanksi berupa Penghentian Sementara Kegiatan kepada PBF  <?php echo $sess['NAMA_SARANA']; ?> selama ............. terhitung mulai tanggal pelaksanaan penghentian oleh Balai Besar/Balai POM di................ / sampai ………*
</div>
<div style="height:20px;"></div>
<div style="text-align:justify">
Selama masa penghentian sementara kegiatan/penghentian kegiatan, Saudara kami harapkan agar melakukan penertiban sistem penyaluran obat sesuai ketentuan yang berlaku. 
</div>

<div style="height:30px;"></div>
<div style="text-align:justify">
Penghentian Sementara Kegiatan/Penghentian Kegiatan* PBF Saudara dapat diaktifkan kembali kegiatannya dengan persetujuan kami setelah mempertimbangkan:<br />
<ul style="list-style:decimal;">
	<li>Surat permohonan dari PBF untuk mengaktifkan kembali PBF-nya</li>
	<li>CAPA yang telah dilakukan PBF, terhadap temuan pelanggaran berdasarkan hasil pemeriksaan</li>
	<li>Surat pernyataan di atas kertas bermaterai dari PBF untuk tidak melakukan pelanggaran lagi yang ditandatangani oleh Penanggung Jawab dan Pimpinan PBF<li>
	<li>Telah selesai masa penghentian ............. sejak tanggal pelaksanaan penghentian kegiatan oleh Balai Besar/Balai POM di <?php echo $sess['TEMPAT']; ?> pemenuhan persyaratan berdasarkan temuan hasil inspeksi*.</li>

</ul>
</div>

<div style="height:30px;"></div>
<div style="text-align:justify">
Apabila pada pemeriksaan yang akan datang masih ditemukan pelanggaran, kami akan memberikan sanksi yang lebih berat sesuai peraturan perundang-undangan yang berlaku. <br />
</div>

<div style="height:30px;"></div>
Demikian agar dilaksanakan dengan sebaik-baiknya.<br />
<div style="height:30px;"></div>
<table width="100%">
  <tr>
    <td width="50%">&nbsp;</td>
    <td width="50%" style="text-align:center"><b>BADAN PENGAWAS OBAT DAN MAKANAN</b></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td style="text-align:center"><b>KEPALA</b></td>
  </tr>
  <tr>
    <td width="50%">&nbsp;</td>
    <td style="text-align:center">&nbsp;</td>
  </tr>
  <tr>
    <td width="50%" style="height:80px;">&nbsp;</td>
    <td style="text-align:center; height:80px;">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td style="text-align:center; border-bottom:1px solid #000;">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td style="text-align:center">NIP : </td>
  </tr>
</table>

<div style="height:30px;"></div>
<div>
Tembusan : <br>
<?php echo $sess['TEMBUSAN']; ?>
</div>

