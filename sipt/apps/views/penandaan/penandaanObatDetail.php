<?php
if (!defined('BASEPATH'))
  exit('No direct script access allowed');
?>
<link type="text/css" href="<?php echo base_url(); ?>css/iklanPenandaan.css" rel="stylesheet" media="screen"/>
<div id="judulpmnpdd" class="judul"></div>
<div class="headersarana">PENGAWASAN PENANDAAN <?php echo $subJudul; ?></div>
<?php
$d1 = explode('*', $sess['BUNGKUS_LUAR']);
$sess['FILE_PENANDAAN_BL'] = $d1[0];
$d2 = explode('*', $sess['ETIKET']);
$sess['FILE_PENANDAAN_ET'] = $d2[0];
$d3 = explode('*', $sess['AMPUL_VIAL10ML']);
$sess['FILE_PENANDAAN_V1'] = $d3[0];
$d4 = explode('*', $sess['AMPUL_VIAL9ML']);
$sess['FILE_PENANDAAN_V2'] = $d4[0];
$d5 = explode('*', $sess['BROSUR']);
$sess['FILE_PENANDAAN_BR'] = $d5[0];
$d6 = explode('*', $sess['AMPLOP']);
$sess['FILE_PENANDAAN_AS'] = $d6[0];
$d7 = explode('*', $sess['BLISTER']);
$sess['FILE_PENANDAAN_SB'] = $d7[0];
$detail1 = explode('#', $d1[1]);
$detail2 = explode('#', $d2[1]);
$detail3 = explode('#', $d3[1]);
$detail4 = explode('#', $d4[1]);
$detail5 = explode('#', $d5[1]);
$detail6 = explode('#', $d6[1]);
$detail7 = explode('#', $d7[1]);
foreach ($detail1 as $k) {
  $detailsub1[] = explode('_', $k);
}foreach ($detail2 as $k) {
  $detailsub2[] = explode('_', $k);
}foreach ($detail3 as $k) {
  $detailsub3[] = explode('_', $k);
}foreach ($detail4 as $k) {
  $detailsub4[] = explode('_', $k);
}foreach ($detail5 as $k) {
  $detailsub5[] = explode('_', $k);
}foreach ($detail6 as $k) {
  $detailsub6[] = explode('_', $k);
}foreach ($detail7 as $k) {
  $detailsub7[] = explode('_', $k);
}
?>
<div class="content">
  <form action="<?php echo $act; ?>" method="post" autocomplete="off" id="fpengawasanPenandaan_001">
    <div class="adCntnr">
      <div class="acco2">
        <div class="expand"><a title="expand/collapse" href="#" style="display: block;">INFORMASI PENGAWASAN PENANDAAN</a></div>
        <div class="collapse">
          <div class="accCntnt">
            <table class="form_tabel">
              <tr class="urut<?php echo $i; ?>" hidden="true">
                <td class="atas">Unit / Balai Besar / Balai</td>
                <td><input type="text" class="stext" readonly="readonly" value="<?php echo $this->newsession->userdata('SESS_MBBPOM'); ?>" name="BBPOM[MBBPOM_ID][]" val="<?php echo $nomor[$i]; ?>" title="Balai Besar / Balai POM" /><input type="hidden" name="BBPOM[BBPOM_ID][]" value="<?php echo $this->newsession->userdata('SESS_BBPOM_ID'); ?>" id="bpomid" /></td>
              </tr>
              <div id="detail_petugas" url="<?php echo $histori_petugas; ?>"></div>
            </table>
            <br />
            <div style="height:15px;"></div>
            <table class="form_tabel"><tr></tr>
              <tr><td class="td_left">Tanggal Pengawasan</td><td class="td_right">
                  <input type="hidden" class="sdate" name="PENANDAAN[TANGGALSURAT]" id="tglXX<?php echo $i; ?>" title="Tanggal Surat" value="<?php
                  if ($this->session->userdata('TANGGAL') != "-" && !$sess['TGL_SURAT']) {
                    echo $this->session->userdata('TANGGAL');
                  } else if ($sess['TGL_SURAT'] != NULL) {
                    echo $sess['TGL_SURAT'];
                  }
                  else
                    echo $sess['TANGGAL_MULAI'];
                  ?>"/>
                  <input type="text" class="sdate" name="PENANDAAN[TANGGALAWAL]" id="tglAwalPengawasan<?php echo $i; ?>" title="Tanggal Pengawasan Penandaan" onchange="comp('A')" rel="required" value="<?php echo $sess['TANGGAL_MULAI']; ?>"/>&nbsp; sampai dengan&nbsp;
                  <input type="text" class="sdate" name="PENANDAAN[TANGGALAKHIR]" id="tglAkhirPengawasan<?php echo $i; ?>" title="Tanggal Pengawasan Penandaan" onchange="comp('B')" rel="required" value="<?php echo $sess['TANGGAL_AKHIR']; ?>"/></td>
              </tr>
              <tr>
                <td class="td_left">Sarana Sampling</td><td class="td_right"><input type="text" class="stext" name="PENANDAAN[SARANA]" id="saranaid_" url="<?php echo site_url(); ?>/autocompletes/autocomplete/sarana" title="Pilih salah satu Nama Sarana" value="<?php echo $sess['NAMA_SARANA']; ?>" rel="required"/><input type="hidden"  name="PENANDAAN[SARANAID]" id="saranaidval_" value="<?php echo $sess['SARANA_ID']; ?>" /></td>
              </tr>
              <tr>
                <td class="td_left">Alamat Sampling</td><td class="td_right"><textarea class="stext" id="alamatPengambilan" title="Alamat Sampling, Sarana" style="width: 240px; height: 50px;" name="PENANDAAN[ALAMAT]" readonly rel="required"><?php
                    if (array_key_exists('ALAMAT_1', $sess)) {
                      echo $sess['ALAMAT_1'] . ", " . $sess['KOTA'] . ", " . $sess['PROPINSI'];
                    }
                    ?></textarea></td>
              </tr>
            </table>
          </div>
        </div><!-- Akhir Pemeriksaan !-->
        <div style="height:5px;"></div>
        <div class="acco2"><div class="expand"><a title="expand/collapse" href="#" style="display: block;">INFORMASI OBAT - PENANDAAN</a></div>
          <div class="collapse">
            <div class="accCntnt">
              <table class="form_tabel">
                <tr>
                  <td class="td_left">Nama Obat Jadi</td><td class="td_right"><input type="text" class="infoObatTxt stext namaObatJadi" id="namaObatJadi" url="<?php echo site_url(); ?>/autocompletes/autocomplete/produk_reg_2/" title="Nama Obat Jadi" name="PENANDAANPRODUK[NAMA_PRODUK]" rel="required" value="<?php echo $sess['NAMA_PRODUK']; ?>" /></td>
                  <td class="td_left" hidden="true"><input type="text" class="infoObatTxt stext nieObatJadi" id="nieObatJadi" title="Nama Obat Jadi" /></td>
                  <td class="td_left">Nomor Izin Edar</td><td class="td_right"><input type="text" class="infoObatTxt stext" id="NIE" title="NIE" title="Nomor Izin Edar" rel="required" name="PENANDAANPRODUK[NOMOR_IZIN_EDAR]" value="<?php echo $sess['NOMOR_IZIN_EDAR']; ?>" onchange="namaObatAuto($(this).val());" /></td>
                </tr>
                <tr>
                  <td class="td_left">Klasifikasi Obat</td><td class="td_right"><div style="display:inline-block; position:relative;"><?php echo form_dropdown('PENANDAANPRODUK[KLASIFIKASI_PRODUK]', $klasifikasi_obat, $sess['KLASIFIKASI_PRODUK'], 'id="klasifikasiObat" class="infoObatCmb stext cmbDetObat" title="Golongan Obat" rel="required"'); ?><div style="position:absolute; left:0; right:0; top:0; bottom:0;" class="infoObatCmbLine" hidden></div></div></td>
                  <td class="td_left">Produsen</td><td class="td_right"><input type="text" class="infoObatTxt stext" id="produsen" title="Nama Produsen" rel="required" name="PENANDAANPRODUK[PRODUSEN]" value="<?php echo $sess['PRODUSEN']; ?>" /></td>
                </tr>
                <tr>
                  <td class="td_left">Klasifikasi Pendaftar</td><td class="td_right"><div style="display:inline-block; position:relative;"><?php echo form_dropdown('PENANDAANPRODUK[KLASIFIKASI_PENDAFTAR]', $klasifikasi_pendaftar, $sess['KLASIFIKASI_PENDAFTAR'], 'id="klasifikasiPendaftar" class="infoObatCmb stext cmbDetObat" title="Golongan Obat" rel="required"'); ?><div style="position:absolute; left:0; right:0; top:0; bottom:0;" class="infoObatCmbLine" hidden></div></div></td>
                  <td class="td_left">Pendaftar</td><td class="td_right"><input type="text" class="infoObatTxt stext" id="pendaftar" title="Nama Pendaftar" rel="required" name="PENANDAANPRODUK[PENDAFTAR]" value="<?php echo $sess['PENDAFTAR']; ?>" /></td>
                </tr>
                <tr>
                  <td class="td_left">Besar Kemasan</td><td class="td_right"><input type="text" class="infoObatTxt stext" id="besarKemasan" title="Besar Kemasan" rel="required" name="PENANDAANPRODUK[BESAR_KEMASAN]" value="<?php echo $sess['BESAR_KEMASAN']; ?>" /></td>
                  <td class="td_left">Bentuk Sediaan</td><td class="td_right"><input type="text" class="infoObatTxt stext" id="bentukSediaan" title="Bentuk Sediaan" rel="required" name="PENANDAANPRODUK[BENTUK_SEDIAAN]" value="<?php echo $sess['BENTUK_SEDIAAN']; ?>" /></td>
                </tr>
                <tr>
                  <td class="td_left">Komposisi</td><td class="td_right"><textarea id="komposisi" class="infoObatTxt stext" style="width: 235px; height: 50px" title="Komposisi Obat" rel="required" name="PENANDAANPRODUK[KOMPOSISI]"><?php echo $sess['KOMPOSISI']; ?></textarea></td>
                  <td class="td_left">Golongan Obat<br /><br />Nomor Batch</td><td class="td_right"><div style="display:inline-block; position:relative;"><?php echo form_dropdown('PENANDAANPRODUK[GOLONGAN_PRODUK]', $golongan_obat, $sess['GOLONGAN_PRODUK'], 'id="golonganObat" class="infoObatCmb stext cmbDetObat" title="Golongan Obat" rel="required"'); ?><div style="position:absolute; left:0; right:0; top:0; bottom:0;" class="infoObatCmbLine" hidden></div></div><br/><input type="text" class="infoObatTxt stext" title="Nomor Batch" name="PENANDAANPRODUK[NOMOR_PRODUK]" rel="required" style="margin-top: 10px" value="<?php echo $sess['NOMOR_PRODUK']; ?>" /></td>
                </tr>
              </table>
            </div>
          </div>
        </div>
        <div style="height:5px;"></div>

        <!-- DIV Detail-->
        <div class="expand" id="expand1"><a title="expand/collapse" href="#" style="display: block;">FORM PENILAIAN PENANDAAN</a></div>
        <div class="collapse">
          <div class="accCntnt">
            <div id="tabs">
              <div>
                <table>
                  <tr>
                    <td>Jenis Penandaan Yang Akan Dinilai : </td>
                    <td><input type="checkbox" value="jkyadp_bL" class="jkyadp" id="jkyadp_bL" param="BL" style="margin-left: 10px" />&nbsp;<b>Bungkus Luar</b></td>
                    <td><input type="checkbox" value="jkyadp_aS" class="jkyadp" id="jkyadp_aS" param="AS" style="margin-left: 15px" />&nbsp;<b>Amplop/ Catch Cover/ Sachet</b></td>
                  </tr>
                  <tr>
                    <td></td>
                    <td><input type="checkbox" value="jkyadp_eT" class="jkyadp" id="jkyadp_eT" param="ET" style="margin-left: 10px" />&nbsp;<b>Etiket</b></td>
                    <td><input type="checkbox" value="jkyadp_sB"class="jkyadp"  id="jkyadp_sB" param="SB" style="margin-left: 15px" />&nbsp;<b>Strip/ Blister</b></td>
                  </tr>
                  <tr>
                    <td></td>
                    <td><input type="checkbox" value="jkyadp_v1" class="jkyadp" id="jkyadp_v1" param="V1" style="margin-left: 10px" />&nbsp;<b>Ampul/ Vial >= 10 ML</b></td>
                    <td><input type="checkbox" value="jkyadp_v2" class="jkyadp" id="jkyadp_v2" param="V2" style="margin-left: 15px" />&nbsp;<b>Ampul/ Vial < 10 ML</b></td>
                  </tr>
                  <tr>
                    <td></td>
                    <td><input type="checkbox" value="jkyadp_bR" class="jkyadp" id="jkyadp_bR" param="BR" style="margin-left: 10px" />&nbsp;<b>Brosur</b></td>
                  </tr>
                </table>
              </div>
              <br />
              <ul>
                <li class="div_bL" hidden="true"><a href="#tabs-1">Bungkus Luar</a></li>
                <li class="div_aS" hidden="true"><a href="#tabs-2">Amplop/ Catch cover/ Sachet</a></li>
                <li class="div_eT" hidden="true"><a href="#tabs-3">Etiket</a></li>
                <li class="div_sB" hidden="true"><a href="#tabs-4">Strip/ Blister</a></li>
                <li class="div_v1" hidden="true"><a href="#tabs-5">Ampul/ Vial >= 10 ML</a></li>
                <li class="div_v2" hidden="true"><a href="#tabs-6">Ampul/ Vial < 10 ML</a></li>
                <li class="div_bR" hidden="true"><a href="#tabs-7">Brosur</a></li>
              </ul>

              <!--Bungkus Luar-->
              <div id="tabs-1" class="div_bL" style="display: none;">
                <table class="form_tabel" style="width: 100%;">
                  <tr>
                    <td style="width: 35%;"></td>
                    <td class="td_left" style="width: 65%">
                      <input type="radio" id="r1" disabled="true">
                      <label for="r1" style="width: 54px; height: 10px;">Ada</label>
                      <span style="margin-left: 5px;"></span>
                      <input type="radio" id="r2" disabled="true">
                      <label for="r2" style="width: 54px; height: 10px;">Tidak Ada</label></td>
                  </tr>
                  <tr class="infoPenandaan_bLRow">
                      <!--<td class="td_left_checklist">1</td>-->
                    <td class="td_left_header_checklist">Nama obat  </td>
                    <td class="td_left">
                      <input class="infoPenandaan_bL" type="radio" id="radioa11_1" name="CHK1[1]" value="+_Nama Obat" <?php if ($detailsub1[0][0] == '+') echo 'checked'; ?>>
                      <label for="radioa11_1" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_bL" type="radio" id="radioa12_2" name="CHK1[1]" value="-_Nama Obat" <?php if ($detailsub1[0][0] == '-') echo 'checked'; ?>>
                      <label for="radioa12_2" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;"  name="CHK1[1]" value="<?php echo join('_', $detailsub1[0]); ?>"></td>
                  </tr>
                  <tr class="infoPenandaan_bLRow">
                      <!--<td class="td_left_checklist">2</td>-->
                    <td class="td_left_header_checklist">Bentuk sediaan</td>
                    <td class="td_left">
                      <input class="infoPenandaan_bL" type="radio" id="radioa21_2" name="CHK1[2]" value="+_Bentuk Sediaan"  <?php if ($detailsub1[1][0] == '+') echo 'checked'; ?>>
                      <label for="radioa21_2" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_bL" type="radio" id="radioa22_2" name="CHK1[2]" value="-_Bentuk Sediaan"  <?php if ($detailsub1[1][0] == '-') echo 'checked'; ?>>
                      <label for="radioa22_2" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK1[2]" value="<?php echo join('_', $detailsub1[1]); ?>"></td>
                  </tr>
                  <tr class="infoPenandaan_bLRow">
                      <!--<td class="td_left_checklist">4</td>-->
                    <td class="td_left_header_checklist">Besar kemasan (unit)</td>
                    <td class="td_left"><input class="infoPenandaan_bL" type="radio" id="radioa31_4" name="CHK1[3]" value="+_Besar Kemasan" <?php if ($detailsub1[2][0] == '+') echo 'checked'; ?>>
                      <label for="radioa31_4" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_bL" type="radio" id="radioa32_4" name="CHK1[3]" value="-_Besar Kemasan" <?php if ($detailsub1[2][0] == '-') echo 'checked'; ?>>
                      <label for="radioa32_4" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK1[3]" value="<?php echo join('_', $detailsub1[2]); ?>"></td>
                  </tr>
                  <tr class="infoPenandaan_bLRow">
                      <!--<td class="td_left_checklist">5</td>-->
                    <td class="td_left_header_checklist">Nama dan kekuatan zat aktif</td>
                    <td class="td_left">
                      <input class="infoPenandaan_bL" type="radio" id="radioa41_5" name="CHK1[5]" value="+_Nama dan kekuatan zat aktif" <?php if ($detailsub1[3][0] == '+') echo 'checked'; ?>>
                      <label for="radioa41_5" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_bL" type="radio" id="radioa42_5" name="CHK1[5]" value="-_Nama dan kekuatan zat aktif" <?php if ($detailsub1[3][0] == '-') echo 'checked'; ?>>
                      <label for="radioa42_5" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK1[5]" value="<?php echo join('_', $detailsub1[3]); ?>"></td>
                  </tr>
                  <tr class="infoPenandaan_bLRow">
                      <!--<td class="td_left_checklist">6a</td>-->
                    <td class="td_left_header_checklist">Nama industri pendaftar</td>
                    <td class="td_left">
                      <input class="infoPenandaan_bL" type="radio" id="radioa6a1_6" name="CHK1[6a]" value="+_Nama industri pendaftar" <?php if ($detailsub1[4][0] == '+') echo 'checked'; ?>>
                      <label for="radioa6a1_6" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_bL" type="radio" id="radioa6a2_6" name="CHK1[6a]" value="-_Nama industri pendaftar" <?php if ($detailsub1[4][0] == '-') echo 'checked'; ?>>
                      <label for="radioa6a2_6" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK1[6a]" value="<?php echo join('_', $detailsub1[4]); ?>"></td>
                  </tr>
                  <tr class="infoPenandaan_bLRow">
                      <!--<td class="td_left_checklist">6b</td>-->
                    <td class="td_left_header_checklist">Alamat industri pendaftar</td>
                    <td class="td_left">
                      <input class="infoPenandaan_bL" type="radio" id="radioa6b1_6" name="CHK1[6b]" value="+_Alamat industri pendaftar" <?php if ($detailsub1[5][0] == '+') echo 'checked'; ?>>
                      <label for="radioa6b1_6" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_bL" type="radio" id="radioa6b2_6" name="CHK1[6b]" value="-_Alamat industri pendaftar" <?php if ($detailsub1[5][0] == '-') echo 'checked'; ?>>
                      <label for="radioa6b2_6" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK1[6b]" value="<?php echo join('_', $detailsub1[5]); ?>"></td>
                  </tr>
                  <tr class="lisensiBasedbL infoPenandaan_bLRow" hidden>
                      <!--<td class="td_left_checklist">7a</td>-->
                    <td class="td_left_header_checklist">Nama industri pendaftar dan produsen obat (untuk obat kontrak)</td>
                    <td class="td_left">
                      <input class="infoPenandaan_bL" type="radio" id="radioa7a1_7" name="CHK1[7a]" value="+_Nama industri pendaftar dan produsen obat (untuk obat kontrak)" <?php if ($detailsub1[6][0] == '+') echo 'checked'; ?>>
                      <label for="radioa7a1_7" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_bL" type="radio" id="radioa7a2_7" name="CHK1[7a]" value="-_Nama industri pendaftar dan produsen obat (untuk obat kontrak)" <?php if ($detailsub1[6][0] == '-') echo 'checked'; ?>>
                      <label for="radioa7a2_7" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK1[7a]" value="<?php echo join('_', $detailsub1[6]); ?>"></td>
                  </tr>
                  <tr class="lisensiBasedbL infoPenandaan_bLRow" hidden>
                      <!--<td class="td_left_checklist">7b</td>-->
                    <td class="td_left_header_checklist">Alamat industri pendaftar dan produsen obat (untuk obat kontrak)</td>
                    <td class="td_left">
                      <input class="infoPenandaan_bL" type="radio" id="radioa7b1_7" name="CHK1[7b]" value="+_Alamat industri pendaftar dan produsen obat (untuk obat kontrak)" <?php if ($detailsub1[7][0] == '+') echo 'checked'; ?>>
                      <label for="radioa7b1_7" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_bL" type="radio" id="radioa7b2_7" name="CHK1[7b]" value="-_Alamat industri pendaftar dan produsen obat (untuk obat kontrak)" <?php if ($detailsub1[7][0] == '-') echo 'checked'; ?>>
                      <label for="radioa7b2_7" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK1[7b]" value="<?php echo join('_', $detailsub1[7]); ?>"></td>
                  </tr>
                  <tr class="infoPenandaan_bLRow">
                      <!--<td class="td_left_checklist">8a</td>-->
                    <td class="td_left_header_checklist">Nama industri pendaftar dan pemberi lisensi</td>
                    <td class="td_left">
                      <input class="infoPenandaan_bL" type="radio" id="radioa8a1_8" name="CHK1[8a]" value="+_Nama industri pendaftar dan pemberi lisensi" <?php if ($detailsub1[8][0] == '+') echo 'checked'; ?>>
                      <label for="radioa8a1_8" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_bL" type="radio" id="radioa8a2_8" name="CHK1[8a]" value="-_Nama industri pendaftar dan pemberi lisensi" <?php if ($detailsub1[8][0] == '-') echo 'checked'; ?>>
                      <label for="radioa8a2_8" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK1[8a]" value="<?php echo join('_', $detailsub1[8]); ?>"></td>
                  </tr>
                  <tr class="infoPenandaan_bLRow">
                      <!--<td class="td_left_checklist">8b</td>-->
                    <td class="td_left_header_checklist">Alamat industri pendaftar dan pemberi lisensi</td>
                    <td class="td_left">
                      <input class="infoPenandaan_bL" type="radio" id="radioa8b1_8" name="CHK1[8b]" value="+_Alamat industri pendaftar dan pemberi lisensi" <?php if ($detailsub1[9][0] == '+') echo 'checked'; ?>>
                      <label for="radioa8b1_8" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_bL" type="radio" id="radioa8b2_8" name="CHK1[8b]" value="-_Alamat industri pendaftar dan pemberi lisensi" <?php if ($detailsub1[9][0] == '-') echo 'checked'; ?>>
                      <label for="radioa8b2_8" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK1[8b]" value="<?php echo join('_', $detailsub1[9]); ?>"></td>
                  </tr>
                  <tr class="infoPenandaan_bLRow">
                      <!--<td class="td_left_checklist">9</td>-->
                    <td class="td_left_checklist">Cara pemberian</td>
                    <td class="td_left">
                      <input class="infoPenandaan_bL" type="radio" id="radioa91_9" name="CHK1[9]" value="+_Cara pemberian" <?php if ($detailsub1[10][0] == '+') echo 'checked'; ?>>
                      <label for="radioa91_9" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_bL" type="radio" id="radioa92_9" name="CHK1[9]" value="-_Cara pemberian" <?php if ($detailsub1[10][0] == '-') echo 'checked'; ?>>
                      <label for="radioa92_9" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK1[9]" value="<?php echo join('_', $detailsub1[10]); ?>"></td>
                  </tr>
                  <tr class="infoPenandaan_bLRow">
                      <!--<td class="td_left_checklist">10</td>-->
                    <td class="td_left_header_checklist">Nomor izin edar</td>
                    <td class="td_left">
                      <input class="infoPenandaan_bL" type="radio" id="radioa101_10" name="CHK1[10]" value="+_Nomor izin edar" <?php if ($detailsub1[11][0] == '+') echo 'checked'; ?>>
                      <label for="radioa101_10" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_bL" type="radio" id="radioa102_10" name="CHK1[10]" value="-_Nomor izin edar" <?php if ($detailsub1[11][0] == '-') echo 'checked'; ?>>
                      <label for="radioa102_10" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK1[10]" value="<?php echo join('_', $detailsub1[11]); ?>"></td>
                  </tr>
                  <tr class="infoPenandaan_bLRow">
                      <!--<td class="td_left_checklist">11</td>-->
                    <td class="td_left_header_checklist">Nomor bets</td>
                    <td class="td_left">
                      <input class="infoPenandaan_bL" type="radio" id="radioa111_11" name="CHK1[11]" value="+_Nomor bets"  <?php if ($detailsub1[12][0] == '+') echo 'checked'; ?>>
                      <label for="radioa111_11" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_bL" type="radio" id="radioa112_11" name="CHK1[11]" value="-_Nomor bets"  <?php if ($detailsub1[12][0] == '-') echo 'checked'; ?>>
                      <label for="radioa112_11" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK1[11]"  value="<?php echo join('_', $detailsub1[12]); ?>"></td>
                  </tr>
                  <tr class="infoPenandaan_bLRow">
                      <!--<td class="td_left_checklist">12</td>-->
                    <td class="td_left_header_checklist">Tanggal produksi</td>
                    <td class="td_left">
                      <input class="infoPenandaan_bL" type="radio" id="radioa121_12" name="CHK1[12]" value="+_Tanggal produksi" <?php if ($detailsub1[13][0] == '+') echo 'checked'; ?>>
                      <label for="radioa121_12" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_bL" type="radio" id="radioa122_12" name="CHK1[12]" value="-_Tanggal produksi" <?php if ($detailsub1[13][0] == '-') echo 'checked'; ?>>
                      <label for="radioa122_12" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK1[12]"  value="<?php echo join('_', $detailsub1[13]); ?>"</td>
                  </tr>
                  <tr class="infoPenandaan_bLRow">
                      <!--<td class="td_left_checklist">13</td>-->
                    <td class="td_left_header_checklist">Batas kadaluarsa</td>
                    <td class="td_left">
                      <input class="infoPenandaan_bL" type="radio" id="radioa131_13" name="CHK1[13]" value="+_Batas kadaluarsa" <?php if ($detailsub1[14][0] == '+') echo 'checked'; ?>>
                      <label for="radioa131_13" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_bL" type="radio" id="radioa132_13" name="CHK1[13]" value="-_Batas kadaluarsa" <?php if ($detailsub1[14][0] == '-') echo 'checked'; ?>>
                      <label for="radioa132_13" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK1[13]"  value="<?php echo join('_', $detailsub1[14]); ?>"></td>
                  </tr>
                  <tr class="oKBTbL infoPenandaan_bLRow">
                      <!--<td class="td_left_checklist">16</td>-->
                    <td class="td_left_header_checklist">Indikasi</td>
                    <td class="td_left">
                      <input class="infoPenandaan_bL" type="radio" id="radioa161_16" name="CHK1[16]" value="+_Indikasi" <?php if ($detailsub1[15][0] == '+') echo 'checked'; ?>>
                      <label for="radioa161_16" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_bL" type="radio" id="radioa162_16" name="CHK1[16]" value="-_Indikasi" <?php if ($detailsub1[15][0] == '-') echo 'checked'; ?>>
                      <label for="radioa162_16" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK1[16]"  value="<?php echo join('_', $detailsub1[15]); ?>"></td>
                  </tr>
                  <tr class="oKBTbL infoPenandaan_bLRow">
                      <!--<td class="td_left_checklist">17</td>-->
                    <td class="td_left_header_checklist">Posologi/Dosis</td>
                    <td class="td_left">
                      <input class="infoPenandaan_bL" type="radio" id="radioa171_17" name="CHK1[18]" value="+_Posologi/Dosis" <?php if ($detailsub1[16][0] == '+') echo 'checked'; ?>>
                      <label for="radioa171_17" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_bL" type="radio" id="radioa172_17" name="CHK1[18]" value="-_Posologi/Dosis" <?php if ($detailsub1[16][0] == '-') echo 'checked'; ?>>
                      <label for="radioa172_17" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK1[18]"  value="<?php echo join('_', $detailsub1[16]); ?>" ></td>
                  </tr>
                  <tr class="infoPenandaan_bLRow">
                      <!--<td class="td_left_checklist">19</td>-->
                    <td class="td_left_header_checklist">Kontra indikasi</td>
                    <td class="td_left">
                      <input class="infoPenandaan_bL" type="radio" id="radioa191_19" name="CHK1[20]" value="+_Kontra indikasi" <?php if ($detailsub1[17][0] == '+') echo 'checked'; ?>>
                      <label for="radioa191_19" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_bL" type="radio" id="radioa192_19" name="CHK1[20]" value="-_Kontra indikasi" <?php if ($detailsub1[17][0] == '-') echo 'checked'; ?>>
                      <label for="radioa192_19" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK1[20]"  value="<?php echo join('_', $detailsub1[17]); ?>"></td>
                  </tr>
                  <tr class="infoPenandaan_bLRow">
                      <!--<td class="td_left_checklist">20</td>-->
                    <td class="td_left_header_checklist">Efek samping</td>
                    <td class="td_left">
                      <input class="infoPenandaan_bL" type="radio" id="radioa201_20" name="CHK1[21]" value="+_Efek samping" <?php if ($detailsub1[18][0] == '+') echo 'checked'; ?>>
                      <label for="radioa201_20" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_bL" type="radio" id="radioa202_20" name="CHK1[21]" value="-_Efek samping" <?php if ($detailsub1[18][0] == '-') echo 'checked'; ?>>
                      <label for="radioa202_20" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK1[21]"  value="<?php echo join('_', $detailsub1[18]); ?>"></td>
                  </tr>
                  <tr class="infoPenandaan_bLRow">
                      <!--<td class="td_left_checklist">21</td>-->
                    <td class="td_left_header_checklist">Interaksi obat</td>
                    <td class="td_left">
                      <input class="infoPenandaan_bL" type="radio" id="radioa211_21" name="CHK1[22]" value="+_Interaksi obat" <?php if ($detailsub1[19][0] == '+') echo 'checked'; ?>>
                      <label for="radioa211_21" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_bL" type="radio" id="radioa212_21" name="CHK1[22]" value="-_Interaksi obat" <?php if ($detailsub1[19][0] == '-') echo 'checked'; ?>>
                      <label for="radioa212_21" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK1[22]"  value="<?php echo join('_', $detailsub1[19]); ?>"></td>
                  </tr>
                  <tr class="infoPenandaan_bLRow">
                      <!--<td class="td_left_checklist">22</td>-->
                    <td class="td_left_header_checklist">Peringatan - Perhatian</td>
                    <td class="td_left">
                      <input class="infoPenandaan_bL" type="radio" id="radioa221_22" name="CHK1[23]" value="+_Peringatan - Perhatian" <?php if ($detailsub1[20][0] == '+') echo 'checked'; ?>>
                      <label for="radioa221_22" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_bL" type="radio" id="radioa222_22" name="CHK1[23]" value="-_Peringatan - Perhatian" <?php if ($detailsub1[20][0] == '-') echo 'checked'; ?>>
                      <label for="radioa222_22" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK1[23]" value="<?php echo join('_', $detailsub1[20]); ?>"></td>
                  </tr>
                  <tr class="oKPNbL infoPenandaan_bLRow"  hidden>
                      <!--<td class="td_left_checklist">28a</td>-->
                    <td class="td_left_header_checklist">"Harus dengan resep dokter"</td>
                    <td class="td_left">
                      <input class="infoPenandaan_bL" type="radio" id="radioa28a1_28RD" name="CHK1[24a]" value="+_Harus dengan resep dokter" <?php if ($detailsub1[21][0] == '+') echo 'checked'; ?>>
                      <label for="radioa28a1_28RD" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_bL" type="radio" id="radioa28a2_28RD" name="CHK1[24a]" value="-_Harus dengan resep dokter" <?php if ($detailsub1[21][0] == '-') echo 'checked'; ?>>
                      <label for="radioa28a2_28RD" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK1[24a]"  value="<?php echo join('_', $detailsub1[21]); ?>"></td>
                  </tr>
                  <tr class="oTbL infoPenandaan_bLRow" hidden>
                       <!--<td class="td_left_checklist">28b</td>-->
                    <td class="td_left_header_checklist">Tanda peringatan (P No.1 - P No.6)</td>
                    <td class="td_left">
                      <input class="infoPenandaan_bL bebasTerbatasbL2" type="radio" id="radioa28b1_28BT" name="CHK1[24b]" value="+_Tanda peringatan (P No.1 - P No.6)" <?php if ($detailsub1[22][0] == '+') echo 'checked'; ?>>
                      <label for="radioa28b1_28BT" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_bL bebasTerbatasbL2" type="radio" id="radioa28b2_28BT" name="CHK1[24b]" value="-_Tanda peringatan (P No.1 - P No.6)" <?php if ($detailsub1[22][0] == '-') echo 'checked'; ?>>
                      <label for="radioa28b2_28BT" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK1[24b]" class="bebasTerbatasbL3" value="<?php echo join('_', $detailsub1[22]); ?>"></td>
                  </tr>
                  <tr style="background-color: white" class="bebasTerbatasbL infoPenandaan_bLRow" hidden>
                      <!--<td class="td_left_checklist">28c</td>-->
                    <td style="background-color: white" class="td_left_header_checklist">Kotak peringatan</td>
                    <td style="background-color: white" class="td_left">
                      <input class="infoPenandaan_bL bebasTerbatasbL2" type="radio" id="radioa28c1_28BT" name="CHK1[24c]" value="+_Kotak peringatan" <?php if ($detailsub1[23][0] == '+') echo 'checked'; ?>>
                      <label for="radioa28c1_28BT" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_bL bebasTerbatasbL2" type="radio" id="radioa28c2_28BT" name="CHK1[24c]" value="-_Kotak peringatan" <?php if ($detailsub1[23][0] == '-') echo 'checked'; ?>>
                      <label for="radioa28c2_28BT" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" class="bebasTerbatasbL3" style="display:none;" name="CHK1[24c]" value="<?php echo join('_', $detailsub1[23]); ?>"></td>
                  </tr>
                  <tr class="infoPenandaan_bLRow">
                      <!--<td class="td_left_checklist">28d</td>-->
                    <td style="background-color: white" class="td_left_header_checklist">"Bersumber babi/bersinggungan"</td>
                    <td style="background-color: white" class="td_left">
                      <input class="infoPenandaan_bL" type="radio" id="radioa28d1_28" name="CHK1[24d]" value="+_Bersumber babi/bersinggungan" <?php if ($detailsub1[24][0] == '+') echo 'checked'; ?>>
                      <label for="radioa28d1_28" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_bL" type="radio" id="radioa28d2_28" name="CHK1[24d]" value="-_Bersumber babi/bersinggungan" <?php if ($detailsub1[24][0] == '-') echo 'checked'; ?>>
                      <label for="radioa28d2_28" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK1[24d]"  value="<?php echo join('_', $detailsub1[24]); ?>"></td>
                  </tr>
                  <tr style="background-color: white" class="infoPenandaan_bLRow">
                      <!--<td class="td_left_checklist">28e</td>-->
                    <td class="td_left_header_checklist">Kandungan alkohol</td>
                    <td class="td_left">
                      <input class="infoPenandaan_bL" type="radio" id="radioa28e1_28" name="CHK1[24e]" value="+_Kandungan alkohol" <?php if ($detailsub1[25][0] == '+') echo 'checked'; ?>>
                      <label for="radioa28e1_28" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_bL" type="radio" id="radioa28e2_28" name="CHK1[24e]" value="-_Kandungan alkohol" <?php if ($detailsub1[25][0] == '-') echo 'checked'; ?>>
                      <label for="radioa28e2_28" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK1[24e]"  value="<?php echo join('_', $detailsub1[25]); ?>"></td>
                  </tr>
                  <tr class="infoPenandaan_bLRow">
                      <!--<td class="td_left_checklist">29</td>-->
                    <td class="td_left_header_checklist">Cara penyimpanan obat (termasuk cara penyimpanan setelah rekonstitusi)</td>
                    <td class="td_left">
                      <input class="infoPenandaan_bL" type="radio" id="radioa291_29" name="CHK1[25]" value="+_Cara penyimpanan obat (termasuk cara penyimpanan setelah rekonstitusi)" <?php if ($detailsub1[26][0] == '+') echo 'checked'; ?>>
                      <label for="radioa291_29" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_bL" type="radio" id="radioa292_29" name="CHK1[25]" value="-_Cara penyimpanan obat (termasuk cara penyimpanan setelah rekonstitusi)" <?php if ($detailsub1[26][0] == '-') echo 'checked'; ?>>
                      <label for="radioa292_29" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK1[25]"  value="<?php echo join('_', $detailsub1[26]); ?>"></td>
                  </tr>
                  <tr class="infoPenandaan_bLRow">
                      <!--<td class="td_left_checklist">32a</td>-->
                    <td style="background-color: white" class="td_left_header_checklist">Harga Eceran Tertinggi (HET)</td>
                    <td style="background-color: white" class="td_left">
                      <input class="infoPenandaan_bL" type="radio" id="radioa32a1_32" name="CHK1[26a]" value="+_Harga Eceran Tertinggi (HET)" <?php if ($detailsub1[27][0] == '+') echo 'checked'; ?>>
                      <label for="radioa32a1_32" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_bL" type="radio" id="radioa32a2_32" name="CHK1[26a]" value="-_Harga Eceran Tertinggi (HET)" <?php if ($detailsub1[27][0] == '-') echo 'checked'; ?>>
                      <label for="radioa32a2_32" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK1[26a]" value="<?php echo join('_', $detailsub1[27]); ?>"></td>
                  </tr>
                  <tr class="infoPenandaan_bLRow">
                      <!--<td class="td_left_checklist">32b</td>-->
                    <td style="background-color: white" class="td_left_header_checklist">Logo golongan obat (obat keras/bebas terbatas/bebas)</td>
                    <td style="background-color: white" class="td_left">
                      <input class="infoPenandaan_bL" type="radio" id="radioa32b1_32" name="CHK1[26b]" value="+_Logo golongan obat (obat keras/bebas terbatas/bebas)" <?php if ($detailsub1[28][0] == '+') echo 'checked'; ?>>
                      <label for="radioa32b1_32" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_bL" type="radio" id="radioa32b2_32" name="CHK1[26b]" value="-_Logo golongan obat (obat keras/bebas terbatas/bebas)" <?php if ($detailsub1[28][0] == '-') echo 'checked'; ?>>
                      <label for="radioa32b2_32" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK1[26b]" value="<?php echo join('_', $detailsub1[28]); ?>"></td>
                  </tr>
                  <tr class="logoGenerikbL infoPenandaan_bLRow" hidden>
                      <!--<td class="td_left_checklist">32c</td>-->
                    <td style="background-color: white" class="td_left_header_checklist">Logo generik</td>
                    <td style="background-color: white" class="td_left">
                      <input class="infoPenandaan_bL" type="radio" id="radioa32c1_32" name="CHK1[26c]" value="+_Logo generik" <?php if ($detailsub1[29][0] == '+') echo 'checked'; ?>>
                      <label for="radioa32c1_32" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_bL" type="radio" id="radioa32c2_32" name="CHK1[26c]" value="-_Logo generik" <?php if ($detailsub1[29][0] == '-') echo 'checked'; ?>>
                      <label for="radioa32c2_32" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK1[26c]" value="<?php echo join('_', $detailsub1[29]); ?>"></td>
                  </tr>
                  <tr></tr>
                  <tr>
                      <!--<td class="td_left_checklist" style="vertical-align: middle">36</td>-->
                    <td class="td_left_header_checklist" style="vertical-align: top"><input style="vertical-align: top;" class="infoPenandaan_bL" name="infoPenandaan_bL-36" type="checkbox" value="-_A" id="bL_36" <?php if ($detailsub1[30][0] != '-' && $detailsub1[30][0] != '+' && $detailsub1[30][0] != '') echo 'checked'; ?> />&nbsp;Informasi Tambahan</td>
                    <td class="td_left"><span id="infoPenandaan_bL_txt" <?php
                      if ($detailsub1[30][0] != '-' && $detailsub1[30][0] != '+' && $detailsub1[30][0] != '')
                        ;
                      else
                        echo 'hidden';
                      ?>><textarea title="Informasi Tambahan" class="infoPenandaan_bL infoPenandaan_bL_txt" style="width: 99%; height: 75px;" name="CHK1[27]" value=" " id="bL_37" onchange="uTL(this)"><?php echo $detailsub1[30][0]; ?></textarea></span></td>
                  </tr>
                  <tr>
                  <!--<td class="td_left_checklist" style="vertical-align: top">37</td>-->
                    <td class="td_left_header_checklist" colspan="2">Lampiran : <?php
                      if (array_key_exists('FILE_PENANDAAN_BL', $sess) && trim($sess['FILE_PENANDAAN_BL']) != "") {
                        ?>
                        <span class="file_FILE_PENANDAAN_BL"><input type="hidden" name="PENANDAAN_OBAT[FILE_PENANDAAN_BL]" value="<?php echo $sess['FILE_PENANDAAN_BL']; ?>"><a href="<?php echo site_url(); ?>/download/penandaanIklanSubDirPostUpload/<?php echo 'penandaan_001/BL'; ?>/<?php echo $sess['FILE_PENANDAAN_BL']; ?>" target="_blank">File Lampiran</a>&nbsp;&bull;&nbsp;<a href="#" class="del_upload" url="<?php echo site_url(); ?>/utility/uploads/del_upload_m/<?php echo 'penandaan_001/BL'; ?>/<?php echo $sess['FILE_PENANDAAN_BL']; ?>" jns="FILE_PENANDAAN_BL">Edit atau Hapus File ?</a></span>
                        <?php
                      } else {
                        ?>
                        <span class="upload_FILE_PENANDAAN_BL"><input type="file" class="upload upBL" jenis="FILE_PENANDAAN_BL" allowed="jpg-jpeg-pdf-doc-docx-rar" url="<?php echo site_url(); ?>/utility/uploads/get_upload_m/<?php echo 'penandaan_001/BL'; ?>" id="fileToUpload_FILE_PENANDAAN_BL" name="userfile" onchange="do_upload($(this));
                        return false;" />
                          &nbsp;Tipe File : *.jpg .jpeg .pdf .doc .docx .rar</span><span class="file_FILE_PENANDAAN_BL"></span>
                        <?php
                      }
                      ?></td>
                  </tr>
                  <tr>
                      <!--<td class="td_left_checklist">35</td>-->
                    <td class="td_left_header_checklist">Kesimpulan</td>
                    <td class="td_left">
                      <input type="text" style="display: none" id="kesimpulanHasilPenilaianBLVal" readonly size="23" name="CHK1[HASIL]" value="<?php echo $detailsub1[31][0]; ?>" />
                      <input type="text" id="kesimpulanHasilPenilaianbL" readonly size="23" value="<?php
                      if ($detailsub1[31][0] == "TMK")
                        echo "Tidak Memenuhi Ketentuan";
                      else
                        echo "Memenuhi Ketentuan";
                      ?>" /></td>
                    <td></td>
                  </tr>
                  <tr></tr>
                  <tr></tr>
                  <tr>
                    <td class="td_left"><h2 class="small garis">Detil Pelanggaran :</h2></td>
                    <td class="td_right"><textarea readonly id="detilPelanggaranbL" name="detilPelanggaranbL" style="height: 70px; width: 99%;"></textarea></td>
                  </tr>
                  <tr></tr>
                  <tr>
                    <td class="td_left">&nbsp;</td>
                    <td class="td_right">Jumlah Jenis Pelanggaran : <span id="jumlahTMKbL"></span></td>
                  </tr>
                  <tr></tr>
                  <?php if ((in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')))) { ?>
                    <tr><td><h2 class="small garis">Kesimpulan Pusat :</h2></td></tr>
                    <?php
                    $TLBL = explode("^", $d1[5]);
                    $TLBLSub = explode("^", $d1[6]);
                    $tempBL = array($TLBL[1], $TLBL[2]);
                    $tempBLSub = array($TLBLSub[0], $TLBLSub[1]);
                    if ((empty($d1[3]) && in_array('2', $this->newsession->userdata('SESS_KODE_ROLE'))) || $editTL == 'YES') {
                      ?>
                      <tr><td class="td_left">Verifikasi Pusat</td><td class="td_right"><select id="BL" class="stext verifikasiPusat" name="<?php echo 'BL[HASIL_PUSAT][]' ?>" title="MK/TMK"><option></option><option value="MK" <?php if ($d1[3] == "MK") echo 'Selected' ?>>Memenuhi Ketentuan</option><option value="TMK" <?php if ($d1[3] == "TMK") echo 'Selected' ?>>Tidak Memenuhi Ketentuan</option></select></tr>
                      <tr class="vTMK_BL" hidden><td class="td_left">Kategori Pelanggaran</td><td class="td_right"><select class="sjenis vTMKa_BL" title="Kategori Pelanggaran"><option></option><option value="Kritikal" <?php if ($TLBL[0] == "Kritikal") echo 'Selected' ?>>Kritikal</option><option value="Non Kritikal" <?php if ($TLBL[0] == "Non Kritikal") echo 'Selected' ?>>Non Kritikal</option></select></td></tr>
                      <tr class="vTMK_BL" hidden><td class="td_left"style="background-color: white;">Tindak Lanjut</td><td class="td_right" style="background-color: white;"><?php echo form_dropdown('BL[HASIL_PUSAT][]', $cb_tl, !empty($d1[4]) ? $d1[4] : '', 'class="stext verifikasiPusatSub" id="vTMKSub_BL" title="Tindak Lanjut Pusat"'); ?></td></tr>
                      <tr class="vTMK2_BL" hidden><td class="td_left"style="background-color: white;"></td><td class="td_right" style="background-color: white;"><?php echo form_dropdown('BL[TL_PUSAT][]', $cb_tindakan, is_array($tempBL) ? $tempBL : '', 'class="stext multiselect vTMK2_BL" multiple title="Saran Tindak Lanjut Pusat. Untuk memilih lebih dari satu, klik + Ctrl"'); ?></td></tr>
                      <tr class="vTMK2_BL" hidden><td class="td_left">Surat Tindak Lanjut</td><td class="td_right"><input type="text" class="sdate vTMK2a_BL" name="BL[DETAIL_PUSAT][]" id="tglSuratTLBL" title="Tanggal Surat Tindak Lanjut" placeholder="Tanggal Surat" onchange="comp('D')" value="<?php echo$tempBLSub[0]; ?>"/>&nbsp;&nbsp;&nbsp;Tanggal Surat Tindak Lanjut</td><td></td></tr>
                      <tr></tr>
                      <tr class="vTMK2_BL" hidden><td class="td_left"></td><td class="td_right"><input type="text" class="stext vTMK2a_BL" name="BL[DETAIL_PUSAT][]" id="stugas_"  title="Di isi dengan nomor surat tindak lanjut" placeholder="Nomor Surat Tindak Lanjut" value="<?php echo $tempBLSub[1]; ?>"/>&nbsp;&nbsp;&nbsp;Nomor Surat Tindak Lanjut</td></tr>
                      <tr class="vJustifikasi_BL" hidden><td class="td_left">Justifikasi</td><td style="padding: 5px"><textarea name="JUSTIFIKASI_BL" title="Justifikasi Pusat" class="stext chkJustifikasi chkJustifikasi_BL" style="height: 140px"><?php echo $d1[7]; ?></textarea></td></tr>
                      <?php
                    } else if (!empty($d1[3])) {
                      ?>
                      <tr><td class="td_left">Verifikasi Pusat</td><td class="td_right"><b><i><?php
                              if ($d1[3] == "TMK")
                                echo "Tidak Memenuhi Ketentuan";
                              else
                                "Memenuhi Ketentuan"
                                ?></i></b></td></tr>
                      <?php if (!empty($TLBL[0])) { ?><tr><td class="td_left">Kategori Pelanggaran</td><td class="td_right"><?php echo $TLBL[0]; ?></td></tr>
                      <?php } if (!empty($d1[4])) { ?><tr><td class="td_left">Tindak Lanjut</td><td class="td_right"><?php if ($d1[4] == "TL") echo "Tindak Lanjut"; else if ($d1[4] == "STL") echo "Sudah Tindak Lanjut"; else if ($d1[4] == "TTL") echo "Tidak Dapat Tindak Lanjut" ?></td></tr>
                      <?php }if (!empty($TLBL[1])) { ?><tr><td class="td_left">Detil Tindak Lanjut Pusat</td><td class="td_right"><ul style="list-style-type:decimal; padding-left:20px; margin:0;"><?php
                        if ($TLBL[2] != '')
                          echo "<li>" . join("</li><li>", $tempBL) . "</li>";
                        else
                          echo "<li>" . $TLBL[1] . "</li>";
                        ?></ul></td></tr>
                      <?php } if (!empty($TLBLSub[0])) {
                        ?><tr><td class="td_left">Surat Tindak Lanjut</td><td class="td_right"><ul style="padding-left:20px; margin:0;"><?php
                              echo "<li>Tangal Surat : " . join("</li><li>Nomor Surat : ", $tempBLSub) . "</li>";
                              ?></ul></td></tr>
                      <?php } if (!empty($d1[7])) {
                        ?>
                        <tr><td class="td_left">Justifikasi Pusat</td><td class="td_right"><?php echo $d1[7]; ?></td></tr>
                        <?php
                      }
                    }
                  }
                  ?>
                </table>
              </div>

              <!--Sachet-->
              <div id="tabs-2" class="div_aS" hidden>
                <table class="form_tabel" style="width: 100%;">
                  <tr>
                    <td style="width: 35%;"></td>
                    <td class="td_left" style="width: 65%">
                      <input type="radio" id="r1" disabled="true">
                      <label for="r1" style="width: 54px; height: 10px;">Ada</label>
                      <span style="margin-left: 5px;"></span>
                      <input type="radio" id="r2" disabled="true">
                      <label for="r2" style="width: 54px; height: 10px;">Tidak Ada</label></td>
                  </tr>
                  <tr class="infoPenandaan_aSRow">
                      <!--<td class="td_left_checklist">1</td>-->
                    <td class="td_left_header_checklist">Nama obat  </td>
                    <td class="td_left">
                      <input class="infoPenandaan_aS" type="radio" id="radiob11_1" name="CHK2[1]" value="+_Nama Obat" <?php if ($detailsub6[0][0] == '+') echo 'checked'; ?>>
                      <label for="radiob11_1" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_aS" type="radio" id="radiob12_1" name="CHK2[1]" value="-_Nama Obat" <?php if ($detailsub6[0][0] == '-') echo 'checked'; ?>>
                      <label for="radiob12_1" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK2[1]" value="<?php echo join('_', $detailsub6[0]); ?>"></td>
                  </tr>
                  <tr class="infoPenandaan_aSRow">
                      <!--<td class="td_left_checklist">2</td>-->
                    <td class="td_left_header_checklist">Bentuk sediaan</td>
                    <td class="td_left">
                      <input class="infoPenandaan_aS" type="radio" id="radiob21_2" name="CHK2[2]" value="+_Bentuk Sediaan" <?php if ($detailsub6[1][0] == '+') echo 'checked'; ?>>
                      <label for="radiob21_2" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_aS" type="radio" id="radiob22_2" name="CHK2[2]" value="-_Bentuk Sediaan" <?php if ($detailsub6[1][0] == '-') echo 'checked'; ?>>
                      <label for="radiob22_2" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK2[2]" value="<?php echo join('_', $detailsub6[1]); ?>"></td>
                  </tr>
                  <tr class="infoPenandaan_aSRow">
                      <!--<td class="td_left_checklist">4</td>-->
                    <td class="td_left_header_checklist">Besar kemasan (unit)</td>
                    <td class="td_left">
                      <input class="infoPenandaan_aS" type="radio" id="radiob31_4" name="CHK2[4]" value="+_Besar Kemasan" <?php if ($detailsub6[2][0] == '+') echo 'checked'; ?>>
                      <label for="radiob31_4" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_aS" type="radio" id="radiob32_4" name="CHK2[4]" value="-_Besar Kemasan" <?php if ($detailsub6[2][0] == '-') echo 'checked'; ?>>
                      <label for="radiob32_4" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK2[4]" value="<?php echo join('_', $detailsub6[2]); ?>"></td>
                  </tr>
                  <tr class="infoPenandaan_aSRow">
                      <!--<td class="td_left_checklist">5</td>-->
                    <td class="td_left_header_checklist">Nama dan kekuatan zat aktif</td>
                    <td class="td_left">
                      <input class="infoPenandaan_aS" type="radio" id="radiob41_5" name="CHK2[5]" value="+_Nama dan kekuatan zat aktif" <?php if ($detailsub6[3][0] == '+') echo 'checked'; ?>>
                      <label for="radiob41_5" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_aS" type="radio" id="radiob42_5" name="CHK2[5]" value="-_Nama dan kekuatan zat aktif" <?php if ($detailsub6[3][0] == '-') echo 'checked'; ?>>
                      <label for="radiob42_5" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK2[5]" value="<?php echo join('_', $detailsub6[3]); ?>"></td>
                  </tr>
                  <tr class="infoPenandaan_aSRow">
                      <!--<td class="td_left_checklist">6a</td>-->
                    <td class="td_left_header_checklist">Nama industri pendaftar</td>
                    <td class="td_left">
                      <input class="infoPenandaan_aS" type="radio" id="radiob6a1_6" name="CHK2[6a]" value="+_Nama industri pendaftar" <?php if ($detailsub6[4][0] == '+') echo 'checked'; ?>>
                      <label for="radiob6a1_6" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_aS" type="radio" id="radiob6a2_6" name="CHK2[6a]" value="-_Nama industri pendaftar" <?php if ($detailsub6[4][0] == '-') echo 'checked'; ?>>
                      <label for="radiob6a2_6" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK2[6a]" value="<?php echo join('_', $detailsub6[4]); ?>"></td>
                  </tr>
                  <tr class="infoPenandaan_aSRow">
                      <!--<td class="td_left_checklist">6b</td>-->
                    <td class="td_left_header_checklist">Alamat industri pendaftar</td>
                    <td class="td_left">
                      <input class="infoPenandaan_aS" type="radio" id="radiob6b1_6" name="CHK2[6b]" value="+_Alamat industri pendaftar" <?php if ($detailsub6[5][0] == '+') echo 'checked'; ?>>
                      <label for="radiob6b1_6" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_aS" type="radio" id="radiob6b2_6" name="CHK2[6b]" value="-_Alamat industri pendaftar" <?php if ($detailsub6[5][0] == '-') echo 'checked'; ?>>
                      <label for="radiob6b2_6" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK2[6b]" value="<?php echo join('_', $detailsub6[5]); ?>"></td>
                  </tr>
                  <tr class="lisensiBasedaS infoPenandaan_aSRow" hidden>
                      <!--<td class="td_left_checklist">7a</td>-->
                    <td class="td_left_header_checklist">Nama industri pendaftar dan produsen obat (untuk obat kontrak)</td>
                    <td class="td_left">
                      <input class="infoPenandaan_aS" type="radio" id="radiob7a1_7" name="CHK2[7a]" value="+_Nama industri pendaftar dan produsen obat (untuk obat kontrak)" <?php if ($detailsub6[6][0] == '+') echo 'checked'; ?>>
                      <label for="radiob7a1_7" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_aS" type="radio" id="radiob7a2_7" name="CHK2[7a]" value="-_Nama industri pendaftar dan produsen obat (untuk obat kontrak)" <?php if ($detailsub6[6][0] == '-') echo 'checked'; ?>>
                      <label for="radiob7a2_7" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK2[7a]" value="<?php echo join('_', $detailsub6[6]); ?>"></td>
                  </tr>
                  <tr class="lisensiBasedaS infoPenandaan_aSRow" hidden>
                      <!--<td class="td_left_checklist">7b</td>-->
                    <td class="td_left_header_checklist">Alamat industri pendaftar dan produsen obat (untuk obat kontrak)</td>
                    <td class="td_left">
                      <input class="infoPenandaan_aS" type="radio" id="radiob7b1_7" name="CHK2[7b]" value="+_Alamat industri pendaftar dan produsen obat (untuk obat kontrak)" <?php if ($detailsub6[7][0] == '+') echo 'checked'; ?>>
                      <label for="radiob7b1_7" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_aS" type="radio" id="radiob7b2_7" name="CHK2[7b]" value="-_Alamat industri pendaftar dan produsen obat (untuk obat kontrak)" <?php if ($detailsub6[7][0] == '-') echo 'checked'; ?>>
                      <label for="radiob7b2_7" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK2[7b]" value="<?php echo join('_', $detailsub6[7]); ?>"></td>
                  </tr>
                  <tr class="infoPenandaan_aSRow">
                      <!--<td class="td_left_checklist">8a</td>-->
                    <td class="td_left_header_checklist">Nama industri pendaftar dan pemberi lisensi</td>
                    <td class="td_left">
                      <input class="infoPenandaan_aS" type="radio" id="radiob8a1_8" name="CHK2[8a]" value="+_Nama industri pendaftar dan pemberi lisensi" <?php if ($detailsub6[8][0] == '+') echo 'checked'; ?>>
                      <label for="radiob8a1_8" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_aS" type="radio" id="radiob8a2_8" name="CHK2[8a]" value="-_Nama industri pendaftar dan pemberi lisensi" <?php if ($detailsub6[8][0] == '-') echo 'checked'; ?>>
                      <label for="radiob8a2_8" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK2[8a]" value="<?php echo join('_', $detailsub6[8]); ?>"></td>
                  </tr>
                  <tr class="infoPenandaan_aSRow">
                      <!--<td class="td_left_checklist">8b</td>-->
                    <td class="td_left_header_checklist">Alamat industri pendaftar dan pemberi lisensi</td>
                    <td class="td_left">
                      <input class="infoPenandaan_aS" type="radio" id="radiob8b1_8" name="CHK2[8b]" value="+_Alamat industri pendaftar dan pemberi lisensi" <?php if ($detailsub6[9][0] == '+') echo 'checked'; ?>>
                      <label for="radiob8b1_8" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_aS" type="radio" id="radiob8b2_8" name="CHK2[8b]" value="-_Alamat industri pendaftar dan pemberi lisensi" <?php if ($detailsub6[9][0] == '-') echo 'checked'; ?>>
                      <label for="radiob8b2_8" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK2[8b]" value="<?php echo join('_', $detailsub6[9]); ?>"></td>
                  </tr>
                  <tr class="infoPenandaan_aSRow">
                      <!--<td class="td_left_checklist">9</td>-->
                    <td class="td_left_checklist">Cara pemberian</td>
                    <td class="td_left">
                      <input class="infoPenandaan_aS" type="radio" id="radiob91_9" name="CHK2[9]" value="+_Cara pemberian" <?php if ($detailsub6[10][0] == '+') echo 'checked'; ?>>
                      <label for="radiob91_9" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_aS" type="radio" id="radiob92_9" name="CHK2[9]" value="-_Cara pemberian" <?php if ($detailsub6[10][0] == '-') echo 'checked'; ?>>
                      <label for="radiob92_9" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK2[9]" value="<?php echo join('_', $detailsub6[10]); ?>"></td>
                  </tr>
                  <tr class="infoPenandaan_aSRow">
                      <!--<td class="td_left_checklist">10</td>-->
                    <td class="td_left_header_checklist">Nomor izin edar</td>
                    <td class="td_left">
                      <input class="infoPenandaan_aS" type="radio" id="radiob101_10" name="CHK2[10]" value="+_Nomor izin edar" <?php if ($detailsub6[11][0] == '+') echo 'checked'; ?>>
                      <label for="radiob101_10" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_aS" type="radio" id="radiob102_10" name="CHK2[10]" value="-_Nomor izin edar" <?php if ($detailsub6[11][0] == '-') echo 'checked'; ?>>
                      <label for="radiob102_10" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK2[10]" value="<?php echo join('_', $detailsub6[11]); ?>"></td>
                  </tr>
                  <tr class="infoPenandaan_aSRow">
                      <!--<td class="td_left_checklist">11</td>-->
                    <td class="td_left_header_checklist">Nomor bets</td>
                    <td class="td_left">
                      <input class="infoPenandaan_aS" type="radio" id="radiob111_11" name="CHK2[11]" value="+_Nomor bets" <?php if ($detailsub6[12][0] == '+') echo 'checked'; ?>>
                      <label for="radiob111_11" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_aS" type="radio" id="radiob112_11" name="CHK2[11]" value="-_Nomor bets" <?php if ($detailsub6[12][0] == '-') echo 'checked'; ?>>
                      <label for="radiob112_11" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK2[11]" value="<?php echo join('_', $detailsub6[12]); ?>"></td>
                  </tr>
                  <tr class="infoPenandaan_aSRow">
                      <!--<td class="td_left_checklist">12</td>-->
                    <td class="td_left_header_checklist">Tanggal produksi</td>
                    <td class="td_left">
                      <input class="infoPenandaan_aS" type="radio" id="radiob121_12" name="CHK2[12]" value="+_Tanggal produksi" <?php if ($detailsub6[13][0] == '+') echo 'checked'; ?>>
                      <label for="radiob121_12" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_aS" type="radio" id="radiob122_12" name="CHK2[12]" value="-_Tanggal produksi" <?php if ($detailsub6[13][0] == '-') echo 'checked'; ?>>
                      <label for="radiob122_12" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK2[12]" value="<?php echo join('_', $detailsub6[13]); ?>"></td>
                  </tr>
                  <tr class="infoPenandaan_aSRow">
                      <!--<td class="td_left_checklist">13</td>-->
                    <td class="td_left_header_checklist">Batas kadaluarsa</td>
                    <td class="td_left">
                      <input class="infoPenandaan_aS" type="radio" id="radiob131_13" name="CHK2[13]" value="+_Batas kadaluarsa" <?php if ($detailsub6[14][0] == '+') echo 'checked'; ?>>
                      <label for="radiob131_13" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_aS" type="radio" id="radiob132_13" name="CHK2[13]" value="-_Batas kadaluarsa" <?php if ($detailsub6[14][0] == '-') echo 'checked'; ?>>
                      <label for="radiob132_13" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK2[13]" value="<?php echo join('_', $detailsub6[14]); ?>"></td>
                  </tr>
                  <tr class="oKPNaS infoPenandaan_aSRow">
                      <!--<td class="td_left_checklist">16</td>-->
                    <td class="td_left_header_checklist">Indikasi</td>
                    <td class="td_left">
                      <input class="infoPenandaan_aS" type="radio" id="radiob161_16" name="CHK2[16]" value="+_Indikasi" <?php if ($detailsub6[15][0] == '+') echo 'checked'; ?>>
                      <label for="radiob161_16" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_aS" type="radio" id="radiob162_16" name="CHK2[16]" value="-_Indikasi" <?php if ($detailsub6[15][0] == '-') echo 'checked'; ?>>
                      <label for="radiob162_16" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK2[16]" value="<?php echo join('_', $detailsub6[15]); ?>"></td>
                  </tr>
                  <tr class="oKPNaS infoPenandaan_aSRow">
                      <!--<td class="td_left_checklist">17</td>-->
                    <td class="td_left_header_checklist">Posologi/Dosis</td>
                    <td class="td_left">
                      <input class="infoPenandaan_aS" type="radio" id="radiob171_17" name="CHK2[17]" value="+_Posologi/Dosis" <?php if ($detailsub6[16][0] == '+') echo 'checked'; ?>>
                      <label for="radiob171_17" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_aS" type="radio" id="radiob172_17" name="CHK2[17]" value="-_Posologi/Dosis" <?php if ($detailsub6[16][0] == '-') echo 'checked'; ?>>
                      <label for="radiob172_17" style="width: 54px; height: 10px; background-color: #9d0101;"></label><input type="text" style="display:none;" name="CHK2[17]" value="<?php echo join('_', $detailsub6[16]); ?>"></td>
                  </tr>
                  <tr class="infoPenandaan_aSRow">
                      <!--<td class="td_left_checklist">19</td>-->
                    <td class="td_left_header_checklist">Kontra indikasi</td>
                    <td class="td_left">
                      <input class="infoPenandaan_aS" type="radio" id="radiob191_19" name="CHK2[19]" value="+_Kontra indikasi" <?php if ($detailsub6[17][0] == '+') echo 'checked'; ?>>
                      <label for="radiob191_19" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_aS" type="radio" id="radiob192_19" name="CHK2[19]" value="-_Kontra indikasi" <?php if ($detailsub6[17][0] == '-') echo 'checked'; ?>>
                      <label for="radiob192_19" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK2[19]" value="<?php echo join('_', $detailsub6[17]); ?>"></td>
                  </tr>
                  <tr class="infoPenandaan_aSRow">
                      <!--<td class="td_left_checklist">20</td>-->
                    <td class="td_left_header_checklist">Efek samping</td>
                    <td class="td_left">
                      <input class="infoPenandaan_aS" type="radio" id="radiob201_20" name="CHK2[20]" value="+_Efek samping" <?php if ($detailsub6[18][0] == '+') echo 'checked'; ?>>
                      <label for="radiob201_20" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_aS" type="radio" id="radiob202_20" name="CHK2[20]" value="-_Efek samping" <?php if ($detailsub6[18][0] == '-') echo 'checked'; ?>>
                      <label for="radiob202_20" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK2[20]" value="<?php echo join('_', $detailsub6[18]); ?>"></td>
                  </tr>
                  <tr class="infoPenandaan_aSRow">
                      <!--<td class="td_left_checklist">21</td>-->
                    <td class="td_left_header_checklist">Interaksi obat</td>
                    <td class="td_left">
                      <input class="infoPenandaan_aS" type="radio" id="radiob211_21" name="CHK2[21]" value="+_Interaksi obat" <?php if ($detailsub6[19][0] == '+') echo 'checked'; ?>>
                      <label for="radiob211_21" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_aS" type="radio" id="radiob212_21" name="CHK2[21]" value="-_Interaksi obat" <?php if ($detailsub6[19][0] == '-') echo 'checked'; ?>>
                      <label for="radiob212_21" style="width: 54px; height: 10px; background-color: #9d0101;"></label><input type="text" style="display:none;" name="CHK2[21]" value="<?php echo join('_', $detailsub6[19]); ?>"></td>
                  </tr>
                  <tr class="infoPenandaan_aSRow">
                      <!--<td class="td_left_checklist">22</td>-->
                    <td class="td_left_header_checklist">Peringatan - Perhatian</td>
                    <td class="td_left">
                      <input class="infoPenandaan_aS" type="radio" id="radiob221_22" name="CHK2[22]" value="+_Peringatan - Perhatian" <?php if ($detailsub6[20][0] == '+') echo 'checked'; ?>>
                      <label for="radiob221_22" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_aS" type="radio" id="radiob222_22" name="CHK2[22]" value="-_Peringatan - Perhatian" <?php if ($detailsub6[20][0] == '-') echo 'checked'; ?>>
                      <label for="radiob222_22" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK2[22]" value="<?php echo join('_', $detailsub6[20]); ?>"></td>
                  </tr>
                  <tr class="oKPNaS infoPenandaan_aSRow"  hidden>
                      <!--<td class="td_left_checklist">28a</td>-->
                    <td class="td_left_header_checklist">"Harus dengan resep dokter"</td>
                    <td class="td_left">
                      <input class="infoPenandaan_aS" type="radio" id="radiob28a1_28RD" name="CHK2[28a]" value="+_Harus dengan resep dokter" <?php if ($detailsub6[21][0] == '+') echo 'checked'; ?>>
                      <label for="radiob28a1_28RD" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_aS" type="radio" id="radiob28a2_28RD" name="CHK2[28a]" value="-_Harus dengan resep dokter" <?php if ($detailsub6[21][0] == '-') echo 'checked'; ?>>
                      <label for="radiob28a2_28RD" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK2[28a]" value="<?php echo join('_', $detailsub6[21]); ?>"></td>
                  </tr>
                  <tr class="oTaS infoPenandaan_aSRow" hidden>
                       <!--<td class="td_left_checklist">28b</td>-->
                    <td class="td_left_header_checklist">Tanda peringatan (P No.1 - P No.6)</td>
                    <td class="td_left">
                      <input class="infoPenandaan_aS" type="radio" id="radiob28b1_28BT" name="CHK2[28b]" value="+_Tanda peringatan (P No.1 - P No.6)" <?php if ($detailsub6[22][0] == '+') echo 'checked'; ?>>
                      <label for="radiob28b1_28BT" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_aS" type="radio" id="radiob28b2_28BT" name="CHK2[28b]" value="-_Tanda peringatan (P No.1 - P No.6)" <?php if ($detailsub6[22][0] == '-') echo 'checked'; ?>>
                      <label for="radiob28b2_28BT" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK2[28b]" value="<?php echo join('_', $detailsub6[22]); ?>"></td>
                  </tr>
                  <tr style="background-color: white" class="bebasTerbatasaS infoPenandaan_aSRow" hidden>
                      <!--<td class="td_left_checklist">28c</td>-->
                    <td style="background-color: white" class="td_left_header_checklist">Kotak peringatan</td>
                    <td style="background-color: white" class="td_left">
                      <input class="infoPenandaan_aS bebasTerbatasaS2" type="radio" id="radiob28c1_28BT" name="CHK2[28c]" value="+_Kotak peringatan" <?php if ($detailsub6[23][0] == '+') echo 'checked'; ?>>
                      <label for="radiob28c1_28BT" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_aS bebasTerbatasaS2" type="radio" id="radiob28c2_28BT" name="CHK2[28c]" value="-_Kotak peringatan" <?php if ($detailsub6[23][0] == '-') echo 'checked'; ?>>
                      <label for="radiob28c2_28BT" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" class="bebasTerbatasaS3" name="CHK2[28c]" value="<?php echo join('_', $detailsub6[23]); ?>"></td>
                  </tr>
                  <tr class="infoPenandaan_aSRow">
                      <!--<td class="td_left_checklist">28d</td>-->
                    <td style="background-color: white" class="td_left_header_checklist">"Bersumber babi/bersinggungan"</td>
                    <td style="background-color: white" class="td_left">
                      <input class="infoPenandaan_aS" type="radio" id="radiob28d1_28" name="CHK2[28d]" value="+_Bersumber babi/bersinggungan" <?php if ($detailsub6[24][0] == '+') echo 'checked'; ?>>
                      <label for="radiob28d1_28" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_aS" type="radio" id="radiob28d2_28" name="CHK2[28d]" value="-_Bersumber babi/bersinggungan" <?php if ($detailsub6[24][0] == '-') echo 'checked'; ?>>
                      <label for="radiob28d2_28" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK2[28d]" value="<?php echo join('_', $detailsub6[24]); ?>"></td>
                  </tr>
                  <tr style="background-color: white" class="infoPenandaan_aSRow">
                      <!--<td class="td_left_checklist">28e</td>-->
                    <td class="td_left_header_checklist">Kandungan alkohol</td>
                    <td class="td_left">
                      <input class="infoPenandaan_aS" type="radio" id="radiob28e1_28" name="CHK2[28e]" value="+_Kandungan alkohol" <?php if ($detailsub6[25][0] == '+') echo 'checked'; ?>>
                      <label for="radiob28e1_28" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_aS" type="radio" id="radiob28e2_28" name="CHK2[28e]" value="-_Kandungan alkohol" <?php if ($detailsub6[25][0] == '-') echo 'checked'; ?>>
                      <label for="radiob28e2_28" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK2[28e]" value="<?php echo join('_', $detailsub6[25]); ?>"></td>
                  </tr>
                  <tr class="infoPenandaan_aSRow">
                      <!--<td class="td_left_checklist">29</td>-->
                    <td class="td_left_header_checklist">Cara penyimpanan obat (termasuk cara penyimpanan setelah rekonstitusi)</td>
                    <td class="td_left">
                      <input class="infoPenandaan_aS" type="radio" id="radiob291_29" name="CHK2[29]" value="+_Cara penyimpanan obat (termasuk cara penyimpanan setelah rekonstitusi)" <?php if ($detailsub6[26][0] == '+') echo 'checked'; ?>>
                      <label for="radiob291_29" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_aS" type="radio" id="radiob292_29" name="CHK2[29]" value="-_Cara penyimpanan obat (termasuk cara penyimpanan setelah rekonstitusi)" <?php if ($detailsub6[26][0] == '-') echo 'checked'; ?>>
                      <label for="radiob292_29" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK2[29]" value="<?php echo join('_', $detailsub6[26]); ?>"></td>
                  </tr>
                  <tr class="infoPenandaan_aSRow">
                      <!--<td class="td_left_checklist">32a</td>-->
                    <td style="background-color: white" class="td_left_header_checklist">Harga Eceran Tertinggi (HET)</td>
                    <td style="background-color: white" class="td_left">
                      <input class="infoPenandaan_aS" type="radio" id="radiob32a1_32" name="CHK2[32a]" value="+_Harga Eceran Tertinggi (HET)" <?php if ($detailsub6[27][0] == '+') echo 'checked'; ?>>
                      <label for="radiob32a1_32" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_aS" type="radio" id="radiob32a2_32" name="CHK2[32a]" value="-_Harga Eceran Tertinggi (HET)" <?php if ($detailsub6[27][0] == '-') echo 'checked'; ?>>
                      <label for="radiob32a2_32" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK2[32a]" value="<?php echo join('_', $detailsub6[27]); ?>"></td>
                  </tr>
                  <tr class="infoPenandaan_aSRow">
                      <!--<td class="td_left_checklist">32b</td>-->
                    <td style="background-color: white" class="td_left_header_checklist">Logo golongan obat (obat keras/bebas terbatas/bebas)</td>
                    <td style="background-color: white" class="td_left">
                      <input class="infoPenandaan_aS" type="radio" id="radiob32b1_32" name="CHK2[32b]" value="+_Logo golongan obat (obat keras/bebas terbatas/bebas)" <?php if ($detailsub6[28][0] == '+') echo 'checked'; ?>>
                      <label for="radiob32b1_32" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_aS" type="radio" id="radiob32b2_32" name="CHK2[32b]" value="-_Logo golongan obat (obat keras/bebas terbatas/bebas)" <?php if ($detailsub6[28][0] == '-') echo 'checked'; ?>>
                      <label for="radiob32b2_32" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK2[32b]" value="<?php echo join('_', $detailsub6[28]); ?>"></td>
                  </tr>
                  <tr class="logoGenerikaS infoPenandaan_aSRow" hidden>
                      <!--<td class="td_left_checklist">32c</td>-->
                    <td style="background-color: white" class="td_left_header_checklist">Logo generik</td>
                    <td style="background-color: white" class="td_left">
                      <input class="infoPenandaan_aS" type="radio" id="radiob32c1_32" name="CHK2[32c]" value="+_Logo generik" <?php if ($detailsub6[29][0] == '+') echo 'checked'; ?>>
                      <label for="radiob32c1_32" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_aS" type="radio" id="radiob32c2_32" name="CHK2[32c]" value="-_Logo generik" <?php if ($detailsub6[29][0] == '-') echo 'checked'; ?>>
                      <label for="radiob32c2_32" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK2[32c]" value="<?php echo join('_', $detailsub6[29]); ?>"></td>
                  </tr>
                  <tr></tr>
                  <tr>
                      <!--<td class="td_left_checklist" style="vertical-align: middle">36</td>-->
                    <td class="td_left_header_checklist" style="vertical-align: top"><input style="vertical-align: top;" class="infoPenandaan_aS" name="infoPenandaan_aS-36" type="checkbox" value="-_A" id="aS_36" <?php if ($detailsub6[30][0] != '-' && $detailsub6[30][0] != '+' && $detailsub6[30][0] != '') echo 'checked'; ?>/>&nbsp;Informasi Tambahan</td>
                    <td class="td_left"><span id="infoPenandaan_aS_txt" <?php
                      if ($detailsub6[30][0] != '-' && $detailsub6[30][0] != '+' && $detailsub6[30][0] != '')
                        ;
                      else
                        echo 'hidden';
                      ?>><textarea title="Informasi Tambahan" class="infoPenandaan_aS infoPenandaan_aS_txt" style="width: 99%; height: 75px;" name="CHK2[33]" id="aS_37" onchange="uTL(this)"><?php echo $detailsub6[29][0]; ?></textarea></span></td>
                  </tr>
                  <tr>
                  <!--<td class="td_left_checklist" style="vertical-align: top">37</td>-->
                    <td class="td_left_header_checklist" colspan="2">Lampiran : <?php
                      if (array_key_exists('FILE_PENANDAAN_AS', $sess) && trim($sess['FILE_PENANDAAN_AS']) != "") {
                        ?>
                        <span class="file_FILE_P
                              ENANDAAN_AS"><input type="hidden" name="PENANDAAN_OBAT[FILE_PENANDAAN_AS]" value="<?php echo $sess['FILE_PENANDAAN_AS']; ?>"><a href="<?php echo site_url(); ?>/download/penandaanIklanSubDirPostUpload/<?php echo 'penandaan_001/AS'; ?>/<?php echo $sess['FILE_PENANDAAN_AS']; ?>" target="_blank">File Lampiran</a>&nbsp;&bull;&nbsp;<a href="#" class="del_upload" url="<?php echo site_url(); ?>/utility/uploads/del_upload_m/<?php echo 'penandaan_001/AS'; ?>/<?php echo $sess['FILE_PENANDAAN_AS']; ?>" jns="FILE_PENANDAAN_AS">Edit atau Hapus File ?</a></span>
                              <?php
                            } else {
                              ?>
                        <span class="upload_FILE_PENANDAAN_AS"><input type="file" class="upload upAS" jenis="FILE_PENANDAAN_AS" allowed="jpg-jpeg-pdf-doc-docx-rar" url="<?php echo site_url(); ?>/utility/uploads/get_upload_m/<?php echo 'penandaan_001/AS'; ?>" id="fileToUpload_FILE_PENANDAAN_AS" name="userfile" onchange="do_upload($(this));
                        return false;" />
                          &nbsp;Tipe File : *.jpg .jpeg .pdf .doc .docx .rar</span><span class="file_FILE_PENANDAAN_AS"></span>
                        <?php
                      }
                      ?></td>
                  </tr>
                  <tr>
                      <!--<td class="td_left_checklist">35</td>-->
                    <td class="td_left_header_checklist">Kesimpulan</td>
                    <td class="td_left">
                      <input type="hidden" id="kesimpulanHasilPenilaianASVal" readonly size="23" name="CHK2[HASIL]" value="<?php echo $detailsub6[31][0]; ?>" />
                      <input type="text" id="kesimpulanHasilPenilaianaS" readonly size="23" value="<?php
                      if ($detailsub6[31][0] == "TMK")
                        echo "Tidak Memenuhi Ketentuan";
                      else
                        echo "Memenuhi Ketentuan";
                      ?>" /></td>
                    <td></td>
                  </tr>
                  <tr><td colspan="2">&nbsp;</td></tr>
                  <tr>
                    <td class="td_left"><h2 class="small garis">Detil Pelanggaran :</h2></td>
                    <td class="td_right"><textarea readonly id="detilPelanggaranaS" name="detilPelanggaranaS" style="height: 70px; width: 99%;"></textarea></td>
                  </tr>
                  <tr>
                    <td class="td_left">&nbsp;</td>
                    <td class="td_right">Jumlah Jenis Pelanggaran : <span id="jumlahTMKaS"></span></td>
                  </tr>
                  <tr></tr>
                  <?php if ((in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')))) { ?>
                    <tr><td colspan="2"><h2 class="small garis">Kesimpulan Pusat :</h2></td></tr>
                    <?php
                    $TLAS = explode("^", $d6[5]);
                    $TLASSub = explode("^", $d6[6]);
                    $tempAS = array($TLAS[1], $TLAS[2]);
                    $tempASSub = array($TLASSub[0], $TLASSub[1]);
                    if ((empty($d6[3]) && in_array('2', $this->newsession->userdata('SESS_KODE_ROLE'))) || $editTL == 'YES') {
                      ?>
                      <tr><td class="td_left">Verifikasi Pusat</td><td class="td_right"><select id="AS" class="stext verifikasiPusat" name="<?php echo 'AS[HASIL_PUSAT][]' ?>" title="MK/TMK"><option></option><option value="MK" <?php if ($d6[3] == "MK") echo 'Selected' ?>>Memenuhi Ketentuan</option><option value="TMK" <?php if ($d6[3] == "TMK") echo 'Selected' ?>>Tidak Memenuhi Ketentuan</option></select></tr>
                      <tr class="vTMK_AS" hidden><td class="td_left">Kategori Pelanggaran</td><td class="td_right"><select class="sjenis vTMKa_AS" title="Kategori Pelanggaran"><option></option><option value="Kritikal" <?php if ($TLAS[0] == "Kritikal") echo 'Selected' ?>>Kritikal</option><option value="Non Kritikal" <?php if ($TLAS[0] == "Non Kritikal") echo 'Selected' ?>>Non Kritikal</option></select></td></tr>
                      <tr class="vTMK_AS" hidden><td class="td_left"style="background-color: white;">Tindak Lanjut</td><td class="td_right" style="background-color: white;"><?php echo form_dropdown('AS[HASIL_PUSAT][]', $cb_tl, !empty($d6[4]) ? $d6[4] : '', 'class="stext verifikasiPusatSub" id="vTMKSub_AS" title="Tindak Lanjut Pusat"'); ?></td></tr>
                      <tr class="vTMK2_AS" hidden><td class="td_left"style="background-color: white;"></td><td class="td_right" style="background-color: white;"><?php echo form_dropdown('AS[TL_PUSAT][]', $cb_tindakan, is_array($tempAS) ? $tempAS : '', 'class="stext multiselect vTMK2_AS" multiple title="Saran Tindak Lanjut Pusat. Untuk memilih lebih dari satu, klik + Ctrl"'); ?></td></tr>
                      <tr class="vTMK2_AS" hidden><td class="td_left">Surat Tindak Lanjut</td><td class="td_right"><input type="text" class="sdate vTMK2a_AS" name="AS[DETAIL_PUSAT][]" id="tglSuratTLAS" title="Tanggal Surat Tindak Lanjut" placeholder="Tanggal Surat" onchange="comp('D')" value="<?php echo$tempASSub[0]; ?>"/>&nbsp;&nbsp;&nbsp;Tanggal Surat Tindak Lanjut</td><td></td></tr>
                      <tr class="vTMK2_AS" hidden><td class="td_left"></td><td class="td_right"><input type="text" class="stext vTMK2a_AS" name="AS[DETAIL_PUSAT][]" id="stugas_"  title="Di isi dengan nomor surat tindak lanjut" placeholder="Nomor Surat Tindak Lanjut" value="<?php echo $tempASSub[1]; ?>"/>&nbsp;&nbsp;&nbsp;Nomor Surat Tindak Lanjut</td></tr>
                      <tr class="vJustifikasi_AS" hidden><td class="td_left">Justifikasi</td><td style="padding: 5px"><textarea name="JUSTIFIKASI_AS" title="Justifikasi Pusat" class="stext chkJustifikasi chkJustifikasi_AS" style="height: 140px"><?php echo $d6[7]; ?></textarea></td></tr>
                      <?php
                    } else if (!empty($d6[3])) {
                      ?>
                      <tr><td class="td_left">Verifikasi Pusat</td><td class="td_right"><b><i><?php
                              if ($d6[3] == "TMK")
                                echo "Tidak Memenuhi Ketentuan";
                              else
                                "Memenuhi Ketentuan"
                                ?></i></b></td></tr>
                      <?php if (!empty($TLAS[0])) { ?><tr><td class="td_left">Kategori Pelanggaran</td><td class="td_right"><?php echo $TLAS[0]; ?></td></tr>
                      <?php } if (!empty($d6[4])) { ?><tr><td class="td_left">Tindak Lanjut</td><td class="td_right"><?php if ($d6[4] == "TL") echo "Tindak Lanjut"; else if ($d6[4] == "STL") echo "Sudah Tindak Lanjut"; else if ($d6[4] == "TTL") echo "Tidak Dapat Tindak Lanjut" ?></td></tr>
                      <?php }if (!empty($TLAS[1])) { ?><tr><td class="td_left">Detil Tindak Lanjut Pusat</td><td class="td_right"><ul style="list-style-type:decimal; padding-left:20px; margin:0;"><?php
                        if ($TLAS[2] != '')
                          echo "<li>" . join("</li><li>", $tempAS) . "</li>";
                        else
                          echo "<li>" . $TLAS[1] . "</li>";
                        ?></ul></td></tr>
                      <?php } if (!empty($TLASSub[0])) {
                        ?><tr><td class="td_left">Surat Tindak Lanjut</td><td class="td_right"><ul style="padding-left:20px; margin:0;"><?php
                              echo "<li>Tangal Surat : " . join("</li><li>Nomor Surat : ", $tempASSub) . "</li>";
                              ?></ul></td></tr>
                      <?php } if (!empty($d6[7])) {
                        ?>
                        <tr><td class="td_left">Justifikasi Pusat</td><td class="td_right"><?php echo $d6[7]; ?></td></tr>
                        <?php
                      }
                    }
                  }
                  ?>
                </table>
              </div>

              <!--Etiket-->
              <div id="tabs-3" class="div_eT" hidden="true">
                <table class="form_tabel" style="width: 100%;">
                  <tr>
                    <td style="width: 35%;"></td>
                    <td class="td_left" style="width: 65%">
                      <input type="radio" id="r1" disabled="true">
                      <label for="r1" style="width: 54px; height: 10px;">Ada</label>
                      <span style="margin-left: 5px;"></span>
                      <input type="radio" id="r2" disabled="true">
                      <label for="r2" style="width: 54px; height: 10px;">Tidak Ada</label></td>
                  </tr>
                  <tr class="infoPenandaan_eTRow">
                      <!--<td class="td_left_checklist">1</td>-->
                    <td class="td_left_header_checklist">Nama obat  </td>
                    <td class="td_left">
                      <input class="infoPenandaan_eT" type="radio" id="radioc11_1" name="CHK3[1]" value="+_Nama Obat" <?php if ($detailsub2[0][0] == '+') echo 'checked'; ?>>
                      <label for="radioc11_1" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_eT" type="radio" id="radioc12_1" name="CHK3[1]" value="-_Nama Obat" <?php if ($detailsub2[0][0] == '-') echo 'checked'; ?>>
                      <label for="radioc12_1" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK3[1]" value="<?php echo join('_', $detailsub2[0]); ?>"></td>
                  </tr>
                  <tr class="infoPenandaan_eTRow">
                      <!--<td class="td_left_checklist">2</td>-->
                    <td class="td_left_header_checklist">Bentuk sediaan</td>
                    <td class="td_left">
                      <input class="infoPenandaan_eT" type="radio" id="radioc21_2" name="CHK3[2]" value="+_Bentuk Sediaan" <?php if ($detailsub2[1][0] == '+') echo 'checked'; ?>>
                      <label for="radioc21_2" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_eT" type="radio" id="radioc22_2" name="CHK3[2]" value="-_Bentuk Sediaan" <?php if ($detailsub2[1][0] == '-') echo 'checked'; ?>>
                      <label for="radioc22_2" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK3[2]" value="<?php echo join('_', $detailsub2[1]); ?>"></td>
                  </tr>
                  <tr class="infoPenandaan_eTRow">
                      <!--<td class="td_left_checklist">4</td>-->
                    <td class="td_left_header_checklist">Besar kemasan (unit)</td>
                    <td class="td_left">
                      <input class="infoPenandaan_eT" type="radio" id="radioc31_4" name="CHK3[4]" value="+_Besar Kemasan" <?php if ($detailsub2[2][0] == '+') echo 'checked'; ?>>
                      <label for="radioc31_4" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_eT" type="radio" id="radioc32_4" name="CHK3[4]" value="-_Besar Kemasan" <?php if ($detailsub2[2][0] == '-') echo 'checked'; ?>>
                      <label for="radioc32_4" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK3[4]" value="<?php echo join('_', $detailsub2[2]); ?>"></td>
                  </tr>
                  <tr class="infoPenandaan_eTRow">
                      <!--<td class="td_left_checklist">5</td>-->
                    <td class="td_left_header_checklist">Nama dan kekuatan zat aktif</td>
                    <td class="td_left">
                      <input class="infoPenandaan_eT" type="radio" id="radioc41_5" name="CHK3[5]" value="+_Nama dan kekuatan zat aktif" <?php if ($detailsub2[3][0] == '+') echo 'checked'; ?>>
                      <label for="radioc41_5" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_eT" type="radio" id="radioc42_5" name="CHK3[5]" value="-_Nama dan kekuatan zat aktif" <?php if ($detailsub2[3][0] == '-') echo 'checked'; ?>>
                      <label for="radioc42_5" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK3[5]" value="<?php echo join('_', $detailsub2[3]); ?>"></td>
                  </tr>
                  <tr class="infoPenandaan_eTRow">
                      <!--<td class="td_left_checklist">6a</td>-->
                    <td class="td_left_header_checklist">Nama industri pendaftar</td>
                    <td class="td_left">
                      <input class="infoPenandaan_eT" type="radio" id="radioc6a1_6" name="CHK3[6a]" value="+_Nama industri pendaftar" <?php if ($detailsub2[4][0] == '+') echo 'checked'; ?>>
                      <label for="radioc6a1_6" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_eT" type="radio" id="radioc6a2_6" name="CHK3[6a]" value="-_Nama industri pendaftar" <?php if ($detailsub2[4][0] == '-') echo 'checked'; ?>>
                      <label for="radioc6a2_6" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK3[6a]" value="<?php echo join('_', $detailsub2[4]); ?>"></td>
                  </tr>
                  <tr class="infoPenandaan_eTRow">
                      <!--<td class="td_left_checklist">6b</td>-->
                    <td class="td_left_header_checklist">Alamat industri pendaftar</td>
                    <td class="td_left">
                      <input class="infoPenandaan_eT" type="radio" id="radioc6b1_6" name="CHK3[6b]" value="+_Alamat industri pendaftar" <?php if ($detailsub2[5][0] == '+') echo 'checked'; ?>>
                      <label for="radioc6b1_6" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_eT" type="radio" id="radioc6b2_6" name="CHK3[6b]" value="-_Alamat industri pendaftar" <?php if ($detailsub2[5][0] == '-') echo 'checked'; ?>>
                      <label for="radioc6b2_6" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK3[6b]" value="<?php echo join('_', $detailsub2[5]); ?>"></td>
                  </tr>
                  <tr class="lisensiBasedeT infoPenandaan_eTRow" hidden>
                      <!--<td class="td_left_checklist">7a</td>-->
                    <td class="td_left_header_checklist">Nama industri pendaftar dan produsen obat (untuk obat kontrak)</td>
                    <td class="td_left">
                      <input class="infoPenandaan_eT" type="radio" id="radioc7a1_7" name="CHK3[7a]" value="+_Nama industri pendaftar dan produsen obat (untuk obat kontrak)" <?php if ($detailsub2[6][0] == '+') echo 'checked'; ?>>
                      <label for="radioc7a1_7" style="width: 54px; height: 10px;" value=" "></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_eT" type="radio" id="radioc7a2_7" name="CHK3[7a]" value="-_Nama industri pendaftar dan produsen obat (untuk obat kontrak)" <?php if ($detailsub2[6][0] == '-') echo 'checked'; ?>>
                      <label for="radioc7a2_7" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK3[7a]" value="<?php echo join('_', $detailsub2[6]); ?>"></td>
                  </tr>
                  <tr class="lisensiBasedeT infoPenandaan_eTRow" hidden>
                      <!--<td class="td_left_checklist">7b</td>-->
                    <td class="td_left_header_checklist">Alamat industri pendaftar dan produsen obat (untuk obat kontrak)</td>
                    <td class="td_left">
                      <input class="infoPenandaan_eT" type="radio" id="radioc7b1_7" name="CHK3[7b]" value="+_Alamat industri pendaftar dan produsen obat (untuk obat kontrak)" <?php if ($detailsub2[7][0] == '+') echo 'checked'; ?>>
                      <label for="radioc7b1_7" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_eT" type="radio" id="radioc7b2_7" name="CHK3[7b]" value="-_Alamat industri pendaftar dan produsen obat (untuk obat kontrak)" <?php if ($detailsub2[7][0] == '-') echo 'checked'; ?>>
                      <label for="radioc7b2_7" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK3[7b]" value="<?php echo join('_', $detailsub2[7]); ?>"></td>
                  </tr>
                  <tr class="infoPenandaan_eTRow">
                      <!--<td class="td_left_checklist">8a</td>-->
                    <td class="td_left_header_checklist">Nama industri pendaftar dan pemberi lisensi</td>
                    <td class="td_left">
                      <input class="infoPenandaan_eT" type="radio" id="radioc8a1_8" name="CHK3[8a]" value="+_Nama industri pendaftar dan pemberi lisensi" <?php if ($detailsub2[8][0] == '+') echo 'checked'; ?>>
                      <label for="radioc8a1_8" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_eT" type="radio" id="radioc8a2_8" name="CHK3[8a]" value="-_Nama industri pendaftar dan pemberi lisensi" <?php if ($detailsub2[8][0] == '-') echo 'checked'; ?>>
                      <label for="radioc8a2_8" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK3[8a]" value="<?php echo join('_', $detailsub2[8]); ?>"></td>
                  </tr>
                  <tr class="infoPenandaan_eTRow">
                      <!--<td class="td_left_checklist">8b</td>-->
                    <td class="td_left_header_checklist">Alamat industri pendaftar dan pemberi lisensi</td>
                    <td class="td_left">
                      <input class="infoPenandaan_eT" type="radio" id="radioc8b1_8" name="CHK3[8b]" value="+_Alamat industri pendaftar dan pemberi lisensi" <?php if ($detailsub2[9][0] == '-') echo 'checked'; ?>>
                      <label for="radioc8b1_8" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_eT" type="radio" id="radioc8b2_8" name="CHK3[8b]" value="-_Alamat industri pendaftar dan pemberi lisensi" <?php if ($detailsub2[9][0] == '-') echo 'checked'; ?>>
                      <label for="radioc8b2_8" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK3[8b]" value="<?php echo join('_', $detailsub2[9]); ?>"></td>
                  </tr>
                  <tr class="infoPenandaan_eTRow">
                      <!--<td class="td_left_checklist">9</td>-->
                    <td class="td_left_checklist">Cara pemberian</td>
                    <td class="td_left">
                      <input class="infoPenandaan_eT" type="radio" id="radioc91_9" name="CHK3[9]" value="+_Cara pemberian" <?php if ($detailsub2[10][0] == '+') echo 'checked'; ?>>
                      <label for="radioc91_9" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_eT" type="radio" id="radioc92_9" name="CHK3[9]" value="-_Cara pemberian" <?php if ($detailsub2[10][0] == '-') echo 'checked'; ?>>
                      <label for="radioc92_9" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK3[9]" value="<?php echo join('_', $detailsub2[10]); ?>"></td>
                  </tr>
                  <tr class="infoPenandaan_eTRow">
                      <!--<td class="td_left_checklist">10</td>-->
                    <td class="td_left_header_checklist">Nomor izin edar</td>
                    <td class="td_left">
                      <input class="infoPenandaan_eT" type="radio" id="radioc101_10" name="CHK3[10]" value="+_Nomor izin edar" <?php if ($detailsub2[11][0] == '+') echo 'checked'; ?>>
                      <label for="radioc101_10" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_eT" type="radio" id="radioc102_10" name="CHK3[10]" value="-_Nomor izin edar" <?php if ($detailsub2[11][0] == '-') echo 'checked'; ?>>
                      <label for="radioc102_10" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK3[10]" value="<?php echo join('_', $detailsub2[11]); ?>"></td>
                  </tr>
                  <tr class="infoPenandaan_eTRow">
                      <!--<td class="td_left_checklist">11</td>-->
                    <td class="td_left_header_checklist">Nomor bets</td>
                    <td class="td_left">
                      <input class="infoPenandaan_eT" type="radio" id="radioc111_11" name="CHK3[11]" value="+_Nomor bets" <?php if ($detailsub2[12][0] == '+') echo 'checked'; ?>>
                      <label for="radioc111_11" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_eT" type="radio" id="radioc112_11" name="CHK3[11]" value="-_Nomor bets" <?php if ($detailsub2[12][0] == '-') echo 'checked'; ?>>
                      <label for="radioc112_11" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK3[11]" value="<?php echo join('_', $detailsub2[12]); ?>"></td>
                  </tr>
                  <tr class="infoPenandaan_eTRow">
                      <!--<td class="td_left_checklist">13</td>-->
                    <td class="td_left_header_checklist">Batas kadaluarsa</td>
                    <td class="td_left">
                      <input class="infoPenandaan_eT" type="radio" id="radioc131_13" name="CHK3[13]" value="+_Batas kadaluarsa" <?php if ($detailsub2[13][0] == '+') echo 'checked'; ?>>
                      <label for="radioc131_13" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_eT" type="radio" id="radioc132_13" name="CHK3[13]" value="-_Batas kadaluarsa" <?php if ($detailsub2[13][0] == '-') echo 'checked'; ?>>
                      <label for="radioc132_13" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK3[13]" value="<?php echo join('_', $detailsub2[13]); ?>"></td>
                  </tr>
                  <tr class="oKBTeT infoPenandaan_eTRow">
                      <!--<td class="td_left_checklist">16</td>-->
                    <td class="td_left_header_checklist">Indikasi</td>
                    <td class="td_left">
                      <input class="infoPenandaan_eT" type="radio" id="radioc161_16" name="CHK3[16]" value="+_Indikasi" <?php if ($detailsub2[14][0] == '+') echo 'checked'; ?>>
                      <label for="radioc161_16" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_eT" type="radio" id="radioc162_16" name="CHK3[16]" value="-_Indikasi " <?php if ($detailsub2[14][0] == '-') echo 'checked'; ?>>
                      <label for="radioc162_16" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK3[16]" value="<?php echo join('_', $detailsub2[14]); ?>"></td>
                  </tr>
                  <tr class="oKBTeT infoPenandaan_eTRow">
                      <!--<td class="td_left_checklist">17</td>-->
                    <td class="td_left_header_checklist">Posologi/Dosis</td>
                    <td class="td_left">
                      <input class="infoPenandaan_eT" type="radio" id="radioc171_17" name="CHK3[17]" value="+_Posologi/Dosis" <?php if ($detailsub2[15][0] == '+') echo 'checked'; ?>>
                      <label for="radioc171_17" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_eT" type="radio" id="radioc172_17" name="CHK3[17]" value="-_Posologi/Dosis" <?php if ($detailsub2[15][0] == '-') echo 'checked'; ?>>
                      <label for="radioc172_17" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK3[17]" value="<?php echo join('_', $detailsub2[15]); ?>"></td>
                  </tr>
                  <tr class="infoPenandaan_eTRow">
                      <!--<td class="td_left_checklist">19</td>-->
                    <td class="td_left_header_checklist">Kontra indikasi</td>
                    <td class="td_left">
                      <input class="infoPenandaan_eT" type="radio" id="radioc191_19" name="CHK3[19]" value="+_Kontra indikasi" <?php if ($detailsub2[16][0] == '+') echo 'checked'; ?>>
                      <label for="radioc191_19" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_eT" type="radio" id="radioc192_19" name="CHK3[19]" value="-_Kontra indikasi" <?php if ($detailsub2[16][0] == '-') echo 'checked'; ?>>
                      <label for="radioc192_19" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK3[19]" value="<?php echo join('_', $detailsub2[16]); ?>"></td>
                  </tr>
                  <tr class="infoPenandaan_eTRow">
                      <!--<td class="td_left_checklist">20</td>-->
                    <td class="td_left_header_checklist">Efek samping</td>
                    <td class="td_left">
                      <input class="infoPenandaan_eT" type="radio" id="radioc201_20" name="CHK3[20]" value="+_Efek samping" <?php if ($detailsub2[17][0] == '+') echo 'checked'; ?>>
                      <label for="radioc201_20" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_eT" type="radio" id="radioc202_20" name="CHK3[20]" value="-_Efek samping" <?php if ($detailsub2[17][0] == '-') echo 'checked'; ?>>
                      <label for="radioc202_20" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK3[20]" value="<?php echo join('_', $detailsub2[17]); ?>"></td>
                  </tr>
                  <tr class="infoPenandaan_eTRow">
                      <!--<td class="td_left_checklist">21</td>-->
                    <td class="td_left_header_checklist">Interaksi obat</td>
                    <td class="td_left">
                      <input class="infoPenandaan_eT" type="radio" id="radioc211_21" name="CHK3[21]" value="+_Interaksi obat" <?php if ($detailsub2[18][0] == '+') echo 'checked'; ?>>
                      <label for="radioc211_21" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_eT" type="radio" id="radioc212_21" name="CHK3[21]" value="-_Interaksi obat" <?php if ($detailsub2[18][0] == '-') echo 'checked'; ?>>
                      <label for="radioc212_21" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK3[21]" value="<?php echo join('_', $detailsub2[18]); ?>"></td>
                  </tr>
                  <tr class="infoPenandaan_eTRow">
                      <!--<td class="td_left_checklist">22</td>-->
                    <td class="td_left_header_checklist">Peringatan - Perhatian</td>
                    <td class="td_left">
                      <input class="infoPenandaan_eT" type="radio" id="radioc221_22" name="CHK3[22]" value="+_Peringatan - Perhatian" <?php if ($detailsub2[19][0] == '+') echo 'checked'; ?>>
                      <label for="radioc221_22" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_eT" type="radio" id="radioc222_22" name="CHK3[22]" value="-_Peringatan - Perhatian" <?php if ($detailsub2[19][0] == '-') echo 'checked'; ?>>
                      <label for="radioc222_22" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK3[22]" value="<?php echo join('_', $detailsub2[19]); ?>"></td>
                  </tr>
                  <tr class="oKPNeT infoPenandaan_eTRow"  hidden="true">
                      <!--<td class="td_left_checklist">28a</td>-->
                    <td class="td_left_header_checklist">"Harus dengan resep dokter"</td>
                    <td class="td_left">
                      <input class="infoPenandaan_eT" type="radio" id="radioc28a1_28RD" name="CHK3[28a]" value="+_Harus dengan resep dokter" <?php if ($detailsub2[20][0] == '+') echo 'checked'; ?>>
                      <label for="radioc28a1_28RD" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_eT" type="radio" id="radioc28a2_28RD" name="CHK3[28a]" <?php if ($detailsub2[20][0] == '-') echo 'checked'; ?> value="-_Harus dengan resep dokter">
                      <label for="radioc28a2_28RD" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK3[28a]" value="<?php echo join('_', $detailsub2[20]); ?>"></td>
                  </tr>
                  <tr class="oTeT infoPenandaan_eTRow" hidden="true">
                       <!--<td class="td_left_checklist">28b</td>-->
                    <td class="td_left_header_checklist">Tanda peringatan (P No.1 - P No.6)</td>
                    <td class="td_left">
                      <input class="infoPenandaan_eT" type="radio" id="radioc28b1_28BT" name="CHK3[28b]" value="+_Tanda peringatan (P No.1 - P No.6)" <?php if ($detailsub2[21][0] == '+') echo 'checked'; ?>>
                      <label for="radioc28b1_28BT" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_eT" type="radio" id="radioc28b2_28BT" name="CHK3[28b]" value="-_Tanda peringatan (P No.1 - P No.6)" <?php if ($detailsub2[21][0] == '-') echo 'checked'; ?>>
                      <label for="radioc28b2_28BT" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK3[28b]" value="<?php echo join('_', $detailsub2[21]); ?>"></td>
                  </tr>
                  <tr style="background-color: white" class="bebasTerbataseT infoPenandaan_eTRow" hidden>
                      <!--<td class="td_left_checklist">28c</td>-->
                    <td style="background-color: white" class="td_left_header_checklist">Kotak peringatan</td>
                    <td style="background-color: white" class="td_left">
                      <input class="infoPenandaan_eT bebasTerbataseT2" type="radio" id="radioc28c1_28BT" name="CHK3[28c]" value="+_Kotak peringatan" <?php if ($detailsub2[22][0] == '+') echo 'checked'; ?>>
                      <label for="radioc28c1_28BT" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_eT bebasTerbataseT2" type="radio" id="radioc28c2_28BT" name="CHK3[28c]" value="-_Kotak peringatan" <?php if ($detailsub2[22][0] == '-') echo 'checked'; ?>>
                      <label for="radioc28c2_28BT" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" class="bebasTerbataseT3" name="CHK3[28c]" value="<?php echo join('_', $detailsub2[22]); ?>"></td>
                  </tr>
                  <tr class="infoPenandaan_eTRow">
                      <!--<td class="td_left_checklist">28d</td>-->
                    <td style="background-color: white" class="td_left_header_checklist">"Bersumber babi/bersinggungan"</td>
                    <td style="background-color: white" class="td_left">
                      <input class="infoPenandaan_eT" type="radio" id="radioc28d1_28" name="CHK3[28d]" value="+_Bersumber babi/bersinggungan" <?php if ($detailsub2[23][0] == '+') echo 'checked'; ?>>
                      <label for="radioc28d1_28" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_eT" type="radio" id="radioc28d2_28" name="CHK3[28d]" value="-_Bersumber babi/bersinggungan" <?php if ($detailsub2[23][0] == '-') echo 'checked'; ?>>
                      <label for="radioc28d2_28" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK3[28d]" value="<?php echo join('_', $detailsub2[23]); ?>"></td>
                  </tr>
                  <tr style="background-color: white" class="infoPenandaan_eTRow">
                      <!--<td class="td_left_checklist">28e</td>-->
                    <td class="td_left_header_checklist">Kandungan alkohol</td>
                    <td class="td_left">
                      <input class="infoPenandaan_eT" type="radio" id="radioc28e1_28" name="CHK3[28e]" value="+_Kandungan alkohol" <?php if ($detailsub2[24][0] == '+') echo 'checked'; ?>>
                      <label for="radioc28e1_28" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_eT" type="radio" id="radioc28e2_28" name="CHK3[28e]" value="-_Kandungan alkohol" <?php if ($detailsub2[24][0] == '-') echo 'checked'; ?>>
                      <label for="radioc28e2_28" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK3[28e]" value="<?php echo join('_', $detailsub2[24]); ?>"></td>
                  </tr>
                  <tr class="infoPenandaan_eTRow">
                      <!--<td class="td_left_checklist">29</td>-->
                    <td class="td_left_header_checklist">Cara penyimpanan obat (termasuk cara penyimpanan setelah rekonstitusi)</td>
                    <td class="td_left">
                      <input class="infoPenandaan_eT" type="radio" id="radioc291_29" name="CHK3[29]" value="+_Cara penyimpanan obat (termasuk cara penyimpanan setelah rekonstitusi)" <?php if ($detailsub2[25][0] == '+') echo 'checked'; ?>>
                      <label for="radioc291_29" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_eT" type="radio" id="radioc292_29" name="CHK3[29]" value="-_Cara penyimpanan obat (termasuk cara penyimpanan setelah rekonstitusi)" <?php if ($detailsub2[25][0] == '-') echo 'checked'; ?>>
                      <label for="radioc292_29" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK3[29]" value="<?php echo join('_', $detailsub2[25]); ?>"></td>
                  </tr>
                  <tr class="infoPenandaan_eTRow">
                      <!--<td class="td_left_checklist">32a</td>-->
                    <td style="background-color: white" class="td_left_header_checklist">Harga Eceran Tertinggi (HET)</td>
                    <td style="background-color: white" class="td_left">
                      <input class="infoPenandaan_eT" type="radio" id="radioc32a1_32" name="CHK3[32a]" value="+_Harga Eceran Tertinggi (HET)" <?php if ($detailsub2[26][0] == '+') echo 'checked'; ?>>
                      <label for="radioc32a1_32" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_eT" type="radio" id="radioc32a2_32" name="CHK3[32a]" value="-_Harga Eceran Tertinggi (HET)" <?php if ($detailsub2[26][0] == '-') echo 'checked'; ?>>
                      <label for="radioc32a2_32" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK3[32a]" value="<?php echo join('_', $detailsub2[26]); ?>"></td>
                  </tr>
                  <tr class="infoPenandaan_eTRow">
                      <!--<td class="td_left_checklist">32b</td>-->
                    <td style="background-color: white" class="td_left_header_checklist">Logo golongan obat (obat keras/ bebas terbatas/ bebas)</td>
                    <td style="background-color: white" class="td_left">
                      <input class="infoPenandaan_eT" type="radio" id="radioc32b1_32" name="CHK3[32b]" value="+_Logo golongan obat (obat keras/bebas terbatas/bebas)" <?php if ($detailsub2[27][0] == '+') echo 'checked'; ?>>
                      <label for="radioc32b1_32" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_eT" type="radio" id="radioc32b2_32" name="CHK3[32b]" value="-_Logo golongan obat (obat keras/bebas terbatas/bebas)" <?php if ($detailsub2[27][0] == '-') echo 'checked'; ?>>
                      <label for="radioc32b2_32" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK3[32b]" value="<?php echo join('_', $detailsub2[27]); ?>"></td>
                  </tr>
                  <tr  class="logoGenerikeT infoPenandaan_eTRow" hidden>
                      <!--<td class="td_left_checklist">32c</td>-->
                    <td style="background-color: white" class="td_left_header_checklist">Logo generik</td>
                    <td style="background-color: white" class="td_left">
                      <input class="infoPenandaan_eT" type="radio" id="radioc32c1_32" name="CHK3[32c]" value="+_Logo generik" <?php if ($detailsub2[28][0] == '+') echo 'checked'; ?>>
                      <label for="radioc32c1_32" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_eT" type="radio" id="radioc32c2_32" name="CHK3[32c]" value="-_Logo generik" <?php if ($detailsub2[28][0] == '-') echo 'checked'; ?>>
                      <label for="radioc32c2_32" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK3[32c]" value="<?php echo join('_', $detailsub2[28]); ?>"></td>
                  </tr>
                  <tr>
                      <!--<td class="td_left_checklist" style="vertical-align: middle">36</td>-->
                    <td class="td_left_header_checklist" style="vertical-align: top"><input style="vertical-align: top;" class="infoPenandaan_eT" name="infoPenandaan_eT-36" type="checkbox" value="-_A" id="eT_36" <?php if ($detailsub2[29][0] != '-' && $detailsub2[29][0] != '+' && $detailsub2[29][0] != '') echo 'checked'; ?>/>&nbsp;Informasi Tambahan</td>
                    <td class="td_left"><span id="infoPenandaan_eT_txt" <?php
                      if ($detailsub2[29][0] != '-' && $detailsub2[29][0] != '+' && $detailsub2[29][0] != '')
                        ;
                      else
                        echo 'hidden';
                      ?>><textarea title="Informasi Tambahan" class="infoPenandaan_eT infoPenandaan_eT_txt" style="width: 99%; height: 75px;" name="CHK3[33]" id="eT_37" onchange="uTL(this)"><?php echo $detailsub2[29][0]; ?></textarea></span></td>
                  </tr>
                  <tr>
                  <!--<td class="td_left_checklist" style="vertical-align: top">37</td>-->
                    <td class="td_left_header_checklist" colspan="2">Lampiran : <?php
                      if (array_key_exists('FILE_PENANDAAN_ET', $sess) && trim($sess['FILE_PENANDAAN_ET']) != "") {
                        ?>
                        <span class="file_FILE_PENANDAAN_ET"><input type="hidden" name="PENANDAAN_OBAT[FILE_PENANDAAN_ET]" value="<?php echo $sess['FILE_PENANDAAN_ET']; ?>"><a href="<?php echo site_url(); ?>/download/penandaanIklanSubDirPostUpload/<?php echo 'penandaan_001/ET'; ?>/<?php echo $sess['FILE_PENANDAAN_ET']; ?>" target="_blank">File Lampiran</a>&nbsp;&bull;&nbsp;<a href="#" class="del_upload" url="<?php echo site_url(); ?>/utility/uploads/del_upload_m/<?php echo 'penandaan_001/ET'; ?>/<?php echo $sess['FILE_PENANDAAN_ET']; ?>" jns="FILE_PENANDAAN_ET">Edit atau Hapus File ?</a></span>
                        <?php
                      } else {
                        ?>
                        <span class="upload_FILE_PENANDAAN_ET"><input type="file" class="upload upET" jenis="FILE_PENANDAAN_ET" allowed="jpg-jpeg-pdf-doc-docx-rar" url="<?php echo site_url(); ?>/utility/uploads/get_upload_m/<?php echo 'penandaan_001/ET'; ?>" id="fileToUpload_FILE_PENANDAAN_ET" name="userfile" onchange="do_upload($(this));
                        return false;" />
                          &nbsp;Tipe File : *.jpg .jpeg .pdf .doc .docx .rar</span><span class="file_FILE_PENANDAAN_ET"></span>
                        <?php
                      }
                      ?></td>
                  </tr>
                  <tr>
                      <!--<td class="td_left_checklist">35</td>-->
                    <td class="td_left_header_checklist">Kesimpulan</td>
                    <td class="td_left">
                      <input type="hidden" id="kesimpulanHasilPenilaianETVal" readonly size="23" name="CHK3[HASIL]" value="<?php echo $detailsub2[30][0]; ?>" />
                      <input type="text" id="kesimpulanHasilPenilaianeT" readonly size="23" value="<?php
                      if ($detailsub2[30][0] == "TMK")
                        echo "Tidak Memenuhi Ketentuan";
                      else
                        echo "Memenuhi Ketentuan";
                      ?>" /></td>
                  </tr>
                  <tr><td colspan="2">&nbsp;</td></tr>
                  <tr>
                    <td class="td_left"><h2 class="small garis">Detil Pelanggaran :</h2></td>
                    <td class="td_right"><textarea readonly id="detilPelanggaraneT" name="detilPelanggaraneT" style="height: 70px; width: 99%;"></textarea></td>
                  </tr>
                  <tr>
                    <td class="td_left">&nbsp;</td>
                    <td class="td_right">Jumlah Jenis Pelanggaran : <span id="jumlahTMKeT"></span></td>
                  </tr>
                  <tr></tr>
                  <?php if ((in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')))) { ?>
                    <tr><td colspan="2"><h2 class="small garis">Kesimpulan Pusat :</h2></td></tr>
                    <?php
                    $TLET = explode("^", $d2[5]);
                    $TLETSub = explode("^", $d2[6]);
                    $tempET = array($TLET[1], $TLET[2]);
                    $tempETSub = array($TLETSub[0], $TLETSub[1]);
                    if ((empty($d2[3]) && in_array('2', $this->newsession->userdata('SESS_KODE_ROLE'))) || $editTL == 'YES') {
                      ?>
                      <tr><td class="td_left">Verifikasi Pusat</td><td class="td_right"><select id="ET" class="stext verifikasiPusat" name="<?php echo 'ET[HASIL_PUSAT][]' ?>" title="MK/TMK"><option></option><option value="MK" <?php if ($d2[3] == "MK") echo 'Selected' ?>>Memenuhi Ketentuan</option><option value="TMK" <?php if ($d2[3] == "TMK") echo 'Selected' ?>>Tidak Memenuhi Ketentuan</option></select></tr>
                      <tr class="vTMK_ET" hidden><td class="td_left">Kategori Pelanggaran</td><td class="td_right"><select class="sjenis vTMKa_ET" title="Kategori Pelanggaran"><option></option><option value="Kritikal" <?php if ($TLET[0] == "Kritikal") echo 'Selected' ?>>Kritikal</option><option value="Non Kritikal" <?php if ($TLET[0] == "Non Kritikal") echo 'Selected' ?>>Non Kritikal</option></select></td></tr>
                      <tr class="vTMK_ET" hidden><td class="td_left"style="background-color: white;">Tindak Lanjut</td><td class="td_right" style="background-color: white;"><?php echo form_dropdown('ET[HASIL_PUSAT][]', $cb_tl, !empty($d2[4]) ? $d2[4] : '', 'class="stext verifikasiPusatSub" id="vTMKSub_ET" title="Tindak Lanjut Pusat"'); ?></td></tr>
                      <tr class="vTMK2_ET" hidden><td class="td_left"style="background-color: white;"></td><td class="td_right" style="background-color: white;"><?php echo form_dropdown('ET[TL_PUSAT][]', $cb_tindakan, is_array($tempET) ? $tempET : '', 'class="stext multiselect vTMK2_ET" multiple title="Saran Tindak Lanjut Pusat. Untuk memilih lebih dari satu, klik + Ctrl"'); ?></td></tr>
                      <tr class="vTMK2_ET" hidden><td class="td_left">Surat Tindak Lanjut</td><td class="td_right"><input type="text" class="sdate vTMK2a_ET" name="ET[DETAIL_PUSAT][]" id="tglSuratTLET" title="Tanggal Surat Tindak Lanjut" placeholder="Tanggal Surat" onchange="comp('D')" value="<?php echo$tempETSub[0]; ?>"/>&nbsp;&nbsp;&nbsp;Tanggal Surat Tindak Lanjut</td><td></td></tr>
                      <tr class="vTMK2_ET" hidden><td class="td_left"></td><td class="td_right"><input type="text" class="stext vTMK2a_ET" name="ET[DETAIL_PUSAT][]" id="stugas_"  title="Di isi dengan nomor surat tindak lanjut" placeholder="Nomor Surat Tindak Lanjut" value="<?php echo $tempETSub[1]; ?>"/>&nbsp;&nbsp;&nbsp;Nomor Surat Tindak Lanjut</td></tr>
                      <tr class="vJustifikasi_ET" hidden><td class="td_left">Justifikasi</td><td style="padding: 5px"><textarea name="JUSTIFIKASI_ET" title="Justifikasi Pusat" class="stext chkJustifikasi chkJustifikasi_ET" style="height: 140px"><?php echo $d2[7]; ?></textarea></td></tr>
                      <?php
                    } else if (!empty($d2[3])) {
                      ?>
                      <tr><td class="td_left">Verifikasi Pusat</td><td class="td_right"><b><i><?php
                              if ($d2[3] == "TMK")
                                echo "Tidak Memenuhi Ketentuan";
                              else
                                "Memenuhi Ketentuan"
                                ?></i></b></td></tr>
                      <?php if (!empty($TLET[0])) { ?><tr><td class="td_left">Kategori Pelanggaran</td><td class="td_right"><?php echo $TLET[0]; ?></td></tr>
                      <?php } if (!empty($d2[4])) { ?><tr><td class="td_left">Tindak Lanjut</td><td class="td_right"><?php if ($d2[4] == "TL") echo "Tindak Lanjut"; else if ($d2[4] == "STL") echo "Sudah Tindak Lanjut"; else if ($d2[4] == "TTL") echo "Tidak Dapat Tindak Lanjut" ?></td></tr>
                      <?php }if (!empty($TLET[1])) { ?><tr><td class="td_left">Detil Tindak Lanjut Pusat</td><td class="td_right"><ul style="list-style-type:decimal; padding-left:20px; margin:0;"><?php
                        if ($TLET[2] != '')
                          echo "<li>" . join("</li><li>", $tempET) . "</li>";
                        else
                          echo "<li>" . $TLET[1] . "</li>";
                        ?></ul></td></tr>
                      <?php } if (!empty($TLETSub[0])) {
                        ?><tr><td class="td_left">Surat Tindak Lanjut</td><td class="td_right"><ul style="padding-left:20px; margin:0;"><?php
                              echo "<li>Tangal Surat : " . join("</li><li>Nomor Surat : ", $tempETSub) . "</li>";
                              ?></ul></td></tr>
                      <?php } if (!empty($d2[7])) {
                        ?>
                        <tr><td class="td_left">Justifikasi Pusat</td><td class="td_right"><?php echo $d2[7]; ?></td></tr>
                        <?php
                      }
                    }
                  }
                  ?>
                </table>
              </div>

              <!--Strip/Blister-->
              <div id="tabs-4" class="div_sB" hidden="true">
                <table class="form_tabel" style="width: 100%;">
                  <tr>
                    <td style="width: 35%;"></td>
                    <td class="td_left" style="width: 65%">
                      <input type="radio" id="r1" disabled="true">
                      <label for="r1" style="width: 54px; height: 10px;">Ada</label>
                      <span style="margin-left: 5px;"></span>
                      <input type="radio" id="r2" disabled="true">
                      <label for="r2" style="width: 54px; height: 10px;">Tidak Ada</label></td>
                  </tr>
                  <tr class="infoPenandaan_sBRow">
                      <!--<td class="td_left_checklist">1</td>-->
                    <td class="td_left_header_checklist">Nama obat  </td>
                    <td class="td_left">
                      <input class="infoPenandaan_sB" type="radio" id="radiod11_1" name="CHK4[1]" value="+_Nama Obat" <?php if ($detailsub7[0][0] == '+') echo 'checked'; ?>>
                      <label for="radiod11_1" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_sB" type="radio" id="radiod12_1" name="CHK4[1]" value="-_Nama Obat" <?php if ($detailsub7[0][0] == '-') echo 'checked'; ?>>
                      <label for="radiod12_1" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" style="display:none;" style="display:none;" style="display:none;" name="CHK4[1]" value="<?php echo join('_', $detailsub7[0]); ?>"></td>
                  </tr>
                  <tr class="infoPenandaan_sBRow">
                      <!--<td class="td_left_checklist">5</td>-->
                    <td class="td_left_header_checklist">Nama dan kekuatan zat aktif</td>
                    <td class="td_left">
                      <input class="infoPenandaan_sB" type="radio" id="radiod41_5" name="CHK4[5]" value="+_Nama dan kekuatan zat aktif" <?php if ($detailsub7[1][0] == '+') echo 'checked'; ?>>
                      <label for="radiod41_5" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_sB" type="radio" id="radiod42_5" name="CHK4[5]" value="-_Nama dan kekuatan zat aktif" <?php if ($detailsub7[1][0] == '-') echo 'checked'; ?>>
                      <label for="radiod42_5" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" style="display:none;" style="display:none;" style="display:none;" name="CHK4[5]" value="<?php echo join('_', $detailsub7[1]); ?>"></td>
                  </tr>
                  <tr class="infoPenandaan_sBRow">
                      <!--<td class="td_left_checklist">6a</td>-->
                    <td class="td_left_header_checklist">Nama industri pendaftar</td>
                    <td class="td_left">
                      <input class="infoPenandaan_sB" type="radio" id="radiod6a1_6" name="CHK4[6a]" value="+_Nama industri pendaftar" <?php if ($detailsub7[2][0] == '+') echo 'checked'; ?>>
                      <label for="radiod6a1_6" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_sB" type="radio" id="radiod6a2_6" name="CHK4[6a]" value="-_Nama industri pendaftar" <?php if ($detailsub7[2][0] == '-') echo 'checked'; ?>>
                      <label for="radiod6a2_6" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" style="display:none;" style="display:none;" style="display:none;" name="CHK4[6a]" value="<?php echo join('_', $detailsub7[2]); ?>"></td>
                  </tr>
                  <tr class="lisensiBasedsB infoPenandaan_sBRow" hidden>
                      <!--<td class="td_left_checklist">7a</td>-->
                    <td class="td_left_header_checklist">Nama industri pendaftar dan produsen obat (untuk obat kontrak)</td>
                    <td class="td_left">
                      <input class="infoPenandaan_sB" type="radio" id="radiod7a1_7" name="CHK4[7a]" value="+_Nama industri pendaftar dan produsen obat (untuk obat kontrak)" <?php if ($detailsub7[3][0] == '+') echo 'checked'; ?>>
                      <label for="radiod7a1_7" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_sB" type="radio" id="radiod7a2_7" name="CHK4[7a]" value="-_Nama industri pendaftar dan produsen obat (untuk obat kontrak)" <?php if ($detailsub7[3][0] == '-') echo 'checked'; ?>>
                      <label for="radiod7a2_7" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" style="display:none;" style="display:none;" style="display:none;" name="CHK4[7a]" value="<?php echo join('_', $detailsub7[3]); ?>"></td>
                  </tr>
                  <tr class="infoPenandaan_sBRow">
                      <!--<td class="td_left_checklist">8a</td>-->
                    <td class="td_left_header_checklist">Nama industri pendaftar dan pemberi lisensi</td>
                    <td class="td_left">
                      <input class="infoPenandaan_sB" type="radio" id="radiod8a1_8" name="CHK4[8a]" value="+_Nama industri pendaftar dan pemberi lisensi" <?php if ($detailsub7[4][0] == '+') echo 'checked'; ?>>
                      <label for="radiod8a1_8" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_sB" type="radio" id="radiod8a2_8" name="CHK4[8a]" value="-_Nama industri pendaftar dan pemberi lisensi" <?php if ($detailsub7[4][0] == '-') echo 'checked'; ?>>
                      <label for="radiod8a2_8" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" style="display:none;" style="display:none;" style="display:none;" name="CHK4[8a]" value="<?php echo join('_', $detailsub7[4]); ?>"></td>
                  </tr>
                  <tr class="infoPenandaan_sBRow">
                      <!--<td class="td_left_checklist">10</td>-->
                    <td class="td_left_header_checklist">Nomor izin edar</td>
                    <td class="td_left">
                      <input class="infoPenandaan_sB" type="radio" id="radiod101_10" name="CHK4[10]" value="+_Nomor izin edar" <?php if ($detailsub7[5][0] == '+') echo 'checked'; ?>>
                      <label for="radiod101_10" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_sB" type="radio" id="radiod102_10" name="CHK4[10]" value="-_Nomor izin edar" <?php if ($detailsub7[5][0] == '-') echo 'checked'; ?>>
                      <label for="radiod102_10" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" style="display:none;" style="display:none;" style="display:none;" name="CHK4[10]" value="<?php echo join('_', $detailsub7[5]); ?>"></td>
                  </tr>
                  <tr class="infoPenandaan_sBRow">
                      <!--<td class="td_left_checklist">11</td>-->
                    <td class="td_left_header_checklist">Nomor bets</td>
                    <td class="td_left">
                      <input class="infoPenandaan_sB" type="radio" id="radiod111_11" name="CHK4[11]" value="+_Nomor bets" <?php if ($detailsub7[6][0] == '+') echo 'checked'; ?>>
                      <label for="radiod111_11" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_sB" type="radio" id="radiod112_11" name="CHK4[11]" value="-_Nomor bets" <?php if ($detailsub7[6][0] == '-') echo 'checked'; ?>>
                      <label for="radiod112_11" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" style="display:none;" style="display:none;" style="display:none;" name="CHK4[11]" value="<?php echo join('_', $detailsub7[6]); ?>"></td>
                  </tr>
                  <tr class="infoPenandaan_sBRow">
                      <!--<td class="td_left_checklist">13</td>-->
                    <td class="td_left_header_checklist">Batas kadaluarsa</td>
                    <td class="td_left">
                      <input class="infoPenandaan_sB" type="radio" id="radiod131_13" name="CHK4[13]" value="+_Batas kadaluarsa" <?php if ($detailsub7[7][0] == '+') echo 'checked'; ?>>
                      <label for="radiod131_13" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_sB" type="radio" id="radiod132_13" name="CHK4[13]" value="-_Batas kadaluarsa" <?php if ($detailsub7[7][0] == '-') echo 'checked'; ?>>
                      <label for="radiod132_13" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" style="display:none;" style="display:none;" style="display:none;" name="CHK4[13]" value="<?php echo join('_', $detailsub7[7]); ?>"></td>
                  </tr>
                  <tr class="oKPNsB infoPenandaan_sBRow"  hidden>
                      <!--<td class="td_left_checklist">28a</td>-->
                    <td class="td_left_header_checklist">"Harus dengan resep dokter"</td>
                    <td class="td_left">
                      <input class="infoPenandaan_sB" type="radio" id="radiod28a1_28RD" name="CHK4[28a]" value="+_Harus dengan resep dokter" <?php if ($detailsub7[8][0] == '+') echo 'checked'; ?>>
                      <label for="radiod28a1_28RD" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_sB" type="radio" id="radiod28a2_28RD" name="CHK4[28a]" value="-_Harus dengan resep dokter" <?php if ($detailsub7[8][0] == '-') echo 'checked'; ?>>
                      <label for="radiod28a2_28RD" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" style="display:none;" style="display:none;" style="display:none;" name="CHK4[28a]" value="<?php echo join('_', $detailsub7[8]); ?>"></td>
                  </tr>
                  <tr class="infoPenandaan_sBRow">
                      <!--<td class="td_left_checklist">32a</td>-->
                    <td style="background-color: white" class="td_left_header_checklist">Harga Eceran Tertinggi (HET)</td>
                    <td style="background-color: white" class="td_left">
                      <input class="infoPenandaan_sB" type="radio" id="radiod32a1_32" name="CHK4[32a]" value="+_Harga Eceran Tertinggi (HET)" <?php if ($detailsub7[9][0] == '+') echo 'checked'; ?>>
                      <label for="radiod32a1_32" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_sB" type="radio" id="radiod32a2_32" name="CHK4[32a]" value="-_Harga Eceran Tertinggi (HET)" <?php if ($detailsub7[9][0] == '-') echo 'checked'; ?>>
                      <label for="radiod32a2_32" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" style="display:none;" style="display:none;" style="display:none;" name="CHK4[32a]" value="<?php echo join('_', $detailsub7[9]); ?>"></td>
                  </tr>
                  <tr class="logoGeneriksB infoPenandaan_sBRow" hidden>
                      <!--<td class="td_left_checklist">32c</td>-->
                    <td style="background-color: white" class="td_left_header_checklist">Logo generik</td>
                    <td style="background-color: white" class="td_left">
                      <input class="infoPenandaan_sB" type="radio" id="radiod32c1_32" name="CHK4[32c]" value="+_Logo generik" <?php if ($detailsub7[10][0] == '+') echo 'checked'; ?>>
                      <label for="radiod32c1_32" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_sB" type="radio" id="radiod32c2_32" name="CHK4[32c]" value="-_Logo generik" <?php if ($detailsub7[10][0] == '-') echo 'checked'; ?>>
                      <label for="radiod32c2_32" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" style="display:none;" style="display:none;" style="display:none;" name="CHK4[32c]" value="<?php echo join('_', $detailsub7[10]); ?>"></td>
                  </tr>
                  <tr>
                      <!--<td class="td_left_checklist" style="vertical-align: middle">36</td>-->
                    <td class="td_left_header_checklist" style="vertical-align: top"><input style="vertical-align: top;" class="infoPenandaan_sB" name="infoPenandaan_sB-36" type="checkbox" value="-_A" id="sB_36" <?php if ($detailsub7[11][0] != '-' && $detailsub7[11][0] != '+' && $detailsub7[11][0] != '') echo 'checked'; ?>/>&nbsp;Informasi Tambahan</td>
                    <td class="td_left"><span id="infoPenandaan_sB_txt" <?php
                      if ($detailsub7[11][0] != '-' && $detailsub7[11][0] != '+' && $detailsub7[11][0] != '')
                        ;
                      else
                        echo 'hidden';
                      ?>><textarea title="Informasi Tambahan" class="infoPenandaan_sB infoPenandaan_sB_txt" style="width: 99%; height: 75px;" name="CHK4[33]" value=" " id="sB_37" onchange="uTL(this)"><?php echo $detailsub7[11][0]; ?></textarea></span></td>
                  </tr>
                  <tr>
                  <!--<td class="td_left_checklist" style="vertical-align: top">37</td>-->
                    <td class="td_left_header_checklist" colspan="2">Lampiran : <?php
                      if (array_key_exists('FILE_PENANDAAN_SB', $sess) && trim($sess['FILE_PENANDAAN_SB']) != "") {
                        ?>
                        <span class="file_FILE_PENANDAAN_SB"><input type="hidden" name="PENANDAAN_OBAT[FILE_PENANDAAN_SB]" value="<?php echo $sess['FILE_PENANDAAN_SB']; ?>"><a href="<?php echo site_url(); ?>/download/penandaanIklanSubDirPostUpload/<?php echo 'penandaan_001/SB'; ?>/<?php echo $sess['FILE_PENANDAAN_SB']; ?>" target="_blank">File Lampiran</a>&nbsp;&bull;&nbsp;<a href="#" class="del_upload" url="<?php echo site_url(); ?>/utility/uploads/del_upload_m/<?php echo 'penandaan_001/SB'; ?>/<?php echo $sess['FILE_PENANDAAN_SB']; ?>" jns="FILE_PENANDAAN_SB">Edit atau Hapus File ?</a></span>
                        <?php
                      } else {
                        ?>
                        <span class="upload_FILE_PENANDAAN_SB"><input type="file" class="upload upSB" jenis="FILE_PENANDAAN_SB" allowed="jpg-jpeg-pdf-doc-docx-rar" url="<?php echo site_url(); ?>/utility/uploads/get_upload_m/<?php echo 'penandaan_001/SB'; ?>" id="fileToUpload_FILE_PENANDAAN_SB" name="userfile" onchange="do_upload($(this));
                        return false;" />
                          &nbsp;Tipe File : *.jpg .jpeg .pdf. doc .docx .rar</span><span class="file_FILE_PENANDAAN_SB"></span>
                        <?php
                      }
                      ?></td>
                  </tr>
                  <tr>
                      <!--<td class="td_left_checklist">35</td>-->
                    <td class="td_left_header_checklist">Kesimpulan</td>
                    <td class="td_left">
                      <input type="hidden" id="kesimpulanHasilPenilaianSBVal" readonly size="23" name="CHK4[HASIL]" value="<?php echo $detailsub7[12][0]; ?>" />
                      <input type="text" id="kesimpulanHasilPenilaiansB" readonly size="23" value="<?php
                      if ($detailsub7[12][0] == "TMK")
                        echo "Tidak Memenuhi Ketentuan";
                      else
                        echo "Memenuhi Ketentuan";
                      ?>" /></td>
                    <td></td>
                  </tr>
                  <tr></tr>
                  <tr></tr>
                  <tr>
                    <td class="td_left"><h2 class="small garis">Detil Pelanggaran :</h2></td>
                    <td class="td_right"><textarea readonly id="detilPelanggaransB" name="detilPelanggaransB" style="height: 70px; width: 99%;"></textarea></td>
                  </tr>
                  <tr></tr>
                  <tr>
                    <td class="td_left">&nbsp;</td>
                    <td class="td_right">Jumlah Jenis Pelanggaran : <span id="jumlahTMKsB"></span></td>
                  </tr>
                  <tr></tr>
                  <?php if ((in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')))) { ?>
                    <tr><td colspan="2"><h2 class="small garis">Kesimpulan Pusat :</h2></td></tr>
                    <?php
                    $TLSB = explode("^", $d7[5]);
                    $TLSBSub = explode("^", $d7[6]);
                    $tempSB = array($TLSB[1], $TLSB[2]);
                    $tempSBSub = array($TLSBSub[0], $TLSBSub[1]);
                    if ((empty($d7[3]) && in_array('2', $this->newsession->userdata('SESS_KODE_ROLE'))) || $editTL == 'YES') {
                      ?>
                      <tr><td class="td_left">Verifikasi Pusat</td><td class="td_right"><select id="SB" class="stext verifikasiPusat" name="<?php echo 'SB[HASIL_PUSAT][]' ?>" title="MK/TMK"><option></option><option value="MK" <?php if ($d7[3] == "MK") echo 'Selected' ?>>Memenuhi Ketentuan</option><option value="TMK" <?php if ($d7[3] == "TMK") echo 'Selected' ?>>Tidak Memenuhi Ketentuan</option></select></tr>
                      <tr class="vTMK_SB" hidden><td class="td_left">Kategori Pelanggaran</td><td class="td_right"><select class="sjenis vTMKa_SB" title="Kategori Pelanggaran"><option></option><option value="Kritikal" <?php if ($TLSB[0] == "Kritikal") echo 'Selected' ?>>Kritikal</option><option value="Non Kritikal" <?php if ($TLSB[0] == "Non Kritikal") echo 'Selected' ?>>Non Kritikal</option></select></td></tr>
                      <tr class="vTMK_SB" hidden><td class="td_left"style="background-color: white;">Tindak Lanjut</td><td class="td_right" style="background-color: white;"><?php echo form_dropdown('SB[HASIL_PUSAT][]', $cb_tl, !empty($d7[4]) ? $d7[4] : '', 'class="stext verifikasiPusatSub" id="vTMKSub_SB" title="Tindak Lanjut Pusat"'); ?></td></tr>
                      <tr class="vTMK2_SB" hidden><td class="td_left"style="background-color: white;"></td><td class="td_right" style="background-color: white;"><?php echo form_dropdown('SB[TL_PUSAT][]', $cb_tindakan, is_array($tempSB) ? $tempSB : '', 'class="stext multiselect vTMK2_SB" multiple title="Saran Tindak Lanjut Pusat. Untuk memilih lebih dari satu, klik + Ctrl"'); ?></td></tr>
                      <tr class="vTMK2_SB" hidden><td class="td_left">Surat Tindak Lanjut</td><td class="td_right"><input type="text" class="sdate vTMK2a_SB" name="SB[DETAIL_PUSAT][]" id="tglSuratTLSB" title="Tanggal Surat Tindak Lanjut" placeholder="Tanggal Surat" onchange="comp('D')" value="<?php echo$tempSBSub[0]; ?>"/>&nbsp;&nbsp;&nbsp;Tanggal Surat Tindak Lanjut</td><td></td></tr>
                      <tr class="vTMK2_SB" hidden><td class="td_left"></td><td class="td_right"><input type="text" class="stext vTMK2a_SB" name="SB[DETAIL_PUSAT][]" id="stugas_"  title="Di isi dengan nomor surat tindak lanjut" placeholder="Nomor Surat Tindak Lanjut" value="<?php echo $tempSBSub[1]; ?>"/>&nbsp;&nbsp;&nbsp;Nomor Surat Tindak Lanjut</td></tr>
                      <tr class="vJustifikasi_SB" hidden><td class="td_left">Justifikasi</td><td style="padding: 5px"><textarea name="JUSTIFIKASI_SB" title="Justifikasi Pusat" class="stext chkJustifikasi chkJustifikasi_SB" style="height: 140px"><?php echo $d7[7]; ?></textarea></td></tr>
                      <?php
                    } else if (!empty($d7[3])) {
                      ?>
                      <tr><td class="td_left">Verifikasi Pusat</td><td class="td_right" colspan="2"><b><i><?php
                              if ($d7[3] == "TMK")
                                echo "Tidak Memenuhi Ketentuan";
                              else
                                "Memenuhi Ketentuan"
                                ?></i></b></td></tr>
                      <?php if (!empty($TLSB[0])) { ?><tr><td class="td_left">Kategori Pelanggaran</td><td class="td_right"><?php echo $TLSB[0]; ?></td></tr>
                      <?php } if (!empty($d7[4])) { ?><tr><td class="td_left">Tindak Lanjut</td><td class="td_right"><?php if ($d7[4] == "TL") echo "Tindak Lanjut"; else if ($d7[4] == "STL") echo "Sudah Tindak Lanjut"; else if ($d7[4] == "TTL") echo "Tidak Dapat Tindak Lanjut" ?></td></tr>
                      <?php }if (!empty($TLSB[1])) { ?><tr><td class="td_left">Detil Tindak Lanjut Pusat</td><td class="td_right"><ul style="list-style-type:decimal; padding-left:20px; margin:0;"><?php
                        if ($TLSB[2] != '')
                          echo "<li>" . join("</li><li>", $tempSB) . "</li>";
                        else
                          echo "<li>" . $TLSB[1] . "</li>";
                        ?></ul></td></tr>
                      <?php } if (!empty($TLSBSub[0])) {
                        ?><tr><td class="td_left">Surat Tindak Lanjut</td><td class="td_right"><ul style="padding-left:20px; margin:0;"><?php
                              echo "<li>Tangal Surat : " . join("</li><li>Nomor Surat : ", $tempSBSub) . "</li>";
                              ?></ul></td></tr>
                      <?php } if (!empty($d7[7])) {
                        ?>
                        <tr><td class="td_left">Justifikasi Pusat</td><td class="td_right"><?php echo $d7[7]; ?></td></tr>
                        <?php
                      }
                    }
                  }
                  ?>
                </table>
              </div>

              <!--Ampul/ Vial > 10 ML-->
              <div id="tabs-5" class="div_v1" hidden="true">
                <table class="form_tabel" style="width: 100%;">
                  <tr>
                    <td style="width: 35%;"></td>
                    <td class="td_left" style="width: 65%">
                      <input type="radio" id="r1" disabled="true">
                      <label for="r1" style="width: 54px; height: 10px;">Ada</label>
                      <span style="margin-left: 5px;"></span>
                      <input type="radio" id="r2" disabled="true">
                      <label for="r2" style="width: 54px; height: 10px;">Tidak Ada</label></td>
                  </tr>
                  <tr class="infoPenandaan_v1Row">
                      <!--<td class="td_left_checklist">1</td>-->
                    <td class="td_left_header_checklist">Nama obat  </td>
                    <td class="td_left">
                      <input class="infoPenandaan_v1" type="radio" id="radioe11_1" name="CHK5[1]" value="+_Nama Obat" <?php if ($detailsub3[0][0] == '+') echo 'checked'; ?>>
                      <label for="radioe11_1" style="width: 54px; height: 10px;" ></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_v1" type="radio" id="radioe12_1" name="CHK5[1]" value="-_Nama Obat" <?php if ($detailsub3[0][0] == '-') echo 'checked'; ?>>
                      <label for="radioe12_1" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                    <input type="text" style="display:none;" name="CHK5[1]" value="<?php echo join('_', $detailsub3[0]); ?>"><td>
                  </tr>
                  <tr class="infoPenandaan_v1Row">
                      <!--<td class="td_left_checklist">2</td>-->
                    <td class="td_left_header_checklist">Bentuk sediaan</td>
                    <td class="td_left">
                      <input class="infoPenandaan_v1" type="radio" id="radioe21_2" name="CHK5[2]" value="+_Bentuk Sediaan" <?php if ($detailsub3[1][0] == '+') echo 'checked'; ?>>
                      <label for="radioe21_2" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_v1" type="radio" id="radioe22_2" name="CHK5[2]" value="-_Bentuk Sediaan" <?php if ($detailsub3[1][0] == '-') echo 'checked'; ?>>
                      <label for="radioe22_2" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK5[2]" value="<?php echo join('_', $detailsub3[1]); ?>"></td>
                  </tr>
                  <tr class="infoPenandaan_v1Row">
                      <!--<td class="td_left_checklist">4</td>-->
                    <td class="td_left_header_checklist">Besar kemasan (unit)</td>
                    <td class="td_left">
                      <input class="infoPenandaan_v1" type="radio" id="radioe31_4" name="CHK5[4]" value="+_Besar Kemasan" <?php if ($detailsub3[2][0] == '+') echo 'checked'; ?>>
                      <label for="radioe31_4" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_v1" type="radio" id="radioe32_4" name="CHK5[4]" value="-_Besar Kemasan" <?php if ($detailsub3[2][0] == '-') echo 'checked'; ?>>
                      <label for="radioe32_4" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK5[4]" value="<?php echo join('_', $detailsub3[2]); ?>"></td>
                  </tr>
                  <tr class="infoPenandaan_v1Row">
                      <!--<td class="td_left_checklist">5</td>-->
                    <td class="td_left_header_checklist">Nama dan kekuatan zat aktif</td>
                    <td class="td_left">
                      <input class="infoPenandaan_v1" type="radio" id="radioe41_5" name="CHK5[5]" value="+_Nama dan kekuatan zat aktif" <?php if ($detailsub3[3][0] == '+') echo 'checked'; ?>>
                      <label for="radioe41_5" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_v1" type="radio" id="radioe42_5" name="CHK5[5]" value="-_Nama dan kekuatan zat aktif" <?php if ($detailsub3[3][0] == '-') echo 'checked'; ?>>
                      <label for="radioe42_5" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK5[5]" value="<?php echo join('_', $detailsub3[3]); ?>"></td>
                  </tr>
                  <tr class="infoPenandaan_v1Row">
                      <!--<td class="td_left_checklist">6a</td>-->
                    <td class="td_left_header_checklist">Nama industri pendaftar</td>
                    <td class="td_left">
                      <input class="infoPenandaan_v1" type="radio" id="radioe6a1_6" name="CHK5[6a]" value="+_Nama industri pendaftar" <?php if ($detailsub3[4][0] == '+') echo 'checked'; ?>>
                      <label for="radioe6a1_6" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_v1" type="radio" id="radioe6a2_6" name="CHK5[6a]" value="-_Nama industri pendaftar" <?php if ($detailsub3[4][0] == '-') echo 'checked'; ?>>
                      <label for="radioe6a2_6" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK5[6a]" value="<?php echo join('_', $detailsub3[4]); ?>"></td>
                  </tr>
                  <tr class=" infoPenandaan_v1Row" hidden>
                      <!--<td class="td_left_checklist">7a</td>-->
                    <td class="td_left_header_checklist">Nama industri pendaftar dan produsen obat (untuk obat kontrak)</td>
                    <td class="td_left">
                      <input class="infoPenandaan_v1" type="radio" id="radioe7a1_7" name="CHK5[7a]" value="-+_Nama industri pendaftar dan produsen obat (untuk obat kontrak)" <?php if ($detailsub3[5][0] == '+') echo 'checked'; ?>>
                      <label for="radioe7a1_7" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_v1" type="radio" id="radioe7a2_7" name="CHK5[7a]" value="-_Nama industri pendaftar dan produsen obat (untuk obat kontrak)" <?php if ($detailsub3[5][0] == '-') echo 'checked'; ?>>
                      <label for="radioe7a2_7" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK5[7a]" value="<?php echo join('_', $detailsub3[5]); ?>"></td>
                  </tr>
                  <tr class="infoPenandaan_v1Row">
                      <!--<td class="td_left_checklist">8a</td>-->
                    <td class="td_left_header_checklist">Nama industri pendaftar dan pemberi lisensi</td>
                    <td class="td_left">
                      <input class="infoPenandaan_v1" type="radio" id="radioe8a1_8" name="CHK5[8a]" value="+_Nama industri pendaftar dan pemberi lisensi" <?php if ($detailsub3[6][0] == '+') echo 'checked'; ?>>
                      <label for="radioe8a1_8" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_v1" type="radio" id="radioe8a2_8" name="CHK5[8a]" value="-_Nama industri pendaftar dan pemberi lisensi" <?php if ($detailsub3[6][0] == '-') echo 'checked'; ?>>
                      <label for="radioe8a2_8" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK5[8a]" value="<?php echo join('_', $detailsub3[6]); ?>"></td>
                  </tr>
                  <tr class="infoPenandaan_v1Row">
                      <!--<td class="td_left_checklist">9</td>-->
                    <td class="td_left_checklist">Cara pemberian</td>
                    <td class="td_left">
                      <input class="infoPenandaan_v1" type="radio" id="radioe91_9" name="CHK5[9]" value="+_Cara pemberian" <?php if ($detailsub3[7][0] == '+') echo 'checked'; ?>>
                      <label for="radioe91_9" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_v1" type="radio" id="radioe92_9" name="CHK5[9]" value="-_Cara pemberian" <?php if ($detailsub3[7][0] == '-') echo 'checked'; ?>>
                      <label for="radioe92_9" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK5[9]" value="<?php echo join('_', $detailsub3[7]); ?>"></td>
                  </tr>
                  <tr class="infoPenandaan_v1Row">
                      <!--<td class="td_left_checklist">10</td>-->
                    <td class="td_left_header_checklist">Nomor izin edar</td>
                    <td class="td_left">
                      <input class="infoPenandaan_v1" type="radio" id="radioe101_10" name="CHK5[10]" value="+_Nomor izin edar" <?php if ($detailsub3[8][0] == '+') echo 'checked'; ?>>
                      <label for="radioe101_10" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_v1" type="radio" id="radioe102_10" name="CHK5[10]" value="-_Nomor izin edar" <?php if ($detailsub3[8][0] == '-') echo 'checked'; ?>>
                      <label for="radioe102_10" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK5[10]" value="<?php echo join('_', $detailsub3[8]); ?>"></td>
                  </tr>
                  <tr class="infoPenandaan_v1Row">
                      <!--<td class="td_left_checklist">11</td>-->
                    <td class="td_left_header_checklist">Nomor bets</td>
                    <td class="td_left">
                      <input class="infoPenandaan_v1" type="radio" id="radioe111_11" name="CHK5[11]" value="+_Nomor bets" <?php if ($detailsub3[9][0] == '+') echo 'checked'; ?>>
                      <label for="radioe111_11" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_v1" type="radio" id="radioe112_11" name="CHK5[11]" value="-_Nomor bets" <?php if ($detailsub3[9][0] == '-') echo 'checked'; ?>>
                      <label for="radioe112_11" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK5[11]" value="<?php echo join('_', $detailsub3[9]); ?>"></td>
                  </tr>
                  <tr class="infoPenandaan_v1Row">
                      <!--<td class="td_left_checklist">13</td>-->
                    <td class="td_left_header_checklist">Batas kadaluarsa</td>
                    <td class="td_left">
                      <input class="infoPenandaan_v1" type="radio" id="radioe131_13" name="CHK5[13]" value="+_Batas kadaluarsa" <?php if ($detailsub3[10][0] == '+') echo 'checked'; ?>>
                      <label for="radioe131_13" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_v1" type="radio" id="radioe132_13" name="CHK5[13]" value="-_Batas kadaluarsa" <?php if ($detailsub3[10][0] == '-') echo 'checked'; ?>>
                      <label for="radioe132_13" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK5[13]" value="<?php echo join('_', $detailsub3[10]); ?>"></td>
                  </tr>
                  <tr class="oKPNv1 infoPenandaan_v1Row"  hidden>
                      <!--<td class="td_left_checklist">28a</td>-->
                    <td class="td_left_header_checklist">"Harus dengan resep dokter"</td>
                    <td class="td_left">
                      <input class="infoPenandaan_v1" type="radio" id="radioe28a1_28RD" name="CHK5[28a]" value="+_Harus dengan resep dokter" <?php if ($detailsub3[11][0] == '+') echo 'checked'; ?>>
                      <label for="radioe28a1_28RD" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_v1" type="radio" id="radioe28a2_28RD" name="CHK5[28a]" value="-_Harus dengan resep dokter" <?php if ($detailsub3[11][0] == '-') echo 'checked'; ?>>
                      <label for="radioe28a2_28RD" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK5[28a]" value="<?php echo join('_', $detailsub3[11]); ?>"></td>
                  </tr>
                  <tr class="infoPenandaan_v1Row">
                      <!--<td class="td_left_checklist">28d</td>-->
                    <td style="background-color: white" class="td_left_header_checklist">"Bersumber babi/bersinggungan"</td>
                    <td style="background-color: white" class="td_left">
                      <input class="infoPenandaan_v1" type="radio" id="radioe28d1_28" name="CHK5[28d]" value="+_Bersumber babi/bersinggungan" <?php if ($detailsub3[12][0] == '+') echo 'checked'; ?>>
                      <label for="radioe28d1_28" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_v1" type="radio" id="radioe28d2_28" name="CHK5[28d]" value="-_Bersumber babi/bersinggungan" <?php if ($detailsub3[12][0] == '-') echo 'checked'; ?>>
                      <label for="radioe28d2_28" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK5[28d]" value="<?php echo join('_', $detailsub3[12]); ?>"></td>
                  </tr>
                  <tr style="background-color: white" class="infoPenandaan_v1Row">
                      <!--<td class="td_left_checklist">28e</td>-->
                    <td class="td_left_header_checklist">Kandungan alkohol</td>
                    <td class="td_left">
                      <input class="infoPenandaan_v1" type="radio" id="radioe28e1_28" name="CHK5[28e]" value="+_Kandungan alkohol" <?php if ($detailsub3[13][0] == '+') echo 'checked'; ?>>
                      <label for="radioe28e1_28" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_v1" type="radio" id="radioe28e2_28" name="CHK5[28e]" value="-_Kandungan alkohol" <?php if ($detailsub3[13][0] == '-') echo 'checked'; ?>>
                      <label for="radioe28e2_28" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK5[28e]" value="<?php echo join('_', $detailsub3[13]); ?>"></td>
                  </tr>
         <!--         <tr class="infoPenandaan_v1Row">
                      <td class="td_left_checklist">29</td>
                   <td class="td_left_header_checklist">Cara penyimpanan obat (termasuk cara penyimpanan setelah rekonstitusi)</td>
                   <td class="td_left">
                    <input class="infoPenandaan_v1" type="radio" id="radioe291" name="CHK5[29]" value="+_Cara penyimpanan obat (termasuk cara penyimpanan setelah rekonstitusi)" <?php if ($detailsub3[14][0] == '+') echo 'checked'; ?>>
                    <label for="radioe291" style="width: 54px; height: 10px;"></label>
                    <span style="margin-left: 5px;"></span>
                    <input class="infoPenandaan_v1" type="radio" id="radioe292" name="CHK5[29]" value="-_Cara penyimpanan obat (termasuk cara penyimpanan setelah rekonstitusi)" <?php if ($detailsub3[14][0] == '-') echo 'checked'; ?>>
                    <label for="radioe292" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                    <input type="text" style="display:none;" name="CHK5[29]" value="<?php echo join('_', $detailsub3[14]); ?>"></td>
                  </tr>-->
                  <input type="hidden" style="display:none;" name="CHK5[29]" value="<?php echo join('_', $detailsub3[14]); ?>" value="">
                  <tr class="infoPenandaan_v1Row">
                      <!--<td class="td_left_checklist">32a</td>-->
                    <td style="background-color: white" class="td_left_header_checklist">Harga Eceran Tertinggi (HET)</td>
                    <td style="background-color: white" class="td_left">
                      <input class="infoPenandaan_v1" type="radio" id="radioe32a1_32" name="CHK5[32a]" value="+_Harga Eceran Tertinggi (HET)" <?php if ($detailsub3[15][0] == '+') echo 'checked'; ?>>
                      <label for="radioe32a1_32" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_v1" type="radio" id="radioe32a2_32" name="CHK5[32a]" value="-_Harga Eceran Tertinggi (HET)" <?php if ($detailsub3[15][0] == '-') echo 'checked'; ?>>
                      <label for="radioe32a2_32" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK5[32a]" value="<?php echo join('_', $detailsub3[15]); ?>"></td>
                  </tr>
                  <tr class="logoGenerikv1 infoPenandaan_v1Row" hidden>
                      <!--<td class="td_left_checklist">32c</td>-->
                    <td style="background-color: white" class="td_left_header_checklist">Logo generik</td>
                    <td style="background-color: white" class="td_left">
                      <input class="infoPenandaan_v1" type="radio" id="radioe32c1_32" name="CHK5[32c]" value="+_Logo generik" <?php if ($detailsub3[16][0] == '+') echo 'checked'; ?>>
                      <label for="radioe32c1_32" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_v1" type="radio" id="radioe32c2_32" name="CHK5[32c]" value="-_Logo generik" <?php if ($detailsub3[16][0] == '-') echo 'checked'; ?>>
                      <label for="radioe32c2_32" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK5[32c]" value="<?php echo join('_', $detailsub3[16]); ?>"></td>
                  </tr>
                  <tr>
                      <!--<td class="td_left_checklist" style="vertical-align: middle">36</td>-->
                    <td class="td_left_header_checklist" style="vertical-align: top"><input style="vertical-align: top;" class="infoPenandaan_v1" name="infoPenandaan_v1-36" type="checkbox" value="-_A" id="v1_36" <?php if ($detailsub3[17][0] != '-' && $detailsub3[17][0] != '+' && $detailsub3[17][0] != '') echo 'checked'; ?>/>&nbsp;Informasi Tambahan</td>
                    <td class="td_left_checklist"><span id="infoPenandaan_v1_txt" <?php
                      if ($detailsub3[17][0] != '-' && $detailsub3[17][0] != '+' && $detailsub3[17][0] != '')
                        ;
                      else
                        echo 'hidden';
                      ?>><textarea title="Informasi Tambahan" class="infoPenandaan_v1 infoPenandaan_v1_txt" style="width: 99%; height: 75px;" name="CHK5[33]" id="v1_37" onchange="uTL(this)"><?php echo $detailsub3[17][0]; ?></textarea></span></td>
                  </tr>
                  <tr>
                  <!--<td class="td_left_checklist" style="vertical-align: top">37</td>-->
                    <td class="td_left_header_checklist" colspan="2">Lampiran : <?php
                      if (array_key_exists('FILE_PENANDAAN_V1', $sess) && trim($sess['FILE_PENANDAAN_V1']) != "") {
                        ?>
                        <span class="file_FILE_PENANDAAN_V1"><input type="hidden" name="PENANDAAN_OBAT[FILE_PENANDAAN_V1]" value="<?php echo $sess['FILE_PENANDAAN_V1']; ?>"><a href="<?php echo site_url(); ?>/download/penandaanIklanSubDirPostUpload/<?php echo 'penandaan_001/V1'; ?>/<?php echo $sess['FILE_PENANDAAN_V1']; ?>" target="_blank">File Lampiran</a>&nbsp;&bull;&nbsp;<a href="#" class="del_upload" url="<?php echo site_url(); ?>/utility/uploads/del_upload_m/<?php echo 'penandaan_001/V1'; ?>/<?php echo $sess['FILE_PENANDAAN_V1']; ?>" jns="FILE_PENANDAAN_V1">Edit atau Hapus File ?</a></span>
                        <?php
                      } else {
                        ?>
                        <span class="upload_FILE_PENANDAAN_V1"><input type="file" class="upload upV1" jenis="FILE_PENANDAAN_V1" allowed="jpg-jpeg-pdf-doc-docx-rar" url="<?php echo site_url(); ?>/utility/uploads/get_upload_m/<?php echo 'penandaan_001/V1'; ?>" id="fileToUpload_FILE_PENANDAAN_V1" name="userfile" onchange="do_upload($(this));
                        return false;" />
                          &nbsp;Tipe File : *.jpg .jpeg .pdf .doc .docx .rar</span><span class="file_FILE_PENANDAAN_V1"></span>
                        <?php
                      }
                      ?></td>
                  </tr>
                  <tr>
                      <!--<td class="td_left_checklist">35</td>-->
                    <td class="td_left_header_checklist">Kesimpulan</td>
                    <td class="td_left">
                      <input type="hidden" id="kesimpulanHasilPenilaianV1Val" readonly size="23" name="CHK5[HASIL]" value="<?php echo $detailsub3[18][0]; ?>" />
                      <input type="text" id="kesimpulanHasilPenilaianv1" readonly size="23" value="<?php
                      if ($detailsub3[18][0] == "TMK")
                        echo "Tidak Memenuhi Ketentuan";
                      else
                        echo "Memenuhi Ketentuan";
                      ?>" /></td>
                    <td></td>
                  </tr>
                  <tr><td colspan="2">&nbsp;</td></tr>
                  <tr>
                    <td class="td_left"><h2 class="small garis">Detil Pelanggaran :</h2></td>
                    <td class="td_right"><textarea readonly id="detilPelanggaranv1" name="detilPelanggaranv1" style="height: 70px; width: 100%;"></textarea></td>
                  </tr>
                  <tr>
                    <td class="td_left">&nbsp;</td>
                    <td class="td_right">Jumlah Jenis Pelanggaran : <span id="jumlahTMKv1"></span></td>
                  </tr>
                  <tr></tr>
                  <?php if ((in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')))) { ?>
                    <tr><td colspan="2"><h2 class="small garis">Kesimpulan Pusat :</h2></td></tr>
                    <?php
                    $TLV1 = explode("^", $d3[5]);
                    $TLV1Sub = explode("^", $d3[6]);
                    $tempV1 = array($TLV1[1], $TLV1[2]);
                    $tempV1Sub = array($TLV1Sub[0], $TLV1Sub[1]);
                    if ((empty($d3[3]) && in_array('2', $this->newsession->userdata('SESS_KODE_ROLE'))) || $editTL == 'YES') {
                      ?>
                      <tr><td class="td_left">Verifikasi Pusat</td><td class="td_right"><select id="V1" class="stext verifikasiPusat" name="<?php echo 'V1[HASIL_PUSAT][]' ?>" title="MK/TMK"><option></option><option value="MK" <?php if ($d3[3] == "MK") echo 'Selected' ?>>Memenuhi Ketentuan</option><option value="TMK" <?php if ($d3[3] == "TMK") echo 'Selected' ?>>Tidak Memenuhi Ketentuan</option></select></tr>
                      <tr class="vTMK_V1" hidden><td class="td_left">Kategori Pelanggaran</td><td class="td_right"><select class="sjenis vTMKa_V1" title="Kategori Pelanggaran"><option></option><option value="Kritikal" <?php if ($TLV1[0] == "Kritikal") echo 'Selected' ?>>Kritikal</option><option value="Non Kritikal" <?php if ($TLV1[0] == "Non Kritikal") echo 'Selected' ?>>Non Kritikal</option></select></td></tr>
                      <tr class="vTMK_V1" hidden><td class="td_left"style="background-color: white;">Tindak Lanjut</td><td class="td_right" style="background-color: white;"><?php echo form_dropdown('V1[HASIL_PUSAT][]', $cb_tl, !empty($d3[4]) ? $d3[4] : '', 'class="stext verifikasiPusatSub" id="vTMKSub_V1" title="Tindak Lanjut Pusat"'); ?></td></tr>
                      <tr class="vTMK2_V1" hidden><td class="td_left"style="background-color: white;"></td><td class="td_right" style="background-color: white;"><?php echo form_dropdown('V1[TL_PUSAT][]', $cb_tindakan, is_array($tempV1) ? $tempV1 : '', 'class="stext multiselect vTMK2_V1" multiple title="Saran Tindak Lanjut Pusat. Untuk memilih lebih dari satu, klik + Ctrl"'); ?></td></tr>
                      <tr class="vTMK2_V1" hidden><td class="td_left">Surat Tindak Lanjut</td><td class="td_right"><input type="text" class="sdate vTMK2a_V1" name="V1[DETAIL_PUSAT][]" id="tglSuratTLV1" title="Tanggal Surat Tindak Lanjut" placeholder="Tanggal Surat" onchange="comp('D')" value="<?php echo$tempV1Sub[0]; ?>"/>&nbsp;&nbsp;&nbsp;Tanggal Surat Tindak Lanjut</td><td></td></tr>
                      <tr class="vTMK2_V1" hidden><td class="td_left"></td><td class="td_right"><input type="text" class="stext vTMK2a_V1" name="V1[DETAIL_PUSAT][]" id="stugas_"  title="Di isi dengan nomor surat tindak lanjut" placeholder="Nomor Surat Tindak Lanjut" value="<?php echo $tempV1Sub[1]; ?>"/>&nbsp;&nbsp;&nbsp;Nomor Surat Tindak Lanjut</td></tr>
                      <tr class="vJustifikasi_V1" hidden><td class="td_left">Justifikasi</td><td style="padding: 5px"><textarea name="JUSTIFIKASI_V1" title="Justifikasi Pusat" class="stext chkJustifikasi chkJustifikasi_V1" style="height: 140px"><?php echo $d3[7]; ?></textarea></td></tr>
                      <?php
                    } else if (!empty($d3[3])) {
                      ?>
                      <tr><td class="td_left">Verifikasi Pusat</td><td class="td_right"><b><i><?php
                              if ($d3[3] == "TMK")
                                echo "Tidak Memenuhi Ketentuan";
                              else
                                "Memenuhi Ketentuan"
                                ?></i></b></td></tr>
                      <?php if (!empty($TLV1[0])) { ?><tr><td class="td_left">Kategori Pelanggaran</td><td class="td_right"><?php echo $TLV1[0]; ?></td></tr>
                      <?php } if (!empty($d3[4])) { ?><tr><td class="td_left">Tindak Lanjut</td><td class="td_right"><?php if ($d3[4] == "TL") echo "Tindak Lanjut"; else if ($d3[4] == "STL") echo "Sudah Tindak Lanjut"; else if ($d3[4] == "TTL") echo "Tidak Dapat Tindak Lanjut" ?></td></tr>
                      <?php }if (!empty($TLV1[1])) { ?><tr><td class="td_left">Detil Tindak Lanjut Pusat</td><td class="td_right"><ul style="list-style-type:decimal; padding-left:20px; margin:0;"><?php
                        if ($TLV1[2] != '')
                          echo "<li>" . join("</li><li>", $tempV1) . "</li>";
                        else
                          echo "<li>" . $TLV1[1] . "</li>";
                        ?></ul></td></tr>
                      <?php } if (!empty($TLV1Sub[0])) {
                        ?><tr><td class="td_left">Surat Tindak Lanjut</td><td class="td_right"><ul style="padding-left:20px; margin:0;"><?php
                              echo "<li>Tangal Surat : " . join("</li><li>Nomor Surat : ", $tempV1Sub) . "</li>";
                              ?></ul></td></tr>
                      <?php } if (!empty($d3[7])) {
                        ?>
                        <tr><td class="td_left">Justifikasi Pusat</td><td class="td_right"><?php echo $d3[7]; ?></td></tr>
                        <?php
                      }
                    }
                  }
                  ?>
                </table>
              </div>

              <!--Ampul/ Vial < 10 ML-->
              <div id="tabs-6" class="div_v2" hidden="true">
                <table class="form_tabel" style="width: 100%;">
                  <tr>
                    <td style="width: 35%;"></td>
                    <td class="td_left" style="width: 65%">
                      <input type="radio" id="r1" disabled="true">
                      <label for="r1" style="width: 54px; height: 10px;">Ada</label>
                      <span style="margin-left: 5px;"></span>
                      <input type="radio" id="r2" disabled="true">
                      <label for="r2" style="width: 54px; height: 10px;">Tidak Ada</label></td>
                  </tr>
                  <tr class="infoPenandaan_v2Row">
                      <!--<td class="td_left_checklist">1</td>-->
                    <td class="td_left_header_checklist">Nama obat  </td>
                    <td class="td_left">
                      <input class="infoPenandaan_v2" type="radio" id="radiof11_1" name="CHK6[1]" value="+_Nama Obat" <?php if ($detailsub4[0][0] == '+') echo 'checked'; ?>>
                      <label for="radiof11_1" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_v2" type="radio" id="radiof12_1" name="CHK6[1]" value="-_Nama Obat" <?php if ($detailsub4[0][0] == '-') echo 'checked'; ?>>
                      <label for="radiof12_1" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK6[1]" style="display: none;" value="<?php echo join('_', $detailsub4[0]); ?>"></td>
                  </tr>
                  <tr class="infoPenandaan_v2Row">
                      <!--<td class="td_left_checklist">4</td>-->
                    <td class="td_left_header_checklist">Besar kemasan (unit)</td>
                    <td class="td_left">
                      <input class="infoPenandaan_v2" type="radio" id="radiof31_4" name="CHK6[4]" value="+_Besar Kemasan" <?php if ($detailsub4[1][0] == '+') echo 'checked'; ?>>
                      <label for="radiof31_4" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_v2" type="radio" id="radiof32_4" name="CHK6[4]" value="-_Besar Kemasan" <?php if ($detailsub4[1][0] == '-') echo 'checked'; ?>>
                      <label for="radiof32_4" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK6[4]" value="<?php echo join('_', $detailsub4[1]); ?>"></td>
                  </tr>
                  <tr class="infoPenandaan_v2Row">
                      <!--<td class="td_left_checklist">5</td>-->
                    <td class="td_left_header_checklist">Nama dan kekuatan zat aktif</td>
                    <td class="td_left">
                      <input class="infoPenandaan_v2" type="radio" id="radiof41_5" name="CHK6[5]" value="+_Nama dan kekuatan zat aktif" <?php if ($detailsub4[2][0] == '+') echo 'checked'; ?>>
                      <label for="radiof41_5" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_v2" type="radio" id="radiof42_5" name="CHK6[5]" value="-_Nama dan kekuatan zat aktif" <?php if ($detailsub4[2][0] == '-') echo 'checked'; ?>>
                      <label for="radiof42_5" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK6[5]" value="<?php echo join('_', $detailsub4[2]); ?>"> </td>
                  </tr>
                  <tr class="infoPenandaan_v2Row">
                      <!--<td class="td_left_checklist">6a</td>-->
                    <td class="td_left_header_checklist">Nama industri pendaftar</td>
                    <td class="td_left">
                      <input class="infoPenandaan_v2" type="radio" id="radiof6a1_6" name="CHK6[6a]" value="+_Nama industri pendaftar" <?php if ($detailsub4[3][0] == '+') echo 'checked'; ?>>
                      <label for="radiof6a1_6" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_v2" type="radio" id="radiof6a2_6" name="CHK6[6a]" value="-_Nama industri pendaftar" <?php if ($detailsub4[3][0] == '-') echo 'checked'; ?>>
                      <label for="radiof6a2_6" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK6[6a]" value="<?php echo join('_', $detailsub4[3]); ?>"></td>
                  </tr>
                  <tr class="lisensiBasedv2 infoPenandaan_v2Row" hidden>
                      <!--<td class="td_left_checklist">7a</td>-->
                    <td class="td_left_header_checklist">Nama industri pendaftar dan produsen obat (untuk obat kontrak)</td>
                    <td class="td_left">
                      <input class="infoPenandaan_v2" type="radio" id="radiof7a1_7" name="CHK6[7a]" value="+_Nama industri pendaftar dan produsen obat (untuk obat kontrak)" <?php if ($detailsub4[4][0] == '+') echo 'checked'; ?>>
                      <label for="radiof7a1_7" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_v2" type="radio" id="radiof7a2_7" name="CHK6[7a]" value="-_Nama industri pendaftar dan produsen obat (untuk obat kontrak)" <?php if ($detailsub4[4][0] == '-') echo 'checked'; ?>>
                      <label for="radiof7a2_7" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK6[7a]" value="<?php echo join('_', $detailsub4[4]); ?>"></td>
                  </tr>
                  <tr class="infoPenandaan_v2Row">
                      <!--<td class="td_left_checklist">8a</td>-->
                    <td class="td_left_header_checklist">Nama industri pendaftar dan pemberi lisensi</td>
                    <td class="td_left">
                      <input class="infoPenandaan_v2" type="radio" id="radiof8a1_8" name="CHK6[8a]" value="+_Nama industri pendaftar dan pemberi lisensi" <?php if ($detailsub4[5][0] == '+') echo 'checked'; ?>>
                      <label for="radiof8a1_8" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_v2" type="radio" id="radiof8a2_8" name="CHK6[8a]" value="-_Nama industri pendaftar dan pemberi lisensi" <?php if ($detailsub4[5][0] == '-') echo 'checked'; ?>>
                      <label for="radiof8a2_8" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK6[8a]" value="<?php echo join('_', $detailsub4[5]); ?>"></td>
                  </tr>
                  <tr class="infoPenandaan_v2Row">
                      <!--<td class="td_left_checklist">9</td>-->
                    <td class="td_left_checklist">Cara pemberian</td>
                    <td class="td_left">
                      <input class="infoPenandaan_v2" type="radio" id="radiof91_9" name="CHK6[9]" value="+_Cara pemberian" <?php if ($detailsub4[6][0] == '+') echo 'checked'; ?>>
                      <label for="radiof91_9" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_v2" type="radio" id="radiof92_9" name="CHK6[9]" value="-_Cara pemberian" <?php if ($detailsub4[6][0] == '-') echo 'checked'; ?>>
                      <label for="radiof92_9" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK6[9]" value="<?php echo join('_', $detailsub4[6]); ?>"></td>
                  </tr>
                  <tr class="infoPenandaan_v2Row">
                      <!--<td class="td_left_checklist">10</td>-->
                    <td class="td_left_header_checklist">Nomor izin edar</td>
                    <td class="td_left">
                      <input class="infoPenandaan_v2" type="radio" id="radiof101_10" name="CHK6[10]" value="+_Nomor izin edar" <?php if ($detailsub4[7][0] == '+') echo 'checked'; ?>>
                      <label for="radiof101_10" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_v2" type="radio" id="radiof102_10" name="CHK6[10]" value="-_Nomor izin edar" <?php if ($detailsub4[7][0] == '-') echo 'checked'; ?>>
                      <label for="radiof102_10" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK6[10]" value="<?php echo join('_', $detailsub4[7]); ?>"></td>
                  </tr>
                  <tr class="infoPenandaan_v2Row">
                      <!--<td class="td_left_checklist">11</td>-->
                    <td class="td_left_header_checklist">Nomor bets</td>
                    <td class="td_left">
                      <input class="infoPenandaan_v2" type="radio" id="radiof111_11" name="CHK6[11]" value="+_Nomor bets" <?php if ($detailsub4[8][0] == '+') echo 'checked'; ?>>
                      <label for="radiof111_11" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_v2" type="radio" id="radiof112_11" name="CHK6[11]" value="-_Nomor bets" <?php if ($detailsub4[8][0] == '-') echo 'checked'; ?>>
                      <label for="radiof112_11" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK6[11]" value="<?php echo join('_', $detailsub4[8]); ?>"></td>
                  </tr>
                  <tr class="infoPenandaan_v2Row">
                      <!--<td class="td_left_checklist">13</td>-->
                    <td class="td_left_header_checklist">Batas kadaluarsa</td>
                    <td class="td_left">
                      <input class="infoPenandaan_v2" type="radio" id="radiof131_13" name="CHK6[13]" value="+_Batas kadaluarsa" <?php if ($detailsub4[9][0] == '+') echo 'checked'; ?>>
                      <label for="radiof131_13" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_v2" type="radio" id="radiof132_13" name="CHK6[13]" value="-_Batas kadaluarsa" <?php if ($detailsub4[9][0] == '-') echo 'checked'; ?>>
                      <label for="radiof132_13" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK6[13]" value="<?php echo join('_', $detailsub4[9]); ?>"></td>
                  </tr>
                  <tr class="oKPNv2 infoPenandaan_v2Row"  hidden="true">
                      <!--<td class="td_left_checklist">28a</td>-->
                    <td class="td_left_header_checklist">"Harus dengan resep dokter"</td>
                    <td class="td_left">
                      <input class="infoPenandaan_v2" type="radio" id="radiof28a1_28RD" name="CHK6[28a]" value="+_Harus dengan resep dokter" <?php if ($detailsub4[10][0] == '+') echo 'checked'; ?>>
                      <label for="radiof28a1_28RD" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_v2" type="radio" id="radiof28a2_28RD" name="CHK6[28a]" value="-_Harus dengan resep dokter" <?php if ($detailsub4[10][0] == '-') echo 'checked'; ?>>
                      <label for="radiof28a2_28RD" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK6[28a]" value="<?php echo join('_', $detailsub4[10]); ?>"></td>
                  </tr>
                  <tr class="infoPenandaan_v2Row">
                      <!--<td class="td_left_checklist">28d</td>-->
                    <td style="background-color: white" class="td_left_header_checklist">"Bersumber babi/bersinggungan"</td>
                    <td style="background-color: white" class="td_left">
                      <input class="infoPenandaan_v2" type="radio" id="radiof28d1_28" name="CHK6[28d]" value="+_Bersumber babi/bersinggungan" <?php if ($detailsub4[11][0] == '+') echo 'checked'; ?>>
                      <label for="radiof28d1_28" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_v2" type="radio" id="radiof28d2_28" name="CHK6[28d]" value="-_Bersumber babi/bersinggungan" <?php if ($detailsub4[11][0] == '-') echo 'checked'; ?>>
                      <label for="radiof28d2_28" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK6[28d]" value="<?php echo join('_', $detailsub4[11]); ?>"></td>
                  </tr>
                  <tr style="background-color: white" class="infoPenandaan_v2Row">
                      <!--<td class="td_left_checklist">28e</td>-->
                    <td class="td_left_header_checklist">Kandungan alkohol</td>
                    <td class="td_left">
                      <input class="infoPenandaan_v2" type="radio" id="radiof28e1_28" name="CHK6[28e]" value="+_Kandungan alkohol" <?php if ($detailsub4[12][0] == '+') echo 'checked'; ?>>
                      <label for="radiof28e1_28" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_v2" type="radio" id="radiof28e2_28" name="CHK6[28e]" value="-_Kandungan alkohol" <?php if ($detailsub4[12][0] == '-') echo 'checked'; ?>>
                      <label for="radiof28e2_28" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK6[28e]" value="<?php echo join('_', $detailsub4[12]); ?>"></td>
                  </tr>
         <!--         <tr class="infoPenandaan_v2Row">
                      <td class="td_left_checklist">29</td>
                   <td class="td_left_header_checklist">Cara penyimpanan obat (termasuk cara penyimpanan setelah rekonstitusi)</td>
                   <td class="td_left">
                    <input class="infoPenandaan_v2" type="radio" id="radiof291_29" name="CHK6[29]" value="+_Cara penyimpanan obat (termasuk cara penyimpanan setelah rekonstitusi)" <?php if ($detailsub4[13][0] == '+') echo 'checked'; ?>>
                    <label for="radiof291_29" style="width: 54px; height: 10px;"></label>
                    <span style="margin-left: 5px;"></span>
                    <input class="infoPenandaan_v2" type="radio" id="radiof292_29" name="CHK6[29]" value="-_Cara penyimpanan obat (termasuk cara penyimpanan setelah rekonstitusi)" <?php if ($detailsub4[13][0] == '-') echo 'checked'; ?>>
                    <label for="radiof292_29" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                    <input type="text" style="display:none;" name="CHK6[29]" value="<?php echo join('_', $detailsub4[13]); ?>"></td>
                  </tr>-->
                  <input type="hidden" style="display:none;" name="CHK6[29]" value="<?php echo join('_', $detailsub4[13]); ?>" value="">
                  <tr></tr>
                  <tr>
                      <!--<td class="td_left_checklist" style="vertical-align: middle">36</td>-->
                    <td class="td_left_header_checklist" style="vertical-align: top"><input style="vertical-align: top;" class="infoPenandaan_v2" name="infoPenandaan_v2-36" type="checkbox" value="-_A" id="v2_36" <?php if ($detailsub4[14][0] != '-' && $detailsub4[14][0] != '+' && $detailsub4[14][0] != '') echo 'checked'; ?>/>&nbsp;Informasi Tambahan</td>
                    <td class="td_left_checklist"><span id="infoPenandaan_v2_txt" <?php
                      if ($detailsub4[14][0] != '-' && $detailsub4[14][0] != '+' && $detailsub4[14][0] != '')
                        ;
                      else
                        echo 'hidden';
                      ?>><textarea title="Informasi Tambahan" class="infoPenandaan_v2 infoPenandaan_v2_txt" style="width: 99%; height: 75px;" name="CHK6[30]" id="v2_37" onchange="uTL(this)"><?php echo $detailsub4[14][0]; ?></textarea></span></td>
                    <td></td>
                  </tr>
                  <tr>
                  <!--<td class="td_left_checklist" style="vertical-align: top">37</td>-->
                    <td class="td_left_header_checklist" colspan="2">Lampiran : <?php
                      if (array_key_exists('FILE_PENANDAAN_V2', $sess) && trim($sess['FILE_PENANDAAN_V2']) != "") {
                        ?>
                        <span class="file_FILE_PENANDAAN_V2"><input type="hidden" name="PENANDAAN_OBAT[FILE_PENANDAAN_V2]" value="<?php echo $sess['FILE_PENANDAAN_V2']; ?>"><a href="<?php echo site_url(); ?>/download/penandaanIklanSubDirPostUpload/<?php echo 'penandaan_001/V2'; ?>/<?php echo $sess['FILE_PENANDAAN_V2']; ?>" target="_blank">File Lampiran</a>&nbsp;&bull;&nbsp;<a href="#" class="del_upload" url="<?php echo site_url(); ?>/utility/uploads/del_upload_m/<?php echo 'penandaan_001/V2'; ?>/<?php echo $sess['FILE_PENANDAAN_V2']; ?>" jns="FILE_PENANDAAN_V2">Edit atau Hapus File ?</a></span>
                        <?php
                      } else {
                        ?>
                        <span class="upload_FILE_PENANDAAN_V2"><input type="file" class="upload upV2" jenis="FILE_PENANDAAN_V2" allowed="jpg-jpeg-pdf-doc-docx-rar" url="<?php echo site_url(); ?>/utility/uploads/get_upload_m/<?php echo 'penandaan_001/V2'; ?>" id="fileToUpload_FILE_PENANDAAN_V2" name="userfile" onchange="do_upload($(this));
                        return false;" />
                          &nbsp;Tipe File : *.jpg .jpeg .pdf .doc .docx .rar</span><span class="file_FILE_PENANDAAN_V2"></span>
                        <?php
                      }
                      ?></td>
                  </tr>
                  <tr>
                      <!--<td class="td_left_checklist">35</td>-->
                    <td class="td_left_header_checklist">Kesimpulan</td>
                    <td class="td_left">
                      <input type="hidden" id="kesimpulanHasilPenilaianV2Val" readonly size="23" name="CHK6[HASIL]" value="<?php echo $detailsub4[15][0]; ?>" />
                      <input type="text" id="kesimpulanHasilPenilaianv2" readonly size="23" value="<?php
                      if ($detailsub4[15][0] == "TMK")
                        echo "Tidak Memenuhi Ketentuan";
                      else
                        echo "Memenuhi Ketentuan";
                      ?>" /></td>
                    <td></td>
                  </tr>
                  <tr><td colspan="2">&nbsp;</td></tr>
                  <tr>
                    <td class="td_left"><h2 class="small garis">Detil Pelanggaran :</h2></td>
                    <td class="td_right"><textarea readonly id="detilPelanggaranv2" name="detilPelanggaranv2" style="height: 70px; width: 99%;"></textarea></td>
                  </tr>
                  <tr>
                    <td class="td_left">&nbsp;</td>
                    <td class="td_right">Jumlah Jenis Pelanggaran : <span id="jumlahTMKv2"></span></td>
                  </tr>
                  <tr></tr>
                  <?php if ((in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')))) { ?>
                    <tr><td colspan="2"><h2 class="small garis">Kesimpulan Pusat :</h2></td></tr>
                    <?php
                    $TLV2 = explode("^", $d4[5]);
                    $TLV2Sub = explode("^", $d4[6]);
                    $tempV2 = array($TLV2[1], $TLV2[2]);
                    $tempV2Sub = array($TLV2Sub[0], $TLV2Sub[1]);
                    if ((empty($d4[3]) && in_array('2', $this->newsession->userdata('SESS_KODE_ROLE'))) || $editTL == 'YES') {
                      ?>
                      <tr><td class="td_left">Verifikasi Pusat</td><td class="td_right"><select id="V2" class="stext verifikasiPusat" name="<?php echo 'V2[HASIL_PUSAT][]' ?>" title="MK/TMK"><option></option><option value="MK" <?php if ($d4[3] == "MK") echo 'Selected' ?>>Memenuhi Ketentuan</option><option value="TMK" <?php if ($d4[3] == "TMK") echo 'Selected' ?>>Tidak Memenuhi Ketentuan</option></select></tr>
                      <tr class="vTMK_V2" hidden><td class="td_left">Kategori Pelanggaran</td><td class="td_right"><select class="sjenis vTMKa_V2" title="Kategori Pelanggaran"><option></option><option value="Kritikal" <?php if ($TLV2[0] == "Kritikal") echo 'Selected' ?>>Kritikal</option><option value="Non Kritikal" <?php if ($TLV2[0] == "Non Kritikal") echo 'Selected' ?>>Non Kritikal</option></select></td></tr>
                      <tr class="vTMK_V2" hidden><td class="td_left"style="background-color: white;">Tindak Lanjut</td><td class="td_right" style="background-color: white;"><?php echo form_dropdown('V2[HASIL_PUSAT][]', $cb_tl, !empty($d4[4]) ? $d4[4] : '', 'class="stext verifikasiPusatSub" id="vTMKSub_V2" title="Tindak Lanjut Pusat"'); ?></td></tr>
                      <tr class="vTMK2_V2" hidden><td class="td_left"style="background-color: white;"></td><td class="td_right" style="background-color: white;"><?php echo form_dropdown('V2[TL_PUSAT][]', $cb_tindakan, is_array($tempV2) ? $tempV2 : '', 'class="stext multiselect vTMK2_V2" multiple title="Saran Tindak Lanjut Pusat. Untuk memilih lebih dari satu, klik + Ctrl"'); ?></td></tr>
                      <tr class="vTMK2_V2" hidden><td class="td_left">Surat Tindak Lanjut</td><td class="td_right"><input type="text" class="sdate vTMK2a_V2" name="V2[DETAIL_PUSAT][]" id="tglSuratTLV2" title="Tanggal Surat Tindak Lanjut" placeholder="Tanggal Surat" onchange="comp('D')" value="<?php echo$tempV2Sub[0]; ?>"/>&nbsp;&nbsp;&nbsp;Tanggal Surat Tindak Lanjut</td><td></td></tr>
                      <tr class="vTMK2_V2" hidden><td class="td_left"></td><td class="td_right"><input type="text" class="stext vTMK2a_V2" name="V2[DETAIL_PUSAT][]" id="stugas_"  title="Di isi dengan nomor surat tindak lanjut" placeholder="Nomor Surat Tindak Lanjut" value="<?php echo $tempV2Sub[1]; ?>"/>&nbsp;&nbsp;&nbsp;Nomor Surat Tindak Lanjut</td></tr>
                      <tr class="vJustifikasi_V2" hidden><td class="td_left">Justifikasi</td><td style="padding: 5px"><textarea name="JUSTIFIKASI_V2" title="Justifikasi Pusat" class="stext chkJustifikasi chkJustifikasi_V2" style="height: 140px"><?php echo $d4[7]; ?></textarea></td></tr>
                      <?php
                    } else if (!empty($d4[3])) {
                      ?>
                      <tr><td class="td_left">Verifikasi Pusat</td><td class="td_right"><b><i><?php
                              if ($d4[3] == "TMK")
                                echo "Tidak Memenuhi Ketentuan";
                              else
                                "Memenuhi Ketentuan"
                                ?></i></b></td></tr>
                      <?php if (!empty($TLV2[0])) { ?><tr><td class="td_left">Kategori Pelanggaran</td><td class="td_right"><?php echo $TLV2[0]; ?></td></tr>
                      <?php } if (!empty($d4[4])) { ?><tr><td class="td_left">Tindak Lanjut</td><td class="td_right"><?php if ($d4[4] == "TL") echo "Tindak Lanjut"; else if ($d4[4] == "STL") echo "Sudah Tindak Lanjut"; else if ($d4[4] == "TTL") echo "Tidak Dapat Tindak Lanjut" ?></td></tr>
                      <?php }if (!empty($TLV2[1])) { ?><tr><td class="td_left">Detil Tindak Lanjut Pusat</td><td class="td_right"><ul style="list-style-type:decimal; padding-left:20px; margin:0;"><?php
                        if ($TLV2[2] != '')
                          echo "<li>" . join("</li><li>", $tempV2) . "</li>";
                        else
                          echo "<li>" . $TLV2[1] . "</li>";
                        ?></ul></td></tr>
                      <?php } if (!empty($TLV2Sub[0])) {
                        ?><tr><td class="td_left">Surat Tindak Lanjut</td><td class="td_right"><ul style="padding-left:20px; margin:0;"><?php
                              echo "<li>Tangal Surat : " . join("</li><li>Nomor Surat : ", $tempV2Sub) . "</li>";
                              ?></ul></td></tr>
                      <?php } if (!empty($d4[7])) {
                        ?>
                        <tr><td class="td_left">Justifikasi Pusat</td><td class="td_right"><?php echo $d4[7]; ?></td></tr>
                        <?php
                      }
                    }
                  }
                  ?>
                </table>
              </div>

              <!--Brosur-->
              <div id="tabs-7" class="div_bR" hidden="true">
                <table class="form_tabel" style="width: 100%;">
                  <tr>
                    <td style="width: 35%;"></td>
                    <td class="td_left" style="width: 65%">
                      <input type="radio" id="r1" disabled="true">
                      <label for="r1" style="width: 54px; height: 10px;">Ada</label>
                      <span style="margin-left: 5px;"></span>
                      <input type="radio" id="r2" disabled="true">
                      <label for="r2" style="width: 54px; height: 10px;">Tidak Ada</label></td>
                  </tr>
                  <tr class="infoPenandaan_bRRow">
                      <!--<td class="td_left_checklist">1</td>-->
                    <td class="td_left_header_checklist">Nama obat  </td>
                    <td class="td_left">
                      <input class="infoPenandaan_bR" type="radio" id="radiog11_1" name="CHK7[1]" value="+_Nama Obat" <?php if ($detailsub5[0][0] == '+') echo 'checked'; ?>>
                      <label for="radiog11_1" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_bR" type="radio" id="radiog12_1" name="CHK7[1]" value="-_Nama Obat" <?php if ($detailsub5[0][0] == '-') echo 'checked'; ?>>
                      <label for="radiog12_1" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK7[1]" value="<?php echo join('_', $detailsub5[0]); ?>"></td>
                  </tr>
                  <tr class="infoPenandaan_bRRow">
                      <!--<td class="td_left_checklist">2</td>-->
                    <td class="td_left_header_checklist">Bentuk sediaan</td>
                    <td class="td_left">
                      <input class="infoPenandaan_bR" type="radio" id="radiog21_2" name="CHK7[2]" value="+_Bentuk Sediaan" <?php if ($detailsub5[1][0] == '+') echo 'checked'; ?>>
                      <label for="radiog21_2" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_bR" type="radio" id="radiog22_2" name="CHK7[2]" value="-_Bentuk Sediaan" <?php if ($detailsub5[1][0] == '-') echo 'checked'; ?>>
                      <label for="radiog22_2" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK7[2]" value="<?php echo join('_', $detailsub5[1]); ?>"></td>
                  </tr>
                  <tr class="infoPenandaan_bRRow">
                      <!--<td class="td_left_checklist">3</td>-->
                    <td class="td_left_header_checklist">Pemerian obat</td>
                    <td class="td_left">
                      <input class="infoPenandaan_bR" type="radio" id="radiog21a_3" name="CHK7[3]" value="+_Pemerian Obat" <?php if ($detailsub5[2][0] == '+') echo 'checked'; ?>>
                      <label for="radiog21a_3" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_bR" type="radio" id="radiog22b_3" name="CHK7[3]" value="-_Pemerian Obat" <?php if ($detailsub5[2][0] == '-') echo 'checked'; ?>>
                      <label for="radiog22b_3" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK7[3]" value="<?php echo join('_', $detailsub5[2]); ?>"></td>
                  </tr>
                  <tr class="infoPenandaan_bRRow">
                      <!--<td class="td_left_checklist">4</td>-->
                    <td class="td_left_header_checklist">Besar kemasan (unit)</td>
                    <td class="td_left">
                      <input class="infoPenandaan_bR" type="radio" id="radiog31_4" name="CHK7[4]" value="+_Besar Kemasan" <?php if ($detailsub5[3][0] == '+') echo 'checked'; ?>>
                      <label for="radiog31_4" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_bR" type="radio" id="radiog32_4" name="CHK7[4]" value="-_Besar Kemasan" <?php if ($detailsub5[3][0] == '-') echo 'checked'; ?>>
                      <label for="radiog32_4" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK7[4]" value="<?php echo join('_', $detailsub5[3]); ?>"></td>
                  </tr>
                  <tr class="infoPenandaan_bRRow">
                      <!--<td class="td_left_checklist">5</td>-->
                    <td class="td_left_header_checklist">Nama dan kekuatan zat aktif</td>
                    <td class="td_left">
                      <input class="infoPenandaan_bR" type="radio" id="radiog41_4" name="CHK7[5]" value="+_Nama dan kekuatan zat aktif" <?php if ($detailsub5[4][0] == '+') echo 'checked'; ?>>
                      <label for="radiog41_4" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_bR" type="radio" id="radiog42_4" name="CHK7[5]" value="-_Nama dan kekuatan zat aktif" <?php if ($detailsub5[4][0] == '-') echo 'checked'; ?>>
                      <label for="radiog42_4" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK7[5]" value="<?php echo join('_', $detailsub5[4]); ?>"></td>
                  </tr>
                  <tr class="infoPenandaan_bRRow">
                      <!--<td class="td_left_checklist">6a</td>-->
                    <td class="td_left_header_checklist">Nama industri pendaftar</td>
                    <td class="td_left">
                      <input class="infoPenandaan_bR" type="radio" id="radiog6a1_6" name="CHK7[6a]" value="+_Nama industri pendaftar" <?php if ($detailsub5[5][0] == '+') echo 'checked'; ?>>
                      <label for="radiog6a1_6" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_bR" type="radio" id="radiog6a2_6" name="CHK7[6a]" value="-_Nama industri pendaftar" <?php if ($detailsub5[5][0] == '-') echo 'checked'; ?>>
                      <label for="radiog6a2_6" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK7[6a]" value="<?php echo join('_', $detailsub5[5]); ?>"></td>
                  </tr>
                  <tr class="infoPenandaan_bRRow">
                      <!--<td class="td_left_checklist">6b</td>-->
                    <td class="td_left_header_checklist">Alamat industri pendaftar</td>
                    <td class="td_left">
                      <input class="infoPenandaan_bR" type="radio" id="radiog6b1_6" name="CHK7[6b]" value="+_Alamat industri pendaftar" <?php if ($detailsub5[6][0] == '+') echo 'checked'; ?>>
                      <label for="radiog6b1_6" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_bR" type="radio" id="radiog6b2_6" name="CHK7[6b]" value="-_Alamat industri pendaftar" <?php if ($detailsub5[6][0] == '-') echo 'checked'; ?>>
                      <label for="radiog6b2_6" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK7[6b]" value="<?php echo join('_', $detailsub5[6]); ?>"></td>
                  </tr>
                  <tr class="lisensiBasedbR infoPenandaan_bRRow" hidden="true">
                      <!--<td class="td_left_checklist">7a</td>-->
                    <td class="td_left_header_checklist">Nama industri pendaftar dan produsen obat (untuk obat kontrak)</td>
                    <td class="td_left">
                      <input class="infoPenandaan_bR" type="radio" id="radiog7a1_7" name="CHK7[7a]" value="+_Nama industri pendaftar dan produsen obat (untuk obat kontrak)" <?php if ($detailsub5[7][0] == '+') echo 'checked'; ?>>
                      <label for="radiog7a1_7" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_bR" type="radio" id="radiog7a2_7" name="CHK7[7a]" value="-_Nama industri pendaftar dan produsen obat (untuk obat kontrak)" <?php if ($detailsub5[7][0] == '-') echo 'checked'; ?>>
                      <label for="radiog7a2_7" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK7[7a]" value="<?php echo join('_', $detailsub5[7]); ?>"></td>
                  </tr>
                  <tr class="lisensiBasedbR infoPenandaan_bRRow" hidden="true">
                      <!--<td class="td_left_checklist">7b</td>-->
                    <td class="td_left_header_checklist">Alamat industri pendaftar dan produsen obat (untuk obat kontrak)</td>
                    <td class="td_left">
                      <input class="infoPenandaan_bR" type="radio" id="radiog7b1_7" name="CHK7[7b]" value="+_Alamat industri pendaftar dan produsen obat (untuk obat kontrak)" <?php if ($detailsub5[8][0] == '+') echo 'checked'; ?>>
                      <label for="radiog7b1_7" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_bR" type="radio" id="radiog7b2_7" name="CHK7[7b]" value="-_Alamat industri pendaftar dan produsen obat (untuk obat kontrak)" <?php if ($detailsub5[8][0] == '-') echo 'checked'; ?>>
                      <label for="radiog7b2_7" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK7[7b]" value="<?php echo join('_', $detailsub5[8]); ?>"></td>
                  </tr>
                  <tr class="infoPenandaan_bRRow">
                      <!--<td class="td_left_checklist">8a</td>-->
                    <td class="td_left_header_checklist">Nama industri pendaftar dan pemberi lisensi</td>
                    <td class="td_left">
                      <input class="infoPenandaan_bR" type="radio" id="radiog8a1_8" name="CHK7[8a]" value="+_Nama industri pendaftar dan pemberi lisensi" <?php if ($detailsub5[9][0] == '+') echo 'checked'; ?>>
                      <label for="radiog8a1_8" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_bR" type="radio" id="radiog8a2_8" name="CHK7[8a]" value="-_Nama industri pendaftar dan pemberi lisensi" <?php if ($detailsub5[9][0] == '-') echo 'checked'; ?>>
                      <label for="radiog8a2_8" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK7[8a]" value="<?php echo join('_', $detailsub5[9]); ?>"></td>
                  </tr>
                  <tr class="infoPenandaan_bRRow">
                      <!--<td class="td_left_checklist">8b</td>-->
                    <td class="td_left_header_checklist">Alamat industri pendaftar dan pemberi lisensi</td>
                    <td class="td_left">
                      <input class="infoPenandaan_bR" type="radio" id="radiog8b1_8" name="CHK7[8b]" value="+_Alamat industri pendaftar dan pemberi lisensi" <?php if ($detailsub5[10][0] == '+') echo 'checked'; ?>>
                      <label for="radiog8b1_8" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_bR" type="radio" id="radiog8b2_8" name="CHK7[8b]" value="-_Alamat industri pendaftar dan pemberi lisensi" <?php if ($detailsub5[10][0] == '-') echo 'checked'; ?>>
                      <label for="radiog8b2_8" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK7[8b]" value="<?php echo join('_', $detailsub5[10]); ?>"></td>
                  </tr>
                  <tr class="infoPenandaan_bRRow">
                      <!--<td class="td_left_checklist">9</td>-->
                    <td class="td_left_checklist">Cara pemberian</td>
                    <td class="td_left">
                      <input class="infoPenandaan_bR" type="radio" id="radiog91_9" name="CHK7[9]" value="+_Cara pemberian" <?php if ($detailsub5[11][0] == '+') echo 'checked'; ?>>
                      <label for="radiog91_9" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_bR" type="radio" id="radiog92_9" name="CHK7[9]" value="-_Cara pemberian" <?php if ($detailsub5[11][0] == '-') echo 'checked'; ?>>
                      <label for="radiog92_9" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK7[9]" value="<?php echo join('_', $detailsub5[11]); ?>"></td>
                  </tr>
                  <tr class="infoPenandaan_bRRow">
                      <!--<td class="td_left_checklist">10</td>-->
                    <td class="td_left_header_checklist">Nomor izin edar</td>
                    <td class="td_left">
                      <input class="infoPenandaan_bR" type="radio" id="radiog101_10" name="CHK7[10]" value="+_Nomor izin edar" <?php if ($detailsub5[12][0] == '+') echo 'checked'; ?>>
                      <label for="radiog101_10" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_bR" type="radio" id="radiog102_10" name="CHK7[10]" value="-_Nomor izin edar" <?php if ($detailsub5[12][0] == '-') echo 'checked'; ?>>
                      <label for="radiog102_10" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK7[10]" value="<?php echo join('_', $detailsub5[12]); ?>"></td>
                  </tr>
                  <tr class="infoPenandaan_bRRow">
                      <!--<td class="td_left_checklist">14</td>-->
                    <td class="td_left_header_checklist">Data keamanan nonklinik </td>
                    <td class="td_left">
                      <input class="infoPenandaan_bR" type="radio" id="radiog141_14" name="CHK7[14]" value="+_Data keamanan nonklinik" <?php if ($detailsub5[13][0] == '+') echo 'checked'; ?>>
                      <label for="radiog141_14" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_bR" type="radio" id="radiog142_14" name="CHK7[14]" value="-_Data keamanan nonklinik" <?php if ($detailsub5[13][0] == '-') echo 'checked'; ?>>
                      <label for="radiog142_14" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK7[14]" value="<?php echo join('_', $detailsub5[13]); ?>"></td>
                  </tr>
                  <tr class="infoPenandaan_bRRow">
                      <!--<td class="td_left_checklist">15</td>-->
                    <td class="td_left_header_checklist">Cara kerja obat</td>
                    <td class="td_left">
                      <input class="infoPenandaan_bR" type="radio" id="radiog151_15" name="CHK7[15]" value="+_Cara kerja obat" <?php if ($detailsub5[14][0] == '+') echo 'checked'; ?>>
                      <label for="radiog151_15" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_bR" type="radio" id="radiog152_15" name="CHK7[15]" value="-_Cara kerja obat" <?php if ($detailsub5[14][0] == '-') echo 'checked'; ?>>
                      <label for="radiog152_15" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK7[15]" value="<?php echo join('_', $detailsub5[14]); ?>"></td>
                  </tr>
                  <tr class="infoPenandaan_bRRow">
                      <!--<td class="td_left_checklist">16</td>-->
                    <td class="td_left_header_checklist">Indikasi</td>
                    <td class="td_left">
                      <input class="infoPenandaan_bR" type="radio" id="radiog161_16" name="CHK7[16]" value="+_Indikasi" <?php if ($detailsub5[15][0] == '+') echo 'checked'; ?>>
                      <label for="radiog161_16" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_bR" type="radio" id="radiog162_16" name="CHK7[16]" value="-_Indikasi" <?php if ($detailsub5[15][0] == '-') echo 'checked'; ?>>
                      <label for="radiog162_16" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK7[16]" value="<?php echo join('_', $detailsub5[15]); ?>"></td>
                  </tr>
                  <tr class="infoPenandaan_bRRow">
                      <!--<td class="td_left_checklist">17</td>-->
                    <td class="td_left_header_checklist">Posologi/Dosis</td>
                    <td class="td_left">
                      <input class="infoPenandaan_bR" type="radio" id="radiog171_17" name="CHK7[17]" value="+_Posologi/Dosis" <?php if ($detailsub5[16][0] == '+') echo 'checked'; ?>>
                      <label for="radiog171_17" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_bR" type="radio" id="radiog172_17" name="CHK7[17]" value="-_Posologi/Dosis" <?php if ($detailsub5[16][0] == '-') echo 'checked'; ?>>
                      <label for="radiog172_17" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK7[17]" value="<?php echo join('_', $detailsub5[16]); ?>"></td>
                  </tr>
                  <tr class=" bentukSediaan1bR infoPenandaan_bRRow" hidden>
                      <!--<td class="td_left_checklist">18</td>-->
                    <td class="td_left_header_checklist">Cara rekonstitusi</td>
                    <td class="td_left">
                      <input class="infoPenandaan_bR" type="radio" id="radiog181_18" name="CHK7[18]" value="+_Cara rekonstitusi" <?php if ($detailsub5[17][0] == '+') echo 'checked'; ?>>
                      <label for="radiog181_18" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_bR" type="radio" id="radiog182_18" name="CHK7[18]" value="-_Cara rekonstitusi" <?php if ($detailsub5[17][0] == '-') echo 'checked'; ?>>
                      <label for="radiog182_18" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK7[18]" value="<?php echo join('_', $detailsub5[17]); ?>"></></td>
                  </tr>
                  <tr class="infoPenandaan_bRRow">
                      <!--<td class="td_left_checklist">19</td>-->
                    <td class="td_left_header_checklist">Kontra indikasi</td>
                    <td class="td_left">
                      <input class="infoPenandaan_bR" type="radio" id="radiog191_19" name="CHK7[19]" value="+_Kontra indikasi" <?php if ($detailsub5[18][0] == '+') echo 'checked'; ?>>
                      <label for="radiog191_19" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_bR" type="radio" id="radiog192_19" name="CHK7[19]" value="-_Kontra indikasi" <?php if ($detailsub5[18][0] == '-') echo 'checked'; ?>>
                      <label for="radiog192_19" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK7[19]" value="<?php echo join('_', $detailsub5[18]); ?>"></></td>
                  </tr>
                  <tr class="infoPenandaan_bRRow">
                      <!--<td class="td_left_checklist">20</td>-->
                    <td class="td_left_header_checklist">Efek samping</td>
                    <td class="td_left">
                      <input class="infoPenandaan_bR" type="radio" id="radiog201_20" name="CHK7[20]" value="+_Efek samping" <?php if ($detailsub5[19][0] == '+') echo 'checked'; ?>>
                      <label for="radiog201_20" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_bR" type="radio" id="radiog202_20" name="CHK7[20]" value="-_Efek samping" <?php if ($detailsub5[19][0] == '-') echo 'checked'; ?>>
                      <label for="radiog202_20" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK7[20]" value="<?php echo join('_', $detailsub5[19]); ?>"></></td>
                  </tr>
                  <tr class="infoPenandaan_bRRow">
                      <!--<td class="td_left_checklist">21</td>-->
                    <td class="td_left_header_checklist">Interaksi obat</td>
                    <td class="td_left">
                      <input class="infoPenandaan_bR" type="radio" id="radiog211_21" name="CHK7[21]" value="+_Interaksi obat" <?php if ($detailsub5[20][0] == '+') echo 'checked'; ?>>
                      <label for="radiog211_21" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_bR" type="radio" id="radiog212_21" name="CHK7[21]" value="-_Interaksi obat" <?php if ($detailsub5[20][0] == '-') echo 'checked'; ?>>
                      <label for="radiog212_21" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK7[21]" value="<?php echo join('_', $detailsub5[20]); ?>"></></td>
                  </tr>
                  <tr class="infoPenandaan_bRRow">
                      <!--<td class="td_left_checklist">22</td>-->
                    <td class="td_left_header_checklist">Peringatan - Perhatian</td>
                    <td class="td_left">
                      <input class="infoPenandaan_bR" type="radio" id="radiog221_22" name="CHK7[22]" value="+_Peringatan - Perhatian" <?php if ($detailsub5[21][0] == '+') echo 'checked'; ?>>
                      <label for="radiog221_22" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_bR" type="radio" id="radiog222_22" name="CHK7[22]" value="-_Peringatan - Perhatian" <?php if ($detailsub5[21][0] == '-') echo 'checked'; ?>>
                      <label for="radiog222_22" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK7[22]" value="<?php echo join('_', $detailsub5[21]); ?>"></></td>
                  </tr>
                  <tr class="infoPenandaan_bRRow">
                      <!--<td class="td_left_checklist">23</td>-->
                    <td class="td_left_header_checklist">Kehamilan dan menyusui</td>
                    <td class="td_left">
                      <input class="infoPenandaan_bR" type="radio" id="radiog231_23" name="CHK7[23]" value="+_Kehamilan dan menyusui" <?php if ($detailsub5[22][0] == '+') echo 'checked'; ?>>
                      <label for="radiog231_23" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_bR" type="radio" id="radiog232_23" name="CHK7[23]" value="-_Kehamilan dan menyusui" <?php if ($detailsub5[22][0] == '-') echo 'checked'; ?>>
                      <label for="radiog232_23" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK7[23]" value="<?php echo join('_', $detailsub5[22]); ?>"></></td>
                  </tr>
                  <tr class="infoPenandaan_bRRow">
                      <!--<td class="td_left_checklist">24</td>-->
                    <td class="td_left_header_checklist">Efek pada pengendara dan menjalankan mesin</td>
                    <td class="td_left">
                      <input class="infoPenandaan_bR" type="radio" id="radiog241_24" name="CHK7[24]" value="+_Efek pada pengendara dan menjalankan mesin" <?php if ($detailsub5[23][0] == '+') echo 'checked'; ?>>
                      <label for="radiog241_24" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_bR" type="radio" id="radiog242_24" name="CHK7[24]" value="-_Efek pada pengendara dan menjalankan mesin" <?php if ($detailsub5[23][0] == '-') echo 'checked'; ?>>
                      <label for="radiog242_24" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK7[24]" value="<?php echo join('_', $detailsub5[23]); ?>"></></td>
                  </tr>
                  <tr class="infoPenandaan_bRRow">
                      <!--<td class="td_left_checklist">25</td>-->
                    <td class="td_left_header_checklist">Overdosis dan pengobatan</td>
                    <td class="td_left">
                      <input class="infoPenandaan_bR" type="radio" id="radiog251_25" name="CHK7[25]" value="+_Overdosis dan pengobatan" <?php if ($detailsub5[24][0] == '+') echo 'checked'; ?>>
                      <label for="radiog251_25" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_bR" type="radio" id="radiog252_25" name="CHK7[25]" value="-_Overdosis dan pengobatan" <?php if ($detailsub5[24][0] == '-') echo 'checked'; ?>>
                      <label for="radiog252_25" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK7[25]" value="<?php echo join('_', $detailsub5[24]); ?>"></></td>
                  </tr>
                  <tr class="infoPenandaan_bRRow">
                      <!--<td class="td_left_checklist">26</td>-->
                    <td class="td_left_header_checklist">Daftar zat tambahan</td>
                    <td class="td_left">
                      <input class="infoPenandaan_bR" type="radio" id="radiog261_26" name="CHK7[26]" value="+_Daftar zat tambahan" <?php if ($detailsub5[25][0] == '+') echo 'checked'; ?>>
                      <label for="radiog261_26" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_bR" type="radio" id="radiog262_26" name="CHK7[26]" value="-_Daftar zat tambahan" <?php if ($detailsub5[25][0] == '-') echo 'checked'; ?>>
                      <label for="radiog262_26" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK7[26]" value="<?php echo join('_', $detailsub5[25]); ?>"></></td>
                  </tr>
                  <tr class="infoPenandaan_bRRow">
                      <!--<td class="td_left_checklist">27</td>-->
                    <td class="td_left_header_checklist">Ketidaktercampuran</td>
                    <td class="td_left">
                      <input class="infoPenandaan_bR" type="radio" id="radiog271_27" name="CHK7[27]" value="+_Ketidaktercampuran" <?php if ($detailsub5[26][0] == '+') echo 'checked'; ?>>
                      <label for="radiog271_27" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_bR" type="radio" id="radiog272_27" name="CHK7[27]" value="-_Ketidaktercampuran" <?php if ($detailsub5[26][0] == '-') echo 'checked'; ?>>
                      <label for="radiog272_27" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK7[27]" value="<?php echo join('_', $detailsub5[26]); ?>"></></td>
                  </tr>
                  <tr class="oKPNbR infoPenandaan_bRRow"  hidden="true">
                      <!--<td class="td_left_checklist">28a</td>-->
                    <td class="td_left_header_checklist">"Harus dengan resep dokter"</td>
                    <td class="td_left">
                      <input class="infoPenandaan_bR" type="radio" id="radiog28a1_28RD" name="CHK7[28a]" value="+_Harus dengan resep dokter" <?php if ($detailsub5[27][0] == '+') echo 'checked'; ?>>
                      <label for="radiog28a1_28RD" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_bR" type="radio" id="radiog28a2_28RD" name="CHK7[28a]" value="-_Harus dengan resep dokter" <?php if ($detailsub5[27][0] == '-') echo 'checked'; ?>>
                      <label for="radiog28a2_28RD" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK7[28a]" value="<?php echo join('_', $detailsub5[27]); ?>"></td>
                  </tr>
                  <tr class="oTbR infoPenandaan_bRRow" hidden="true">
                       <!--<td class="td_left_checklist">28b</td>-->
                    <td class="td_left_header_checklist">Tanda peringatan (P No.1 - P No.6)</td>
                    <td class="td_left">
                      <input class="infoPenandaan_bR" type="radio" id="radiog28b1_28BT" name="CHK7[28b]" value="+_Tanda peringatan (P No.1 - P No.6)" <?php if ($detailsub5[28][0] == '+') echo 'checked'; ?>>
                      <label for="radiog28b1_28BT" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_bR" type="radio" id="radiog28b2_28BT" name="CHK7[28b]" value="-_Tanda peringatan (P No.1 - P No.6)" <?php if ($detailsub5[28][0] == '-') echo 'checked'; ?>>
                      <label for="radiog28b2_28BT" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK7[28b]" value="<?php echo join('_', $detailsub5[28]); ?>"></td>
                  </tr>
                  <tr style="background-color: white" class="bebasTerbatasbR infoPenandaan_bRRow" hidden>
                      <!--<td class="td_left_checklist">28c</td>-->
                    <td style="background-color: white" class="td_left_header_checklist">Kotak peringatan</td>
                    <td style="background-color: white" class="td_left">
                      <input class="infoPenandaan_bR bebasTerbatasbR2" type="radio" id="radiog28c1_28BT" name="CHK7[28c]" value="+_Kotak peringatan" <?php if ($detailsub5[29][0] == '+') echo 'checked'; ?>>
                      <label for="radiog28c1_28BT" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_bR bebasTerbatasbR2" type="radio" id="radiog28c2_28BT" name="CHK7[28c]" value="-_Kotak peringatan" <?php if ($detailsub5[29][0] == '-') echo 'checked'; ?>>
                      <label for="radiog28c2_28BT" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" class="bebasTerbatasbR3" name="CHK7[28c]" value="<?php echo join('_', $detailsub5[29]); ?>"></td>
                  </tr>
                  <tr class="infoPenandaan_bRRow">
                      <!--<td class="td_left_checklist">28d</td>-->
                    <td style="background-color: white" class="td_left_header_checklist">"Bersumber babi/bersinggungan"</td>
                    <td style="background-color: white" class="td_left">
                      <input class="infoPenandaan_bR" type="radio" id="radiog28d1_28" name="CHK7[28d]" value="+_Bersumber babi/bersinggungan" <?php if ($detailsub5[30][0] == '+') echo 'checked'; ?>>
                      <label for="radiog28d1_28" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_bR" type="radio" id="radiog28d2_28" name="CHK7[28d]" value="-_Bersumber babi/bersinggungan" <?php if ($detailsub5[30][0] == '-') echo 'checked'; ?>>
                      <label for="radiog28d2_28" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK7[28d]" value="<?php echo join('_', $detailsub5[30]); ?>"></td>
                  </tr>
                  <tr style="background-color: white" class="infoPenandaan_bRRow">
                      <!--<td class="td_left_checklist">28e</td>-->
                    <td class="td_left_header_checklist">Kandungan alkohol</td>
                    <td class="td_left">
                      <input class="infoPenandaan_bR" type="radio" id="radiog28e1_28" name="CHK7[28e]" value="+_Kandungan alkohol" <?php if ($detailsub5[31][0] == '+') echo 'checked'; ?>>
                      <label for="radiog28e1_28" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_bR" type="radio" id="radiog28e2_28" name="CHK7[28e]" value="-_Kandungan alkohol" <?php if ($detailsub5[31][0] == '-') echo 'checked'; ?>>
                      <label for="radiog28e2_28" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK7[28e]" value="<?php echo join('_', $detailsub5[31]); ?>"></td>
                  </tr>
                  <tr class="infoPenandaan_bRRow">
                      <!--<td class="td_left_checklist">29</td>-->
                    <td class="td_left_header_checklist">Cara penyimpanan obat (termasuk cara penyimpanan setelah rekonstitusi)</td>
                    <td class="td_left">
                      <input class="infoPenandaan_bR" type="radio" id="radiog291_29" name="CHK7[29]" value="+_Cara penyimpanan obat (termasuk cara penyimpanan setelah rekonstitusi)" <?php if ($detailsub5[32][0] == '+') echo 'checked'; ?>>
                      <label for="radiog291_29" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_bR" type="radio" id="radiog292_29" name="CHK7[29]" value="-_Cara penyimpanan obat (termasuk cara penyimpanan setelah rekonstitusi)" <?php if ($detailsub5[32][0] == '-') echo 'checked'; ?>>
                      <label for="radiog292_29" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK7[29]" value="<?php echo join('_', $detailsub5[32]); ?>"></td>
                  </tr>
                  <tr class="infoPenandaan_bRRow">
                      <!--<td class="td_left_checklist">30</td>-->
                    <td class="td_left_header_checklist">Stabilitas/masa edar (shelf life) obat</td>
                    <td class="td_left">
                      <input class="infoPenandaan_bR" type="radio" id="radiog301_30" name="CHK7[30]" value="+_Stabilitas/masa edar (shelf life) obat" <?php if ($detailsub5[33][0] == '+') echo 'checked'; ?>>
                      <label for="radiog301_30" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_bR" type="radio" id="radiog302_30" name="CHK7[30]" value="-_Stabilitas/masa edar (shelf life) obat" <?php if ($detailsub5[33][0] == '-') echo 'checked'; ?>>
                      <label for="radiog302_30" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK7[30]" value="<?php echo join('_', $detailsub5[33]); ?>"></td>
                  </tr>
                  <tr class="infoPenandaan_bRRow bentukSediaan3bR" hidden>
                      <!--<td class="td_left_checklist">31</td>-->
                    <td class="td_left_header_checklist">Stabilitas/batas penggunaan setelah direkonstitusi/setelah wadah dibuka </td>
                    <td class="td_left">
                      <input class="infoPenandaan_bR" type="radio" id="radiog311_31" name="CHK7[31]" value="+_Stabilitas/batas penggunaan setelah direkonstitusi/setelah wadah dibuka" <?php if ($detailsub5[34][0] == '+') echo 'checked'; ?>>
                      <label for="radiog311_31" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_bR" type="radio" id="radiog312_31" name="CHK7[31]" value="-_Stabilitas/batas penggunaan setelah direkonstitusi/setelah wadah dibuka" <?php if ($detailsub5[34][0] == '-') echo 'checked'; ?>>
                      <label for="radiog312_31" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK7[31]" value="<?php echo join('_', $detailsub5[34]); ?>"></td>
                  </tr>
                  <tr class="bentukSediaan2bR infoPenandaan_bRRow" hidden>
                      <!--<td class="td_left_checklist">33</td>-->
                    <td class="td_left_header_checklist">Tanggal disetujui pertama kali/registrasi ulang</td>
                    <td class="td_left">
                      <input class="infoPenandaan_bR" type="radio" id="radiog331_33" name="CHK7[33]" value="+_Tanggal disetujui pertama kali/registrasi ulang" <?php if ($detailsub5[35][0] == '+') echo 'checked'; ?>>
                      <label for="radiog331_33" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_bR" type="radio" id="radiog332_33" name="CHK7[33]" value="-_Tanggal disetujui pertama kali/registrasi ulang" <?php if ($detailsub5[35][0] == '-') echo 'checked'; ?>>
                      <label for="radiog332_33" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK7[33]" value="<?php echo join('_', $detailsub5[35]); ?>"></td>
                  </tr>
                  <tr class="infoPenandaan_bRRow">
                      <!--<td class="td_left_checklist">34</td>-->
                    <td class="td_left_header_checklist">Tanggal perubahan</td>
                    <td class="td_left">
                      <input class="infoPenandaan_bR" type="radio" id="radiog341_34" name="CHK7[34]" value="+_Tanggal perubahan" <?php if ($detailsub5[36][0] == '+') echo 'checked'; ?>>
                      <label for="radiog341_34" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_bR" type="radio" id="radiog342_34" name="CHK7[34]" value="-_Tanggal perubahan" <?php if ($detailsub5[36][0] == '-') echo 'checked'; ?>>
                      <label for="radiog342_34" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK7[34]" value="<?php echo join('_', $detailsub5[36]); ?>"></td>
                  </tr>
                  <tr class="infoPenandaan_bRRow">
                      <!--<td class="td_left_checklist">35</td>-->
                    <td class="td_left_header_checklist">Golongan obat</td>
                    <td class="td_left">
                      <input class="infoPenandaan_bR" type="radio" id="radiog351_35" name="CHK7[35]" value="+_Golongan obat" <?php if ($detailsub5[37][0] == '+') echo 'checked'; ?>>
                      <label for="radiog351_35" style="width: 54px; height: 10px;"></label>
                      <span style="margin-left: 5px;"></span>
                      <input class="infoPenandaan_bR" type="radio" id="radiog352_35" name="CHK7[35]" value="-_Golongan obat" <?php if ($detailsub5[37][0] == '-') echo 'checked'; ?>>
                      <label for="radiog352_35" style="width: 54px; height: 10px; background-color: #9d0101;"></label>
                      <input type="text" style="display:none;" name="CHK7[35]" value="<?php echo join('_', $detailsub5[37]); ?>"></td>
                  </tr>
                  <tr>
                      <!--<td class="td_left_checklist" style="vertical-align: middle">36</td>-->
                    <td class="td_left_header_checklist" style="vertical-align: top"><input style="vertical-align: top;" class="infoPenandaan_bR" name="infoPenandaan_bR-36" type="checkbox" value="-_A" id="bR_36" <?php if ($detailsub5[38][0] != '-' && $detailsub5[38][0] != '+' && $detailsub5[38][0] != '') echo 'checked'; ?>/>&nbsp;Informasi Tambahan</td>
                    <td class="td_left"><span id="infoPenandaan_bR_txt" <?php
                      if ($detailsub5[38][0] != '-' && $detailsub5[38][0] != '+' && $detailsub5[38][0] != '')
                        ;
                      else
                        echo 'hidden';
                      ?>><textarea title="Informasi Tambahan" class="infoPenandaan_bR infoPenandaan_bR_txt" style="width: 99%; height: 75px;" name="CHK7[36]" id="bR_37" onchange="uTL(this)"><?php echo $detailsub5[38][0]; ?></textarea></span></td>
                    <td></td>
                  </tr>
                  <tr>
                  <!--<td class="td_left_checklist" style="vertical-align: top">37</td>-->
                    <td class="td_left_header_checklist" colspan="2">Lampiran : <?php
                      if (array_key_exists('FILE_PENANDAAN_BR', $sess) && trim($sess['FILE_PENANDAAN_BR']) != "") {
                        ?>
                        <span class="file_FILE_PENANDAAN_BR"><input type="hidden" name="PENANDAAN_OBAT[FILE_PENANDAAN_BR]" value="<?php echo $sess['FILE_PENANDAAN_BR']; ?>"><a href="<?php echo site_url(); ?>/download/penandaanIklanSubDirPostUpload/<?php echo 'penandaan_001/BR'; ?>/<?php echo $sess['FILE_PENANDAAN_BR']; ?>" target="_blank">File Lampiran</a>&nbsp;&bull;&nbsp;<a href="#" class="del_upload" url="<?php echo site_url(); ?>/utility/uploads/del_upload_m/<?php echo 'penandaan_001/BR'; ?>/<?php echo $sess['FILE_PENANDAAN_BR']; ?>" jns="FILE_PENANDAAN_BR">Edit atau Hapus File ?</a></span>
                        <?php
                      } else {
                        ?>
                        <span class="upload_FILE_PENANDAAN_BR"><input type="file" class="upload upBR" jenis="FILE_PENANDAAN_BR" allowed="jpg-jpeg-pdf-doc-docx-rar" url="<?php echo site_url(); ?>/utility/uploads/get_upload_m/<?php echo 'penandaan_001/BR'; ?>" id="fileToUpload_FILE_PENANDAAN_BR" name="userfile" onchange="do_upload($(this));
                        return false;" />
                          &nbsp;Tipe File : *.jpg .jpeg .pdf .doc .docx .rar</span><span class="file_FILE_PENANDAAN_BR"></span>
                        <?php
                      }
                      ?></td>
                  </tr>
                  <tr>
                      <!--<td class="td_left_checklist">35</td>-->
                    <td class="td_left_header_checklist">Kesimpulan</td>
                    <td class="td_left">
                      <input type="hidden" id="kesimpulanHasilPenilaianBRVal" readonly size="23" name="CHK7[HASIL]" value="<?php echo $detailsub5[39][0]; ?>" />
                      <input type="text" id="kesimpulanHasilPenilaianbR" readonly size="23" value="<?php
                      if ($detailsub5[39][0] == "TMK")
                        echo "Tidak Memenuhi Ketentuan";
                      else
                        echo "Memenuhi Ketentuan";
                      ?>" /></td>
                    <td></td>
                  </tr>
                  <tr><td colspan="2">&nbsp;</td></tr>
                  <tr>
                    <td class="td_left"><h2 class="small garis">Detil Pelanggaran :</h2></td>
                    <td class="td_right"><textarea readonly id="detilPelanggaranbR" name="detilPelanggaranbR" style="height: 70px; width: 99%;"></textarea></td>
                  </tr>
                  <tr>
                    <td class="td_left">&nbsp;</td>
                    <td class="td_right">Jumlah Jenis Pelanggaran : <span id="jumlahTMKbR"></span></td>
                  </tr>
                  <tr></tr>
                  <?php if ((in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')))) { ?>
                    <tr><td colspan="2"><h2 class="small garis">Kesimpulan Pusat :</h2></td></tr>
                    <?php
                    $TLBR = explode("^", $d5[5]);
                    $TLBRSub = explode("^", $d5[6]);
                    $tempBR = array($TLBR[1], $TLBR[2]);
                    $tempBRSub = array($TLBRSub[0], $TLBRSub[1]);
                    if ((empty($d5[3]) && in_array('2', $this->newsession->userdata('SESS_KODE_ROLE'))) || $editTL == 'YES') {
                      ?>
                      <tr><td class="td_left">Verifikasi Pusat</td><td class="td_right"><select id="BR" class="stext verifikasiPusat" name="<?php echo 'BR[HASIL_PUSAT][]' ?>" title="MK/TMK"><option></option><option value="MK" <?php if ($d5[3] == "MK") echo 'Selected' ?>>Memenuhi Ketentuan</option><option value="TMK" <?php if ($d5[3] == "TMK") echo 'Selected' ?>>Tidak Memenuhi Ketentuan</option></select></tr>
                      <tr class="vTMK_BR" hidden><td class="td_left">Kategori Pelanggaran</td><td class="td_right"><select class="sjenis vTMKa_BR" title="Kategori Pelanggaran"><option></option><option value="Kritikal" <?php if ($TLBR[0] == "Kritikal") echo 'Selected' ?>>Kritikal</option><option value="Non Kritikal" <?php if ($TLBR[0] == "Non Kritikal") echo 'Selected' ?>>Non Kritikal</option></select></td></tr>
                      <tr class="vTMK_BR" hidden><td class="td_left"style="background-color: white;">Tindak Lanjut</td><td class="td_right" style="background-color: white;"><?php echo form_dropdown('BR[HASIL_PUSAT][]', $cb_tl, !empty($d5[4]) ? $d5[4] : '', 'class="stext verifikasiPusatSub" id="vTMKSub_BR" title="Tindak Lanjut Pusat"'); ?></td></tr>
                      <tr class="vTMK2_BR" hidden><td class="td_left"style="background-color: white;"></td><td class="td_right" style="background-color: white;"><?php echo form_dropdown('BR[TL_PUSAT][]', $cb_tindakan, is_array($tempBR) ? $tempBR : '', 'class="stext multiselect vTMK2_BR" multiple title="Saran Tindak Lanjut Pusat. Untuk memilih lebih dari satu, klik + Ctrl"'); ?></td></tr>
                      <tr class="vTMK2_BR" hidden><td class="td_left">Surat Tindak Lanjut</td><td class="td_right"><input type="text" class="sdate vTMK2a_BR" name="BR[DETAIL_PUSAT][]" id="tglSuratTLBR" title="Tanggal Surat Tindak Lanjut" placeholder="Tanggal Surat" onchange="comp('D')" value="<?php echo$tempBRSub[0]; ?>"/>&nbsp;&nbsp;&nbsp;Tanggal Surat Tindak Lanjut</td><td></td></tr>
                      <tr class="vTMK2_BR" hidden><td class="td_left"></td><td class="td_right"><input type="text" class="stext vTMK2a_BR" name="BR[DETAIL_PUSAT][]" id="stugas_"  title="Di isi dengan nomor surat tindak lanjut" placeholder="Nomor Surat Tindak Lanjut" value="<?php echo $tempBRSub[1]; ?>"/>&nbsp;&nbsp;&nbsp;Nomor Surat Tindak Lanjut</td></tr>
                      <tr class="vJustifikasi_BR" hidden><td class="td_left">Justifikasi</td><td style="padding: 5px"><textarea name="JUSTIFIKASI_BR" title="Justifikasi Pusat" class="stext chkJustifikasi chkJustifikasi_BR" style="height: 140px"><?php echo $d5[7]; ?></textarea></td></tr>
                      <?php
                    } else if (!empty($d5[3])) {
                      ?>
                      <tr><td class="td_left">Verifikasi Pusat</td><td class="td_right" colspan="2"><b><i><?php
                              if ($d5[3] == "TMK")
                                echo "Tidak Memenuhi Ketentuan";
                              else
                                "Memenuhi Ketentuan"
                                ?></i></b></td></tr>
                      <?php if (!empty($TLBR[0])) { ?><tr><td class="td_left">Kategori Pelanggaran</td><td class="td_right"><?php echo $TLBR[0]; ?></td></tr>
                      <?php } if (!empty($d5[4])) { ?><tr><td class="td_left">Tindak Lanjut</td><td class="td_right"><?php if ($d5[4] == "TL") echo "Tindak Lanjut"; else if ($d5[4] == "STL") echo "Sudah Tindak Lanjut"; else if ($d5[4] == "TTL") echo "Tidak Dapat Tindak Lanjut" ?></td></tr>
                      <?php }if (!empty($TLBR[1])) { ?><tr><td class="td_left">Detil Tindak Lanjut Pusat</td><td class="td_right"><ul style="list-style-type:decimal; padding-left:20px; margin:0;"><?php
                        if ($TLBR[2] != '')
                          echo "<li>" . join("</li><li>", $tempBR) . "</li>";
                        else
                          echo "<li>" . $TLBR[1] . "</li>";
                        ?></ul></td></tr>
                      <?php } if (!empty($TLBRSub[0])) {
                        ?><tr><td class="td_left">Surat Tindak Lanjut</td><td class="td_right"><ul style="padding-left:20px; margin:0;"><?php
                              echo "<li>Tangal Surat : " . join("</li><li>Nomor Surat : ", $tempBRSub) . "</li>";
                              ?></ul></td></tr>
                      <?php } if (!empty($d5[7])) {
                        ?>
                        <tr><td class="td_left">Justifikasi Pusat</td><td class="td_right"><?php echo $d5[7]; ?></td></tr>
                        <?php
                      }
                    }
                  }
                  ?>
                </table>
              </div>
            </div>
          </div>
        </div>
        <div style="height:5px;" id="expand2b"></div>

        <?php if ($formEdit === 'check') { ?>
          <div class="expand" id="expand5"><a title="expand/collapse" href="#" style="display: block;">VERIFIKASI PENGAWASAN</a></div>
          <div class="collapse">
            <div class="accCntnt">
              <h2 class="small garis">Verifikasi Pengawasan</h2>
              <table class="form_tabel">
                <tr><td class="td_left">Proses Pengawasan</td><td class="td_right"><?php echo form_dropdown($objStatus, $status, '', 'class="stext" title="Pilih salah satu, untuk memproses dokumen pemeriksaan" rel="required" name', $disverifikasi); ?></td></tr>
                <tr><td class="td_left">Catatan</td><td class="td_right"><textarea name="CATATAN" class="stext" rel="required" title="Catatan"></textarea></td></tr></table>
            </div>
          </div>
        </div>
      <?php } ?>

      <div style="padding:10px;"></div><div><a href="javascript:void(0)" id="btnSave" class="button <?php echo $icon; ?>" onclick="fpost('#fpengawasanPenandaan_001', '', '');">
          <span><span class="icon"></span>&nbsp; <?php echo $labelSimpan; ?></span></a>&nbsp;
        <a href="javascript:void(0)" class="button reload" onclick="goBack()" >
          <span><span class="icon"></span>&nbsp; Batal</span></a></div>
      <br />
      <br />
      <div id="form_tabel_detail" hidden="true" class="popup">
      </div>
    </div>
</div>
<input type="hidden" name="PENANDAAN_ID[]" value="<?php echo $sess['PENANDAAN_ID']; ?>" />
<input type="hidden" name="UPDATE" value="<?php echo $sess['STATUS']; ?>" />
<input type="hidden" name="KLASIFIKASIPENANDAAN" value="<?php echo $klasifikasi; ?>" />
<input type="hidden" name="EDIT" value="<?php echo $editTL; ?>" />
<input type="hidden" name="TUJUAN" value="<?php echo $tujuan; ?>" />
</form>
</div>
<script type="text/javascript">
                    function goBack()
                    {
                      window.history.back()
                    }
                    function uTL(XXX) {
                      uraianTidakLengkap($(XXX));
                    }
                    function resetPusat(id) {
                      $(".vTMK_" + id).attr("rel", " ");
                      $(".vTMK_" + id).val("");
                      $(".vTMKa_" + id).val("");
                      $(".vTMKa_" + id).attr("rel", " ");
                      $(".vMK_" + id).attr("rel", " ");
                      $(".vMK_" + id).val("");
                      $(".vMKa_" + id).val("");
                      $(".vMKa_" + id).attr("rel", " ");
                    }
                    function clearRedact(X, A) {
                      if (A == 0) {
                        var id = $(X).attr("id");
                        $(".chkJustifikasi_" + id).text("");
                        $(".vJustifikasi_" + id + " .redactor_box .redactor_frame").contents().find("#page").html("<p>&nbsp;</p>");
                      } else {
                        $(".chkJustifikasi_" + X).text("");
                        $(".vJustifikasi_" + X + " .redactor_box .redactor_frame").contents().find("#page").html("<p>&nbsp;</p>");
                      }
                    }
                    function verifikasiPusat(X, A) {
                      if (A == 0) {
                        var id = $(X).attr("id");
                        var mkTMK = $("#" + id).val();
                        if (mkTMK === "MK") {
                          $(".vMK_" + id).show();
                          $(".vMK_" + id).attr("rel", "required");
                          $(".vMKa_" + id).attr("rel", "required");
                          $(".vMKa_" + id).attr("name", id + "[TL_PUSAT][]");
                          $(".vTMK_" + id).hide();
                          $(".vTMK_" + id).attr("rel", " ");
                          $(".vTMK_" + id).val("");
                          $(".vTMKa_" + id).val("");
                          $(".vTMKa_" + id).attr("rel", " ");
                          $(".vTMKa_" + id).attr("name", " ");
                          $(".vTMK2_" + id).hide("slow");
                          $(".vTMK2_" + id).val("");
                          $(".vTMK2_" + id).attr("rel", "");
                          $(".vTMK2a_" + id).val("");
                          $("#vTMKSub_" + id).attr("rel", "");
                          $("#vTMKSub_" + id).val("");
                        }
                        else if (mkTMK === "TMK") {
                          $(".vMK_" + id).hide();
                          $(".vMK_" + id).attr("rel", " ");
                          $(".vMK_" + id).val("");
                          $(".vMKa_" + id).attr("rel", " ");
                          $(".vMKa_" + id).attr("name", " ");
                          $(".vMKa_" + id).val("");
                          $(".vTMK_" + id).show();
                          $(".vTMK_" + id).attr("rel", "required");
                          $(".vTMKa_" + id).attr("rel", "required");
                          $(".vTMKa_" + id).attr("name", id + "[TL_PUSAT][]");
                          $("#vTMKSub_" + id).attr("rel", "required");
                        }
                        else {
                          $(".vMK_" + id).hide();
                          $(".vMK_" + id).attr("rel", " ");
                          $(".vMK_" + id).val("");
                          $(".vMKa_" + id).attr("rel", " ");
                          $(".vMKa_" + id).attr("name", " ");
                          $(".vMKa_" + id).val("");
                          $(".vMK_" + id).hide();
                          $(".vTMK_" + id).hide();
                          $(".vTMK_" + id).hide();
                          $(".vTMK_" + id).attr("rel", " ");
                          $(".vTMK_" + id).val("");
                          $(".vTMKa_" + id).val("");
                          $(".vTMKa_" + id).attr("rel", " ");
                          $(".vTMKa_" + id).attr("name", " ");
                          $(".vTMK2_" + id).hide("slow");
                          $(".vTMK2_" + id).val("");
                          $(".vTMK2_" + id).attr("rel", "");
                          $(".vTMK2a_" + id).val("");
                          $("#vTMKSub_" + id).attr("rel", "");
                          $("#vTMKSub_" + id).val("");
                        }
                        if ($(X).val() != '') {
                          if ($(X).val() != $("#kesimpulanHasilPenilaian" + id + "Val").val()) {
                            $(".vJustifikasi_" + id).show("slow");
                            $(".chkJustifikasi_" + id).attr("rel", "required");
                          } else if ($(X).val() == $("#kesimpulanHasilPenilaian" + id + "Val").val()) {
                            $(".vJustifikasi_" + id).hide("slow");
                            $(".chkJustifikasi_" + id).attr("rel", "");
                          }
                        } else {
                          $(".vJustifikasi_" + id).hide("slow");
                          $(".chkJustifikasi_" + id).attr("rel", "");
                        }
                      }
                      else {
                        if ($("#" + X).val() != '') {
                          if ($("#" + X).val() != $("#kesimpulanHasilPenilaian" + X + "Val").val()) {
                            $(".vJustifikasi_" + X).show("slow");
                            $(".chkJustifikasi_" + X).attr("rel", "required");
                          } else if ($("#" + X).val() == $("#kesimpulanHasilPenilaian" + X + "Val").val()) {
                            $(".vJustifikasi_" + X).hide("slow");
                            $(".chkJustifikasi_" + X).attr("rel", "");
                          }
                        } else {
                          $(".vJustifikasi_" + X).hide("slow");
                          $(".chkJustifikasi_" + X).attr("rel", "");
                          $(".chkJustifikasi_" + X).html("");
                        }
                      }
                    }
                    function verifikasiTL(X) {
                      var id = $(X).attr("id").split("_");
                      if ($(X).val() == 'TL' || $(X).val() == 'STL') {
                        $(".vTMK2_" + id[1]).show("slow");
                        $(".vTMK2_" + id[1]).attr("rel", "required");
                      } else {
                        $(".vTMK2_" + id[1]).hide("slow");
                        $(".vTMK2_" + id[1]).attr("rel", "");
                        $(".vTMK2_" + id[1]).val("");
                        $(".vTMK2a_" + id[1]).val("");
                      }
                    }
                    function do_upload(element) {
                      var jenis = $(element).attr("jenis");
                      var allowed = $(element).attr("allowed");
                      var id = $(element).attr("id").split("_");
                      if ($("#kesimpulanHasilPenilaian" + id[3] + "Val").val() === "") {
                        jAlert("Mohon berikan penilaian terlebih dahulu")
                        $(element).val("");
                        return false;
                      }
                      jLoadingOpen("Upload File", "SIPT Versi 1.0");
                      $.ajaxFileUpload({
                        url: $(element).attr("url") + "/" + jenis + "/" + allowed,
                        secureuri: false,
                        fileElementId: $(element).attr("id"),
                        dataType: "json",
                        success: function(data) {
                          var arrdata = data.msg.split("#");
                          if (typeof (data.error) !== "undefined") {
                            if (data.error !== "") {
                              jAlert(data.error, "SIPT Versi 1.0 Beta");
                            } else {
                              if (arrdata[2] !== "") {
                                $("#fileToUpload_" + arrdata[2] + "").removeAttr("rel");
                                $(".upload_" + arrdata[2] + "").hide();
                                $(".file_" + arrdata[2] + "").html("<b>1 File telah dilampirkan. </b>&nbsp;<a href=\"<?php echo site_url(); ?>/download/penandaanIklanSubDirPreUpload/" + arrdata[3] + "/" + arrdata[4] + "/" + arrdata[0] + "\" target=\"_blank\">Tampilkan File</a>&nbsp;&bull;&nbsp;<a href=\"#\" class=\"del_upload\" url=\"<?php echo site_url(); ?>/utility/uploads/del_upload_m/" + arrdata[3] + "/" + arrdata[4] + "/" + arrdata[0] + "\" jns=" + arrdata[2] + ">Edit atau Hapus File ?</a><input type=\"hidden\" name=\"PENANDAAN_OBAT[" + arrdata[2] + "]\" value=" + arrdata[5] + ">");
                              }
                            }
                          }
                          jLoadingClose();
                        },
                        error: function(data, status, e) {
                          jAlert(e, "SIPT Versi 1.0 Beta");
                        }
                      });
                    }
                    function comp(A) {
                      var tgl1 = "#tglXX", tgl2 = "#tglAwalPengawasan", tgl3 = "#tglAkhirPengawasan";
                      if (A === "A") {
                        if ($("#tglXX") !== "")
                          compare(tgl1, tgl2);
                        if ($("#tglAkhirPengawasan").val() !== "")
                          compare(tgl2, tgl3);
                      }
                      else if (A === "B") {
                        if ($("#tglXX") !== "")
                          compare(tgl1, tgl3);
                        if ($("#tglAwalPengawasan").val() !== "")
                          compare(tgl2, tgl3);
                      }
                    }
                    function mkTmk(XXX) {
                      var Z = cekAll(XXX), A = XXX.attr("class").split("_");
                      var BT = A[1].split(" ");
                      if ($(BT).size() > 1)
                        A[1] = BT[0];
                      if (Z === true) {
                        $("#kesimpulanHasilPenilaian" + A[1]).val("Tidak Memenuhi Ketentuan");
                        $("#kesimpulanHasilPenilaian" + A[1].toUpperCase() + "Val").val("TMK");
                        $("#fileToUpload_FILE_PENANDAAN_" + A[1].toUpperCase()).attr("rel", "required");
                      }
                      else {
                        $("#kesimpulanHasilPenilaian" + A[1]).val("Memenuhi Ketentuan");
                        $("#kesimpulanHasilPenilaian" + A[1].toUpperCase() + "Val").val("MK");
                        $("#fileToUpload_FILE_PENANDAAN_" + A[1].toUpperCase()).attr("rel", "");
                        $("#fileToUpload_FILE_PENANDAAN_" + A[1].toUpperCase()).css("background-color", "#FFF");
                        $("#fileToUpload_FILE_PENANDAAN_" + A[1].toUpperCase()).css("border", "");
                      }
                      uraianTidakLengkap(XXX);
                    }
                    function cekAll(XXX) {
                      var rE, xx = XXX.attr("id").split("_"), X, XX = $(XXX).attr("class"), xxx = XX.split("_"), xBT = XX.split(" "), xxx1 = ["bL"], xxx2 = ["aS", "sB", "v1", "v2", "bR"], xxx3 = ["eT"];
                      var golonganObat = $("#golonganObat").val();
                      var BT = xxx[1].split(" ");
                      if ($(BT).size() > 1) {
                        xxx[1] = BT[0];
                        XX = xBT[0];
                      }
                      if ($.inArray(xxx[1], xxx1) > -1) {
                        if (golonganObat === "Keras" || golonganObat === "Narkotika" || golonganObat === "Psikotropika")
                          X = ["3", "8", "9", "14", "16", "17", "19", "20", "21", "22", "26", "27", "28", "30", "33", "34", "35"];
                        else if (golonganObat === "Bebas Terbatas")
                          X = ["3", "8", "9", "14", "19", "20", "21", "22", "26", "27", "28", "30", "33", "34", "35"];
//                                                else if (golonganObat !== "Keras" && golonganObat !== "Bebas Terbatas")
                        else
                          X = ["3", "8", "9", "14", "19", "20", "21", "22", "26", "27", "28", "28BT", "30", "33", "34", "35"];
                      }
                      if ($.inArray(xxx[1], xxx2) > -1)
                        X = ["3", "8", "9", "14", "23", "24", "25", "26", "27", "28", "30", "33", "34", "35"];
                      if ($.inArray(xxx[1], xxx3) > -1) {
                        if (golonganObat === "Keras" || golonganObat === "Narkotika" || golonganObat === "Psikotropika")
                          X = ["3", "8", "9", "14", "16", "17", "19", "20", "21", "22", "26", "27", "28", "30", "33", "34", "35"];
//                                                else if (golonganObat !== "Keras")
                        else
                          X = ["3", "8", "9", "14", "16", "17", "19", "20", "21", "22", "26", "27", "28", "30", "33", "34", "35"];
                      }
                      $("." + XX + ":checked").each(function() {
                        var A = $(this).val(), x = $(this).attr("id").split("_"), id = $(this).val().split("_");
                        if (A !== "" && $.inArray(x[1], X) > -1) {
                        } else if (A !== "" && !$.inArray(x[1], X) > -1 && id[0] == "-") {
                          rE = true;
                        }
                      });
                      return rE;
                    }
                    function uraianTidakLengkap(XXX) {
                      var Z = "", val2 = "", val = [], xxx = "", X = [], clazz = $(XXX).attr("class").split(" "), A = clazz[0].split("_"), xxx1 = ["bL"], xxx2 = ["aS", "sB", "v1", "v2", "bR"], xxx3 = ["eT"];
                      var golonganObat = $("#golonganObat").val();
                      var BT = A[1].split(" ");
                      if ($(BT).size() > 1)
                        A[1] = BT[0];
                      if ($.inArray(A[1], xxx1) > -1) {
                        if (golonganObat === "Keras" || golonganObat === "Narkotika" || golonganObat === "Psikotropika")
                          X = ["3", "8", "9", "14", "16", "17", "19", "20", "21", "22", "26", "27", "28", "30", "33", "34", "35", "36"];
                        else if (golonganObat === "Bebas Terbatas")
                          X = ["3", "8", "9", "14", "19", "20", "21", "22", "26", "27", "28", "30", "33", "34", "35", "36"];
//                                                else if (golonganObat !== "Keras" && golonganObat !== "Bebas Terbatas")
                        else
                          X = ["3", "8", "9", "14", "19", "20", "21", "22", "26", "27", "28", "28BT", "30", "33", "34", "35", "36"];
                      }
                      if ($.inArray(A[1], xxx2) > -1)
                        X = ["3", "8", "9", "14", "23", "24", "25", "26", "27", "28", "30", "33", "34", "35", "36"];
                      if ($.inArray(A[1], xxx3) > -1) {
                        if (golonganObat === "Keras" || golonganObat === "Narkotika" || golonganObat === "Psikotropika")
                          X = ["3", "8", "9", "14", "16", "17", "19", "20", "21", "22", "26", "27", "28", "30", "33", "34", "35", "36"];
//                                                else if (golonganObat !== "Keras")
                        else
                          X = ["3", "8", "9", "14", "16", "17", "19", "20", "21", "22", "26", "27", "28", "30", "33", "34", "35", "36"];
                      }
                      $(".infoPenandaan_" + A[1]).each(function() {
                        var x = $(this).attr("id").split("_");
                        if (x[1] === "37") {
                          val2 = $("#" + A[1] + "_" + x[1]).val();
                        }
                        if ($(this).is(":checked") === true) {
                          Z = $(this).val().split("_");
                          if (Z[0] === "-" && $.inArray(x[1], X) < 0) {
                            var isi = $(this).val().split("_");
                            val.push(isi[1]);
                          }
                        }
                      });
                      if (val2 !== "")
                        val.push(val2);
                      xxx = "" + val;
                      $("#detilPelanggaran" + A[1]).val(xxx.replace(/,/g, ", "));
                      var cnt = xxx.split(",");
                      if ($("#detilPelanggaran" + A[1]).val() !== "")
                        $("#jumlahTMK" + A[1]).html(cnt.length);
                      else
                        $("#jumlahTMK" + A[1]).html("0");
                    }
                    function required(X, x) {
                      var XX = $(X).val().split("_");
                      var Param = $(X).attr("param");
                      if (x === 1) {
                        $("input:radio.infoPenandaan_" + XX[1]).each(function() {
                          var name = $(this).attr("name");
                          if ($(this).closest(".infoPenandaan_" + XX[1] + "Row").attr("hidden") === false) {
                            $("input[type='text'][name='" + name + "']").attr("rel", "required");
                            $("#" + Param).attr("rel", "required");
                          }
                          if ($(this).closest(".infoPenandaan_" + XX[1] + "Row").attr("hidden") === true) {
                            $("input[type='text'][name='" + name + "']").attr("rel", "");
                            $("#" + Param).attr("rel", "");
                          }
                        });
                      }
                      else if (x === 2) {
                        $("input:radio.infoPenandaan_" + XX[1]).each(function() {
                          var name = $(this).attr("name");
                          $("input[type='text'][name='" + name + "']").attr("rel", "");
                        });
                        $("#" + Param).attr("rel", "");
                        resetPusat(Param);
                      }
                      else {
                        alert("Terjadi Kesalahan");
                      }
                    }
                    function clear(XX) {
                      $("input:radio.infoPenandaan_" + XX).each(function() {
                        $(this).attr("checked", false);
                        $("#detilPelanggaran" + XX).val("");
                        var XXX = $(this).attr("name");
                        $("input[type='text'][name='" + XXX + "']").val("");
                      });
                      $("#kesimpulanHasilPenilaian" + XX).val("");
                      $("#kesimpulanHasilPenilaian" + XX.toUpperCase() + "Val").val("");
                      $("#fileToUpload_FILE_PENANDAAN_" + XX.toUpperCase()).attr("rel", "");
                    }
                    function borderLess(obj, param) {
                      $(obj).closest(".infoPenandaan_" + param + "Row").css('border-left', '0px');
                      $(obj).closest(".infoPenandaan_" + param + "Row").css('border-right', '0px');
                    }
                    function namaObatAuto(isian) {
                      var klasifikasiPendaftar = isian.substring(3, 2);
                      if (klasifikasiPendaftar === "L") {
                        $("#klasifikasiPendaftar").val("Lokal");
                      }
                      else if (klasifikasiPendaftar === "I") {
                        $("#klasifikasiPendaftar").val("Impor");
                      }
                      var golonganObat = isian.substring(2, 1);
                      if (golonganObat === "K") {
                        $("#golonganObat").val("Keras");
                      }
                      else if (golonganObat === "B") {
                        $("#golonganObat").val("Bebas");
                      }
                      else if (golonganObat === "T") {
                        $("#golonganObat").val("Bebas Terbatas");
                      }
                      else if (golonganObat === "P") {
                        $("#golonganObat").val("Psikotropika");
                      }
                      else if (golonganObat === "N") {
                        $("#golonganObat").val("Narkotika");
                      }
                      var klasifikasiObat = isian.substring(0, 1);
                      if (klasifikasiObat === "D") {
                        $("#klasifikasiObat").val("Obat Nama Dagang");
                      }
                      else if (klasifikasiObat === "G") {
                        $("#klasifikasiObat").val("Obat Generik");
                      }
                    }
                    $(document).ready(function() {
                      $("textarea.chkJustifikasi").redactor({
                        buttons: ['bold', 'italic', '|', 'unorderedlist', 'orderedlist', 'outdent', 'indent', '|', 'alignleft', 'aligncenter', 'alignright', 'justify'],
                        removeStyles: false,
                        cleanUp: true,
                        autoformat: true
                      });
//                      load data
<?php if (end($detail1) === "MK" || end($detail1) === "TMK") { ?>
                        var X = "bL";
                        checkedCmb(X, 2);
                        uraianTidakLengkap($(".infoPenandaan_bL"));
<?php } if (end($detail2) === "MK" || end($detail2) === "TMK") { ?>
                        var X = "eT";
                        checkedCmb(X, 2);
                        uraianTidakLengkap($(".infoPenandaan_eT"));
<?php } if (end($detail3) === "MK" || end($detail3) === "TMK") { ?>
                        var X = "v1";
                        checkedCmb(X, 2);
                        uraianTidakLengkap($(".infoPenandaan_v1"));
<?php } if (end($detail4) === "MK" || end($detail4) === "TMK") { ?>
                        var X = "v2";
                        checkedCmb(X, 2);
                        uraianTidakLengkap($(".infoPenandaan_v2"));
<?php } if (end($detail5) === "MK" || end($detail5) === "TMK") { ?>
                        var X = "bR";
                        checkedCmb(X, 2);
                        uraianTidakLengkap($(".infoPenandaan_bR"));
<?php } if (end($detail6) === "MK" || end($detail6) === "TMK") { ?>
                        var X = "aS";
                        checkedCmb(X, 2);
                        uraianTidakLengkap($(".infoPenandaan_aS"));
<?php } if (end($detail7) === "MK" || end($detail7) === "TMK") { ?>
                        var X = "sB";
                        checkedCmb(X, 2);
                        uraianTidakLengkap($(".infoPenandaan_sB"));
<?php } if (array_key_exists("PENANDAAN_ID", $sess)) { ?>
                        $(".infoObatTxt").attr("readonly", true);
                        $(".infoObatCmb").attr("disabled", true);
                        $(".infoObatCmbLine").show();
                        var klasifikasiPendaftar = $("#NIE").val().substring(3, 2);
                        if (klasifikasiPendaftar === "L") {
                          $("#klasifikasiPendaftar").val("Lokal")
                        }
                        else if (klasifikasiPendaftar === "I") {
                          $("#klasifikasiPendaftar").val("Lokal")
                        }
                        var klasifikasiObat = $("#NIE").val().substring(0, 1);
                        if (klasifikasiObat === "D") {
                          $("#klasifikasiObat").val("Obat Nama Dagang");
                        }
                        else if (klasifikasiObat === "G") {
                          $("#klasifikasiObat").val("Obat Generik");
                        }
                        showHide();
  <?php if (in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) { ?>
                          $(".verifikasiPusat").each(function() {
                            verifikasiPusat($(this), 0);
                          });
                          $(".verifikasiPusatSub").each(function() {
                            verifikasiTL($(this));
                          });
    <?php
  }
}
?>
//                      akhir load data
                      function showHide() {
                        var valz = "";
                        $(".jkyadp:checked").each(function() {
                          valz = $(this).val().split("_");
                          if (valz[1] == 'bR') {
                            var A = $("#bentukSediaan").val().split(" ");
                            if (A[0] + A[1] === "TETESMATA") {
                              $(".bentukSediaan2" + valz[1]).show();
                              $(".bentukSediaan1" + valz[1]).hide();
                              $(".bentukSediaan2" + valz[1]).attr("hidden", false);
                              $(".bentukSediaan1" + valz[1]).attr("hidden", true);
                            } else if (A[0] + A[1] === "SIRUPKERING" || A[0] + A[1] === "SERBUKINJEKSI") {
                              $(".bentukSediaan1" + valz[1]).show();
                              $(".bentukSediaan2" + valz[1]).show();
                              $(".bentukSediaan2" + valz[1]).attr("hidden", false);
                              $(".bentukSediaan1" + valz[1]).attr("hidden", false);
                            } else {
                              $(".bentukSediaan1" + valz[1]).hide();
                              $(".bentukSediaan2" + valz[1]).hide();
                              $(".bentukSediaan2" + valz[1]).attr("hidden", true);
                              $(".bentukSediaan1" + valz[1]).attr("hidden", true);
                            }
                            if (A[0] + A[1] === "SIRUPKERING" || A[0] + A[1] === "SERBUKINJEKSI" || A[0] + A[1] === "TETESMATA") {
                              $(".bentukSediaan3" + valz[1]).show();
                              $(".bentukSediaan3" + valz[1]).attr("hidden", false);
                            }
                            else {
                              $(".bentukSediaan3" + valz[1]).hide();
                              $(".bentukSediaan3" + valz[1]).attr("hidden", true);
                            }
                          }
                          if (valz != 'bR' && valz != 'v2') {
                            var klasifikasiObat = $("#klasifikasiObat").val();
                            if (klasifikasiObat === "Obat Nama Dagang") {
                              $(".logoGenerik" + valz[1]).hide();
                              $(".logoGenerik" + valz[1]).attr("hidden", true);
                            }
                            else if (klasifikasiObat === "Obat Generik") {
                              $(".logoGenerik" + valz[1]).show();
                              $(".logoGenerik" + valz[1]).attr("hidden", false);
                            }
                          }
                          var produsen = $("#produsen").val();
                          var lisensi = $("#pendaftar").val();
                          if (produsen !== lisensi) {
                            $(".lisensiBased" + valz[1]).show();
                            $(".lisensiBased" + valz[1]).attr("hidden", false);
                          }
                          if (produsen === lisensi) {
                            $(".lisensiBased" + valz[1]).hide();
                            $(".lisensiBased" + valz[1]).attr("hidden", true);
                          }
                          var golonganObat = $("#golonganObat").val();
                          if (golonganObat === "Keras" || golonganObat === "Narkotika" || golonganObat === "Psikotropika") {
//                                                        if (golonganObat === "Narkotika" || golonganObat === "Psikotropika") {
//                                                            $(".oKBT" + valz[1]).hide();
//                                                            $(".oKBT" + valz[1]).attr("hidden", true);
//                                                        }
                            $(".oKPN" + valz[1]).show();
                            $(".oT" + valz[1]).hide();
                            $(".bebasTerbatas" + valz[1]).hide();
                            $(".bebasTerbatas" + valz[1] + "2").attr("checked", false);
                            $(".bebasTerbatas" + valz[1] + "3").val("");
                            $(".oKPN" + valz[1]).attr("hidden", false);
                            $(".oT" + valz[1]).attr("hidden", true);
                            $(".bebasTerbatas" + valz[1]).attr("hidden", true);
                          }
                          else if (golonganObat === "Bebas") {
                            $(".oT" + valz[1]).hide();
                            $(".oKPN" + valz[1]).hide();
                            $(".bebasTerbatas" + valz[1]).hide();
                            $(".bebasTerbatas" + valz[1] + "2").attr("checked", false);
                            $(".bebasTerbatas" + valz[1] + "3").val("");
                            $(".oT" + valz[1]).attr("hidden", true);
                            $(".oKPN" + valz[1]).attr("hidden", true);
                            $(".bebasTerbatas" + valz[1]).attr("hidden", true);
                          }
                          else if (golonganObat === "Bebas Terbatas") {
                            $(".oKBT" + valz[1]).show();
                            $(".oKBT" + valz[1]).attr("hidden", false);
                            $(".oT" + valz[1]).show();
                            $(".oKPN" + valz[1]).hide();
                            $(".bebasTerbatas" + valz[1]).show();
                            $(".oKPN" + valz[1]).attr("hidden", false);
                            $(".oT" + valz[1]).attr("hidden", false);
                            $(".oKPN" + valz[1]).attr("hidden", true);
                            $(".bebasTerbatas" + valz[1]).attr("hidden", false);
                          }
                        });
                        if (valz != "")
                          uraianTidakLengkap($(".infoPenandaan_" + valz[1]));
                      }
                      function checkedCmb(X, x) {
                        if (x == 2)
                          $(".jkyadp[value='jkyadp_" + X + "']").attr("checked", "checked");
                        if ($(".jkyadp[value='jkyadp_" + X + "']").attr("checked") === true) {
                          $(".div_" + X).show();
                          showHide();
                          required($("#jkyadp_" + X), 1);
                        } else {
                          $(".div_" + X).hide();
                          required($("#jkyadp_" + X), 2);
                          clear(X);
                        }
                      }
                      $("input.namaObatJadi").autocomplete($("input.namaObatJadi").attr("url") + "1", {width: 244, selectFirst: false});
                      $("input.namaObatJadi").result(function(event, data, formatted) {
                        if (data) {
                          $("#namaObatJadi").val(data[1]);
                          $("#NIE").val(data[2]);
                          $("#bentukSediaan").val(data[9]);
                          $("#besarKemasan").val(data[4]);
                          $("#pendaftar").val(data[3]);
                          $("#produsen").val(data[6]);
                          $.get("<?php echo site_url() . "/autocompletes/autocomplete/get_komposisi/"; ?>" + data[14].replace(" ", "-") + "/" + data[15], function(hasil) {
                            $("#komposisi").val(hasil);
                          });
                          namaObatAuto(data[2]);
                          showHide();
                        }
                      });
                      $("#namaObatJadi").keyup(function() {
                        if ($("#namaObatJadi").val() === "") {
                          $("#namaObatJadi").val("");
                          $("#NIE").val("");
                          $("#bentukSediaan").val("");
                          $("#besarKemasan").val("");
                          $("#pendaftar").val("");
                          $("#produsen").val("");
                          $("#komposisi").val("");
                          $("#klasifikasiPendaftar").val("");
                          $("#golonganObat").val("");
                          $("#klasifikasiObat").val("");
                        }
                      });
                      $("#saranaid_").autocomplete($("#saranaid_").attr("url"), {width: 244, selectFirst: false});
                      $("#saranaid_").result(function(event, data, formatted) {
                        if (data) {
                          $(this).val(data[2]);
                          $("#saranaidval_").val(data[1]);
                          $("#alamatPengambilan").val(data[3]);
                          $("#saranaidval_").focus();
                        }
                      });
                      $("input.sdate").datepicker({dateFormat: "dd/mm/yy", regional: "id"});
                      $("#klasifikasi_id").change(function() {
                        if ($(this).val() === "001") {
                          $(".content2").fadeIn(3500);
                          $("html, body").animate({scrollTop: $(window).scrollTop() + 300});
                          $(".form_tabel_detail").focus();
                        } else {
                          $(this).attr("checked", false);
                        }
                      });
                      $(".jkyadp").click(function() {
                        if ($("#NIE").val() == "" | $("#namaObatJadi").val() == "") {
                          jAlert("Silahkan Lengkapi Isian Informasi Obat Terlebih Dahulu", "SIPT Versi 1.0");
                          $(this).attr("checked", false);
                          return false;
                        }
                        var i = 0;
                        $(".jkyadp").each(function() {
                          if ($(this).attr("checked"))
                            i++;
                          if (i > 0) {
                            $(".infoObatTxt").attr("readonly", true);
                            $(".infoObatCmb").attr("disabled", true);
                            $(".infoObatCmbLine").show();
                          }
                          else {
                            $(".infoObatTxt").attr("readonly", false);
                            $(".infoObatCmb").attr("disabled", false);
                            $(".infoObatCmbLine").hide();
                          }
                        });
                        var XX = $(this).val().split("_");
                        checkedCmb(XX[1], 1);
                      });
                      $(".infoPenandaan_aS").click(function() {
                        var name = $(this).attr("name"), selectedVal = "";
                        var selected = $("input[type='radio'][name='" + name + "']:checked").val();
                        $("input[type='text'][name='" + name + "']").val(selected);
                        borderLess($(this), 'aS');
                        if ($(this).attr("name") === "infoPenandaan_aS-36") {
                          if ($(this).is(":checked")) {
                            $("#infoPenandaan_aS_txt").fadeIn("slow");
                            $(".infoPenandaan_aS_txt").attr("rel", "required");
                          } else {
                            $("#infoPenandaan_aS_txt").fadeOut("slow");
                            $(".infoPenandaan_aS_txt").attr("rel", "");
                            $("#aS_37").val("");
                          }
                        }
                        mkTmk($(this));
                        verifikasiPusat("AS", 1);
                      });
                      $(".infoPenandaan_bL").click(function() {
                        var name = $(this).attr("name");
                        var selected = $("input[type='radio'][name='" + name + "']:checked").val();
                        $("input[type='text'][name='" + name + "']").val(selected);
                        borderLess($(this), 'bL');
                        if ($(this).attr("name") === "infoPenandaan_bL-36") {
                          if ($(this).is(":checked")) {
                            $("#infoPenandaan_bL_txt").fadeIn("slow");
                            $(".infoPenandaan_bL_txt").attr("rel", "required");
                          } else {
                            $("#infoPenandaan_bL_txt").fadeOut("slow");
                            $(".infoPenandaan_bL_txt").attr("rel", "");
                            $("#bL_37").val("");
                          }
                        }
                        mkTmk($(this));
                        verifikasiPusat("BL", 1);
                      });
                      $(".infoPenandaan_eT").click(function() {
                        var name = $(this).attr("name"), selectedVal = "";
                        var selected = $("input[type='radio'][name='" + name + "']:checked").val();
                        borderLess($(this), 'eT');
                        $("input[type='text'][name='" + name + "']").val(selected);
                        if ($(this).attr("name") === "infoPenandaan_eT-36") {
                          if ($(this).is(":checked")) {
                            $("#infoPenandaan_eT_txt").fadeIn("slow");
                            $(".infoPenandaan_eT_txt").attr("rel", "required");
                          } else {
                            $("#infoPenandaan_eT_txt").fadeOut("slow");
                            $(".infoPenandaan_eT_txt").attr("rel", "");
                            $("#eT_37").val("");
                          }
                        }
                        mkTmk($(this));
                        verifikasiPusat("ET", 1);
                      });
                      $(".infoPenandaan_sB").click(function() {
                        var name = $(this).attr("name"), selectedVal = "";
                        var selected = $("input[type='radio'][name='" + name + "']:checked").val();
                        borderLess($(this), 'sB');
                        $("input[type='text'][name='" + name + "']").val(selected);
                        if ($(this).attr("name") === "infoPenandaan_sB-36") {
                          if ($(this).is(":checked")) {
                            $("#infoPenandaan_sB_txt").fadeIn("slow");
                            $(".infoPenandaan_sB_txt").attr("rel", "required");
                          } else {
                            $("#infoPenandaan_sB_txt").fadeOut("slow");
                            $(".infoPenandaan_sB_txt").attr("rel", "");
                            $("#sB_37").val("");
                          }
                        }
                        mkTmk($(this));
                        verifikasiPusat("SB", 1);
                      });
                      $(".infoPenandaan_v1").click(function() {
                        var name = $(this).attr("name"), selectedVal = "";
                        var selected = $("input[type='radio'][name='" + name + "']:checked").val();
                        borderLess($(this), 'v1');
                        $("input[type='text'][name='" + name + "']").val(selected);
                        if ($(this).attr("name") === "infoPenandaan_v1-36") {
                          if ($(this).is(":checked")) {
                            $("#infoPenandaan_v1_txt").fadeIn("slow");
                            $(".infoPenandaan_v1_txt").attr("rel", "required");
                          } else {
                            $("#infoPenandaan_v1_txt").fadeOut("slow");
                            $(".infoPenandaan_v1_txt").attr("rel", "");
                            $("#v1_37").val("");
                          }
                        }
                        mkTmk($(this));
                        verifikasiPusat("V1", 1);
                      });
                      $(".infoPenandaan_v2").click(function() {
                        var name = $(this).attr("name"), selectedVal = "";
                        var selected = $("input[type='radio'][name='" + name + "']:checked").val();
                        borderLess($(this), 'v2');
                        $("input[type='text'][name='" + name + "']").val(selected);
                        if ($(this).attr("name") === "infoPenandaan_v2-36") {
                          if ($(this).is(":checked")) {
                            $("#infoPenandaan_v2_txt").fadeIn("slow");
                            $(".infoPenandaan_v2_txt").attr("rel", "required");
                          } else {
                            $("#infoPenandaan_v2_txt").fadeOut("slow");
                            $(".infoPenandaan_v2_txt").attr("rel", "");
                            $("#v2_37").val("");
                          }
                        }
                        mkTmk($(this));
                        verifikasiPusat("V2", 1);
                      });
                      $(".infoPenandaan_bR").click(function() {
                        var name = $(this).attr("name"), selectedVal = "";
                        var selected = $("input[type='radio'][name='" + name + "']:checked").val();
                        borderLess($(this), 'bR');
                        $("input[type='text'][name='" + name + "']").val(selected);
                        if ($(this).attr("name") === "infoPenandaan_bR-36") {
                          if ($(this).is(":checked")) {
                            $("#infoPenandaan_bR_txt").fadeIn("slow");
                            $(".infoPenandaan_bR_txt").attr("rel", "required");
                          } else {
                            $("#infoPenandaan_bR_txt").fadeOut("slow");
                            $(".infoPenandaan_bR_txt").attr("rel", "");
                            $("#bR_37").val("");
                          }
                        }
                        mkTmk($(this));
                        verifikasiPusat("BR", 1);
                      });
                      $(".cmbDetObat").change(function() {
                        showHide();
                      });
                      function splitVal(xxx) {
                        var XX = xxx.split("_");
                        if (XX !== "") {
                          if (XX[0] === "infoPenandaan") {
                            return XX[1];
                          } else {
                            return XX[0];
                          }
                        }
                      }
                      $("#detail_petugas").html("Loading ...");
                      $("#detail_petugas").load($("#detail_petugas").attr("url"));
                      $(".verifikasiPusat").change(function() {
                        clearRedact($(this), 0);
                        verifikasiPusat($(this), 0);
                      });
                      $(".verifikasiPusatSub").change(function() {
                        verifikasiTL($(this));
                      });
                      $(".del_upload").live("click", function() {
                        var jenis = $(this).attr("jns"), bks;
                        $.ajax({
                          type: "GET",
                          url: $(this).attr("url"),
                          data: $(this).serialize(),
                          success: function(data) {
                            var arrdata = data.split("#");
                            $(".upload_" + jenis + "").show();
                            $("#fileToUpload_" + jenis + "").val("");
                            $(".file_" + jenis + "").html("");
                            bks = jenis.split("_");
                            if (jenis !== "FILE_LAMPIRAN_IKLAN") {
                              if ($("#kesimpulanHasilPenilaian" + bks[2] + "Val").val() === "TMK") {
                                $("#fileToUpload_" + jenis).attr("rel", "required");
                                $("#fileToUpload_" + jenis).css("background-color", "#FFF");
                                $("#fileToUpload_" + jenis).css("border", "");
                              }
                              else {
                                $("#fileToUpload_" + jenis).attr("rel", "");
                                $("#fileToUpload_" + jenis).css("background-color", "#FFF");
                                $("#fileToUpload_" + jenis).css("border", "");
                              }
                            }
                          }
                        });
                        return false;
                      });
                      $(".infoObatTxt").click(function() {
                        if ($(this).attr("readonly"))
                          jAlert("Untuk mengubah isi, silahkan uncheck pilihan ' Jenis Penandaan Yang Akan Dinilai ' terlebih dahulu");
                      });
                      $(".infoObatCmbLine").click(function() {
                        if ($(this).prev().attr("disabled"))
                          jAlert("Untuk mengubah isi, silahkan uncheck pilihan ' Jenis Penandaan Yang Akan Dinilai ' terlebih dahulu");
                      });
                    });</script>