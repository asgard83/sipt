<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
error_reporting(E_ERROR);
?>
<div id="judulpmnpdd" class="judul"></div>
<div class="headersarana">PENGAWASAN PENANDAAN KOSMETIKA</div>
<?php
$detail = explode('#', $sess['PENILAIAN']);
$detail2 = explode('^', $sess['URAIAN']);
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
                            <tr><td class="td_left">Nama Produk</td><td><?php echo $sess['NAMA_PRODUK']; ?></td> </tr>
                            <tr><td class="td_left">Nomor Izin Edar</td><td><?php echo $sess['NOMOR_IZIN_EDAR']; ?></td> </tr>
                            <tr><td class="td_left">Nama Pemohon Notifikasi</td><td><?php echo $sess['PENDAFTAR']; ?></td> </tr>
                            <tr><td class="td_left">Alamat Pemohon Notifikasi</td><td><?php echo $sess['ALAMAT_PENDAFTAR']; ?></td> </tr>
                            <tr><td class="td_left">Produsen</td><td><?php echo $sess['PRODUSEN']; ?></td> </tr>
                            <tr><td class="td_left">Alamat Produsen</td><td><?php echo $sess['ALAMAT_PRODUSEN']; ?></td> </tr>
                            <tr><td class="td_left">Importir</td><td><?php echo $sess['IMPORTIR']; ?></td> </tr>
                            <tr><td class="td_left">Alamat Importir</td><td><?php echo $sess['ALAMAT_IMPORTIR']; ?></td> </tr>
                            <tr><td class="td_left">Pemberi Lisensi</td><td><?php echo $sess['LISENSI']; ?></td> </tr>
                            <tr><td class="td_left">Alamat Pemberi Lisensi</td><td><?php echo $sess['ALAMAT_LISENSI']; ?></td> </tr>
                            <tr><td class="td_left">Pabrik Pengemas</td><td><?php echo $sess['PENGEMAS']; ?></td> </tr>
                            <tr><td class="td_left">Alamat Pabrik Pengemas</td><td><?php echo $sess['ALAMAT_PENGEMAS']; ?></td> </tr>
                            <tr><td class="td_left">Kategori Produk</td><td><?php echo $sess['GOLONGAN_PRODUK']; ?></td></tr>
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
                                <table class="form_tabel" style="width: 100%;">
                                    <tr>
                                        <td class="td_left" style="width: 20%"><h3>Poin Penilaian</h3></td>
                                        <td class="td_right" style="width: 20%"><h3>Penilaian</h3></td>
                                        <td class="td_left"><h3>Keterangan</h3></td>
                                    </tr>
                                    <?php
                                    $i = 0;
                                    foreach ($detail as $value) {
                                        $d2 = explode('_', $value);
                                        if ($d2[0] != "" && $i < 15) {
                                            ?>
                                            <tr>
                                                <td class="td_left"><span <?php if ($i == 3 || $i == 4 || $i == 5 || $i == 6 || $i == 7) echo 'style="margin-left: 20px;"'; ?>><?php echo $d2[1]; ?></span></td>
                                                <td class="td_right"><?php
                                                    if ($d2[0] == "-") {
                                                        echo 'Tidak Ada';
                                                    } else if ($d2[0] == "+") {
                                                        if ($i == 14)
                                                            echo 'Ada';
                                                        else
                                                            echo 'Ada / Sesuai';
                                                    } else if ($d2[0] == "X") {
                                                        echo 'Tidak Sesuai';
                                                    }
                                                    ?></td>
                                                <td><?php
                                                    if (trim($detail2[$i]) != "")
                                                        echo "&nbsp;<b>" . $detail2[$i] . "</b>&nbsp;";
                                                    ?></td>
                                            </tr>
                                            <?php if ($d2[0] != "" && $i == 2) { ?>
                                                <tr><td colspan="3"><b><u>Nama & Alamat</u></b></td></tr>
                                                <?php
                                            }
                                        } $i++;
                                        if ($d2[0] != "" && $i == 15 && $d2[0] != "-") {
                                            ?>
                                            <tr>
                                                <td colspan="3" class="td_right"><b><u>Kemasan Primer</u></b></td>
                                            </tr>
                                            <?php
                                        }
                                        if ($d2[0] != "" && $i > 15) {
                                            ?>
                                            <tr>
                                                <td class="td_right"><span style="margin-left: 20px;"><?php echo $d2[1]; ?></span></td>
                                                <td><?php
                                                    if ($d2[0] == "-") {
                                                        echo 'Tidak Ada';
                                                    } else if ($d2[0] == "+") {
                                                        echo 'Ada / Sesuai';
                                                    } else if ($d2[0] == "X") {
                                                        echo 'Tidak Sesuai';
                                                    }
                                                    ?></td>
                                                <td>&nbsp;</td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    ?>
                                    <tr><td class="td_left" style="padding-left: 20px" colspan="3"><h2 class="small garis">Lampiran</h2></td></tr>
                                    <?php
                                    if (trim($sess['LAMPIRAN']) != '' && $sess['LAMPIRAN'] != 0) {
                                        $arrDataLamp = explode("^", $sess["LAMPIRAN"]);
                                        foreach ($arrDataLamp as $value) {
                                            $arrLamp = explode(".", $value);
                                            ?>
                                            <tr><td class="td_left" style="padding-left: 20px" colspan="3"><a href="<?php echo base_url(); ?>files/<?php echo 'penandaan_012/'; ?><?php echo $value; ?>" target="_blank" <?php if ($arrLamp[1] == "rar") echo 'onclick="dotRar();return false;"'; ?>>Lihat Lampiran</a></td></tr>
                                            <?php
                                        }
                                    } else {
                                        ?>
                                        <tr><td class="td_left" style="padding-left: 20px" colspan="3"><td class="td_right">-</td></tr>
                                    <?php } if (trim($sess['SISTEM']) != "") { ?>
                                        <tr><td colspan="4">&nbsp;</td></tr>
                                        <tr>
                                            <td class="td_left">Kesimpulan</td>
                                            <td class="td_right"><?php
                                                if ($sess['SISTEM'] == "MS")
                                                    echo "Memenuhi Syarat";
                                                else if ($sess['SISTEM'] == "TMS")
                                                    echo "Tidak Memenuhi Syarat";
                                                else if ($sess['SISTEM'] == "TIE")
                                                    echo "Tidak Memiliki Izin Edar";
                                                ?></td>
                                            <td colspan="4">&nbsp;</td>
                                        </tr>
                                        <?php if ($sess['SISTEM'] == "TMS") { ?>
                                            <tr>
                                                <td class="td_left">Tindak Lanjut Balai</td>
                                                <td class="td_right"><?php
                                                    echo $cb_tindakan_balai[$sess['TL_BALAI']];
                                                    ?></td>
                                                <td colspan="4">&nbsp;</td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    ?>
                                </table>
<!--                                <table class="form_tabel">
                                    <tr><td colspan="3">&nbsp;</td></tr>
                                    <tr><td class="td_left" style="padding-left: 20px" colspan="3"><h2 class="small garis">Lampiran</h2></td></tr>
                                <?php
                                if (trim($sess['LAMPIRAN']) != '' && $sess['LAMPIRAN'] != 0) {
                                    $arrDataLamp = explode("^", $sess["LAMPIRAN"]);
                                    foreach ($arrDataLamp as $value) {
                                        $arrLamp = explode(".", $value);
                                        ?>
                                                                                                                    <tr><td class="td_left" style="padding-left: 20px" colspan="3"><a href="<?php echo base_url(); ?>files/<?php echo 'penandaan_012/'; ?><?php echo $value; ?>" target="_blank" <?php if ($arrLamp[1] == "rar") echo 'onclick="dotRar();return false;"'; ?>>Lihat Lampiran</a></td></tr>
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
                                <?php if ($sess['TL_BALAI'] != 0) { ?><tr><td class="td_left" style="padding-left: 20px">Tindak Lanjut</td><td class="td_right"><?php
                                    echo $sess["TL_BALAI"];
                                    ?></td></tr>
                                <?php } ?>
                                </table>-->
                                </table>
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
                                    <?php
                                    $pusat = explode("*", $sess['PUSAT']);
                                    $justifikasi = preg_replace('/(?:<|&lt;)\/?([a-zA-Z]+) *[^<\/]*?(?:>|&gt;)/', '', $pusat[2]) . "\n";
                                    if ((trim($sess['PUSAT']) == "" && in_array('2', $this->newsession->userdata('SESS_KODE_ROLE'))) || $editTL == 'YES') {
                                        ?>
                                        <tr><td class="td_left">Verifikasi Pusat</td><td class="td_right"><select class="stext verifikasiPusat" name="<?php echo 'PENANDAAN[HASIL_PUSAT]' ?>" rel="required" title="MS/TMS"><option></option><option value="MS" <?php if ($pusat[0] == 'MS') echo 'Selected' ?>>Memenuhi Syarat</option><option value="TMS"  <?php if ($pusat[0] == 'TMS') echo 'Selected' ?>>Tidak Memenuhi Syarat</option><option value="TIE"  <?php if ($pusat[0] == 'TIE') echo 'Selected' ?>>Tidak Memiliki Izin Edar</option></select></td></tr>
                                        <tr class="vTMK" hidden><td class="td_left"style="background-color: white;">Tindak Lanjut</td><td class="td_right" style="background-color: white;"><?php echo form_dropdown('PENANDAAN[TL_PUSAT]', $cb_tindakan, is_array($pusat) ? $pusat[1] : '', 'class="stext vTMK" id="vTMKSub" title="Tindak Lanjut Pusat"'); ?></td></tr>
                                        <tr class="vJustifikasi" hidden><td class="td_left" style="background-color: white;">Justifikasi</td><td class="td_right" style="background-color: white;"><textarea name="JUSTIFIKASI" title="Justifikasi Pusat" class="stext chkJustifikasi" id="XXX" style="height: 140px;"><?php echo $justifikasi; ?></textarea></td></tr> <?php
                                    }else {
                                        if ($pusat[0] == "TMS") {
                                            ?>
                                            <tr><td class="td_left">Verifikasi Pusat</td><td><b><i><?php
                                                            echo 'Tidak Memenuhi Syarat';
                                                            ?></i></b></td></tr><?php if (trim($pusat[1]) != "") { ?>
                                                <tr><td class="td_left">Tindak Lanjut Pusat</td><td><?php echo $cb_tindakan[$pusat[1]]; ?></td></tr>
                                            <?php } if (trim($pusat[2]) != "") { ?>
                                                <tr><td class="td_left">Justifikasi Pusat</td><td><?php echo $justifikasi; ?></td></tr>
                                                <?php
                                            }
                                        } else {
                                            ?>
                                            <tr><td class="td_left">Verifikasi Pusat</td><td><b><i><?php
                                                            echo $pusat[0] == "MS" ? 'Memenuhi Syarat' : 'Tidak Memiliki Izin Edar';
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
                                $(".vTMK2").hide("slow");
                                $(".vTMK2").val("");
                                $(".vTMK2").attr("rel", "");
                                $(".vTMK2a").val("");
                                $("#vTMKSub").attr("rel", "");
                            }
                            else if (mkTMK === "TMS") {
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
                                autoformat: true,
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
                                verifikasiPusat($(this), 0);
                            });
                            $(".verifikasiPusatSub").change(function() {
                                verifikasiTL($(this));
                            });
                        });
</script>