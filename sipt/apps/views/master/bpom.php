<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR);?>

<div id="juduldaerah" class="judul"></div>
<div class="content">
  <form action="<?php echo $act; ?>" method="post" autocomplete="off" id="m_bbpom">
    <div class="adCntnr">
      <div class="acco2">
        <div class="expand"><b>Data BBPOM / BPOM</b></div>
        <div class="collapse">
          <div class="accCntnt">
            <table class="form_tabel">
              <tr>
                <td class="td_left">Nama BBPOM / BPOM</td>
                <td class="td_right"><?= $sess['NAMA_BBPOM']; ?></td>
              </tr>
              <tr>
                <td class="td_left">Kode Balai</td>
                <td class="td_right"><?= $sess['KODE_BALAI']; ?></td>
              </tr>
              <tr>
                <td class="td_left">Tipe Balai</td>
                <td class="td_right"><?= form_dropdown('BBPOM[TIPE]',$tipe_balai, $sess['TIPE'], 'class="stext" rel="required" title="Tipe Balai (A / B)"'); ?></td>
              </tr>
              <tr>
                <td class="td_left">Pembagian Wilayah</td>
                <td class="td_right"><?= form_dropdown('BBPOM[WILAYAH]',$wilayah, $sess['WILAYAH'], 'class="stext" rel="required" title="Pembagian wilayah"'); ?></td>
              </tr>
              <tr>
                <td class="td_left">Alamat</td>
                <td class="td_right"><textarea class="stext catatan" title="Alamat BBPOM / BPOM" rel="required" name="BBPOM[ALAMAT_BALAI]"><?= $sess['ALAMAT_BALAI']; ?></textarea></td>
              </tr>
              <tr>
                <td class="td_left">Kota</td>
                <td class="td_right"><?= $sess['KOTA']; ?></td>
              </tr>
              <tr>
                <td class="td_left">Kode Pos</td>
                <td class="td_right"><input type="text" name="BBPOM[KODE_POS]" class="stext" style="width:50px;" maxlength="6" value="<?= $sess['KODE_POS']; ?>" rel="required" title="Kode Pos" /></td>
              </tr>
              <tr>
                <td class="td_left">Telepon</td>
                <td class="td_right"><input type="text" name="BBPOM[TELPON]" class="stext" value="<?= $sess['TELPON']; ?>" rel="required" title="Telepon"  /></td>
              </tr>
              <tr>
                <td class="td_left">Fax</td>
                <td class="td_right"><input type="text" name="BBPOM[FAX]" class="stext" value="<?= $sess['FAX']; ?>" rel="required" title="Faximile"  /></td>
              </tr>
              <tr>
                <td class="td_left">Email</td>
                <td class="td_right"><input type="text" name="BBPOM[EMAIL]" class="stext" value="<?= $sess['EMAIL']; ?>" rel="required" title="Email"  /></td>
              </tr>
            </table>
          </div>
        </div>
        <div style="padding:10px;"></div>
        <div><a href="#" class="button save" onclick="fpost('#m_bbpom','',''); return false;"><span><span class="icon"></span>&nbsp; <?php echo $save; ?> &nbsp;</span></a>&nbsp;<a href="#" class="button reload" onclick="javascript:window.history.back(); return false;" ><span><span class="icon"></span>&nbsp; Batal &nbsp;</span></a></div>
      </div>
    </div>
    <input type="hidden" name="BBPOM_ID" value="<?php echo $id; ?>" />
  </form>
</div>
