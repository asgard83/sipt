<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
?>
<link type="text/css" href="<?php echo base_url(); ?>css/iklanPenandaan.css" rel="stylesheet" media="screen"/>
<div id="judulpmnpdd" class="judul"></div>
<div class="headersarana">PENGAWASAN PENANDAAN - OBAT TRADISIONAL</div>
<?php
$detail = explode('#', $sess['PENILAIANBL']);
foreach ($detail as $k) {
    $d[] = explode('_', $k);
}
$detail2 = explode('#', $sess['PENILAIANKP']);
foreach ($detail2 as $k) {
    $d2[] = explode('_', $k);
}
$detailBL = explode('^', $sess['URAIANBL']);
$detailKP = explode('^', $sess['URAIANKP']);
$pemusnahan = explode('^', $sess['PEMUSNAHAN']);
$pemusnahan2 = explode('#', $pemusnahan[0]);
$sess['FILE_MUSNAH'] = $pemusnahan[2];
?>
<div class="content">
    <form action="<?php echo $act; ?>" method="post" autocomplete="off" id="fpengawasanPenandaan_010">
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
                                    if ($this->session->userdata('TANGGAL') != "-") {
                                        echo $this->session->userdata('TANGGAL');
                                    }
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
                <div class="acco2"><div class="expand"><a title="expand/collapse" href="#" style="display: block;">INFORMASI OBAT TRADISIONAL - PENANDAAN</a></div>
                    <div class="collapse">
                        <div class="accCntnt">
                            <table class="form_tabel">
                                <tr>
                                    <td class="td_left">Nama Produk <br /><br />Bentuk Sediaan</td><td class="td_right"><input type="text" class="stext namaOTJadi" id="namaOTJadi" url="<?php echo site_url(); ?>/autocompletes/autocomplete/produk_reg_2/" title="Nama Produk" rel="required" name="PENANDAANPRODUK[NAMA_PRODUK]" value="<?php echo $sess['NAMA_PRODUK'] ?>" /> <br /><br /><input type="text" class="stext" id="bentukSediaan" title="Bentuk Sediaan" name="PENANDAANPRODUK[BENTUK_SEDIAAN]" value="<?php echo $sess['BENTUK_SEDIAAN'] ?>"/></td>
                                    <td class="td_left">Komposisi</td><td class="td_right"><textarea class="stext" id="komposisi" title="Komposisi" name="PENANDAANPRODUK[KOMPOSISI]" rel="required" style="height: 40px;"><?php echo $sess['KOMPOSISI'] ?></textarea></td>
                                </tr>
                                <tr>
                                    <td class="td_left">Nomor Izin Edar</td><td class="td_right"><input type="text" class="stext" id="NIE" title="NIE" title="Nomor Izin Edar" name="PENANDAANPRODUK[NIE]" value="<?php echo $sess['NOMOR_IZIN_EDAR'] ?>" /></td>
                                    <td class="td_left">Kemasan</td><td class="td_right"><input type="text" class="stext" id="kemasan" title="Kemasan" name="PENANDAANPRODUK[BESAR_KEMASAN]" value="<?php echo $sess['BESAR_KEMASAN'] ?>"/></td>
                                </tr>
                                <tr>
                                    <td class="td_left">Importir</td><td class="td_right"><input type="text" class="stext" id="pendaftar" title="Nama Pendaftar" name="PENANDAANPRODUK[PENDAFTAR]" value="<?php echo $sess['PENDAFTAR'] ?>"/></td>
                                    <td class="td_left">Produsen</td><td class="td_right"><input type="text" class="stext" id="produsen" title="Nama Produsen" name="PENANDAANPRODUK[PRODUSEN]" value="<?php echo $sess['PRODUSEN'] ?>"/></td>
                                </tr>
                                <tr>
                                    <td class="td_left">Alamat Importir</td><td class="td_right"><textarea id="alamatPendaftar" class="stext" style="width: 240px; height: auto" title="Alamat Pendaftar" name="PENANDAANPRODUK[ALAMAT_PENDAFTAR]"><?php echo $sess['ALAMAT_PENDAFTAR'] ?></textarea></td>
                                    <td class="td_left">Alamat Produsen</td><td class="td_right"><textarea id="alamatProdusen" class="stext" style="width: 240px; height: auto" title="Alamat Produsen" name="PENANDAANPRODUK[ALAMAT_PRODUSEN]"><?php echo $sess['ALAMAT_PRODUSEN'] ?></textarea></td>
                                </tr>
                                <tr></tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div style="height:5px;"></div>

                <div class="expand" id="expand1"><a title="expand/collapse" href="#" style="display: block;">FORM PENILAIAN PENANDAAN</a></div>
                <div class="collapse">
                    <div class="accCntnt">
                        <div id="tabs">
                            <div>
                                <table>
                                    <tr>
                                        <td>Jenis Penandaan Yang Akan Di Nilai : </td>
                                        <td><input type="checkbox" value="jkyadp_bL" class="jkyadp" id="jkyadp_bL" param="BL" style="margin-left: 10px" <?php if (trim($sess['PENILAIANBL']) != "" && trim($detail[0]) != "") echo 'checked'; ?>/>&nbsp;<b>Bungkus Luar</b></td>
                                        <td><input type="checkbox" value="jkyadp_kP" class="jkyadp" id="jkyadp_kP" param="KP" style="margin-left: 15px" <?php if (trim($sess['PENILAIANKP']) != "" && trim($detail2[0]) != "") echo 'checked'; ?> />&nbsp;<b>Kemasan Primer</b></td>
                                    </tr>
                                </table>
                            </div>
                            <br />
                            <ul>
                                <?php if (trim($sess['PENILAIANBL']) != "" && trim($detail[0]) != "") { ?>
                                    <li class="div_bL"><a href="#tabs-1">Bungkus Luar</a></li>
                                <?php } else { ?>
                                    <li class="div_bL" style="display: none;"><a href="#tabs-1">Bungkus Luar</a></li>
                                <?php } if (trim($sess['PENILAIANKP']) != "" && trim($detail2[0]) != "") { ?>
                                    <li class="div_kP"><a href="#tabs-2">Kemasan Primer</a></li>
                                <?php } else { ?>
                                    <li class="div_kP"style="display: none;"><a href="#tabs-2">Kemasan Primer</a></li>
                                <?php } ?>
                            </ul>

                            <!--Bungkus Luar-->
                            <?php if (trim($sess['PENILAIANBL']) != "" && trim($detail[0]) != "") { ?>
                                <div id="tabs-1" class="div_bL">
                                <?php } else { ?>
                                    <div id="tabs-1" class="div_bL" style="display: none">
                                    <?php } ?>
                                    <table class="form_tabel" class="div_bL" style="width: 100%;">
                                        <tr>
                                            <td style="width: 30%;"></td>
                                            <td style="width: 70%;" class="td_left">
                                                <input type="radio" name="penandaan[1][Nasal_dekongestan]">
                                                <label style="width: 70px; height: 10px;" title="Ada / Sesuai">Ada / Sesuai</label>
                                                <span style="margin-left: 5px;"></span>
                                                <input  type="radio" name="penandaan[1][Nasal_dekongestan]">
                                                <label for="radioA3" style="width: 70px; height: 10px; background-color: #f1f600" title="Tidak Sesuai">Tidak Sesuai</label>
                                                <span style="margin-left: 5px;"></span>
                                                <input  type="radio" name="penandaan[1][Nasal_dekongestan]" >
                                                <label style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak Ada">Tidak Ada</label>
                                            </td>
                                        </tr>
                                        <tr class="infoPenandaanOT_bLRow">
                                            <!--<td class="td_left_checklist">1</td>-->
                                            <td class="td_left_header_checklist" style="vertical-align: top">No Bets </td>
                                            <td class="td_left">
                                                <input class="uraianPenandaan_bL" param="BetsBL" type="radio" id="radioA1_BL" name="CHKBL[1]" value="+_No Bets" <?php if ($d[0][0] == '+') echo 'checked'; ?>>
                                                <label for="radioA1_BL" style="width: 70px; height: 10px;" title="Ada / Sesuai"></label>
                                                <span style="margin-left: 5px;"></span>
                                                <input class="uraianPenandaan_bL" param="BetsBL" type="radio" id="radioA3_BL" name="CHKBL[1]" value="X_No Bets" <?php if ($d[0][0] == 'X') echo 'checked'; ?>>
                                                <label for="radioA3_BL" style="width: 70px; height: 10px; background-color: #f1f600" title="Tidak Sesuai"></label>
                                                <span style="margin-left: 5px;"></span>
                                                <input class="uraianPenandaan_bL" param="BetsBL" type="radio" id="radioA2_BL" name="CHKBL[1]" value="-_No Bets" <?php if ($d[0][0] == '-') echo 'checked'; ?>>
                                                <label for="radioA2_BL" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak Ada"></label>
                                                <input type="text" name="CHKBL[1]"  value="<?php echo $detail[0]; ?>" style="display: none;" class="uPenandaan_bL">
                                            </td>
                                        </tr>
                                        <tr id="BetsBL" class="txt_bL" hidden>
                                            <td></td>
                                            <td>&nbsp;<input type="text" name="URNBL[1]" class="uPenandaan_bL" title="Uraian Penandaan" size="45" id="CHKBL[1]" value="<?php echo $detailBL[0]; ?>" /></td>
                                        </tr>
                                        <tr class="infoPenandaanOT_bLRow">
                                            <td class="td_left_header_checklist" style="vertical-align: top">Kemasan Isi / Bobot </td>
                                            <td class="td_left">
                                                <input class="uraianPenandaan_bL" param="NettoBL" type="radio" id="radioB1_BL" name="CHKBL[2]" value="+_Kemasan Isi / Bobot / Netto" <?php if ($d[1][0] == '+') echo 'checked'; ?>>
                                                <label for="radioB1_BL" style="width: 70px; height: 10px;" title="Ada / Sesuai"></label>
                                                <span style="margin-left: 5px;"></span>
                                                <input class="uraianPenandaan_bL" param="NettoBL" type="radio" id="radioB3_BL" name="CHKBL[2]" value="X_Kemasan Isi / Bobot / Netto">
                                                <label for="radioB3_BL" style="width: 70px; height: 10px; background-color: #f1f600" title="Tidak Sesuai" <?php if ($d[1][0] == 'X') echo 'checked'; ?>></label>
                                                <span style="margin-left: 5px;"></span>
                                                <input class="uraianPenandaan_bL" param="NettoBL" type="radio" id="radioB2_BL" name="CHKBL[2]" value="-_Kemasan Isi / Bobot / Netto" <?php if ($d[1][0] == '-') echo 'checked'; ?> class="uPenandaan_bL">
                                                <label for="radioB2_BL" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak Ada"></label>
                                                <input type="text" name="CHKBL[2]"  value="<?php echo $detail[1]; ?>" style="display: none;" class="uPenandaan_bL">
                                            </td>
                                        </tr>
                                        <tr id="NettoBL" class="txt_bL" hidden>
                                            <td></td>
                                            <td>&nbsp;<input type="text" name="URNBL[2]" class="uPenandaan_bL" title="Uraian Penandaan" size="45" id="CHKBL[2]" value="<?php echo $detailBL[1]; ?>" class="uPenandaan_bL" /></td>
                                        </tr>
                                        <tr class="infoPenandaanOT_bLRow">
                                            <td class="td_left_header_checklist" style="vertical-align: top">NIE </td>
                                            <td class="td_left">
                                                <input class="uraianPenandaan_bL" param="NieBL" type="radio" id="radioC1_BL" name="CHKBL[3]" value="+_Nie" <?php if ($d[2][0] == '+') echo 'checked'; ?>>
                                                <label for="radioC1_BL" style="width: 70px; height: 10px;" title="Ada / Sesuai"></label>
                                                <span style="margin-left: 5px;"></span>
                                                <input class="uraianPenandaan_bL" param="NieBL" type="radio" id="radioC3_BL" name="CHKBL[3]" value="X_Nie" <?php if ($d[2][0] == 'X') echo 'checked'; ?>>
                                                <label for="radioC3_BL" style="width: 70px; height: 10px; background-color: #f1f600" title="Tidak Sesuai"></label>
                                                <span style="margin-left: 5px;"></span>
                                                <input class="uraianPenandaan_bL" param="NieBL" type="radio" id="radioC2_BL" name="CHKBL[3]" value="-_Nie" <?php if ($d[2][0] == '-') echo 'checked'; ?>>
                                                <label for="radioC2_BL" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak Ada"></label>
                                                <input type="text" name="CHKBL[3]"  value="<?php echo $detail[2]; ?>" style="display: none;" class="uPenandaan_bL">
                                            </td>
                                        </tr>
                                        <tr id="NieBL" class="txt_bL" hidden>
                                            <td></td>
                                            <td>&nbsp;<input type="text" name="URNBL[3]" class="uPenandaan_bL" title="Uraian Penandaan" size="45" id="CHKBL[3]" value="<?php echo $detailBL[2]; ?>" /></td>
                                        </tr>
                                        <tr><td colspan="3" style="background-color: white;"></td></tr>
                                        <tr>
                                            <td class="td_left_header_checklist" style="vertical-align: top; background-color: white; border-bottom: 1px solid #000"> <b>Nama dan Alamat:</b> </td>
                                        </tr>
                                        <tr></tr>
                                        <tr></tr>
                                        <tr class="infoPenandaanOT_bLRow">
                                            <td class="td_left_header_checklist" style="vertical-align: top;">Produsen </td>
                                            <td class="td_left">
                                                <input class="uraianPenandaan_bL" param="ProdusenBL" type="radio" id="radioD1_BL" name="CHKBL[4]" value="+_Produsen" <?php if ($d[3][0] == '+') echo 'checked'; ?>>
                                                <label for="radioD1_BL" style="width: 70px; height: 10px;" title="Ada / Sesuai"></label>
                                                <span style="margin-left: 5px;"></span>
                                                <input class="uraianPenandaan_bL" param="ProdusenBL" type="radio" id="radioD3_BL" name="CHKBL[4]" value="X_Produsen" <?php if ($d[3][0] == 'X') echo 'checked'; ?>>
                                                <label for="radioD3_BL" style="width: 70px; height: 10px; background-color: #f1f600" title="Tidak Sesuai"></label>
                                                <span style="margin-left: 5px;"></span>
                                                <input class="uraianPenandaan_bL" param="ProdusenBL" type="radio" id="radioD2_BL" name="CHKBL[4]" value="-_Produsen" <?php if ($d[3][0] == '-') echo 'checked'; ?>>
                                                <label for="radioD2_BL" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak Ada"></label>
                                                <input type="text" name="CHKBL[4]"  value="<?php echo $detail[3]; ?>" style="display: none;" class="uPenandaan_bL">
                                            </td>
                                        </tr>
                                        <tr id="ProdusenBL" class="txt_bL" hidden>
                                            <td></td>
                                            <td>&nbsp;<textarea class="uPenandaan_bL" title="Uraian Penandaan" style="width: 35%; height: 45px;" name="URNBL[4]" id="CHKBL[4]"><?php echo $detailBL[3]; ?></textarea></td>
                                        </tr>
                                        <tr class="BahasaImporbL infoPenandaanOT_bLRow" hidden>
                                            <td class="td_left_header_checklist" style="vertical-align: top;">Importir </td>
                                            <td class="td_left">
                                                <input class="uraianPenandaan_bL" param="ImportirBL" type="radio" id="radioE1_BL" name="CHKBL[5]" value="+_Importir" <?php if ($d[4][0] == '+') echo 'checked'; ?>>
                                                <label for="radioE1_BL" style="width: 70px; height: 10px;" title="Ada / Sesuai"></label>
                                                <span style="margin-left: 5px;"></span>
                                                <input class="uraianPenandaan_bL" param="ImportirBL" type="radio" id="radioE3_BL" name="CHKBL[5]" value="X_Importir" <?php if ($d[4][0] == 'X') echo 'checked'; ?>>
                                                <label for="radioE3_BL" style="width: 70px; height: 10px; background-color: #f1f600" title="Tidak Sesuai"></label>
                                                <span style="margin-left: 5px;"></span>
                                                <input class="uraianPenandaan_bL" param="ImportirBL" type="radio" id="radioE2_BL" name="CHKBL[5]" value="-_Importir" <?php if ($d[4][0] == '-') echo 'checked'; ?>>
                                                <label for="radioE2_BL" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak Ada"></label>
                                                <input type="text" name="CHKBL[5]"  value="<?php echo $detail[4]; ?>" style="display: none;" class="uPenandaan_bL BahasaImporbLVal">
                                            </td>
                                        </tr>
                                        <tr id="ImportirBL" class="txt_bL" hidden>
                                            <td></td>
                                            <td>&nbsp;<textarea class="uPenandaan_bL" title="Uraian Penandaan" style="width: 35%; height: 45px;" name="URNBL[5]" id="CHKBL[5]"><?php echo $detailBL[4]; ?></textarea></td>
                                        </tr>
                                        <tr class="infoPenandaanOT_bLRow">
                                            <td class="td_left_header_checklist" style="vertical-align: top;">Distributor </td>
                                            <td class="td_left">
                                                <input class="uraianPenandaan_bL" param="DistributorBL" type="radio" id="radioF1_BL" name="CHKBL[6]" value="+_Distributor" <?php if ($d[5][0] == '+') echo 'checked'; ?>>
                                                <label for="radioF1_BL" style="width: 70px; height: 10px;" title="Ada / Sesuai"></label>
                                                <span style="margin-left: 5px;"></span>
                                                <input class="uraianPenandaan_bL" param="DistributorBL" type="radio" id="radioF3_BL" name="CHKBL[6]" value="X_Distributor" <?php if ($d[5][0] == 'X') echo 'checked'; ?>>
                                                <label for="radioF3_BL" style="width: 70px; height: 10px; background-color: #f1f600" title="Tidak Sesuai"></label>
                                                <span style="margin-left: 5px;"></span>
                                                <input class="uraianPenandaan_bL" param="DistributorBL" type="radio" id="radioF2_BL" name="CHKBL[6]" value="-_Distributor" <?php if ($d[5][0] == '-') echo 'checked'; ?>>
                                                <label for="radioF2_BL" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak Ada"></label>
                                                <input type="text" name="CHKBL[6]"  value="<?php echo $detail[5]; ?>" style="display: none;" class="uPenandaan_bL">
                                            </td>
                                        </tr>
                                        <tr id="DistributorBL" class="txt_bL" hidden>
                                            <td></td>
                                            <td>&nbsp;<textarea class="uPenandaan_bL" title="Uraian Penandaan" style="width: 35%; height: 45px;" name="URNBL[6]" id="CHKBL[6]"><?php echo $detailBL[5]; ?></textarea></td>
                                        </tr>
                                        <tr class="infoPenandaanOT_bLRow">
                                            <td class="td_left_header_checklist" style="vertical-align: top;">Pemberi Lisensi </td>
                                            <td class="td_left">
                                                <input class="uraianPenandaan_bL" param="PemberiLisensiBL" type="radio" id="radioG1_BL" name="CHKBL[7]" value="+_Pemberi Lisensi" <?php if ($d[6][0] == '+') echo 'checked'; ?>>
                                                <label for="radioG1_BL" style="width: 70px; height: 10px;" title="Ada / Sesuai"></label>
                                                <span style="margin-left: 5px;"></span>
                                                <input class="uraianPenandaan_bL" param="PemberiLisensiBL" type="radio" id="radioG3_BL" name="CHKBL[7]" value="X_Pemberi Lisensi" <?php if ($d[6][0] == 'X') echo 'checked'; ?>>
                                                <label for="radioG3_BL" style="width: 70px; height: 10px; background-color: #f1f600" title="Tidak Sesuai"></label>
                                                <span style="margin-left: 5px;"></span>
                                                <input class="uraianPenandaan_bL" param="PemberiLisensiBL" type="radio" id="radioG2_BL" name="CHKBL[7]" value="-_Pemberi Lisensi" <?php if ($d[6][0] == '-') echo 'checked'; ?>>
                                                <label for="radioG2_BL" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak Ada"></label>
                                                <input type="text" name="CHKBL[7]"  value="<?php echo $detail[6]; ?>" style="display: none;" class="uPenandaan_bL">
                                            </td>
                                        </tr>
                                        <tr id="PemberiLisensiBL" class="txt_bL" hidden>
                                            <td></td>
                                            <td>&nbsp;<textarea class="uPenandaan_bL" title="Uraian Penandaan" style="width: 35%; height: 45px;" name="URNBL[7]" id="CHKBL[7]"><?php echo $detailBL[6]; ?></textarea></td>
                                        </tr>
                                        <tr><td style="vertical-align: top; background-color: white; border-bottom: 1px solid #000"></td></tr>
                                        <tr><td style="background-color: white;">&nbsp;</td></tr>
                                        <tr class="infoPenandaanOT_bLRow">
                                            <td class="td_left_header_checklist" style="vertical-align: top;">Expire Date </td>
                                            <td class="td_left">
                                                <input class="uraianPenandaan_bL" param="ExpDateBL" type="radio" id="radioH1_BL" name="CHKBL[8]" value="+_Exp Date" <?php if ($d[7][0] == '+') echo 'checked'; ?>>
                                                <label for="radioH1_BL" style="width: 70px; height: 10px;" title="Ada / Sesuai"></label>
                                                <span style="margin-left: 5px;"></span>
                                                <input class="uraianPenandaan_bL" param="ExpDateBL" type="radio" id="radioH3_BL" name="CHKBL[8]" value="X_Exp Date" <?php if ($d[7][0] == 'X') echo 'checked'; ?>>
                                                <label for="radioH3_BL" style="width: 70px; height: 10px; background-color: #f1f600" title="Tidak Sesuai"></label>
                                                <span style="margin-left: 5px;"></span>
                                                <input class="uraianPenandaan_bL" param="ExpDateBL" type="radio" id="radioH2_BL" name="CHKBL[8]" value="-_Exp Date" <?php if ($d[7][0] == '-') echo 'checked'; ?>>
                                                <label for="radioH2_BL" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak Ada"></label>
                                                <input type="text" name="CHKBL[8]"  value="<?php echo $detail[7]; ?>" style="display: none;" class="uPenandaan_bL">
                                            </td>
                                        </tr>
                                        <tr id="ExpDateBL" class="txt_bL" hidden>
                                            <td></td>
                                            <td><input type="text" class="sdate uPenandaan_bL" name="URNBL[8]"  title="Tanggal Expire" id="CHKBL[8]" value="<?php echo $detailBL[7]; ?>"/></td>
                                        </tr>
                                        <tr class="infoPenandaanOT_bLRow">
                                            <td class="td_left_header_checklist" style="vertical-align: top;">Komposisi </td>
                                            <td class="td_left">
                                                <input class="uraianPenandaan_bL" param="KomposisiBL" type="radio" id="radioI1_BL" name="CHKBL[9]" value="+_Komposisi" <?php if ($d[8][0] == '+') echo 'checked'; ?>>
                                                <label for="radioI1_BL" style="width: 70px; height: 10px;" title="Ada / Sesuai"></label>
                                                <span style="margin-left: 5px;"></span>
                                                <input class="uraianPenandaan_bL" param="KomposisiBL" type="radio" id="radioI3_BL" name="CHKBL[9]" value="X_Komposisi" <?php if ($d[8][0] == 'X') echo 'checked'; ?>>
                                                <label for="radioI3_BL" style="width: 70px; height: 10px; background-color: #f1f600" title="Tidak Sesuai"></label>
                                                <span style="margin-left: 5px;"></span>
                                                <input class="uraianPenandaan_bL" param="KomposisiBL" type="radio" id="radioI2_BL" name="CHKBL[9]" value="-_Komposisi" <?php if ($d[8][0] == '-') echo 'checked'; ?>>
                                                <label for="radioI2_BL" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak Ada"></label>
                                                <input type="text" name="CHKBL[9]"  value="<?php echo $detail[8]; ?>" style="display: none;" class="uPenandaan_bL">
                                            </td>
                                        </tr>
                                        <tr id="KomposisiBL" class="txt_bL" hidden>
                                            <td></td>
                                            <td>&nbsp;<textarea class="uPenandaan_bL" title="Uraian Penandaan" style="width: 35%; height: 45px;" name="URNBL[9]" id="CHKBL[9]"><?php echo $detailBL[8]; ?></textarea></td>
                                        </tr>
                                        <tr class="infoPenandaanOT_bLRow">
                                            <td class="td_left_header_checklist" style="vertical-align: top;">Cara Penggunaan </td>
                                            <td class="td_left">
                                                <input class="uraianPenandaan_bL" param="CaraPenggunaanBL" type="radio" id="radioJ1_BL" name="CHKBL[10]" value="+_Cara Penggunaan" <?php if ($d[9][0] == '+') echo 'checked'; ?>>
                                                <label for="radioJ1_BL" style="width: 70px; height: 10px;" title="Ada / Sesuai"></label>
                                                <span style="margin-left: 5px;"></span>
                                                <input class="uraianPenandaan_bL" param="CaraPenggunaanBL" type="radio" id="radioJ3_BL" name="CHKBL[10]" value="X_Cara Penggunaan" <?php if ($d[9][0] == 'X') echo 'checked'; ?>>
                                                <label for="radioJ3_BL" style="width: 70px; height: 10px; background-color: #f1f600" title="Tidak Sesuai"></label>
                                                <span style="margin-left: 5px;"></span>
                                                <input class="uraianPenandaan_bL" param="CaraPenggunaanBL" type="radio" id="radioJ2_BL" name="CHKBL[10]" value="-_Cara Penggunaan" <?php if ($d[9][0] == '-') echo 'checked'; ?>>
                                                <label for="radioJ2_BL" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak Ada"></label>
                                                <input type="text" name="CHKBL[10]"  value="<?php echo $detail[9]; ?>" style="display: none;" class="uPenandaan_bL">
                                            </td>
                                        </tr>
                                        <tr id="CaraPenggunaanBL" class="txt_bL" hidden>
                                            <td></td>
                                            <td>&nbsp;<textarea class="uPenandaan_bL" title="Uraian Penandaan" style="width: 35%; height: 45px;" name="URNBL[10]" id="CHKBL[10]"><?php echo $detailBL[9]; ?></textarea></td>
                                        </tr>
                                        <tr class="infoPenandaanOT_bLRow">
                                            <td class="td_left_header_checklist" style="vertical-align: top;">Cara Penyimpanan </td>
                                            <td class="td_left">
                                                <input class="uraianPenandaan_bL" param="CaraPenyimpananBL" type="radio" id="radioJ111_BL" name="CHKBL[11]" value="+_Cara Penyimpanan" <?php if ($d[10][0] == '+') echo 'checked'; ?>>
                                                <label for="radioJ111_BL" style="width: 70px; height: 10px;" title="Ada / Sesuai"></label>
                                                <span style="margin-left: 5px;"></span>
                                                <input class="uraianPenandaan_bL" param="CaraPenyimpananBL" type="radio" id="radioJ113_BL" name="CHKBL[11]" value="X_Cara Penyimpanan" <?php if ($d[10][0] == 'X') echo 'checked'; ?>>
                                                <label for="radioJ113_BL" style="width: 70px; height: 10px; background-color: #f1f600" title="Tidak Sesuai"></label>
                                                <span style="margin-left: 5px;"></span>
                                                <input class="uraianPenandaan_bL" param="CaraPenyimpananBL" type="radio" id="radioJ112_BL" name="CHKBL[11]" value="-_Cara Penyimpanan" <?php if ($d[10][0] == '-') echo 'checked'; ?>>
                                                <label for="radioJ112_BL" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak Ada"></label>
                                                <input type="text" name="CHKBL[11]"  value="<?php echo $detail[10]; ?>" style="display: none;" class="uPenandaan_bL">
                                            </td>
                                        </tr>
                                        <tr id="CaraPenyimpananBL" class="txt_bL" hidden>
                                            <td></td>
                                            <td>&nbsp;<textarea class="uPenandaan_bL" title="Uraian Penandaan" style="width: 35%; height: 45px;" name="URNBL[11]" id="CHKBL[11]"><?php echo $detailBL[10]; ?></textarea></td>
                                        </tr>
                                        <tr class="infoPenandaanOT_bLRow">
                                            <td class="td_left_header_checklist" style="vertical-align: top;">Klaim </td>
                                            <td class="td_left">
                                                <input class="uraianPenandaan_bL" param="KlaimBL" type="radio" id="radioK1_BL" name="CHKBL[12]" value="+_Klaim" <?php if ($d[11][0] == '+') echo 'checked'; ?>>
                                                <label for="radioK1_BL" style="width: 70px; height: 10px;" title="Ada / Sesuai"></label>
                                                <span style="margin-left: 5px;"></span>
                                                <input class="uraianPenandaan_bL" param="KlaimBL" type="radio" id="radioK3_BL" name="CHKBL[12]" value="X_Klaim" <?php if ($d[11][0] == 'X') echo 'checked'; ?>>
                                                <label for="radioK3_BL" style="width: 70px; height: 10px; background-color: #f1f600" title="Tidak Sesuai"></label>
                                                <span style="margin-left: 5px;"></span>
                                                <input class="uraianPenandaan_bL" param="KlaimBL" type="radio" id="radioK2_BL" name="CHKBL[12]" value="-_Klaim" <?php if ($d[11][0] == '-') echo 'checked'; ?>>
                                                <label for="radioK2_BL" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak Ada"></label>
                                                <input type="text" name="CHKBL[12]"  value="<?php echo $detail[11]; ?>" style="display: none;" class="uPenandaan_bL">
                                            </td>
                                        </tr>
                                        <tr id="KlaimBL" class="txt_bL" hidden>
                                            <td></td>
                                            <td>&nbsp;<textarea class="uPenandaan_bL" title="Uraian Penandaan" style="width: 35%; height: 45px;" name="URNBL[12]" id="CHKBL[12]"><?php echo $detailBL[11]; ?></textarea></td>
                                        </tr>
                                        <tr class="infoPenandaanOT_bLRow">
                                            <td class="td_left_header_checklist" style="vertical-align: top;">Peringatan Dan Perhatian </td>
                                            <td class="td_left">
                                                <input class="uraianPenandaan_bL"param="PeringatanBL" type="radio" id="radioL1_BL" name="CHKBL[13]" value="+_Peringatan dan Perhatian" <?php if ($d[12][0] == '+') echo 'checked'; ?>>
                                                <label for="radioL1_BL" style="width: 70px; height: 10px;" title="Ada / Sesuai"></label>
                                                <span style="margin-left: 5px;"></span>
                                                <input class="uraianPenandaan_bL" param="PeringatanBL" type="radio" id="radioL3_BL" name="CHKBL[13]" value="X_Peringatan dan Perhatian" <?php if ($d[12][0] == 'X') echo 'checked'; ?>>
                                                <label for="radioL3_BL" style="width: 70px; height: 10px; background-color: #f1f600" title="Tidak Sesuai"></label>
                                                <span style="margin-left: 5px;"></span>
                                                <input class="uraianPenandaan_bL" param="PeringatanBL" type="radio" id="radioL2_BL" name="CHKBL[13]" value="-_Peringatan dan Perhatian" <?php if ($d[12][0] == '-') echo 'checked'; ?>>
                                                <label for="radioL2_BL" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak Ada"></label>
                                                <input type="text" name="CHKBL[13]"  value="<?php echo $detail[12]; ?>" style="display: none;" class="uPenandaan_bL">
                                            </td>
                                        </tr>
                                        <tr id="PeringatanBL" class="txt_bL" hidden>
                                            <td></td>
                                            <td>&nbsp;<textarea class="uPenandaan_bL" title="Uraian Penandaan" style="width: 35%; height: 45px;" name="URNBL[13]" id="CHKBL[13]"><?php echo $detailBL[12]; ?></textarea></td>
                                        </tr>
                                        <tr class="infoPenandaanOT_bLRow">
                                            <td class="td_left_header_checklist" style="vertical-align: top;">Bentuk Sediaan </td>
                                            <td class="td_left">
                                                <input class="uraianPenandaan_bL" param="BentukSediaanBL" type="radio" id="radioM1_BL" name="CHKBL[14]" value="+_Bentuk Sediaan" <?php if ($d[13][0] == '+') echo 'checked'; ?>>
                                                <label for="radioM1_BL" style="width: 70px; height: 10px;" title="Ada / Sesuai"></label>
                                                <span style="margin-left: 5px;"></span>
                                                <input class="uraianPenandaan_bL" param="BentukSediaanBL" type="radio" id="radioM3_BL" name="CHKBL[14]" value="X_Bentuk Sediaan" <?php if ($d[13][0] == 'X') echo 'checked'; ?>>
                                                <label for="radioM3_BL" style="width: 70px; height: 10px; background-color: #f1f600" title="Tidak Sesuai"></label>
                                                <span style="margin-left: 5px;"></span>
                                                <input class="uraianPenandaan_bL" param="BentukSediaanBL" type="radio" id="radioM2_BL" name="CHKBL[14]" value="-_Bentuk Sediaan" <?php if ($d[13][0] == '-') echo 'checked'; ?>>
                                                <label for="radioM2_BL" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak Ada"></label>
                                                <input type="text" name="CHKBL[14]"  value="<?php echo $detail[13]; ?>" style="display: none;" class="uPenandaan_bL">
                                            </td>
                                        </tr>
                                        <tr id="BentukSediaanBL" class="txt_bL" hidden>
                                            <td></td>
                                            <td>&nbsp;<textarea class="uPenandaan_bL" title="Uraian Penandaan" style="width: 35%; height: 45px;" name="URNBL[14]" id="CHKBL[14]"><?php echo $detailBL[13]; ?></textarea></td>
                                        </tr>
                                        <tr class="BahasaImporbL infoPenandaanOT_bLRow" hidden>
                                            <td class="td_left_header_checklist" style="vertical-align: top;">Bahasa Indonesia </td>
                                            <td class="td_left">
                                                <input class="uraianPenandaan_bL" param="BahasaBL" type="radio" id="radioN1_BL" name="CHKBL[15]" value="+_Bahasa Indonesia" <?php if ($d[14][0] == '+') echo 'checked'; ?>>
                                                <label for="radioN1_BL" style="width: 70px; height: 10px;" title="Ada / Sesuai"></label>
                                                <span style="margin-left: 5px;"></span>
                                                <input class="uraianPenandaan_bL" param="BahasaBL" type="radio" id="radioN3_BL" name="CHKBL[15]" value="X_Bahasa Indonesia" <?php if ($d[14][0] == 'X') echo 'checked'; ?>>
                                                <label for="radioN3_BL" style="width: 70px; height: 10px; background-color: #f1f600" title="Tidak Sesuai"></label>
                                                <span style="margin-left: 5px;"></span>
                                                <input class="uraianPenandaan_bL" param="BahasaBL" type="radio" id="radioN2_BL" name="CHKBL[15]" value="-_Bahasa Indonesia" <?php if ($d[14][0] == '-') echo 'checked'; ?>>
                                                <label for="radioN2_BL" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak Ada"></label>
                                                <input type="text" name="CHKBL[15]" value="<?php echo $detail[14]; ?>" style="display: none;" class="uPenandaan_bL BahasaImporbLVal">
                                            </td>
                                        </tr>
                                        <tr id="BahasaBL" class="txt_bL" hidden>
                                            <td></td>
                                            <td>&nbsp;<textarea class="uPenandaan_bL" title="Uraian Penandaan" style="width: 35%; height: 45px;" name="URNBL[15]" id="CHKBL[15]"><?php echo $detailBL[14]; ?></textarea></td>
                                        </tr>
                                        <tr class="infoPenandaanOT_bLRow">
                                            <td class="td_left_header_checklist" style="vertical-align: top;">Tercetak Langsung </td>
                                            <td class="td_left">
                                                <input class="uraianPenandaan_bL" param="TercetakBL" type="radio" id="radioP1_BL" name="CHKBL[18]" value="+_Tercetak Langsung" <?php if ($d[17][0] == '+') echo 'checked'; ?>>
                                                <label for="radioP1_BL" style="width: 70px; height: 10px;" title="Ada / Sesuai"></label>
                                                <span style="margin-left: 5px;"></span>
                                                <input class="uraianPenandaan_bL" param="TercetakBL" type="radio" id="radioP3_BL" name="CHKBL[18]" value="X_Tercetak Langsung" <?php if ($d[17][0] == 'X') echo 'checked'; ?>>
                                                <label for="radioP3_BL" style="width: 70px; height: 10px; background-color: #f1f600" title="Tidak Sesuai"></label>
                                                <span style="margin-left: 5px;"></span>
                                                <input class="uraianPenandaan_bL" param="TercetakBL" type="radio" id="radioP2_BL" name="CHKBL[18]" value="-_Tercetak Langsung" <?php if ($d[17][0] == '-') echo 'checked'; ?>>
                                                <label for="radioP2_BL" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak Ada"></label>
                                                <input type="text" name="CHKBL[18]"  value="<?php echo $detail[17]; ?>" style="display: none;" class="uPenandaan_bL">
                                            </td>
                                        </tr>
                                        <tr id="TercetakBL" class="txt_bL" hidden>
                                            <td></td>
                                            <td>&nbsp;<textarea class="uPenandaan_bL" title="Uraian Penandaan" style="width: 35%; height: 45px;" name="URNBL[18]" id="CHKBL[18]"><?php echo $detailBL[17]; ?></textarea></td>
                                        </tr>
                                        <tr class="infoPenandaanOT_bLRow">
                                            <td class="td_left_header_checklist" style="vertical-align: top;">Kemasan </td>
                                            <td class="td_left">
                                                <input class="uraianPenandaan_bL" param="KemasanBL" type="radio" id="radioO1_BL" name="CHKBL[16]" value="+_Kemasan" <?php if ($d[15][0] == '+') echo 'checked'; ?>>
                                                <label for="radioO1_BL" style="width: 70px; height: 10px;" title="Ada / Sesuai"></label>
                                                <span style="margin-left: 5px;"></span>
                                                <input class="uraianPenandaan_bL" param="KemasanBL" type="radio" id="radioO3_BL" name="CHKBL[16]" value="X_Kemasan" <?php if ($d[15][0] == 'X') echo 'checked'; ?>>
                                                <label for="radioO3_BL" style="width: 70px; height: 10px; background-color: #f1f600" title="Tidak Sesuai"></label>
                                                <span style="margin-left: 5px;"></span>
                                                <input class="uraianPenandaan_bL" param="KemasanBL" type="radio" id="radioO2_BL" name="CHKBL[16]" value="-_Kemasan" <?php if ($d[15][0] == '-') echo 'checked'; ?>>
                                                <label for="radioO2_BL" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak Ada"></label>
                                                <input type="text" name="CHKBL[16]"  value="<?php echo $detail[15]; ?>" style="display: none;" class="uPenandaan_bL">
                                            </td>
                                        </tr>
                                        <tr id="KemasanBL" class="txt_bL" hidden>
                                            <td></td>
                                            <td>&nbsp;<textarea class="uPenandaan_bL" title="Uraian Penandaan" style="width: 35%; height: 45px;" name="URNBL[16]" id="CHKBL[16]"><?php echo $detailBL[15]; ?></textarea></td>
                                        </tr>
                                        <tr><td colspan="3" style="background-color: white">&nbsp;</td></tr>
                                        <tr><td style="border-bottom: 1px solid #000;"></td></tr>
                                        <tr>
                                            <td class="td_left_header_checklist" style="vertical-align: top">Narasi gambar pada penandaan </td>
                                            <td class="td_left">
                                                <input hidden name="CHKBL[17]" value="">
                                                <textarea class="uPenandaan_bL" title="Narasi pada gambar penandaan" style="width: 35%; height: 100px;" name="URNBL[17]"><?php echo $detailBL[16]; ?></textarea>
                                            </td>
                                        </tr>
                                        <td style="border-bottom: 1px solid #000;"></td>
                                        <tr></tr>
                                    </table>
                                </div>

                                <!--Kemasan Primer-->
                                <?php if (trim($sess['PENILAIANBL']) != "" && trim($detail2[0]) != "") { ?>
                                    <div id="tabs-2" class="div_kP">
                                    <?php } else { ?>
                                        <div id="tabs-2" class="div_kP" style="display: none">
                                        <?php } ?>
                                        <table class="form_tabel" class="div_kP" style="width: 100%;">
                                            <tr>
                                                <td style="width: 30%;"></td>
                                                <td style="width: 70%;" class="td_left">
                                                    <input type="radio" name="penandaan[1][Nasal_dekongestan]">
                                                    <label style="width: 70px; height: 10px;" title="Ada / Sesuai">Ada / Sesuai</label>
                                                    <span style="margin-left: 5px;"></span>
                                                    <input  type="radio" name="penandaan[1][Nasal_dekongestan]">
                                                    <label for="radioA3" style="width: 70px; height: 10px; background-color: #f1f600" title="Tidak Sesuai">Tidak Sesuai</label>
                                                    <span style="margin-left: 5px;"></span>
                                                    <input  type="radio" name="penandaan[1][Nasal_dekongestan]" >
                                                    <label style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak Ada">Tidak Ada</label>
                                                </td>
                                            </tr>
                                            <tr class="infoPenandaanOT_kPRow">
                                                <!--<td class="td_left_checklist">1</td>-->
                                                <td class="td_left_header_checklist" style="vertical-align: top">No Bets </td>
                                                <td class="td_left">
                                                    <input class="uraianPenandaan_kP" param="BetsKP" type="radio" id="radioA1_KP" name="CHKKP[1]" value="+_No Bets" <?php if ($d2[0][0] == '+') echo 'checked'; ?>>
                                                    <label for="radioA1_KP" style="width: 70px; height: 10px;" title="Ada / Sesuai"></label>
                                                    <span style="margin-left: 5px;"></span>
                                                    <input class="uraianPenandaan_kP" param="BetsKP" type="radio" id="radioA3_KP" name="CHKKP[1]" value="X_No Bets" <?php if ($d2[0][0] == 'X') echo 'checked'; ?>>
                                                    <label for="radioA3_KP" style="width: 70px; height: 10px; background-color: #f1f600" title="Tidak Sesuai"></label>
                                                    <span style="margin-left: 5px;"></span>
                                                    <input class="uraianPenandaan_kP" param="BetsKP" type="radio" id="radioA2_KP" name="CHKKP[1]" value="-_No Bets" <?php if ($d2[0][0] == '-') echo 'checked'; ?>>
                                                    <label for="radioA2_KP" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak Ada"></label>
                                                    <input type="text" name="CHKKP[1]"  value="<?php echo $detail2[0]; ?>" style="display: none;" class="uPenandaan_kP">
                                                </td>
                                            </tr>
                                            <tr id="BetsKP" class="txt_kP" hidden>
                                                <td></td>
                                                <td>&nbsp;<input type="text" name="URNKP[1]" class="uPenandaan_kP" title="Uraian Penandaan" size="45" id="CHKKP[1]" value="<?php echo $detailKP[0]; ?>" /></td>
                                            </tr>
                                            <tr class="infoPenandaanOT_kPRow">
                                                <td class="td_left_header_checklist" style="vertical-align: top">Kemasan Isi / Bobot </td>
                                                <td class="td_left">
                                                    <input class="uraianPenandaan_kP" param="NettoKP" type="radio" id="radioB1_KP" name="CHKKP[2]" value="+_Kemasan Isi / Bobot / Netto" <?php if ($d2[1][0] == '+') echo 'checked'; ?>>
                                                    <label for="radioB1_KP" style="width: 70px; height: 10px;" title="Ada / Sesuai"></label>
                                                    <span style="margin-left: 5px;"></span>
                                                    <input class="uraianPenandaan_kP" param="NettoKP" type="radio" id="radioB3_KP" name="CHKKP[2]" value="X_Kemasan Isi / Bobot / Netto">
                                                    <label for="radioB3_KP" style="width: 70px; height: 10px; background-color: #f1f600" title="Tidak Sesuai" <?php if ($d2[1][0] == 'X') echo 'checked'; ?>></label>
                                                    <span style="margin-left: 5px;"></span>
                                                    <input class="uraianPenandaan_kP" param="NettoKP" type="radio" id="radioB2_KP" name="CHKKP[2]" value="-_Kemasan Isi / Bobot / Netto" <?php if ($d2[1][0] == '-') echo 'checked'; ?>>
                                                    <label for="radioB2_KP" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak Ada"></label>
                                                    <input type="text" name="CHKKP[2]"  value="<?php echo $detail2[1]; ?>" style="display: none;" class="uPenandaan_kP">
                                                </td>
                                            </tr>
                                            <tr id="NettoKP" class="txt_kP" hidden>
                                                <td></td>
                                                <td>&nbsp;<input type="text" name="URNKP[2]" class="uPenandaan_kP" title="Uraian Penandaan" size="45" id="CHKKP[2]" value="<?php echo $detailKP[1]; ?>" /></td>
                                            </tr>
                                            <tr class="infoPenandaanOT_kPRow">
                                                <td class="td_left_header_checklist" style="vertical-align: top">NIE </td>
                                                <td class="td_left">
                                                    <input class="uraianPenandaan_kP" param="NieKP" type="radio" id="radioC1_KP" name="CHKKP[3]" value="+_Nie" <?php if ($d2[2][0] == '+') echo 'checked'; ?>>
                                                    <label for="radioC1_KP" style="width: 70px; height: 10px;" title="Ada / Sesuai"></label>
                                                    <span style="margin-left: 5px;"></span>
                                                    <input class="uraianPenandaan_kP" param="NieKP" type="radio" id="radioC3_KP" name="CHKKP[3]" value="X_Nie" <?php if ($d2[2][0] == 'X') echo 'checked'; ?>>
                                                    <label for="radioC3_KP" style="width: 70px; height: 10px; background-color: #f1f600" title="Tidak Sesuai"></label>
                                                    <span style="margin-left: 5px;"></span>
                                                    <input class="uraianPenandaan_kP" param="NieKP" type="radio" id="radioC2_KP" name="CHKKP[3]" value="-_Nie" <?php if ($d2[2][0] == '-') echo 'checked'; ?>>
                                                    <label for="radioC2_KP" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak Ada"></label>
                                                    <input type="text" name="CHKKP[3]"  value="<?php echo $detail2[2]; ?>" style="display: none;" class="uPenandaan_kP">
                                                </td>
                                            </tr>
                                            <tr id="NieKP" class="txt_kP" hidden>
                                                <td></td>
                                                <td>&nbsp;<input type="text" name="URNKP[3]" class="uPenandaan_kP" title="Uraian Penandaan" size="45" id="CHKKP[3]" value="<?php echo $detailKP[2]; ?>" /></td>
                                            </tr>
                                            <tr><td colspan="3" style="background-color: white;"></td></tr>
                                            <tr>
                                                <td class="td_left_header_checklist" style="vertical-align: top; background-color: white; border-bottom: 1px solid #000"> <b>Nama dan Alamat:</b> </td>
                                            </tr>
                                            <tr></tr>
                                            <tr></tr>
                                            <tr class="infoPenandaanOT_kPRow">
                                                <td class="td_left_header_checklist" style="vertical-align: top;">Produsen </td>
                                                <td class="td_left">
                                                    <input class="uraianPenandaan_kP" param="ProdusenKP" type="radio" id="radioD1_KP" name="CHKKP[4]" value="+_Produsen" <?php if ($d2[3][0] == '+') echo 'checked'; ?>>
                                                    <label for="radioD1_KP" style="width: 70px; height: 10px;" title="Ada / Sesuai"></label>
                                                    <span style="margin-left: 5px;"></span>
                                                    <input class="uraianPenandaan_kP" param="ProdusenKP" type="radio" id="radioD3_KP" name="CHKKP[4]" value="X_Produsen" <?php if ($d2[3][0] == 'X') echo 'checked'; ?>>
                                                    <label for="radioD3_KP" style="width: 70px; height: 10px; background-color: #f1f600" title="Tidak Sesuai"></label>
                                                    <span style="margin-left: 5px;"></span>
                                                    <input class="uraianPenandaan_kP" param="ProdusenKP" type="radio" id="radioD2_KP" name="CHKKP[4]" value="-_Produsen" <?php if ($d2[3][0] == '-') echo 'checked'; ?>>
                                                    <label for="radioD2_KP" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak Ada"></label>
                                                    <input type="text" name="CHKKP[4]"  value="<?php echo $detail2[3]; ?>" style="display: none;" class="uPenandaan_kP">
                                                </td>
                                            </tr>
                                            <tr id="ProdusenKP" class="txt_kP" hidden>
                                                <td></td>
                                                <td>&nbsp;<textarea class="uPenandaan_kP" title="Uraian Penandaan" style="width: 35%; height: 45px;" name="URNKP[4]" id="CHKKP[4]"><?php echo $detailKP[3]; ?></textarea></td>
                                            </tr>
                                            <tr class="BahasaImporkP infoPenandaanOT_kPRow" hidden>
                                                <td class="td_left_header_checklist" style="vertical-align: top;">Importir </td>
                                                <td class="td_left">
                                                    <input class="uraianPenandaan_kP" param="ImportirKP" type="radio" id="radioE1_KP" name="CHKKP[5]" value="+_Importir" <?php if ($d2[4][0] == '+') echo 'checked'; ?>>
                                                    <label for="radioE1_KP" style="width: 70px; height: 10px;" title="Ada / Sesuai"></label>
                                                    <span style="margin-left: 5px;"></span>
                                                    <input class="uraianPenandaan_kP" param="ImportirKP" type="radio" id="radioE3_KP" name="CHKKP[5]" value="X_Importir" <?php if ($d2[4][0] == 'X') echo 'checked'; ?>>
                                                    <label for="radioE3_KP" style="width: 70px; height: 10px; background-color: #f1f600" title="Tidak Sesuai"></label>
                                                    <span style="margin-left: 5px;"></span>
                                                    <input class="uraianPenandaan_kP" param="ImportirKP" type="radio" id="radioE2_KP" name="CHKKP[5]" value="-_Importir" <?php if ($d2[4][0] == '-') echo 'checked'; ?>>
                                                    <label for="radioE2_KP" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak Ada"></label>
                                                    <input type="text" name="CHKKP[5]"  value="<?php echo $detail2[4]; ?>" style="display: none;" class="uPenandaan_kP BahasaImporkPVal">
                                                </td>
                                            </tr>
                                            <tr id="ImportirKP" class="txt_kP" hidden>
                                                <td></td>
                                                <td>&nbsp;<textarea class="uPenandaan_kP" title="Uraian Penandaan" style="width: 35%; height: 45px;" name="URNKP[5]" id="CHKKP[5]"><?php echo $detailKP[4]; ?></textarea></td>
                                            </tr>
                                            <tr class="infoPenandaanOT_kPRow">
                                                <td class="td_left_header_checklist" style="vertical-align: top;">Distributor </td>
                                                <td class="td_left">
                                                    <input class="uraianPenandaan_kP" param="DistributorKP" type="radio" id="radioF1_KP" name="CHKKP[6]" value="+_Distributor" <?php if ($d2[5][0] == '+') echo 'checked'; ?>>
                                                    <label for="radioF1_KP" style="width: 70px; height: 10px;" title="Ada / Sesuai"></label>
                                                    <span style="margin-left: 5px;"></span>
                                                    <input class="uraianPenandaan_kP" param="DistributorKP" type="radio" id="radioF3_KP" name="CHKKP[6]" value="X_Distributor" <?php if ($d2[5][0] == 'X') echo 'checked'; ?>>
                                                    <label for="radioF3_KP" style="width: 70px; height: 10px; background-color: #f1f600" title="Tidak Sesuai"></label>
                                                    <span style="margin-left: 5px;"></span>
                                                    <input class="uraianPenandaan_kP" param="DistributorKP" type="radio" id="radioF2_KP" name="CHKKP[6]" value="-_Distributor" <?php if ($d2[5][0] == '-') echo 'checked'; ?>>
                                                    <label for="radioF2_KP" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak Ada"></label>
                                                    <input type="text" name="CHKKP[6]"  value="<?php echo $detail2[5]; ?>" style="display: none;" class="uPenandaan_kP">
                                                </td>
                                            </tr>
                                            <tr id="DistributorKP" class="txt_kP" hidden>
                                                <td></td>
                                                <td>&nbsp;<textarea class="uPenandaan_kP" title="Uraian Penandaan" style="width: 35%; height: 45px;" name="URNKP[6]" id="CHKKP[6]"><?php echo $detailKP[5]; ?></textarea></td>
                                            </tr>
                                            <tr class="infoPenandaanOT_kPRow">
                                                <td class="td_left_header_checklist" style="vertical-align: top;">Pemberi Lisensi </td>
                                                <td class="td_left">
                                                    <input class="uraianPenandaan_kP" param="PemberiLisensiKP" type="radio" id="radioG1_KP" name="CHKKP[7]" value="+_Pemberi Lisensi" <?php if ($d2[6][0] == '+') echo 'checked'; ?>>
                                                    <label for="radioG1_KP" style="width: 70px; height: 10px;" title="Ada / Sesuai"></label>
                                                    <span style="margin-left: 5px;"></span>
                                                    <input class="uraianPenandaan_kP" param="PemberiLisensiKP" type="radio" id="radioG3_KP" name="CHKKP[7]" value="X_Pemberi Lisensi" <?php if ($d2[6][0] == 'X') echo 'checked'; ?>>
                                                    <label for="radioG3_KP" style="width: 70px; height: 10px; background-color: #f1f600" title="Tidak Sesuai"></label>
                                                    <span style="margin-left: 5px;"></span>
                                                    <input class="uraianPenandaan_kP" param="PemberiLisensiKP" type="radio" id="radioG2_KP" name="CHKKP[7]" value="-_Pemberi Lisensi" <?php if ($d2[6][0] == '-') echo 'checked'; ?>>
                                                    <label for="radioG2_KP" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak Ada"></label>
                                                    <input type="text" name="CHKKP[7]"  value="<?php echo $detail2[6]; ?>" style="display: none;" class="uPenandaan_kP">
                                                </td>
                                            </tr>
                                            <tr id="PemberiLisensiKP" class="txt_kP" hidden>
                                                <td></td>
                                                <td>&nbsp;<textarea class="uPenandaan_kP" title="Uraian Penandaan" style="width: 35%; height: 45px;" name="URNKP[7]" id="CHKKP[7]"><?php echo $detailKP[6]; ?></textarea></td>
                                            </tr>
                                            <tr><td style="vertical-align: top; background-color: white; border-bottom: 1px solid #000"></td></tr>
                                            <tr><td style="background-color: white;">&nbsp;</td></tr>
                                            <tr class="infoPenandaanOT_kPRow">
                                                <td class="td_left_header_checklist" style="vertical-align: top;">Expire Date </td>
                                                <td class="td_left">
                                                    <input class="uraianPenandaan_kP" param="ExpDateKP" type="radio" id="radioH1_KP" name="CHKKP[8]" value="+_Exp Date" <?php if ($d2[7][0] == '+') echo 'checked'; ?>>
                                                    <label for="radioH1_KP" style="width: 70px; height: 10px;" title="Ada / Sesuai"></label>
                                                    <span style="margin-left: 5px;"></span>
                                                    <input class="uraianPenandaan_kP" param="ExpDateKP" type="radio" id="radioH3_KP" name="CHKKP[8]" value="X_Exp Date" <?php if ($d2[7][0] == 'X') echo 'checked'; ?>>
                                                    <label for="radioH3_KP" style="width: 70px; height: 10px; background-color: #f1f600" title="Tidak Sesuai"></label>
                                                    <span style="margin-left: 5px;"></span>
                                                    <input class="uraianPenandaan_kP" param="ExpDateKP" type="radio" id="radioH2_KP" name="CHKKP[8]" value="-_Exp Date" <?php if ($d2[7][0] == '-') echo 'checked'; ?>>
                                                    <label for="radioH2_KP" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak Ada"></label>
                                                    <input type="text" name="CHKKP[8]"  value="<?php echo $detail2[7]; ?>" style="display: none;" class="uPenandaan_kP">
                                                </td>
                                            </tr>
                                            <tr id="ExpDateKP" class="txt_kP" hidden>
                                                <td></td>
                                                <td><input type="text" class="sdate uPenandaan_kP" name="URNKP[8]"  title="Tanggal Expire" id="CHKKP[8]" value="<?php echo $detailKP[7]; ?>"/></td>
                                            </tr>
                                            <tr class="infoPenandaanOT_kPRow">
                                                <td class="td_left_header_checklist" style="vertical-align: top;">Komposisi </td>
                                                <td class="td_left">
                                                    <input class="uraianPenandaan_kP" param="KomposisiKP" type="radio" id="radioI1_KP" name="CHKKP[9]" value="+_Komposisi" <?php if ($d2[8][0] == '+') echo 'checked'; ?>>
                                                    <label for="radioI1_KP" style="width: 70px; height: 10px;" title="Ada / Sesuai"></label>
                                                    <span style="margin-left: 5px;"></span>
                                                    <input class="uraianPenandaan_kP" param="KomposisiKP" type="radio" id="radioI3_KP" name="CHKKP[9]" value="X_Komposisi" <?php if ($d2[8][0] == 'X') echo 'checked'; ?>>
                                                    <label for="radioI3_KP" style="width: 70px; height: 10px; background-color: #f1f600" title="Tidak Sesuai"></label>
                                                    <span style="margin-left: 5px;"></span>
                                                    <input class="uraianPenandaan_kP" param="KomposisiKP" type="radio" id="radioI2_KP" name="CHKKP[9]" value="-_Komposisi" <?php if ($d2[8][0] == '-') echo 'checked'; ?>>
                                                    <label for="radioI2_KP" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak Ada"></label>
                                                    <input type="text" name="CHKKP[9]"  value="<?php echo $detail2[8]; ?>" style="display: none;" class="uPenandaan_kP">
                                                </td>
                                            </tr>
                                            <tr id="KomposisiKP" class="txt_kP" hidden>
                                                <td></td>
                                                <td>&nbsp;<textarea class="uPenandaan_kP" title="Uraian Penandaan" style="width: 35%; height: 45px;" name="URNKP[9]" id="CHKKP[9]"><?php echo $detailKP[8]; ?></textarea></td>
                                            </tr>
                                            <tr class="infoPenandaanOT_kPRow">
                                                <td class="td_left_header_checklist" style="vertical-align: top;">Cara Penggunaan </td>
                                                <td class="td_left">
                                                    <input class="uraianPenandaan_kP" param="CaraPenggunaanKP" type="radio" id="radioJ1_KP" name="CHKKP[10]" value="+_Cara Penggunaan" <?php if ($d2[9][0] == '+') echo 'checked'; ?>>
                                                    <label for="radioJ1_KP" style="width: 70px; height: 10px;" title="Ada / Sesuai"></label>
                                                    <span style="margin-left: 5px;"></span>
                                                    <input class="uraianPenandaan_kP" param="CaraPenggunaanKP" type="radio" id="radioJ3_KP" name="CHKKP[10]" value="X_Cara Penggunaan" <?php if ($d2[9][0] == 'X') echo 'checked'; ?>>
                                                    <label for="radioJ3_KP" style="width: 70px; height: 10px; background-color: #f1f600" title="Tidak Sesuai"></label>
                                                    <span style="margin-left: 5px;"></span>
                                                    <input class="uraianPenandaan_kP" param="CaraPenggunaanKP" type="radio" id="radioJ2_KP" name="CHKKP[10]" value="-_Cara Penggunaan" <?php if ($d2[9][0] == '-') echo 'checked'; ?>>
                                                    <label for="radioJ2_KP" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak Ada"></label>
                                                    <input type="text" name="CHKKP[10]"  value="<?php echo $detail2[9]; ?>" style="display: none;" class="uPenandaan_kP">
                                                </td>
                                            </tr>
                                            <tr id="CaraPenggunaanKP" class="txt_kP" hidden>
                                                <td></td>
                                                <td>&nbsp;<textarea class="uPenandaan_kP" title="Uraian Penandaan" style="width: 35%; height: 45px;" name="URNKP[10]" id="CHKKP[10]"><?php echo $detailKP[9]; ?></textarea></td>
                                            </tr>
                                            <tr class="infoPenandaanOT_kPRow">
                                                <td class="td_left_header_checklist" style="vertical-align: top;">Cara Penyimpanan </td>
                                                <td class="td_left">
                                                    <input class="uraianPenandaan_kP" param="CaraPenyimpananKP" type="radio" id="radioJ111_KP" name="CHKKP[11]" value="+_Cara Penyimpanan" <?php if ($d2[10][0] == '+') echo 'checked'; ?>>
                                                    <label for="radioJ111_KP" style="width: 70px; height: 10px;" title="Ada / Sesuai"></label>
                                                    <span style="margin-left: 5px;"></span>
                                                    <input class="uraianPenandaan_kP" param="CaraPenyimpananKP" type="radio" id="radioJ113_KP" name="CHKKP[11]" value="X_Cara Penyimpanan" <?php if ($d2[10][0] == 'X') echo 'checked'; ?>>
                                                    <label for="radioJ113_KP" style="width: 70px; height: 10px; background-color: #f1f600" title="Tidak Sesuai"></label>
                                                    <span style="margin-left: 5px;"></span>
                                                    <input class="uraianPenandaan_kP" param="CaraPenyimpananKP" type="radio" id="radioJ112_KP" name="CHKKP[11]" value="-_Cara Penyimpanan" <?php if ($d2[10][0] == '-') echo 'checked'; ?>>
                                                    <label for="radioJ112_KP" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak Ada"></label>
                                                    <input type="text" name="CHKKP[11]"  value="<?php echo $detail2[10]; ?>" style="display: none;" class="uPenandaan_kP">
                                                </td>
                                            </tr>
                                            <tr id="CaraPenyimpananKP" class="txt_kP" hidden>
                                                <td></td>
                                                <td>&nbsp;<textarea class="uPenandaan_kP" title="Uraian Penandaan" style="width: 35%; height: 45px;" name="URNKP[11]" id="CHKKP[11]"><?php echo $detailKP[10]; ?></textarea></td>
                                            </tr>
                                            <tr class="infoPenandaanOT_kPRow">
                                                <td class="td_left_header_checklist" style="vertical-align: top;">Klaim </td>
                                                <td class="td_left">
                                                    <input class="uraianPenandaan_kP" param="KlaimKP" type="radio" id="radioK1_KP" name="CHKKP[12]" value="+_Klaim" <?php if ($d2[11][0] == '+') echo 'checked'; ?>>
                                                    <label for="radioK1_KP" style="width: 70px; height: 10px;" title="Ada / Sesuai"></label>
                                                    <span style="margin-left: 5px;"></span>
                                                    <input class="uraianPenandaan_kP" param="KlaimKP" type="radio" id="radioK3_KP" name="CHKKP[12]" value="X_Klaim" <?php if ($d2[11][0] == 'X') echo 'checked'; ?>>
                                                    <label for="radioK3_KP" style="width: 70px; height: 10px; background-color: #f1f600" title="Tidak Sesuai"></label>
                                                    <span style="margin-left: 5px;"></span>
                                                    <input class="uraianPenandaan_kP" param="KlaimKP" type="radio" id="radioK2_KP" name="CHKKP[12]" value="-_Klaim" <?php if ($d2[11][0] == '-') echo 'checked'; ?>>
                                                    <label for="radioK2_KP" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak Ada"></label>
                                                    <input type="text" name="CHKKP[12]"  value="<?php echo $detail2[11]; ?>" style="display: none;" class="uPenandaan_kP">
                                                </td>
                                            </tr>
                                            <tr id="KlaimKP" class="txt_kP" hidden>
                                                <td></td>
                                                <td>&nbsp;<textarea class="uPenandaan_kP" title="Uraian Penandaan" style="width: 35%; height: 45px;" name="URNKP[12]" id="CHKKP[12]"><?php echo $detailKP[11]; ?></textarea></td>
                                            </tr>
                                            <tr class="infoPenandaanOT_kPRow">
                                                <td class="td_left_header_checklist" style="vertical-align: top;">Peringatan Dan Perhatian </td>
                                                <td class="td_left">
                                                    <input class="uraianPenandaan_kP"param="PeringatanKP" type="radio" id="radioL1_KP" name="CHKKP[13]" value="+_Peringatan dan Perhatian" <?php if ($d2[12][0] == '+') echo 'checked'; ?>>
                                                    <label for="radioL1_KP" style="width: 70px; height: 10px;" title="Ada / Sesuai"></label>
                                                    <span style="margin-left: 5px;"></span>
                                                    <input class="uraianPenandaan_kP" param="PeringatanKP" type="radio" id="radioL3_KP" name="CHKKP[13]" value="X_Peringatan dan Perhatian" <?php if ($d2[12][0] == 'X') echo 'checked'; ?>>
                                                    <label for="radioL3_KP" style="width: 70px; height: 10px; background-color: #f1f600" title="Tidak Sesuai"></label>
                                                    <span style="margin-left: 5px;"></span>
                                                    <input class="uraianPenandaan_kP" param="PeringatanKP" type="radio" id="radioL2_KP" name="CHKKP[13]" value="-_Peringatan dan Perhatian" <?php if ($d2[12][0] == '-') echo 'checked'; ?>>
                                                    <label for="radioL2_KP" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak Ada"></label>
                                                    <input type="text" name="CHKKP[13]"  value="<?php echo $detail2[12]; ?>" style="display: none;" class="uPenandaan_kP">
                                                </td>
                                            </tr>
                                            <tr id="PeringatanKP" class="txt_kP" hidden>
                                                <td></td>
                                                <td>&nbsp;<textarea class="uPenandaan_kP" title="Uraian Penandaan" style="width: 35%; height: 45px;" name="URNKP[13]" id="CHKKP[13]"><?php echo $detailKP[12]; ?></textarea></td>
                                            </tr>
                                            <tr class="infoPenandaanOT_kPRow">
                                                <td class="td_left_header_checklist" style="vertical-align: top;">Bentuk Sediaan </td>
                                                <td class="td_left">
                                                    <input class="uraianPenandaan_kP" param="BentukSediaanKP" type="radio" id="radioM1_KP" name="CHKKP[14]" value="+_Bentuk Sediaan" <?php if ($d2[13][0] == '+') echo 'checked'; ?>>
                                                    <label for="radioM1_KP" style="width: 70px; height: 10px;" title="Ada / Sesuai"></label>
                                                    <span style="margin-left: 5px;"></span>
                                                    <input class="uraianPenandaan_kP" param="BentukSediaanKP" type="radio" id="radioM3_KP" name="CHKKP[14]" value="X_Bentuk Sediaan" <?php if ($d2[13][0] == 'X') echo 'checked'; ?>>
                                                    <label for="radioM3_KP" style="width: 70px; height: 10px; background-color: #f1f600" title="Tidak Sesuai"></label>
                                                    <span style="margin-left: 5px;"></span>
                                                    <input class="uraianPenandaan_kP" param="BentukSediaanKP" type="radio" id="radioM2_KP" name="CHKKP[14]" value="-_Bentuk Sediaan" <?php if ($d2[13][0] == '-') echo 'checked'; ?>>
                                                    <label for="radioM2_KP" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak Ada"></label>
                                                    <input type="text" name="CHKKP[14]"  value="<?php echo $detail2[13]; ?>" style="display: none;" class="uPenandaan_kP">
                                                </td>
                                            </tr>
                                            <tr id="BentukSediaanKP" class="txt_kP" hidden>
                                                <td></td>
                                                <td>&nbsp;<textarea class="uPenandaan_kP" title="Uraian Penandaan" style="width: 35%; height: 45px;" name="URNKP[14]" id="CHKKP[14]"><?php echo $detailKP[13]; ?></textarea></td>
                                            </tr>
                                            <tr class="BahasaImporkP infoPenandaanOT_kPRow" hidden>
                                                <td class="td_left_header_checklist" style="vertical-align: top;">Bahasa Indonesia </td>
                                                <td class="td_left">
                                                    <input class="uraianPenandaan_kP" param="BahasaKP" type="radio" id="radioN1_KP" name="CHKKP[15]" value="+_Bahasa Indonesia" <?php if ($d2[14][0] == '+') echo 'checked'; ?>>
                                                    <label for="radioN1_KP" style="width: 70px; height: 10px;" title="Ada / Sesuai"></label>
                                                    <span style="margin-left: 5px;"></span>
                                                    <input class="uraianPenandaan_kP" param="BahasaKP" type="radio" id="radioN3_KP" name="CHKKP[15]" value="X_Bahasa Indonesia" <?php if ($d2[14][0] == 'X') echo 'checked'; ?>>
                                                    <label for="radioN3_KP" style="width: 70px; height: 10px; background-color: #f1f600" title="Tidak Sesuai"></label>
                                                    <span style="margin-left: 5px;"></span>
                                                    <input class="uraianPenandaan_kP" param="BahasaKP" type="radio" id="radioN2_KP" name="CHKKP[15]" value="-_Bahasa Indonesia" <?php if ($d2[14][0] == '-') echo 'checked'; ?>>
                                                    <label for="radioN2_KP" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak Ada"></label>
                                                    <input type="text" name="CHKKP[15]" value="<?php echo $detail2[14]; ?>" style="display: none;" class="uPenandaan_kP BahasaImporkPVal">
                                                </td>
                                            </tr>
                                            <tr id="BahasaKP" class="txt_kP" hidden>
                                                <td></td>
                                                <td>&nbsp;<textarea class="uPenandaan_kP" title="Uraian Penandaan" style="width: 35%; height: 45px;" name="URNKP[15]" id="CHKKP[15]"><?php echo $detailKP[14]; ?></textarea></td>
                                            </tr>
                                            <tr class="infoPenandaanOT_kPRow">
                                                <td class="td_left_header_checklist" style="vertical-align: top;">Tercetak Langsung </td>
                                                <td class="td_left">
                                                    <input class="uraianPenandaan_kP" param="TercetakKP" type="radio" id="radioP1_KP" name="CHKKP[18]" value="+_Tercetak Langsung" <?php if ($d2[17][0] == '+') echo 'checked'; ?>>
                                                    <label for="radioP1_KP" style="width: 70px; height: 10px;" title="Ada / Sesuai"></label>
                                                    <span style="margin-left: 5px;"></span>
                                                    <input class="uraianPenandaan_kP" param="TercetakKP" type="radio" id="radioP3_KP" name="CHKKP[18]" value="X_Tercetak Langsung" <?php if ($d2[17][0] == 'X') echo 'checked'; ?>>
                                                    <label for="radioP3_KP" style="width: 70px; height: 10px; background-color: #f1f600" title="Tidak Sesuai"></label>
                                                    <span style="margin-left: 5px;"></span>
                                                    <input class="uraianPenandaan_kP" param="TercetakKP" type="radio" id="radioP2_KP" name="CHKKP[18]" value="-_Tercetak Langsung" <?php if ($d2[17][0] == '-') echo 'checked'; ?>>
                                                    <label for="radioP2_KP" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak Ada"></label>
                                                    <input type="text" name="CHKKP[18]"  value="<?php echo $detail2[17]; ?>" style="display: none;" class="uPenandaan_kP">
                                                </td>
                                            </tr>
                                            <tr id="TercetakKP" class="txt_kP" hidden>
                                                <td></td>
                                                <td>&nbsp;<textarea class="uPenandaan_kP" title="Uraian Penandaan" style="width: 35%; height: 45px;" name="URNKP[18]" id="CHKKP[18]"><?php echo $detailKP[17]; ?></textarea></td>
                                            </tr>
                                            <tr class="infoPenandaanOT_kPRow">
                                                <td class="td_left_header_checklist" style="vertical-align: top;">Kemasan </td>
                                                <td class="td_left">
                                                    <input class="uraianPenandaan_kP" param="KemasanKP" type="radio" id="radioO1_KP" name="CHKKP[16]" value="+_Kemasan" <?php if ($d2[15][0] == '+') echo 'checked'; ?>>
                                                    <label for="radioO1_KP" style="width: 70px; height: 10px;" title="Ada / Sesuai"></label>
                                                    <span style="margin-left: 5px;"></span>
                                                    <input class="uraianPenandaan_kP" param="KemasanKP" type="radio" id="radioO3_KP" name="CHKKP[16]" value="X_Kemasan" <?php if ($d2[15][0] == 'X') echo 'checked'; ?>>
                                                    <label for="radioO3_KP" style="width: 70px; height: 10px; background-color: #f1f600" title="Tidak Sesuai"></label>
                                                    <span style="margin-left: 5px;"></span>
                                                    <input class="uraianPenandaan_kP" param="KemasanKP" type="radio" id="radioO2_KP" name="CHKKP[16]" value="-_Kemasan" <?php if ($d2[15][0] == '-') echo 'checked'; ?>>
                                                    <label for="radioO2_KP" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak Ada"></label>
                                                    <input type="text" name="CHKKP[16]"  value="<?php echo $detail2[15]; ?>" style="display: none;" class="uPenandaan_kP">
                                                </td>
                                            </tr>
                                            <tr id="KemasanKP" class="txt_kP" hidden>
                                                <td></td>
                                                <td>&nbsp;<textarea class="uPenandaan_kP" title="Uraian Penandaan" style="width: 35%; height: 45px;" name="URNKP[16]" id="CHKKP[16]"><?php echo $detailKP[15]; ?></textarea></td>
                                            </tr>
                                            <tr><td colspan="6" style="background-color: white">&nbsp;</td></tr>
                                            <tr><td style="border-bottom: 1px solid #000;"></td></tr>
                                            <tr>
                                                <td class="td_left_header_checklist" style="vertical-align: top">Narasi gambar pada penandaan </td>
                                                <td class="td_left">
                                                    <input hidden name="CHKKP[17]" value="">
                                                    <textarea class="uPenandaan_kP" title="Narasi pada gambar penandaan" style="width: 35%; height: 100px;" name="URNKP[17]"><?php echo $detailKP[16]; ?></textarea>
                                                </td>
                                            </tr>
                                            <td style="border-bottom: 1px solid #000;"></td>
                                        </table>
                                    </div>

                                    <?php if (($sess['PENILAIANBL'] != '' && $sess['PENILAIANBL'] != ' ') || ($sess['PENILAIANKP'] != '' && $sess['PENILAIANKP'] != ' ')) { ?>
                                        <div class="div_tambahan">
                                        <?php } else { ?>
                                            <div class="div_tambahan" hidden>
                                                <?php
                                            }
                                            $jmldata = 0;
                                            $data = explode("^", $sess['LAMPIRAN']);
                                            $jmldata = count($data);
                                            if ($jmldata == 0) {
                                                $jmldata = 1;
                                                $data[] = "";
                                            }
                                            else
                                                $arrDataLamp = explode("^", $sess['LAMPIRAN']);
                                            ?>
                                            <br />
                                            <br />
                                            <table  id="tb_Lamp">
                                                <tr>
                                                    <td colspan="2"><h2 class="small garis">Lampiran&nbsp;<a href="javascript:void(0)" class="addLampiran" periksa="urut" terakhir="<?php echo 1; ?>"><img src="<?php echo base_url(); ?>images/add.png" align="absmiddle" style="border:none" title="Tambah Lampiran" /></a></h2></td>
                                                </tr>
                                                <?php
                                                $i = 0;
                                                do {
                                                    if (array_key_exists('LAMPIRAN', $sess) && trim($sess['LAMPIRAN']) != "") {
                                                        $arrLamp = explode(".", $arrDataLamp[$i]);
                                                        ?>
                                                        <tr>
                                                                 <!--<td class="td_left_checklist" style="vertical-align: top">37</td>-->
                                                            <td class="td_left_header_checklist" colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="file_FILE_PENANDAAN_OT<?php echo $i; ?>"><input type="hidden" name="PENANDAAN_OT[]" value="<?php echo $arrDataLamp[$i]; ?>"><a href="<?php echo base_url(); ?>files/<?php echo 'penandaan_010'; ?>/<?php echo $arrDataLamp[$i]; ?>" target="_blank" <?php if ($arrLamp[1] == "rar") echo 'onclick="dotRar();return false;"'; ?>>File Lampiran</a>&nbsp;&bull;&nbsp;<a href="#" class="del_upload" url="<?php echo site_url(); ?>/utility/uploads/del_upload_s/<?php echo 'penandaan_010/'; ?><?php echo $arrDataLamp[$i]; ?>" jns="FILE_PENANDAAN_OT<?php echo $i; ?>">Edit atau Hapus File ?</a></span><span class="upload_FILE_PENANDAAN_OT<?php echo $i; ?>" hidden><input type="file" jenis="FILE_PENANDAAN_OT<?php echo $i; ?>" allowed="jpg-jpeg-pdf-doc-docx-rar" url="<?php echo site_url(); ?>/utility/uploads/get_upload_s/<?php echo 'penandaan_010'; ?>" id="fileToUpload_FILE_PENANDAAN_OT<?php echo $i; ?>" name="userfile" onchange="do_upload($(this));
                                                    return false;" />
                                                                    &nbsp;Tipe File : *.jpg .jpeg .pdf .doc .docx .rar</span></td>
                                                        </tr>
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <tr>
                                                            <td class="td_left_header_checklist" colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="upload_FILE_PENANDAAN_OT"><input type="file" class="upload upOT" jenis="FILE_PENANDAAN_OT" allowed="jpg-jpeg-pdf-doc-docx-rar" url="<?php echo site_url(); ?>/utility/uploads/get_upload_s/<?php echo 'penandaan_010'; ?>" id="fileToUpload_FILE_PENANDAAN_OT" name="userfile" onchange="do_upload($(this));
                                                    return false;" />
                                                                    &nbsp;Tipe File : *.jpg .jpeg .pdf .doc .docx .rar</span><span class="file_FILE_PENANDAAN_OT"></span></td>
                                                        </tr>
                                                        <?php
                                                    }
                                                    $i++;
                                                } while ($i < $jmldata);
                                                ?>
                                            </table>
                                        </div>
                                        <?php if (($sess['PENILAIANBL'] != '' && $sess['PENILAIANBL'] != ' ') || ($sess['PENILAIANKP'] != '' && $sess['PENILAIANKP'] != ' ')) { ?>
                                            <div class="div_tambahan">
                                            <?php } else { ?>
                                                <div class="div_tambahan" hidden>
                                                <?php } ?>
                                                <br />
                                                <br />
                                                <table style="width: 60%; border-bottom: 1px solid #000;border-left: 1px solid #000;border-bottom: 1px solid #000;border-right: 1px solid #000;border-top: 1px solid #000;" class="form_tabel">
                                                    <tr>
                                                        <td style="width: 20%;"></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="td_left_header_checklist">&nbsp;Kesimpulan&nbsp;&nbsp;</td>
                                                        <td class="td_left">
                                                            <input type="text" id="kesimpulanHasilPenilaian" value="<?php
                                                            if ($sess['SISTEM'] == "MK")
                                                                echo "Memenuhi Ketentuan";
                                                            else
                                                                echo "Tidak Memenuhi Ketentuan"
                                                                ?>" readonly size="23" />
                                                            <input type="hidden" id="kesimpulanHasilPenilaianVal" value="<?php echo $sess['SISTEM']; ?>" name="URN[HASIL]"  /></td>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                    <?php if (!in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) { ?>
                                                        <tr class="TDKB" hidden><td class="td_left_header_checklist">&nbsp;Tindak Lanjut Balai</td><td class="td_left"><?php echo form_dropdown('PENANDAAN[TL_BALAI]', $cb_tindakan_balai, $sess['TL_BALAI'], 'class="stext TDKB" id="tDKBalai" title="Tindak Lanjut Balai" rel="required"'); ?></td><td></td></tr>
                                                        <tr class="tDKBalaiRow" hidden><td class="td_left_header_checklist"></td><td colspan="2"><input type="text" class="tDKBalaiRow TDKB" id="jmlMusnah" title="Jumlah" placeholder = "Jumlah" maxlength="7" size="5" value="<?php echo $pemusnahan2[0] ?>"/>&nbsp;<input type="text" class="tDKBalaiRow TDKB" id="satuanMusnah" title="Satuan" placeholder = "Satuan" size="10" value="<?php echo $pemusnahan[1] ?>"/>&nbsp;<input type="text" class="tDKBalaiRow TDKB" id="estimasiMusnah" title="Estimasi Harga" placeholder = "Estimasi Harga" maxlength="10" size="10" value="<?php echo $pemusnahan2[1] ?>"/></td></tr>
                                                        <tr class="tDKBalaiRow" hidden><td class="td_left"></td><td colspan="2"><?php
                                                                if ((array_key_exists('FILE_MUSNAH', $sess) && trim($sess['FILE_MUSNAH']) != "")) {
                                                                    ?><input type="hidden" name="MUSNAH[]" id = "fileMusnah" value="<?php echo $sess['FILE_MUSNAH']; ?>">
                                                                    <span id="file_FILE_MUSNAH"><a href="<?php echo base_url(); ?>files/<?php echo 'penandaan_010/2_010'; ?>/<?php echo $sess['FILE_MUSNAH']; ?>" target="_blank">File Lampiran</a>&nbsp;&bull;&nbsp;<a href="#" class="del_upload" id = "del_upload1" url="<?php echo site_url(); ?>/utility/uploads/del_upload_m/<?php echo 'penandaan_010/2_010'; ?>/<?php echo $sess['FILE_MUSNAH']; ?>" jns="FILE_MUSNAH">Edit atau Hapus File ?</a></span>
                                                                    <span class="upload_FILE_MUSNAH" hidden><input type="file" class="uploadMusnahBalai tDKBalaiRow" jenis="FILE_MUSNAH" allowed="doc-docx-pdf-rar" url="<?php echo site_url(); ?>/utility/uploads/get_upload_m/<?php echo 'penandaan_010/2_010'; ?>" id="fileToUpload_FILE_MUSNAH" name="userfile" onchange="do_upload($(this));
                                                    return false;" title="Lampiran Berita Acara" />
                                                                        &nbsp;Tipe File : *.doc .docx .pdf .rar</span><span class="file_FILE_MUSNAH"></span>
                                                                    <?php
                                                                } else {
                                                                    ?>
                                                                    <span class="upload_FILE_MUSNAH"><input type="file" class="uploadMusnahBalai tDKBalaiRow" jenis="FILE_MUSNAH" allowed="doc-docx-pdf-rar" url="<?php echo site_url(); ?>/utility/uploads/get_upload_m/<?php echo 'penandaan_010/2_010'; ?>" id="fileToUpload_FILE_MUSNAH" name="userfile" onchange="do_upload($(this));
                                                    return false;" title="Lampiran Berita Acara" />
                                                                        &nbsp;Tipe File : *.doc .docx .pdf .rar</span><span class="file_FILE_MUSNAH"></span>
                                                                    <?php
                                                                }
                                                                ?></td></tr>
                                                        <?php } ?>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                    <div style="height:5px;"></div>

                                <!--7-->
                                <?php if (in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) { ?>
                                    <div class="expand"><a title="expand/collapse" href="#" style="display: block;">KESIMPULAN</a></div>
                                    <div class="collapse">
                                        <div class="accCntnt">
                                            <table class="form_tabel" style="width: 100%;">
                                                <tr>
                                                    <td style="width: 22%; background-color: white"></td>
                                                    <td style="width: 78%; background-color: white; font-size: 14px; padding-right: 250px; padding-bottom: 5px; padding-top: 5px;"></td>
                                                </tr>
                                                <?php
                                                $pusat = explode("*", $sess['PUSAT']);
                                                $justifikasi = preg_replace('/(?:<|&lt;)\/?([a-zA-Z]+) *[^<\/]*?(?:>|&gt;)/', '', $pusat[2]) . "\n";
                                                if ((trim($sess['PUSAT']) == "" && in_array('2', $this->newsession->userdata('SESS_KODE_ROLE'))) || $editTL == 'YES') {
                                                    ?>
                                                    <tr><td class="td_left">Verifikasi Pusat</td><td class="td_left"><select class="stext verifikasiPusat" name="<?php echo 'PENANDAAN[HASIL_PUSAT]' ?>" rel="required" title="MK/TMK"><option></option><option value="MK" <?php if ($pusat[0] == 'MK') echo 'Selected' ?>>Memenuhi Ketentuan</option><option value="TMK"  <?php if ($pusat[0] == 'TMK') echo 'Selected' ?>>Tidak Memenuhi Ketentuan</option></select></td></tr>
                                                    <tr class="vTMK" hidden><td class="td_left"style="background-color: white;">Tindak Lanjut</td><td class="td_left" style="background-color: white;"><?php echo form_dropdown('PENANDAAN[TL_PUSAT]', $cb_tindakan, is_array($pusat) ? $pusat[1] : '', 'class="stext vTMK" id="vTMKSub" title="Tindak Lanjut Pusat"'); ?></td></tr>
                                                    <tr class="vJustifikasi" hidden><td class="td_left" style="background-color: white; vertical-align: top;">Justifikasi</td><td class="td_left" style="background-color: white;"><textarea name="JUSTIFIKASI" title="Justifikasi Pusat" class="stext chkJustifikasi" id="XXX" style="height: 140px;"><?php echo $justifikasi; ?></textarea></td></tr> <?php
                                                } else {
                                                    if ($pusat[0] == "TMK") {
                                                        ?>
                                                        <tr><td class="td_left">Verifikasi Pusat</td><td><b><i><?php
                                                                        echo 'Tidak Memenuhi Ketentuan';
                                                                        ?></i></b></td></tr><?php if (trim($pusat[1]) != "") { ?>
                                                            <tr><td class="td_left">Tindak Lanjut Pusat</td><td><?php echo $pusat[1]; ?></td></tr>
                                                        <?php } if (trim($pusat[2]) != "") { ?>
                                                            <tr><td class="td_left">Justifikasi Pusat</td><td><?php echo $justifikasi; ?></td></tr>
                                                            <?php
                                                        }
                                                    } else {
                                                        ?>
                                                        <tr><td class="td_left">Verifikasi Pusat</td><td><b><i><?php
                                                                        echo 'Memenuhi Ketentuan';
                                                                        ?></i></b></td></tr>
                                                        <?php if (trim($pusat[2]) != "") { ?>
                                                            <tr><td class="td_left">Justifikasi Pusat</td><td><?php echo $justifikasi; ?></td></tr>
                                                            <?php
                                                        }
                                                    }
                                                }
                                                ?>
                                            </table>
                                        </div>
                                    </div>
                                    <div style="height:5px;"></div>
                                <?php } ?>

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
                                    <?php
                                }
                                ?>

                                <div style="padding:10px;"></div><div><a href="javascript:void(0)" id="btnSave" class="button <?php echo $icon; ?>" onclick="fpost('#fpengawasanPenandaan_010', '', '');">
                                        <span><span class="icon"></span>&nbsp; <?php echo $labelSimpan; ?></span></a>&nbsp;
                                    <a href="javascript:void(0)" class="button reload" onclick="goBack()" >
                                        <span><span class="icon"></span>&nbsp; Batal</span></a></div>
                                <br />
                                <br />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" name="PENANDAAN_ID[]" value="<?php echo $sess['PENANDAAN_ID']; ?>" />
        <input type="hidden" name="KLASIFIKASIPENANDAAN" value="<?php echo $klasifikasi; ?>" />
        <input type="hidden" name="UPDATE" value="<?php echo $sess['STATUS']; ?>" />
        <input type="hidden" name="EDIT" value="<?php echo $editTL; ?>" />
        <input type="hidden" name="TUJUAN" value="<?php echo $tujuan; ?>" />
    </form>
