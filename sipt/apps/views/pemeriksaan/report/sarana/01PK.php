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
	<tr><td>&nbsp;</td><td colspan="15"><b>REKAP LAPORAN BB/B POM PEMERIKSAAN SARANA PRODUKSI PRODUK KOMPLEMEN TERKAIT TEMUAN PRODUK</b></td></tr>
	<tr><td>&nbsp;</td><td>Jenis Sarana</td><td colspan="14"><b><?php echo $judul; ?></b></td></tr>
	<tr><td>&nbsp;</td><td>Pemeriksaan Awal</td><td colspan="14"><?php echo $awal; ?></td></tr>
	<tr><td>&nbsp;</td><td>Pemeriksaan Akhir</td><td colspan="14"><?php echo $akhir; ?></td></tr>
    <tr><td>&nbsp;</td><td>Balai Besar / Balai Pemeriksa</td><td colspan="14"><?php echo $balai; ?></td></tr>      
    <tr><td colspan="15">&nbsp;</td></tr>
</table>
</div>
<table class="xcel">
  <tr>
    <th style="border:1px solid #000; border:thin; background:#CCC;" rowspan="2">No</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;" rowspan="2">Klasifikasi Produk</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;" colspan="2">Identitas Perusahaan</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;" colspan="5">Produk</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;" colspan="7">Temuan</th>
  </tr>
  <tr>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Nama Perusahaan</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Alamat Perusahaan</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Nama Produk</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Nomor Registrasi</th>
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
  </tr>
  <?php $n++; } } else{ ?>	
  <tr>
    <td valign="top" style="border:1px solid #000; border:thin;" colspan="16">Data Tidak Ditemukan</td>
  </tr>
  <?php } ?>
</table>



<?php
}else{
?>
<div>
<table class="xcelheader">
	<tr><td colspan="20">&nbsp;</td></tr>
	<td colspan="20"><b>LAPORAN HASIL PEMERIKSAAN SARANA PRODUKSI PRODUK KOMPLEMEN</b></td></tr>
	<tr><td>&nbsp;</td><td>Jenis Sarana</td><td colspan="18"><b><?php echo $judul; ?></b></td></tr>
	<tr><td>&nbsp;</td><td>Pemeriksaan Awal</td><td colspan="18"><?php echo $awal; ?></td></tr>
	<tr><td>&nbsp;</td><td>Pemeriksaan Akhir</td><td colspan="18"><?php echo $akhir; ?></td></tr>
    <tr><td>&nbsp;</td><td>Balai Besar / Balai Pemeriksa</td><td colspan="18"><?php echo $balai; ?></td></tr>      
    <tr><td colspan="20">&nbsp;</td></tr>
</table>
</div>

<table class="xcel">
  <tr>
    <th style="border:1px solid #000; border:thin; background:#CCC;" rowspan="2">No</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;" colspan="4">Data Sarana</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;" colspan="4">Pemeriksaan</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;" colspan="3">Klasifikasi Temuan</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;" colspan="4">Kesimpulan</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;" colspan="2">Tindak Lanjut</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;" colspan="2">CAPA</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;" rowspan="2">Petugas Pemeriksa</th>
  </tr>
  <tr>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Nama</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Alamat</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Pimpinan</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Penanggung Jawab</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Tanggal</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Tujuan </th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Kepatuhan CPOTB</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Hasil</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Kritikal</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Major</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Minor</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Detil Hasil</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Detil TMK</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Rekomendasi</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Kesimpulan</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Tindak Lanjut</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Timeline</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Status CAPA</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">CAPA Closed</th>
  </tr>
  <?php if(count($kolom) > 0){ 
  $no = 1;
  for($i=0; $i<count($kolom); $i++){
  ?>
  <tr>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $no; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['NAMA_SARANA']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['ALAMAT']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['NAMA_PIMPINAN']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['PENANGGUNG_JAWAB']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['TANGGAL']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['TUJUAN_PEMERIKSAAN']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['KEPATUHAN_CPPKB']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['HASIL']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['TEMUAN_KRITIKAL']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['TEMUAN_MAJOR']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['TEMUAN_MINOR']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><ul style="list-style-type:disc; padding-left:10px; margin:0;"><?php $DTLHASIL = explode("#",$kolom[$i]['DETIL_HASIL']); echo "<li>".join("</li><li>", $DTLHASIL)."</li>"; ?></ul></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><ul style="list-style-type:disc; padding-left:10px; margin:0;"><?php $DTLTMK = explode("#",$kolom[$i]['KESIMPULAN_DETIL_TMK']); echo "<li>".join("</li><li>", $DTLTMK)."</li>"; ?></ul></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['REKOMENDASI']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['KESIMPULAN']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['TINDAK_LANJUT']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['TIME_LINE']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['STATUS_CAPA']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['CAPA_CLOSE']; ?></td>
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
    <td valign="top" style="border:1px solid #000; border:thin;" colspan="21">Data tidak ditemukan</td>
  </tr>
  <?php } ?>
</table>
<?php } ?>