<?php
if (!defined('BASEPATH'))
 exit('No direct script access allowed');
error_reporting(E_ERROR);
?>
<div id="judulpmnikl" class="judul"></div>
<div class="headersarana">PENGAWASAN IKLAN KOSMETIKA</div>
<?php
$UP = explode("^", $sess['URAIAN_PELANGGARAN']);
$UPP = explode("^", $sess['URAIAN_PELANGGARAN_PUSAT']);
$hasil = explode("^", $sess['TL_PUSAT']);
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
       </tr>
      </table>
     </div>
    </div>

    <div style="height:5px;"></div><div class="expand"><a title="expand/collapse" href="#" style="display: block;">INFORMASI KOSMETIKA - IKLAN</a></div>
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
       <?php } if (trim($sess['JAM_TAYANG']) != "") { ?><tr><td class="td_left">Jam Tayang</td><td class="td_right"><?php echo str_replace(" ", ".", $sess['JAM_TAYANG']); ?></td>
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
     <div class="expand"><a title="expand/collapse" href="#" style="display: block;">DESKRIPSI IKLAN / PROMOSI </a></div>
     <div class="collapse">
      <div class="accCntnt">
       <h2 class="small garis">Deskripsi Iklan / Promosi</h2>
       <table class="form_tabel">
        <tr><td class="td_left">Deskripsi Iklan / Promosi</td><td class="td_right"><?php echo $sess['NARASI']; ?></td></tr>
       </table>
      </div>
     </div>
     <div style="height:5px;"></div>
    <?php } ?>


    <!--7-->
    <?php if ((in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) || ((!in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) && $sess['HASIL_PUSAT'] != NULL)) { ?>
     <div class="expand" id="expand5"><a title="expand/collapse" href="#" style="display: block;">KESIMPULAN</a></div>
     <div class="collapse">
      <div class="accCntnt">
       <table class="form_tabel">
        <?php if (trim($sess['HASIL']) != "" && $sess['HASIL'] != NULL) { ?>
         <tr><td class="td_left"><?php
           if ((!in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))))
            echo 'Hasil Penilaian';
           else if ((in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))))
            echo 'Hasil Penilaian Balai';
           ?></td><td class="td_right"><b><?php
           if ($sess['HASIL'] == 'MK')
            echo 'Memenuhi Ketentuan';
           else
            echo 'Tidak Memenuhi Ketentuan';
           ?></b></td></tr>
         <?php } if ((!$sess['HASIL_PUSAT'] && in_array('2', $this->newsession->userdata('SESS_KODE_ROLE'))) || $editTL == 'YES') {
          ?>
         <tr><td class="td_left">Verifikasi Pusat</td><td class="td_right"><select class="stext verifikasiPusat" name="<?php echo 'IKLAN[HASIL_PUSAT]' ?>" rel="required" title="MK/TMK"><option></option><option value="MK" <?php if ($sess['HASIL_PUSAT'] == 'MK') echo 'Selected' ?>>Memenuhi Ketentuan</option><option value="TMK"  <?php if ($sess['HASIL_PUSAT'] == 'TMK') echo 'Selected' ?>>Tidak Memenuhi Ketentuan</option></select></td></tr>
         <tr class="vTMK" hidden><td class="td_left"style="background-color: white;">Tindak Lanjut</td><td class="td_right" style="background-color: white;"><?php echo form_dropdown('IKLAN[TL_PUSAT]', $cb_tindakan, $sess['TL_PUSAT'], 'class="stext vTMK" id="vTMKSub" title="Tindak Lanjut Pusat"'); ?></td></tr>
         <tr class="vTMK" hidden>
          <td class="td_left" style="vertical-align: top;"><input class="uraianPelanggaranPusat" type="checkbox" name="uraianPusat2" style="vertical-align: top; margin-right: 10px" title="Tidak Obyektif" />&nbsp;Tidak memiliki izin edar</td>
          <td class="td_right"><span class="uraianPusat2 uraianPelanggaranPusatDivDet" hidden="true"><textarea class="uPelanggaran uraianPusat2" title="Uraian Pelanggaran" style="width: 98%; height: 75px;" name="UPELANGGARANPUSAT[]"><?php echo $UPP[0]; ?></textarea></span></td>
         </tr>
         <tr class="vTMK" hidden>
          <td class="td_left" style="vertical-align: top;"><input class="uraianPelanggaranPusat" type="checkbox" name="uraianPusat3" style="vertical-align: top; margin-right: 10px" title="Uraian Pelanggaran" />&nbsp;Seolah-olah sebagai obat/mengobati/mempengaruhi fungsi fisiologis tubuh</td>
          <td class="td_right"><span class="uraianPusat3 uraianPelanggaranPusatDivDet" hidden="true"><textarea class="uPelanggaranPusat uraianPusat3" title="Uraian Pelanggaran" style="width: 98%; height: 75px;" name="UPELANGGARANPUSAT[]"><?php echo $UPP[1]; ?></textarea></span></td>
         </tr>
         <tr class="vTMK" hidden>
          <td class="td_left" style="vertical-align: top;"><input class="uraianPelanggaranPusat" type="checkbox" name="uraianPusat4" style="vertical-align: top; margin-right: 10px" title="Uraian Pelanggaran" />&nbsp;Peragaan tenaga kesehatan</td>
          <td class="td_right"><span class="uraianPusat4 uraianPelanggaranPusatDivDet" hidden="true"><textarea class="uPelanggaranPusat uraianPusat4" title="Uraian Pelanggaran" style="width: 98%; height: 75px;" name="UPELANGGARANPUSAT[]"><?php echo $UPP[2]; ?></textarea></span></td>
         </tr>
         <tr class="vTMK" hidden>
          <td class="td_left" style="vertical-align: top;"><input class="uraianPelanggaranPusat" type="checkbox" name="uraianPusat5" style="vertical-align: top; margin-right: 10px" title="Uraian Pelanggaran" />&nbsp;Rekomendasi laboratorium / tenaga kesehatan</td>
          <td class="td_right"><span class="uraianPusat5 uraianPelanggaranPusatDivDet" hidden="true"><textarea class="uPelanggaranPusat uraianPusat5" title="Uraian Pelanggaran" style="width: 98%; height: 75px;" name="UPELANGGARANPUSAT[]"><?php echo $UPP[3]; ?></textarea></span></td>
         </tr>
         <tr class="vTMK" hidden>
          <td class="td_left" style="vertical-align: top;"><input class="uraianPelanggaranPusat" type="checkbox" name="uraianPusat6" style="vertical-align: top; margin-right: 10px" title="Uraian Pelanggaran" />&nbsp;Tidak etis / tidak sesuai norma susila</td>
          <td class="td_right"><span class="uraianPusat6 uraianPelanggaranPusatDivDet" hidden="true"><textarea class="uPelanggaranPusat uraianPusat6" title="Uraian Pelanggaran" style="width: 98%; height: 75px;" name="UPELANGGARANPUSAT[]"><?php echo $UPP[4]; ?></textarea></span></td>
         </tr>
         <tr class="vTMK" hidden>
          <td class="td_left" style="vertical-align: top;"><input class="uraianPelanggaranPusat" type="checkbox" name="uraianPusat7" style="vertical-align: top; margin-right: 10px" title="Uraian Pelanggaran" />&nbsp;Berlebihan / menyesatkan</td>
          <td class="td_right"><span class="uraianPusat7 uraianPelanggaranPusatDivDet" hidden="true"><textarea class="uPelanggaranPusat uraianPusat7" title="Uraian Pelanggaran" style="width: 98%; height: 75px;" name="UPELANGGARANPUSAT[]"><?php echo $UPP[5]; ?></textarea></span></td>
         </tr>
         <tr class="vTMK" hidden>
          <td class="td_left" style="vertical-align: top;"><input class="uraianPelanggaranPusat" type="checkbox" name="uraianPusat8" style="vertical-align: top; margin-right: 10px" title="Uraian Pelanggaran" />&nbsp;Tidak mencantumkan spot (untuk iklan yang wajib mencantumkan spot iklan)</td>
          <td class="td_right"><span class="uraianPusat8 uraianPelanggaranPusatDivDet" hidden="true"><textarea class="uPelanggaranPusat uraianPusat8" title="Uraian Pelanggaran" style="width: 98%; height: 75px;" name="UPELANGGARANPUSAT[]"><?php echo $UPP[6]; ?></textarea></span></td>
         </tr>
         <tr class="vTMK" hidden>
          <td class="td_left" style="vertical-align: top;"><input class="uraianPelanggaranPusat" type="checkbox" name="uraianPusat9" style="vertical-align: top; margin-right: 10px" title="Uraian Pelanggaran" />&nbsp;Iklan yang mempengaruhi fungsi fisiologis dan atau metabolisme tubuh</td>
          <td class="td_right"><span class="uraianPusat9 uraianPelanggaranPusatDivDet" hidden="true"><textarea class="uPelanggaranPusat uraianPusat9" title="Uraian Pelanggaran" style="width: 98%; height: 75px;" name="UPELANGGARANPUSAT[]"><?php echo $UPP[7]; ?></textarea></span></td>
         </tr>
         <tr class="vJustifikasi" hidden><td class="td_left">Justifikasi</td><td class="td_right"><textarea name="JUSTIFIKASI" title="Justifikasi Pusat" class="stext chkJustifikasi" id="XXX" style="height: 140px"><?php echo $sess['JUSTIFIKASI_PUSAT']; ?></textarea></td></tr> <?php
        } else {
         ?>
         <tr><td class="td_left">Verifikasi Pusat</td><td class="td_right"><b><i><?php
             if ($sess['HASIL_PUSAT'] == 'MK')
              echo 'Memenuhi Ketentuan';
             else
              echo 'Tidak Memenuhi Ketentuan';
             ?></i></b></td></tr>
         <?php if ($sess['TL_PUSAT'] != NULL && trim($sess['TL_PUSAT']) != "") { ?><tr><td class="td_left">Tindak Lanjut Pusat</td><td class="td_right"><?php echo $cb_tindakan[$sess['TL_PUSAT']]; ?></td></tr>
          <?php
         } if ($sess['URAIAN_PELANGGARAN_PUSAT'] != NULL && $sess['URAIAN_PELANGGARAN_PUSAT'] != "^^^^^^^") {
          echo '<tr><td class="td_left" colspan="2" style="border-bottom:solid 1px;"></td></tr>';
          echo '<tr><td class="td_left" colspan="2"><h2 class="small garis">Uraian Pelanggaran Pusat</h2></td></tr>';
          if ($UPP [0] != '') {
           echo '<tr><td class="td_left"><b>Tidak memiliki izin edar</b></td><td class="td_right">' . $UPP [0] . '</td></tr>';
          } if ($UPP [1] != '') {
           echo '<tr><td class="td_left"><b>Seolah-olah sebagai obat/mengobati/mempengaruhi fungsi fisiologis tubuh</b></td><td class="td_right">' . $UPP [1] . '</td></tr>';
          } if ($UPP [2] != '') {
           echo '<tr><td class="td_left"><b>Peragaan tenaga kesehatan</b></td><td class="td_right">' . $UPP [2] . '</td></tr>';
          } if ($UPP [3] != '') {
           echo '<tr><td class="td_left"><b>Rekomendasi laboratorium / tenaga kesehatan</b></td><td class="td_right">' . $UPP [3] . '</td></tr>';
          } if ($UPP [4] != '') {
           echo '<tr><td class="td_left"><b>Tidak etis / tidak sesuai norma susila</b></td><td class="td_right">' . $UPP [4] . '</td></tr>';
          } if ($UPP [5] != '') {
           echo '<tr><td class="td_left"><b>Berlebihan / menyesatkan</b></td><td class="td_right">' . $UPP [5] . '</td></tr>';
          } if ($UPP [6] != '') {
           echo '<tr><td class="td_left"><b>Tidak mencantumkan spot (untuk iklan yang wajib mencantumkan spot iklan)</b></td><td class="td_right">' . $UPP [6] . '</td></tr>';
          } if ($UPP [7] != '') {
           echo '<tr><td class="td_left"><b>Iklan yang mempengaruhi fungsi fisiologis dan atau metabolisme tubuh</b></td><td class="td_right">' . $UPP [7] . '</td></tr>';
          }
          echo '<tr><td class="td_left" colspan="2" style="border-bottom:solid 1px;"></td></tr>';
         } if ($sess['JUSTIFIKASI_PUSAT'] != NULL && trim($sess['JUSTIFIKASI_PUSAT']) != "" && $sess['HASIL_PUSAT'] != $sess['HASIL']) {
          ?>
          <tr><td class="td_left">Justifikasi Pusat</td><td class="td_right"><?php echo $sess['JUSTIFIKASI_PUSAT']; ?></td></tr>
          <?php
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

    <!--5-->
    <?php if ($sess['URAIAN_PELANGGARAN'] != NULL && $sess['URAIAN_PELANGGARAN'] != "^^^^^^^") { ?>
     <div class="expand" id="expand5"><a title="expand/collapse" href="#" style="display: block;">URAIAN PELANGGARAN</a></div>
     <div class="collapse">
      <div class="accCntnt">
       <h2 class="small garis">Uraian Pelanggaran :</h2>
       <table class="form_tabel">
        <?php
        if ($UP [0] != '') {
         echo '<tr><td class="td_left"><b>Tidak memiliki izin edar</b></td><td class="td_right">' . $UP [0] . '</td></tr>';
        } if ($UP [1] != '') {
         echo '<tr><td class="td_left"><b>Seolah-olah sebagai obat/mengobati/mempengaruhi fungsi fisiologis tubuh</b></td><td class="td_right">' . $UP [1] . '</td></tr>';
        } if ($UP [2] != '') {
         echo '<tr><td class="td_left"><b>Peragaan tenaga kesehatan</b></td><td class="td_right">' . $UP [2] . '</td></tr>';
        } if ($UP [3] != '') {
         echo '<tr><td class="td_left"><b>Rekomendasi laboratorium / tenaga kesehatan</b></td><td class="td_right">' . $UP [3] . '</td></tr>';
        } if ($UP [4] != '') {
         echo '<tr><td class="td_left"><b>Tidak etis / tidak sesuai norma susila</b></td><td class="td_right">' . $UP [4] . '</td></tr>';
        } if ($UP [5] != '') {
         echo '<tr><td class="td_left"><b>Berlebihan / menyesatkan</b></td><td class="td_right">' . $UP [5] . '</td></tr>';
        } if ($UP [6] != '') {
         echo '<tr><td class="td_left"><b>Tidak mencantumkan spot (untuk iklan yang wajib mencantumkan spot iklan)</b></td><td class="td_right">' . $UP [6] . '</td></tr>';
        } if ($UP [7] != '') {
         echo '<tr><td class="td_left"><b>Iklan yang mempengaruhi fungsi fisiologis dan atau metabolisme tubuh</b></td><td class="td_right">' . $UP [7] . '</td></tr>';
        }
        ?>
       </table>
      </div>
     </div>
     <div style="height:5px;"></div>
    <?php } ?>

    <?php
    if ($sess['FILE_IKLAN'] != '') {
     $arrLamp = explode(".", $sess["FILE_IKLAN"]);
     ?>
     <div class="expand" id="expand5"><a title="expand/collapse" href="#" style="display: block;">LAMPIRAN</a></div>
     <div class="collapse">
      <div class="accCntnt">
       <table class="form_tabel">
        <tr><td class="td_left">Lampiran</td><td class="td_right"><a href="<?php echo base_url(); ?>files/<?php echo 'iklan_012'; ?>/<?php echo $sess['FILE_IKLAN']; ?>" target="_blank" <?php if ($arrLamp[1] == "rar") echo 'onclick="dotRar();return false;"'; ?>>Lihat Lampiran</a></td></tr>
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
       $(".vTMKa").attr("name", "IKLAN[TL_PUSAT]");
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
  <?php
 }
}
?>
      $("#detail_petugas").html("Loading ...");
      $("#detail_petugas").load($("#detail_petugas").attr("url"));
      $('.verifikasiPusat').change(function() {
       verifikasiPusat($(this));
      });
      $(".uraianPelanggaranPusat").click(function() {
       checkListTxt($(this).attr("name"));
      });
     });
</script>