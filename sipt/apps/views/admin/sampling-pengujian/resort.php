<form action="<?php echo site_url(); ?>/utility/tools/resort/first" id="fresort" name="fresort" method="post">
<table class="form_tabel">
  <tr>
    <td class="td_left">Balai Besar / Balai POM</td>
    <td class="td_right"><?php echo form_dropdown('balai',$balai,'','class="stext" title="Pilih salah satu balai" rel="required"'); ?></td>
  </tr>
</table>
  <div style="padding-left:5px;" id="div-btn-reset"><a href="#" class="button download" id="btn-check" onclick="save_tools('#fresort'); return false;"><span><span class="icon"></span>&nbsp; Check Data &nbsp;</span></a></div>
  <div style="height:5px;">&nbsp;</div>
  <div id="tmp-resort"></div>
</form>
<script>
$(document).ready(function(){
	$("table.form_tabel tr:even").css("background-color", "#f0f0f0");
	$("table.form_tabel tr:odd").css("background-color", "#fff");
});
function save_tools(formid){
	var jumlah = 0; 
	$.each($(formid+" input:visible, select:visible, textarea:visible"), function(){
		if($(this).attr('rel')){
			if($(this).attr('rel')=="required" && ($(this).val()=="" || $(this).val()==null)){
				$(this).css('background-color','#FBE3E4');
				$(this).css('border','1px solid #F00'); 
				jumlah++;
			}
		}
	});
	if(jumlah > 0){
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
				if(data){
					$("#tmp-resort").html(data);
					$("#div-btn-reset").hide();
				}
			}
		});
	}
}
</script> 


