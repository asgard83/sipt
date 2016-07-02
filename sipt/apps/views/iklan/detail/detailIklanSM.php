<?php
if (!defined('BASEPATH'))
 exit('No direct script access allowed'); error_reporting(E_ERROR);
$UP = explode('#', $sess['URAIAN_PELANGGARAN']);
?>
<link type="text/css" href="<?php echo base_url(); ?>css/css.css" rel="stylesheet" />
<table class="detil" width="100%">
 <tr><td colspan="2"><h2 class="small">Detil Pengawasan : <?php echo $judul; ?></h2></td></tr>
 <tr><td width="200">Tanggal Pemeriksaan</td><td><?php echo $sess['TANGGAL_MULAI']; ?>&nbsp;&nbsp;sampai dengan&nbsp;&nbsp;<?php echo $sess['TANGGAL_AKHIR']; ?></td></tr>
 <tr><td>&nbsp;</td></tr>
 <?php if (array_filter($UP)) { ?>
  <tr><td colspan="3"><h2 class="small garis">Uraian Pelanggaran : </h2><span id="uraianP">
     <?php
     $arrUraianSm = $this->config->item("uraian_iklan_smpk");
     foreach ($UP as $value) {
      if (trim($value) != "")
       echo $arrUraianSm[$value];
     }
     ?></span></td></tr><?php } ?>
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
  $("#detail_petugas").html('Loading..');
  $("#detail_petugas").load($("#detail_petugas").attr("url"));
 });
</script>