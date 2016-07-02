<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR);?>
<link type="text/css" href="<?php echo base_url();?>css/css.css" rel="stylesheet" />
<form id="frevisi-spk" action="<?php echo $act; ?>"	autocomplete="off" name="frevisi-spk" method="post">
  <table class="form_tabel">
    <tr>
      <td class="td_left bold">BB / BBPOM</td>
      <td class="td_right"><?php echo $sess['NAMA_BBPOM']; ?></td>
    </tr>
    <tr>
      <td class="td_left bold">Nomor SPU</td>
      <td class="td_right"><?php echo $sess['UR_SPU']; ?></td>
    </tr>
    <tr>
      <td class="td_left bold">Kode Sampel</td>
      <td class="td_right"><?php echo $sess['UR_KODE_SAMPEL']; ?></td>
    </tr>
    <tr>
      <td class="td_left bold">Komoditi</td>
      <td class="td_right"><?php echo $sess['UR_KOMODITI']; ?></td>
    </tr>
    <tr>
      <td class="td_left bold">Nama Manajer Teknis</td>
      <td class="td_right"><?php echo form_dropdown('CREATE_BY',$mt,$sess['CREATE_BY'],'class="stext" style="width:500px;" title="Daftar nama Manager Teknis" rel="required"'); ?></td>
    </tr>
    <tr>
      <td class="td_left bold">Nomor SPK</td>
      <td class="td_right"><?php echo $sess['UR_SPK']; ?><div style="font-size:10px; font-weight:bold;"><?php echo $sess['JENIS_SPK']; ?></div></td>
    </tr>
    <tr>
      <td class="td_left bold">Tanggal Surat Perintah Kerja</td>
      <td class="td_right"><input type="text" value="<?php echo $sess['TANGGAL_SPK']; ?>" rel="required" class="sdate" name="TANGGAL_SPK"></td>
    </tr>
    <tr>
      <td class="td_left bold">Nama Penyelia</td>
      <td class="td_right"><?php echo form_dropdown('KASIE',$penyelia,$sess['KASIE'],'class="stext" style="width:500px;" title="Daftar nama Manager Teknis" rel="required"'); ?></td>
    </tr>
  </table>
  <input type="hidden" name="SPK_ID" value="<?php echo $sess['SPK_ID']; ?>">
  <input type="hidden" name="KODE_SAMPEL" value="<?php echo $sess['KODE_SAMPEL']; ?>">
</form>
<div style="padding:1px;">&nbsp;</div>
<div style="padding-left:5px;"> <a href="#" class="button save" onclick="save_edit('#frevisi-spk'); return false;"><span><span class="icon"></span>&nbsp; Proses&nbsp;</span></a> </div>
<div style="padding:2px;">&nbsp;</div>
<script>
	$(document).ready(function(){
		$('input.sdate').datepicker({ dateFormat: 'dd/mm/yy',regional: 'id'});
		$("table.form_tabel tr:even").css("background-color", "#f0f0f0");
		$("table.form_tabel tr:odd").css("background-color", "#fff");
		$(".delete-params").click(function(){
			var jenis = $(this).attr("jns");
			$(".upload_FILE"+jenis+"").show();
			$(".tmp_FILE"+jenis+"").hide();
			return false;
		});
	});
	function do_upload(element){
		var allowed = $(element).attr("allowed");
		var ke = $(element).attr("ke");
		$.ajaxFileUpload({
			url: $(element).attr("url")+'/'+allowed,
			secureuri: false,
			fileElementId: $(element).attr("id"),
			dataType: "json",
			success: function(data){
				var arrdata = data.msg.split("#");
				if(typeof(data.error) != "undefined"){
					if(data.error != ""){
						jAlert(data.error, "SIPT Versi 1.0 ");
					}else{
						$(".upload_FILE"+ke+"").hide();
						$(".file_LCP"+ke+"").html("<b>1 File telah dilampirkan. </b>&nbsp;<a href=\"<?php echo base_url(); ?>files/LCP/"+arrdata[2]+"/"+arrdata[0]+"\" target=\"_blank\">Tampilkan File</a></a><input type=\"hidden\" name=\"UJI[LCP]\" value="+arrdata[0]+">");
					}
				}
			},
			error: function (data, status, e){
				jAlert(e, "SIPT Versi 1.0 Beta");
			}
		});
	}
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