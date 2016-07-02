<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR); ?>
<div id="judulpetugas" class="judul"></div>
<div class="content">
    <form action="<?php echo $act; ?>" method="post" autocomplete="off" id="m_verifikasi">
        <div class="adCntnr">
        	<div class="acco2">
            	<div class="expand"><b>Verifikasi Dokumen Pemeriksaan</b></div>
                <div class="collapse">
                	<div class="accCntnt">
                    <table class="form_tabel">
                      <tr><td class="td_left">Jenis Pelaporan</td><td class="td_right"><?php echo form_dropdown('VERIFIKASI[PELAPORAN_ID]', $jenis_pelaporan, $sess['PELAPORAN_ID'],'class="stext" id="jenis_pelaporan" rel="required" title="Pilih Jenis Pelaporan"'); ?></td></tr>
                      <tr><td class="td_left">Role</td><td class="td_right"><?php echo form_dropdown('VERIFIKASI[ROLE_ID]', $role, $sess['ROLE_ID'],'class="stext" id="role" rel="required" title="Pilih Role Petugas"'); ?></td></tr>
                      <tr><td class="td_left">Dokumen Sebelum Proses</td><td class="td_right"><?php echo form_dropdown('VERIFIKASI[SEBELUM]', $sebelum, $sess['SEBELUM'],'class="stext" id="sebelum" rel="required" title="Status sebelum di verifikasi"'); ?></td></tr>
                      <tr><td class="td_left">Proses Verifikasi</td><td class="td_right"><?php echo form_dropdown('VERIFIKASI[PROSES]', $proses, $sess['PROSES'],'class="stext" id="proses" rel="required" title="Pilih Proses verifikasi"'); ?></td></tr>
                      <tr><td class="td_left">Dokumen Sesudah Proses</td><td class="td_right"><?php echo form_dropdown('VERIFIKASI[SESUDAH]', $sesudah, $sess['SESUDAH'],'class="stext" id="sesudah" rel="required" title="Status sesudah di verifikasi"'); ?></td></tr>
                    </table>
                    <div style="padding:10px;"></div><div><a href="#" class="button save" onclick="fpost('#m_verifikasi','',''); return false;"><span><span class="icon"></span>&nbsp; <?php echo $save; ?> &nbsp;</span></a>&nbsp;<a href="#" class="button reload" url="<?php echo $batal; ?>" onclick="batal($(this)); return false;" ><span><span class="icon"></span>&nbsp; <?php echo $cancel; ?> &nbsp;</span></a></div>                  
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" name="ID" value="<?php echo $id; ?>" />
    </form>
</div>