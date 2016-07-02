<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR); ?>
<style>
@page{size:landscape}
div{font-size:8pt;}
table.form_tabel td{vertical-align:top; text-align:justify; padding:2px; font-size:8pt;}
table.form_tabel th{vertical-align:top; text-align:justify; padding:2px; font-size:8pt;}
table.form_tabel td.kotak{border-bottom:1px solid #505968;}
table.form_tabel td.bold{font-weight:bold; width:225px; vertical-align:top; font-size:9pt;}
table.form_tabel td.garis{vertical-align:top; border-bottom:1px solid #505968;padding-left:10px; padding-bottom:2px;}
table.form_tabel td.garisatas{vertical-align:top; border-top:1px solid #505968;padding-left:10px; padding-bottom:2px;}
.hideme{display:none;}
.kolom{width:300px; display:block; display:block;}
.kolom .kiri{float: left; width:53px; padding:5px; border-right:1px solid #000;}
.kolom .kanan{float: right; width:218px; text-align:center; margin-right:5px;}
</style>
<div>Bersama ini disampaikan daftar sampel : </div>
<div style="height:5px;">&nbsp;</div>
<table class="form_tabel">
	<tr><td>Komoditi</td><td>:</td><td><?php echo $sess[0]['KLASIFIKASI']; ?></td></tr>
	<tr><td>Anggaran</td><td>:</td><td><?php echo $sess[0]['ANGGARAN']; ?></td></tr>
	<tr><td>Asal Sampling</td><td>:</td><td><?php echo $sess[0]['ASAL_SAMPLING']; ?></td></tr>
	<tr><td>Bulan</td><td>:</td><td><?php echo $sess[0]['BULAN']; ?>&nbsp;<?php echo $sess[0]['TAHUN']; ?></td></tr>
</table>
<div style="height:5px;">&nbsp;</div>
<div>Untuk dilakukan pengujian sesuai ruang lingkup</div>
<div style="height:5px;">&nbsp;</div>
<table class="form_tabel" width="100%">
	<tr><th>No</th><th>Kode Sampel</th><th>Nama Sampel</th><th>Keterangan ED</th><th>Komposisi</th><th>Tempat dan Tanggal Sampling<th>Jumlah Sampel</th><th>Kimia</th><th>Mikro</th><th>Sisa</th><th>Judul</th><th>Catatan</th></tr>
   <?php 
   $jml = count($sess);
   $z = 0;
   $no = 1;
   if($jml > 0){
	   for($i=0; $i<$jml; $i++){
		   ?>
		   <tr>
				<td><?php echo $no; ?></td>
                <td><?php echo $sess[$i]['KODE_SAMPEL']; ?></td>
				<td>
				<?php echo $sess[$i]['NAMA_SAMPEL']; ?>
				<div>&bull; <?php echo $sess[$i]['NOMOR_REGISTRASI']; ?></div>
				<div>&bull; <?php echo $sess[$i]['BENTUK_SEDIAAN']; ?></div>
				<div>&bull; <?php echo $sess[$i]['NOMOR_REGISTRASI']; ?></div>
				<div>&bull; <?php echo trim($sess[$i]['SUB_KLASIFIKASI']) != "" ? $sess[$i]['SUB_KLASIFIKASI'] : '-'; ?></div>
				<div>&bull; <?php echo trim($sess[$i]['SUB_SUB_KLASIFIKASI']) != "" ? $sess[$i]['SUB_SUB_KLASIFIKASI'] : '-'; ?></div>
				<div>&bull; <?php echo trim($sess[$i]['IMPORTIR']) != "" ? $sess[$i]['IMPORTIR'] : '-'; ?></div>
				<div>&bull; <?php echo trim($sess[$i]['PABRIK']) != "" ? $sess[$i]['PABRIK'] : '-'; ?></div>
				</td>
				<td>
				<?php echo $sess[$i]['KETERANGAN_ED']; ?>
                <div><?php echo $sess[$i]['NO_BETS']; ?></div>
                <div><?php echo $sess[$i]['NETTO']; ?></div>
                </td>
				<td><?php echo str_replace(";","<br>",$sess[$i]['KOMPOSISI']); ?></td>
				<td>
                <?php echo $sess[$i]['TEMPAT SAMPLING']; ?>
                <div><?php echo $sess[$i]['TANGGAL SAMPLING']; ?></div>
                </td>
				<td> <?php echo $sess[$i]['JUMLAH_SAMPEL']; ?></td>
				<td><?php echo $sess[$i]['JUMLAH_KIMIA']; ?></td>
				<td><?php echo $sess[$i]['JUMLAH_MIKRO']; ?></td>
				<td><?php echo $sess[$i]['SISA']; ?></td>
				<td>
				<?php echo $sess[$i]['EVALUASI_PENANDAAN']; ?>
				<div><?php echo $sess[$i]['CARA_PENYIMPANAN']; ?></div>
				<div><?php echo $sess[$i]['KONDISI_SAMPEL']; ?></div>
				<div><?php echo trim($sess[$i]['KLASIFIKASI_TAMBAHAN']) != "" ? $sess[$i]['KLASIFIKASI_TAMBAHAN'] : '-'; ?></div>
				</td>
				<td><?php echo trim($sess[$i]['CATATAN']) != "" ? $sess[$i]['CATATAN'] : '-'; ?></td></tr>
		   <?php
		   $no++;
	   }
   }else{
	   ?>
       <tr><td colspan="11">Data Tidak Ditemukan</td></tr>
       <?php
   }
   ?>
</table>
