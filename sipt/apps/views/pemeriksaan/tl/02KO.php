<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);
?>
<input type="hidden" name="TL[BBPOM_ID]" value="<?php echo $this->newsession->userdata('SESS_BBPOM_ID'); ?>" />
<table class="form_tabel">
	<tr><td class="td_left">Perihal</td><td class="td_right"><?php echo form_dropdown('TL[PERIHAL]',$perihal,$sess_['PERIHAL'],'class="stext" rel="required" title="Perihal Surat" id="perihal"'); ?></td></tr>
    <tr id="point" <?php if($sess_['PERIHAL'] == "F03") echo 'style=""'; else echo 'style="display:none;"'; ?>><td class="td_left">Berdasarkan</td><td class="td_right"><textarea class="stext chk" name="TL[POINT]" id="POINT"><?php echo $sess_['PELANGGARAN']; ?></textarea></td></tr>
    <tr id="pemberitahuan" <?php if($sess_['PERIHAL'] == "F03") echo 'style=""'; else echo 'style="display:none;"'; ?>><td class="td_left">Diberitahukan bahwa</td><td class="td_right"><textarea class="stext chk" name="TL[PELANGGARAN]" id="PELANGGARAN"><?php echo $sess_['PELANGGARAN']; ?></textarea></td></tr>
    <tr id="sanksi" <?php if($sess_['PERIHAL'] == "F03") echo 'style=""'; else echo 'style="display:none;"'; ?>><td class="td_left">Sanksi pada fasilitas produksi berupa</td><td class="td_right"><input type="text" class="stext" name="TL[TINDAKAN]" value="<?php echo $sess_['TINDAKAN']; ?>" title="Sanksi pada fasilitas produksi" /></td></tr>
    <tr id="lama" <?php if($sess_['PERIHAL'] == "F03") echo 'style=""'; else echo 'style="display:none;"'; ?>><td class="td_left">Lama sanksi</td><td class="td_right"><input type="text" class="stext" name="TL[AWAL_PSK]" value="<?php echo $sess_['AWAL_PSK']; ?>" title="Lamanya sanksi yang diberikan" /></td></tr>
    <tr id="permintaan" <?php if($sess_['PERIHAL'] == "F03") echo 'style=""'; else echo 'style="display:none;"'; ?>><td class="td_left">Permintaan terhadap sarana selama sanksi</td><td class="td_right"><textarea class="stext chk" id="KETERANGAN" name="TL[KETERANGAN]"><?php echo $sess_['KETERANGAN']; ?></textarea></td></tr>
    <tr id="bbpom" <?php if($sess_['PERIHAL'] == "F03") echo 'style=""'; else echo 'style="display:none;"'; ?>><td class="td_left">Penghentian di lakukan oleh</td><td class="td_right"><?php echo form_dropdown('TL[BBPOM_ID]',$bbpom,$sess_['BBPOM_ID'],'class="stext" title="Balai Besar / Balai POM yang melakukan Penghentian Kegiatan Sarana"'); ?></td></tr>
</table>
<script type="text/javascript">
$(document).ready(function(){
	$("#perihal").change(function(){
		var val = $(this).val();
		if(val == "F02"){
			$("#pemberitahuan, #sanksi, #lama, #permintaan, #bbpom").hide();
		}else if(val == "F03"){
			$("#pemberitahuan, #sanksi, #lama, #permintaan, #bbpom").show();
		}
		return false;
	});
});
</script>