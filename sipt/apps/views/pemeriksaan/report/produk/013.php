<?php 
if(!defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);
?>
<style type="text/css">
table.xcel{text-align: left;border:1px solid #000; border:thin; color:#000; font-family: "lucida grande", Tahoma, verdana, arial, sans-serif; font-size:10px; direction:ltr;}
table.xcelheader{text-align: left; border-collapse:collapse; color:#000; font-family: "lucida grande", Tahoma, verdana, arial, sans-serif; font-size:10px; direction:ltr;}
</style>
<div>
<table class="xcelheader">
	<td colspan="9"><b>LAPORAN BB/B POM PEMERIKSAAN SARANA TERKAIT TEMUAN PRODUK</b></td></tr>
	<tr><td>&nbsp;</td><td>Komoditi</td><td colspan="7"><b><?php echo $judul; ?></b></td></tr>
	<tr><td>&nbsp;</td><td>Pemeriksaan Awal</td><td colspan="7"><?php echo $awal; ?></td></tr>
	<tr><td>&nbsp;</td><td>Pemeriksaan Akhir</td><td colspan="7"><?php echo $akhir; ?></td></tr>
    <tr><td>&nbsp;</td><td>Balai Besar / Balai Pemeriksa</td><td colspan="7"><?php echo $balai; ?></td></tr>      
    <tr><td colspan="9">&nbsp;</td></tr>
</table>
</div>
<table class="xcel">
  <tr>
    <th style="border:1px solid #000; border:thin; background:#CCC;">No</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Nama Produk</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Nama Produsen</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Jenis Registrasi</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Nomor Registrasi</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Kemasan</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Satuan</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Kategori</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Harga</th>
    <?php if($balai == "Seluruh Balai"){?>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Balai Pemeriksa</th>
    <?php } ?>
  </tr>
  <?php if(count($temuan) > 0){ 
  $n = 1;
  for($z=0; $z<count($temuan); $z++){
  ?>
  <tr>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $n; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $temuan[$z]['NAMA_PRODUK']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $temuan[$z]['PRODUSEN']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $temuan[$z]['REGISTRASI']; ?></td>
    <td valign="top" align="left" style="border:1px solid #000; border:thin;"><?php echo $temuan[$z]['NOMOR_REGISTRASI']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $temuan[$z]['KEMASAN']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $temuan[$z]['SATUAN']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $temuan[$z]['KATEGORI']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $temuan[$z]['HARGA']; ?></td>
	<?php if($balai == "Seluruh Balai"){?>
   <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $temuan[$z]['NAMA_BBPOM']; ?></td>
    <?php } ?>

  </tr>
  <?php $n++; } } else{ ?>	
  <tr>
    <td valign="top" style="border:1px solid #000; border:thin;" colspan="9">Data Tidak Ditemukan</td>
  </tr>
  <?php } ?>
</table>
