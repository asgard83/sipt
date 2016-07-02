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
	<tr><td>&nbsp;</td><td colspan="12"><b>REKAPITULASI PEMERIKSAAN SARANA DISTRIBUSI KOSMETIK</b></td></tr>
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
    <th style="border:1px solid #000; border:thin; background:#CCC;" colspan="4">Rincian TMK (Sarana)</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;" colspan="3">Rincian Temuan Produk</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;" colspan="5">Tindak Lanjut Terhadap Sarana</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;" colspan="4">Tindak Lanjut Terhadap Produk</th>
  </tr>
  <tr>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Mengedarkan<br>Produk TIE</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Mengedarkan<br>Produk BB</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Administrasi </th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Kadaluarsa</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Produk<br>TIE</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Produk<br>BB</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Produk<br>TMK Penandaan</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Pembinaan</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Pengamanan</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Projusticia</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Rekomendasi<br>PSK</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Lain-Lain</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Pengamanan</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Pemusnahan</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Penarikan</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Pendataan</th>
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
		<td style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['TMKTIE']; ?></td>
		<td style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['TMKBB']; ?></td>
		<td style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['TMKADMINISTRASI']; ?></td>
		<td style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['TMKED']; ?></td>
		<td style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['PRODUKTIE']; ?></td>
		<td style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['PRODUKBB']; ?></td>
		<td style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['PRODUKPENANDAAN']; ?></td>
		<td style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['PEMBINAAN']; ?></td>
		<td style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['PENGAMANAN']; ?></td>
		<td style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['PROJUSTICIA']; ?></td>
		<td style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['REKOMENDASIPSK']; ?></td>
		<td style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['LAINLAIN']; ?></td>
		<td style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['PENGAMANANPRODUK']; ?></td>
		<td style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['PEMUSNAHANPRODUK']; ?></td>
		<td style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['PENARIKANPRODUK']; ?></td>
		<td style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['PENDATAANPRODUK']; ?></td>
	  </tr>
	  <?php
	  $no++;
	  }
  }else{
  ?>
  <tr>
    <td style="border:1px solid #000; border:thin;" colspan="21">Data Tidak Ditemukan</td>
  </tr>
  <?php
  }
  ?>
</table>

