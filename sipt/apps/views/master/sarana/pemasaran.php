<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);
?>
<script type="text/javascript">
$(document).ready(function(){
	$("#tujuan").change(function(){
		if($(this).val()=="Dalam Negeri"){
			$("#negara").val('Indonesia').attr("readonly","readonly");
		}else{
			$("#negara").val('').removeAttr("readonly");
		}
	});
	$("#negara").autocomplete($("#negara").attr("url"), {width: 244, selectFirst: false});
	$("#negara").result(function(event, data, formatted){
		if(data){
			$(this).val(data[2]);
			$("#persentase").focus();
		}
	});
	
});
</script> 
<div id="judulmsarana" class="judul"></div>
<div class="content">
<form action="<?php echo $act; ?>" method="post" autocomplete="off" id="m_pemasaran">
<div class="adCntnr">
    <div class="acco2">
    
        <div class="expand"><a title="expand/collapse" href="#" style="display: block;">Master Sarana &raquo; Hasil Pemasaran Baru</a></div>
        <div class="collapse">
                <div class="accCntnt">
				<table class="form_tabel">
                	<tr><td class="td_left">Tujuan Pemasaran</td><td class="td_right"><?php echo form_dropdown('PEMASARAN[TUJUAN]',$tujuan,$sess['TUJUAN'],'class="stext" id="tujuan" title="Pilih tujuan hasil pemasaran"'); ?></td></tr>
                    <tr><td class="td_left">Jenis Produk</td><td class="td_right"><input type="text" class="stext" name="PEMASARAN[JENIS_PRODUK]" value="<?php echo $sess['JENIS_PRODUK']; ?>" title="Jenis Produk yang dipasarkan" rel="required" /></td></tr>
                    <tr><td class="td_left">Negara Tujuan</td><td class="td_right"><input type="text" name="PEMASARAN[NEGARA]" class="stext" title="Negara tujuan hasil pemasaran" id="negara" rel="required" url="<?php echo site_url();?>/autocompletes/autocomplete/negara" value="<?php echo $sess['NEGARA']; ?>" /></td></tr>
                    <tr><td class="td_left">Persentase</td><td class="td_right"><input type="text" name="PEMASARAN[PERSENTASE]" class="stext sdate" title="Persentase hasil pemasaran. Pemisah decimal menggunakan titik. Contoh : 0.5 %" rel="required" id="persentase" value="<?php echo $sess['PERSENTASE']; ?>" />&nbsp;%</td></tr>
                </table>
                </div>
		</div>
    	
        <div style="padding:10px;"></div><div><a href="#" class="button save" onclick="fpost('#m_pemasaran','',''); return false;"><span><span class="icon"></span>&nbsp; <?php echo $save; ?> &nbsp;</span></a>&nbsp;<a href="#" class="button reload" url="<?php echo $batal; ?>" onclick="batal($(this)); return false;" ><span><span class="icon"></span>&nbsp; <?php echo $cancel; ?> &nbsp;</span></a></div>

    </div>
</div>
<input type="hidden" name="ID" value="<?php echo $id; ?>" /><input type="hidden" name="SERI" value="<?php echo $seri; ?>" />
</form>
</div>




