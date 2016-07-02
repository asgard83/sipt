<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR);
$jml = count($kabid);
?>
<form name="fedit-mt" id="fedit-headerspu" method="post" action="<?php echo $act; ?>" autocomplete="off">
	<input type="hidden" name="SPU_ID" value="<?php echo $sess['SPU_ID']; ?>" readonly />
	<table class="form_tabel">
          <tr>
            <td class="td_left"><b>Nomor Surat Permintaan Uji</b></td>
            <td class="td_right"><?php echo $sess['UR_SPU']; ?></td>
          </tr>
          <tr>
            <td class="td_left"><b>Tanggal Surat Permintaan Uji</b></td>
            <td class="td_right"><input name="SPU[TANGGAL]" rel="required" type="text" class="sdate" title="Tanggal SPU" value="<?= $sess['TANGGAL_SPU']; ?>" /></td>
          </tr>
          <tr>
            <td class="td_left"><b>Nomor Surat Perintah</b></td>
            <td class="td_right"><?php echo $sess['NOMOR_SP']; ?></td>
          </tr>
          <tr>
            <td class="td_left"><b>Tanggal Terima Di TPS</b></td>
            <td class="td_right"><?= $jml > 0 ? '<input name="SPU[TANGGAL_TERIMA_TPS]" rel="required" type="text" class="sdate" title="Tanggal Terima di TIPS" value="'.$sess['TANGGAL_TERIMA_TPS'].'" />' : $sess['TANGGAL_TERIMA_TPS']; ?></td>
          </tr>
          <tr>
            <td class="td_left"><b>Tanggal Surat Perintah</b></td>
            <td class="td_right"><?= $jml > 0 ? '<input name="SPU[TANGGAL_PERINTAH]" rel="required" type="text" class="sdate" title="Tanggal Surat Perintah" value="'.$sess['TANGGAL_PERINTAH'].'"  />' : $sess['TANGGAL_PERINTAH']; ?></td>
          </tr>
          <tr>
            <td class="td_left"><b>Menyetujui Kepala Balai</b></td>
            <td class="td_right"><?php echo $sess['NAMA_USER']; ?></td>
          </tr>
          <tr>
            <td class="td_left">&nbsp;</td>
            <td class="td_right"><?php echo $sess['NAMA_BBPOM']; ?></td>
          </tr>
          <?php
		  if($jml > 0){
		  ?>
          <tr>
            <td class="td_left">Ditujukan Kepada : </td>
            <td class="td_right"><?php
							for($i = 0; $i < $jml; $i++){
								?>
              <div><b><?php echo $kabid[$i]['NAMA_USER']; ?></b></div>
              <div><?php echo $kabid[$i]['USER_ID']; ?></div>
              <div>&bull;&nbsp;<?php echo $kabid[$i]['JABATAN']; ?></div>
              <hr>
              <?php
							}
						?></td>
          </tr>
          <?php
		  }
		  ?>
        </table>
	<div style="height:10px;">&nbsp;</div>
    <?php
	#if($jml > 0){
	?>
	<div style="padding-left:5px;"><a href="javascript:;" class="button save" onclick="save_dispo('#fedit-headerspu'); return false;"><span><span class="icon"></span>&nbsp; Update &nbsp;</span></a></div>
    <?php
	#}
	?>
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