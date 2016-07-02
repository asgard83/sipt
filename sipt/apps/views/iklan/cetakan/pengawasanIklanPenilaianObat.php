<?php
if (!defined('BASEPATH'))
 exit('No direct script access allowed');
error_reporting(E_ERROR);
?>
<div id="judulpmnikl" class="judul"></div>
<div class="headersarana">PENGAWASAN IKLAN OBAT </div>
<?php
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
      <h2 class="small garis">Informasi Pengawasan Iklan</h2>
      <table class="form_tabel">
       <tr class="urut<?php echo $i; ?>" hidden="true">
        <td class="atas">Unit / Balai Besar / Balai</td>
        <td><input type="text" class="stext" readonly="readonly" value="<?php echo $this->newsession->userdata('SESS_MBBPOM'); ?>" name="BBPOM[MBBPOM_ID][]" val="<?php echo $nomor[$i]; ?>" title="Balai Besar / Balai POM" /><input type="hidden" name="BBPOM[BBPOM_ID][]" value="<?php echo $this->newsession->userdata('SESS_BBPOM_ID'); ?>" id="bpomid" /></td>
       </tr>
      </table>
      <div style="height:15px;"></div>
      <div>
       <?php echo $histori; ?>
      </div>
      <div style="height:15px;"></div>
      <table class="form_tabel">
       <tr><td class="td_left">Tanggal Pengawasan</td><td class="td_right">
         <?php echo $sess['TANGGAL_MULAI']; ?>&nbsp; sampai dengan&nbsp;
         <?php echo $sess['TANGGAL_AKHIR']; ?>
       </tr>
       <tr><td class="td_left">Kelompok Iklan</td><td class="td_right"><?php echo $sess['KELOMPOK_IKLAN']; ?></td>
       </tr>
      </table>
     </div>
    </div>

    <div style="height:5px;"></div><div class="expand"><a title="expand/collapse" href="#" style="display: block;">INFORMASI OBAT - IKLAN</a></div>
    <div class="collapse">
     <div class="accCntnt">
      <?php echo $sess2; ?>
     </div>
    </div>

    <?php if ($sess['PENILAIAN1'] != NULL && trim($sess['PENILAIAN1']) != '') { ?>
     <div style="height:5px;"></div><div class="expand"><a title="expand/collapse" href="#" style="display: block;">INFORMASI TAMBAHAN</a></div>
     <div class="collapse">
      <div class="accCntnt">
       <table class="form_tabel">
        <?php
        foreach ($tambahan as $value) {
         if ($value[1] != "") {
          ?>
          <tr>
           <td class="td_left"><?php echo $value[1]; ?></td>
           <td class="td_right"><?php
            if ($value[0] == "-") {
             echo '<b><i>Tidak Ada</i></b>';
            } else if ($value[0] == "+") {
             echo '<b><i>Ada</i></b>';
            }
            ?></td>
          </tr>
          <?php
         }
        }
        ?>
       </table>
      </div>
     </div>
    <?php } ?>

    <div style="height:5px;"></div>
    <div class="expand"><a title="expand/collapse" href="#" style="display: block;">IDENTITAS MEDIA PENAYANGAN IKLAN</a></div>
    <div class="collapse">
     <div class="accCntnt">
      <h2 class="small garis">Informasi Media Iklan</h2>
      <table class="form_tabel">
       <?php if (trim($sess['JENIS_IKLAN']) != '') { ?><tr><td class="td_left">Jenis Iklan</td><td class="td_right"><?php echo $sess['JENIS_IKLAN']; ?></td>
        </tr>
       <?php } if (trim($sess['MEDIA']) != '') { ?><tr><td class="td_left">Media</td><td class="td_right"><?php echo $sess['MEDIA']; ?></td>
        </tr>
       <?php } if (trim($sess['NAMA_MEDIA']) != "" && $sess['NAMA_MEDIA'] != '0') { ?><tr><td class="td_left"><?php
        if ($sess['JENIS_IKLAN'] != 'Internet') {
         echo 'Nama Media';
        } else {
         echo 'Nama Situs';
        }
        ?></td><td class="td_right"><?php echo $sess['NAMA_MEDIA']; ?></td>
        </tr>
       <?php } if (trim($sess['JUDUL_KEGIATAN']) != '') { ?><tr><td class="td_left">Judul Kegiatan</td><td class="td_right"><?php echo $sess['JUDUL_KEGIATAN']; ?></td>
        </tr>
       <?php } if (trim($sess['JAM_TAYANG']) != '') { ?><tr><td class="td_left">Jam Tayang</td><td class="td_right"><?php echo str_replace(" ", ".", $sess['JAM_TAYANG']); ?></td>
        </tr>
       <?php
       } $edisiUraian = explode("^", $sess['EDISI']);
       if (trim($edisiUraian[0]) != "" && trim($edisiUraian[0]) != "-") {
        ?>
        <tr><td class="td_left">Edisi</td><td class="td_right"><?php
          $edisi = explode(" ", $edisiUraian[0]);
          if (trim($edisiUraian[1]) == "" || trim($edisiUraian[1]) == "-")
           echo 'Tahun <b>' . $edisi[0] . "</b> " . " Bulan <b>" . $edisi[1] . "</b>";
          else
           echo "<i>' " . $edisiUraian[1] . " '</i>  &nbsp;&nbsp;Bulan <b>" . $edisi[1] . "</b> " . " Tahun <b>" . $edisi[0] . "</b>";
          ?></td>
        </tr>
       <?php } if ($sess['TANGGAL'] != NULL) { ?><tr><td class="td_left">Tanggal Penerbitan</td><td class="td_right"><?php echo $sess['TANGGAL']; ?></td>
        </tr>
       <?php } ?><tr><td class="td_left">Nama Lokasi Pengawasan Iklan</td><td class="td_right"><?php
       if (trim($sess['NAMA_LOKASI_IKLAN']) != '') {
        echo $sess['NAMA_LOKASI_IKLAN'];
       }
       else
        echo "-";
       ?></td>
       </tr>
       <tr><td class="td_left">Alamat / Lokasi Pengawasan Iklan</td><td class="td_right"><?php
         if (trim($sess['ALAMAT_LOKASI_IKLAN']) != '') {
          echo $sess['ALAMAT_LOKASI_IKLAN'];
         } else {
          echo "-";
         }
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
      </table>
     </div>
    </div>
    <div style="height:5px;"></div>

