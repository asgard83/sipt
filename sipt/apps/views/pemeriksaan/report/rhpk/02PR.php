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
	<tr><td colspan="23" align="center"><b><?php echo $judul; ?></b></td></tr>
	<tr><td colspan="23" align="center"><b><?php echo $sub_judul; ?></b></td></tr>
	<tr><td colspan="23" align="center"><b><?php echo $balai; ?></b></td></tr>
	<tr><td colspan="23" align="center"><b>PERIODE <?php echo $periode; ?></b></td></tr>
    <tr><td colspan="23">&nbsp;</td></tr>
</table>

</div>
<table class="xcel">
  <tr>
    <th rowspan="2" style="border:1px solid #000; border:thin; background:#CCC;">No.</th>
    <th rowspan="2" style="border:1px solid #000; border:thin; background:#CCC;">BALAI BESAR / BALAI POM</th>
    <th rowspan="2" style="border:1px solid #000; border:thin; background:#CCC;">Januari</th>
    <th rowspan="2" style="border:1px solid #000; border:thin; background:#CCC;">Februari</th>
    <th rowspan="2" style="border:1px solid #000; border:thin; background:#CCC;">Maret</th>
    <th rowspan="2" style="border:1px solid #000; border:thin; background:#CCC;">April</th>
    <th rowspan="2" style="border:1px solid #000; border:thin; background:#CCC;">Mei</th>
    <th rowspan="2" style="border:1px solid #000; border:thin; background:#CCC;">Juni</th>
    <th rowspan="2" style="border:1px solid #000; border:thin; background:#CCC;">Juli</th>
    <th rowspan="2" style="border:1px solid #000; border:thin; background:#CCC;">Agustus</th>
    <th rowspan="2" style="border:1px solid #000; border:thin; background:#CCC;">September</th>
    <th rowspan="2" style="border:1px solid #000; border:thin; background:#CCC;">Oktober</th>
    <th rowspan="2" style="border:1px solid #000; border:thin; background:#CCC;">November</th>
    <th rowspan="2" style="border:1px solid #000; border:thin; background:#CCC;">Desember</th>
    <th rowspan="2" style="border:1px solid #000; border:thin; background:#CCC;">Jumlah <br>Diperiksa</th>
    <th rowspan="2" style="border:1px solid #000; border:thin; background:#CCC;">MK</th>
    <th rowspan="2" style="border:1px solid #000; border:thin; background:#CCC;">TMK</th>
    <th colspan="6" style="border:1px solid #000; border:thin; background:#CCC;" align="center">Tindakan</th>
  </tr>
  <tr>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Dikeluarkan dari Parcel</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Produk Diamankan</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Produk Dimusnahkan</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Dikembalikan Ke Penyalur</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Teguran Ke Pemilik</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Projusticia</th>
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
		<td style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['Jan']; ?></td>
		<td style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['Feb']; ?></td>
		<td style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['Mar']; ?></td>
		<td style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['Apr']; ?></td>
		<td style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['Mei']; ?></td>
		<td style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['Jun']; ?></td>
		<td style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['Jul']; ?></td>
		<td style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['Agst']; ?></td>
		<td style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['Sept']; ?></td>
		<td style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['Okt']; ?></td>
		<td style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['Nov']; ?></td>
		<td style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['Des']; ?></td>
		<td style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['DIPERIKSA']; ?></td>
		<td style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['MK']; ?></td>
		<td style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['TMK']; ?></td>
		<td style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['PARCEL']; ?></td>
		<td style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['DIAMANKAN']; ?></td>
		<td style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['DIMUSNAHKAN']; ?></td>
		<td style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['DIKEMBALIKAN']; ?></td>
		<td style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['TEGURAN']; ?></td>
		<td style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['PROJUSTICIA']; ?></td>
	  </tr>
	  <?php
	  $no++;
	  }
  }else{
  ?>
  <tr>
    <td style="border:1px solid #000; border:thin;" colspan="23">Data Tidak Ditemukan</td>
  </tr>
  <?php
  }
  ?>
</table>

