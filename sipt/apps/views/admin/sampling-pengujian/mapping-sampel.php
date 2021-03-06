<form action="<?php echo site_url(); ?>/utility/tools/mapping_sampel/first/sampel" id="fmapping-sampel" name="fmapping-sampel" method="post">
  <table class="form_tabel">
    <tr>
      <td class="td_left">Kode Sampel</td>
      <td class="td_right"><input type="text" class="stext" title="Masukan kode sampel yang akan di mapping" rel="required" name="KODE_SAMPEL" /></td>
    </tr>
  </table>
  <div style="padding-left:5px;" id="div-btn-reset"><a href="#" class="button download" id="btn-check" onclick="save_tools('#fmapping-sampel'); return false;"><span><span class="icon"></span>&nbsp; Mapping Data &nbsp;</span></a></div>
  <div style="height:5px;">&nbsp;</div>
</form>
<div id="tmp-result-kode"></div>
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
					$("#tmp-result-kode").html(data);
				}
			}
		});
	}
}
</script> 
