<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<link type="text/css" href="<?php echo base_url();?>css/morris.css" rel="stylesheet" />
<div style="height:10px;"></div>
<div style="font-size:16px; color:#F00; margin-left:7px; display:none;"><a href="<?php echo site_url(); ?>/download/data/UPDATE_AUTO_RESET_PENOMORAN.pdf" target="_blank">Notifikasi : Update pengkodean nomor untuk sampling dan pengujian. Untuk lebih detil, silahkan klik link tautan ini</a> </div>
<div style="height:10px; display:none;"></div>
<div style="padding:5px;">
  <div class="inbox-head">
    <h3>Pemeriksaan Sarana Tahun Aktif
      <?= date("Y"); ?>
    </h3>
  </div>
  <div class="inbox-body pelaporan" id="pemeriksaan">
    <div class="moris-kiri cmorris" id="psarana" url="<?php echo site_url(); ?>/utility/grafik/get_chart/pemeriksaan/periksa" tmorris="garis">
      <div class="loading">Memuat Data ...</div>
    </div>
    <div class="moris-kanan cmorris" id="pjenis" url="<?php echo site_url(); ?>/utility/grafik/get_chart/pemeriksaan/jenis-sarana" tmorris="donut">
      <div class="loading">Memuat Data ...</div>
    </div>
  </div>
  <div style="height:5px;">&nbsp;</div>
  <div class="inbox-head">
    <h3>Sampling dan Pengujian Tahun Aktif
      <?= date("Y"); ?>
    </h3>
  </div>
  <div class="inbox-body pelaporan" id="pengujian">
    <div class="moris-kiri cmorris" id="psampling" url="<?php echo site_url(); ?>/utility/grafik/get_chart/pengujian/sampling" tmorris="garis">
      <div class="loading">Memuat Data ...</div>
    </div>
    <div class="moris-kanan cmorris" id="pkomoditi" url="<?php echo site_url(); ?>/utility/grafik/get_chart/pengujian/komoditi" tmorris="donut">
      <div class="loading">Memuat Data ...</div>
    </div>
  </div>
</div>
<script type="text/javascript" src="<?php echo base_url();?>js/raphael-min.js"></script> 
<script type="text/javascript" src="<?php echo base_url();?>js/morris.js"></script> 
<script>
$(".cmorris").each(function(n,i){
	var id = $(this).attr("id");
	var url = $(this).attr("url");
	var tipe = $(this).attr("tmorris");
	$.ajax({
		url : url,
		dataType: 'json',
		success: function(response){
			var arrdata = response;
			if(tipe == "garis"){
				Morris.Line({
					element: id,
					data: arrdata,
					xkey: 'Bulan',
					ykeys: ['Total'],
					labels: ['Total'],
					parseTime: false
				});
			}else if(tipe == "donut"){
				Morris.Donut({
				  element: id,
				  data: arrdata,
				  labelColor: '#303641',
				  colors: ['#f26c4f', '#00a651', '#00bff3', '#0072bc', '#707f9b', '#455064', '#242d3c']
				})
			}
		}
	});
	$(".loading").hide(500);
});
</script> 
