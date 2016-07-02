<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR); ?>
<?php 
$jml = count($sess);
?>
<table class="listtemuan" width="100%" id="list-sps">
  <thead>
    <tr>
      <th width="80">Nomor SPU</th>
      <th width="80">Nomor SPS</th>
      <th width="500">Manager Teknis</th>
      <th width="120">Status</th>
    </tr>
  </thead>
  <tbody id="tbodylist-sps">
  <?php
  if($jml > 0){
	  for($x = 0; $x < $jml; $x++){
		  ?>
          <tr>
          	<td><?php echo $sess[$x]['UR_SPU']; ?></td>
          	<td><?php echo $sess[$x]['UR_SPS']; ?></td>
          	<td><?php echo $sess[$x]['MT']; ?><div><?php echo $sess[$x]['JABATAN']; ?></div></td>
          	<td><?php echo $sess[$x]['UR_STATUS']; ?></td>
          </tr>
          <?php
	  }
  }else{
	  ?>
      <tr><td colspan="4">Data Tidak Ditemukan</td></tr>
      <?php
  }
  ?>
  </tbody>
</table>
