<?php 
if(!defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);
?>
<style type="text/css">
table.xcel{text-align: left; border:1px solid #000; border:thin; color:#000; font-family: "lucida grande", Tahoma, verdana, arial, sans-serif; font-size:10px; direction:ltr;}
table.xcelheader{text-align: left; border-collapse:collapse; color:#000; font-family: "lucida grande", Tahoma, verdana, arial, sans-serif; font-size:10px; direction:ltr;}
</style>
<div>
<table class="xcelheader">
	<tr><td colspan="20">&nbsp;</td></tr>
	<td colspan="20"><b>LAPORAN HASIL PEMERIKSAAN SARANA PRODUKSI OBAT</b></td></tr>
	<tr><td>&nbsp;</td><td>Jenis Sarana</td><td colspan="18"><b><?php echo $judul; ?></b></td></tr>
	<tr><td>&nbsp;</td><td>Pemeriksaan Awal</td><td colspan="18"><?php echo $awal; ?></td></tr>
	<tr><td>&nbsp;</td><td>Pemeriksaan Akhir</td><td colspan="18"><?php echo $akhir; ?></td></tr>
    <tr><td>&nbsp;</td><td>Balai Besar / Balai Pemeriksa</td><td colspan="18"><?php echo $balai; ?></td></tr>      
    <tr><td colspan="20">&nbsp;</td></tr>
</table>
</div>

<table class="xcel">
  <tr>
    <th rowspan="2" style="border:1px solid #000; border:thin; background:#CCC;">No</th>
    <th colspan="2" style="border:1px solid #000; border:thin; background:#CCC;">Data Sarana</th>
    <th colspan="9" style="border:1px solid #000; border:thin; background:#CCC;">Pemeriksaan</th>
    <th colspan="3" style="border:1px solid #000; border:thin; background:#CCC;">Temuan</th>
    <th colspan="2" style="border:1px solid #000; border:thin; background:#CCC;">Rekomendasi</th>
    <th colspan="2" style="border:1px solid #000; border:thin; background:#CCC;">Kesimpulan</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">CAPA</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">&nbsp;</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Petugas</th>
  </tr>
  <tr>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Nama</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Alamat</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Tanggal</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Nomor Inspeksi</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Standar </th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Kepatuhan CPOB</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Latar Belakang</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Perubahan Bermakna</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Ruang Lingkup</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Area Inspeksi</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Distribusi Laporan</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Kritikal</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Major</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Minor</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Rekomendasi</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Kesimpulan</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Tindak Lanjut</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Timeline</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Status CAPA</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">CAPA Closed</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Petugas</th>
  </tr>
  <?php if(count($kolom) > 0){ 
  $no = 1;
  for($i=0; $i<count($kolom); $i++){
  ?>
  <tr>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $no; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['NAMA_SARANA']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['ALAMAT']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['TANGGAL']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['NOMOR_INSPEKSI']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['STANDARD']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['KEPATUHAN_CPOB']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['LATAR_BELAKANG']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['PERUBAHAN_BERMAKNA']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['RUANG_LINGKUP']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['AREA_INSPEKSI']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['DISTRIBUSI_LAPORAN']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['TEMUAN_KRITIKAL']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['TEMUAN_MAJOR']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['TEMUAN_MINOR']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['REKOMENDASI']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['KESIMPULAN']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['TINDAK_LANJUT']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['TIMELINE']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['STATUS_CAPA']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['CAPA_CLOSED']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;">
	<?php $petugas = explode("-",$kolom[$i]['PETUGAS']); ?>
    <ul style="margin-top:0px; padding-left:15px; list-style:decimal;"><li>
	<?php
		if(count($petugas) > 1){
			for($b=1;$b<count($petugas); $b++){
			?>
		   <li><?php echo $petugas[$b]; ?></li>                                
		   <?php
			}
		}
    ?>
    </ul></td>
  </tr>
 <?php $no++; } } else { ?>  
 <tr>
    <td valign="top" style="border:1px solid #000; border:thin;" colspan="23">Data tidak ditemukan</td>
  </tr>
  <?php } ?>
</table>
