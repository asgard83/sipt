<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR); ?>

<table class="listtemuan" width="100%" id="list-spp">
  <thead>
  	<tr>
    <th>Jenis Uji</th>
    <th>Uji yang dilakukan</th>
    <th>Hasil</th>
    <th>Syarat</th>
    <th>Metode</th>
    <th>Pustaka</th>
    <th>Hasil Parameter</th>
    <th>LCP</th>
    <th>Penguji</th>
    </tr>
  </thead>
  <tbody>
    <?php
	$jparameter = count($sess);
	if($jparameter > 0){
		for($x = 0; $x < $jparameter; $x++){
			?>
            <tr id="<?php echo $sess[$x]['UJI_ID']; ?>">
              <td><?php echo $sess[$x]['JENIS_UJI']; ?></td>
              <td><?php echo $sess[$x]['PARAMETER_UJI'];?></td>
              <td><div><?php echo $sess[$x]['HASIL']; ?></div>
                <div><?php echo $sess[$x]['HASIL_KUALITATIF']; ?></div></td>
              <td><?php echo $sess[$x]['SYARAT']; ?></td>
              <td><?php echo $sess[$x]['METODE']; ?></td>
              <td><?php echo $sess[$x]['PUSTAKA']; ?></td>
              <td><a href="javascript:;" class="view-hasil" url = "<?= site_url(); ?>/get/pengujian/get_hasil/" kode = "<?= $sess[$x]['KODE_SAMPEL']; ?>"><?php echo $sess[$x]['HASIL_PARAMETER']; ?></a></td>
              <td><?php
                        if(strlen(trim($sess[$x]['LCP'])) > 0){
                            ?>
                <a href="<?php echo base_url().'files/LCP/'.$sess[$x]['KODE_SAMPEL'].'/'.$sess[$x]['LCP']; ?>" target="_blank">LCP</a>
                <?php
                        }else{
                            ?>
                Tidak melampirkan LCP
                <?php
                        }
                        ?></td>
              <td><?php echo $sess[$x]['NAMA_USER']; ?></td>         
            </tr>
            <?php
			}
		}else{
			?>
            <tr>
            	<td colspan="9">&nbsp;</td>
            </tr>
            <?php
		}
	?>
  </tbody>
</table>
<div id="dialog-parameter"></div>
<script>
	$(document).ready(function(){
		$("table.form_tabel tr:even").css("background-color", "#f0f0f0");
		$("table.form_tabel tr:odd").css("background-color", "#fff");
		$(".view-hasil").click(function(){
            var id = $(this).closest("tr").attr("id");
			var kode = $(this).attr("kode");
			$.get($(this).attr("url") + id + '/' + kode, function(data){
				$("#dialog-parameter").html(data); 
				$("#dialog-parameter").dialog({ 
					title: 'Hasil Parameter', 
					width: 800, 
					resizable: false, 
					modal: true
				}); 
			});
			return false;
        });
	});
</script>