<?php 
if(!defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);
?>
<style>
table.xcel{text-align: left;border:1px solid #000; border:thin; color:#000; font-family: "lucida grande", Tahoma, verdana, arial, sans-serif; font-size:10px; direction:ltr;}
table.xcelheader{text-align: left; border-collapse:collapse; color:#000; font-family: "lucida grande", Tahoma, verdana, arial, sans-serif; font-size:10px; direction:ltr;}
</style>
<div>
<table class="xcelheader">
	<tr><td>&nbsp;</td>
	<td colspan="12"><b>REKAPITULASI PEMERIKSAAN SARANA <?php echo $judul; ?></b></td></tr>
	<tr><td>&nbsp;</td><td colspan="5">Pemeriksaan Awal</td><td colspan="6" align="left"><?php echo $awal; ?></td></tr>
	<tr><td>&nbsp;</td><td colspan="5">Pemeriksaan Akhir</td><td colspan="6" align="left"><?php echo $akhir; ?></td></tr>
    <tr><td>&nbsp;</td><td colspan="5">Balai Besar / Balai Pemeriksa</td><td colspan="6" align="left"><?php echo $balai; ?></td></tr>      
    <tr><td colspan="21">&nbsp;</td></tr>
</table>
</div>
<table class="xcel">
  <tr>
    <th style="border:1px solid #000; border:thin; background:#CCC;" rowspan="2">No.</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;" rowspan="2">BALAI BESAR / BALAI POM</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;" rowspan="2">Jumlah <br>Diperiksa</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;" rowspan="2">MK</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;" rowspan="2">TMK</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;" colspan="6">Tindak Lanjut</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;" colspan="5">Temuan Produk</th>
  </tr>
  <tr>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Produk<br>Dikeluarkan<br>Dari Parcel</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Produk<br>Diamankan</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Produk<br>Dimusnahkan</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Produk<br>Dikembalikan<br>Ke Penyalur</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Teguran<br>Ke Pemilik<br>Sarana</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Projusticia</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">TIE</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Rusak</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Expire Date</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">TMK Label</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Bahan Berbahaya</th>
  </tr>
  <?php  
  $jml = count($kolom);
  if($jml > 0){
	  $no = 1;
	  for($i=0; $i<count($kolom); $i++){
	  ?>
	  <tr>
		<td style="border:1px solid #000; border:thin;"><?php echo $no; ?></td>
		<td style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['NAMA_BBPOM']; ?></td>
		<td style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['JMLPERIKSA']; ?></td>
		<td style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['MK']; ?></td>
		<td style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['TMK']; ?></td>
		<td style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['PRODUKPARCEL']; ?></td>
		<td style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['DIAMANKAN']; ?></td>
		<td style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['DIMUSNAHKAN']; ?></td>
		<td style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['PENYALUR']; ?></td>
		<td style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['TEGURAN']; ?></td>
		<td style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['PROJUSTICIA']; ?></td>
		<td style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['PRODUKTIE']; ?></td>
		<td style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['PRODUKRUSAK']; ?></td>
		<td style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['ED']; ?></td>
		<td style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['TMKLABEL']; ?></td>
		<td style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['BB']; ?></td>
	  </tr>
	  <?php
	  $no++;
	  }
  }else{
  ?>
  <tr>
    <td style="border:1px solid #000; border:thin;" colspan="17">Data Tidak Ditemukan</td>
  </tr>
  <?php
  }
  ?>
</table>

