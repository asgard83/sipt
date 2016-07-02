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
$d1 = explode('^', $sess['PENILAIAN1']);
$d2 = explode('^', $sess['PENILAIAN2']);
$d3 = explode('^', $sess['PENILAIAN3']);
foreach ($d1 as $value) {
 $pend1[] = explode("_", $value);
}
foreach ($d2 as $value) {
 $pend2[] = explode("_", $value);
}
foreach ($d3 as $value) {
 $pend3[] = explode("_", $value);
}
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
       <tr><td class="td_left">Tanggal Pembelian</td><td class="td_right">
         <input type="hidden" class="sdate" name="PENANDAAN[TANGGALSURAT]" id="tglXX<?php echo $i; ?>" title="Tanggal Surat" value="<?php
         if ($this->session->userdata('TANGGAL') != "-") {
          echo $this->session->userdata('TANGGAL');
         }
         ?>"/>
         <input type="text" class="sdate" name="PENANDAAN[TANGGALAWAL]" id="tglAwalPengawasan<?php echo $i; ?>" title="Tanggal Pembelian" onchange="comp('A')" rel="required" value="<?php echo $sess['TANGGAL_MULAI']; ?>"/>&nbsp; sampai dengan&nbsp;
         <input type="text" class="sdate" name="PENANDAAN[TANGGALAKHIR]" id="tglAkhirPengawasan<?php echo $i; ?>" title="Tanggal Pembelian" onchange="comp('B')" rel="required" value="<?php echo $sess['TANGGAL_AKHIR']; ?>"/></td>
       </tr>
       <tr>
        <td class="td_left">Lokasi Pembelian</td><td class="td_right"><input type="text" class="stext" name="PENANDAAN[SARANA]" id="saranaid_" url="<?php echo site_url(); ?>/autocompletes/autocomplete/sarana" title="Pilih salah satu Nama Sarana" value="<?php echo $sess['NAMA_SARANA']; ?>" rel="required"/><input type="hidden"  name="PENANDAAN[SARANAID]" id="saranaidval_" value="<?php echo $sess['SARANA_ID']; ?>" /></td>
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
         <td class="td_left">Produsen</td><td class="td_right"><input type="text" class="stext" id="produsen" title="Nama Produsen" name="PENANDAANPRODUK[PRODUSEN]" value="<?php echo $sess['PRODUSEN'] ?>"/></td>
         <td colspan="2"></td>
        </tr>
        <tr>
         <td class="td_left">Alamat Produsen</td><td class="td_right"><textarea id="alamatProdusen" class="stext" style="width: 240px; height: auto" title="Alamat Produsen" name="PENANDAANPRODUK[ALAMAT_PRODUSEN]"><?php echo $sess['ALAMAT_PRODUSEN']; ?></textarea></td>
         <td colspan="2"></td>
        </tr>
        <tr>
         <td class="td_left">Jenis Produk Tembakau</td><td class="td_right"><?php echo form_dropdown("PENANDAANPRODUK[JENIS]", $jenisTmbk, $sess['KLASIFIKASI_PRODUK'], "rel='required'") ?></td>
         <td colspan="2"></td>
        </tr>
        <tr>
         <td class="td_left">Bentuk Kemasan Produk Tembakau</td><td class="td_right"><?php echo form_dropdown("PENANDAANPRODUK[BENTUK]", $jenisKmsn, $sess['BENTUK_SEDIAAN'], "id='bentukKemasan' onchange='bentukKemasanHide(this);' rel='required' class='stext' title='Bentuk Kemasan Produk Tembakau' ") ?></td>
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
         <input class="uraianPenandaan romawi1Chk" param="romawi1" type="radio" id="radioA1" name="CHK[SATU][1]" value="+_Mencantumkan peringatan kesehatan berbentuk gambar dan tulisan" <?php if ($pend1[0][0] == '+') echo 'checked'; ?>>
         <label for="radioA1" style="width: 70px; height: 10px;" title="Ada"></label>
         <span style="margin-left: 5px;"></span>
         <input class="uraianPenandaan romawi1Chk" param="romawi1" type="radio" id="radioA2" name="CHK[SATU][1]" value="-_Mencantumkan peringatan kesehatan berbentuk gambar dan tulisan" <?php if ($pend1[0][0] == '-') echo 'checked'; ?>>
         <label for="radioA2" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak"></label>
         <input type="text" name="CHK[SATU][1]" style="display: none;"  rel="required" value="<?php echo $d1[0]; ?>">
        </td>
       </tr>
       <tr class="romawi1 infoPenandaanRokokRow" hidden>
        <td><b>Jenis Gambar dan tulisan</b></td>
        <td>&nbsp;</td>
       </tr>
       <tr class="romawi1 infoPenandaanRokokRow" hidden>
        <td>Gambar 1 : Gambar kanker mulut <br/>Tulisan 1 : Merokok sebabkan kanker mulut</td>
        <td class="td_left" style="vertical-align: middle">
         <input type="checkbox" name="CHK[SATU][2]" value="CT_GT1" class="uraianPenandaan romawi1Chk romawi1 subPenilaianPoin1GT" <?php if ($pend1[1][0] != "") echo "checked"; ?> />
         <input type="text" class="romawi1Val subPenilaianPoin1GTVal" name="CHK[SATU][2]" style="display: none;" value="<?php echo $d1[1]; ?>"/>
        </td>
       </tr>
       <tr class="romawi1 infoPenandaanRokokRow" hidden>
        <td>Gambar 2 : Gambar orang merokok dengan asap yang membentuk tengkorak <br/>Tulisan 2 : Merokok Membunuhmu</td>
        <td class="td_left" style="vertical-align: middle">
         <input type="checkbox" name="CHK[SATU][3]" value="CT_GT2" class="uraianPenandaan romawi1Chk romawi1 subPenilaianPoin1GT" <?php if ($pend1[2][0] != "") echo "checked"; ?> />
         <input type="text" class="romawi1Val subPenilaianPoin1GTVal"  name="CHK[SATU][3]" style="display: none;" value="<?php echo $d1[2]; ?>" />
        </td>
       </tr>
       <tr class="romawi1 infoPenandaanRokokRow" hidden>
        <td>Gambar 3 : Gambar kanker tenggorokan <br/>Tulisan 3 : Merokok Sebabkan Kanker Tenggorokan</td>
        <td class="td_left" style="vertical-align: middle">
         <input type="checkbox" name="CHK[SATU][4]" value="CT_GT3" class="uraianPenandaan romawi1Chk romawi1 subPenilaianPoin1GT" <?php if ($pend1[3][0] != "") echo "checked"; ?> />
         <input type="text" class="romawi1Val subPenilaianPoin1GTVal" name="CHK[SATU][4]" style="display: none;" value="<?php echo $d1[3]; ?>"/>
        </td>
       </tr>
       <tr class="romawi1 infoPenandaanRokokRow" hidden>
        <td>Gambar 4 : Gambar Orang Merokok Dengan Anak Didekatnya <br/>Tulisan 4 : Merokok Dekat Anak Berbahaya Bagi Mereka</td>
        <td class="td_left" style="vertical-align: middle">
         <input type="checkbox" name="CHK[SATU][5]" value="CT_GT4" class="uraianPenandaan romawi1Chk romawi1 subPenilaianPoin1GT" <?php if ($pend1[4][0] != "") echo "checked"; ?> />
         <input type="text" class="romawi1Val subPenilaianPoin1GTVal" name="CHK[SATU][5]" style="display: none;" value="<?php echo $d1[4]; ?>"/>
        </td>
       </tr>
       <tr class="romawi1 infoPenandaanRokokRow" hidden>
        <td>Gambar 5 : Gambar Paru - Paru Yang Menghitam Karena Kanker <br/>Tulisan 5 : Merokok Sebabkan Kanker Paru-paru dan Bronkitis Kronis</td>
        <td class="td_left" style="vertical-align: middle">
         <input type="checkbox" name="CHK[SATU][6]" value="CT_GT5" class="uraianPenandaan romawi1Chk romawi1 subPenilaianPoin1GT" <?php if ($pend1[5][0] != "") echo "checked"; ?> />
         <input type="text" class="romawi1Val subPenilaianPoin1GTVal" name="CHK[SATU][6]" style="display: none;" value="<?php echo $d1[5]; ?>"/>
        </td>
       </tr>
       <tr class="romawi1 infoPenandaanRokokRow" hidden>
        <td class="td_left_header_checklist" style="vertical-align: top">Gambar jelas dan mencolok sesuai dengan ketentuan</td>
        <td class="td_left">
         <input class="uraianPenandaan romawi1Chk romawi1r" type="radio" id="bradioA1" name="CHK[SATU][7]" value="+_Gambar jelas dan mencolok sesuai dengan ketentuan" <?php if ($pend1[6][0] == '+') echo 'checked'; ?>>
         <label for="bradioA1" style="width: 70px; height: 10px;" title="Ya"></label>
         <span style="margin-left: 5px;"></span>
         <input class="uraianPenandaan romawi1Chk romawi1r" type="radio" id="bradioA2" name="CHK[SATU][7]" value="-_Gambar jelas dan mencolok sesuai dengan ketentuan" <?php if ($pend1[6][0] == '-') echo 'checked'; ?>>
         <label for="bradioA2" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak"></label>
         <input type="text" class="romawi1Val" name="CHK[SATU][7]" style="display: none" rel = "required" value="<?php echo $d1[6]; ?>">
        </td>
       </tr>
       <tr class="infoPenandaanRokokRow">
        <td class="td_left_header_checklist" style="vertical-align: top">2.  Letak Gambar Peringatan Kesehatan di bagian atas kemasan sisi lebar di depan dan belakang</td>
        <td class="td_left">
         <input class="uraianPenandaan romawi1Chk" type="radio" id="2radioA1" name="CHK[SATU][8]" value="+_Letak Gambar Peringatan Kesehatan di bagian atas kemasan sisi lebar di depan dan belakang" <?php if ($pend1[7][0] == '+') echo 'checked'; ?>>
         <label for="2radioA1" style="width: 70px; height: 10px;" title="Ya"></label>
         <span style="margin-left: 5px;"></span>
         <input class="uraianPenandaan romawi1Chk" type="radio" id="2radioA2" name="CHK[SATU][8]" value="-_Letak Gambar Peringatan Kesehatan di bagian atas kemasan sisi lebar di depan dan belakang" <?php if ($pend1[7][0] == '-') echo 'checked'; ?>>
         <label for="2radioA2" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak"></label>
         <input type="text" name="CHK[SATU][8]" style="display: none" rel = "required" value="<?php echo $d1[7]; ?>">
        </td>
       </tr>
       <tr class="infoPenandaanRokokRow">
        <td class="td_left_header_checklist" style="vertical-align: top">3.  Luas Peringatan Kesehatan : 40%</td>
        <td class="td_left">
         <input class="uraianPenandaan romawi1Chk" param= "luasKesehatan" type="radio" id="3radioA1" name="CHK[SATU][9]" value="+_Luas Peringatan Kesehatan : 40%" <?php if ($pend1[8][0] == '+') echo 'checked'; ?>>
         <label for="3radioA1" style="width: 70px; height: 10px;" title="Ada / Sesuai"></label>
         <span style="margin-left: 5px;"></span>
         <input class="uraianPenandaan romawi1Chk" param= "luasKesehatan" type="radio" id="3radioA2" name="CHK[SATU][9]" value="-_Luas Peringatan Kesehatan : 40%" <?php if ($pend1[8][0] == '-') echo 'checked'; ?>>
         <label for="3radioA2" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak"></label>
         <input type="text" name="CHK[SATU][9]"  style="display: none" rel = "required" value="<?php echo $d1[8]; ?>" />
        </td>
       </tr>
       <tr class="luasKesehatan" hidden>
        <td class="td_left_checklist"><b>Jika Tidak 40%, tuliskan luas :</b></td>
        <td>&nbsp;</td>
       </tr>
       <tr class="luasKesehatan" hidden>
        <td class="td_left_checklist">Bagian depan :</td>
        <td>&nbsp;<input type="text" name="CHK[SATU][10]" class="uPenandaan" title="Uraian Penandaan" size="10" id="CHK[SATU][8]" value="<?php echo $d1[9]; ?>" />%</td>
       </tr>
       <tr class="luasKesehatan" hidden>
        <td class="td_left_checklist">Bagian belakang :</td>
        <td>&nbsp;<input type="text" name="CHK[SATU][11]" class="uPenandaan" title="Uraian Penandaan" size="10" id="CHK[SATU][8]" value="<?php echo $d1[10]; ?>" />%</td>
       </tr>
       <tr class="infoPenandaanRokokRow">
        <td class="td_left_header_checklist" style="vertical-align: top">4.  Pada bagian atas gambar terdapat tulisan “PERINGATAN” dengan menggunakan jenis huruf arial bold berwarna putih dengan dasar hitam dengan ukuran huruf 10 (sepuluh) atau proporsional dengan kemasan</td>
        <td class="td_left">
         <input class="uraianPenandaan romawi1Chk" type="radio" id="4radioA1" name="CHK[SATU][12]" value="+_Pada bagian atas gambar terdapat tulisan “PERINGATAN” dengan menggunakan jenis huruf arial bold berwarna putih dengan dasar hitam dengan ukuran huruf 10 (sepuluh) atau proporsional dengan kemasan" <?php if ($pend1[11][0] == '+') echo 'checked'; ?>>
         <label for="4radioA1" style="width: 70px; height: 10px;" title="Ada"></label>
         <span style="margin-left: 5px;"></span>
         <input class="uraianPenandaan romawi1Chk" type="radio" id="4radioA2" name="CHK[SATU][12]" value="-_Pada bagian atas gambar terdapat tulisan “PERINGATAN” dengan menggunakan jenis huruf arial bold berwarna putih dengan dasar hitam dengan ukuran huruf 10 (sepuluh) atau proporsional dengan kemasan" <?php if ($pend1[11][0] == '-') echo 'checked'; ?>>
         <label for="4radioA2" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak"></label>
         <input type="text" name="CHK[SATU][12]" style="display: none" rel = "required" value="<?php echo $d1[11]; ?>">
        </td>
       </tr>
       <tr class="infoPenandaanRokokRow">
        <td class="td_left_header_checklist" style="vertical-align: top">5.  Di bagian bawah gambar dicantumkan tulisan berwarna putih dengan dasar hitam sesuai dengan makna gambar, dicetak dengan jelas dan mencolok</td>
        <td class="td_left">
         <input class="uraianPenandaan romawi1Chk" type="radio" id="5radioA1" name="CHK[SATU][13]" value="+_Di bagian bawah gambar dicantumkan tulisan berwarna putih dengan dasar hitam sesuai dengan makna gambar, dicetak dengan jelas dan mencolok" <?php if ($pend1[12][0] == '+') echo 'checked'; ?>>
         <label for="5radioA1" style="width: 70px; height: 10px;" title="Ya"></label>
         <span style="margin-left: 5px;"></span>
         <input class="uraianPenandaan romawi1Chk" type="radio" id="5radioA2" name="CHK[SATU][13]" value="-_Di bagian bawah gambar dicantumkan tulisan berwarna putih dengan dasar hitam sesuai dengan makna gambar, dicetak dengan jelas dan mencolok" <?php if ($pend1[12][0] == '-') echo 'checked'; ?>>
         <label for="5radioA2" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak"></label>
         <input type="text" name="CHK[SATU][13]" style="display: none" rel = "required" value="<?php echo $d1[12]; ?>">
        </td>
       </tr>
       <tr class="infoPenandaanRokokRow">
        <td class="td_left_header_checklist" style="vertical-align: top">6.  Peringatan kesehatan tidak tertutup oleh apapun sesuai ketentuan perundang-undangan yang berlaku, kecuali pembungkus plastic transparan.</td>
        <td class="td_left">
         <input class="uraianPenandaan romawi1Chk" type="radio" id="6radioA1" name="CHK[SATU][14]" value="+_Peringatan kesehatan tidak tertutup oleh apapun sesuai ketentuan perundang-undangan yang berlaku, kecuali pembungkus plastic transparan" <?php if ($pend1[13][0] == '+') echo 'checked'; ?>>
         <label for="6radioA1" style="width: 70px; height: 10px;" title="Ya"></label>
         <span style="margin-left: 5px;"></span>
         <input class="uraianPenandaan romawi1Chk" type="radio" id="6radioA2" name="CHK[SATU][14]" value="-_Peringatan kesehatan tidak tertutup oleh apapun sesuai ketentuan perundang-undangan yang berlaku, kecuali pembungkus plastic transparan" <?php if ($pend1[13][0] == '-') echo 'checked'; ?>>
         <label for="6radioA2" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak"></label>
         <input type="text" name="CHK[SATU][14]" style="display: none" rel = "required" value="<?php echo $d1[13]; ?>">
        </td>
       </tr>
       <tr>
        <td class="td_left_header_checklist" style="vertical-align: top"><b>B. Hasil Evaluasi Pencantuman Peringatan Kesehatan</b></td>
        <td class="td_left">
         <input type="text" id="kesimpulanHasilPenilaianromawi1" value="<?php
         if ($d1[14] == "MK")
          echo "Memenuhi Ketentuan";
         else
          echo "Tidak Memenuhi Ketentuan"
          ?>" readonly size="23" />
         <input type="hidden" id="kesimpulanHasilPenilaianromawi1Val" value="<?php echo $d1[14]; ?>" name="CHK[SATU][15]"  /></td>
       </tr>
      </table>
     </div>
    </div>
    <div style="height:5px;"></div>

    <!-- DIV Detail-->
    <div class="expand" id="expand1"><a title="expand/collapse" href="#" style="display: block;">PENGAWASAN  PENCANTUMAN INFORMASI KESEHATAN</a></div>
    <div class="collapse">
     <div class="accCntnt">
      <table class="form_tabel">
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
        <td class="td_left_header_checklist" style="vertical-align: top"><b>A. Kewajiban Pencantuman Kandungan Kadar Nikotin dan Tar</b></td>
        <td class="td_left">
        </td>
       </tr>
       <tr class="infoPenandaanRokokRow">
        <td class="td_left_header_checklist" param="Kadar" style="vertical-align: top">a. Mencantumkan informasi kandungan kadar nikotin dan tar <br/>b. Jika ya, tulis kadar yang tercantum</td>
        <td class="td_left">
         <input class="uraianPenandaan romawi2Chk" param="Kadar" type="radio" id="cradioA1" name="CHK[DUA][1]" value="+_Mencantumkan informasi kandungan kadar nikotin dan tar" <?php if ($pend2[0][0] == '+') echo 'checked'; ?>>
         <label for="cradioA1" style="width: 70px; height: 10px;" title="Ya"></label>
         <span style="margin-left: 5px;"></span>
         <input class="uraianPenandaan romawi2Chk" param="Kadar" type="radio" id="cradioA2" name="CHK[DUA][1]" value="-_Mencantumkan informasi kandungan kadar nikotin dan tar" <?php if ($pend2[0][0] == '-') echo 'checked'; ?>>
         <label for="cradioA2" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak"></label>
         <input type="text" name="CHK[DUA][1]" style="display: none" rel = "required" value="<?php echo $d2[0]; ?>">
        </td>
       </tr>
       <tr class="Kadar" hidden>
        <td></td>
        <td><input type="text" class="Kadar" placeholder="Nikotin" name="CHK[DUA][2]" size="6" value="<?php echo $d2[1]; ?>">&nbsp;mg&nbsp;&nbsp;<input type="text" class="Kadar" placeholder="Tar" name="CHK[DUA][3]" size="6" value="<?php echo $d2[2]; ?>"> &nbsp;mg</td>
       </tr>
       <tr class="penulisanTxt" hidden>
        <td>c. Letak Penulisan:</td>
        <td>&nbsp;</td>
       </tr>
       <tr class="bungkusKotak infoPenandaanRokokRow" hidden>
        <td class="td_left_header_checklist" style="vertical-align: top">- Pada kemasan berbentuk kotak persegi panjang dan kotak dengan sisi lebar yang sama maka kadar nikotin dan tar diletakan pada salah satu sisi samping kemasan</td>
        <td class="td_left">
         <input class="uraianPenandaan romawi2Chk" type="radio" id="cradioC1" name="CHK[DUA][4]" value="+_Pada kemasan berbentuk kotak persegi panjang dan kotak dengan sisi lebar yang sama maka kadar nikotin dan tar diletakan pada salah satu sisi samping kemasan" <?php if ($pend2[3][0] == '+') echo 'checked'; ?>>
         <label for="cradioC1" style="width: 70px; height: 10px;" title="Ya"></label>
         <span style="margin-left: 5px;"></span>
         <input class="uraianPenandaan romawi2Chk" type="radio" id="cradioC2" name="CHK[DUA][4]" value="-_Pada kemasan berbentuk kotak persegi panjang dan kotak dengan sisi lebar yang sama maka kadar nikotin dan tar diletakan pada salah satu sisi samping kemasan" <?php if ($pend2[3][0] == '-') echo 'checked'; ?>>
         <label for="cradioC2" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak"></label>
         <input type="text" class="bungkusKotakVal" name="CHK[DUA][4]" style="display: none" value="<?php echo $d2[3]; ?>">
        </td>
       </tr>
       <tr class="bungkusBulat infoPenandaanRokokRow" hidden>
        <td class="td_left_header_checklist" style="vertical-align: top">- Pada kemasan berbentuk silinder (lingkaran) dan bentuk lainnya maka kadar nikotin dan tar diletakan pada sisi atas tutup kemasan</td>
        <td class="td_left">
         <input class="uraianPenandaan romawi2Chk" type="radio" id="cradioD1" name="CHK[DUA][5]" value="+_Pada kemasan berbentuk silinder (lingkaran) dan bentuk lainnya maka kadar nikotin dan tar diletakan pada sisi atas tutup kemasan" <?php if ($pend2[4][0] == '+') echo 'checked'; ?>>
         <label for="cradioD1" style="width: 70px; height: 10px;" title="Ya"></label>
         <span style="margin-left: 5px;"></span>
         <input class="uraianPenandaan romawi2Chk" type="radio" id="cradioD2" name="CHK[DUA][5]" value="-_Pada kemasan berbentuk silinder (lingkaran) dan bentuk lainnya maka kadar nikotin dan tar diletakan pada sisi atas tutup kemasan" <?php if ($pend2[4][0] == '-') echo 'checked'; ?>>
         <label for="cradioD2" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak"></label>
         <input type="text" class="bungkusBulatVal" name="CHK[DUA][5]" style="display: none" value="<?php echo $d2[4]; ?>">
        </td>
       </tr>
       <tr class="infoPenandaanRokokRow">
        <td class="td_left_header_checklist" style="vertical-align: top">d.  Tulisan dicetak dengan jenis huruf kapital arial </td>
        <td class="td_left">
         <input class="uraianPenandaan romawi2Chk" type="radio" id="cradioE1" name="CHK[DUA][6]" value="+_Tulisan dicetak dengan jenis huruf kapital arial" <?php if ($pend2[5][0] == '+') echo 'checked'; ?>>
         <label for="cradioE1" style="width: 70px; height: 10px;" title="Ya"></label>
         <span style="margin-left: 5px;"></span>
         <input class="uraianPenandaan romawi2Chk" type="radio" id="cradioE2" name="CHK[DUA][6]" value="-_Tulisan dicetak dengan jenis huruf kapital arial" <?php if ($pend2[5][0] == '-') echo 'checked'; ?>>
         <label for="cradioE2" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak"></label>
         <input type="text" name="CHK[DUA][6]" style="display: none" rel = "required" value="<?php echo $d2[5]; ?>">
        </td>
       </tr>
       <tr class="infoPenandaanRokokRow">
        <td class="td_left_header_checklist" style="vertical-align: top">e.  Ukuran tulisan paling sedikit 3 mm atau setara dengan ukuran huruf 8 (delapan) </td>
        <td class="td_left">
         <input class="uraianPenandaan romawi2Chk" type="radio" id="cradioF1" name="CHK[DUA][7]" value="+_Ukuran tulisan paling sedikit 3 mm atau setara dengan ukuran huruf 8 (delapan)" <?php if ($pend2[6][0] == '+') echo 'checked'; ?>>
         <label for="cradioF1" style="width: 70px; height: 10px;" title="Ya"></label>
         <span style="margin-left: 5px;"></span>
         <input class="uraianPenandaan romawi2Chk" type="radio" id="cradioF2" name="CHK[DUA][7]" value="-_Ukuran tulisan paling sedikit 3 mm atau setara dengan ukuran huruf 8 (delapan)" <?php if ($pend2[6][0] == '-') echo 'checked'; ?>>
         <label for="cradioF2" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak"></label>
         <input type="text" name="CHK[DUA][7]" style="display: none" rel = "required" value="<?php echo $d2[6]; ?>">
        </td>
       </tr>
       <tr class="infoPenandaanRokokRow">
        <td class="td_left_header_checklist" style="vertical-align: top">f.  Tulisan diletakan  di dalam kotak segiempat dengan garis pinggir 1 (satu) mm </td>
        <td class="td_left">
         <input class="uraianPenandaan romawi2Chk" type="radio" id="cradioG1" name="CHK[DUA][8]" value="+_Tulisan diletakan  di dalam kotak segiempat dengan garis pinggir 1 (satu) mm" <?php if ($pend2[7][0] == '+') echo 'checked'; ?>>
         <label for="cradioG1" style="width: 70px; height: 10px;" title="Ya"></label>
         <span style="margin-left: 5px;"></span>
         <input class="uraianPenandaan romawi2Chk" type="radio" id="cradioG2" name="CHK[DUA][8]" value="-_Tulisan diletakan  di dalam kotak segiempat dengan garis pinggir 1 (satu) mm" <?php if ($pend2[7][0] == '-') echo 'checked'; ?>>
         <label for="cradioG2" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak"></label>
         <input type="text" name="CHK[DUA][8]" style="display: none" rel = "required" value="<?php echo $d2[7]; ?>">
        </td>
       </tr>
       <tr class="infoPenandaanRokokRow">
        <td class="td_left_header_checklist" style="vertical-align: top">g.  Warna tulisan kontras dengan warna dasar dan terbaca dengan jelas </td>
        <td class="td_left">
         <input class="uraianPenandaan romawi2Chk" type="radio" id="cradioH1" name="CHK[DUA][9]" value="+_Warna tulisan kontras dengan warna dasar dan terbaca dengan jelas" <?php if ($pend2[8][0] == '+') echo 'checked'; ?>>
         <label for="cradioH1" style="width: 70px; height: 10px;" title="Ya"></label>
         <span style="margin-left: 5px;"></span>
         <input class="uraianPenandaan romawi2Chk" type="radio" id="cradioH2" name="CHK[DUA][9]" value="-_Warna tulisan kontras dengan warna dasar dan terbaca dengan jelas" <?php if ($pend2[8][0] == '-') echo 'checked'; ?>>
         <label for="cradioH2" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak"></label>
         <input type="text" name="CHK[DUA][9]" style="display: none" rel = "required" value="<?php echo $d2[8]; ?>">
        </td>
       </tr>
       <tr class="infoPenandaanRokokRow">
        <td class="td_left_header_checklist" style="vertical-align: top"><b>B. Kewajiban mencantumkan pernyataan “dilarang menjual atau memberi kepada anak berusia di bawah 18 tahun dan perempuan hamil”</b></td>
        <td class="td_left">&nbsp;</td>
       </tr>
       <tr class="infoPenandaanRokokRow">
        <td class="td_left_header_checklist" style="vertical-align: top">a.  Mencantumkan pernyataan </td>
        <td class="td_left">
         <input class="uraianPenandaan romawi2Chk" type="radio" id="cradioI1" name="CHK[DUA][10]" value="+_Mencantumkan pernyataan" <?php if ($pend2[9][0] == '+') echo 'checked'; ?>>
         <label for="cradioI1" style="width: 70px; height: 10px;" title="Ya"></label>
         <span style="margin-left: 5px;"></span>
         <input class="uraianPenandaan romawi2Chk" type="radio" id="cradioI2" name="CHK[DUA][10]" value="-_Mencantumkan pernyataan" <?php if ($pend2[9][0] == '-') echo 'checked'; ?>>
         <label for="cradioI2" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak"></label>
         <input type="text" name="CHK[DUA][10]" style="display: none" rel = "required" value="<?php echo $d2[9]; ?>">
        </td>
       </tr>
       <tr class="penulisanTxt" hidden>
        <td>b. Letak Pernyataan :</td>
        <td>&nbsp;</td>
       </tr>
       <tr class="bungkusKotak infoPenandaanRokokRow" hidden>
        <td class="td_left_header_checklist" style="vertical-align: top">- Pada kemasan berbentuk kotak persegi panjang dan kotak dengan sisi lebar yang sama pernyataan diletakan pada sisi samping lainnya dari kemasan</td>
        <td class="td_left">
         <input class="uraianPenandaan romawi2Chk" type="radio" id="cradioJ1" name="CHK[DUA][11]" value="+_Pada kemasan berbentuk kotak persegi panjang dan kotak dengan sisi lebar yang sama pernyataan diletakan pada sisi samping lainnya dari kemasan" <?php if ($pend2[10][0] == '+') echo 'checked'; ?>>
         <label for="cradioJ1" style="width: 70px; height: 10px;" title="Ya"></label>
         <span style="margin-left: 5px;"></span>
         <input class="uraianPenandaan romawi2Chk" type="radio" id="cradioJ2" name="CHK[DUA][11]" value="-_Pada kemasan berbentuk kotak persegi panjang dan kotak dengan sisi lebar yang sama pernyataan diletakan pada sisi samping lainnya dari kemasan" <?php if ($pend2[10][0] == '-') echo 'checked'; ?>>
         <label for="cradioJ2" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak"></label>
         <input type="text" class="bungkusKotakVal" name="CHK[DUA][11]" style="display: none" value="<?php echo $d2[10]; ?>">
        </td>
       </tr>
       <tr class="bungkusBulat infoPenandaanRokokRow" hidden>
        <td class="td_left_header_checklist" style="vertical-align: top">- Pada kemasan berbentuk silinder (lingkaran) dan bentuk lainnya, pernyataan ditempatkan pada sisi atas tutup kemasan</td>
        <td class="td_left">
         <input class="uraianPenandaan romawi2Chk" type="radio" id="cradioK1" name="CHK[DUA][12]" value="+_Pada kemasan berbentuk silinder (lingkaran) dan bentuk lainnya, pernyataan ditempatkan pada sisi atas tutup kemasan" <?php if ($pend2[11][0] == '+') echo 'checked'; ?>>
         <label for="cradioK1" style="width: 70px; height: 10px;" title="Ya"></label>
         <span style="margin-left: 5px;"></span>
         <input class="uraianPenandaan romawi2Chk" type="radio" id="cradioK2" name="CHK[DUA][12]" value="-_Pada kemasan berbentuk silinder (lingkaran) dan bentuk lainnya, pernyataan ditempatkan pada sisi atas tutup kemasan" <?php if ($pend2[11][0] == '-') echo 'checked'; ?>>
         <label for="cradioK2" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak"></label>
         <input type="text" class="bungkusBulatVal" name="CHK[DUA][12]" style="display: none" value="<?php echo $d2[11]; ?>">
        </td>
       </tr>
       <tr class="infoPenandaanRokokRow">
        <td class="td_left_header_checklist" style="vertical-align: top">c.  Tulisan dicetak dengan jenis huruf kapital arial </td>
        <td class="td_left">
         <input class="uraianPenandaan romawi2Chk" type="radio" id="cradioL1" name="CHK[DUA][13]" value="+_Tulisan dicetak dengan jenis huruf kapital arial" <?php if ($pend2[12][0] == '+') echo 'checked'; ?>>
         <label for="cradioL1" style="width: 70px; height: 10px;" title="Ya"></label>
         <span style="margin-left: 5px;"></span>
         <input class="uraianPenandaan romawi2Chk" type="radio" id="cradioL2" name="CHK[DUA][13]" value="-_Tulisan dicetak dengan jenis huruf kapital arial" <?php if ($pend2[12][0] == '-') echo 'checked'; ?>>
         <label for="cradioL2" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak"></label>
         <input type="text" name="CHK[DUA][13]" style="display: none" rel = "required" value="<?php echo $d2[12]; ?>">
        </td>
       </tr>
       <tr class="infoPenandaanRokokRow">
        <td class="td_left_header_checklist" style="vertical-align: top">d.  Warna tulisan kontras dengan warna dasar dan terbaca dengan jelas</td>
        <td class="td_left">
         <input class="uraianPenandaan romawi2Chk" type="radio" id="cradioM1" name="CHK[DUA][14]" value="+_Warna tulisan kontras dengan warna dasar dan terbaca dengan jelas" <?php if ($pend2[13][0] == '+') echo 'checked'; ?>>
         <label for="cradioM1" style="width: 70px; height: 10px;" title="Ya"></label>
         <span style="margin-left: 5px;"></span>
         <input class="uraianPenandaan romawi2Chk" type="radio" id="cradioM2" name="CHK[DUA][14]" value="-_Warna tulisan kontras dengan warna dasar dan terbaca dengan jelas" <?php if ($pend2[13][0] == '-') echo 'checked'; ?>>
         <label for="cradioM2" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak"></label>
         <input type="text" name="CHK[DUA][14]" style="display: none" rel = "required" value="<?php echo $d2[13]; ?>">
        </td>
       </tr>
       <tr class="infoPenandaanRokokRow">
        <td class="td_left_header_checklist" style="vertical-align: top"><b>C. Pencantuman informasi kode produksi, tanggal, bulan, tahun, serta nama dan alamat produsen</b></td>
        <td class="td_left">&nbsp;</td>
       </tr>
       <tr class="infoPenandaanRokokRow">
        <td class="td_left_header_checklist" style="vertical-align: top">a.  Mencantumkan informasi:</td>
        <td class="td_left">
        </td>
       </tr>
       <tr class="infoPenandaanRokokRow">
        <td class="td_left_header_checklist" style="vertical-align: top">1.  Kode produksi, tanggal, bulan, tahun produksi </td>
        <td class="td_left">
         <input class="uraianPenandaan romawi2Chk" type="radio" id="cradioN1" name="CHK[DUA][15]" value="+_Kode produksi, tanggal, bulan, tahun produksi" <?php if ($pend2[14][0] == '+') echo 'checked'; ?>>
         <label for="cradioN1" style="width: 70px; height: 10px;" title="Ya"></label>
         <span style="margin-left: 5px;"></span>
         <input class="uraianPenandaan romawi2Chk" type="radio" id="cradioN2" name="CHK[DUA][15]" value="-_Kode produksi, tanggal, bulan, tahun produksi" <?php if ($pend2[14][0] == '-') echo 'checked'; ?>>
         <label for="cradioN2" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak"></label>
         <input type="text" name="CHK[DUA][15]" style="display: none" rel = "required" value="<?php echo $d2[14]; ?>">
        </td>
       </tr>
       <tr class="infoPenandaanRokokRow">
        <td class="td_left_header_checklist" style="vertical-align: top">2.  Nama dan alamat produsen </td>
        <td class="td_left">
         <input class="uraianPenandaan romawi2Chk" param = "namaAlamatProdusen" type="radio" id="cradioO1" name="CHK[DUA][16]" value="+_Nama dan alamat produsen" <?php if ($pend2[15][0] == '+') echo 'checked'; ?>>
         <label for="cradioO1" style="width: 70px; height: 10px;" title="Ya"></label>
         <span style="margin-left: 5px;"></span>
         <input class="uraianPenandaan romawi2Chk" param = "namaAlamatProdusen" type="radio" id="cradioO2" name="CHK[DUA][16]" value="-_Kode produksi, tanggal, bulan, tahun produksi" <?php if ($pend2[15][0] == '+') echo 'checked'; ?>>
         <label for="cradioO2" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak"></label>
         <input type="text" name="CHK[DUA][16]" style="display: none" rel = "required" value="<?php echo $d2[15]; ?>">
        </td>
       </tr>
       <tr class="namaAlamatProdusen"hidden>
        <td class="td_left_header_checklist" style="vertical-align: top"></td>
        <td class="td_left">
         Diletakan: <select name="CHK[DUA][17]" class="namaAlamatProdusen" id="CHK[DUA][16]"><option value=""></option><option value="Samping" <?php if ($pend2[16][0] == 'Samping') echo 'checked'; ?>>Samping</option><option value="Atas">Atas</option><option value="Bawah" <?php if ($pend2[16][0] == 'Bawah') echo 'checked'; ?>>Bawah</option></select>
        </td>
       </tr>
       <tr class="infoPenandaanRokokRow">
        <td class="td_left_header_checklist" style="vertical-align: top">b.  Informasi berbentuk:cetakan/stempel/emboss/stiker</td>
        <td class="td_left">
         <input class="uraianPenandaan romawi2Chk" type="radio" id="cradioP1" name="CHK[DUA][18]" value="+_Informasi berbentuk:cetakan/stempel/emboss/stiker" <?php if ($pend2[17][0] == '+') echo 'checked'; ?>>
         <label for="cradioP1" style="width: 70px; height: 10px;" title="Ya"></label>
         <span style="margin-left: 5px;"></span>
         <input class="uraianPenandaan romawi2Chk" type="radio" id="cradioP2" name="CHK[DUA][18]" value="-_Informasi berbentuk:cetakan/stempel/emboss/stiker" <?php if ($pend2[17][0] == '-') echo 'checked'; ?>>
         <label for="cradioP2" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak"></label>
         <input type="text" name="CHK[DUA][18]" style="display: none" rel = "required" value="<?php echo $d2[17]; ?>">
        </td>
       </tr>
       <tr class="infoPenandaanRokokRow">
        <td class="td_left_header_checklist" style="vertical-align: top"><b>D. Mencantumkan pernyataan “tidak ada batas aman”</b></td>
        <td class="td_left">
         <input class="uraianPenandaan romawi2Chk" type="radio" id="cradioQ1" name="CHK[DUA][19]" value='+_Mencantumkan pernyataan "tidak ada batas aman"' <?php if ($pend2[18][0] == '+') echo 'checked'; ?>>
         <label for="cradioQ1" style="width: 70px; height: 10px;" title="Ya"></label>
         <span style="margin-left: 5px;"></span>
         <input class="uraianPenandaan romawi2Chk" type="radio" id="cradioQ2" name="CHK[DUA][19]" value='-_Mencantumkan pernyataan "tidak ada batas aman"' <?php if ($pend2[18][0] == '-') echo 'checked'; ?>>
         <label for="cradioQ2" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak"></label>
         <input type="text" name="CHK[DUA][19]" style="display: none" rel = "required" value="<?php echo $d2[18]; ?>">
        </td>
       </tr>
       <tr class="infoPenandaanRokokRow">
        <td class="td_left_header_checklist" style="vertical-align: top"><b>E. Mencantumkan pernyataan “mengandung lebih dari 4000 zat kimia berbahaya serta lebih dari 43 zat penyebab kanker”</b></td>
        <td class="td_left">
         <input class="uraianPenandaan romawi2Chk" type="radio" id="cradioR1" name="CHK[DUA][20]" value='+_Mencantumkan pernyataan "mengandung lebih dari 4000 zat kimia berbahaya serta lebih dari 43 zat penyebab kanker"' <?php if ($pend2[19][0] == '+') echo 'checked'; ?>>
         <label for="cradioR1" style="width: 70px; height: 10px;" title="Ya"></label>
         <span style="margin-left: 5px;"></span>
         <input class="uraianPenandaan romawi2Chk" type="radio" id="cradioR2" name="CHK[DUA][20]" value='-_Mencantumkan pernyataan "mengandung lebih dari 4000 zat kimia berbahaya serta lebih dari 43 zat penyebab kanker"' <?php if ($pend2[19][0] == '-') echo 'checked'; ?>>
         <label for="cradioR2" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak"></label>
         <input type="text" name="CHK[DUA][20]" style="display: none" rel = "required" value="<?php echo $d2[19]; ?>">
        </td>
       </tr>
       <tr>
        <td class="td_left_header_checklist" style="vertical-align: top"><b>Hasil Evaluasi Pencantuman Informasi Kesehatan</b></td>
        <td class="td_left">
         <input type="text" id="kesimpulanHasilPenilaianromawi2" value="<?php
         if ($d2[20] == "MK")
          echo "Memenuhi Ketentuan";
         else
          echo "Tidak Memenuhi Ketentuan"
          ?>" readonly size="23" />
         <input type="hidden" id="kesimpulanHasilPenilaianromawi2Val" value="<?php echo $d2[20]; ?>" name="CHK[DUA][21]"  /></td>
       </tr>
      </table>
     </div>
    </div>
    <div style="height:5px;"></div>

    <!-- DIV Detail-->
    <div class="expand" id="expand1"><a title="expand/collapse" href="#" style="display: block;">PENCANTUMAN INFORMASI YANG MENYESATKAN</a></div>
    <div class="collapse">
     <div class="accCntnt">
      <table class="form_tabel">
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
        <td class="td_left_header_checklist" style="vertical-align: top"><b>Tidak mencantumkan Informasi menyesatkan</b></td>
        <td class="td_left">
        </td>
       </tr>
       <tr class="infoPenandaanRokokRow">
        <td class="td_left_header_checklist" style="vertical-align: top">a.  Tidak mencantumkan keterangan atau tanda apapun yang menyesatkan atau kata-kata yang bersifat promotif</td>
        <td class="td_left">
         <input class="uraianPenandaan romawi3Chk" param="Promotif" type="radio" id="dradioA1" name="CHK[TIGA][1]" value="+_Tidak mencantumkan keterangan atau tanda apapun yang menyesatkan atau kata-kata yang bersifat promotif" <?php if ($pend3[0][0] == '+') echo 'checked'; ?>>
         <label for="dradioA1" style="width: 70px; height: 10px;" title="Ya"></label>
         <span style="margin-left: 5px;"></span>
         <input class="uraianPenandaan romawi3Chk" param="Promotif" type="radio" id="dradioA2" name="CHK[TIGA][1]" value="-_Tidak mencantumkan keterangan atau tanda apapun yang menyesatkan atau kata-kata yang bersifat promotif" <?php if ($pend3[0][0] == '-') echo 'checked'; ?>>
         <label for="dradioA2" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak"></label>
         <input type="text" name="CHK[TIGA][1]" style="display: none" rel = "required" value="<?php echo $d3[0]; ?>">
        </td>
       </tr>
       <tr class="Promotif" hidden>
        <td>Jika mencantumkan, sebutkan</td>
        <td><textarea name="CHK[TIGA][2]" class="PromotifVal" style="width: 188px"><?php echo $d3[1]; ?>"</textarea></td>
       </tr>
       <tr class="infoPenandaanRokokRow">
        <td class="td_left_header_checklist" style="vertical-align: top">b.  Tidak mencantumkan kata”light”, “ultra light”, “mild”, “extra mild”,”low tar”, “slim”, “special”,”full flavor”, “premium”, atau kata lain yang mengindikasikan kualitas, superioritas, rasa aman, pencitraan, kepribadian atau kata-kata dengan arti sama.</td>
        <td class="td_left">
         <input class="uraianPenandaan romawi3Chk" param="Light" type="radio" id="dradioB1" name="CHK[TIGA][3]" value='+_Tidak mencantumkan kata "light", "ultra light", "mild", "extra mild","low tar", "slim", "special", "full flavor", "premium", atau kata lain yang mengindikasikan kualitas, superioritas, rasa aman, pencitraan, kepribadian atau kata-kata dengan arti sama.' <?php if ($pend3[2][0] == '+') echo 'checked'; ?>>
         <label for="dradioB1" style="width: 70px; height: 10px;" title="Ya"></label>
         <span style="margin-left: 5px;"></span>
         <input class="uraianPenandaan romawi3Chk" param="Light" type="radio" id="dradioB2" name="CHK[TIGA][3]" value='-_Tidak mencantumkan kata "light", "ultra light", "mild", "extra mild","low tar", "slim", "special", "full flavor", "premium", atau kata lain yang mengindikasikan kualitas, superioritas, rasa aman, pencitraan, kepribadian atau kata-kata dengan arti sama.' <?php if ($pend3[2][0] == '-') echo 'checked'; ?>>
         <label for="dradioB2" style="width: 70px; height: 10px; background-color: #9d0101" title="Tidak"></label>
         <input type="text" name="CHK[TIGA][3]" style="display: none" rel = "required" value="<?php echo $d3[2]; ?>">
        </td>
       </tr>
       <tr class="Light" hidden>
        <td>Jika mencantumkan, sebutkan</td>
        <td><textarea name="CHK[TIGA][4]" class="LightVal" style="width: 188px"><?php echo $d3[3]; ?></textarea></td>
       </tr>
       <tr>
        <td class="td_left_header_checklist" style="vertical-align: top"><b>Hasil Evaluasi Pencantuman Informasi Kesehatan</b></td>
        <td class="td_left">
         <input type="text" id="kesimpulanHasilPenilaianromawi3" value="<?php
         if ($d3[4] == "MK")
          echo "Memenuhi Ketentuan";
         else
          echo "Tidak Memenuhi Ketentuan"
          ?>" readonly size="23" />
         <input type="hidden" id="kesimpulanHasilPenilaianromawi3Val" value="<?php echo $d3[4]; ?>" name="CHK[TIGA][5]"  /></td>
       </tr>
      </table>
     </div>
    </div>
    <div style="height:5px;"></div>

    <div class="expand" id="expand5"><a title="expand/collapse" href="#" style="display: block;">KESIMPULAN</a></div>
    <div class="collapse">
     <div class="accCntnt">
      <h2 class="small garis"></h2>
      <table class="form_tabel">
       <tr>
        <td style="width: 30%; background-color: white"></td>
        <td style="width: 70%; background-color: white; font-size: 14px; padding-left: 250px; padding-right: 250px; padding-bottom: 5px; padding-top: 5px;" class="td_left"></td>
       </tr>
       <tr></tr>
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
        if (in_array('2', $this->newsession->userdata('SESS_KODE_ROLE')) && $editTL == 'YES') {
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
    <?php } ?>
    <div style="height:5px;"></div>

    <div class="expand"><a title="expand/collapse" href="#" style="display: block;">LAMPIRAN</a></div>
    <div class="collapse">
     <div class="accCntnt">
      <table class="form_tabel_detail">
       <tr>
        <td class="td_left_checklist" colspan="5" style="margin-right: 200px">
         <?php
         if (array_key_exists('FILE_PENANDAAN', $sess) && trim($sess['FILE_PENANDAAN']) != "") {
          ?><input type="hidden" name="PENANDAAN_NAPZA[FILE_PENANDAAN]" value="<?php echo $sess['FILE_PENANDAAN']; ?>">
          <span id="file_FILE_PENANDAAN"><a href="<?php echo base_url(); ?>files/<?php echo 'penandaan_007'; ?>/<?php echo $sess['FILE_PENANDAAN']; ?>" target="_blank">File Lampiran</a>&nbsp;&bull;&nbsp;<a href="#" class="del_upload" url="<?php echo site_url(); ?>/utility/uploads/del_upload_s/<?php echo 'penandaan_007'; ?>/<?php echo $sess['FILE_PENANDAAN']; ?>" jns="FILE_PENANDAAN">Edit atau Hapus File ?</a></span>
          <span class="upload_FILE_PENANDAAN" hidden><input type="file" class="upload" jenis="FILE_PENANDAAN" allowed="jpg-jpeg-pdf-doc-docx" url="<?php echo site_url(); ?>/utility/uploads/get_upload_s/<?php echo 'penandaan_007'; ?>" id="fileToUpload_FILE_PENANDAAN" name="userfile" onchange="do_upload($(this));
            return false;" title="Lampiran Berita Acara" />
           &nbsp;Tipe File : *.jpg .jpeg .pdf .doc .docx</span><span class="file_FILE_PENANDAAN"></span>
          <?php
         } else {
          ?>
          <span class="upload_FILE_PENANDAAN"><input type="file" class="upload" jenis="FILE_PENANDAAN" allowed="jpg-jpeg-pdf-doc-docx" url="<?php echo site_url(); ?>/utility/uploads/get_upload_s/<?php echo 'penandaan_007'; ?>" id="fileToUpload_FILE_PENANDAAN" name="userfile" onchange="do_upload($(this));
            return false;" title="Lampiran Berita Acara" />
           &nbsp;Tipe File : *.jpg .jpeg .pdf .doc .docx</span><span class="file_FILE_PENANDAAN"></span>
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
    <input type="hidden" name="UPDATE" value="<?php echo $sess['STATUS']; ?>" />
    <input type="hidden" name="EDIT" value="<?php echo $editTL; ?>" />
    <input type="hidden" name="KLASIFIKASIPENANDAAN" value="<?php echo $klasifikasi; ?>" />
    <input type="hidden" name="TUJUAN" value="<?php echo $tujuan; ?>" />
   </div>
  </div>
 </form>
</div>
<script type="text/javascript">
          function goBack() {
           window.history.back()
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
          function checklistSub(clazz) {
           var i = 0;
           $('.' + clazz).each(function() {
            if ($(this).is(":checked")) {
             $('.' + clazz).closest("td").css('border-left', '0px solid #F00');
             i++;
            }
            else
             i - 1;
           });
           if (i != 0) {
            $('.' + clazz + 'Val').attr("rel", "");
           }
           else
            $('.' + clazz + 'Val').attr("rel", "required");
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
             if (typeof (data.error) != "undefined") {
              if (data.error != "") {
               jAlert(data.error, "SIPT Versi 1.0 Beta");
              } else {
               if (arrdata[2] == "FILE_PENANDAAN") {
                $("#fileToUpload_" + arrdata[2] + "").removeAttr("rel");
                $(".upload_" + arrdata[2] + "").hide();
                $("#file_" + arrdata[2] + "").hide();
                $(".file_" + arrdata[2] + "").html("<b>1 File telah dilampirkan. </b>&nbsp;<a href=\"<?php echo base_url(); ?>files/" + arrdata[3] + "/" + arrdata[0] + "\" target=\"_blank\">Tampilkan File</a>&nbsp;&bull;&nbsp;<a href=\"#\" class=\"del_upload\" url=\"<?php echo site_url(); ?>/utility/uploads/del_upload_s/" + arrdata[3] + "/" + arrdata[0] + "\" jns=" + arrdata[2] + ">Edit atau Hapus File ?</a><input type=\"hidden\" name=\"PENANDAAN_NAPZA[" + arrdata[2] + "]\" value=" + arrdata[0] + ">");
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
          function bentukKemasanHide(obj) {
           if ($(obj).val() !== "")
            $(".penulisanTxt").show();
           else
            $(".penulisanTxt").hide();
           if ($(obj).val() == "KPP" || $(obj).val() == "KSL") {
            $(".bungkusKotak").show();
            $(".bungkusKotakVal").attr("rel", "required");
            $(".bungkusBulat").hide();
            $("#bungkusBulatVal").attr("rel", "");
           }
           if ($(obj).val() == "SLN" || $(obj).val() == "BLL") {
            $(".bungkusKotak").hide();
            $(".bungkusKotakVal").attr("rel", "");
            $(".bungkusBulat").show();
            $("#bungkusBulatVal").attr("rel", "required");
           }
          }
          function checkListTxt(XXX) {
           var A = $(XXX).val().split('_');
           var B = "A";
           var param = $(XXX).attr('param');
           var name = $(XXX).attr("name");
           if (name === "CHK[TIGA][1]" || name === "CHK[SATU][8]" || name === "CHK[TIGA][3]" || name === "CHK[SATU][9]")
            B = "B";
           if (A[0] === '+' && B === "A") {
            $('.' + param).show();
            $('.' + param + "Val").attr("rel", "required");
            $("[id='" + name + "']").attr("rel", "required");
            if (param == "Promotif" || param == "Light") {
             $('.' + param + 'Val').css("background-color", "#FFF");
             $('.' + param + 'Val').css("border", "");
            }
           }
           else if (A[0] === '-' && B === "B") {
            $('.' + param).show();
            $('.' + param + "Val").attr("rel", "required");
            $("[id='" + name + "']").attr("rel", "required");
           }
           else {
            if (param == "Kadar" || param == "namaAlamatProdusen")
             $('.' + param).val('');
            else if (param == "Promotif" || param == "Light") {
             $('.' + param + 'Val').val('');
            }
            $('.' + param).hide();
            $('.' + param + "Val").attr("rel", "");
            $('.' + param).attr('checked', false);
            $('.' + param + "r").attr('checked', false);
            $("[id='" + name + "']").val("");
            $("[id='" + name + "']").attr("rel", "");
           }
           mkTmk();
          }
          function mkTmk() {
           var X = false, X2 = false, X3 = false, X4 = false;
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
           $('.romawi2Chk').each(function() {
            if ($(this).is(":checked") === true) {
             var a = $(this).val().split('_');
             if (a[0] === '-') {
              X3 = true;
             }
            }
           });
           $('.romawi3Chk').each(function() {
            if ($(this).is(":checked") === true) {
             var a = $(this).val().split('_');
             if (a[0] === '+') {
              X4 = true;
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
           if (X3 === true) {
            $('#kesimpulanHasilPenilaianromawi2').val('Tidak Memenuhi Ketentuan');
            $('#kesimpulanHasilPenilaianromawi2Val').val('TMK');
           } else if (X3 !== true) {
            $('#kesimpulanHasilPenilaianromawi2').val('Memenuhi Ketentuan');
            $('#kesimpulanHasilPenilaianromawi2Val').val('MK');
           }
           if (X4 === true) {
            $('#kesimpulanHasilPenilaianromawi3').val('Tidak Memenuhi Ketentuan');
            $('#kesimpulanHasilPenilaianromawi3Val').val('TMK');
           } else if (X4 !== true) {
            $('#kesimpulanHasilPenilaianromawi3').val('Memenuhi Ketentuan');
            $('#kesimpulanHasilPenilaianromawi3Val').val('MK');
           }
           if ($('#kesimpulanHasilPenilaianromawi1Val').val() == "TMK" || $('#kesimpulanHasilPenilaianromawi2Val').val() == "TMK" || $('#kesimpulanHasilPenilaianromawi3Val').val() == "TMK") {
            $('#kesimpulanHasilPenilaian').val('Tidak Memenuhi Ketentuan');
            $('#kesimpulanHasilPenilaianVal').val('TMK');
            $(".TDKB").show();
           } else if ($('#kesimpulanHasilPenilaianromawi1Val').val() == "MK" && $('#kesimpulanHasilPenilaianromawi2Val').val() == "MK" && $('#kesimpulanHasilPenilaianromawi3Val').val() == "MK") {
            $('#kesimpulanHasilPenilaian').val('Memenuhi Ketentuan');
            $('#kesimpulanHasilPenilaianVal').val('MK');
            $(".TDKB").hide();
           }
          }
          $(document).ready(function() {
           $("textarea.chkJustifikasi").redactor({
            buttons: ['bold', 'italic', '|', 'unorderedlist', 'orderedlist', 'outdent', 'indent', '|', 'alignleft', 'aligncenter', 'alignright', 'justify'],
            removeStyles: false,
            cleanUp: true,
            autoformat: true
           });
<?php if (!empty($d1)) { ?>
            $(".uraianPenandaan").each(function() {
             if ($(this).is(":checked"))
              checkListTxt($(this));
            });
<?php } ?>
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
           $(".uraianPenandaan").click(function() {
            var name = $(this).attr("name");
            var selected = $("[name='" + name + "']:checked").val();
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
              if (jenis !== "FILE_LAMPIRAN_PENANDAAN")
               $("#fileToUpload_" + jenis + "").attr("rel", "");
             }
            });
            return false;
           });
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
              if (jenis !== "FILE_LAMPIRAN_PENANDAAN")
               $("#fileToUpload_" + jenis + "").attr("rel", "");
             }
            });
            return false;
           });
           $("#jenisPengawasan").change(function() {
            showHide();
           });
           $(".subPenilaianPoin1GT").click(function() {
            checklistSub('subPenilaianPoin1GT');
           });
          });</script>