<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR); ?>
<link type="text/css" href="<?php echo base_url();?>css/css.css" rel="stylesheet" />
<table class="detil" width="100%">
	<tr><td colspan="2"><h2 class="small">Detil Pemeriksaan : <?php echo $judul; ?></h2></td></tr>
    <tr><td width="200">Tanggal Pemeriksaan</td><td><?php echo $sess['AWAL_PERIKSA']; ?>&nbsp;sampai dengan&nbsp;<?php echo $sess['AKHIR_PERIKSA']; ?></td></tr>
    <tr><td>Tujuan Pemeriksaan</td><td><?php echo $sess['TUJUAN_PEMERIKSAAN']; ?></td></tr>
    <tr><td>Hasil Pemeriksaan</td><td><?php echo $sess['URAIAN']; ?></td></tr>
    <?php
	if($sess['TUJUAN_PEMERIKSAAN'] == "Rutin"){
	?>    <tr><td>Hasil Temuan</td><td><?php if(strlen($sess['HASIL_TEMUAN']) > 0){ ?><ul style="list-style-type:decimal; padding-left:15px; margin:0;"><?php $hasil_temuan = explode("___", $sess['HASIL_TEMUAN']); echo "<li>".join("</li><li>", $hasil_temuan)."</li>"; ?></ul><?php } else { echo "-"; } ?></td></tr><tr><td>Jumlah Pelanggaran Minor</td><td><?php echo $sess['MINOR']; ?></td></tr>
    <tr><td>Jumlah Pelanggaran Major</td><td><?php echo $sess['MAJOR']; ?></td></tr>
    <tr><td>Jumlah Pelanggaran Critical</td><td><?php echo $sess['CRITICAL']; ?></td></tr>
    <?php
	}else if($sess['TUJUAN_PEMERIKSAAN'] == "Kasus"){
	?>    
  <tr>
    <td>A. Profil Sarana dan Organisasi</td>
    <td><?php echo preg_replace('/[^(\x20-\x7F)]*/','',html_entity_decode($sess['KASUS_POINT_A'])); ?></td>
  </tr>
  <tr>
    <td>B. Personalia</td>
    <td><?php echo preg_replace('/[^(\x20-\x7F)]*/','',html_entity_decode($sess['KASUS_POINT_B'])); ?></td>
  </tr>
  <tr>
    <td>C. Gudang dan Perlengkapan</td>
    <td><?php echo preg_replace('/[^(\x20-\x7F)]*/','',html_entity_decode($sess['KASUS_POINT_C'])); ?></td>
  </tr>
  <tr>
    <td>D. Pengadaan</td>
    <td><?php echo preg_replace('/[^(\x20-\x7F)]*/','',html_entity_decode($sess['KASUS_POINT_D'])); ?></td>
  </tr>
  <tr>
    <td>E. Penyimpanan</td>
    <td><?php echo preg_replace('/[^(\x20-\x7F)]*/','',html_entity_decode($sess['KASUS_POINT_E'])); ?></td>
  </tr>
  <tr>
    <td>F. Pendistribusian</td>
    <td><?php echo preg_replace('/[^(\x20-\x7F)]*/','',html_entity_decode($sess['KASUS_POINT_F'])); ?></td>
  </tr>
  <tr>
    <td>G. Dokumentasi</td>
    <td><?php echo preg_replace('/[^(\x20-\x7F)]*/','',html_entity_decode($sess['KASUS_POINT_H'])); ?></td>
  </tr>
  <tr>
    <td>H. Lain-lain</td>
    <td><?php echo preg_replace('/[^(\x20-\x7F)]*/','',html_entity_decode($sess['KASUS_POINT_I'])); ?></td>
  </tr>
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