<?php if ($sess['PENILAIAN2'] != ' ') { ?>
     <div class="expand"><a title="expand/collapse" href="#" style="display: block;">INFORMASI TERCANTUM DALAM IKLAN OBAT</a></div>
     <div class="collapse">
      <div class="accCntnt">
       <table class="form_tabel">
        <?php
        foreach ($tercantum as $value) {
         if ($value[1] != "") {
          ?>
          <tr>
           <td class="td_left"><?php echo $value[1]; ?></td>
           <td class="td_right"><?php
            if ($value[0] == "-") {
             echo '<b><i>Tidak Ada</i></b>';
            } else if ($value[0] == "+") {
             echo '<b><i>Ada</i></b>';
            }
            ?></td>
          </tr>
          <?php
         }
        }
        ?>
       </table>
      </div>
     </div>
     <div style="height:5px;"></div>
    <?php } ?>

<?php if ($sess['PROMO'] != ' ' && $sess['PROMO'] != NULL) { ?>
     <div class="expand"><a title="expand/collapse" href="#" style="display: block;">DESKRIPSI IKLAN / PROMOSI </a></div>
     <div class="collapse">
      <div class="accCntnt">
       <h2 class="small garis">Deskripsi Iklan / Promosi</h2>
       <table class="form_tabel">
        <tr><td class="td_left">Deskripsi Iklan / Promosi</td><td class="td_right"><?php echo $sess['PROMO']; ?></td></tr>
       </table>
      </div>
     </div>
     <div style="height:5px;"></div>
<?php } ?>

    <!--5-->
