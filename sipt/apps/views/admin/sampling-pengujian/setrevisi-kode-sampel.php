<?php
if($result){
?>
<form action="<?php echo site_url(); ?>/utility/tools/revisi_nomor/second/sampel" id="frevisi-second" name="frevisi-second" method="post">
  <table class="form_tabel">
    <tr>
      <td class="td_left">Kode Sampel</td>
      <td class="td_right"><?php echo $sess['KODE_LAMA']; ?></td>
    </tr>
    <tr>
      <td class="td_left">Diuji</td>
      <td class="td_right"><?php echo $sess['UJI_SAMPEL']; ?></td>
    </tr>
    <tr>
      <td class="td_left">Jumlah Sampel</td>
      <td class="td_right"><input type="text" class="sdate" name="REVISI[JUMLAH_SAMPEL]" value="<?php echo $sess['JUMLAH_SAMPEL']; ?>" rel="required" id="jumlah" />&nbsp;<?php echo form_dropdown('SAMPEL[SATUAN]',$satuan,$sess['SATUAN'],'class="stext sjenis" title="Satuan" rel="required"'); ?></td>
    </tr>
    <tr>
      <td class="td_left">Jumlah Kimia</td>
      <td class="td_right"><input type="text" class="scode jml" name="REVISI[JUMLAH_KIMIA]" value="<?php echo $sess['JUMLAH_KIMIA']; ?>" rel="required" id="jml_kimia" onkeyup="numericOnly($(this))" /></td>
    </tr>
    <tr>
      <td class="td_left">Jumlah Mikro</td>
      <td class="td_right"><input type="text" class="scode jml" name="REVISI[JUMLAH_MIKRO]" value="<?php echo $sess['JUMLAH_MIKRO']; ?>" rel="required" id="jml_mikro" onkeyup="numericOnly($(this))" /></td>
    </tr>
    <tr>
      <td class="td_left">Retain Sampel</td>
      <td class="td_right"><input type="text" class="scode jml" name="REVISI[SISA]" value="<?php echo $sess['SISA']; ?>" rel="required" id="sisa" readonly="readonly" /></td>
    </tr>
    <tr>
      <td class="td_left">Revisi Uji Sampel</td>
      <td class="td_right"><div><input type="checkbox" class="chklab" value="K" name="lab[]" />&nbsp;Kimia</div><div><input type="checkbox" value="M" name="lab[]" class="chklab" />&nbsp;Mikro</div></td>
    </tr>
    
  </table>
  <div style="padding-left:5px;" id="div-btn-reset"><a href="#" class="button reload" id="btn-proses" onclick="save_revisi('#frevisi-second'); return false;"><span><span class="icon"></span>&nbsp; Proses Revisi &nbsp;</span></a></div>
  <div style="height:5px;">&nbsp;</div>
  <div id="showrevisi"></div>
  <input type="hidden" name="OLD_KODE" value="<?php echo $sess["KODE_SAMPEL"]; ?>" />
</form>
<script>
$(document).ready(function(){
	$("table.form_tabel tr:even").css("background-color", "#f0f0f0");
	$("table.form_tabel tr:odd").css("background-color", "#fff");
	$("#jumlah").change(function(){
		$("#jml_kimia, #jml_mikro").val('0');
		$("#sisa").val('0');
		return false;
	});
	$("#jml_kimia").change(function(){
		var jml = parseFloat($("#jml_mikro").val()) + parseFloat($("#jml_kimia").val());
		if($("#jumlah").val() == "" || parseFloat($("#jumlah").val()) == 0) return false;
		sisa = parseFloat($("#jumlah").val()) - (parseFloat($("#jml_mikro").val()) + parseFloat($(this).val()));		
		if(parseFloat($("#jml_kimia").val()) + sisa > parseFloat($("#jumlah").val())){
			jAlert('Jumlah sampel melebihi sisa sampel','SIPT versi 1.0')
			$("#jml_kimia").focus();
		}
		if(jml > parseFloat($("#jumlah").val())){
			jAlert('Total jumlah sampel kimia dan mikro melebihi jumlah sampel','SIPT versi 1.0')
			$("#jml_kimia").focus();
			$("#jml_kimia").val('0');
			sisa = parseFloat($("#jumlah").val()) - (parseFloat($("#jml_mikro").val()) + parseFloat($(this).val()));
		}
		if(sisa < 0) sisa = 0;
		$("#sisa").val(parseFloat(sisa).toFixed(2));
	});
	$("#jml_mikro").change(function(){
		var jml = parseFloat($("#jml_mikro").val()) + parseFloat($("#jml_kimia").val());
		if($("#jumlah").val() == "" || parseFloat($("#jumlah").val()) == 0) return false;
		sisa = parseFloat($("#jumlah").val()) - (parseFloat($("#jml_kimia").val()) + parseFloat($(this).val()));
		if(parseFloat($("#jml_mikro").val()) + sisa > parseFloat($("#jumlah").val())){
			jAlert('Jumlah sampel melebihi sisa sampel','SIPT versi 1.0')
			$("#jml_mikro").focus();
		}
		if(jml > parseFloat($("#jumlah").val())){
			jAlert('Total jumlah sampel kimia dan mikro melebihi jumlah sampel','SIPT versi 1.0')
			$("#jml_mikro").focus();
			$("#jml_mikro").val('0');
			sisa = parseFloat($("#jumlah").val()) - (parseFloat($("#jml_kimia").val()) + parseFloat($(this).val()));
		}
		if(sisa < 0) sisa = 0;
		$("#sisa").val(parseFloat(sisa).toFixed(2));
	});
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
	
	if(jumlah == 0){
		if(!$(".chklab").is(':checked')){
			jumlah = -1;	
		}
	}
	
	if(jumlah==-1){
		jAlert('Jenis pengujian belum di pilih', 'SIPT Versi 1.0');
		return false;
	}else if(jumlah > 0){
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
					$("#showrevisi").html(data);
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
      <td class="td_left" colspan="2">Data tidak ditemukan</td>
    </tr>
    </table>
    <?php
}
?>