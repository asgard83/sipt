<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR); ?>
<style>
body {
font-family:font-family: "Times New Roman";
font-size:10pt;
}
@page {
margin-top: 2.5cm;
margin-bottom: 2.5cm;
margin-left: 2.5cm;
margin-right: 2.5cm;
}
h2.judulbap {
	font-size:14pt;
	font-weight:bold;
	text-decoration:underline;
}
table td {
	vertical-align:top;
	text-align:justify;
}
table.tb_temuan {
	font-size:8pt;
	border-collapse:collapse;
	width:100%;
	padding:5px;
}
table.tb_temuan tr.header th {
	border-collapse:collapse;
	text-align:left;
	padding:5px;
	border:1px solid #000;
	height:35px;
	vertical-align:top;
}
table.tb_temuan td {
	padding:5px;
	vertical-align:top;
	border:1px solid #000;
}
table.form_tabel {
	font-size:8pt;
	border-collapse:collapse;
	border-spacing:0;
	width:100%;
	padding:5px;
}
table.form_tabel td {
	padding:5px;
	vertical-align:top;
	border:1px solid #000;
}
table.form_tabel td.isi {
	font-weight:bold;
}
table.form_tabel td.td_no {
	width:20px;
}
table.form_tabel td.td_aspek {
	width:600px;
}
h2.small {
	font-size:9pt;
	font-weight:bold;
}
</style>
<div style="text-align:center;">
  <div><img src="<?php echo base_url(); ?>images/logobpom_.jpg" /></div>
  <div>
    <h2 class="judulbap">TINDAK LANJUT NOTIFIKASI PEMERIKSAAN <br>
      BAHAN BERBAHAYA</h2>
  </div>
</div>
<div style="height:5px;">&nbsp;</div>
<table width="100%">
  <tr>
    <td width="200">Nama Sarana Distribusi<br />Ritel/Toko/Apotek/PBF</td>
    <td width="20">:</td>
    <td><?php echo $sess['NAMA_SARANA']; ?></td>
  </tr>
  <tr>
    <td width="200">Bertindak Sebagai</td>
    <td width="20">:</td>
    <td><?php echo $sess['SARANA_BB']; ?></td>
  </tr>
  <tr>
    <td width="200">Alamat Kantor</td>
    <td width="20">:</td>
    <td><ul style="list-style-type:disc; padding-left:15px; margin:0;">
        <?php $alamat_1 = explode(";", $sess['ALAMAT_1']); echo "<li>".join("</li><li>", $alamat_1)."</li>"; ?>
      </ul></td>
  </tr>
  <tr>
    <td width="200">Alamat Gudang</td>
    <td width="20">:</td>
    <td><ul style="list-style-type:disc; padding-left:15px; margin:0;">
        <?php $alamat_2 = explode(";", $sess['ALAMAT_2']); echo "<li>".join("</li><li>", $alamat_2)."</li>"; ?>
      </ul></td>
  </tr>
  <tr>
    <td width="200">Telepon</td>
    <td width="20">:</td>
    <td><ul style="list-style-type:decimal; padding-left:20px; margin:0;">
        <?php $telepon = explode(";", $sess['TELEPON']); echo "<li>".join("</li><li>", $telepon)."</li>"; ?>
      </ul></td>
  </tr>
  <tr>
    <td width="200">Nomor Izin</td>
    <td width="20">:</td>
    <td><?php echo $sess['NOMOR_IZIN']; ?></td>
  </tr>
  <tr>
    <td width="200">Nama Pemilik / Pimpinan Usaha</td>
    <td width="20">:</td>
    <td><?php echo $sess['NAMA_PIMPINAN']; ?></td>
  </tr>
  <tr>
    <td width="200">Nama Penanggung Jawab</td>
    <td width="20">:</td>
    <td><?php echo $sess['PENANGGUNG_JAWAB']; ?></td>
  </tr>
  <tr>
    <td width="200">Tujuan Pemeriksaan</td>
    <td width="20">:</td>
    <td><?php echo $sess['TUJUAN_PEMERIKSAAN']; ?></td>
  </tr>
  <tr>
    <td width="200">Status Sarana</td>
    <td width="20">:</td>
    <td><?php echo $sess['STATUS_SARANA']; ?></td>
  </tr>
  <tr>
    <td width="200">Tanggal Pemeriksaan</td>
    <td width="20">:</td>
    <td><?php echo array_key_exists('AWAL_PERIKSA', $sess)?$sess['AWAL_PERIKSA']:""; ?>&nbsp; sampai dengan &nbsp;<?php echo array_key_exists('AKHIR_PERIKSA', $sess)?$sess['AKHIR_PERIKSA']:''; ?></td>
  </tr>
