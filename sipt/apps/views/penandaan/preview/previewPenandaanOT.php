<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
error_reporting(E_ERROR);
?>
<div id="judulpmnpdd" class="judul"></div>
<div class="headersarana">PENGAWASAN PENANDAAN OBAT TRADISIONAL</div>
<?php
$detailBL = explode('#', $sess['PENILAIANBL']);
$detail2BL = explode('^', $sess['URAIANBL']);
$detailKP = explode('#', $sess['PENILAIANKP']);
$detail2KP = explode('^', $sess['URAIANKP']);
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
                        <h2 class="small garis">Informasi Pengawasan Penandaan</h2>
                        <div id="detail_petugas" url="<?php echo $histori_petugas; ?>"></div>
                        <div style="height:15px;"></div>
                        <table class="form_tabel">
                            <tr class="urut<?php echo $i; ?>" hidden="true">
                                <td class="atas">Unit / Balai Besar / Balai</td>
                                <td><input type="text" class="stext" readonly="readonly" value="<?php echo $this->newsession->userdata('SESS_MBBPOM'); ?>" name="BBPOM[MBBPOM_ID][]" val="<?php echo $nomor[$i]; ?>" title="Balai Besar / Balai POM" /><input type="hidden" name="BBPOM[BBPOM_ID][]" value="<?php echo $this->newsession->userdata('SESS_BBPOM_ID'); ?>" id="bpomid" /></td>
                            </tr>
                        </table>
                        <div style="height:15px;"></div>
                        <div id="detail_petugas" url="<?php echo $histori_petugas; ?>"></div>
                        <div style="height:15px;"></div>
                        <table class="form_tabel">
                            <tr><td class="td_left">Tanggal Pengawasan</td><td class="td_right">
                                    <?php echo $sess['TANGGAL_MULAI']; ?>&nbsp; sampai dengan&nbsp;
                                    <?php echo $sess['TANGGAL_MULAI']; ?></td>
                            </tr>
                            <tr><td class="td_left">Sarana</td><td class="td_right"><?php echo $sess['NAMA_SARANA']; ?></td></tr>
                            <tr><td class="td_left">Alamat</td><td class="td_right"><?php echo $sess['ALAMAT_1'] . ", " . $sess['KOTA'] . ", " . $sess['PROPINSI']; ?></td></tr>
                        </table>
                    </div>
                </div>
                <div style="height:5px;"></div><div class="expand"><a title="expand/collapse" href="#" style="display: block;">INFORMASI OBAT PENANDAAN</a></div>
                <div class="collapse">
                    <div class="accCntnt">
                        <h2 class="small garis">Informasi Produk Penandaan</h2>
                        <table class="form_tabel">
                            <tr><td class="td_left">Nama Obat Jadi</td><td><?php echo $sess['NAMA_PRODUK']; ?></td></tr>
                            <tr><td class="td_left">Nomor Izin Edar</td><td><?php echo $sess['NOMOR_IZIN_EDAR']; ?></td></tr>
                            <tr><td class="td_left">Bentuk Sediaan</td><td><?php echo $sess['BENTUK_SEDIAAN']; ?></td></tr>
                            <tr><td class="td_left">Besar Kemasan</td><td><?php echo $sess['BESAR_KEMASAN']; ?></td></tr>
                            <tr><td class="td_left">Komposisi</td><td><?php echo $sess['KOMPOSISI']; ?></td></tr>
                            <tr><td class="td_left">Produsen</td><td><?php echo $sess['PRODUSEN']; ?></td></tr>
                            <tr><td class="td_left">Alamat Produsen</td><td><?php echo $sess['ALAMAT_PRODUSEN']; ?></td></tr>
                            <tr><td class="td_left">Importir</td><td><?php echo $sess['PENDAFTAR']; ?></td></tr>
                            <tr><td class="td_left">Alamat Improtir</td><td><?php echo $sess['ALAMAT_PENDAFTAR']; ?></td></tr>
                        </table>
                    </div>
                </div>

                <div style="height:5px;"></div>
                <div>
                    <!--5-->
                    <div class="expand" id="expand5"><a title="expand/collapse" href="#" style="display: block;">PENILAIAN</a></div>
                    <div class="collapse">
                        <div class="accCntnt">
                            <h2 class="small garis">Detil Penilaian :</h2>
                            <div id="tabs">
                                <br />
                                <ul>
                                    <?php if (trim($sess['PENILAIANBL']) != "" && trim($detailBL[0]) != "") { ?>
                                        <li class="div_bL"><a href="#tabs-1">Bungkus Luar</a></li>
                                    <?php } else { ?>
                                        <li class="div_bL" style="display: none;"><a href="#tabs-1">Bungkus Luar</a></li>
                                    <?php } if (trim($sess['PENILAIANKP']) != "" && trim($detailKP[0]) != "") { ?>
                                        <li class="div_kP"><a href="#tabs-2">Kemasan Primer</a></li>
                                    <?php } else { ?>
                                        <li class="div_kP"style="display: none;"><a href="#tabs-2">Kemasan Primer</a></li>
                                    <?php } ?>
                                </ul>

                                <!--Bungkus Luar-->
                                <?php if (trim($sess['PENILAIANBL']) != "" && trim($detailBL[0]) != "") { ?>
                                    <div id="tabs-1" class="div_bL">
                                    <?php } else { ?>
                                        <div id="tabs-1" class="div_bL" style="display: none">
                                        <?php } ?>
                                        <table class="form_tabel" style="width: 100%;">
                                            <tr>
                                                <td class="td_left" style="width: 20%"><h3>Poin Penilaian</h3></td>
                                                <td class="td_right" style="width: 20%"><h3>Penilaian</h3></td>
                                                <td class="td_left"><h3>Isian Penilaian</h3></td>
                                            </tr>
                                            <?php
                                            $i = 0;
                                            foreach ($detailBL as $value) {
                                                $d2 = explode('_', $value);
                                                if ($d2[0] != "") {
                                                    ?>
                                                    <tr>
                                                        <td class="td_left"><?php echo $d2[1]; ?></td>
                                                        <td class="td_right"><?php
                                                            if ($d2[0] == "-") {
                                                                echo 'Tidak Ada';
                                                            } else if ($d2[0] == "+") {
                                                                echo 'Ada / Sesuai';
                                                            } else if ($d2[0] == "X") {
                                                                echo 'Tidak Sesuai';
                                                            }
                                                            ?></td>
                                                        <td><?php
                                                            if (trim($detail2BL[$i]) != "")
                                                                echo "&nbsp;<b>" . $detail2BL[$i] . "</b>&nbsp;";
                                                            ?></td>
                                                    </tr>
                                                    <?php
                                                } $i++;
                                            }
                                            ?>
                                            <tr>
                                                <td class="td_left">Narasi</td>
                                                <td class="td_right" colspan="2"><?php
                                                    if (trim($detail2BL[16]) != "")
                                                        echo $detail2BL[16];
                                                    else
                                                        echo "-";
                                                    ?></td>
                                            </tr>
                                        </table>
                                    </div>
                                    <!--Kemasan Primer-->
                                    <?php if (trim($sess['PENILAIANKP']) != "" && trim($detailKP[0]) != "") { ?>
                                        <div id="tabs-2" class="div_kP">
                                        <?php } else { ?>
                                            <div id="tabs-2" class="div_kP" style="display: none">
                                            <?php } ?>
                                            <table class="form_tabel" style="width: 100%;">
                                                <tr>
                                                    <td class="td_left" style="width: 20%"><h3>Poin Penilaian</h3></td>
                                                    <td class="td_right" style="width: 20%"><h3>Penilaian</h3></td>
                                                    <td class="td_left"><h3>Isian Penilaian</h3></td>
                                                </tr>
                                                <?php
                                                $i = 0;
                                                foreach ($detailKP as $value) {
                                                    $d2 = explode('_', $value);
                                                    if ($d2[0] != "") {
                                                        ?>
                                                        <tr>
                                                            <td class="td_left"><?php echo $d2[1]; ?></td>
                                                            <td class="td_right"><?php
                                                                if ($d2[0] == "-") {
                                                                    echo 'Tidak Ada';
                                                                } else if ($d2[0] == "+") {
                                                                    echo 'Ada / Sesuai';
                                                                } else if ($d2[0] == "X") {
                                                                    echo 'Tidak Sesuai';
                                                                }
                                                                ?></td>
                                                            <td><?php
                                                                if (trim($detail2KP[$i]) != "")
                                                                    echo "&nbsp;<b>" . $detail2KP[$i] . "</b>&nbsp;";
                                                                ?></td>
                                                        </tr>
                                                        <?php
                                                    } $i++;
                                                }
                                                ?>
                                                <tr>
                                                    <td class="td_left">Narasi</td>
                                                    <td class="td_right" colspan="2"><?php
                                                        if (trim($detail2KP[16]) != "")
                                                            echo $detail2KP[16];
                                                        else
                                                            echo "-";
                                                        ?></td>
                                                </tr>
                                                <tr><td>&nbsp;</td></tr>
                                            </table>
                                        </div>
                                    </div>
                                    <div>
                                        <table class="form_tabel">
                                            <tr><td class="td_left" style="padding-left: 20px" colspan="3"><h2 class="small garis">Lampiran</h2></td></tr>
                                            <?php
                                            if (trim($sess['LAMPIRAN']) != '' && $sess['LAMPIRAN'] != 0) {
                                                $arrDataLamp = explode("^", $sess["LAMPIRAN"]);
                                                foreach ($arrDataLamp as $value) {
                                                    $arrLamp = explode(".", $value);
                                                    ?>
                                                    <tr><td class="td_left" style="padding-left: 20px" colspan="3"><a href="<?php echo base_url(); ?>files/<?php echo 'penandaan_010/'; ?><?php echo $value; ?>" target="_blank" <?php if ($arrLamp[1] == "rar") echo 'onclick="dotRar();return false;"'; ?>>Lihat Lampiran</a></td></tr>
                                                <?php
                                                }
                                            } else {
                                                ?>
                                                <tr><td class="td_left" style="padding-left: 20px" colspan="3"><td class="td_right">-</td></tr>
<?php } ?>
                                            <tr><td colspan="3"><h2 class="small garisatas"></h2></td></tr>
                                            <tr>
                                                <td class="td_left" style="padding-left: 20px;">Kesimpulan</td>
                                                <td class="td_right"><?php
                                                    if ($sess['SISTEM'] == "MK")
                                                        echo "Memenuhi Ketentuan";
                                                    else
                                                        echo "Tidak Memenuhi Ketentuan";
                                                    ?></td>
                                            </tr>
                                            <?php if ($sess['TL_BALAI'] != '0' && $sess['TL_BALAI'] != NULL && trim($sess['TL_BALAI']) != "") { ?><tr><td class="td_left" style="padding-left: 20px">Tindak Lanjut</td><td class="td_right"><?php echo $cb_tindakan_balai[$sess["TL_BALAI"]]; ?></td></tr>
                                                    <?php } if (trim($sess["TL_BALAI"]) == "1") { ?>
                                                <tr><td class="td_left" style="padding-left: 20px"></td><td><input type="text" class="tDKBalaiRow TDKB" id="jmlMusnah" title="Jumlah" placeholder = "Jumlah" maxlength="5" size="5" value="<?php echo $pemusnahan2[0] ?>" readonly/>&nbsp;<input type="text" class="tDKBalaiRow TDKB" id="satuanMusnah" title="Satuan" placeholder = "Satuan" size="10" value="<?php echo $pemusnahan[1] ?>" readonly/>&nbsp;<input type="text" class="tDKBalaiRow TDKB" id="estimasiMusnah" title="Estimasi Harga" placeholder = "Estimasi Harga" maxlength="10" size="10" value="<?php
                                                        if (trim($pemusnahan2[1]) != "")
                                                            echo $pemusnahan2[1];
                                                        else
                                                            echo "-"
                                                            ?>" readonly/></td></tr>
                                                <tr><td class="td_left" style="padding-left: 20px"></td><td><input type="hidden" name="MUSNAH[]" id = "fileMusnah" value="<?php echo $sess['FILE_MUSNAH']; ?>"><span id="file_FILE_MUSNAH"><a href="<?php echo base_url(); ?>files/<?php echo 'penandaan_010/2_010'; ?>/<?php echo $sess['FILE_MUSNAH']; ?>" target="_blank">File Lampiran Pemusnahan</a></span></td></tr>
<?php } ?>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div style="height:5px;"></div>

                            <!--7-->
