<?php
if (!defined('BASEPATH'))
  exit('No direct script access allowed');
error_reporting(E_ERROR);
?>
<link type="text/css" href="<?php echo base_url(); ?>css/iklanPenandaan.css" rel="stylesheet" media="screen"/>
<div id="judulpmnpdd" class="judul"></div>
<div class="headersarana">PENGAWASAN PENANDAAN -  PRODUK TEMBAKAU</div>
<?php
$detail = explode('#', $sess['PENILAIAN']);
foreach ($detail as $k) {
  $d[] = explode('_', $k);
}
$detail2 = explode('^', $sess['URAIAN']);
?>
<div class="content">
  <form action="<?php echo $act; ?>" method="post" autocomplete="off" id="fpengawasanPenandaan_007">
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
                  <input type="text" class="sdate" name="PENANDAAN[TANGGALAWAL]" id="tglAwalPengawasan<?php echo $i; ?>" title="Tanggal Pengawasan Iklan" onchange="comp('A')" rel="required" value="<?php echo $sess['TANGGAL_MULAI']; ?>"/>&nbsp; sampai dengan&nbsp;
                  <input type="text" class="sdate" name="PENANDAAN[TANGGALAKHIR]" id="tglAkhirPengawasan<?php echo $i; ?>" title="Tanggal Pengawasan Iklan" onchange="comp('B')" rel="required" value="<?php echo $sess['TANGGAL_AKHIR']; ?>"/></td>
              </tr>
              <tr>
                <td class="td_left">Lokasi Pembelian</td><td class="td_right"><input type="text" class="stext" name="PENANDAAN[SARANA]" id="saranaid_" url="<?php echo site_url(); ?>/autocompletes/autocomplete/sarana" title="Pilih salah satu Nama Sarana" value="<?php echo $sess['NAMA_SARANA']; ?>" rel="required"/><input type="hidden"  name="PENANDAAN[SARANAID]" id="saranaidval_" value="<?php echo $sess['SARANA_ID']; ?>" /></td>
              </tr>
              <tr>
                <td class="td_left">Tanggal Pembelian</td><td class="td_right"><input type="text" class="sdate" name="PENANDAAN[TANGGALBELI]" id="tglBeli<?php echo $i; ?>" title="Tanggal Pengawasan Iklan" onchange="comp('C')" rel="required" value="<?php echo $sess['TANGGAL_AKHIR']; ?>"/></td>
              </tr>
              <tr>
                <td class="td_left">Alamat Pembelian</td><td class="td_right"><textarea class="stext" id="alamatPengambilan" title="Alamat Sampling, Sarana" style="width: 240px; height: 50px;" name="PENANDAAN[ALAMAT]" readonly><?php
                    if (array_key_exists('ALAMAT_1', $sess)) {
                      echo $sess['ALAMAT_1'] . ", " . $sess['KOTA'] . ", " . $sess['PROPINSI'];
                    }
                    ?></textarea></td>
              </tr>
            </table>
          </div>
        </div><!-- Akhir Pemeriksaan !-->
        <div style="height:5px;"></div>
        <div class="acco2"><div class="expand"><a title="expand/collapse" href="#" style="display: block;">INFORMASI PRODUK TEMBAKAU - PENANDAAN</a></div>
          <div class="collapse">
            <div class="accCntnt">
              <table class="form_tabel">
                <tr>
                  <td class="td_left">Nama Merk Produk Tembakau </td><td class="td_right"><input type="text" class="stext" id="" title="Nama Produk" rel="required" name="PENANDAANPRODUK[NAMA_PRODUK]" value="<?php echo $sess['NAMA_PRODUK'] ?>" /></td>
                  <td colspan="2"></td>
                </tr>
                <tr>
                  <td class="td_left">Produsen</td><td class="td_right"><input type="text" class="stext" id="produsen" title="Nama Produsen" readonly name="PENANDAANPRODUK[PRODUSEN]" value="<?php echo $sess['PRODUSEN'] ?>"/></td>
                  <td colspan="2"></td>
                </tr>
                <tr>
                  <td class="td_left">Alamat Produsen</td><td class="td_right"><textarea id="alamatProdusen" class="stext" style="width: 240px; height: auto" readonly title="Alamat Produsen" name="PENANDAANPRODUK[ALAMAT_PRODUSEN]"><?php echo $sess['ALAMAT_PRODUSEN'] ?></textarea></td>
                  <td colspan="2"></td>
                </tr>
                <tr>
                  <td class="td_left">Jenis Produk Tembakau</td><td class="td_right"><textarea id="jenisProduk" class="stext" style="width: 240px; height: auto" readonly title="Alamat Produsen" name="PENANDAANPRODUK[ALAMAT_PRODUSEN]"><?php echo $sess['ALAMAT_PRODUSEN'] ?></textarea></td>
                  <td colspan="2"></td>
                </tr>
                <tr>
                  <td class="td_left">Bentuk Kemasan Produk Tembakau</td><td class="td_right"><textarea id="bentukKemasan" class="stext" style="width: 240px; height: auto" readonly title="Alamat Produsen" name="PENANDAANPRODUK[ALAMAT_PRODUSEN]"><?php echo $sess['ALAMAT_PRODUSEN'] ?></textarea></td>
                  <td colspan="2"></td>
                </tr>
              </table>
            </div>
          </div>
        </div>
        <div style="height:5px;"></div>

        <!-- DIV Detail-->
        <div class="expand" id="expand1"><a title="expand/collapse" href="#" style="display: block;">PENGAWASAN  PENCANTUMAN PERINGATAN KESEHATAN </a></div>
        <div class="collapse">
          <div class="accCntnt">
            <table class="form_tabel">
              <tr>
                <td style="width: 30%; background-color: white"></td>
                <td style="width: 35%; background-color: white; font-size: 14px; padding-left: 250px; padding-right: 250px; padding-bottom: 5px; padding-top: 5px;"></td>
              </tr>
              <tr></tr>
              <tr>
                <td style="width: 30%;"></td>
                <td style="width: 70%;" class="td_left">
                  <input type="radio" name="penandaan[1][Nasal_dekongestan]">
                  <label style="width: 70px; height: 10px;" title="Ada / Sesuai">Ya</label>
                  <span style="margin-left: 5px;"></span>
                  <input  type="radio" name="penandaan[1][Nasal_dekongestan]">
                  <label for="radioA3" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak Sesuai">Tidak</label>
                </td>
              </tr>
              <tr>
                <td class="td_left_header_checklist" style="vertical-align: top"><b>A. Kewajiban Pencantuman Peringatan Kesehatan</b></td>
                <td class="td_left">
                </td>
              </tr>
              <tr class="infoPenandaanRokokRow">
                <td class="td_left_header_checklist" style="vertical-align: top">1. Mencantumkan peringatan kesehatan berbentuk gambar dan tulisan</td>
                <td class="td_left">
                  <input class="uraianPenandaan romawi1Chk" param="romawi1" type="radio" id="radioA1" name="CHK[1]" value="+_No Bets" <?php if ($d[0][0] == '+') echo 'checked'; ?>>
                  <label for="radioA1" style="width: 70px; height: 10px;" title="Ada / Sesuai"></label>
                  <span style="margin-left: 5px;"></span>
                  <input class="uraianPenandaan romawi1Chk" param="romawi1" type="radio" id="radioA3" name="CHK[1]" value="-_No Bets" <?php if ($d[0][0] == '-') echo 'checked'; ?>>
                  <label for="radioA3" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak Sesuai"></label>
                  <input type="text" name="CHK[1]"  value="<?php echo $detail[0]; ?>" style="display: none;"  rel="required">
                </td>
              </tr>
              <tr class="romawi1 infoPenandaanRokokRow" hidden>
                <td><b>Jenis Gambar dan tulisan</b></td>
                <td>&nbsp;</td>
              </tr>
              <tr class="romawi1 infoPenandaanRokokRow" hidden>
                <td>Gambar 1 : Gambar kanker mulut</td>
                <td class="td_left">
                  <input class="uraianPenandaan romawi1Chk" type="radio" id="aradioA1" name="CHK[1][1]" value="+_Gambar kanker mulut" <?php if ($d[0][0] == '+') echo 'checked'; ?>>
                  <label for="aradioA1" style="width: 70px; height: 10px;" title="Ada / Sesuai"></label>
                  <span style="margin-left: 5px;"></span>
                  <input class="uraianPenandaan romawi1Chk" type="radio" id="aradioA2" name="CHK[1][1]" value="-_Gambar kanker mulut" <?php if ($d[0][0] == '-') echo 'checked'; ?>>
                  <label for="aradioA2" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak Sesuai"></label>
                  <input type="text" class="romawi1Val" name="CHK[1][1]" style="display: none"  value="<?php echo $detail[0]; ?>">
                </td>
              </tr>
              <tr class="romawi1 infoPenandaanRokokRow" hidden>
                <td>Tulisan 1 : Merokok sebabkan kanker mulut</td>
                <td class="td_left">
                  <input class="uraianPenandaan romawi1Chk" type="radio" id="aradioB1" name="CHK[1][2]" value="+_Merokok sebabkan kanker mulut" <?php if ($d[0][0] == '+') echo 'checked'; ?>>
                  <label for="aradioB1" style="width: 70px; height: 10px;" title="Ya"></label>
                  <span style="margin-left: 5px;"></span>
                  <input class="uraianPenandaan romawi1Chk" type="radio" id="aradioB2" name="CHK[1][2]" value="-_Merokok sebabkan kanker mulut" <?php if ($d[0][0] == '-') echo 'checked'; ?>>
                  <label for="aradioB2" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak"></label>
                  <input type="text" class="romawi1Val" name="CHK[1][2]" style="display: none" value="<?php echo $detail[0]; ?>">
                </td>
              </tr>
              <tr class="romawi1 infoPenandaanRokokRow" hidden>
                <td>Gambar 2 : Gambar orang merokok dengan asap yang membentuk tengkorak</td>
                <td class="td_left">
                  <input class="uraianPenandaan romawi1Chk" type="radio" id="aradioC1" name="CHK[1][3]" value="+_Gambar orang merokok dengan asap yang membentuk tengkorak" <?php if ($d[0][0] == '+') echo 'checked'; ?>>
                  <label for="aradioC1" style="width: 70px; height: 10px;" title="Ya"></label>
                  <span style="margin-left: 5px;"></span>
                  <input class="uraianPenandaan romawi1Chk" type="radio" id="aradioC2" name="CHK[1][3]" value="-_Gambar orang merokok dengan asap yang membentuk tengkorak" <?php if ($d[0][0] == '-') echo 'checked'; ?>>
                  <label for="aradioC2" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak"></label>
                  <input type="text" class="romawi1Val" name="CHK[1][3]" style="display: none" value="<?php echo $detail[0]; ?>">
                </td>
              </tr>
              <tr class="romawi1 infoPenandaanRokokRow" hidden>
                <td>Tulisan 2 : Merokok Membunuhmu</td>
                <td class="td_left">
                  <input class="uraianPenandaan romawi1Chk" type="radio" id="aradioD1" name="CHK[1][4]" value="+_Merokok Membunuhmu" <?php if ($d[0][0] == '+') echo 'checked'; ?>>
                  <label for="aradioD1" style="width: 70px; height: 10px;" title="Ya"></label>
                  <span style="margin-left: 5px;"></span>
                  <input class="uraianPenandaan romawi1Chk" type="radio" id="aradioD2" name="CHK[1][4]" value="-_Merokok Membunuhmu" <?php if ($d[0][0] == '-') echo 'checked'; ?>>
                  <label for="aradioD2" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak"></label>
                  <input type="text" class="romawi1Val" name="CHK[1][4]" style="display: none" value="<?php echo $detail[0]; ?>">
                </td>
              </tr>
              <tr class="romawi1 infoPenandaanRokokRow" hidden>
                <td>Gambar 3 : Gambar kanker tenggorokan</td>
                <td class="td_left">
                  <input class="uraianPenandaan romawi1Chk" type="radio" id="aradioE1" name="CHK[1][5]" value="+_Gambar kanker tenggorokan" <?php if ($d[0][0] == '+') echo 'checked'; ?>>
                  <label for="aradioE1" style="width: 70px; height: 10px;" title="Ya"></label>
                  <span style="margin-left: 5px;"></span>
                  <input class="uraianPenandaan romawi1Chk" type="radio" id="aradioE2" name="CHK[1][5]" value="-_Gambar kanker tenggorokan" <?php if ($d[0][0] == '-') echo 'checked'; ?>>
                  <label for="aradioE2" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak"></label>
                  <input type="text" class="romawi1Val" name="CHK[1][5]" style="display: none" value="<?php echo $detail[0]; ?>">
                </td>
              </tr>
              <tr class="romawi1 infoPenandaanRokokRow" hidden>
                <td>Tulisan 3 : Merokok Sebabkan Kanker Tenggorokan</td>
                <td class="td_left">
                  <input class="uraianPenandaan romawi1Chk" type="radio" id="aradioF1" name="CHK[1][6]" value="+_Merokok Sebabkan Kanker Tenggorokan" <?php if ($d[0][0] == '+') echo 'checked'; ?>>
                  <label for="aradioF1" style="width: 70px; height: 10px;" title="Ya"></label>
                  <span style="margin-left: 5px;"></span>
                  <input class="uraianPenandaan romawi1Chk" type="radio" id="aradioF2" name="CHK[1][6]" value="-_Merokok Sebabkan Kanker Tenggorokan" <?php if ($d[0][0] == '-') echo 'checked'; ?>>
                  <label for="aradioF2" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak"></label>
                  <input type="text" class="romawi1Val" name="CHK[1][6]" style="display: none" value="<?php echo $detail[0]; ?>">
                </td>
              </tr>
              <tr class="romawi1 infoPenandaanRokokRow" hidden>
                <td>Gambar 4 : Gambar Orang Merokok Dengan Anak Didekatnya</td>
                <td class="td_left">
                  <input class="uraianPenandaan romawi1Chk" type="radio" id="aradioG1" name="CHK[1][7]" value="+_Gambar Orang Merokok Dengan Anak Didekatnya" <?php if ($d[0][0] == '+') echo 'checked'; ?>>
                  <label for="aradioG1" style="width: 70px; height: 10px;" title="Ya"></label>
                  <span style="margin-left: 5px;"></span>
                  <input class="uraianPenandaan romawi1Chk" type="radio" id="aradioG2" name="CHK[1][7]" value="-_Gambar Orang Merokok Dengan Anak Didekatnya" <?php if ($d[0][0] == '-') echo 'checked'; ?>>
                  <label for="aradioG2" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak"></label>
                  <input type="text" class="romawi1Val" name="CHK[1][7]" style="display: none" value="<?php echo $detail[0]; ?>">
                </td>
              </tr>
              <tr class="romawi1 infoPenandaanRokokRow" hidden>
                <td>Tulisan 4 : Merokok Dekat Anak Berbahaya Bagi Mereka</td>
                <td class="td_left">
                  <input class="uraianPenandaan romawi1Chk" type="radio" id="aradioH1" name="CHK[1][8]" value="+_Merokok Dekat Anak Berbahaya Bagi Mereka" <?php if ($d[0][0] == '+') echo 'checked'; ?>>
                  <label for="aradioH1" style="width: 70px; height: 10px;" title="Ya"></label>
                  <span style="margin-left: 5px;"></span>
                  <input class="uraianPenandaan romawi1Chk" type="radio" id="aradioH2" name="CHK[1][8]" value="-_Merokok Dekat Anak Berbahaya Bagi Mereka" <?php if ($d[0][0] == '-') echo 'checked'; ?>>
                  <label for="aradioH2" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak"></label>
                  <input type="text" class="romawi1Val" name="CHK[1][8]" style="display: none" value="<?php echo $detail[0]; ?>">
                </td>
              </tr>
              <tr class="romawi1 infoPenandaanRokokRow" hidden>
                <td>Gambar 5 : Gambar Paru - Paru Yang Menghitam Karena Kanker</td>
                <td class="td_left">
                  <input class="uraianPenandaan romawi1Chk" type="radio" id="aradioI1" name="CHK[1][9]" value="+_Gambar Paru - Paru Yang Menghitam Karena Kanker" <?php if ($d[0][0] == '+') echo 'checked'; ?>>
                  <label for="aradioI1" style="width: 70px; height: 10px;" title="Ya"></label>
                  <span style="margin-left: 5px;"></span>
                  <input class="uraianPenandaan romawi1Chk" type="radio" id="aradioI2" name="CHK[1][9]" value="-_Gambar Paru - Paru Yang Menghitam Karena Kanker" <?php if ($d[0][0] == '-') echo 'checked'; ?>>
                  <label for="aradioI2" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak"></label>
                  <input type="text" class="romawi1Val" name="CHK[1][9]" style="display: none" value="<?php echo $detail[0]; ?>">
                </td>
              </tr>
              <tr class="romawi1 infoPenandaanRokokRow" hidden>
                <td>Tulisan 5 : Merokok Sebabkan Kanker Paru-paru dan Bronkitis Kronis</td>
                <td class="td_left">
                  <input class="uraianPenandaan romawi1Chk" type="radio" id="aradioJ1" name="CHK[1][10]" value="+_Merokok Sebabkan Kanker Paru-paru dan Bronkitis Kronis" <?php if ($d[0][0] == '+') echo 'checked'; ?>>
                  <label for="aradioJ1" style="width: 70px; height: 10px;" title="Ya"></label>
                  <span style="margin-left: 5px;"></span>
                  <input class="uraianPenandaan romawi1Chk" type="radio" id="aradioJ2" name="CHK[1][10]" value="-_Merokok Sebabkan Kanker Paru-paru dan Bronkitis Kronis" <?php if ($d[0][0] == '-') echo 'checked'; ?>>
                  <label for="aradioJ2" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak"></label>
                  <input type="text" class="romawi1Val" name="CHK[1][10]"  style="display: none" value="<?php echo $detail[0]; ?>">
                </td>
              </tr>
              <tr class="infoPenandaanRokokRow">
                <td class="td_left_header_checklist" style="vertical-align: top">Gambar jelas dan mencolok sesuai dengan ketentuan</td>
                <td class="td_left">
                  <input class="uraianPenandaan romawi1Chk" type="radio" id="bradioA1" name="CHK[1][11]" value="+_Gambar jelas dan mencolok sesuai dengan ketentuan" <?php if ($d[0][0] == '+') echo 'checked'; ?>>
                  <label for="bradioA1" style="width: 70px; height: 10px;" title="Ya"></label>
                  <span style="margin-left: 5px;"></span>
                  <input class="uraianPenandaan romawi1Chk" type="radio" id="bradioA2" name="CHK[1][11]" value="-_Gambar jelas dan mencolok sesuai dengan ketentuan" <?php if ($d[0][0] == '-') echo 'checked'; ?>>
                  <label for="bradioA2" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak"></label>
                  <input type="text" name="CHK[1][11]"  value="<?php echo $detail[0]; ?>" style="display: none" rel = "required">
                </td>
              </tr>
              <tr class="infoPenandaanRokokRow">
                <td class="td_left_header_checklist" style="vertical-align: top">2.  Letak Gambar Peringatan Kesehatan di bagian atas kemasan sisi lebar di depan dan belakang</td>
                <td class="td_left">
                  <input class="uraianPenandaan romawi1Chk" type="radio" id="2radioA1" name="CHK[2]" value="+_Letak Gambar Peringatan Kesehatan di bagian atas kemasan sisi lebar di depan dan belakang" <?php if ($d[0][0] == '+') echo 'checked'; ?>>
                  <label for="2radioA1" style="width: 70px; height: 10px;" title="Ya"></label>
                  <span style="margin-left: 5px;"></span>
                  <input class="uraianPenandaan romawi1Chk" type="radio" id="2radioA2" name="CHK[2]" value="-_Letak Gambar Peringatan Kesehatan di bagian atas kemasan sisi lebar di depan dan belakang" <?php if ($d[0][0] == '-') echo 'checked'; ?>>
                  <label for="2radioA2" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak"></label>
                  <input type="text" name="CHK[2]"  value="<?php echo $detail[0]; ?>" style="display: none" rel = "required">
                </td>
              </tr>
              <tr class="infoPenandaanRokokRow">
                <td class="td_left_header_checklist" style="vertical-align: top">3.  Luas Peringatan Kesehatan : 40%</td>
                <td class="td_left">
                  <input class="uraianPenandaan romawi1Chk" param= "luasKesehatan" type="radio" id="3radioA1" name="CHK[3]" value="+_Letak Gambar Peringatan Kesehatan di bagian atas kemasan sisi lebar di depan dan belakang" <?php if ($d[0][0] == '+') echo 'checked'; ?>>
                  <label for="3radioA1" style="width: 70px; height: 10px;" title="Ada / Sesuai"></label>
                  <span style="margin-left: 5px;"></span>
                  <input class="uraianPenandaan romawi1Chk" param= "luasKesehatan" type="radio" id="3radioA2" name="CHK[3]" value="-_Letak Gambar Peringatan Kesehatan di bagian atas kemasan sisi lebar di depan dan belakang" <?php if ($d[0][0] == '-') echo 'checked'; ?>>
                  <label for="3radioA2" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak"></label>
                  <input type="text" name="CHK[3]"  value="<?php echo $detail[0]; ?>" style="display: none" rel = "required">
                </td>
              </tr>
              <tr class="luasKesehatan" hidden>
                <td class="td_left_checklist"><b>Jika Tidak 40%, tuliskan luas :</b></td>
                <td>&nbsp;</td>
              </tr>
              <tr class="luasKesehatan" hidden>
                <td class="td_left_checklist">Bagian depan :</td>
                <td>&nbsp;<input type="text" name="URN[3]" class="uPenandaan" title="Uraian Penandaan" size="10" id="CHK[3]" value="<?php echo $detail2[1]; ?>" />%</td>
              </tr>
              <tr class="luasKesehatan" hidden>
                <td class="td_left_checklist">Bagian belakang :</td>
                <td>&nbsp;<input type="text" name="URN[3]" class="uPenandaan" title="Uraian Penandaan" size="10" id="CHK[3]" value="<?php echo $detail2[1]; ?>" />%</td>
              </tr>
              <tr class="infoPenandaanRokokRow">
                <td class="td_left_header_checklist" style="vertical-align: top">4.  Pada bagian atas gambar terdapat tulisan “PERINGATAN” dengan menggunakan jenis huruf arial bold berwarna putih dengan dasar hitam dengan ukuran huruf 10 (sepuluh) atau proporsional dengan kemasan</td>
                <td class="td_left">
                  <input class="uraianPenandaan romawi1Chk" type="radio" id="4radioA1" name="CHK[4]" value="+_Pada bagian atas gambar terdapat tulisan “PERINGATAN” dengan menggunakan jenis huruf arial bold berwarna putih dengan dasar hitam dengan ukuran huruf 10 (sepuluh) atau proporsional dengan kemasan" <?php if ($d[0][0] == '+') echo 'checked'; ?>>
                  <label for="4radioA1" style="width: 70px; height: 10px;" title="Ada"></label>
                  <span style="margin-left: 5px;"></span>
                  <input class="uraianPenandaan romawi1Chk" type="radio" id="4radioA2" name="CHK[4]" value="-_Pada bagian atas gambar terdapat tulisan “PERINGATAN” dengan menggunakan jenis huruf arial bold berwarna putih dengan dasar hitam dengan ukuran huruf 10 (sepuluh) atau proporsional dengan kemasan" <?php if ($d[0][0] == '-') echo 'checked'; ?>>
                  <label for="4radioA2" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak"></label>
                  <input type="text" name="CHK[4]"  value="<?php echo $detail[0]; ?>" style="display: none" rel = "required">
                </td>
              </tr>
              <tr class="infoPenandaanRokokRow">
                <td class="td_left_header_checklist" style="vertical-align: top">5.  Di bagian bawah gambar dicantumkan tulisan berwarna putih dengan dasar hitam sesuai dengan makna gambar, dicetak dengan jelas dan mencolok</td>
                <td class="td_left">
                  <input class="uraianPenandaan romawi1Chk" type="radio" id="5radioA1" name="CHK[5]" value="+_Di bagian bawah gambar dicantumkan tulisan berwarna putih dengan dasar hitam sesuai dengan makna gambar, dicetak dengan jelas dan mencolok" <?php if ($d[0][0] == '+') echo 'checked'; ?>>
                  <label for="5radioA1" style="width: 70px; height: 10px;" title="Ya"></label>
                  <span style="margin-left: 5px;"></span>
                  <input class="uraianPenandaan romawi1Chk" type="radio" id="5radioA2" name="CHK[5]" value="-_Di bagian bawah gambar dicantumkan tulisan berwarna putih dengan dasar hitam sesuai dengan makna gambar, dicetak dengan jelas dan mencolok" <?php if ($d[0][0] == '-') echo 'checked'; ?>>
                  <label for="5radioA2" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak"></label>
                  <input type="text" name="CHK[4]"  value="<?php echo $detail[0]; ?>" style="display: none" rel = "required">
                </td>
              </tr>
              <tr class="infoPenandaanRokokRow">
                <td class="td_left_header_checklist" style="vertical-align: top">6.  Peringatan kesehatan tidak tertutup oleh apapun sesuai ketentuan perundang-undangan yang berlaku, kecuali pembungkus plastic transparan.</td>
                <td class="td_left">
                  <input class="uraianPenandaan romawi1Chk" type="radio" id="6radioA1" name="CHK[6]" value="+_Peringatan kesehatan tidak tertutup oleh apapun sesuai ketentuan perundang-undangan yang berlaku, kecuali pembungkus plastic transparan" <?php if ($d[0][0] == '+') echo 'checked'; ?>>
                  <label for="6radioA1" style="width: 70px; height: 10px;" title="Ya"></label>
                  <span style="margin-left: 5px;"></span>
                  <input class="uraianPenandaan romawi1Chk" type="radio" id="6radioA2" name="CHK[6]" value="-_Peringatan kesehatan tidak tertutup oleh apapun sesuai ketentuan perundang-undangan yang berlaku, kecuali pembungkus plastic transparan" <?php if ($d[0][0] == '-') echo 'checked'; ?>>
                  <label for="6radioA2" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak"></label>
                  <input type="text" name="CHK[6]"  value="<?php echo $detail[0]; ?>" style="display: none" rel = "required">
                </td>
              </tr>
              <tr>
                <td class="td_left_header_checklist" style="vertical-align: top"><b>B. Hasil Evaluasi Pencantuman Peringatan Kesehatan</b></td>
                <td class="td_left">
                  <input type="text" id="kesimpulanHasilPenilaianromawi1" value="<?php
                  if ($sess['SISTEM'] == "MK")
                    echo "Memenuhi Ketentuan";
                  else
                    echo "Tidak Memenuhi Ketentuan"
                    ?>" readonly size="23" />
                  <input type="hidden" id="kesimpulanHasilPenilaianromawi1Val" value="<?php echo $sess['SISTEM']; ?>" name="HASIL"  /></td>
                </td>
              </tr>
              <tr>
                <td class="td_left_header_checklist" style="vertical-align: top; background-color: white; border-bottom: 1px solid #000">&nbsp; </td>
              </tr>
              <tr class="infoPenandaanPNGRow">
                <td class="td_left_header_checklist" style="vertical-align: top">Lain - lain </td>
                <td>&nbsp;<textarea name="URN[12]" class="uPenandaan" title="Uraian Penandaan" id="CHK[11]" style="width: 34%; height: 100px;" ><?php echo $detail2[10]; ?></textarea></td>
              </tr>
              <tr></tr>
              <tr><td colspan="2" style="background-color: white">&nbsp;</td></tr>
              <tr>
                 <!--<td class="td_left_checklist" style="vertical-align: top">37</td>-->
                <td class="td_left_header_checklist">Lampiran : </td><td><?php
                  if (array_key_exists('LAMPIRAN', $sess) && trim($sess['LAMPIRAN']) != "") {
                    ?><input type="hidden" name="PENANDAAN_PANGAN[FILE_PENANDAAN_PANGAN]" value="<?php echo $sess['LAMPIRAN']; ?>">
                    <span class="file_FILE_PENANDAAN_PANGAN"><a href="<?php echo base_url(); ?>files/<?php echo 'penandaan_013/irt'; ?>/<?php echo $sess['LAMPIRAN']; ?>" target="_blank">File Lampiran</a>&nbsp;&bull;&nbsp;<a href="#" class="del_upload" url="<?php echo site_url(); ?>/utility/uploads/del_upload_m/<?php echo 'penandaan_013/irt'; ?><?php echo $sess['FILE_PENANDAAN_PANGAN']; ?>" jns="FILE_PENANDAAN_PANGAN">Edit atau Hapus File ?</a></span>
                    <?php
                  } else {
                    ?>
                    <span class="upload_FILE_PENANDAAN_PANGAN"><input type="file" class="upload upPANGAN" jenis="FILE_PENANDAAN_PANGAN" allowed="jpg-jpeg-pdf" url="<?php echo site_url(); ?>/utility/uploads/get_upload_m/<?php echo 'penandaan_013/irt'; ?>" id="fileToUpload_FILE_PENANDAAN_PANGAN" name="userfile" onchange="do_upload($(this));
                          return false;" />
                      &nbsp;Tipe File : *.jpg .jpeg .pdf</span><span class="file_FILE_PENANDAAN_PANGAN"></span>
                    <?php
                  }
                  ?></td>
              </tr>
              <tr><td>&nbsp;</td></tr>
              <tr>
                <td class="td_left_header_checklist">&nbsp;Kesimpulan&nbsp;&nbsp;</td>
                <td class="td_left">
                  <input type="text" id="kesimpulanHasilPenilaian" value="<?php
                  if ($sess['SISTEM'] == "MK")
                    echo "Memenuhi Ketentuan";
                  else
                    echo "Tidak Memenuhi Ketentuan"
                    ?>" readonly size="23" />
                  <input type="hidden" id="kesimpulanHasilPenilaianVal" value="<?php echo $sess['SISTEM']; ?>" name="HASIL"  /></td>
              </tr>
              <tr class="TDKB" hidden><td class="td_left_checklist">Tindak Lanjut Balai</td><td class="td_left"><?php echo form_dropdown('PENANDAAN[TL_BALAI]', $cb_tindakan_balai, $sess['TL_BALAI'], 'class="stext TDKB" id="tDKBalai" title="Tindak Lanjut Balai"'); ?></td></tr>
              <td colspan="3"></td>
              </tr>
            </table>
          </div>
        </div>

        <!--7-->
        <?php if ($this->newsession->userdata('SESS_BBPOM_ID') == '92') { ?>
          <div style="height:5px;"></div>
          <div class="expand"><a title="expand/collapse" href="#" style="display: block;">KESIMPULAN</a></div>
          <div class="collapse">
            <div class="accCntnt">
              <table class="form_tabel" style="width: 100%;">
                <tr>
                  <td style="width: 30%; background-color: white"></td>
                  <td style="width: 65%; background-color: white; font-size: 14px; padding-left: 250px; padding-right: 250px; padding-bottom: 5px; padding-top: 5px;"></td>
                </tr>
                <?php
                $pusat = explode("*", $sess['PUSAT']);
                $hasil2 = explode("^", $pusat[1]);
                $hasil = explode("^", $pusat[2]);
                if ($role == '2' && $editTL == 'YES') {
                  ?>
                  <tr><td class="td_left_checklistRed">Verifikasi Pusat</td><td class="td_left"><select class="stext verifikasiPusat" name="<?php echo 'PENANDAAN[HASIL_PUSAT]' ?>" rel="required" title="MK/TMK"><option></option><option value="MK" <?php if ($pusat[0] == 'MK') echo 'Selected' ?>>Memenuhi Ketentuan</option><option value="TMK"  <?php if ($pusat[0] == 'TMK') echo 'Selected' ?>>Tidak Memenuhi Ketentuan</option></select></td></tr>
                  <tr class="vTMK" hidden><td class="td_left_checklistRed"style="background-color: white;">Tindak Lanjut</td><td class="td_left" style="background-color: white;"><?php echo form_dropdown('PENANDAAN[TL_PUSAT][]', $cb_tindakan, is_array($hasil) ? $hasil : '', 'class="stext vTMK" id="vTMKSub" title="Tindak Lanjut Pusat"'); ?></td></tr>
                  <tr class="vJustifikasi" hidden><td class="td_left_checklistRed" style="background-color: white; vertical-align: top;">Justifikasi</td><td class="td_left" style="background-color: white;"><textarea name="JUSTIFIKASI" title="Justifikasi Pusat" class="stext chkJustifikasi" id="XXX" style="height: 140px;"><?php echo $pusat[3]; ?></textarea></td></tr> <?php
                } else {
                  if ($pusat[0] == "TMK") {
                    ?>
                    <tr><td class="td_left_checklistRed">Verifikasi Pusat</td><td class="td_left"><b><i><?php
                            echo 'Tidak Memenuhi Ketentuan';
                            ?></i></b></td></tr>
                    <tr><td class="td_left_checklistRed">Kategori Pelanggaran</td><td class="td_left"><?php echo $hasil[0]; ?></td></tr>
                    <?php if ($hasil[1] != NULL) { ?><tr><td class="td_left_checklistRed">Tindak Lanjut Pusat</td><td class="td_left"><?php
                      if ($hasil[1] == 'TL')
                        echo 'Tindak Lanjut'; else if ($hasil[1] == 'STL')
                        echo 'Sudah Tindak Lanjut';
                      else
                        echo 'Tidak Dapat Tindak Lanjut'
                        ?></td></tr>
                      <tr><td class="td_left_checklistRed"></td><td class="td_left"><ul style="list-style-type:decimal; padding-left:20px; margin:0;"><?php
                            $temp = array($hasil[2], $hasil[3]);
                            if ($hasil[3] != '')
                              echo "<li>" . join("</li><li>", $temp) . "</li>";
                            else
                              echo "<li>" . $hasil[2] . "</li>";
                            ?></ul></td></tr><?php if ($hasil[1] != NULL) { ?>
                        <tr><td class="td_left_checklistRed">Surat Tindak Lanjut</td><td class="td_left"><ul style="list-style-type:decimal; padding-left:20px; margin:0;"><?php
                              $temp2 = array($hasil2[0], $hasil2[1]);
                              if ($hasil2[1] != "")
                                echo "<li>" . join("</li><li>", $temp2) . "</li>";
                              else
                                echo "<li>" . $hasil2[0] . "</li>";
                              ?></ul></td></tr><?php } if ($sess['JUSTIFIKASI_PUSAT'] != NULL || $sess['JUSTIFIKASI_PUSAT'] != "") { ?>
                        <tr><td class="td_left">Justifikasi Pusat</td><td class="td_right"><?php echo $sess['JUSTIFIKASI_PUSAT']; ?></td></tr>
                        <?php
                      }
                    }
                  } else {
                    ?>
                    <tr><td class="td_left_checklistRed">Verifikasi Pusat</td><td class="td_left"><b><i><?php
                            echo 'Memenuhi Ketentuan';
                            ?></i></b></td></tr>
                    <?php if ($sess['JUSTIFIKASI_PUSAT'] != NULL || $sess['JUSTIFIKASI_PUSAT'] != "") { ?>
                      <tr><td class="td_left">Justifikasi Pusat</td><td class="td_right"><?php echo $sess['JUSTIFIKASI_PUSAT']; ?></td></tr>
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

        <div style="padding:10px;"></div><div><a href="javascript:void(0)" id="btnSave" class="button <?php echo $icon; ?>" onclick="fpost('#fpengawasanPenandaan_007', '', '');">
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
        <input type="hidden" name="JENIS" value="<?php echo "IRT"; ?>" />
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
    } else if (halal !== "Halal") {
      $('#halalRow').hide();
      $('.halal').val('');
      $('.halalVal').val('');
      $('.halalVal').attr("rel", "");
      $('#radioQ1').attr('checked', false);
      $('#radioQ2').attr('checked', false);
      $('#radioQ3').attr('checked', false);
    }
  }
  function comp(A) {
    var tgl1 = '#tglXX', tgl2 = '#tglAwalPengawasan', tgl3 = '#tglAkhirPengawasan', tgl4 = '#tglBeli';
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
    else if (A === 'C') {
      compare2(tgl4, tgl3, tgl4, "Harap dipastikan untuk Tanggal Beli : \n  Harus lebih kecil dari Tanggal Akhir Pemeriksaan");
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
  function required(X, x) {
    var XX = $(X).val().split("_");
    var Param = $(X).attr("param");
    if (x === 1) {
      $("input:radio.uraianPenandaan_" + XX[1]).each(function() {
        var name = $(this).attr("name");
        if ($(this).closest(".infoPenandaanSM_" + XX[1] + "Row").attr("hidden") === false) {
          $("input[type='text'][name='" + name + "']").attr("rel", "required");
        }
        if ($(this).closest(".infoPenandaanSM_" + XX[1] + "Row").attr("hidden") === true) {
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
    $(obj).closest("td").css('border-left', '0px');
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
  function tindakLanjutBalai(obj) {
    if ($(obj).val() == "TMK") {
      $(".TDKB").show();
      $("#tDKBalai").attr("rel", "required");
      $("#fileToUpload_FILE_PENANDAAN_PANGAN").attr("rel", "required");
    } else {
      $(".TDKB").hide();
      $(".TDKB").val("");
      $("#tDKBalai").attr("rel", "");
      $("#fileToUpload_FILE_PENANDAAN_PANGAN").attr("rel", "");
    }
  }
  $(document).ready(function() {
    $("textarea.chkJustifikasi").redactor({
      buttons: ['bold', 'italic', '|', 'unorderedlist', 'orderedlist', 'outdent', 'indent', '|', 'alignleft', 'aligncenter', 'alignright', 'justify'],
      removeStyles: false,
      cleanUp: true,
      autoformat: true
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
          $('.primer').show();
          $('#' + param).hide();
          $('.kemasanPrimer').attr("rel", "required");
        }
        else {
          $('.' + param).show();
          $('.' + param + "Val").attr("rel", "required");
        }
        $("[id='" + name + "']").attr("rel", "required");
      }
      else {
        $('.' + param).hide();
        $('.' + param + "Val").attr("rel", "");
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
    function mkTmk() {
      var X = false, X2 = false;
      $('.uraianPenandaan').each(function() {
        if ($(this).is(":checked") === true) {
          var a = $(this).val().split('_');
          if (a[0] === '-' || a[0] === 'X') {
            X = true;
          }
        }
      });
      $('.romawi1Chk').each(function() {
        if ($(this).is(":checked") === true) {
          var a = $(this).val().split('_');
          if (a[0] === '-') {
            X2 = true;
          }
        }
      });
      if (X2 === true) {
        $('#kesimpulanHasilPenilaianromawi1').val('Tidak Memenuhi Ketentuan');
        $('#kesimpulanHasilPenilaianromawi1Val').val('TMK');
      } else if (X2 !== true) {
        $('#kesimpulanHasilPenilaianromawi1').val('Memenuhi Ketentuan');
        $('#kesimpulanHasilPenilaianromawi1Val').val('MK');
      }
      if (X === true) {
        $('#kesimpulanHasilPenilaian').val('Tidak Memenuhi Ketentuan');
        $('#kesimpulanHasilPenilaianVal').val('TMK');
        $(".TDKB").show();
      } else if (X !== true) {
        $('#kesimpulanHasilPenilaian').val('Memenuhi Ketentuan');
        $('#kesimpulanHasilPenilaianVal').val('MK');
        $(".TDKB").hide();
      }
    }
    $(".uraianPenandaan").click(function() {
      var name = $(this).attr("name"), selectedVal = "";
      var selected = $("input[type='radio'][name='" + name + "']:checked").val();
      $("input[type='text'][name='" + name + "']").val(selected);
      checkListTxt($(this));
      borderLess($(this));
      verifikasiTL($("#vTMKSub"));
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