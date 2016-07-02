<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR); ?>
<?php 
$jml = count($sess);
?>
<table class="listtemuan" width="100%" id="list-spp">
  <thead>
    <tr>
      <th width="80">Nomor</th>
      <th width="80">Tanggal</th>
      <th>Penyelia</th>
    </tr>
  </thead>
  <tbody id="tbodylist-spp">
  <?php
  if($jml > 0){
	  for($x = 0; $x < $jml; $x++){
		  ?>
          <tr>
          	<td><?php echo $sess[$x]['UR_SPP']; ?></td>
          	<td><?php echo $sess[$x]['TGL_SPP']; ?></td>
          	<td><?php echo $sess[$x]['PENYELIA']; ?><div><?php echo $sess[$x]['JABATAN']; ?></div></td>
          </tr>
          <?php
	  }
  }else{
	  ?>
      <tr><td colspan="3">Data Tidak Ditemukan</td></tr>
      <?php
  }
  ?>
  </tbody>
</table>
