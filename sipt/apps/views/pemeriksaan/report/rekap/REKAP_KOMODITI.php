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
	<tr><td>&nbsp;</td><td colspan="12"><b>REKAPITULASI JUMLAH PEMERIKSAAN KOMODITI</b></td></tr>
	<tr><td>&nbsp;</td><td colspan="5">Pemeriksaan Awal</td><td colspan="6" align="left"><?php echo $awal; ?></td></tr>
	<tr><td>&nbsp;</td><td colspan="5">Pemeriksaan Akhir</td><td colspan="6" align="left"><?php echo $akhir; ?></td></tr>
    <tr><td>&nbsp;</td><td colspan="5">Balai Besar / Balai Pemeriksa</td><td colspan="6" align="left"><?php echo $balai; ?></td></tr>      
    <tr><td colspan="12">&nbsp;</td></tr>
</table>
</div>
<table class="xcel">
  <tr>
    <th rowspan="2" style="border:1px solid #000; border:thin; background:#CCC;" valign="top">No.</th>
    <th rowspan="2" style="border:1px solid #000; border:thin; background:#CCC;" valign="top">Unit / Balai Besar / Balai POM</th>
    <th colspan="10" style="border:1px solid #000; border:thin; background:#CCC;" align="center">KOMODITI</th>
  </tr>
  <tr>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Obat</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Narkotika</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Psikotropika</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Prekursor</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Obat Tradisional</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Produk Komplemen</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Kosmetika</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Produk Pangan</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Obat dan Produk Biologi</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Bahan Obat</th>
  </tr>
  <?php 
  if(count($kolom) > 0){ 
	$no = 1;
	$jml = 0;
	$JMLOBAT = 0;
	$JMLNARKOTIK = 0;
	$JMLPSIKOTROPIKA = 0;
	$JMLPREKURSOR = 0;
	$JMLOT = 0;
	$JMLPK = 0;
	$JMLKOS = 0;
	$JMLPANGAN = 0;
	$JMLBIOLOGI = 0;
	$JMLBAHAN = 0;
	for($i=0; $i<count($kolom); $i++){
	?>
	<tr>
	  <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $no; ?></td>
	  <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['NAMA_BBPOM']; ?></td>
	  <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['Obat']; ?></td>
	  <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['Narkotika']; ?></td>
	  <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['Psikotropika']; ?></td>
	  <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['Prekursor']; ?></td>
	  <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['Obat Tradisional']; ?></td>
	  <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['Produk Komplemen']; ?></td>
	  <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['Kosmetika']; ?></td>
	  <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['Produk Pangan']; ?></td>
	  <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['Obat dan Produk Biologi']; ?></td>
	  <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['Bahan Obat']; ?></td>
	<?php 
	  $no++;
	  $JMLOBAT = $JMLOBAT + $kolom[$i]['Obat'];
	  $JMLNARKOTIK = $JMLNARKOTIK + $kolom[$i]['Narkotika'];
	  $JMLPSIKOTROPIKA = $JMLPSIKOTROPIKA + $kolom[$i]['Psikotropika'];
	  $JMLPREKURSOR = $JMLPREKURSOR + $kolom[$i]['Prekursor'];
	  $JMLOT = $JMLOT + $kolom[$i]['Obat Tradisional'];
	  $JMLPK = $JMLPK + $kolom[$i]['Produk Komplemen'];
	  $JMLKOS = $JMLKOS + $kolom[$i]['Kosmetika'];
	  $JMLPANGAN = $JMLPANGAN + $kolom[$i]['Produk Pangan'];
	  $JMLBIOLOGI = $JMLBIOLOGI + $kolom[$i]['Obat dan Produk Biologi'];
	  $JMLBAHAN = $JMLBAHAN + $kolom[$i]['Bahan Obat']; 
	?>
    </tr>
    <?php
	}
	?>
	<tr>
	  <td valign="top" style="border:1px solid #000; border:thin;">&nbsp;</td>
	  <td valign="top" style="border:1px solid #000; border:thin;">Jumlah</td>
	  <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $JMLOBAT; ?></td>
	  <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $JMLNARKOTIK; ?></td>
	  <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $JMLPSIKOTROPIKA; ?></td>
	  <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $JMLPREKURSOR; ?></td>
	  <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $JMLOT; ?></td>
	  <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $JMLPK; ?></td>
	  <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $JMLKOS; ?></td>
	  <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $JMLPANGAN; ?></td>
	  <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $JMLBIOLOGI; ?></td>
	  <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $JMLBAHAN; ?></td>
	<?php 
  } else { ?>
  <tr>
    <td colspan="13" style="border:1px solid #000; border:thin;">Data Tidak Ditemukan</td>
  </tr>
  <?php } ?>
</table>
