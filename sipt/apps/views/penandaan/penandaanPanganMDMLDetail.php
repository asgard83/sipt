<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
?>
<link type="text/css" href="<?php echo base_url(); ?>css/iklanPenandaan.css" rel="stylesheet" media="screen"/>
<div id="judulpmnpdd" class="judul"></div>
<div class="headersarana">PENGAWASAN PENANDAAN - PANGAN MD / ML</div>
<?php
$detail = explode('#', $sess['PENILAIAN']);
foreach ($detail as $k) {
    $d[] = explode('_', $k);
}
$detail2 = explode('^', $sess['URAIAN']);
?>
<div class="content">
    <form action="<?php echo $act; ?>" method="post" autocomplete="off" id="fpengawasanPenandaan_013">
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
                        <table class="form_tabel">
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
                            <tr>
                                <td class="td_left">Jenis Pengawasan</td><td class="td_right"><select name="JENIS_PENGAWASAN" class="stext" id="jenisPengawasan" rel="required" title="Jenis Pengawasan"><option></option><option value="Halal" <?php if ($sess["JENIS_PENGAWASAN"] == "Halal") echo 'selected'; ?>>Halal</option><option value="Rutin" <?php if ($sess["JENIS_PENGAWASAN"] == "Rutin") echo 'selected'; ?>>Rutin</option></select></td>
                            </tr>
                        </table>
                    </div>
                </div><!-- Akhir Pemeriksaan !-->
                <div style="height:5px;"></div>
                <div class="acco2"><div class="expand"><a title="expand/collapse" href="#" style="display: block;">INFORMASI PANGAN - PENANDAAN</a></div>
                    <div class="collapse">
                        <div class="accCntnt">
                            <table class="form_tabel">
                                <tr>
                                    <td class="td_left">Nama Produk </td><td class="td_right"><input type="text" size="45" class="namaPanganJadi" id="namaPanganJadi" url="<?php echo site_url(); ?>/autocompletes/autocomplete/produk_reg_2/" title="Nama Produk" rel="required" name="PENANDAANPRODUK[NAMA_PRODUK]" value="<?php echo $sess['NAMA_PRODUK'] ?>" /><br /><input type="checkbox" id="checkboxTie" name="PENANDAANPRODUK[TIE]" <?php if (trim($sess['TIE']) == "1") echo "checked"; ?> style="margin-top: 2%;"/> Produk TIE</td>
                                    <td class="td_left">Nomor Izin Edar</td><td class="td_right"><input type="text" size="45" id="NIE" title="NIE" title="Nomor Izin Edar" name="PENANDAANPRODUK[NIE]" value="<?php echo $sess['NOMOR_IZIN_EDAR'] ?>" /></td>
                                </tr>
                                <tr>
                                    <td class="td_left">Merk Pangan</td><td class="td_right"><input type="text" size="45" id="merk" title="Merk Pangan" name="PENANDAANPRODUK[MERK_PRODUK]" value="<?php echo $sess['MERK_PRODUK'] ?>" /></td>
                                    <td class="td_left">Kemasan (Netto)</td><td class="td_right"><input type="text" size="45" id="kemasan" title="Kemasan" name="PENANDAANPRODUK[BESAR_KEMASAN]" value="<?php echo $sess['BESAR_KEMASAN'] ?>"/></td>
                                </tr>
                                <tr>
                                    <td class="td_left">Produsen</td><td class="td_right"><input type="text" size="45" id="produsen" title="Nama Produsen" name="PENANDAANPRODUK[PRODUSEN]" value="<?php echo $sess['PRODUSEN'] ?>"/></td>
                                    <td class="td_left">Importir / Distributor</td><td class="td_right"><input type="text" size="45" id="importir" title="Nama Importir / Produsen" name="PENANDAANPRODUK[IMPORTIR]"  value="<?php echo $sess['IMPORTIR'] ?>"/></td>
                                </tr>
                                <tr>
                                    <td class="td_left">Alamat Produsen</td><td class="td_right"><textarea id="alamatProdusen" class="stext" style="height: 50px; width: 285px;" title="Alamat Produsen" name="PENANDAANPRODUK[ALAMAT_PRODUSEN]"><?php echo $sess['ALAMAT_PRODUSEN'] ?></textarea></td>
                                    <td class="td_left">Alamat Importir / Distributor</td><td class="td_right"><textarea id="alamatImportir" class="stext" style="height: 50px; width: 285px;" title="Alamat Produsen" name="PENANDAANPRODUK[ALAMAT_IMPORTIR]"><?php echo $sess['ALAMAT_IMPORTIR'] ?></textarea></td>
                                </tr>
                                <tr>
                                    <td class="td_left">Jenis Pangan</td><td class="td_right"><input type="text" size="45" id="jenisPangan" title="Jenis Pangan" name="PENANDAANPRODUK[GOLONGAN_PRODUK]" value="<?php echo $sess['GOLONGAN_PRODUK'] ?>"/></td>
                                    <td colspan="2"></td>
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
                        <table class="form_tabel">
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
                            <tr class="infoPenandaanPNGRow">
                                <td class="td_left_header_checklist" style="vertical-align: top">No Bets / Kode Produksi </td>
                                <td class="td_left">
                                    <input class="uraianPenandaan" param="Bets" type="radio" id="radioA1" name="CHK[1]" value="+_No Bets / Kode Produksi" <?php if ($d[0][0] == '+') echo 'checked'; ?>>
                                    <label for="radioA1" style="width: 70px; height: 10px;" title="Ada / Sesuai"></label>
                                    <span style="margin-left: 5px;"></span>
                                    <input class="uraianPenandaan" param="Bets" type="radio" id="radioA3" name="CHK[1]" value="X_No Bets / Kode Produksi" <?php if ($d[0][0] == 'X') echo 'checked'; ?>>
                                    <label for="radioA3" style="width: 70px; height: 10px; background-color: #f1f600" title="Tidak Sesuai"></label>
                                    <span style="margin-left: 5px;"></span>
                                    <input class="uraianPenandaan" param="Bets" type="radio" id="radioA2" name="CHK[1]" value="-_No Bets / Kode Produksi" <?php if ($d[0][0] == '-') echo 'checked'; ?>>
                                    <label for="radioA2" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak Ada"></label>
                                    <input type="text" name="CHK[1]"  value="<?php echo $detail[0]; ?>" style="display: none;"  rel="required">
                                </td>
                            </tr>
                            <tr id="Bets" hidden>
                                <td></td>
                                <td>&nbsp;<input type="text" name="URN[1]" class="uPenandaan" title="Uraian Penandaan" size="45" id="CHK[1]" value="<?php echo $detail2[0]; ?>" /></td>
                            </tr>
                            <tr class="infoPenandaanPNGRow">
                                <td class="td_left_header_checklist" style="vertical-align: top">Tanggal Kadaluarsa </td>
                                <td class="td_left">
                                    <input class="uraianPenandaan" param="ED" type="radio" id="radioC1" name="CHK[2]" value="+_Tanggal Kadaluarsa" <?php if ($d[1][0] == '+') echo 'checked'; ?>>
                                    <label for="radioC1" style="width: 70px; height: 10px;" title="Ada / Sesuai"></label>
                                    <span style="margin-left: 5px;"></span>
                                    <input class="uraianPenandaan" param="ED" type="radio" id="radioC3" name="CHK[2]" value="X_Tanggal Kadaluarsa" <?php if ($d[1][0] == 'X') echo 'checked'; ?>>
                                    <label for="radioC3" style="width: 70px; height: 10px; background-color: #f1f600" title="Tidak Sesuai"></label>
                                    <span style="margin-left: 5px;"></span>
                                    <input class="uraianPenandaan" param="ED" type="radio" id="radioC2" name="CHK[2]" value="-_Tanggal Kadaluarsa" <?php if ($d[1][0] == '-') echo 'checked'; ?>>
                                    <label for="radioC2" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak Ada"></label>
                                    <input type="text" name="CHK[2]"  value="<?php echo $detail[1]; ?>" style="display: none;"  rel="required">
                                </td>
                            </tr>
                            <tr id="ED" hidden>
                                <td class="td_left_checklist"></td>
                                <td>&nbsp;<input type="text" name="URN[2]" class="sdate uPenandaan" title="Uraian Penandaan" size="45" id="CHK[2]" value="<?php echo $detail2[1]; ?>" /></td>
                            </tr>
                            <tr class="infoPenandaanPNGRow">
                                <td class="td_left_header_checklist" style="vertical-align: top">Netto / Berat Bersih </td>
                                <td class="td_left">
                                    <input class="uraianPenandaan" param="Netto" type="radio" id="radioD1" name="CHK[3]"  value="+_Netto / Berat Bersih" <?php if ($d[2][0] == '+') echo 'checked'; ?>>
                                    <label for="radioD1" style="width: 70px; height: 10px;" title="Ada / Sesuai"></label>
                                    <span style="margin-left: 5px;"></span>
                                    <input class="uraianPenandaan" param="Netto" type="radio" id="radioD3" name="CHK[3]" value="X_Netto / Berat Bersih" <?php if ($d[2][0] == 'X') echo 'checked'; ?>>
                                    <label for="radioD3" style="width: 70px; height: 10px; background-color: #f1f600" title="Tidak Sesuai"></label>
                                    <span style="margin-left: 5px;"></span>
                                    <input class="uraianPenandaan" param="Netto" type="radio" id="radioD2" name="CHK[3]" value="-_Netto / Berat Bersih" <?php if ($d[2][0] == '-') echo 'checked'; ?>>
                                    <label for="radioD2" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak Ada"></label>
                                    <input type="text" name="CHK[3]"  value="<?php echo $detail[2]; ?>" style="display: none;"  rel="required">
                                </td>
                            </tr>
                            <tr id="Netto" hidden>
                                <td class="td_left_checklist"></td>
                                <td>&nbsp;<input type="text" name="URN[3]" class="uPenandaan" title="Uraian Penandaan" size="45" id="CHK[3]" value="<?php echo $detail2[2]; ?>" /></td>
                            </tr>
                            <tr class="infoPenandaanPNGRow">
                                <td class="td_left_header_checklist" style="vertical-align: top;">Bobot Tuntas </td>
                                <td class="td_left">
                                    <input class="uraianPenandaan" param="Bobot" type="radio" id="radioE1" name="CHK[4]" value="+_Bobot Tuntas" <?php if ($d[3][0] == '+') echo 'checked'; ?>>
                                    <label for="radioE1" style="width: 70px; height: 10px;" title="Ada / Sesuai"></label>
                                    <span style="margin-left: 5px;"></span>
                                    <input class="uraianPenandaan" param="Bobot" type="radio" id="radioE3" name="CHK[4]" value="X_Bobot Tuntas" <?php if ($d[3][0] == 'X') echo 'checked'; ?>>
                                    <label for="radioE3" style="width: 70px; height: 10px; background-color: #f1f600" title="Tidak Sesuai"></label>
                                    <span style="margin-left: 5px;"></span>
                                    <input class="uraianPenandaan" param="Bobot" type="radio" id="radioE2" name="CHK[4]" value="-_Bobot Tuntas" <?php if ($d[3][0] == '-') echo 'checked'; ?>>
                                    <label for="radioE2" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak Ada"></label>
                                    <input type="text" name="CHK[4]"  value="<?php echo $detail[3]; ?>" style="display: none;"  rel="required">
                                </td>
                            </tr>
                            <tr id="Bobot" hidden>
                                <td class="td_left_checklist"></td>
                                <td>&nbsp;<input type="text" name="URN[4]" class="uPenandaan" title="Uraian Penandaan" size="45" id="CHK[4]" value="<?php echo $detail2[3]; ?>" /></td>
                            </tr>
                            <tr class="infoPenandaanPNGRow">
                                <td class="td_left_header_checklist" style="vertical-align: top">Komposisi </td>
                                <td class="td_left">
                                    <input class="uraianPenandaan" param="Komposisi" type="radio" id="radioI1" name="CHK[5]" value="+_Komposisi" <?php if ($d[4][0] == '+') echo 'checked'; ?>>
                                    <label for="radioI1" style="width: 70px; height: 10px;" title="Ada / Sesuai"></label>
                                    <span style="margin-left: 5px;"></span>
                                    <input class="uraianPenandaan" param="Komposisi" type="radio" id="radioI3" name="CHK[5]" value="X_Komposisi" <?php if ($d[4][0] == 'X') echo 'checked'; ?>>
                                    <label for="radioI3" style="width: 70px; height: 10px; background-color: #f1f600" title="Tidak Sesuai"></label>
                                    <span style="margin-left: 5px;"></span>
                                    <input class="uraianPenandaan" param="Komposisi" type="radio" id="radioI2" name="CHK[5]" value="-_Komposisi" <?php if ($d[4][0] == '-') echo 'checked'; ?>>
                                    <label for="radioI2" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak Ada"></label>
                                    <input type="text" name="CHK[5]"  value="<?php echo $detail[4]; ?>" style="display: none;"  rel="required">
                                </td>
                            </tr>
                            <tr id="Komposisi" hidden>
                                <td class="td_left_checklist"></td>
                                <td>&nbsp;<input type="text" name="URN[5]" class="uPenandaan" title="Uraian Penandaan" size="45" id="CHK[5]" value="<?php echo $detail2[4]; ?>" /></td>
                            </tr>
                            <tr class="infoPenandaanPNGRow">
                                <td class="td_left_header_checklist" style="vertical-align: top">Bahasa Indonesia </td>
                                <td class="td_left">
                                    <input class="uraianPenandaan" param="Bahasa" type="radio" id="radioN1" name="CHK[7]" value="+_Bahasa Indonesia" <?php if ($d[6][0] == '+') echo 'checked'; ?>>
                                    <label for="radioN1" style="width: 70px; height: 10px;" title="Ada / Sesuai"></label>
                                    <span style="margin-left: 5px;"></span>
                                    <input class="uraianPenandaan" param="Bahasa" type="radio" id="radioN3" name="CHK[7]" value="X_Bahasa Indonesia" <?php if ($d[6][0] == 'X') echo 'checked'; ?>>
                                    <label for="radioN3" style="width: 70px; height: 10px; background-color: #f1f600" title="Tidak Sesuai"></label>
                                    <span style="margin-left: 5px;"></span>
                                    <input class="uraianPenandaan" param="Bahasa" type="radio" id="radioN2" name="CHK[7]" value="-_Bahasa Indonesia" <?php if ($d[6][0] == '-') echo 'checked'; ?>>
                                    <label for="radioN2" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak Ada"></label>
                                    <input type="text" name="CHK[7]"  value="<?php echo $detail[6]; ?>" style="display: none;"  rel="required">
                                </td>
                            </tr>
                            <tr id="Bahasa" hidden>
                                <td class="td_left_checklist"></td>
                                <td>&nbsp;<input type="text" name="URN[7]" class="uPenandaan" title="Uraian Penandaan" size="45" id="CHK[7]" value="<?php echo $detail2[6]; ?>" /></td>
                            </tr>
                            <tr class="infoPenandaanPNGRow" id="halalRow" hidden>
                                <td class="td_left_header_checklist" style="vertical-align: top">Logo Halal</td>
                                <td class="td_left">
                                    <input class="uraianPenandaan" param="Halal" type="radio" id="radioQ1" name="CHK[10]" value="+_Logo Halal" <?php if ($d[9][0] == '+') echo 'checked'; ?>>
                                    <label for="radioQ1" style="width: 70px; height: 10px;" title="Ada / Sesuai"></label>
                                    <span style="margin-left: 5px;"></span>
                                    <input class="uraianPenandaan" param="Halal" type="radio" id="radioQ3" name="CHK[10]" value="X_Logo Halal" <?php if ($d[9][0] == 'X') echo 'checked'; ?>>
                                    <label for="radioQ3" style="width: 70px; height: 10px; background-color: #f1f600" title="Tidak Sesuai"></label>
                                    <span style="margin-left: 5px;"></span>
                                    <input class="uraianPenandaan" param="Halal" type="radio" id="radioQ2" name="CHK[10]" value="-_Logo Halal" <?php if ($d[9][0] == '-') echo 'checked'; ?>>
                                    <label for="radioQ2" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak Ada"></label>
                                    <input type="text" class="halalVal" name="CHK[10]"  value="<?php echo $detail[9]; ?>" style="display: none;">
                                </td>
                            </tr>
                            <tr id="Halal" hidden>
                                <td class="td_left_checklist"></td>
                                <td>&nbsp;<input type="text" name="URN[10]" class="uPenandaan halal" title="Uraian Penandaan" size="45" id="CHK[10]" value="<?php echo $detail2[9]; ?>" /></td>
                            </tr>
                            <tr class="infoPenandaanPNGRow">
                                <td class="td_left_header_checklist" style="vertical-align: top">Peringatan</td>
                                <td class="td_left">
                                    <input class="uraianPenandaan" param="Peringatan" type="radio" id="radioL1" name="CHK[6]" value="+_Peringatan" <?php if ($d[5][0] == '+') echo 'checked'; ?>>
                                    <label for="radioL1" style="width: 70px; height: 10px;" title="Ada / Sesuai"></label>
                                    <span style="margin-left: 5px;"></span>
                                    <input class="uraianPenandaan" param="Peringatan" type="radio" id="radioL3" name="CHK[6]" value="X_Peringatan" <?php if ($d[5][0] == 'X') echo 'checked'; ?>>
                                    <label for="radioL3" style="width: 70px; height: 10px; background-color: #f1f600" title="Tidak Sesuai"></label>
                                    <span style="margin-left: 5px;"></span>
                                    <input class="uraianPenandaan" param="Peringatan" type="radio" id="radioL2" name="CHK[6]" value="-_Peringatan" <?php if ($d[5][0] == '-') echo 'checked'; ?>>
                                    <label for="radioL2" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak Ada"></label>
                                    <input type="text" name="CHK[6]"  value="<?php echo $detail[5]; ?>" style="display: none;"  rel="required">
                                </td>
                            </tr>
                            <tr id="Peringatan" hidden>
                                <td class="td_left_checklist"></td>
                                <td>&nbsp;<input type="text" name="URN[6]" class="uPenandaan" title="Uraian Penandaan" size="45" id="CHK[6]" value="<?php echo $detail2[5]; ?>" /></td>
                            </tr>
                            <tr class="infoPenandaanPNGRow">
                                <td class="td_left_header_checklist" style="vertical-align: top">Gambar / Tulisan </td>
                                <td class="td_left">
                                    <input class="uraianPenandaan" param="GambarTulisan" type="radio" id="radioO1" name="CHK[8]" value="+_Gambar / Tulisan" <?php if ($d[7][0] == '+') echo 'checked'; ?>>
                                    <label for="radioO1" style="width: 70px; height: 10px;" title="Ada / Sesuai"></label>
                                    <span style="margin-left: 5px;"></span>
                                    <input class="uraianPenandaan" param="GambarTulisan" type="radio" id="radioO3" name="CHK[8]" value="X_Gambar / Tulisan" <?php if ($d[7][0] == 'X') echo 'checked'; ?>>
                                    <label for="radioO3" style="width: 70px; height: 10px; background-color: #f1f600" title="Tidak Sesuai"></label>
                                    <span style="margin-left: 5px;"></span>
                                    <input class="uraianPenandaan" param="GambarTulisan" type="radio" id="radioO2" name="CHK[8]" value="-_Gambar / Tulisan" <?php if ($d[7][0] == '-') echo 'checked'; ?>>
                                    <label for="radioO2" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak Ada"></label>
                                    <input type="text" name="CHK[8]"  value="<?php echo $detail[7]; ?>" style="display: none;"  rel="required">
                                </td>
                            </tr>
                            <tr id="GambarTulisan" hidden>
                                <td class="td_left_checklist"></td>
                                <td>&nbsp;<input type="text" name="URN[8]" class="uPenandaan" title="Uraian Penandaan" size="45" id="CHK[8]" value="<?php echo $detail2[7]; ?>" /></td>
                            </tr>
                            <tr class="infoPenandaanPNGRow">
                                <td class="td_left_header_checklist" style="vertical-align: top">Keterangan Khusus </td>
                                <td class="td_left">
                                    <input class="uraianPenandaan" param="Khusus" type="radio" id="radioP1" name="CHK[9]" value="+_Keterangan Khusus" <?php if ($d[8][0] == '+') echo 'checked'; ?>>
                                    <label for="radioP1" style="width: 70px; height: 10px;" title="Ada / Sesuai"></label>
                                    <span style="margin-left: 5px;"></span>
                                    <input class="uraianPenandaan" param="Khusus" type="radio" id="radioP3" name="CHK[9]" value="X_Keterangan Khusus" <?php if ($d[8][0] == 'X') echo 'checked'; ?>>
                                    <label for="radioP3" style="width: 70px; height: 10px; background-color: #f1f600" title="Tidak Sesuai"></label>
                                    <span style="margin-left: 5px;"></span>
                                    <input class="uraianPenandaan" param="Khusus" type="radio" id="radioP2" name="CHK[9]" value="-_Keterangan Khusus" <?php if ($d[8][0] == '-') echo 'checked'; ?>>
                                    <label for="radioP2" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak Ada"></label>
                                    <input type="text" name="CHK[9]"  value="<?php echo $detail[8]; ?>" style="display: none;"  rel="required">
                                </td>
                            </tr>
                            <tr id="Khusus" hidden>
                                <td class="td_left_checklist"></td>
                                <td>&nbsp;<input type="text" name="URN[9]" class="uPenandaan" title="Uraian Penandaan" size="45" id="CHK[9]" value="<?php echo $detail2[8]; ?>" /></td>
                            </tr>
                            <tr class="infoPenandaanPNGRow" id="rutinRow" hidden>
                                <td class="td_left_header_checklist" style="vertical-align: top">Menyesatkan</td>
                                <td class="td_left">
                                    <input class="uraianPenandaan" param="Rutin" type="radio" id="radioR1" name="CHK[12]" value="+_Menyesatkan" <?php if ($d[11][0] == '+') echo 'checked'; ?>>
                                    <label for="radioR1" style="width: 70px; height: 10px;" title="Ada / Sesuai"></label>
                                    <span style="margin-left: 5px;"></span>
                                    <input class="uraianPenandaan" param="Rutin" type="radio" id="radioR3" name="CHK[12]" value="X_Menyesatkan" <?php if ($d[11][0] == 'X') echo 'checked'; ?>>
                                    <label for="radioR3" style="width: 70px; height: 10px; background-color: #f1f600" title="Tidak Sesuai"></label>
                                    <span style="margin-left: 5px;"></span>
                                    <input class="uraianPenandaan" param="Rutin" type="radio" id="radioR2" name="CHK[12]" value="-_Menyesatkan" <?php if ($d[11][0] == '-') echo 'checked'; ?>>
                                    <label for="radioR2" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak Ada"></label>
                                    <input type="text" class="rutinVal" name="CHK[12]"  value="<?php echo $detail[11]; ?>" style="display: none;">
                                </td>
                            </tr>
                            <tr id="Rutin" hidden>
                                <td class="td_left_checklist"></td>
                                <td>&nbsp;<input type="text" name="URN[12]" class="uPenandaan rutin" title="Uraian Penandaan" size="45" id="CHK[12]" value="<?php echo $detail2[11]; ?>" /></td>
                            </tr>
                            <tr>
                                <td class="td_left_header_checklist" style="vertical-align: top; background-color: white; border-bottom: 1px solid #000">&nbsp; </td>
                            </tr>
                            <tr class="infoPenandaanPNGRow">
                                <td class="td_left_header_checklist" style="vertical-align: top">Lain - lain </td>
                                <td>&nbsp;<textarea name="URN[11]" class="uPenandaan" title="Uraian Penandaan" style="width: 34%; height: 100px;" ><?php echo $detail2[10]; ?></textarea></td>
                            <input type="text" name="CHK[11]" value="_"  style="display: none;">
                            </tr>
                            <tr></tr>
                            <tr><td colspan="2" style="background-color: white">&nbsp;</td></tr>
                            <tr>
                               <!--<td class="td_left_checklist" style="vertical-align: top">37</td>-->
                                <td class="td_left_header_checklist">Lampiran : </td><td><?php
                                    if (array_key_exists('LAMPIRAN', $sess) && trim($sess['LAMPIRAN']) != "") {
                                        ?><input type="hidden" name="PENANDAAN_PANGAN[FILE_PENANDAAN_PANGAN]" value="<?php echo $sess['LAMPIRAN']; ?>">
                                        <span class="file_FILE_PENANDAAN_PANGAN"><a href="<?php echo base_url(); ?>files/<?php echo 'penandaan_013/mdml'; ?>/<?php echo $sess['LAMPIRAN']; ?>" target="_blank">File Lampiran</a>&nbsp;&bull;&nbsp;<a href="#" class="del_upload" url="<?php echo site_url(); ?>/utility/uploads/del_upload_m/<?php echo 'penandaan_013/mdml'; ?><?php echo $sess['FILE_PENANDAAN_PANGAN']; ?>" jns="FILE_PENANDAAN_PANGAN">Edit atau Hapus File ?</a></span>
                                        <?php
                                    } else {
                                        ?>
                                        <span class="upload_FILE_PENANDAAN_PANGAN"><input type="file" class="upload upPANGAN" jenis="FILE_PENANDAAN_PANGAN" allowed="jpg-jpeg-pdf-doc-docx-rar" url="<?php echo site_url(); ?>/utility/uploads/get_upload_m/<?php echo 'penandaan_013/mdml'; ?>" id="fileToUpload_FILE_PENANDAAN_PANGAN" name="userfile" onchange="do_upload($(this));
                                                return false;" />
                                            &nbsp;Tipe File : *.jpg .jpeg .pdf .doc .docx .rar</span><span class="file_FILE_PENANDAAN_PANGAN"></span>
                                        <?php
                                    }
                                    ?></td>
                            </tr>
                            <?php if (!in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) { ?>
                                <tr><td colspan="3">&nbsp;</td></tr>
                                <tr>
                                    <td class="td_left_header_checklist">&nbsp;Kesimpulan&nbsp;&nbsp;</td>
                                    <td class="td_left">
                            <!--         <input type="text" id="kesimpulanHasilPenilaian" value="<?php
//         if ($sess['SISTEM'] == "MK")
//          echo "Memenuhi Ketentuan";
//         else
//          echo "Tidak Memenuhi Ketentuan"
                                        ?>" readonly size="23" />-->
                                     <!--<input type="hidden" id="kesimpulanHasilPenilaianVal" value="<?php // echo $sess['SISTEM'];        ?>" name="HASIL"  /></td>-->
                                        <select name="HASIL" class="stext" rel="required" title="Kesimpulan" onchange="mkTmk();"><option value=""></option><option value="MK" <?php echo trim($sess['SISTEM']) == "MK" ? "selected" : ""; ?>>Memenuhi Ketentuan</option><option value="TMK" <?php echo trim($sess['SISTEM']) == "TMK" ? "selected" : ""; ?>>Tidak Memenuhi Ketentuan</option></select>
                                </tr>
                                <tr>
                                    <td colspan="3"></td>
                                </tr>
                            <?php } ?>
                        </table>
                    </div>
                </div>

                <!--7-->
                <?php if ((in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')))) { ?>
                    <div style="height:5px;"></div>
                    <div class="expand"><a title="expand/collapse" href="#" style="display: block;">KESIMPULAN</a></div>
                    <div class="collapse">
                        <div class="accCntnt">
                            <table class="form_tabel">
                                <?php
                                $pusat = explode("*", $sess['PUSAT']);
                                if ((trim($sess['PUSAT']) == "" && in_array('2', $this->newsession->userdata('SESS_KODE_ROLE'))) || $editTL == 'YES') {
                                    ?><tr><td class="td_left">Verifikasi Pusat</td><td class="td_right"><select class="stext verifikasiPusat" name="<?php echo 'PENANDAAN[HASIL_PUSAT]' ?>" rel="required" title="MK/TMK"><option></option><option value="MK" <?php if ($pusat[0] == 'MK') echo 'Selected' ?>>Memenuhi Ketentuan</option><option value="TMK"  <?php if ($pusat[0] == 'TMK') echo 'Selected' ?>>Tidak Memenuhi Ketentuan</option></select></td></tr>
                                    <tr class="vTMK" hidden><td class="td_left"style="background-color: white;">Tindak Lanjut</td><td class="td_right" style="background-color: white;"><?php echo form_dropdown('PENANDAAN[TL_PUSAT]', $cb_tl, is_array($pusat) ? $pusat[1] : '', 'class="stext vTMK" id="vTMKSub" title="Tindak Lanjut Pusat"'); ?></td></tr>
                                    <?php
                                }else {
                                    if ($pusat[0] == "TMK") {
                                        ?>
                                        <tr><td class="td_left">Verifikasi Pusat</td><td><b><i><?php
                                                        echo 'Tidak Memenuhi Ketentuan';
                                                        ?></i></b></td></tr><?php if (trim($pusat[1]) != "") { ?>
                                            <tr><td class="td_left">Tindak Lanjut Pusat</td><td><?php echo $pusat[1]; ?></td></tr>
                                            <?php
                                        }
                                    } else {
                                        ?>
                                        <tr><td class="td_left">Verifikasi Pusat</td><td><b><i><?php
                                                        echo 'Memenuhi Ketentuan';
                                                        ?></i></b></td></tr>
                                        <?php
                                    }
                                }
                                ?>
                            </table>
                        </div>
                    </div>
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

                <div style="padding:10px;"></div><div><a href="javascript:void(0)" id="btnSave" class="button <?php echo $icon; ?>" onclick="fpost('#fpengawasanPenandaan_013', '', '');">
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
                <input type="hidden" name="JENIS" value="<?php echo "MD/ML"; ?>" />
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
                                            var impor = $("#NIE").val().substring(2, 1);
                                            var halal = $("#jenisPengawasan").val();
                                            if (impor === 'C') {
                                                $('.importirBased').show();
                                                $('.importirBased').attr("hidden", false);
                                                $('#importirBasedTxt').attr('rel', 'required');
                                            } else if (impor !== 'I') {
                                                $('.importirBased').hide();
                                                $('.importirBased').attr("hidden", true);
                                                $('#importirBasedTxt').attr('rel', '');
                                            }
                                            if (halal === "Halal") {
                                                $('#halalRow').show();
                                                $('.halalVal').attr("rel", "required");
                                                $('#rutinRow').hide();
                                                $('#Rutin').hide();
                                                $('.rutin').val('');
                                                $('.rutin').attr("rel", "");
                                                $('.rutinVal').val('');
                                                $('.rutinVal').attr("rel", "");
                                                $('#radioR1').attr('checked', false);
                                                $('#radioR2').attr('checked', false);
                                                $('#radioR3').attr('checked', false);
                                            } else {
                                                $('#rutinRow').show();
                                                $('.rutinVal').attr("rel", "required");
                                                $('#halalRow').hide();
                                                $('#Halal').hide();
                                                $('.halal').val('');
                                                $('.halal').attr("rel", "");
                                                $('.halalVal').val('');
                                                $('.halalVal').attr("rel", "");
                                                $('#radioQ1').attr('checked', false);
                                                $('#radioQ2').attr('checked', false);
                                                $('#radioQ3').attr('checked', false);
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
                                        function cekLampiran() {
//    var kesimpulan = $('#kesimpulanHasilPenilaian').val(), jenis = $('#iklan_media').val();
//    if (kesimpulan === 'Tidak Memenuhi Ketentuan') {
                                            $('.upload').attr('rel', 'required');
//    } else {
//      $('.upload').attr('rel', ' ');
//    }
                                        }
                                        function verifikasiPusat(X) {
                                            if ($(X).val() === "MK") {
                                                $(".vTMK").hide();
                                                $(".vTMK").attr("rel", " ");
                                                $(".vTMK").val("");
                                                $(".vTMKa").val("");
                                                $(".vTMKa").attr("rel", " ");
                                                $(".vTMKa").attr("name", " ");
                                                $(".vTMK2").hide("slow");
                                                $(".vTMK2").val("");
                                                $(".vTMK2").attr("rel", "");
                                                $(".vTMK2a").val("");
                                            }
                                            else if ($(X).val() === "TMK") {
                                                $(".vTMK").show();
                                                $(".vTMK").attr("rel", "required");
                                                $(".vTMKa").attr("rel", "required");
                                                $(".vTMK2").show();
                                                $(".vTMKa").attr("name", "PENANDAAN[TL_PUSAT][]");
                                            }
                                            else {
                                                $(".vTMK").hide();
                                                $(".vTMK").hide();
                                                $(".vTMK").attr("rel", " ");
                                                $(".vTMK").val("");
                                                $(".vTMKa").val("");
                                                $(".vTMKa").attr("rel", " ");
                                                $(".vTMKa").attr("name", " ");
                                                $(".vTMK2").hide("slow");
                                                $(".vTMK2").val("");
                                                $(".vTMK2").attr("rel", "");
                                                $(".vTMK2a").val("");
                                            }
//           if ($(X).val() != '') {
//            if ($(X).val() != $("#kesimpulanHasilPenilaianVal").val()) {
//             $(".vJustifikasi").show("slow");
//             $(".chkJustifikasi").attr("rel", "required");
//            } else if ($(X).val() == $("#kesimpulanHasilPenilaianVal").val()) {
//             $(".vJustifikasi").hide("slow");
//             $(".chkJustifikasi").attr("rel", "");
//            }
//           } else {
//            $(".vJustifikasi").hide("slow");
//            $(".chkJustifikasi").attr("rel", "");
//           }
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
                                                                $("#fileToUpload_" + arrdata[2] + "").removeAttr("rel");
                                                                $(".upload_" + arrdata[2] + "").hide();
                                                                $(".file_" + arrdata[2] + "").html("<b>1 File telah dilampirkan. </b>&nbsp;<a href=\"<?php echo base_url(); ?>files/" + arrdata[3] + "/" + arrdata[4] + "/" + arrdata[0] + "\" target=\"_blank\">Tampilkan File</a>&nbsp;&bull;&nbsp;<a href=\"#\" class=\"del_upload\" url=\"<?php echo site_url(); ?>/utility/uploads/del_upload_m/" + arrdata[3] + "/" + arrdata[4] + "/" + arrdata[0] + "\" jns=" + arrdata[2] + ">Edit atau Hapus File ?</a><input type=\"hidden\" name=\"PENANDAAN_PANGAN[" + arrdata[2] + "]\" value=" + arrdata[0] + ">");
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
                                        function isiValue(obj) {
                                            var A, param, name;
                                            var netto = $("#kemasan").val(), nie = $("#NIE").val();
                                            if (typeof obj === "object") {
                                                A = obj.val().split('_');
                                                param = obj.attr('param');
                                                name = $(obj).attr("name");
                                                if (A[1] === 'Netto') {
                                                    if (netto !== "" && A[0] === '+') {
                                                        $("[id='" + name + "']").val(netto);
                                                    }
                                                    else if (netto !== "" && A[0] === 'X') {
                                                        $("[id='" + name + "']").val("");
                                                    }
                                                }
                                            } else {
                                                $(".uraianPenandaan").each(function() {
                                                    if ($(this).attr("checked") === true) {
                                                        A = $(this).val().split('_');
                                                        param = $(this).attr('param');
                                                        name = $(this).attr("name");
                                                        if (A[1] === 'Netto') {
                                                            if (nie !== "" && A[0] === '+') {
                                                                $("[id='" + name + "']").val(netto);
                                                            }
                                                            else if (netto !== "" && A[0] === 'X') {
                                                                $("[id='" + name + "']").val("");
                                                            }
                                                        }
                                                    }
                                                });
                                            }
                                        }
                                        function mkTmk() {
                                            //            var X = false;
                                            //            $('.uraianPenandaan').each(function() { //             if ($(this).is(":checked") === true) {
//              var a = $(this).val().split('_');
                                            //              if (a[0] === '-' || a[0] === 'X') {
                                            //               X = true;
                                            //              }
//             }
                                            //            });
//            if (X === true) {
//             $('#kesimpulanHasilPenilaian').val('Tidak Memenuhi Ketentuan');
                                            //             $('#kesimpulanHasilPenilaianVal').val('TMK');
                                            //            } else if (X !== true) {
                                            //             $('#kesimpulanHasilPenilaian').val('Memenuhi Ketentuan');
                                            //             $('#kesimpulanHasilPenilaianVal').val('MK');
//            }
                                            cekLampiran();
                                        }
                                        function clearNamaPangan() {
                                            $('#namaPanganJadi').val('');
                                            $('#NIE').val('');
                                            $('#merk').val('');
                                            $('#produsen').val('');
                                            $('#importir').val('');
                                            $('#jenisPangan').val('');
                                            $('#kemasan').val('');
                                            $('#alamatProdusen').val('');
                                            $('#alamatImportir').val('');
                                        }
                                        $(document).ready(function() {
//           $("textarea.chkJustifikasi").redactor({
//            buttons: ['bold', 'italic', '|', 'unorderedlist', 'orderedlist', 'outdent', 'indent', '|', 'alignleft', 'aligncenter', 'alignright', 'justify'],
//            removeStyles: false,
//            cleanUp: true,
//            autoformat: true
//           });
//                      Load data
<?php
if (array_key_exists("PENANDAAN_ID", $sess)) {
    if ($sess['PENILAIAN'] != '') {
        ?>
                                                    $(".uraianPenandaan").each(function() {
                                                        if ($(this).is(':checked')) {
                                                            borderLess($(this));
                                                            checkListTxt($(this));
                                                        }
                                                    });
                                                    showHide();
        <?php if (in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) { ?>
                                                        $(".verifikasiPusat").each(function() {
                                                            verifikasiPusat($(this));
                                                        });
            <?php
        }
    }
}
?>
//    akhir load data
                                            $("input.namaPanganJadi").autocomplete($("input.namaPanganJadi").attr("url") + '3', {width: 244, selectFirst: false});
                                            $("input.namaPanganJadi").result(function(event, data, formatted) {
                                                if (data) {
                                                    clearNamaPangan();
                                                    var nieSubstr = data[2].substring(0, 2);
                                                    $('#namaPanganJadi').val(data[1]);
                                                    $('#NIE').val(data[2]);
                                                    $('#merk').val(data[13]);
                                                    $('#kemasan').val(data[4]);
                                                    if (nieSubstr == "MD") {
                                                        $('#produsen').val(data[3]);
                                                        $('#alamatProdusen').val(data[5]);
                                                    } else {
                                                        $('#produsen').val(data[6]);
                                                        $("#importir").val(data[3]);
                                                        $('#alamatProdusen').val(data[11]);
                                                        $('#alamatImportir').val(data[5]);
                                                    }
                                                    $('#jenisPangan').val(data[12]);
                                                    showHide();
                                                }
                                            });
                                            $('#namaPanganJadi').keyup(function() {
                                                if ($('#namaPanganJadi').val() === '') {
                                                    clearNamaPangan();
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
                                            $("#klasifikasi_id").change(function() {
                                                if ($(this).val() === "001") {
                                                    $('.content2').fadeIn(3500);
                                                    $('html, body').animate({scrollTop: $(window).scrollTop() + 300});
                                                    $('.form_tabel_detail').focus();
                                                } else {
                                                    $(this).attr("checked", false);
                                                }
                                            });
                                            function checkListTxt(XXX) {
                                                var A = XXX.val().split('_');
                                                var param = XXX.attr('param');
                                                var name = $(XXX).attr("name");
                                                if (A[0] === '+' || A[0] === 'X') {
                                                    if (param === 'Sekunder') {
                                                        $('.primer').fadeIn("slow");
                                                        $('#' + param).fadeOut("slow");
                                                        $('.kemasanPrimer').attr("rel", "required");
                                                    }
                                                    else {
                                                        $('#' + param).fadeIn("slow");
                                                    }
                                                    if (name !== "CHK[7]")
                                                        $("[id='" + name + "']").attr("rel", "required");
                                                }
                                                else {
                                                    $('#' + param).fadeOut("slow");
                                                    $("[id='" + name + "']").val("");
                                                    if (XXX.val() === '-_Klaim') {
                                                        $('#KlaimCb').fadeOut("slow");
                                                    }
                                                    if (XXX.val() === '-_Sekunder') {
                                                        $('.primer').fadeOut("slow");
                                                        $('.kemasanPrimer').attr("rel", "");
                                                    }
                                                    $("[id='" + name + "']").attr("rel", "");
                                                }
                                                mkTmk();
                                            }
                                            $(".uraianPenandaan").click(function() {
                                                var name = $(this).attr("name"), selectedVal = "";
                                                var selected = $("input[type='radio'][name='" + name + "']:checked").val();
                                                $("input[type='text'][name='" + name + "']").val(selected);
                                                checkListTxt($(this));
                                                borderLess($(this));
                                                verifikasiTL($("#vTMKSub"));
                                                isiValue($(this));
                                            });
                                            $(".verifikasiPusat").change(function() {
                                                verifikasiPusat($(this));
                                            });
                                            $("#vTMKSub").change(function() {
                                                verifikasiTL($(this));
                                            });
                                            $("#detail_petugas").html("Loading ...");
                                            $("#detail_petugas").load($("#detail_petugas").attr("url"));
                                            $(".del_upload").live("click", function() {
                                                var jenis = $(this).attr("jns");
                                                $.ajax({
                                                    type: "GET",
                                                    url: $(this).attr("url"),
                                                    data: $(this).serialize(),
                                                    success: function(data) {
                                                        var arrdata = data.split("#");
                                                        $(".upload_" + jenis + "").show();
                                                        $("#fileToUpload_" + jenis + "").val('');
                                                        $(".file_" + jenis + "").html("");
                                                        if (jenis !== "FILE_LAMPIRAN_IKLAN")
                                                            $("#fileToUpload_" + jenis + "").attr("rel", "");
                                                    }
                                                });
                                                return false;
                                            });
                                            $("#jenisPengawasan").change(function() {
                                                showHide();
                                            });
                                        });</script>