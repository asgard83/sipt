<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR);?>
<link type="text/css" href="<?php echo base_url();?>css/css.css" rel="stylesheet"/>
<table class="form_tabel" width="100%">
  <tr>
    <td colspan="2"><h2 class="small" style="font-weight: bold; padding-bottom: 2px; font-size: 11px; color:#3c7faf;">Detil Pemeriksaan : <?php echo $judul; ?></h2></td>
  </tr>
  <tr>
    <td width="200" class="td_left">Tanggal Pemeriksaan</td>
    <td class="td_right"><?php echo $sess['AWAL_PERIKSA']; ?>&nbsp;sampai dengan&nbsp;<?php echo $sess['AKHIR_PERIKSA']; ?></td>
  </tr>
  <tr>
    <td width="200" class="td_left">Tujuan Pemeriksaan</td>
    <td class="td_right"><?php echo $sess['TUJUAN_PEMERIKSAAN']; ?></td>
  </tr>
  <tr>
    <td colspan="2"><h2 class="small" style="font-weight: bold; padding-bottom: 2px; font-size: 11px; color:#3c7faf;">Ketidaksesuaian</h2></td>
  </tr>
  <tr>
    <td class="td_left">Jumlah Kritis</td>
    <td class="td_right"><?php echo $sess['JML_KRITIS'];?></td>
  </tr>
  <tr>
    <td class="td_left">Jumlah Serius</td>
    <td class="td_right"><?php echo $sess['JML_SERIUS'];?></td>
  </tr>
  <tr>
    <td class="td_left">Jumlah Major</td>
    <td class="td_right"><?php echo $sess['JML_MAJOR'];?></td>
  </tr>
  <tr>
    <td class="td_left">Jumlah Minor</td>
    <td class="td_right"><?php echo $sess['JML_MINOR'];?></td>
  </tr>
  <tr>
    <td class="td_left">Level IRTP</td>
    <td class="td_right"><?php echo $sess['LEVEL_IRTP'];?></td>
  </tr>
</table>
<h2 class="small garis" style="font-weight: bold; padding-bottom: 2px; font-size: 11px; color:#3c7faf;">Rincian Ketidaksesuaian</h2>
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
<!-- <h2 class="small" style="font-weight: bold; padding-bottom: 2px; font-size: 11px; color:#3c7faf;">Detil Petugas Pemeriksa</h2>!-->
<?php /*?><div id="detail_petugasx" url="<?php echo $histori_petugasx;?>"></div><?php */?>
<script type="text/javascript">
$(document).ready(function(){
	/*$("#detail_petugasx").html('Loading..');
	$("#detail_petugasx").load($("#detail_petugasx").attr("url"));*/
	$("table.form_tabel tr:even").css("background-color", "#f0f0f0");
	$("table.form_tabel tr:odd").css("background-color", "#fff");

});
</script>