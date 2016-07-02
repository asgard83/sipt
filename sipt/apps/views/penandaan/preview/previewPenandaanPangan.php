<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
error_reporting(E_ERROR);
?>
<div id="judulpmnpdd" class="judul"></div>
<div class="headersarana">PENGAWASAN PENANDAAN PANGAN</div>
<?php
$detail = explode('#', $sess['PENILAIAN']);
$detail2 = explode('^', $sess['URAIAN']);
if ($sess['JENIS'] == "IRT") {
    $lampiranFold = "irt";
} else if ($sess['JENIS'] == "MD/ML") {
    $lampiranFold = "mdml";
}
?>
<div class="content">
    <form action="<?php echo $act; ?>" method="post" autocomplete="off" id="fpengawasanPenandaan_013">
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
                <div style="height:5px;"></div><div class="expand"><a title="expand/collapse" href="#" style="display: block;">INFORMASI PANGAN PENANDAAN</a></div>
                <div class="collapse">
                    <div class="accCntnt">
                        <h2 class="small garis">Informasi Produk Penandaan</h2>
                        <table class="form_tabel">
                            <tr><td class="td_left">Nama Produk</td><td><?php
                                    echo $sess['NAMA_PRODUK'];
                                    if ($sess['TIE'] == "1")
                                        echo "&nbsp;&nbsp;&raquo;&nbsp;&nbsp;Produk TIE</b>"
                                        ?></td></tr>
                            <tr><td class="td_left">Merk Produk</td><td><?php echo $sess['MERK_PRODUK']; ?></td></tr>
                            <tr><td class="td_left">Nomor Izin Edar</td><td><?php echo $sess['NOMOR_IZIN_EDAR']; ?></td></tr>
                            <tr><td class="td_left">Kemasan / Netto</td><td><?php echo $sess['BESAR_KEMASAN']; ?></td></tr>
                            <tr><td class="td_left">Produsen</td><td><?php echo $sess['PRODUSEN']; ?></td></tr>
                            <tr><td class="td_left">Alamat Produsen</td><td><?php echo $sess['ALAMAT_PRODUSEN']; ?></td></tr>
                            <tr><td class="td_left">Importir / Distributor</td><td><?php echo $sess['IMPORTIR']; ?></td></tr>
                            <tr><td class="td_left">Alamat Importir / Distributor</td><td><?php echo $sess['ALAMAT_IMPORTIR']; ?></td></tr>
                            <tr><td class="td_left">Jenis Pangan</td><td><?php echo $sess['GOLONGAN_PRODUK']; ?></td></tr>
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
                                        <td class="td_left"><h3>Isian Penilaian</h3></td>
                                    </tr>
                                    <?php
                                    $i = 0;
                                    $data = count($detail);
                                    for ($i; $i < $data; $i++) {
                                        if ($i != 5 && $i != 6)
                                            $d2 = explode('_', $detail[$i]);
                                        else if ($i == 5)
                                            $d2 = explode('_', $detail[$i + 1]);
                                        else if ($i == 6)
                                            $d2 = explode('_', $detail[$i - 1]);
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
                                                    if (trim($detail2[$i]) != "")
                                                        echo "&nbsp;<b>" . $detail2[$i] . "</b>&nbsp;";
                                                    ?></td>
                                            </tr>
                                            <?php
                                        }
                                    } if (trim(end($detail2)) != "") {
                                        ?>
                                        <tr>
                                            <td class="td_left">Lain - lain</td>
                                            <td class="td_right"><?php
                                                if (trim($detail2[10]) != "")
                                                    echo $detail2[10];
                                                else
                                                    echo "-";
                                                ?></td>
                                            <td></td>
                                        </tr>
<?php } ?><tr>
                                        <td class="td_left">Lampiran</td>
                                        <td class="td_right" style="width: 25%"><?php if ($sess['LAMPIRAN'] != '' && $sess['LAMPIRAN'] != 0) { ?><a href="<?php echo base_url(); ?>files/<?php echo 'penandaan_013/' . $lampiranFold; ?>/<?php echo $sess['LAMPIRAN']; ?>" target="_blank">Lihat Lampiran</a><?php
                                            } else {
                                                echo '-';
                                            }
                                            ?></td>
                                        <td colspan="4"></td>
                                    </tr>
