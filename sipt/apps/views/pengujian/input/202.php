<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR); 
$arrhasil = array("MS","HPST");
?>
<link type="text/css" href="<?php echo base_url();?>css/css.css" rel="stylesheet" />
<tr>
  <td class="td_left">Tindak lanjut terhadap hasil sampling</td>
  <td class="td_right"><?php
	if(in_array(trim($row[0]['HASIL_SAMPEL']), $arrhasil)){
		?>
        <div style="padding-bottom:5px;">Hasil Pengujian Sampel : <b><?php echo $row[0]['HASIL_SAMPEL']; ?></b></div>
        <div style="padding-bottom:5px;">Sampel diarsipkan di PPOMN dan Ditembuskan ke Insert atau Ditwas Terkait</div>
        <?php
	}else{
		echo form_dropdown('TINDAK_LANJUT', $tindak_lanjut, '', 'class="stext" title="Piilh tindak lanjut hasil pengujian"rel="required" style="width:500px;"');
	}
	?></td>
</tr>
