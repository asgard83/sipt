<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR); ?>
<link type="text/css" href="<?php echo base_url();?>css/css.css" rel="stylesheet" />
<table class="detil" width="100%">
	<tr><td colspan="2"><h2 class="small">Detil Pemeriksaan : <?php echo $judul; ?></h2></td></tr>
    <tr><td width="200">Tanggal Pemeriksaan</td><td><?php echo $sess['AWAL_PERIKSA']; ?>&nbsp;sampai dengan&nbsp;<?php echo $sess['AKHIR_PERIKSA']; ?></td></tr>
    <tr><td>Kepatuhan CPOTB & Keputusan</td><td><?php echo preg_replace('/[^(\x20-\x7F)]*/','',html_entity_decode($sess['KEPATUHAN_CPOTB'])); ?></td></tr>
    <tr><td>Latar Belakang Pemeriksaan</td><td><?php echo preg_replace('/[^(\x20-\x7F)]*/','',html_entity_decode($sess['LATAR_BELAKANG'])); ?></td></tr>
    <tr><td>Perubahan Bermakna</td><td><?php echo preg_replace('/[^(\x20-\x7F)]*/','',html_entity_decode($sess['PERUBAHAN_BERMAKNA'])); ?></td></tr>
    <tr><td>Ruang Lingkup</td><td><?php echo preg_replace('/[^(\x20-\x7F)]*/','',html_entity_decode($sess['RUANG_LINGKUP'])); ?></td></tr>
    <tr><td>Area Inspeksi</td><td><?php echo preg_replace('/[^(\x20-\x7F)]*/','',html_entity_decode($sess['AREA_INSPEKSI'])); ?></td></tr>
    <tr><td colspan="2"><h2 class="small">Temuan Observasi</h2></td></tr>
    <tr><td colspan="2">
    <?php
	if(count($observasi) > 0){
		?>
        <li style="list-style:none;">
        <?php 
		$current_observasi = "";
		for($i=0; $i<count($observasi); $i++){
			?>
            <div style="font-size:11px;"><b>
            <?php
			if($observasi[$i]['URAIAN'] != $current_observasi){
				echo $observasi[$i]['URAIAN'];
			}
			$current_observasi = $observasi[$i]['URAIAN'];
			?>
            </b></div>
            <div style="text-align:justify; margin-left:20px; font-size:11px;"><?php echo preg_replace('/[^(\x20-\x7F)]*/','',html_entity_decode($observasi[$i]['TEMUAN_TEKS'])); ?></div>
            <div style="text-align:justify; margin-left:20px; font-size:11px;">Kriteria : <?php echo $observasi[$i]['TEMUAN_KRITERIA']; ?></div>
            <?php
		}
		?>
        </li>
        <?php
	}
	?>
    </td></tr>
    <tr><td colspan="2"><h2 class="small">Hasil Pemeriksaan</h2></td></tr>  
    <tr><td>Jumlah Temuan Kritikal</td><td><?php echo $sess['TEMUAN_KRITIKAL'] ?></td></tr>
    <tr><td>Jumlah Temuan Major</td><td><?php echo $sess['TEMUAN_MAJOR'] ?></td></tr>
    <tr><td>Jumlah Temuan Minor</td><td><?php echo $sess['TEMUAN_MINOR'] ?></td></tr>
    <tr><td>Hasil</td><td><?php echo $sess['HASIL'] ?></td></tr>
    <?php if($sess['HASIL'] == "TMK"){ ?>
    <tr><td>Detil Hasil</td><td>
    <?php if(trim($sess['DETIL_HASIL'])!=""){?>
    <ul style="list-style-type:decimal; padding-left:15px; margin:0;"><?php $detil_hasil = explode("#", $sess['DETIL_HASIL']); echo "<li>".join("</li><li>", $detil_hasil)."</li>"; ?></ul>
    <?php } ?></td></tr>
    <tr><td>Keterangan Detil Hasil TMK</td><td><?php echo preg_replace('/[^(\x20-\x7F)]*/', "",html_entity_decode($sess['KESIMPULAN_DETIL_TMK'])); ?></td></tr>
    <?php }else{ ?>
    <tr><td>Catatan</td><td><?php echo preg_replace('/[^(\x20-\x7F)]*/', "",html_entity_decode($sess['REKOMENDASI'])); ?></td></tr>
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