<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR);?>
<link type="text/css" href="<?php echo base_url();?>css/css.css" rel="stylesheet" />
<form name="fedit-penyelia" id="fedit-tindakan-balai" method="post" action="<?php echo $act; ?>" autocomplete="off">
  <input type="hidden" name="PERIKSA_ID" value="<?php echo $sess['PERIKSA_ID']; ?>" />
  <table class="form_tabel">
    <tr>
      <td class="td_left">Nama Sarana</td>
      <td class="td_right"><?php echo array_key_exists('NAMA_SARANA', $sess)?$sess['NAMA_SARANA']:""; ?></td>
    </tr>
    <tr>
      <td class="td_left">Tanggal Pemeriksaan</td>
      <td class="td_right"><?php echo array_key_exists('AWAL_PERIKSA', $sess)?$sess['AWAL_PERIKSA']:""; ?>&nbsp; sampai dengan &nbsp; <?php echo array_key_exists('AKHIR_PERIKSA', $sess)?$sess['AKHIR_PERIKSA']:""; ?></td>
    </tr>
    <tr>
      <td class="td_left">Tujuan Pemeriksaan</td>
      <td class="td_right"><?php echo array_key_exists('TUJUAN_PEMERIKSAAN', $sess)?$sess['TUJUAN_PEMERIKSAAN']:""; ?></td>
    </tr>
    <tr>
      <td class="td_left">Dasar Pemeriksaan</td>
      <td class="td_right"><?php echo array_key_exists('DASAR_PEMERIKSAAN', $sess)?$sess['DASAR_PEMERIKSAAN']:""; ?></td>
    </tr>
    <tr>
      <td class="td_left">Tanggal Tindakan</td>
      <td class="td_right"><input type="text" class="stext sdate" name="PEMERIKSAAN[TANGGAL_TINDAKAN_BALAI]" value="<?php echo $sess['TANGGAL_TINDAKAN_BALAI']; ?>" title="Tanggal tindakan" /></td>
    </tr>
    <tr>
      <td class="td_left">Saran Tindak Lanjut</td>
      <td class="td_right"><textarea name="PEMERIKSAAN[DETAIL_TINDAKAN_BALAI]" class="stext catatan" title="Detil saran tindak lanjut"><?php echo $sess['DETAIL_TINDAKAN_BALAI']; ?></textarea></td>
    </tr>
    <?php
	if($sess['JENIS_SARANA'] == "03"){
	?>
    <tr>
      <td class="td_left">File Tindak Lanjut</td>
      <td class="td_right">
	   <?php
	  if($sess['FILE_TL_BALAI'] != "" && trim($sess['FILE_TL_BALAI']) != ""){
		  ?>
		  <a href="<?php echo base_url(); ?>files/<?php echo $sess['SARANA_ID']; ?>/<?php echo $sess['FILE_TL_BALAI']; ?>" target="_blank">File Lampiran</a><input type="hidden" name="PEMERIKSAAN[FILE_TL_BALAI]" value="<?php echo $sess['FILE_TL_BALAI']; ?>" /><?php
	  }else{?> 
      	<span class="upload_TL_BALAI"><input type="file" class="stext upload" jenis="TL_BALAI" allowed="pdf" url="<?php echo site_url(); ?>/utility/uploads/get_upload/<?php echo $sess['SARANA_ID'];?>" id="fileToUpload_TL_BALAI" name="userfile" onchange="do_upload($(this)); return false;"/>&nbsp;Tipe file : *.pdf</span><span class="file_TL_BALAI"></span>
		<?php
	  }
	  ?>
      </td>
    </tr>
    <?php
  }
  ?>
  </table>
  <div style="height:10px;">&nbsp;</div>
  <div style="padding-left:5px;"><a href="#" class="button save" onclick="save_edit('#fedit-tindakan-balai'); return false;"><span><span class="icon"></span>&nbsp; Update Tindak Lanjut &nbsp;</span></a></div>
  <div style="height:10px;">&nbsp;</div>
</form>
<script>
	$(document).ready(function(){
		$("table.form_tabel tr:even").css("background-color", "#f0f0f0");
		$("table.form_tabel tr:odd").css("background-color", "#fff");
		$('input.sdate').datepicker({ dateFormat: 'dd/mm/yy',regional: 'id'});
		$(".del_upload").live("click", function(){
			var jenis = $(this).attr("jns");
			$.ajax({
				type: "GET",
				url: $(this).attr("url"),
				data: $(this).serialize(),
				success: function(data){
					var arrdata = data.split("#");
					$(".upload_"+jenis+"").show();
					$("#fileToUpload_"+jenis+"").val('');
					$(".file_"+jenis+"").html("");
				}
			});
			return false;
		});
		
	});
	function do_upload(element){
		var jenis = $(element).attr("jenis");
		var allowed = $(element).attr("allowed");
		$("#indicator").ajaxStart(function(){
			jLoadingOpen('Upload File','SIPT Versi 1.0');
		}).ajaxComplete(function(){
			jLoadingClose();
		});
		$.ajaxFileUpload({
			url: $(element).attr("url")+'/'+jenis+'/'+allowed,
			secureuri: false,
			fileElementId: $(element).attr("id"),
			dataType: "json",
			success: function(data){
				var arrdata = data.msg.split("#");
				if(typeof(data.error) != "undefined"){
					if(data.error != ""){
						jAlert(data.error, "SIPT Versi 1.0 ");
					}else{
						$(".upload_"+arrdata[2]+"").hide();
						$("#fileToUpload_"+arrdata[2]+"").removeAttr("rel");
						$(".file_"+arrdata[2]+"").html("<b>1 File telah dilampirkan. </b>&nbsp;<a href=\"<?php echo base_url(); ?>files/"+arrdata[3]+"/"+arrdata[0]+"\" target=\"_blank\">Tampilkan File</a>&nbsp;&bull;&nbsp;<a href=\"#\" class=\"del_upload\" url=\"<?php echo site_url(); ?>/utility/uploads/del_upload/"+arrdata[3]+"/"+arrdata[0]+"\" jns="+arrdata[2]+">Edit atau Hapus File ?</a><input type=\"hidden\" name=\"PEMERIKSAAN[FILE_"+arrdata[2]+"]\" value="+arrdata[0]+">");
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