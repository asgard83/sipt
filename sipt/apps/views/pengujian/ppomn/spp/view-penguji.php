<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR); ?>
<form name="fedit-mt" id="fedit-penguji" method="post" action="<?php echo site_url(); ?>/post/spp/spp_act/update-penguji" autocomplete="off">
	<input type="hidden" name="SPK_ID" value="<?php echo $sess['SPK_ID']; ?>" />
	<input type="hidden" name="UJI_ID" value="<?php echo $sess['UJI_ID']; ?>" />
	<table class="form_tabel">
		<tr>
			<td class="td_left">Nomor SPP</td>
			<td class="td_right"><?php echo $sess['UR_SPP']; ?></td>
		</tr>
		<tr>
			<td class="td_left">Parameter Uji</td>
			<td class="td_right"><?php echo $sess['PARAMETER_UJI']; ?></td>
		</tr>
		<tr>
			<td class="td_left">Metode</td>
			<td class="td_right"><?php echo $sess['METODE']; ?></td>
		</tr>
		<tr>
			<td class="td_left">Pustaka</td>
			<td class="td_right"><?php echo $sess['PUSTAKA']; ?></td>
		</tr>
		<tr>
			<td class="td_left">Hasil Kuantitatif</td>
			<td class="td_right"><?php echo $sess['HASIL']; ?></td>
		</tr>
		<tr>
			<td class="td_left">Hasil Kualitatif</td>
			<td class="td_right"><?php echo $sess['HASIL_KUALITATIF']; ?></td>
		</tr>
		<tr>
			<td class="td_left">Hasil Parameter</td>
			<td class="td_right"><?php echo $sess['HASIL_PARAMETER']; ?></td>
		</tr>
		<tr>
			<td class="td_left">LCP</td>
			<td class="td_right"><?php echo trim($sess['LCP']) == "" ? "Tidak / belum melampirkan LCP" : "LCP Terlampir dalam aplikasi"?></td>
		</tr>
		<tr>
			<td class="td_left">Nama Penguji</td>
			<td class="td_right"><?php echo form_dropdown('PENGUJI',$arrpenguji,$sess['PENGUJI'],'class="stext" title="Daftar nama penguji" id="penguji"'); ?></td>
		</tr>
	</table>
	<div style="height:10px;">&nbsp;</div>
	<div style="padding-left:5px;"><a href="#" class="button save" onclick="save_edit('#fedit-penguji'); return false;"><span><span class="icon"></span>&nbsp; Update &nbsp;</span></a></div>
	<div style="padding:5px;">&nbsp;</div>
</form>
<script type="text/javascript">
function save_edit(formid){
	var jumlah = 0; 
	$(':input[rel=required]:not(:image, submit, button)', formid).each(function(){
		if($(this).val() == "" || $(this).val() == null){ 
			$(this).css('background-color','#FBE3E4'); 
			$(this).css('border','1px solid #F00'); 
			jumlah++;
		}
	}); 
	if(jumlah>0){
		jAlert('Maaf, ada ' + jumlah + ' kolom yang harus diisi', 'SIPT Versi 1.0');
		return false;
	}else{
		$.ajax({
			type: "POST", 
			url: $(formid).attr('action') + '/ajax', 
			data: $(formid).serialize(),
			error: function(){ 
				jAlert('Maaf, Request halaman tidak ditemukan', 'SIPT Versi 1.0'); 
			}, 
			beforeSend: function(){
				jLoadingOpen('','SIPT Versi 1.0');
			}, 
			complete: function(){ 
				jLoadingClose();
			},
			success: function(data){
				if(data.search("MSG")>=0){
					arrdata = data.split('#');
					if(arrdata[1]=="YES"){
						jAlert(arrdata[2],'SIPT Versi 1.0');
						if(arrdata.length>3){
							setTimeout(function(){location.reload(true);}, 1000);
							return false;
						}
					}else{
						jAlert(arrdata[2],'SIPT Versi 1.0');
					}
				}else{
					jAlert(arrdata[2],'SIPT Versi 1.0');
				}
				return false;  
			} 
		}); 
	} 
	return false;
}
</script> 