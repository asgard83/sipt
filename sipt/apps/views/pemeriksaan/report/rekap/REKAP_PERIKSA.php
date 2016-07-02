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
	<tr><td>&nbsp;</td><td colspan="13"><b>REKAPITULASI PEMERIKSAAN SARANA</b></td></tr>
	<tr><td>&nbsp;</td><td>Jenis Sarana</td><td colspan="11" align="left"><b><?php echo $judul; ?></b></td></tr>
	<tr><td>&nbsp;</td><td>Pemeriksaan Awal</td><td colspan="11" align="left"><?php echo $awal; ?></td></tr>
	<tr><td>&nbsp;</td><td>Pemeriksaan Akhir</td><td colspan="11" align="left"><?php echo $akhir; ?></td></tr>
    <tr><td>&nbsp;</td><td>Balai Besar / Balai Pemeriksa</td><td colspan="10" align="left"><?php echo $balai; ?></td></tr>      
    <tr><td colspan="13">&nbsp;</td></tr>
</table>
</div>
<table class="xcel">
  <tr>
    <th rowspan="2" style="border:1px solid #000; border:thin; background:#CCC;" valign="top">No.</th>
    <th rowspan="2" style="border:1px solid #000; border:thin; background:#CCC;" valign="top">Balai Besar / Balai POM</th>
    <th colspan="11" style="border:1px solid #000; border:thin; background:#CCC;" align="center">HASIL</th>
    <th colspan="3" style="border:1px solid #000; border:thin; background:#CCC;" align="center">PROGRESS</th>
  </tr>
  <tr>
    <th style="border:1px solid #000; border:thin; background:#CCC;">TMK</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">MK</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">KRITIKAL</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">MAJOR</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">MINOR</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">BAIK SEKALI</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">BAIK</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">CUKUP</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">KURANG</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">JELEK</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">TUTUP</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">PROSES BALAI</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">PROSES PUSAT</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">SELESAI</th>
  </tr>
  <?php 
  if(count($kolom) > 0){ 
	$no = 1;
	$jml = 0;
	for($i=0; $i<count($kolom); $i++){
		$jml = $kolom[$i]['TMK'] + $kolom[$i]['MK'] + $kolom[$i]['KRITIKAL'] + $kolom[$i]['MAJOR'] + $kolom[$i]['MINOR'] + $kolom[$i]['BAIK SEKALI'] + $kolom[$i]['BAIK'] + $kolom[$i]['CUKUP'] + $kolom[$i]['KURANG'] + $kolom[$i]['JELEK'];
	?>
	<tr>
	  <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $no; ?></td>
	  <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['NAMA_BBPOM']; ?></td>
	  <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['TMK']; ?></td>
	  <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['MK']; ?></td>
	  <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['Kritikal']; ?></td>
	  <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['Major']; ?></td>
	  <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['Minor']; ?></td>
	  <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['BAIK SEKALI']; ?></td>
	  <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['BAIK']; ?></td>
	  <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['CUKUP']; ?></td>
	  <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['KURANG']; ?></td>
	  <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['JELEK']; ?></td>
	  <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['TUTUP']; ?></td>
	  <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['PROSES BALAI']; ?></td>
	  <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['PROSES PUSAT']; ?></td>
	  <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['SELESAI']; ?></td>
	<?php 
	$no++; 
	} 
  } else { ?>
  <tr>
    <td colspan="16" style="border:1px solid #000; border:thin;">Data Tidak Ditemukan</td>
  </tr>
  <?php } ?>
</table>
