<?php
if($result){
?>

<form action="<?php echo site_url(); ?>/utility/tools/mapping_sampel/second/sampel" id="fmapping-sampel-second" name="fmapping-sampel-second" method="post">
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
      <td class="td_left atas isi" colspan="2">Komoditi Sebelumnya</td>
    </tr>
    <tr>
      <td class="td_left">Kategori</td>
      <td class="td_right"><?php echo $sess['UR_KOMODITI']; ?>
        <input type="hidden" id="sel1" ke="1" value="<?php echo $sess['KOMODITI']; ?>" /></td>
    </tr>
    <tr>
      <td class="td_left atas isi" colspan="2">Revisi Komoditi</td>
    </tr>
    <tr>
      <td class="td_left">Komoditi</td>
      <td class="td_right"><?php echo form_dropdown('KOMODITI[]',$komoditi,$sess['KOMODITI'],'class="stext komoditi" title="Komoditi" ke="1" id="sel1" rel="required"'); ?></td>
    </tr>
    <tr class="hideme" id="tdanak2" ke="2">
      <td class="td_left">Kategori sampel</td>
      <td class="td_right"><?php echo form_dropdown('KOMODITI[]',is_array($selkategori[0]) ? $selkategori[0] : '',$sel[0],'class="stext komoditi" title="Sub Komoditi atau Sub Kategori sampel" id="sel2" ke="2" rel="required"'); ?></td>
    </tr>
    <tr class="hideme" id="tdanak3" ke="3">
      <td class="td_left">&nbsp;</td>
      <td class="td_right"><?php echo form_dropdown('KOMODITI[]',is_array($selkategori[1]) ? $selkategori[1] : '',$sel[1],'class="stext komoditi" title="Sub Sub Komoditi atau Sub Sub Kategori sampel" id="sel3" ke="3"'); ?></td>
    </tr>
    <tr class="hideme" id="tdanak4" ke="4">
      <td class="td_left">&nbsp;</td>
      <td class="td_right"><?php echo form_dropdown('KOMODITI[]',is_array($selkategori[2]) ? $selkategori[2] : '',$sel[2],'class="stext komoditi" title="Sub Sub Komoditi atau Sub Sub Kategori sampel" id="sel4" ke="4"'); ?></td>
    </tr>
    <tr class="hideme" id="tdanak5" ke="5">
      <td class="td_left">&nbsp;</td>
      <td class="td_right"><?php echo form_dropdown('KOMODITI[]',is_array($selkategori[3]) ? $selkategori[3] : '',$sel[3],'class="stext komoditi" title="Sub Sub Komoditi atau Sub Sub Kategori sampel" id="sel5" ke="5"'); ?></td>
    </tr>
  </table>
  <div style="padding-left:5px;" id="div-btn-reset"><a href="#" class="button reload" id="btn-proses" onclick="save_revisi('#fmapping-sampel-second'); return false;"><span><span class="icon"></span>&nbsp; Proses &nbsp;</span></a></div>
  <div style="height:5px;">&nbsp;</div>
  <div id="showrevisi"></div>
  <input type="hidden" name="OLD_KODE" value="<?php echo $sess["KODE_SAMPEL"]; ?>" />
</form>
<script>
$(document).ready(function(){
	$("table.form_tabel tr:even").css("background-color", "#f0f0f0");
	$("table.form_tabel tr:odd").css("background-color", "#fff");
	$('select.komoditi').change(function(){
		var ke = $(this).attr('ke');
		var kunci = $(this).val();
		var urls = '<?php echo site_url().'/autocompletes/autocomplete/get_kategori/'; ?>' + kunci;	
		ke = parseInt(ke) + 1;
		for(i=ke;i<=5;i++){
			$('#sel' + ke).html();
		}
		$.get(urls, function(hasil){
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
