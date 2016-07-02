<?php 
if(!defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);
?>
<style type="text/css">
table.xcel{text-align: left;border:1px solid #000; border:thin; color:#000; font-family: "lucida grande", Tahoma, verdana, arial, sans-serif; font-size:10px; direction:ltr;}
table.xcelheader{text-align: left; border-collapse:collapse; color:#000; font-family: "lucida grande", Tahoma, verdana, arial, sans-serif; font-size:10px; direction:ltr;}
</style>
<div>
<table class="xcelheader">
	<tr><td>&nbsp;</td>
	<td colspan="15"><b>REKAP LAPORAN BB/B POM PEMERIKSAAN SARANA TERKAIT TEMUAN PRODUK</b></td></tr>
	<tr><td>&nbsp;</td><td>Jenis Sarana</td><td colspan="14"><b><?php echo $judul; ?></b></td></tr>
	<tr><td>&nbsp;</td><td>Pemeriksaan Awal</td><td colspan="14"><?php echo $awal; ?></td></tr>
	<tr><td>&nbsp;</td><td>Pemeriksaan Akhir</td><td colspan="14"><?php echo $akhir; ?></td></tr>
    <tr><td>&nbsp;</td><td>Balai Besar / Balai Pemeriksa</td><td colspan="14"><?php echo $balai; ?></td></tr>      
    <tr><td colspan="16">&nbsp;</td></tr>
</table>
</div>
<table class="xcel">
  <tr>
    <th style="border:1px solid #000; border:thin; background:#CCC;" rowspan="2">No</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;" rowspan="2">Klasifikasi Produk</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;" colspan="2">Identitas Perusahaan</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;" colspan="5">Produk</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;" colspan="7">Temuan</th>
    <?php if($balai == "Seluruh Balai"){?>
    <th style="border:1px solid #000; border:thin; background:#CCC;" rowspan="2">Balai Pemeriksa</th>
    <?php } ?>
  </tr>
  <tr>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Nama Perusahaan</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Alamat Perusahaan</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Nama Produk</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Nomor Pendaftaran</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">No Batch</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Netto</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Tanggal Exp</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Kategori</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Jumlah</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Harga Satuan</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Harga Total</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Jenis Pelanggaran</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Tindakan Produk</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Keterangan Sumber</th>
  </tr>
  <?php if(count($temuan) > 0){ 
  $n = 1;
  for($z=0; $z<count($temuan); $z++){
  ?>
  <tr>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $n; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $temuan[$z]['KLASIFIKASI_PRODUK']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $temuan[$z]['NAMA_PERUSAHAAN']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $temuan[$z]['ALAMAT_PERUSAHAAN']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $temuan[$z]['NAMA_PRODUK']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $temuan[$z]['NOMOR_REGISTRASI']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $temuan[$z]['NO_BATCH']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $temuan[$z]['NETTO']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $temuan[$z]['TANGGAL_EXPIRE']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $temuan[$z]['KATEGORI_TEMUAN']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $temuan[$z]['JUMLAH_TEMUAN']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $temuan[$z]['HARGA_SATUAN']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $temuan[$z]['HARGA_TOTAL']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $temuan[$z]['JENIS_PELANGGARAN']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $temuan[$z]['TINDAKAN_PRODUK']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $temuan[$z]['KETERANGAN_SUMBER']; ?></td>
    <?php if($balai == "Seluruh Balai"){?>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $temuan[$z]['NAMA_BBPOM']; ?></td>
    <?php } ?>
  </tr>
  <?php $n++; } } else{ ?>	
  <tr>
    <td valign="top" style="border:1px solid #000; border:thin;" colspan="16">Data Tidak Ditemukan</td>
  </tr>
  <?php } ?>
</table>

