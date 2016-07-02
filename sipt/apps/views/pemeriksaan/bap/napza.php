<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR); ?>
<style>
body {font-family:font-family: "Times New Roman"; font-size:10pt;}
@page {margin-top: 2.5cm; margin-bottom: 2.5cm; margin-left: 2.5cm; margin-right: 2.5cm;}
h2.judulbap{font-size:14pt; font-weight:bold; text-decoration:underline;}
table td{vertical-align:top; text-align:justify;}
table.tb_temuan{font-size:8pt; border-collapse:collapse; border-spacing:0; width:100%; padding:5px;}
table.tb_temuan tr.header th{border-collapse:collapse; text-align:left; padding:5px; border:1px solid #000; height:35px; vertical-align:top;}
table.tb_temuan td{padding:5px;vertical-align:top; border:1px solid #000;}
</style>
<div style="text-align:center;">
	<div><img src="<?php echo base_url(); ?>images/logobpom_.jpg" /></div>
	<div><h2 class="judulbap">BERITA ACARA PEMERIKSAAN</h2></div>
</div>

<div style="height:5px;">&nbsp;</div>
<div style="text-align:justify;">Pada hari ini <?php echo $hari; ?> tanggal <?php echo $awal_periksa; ?> kami yang bertanda tangan di bawah ini :</div>
<div style="height:5px;">&nbsp;</div>
<table width="100%">
<?php 
$jml_petugas = count($petugas);
$no = 1;
for($z=0; $z<$jml_petugas; $z++){ ?>  
  <tr><td width="20"><?php echo $no; ?>.</td><td width="120">Nama</td><td width="20">:</td><td><?php echo $petugas[$z]['NAMA_PETUGAS']; ?></td></tr>
  <tr><td>&nbsp;</td><td>NIP</td><td>:</td><td><?php echo $petugas[$z]['NIP']; ?></td></tr>
  <tr><td>&nbsp;</td><td>Jabatan</td><td>:</td><td><?php echo $petugas[$z]['JABATAN']; ?></td></tr>
<?php 
$no++;
} ?>
</table>
<div style="height:20px;"></div>
<div style="text-align:justify">Berdasarkan surat tugas dari Kepala <?php echo ucwords(strtolower($petugas[0]['BADAN'])); ?> Nomor : <?php echo $petugas[0]['NOMOR_SURAT']; ?> tanggal <?php echo $petugas[0]['TANGGAL_SURAT']; ?> telah melakukan pemeriksaan terhadap : </div>
<div style="height:20px;"></div>
<table width="100%">
	<tr><td width="200">Nama Sarana</td><td width="20">:</td><td><?php echo $sess['NAMA_SARANA']; ?></td></tr>
	<tr><td width="200">Alamat</td><td width="20">:</td><td><?php echo $sess['ALAMAT_1']; ?></td></tr>
</table>
<div style="height:20px;"></div>
<div style="text-align:justify;">Adapun hasil pemeriksaan sebagaimana tersebut terlampir. </div>
<div style="height:20px;"></div>
<div style="text-align:justify;">Demikian Berita Acara ini dibuat dengan sesungguhnya untuk dapat dipergunakan sebagaimana mestinya. </div>
<div style="height:40px;"></div>
<table style="width:100%">
	<tr><td style="width:50%;">Mengetahui,</td><td style="width:50%;">Yang membuat Berita Acara</td></tr>
	<tr><td height="150">Penanggung Jawab,</td><td>
    <table width="100%">
    <?php 
    $jml = count($petugas);
    $no = 1;
    for($x=0; $x<$jml; $x++){ ?>  
      <tr><td width="20"><?php echo $no; ?>.</td><td><?php echo $petugas[$x]['NAMA_PETUGAS']; ?></td></tr>
    <?php 
    $no++;
    } ?>
    </table></td></tr>
	<tr><td><?php echo $sess['PENANGGUNG_JAWAB']; ?></td><td>&nbsp;</td></tr>
</table>

<pagebreak>
<p><b>Lampiran I</b>
<p><b>Sarana yang diperiksa : </b></p>
<table width="100%">
	<tr><td width="200">Nama Sarana</td><td width="20">:</td><td><?php echo $sess['NAMA_SARANA']; ?></td></tr>
	<tr><td width="200">Alamat Sarana</td><td width="20">:</td><td><?php echo $sess['ALAMAT']; ?></td></tr>
	<tr><td width="200">Nomor Izin Sarana</td><td width="20">:</td><td><?php echo $sess['NOMOR_IZIN']; ?></td></tr>
	<tr><td width="200">Penanggung Jawab Sarana</td><td width="20">:</td><td><?php echo $sess['PENANGGUNG_JAWAB']; ?></td></tr>
</table>
<div style="height:5px;"></div>
<p><b>Informasi Pemeriksaan</b></p>
<table width="100%">
	<tr><td width="200">Tanggal Pemeriksaan</td><td width="20">:</td><td><?php echo $sess['AWAL_PERIKSA']; ?>&nbsp; sampai dengan &nbsp; <?php echo $sess['AKHIR_PERIKSA']; ?></td></tr>
	<tr><td width="200">Tujuan Pemeriksaan</td><td width="20">:</td><td><?php echo $sess['TUJUAN_PEMERIKSAAN']; ?></td></tr>
	<tr><td width="200">Dasar Pemeriksaan</td><td width="20">:</td><td><?php echo $sess['DASAR_PEMERIKSAAN']; ?></td></tr>
</table>

<p><b>Tindakan Balai</b></p>
<table width="100%">
<tr><td width="200">Tanggal Tindakan</td><td width="20">:</td><td><?php echo $sess['TANGGAL_TINDAKAN_BALAI']; ?></td></tr>
<tr><td>Unit yang melakukan tindakan</td><td width="20">:</td><td><?php echo $sess['UNIT_BALAI']; ?></td></tr>
<tr><td>Detail Tindakan</td><td width="20">:</td><td><?php echo $sess['DETAIL_TINDAKAN_BALAI']; ?></td></tr>
</table>

<?php if(trim($sess['TANGGAL_TINDAKAN_PUSAT']) != ""){ ?>
<p><b>Tindakan Pusat</b></p>
<table width="100%">
<tr><td width="200">Tanggal Tindakan</td><td width="20">:</td><td><?php echo ($sess['TANGGAL_TINDAKAN_PUSAT'] == '01/01/1900' ? '' : $sess['TANGGAL_TINDAKAN_PUSAT']); ?></td></tr>
<tr><td>Unit yang melakukan tindakan</td><td width="20">:</td><td><?php echo $sess['UNIT_PUSAT']; ?></td></tr>
<tr><td>Detail Tindakan</td><td width="20">:</td><td><?php echo $sess['DETAIL_TINDAKAN_PUSAT']; ?></td></tr>
<?php /*<tr><td>File Tindak Lanjut</td><td><?php if($sess['FILE_TINDAK_LANJUT'] != ""){ ?><a href="<?php echo base_url(); ?>files/<?php echo $sess['SARANA_ID']; ?>/<?php echo $sess['FILE_TINDAK_LANJUT']; ?>" target="_blank">File Lampiran</a><?php } ?></td></tr>*/?>
</table>
<?php } ?>

<?php if($sess['JML_TEMUAN'] != '0') { ?>
<pagebreak sheet-size="330mm 210mm" />
<p><b>Lampiran II</b></p>
<p>Temuan Produk</p>
<table class="tb_temuan">
<tr class="header"><th>Nama Produk</th><th>Jenis Pelanggaran</th><th>Jenis Kriteria Pelanggaran</th><th>Jenis Penyimpangan</th><th>Klasifikasi Produk</th></tr>
<?php
if(count($temuan_produk) != 0){
  for($i=0; $i<count($temuan_produk); $i++){
      ?>
      <tr id="<?php echo $temuan_produk[$i]['SERI']; ?>"><td><?php echo $temuan_produk[$i]['NAMA_PRODUK']; ?></td><td><?php echo $temuan_produk[$i]['JENIS_PELANGGARAN']; ?></td><td><?php echo $temuan_produk[$i]['JENIS_KRITERIA_PELANGGARAN']; ?></td><td><?php echo $temuan_produk[$i]['JENIS_PENYIMPANGAN']; ?></td><td><?php echo $temuan_produk[$i]['KLASIFIKASI_PRODUK']; ?></td></tr>
      <?php
  }
}else{
  $temuan_produk = "";
}
?>
</table>
<?php } ?>
