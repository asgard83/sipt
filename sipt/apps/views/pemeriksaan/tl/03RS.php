<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);
?>
<table class="form_tabel">
	<tr><td class="td_left">Perihal</td><td class="td_right"><?php echo form_dropdown('TL[PERIHAL]',$perihal,$sess_['PERIHAL'],'class="stext" id="perihal" rel="required" title="Perihal Surat"'); ?></td></tr>
    <tr id="awal" <?php if($sess_['PERIHAL'] == "1103" || $sess_['PERIHAL'] == "1104") echo 'style=""'; else echo 'style="display:none;"'; ?>><td class="td_left">Awal penghentian</td><td class="td_right"><input name="TL[AWAL_PSK]" type="text" class="stext" value="<?php echo $sess_['AWAL_PSK']; ?>" title="Awal Penghentian Kegiatan Sarana" /></td></tr>
    <tr id="selesai" <?php if($sess_['PERIHAL'] == "1103" || $sess_['PERIHAL'] == "1104") echo 'style=""'; else echo 'style="display:none;"'; ?>><td class="td_left">Akhir penghentian</td><td class="td_right"><input name="TL[AKHIR_PSK]" type="text" class="stext" value="<?php echo $sess_['AKHIR_PSK']; ?>" title="Akhir Penghentian Kegiatan Sarana" /></td></tr>
    <tr id="bbpom" <?php if($sess_['PERIHAL'] == "1103" || $sess_['PERIHAL'] == "1104") echo 'style=""'; else echo 'style="display:none;"'; ?>><td class="td_left">Penghentian di lakukan oleh</td><td class="td_right"><?php echo form_dropdown('TL[BBPOM_ID]',$bbpom,$sess_['BBPOM_ID'],'class="stext" title="Balai Besar / Balai POM yang melakukan Penghentian Kegiatan Sarana"'); ?></td></tr>
    <tr id="sanksi" <?php if($sess_['PERIHAL'] == "1107") echo 'style=""'; else echo 'style="display:none;"'; ?>><td class="td_left">Sanksi administratif berupa</td><td class="td_right"><input type="text" class="stext" name="TL[TINDAKAN]" value="<?php echo $sess_['TINDAKAN'];?>" title="Sanksi administratif yang di berikan" /></td></tr>
    <tr id="pihak" <?php if($sess_['PERIHAL'] == "1107") echo 'style=""'; else echo 'style="display:none;"'; ?>><td class="td_left">Pihak yang disarankan</td><td class="td_right"><input type="text" class="stext" name="TL[PIHAK]" value="<?php echo $sess_['PIHAK'];?>" title="Pihak yang disarankan" /></td></tr> 
</table>

<script type="text/javascript">
$(document).ready(function(){
	$("#perihal").change(function(){
		var val = $(this).val();
		if(val == "1103" || val == "1104"){
			$("#awal, #selesai, #bbpom").show();
			$("#sanksi, #pihak").hide();
		}else if(val == "1106"){
			$("#sanksi, #pihak").show();
			$("#awal, #selesai, #bbpom").hide();
		}else{
			$("#awal, #selesai, #bbpom, #sanksi, #pihak").hide();
		}
		return false;
	});
});
</script>