</div>
<script type="text/javascript">
                                        function goBack()
                                        {
                                            window.history.back()
                                        }
                                        function showHide() {
                                            var impor = $("#NIE").val();
                                            var i = 0;
                                            $(".jkyadp").each(function() {
                                                var valz = $(this).val().split("_");
                                                if ($(this).attr('checked') === true) {
                                                    i++;
                                                    if (impor.indexOf("I") >= 0) {
                                                        $('.BahasaImpor' + valz[1]).show();
                                                        $('.BahasaImpor' + valz[1]).attr("hidden", false);
                                                        $('.BahasaImpor' + valz[1] + "Val").attr("rel", "required");
                                                    }
                                                    else {
                                                        $('.BahasaImpor' + valz[1]).hide();
                                                        $('.BahasaImpor' + valz[1]).attr("hidden", true);
                                                        $('.BahasaImpor' + valz[1] + "Val").attr("rel", "");
                                                    }
                                                }
                                            });
                                            if (i > 0)
                                                $(".div_tambahan").show("slow");
                                            else
                                                $(".div_tambahan").hide("slow");
                                        }
                                        function required(X, x) {
                                            var XX = $(X).val().split("_");
                                            var Param = $(X).attr("param");
                                            if (x === 1) {
                                                $("input:radio.uraianPenandaan_" + XX[1]).each(function() {
                                                    var name = $(this).attr("name");
                                                    if ($(this).closest(".infoPenandaanOT_" + XX[1] + "Row").attr("hidden") === false) {
                                                        $("input[type='text'][name='" + name + "']").attr("rel", "required");
                                                    }
                                                    if ($(this).closest(".infoPenandaanOT_" + XX[1] + "Row").attr("hidden") === true) {
                                                        $("input[type='text'][name='" + name + "']").attr("rel", "");
                                                    }
                                                });
                                            }
                                            else if (x === 2) {
                                                $("input:radio.uraianPenandaan_" + XX[1]).each(function() {
                                                    var name = $(this).attr("name");
                                                    $("input[type='text'][name='" + name + "']").attr("rel", "");
                                                });
                                                //                        resetPusat(Param);
                                            }
                                            else {
                                                alert("Terjadi Kesalahan");
                                            }
                                        }
                                        function checkedCmb(X, x) {
                                            if (x == 2)
                                                $(".jkyadp[value='jkyadp_" + X + "']").attr("checked", "checked");
                                            if ($(".jkyadp[value='jkyadp_" + X + "']").attr("checked") === true) {
                                                $(".div_" + X).show();
                                                required($("#jkyadp_" + X), 1);
                                                showHide();
                                            } else {
                                                $(".div_" + X).hide();
                                                required($("#jkyadp_" + X), 2);
                                                clear(X);
                                            }
                                        }
                                        function clear(XX) {
                                            $("input:radio.uraianPenandaan_" + XX).each(function() {
                                                $(this).attr("checked", false);
                                            });
                                            $(".uPenandaan_" + XX).val("");
                                            $(".uPenandaan_" + XX).attr("rel", "");
                                            $(".txt_" + XX).hide();
                                            $("#kesimpulanHasilPenilaian" + XX).val("");
                                            $("#kesimpulanHasilPenilaian" + XX.toUpperCase() + "Val").val("");
                                            $("#fileToUpload_FILE_PENANDAAN_" + XX.toUpperCase()).attr("rel", "");
                                        }
                                        function do_upload(element) {
                                            var jenis = $(element).attr("jenis");
                                            var allowed = $(element).attr("allowed");
                                            jLoadingOpen('Upload File', 'SIPT Versi 1.0');
                                            $.ajaxFileUpload({
                                                url: $(element).attr("url") + '/' + jenis + '/' + allowed,
                                                secureuri: false,
                                                fileElementId: $(element).attr("id"),
                                                dataType: "json",
                                                success: function(data) {
                                                    var arrdata = data.msg.split("#");
                                                    if (typeof (data.error) !== "undefined") {
                                                        if (data.error !== "") {
                                                            jAlert(data.error, "SIPT Versi 1.0 Beta");
                                                        } else {
                                                            var param = arrdata[2].substr(0, 17);
                                                            if (param == "FILE_PENANDAAN_OT") {
                                                                var arrFile = arrdata[0].split("."), strFile = "";
                                                                if (arrFile[1] == "rar")
                                                                    strFile = 'onclick="dotRar();return false;"';
                                                                $("#fileToUpload_" + arrdata[2] + "").removeAttr("rel");
                                                                $(".upload_" + arrdata[2] + "").hide();
                                                                $(".file_" + arrdata[2] + "").html("<b>1 File telah dilampirkan. </b>&nbsp;<a href=\"<?php echo base_url(); ?>files/" + arrdata[3] + "/" + arrdata[0] + "\" target=\"_blank\" " + strFile + ">Tampilkan File</a>&nbsp;&bull;&nbsp;<a href=\"#\" class=\"del_upload\" url=\"<?php echo site_url(); ?>/utility/uploads/del_upload_s/" + arrdata[3] + "/" + arrdata[0] + "\" jns=" + arrdata[2] + ">Edit atau Hapus File ?</a><input type=\"hidden\" name=\"PENANDAAN_OT[]\" value=" + arrdata[0] + ">");
                                                            } else if (arrdata[2] == "FILE_MUSNAH") {
                                                                $("#fileToUpload_" + arrdata[2] + "").removeAttr("rel");
                                                                $(".upload_" + arrdata[2] + "").hide();
                                                                $(".file_" + arrdata[2] + "").html("<b>1 File telah dilampirkan. </b>&nbsp;<a href=\"<?php echo base_url(); ?>files/" + arrdata[3] + "/" + arrdata[4] + "/" + arrdata[0] + "\" target=\"_blank\">Tampilkan File</a>&nbsp;&bull;&nbsp;<a href=\"#\" class=\"del_upload\" id=\"del_upload1\" url=\"<?php echo site_url(); ?>/utility/uploads/del_upload_m/" + arrdata[3] + "/" + arrdata[4] + "/" + arrdata[0] + "\" jns=" + arrdata[2] + ">Edit atau Hapus File ?</a><input type=\"hidden\" name=\"MUSNAH[FILE]\" value=" + arrdata[0] + ">");
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
                                            var tgl1 = '#tglXX', tgl2 = '#tglAwalPengawasan', tgl3 = '#tglAkhirPengawasan';
                                            if (A === 'A') {
                                                if ($('#tglXX') !== '')
                                                    compare(tgl1, tgl2);
                                                if ($('#tglAkhirPengawasan').val() !== '')
                                                    compare(tgl2, tgl3);
                                            }
                                            else if (A === 'B') {
                                                if ($('#tglXX') !== '')
                                                    compare(tgl1, tgl3);
                                                if ($('#tglAwalPengawasan').val() !== '')
                                                    compare(tgl2, tgl3);
                                            }
                                        }
                                        function cekLampiran(load) {
                                            //    var kesimpulan = $('#kesimpulanHasilPenilaian').val();
                                            //    if (kesimpulan === 'Tidak Memenuhi Ketentuan') {
                                            if (load === "NO")
                                                $('.upload').attr('rel', 'required');
                                            else
                                                $('.upload').attr('rel', '');
                                            //    } else {
                                            //      $('.upload').attr('rel', ' ');
                                            //    }
                                        }
                                        function verifikasiPusat(X) {
                                            if ($(X).val() === "MK") {
                                                $(".vTMK").hide();
                                                $(".vTMK").attr("rel", " ");
                                                $(".vTMK").val("");
                                                $(".vTMK2").hide("slow");
                                                $(".vTMK2").val("");
                                                $(".vTMK2").attr("rel", "");
                                                $(".vTMK2a").val("");
                                            }
                                            else if ($(X).val() === "TMK") {
                                                $(".vTMK").show();
                                                $(".vTMK").attr("rel", "required");
                                                $(".vTMK2").show();
                                            }
                                            else {
                                                $(".vTMK").hide();
                                                $(".vTMK").hide();
                                                $(".vTMK").attr("rel", " ");
                                                $(".vTMK").val("");
                                                $(".vTMK2").hide("slow");
                                                $(".vTMK2").val("");
                                                $(".vTMK2").attr("rel", "");
                                                $(".vTMK2a").val("");
                                            }
                                            if ($(X).val() != '') {
                                                if ($(X).val() != $("#kesimpulanHasilPenilaianVal").val()) {
                                                    $(".vJustifikasi").show("slow");
                                                    $(".chkJustifikasi").attr("rel", "required");
                                                } else if ($(X).val() == $("#kesimpulanHasilPenilaianVal").val()) {
                                                    $(".vJustifikasi").hide("slow");
                                                    $(".chkJustifikasi").attr("rel", "");
                                                }
                                            } else {
                                                $(".vJustifikasi").hide("slow");
                                                $(".chkJustifikasi").attr("rel", "");
                                            }
                                        }
                                        function verifikasiTL(X) {
                                            if ($(X).val() == 'TL' || $(X).val() == 'STL') {
                                                $(".vTMK2").show("slow");
                                                $(".vTMK2").attr("rel", "required");
                                            } else {
                                                $(".vTMK2").hide("slow");
                                                $(".vTMK2").attr("rel", "");
                                                $(".vTMK2").val("");
                                                $(".vTMK2a").val("");
                                            }
                                        }
                                        function borderLess(obj, param) {
                                            $(obj).closest("td").css('border-left', '0px solid #F00');
                                        }
                                        function isiValue(obj) {
                                            var A, param, name;
                                            var nie = $("#NIE").val(), produsen = $("#produsen").val(), almtProdusen = $("#alamatProdusen").val(), komposisi = $('#komposisi').val(), btkSediaan = $('#bentukSediaan').val(), kemasan = $('#kemasan').val(), importir = $("#pendaftar").val(), almtImportir = $("#alamatPendaftar").val();
                                            var clazz = $(".jkyadp"), clazzComp;
                                            if (typeof obj === "object") {
                                                A = obj.val().split('_');
                                                param = obj.attr('param');
                                                name = $(obj).attr("name");
                                                if (A[1] === 'Nie') {
                                                    if (nie !== "" && A[0] === '+') {
                                                        $("[id='" + name + "']").val(nie);
                                                        $("[id='" + name + "']").attr("readonly", true);
                                                    }
                                                    else if (nie !== "" && A[0] === 'X') {
                                                        $("[id='" + name + "']").val("");
                                                        $("[id='" + name + "']").attr("readonly", false);
                                                    }
                                                }
                                                else if (A[1] === 'Produsen') {
                                                    if (produsen !== "" && A[0] === '+') {
                                                        $("[id='" + name + "']").val(produsen + "; " + almtProdusen);
                                                        $("[id='" + name + "']").attr("readonly", true);
                                                    }
                                                    else if (produsen !== "" && A[0] === 'X') {
                                                        $("[id='" + name + "']").val("");
                                                        $("[id='" + name + "']").attr("readonly", false);
                                                    }
                                                }
                                                else if (A[1] === 'Importir') {
                                                    if (importir !== "" && A[0] === '+') {
                                                        $("[id='" + name + "']").val(importir + "; " + almtImportir);
                                                        $("[id='" + name + "']").attr("readonly", true);
                                                    }
                                                    else if (importir !== "" && A[0] === 'X') {
                                                        $("[id='" + name + "']").val("");
                                                        $("[id='" + name + "']").attr("readonly", false);
                                                    }
                                                }
                                                else if (A[1] === 'Komposisi') {
                                                    if (komposisi !== "" && A[0] === '+') {
                                                        $("[id='" + name + "']").val(komposisi);
                                                        $("[id='" + name + "']").attr("readonly", true);
                                                    }
                                                    else if (komposisi !== "" && A[0] === 'X') {
                                                        $("[id='" + name + "']").val("");
                                                        $("[id='" + name + "']").attr("readonly", false);
                                                    }
                                                }
                                                else if (A[1] === 'Bentuk Sediaan') {
                                                    if (btkSediaan !== "" && A[0] === '+') {
                                                        $("[id='" + name + "']").val(btkSediaan);
                                                        $("[id='" + name + "']").attr("readonly", true);
                                                    }
                                                    else if (btkSediaan !== "" && A[0] === 'X') {
                                                        $("[id='" + name + "']").val("");
                                                        $("[id='" + name + "']").attr("readonly", false);
                                                    }
                                                }
                                                else if (A[1] === 'Kemasan') {
                                                    if (kemasan !== "" && A[0] === '+') {
                                                        $("[id='" + name + "']").val(kemasan);
                                                    }
                                                    else if (kemasan !== "" && A[0] === 'X') {
                                                        $("[id='" + name + "']").val("");
                                                    }
                                                }
                                            } else {
                                                $(clazz).each(function() {
                                                    var clazzVal = $(this).val();
                                                    if ($("#" + clazzVal).attr("checked") === true) {
                                                        clazzComp = clazzVal.split("_");
                                                        var i = 0;
                                                        $(".txt_" + clazzComp[1]).each(function() {
                                                            var before = $(this).prev('tr').attr("class");
                                                            var after = $("." + before).find('input').attr("class");
                                                            $("." + after).each(function() {
                                                                if ($(this).attr("checked") === true) {
                                                                    A = $(this).val().split('_');
                                                                    param = $(this).attr('param');
                                                                    name = $(this).attr("name");
                                                                    if (A[1] === 'Nie') {
                                                                        if (nie !== "" && A[0] === '+') {
                                                                            $("[id='" + name + "']").val(nie);
                                                                            $("[id='" + name + "']").attr("readonly", true);
                                                                        }
                                                                        else if (nie !== "" && A[0] === 'X') {
                                                                            $("[id='" + name + "']").val("");
                                                                            $("[id='" + name + "']").attr("readonly", false);
                                                                        }
                                                                    }
                                                                    else if (A[1] === 'Produsen') {
                                                                        if (produsen !== "" && A[0] === '+') {
                                                                            $("[id='" + name + "']").val(produsen + "; " + almtProdusen);
                                                                            $("[id='" + name + "']").attr("readonly", true);
                                                                        }
                                                                        else if (produsen !== "" && A[0] === 'X') {
                                                                            $("[id='" + name + "']").val("");
                                                                            $("[id='" + name + "']").attr("readonly", false);
                                                                        }
                                                                    }
                                                                    else if (A[1] === 'Importir') {
                                                                        if (importir !== "" && A[0] === '+') {
                                                                            $("[id='" + name + "']").val(importir + "; " + almtImportir);
                                                                            $("[id='" + name + "']").attr("readonly", true);
                                                                        }
                                                                        else if (importir !== "" && A[0] === 'X') {
                                                                            $("[id='" + name + "']").val("");
                                                                            $("[id='" + name + "']").attr("readonly", false);
                                                                        }
                                                                    }
                                                                    else if (A[1] === 'Komposisi') {
                                                                        if (komposisi !== "" && A[0] === '+') {
                                                                            $("[id='" + name + "']").val(komposisi);
                                                                            $("[id='" + name + "']").attr("readonly", true);
                                                                        }
                                                                        else if (komposisi !== "" && A[0] === 'X') {
                                                                            $("[id='" + name + "']").val("");
                                                                            $("[id='" + name + "']").attr("readonly", false);
                                                                        }
                                                                    }
                                                                    else if (A[1] === 'Bentuk Sediaan') {
                                                                        if (btkSediaan !== "" && A[0] === '+') {
                                                                            $("[id='" + name + "']").val(btkSediaan);
                                                                            $("[id='" + name + "']").attr("readonly", true);
                                                                        }
                                                                        else if (btkSediaan !== "" && A[0] === 'X') {
                                                                            $("[id='" + name + "']").val("");
                                                                            $("[id='" + name + "']").attr("readonly", false);
                                                                        }
                                                                    }
                                                                    else if (A[1] === 'Kemasan') {
                                                                        if (kemasan !== "" && A[0] === '+') {
                                                                            $("[id='" + name + "']").val(kemasan);
                                                                        }
                                                                        else if (kemasan !== "" && A[0] === 'X') {
                                                                            $("[id='" + name + "']").val("");
                                                                        }
                                                                    }
                                                                }
                                                            });
                                                        });
                                                    }
                                                });
                                            }
                                        }
                                        function musnahkan() {
                                            $("#jmlMusnah").val("");
                                            $("#estimasiMusnah").val("");
                                            $("#satuanMusnah").val("");
                                            $("#fileMusnah").val("");
                                            musnahkanFile("#del_upload1");
                                        }
                                        function musnahkanFile(id) {
                                            var jenis = $(id).attr("jns");
                                            $.ajax({
                                                type: "GET",
                                                url: $(id).attr("url"),
                                                data: $(id).serialize(),
                                                success: function(data) {
                                                    var arrdata = data.split("#");
                                                    $(".upload_" + jenis + "").show();
                                                    $(".upload_" + jenis + "").attr("rel", "required");
                                                    $("#fileToUpload_" + jenis + "").val('');
                                                    $(".file_" + jenis + "").html("");
                                                    $("#file_" + jenis + "").hide("");
                                                    cekLampiran();
                                                    if (jenis !== "FILE_PENANDAAN_OT")
                                                        $("#fileToUpload_" + jenis + "").attr("rel", "");
                                                }
                                            });
                                            return false;
                                        }
                                        function tdkBalai(obj) {
                                            if ($(obj).val() === '1') {
                                                $(".tDKBalaiRow").show();
                                                $(".tDKBalaiRow").attr("rel", "required");
                                                $("#estimasiMusnah").attr("rel", "");
<?php if (trim($sess['FILE_MUSNAH']) != "") { ?>
                                                    $(".uploadMusnahBalai").attr("rel", "");
<?php } ?>
                                                $("#jmlMusnah").attr("name", "MUSNAH[JUMLAH]");
                                                $("#estimasiMusnah").attr("name", "MUSNAH[ESTIMASI]");
                                                $("#satuanMusnah").attr("name", "MUSNAH[SATUAN]");
                                                $("#fileMusnah").attr("name", "MUSNAH[FILE]");
                                            }
                                            else {
                                                $(".tDKBalaiRow").hide();
                                                $(".tDKBalaiRow").attr("rel", "");
                                                $("#jmlMusnah").attr("name", "");
                                                $("#estimasiMusnah").attr("name", "");
                                                $("#satuanMusnah").attr("name", "");
                                                $("#fileMusnah").attr("name", "");
                                                musnahkan();
                                            }
                                        }
                                        $(document).ready(function() {
                                            $("textarea.chkJustifikasi").redactor({
                                                buttons: ['bold', 'italic', '|', 'unorderedlist', 'orderedlist', 'outdent', 'indent', '|', 'alignleft', 'aligncenter', 'alignright', 'justify'],
                                                removeStyles: false,
                                                cleanUp: true,
                                                autoformat: true
                                            });
                                            //                      Load data
<?php
if (array_key_exists("PENANDAAN_ID", $sess)) {
    if (trim($sess['PENILAIANBL']) != "" && trim($detail[0]) != "") {
        ?>
                                                    $(".uraianPenandaan_bL").each(function() {
                                                        if ($(this).is(':checked')) {
                                                            checkListTxt($(this), "LOAD");
                                                            isiValue($(this));
                                                        }
                                                    });
        <?php
    } if (trim($sess['PENILAIANKP']) != "" && trim($detail2[0]) != "") {
        ?>
                                                    $(".uraianPenandaan_kP").each(function() {
                                                        if ($(this).is(':checked')) {
                                                            checkListTxt($(this), "LOAD");
                                                            isiValue($(this));
                                                        }
                                                    });
    <?php } if (trim($sess['TL_BALAI']) != "" && $sess['TL_BALAI'] != NULL) { ?>
                                                    tdkBalai($("#tDKBalai"));
    <?php } ?>
    <?php if (in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) { ?>
                                                    $(".verifikasiPusat").each(function() {
                                                        verifikasiPusat($(this));
                                                    });
    <?php } ?>
                                                showHide();
    <?php
}
?>
                                            $("input.namaOTJadi").autocomplete($("input.namaOTJadi").attr("url") + 'ot', {width: 244, selectFirst: false});
                                            $("input.namaOTJadi").result(function(event, data, formatted) {
                                                if (data) {
                                                    $('#namaOTJadi').val(data[1]);
                                                    $('#NIE').val(data[2]);
                                                    $('#bentukSediaan').val(data[9]);
                                                    $('#kemasan').val(data[4]);
                                                    $('#produsen').val(data[6]);
                                                    $('#alamatProdusen').val(data[11]);
                                                    if (data[2].indexOf("I") >= 0) {
                                                        $('#alamatPendaftar').val(data[5]);
                                                        $('#pendaftar').val(data[3]);
                                                    }
                                                    showHide();
                                                    isiValue("N");
                                                }
                                            });
                                            $('#namaOTJadi').keyup(function() {
                                                if ($('#namaOTJadi').val() === '') {
                                                    $('#namaOTJadi').val('');
                                                    $('#NIE').val('');
                                                    $('#bentukSediaan').val('');
                                                    $('#pendaftar').val('');
                                                    $('#produsen').val('');
                                                    $('#kemasan').val('');
                                                    $('#komposisi').val('');
                                                    $('#alamatProdusen').val('');
                                                    $('#alamatPendaftar').val('');
                                                    //                          $('#komposisi').val('').attr('disabled', true);
                                                    //                          $('#alamatProdusen').val('').attr('disabled', true);
                                                    //                          $('#alamatPendaftar').val('').attr('disabled', true);
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
                                            $(".jkyadp").click(function() {
                                                var XX = $(this).val().split("_");
                                                checkedCmb(XX[1], 1);
                                            });
                                            $(".uraianPenandaan_bL").click(function() {
                                                var name = $(this).attr("name"), selectedVal = "";
                                                var selected = $("input[type='radio'][name='" + name + "']:checked").val();
                                                $("input[type='text'][name='" + name + "']").val(selected);
                                                checkListTxt($(this), "NO");
                                                //                        verifikasiPusat($(".verifikasiPusat"));
                                                //                        verifikasiTL($("#vTMKSub"));
                                                borderLess($(this));
                                                isiValue($(this));
                                            });
                                            $(".uraianPenandaan_kP").click(function() {
                                                var name = $(this).attr("name"), selectedVal = "";
                                                var selected = $("input[type='radio'][name='" + name + "']:checked").val();
                                                $("input[type='text'][name='" + name + "']").val(selected);
                                                checkListTxt($(this), "NO");
                                                //                        verifikasiPusat($(".verifikasiPusat"));
                                                //                        verifikasiTL($("#vTMKSub"));
                                                borderLess($(this));
                                                isiValue($(this));
                                            });
                                            $('input.sdate').datepicker({dateFormat: 'dd/mm/yy', regional: 'id'});
                                            $("#klasifikasi_id").change(function() {
                                                if ($(this).val() === "001") {
                                                    $('.content2').fadeIn(3500);
                                                    $('html, body').animate({scrollTop: $(window).scrollTop() + 300});
                                                    $('.form_tabel_detail').focus();
                                                } else {
                                                    $(this).attr("checked", false);
                                                }
                                            });
                                            function checkListTxt(XXX, load) {
                                                var A = XXX.val().split('_');
                                                var param = XXX.attr('param');
                                                var name = $(XXX).attr("name");
                                                if (A[0] === '+' || A[0] === 'X') {
                                                    $('#' + param).show("");
                                                    if (name !== "CHKBL[15]" && name !== "CHKKP[15]" && name !== "CHKBL[18]" && name !== "CHKKP[18]")
                                                        $("[id='" + name + "']").attr("rel", "required");
                                                }
                                                else {
                                                    $('#' + param).hide("");
                                                    $("[id='" + name + "']").attr("rel", "");
                                                    $("[id='" + name + "']").val("");
                                                }
                                                mkTmk(load);
                                            }
                                            function mkTmk(load) {
                                                var X = false, X2 = false;
                                                $('.uraianPenandaan_bL').each(function() {
                                                    if ($(this).is(":checked") === true) {
                                                        var a = $(this).val().split('_');
                                                        var b = $(this).attr('name');
                                                        if ((a[0] === '-' || a[0] === 'X') && (b !== 'CHKBL[13]' && b !== 'CHKBL[6]' && b !== 'CHKBL[7]')) {
                                                            X = true;
                                                        }
                                                    }
                                                });
                                                $('.uraianPenandaan_kP').each(function() {
                                                    if ($(this).is(":checked") === true) {
                                                        var a = $(this).val().split('_');
                                                        var b = $(this).attr('name');
                                                        if ((a[0] === '-' || a[0] === 'X') && (b !== 'CHKKP[13]' && b !== 'CHKKP[6]' && b !== 'CHKKP[7]')) {
                                                            X2 = true;
                                                        }
                                                    }
                                                });
                                                if ((X === true && X2 === true) || (X !== true && X2 === true) || (X === true && X2 !== true)) {
                                                    $('#kesimpulanHasilPenilaian').val('Tidak Memenuhi Ketentuan');
                                                    $('#kesimpulanHasilPenilaianVal').val('TMK');
                                                    $("#fileToUpload_FILE_PENANDAAN_OT").attr("rel", "required");
                                                    $(".TDKB").show("");
                                                    $("#tDKBalai").attr("rel", "required");
                                                } else if (X !== true && X2 !== true) {
                                                    $('#kesimpulanHasilPenilaian').val('Memenuhi Ketentuan');
                                                    $('#kesimpulanHasilPenilaianVal').val('MK');
                                                    $("#fileToUpload_FILE_PENANDAAN_OT").attr("rel", "");
                                                    $(".TDKB").hide("");
                                                    $(".TDKB").val("");
                                                    $(".TDKB").attr("rel", "");
                                                    $("#tDKBalai").attr("rel", "");
                                                }
                                                cekLampiran(load);
                                            }
                                            $("#detail_petugas").html("Loading ...");
                                            $("#detail_petugas").load($("#detail_petugas").attr("url"));
                                            $(".del_upload").live("click", function() {
                                                var jenis = $(this).attr("jns");
                                                var param = jenis.substr(0, 17);
                                                $.ajax({
                                                    type: "GET",
                                                    url: $(this).attr("url"),
                                                    data: $(this).serialize(),
                                                    success: function(data) {
                                                        var arrdata = data.split("#");
                                                        $(".upload_" + jenis + "").show();
                                                        $("#fileToUpload_" + jenis + "").val('');
                                                        $(".file_" + jenis + "").html("");
                                                        $("#file_" + jenis + "").html("");
                                                        if (param !== "FILE_PENANDAAN_OT")
                                                            $("#fileToUpload_" + jenis + "").attr("rel", "");
                                                    }
                                                });
                                                return false;
                                            });
                                            $(".verifikasiPusat").change(function() {
                                                $(".chkJustifikasi").text("");
                                                $(".vJustifikasi .redactor_box .redactor_frame").contents().find("#page").html("<p>&nbsp;</p>");
                                                verifikasiPusat($(this));
                                            });
                                            $("#vTMKSub").change(function() {
                                                verifikasiTL($(this));
                                            });
                                            $("#tDKBalai").change(function() {
                                                tdkBalai($(this));
                                            });
                                            $('.addLampiran').click(function() {
                                                var nom = $(this).attr('terakhir');
                                                $("#tb_Lamp").append('<tr id= "id_' + nom + '"><td class="td_left_header_checklist" colspan="2"><a href="javascript:void(0)" class="min" id="minCls' + nom + '" ><img src="<?php echo base_url(); ?>images/cancel.png" align="top" style="border:none" title="Hapus Lampiran" /></a>&nbsp;<span class="upload_FILE_PENANDAAN_OT' + nom + '"><input type="file" class="upload upOT" jenis="FILE_PENANDAAN_OT' + nom + '" allowed="jpg-jpeg-pdf-doc-docx-rar" url="<?php echo site_url(); ?>/utility/uploads/get_upload_s/<?php echo 'penandaan_010'; ?>" id="fileToUpload_FILE_PENANDAAN_OT' + nom + '" name="userfile" onchange="do_upload($(this));return false;" />&nbsp;Tipe File : *.jpg .jpeg .pdf .doc .docx .rar</span><span class="file_FILE_PENANDAAN_OT' + nom + '"></span></td></tr>');
                                                $(this).attr('terakhir', parseInt(nom) + 1);
                                                $("#minCls" + nom).click(function() {
                                                    $('#id_' + nom).remove();
                                                });
                                            });
                                        });</script>