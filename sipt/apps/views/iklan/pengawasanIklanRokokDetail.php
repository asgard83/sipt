<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
error_reporting(E_ERROR);
?>
<link type="text/css" href="<?php echo base_url(); ?>css/iklanPenandaan.css" rel="stylesheet" media="screen"/>
<div id="judulpmnikl" class="judul"></div>
<div class="headersarana">PENGAWASAN IKLAN ROKOK </div>
<?php
$bulan_iklan = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
$tahun_iklan = array(range(date("Y"), 2007));
$totalThn = array_sum(array_map("count", $tahun_iklan));
$UP = explode('^', $sess['URAIAN_PELANGGARAN']);
$tayangMedia = explode(" ", $sess['JAM_TAYANG']);
$hasilKesimpulanOpt = explode("^", $sess['TL_PUSAT']);
$hasilKesimpulanOpt2 = explode("^", $sess['DETAIL_PUSAT']);
$kelompokIklan = array("" => "", "Iklan" => "Iklan", "Sponsor" => "Sponsor", "Layanan Masyarakat" => "Layanan Masyarakat");
$edisiUraian = explode("^", $sess['EDISI']);
$edisiMedia = explode(" ", $edisiUraian[0]);
$kegiatan = explode("^", $sess['JUDUL_KEGIATAN']);
$penilaianAll = explode("#", $sess["PENILAIAN"]);
if ($sess["JENIS"] == "CT") {
    foreach ($penilaianAll as $value) {
        $penCT[] = explode("_", $value);
    }
    $penilaianCT = $penilaianAll;
}
if ($sess["JENIS"] == "RD") {
    foreach ($penilaianAll as $value) {
        $penRD[] = explode("_", $value);
    }
    $penilaianRD = $penilaianAll;
}
if ($sess["JENIS"] == "TV") {
    foreach ($penilaianAll as $value) {
        $penTV[] = explode("_", $value);
    }
    $penilaianTV = $penilaianAll;
}
if ($sess["JENIS"] == "TI") {
    foreach ($penilaianAll as $value) {
        $penTI[] = explode("_", $value);
    }
    $penilaianTI = $penilaianAll;
}
if ($sess["JENIS"] == "LR") {
    foreach ($penilaianAll as $value) {
        $penLR[] = explode("_", $value);
    }
    $penilaianLR = $penilaianAll;
}
?>
<div class="content">
    <form action="<?php echo $act; ?>" method="post" autocomplete="off" id="fpengawasanIklan_007">
        <div class="adCntnr">
            <div class="acco2">
                <div class="expand"><a title="expand/collapse" href="#" style="display: block;">INFORMASI PENGAWASAN IKLAN</a></div>
                <div class="collapse">
                    <div class="accCntnt">
                        <table class="form_tabel">
                            <tr class="urut<?php echo $i; ?>" hidden="true">
                                <td class="atas">Unit / Balai Besar / Balai</td>
                                <td><input type="text" class="stext" readonly="readonly" value="<?php echo $this->newsession->userdata('SESS_MBBPOM'); ?>" name="BBPOM[MBBPOM_ID][]" val="<?php echo $nomor[$i]; ?>" title="Balai Besar / Balai POM" /><input type="hidden" name="BBPOM[BBPOM_ID][]" value="<?php echo $this->newsession->userdata('SESS_BBPOM_ID'); ?>" id="bpomid" /></td>
                            </tr>
                        </table>
                        <br />
                        <div id="detail_petugas" url="<?php echo $histori_petugas; ?>"></div>
                        <div style="height:15px;"></div>
                        <table class="form_tabel">
                            <tr><td class="td_left">Tanggal Pengawasan</td><td class="td_right">
                                    <input type="hidden" class="sdate" name="IKLAN[TANGGALSURAT]" id="tglXX<?php echo $i; ?>" title="Tanggal Surat" value="<?php
                                    if ($this->session->userdata('TANGGAL') != "-") {
                                        echo $this->session->userdata('TANGGAL');
                                    }
                                    ?>"/>
                                    <input type="text" class="sdate" name="IKLAN[TANGGALAWAL]" id="tglAwalPengawasan" title="Tanggal Pengawasan Iklan" onchange="comp('A')" rel='required' value="<?php echo $sess['TANGGAL_MULAI']; ?>"/>&nbsp; sampai dengan&nbsp;
                                    <input type="text" class="sdate" name="IKLAN[TANGGALAKHIR]" id="tglAkhirPengawasan" title="Tanggal Pengawasan Iklan" onchange="comp('B')" rel='required' value="<?php echo $sess['TANGGAL_AKHIR']; ?>"/></td>
                            </tr>
                            <tr><td class="td_left">Jenis Iklan</td>
                                <td class="td_right"><?php echo form_dropdown('IKLANNAPZA[KELOMPOK]', $kelompokIklan, $sess['KELOMPOK_IKLAN'], 'title="Kelompok Iklan" class="stext" rel="required"') ?></td>
                            </tr>
                        </table>
                    </div>
                </div><!-- Akhir Pemeriksaan !-->
                <div style="height:5px;"></div>
                <div class="acco2"><div class="expand"><a title="expand/collapse" href="#" style="display: block;">IDENTITAS ROKOK - IKLAN</a></div>
                    <div class="collapse">
                        <div class="accCntnt">
                            <table>
                                <tr>
                                    <td>
                                        <table>
                                            <tbody id="tb_napza">
                                                <?php
                                                $jmldata = 0;
                                                $nomor = array();
                                                $jmldata = count($nomor);
                                                if ($jmldata == 0) {
                                                    $jmldata = 1;
                                                    $nomor[] = "";
                                                }
                                                $i = 0;
                                                do {
                                                    ?>
                                                    <tr class="urut<?php echo $i; ?>">
                                                        <td width="150">Nama / Merk Rokok</td>
                                                        <td>
                                                            <input type="text" size="40" name="PRODUK[NAMA][]" class="namaNapza" id="namaNapza" title="Nama / Merk Rokok" rel="required" value="<?php echo $sess2[$i]['NAMA_PRODUK']; ?>"/>&nbsp;
                                                            <?php
                                                            if ($i == 0) {
                                                                ?>
                                                                <a href="javascript:void(0)" class="addnomor" periksa="urut" terakhir="<?php echo $jmldata; ?>"><img src="<?php echo base_url(); ?>images/add.png" align="absmiddle" style="border:none" title="Tambah Rokok" /></a>
                                                                <?php
                                                            } else {
                                                                ?>
                                                                <a href="javascript:void(0)" class="min" onclick="$('.urut<?php echo $i; ?>').remove();"><img src="<?php echo base_url(); ?>images/cancel.png" align="absmiddle" style="border:none" title="Hapus Rokok" /></a>
                                                                <?php
                                                            }
                                                            ?></td>
                                                    </tr>
                                                    <tr class="urut<?php echo $i; ?>">
                                                        <td width="150">Nama Produsen</td>
                                                        <td><input type="text" size="40" name="PRODUK[NAMAPEMILIKIZINEDAR][]" id="namaPemilikNIE" title="Nama Produsen" value="<?php echo $sess2[$i]['NAMA_PEMILIK_IZIN_EDAR']; ?>" rel="required" />
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="td_left">Bentuk Kemasan Produk Tembakau</td><td class="td_right"><?php echo form_dropdown("PRODUK[JENIS][]", $jenisKmsn, $sess2[$i]['JENIS_PRODUK'], "id='bentukKemasan' rel='required' class='stext' title='Bentuk Kemasan Produk Tembakau' ") ?></td>
                                                        <td colspan="2"></td>
                                                    </tr>
                                                    <?php
                                                    $i++;
                                                } while ($i < $jmldata)
                                                ?>
                                            </tbody>
                                        </table>
                                    </td></tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div style="height:5px;"></div>

                <!-- DIV Detail-->
                <div>
                    <!--1-->
                    <div class="expand" id="expand1"><a title="expand/collapse" href="#" style="display: block;">IDENTITAS MEDIA PENAYANGAN IKLAN</a></div>
                    <div class="collapse">
                        <div class="accCntnt">
                            <table class="form_tabel">
                                <tr>
                                    <td style="width: 2%;"></td>
                                    <td style="width: 50%;"></td>
                                    <td style="width: 13%;"></td>
                                    <td style="width: 35%; font-size: 14px; padding-left: 250px; padding-right: 250px; padding-bottom: 5px; padding-top: 5px;"></td>
                                </tr>
                                <tr>
                                    <td class="td_left_checklist"></td>
                                    <td class="td_left_header_checklist" style="vertical-align: top;">Media</td>
                                    <td></td>
                                    <td colspan="2" class="td_left"><select name="IKLAN[JENISIKLAN]" onChange="mediaIklan2(this);" id="iklan_media" class="stext sl_iklan_media" title="Jenis Iklan" rel="required">
                                            <option value=""></option>
                                            <option value="Cetak">Cetak</option>
                                            <option value="Penyiaran">Penyiaran</option>
                                            <option value="Luar Ruang">Luar Ruang</option>
                                            <option value="Media Teknologi Informasi Lainnya">Media Teknologi Informasi Lainnya</option></select></td>
                                </tr>
                                <tr class="iklanObatReq iorMedia">
                                    <td class="td_left_checklist"></td>
                                    <td class="td_left_header_checklist" style="vertical-align: top;"><span id="lnChoosedTitle">Jenis Media</span></td>
                                    <td></td>
                                    <td colspan="2" class="td_left lainnyaChoosed" hidden>
                                        <input type="text" class="stext mediaIklanEditTi" id="lnChoosed" name="IKLAN[MEDIA][]" title="Nama Media Teknologi Informasi" /></td>
                                    <td colspan="2" class="td_left penyiaranChoosed" hidden>
                                        <select class="stext mediaIklanEditP" id="pChoosed" onChange="mediaIklan(this);" name="IKLAN[MEDIA][]" title="Media Iklan">
                                            <option value=""></option>
                                            <option value="TV">TV</option>
                                            <option value="Radio">Radio</option></select></td>
                                    <td colspan="2" class="td_left lRChoosed" hidden>
                                        <select class="stext mediaIklanEditLr" id="lrChoosed" onChange="mediaIklan(this);" name="IKLAN[MEDIA][]" title="Media Iklan">
                                            <option value=""></option>
                                            <option value="Billboard">Billboard</option>
                                            <option value="Neon Box">Lampu Hias / Neon Box</option>
                                            <option value="Papan Nama">Papan Nama</option>
                                            <option value="Spanduk">Spanduk</option>
                                            <option value="Balon Udara">Balon Udara</option>
                                            <option value="Transit Ad (Iklan pada sarana transportasi)">Transit Ad (Iklan pada sarana transportasi)</option>
                                            <option value="Hanging Mobil">Hanging Mobil</option>
                                            <option value="Iklan Dinding">Iklan Dinding</option>
                                            <option value="Gimmick">Gimmick</option>
                                            <option value="Backdrop">Backdrop</option>
                                            <option value="Baliho">Baliho</option></select></td>
                                    <td colspan="2" class="td_left cetakChoosed">
                                        <select class="stext mediaIklanEditC" id="cChoosed" name="IKLAN[MEDIA][]" onChange="mediaIklan(this);" title="Media Iklan">
                                            <option value=""></option>
                                            <option value="Surat Kabar">Surat Kabar</option>
                                            <option value="Majalah">Majalah</option>
                                            <option value="Tabloid">Tabloid</option>
                                            <option value="Buletin">Buletin</option>
                                            <option value="Poster / Selebaran">Poster / Selebaran</option>
                                            <option value="Leaflet / Brosur">Leaflet / Brosur</option>
                                            <option value="Stiker">Stiker</option>
                                            <option value="Banner">Banner</option>
                                            <option value="Booklet / Katalog">Booklet / Katalog</option>
                                            <option value="Pamflet">Pamflet</option>
                                            <option value="Halaman Kuning">Halaman Kuning</option>
                                            <option value="Kalender ">Kalender</option>
                                            <option value="lainnya">Media Cetak Lainnya</option></select></td>
                                </tr>
                                <tr class="td_left" id="namaMedia" hidden>
                                    <td class="td_left_checklist"></td>
                                    <td class="td_left_header_checklist" style="vertical-align: top;"><span id ="namaMedia1"></span></td>
                                    <td></td>
                                    <td style="width: 10%;" colspan="2" class="td_left"><input type="text" id="namaMediaIklan" class="stext namaMedia" title="Nama Media" url="<?php echo site_url(); ?>/autocompletes/autocomplete/nama_media/" onchange="namaMedia();" value="<?php echo $sess['NAMA_MEDIA']; ?>" /><input type="hidden" id="idMediaIklan"  value="<?php echo $sess['ID_MEDIA']; ?>" /></td>
                                </tr>
                                <tr class="edisiTime" hidden>
                                    <td class="td_left_checklist" style="vertical-align: top;"></td>
                                    <td class="td_left_header_checklist" style="vertical-align: top;">Edisi / Nomor</td>
                                    <td></td>
                                    <td style="width: 10%;" class="td_left" colspan="2">
                                        <input type="text" title="Edisi" class="stext edisiTayang edisiCetak" name="IKLAN[EDISI1]" value="<?php echo $edisiUraian[0] ?>"/>
                                    </td>
                                </tr>
                                <tr class="edisiTime" hidden>
                                    <td class="td_left_checklist" style="vertical-align: top;"></td>
                                    <td class="td_left_header_checklist" style="vertical-align: top;">Halaman</td>
                                    <td></td>
                                    <td style="width: 10%;" class="td_left" colspan="2">
                                        <input type="text" title="Halaman" class="stext edisiTayang edisiCetak" name="IKLAN[EDISI2]" value="<?php echo $edisiUraian[1] ?>"/>
                                    </td>
                                </tr>
                                <tr class="time" hidden>
                                    <td class="td_left_checklist" style="vertical-align: top;"></td>
                                    <td class="td_left_header_checklist" style="vertical-align: top;">Waktu <span class="pantauTime" hidden>Pemantauan</span><span class="tayangTime" hidden>Tayang</span></td>
                                    <td></td>
                                    <td style="width: 10%;" class="td_left" colspan="2">
                                        <span><select class="edisiTayang time" title="Jam" name="IKLAN[TAYANG1]"><option value=""></option><?php
                                                for ($i = 1; $i <= 24; $i++) {
                                                    ?><option value="<?php echo $i; ?>"><?php echo $i; ?></option><?php } ?></select> : <select class="edisiTayang time" title="Jam" name="IKLAN[TAYANG2]"><option value=""></option><?php
                                                for ($i = 1; $i < 60; $i++) {
                                                    ?><option value="<?php echo $i; ?>"><?php echo $i; ?></option><?php } ?></select>&nbsp;&nbsp;&nbsp;hh : mm</span>
                                    </td>
                                </tr>
                                <tr class="td_left">
                                    <td class="td_left_checklist"></td>
                                    <td class="td_left_header_checklist" style="vertical-align: top;">Versi Iklan</td>
                                    <td></td>
                                    <td style="width: 10%;" colspan="2" class="td_left"><input type="text" name="IKLAN[JUDUL]" class="stext namaMedia" rel="required" title="Versi Iklan" value="<?php echo $kegiatan[0] ?>" /></td>
                                </tr>
                                <tr class="luarTime" hidden>
                                    <td class="td_left_checklist" style="vertical-align: top;"></td>
                                    <td class="td_left_header_checklist" style="vertical-align: top;">Lokasi / Tempat</td>
                                    <td></td>
                                    <td style="width: 10%;" class="td_left" colspan="2">
                                        <input type="text" title="Lokasi / Tempat" class="stext edisiTayang edisiLuar" name="IKLAN[EDISI]" value="<?php echo $sess['EDISI']; ?>"/>
                                    </td>
                                </tr>
                                <?php if (in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')) || $this->newsession->userdata("SESS_BBPOM_ID") == "50") { ?>
                                    <tr class="td_left luarTime" hidden>
                                        <td class="td_left_checklist"></td>
                                        <td class="td_left_header_checklist" style="vertical-align: top;">Provinsi</td>
                                        <td></td>
                                        <td style="width: 10%;" colspan="2" class="td_left"><?php echo form_dropdown('KOTA', $provinsi, $provinsiVal, 'style="width:158px" id="provkotAlamat" class="stext" title="Nama Provinsi Pengambilan Iklan"'); ?></td>
                                    </tr>
                                <?php } ?>
                                <tr class="td_left luarTime" hidden>
                                    <td class="td_left_checklist"></td>
                                    <td class="td_left_header_checklist" style="vertical-align: top;">Kota / Kabupaten</td>
                                    <td></td>
                                    <td style="width: 10%;" colspan="2" class="td_left"><?php echo form_dropdown('IKLAN[KOTA]', $kabupaten, $kabupatenVal, 'style="width:158px" id="kabkotAlamat" class="stext" title="Nama Kota Pengambilan Iklan"'); ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div style="height:5px;" id="expand2b"></div>

                    <!--5-->
                    <div class="expand" id="expand5"><a title="expand/collapse" href="#" style="display: block;">PENILAIAN</a></div>
                    <div class="collapse">
                        <div id="medianyaKosong">Silahkan pilih media : Identitas Media Penayangan Iklan => Media / Jenis Media</div>
                        <!--Radio-->
                        <div class="accCntnt"  id="penilaianRadio" hidden>
                            <table class="form_tabel">
                                <tr>
                                    <td style="width: 2%; background-color: white;"></td>
                                    <td style="width: 50%; background-color: white;"></td>
                                    <td style="width: 13%; background-color: white;"></td>
                                    <td style="width: 35%; font-size: 14px; padding-left: 250px; padding-right: 250px; padding-bottom: 5px; padding-top: 5px; background-color: white;"></td>
                                </tr>
                                <!--Romawi 2-->
                                <tr>
                                    <td class="td_left_checklist" style="background-color: white;"></td>
                                    <td class="td_left_header_checklist" style="background-color: white; vertical-align: top;">1. Narasi Peringatan Kesehatan</td>
                                    <td></td>
                                    <?php $cmbRD1 = explode("^", $penilaianRD[0]); ?>
                                    <td style="width: 10%;background-color: white;" class="td_left">
                                        <?php echo form_dropdown('RADIO[1][]', $romawi1_2, is_array($cmbRD1) ? $cmbRD1 : '', 'class="uraianPenilaian sjenis uraianPenilaianCmb infoT penilaianRadio" part="radioRomawi1" title="CTRL + Klik Kiri untuk pilihan ganda " wajib="yes" size="5" multiple'); ?></td>
                                </tr>
                                <tr class="rowIklan">
                                    <td class="td_left_checklist" style="vertical-align: top"></td>
                                    <td class="td_left_header_checklist" style="vertical-align: top">Suara sesuai gambar 1 : Merokok sebabkan kanker mulut</td>
                                    <td></td>
                                    <td style="width: 10%;" class="td_left">
                                        <input type="checkbox" name="RADIO[2]" value="RD_GT1" class="uraianPenilaian subPenilaianRadioGT" <?php if ($penRD[1][0] != "") echo "checked"; ?> />
                                        <input type="text" class="infoT radio_romawi1aVal subPenilaianRadio subPenilaianRadioGTVal" name="RADIO[2]" style="display: none" <?php if (trim($penilaianRD[1]) != "") echo "value='" . $penilaianRD[1] . "'" ?> />
                                    </td>
                                </tr>
                                <tr class="rowIklan">
                                    <td class="td_left_checklist" style="vertical-align: top"></td>
                                    <td class="td_left_header_checklist" style="vertical-align: top">Suara sesuai gambar 2 : Merokok membunuhmu</td>
                                    <td></td>
                                    <td style="width: 10%;" class="td_left">
                                        <input type="checkbox" name="RADIO[3]" value="RD_GT2" class="uraianPenilaian subPenilaianRadioGT" <?php if ($penRD[2][0] != "") echo "checked"; ?> />
                                        <input type="text" class="infoT radio_romawi2aVal subPenilaianRadio subPenilaianRadioGTVal" name="RADIO[3]" style="display: none" <?php if (trim($penilaianRD[2]) != "") echo "value='" . $penilaianRD[2] . "'" ?> />
                                    </td>
                                </tr>
                                <tr class="rowIklan">
                                    <td class="td_left_checklist" style="vertical-align: top"></td>
                                    <td class="td_left_header_checklist" style="vertical-align: top">Suara sesuai gambar 3 : Merokok sebabkan kanker tenggorokan</td>
                                    <td></td>
                                    <td style="width: 10%;" class="td_left">
                                        <input type="checkbox" name="RADIO[4]" value="RD_GT3" class="uraianPenilaian subPenilaianRadioGT" <?php if ($penRD[3][0] != "") echo "checked"; ?> />
                                        <input type="text" class="infoT radio_romawi3aVal subPenilaianRadio subPenilaianRadioGTVal" name="RADIO[4]" style="display: none" <?php if (trim($penilaianRD[3]) != "") echo "value='" . $penilaianRD[3] . "'" ?> />
                                    </td>
                                </tr>
                                <tr class="rowIklan">
                                    <td class="td_left_checklist" style="vertical-align: top"></td>
                                    <td class="td_left_header_checklist" style="vertical-align: top">Suara sesuai gambar 4 : Merokok dekat anak bahaya bagi mereka</td>
                                    <td></td>
                                    <td style="width: 10%;" class="td_left">
                                        <input type="checkbox" name="RADIO[5]" value="RD_GT4" class="uraianPenilaian subPenilaianRadioGT" <?php if ($penRD[4][0] != "") echo "checked"; ?> />
                                        <input type="text" class="infoT radio_romawi4aVal subPenilaianRadio subPenilaianRadioGTVal" name="RADIO[5]" style="display: none" <?php if (trim($penilaianRD[4]) != "") echo "value='" . $penilaianRD[4] . "'" ?> />
                                    </td>
                                </tr>
                                <tr class="rowIklan">
                                    <td class="td_left_checklist" style="vertical-align: top"></td>
                                    <td class="td_left_header_checklist" style="vertical-align: top">Suara sesuai gambar 5 : Merokok sebabkan kanker paru-paru dan bronkitis kronis</td>
                                    <td></td>
                                    <td style="width: 10%;" class="td_left">
                                        <input type="checkbox" name="RADIO[6]" value="RD_GT5" class="uraianPenilaian subPenilaianRadioGT" <?php if ($penRD[5][0] != "") echo "checked"; ?> />
                                        <input type="text" class="infoT radio_romawi5aVal subPenilaianRadio subPenilaianRadioGTVal" name="RADIO[6]" style="display: none" <?php if (trim($penilaianRD[5]) != "") echo "value='" . $penilaianRD[5] . "'" ?> />
                                    </td>
                                </tr>
                                <tr class="rowIklan">
                                    <td class="td_left_checklist" style="vertical-align: top"></td>
                                    <td class="td_left_header_checklist" style="vertical-align: top">2. Durasi Peringatan Kesehatan : minimal 10% dari total durasi iklan</td>
                                    <td></td>
                                    <td style="width: 10%;" class="td_left">
                                        <?php echo form_dropdown('RADIO[7]', $radio_no_2, trim($penilaianRD[6]) != "" ? $penilaianRD[6] : '', 'class="uraianPenilaian sjenis infoT penilaianRadio uraianPenilaianCmb" part="radioRomawi1" id="cmbRadio" title="Durasi Peringatan Kesejatan" wajib="yes"'); ?>
                                    </td>
                                </tr>
                                <tr class="rowIklan cmbRadio" hidden>
                                    <td class="td_left_checklist" style="vertical-align: top"></td>
                                    <td class="td_left_header_checklist" style="vertical-align: top">Tuliskan durasi peringatan kesehatan</td>
                                    <td></td>
                                    <td style="width: 10%;" class="td_left">
                                        <input type="text" class="cmbRadio infoT penilaianRadio" name="RADIO[8]" value="<?php echo $penilaianRD[7]; ?>" title="Durasi Peringatan Kesehatan"/>&nbsp;&nbsp;<b>detik</b>
                                    </td>
                                </tr>
                                <tr class="rowIklan">
                                    <td class="td_left_checklist" style="vertical-align: top"></td>
                                    <td class="td_left_header_checklist" style="vertical-align: top">Evaluasi MK / TMK</td>
                                    <td></td>
                                    <td style="width: 10%;" class="td_left">
                                        <input type="text" size="25" id="radioRomawi1Eval" class="radioRomawiMkTmk" placeholder="Evaluasi MK / TMK" title="Evaluasi MK / TMK Pencantuman Peringatan Kesehatan" value="<?php
                                        if ($penilaianRD[8] == "TMK")
                                            echo "Tidak Memenuhi Ketentuan";
                                        else
                                            echo "Memenuhi Ketentuan";
                                        ?>" />
                                        <input type="hidden" id="radioRomawi1EvalVal" name="RADIO[9]" value="<?php echo $penilaianRD[8]; ?>"/>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <!--Cetak-->
                        <div class="accCntnt"  id="penilaianCetak" hidden>
                            <table class="form_tabel">
                                <tr>
                                    <td style="width: 2%;"></td>
                                    <td style="width: 50%;"></td>
                                    <td style="width: 13%;"></td>
                                    <td style="width: 35%; font-size: 14px; padding-left: 250px; padding-right: 250px; padding-bottom: 5px; padding-top: 5px;"></td>
                                </tr>
                                <tr>
                                    <td class="td_left_checklist" style="background-color: white;"></td>
                                    <td class="td_left_header_checklist" style="background-color: white;"></td>
                                    <td style="background-color: white;"></td>
                                    <td style="background-color: white;" class="td_left">
                                    </td>
                                </tr>
                                <!--Romawi 1-->
                                <tr>
                                    <td class="td_left_checklist" style="background-color: white;"></td>
                                    <td class="td_left_header_checklist" style="background-color: white;" colspan="3"><b>PENGAWASAN  PENCANTUMAN PERINGATAN KESEHATAN</b></td>
                                </tr>
                                <tr class="rowIklan">
                                    <td class="td_left_checklist" style="vertical-align: top"></td>
                                    <td class="td_left_header_checklist" style="vertical-align: top">1. Mencantumkan peringatan kesehatan berbentuk gambar dan tulisan</td>
                                    <td></td>
                                    <td style="width: 10%;" class="td_left">
                                        <input class="uraianPenilaian" param = "cetak_romawi1a" part="cetakRomawi1" type="radio" id="cetak_aromawi1A1" name="CETAK[1]" value="+_Mencantumkan peringatan kesehatan berbentuk gambar dan tulisan" <?php if ($penCT[0][0] == "+") echo "checked"; ?>>
                                        <label for="cetak_aromawi1A1" style="width: 70px; height: 10px;" title="Ya">Ya</label>
                                        <span style="margin-left: 5px;"></span>
                                        <input class="uraianPenilaian" param = "cetak_romawi1a" part="cetakRomawi1" type="radio" id="cetak_aromawi1A2" name="CETAK[1]" value="-_Mencantumkan peringatan kesehatan berbentuk gambar dan tulisan" <?php if ($penCT[0][0] == "-") echo "checked"; ?>>
                                        <label for="cetak_aromawi1A2" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak">Tidak</label>
                                        <input type="text" class="infoT penilaianCetak" name="CETAK[1]" style="display: none" value="<?php echo $penilaianCT[0]; ?>">
                                    </td>
                                </tr>
                                <tr class="cetak_romawi1a subPenilaianCetak" hidden>
                                    <td></td>
                                    <td><b>Jenis Gambar dan tulisan</b></td>
                                    <td colspan="2">&nbsp;</td>
                                </tr>
                                <tr class="cetak_romawi1a subPenilaianCetak rowIklan" hidden>
                                    <td></td>
                                    <td style="vertical-align: top">Gambar 1 : Gambar kanker mulut <br />Tulisan 1 : Merokok sebabkan kanker mulut</td>
                                    <td></td>
                                    <td class="td_left">
                                        <input type="checkbox" name="CETAK[2]" value="CT_GT1" class="uraianPenilaian subPenilaianCetakGT" <?php if ($penCT[1][0] != "") echo "checked"; ?> />
                                        <input type="text" class="infoT cetak_romawi1aVal subPenilaianCetak subPenilaianCetakGTVal" name="CETAK[2]" style="display: none" <?php if (trim($penilaianCT[1]) != "") echo "value='" . $penilaianCT[1] . "'" ?> />
                                    </td>
                                </tr>
                                <tr class="cetak_romawi1a subPenilaianCetak rowIklan" hidden>
                                    <td></td>
                                    <td> Gambar 2 : Gambar orang merokok dengan asap yang membentuk tengkorak <br />Tulisan 2 : Merokok Membunuhmu</td>
                                    <td></td>
                                    <td class="td_left">
                                        <input type="checkbox" name="CETAK[3]" value="CT_GT2" class="uraianPenilaian subPenilaianCetakGT" <?php if ($penCT[2][0] != "") echo "checked"; ?> />
                                        <input type="text" class="infoT cetak_romawi1aVal subPenilaianCetak subPenilaianCetakGTVal" name="CETAK[3]" style="display: none" <?php if (trim($penilaianCT[2]) != "") echo "value='" . $penilaianCT[2] . "'" ?> />
                                    </td>
                                </tr>
                                <tr class="cetak_romawi1a subPenilaianCetak rowIklan" hidden>
                                    <td></td>
                                    <td> Gambar 3 : Gambar kanker tenggorokan <br />Tulisan 3 : Merokok Sebabkan Kanker Tenggorokan</td>
                                    <td></td>
                                    <td class="td_left">
                                        <input type="checkbox" name="CETAK[4]" value="CT_GT3" class="uraianPenilaian subPenilaianCetakGT" <?php if ($penCT[3][0] != "") echo "checked"; ?> />
                                        <input type="text" class="infoT cetak_romawi1aVal subPenilaianCetak subPenilaianCetakGTVal" name="CETAK[4]" style="display: none" <?php if (trim($penilaianCT[3]) != "") echo "value='" . $penilaianCT[3] . "'" ?> />
                                    </td>
                                </tr><tr class="cetak_romawi1a subPenilaianCetak rowIklan" hidden>
                                    <td></td>
                                    <td>Gambar 4 : Gambar orang merokok dengan anak didekatnya <br />Tulisan 4 : Merokok Dekat Anak Berbahaya Bagi Mereka</td>
                                    <td></td>
                                    <td class="td_left">
                                        <input type="checkbox" name="CETAK[5]" value="CT_GT4" class="uraianPenilaian subPenilaianCetakGT" <?php if ($penCT[4][0] != "") echo "checked"; ?> />
                                        <input type="text" class="infoT cetak_romawi1aVal subPenilaianCetak subPenilaianCetakGTVal" name="CETAK[5]" style="display: none"  <?php if (trim($penilaianCT[4]) != "") echo "value='" . $penilaianCT[4] . "'" ?> >
                                    </td>
                                </tr>
                                <tr class="cetak_romawi1a subPenilaianCetak rowIklan" hidden>
                                    <td></td>
                                    <td>Gambar 5 : Gambar paru-paru yang menghitam karena kanker <br />Tulisan 5 : Merokok Sebabkan Kanker Paru-paru dan Bronkitis Kronis</td>
                                    <td></td>
                                    <td class="td_left">
                                        <input type="checkbox" name="CETAK[6]" value="CT_GT5" class="uraianPenilaian subPenilaianCetakGT" <?php if ($penCT[5][0] != "") echo "checked"; ?> />
                                        <input type="text" class="infoT cetak_romawi1aVal subPenilaianCetak subPenilaianCetakGTVal" name="CETAK[6]" style="display: none"  <?php if (trim($penilaianCT[5]) != "") echo "value='" . $penilaianCT[5] . "'" ?> >
                                    </td>
                                </tr>
                                <?php $cmbCtk1 = explode("^", $penilaianCT[6]); ?>
                                <tr class="rowIklan">
                                    <td class="td_left_checklist" style="vertical-align: top"></td>
                                    <td class="td_left_header_checklist" style="vertical-align: top">2. Tulisan Peringatan Kesehatan</td>
                                    <td></td>
                                    <td style="width: 10%;" class="td_left">
                                        <?php echo form_dropdown('CETAK[7][]', $romawi1_2, is_array($cmbCtk1) ? $cmbCtk1 : '', 'class="uraianPenilaian sjenis uraianPenilaianCmb infoT penilaianCetak" part="cetakRomawi1" title="CTRL + Klik Kiri untuk pilihan ganda " wajib="yes" size="5" multiple'); ?>
                                    </td>
                                </tr>
                                <tr class="rowIklan">
                                    <td class="td_left_checklist" style="vertical-align: top"></td>
                                    <td class="td_left_header_checklist" style="vertical-align: top">3. Gambar Jelas dan Mencolok sesuai dengan ketentuan</td>
                                    <td></td>
                                    <td style="width: 10%;" class="td_left">
                                        <input class="uraianPenilaian" param = "cetak_romawi1d" part="cetakRomawi1" type="radio" id="cetak_dromawi1A1" name="CETAK[8]" value="+_Gambar Jelas dan Mencolok sesuai dengan ketentuan" <?php if ($penCT[7][0] == "+") echo "checked"; ?>>
                                        <label for="cetak_dromawi1A1" style="width: 70px; height: 10px;" title="Sesuai">Sesuai</label>
                                        <span style="margin-left: 5px;"></span>
                                        <input class="uraianPenilaian" param = "cetak_romawi1d" part="cetakRomawi1" type="radio" id="cetak_dromawi1A2" name="CETAK[8]" value="-_Gambar Jelas dan Mencolok sesuai dengan ketentuan" <?php if ($penCT[7][0] == "-") echo "checked"; ?>>
                                        <label for="cetak_dromawi1A2" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak Sesuai">Tidak Sesuai</label>
                                        <input type="text" class="infoT penilaianCetak" name="CETAK[8]" style="display: none" value="<?php echo $penilaianCT[7]; ?>">
                                    </td>
                                </tr>
                                <tr class="rowIklan">
                                    <td class="td_left_checklist" style="vertical-align: top"></td>
                                    <td class="td_left_header_checklist" style="vertical-align: top">4. Luas</td>
                                    <td></td>
                                    <td style="width: 10%;" class="td_left">
                                        <?php echo form_dropdown('CETAK[9]', $romawi1_4, trim($penilaianCT[8]) != "" ? $penilaianCT[8] : '', 'class="sjenis uraianPenilaianCmb infoT penilaianCetak" part="cetakRomawi1" title="Luas" wajib="yes"'); ?>
                                    </td>
                                </tr>
                                <tr class="rowIklan">
                                    <td class="td_left_checklist" style="vertical-align: top"></td>
                                    <td class="td_left_header_checklist" style="vertical-align: top">Evaluasi MK / TMK</td>
                                    <td></td>
                                    <td style="width: 10%;" class="td_left">
                                        <input type="text" size="25" id="cetakRomawi1Eval" class="cetakRomawiMkTmk" placeholder="Evaluasi MK / TMK" title="Evaluasi MK / TMK Pencantuman Peringatan Kesehatan" value="<?php
                                        if ($penilaianCT[9] == "TMK")
                                            echo "Tidak Memenuhi Ketentuan";
                                        else
                                            echo "Memenuhi Ketentuan";
                                        ?>" />
                                        <input type="hidden" id="cetakRomawi1EvalVal" name="CETAK[10]"  value="<?php echo $penilaianCT[9]; ?>"/>
                                    </td>
                                </tr>
                                <!--Romawi 2-->
                                <tr>
                                    <td class="td_left_checklist" style="background-color: white;"></td>
                                    <td class="td_left_header_checklist" style="background-color: white;" colspan="3"><b>MATERI IKLAN  LAINNYA</b></td>
                                </tr>
                                <tr>
                                    <td class="td_left_checklist" style="background-color: white;"></td>
                                    <td class="td_left_header_checklist" style="background-color: white;"></td>
                                    <td style="background-color: white;"></td>
                                    <td style="background-color: white;" class="td_left">
                                        <input type="radio" id="r1" disabled="true">
                                        <label for="r1" style="width: 70px; height: 10px;">Sesuai</label>
                                        <span style="margin-left: 5px;"></span>
                                        <input type="radio" id="r2" disabled="true">
                                        <label for="r2" style="width: 70px; height: 10px;">Tidak Sesuai</label>
                                    </td>
                                </tr>
                                <tr class="rowIklan">
                                    <td class="td_left_checklist" style="vertical-align: top"></td>
                                    <td class="td_left_header_checklist" style="vertical-align: top">1. Penandaan 18+</td>
                                    <td></td>
                                    <td style="width: 10%;" class="td_left">
                                        <input class="uraianPenilaian" param = "cetak_romawi2a" part="cetakRomawi2" type="radio" id="cetak_aromawi2A1" name="CETAK[11]" value="+_Penandaan 18+" <?php if ($penCT[10][0] == "+") echo "checked"; ?>>
                                        <label for="cetak_aromawi2A1" style="width: 70px; height: 10px;" title="Sesuai"></label>
                                        <span style="margin-left: 5px;"></span>
                                        <input class="uraianPenilaian" param = "cetak_romawi2a" part="cetakRomawi2" type="radio" id="cetak_aromawi2A2" name="CETAK[11]" value="-_Penandaan 18+" <?php if ($penCT[10][0] == "-") echo "checked"; ?>>
                                        <label for="cetak_aromawi2A2" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak Sesuai"></label>
                                        <input type="text" class="infoT penilaianCetak" name="CETAK[11]" style="display: none" value="<?php echo $penilaianCT[10]; ?>">
                                    </td>
                                </tr>
                                <tr class="rowIklan">
                                    <td class="td_left_checklist" style="vertical-align: top"></td>
                                    <td class="td_left_header_checklist" style="vertical-align: top">2. Tidak Menggunakan Bentuk Rokok/asosiasi lainnya</td>
                                    <td></td>
                                    <td style="width: 10%;" class="td_left">
                                        <input class="uraianPenilaian" param = "cetak_romawi2a" part="cetakRomawi2" type="radio" id="cetak_bromawi2A1" name="CETAK[12]" value="+_Tidak Menggunakan Bentuk Rokok/asosiasi lainnya" <?php if ($penCT[11][0] == "+") echo "checked"; ?>>
                                        <label for="cetak_bromawi2A1" style="width: 70px; height: 10px;" title="Sesuai"></label>
                                        <span style="margin-left: 5px;"></span>
                                        <input class="uraianPenilaian" param = "cetak_romawi2a" part="cetakRomawi2" type="radio" id="cetak_bromawi2A2" name="CETAK[12]" value="-_Tidak Menggunakan Bentuk Rokok/asosiasi lainnya" <?php if ($penCT[11][0] == "-") echo "checked"; ?>>
                                        <label for="cetak_bromawi2A2" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak Sesuai"></label>
                                        <input type="text" class="infoT penilaianCetak" name="CETAK[12]" style="display: none" value="<?php echo $penilaianCT[11]; ?>">
                                    </td>
                                </tr>
                                <tr class="rowIklan">
                                    <td class="td_left_checklist" style="vertical-align: top"></td>
                                    <td class="td_left_header_checklist" style="vertical-align: top">3. Tidak Merangsang</td>
                                    <td></td>
                                    <td style="width: 10%;" class="td_left">
                                        <input class="uraianPenilaian" param = "cetak_romawi2a" part="cetakRomawi2" type="radio" id="cetak_cromawi2A1" name="CETAK[13]" value="+_Tidak Merangsang" <?php if ($penCT[12][0] == "+") echo "checked"; ?>>
                                        <label for="cetak_cromawi2A1" style="width: 70px; height: 10px;" title="Sesuai"></label>
                                        <span style="margin-left: 5px;"></span>
                                        <input class="uraianPenilaian" param = "cetak_romawi2a" part="cetakRomawi2" type="radio" id="cetak_cromawi2A2" name="CETAK[13]" value="-_Tidak Merangsang" <?php if ($penCT[12][0] == "-") echo "checked"; ?>>
                                        <label for="cetak_cromawi2A2" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak Sesuai"></label>
                                        <input type="text" class="infoT penilaianCetak" name="CETAK[13]" style="display: none" value="<?php echo $penilaianCT[12]; ?>">
                                    </td>
                                </tr>
                                <tr class="rowIklan">
                                    <td class="td_left_checklist" style="vertical-align: top"></td>
                                    <td class="td_left_header_checklist" style="vertical-align: top">4. Tidak ditujukan untuk anak, remaja, wanita hamil</td>
                                    <td></td>
                                    <td style="width: 10%;" class="td_left">
                                        <input class="uraianPenilaian" param = "cetak_romawi2a" part="cetakRomawi2" type="radio" id="cetak_dromawi2A1" name="CETAK[14]" value="+_Tidak ditujukan untuk anak, remaja, wanita hamil" <?php if ($penCT[13][0] == "+") echo "checked"; ?>>
                                        <label for="cetak_dromawi2A1" style="width: 70px; height: 10px;" title="Sesuai"></label>
                                        <span style="margin-left: 5px;"></span>
                                        <input class="uraianPenilaian" param = "cetak_romawi2a" part="cetakRomawi2" type="radio" id="cetak_dromawi2A2" name="CETAK[14]" value="-_Tidak ditujukan untuk anak, remaja, wanita hamil" <?php if ($penCT[13][0] == "-") echo "checked"; ?>>
                                        <label for="cetak_dromawi2A2" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak Sesuai"></label>
                                        <input type="text" class="infoT penilaianCetak" name="CETAK[14]" style="display: none" value="<?php echo $penilaianCT[13]; ?>">
                                    </td>
                                </tr>
                                <tr class="rowIklan">
                                    <td class="td_left_checklist" style="vertical-align: top"></td>
                                    <td class="td_left_header_checklist" style="vertical-align: top">5. Tidak bertentangan dengan norma</td>
                                    <td></td>
                                    <td style="width: 10%;" class="td_left">
                                        <input class="uraianPenilaian" param = "cetak_romawi2a" part="cetakRomawi2" type="radio" id="cetak_eromawi2A1" name="CETAK[15]" value="+_Tidak bertentangan dengan norma" <?php if ($penCT[14][0] == "+") echo "checked"; ?>>
                                        <label for="cetak_eromawi2A1" style="width: 70px; height: 10px;" title="Sesuai"></label>
                                        <span style="margin-left: 5px;"></span>
                                        <input class="uraianPenilaian" param = "cetak_romawi2a" part="cetakRomawi2" type="radio" id="cetak_eromawi2A2" name="CETAK[15]" value="-_Tidak bertentangan dengan norma" <?php if ($penCT[14][0] == "-") echo "checked"; ?>>
                                        <label for="cetak_eromawi2A2" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak Sesuai"></label>
                                        <input type="text" class="infoT penilaianCetak" name="CETAK[15]" style="display: none" value="<?php echo $penilaianCT[14]; ?>">
                                    </td>
                                </tr>
                                <tr class="rowIklan">
                                    <td class="td_left_checklist" style="vertical-align: top"></td>
                                    <td class="td_left_header_checklist" style="vertical-align: top">Evaluasi MK / TMK</td>
                                    <td></td>
                                    <td style="width: 10%;" class="td_left">
                                        <input type="text" size="25" id="cetakRomawi2Eval" class="cetakRomawiMkTmk" placeholder="Evaluasi MK / TMK" title="Evaluasi MK / TMK Pencantuman Peringatan Kesehatan" value="<?php
                                        if ($penilaianCT[15] == "TMK")
                                            echo "Tidak Memenuhi Ketentuan";
                                        else
                                            echo "Memenuhi Ketentuan";
                                        ?>" />
                                        <input type="hidden" id="cetakRomawi2EvalVal" name="CETAK[16]" value="<?php echo $penilaianCT[15]; ?>"/>
                                    </td>
                                </tr>
                                <!--Romawi 3-->
                                <tr>
                                    <td class="td_left_checklist" style="background-color: white;"></td>
                                    <td class="td_left_header_checklist" style="background-color: white;" colspan="3"><b>KETENTUAN KHUSUS DI MEDIA CETAK</b></td>
                                </tr>
                                <tr class="rowIklan">
                                    <td class="td_left_checklist" style="vertical-align: top"></td>
                                    <td class="td_left_header_checklist" style="vertical-align: top">1. Tidak di sampul depan/belakang</td>
                                    <td></td>
                                    <td style="width: 10%;" class="td_left">
                                        <input class="uraianPenilaian" param = "cetak_romawi3a" part="cetakRomawi3" type="radio" id="cetak_aromawi3A1" name="CETAK[17]" value="+_Tidak di sampul depan/belakang" <?php if ($penCT[16][0] == "+") echo "checked"; ?>>
                                        <label for="cetak_aromawi3A1" style="width: 70px; height: 10px;" title="Sesuai"></label>
                                        <span style="margin-left: 5px;"></span>
                                        <input class="uraianPenilaian" param = "cetak_romawi3a" part="cetakRomawi3" type="radio" id="cetak_aromawi3A2" name="CETAK[17]" value="-_Tidak di sampul depan/belakang" <?php if ($penCT[16][0] == "-") echo "checked"; ?>>
                                        <label for="cetak_aromawi3A2" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak Sesuai"></label>
                                        <input type="text" class="infoT penilaianCetak" name="CETAK[17]" style="display: none" value="<?php echo $penilaianCT[16]; ?>">
                                    </td>
                                </tr>
                                <tr class="rowIklan">
                                    <td class="td_left_checklist" style="vertical-align: top"></td>
                                    <td class="td_left_header_checklist" style="vertical-align: top">2. Tidak diletakkan dekat dengan iiklan makanan dan minuman</td>
                                    <td></td>
                                    <td style="width: 10%;" class="td_left">
                                        <input class="uraianPenilaian" param = "cetak_romawi3a" part="cetakRomawi3" type="radio" id="cetak_bromawi3A1" name="CETAK[18]" value="+_Tidak diletakkan dekat dengan iiklan makanan dan minuman" <?php if ($penCT[17][0] == "+") echo "checked"; ?>>
                                        <label for="cetak_bromawi3A1" style="width: 70px; height: 10px;" title="Sesuai"></label>
                                        <span style="margin-left: 5px;"></span>
                                        <input class="uraianPenilaian" param = "cetak_romawi3a" part="cetakRomawi3" type="radio" id="cetak_bromawi3A2" name="CETAK[18]" value="-_Tidak diletakkan dekat dengan iiklan makanan dan minuman" <?php if ($penCT[17][0] == "-") echo "checked"; ?>>
                                        <label for="cetak_bromawi3A2" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak Sesuai"></label>
                                        <input type="text" class="infoT penilaianCetak" name="CETAK[18]" style="display: none" value="<?php echo $penilaianCT[17]; ?>">
                                    </td>
                                </tr>
                                <tr class="rowIklan">
                                    <td class="td_left_checklist" style="vertical-align: top"></td>
                                    <td class="td_left_header_checklist" style="vertical-align: top">3. Luas kolom iklan tidak memenuhi seluruh isi halaman</td>
                                    <td></td>
                                    <td style="width: 10%;" class="td_left">
                                        <input class="uraianPenilaian" param = "cetak_romawi3a" part="cetakRomawi3" type="radio" id="cetak_cromawi3A1" name="CETAK[19]" value="+_Luas kolom iklan tidak memenuhi seluruh isi halaman" <?php if ($penCT[18][0] == "+") echo "checked"; ?>>
                                        <label for="cetak_cromawi3A1" style="width: 70px; height: 10px;" title="Sesuai"></label>
                                        <span style="margin-left: 5px;"></span>
                                        <input class="uraianPenilaian" param = "cetak_romawi3a" part="cetakRomawi3" type="radio" id="cetak_cromawi3A2" name="CETAK[19]" value="-_Luas kolom iklan tidak memenuhi seluruh isi halaman" <?php if ($penCT[18][0] == "-") echo "checked"; ?>>
                                        <label for="cetak_cromawi3A2" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak Sesuai"></label>
                                        <input type="text" class="infoT penilaianCetak" name="CETAK[19]" style="display: none" value="<?php echo $penilaianCT[18]; ?>">
                                    </td>
                                </tr>
                                <tr class="rowIklan">
                                    <td class="td_left_checklist" style="vertical-align: top"></td>
                                    <td class="td_left_header_checklist" style="vertical-align: top">4. Iklan tidak dimuat di media cetak untuk anak, remaja dan perempuan</td>
                                    <td></td>
                                    <td style="width: 10%;" class="td_left">
                                        <input class="uraianPenilaian" param = "cetak_romawi3a" part="cetakRomawi3" type="radio" id="cetak_dromawi3A1" name="CETAK[20]" value="+_Iklan tidak dimuat di media cetak untuk anak, remaja dan perempuan" <?php if ($penCT[19][0] == "+") echo "checked"; ?>>
                                        <label for="cetak_dromawi3A1" style="width: 70px; height: 10px;" title="Sesuai"></label>
                                        <span style="margin-left: 5px;"></span>
                                        <input class="uraianPenilaian" param = "cetak_romawi3a" part="cetakRomawi3" type="radio" id="cetak_dromawi3A2" name="CETAK[20]" value="-_Iklan tidak dimuat di media cetak untuk anak, remaja dan perempuan" <?php if ($penCT[19][0] == "-") echo "checked"; ?>>
                                        <label for="cetak_dromawi3A2" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak Sesuai"></label>
                                        <input type="text" class="infoT penilaianCetak" name="CETAK[20]" style="display: none" value="<?php echo $penilaianCT[19]; ?>">
                                    </td>
                                </tr>
                                <tr class="rowIklan">
                                    <td class="td_left_checklist" style="vertical-align: top"></td>
                                    <td class="td_left_header_checklist" style="vertical-align: top">Evaluasi MK / TMK</td>
                                    <td></td>
                                    <td style="width: 10%;" class="td_left">
                                        <input type="text" size="25" id="cetakRomawi3Eval" class="cetakRomawiMkTmk" placeholder="Evaluasi MK / TMK" title="Evaluasi MK / TMK Pencantuman Peringatan Kesehatan" value="<?php
                                        if ($penilaianCT[20] == "TMK")
                                            echo "Tidak Memenuhi Ketentuan";
                                        else
                                            echo "Memenuhi Ketentuan"
                                            ?>"/>
                                        <input type="hidden" id="cetakRomawi3EvalVal" name="CETAK[21]" value="<?php echo $penilaianCT[20]; ?>"/>
                                    </td>
                                </tr>
                                <tr class="rowIklan">
                                    <td class="td_left_checklist" style="vertical-align: top"></td>
                                    <td class="td_left_header_checklist" style="vertical-align: top">Kesimpulan MK / TMK</td>
                                    <td></td>
                                    <td style="width: 10%;" class="td_left">
                                        <input type="text" size="25" id="cetakRomawiEvalFinal" placeholder="Evaluasi MK / TMK" title="Evaluasi MK / TMK Pencantuman Peringatan Kesehatan" value="<?php
                                        if ($penilaianCT[21] == "TMK")
                                            echo "Tidak Memenuhi Ketentuan";
                                        else
                                            echo "Memenuhi Ketentuan";
                                        ?>" />
                                        <input type="hidden" id="cetakRomawiEvalValFinal" name="CETAK[22]" value="<?php echo $penilaianCT[21]; ?>" />
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <!--Luar ruang-->
                        <div class="accCntnt"  id="penilaianLuarRuang" hidden>
                            <table class="form_tabel">
                                <tr>
                                    <td style="width: 2%;"></td>
                                    <td style="width: 50%;"></td>
                                    <td style="width: 13%;"></td>
                                    <td style="width: 35%; font-size: 14px; padding-left: 250px; padding-right: 250px; padding-bottom: 5px; padding-top: 5px;"></td>
                                </tr>
                                <tr>
                                    <td class="td_left_checklist" style="background-color: white;"></td>
                                    <td class="td_left_header_checklist" style="background-color: white;"></td>
                                    <td style="background-color: white;"></td>
                                    <td style="background-color: white;" class="td_left">
                                    </td>
                                </tr>
                                <!--Romawi 1-->
                                <tr>
                                    <td class="td_left_checklist" style="background-color: white;"></td>
                                    <td class="td_left_header_checklist" style="background-color: white;" colspan="3"><b>PENCANTUMAN PERINGATAN KESEHATAN</b></td>
                                </tr>
                                <tr class="rowIklan">
                                    <td class="td_left_checklist" style="vertical-align: top"></td>
                                    <td class="td_left_header_checklist" style="vertical-align: top">1. Mencantumkan peringatan kesehatan berbentuk gambar dan tulisan</td>
                                    <td></td>
                                    <td style="width: 10%;" class="td_left">
                                        <input class="uraianPenilaian" param = "luarRuang_romawi1a" part="luarRuangRomawi1" type="radio" id="luarRuang_aromawi1A1" name="LUARRUANG[1]" value="+_Mencantumkan peringatan kesehatan berbentuk gambar dan tulisan" <?php if ($penLR[0][0] == "+") echo "checked"; ?>>
                                        <label for="luarRuang_aromawi1A1" style="width: 70px; height: 10px;" title="Ya">Ya</label>
                                        <span style="margin-left: 5px;"></span>
                                        <input class="uraianPenilaian" param = "luarRuang_romawi1a" part="luarRuangRomawi1" type="radio" id="luarRuang_aromawi1A2" name="LUARRUANG[1]" value="-_Mencantumkan peringatan kesehatan berbentuk gambar dan tulisan" <?php if ($penLR[0][0] == "-") echo "checked"; ?>>
                                        <label for="luarRuang_aromawi1A2" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak">Tidak</label>
                                        <input type="text" class="infoT penilaianLuarRuang" name="LUARRUANG[1]" style="display: none" value="<?php echo $penilaianLR[0]; ?>">
                                    </td>
                                </tr>
                                <tr class="luarRuang_romawi1a subPenilaianLuarRuang" hidden>
                                    <td></td>
                                    <td><b>Jenis Gambar dan tulisan</b></td>
                                    <td colspan="2">&nbsp;</td>
                                </tr>
                                <tr class="luarRuang_romawi1a subPenilaianLuarRuang rowIklan" hidden>
                                    <td></td>
                                    <td style="vertical-align: top">Gambar 1 : Gambar kanker mulut <br />Tulisan 1 : Merokok sebabkan kanker mulut</td>
                                    <td></td>
                                    <td class="td_left">
                                        <input type="checkbox" name="LUARRUANG[2]" value="LR_GT1" class="uraianPenilaian subPenilaianLuarRuangGT" <?php if ($penLR[1][0] != "") echo "checked"; ?> />
                                        <input type="text" class="infoT luarRuang_romawi1aVal subPenilaianLuarRuang subPenilaianLuarRuangGTVal" name="LUARRUANG[2]" style="display: none" <?php if (trim($penilaianLR[1]) != "") echo "value='" . $penilaianLR[1] . "'" ?> />
                                    </td>
                                </tr><tr class="luarRuang_romawi1a subPenilaianLuarRuang rowIklan" hidden>
                                    <td></td>
                                    <td> Gambar 2 : Gambar orang merokok dengan asap yang membentuk tengkorak <br />Tulisan 2 : Merokok Membunuhmu</td>
                                    <td></td>
                                    <td class="td_left">
                                        <input type="checkbox" name="LUARRUANG[3]" value="LR_GT2" class="uraianPenilaian subPenilaianLuarRuangGT" <?php if ($penLR[2][0] != "") echo "checked"; ?> />
                                        <input type="text" class="infoT luarRuang_romawi1aVal subPenilaianLuarRuang subPenilaianLuarRuangGTVal" name="LUARRUANG[3]" style="display: none" <?php if (trim($penilaianLR[2]) != "") echo "value='" . $penilaianLR[2] . "'" ?> />
                                    </td>
                                </tr>
                                <tr class="luarRuang_romawi1a subPenilaianLuarRuang rowIklan" hidden>
                                    <td></td>
                                    <td> Gambar 3 : Gambar kanker tenggorokan <br />Tulisan 3 : Merokok Sebabkan Kanker Tenggorokan</td>
                                    <td></td>
                                    <td class="td_left">
                                        <input type="checkbox" name="LUARRUANG[4]" value="LR_GT3" class="uraianPenilaian subPenilaianLuarRuangGT" <?php if ($penLR[3][0] != "") echo "checked"; ?> />
                                        <input type="text" class="infoT luarRuang_romawi1aVal subPenilaianLuarRuang subPenilaianLuarRuangGTVal" name="LUARRUANG[4]" style="display: none" <?php if (trim($penilaianLR[3]) != "") echo "value='" . $penilaianLR[3] . "'" ?> />
                                    </td>
                                </tr><tr class="luarRuang_romawi1a subPenilaianLuarRuang rowIklan" hidden>
                                    <td></td>
                                    <td>Gambar 4 : Gambar orang merokok dengan anak didekatnya <br />Tulisan 4 : Merokok Dekat Anak Berbahaya Bagi Mereka</td>
                                    <td></td>
                                    <td class="td_left">
                                        <input type="checkbox" name="LUARRUANG[5]" value="LR_GT4" class="uraianPenilaian subPenilaianLuarRuangGT" <?php if ($penLR[4][0] != "") echo "checked"; ?> />
                                        <input type="text" class="infoT luarRuang_romawi1aVal subPenilaianLuarRuang subPenilaianLuarRuangGTVal" name="LUARRUANG[5]" style="display: none"  <?php if (trim($penilaianLR[4]) != "") echo "value='" . $penilaianLR[4] . "'" ?> >
                                    </td>
                                </tr>
                                <tr class="luarRuang_romawi1a subPenilaianLuarRuang rowIklan" hidden>
                                    <td></td>
                                    <td>Gambar 5 : Gambar paru-paru yang menghitam karena kanker <br />Tulisan 5 : Merokok Sebabkan Kanker Paru-paru dan Bronkitis Kronis</td>
                                    <td></td>
                                    <td class="td_left">
                                        <input type="checkbox" name="LUARRUANG[6]" value="LR_GT5" class="uraianPenilaian subPenilaianLuarRuangGT" <?php if ($penLR[5][0] != "") echo "checked"; ?> />
                                        <input type="text" class="infoT luarRuang_romawi1aVal subPenilaianLuarRuang subPenilaianLuarRuangGTVal" name="LUARRUANG[6]" style="display: none"  <?php if (trim($penilaianLR[5]) != "") echo "value='" . $penilaianLR[5] . "'" ?> >
                                    </td>
                                </tr>
                                <?php $cmbLR1 = explode("^", $penilaianLR[6]); ?>
                                <tr class="rowIklan">
                                    <td class="td_left_checklist" style="vertical-align: top"></td>
                                    <td class="td_left_header_checklist" style="vertical-align: top">2. Tulisan Peringatan Kesehatan</td>
                                    <td></td>
                                    <td style="width: 10%;" class="td_left">
                                        <?php echo form_dropdown('LUARRUANG[7][]', $romawi1_2, is_array($cmbLR1) ? $cmbLR1 : '', 'class="uraianPenilaian sjenis uraianPenilaianCmb infoT penilaianLuarRuang" part="luarRuangRomawi1" title="CTRL + Klik Kiri untuk pilihan ganda " wajib="yes" size="5" multiple'); ?>
                                    </td>
                                </tr>
                                <tr class="rowIklan">
                                    <td class="td_left_checklist" style="vertical-align: top"></td>
                                    <td class="td_left_header_checklist" style="vertical-align: top">3. Gambar Jelas dan Mencolok sesuai dengan ketentuan</td>
                                    <td></td>
                                    <td style="width: 10%;" class="td_left">
                                        <input class="uraianPenilaian" param = "luarRuang_romawi1d" part="luarRuangRomawi1" type="radio" id="luarRuang_dromawi1A1" name="LUARRUANG[8]" value="+_Gambar Jelas dan Mencolok sesuai dengan ketentuan" <?php if ($penLR[7][0] == "+") echo "checked"; ?>>
                                        <label for="luarRuang_dromawi1A1" style="width: 70px; height: 10px;" title="Sesuai">Sesuai</label>
                                        <span style="margin-left: 5px;"></span>
                                        <input class="uraianPenilaian" param = "luarRuang_romawi1d" part="luarRuangRomawi1" type="radio" id="luarRuang_dromawi1A2" name="LUARRUANG[8]" value="-_Gambar Jelas dan Mencolok sesuai dengan ketentuan" <?php if ($penLR[7][0] == "-") echo "checked"; ?>>
                                        <label for="luarRuang_dromawi1A2" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak Sesuai">Tidak Sesuai</label>
                                        <input type="text" class="infoT penilaianLuarRuang" name="LUARRUANG[8]" style="display: none" value="<?php echo $penilaianLR[7]; ?>">
                                    </td>
                                </tr>
                                <tr class="rowIklan">
                                    <td class="td_left_checklist" style="vertical-align: top"></td>
                                    <td class="td_left_header_checklist" style="vertical-align: top">4. Luas</td>
                                    <td></td>
                                    <td style="width: 10%;" class="td_left">
                                        <?php echo form_dropdown('LUARRUANG[9]', $romawi1_4, trim($penilaianLR[8]) != "" ? $penilaianLR[8] : '', 'class="uraianPenilaian sjenis uraianPenilaianCmb infoT penilaianLuarRuang" part="luarRuangRomawi1" title="Luas" wajib="yes"'); ?>
                                    </td>
                                </tr>
                                <tr class="rowIklan">
                                    <td class="td_left_checklist" style="vertical-align: top"></td>
                                    <td class="td_left_header_checklist" style="vertical-align: top">Evaluasi MK / TMK</td>
                                    <td></td>
                                    <td style="width: 10%;" class="td_left">
                                        <input type="text" size="25" id="luarRuangRomawi1Eval" class="luarRuangRomawiMkTmk" placeholder="Evaluasi MK / TMK" title="Evaluasi MK / TMK Pencantuman Peringatan Kesehatan" value="<?php
                                        if ($penilaianLR[9] == "TMK")
                                            echo "Tidak Memenuhi Ketentuan";
                                        else
                                            echo "Memenuhi Ketentuan";
                                        ?>"  />
                                        <input type="hidden" id="luarRuangRomawi1EvalVal" name="LUARRUANG[10]" value="<?php echo $penilaianLR[9]; ?>" />
                                    </td>
                                </tr>
                                <!--Romawi 2-->
                                <tr>
                                    <td class="td_left_checklist" style="background-color: white;"></td>
                                    <td class="td_left_header_checklist" style="background-color: white;"></td>
                                    <td style="background-color: white;"></td>
                                    <td style="background-color: white;" class="td_left">
                                        <input type="radio" id="r1" disabled="true">
                                        <label for="r1" style="width: 70px; height: 10px;">Sesuai</label>
                                        <span style="margin-left: 5px;"></span>
                                        <input type="radio" id="r2" disabled="true">
                                        <label for="r2" style="width: 70px; height: 10px;">Tidak Sesuai</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="td_left_checklist" style="background-color: white;"></td>
                                    <td class="td_left_header_checklist" style="background-color: white;" colspan="3"><b>MATERI IKLAN  LAINNYA</b></td>
                                </tr>
                                <tr class="rowIklan">
                                    <td class="td_left_checklist" style="vertical-align: top"></td>
                                    <td class="td_left_header_checklist" style="vertical-align: top">1. Penandaan 18+</td>
                                    <td></td>
                                    <td style="width: 10%;" class="td_left">
                                        <input class="uraianPenilaian" param = "luarRuang_romawi2a" part="luarRuangRomawi2" type="radio" id="luarRuang_aromawi2A1" name="LUARRUANG[11]" value="+_Penandaan 18+" <?php if ($penLR[10][0] == "+") echo "checked"; ?>>
                                        <label for="luarRuang_aromawi2A1" style="width: 70px; height: 10px;" title="Sesuai"></label>
                                        <span style="margin-left: 5px;"></span>
                                        <input class="uraianPenilaian" param = "luarRuang_romawi2a" part="luarRuangRomawi2" type="radio" id="luarRuang_aromawi2A2" name="LUARRUANG[11]" value="-_Penandaan 18+" <?php if ($penLR[10][0] == "-") echo "checked"; ?>>
                                        <label for="luarRuang_aromawi2A2" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak Sesuai"></label>
                                        <input type="text" class="infoT penilaianLuarRuang" name="LUARRUANG[11]" style="display: none" value="<?php echo $penilaianLR[10]; ?>">
                                    </td>
                                </tr>
                                <tr class="rowIklan">
                                    <td class="td_left_checklist" style="vertical-align: top"></td>
                                    <td class="td_left_header_checklist" style="vertical-align: top">2. Tidak Menggunakan Bentuk Rokok/asosiasi lainnya</td>
                                    <td></td>
                                    <td style="width: 10%;" class="td_left">
                                        <input class="uraianPenilaian" param = "luarRuang_romawi2a" part="luarRuangRomawi2" type="radio" id="luarRuang_bromawi2A1" name="LUARRUANG[12]" value="+_Tidak Menggunakan Bentuk Rokok/asosiasi lainnya" <?php if ($penLR[11][0] == "+") echo "checked"; ?>>
                                        <label for="luarRuang_bromawi2A1" style="width: 70px; height: 10px;" title="Sesuai"></label>
                                        <span style="margin-left: 5px;"></span>
                                        <input class="uraianPenilaian" param = "luarRuang_romawi2a" part="luarRuangRomawi2" type="radio" id="luarRuang_bromawi2A2" name="LUARRUANG[12]" value="-_Tidak Menggunakan Bentuk Rokok/asosiasi lainnya" <?php if ($penLR[11][0] == "-") echo "checked"; ?>>
                                        <label for="luarRuang_bromawi2A2" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak Sesuai"></label>
                                        <input type="text" class="infoT penilaianLuarRuang" name="LUARRUANG[12]" style="display: none" value="<?php echo $penilaianLR[11]; ?>">
                                    </td>
                                </tr>
                                <tr class="rowIklan">
                                    <td class="td_left_checklist" style="vertical-align: top"></td>
                                    <td class="td_left_header_checklist" style="vertical-align: top">3. Tidak Merangsang</td>
                                    <td></td>
                                    <td style="width: 10%;" class="td_left">
                                        <input class="uraianPenilaian" param = "luarRuang_romawi2a" part="luarRuangRomawi2" type="radio" id="luarRuang_cromawi2A1" name="LUARRUANG[13]" value="+_Tidak Merangsang" <?php if ($penLR[12][0] == "+") echo "checked"; ?>>
                                        <label for="luarRuang_cromawi2A1" style="width: 70px; height: 10px;" title="Sesuai"></label>
                                        <span style="margin-left: 5px;"></span>
                                        <input class="uraianPenilaian" param = "luarRuang_romawi2a" part="luarRuangRomawi2" type="radio" id="luarRuang_cromawi2A2" name="LUARRUANG[13]" value="-_Tidak Merangsang" <?php if ($penLR[12][0] == "-") echo "checked"; ?>>
                                        <label for="luarRuang_cromawi2A2" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak Sesuai"></label>
                                        <input type="text" class="infoT penilaianLuarRuang" name="LUARRUANG[13]" style="display: none" value="<?php echo $penilaianLR[12]; ?>">
                                    </td>
                                </tr>
                                <tr class="rowIklan">
                                    <td class="td_left_checklist" style="vertical-align: top"></td>
                                    <td class="td_left_header_checklist" style="vertical-align: top">4. Tidak ditujukan untuk anak, remaja, wanita hamil</td>
                                    <td></td>
                                    <td style="width: 10%;" class="td_left">
                                        <input class="uraianPenilaian" param = "luarRuang_romawi2a" part="luarRuangRomawi2" type="radio" id="luarRuang_dromawi2A1" name="LUARRUANG[14]" value="+_Tidak ditujukan untuk anak, remaja, wanita hamil" <?php if ($penLR[13][0] == "+") echo "checked"; ?>>
                                        <label for="luarRuang_dromawi2A1" style="width: 70px; height: 10px;" title="Sesuai"></label>
                                        <span style="margin-left: 5px;"></span>
                                        <input class="uraianPenilaian" param = "luarRuang_romawi2a" part="luarRuangRomawi2" type="radio" id="luarRuang_dromawi2A2" name="LUARRUANG[14]" value="-_Tidak ditujukan untuk anak, remaja, wanita hamil" <?php if ($penLR[13][0] == "-") echo "checked"; ?>>
                                        <label for="luarRuang_dromawi2A2" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak Sesuai"></label>
                                        <input type="text" class="infoT penilaianLuarRuang" name="LUARRUANG[14]" style="display: none" value="<?php echo $penilaianLR[13]; ?>">
                                    </td>
                                </tr>
                                <tr class="rowIklan">
                                    <td class="td_left_checklist" style="vertical-align: top"></td>
                                    <td class="td_left_header_checklist" style="vertical-align: top">5. Tidak bertentangan dengan norma</td>
                                    <td></td>
                                    <td style="width: 10%;" class="td_left">
                                        <input class="uraianPenilaian" param = "luarRuang_romawi2a" part="luarRuangRomawi2" type="radio" id="luarRuang_eromawi2A1" name="LUARRUANG[15]" value="+_Tidak bertentangan dengan norma" <?php if ($penLR[14][0] == "+") echo "checked"; ?>>
                                        <label for="luarRuang_eromawi2A1" style="width: 70px; height: 10px;" title="Sesuai"></label>
                                        <span style="margin-left: 5px;"></span>
                                        <input class="uraianPenilaian" param = "luarRuang_romawi2a" part="luarRuangRomawi2" type="radio" id="luarRuang_eromawi2A2" name="LUARRUANG[15]" value="-_Tidak bertentangan dengan norma" <?php if ($penLR[14][0] == "-") echo "checked"; ?>>
                                        <label for="luarRuang_eromawi2A2" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak Sesuai"></label>
                                        <input type="text" class="infoT penilaianLuarRuang" name="LUARRUANG[15]" style="display: none" value="<?php echo $penilaianLR[14]; ?>">
                                    </td>
                                </tr>
                                <tr class="rowIklan">
                                    <td class="td_left_checklist" style="vertical-align: top"></td>
                                    <td class="td_left_header_checklist" style="vertical-align: top">Evaluasi MK / TMK</td>
                                    <td></td>
                                    <td style="width: 10%;" class="td_left">
                                        <input type="text" size="25" id="luarRuangRomawi2Eval" class="luarRuangRomawiMkTmk" placeholder="Evaluasi MK / TMK" title="Evaluasi MK / TMK Pencantuman Peringatan Kesehatan" value="<?php
                                        if ($penilaianLR[15] == "TMK")
                                            echo "Tidak Memenuhi Ketentuan";
                                        else
                                            echo "Memenuhi Ketentuan";
                                        ?>" />
                                        <input type="hidden" id="luarRuangRomawi2EvalVal" name="LUARRUANG[16]" value="<?php echo $penilaianLR[15]; ?>" />
                                    </td>
                                </tr>
                                <!--Romawi 3-->
                                <tr>
                                    <td class="td_left_checklist" style="background-color: white;"></td>
                                    <td class="td_left_header_checklist" style="background-color: white;" colspan="3"><b>KETENTUAN KHUSUS DI MEDIA LUAR RUANG</b></td>
                                </tr>
                                <tr class="rowIklan">
                                    <td class="td_left_checklist" style="vertical-align: top"></td>
                                    <td class="td_left_header_checklist" style="vertical-align: top">1. Tidak diletakkan di kawasan tanpa rokok</td>
                                    <td></td>
                                    <td style="width: 10%;" class="td_left">
                                        <input class="uraianPenilaian" param = "luarRuang_romawi3a" part="luarRuangRomawi3" type="radio" id="luarRuang_aromawi3A1" name="LUARRUANG[17]" value="+_Tidak diletakkan di kawasan tanpa rokok" <?php if ($penLR[16][0] == "+") echo "checked"; ?>>
                                        <label for="luarRuang_aromawi3A1" style="width: 70px; height: 10px;" title="Sesuai"></label>
                                        <span style="margin-left: 5px;"></span>
                                        <input class="uraianPenilaian" param = "luarRuang_romawi3a" part="luarRuangRomawi3" type="radio" id="luarRuang_aromawi3A2" name="LUARRUANG[17]" value="-_Tidak diletakkan di kawasan tanpa rokok" <?php if ($penLR[16][0] == "-") echo "checked"; ?>>
                                        <label for="luarRuang_aromawi3A2" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak Sesuai"></label>
                                        <input type="text" class="infoT penilaianLuarRuang" name="LUARRUANG[17]" style="display: none" value="<?php echo $penilaianLR[16]; ?>">
                                    </td>
                                </tr>
                                <tr class="rowIklan">
                                    <td class="td_left_checklist" style="vertical-align: top"></td>
                                    <td class="td_left_header_checklist" style="vertical-align: top">2. Tidak diletakkan di jalan utama atau protokol</td>
                                    <td></td>
                                    <td style="width: 10%;" class="td_left">
                                        <input class="uraianPenilaian" param = "luarRuang_romawi3a" part="luarRuangRomawi3" type="radio" id="luarRuang_bromawi3A1" name="LUARRUANG[18]" value="+_Tidak diletakkan di jalan utama atau protokol" <?php if ($penLR[17][0] == "+") echo "checked"; ?>>
                                        <label for="luarRuang_bromawi3A1" style="width: 70px; height: 10px;" title="Sesuai"></label>
                                        <span style="margin-left: 5px;"></span>
                                        <input class="uraianPenilaian" param = "luarRuang_romawi3a" part="luarRuangRomawi3" type="radio" id="luarRuang_bromawi3A2" name="LUARRUANG[18]" value="-_Tidak diletakkan di jalan utama atau protokol" <?php if ($penLR[17][0] == "-") echo "checked"; ?>>
                                        <label for="luarRuang_bromawi3A2" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak Sesuai"></label>
                                        <input type="text" class="infoT penilaianLuarRuang" name="LUARRUANG[18]" style="display: none" value="<?php echo $penilaianLR[17]; ?>">
                                    </td>
                                </tr>
                                <tr class="rowIklan">
                                    <td class="td_left_checklist" style="vertical-align: top"></td>
                                    <td class="td_left_header_checklist" style="vertical-align: top">3. Harus diletakkan sejajar dengan bahu jalan dan tidak memotong jalan</td>
                                    <td></td>
                                    <td style="width: 10%;" class="td_left">
                                        <input class="uraianPenilaian" param = "luarRuang_romawi3a" part="luarRuangRomawi3" type="radio" id="luarRuang_cromawi3A1" name="LUARRUANG[19]" value="+_Harus diletakkan sejajar dengan bahu jalan dan tidak memotong jalan" <?php if ($penLR[18][0] == "+") echo "checked"; ?>>
                                        <label for="luarRuang_cromawi3A1" style="width: 70px; height: 10px;" title="Sesuai"></label>
                                        <span style="margin-left: 5px;"></span>
                                        <input class="uraianPenilaian" param = "luarRuang_romawi3a" part="luarRuangRomawi3" type="radio" id="luarRuang_cromawi3A2" name="LUARRUANG[19]" value="-_Harus diletakkan sejajar dengan bahu jalan dan tidak memotong jalan" <?php if ($penLR[18][0] == "-") echo "checked"; ?>>
                                        <label for="luarRuang_cromawi3A2" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak Sesuai"></label>
                                        <input type="text" class="infoT penilaianLuarRuang" name="LUARRUANG[19]" style="display: none" value="<?php echo $penilaianLR[18]; ?>">
                                    </td>
                                </tr>
                                <tr class="rowIklan">
                                    <td class="td_left_checklist" style="vertical-align: top"></td>
                                    <td class="td_left_header_checklist" style="vertical-align: top">4. Tidak melebihi ukuran 72m2</td>
                                    <td></td>
                                    <td style="width: 10%;" class="td_left">
                                        <input class="uraianPenilaian" param = "luarRuang_romawi3a" part="luarRuangRomawi3" type="radio" id="luarRuang_dromawi3A1" name="LUARRUANG[20]" value="+_Tidak melebihi ukuran 72m2" <?php if ($penLR[19][0] == "+") echo "checked"; ?>>
                                        <label for="luarRuang_dromawi3A1" style="width: 70px; height: 10px;" title="Sesuai"></label>
                                        <span style="margin-left: 5px;"></span>
                                        <input class="uraianPenilaian" param = "luarRuang_romawi3a" part="luarRuangRomawi3" type="radio" id="luarRuang_dromawi3A2" name="LUARRUANG[20]" value="-_Tidak melebihi ukuran 72m2" <?php if ($penLR[19][0] == "-") echo "checked"; ?>>
                                        <label for="luarRuang_dromawi3A2" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak Sesuai"></label>
                                        <input type="text" class="infoT penilaianLuarRuang" name="LUARRUANG[20]" style="display: none" value="<?php echo $penilaianLR[19]; ?>">
                                    </td>
                                </tr>
                                <tr class="rowIklan">
                                    <td class="td_left_checklist" style="vertical-align: top"></td>
                                    <td class="td_left_header_checklist" style="vertical-align: top">Evaluasi MK / TMK</td>
                                    <td></td>
                                    <td style="width: 10%;" class="td_left">
                                        <input type="text" size="25" id="luarRuangRomawi3Eval" class="luarRuangRomawiMkTmk" placeholder="Evaluasi MK / TMK" title="Evaluasi MK / TMK Pencantuman Peringatan Kesehatan" value="<?php
                                        if ($penilaianLR[20] == "TMK")
                                            echo "Tidak Memenuhi Ketentuan";
                                        else
                                            echo "Memenuhi Ketentuan";
                                        ?>" />
                                        <input type="hidden" id="luarRuangRomawi3EvalVal" name="LUARRUANG[21]" value="<?php echo $penilaianLR[20]; ?>" />
                                    </td>
                                </tr>
                                <tr class="rowIklan">
                                    <td class="td_left_checklist" style="vertical-align: top"></td>
                                    <td class="td_left_header_checklist" style="vertical-align: top">Kesimpulan MK / TMK</td>
                                    <td></td>
                                    <td style="width: 10%;" class="td_left">
                                        <input type="text" size="25" id="luarRuangRomawiEvalFinal" placeholder="Evaluasi MK / TMK" title="Evaluasi MK / TMK Pencantuman Peringatan Kesehatan" value="<?php
                                        if ($penilaianLR[21] == "TMK")
                                            echo "Tidak Memenuhi Ketentuan";
                                        else
                                            echo "Memenuhi Ketentuan";
                                        ?>" />
                                        <input type="hidden" id="luarRuangRomawiEvalValFinal" name="LUARRUANG[22]" value="<?php echo $penilaianLR[21]; ?>" />
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <!--Televisi-->
                        <div class="accCntnt"  id="penilaianTV" hidden>
                            <table class="form_tabel">
                                <tr>
                                    <td style="width: 2%;"></td>
                                    <td style="width: 50%;"></td>
                                    <td style="width: 13%;"></td>
                                    <td style="width: 35%; font-size: 14px; padding-left: 250px; padding-right: 250px; padding-bottom: 5px; padding-top: 5px;"></td>
                                </tr>
                                <tr>
                                    <td class="td_left_checklist" style="background-color: white;"></td>
                                    <td class="td_left_header_checklist" style="background-color: white;"></td>
                                    <td style="background-color: white;"></td>
                                    <td style="background-color: white;" class="td_left">
                                    </td>
                                </tr>
                                <!--Romawi 1-->
                                <tr>
                                    <td class="td_left_checklist" style="background-color: white;"></td>
                                    <td class="td_left_header_checklist" style="background-color: white;" colspan="3"><b>PENGAWASAN  PENCANTUMAN PERINGATAN KESEHATAN</b></td>
                                </tr>
                                <tr class="rowIklan">
                                    <td class="td_left_checklist" style="vertical-align: top"></td>
                                    <td class="td_left_header_checklist" style="vertical-align: top">1. Mencantumkan peringatan kesehatan berbentuk gambar dan tulisan</td>
                                    <td></td>
                                    <td style="width: 10%;" class="td_left">
                                        <input class="uraianPenilaian" param = "tv_romawi1a" part="tvRomawi1" type="radio" id="tv_aromawi1A1" name="TV[1]" value="+_Mencantumkan peringatan kesehatan berbentuk gambar dan tulisan" <?php if ($penTV[0][0] == "+") echo "checked"; ?>>
                                        <label for="tv_aromawi1A1" style="width: 70px; height: 10px;" title="Ya">Ya</label>
                                        <span style="margin-left: 5px;"></span>
                                        <input class="uraianPenilaian" param = "tv_romawi1a" part="tvRomawi1" type="radio" id="tv_aromawi1A2" name="TV[1]" value="-_Mencantumkan peringatan kesehatan berbentuk gambar dan tulisan" <?php if ($penTV[0][0] == "-") echo "checked"; ?>>
                                        <label for="tv_aromawi1A2" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak">Tidak</label>
                                        <input type="text" class="infoT penilaianTV" name="TV[1]" style="display: none" value="<?php echo $penilaianTV[0]; ?>">
                                    </td>
                                </tr>
                                <tr class="tv_romawi1a subPenilaianTV" hidden>
                                    <td></td>
                                    <td><b>Jenis Gambar dan tulisan</b></td>
                                    <td colspan="2">&nbsp;</td>
                                </tr>
                                <tr class="tv_romawi1a subPenilaianTV rowIklan" hidden>
                                    <td></td>
                                    <td style="vertical-align: top">Gambar 1 : Gambar kanker mulut <br />Tulisan 1 : Merokok sebabkan kanker mulut</td>
                                    <td></td>
                                    <td class="td_left">
                                        <input type="checkbox" name="TV[2]" value="TV_GT1" class="uraianPenilaian subPenilaianTVGT" <?php if ($penTV[1][0] != "") echo "checked"; ?> />
                                        <input type="text" class="infoT tv_romawi1aVal subPenilaianTV subPenilaianTVGTVal" name="TV[2]" style="display: none" <?php if (trim($penilaianTV[1]) != "") echo "value='" . $penilaianTV[1] . "'" ?> />
                                    </td>
                                </tr><tr class="tv_romawi1a subPenilaianTV rowIklan" hidden>
                                    <td></td>
                                    <td> Gambar 2 : Gambar orang merokok dengan asap yang membentuk tengkorak <br />Tulisan 2 : Merokok Membunuhmu</td>
                                    <td></td>
                                    <td class="td_left">
                                        <input type="checkbox" name="TV[3]" value="TV_GT2" class="uraianPenilaian subPenilaianTVGT" <?php if ($penTV[2][0] != "") echo "checked"; ?> />
                                        <input type="text" class="infoT tv_romawi1aVal subPenilaianTV subPenilaianTVGTVal" name="TV[3]" style="display: none" <?php if (trim($penilaianTV[2]) != "") echo "value='" . $penilaianTV[2] . "'" ?> />
                                    </td>
                                </tr>
                                <tr class="tv_romawi1a subPenilaianTV rowIklan" hidden>
                                    <td></td>
                                    <td> Gambar 3 : Gambar kanker tenggorokan <br />Tulisan 3 : Merokok Sebabkan Kanker Tenggorokan</td>
                                    <td></td>
                                    <td class="td_left">
                                        <input type="checkbox" name="TV[4]" value="TV_GT3" class="uraianPenilaian subPenilaianTVGT" <?php if ($penTV[3][0] != "") echo "checked"; ?> />
                                        <input type="text" class="infoT tv_romawi1aVal subPenilaianTV subPenilaianTVGTVal" name="TV[4]" style="display: none" <?php if (trim($penilaianTV[3]) != "") echo "value='" . $penilaianTV[3] . "'" ?> />
                                    </td>
                                </tr>
                                <tr class="tv_romawi1a subPenilaianTV rowIklan" hidden>
                                    <td></td>
                                    <td>Gambar 4 : Gambar orang merokok dengan anak didekatnya <br />Tulisan 4 : Merokok Dekat Anak Berbahaya Bagi Mereka</td>
                                    <td></td>
                                    <td class="td_left">
                                        <input type="checkbox" name="TV[5]" value="TV_GT4" class="uraianPenilaian subPenilaianTVGT" <?php if ($penTV[4][0] != "") echo "checked"; ?> />
                                        <input type="text" class="infoT tv_romawi1aVal subPenilaianTV subPenilaianTVGTVal" name="TV[5]" style="display: none"  <?php if (trim($penilaianTV[4]) != "") echo "value='" . $penilaianTV[4] . "'" ?> >
                                    </td>
                                </tr>
                                <tr class="tv_romawi1a subPenilaianTV rowIklan" hidden>
                                    <td></td>
                                    <td>Gambar 5 : Gambar paru-paru yang menghitam karena kanker <br />Tulisan 5 : Merokok Sebabkan Kanker Paru-paru dan Bronkitis Kronis</td>
                                    <td></td>
                                    <td class="td_left">
                                        <input type="checkbox" name="TV[6]" value="TV_GT5" class="uraianPenilaian subPenilaianTVGT" <?php if ($penTV[5][0] != "") echo "checked"; ?> />
                                        <input type="text" class="infoT tv_romawi1aVal subPenilaianTV subPenilaianTVGTVal" name="TV[6]" style="display: none"  <?php if (trim($penilaianTV[5]) != "") echo "value='" . $penilaianTV[5] . "'" ?> >
                                    </td>
                                </tr>
                                <?php
                                $cmbTV1 = explode("^", $penilaianTV[6]);
                                $cmbTV2 = explode("^", $penilaianTV[9]);
                                ?>
                                <tr class="rowIklan">
                                    <td class="td_left_checklist" style="vertical-align: top"></td>
                                    <td class="td_left_header_checklist" style="vertical-align: top">2. Tulisan Peringatan Kesehatan</td>
                                    <td></td>
                                    <td style="width: 10%;" class="td_left">
                                        <?php echo form_dropdown('TV[7][]', $romawi1_2, is_array($cmbTV1) ? $cmbTV1 : '', 'class="uraianPenilaian sjenis uraianPenilaianCmb infoT penilaianTV" part="tvRomawi1" title="CTRL + Klik Kiri untuk pilihan ganda " wajib="yes" size="5" multiple'); ?>
                                    </td>
                                </tr>
                                <tr class="rowIklan">
                                    <td class="td_left_checklist" style="vertical-align: top"></td>
                                    <td class="td_left_header_checklist" style="vertical-align: top">3. Gambar Jelas dan Mencolok sesuai dengan ketentuan</td>
                                    <td></td>
                                    <td style="width: 10%;" class="td_left">
                                        <input class="uraianPenilaian" param = "tv_romawi1d" part="tvRomawi1" type="radio" id="tv_dromawi1A1" name="TV[8]" value="+_Gambar Jelas dan Mencolok sesuai dengan ketentuan" <?php if ($penTV[7][0] == "+") echo "checked"; ?>>
                                        <label for="tv_dromawi1A1" style="width: 70px; height: 10px;" title="Sesuai">Sesuai</label>
                                        <span style="margin-left: 5px;"></span>
                                        <input class="uraianPenilaian" param = "tv_romawi1d" part="tvRomawi1" type="radio" id="tv_dromawi1A2" name="TV[8]" value="-_Gambar Jelas dan Mencolok sesuai dengan ketentuan" <?php if ($penTV[7][0] == "-") echo "checked"; ?>>
                                        <label for="tv_dromawi1A2" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak Sesuai">Tidak Sesuai</label>
                                        <input type="text" class="infoT penilaianTV" name="TV[8]" style="display: none" value="<?php echo $penilaianTV[7]; ?>">
                                    </td>
                                </tr>
                                <tr class="rowIklan">
                                    <td class="td_left_checklist" style="vertical-align: top"></td>
                                    <td class="td_left_header_checklist" style="vertical-align: top">4. Durasi Iklan 10% dari total durasi</td>
                                    <td></td>
                                    <td style="width: 10%;" class="td_left">
                                        <?php echo form_dropdown('TV[9]', $romawi1_4, trim($penilaianTV[8]) != "" ? $penilaianTV[8] : '', 'class="uraianPenilaian sjenis uraianPenilaianCmb infoT penilaianTV" part="tvRomawi1" title="Luas Iklan atau Durasi Iklan" wajib="yes"'); ?>
                                    </td>
                                </tr>
                                <tr class="rowIklan">
                                    <td class="td_left_checklist" style="vertical-align: top"></td>
                                    <td class="td_left_header_checklist" style="vertical-align: top">5. Fullscreen</td>
                                    <td></td>
                                    <td style="width: 10%;" class="td_left">
                                        <?php echo form_dropdown('TV[10][]', $romawi1_2, trim($cmbTV2) != "" ? $cmbTV2 : '', 'class="uraianPenilaian sjenis uraianPenilaianCmb infoT penilaianTV" part="tvRomawi1" title="CTRL + Klik Kiri untuk pilihan ganda " wajib="yes" size="5" multiple'); ?>
                                    </td>
                                </tr>
                                <tr class="rowIklan">
                                    <td class="td_left_checklist" style="vertical-align: top"></td>
                                    <td class="td_left_header_checklist" style="vertical-align: top">Evaluasi MK / TMK</td>
                                    <td></td>
                                    <td style="width: 10%;" class="td_left">
                                        <input type="text" size="25" id="tvRomawi1Eval" class="tvRomawiMkTmk" placeholder="Evaluasi MK / TMK" title="Evaluasi MK / TMK Pencantuman Peringatan Kesehatan" value="<?php
                                        if ($penilaianTV[10] == "TMK")
                                            echo "Tidak Memenuhi Ketentuan";
                                        else
                                            echo "Memenuhi Ketentuan";
                                        ?>"/>
                                        <input type="hidden" id="tvRomawi1EvalVal" name="TV[11]" value="<?php echo $penilaianTV[10]; ?>" />
                                    </td>
                                </tr>
                                <!--Romawi 2-->
                                <tr>
                                    <td class="td_left_checklist" style="background-color: white;"></td>
                                    <td class="td_left_header_checklist" style="background-color: white;"></td>
                                    <td style="background-color: white;"></td>
                                    <td style="background-color: white;" class="td_left">
                                        <input type="radio" id="r1" disabled="true">
                                        <label for="r1" style="width: 70px; height: 10px;">Sesuai</label>
                                        <span style="margin-left: 5px;"></span>
                                        <input type="radio" id="r2" disabled="true">
                                        <label for="r2" style="width: 70px; height: 10px;">Tidak Sesuai</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="td_left_checklist" style="background-color: white;"></td>
                                    <td class="td_left_header_checklist" style="background-color: white;" colspan="3"><b>MATERI IKLAN  LAINNYA</b></td>
                                </tr>
                                <tr class="rowIklan">
                                    <td class="td_left_checklist" style="vertical-align: top"></td>
                                    <td class="td_left_header_checklist" style="vertical-align: top">1. Penandaan 18+</td>
                                    <td></td>
                                    <td style="width: 10%;" class="td_left">
                                        <input class="uraianPenilaian" param = "tv_romawi2a" part="tvRomawi2" type="radio" id="tv_aromawi2A1" name="TV[12]" value="+_Penandaan 18+" <?php if ($penTV[11][0] == "+") echo "checked"; ?>>
                                        <label for="tv_aromawi2A1" style="width: 70px; height: 10px;" title="Sesuai"></label>
                                        <span style="margin-left: 5px;"></span>
                                        <input class="uraianPenilaian" param = "tv_romawi2a" part="tvRomawi2" type="radio" id="tv_aromawi2A2" name="TV[12]" value="-_Penandaan 18+" <?php if ($penTV[11][0] == "-") echo "checked"; ?>>
                                        <label for="tv_aromawi2A2" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak Sesuai"></label>
                                        <input type="text" class="infoT penilaianTV" name="TV[12]" style="display: none" value="<?php echo $penilaianTV[11]; ?>">
                                    </td>
                                </tr>
                                <tr class="rowIklan">
                                    <td class="td_left_checklist" style="vertical-align: top"></td>
                                    <td class="td_left_header_checklist" style="vertical-align: top">2. Tidak Menggunakan Bentuk Rokok/asosiasi lainnya</td>
                                    <td></td>
                                    <td style="width: 10%;" class="td_left">
                                        <input class="uraianPenilaian" param = "tv_romawi2a" part="tvRomawi2" type="radio" id="tv_bromawi2A1" name="TV[13]" value="+_Tidak Menggunakan Bentuk Rokok/asosiasi lainnya" <?php if ($penTV[12][0] == "+") echo "checked"; ?>>
                                        <label for="tv_bromawi2A1" style="width: 70px; height: 10px;" title="Sesuai"></label>
                                        <span style="margin-left: 5px;"></span>
                                        <input class="uraianPenilaian" param = "tv_romawi2a" part="tvRomawi2" type="radio" id="tv_bromawi2A2" name="TV[13]" value="-_Tidak Menggunakan Bentuk Rokok/asosiasi lainnya" <?php if ($penTV[12][0] == "-") echo "checked"; ?>>
                                        <label for="tv_bromawi2A2" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak Sesuai"></label>
                                        <input type="text" class="infoT penilaianTV" name="TV[13]" style="display: none" value="<?php echo $penilaianTV[12]; ?>">
                                    </td>
                                </tr>
                                <tr class="rowIklan">
                                    <td class="td_left_checklist" style="vertical-align: top"></td>
                                    <td class="td_left_header_checklist" style="vertical-align: top">3. Tidak Merangsang</td>
                                    <td></td>
                                    <td style="width: 10%;" class="td_left">
                                        <input class="uraianPenilaian" param = "tv_romawi2a" part="tvRomawi2" type="radio" id="tv_cromawi2A1" name="TV[14]" value="+_Tidak Merangsang" <?php if ($penTV[13][0] == "+") echo "checked"; ?>>
                                        <label for="tv_cromawi2A1" style="width: 70px; height: 10px;" title="Sesuai"></label>
                                        <span style="margin-left: 5px;"></span>
                                        <input class="uraianPenilaian" param = "tv_romawi2a" part="tvRomawi2" type="radio" id="tv_cromawi2A2" name="TV[14]" value="-_Tidak Merangsang" <?php if ($penTV[13][0] == "-") echo "checked"; ?>>
                                        <label for="tv_cromawi2A2" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak Sesuai"></label>
                                        <input type="text" class="infoT penilaianTV" name="TV[14]" style="display: none" value="<?php echo $penilaianTV[13]; ?>">
                                    </td>
                                </tr>
                                <tr class="rowIklan">
                                    <td class="td_left_checklist" style="vertical-align: top"></td>
                                    <td class="td_left_header_checklist" style="vertical-align: top">4. Tidak ditujukan untuk anak, remaja, wanita hamil</td>
                                    <td></td>
                                    <td style="width: 10%;" class="td_left">
                                        <input class="uraianPenilaian" param = "tv_romawi2a" part="tvRomawi2" type="radio" id="tv_dromawi2A1" name="TV[15]" value="+_Tidak ditujukan untuk anak, remaja, wanita hamil" <?php if ($penTV[14][0] == "+") echo "checked"; ?>>
                                        <label for="tv_dromawi2A1" style="width: 70px; height: 10px;" title="Sesuai"></label>
                                        <span style="margin-left: 5px;"></span>
                                        <input class="uraianPenilaian" param = "tv_romawi2a" part="tvRomawi2" type="radio" id="tv_dromawi2A2" name="TV[15]" value="-_Tidak ditujukan untuk anak, remaja, wanita hamil" <?php if ($penTV[14][0] == "-") echo "checked"; ?>>
                                        <label for="tv_dromawi2A2" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak Sesuai"></label>
                                        <input type="text" class="infoT penilaianTV" name="TV[15]" style="display: none" value="<?php echo $penilaianTV[14]; ?>">
                                    </td>
                                </tr>
                                <tr class="rowIklan">
                                    <td class="td_left_checklist" style="vertical-align: top"></td>
                                    <td class="td_left_header_checklist" style="vertical-align: top">5. Tidak bertentangan dengan norma</td>
                                    <td></td>
                                    <td style="width: 10%;" class="td_left">
                                        <input class="uraianPenilaian" param = "tv_romawi2a" part="tvRomawi2" type="radio" id="tv_eromawi2A1" name="TV[16]" value="+_Tidak bertentangan dengan norma" <?php if ($penTV[15][0] == "+") echo "checked"; ?>>
                                        <label for="tv_eromawi2A1" style="width: 70px; height: 10px;" title="Sesuai"></label>
                                        <span style="margin-left: 5px;"></span>
                                        <input class="uraianPenilaian" param = "tv_romawi2a" part="tvRomawi2" type="radio" id="tv_eromawi2A2" name="TV[16]" value="-_Tidak bertentangan dengan norma" <?php if ($penTV[15][0] == "-") echo "checked"; ?>>
                                        <label for="tv_eromawi2A2" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak Sesuai"></label>
                                        <input type="text" class="infoT penilaianTV" name="TV[16]" style="display: none" value="<?php echo $penilaianTV[15]; ?>">
                                    </td>
                                </tr>
                                <tr class="rowIklan">
                                    <td class="td_left_checklist" style="vertical-align: top"></td>
                                    <td class="td_left_header_checklist" style="vertical-align: top">Evaluasi MK / TMK</td>
                                    <td></td>
                                    <td style="width: 10%;" class="td_left">
                                        <input type="text" size="25" id="tvRomawi2Eval" class="tvRomawiMkTmk" placeholder="Evaluasi MK / TMK" title="Evaluasi MK / TMK Pencantuman Peringatan Kesehatan" value="<?php
                                        if ($penilaianTV[16] == "TMK")
                                            echo "Tidak Memenuhi Ketentuan";
                                        else
                                            echo "Memenuhi Ketentuan";
                                        ?>"/>
                                        <input type="hidden" id="tvRomawi2EvalVal" name="TV[17]" value="<?php echo $penilaianTV[16]; ?>"/>
                                    </td>
                                </tr>
                                <tr class="rowIklan">
                                    <td class="td_left_checklist" style="vertical-align: top"></td>
                                    <td class="td_left_header_checklist" style="vertical-align: top">Kesimpulan MK / TMK</td>
                                    <td></td>
                                    <td style="width: 10%;" class="td_left">
                                        <input type="text" size="25" id="tvRomawiEvalFinal" placeholder="Evaluasi MK / TMK" title="Evaluasi MK / TMK Pencantuman Peringatan Kesehatan" value="<?php
                                        if ($penilaianTV[17] == "TMK")
                                            echo "Tidak Memenuhi Ketentuan";
                                        else
                                            echo "Memenuhi Ketentuan";
                                        ?>"/>
                                        <input type="hidden" id="tvRomawiEvalValFinal" name="TV[18]" value="<?php echo $penilaianTV[17]; ?>" />
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <!--TI-->
                        <div class="accCntnt"  id="penilaianTI" hidden>
                            <table class="form_tabel">
                                <tr>
                                    <td style="width: 2%;"></td>
                                    <td style="width: 50%;"></td>
                                    <td style="width: 13%;"></td>
                                    <td style="width: 35%; font-size: 14px; padding-left: 250px; padding-right: 250px; padding-bottom: 5px; padding-top: 5px;"></td>
                                </tr>
                                <tr>
                                    <td class="td_left_checklist" style="background-color: white;"></td>
                                    <td class="td_left_header_checklist" style="background-color: white;"></td>
                                    <td style="background-color: white;"></td>
                                    <td style="background-color: white;" class="td_left">
                                    </td>
                                </tr>
                                <!--Romawi 1-->
                                <tr>
                                    <td class="td_left_checklist" style="background-color: white;"></td>
                                    <td class="td_left_header_checklist" style="background-color: white;" colspan="3"><b>PENGAWASAN  PENCANTUMAN PERINGATAN KESEHATAN</b></td>
                                </tr>
                                <tr class="rowIklan">
                                    <td class="td_left_checklist" style="vertical-align: top"></td>
                                    <td class="td_left_header_checklist" style="vertical-align: top">1. Mencantumkan peringatan kesehatan berbentuk gambar dan tulisan</td>
                                    <td></td>
                                    <td style="width: 10%;" class="td_left">
                                        <input class="uraianPenilaian" param = "ti_romawi1a" part="tiRomawi1" type="radio" id="ti_aromawi1A1" name="TI[1]" value="+_Mencantumkan peringatan kesehatan berbentuk gambar dan tulisan" <?php if ($penTI[0][0] == "+") echo "checked"; ?>>
                                        <label for="ti_aromawi1A1" style="width: 70px; height: 10px;" title="Ya">Ya</label>
                                        <span style="margin-left: 5px;"></span>
                                        <input class="uraianPenilaian" param = "ti_romawi1a" part="tiRomawi1" type="radio" id="ti_aromawi1A2" name="TI[1]" value="-_Mencantumkan peringatan kesehatan berbentuk gambar dan tulisan" <?php if ($penTI[0][0] == "-") echo "checked"; ?>>
                                        <label for="ti_aromawi1A2" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak">Tidak</label>
                                        <input type="text" class="infoT penilaianTI" name="TI[1]" style="display: none" value="<?php echo $penilaianTI[0]; ?>">
                                    </td>
                                </tr>
                                <tr class="ti_romawi1a subPenilaianTI" hidden>
                                    <td></td>
                                    <td><b>Jenis Gambar dan tulisan</b></td>
                                    <td colspan="2">&nbsp;</td>
                                </tr>
                                <tr class="ti_romawi1a subPenilaianTI rowIklan" hidden>
                                    <td></td>
                                    <td style="vertical-align: top">Gambar 1 : Gambar kanker mulut <br />Tulisan 1 : Merokok sebabkan kanker mulut</td>
                                    <td></td>
                                    <td class="td_left">
                                        <input type="checkbox" name="TI[2]" value="TI_GT1" class="uraianPenilaian subPenilaianTIGT" <?php if ($penTI[1][0] != "") echo "checked"; ?> />
                                        <input type="text" class="infoT ti_romawi1aVal subPenilaianTI subPenilaianTIGTVal" name="TI[2]" style="display: none" <?php if (trim($penilaianTI[1]) != "") echo "value='" . $penilaianTI[1] . "'" ?> />
                                    </td>
                                </tr>
                                <tr class="ti_romawi1a subPenilaianTI rowIklan" hidden>
                                    <td></td>
                                    <td> Gambar 2 : Gambar orang merokok dengan asap yang membentuk tengkorak <br />Tulisan 2 : Merokok Membunuhmu</td>
                                    <td></td>
                                    <td class="td_left">
                                        <input type="checkbox" name="TI[3]" value="TI_GT2" class="uraianPenilaian subPenilaianTIGT" <?php if ($penTI[2][0] != "") echo "checked"; ?> />
                                        <input type="text" class="infoT ti_romawi1aVal subPenilaianTI subPenilaianTIGTVal" name="TI[3]" style="display: none" <?php if (trim($penilaianTI[2]) != "") echo "value='" . $penilaianTI[2] . "'" ?> />
                                    </td>
                                </tr>
                                <tr class="ti_romawi1a subPenilaianTI rowIklan" hidden>
                                    <td></td>
                                    <td> Gambar 3 : Gambar kanker tenggorokan <br />Tulisan 3 : Merokok Sebabkan Kanker Tenggorokan</td>
                                    <td></td>
                                    <td class="td_left">
                                        <input type="checkbox" name="TI[4]" value="TI_GT3" class="uraianPenilaian subPenilaianTIGT" <?php if ($penTI[3][0] != "") echo "checked"; ?> />
                                        <input type="text" class="infoT ti_romawi1aVal subPenilaianTI subPenilaianTIGTVal" name="TI[4]" style="display: none" <?php if (trim($penilaianTI[3]) != "") echo "value='" . $penilaianTI[3] . "'" ?> />
                                    </td>
                                </tr><tr class="ti_romawi1a subPenilaianTI rowIklan" hidden>
                                    <td></td>
                                    <td>Gambar 4 : Gambar orang merokok dengan anak didekatnya <br />Tulisan 4 : Merokok Dekat Anak Berbahaya Bagi Mereka</td>
                                    <td></td>
                                    <td class="td_left">
                                        <input type="checkbox" name="TI[5]" value="TI_GT4" class="uraianPenilaian subPenilaianTIGT" <?php if ($penTI[4][0] != "") echo "checked"; ?> />
                                        <input type="text" class="infoT ti_romawi1aVal subPenilaianTI subPenilaianTIGTVal" name="TI[5]" style="display: none"  <?php if (trim($penilaianTI[4]) != "") echo "value='" . $penilaianTI[4] . "'" ?> >
                                    </td>
                                </tr>
                                <tr class="ti_romawi1a subPenilaianTI rowIklan" hidden>
                                    <td></td>
                                    <td>Gambar 5 : Gambar paru-paru yang menghitam karena kanker <br />Tulisan 5 : Merokok Sebabkan Kanker Paru-paru dan Bronkitis Kronis</td>
                                    <td></td>
                                    <td class="td_left">
                                        <input type="checkbox" name="TI[6]" value="TI_GT5" class="uraianPenilaian subPenilaianTIGT" <?php if ($penTI[5][0] != "") echo "checked"; ?> />
                                        <input type="text" class="infoT ti_romawi1aVal subPenilaianTI subPenilaianTIGTVal" name="TI[6]" style="display: none"  <?php if (trim($penilaianTI[5]) != "") echo "value='" . $penilaianTI[5] . "'" ?> >
                                    </td>
                                </tr>
                                <?php $cmbTI1 = explode("^", $penilaianTI[6]); ?>
                                <tr class="rowIklan">
                                    <td class="td_left_checklist" style="vertical-align: top"></td>
                                    <td class="td_left_header_checklist" style="vertical-align: top">2. Tulisan Peringatan Kesehatan</td>
                                    <td></td>
                                    <td style="width: 10%;" class="td_left">
                                        <?php echo form_dropdown('TI[7][]', $romawi1_2, is_array($cmbTI1) ? $cmbTI1 : '', 'class="uraianPenilaian sjenis uraianPenilaianCmb infoT penilaianTI" part="tiRomawi1" title="CTRL + Klik Kiri untuk pilihan ganda " wajib="yes" size="5" multiple'); ?>
                                    </td>
                                </tr>
                                <tr class="rowIklan">
                                    <td class="td_left_checklist" style="vertical-align: top"></td>
                                    <td class="td_left_header_checklist" style="vertical-align: top">3. Gambar Jelas dan Mencolok sesuai dengan ketentuan</td>
                                    <td></td>
                                    <td style="width: 10%;" class="td_left">
                                        <input class="uraianPenilaian" param = "ti_romawi1d" part="tiRomawi1" type="radio" id="ti_dromawi1A1" name="TI[8]" value="+_Gambar Jelas dan Mencolok sesuai dengan ketentuan" <?php if ($penTI[7][0] == "+") echo "checked"; ?>>
                                        <label for="ti_dromawi1A1" style="width: 70px; height: 10px;" title="Sesuai">Sesuai</label>
                                        <span style="margin-left: 5px;"></span>
                                        <input class="uraianPenilaian" param = "ti_romawi1d" part="tiRomawi1" type="radio" id="ti_dromawi1A2" name="TI[8]" value="-_Gambar Jelas dan Mencolok sesuai dengan ketentuan" <?php if ($penTI[7][0] == "-") echo "checked"; ?>>
                                        <label for="ti_dromawi1A2" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak Sesuai">Tidak Sesuai</label>
                                        <input type="text" class="infoT penilaianTI" name="TI[8]" style="display: none" value="<?php echo $penilaianTI[7]; ?>">
                                    </td>
                                </tr>
                                <tr class="rowIklan">
                                    <td class="td_left_checklist" style="vertical-align: top"></td>
                                    <td class="td_left_header_checklist" style="vertical-align: top">4. Luas Iklan atau Durasi Iklan</td>
                                    <td></td>
                                    <td style="width: 10%;" class="td_left">
                                        <?php echo form_dropdown('TI[9]', $romawi1_4, trim($penilaianTI[8]) != "" ? $penilaianTI[8] : '', 'class="uraianPenilaian sjenis uraianPenilaianCmb infoT penilaianTI" part="tiRomawi1" title="Durasi Iklan" wajib="yes"'); ?>
                                    </td>
                                </tr>
                                <tr class="rowIklan">
                                    <td class="td_left_checklist" style="vertical-align: top"></td>
                                    <td class="td_left_header_checklist" style="vertical-align: top">Evaluasi MK / TMK</td>
                                    <td></td>
                                    <td style="width: 10%;" class="td_left">
                                        <input type="text" size="25" id="tiRomawi1Eval" class="tiRomawiMkTmk" placeholder="Evaluasi MK / TMK" title="Evaluasi MK / TMK Pencantuman Peringatan Kesehatan" value="<?php
                                        if ($penilaianTI[9] == "TMK")
                                            echo "Tidak Memenuhi Ketentuan";
                                        else
                                            echo "Memenuhi Ketentuan";
                                        ?>"/>
                                        <input type="hidden" id="tiRomawi1EvalVal" name="TI[10]" value="<?php echo $penilaianTI[9]; ?>"/>
                                    </td>
                                </tr>
                                <!--Romawi 2-->
                                <tr>
                                    <td class="td_left_checklist" style="background-color: white;"></td>
                                    <td class="td_left_header_checklist" style="background-color: white;"></td>
                                    <td style="background-color: white;"></td>
                                    <td style="background-color: white;" class="td_left">
                                        <input type="radio" id="r1" disabled="true">
                                        <label for="r1" style="width: 70px; height: 10px;">Sesuai</label>
                                        <span style="margin-left: 5px;"></span>
                                        <input type="radio" id="r2" disabled="true">
                                        <label for="r2" style="width: 70px; height: 10px;">Tidak Sesuai</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="td_left_checklist" style="background-color: white;"></td>
                                    <td class="td_left_header_checklist" style="background-color: white;" colspan="3"><b>MATERI IKLAN  LAINNYA</b></td>
                                </tr>
                                <tr class="rowIklan">
                                    <td class="td_left_checklist" style="vertical-align: top"></td>
                                    <td class="td_left_header_checklist" style="vertical-align: top">1. Penandaan 18+</td>
                                    <td></td>
                                    <td style="width: 10%;" class="td_left">
                                        <input class="uraianPenilaian" param = "ti_romawi2a" part="tiRomawi2" type="radio" id="ti_aromawi2A1" name="TI[11]" value="+_Penandaan 18+" <?php if ($penTI[10][0] == "+") echo "checked"; ?>>
                                        <label for="ti_aromawi2A1" style="width: 70px; height: 10px;" title="Sesuai"></label>
                                        <span style="margin-left: 5px;"></span>
                                        <input class="uraianPenilaian" param = "ti_romawi2a" part="tiRomawi2" type="radio" id="ti_aromawi2A2" name="TI[11]" value="-_Penandaan 18+" <?php if ($penTI[10][0] == "-") echo "checked"; ?>>
                                        <label for="ti_aromawi2A2" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak Sesuai"></label>
                                        <input type="text" class="infoT penilaianTI" name="TI[11]" style="display: none" value="<?php echo $penilaianTI[10]; ?>">
                                    </td>
                                </tr>
                                <tr class="rowIklan">
                                    <td class="td_left_checklist" style="vertical-align: top"></td>
                                    <td class="td_left_header_checklist" style="vertical-align: top">2. Tidak Menggunakan Bentuk Rokok/asosiasi lainnya</td>
                                    <td></td>
                                    <td style="width: 10%;" class="td_left">
                                        <input class="uraianPenilaian" param = "ti_romawi2a" part="tiRomawi2" type="radio" id="ti_bromawi2A1" name="TI[12]" value="+_Tidak Menggunakan Bentuk Rokok/asosiasi lainnya" <?php if ($penTI[13][0] == "+") echo "checked"; ?>>
                                        <label for="ti_bromawi2A1" style="width: 70px; height: 10px;" title="Sesuai"></label>
                                        <span style="margin-left: 5px;"></span>
                                        <input class="uraianPenilaian" param = "ti_romawi2a" part="tiRomawi2" type="radio" id="ti_bromawi2A2" name="TI[12]" value="-_Tidak Menggunakan Bentuk Rokok/asosiasi lainnya" <?php if ($penTI[13][0] == "-") echo "checked"; ?>>
                                        <label for="ti_bromawi2A2" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak Sesuai"></label>
                                        <input type="text" class="infoT penilaianTI" name="TI[12]" style="display: none" value="<?php echo $penilaianTI[13]; ?>">
                                    </td>
                                </tr>
                                <tr class="rowIklan">
                                    <td class="td_left_checklist" style="vertical-align: top"></td>
                                    <td class="td_left_header_checklist" style="vertical-align: top">3. Tidak Merangsang</td>
                                    <td></td>
                                    <td style="width: 10%;" class="td_left">
                                        <input class="uraianPenilaian" param = "ti_romawi2a" part="tiRomawi2" type="radio" id="ti_cromawi2A1" name="TI[13]" value="+_Tidak Merangsang" <?php if ($penTI[12][0] == "+") echo "checked"; ?>>
                                        <label for="ti_cromawi2A1" style="width: 70px; height: 10px;" title="Sesuai"></label>
                                        <span style="margin-left: 5px;"></span>
                                        <input class="uraianPenilaian" param = "ti_romawi2a" part="tiRomawi2" type="radio" id="ti_cromawi2A2" name="TI[13]" value="-_Tidak Merangsang" <?php if ($penTI[12][0] == "-") echo "checked"; ?>>
                                        <label for="ti_cromawi2A2" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak Sesuai"></label>
                                        <input type="text" class="infoT penilaianTI" name="TI[13]" style="display: none" value="<?php echo $penilaianTI[12]; ?>">
                                    </td>
                                </tr>
                                <tr class="rowIklan">
                                    <td class="td_left_checklist" style="vertical-align: top"></td>
                                    <td class="td_left_header_checklist" style="vertical-align: top">4. Tidak ditujukan untuk anak, remaja, wanita hamil</td>
                                    <td></td>
                                    <td style="width: 10%;" class="td_left">
                                        <input class="uraianPenilaian" param = "ti_romawi2a" part="tiRomawi2" type="radio" id="ti_dromawi2A1" name="TI[14]" value="+_Tidak ditujukan untuk anak, remaja, wanita hamil" <?php if ($penTI[13][0] == "+") echo "checked"; ?>>
                                        <label for="ti_dromawi2A1" style="width: 70px; height: 10px;" title="Sesuai"></label>
                                        <span style="margin-left: 5px;"></span>
                                        <input class="uraianPenilaian" param = "ti_romawi2a" part="tiRomawi2" type="radio" id="ti_dromawi2A2" name="TI[14]" value="-_Tidak ditujukan untuk anak, remaja, wanita hamil" <?php if ($penTI[13][0] == "-") echo "checked"; ?>>
                                        <label for="ti_dromawi2A2" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak Sesuai"></label>
                                        <input type="text" class="infoT penilaianTI" name="TI[14]" style="display: none" value="<?php echo $penilaianTI[13]; ?>">
                                    </td>
                                </tr>
                                <tr class="rowIklan">
                                    <td class="td_left_checklist" style="vertical-align: top"></td>
                                    <td class="td_left_header_checklist" style="vertical-align: top">5. Tidak bertentangan dengan norma</td>
                                    <td></td>
                                    <td style="width: 10%;" class="td_left">
                                        <input class="uraianPenilaian" param = "ti_romawi2a" part="tiRomawi2" type="radio" id="ti_eromawi2A1" name="TI[15]" value="+_Tidak bertentangan dengan norma" <?php if ($penTI[14][0] == "+") echo "checked"; ?>>
                                        <label for="ti_eromawi2A1" style="width: 70px; height: 10px;" title="Sesuai"></label>
                                        <span style="margin-left: 5px;"></span>
                                        <input class="uraianPenilaian" param = "ti_romawi2a" part="tiRomawi2" type="radio" id="ti_eromawi2A2" name="TI[15]" value="-_Tidak bertentangan dengan norma" <?php if ($penTI[14][0] == "-") echo "checked"; ?>>
                                        <label for="ti_eromawi2A2" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak Sesuai"></label>
                                        <input type="text" class="infoT penilaianTI" name="TI[15]" style="display: none" value="<?php echo $penilaianTI[14]; ?>">
                                    </td>
                                </tr>
                                <tr class="rowIklan">
                                    <td class="td_left_checklist" style="vertical-align: top"></td>
                                    <td class="td_left_header_checklist" style="vertical-align: top">Evaluasi MK / TMK</td>
                                    <td></td>
                                    <td style="width: 10%;" class="td_left">
                                        <input type="text" size="25" id="tiRomawi2Eval" class="tiRomawiMkTmk" placeholder="Evaluasi MK / TMK" title="Evaluasi MK / TMK Pencantuman Peringatan Kesehatan" value="<?php
                                        if ($penilaianTI[15] == "TMK")
                                            echo "Tidak Memenuhi Ketentuan";
                                        else
                                            echo "Memenuhi Ketentuan";
                                        ?>"/>
                                        <input type="hidden" id="tiRomawi2EvalVal" name="TI[16]" value="<?php echo $penilaianTI[15]; ?>"/>
                                    </td>
                                </tr>
                                <tr class="rowIklan">
                                    <td class="td_left_checklist" style="vertical-align: top"></td>
                                    <td class="td_left_header_checklist" style="vertical-align: top">Kesimpulan MK / TMK</td>
                                    <td></td>
                                    <td style="width: 10%;" class="td_left">
                                        <input type="text" size="25" id="tiRomawiEvalFinal" placeholder="Evaluasi MK / TMK" title="Evaluasi MK / TMK Pencantuman Peringatan Kesehatan" value="<?php
                                        if ($penilaianTI[16] == "TMK")
                                            echo "Tidak Memenuhi Ketentuan";
                                        else
                                            echo "Memenuhi Ketentuan";
                                        ?>"/>
                                        <input type="hidden" id="tiRomawiEvalValFinal" name="TI[17]" value="<?php echo $penilaianTI[16]; ?>" />
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div style="height:5px;" id="expand6b"></div>


                    <?php if (in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) { ?>
                        <div class="expand"><a title="expand/collapse" href="#" style="display: block;">KESIMPULAN</a></div>
                        <div class="collapse">
                            <div class="accCntnt">
                                <table class="form_tabel_detail">
                                    <tr>
                                        <td style="width: 2%;"></td>
                                        <td style="width: 50%;"></td>
                                        <td style="width: 13%;"></td>
                                        <td style="width: 35%; font-size: 14px; padding-left: 250px; padding-right: 250px; padding-bottom: 5px; padding-top: 5px;"></td>
                                    </tr>
                                    <?php
                                    //Pusat
                                    if ((!$sess['HASIL_PUSAT'] && in_array('2', $this->newsession->userdata('SESS_KODE_ROLE'))) || $editTL == 'YES') {
                                        ?>
                                        <tr><td class="td_left_checklist"></td><td class="td_left">Verifikasi Pusat</td><td></td><td class="td_right"><select class="stext verifikasiPusat" name="<?php echo 'IKLAN[HASIL_PUSAT]' ?>" rel="required" title="MK/TMK"><option></option><option value="MK" <?php if ($sess['HASIL_PUSAT'] == 'MK') echo 'Selected' ?>>Memenuhi Ketentuan</option><option value="TMK"  <?php if ($sess['HASIL_PUSAT'] == 'TMK') echo 'Selected' ?>>Tidak Memenuhi Ketentuan</option></select></td></tr>
                                        <tr class="vTMK" hidden><td class="td_left_checklist"></td><td class="td_left"style="background-color: white;">Tindak Lanjut</td><td></td><td class="td_right" style="background-color: white;"><span id="nonCetak" hidden><?php echo form_dropdown('', $cb_tindakan, $sess['TL_PUSAT'], 'class="stext vTMK vTMKSub nonCetak" title="Tindak Lanjut Pusat"'); ?></span><span id="ygCetak" hidden><?php echo form_dropdown('', $cb_tindakan2, $sess['TL_PUSAT'], 'class="stext vTMK vTMKSub ygCetak" title="Tindak Lanjut Pusat"'); ?></span></td></tr>
                                        <tr class="vJustifikasi" hidden><td class="td_left_checklist"></td><td class="td_left" style="background-color: white;">Justifikasi</td><td></td><td class="td_right" style="background-color: white;"><textarea name="JUSTIFIKASI" title="Justifikasi Pusat" class="stext chkJustifikasi" id="XXX" style="height: 140px"><?php echo $sess['JUSTIFIKASI_PUSAT']; ?></textarea></td></tr><?php
                                    } else {
                                        if ($sess['HASIL_PUSAT'] == "TMK") {
                                            ?>
                                            <tr><td class="td_left">Verifikasi Pusat</td><td class="td_right"><b><i><?php
                                                            if ($sess['HASIL_PUSAT'] == 'MK')
                                                                echo 'Memenuhi Ketentuan';
                                                            else
                                                                echo 'Tidak Memenuhi Ketentuan';
                                                            ?></i></b></td></tr>
                                            <?php
                                        }
                                    }
                                    ?>
                                </table>
                            </div>
                        </div>
                        <div style="height:5px;"></div>
                    <?php } ?>

                    <!--8-->
                    <div class="expand"><a title="expand/collapse" href="#" style="display: block;">LAMPIRAN</a></div>
                    <div class="collapse">
                        <div class="accCntnt">
                            <table class="form_tabel_detail">
                                <tr>
                                    <td class="td_left_checklist" colspan="5" style="margin-right: 200px">
                                        <?php
                                        if (array_key_exists('FILE_IKLAN', $sess) && trim($sess['FILE_IKLAN']) != "") {
                                            ?>
                                            <span id="file_FILE_IKLAN"><input type="hidden" name="IKLAN_NAPZA[FILE_IKLAN]" value="<?php echo $sess['FILE_IKLAN']; ?>"><a href="<?php echo base_url(); ?>files/<?php echo 'iklan_007'; ?>/<?php echo $sess['FILE_IKLAN']; ?>" target="_blank">File Lampiran</a>&nbsp;&bull;&nbsp;<a href="#" class="del_upload" url="<?php echo site_url(); ?>/utility/uploads/del_upload_s/<?php echo 'iklan_007'; ?>/<?php echo $sess['FILE_IKLAN']; ?>" jns="FILE_IKLAN">Edit atau Hapus File ?</a></span>
                                            <span class="upload_FILE_IKLAN" hidden><input type="file" class="upload" jenis="FILE_IKLAN" allowed="jpg-jpeg-pdf-doc-docx-rar" url="<?php echo site_url(); ?>/utility/uploads/get_upload_s/<?php echo 'iklan_007'; ?>" id="fileToUpload_FILE_IKLAN" name="userfile" onchange="do_upload($(this));
                                                return false;" title="Lampiran Berita Acara" />
                                                &nbsp;Tipe File : *.jpg .jpeg .pdf .doc .docx .rar</span><span class="file_FILE_IKLAN"></span>
                                            <?php
                                        } else {
                                            ?>
                                            <span class="upload_FILE_IKLAN"><input type="file" class="upload" jenis="FILE_IKLAN" allowed="jpg-jpeg-pdf-doc-docx-rar" url="<?php echo site_url(); ?>/utility/uploads/get_upload_s/<?php echo 'iklan_007'; ?>" id="fileToUpload_FILE_IKLAN" name="userfile" onchange="do_upload($(this));
                                                return false;" title="Lampiran Berita Acara" />
                                                &nbsp;Tipe File : *.jpg .jpeg .pdf .doc .docx .rar</span><span class="file_FILE_IKLAN"></span>
                                            <?php
                                        }
                                        ?>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

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
                    </div>
                <?php } ?>

                <div style="padding:10px;"></div><div><a href="javascript:void(0)" id="btnSave" class="button <?php echo $icon; ?>" onclick="fpost('#fpengawasanIklan_007', '', '');">
                        <span><span class="icon"></span>&nbsp; <?php echo $labelSimpan; ?> </span></a>&nbsp;
                    <a href="javascript:void(0)" class="button back" onclick="goBack()" >
                        <span><span class="icon"></span>&nbsp; Kembali</span></a></div>
                <br />
                <br />
            </div>
        </div>
        <input type="hidden" name="IKLAN_ID[]" value="<?php echo $sess['IKLAN_ID']; ?>" />
        <input type="hidden" name="UPDATE" value="<?php echo $sess['STATUS']; ?>" />
        <input type="hidden" name="KLASIFIKASIIKLAN" value="<?php echo $klasifikasi; ?>" />
        <input type="hidden" name="EDIT" value="<?php echo $editTL; ?>" />
        <input type="hidden" name="TUJUAN" value="<?php echo $tujuan; ?>" />
    </form>
