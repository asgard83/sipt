<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR); ?>
<style>
body {font-family:"Times New Roman"; font-size:10pt;}
@page {margin-top: 2.5cm; margin-bottom: 2.5cm; margin-left: 2.5cm; margin-right: 2.5cm;}
h2.judulbap{font-size:14pt; font-weight:bold; text-decoration:underline;}
table td{vertical-align:top; text-align:justify;}
table.tb_temuan{font-size:8pt; border-collapse:collapse; width:100%; padding:5px;}
table.tb_temuan tr.header th{border-collapse:collapse; text-align:left; padding:5px; border:1px solid #000; height:35px; vertical-align:top;}
table.tb_temuan td{padding:5px;vertical-align:top; border:1px thin #000;}
table.form_tabel{font-size:8pt; border-collapse:collapse; border-spacing:0; width:100%; padding:5px;}
table.form_tabel td{padding:5px;vertical-align:top; border:1px solid #000;}
table.form_tabel td.isi{font-weight:bold;}
table.form_tabel td.td_no{width:20px;}
table.form_tabel td.td_aspek{width:600px;}
table.box{border:1px solid #000; width:100%}
h2.small{font-size:9pt; font-weight:bold;}
div{text-align:justify;}
div.boxatas{}
div.boxbawah{}
div.boxatasbawah{}
</style>
<div style="text-align:center;">
	<div style="text-align:center;"><img src="<?php echo base_url(); ?>images/logobpom_.jpg" /></div>
	<div style="text-align:center;"><h2 class="judulbap">FORM - LAPORAN INSPEKSI CPOB</h2></div>
</div>


<table width="100%"><tr><td width="220">Nomor Inspeksi</td><td width="10">:</td><td><?php echo $sess['NOMOR_INSPEKSI']; ?></td></tr></table>
<table width="100%">
<tr><td width="220">Industri Farmasi yang diinspeksi</td><td width="10">:</td><td><b><?php echo strtoupper($sess['NAMA_SARANA']); ?></b></td></tr>
<tr><td width="220">&nbsp;</td><td width="10">&nbsp;</td><td><?php echo $sess['ALAMAT_1']; ?></td></tr>
</table>
<div style='page-break-after:always;'>&nbsp;</div>
<table width="100%">
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
</table>
<table width="100%"><tr><td width="220">Nomor Izin Industri Farmasi</td><td width="10">:</td><td><?php echo $sess['NOMOR_IZIN']; ?></td></tr></table>
<table width="100%">
<tr><td width="220">Tanggal Inspeksi</td><td width="10">:</td><td><?php echo $sess['AWAL_PERIKSA']; ?> s.d <?php echo $sess['AKHIR_PERIKSA']; ?></td></tr>
</table>
<table width="100%">
<tr><td width="220">Nomor dan tanggal surat tugas </td><td width="10">:</td><td>&nbsp;</td></tr>
<tr><td colspan="3">
<?php
$jml_surat = count($petugas);
$no_surat = 1;
$curr_no = "";
for($s=0; $s<$jml_surat; $s++){
	if($petugas[$s]['TANGGAL_SURAT'] != $curr_no){
	?>
    
    <div><?php echo $no_surat.". Surat Tugas Nomor : ".$petugas[$s]['NOMOR_SURAT']; ?> tanggal <?php echo $petugas[$s]['TANGGAL_SURAT']; ?></div>
    <?php
	}
	$curr_no = $petugas[$s]['TANGGAL_SURAT'];
	$no_surat++;
}
?>
</td></tr>
</table>
<table width="100%">
<tr><td width="220">Inspektur</td><td width="10">:</td><td>&nbsp;</td></tr>
<tr><td colspan="3">
<?php
$jml_inspektur = count($petugas);
$no_petugas = 1;
for($p=0; $p<$jml_inspektur; $p++){
	?>
    <div><?php echo $no_petugas.". ".$petugas[$p]['NAMA_PETUGAS']; ?></div>
    <?php
	$no_petugas++;
}
?>
</td></tr>
</table>
<table width="100%">
<tr><td width="220">Referensi</td><td width="10">&nbsp;</td><td>&nbsp;</td></tr>
<tr><td colspan="3"><?php echo preg_replace('/[^(\x20-\x7F)]*/', "",html_entity_decode($sess['STANDARD'])); ?></td></tr>
</table>
<table width="100%">
<tr><td width="220">Pendahuluan</td><td width="10">&nbsp;</td><td>&nbsp;</td></tr>
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
<div><b>Ringkasan hasil inspeksi sebelumnya</b></div>
<div style="page-break-inside:avoid;"><?php echo preg_replace('/[^(\x20-\x7F)]*/', "",html_entity_decode($sess['RINGKASAN'])); ?></div>
<div><b>Perubahan bermakna (major) sejak inspeksi terakhir</b></div>
<div style="page-break-inside:avoid;"><?php echo preg_replace('/[^(\x20-\x7F)]*/', "",html_entity_decode($sess['PERUBAHAN_BERMAKNA'])); ?></div>
<div>1. Ruang Lingkup</div>
<div style="page-break-inside:avoid;"><?php echo preg_replace('/[^(\x20-\x7F)]*/', "",html_entity_decode($sess['RUANG_LINGKUP'])); ?></div>
<div>2. Area Inspeksi</div>
<div style="page-break-inside:avoid;"><?php echo preg_replace('/[^(\x20-\x7F)]*/', "",html_entity_decode($sess['AREA_INSPEKSI'])); ?></div>
<div style="page-break-inside:avoid;">&nbsp;</div>
<div><b>TEMUAN DAN OBSERVASI</b></div>
<div style="height:5px;">&nbsp;</div>
<div><b>OBSERVASI</b></div>
<?php if(strlen($sess['OBSERVASI']) !=""){ ?>
<div style="page-break-inside:avoid;"><?php echo preg_replace('/[^(\x20-\x7F)]*/', "",html_entity_decode($sess['OBSERVASI'])); ?></div>
<?php }else{ ?>
<div style="page-break-inside:avoid;">-</div>
<?php } ?>
<div style="height:5px;">&nbsp;</div>
<div><b>TEMUAN</b></div>
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
<div style="height:5px;">&nbsp;</div>
<div><b>Pertanyaan berkaitan dengan penilaian permohonan pendaftaran produk</b></div>
<div style="page-break-inside:avoid;"><?php echo preg_replace('/[^(\x20-\x7F)]*/', "",html_entity_decode($sess['PERMOHONAN_PENDAFTARAN_PRODUK'])); ?></div>
<div><b>Isu Spesifik lainnya : </b></div>
<div style="page-break-inside:avoid;"><?php echo preg_replace('/[^(\x20-\x7F)]*/', "",html_entity_decode($sess['ISU_SPESIFIK_LAINNYA'])); ?></div>
<div><b>Site Master File : </b></div>
<div style="page-break-inside:avoid;"><?php echo preg_replace('/[^(\x20-\x7F)]*/', "",html_entity_decode($sess['SITE_FILE_MASTER'])); ?></div>
<div><b>Lain - Lain : </b></div>
<div><b>Sampel yang diambil : </b></div>
<div style="page-break-inside:avoid;"><?php echo preg_replace('/[^(\x20-\x7F)]*/', "",html_entity_decode($sess['SAMPEL_DIAMBIL'])); ?></div>
<table width="100%">
<tr><td>Distribusi Laporan :</td></tr>
<tr><td><?php echo preg_replace('/[^(\x20-\x7F)]*/', "",html_entity_decode($sess['DISTRIBUSI_LAPORAN'])); ?></td></tr>
</table>
<table width="100%">
<tr><td>Lampiran Daftar Hadir :</td></tr>
<tr><td><?php if(trim($sess['LAMPIRAN']) != "") echo "Terlampir"; else echo "Tidak ada"; ?></td></tr>
</table>
<table width="100%">
<tr><td width="220">1. Temuan kritikal</td><td width="10">:</td><td><?php echo $sess['TEMUAN_KRITIKAL']; ?></td></tr>
<tr><td width="220">2. Temuan major</td><td width="10">:</td><td><?php echo $sess['TEMUAN_MAJOR']; ?></td></tr>
<tr><td width="220">3. Temuan minor</td><td width="10">:</td><td><?php echo $sess['TEMUAN_MINOR']; ?></td></tr>
</table>
<div style="height:5px;">&nbsp;</div>
<div><b>Rekomendasi : </b></div>
<div style="page-break-inside:avoid;"><?php echo preg_replace('/[^(\x20-\x7F)]*/', "",html_entity_decode($sess['REKOMENDASI'])); ?></div>
<div><b>Ringkasan dan Kesimpulan : </b></div>
<div style="page-break-inside:avoid;"><?php echo preg_replace('/[^(\x20-\x7F)]*/', "",html_entity_decode($sess['KESIMPULAN'])); ?></div>

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