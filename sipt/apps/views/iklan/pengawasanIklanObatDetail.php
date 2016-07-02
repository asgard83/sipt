<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
error_reporting(E_ERROR);
?>
<link type="text/css" href="<?php echo base_url(); ?>css/iklanPenandaan.css" rel="stylesheet" media="screen"/>
<div id="judulpmnikl" class="judul"></div>
<div class="headersarana">PENGAWASAN IKLAN OBAT <?php echo $subJudul; ?> </div>
<?php
$bulan_iklan = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
$tahun_iklan = array(range(date("Y"), 2007));
$totalThn = array_sum(array_map("count", $tahun_iklan));
$hasil = explode('^', $sess['DETAIL_PUSAT']);
$infoTambahan = explode(',', $sess['PENILAIAN1']);
$infoTercantum = explode(',', $sess['PENILAIAN2']);
foreach ($infoTambahan as $k) {
    $tambahan[] = explode('_', $k);
}
foreach ($infoTercantum as $k) {
    $tercantum[] = explode('_', $k);
}
$UP = explode('^', $sess['URAIAN_PELANGGARAN']);
$comas = str_replace(",", ", ", $UP[0]);
$edisiMedia = explode(" ", $sess['EDISI']);
$tayangMedia = explode(" ", $sess['JAM_TAYANG']);
$hasilKesimpulanOpt = explode("^", $sess['TL_PUSAT']);
$hasilKesimpulanOpt2 = explode("^", $sess['DETAIL_PUSAT']);
?>
<div class="content">
    <form action="<?php echo $act; ?>" method="post" autocomplete="off" id="fpengawasanIklan_001">
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
                                    if ($this->session->userdata('TANGGAL') != "-" && !$sess['TGL_SURAT']) {
                                        echo $this->session->userdata('TANGGAL');
                                    } else if ($sess['TGL_SURAT'] != NULL) {
                                        echo $sess['TGL_SURAT'];
                                    }
                                    else
                                        echo $sess['TANGGAL_MULAI'];
                                    ?>"/>
                                    <input type="text" class="sdate" name="IKLAN[TANGGALAWAL]" id="tglAwalPengawasan" title="Tanggal Pengawasan Iklan" onchange="comp('A')" rel='required' value="<?php echo $sess['TANGGAL_MULAI']; ?>"/>&nbsp; sampai dengan&nbsp;
                                    <input type="text" class="sdate" name="IKLAN[TANGGALAKHIR]" id="tglAkhirPengawasan" title="Tanggal Pengawasan Iklan" onchange="comp('B')" rel='required' value="<?php echo $sess['TANGGAL_AKHIR']; ?>"/></td>
                            </tr>
                            <tr><td class="td_left">Kelompok Iklan</td><td class="td_right">
                                    <select name="IKLANOBAT[KELOMPOK]" id="iklan_kelompok" class="sjenis sl_kelompok_iklan" title="Kelompok Iklan" rel="required">
                                        <option value=""></option>
                                        <option value="Dengan Indikasi">Dengan Indikasi</option>
                                        <option value="Tanpa Indikasi">Tanpa Indikasi</option>
                                        <option value="Kegiatan Promosi">Kegiatan Promosi</option></select></td>
                            </tr>
                        </table>
                    </div>
                </div><!-- Akhir Pemeriksaan !-->
                <div style="height:5px;"></div>
                <div class="acco2"><div class="expand"><a title="expand/collapse" href="#" style="display: block;">INFORMASI OBAT - IKLAN</a></div>
                    <div class="collapse">
                        <div class="accCntnt">
                            <table>
                                <tr>
                                    <td>
                                        <table>
                                            <tbody id="tb_obat">
                                                <?php
                                                $jmldata = 0;
                                                $data = $sess2;
                                                $jmldata = count($data);
                                                if ($jmldata == 0) {
                                                    $jmldata = 1;
                                                    $data[] = "";
                                                }
                                                $i = 0;
                                                do {
                                                    $A = explode("_", $sess2[$i]['JENIS_PRODUK']);
                                                    ?>
                                                    <tr class="urut<?php echo $i; ?>">
                                                        <td width="150">Nama Obat</td>
                                                        <td>
                                                            <input type="text" name="PRODUK[NAMA][]" class="namaObat" size="40" id="namaObat" url="<?php echo site_url(); ?>/autocompletes/autocomplete/produk_reg_2/" title="Nama Obat" rel="required" value="<?php echo $sess2[$i]['NAMA_PRODUK']; ?>" />&nbsp;
                                                            <?php
                                                            if ($i == 0) {
                                                                ?>
                                                                <a href="javascript:void(0)" class="addnomor" periksa="urut" terakhir="<?php echo $jmldata; ?>"><img src="<?php echo base_url(); ?>images/add.png" align="absmiddle" style="border:none" title="Tambah Obat" /></a>
                                                                <?php
                                                            } else {
                                                                ?>
                                                                <a href="javascript:void(0)" class="min" onclick="$('.urut<?php echo $i; ?>').remove();"><img src="<?php echo base_url(); ?>images/cancel.png" align="absmiddle" style="border:none" title="Hapus Obat" /></a>
                                                                <?php
                                                            }
                                                            ?></td>
                                                    </tr>
                                                    <tr class="urut<?php echo $i; ?>">
                                                        <td width="150">Bentuk Sediaan</td>
                                                        <td><input type="text" size="40" name="PRODUK[BENTUKSEDIAAN][]" id="bentukSediaan" title="Bentuk Sediaan" value="<?php echo $sess2[$i]['BENTUK_SEDIAAN']; ?>" />
                                                        </td>
                                                    </tr>
                                                    <tr class="urut<?php echo $i; ?>">
                                                        <td width="150">Nama Pemilik Izin Edar</td>
                                                        <td><input type="text" size="40" name="PRODUK[NAMAPEMILIKIZINEDAR][]" id="namaPemilikNIE" title="Pemilik Izin Edar" value="<?php echo $sess2[$i]['NAMA_PEMILIK_IZIN_EDAR']; ?>" />
                                                        </td>
                                                    </tr>
                                                    <tr class="urut<?php echo $i; ?>">
                                                        <td width="150">Nomor Izin Edar</td>
                                                        <td><input type="text" size="40" name="PRODUK[NIE][]" id="NIE" title="Nomor Izin Edar" value="<?php echo $sess2[$i]['NOMOR_IZIN_EDAR']; ?>" />
                                                        </td>
                                                    </tr>
                                                    <tr class="urut<?php echo $i; ?>">
                                                        <td>Golongan Obat</td>
                                                        <td>
                                                            <input type="text" class="golonganObat" size="40" name="PRODUK[GOLONGAN][]" id="golonganObat" title="Golongan Obat" value="<?php echo $sess2[$i]['GOLONGAN_PRODUK']; ?>" />
                                                        </td>
                                                    </tr>
                                                    <tr class="urut<?php echo $i; ?> jenisObatChoosed" hidden>
                                                        <td>Jenis Obat</td><td>
                                                            <select name="PRODUK[JENIS][]" id="jenis_obat" title="Jenis Obat" class="sl_jenis_obat" onChange="sl_jenis_obat();">
                                                                <option value="<?php echo $sess2[$i]['JENIS_PRODUK']; ?>" class="X"><?php echo $A[1]; ?></option>
                                                                <option value="A_Obat Mengandung Antihistamin" class="A">Obat Mengandung Antihistamin</option>
                                                                <option value="B_Obat Mengandung Nasal Dekongestan" class="B">Obat Mengandung Nasal Dekongestan</option>
                                                                <option value="C_Obat Tetes Mata Mengandung Benzalkonium Chloride" class="C">Obat Tetes Mata Mengandung Benzalkonium Chloride</option>
                                                                <option value="D_Obat Pencahar" class="D">Obat Pencahar</option>
                                                                <option value="E_Obat Diare kecuali Oralit" class="E">Obat Diare kecuali Oralit</option>
                                                                <option value="F_Obat Cacing" class="F">Obat Cacing</option>
                                                                <option value="G_Obat Maag" class="G">Obat Maag</option>
                                                                <option value="H_Obat Infeksi Jamur Kulit Topikal" class="H">Obat Infeksi Jamur Kulit Topikal</option>
                                                                <option value="I_Obat Mengandung Antihistamin Dan Nasal Dekongestan" class="I">Obat Mengandung Antihistamin Dan Nasal Dekongestan</option>
                                                                <option value="J_Obat Kelompok Umum (Tanpa informasi tambahan)" class="J">Obat Kelompok Umum (Tanpa informasi tambahan)</option>
                                                            </select></td>
                                                    </tr>
                                                    <?php
                                                    $i++;
                                                    if ($i > 0)
                                                        echo "<tr><td>&nbsp;</td></tr>";
                                                } while ($i < $jmldata)
                                                ?>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div style="height:5px;"></div>

                <!-- DIV Detail-->
                <div>

                    <!--3-->
                    <div class="expand" id="expand3" hidden="true"><a title="expand/collapse" href="#" style="display: block;">INFORMASI TAMBAHAN</a></div>
                    <div class="collapse">
                        <div class="accCntnt" id="expand3a" hidden="true">
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
                                    <td style="width: 10%; background-color: white;" class="td_left" colspan="6">
                                        <input type="radio" id="r1" disabled="true">
                                        <label for="r1" style="width: 54px; height: 10px;">Ada</label>
                                        <span style="margin-left: 5px;"></span>
                                        <input type="radio" id="r2" disabled="true">
                                        <label for="r2" style="width: 54px; height: 10px;">Tidak Ada</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="td_left_checklist"></td>
                                    <td class="td_left_header_checklist"></td>
                                    <td>&nbsp;</td>
                                    <td style="width: 10%;" class="td_left" colspan="6">
                                    </td>
                                </tr>
                                <tr class="obat_A obj_jenis_obat infoTambahanRow rowIklan" hidden> <!--Antihistamin-->
                                    <td class="td_left_checklist"></td>
                                    <td class="td_left_header_checklist">Antihistamin/ CTM  : Obat Ini Dapat Menyebabkan Kantuk </td>
                                    <td></td>
                                    <td style="width: 10%;" class="td_left" colspan="6">
                                        <input class="infoTambahan" type="radio" id="radio3a1" name="info2[1][Antihistamin_CTM]" value="+_Informasi Antihistamin/ CTM">
                                        <label for="radio3a1" style="width: 54px; height: 10px;" title="Ada"></label>
                                        <span style="margin-left: 5px;"></span>
                                        <input class="infoTambahan" type="radio" id="radio3a2" name="info2[1][Antihistamin_CTM]" value="-_Informasi Antihistamin/ CTM">
                                        <label for="radio3a2" style="width: 54px; height: 10px; background-color: #9d0101" title="Tidak Ada"></label>
                                        <input type="text" class="infoT" name="info2[1][Antihistamin_CTM]" style="display: none">
                                    </td>
                                </tr>
                                <tr class="obat_B obj_jenis_obat infoTambahanRow rowIklan" hidden> <!--Nasal Dekongestan-->
                                    <td class="td_left_checklist"></td>
                                    <td class="td_left_header_checklist">Nasal dekongestan (Phenil Propanolamin, Efedrin, Pseudoefedrin, Fenilefrin) : Perhatikan Peringatan dan Kontra Indikasi. Tidak Melebihi Dosis dan Anjuran </td>
                                    <td></td>
                                    <td style="width: 10%;" class="td_left" colspan="6">
                                        <input class="infoTambahan" type="radio" id="radio3b1" name="info2[2][Nasal_dekongestan]" value="+_Informasi Nasal dekongestan">
                                        <label for="radio3b1" style="width: 54px; height: 10px;" title="Ada"></label>
                                        <span style="margin-left: 5px;"></span>
                                        <input class="infoTambahan" type="radio" id="radio3b2" name="info2[2][Nasal_dekongestan]" value="-_Informasi Nasal dekongestan">
                                        <label for="radio3b2" style="width: 54px; height: 10px; background-color: #9d0101" title="Tidak Ada"></label>
                                        <input type="text" class="infoT" name="info2[2][Nasal_dekongestan]" style="display: none">
                                    </td>
                                </tr>
                                <tr class="obat_C obj_jenis_obat infoTambahanRow rowIklan" hidden> <!--Obat tetes mata-->
                                    <td class="td_left_checklist"></td>
                                    <td class="td_left_header_checklist">Benzalkonium Chlorida (untuk obat tetes mata) : Lepaskan Lensa Kontak Saat Digunakan. Jangan Digunakan Rutin Jangka Panjang </td>
                                    <td></td>
                                    <td style="width: 10%;" class="td_left" colspan="6">
                                        <input class="infoTambahan" type="radio" id="radio3c1" name="info2[3][Benzalkonium_Chlorida]" value="+_Informasi Benzalkonium Chlorida">
                                        <label for="radio3c1" style="width: 54px; height: 10px;" title="Ada"></label>
                                        <span style="margin-left: 5px;"></span>
                                        <input class="infoTambahan" type="radio" id="radio3c2" name="info2[3][Benzalkonium_Chlorida]" value="-_Informasi Benzalkonium Chlorida">
                                        <label for="radio3c2" style="width: 54px; height: 10px; background-color: #9d0101" title="Tidak Ada"></label>
                                        <input type="text" class="infoT" name="info2[3][Benzalkonium_Chlorida]" style="display: none">
                                    </td>
                                </tr>
                                <tr class="obat_D obj_jenis_obat infoTambahanRow rowIklan" hidden> <!--Obat Pencahar-->
                                    <td class="td_left_checklist"></td>
                                    <td class="td_left_header_checklist">Obat Pencahar : Penggunaan Obat Pencahar Ini Hanya Bila Benar-Benar Diperlukan. Hanya Untuk Penggunaan Jangka Pendek </td>
                                    <td></td>
                                    <td style="width: 10%;" class="td_left" colspan="6">
                                        <input class="infoTambahan" type="radio" id="radio3d1" name="info2[4][Nasal_dekongestan]" value="+_Informasi Obat Pencahar">
                                        <label for="radio3d1" style="width: 54px; height: 10px;" title="Ada"></label>
                                        <span style="margin-left: 5px;"></span>
                                        <input class="infoTambahan" type="radio" id="radio3d2" name="info2[4][Nasal_dekongestan]" value="-_Informasi Obat Pencahar">
                                        <label for="radio3d2" style="width: 54px; height: 10px; background-color: #9d0101" title="Tidak Ada"></label>
                                        <input type="text" class="infoT" name="info2[4][Nasal_dekongestan]" style="display: none">
                                    </td>
                                </tr>
                                <tr class="obat_E obj_jenis_obat infoTambahanRow rowIklan" hidden> <!--Obat Diare-->
                                    <td class="td_left_checklist"></td>
                                    <td class="td_left_header_checklist">Obat diare yang diserahkan tanpa resep dokter, tidak termasuk Oralit  : Tidak boleh diberikan pada anak di bawah 5 tahun dan penderita harus minum oralit </td>
                                    <td></td>
                                    <td style="width: 10%;" class="td_left" colspan="6">
                                        <input class="infoTambahan" type="radio" id="radio3e1" name="info2[5][Nasal_dekongestan]" value="+_Informasi Obat diare">
                                        <label for="radio3e1" style="width: 54px; height: 10px;" title="Ada"></label>
                                        <span style="margin-left: 5px;"></span>
                                        <input class="infoTambahan" type="radio" id="radio3e2" name="info2[5][Nasal_dekongestan]" value="-_Informasi Obat diare">
                                        <label for="radio3e2" style="width: 54px; height: 10px; background-color: #9d0101" title="Tidak Ada"></label>
                                        <input type="text" class="infoT" name="info2[5][Nasal_dekongestan]" style="display: none">
                                    </td>
                                </tr>
                                <tr class="obat_F obj_jenis_obat infoTambahanRow rowIklan" hidden> <!--Obat Cacing-->
                                    <td class="td_left_checklist"></td>
                                    <td class="td_left_header_checklist">Obat Cacing : Jagalah Kebersihan Badan, Makanan dan Lingkungan untuk Menghindari Kecacingan </td>
                                    <td></td>
                                    <td style="width: 10%;" class="td_left" colspan="6">
                                        <input class="infoTambahan" type="radio" id="radio3f1" name="info2[6][Nasal_dekongestan]" value="+_Informasi Obat Cacing">
                                        <label for="radio3f1" style="width: 54px; height: 10px;" title="Ada"></label>
                                        <span style="margin-left: 5px;"></span>
                                        <input class="infoTambahan" type="radio" id="radio3f2" name="info2[6][Nasal_dekongestan]" value="-_Informasi Obat Cacing">
                                        <label for="radio3f2" style="width: 54px; height: 10px; background-color: #9d0101" title="Tidak Ada"></label>
                                        <input type="text" class="infoT" name="info2[6][Nasal_dekongestan]" style="display: none"
                                    </td>
                                </tr>
                                <tr class="obat_G obj_jenis_obat infoTambahanRow rowIklan" hidden> <!--Obat maag-->
                                    <td class="td_left_checklist"></td>
                                    <td class="td_left_header_checklist">Obat maag : Makan Teratur Dapat Mengurangi Gejala Sakit Maag </td>
                                    <td></td>
                                    <td style="width: 10%;" class="td_left" colspan="6">
                                        <input class="infoTambahan" type="radio" id="radio3g1" name="info2[7][Nasal_dekongestan]" value="+_Informasi Obat maag">
                                        <label for="radio3g1" style="width: 54px; height: 10px;" title="Ada"></label>
                                        <span style="margin-left: 5px;"></span>
                                        <input class="infoTambahan" type="radio" id="radio3g2" name="info2[7][Nasal_dekongestan]" value="-_Informasi Obat maag">
                                        <label for="radio3g2" style="width: 54px; height: 10px; background-color: #9d0101" title="Tidak Ada"></label>
                                        <input type="text" class="infoT" name="info2[7][Nasal_dekongestan]" style="display: none">
                                    </td>
                                </tr>
                                <tr class="obat_H obj_jenis_obat infoTambahanRow rowIklan" hidden="true"> <!--Obat infeksi jamur-->
                                    <td class="td_left_checklist"></td>
                                    <td class="td_left_header_checklist">Obat infeksi jamur kulit : Gunakan Obat Ini Selama Minimal 2 (Dua) Minggu Jagalah Kebersihan Tubuh Untuk Menghindari Penyakit Kulit </td>
                                    <td></td>
                                    <td style="width: 10%;" class="td_left" colspan="6">
                                        <input class="infoTambahan" type="radio" id="radio3h1" name="info2[8][Nasal_dekongestan]" value="+_Informasi Obat infeksi jamur kulit">
                                        <label for="radio3h1" style="width: 54px; height: 10px;" title="Ada"></label>
                                        <span style="margin-left: 5px;"></span>
                                        <input class="infoTambahan" type="radio" id="radio3h2" name="info2[8][Nasal_dekongestan]" value="-_Informasi Obat infeksi jamur kulit">
                                        <label for="radio3h2" style="width: 54px; height: 10px; background-color: #9d0101" title="Tidak Ada"></label>
                                        <input type="text" class="infoT" name="info2[8][Nasal_dekongestan]" style="display: none">
                                    </td></tr>
                                <tr>
                                    <td style="width: 2%; background-color: white;"></td>
                                    <td style="width: 50%; background-color: white;"></td>
                                    <td style="width: 13%; background-color: white;"></td>
                                    <td style="width: 35%; font-size: 14px; padding-left: 250px; padding-right: 250px; padding-bottom: 5px; padding-top: 5px; background-color: white;"></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div style="height:5px;" id="expand3b" hidden="true"></div>

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
                                <tr class="promoBased">
                                    <td class="td_left_checklist"></td>
                                    <td class="td_left_header_checklist">Jenis Iklan</td>
                                    <td></td>
                                    <td colspan="2" class="td_left"><select name="IKLAN[JENISIKLAN]" onChange="mediaIklan2();" id="iklan_media" class="sjenis sl_iklan_media promoBased" title="Jenis Iklan" rel="required">
                                            <option value=""></option>
                                            <option value="Cetak">Cetak</option>
                                            <option value="Elektronik">Elektronik</option>
                                            <option value="Luar Ruang">Luar Ruang</option></select></td>
                                </tr>
                                <tr class="iklanObatReq iorMedia promoBased">
                                    <td class="td_left_checklist"></td>
                                    <td class="td_left_header_checklist">Media</td>
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
                                            <option value="Transit Ad">Transit Ad</option>
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
                                <tr class="td_left promoBased" id="namaMedia" hidden>
                                    <td class="td_left_checklist"></td>
                                    <td class="td_left_header_checklist"><span id ="namaMedia1"></span></td>
                                    <td></td>
                                    <td style="width: 10%;" colspan="2" class="td_left_checklist"><input type="text" id="namaMediaIklan" class="stext namaMedia" title="Nama Media (Klik untuk memilih data)" url="<?php echo site_url(); ?>/autocompletes/autocomplete/nama_media/" value="<?php echo $sess['NAMA_MEDIA']; ?>" /><input type="hidden" id="idMediaIklan"  value="<?php echo $sess['ID_MEDIA']; ?>" /></td>
                                </tr>
                                <tr class="td_left" id="judulKegiatanRow" hidden>
                                    <td class="td_left_checklist"></td>
                                    <td class="td_left_header_checklist">Judul Kegiatan</td>
                                    <td></td>
                                    <td style="width: 10%;" colspan="2" class="td_left_checklist"><input type="text" class="stext" id="judulKegiatan" name="IKLAN[JUDUL]" title="Judul Kegiatan" value="<?php echo $sess['JUDUL_KEGIATAN']; ?>" /></td>
                                </tr>
                                <tr id="tglTerbit" class="promoBased">
                                    <td class="td_left_checklist"></td>
                                    <td class="td_left_header_checklist">Tanggal Penerbitan</td>
                                    <td></td>
                                    <td style="width: 10%;" class="td_left" colspan="2"><input type="text" class="sdate promoBased" name="IKLAN[TANGGAL]" id="tglTugas" title="Tanggal Penerbitan Iklan" onchange="comp('C')" rel="required" value="<?php echo $sess['TANGGAL']; ?>"/>&nbsp;&nbsp;
                                </tr>
                                <tr id="edisiTime" class="promoBased" hidden>
                                    <td class="td_left_checklist"></td>
                                    <td class="td_left_header_checklist">Edisi Media Iklan</td>
                                    <td></td>
                                    <td style="width: 10%;" class="td_left" colspan="2">
                                        <span><select class="edisiTayang edisiCetak" title="Tahun" name="IKLAN[EDISI1]"><option value=""></option><?php
                                                for ($i = 0; $i < $totalThn; $i++) {
                                                    ?><option value="<?php echo $tahun_iklan[0][$i]; ?>"><?php echo $tahun_iklan[0][$i]; ?></option><?php } ?></select>&nbsp;&nbsp;<select class="edisiTayang edisiCetak" title="Bulan" name="IKLAN[EDISI2]"><option value=""></option><?php
                                                for ($i = 0; $i < 12; $i++) {
                                                    ?><option value="<?php echo $bulan_iklan[$i]; ?>"><?php echo $bulan_iklan[$i]; ?></option><?php } ?></select></span>
                                    </td>
                                </tr>
                                <tr id="tayangTime" class="promoBased" hidden>
                                    <td class="td_left_checklist"></td>
                                    <td class="td_left_header_checklist">Jam Tayang Media Iklan</td>
                                    <td></td>
                                    <td style="width: 10%;" class="td_left" colspan="2">
                                        <span><select class="edisiTayang edisiTV" title="Jam" name="IKLAN[TAYANG1]"><option value=""></option><?php
                                                for ($i = 1; $i <= 24; $i++) {
                                                    ?><option value="<?php echo $i; ?>"><?php echo $i; ?></option><?php } ?></select> : <select class="edisiTayang edisiTV" title="Jam" name="IKLAN[TAYANG2]"><option value=""></option><?php
                                                for ($i = 1; $i < 60; $i++) {
                                                    ?><option value="<?php echo $i; ?>"><?php echo $i; ?></option><?php } ?></select>&nbsp;&nbsp;&nbsp;hh : mm</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="td_left_checklist"></td>
                                    <td class="td_left_header_checklist">Nama Lokasi Pengambilan Iklan</td>
                                    <td></td>
                                    <td style="width: 10%;" class="td_left" colspan="2"><input name="IKLAN[LOKASI]" type="text" class="stext" id="namaLokasi" title="Nama Lokasi" value="<?php echo $sess['NAMA_LOKASI_IKLAN']; ?>"/>
                                </tr>
                                <tr class="ifElektronik">
                                    <td class="td_left_checklist"></td>
                                    <td class="td_left_header_checklist" style="vertical-align: top;">Alamat Lokasi Pengawasan Iklan</td>
                                    <td></td>
                                    <td style="width: 10%;" class="td_left" colspan="2"><textarea class="stext" id="alamatLokasi" title="Alamat Lokasi Pengambilan Iklan" name="IKLAN[ALAMAT]"><?php echo $sess['ALAMAT_LOKASI_IKLAN']; ?></textarea></td>
                                </tr>
                                <?php if (in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')) || $this->newsession->userdata("SESS_BBPOM_ID") == "50") { ?>
                                    <tr class="ifElektronik promoBased">
                                        <td class="td_left_checklist"></td>
                                        <td class="td_left_header_checklist">Provinsi</td>
                                        <td></td>
                                        <td style="width: 10%;" colspan="2" class="td_left"><?php echo form_dropdown('KOTA', $provinsi, $provinsiVal, 'style="width:158px" id="provkotAlamat" class="stext" title="Nama Provinsi Pengambilan Iklan"'); ?></td>
                                    </tr>
                                <?php } ?>
                                <tr class="ifElektronik promoBased">
                                    <td class="td_left_checklist"></td>
                                    <td class="td_left_header_checklist">Kota / Kabupaten</td>
                                    <td></td>
                                    <td style="width: 10%;" colspan="2" class="td_left"><?php echo form_dropdown('IKLAN[KOTA]', $kabupaten, $kabupatenVal, 'style="width:158px" id="kabkotAlamat" class="stext" title="Nama Kota Pengambilan Iklan"'); ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div style="height:5px;" id="expand2b"></div>

                    <!--2-->
                    <div class="expand" id="expand2"><a title="expand/collapse" href="#" style="display: block;">INFORMASI YANG TERCANTUM DALAM IKLAN OBAT</a></div>
                    <div class="collapse">
                        <div class="accCntnt" id="expand2a">
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
                                    <td style="width: 10%; background-color: white;" class="td_left" colspan="6">
                                        <input type="radio" id="r1" disabled="true">
                                        <label for="r1" style="width: 54px; height: 10px;">Ada</label>
                                        <span style="margin-left: 5px;"></span>
                                        <input type="radio" id="r2" disabled="true">
                                        <label for="r2" style="width: 54px; height: 10px; background-color: #9d0101;">Tidak Ada</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="td_left_checklist"></td>
                                    <td class="td_left_header_checklist"></td>
                                    <td>&nbsp;</td>
                                    <td style="width: 10%;" class="td_left" colspan="6">
                                    </td>
                                </tr>
                                <tr class="promoBased infoTercantumRow rowIklan">
                                    <td class="td_left_checklist"></td>
                                    <td class="td_left_header_checklist">Nama Obat Jadi</td>
                                    <td></td>
                                    <td style="width: 10%;" class="td_left" colspan="6">
                                        <input class="infoTercantum" type="radio" id="radio2a1" name="info2[1][Nama_Obat_Jadi]" value="+_Nama Obat Jadi">
                                        <label  for="radio2a1" style="width: 54px; height: 10px;" title="Ada"></label>
                                        <span style="margin-left: 5px;"></span>
                                        <input class="infoTercantum" type="radio" id="radio2a2" name="info2[1][Nama_Obat_Jadi]" value="-_Nama Obat Jadi">
                                        <label for="radio2a2" style="width: 54px; height: 10px; background-color: #9d0101" title="Tidak Ada"></label>
                                        <input type="text" class="infoTercantumVal" name="info2[1][Nama_Obat_Jadi]" style="display: none">
                                    </td>
                                </tr>
                                <tr class="promoBased infoTercantumRow rowIklan">
                                    <td class="td_left_checklist"></td>
                                    <td class="td_left_header_checklist">Nama Pemilik Izin Edar</td>
                                    <td></td>
                                    <td style="width: 10%;" class="td_left" colspan="6">
                                        <input class="infoTercantum" type="radio" id="radio2b1" name="info2[1][Nama_Pemilik_Izin_Edar]" value="+_Nama Pemilik Izin Edar">
                                        <label for="radio2b1" style="width: 54px; height: 10px;" title="Ada"></label>
                                        <span style="margin-left: 5px;"></span>
                                        <input class="infoTercantum" type="radio" id="radio2b2" name="info2[1][Nama_Pemilik_Izin_Edar]" value="-_Nama Pemilik Izin Edar">
                                        <label for="radio2b2" style="width: 54px; height: 10px; background-color: #9d0101" title="Tidak Ada"  ></label>
                                        <input type="text" class="infoTercantumVal" name="info2[1][Nama_Pemilik_Izin_Edar]" style="display: none">
                                    </td>
                                </tr>
                                <tr class="hashStar aav infoTercantumRow rowIklan">
                                    <td class="td_left_checklist"></td>
                                    <td class="td_left_header_checklist">Nomor Izin Edar (NIE)</td>
                                    <td></td>
                                    <td style="width: 10%;" class="td_left" colspan="6">
                                        <input class="infoTercantum" type="radio" id="radio2c1" name="info2[3][NIE]" value="+_Nomor Izin Edar (NIE)">
                                        <label  for="radio2c1" style="width: 54px; height: 10px;" title="Ada"></label>
                                        <span style="margin-left: 5px;"></span>
                                        <input class="infoTercantum" type="radio" id="radio2c2" name="info2[3][NIE]" value="-_Nomor Izin Edar (NIE)">
                                        <label for="radio2c2" style="width: 54px; height: 10px; background-color: #9d0101" title="Tidak Ada"></label>
                                        <input type="text" class="infoTercantumVal" name="info2[3][NIE]" style="display: none">
                                    </td>
                                </tr>
                                <tr class="hashStar aav infoTercantumRow rowIklan">
                                    <td class="td_left_checklist"></td>
                                    <td class="td_left_header_checklist">Komposisi Zat Aktif</td>
                                    <td></td>
                                    <td style="width: 10%;" class="td_left" colspan="6">
                                        <input class="infoTercantum" type="radio" id="radio2d1" name="info2[4][Komposisi_Zat_Aktif]" value="+_Komposisi Zat Aktif">
                                        <label  for="radio2d1" style="width: 54px; height: 10px;" title="Ada"></label>
                                        <span style="margin-left: 5px;"></span>
                                        <input class="infoTercantum" type="radio" id="radio2d2" name="info2[4][Komposisi_Zat_Aktif]" value="-_Komposisi Zat Aktif">
                                        <label for="radio2d2" style="width: 54px; height: 10px; background-color: #9d0101" title="Tidak Ada"></label>
                                        <input type="text" class="infoTercantumVal" name="info2[4][Komposisi_Zat_Aktif]" style="display: none">
                                    </td>
                                </tr>
                                <tr class="hashStar infoTercantumRow rowIklan">
                                    <td class="td_left_checklist"></td>
                                    <td class="td_left_header_checklist">Indikasi Utama</td>
                                    <td></td>
                                    <td style="width: 10%;" class="td_left" colspan="6">
                                        <input class="infoTercantum" type="radio" id="radio2e1" name="info2[5][Indikasi_Utama]" value="+_Indikasi Utama">
                                        <label  for="radio2e1" style="width: 54px; height: 10px;" title="Ada"></label>
                                        <span style="margin-left: 5px;"></span>
                                        <input class="infoTercantum" type="radio" id="radio2e2" name="info2[5][Indikasi_Utama]" value="-_Indikasi Utama">
                                        <label for="radio2e2" style="width: 54px; height: 10px; background-color: #9d0101" title="Tidak Ada"></label>
                                        <input type="text" class="infoTercantumVal" name="info2[5][Indikasi_Utama]" style="display: none">
                                    </td>
                                </tr>
                                <tr class="hashStar infoTercantumRow rowIklan">
                                    <td class="td_left_checklist"></td>
                                    <td class="td_left_header_checklist">Spot Peringatan Perhatian</td>
                                    <td></td>
                                    <td style="width: 10%;" class="td_left" colspan="6">
                                        <input class="infoTercantum" type="radio" id="radio2f1" name="info2[6][Spot_Peringatan_Perhatian]" value="+_Spot Peringatan Perhatian">
                                        <label  for="radio2f1" style="width: 54px; height: 10px;" title="Ada"></label>
                                        <span style="margin-left: 5px;"></span>
                                        <input class="infoTercantum" type="radio" id="radio2f2" name="info2[6][Spot_Peringatan_Perhatian]" value="-_Spot Peringatan Perhatian">
                                        <label for="radio2f2" style="width: 54px; height: 10px; background-color: #9d0101" title="Tidak Ada"></label>
                                        <input type="text" class="infoTercantumVal" name="info2[6][Spot_Peringatan_Perhatian]" style="display: none">
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 2%; background-color: white;"></td>
                                    <td style="width: 50%; background-color: white;"></td>
                                    <td style="width: 13%; background-color: white;"></td>
                                    <td style="width: 35%; font-size: 14px; padding-left: 250px; padding-right: 250px; padding-bottom: 5px; padding-top: 5px; background-color: white;"></td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <!--4-->
                    <?php
                    $hdn4 = 'hidden = "true"';
                    if (trim($sess['PROMO']) != '' || $sess['PROMO'] != NULL)
                        $hdn4 = 'hidden = "false"';
                    ?>
                    <div style="height:5px;" id="expand4b" <?php echo $hdn4; ?>></div>
                    <div class="expand" id="expand4" <?php echo $hdn4; ?>><a title="expand/collapse" href="#" style="display: block;">DESKRIPSI IKLAN / PROMOSI</a></div>
                    <div class="collapse" <?php echo $hdn4; ?>>
                        <div class="accCntnt" id="expand4a" <?php echo $hdn4; ?>>
                            <table class="form_tabel_detail">
                                <tr>
                                    <td style="width: 2%;"></td>
                                    <td style="width: 50%;"></td>
                                    <td style="width: 13%;"></td>
                                    <td style="width: 35%; font-size: 14px; padding-left: 250px; padding-right: 250px; padding-bottom: 5px; padding-top: 5px;"></td>
                                </tr>
                                <tr>
                                    <td class="td_left_checklist" style="vertical-align: top;"></td>
                                    <td class="td_left_header_checklist" style="vertical-align: top;">Deskripsi Iklan/Promosi (untuk iklan audio dan audio visual yang tidak tersedia rekaman elektroniknya serta untuk Kelompok Iklan Kegiatan Promosi)</td>
                                    <td></td>
                                    <td style="width: 10%;" colspan="2" class="td_left_checklist"><textarea class="stext" id="deskripsiIklan" title="Deskripsi Iklan" name="IKLANOBAT[PROMOSI]" style="width: 98%; height: 75px;" rel="required"><?php echo $sess['PROMO']; ?></textarea></td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <!--5-->
                    <div style="height:5px;" id="expand5b"></div>
                    <div class="expand" id="expand5"><a title="expand/collapse" href="#" style="display: block;">URAIAN PELANGGARAN</a></div>
                    <div class="collapse">
                        <div class="accCntnt">
                            <table class="form_tabel_detail">
                                <tr>
                                    <td style="width: 2%;"></td>
                                    <td style="width: 50%;"></td>
                                    <td style="width: 13%;"></td>
                                    <td style="width: 35%; font-size: 14px; padding-left: 250px; padding-right: 250px; padding-bottom: 5px; padding-top: 5px;"></td>
                                </tr>
                                <tr class="tL" <?php if (trim($UP[0]) == "") echo 'hidden'; ?>>
                                    <td class="td_left_checklist"></td>
                                    <td class="td_left_header_checklist" style="vertical-align: top;"><input class="uraianPelanggaran" type="checkbox" name="uraian" style="vertical-align: top; margin-right: 10px" checked disabled />Tidak lengkap</td>
                                    <td></td>
                                    <td style="width: 10%;" colspan="6"><span class="uraian1"><textarea class="uPelanggaran" title="Tidak Lengkap" id="uraianTidakLengkap" style="width: 98%; height: 75px;" name="UPELANGGARAN[]" readonly></textarea></span></td>
                                </tr>
                                <tr class="hashTag">
                                    <td class="td_left_checklist"  style="vertical-align: top;"></td>
                                    <td class="td_left_header_checklist" style="vertical-align: top;"><input class="uraianPelanggaran" type="checkbox" name="uraian2" style="vertical-align: top; margin-right: 10px" title="Tidak Obyektif" />&nbsp;Tidak obyektif</td>
                                    <td></td>
                                    <td style="width: 10%;" colspan="6"><span class="uraian2" hidden="true"><textarea class="uPelanggaran uraian2 TIDAK_OBYEKTIF" title="Tidak Obyektif" id="uraianTidakObyektif" style="width: 98%; height: 75px;" name="UPELANGGARAN[]"></textarea></span></td>
                                <tr class="hashTag">
                                    <td class="td_left_checklist"></td>
                                    <td class="td_left_header_checklist" style="vertical-align: top;"><input class="uraianPelanggaran" type="checkbox" name="uraian3" style="vertical-align: top; margin-right: 10px" title="Klaim Berlebihan" />&nbsp;Klaim berlebihan</td>
                                    <td></td>
                                    <td style="width: 10%;" colspan="6"><span class="uraian3" hidden="true"><textarea class="uPelanggaran uraian3 KLAIM_BERLEBIHAN" title="Klaim Berlebihan" id="uraianKlaimBerlebihan" style="width: 98%; height: 75px;" name="UPELANGGARAN[]"></textarea></span></td>
                                </tr>
                                <tr class="hashTag">
                                    <td class="td_left_checklist"></td>
                                    <td class="td_left_header_checklist" style="vertical-align: top;"><input class="uraianPelanggaran" type="checkbox" name="uraian4" style="vertical-align: top; margin-right: 10px" title="Testimoni" />&nbsp;Testimoni</td>
                                    <td></td>
                                    <td style="width: 10%;" colspan="6"><span class="uraian4" hidden="true"><textarea class="uPelanggaran uraian4 TESTIMONI" title="Testimoni" id="uraianTestimoni" style="width: 98%; height: 75px;" name="UPELANGGARAN[]"></textarea></span></td>
                                </tr>
                                <tr class="hashTag">
                                    <td class="td_left_checklist"></td>
                                    <td class="td_left_header_checklist" style="vertical-align: top;"><input class="uraianPelanggaran" type="checkbox" name="uraian5" style="vertical-align: top; margin-right: 10px" title="Pemberian Hadiah" />&nbsp;Pemberian hadiah</td>
                                    <td></td>
                                    <td style="width: 10%;" colspan="6"><span class="uraian5" hidden="true"><textarea class="uPelanggaran uraian5 PEMBERIAN_HADIAH" title="Pemberian Hadiah" id="uraianPemberianHadiah" style="width: 98%; height: 75px;" name="UPELANGGARAN[]"></textarea></span></td>
                                </tr>
                                <tr class="hashTag">
                                    <td class="td_left_checklist"></td>
                                    <td class="td_left_header_checklist" style="vertical-align: top;"><input class="uraianPelanggaran" type="checkbox" name="uraian7" style="vertical-align: top; margin-right: 10px" title="Menampilkan Profesi Kesehatan / Rekomendasi Instansi Tertentu" />&nbsp;Menampilkan profesi kesehatan / rekomendasi instansi tertentu</td>
                                    <td></td>
                                    <td style="width: 10%;" colspan="6"><span class="uraian7" hidden="true"><textarea class="uPelanggaran uraian7 PROFESI_KESEHATAN" title="Menampilkan Profesi Kesehatan / Rekomendasi Instansi Tertentu" id="uraianProfesi" style="width: 98%; height: 75px;" name="UPELANGGARAN[]"></textarea></span></td>
                                </tr>
                                <tr class="hashTag">
                                    <td class="td_left_checklist"></td>
                                    <td class="td_left_header_checklist" style="vertical-align: top;"><input class="uraianPelanggaran" type="checkbox" name="uraian8" style="vertical-align: top; margin-right: 10px" title="Tidak Sesuai Norma Sosial" />&nbsp;Tidak sesuai norma sosial</td>
                                    <td></td>
                                    <td style="width: 10%;" colspan="6"><span class="uraian8" hidden="true"><textarea class="uPelanggaran uraian8 TIDAK_SESUAI_NORMA" title="Tidak Sesuai Norma Sosial" id="uraianNorma" style="width: 98%; height: 75px;" name="UPELANGGARAN[]"></textarea></span></td>
                                </tr>
                                <tr id="ditujukanKepadaUmum" class="infoTercantumRow rowIklan" hidden>
                                    <td class="td_left_checklist"></td>
                                    <td class="td_left_header_checklist" style="vertical-align: top;"><span style="margin-left: 28px;"><b>Ditujukan kepada umum</b></span></td>
                                    <td></td>
                                    <td style="width: 10%;" class="td_left" colspan="6">
                                        <input class="infoTercantum" type="radio" id="radioUmum1" name="info2[7][Ditujukan_Kepada_Umum]" value="+_Ditujukan Kepada Umum">
                                        <label  for="radioUmum1" style="width: 54px; height: 10px;" title="Ya">Ya</label>
                                        <span style="margin-left: 5px;"></span>
                                        <input class="infoTercantum" type="radio" id="radioUmum2" name="info2[7][Ditujukan_Kepada_Umum]" value="-_Ditujukan Kepada Umum">
                                        <label for="radioUmum2" style="width: 54px; height: 10px; background-color: #9d0101" title="Tidak">Tidak</label>
                                        <input type="text" class="infoTercantumVal" name="info2[7][Ditujukan_Kepada_Umum]" style="display: none"></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div style="height:5px;" id="expand6b"></div>

                    <!--6-->
                    <div class="expand" id="expand6"><a title="expand/collapse" href="#" style="display: block;">HASIL VERIFIKASI SIAMI</a></div>
                    <div class="collapse">
                        <div class="accCntnt" id="expand6a">
                            <table class="form_tabel_detail">
                                <tr>
                                    <td style="width: 2%;"></td>
                                    <td style="width: 50%;"></td>
                                    <td style="width: 13%;"></td>
                                    <td style="width: 35%; font-size: 14px; padding-left: 250px; padding-right: 250px; padding-bottom: 5px; padding-top: 5px;"></td>
                                </tr>
                                <tr>
                                    <td class="td_left_checklist"></td>
                                    <td class="td_left_header_checklist"><b>Hasil referensi dari SIAMI</b></td>
                                    <td></td>
                                    <td style="width: 10%;" class="td_left" colspan="6"><select class="stext" name="IKLANOBAT[SIAMI]" id="referensiSiami" title="Referensi SIAMI">
                                            <option value=""></option>
                                            <option value="Belum Disetujui">Belum disetujui</option>
                                            <option value="Tidak Sesuai Dengan Yang Disetujui">Tidak sesuai dengan yang di setujui</option>
                                            <option value="Sesuai Dengan Yang Disetujui">Sesuai dengan yang disetujui</option></select>&nbsp;&nbsp;&nbsp;<a href="http://siami.pom.go.id/" target="blank"><u><b>SIAMI</b></u></a></td>
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
                                <tr>
                                    <td class="td_left_checklist"></td>
                                    <td class="td_left_header_checklist"><b>Hasil Penilaian</b></td>
                                    <td></td>
                                    <td style="width: 10%;" class="td_left" colspan="6">
                                        <input type="text" id="kesimpulanHasilPenilaian" readonly size="22" title="Hasil Kesimpulan" value="<?php
                                        if ($sess['HASIL'] == 'TMK')
                                            echo 'Tidak Memenuhi Ketentuan';
                                        else
                                            echo 'Memenuhi Ketentuan';
                                        ?>" />
                                        <input type="hidden" id="kesimpulanHasilPenilaianVal" name="IKLAN[HASIL]" value="<?php
                                        if ($sess['HASIL'])
                                            echo $sess['HASIL'];
                                        else
                                            echo "MK";
                                        ?>" /></td>
                                </tr>
                                <?php
                                if (in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) {
                                    if ((!$sess['HASIL_PUSAT'] && in_array('2', $this->newsession->userdata('SESS_KODE_ROLE'))) || $editTL == 'YES') {
                                        ?>
                                        <tr><td class="td_left_checklist"></td><td class="td_left">Verifikasi Pusat</td><td></td><td class="td_right"><select class="stext verifikasiPusat" name="<?php echo 'IKLAN[HASIL_PUSAT]' ?>" rel="required" title="MK/TMK"><option></option><option value="MK" <?php if ($sess['HASIL_PUSAT'] == 'MK') echo 'Selected' ?>>Memenuhi Ketentuan</option><option value="TMK"  <?php if ($sess['HASIL_PUSAT'] == 'TMK') echo 'Selected' ?>>Tidak Memenuhi Ketentuan</option></select></td></tr>
                                        <tr class="vTMK" hidden><td class="td_left_checklist"></td><td class="td_left">Kategori Pelanggaran</td><td></td><td class="td_right"><select class="stext vTMKa" title="Kategori Pelanggaran"><option></option><option value="Minor" <?php if ($hasilKesimpulanOpt[0] == 'Minor') echo 'Selected' ?>>Minor</option><option value="Mayor" <?php if ($hasilKesimpulanOpt[0] == 'Mayor') echo 'Selected' ?>>Mayor</option><option value="Kritikal" <?php if ($hasilKesimpulanOpt[0] == 'Kritikal') echo 'Selected' ?>>Kritikal</option></select></td></tr>
                                        <tr class="vTMK" hidden><td class="td_left_checklist"></td><td class="td_left"style="background-color: white;">Tindak Lanjut</td><td></td><td class="td_right" style="background-color: white;"><?php echo form_dropdown('IKLAN[TL_PUSAT][]', $cb_tl, is_array($hasilKesimpulanOpt) ? $hasilKesimpulanOpt[1] : '', 'class="stext vTMK" id="vTMKSub" title="Tindak Lanjut Pusat"'); ?></td></tr>
                                        <tr class="vTMK2" hidden><td class="td_left_checklist"></td><td class="td_left"style="background-color: white;"></td><td></td><td class="td_right" style="background-color: white;"><?php echo form_dropdown('IKLAN[TL_PUSAT][]', $cb_tindakan, is_array($hasilKesimpulanOpt) ? $hasilKesimpulanOpt : '', 'class="stext multiselect vTMK2" multiple title="Tindak Lanjut Pusat. Untuk memilih lebih dari satu, klik + Ctrl"'); ?></td></tr>
                                        <tr class="vTMK2" hidden><td class="td_left_checklist"></td><td class="td_left">Surat Tindak Lanjut</td><td></td><td class="td_right"><input type="text" class="sdate vTMK2a" name="IKLAN[DETAIL_PUSAT][]" id="tglSuratTL" title="Tanggal Surat Tindak Lanjut" placeholder="Tanggal Surat" value="<?php echo $hasilKesimpulanOpt2[0]; ?>"/>&nbsp;&nbsp;&nbsp;Tanggal Surat Tindak Lanjut</td></tr>
                                        <tr class="vTMK2" hidden><td class="td_left_checklist"></td><td class="td_left"></td><td></td><td class="td_right"><input type="text" class="stext vTMK2a" name="IKLAN[DETAIL_PUSAT][]" id="stugas_"  title="Di isi dengan nomor surat tindak lanjut" placeholder="Nomor Surat Tindak Lanjut" value="<?php echo $hasilKesimpulanOpt2[1]; ?>"/>&nbsp;&nbsp;&nbsp;Nomor Surat Tindak Lanjut</td></tr>
                                        <tr class="vMK" hidden><td class="td_left_checklist"></td><td class="td_left" style="background-color: white;">Kategori MK</td><td></td><td class="td_right" style="background-color: white;"><select class="stext vMKa" title="Kategori MK"><option></option><option value="Iklan Sesuai Dengan Yang Disetujui" <?php if ($hasilKesimpulanOpt[0] == 'Iklan Sesuai Dengan Yang Disetujui') echo 'Selected' ?>>Iklan Sesuai Dengan Yang Disetujui</option><option value="Iklan Mencantumkan Informasi Sesuai Dengan Penandaan Terakhir Yang Disetujui" <?php if ($hasilKesimpulanOpt[0] == 'Iklan Mencantumkan Informasi Sesuai Dengan Penandaan Terakhir Yang Disetujui') echo 'Selected' ?>>Iklan Mencantumkan Informasi Sesuai Dengan Penandaan Terakhir Yang Disetujui</option><option id="mkPusatKeras" hidden value="Iklan Dapat Diterima Untuk Kalangan Terbatas Profesi Kesehatan" <?php if ($hasilKesimpulanOpt[0] == 'Iklan Dapat Diterima Untuk Kalangan Terbatas Profesi Kesehatan') echo 'Selected' ?>>Iklan Dapat Diterima Untuk Kalangan Terbatas Profesi Kesehatan</option></select></td></tr>
                                        <tr class="vJustifikasi" hidden><td class="td_left_checklist"></td><td class="td_left" style="background-color: white;">Justifikasi</td><td></td><td class="td_right" style="background-color: white;"><textarea name="JUSTIFIKASI" title="Justifikasi Pusat" class="stext chkJustifikasi" id="XXX" style="height: 140px"><?php echo $sess['JUSTIFIKASI_PUSAT']; ?></textarea></td></tr> <?php
                                    } else {
                                        if ($sess['HASIL_PUSAT'] == "TMK") {
                                            ?>
                                            <tr><td class="td_left">Verifikasi Pusat</td><td class="td_right"><b><i><?php
                                                            if ($sess['HASIL_PUSAT'] == 'MK')
                                                                echo 'Memenuhi Ketentuan';
                                                            else
                                                                echo 'Tidak Memenuhi Ketentuan';
                                                            ?></i></b></td></tr>
                                            <tr><td class="td_left">Kategori Pelanggaran</td><td class="td_right"><?php echo $hasil[0]; ?></td></tr>
                                            <?php if ($hasil[1] != NULL) { ?><tr><td class="td_left">Tindak Lanjut Pusat</td><td class="td_right"><?php
                                                if ($hasil[1] == 'TL')
                                                    echo 'Tindak Lanjut'; else if ($hasil[1] == 'STL')
                                                    echo 'Sudah Tindak Lanjut';
                                                else
                                                    echo 'Tidak Dapat Tindak Lanjut'
                                                    ?></td></tr><tr><td class="td_left"></td><td class="td_right"><ul style="list-style-type:decimal; padding-left:20px; margin:0;"><?php
                                                        $temp = array($hasil[2], $hasil[3]);
                                                        if ($hasil[3] != '')
                                                            echo "<li>" . join("</li><li>", $temp) . "</li>";
                                                        else
                                                            echo "<li>" . $hasil[2] . "</li>";
                                                        ?></ul></td></tr><?php if ($hasil[1] != NULL) { ?>
                                                    <tr><td class="td_left">Surat Tindak Lanjut</td><td class="td_right"><ul style="padding-left:20px; margin:0;"><?php
                                                                $temp2 = array($hasilKesimpulanOpt2[0], $hasilKesimpulanOpt2[1]);
                                                                if ($hasilKesimpulanOpt2[1] != '')
                                                                    echo "<li>Tanggal Surat: <b>" . join("</b></li><li>Nomor Surat: <b>", $temp2) . "</b></li>";
                                                                else
                                                                    echo "<li>Tanggal Surat: <b>" . $hasilKesimpulanOpt2[0] . "</b></li>";
                                                                ?></ul></td></tr><?php } if (($sess['JUSTIFIKASI_PUSAT'] != NULL || $sess['JUSTIFIKASI_PUSAT'] != "") && $sess['HASIL_PUSAT'] != $sess['HASIL']) { ?>
                                                    <tr><td class="td_left">Justifikasi Pusat</td><td class="td_right"><?php echo $sess['JUSTIFIKASI_PUSAT']; ?></td></tr>
                                                    <?php
                                                }
                                            }
                                        } else {
                                            ?>
                                            <tr><td class="td_left">Verifikasi Pusat</td><td class="td_right"><b><i><?php
                                                            if ($sess['HASIL_PUSAT'] == 'MK')
                                                                echo 'Memenuhi Ketentuan';
                                                            else
                                                                echo 'Tidak Memenuhi Ketentuan';
                                                            ?></i></b></td></tr>
                                            <tr><td class="td_left">Kategori MK</td><td class="td_right"><?php echo $hasil[0]; ?></td></tr>
                                            <?php if (($sess['JUSTIFIKASI_PUSAT'] != NULL || $sess['JUSTIFIKASI_PUSAT'] != "") && $sess['HASIL_PUSAT'] != $sess['HASIL']) { ?>
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
                    <div style="height:5px;"></div>

                    <!--8-->
                    <div class="expand"><a title="expand/collapse" href="#" style="display: block;">LAMPIRAN</a></div>
                    <div class="collapse">
                        <div class="accCntnt">
                            <table class="form_tabel_detail">
                                <tr>
                                    <td class="td_left_checklist" colspan="5" style="margin-right: 200px">
                                        <?php
                                        if (array_key_exists('FILE_IKLAN', $sess) && trim($sess['FILE_IKLAN']) != "") {
                                            ?><input type="hidden" name="IKLAN_OBAT[FILE_IKLAN]" value="<?php echo $sess['FILE_IKLAN']; ?>">
                                            <span class="file_FILE_IKLAN"><a href="<?php echo site_url(); ?>/download/penandaanIklanNoDirPostUpload/<?php echo 'iklan_001'; ?>/<?php echo $sess['FILE_IKLAN']; ?>" target="_blank">File Lampiran</a>&nbsp;&bull;&nbsp;<a href="#" class="del_upload" url="<?php echo site_url(); ?>/utility/uploads/del_upload_s/<?php echo 'iklan_001'; ?>/<?php echo $sess['FILE_IKLAN']; ?>" jns="FILE_IKLAN">Edit atau Hapus File ?</a></span>
                                            <span class="upload_FILE_IKLAN" hidden><input type="file" class="upload_FILE_IKLAN" jenis="FILE_IKLAN" allowed="jpg-jpeg-pdf-doc-docx-rar" url="<?php echo site_url(); ?>/utility/uploads/get_upload_s/<?php echo 'iklan_001'; ?>" id="fileToUpload_FILE_IKLAN" name="userfile" onchange="do_upload($(this));
                     return false;" /></span>
                                                <?php
                                            } else {
                                                ?>
                                            <span class="upload_FILE_IKLAN"><input type="file" class="upload" jenis="FILE_IKLAN" allowed="jpg-jpeg-pdf-doc-docx-rar" url="<?php echo site_url(); ?>/utility/uploads/get_upload_s/<?php echo 'iklan_001'; ?>" id="fileToUpload_FILE_IKLAN" name="userfile" onchange="do_upload($(this));
                     return false;" title="Lampiran" />
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

                <div style="padding:10px;"></div><div><a href="javascript:void(0)" id="btnSave" class="button <?php echo $icon; ?>" onclick="fpost('#fpengawasanIklan_001', '', '');">
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
        <input type="hidden" id="uraianPenilaian1" name="IKLANOBAT[PENILAIAN1]" />
        <input type="hidden" id="uraianPenilaian2" name="IKLANOBAT[PENILAIAN2]" />
        <input type="hidden" name="TUJUAN" value="<?php echo $tujuan; ?>" />
    </form>
</div>
</div>
<script type="text/javascript">
             function goBack()
             {
                 window.history.back()
             }
             function mediaIklan2() {
                 $("#eChoosed").val("");
                 $("#lrChoosed").val("");
                 $("#cChoosed").val("");
                 clear();
                 showHide();
                 cekLampiran();
             }
             function cekLampiran() {
                 var kesimpulan = $("#kesimpulanHasilPenilaian").val(), jenis = $("#iklan_media").val();
                 if ((kesimpulan === "Tidak Memenuhi Ketentuan" && jenis === "Cetak") || kesimpulan === "Tidak Memenuhi Ketentuan" && jenis === "Luar Ruang") {
                     $(".upload").attr("rel", "required");
                 }
                 else {
                     $(".upload").attr("rel", " ");
                 }
             }
             function cekInfoTercantum() {
                 $("input:radio.infoTercantum").each(function() {
                     var name = $(this).attr("name");
                     if ($(this).closest('.infoTercantumRow').attr("hidden") === false && $("#iklan_kelompok").val() !== "Kegiatan Promosi") {
                         $("input[type='text'][name='" + name + "']").attr("rel", "required");
                     }
                     else if ($(this).closest(".infoTercantumRow").attr("hidden") === true) {
                         $("input[type='text'][name='" + name + "']").attr("rel", "");
                     }
                 });
             }
             function cekInfoTambahan() {
                 $("input:radio.infoTambahan").each(function() {
                     var name = $(this).attr("name");
                     if ($(this).closest(".infoTambahanRow").attr("hidden") === false && $(this).closest('div').attr("hidden") === false) {
                         $("input[type='text'][name='" + name + "']").attr("rel", "required");
                     }
                     if ($(this).closest(".infoTambahanRow").attr("hidden") === true) {
                         $("input[type='text'][name='" + name + "']").attr("rel", " ");
                     }
                     if ($(this).closest('div').attr("hidden") === true) {
                         $("input[type='text'][name='" + name + "']").attr("rel", " ");
                     }
                 });
             }
             function showHide2(X) {
                 var param = "", targetAuto = "";
                 var kelompokIklan = $("#iklan_kelompok").val();
                 var media1 = ["TV", "Radio", "Iklan Baris", "Bioskop", "Megatron", "Lainnya"];
                 var media2 = ["Majalah", "Tabloid", "Buletin", "Halaman Kuning"];
//                      var media3 = ["Majalah", "Tabloid", "Buletin", "Surat Kabar", "TV", "Radio", "Internet", "Iklan Baris"];
                 var media3 = ["Majalah", "Tabloid", "Surat Kabar", "TV", "Radio", "Internet", "Buletin", "Iklan Baris"];
                 var mediaifElektronik = ["Majalah", "Tabloid", "Buletin", "Surat Kabar"];
                 if (typeof X === "object")
                     param = $(X).val();
                 else
                     param = X;
                 if (kelompokIklan === "Kegiatan Promosi") {
                     $(".promoBased").hide();
                     $(".promoBased").attr("rel", "");
                     $("#judulKegiatan").attr("rel", "required");
                     $("#judulKegiatanRow").show();
                 } else {
                     $(".promoBased").show();
                     $("#judulKegiatan").attr("rel", "");
                     $("#judulKegiatanRow").hide();
                     if ($.inArray(param, media1) > -1) {
                         $("#tayangTime").show();
                         $("#edisiTime").hide();
                         $(".edisiCetak").attr("rel", " ");
                         $(".edisiTV").attr("rel", "required");
                     } else if ($.inArray(param, media2) > -1) {
                         $("#tayangTime").hide();
                         $("#edisiTime").show();
                         $(".edisiCetak").attr("rel", "required");
                         $(".edisiTV").attr("rel", " ");
                     } else {
                         $("#tayangTime").hide();
                         $("#edisiTime").hide();
                         $(".edisiCetak").attr("rel", "");
                         $(".edisiTV").attr("rel", "");
                     }
                     if ($.inArray(param, media3) > -1) {
                         $("#namaMedia").show();
                         $(".namaMedia").attr("rel", "required");
                     } else {
                         $("#namaMedia").hide();
                         $(".namaMedia").attr("rel", "");
                     }
                     if ($.inArray(param, mediaifElektronik) < 0) {
                         $("#tglTerbit").hide();
                         $("#tglTugas").attr("rel", "");
                     } else {
                         $("#tglTerbit").show();
                         $("#tglTugas").attr("rel", "required");
                     }
                     if (param === "Internet") {
                         document.getElementById("namaMedia1").innerHTML = "Alamat Situs";
                     } else {
                         document.getElementById("namaMedia1").innerHTML = "Nama Media";
                     }
                     $("#namaMediaIklan").unautocomplete();
                     $(".ac_results").remove();
                     $("#namaMediaIklan").autocomplete($("#namaMediaIklan").attr("url") + param, {width: 244, selectFirst: false});
                     $("#namaMediaIklan").attr("name", "IKLAN[NAMA]");
                     $("#namaMediaIklan").result(function(event, data, formatted) {
                         if (data) {
                             $("#namaMediaIklan").attr("name", "");
                             $("#idMediaIklan").attr("name", "IKLAN[NAMA]");
                             $("#namaMediaIklan").val(data[1]);
                             $("#idMediaIklan").val(data[2]);
                         }
                     });
                 }
             }
             function mediaIklan(X) {
                 clear();
                 showHide2(X);
             }
             function sl_jenis_obat() {
                 var xxx = 0, isi_jenis_obat, nama = " ", nama1 = " ", nama2 = " ";
                 $(".obj_jenis_obat").hide();
                 $("#uraianPenilaian1").val("");
                 $(".infoTambahan").attr("checked", false);
                 $(".infoT").val("");
                 $(".infoT").attr("rel", " ");
                 $("select.sl_jenis_obat option:selected").each(function() {
                     isi_jenis_obat = $(this).attr("class");
                     $(".X").val("");
                     $(".X").html("");
                     if (isi_jenis_obat !== "" && isi_jenis_obat !== "J") {
                         xxx++;
                         if ($("#iklan_kelompok").val() !== "Kegiatan Promosi" || $("#iklan_kelompok").val() !== "Tanpa Indikasi") {
                             if (isi_jenis_obat === "I") {
                                 nama1 = $(".obat_A input").attr("name");
                                 nama2 = $(".obat_B input").attr("name");
                                 $(".obat_A").show();
                                 $(".obat_B").show();
                                 $("#expand3").fadeIn("slow");
                                 $("#expand3a").fadeIn("slow");
                                 $("#expand3b").fadeIn("slow");
                                 $("input[type='text'][name='" + nama1 + "']").attr("rel", "required");
                                 $("input[type='text'][name='" + nama2 + "']").attr("rel", "required");
                             } else if (isi_jenis_obat !== "I" && isi_jenis_obat !== "X") {
                                 nama = $(".obat_" + isi_jenis_obat + " input").attr("name");
                                 $(".obat_" + isi_jenis_obat).show();
                                 $("#expand3").fadeIn("slow");
                                 $("#expand3a").fadeIn("slow");
                                 $("#expand3b").fadeIn("slow");
                                 $("input[type='text'][name='" + nama + "']").attr("rel", "required");
                             } else {
                                 $('#expand3b').fadeOut("slow");
                                 $('#expand3a').fadeOut("slow");
                                 $('#expand3').fadeOut("slow");
                                 $("input[type='text'][name='" + nama1 + "']").attr("rel", " ");
                                 $("input[type='text'][name='" + nama2 + "']").attr("rel", " ");
                                 $("input[type='text'][name='" + nama + "']").attr("rel", " ");
                             }
                         }
                     }
                 });
                 if (xxx === 0) {
                     $('#expand3b').fadeOut("slow");
                     $('#expand3a').fadeOut("slow");
                     $('#expand3').fadeOut("slow");
                     $("input[type='text'][name='" + nama1 + "']").attr("rel", " ");
                     $("input[type='text'][name='" + nama2 + "']").attr("rel", " ");
                     $("input[type='text'][name='" + nama + "']").attr("rel", " ");
                 }
                 uraianTidakLengkap();
             }
             function sl_jenis_obat2() {
                 var isi_jenis_obat, a = "1";
                 $("select.sl_jenis_obat option:selected").each(function() {
                     isi_jenis_obat = $(this).val().split('_');
                     if (isi_jenis_obat !== '' && isi_jenis_obat[0] !== 'J') {
                         if (isi_jenis_obat[0] == "I") {
                             $(".obat_A").show();
                             $(".obat_B").show();
                         }
                         $('#expand3').fadeIn("slow");
                         $('#expand3a').fadeIn("slow");
                         $('#expand3b').fadeIn("slow");
                         $(".obat_" + isi_jenis_obat[0]).show();
                         $(".obat_" + isi_jenis_obat[0]).attr('hidden', false);
                         a = "2";
                     }
                 });
                 if (a === "2") {
                     var name = '<?php echo $sess['PENILAIAN1'] ?>'.split(',');
                     for (var i = 0; i < name.length; i++) {
                         $("input[type='radio'][value='" + name[i] + "']").attr('checked', 'checked');
                     }
                 }
                 var name2 = '<?php echo $sess['PENILAIAN2'] ?>'.split(',');
                 for (var i = 0; i < name2.length; i++) {
                     $("input[type='radio'][value='" + name2[i] + "']").attr('checked', 'checked');
                 }
                 $(".infoTercantum").each(function() {
                     var isi_info = $(this).val().split('_');
                     if ($(this).closest(".infoTercantumRow").attr("hidden") === false) {
                         var name = $(this).attr("name");
                         var selected = $("input[type='radio'][name='" + name + "']:checked").val();
                         $("input[type='text'][name='" + name + "']").val(selected);
                         checkList($(this));
                     }
                 });
                 $(".infoTambahan").each(function() {
                     var isi_info = $(this).val().split('_');
                     if ($(this).closest(".infoTambahanRow").attr("hidden") === false) {
                         var name = $(this).attr("name");
                         var selected = $("input[type='radio'][name='" + name + "']:checked").val();
                         $("input[type='text'][name='" + name + "']").val(selected);
                         checkList($(this));
                     }
                 });
             }
             function cekAll() {
                 var rE = false, Re = false, Re2 = false, Re3 = false;
                 $(".infoTercantum").each(function() {
                     if ($(this).is(":checked") === true) {
                         var a = $(this).val().split("_");
                         if (a[1] !== "Ditujukan Kepada Umum") {
                             if (a[0] === "-") {
                                 Re = true;
                             }
                         } else if (a[1] === "Ditujukan Kepada Umum") {
                             if (a[0] === "+") {
                                 Re = true;
                             }
                         }
                     }
                 });
                 $(".infoTambahan").each(function() {
                     if ($(this).is(":checked") === true) {
                         var a = $(this).val().split("_");
                         if (a[0] === "-") {
                             Re2 = true;
                         }
                     }
                 });
                 $(".uraianPelanggaran").each(function() {
                     if ($(".uraianPelanggaran:checked").length > 1) {
                         Re3 = true;
                     }
                 });
                 $(".uPelanggaran").each(function() {
                     if ($(this).val() !== "" && (Re === true || Re2 === true || Re3 === true)) {
                         rE = true;
                     } else if ($(this).val() === "" && (Re === true || Re2 === true || Re3 === true)) {
                         rE = true;
                     }
                 });
                 return rE;
             }
             function mkTmk() {
                 var x = $("#referensiSiami").val();
                 var XXX = $("#uraianTidakLengkap").val(), X = cekAll();
                 if (XXX === "") {
                     $(".tL").fadeOut("slow");
                 }
                 if (X === true || x === "Tidak Sesuai Dengan Yang Disetujui" || x === "Belum Disetujui") {
                     $("#kesimpulanHasilPenilaian").val("Tidak Memenuhi Ketentuan");
                     $("#kesimpulanHasilPenilaianVal").val("TMK");
                 } else if (X !== true) {
                     $("#kesimpulanHasilPenilaian").val("Memenuhi Ketentuan");
                     $("#kesimpulanHasilPenilaianVal").val("MK");
                 }
                 verifikasiPusat($(".verifikasiPusat"));
                 verifikasiTL($("#vTMKSub"));
                 cekLampiran();
             }
             function checkList(obj) {
                 var XXX = obj.attr("name"), xxx = obj.val(), X = "input:radio[name='" + XXX + "']", XX = xxx.split("_"), cls = obj.attr("class");
                 if ($(X).is(":checked")) {
                     if (cls === "infoTercantum") {
                         uraianPenilaian2();
                     }
                     if (cls === "infoTambahan") {
                         uraianPenilaian1();
                     }
                     uraianTidakLengkap();
                     mkTmk();
                     verifikasiPusat($(".verifikasiPusat"));
                     verifikasiTL($("#vTMKSub"));
                 }
             }
             function checkListTxt(XXX) {
                 var X = "input:checkbox[name='" + XXX + "']";
                 if ($(X).is(":checked")) {
                     $("." + XXX).show("");
                     $("." + XXX).attr("hidden", false);
                     $("." + XXX).attr("rel", "required");
                 } else {
                     $("." + XXX).hide("");
                     $("." + XXX).val("");
                     $("." + XXX).attr("hidden", true);
                     $("." + XXX).attr("rel", " ");
                 }
                 mkTmk();
             }
             function uraianPenilaian1() {
                 var Z = "", X = [], i = 0;
                 $(".infoTambahan").each(function() {
                     if ($(this).is(":checked") === true) {
                         Z = $(this).val();
                         X.push(Z);
                     }
                 });
                 $("#uraianPenilaian1").val(X);
             }
             function uraianPenilaian2() {
                 var Z = "", X = [], i = 0;
                 $(".infoTercantum").each(function() {
                     if ($(this).is(":checked") === true) {
                         Z = $(this).val();
                         X.push(Z);
                     }
                 });
                 $("#uraianPenilaian2").val(X);
             }
             function uraianTidakLengkap() {
                 var Z = "", X = [], i = 0, xxx = "";
                 $(".infoTambahan").each(function() {
                     if ($(this).is(":checked") === true) {
                         Z = $(this).val().split("_");
                         if (Z[0] === "-") {
                             X.push(Z[1]);
                         }
                     }
                 });
                 $(".infoTercantum").each(function() {
                     if ($(this).is(":checked") === true) {
                         Z = $(this).val().split("_");
                         if (Z[1] !== "Ditujukan Kepada Umum") {
                             if (Z[0] === "-") {
                                 X.push(Z[1]);
                             }
                         }
                     }
                 });
                 xxx = "" + X;
                 $("#uraianTidakLengkap").val(xxx.replace(/,/g, ", "));
                 if ($("#uraianTidakLengkap").val() != "")
                     $(".tL").show();
                 else if ($("#uraianTidakLengkap").val() == "")
                     $(".tL").hide();
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
                 var golonganObat = $("#golonganObat").val();
                 var jenisIklan = $("#iklan_media").val();
                 if (jenisIklan === "Cetak") {
                     $(".elektronikChoosed").hide();
                     $(".lRChoosed").hide();
                     $(".cetakChoosed").show("");
                     $("#cChoosed").attr("rel", "required");
                     $("#lrChoosed").attr("rel", "");
                     $("#eChoosed").attr("rel", "");
                 } else if (jenisIklan === "Elektronik") {
                     $(".lRChoosed").hide();
                     $(".cetakChoosed").hide();
                     $("#expand4").fadeIn("slow");
                     $("#expand4a").fadeIn("slow");
                     $("#expand4b").fadeIn("slow");
                     $("#deskripsiIklan").attr("rel", "required");
                     $(".elektronikChoosed").show("");
                     $("#cChoosed").attr("rel", "");
                     $("#lrChoosed").attr("rel", "");
                     $("#eChoosed").attr("rel", "required");
                 } else if (jenisIklan === "Luar Ruang") {
                     $(".elektronikChoosed").hide();
                     $(".cetakChoosed").hide();
                     $("#expand4").fadeIn("slow");
                     $("#expand4a").fadeIn("slow");
                     $("#expand4b").fadeIn("slow");
                     $(".lRChoosed").show();
                     $("#cChoosed").attr("rel", "");
                     $("#lrChoosed").attr("rel", "required");
                     $("#eChoosed").attr("rel", "");
                 }
                 if (kelompokIklan === "Dengan Indikasi") {
                     if (golonganObat !== "Keras") {
                         $(".hashTag").show();
                         $(".hashTag").attr("hidden", false);
                         $('#ditujukanKepadaUmum').fadeOut("slow");
                     }
                     else if (golonganObat === "Keras") {
                         $(".hashTag").hide();
                         $(".hashTag").attr("hidden", true);
                         $('#ditujukanKepadaUmum').fadeIn("slow");
                     }
                     $(".hashStar").show();
                     $(".hashStar").attr("hidden", false);
                     if ($("#iklan_media").val() === "Elektronik") {
                         $(".aav").hide();
                         $(".aav").attr("hidden", true);
                     } else {
                         if (golonganObat !== "Keras") {
                             $(".aav").show();
                             $(".aav").attr("hidden", false);
                         }
                     }
                     $("#expand2").fadeIn("slow");
                     $("#expand2a").fadeIn("slow");
                     $("#expand2a").attr("hidden", false);
                     $("#expand2b").fadeIn("slow");
                     if ($("#iklan_media").val() !== "Elektronik") {
                         $("#expand4").fadeOut("slow");
                         $("#expand4a").fadeOut("slow");
                         $("#expand4b").fadeOut("slow");
                         $("#deskripsiIklan").attr("rel", "");
                     }
                     $(".jenisObatChoosed").show("");
                     $(".sl_jenis_obat").attr("rel", "required");
                 }
                 else if (kelompokIklan === "Tanpa Indikasi") {
                     $(".jenisObatChoosed").fadeOut("slow");
                     $(".sl_jenis_obat").attr("rel", "");
                     if (golonganObat !== "Keras") {
                         $(".hashTag").show();
                         $(".hashTag").attr("hidden", false);
                         $('#ditujukanKepadaUmum').fadeOut("slow");
                     }
                     else if (golonganObat === "Keras") {
                         $(".hashTag").hide();
                         $(".hashTag").attr("hidden", true);
                         $('#ditujukanKepadaUmum').fadeIn("slow");
                     }
                     $(".hashStar").hide();
                     $(".hashStar").attr("hidden", true);
                     $("#expand2").fadeIn("slow");
                     $("#expand2a").fadeIn("slow");
                     $("#expand2a").attr("hidden", false);
                     $("#expand2b").fadeIn("slow");
                     $("#expand3").fadeOut("slow");
                     $("#expand3a").fadeOut("slow");
                     $("#expand3b").fadeOut("slow");
                     if ($("#iklan_media").val() !== "Elektronik") {
                         $("#expand4").fadeOut("slow");
                         $("#expand4a").fadeOut("slow");
                         $("#expand4b").fadeOut("slow");
                         $("#deskripsiIklan").attr("rel", "");
                     }
                 }
                 else if (kelompokIklan === "Kegiatan Promosi") {
                     $(".jenisObatChoosed").fadeOut("slow");
                     $(".sl_jenis_obat").attr("rel", "");
                     if (golonganObat !== "Keras") {
                         $(".hashTag").show();
                         $(".hashTag").attr("hidden", false);
                         $('#ditujukanKepadaUmum').fadeOut("slow");
                     }
                     else if (golonganObat === "Keras") {
                         $(".hashTag").hide();
                         $(".hashTag").attr("hidden", true);
                         $('#ditujukanKepadaUmum').fadeIn("slow");
                     }
                     $(".hashStar").show();
                     $(".hashStar").attr("hidden", false);
                     $("#expand3b").fadeOut("slow");
                     $("#expand3a").fadeOut("slow");
                     $("#expand3").fadeOut("slow");
                     if ($("#iklan_media").val() === "Cetak") {
                         $("#expand2").fadeOut("slow");
                         $("#expand3").fadeOut("slow");
                         $("#expand2a").fadeOut("slow");
                         $("#expand2a").attr("hidden", true);
                         $("#expand2b").fadeOut("slow");
                         $("#expand3a").fadeOut("slow");
                         $("#expand3b").fadeOut("slow");
                     } else {
                         $("#expand2").fadeOut("slow");
                         $("#expand3").fadeOut("slow");
                         $("#expand2a").fadeOut("slow");
                         $("#expand2a").attr("hidden", true);
                         $("#expand2b").fadeOut("slow");
                         $("#expand3a").fadeOut("slow");
                         $("#expand3b").fadeOut("slow");
                         $("#expand4").fadeIn("slow");
                         $("#expand4a").fadeIn("slow");
                         $("#expand4b").fadeIn("slow");
                         $("#deskripsiIklan").attr("rel", "required");
                     }
                 }
                 if (golonganObat !== "Keras") {
                     $("#expand6").show();
                     $("#expand6b").show();
                     $("#referensiSiami").attr("rel", "required");
                     $("#mkPusatKeras").hide();
                 } else if (golonganObat === "Keras") {
                     $("#expand6").hide();
                     $("#expand6b").hide();
                     $("#referensiSiami").attr("rel", "");
                     $("#mkPusatKeras").show();
                 }
                 cekInfoTercantum();
                 cekInfoTambahan();
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
                                 jAlert(data.error, "SIPT Versi 1.0");
                             } else {
                                 if (arrdata[2] == "FILE_IKLAN") {
                                     $("#fileToUpload_" + arrdata[2] + "").removeAttr("rel");
                                     $(".upload_" + arrdata[2] + "").hide();
                                     $("#file_" + arrdata[2] + "").hide();
                                     $(".file_" + arrdata[2] + "").html("<b>1 File telah dilampirkan. </b>&nbsp;<a href=\"<?php echo site_url(); ?>/download/penandaanIklanNoDirPreUpload/" + arrdata[3] + "/" + arrdata[0] + "\" target=\"_blank\">Tampilkan File</a>&nbsp;&bull;&nbsp;<a href=\"#\" class=\"del_upload\" url=\"<?php echo site_url(); ?>/utility/uploads/del_upload_s/" + arrdata[3] + "/" + arrdata[0] + "\" jns=" + arrdata[2] + ">Edit atau Hapus File ?</a><input type=\"hidden\" name=\"IKLAN_OBAT[" + arrdata[2] + "]\" value=" + arrdata[4] + ">");
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
             function verifikasiPusat(X) {
                 if ($(X).val() === "MK") {
                     $(".vMK").show();
                     $(".vMK").attr("rel", "required");
                     $(".vMKa").attr("rel", "required");
                     $(".vMKa").attr("name", "IKLAN[TL_PUSAT]");
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
                     $(".vMK").hide();
                     $(".vMK").attr("rel", " ");
                     $(".vMK").val("");
                     $(".vMKa").attr("rel", " ");
                     $(".vMKa").attr("name", " ");
                     $(".vMKa").val("");
                     $(".vTMK").show();
                     $(".vTMK").attr("rel", "required");
                     $(".vTMKa").attr("rel", "required");
                     $(".vTMKa").attr("name", "IKLAN[TL_PUSAT][]");
                 } else {
                     $(".vMK").hide();
                     $(".vMK").attr("rel", " ");
                     $(".vMK").val("");
                     $(".vMKa").attr("rel", " ");
                     $(".vMKa").attr("name", " ");
                     $(".vMKa").val("");
                     $(".vMK").hide();
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

//          function namaMedia() {
//           $("#namaMediaIklan").result(function(event, data, formatted) {
//            if (data) {
//             console.log(data);
//             $("#namaMediaIklan").attr("name", "");
//             $("#idMediaIklan").attr("name", "IKLAN[NAMA]");
//             $("#namaMediaIklan").val(data[1]);
//             $("#idMediaIklan").val(data[2]);
//            }
//           });
//          }

             $(document).ready(function() {
                 $("textarea.chkJustifikasi").redactor({
                     buttons: ['bold', 'italic', '|', 'unorderedlist', 'orderedlist', 'outdent', 'indent', '|', 'alignleft', 'aligncenter', 'alignright', 'justify'],
                     removeStyles: false,
                     cleanUp: true,
                     autoformat: true
                 });
                 //                      load data edit
<?php if (array_key_exists("IKLAN_ID", $sess)) { ?>
                     $("#iklan_kelompok option[value='<?php echo $sess["KELOMPOK_IKLAN"]; ?>']").attr("selected", "selected");
                     $("#iklan_media option[value='<?php echo $sess["JENIS_IKLAN"]; ?>']").attr("selected", "selected");
                     $(".mediaIklanEdit option[value='<?php echo $sess["MEDIA"]; ?>']").attr("selected", "selected");
                     $("#referensiSiami option[value='<?php echo $sess["VERIFIKASI_SIAMI"]; ?>']").attr("selected", "selected");
                     $("[name='IKLAN[EDISI1]'] option[value='<?php echo $edisiMedia[0]; ?>']").attr("selected", "selected");
                     $("[name='IKLAN[EDISI2]'] option[value='<?php echo $edisiMedia[1]; ?>']").attr("selected", "selected");
                     $("[name='IKLAN[TAYANG1]'] option[value='<?php echo $tayangMedia[0]; ?>']").attr("selected", "selected");
                     $("[name='IKLAN[TAYANG2]'] option[value='<?php echo $tayangMedia[1]; ?>']").attr("selected", "selected");
                     var gObatEdit = [];
                     if ("<?php echo $UP[1]; ?>" !== " " && "<?php echo $UP[1]; ?>" !== "") {
                         $("input:checkbox[name='uraian2']").attr("checked", "checked");
                         $("#uraianTidakObyektif").val("<?php echo $UP[1]; ?>");
                         checkListTxt("uraian2");
                     }
                     if ("<?php echo $UP[2]; ?>" !== " " && "<?php echo $UP[2]; ?>" !== "") {
                         $("input:checkbox[name='uraian3']").attr("checked", "checked");
                         $("#uraianKlaimBerlebihan").val("<?php echo $UP[2]; ?>");
                         checkListTxt("uraian3");
                     }
                     if ("<?php echo $UP[3]; ?>" !== " " && "<?php echo $UP[3]; ?>" !== "") {
                         $("input:checkbox[name='uraian4']").attr("checked", "checked");
                         $("#uraianTestimoni").val("<?php echo $UP[3]; ?>");
                         checkListTxt("uraian4");
                     }
                     if ("<?php echo $UP[4]; ?>" !== " " && "<?php echo $UP[4]; ?>" !== "") {
                         $("input:checkbox[name='uraian5']").attr("checked", "checked");
                         $("#uraianPemberianHadiah").val("<?php echo $UP[4]; ?>");
                         checkListTxt("uraian5");
                     }
                     if ("<?php echo $UP[5]; ?>" !== " " && "<?php echo $UP[5]; ?>" !== "") {
                         $("input:checkbox[name='uraian7']").attr("checked", "checked");
                         $("#uraianProfesi").val("<?php echo $UP[5]; ?>");
                         checkListTxt("uraian7");
                     }
                     if ("<?php echo $UP[6]; ?>" !== " " && "<?php echo $UP[6]; ?>" !== "") {
                         $("input:checkbox[name='uraian8']").attr("checked", "checked");
                         $("#uraianNorma").val("<?php echo $UP[6]; ?>");
                         checkListTxt("uraian8");
                     }
                     gObatEdit.push("<?php echo $sess2[0]["JENIS_PRODUK"]; ?>");
                     if (gObatEdit !== "") {
                         sl_jenis_obat2();
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
                     if ("<?php echo $this->newsession->userdata("SESS_BBPOM_ID") ?>" === "92") {
                         verifikasiPusat($(".verifikasiPusat"));
                         verifikasiTL($("#vTMKSub"));
                     }
                     uraianPenilaian1();
                     uraianPenilaian2();
                     showHide();
                     showHide2("<?php echo $sess["MEDIA"]; ?>");
<?php } ?>
                 //                      akhir load data edit

                 $("input.namaObat").autocomplete($("input.namaObat").attr("url") + "1", {width: 244, selectFirst: false});
                 $("input.namaObat").result(function(event, data, formatted) {
                     if (data) {
                         $("input.namaObat").val(data[1]);
                         $("#namaPemilikNIE").val(data[3]);
                         $("#bentukSediaan").val(data[9]);
                         $("#NIE").val(data[2]);
                         var golonganObat = data[2].substring(2, 1);
                         if (golonganObat === "K") {
                             $("#golonganObat").val("Keras");
                             $("#ditujukanKepadaUmum").show("");
                             $("#expand6").fadeOut("slow");
                             $("#expand6a").fadeOut("slow");
                             $("#expand6b").fadeOut("slow");
                             $("#referensiSiami").attr("rel", " ");
                         }
                         else if (golonganObat === "B") {
                             $("#golonganObat").val("Bebas");
                             $("#ditujukanKepadaUmum").fadeOut("slow");
                             $("#expand6").show("");
                             $("#expand6a").show("");
                             $("#expand6b").show("");
                             $("#referensiSiami").attr("rel", "required");
                         }
                         else if (golonganObat === "T") {
                             $("#golonganObat").val("Bebas Terbatas");
                             $("#ditujukanKepadaUmum").fadeOut("slow");
                             $("#expand6").show("");
                             $("#expand6a").show("");
                             $("#expand6b").show("");
                             $("#referensiSiami").attr("rel", "required");
                         }
                         showHide();
                     }
                 });
//           $("#namaMediaIklan").result(function(event, data, formatted) {
//            if (data) {
//             $("#namaMediaIklan").attr("name", "");
//             $("#idMediaIklan").attr("name", "IKLAN[NAMA]");
//             $("#namaMediaIklan").val(data[1]);
//             $("#idMediaIklan").val(data[2]);
//            }
//           });
                 $(".addnomor").click(function() {
                     var kelompokIklan = $("#iklan_kelompok").val();
                     var nom = $(this).attr("terakhir"), idtr = $(this).attr("periksa"), cls = idtr + nom;
                     if (kelompokIklan === "Dengan Indikasi") {
                         $("#tb_obat").append('<tr class= "' + cls + '"><td>&nbsp;</td></tr><tr class= "' + cls + '"><td width="150">Nama Obat</td><td><input type="text" size="40" name="PRODUK[NAMA][]" class="namaObat' + cls + '" url="<?php echo site_url(); ?>/autocompletes/autocomplete/produk_reg_2/" title="Nama Obat" >&nbsp;&nbsp;<a href="javascript:void(0)" class="min" id="minCls' + cls + '" ><img src="<?php echo base_url(); ?>images/cancel.png" align="top" style="border:none" title="Hapus Obat" /></a><input type="hidden" name="BBPOM[BBPOM_ID][]" id="bbpomid' + cls + '"><input type="hidden" name="BBPOM[MBBPOM_ID][]" id="mbbpomid' + cls + '"></td></tr><tr class= "' + cls + '"><td width="150">Bentuk Sediaan</td><td><input type="text" size="40" name="PRODUK[BENTUKSEDIAAN][]" id="bentukSediaan' + cls + '" title="Bentuk Sediaan" /></td></tr><tr class= "' + cls + '"><td width="150">Nama Pemilik Izin Edar</td><td><input type="text" size="40" name="PRODUK[NAMAPEMILIKIZINEDAR][]" id="namaPemilikNIE' + cls + '" title="Pemilik Izin Edar"/></td></tr><tr class= "' + cls + '"><td width="150">Nomor Izin Edar</td><td><input type="text" size="40" name="PRODUK[NIE][]" id="NIE' + cls + '" title="Nomor Izin Edar"/></td></tr><tr class= "' + cls + '"><td>Golongan Obat</td><td><input type="text" size="40" name="PRODUK[GOLONGAN][]" class="golonganObat" id="golonganObat' + cls + '" title="Golongan Obat" /></td></tr></tr><tr class="jenisObatChoosed ' + cls + '"><td>Jenis Obat</td><td><select name="PRODUK[JENIS][]" id="jenis_obat' + cls + '" class="sl_jenis_obat" onChange="sl_jenis_obat();" title="Jenis Obat"><option></option><option value="A_Obat Mengandung Antihistamin" class="A">Obat Mengandung Antihistamin</option><option value="B_Obat Mengandung Nasal Dekongestan" class="B">Obat Mengandung Nasal Dekongestan</option><option value="C_Obat Tetes Mata Mengandung Benzalkonium Chloride" class="C">Obat Tetes Mata Mengandung Benzalkonium Chloride</option><option value="D_Obat Pencahar" class="D">Obat Pencahar</option><option value="E_Obat Diare kecuali Oralit" class="E">Obat Diare kecuali Oralit</option><option value="F_Obat Cacing" class="F">Obat Cacing</option><option value="G_Obat Maag" class="G">Obat Maag</option><option value="H_Obat Infeksi Jamur Kulit Topikal" class="H">Obat Infeksi Jamur Kulit Topikal</option><option value="I_Obat Mengandung Antihistamin Dan Nasal Dekongestan" class="I">Obat Mengandung Antihistamin Dan Nasal Dekongestan</option><option value="J_Obat Kelompok Umum (Tanpa informasi tambahan)" class="J">Obat Kelompok Umum (Tanpa informasi tambahan)</option></select></td></tr>');
                     }
                     else {
                         $("#tb_obat").append('<tr class= "' + cls + '"><td>&nbsp;</td></tr><tr class= "' + cls + '"><td width="150">Nama Obat</td><td><input type="text" size="40" name="PRODUK[NAMA][]" class="namaObat' + cls + '" url="<?php echo site_url(); ?>/autocompletes/autocomplete/produk_reg_2/" title="Nama Obat" >&nbsp;&nbsp;<a href="javascript:void(0)" class="min" id="minCls' + cls + '" ><img src="<?php echo base_url(); ?>images/cancel.png" align="top" style="border:none" title="Hapus Obat" /></a><input type="hidden" name="BBPOM[BBPOM_ID][]" id="bbpomid' + cls + '"><input type="hidden" name="BBPOM[MBBPOM_ID][]" id="mbbpomid' + cls + '"></td></tr><tr class= "' + cls + '"><td width="150">Bentuk Sediaan</td><td><input type="text" size="40" name="PRODUK[BENTUKSEDIAAN][]" id="bentukSediaan' + cls + '" title="Bentuk Sediaan" /></td></tr><tr class= "' + cls + '"><td width="150">Nama Pemilik Izin Edar</td><td><input type="text" size="40" name="PRODUK[NAMAPEMILIKIZINEDAR][]" id="namaPemilikNIE' + cls + '" title="Pemilik Izin Edar"/></td></tr><tr class= "' + cls + '"><td width="150">Nomor Izin Edar</td><td><input type="text" size="40" name="PRODUK[NIE][]" id="NIE' + cls + '" title="Nomor Izin Edar"/></td></tr><tr class= "' + cls + '"><td>Golongan Obat</td><td><input type="text" size="40" name="PRODUK[GOLONGAN][]" class="golonganObat" id="golonganObat' + cls + '" title="Golongan Obat" /></td></tr></tr><tr class="jenisObatChoosed ' + cls + '" hidden><td>Jenis Obat</td><td><select name="PRODUK[JENIS][]" id="jenis_obat' + cls + '" class="sl_jenis_obat" onChange="sl_jenis_obat();" title="Jenis Obat"><option></option><option value="A_Obat Mengandung Antihistamin" class="A">Obat Mengandung Antihistamin</option><option value="B_Obat Mengandung Nasal Dekongestan" class="B">Obat Mengandung Nasal Dekongestan</option><option value="C_Obat Tetes Mata Mengandung Benzalkonium Chloride" class="C">Obat Tetes Mata Mengandung Benzalkonium Chloride</option><option value="D_Obat Pencahar" class="D">Obat Pencahar</option><option value="E_Obat Diare kecuali Oralit" class="E">Obat Diare kecuali Oralit</option><option value="F_Obat Cacing" class="F">Obat Cacing</option><option value="G_Obat Maag" class="G">Obat Maag</option><option value="H_Obat Infeksi Jamur Kulit Topikal" class="H">Obat Infeksi Jamur Kulit Topikal</option><option value="I_Obat Mengandung Antihistamin Dan Nasal Dekongestan" class="I">Obat Mengandung Antihistamin Dan Nasal Dekongestan</option><option value="J_Obat Kelompok Umum (Tanpa informasi tambahan)" class="J">Obat Kelompok Umum (Tanpa informasi tambahan)</option></select></td></tr>');
                     }
                     $(this).attr('terakhir', parseInt(nom) + 1);
                     $("input.namaObat" + cls).autocomplete($("input.namaObat").attr("url") + '1', {width: 244, selectFirst: false});
                     $("input.namaObat" + cls).attr('rel', 'required');
                     $("#jenis_obat" + cls).attr('rel', 'required');
                     $("#minCls" + cls).click(function() {
                         var X = $('#jenis_obat' + cls).val().split('_');
                         $("#uraianPenilaian1").val('');
                         $(".obat_" + X[0]).hide();
                         $('.' + cls).remove();
                     });
                     $("input.namaObat" + cls).result(function(event, data, formatted) {
                         if (data) {
                             var golonganObat = data[2].substring(2, 1);
                             $(this).val(data[1]);
                             $("#namaPemilikNIE" + cls).val(data[3]);
                             $("#bentukSediaan" + cls).val(data[4]);
                             $("#NIE" + cls).val(data[2]);
                             if (golonganObat === 'K') {
                                 golonganObat = 'Keras';
                                 $('#ditujukanKepadaUmum').show("");
                                 $('#expand6').fadeOut("slow");
                                 $('#expand6b').fadeOut("slow");
                                 $('#referensiSiami').attr("rel", " ");
                             }
                             else if (golonganObat === 'B') {
                                 golonganObat = 'Bebas';
                                 $('#ditujukanKepadaUmum').fadeOut("slow");
                                 $('#expand6').show("");
                                 $('#expand6b').show("");
                                 $('#referensiSiami').attr("rel", "required");
                             }
                             else if (golonganObat === 'T') {
                                 golonganObat = 'Bebas Terbatas';
                                 $('#ditujukanKepadaUmum').fadeOut("slow");
                                 $('#expand6').show("");
                                 $('#expand6b').show("");
                                 $('#referensiSiami').attr("rel", "required");
                             }
                             $("#namaObat" + cls).val(data[1]);
                             $("#golonganObat" + cls).val(golonganObat);
                             $("#mbbpomid" + cls).val(data[2]);
                             //$("input.op").autocomplete($("input.op").attr("url") + $("#bbpomid" + cls).val(), {width: 244, selectFirst: false});
                         }
                     });
                     $('select, textarea, input:not(:image, submit, checkbox, radio)').poshytip({className: 'tip-twitter', showTimeout: 1, alignTo: 'target', alignX: 'right', alignY: 'center', offsetX: 5, allowTipHover: false, fade: false, slide: false});
                 });
                 $("input.sdate").datepicker({dateFormat: 'dd/mm/yy', regional: 'id'});
                 $("#iklan_kelompok").change(function() {
                     if ($(this).val() !== "Kegiatan Promosi") {
                         $(".promoBased").show();
                         $("#judulKegiatan").attr("rel", "");
                         $("#judulKegiatanRow").hide();
                     } else {
                         $(".promoBased").hide();
                         $(".promoBased").attr("rel", "");
                         $("#judulKegiatan").attr("rel", "required");
                         $("#judulKegiatanRow").show();
                     }
                     $('#uraianTidakLengkap').val('');
                     $(".infoTercantum").attr("checked", false);
                     $(".infoTercantumVal").val("");
                     $("#iklan_media").val("");
                     $(".mediaIklanEdit").val("");
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
                 $(".infoTercantum").click(function() {
                     var name = $(this).attr("name");
                     var selected = $("input[type='radio'][name='" + name + "']:checked").val();
                     $("input[type='text'][name='" + name + "']").val(selected);
                     $(this).closest("tr").css('border-left', '0px');
                     $(this).closest("tr").css('border-right', '0px solid #F00');
                     checkList($(this));
                 });
                 $(".infoTambahan").click(function() {
                     var name = $(this).attr("name");
                     var selected = $("input[type='radio'][name='" + name + "']:checked").val();
                     $("input[type='text'][name='" + name + "']").val(selected);
                     $(this).closest("tr").css('border-left', '0px');
                     $(this).closest("tr").css('border-right', '0px solid #F00');
                     checkList($(this));
                 });
                 $("#referensiSiami").change(function() {
                     mkTmk();
                 });
                 $(".uraianPelanggaran").click(function() {
                     checkListTxt($(this).attr("name"));
                 });
                 $(".uPelanggaran").change(function() {
                     mkTmk();
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
                             if (jenis !== "FILE_IKLAN")
                                 $("#fileToUpload_" + jenis + "").attr("rel", "");
                         }
                     });
                     return false;
                 });
                 $(".verifikasiPusat").change(function() {
                     verifikasiPusat($(this));
                 });
                 $("#vTMKSub").change(function() {
                     verifikasiTL($(this));
                 });
                 $("#provkotAlamat").change(function() {
                     var kunci = $(this).val();
                     if (kunci !== "")
                         $('#kabkotAlamat').attr("rel", "required");
                     else
                         $('#kabkotAlamat').attr("rel", "");
                     $.get('<?php echo site_url(); ?>/get/iklan_penandaan/set_provinsi/' + kunci, function(hasil) {
                         hasil = hasil.replace(' ', '');
                         if (hasil != "") {
                             $('#kabkotAlamat').html(hasil);
                         }
                     });
                 });

             });</script>