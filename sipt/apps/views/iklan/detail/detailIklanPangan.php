<?php if (!defined('BASEPATH'))
  exit('No direct script access allowed'); error_reporting(E_ERROR);
$UP = explode('^', $sess['URAIAN_PELANGGARAN']);
?>
<link type="text/css" href="<?php echo base_url(); ?>css/css.css" rel="stylesheet" />
<table class="detil" width="100%">
  <tr><td colspan="2"><h2 class="small">Detil Pengawasan : <?php echo $judul. " &raquo; " . $sess['JENIS']; ?></h2></td></tr>
  <tr><td width="200">Tanggal Pemeriksaan</td><td><?php echo $sess['TANGGAL_MULAI']; ?>&nbsp;&nbsp;sampai dengan&nbsp;&nbsp;<?php echo $sess['TANGGAL_AKHIR']; ?></td></tr>
  <tr><td>&nbsp;</td></tr>
        <?php if (array_filter($UP)) { ?>
    <tr><td colspan="3"><h2 class="small garis">Uraian Pelanggaran : </h2><span id="uraianP">
          <?php
          if ($UP[0] != '') {
            echo 'Tidak memiliki izin edar, ';
          } if ($UP[1] != '') {
            echo 'Seolah-olah sebagai obat / mengobati, ';
          } if ($UP[2] != '') {
            echo 'Peragaan tenaga kesehatan, ';
          } if ($UP[3] != '') {
            echo 'Rekomendasi laboratorium/tenaga kesehatan, ';
          } if ($UP[4] != '') {
            echo 'Tidak etis / tidak sesuai norma susila, ';
          } if ($UP[5] != '') {
            echo 'Berlebihan / menyesatkan, ';
          } if ($UP[6] != '') {
            echo 'Tidak mencantumkan spot (untuk iklan yang wajib mencantumkan spot iklan), ';
          } if ($UP[7] != '') {
            echo 'Iklan yang mempengaruhi fungsi fisiologis dan atau metabolisme tubuh, ';
          } if ($UP[8] != '') {
            echo 'Slogan, ikon atau logo tidak sesuai, ';
          } if ($UP[9] != '') {
            echo 'Testimoni, ';
          } if ($UP[10] != '') {
            echo 'Tidak mencantumkan peringatan / perhatian, ';
          } if ($UP[11] != '') {
            echo 'Tidak menyebutkan keterangan jelas terkait hadiah, ';
          } if ($UP[12] != '') {
            echo 'Tidak sesuai dengan klaim yang disetujui pada label, ';
          } if ($UP[13] != '') {
            echo 'Disiarkan di media massa atau kegiatan tertentu, ';
          } if ($UP[14] != '') {
            echo 'Kadar etanol lebih dari 1% (v/v), ';
          } if ($UP[15] != '') {
            echo 'Mencantumkan logo dan atau simbol keagamaan yang dianggap suci, ';
          } if ($UP[16] != '') {
            echo 'Mengiklankan kata halal, ';
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
<?php if ($sess['HASIL'] != $sess['HASIL_PUSAT']  && $sess['HASIL_PUSAT'] != NULL) { ?><tr><td><b>Justifikasi Pusat</b></td><td><?php echo $sess['JUSTIFIKASI_PUSAT']; ?></td></tr><?php } ?>
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