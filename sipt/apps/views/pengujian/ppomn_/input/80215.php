<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR); 
$arrhasil = array("MS","HPST");
?>
<link type="text/css" href="<?php echo base_url();?>css/css.css" rel="stylesheet" />
<h2 class="small garis">Tindak Lanjut Sampling</h2>
<table class="form_tabel">
  <tr>
    <td class="td_left">Tindak lanjut terhadap hasil sampling</td>
    <td class="td_right"><?php
	if(in_array(trim($row[0]['HASIL_SAMPEL']), $arrhasil)){
		echo "<b>Sampel di arsipkan, dan ditembuskan ke Insert dan Ditwas</b>";
	}else{
		echo form_dropdown('TINDAK_LANJUT_PPOMN', $tindak_lanjut_ppomn, '', 'class="stext" title="Piilh tindak lanjut hasil pengujian"rel="required"');
	}
	?></td>
  </tr>
  <?php 
  if(!in_array(trim($row[0]['HASIL_SAMPEL']), $arrhasil)){
	  ?>
  <tr>
    <td class="td_left">Tindak lanjut terhadap hasil sampling</td>
    <td class="td_right">
    <textarea name="CATATAN" class="stext catatan" title="Catatan verifikasi tindak lanjut hasil sampling" rel="required"></textarea>
    </td>
  </tr>
  <?php
  }
  ?>
</table>
