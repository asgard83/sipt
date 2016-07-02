<table class="form_tabel">
<tr><td class="td_left">Tanggal Inspeksi Terakhir</td><td class="td_right"><?php echo $sess['AWAL_PERIKSA']; ?> sampai dengan <?php echo $sess['AKHIR_PERIKSA']; ?></td></tr>
<tr><td class="td_left">Inspektur yang bertugas pada inspeksi terakhir</td><td class="td_right">
<ul style="margin-top:0px; padding-left:15px; list-style:decimal;"><li>
<?php 
  $petugas = explode("-",$sess['PETUGAS']);
  foreach($petugas as $val){
	  ?>
	 	<li><?php echo $val; ?></li>                                
	 <?php
  }
?>
</ul>
</td></tr>
<tr><td class="td_left">Ringkasan hasil inspeksi sebelumnya</td><td class="td_right"><?php echo $sess['LATAR_BELAKANG']; ?></td></tr>
<tr><td class="td_left">&nbsp;</td><td class="td_right">&nbsp;</td></tr>
</table>
<script type="text/javascript">
	$(document).ready(function(){
		$("table.form_tabel tr:even").css("background-color", "#f0f0f0");
		$("table.form_tabel tr:odd").css("background-color", "#fff");	  
	});
</script>