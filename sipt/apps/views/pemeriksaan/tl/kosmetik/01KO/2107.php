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
    <td colspan="2"><?php echo substr($sess['PERIHAL SURAT'],0,16); ?></td>
  </tr>
</table>
<div style="height:30px;"></div>
Kepada Yth <br />
Pimpinan<br />
<?php echo $sess['NAMA_SARANA']; ?><br />
<?php echo $sess['ALAMAT_1']; ?>
<div style="height:30px;"></div>

<div style="text-align:justify; padding-bottom:20px;">
Berdasarkan hasil pengawasan, ditemukan kosmetik Saudara tercemar miikroba sebagaimana terlampir. <br /><br />
Untuk itu Saudara telah melanggar Undang-Undang nomor 36 Tahun 2009 tentang Kesehatan Pasal 196 yang berbunyi : "Setiap orang yang dengan sengaja memproduksi atau mengedarkan sediaan farmasi dan/atau alat kesehatan yang tidak memenuhi standar dan/atau persyaratan keamanan, khasiat atau kemanfaatan, dan mutu sebagaimana dimaksud dalam Pasal 98 ayat (2) dan dan ayat (3) dipidana dengan pidana penjara paling lama 10 (sepuluh) tahun dan denda paling banyak Rp. 1.000.000.000,00 (satu miliar rupiah)"
</div>

<div style="text-align:justify;"> Berkenaan dengan hal tersebut, dalam upaya melindungi masyarakat dari efek yang merugikan, Saudara kami berikan <b><?php echo substr($sess['PERIHAL SURAT'],0,16); ?></b> dan diminta untuk melakukan hal-hal sebagai berikut :
<br />
<ul style="list-style-type:decimal;">
	<li>Menarik dari peredaran dan memusnahkan kosmetik yang tidak memenuhi syarat dengan nomor bets tersebut dengan disaksikan oleh petugas Balai Besar POM.</li>
    <li>Memperbaiki proses produksi dengan menerapkan prinsip Cara Pembuatan Kosmetik yang Baik secara konsisten sehingga kosmetik yang diproduksi senantiasa memenuhi persyaratan yang ditetapkan.</li>
    <li>Tidak mengedarkan produk yang tidak memenuhi persyaratan, sebelum diedarkan terlebih dahulu dilakukan pengujian mutu.</li>
    <li>Melaporkan hasil pelaksanaan perbaikan produksi paling lama 3 (tiga) bulan setelah tanggal surat kepada Kepala Badan POM c.q. Direktorat Inspeksi dan Sertifikasi Obat Tradisional, Kosmetik dan Produk Komplemen.</li>
</ul>
</div>

<div style="height:20px;"></div>
<div style="text-align:justify">
Demikian, atas perhatian dan kerja sama Saudara diucapkan terima kasih.
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

