<?php
if (!defined('BASEPATH'))
 exit('No direct script access allowed');
error_reporting(E_ERROR);
?>
<div id="judulpmnikl" class="judul"></div>
<div class="headersarana">PENGAWASAN IKLAN SUPLEMEN KESEHATAN</div>
<?php
$pemusnahan = explode("^", $sess['PEMUSNAHAN']);
$pemusnahanPusat = explode("^", $sess['PEMUSNAHANPUSAT']);
$sess['FILE_MUSNAH'] = $pemusnahan[2];
$sess['FILE_MUSNAH_PUSAT'] = $pemusnahanPusat[2];
$UP = explode("#", $sess['URAIAN_PELANGGARAN']);
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
      <div id="detail_petugas" url="<?php echo $histori_petugas; ?>"></div>
      <div style="height:15px;"></div>
      <table class="form_tabel">
       <tr><td class="td_left">Tanggal Pengawasan</td><td class="td_right">
         <?php echo $sess['TANGGAL_MULAI']; ?>&nbsp; sampai dengan&nbsp;
         <?php echo $sess['TANGGAL_MULAI']; ?>
       </tr>
      </table>
     </div>
    </div>

    <div style="height:5px;"></div><div class="expand"><a title="expand/collapse" href="#" style="display: block;">INFORMASI SUPLEMEN KESEHATAN - IKLAN</a></div>
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
       <?php if (trim($sess['JENIS_IKLAN']) != "") { ?><tr><td class="td_left">Jenis Iklan</td><td class="td_right"><?php echo $sess['JENIS_IKLAN']; ?></td>
        </tr>
       <?php } if (trim($sess['MEDIA']) != "") { ?><tr><td class="td_left">Media</td><td class="td_right"><?php echo $sess['MEDIA']; ?></td>
        </tr>
       <?php } if (trim($sess['NAMA_MEDIA']) != "" && $sess['NAMA_MEDIA'] != '0') { ?><tr><td class="td_left"><?php
        if ($sess['JENIS_IKLAN'] != 'Internet') {
         echo 'Nama Media';
        } else {
         echo 'Nama Situs';
        }
        ?></td><td class="td_right"><?php echo $sess['NAMA_MEDIA']; ?></td>
        </tr>
       <?php } if (trim($sess['JUDUL_KEGIATAN']) != "") { ?><tr><td class="td_left">Judul Kegiatan</td><td class="td_right"><?php echo $sess['JUDUL_KEGIATAN']; ?></td>
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

    <?php if (trim($sess['NARASI']) != '' && $sess['NARASI'] != NULL) { ?>
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

    <!--5-->
    <?php if (array_filter($UP)) { ?>
     <div class="expand" id="expand5"><a title="expand/collapse" href="#" style="display: block;">URAIAN PELANGGARAN</a></div>
     <div class="collapse">
      <div class="accCntnt">
       <h2 class="small garis">Uraian Pelanggaran :</h2>
       <table class="form_tabel">
        <?php
        $arrUraianSm = $this->config->item("uraian_iklan_smpk");
        foreach ($UP as $value) {
         if (trim($value) != "")
          echo '<tr><td class="td_left" colspan="4">' . $arrUraianSm[$value] . '</td></tr>';
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
           echo 'Hasil Penilaian';
          else if ((in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))))
           echo 'Hasil Penilaian Balai';
          ?></td><td class="td_right"><b><?php
          if ($sess['HASIL'] == 'MK')
           echo 'Memenuhi Ketentuan';
          else
           echo 'Tidak Memenuhi Ketentuan';
          ?></b></td></tr>
         <?php
         if (trim($sess["TL_BALAI"]) != "" && $sess["TL_BALAI"] != NULL) {
          ?>
         <tr class="TDKB"><td class="td_left">Tindak Lanjut Balai</td><td class="td_right"><?php echo $cb_tindakan_balai[$sess["TL_BALAI"]]; ?></td></tr>
         <?php if ($sess["TL_BALAI"] == "2") { ?>
          <tr class="tDKBalaiRow"><td></td><td class="td_right"><input type="text" class="tDKBalaiRow" id="jmlMusnah" title="Jumlah" placeholder = "Jumlah" maxlength="5" size="5" readonly value="<?php echo $pemusnahan[0] ?>"/>&nbsp;<input type="text" class="tDKBalaiRow" id="satuanMusnah" title="Satuan" placeholder = "Satuan" size="10" readonly value="<?php echo $pemusnahan[1] ?>"/>&nbsp;
            <a href="<?php echo base_url(); ?>files/<?php echo 'iklan_011/2_011'; ?>/<?php echo $sess['FILE_MUSNAH']; ?>" target="_blank">Lihat Lampiran</a></td></tr>
          <?php
         }
        }
        if ((!$sess['HASIL_PUSAT'] && in_array('2', $this->newsession->userdata('SESS_KODE_ROLE'))) || $editTL == 'YES') {
         ?>
         <tr><td class="td_left">Verifikasi Pusat</td><td class="td_right"><select class="stext verifikasiPusat" name="<?php echo 'IKLAN[HASIL_PUSAT]' ?>" rel="required" title="MK/TMK"><option></option><option value="MK" <?php if ($sess['HASIL_PUSAT'] == 'MK') echo 'Selected' ?>>Memenuhi Ketentuan</option><option value="TMK"  <?php if ($sess['HASIL_PUSAT'] == 'TMK') echo 'Selected' ?>>Tidak Memenuhi Ketentuan</option></select></td></tr>
         <?php
         if ($sess['JENIS_IKLAN'] == "Cetak") {
          $tindakLanjutCmb = $cb_tindakan2;
         } else {
          $tindakLanjutCmb = $cb_tindakan;
         }
         ?>
         <tr class="vTMK" hidden><td class="td_left"  style="background-color: white;">Tindak Lanjut</td><td class="td_right" style="background-color: white;"><?php echo form_dropdown('IKLAN[TL_PUSAT]', $tindakLanjutCmb, $sess['TL_PUSAT'], 'class="stext vTMK" id="vTMKSub" title="Tindak Lanjut Pusat"'); ?></td></tr>
         <tr class="vTMK2" hidden><td></td><td class="td_right"><input type="text" class="vTMK2" id="jmlMusnahPusat" title="Jumlah" placeholder = "Jumlah" maxlength="4" size="5" value="<?php echo $pemusnahanPusat[0] ?>"/>&nbsp;<input type="text" class="vTMK2" id="satuanMusnahPusat" title="Satuan" placeholder = "Satuan" size="10" value="<?php echo $pemusnahanPusat[1] ?>"/></td></tr>
         <tr class="vTMK2" hidden><td></td><td class="td_right">
           <?php
           if ((array_key_exists('FILE_MUSNAH_PUSAT', $sess) && trim($sess['FILE_MUSNAH_PUSAT']) != "")) {
            ?><input type="hidden" id = "fileMusnahPusat" value="<?php echo $sess['FILE_IKLAN_MUSNAH_PUSAT']; ?>">
            <span id="file_FILE_MUSNAH_PUSAT"><a href="<?php echo base_url(); ?>files/<?php echo 'iklan_011/1_011'; ?>/<?php echo $sess['FILE_MUSNAH_PUSAT']; ?>" target="_blank">File Lampiran</a>&nbsp;&bull;&nbsp;<a href="#" class="del_upload" id="del_upload2" url="<?php echo site_url(); ?>/utility/uploads/del_upload_m/<?php echo 'iklan_011/1_011'; ?>/<?php echo $sess['FILE_MUSNAH_PUSAT']; ?>" jns="FILE_MUSNAH_PUSAT">Edit atau Hapus File ?</a></span>
            <span class="upload_FILE_MUSNAH_PUSAT" hidden><input type="file" class="upload" jenis="FILE_MUSNAH_PUSAT" allowed="doc-docx-pdf" url="<?php echo site_url(); ?>/utility/uploads/get_upload_m/<?php echo 'iklan_011/1_011'; ?>"  id="fileToUpload_FILE_MUSNAH_PUSAT" name="userfile" onchange="do_upload($(this));
                 return false;" />
             &nbsp;Tipe File : *.doc .docx.pdf</span><span class="file_FILE_MUSNAH_PUSAT"></span>
            <?php
           } else {
            ?>
            <span class="upload_FILE_MUSNAH_PUSAT"><input type="file" class="upload" jenis="FILE_MUSNAH_PUSAT" allowed="doc-docx-pdf" url="<?php echo site_url(); ?>/utility/uploads/get_upload_m/<?php echo 'iklan_011/1_011'; ?>"  id="fileToUpload_FILE_MUSNAH_PUSAT" name="userfile" onchange="do_upload($(this));
                 return false;" />
             &nbsp;Tipe File : *.doc .docx.pdf</span><span class="file_FILE_MUSNAH_PUSAT"></span>
            <?php
           }
           ?></td></tr>
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
          <?php if ($sess['TL_PUSAT'] != NULL) { ?><tr><td class="td_left">Tindak Lanjut Pusat</td><td class="td_right"><?php echo $cb_tindakan2[$sess["TL_PUSAT"]]; ?></td></tr>
          <?php } if ($sess['TL_PUSAT'] == 6) { ?><tr><td class="td_left"></td><td class="td_right"><?php
           echo "<b>" . $sess['DETAIL_PUSAT'] . "</b>";
           ?></td></tr>
          <?php } if ($sess['PEMUSNAHANPUSAT'] != NULL && trim($sess['PEMUSNAHANPUSAT']) != '^') { ?>
           <tr><td></td><td class="td_right"><input type="text" title="Jumlah" placeholder = "Jumlah" maxlength="4" size="5" value="<?php echo $pemusnahanPusat[0] ?>"/>&nbsp;<input type="text" title="Satuan" placeholder = "Satuan" size="10" value="<?php echo $pemusnahanPusat[1] ?>"/>&nbsp;<a href="<?php echo base_url(); ?>files/<?php echo 'iklan_011/1_011'; ?>/<?php echo $sess['FILE_MUSNAH_PUSAT']; ?>" target="_blank">Lihat Lampiran</a></td></tr>
          <?php } if ($sess['JUSTIFIKASI_PUSAT'] != NULL && trim($sess['JUSTIFIKASI_PUSAT']) != "" && $sess['HASIL_PUSAT'] != $sess['HASIL']) { ?>
           <tr><td class="td_left">Justifikasi Pusat</td><td class="td_right"><?php echo $sess['JUSTIFIKASI_PUSAT']; ?></td></tr>
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
          <?php if ($sess['JUSTIFIKASI_PUSAT'] != NULL && trim($sess['JUSTIFIKASI_PUSAT']) != "" && $sess['HASIL_PUSAT'] != $sess['HASIL']) { ?>
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
        <?php
        if (trim($sess["TL_BALAI"]) != "" && $sess["TL_BALAI"] != NULL) {
         ?>
         <tr class="TDKB"><td class="td_left">Tindak Lanjut Balai</td><td class="td_right"><?php echo $cb_tindakan_balai[$sess["TL_BALAI"]]; ?></td></tr>
         <?php if ($sess["TL_BALAI"] == "2") { ?>
          <tr class="tDKBalaiRow"><td></td><td class="td_right"><input type="text" class="tDKBalaiRow" id="jmlMusnah" title="Jumlah" placeholder = "Jumlah" maxlength="4" size="5" readonly value="<?php echo $pemusnahan[0] ?>"/>&nbsp;<input type="text" class="tDKBalaiRow" id="satuanMusnah" title="Satuan" placeholder = "Satuan" size="10" readonly value="<?php echo $pemusnahan[1] ?>"/>&nbsp;
            <a href="<?php echo base_url(); ?>files/<?php echo 'iklan_011/2_011'; ?>/<?php echo $sess['FILE_MUSNAH']; ?>" target="_blank">Lihat Lampiran</a>
            <?php
            ?></td></tr>
          <?php
         }
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
        <tr><td class="td_left">Lampiran</td><td class="td_right"><a href="<?php echo base_url(); ?>files/<?php echo 'iklan_011'; ?>/<?php echo $sess['FILE_IKLAN']; ?>" target="_blank" <?php if ($arrLamp[1] == "rar") echo 'onclick="dotRar();return false;"'; ?>>Lihat Lampiran</a></td></tr>
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
    <div style="padding:10px;"></div><div><?php if ($formEdit === 'check') { ?><a href="javascript:void(0)" id="btnSave" class="button check" onclick="fpost('#fpengawasanIklan_001', '', '');">
       <span><span class="icon"></span>&nbsp; <?php echo $save; ?> Proses</span></a>&nbsp;<?php } ?><a href="javascript:void(0)" class="button back" onclick="goBack()" >
      <span><span class="icon"></span>&nbsp; Kembali</span></a>
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
               $(".chkJustifikasi").val("");
              }
             }
             function verifikasiTL(X) {
              if ($(X).val() == '5') {
               $(".vTMK2").show("slow");
               $(".vTMK2").attr("rel", "required");
               $("#fileToUpload_FILE_MUSNAH").attr("rel", "required");
               $("#fileToUpload_FILE_MUSNAH_PUSAT").attr("rel", "required");
               $("#jmlMusnahPusat").attr("name", "MUSNAHPUSAT[]");
               $("#satuanMusnahPusat").attr("name", "MUSNAHPUSAT[]");
               $("#fileMusnahPusat").attr("name", "MUSNAHPUSAT[]");
               $(".diData").hide();
               $(".diData").attr("rel", "");
               $("#diData").attr("name", "");
               $("#diData").val("");
              } else if ($(X).val() == '6') {
               $(".vTMK2").hide();
               $(".vTMK2").attr("rel", "");
               $("#fileToUpload_FILE_MUSNAH").attr("rel", "");
               $("#fileToUpload_FILE_MUSNAH_PUSAT").attr("rel", "");
               $(".vTMK2").val("");
               $(".vTMK2a").val("");
               $("#jmlMusnahPusat").attr("name", "");
               $("#satuanMusnahPusat").attr("name", "");
               $("#fileMusnahPusat").attr("name", "");
               $(".diData").show("slow");
               $(".diData").attr("rel", "required");
               $("#diData").attr("name", "IKLAN[DETAIL_PUSAT]");
              } else {
               $(".vTMK2").hide();
               $(".vTMK2").attr("rel", "");
               $("#fileToUpload_FILE_MUSNAH").attr("rel", "");
               $("#fileToUpload_FILE_MUSNAH_PUSAT").attr("rel", "");
               $(".vTMK2").val("");
               $(".vTMK2a").val("");
               $("#jmlMusnahPusat").attr("name", "");
               $("#satuanMusnahPusat").attr("name", "");
               $("#fileMusnahPusat").attr("name", "");
               $(".diData").hide();
               $(".diData").attr("rel", "");
               $("#diData").attr("name", "");
               $("#diData").val("");
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
                   $(".file_" + arrdata[2] + "").html("<b>1 File telah dilampirkan. </b>&nbsp;<a href=\"<?php echo base_url(); ?>files/" + arrdata[3] + "/" + arrdata[0] + "\" target=\"_blank\">Tampilkan File</a>&nbsp;&bull;&nbsp;<a href=\"#\" class=\"del_upload\" url=\"<?php echo site_url(); ?>/utility/uploads/del_upload_s/" + arrdata[3] + "/" + arrdata[0] + "\" jns=" + arrdata[2] + ">Edit atau Hapus File ?</a><input type=\"hidden\" name=\"IKLAN_OT[" + arrdata[2] + "]\" value=" + arrdata[0] + ">");
                  } else if (arrdata[2] == "FILE_MUSNAH") {
                   $("#fileToUpload_" + arrdata[2] + "").removeAttr("rel");
                   $(".upload_" + arrdata[2] + "").hide();
                   $(".file_" + arrdata[2] + "").html("<b>1 File telah dilampirkan. </b>&nbsp;<a href=\"<?php echo base_url(); ?>files/" + arrdata[3] + "/" + arrdata[4] + "/" + arrdata[0] + "\" target=\"_blank\">Tampilkan File</a>&nbsp;&bull;&nbsp;<a href=\"#\" class=\"del_upload\" id=\"del_upload1\" url=\"<?php echo site_url(); ?>/utility/uploads/del_upload_m/" + arrdata[3] + "/" + arrdata[4] + "/" + arrdata[0] + "\" jns=" + arrdata[2] + ">Edit atau Hapus File ?</a><input type=\"hidden\" name=\"MUSNAH[]\" value=" + arrdata[0] + ">");
                  } else if (arrdata[2] == "FILE_MUSNAH_PUSAT") {
                   $("#fileToUpload_" + arrdata[2] + "").removeAttr("rel");
                   $(".upload_" + arrdata[2] + "").hide();
                   $(".file_" + arrdata[2] + "").html("<b>1 File telah dilampirkan. </b>&nbsp;<a href=\"<?php echo base_url(); ?>files/" + arrdata[3] + "/" + arrdata[4] + "/" + arrdata[0] + "\" target=\"_blank\">Tampilkan File</a>&nbsp;&bull;&nbsp;<a href=\"#\" class=\"del_upload\" id=\"del_upload2\" url=\"<?php echo site_url(); ?>/utility/uploads/del_upload_m/" + arrdata[3] + "/" + arrdata[4] + "/" + arrdata[0] + "\" jns=" + arrdata[2] + ">Edit atau Hapus File ?</a><input type=\"hidden\" name=\"MUSNAHPUSAT[]\" value=" + arrdata[0] + ">");
                   $("#fileToUpload_FILE_MUSNAH_PUSAT").attr("rel", "");
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
             function musnahkan2() {
              $("#jmlMusnahPusat").val("");
              $("#satuanMusnahPusat").val("");
              $("#fileMusnahPusat").val("");
              musnahkanFile("#del_upload2");
             }
             function musnahkanFile(id) {
              var jenis = $(id).attr("jns");
              $.ajax({
               type: "GET",
               url: $(id).attr("url"),
               data: $(id).serialize(),
               success: function(data) {
                var arrdata = data.split("#");
                $(".upload_" + jenis + "").show();
                $("#fileToUpload_" + jenis + "").val('');
                $(".file_" + jenis + "").html("");
                $("#file_" + jenis + "").hide();
                if (jenis !== "FILE_LAMPIRAN_IKLAN")
                 $("#fileToUpload_" + jenis + "").attr("rel", "");
               }
              });
              return false;
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
              var obj;
              create_ck("textarea.chk", 505)
              $("#detail_petugas").html("Loading ...");
              $("#detail_petugas").load($("#detail_petugas").attr("url"));
              $("#F02MM_tgpusat, #F02MM_tgperbaikan").datepicker();
              $(".del_tl").live("click", function() {
               var id = $(this).closest("ul#list_tl li").attr("id");
               $("ul#list_tl li#" + id).remove();
               return false;
              });
              if ("<?php echo $this->newsession->userdata('SESS_BBPOM_ID') ?>" === "92") {
               verifikasiPusat($('.verifikasiPusat'));
              }
              $("input.sdate").datepicker({dateFormat: 'dd/mm/yy', regional: 'id'});
              $('.verifikasiPusat').change(function() {
               verifikasiPusat($(this));
              });
              $('.verifikasiPusat').change(function() {
               verifikasiPusat($(this));
              });
              $("#vTMKSub").change(function() {
               verifikasiTL($(this));
              });
              $("#jmlMusnahPusat").keydown(function(e) {
               if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 || (e.keyCode == 65 && e.ctrlKey === true) || (e.keyCode >= 35 && e.keyCode <= 39)) {
                return;
               }
               if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                e.preventDefault();
                jAlert("Maaf, hanya angka yang diperbolehkan")
               }
              });
              $("#satuanMusnahPusat").change(function() {
               var val = $(this).val();
               var val2 = val.charAt(0).toUpperCase();
               val = val.slice(1);
               $(this).val(val2 + val);
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
                 if (jenis !== "FILE_LAMPIRAN_IKLAN")
                  $("#fileToUpload_" + jenis + "").attr("rel", "");
                }
               });
               return false;
              });
             });
</script>