<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR);?>
<link type="text/css" href="<?php echo base_url();?>css/css.css" rel="stylesheet" />
<form name="fstatusmt" id="fstatusmt" method="post" action="<?php echo $act; ?>" autocomplete="off">
  <input type="hidden" name="KODE_SAMPEL" value="<?php echo $sess['KODE_SAMPEL']; ?>" readonly />
  <input type="hidden" name="SPU_ID" value="<?php echo $sess['SPU_ID']; ?>" readonly />
  <input type="hidden" name="chkjml" value="<?php echo $jmlinput; ?>" readonly />
  <table class="form_tabel">
    <tr>
      <td class="td_left"><b>Kode Sampel</b></td>
      <td class="td_right"><?php echo $sess['UR_KODE']; ?></td>
    </tr>
    <tr>
      <td class="td_left"><b>Nomor Surat Permintaan Uji</b></td>
      <td class="td_right"><?php echo $sess['UR_SPU']; ?></td>
    </tr>
    <tr>
      <td class="td_left"><b>Komoditi</b></td>
      <td class="td_right"><?php echo $sess['UR_KOMODITI']; ?></td>
    </tr>
    <tr>
      <td class="td_left"><b>Sampel Di Uji</b></td>
      <td class="td_right"><?php echo $sess['JENIS_UJI']; ?></td>
    </tr>
    <tr>
      <td class="td_left"><b>Manajer Teknis</b></td>
      <td class="td_right"><?php echo form_dropdown('USER_ID[]',$arrmt,'','class="stext multiselect" style="height:90px; width:500px;" title="Daftar nama Manager Teknis. Untuk memilih MT lebih dari satu, silahkan klik di salah satu nama MT kemudian tekan tombol Ctrl untuk memilih MT yang lainnya" multiple rel="required"'); ?></td>
    </tr>
  </table>
  <div style="height:10px;">&nbsp;</div>
  <div style="padding-left:5px;"><a href="javascript:;" class="button save" onclick="save_dispo('#fstatusmt'); return false;"><span><span class="icon"></span>&nbsp; Update &nbsp;</span></a></div>
</form>
<script type="text/javascript">
$(document).ready(function(e) {
	$("table.form_tabel tr:even").css("background-color", "#f0f0f0");
	$("table.form_tabel tr:odd").css("background-color", "#fff");
	$('input.sdate').datepicker({ dateFormat: 'dd/mm/yy',regional: 'id', maxDate: new Date()});
});
function save_dispo(formid){
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