<?php if ($sess['URAIAN_PELANGGARAN'] != NULL) { ?>
     <div class="expand" id="expand5"><a title="expand/collapse" href="#" style="display: block;">URAIAN PELANGGARAN</a></div>
     <div class="collapse">
      <div class="accCntnt">
       <h2 class="small garis">Uraian Pelanggaran :</h2>
       <table class="form_tabel">
        <?php
        if ($UP [0] != '') {
         echo '<tr><td class="td_left">Tidak Lengkap</td><td class="td_right">' . $comas . '</td></tr>';
        } if ($UP[1] != '') {
         echo '<tr><td class="td_left">Tidak Obyektif</td><td class="td_right">' . $UP[1] . '</td></tr>';
        } if ($UP[2] != '') {
         echo '<tr><td class="td_left">Klaim Berlebihan</td><td class="td_right">' . $UP[2] . '</td></tr>';
        } if ($UP[3] != '') {
         echo '<tr><td class="td_left">Testimoni</td><td class="td_right">' . $UP[3] . '</td></tr>';
        } if ($UP[4] != '') {
         echo '<tr><td class="td_left">Pemberian Hadiah</td><td class="td_right">' . $UP[4] . '</td></tr>';
        } if ($UP[5] != '') {
         echo '<tr><td class="td_left">Profesi Kesehtan</td><td class="td_right">' . $UP[5] . '</td></tr>';
        } if ($UP[6] != '') {
         echo '<tr><td class="td_left">Tidak Sesuai Norma</td><td class="td_right">' . $UP[6] . '</td></tr>';
        } if ($UP[7] != '') {
         echo '<tr><td class="td_left">Ditujukan Untuk Umum</td><td class="td_right">' . $UP[7] . '</td></tr>';
        }
        ?>
       </table>
      </div>
     </div>
     <div style="height:5px;"></div>
    <?php } ?>

<?php if (trim($sess['VERIFIKASI_SIAMI']) != '') { ?>
     <div class="expand" id="expand5"><a title="expand/collapse" href="#" style="display: block;">HASIL VERIFIKASI SIAMI</a></div>
     <div class="collapse">
      <div class="accCntnt">
       <table class="form_tabel">
        <tr><td class="td_left">Hasil Verifikasi Siami</td><td class="td_right"><?php echo $sess['VERIFIKASI_SIAMI']; ?></td></tr>
       </table>
      </div>
     </div>
     <div style="height:5px;"></div>
<?php } ?>


