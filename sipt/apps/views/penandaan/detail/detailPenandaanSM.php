<?php
if (!defined('BASEPATH'))
  exit('No direct script access allowed'); error_reporting(E_ERROR);
$d1BL = explode('^', $sess['URAIANBL']);
$d2BL = explode('#', $sess['PENILAIANBL']);
$d1KP = explode('^', $sess['URAIANKP']);
$d2KP = explode('#', $sess['PENILAIANKP']);
$d3 = explode('*', $sess['PUSAT']);
$justifikasi = preg_replace('/(?:<|&lt;)\/?([a-zA-Z]+) *[^<\/]*?(?:>|&gt;)/', '', $d3[2]) . "\n";
?>
<!--<link type="text/css" href="<?php echo base_url(); ?>css/css.css" rel="stylesheet" />-->
<table width="100%" class="detil">
  <tr><td colspan="2"><h2 class="small">Detil Pengawasan : <?php echo $judul; ?></h2></td></tr>
  <tr><td style="width: 15%">Tanggal Pemeriksaan</td><td><?php echo $sess['TANGGAL_MULAI']; ?>&nbsp;&nbsp;sampai dengan&nbsp;&nbsp;<?php echo $sess['TANGGAL_AKHIR']; ?></td></tr>
  <tr><td><h2 class="small garis">MK / TMK : </h2></td><td><h2 class="small garis">Bungkus Luar</h2></td><td></td><td><h2 class="small garis">Kemasan Primer</h2></td></tr>
  <tr><td>Ada / Sesuai</td><td> : &nbsp;<?php
      $arr2 = array();
      $i = 0;
      foreach ($d2BL as $value) {
        $detail2 = explode('_', $value);
        if ($detail2[0] == "+") {
          $arr2[$i] = $detail2[1];
          $i++;
        }
      }
      if (trim(join('', $arr2)) != "")
        echo join(', ', $arr2);
      else
        echo "-";
      ?></td>
    <td></td>
    <td> : &nbsp;<?php
      $arr2 = array();
      $i = 0;
      foreach ($d2KP as $value) {
        $detail2 = explode('_', $value);
        if ($detail2[0] == "+") {
          $arr2[$i] = $detail2[1];
          $i++;
        }
      }
      if (trim(join('', $arr2)) != "")
        echo join(', ', $arr2);
      else
        echo "-";
      ?></td></tr>
  <tr><td>Tidak Sesuai</td><td> : &nbsp;<?php
      $arr2 = array();
      $i = 0;
      foreach ($d2BL as $value) {
        $detail2 = explode('_', $value);
        if ($detail2[0] == "X") {
          $arr2[$i] = $detail2[1];
          $i++;
        }
      }
      if (trim(join('', $arr2)) != "")
        echo join(', ', $arr2);
      else
        echo "-";
      ?></td>
    <td></td>
    <td> : &nbsp;<?php
      $arr2 = array();
      $i = 0;
      foreach ($d2KP as $value) {
        $detail2 = explode('_', $value);
        if ($detail2[0] == "X") {
          $arr2[$i] = $detail2[1];
          $i++;
        }
      }
      if (trim(join('', $arr2)) != "")
        echo join(', ', $arr2);
      else
        echo "-";
      ?></td>
  </tr>
  <tr><td>Tidak Ada</td><td> : &nbsp;<?php
      $arr2 = array();
      $i = 0;
      foreach ($d2BL as $value) {
        $detail2 = explode('_', $value);
        if ($detail2[0] == "-") {
          $arr2[$i] = $detail2[1];
          $i++;
        }
      }
      if (trim(join('', $arr2)) != "")
        echo join(', ', $arr2);
      else
        echo "-";
      ?></td>
    <td></td>
    <td> : &nbsp;<?php
      $arr2 = array();
      $i = 0;
      foreach ($d2KP as $value) {
        $detail2 = explode('_', $value);
        if ($detail2[0] == "-") {
          $arr2[$i] = $detail2[1];
          $i++;
        }
      }
      if (trim(join('', $arr2)) != "")
        echo join(', ', $arr2);
      else
        echo "-";
      ?></td></tr>
  <tr><td>Hasil Balai</td><td> : &nbsp;<?php
  if ($sess["SISTEM"] == "TMK")
    echo "Tidak Memenuhi Ketentuan";
  else
    echo "Memenuhi Ketentuan";
  ?></td></tr>
<?php if (trim($d3[0]) != "") { ?>
    <tr><td>Hasil Pusat</td><td> : &nbsp;<?php
  if ($d3[0] == "TMK")
    echo "Tidak Memenuhi Ketentuan";
  else
    echo "Memenuhi Ketentuan";
  ?></td></tr>
    <tr><td>Justifikasi Pusat</td><td> : &nbsp;<?php
  if ($d3[2] != "")
    echo "<b>" . $justifikasi . "</b>";
  else
    echo "-";
  ?></td></tr>
<?php } ?>
</table>
<br />
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