<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR); ?>
<?php 
$jml = count($sess);
?>
<table class="listtemuan" width="100%" id="list-spk">
  <thead>
    <tr>
      <th width="80">Nomor</th>
      <th width="80">Tanggal</th>
      <th width="200">Manager Teknis</th>
      <th width="200">Penyelia</th>
      <th width="100">Bidang</th>
    </tr>
  </thead>
  <tbody id="tbodylist-spk">
  <?php
  if($jml > 0){
	  for($x = 0; $x < $jml; $x++){
		  ?>
          <tr>
          	<td><?php echo $sess[$x]['UR_SPK']; ?></td>
          	<td><?php echo $sess[$x]['TGL_SPK']; ?></td>
          	<td><?php echo $sess[$x]['MT']; ?><div><?php echo $sess[$x]['JABATAN_MT']; ?></div></td>
          	<td><?php echo $sess[$x]['PENYELIA']; ?><div><?php echo $sess[$x]['JABATAN_PENYELIA']; ?></div></td>
          	<td><?php echo $sess[$x]['SPK_BIDANG']; ?></td>
          </tr>
          <?php
	  }
  }else{
	  ?>
      <tr><td colspan="5">Data Tidak Ditemukan</td></tr>
      <?php
  }
  ?>
  </tbody>
</table>
