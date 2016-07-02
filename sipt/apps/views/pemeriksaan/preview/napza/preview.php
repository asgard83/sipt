<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR);?>
<link type="text/css" href="<?php echo base_url();?>css/css.css" rel="stylesheet" />
<table class="detil" width="100%">
	<tr><td colspan="2"><h2 class="small">Detil Pemeriksaan :<?php echo $judul; ?></h2></td></tr>
    <tr><td width="200">Tanggal Pemeriksaan</td><td><?php echo $sess['AWAL_PERIKSA']; ?>&nbsp;sampai dengan&nbsp;<?php echo $sess['AKHIR_PERIKSA']; ?></td></tr>
    <tr><td>Tujuan Pemeriksaan</td><td><?php echo $sess['TUJUAN_PEMERIKSAAN']; ?></td></tr>
    <tr><td valign="top">Dasar Pemeriksaan</td><td><?php echo $sess['DASAR_PEMERIKSAAN']; ?></td></tr>
	<tr><td colspan="2"><h2 class="small">Tindakan Balai</h2></td></tr>  
    <tr><td>Unit / Balai Yang Melakukan Tindakan</td><td><?php echo $sess['UNIT_BALAI'];?></td></tr>
    <tr><td>Tanggal Tindakan</td><td><?php echo $sess['TANGGAL_TINDAKAN_BALAI']; ?></td></tr>
    <tr><td>File BAP</td><td><?php if(trim($sess['FILE_BAP']) != ""){?><a href="<?php echo base_url(); ?>files/<?php echo $sess['SARANA_ID']; ?>/<?php echo $sess['FILE_BAP']; ?>">View</a><?php } ?></td></tr>
    <tr><td>File Lampiran BAP</td><td><?php if(trim($sess['FILE_LAMPIRAN_BAP']) != ""){?><a href="<?php echo base_url(); ?>files/<?php echo $sess['SARANA_ID']; ?>/<?php echo $sess['FILE_LAMPIRAN_BAP']; ?>">View</a><?php } ?></td></tr>
    <tr><td>File Tindak Lanjut Balai</td><td><?php if(trim($sess['FILE_TL_BALAI']) != ""){?><a href="<?php echo base_url(); ?>files/<?php echo $sess['SARANA_ID']; ?>/<?php echo $sess['FILE_TL_BALAI']; ?>">View</a><?php } ?></td></tr>
    <?php
	if($this->newsession->userdata('SESS_BBPOM_ID') == "00"){
		?>
        <tr><td colspan="2"><h2 class="small">Tindakan Pusat</h2></td></tr>
        <tr><td>Unit Pusat Yang Melakukan Tindakan</td><td><?php echo $sess['UNIT_PUSAT'];?></td></tr>
        <tr><td>Tanggal Tindakan</td><td><?php echo $sess['TANGGAL_TINDAKAN_PUSAT']; ?></td></tr>
        <tr><td>File Tindak Lanjut</td><td><?php if(trim($sess['FILE_TINDAK_LANJUT']) != ""){?><a href="<?php echo base_url(); ?>files/<?php echo $sess['SARANA_ID']; ?>/<?php echo $sess['FILE_TINDAK_LANJUT']; ?>">View</a><?php } ?></td></tr>
        <?php
	}
	?>
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