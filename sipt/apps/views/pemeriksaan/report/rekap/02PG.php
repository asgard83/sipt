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
    <th style="border:1px solid #000; border:thin; background:#CCC;" rowspan="2">BAIK</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;" rowspan="2">CUKUP</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;" rowspan="2">KURANG</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;" colspan="8">Tindak Lanjut</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;" colspan="5">Temuan Produk</th>
  </tr>
  <tr>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Pembinaan</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Surat<br>Peringatan</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Pengamanan</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Pemusnahan<br>Produk</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Pengambilan<br>Sampel</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Pemanggilan<br>Resmi</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Pengambilan<br>Retur</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Projusticia</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">TIE</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Rusak</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Expire<br>Date</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">TMK Label</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Bahan<br>Berbahaya</th>
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
		<td style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['BAIK']; ?></td>
		<td style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['CUKUP']; ?></td>
		<td style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['KURANG']; ?></td>
		<td style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['PEMBINAAN']; ?></td>
		<td style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['SP']; ?></td>
		<td style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['PENGAMANAN']; ?></td>
		<td style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['PEMUSNAHAN']; ?></td>
		<td style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['SAMPEL']; ?></td>
		<td style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['PEMANGGILAN']; ?></td>
		<td style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['RETUR']; ?></td>
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
    <td style="border:1px solid #000; border:thin;" colspan="19">Data Tidak Ditemukan</td>
  </tr>
  <?php
  }
  ?>
</table>

