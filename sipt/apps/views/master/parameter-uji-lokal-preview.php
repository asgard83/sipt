<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR); ?>
<style>
.hideme {
	display: none;
}
</style>
<div id="juduluji" class="judul"></div>
<div class="content">
  <form action="<?php echo $act; ?>" method="post" autocomplete="off" id="m_srl">
    <div class="adCntnr">
      <div class="acco2">
        <div class="expand"><b>Standar Ruang Lingkup Pengujian</b></div>
        <div class="collapse">
          <div class="accCntnt">
            <table class="form_tabel">
              <tr>
                <td class="td_left">Bidang Pengujian</td>
                <td class="td_right"><?= $sess['BIDANG_UJI']; ?></td>
              </tr>
              <tr>
                <td class="td_left">Komoditi</td>
                <td class="td_right"><?= $sess['UR_KOMODITI']; ?></td>
              </tr>
              <tr <?php echo (strlen($sess['UR_KATEGORI']) > 0) ? '' : 'class="hideme"' ;?> id="tdanak1" ke="1">
                <td class="td_left">Sub Kategori</td>
                <td class="td_right"><?= $sess['UR_KATEGORI']; ?></td>
              </tr>
              <tr <?php echo strlen($sess['UR_SUB_KATEGORI']) > 0 ? '' : 'class="hideme"' ;?> id="tdanak2" ke="2">
                <td class="td_left">&nbsp;</td>
                <td class="td_right"><?= $sess['UR_SUB_KATEGORI']; ?></td>
              </tr>
              <tr <?php echo strlen($sess['UR_SUB_SUB_KATEGORI']) > 0 ? '' : 'class="hideme"' ;?> id="tdanak3" ke="3">
                <td class="td_left">&nbsp;</td>
                <td class="td_right"><?= $sess['UR_SUB_SUB_KATEGORI']; ?></td>
              </tr>
              <tr <?php echo strlen($sess['UR_SUB_SUB_SUB_KATEGORI']) > 0 ? '' : 'class="hideme"' ;?> id="tdanak4" ke="4">
                <td class="td_left">&nbsp;</td>
                <td class="td_right"><?= $sess['UR_SUB_SUB_SUB_KATEGORI']; ?></td>
              </tr>
              <tr>
                <td class="td_left">Parameter Uji</td>
                <td class="td_right"><?= $sess['PARAMETER_UJI']; ?></td>
              </tr>
              <tr>
                <td class="td_left">Metode</td>
                <td class="td_right"><?= $sess['METODE']; ?></td>
              </tr>
              <tr>
                <td class="td_left">Pustaka</td>
                <td class="td_right"><?= $sess['PUSTAKA']; ?></td>
              </tr>
              <tr>
                <td class="td_left">Syarat</td>
                <td class="td_right"><?= $sess['SYARAT']; ?></td>
              </tr>
              <tr>
                <td class="td_left">Ruang Lingkup</td>
                <td class="td_right"><?= $sess['RUANG_LINGKUP']; ?></td>
              </tr>
              <tr>
                <td class="td_left">Verifikasi Parameter</td>
                <td class="td_right"><?= form_dropdown('SRL[VERIFI]',$verifikasi,'','id="sel-verifi" class="stext" title="Verifikasi paramter uji lokal spesifik" rel="required"'); ?></td>
              </tr>
              <tr>
                <td class="td_left">Catatan</td>
                <td class="td_right"><textarea name="SRL[CATATAN]" class="stext catatan" title="Catatan untuk verifikasi parameter uji lokal spesifik" rel="required"></textarea></td>
              </tr>
            </table>
          </div>
        </div>
      </div>
      <div style="padding:10px;"></div>
      <div><a href="#" class="button save" onclick="fpost('#m_srl','',''); return false;"><span><span class="icon"></span>&nbsp; <?php echo $save; ?> &nbsp;</span></a>&nbsp;<a href="#" class="button back" onclick="window.history.back(); return false;" ><span><span class="icon"></span>&nbsp; <?php echo $cancel; ?> &nbsp;</span></a></div>
    </div>
    <div style="padding:10px;"></div>
    <input type="hidden" name="ID" value="<?php echo $id; ?>" />
  </form>
</div>