<?php if ((in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) || ((!in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) && $sess['HASIL_PUSAT'] != NULL)) { ?>
     <div class="expand" id="expand5"><a title="expand/collapse" href="#" style="display: block;">KESIMPULAN </a></div>
     <div class="collapse">
      <div class="accCntnt">
       <table class="form_tabel">
        <tr><td class="td_left"><?php
          if ((!in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))))
           echo 'Kesimpulan';
          else if ((in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))))
           echo 'Kesimpulan  Balai';
          ?></td><td class="td_right"><b><?php
          if ($sess['HASIL'] == 'MK')
           echo 'Memenuhi Ketentuan';
          else
           echo 'Tidak Memenuhi Ketentuan';
          ?></b></td></tr>
         <?php
         if ((!$sess['HASIL_PUSAT'] && in_array('2', $this->newsession->userdata('SESS_KODE_ROLE'))) || $editTL == 'YES') {
          ?>
         <tr><td class="td_left">Verifikasi Pusat</td><td class="td_right"><select class="stext verifikasiPusat" name="<?php echo 'IKLAN[HASIL_PUSAT]' ?>" rel="required" title="MK/TMK"><option></option><option value="MK" <?php if ($sess['HASIL_PUSAT'] == 'MK') echo 'Selected' ?>>Memenuhi Ketentuan</option><option value="TMK"  <?php if ($sess['HASIL_PUSAT'] == 'TMK') echo 'Selected' ?>>Tidak Memenuhi Ketentuan</option></select></td></tr>
         <tr class="vTMK" hidden><td class="td_left" >Kategori Pelanggaran</td><td class="td_right"><select class="sjenis vTMKa" title="Kategori Pelanggaran"><option></option><option value="Minor" <?php if ($hasilKesimpulanOpt[0] == 'Minor') echo 'Selected' ?>>Minor</option><option value="Mayor" <?php if ($hasilKesimpulanOpt[0] == 'Mayor') echo 'Selected' ?>>Mayor</option><option value="Kritikal" <?php if ($hasilKesimpulanOpt[0] == 'Kritikal') echo 'Selected' ?>>Kritikal</option></select></td></tr>
         <tr class="vTMK" hidden><td class="td_left"  style="background-color: white;">Tindak Lanjut</td><td class="td_right" style="background-color: white;"><?php echo form_dropdown('IKLAN[TL_PUSAT][]', $cb_tl, is_array($hasilKesimpulanOpt) ? $hasilKesimpulanOpt[1] : '', 'class="stext vTMK" id="vTMKSub" title="Tindak Lanjut Pusat"'); ?></td></tr>
         <tr class="vTMK2" hidden><td class="td_left"  style="background-color: white;"></td><td class="td_right" style="background-color: white;"><?php echo form_dropdown('IKLAN[TL_PUSAT][]', $cb_tindakan, is_array($hasilKesimpulanOpt) ? $hasilKesimpulanOpt : '', 'class="stext multiselect vTMK2" multiple title="Saran Tindak Lanjut Pusat. Untuk memilih lebih dari satu, klik + Ctrl"'); ?></td></tr>
         <tr class="vTMK2" hidden><td class="td_left" ></td><td class="td_right"><input type="text" class="sdate" name="IKLAN[DETAIL_PUSAT][]" id="tglSuratTL" title="Tanggal Surat Tindak Lanjut" placeholder="Tanggal Surat" onchange="comp('D')" value="<?php echo $hasilKesimpulanOpt2[0]; ?>"/>&nbsp;&nbsp;&nbsp;Tanggal Surat Tindak Lanjut</td></tr>
         <tr class="vTMK2" hidden><td class="td_left" ></td><td class="td_right"><input type="text" class="stext" name="IKLAN[DETAIL_PUSAT][]" id="stugas_"  title="Di isi dengan nomor surat tindak lanjut" placeholder="Nomor Surat Tindak Lanjut" value="<?php echo $hasilKesimpulanOpt2[1]; ?>"/>&nbsp;&nbsp;&nbsp;Nomor Surat Tindak Lanjut</td></tr>
         <tr class="vMK" hidden><td class="td_left" style="background-color: white;">Kategori MK</td><td class="td_right" style="background-color: white;"><select class="stext vMKa" title="Kategori MK"><option></option><option value="Iklan Sesuai Dengan Yang Disetujui" <?php if ($hasilKesimpulanOpt[1] == 'Iklan Sesuai Dengan Yang Disetujui') echo 'Selected' ?>>Iklan Sesuai Dengan Yang Disetujui</option><option value="Iklan Mencantumkan Informasi Sesuai Dengan Penandaan Terakhir Yang Disetujui" <?php if ($hasilKesimpulanOpt[1] == 'Iklan Mencantumkan Informasi Sesuai Dengan Penandaan Terakhir') echo 'Selected' ?>>Iklan Mencantumkan Informasi Sesuai Dengan Penandaan Terakhir</option></select></td></tr>
         <tr class="vJustifikasi" hidden><td class="td_left" style="background-color: white;">Justifikasi</td><td class="td_right" style="background-color: white;"><textarea name="JUSTIFIKASI" title="Justifikasi Pusat" class="stext chkJustifikasi" id="XXX" style="height: 140px"><?php echo $sess['JUSTIFIKASI_PUSAT']; ?></textarea></td></tr>
         <?php
        } else {
         if ($sess['HASIL_PUSAT'] == "TMK") {
          ?>
          <tr><td class="td_left">Verifikasi Pusat</td><td class="td_right"><b><i><?php
              if ($sess['HASIL_PUSAT'] == 'MK')
               echo 'Memenuhi Ketentuan';
              else
               echo 'Tidak Memenuhi Ketentuan';
              ?></i></b></td></tr>
          <tr><td class="td_left">Kategori Pelanggaran</td><td class="td_right"><?php echo $hasilKesimpulanOpt[0]; ?></td></tr>
          <?php if ($hasilKesimpulanOpt[1] != NULL) { ?><tr><td class="td_left">Tindak Lanjut Pusat</td><td class="td_right"><?php
           if ($hasilKesimpulanOpt[1] == 'TL')
            echo 'Tindak Lanjut'; else if ($hasilKesimpulanOpt[1] == 'STL')
            echo 'Sudah Tindak Lanjut';
           else
            echo 'Tidak Dapat Tindak Lanjut'
            ?></td></tr><?php if ($hasilKesimpulanOpt[1] != NULL && $hasilKesimpulanOpt[1] != "TTL") { ?><tr><td class="td_left"></td><td class="td_right"><ul style="list-style-type:decimal; padding-left:20px; margin:0;"><?php
              $temp = array($hasilKesimpulanOpt[2], $hasilKesimpulanOpt[3]);
              if ($hasilKesimpulanOpt[3] != '')
               echo "<li>" . join("</li><li>", $temp) . "</li>";
              else
               echo "<li>" . $hasilKesimpulanOpt[2] . "</li>";
              ?></ul></td></tr>
            <tr><td class="td_left">Surat Tindak Lanjut</td><td class="td_right"><ul style="padding-left:20px; margin:0;"><?php
               $temp2 = array($hasilKesimpulanOpt2[0], $hasilKesimpulanOpt2[1]);
               if ($hasilKesimpulanOpt2[1] != '')
                echo "<li>Tanggal Surat: <b>" . join("</b></li><li>Nomor Surat: <b>", $temp2) . "</b></li>";
               else if ($hasilKesimpulanOpt2[0] != '')
                echo "<li>Tanggal Surat: <b>" . $hasilKesimpulanOpt2[0] . "</b></li>";
               else
                echo "<li>Tanggal Surat: <b> - </b></li><li>Nomor Surat: <b> - </b></li>";
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
          <tr><td class="td_left">Kategori MK</td><td class="td_right"><?php echo $hasilKesimpulanOpt[1]; ?></td></tr>
          <?php if (($sess['JUSTIFIKASI_PUSAT'] != NULL || $sess['JUSTIFIKASI_PUSAT'] != "") && $sess['HASIL_PUSAT'] != $sess['HASIL']) { ?>
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
<?php } else { ?>
     <div class="expand" id="expand5"><a title="expand/collapse" href="#" style="display: block;">KESIMPULAN</a></div>
     <div class="collapse">
      <div class="accCntnt">
       <table class="form_tabel">
        <tr><td class="td_left">Hasil Kesimpulan</td><td class="td_right"><?php
          if ($sess['HASIL'] == "MK")
           echo 'Memenuhi Ketentuan';
          else
           echo 'Tidak Memenuhi Ketentuan';
          ?></td></tr>
       </table>
      </div>
     </div>
     <div style="height:5px;"></div>
    <?php } ?>
   </div>
  </div>
  <input type="hidden" id="kesimpulanHasilPenilaianVal" value="<?php echo $sess['HASIL']; ?>" name="IKLAN[HASIL]" />
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
                     $(".chkJustifikasi").val("");
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
                    //                      load data edit
<?php if (array_key_exists("IKLAN_ID", $sess)) { ?>
                     if ("<?php echo $this->newsession->userdata("SESS_BBPOM_ID") ?>" === "92" || "<?php echo $this->newsession->userdata("SESS_BBPOM_ID") ?>" === "00") {
                      verifikasiPusat($(".verifikasiPusat"));
                      verifikasiTL($("#vTMKSub"));
                     }
<?php } ?>
                    if ("<?php echo $this->newsession->userdata('SESS_BBPOM_ID') ?>" === "92") {
                     verifikasiPusat($('.verifikasiPusat'));
                    }
                   });
</script>