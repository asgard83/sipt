<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR);?>
<link type="text/css" href="<?php echo base_url();?>css/css.css" rel="stylesheet" />
<table class="detil" width="100%">
  <tr>
    <td colspan="2"><h2 class="small">Detil Pemeriksaan : <?php echo $judul; ?></h2></td>
  </tr>
  <tr>
    <td width="200">Tanggal Pemeriksaan</td>
    <td><?php echo $sess['AWAL_PERIKSA']; ?>&nbsp;sampai dengan&nbsp;<?php echo $sess['AKHIR_PERIKSA']; ?></td>
  </tr>
  <tr>
    <td width="200">Tujuan Pemeriksaan</td>
    <td><?php echo $sess['TUJUAN_PEMERIKSAAN']; ?></td>
  </tr>
  <?php /*?><tr>
    <td width="200">Petugas Pengawas Kabupaten / Kota</td>
    <td><?php echo $sess['PENGAWAS']; ?></td>
  </tr><?php */?>
  <tr>
    <td colspan="2"><h2 class="small">Ketidaksesuaian</h2></td>
  </tr>
  <tr>
    <td>Jumlah Kritis</td>
    <td><?php echo $sess['JML_KRITIS'];?></td>
  </tr>
  <tr>
    <td>Jumlah Serius</td>
    <td><?php echo $sess['JML_SERIUS'];?></td>
  </tr>
  <tr>
    <td>Jumlah Major</td>
    <td><?php echo $sess['JML_MAJOR'];?></td>
  </tr>
  <tr>
    <td>Jumlah Minor</td>
    <td><?php echo $sess['JML_MINOR'];?></td>
  </tr>
  <tr>
    <td>Level IRTP</td>
    <td><?php echo $sess['LEVEL_IRTP'];?></td>
  </tr>
</table>
<h2 class="small garis">Rincian Ketidaksesuaian</h2>
<table class="listtemuan" width="100%">
  <thead>
    <tr>
      <th width="500">Ketidaksesuaian</th>
      <th width="75">Kriteria</th>
      <th width="300">Timeline</th>
    </tr>
  </thead>
  <tbody id="draft-penilaian">
    <?php
	$jml = count($rincian_ketidaksesuaian);
	if($jml > 0){
		for($i = 0; $i < $jml; $i++){
		  ?>
    <tr id="<?php echo $rincian_ketidaksesuaian[$i]; ?>">
      <td width="500"><?php echo $rincian_ketidaksesuaian[$i]; ?></td>
      <td width="70"><?php echo $rincian_kriteria[$i]; ?></td>
      <td><?php echo $rincian_timeline[$i]; ?></td>
    </tr>
    <?php
		}
	}
	?>
  </tbody>
</table>
<div style="height:5px;">&nbsp;</div>
<h2 class="small">Detil Petugas Pemeriksa</h2>
<div id="detail_petugas" url="<?php echo $histori_petugas;?>"></div>
<div style="margin-top:10px; margin-bottom:10px;">
  <?php if($sess['STATUS'] == "60010" || $this->newsession->userdata('SESS_BBPOM_ID') == "00" || array_key_exists('5', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('6', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('9', $this->newsession->userdata('SESS_KODE_ROLE'))){ ?>
  <a href="#" class="button comment" url="<?php echo site_url(); ?>/home/proses/<?php echo $sess['IDPERIKSA']; ?>/1" onclick="batal($(this)); return false;"><span><span class="icon"></span>&nbsp; Lihat Data Pemeriksaan &nbsp;</span></a>
  <?php } ?>
</div>
<div class="riwayat"></div>
<script type="text/javascript">
$(document).ready(function(){
	$("#detail_petugas").html('Loading..');
	$("#detail_petugas").load($("#detail_petugas").attr("url"));	  
});
</script>