</div>
</div>
<input type="hidden" name="ID" value="<?php echo $id; ?>" />
<script type="text/javascript">
                                        function goBack()
                                        {
                                            window.history.back()
                                        }
                                        function mediaIklan2(X) {
                                            $("#pChoosed").val('');
                                            $("#lrChoosed").val('');
                                            $("#lnChoosed").val('');
                                            $("#cChoosed").val('');
                                            clear();
                                            showHide();
                                            cekLampiran();
                                            jenisPenilaian($(X));
                                        }
                                        function jenisPenilaian(X) {
                                            var iklanMedia = $("#iklan_media").val();
                                            if (iklanMedia != "")
                                                $("#medianyaKosong").hide();
                                            else
                                                $("#medianyaKosong").show();
                                            $(".subPenilaianCetak").attr("rel", "");
                                            $(".subPenilaianLuarRuang").attr("rel", "");
                                            $(".subPenilaianRadio").attr("rel", "");
                                            $(".subPenilaianTV").attr("rel", "");
                                            $(".subPenilaianTI").attr("rel", "");
                                            if ($(X).val() == "Radio") {
                                                $("#penilaianCetak").hide();
                                                $(".penilaianCetak").attr("rel", "");
                                                $("#penilaianLuarRuang").hide();
                                                $(".penilaianLuarRuang").attr("rel", "");
                                                $("#penilaianRadio").show();
                                                $(".penilaianRadio").attr("rel", "required");
                                                $("#penilaianTV").hide();
                                                $(".penilaianTV").attr("rel", "");
                                                $("#penilaianTI").hide();
                                                $(".penilaianTI").attr("rel", "");
                                                $(".pantauTime").hide();
                                                $(".tayangTime").show();
                                                $(".luarTime").hide();
                                                $(".edisiTime").hide();
                                                $(".edisiCetak").attr("rel", "");
                                                $(".time").attr("rel", "required");
                                                $(".edisiLuar").attr("rel", "");
                                                $("#namaMedia").show();
                                                $(".namaMedia").attr("rel", "required");
                                                document.getElementById("namaMedia1").innerHTML = "Nama Stasiun Radio";
                                            }
                                            else if ($(X).val() == "Cetak") {
                                                $("#penilaianCetak").show();
                                                $(".penilaianCetak").attr("rel", "required");
                                                $("#penilaianLuarRuang").hide();
                                                $(".penilaianLuarRuang").attr("rel", "");
                                                $("#penilaianRadio").hide();
                                                $(".penilaianRadio").attr("rel", "");
                                                $("#penilaianTV").hide();
                                                $(".penilaianTV").attr("rel", "");
                                                $("#penilaianTI").hide();
                                                $(".penilaianTI").attr("rel", "");
                                                $(".tayangTime").hide();
                                                $(".pantauTime").hide();
                                                $(".tayangTime").hide();
                                                $(".luarTime").hide();
                                                $(".edisiTime").show();
                                                $(".edisiCetak").attr("rel", "required");
                                                $(".time").attr("rel", "");
                                                $(".edisiLuar").attr("rel", "");
                                                $("#namaMedia").show("");
                                                $(".namaMedia").attr("rel", "required");
                                                document.getElementById("namaMedia1").innerHTML = "Nama Media Cetak";
                                            }
                                            else if ($(X).val() == "Luar Ruang") {
                                                $("#penilaianCetak").hide();
                                                $(".penilaianCetak").attr("rel", "");
                                                $("#penilaianLuarRuang").show();
                                                $(".penilaianLuarRuang").attr("rel", "required");
                                                $("#penilaianRadio").hide();
                                                $(".penilaianRadio").attr("rel", "");
                                                $("#penilaianTV").hide();
                                                $(".penilaianTV").attr("rel", "");
                                                $("#penilaianTI").hide();
                                                $(".penilaianTI").attr("rel", "");
                                                $(".pantauTime").hide();
                                                $(".tayangTime").hide();
                                                $(".luarTime").show();
                                                $(".edisiTime").hide();
                                                $(".edisiCetak").attr("rel", "");
                                                $(".time").attr("rel", "");
                                                $(".edisiLuar").attr("rel", "required");
                                                $("#namaMedia").hide();
                                                $(".namaMedia").attr("rel", "");
                                            }
                                            else if ($(X).val() == "TV") {
                                                $("#penilaianCetak").hide();
                                                $(".penilaianCetak").attr("rel", "");
                                                $("#penilaianLuarRuang").hide();
                                                $(".penilaianLuarRuang").attr("rel", "");
                                                $("#penilaianRadio").hide();
                                                $(".penilaianRadio").attr("rel", "");
                                                $("#penilaianTV").show();
                                                $(".penilaianTV").attr("rel", "required");
                                                $("#penilaianTI").hide();
                                                $(".penilaianTI").attr("rel", "");
                                                $(".pantauTime").hide();
                                                $(".tayangTime").show();
                                                $(".luarTime").hide();
                                                $(".edisiTime").hide();
                                                $(".edisiCetak").attr("rel", "");
                                                $(".time").attr("rel", "required");
                                                $(".edisiLuar").attr("rel", "");
                                                $("#namaMedia").show();
                                                $(".namaMedia").attr("rel", "required");
                                                document.getElementById("namaMedia1").innerHTML = "Nama Stasiun TV";
                                            }
                                            else if ($(X).val() == "Media Teknologi Informasi Lainnya") {
                                                $("#penilaianCetak").hide();
                                                $(".penilaianCetak").attr("rel", "");
                                                $("#penilaianLuarRuang").hide();
                                                $(".penilaianLuarRuang").attr("rel", "");
                                                $("#penilaianRadio").hide();
                                                $(".penilaianRadio").attr("rel", "");
                                                $("#penilaianTV").hide();
                                                $(".penilaianTV").attr("rel", "");
                                                $("#penilaianTI").show();
                                                $(".penilaianTI").attr("rel", "required");
                                                $(".pantauTime").show();
                                                $(".tayangTime").hide();
                                                $(".luarTime").hide();
                                                $(".edisiTime").hide();
                                                $(".edisiCetak").attr("rel", "");
                                                $(".time").attr("rel", "required");
                                                $(".edisiLuar").attr("rel", "");
                                                $("#namaMedia").show();
                                                $(".namaMedia").attr("rel", "required");
                                                document.getElementById("namaMedia1").innerHTML = "Alamat Website";
                                            }
                                            if ($(X).val() == "Radio" || $(X).val() == "Media Teknologi Informasi Lainnya" || $(X).val() == "TV")
                                                $(".time").show();
                                            else
                                                $(".time").hide();
                                        }
                                        function cekLampiran() {
                                            var val = $("#iklan_media").val();
                                            if (val == "Penyiaran")
                                                $('.upload').attr('rel', '');
                                            else {
<?php
if (!array_key_exists('FILE_IKLAN', $sess) && trim($sess['FILE_IKLAN']) == "") {
    ?>
                                                    $('.upload').attr('rel', 'required');
<?php } ?>
                                            }
//    var kesimpulan = $('#kesimpulanHasilPenilaian').val(), jenis = $('#iklan_media').val();
//    if ((kesimpulan === 'Tidak Memenuhi Ketentuan' && jenis === 'Cetak') || kesimpulan === 'Tidak Memenuhi Ketentuan' && jenis === 'Luar Ruang') {
//      $('.upload').attr('rel', 'required');
//    } else {
//      $('.upload').attr('rel', ' ');
//      $(".upload").css("background-color", "#FFF");
//      $(".upload").css("border", "");
//    }
                                        }
                                        function showHide2(X) {
                                            var param = "";
                                            if (typeof X === "object")
                                                param = $(X).val();
                                            else
                                                param = X;
                                            $("#namaMediaIklan").unautocomplete();
                                            $(".ac_results").remove();
                                            $("#namaMediaIklan").autocomplete($("#namaMediaIklan").attr("url") + param, {width: 244, selectFirst: false});
                                            $("#namaMediaIklan").attr("name", "IKLAN[NAMA]");
                                        }
