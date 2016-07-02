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
	<tr><td>&nbsp;</td><td colspan="14"><b>LAPORAN BB/B POM TERKAIT OBAT PALSU DAN TIE SERTA OBAT KERAS</b></td></tr>
	<tr><td>&nbsp;</td><td>Komoditi</td><td colspan="13"><b><?php echo $judul; ?></b></td></tr>
	<tr><td>&nbsp;</td><td>Pemeriksaan Awal</td><td colspan="13"><?php echo $awal; ?></td></tr>
	<tr><td>&nbsp;</td><td>Pemeriksaan Akhir</td><td colspan="13"><?php echo $akhir; ?></td></tr>
    <tr><td>&nbsp;</td><td>Balai Besar / Balai Pemeriksa</td><td colspan="13"><?php echo $balai; ?></td></tr>      
    <tr><td colspan="15">&nbsp;</td></tr>
</table>
</div>
<table class="xcel">
  <tr>
    <th rowspan="2" style="border:1px solid #000; border:thin; background:#CCC;">No.</th>
    <th rowspan="2" style="border:1px solid #000; border:thin; background:#CCC;">Kategori</th>
    <th rowspan="2" style="border:1px solid #000; border:thin; background:#CCC;">Nama Produk</th>
    <th rowspan="2" style="border:1px solid #000; border:thin; background:#CCC;">Pabrik</th>
    <th rowspan="2" style="border:1px solid #000; border:thin; background:#CCC;">Negara Asal</th>
    <th rowspan="2" style="border:1px solid #000; border:thin; background:#CCC;">Kemasan</th>
    <th rowspan="2" style="border:1px solid #000; border:thin; background:#CCC;">NIE</th>
    <th rowspan="2" style="border:1px solid #000; border:thin; background:#CCC;">No. Lot / Bets</th>
    <th rowspan="2" style="border:1px solid #000; border:thin; background:#CCC;">Exp. Date</th>
    <th rowspan="2" style="border:1px solid #000; border:thin; background:#CCC;">Jumlah</th>
    <th colspan="3" style="border:1px solid #000; border:thin; background:#CCC;">Identitas Sarana</th>
    <th rowspan="2" style="border:1px solid #000; border:thin; background:#CCC;">Tindakan</th>
    <th rowspan="2" style="border:1px solid #000; border:thin; background:#CCC;">Keterangan</th>
	<?php if($balai == "Seluruh Balai"){?>
    <th rowspan="2" style="border:1px solid #000; border:thin; background:#CCC;">Balai Pemeriksa</th>
    <?php } ?>
  </tr>
  <tr>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Nama</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Alamat</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Pemilik</th>
  </tr>
  
  <?php if(count($temuan) > 0){ 
  $n = 1;
  for($z=0; $z<count($temuan); $z++){
  ?>
  <tr>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $n; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $temuan[$z]['KATEGORI']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $temuan[$z]['NAMA_PRODUK']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $temuan[$z]['NAMA_PABRIK']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $temuan[$z]['NEGARA_ASAL']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $temuan[$z]['KEMASAN']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $temuan[$z]['NOMOR_REGISTRASI']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $temuan[$z]['NO_BATCH']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $temuan[$z]['TANGGAL_EXPIRE']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $temuan[$z]['JUMLAH_TEMUAN']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $temuan[$z]['NAMA_PERUSAHAAN']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $temuan[$z]['ALAMAT_PERUSAHAAN']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $temuan[$z]['PEMILIK']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $temuan[$z]['TINDAKAN_PRODUK']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $temuan[$z]['KETERANGAN_SUMBER']; ?></td>
    <?php if($balai == "Seluruh Balai"){?>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $temuan[$z]['NAMA_BBPOM']; ?></td>
    <?php } ?>
  </tr>
  <?php $n++; } } else{ ?>	
  <tr>
    <td colspan="15" style="border:1px solid #000; border:thin;">Data Tidak Ditemukan</td>
  </tr>
  <?php } ?>
  
</table>

