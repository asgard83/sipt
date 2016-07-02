<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR);?>
<h2 class="small">Detil Petugas</h2>
<table class="form_tabel detil">
    <tr><td class="td_left">Nama Petugas</td><td class="td_right"><?php echo $sess['NAMA_USER']; ?></td></tr>
    <tr><td class="td_left">NIP</td><td class="td_right"><?php echo $sess['NIP']; ?></td></tr>
    <tr><td class="td_left">Jabatan</td><td class="td_right"><?php echo $sess['JABATAN']; ?></td></tr>
    <tr><td class="td_left">Balai Besar / Balai</td><td class="td_right"><?php echo $sess['NAMA_BBPOM']; ?></td></tr>
    <tr><td class="td_left">E-mail</td><td class="td_right"><?php echo $sess['EMAIL']; ?></td></tr>
    <tr><td class="td_left">Status</td><td class="td_right"><?php echo $sess['STATUS']; ?></td></tr>
    <tr><td class="td_left">Role SIPT</td><td class="td_right"><?php echo $sess['ROLE']; ?></td></tr>
</table>

<script type="text/javascript">
$(document).ready(function(){
    $(".entry").live("click", function(){
		jpopup($(this).attr('url'),'SIPT Versi 1.0','',900,'');
		return false;
	});
});
</script>