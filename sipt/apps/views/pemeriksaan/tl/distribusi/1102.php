<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);
?>
<style>
<?php if($ispdf){ ?>
	body {font-family:Georgia, "Times New Roman", font-size:12pt;}
	@page {margin-top: 3.5cm; margin-bottom: 3.5cm; margin-left: 2.3cm; margin-right: 2.3cm;}
	/*table{border-collapse:collapse; width:100%; font-size:12px; vertical-align:top;}*/
<?php }else{ ?>
	body {font-family: "lucida grande", Tahoma, verdana, arial, sans-serif; font-size:11px;}
	/*table{border-collapse:collapse; width:100%; font-size:11px; vertical-align:top;}*/
	table.detil table{border-collapse:collapse; width:100%; font-size:11px;}
<?php } ?>
</style>
<table <?php if($ispdf) echo 'width="100%"'; else echo 'class="detil" width="100%"'; ?>>
  <tr>
    <td width="14%">Nomor</td>
    <td width="3%">:</td>
    <td width="47%"><?php echo $sess['SURAT TL']; ?></td>
    <td width="36%"><?php echo $sess['TEMPAT']; ?>, <?php echo $sess['TANGGAL TL']; ?></td>
  </tr>
  <tr>
    <td>Lampiran</td>
    <td>:</td>
    <td colspan="2"><?php echo $sess['LAMPIRAN']; ?></td>
  </tr>
  <tr>
    <td>Perihal</td>
    <td>:</td>
    <td colspan="2"><?php echo $sess['PERIHAL SURAT']; ?></td>
  </tr>
</table>
<div style="height:30px;"></div>
Kepada Yth.<br>
Pimpinan dan Asisten Apoteker Penanggung Jawab<br>
<?php echo $sess['NAMA_SARANA']; ?><br>
<?php echo $sess['ALAMAT_1']; ?><br>
<div style="height:30px;"></div>

<div style="text-align:justify; padding-bottom:20px;">
Sehubungan dengan Pemeriksaan Sarana Nomor Surat : <?php echo $sess['NOMOR']; ?> dan Tanggal Surat <?php echo $sess['TANGGAL']; ?>, ditemukan data bahwa <?php echo $sess['NAMA_SARANA']; ?> melakukan kegiatan sebagai berikut : <br />
<?php if(trim($sess['KEGIATAN_SARANA']) != ""){ ?>
<ul style="list-style-type:decimal; padding-left:20px; margin:0;"><?php $kegiatan = explode(";", $sess['KEGIATAN_SARANA']); echo "<li>".join("</li><li>", $kegiatan)."</li>"; ?></ul>
<?php }else{ echo "-"; } ?>
</div>
<div style="text-align:justify;">
Bahwa kegiatan <?php echo $sess['NAMA_SARANA']; ?> tersebut telah melanggar : <br>
<ul style="list-style-type:decimal; padding-left:30px; margin:0;"><?php $hasil_temuan = explode("___", $sess['HASIL_TEMUAN']); echo "<li>".join("</li><li>", $hasil_temuan)."</li>"; ?></ul>
</div>

<div style="height:30px;"></div>
<div style="text-align:justify">
Bahwa berdasarkan hal tersebut di atas, dengan ini kami menetapkan dan memberikan sanksi berupa <b><?php echo $sess['PERIHAL SURAT']; ?></b> kepada <?php echo $sess['NAMA_SARANA']; ?> dan kami minta Saudara agar memperbaiki pelaksanaan penyaluran obat dan pengelolaan administrasi PBF sesuai dengan ketentuan yang berlaku dalam jangka waktu selambat-lambatnya 2 (dua) bulan dan melaporkan hasil dari perbaikan tersebut ke Badan POM c.q. Direktorat Pengawasan Distribusi Produk Terapetik dan PKRT.
</div>

<div style="height:30px;"></div>
<div style="text-align:justify">
Apabila pada pemeriksaan yang berikut masih ditemukan pelanggaran, kami akan memberikan sanksi yang lebih berat sesuai dengan peraturan perundang-undangan yang berlaku. 
</div>

<div style="height:30px;"></div>
<div style="text-align:justify">
Demikian, agar dilaksanakan dengan sebaik-baiknya. 
</div>

<div style="height:30px;"></div>
<?php if($ispdf){ ?>
<table width="100%">
   <tr>
    <td width="50%">&nbsp;</td>
    <td style="text-align:center"><?php echo $sess['JABATAN']; ?></td>
  </tr>
  <tr>
    <td width="50%" style="height:80px;">&nbsp;</td>
    <td style="text-align:center; height:80px;">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td style="text-align:center; border-bottom:1px solid #000;"><?php echo $sess['NAMA TTD']; ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td style="text-align:center">NIP : <?php echo $sess['NIP']; ?></td>
  </tr>
</table>
<?php } else{ ?>
<table class="detil" width="100%">
   <tr>
    <td width="50%">&nbsp;</td>
    <td style="text-align:center"><?php echo $sess['JABATAN']; ?></td>
  </tr>
  <tr>
    <td width="50%" style="height:80px;">&nbsp;</td>
    <td style="text-align:center; height:80px;">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td style="text-align:center;"><?php echo $sess['NAMA TTD']; ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td style="text-align:center">NIP : <?php echo $sess['NIP']; ?></td>
  </tr>
</table>
<?php } ?>

<div style="height:30px;"></div>
<div>
Tembusan : <br>
<?php echo $sess['TEMBUSAN']; ?>
</div>

