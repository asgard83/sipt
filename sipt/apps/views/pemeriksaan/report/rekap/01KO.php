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
	<tr><td>&nbsp;</td><td colspan="12"><b>REKAPITULASI PEMERIKSAAN SARANA <?php echo $judul; ?></b></td></tr>
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
    <th style="border:1px solid #000; border:thin; background:#CCC;" rowspan="2">MK</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;" rowspan="2">TMK</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;" rowspan="2">Tutup</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;" colspan="5">Rincian TMK (Sarana)</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;" colspan="11">Tindak Lanjut (Sarana)</th>
  </tr>
  <tr>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Memproduksi <br />Produk TIE</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Memproduksi <br />BB</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Aspek <br />CPKB</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Memproduksi <br />TMK Penandaan</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Administrasi <br />Tidak Lengkap</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Pembinaan</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Perbaikan</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Peringatan</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Peringatan<br />Keras</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Pemberhentian<br />Sementara<br />Kegiatan</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Pembekuan</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Penutupan</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Penutupan<br />Sementara<br />Akses<br />Online<br />Kosmetik</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Projusticia</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Pencabutan<br />Sertifikat<br />CPKB</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Rekomendasi<br />Untuk<br />Pencabutan<br />Izin<br />Produksi</th>
  </tr>
  <?php  
  $jml = count($kolom);
  if($jml > 0){
	  $no = 1;
	  for($i=0; $i<$jml; $i++){
	  ?>
	  <tr>
		<td style="border:1px solid #000; border:thin;"><?php echo $no; ?></td>
		<td style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['NAMA_BBPOM']; ?></td>
		<td style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['JMLPERIKSA']; ?></td>
		<td style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['MK']; ?></td>
		<td style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['TMK']; ?></td>
		<td style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['TUTUP']; ?></td>
		<td style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['TMKTIE']; ?></td>
		<td style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['TMKBB']; ?></td>
		<td style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['ASPEK_CPKB']; ?></td>
		<td style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['TMKLABEL']; ?></td>
		<td style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['ADMINISTRASI']; ?></td>
		<td style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['PEMBINAAN']; ?></td>
		<td style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['PERBAIKAN']; ?></td>
		<td style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['PERINGATAN']; ?></td>
		<td style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['PK']; ?></td>
		<td style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['PSK']; ?></td>
		<td style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['PEMBEKUAN']; ?></td>
		<td style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['PENUTUPAN']; ?></td>
		<td style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['AKSES_ONLINE']; ?></td>
		<td style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['PROJUSTICIA']; ?></td>
		<td style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['SERT_CPKB']; ?></td>
		<td style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['PIP']; ?></td>
	  </tr>
	  <?php
	  $no++;
	  }
  }else{
  ?>
  <tr>
    <td style="border:1px solid #000; border:thin;" colspan="22">Data Tidak Ditemukan</td>
  </tr>
  <?php
  }
  ?>
</table>

