<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR); ?>
<style>
body {font-family:font-family: 'Times New Roman'; font-size:9pt; line-height:20px;}
@page {margin-top:0.5cm; margin-bottom: 1.5cm; margin-left: 1cm; margin-right: 1cm;}
table.form_tabel td{vertical-align:top; text-align:justify; padding:2px; font-size:8pt;}
table.form_tabel td.kotak{border-bottom:1px solid #505968;}
table.form_tabel td.bold{font-weight:bold; width:225px; vertical-align:top; font-size:9pt;}
table.form_tabel td.garis{vertical-align:top; border-bottom:1px solid #505968;padding-left:10px; padding-bottom:2px;}
table.form_tabel td.garisatas{vertical-align:top; border-top:1px solid #505968;padding-left:10px; padding-bottom:2px;}
.hideme{display:none;}
.kolom{width:300px; display:block; display:block;}
.kolom .kiri{float: left; width:53px; padding:5px; border-right:1px solid #000;}
.kolom .kanan{float: right; width:218px; text-align:center; margin-right:5px;}
</style>
<?php 
$jml = count($sess);
$z = 0;
for($i=0; $i<$jml; $i++){
	?>
    <table class="form_tabel" width="100%">
    <tr><td width="15%">Kode Sampel</td><td class="kotak" colspan="3"><b><?php echo $sess[$i]['KODE_SAMPEL']; ?></b></td></tr>    
    <tr>
      <td width="15%">Komoditi</td><td class="kotak" width="35%"><?php echo $sess[$i]['KLASIFIKASI']; ?></td><td width="15%">Identitas Tambahan</td><td class="kotak" width="35%"><?php echo trim($sess[$i]['KLASIFIKASI_TAMBAHAN']) != "" ? $sess[$i]['KLASIFIKASI_TAMBAHAN'] : '-'; ?></td></tr>    
    <tr>
      <td>Kategori</td><td class="kotak"><?php echo $sess[$i]['SUB_KLASIFIKASI']; ?></td>
      <td>Sub Kategori</td><td class="kotak"><?php echo $sess[$i]['SUB_SUB_KLASIFIKASI']; ?></td></tr>
    <tr><td>Nama Sampel</td><td class="kotak"><?php echo $sess[$i]['NAMA_SAMPEL']; ?></td><td>Pabrik</td><td class="kotak"><?php echo $sess[$i]['IMPORTIR']; ?></td></tr>    
    <tr><td>Importir</td><td class="kotak"><?php echo $sess[$i]['PABRIK']; ?></td><td>Bentuk Sediaan</td><td class="kotak"><?php echo $sess[$i]['BENTUK_SEDIAAN']; ?></td></tr>
    <tr><td>Kemasan</td><td class="kotak"><?php echo $sess[$i]['KEMASAN']; ?></td><td>No. Bets</td><td class="kotak"><?php echo $sess[$i]['NO_BETS']; ?></td></tr>
    <tr><td>Keterangan ED</td><td class="kotak"><?php echo $sess[$i]['KETERANGAN_ED']; ?></td><td>Netto</td><td class="kotak"><?php echo $sess[$i]['NETTO']; ?></td></tr>
    <tr><td>Evaluasi Penandaan</td><td class="kotak"><?php echo $sess[$i]['EVALUASI_PENANDAAN']; ?></td><td>Cara Penyimpanan</td><td class="kotak"><?php echo $sess[$i]['CARA_PENYIMPANAN']; ?></td></tr>
    <tr><td>Jumlah Sampel</td><td class="kotak"><?php echo $sess[$i]['JUMLAH_SAMPEL']; ?>&nbsp;<?php echo $sess[$i]['SATUAN']; ?></td><td>Kondisi Sampel</td><td class="kotak"><?php echo $sess[$i]['KONDISI_SAMPEL']; ?></td></tr>
    <tr><td>Pengujian</td><td class="kotak">
    <div><span style="float:left;"><input type="checkbox" <?php echo $sess[$i]['UJI_KIMIA'] > 0 ? 'checked="checked"' : ''; ?> />&nbsp;Kimia</span>&nbsp;<span style="float:right; margin-right:2px;"><input type="text" style="width:20px; text-align:center;" value="<?php echo $sess[$i]['JUMLAH_KIMIA']; ?>"/></span></div>
    <div><span style="float:left;"><input type="checkbox" <?php echo $sess[$i]['UJI_MIKRO'] > 0 ? 'checked="checked"' : ''; ?> />&nbsp;Mikro</span>&nbsp;<span style="float:right; margin-right:2px;"><input type="text" style="width:20px; text-align:center;" value="<?php echo $sess[$i]['JUMLAH_MIKRO']; ?>"/></span></div>
    </td><td>Sisa Sampel</td><td class="kotak"><?php echo $sess[$i]['SISA']; ?></td></tr>

    <tr><td>Komposisi</td><td class="kotak"><?php echo $sess[$i]['KOMPOSISI']; ?></td><td>Catatan</td><td class="kotak"><?php echo $sess[$i]['CATATAN']; ?></td></tr>
    </table>
    <div style="height:5px;">&nbsp;</div>
    <?php
	if((($z+1) % 2) == 0) {
        ?>
        <pagebreak />
        <?php
    }
	$z++;
}
?>
<?php 
$total = count($label['kode']);
if($total > 0){
?>
<pagebreak />
<div><h4>LABEL KODE SAMPEL</h4></div>
<div>&nbsp;</div>
<table width="100%">
<?php
$y = 0;
for($x=0; $x<$total; $x++){
	$y++;
	if((($y+1) % 2) == 0) {
        echo "</tr><tr>";
    }
	echo '<td><table width="350" cellpadding="0" cellspacing="0"><tr><td rowspan="2" width="60" height="60" style="border-left:1px solid #000;border-top:1px solid #000;border-bottom:1px solid #000;"><img src="'.base_url().'/images/bpom_small.png" align="absmiddle" /></td><td style="border-left:1px solid #000;border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000; text-align:center;">'.$label['kode'][$x].'</td></tr><tr><td style="border-left:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000; text-align:center;">'.$label['balai'].'</td></tr></table></td>';
}
?>
</table>
<?php 
}
?>