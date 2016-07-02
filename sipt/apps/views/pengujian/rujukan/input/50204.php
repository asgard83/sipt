<h2 class="small garis">Hasil Uji Parameter Yang dilakukan</h2>
<table class="tabelajax">
  <tr class="head">
    <th width="75">Jenis Uji</th>
    <th width="150">Uji yang dilakukan</th>
    <th width="150">Hasil</th>
    <th width="150">Syarat</th>
    <th width="150">Metode</th>
    <th width="150">Pustaka</th>
    <th width="50">LCP</th>
    <th width="100">Hasil Parameter</th>
  </tr>
  <?php 
    $jparameter = count($parameter);
    if($jparameter > 0){
        for($x = 0; $x < $jparameter; $x++){
            ?>
  <tr>
    <td><?php echo $parameter[$x]['JENIS_UJI']; ?></td>
    <td><?php echo $parameter[$x]['PARAMETER_UJI']; ?></td>
    <td><div><?php echo $parameter[$x]['HASIL']; ?></div>
      <div><?php echo $parameter[$x]['HASIL_KUALITATIF']; ?></div></td>
    <td><?php echo $parameter[$x]['SYARAT']; ?></td>
    <td><?php echo $parameter[$x]['METODE']; ?></td>
    <td><?php echo $parameter[$x]['PUSTAKA']; ?></td>
    <td><?php
      if(strlen(trim($parameter[$x]['LCP'])) > 0){
          ?>
      <a href="<?php echo base_url().'files/LCP/'.$parameter[$x]['KODE_SAMPEL'].'/'.$parameter[$x]['LCP']; ?>" target="_blank">LCP</a>
      <?php
      }else{
		  ?>
      Tidak Melampirkan CP
      <?php
	  }
      ?></td>
    <td><?php echo $parameter[$x]['HASIL_PARAMETER']; ?></td>
  </tr>
  <?php
            }
        }else{
            ?>
  <tr>
    <td colspan="8"><?= $dtrujukan[0]['CATATAN']; ?></td>
  </tr>
  <?php
        }
    ?>
</table>
