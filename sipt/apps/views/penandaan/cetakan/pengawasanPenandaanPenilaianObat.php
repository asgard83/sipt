<?php
if (!defined('BASEPATH'))
 exit('No direct script access allowed');
error_reporting(E_ERROR);
?>
<div id="judulpmnpdd" class="judul"></div>
<div class="headersarana">PENGAWASAN PENANDAAN OBAT</div>
<?php
$d1 = explode('*', $sess['BUNGKUS_LUAR']);
$d2 = explode('*', $sess['ETIKET']);
$d3 = explode('*', $sess['AMPUL_VIAL10ML']);
$d4 = explode('*', $sess['AMPUL_VIAL9ML']);
$d5 = explode('*', $sess['BROSUR']);
$d6 = explode('*', $sess['AMPLOP']);
$d7 = explode('*', $sess['BLISTER']);
$detail1 = explode('#', $d1[1]);
$detail2 = explode('#', $d2[1]);
$detail3 = explode('#', $d3[1]);
$detail4 = explode('#', $d4[1]);
$detail5 = explode('#', $d5[1]);
$detail6 = explode('#', $d6[1]);
$detail7 = explode('#', $d7[1]);
foreach ($detail1 as $k) {
 $detailsub1[] = explode('_', $k);
}foreach ($detail2 as $k) {
 $detailsub2[] = explode('_', $k);
}foreach ($detail3 as $k) {
 $detailsub3[] = explode('_', $k);
}foreach ($detail4 as $k) {
 $detailsub4[] = explode('_', $k);
}foreach ($detail5 as $k) {
 $detailsub5[] = explode('_', $k);
}foreach ($detail6 as $k) {
 $detailsub6[] = explode('_', $k);
}foreach ($detail7 as $k) {
 $detailsub7[] = explode('_', $k);
}
?>
<div class="content">
 <form action="<?php echo $act; ?>" method="post" autocomplete="off" id="fpengawasanPenandaan_001">
  <div class="adCntnr">
   <div class="acco2">
    <div class="collapse">
     <div class="accCntnt">
      <h2 class="small garis">Informasi Pengawasan Penandaan</h2>
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
         <?php echo $sess['TANGGAL_MULAI']; ?></td>
       </tr>
       <tr><td class="td_left">Sarana</td><td class="td_right"><?php echo $sess['NAMA_SARANA']; ?></td>
       </tr>
       <tr><td class="td_left">Alamat</td><td class="td_right"><?php echo $sess['ALAMAT_1'] . ", " . $sess['KOTA'] . ", " . $sess['PROPINSI']; ?></td>
       </tr>
      </table>
     </div>
    </div>
    <div style="height:5px;"></div><div class="expand"><a title="expand/collapse" href="#" style="display: block;">INFORMASI OBAT - PENGAWASAN PENANDAAN</a></div>
    <div class="collapse">
     <div class="accCntnt">
      <h2 class="small garis">Informasi Produk Penandaan</h2>
      <table class="form_tabel">
       <tr><td class="td_left">Nama Obat Jadi</td><td><?php echo $sess['NAMA_PRODUK']; ?></td>
       </tr>
       <tr><td class="td_left">Nomor Izin Edar</td><td><?php
         echo $sess['NOMOR_IZIN_EDAR'];
         if ($asalProduk == "NO")
          echo " &raquo; <b>Bukan Produk Webreg</b>"
          ?></td>
       </tr>
       <tr><td class="td_left">Klasifikasi Obat</td><td><?php echo $sess['KLASIFIKASI_PRODUK']; ?></td>
       </tr>
       <tr><td class="td_left">Komposisi</td><td><?php echo $sess['KOMPOSISI']; ?></td>
       </tr>
       <tr><td class="td_left">Klasifikasi Pendaftar</td><td><?php echo $sess['KLASIFIKASI_PENDAFTAR']; ?></td>
       </tr>
       <tr><td class="td_left">Produsen</td><td><?php echo $sess['PRODUSEN']; ?></td>
       </tr>
       <tr><td class="td_left">Pendaftar</td><td><?php echo $sess['PENDAFTAR']; ?></td>
       </tr>
       <tr><td class="td_left">Bentuk Sediaan</td><td><?php echo $sess['BENTUK_SEDIAAN']; ?></td>
       </tr>
       <tr><td class="td_left">Besar Kemasan</td><td><?php echo $sess['BESAR_KEMASAN']; ?></td>
       </tr>
       <tr><td class="td_left">Golongan Obat</td><td><?php echo $sess['GOLONGAN_PRODUK']; ?></td>
       </tr>
       <tr><td class="td_left">Nomor Batch</td><td><?php echo $sess['NOMOR_PRODUK']; ?></td>
       </tr>
      </table>
     </div>
    </div>
    <pagebreak />
    <div>
     <h2 class="small garis">Detil Penilaian :</h2>
     <?php
     if (end($detail1) == "MK" || end($detail1) == "TMK") {
      ?>
      <div>
       <b>Bungkus Luar</b>
       <table border="1">
        <?php
        foreach ($detailsub1 as $value) {
         if ($value[1] != "") {
          ?>
          <tr>
           <td class="td_left"><?php echo $value[1]; ?></td>
           <td class="td_right"><?php
            if ($value[0] == "-") {
             echo 'Tidak Ada';
            } else if ($value[0] == "+") {
             echo 'Ada';
            }
            ?></td>
          </tr>
          <?php
         } else if ($value[0] != "" && $value[0] != "+" && $value[0] != "-" && $value[0] != "TMK" && $value[0] != "MK") {
          ?>
          <tr>
           <td class="td_left"><?php echo 'Informasi Tambahan' ?></td>
           <td class="td_right"><?php echo $value[0]; ?></td>
          </tr>
          <?php
         }
        }
        ?>
        <tr>
         <td class="td_left"><b>Kesimpulan</b></td>
         <td class="td_right" style="width: 25%"><b><?php
           if ($detail1[31] == "TMK")
            echo "Tidak Memenuhi Ketentuan";
           else
            echo "Memenuhi Ketentuan";
           ?></b></td>
        </tr>
        <?php if ($d1[2] != '') { ?>
         <tr><td colspan="2"><h2 class="small garis">Detil Pelanggaran :</h2></td></tr>
         <tr>
          <td class="td_left" colspan="2"><?php echo $d1[2]; ?></td>
         </tr>
         <tr>
          <td class="td_left" colspan="2">Jumlah Jenis Pelanggaran : <?php
           if ($d1[2] != '')
            echo count(explode(", ", $d1[2]));
           else
            echo '0';
           ?></td>
         </tr>
         <tr></tr>
        <?php } if (in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) { ?>
         <tr><td colspan="2"><h2 class="small garis">Kesimpulan Pusat :</h2></td></tr>
         <?php
         $TLBL = explode("^", $d1[5]);
         $TLBLSub = explode("^", $d1[6]);
         $tempBL = array($TLBL[1], $TLBL[2]);
         $tempBLSub = array($TLBLSub[0], $TLBLSub[1]);
         if ((trim($d1[3]) == "" && in_array('2', $this->newsession->userdata('SESS_KODE_ROLE'))) || $editTL == 'YES') {
          ?>
          <tr><td class="td_left">Verifikasi Pusat</td><td class="td_right"><select id="BL" class="stext verifikasiPusat" name="<?php echo 'BL[HASIL_PUSAT][]' ?>" title="MK/TMK" <?php if (end($detail1) == "MK" || end($detail1) == "TMK") echo 'rel="required"'; ?>><option></option><option value="MK" <?php if ($d1[3] == "MK") echo 'Selected' ?>>Memenuhi Ketentuan</option><option value="TMK" <?php if ($d1[3] == "TMK") echo 'Selected' ?>>Tidak Memenuhi Ketentuan</option></select></tr>
          <tr class="vTMK_BL" hidden><td class="td_left">Kategori Pelanggaran</td><td class="td_right"><select class="sjenis vTMKa_BL" title="Kategori Pelanggaran"><option></option><option value="Kritikal" <?php if ($TLBL[0] == "Kritikal") echo 'Selected' ?>>Kritikal</option><option value="Non Kritikal" <?php if ($TLBL[0] == "Non Kritikal") echo 'Selected' ?>>Non Kritikal</option></select></td><td colspan="2"></td></tr>
          <tr class="vTMK_BL" hidden><td class="td_left"style="background-color: white;">Tindak Lanjut</td><td class="td_right" style="background-color: white;"><?php echo form_dropdown('BL[HASIL_PUSAT][]', $cb_tl, trim($d1[4]) != "" ? $d1[4] : '', 'class="stext verifikasiPusatSub" id="vTMKSub_BL" title="Tindak Lanjut Pusat"'); ?></td></tr>
          <tr class="vTMK2_BL" hidden><td class="td_left"style="background-color: white;"></td><td class="td_right" style="background-color: white;"><?php echo form_dropdown('BL[TL_PUSAT][]', $cb_tindakan, is_array($tempBL) ? $tempBL : '', 'class="stext multiselect vTMK2_BL" multiple title="Saran Tindak Lanjut Pusat. Untuk memilih lebih dari satu, klik + Ctrl"'); ?></td><td colspan="2" style="background-color: white;"></td></tr>
          <tr class="vTMK2_BL" hidden><td class="td_left">Surat Tindak Lanjut</td><td class="td_right"><input type="text" class="sdate vTMK2a_BL" name="BL[DETAIL_PUSAT][]" id="tglSuratTLBL" title="Tanggal Surat Tindak Lanjut" placeholder="Tanggal Surat" onchange="comp('D')" value="<?php echo $TLBLSub[0]; ?>"/>&nbsp;&nbsp;&nbsp;Tanggal Surat Tindak Lanjut</td></tr>
          <tr class="vTMK2_BL" hidden><td class="td_left"></td><td class="td_right"><input type="text" class="stext vTMK2a_BL" name="BL[DETAIL_PUSAT][]" id="stugas_"  title="Di isi dengan nomor surat tindak lanjut" placeholder="Nomor Surat Tindak Lanjut" value="<?php echo $TLBLSub[1]; ?>"/>&nbsp;&nbsp;&nbsp;Nomor Surat Tindak Lanjut</td></tr>
          <tr class="vJustifikasi_BL" hidden><td class="td_left">Justifikasi</td><td style="padding: 5px" colspan="2"><textarea name="JUSTIFIKASI_BL" title="Justifikasi Pusat" class="stext chkJustifikasi chkJustifikasi_BL" style="height: 140px"><?php echo $d1[7]; ?></textarea></td></tr>
          <?php
         } else if (trim($d1[3]) != "") {
          ?>
          <tr><td class="td_left">Verifikasi Pusat</td><td class="td_right" colspan="2"><b><i><?php
              if ($d1[3] == "TMK")
               echo "Tidak Memenuhi Ketentuan";
              else
               echo "Memenuhi Ketentuan";
              ?></i></b></td></tr>
          <?php if (trim($TLBL[0]) != "") { ?><tr><td class="td_left">Kategori Pelanggaran</td><td class="td_right" colspan="2"><?php echo $TLBL[0]; ?></td></tr>
          <?php } if (trim($d1[4]) != "") { ?><tr><td class="td_left">Tindak Lanjut</td><td class="td_right" colspan="2"><?php if ($d1[4] == "TL") echo "Tindak Lanjut"; else if ($d1[4] == "STL") echo "Sudah Tindak Lanjut"; else if ($d1[4] == "TTL") echo "Tidak Dapat Tindak Lanjut" ?></td></tr>
          <?php }if (trim($TLBL[1]) != "") { ?><tr><td class="td_left">Detil Tindak Lanjut Pusat</td><td class="td_right" colspan="2"><ul style="list-style-type:decimal; padding-left:20px; margin:0;"><?php
           if ($TLBL[2] != '')
            echo "<li>" . join("</li><li>", $tempBL) . "</li>";
           else
            echo "<li>" . $TLBL[1] . "</li>";
           ?></ul></td></tr>
          <?php } if (trim($TLBLSub[0]) != "") {
           ?><tr><td class="td_left">Surat Tindak Lanjut</td><td class="td_right" colspan="2"><ul style="padding-left:20px; margin:0;"><?php
              echo "<li>Tangal Surat : " . join("</li><li>Nomor Surat : ", $tempBLSub) . "</li>";
              ?></ul></td></tr>
          <?php } if (trim($d1[7]) != "") {
           ?>
           <tr><td class="td_left">Justifikasi Pusat</td><td class="td_right" colspan="2"><?php echo $d1[7]; ?></td></tr>
           <?php
          }
         }
        }
        ?>
       </table>
      </div>
      <pagebreak />
     <?php } if (end($detail6) == "MK" || end($detail6) == "TMK") {
      ?>
      <div>
       <b>Amplop/ Catch cover/ Sachet</b>
       <table border="1">
        <?php
        foreach ($detailsub6 as $value) {
         if ($value[1] != "") {
          ?>
          <tr>
           <td class="td_left"><?php echo $value[1]; ?></td>
           <td class="td_right"><?php
            if ($value[0] == "-") {
             echo 'Tidak Ada';
            } else if ($value[0] == "+") {
             echo 'Ada';
            }
            ?></td>
          </tr>
          <?php
         } else if ($value[0] != "" && $value[0] != "+" && $value[0] != "-" && $value[0] != "TMK" && $value[0] != "MK") {
          ?>
          <tr>
           <td class="td_left"><?php echo 'Informasi Tambahan' ?></td>
           <td class="td_right"><?php echo $value[0]; ?></td>
          </tr>
          <?php
         }
        }
        ?>
        <tr>
         <td class="td_left"><b>Kesimpulan</b></td>
         <td class="td_right" style="width: 25%"><b><?php
           if ($detail6[31] == "TMK")
            echo "Tidak Memenuhi Ketentuan";
           else
            echo "Memenuhi Ketentuan";
           ?></b></td>
        </tr>
        <?php if ($d6[2] != '') { ?>
         <tr><td colspan="2">&nbsp;</td></tr>
         <tr><td colspan="2"><h2 class="small garis">Detil Pelanggaran :</h2></td></tr>
         <tr>
          <td class="td_left" colspan="2"><?php echo $d6[2]; ?></td>
         </tr>
         <tr>
          <td class="td_left" colspan="2">Jumlah Jenis Pelanggaran : <?php
           if ($d6[2] != '')
            echo count(explode(", ", $d6[2]));
           else
            echo '0';
           ?></td>
         </tr>
         <tr></tr>
        <?php } if (in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) { ?>
         <tr><td colspan="2"><h2 class="small garis">Kesimpulan Pusat :</h2></td></tr>
         <?php
         $TLAS = explode("^", $d6[5]);
         $TLASSub = explode("^", $d6[6]);
         $tempAS = array($TLAS[1], $TLAS[2]);
         $tempASSub = array($TLASSub[0], $TLASSub[1]);
         if ((trim($d6[3] == "") && in_array('2', $this->newsession->userdata('SESS_KODE_ROLE'))) || $editTL == 'YES') {
          ?>
          <tr><td class="td_left">Verifikasi Pusat</td><td class="td_right"><select id="AS" class="stext verifikasiPusat" name="<?php echo 'AS[HASIL_PUSAT][]' ?>" title="MK/TMK" <?php if (end($detail6) == "MK" || end($detail6) == "TMK") echo 'rel="required"'; ?>><option></option><option value="MK" <?php if ($d6[3] == "MK") echo 'Selected' ?>>Memenuhi Ketentuan</option><option value="TMK" <?php if ($d6[3] == "TMK") echo 'Selected' ?>>Tidak Memenuhi Ketentuan</option></select></tr>
          <tr class="vTMK_AS" hidden><td class="td_left">Kategori Pelanggaran</td><td class="td_right"><select class="sjenis vTMKa_AS" title="Kategori Pelanggaran"><option></option><option value="Kritikal" <?php if ($TLAS[0] == "Kritikal") echo 'Selected' ?>>Kritikal</option><option value="Non Kritikal" <?php if ($TLAS[0] == "Non Kritikal") echo 'Selected' ?>>Non Kritikal</option></select></td></tr>
          <tr class="vTMK_AS" hidden><td class="td_left"style="background-color: white;">Tindak Lanjut</td><td class="td_right" style="background-color: white;"><?php echo form_dropdown('AS[HASIL_PUSAT][]', $cb_tl, trim($d6[4]) != "" ? $d6[4] : '', 'class="stext verifikasiPusatSub" id="vTMKSub_AS" title="Tindak Lanjut Pusat"'); ?></td></tr>
          <tr class="vTMK2_AS" hidden><td class="td_left"style="background-color: white;"></td><td class="td_right" style="background-color: white;"><?php echo form_dropdown('AS[TL_PUSAT][]', $cb_tindakan, is_array($tempAS) ? $tempAS : '', 'class="stext multiselect vTMK2_AS" multiple title="Saran Tindak Lanjut Pusat. Untuk memilih lebih dari satu, klik + Ctrl"'); ?></td></tr>
          <tr class="vTMK2_AS" hidden><td class="td_left">Surat Tindak Lanjut</td><td class="td_right"><input type="text" class="sdate vTMK2a_AS" name="AS[DETAIL_PUSAT][]" id="tglSuratTLAS" title="Tanggal Surat Tindak Lanjut" placeholder="Tanggal Surat" onchange="comp('D')" value="<?php echo $TLASSub[0]; ?>"/>&nbsp;&nbsp;&nbsp;Tanggal Surat Tindak Lanjut</td></tr>
          <tr class="vTMK2_AS" hidden><td class="td_left"></td><td class="td_right"><input type="text" class="stext vTMK2a_AS" name="AS[DETAIL_PUSAT][]" id="stugas_"  title="Di isi dengan nomor surat tindak lanjut" placeholder="Nomor Surat Tindak Lanjut" value="<?php echo $TLASSub[1]; ?>"/>&nbsp;&nbsp;&nbsp;Nomor Surat Tindak Lanjut</td></tr>
          <tr class="vJustifikasi_AS" hidden><td class="td_left">Justifikasi</td><td style="padding: 5px" colspan="2"><textarea name="JUSTIFIKASI_AS" title="Justifikasi Pusat" class="stext chkJustifikasi chkJustifikasi_AS" style="height: 140px"><?php echo $d6[7]; ?></textarea></td></tr>
          <?php
         } else if (trim($d6[3]) != "") {
          ?>
          <tr><td class="td_left">Verifikasi Pusat</td><td class="td_right" colspan="2"><b><i><?php
              if ($d6[3] == "TMK")
               echo "Tidak Memenuhi Ketentuan";
              else
               echo "Memenuhi Ketentuan";
              ?></i></b></td></tr>
          <?php if (trim($TLAS[0]) != "") { ?><tr><td class="td_left">Kategori Pelanggaran</td><td class="td_right" colspan="2"><?php echo $TLAS[0]; ?></td></tr>
          <?php } if (trim($d6[4]) != "") { ?><tr><td class="td_left">Tindak Lanjut</td><td class="td_right" colspan="2"><?php if ($d6[4] == "TL") echo "Tindak Lanjut"; else if ($d6[4] == "STL") echo "Sudah Tindak Lanjut"; else if ($d6[4] == "TTL") echo "Tidak Dapat Tindak Lanjut" ?></td></tr>
          <?php }if (trim($TLAS[1]) != "") { ?><tr><td class="td_left">Detil Tindak Lanjut Pusat</td><td class="td_right" colspan="2"><ul style="list-style-type:decimal; padding-left:20px; margin:0;"><?php
           if ($TLAS[2] != '')
            echo "<li>" . join("</li><li>", $tempAS) . "</li>";
           else
            echo "<li>" . $TLAS[1] . "</li>";
           ?></ul></td></tr>
          <?php } if (trim($TLASSub[0]) != "") {
           ?><tr><td class="td_left">Surat Tindak Lanjut</td><td class="td_right" colspan="2"><ul style="padding-left:20px; margin:0;"><?php
              echo "<li>Tangal Surat : " . join("</li><li>Nomor Surat : ", $tempASSub) . "</li>";
              ?></ul></td></tr>
          <?php } if (trim($d6[7]) != "") {
           ?>
           <tr><td class="td_left">Justifikasi Pusat</td><td class="td_right" colspan="2"><?php echo $d6[7]; ?></td></tr>
           <?php
          }
         }
        }
        ?>
       </table>
       <pagebreak />
      <?php } if (end($detail2) == "MK" || end($detail2) == "TMK") {
       ?>
       <div>
        <b>Etiket</b>
        <table border="1">
         <?php
         foreach ($detailsub2 as $value) {
          if ($value[1] != "") {
           ?>
           <tr>
            <td class="td_left"><?php echo $value[1]; ?></td>
            <td class="td_right"><?php
             if ($value[0] == "-") {
              echo 'Tidak Ada';
             } else if ($value[0] == "+") {
              echo 'Ada';
             }
             ?></td>
           </tr>
           <?php
          } else if ($value[0] != "" && $value[0] != "+" && $value[0] != "-" && $value[0] != "TMK" && $value[0] != "MK") {
           ?>
           <tr>
            <td class="td_left"><?php echo 'Informasi Tambahan' ?></td>
            <td class="td_right"><?php echo $value[0]; ?></td>
           </tr>
           <?php
          }
         }
         ?>
         <tr>
          <td class="td_left"><b>Kesimpulan</b></td>
          <td class="td_right" style="width: 25%"><b><?php
            if ($detail2[30] == "TMK")
             echo "Tidak Memenuhi Ketentuan";
            else
             echo "Memenuhi Ketentuan";
            ?></b></td>
         </tr>
         <?php if ($d2[2] != '') { ?>
          <tr><td colspan="2">&nbsp;</td></tr>
          <tr><td colspan="2"><h2 class="small garis">Detil Pelanggaran :</h2></td></tr>
          <tr>
           <td class="td_left" colspan="2"><?php echo $d2[2]; ?></td>
          </tr>
          <tr>
           <td class="td_left" colspan="2">Jumlah Jenis Pelanggaran : <?php
            if ($d2[2] != '')
             echo count(explode(", ", $d2[2]));
            else
             echo '0';
            ?></td>
          </tr>
          <tr></tr>
         <?php } if (in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) { ?>
          <tr><td colspan="2"><h2 class="small garis">Kesimpulan Pusat :</h2></td></tr>
          <?php
          $TLET = explode("^", $d2[5]);
          $TLETSub = explode("^", $d2[6]);
          $tempET = array($TLET[1], $TLET[2]);
          $tempETSub = array($TLETSub[0], $TLETSub[1]);
          if ((trim($d2[3]) == "" && in_array('2', $this->newsession->userdata('SESS_KODE_ROLE'))) || $editTL == 'YES') {
           ?>
           <tr><td class="td_left">Verifikasi Pusat</td><td class="td_right"><select id="ET" class="stext verifikasiPusat" name="<?php echo 'ET[HASIL_PUSAT][]' ?>" title="MK/TMK" <?php if (end($detail2) == "MK" || end($detail2) == "TMK") echo 'rel="required"'; ?>><option></option><option value="MK" <?php if ($d2[3] == "MK") echo 'Selected' ?>>Memenuhi Ketentuan</option><option value="TMK" <?php if ($d2[3] == "TMK") echo 'Selected' ?>>Tidak Memenuhi Ketentuan</option></select></tr>
           <tr class="vTMK_ET" hidden><td class="td_left">Kategori Pelanggaran</td><td class="td_right"><select class="sjenis vTMKa_ET" title="Kategori Pelanggaran"><option></option><option value="Kritikal" <?php if ($TLET[0] == "Kritikal") echo 'Selected' ?>>Kritikal</option><option value="Non Kritikal" <?php if ($TLET[0] == "Non Kritikal") echo 'Selected' ?>>Non Kritikal</option></select></td></tr>
           <tr class="vTMK_ET" hidden><td class="td_left"style="background-color: white;">Tindak Lanjut</td><td class="td_right" style="background-color: white;"><?php echo form_dropdown('ET[HASIL_PUSAT][]', $cb_tl, trim($d2[4]) != "" ? $d2[4] : '', 'class="stext verifikasiPusatSub" id="vTMKSub_ET" title="Tindak Lanjut Pusat"'); ?></td></tr>
           <tr class="vTMK2_ET" hidden><td class="td_left"style="background-color: white;"></td><td class="td_right" style="background-color: white;"><?php echo form_dropdown('ET[TL_PUSAT][]', $cb_tindakan, is_array($tempET) ? $tempET : '', 'class="stext multiselect vTMK2_ET" multiple title="Saran Tindak Lanjut Pusat. Untuk memilih lebih dari satu, klik + Ctrl"'); ?></td></tr>
           <tr class="vTMK2_ET" hidden><td class="td_left">Surat Tindak Lanjut</td><td class="td_right"><input type="text" class="sdate vTMK2a_ET" name="ET[DETAIL_PUSAT][]" id="tglSuratTLET" title="Tanggal Surat Tindak Lanjut" placeholder="Tanggal Surat" onchange="comp('D')" value="<?php echo $TLETSub[0]; ?>"/>&nbsp;&nbsp;&nbsp;Tanggal Surat Tindak Lanjut</td></tr>
           <tr class="vTMK2_ET" hidden><td class="td_left"></td><td class="td_right"><input type="text" class="stext vTMK2a_ET" name="ET[DETAIL_PUSAT][]" id="stugas_"  title="Di isi dengan nomor surat tindak lanjut" placeholder="Nomor Surat Tindak Lanjut" value="<?php echo $TLETSub[1]; ?>"/>&nbsp;&nbsp;&nbsp;Nomor Surat Tindak Lanjut</td></tr>
           <tr class="vJustifikasi_ET" hidden><td class="td_left">Justifikasi</td><td style="padding: 5px" colspan="2"><textarea name="JUSTIFIKASI_ET" title="Justifikasi Pusat" class="stext chkJustifikasi chkJustifikasi_ET" style="height: 140px"><?php echo $d2[7]; ?></textarea></td></tr>
           <?php
          } else if (trim($d2[3]) != "") {
           ?>
           <tr><td class="td_left">Verifikasi Pusat</td><td class="td_right" colspan="2"><b><i><?php
               if ($d2[3] == "TMK")
                echo "Tidak Memenuhi Ketentuan";
               else
                echo "Memenuhi Ketentuan";
               ?></i></b></td></tr>
           <?php if (trim($TLET[0]) != "") { ?><tr><td class="td_left">Kategori Pelanggaran</td><td class="td_right" colspan="2"><?php echo $TLET[0]; ?></td></tr>
           <?php } if (trim($d2[4]) != "") { ?><tr><td class="td_left">Tindak Lanjut</td><td class="td_right" colspan="2"><?php if ($d2[4] == "TL") echo "Tindak Lanjut"; else if ($d2[4] == "STL") echo "Sudah Tindak Lanjut"; else if ($d2[4] == "TTL") echo "Tidak Dapat Tindak Lanjut" ?></td></tr>
           <?php }if (trim($TLET[1]) != "") { ?><tr><td class="td_left">Detil Tindak Lanjut Pusat</td><td class="td_right" colspan="2"><ul style="list-style-type:decimal; padding-left:20px; margin:0;"><?php
            if ($TLET[2] != '')
             echo "<li>" . join("</li><li>", $tempET) . "</li>";
            else
             echo "<li>" . $TLET[1] . "</li>";
            ?></ul></td></tr>
           <?php } if (trim($TLETSub[0]) != "") {
            ?><tr><td class="td_left">Surat Tindak Lanjut</td><td class="td_right" colspan="2"><ul style="padding-left:20px; margin:0;"><?php
               echo "<li>Tangal Surat : " . join("</li><li>Nomor Surat : ", $tempETSub) . "</li>";
               ?></ul></td></tr>
           <?php } if (trim($d2[7]) != "") {
            ?>
            <tr><td class="td_left">Justifikasi Pusat</td><td class="td_right" colspan="2"><?php echo $d2[7]; ?></td></tr>
            <?php
           }
          }
         }
         ?>
        </table>
       </div>
       <pagebreak />
      <?php } if (end($detail7) == "MK" || end($detail7) == "TMK") {
       ?>
       <div>
        <b>Strip/ Blister</b>
        <table border="1">
         <?php
         foreach ($detailsub7 as $value) {
          if ($value[1] != "") {
           ?>
           <tr>
            <td class="td_left"><?php echo $value[1]; ?></td>
            <td class="td_right"><?php
             if ($value[0] == "-") {
              echo 'Tidak Ada';
             } else if ($value[0] == "+") {
              echo 'Ada';
             }
             ?></td>
           </tr>
           <?php
          } else if ($value[0] != "" && $value[0] != "+" && $value[0] != "-" && $value[0] != "TMK" && $value[0] != "MK") {
           ?>
           <tr>
            <td class="td_left"><?php echo 'Informasi Tambahan' ?></td>
            <td class="td_right"><?php echo $value[0]; ?></td>
           </tr>
           <?php
          }
         }
         ?>
         <tr>
          <td class="td_left"><b>Kesimpulan</b></td>
          <td class="td_right" style="width: 25%"><b><?php
            if ($detail7[12] == "TMK")
             echo "Tidak Memenuhi Ketentuan";
            else
             echo "Memenuhi Ketentuan";
            ?></b></td>
         </tr>
         <?php if ($d7[2] != '') { ?>
          <tr><td colspan="2">&nbsp;</td></tr>
          <tr><td colspan="2"><h2 class="small garis">Detil Pelanggaran :</h2></td></tr>
          <tr>
           <td class="td_left" colspan="2"><?php echo $d7[2]; ?></td>
          </tr>
          <tr>
           <td class="td_left" colspan="2">Jumlah Jenis Pelanggaran : <?php
            if ($d7[2] != '')
             echo count(explode(", ", $d7[2]));
            else
             echo '0';
            ?></td>
          </tr>
          <tr></tr>
         <?php } if (in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) { ?>
          <tr><td colspan="2"><h2 class="small garis">Kesimpulan Pusat :</h2></td></tr>
          <?php
          $TLSB = explode("^", $d7[5]);
          $TLSBSub = explode("^", $d7[6]);
          $tempSB = array($TLSB[1], $TLSB[2]);
          $tempSBSub = array($TLSBSub[0], $TLSBSub[1]);
          if ((trim($d7[3]) == "" && in_array('2', $this->newsession->userdata('SESS_KODE_ROLE'))) || $editTL == 'YES') {
           ?>
           <tr><td class="td_left">Verifikasi Pusat</td><td class="td_right"><select id="SB" class="stext verifikasiPusat" name="<?php echo 'SB[HASIL_PUSAT][]' ?>" title="MK/TMK" <?php if (end($detail7) == "MK" || end($detail7) == "TMK") echo 'rel="required"'; ?>><option></option><option value="MK" <?php if ($d7[3] == "MK") echo 'Selected' ?>>Memenuhi Ketentuan</option><option value="TMK" <?php if ($d7[3] == "TMK") echo 'Selected' ?>>Tidak Memenuhi Ketentuan</option></select></tr>
           <tr class="vTMK_SB" hidden><td class="td_left">Kategori Pelanggaran</td><td class="td_right"><select class="sjenis vTMKa_SB" title="Kategori Pelanggaran"><option></option><option value="Kritikal" <?php if ($TLSB[0] == "Kritikal") echo 'Selected' ?>>Kritikal</option><option value="Non Kritikal" <?php if ($TLSB[0] == "Non Kritikal") echo 'Selected' ?>>Non Kritikal</option></select></td></tr>
           <tr class="vTMK_SB" hidden><td class="td_left"style="background-color: white;">Tindak Lanjut</td><td class="td_right" style="background-color: white;"><?php echo form_dropdown('SB[HASIL_PUSAT][]', $cb_tl, trim($d7[4]) != "" ? $d7[4] : '', 'class="stext verifikasiPusatSub" id="vTMKSub_SB" title="Tindak Lanjut Pusat"'); ?></td></tr>
           <tr class="vTMK2_SB" hidden><td class="td_left"style="background-color: white;"></td><td class="td_right" style="background-color: white;"><?php echo form_dropdown('SB[TL_PUSAT][]', $cb_tindakan, is_array($tempSB) ? $tempSB : '', 'class="stext multiselect vTMK2_SB" multiple title="Saran Tindak Lanjut Pusat. Untuk memilih lebih dari satu, klik + Ctrl"'); ?></td><td colspan="2" style="background-color: white;"></td></tr>
           <tr class="vTMK2_SB" hidden><td class="td_left">Surat Tindak Lanjut</td><td class="td_right"><input type="text" class="sdate vTMK2a_SB" name="SB[DETAIL_PUSAT][]" id="tglSuratTLSB" title="Tanggal Surat Tindak Lanjut" placeholder="Tanggal Surat" onchange="comp('D')" value="<?php echo $TLSBSub[0]; ?>"/>&nbsp;&nbsp;&nbsp;Tanggal Surat Tindak Lanjut</td><td colspan="2"></td></tr>
           <tr class="vTMK2_SB" hidden><td class="td_left"></td><td class="td_right"><input type="text" class="stext vTMK2a_SB" name="SB[DETAIL_PUSAT][]" id="stugas_"  title="Di isi dengan nomor surat tindak lanjut" placeholder="Nomor Surat Tindak Lanjut" value="<?php echo $TLSBSub[1]; ?>"/>&nbsp;&nbsp;&nbsp;Nomor Surat Tindak Lanjut</td><td colspan="2"></td></tr>
           <tr class="vJustifikasi_SB" hidden><td class="td_left">Justifikasi</td><td style="padding: 5px" colspan="2"><textarea name="JUSTIFIKASI_SB" title="Justifikasi Pusat" class="stext chkJustifikasi chkJustifikasi_SB" style="height: 140px"><?php echo $d7[7]; ?></textarea></td></tr>
           <?php
          } else if (trim($d7[3]) != "") {
           ?>
           <tr><td class="td_left">Verifikasi Pusat</td><td class="td_right" colspan="2"><b><i><?php
               if ($d7[3] == "TMK")
                echo "Tidak Memenuhi Ketentuan";
               else
                echo "Memenuhi Ketentuan";
               ?></i></b></td></tr>
           <?php if (trim($TLSB[0]) != "") { ?><tr><td class="td_left">Kategori Pelanggaran</td><td class="td_right" colspan="2"><?php echo $TLSB[0]; ?></td></tr>
           <?php } if (trim($d7[4]) != "") { ?><tr><td class="td_left">Tindak Lanjut</td><td class="td_right" colspan="2"><?php if ($d7[4] == "TL") echo "Tindak Lanjut"; else if ($d7[4] == "STL") echo "Sudah Tindak Lanjut"; else if ($d7[4] == "TTL") echo "Tidak Dapat Tindak Lanjut"; ?></td></tr>
           <?php }if (trim($TLSB[1]) != "") { ?><tr><td class="td_left">Detil Tindak Lanjut Pusat</td><td class="td_right" colspan="2"><ul style="list-style-type:decimal; padding-left:20px; margin:0;"><?php
            if ($TLSB[2] != '')
             echo "<li>" . join("</li><li>", $tempSB) . "</li>";
            else
             echo "<li>" . $TLSB[1] . "</li>";
            ?></ul></td></tr>
           <?php } if (trim($TLSBSub[0]) != "") {
            ?><tr><td class="td_left">Surat Tindak Lanjut</td><td class="td_right" colspan="2"><ul style="padding-left:20px; margin:0;"><?php
               echo "<li>Tangal Surat : " . join("</li><li>Nomor Surat : ", $tempSBSub) . "</li>";
               ?></ul></td></tr>
           <?php } if (trim($d7[7]) != "") {
            ?>
            <tr><td class="td_left">Justifikasi Pusat</td><td class="td_right" colspan="2"><?php echo $d7[7]; ?></td></tr>
            <?php
           }
          }
         }
         ?>
        </table>
       </div>
       <pagebreak />
      <?php } if (end($detail3) == "MK" || end($detail3) == "TMK") {
       ?>
       <div>
        <b>Ampul/ Vial >= 10 ML</b>
        <table border="1">
         <?php
         foreach ($detailsub3 as $value) {
          if ($value[1] != "") {
           ?>
           <tr>
            <td class="td_left"><?php echo $value[1]; ?></td>
            <td class="td_right"><?php
             if ($value[0] == "-") {
              echo 'Tidak Ada';
             } else if ($value[0] == "+") {
              echo 'Ada';
             }
             ?></td>
           </tr>
           <?php
          } else if ($value[0] != "" && $value[0] != "+" && $value[0] != "-" && $value[0] != "TMK" && $value[0] != "MK") {
           ?>
           <tr>
            <td class="td_left"><?php echo 'Informasi Tambahan' ?></td>
            <td class="td_right"><?php echo $value[0]; ?></td>
           </tr>
           <?php
          }
         }
         ?>
         <tr>
          <td class="td_left"><b>Kesimpulan</b></td>
          <td class="td_right" style="width: 25%"><b><?php
            if ($detail3[18] == "TMK")
             echo "Tidak Memenuhi Ketentuan";
            else
             echo "Memenuhi Ketentuan";
            ?></b></td>
         </tr>
         <?php if ($d3[2] != '') { ?>
          <tr><td colspan="2">&nbsp;</td></tr>
          <tr><td colspan="2"><h2 class="small garis">Detil Pelanggaran :</h2></td></tr>
          <tr>
           <td class="td_left" colspan="2"><?php echo $d3[2]; ?></td>
          </tr>
          <tr>
           <td class="td_left" colspan="2">Jumlah Jenis Pelanggaran : <?php
            if ($d3[2] != '')
             echo count(explode(", ", $d3[2]));
            else
             echo '0';
            ?></td>
          </tr>
          <tr></tr>
         <?php } if (in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) { ?>
          <tr><td colspan="2"><h2 class="small garis">Kesimpulan Pusat :</h2></td></tr>
          <?php
          $TLV1 = explode("^", $d3[5]);
          $TLV1Sub = explode("^", $d3[6]);
          $tempV1 = array($TLV1[1], $TLV1[2]);
          $tempV1Sub = array($TLV1Sub[0], $TLV1Sub[1]);
          if ((trim($d3[3]) == "" && in_array('2', $this->newsession->userdata('SESS_KODE_ROLE'))) || $editTL == 'YES') {
           ?>
           <tr><td class="td_left">Verifikasi Pusat</td><td class="td_right"><select id="V1" class="stext verifikasiPusat" name="<?php echo 'V1[HASIL_PUSAT][]' ?>" title="MK/TMK" <?php if (end($detail3) == "MK" || end($detail3) == "TMK") echo 'rel="required"'; ?>><option></option><option value="MK" <?php if ($d3[3] == "MK") echo 'Selected' ?>>Memenuhi Ketentuan</option><option value="TMK" <?php if ($d3[3] == "TMK") echo 'Selected' ?>>Tidak Memenuhi Ketentuan</option></select></tr>
           <tr class="vTMK_V1" hidden><td class="td_left">Kategori Pelanggaran</td><td class="td_right"><select class="sjenis vTMKa_V1" title="Kategori Pelanggaran"><option></option><option value="Kritikal" <?php if ($TLV1[0] == "Kritikal") echo 'Selected' ?>>Kritikal</option><option value="Non Kritikal" <?php if ($TLV1[0] == "Non Kritikal") echo 'Selected' ?>>Non Kritikal</option></select></td></tr>
           <tr class="vTMK_V1" hidden><td class="td_left"style="background-color: white;">Tindak Lanjut</td><td class="td_right" style="background-color: white;"><?php echo form_dropdown('V1[HASIL_PUSAT][]', $cb_tl, trim($d3[4]) != "" ? $d3[4] : '', 'class="stext verifikasiPusatSub" id="vTMKSub_V1" title="Tindak Lanjut Pusat"'); ?></td><td colspan="4" style="background-color: white;"></td></tr>
           <tr class="vTMK2_V1" hidden><td class="td_left"style="background-color: white;"></td><td class="td_right" style="background-color: white;"><?php echo form_dropdown('V1[TL_PUSAT][]', $cb_tindakan, is_array($tempV1) ? $tempV1 : '', 'class="stext multiselect vTMK2_V1" multiple title="Saran Tindak Lanjut Pusat. Untuk memilih lebih dari satu, klik + Ctrl"'); ?></td></tr>
           <tr class="vTMK2_V1" hidden><td class="td_left">Surat Tindak Lanjut</td><td class="td_right"><input type="text" class="sdate vTMK2a_V1" name="V1[DETAIL_PUSAT][]" id="tglSuratTLV1" title="Tanggal Surat Tindak Lanjut" placeholder="Tanggal Surat" onchange="comp('D')" value="<?php echo $TLV1Sub[0]; ?>"/>&nbsp;&nbsp;&nbsp;Tanggal Surat Tindak Lanjut</td></tr>
           <tr class="vTMK2_V1" hidden><td class="td_left"></td><td class="td_right"><input type="text" class="stext vTMK2a_V1" name="V1[DETAIL_PUSAT][]" id="stugas_"  title="Di isi dengan nomor surat tindak lanjut" placeholder="Nomor Surat Tindak Lanjut" value="<?php echo $TLV1Sub[1]; ?>"/>&nbsp;&nbsp;&nbsp;Nomor Surat Tindak Lanjut</td></tr>
           <tr class="vJustifikasi_V1" hidden><td class="td_left">Justifikasi</td><td style="padding: 5px" colspan="2"><textarea name="JUSTIFIKASI_V1" title="Justifikasi Pusat" class="stext chkJustifikasi chkJustifikasi_V1" style="height: 140px"><?php echo $d3[7]; ?></textarea></td></tr>
           <?php
          } else if (trim($d3[3]) != "") {
           ?>
           <tr><td class="td_left">Verifikasi Pusat</td><td class="td_right" colspan="2"><b><i><?php
               if ($d3[2] == "TMK")
                echo "Tidak Memenuhi Ketentuan";
               else
                echo "Memenuhi Ketentuan";
               ?></i></b></td></tr>
           <?php if (trim($TLV1[0]) != "") { ?><tr><td class="td_left">Kategori Pelanggaran</td><td class="td_right" colspan="2"><?php echo $TLV1[0]; ?></td></tr>
           <?php } if (trim($d3[4]) != "") { ?><tr><td class="td_left">Tindak Lanjut</td><td></td><td class="td_right" colspan="2"><?php if ($d3[4] == "TL") echo "Tindak Lanjut"; else if ($d3[4] == "STL") echo "Sudah Tindak Lanjut"; else if ($d3[4] == "TTL") echo "Tidak Dapat Tindak Lanjut" ?></td></tr>
           <?php }if (trim($TLV1[1]) != "") { ?><tr><td class="td_left">Detil Tindak Lanjut Pusat</td><td></td><td class="td_right" colspan="2"><ul style="list-style-type:decimal; padding-left:20px; margin:0;"><?php
            if ($TLV1[2] != '')
             echo "<li>" . join("</li><li>", $tempV1) . "</li>";
            else
             echo "<li>" . $TLV1[1] . "</li>";
            ?></ul></td></tr>
           <?php } if (trim($TLV1Sub[0]) != "") {
            ?><tr><td class="td_left">Surat Tindak Lanjut</td><td class="td_right" colspan="2"><ul style="padding-left:20px; margin:0;"><?php
               echo "<li>Tangal Surat : " . join("</li><li>Nomor Surat : ", $tempV1Sub) . "</li>";
               ?></ul></td></tr>
           <?php } if (trim($d3[7]) != "") {
            ?>
            <tr><td class="td_left">Justifikasi Pusat</td><td class="td_right" colspan="2"><?php echo $d3[7]; ?></td></tr>
            <?php
           }
          }
         }
         ?>
        </table>
       </div>
       <pagebreak />
      <?php } if (end($detail4) == "MK" || end($detail4) == "TMK") {
       ?>
       <div>
        <b>Ampul/ Vial < 10 ML</b>
        <table border="1">
         <?php
         foreach ($detailsub4 as $value) {
          if ($value[1] != "") {
           ?>
           <tr>
            <td class="td_left"><?php echo $value[1]; ?></td>
            <td class="td_right"><?php
             if ($value[0] == "-") {
              echo 'Tidak Ada';
             } else if ($value[0] == "+") {
              echo 'Ada';
             }
             ?></td>
           </tr>
           <?php
          } else if ($value[0] != "" && $value[0] != "+" && $value[0] != "-" && $value[0] != "TMK" && $value[0] != "MK") {
           ?>
           <tr>
            <td class="td_left"><?php echo 'Informasi Tambahan' ?></td>
            <td class="td_right"><?php echo $value[0]; ?></td>
           </tr>
           <?php
          }
         }
         ?>
         <tr>
          <td class="td_left"><b>Kesimpulan</b></td>
          <td class="td_right" style="width: 25%"><b><?php
            if ($detail4[15] == "TMK")
             echo "Tidak Memenuhi Ketentuan";
            else
             echo "Memenuhi Ketentuan";
            ?></b></td>
         </tr>
         <?php if ($d4[2] != '') { ?>
          <tr><td colspan="2">&nbsp;</td></tr>
          <tr><td colspan="2"><h2 class="small garis">Detil Pelanggaran :</h2></td></tr>
          <tr>
           <td class="td_left" colspan="2"><?php echo $d4[2]; ?></td>
          </tr>
          <tr>
           <td class="td_left" colspan="2">Jumlah Jenis Pelanggaran : <?php
            if ($d4[2] != '')
             echo count(explode(", ", $d4[2]));
            else
             echo '0';
            ?></td>
          </tr>
          <tr></tr>
         <?php } if (in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) { ?>
          <tr><td colspan="2"><h2 class="small garis">Kesimpulan Pusat :</h2></td></tr>
          <?php
          $TLV2 = explode("^", $d4[5]);
          $TLV2Sub = explode("^", $d4[6]);
          $tempV2 = array($TLV2[1], $TLV2[2]);
          $tempV2Sub = array($TLV2Sub[0], $TLV2Sub[1]);
          if ((trim($d4[3]) == "" && in_array('2', $this->newsession->userdata('SESS_KODE_ROLE'))) || $editTL == 'YES') {
           ?>
           <tr><td class="td_left">Verifikasi Pusat</td><td class="td_right"><select id="V2" class="stext verifikasiPusat" name="<?php echo 'V2[HASIL_PUSAT][]' ?>" title="MK/TMK" <?php if (end($detail4) == "MK" || end($detail4) == "TMK") echo 'rel="required"'; ?>><option></option><option value="MK" <?php if ($d4[3] == "MK") echo 'Selected' ?>>Memenuhi Ketentuan</option><option value="TMK" <?php if ($d4[3] == "TMK") echo 'Selected' ?>>Tidak Memenuhi Ketentuan</option></select></tr>
           <tr class="vTMK_V2" hidden><td class="td_left">Kategori Pelanggaran</td><td class="td_right"><select class="sjenis vTMKa_V2" title="Kategori Pelanggaran"><option></option><option value="Kritikal" <?php if ($TLV2[0] == "Kritikal") echo 'Selected' ?>>Kritikal</option><option value="Non Kritikal" <?php if ($TLV2[0] == "Non Kritikal") echo 'Selected' ?>>Non Kritikal</option></select></td></tr>
           <tr class="vTMK_V2" hidden><td class="td_left"style="background-color: white;">Tindak Lanjut</td><td class="td_right" style="background-color: white;"><?php echo form_dropdown('V2[HASIL_PUSAT][]', $cb_tl, trim($d4[4]) != "" ? $d4[4] : '', 'class="stext verifikasiPusatSub" id="vTMKSub_V2" title="Tindak Lanjut Pusat"'); ?></td></tr>
           <tr class="vTMK2_V2" hidden><td class="td_left"style="background-color: white;"></td><td class="td_right" style="background-color: white;"><?php echo form_dropdown('V2[TL_PUSAT][]', $cb_tindakan, is_array($tempV2) ? $tempV2 : '', 'class="stext multiselect vTMK2_V2" multiple title="Saran Tindak Lanjut Pusat. Untuk memilih lebih dari satu, klik + Ctrl"'); ?></td></tr>
           <tr class="vTMK2_V2" hidden><td class="td_left">Surat Tindak Lanjut</td><td class="td_right"><input type="text" class="sdate vTMK2a_V2" name="V2[DETAIL_PUSAT][]" id="tglSuratTLV2" title="Tanggal Surat Tindak Lanjut" placeholder="Tanggal Surat" onchange="comp('D')" value="<?php echo $TLV2Sub[0]; ?>"/>&nbsp;&nbsp;&nbsp;Tanggal Surat Tindak Lanjut</td></tr>
           <tr class="vTMK2_V2" hidden><td class="td_left"></td><td class="td_right"><input type="text" class="stext vTMK2a_V2" name="V2[DETAIL_PUSAT][]" id="stugas_"  title="Di isi dengan nomor surat tindak lanjut" placeholder="Nomor Surat Tindak Lanjut" value="<?php echo $TLV2Sub[1]; ?>"/>&nbsp;&nbsp;&nbsp;Nomor Surat Tindak Lanjut</td></tr>
           <tr class="vJustifikasi_V2" hidden><td class="td_left">Justifikasi</td><td style="padding: 5px" colspan="2"><textarea name="JUSTIFIKASI_V2" title="Justifikasi Pusat" class="stext chkJustifikasi chkJustifikasi_V2" style="height: 140px"><?php echo $d4[7]; ?></textarea></td></tr>
           <?php
          } else if (trim($d4[3]) != "") {
           ?>
           <tr><td class="td_left">Verifikasi Pusat</td><td class="td_right" colspan="2"><b><i><?php
               if ($d4[2] == "TMK")
                echo "Tidak Memenuhi Ketentuan";
               else
                echo "Memenuhi Ketentuan";
               ?></i></b></td></tr>
           <?php if (trim($TLV2[0]) != "") { ?><tr><td class="td_left">Kategori Pelanggaran</td><td class="td_right" colspan="2"><?php echo $TLV2[0]; ?></td></tr>
           <?php } if (trim($d4[4]) != "") { ?><tr><td class="td_left">Tindak Lanjut</td><td class="td_right" colspan="2"><?php if ($d4[4] == "TL") echo "Tindak Lanjut"; else if ($d4[4] == "STL") echo "Sudah Tindak Lanjut"; else if ($d4[4] == "TTL") echo "Tidak Dapat Tindak Lanjut" ?></td></tr>
           <?php }if (trim($TLV2[1]) != "") { ?><tr><td class="td_left">Detil Tindak Lanjut Pusat</td><td class="td_right" colspan="2"><ul style="list-style-type:decimal; padding-left:20px; margin:0;"><?php
            if ($TLV2[2] != '')
             echo "<li>" . join("</li><li>", $tempV2) . "</li>";
            else
             echo "<li>" . $TLV2[1] . "</li>";
            ?></ul></td></tr>
           <?php } if (trim($TLV2Sub[0]) != "") {
            ?><tr><td class="td_left">Surat Tindak Lanjut</td><td class="td_right" colspan="2"><ul style="padding-left:20px; margin:0;"><?php
               echo "<li>Tangal Surat : " . join("</li><li>Nomor Surat : ", $tempV2Sub) . "</li>";
               ?></ul></td></tr>
           <?php } if (trim($d4[7]) != "") {
            ?>
            <tr><td class="td_left">Justifikasi Pusat</td><td class="td_right" colspan="2"><?php echo $d4[7]; ?></td></tr>
            <?php
           }
          }
         }
         ?>
        </table>
       </div>
       <pagebreak />
      <?php } if (end($detail5) == "MK" || end($detail5) == "TMK") {
       ?>
       <div>
        <b>Brosur</b>
        <table border="1">
         <?php
         foreach ($detailsub5 as $value) {
          if ($value[1] != "") {
           ?>
           <tr>
            <td class="td_left"><?php echo $value[1]; ?></td>
            <td class="td_right"><?php
             if ($value[0] == "-") {
              echo 'Tidak Ada';
             } else if ($value[0] == "+") {
              echo 'Ada';
             }
             ?></td>
           </tr>
           <?php
          } else if ($value[0] != "" && $value[0] != "+" && $value[0] != "-" && $value[0] != "TMK" && $value[0] != "MK") {
           ?>
           <tr>
            <td class="td_left"><?php echo 'Informasi Tambahan' ?></td>
            <td class="td_right"><?php echo $value[0]; ?></td>
           </tr>
           <?php
          }
         }
         ?>
         <tr>
          <td class="td_left">Lampiran</td>
          <td class="td_right"><?php if ($d5[0] != '') { ?><a href="<?php echo base_url(); ?>files/<?php echo 'penandaan_001/BR/'; ?>/<?php echo $d5[0]; ?>" target="_blank">Lihat Lampiran</a><?php
           } else {
            echo '-';
           }
           ?></td>
         </tr>
         <tr>
          <td class="td_left"><b>Kesimpulan</b></td>
          <td class="td_right" style="width: 25%"><b><?php
            if ($detail5[39] == "TMK")
             echo "Tidak Memenuhi Ketentuan";
            else
             echo "Memenuhi Ketentuan";
            ?></b></td>
         </tr>
         <?php if ($d5[2] != '') { ?>
          <tr><td colspan="2">&nbsp;</td></tr>
          <tr><td colspan="2"><h2 class="small garis">Detil Pelanggaran :</h2></td></tr>
          <tr>
           <td class="td_left" colspan="2"><?php echo $d5[2]; ?></td>
          </tr>
          <tr>
           <td class="td_left" colspan="2">Jumlah Jenis Pelanggaran : <?php
            if ($d5[2] != '')
             echo count(explode(", ", $d5[2]));
            else
             echo '0';
            ?></td>
          </tr>
          <tr></tr>
         <?php } if (in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) { ?>
          <tr><td colspan="2"><h2 class="small garis">Kesimpulan Pusat :</h2></td></tr>
          <?php
          $TLBR = explode("^", $d5[5]);
          $TLBRSub = explode("^", $d5[6]);
          $tempBR = array($TLBR[1], $TLBR[2]);
          $tempBRSub = array($TLBRSub[0], $TLBRSub[1]);
          if ((trim($d5[3] == "") && in_array('2', $this->newsession->userdata('SESS_KODE_ROLE'))) || $editTL == 'YES') {
           ?>
           <tr><td class="td_left">Verifikasi Pusat</td><td class="td_right"><select id="BR" class="stext verifikasiPusat" name="<?php echo 'BR[HASIL_PUSAT][]' ?>" title="MK/TMK" <?php if (end($detail5) == "MK" || end($detail5) == "TMK") echo 'rel="required"'; ?>><option></option><option value="MK" <?php if ($d5[3] == "MK") echo 'Selected' ?>>Memenuhi Ketentuan</option><option value="TMK" <?php if ($d5[3] == "TMK") echo 'Selected' ?>>Tidak Memenuhi Ketentuan</option></select></tr>
           <tr class="vTMK_BR" hidden><td class="td_left">Kategori Pelanggaran</td><td class="td_right"><select class="sjenis vTMKa_BR" title="Kategori Pelanggaran"><option></option><option value="Kritikal" <?php if ($TLBR[0] == "Kritikal") echo 'Selected' ?>>Kritikal</option><option value="Non Kritikal" <?php if ($TLBR[0] == "Non Kritikal") echo 'Selected' ?>>Non Kritikal</option></select></td></tr>
           <tr class="vTMK_BR" hidden><td class="td_left"style="background-color: white;">Tindak Lanjut</td><td class="td_right" style="background-color: white;"><?php echo form_dropdown('BR[HASIL_PUSAT][]', $cb_tl, !empty($d5[4]) ? $d5[4] : '', 'class="stext verifikasiPusatSub" id="vTMKSub_BR" title="Tindak Lanjut Pusat"'); ?></td></tr>
           <tr class="vTMK2_BR" hidden><td class="td_left"style="background-color: white;"></td><td class="td_right" style="background-color: white;"><?php echo form_dropdown('BR[TL_PUSAT][]', $cb_tindakan, is_array($tempBR) ? $tempBR : '', 'class="stext multiselect vTMK2_BR" multiple title="Saran Tindak Lanjut Pusat. Untuk memilih lebih dari satu, klik + Ctrl"'); ?></td></tr>
           <tr class="vTMK2_BR" hidden><td class="td_left">Surat Tindak Lanjut</td><td class="td_right"><input type="text" class="sdate vTMK2a_BR" name="BR[DETAIL_PUSAT][]" id="tglSuratTLBR" title="Tanggal Surat Tindak Lanjut" placeholder="Tanggal Surat" onchange="comp('D')" value="<?php echo $TLBRSub[0]; ?>"/>&nbsp;&nbsp;&nbsp;Tanggal Surat Tindak Lanjut</td></tr>
           <tr class="vTMK2_BR" hidden><td class="td_left"></td><td class="td_right"><input type="text" class="stext vTMK2a_BR" name="BR[DETAIL_PUSAT][]" id="stugas_"  title="Di isi dengan nomor surat tindak lanjut" placeholder="Nomor Surat Tindak Lanjut" value="<?php echo $TLBRSub[1]; ?>"/>&nbsp;&nbsp;&nbsp;Nomor Surat Tindak Lanjut</td></tr>
           <tr class="vJustifikasi_BR" hidden><td class="td_left">Justifikasi</td><td style="padding: 5px" colspan="2"><textarea name="JUSTIFIKASI_BR" title="Justifikasi Pusat" class="stext chkJustifikasi chkJustifikasi_BR" style="height: 140px"><?php echo $d5[7]; ?></textarea></td></tr>
           <?php
          } else if (trim($d5[3]) != "") {
           ?>
           <tr><td class="td_left">Verifikasi Pusat</td><td class="td_right" colspan="2"><b><i><?php
               if ($d5[3] == "TMK")
                echo "Tidak Memenuhi Ketentuan";
               else
                echo "Memenuhi Ketentuan"
                ?></i></b></td></tr>
           <?php if (trim($TLBR[0]) != "") { ?><tr><td class="td_left">Kategori Pelanggaran</td><td class="td_right" colspan="2"><?php echo $TLBR[0]; ?></td></tr>
           <?php } if (trim($d5[4]) != "") { ?><tr><td class="td_left">Tindak Lanjut</td><td class="td_right" colspan="2"><?php if ($d5[4] == "TL") echo "Tindak Lanjut"; else if ($d5[4] == "STL") echo "Sudah Tindak Lanjut"; else if ($d5[4] == "TTL") echo "Tidak Dapat Tindak Lanjut" ?></td></tr>
           <?php }if (trim($TLBR[1]) != "") { ?><tr><td class="td_left">Detil Tindak Lanjut Pusat</td><td class="td_right" colspan="2"><ul style="list-style-type:decimal; padding-left:20px; margin:0;"><?php
            if ($TLBR[2] != '')
             echo "<li>" . join("</li><li>", $tempBR) . "</li>";
            else
             echo "<li>" . $TLBR[1] . "</li>";
            ?></ul></td></tr>
           <?php } if (trim($TLBRSub[0]) != "") {
            ?><tr><td class="td_left">Surat Tindak Lanjut</td><td class="td_right" colspan="2"><ul style="padding-left:20px; margin:0;"><?php
               echo "<li>Tangal Surat : " . join("</li><li>Nomor Surat : ", $tempBRSub) . "</li>";
               ?></ul></td></tr>
           <?php } if (trim($d5[7]) != "") {
            ?>
            <tr><td class="td_left">Justifikasi Pusat</td><td class="td_right" colspan="2"><?php echo $d5[7]; ?></td></tr>
            <?php
           }
          }
         }
         ?>
        </table>
       </div>
       <pagebreak />
      <?php } ?>
     </div>
    </div>
   </div>
   <input type="hidden" id="kesimpulanHasilPenilaianBLVal" value="<?php echo $detail1[31]; ?>" />
   <input type="hidden" id="kesimpulanHasilPenilaianETVal" value="<?php echo $detail2[30]; ?>" />
   <input type="hidden" id="kesimpulanHasilPenilaianV1Val" value="<?php echo $detail3[18]; ?>" />
   <input type="hidden" id="kesimpulanHasilPenilaianV2Val" value="<?php echo $detail4[15]; ?>" />
   <input type="hidden" id="kesimpulanHasilPenilaianBRVal" value="<?php echo $detail5[39]; ?>" />
   <input type="hidden" id="kesimpulanHasilPenilaianASVal" value="<?php echo $detail6[31]; ?>" />
   <input type="hidden" id="kesimpulanHasilPenilaianSBVal" value="<?php echo $detail7[12]; ?>" />
   <input type="hidden" name="VALUE_BL"  value="<?php echo $d1[0] . "*" . $d1[1] . "*" . $d1[2]; ?>" />
   <input type="hidden" name="VALUE_ET" value="<?php echo $d2[0] . "*" . $d2[1] . "*" . $d2[2]; ?>" />
   <input type="hidden" name="VALUE_V1" value="<?php echo $d3[0] . "*" . $d3[1] . "*" . $d3[2]; ?>" />
   <input type="hidden" name="VALUE_V2"  value="<?php echo $d4[0] . "*" . $d4[1] . "*" . $d4[2]; ?>" />
   <input type="hidden" name="VALUE_BR" value="<?php echo $d5[0] . "*" . $d5[1] . "*" . $d5[2]; ?>" />
   <input type="hidden" name="VALUE_AS" value="<?php echo $d6[0] . "*" . $d6[1] . "*" . $d6[2]; ?>" />
   <input type="hidden" name="VALUE_SB" value="<?php echo $d7[0] . "*" . $d7[1] . "*" . $d7[2]; ?>" />
   <input type="hidden" name="PENANDAAN_ID[]" value="<?php echo $sess['PENANDAAN_ID']; ?>" />
   <input type="hidden" name="UPDATE" value="<?php echo $sess['STATUS']; ?>" />
   <input type="hidden" name="EDIT" value="<?php echo $editTL; ?>" />
   <input type="hidden" name="KOMODITI[]" value="<?php echo $sess['KOMODITI']; ?>" />
 </form>
