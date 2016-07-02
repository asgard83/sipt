<?php
if (!defined('BASEPATH'))
  exit('No direct script access allowed'); error_reporting(E_ERROR);
$penilaian = explode('#', $sess['PENILAIAN']);
$jenis = $sess["JENIS"];
if($jenis == "CT")
  $jenis = "Cetak";
else if($jenis == "RD")
  $jenis = "Radio";
else if($jenis == "TV")
  $jenis = "Tv";
else if($jenis == "TI")
  $jenis = "Teknologi Informasi Lainnya";
else if($jenis == "LR")
  $jenis = "Luar Ruang";
?>
<link type="text/css" href="<?php echo base_url(); ?>css/css.css" rel="stylesheet" />
<table class="detil" width="100%">
  <tr><td colspan="2"><h2 class="small">Detil Pengawasan : <?php echo $judul; ?></h2></td></tr>
  <tr><td width="200">Tanggal Pemeriksaan</td><td><?php echo $sess['TANGGAL_MULAI']; ?>&nbsp;&nbsp;sampai dengan&nbsp;&nbsp;<?php echo $sess['TANGGAL_AKHIR']; ?></td></tr>
  <tr><td>&nbsp;</td></tr>
  <tr>
    <td class="td_left">Jenis Iklan</td>
    <td><b><?php echo $sess['KELOMPOK_IKLAN']." &raquo ".$jenis; ?></b></td>
  </tr>
  <?php if (array_filter($penilaian)) { ?>
    <tr>
      <td colspan="3"><h2 class="small garis">Uraian Penilaian : </h2></td>
    </tr>
    <tr>
      <td></td>
      <td class="td_left">Sesuai </td>
      <td class="td_left">&raquo;&raquo;</td>
      <td class="td_left">
        <?php
        foreach ($penilaian as $value) {
         $val = explode("_", $value);
         if ($val[0] == "+")
          echo "- " . $val[1] . "<b>;</b> ";
        }
        ?></td>
      <td></td>
     </tr>
     <tr>
      <td></td>
      <td class="td_left">Tidak Sesuai </td>
      <td class="td_left">&raquo;&raquo;</td>
      <td class="td_left">
        <?php
        foreach ($penilaian as $value) {
         $val = explode("_", $value);
         if ($val[0] == "-")
          echo "- " . $val[1] . "<b>;</b> ";
        }
        ?></td>
      <td></td>
     </tr>
     <tr>
      <td></td>
      <td class="td_left">Lengkap</td>
      <td class="td_left">&raquo;&raquo;</td>
      <td class="td_left">
        <?php
        foreach ($penilaian as $value) {
         $val = explode("_", $value);
         if ($val[0] == "y")
          echo "- " . $val[1] . "<b>;</b> ";
        }
        ?></td>
      <td></td>
     </tr>
     <tr>
      <td></td>
      <td class="td_left">Tidak Lengkap </td>
      <td class="td_left">&raquo;&raquo;</td>
      <td class="td_left">
        <?php
        foreach ($penilaian as $value) {
         $val = explode("_", $value);
         if ($val[0] == "x")
          echo "- " . $val[1] . "<b>;</b> ";
        }
        ?></td>
      <td></td>
     </tr>
  <?php } ?>
  <tr><td>&nbsp;</td></tr>
  <tr><td><b>Hasil Pengawasan</b></td><td><?php
      if ($sess['HASIL'] == 'MK')
        echo 'Memenuhi Ketentuan';
      else
        echo 'Tidak Memenuhi Ketentuan';
      ?></td></tr>
  <tr><td>&nbsp;</td></tr>
  <?php if ($sess['HASIL'] != $sess['HASIL_PUSAT'] && $sess['HASIL_PUSAT'] != NULL) { ?><tr><td><b>Justifikasi Pusat</b></td><td><?php echo $sess['JUSTIFIKASI_PUSAT']; ?></td></tr><?php } ?>
</table>
<br /><br />
<h2 class="small">Detil Petugas Pengawasan</h2>
<div id="detail_petugas" url="<?php echo $histori_petugas; ?>"></div>

<div class="riwayat"></div>
<script type="text/javascript">
  $(document).ready(function() {
    var a = $("#uraianP").text().slice(0, -2);
    $("#uraianP").text(a);
    $("#detail_petugas").html('Loading..');
    $("#detail_petugas").load($("#detail_petugas").attr("url"));
  });
</script>