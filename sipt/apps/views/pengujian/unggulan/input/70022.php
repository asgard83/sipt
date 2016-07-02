<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR); ?>
<tr>
	<td class="td_left">Tanggal Terima Sampel</td>
	<td class="td_right"><b><?php echo $sess[0]['TANGGAL_TERIMA']; ?></b></td>
</tr>
<tr>
	<td class="td_left">Nomor Surat Permintaan Uji</td>
	<td class="td_right"><b><?php echo $sess[0]['SPU']; ?></b></td>
</tr>
<tr>
	<td class="td_left">Tanggal Surat Perintah Uji</td>
	<td class="td_right"><input type="text" class="sdate" title="Tanggal Surat Perintah Uji" rel="required" name="PERINTAH_UJI[TANGGAL_PERINTAH]" />
	 <input type="hidden" name="SPU_ID" value="<?php echo $sess[0]['SPU_ID']; ?>" />
     <input type="hidden" name="KLASIFIKASI" value="<?php echo $sess[0]['KLASIFIKASI']; ?>" />
	 <input type="hidden" name="chkjml" value="<?php echo $jmlinput; ?>" />
	</td>
</tr>
<tr>
  <td class="td_left">Ditujukan Kepada</td>
  <td class="td_right" colspan="4"><?php echo form_dropdown('USER_ID[]',$mt,'','multiple="multiple" style="height:80px;" class="text" rel="required" title="Manager Teknis" id="mt"'); ?></td>
</tr>
<script type="text/javascript">
$(document).ready(function(){
	$('input.sdate').datepicker({ dateFormat: 'dd/mm/yy',regional: 'id'});
});
</script>           