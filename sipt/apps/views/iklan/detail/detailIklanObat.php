<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed'); error_reporting(E_ERROR);
$UP = explode('^', $sess['URAIAN_PELANGGARAN']);
?>
<link type="text/css" href="<?php echo base_url(); ?>css/css.css" rel="stylesheet" />
<table class="detil" width="100%">
    <tr><td colspan="3"><h2 class="small">Detil Pengawasan : <?php echo $judul . " - " . $sess['KELOMPOK_IKLAN']; ?></h2></td></tr>
    <tr><td width="200">Tanggal Pemeriksaan</td><td><?php echo $sess['TANGGAL_MULAI']; ?>&nbsp;&nbsp;sampai dengan&nbsp;&nbsp;<?php echo $sess['TANGGAL_AKHIR']; ?></td></tr>
    <tr><td>&nbsp;</td></tr>
    <tr><td colspan="3"><h2 class="small garis">Uraian Pelanggaran : </h2><span id="uraianP">
                <?php
                if ($UP[0] != '') {
                    echo 'Tidak Lengkap, ';
                } if ($UP[1] != '') {
                    echo 'Tidak Obyektif, ';
                } if ($UP[2] != '') {
                    echo 'Klaim Berlebihan, ';
                } if ($UP[3] != '') {
                    echo 'Testimoni, ';
                } if ($UP[4] != '') {
                    echo 'Pemberian Hadiah, ';
                } if ($UP[5] != '') {
                    echo 'Profesi Kesehatan, ';
                } if ($UP[6] != '') {
                    echo 'Tidak Sesuai Norma, ';
                } if ($UP[7] != '') {
                    echo 'Ditujukan Untuk Umum, ';
                } if ($UP[0] == '' && $UP[1] == '' && $UP[2] == '' && $UP[3] == '' && $UP[4] == '' && $UP[5] == '' && $UP[6] == '' && $UP[7] == '') {
                    echo '---';
                }
                ?></span></td></tr>
    <tr><td>&nbsp;</td></tr>
    <tr><td><b>Verifikasi SIAMI</b></td><td colspan="3"><?php echo $sess['VERIFIKASI_SIAMI']; ?></td></tr>
    <tr><td>&nbsp;</td></tr>
    <tr><td><b>Hasil Pengawasan</b></td><td><?php
            if ($sess['HASIL'] == 'MK')
                echo 'Memenuhi Ketentuan';
            else
                echo 'Tidak Memenuhi Ketentuan';
            ?></td></tr>
    <tr><td>&nbsp;</td></tr>
    <?php if ($sess['HASIL'] != $sess['HASIL_PUSAT'] && $sess['HASIL_PUSAT'] != NULL) { ?><tr><td><b>Justifikasi Pusat</b></td><td><?php echo preg_replace('/(?:<|&lt;)\/?([a-zA-Z]+) *[^<\/]*?(?:>|&gt;)/', '', $sess['JUSTIFIKASI_PUSAT']) . "\n"; ?></td></tr><?php } ?>
</table>
<br /><br />
<h2 class="small">Detil Petugas Pengawasan</h2>
<div id="detail_petugas" url="<?php echo $histori_petugas; ?>"></div>
<?php if ($yesBtn == "YES") { ?><div style="margin-top:10px; margin-bottom:10px;"><a href="#" class="button comment" url="<?php echo $act; ?>" onclick="batal($(this));
          return false;"><span><span class="icon"></span>&nbsp; <?php echo $tombol; ?> &nbsp;</span></a></div><?php } ?>
<script type="text/javascript">
    $(document).ready(function() {
        var a = $("#uraianP").text().slice(0, -2);
        $("#uraianP").text(a);
        $("#detail_petugas").html('Loading..');
        $("#detail_petugas").load($("#detail_petugas").attr("url"));
    });
</script>