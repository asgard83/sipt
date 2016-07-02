<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);
?>
<script type="text/javascript">
$(document).ready(function(){
});
</script> 
<div id="judulmsarana" class="judul"></div>
<div class="content">
<form action="<?php echo $act; ?>" method="post" autocomplete="off" id="m_izin">
<div class="adCntnr">
    <div class="acco2">
    
        <div class="expand"><a title="expand/collapse" href="#" style="display: block;">Master Sarana &raquo; Izin Industri / Izin Produksi Baru</a></div>
        <div class="collapse">
                <div class="accCntnt">
				<table class="form_tabel">
                	<tr><td class="td_left">Jenis Izin</td><td class="td_right"><?php echo form_dropdown('IZIN[JENIS_IZIN]',$jenis_izin,$sess['JENIS_IZIN'],'class="stext" title="Jenis Izin yang dimiliki." id="jenis_izin"'); ?></td></tr>
                	<tr><td class="td_left">Nomor Izin</td><td class="td_right"><input type="text" name="IZIN[NOMOR_IZIN]" class="stext" title="Nomor izin industri atau produksi" rel="required" value="<?php echo $sess['NOMOR_IZIN']; ?>" /></td></tr>
                	<tr><td class="td_left">Bentuk Sediaan</td><td class="td_right"><input type="text" name="IZIN[BENTUK_SEDIAAN]" class="stext" title="Bentuk sediaan. Jika tidak ada, cukup dengan tanda - (strip)" rel="required" value="<?php echo $sess['BENTUK_SEDIAAN']; ?>" /></td></tr>
                	<tr><td class="td_left">Jenis Sediaan</td><td class="td_right"><input type="text" name="IZIN[JENIS_SEDIAAN]" class="stext" title="Jenis sediaan. Jika tidak ada, cukup dengan tanda - (strip)" rel="required" value="<?php echo $sess['JENIS_SEDIAAN']; ?>" /></td></tr>
                    <tr><td class="td_left">Tanggal Izin Berlaku</td><td class="td_right"><input type="text" class="stext sdate" name="IZIN[TANGGAL_IZIN]" value="<?php echo $sess['TANGGAL_IZIN']; ?>" title="Tanggal izin di keluarkan. Format : dd/mm/yyyy" rel="required" /></td></tr>
                    <tr><td class="td_left">Masa Izin Berlaku</td><td class="td_right"><input type="text" name="IZIN[TANGGAL_EXPIRED]" class="stext sdate" title="Masa berlaku izin. Format : dd/mm/yyyy" value="<?php echo $sess['TANGGAL_EXPIRED']; ?>" rel="required" /></td></tr>
                </table>
                </div>
		</div>
    	
        <div style="padding:10px;"></div><div><a href="#" class="button save" onclick="fpost('#m_izin','',''); return false;"><span><span class="icon"></span>&nbsp; <?php echo $save; ?> &nbsp;</span></a>&nbsp;<a href="#" class="button reload" url="<?php echo $batal; ?>" onclick="batal($(this)); return false;" ><span><span class="icon"></span>&nbsp; <?php echo $cancel; ?> &nbsp;</span></a></div>

    </div>
</div>
<input type="hidden" name="ID" value="<?php echo $id; ?>" /><input type="hidden" name="SERI" value="<?php echo $seri; ?>" />
</form>
</div>




