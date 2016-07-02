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
	<tr><td colspan="25" align="center"><b><?php echo $judul; ?></b></td></tr>
	<tr><td colspan="25" align="center"><b><?php echo $sub_judul; ?></b></td></tr>
	<tr><td colspan="25" align="center"><b><?php echo $balai; ?></b></td></tr>
	<tr><td colspan="25" align="center"><b>PERIODE <?php echo $periode; ?></b></td></tr>
    <tr><td colspan="25">&nbsp;</td></tr>
</table>

</div>
<table class="xcel">
  <tr>
    <th style="border:1px solid #000; border:thin; background:#CCC;">No.</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">BALAI BESAR / BALAI POM</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Januari</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Februari</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Maret</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">April</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Mei</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Juni</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Juli</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Agustus</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">September</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Oktober</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">November</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Desember</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Jumlah <br>Diperiksa</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">MK</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">TMK</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Tutup</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Tidak<br>Dapat<br>Diperiksa</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Pb</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">P</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">PK</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">PSK</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">PKe</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Pi</th>
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
		<td style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['TUTUP']; ?></td>
		<td style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['TDP']; ?></td>
		<td style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['PEMBINAAN']; ?></td>
		<td style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['PERINGATAN']; ?></td>
		<td style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['PK']; ?></td>
		<td style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['PSK']; ?></td>
		<td style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['PKe']; ?></td>
		<td style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['PIz']; ?></td>
	  </tr>
	  <?php
	  $no++;
	  }
  }else{
  ?>
  <tr>
    <td style="border:1px solid #000; border:thin;" colspan="25">Data Tidak Ditemukan</td>
  </tr>
  <?php
  }
  ?>
</table>
<div>
<table class="xcelheader">
    <tr><td colspan="25">&nbsp;</td></tr>
	<tr><td>&nbsp;</td><td>Keterangan</td><td>&nbsp;</td><td colspan="22">&nbsp;</td></tr>
	<tr><td>&nbsp;</td><td>Pb</td><td>:</td><td colspan="22">Pembinaan</td></tr>
	<tr><td>&nbsp;</td><td>P</td><td>:</td><td colspan="22">Peringatan</td></tr>
	<tr><td>&nbsp;</td><td>PSK</td><td>:</td><td colspan="22">Peringatan Keras</td></tr>
	<tr><td>&nbsp;</td><td>PKe</td><td>:</td><td colspan="22">Penghentian Sementara Kegiatan</td></tr>
	<tr><td>&nbsp;</td><td>Pi</td><td>:</td><td colspan="22">Pencabutan Izin</td></tr>
</table>
</div>

