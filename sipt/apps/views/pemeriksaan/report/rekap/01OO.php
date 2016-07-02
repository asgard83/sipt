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
    <th rowspan="2" style="border:1px solid #000; border:thin; background:#CCC;">No.</th>
    <th rowspan="2" style="border:1px solid #000; border:thin; background:#CCC;">BALAI BESAR / BALAI POM</th>
    <th rowspan="2" style="border:1px solid #000; border:thin; background:#CCC;">Jumlah <br>Diperiksa</th>
    <th rowspan="2" style="border:1px solid #000; border:thin; background:#CCC;">MK</th>
    <th rowspan="2" style="border:1px solid #000; border:thin; background:#CCC;">Minor</th>
    <th rowspan="2" style="border:1px solid #000; border:thin; background:#CCC;">Major</th>
    <th rowspan="2" style="border:1px solid #000; border:thin; background:#CCC;">Kritikal</th>
    <th colspan="7" style="border:1px solid #000; border:thin; background:#CCC;">Tindak Lanjut Terhadap Sarana</th>
  </tr>
  <tr>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Perbaikan</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Peringatan</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Peringatan<br />Keras</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Penghentian<br />Sementara<br />Kegiatan</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Pembekuan<br />Sertifikat<br />CPOB</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Pencabutan<br />Sertifikat</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Penarikan<br />Produk Jadi<br />(Recall)</th>
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
		<td style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['JMLMK']; ?></td>
		<td style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['JMLMINOR']; ?></td>
		<td style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['JMLMAJOR']; ?></td>
		<td style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['JMLKRITIKAL']; ?></td>
		<td style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['PERBAIKAN']; ?></td>
		<td style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['PERINGATAN']; ?></td>
		<td style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['PK']; ?></td>
		<td style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['PSK']; ?></td>
		<td style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['PEMBEKUAN ']; ?></td>
		<td style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['PENCABUTAN']; ?></td>
		<td style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['PENARIKAN']; ?></td>
	  </tr>
	  <?php
	  $no++;
	  }
  }else{
  ?>
  <tr>
    <td style="border:1px solid #000; border:thin;" colspan="14">Data Tidak Ditemukan</td>
  </tr>
  <?php
  }
  ?>
</table>

