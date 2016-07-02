<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);
?>
<script type="text/javascript">
$(document).ready(function(){
	$("#jenis_pangan").autocomplete($("#jenis_pangan").attr("url"), {width: 244, selectFirst: false});
	$("#jenis_pangan").result(function(event, data, formatted){
		if(data){
			$(this).val(data[2]);
			$("#persentase").focus();
		}
	});
});
</script> 
<div id="judulmsarana" class="judul"></div>
<div class="content">
<form action="<?php echo $act; ?>" method="post" autocomplete="off" id="m_jenis">
<div class="adCntnr">
    <div class="acco2">
    
        <div class="expand"><a title="expand/collapse" href="#" style="display: block;">Master Sarana &raquo; Jenis Pangan Baru</a></div>
        <div class="collapse">
                <div class="accCntnt">
				<table class="form_tabel">
                	<tr><td class="td_left">Terdaftar / Tidak Terdaftar</td><td class="td_right"><?php echo form_dropdown('JENIS[JENIS]',$arr_jenis,$sess['JENIS'],'class="stext" title="Pilih jenis salah satu"'); ?></td></tr>
                	<tr><td class="td_left">Jenis Pangan</td><td class="td_right"><input type="text" name="JENIS[NAMA_JENIS]" class="stext" title="Nama Jenis Pangan" rel="required" value="<?php echo $sess['NAMA_JENIS']; ?>" id="jenis_pangan" url="<?php echo site_url(); ?>/autocompletes/automplete/jenis_pangan" /></td></tr>
                	<tr><td class="td_left">No. PIRT</td><td class="td_right"><input type="text" name="JENIS[NO_PIRT]" class="stext" title="No. PIRT" rel="required" value="<?php echo $sess['NO_PIRT']; ?>" /></td></tr>
                </table>
                </div>
		</div>
    	
        <div style="padding:10px;"></div><div><a href="#" class="button save" onclick="fpost('#m_jenis','',''); return false;"><span><span class="icon"></span>&nbsp; <?php echo $save; ?> &nbsp;</span></a>&nbsp;<a href="#" class="button reload" url="<?php echo $batal; ?>" onclick="batal($(this)); return false;" ><span><span class="icon"></span>&nbsp; <?php echo $cancel; ?> &nbsp;</span></a></div>

    </div>
</div>
<input type="hidden" name="ID" value="<?php echo $id; ?>" /><input type="hidden" name="SERI" value="<?php echo $seri; ?>" />
</form>
</div>




