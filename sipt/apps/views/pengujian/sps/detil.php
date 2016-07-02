<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR); ?>
<link type="text/css" href="<?php echo base_url();?>css/css.css" rel="stylesheet" />
<form name="fviewsps" id="fviewsps" method="post" action="<?php echo $act; ?>" autocomplete="off">
  <input type="hidden" name="SPU_ID" value="<?php echo $sess['SPU_ID']; ?>" />
  <input type="hidden" name="KODE_SAMPEL" value="<?php echo $sess['KODE_SAMPEL']; ?>" />
  <input type="hidden" name="USER_ID" value="<?php echo $sess['USER_ID']; ?>" />
  <h2 style="font-weight: bold; padding-bottom: 2px; font-size: 11px; color:#3c7faf;">Detil Penyerahan Sampel Per Kode Sampel</h2>
  <table class="form_tabel">
    <tr>
      <td class="td_left">Nomor Surat Permintaan Uji</td>
      <td class="td_right"><?php echo $sess['UR_SPU']; ?></td>
    </tr>
    <tr>
      <td class="td_left">Kode Sampel</td>
      <td class="td_right"><?php echo $sess['UR_SPL']; ?></td>
    </tr>
    <tr>
      <td class="td_left">Nama Kepala Bidang</td>
      <td class="td_right"><?php echo $sess['NAMA_USER']; ?></td>
    </tr>
    <tr>
      <td colspan="2"><h2 style="font-weight: bold; padding-bottom: 2px; font-size: 11px; color:#3c7faf;">Disposisi Perintah Kerja</h2></td>
    </tr>
    <tr>
      <td class="td_left">Nomor Surat Perintah Kerja</td>
      <td class="td_right"><?php echo $spk['UR_SPK']; ?></td>
    </tr>
    <tr>
      <td class="td_left">Tanggal</td>
      <td class="td_right"><?php echo $spk['TANGGAL']; ?></td>
    </tr>
    <tr>
      <td class="td_left">Komoditi</td>
      <td class="td_right"><?php echo $spk['KOMODITI']; ?></td>
    </tr>
    <tr>
      <td class="td_left">Nama Penyelia</td>
      <td class="td_right"><?php echo $spk['PENYELIA']; ?></td>
    </tr>
    <tr>
      <td class="td_left">Status Penyerahan Sampel</td>
      <td class="td_right"><?php echo form_dropdown('STATUS',$status,$sess['STATUS'],'class="stext editable" title="Pilih Status" rel="required"'); ?><span class="showme"><?php echo $sess['UR_STATUS']; ?></span></td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
    <?php
	if($jml > 0 || $sess['STATUS'] == '30201'){
	?>
    <tr>
      <td class="td_left bold" colspan="2"><div style="background:#FBE3E4; border:1px solid #ccc; padding:5px;">
          <input type="checkbox" id="chk_edit" />
          &nbsp;<b>Edit Status Penyerahan Sampel</b></div></td>
    </tr>
    <?php
	}
	?>
  </table>
  <div style="height:10px;">&nbsp;</div>
  <div style="padding-left:5px;"><a href="#" class="button save editable" onclick="save_edit('#fviewsps'); return false;"><span><span class="icon"></span>&nbsp; Update &nbsp;</span></a></div>
</form>
<div style="padding:3px;">&nbsp;</div>
<script type="text/javascript">
	$(document).ready(function(){
		$("table.form_tabel tr:even").css("background-color", "#f0f0f0");
		$("table.form_tabel tr:odd").css("background-color", "#fff");
		$(".editable").css("display","none");
		$("#chk_edit").change(function(e){
        if($(this).is(":checked")){
			$(".editable").css("display","");
			$(".showme").css("display","none");
		}else{
			$(".editable").css("display","none");
			$(".showme").css("display","");
		}
		return false;
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