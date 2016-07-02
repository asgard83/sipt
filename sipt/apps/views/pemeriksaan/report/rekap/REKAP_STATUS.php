<?php 
if(!defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);
?>
<style>
table.xcel{text-align: left;border:1px solid #000; border:thin; color:#000; font-family: "lucida grande", Tahoma, verdana, arial, sans-serif; font-size:10px; direction:ltr;}
table.xcelheader{text-align: left; border:thin; color:#000; font-family: "lucida grande", Tahoma, verdana, arial, sans-serif; font-size:10px; direction:ltr;}
</style>
<div>
<table class="xcelheader">
	<tr><td>&nbsp;</td>
	<td colspan="21"><b>REKAPITULASI JUMLAH STATUS DOKUMEN</b></td></tr>
	<tr><td>&nbsp;</td><td colspan="5">Pemeriksaan Awal</td><td colspan="6" align="left"><?php echo $awal; ?></td></tr>
	<tr><td>&nbsp;</td><td colspan="5">Pemeriksaan Akhir</td><td colspan="6" align="left"><?php echo $akhir; ?></td></tr>
    <tr><td>&nbsp;</td><td colspan="5">Balai Besar / Balai Pemeriksa</td><td colspan="6" align="left"><?php echo $balai; ?></td></tr>      
    <tr><td colspan="21">&nbsp;</td></tr>
</table>
</div>
<table class="xcel">
  <tr>
    <th rowspan="2" style="border:1px solid #000; border:thin; background:#CCC;" valign="top">No.</th>
    <th rowspan="2" style="border:1px solid #000; border:thin; background:#CCC;" valign="top">Unit / Balai Besar / Balai POM</th>
    <th colspan="3" style="border:1px solid #000; border:thin; background:#CCC;" valign="top">Operator Balai</th>
    <th colspan="3" style="border:1px solid #000; border:thin; background:#CCC;" valign="top">SPV Satu Balai</th>
    <th colspan="2" style="border:1px solid #000; border:thin; background:#CCC;" valign="top">SPV Dua Balai</th>
    <th rowspan="2" style="border:1px solid #000; border:thin; background:#CCC;" valign="top">Ka. Balai</th>
    <th colspan="3" style="border:1px solid #000; border:thin; background:#CCC;" valign="top">Operator Pusat</th>
    <th colspan="3" style="border:1px solid #000; border:thin; background:#CCC;" valign="top">SPV Satu Pusat</th>
    <th colspan="2" style="border:1px solid #000; border:thin; background:#CCC;" valign="top">SPV Dua Pusat</th>
    <th rowspan="2" style="border:1px solid #000; border:thin; background:#CCC;" valign="top">Direktur</th>
    <th rowspan="2" style="border:1px solid #000; border:thin; background:#CCC;" valign="top">Selesai</th>
	<th rowspan="2" style="border:1px solid #000; border:thin; background:#CCC;" valign="top">Total</th>
  </tr>
  <tr>
    <th style="border:1px solid #000; border:thin; background:#CCC;" valign="top">Draft</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;" valign="top">Ditolak </th>
    <th style="border:1px solid #000; border:thin; background:#CCC;" valign="top">Perbaikan</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;" valign="top">Tindak Lanjut</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;" valign="top">Ditolak</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;" valign="top">Perbaikan</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;" valign="top">Tindak Lanjut</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;" valign="top">Perbaikan</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;" valign="top">Draft Pusat</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;" valign="top">Ditolak</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;" valign="top">Perbaikan</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;" valign="top">Tindak Lanjut</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;" valign="top">Ditolak</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;" valign="top">Perbaikan</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;" valign="top">Tindak Lanjut</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;" valign="top">Perbaikan</th>
  </tr>
  <?php 
  if(count($kolom) > 0){ 
	$no = 1;
	$jml = 0;
	$baris = count($kolom);
	for($i=0; $i<$baris; $i++){
	?>
  <tr>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $no; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['NAMA_BBPOM']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['OPBALAIDRAFT']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['OPBALAIREJECT']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['OPBALAIREV']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['SPV1BALAITL']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['SPV1BALAIREJECT']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['SPV1BALAIREV']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['SPV2BALAITL']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['SPV2BALAIREV']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['KABALAI']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['OPPUSATDRAFT']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['OPPUSATREJECT']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['OPPUSATREV']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['SPV1PUSATTL']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['SPV1PUSATREJECT']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['SPV1PUSATREV']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['SPV2PUSATTL']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['SPV2PUSATREV']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['DIREKTUR']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['SELESAI']; ?></td>
	<td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['TOTAL']; ?></td>
  </tr>
	<?php 
	$no++; 
	} 
  } else { ?>
  <tr>
    <td colspan="21">Data Tidak ditemukan</td>
  </tr>
    <?php } ?>
</table>
