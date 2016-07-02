<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR);?>
<link type="text/css" href="<?php echo base_url();?>css/css.css" rel="stylesheet" />	
<form id="fupdate-lcp" action="<?php echo $act; ?>"	autocomplete="off" name="fupdate-lcp" method="post">
<table class="listtemuan" width="100%">
	<tr style="background:#e7e7e7;">
		<td width="300"><b>Parameter Uji</b></td>
		<td width="100"><b>Metode</b></td>
		<td width="350"><b>Pustaka</b></td>
		<td width="100"><b>Syarat</b></td>
	</tr>
	<tr>
		<td><?php echo $sess['PARAMETER_UJI']; ?></td>
		<td><?php echo $sess['METODE']; ?></td>
		<td><?php echo $sess['PUSTAKA']; ?></td>
		<td><?php echo $sess['SYARAT']; ?></td>
	</tr>
</table>
<div style="height:5px;">&nbsp;</div>
<table class="form_tabel">
	<tr>
		<td class="td_left">Mulai Diuji </td>
		<td class="td_right"><?php echo $sess['AWAL_UJI']; ?></td>
		<td></td>
		<td class="td_left">Selesai Diuji</td>
		<td class="td_right"><?php echo $sess['AKHIR_UJI']; ?></td>
	</tr>
	<tr>
		<td class="td_left">Jumlah Sampel</td>
		<td colspan="4" class="td_right"><div style="padding-bottom:5px;"><span>Diuji </span><span style="margin-left:39px;"><?php echo $sess['JUMLAH_UJI']; ?></td>
	</tr>
	<tr>
		<td class="td_left">Hasil Kualitatif</td>
		<td class="td_right"><?php echo $sess['HASIL']; ?></td>
		<td></td>
		<td class="td_left">Hasil Kuantitatif</td>
		<td class="td_right"><?php echo $sess['HASIL_KUALITATIF']; ?></td>
	</tr>
	<tr>
		<td class="td_left">LCP</td>
		<td class="td_right" colspan="4">
        <?php
		if(trim($sess['LCP']) == 0){
			?>
				<span class="upload_LCP<?php echo $sess['UJI_ID']; ?>"><input type="file" class="stext upload" allowed="xls-doc-xlsx-docx-pdf-rar-zip" ke="<?php echo $sess['UJI_ID']; ?>" url="<?php echo site_url(); ?>/utility/uploads/set_lcp/<?php echo $sess['KODE_SAMPEL'];?>" id="fileToUpload_LCP<?php echo $sess['UJI_ID']; ?>" title="File Lampiran Catatan Pengujian" name="userfile" onchange="do_upload($(this)); return false;"/>&nbsp; <div>Tipe File : *.xls, *.xlsx, *.doc, *.docx, *.rar, *.zip, *.pdf</div></span><span class="file_LCP<?php echo $sess['UJI_ID']; ?>"></span>
			<?php
		}else{
			?>
            <p>LCP terlampir, atau checklist</p>
            <p style="padding-top:5px;"><input type="checkbox" name="chk_lampiran" value="1"/>&nbsp; untuk membatalkan / hapus LCP</p>
			<?php
		}
		?>
		</td>
	</tr>
</table>
<input type="hidden" name="KODE_SAMPEL" value="<?php echo $sess['KODE_SAMPEL']; ?>">
<input type="hidden" name="UJI_ID" value="<?php echo $sess['UJI_ID']; ?>">
</form>
<div style="padding:1px;">&nbsp;</div>
<div style="padding-left:5px;">
	<a href="#" class="button save" onclick="save_edit('#fupdate-lcp'); return false;"><span><span class="icon"></span>&nbsp; Proses &nbsp;</span></a>
</div>
<div style="padding:2px;">&nbsp;</div>

<script>
	$(document).ready(function(){
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
						$(".upload_LCP"+ke+"").hide();
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