</div>
<script type="text/javascript">
           function goBack()
           {
            window.history.back()
           }
           function verifikasiPusat(X, A) {
            if (A == 0) {
             var id = $(X).attr("id");
             var mkTMK = $("#" + id).val();
             if (mkTMK === "MK") {
              $(".vMK_" + id).show();
              $(".vMK_" + id).attr("rel", "required");
              $(".vMKa_" + id).attr("rel", "required");
              $(".vMKa_" + id).attr("name", id + "[TL_PUSAT][]");
              $(".vTMK_" + id).hide();
              $(".vTMK_" + id).attr("rel", " ");
              $(".vTMK_" + id).val("");
              $(".vTMKa_" + id).val("");
              $(".vTMKa_" + id).attr("rel", " ");
              $(".vTMKa_" + id).attr("name", " ");
              $(".vTMK2_" + id).hide("slow");
              $(".vTMK2_" + id).val("");
              $(".vTMK2_" + id).attr("rel", "");
              $(".vTMK2a_" + id).val("");
              $("#vTMKSub_" + id).attr("rel", "");
              $("#vTMKSub_" + id).val("");
             }
             else if (mkTMK === "TMK") {
              $(".vMK_" + id).hide();
              $(".vMK_" + id).attr("rel", " ");
              $(".vMK_" + id).val("");
              $(".vMKa_" + id).attr("rel", " ");
              $(".vMKa_" + id).attr("name", " ");
              $(".vMKa_" + id).val("");
              $(".vTMK_" + id).show();
              $(".vTMK_" + id).attr("rel", "required");
              $(".vTMKa_" + id).attr("rel", "required");
              $(".vTMKa_" + id).attr("name", id + "[TL_PUSAT][]");
              $("#vTMKSub_" + id).attr("rel", "required");
             }
             else {
              $(".vMK_" + id).hide();
              $(".vMK_" + id).attr("rel", " ");
              $(".vMK_" + id).val("");
              $(".vMKa_" + id).attr("rel", " ");
              $(".vMKa_" + id).attr("name", " ");
              $(".vMKa_" + id).val("");
              $(".vMK_" + id).hide();
              $(".vTMK_" + id).hide();
              $(".vTMK_" + id).hide();
              $(".vTMK_" + id).attr("rel", " ");
              $(".vTMK_" + id).val("");
              $(".vTMKa_" + id).val("");
              $(".vTMKa_" + id).attr("rel", " ");
              $(".vTMKa_" + id).attr("name", " ");
              $(".vTMK2_" + id).hide("slow");
              $(".vTMK2_" + id).val("");
              $(".vTMK2_" + id).attr("rel", "");
              $(".vTMK2a_" + id).val("");
              $("#vTMKSub_" + id).attr("rel", "");
              $("#vTMKSub_" + id).val("");
             }
             if ($(X).val() != '') {
              if ($(X).val() != $("#kesimpulanHasilPenilaian" + id + "Val").val()) {
               $(".vJustifikasi_" + id).show("slow");
               $(".chkJustifikasi_" + id).attr("rel", "required");
              } else if ($(X).val() == $("#kesimpulanHasilPenilaian" + id + "Val").val()) {
               $(".vJustifikasi_" + id).hide("slow");
               $(".chkJustifikasi_" + id).attr("rel", "");
              }
             } else {
              $(".vJustifikasi_" + id).hide("slow");
              $(".chkJustifikasi_" + id).attr("rel", "");
             }
            }
            else {
             if ($("#" + X).val() != '') {
              if ($("#" + X).val() != $("#kesimpulanHasilPenilaian" + X + "Val").val()) {
               $(".vJustifikasi_" + X).show("slow");
               $(".chkJustifikasi_" + X).attr("rel", "required");
              } else if ($("#" + X).val() == $("#kesimpulanHasilPenilaian" + X + "Val").val()) {
               $(".vJustifikasi_" + X).hide("slow");
               $(".chkJustifikasi_" + X).attr("rel", "");
              }
             } else {
              $(".vJustifikasi_" + X).hide("slow");
              $(".chkJustifikasi_" + X).attr("rel", "");
              $(".chkJustifikasi_" + X).html("");
             }
            }
           }
           function verifikasiTL(X) {
            var id = $(X).attr("id").split("_");
            if ($(X).val() == 'TL' || $(X).val() == 'STL') {
             $(".vTMK2_" + id[1]).show("slow");
             $(".vTMK2_" + id[1]).attr("rel", "required");
            } else {
             $(".vTMK2_" + id[1]).hide("slow");
             $(".vTMK2_" + id[1]).attr("rel", "");
             $(".vTMK2_" + id[1]).val("");
             $(".vTMK2a_" + id[1]).val("");
            }
           }
           $(document).ready(function() {
            $("textarea.chkJustifikasi").redactor({
             buttons: ['bold', 'italic', '|', 'unorderedlist', 'orderedlist', 'outdent', 'indent', '|', 'alignleft', 'aligncenter', 'alignright', 'justify'],
             removeStyles: false,
             cleanUp: true,
             autoformat: true
            });
            $("input.sdate").datepicker({dateFormat: "dd/mm/yy", regional: "id"});
<?php if (in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) { ?>
             $(".verifikasiPusat").each(function() {
              verifikasiPusat($(this), 0);
             });
             $(".verifikasiPusatSub").each(function() {
              verifikasiTL($(this));
             });
<?php } ?>
            $('.verifikasiPusat').change(function() {
             verifikasiPusat($(this), 0);
            });
            $(".verifikasiPusatSub").change(function() {
             verifikasiTL($(this));
            });
           });
</script>