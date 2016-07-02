<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR);?>
<link type="text/css" href="<?php echo base_url();?>css/css.css" rel="stylesheet" />
<table class="listtemuan" width="100%">
  <thead>
    <tr>
      <th width="400">Tanggal Pemeriksaan</th>
      <th width="150">Level IRTP</th>
      <th width="250">Aksi</th>
    </tr>
  </thead>
  <tbody>
    <?php
	$jml = count($data);
	if($jml > 0){
		for($i = 0; $i < $jml; $i++){
	?>
    <tr>
      <td><?php echo $data[$i]['AWAL PERIKSA']; ?> s.d <?php echo $data[$i]['AKHIR PERIKSA']; ?> </td>
      <td><?php echo $data[$i]['LEVEL_IRTP']; ?></td>
      <td><a href="javascript:void(0);" class="preview-histrori" data-url = "<?php echo site_url(); ?>/get/pemeriksaan/get_histori_pirt/<?php echo $data[$i]['PERIKSA_ID']; ?>" data-judul = "Histori Pemeriksaan Sarana Produksi Pangan PIRT">Preview Data</a></td>
    </tr>
    <?php
		}
	}
	?>
  </tbody>
</table>
<div id="ctn-histori"></div>
<script>
	$(document).ready(function(e){
		$("a.preview-histrori").click(function(e){
			var $this = $(this);
			$.get($this.attr("data-url"), function(data){
				$("#ctn-histori").html(data); 
				$("#ctn-histori").dialog({ 
					title: $this.attr("data-judul"), 
					width: 900, 
					resizable: false, 
					modal: true
				}); 
			});
        });
	});
</script> 
