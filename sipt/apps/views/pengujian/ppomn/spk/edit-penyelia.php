<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR);  ?>
<form name="fedit-penyelia" id="fedit-penyelia" method="post" action="<?php echo $act; ?>" autocomplete="off">
  <input type="hidden" name="KODE_SAMPEL" value="<?php echo $sess['KODE_SAMPEL']; ?>" />
  <input type="hidden" name="SPK_ID" value="<?php echo $sess['SPK_ID']; ?>" />
  <input type="hidden" name="SPU_ID" value="<?php echo $sess['SPU_ID']; ?>" />
  <input type="hidden" name="USER" value="<?php echo $sess['KASIE']; ?>" />
  <table class="form_tabel">
    <tr>
      <td class="td_left bold">Nomor SPU</td>
      <td class="td_right"><?php echo $sess['UR_SPU']; ?></td>
    </tr>
    <tr>
      <td class="td_left bold">Kode Sampel</td>
      <td class="td_right"><?php echo $sess['UR_KODE']; ?></td>
    </tr>
    <tr>
      <td class="td_left bold">Nomor SPK</td>
      <td class="td_right"><?php echo $sess['UR_SPK']; ?></td>
    </tr>
    <tr>
      <td class="td_left bold">Tanggal Surat Perintah Kerja</td>
      <td class="td_right"><?php echo $sess['TANGGAL_SPK']; ?></td>
    </tr>
    <tr>
      <td class="td_left bold">Nama Penyelia Sebelumnya</td>
      <td class="td_right"><?php echo $sess['NAMA_USER']; ?></td>
    </tr>
    <tr>
      <td class="td_left bold">Penyelia Pengganti</td>
      <td class="td_right"><?php echo form_dropdown('PENYELIA',$penyelia,'','class="stext" id="penyelia_edt" title="Daftar nama penyelia" rel="required"'); ?></td>
    </tr>
  </table>
  <div style="height:10px;">&nbsp;</div>
  <div style="padding-left:5px;"><a href="#" class="button save" onclick="save_edit('#fedit-penyelia'); return false;"><span><span class="icon"></span>&nbsp; Update Penyelia &nbsp;</span></a></div>
  <div style="height:10px;">&nbsp;</div>
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