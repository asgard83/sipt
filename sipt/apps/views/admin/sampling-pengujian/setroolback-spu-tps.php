<?php
if($result){
?>

<div id="ctn-form">
  <form action="<?php echo site_url(); ?>/utility/tools/set_tps/second" id="ftps-second" name="ftps-second" method="post">
    <input type="hidden" name="SPU_ID" value="<?php echo $SPU_ID; ?>" />
    <input type="hidden" name="STATUS" value="<?php echo $STATUS; ?>" />
    <table class="form_tabel">
      <tr>
        <td class="td_left atas isi">Nomor SPU</td>
        <td class="td_right atas isi"><?php echo $sess['F_SPU']; ?></td>
      </tr>
      <tr>
        <td class="td_left">Anda yakin SPU akan dikembalikan ke</td>
        <td class="td_right"><b><?php echo $ur_stat; ?></b></td>
      </tr>
    </table>
    <div style="padding-left:5px;" id="div-btn-reset"><a href="#" class="button reload" id="btn-proses" onclick="save_revisi('#ftps-second'); return false;"><span><span class="icon"></span>&nbsp; Tarik Data &nbsp;</span></a></div>
    <div style="height:5px;">&nbsp;</div>
  </form>
</div>
<div id="showrespon"></div>
<script>
$(document).ready(function(){
	$("table.form_tabel tr:even").css("background-color", "#f0f0f0");
	$("table.form_tabel tr:odd").css("background-color", "#fff");
});
function save_revisi(formid){
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
					$("#showrespon").html(data);
					$("#ctn-form").hide();
				}
			}
		});
	}
}
</script>
<?php
}else{
	?>
<table class="form_tabel">
  <tr>
    <td class="td_left" colspan="3">Data tidak ditemukan</td>
  </tr>
</table>
<?php
}
?>
