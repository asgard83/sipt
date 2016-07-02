<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR); ?>
<div id="judulpetugas" class="judul"></div>
<div class="content">
    <form action="<?php echo $act; ?>" method="post" autocomplete="off" id="m_pelanggaran">
        <div class="adCntnr">
        	<div class="acco2">
            	<div class="expand"><b>Jenis Pelanggaran - Kriteria Tindak Lanjut NAPZA</b></div>
                <div class="collapse">
                	<div class="accCntnt">
                    <table class="form_tabel">
                      <tr><td class="td_left">Jenis Sarana</td><td class="td_right"><?php echo form_dropdown('PELANGGARAN[JENIS_SARANA]',$jenis_sarana,$sess['JENIS_SARANA'],'class="stext" rel="required" title="Jenis Sarana"',$disinput); ?></td></tr>
                      <tr><td class="td_left">Aspek</td><td class="td_right"><?php echo form_dropdown('PELANGGARAN[ASPEK]',$aspek,$sess['ASPEK'],'class="stext" rel="required" title="Aspek pelanggaran"'); ?></td></tr>
                      <tr><td class="td_left">Jenis Pelanggaran</td><td class="td_right"><textarea class="stext catatan" title="Jenis Pelanggaran" name="PELANGGARAN[JENIS_PELANGGARAN]"><?php echo $sess['JENIS_PELANGGARAN']; ?></textarea></td></tr>
                      <tr><td class="td_left">Jenis Penyimpangan</td><td class="td_right"><textarea class="stext catatan" title="Jenis Penyimpangan" name="PELANGGARAN[JENIS_PENYIMPANGAN]"><?php echo $sess['JENIS_PENYIMPANGAN']; ?></textarea></td></tr>
                      <tr><td class="td_left">Jenis Kriteria Pelanggaran</td><td class="td_right"><?php echo form_dropdown('PELANGGARAN[JENIS_KRITERIA_PELANGGARAN]',$kriteria,$sess['JENIS_KRITERIA_PELANGGARAN'],'class="stext" rel="required" title="Jenis Sarana"'); ?></td></tr>
                      <tr><td class="td_left">Klasifikasi Produk</td><td class="td_right"><?php echo form_dropdown('KLASIFIKASI[]',$kk_id,$sel_kk,'class="stext multiselect" id="klasifikasi" multiple rel="required" title="Klasifikasi produk"'); ?></td></tr>
                    </table>
                    <div style="padding:10px;"></div><div><a href="#" class="button save" onclick="fpost('#m_pelanggaran','',''); return false;"><span><span class="icon"></span>&nbsp; <?php echo $save; ?> &nbsp;</span></a>&nbsp;<a href="#" class="button reload" url="<?php echo $batal; ?>" onclick="batal($(this)); return false;" ><span><span class="icon"></span>&nbsp; <?php echo $cancel; ?> &nbsp;</span></a></div>                  
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" name="ID" value="<?php echo $id; ?>" />
    </form>
</div>