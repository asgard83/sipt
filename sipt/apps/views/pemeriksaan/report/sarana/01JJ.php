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
	<tr><td>&nbsp;</td><td colspan="17"><b>HASIL PEMERIKSAAN SARANA PRODUKSI PANGAN (MD)</b></td></tr>
	<tr><td>&nbsp;</td><td>Jenis Sarana</td><td colspan="16"><b><?php echo $judul; ?></b></td></tr>
	<tr><td>&nbsp;</td><td>Pemeriksaan Awal</td><td colspan="16"><?php echo $awal; ?></td></tr>
	<tr><td>&nbsp;</td><td>Pemeriksaan Akhir</td><td colspan="16"><?php echo $akhir; ?></td></tr>
    <tr><td>&nbsp;</td><td>Balai Besar / Balai Pemeriksa</td><td colspan="16"><?php echo $balai; ?></td></tr>      
    <tr><td colspan="18">&nbsp;</td></tr>
</table>
</div>
<table class="xcel">
  <tr>
    <th rowspan="2" style="border:1px solid #000; border:thin; background:#CCC;">No.</th>
    <th rowspan="2" style="border:1px solid #000; border:thin; background:#CCC;">Nama Sarana</th>
    <th rowspan="2" style="border:1px solid #000; border:thin; background:#CCC;">Alamat</th>
    <th rowspan="2" style="border:1px solid #000; border:thin; background:#CCC;">Nama Produk Pangan</th>
    <th rowspan="2" style="border:1px solid #000; border:thin; background:#CCC;">Jenis Produk Pangan</th>
    <th rowspan="2" style="border:1px solid #000; border:thin; background:#CCC;">Tanggal Pemeriksaan</th>
    <th colspan="6" style="border:1px solid #000; border:thin; background:#CCC;">Temuan</th>
    <th rowspan="2" style="border:1px solid #000; border:thin; background:#CCC;">Rating</th>
    <th colspan="4" style="border:1px solid #000; border:thin; background:#CCC;">CAPA</th>
    <th rowspan="2" style="border:1px solid #000; border:thin; background:#CCC;">Petugas Pemeriksa</th>
  </tr>
  <tr>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Penyimpangan Fisik</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Penyimpangan Operasional</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">MN</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">MJ</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">SR</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">KR</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Tindak Lanjut Fisik</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Timeline Fisik</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Tindak Lanjut Operasional</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Timeline Operasional</th>
  </tr>
  <?php if(count($kolom) > 0){ 
  $no = 1;
  for($i=0; $i<count($kolom); $i++){
  ?>
  <tr>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $no; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['NAMA_SARANA']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['ALAMAT']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;">
    <ul style="list-style-type:decimal; padding-left:15px; margin:0;"><?php $nama_produk = explode(";",$kolom[$i]['NAMA PRODUK PANGAN']); echo "<li>".join("</li><li>", $nama_produk)."</li>"; ?></ul>
    </td>
    <td valign="top" style="border:1px solid #000; border:thin;"><ul style="list-style-type:decimal; padding-left:15px; margin:0;"><?php $jenis_pangan = explode(";",$kolom[$i]['JENIS PRODUK PANGAN']); echo "<li>".join("</li><li>", $jenis_pangan)."</li>"; ?></ul></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['TANGGAL']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;">
	<?php $fisik = explode("#",$kolom[$i]['FISIK']); ?>
    <ul style="margin-top:0px; padding-left:15px; list-style:decimal;"><li>
	<?php $as_fisik = explode(";", str_replace('0|','',$fisik[0])); echo "<li>".join("</li><li>", $as_fisik)."</li>"; ?>
	<?php
		if(count($fisik) > 1){
			for($b=1;$b<count($fisik); $b++){
			?>
		   <li><?php echo str_replace($b.'|','',$fisik[$b]); ?></li>                                
		   <?php
			}
		}
    ?>
    </ul>
    </td>
    <td valign="top" style="border:1px solid #000; border:thin;">
	<?php $operasional = explode("#",$kolom[$i]['OPERASIONAL']); ?>
    <ul style="margin-top:0px; padding-left:15px; list-style:decimal;">
	<?php $as_operasional = explode(";", str_replace('0|','',$operasional[0])); echo "<li>".join("</li><li>", $as_operasional)."</li>"; ?>
	<?php
		if(count($operasional) > 1){
			for($b=1;$b<count($operasional); $b++){
			?>
		   <li><?php echo str_replace($b.'|','',$operasional[$b]); ?></li>                                
		   <?php
			}
		}
    ?>
    </ul></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['JUMLAH_MINOR']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['JUMLAH_MAJOR']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['JUMLAH_SERIUS']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['JUMLAH_KRITIS']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><b><?php echo $kolom[$i]['RATING']; ?></b></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['FISIK_PERBAIKAN']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['FISIK_TIMELINE']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['OPERASIONAL_PERBAIKAN']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['OPERASIONAL_TIMELINE']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;">
    <ul style="margin-top:0px; padding-left:15px; list-style:decimal;"><li>
	<?php $petugas = explode("-",$kolom[$i]['PETUGAS']); ?>
	<?php
		if(count($petugas) > 1){
			for($b=1;$b<count($petugas); $b++){
			?>
		   <li><?php echo $petugas[$b]; ?></li>                                
		   <?php
			}
		}
    ?>
    </ul>
    </td>
  </tr>
  <?php $no++; } } else { ?>
  <tr>
    <td colspan="18" style="border:1px solid #000; border:thin;">Data Tidak Ditemukan</td>
  </tr>
  <?php } ?>
</table>
