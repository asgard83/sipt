<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR);?>
<link type="text/css" href="<?php echo base_url();?>css/css.css" rel="stylesheet" />
<style>
h2.small {
	font-weight: bold;
	padding-bottom: 10px;
	border-bottom: 1px solid #ededed;
	font-size: 1em;
	color:#3c7faf;
}
garis {
	line-height:23px;
	padding-top:5px;
}
</style>
<div style="height:5px;">&nbsp;</div>
<h2 class="small garis">Detail Hasil Pengujian Parameter Uji</h2>
<h2 class="small garis">Data Sampel</h2>
<table class="form_tabel">
  <tr>
    <td class="td_left">Kode Sampel</td>
    <td class="td_right atas bold"><?= $sess['KODE']; ?></td>
    <td></td>
    <td class="td_left">Nama Sampel</td>
    <td class="td_right"><?= $sess['NAMA_SAMPEL']; ?></td>
  </tr>
  <tr>
    <td class="td_left">Komoditi</td>
    <td class="td_right"><?= $sess['KOMODITI']; ?></td>
    <td></td>
    <td class="td_left">Nomor Registrasi</td>
    <td class="td_right"><?= $sess['NOMOR_REGISTRASI']; ?></td>
  </tr>
  <tr>
    <td class="td_left">Pabrik</td>
    <td class="td_right"><?= $sess['PABRIK']; ?></td>
    <td></td>
    <td class="td_left">Importir</td>
    <td class="td_right"><?= $sess['IMPORTIR']; ?></td>
  </tr>
  <tr>
    <td class="td_left">No Bets</td>
    <td class="td_right atas bold"><?= $sess['NO_BETS']; ?></td>
    <td></td>
    <td class="td_left">Bentuk Sediaan</td>
    <td class="td_right"><?= $sess['BENTUK_SEDIAAN']; ?></td>
  </tr>
</table>
<h2 class="small garis">Parameter Uji</h2>
<table class="tabelajax" id="update-hasil-parameter">
  <tr class="head">
    <th>Jenis Uji</th>
    <th>Uji yang dilakukan</th>
    <th>Hasil</th>
    <th>Syarat</th>
    <th>Metode</th>
    <th>Pustaka</th>
    <th>Hasil Parameter</th>
    <th>LCP</th>
  </tr>
  <?php
	$jparameter = count($parameter);
	if($jparameter > 0){
		for($x = 0; $x < $jparameter; $x++){
			?>
  <tr id="<?php echo $parameter[$x]['UJI_ID']; ?>">
    <td><?php echo $parameter[$x]['JENIS_UJI']; ?></td>
    <td><?php echo $parameter[$x]['PARAMETER_UJI'];?></td>
    <td><div><?php echo $parameter[$x]['HASIL']; ?></div>
      <div><?php echo $parameter[$x]['HASIL_KUALITATIF']; ?></div></td>
    <td><?php echo $parameter[$x]['SYARAT']; ?></td>
    <td><?php echo $parameter[$x]['METODE']; ?></td>
    <td><?php echo $parameter[$x]['PUSTAKA']; ?></td>
    <td><a href="javascript:;" class="view-hasil" url = "<?= site_url(); ?>/get/pengujian/get_hasil/" kode = "<?= $parameter[$x]['KODE_SAMPEL']; ?>"><?php echo $parameter[$x]['HASIL_PARAMETER']; ?></a></td>
    <td><?php
				if(strlen(trim($parameter[$x]['LCP'])) > 0){
					?>
      <a href="<?php echo base_url().'files/LCP/'.$sess['KODE_SAMPEL'].'/'.$parameter[$x]['LCP']; ?>" target="_blank">LCP</a>
      <?php
				}else{
					?>
      Tidak melampirkan LCP
      <?php
				}
				?></td>
  </tr>
  <?php
			}
		}
	?>
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