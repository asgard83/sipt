<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR); ?>
<script type="text/javascript">
	function sel_klasifikasi(kk_id, periksa){
		if(kk_id=="") return false;
			$('#load_klas').load($('#sel_klas').attr('url') + kk_id +'/' +$(periksa).val());
		return false;
	}
	
	function do_upload(element){
		var allowed = $(element).attr("allowed");
		$("#indicator").ajaxStart(function(){
			jLoadingOpen('Upload File','SIPT Versi 1.0');
		}).ajaxComplete(function(){
			jLoadingClose();
		});
		$.ajaxFileUpload({
			url: $(element).attr("url")+'/'+allowed,
			secureuri: false,
			fileElementId: $(element).attr("id"),
			dataType: "json",
			success: function(data){
				var arrdata = data.msg.split("#");
				if(typeof(data.error) != "undefined"){
					if(data.error != ""){
						jAlert(data.error, "SIPT Versi 1.0");
					}else{
						if(arrdata[0] == "YES"){
							jAlert(arrdata[1], "SIPT Versi 1.0");
							window.location.reload(true);
						}else{
							jAlert(arrdata[1], "SIPT Versi 1.0");
							return false;
						}
					}
				}
			},
			error: function (data, status, e){
				jAlert(e, "SIPT Versi 1.0 Beta");
			}
		});
	}

</script>
<div id="judulpmnsarana" class="judul"></div>
    <div class="content">
    
        <div id="accordion">
            <h2 class="current"><?php echo $header; ?></h2>
            <form name="fproduk" id="fproduk" method="post" action="<?php echo $act; ?>" autocomplete="off">
                <table class="form_tabel">
                	<tr><td class="td_left">Klasifikasi Kategori</td><td class="td_right">
					<?php 
					if($seri != ""){
						echo "<b>".$sess['NAMA_KK']."</b>";
						?>
                        <input type="hidden" name="TEMUAN[KK_ID]" value="<?php echo $sess['KK_ID']; ?>" />
                        <?php
					}else{
						echo form_dropdown('TEMUAN[KK_ID]',$klasifikasi,$sel_kk,'class="stext" id="sel_klas" title="Pilih salah satu klasifikasi kategori produk" rel="required" url="'.site_url().'/load/utility/get_klasifikasi_produk/" onchange="sel_klasifikasi($(this).val(),\'#PERIKSA_ID\');"'); 
					}
					?></td></tr>
                </table>
                <div id="load_klas" style="margin-left:2px;"><?php echo $load_kk; ?></div>
                <div style="height:15px;"></div>
                <table class="form_tabel">
                	<tr><td colspan="2" class="atas isi">Catatan : </td></tr>
                	<tr><td colspan="2">Jika anda mengalami kesulitan dalam hal entri data temuan produk, anda bisa mengupload data temuan produk dalam format MS Excel. Format data dan petunjuk bisa anda download <a href="http://sipt.pom.go.id/download/manual/UPLOAD_EXCEL.rar">di sini</a></td></tr>
                	<tr><td class="td_left">Upload data temuan produk</td><td class="td_right"><input type="file" class="stext upload" allowed="xls" url="<?php echo site_url(); ?>/utility/uploads/upload_produk/<?php echo $id; ?>" id="fileToUpload_PRODUK" name="userfile" onchange="do_upload($(this)); return false;" title="Upload Data Temuan Produk"/>&nbsp;Tipe File : *.xls (File Format Excel 2003)</td></tr>
                </table>
				
                <div style="height:5px;"></div><div style="margin-left:5px;"><a href="#" class="button save" onclick="fpost('#fproduk','',''); return false;"><span><span class="icon"></span>&nbsp; <?php echo $save; ?> &nbsp;</span></a>&nbsp;<a href="#" class="button back" onclick="batal($(this)); return false;" id="selesai" url="<?php echo $url_selesai; ?>" ><span><span class="icon"></span>&nbsp; <?php echo $selesai; ?> &nbsp;</span></a></div>
                <input type="hidden" name="PERIKSA_ID" value="<?php echo $id; ?>" id="PERIKSA_ID" />
                <input type="hidden" name="URL" value="<?php echo $url_hidden; ?>" />            
                <input type="hidden" name="SERI" value="<?php echo $seri; ?>" />            
                </form>
                <div style="height:5px;"></div>
                <?php echo $produk; ?>
                <div style="height:5px;"></div>
           
        </div>
    
    </div>
</div>
