<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR);?>
<style>
body {font-family:font-family: "Times New Roman"; font-size:10pt;}
@page {margin-top: 2.5cm; margin-bottom: 2.5cm; margin-left: 2.5cm; margin-right: 2.5cm;}
h2.judulbap{font-size:14pt; font-weight:bold; text-decoration:underline;}
table td{vertical-align:top; text-align:justify;}
table.tb_temuan{font-size:8pt; border-collapse:collapse; width:100%; padding:5px;}
table.tb_temuan tr.header th{border-collapse:collapse; text-align:left; padding:5px; border:1px solid #000; height:35px; vertical-align:top;}
table.tb_temuan td{padding:5px;vertical-align:top; border:1px solid #000;}
table.form_tabel{font-size:8pt; border-collapse:collapse; border-spacing:0; width:100%; padding:5px;}
table.form_tabel td{padding:5px;vertical-align:top; border:1px solid #000;}
table.form_tabel td.isi{font-weight:bold;}
table.form_tabel td.td_no{width:20px;}
table.form_tabel td.td_aspek{width:600px;}
table.box{border:1px solid #000; width:100%}
h2.small{font-size:9pt; font-weight:bold;}
div.boxatas{}
div.boxbawah{}
div.boxatasbawah{}
</style>
<div style="text-align:center;">
	<div><img src="<?php echo base_url(); ?>images/logobpom_.jpg" /></div>
	<div><h2 class="judulbap">FORM - LAPORAN INSPEKSI CPKB</h2></div>
</div>

<div style="height:5px;">&nbsp;</div>
<div class="boxatas">
<table width="100%">
<tr><td width="220">Nama Sarana</td><td width="10">:</td><td><b><?php echo strtoupper($sess['NAMA_SARANA']); ?></b></td></tr>
<tr><td width="220">Alamat</td><td width="10">:</td><td><?php echo $sess['ALAMAT_1']; ?></td></tr>
<tr><td width="220">Jenis Industri</td><td width="10">:</td><td><?php echo $sess['JENIS_INDUSTRI']; ?></td></tr>
<tr><td width="220">Kegiatan yang dilakukan</td><td width="10">:</td><td>
<?php
if(trim($sess['KEGIATAN_SARANA']) != ""){
$kegiatan = explode("|", $sess['KEGIATAN_SARANA']);
$jmlkegiatan = count($kegiatan);
?><ul style="list-style-type:decimal; padding-left:15px; margin:0;"><?php
for($k=0;$k<$jmlkegiatan;$k++){
	?>
    <li><?php echo $kegiatan[$k]; ?></li>
    <?php
}
?></ul>
<?php
}
?>
</td></tr>
<tr><td width="220">Nama Pemilik</td><td width="10">:</td><td><?php echo $sess['NAMA_PIMPINAN']; ?></td></tr>
<tr><td width="220">Nama Penanggung Jawab</td><td width="10">:</td><td><?php echo $sess['PENANGGUNG_JAWAB']; ?></td></tr>
<tr><td width="220">Tanggal Pemeriksaan</td><td width="10">:</td><td><?php echo $sess['AWAL_PERIKSA']; ?>&nbsp; sampai dengan &nbsp;<?php echo $sess['AKHIR_PERIKSA']; ?></td></tr>
<tr><td width="220">Kepatuhan CPKB dan Keputusan</td><td width="10">:</td><td><?php echo $sess['KEPATUHAN_CPKB']; ?></td></tr>
<tr><td width="220">Latar Belakang Hasil Pemeriksaan yang Lalu</td><td width="10">:</td><td><?php echo $sess['LATAR_BELAKANG']; ?></td></tr>
<tr><td width="220">Perubahan Bermakna sejak inspeksi terakhir</td><td width="10">:</td><td><?php echo $sess['PERUBAHAN_BERMAKNA']; ?></td></tr>
<tr><td width="220">Tujuan Pemeriksaan</td><td width="10">:</td><td><?php echo $sess['TUJUAN_PEMERIKSAAN']; ?></td></tr>
<tr><td colspan="3">&nbsp;</td></tr>
</table>
</div>

<div class="boxatas">
<table width="100%">
<tr><td width="220">Tanggal Inspeksi Sebelumnya</td><td width="10">:</td><td><?php echo $sess['TERAKHIR']; ?></td></tr>
<tr><td colspan="3">Inspektur yang bertugas pada inspeksi sebelumnya</td></tr>
<tr><td colspan="3">
<?php 
  $inspektur = explode("-",$sess['INSPEKTUR']);
  unset($inspektur[0]);
  $xx = 1;
  foreach($inspektur as $val){ echo "<div>".$xx.". ".$val."</div>"; $xx++;}
?>
</td></tr>
<tr><td colspan="3">&nbsp;</td></tr>
</table>
</div>
<div class="boxatasbawah">
<div><b>Ringkasan hasil inspeksi sebelumnya</b></div>
<div style="page-break-inside:avoid;"><?php echo preg_replace('/[^(\x20-\x7F)]*/', "",html_entity_decode($sess['RINGKASAN'])); ?></div>
<div><b>Penjelasan Singkat Dari Kegiatan Inspeksi yang Dilakukan</b></div>
<div>Ruang Lingkup</div>
<div style="page-break-inside:avoid;"><?php echo preg_replace('/[^(\x20-\x7F)]*/', "",html_entity_decode($sess['RUANG_LINGKUP'])); ?></div>
<div>Area Inspeksi</div>
<div style="page-break-inside:avoid;"><?php echo preg_replace('/[^(\x20-\x7F)]*/', "",html_entity_decode($sess['AREA_INSPEKSI'])); ?></div>
</div>
<div style="height:10px;"></div>
<div style="page-break-inside:avoid;">&nbsp;</div>
<div><b>TEMUAN DAN OBSERVASI</b></div>
<?php 
$jmltemuan = count($temuan);
if($jmltemuan > 0){	
	$currenttemuan = "";
	for($t=0; $t<$jmltemuan; $t++){
		?> <div style="padding-top:5px; padding-bottom:5px;"> <?php
		if($temuan[$t]['URAIAN'] != $currenttemuan){
			echo '<h2 class="small">'.$temuan[$t]['URAIAN'].'</h2>';
		}
		?></div><div><?php echo preg_replace('/[^(\x20-\x7F)]*/', "",html_entity_decode($temuan[$t]['TEMUAN_TEKS'])); ?></div><div style="padding-bottom:5px;">Kriteria : <?php echo $temuan[$t]['TEMUAN_KRITERIA']; ?></div><?php
		$currenttemuan = $temuan[$t]['URAIAN'];
	}
}
?>
<div style="height:10px;">&nbsp;</div>
<div class="boxatasbawah">
<div><b>Distribusi dan Pengangkutan</b></div>
<div style="page-break-inside:avoid;"><?php echo preg_replace('/[^(\x20-\x7F)]*/', "",html_entity_decode($sess['DISTRIBUSI_PENGANGKUTAN'])); ?></div>
<div><b>Pertanyaan Berkaitan dengan Penilaian Permohonan Pendaftaran Produk</b></div>
<div style="page-break-inside:avoid;"><?php echo preg_replace('/[^(\x20-\x7F)]*/', "",html_entity_decode($sess['PERMOHONAN_PENDAFTARAN_PRODUK'])); ?></div>
<div><b>Isu Spesifik Lainnya</b></div>
<div style="page-break-inside:avoid;"><?php echo preg_replace('/[^(\x20-\x7F)]*/', "",html_entity_decode($sess['ISU_SPESIFIK_LAINNYA'])); ?></div>
<div><b>Site Master File</b></div>
<div style="page-break-inside:avoid;"><?php echo preg_replace('/[^(\x20-\x7F)]*/', "",html_entity_decode($sess['SITE_FILE_MASTER'])); ?></div>
<div><b>Lain-Lain</b></div>
<div style="page-break-inside:avoid;"><?php echo preg_replace('/[^(\x20-\x7F)]*/', "",html_entity_decode($sess['LAIN_LAIN'])); ?></div>
<div><b>Sampel yang Diambil</b></div>
<div style="page-break-inside:avoid;"><?php echo preg_replace('/[^(\x20-\x7F)]*/', "",html_entity_decode($sess['SAMPEL_DIAMBIL'])); ?></div>
<table width="100%">
<tr><td>Distribusi Laporan</td></tr>
<tr><td><?php echo $sess['DISTRIBUSI_LAPORAN']; ?></td></tr>
<tr><td>Kesimpulan Sarana</td></tr>
<tr><td><?php echo $sess['KESIMPULAN_OBSERVASI']; ?></td></tr>
<tr><td>Tindak Lanjut Temuan dan Observasi</td></tr>
<tr><td><?php if(trim($sess['TINDAKAN_OBSERVASI']) != "") { ?>
<ul style="list-style-type:disc; padding-left:15px; margin:0;"><?php echo "<li>".join("</li><li>", $sel_tindakan_observasi)."</li>"; ?></ul><?php }else { echo "-"; } ?></td></tr>	
</table>
</div>

<div style="height:10px;">&nbsp;</div>
<div class="boxatasbawah">
<h2 class="small">Pemeriksaan DIP</h2>
<div><b>Bagian I : Dokumen Administrasi & Ringkasan Produk</b></div>
<div style="page-break-inside:avoid;"><?php echo preg_replace('/[^(\x20-\x7F)]*/', "",html_entity_decode($sess['DIP_A'])); ?></div>
<div><b>Bagian II : Data Mutu Keamanan dan Bahan Kosmetik</b></div>
<div style="page-break-inside:avoid;"><?php echo preg_replace('/[^(\x20-\x7F)]*/', "",html_entity_decode($sess['DIP_B'])); ?></div>
<div><b>Bagian III : Data Mutu Kosmetik</b></div>
<div style="page-break-inside:avoid;"><?php echo preg_replace('/[^(\x20-\x7F)]*/', "",html_entity_decode($sess['DIP_C'])); ?></div>
<div><b>Bagian IV : Data Keamanan dan Kemanfaatan Kosmetik</b></div>
<div style="page-break-inside:avoid;"><?php echo preg_replace('/[^(\x20-\x7F)]*/', "",html_entity_decode($sess['DIP_D'])); ?></div>
<h2 class="small">Kesimpulan DIP</h2>
<div><b>Kesimpulan DIP</b></div>
<div style="page-break-inside:avoid;"><?php echo preg_replace('/[^(\x20-\x7F)]*/', "",html_entity_decode($sess['KESIMPULAN_DIP'])); ?></div>
<div><b>Tindak Lanjut</b></div>
<div style="page-break-inside:avoid;"><?php echo preg_replace('/[^(\x20-\x7F)]*/', "",html_entity_decode($sess['TINDAK_LANJUT_DIP'])); ?></div>
<h2 class="small">Kesimpulan DIP</h2>
</div>

<div style="height:10px;">&nbsp;</div>
<div class="boxatasbawah">
<table width="100%">
<tr><td width="220">1. Temuan Kritikal</td><td width="10">&nbsp;</td><td><?php echo $sess['TEMUAN_KRITIKAL']; ?></td></tr>
<tr><td width="220">2. Temuan Major</td><td width="10">&nbsp;</td><td><?php echo $sess['TEMUAN_MAJOR']; ?></td></tr>
<tr><td width="220">3. Temuan Minor</td><td width="10">&nbsp;</td><td><?php echo $sess['TEMUAN_MINOR']; ?></td></tr>
</table>
</div>

<div style="height:10px;">&nbsp;</div>
<div class="boxatasbawah">

<table width="100%">
<tr><td colspan="3"><h2 class="small">Kesimpulan</h2></td></tr>
<tr <?php if($sess['TUJUAN_PEMERIKSAAN'] == "Sertifikasi" || $sess['TUJUAN_PEMERIKSAAN'] == "Prasertifikasi" || $sess['TUJUAN_PEMERIKSAAN'] == "Resertifikasi") echo 'style="display:none"'; else echo 'style=""';?>><td width="220">Hasil Pemeriksaan</td><td width="10">&nbsp;</td><td><?php echo $sess['HASIL']; ?></td></tr>
<tr <?php if($sess['HASIL'] == "MK"){echo 'style=""'; }else{ echo 'style="display:none;"'; }?>><td width="220">Catatan</td><td width="10">&nbsp;</td><td><?php echo preg_replace('/[^(\x20-\x7F)]*/', "",html_entity_decode($sess['REKOMENDASI'])); ?></td></tr>
<tr <?php if($sess['HASIL'] == "TMK"){echo 'style=""'; }else{ echo 'style="display:none;"'; }?>><td width="220">Detil Hasil Pemeriksaan</td><td width="10">&nbsp;</td><td><?php if(trim($sess["DETIL_HASIL"]) != ""){ ?><ul style="list-style-type:decimal; padding-left:15px; margin:0;"><?php $detil_hasil = explode("#", $sess['DETIL_HASIL']); echo "<li>".join("</li><li>", $detil_hasil)."</li>"; ?></ul><?php } ?></td></tr>
<tr <?php if($sess['HASIL'] == "TMK"){echo 'style=""'; }else{ echo 'style="display:none;"'; }?>><td width="220">Detil Kesimpulan TMK</td><td width="10">&nbsp;</td><td><?php echo preg_replace('/[^(\x20-\x7F)]*/', "",html_entity_decode($sess['KESIMPULAN_DETIL_TMK'])); ?></td></tr>
</table>

<table width="100%">
<tr><td colspan="3"><h2 class="small">Tindak Lanjut</h2></td></tr>
<tr><td width="220">Tindak Lanjut Hasil Inspeksi</td><td width="10">&nbsp;</td><td><?php echo preg_replace('/[^(\x20-\x7F)]*/', "",html_entity_decode($sess['TINDAK_LANJUT'])); ?></td></tr>
<tr><td width="220">Time Line</td><td width="10">&nbsp;</td><td><?php echo preg_replace('/[^(\x20-\x7F)]*/', "",html_entity_decode($sess['TIME_LINE'])); ?></td></tr>
</table>

<table width="100%">
<tr><td colspan="3"><h2 class="small">C A P A</h2></td></tr>
<tr><td width="220">Hasil Evaluasi CAPA</td><td width="10">&nbsp;</td><td><?php echo preg_replace('/[^(\x20-\x7F)]*/', "",html_entity_decode($sess['STATUS_CAPA'])); ?></td></tr>
</table>

</div>

<div class="boxatasbawah">
<table width="100%">
<tr><td>Nama Inspektur Badan POM</td></tr>
<tr><td>
<?php
$jml_inspektur = count($petugas);
$npp = 1;
for($np=0; $np<$jml_inspektur; $np++){
	?>
    <div><?php echo $npp.". ".$petugas[$np]['NAMA_PETUGAS']; ?></div>
    <?php
	$npp++;
}
?>
</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td>Tanda tangan ketua tim</td></tr>
<tr><td>Tanggal : <?php echo $awal_periksa; ?></td></tr>
</table>
</div>

<?php if($sess['JUMLAH_TEMUAN'] != 0) { ?>
<pagebreak sheet-size="330mm 210mm" />
<p><b>Lampiran</b></p>
<p>Temuan Produk</p>
<table class="tb_temuan">
    <tr class="header"><th>Detil Kosmetik</th><th>Klasifikasi</th><th>Nama<br />Perusahaan</th><th>Kategori<br />Temuan</th><th>Jenis <br /> Pelanggaran</th><th>Harga Total</th><th>Keterangan<br />(sumber perolehan)</th></tr>
<?php
	for($i=0; $i<count($temuan_produk); $i++){
		?>
		<tr><td><?php echo $temuan_produk[$i]['NAMA_PRODUK']; ?><br>No. Registrasi : <?php echo $temuan_produk[$i]['NOMOR_REGISTRASI']; ?><br>No. Batch : <?php echo $temuan_produk[$i]['NO_BATCH']; ?><br>Tanggal Expire : <?php echo $temuan_produk[$i]['TANGGAL_EXPIRE']; ?><br>Netto : <?php echo $temuan_produk[$i]['NETTO']; ?><br>Harga Satuan : <?php echo $temuan_produk[$i]['HARGA_SATUAN']; ?><br>Jumlah Temuan : <?php echo $temuan_produk[$i]['JUMLAH_TEMUAN']; ?>&nbsp;<?php echo $temuan_produk[$i]['SATUAN']; ?></td><td><?php echo $temuan_produk[$i]['KLASIFIKASI_PRODUK']; ?></td><td><?php echo $temuan_produk[$i]['NAMA_PERUSAHAAN']; ?><br><?php echo $temuan_produk[$i]['ALAMAT_PERUSAHAAN']; ?></td><td><?php echo $temuan_produk[$i]['KATEGORI']; ?></td><td><?php echo $temuan_produk[$i]['JENIS_PELANGGARAN']; ?><br />Tindakan Produk : <?php echo $temuan_produk[$i]['TINDAKAN_PRODUK']; ?></td><td><?php echo $temuan_produk[$i]['HARGA_TOTAL']; ?></td><td><?php echo $temuan_produk[$i]['KETERANGAN_SUMBER']; ?></td></tr>
		<?php
	}
  ?>
</table>
<?php } ?>