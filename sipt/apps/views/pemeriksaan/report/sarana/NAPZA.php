<?php 
if(!defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);
?>
<style>
table.xcel{text-align: left;border:1px solid #000; border:thin; color:#000; font-family: "lucida grande", Tahoma, verdana, arial, sans-serif; font-size:10px; direction:ltr;}
table.xcelheader{text-align: left; border-collapse:collapse; color:#000; font-family: "lucida grande", Tahoma, verdana, arial, sans-serif; font-size:10px; direction:ltr;}
</style>
<?php
if($isTemuan){
?>
<div>
<table class="xcelheader">
	<tr><td colspan="6">&nbsp;</td></tr>
	<td colspan="6"><b>REKAP LAPORAN BB/B POM PENGAWASAN NAPZA TERKAIT TEMUAN PRODUK</b></td></tr>
	<tr><td>&nbsp;</td><td>Jenis Sarana</td><td colspan="4"><b><?php echo $judul; ?></b></td></tr>
	<tr><td>&nbsp;</td><td>Pemeriksaan Awal</td><td colspan="4"><?php echo $awal; ?></td></tr>
	<tr><td>&nbsp;</td><td>Pemeriksaan Akhir</td><td colspan="4"><?php echo $akhir; ?></td></tr>
    <tr><td>&nbsp;</td><td>Balai Besar / Balai Pemeriksa</td><td colspan="4"><?php echo $balai; ?></td></tr>      
    <tr><td colspan="6">&nbsp;</td></tr>
</table>
</div>
<table class="xcel">
  <tr>
    <th style="border:1px solid #000; border:thin; background:#CCC;">No.</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Nama Produk</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Klasifikasi Produk</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Jenis Pelanggaran</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Jenis Penyimpangan</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Jenis Kriteria Pelanggaran</th>
  </tr>
  <?php if(count($temuan) > 0){ 
  $n = 1;
  for($z=0; $z<count($temuan); $z++){
  ?>
  <tr>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $n; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $temuan[$z]['NAMA_PRODUK']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $temuan[$z]['KLASIFIKASI_PRODUK']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $temuan[$z]['JENIS_PELANGGARAN']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $temuan[$z]['JENIS_PENYIMPANGAN']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $temuan[$z]['JENIS_KRITERIA_PELANGGARAN']; ?></td>
  </tr>
  <?php $n++; } } else{ ?>	
  <tr>
    <td colspan="6" style="border:1px solid #000; border:thin;">Data Tidak Ditemukan</td>
  </tr>
  <?php } ?>
  
</table>

<?php
}else{
?>
<div>
<table class="xcelheader">
	<tr><td>&nbsp;</td></tr>
	<td colspan="9"><b>LAPORAN HASIL PEMERIKSAAN SARANA PENGAWASAN NAPZA</b></td></tr>
	<tr><td>&nbsp;</td><td>Jenis Sarana</td><td colspan="7"><b><?php echo $judul; ?></b></td></tr>
	<tr><td>&nbsp;</td><td>Pemeriksaan Awal</td><td colspan="7"><?php echo $awal; ?></td></tr>
	<tr><td>&nbsp;</td><td>Pemeriksaan Akhir</td><td colspan="7"><?php echo $akhir; ?></td></tr>
    <tr><td>&nbsp;</td><td>Balai Besar / Balai Pemeriksa</td><td colspan="7"><?php echo $balai; ?></td></tr>      
    <tr><td colspan="9">&nbsp;</td></tr>
</table>
</div>

<table class="xcel">
  <tr>
    <th style="border:1px solid #000; border:thin; background:#CCC;">No.</td>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Nama Sarana</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Alamat</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Tanggal Pemeriksaan</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Tujuan Pemeriksaan</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Dasar Pemeriksaan</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Tindakan Balai</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Tindakan Pusat</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Petugas Pemeriksa</th>
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
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['TUJUAN_PEMERIKSAAN']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['DASAR_PEMERIKSAAN']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['DETAIL_TINDAKAN_BALAI']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['DETAIL_TINDAKAN_PUSAT']; ?></td>
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
    <td valign="top" style="border:1px solid #000; border:thin;" colspan="9">Data Tidak Ditemukan</td>
  </tr>
  <?php } ?>
</table>
<?php } ?>