<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);
?>

<style>
.form_tabel{
	border-collapse: collapse;
	border-spacing: 0;
	width:100%;
}

.form_tabel .td_left{
	vertical-align:top;
	width:240px;
	padding: 5px; 
	height:auto;
}
.form_tabel .td_right{
	vertical-align:top;
	width:auto;
	padding: 5px; 
	height:auto;
}
</style>
<table class="form_tabel">
	<tr><td class="td_left">Tanggal Perbaikan</td><td class="td_right"><?php echo array_key_exists('TANGGAL_PERBAIKAN', $sess)?$sess['TANGGAL_PERBAIKAN'] : ''; ?></td></tr>
    <tr><td class="td_left">Nama Petugas</td><td class="td_right"><?php echo array_key_exists('NAMA_USER', $sess)?$sess['NAMA_USER'] : ''; ?></td></tr>
    <tr><td class="td_left">Nama Balai Pemeriksa</td><td class="td_right"><?php echo array_key_exists('NAMA_BBPOM', $sess)?$sess['NAMA_BBPOM'] : ''; ?></td></tr>
    <tr><td class="td_left">Detil Perbaikan</td><td class="td_right"><?php echo array_key_exists('DETAIL_PERBAIKAN', $sess)?$sess['DETAIL_PERBAIKAN'] : ''; ?></td></tr>
    <tr><td class="td_left">File Perbaikan</td><td class="td_right">
    <?php
	if($sess['FILE_PERBAIKAN'] != NULL){
		?>
          <a href="<?php echo base_url(); ?>files/<?php echo $sess['SARANA_ID'];?>/<?php echo $sess['FILE_PERBAIKAN']; ?>">Lampiran File Perbaikan</a>
    <?php
	}
    ?></td></tr>
</table>
<script type="text/javascript">
	$(document).ready(function(){
		$("table.form_tabel tr:even").css("background-color", "#f0f0f0");
		$("table.form_tabel tr:odd").css("background-color", "#fff");
	});
</script>

