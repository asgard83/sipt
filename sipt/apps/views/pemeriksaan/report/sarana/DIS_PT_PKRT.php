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
	<tr><td>&nbsp;</td><td colspan="14"><b>REKAP LAPORAN BB/B POM TERKAIT OBAT PALSU DAN TIE SERTA OBAT KERAS</b></td></tr>
	<tr><td>&nbsp;</td><td>Jenis Sarana</td><td colspan="13"><b><?php echo $judul; ?></b></td></tr>
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
  </tr>
  <?php $n++; } } else{ ?>	
  <tr>
    <td colspan="15" style="border:1px solid #000; border:thin;">Data Tidak Ditemukan</td>
  </tr>
  <?php } ?>
  
</table>

<?php
}else{
?>
<div>
<table class="xcelheader">
	<tr><td>&nbsp;</td><td colspan="14"><b>LAPORAN HASIL PEMERIKSAAN SARANA DISTRIBUSI OBAT PT DAN PKRT</b></td></tr>
	<tr><td>&nbsp;</td><td>Jenis Sarana</td><td colspan="13"><b><?php echo $judul; ?></b></td></tr>
	<tr><td>&nbsp;</td><td>Pemeriksaan Awal</td><td colspan="13"><?php echo $awal; ?></td></tr>
	<tr><td>&nbsp;</td><td>Pemeriksaan Akhir</td><td colspan="13"><?php echo $akhir; ?></td></tr>
    <tr><td>&nbsp;</td><td>Balai Besar / Balai Pemeriksa</td><td colspan="13"><?php echo $balai; ?></td></tr>      
    <tr><td colspan="15">&nbsp;</td></tr>
</table>
</div>

<table class="xcel">
  <tr>
    <th rowspan="2" style="border:1px solid #000; border:thin; background:#CCC;">No.</th>
    <th rowspan="2" style="border:1px solid #000; border:thin; background:#CCC;">Nama Sarana</th>
    <th rowspan="2" style="border:1px solid #000; border:thin; background:#CCC;">Alamat</th>
    <th rowspan="2" style="border:1px solid #000; border:thin; background:#CCC;">Tanggal Pemeriksaan</th>
    <th rowspan="2" style="border:1px solid #000; border:thin; background:#CCC;">Tujuan Pemeriksaan</th>
    <th colspan="5" style="border:1px solid #000; border:thin; background:#CCC;">Temuan</th>
    <th rowspan="2" style="border:1px solid #000; border:thin; background:#CCC;">Hasil</th>
    <th rowspan="2" style="border:1px solid #000; border:thin; background:#CCC;">Tindak Lanjut Balai</th>
    <th rowspan="2" style="border:1px solid #000; border:thin; background:#CCC;">Detil Tindak Lanjut Balai</th>
    <th rowspan="2" style="border:1px solid #000; border:thin; background:#CCC;">Tindak Lanjut Pusat</th>
    <th rowspan="2" style="border:1px solid #000; border:thin; background:#CCC;">Detil Tindak Lanjut Pusat</th>
    <th rowspan="2" style="border:1px solid #000; border:thin; background:#CCC;">Petugas</th>
  </tr>
  <tr>
    <th style="border:1px solid #000; border:thin; background:#CCC;">Hasil Temuan</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">M</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">m</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">C</th>
    <th style="border:1px solid #000; border:thin; background:#CCC;">CA</td>
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
    <?php
	if($kolom[$i]['TUJUAN_PEMERIKSAAN'] == "Rutin"){
		?>
		<td valign="top" style="border:1px solid #000; border:thin;"><ul style="list-style-type:decimal; padding-left:20px; margin:0;"><?php $hasil_temuan = explode("___", $kolom[$i]['HASIL_TEMUAN']); echo "<li>".join("</li><li>", $hasil_temuan)."</li>"; ?></ul></td>
		<?php
	}else if($kolom[$i]['TUJUAN_PEMERIKSAAN'] == "Kasus"){
		?>
		<td valign="top" style="border:1px solid #000; border:thin;"><ul style="list-style-type:decimal; padding-left:20px; margin:0;">
        <li>Kasus Point A : <br /><?php echo $kolom[$i]['KASUS_POINT_A']; ?></li>
        <li>Kasus Point B : <br /><?php echo $kolom[$i]['KASUS_POINT_B']; ?></li>
        <li>Kasus Point C : <br /><?php echo $kolom[$i]['KASUS_POINT_C']; ?></li>
        <li>Kasus Point D : <br /><?php echo $kolom[$i]['KASUS_POINT_D']; ?></li>
        <li>Kasus Point E : <br /><?php echo $kolom[$i]['KASUS_POINT_E']; ?></li>
        <li>Kasus Point F : <br /><?php echo $kolom[$i]['KASUS_POINT_F']; ?></li>
        <li>Kasus Point G : <br /><?php echo $kolom[$i]['KASUS_POINT_G']; ?></li>
        <li>Kasus Point H : <br /><?php echo $kolom[$i]['KASUS_POINT_H']; ?></li>
        </ul></td>
        <?php
	}
	?>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['MAJOR']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['MINOR']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['KRITIKAL']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['CA']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><?php echo $kolom[$i]['HASIL_PERIKSA']; ?></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><ul style="list-style-type:decimal; padding-left:20px; margin:0;"><?php $tl_balai= explode("#", $kolom[$i]['TINDAK_LANJUT_BALAI']); echo "<li>".join("</li><li>", $tl_balai)."</li>"; ?></ul></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><ul style="list-style-type:decimal; padding-left:20px; margin:0;"><?php $dt_balai= explode("#", $kolom[$i]['DETAIL_TINDAK_LANJUT_BALAI']); echo "<li>".join("</li><li>", $dt_balai)."</li>"; ?></ul></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><ul style="list-style-type:decimal; padding-left:20px; margin:0;"><?php $tl_balai= explode("#", $kolom[$i]['TINDAK_LANJUT_PUSAT']); echo "<li>".join("</li><li>", $tl_balai)."</li>"; ?></ul></td>
    <td valign="top" style="border:1px solid #000; border:thin;"><ul style="list-style-type:decimal; padding-left:20px; margin:0;"><?php $dt_balai= explode("#", $kolom[$i]['DETIL_TINDAK_LANJUT_PUSAT']); echo "<li>".join("</li><li>", $dt_balai)."</li>"; ?></ul></td>
    <td valign="top" style="border:1px solid #000; border:thin;">
    <ul style="margin-top:0px; padding-left:15px; list-style:decimal;">
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
    <td colspan="15" style="border:1px solid #000; border:thin;">Data Tidak Ditemukan</td>
  </tr>
  <?php } ?>
</table>
<?php } ?>