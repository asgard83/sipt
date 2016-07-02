<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR);?>
<div id="juduldaerah" class="judul"></div>
<div class="content">
<form action="<?php echo $act; ?>" method="post" autocomplete="off" id="m_daerah">
<div class="adCntnr">
    <div class="acco2">
        <div class="expand"><b>Tambah Propinsi / Kota / Kabupaten Baru</b></div>
        <div class="collapse">
                <div class="accCntnt">
                <table class="form_tabel">
                  <tr><td class="td_left">Kode Propinsi / Kota / Kabupaten</td><td class="td_right"><input type="text" class="sdate" name="DAERAH[PROPINSI_ID]" rel="required" maxlength="4" title="Kode Propinsi / Kota / Kabupaten" value="<?php echo array_key_exists('PROPINSI_ID', $sess)?$sess['PROPINSI_ID']:$prop;  ?>" /></td></tr>
					<tr><td class="td_left">Nama Propinsi / Kota / Kabupaten</td><td class="td_right"><input type="text" class="stext" name="DAERAH[NAMA_PROPINSI]" rel="required" title="Nama Propinsi / Kota / Kabupaten" value="<?php echo $sess['NAMA_PROPINSI']; ?>" /></td></tr>
                </table>
                </div>
		</div>
        <div style="padding:10px;"></div><div><a href="#" class="button save" onclick="fpost('#m_daerah','',''); return false;"><span><span class="icon"></span>&nbsp; <?php echo $save; ?> &nbsp;</span></a>&nbsp;<a href="#" class="button reload" url="<?php echo $batal; ?>" onclick="batal($(this)); return false;" ><span><span class="icon"></span>&nbsp; <?php echo $cancel; ?> &nbsp;</span></a></div>

    </div>
</div>
<input type="hidden" name="ID" value="<?php echo $id; ?>" />
</form>
</div>
