<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);
?>
<input type="hidden" name="TL[BBPOM_ID]" value="<?php echo $this->newsession->userdata('SESS_BBPOM_ID'); ?>" />
<table class="form_tabel">
	<tr><td class="td_left">Perihal</td><td class="td_right"><?php echo form_dropdown('TL[PERIHAL]',$perihal,$sess_['PERIHAL'],'class="stext" rel="required" title="Perihal Surat" id="perihal"'); ?></td></tr>
    <tr id="point" <?php if($sess_['PERIHAL'] == "2103" || $sess_['PERIHAL'] == "2105" || $sess_['PERIHAL'] == "2106") echo 'style=""'; else echo 'style="display:none;"'; ?>><td class="td_left">Berdasarkan</td><td class="td_right"><textarea class="stext chk" name="TL[POINT]" id="POINT"><?php echo $sess_['PELANGGARAN']; ?></textarea></td></tr>
    <tr id="pemberitahuan" <?php if($sess_['PERIHAL'] == "2103"  || $sess_['PERIHAL'] == "2105" || $sess_['PERIHAL'] == "2106" || $sess_['PERIHAL'] == "2109") echo 'style=""'; else echo 'style="display:none;"'; ?>><td class="td_left">Diberitahukan bahwa</td><td class="td_right"><textarea class="stext chk" name="TL[PELANGGARAN]" id="PELANGGARAN"><?php echo $sess_['PELANGGARAN']; ?></textarea></td></tr>
    <tr id="nosertifikat" <?php if($sess_['PERIHAL'] == "2106") echo 'style=""'; else echo 'style="display:none;"'; ?>><td class="td_left">No. Serifikat</td><td class="td_right"><input type="text" class="stext" name="TL[NOSERTIFIKAT]" value="<?php echo $sess_['NOSERTIFIKAT']; ?>" title="Nomor Sertifikat" /></td></tr>
    <tr id="tgsertifikat" <?php if($sess_['PERIHAL'] == "2106") echo 'style=""'; else echo 'style="display:none;"'; ?>><td class="td_left">Tanggal</td><td class="td_right"><input type="text" class="stext" name="TL[TGSERTIFIKAT]" value="<?php echo $sess_['TGSERTIFIKAT']; ?>" title="Tanggal Sertifikat" /></td></tr>
    <tr id="sanksi" <?php if($sess_['PERIHAL'] == "2103" || $sess_['PERIHAL'] == "2105") echo 'style=""'; else echo 'style="display:none;"'; ?>><td class="td_left" id="lblsanksi">
    <?php 
	if($sess_['PERIHAL'] == "2103"){?>Sanksi pada fasilitas produksi berupa<?php
	}else if($sess_['PERIHAL'] == "2105"){?> Sanksi pada fasilitas produksi sediaan<?php
	}else if($sess_['PERIHAL'] == "2106"){?> Bentuk sediaan<?php
	}
	?></td><td class="td_right"><input type="text" class="stext" name="TL[TINDAKAN]" value="<?php echo $sess_['TINDAKAN']; ?>" title="Sanksi pada fasilitas produksi" /></td></tr>
    <tr id="lama" <?php if($sess_['PERIHAL'] == "2103") echo 'style=""'; else echo 'style="display:none;"'; ?>><td class="td_left">Lama sanksi</td><td class="td_right"><input type="text" class="stext" name="TL[AWAL_PSK]" value="<?php echo $sess_['AWAL_PSK']; ?>" title="Lamanya sanksi yang diberikan" /></td></tr>
    <tr id="permintaan" <?php if($sess_['PERIHAL'] == "2103"|| $sess_['PERIHAL'] == "2109") echo 'style=""'; else echo 'style="display:none;"'; ?>><td class="td_left">Permintaan terhadap sarana selama sanksi</td><td class="td_right"><textarea class="stext chk" id="KETERANGAN" name="TL[KETERANGAN]"><?php echo $sess_['KETERANGAN']; ?></textarea></td></tr>
    <tr id="bbpom" <?php if($sess_['PERIHAL'] == "2103" || $sess_['PERIHAL'] == "2101" || $sess_['PERIHAL'] == "2104") echo 'style=""'; else echo 'style="display:none;"'; ?>><td class="td_left" id="lblbbpom">
    <?php 
	if($sess_['PERIHAL'] == "2101" || $sess_['PERIHAL'] == "2104"){?>Balai Tembusan<?php
	}else if($sess_['PERIHAL'] == "2103"){?> Penghentian di lakukan oleh<?php
	}
	?>
    </td><td class="td_right"><?php echo form_dropdown('TL[BBPOM_ID]',$bbpom,$sess_['BBPOM_ID'],'class="stext" title="Balai Besar / Balai POM"'); ?></td></tr>
</table>
<script type="text/javascript">
$(document).ready(function(){
	$("#perihal").change(function(){
		var val = $(this).val();
		if(val == "2101" || val == "2104"){
			$("#point, #pemberitahuan, #sanksi, #lama, #permintaan, #tgsertifikat, #nosertifikat").hide();
			$("#bbpom").show();
			$("#lblbbpom").html('Balai Tembusan');
		}else if(val == "2102" || val == "2112"){
			$("#pemberitahuan, #sanksi, #lama, #permintaan, #bbpom, #tgsertifikat, #nosertifikat").hide();
		}else if(val == "2103"){
			$("#pemberitahuan, #sanksi, #lama, #permintaan, #bbpom").show();
			$("#tgsertifikat, #nosertifikat").hide();
			$("#lblbbpom").html('Penghentian dilakukan oleh');
			$("#lblsanksi").html('Sanksi pada fasilitas produksi berupa');
		}else if(val == "2105"){
			$("#pemberitahuan, #sanksi, #permintaan").show();
			$("#lama, #bbpom").hide();
			$("#lblsanksi").html('Sanksi pada fasilitas produksi sediaan');
		}else if(val == "2106"){
			$("#pemberitahuan, #sanksi, #tgsertifikat, #nosertifikat").show();
			$("#lama, #bbpom, #permintaan").hide();
			$("#lblsanksi").html('Untuk bentuk sediaan');
		}else if(val == "2107" || val == "2108"){
			$("#point, #pemberitahuan, #sanksi, #lama, #permintaan, #tgsertifikat, #nosertifikat, #bbpom").hide();
		}else if(val == "2109"){
			$("#pemberitahuan, #permintaan").show();
			$("#sanksi, #lama, #bbpom, #tgsertifikat, #nosertifikat").hide();
		}else if(val == ""){
			$("#pemberitahuan, #sanksi, #lama, #permintaan, #bbpom, #tgsertifikat, #nosertifikat").hide();
			$("#lblbbpom").html('Balai Tembusan');
		}
		return false;
	});
});
</script>