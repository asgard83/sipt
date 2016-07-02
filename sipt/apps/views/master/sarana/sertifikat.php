<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);
?>
<script type="text/javascript">
$(document).ready(function(){
});
</script> 
<div id="judulmsarana" class="judul"></div>
<div class="content">
<form action="<?php echo $act; ?>" method="post" autocomplete="off" id="m_sertifikat">
<div class="adCntnr">
    <div class="acco2">
    
        <div class="expand"><a title="expand/collapse" href="#" style="display: block;">Master Sarana &raquo; Sertifikat Baru</a></div>
        <div class="collapse">
                <div class="accCntnt">
				<table class="form_tabel">
                	<tr><td class="td_left">Jenis Sertifikat</td><td class="td_right"><?php echo form_dropdown('SERTIFIKAT[JENIS]',$jenis_sertifikat,$sess['JENIS'],'class="stext" id="tujuan" title="Pilih jenis sertifikat"'); ?></td></tr>
                	<tr><td class="td_left">Nomor Sertifikat</td><td class="td_right"><input type="text" name="SERTIFIKAT[NOMOR_SERTIFIKAT]" class="stext" title="Nomor Sertifikat" rel="required" value="<?php echo $sess['NOMOR_SERTIFIKAT']; ?>" /></td></tr>
                	<tr><td class="td_left">Bentuk Sediaan</td><td class="td_right"><input type="text" name="SERTIFIKAT[BENTUK_SEDIAAN]" class="stext" title="Bentuk sediaan. Jika tidak ada, cukup dengan tanda - (strip)" rel="required" value="<?php echo $sess['BENTUK_SEDIAAN']; ?>" /></td></tr>
                    <tr><td class="td_left">Tanggal Sertifikat</td><td class="td_right"><input type="text" class="stext sdate" name="SERTIFIKAT[TANGGAL_SERTIFIKAT]" value="<?php echo $sess['TANGGAL_SERTIFIKAT']; ?>" title="Tanggal sertifikat di keluarkan. Format : dd/mm/yyyy" rel="required" /></td></tr>
                    <tr><td class="td_left">Dikeluarkan Oleh </td><td class="td_right"><input type="text" name="SERTIFIKAT[PEMBERI_SERTIFIKAT]" class="stext" title="Dikeluarkan oleh, instansi atau lembaga mana" value="<?php echo $sess['PEMBERI_SERTIFIKAT']; ?>" rel="required" /></td></tr>
                </table>
                </div>
		</div>
    	
        <div style="padding:10px;"></div><div><a href="#" class="button save" onclick="fpost('#m_sertifikat','',''); return false;"><span><span class="icon"></span>&nbsp; <?php echo $save; ?> &nbsp;</span></a>&nbsp;<a href="#" class="button reload" url="<?php echo $batal; ?>" onclick="batal($(this)); return false;" ><span><span class="icon"></span>&nbsp; <?php echo $cancel; ?> &nbsp;</span></a></div>

    </div>
</div>
<input type="hidden" name="ID" value="<?php echo $id; ?>" /><input type="hidden" name="SERI" value="<?php echo $seri; ?>" />
</form>
</div>