<?php if (trim($sess['SISTEM']) != "0" && trim($sess['SISTEM']) != "") { ?>
                                        <tr>
                                            <td class="td_left">Kesimpulan</td>
                                            <td class="td_right"><?php
                                                if ($sess['SISTEM'] == "MK")
                                                    echo "Memenuhi Ketentuan";
                                                else
                                                    echo "Tidak Memenuhi Ketentuan";
                                                ?></td>
                                            <td colspan="4">&nbsp;</td>
                                        </tr>
<?php } if (trim($sess["TL_BALAI"]) != "") { ?>
                                        <tr>
                                            <td class="td_left">Tindak Lanjut Balai</td>
                                            <td class="td_right"><?php echo $cb_tindakan_balai[$sess["TL_BALAI"]]; ?></td>
                                            <td colspan="4">&nbsp;</td>
                                        </tr>
<?php } ?>
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
                                <table class="form_tabel">
                                    <?php
                                    $pusat = explode("*", $sess['PUSAT']);
                                    $justifikasi = preg_replace('/(?:<|&lt;)\/?([a-zA-Z]+) *[^<\/]*?(?:>|&gt;)/', '', $pusat[2]) . "\n";
                                    if ((trim($sess['PUSAT']) == "" && in_array('2', $this->newsession->userdata('SESS_KODE_ROLE'))) || $editTL == 'YES') {
                                        ?>
                                        <tr><td class="td_left">Verifikasi Pusat</td><td class="td_right"><select class="stext verifikasiPusat" name="<?php echo 'PENANDAAN[HASIL_PUSAT]' ?>" rel="required" title="MK/TMK"><option></option><option value="MK" <?php if ($pusat[0] == 'MK') echo 'Selected' ?>>Memenuhi Ketentuan</option><option value="TMK"  <?php if ($pusat[0] == 'TMK') echo 'Selected' ?>>Tidak Memenuhi Ketentuan</option></select></td></tr>
                                        <tr class="vTMK" hidden><td class="td_left"style="background-color: white;">Tindak Lanjut</td><td class="td_right" style="background-color: white;"><?php echo form_dropdown('PENANDAAN[TL_PUSAT]', $cb_tl, is_array($pusat) ? $pusat[1] : '', 'class="stext vTMK" id="vTMKSub" title="Tindak Lanjut Pusat"'); ?></td></tr>
                                        <tr class="vJustifikasi" hidden><td class="td_left" style="background-color: white;">Justifikasi</td><td class="td_right" style="background-color: white;"><textarea name="JUSTIFIKASI" title="Justifikasi Pusat" class="stext chkJustifikasi" id="XXX" style="height: 140px;"><?php echo $justifikasi; ?></textarea></td></tr> <?php
                                    } else {
                                        if ($pusat[0] == "TMK") {
                                            ?>
                                            <tr><td class="td_left">Verifikasi Pusat</td><td><b><i><?php
                                                            echo 'Tidak Memenuhi Ketentuan';
                                                            ?></i></b></td></tr><?php if (trim($pusat[1]) != "") { ?>
                                                <tr><td class="td_left">Tindak Lanjut Pusat</td><td><?php echo $cb_tl[$pusat[1]]; ?></td></tr>
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
                    <div style="padding:10px;"></div><div><?php if ($formEdit === 'check') { ?><a href="javascript:void(0)" id="btnSave" class="button check" onclick="fpost('#fpengawasanPenandaan_013', '', '');">
                                <span><span class="icon"></span>&nbsp; <?php echo $save; ?> Proses</span></a>&nbsp;<?php } ?><a href="javascript:void(0)" class="button back" onclick="goBack()" >
                            <span><span class="icon"></span>&nbsp; Kembali</span></a></div>
                </div>
            </div>
        </div>
        <input type="hidden" id="kesimpulanHasilPenilaianVal" name="HASIL"  value="<?php echo $sess['SISTEM']; ?>" />
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
                            if (mkTMK === "MK") {
                                $(".vTMK").hide();
                                $(".vTMK").attr("rel", " ");
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
                        });
</script>