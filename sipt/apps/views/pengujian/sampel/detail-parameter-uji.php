<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR);?>
<link type="text/css" href="<?php echo base_url();?>css/css.css" rel="stylesheet" />
<form id="fupdate-uji-hasil" action="<?php echo $act; ?>"	autocomplete="off" name="fupdate-uji-hasil" method="post">
  <table class="listtemuan" width="100%">
    <tr style="background:#e7e7e7;">
      <td width="300"><b>Parameter Uji</b></td>
      <td width="100"><b>Metode</b></td>
      <td width="350"><b>Pustaka</b></td>
      <td width="100"><b>Syarat</b></td>
    </tr>
    <tr>
      <td><?php echo $sess['PARAMETER_UJI']; ?></td>
      <td><?php echo $sess['METODE']; ?></td>
      <td><?php echo $sess['PUSTAKA']; ?></td>
      <td><?php echo $sess['SYARAT']; ?></td>
    </tr>
  </table>
  <div style="height:5px;">&nbsp;</div>
  <table class="form_tabel">
    <tr>
      <td class="td_left">Mulai Diuji </td>
      <td class="td_right"><input type="text" name="UJI[AWAL_UJI"] value="<?php echo $sess['AWAL_UJI']; ?>" class="sdate" /></td>
      <td></td>
      <td class="td_left">Selesai Diuji</td>
      <td class="td_right"><input type="text" name="UJI[AKHIR_UJI]" value="<?php echo $sess['AKHIR_UJI']; ?>" class="sdate" /></td>
    </tr>
    <tr>
      <td class="td_left">Hasil Kualitatif</td>
      <td class="td_right"><textarea class="stext" name="UJI[HASIL]"><?php echo $sess['HASIL']; ?></textarea></td>
      <td></td>
      <td class="td_left">Hasil Kuantitatif</td>
      <td class="td_right"><textarea class="stext" name="UJI[HASIL_KUALITATIF]"><?php echo $sess['HASIL_KUALITATIF']; ?></textarea></td>
    </tr>
    <tr>
      <td class="td_left">Hasil Parameter</td>
      <td class="td_right"><?= form_dropdown('UJI[HASIL_PARAMETER]',$hasil_parameter, $sess['HASIL_PARAMETER'],'class="stext" title="Hasil Parameter" rel="required" style="width:150px;"'); ?></td>
      <td></td>
      <td class="td_left">LCP</td>
      <td class="td_right"><?php
		if(strlen(trim($sess['LCP'])) > 0){
			?>
        <a href="<?php echo base_url().'files/LCP/'.$sess['KODE_SAMPEL'].'/'.$sess['LCP']; ?>" target="_blank">LCP</a>
        <?php
		}else{
			?>
        Tidak melampirkan LCP
        <?php
		}
		?></td>
    </tr>
  </table>
  <div style="height:10px;">&nbsp;</div>
  <input type="checkbox" id="chk-hasil" />
  &nbsp;Dengan ini menyatakan setuju untuk mengubah hasil parameter dan semua data perubahan ini akan tercatat dalam aplikasi.
  <input type="hidden" name="UJI_ID" value="<?php echo $sess['UJI_ID']; ?>" readonly="readonly">
  <input type="hidden" name="KODE_SAMPEL" value="<?php echo $sess['KODE_SAMPEL']; ?>" readonly="readonly">
</form>
<div style="padding:5px;">&nbsp;</div>
<div style="padding-left:5px;"> <a href="#" class="button save" onclick="save_hasil('#fupdate-uji-hasil'); return false;"><span><span class="icon"></span>&nbsp; Proses&nbsp;</span></a> </div>
<div style="padding:2px;">&nbsp;</div>
<script>
$(document).ready(function(e) {
	$("table.form_tabel tr:even").css("background-color", "#f0f0f0");
	$("table.form_tabel tr:odd").css("background-color", "#fff");
	$('input.sdate').datepicker({ dateFormat: 'dd/mm/yy',regional: 'id'});
});
</script>