//          function showHide3(X) {
//           var param = "";
//           if (typeof X === "object")
//            param = $(X).val();
//           else
//            param = X;
//           if (param == "Penyiaran") {
//            $("#tayangTime").show("");
//            $("#edisiTime").hide("");
//            $(".edisiCetak").attr("rel", "");
//            $(".edisiTV").attr("rel", "required");
//           } else if (param == "Cetak") {
//
//           } else {
//            $("#tayangTime").hide("");
//            $("#edisiTime").hide("");
//            $(".edisiCetak").attr("rel", "");
//            $(".edisiTV").attr("rel", "");
//           }
//          }
                                        function mediaIklan(X) {
                                            clear();
                                            showHide2(X);
                                            jenisPenilaian(X);
                                        }
                                        function clear() {
                                            $(".uraianPenilaian").attr("checked", false);
                                            $("#namaMedia").val("");
                                            $("#namaMediaIklan").val("");
                                            $("#idMediaIklan").val("");
                                            $("#idMediaIklan").attr("name", "");
                                            $("#tglTugas").val('');
                                            $(".edisiTayang").val('');
                                            $("#namaLokasi").val('');
                                            $("#alamatLokasi").val('');
                                            $(".penilaianRadio").val("");
                                            $(".penilaianCetak").val("");
                                            $(".penilaianTV").val("");
                                            $(".penilaianTI").val("");
                                            $(".penilaianLuarRuang").val("");
                                            $(".subPenilaianRadio").val("");
                                            $(".subPenilaianCetak").val("");
                                            $(".subPenilaianTV").val("");
                                            $(".subPenilaianTI").val("");
                                            $(".subPenilaianLuarRuang").val("");
                                            $(".subPenilaianRadio").hide();
                                            $(".subPenilaianCetak").hide();
                                            $(".subPenilaianTV").hide();
                                            $(".subPenilaianTI").hide();
                                            $(".subPenilaianLuarRuang").hide();
                                        }
                                        function showHide() {
                                            var jenisIklan = $("#iklan_media").val();
                                            var x;
                                            if (jenisIklan === "Cetak") {
                                                $(".penyiaranChoosed").hide();
                                                $(".lRChoosed").hide();
                                                $(".cetakChoosed").show();
                                                $(".lainnyaChoosed").hide();
//      $(".penyiaranChoosed").attr("rel", "");
//      $(".cetakChoosed").attr("rel", "required");
                                                $('#expand4').fadeIn("slow");
                                                $('#expand4a').fadeIn("slow");
                                                $('#expand4b').fadeIn("slow");
                                                $("#cChoosed").attr("rel", "required");
                                                $("#lrChoosed").attr("rel", " ");
                                                $("#lnChoosed").attr("rel", "");
                                                $("#lnChoosedTitle").html("Jenis Media");
                                                $("#pChoosed").attr("rel", " ");
                                                x = 1;
                                            }
                                            else if (jenisIklan === "Penyiaran") {
                                                $(".lRChoosed").hide();
                                                $(".cetakChoosed").hide();
                                                $(".lainnyaChoosed").hide();
                                                $(".penyiaranChoosed").show();
//      $(".penyiaranChoosed").attr("rel", "required");
//      $(".cetakChoosed").attr("rel", "");
                                                $('#expand4').fadeIn("slow");
                                                $('#expand4a').fadeIn("slow");
                                                $('#expand4b').fadeIn("slow");
                                                $('#deskripsiIklan').attr("rel", "required");
                                                $("#cChoosed").attr("rel", "");
                                                $("#lrChoosed").attr("rel", "");
                                                $("#lnChoosed").attr("rel", "");
                                                $("#lnChoosedTitle").html("Jenis Media");
                                                $("#pChoosed").attr("rel", "required");
                                                x = 1;
                                            }
                                            else if (jenisIklan === "Luar Ruang") {
                                                $(".penyiaranChoosed").hide();
                                                $(".cetakChoosed").hide();
                                                $(".lainnyaChoosed").hide();
                                                $(".penyiaranChoosed").attr("rel", "");
                                                $(".cetakChoosed").attr("rel", "");
                                                $('#expand4').fadeIn("slow");
                                                $('#expand4a').fadeIn("slow");
                                                $('#expand4b').fadeIn("slow");
                                                $(".lRChoosed").show();
                                                $("#cChoosed").attr("rel", "");
                                                $("#lrChoosed").attr("rel", "required");
                                                $("#lnChoosed").attr("rel", "");
                                                $("#lnChoosedTitle").html("Jenis Media");
                                                $("#pChoosed").attr("rel", "");
                                                x = 0;
                                            }
                                            else if (jenisIklan === "Media Teknologi Informasi Lainnya") {
                                                $(".penyiaranChoosed").hide();
                                                $(".cetakChoosed").hide();
                                                $(".lRChoosed").hide();
                                                $(".penyiaranChoosed").attr("rel", "");
                                                $(".cetakChoosed").attr("rel", "");
                                                $('#expand4').fadeIn("slow");
                                                $('#expand4a').fadeIn("slow");
                                                $('#expand4b').fadeIn("slow");
                                                $(".lainnyaChoosed").show();
                                                $("#cChoosed").attr("rel", "");
                                                $("#lrChoosed").attr("rel", "");
                                                $("#lnChoosed").attr("rel", "required");
                                                $("#lnChoosedTitle").html("Nama Media Teknologi Infomasi Lainnya");
                                                $("#pChoosed").attr("rel", "");
                                                $("#tglTugas").attr("rel", "");
                                                $("#namaMediaIklan").unautocomplete();
                                                $("#namaMediaIklan").attr("name", "IKLAN[NAMA]");
                                                x = 1;
                                            }
                                            if (x == 1) {
                                                $("#provkotAlamat").attr("");
                                                $("#kabkotAlamat").attr("rel", "");
                                                $("#provkotAlamat").css('background-color', '#FFFFFF');
                                                $("#provkotAlamat").css('border', '1px solid #dcdcdc');
                                                $("#kabkotAlamat").css('background-color', '#FFFFFF');
                                                $("#kabkotAlamat").css('border', '1px solid #dcdcdc');
                                            } else if (x == 0) {
                                                $("#provkotAlamat").attr("rel", "required");
                                                $("#kabkotAlamat").attr("rel", "required");
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
                                                    if (typeof (data.error) != "undefined") {
                                                        if (data.error != "") {
                                                            jAlert(data.error, "SIPT Versi 1.0 Beta");
                                                        } else {
                                                            if (arrdata[2] == "FILE_IKLAN") {
                                                                $("#fileToUpload_" + arrdata[2] + "").removeAttr("rel");
                                                                $(".upload_" + arrdata[2] + "").hide();
                                                                $("#file_" + arrdata[2] + "").hide();
                                                                $(".file_" + arrdata[2] + "").html("<b>1 File telah dilampirkan. </b>&nbsp;<a href=\"<?php echo base_url(); ?>files/" + arrdata[3] + "/" + arrdata[0] + "\" target=\"_blank\">Tampilkan File</a>&nbsp;&bull;&nbsp;<a href=\"#\" class=\"del_upload\" url=\"<?php echo site_url(); ?>/utility/uploads/del_upload_s/" + arrdata[3] + "/" + arrdata[0] + "\" jns=" + arrdata[2] + ">Edit atau Hapus File ?</a><input type=\"hidden\" name=\"IKLAN_NAPZA[" + arrdata[2] + "]\" value=" + arrdata[0] + ">");
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
                                            var tgl1 = "#tglXX", tgl2 = "#tglAwalPengawasan", tgl3 = "#tglAkhirPengawasan", tgl4 = "#tglTugas", tgl5 = "#tglSuratTL";
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
                                            else if (A === "C") {
                                                compare2(tgl4, tgl3, tgl4, "Harap dipastikan untuk Tanggal Terbit Media : \n  Harus lebih kecil dari Tanggal Akhir Pemeriksaan");
                                            }
                                            else if (A === "D") {
                                                compare2(tgl2, tgl5, tgl5, "Harap dipastikan untuk Tanggal Surat : \n  Harus lebih besar dari Tanggal Awal Pemeriksaan");
                                            }
                                        }
                                        function compare2(objstart, objend, focuz, alertz) {
                                            var date_str = $(objstart).val();
                                            var date_end = $(objend).val();
                                            date_str = new Date(date_str.split('/')[2], date_str.split('/')[1], date_str.split('/')[0]);
                                            date_end = new Date(date_end.split('/')[2], date_end.split('/')[1], date_end.split('/')[0]);
                                            if (date_end.getTime() < date_str.getTime()) {
                                                jAlert(alertz, "SIPT Versi 1.0");
                                                $(focuz).val('');
                                                $(focuz).focus();
                                                return false;
                                            }
                                        }
                                        function cekAll() {
                                            var rE, Re2;
                                            $('.uraianPelanggaran').each(function() {
                                                if ($('.uraianPelanggaran:checked').length > 0) {
                                                    Re2 = true;
                                                }
                                            });
                                            $('.uPelanggaran').each(function() {
                                                if ($(this).val() !== '' && Re2 === true) {
                                                    rE = true;
                                                } else if ($(this).val() === '' && Re2 === true) {
                                                    rE = true;
                                                }
                                            });
                                            return rE;
                                        }
                                        function checkListTxt(XXX) {
                                            var A = $(XXX).val().split('_'), B = "A", param = $(XXX).attr('param'), name = $(XXX).attr("name");
                                            if (name === "CETAK[6]")
                                                B = "B";
                                            if (A[0] === '+' && B === "A") {
                                                $('.' + param).show();
                                                $('.' + param + "Val").attr("rel", "required");
                                                $("[id='" + name + "']").attr("rel", "required");
                                            }
                                            else if (A[0] === '-' && B === "B") {
                                                $('.' + param).show();
                                                $('.' + param + "Val").attr("rel", "required");
                                                $("[id='" + name + "']").attr("rel", "required");
                                            } else {
                                                $('.' + param).hide();
                                                $('.' + param + "Val").attr("rel", "");
                                                $("[id='" + name + "']").val("");
                                                $("[id='" + name + "']").attr("rel", "");
                                                $("[id='" + name + "']").css("background-color", "#FFF");
                                                $("[id='" + name + "']").css("border", "");
                                            }
                                        }
                                        function checkList(obj) {
                                            var XXX = obj.attr("name"), xxx = obj.val(), X = "input:radio[name='" + XXX + "']", cls = obj.attr("class");
                                            if ($(X).is(":checked")) {
                                                uraianTidakLengkap();
                                                if (cls === 'infoTambahan') {
                                                    uraianPenilaian1();
                                                }
                                            }
                                        }
                                        function checklistSub(clazz) {
                                            var i = 0;
                                            $('.' + clazz).each(function() {
                                                if ($(this).is(":checked")) {
                                                    $('.' + clazz).closest("tr").css('border-left', '0px solid #F00');
                                                    $('.' + clazz).closest("tr").css('border-right', '0px solid #F00');
                                                    i++;
                                                }
                                                else
                                                    i - 1;
                                            });
                                            if (i !== 0) {
                                                $('.' + clazz + 'Val').attr("rel", "");
                                            }
                                            else
                                                $('.' + clazz + 'Val').attr("rel", "required");
                                        }
                                        function checklistSubClear(clazz) {
                                            var i = 0;
                                            $('.' + clazz).each(function() {
                                                if ($(this).is(":checked")) {
                                                    i++;
                                                }
                                            });
                                            if (i > 1) {
                                                $('.' + clazz + 'Val').val("");
                                                $('.' + clazz).attr("checked", false);
                                            }
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
                                                $(".diData").hide();
                                                $(".diData").attr("rel", "");
                                                $("#diData").attr("name", "");
                                                $("#diData").val("");
                                            }
                                            else if ($(X).val() === "TMK") {
                                                $("#ygCetak").hide();
                                                $("#nonCetak").hide();
                                                $(".vTMK").show();
                                                if ($("#iklan_media").val() === "Cetak") {
                                                    $("#ygCetak").show();
                                                    $(".ygCetak").attr("rel", "required");
                                                    $(".ygCetak").attr("name", "IKLAN[TL_PUSAT]");
                                                    $(".nonCetak").attr("rel", "");
                                                    $(".nonCetak").attr("name", "");
                                                }
                                                else {
                                                    $("#nonCetak").show();
                                                    $(".nonCetak").attr("rel", "required");
                                                    $(".nonCetak").attr("name", "IKLAN[TL_PUSAT]");
                                                    $(".ygCetak").attr("rel", "");
                                                    $(".ygCetak").attr("name", "");
                                                }
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
                                                $(".diData").hide();
                                                $(".diData").attr("rel", "");
                                                $("#diData").attr("name", "");
                                                $("#diData").val("");
                                            }
                                            if ($(X).val() != '') {
                                                if ($(X).val() != $("#kesimpulanHasilPenilaianVal").val()) {
                                                    $(".vJustifikasi").show("slow");
                                                    $(".chkJustifikasi").attr("rel", "required");
                                                } else if ($(X).val() == $("#kesimpulanHasilPenilaianVal").val()) {
                                                    $(".vJustifikasi").hide("slow");
                                                    $(".chkJustifikasi").attr("rel", "");
                                                    $("#jmlMusnahPusat").attr("name", "");
                                                    $("#satuanMusnahPusat").attr("name", "");
                                                    $("#fileMusnahPusat").attr("name", "");
                                                }
                                            } else {
                                                $(".vJustifikasi").hide("slow");
                                                $(".chkJustifikasi").attr("rel", "");
                                            }
                                        }
                                        function statisGerak(obj) {
                                            $(".X").hide();
                                            $(".X").val("");
                                            $(".XCHK").attr("checked", false);
                                            $(".X").attr("rel", "");
                                            $(".row" + $(obj).val()).show();
                                            $(".penilaianTI" + $(obj).val()).attr("rel", "required");
                                        }
                                        function loadPenilaianReq(X) {
<?php for ($i = 1; $i <= count($penilaianAll); $i++) { ?>
                                                if ($("[name='" + X + "[<?php echo $i ?>]']").is("input:radio") || $("[name='" + X + "[<?php echo $i ?>]']").is("input:checkbox")) {
                                                    $("[name='" + X + "[<?php echo $i ?>]']:radio:checked").each(function() {
                                                        checkListTxt($(this));
                                                    });
                                                    $("[name='" + X + "[<?php echo $i ?>]']:checkbox:checked").each(function() {
                                                        checkListTxt($(this));
                                                    });
                                                }
<?php } ?>
                                        }
                                        function mkTmk(part) {
                                            var x = 0, y = 0;
                                            $("input[part=" + part + "]:radio:checked").each(function() {
                                                var val = $(this).val();
                                                var spl = val.split("_");
                                                if (spl[0] === "-" || spl[0] === "x")
                                                    x++;
                                            });
                                            $("select[part=" + part + "]").each(function() {
                                                var param = ["22", "32", "14", "24", "11", "21"];
                                                if ($(this).attr("multiple") == true) {
                                                    $.each($(this).val(), function(i, val) {
                                                        for (var i = 0; i < param.length; i++) {
                                                            if (param[i] == val)
                                                                y++;
                                                        }
                                                    });
                                                } else {
                                                    for (var i = 0; i < param.length; i++) {
                                                        if (param[i] == $(this).val())
                                                            y++;
                                                    }
                                                }
                                            });
                                            if (x > 0 || y > 0) {
                                                $("#" + part + "Eval").val("Tidak Memenuhi Ketentuan");
                                                $("#" + part + "EvalVal").val("TMK");
                                            }
                                            else {
                                                $("#" + part + "Eval").val(" Memenuhi Ketentuan")
                                                $("#" + part + "EvalVal").val("MK");
                                            }
                                            if (part != null)
                                                mkTmkFinal(part.slice(0, -1));
                                        }
                                        function mkTmkFinal(part) {
                                            var x = 0;
                                            $("." + part + "MkTmk").each(function() {
                                                if ($(this).val() === "Tidak Memenuhi Ketentuan" || $(this).val() === "")
                                                    x++;
                                            });
                                            if (x > 0) {
                                                $("#" + part + "EvalFinal").val("Tidak Memenuhi Ketentuan")
                                                $("#" + part + "EvalValFinal").val("TMK");
                                            }
                                            else {
                                                $("#" + part + "EvalFinal").val("Memenuhi Ketentuan")
                                                $("#" + part + "EvalValFinal").val("MK");
                                            }
                                        }
                                        function cmbRadio(obj) {
                                            if ($(obj).val() == "14") {
                                                $(".cmbRadio").show();
                                                $(".cmbRadio").attr("rel", "required");
                                            } else {
                                                $(".cmbRadio").hide();
                                                $(".cmbRadio").attr("rel", "");
                                            }
                                        }
                                        function namaMedia() {
                                            $("#namaMediaIklan").result(function(event, data, formatted) {
                                                if (data) {
                                                    $("#namaMediaIklan").attr("name", "");
                                                    $("#idMediaIklan").attr("name", "IKLAN[NAMA]");
                                                    $("#namaMediaIklan").val(data[1]);
                                                    $("#idMediaIklan").val(data[2]);
                                                }
                                            });
                                        }
                                        $(document).ready(function() {
                                            $("textarea.chkJustifikasi").redactor({
                                                buttons: ['bold', 'italic', '|', 'unorderedlist', 'orderedlist', 'outdent', 'indent', '|', 'alignleft', 'aligncenter', 'alignright', 'justify'],
                                                removeStyles: false,
                                                cleanUp: true,
                                                autoformat: true
                                            });
//                      load data edit
<?php if (array_key_exists('IKLAN_ID', $sess)) { ?>
                                                $("#iklan_kelompok option[value='<?php echo $sess["KELOMPOK_IKLAN"]; ?>']").attr("selected", "selected");
                                                $("#iklan_media option[value='<?php echo $sess["JENIS_IKLAN"]; ?>']").attr("selected", "selected");
                                                $("[name='IKLAN[EDISI1]'] option[value='<?php echo $edisiMedia[0]; ?>']").attr("selected", "selected");
                                                $("[name='IKLAN[EDISI2]'] option[value='<?php echo $edisiMedia[1]; ?>']").attr("selected", "selected");
                                                $("[name='IKLAN[TAYANG1]'] option[value='<?php echo $tayangMedia[0]; ?>']").attr("selected", "selected");
                                                $("[name='IKLAN[TAYANG2]'] option[value='<?php echo $tayangMedia[1]; ?>']").attr("selected", "selected");
                                                if ("<?php echo $provinsiVal; ?>" !== " " && "<?php echo $provinsiVal; ?>" !== "") {
                                                    var kunci = $("#provkotAlamat").val();
                                                    $.get("<?php echo site_url(); ?>/get/iklan_penandaan/set_provinsi/" + kunci, function(hasil) {
                                                        hasil = hasil.replace(" ", "");
                                                        if (hasil != "") {
                                                            $("#kabkotAlamat").html(hasil);
                                                            $("#kabkotAlamat").val("<?php echo $kabupatenVal; ?>");
                                                        }
                                                    });
                                                }
    <?php if (in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) { ?>
                                                    verifikasiPusat($(".verifikasiPusat"));
                                                    verifikasiTL($("#vTMKSub"));
    <?php } ?>
                                                if ('<?php echo $sess["JENIS"] ?>' === "CT") {
                                                    $(".mediaIklanEditC option[value='<?php echo $sess["MEDIA"]; ?>']").attr("selected", "selected");
                                                    jenisPenilaian("#iklan_media");
                                                    loadPenilaianReq("CETAK");
                                                }
                                                else if ('<?php echo $sess["JENIS"] ?>' === "LR") {
                                                    $(".mediaIklanEditLr option[value='<?php echo $sess["MEDIA"]; ?>']").attr("selected", "selected");
                                                    jenisPenilaian("#iklan_media");
                                                    loadPenilaianReq("LUARRUANG");
                                                }
                                                else if ('<?php echo $sess["JENIS"] ?>' === "TI") {
                                                    $(".mediaIklanEditTi").val("<?php echo $sess["MEDIA"]; ?>");
                                                    jenisPenilaian("#iklan_media");
                                                    loadPenilaianReq("TI");
                                                }
                                                else if ('<?php echo $sess["JENIS"] ?>' === "RD") {
                                                    $(".mediaIklanEditP option[value='<?php echo $sess["MEDIA"]; ?>']").attr("selected", "selected");
                                                    jenisPenilaian($(".mediaIklanEditP"));
                                                    loadPenilaianReq("RADIO");
                                                    cmbRadio("#cmbRadio");
                                                }
                                                else if ('<?php echo $sess["JENIS"] ?>' === "TV") {
                                                    $(".mediaIklanEditP option[value='<?php echo $sess["MEDIA"]; ?>']").attr("selected", "selected");
                                                    jenisPenilaian($(".mediaIklanEditP"));
                                                    loadPenilaianReq("TV");
                                                }
                                                showHide();
                                                showHide2('<?php echo $sess['MEDIA']; ?>');
                                                $(".subPenilaianLuarRuangGTVal").attr("rel", "");
                                                $(".subPenilaianRadioGTVal").attr("rel", "");
                                                $(".subPenilaianCetakGTVal").attr("rel", "");
                                                $(".subPenilaianTVGTVal").attr("rel", "");
                                                $(".subPenilaianTIGTVal").attr("rel", "");
<?php } ?>
                                            //                      akhir load data edit
                                            $('input.sdate').datepicker({dateFormat: 'dd/mm/yy', regional: 'id'});
                                            $("#iklan_kelompok").change(function() {
                                                clear();
                                                showHide();
                                            });
                                            $('#cChoosed').change(function() {
                                                showHide();
                                            });
                                            $('#pChoosed').change(function() {
                                                showHide();
                                            });
                                            $('#lRChoosed').change(function() {
                                                showHide();
                                            });
                                            $('#kesimpulanHasilPenilaian').change(function() {
                                                cekLampiran();
                                            });
                                            $(".subPenilaianRadioGT").click(function() {
                                                checklistSubClear('subPenilaianRadioGT');
                                                $(this).attr("checked", true);
                                                checklistSub('subPenilaianRadioGT');
                                            });
                                            $(".subPenilaianCetakGT").click(function() {
                                                checklistSubClear('subPenilaianCetakGT');
                                                $(this).attr("checked", true);
                                                checklistSub('subPenilaianCetakGT');
                                            });
                                            $(".subPenilaianLuarRuangGT").click(function() {
                                                checklistSubClear('subPenilaianLuarRuangGT');
                                                $(this).attr("checked", true);
                                                checklistSub('subPenilaianLuarRuangGT');
                                            });
                                            $(".subPenilaianTVGT").click(function() {
                                                checklistSubClear('subPenilaianTVGT');
                                                $(this).attr("checked", true);
                                                checklistSub('subPenilaianTVGT');
                                            });
                                            $(".subPenilaianTIGT").click(function() {
                                                checklistSubClear('subPenilaianTIGT');
                                                $(this).attr("checked", true);
                                                checklistSub('subPenilaianTIGT');
                                            });
                                            $(".uraianPenilaian").click(function() {
                                                var name = $(this).attr("name");
                                                var part = $(this).attr("part");
                                                var selected = $("[name='" + name + "']:checked").val();
                                                $("input[type='text'][name='" + name + "']").val(selected);
                                                $(this).closest("tr").css('border-left', '0px solid #F00');
                                                $(this).closest("tr").css('border-right', '0px solid #F00');
                                                mkTmk(part);
                                                checkListTxt($(this));
                                            });
                                            $(".uraianPenilaianCmb").change(function() {
                                                var part = $(this).attr("part");
                                                mkTmk(part);
                                            });
                                            $('.addnomor').click(function() {
                                                var nom = $(this).attr('terakhir'), idtr = $(this).attr('periksa'), cls = idtr + nom;
                                                $("#tb_napza").append('<tr class= "' + cls + '"><td>&nbsp;</td><tr class= "' + cls + '"><td width="150">Nama / Merk Rokok</td><td><input type="text" size="40" name="PRODUK[NAMA][]" class="namaNapza" id="namaNapza' + cls + '" title="Nama / Merk Rokok" rel="required"/>&nbsp;<a href="javascript:void(0)" class="min" id="minCls' + cls + '" ><img src="<?php echo base_url(); ?>images/cancel.png" align="top" style="border:none" title="Hapus Rokok" /></a><input type="hidden" name="BBPOM[BBPOM_ID][]" id="bbpomid' + cls + '"><input type="hidden" name="BBPOM[MBBPOM_ID][]" id="mbbpomid' + cls + '"></td></tr><tr class= "' + cls + '"><td width="150">Nama Produsen</td><td><input type="text" size="40" name="PRODUK[NAMAPEMILIKIZINEDAR][]" id="namaPemilikNIE' + cls + '" title="NamaProdusen" rel="required" /></td></tr><tr class= "' + cls + '"><td width="150">Bentuk Kemasan Produk Tembakau</td><td><select class="stext" title="Bentuk Kemasan Produk Tembakau" name="PRODUK[NAMAPEMILIKIZINEDAR][]" id="bentukKemasan' + cls + '" rel = "required"><option value=""></option><option value="BLL">Bentuk lainnya</option><option value="KPP">Kotak persegi panjang</option><option value="KSL">Kotak dengan sisi lebar yang sama</option><option value="SLN">Silinder</option></select></td></tr>');
                                                $(this).attr('terakhir', parseInt(nom) + 1);
                                                $("input.Rokok" + cls).autocomplete($("input.namaNapza").attr("url") + 'kos', {width: 244, selectFirst: false});
                                                $("#minCls" + cls).click(function() {
                                                    $('.' + cls).remove();
                                                });
                                                $("input.namaNapza" + cls).result(function(event, data, formatted) {
                                                    if (data) {
                                                        var golonganNapza = data[2].substring(2, 1);
                                                        $(this).val(data[1]);
                                                        $("#namaPemilikNIE" + cls).val(data[3]);
                                                        $("#bentukSediaan" + cls).val(data[9]);
                                                        if (data[13] !== "-" && data[13] !== "")
                                                            $("#merkDagang" + cls).val(data[13]);
                                                        else
                                                            $("#merkDagang" + cls).val("-");
                                                        $("#NIE" + cls).val(data[2]);
                                                        var jenis = data[12].split('-'), val = [];
                                                        for (var i = 0; i < jenis.length; i++)
                                                            val.push(jenis[i]);
                                                        val = "" + val;
                                                        $("#jenis_napza" + cls).val(val.replace(/,/g, ", "));
                                                        $("#mbbpomid" + cls).val(data[2]);
                                                        $("input.op").autocomplete($("input.op").attr("url") + $("#bbpomid" + cls).val(), {width: 244, selectFirst: false});
                                                    }
                                                });
                                                $('select, textarea, input:not(:image, submit, checkbox, radio)').poshytip({className: 'tip-twitter', showTimeout: 1, alignTo: 'target', alignX: 'right', alignY: 'center', offsetX: 5, allowTipHover: false, fade: false, slide: false});
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
                                                        $("#file_" + jenis + "").hide();
                                                        cekLampiran();
                                                        if (jenis !== "FILE_LAMPIRAN_IKLAN")
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
                                            $("#provkotAlamat").change(function() {
                                                var kunci = $(this).val();
                                                $.get('<?php echo site_url(); ?>/get/iklan_penandaan/set_provinsi/' + kunci, function(hasil) {
                                                    hasil = hasil.replace(' ', '');
                                                    if (hasil != "") {
                                                        $('#kabkotAlamat').html(hasil);
                                                    }
                                                });
                                            });
                                            $("#lnChoosed").keyup(function() {
                                                var val = $(this).val();
                                                var val2 = val.charAt(0).toUpperCase();
                                                val = val.slice(1);
                                                $(this).val(val2 + val);
                                            });
                                            $("#cmbRadio").change(function() {
                                                cmbRadio($(this));
                                            });
                                        });
</script>