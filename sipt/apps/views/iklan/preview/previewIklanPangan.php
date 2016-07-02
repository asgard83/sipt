<?php
if (!defined('BASEPATH'))
 exit('No direct script access allowed');
error_reporting(E_ERROR);
?>
<div id="judulpmnikl" class="judul"></div>
<div class="headersarana">PENGAWASAN IKLAN PANGAN</div>
<?php
$UP = explode("^", $sess['URAIAN_PELANGGARAN']);
if ($sess['JENIS'] == "IRT") {
 $lampiranFold = "irt";
} else if ($sess['JENIS'] == "MD/ML") {
 $lampiranFold = "mdml";
}
?>
<div class="content">
 <form action="<?php echo $act; ?>" method="post" autocomplete="off" id="fpengawasanIklan_013">
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
       <tr><td class="td_left">Kelompok Iklan</td><td class="td_right"><?php
         echo $sess['KELOMPOK_IKLAN'];
         ?></td>
       </tr>
      </table>
     </div>
    </div>

    <div style="height:5px;"></div><div class="expand"><a title="expand/collapse" href="#" style="display: block;">INFORMASI PANGAN - IKLAN</a></div>
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
       <?php if ($sess['JENIS_IKLAN'] != ' ') { ?><tr><td class="td_left">Jenis Iklan</td><td class="td_right"><?php echo $sess['JENIS_IKLAN']; ?></td>
        </tr>
       <?php } if ($sess['MEDIA'] != ' ') { ?><tr><td class="td_left">Media</td><td class="td_right"><?php echo $sess['MEDIA']; ?></td>
        </tr>
       <?php } if (trim($sess['NAMA_MEDIA']) != "" && $sess['NAMA_MEDIA'] != '0') { ?><tr><td class="td_left"><?php
        if ($sess['JENIS_IKLAN'] != 'Internet') {
         echo 'Nama Media';
        } else {
         echo 'Nama Situs';
        }
        ?></td><td class="td_right"><?php echo $sess['NAMA_MEDIA']; ?></td>
        </tr>
       <?php } if ($sess['JUDUL_KEGIATAN'] != ' ') { ?><tr><td class="td_left">Judul Kegiatan</td><td class="td_right"><?php echo $sess['JUDUL_KEGIATAN']; ?></td>
        </tr>
       <?php } if ($sess['JAM_TAYANG'] != ' ') { ?><tr><td class="td_left">Jam Tayang</td><td class="td_right"><?php echo str_replace(" ", ".", $sess['JAM_TAYANG']); ?></td>
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

    <?php if ($sess['NARASI'] != ' ' && $sess['NARASI'] != NULL) { ?>
     <div class="expand"><a title="expand/collapse" href="#" style="display: block;">NARASI / KLAIM IKLAN </a></div>
     <div class="collapse">
      <div class="accCntnt">
       <h2 class="small garis">Narasi / Klaim Iklan</h2>
       <table class="form_tabel">
        <tr><td class="td_left">Narasi / Klaim Iklan</td><td class="td_right"><?php echo $sess['NARASI']; ?></td></tr>
       </table>
      </div>
     </div>
     <div style="height:5px;"></div>
    <?php } ?>

    <!--5-->
    <?php if ($sess['URAIAN_PELANGGARAN'] != NULL && $sess['URAIAN_PELANGGARAN'] != "^^^^^^^^^^^^^^^^") { ?>
     <div class="expand" id="expand5"><a title="expand/collapse" href="#" style="display: block;">URAIAN PELANGGARAN</a></div>
     <div class="collapse">
      <div class="accCntnt">
       <h2 class="small garis">Uraian Pelanggaran :</h2>
       <table class="form_tabel">
        <?php
        if ($UP [0] != '') {
         echo '<tr><td class="td_left">Tidak memiliki izin edar</td><td class="td_right">' . $UP[0] . '</td></tr>';
        } if ($UP [1] != '') {
         echo '<tr><td class="td_left">Seolah-olah sebagai obat / mengobati</td><td class="td_right">' . $UP[1] . '</td></tr>';
        } if ($UP [2] != '') {
         echo '<tr><td class="td_left">Peragaan tenaga kesehatan</td><td class="td_right">' . $UP[2] . '</td></tr>';
        } if ($UP [3] != '') {
         echo '<tr><td 5lass="td_left">Rekomendasi laboratorium/tenaga kesehatan</td><td class="td_right">' . $UP[3] . '</td></tr>';
        } if ($UP [4] != '') {
         echo '<tr><td class="td_left">Tidak etis / tidak sesuai norma susila</td><td class="td_right">' . $UP[4] . '</td></tr>';
        } if ($UP [5] != '') {
         echo '<tr><td class="td_left">Berlebihan / menyesatkan</td><td class="td_right">' . $UP[5] . '</td></tr>';
        } if ($UP [6] != '') {
         echo '<tr><td class="td_left">Tidak mencantumkan spot (untuk iklan yang wajib mencantumkan spot iklan)</td><td class="td_right">' . $UP[6] . '</td></tr>';
        } if ($UP [7] != '') {
         echo '<tr><td class="td_left">Iklan yang mempengaruhi fungsi fisiologis dan atau metabolisme tubuh</td><td class="td_right">' . $UP[7] . '</td></tr>';
        } if ($UP [8] != '') {
         echo '<tr><td class="td_left">Slogan, ikon atau logo tidak sesuai</td><td class="td_right">' . $UP[8] . '</td></tr>';
        } if ($UP [9] != '') {
         echo '<tr><td class="td_left">Testimoni</td><td class="td_right">' . $UP[9] . '</td></tr>';
        } if ($UP [10] != '') {
         echo '<tr><td class="td_left">Tidak mencantumkan peringatan / perhatian</td><td class="td_right">' . $UP[10] . '</td></tr>';
        } if ($UP [11] != '') {
         echo '<tr><td class="td_left">Tidak menyebutkan keterangan jelas terkait hadiah -> menyesatkan</td><td class="td_right">' . $UP[11] . '</td></tr>';
        } if ($UP [12] != '') {
         echo '<tr><td class="td_left">Tidak sesuai dengan klaim yang disetujui pada label</td><td class="td_right">' . $UP[12] . '</td></tr>';
        } if ($UP [13] != '') {
         echo '<tr><td class="td_left">Disiarkan di media massa atau kegiatan tertentu</td><td class="td_right">' . $UP[13] . '</td></tr>';
        } if ($UP [14] != '') {
         echo '<tr><td class="td_left">Kadar etanol lebih dari 1% (v/v)</td><td class="td_right">' . $UP[14] . '</td></tr>';
        } if ($UP [15] != '') {
         echo '<tr><td class="td_left">Mencantumkan logo dan atau simbol keagamaan yang dianggap suci</td><td class="td_right">' . $UP[15] . '</td></tr>';
        } if ($UP [16] != '') {
         echo '<tr><td class="td_left">Mengiklankan kata halal</td><td class="td_right">' . $UP[16] . '</td></tr>';
        }
        ?>
       </table>
      </div>
     </div>
     <div style="height:5px;"></div>
    <?php } ?>

    <?php if ((in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) || ((!in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) && $sess['HASIL_PUSAT'] != NULL)) { ?>
     <div class="expand" id="expand5"><a title="expand/collapse" href="#" style="display: block;">KESIMPULAN</a></div>
     <div class="collapse">
      <div class="accCntnt">
       <table class="form_tabel">
        <tr><td class="td_left"><?php
          if ((!in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))))
           echo 'Kesimpulan ';
          else if ((in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))))
           echo 'Kesimpulan  Balai';
          ?></td><td class="td_right"><b><?php
          if ($sess['HASIL'] == 'MK')
           echo 'Memenuhi Ketentuan';
          else
           echo 'Tidak Memenuhi Ketentuan';
          ?></b></td></tr>
        <?php if (trim($sess['TL_BALAI']) != "") { ?><tr><td class="td_left">Tindak Lanjut Balai</td><td class="td_right"><?php
         if (trim($sess['TL_BALAI']) != "")
          echo $cb_tindakan_balai[$sess["TL_BALAI"]];
         else
          echo "-";
         ?></td></tr><?php } ?>
        <?php
        if ((!$sess['HASIL_PUSAT'] && in_array('2', $this->newsession->userdata('SESS_KODE_ROLE'))) || $editTL == 'YES') {
         ?>
         <tr><td class="td_left">Verifikasi Pusat</td><td class="td_right"><select class="stext verifikasiPusat" name="<?php echo 'IKLAN[HASIL_PUSAT]' ?>" rel="required" title="MK/TMK"><option></option><option value="MK" <?php if ($sess['HASIL_PUSAT'] == 'MK') echo 'Selected' ?>>Memenuhi Ketentuan</option><option value="TMK"  <?php if ($sess['HASIL_PUSAT'] == 'TMK') echo 'Selected' ?>>Tidak Memenuhi Ketentuan</option></select></td></tr>
         <tr class="vTMK" hidden><td class="td_left"style="background-color: white;">Tindak Lanjut</td><td class="td_right" style="background-color: white;"><?php echo form_dropdown('IKLAN[TL_PUSAT]', $cb_tindakan, $sess['TL_PUSAT'], 'id="" class="stext vTMK" title="Tindak Lanjut Pusat"'); ?></td></tr>
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
          <?php if (trim($sess['TL_PUSAT']) != "" && $sess['TL_PUSAT'] != NULL) { ?><tr><td class="td_left">Tindak Lanjut Pusat</td><td class="td_right"><?php echo $cb_tindakan[$sess['TL_PUSAT']]; ?></td></tr>
          <?php } if ($sess['JUSTIFIKASI_PUSAT'] != NULL && trim($sess['JUSTIFIKASI_PUSAT']) != "") { ?><tr><td class="td_left">Justifikasi Pusat</td><td class="td_right"><?php echo $sess['JUSTIFIKASI_PUSAT']; ?></td></tr>
           <?php
          }
         } else {
          ?>
          <tr><td class="td_left">Verifikasi Pusat</td><td class="td_right"><b><i><?php
              if ($sess['HASIL_PUSAT'] == 'MK')
               echo 'Memenuhi Ketentuan';
              else
               echo 'Tidak Memenuhi Ketentuan';
              ?></i></b></td></tr>
          <?php if (trim($sess['TL_PUSAT']) != "" && $sess['TL_PUSAT'] != NULL) { ?><tr><td class="td_left">Tindak Lanjut Pusat</td><td class="td_right"><?php echo $cb_tindakan[$sess['TL_PUSAT']]; ?></td></tr>
          <?php } if ($sess['JUSTIFIKASI_PUSAT'] != NULL && trim($sess['JUSTIFIKASI_PUSAT']) != "") { ?><tr><td class="td_left">Justifikasi Pusat</td><td class="td_right"><?php echo $sess['JUSTIFIKASI_PUSAT']; ?></td></tr>
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
           echo "Memenuhi Ketentuan";
          else
           echo "Tidak Memenuhi Ketentuan";
          ?></td></tr>
        <?php if (trim($sess['TL_BALAI']) != "") { ?><tr><td class="td_left">Tindak Lanjut Balai</td><td class="td_right"><?php
         if (trim($sess['TL_BALAI']) != "")
          echo $cb_tindakan_balai[$sess["TL_BALAI"]];
         else
          echo "-";
         ?></td></tr><?php } ?>
       </table>
      </div>
     </div>
     <div style="height:5px;"></div>
    <?php } ?>

    <?php if ($sess['FILE_IKLAN'] != '') { ?>
     <div class="expand" id="expand5"><a title="expand/collapse" href="#" style="display: block;">LAMPIRAN</a></div>
     <div class="collapse">
      <div class="accCntnt">
       <table class="form_tabel">
        <tr><td class="td_left">Lampiran</td><td class="td_right"><a href="<?php echo base_url(); ?>files/<?php echo 'iklan_013/' . $lampiranFold; ?>/<?php echo $sess['FILE_IKLAN']; ?>" target="_blank">Lihat Lampiran</a></td></tr>
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
    <div style="padding:10px;"></div><div><?php if ($formEdit === 'check') { ?><a href="javascript:void(0)" id="btnSave" class="button check" onclick="fpost('#fpengawasanIklan_013', '', '');">
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
       $(".vTMK").hide();
       $(".vTMK").attr("rel", " ");
       $(".vTMK").val("");
       $(".vTMK2").hide("slow");
       $(".vTMK2").val("");
       $(".vTMK2").attr("rel", "");
       $(".vTMK2a").val("");
      }
      else if ($(X).val() === "TMK") {
       $(".vMK").hide();
       $(".vMK").attr("rel", " ");
       $(".vMK").val("");
       $(".vTMK").show();
       $(".vTMK").attr("rel", "required");
      }
      else {
       $(".vMK").hide();
       $(".vMK").attr("rel", " ");
       $(".vMK").val("");
       $(".vMK").hide();
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
<?php
if (array_key_exists("IKLAN_ID", $sess)) {
 if (in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')) || $this->newsession->userdata("SESS_BBPOM_ID") == "50") {
  ?>
        verifikasiPusat($(".verifikasiPusat"));
        verifikasiTL($("#vTMKSub"));
  <?php
 }
}
?>
      $("#detail_petugas").html("Loading ...");
      $("#detail_petugas").load($("#detail_petugas").attr("url"));
      $('.verifikasiPusat').change(function() {
       verifikasiPusat($(this));
      });
     });
</script>