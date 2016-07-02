<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR);?>
<link type="text/css" href="<?php echo base_url();?>css/css.css" rel="stylesheet" />
<table class="detil" width="100%">
	<tr><td colspan="2"><h2 class="small">Detil Pemeriksaan : <?php echo $judul; ?></h2></td></tr>
    <tr><td>Sarana Bertindak Sebagai</td><td><?php echo $sess['UR_SARANA_BB'] != '' ? $sess['UR_SARANA_BB'] : '-'; ?></td></tr>
    <tr><td>Status Sarana</td><td><?php echo $sess['UR_STATUS_SARANA'] != '' ? $sess['UR_STATUS_SARANA'] : '-'; ?></td></tr>
    <tr><td width="200">Tanggal Pemeriksaan</td><td><?php echo $sess['AWAL_PERIKSA']; ?>&nbsp;sampai dengan&nbsp;<?php echo $sess['AKHIR_PERIKSA']; ?></td></tr>
    <tr><td>Tujuan Pemeriksaan</td><td><?php echo $sess['TUJUAN_PEMERIKSAAN']; ?></td></tr>
    <tr><td colspan="2"><h2 class="small">Hasil Pemeriksaan</h2></td></tr> 
    <tr><td>Jenis Produk Yang Diperiksa</td><td>
	<?php 
		if(count($produk) > 0){
			$jml = strlen(join("<br>",$produk));
			if($jml > 1)
			echo join("<br>",$produk);
			else
			echo '-';
			
		}
	?>
	</td></tr> 
    <tr><td>Hasil</td><td><?php echo $sess['UR_HASIL'] ?></td></tr>
    <?php if($sess['HASIL'] == "TMK"){ ?>
    <tr><td>Detil Hasil</td><td><?php echo $sess['CATATAN'] != '' ? $sess['CATATAN'] : '-'; ?></td></tr>
    <tr><td>Tindak Lanjut</td><td><?php echo $sess['TINDAK_LANJUT'] != '' ? $sess['TINDAK_LANJUT'] : '-'; ?></td></tr>
    <tr><td>Rekomendasi</td><td><?php echo $sess['REKOMENDASI'] != '' ? $sess['REKOMENDASI'] : '-'; ?></td></tr>
    <tr <?php echo $sess['KEBIJAKAN'] == "Kebijakan lain" ? '' : 'style="display:none"'; ?>><td>Kebijakan Lain</td><td><?php echo $sess['KEBIJAKAN']; ?></td></tr>
    <?php } ?>
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