<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR); ?>
<style>
.hideme {
	display: none;
}
</style>
<div id="juduluji" class="judul"></div>
<div class="content">
  <form action="<?php echo $act; ?>" method="post" autocomplete="off" id="edm_golonganspesifik" name="edm_golonganspesifik">
    <div class="adCntnr">
      <div class="acco2">
        <div class="expand"><b>Edit Golongan Spesifik Lokal</b></div>
        <div class="collapse">
          <div class="accCntnt">
            <table class="form_tabel">
              <tr>
                <td class="td_left">Komoditi</td>
                <td class="td_right"><?= $sess['UR_KOMODITI']; ?></td>
              </tr>
              <tr <?php echo (strlen($sess['KATEGORI']) == 4) ? '' : 'class="hideme"' ;?> id="tdanak1" ke="1">
                <td class="td_left">Sub Kategori</td>
                <td class="td_right"><?= $sess['UR_KATEGORI']; ?></td>
              </tr>
              <tr <?php echo strlen($sess['SUB_KATEGORI']) == 6 ? '' : 'class="hideme"' ;?> id="tdanak2" ke="2">
                <td class="td_left">&nbsp;</td>
                <td class="td_right"><?= $sess['UR_SUB_KATEGORI']; ?></td>
              </tr>
              <tr <?php echo strlen($sess['SUB_SUB_KATEGORI']) == 8 ? '' : 'class="hideme"' ;?> id="tdanak3" ke="3">
                <td class="td_left">&nbsp;</td>
                <td class="td_right"><?= $sess['UR_SUB_SUB_KATEGORI']; ?></td>
              </tr>
              <tr <?php echo strlen($sess['SUB_SUB_SUB_KATEGORI']) == 10 ? '' : 'class="hideme"' ;?> id="tdanak4" ke="4">
                <td class="td_left">&nbsp;</td>
                <td class="td_right"><?= $sess['UR_SUB_SUB_SUB_KATEGORI']; ?></td>
              </tr>
              <tr>
                <td class="td_left">&nbsp;</td>
                <td class="td_right"><input type="text" name="KLASIFIKASI" class="stext" title="Edit Kategori, Golongan, Zat Aktif, Bentuk Sediaan" value="<?= end($uraian); ?>" rel="required" /></td>
              </tr>
            </table>
          </div>
        </div>
      </div>
      <div style="padding:10px;"></div>
      <div><a href="#" class="button save" onclick="fpost('#edm_golonganspesifik','',''); return false;"><span><span class="icon"></span>&nbsp; <?php echo $save; ?> &nbsp;</span></a>&nbsp;<a href="#" class="button reload" onclick="window.history.back();return false;" ><span><span class="icon"></span>&nbsp; <?php echo $cancel; ?> &nbsp;</span></a></div>
    </div>
    <div style="padding:10px;"></div>
    <input type="hidden" name="KLASIFIKASI_ID" value="<?= $sess['KLASIFIKASI_ID'];  ?>" />
  </form>
</div>