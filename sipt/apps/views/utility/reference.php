<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR);?>
<div id="<?php echo $idjudul; ?>" class="judul"></div>
<div class="content">
<form action="<?php echo $act; ?>" method="post" autocomplete="off" id="form-reference">
<div class="adCntnr">
    <div class="acco2">
        <div class="expand"><b>Referensi FAQ</b></div>
        <div class="collapse">
                <div class="accCntnt">
                <table class="form_tabel">
                    <tr><td class="td_left">Jenis Pelaporan</td><td><?php echo form_dropdown('REFERENCE[JENIS]',$pelaporan,$sess['JENIS'],'class="stext" wajib="yes" rel="required" title="Jenis Pelaporan"'); ?></td></tr>
                    <tr><td class="td_left">Uraian Referensi</td><td><textarea class="stext" wajib="yes" title="Uraian Referensi" rel="required" name="REFERENCE[URAIAN]"><?php echo $sess['URAIAN']; ?></textarea></td></tr>
                </table>
                </div>
		</div>        
        <div style="height:10px"></div>
        <div><a href="#" class="button save" onclick="fpost('#form-reference','',''); return false;"><span><span class="icon"></span>&nbsp; Simpan &nbsp;</span></a>&nbsp;<a href="#" class="button back" url="<?php echo $back; ?>" onclick="batal($(this)); return false;"><span><span class="icon"></span>&nbsp; Batal &nbsp;</span></a></div> 
    </div>
</div>
<?php
if(array_key_exists('KODE', $sess)){
	?>
    <input type="hidden" name="KODE" value="<?php echo $sess['KODE']; ?>" />
    <?
}
?>
</form>
</div>
