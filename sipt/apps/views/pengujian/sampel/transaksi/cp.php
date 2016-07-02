<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR); ?>
<?php 
$jml = count($sess);
?>
<table class="listtemuan" width="100%" id="list-cp">
  <thead>
    <tr>
      <th width="80">Nomor</th>
      <th width="150">Diperiksa Oleh</th>
      <th width="80">Tanggal Periksa</th>
      <th width="200">Catatan</th>
      <th width="50">Hasil</th>
      <th width="150">Di Verifikasi Oleh</th>
      <th width="80">Tanggal Verifikasi</th>
    </tr>
  </thead>
  <tbody id="tbodylist-cp">
  <?php
  if($jml > 0){
	  for($x = 0; $x < $jml; $x++){
		  ?>
          <tr id="<?php echo $sess[$x]['LHU_ID']; ?>.<?php echo $sess[$x]['CP_ID']; ?>">
          	<td><?php echo $sess[$x]['UR_LHU']; ?></td>
          	<td><?php echo $sess[$x]['PENYELIA']; ?><div><?php echo $sess[$x]['JABATAN_PENYELIA']; ?></div></td>
          	<td><?php echo $sess[$x]['TGL_CP']; ?></td>
          	<td><?php echo $sess[$x]['CATATAN']; ?></td>
          	<td><?php echo $sess[$x]['HASIL']; ?></td>
          	<td><?php echo $sess[$x]['MANAJER']; ?><div><?php echo $sess[$x]['JABATAN_MT']; ?></div></td>
          	<td><?php echo $sess[$x]['TGL_MT']; ?></td>
          </tr>
          <?php
	  }
  }else{
	  ?>
      <tr><td colspan="7">Data Tidak Ditemukan</td></tr>
      <?php
  }
  ?>
  </tbody>
</table>
