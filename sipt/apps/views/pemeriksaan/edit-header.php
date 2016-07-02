<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR);?>
<link type="text/css" href="<?php echo base_url();?>css/css.css" rel="stylesheet" />
<form name="fedit-header-periksa" id="fedit-header-periksa" method="post" action="<?php echo $act; ?>" autocomplete="off">
  <input type="hidden" name="PERIKSA_ID" value="<?php echo $sess['PERIKSA_ID']; ?>" />
  <input type="hidden" name="SARANA_ID" value="<?php echo $sess['SARANA_ID']; ?>" />
  <table class="form_tabel">
    <tr>
      <td class="td_left">Nama Sarana</td>
      <td class="td_right"><?php echo $sess['NAMA_SARANA']; ?></td>
    </tr>
    <tr>
      <td class="td_left">Jenis Sarana</td>
      <td class="td_right"><?php echo $sess['NAMA_JENIS_SARANA']; ?></td>
    </tr>
    <tr>
      <td class="td_left">Tanggal Pemeriksaan</td>
      <td class="td_right"><input type="text" class="sdate" rel="required" value="<?php echo $sess['AWAL_PERIKSA']; ?>" name="PEMERIKSAAN[AWAL_PERIKSA]" title="Awal Periksa" /> s.d <input type="text" class="sdate" rel="required" value="<?php echo $sess['AKHIR_PERIKSA']; ?>" title="Akhir Periksa" name="PEMERIKSAAN[AKHIR_PERIKSA]" /></td>
    </tr>
    <tr>
      <td class="td_left">Balai Besar / Balai POM</td>
      <td class="td_right"><?php echo $sess['NAMA_BBPOM']; ?></td>
    </tr>
    <tr>
      <td class="td_left">Petugas Entri</td>
      <td class="td_right"><?php echo form_dropdown('PEMERIKSAAN[CREATE_BY]', $petugas, $sess['CREATE_BY'], 'id="CREATE_BY" class="stext" rel="required" title="Daftar nama petugas"'); ?></td>
    </tr>
    <tr>
      <td class="td_left">Status Pemeriksaan</td>
      <td class="td_right"><?php echo $sess['STATUS']; ?></td>
    </tr>
  </table>
  <div style="height:10px;">&nbsp;</div>
	<div style="padding-left:5px;"><a href="#" class="button save" onclick="save_edit('#fedit-header-periksa'); return false;"><span><span class="icon"></span>&nbsp; Update &nbsp;</span></a></div>
</form>
<script>
$(document).ready(function(){
	$('input.sdate').datepicker({ dateFormat: 'dd/mm/yy',regional: 'id'});
	$("table.form_tabel tr:even").css("background-color", "#f0f0f0");
	$("table.form_tabel tr:odd").css("background-color", "#fff");
	$('select, textarea, input:not(:image, submit, checkbox, radio)').poshytip({className: 'tip-twitter',showTimeout: 1,alignTo: 'target',alignX: 'right',alignY: 'center',offsetX: 5,allowTipHover: false,fade: false,slide: false});
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