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
    
        <div class="expand"><a title="expand/collapse" href="#" style="display: block;">Master Sarana &raquo; Golongan Sarana Baru</a></div>
        <div class="collapse">
                <div class="accCntnt">
				<table class="form_tabel">
                	<tr><td class="td_left">Bertindak Sebagai</td><td class="td_right"><?php echo form_dropdown('GOLONGAN[BERTINDAK_SEBAGAI]',$arr_sebagai,$sess['BERTINDAK_SEBAGAI'],'class="stext" title="Pilih salah satu opsi"'); ?></td></tr>
                	<tr><td class="td_left">Nama</td><td class="td_right"><input type="text" name="GOLONGAN[NAMA]" class="stext" title="Penjalasan Nama bertindak sebagai" rel="required" value="<?php echo $sess['NAMA']; ?>" /></td></tr>
                    <tr><td class="td_left">Alamat</td><td class="td_right"><textarea class="stext" title="Penjelasan Alamat bertindak sebagai" name="GOLONGAN[ALAMAT]"><?php echo $sess['ALAMAT']; ?></textarea></td></tr>
                </table>
                </div>
		</div>
    	
        <div style="padding:10px;"></div><div><a href="#" class="button save" onclick="fpost('#m_sertifikat','',''); return false;"><span><span class="icon"></span>&nbsp; <?php echo $save; ?> &nbsp;</span></a>&nbsp;<a href="#" class="button reload" url="<?php echo $batal; ?>" onclick="batal($(this)); return false;" ><span><span class="icon"></span>&nbsp; <?php echo $cancel; ?> &nbsp;</span></a></div>

    </div>
</div>
<input type="hidden" name="ID" value="<?php echo $id; ?>" /><input type="hidden" name="SERI" value="<?php echo $seri; ?>" />
</form>
</div>




