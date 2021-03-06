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
Kepada Yth <br />
Pimpinan dan Apoteker Penangungg Jawab <br />
<?php echo $sess['NAMA_SARANA']; ?><br />
<?php echo $sess['ALAMAT_1']; ?>
<div style="height:30px;"></div>

<div style="text-align:justify; padding-bottom:20px;">
Berdasarkan : <br />
<?php echo $sess['POINT']; ?>
</div>

<div style="height:30px;"></div>
<div style="text-align:justify">
dengan ini kami beritahukan bahwa Saudara : <br />
<?php echo $sess['PELANGGARAN']; ?>
</div>

<div style="height:30px;"></div>
<div style="text-align:justify">
<ul style="list-style:decimal;">
	<li>Sehubungan dengan hal tersebut di atas, kepada Saudara kami berikan sanksi berupa <b><?php echo $sess['PERIHAL SURAT']; ?></b> produksi pada fasilitas produksi : <?php echo $sess['TINDAKAN']; ?> selama <?php echo $sess['AWAL_PSK']; ?> terhitung sejak dilaksanakan penghentian sementara kegiatan oleh <?php echo $sess['BALAI']; ?> / sampai dengan fasilitas memenuhi persyaratan CPOKB</li>
</ul>
</div>

<div style="height:30px;"></div>
<div style="text-align:justify;">
<b><?php echo $sess['PERIHAL SURAT']; ?></b> Saudara dapat diaktifkan kembali kegiatannya dengan persetujuan kami setelah mempertimbangkan:
<ul style="list-style-type:decimal;">
	<li>Surat permohonan dari PBF untuk mengaktifkan kembali PBF-nya.</li>
    <li>CAPA yang telah dilakukan PBF, terhadap temuan pelanggaran berdasarkan hasil pemeriksaan.</li>
    <li>Surat pernyataan di atas kertas bermaterai dari PBF untuk tidak melakukan pelanggaran lagi yang ditandatangani oleh Penanggung Jawab dan Pimpinan PBF.</li>
    <li>Telah selesai masa penghentian <?php echo $sess['AKHIR_PSK']; ?> sejak tanggal pelaksanaan penghentian kegiatan oleh <?php echo $sess['BALAI']; ?> / pemenuhan persyaratan berdasarkan temuan hasil inspeksi.</li>
</ul>
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

