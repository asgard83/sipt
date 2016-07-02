<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR); ?>
<form name="fedit-kategori" id="fedit-kategori" method="post" action="<?php echo $act; ?>" autocomplete="off">
	<input type="hidden" name="kode_sampel" value="<?php echo $sess['KODE_SAMPEL']; ?>" />
	<table class="form_tabel">
		<tr>
			<td class="td_left">Komoditi</td>
			<td class="td_right"><?php echo $sess['KOMODITI']; ?></td>
			<td width="10"></td>
			<td class="td_left">&nbsp;</td>
			<td class="td_right">&nbsp;</td>
		</tr>
		<tr id="tdanak2" ke="2">
			<td class="td_left">Kategori sampel</td>
			<td class="td_right"><?php echo form_dropdown('KOMODITI[]',is_array($selkategori[0]) ? $selkategori[0] : '',$sel[0],'class="stext komoditi" title="Sub Komoditi atau Sub Kategori sampel" id="sel2" ke="2" rel="required"'); ?></td>
			<td width="10"></td>
			<td class="td_left">&nbsp;</td>
			<td class="td_right">&nbsp;</td>
		</tr>
		 <tr <?php echo (strlen($sel[1]) == 6 || strlen($sel[1]) == 7 ) ? '' : 'class="hideme"'; ?> id="tdanak3" ke="3">
			<td class="td_left">&nbsp;</td>
			<td class="td_right"><?php echo form_dropdown('KOMODITI[]',is_array($selkategori[1]) ? $selkategori[1] : '',$sel[1],'class="stext komoditi" title="Sub Sub Komoditi atau Sub Sub Kategori sampel" id="sel3" ke="3"'); ?></td>
			<td></td>
			<td class="td_left">&nbsp;</td>
			<td class="td_right">&nbsp;</td>
		</tr>
		<tr <?php echo (strlen($sel[2]) == 8 || strlen($sel[2]) == 9) ? '' : 'class="hideme"'; ?> id="tdanak4" ke="4">
			<td class="td_left">&nbsp;</td>
			<td class="td_right"><?php echo form_dropdown('KOMODITI[]',is_array($selkategori[2]) ? $selkategori[2] : '',$sel[2],'class="stext komoditi" title="Sub Sub Komoditi atau Sub Sub Kategori sampel" id="sel4" ke="4"'); ?></td>
			<td></td>
			<td class="td_left">&nbsp;</td>
			<td class="td_right">&nbsp;</td>
		</tr>
		<tr <?php echo (strlen($sel[3]) == 10 || strlen($sel[3]) == 11)? '' : 'class="hideme"'; ?> id="tdanak5" ke="5">
			<td class="td_left">&nbsp;</td>
			<td class="td_right"><?php echo form_dropdown('KOMODITI[]',is_array($selkategori[3]) ? $selkategori[3] : '',$sel[3],'class="stext komoditi" title="Sub Sub Komoditi atau Sub Sub Kategori sampel" id="sel5" ke="5"'); ?></td>
			<td></td>
			<td class="td_left">&nbsp;</td>
			<td class="td_right">&nbsp;</td>
		</tr>
		
		<tr <?php echo (strlen($sel[4]) == 12 || strlen($sel[4]) == 13)? '' : 'class="hideme"'; ?> id="tdanak6" ke="6">
			<td class="td_left">&nbsp;</td>
			<td class="td_right"><?php echo form_dropdown('KOMODITI[]',is_array($selkategori[4]) ? $selkategori[4] : '',$sel[4],'class="stext komoditi" title="Sub Sub Komoditi atau Sub Sub Kategori sampel" id="sel6" ke="6"'); ?></td>
			<td></td>
			<td class="td_left">&nbsp;</td>
			<td class="td_right">&nbsp;</td>
		</tr>
	</table>
	<div style="height:10px;">&nbsp;</div>
	<div style="padding-left:5px;"><a href="#" class="button save" onclick="save_edit('#fedit-kategori'); return false;"><span><span class="icon"></span>&nbsp; Update Kategori &nbsp;</span></a></div>
    <input type="hidden" name="prioritas" value="<?= $sess['PRIORITAS']; ?>">
    <input type="hidden" name="exist" value="<?= $ext; ?>">
</form>
<script type="text/javascript">
$(document).ready(function(){
	$('select.komoditi').change(function(){
		var ke = $(this).attr('ke');
		var kunci = $(this).val();
		ke = parseInt(ke) + 1;
		for(i=ke;i<=5;i++){
			$('#sel' + ke).html();
		}
		$.get('<?php echo site_url().'/autocompletes/autocomplete/get_kategori/'; ?>' + kunci + '/' + <?php echo $sess['PRIORITAS']; ?>, function(hasil){
			var hasil = hasil.replace(' ', '');
			var jum = hasil.length;
			if(jum == 0 || kunci == 00){
				$('#tdanak' + ke).hide();
				$('#sel' + ke).html('');
				$('#sel' + ke).removeAttr("rel");
			}else{
				$('#tdanak' + ke).show();
				$('#sel' + ke).html(hasil);
				$('#sel' + ke).attr("rel","required");
			}
		});
	});
});

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