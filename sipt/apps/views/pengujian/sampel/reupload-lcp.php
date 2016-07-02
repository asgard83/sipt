<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR);?>
<link type="text/css" href="<?php echo base_url();?>css/css.css" rel="stylesheet" />
<form name="fedit-penyelia" id="fedit-upload-mapping" method="post" action="<?php echo $act; ?>" autocomplete="off">
  <input type="hidden" name="PERIKSA_ID" value="<?php echo $sess['PERIKSA_ID']; ?>" />
  <table class="form_tabel" width="100%">
    <tr>
      <td class="td_left">Nama Sarana</td>
      <td class="td_right"><?php echo $sess['NAMA_SARANA']; ?></td>
    </tr>
    <tr>
      <td class="td_left">Tanggal Pemeriksaan</td>
      <td class="td_right"><?php echo $sess['AWAL_PERIKSA']; ?>&nbsp;sampai dengan&nbsp;<?php echo $sess['AKHIR_PERIKSA']; ?></td>
    </tr>
    <tr>
      <td class="td_left">Tujuan Pemeriksaan</td>
      <td class="td_right"><?php echo $sess['TUJUAN_PEMERIKSAAN']; ?></td>
    </tr>
    <tr>
      <td class="td_left">Hasil Pemeriksaan</td>
      <td class="td_right"><?php echo $sess['URAIAN']; ?></td>
    </tr>
    <tr>
      <td class="td_left">File Lampiran Mapping</td>
      <td class="td_right"><span class="upload_LAMPIRAN_MAPPING">
        <input type="file" class="stext upload" jenis="LAMPIRAN_MAPPING" allowed="rar-zip" url="<?php echo site_url(); ?>/utility/uploads/get_upload/<?php echo $sess['SARANA_ID'];?>" id="fileToUpload_LAMPIRAN_MAPPING" rel="required" title="File lampiran mapping" name="userfile" onchange="do_upload_mapping($(this)); return false;"/>&nbsp;Tipe File : *.rar, *.zip</span><span class="file_LAMPIRAN_MAPPING"></span></td>
    </tr>
    <tr>
      <td class="td_left" colspan="2"><p>Keterangan : </p>
        <p>Attachment wajib melampirkan :</p>
        <p>1. BAP</p>
        <p>2. Checklist</p>
        <p>3. Rekap Penilaian</p>
        <p>Ketiga file tersebut disatukan dalam satu folder, kemudian folder tersebut <i>compress</i> menjadi file <b>*.RAR</b> atau <b>*.ZIP</b></p></td>
    </tr>
  </table>
  <div style="height:10px;">&nbsp;</div>
  <div style="padding-left:5px;"><a href="#" class="button save" onclick="save_edit('#fedit-upload-mapping'); return false;"><span><span class="icon"></span>&nbsp; Re-upload &nbsp;</span></a></div>
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
	
	function do_upload_mapping(element){
		var jenis = $(element).attr("jenis");
		var allowed = $(element).attr("allowed");
		if ($("#progress").length === 0) {
			$("body").append($("<div></div>").attr("id", "progress"));
		}
		$("#progress").ajaxStart(function(){
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
						$(".file_"+arrdata[2]+"").html("<b>1 File telah dilampirkan. </b>&nbsp;<a href=\"<?php echo base_url(); ?>files/"+arrdata[3]+"/"+arrdata[0]+"\" target=\"_blank\">Tampilkan File</a>&nbsp;&bull;&nbsp;<a href=\"#\" class=\"del_upload\" url=\"<?php echo site_url(); ?>/utility/uploads/del_upload/"+arrdata[3]+"/"+arrdata[0]+"\" jns="+arrdata[2]+">Edit atau Hapus File ?</a><input type=\"hidden\" name=\"PEMERIKSAAN_DISTRIBUSI["+arrdata[2]+"]\" value="+arrdata[0]+">");
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