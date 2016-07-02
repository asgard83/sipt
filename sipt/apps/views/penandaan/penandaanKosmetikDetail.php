<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
?>
<link type="text/css" href="<?php echo base_url(); ?>css/iklanPenandaan.css" rel="stylesheet" media="screen"/>
<div id="judulpmnpdd" class="judul"></div>
<div class="headersarana">PENGAWASAN PENANDAAN - KOSMETIKA</div>
<?php
$detail = explode('#', $sess['PENILAIAN']);
foreach ($detail as $k) {
    $d[] = explode('_', $k);
}
$detail2 = explode('^', $sess['URAIAN']);
?>
<div class="content">
    <form action="<?php echo $act; ?>" method="post" autocomplete="off" id="fpengawasanPenandaan_012">
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
                                <td class="td_left">Alamat Sampling</td><td class="td_right"><textarea class="stext" id="alamatPengambilan" title="Alamat Sampling, Sarana" style="width: 240px; height: 50px;" name="PENANDAAN[ALAMAT]" readonly><?php
                                        if (array_key_exists('ALAMAT_1', $sess)) {
                                            echo $sess['ALAMAT_1'] . ", " . $sess['KOTA'] . ", " . $sess['PROPINSI'];
                                        }
                                        ?></textarea></td>
                            </tr>
                        </table>
                    </div>
                </div><!-- Akhir Pemeriksaan !-->
                <div style="height:5px;"></div>
                <div class="acco2"><div class="expand"><a title="expand/collapse" href="#" style="display: block;">INFORMASI KOSMETIKA - PENANDAAN</a></div>
                    <div class="collapse">
                        <div class="accCntnt">
                            <table class="form_tabel">
                                <tr>
                                    <td class="td_left">Nama Produk </td><td class="td_right"><input type="text" class="stext namaKosmetikaJadi" id="namaKosmetikaJadi" url="<?php echo site_url(); ?>/autocompletes/autocomplete/produk_reg_2/" title="Nama Produk" rel="required" name="PENANDAANPRODUK[NAMA_PRODUK]" value="<?php echo $sess['NAMA_PRODUK'] ?>" /></td>
                                    <td class="td_left">Nomor Izin Edar / Notifikasi</td><td class="td_right"><input type="text" class="stext" id="NIE" title="NIE" title="Nomor Izin Edar" name="PENANDAANPRODUK[NIE]" value="<?php echo $sess['NOMOR_IZIN_EDAR'] ?>" /></td>
                                </tr>
                                <tr>
                                    <td class="td_left">Nama Pemohon Notifikasi</td><td class="td_right"><input type="text" class="stext" id="pemohon" title="Nama Pemohon Notifikasi" name="PENANDAANPRODUK[PENDAFTAR]" value="<?php echo $sess['PENDAFTAR'] ?>"/></td>
                                    <td class="td_left">Produsen</td><td class="td_right"><input type="text" class="stext" id="produsen" title="Nama Produsen" name="PENANDAANPRODUK[PRODUSEN]" value="<?php echo $sess['PRODUSEN'] ?>"/></td>
                                </tr>
                                <tr>
                                    <td class="td_left">Alamat Pemohon Notifikasi</td><td class="td_right"><textarea id="alamatPemohon" class="stext" title="Alamat Pemohon Notifikasi" name="PENANDAANPRODUK[ALAMAT_PENDAFTAR]"><?php echo $sess['ALAMAT_PENDAFTAR'] ?></textarea></td>
                                    <td class="td_left">Alamat Produsen</td><td class="td_right"><textarea id="alamatProdusen" class="stext" title="Alamat Produsen" name="PENANDAANPRODUK[ALAMAT_PRODUSEN]"><?php echo $sess['ALAMAT_PRODUSEN'] ?></textarea></td>
                                </tr>
                                <tr>
                                    <td class="td_left">Nama Importir</td><td class="td_right"><input type="text" class="stext" id="importir" title="Nama Importir" name="PENANDAANPRODUK[IMPORTIR]" value="<?php echo $sess['IMPORTIR'] ?>"/></td>
                                    <td class="td_left">Nama Pemberi Lisensi</td><td class="td_right"><input type="text" class="stext" id="lisensi" title="Nama Pemberi Lisensi" name="PENANDAANPRODUK[LISENSI]" value="<?php echo $sess['LISENSI'] ?>" rel="required"/></td>
                                </tr>
                                <tr>
                                    <td class="td_left">Alamat Importir</td><td class="td_right"><textarea id="alamatImportir" class="stext" title="Alamat Importir" name="PENANDAANPRODUK[ALAMAT_IMPORTIR]"><?php echo $sess['ALAMAT_IMPORTIR'] ?></textarea></td>
                                    <td class="td_left">Alamat Pemberi Lisensi</td><td class="td_right"><textarea id="alamatLisensi" class="stext" title="Alamat Pemberi Lisensi" name="PENANDAANPRODUK[ALAMAT_LISENSI]" rel = "required"><?php echo $sess['ALAMAT_LISENSI'] ?></textarea></td>
                                </tr>
                                <tr>
                                    <td class="td_left">Nama Pabrik Pengemas</td><td class="td_right"><input type="text" class="stext" id="pengemas" title="Nama Pabrik Pengemas" name="PENANDAANPRODUK[PENGEMAS]" value="<?php echo $sess['PENGEMAS'] ?>" rel="required"/></td>
                                    <td class="td_left" colspan="3"></td>
                                </tr>
                                <tr>
                                    <td class="td_left">Alamat Pabrik Pengemas</td><td class="td_right"><textarea id="alamatPengemas" class="stext"  title="Alamat Pabrik Pengemas" name="PENANDAANPRODUK[ALAMAT_PENGEMAS]" rel="required"><?php echo $sess['ALAMAT_PENGEMAS'] ?></textarea></td>
                                    <td class="td_left"></td><td class="td_right"></td>
                                </tr>
                                <tr>
                                    <td class="td_left">Kategori Produk</td><td class="td_right"><textarea id="kategoriProduk" class="stext" title="Kategori Produk" name="PENANDAANPRODUK[GOLONGAN_PRODUK]"><?php echo $sess['GOLONGAN_PRODUK'] ?></textarea></td>
                                    <td colspan="3"></td>
                                </tr>
                                <tr>
                                    <td colspan="2">&nbsp;</td>
                                </tr>
                                <tr></tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div style="height:5px;"></div>

                <!-- DIV Detail-->
                <div class="expand" id="expand1"><a title="expand/collapse" href="#" style="display: block;">FORM PENILAIAN PENANDAAN</a></div>
                <div class="collapse">
                    <div class="accCntnt">
                        <table class="form_tabel" style="width: 100%;">
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
                            <tr class="infoPenandaanKOSRow">
                                <td class="td_left_header_checklist" style="vertical-align: top">No Bets </td>
                                <td class="td_left">
                                    <input class="uraianPenandaan" param="Bets" type="radio" id="radioA1" name="CHK[1]" value="+_No Bets" <?php if ($d[0][0] == '+') echo 'checked'; ?>>
                                    <label for="radioA1" style="width: 70px; height: 10px;" title="Ada / Sesuai"></label>
                                    <span style="margin-left: 5px;"></span>
                                    <input class="uraianPenandaan" param="Bets" type="radio" id="radioA3" name="CHK[1]" value="X_No Bets" <?php if ($d[0][0] == 'X') echo 'checked'; ?>>
                                    <label for="radioA3" style="width: 70px; height: 10px; background-color: #f1f600" title="Tidak Sesuai"></label>
                                    <span style="margin-left: 5px;"></span>
                                    <input class="uraianPenandaan" param="Bets" type="radio" id="radioA2" name="CHK[1]" value="-_No Bets" <?php if ($d[0][0] == '-') echo 'checked'; ?>>
                                    <label for="radioA2" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak Ada"></label>
                                    <input type="text" name="CHK[1]"  value="<?php echo $detail[0]; ?>" style="display: none;"  rel="required">
                                </td>
                            </tr>
                            <tr id="Bets" hidden>
                                <td></td>
                                <td>&nbsp;<input type="text" name="URN[1]" class="Bets uPenandaan" title="Uraian Penandaan" size="45" id="CHK[1]" value="<?php echo $detail2[0]; ?>" /></td>
                            </tr>
                            <tr class="infoPenandaanKOSRow">
                                <td class="td_left_header_checklist" style="vertical-align: top">Netto </td>
                                <td class="td_left">
                                    <input class="uraianPenandaan" param="Netto" type="radio" id="radioB1" name="CHK[2]"  value="+_Netto" <?php if ($d[1][0] == '+') echo 'checked'; ?>>
                                    <label for="radioB1" style="width: 70px; height: 10px;" title="Ada / Sesuai"></label>
                                    <span style="margin-left: 5px;"></span>
                                    <input class="uraianPenandaan" param="Netto" type="radio" id="radioB3" name="CHK[2]" value="X_Netto" <?php if ($d[1][0] == 'X') echo 'checked'; ?>>
                                    <label for="radioB3" style="width: 70px; height: 10px; background-color: #f1f600" title="Tidak Sesuai"></label>
                                    <span style="margin-left: 5px;"></span>
                                    <input class="uraianPenandaan" param="Netto" type="radio" id="radioB2" name="CHK[2]" value="-_Netto" <?php if ($d[1][0] == '-') echo 'checked'; ?>>
                                    <label for="radioB2" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak Ada"></label>
                                    <input type="text" name="CHK[2]"  value="<?php echo $detail[1]; ?>" style="display: none;"  rel="required">
                                </td>
                            </tr>
                            <tr id="Netto" hidden>
                                <td></td>
                                <td style="width: 10%;">&nbsp;<input type="text" name="URN[2]" class="Netto uPenandaan" title="Uraian Penandaan" size="45" id="CHK[2]" value="<?php echo $detail2[1]; ?>"/></td>
                            <tr class="infoPenandaanKOSRow">
                                <td class="td_left_header_checklist" style="vertical-align: top">NIE / No. Notifikasi </td>
                                <td class="td_left">
                                    <input class="uraianPenandaan" param="Nie" type="radio" id="radioC1" name="CHK[3]" value="+_NIE" <?php if ($d[2][0] == '+') echo 'checked'; ?>>
                                    <label for="radioC1" style="width: 70px; height: 10px;" title="Ada / Sesuai"></label>
                                    <span style="margin-left: 5px;"></span>
                                    <input class="uraianPenandaan" param="Nie" type="radio" id="radioC3" name="CHK[3]" value="X_NIE" <?php if ($d[2][0] == 'X') echo 'checked'; ?>>
                                    <label for="radioC3" style="width: 70px; height: 10px; background-color: #f1f600" title="Tidak Sesuai"></label>
                                    <span style="margin-left: 5px;"></span>
                                    <input class="uraianPenandaan" param="Nie" type="radio" id="radioC2" name="CHK[3]" value="-_NIE" <?php if ($d[2][0] == '-') echo 'checked'; ?>>
                                    <label for="radioC2" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak Ada"></label>
                                    <input type="text" name="CHK[3]"  value="<?php echo $detail[2]; ?>" style="display: none;"  rel="required">
                                </td>
                            </tr>
                            <tr id="Nie" hidden>
                                <td></td>
                                <td>&nbsp;<input type="text" name="URN[3]" class="Nie uPenandaan" title="Uraian Penandaan" size="45"  id="CHK[3]" value="<?php echo $detail2[2]; ?>" /></td>
                            </tr>
                            <tr><td colspan="3" style="background-color: white;"></td></tr>
                            <tr>
                                <td class="td_left_header_checklist" style="vertical-align: top; background-color: white; border-bottom: 1px solid #000"> <b>Nama dan Alamat:</b> </td>
                            </tr>
                            <tr></tr>
                            <tr></tr>
                            <tr class="infoPenandaanKOSRow">
                                <td class="td_left_header_checklist" style="vertical-align: top;">Pemohon Notifikasi</td>
                                <td class="td_left">
                                    <input class="uraianPenandaan" param="PemohonNotifkos" type="radio" id="radioG11" name="CHK[4]" value="+_Pemohon Notifikasi" <?php if ($d[3][0] == '+') echo 'checked'; ?>>
                                    <label for="radioG11" style="width: 70px; height: 10px;" title="Ada / Sesuai"></label>
                                    <span style="margin-left: 5px;"></span>
                                    <input class="uraianPenandaan" param="PemohonNotifkos" type="radio" id="radioG13" name="CHK[4]" value="X_Pemohon Notifikasi" <?php if ($d[3][0] == 'X') echo 'checked'; ?>>
                                    <label for="radioG13" style="width: 70px; height: 10px; background-color: #f1f600" title="Tidak Sesuai"></label>
                                    <span style="margin-left: 5px;"></span>
                                    <input class="uraianPenandaan" param="PemohonNotifkos" type="radio" id="radioG12" name="CHK[4]"value="-_Pemohon Notifikasi" <?php if ($d[3][0] == '-') echo 'checked'; ?>>
                                    <label for="radioG12" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak Ada"></label>
                                    <span style="margin-left: 5px;" class="verified_PemohonNotifkos" hidden>
                                        <input class="uraianPenandaan" type="radio" id="radioG12V" name="VRF[PemohonNotifkos]" value="YES">
                                        <label for="radioG12V" style="width: 70px; height: 10px; background-color: #2F99CA" title="Sudah terverivikasi">Verifikasi</label>
                                        <input type="text" name="VRF[PemohonNotifkos]" style="display: none;"></span>
                                    <input type="text" name="CHK[4]"  value="<?php echo $detail[3]; ?>" style="display: none;"  rel="required">
                                </td>
                            </tr>
                            <tr id="PemohonNotifkos" hidden>
                                <td></td>
                                <td>&nbsp;<textarea class="PemohonNotifkos uPenandaan" title="Uraian Penandaan" style="width: 34%; height: 45px;" name="URN[4]" id="CHK[4]"><?php echo $detail2[3]; ?></textarea></td>
                            </tr>
                            <tr class="infoPenandaanKOSRow">
                                <td class="td_left_header_checklist" style="vertical-align: top;">Produsen </td>
                                <td class="td_left">
                                    <input class="uraianPenandaan" param="Produsen" type="radio" id="radioD1" name="CHK[5]" value="+_Produsen" <?php if ($d[4][0] == '+') echo 'checked'; ?>>
                                    <label for="radioD1" style="width: 70px; height: 10px;" title="Ada / Sesuai"></label>
                                    <span style="margin-left: 5px;"></span>
                                    <input class="uraianPenandaan" param="Produsen" type="radio" id="radioD3" name="CHK[5]" value="X_Produsen" <?php if ($d[4][0] == 'X') echo 'checked'; ?>>
                                    <label for="radioD3" style="width: 70px; height: 10px; background-color: #f1f600" title="Tidak Sesuai"></label>
                                    <span style="margin-left: 5px;"></span>
                                    <input class="uraianPenandaan" param="Produsen" type="radio" id="radioD2" name="CHK[5]" value="-_Produsen" <?php if ($d[4][0] == '-') echo 'checked'; ?>>
                                    <label for="radioD2" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak Ada"></label>
                                    <span style="margin-left: 5px;" class="verified_Produsen" hidden>
                                        <input class="uraianPenandaan" type="radio" id="radioD2V" name="VRF[Produsen]" value="YES">
                                        <label for="radioD2V" style="width: 70px; height: 10px; background-color: #2F99CA" title="Sudah terverivikasi">Verifikasi</label>
                                        <input type="text" name="VRF[Produsen]" style="display: none;"></span>
                                    <input type="text" name="CHK[5]"  value="<?php echo $detail[4]; ?>" style="display: none;"  rel="required">
                                </td>
                            </tr>
                            <tr id="Produsen" hidden>
                                <td></td>
                                <td>&nbsp;<textarea class="Produsen uPenandaan" title="Uraian Penandaan" style="width: 34%; height: 45px;" name="URN[5]" id="CHK[5]"><?php echo $detail2[4]; ?></textarea></td>
                            </tr>
                            <tr class="importirBased infoPenandaanKOSRow" hidden>
                                <td class="td_left_header_checklist" style="vertical-align: top;">Importir </td>
                                <td class="td_left">
                                    <input class="uraianPenandaan" param="Importir" type="radio" id="radioE1" name="CHK[6]" value="+_Importir" <?php if ($d[5][0] == '+') echo 'checked'; ?>>
                                    <label for="radioE1" style="width: 70px; height: 10px;" title="Ada / Sesuai"></label>
                                    <span style="margin-left: 5px;"></span>
                                    <input class="uraianPenandaan" param="Importir" type="radio" id="radioE3" name="CHK[6]" value="X_Importir" <?php if ($d[5][0] == 'X') echo 'checked'; ?>>
                                    <label for="radioE3" style="width: 70px; height: 10px; background-color: #f1f600" title="Tidak Sesuai"></label>
                                    <span style="margin-left: 5px;"></span>
                                    <input class="uraianPenandaan" param="Importir" type="radio" id="radioE2" name="CHK[6]" value="-_Importir" <?php if ($d[5][0] == '-') echo 'checked'; ?>>
                                    <label for="radioE2" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak Ada"></label>
                                    <span style="margin-left: 5px;" class="verified_Importir" hidden>
                                        <input class="uraianPenandaan" type="radio" id="radioE2V" name="VRF[Importir]" value="YES">
                                        <label for="radioE2V" style="width: 70px; height: 10px; background-color: #2F99CA" title="Sudah terverivikasi">Verifikasi</label>
                                        <input type="text" name="VRF[Importir]" style="display: none;"></span>
                                    <input type="text" id="importirBasedTxt" name="CHK[6]"  value="<?php echo $detail[5]; ?>" style="display: none;">
                                </td>
                            </tr>
                            <tr id="Importir" hidden>
                                <td></td>
                                <td>&nbsp;<textarea class="Importir uPenandaan" title="Uraian Penandaan" style="width: 34%; height: 45px;" name="URN[6]" id="CHK[6]"><?php echo $detail2[5]; ?></textarea></td>
                            </tr>
                            <tr class="infoPenandaanKOSRow">
                                <td class="td_left_header_checklist" style="vertical-align: top;">Distributor</td>
                                <td class="td_left">
                                    <input class="uraianPenandaan" param="Distributor" type="radio" id="radioF1" name="CHK[7]" value="+_Distributor" <?php if ($d[6][0] == '+') echo 'checked'; ?>>
                                    <label for="radioF1" style="width: 70px; height: 10px;" title="Ada / Sesuai"></label>
                                    <span style="margin-left: 5px;"></span>
                                    <input class="uraianPenandaan" param="Distributor" type="radio" id="radioF3" name="CHK[7]" value="X_Distributor" <?php if ($d[6][0] == 'X') echo 'checked'; ?>>
                                    <label for="radioF3" style="width: 70px; height: 10px; background-color: #f1f600" title="Tidak Sesuai"></label>
                                    <span style="margin-left: 5px;"></span>
                                    <input class="uraianPenandaan" param="Distributor" type="radio" id="radioF2" name="CHK[7]" value="-_Distributor" <?php if ($d[6][0] == '-') echo 'checked'; ?>>
                                    <label for="radioF2" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak Ada"></label>
                                    <span style="margin-left: 5px;" class="verified_Distributor" hidden>
                                        <input class="uraianPenandaan" type="radio" id="radioF2V" name="VRF[Distributor]" value="YES">
                                        <label for="radioF2V" style="width: 70px; height: 10px; background-color: #2F99CA" title="Sudah terverivikasi">Verifikasi</label>
                                        <input type="text" name="VRF[Distributor]" style="display: none;"></span>
                                    <input type="text" name="CHK[7]"  value="<?php echo $detail[6]; ?>" style="display: none;"  rel="required">
                                </td>
                            </tr>
                            <tr id="Distributor" hidden>
                                <td></td>
                                <td>&nbsp;<textarea class="Distributor uPenandaan" title="Uraian Penandaan" style="width: 34%; height: 45px;" name="URN[7]" id="CHK[7]"><?php echo $detail2[6]; ?></textarea></td>
                            <tr class="infoPenandaanKOSRow">
                                <td class="td_left_header_checklist" style="vertical-align: top;">Pemberi Lisensi </td>
                                <td class="td_left">
                                    <input class="uraianPenandaan" param="PemberiLisensi" type="radio" id="radioG1" name="CHK[8]" value="+_Pemberi Lisensi" <?php if ($d[7][0] == '+') echo 'checked'; ?>>
                                    <label for="radioG1" style="width: 70px; height: 10px;" title="Ada / Sesuai"></label>
                                    <span style="margin-left: 5px;"></span>
                                    <input class="uraianPenandaan" param="PemberiLisensi" type="radio" id="radioG3" name="CHK[8]" value="X_Pemberi Lisensi" <?php if ($d[7][0] == 'X') echo 'checked'; ?>>
                                    <label for="radioG3" style="width: 70px; height: 10px; background-color: #f1f600" title="Tidak Sesuai"></label>
                                    <span style="margin-left: 5px;"></span>
                                    <input class="uraianPenandaan" param="PemberiLisensi" type="radio" id="radioG2" name="CHK[8]"value="-_Pemberi Lisensi" <?php if ($d[7][0] == '-') echo 'checked'; ?>>
                                    <label for="radioG2" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak Ada"></label>
                                    <span style="margin-left: 5px;" class="verified_PemberiLisensi" hidden>
                                        <input class="uraianPenandaan" type="radio" id="radioG2V" name="VRF[PemberiLisensi]" value="YES">
                                        <label for="radioG2V" style="width: 70px; height: 10px; background-color: #2F99CA" title="Sudah terverivikasi">Verifikasi</label>
                                        <input type="text" name="VRF[PemberiLisensi]" style="display: none;"></span>
                                    <input type="text" name="CHK[8]"  value="<?php echo $detail[7]; ?>" style="display: none;"  rel="required">
                                </td>
                            </tr>
                            <tr id="PemberiLisensi" hidden>
                                <td></td>
                                <td>&nbsp;<textarea class="PemberiLisensi uPenandaan" title="Uraian Penandaan" style="width: 34%; height: 45px;" name="URN[8]" id="CHK[8]"><?php echo $detail2[7]; ?></textarea></td>
                            </tr>
                            <tr><td style="background-color: white;">&nbsp;</td></tr>
                            <tr class="infoPenandaanKOSRow">
                                <td class="td_left_header_checklist" style="vertical-align: top">Expire Date </td>
                                <td class="td_left">
                                    <input class="uraianPenandaan" param="ExpDate" type="radio" id="radioH1" name="CHK[9]" value="+_Exp Date" <?php if ($d[8][0] == '+') echo 'checked'; ?>>
                                    <label for="radioH1" style="width: 70px; height: 10px;" title="Ada / Sesuai"></label>
                                    <span style="margin-left: 5px;"></span>
                                    <input class="uraianPenandaan" param="ExpDate" type="radio" id="radioH3" name="CHK[9]" value="X_Exp Date" <?php if ($d[8][0] == 'X') echo 'checked'; ?>>
                                    <label for="radioH3" style="width: 70px; height: 10px; background-color: #f1f600" title="Tidak Sesuai"></label>
                                    <span style="margin-left: 5px;"></span>
                                    <input class="uraianPenandaan" param="ExpDate" type="radio" id="radioH2" name="CHK[9]" value="-_Exp Date" <?php if ($d[8][0] == '-') echo 'checked'; ?>>
                                    <label for="radioH2" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak Ada"></label>
                                    <input type="text" name="CHK[9]"  value="<?php echo $detail[8]; ?>" style="display: none;" rel="required">
                                </td>
                            </tr>
                            <tr id="ExpDate" hidden>
                                <td></td>
                                <td><input type="checkbox" value="1" class="chkFreeExp" onclick="freeExp(this)" <?php if (strpos($detail2[8], "/") && $d[8][0] != '-') echo 'checked'; ?>> Kalender&nbsp;<input type="checkbox" value="2" class="chkFreeExp" onclick="freeExp(this)" <?php if (!strpos($detail2[8], "/") && $d[8][0] != '-') echo 'checked'; ?>> Teks&nbsp;<br /><input type="text" class="URN9_1 sdate ExpDate"  title="Tanggal Expired" value="<?php if (strpos($detail2[8], "/")) echo $detail2[8]; ?>"/><input type="text" class="URN9_2 stext ExpDate"  title="Tanggal Expired" value="<?php if (!strpos($detail2[8], "/")) echo $detail2[8]; ?>"/></td>
                            </tr>
                            <tr class="infoPenandaanKOSRow">
                                <td class="td_left_header_checklist" style="vertical-align: top">Komposisi </td>
                                <td class="td_left">
                                    <input class="uraianPenandaan" param="Komposisi" type="radio" id="radioI1" name="CHK[10]" value="+_Komposisi" <?php if ($d[9][0] == '+') echo 'checked'; ?>>
                                    <label for="radioI1" style="width: 70px; height: 10px;" title="Ada / Sesuai"></label>
                                    <span style="margin-left: 5px;"></span>
                                    <input class="uraianPenandaan" param="Komposisi" type="radio" id="radioI3" name="CHK[10]" value="X_Komposisi" <?php if ($d[9][0] == 'X') echo 'checked'; ?>>
                                    <label for="radioI3" style="width: 70px; height: 10px; background-color: #f1f600" title="Tidak Sesuai"></label>
                                    <span style="margin-left: 5px;"></span>
                                    <input class="uraianPenandaan" param="Komposisi" type="radio" id="radioI2" name="CHK[10]" value="-_Komposisi" <?php if ($d[9][0] == '-') echo 'checked'; ?>>
                                    <label for="radioI2" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak Ada"></label>
                                    <input type="text" name="CHK[10]"  value="<?php echo $detail[9]; ?>" style="display: none;"  rel="required">
                                </td>
                            </tr>
                            <tr id="Komposisi" hidden>
                                <td></td>
                                <td>&nbsp;<textarea class="Komposisi uPenandaan" title="Uraian Penandaan" style="width: 34%; height: 45px;" name="URN[10]" id="CHK[10]"><?php echo $detail2[9]; ?></textarea></td>
                            </tr>
                            <tr class="infoPenandaanKOSRow">
                                <td class="td_left_header_checklist" style="vertical-align: top">Kegunaan </td>
                                <td class="td_left">
                                    <input class="uraianPenandaan" param="Kegunaan" type="radio" id="radioJ11" name="CHK[11]" value="+_Kegunaan" <?php if ($d[10][0] == '+') echo 'checked'; ?>>
                                    <label for="radioJ11" style="width: 70px; height: 10px;" title="Ada / Sesuai"></label>
                                    <span style="margin-left: 5px;"></span>
                                    <input class="uraianPenandaan" param="Kegunaan" type="radio" id="radioJ13" name="CHK[11]" value="X_Kegunaan" <?php if ($d[10][0] == 'X') echo 'checked'; ?>>
                                    <label for="radioJ13" style="width: 70px; height: 10px; background-color: #f1f600" title="Tidak Sesuai"></label>
                                    <span style="margin-left: 5px;"></span>
                                    <input class="uraianPenandaan" param="Kegunaan" type="radio" id="radioJ12" name="CHK[11]" value="-_Kegunaan" <?php if ($d[10][0] == '-') echo 'checked'; ?>>
                                    <label for="radioJ12" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak Ada"></label>
                                    <input type="text" name="CHK[11]"  value="<?php echo $detail[10]; ?>" style="display: none;"  rel="required">
                                </td>
                            </tr>
                            <tr id="Kegunaan" hidden>
                                <td></td>
                                <td>&nbsp;<textarea class="Kegunaan uPenandaan" title="Uraian Penandaan" style="width: 34%; height: 45px;" name="URN[11]" id="CHK[11]"><?php echo $detail2[10]; ?></textarea></td>
                            </tr>
                            <tr class="infoPenandaanKOSRow">
                                <td class="td_left_header_checklist" style="vertical-align: top">Cara Penggunaan </td>
                                <td class="td_left">
                                    <input class="uraianPenandaan" param="CaraPenggunaan" type="radio" id="radioJ1" name="CHK[12]" value="+_Cara Penggunaan" <?php if ($d[11][0] == '+') echo 'checked'; ?>>
                                    <label for="radioJ1" style="width: 70px; height: 10px;" title="Ada / Sesuai"></label>
                                    <span style="margin-left: 5px;"></span>
                                    <input class="uraianPenandaan" param="CaraPenggunaan" type="radio" id="radioJ3" name="CHK[12]" value="X_Cara Penggunaan" <?php if ($d[11][0] == 'X') echo 'checked'; ?>>
                                    <label for="radioJ3" style="width: 70px; height: 10px; background-color: #f1f600" title="Tidak Sesuai"></label>
                                    <span style="margin-left: 5px;"></span>
                                    <input class="uraianPenandaan" param="CaraPenggunaan" type="radio" id="radioJ2" name="CHK[12]" value="-_Cara Penggunaan" <?php if ($d[11][0] == '-') echo 'checked'; ?>>
                                    <label for="radioJ2" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak Ada"></label>
                                    <input type="text" name="CHK[12]"  value="<?php echo $detail[11]; ?>" style="display: none;"  rel="required">
                                </td>
                            </tr>
                            <tr id="CaraPenggunaan" hidden>
                                <td></td>
                                <td>&nbsp;<textarea class="CaraPenggunaan uPenandaan" title="Uraian Penandaan" style="width: 34%; height: 45px;" name="URN[12]" id="CHK[12]"><?php echo $detail2[11]; ?></textarea></td>
                            </tr>
                            <tr class="infoPenandaanKOSRow">
                                <td class="td_left_header_checklist" style="vertical-align: top">Klaim </td>
                                <td class="td_left">
                                    <input class="uraianPenandaan" param="Klaim" type="radio" id="radioK1" name="CHK[13]" value="+_Klaim" <?php if ($d[12][0] == '+') echo 'checked'; ?>>
                                    <label for="radioK1" style="width: 70px; height: 10px;" title="Ada / Sesuai"></label>
                                    <span style="margin-left: 5px;"></span>
                                    <input class="uraianPenandaan" param="Klaim" type="radio" id="radioK3" name="CHK[13]" value="X_Klaim" <?php if ($d[12][0] == 'X') echo 'checked'; ?>>
                                    <label for="radioK3" style="width: 70px; height: 10px; background-color: #f1f600" title="Tidak Sesuai"></label>
                                    <span style="margin-left: 5px;"></span>
                                    <input class="uraianPenandaan" param="Klaim" type="radio" id="radioK2" name="CHK[13]" value="-_Klaim" <?php if ($d[12][0] == '-') echo 'checked'; ?>>
                                    <label for="radioK2" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak Ada"></label>
                                    <input type="text" name="CHK[13]"  value="<?php echo $detail[12]; ?>" style="display: none;"  rel="required">
                                </td>
                            </tr>
                            <tr id="Klaim" hidden>
                                <td></td>
                                <td>&nbsp;<textarea class="Klaim uPenandaan" title="Uraian Penandaan" style="width: 34%; height: 45px;" name="URN[13]" id="CHK[13]"><?php echo $detail2[12]; ?></textarea></td>
                            </tr>
                            <tr class="infoPenandaanKOSRow">
                                <td class="td_left_header_checklist" style="vertical-align: top">Peringatan / Perhatian </td>
                                <td class="td_left">
                                    <input class="uraianPenandaan" param="Peringatan" type="radio" id="radioL1" name="CHK[14]" value="+_Peringatan" <?php if ($d[13][0] == '+') echo 'checked'; ?>>
                                    <label for="radioL1" style="width: 70px; height: 10px;" title="Ada / Sesuai"></label>
                                    <span style="margin-left: 5px;"></span>
                                    <input class="uraianPenandaan" param="Peringatan" type="radio" id="radioL3" name="CHK[14]" value="X_Peringatan" <?php if ($d[13][0] == 'X') echo 'checked'; ?>>
                                    <label for="radioL3" style="width: 70px; height: 10px; background-color: #f1f600" title="Tidak Sesuai"></label>
                                    <span style="margin-left: 5px;"></span>
                                    <input class="uraianPenandaan" param="Peringatan" type="radio" id="radioL2" name="CHK[14]" value="-_Peringatan" <?php if ($d[13][0] == '-') echo 'checked'; ?>>
                                    <label for="radioL2" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak Ada"></label>
                                    <input type="text" name="CHK[14]"  value="<?php echo $detail[13]; ?>" style="display: none;"  rel="required">
                                </td>
                            </tr>
                            <tr id="Peringatan" hidden>
                                <td></td>
                                <td>&nbsp;<textarea class="Peringatan uPenandaan" title="Uraian Penandaan" style="width: 34%; height: 45px;" name="URN[14]" id="CHK[14]"><?php echo $detail2[13]; ?></textarea></td></tr>
                            <tr class="infoPenandaanKOSRow">
                                <td class="td_left_header_checklist" style="vertical-align: top">Kemasan Sekunder </td>
                                <td class="td_left">
                                    <input class="uraianPenandaan" param="Sekunder" type="radio" id="radioM1" name="CHK[15]" value="+_Kemasan Sekunder" <?php if ($d[14][0] == '+') echo 'checked'; ?>>
                                    <label for="radioM1" style="width: 70px; height: 10px;" title="Ada / Sesuai"></label>
                                    <span style="margin-left: 5px;"></span>
                                    <span style="margin-left: 100px;"></span>
                                    <input class="uraianPenandaan" param="Sekunder" type="radio" id="radioM2" name="CHK[15]" value="-_Kemasan Sekunder" <?php if ($d[14][0] == '-') echo 'checked'; ?>>
                                    <label for="radioM2" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak Ada"></label>
                                    <input type="text" name="CHK[15]"  value="<?php echo $detail[14]; ?>" style="display: none;"  rel="required">
                                </td>
                            </tr>
                            <tr><td style="background-color: white">&nbsp;</td></tr>
                            <tr></tr>
                            <!--Primer-->
                            <tr class="primer" hidden>
                                <td class="td_left_header_checklist" style="vertical-align: top"></td>
                                <td><b>Kemasan Primer :</b> </td>
                            </tr>
                            <tr class="primer" hidden>
                                <td></td>
                                <td class="td_left">
                                    <input type="radio" name="penandaan[1][Nasal_dekongestan]">
                                    <label style="width: 70px; height: 10px;" title="Ada / Sesuai">Ada / Sesuai</label>
                                    <span style="margin-left: 5px;"></span>
                                    <input  type="radio" name="penandaan[1][Nasal_dekongestan]">
                                    <label style="width: 70px; height: 10px; background-color: #f1f600" title="Tidak Sesuai">Tidak Sesuai</label>
                                    <span style="margin-left: 5px;"></span>
                                    <input  type="radio" name="penandaan[1][Nasal_dekongestan]" >
                                    <label style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak Ada">Tidak Ada</label>
                                </td>
                            </tr>
                            <tr class="primer infoPenandaanKOSRow" hidden>
                                <td>Nama Produk</td>
                                <td class="td_left">
                                    <input class="uraianPenandaanPrimer" type="radio" id="radioM1a" name="CHK[16]" value="+_Nama Produk pada Kemasan Primer" <?php if ($d[15][0] == '+') echo 'checked'; ?>>
                                    <label for="radioM1a" style="width: 70px; height: 10px;" title="Ada"></label>
                                    <span style="margin-left: 5px;"></span>
                                    <input class="uraianPenandaanPrimer" type="radio" id="radioM2a" name="CHK[16]" value="X_Nama Produk pada Kemasan Primer" <?php if ($d[15][0] == 'X') echo 'checked'; ?>>
                                    <label for="radioM2a" style="width: 70px; height: 10px; background-color: #f1f600" title="Tidak Sesuai"></label>
                                    <span style="margin-left: 5px;"></span>
                                    <input class="uraianPenandaanPrimer" type="radio" id="radioM3a" name="CHK[16]" value="-_Nama Produk pada Kemasan Primer" <?php if ($d[15][0] == '-') echo 'checked'; ?>>
                                    <label for="radioM3a" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak Ada"></label>
                                    <input type="text" name="CHK[16]" class="kemasanPrimer"  value="<?php echo $detail[15]; ?>" style="display: none;">
                                </td>
                            </tr>
                            <tr></tr>
                            <tr class="primer infoPenandaanKOSRow" hidden>
                                <td>No Bets</td>
                                <td class="td_left">
                                    <input class="uraianPenandaanPrimer" type="radio" id="radioM1b" name="CHK[17]" value="+_No Bets pada Kemasan Primer" <?php if ($d[16][0] == '+') echo 'checked'; ?>>
                                    <label for="radioM1b" style="width: 70px; height: 10px;" title="Ada"></label>
                                    <span style="margin-left: 5px;"></span>
                                    <input class="uraianPenandaanPrimer" type="radio" id="radioM2b" name="CHK[17]" value="X_No Bets pada Kemasan Primer" <?php if ($d[16][0] == 'X') echo 'checked'; ?>>
                                    <label for="radioM2b" style="width: 70px; height: 10px; background-color: #f1f600" title="Tidak Sesuai"></label>
                                    <span style="margin-left: 5px;"></span>
                                    <input class="uraianPenandaanPrimer" type="radio" id="radioM3b" name="CHK[17]" value="-_No Bets pada Kemasan Primer" <?php if ($d[16][0] == '-') echo 'checked'; ?>>
                                    <label for="radioM3b" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak Ada"></label>
                                    <input type="text" name="CHK[17]" class="kemasanPrimer"  value="<?php echo $detail[16]; ?>" style="display: none;">
                                </td>
                            </tr>
                            <tr></tr>
                            <tr class="primer infoPenandaanKOSRow" hidden>
                                <td>Netto</td>
                                <td class="td_left">
                                    <input class="uraianPenandaanPrimer" type="radio" id="radioM1c" name="CHK[18]" value="+_Netto pada Kemasan Primer" <?php if ($d[17][0] == '+') echo 'checked'; ?>>
                                    <label for="radioM1c" style="width: 70px; height: 10px;" title="Ada"></label>
                                    <span style="margin-left: 5px;"></span>
                                    <input class="uraianPenandaanPrimer" type="radio" id="radioM2c" name="CHK[18]" value="X_Netto pada Kemasan Primer" <?php if ($d[17][0] == 'X') echo 'checked'; ?>>
                                    <label for="radioM2c" style="width: 70px; height: 10px; background-color: #f1f600" title="Tidak Sesuai"></label>
                                    <span style="margin-left: 5px;"></span>
                                    <input class="uraianPenandaanPrimer" type="radio" id="radioM3c" name="CHK[18]" value="-_Netto pada Kemasan Primer" <?php if ($d[17][0] == '-') echo 'checked'; ?>>
                                    <label for="radioM3c" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak Ada"></label>
                                    <input type="text" name="CHK[18]" class="kemasanPrimer"  value="<?php echo $detail[16]; ?>" style="display: none;">
                                </td>
                            </tr>
                        </table>
                        <?php
                        $data = explode("^", $sess['LAMPIRAN']);
                        $jmldata = count($data);
                        ?>
                        <table  id="tb_Lamp" class="form_tabel">
                            <tr>
                                <td colspan="2"><h2 class="small garis">Lampiran&nbsp;<a href="javascript:void(0)" class="addLampiran" periksa="urut" terakhir="<?php echo $jmldata; ?>"><img src="<?php echo base_url(); ?>images/add.png" align="absmiddle" style="border:none" title="Tambah Lampiran" /></a></h2></td>
                            </tr>
                            <?php
                            if ($jmldata == 0) {
                                $jmldata = 1;
                                $data[] = "";
                            }
                            else
                                $arrDataLamp = explode("^", $sess['LAMPIRAN']);
                            $i = 0;
                            do {
                                if (array_key_exists('LAMPIRAN', $sess) && trim($sess['LAMPIRAN']) != "") {
                                    $arrLamp = explode(".", $arrDataLamp[$i]);
                                    ?>
                                    <tr>
                                             <!--<td class="td_left_checklist" style="vertical-align: top">37</td>-->
                                        <td class="td_left_header_checklist" colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="file_FILE_PENANDAAN_KOS<?php echo $i; ?>"><input type="hidden" name="PENANDAAN_KOS[]" value="<?php echo $arrDataLamp[$i]; ?>"><a href="<?php echo base_url(); ?>files/<?php echo 'penandaan_012'; ?>/<?php echo $arrDataLamp[$i]; ?>" target="_blank" <?php if ($arrLamp[1] == "rar") echo 'onclick="dotRar();return false;"'; ?>>File Lampiran</a>&nbsp;&bull;&nbsp;<a href="#" class="del_upload" url="<?php echo site_url(); ?>/utility/uploads/del_upload_s/<?php echo 'penandaan_012/'; ?><?php echo $arrDataLamp[$i]; ?>" jns="FILE_PENANDAAN_KOS<?php echo $i; ?>">Edit atau Hapus File ?</a></span><span class="upload_FILE_PENANDAAN_KOS<?php echo $i; ?>" hidden><input type="file" jenis="FILE_PENANDAAN_KOS<?php echo $i; ?>" allowed="jpg-jpeg-pdf-doc-docx-rar" url="<?php echo site_url(); ?>/utility/uploads/get_upload_s/<?php echo 'penandaan_012'; ?>" id="fileToUpload_FILE_PENANDAAN_KOS<?php echo $i; ?>" name="userfile" onchange="do_upload($(this));
                                                    return false;" />
                                                &nbsp;Tipe File : *.jpg .jpeg .pdf .doc .docx .rar</span></td>
                                    </tr>
                                    <?php
                                } else {
                                    ?>
                                    <tr>
                                        <td class="td_left_header_checklist" colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="upload_FILE_PENANDAAN_KOS"><input type="file" class="upload upKOS" jenis="FILE_PENANDAAN_KOS" allowed="jpg-jpeg-pdf-doc-docx-rar" url="<?php echo site_url(); ?>/utility/uploads/get_upload_s/<?php echo 'penandaan_012'; ?>" id="fileToUpload_FILE_PENANDAAN_KOS" name="userfile" onchange="do_upload($(this));
                                                    return false;" />
                                                &nbsp;Tipe File : *.jpg .jpeg .pdf .doc .docx .rar</span><span class="file_FILE_PENANDAAN_KOS"></span></td>
                                    </tr>
                                    <?php
                                }
                                $i++;
                            } while ($i < $jmldata);
                            ?>
                        </table>
                        <table class="form_tabel" style="width: 100%;">
                            <tr><td colspan="3">&nbsp;</td></tr>
                            <?php
                            $dataAsal = "y";
                            if (!in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')) && trim($sess['PUSAT']) == "") {
                                $dataAsal = "x";
                                ?>
                                <tr>
                                    <td class="td_left">Kesimpulan</td>
                                    <td class="td_left">
                                        <select id="kesimpulanHasilPenilaianVal" name="HASIL" rel="required" class="stext" title="Kesimpulan" style="margin-left: 40%"><option value=""></option><option value="MS" <?php if ($sess['SISTEM'] == "MS") echo "selected"; ?>>Memenuhi Syarat</option><option value="TMS" <?php if ($sess['SISTEM'] == "TMS") echo "selected"; ?>>Tidak Memenuhi Syarat</option><option value="TIE" <?php if ($sess['SISTEM'] == "TIE") echo "selected"; ?>>Tidak Memiliki Izin Edar</option></select></td>
                                    <td colspan="3"></td>
                                </tr>
                                <tr class="TDKB" hidden><td class="td_left">Tindak Lanjut Balai</td><td class="td_left"><?php echo form_dropdown('PENANDAAN[TL_BALAI]', $cb_tindakan_balai, $sess['TL_BALAI'], 'class="stext TDKB" id="tDKBalai" title="Tindak Lanjut Balai"  style="margin-left: 40%"'); ?></td>
                                    <td colspan="3"></td></tr><?php } ?>
                        </table>
                    </div>
                </div>

                <!--7-->
                <?php if (in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) { ?>
                    <div style="height:5px;"></div>
                    <div class="expand"><a title="expand/collapse" href="#" style="display: block;">KESIMPULAN</a></div>
                    <div class="collapse">
                        <div class="accCntnt">
                            <table class="form_tabel" style="width: 100%;">
                                <?php
                                $pusat = explode("*", $sess['PUSAT']);
                                $justifikasi = preg_replace('/(?:<|&lt;)\/?([a-zA-Z]+) *[^<\/]*?(?:>|&gt;)/', '', $pusat[2]) . "\n";
                                if ((trim($sess['PUSAT']) == "" && in_array('2', $this->newsession->userdata('SESS_KODE_ROLE'))) || $editTL == 'YES') {
                                    ?>
                                    <tr><td class="td_left">Verifikasi Pusat</td><td class="td_right"><select class="stext" id="verifikasiPusat" name="<?php echo 'PENANDAAN[HASIL_PUSAT]' ?>" rel="required" title="MS/TMS"><option></option><option value="MS" <?php if ($pusat[0] == 'MS') echo 'Selected' ?>>Memenuhi Syarat</option><option value="TMS"  <?php if ($pusat[0] == 'TMS') echo 'Selected' ?>>Tidak Memenuhi Syarat</option><option value="TIE"  <?php if ($pusat[0] == 'TIE') echo 'Selected' ?>>Tidak Memiliki Izin Edar</option></select></td></tr>
                                    <tr class="vTMK" hidden><td class="td_left"style="background-color: white;">Tindak Lanjut</td><td class="td_right" style="background-color: white;"><?php echo form_dropdown('PENANDAAN[TL_PUSAT]', $cb_tindakan, is_array($pusat) ? $pusat[1] : '', 'class="stext vTMK" id="vTMKSub" title="Tindak Lanjut Pusat"'); ?></td></tr>
                                    <tr class="vJustifikasi" hidden><td class="td_left" style="background-color: white;">Justifikasi</td><td class="td_right" style="background-color: white;"><textarea name="JUSTIFIKASI" title="Justifikasi Pusat" class="stext chkJustifikasi" id="XXX" style="height: 140px;"><?php echo $justifikasi; ?></textarea></td></tr> <?php
                                }else {
                                    if ($pusat[0] == "TMS") {
                                        ?>
                                        <tr><td class="td_left">Verifikasi Pusat</td><td><b><i><?php
                                                        echo 'Tidak Memenuhi Syarat';
                                                        ?></i></b></td></tr><?php if (trim($pusat[1]) != "") { ?>
                                            <tr><td class="td_left">Tindak Lanjut Pusat</td><td><?php echo $pusat[1]; ?></td></tr>
                                        <?php } if (trim($pusat[2]) != "") { ?>
                                            <tr><td class="td_left">Justifikasi Pusat</td><td><?php echo $justifikasi; ?></td></tr>
                                            <?php
                                        }
                                    } else {
                                        ?>
                                        <tr><td class="td_left">Verifikasi Pusat</td><td><b><i><?php
                                                        echo 'Memenuhi Syarat';
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
                    <div style="height:5px;"></div>
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

                <div style="padding:10px;"></div><div><a href="javascript:void(0)" id="btnSave" class="button <?php echo $icon; ?>" onclick="fpost('#fpengawasanPenandaan_012', '', '');">
                        <span><span class="icon"></span>&nbsp; <?php echo $labelSimpan; ?></span></a>&nbsp;
                    <a href="javascript:void(0)" class="button reload" onclick="goBack()" >
                        <span><span class="icon"></span>&nbsp; Batal</span></a></div>
                <br />
                <br />
                <input type="hidden" name="PENANDAAN_ID[]" value="<?php echo $sess['PENANDAAN_ID']; ?>" />
                <input type="hidden" name="KLASIFIKASIPENANDAAN" value="<?php echo $klasifikasi; ?>" />
                <input type="hidden" name="UPDATE" value="<?php echo $sess['STATUS']; ?>" />
                <input type="hidden" name="EDIT" value="<?php echo $editTL; ?>" />
                <input type="hidden" name="TUJUAN" value="<?php echo $tujuan; ?>" />
            </div>
        </div>
    </form>
</div>

<script type="text/javascript">
                                        function goBack()
                                        {
                                            window.history.back()
                                        }
                                        function showHide() {
                                            var impor = $("#NIE").val().substring(0, 4);
                                            if (impor !== 'NA18') {
                                                $('.importirBased').show();
                                                $('.importirBased').attr("hidden", false);
                                                $('#importirBasedTxt').attr('rel', 'required');
                                            } else if (impor !== 'I') {
                                                $('.importirBased').hide();
                                                $('.importirBased').attr("hidden", true);
                                                $('#importirBasedTxt').attr('rel', '');
                                            }
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
                                                            if (arrdata[2] !== "") {
                                                                var arrFile = arrdata[0].split("."), strFile = "";
                                                                if (arrFile[1] == "rar")
                                                                    strFile = 'onclick="dotRar();return false;"';
                                                                $("#fileToUpload_" + arrdata[2] + "").removeAttr("rel");
                                                                $(".upload_" + arrdata[2] + "").hide();
                                                                $(".file_" + arrdata[2] + "").html("<b>1 File telah dilampirkan. </b>&nbsp;<a href=\"<?php echo base_url(); ?>files/" + arrdata[3] + "/" + arrdata[0] + "\" target=\"_blank\"" + strFile + ">Tampilkan File</a>&nbsp;&bull;&nbsp;<a href=\"#\" class=\"del_upload\" url=\"<?php echo site_url(); ?>/utility/uploads/del_upload_s/" + arrdata[3] + "/" + arrdata[0] + "\" jns=" + arrdata[2] + ">Edit atau Hapus File ?</a><input type=\"hidden\" name=\"PENANDAAN_KOS[]\" value=" + arrdata[0] + ">");
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
                                        function cekLampiran() {
<?php if (!in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) { ?>
                                                var kesimpulan = $('#kesimpulanHasilPenilaianVal').val();
                                                if (kesimpulan === 'TMS') {
                                                    $('.upload').attr('rel', 'required');
                                                } else {
                                                    $('.upload').attr('rel', '');
                                                    $(".upload").css("background-color", "#FFF");
                                                    $(".upload").css("border", "");
                                                }
<?php } else { ?>
                                                var kesimpulan = $('#verifikasiPusat').val();
                                                if (kesimpulan === 'TMS') {
                                                    $('.upload').attr('rel', 'required');
                                                } else {
                                                    $('.upload').attr('rel', '');
                                                    $(".upload").css("background-color", "#FFF");
                                                    $(".upload").css("border", "");
                                                }
<?php } ?>
                                        }
                                        function verifikasiPusat(X) {
                                            if ($(X).val() === "MS") {
                                                $(".vTMK").hide();
                                                $(".vTMK").attr("rel", " ");
                                                $(".vTMK").val("");
                                                $(".vTMK2").hide("slow");
                                                $(".vTMK2").val("");
                                                $(".vTMK2").attr("rel", "");
                                                $(".vTMK2a").val("");
                                            }
                                            else if ($(X).val() === "TMS") {
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
<?php if (!in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) { ?>
                                                    if ($(X).val() != $("#kesimpulanHasilPenilaianVal").val()) {
                                                        $(".vJustifikasi").show("slow");
                                                        $(".chkJustifikasi").attr("rel", "required");
                                                    } else if ($(X).val() == $("#kesimpulanHasilPenilaianVal").val()) {
                                                        $(".vJustifikasi").hide("slow");
                                                        $(".chkJustifikasi").attr("rel", "");
                                                    }
<?php } ?>
                                            } else {
                                                $(".vJustifikasi").hide("slow");
                                                $(".chkJustifikasi").attr("rel", "");
                                            }
                                            cekLampiran();
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
                                        function borderLess(obj) {
                                            $(obj).closest("td").css('border-left', '0px solid #F00');
                                        }
                                        function isiValue(obj) {
                                            var A, param, name;
                                            var nie = $("#NIE").val(), produsen = $("#produsen").val(), almtProdusen = $("#alamatProdusen").val(), btkSediaan = $('#bentukSediaan').val(), kemasan = $('#kemasan').val(), kegunaan = $('#kategoriProduk').val(), importir = $('#importir').val(), almtImportir = $('#alamatImportir').val(), lisensi = $('#lisensi').val(), almtLisensi = $('#alamatLisensi').val(), pengemas = $('#pengemas').val(), almtPengemas = $('#alamatPengemas').val(), pemohon = $('#pemohon').val(), almtpemohon = $('#alamatPemohon').val();
                                            if (typeof obj === "object") {
                                                A = obj.val().split('_');
                                                name = $(obj).attr("name");
                                                if (A[1] === 'NIE') {
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
                                                    if (produsen !== "" && A[0] === '+') {
                                                        $("[id='" + name + "']").val(importir + "; " + almtImportir);
                                                        $("[id='" + name + "']").attr("readonly", true);
                                                    }
                                                    else if (produsen !== "" && A[0] === 'X') {
                                                        $("[id='" + name + "']").val("");
                                                        $("[id='" + name + "']").attr("readonly", false);
                                                    }
                                                }
                                                else if (A[1] === 'Distributor') {
                                                    if (produsen !== "" && produsen !== "-" && A[0] === '+') {
                                                        $("[id='" + name + "']").val(pengemas + "; " + almtPengemas);
                                                        $("[id='" + name + "']").attr("readonly", true);
                                                    }
                                                    else if (produsen !== "" && produsen === "-" && A[0] === '+') {
                                                        $("[id='" + name + "']").val("-");
                                                        $("[id='" + name + "']").attr("readonly", true);
                                                    }
                                                    else {
                                                        $("[id='" + name + "']").val("");
                                                        $("[id='" + name + "']").attr("readonly", false);
                                                    }
                                                }
                                                else if (A[1] === 'Pemberi Lisensi') {
                                                    if (lisensi !== "" && lisensi !== "-" && A[0] === '+') {
                                                        $("[id='" + name + "']").val(lisensi + "; " + almtLisensi);
                                                        $("[id='" + name + "']").attr("readonly", true);
                                                    }
                                                    else if (lisensi !== "" && lisensi === "-" && A[0] === '+') {
                                                        $("[id='" + name + "']").val("-");
                                                        $("[id='" + name + "']").attr("readonly", true);
                                                    }
                                                    else {
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
                                                        $("[id='" + name + "']").attr("readonly", true);
                                                    }
                                                    else if (kemasan !== "" && A[0] === 'X') {
                                                        $("[id='" + name + "']").val("");
                                                        $("[id='" + name + "']").attr("readonly", false);
                                                    }
                                                }
                                                else if (A[1] === 'Kegunaan') {
                                                    if (kegunaan !== "" && A[0] === '+') {
                                                        $("[id='" + name + "']").val(kegunaan);
                                                        $("[id='" + name + "']").attr("readonly", true);
                                                    }
                                                    else if (kegunaan !== "" && A[0] === 'X') {
                                                        $("[id='" + name + "']").val("");
                                                        $("[id='" + name + "']").attr("readonly", false);
                                                    }
                                                }
                                                else if (A[1] === 'Pemohon Notifikasi') {
                                                    if (pemohon !== "" && A[0] === '+') {
                                                        $("[id='" + name + "']").val(pemohon + "; " + almtpemohon);
                                                        $("[id='" + name + "']").attr("readonly", true);
                                                    }
                                                    else if (pemohon !== "" && A[0] === 'X') {
                                                        $("[id='" + name + "']").val("");
                                                        $("[id='" + name + "']").attr("readonly", false);
                                                    }
                                                }
                                            } else {
                                                $(".uraianPenandaan").each(function() {
                                                    if ($(this).attr("checked") === true) {
                                                        A = $(this).val().split('_');
                                                        name = $(this).attr("name");
                                                        if (A[1] === 'NIE') {
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
                                                            if (produsen !== "" && A[0] === '+') {
                                                                $("[id='" + name + "']").val(importir + "; " + almtImportir);
                                                                $("[id='" + name + "']").attr("readonly", true);
                                                            }
                                                            else if (produsen !== "" && A[0] === 'X') {
                                                                $("[id='" + name + "']").val("");
                                                                $("[id='" + name + "']").attr("readonly", false);
                                                            }
                                                        }
                                                        else if (A[1] === 'Distributor') {
                                                            if (produsen !== "" && produsen !== "-" && A[0] === '+') {
                                                                $("[id='" + name + "']").val(pengemas + "; " + almtPengemas);
                                                                $("[id='" + name + "']").attr("readonly", true);
                                                            }
                                                            else if (produsen !== "" && produsen === "-" && A[0] === '+') {
                                                                $("[id='" + name + "']").val("-");
                                                                $("[id='" + name + "']").attr("readonly", true);
                                                            }
                                                            else {
                                                                $("[id='" + name + "']").val("");
                                                                $("[id='" + name + "']").attr("readonly", false);
                                                            }
                                                        }
                                                        else if (A[1] === 'Pemberi Lisensi') {
                                                            if (lisensi !== "" && lisensi !== "-" && A[0] === '+') {
                                                                $("[id='" + name + "']").val(lisensi + "; " + almtLisensi);
                                                                $("[id='" + name + "']").attr("readonly", true);
                                                            }
                                                            else if (lisensi !== "" && lisensi === "-" && A[0] === '+') {
                                                                $("[id='" + name + "']").val("-");
                                                                $("[id='" + name + "']").attr("readonly", true);
                                                            }
                                                            else {
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
                                                                $("[id='" + name + "']").attr("readonly", true);
                                                            }
                                                            else if (kemasan !== "" && A[0] === 'X') {
                                                                $("[id='" + name + "']").val("");
                                                                $("[id='" + name + "']").attr("readonly", false);
                                                            }
                                                        }
                                                        else if (A[1] === 'Kegunaan') {
                                                            if (kegunaan !== "" && A[0] === '+') {
                                                                $("[id='" + name + "']").val(kegunaan);
                                                                $("[id='" + name + "']").attr("readonly", true);
                                                            }
                                                            else if (kegunaan !== "" && A[0] === 'X') {
                                                                $("[id='" + name + "']").val("");
                                                                $("[id='" + name + "']").attr("readonly", false);
                                                            }
                                                        }
                                                        else if (A[1] === 'Pemohon Notifikasi') {
                                                            if (pemohon !== "" && A[0] === '+') {
                                                                $("[id='" + name + "']").val(pemohon + "; " + almtpemohon);
                                                                $("[id='" + name + "']").attr("readonly", true);
                                                            }
                                                            else if (pemohon !== "" && A[0] === 'X') {
                                                                $("[id='" + name + "']").val("");
                                                                $("[id='" + name + "']").attr("readonly", false);
                                                            }
                                                        }
                                                    }
                                                });
                                            }
                                        }
                                        function tindakLanjutBalai(obj) {
                                            if ($(obj).val() == "TMS") {
                                                $(".TDKB").show();
                                                $("#tDKBalai").attr("rel", "required");
                                                $("#fileToUpload_FILE_PENANDAAN_KOS").attr("rel", "required");
                                            } else {
                                                $(".TDKB").hide();
                                                $(".TDKB").val("");
                                                $("#tDKBalai").attr("rel", "");
                                                $("#fileToUpload_FILE_PENANDAAN_KOS").attr("rel", "");
                                            }
                                        }
                                        function freeExp(obj) {
                                            var val = $(obj).val();
                                            if (val == "1") {
                                                $(".URN9_1").show();
                                                $(".URN9_1").attr("rel", "required");
                                                $(".URN9_1").attr("name", "URN[9]");
                                                $(".URN9_2").hide();
                                                $(".URN9_2").attr("rel", "");
                                                $(".URN9_2").attr("name", "");
                                            } else if (val == "2") {
                                                $(".URN9_1").hide();
                                                $(".URN9_1").attr("rel", "");
                                                $(".URN9_1").attr("name", "");
                                                $(".URN9_2").show();
                                                $(".URN9_2").attr("rel", "required");
                                                $(".URN9_2").attr("name", "URN[9]");
                                            }
                                        }
                                        $(document).ready(function() {
                                            var verification = 0;
                                            $("textarea.chkJustifikasi").redactor({
                                                buttons: ['bold', 'italic', '|', 'unorderedlist', 'orderedlist', 'outdent', 'indent', '|', 'alignleft', 'aligncenter', 'alignright', 'justify'],
                                                removeStyles: false,
                                                cleanUp: true,
                                                autoformat: true
                                            });
//                      Load data
<?php
if (array_key_exists("PENANDAAN_ID", $sess)) {
    if ($sess['PENILAIAN'] != '') {
        ?>
                                                    $(".uraianPenandaan").each(function() {
                                                        if ($(this).is(':checked')) {
                                                            verification++;
                                                            borderLess($(this));
                                                            checkListTxt($(this));
                                                        }
                                                    });
                                                    $('.chkFreeExp').each(function() {
                                                        if ($(this).is(':checked'))
                                                            freeExp($(this));
                                                    });
        <?php if (in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) { ?>
                                                        verifikasiPusat($("#verifikasiPusat"));
        <?php } ?>
                                                    tindakLanjutBalai($("#kesimpulanHasilPenilaianVal"))
    <?php }
    ?>
                                                showHide();
<?php }
?>
                                            $("input.namaKosmetikaJadi").autocomplete($("input.namaKosmetikaJadi").attr("url") + 'kos', {width: 244, selectFirst: false});
                                            $("input.namaKosmetikaJadi").result(function(event, data, formatted) {
                                                if (data) {
                                                    var impor = data[2].substring(0, 4);
                                                    if (impor !== 'NA18') {
                                                        $('#importir').val(data[3]);
                                                        $('#alamatImportir').val(data[5]);
                                                    }
                                                    else if (impor === 'NA18') {
                                                        $('#importir').val("-");
                                                        $('#alamatImportir').val("-");
                                                    }
                                                    $('#namaKosmetikaJadi').val(data[1]);
                                                    $('#NIE').val(data[2]);
                                                    $('#pemohon').val(data[3]);
                                                    $('#alamatPemohon').val(data[5]);
                                                    $('#bentukSediaan').val(data[9]);
                                                    $('#kegunaan').val(data[12]);
                                                    $('#produsen').val(data[6]);
                                                    $('#alamatProdusen').val(data[11]);
                                                    var jenis = data[12].split('-'), val = [];
                                                    for (var i = 0; i < jenis.length; i++)
                                                        val.push(jenis[i]);
                                                    val = "" + val;
                                                    $("#kategoriProduk").val(val.replace(/,/g, ", "));
                                                    showHide();
                                                    isiValue("N");
                                                }
                                            });
                                            $('#namaKosmetikaJadi').keyup(function() {
                                                if ($('#namaKosmetikaJadi').val() === '') {
                                                    $('#namaKosmetikaJadi').val('');
                                                    $('#NIE').val('');
                                                    $('#bentukSediaan').val('');
                                                    $('#kegunaan').val('');
                                                    $('#pendaftar').val('');
                                                    $('#pemohon').val('');
                                                    $('#produsen').val('');
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
                                            $('input.sdate').datepicker({dateFormat: 'dd/mm/yy', regional: 'id'});
                                            function checkListTxt(XXX) {
                                                var A = XXX.val().split('_');
                                                var param = XXX.attr('param');
                                                var name = $(XXX).attr("name");
                                                var arrParam = ["Produsen", "Importir", "Distributor", "PemberiLisensi", "PemohonNotifkos"];
                                                if (A[0] === '+' || A[0] === 'X') {
                                                    if (param === 'Sekunder') {
                                                        $('.primer').show();
                                                        $('#' + param).hide();
                                                        $('.kemasanPrimer').attr("rel", "required");
                                                    }
                                                    else if (param == "ExpDate") {
                                                        $('#' + param).show();
                                                        $(".ExpDate").attr("name", "");
                                                        $(".URN9_1").hide();
                                                        $(".URN9_1").attr("rel", "");
                                                        $(".URN9_2").hide();
                                                        $(".URN9_2").attr("rel", "");
//              if (A[0] === '+') {
//               $(".URN9_1").show();
//               $(".URN9_1").attr("rel", "required");
//               $(".URN9_1").attr("name", "URN[9]");
//               $(".URN9_2").hide();
//               $(".URN9_2").attr("rel", "");
//              } else if (A[0] === 'X') {
//               $(".URN9_1").hide();
//               $(".URN9_1").attr("rel", "");
//               $(".URN9_2").show();
//               $(".URN9_2").attr("rel", "required");
//               $(".URN9_2").attr("name", "URN[9]");
//              }
                                                    }
                                                    else {
                                                        $('#' + param).show();
                                                        if ($.inArray(param, arrParam) > -1) {
                                                            if (A[0] === '+') {
                                                                if (verification == 0) {
                                                                    jAlert("Verifikasi ulang apakah benar sudah sesuai dengan label yang diawasi");
                                                                    $("input[type='text'][name='VRF[" + param + "]']").attr("rel", "required");
                                                                    $('.verified_' + param).fadeIn("slow");
                                                                }
                                                            }
                                                            else {
                                                                $('.verified_' + param).hide();
                                                                $("input[type='text'][name='VRF[" + param + "]']").attr("rel", "");
                                                                $("input[type='radio'][name='VRF[" + param + "]']").attr("checked", false);
                                                                $("input[type='text'][name='VRF[" + param + "]']").val("");
                                                            }
                                                        }
                                                    }
                                                    $("[id='" + name + "']").attr("rel", "required");
                                                }
                                                else {
                                                    $('#' + param).hide();
                                                    $("input[type='text'][name='VRF[" + param + "]']").attr("rel", "");
                                                    $("input[type='text'][name='VRF[" + param + "]']").val("");
                                                    $("input[type='radio'][name='VRF[" + param + "]']").attr("checked", false);
                                                    $('.verified_' + param).hide();
                                                    if (XXX.val() === '-_Kemasan Sekunder') {
                                                        $('.primer').hide();
                                                        $('.kemasanPrimer').attr("rel", "");
                                                    }
                                                    $("[id='" + name + "']").attr("rel", "");
                                                }
//      mkTmk();
                                                cekLampiran();
                                            }
//    function mkTmk() {
//      var X = false;
//      $('.uraianPenandaan').each(function() {
//        if ($(this).is(":checked") === true) {
//          var a = $(this).val().split('_');
//          var b = $(this).attr('name');
//          if ((a[0] === '-' || a[0] === 'X') && b !== 'CHK[14]') {
//            X = true;
//          }
//        }
//      });
//      if (X === true) {
//        $("#TDKB").show();
//        $("#fileToUpload_FILE_PENANDAAN_OT").attr("rel", "required");
//      } else if (X !== true) {
//        $("#TDKB").hide();
//        $("#TDKB").val("");
//        $("#fileToUpload_FILE_PENANDAAN_OT").attr("rel", "");
//      }
//      cekLampiran();
//    }
                                            $(".uraianPenandaan").click(function() {
                                                verification = 0;
                                                var name = $(this).attr("name");
                                                var param = $(this).attr('param');
                                                var selected = $("input[type='radio'][name='" + name + "']:checked").val();
                                                $("input[type='text'][name='" + name + "']").val(selected);
                                                if ($("." + param).attr('type') == "textarea")
                                                    $("." + param).text('');
                                                else
                                                    $("." + param).val('');
                                                if (param == 'ExpDate') {
                                                    $(".chkFreeExp").attr("checked", false);
                                                    $(".ExpDate").val('');
                                                }
                                                borderLess($(this));
                                                checkListTxt($(this));
                                                isiValue($(this));
                                                verifikasiPusat($("#verifikasiPusat"));
                                                verifikasiTL($("#vTMKSub"));
                                            });
                                            $(".uraianPenandaanPrimer").click(function() {
                                                var name = $(this).attr("name");
                                                var selected = $("input[type='radio'][name='" + name + "']:checked").val();
                                                $("input[type='text'][name='" + name + "']").val(selected);
                                                borderLess($(this));
                                                cekLampiran();
                                            });
                                            $("#verifikasiPusat").change(function() {
                                                $(".chkJustifikasi").text("");
                                                $(".vJustifikasi .redactor_box .redactor_frame").contents().find("#page").html("<p>&nbsp;</p>");
                                                verifikasiPusat($(this));
                                            });
                                            $("#vTMKSub").change(function() {
                                                verifikasiTL($(this));
                                            });
                                            $("#NIE").change(function() {
                                                $(this).val($(this).val().toUpperCase());
                                                showHide();
                                            });
                                            $("#detail_petugas").html("Loading ...");
                                            $("#detail_petugas").load($("#detail_petugas").attr("url"));
                                            $(".del_upload").live("click", function() {
                                                var jenis = $(this).attr("jns");
                                                var param = jenis.substr(0, 23);
                                                $.ajax({
                                                    type: "GET",
                                                    url: $(this).attr("url"),
                                                    data: $(this).serialize(),
                                                    success: function(data) {
                                                        var arrdata = data.split("#");
                                                        $(".upload_" + jenis + "").show();
                                                        $("#fileToUpload_" + jenis + "").val('');
                                                        $(".file_" + jenis + "").html("");
                                                        if (param !== "FILE_LAMPIRAN_PENANDAAN")
                                                            $("#fileToUpload_" + jenis + "").attr("rel", "");
                                                    }
                                                });
                                                return false;
                                            });
                                            $("#kesimpulanHasilPenilaianVal").change(function() {
                                                tindakLanjutBalai($(this));
                                            });
                                            $('.addLampiran').click(function() {
                                                var nom = $(this).attr('terakhir');
                                                $("#tb_Lamp").append('<tr id= "id_' + nom + '"><td class="td_left_header_checklist" colspan="2"><a href="javascript:void(0)" class="min" id="minCls' + nom + '" ><img src="<?php echo base_url(); ?>images/cancel.png" align="top" style="border:none" title="Hapus Lampiran" /></a>&nbsp;<span class="upload_FILE_PENANDAAN_KOS' + nom + '"><input type="file" class="upload upKOS" jenis="FILE_PENANDAAN_KOS' + nom + '" allowed="jpg-jpeg-pdf-doc-docx-rar" url="<?php echo site_url(); ?>/utility/uploads/get_upload_s/<?php echo 'penandaan_012'; ?>" id="fileToUpload_FILE_PENANDAAN_KOS' + nom + '" name="userfile" onchange="do_upload($(this));return false;" />&nbsp;Tipe File : *.jpg .jpeg .pdf .doc .docx .rar</span><span class="file_FILE_PENANDAAN_KOS' + nom + '"></span></td></tr>');
                                                $(this).attr('terakhir', parseInt(nom) + 1);
                                                $("#minCls" + nom).click(function() {
                                                    $('#id_' + nom).remove();
                                                });
                                            });
                                            $(".URN9_2").keydown(function(e)
                                            {
                                                if (e.keyCode == "191") {
                                                    jAlert("Penggunaan simbol '/' & '?' tidak diperbolehkan");
                                                    return false;
                                                }
                                            });
                                            $(".chkFreeExp").click(function() {
                                                $(".chkFreeExp").attr("checked", false);
                                                $(".ExpDate").val('');
                                                $(this).attr("checked", true);
                                                freeExp($(this));
                                            });
                                        });</script>