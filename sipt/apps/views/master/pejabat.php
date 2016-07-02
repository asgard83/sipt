<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);
?>
<div id="judulpetugas" class="judul"></div>
<div class="content">
<form action="<?php echo $act; ?>" method="post" autocomplete="off" id="fpejabat">
<div class="adCntnr">
    <div class="acco2">
    
        <div class="expand"><b><?php echo $header; ?></b></div>
        <div class="collapse">
                <div class="accCntnt">
                <table class="form_tabel">
                <tr><td class="td_left">Nomor Induk Pegawai / NIP</td><td class="td_right"><input type="text" class="stext" name="PEJABAT[NIP]" title="Nomor Induk Pegawai" value="<?php echo $sess['NIP']; ?>" rel="required" onblur="noSpace($(this)); return false;" /></td></tr>
                <tr><td class="td_left">Nama Pejabat</td><td class="td_right"><input type="text" class="stext" name="PEJABAT[NAMA]" title="Nama Pejabat" value="<?php echo $sess['NAMA']; ?>" rel="required" /></td></tr>
                <tr><td class="td_left">Jabatan</td><td class="td_right"><input type="text" class="stext" name="PEJABAT[JABATAN]" title="Jabatan Pejabat" value="<?php echo $sess['JABATAN']; ?>" rel="required" /></td></tr>
                </table>
                </div>
		</div>
        <div style="padding:10px;"></div><div><a href="#" class="button save" onclick="fpost('#fpejabat','',''); return false;"><span><span class="icon"></span>&nbsp; <?php echo $save; ?> &nbsp;</span></a>&nbsp;<a href="#" class="button reload" url="<?php echo $batal; ?>" onclick="batal($(this)); return false;" ><span><span class="icon"></span>&nbsp; <?php echo $cancel; ?> &nbsp;</span></a></div>

    </div>
</div>
<input type="hidden" name="NIP" value="<?php echo $sess['NIP']; ?>" />
</form>
</div>




