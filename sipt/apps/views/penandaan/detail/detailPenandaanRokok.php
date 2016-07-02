<?php
if (!defined('BASEPATH'))
 exit('No direct script access allowed'); error_reporting(E_ERROR);
$d1 = explode('^', $sess['PENILAIAN1']);
$d2 = explode('^', $sess['PENILAIAN2']);
?>
<link type="text/css" href="<?php echo base_url(); ?>css/css.css" rel="stylesheet" />
<table class="detil" width="100%">
 <tr><td colspan="2"><h2 class="small">Detil Pengawasan : <?php echo $judul; ?></h2></td></tr>
 <tr><td width="200">Tanggal Pemeriksaan</td><td><?php echo $sess['TANGGAL_MULAI']; ?>&nbsp;&nbsp;sampai dengan&nbsp;&nbsp;<?php echo $sess['TANGGAL_AKHIR']; ?></td></tr>
 <tr><td>&nbsp;</td></tr>
 <tr><td colspan="2"><h2 class="small garis">MK / TMK : Pencatuman Peringatan Kesehatan</h2></td></tr>
 <tr><td>Ada / Sesuai</td><td> : &nbsp;<?php
   $arr1 = array();
   $i = 0;
   foreach ($d1 as $value) {
    $detail1 = explode('_', $value);
    if ($detail1[0] == "+") {
     $arr1[$i] = $detail1[1];
     $i++;
    }
   }
   echo join(', ', $arr1);
   ?></td></tr>
 <tr><td>Tidak Ada</td><td> : &nbsp;<?php
   $arr1 = array();
   $i = 0;
   foreach ($d1 as $value) {
    $detail1 = explode('_', $value);
    if ($detail1[0] == "-") {
     $arr1[$i] = $detail1[1];
     $i++;
    }
   }
   echo join(', ', $arr1);
   ?></td></tr>
 <tr><td>Hasil Balai</td><td> : &nbsp;<?php
   if (end($d1) == "TMK")
    echo "Tidak Memenuhi Ketentuan";
   else
    echo "Memenuhi Ketentuan";
   ?></td></tr>
 <tr><td>&nbsp;</td></tr>
 <tr><td colspan="2"><h2 class="small garis">MK / TMK : Pencatuman Informasi Kesehatan</h2></td></tr>
 <tr><td>Ada / Sesuai</td><td> : &nbsp;<?php
   $arr2 = array();
   $i = 0;
   foreach ($d2 as $value) {
    $detail2 = explode('_', $value);
    if ($detail2[0] == "+") {
     $arr2[$i] = $detail2[1];
     $i++;
    }
   }
   echo join(', ', $arr2);
   ?></td></tr>
 <tr><td>Tidak Ada</td><td> : &nbsp;<?php
   $arr2 = array();
   $i = 0;
   foreach ($d2 as $value) {
    $detail2 = explode('_', $value);
    if ($detail2[0] == "-") {
     $arr2[$i] = $detail2[1];
     $i++;
    }
   }
   echo join(', ', $arr2);
   ?></td></tr>
 <tr><td>Hasil Balai</td><td> : &nbsp;<?php
   if (end($d2) == "TMK")
    echo "Tidak Memenuhi Ketentuan";
   else
    echo "Memenuhi Ketentuan";
   ?></td></tr>
</table>
<br /><br />
<h2 class="small">Detil Petugas Pengawasan</h2>
<div id="detail_petugas" url="<?php echo $histori_petugas; ?>"></div>

<!--<div style="margin-top:10px; margin-bottom:10px;"><a href="#" class="button comment" url="<?php echo $act; ?>" onclick="batal($(this));
  return false;"><span><span class="icon"></span>&nbsp; <?php echo $tombol; ?> &nbsp;</span></a></div>-->
<!--<div class="riwayat"></div>-->
<script type="text/javascript">
 $(document).ready(function() {
  $("#detail_petugas").html('Loading..');
  $("#detail_petugas").load($("#detail_petugas").attr("url"));
 });
</script>