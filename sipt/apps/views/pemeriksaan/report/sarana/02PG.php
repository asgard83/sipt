<?php 
if(!defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);
?>
<style type="text/css">
table.xcel{text-align: left;border:1px solid #000; border:thin; color:#000; font-family: "lucida grande", Tahoma, verdana, arial, sans-serif; font-size:10px; direction:ltr;}
table.xcelheader{text-align: left; border-collapse:collapse; color:#000; font-family: "lucida grande", Tahoma, verdana, arial, sans-serif; font-size:10px; direction:ltr;}
</style>
<?php
if($isTemuan){
?>
<div>
<table class="xcelheader">
	<td colspan="9"><b>REKAP LAPORAN BB/B POM PEMERIKSAAN SARANA DISTRIBUSI PANGAN TERKAIT TEMUAN PRODUK</b></td></tr>
	<tr><td>&nbsp;</td><td>Jenis Sarana</td><td colspan="7"><b><?php echo $judul; ?></b></td></tr>
	<tr><td>&nbsp;</td><td>Pemeriksaan Awal</td><td colspan="7"><?php echo $awal; ?></td></tr>
	<tr><td>&nbsp;</td><td>Pemeriksaan Akhir</td><td colspan="7"><?php echo $akhir; ?></td></tr>
    <tr><td>&nbsp;</td><td>Balai Besar / Balai Pemeriksa</td><td colspan="7"><?php echo $balai; ?></td></tr>      
    <tr><td colspan="9">&nbsp;</td></tr>
</table>
</div>
<table class="xcel">
  <tr>
    <th style="border:1px solid #000; border:thin; background:#CCC;">No</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Nama Produk</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Nama Produsen</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Jenis Registrasi</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Nomor Registrasi</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Kemasan</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Satuan</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Kategori</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Harga</th>
  </tr>
  <?php if(count($temuan) > 0){ 
  $n = 1;
  for($z=0; $z<count($temuan); $z++){
  ?>
  <tr>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $n; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $temuan[$z]['NAMA_PRODUK']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $temuan[$z]['PRODUSEN']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $temuan[$z]['REGISTRASI']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $temuan[$z]['NOMOR_REGISTRASI']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $temuan[$z]['KEMASAN']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $temuan[$z]['SATUAN']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $temuan[$z]['KATEGORI']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $temuan[$z]['HARGA']; ?></td>
  </tr>
  <?php $n++; } } else{ ?>	
  <tr>
    <td valign="top" style="border:1px solid #000; border:thin;" colspan="9">Data Tidak Ditemukan</td>
  </tr>
  <?php } ?>
</table>



<?php
}else{
?>
<div>
<table class="xcelheader">
	<tr><td>&nbsp;</td></tr>
	<td colspan="10"><b>LAPORAN HASIL PEMERIKSAAN SARANA DISTRIBUSI PANGAN</b></td></tr>
	<tr><td>&nbsp;</td><td>Jenis Sarana</td><td colspan="7"><b><?php echo $judul; ?></b></td></tr>
	<tr><td>&nbsp;</td><td>Pemeriksaan Awal</td><td colspan="7"><?php echo $awal; ?></td></tr>
	<tr><td>&nbsp;</td><td>Pemeriksaan Akhir</td><td colspan="7"><?php echo $akhir; ?></td></tr>
    <tr><td>&nbsp;</td><td>Balai Besar / Balai Pemeriksa</td><td colspan="7"><?php echo $balai; ?></td></tr>      
    <tr><td colspan="10">&nbsp;</td></tr>
</table>
</div>

<table class="xcel">
  <tr>
    <th style="border:1px solid #000; border:thin; background:#CCC;">No.</td>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Nama Sarana</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Alamat</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Tanggal Pemeriksaan</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Hasil Temuan</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Hasil Periksa</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Kesimpulan</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Tindakan</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Rekomendasi</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">CAPA</th>
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
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['HASIL_TEMUAN_LAIN']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['HASIL']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['KESIMPULAN']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;">
	<?php
	if(trim($kolom[$i]['TINDAKAN']) != ""){
		?>
        <ul style="list-style-type:decimal; padding-left:20px; margin:0;"><?php $tindakan = explode("#", $kolom[$i]['TINDAKAN']); echo "<li>".join("</li><li>", $tindakan)."</li>"; ?></ul>
        <?php
	}
	?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['REKOMENDASI']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['CAPA']; ?></td>
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
    <td valign="top" style="border:1px solid #000; border:thin;" colspan="10">Data Tidak Ditemukan</td>
  </tr>
  <?php } ?>
</table>
<?php } ?>