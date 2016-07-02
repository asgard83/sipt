<?php
if (!defined('BASEPATH'))
 exit('No direct script access allowed');
error_reporting(E_ERROR);
?>
<div id="judulpmnikl" class="judul"></div>
<div class="headersarana">PENGAWASAN IKLAN ROKOK</div>
<?php
$penilaian = explode("#", $sess['PENILAIAN']);
$hasil = explode("^", $sess['TL_PUSAT']);
$napzaMediaInfoArr = explode("^", $sess['JUDUL_KEGIATAN']);
$arraySign = array("+", "-");
$arrayGT = array("CT", "LR", "TV", "TI", "RD");
?>
<div class="content">
 <form action="<?php echo $act; ?>" method="post" autocomplete="off" id="fpengawasanIklan_012">
  <div class="adCntnr">
   <div class="acco2">
    <div class="expand"><a title="expand/collapse" href="#" style="display: block;">INFORMASI PENGAWASAN IKLAN</a></div>
    <div class="collapse">
     <div class="accCntnt">
      <h2 class="small garis">Informasi Pengawasan Iklan</h2>
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
         <?php echo $sess['TANGGAL_MULAI']; ?>
       </tr>
       <tr><td class="td_left">Jenis Iklan</td>
        <td class="td_right"><?php echo $sess['KELOMPOK_IKLAN']; ?></td>
       </tr>
      </table>
     </div>
    </div>

    <div style="height:5px;"></div><div class="expand"><a title="expand/collapse" href="#" style="display: block;">INFORMASI ROKOK - IKLAN</a></div>
    <div class="collapse">
     <div class="accCntnt">
      <?php echo $sess2; ?>
     </div>
    </div>

    <div style="height:5px;"></div>
    <div class="expand"><a title="expand/collapse" href="#" style="display: block;">IDENTITAS MEDIA PENAYANGAN IKLAN</a></div>
    <div class="collapse">
     <div class="accCntnt">
      <h2 class="small garis">Informasi Media Iklan</h2>
      <table class="form_tabel">
       <?php if (trim($sess['JENIS_IKLAN']) != "") { ?><tr><td class="td_left">Media</td><td class="td_right"><?php echo $sess['JENIS_IKLAN']; ?></td>
        </tr>
       <?php } if (trim($sess['MEDIA']) != "") { ?><tr><td class="td_left"><?php if(trim($sess['JENIS_IKLAN']) == "Media Teknologi Informasi Lainnya") echo "Nama Media Teknologi Informasi Lainnya"; else echo "Jenis Media";?></td><td class="td_right"><?php echo $sess['MEDIA']; ?></td>
        </tr>
       <?php } if (trim($sess['NAMA_MEDIA']) != "" && $sess['NAMA_MEDIA'] != '0') { ?><tr><td class="td_left"><?php
        if (trim($sess['JENIS_IKLAN']) == "Media Teknologi Informasi Lainnya") {
         echo 'Alamat Website';
        } else {
         echo 'Nama Situs';
        }
        ?></td><td class="td_right"><?php echo $sess['NAMA_MEDIA']; ?></td>
        </tr>
       <?php } if (trim($sess['JAM_TAYANG']) != "") { ?><tr><td class="td_left"><?php if(trim($sess['JENIS_IKLAN']) == "Media Teknologi Informasi Lainnya") echo "Waktu Pemantauan"; else echo "Jam Tayang";?></td><td class="td_right"><?php echo str_replace(" ", ".", $sess['JAM_TAYANG']); ?></td>
        </tr>
        <?php
       }
       $edisiUraian = explode("^", $sess['EDISI']);
       if (trim($sess['JENIS_IKLAN']) == "Cetak") {
        if (trim($edisiUraian[0]) != "") {
         ?>
         <tr><td class="td_left">Edisi</td><td class="td_right"><?php
           echo $edisiUraian[0];
           ?></td>
         </tr>
        <?php } if (trim($edisiUraian[1]) != "") {
         ?>
         <tr><td class="td_left">Halaman</td><td class="td_right"><?php
           echo $edisiUraian[1];
           ?></td>
         </tr>
         <?php
        }
       } if ($sess['JUDUL_KEGIATAN'] != NULL) {
        ?><tr><td class="td_left">Versi Iklan</td><td class="td_right"><?php echo $sess['JUDUL_KEGIATAN']; ?></td>
        </tr>
       <?php } if (trim($sess['JENIS_IKLAN']) == "Luar Ruang") { ?>
        <tr><td class="td_left">Alamat / Lokasi Pengawasan Iklan</td><td class="td_right"><?php
          echo $edisiUraian[0];
          ?></td>
        </tr>
        <?php if (in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')) || $this->newsession->userdata("SESS_BBPOM_ID") == "50") { ?><tr><td class="td_left">Provinsi</td><td class="td_right"><?php
         if ($provinsiVal2) {
          echo $provinsiVal2;
         } else {
          echo "-";
         }
         ?></td>
         </tr><?php } ?>
        <tr><td class="td_left">Kota / Kabupaten</td><td class="td_right"><?php
          if (trim($sess['KOTA']) != '') {
           echo $sess['KOTA'];
          } else {
           echo '-';
          }
          ?></td>
        </tr>
       <?php } ?>
      </table>
     </div>
    </div>
    <div style="height:5px;"></div>

    <!--5-->
    <div class="expand" id="expand5"><a title="expand/collapse" href="#" style="display: block;">PENILAIAN</a></div>
    <div class="collapse">
     <div class="accCntnt">
      <h2 class="small garis">Penilaian :</h2>
      <table class="form_tabel">
       <tr>
        <td style="width: 2%;"></td>
        <td style="width: 25%;"></td>
        <td style="width: 3%;"></td>
        <td style="width: 70%;"></td>
       </tr>
       <?php
       if (trim($sess['MEDIA']) == "TV") {
        $i = 1;
        $arrayCt = array("7", "9", "10");
        foreach ($penilaian as $value) {
         $val = explode("_", $value);
         if ($i == 1) {
          ?>
          <tr>
           <td class="td_left" colspan="6"><b><u>PENGAWASAN PENCANTUMAN PERINGATAN KESEHATAN</u></b></td>
          </tr>
         <?php } else if ($i == 12) {
          ?>
          <tr>
           <td class="td_left" colspan="6"><b><u>MATERI IKLAN  LAINNYA</u></b></td>
          </tr>
          <?php
         }
         if (in_array($i, $arrayCt)) {
          ?>
          <tr>
           <td></td>
           <td class="td_left"><?php
            if ($i == 7)
             echo "Tulisan Peringatan Kesehatan";
            else if ($i == 9)
             echo "Durasi Iklan 10% dari total durasi";
            else if ($i == 10)
             echo " Full Screen";
            ?></td>
           <td class="td_left">&raquo;&raquo;</td>
           <td class="td_left"><span id="uraianP">
             <?php
             if ($i == 7 || $i == 10) {
              $exp = explode("^", $value);
              unset($str);
              foreach ($exp as $entry) {
               if (array_key_exists($entry, $romawi1_2))
                $str[] = $romawi1_2[$entry];
              }
              echo join("; ", $str);
             } else {
              if (array_key_exists($value, $romawi1_4))
               echo $romawi1_4[$value];
             }
             ?></span></td>
           <td></td>
          </tr>
          <?php
         } else if (in_array($val[0], $arraySign)) {
          ?>
          <tr>
           <td></td>
           <td class="td_left"><?php echo $val[1]; ?></td>
           <td class="td_left">&raquo;&raquo;</td>
           <td class="td_left"><span id="uraianP">
             <?php
             if ($val[0] == "+") {
              if ($i == 1)
               echo "Ya";
              else
               echo "Sesuai";
             }
             else if ($val[0] == "-") {
              if ($i == 1)
               echo "Tidak";
              else
               echo "Tidak Sesuai";
             }
             ?></span></td>
           <td></td>
          </tr>
         <?php } else if ($val[0] == "TMK" || $val[0] == "MK") { ?>
          <tr>
           <td></td>
           <td class="td_left"><b>&nbsp;&nbsp;&nbsp;<?php
          if ($i == 17)
           echo "Kesimpulan";
          else
           echo "Evaluasi";
          ?></b></td>
           <td class="td_left">&raquo;&raquo;</td>
           <td class="td_left"><b>
             <?php
             if ($val[0] == "MK")
              echo "Memenuhi Ketentuan";
             else if ($val[0] == "TMK")
              echo "Tidak Memenuhi Ketentuan";
             ?></b></td>
           <td></td>
          </tr>
          <?php
         } else if (in_array($val[0], $arrayGT)) {
          if ($val[1] == "GT1")
           $gt = "Gambar 1 : Gambar kanker mulut <br /> Tulisan 1 : Merokok sebabkan kanker mulut";
          if ($val[1] == "GT2")
           $gt = "Gambar 2 : Gambar orang merokok dengan asap yang membentuk tengkorak<br /> Tulisan 2 : Merokok Membunuhmu";
          if ($val[1] == "GT3")
           $gt = "Gambar 3 : Gambar kanker tenggorokan<br /> Tulisan 3 : Merokok Sebabkan Kanker Tenggorokan";
          if ($val[1] == "GT4")
           $gt = "Gambar 4 : Gambar orang merokok dengan anak didekatnya<br /> Tulisan 4 : Merokok Dekat Anak Berbahaya Bagi Mereka";
          if ($val[1] == "GT5")
           $gt = "Gambar 5 : Gambar paru-paru yang menghitam karena kanker<br /> Tulisan 5 : Merokok Sebabkan Kanker Paru-paru dan Bronkitis Kronis";
          ?>
          <tr>
           <td></td>
           <td class="td_left"><b>&nbsp;&nbsp;&nbsp;</b></td>
           <td class="td_left">&raquo;&raquo;</td>
           <td class="td_left"><b>
             <?php
             echo $gt;
             ?></b></td>
           <td></td>
          </tr>
          <?php
         }
         $i++;
        }
       }
       else if (trim($sess['JENIS_IKLAN']) == "Cetak") {
        $i = 1;
        $arrayCt = array("7", "9");
        foreach ($penilaian as $value) {
         $val = explode("_", $value);
         if ($i == 1) {
          ?>
          <tr>
           <td class="td_left" colspan="6"><b><u>PENGAWASAN PENCANTUMAN PERINGATAN KESEHATAN</u></b></td>
          </tr>
         <?php } else if ($i == 11) {
          ?>
          <tr>
           <td class="td_left" colspan="6"><b><u>MATERI IKLAN  LAINNYA</u></b></td>
          </tr>
          <?php
         }
         if (in_array($i, $arrayCt)) {
          ?>
          <tr>
           <td></td>
           <td class="td_left"><?php
       if ($i == 7)
        echo "Tulisan Peringatan Kesehatan";
       else if ($i == 9)
        echo "Luas";
          ?></td>
           <td class="td_left">&raquo;&raquo;</td>
           <td class="td_left"><span id="uraianP">
             <?php
             if ($i == 7) {
              $exp = explode("^", $value);
              foreach ($exp as $entry) {
               if (array_key_exists($entry, $romawi1_2))
                $str[] = $romawi1_2[$entry];
              }
              echo join("; ", $str);
             } else {
              if (array_key_exists($value, $romawi1_4))
               echo $romawi1_4[$value];
             }
             ?></span></td>
           <td></td>
          </tr>
          <?php
         } else if (in_array($val[0], $arraySign)) {
          ?>
          <tr>
           <td></td>
           <td class="td_left"><?php echo $val[1]; ?></td>
           <td class="td_left">&raquo;&raquo;</td>
           <td class="td_left"><span id="uraianP">
             <?php
             if ($val[0] == "+") {
              if ($i == 1)
               echo "Ya";
              else
               echo "Sesuai";
             }
             else if ($val[0] == "-") {
              if ($i == 1)
               echo "Tidak";
              else
               echo "Tidak Sesuai";
             }
             ?></span></td>
           <td></td>
          </tr>
         <?php } else if ($val[0] == "TMK" || $val[0] == "MK") { ?>
          <tr>
           <td></td>
           <td class="td_left"><b>&nbsp;&nbsp;&nbsp;<?php
          if ($i == 22)
           echo "Kesimpulan";
          else
           echo "Evaluasi";
          ?></b></td>
           <td class="td_left">&raquo;&raquo;</td>
           <td class="td_left"><b>
             <?php
             if ($val[0] == "MK")
              echo "Memenuhi Ketentuan";
             else if ($val[0] == "TMK")
              echo "Tidak Memenuhi Ketentuan";
             ?></b></td>
           <td></td>
          </tr>
          <?php
         } else if (in_array($val[0], $arrayGT)) {
          if ($val[1] == "GT1")
           $gt = "Gambar 1 : Gambar kanker mulut <br /> Tulisan 1 : Merokok sebabkan kanker mulut";
          if ($val[1] == "GT2")
           $gt = "Gambar 2 : Gambar orang merokok dengan asap yang membentuk tengkorak<br /> Tulisan 2 : Merokok Membunuhmu";
          if ($val[1] == "GT3")
           $gt = "Gambar 3 : Gambar kanker tenggorokan<br /> Tulisan 3 : Merokok Sebabkan Kanker Tenggorokan";
          if ($val[1] == "GT4")
           $gt = "Gambar 4 : Gambar orang merokok dengan anak didekatnya<br /> Tulisan 4 : Merokok Dekat Anak Berbahaya Bagi Mereka";
          if ($val[1] == "GT5")
           $gt = "Gambar 5 : Gambar paru-paru yang menghitam karena kanker<br /> Tulisan 5 : Merokok Sebabkan Kanker Paru-paru dan Bronkitis Kronis";
          ?>
          <tr>
           <td></td>
           <td class="td_left"><b>&nbsp;&nbsp;&nbsp;</b></td>
           <td class="td_left">&raquo;&raquo;</td>
           <td class="td_left"><b>
             <?php
             echo $gt;
             ?></b></td>
           <td></td>
          </tr>
          <?php
         }
         $i++;
        }
       }
       else if (trim($sess['MEDIA']) == "Radio") {
        $i = 1;
        $arrayCt = array("1", "7", "8");
        foreach ($penilaian as $value) {
         $val = explode("_", $value);
         if (in_array($i, $arrayCt)) {
          ?>
          <tr>
           <td></td>
           <td class="td_left"><?php
       if ($i == 1)
        echo "Narasi Peringatan Kesehatan";
       else if ($i == 7)
        echo "Durasi Peringatan Kesehatan : minimal 10% dari total durasi iklan";
       else
        echo "Tuliskan durasi peringatan kesehatan";
          ?></td>
           <td class="td_left">&raquo;&raquo;</td>
           <td class="td_left"><span id="uraianP">
             <?php
             if ($i == 1) {
              $exp = explode("^", $value);
              foreach ($exp as $entry) {
               if (array_key_exists($entry, $romawi1_2))
                $str[] = $romawi1_2[$entry];
              }
              echo join("; ", $str);
             } else {
              if (array_key_exists($value, $romawi1_4))
               echo $romawi1_4[$value];
              else
               echo $value . "  Detik";
             }
             ?></span></td>
           <td></td>
          </tr>
         <?php } else if ($val[0] == "TMK" || $val[0] == "MK") {
          ?>
          <tr>
           <td></td>
           <td class="td_left"><b>&nbsp;&nbsp;&nbsp;<?php
       if ($i == 9)
        echo "Kesimpulan";
       else
        echo "Evaluasi";
          ?></b></td>
           <td class="td_left">&raquo;&raquo;</td>
           <td class="td_left"><b>
             <?php
             if ($val[0] == "MK")
              echo "Memenuhi Ketentuan";
             else if ($val[0] == "TMK")
              echo "Tidak Memenuhi Ketentuan";
             ?></b></td>
           <td></td>
          </tr>
          <?php
         } else if (in_array($val[0], $arrayGT)) {
          if ($val[1] == "GT1")
           $gt = "Suara sesuai gambar 1 : Merokok sebabkan kanker mulut";
          if ($val[1] == "GT2")
           $gt = "Suara sesuai gambar 2 : Merokok membunuhmu";
          if ($val[1] == "GT3")
           $gt = "Suara sesuai gambar 3 : Merokok sebabkan kanker tenggorokan";
          if ($val[1] == "GT4")
           $gt = "Suara sesuai gambar 4 : Merokok dekat anak bahaya bagi mereka";
          if ($val[1] == "GT5")
           $gt = " 	Suara sesuai gambar 5 : Merokok sebabkan kanker paru-paru dan bronkitis kronis";
          ?>
          <tr>
           <td></td>
           <td class="td_left"><b>&nbsp;&nbsp;&nbsp;</b></td>
           <td class="td_left">&raquo;&raquo;</td>
           <td class="td_left"><b>
             <?php
             echo $gt;
             ?></b></td>
           <td></td>
          </tr>
          <?php
         }
         $i++;
        }
       }
       else if (trim($sess['JENIS_IKLAN']) == "Luar Ruang") {
        $i = 1;
        $arrayCt = array("7", "9");
        foreach ($penilaian as $value) {
         $val = explode("_", $value);
         if ($i == 1) {
          ?>
          <tr>
           <td class="td_left" colspan="6"><b><u>PENGAWASAN PENCANTUMAN PERINGATAN KESEHATAN</u></b></td>
          </tr>
         <?php } else if ($i == 11) {
          ?>
          <tr>
           <td class="td_left" colspan="6"><b><u>MATERI IKLAN  LAINNYA</u></b></td>
          </tr>
          <?php
         } else if ($i == 17) {
          ?>
          <tr>
           <td class="td_left" colspan="6"><b><u>KETENTUAN KHUSUS DI MEDIA LUAR RUANG</u></b></td>
          </tr>
          <?php
         }
         if (in_array($i, $arrayCt)) {
          ?>
          <tr>
           <td></td>
           <td class="td_left"><?php
       if ($i == 7)
        echo "Tulisan Peringatan Kesehatan";
       else
        echo "Luas";
          ?></td>
           <td class="td_left">&raquo;&raquo;</td>
           <td class="td_left"><span id="uraianP">
             <?php
             if ($i == 7) {
              $exp = explode("^", $value);
              foreach ($exp as $entry) {
               if (array_key_exists($entry, $romawi1_2))
                $str[] = $romawi1_2[$entry];
              }
              echo join("; ", $str);
             } else {
              if (array_key_exists($value, $romawi1_4))
               echo $romawi1_4[$value];
             }
             ?></span></td>
           <td></td>
          </tr>
          <?php
         } else if (in_array($val[0], $arraySign)) {
          ?>
          <tr>
           <td></td>
           <td class="td_left"><?php echo $val[1]; ?></td>
           <td class="td_left">&raquo;&raquo;</td>
           <td class="td_left"><span id="uraianP">
             <?php
             if ($val[0] == "+") {
              if ($i == 1)
               echo "Ya";
              else
               echo "Sesuai";
             }
             else if ($val[0] == "-") {
              if ($i == 1)
               echo "Tidak";
              else
               echo "Tidak Sesuai";
             }
             ?></span></td>
           <td></td>
          </tr>
         <?php } else if ($val[0] == "TMK" || $val[0] == "MK") { ?>
          <tr>
           <td></td>
           <td class="td_left"><b>&nbsp;&nbsp;&nbsp;<?php
          if ($i == 22)
           echo "Kesimpulan";
          else
           echo "Evaluasi";
          ?></b></td>
           <td class="td_left">&raquo;&raquo;</td>
           <td class="td_left"><b>
             <?php
             if ($val[0] == "MK")
              echo "Memenuhi Ketentuan";
             else if ($val[0] == "TMK")
              echo "Tidak Memenuhi Ketentuan";
             ?></b></td>
           <td></td>
          </tr>
          <?php
         } else if (in_array($val[0], $arrayGT)) {
          if ($val[1] == "GT1")
           $gt = "Gambar 1 : Gambar kanker mulut <br /> Tulisan 1 : Merokok sebabkan kanker mulut";
          if ($val[1] == "GT2")
           $gt = "Gambar 2 : Gambar orang merokok dengan asap yang membentuk tengkorak<br /> Tulisan 2 : Merokok Membunuhmu";
          if ($val[1] == "GT3")
           $gt = "Gambar 3 : Gambar kanker tenggorokan<br /> Tulisan 3 : Merokok Sebabkan Kanker Tenggorokan";
          if ($val[1] == "GT4")
           $gt = "Gambar 4 : Gambar orang merokok dengan anak didekatnya<br /> Tulisan 4 : Merokok Dekat Anak Berbahaya Bagi Mereka";
          if ($val[1] == "GT5")
           $gt = "Gambar 5 : Gambar paru-paru yang menghitam karena kanker<br /> Tulisan 5 : Merokok Sebabkan Kanker Paru-paru dan Bronkitis Kronis";
          ?>
          <tr>
           <td></td>
           <td class="td_left"><b>&nbsp;&nbsp;&nbsp;</b></td>
           <td class="td_left">&raquo;&raquo;</td>
           <td class="td_left"><b>
             <?php
             echo $gt;
             ?></b></td>
           <td></td>
          </tr>
          <?php
         }
         $i++;
        }
       }
       else if (trim($sess['JENIS_IKLAN']) == "Media Teknologi Informasi Lainnya") {
        $i = 1;
        $arrayCt = array("7", "9");
        foreach ($penilaian as $value) {
         $val = explode("_", $value);
         if ($i == 1) {
          ?>
          <tr>
           <td class="td_left" colspan="6"><b><u>PENGAWASAN PENCANTUMAN PERINGATAN KESEHATAN</u></b></td>
          </tr>
         <?php } else if ($i == 11) {
          ?>
          <tr>
           <td class="td_left" colspan="6"><b><u>MATERI IKLAN  LAINNYA</u></b></td>
          </tr>
          <?php
         }
         if (in_array($i, $arrayCt)) {
          ?>
          <tr>
           <td></td>
           <td class="td_left"><?php
       if ($i == 7)
        echo "Tulisan Peringatan Kesehatan";
       else
        echo "Luas Iklan atau Durasi Iklan";
          ?></td>
           <td class="td_left">&raquo;&raquo;</td>
           <td class="td_left"><span id="uraianP">
             <?php
             if ($i == 7) {
              $exp = explode("^", $value);
              foreach ($exp as $entry) {
               if (array_key_exists($entry, $romawi1_2))
                $str[] = $romawi1_2[$entry];
              }
              echo join("; ", $str);
             } else {
              if (array_key_exists($value, $romawi1_4))
               echo $romawi1_4[$value];
             }
             ?></span></td>
           <td></td>
          </tr>
          <?php
         } else if (in_array($val[0], $arraySign)) {
          ?>
          <tr>
           <td></td>
           <td class="td_left"><?php echo $val[1]; ?></td>
           <td class="td_left">&raquo;&raquo;</td>
           <td class="td_left"><span id="uraianP">
             <?php
             if ($val[0] == "+") {
              if ($i == 1)
               echo "Ya";
              else
               echo "Sesuai";
             }
             else if ($val[0] == "-") {
              if ($i == 1)
               echo "Tidak";
              else
               echo "Tidak Sesuai";
             }
             ?></span></td>
           <td></td>
          </tr>
         <?php } else if ($val[0] == "TMK" || $val[0] == "MK") { ?>
          <tr>
           <td></td>
           <td class="td_left"><b>&nbsp;&nbsp;&nbsp;<?php
          if ($i == 17)
           echo "Kesimpulan";
          else
           echo "Evaluasi";
          ?></b></td>
           <td class="td_left">&raquo;&raquo;</td>
           <td class="td_left"><b>
             <?php
             if ($val[0] == "MK")
              echo "Memenuhi Ketentuan";
             else if ($val[0] == "TMK")
              echo "Tidak Memenuhi Ketentuan";
             ?></b></td>
           <td></td>
          </tr>
          <?php
         } else if (in_array($val[0], $arrayGT)) {
          if ($val[1] == "GT1")
           $gt = "Gambar 1 : Gambar kanker mulut <br /> Tulisan 1 : Merokok sebabkan kanker mulut";
          if ($val[1] == "GT2")
           $gt = "Gambar 2 : Gambar orang merokok dengan asap yang membentuk tengkorak<br /> Tulisan 2 : Merokok Membunuhmu";
          if ($val[1] == "GT3")
           $gt = "Gambar 3 : Gambar kanker tenggorokan<br /> Tulisan 3 : Merokok Sebabkan Kanker Tenggorokan";
          if ($val[1] == "GT4")
           $gt = "Gambar 4 : Gambar orang merokok dengan anak didekatnya<br /> Tulisan 4 : Merokok Dekat Anak Berbahaya Bagi Mereka";
          if ($val[1] == "GT5")
           $gt = "Gambar 5 : Gambar paru-paru yang menghitam karena kanker<br /> Tulisan 5 : Merokok Sebabkan Kanker Paru-paru dan Bronkitis Kronis";
          ?>
          <tr>
           <td></td>
           <td class="td_left"><b>&nbsp;&nbsp;&nbsp;</b></td>
           <td class="td_left">&raquo;&raquo;</td>
           <td class="td_left"><b>
             <?php
             echo $gt;
             ?></b></td>
           <td></td>
          </tr>
          <?php
         }
         $i++;
        }
       }
       ?>


      </table>
     </div>
    </div>
    <div style="height:5px;"></div>

    <?php if ($sess['FILE_IKLAN'] != '') { ?>
     <div class="expand" id="expand5"><a title="expand/collapse" href="#" style="display: block;">LAMPIRAN</a></div>
     <div class="collapse">
      <div class="accCntnt">
       <table class="form_tabel">
        <tr><td class="td_left">Lampiran</td><td class="td_right"><a href="<?php echo base_url(); ?>files/<?php echo 'iklan_007'; ?>/<?php echo $sess['FILE_IKLAN']; ?>" target="_blank">Lihat Lampiran</a></td></tr>
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
    <?php } ?>
    <div style="padding:10px;"></div><div><?php if ($formEdit === 'check') { ?><a href="javascript:void(0)" id="btnSave" class="button check" onclick="fpost('#fpengawasanIklan_012', '', '');">
       <span><span class="icon"></span>&nbsp; <?php echo $save; ?> Proses</span></a>&nbsp;<?php } ?><a href="javascript:void(0)" class="button back" onclick="goBack()" >
      <span><span class="icon"></span>&nbsp; Kembali</span></a></div>
   </div>
  </div>
  <input type="hidden" id="kesimpulanHasilPenilaianVal" value="<?php echo $sess['HASIL']; ?>" name="IKLAN[HASIL]" />
  <input type="hidden" name="IKLAN_ID[]" value="<?php echo $sess['IKLAN_ID']; ?>" />
  <input type="hidden" name="UPDATE" value="<?php echo $sess['STATUS']; ?>" />
  <input type="hidden" name="EDIT" value="<?php echo $editTL; ?>" />
  <input type="hidden" name="TUJUAN" value="<?php echo $tujuan; ?>" />
  <input type="hidden" name="KOMODITI[]" value="<?php echo $sess['KOMODITI']; ?>" />
 </form>
</div>
<script type="text/javascript">
     function goBack()
     {
      window.history.back()
     }
     function verifikasiPusat(X) {
      if ($(X).val() === "MK") {
       $(".vMK").show();
       $(".vMK").attr("rel", "required");
       $(".vMKa").attr("rel", "required");
       $(".vMKa").attr("name", "IKLAN[TL_PUSAT][]");
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
      }
      else {
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
     $(document).ready(function() {
      $("textarea.chkJustifikasi").redactor({
       buttons: ['bold', 'italic', '|', 'unorderedlist', 'orderedlist', 'outdent', 'indent', '|', 'alignleft', 'aligncenter', 'alignright', 'justify'],
       removeStyles: false,
       cleanUp: true,
       autoformat: true
      });
//      var a = $("#uraianP").text().slice(0, -2);
//      $("#uraianP").text(a);
      $("#detail_petugas").html("Loading ...");
      $("#detail_petugas").load($("#detail_petugas").attr("url"));
      $('.verifikasiPusat').change(function() {
       verifikasiPusat($(this));
      });
     });
</script>