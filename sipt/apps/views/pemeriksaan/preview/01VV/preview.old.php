<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR);?>
<link type="text/css" href="<?php echo base_url();?>css/css.css" rel="stylesheet" />
<table class="detil" width="100%">
	<tr><td colspan="2"><h2 class="small">Detil Pemeriksaan : <?php echo $judul; ?></h2></td></tr>
    <tr><td width="200">Tanggal Pemeriksaan</td><td><?php echo $sess['AWAL_PERIKSA']; ?>&nbsp;sampai dengan&nbsp;<?php echo $sess['AKHIR_PERIKSA']; ?></td></tr>
	<tr><td colspan="2"><h2 class="small">Kesimpulan dan Tindakan</h2></td></tr>  
    <tr><td>Hasil</td><td><?php echo $sess['HASIL'];?></td></tr>
    <tr><td>Saran</td><td><?php echo $sess['REKOMENDASI'];?></td></tr>
    <tr><td>Kesimpulan</td><td><?php echo $sess['KESIMPULAN'];?></td></tr>
    <tr><td>Tindakan</td><td><?php if(trim($sess["TINDAKAN"]) != ""){ ?><ul style="list-style-type:decimal; padding-left:20px; margin:0;"><?php $tindakan = explode("#", $sess['TINDAKAN']); echo "<li>".join("</li><li>", $tindakan)."</li>"; ?></ul><?php } ?></td></tr>
    <tr><td>CAPA</td><td><?php echo $sess['CAPA'];?></td></tr>
</table>
<h2 class="small">Detil Petugas Pemeriksa</h2>
<div id="detail_petugas" url="<?php echo $histori_petugas;?>"></div>

<div style="margin-top:10px; margin-bottom:10px;"><?php if($sess['STATUS'] == "60010" || $this->newsession->userdata('SESS_BBPOM_ID') == "00" || array_key_exists('5', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('6', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('9', $this->newsession->userdata('SESS_KODE_ROLE'))){ ?><a href="#" class="button comment" url="<?php echo site_url(); ?>/home/proses/<?php echo $sess['IDPERIKSA']; ?>/1" onclick="batal($(this)); return false;"><span><span class="icon"></span>&nbsp; Lihat Data Pemeriksaan &nbsp;</span></a><?php } ?></div>

<div class="riwayat"></div>
<script type="text/javascript">
$(document).ready(function(){
	$("#detail_petugas").html('Loading..');
	$("#detail_petugas").load($("#detail_petugas").attr("url"));	  
});
</script>