</table>
<div style="height:5px;">&nbsp;</div>
<h2 class="small">Detil Pengadaan B2, Distribusi B2 dan Repacking B2</h2>
<?php
$jml_pelaporan = count($pelaporan);
?>
<table class="tb_temuan">
<tr class="header">
  <th>Bahan Berbahaya</th>
  <th colspan="2">Kemasan</th>
  <th colspan="3">Pengadaan</th>
  <th colspan="3">Distribusi</th>
</tr>
<tr class="header">
  <th>&nbsp;</th>
  <th>Ukuran</th>
  <th>Repacking</th>
  <th>Nama <br />Alamat Pemasok</th>
  <th>Status <br />Pemasok</th>
  <th>Ukuran <br />Kemasan</th>
  <th>Nama <br />Alamat Pembeli</th>
  <th>Jenis <br />Sarana</th>
  <th>Tujuan <br />Penggunaan</th>
</tr>
<?php
if($jml_pelaporan > 0){
    for($z=0; $z < $jml_pelaporan; $z++){
?>
<tr>
  <td><?php echo $pelaporan[$z]['PRODUK_BB']; ?></td>
  <td><?php echo $pelaporan[$z]['KEMASAN']; ?></td>
  <td><?php echo $pelaporan[$z]['REPACKING']; ?></td>
  <td><?php echo $pelaporan[$z]['PENGADAAN_SARANA'].'<br />'.$pelaporan[$z]['PENGADAAN_ALAMAT'].'<br>'.$pelaporan[$z]['PENGADAAN_DAERAH_ID']; ?></td>
  <td><?php echo $pelaporan[$z]['PENGADAAN_STATUS']; ?></td>
  <td><?php echo $pelaporan[$z]['PENGADAAN_KEMASAN']; ?></td>
  <td><?php echo $pelaporan[$z]['DISTRIBUSI_SARANA'].'<br />'.$pelaporan[$z]['DISTRIBUSI_ALAMAT'].'<br>'.$pelaporan[$z]['DISTRIBUSI_DAERAH_ID']; ?></td>
  <td><?php echo $pelaporan[$z]['DISTRIBUSI_JENIS']; ?></td>
  <td><?php echo $pelaporan[$z]['DISTRIBUSI_TUJUAN']; ?></td>
</tr>
<?php
    }
}else{
?>
<tr>
  <td colspan="9">Data tidak ditemukan</td>
</tr>
<?php
}
?>
</table>
<div style="height:5px;">&nbsp;</div>
<h2 class="small">Tindak Lanjut</h2>
<?php
$jmlnotifikasi = count($notifikasi);
?>
<table class="tb_temuan">
<tr class="header">
  <th width="300">Nama Sarana</th>
  <th>Konfirmasi Tindak Lanjut</th>
</tr>
<?php
if($jmlnotifikasi > 0){
	for($x =0; $x < $jmlnotifikasi; $x++){
		?>
        <tr>
        	<td><?php echo $notifikasi[$x]['NAMA_SARANA']; ?>
            <div><?php echo $notifikasi[$x]['ALAMAT_SARANA']; ?></div>
            <?php echo $notifikasi[$x]['SARANA_ID'] == "0" ? '(Tidak Terdapat di Master Data)' : '(Terdapat di Master Data)'; ?>
            </td>
            <td>
             <?php
             if(strlen($notifikasi[$x]['CATATAN']) == 0 )
			 echo 'Belum dilakukan verifikasi kebenaran data sarana dan menginput hasil verifikasi ke Master Data';
			 else echo '<div style="padding-bottom:5px;">'.$notifikasi[$x]['CATATAN'].'</div><div>Diupdate oleh : '.$notifikasi[$x]['UPDATE_BY'].', '.$notifikasi[$x]['UPDATE_DATE'].'</div>';
			?>
            </td>
        </tr>
        <?php
	}
}else{
	?>
    <tr>
    	<td colspan="2">Data tidak ditemukan</td>
    </tr>
    <?php
}
?>
</table>