<?php if ((in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')))) { ?>
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
                                                        <tr><td class="td_left">Tindak Lanjut Pusat</td><td><?php echo $cb_tindakan[$pusat[1]]; ?></td></tr>
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
                                <div style="height:5px;"></div>
<?php } ?>
                            <div style="padding:10px;"></div><div><?php if ($formEdit === 'check') { ?><a href="javascript:void(0)" id="btnSave" class="button check" onclick="fpost('#fpengawasanPenandaan_010', '', '');">
                                        <span><span class="icon"></span>&nbsp; <?php echo $save; ?> Proses</span></a>&nbsp;<?php } ?><a href="javascript:void(0)" class="button back" onclick="goBack()" >
                                    <span><span class="icon"></span>&nbsp; Kembali</span></a></div>
                        </div>
                    </div>
                </div>
                <input type="hidden" id="kesimpulanHasilPenilaianVal" name="VALUEPENILAIAN"  value="<?php echo $sess['SISTEM']; ?>" />
                <input type="hidden" name="PENANDAAN_ID[]" value="<?php echo $sess['PENANDAAN_ID']; ?>" />
                <input type="hidden" name="UPDATE" value="<?php echo $sess['STATUS']; ?>" />
                <input type="hidden" name="EDIT" value="<?php echo $editTL; ?>" />
                <input type="hidden" name="TUJUAN" value="<?php echo $tujuan; ?>" />
                <input type="hidden" name="KOMODITI[]" value="<?php echo $sess['KOMODITI']; ?>" />
            </div>
        </div>
    </form>
</div>
<script type="text/javascript">
                                function goBack()
                                {
                                    window.history.back()
                                }
                                function verifikasiPusat(X) {
                                    var mkTMK = $(X).val();
                                    if (mkTMK === "MK") {
                                        $(".vTMK").hide();
                                        $(".vTMK").attr("rel", "");
                                        $(".vTMK").val("");
                                        $(".vTMK2").hide("slow");
                                        $(".vTMK2").val("");
                                        $(".vTMK2").attr("rel", "");
                                        $(".vTMK2a").val("");
                                        $("#vTMKSub").attr("rel", "");
                                    }
                                    else if (mkTMK === "TMK") {
                                        $(".vTMK").show();
                                        $(".vTMK").attr("rel", "required");
                                        $("#vTMKSub").attr("rel", "required");
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
                                    if (mkTMK !== '') {
                                        if (mkTMK !== $("#kesimpulanHasilPenilaianVal").val()) {
                                            $(".vJustifikasi").show("slow");
                                            $(".chkJustifikasi").attr("rel", "required");
                                        } else if (mkTMK === $("#kesimpulanHasilPenilaianVal").val()) {
                                            $(".vJustifikasi").hide("slow");
                                            $(".chkJustifikasi").attr("rel", "");
                                        }
                                    } else {
                                        $(".vJustifikasi").hide("slow");
                                        $(".chkJustifikasi").attr("rel", "");
                                    }
                                }
                                $(document).ready(function() {
                                    $("textarea.chkJustifikasi").redactor({
                                        buttons: ['bold', 'italic', '|', 'unorderedlist', 'orderedlist', 'outdent', 'indent', '|', 'alignleft', 'aligncenter', 'alignright', 'justify'],
                                        removeStyles: false,
                                        cleanUp: true,
                                        autoformat: true
                                    });
<?php if (in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) { ?>
                                        $(".verifikasiPusat").each(function() {
                                            verifikasiPusat($(this));
                                        });
<?php } ?>
                                    $("#detail_petugas").html("Loading ...");
                                    $("#detail_petugas").load($("#detail_petugas").attr("url"));
                                    $('.verifikasiPusat').change(function() {
                                        $(".chkJustifikasi").text("");
                                        $(".vJustifikasi .redactor_box .redactor_frame").contents().find("#page").html("<p>&nbsp;</p>");
                                        verifikasiPusat($(this));
                                    });
                                });

</script>