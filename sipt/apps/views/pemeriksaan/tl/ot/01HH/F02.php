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
Pimpinan <?php echo $sess['NAMA_SARANA']; ?><br />
<?php echo $sess['ALAMAT_1']; ?>
<div style="height:30px;"></div>

<div style="text-align:justify; padding-bottom:20px;">Berdasarkan hasil pengawasan, ditemukan kosmetik Saudara Tanpa Izin Edar sebagaimana terlampir.
</div>

<div style="text-align:justify;">Untuk itu Saudara telah melanggar Undang-Undang No. 36 Tahun 2009 tentang Kesehatan, pasal 197 yang berbunyi ayat : "Setiap orang yang dengan sengaja memiliki izin edar sebagaimana di maksud dalam pasal 106 ayat (1) dipidana dengan pidana paling lama 15 (lima belas) tahun dan denda paling banyak Rp. 1.500.000.000,00 (satu miliar lima ratus juta rupiah).
</div>

<div style="text-align:justify">
Berkenaan dengan itu kepada Saudara, kami berikan <?php echo $sess['PERIHAL SURAT']; ?> dan segera melakukan hal-hal sebagai berikut :
<ul style="list-style:decimal; text-align:justify;">
	<li>Menarik semua kosmetik yang tidak memiliki nomor pendaftaran dari peredaran</li>
    <li>Tidak memproduksi kosmetik yang belum memiliki nomor pendaftaran dari Badan POM</li>
    <li>Melakukan inventarisasi jumlah yang ditarik dan diedarkan</li>
    <li>Melaporkan hasil pelaksanaan butir 1 s/d 3 di atas paling lama 3 (tiga) bulan setelah tanggal surat kepada Badan POM c.q. Direktorat Inspeksi dan Sertifikasi Obat Tradisional, Kosmetik dan Produk Komplemen</li>
</ul>
</div>

<div style="height:20px;"></div>
<div style="text-align:justify;">Demikian, atas perhatian dan kerja sama Saudara diucapkan terima kasih.
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

