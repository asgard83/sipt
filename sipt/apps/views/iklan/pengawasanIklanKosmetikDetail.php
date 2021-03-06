<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
error_reporting(E_ERROR);
?>
<link type="text/css" href="<?php echo base_url(); ?>css/iklanPenandaan.css" rel="stylesheet" media="screen"/>
<div id="judulpmnikl" class="judul"></div>
<div class="headersarana">PENGAWASAN IKLAN KOSMETIKA </div>
<?php
$bulan_iklan = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
$tahun_iklan = array(range(date("Y"), 2007));
$totalThn = array_sum(array_map("count", $tahun_iklan));
$UP = explode('^', $sess['URAIAN_PELANGGARAN']);
$tayangMedia = explode(" ", $sess['JAM_TAYANG']);
$hasilKesimpulanOpt = explode("^", $sess['TL_PUSAT']);
$jenisProduk = array("" => "", "SBY" => "Sediaan bayi", "SMD" => "Sediaan mandi", "SKB" => "Sediaan kebersihan badan", "SCK" => "Sediaan cukur", "SWW" => "Sediaan wangi-wangian", "SRB" => "Sediaan rambut", "SPR" => "Sediaan pewarna rambut", "SRM" => "Sediaan rias mata", "SRW" => "Sediaan rias wajah", "SPK" => "Sediaan perawatan kulit", "SSS" => "Sediaan mandi surya dan tabir surya", "SKK" => "Sediaan kuku", "SHM" => "Sediaan hygiene mulut");
$edisiUraian = explode("^", $sess['EDISI']);
$edisiMedia = explode(" ", $edisiUraian[0]);
?>
<div class="content">
    <form action="<?php echo $act; ?>" method="post" autocomplete="off" id="fpengawasanIklan_012">
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
                        </table>
                    </div>
                </div><!-- Akhir Pemeriksaan !-->
                <div style="height:5px;"></div>
                <div class="acco2"><div class="expand"><a title="expand/collapse" href="#" style="display: block;">INFORMASI KOSMETIKA - IKLAN</a></div>
                    <div class="collapse">
                        <div class="accCntnt">
                            <table>
                                <tr>
                                    <td>
                                        <table>
                                            <tbody id="tb_kosmetika">
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
                                                        <td width="150">Nama Kosmetika</td>
                                                        <td>
                                                            <input type="text" size="40" name="PRODUK[NAMA][]" class="namaKosmetika" id="namaKosmetika" url="<?php echo site_url(); ?>/autocompletes/autocomplete/produk_reg_2/" title="Nama Kosmetika" rel="required" value="<?php echo $sess2[$i]['NAMA_PRODUK']; ?>"/>&nbsp;
                                                            <?php
                                                            if ($i == 0) {
                                                                ?>
                                                                <a href="javascript:void(0)" class="addnomor" periksa="urut" terakhir="<?php echo $jmldata; ?>"><img src="<?php echo base_url(); ?>images/add.png" align="absmiddle" style="border:none" title="Tambah Kosmetika" /></a>
                                                                <?php
                                                            } else {
                                                                ?>
                                                                <a href="javascript:void(0)" class="min" onclick="$('.urut<?php echo $i; ?>').remove();"><img src="<?php echo base_url(); ?>images/cancel.png" align="absmiddle" style="border:none" title="Hapus Kosmetik" /></a>
                                                                <?php
                                                            }
                                                            ?></td>
                                                    </tr>
                                                    <tr class="urut<?php echo $i; ?>">
                                                        <td width="150">Merk Dagang</td>
                                                        <td><input type="text" size="40" name="PRODUK[MERKDAGANG][]" id="merkDagang" title="Merk Dagang" value="<?php echo $sess2[$i]['MERK_PRODUK']; ?>" />
                                                        </td>
                                                    </tr>
                                                    <tr class="urut<?php echo $i; ?>">
                                                        <td width="150">Nomor Izin Edar</td>
                                                        <td><input type="text" size="40" name="PRODUK[NOMORIZINEDAR][]" id="NIE" title="NIE" value="<?php echo $sess2[$i]['NOMOR_IZIN_EDAR']; ?>" /></td>
                                                    </tr>
                                                    <tr class="urut<?php echo $i; ?>">
                                                        <td width="150">Nama Pemilik Izin Edar</td>
                                                        <td><input type="text" size="40" name="PRODUK[NAMAPEMILIKIZINEDAR][]" id="namaPemilikNIE" title="Pemilik Izin Edar" value="<?php echo $sess2[$i]['NAMA_PEMILIK_IZIN_EDAR']; ?>" />
                                                        </td>
                                                    </tr>
                                                    <tr class="urut<?php echo $i; ?>">
                                                        <td width="150">Kategori Produk</td>
                                                        <td><textarea style="width: 90%" name="PRODUK[JENIS][]" id="jenis_kosmetika" title="Golongan Obat" rel="required"><?php echo $sess2[$i]['JENIS_PRODUK']; ?></textarea>
                                                        </td>
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
                            <table class="form_tabel_detail">
                                <tr>
                                    <td style="width: 2%;"></td>
                                    <td style="width: 50%;"></td>
                                    <td style="width: 13%;"></td>
                                    <td style="width: 35%; font-size: 14px; padding-left: 250px; padding-right: 250px; padding-bottom: 5px; padding-top: 5px;"></td>
                                </tr>
                                <tr>
                                    <td class="td_left_checklist"></td>
                                    <td class="td_left_header_checklist" style="vertical-align: top;">Jenis Iklan</td>
                                    <td></td>
                                    <td colspan="2" class="td_left"><select name="IKLAN[JENISIKLAN]" onChange="mediaIklan2();" id="iklan_media" class="sjenis sl_iklan_media" title="Jenis Iklan" rel="required">
                                            <option value=""></option>
                                            <option value="Cetak">Cetak</option>
                                            <option value="Elektronik">Elektronik</option>
                                            <option value="Luar Ruang">Luar Ruang</option></select></td>
                                </tr>
                                <tr class="iklanObatReq iorMedia">
                                    <td class="td_left_checklist"></td>
                                    <td class="td_left_header_checklist" style="vertical-align: top;">Media</td>
                                    <td></td>
                                    <td colspan="2" class="td_left elektronikChoosed" hidden>
                                        <select class="stext mediaIklanEdit" id="eChoosed" onChange="mediaIklan(this);" name="IKLAN[MEDIA][]" title="Media Iklan">
                                            <option value=""></option>
                                            <option value="TV">TV</option>
                                            <option value="Radio">Radio</option>
                                            <option value="Internet">Internet</option>
                                            <option value="Iklan Baris">Iklan Baris</option>
                                            <option value="Bioskop">Bioskop</option>
                                            <option value="Megatron">Megatron</option>
                                            <option value="Lainnya">Media Teknologi Informasi Lainnya</option></select></td>
                                    <td colspan="2" class="td_left lRChoosed" hidden>
                                        <select class="stext mediaIklanEdit" id="lrChoosed" onChange="mediaIklan(this);" name="IKLAN[MEDIA][]" title="Media Iklan">
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
                                        <select class="stext mediaIklanEdit" id="cChoosed" name="IKLAN[MEDIA][]" onChange="mediaIklan(this);" title="Media Iklan">
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
                                    <td style="width: 10%;" colspan="2" class="td_left_checklist"><input type="text" id="namaMediaIklan" class="stext namaMedia" title="Nama Media" url="<?php echo site_url(); ?>/autocompletes/autocomplete/nama_media/" value="<?php echo $sess['NAMA_MEDIA']; ?>" /><input type="hidden" id="idMediaIklan"  value="<?php echo $sess['ID_MEDIA']; ?>" /></td>
                                </tr>
                                <tr class="td_left promoBased" hidden>
                                    <td class="td_left_checklist"></td>
                                    <td class="td_left_header_checklist" style="vertical-align: top;">Judul Kegiatan</td>
                                    <td></td>
                                    <td style="width: 10%;" colspan="2" class="td_left_checklist"><input type="text" class="stext" id="judulKegiatan" name="IKLAN[JUDUL]" title="Judul Kegiatan" value="<?php echo $sess['JUDUL_KEGIATAN']; ?>" /></td>
                                </tr>
                                <tr id="tglTerbit">
                                    <td class="td_left_checklist" style="vertical-align: top;"></td>
                                    <td class="td_left_header_checklist" style="vertical-align: top;">Tanggal Penerbitan</td>
                                    <td></td>
                                    <td style="width: 10%;" class="td_left" colspan="2"><input type="text" class="sdate" name="IKLAN[TANGGAL]" id="tglTugas" title="Tanggal Penerbitan Iklan" onchange="comp('C')" value="<?php echo $sess['TANGGAL']; ?>"/>&nbsp;&nbsp;
                                </tr>
                                <tr id="edisiTime" hidden>
                                    <td class="td_left_checklist" style="vertical-align: top;"></td>
                                    <td class="td_left_header_checklist" style="vertical-align: top;">Edisi Media Iklan</td>
                                    <td></td>
                                    <td style="width: 10%;" class="td_left" colspan="2">
                                        <span><select class="edisiTayang edisiCetak" title="Tahun" name="IKLAN[EDISI1]" style="height: 21px"><option value=""></option><?php
                                                for ($i = 0; $i < $totalThn; $i++) {
                                                    ?><option value="<?php echo $tahun_iklan[0][$i]; ?>"><?php echo $tahun_iklan[0][$i]; ?></option><?php } ?></select>&nbsp;&nbsp;<select class="edisiTayang edisiCetak" title="Bulan" name="IKLAN[EDISI2]" style="height: 21px"><option value=""></option><?php
                                                for ($i = 0; $i < 12; $i++) {
                                                    ?><option value="<?php echo $bulan_iklan[$i]; ?>"><?php echo $bulan_iklan[$i]; ?></option><?php } ?></select></span>&nbsp;&nbsp;
                                        <input type="text" name="IKLAN[EDISI3]" title="Edisi" class="stext edisiTayang edisiCetak" value="<?php echo $edisiUraian[1] ?>"/>
                                    </td>
                                </tr>
                                <tr id="tayangTime" hidden>
                                    <td class="td_left_checklist" style="vertical-align: top;"></td>
                                    <td class="td_left_header_checklist" style="vertical-align: top;">Jam Tayang Media Iklan</td>
                                    <td></td>
                                    <td style="width: 10%;" class="td_left" colspan="2">
                                        <span><select class="edisiTayang edisiTV" title="Jam" name="IKLAN[TAYANG1]"><option value=""></option><?php
                                                for ($i = 1; $i <= 24; $i++) {
                                                    ?><option value="<?php echo $i; ?>"><?php echo $i; ?></option><?php } ?></select> : <select class="edisiTayang edisiTV" title="Jam" name="IKLAN[TAYANG2]"><option value=""></option><?php
                                                for ($i = 1; $i < 60; $i++) {
                                                    ?><option value="<?php echo $i; ?>"><?php echo $i; ?></option><?php } ?></select>&nbsp;&nbsp;&nbsp;hh : mm</span>
                                    </td>
                                </tr>
                                <tr class="cetakTertentu">
                                    <td class="td_left_checklist"></td>
                                    <td class="td_left_header_checklist" style="vertical-align: top;">Nama Lokasi Pengambilan Iklan</td>
                                    <td></td>
                                    <td style="width: 10%;" class="td_left" colspan="2"><input name="IKLAN[LOKASI]" type="text" class="stext" id="namaLokasi" title="Nama Lokasi" value="<?php echo $sess['NAMA_LOKASI_IKLAN']; ?>"/>
                                </tr>
                                <tr class="cetakTertentu">
                                    <td class="td_left_checklist"></td>
                                    <td class="td_left_header_checklist" style="vertical-align: top;">Alamat Lokasi Pengawasan Iklan</td>
                                    <td></td>
                                    <td style="width: 10%;" class="td_left" colspan="2"><textarea class="stext cetakTertentu" id="alamatLokasi" title="Alamat Lokasi Pengambilan Iklan" name="IKLAN[ALAMAT]"><?php echo $sess['ALAMAT_LOKASI_IKLAN']; ?></textarea></td>
                                </tr>
                                <?php if (in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')) || $this->newsession->userdata("SESS_BBPOM_ID") == "50") { ?>
                                    <tr class="ifElektronik">
                                        <td class="td_left_checklist"></td>
                                        <td class="td_left_header_checklist" style="vertical-align: top;">Provinsi</td>
                                        <td></td>
                                        <td style="width: 10%;" colspan="2" class="td_left_checklist"><?php echo form_dropdown('KOTA', $provinsi, $provinsiVal, 'style="width:158px" id="provkotAlamat" class="stext" rel="required" title="Nama Provinsi Pengambilan Iklan"'); ?></td>
                                    </tr>
                                <?php } ?>
                                <tr class="ifElektronik">
                                    <td class="td_left_checklist"></td>
                                    <td class="td_left_header_checklist" style="vertical-align: top;">Kota / Kabupaten</td>
                                    <td></td>
                                    <td style="width: 10%;" colspan="2" class="td_left_checklist"><?php echo form_dropdown('IKLAN[KOTA]', $kabupaten, $kabupatenVal, 'style="width:158px" id="kabkotAlamat" class="stext" title="Nama Kota Pengambilan Iklan"'); ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div style="height:5px;" id="expand2b"></div>

                    <!--4-->
                    <div class="expand" id="expand4"><a title="expand/collapse" href="#" style="display: block;">NARASI / KLAIM IKLAN</a></div>
                    <div class="collapse">
                        <div class="accCntnt" id="expand4a">
                            <table class="form_tabel_detail">
                                <tr>
                                    <td style="width: 2%;"></td>
                                    <td style="width: 50%;"></td>
                                    <td style="width: 13%;"></td>
                                    <td style="width: 35%; font-size: 14px; padding-left: 250px; padding-right: 250px; padding-bottom: 5px; padding-top: 5px;"></td>
                                </tr>
                                <tr>
                                    <td class="td_left_checklist" style="vertical-align: top;"></td>
                                    <td class="td_left_header_checklist" style="vertical-align: top;">Narasi / Klaim Iklan</td>
                                    <td></td>
                                    <td style="width: 10%;" colspan="2" class="td_left_checklist"><textarea style="width: 98%; height: 75px;" class="stext" title="Narasi / Klaim Iklan" name="IKLANKOS[NARASI]" rel="required"><?php echo $sess['NARASI']; ?></textarea></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div style="height:5px;"></div>

                    <!--7-->
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
                                <?php if (!in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) { ?>
                                    <tr>
                                        <td class="td_left_checklist"></td>
                                        <td class="td_left_header_checklist"><b>Hasil Penilaian</b></td>
                                        <td></td>
                                        <td style="width: 10%;" class="td_left" colspan="6">
                                            <select name="IKLAN[HASIL]" class="stext" title="Hasil Penilaian" id="kesimpulanHasilPenilaian" rel="required" onchange="kesimpulanHasilPenilaianFunct(this);"><option value=""></option><option value="MK" <?php if ($sess['HASIL'] == 'MK') echo 'selected'; ?>>Memenuhi Ketentuan</option><option value="TMK" <?php if ($sess['HASIL'] == 'TMK') echo 'selected'; ?>>Tidak Memenuhi Ketentuan</option></select>
                                            <input type="hidden" id="kesimpulanHasilPenilaianVal" name="IKLAN[HASIL]" value="<?php
                                            if (trim($sess['HASIL']) == "")
                                                echo "TMK";
                                            else
                                                echo $sess['HASIL'];
                                            ?>" />
                                        </td>
                                    </tr>
                                    <?php
                                }
                                if (in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) {
                                    if ((!$sess['HASIL_PUSAT'] && in_array('2', $this->newsession->userdata('SESS_KODE_ROLE'))) || $editTL == 'YES') {
                                        if (trim($sess['HASIL']) != "" && $sess['HASIL'] != NULL) {
                                            ?>
                                            <tr>
                                                <td class="td_left_checklist"></td>
                                                <td class="td_left_header_checklist"><b>Hasil Penilaian Balai</b></td>
                                                <td></td>
                                                <td style="width: 10%;" class="td_left" colspan="6">
                                                    <?php
                                                    if (trim($sess['HASIL']) == "")
                                                        echo "TMK";
                                                    else
                                                        echo $sess['HASIL'];
                                                    ?>"
                                                    <input type="hidden" id="kesimpulanHasilPenilaianVal" name="IKLAN[HASIL]" value="<?php
                                                    if (trim($sess['HASIL']) == "")
                                                        echo "TMK";
                                                    else
                                                        echo $sess['HASIL'];
                                                    ?>" />
                                                </td>
                                            </tr>
                                        <?php } ?>
                                        <tr><td class="td_left_checklist"></td><td class="td_left">Hasil Penilaian</td><td></td><td class="td_right"><select class="stext" id="verifikasiPusat" name="<?php echo 'IKLAN[HASIL_PUSAT]' ?>" rel="required" title="MK/TMK" onchange="kesimpulanHasilPenilaianFunct(this);"><option></option><option value="MK" <?php if ($sess['HASIL_PUSAT'] == 'MK') echo 'Selected' ?>>Memenuhi Ketentuan</option><option value="TMK"  <?php if ($sess['HASIL_PUSAT'] == 'TMK') echo 'Selected' ?>>Tidak Memenuhi Ketentuan</option></select></td></tr>
                                        <tr class="vTMK" hidden><td class="td_left_checklist"></td><td class="td_left"style="background-color: white;">Tindak Lanjut</td><td></td><td class="td_right" style="background-color: white;"><?php echo form_dropdown('IKLAN[TL_PUSAT]', $cb_tindakan, $sess['TL_PUSAT'], 'class="stext vTMK" id="vTMKSub" title="Tindak Lanjut Pusat"'); ?></td></tr>
                                        <?php if (trim($sess['HASIL']) != "" && $sess['HASIL'] != NULL) { ?>
                                            <tr class="vJustifikasi" hidden><td class="td_left_checklist"></td><td class="td_left" style="background-color: white;">Justifikasi</td><td></td><td class="td_right" style="background-color: white;"><textarea name="JUSTIFIKASI" title="Justifikasi Pusat" class="stext chkJustifikasi" id="XXX" style="height: 140px"><?php echo $sess['JUSTIFIKASI_PUSAT']; ?></textarea></td></tr> <?php
                                        }
                                    } else {
                                        if ($sess['HASIL_PUSAT'] == "TMK") {
                                            ?>
                                            <tr><td class="td_left">Verifikasi Pusat</td><td class="td_right"><b><i><?php
                                                            echo $sess['HASIL_PUSAT'];
                                                            ?></i></b></td></tr>
                                            <?php if ($sess['JUSTIFIKASI_PUSAT'] != NULL || $sess['JUSTIFIKASI_PUSAT'] != "") { ?>
                                                <tr><td class="td_left">Justifikasi Pusat</td><td class="td_right"><?php echo $sess['JUSTIFIKASI_PUSAT']; ?></td></tr>
                                                <?php
                                            }
                                        } else {
                                            ?>
                                            <tr><td class="td_left">Verifikasi Pusat</td><td class="td_right"><b><i><?php
                                                            echo $sess['HASIL_PUSAT'];
                                                            ?></i></b></td></tr>
                                            <?php if ($sess['JUSTIFIKASI_PUSAT'] != NULL || $sess['JUSTIFIKASI_PUSAT'] != "") { ?>
                                                <tr><td class="td_left">Justifikasi Pusat</td><td class="td_right"><?php echo $sess['JUSTIFIKASI_PUSAT']; ?></td></tr>
                                                <?php
                                            }
                                        }
                                    }
                                }
                                ?>
                            </table>
                        </div>
                    </div>
                    <div class="uraianPelanggaranDiv" style="height:5px;"></div>

                    <!--5-->
                    <div class="expand uraianPelanggaranDiv" id="expand5"><a title="expand/collapse" href="#" style="display: block;">URAIAN PELANGGARAN</a></div>
                    <div class="collapse uraianPelanggaranDiv">
                        <div class="accCntnt uraianPelanggaranDiv">
                            <table class="form_tabel_detail">
                                <tr class="hashStar">
                                    <td style="width: 2%;"></td>
                                    <td style="width: 50%;"></td>
                                    <td style="width: 13%;"></td>
                                    <td style="width: 35%; font-size: 14px; padding-left: 250px; padding-right: 250px; padding-bottom: 5px; padding-top: 5px;"></td>
                                </tr>
                                <tr class="hashStar">
                                    <td class="td_left_checklist"  style="vertical-align: top;"></td>
                                    <td class="td_left_header_checklist" style="vertical-align: top;"><input class="uraianPelanggaran" type="checkbox" name="uraian2" style="vertical-align: top; margin-right: 10px" title="Tidak Obyektif" />&nbsp;Tidak memiliki izin edar</td>
                                    <td></td>
                                    <td style="width: 10%;" colspan="6"><span class="uraian2 uraianPelanggaranDivDet" hidden="true"><textarea class="uPelanggaran uraian2" title="Uraian Pelanggaran" style="width: 98%; height: 75px;" name="UPELANGGARAN[]"><?php echo $UP[0]; ?></textarea></span></td>
                                </tr>
                                <tr class="hashStar">
                                    <td class="td_left_checklist"></td>
                                    <td class="td_left_header_checklist" style="vertical-align: top;"><input class="uraianPelanggaran" type="checkbox" name="uraian3" style="vertical-align: top; margin-right: 10px" title="Uraian Pelanggaran" />&nbsp;Seolah-olah sebagai obat/mengobati/mempengaruhi fungsi fisiologis tubuh</td>
                                    <td></td>
                                    <td style="width: 10%;" colspan="6"><span class="uraian3 uraianPelanggaranDivDet" hidden="true"><textarea class="uPelanggaran uraian3" title="Uraian Pelanggaran" style="width: 98%; height: 75px;" name="UPELANGGARAN[]"><?php echo $UP[1]; ?></textarea></span></td>
                                </tr>
                                <tr class="hashStar">
                                    <td class="td_left_checklist"></td>
                                    <td class="td_left_header_checklist" style="vertical-align: top;"><input class="uraianPelanggaran" type="checkbox" name="uraian4" style="vertical-align: top; margin-right: 10px" title="Uraian Pelanggaran" />&nbsp;Peragaan tenaga kesehatan</td>
                                    <td></td>
                                    <td style="width: 10%;" colspan="6"><span class="uraian4 uraianPelanggaranDivDet" hidden="true"><textarea class="uPelanggaran uraian4" title="Uraian Pelanggaran" style="width: 98%; height: 75px;" name="UPELANGGARAN[]"><?php echo $UP[2]; ?></textarea></span></td>
                                </tr>
                                <tr class="hashStar">
                                    <td class="td_left_checklist"></td>
                                    <td class="td_left_header_checklist" style="vertical-align: top;"><input class="uraianPelanggaran" type="checkbox" name="uraian5" style="vertical-align: top; margin-right: 10px" title="Uraian Pelanggaran" />&nbsp;Rekomendasi laboratorium / tenaga kesehatan</td>
                                    <td></td>
                                    <td style="width: 10%;" colspan="6"><span class="uraian5 uraianPelanggaranDivDet" hidden="true"><textarea class="uPelanggaran uraian5" title="Uraian Pelanggaran" style="width: 98%; height: 75px;" name="UPELANGGARAN[]"><?php echo $UP[3]; ?></textarea></span></td>
                                </tr>
                                <tr class="hashStar">
                                    <td class="td_left_checklist"></td>
                                    <td class="td_left_header_checklist" style="vertical-align: top;"><input class="uraianPelanggaran" type="checkbox" name="uraian6" style="vertical-align: top; margin-right: 10px" title="Uraian Pelanggaran" />&nbsp;Tidak etis / tidak sesuai norma susila</td>
                                    <td></td>
                                    <td style="width: 10%;" colspan="6"><span class="uraian6 uraianPelanggaranDivDet" hidden="true"><textarea class="uPelanggaran uraian6" title="Uraian Pelanggaran" style="width: 98%; height: 75px;" name="UPELANGGARAN[]"><?php echo $UP[4]; ?></textarea></span></td>
                                </tr>
                                <tr class="hashStar">
                                    <td class="td_left_checklist"></td>
                                    <td class="td_left_header_checklist" style="vertical-align: top;"><input class="uraianPelanggaran" type="checkbox" name="uraian7" style="vertical-align: top; margin-right: 10px" title="Uraian Pelanggaran" />&nbsp;Berlebihan / menyesatkan</td>
                                    <td></td>
                                    <td style="width: 10%;" colspan="6"><span class="uraian7 uraianPelanggaranDivDet" hidden="true"><textarea class="uPelanggaran uraian7" title="Uraian Pelanggaran" style="width: 98%; height: 75px;" name="UPELANGGARAN[]"><?php echo $UP[5]; ?></textarea></span></td>
                                </tr>
                                <tr class="hashStar">
                                    <td class="td_left_checklist"></td>
                                    <td class="td_left_header_checklist" style="vertical-align: top;"><input class="uraianPelanggaran" type="checkbox" name="uraian8" style="vertical-align: top; margin-right: 10px" title="Uraian Pelanggaran" />&nbsp;Tidak mencantumkan spot (untuk iklan yang wajib mencantumkan spot iklan)</td>
                                    <td></td>
                                    <td style="width: 10%;" colspan="6"><span class="uraian8 uraianPelanggaranDivDet" hidden="true"><textarea class="uPelanggaran uraian8" title="Uraian Pelanggaran" style="width: 98%; height: 75px;" name="UPELANGGARAN[]"><?php echo $UP[6]; ?></textarea></span></td>
                                </tr>
                                <tr class="hashStar">
                                    <td class="td_left_checklist"></td>
                                    <td class="td_left_header_checklist" style="vertical-align: top;"><input class="uraianPelanggaran" type="checkbox" name="uraian9" style="vertical-align: top; margin-right: 10px" title="Uraian Pelanggaran" />&nbsp;Iklan yang mempengaruhi fungsi fisiologis dan atau metabolisme tubuh</td>
                                    <td></td>
                                    <td style="width: 10%;" colspan="6"><span class="uraian9 uraianPelanggaranDivDet" hidden="true"><textarea class="uPelanggaran uraian9" title="Uraian Pelanggaran" style="width: 98%; height: 75px;" name="UPELANGGARAN[]"><?php echo $UP[7]; ?></textarea></span></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div style="height:5px;" id="expand6b"></div>

                    <!--8-->
                    <div class="expand"><a title="expand/collapse" href="#" style="display: block;">LAMPIRAN</a></div>
                    <div class="collapse">
                        <div class="accCntnt">
                            <table class="form_tabel_detail">
                                <tr>
                                    <td class="td_left_checklist" colspan="5" style="margin-right: 200px">
                                        <?php
                                        if (array_key_exists('FILE_IKLAN', $sess) && trim($sess['FILE_IKLAN']) != "") {
                                            ?><input type="hidden" name="IKLAN_KOS[FILE_IKLAN]" value="<?php echo $sess['FILE_IKLAN']; ?>">
                                            <span id="file_FILE_IKLAN"><a href="<?php echo base_url(); ?>files/<?php echo 'iklan_012'; ?>/<?php echo $sess['FILE_IKLAN']; ?>" target="_blank">File Lampiran</a>&nbsp;&bull;&nbsp;<a href="#" class="del_upload" url="<?php echo site_url(); ?>/utility/uploads/del_upload_s/<?php echo 'iklan_012'; ?>/<?php echo $sess['FILE_IKLAN']; ?>" jns="FILE_IKLAN">Edit atau Hapus File ?</a></span>
                                            <span class="upload_FILE_IKLAN" hidden><input type="file" class="upload_FILE_IKLAN" jenis="FILE_IKLAN" allowed="jpg-jpeg-pdf-doc-docx-rar" url="<?php echo site_url(); ?>/utility/uploads/get_upload_s/<?php echo 'iklan_012'; ?>" id="fileToUpload_FILE_IKLAN" name="userfile" onchange="do_upload($(this));
                                                return false;" title="Lampiran" value="<?php echo $sess['FILE_IKLAN']; ?>"/>
                                                &nbsp;Tipe File : *.jpg .jpeg .pdf .doc .docx .rar</span>
                                            <?php
                                        } else {
                                            ?>
                                            <span class="upload_FILE_IKLAN"><input type="file" class="upload" jenis="FILE_IKLAN" allowed="jpg-jpeg-pdf-doc-docx-rar" url="<?php echo site_url(); ?>/utility/uploads/get_upload_s/<?php echo 'iklan_012'; ?>" id="fileToUpload_FILE_IKLAN" name="userfile" onchange="do_upload($(this));
                                                return false;" title="Lampiran Berita Acara" rel="required" />
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

                <div style="padding:10px;"></div><div><a href="javascript:void(0)" id="btnSave" class="button <?php echo $icon; ?>" onclick="fpost('#fpengawasanIklan_012', '', '');">
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
                                            $("#eChoosed").val('');
                                            $("#lrChoosed").val('');
                                            $("#cChoosed").val('');
                                            clear();
                                            showHide();
                                            cekLampiran();
                                        }
                                        function cekLampiran() {
//           var val = $("#iklan_media").val();
//           if (val == "Elektronik")
//            $('.upload').attr('rel', '');
//           else
//            $('.upload').attr('rel', 'required');
<?php if (!in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) { ?>
                                                var kesimpulan = $('#kesimpulanHasilPenilaianVal').val(), jenis = $('#iklan_media').val();
                                                if ((kesimpulan === 'TMK' && jenis === 'Cetak') || kesimpulan === 'TMK' && jenis === 'Luar Ruang') {
                                                    $('.upload').attr('rel', 'required');
                                                } else {
                                                    $('.upload').attr('rel', '');
                                                    $(".upload").css("background-color", "#FFF");
                                                    $(".upload").css("border", "");
                                                }
<?php } else { ?>
                                                var kesimpulan = $('#verifikasiPusat').val(), jenis = $('#iklan_media').val();
                                                if ((kesimpulan === 'TMK' && jenis === 'Cetak') || kesimpulan === 'TMK' && jenis === 'Luar Ruang') {
                                                    $('.upload').attr('rel', 'required');
                                                } else {
                                                    $('.upload').attr('rel', '');
                                                    $(".upload").css("background-color", "#FFF");
                                                    $(".upload").css("border", "");
                                                }
<?php } ?>
                                        }
                                        function showHide2(X) {
                                            var param = "";
                                            var media1 = ["TV", "Radio", "Iklan Baris", "Bioskop", "Megatron", "Lainnya"];
                                            var media2 = ["Majalah", "Tabloid", "Buletin", "Halaman Kuning"];
//                      var media3 = ["Majalah", "Tabloid", "Buletin", "Surat Kabar", "TV", "Radio", "Internet", "Iklan Baris"];
                                            var media3 = ["Majalah", "Tabloid", "Surat Kabar", "TV", "Radio", "Internet", "Buletin", "Iklan Baris"];
                                            var mediaifTertentu = ["Majalah", "Tabloid", "Buletin", "Surat Kabar"];
                                            var luarRuang = ["Billboard", "Neon Box", "Papan Nama", "Spanduk", "Balon Udara", "Transit Ad", "Hanging Mobil", "Iklan Dinding", "Gimmick", "Backdrop", "Baliho"];
                                            var elektronik = ["TV", "Radio", "Iklan Baris", "Bioskop", "Lainnya", "Internet"];
                                            if (typeof X === "object")
                                                param = $(X).val();
                                            else
                                                param = X;
                                            if ($.inArray(param, media1) > -1) {
                                                $("#tayangTime").show("");
                                                $("#edisiTime").hide("");
                                                $(".edisiCetak").attr("rel", "");
                                                $(".edisiTV").attr("rel", "required");
                                            } else if ($.inArray(param, media2) > -1) {
                                                $("#tayangTime").hide("");
                                                $("#edisiTime").show("");
                                                $(".edisiCetak").attr("rel", "required");
                                                $(".edisiTV").attr("rel", "");
                                            } else {
                                                $("#tayangTime").hide("");
                                                $("#edisiTime").hide("");
                                                $(".edisiCetak").attr("rel", "");
                                                $(".edisiTV").attr("rel", "");
                                            }
                                            if ($.inArray(param, media3) > -1) {
                                                $("#namaMedia").show("");
                                                $(".namaMedia").attr("rel", "required");
                                            } else {
                                                $("#namaMedia").hide("");
                                                $(".namaMedia").attr("rel", " ");
                                            }
                                            if ($.inArray(param, mediaifTertentu) < 0) {
                                                $("#tglTerbit").hide();
                                                $("#tglTugas").attr("rel", "");
                                            } else {
                                                $("#tglTerbit").show();
                                                $("#tglTugas").attr("rel", "required");
                                            }
                                            if (param === "Megatron") {
                                                $("#kabkotAlamat").attr("rel", "required");
                                                $("#provkotAlamat").attr("rel", "required");
                                                $(".cetakTertentu").attr("rel", "required");
                                            }
                                            else if ($.inArray(param, mediaifTertentu) < 0 && $.inArray(param, luarRuang) < 0 && $.inArray(param, elektronik) < 0) {
                                                $("#kabkotAlamat").attr("rel", "required");
                                                $("#provkotAlamat").attr("rel", "required");
                                                $(".cetakTertentu").attr("rel", "required");
                                            }
                                            else if ($.inArray(param, luarRuang) > -1) {
                                                $("#kabkotAlamat").attr("rel", "required");
                                                $("#provkotAlamat").attr("rel", "required");
                                                $(".cetakTertentu").attr("rel", "required");
                                            } else {
                                                $("#provkotAlamat").attr("rel", "");
                                                $("#kabkotAlamat").attr("rel", "");
                                                $(".cetakTertentu").attr("rel", "");
                                                $(".cetakTertentu").css('background-color', '#FFFFFF');
                                                $("#provkotAlamat").css('background-color', '#FFFFFF');
                                                $("#provkotAlamat").css('border', '1px solid #dcdcdc');
                                                $("#kabkotAlamat").css('background-color', '#FFFFFF');
                                                $("#kabkotAlamat").css('border', '1px solid #dcdcdc');
                                            }
                                            if (param === "Internet") {
                                                document.getElementById("namaMedia1").innerHTML = "Alamat Situs";
                                            } else {
                                                document.getElementById("namaMedia1").innerHTML = "Nama Media";
                                            }
//    $("#namaMediaIklan").unautocomplete();
                                            $("#namaMediaIklan").autocomplete($("#namaMediaIklan").attr("url") + param, {width: 244, selectFirst: false});
                                            $(".ac_results").remove();
                                            $("#namaMediaIklan").attr("name", "IKLAN[NAMA]");
                                        }
                                        function mediaIklan(X) {
                                            clear();
                                            showHide2(X);
                                        }
                                        function clear() {
                                            $("#namaMediaIklan").val("");
                                            $("#idMediaIklan").val("");
                                            $("#idMediaIklan").attr("name", "");
                                            $("#judulKegiatan").val("");
                                            $("#tglTugas").val("");
                                            $(".edisiTayang").val("");
                                            $("#namaLokasi").val("");
                                            $("#alamatLokasi").val("");
                                        }
                                        function showHide() {
                                            var kelompokIklan = $("#iklan_kelompok").val();
                                            var golonganOT = $('#golonganOT').val();
                                            var jenisIklan = $("#iklan_media").val();
                                            if (jenisIklan === "Cetak") {
                                                $(".elektronikChoosed").hide();
                                                $(".lRChoosed").hide();
                                                $(".cetakChoosed").fadeIn("slow");
                                                $("#cChoosed").attr("rel", "required");
                                                $("#lrChoosed").attr("rel", " ");
                                                $("#eChoosed").attr("rel", " ");
                                            }
                                            else if (jenisIklan === "Elektronik") {
                                                $(".lRChoosed").hide();
                                                $(".cetakChoosed").hide();
                                                $('#expand4').fadeIn("slow");
                                                $('#expand4a').fadeIn("slow");
                                                $('#expand4b').fadeIn("slow");
                                                $('#deskripsiIklan').attr("rel", "required");
                                                $(".elektronikChoosed").fadeIn("slow");
                                                $("#cChoosed").attr("rel", " ");
                                                $("#lrChoosed").attr("rel", " ");
                                                $("#eChoosed").attr("rel", "required");
                                            }
                                            else if (jenisIklan === "Luar Ruang") {
                                                $(".elektronikChoosed").hide();
                                                $(".cetakChoosed").hide();
                                                $('#expand4').fadeIn("slow");
                                                $('#expand4a').fadeIn("slow");
                                                $('#expand4b').fadeIn("slow");
                                                $(".lRChoosed").show();
                                                $("#cChoosed").attr("rel", " ");
                                                $("#lrChoosed").attr("rel", "required");
                                                $("#eChoosed").attr("rel", " ");
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
                                                                $(".file_" + arrdata[2] + "").html("<b>1 File telah dilampirkan. </b>&nbsp;<a href=\"<?php echo base_url(); ?>files/" + arrdata[3] + "/" + arrdata[0] + "\" target=\"_blank\">Tampilkan File</a>&nbsp;&bull;&nbsp;<a href=\"#\" class=\"del_upload\" url=\"<?php echo site_url(); ?>/utility/uploads/del_upload_s/" + arrdata[3] + "/" + arrdata[0] + "\" jns=" + arrdata[2] + ">Edit atau Hapus File ?</a><input type=\"hidden\" name=\"IKLAN_KOS[" + arrdata[2] + "]\" value=" + arrdata[0] + ">");
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
                                            var X = "input:checkbox[name='" + XXX + "']";
                                            if ($(X).is(":checked")) {
                                                $('.' + XXX).fadeIn("slow");
                                                $('.' + XXX).attr('hidden', false);
                                                $('.' + XXX).attr('rel', 'required');
                                            } else {
                                                $('.' + XXX).fadeOut("slow");
                                                $('.' + XXX).val("");
                                                $('.' + XXX).attr('hidden', true);
                                                $('.' + XXX).attr('rel', ' ');
                                            }
                                            verifikasiPusat($("#verifikasiPusat"));
                                        }
                                        function checkList(obj) {
                                            var XXX = obj.attr("name"), xxx = obj.val(), X = "input:radio[name='" + XXX + "']", XX = xxx.split('_'), cls = obj.attr("class");
                                            if ($(X).is(":checked")) {
                                                uraianTidakLengkap();
                                                if (cls === 'infoTambahan') {
                                                    uraianPenilaian1();
                                                }
                                            }
                                        }
                                        function verifikasiPusat(X) {
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
                                        function showHideUraian(id) {
                                            var hasil = $("#" + id).val();
                                            if (hasil == "MK") {
                                                $(".uraianPelanggaranDiv").hide("slow");
                                                $(".uraianPelanggaranDivDet").hide("");
                                                $(".uPelanggaran").val("");
                                                $(".uPelanggaran").attr("rel", "");
                                                $(".uraianPelanggaran").attr("checked", false);
                                                $(".vTMK").hide();
                                                $(".vTMKSub").attr("rel", "");
                                            }
                                            else {
                                                $(".uraianPelanggaranDiv").show("slow");
                                                $(".vTMK").show();
                                                $(".vTMKSub").attr("rel", "required");
                                            }
                                        }
                                        function kesimpulanHasilPenilaianFunct(obj) {
<?php if (!in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) { ?>
                                                $('#kesimpulanHasilPenilaianVal').val($(obj).val());
                                                showHideUraian('kesimpulanHasilPenilaianVal');
<?php } else { ?>
                                                $('#verifikasiPusat').val($(obj).val());
                                                showHideUraian('verifikasiPusat');
<?php } ?>
                                            cekLampiran();
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
                                                $(".mediaIklanEdit option[value='<?php echo $sess["MEDIA"]; ?>']").attr("selected", "selected");
                                                $("[name='IKLAN[EDISI1]'] option[value='<?php echo $edisiMedia[0]; ?>']").attr("selected", "selected");
                                                $("[name='IKLAN[EDISI2]'] option[value='<?php echo $edisiMedia[1]; ?>']").attr("selected", "selected");
                                                $("[name='IKLAN[TAYANG1]'] option[value='<?php echo $tayangMedia[0]; ?>']").attr("selected", "selected");
                                                $("[name='IKLAN[TAYANG2]'] option[value='<?php echo $tayangMedia[1]; ?>']").attr("selected", "selected");
                                                if ("<?php echo trim($UP[0]); ?>" !== "") {
                                                    $("input:checkbox[name='uraian2']").attr('checked', 'checked');
                                                    checkListTxt('uraian2');
                                                }
                                                if ("<?php echo trim($UP[1]); ?>" !== "") {
                                                    $("input:checkbox[name='uraian3']").attr('checked', 'checked');
                                                    checkListTxt('uraian3');
                                                }
                                                if ("<?php echo trim($UP[2]); ?>" !== "") {
                                                    $("input:checkbox[name='uraian4']").attr('checked', 'checked');
                                                    checkListTxt('uraian4');
                                                }
                                                if ("<?php echo trim($UP[3]); ?>" !== "") {
                                                    $("input:checkbox[name='uraian5']").attr('checked', 'checked');
                                                    checkListTxt('uraian5');
                                                }
                                                if ("<?php echo trim($UP[4]); ?>" !== "") {
                                                    $("input:checkbox[name='uraian6']").attr('checked', 'checked');
                                                    checkListTxt('uraian6');
                                                }
                                                if ("<?php echo trim($UP[5]); ?>" !== "") {
                                                    $("input:checkbox[name='uraian7']").attr('checked', 'checked');
                                                    checkListTxt('uraian7');
                                                }
                                                if ("<?php echo trim($UP[6]); ?>" !== "") {
                                                    $("input:checkbox[name='uraian8']").attr('checked', 'checked');
                                                    checkListTxt('uraian8');
                                                }
                                                if ("<?php echo trim($UP[7]); ?>" !== "") {
                                                    $("input:checkbox[name='uraian9']").attr('checked', 'checked');
                                                    checkListTxt('uraian9');
                                                }
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
    <?php if (in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) {
        ?>
                                                    verifikasiPusat($("#verifikasiPusat"));
                                                    kesimpulanHasilPenilaianFunct($("#verifikasiPusat"));
    <?php } else { ?>
                                                    kesimpulanHasilPenilaianFunct($("#kesimpulanHasilPenilaian"));
    <?php } ?>
                                                showHide();
                                                showHide2('<?php echo $sess['MEDIA']; ?>');
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
                                            $('#eChoosed').change(function() {
                                                showHide();
                                            });
                                            $('#lRChoosed').change(function() {
                                                showHide();
                                            });
                                            $(".uraianPelanggaran").click(function() {
                                                checkListTxt($(this).attr("name"));
                                            });
                                            $("input.namaKosmetika").autocomplete($("input.namaKosmetika").attr("url") + 'kos', {width: 244, selectFirst: false});
                                            $("input.namaKosmetika").result(function(event, data, formatted) {
                                                if (data) {
                                                    $("input.namaKosmetika").val(data[1]);
                                                    $("#namaPemilikNIE").val(data[3]);
                                                    $("#NIE").val(data[2]);
                                                    if (data[13] !== "-" && data[13] !== "")
                                                        $("#merkDagang").val(data[13]);
                                                    else
                                                        $("#merkDagang").val("-");
                                                    var jenis = data[12].split('-'), val = [];
                                                    for (var i = 0; i < jenis.length; i++)
                                                        val.push(jenis[i]);
                                                    val = "" + val;
                                                    $("#jenis_kosmetika").val(val.replace(/,/g, ", "));
                                                }
                                            });
                                            $("#namaMediaIklan").result(function(event, data, formatted) {
                                                if (data) {
                                                    $("#namaMediaIklan").attr("name", "");
                                                    $("#idMediaIklan").attr("name", "IKLAN[NAMA]");
                                                    $("#namaMediaIklan").val(data[1]);
                                                    $("#idMediaIklan").val(data[2]);
                                                }
                                            });
                                            $('.addnomor').click(function() {
                                                var nom = $(this).attr('terakhir'), idtr = $(this).attr('periksa'), cls = idtr + nom;
                                                $("#tb_kosmetika").append('<tr class= "' + cls + '"><td>&nbsp;</td></tr><tr class= "' + cls + '"><td width="150">Nama Kosmetika</td><td><input type="text" size="40" name="PRODUK[NAMA][]" class="namaKosmetika' + cls + '" url="<?php echo site_url(); ?>/autocompletes/autocomplete/produk_reg/" title="Nama Kosmetika" rel="required">&nbsp;&nbsp;<a href="javascript:void(0)" class="min" id="minCls' + cls + '" ><img src="<?php echo base_url(); ?>images/cancel.png" align="top" style="border:none" title="Hapus Kosmetika" /></a><input type="hidden" name="BBPOM[BBPOM_ID][]" id="bbpomid' + cls + '"><input type="hidden" name="BBPOM[MBBPOM_ID][]" id="mbbpomid' + cls + '"></td></tr><tr class= "' + cls + '"><td width="150">Merk Dagang</td><td><input type="text" size="40" name="PRODUK[MERKDAGANG][]" id="merkDagang' + cls + '" title="Merk Dagang" /></td></tr><tr class= "' + cls + '"><td width="150">Nama Pemilik Izin Edar</td><td><input type="text" size="40" name="PRODUK[NAMAPEMILIKIZINEDAR][]" id="namaPemilikNIE' + cls + '" title="Pemilik Izin Edar" readonly/></td><tr class= "' + cls + '"><td width="150">Nomor Izin Edar</td><td><input type="text" size="40" name="PRODUK[NOMORIZINEDAR][]" id="NIE' + cls + '" title="NIE" readonly /></td></tr></tr><tr class= "' + cls + '"><td width="150">Kategori Produk</td><td><textarea style="width:90%; name="PRODUK[JENIS][]" id="jenis_kosmetika' + cls + '" title="Kategori Produk" readonly></textarea></td></td></tr>');
                                                $(this).attr('terakhir', parseInt(nom) + 1);
                                                $("input.namaKosmetika" + cls).autocomplete($("input.namaKosmetika").attr("url") + 'kos', {width: 244, selectFirst: false});
                                                $("#minCls" + cls).click(function() {
                                                    $('.' + cls).remove();
                                                });
                                                $("input.namaKosmetika" + cls).result(function(event, data, formatted) {
                                                    if (data) {
                                                        var golonganKosmetika = data[2].substring(2, 1);
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
                                                        $("#jenis_kosmetika" + cls).val(val.replace(/,/g, ", "));
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
                                                        $(".upload_" + jenis + "").attr("rel", "required");
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
                                            $("#verifikasiPusat").change(function() {
                                                verifikasiPusat($(this));
                                                showHideUraian('verifikasiPusat');
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
                                        });
</script>