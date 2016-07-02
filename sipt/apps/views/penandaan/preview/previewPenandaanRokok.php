<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
error_reporting(E_ERROR);
?>
<div id="judulpmnpdd" class="judul"></div>
<div class="headersarana">PENGAWASAN PENANDAAN ROKOK</div>
<?php
$d1 = explode('^', $sess['PENILAIAN1']);
$d2 = explode('^', $sess['PENILAIAN2']);
?>
<div class="content">
    <form action="<?php echo $act; ?>" method="post" autocomplete="off" id="fpengawasanPenandaan_012">
        <div class="adCntnr">
            <div class="acco2">
                <div class="expand"><a title="expand/collapse" href="#" style="display: block;">INFORMASI PENGAWASAN PENANDAAN</a></div>
                <div class="collapse">
                    <div class="accCntnt">
                        <h2 class="small garis">Informasi Pengawasan Penandaan</h2>
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
                            <tr><td class="td_left">Sarana</td><td class="td_right"><?php echo $sess['NAMA_SARANA']; ?></td>
                            </tr>
                            <tr><td class="td_left">Alamat</td><td class="td_right"><?php echo $sess['ALAMAT_1'] . ", " . $sess['KOTA'] . ", " . $sess['PROPINSI']; ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div style="height:5px;"></div><div class="expand"><a title="expand/collapse" href="#" style="display: block;">INFORMASI OBAT PENANDAAN</a></div>
                <div class="collapse">
                    <div class="accCntnt">
                        <h2 class="small garis">Informasi Produk Penandaan</h2>
                        <table class="form_tabel">
                            <tr><td class="td_left">Nama Produk</td><td><?php echo $sess['NAMA_PRODUK']; ?></td></tr>
                            <tr><td class="td_left">Produsen</td><td><?php echo $sess['PRODUSEN']; ?></td></tr>
                            <tr><td class="td_left">Alamat Produsen</td><td><?php echo $sess['ALAMAT_PRODUSEN']; ?></td></tr>
                            <tr><td class="td_left">Kategori Produk</td><td><?php echo $sess['KLASIFIKASI_PRODUK']; ?></td></tr>
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
                            <div>
                                <table class="form_tabel">
                                    <tr>
                                        <td style="width: 2%; background-color: white"></td>
                                        <td style="width: 25%; background-color: white"></td>
                                        <td style="width: 3%; background-color: white"></td>
                                        <td style="width: 70%; background-color: white;"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4"><b><u>Pengawasan Pencantuman Peringatan Kesehatan</u></b></td>
                                    </tr>
                                    <?php
                                    $arraySign = array("+", "-", "x", "y");
                                    $arrayGT = array("GBR", "TLS");
                                    $i = 0;
                                    foreach ($d1 as $value) {
                                        $val = explode("_", $value);
                                        if (in_array($val[0], $arraySign)) {
                                            ?>
                                            <tr>
                                                <td></td>
                                                <td class="td_left"><?php echo $val[1]; ?></td>
                                                <td class="td_left">&raquo;&raquo;</td>
                                                <td class="td_left">
                                                    <?php
                                                    if ($val[0] == "+") {
                                                        if ($i == 12 || $i == 15)
                                                            echo "Sesuai";
                                                        else
                                                            echo "Ya";
                                                    }
                                                    else if ($val[0] == "-") {
                                                        if ($i == 12 || $i == 15)
                                                            echo "Tidak Sesuai";
                                                        else
                                                            echo "Tidak Ada";
                                                    }
                                                    ?></td>
                                            </tr>
                                        <?php } else if ($val[0] == "TMK" || $val[0] == "MK") { ?>
                                            <tr>
                                                <td></td>
                                                <td class="td_left"><b>&nbsp;&nbsp;&nbsp;Evaluasi</b></td>
                                                <td class="td_left">&raquo;&raquo;</td>
                                                <td class="td_left"><b>
                                                        <?php
                                                        if ($val[0] == "MK")
                                                            echo "Memenuhi Ketentuan";
                                                        else if ($val[0] == "TMK")
                                                            echo "Tidak Memenuhi Ketentuan";
                                                        ?></b></td>
                                            </tr>
                                            <?php
                                        } else if (in_array($val[0], $arrayGT)) {
                                            if ($val[1] == "G1")
                                                $gt = "Gambar 1 : Gambar kanker mulut";
                                            if ($val[1] == "G2")
                                                $gt = "Gambar 2 : Gambar orang merokok dengan asap yang membentuk tengkorak";
                                            if ($val[1] == "G3")
                                                $gt = "Gambar 3 : Gambar kanker tenggorokan";
                                            if ($val[1] == "G4")
                                                $gt = "Gambar 4 : Gambar orang merokok dengan anak didekatnya";
                                            if ($val[1] == "G5")
                                                $gt = "Gambar 5 : Gambar paru-paru yang menghitam karena kanker";
                                            if ($val[1] == "T1")
                                                $gt = "Tulisan 1 : Merokok sebabkan kanker mulut";
                                            if ($val[1] == "T2")
                                                $gt = "Tulisan 2 : Merokok Membunuhmu";
                                            if ($val[1] == "T3")
                                                $gt = "Tulisan 3 : Merokok Sebabkan Kanker Tenggorokan";
                                            if ($val[1] == "T4")
                                                $gt = "Tulisan 4 : Merokok Dekat Anak Berbahaya Bagi Mereka";
                                            if ($val[1] == "T5")
                                                $gt = "Tulisan 5 : Merokok Sebabkan Kanker Paru-paru dan Bronkitis Kronis";
                                            ?>
                                            <tr>
                                                <td></td>
                                                <td class="td_left"><b>&nbsp;&nbsp;&nbsp;</b></td>
                                                <td class="td_left">&raquo;&raquo;</td>
                                                <td class="td_left"><b>
                                                        <?php
                                                        echo $gt;
                                                        ?></b></td>
                                            </tr>
                                            <?php
                                        } else {
                                            if (trim($val[0] != "")) {
                                                if ($i == 13)
                                                    $txtLuas = "Depan";
                                                else if ($i == 14)
                                                    $txtLuas = "Belakang";
                                                ?>
                                                <tr>
                                                    <td></td>
                                                    <td class="td_left" style="padding-left: 2%;"><?php echo $txtLuas; ?></td>
                                                    <td class="td_left">&raquo;&raquo;</td>
                                                    <td class="td_left"><?php echo $val[0] . "&nbsp;&nbsp;%"; ?></td>
                                                </tr>
                                                <?php
                                            }
                                        }
                                        $i++;
                                    }
                                    ?>
                                    <tr>
                                        <td colspan="4" style="border-bottom: 1px solid">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td colspan="4"><b><u>Pencantuman Informasi Kesehatan</u></b></td>
                                    </tr>
                                    <?php
                                    $i = 0;
                                    foreach ($d2 as $value) {
                                        $val = explode("_", $value);
                                        if (in_array($val[0], $arraySign)) {
                                            ?>
                                            <tr>
                                                <td></td>
                                                <td class="td_left"><?php echo $val[1]; ?></td>
                                                <td class="td_left">&raquo;&raquo;</td>
                                                <td class="td_left">
                                                    <?php
                                                    if ($val[0] == "+") {
                                                        if ($i == 3)
                                                            echo "Sesuai";
                                                        else
                                                            echo "Ada";
                                                    }
                                                    else if ($val[0] == "-") {
                                                        if ($i == 3)
                                                            echo "Tidak Sesuai";
                                                        else
                                                            echo "Tidak Ada";
                                                    }
                                                    ?></td>
                                            </tr>
                                        <?php } else if ($val[0] == "TMK" || $val[0] == "MK") { ?>
                                            <tr>
                                                <td></td>
                                                <td class="td_left"><b>&nbsp;&nbsp;&nbsp;Evaluasi</b></td>
                                                <td class="td_left">&raquo;&raquo;</td>
                                                <td class="td_left"><b>
                                                        <?php
                                                        if ($val[0] == "MK")
                                                            echo "Memenuhi Ketentuan";
                                                        else if ($val[0] == "TMK")
                                                            echo "Tidak Memenuhi Ketentuan";
                                                        ?></b></td>
                                            </tr>
                                            <?php
                                        } else {
                                            if (trim($val[0] != "")) {
                                                if ($i == 1 || $i == 2)
                                                    $mgTxt = "mg";
                                                else
                                                    $mgTxt = "";
                                            }
                                            $nikotar = "";
                                            if ($i == "1")
                                                $nikotar = "Nikotin";
                                            else if ($i == "2")
                                                $nikotar = "Tar";
                                            ?>
                                            <tr>
                                                <td></td>
                                                <td class="td_left"></td>
                                                <td class="td_left">&raquo;&raquo;</td>
                                                <td class="td_left" style="padding-left: 1%;"><?php echo $nikotar . " " . $val[0] . "&nbsp;&nbsp;" . $mgTxt; ?></td>
                                            </tr>
                                            <?php
                                        }
                                        $i++;
                                    }
                                    ?>
                                    <tr>
                                        <td colspan="4" style="border-bottom: 1px solid">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td class="td_left">Lampiran</td>
                                        <td class="td_right" colspan="2"><?php if ($sess['LAMPIRAN'] != '' && $sess['LAMPIRAN'] != 0) { ?><a href="<?php echo base_url(); ?>files/<?php echo 'penandaan_007/'; ?><?php echo $sess['LAMPIRAN']; ?>" target="_blank">Lihat Lampiran</a><?php
                                            } else {
                                                echo '-';
                                            }
                                            ?></td>
                                    </tr>
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
                                    <?php
                                    if ($this->newsession->userdata('SESS_BBPOM_ID') == '92') {
                                        $pusat = explode("*", $sess['PUSAT']);
                                        $justifikasi = preg_replace('/(?:<|&lt;)\/?([a-zA-Z]+) *[^<\/]*?(?:>|&gt;)/', '', $pusat[2]) . "\n";
                                        $hasil = explode("^", $pusat[1]);
                                        if (in_array('2', $this->newsession->userdata('SESS_KODE_ROLE')) && $editTL == 'YES') {
                                            ?>
                                            <tr><td class="td_left">Verifikasi Pusat</td><td class="td_right"><select class="stext verifikasiPusat" name="<?php echo 'PENANDAAN[HASIL_PUSAT]' ?>" rel="required" title="MS/TMS"><option></option><option value="MS" <?php if ($pusat[0] == 'MS') echo 'Selected' ?>>Memenuhi Syarat</option><option value="TMS"  <?php if ($pusat[0] == 'TMS') echo 'Selected' ?>>Tidak Memenuhi Syarat</option></select></td></tr>
                                            <tr class="vTMK" hidden><td class="td_left">Kategori Pelanggaran</td><td class="td_right"><select class="stext vTMKa" name="<?php echo 'PENANDAAN[TL_PUSAT][]' ?>" title="Kategori Pelanggaran"><option></option><option value="Minor" <?php if ($hasil[0] == 'Minor') echo 'Selected' ?>>Minor</option><option value="Mayor" <?php if ($hasil[0] == 'Mayor') echo 'Selected' ?>>Mayor</option><option value="Kritikal" <?php if ($hasil[0] == 'Kritikal') echo 'Selected' ?>>Kritikal</option></select></td></tr>
                                            <tr class="vTMK" hidden><td class="td_left"style="background-color: white;">Tindak Lanjut</td><td class="td_right" style="background-color: white;"><?php echo form_dropdown('PENANDAAN[TL_PUSAT][]', $cb_tl, is_array($hasil) ? $hasil[1] : '', 'class="stext vTMK" id="vTMKSub" title="Tindak Lanjut Pusat"'); ?></td></tr>
                                            <tr class="vJustifikasi" hidden><td class="td_left" style="background-color: white;">Justifikasi</td><td class="td_right" style="background-color: white;"><textarea name="JUSTIFIKASI" title="Justifikasi Pusat" class="stext chkJustifikasi" id="XXX" style="height: 140px;"><?php echo $pusat[3]; ?></textarea></td></tr> <?php
                                        } else {
                                            if ($pusat[0] == "TMS") {
                                                ?>
                                                <tr><td class="td_left">Verifikasi Pusat</td><td class="td_right"><b><i><?php
                                                                echo "Tidak Memenuhi Syarat";
                                                                ?></i></b></td></tr>
                                                <tr><td class="td_left">Kategori Pelanggaran</td><td class="td_right"><?php echo $hasil[0]; ?></td></tr>
                                                <?php if ($hasil[1] != NULL) { ?><tr><td class="td_left">Tindak Lanjut Pusat</td><td class="td_right"><?php
                                                    echo $hasil[1];
                                                    ?></td></tr>
                                                <?php } if ($pusat[2] != NULL) { ?>
                                                    <tr><td class="td_left">Justifikasi Pusat</td><td class="td_right"><?php echo $justifikasi; ?></td></tr>
                                                    <?php
                                                }
                                            } else {
                                                ?>
                                                <tr><td class="td_left">Verifikasi Pusat</td><td class="td_right"><b><i><?php
                                                                echo 'Memenuhi Ketentuan';
                                                                ?></i></b></td></tr>
                                                <?php if ($pusat[2] != NULL) { ?>
                                                    <tr><td class="td_left">Justifikasi Pusat</td><td class="td_right"><?php echo $justifikasi; ?></td></tr>
                                                    <?php
                                                }
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

                    <div style="padding:10px;"></div><div><?php if ($formEdit === 'check') { ?><a href="javascript:void(0)" id="btnSave" class="button check" onclick="fpost('#fpengawasanPenandaan_012', '', '');">
                                <span><span class="icon"></span>&nbsp; <?php echo $save; ?> Proses</span></a>&nbsp;<?php } ?><a href="javascript:void(0)" class="button back" onclick="goBack()" >
                            <span><span class="icon"></span>&nbsp; Kembali</span></a></div>
                </div>
            </div>
        </div>
        <input type="hidden" id="kesimpulanHasilPenilaianVal" name="VALUEPENILAIAN"  value="<?php echo $sess['SISTEM']; ?>" />
        <input type="hidden" name="PENANDAAN_ID[]" value="<?php echo $sess['PENANDAAN_ID']; ?>" />
        <input type="hidden" name="UPDATE" value="<?php echo $sess['STATUS']; ?>" />
        <input type="hidden" name="EDIT" value="<?php echo $editTL; ?>" />
        <input type="hidden" name="KOMODITI[]" value="<?php echo $sess['KOMODITI']; ?>" />
    </form>
</div>
<script type="text/javascript">
                        function goBack()
                        {
                            window.history.back()
                        }
                        function verifikasiPusat(X) {
                            var mkTMK = $(X).val();
                            if (mkTMK === "MS") {
                                $(".vTMK").hide();
                                $(".vTMK").attr("rel", " ");
                                $(".vTMK").val("");
                                $(".vTMKa").val("");
                                $(".vTMKa").attr("rel", "");
                                $(".vTMK2").hide("slow");
                                $(".vTMK2").val("");
                                $(".vTMK2").attr("rel", "");
                                $(".vTMK2a").val("");
                                $("#vTMKSub").attr("rel", "");
                            }
                            else if (mkTMK === "TMS") {
                                $(".vTMK").show();
                                $(".vTMK").attr("rel", "required");
                                $(".vTMKa").attr("rel", "required");
                                $("#vTMKSub").attr("rel", "required");
                            }
                            else {
                                $(".vTMK").hide();
                                $(".vTMK").hide();
                                $(".vTMK").attr("rel", " ");
                                $(".vTMK").val("");
                                $(".vTMKa").val("");
                                $(".vTMKa").attr("rel", "");
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
                        $(document).ready(function() {
                            $("textarea.chkJustifikasi").redactor({
                                buttons: ['bold', 'italic', '|', 'unorderedlist', 'orderedlist', 'outdent', 'indent', '|', 'alignleft', 'aligncenter', 'alignright', 'justify'],
                                removeStyles: false,
                                cleanUp: true,
                                autoformat: true
                            });
                            if ("<?php echo $this->newsession->userdata("SESS_BBPOM_ID") ?>" === "92") {
                                $(".verifikasiPusat").each(function() {
                                    verifikasiPusat($(this));
                                });
                                $(".verifikasiPusatSub").each(function() {
                                    verifikasiTL($(this));
                                });
                            }
                            $("#detail_petugas").html("Loading ...");
                            $("#detail_petugas").load($("#detail_petugas").attr("url"));
                            $('.verifikasiPusat').change(function() {
                                $(".chkJustifikasi").text("");
                                $(".vJustifikasi .redactor_box .redactor_frame").contents().find("#page").html("<p>&nbsp;</p>");
                                verifikasiPusat($(this), 0);
                            });
                            $(".verifikasiPusatSub").change(function() {
                                verifikasiTL($(this));
                            });
                        });
</script>