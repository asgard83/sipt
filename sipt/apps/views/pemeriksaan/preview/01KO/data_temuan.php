<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR);?>
<table class="listtemuan" id="tb_temuan" width="100%">
	<thead><tr><th>Klasifikasi Temuan dan Keterangan Temuan</th><th>Kriteria Temuan dan Lampiran File</th></tr></thead>
    <?php
		$jmldata = count($temuan_cpkb);
		if($jmldata==0){
			$jmldata = 1;
			$temuan_cpkb[] = "";
		}
		$i = 0;
		$currenttemuan = "";
		do{
			  ?>
			  <tr><td width="545px;"><div style="padding-bottom:5px;">
              <?php
			  if($temuan_cpkb[$i]['UR_JENIS'] != $currenttemuan){
				echo '<b>'.$temuan_cpkb[$i]['UR_JENIS'].'</b>';
              }
              $currenttemuan = $temuan_cpkb[$i]['UR_JENIS'];
			  ?>
              
              </div><div><?php echo preg_replace('/[^(\x20-\x7F)]*/','',html_entity_decode($temuan_cpkb[$i]['TEMUAN_TEKS'])); ?></div></td><td><div style="padding-bottom:5px;"><?php echo $temuan_cpkb[$i]['TEMUAN_KRITERIA']; ?><br /><?php if(trim($temuan_cpkb[$i]['TEMUAN_FILE']) != "") { ?><a href="<?php echo base_url(); ?>files/<?php echo $sarana_id; ?>/<?php echo $temuan_cpkb[$i]['TEMUAN_FILE']; ?>" target="_blank">File Lampiran</a><?php } ?></div></td></tr>
			  <?php
		$i++;
		}while($i<$jmldata);
	?>
</table>
