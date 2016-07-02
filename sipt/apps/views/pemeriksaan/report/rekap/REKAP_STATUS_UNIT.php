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
	<td colspan="21"><b>REKAPITULASI STATUS DOKUMEN</b></td></tr>
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
    <th colspan="4" style="border:1px solid #000; border:thin; background:#CCC;" valign="top">Operator Pusat</th>
    <th colspan="3" style="border:1px solid #000; border:thin; background:#CCC;" valign="top">SPV Satu Pusat</th>
    <th colspan="3" style="border:1px solid #000; border:thin; background:#CCC;" valign="top">SPV Dua Pusat</th>
    <th rowspan="2" style="border:1px solid #000; border:thin; background:#CCC;" valign="top">Direktur</th>
    <th rowspan="2" style="border:1px solid #000; border:thin; background:#CCC;" valign="top">Selesai</th>
	<th rowspan="2" style="border:1px solid #000; border:thin; background:#CCC;" valign="top">Proses<br /> di Pusat</th>
	<th rowspan="2" style="border:1px solid #000; border:thin; background:#CCC;" valign="top">Proses<br /> di Balai</th>
  </tr>
  <tr>
    <th style="border:1px solid #000; border:thin; background:#CCC;" valign="top">TL Balai</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;" valign="top">Draft Pusat</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;" valign="top">Ditolak</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;" valign="top">Perbaikan</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;" valign="top">Tindak Lanjut</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;" valign="top">Ditolak</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;" valign="top">Perbaikan</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;" valign="top">Tindak Lanjut</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;" valign="top">Ditolak Direktur</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;" valign="top">Perbaikan</th>
  </tr>
  <?php 
  if(count($kolom) > 0){ 
	$no = 1;
	$jml = 0;
	$TOTOPPUSATDRAFT = 0;
	$TOTOPPUSATREJECT = 0;
	$TOTOPPUSATREV = 0;
	$TOTSPV1PUSATTL = 0;
	$TOTSPV1PUSATREJECT = 0;
	$TOTSPV1PUSATREV = 0;
	$TOTSPV2PUSATTL = 0;
	$TOTSPV2PUSATREJECT = 0;
	$TOTSPV2PUSATREV = 0;
	$TOTDIREKTUR= 0;
	$TOTSELESAI = 0;
	$TOTTOTAL = 0;
	$TOTTOTALBALAI = 0;
	$baris = count($kolom);
	for($i=0; $i<$baris; $i++){
	?>
  <tr>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $no; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['NAMA_BBPOM']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['TLBALAI']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['OPPUSATDRAFT']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['OPPUSATREJECT']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['OPPUSATREV']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['SPV1PUSATTL']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['SPV1PUSATREJECT']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['SPV1PUSATREV']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['SPV2PUSATTL']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['SPV2PUSATREJECT']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['SPV2PUSATREV']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['DIREKTUR']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['SELESAI']; ?></td>
	<td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['TOTAL']; ?></td>
	<td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['TOTBALAI']; ?></td>
  </tr>
	<?php 
	$no++;
	$TOTTLBALAI = $TOTTLBALAI + $kolom[$i]['TLBALAI'];
	$TOTOPPUSATDRAFT = $TOTOPPUSATDRAFT + $kolom[$i]['OPPUSATDRAFT'];
	$TOTOPPUSATREJECT = $TOTOPPUSATREJECT + $kolom[$i]['OPPUSATREJECT'];
	$TOTOPPUSATREV = $TOTOPPUSATREV + $kolom[$i]['OPPUSATREV'];
	$TOTSPV1PUSATTL = $TOTSPV1PUSATTL + $kolom[$i]['SPV1PUSATTL'];
	$TOTSPV1PUSATREJECT = $TOTSPV1PUSATREJECT + $kolom[$i]['SPV1PUSATREJECT'];
	$TOTSPV1PUSATREV = $TOTSPV1PUSATREV + $kolom[$i]['SPV1PUSATREV'];
	$TOTSPV2PUSATTL = $TOTSPV2PUSATTL + $kolom[$i]['SPV2PUSATTL'];
	$TOTSPV2PUSATREJECT = $TOTSPV2PUSATREJECT + $kolom[$i]['SPV2PUSATREJECT'];
	$TOTSPV2PUSATREV = $TOTSPV2PUSATREV + $kolom[$i]['SPV2PUSATREV'];
	$TOTDIREKTUR= $TOTDIREKTUR + $kolom[$i]['DIREKTUR'];
	$TOTSELESAI = $TOTSELESAI + $kolom[$i]['SELESAI'];
	$TOTTOTAL = $TOTTOTAL + $kolom[$i]['TOTAL'];
	$TOTTOTALBALAI = $TOTTOTALBALAI + $kolom[$i]['TOTBALAI'];
	} 
	?>
    <tr>
    <td valign="top" style="border:1px solid #000; border:thin;">&nbsp;</td>
    <td valign="top" style="border:1px solid #000; border:thin;">Jumlah</td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $TOTTLBALAI; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $TOTOPPUSATDRAFT; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $TOTOPPUSATREJECT; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $TOTOPPUSATREV; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $TOTSPV1PUSATTL; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $TOTSPV1PUSATREJECT; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $TOTSPV1PUSATREV; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $TOTSPV2PUSATTL; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $TOTSPV2PUSATREJECT; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $TOTSPV2PUSATREV; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $TOTDIREKTUR; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $TOTSELESAI; ?></td>
	<td valign="top" style="border:1px solid #000; border:thin;"><?php echo $TOTTOTAL; ?></td>
	<td valign="top" style="border:1px solid #000; border:thin;"><?php echo $TOTTOTALBALAI; ?></td>
    </tr>
    <?php
  } else { ?>
  <tr>
    <td colspan="16">Data Tidak ditemukan</td>
  </tr>
    <?php } ?>
</table>
