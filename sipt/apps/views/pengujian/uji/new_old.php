<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR); ?>
<div id="juduluji" class="judul"></div>
<div class="headersarana"><?php echo $judul; ?></div>
<div class="content">
    <div class="adCntnr">
    	<div class="acco2">
        	<div class="expand"><a title="expand/collapse" href="#" style="display: block;">PENGUJIAN</a></div>
                <div class="accCntnt">
                <h2 class="small garis">Informasi Sampel</h2>
				<form name="fuji" id="fuji" method="post" action="<?php echo $act; ?>" autocomplete="off">
				<table class="form_tabel">
					<tr>
						<td class="td_left">Kode Sampel</td><td class="td_right" width="300"><b><?php echo $kode_sampel ?></b></td>
					</tr>
				</table>
			    <div style="height:5px;">&nbsp;</div>		
                <h2 class="small garis">Standar Ruang Lingkup Pengujian</h2>
				<table class="form_tabel">
					<tr>
						<td class="td_left">Parameter Uji</td><td class="td_right"><?php echo $sess['PARAMETER_UJI'];  ?></td>
					</tr>
					<tr>
						<td class="td_left">Metode</td><td class="td_right"><?php echo $sess['METODE']; ?></td>
					</tr>
					<tr>
						<td class="td_left">Pustaka</td><td class="td_right"><?php echo $sess['PUSTAKA']; ?></td>
				  	</tr>
				  	<tr>
						<td class="td_left">Syarat</td><td class="td_right" width="300"><?php echo $sess['SYARAT'];  ?></td>
				  	</tr>
				</table>
			    <div style="height:5px;">&nbsp;</div>		
                <h2 class="small garis">Hasil Pengujian</h2>
				<table class="form_tabel">
				<tr>
				  <td class="td_left">Mulai Diuji </td>
				  <td class="td_right"><input type="hidden" name="UJI[AWAL_UJI]" value="<?php echo $sess['AWAL_UJI']; ?>" /><?php echo $sess['AWAL_UJI']; ?></td>
				  <td></td>
				  <td class="td_left">Selesai Diuji</td>
				  <td class="td_right"><input type="text" class="sdate datepick" title="Selesai Di Uji" name="UJI[AKHIR_UJI]" value="<?php echo $sess['AKHIR_UJI']; ?>" rel="required" /></td>
				  </tr>
				<tr>
				  <td class="td_left">Jumlah Sampel</td>
				  <td colspan="4" class="td_right">
				  	<div style="padding-bottom:5px;"><span>Diterima </span><span style="margin-left:20px;"><input type="text" class="sdate" title="Jumlah sampel yang diterima" value="<?php echo in_array('B1',$this->newsession->userdata('SESS_SUB_SARANA')) || in_array('B2',$this->newsession->userdata('SESS_SUB_SARANA')) ? $sess['JUMLAH_KIMIA'] : $sess['JUMLAH_MIKRO']; ?>" readonly="readonly" id="jawal"/>&nbsp; <?php echo $sess['SATUAN']; ?></span></div>
					<div style="padding-bottom:5px;"><span>Diuji </span><span style="margin-left:39px;"><input type="text" class="sdate" title="Jumlah sampel yang diuji" name="UJI[JUMLAH_UJI]" value="<?php echo $sess['JUMLAH_UJI']; ?>" id="jpakai" onkeyup="numericOnly($(this))"/></span></div>
					<div style="padding-bottom:5px;"><span>Sisa</span><span style="margin-left:40px;">
					<input type="text" class="sdate" title="Jumlah retain sampel" name="SISA" value="<?php echo in_array('B1',$this->newsession->userdata('SESS_SUB_SARANA')) || in_array('B2',$this->newsession->userdata('SESS_SUB_SARANA')) ? $sess['SISA_KIMIA'] : $sess['SISA_MIKRO']; ?>" readonly="readonly" id="jsisa"/></span></div>
					</td>
				  </tr>
				<tr>
				  <td class="td_left">Pemerian</td>
				  <td class="td_right">
				  <?php
				  if($pemerian==""){
				  ?>
				  <textarea class="stext" name="PEMERIAN" rel="required" title="Pemerian" style="height:80px;"><?php echo $sess['PEMERIAN']; ?></textarea>
				  <?php
				  }else{
				  	echo $sess['PEMERIAN'];
				  }?>				  </td><td width="10"></td>
				  <td class="td_left">Hasil Kualitatif</td>
				  <td class="td_right"><textarea class="stext" name="UJI[HASIL]" rel="required" title="Hasil Kualitatif" style="height:80px;"><?php echo $sess['IDENTIFIKASI']; ?></textarea></td>
				  </tr>
				<tr>
				  <td class="td_left">&nbsp;</td>
				  <td class="td_right">&nbsp;</td>
				  <td></td>
				  <td class="td_left">Hasil Kuantitatif</td>
				  <td class="td_right"><textarea class="stext" name="UJI[HASIL_KUALITATIF]" rel="required" title="Hasil Kuantitatif" style="height:80px;"><?php echo $sess['HASIL_KUALITATIF']; ?></textarea></td>
				  </tr>
				<tr>
				  <td class="td_left">LCP</td>
				  <td class="td_right"><span class="upload_LCP"><input type="file" class="stext upload" jenis="LCP" allowed="xls-doc-xlsx-docx-pdf-rar-zip" url="<?php echo site_url(); ?>/utility/uploads/set_lcp/<?php echo $sess['KODE_SAMPEL'];?>" id="fileToUpload_LCP" title="File Lampiran Catatan Pengujian" name="userfile" rel="required" onchange="do_upload($(this)); return false;"/>&nbsp;<div>Tipe File : *.xls, *.xlsx, *.doc, *.docx, *.rar, *.zip, *.pdf</div></span><span class="file_LCP"></span></td>
				  <td></td>
				  <td class="td_left">&nbsp;</td>
				  <td class="td_right">&nbsp;</td>
				  </tr>
				</table>
				<input type="hidden" name="UJI_ID" value="<?php echo $sess['UJI_ID']; ?>" />
				<input type="hidden" name="KODE_SAMPEL" value="<?php echo $sess['KODE_SAMPEL']; ?>" />
				<input type="hidden" name="SPK_ID" value="<?php echo $sess['SPK_ID']; ?>" />
                </form>
            </div>
        </div>
			  
		<div style="height:10px;">&nbsp;</div>		
		<div style="padding-left:5px;"><a href="#" class="button check" onclick="fpost('#fuji','',''); return false;"><span><span class="icon"></span>&nbsp; Proses &nbsp;</span></a>&nbsp;<a href="#" class="button reload" url="<?php echo $batal; ?>" onclick="batal($(this)); return false;"><span><span class="icon"></span>&nbsp; Batal &nbsp;</span></a></div>
		<div style="height:10px;">&nbsp;</div>		
				
    </div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$('input.datepick').datepicker({ dateFormat: 'dd/mm/yy',regional: 'id'});
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
	    $("#jpakai").change(function(){
			var sisa = 0;
			var jawal = parseInt($("#jawal").val());
			var jpakai = parseInt($("#jpakai").val());
			var jsisa = parseInt($("#jsisa").val());
			if(jsisa <= 0){
				if(jpakai > jawal){
					jAlert('Jumlah sampel yang di uji melebihi jumlah sampel yang diterima','SIPT versi 1.0');
					$("#jpakai").focus();
					$("#jpakai").val('0');
					$("#jsisa").val(jsisa);
					return false;
				}
				if(jsisa < 0){
					jAlert('Jumlah sisa sampel tidak mencukupi','SIPT versi 1.0');
					$("#jpakai").focus();
					$("#jpakai").val('0');
					$("#jsisa").val(jsisa);
					return false;
				}
				sisa = parseInt(jawal - jpakai);
				if(sisa < 0) sisa = 0;
				$("#jsisa").val(parseInt(sisa));
			}else{
				sisa = parseInt(jsisa - jpakai);
				if(jpakai > jsisa){
					jAlert('Jumlah uji melebihi sisa sampel','SIPT versi 1.0');
					$("#jpakai").focus();
					$("#jpakai").val('0');
					return false;
				}else{
					if(sisa < 0) sisa = 0;
					$("#jsisa").val(parseInt(sisa));
				}
			}
		});
	});
	
	function do_upload(element){
		var jenis = $(element).attr("jenis");
		var allowed = $(element).attr("allowed");
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
						$(".file_"+arrdata[2]+"").html("<b>1 File telah dilampirkan. </b>&nbsp;<a href=\"<?php echo base_url(); ?>files/LCP/"+arrdata[3]+"/"+arrdata[0]+"\" target=\"_blank\">Tampilkan File</a>&nbsp;&bull;&nbsp;<a href=\"#\" class=\"del_upload\" url=\"<?php echo site_url(); ?>/utility/uploads/del_upload/"+arrdata[3]+"/"+arrdata[0]+"\" jns="+arrdata[2]+">Edit atau Hapus File ?</a><input type=\"hidden\" name=\"UJI["+arrdata[2]+"]\" value="+arrdata[0]+">");
					}
				}
			},
			error: function (data, status, e){
				jAlert(e, "SIPT Versi 1.0 Beta");
			}
		});
	}
</script>