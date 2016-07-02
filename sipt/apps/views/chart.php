<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Grafik Monitoring Pemeriksaan Sarana SIPT BPOM</title>
<style type="text/css">
#wrap {
   width:950px;
   margin:0 auto;
}
.left_col {
   float:left;
   width:450;
}
.right_col {
   float:right;
   width:450px;
}
.colspan{
   width:850px;
   margin:0 auto;
}
</style>
<script type="text/javascript" src="<?php echo base_url();?>js/google_api.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.min.js"></script>
<script type="text/javascript">
google.load('visualization', '1', {'packages':['corechart']});
google.setOnLoadCallback(function(){
	var refreshId = setInterval( function(){
		$("#wrap").children().each(function(n,i){
			var cont = $(this).attr("id");
			var url = $(this).attr("url");
			var judul = $(this).attr("judul");
			$.get(url, function(hasil){
				drawchart(hasil, cont, 850, 250, judul,'bottom','column');
			},"json");

		});
	}, 9000);
});

function drawchart(hasil, obj, lebar, tinggi, judul, posisi, tipe){
	var data = new google.visualization.arrayToDataTable(hasil);
	var options = {width: lebar, height: tinggi, title: judul, fontSize: 11, titleTextStyle: {fontSize: 11},legend: {position:posisi}};
	if(tipe == "column"){
		var chart = new google.visualization.ColumnChart(document.getElementById(obj));
	}else if(tipe == "bar"){
		var chart = new google.visualization.BarChart(document.getElementById(obj));
	}else if(tipe == "line"){
		var chart = new google.visualization.LineChart(document.getElementById(obj));
	}else{
		var chart = new google.visualization.PieChart(document.getElementById(obj));
	}
	chart.draw(data, options);
}

</script>
</head>

<body>
<div id="wrap">

    <div id="jmlsarana" url="<?php echo site_url(); ?>/chart/sarana" class="colspan" judul="Rekapitulasi Jumlah Pemeriksaan Sarana"></div>
    <div id="prodob" url="<?php echo site_url(); ?>/chart/produksi/1" class="colspan" judul="Rekapitulasi Sarana Produksi Obat"></div>
    <div id="prodotkos" url="<?php echo site_url(); ?>/chart/produksi/2" class="colspan" judul="Rekapitulasi Sarana Produksi OTKosPK"></div>
    <div id="prodpangan" url="<?php echo site_url(); ?>/chart/produksi/3" class="colspan" judul="Rekapitulasi Sarana Produksi Pangan"></div>
    <div id="disob" url="<?php echo site_url(); ?>/chart/dist/deputi/1" class="colspan" judul="Rekapitulasi Sarana Distribusi Obat"></div>
    <div id="disotkos" url="<?php echo site_url(); ?>/chart/dist/deputi/2" class="colspan" judul="Rekapitulasi Sarana Distribusi OTKosPK"></div>
    <div id="dispangan" url="<?php echo site_url(); ?>/chart/dist/deputi/3" class="colspan" judul="Rekapitulasi Sarana Distribusi Pangan"></div>
    <div id="dispelayanan" url="<?php echo site_url(); ?>/chart/pelayanan/deputi/2" class="colspan" judul="Rekapitulasi Sarana Pelayanan Obat"></div>
    <div id="diswaza" url="<?php echo site_url(); ?>/chart/wasza" class="colspan" judul="Rekapitulasi Sarana Pengawasan NAPZA"></div>
    <div id="disproduk" url="<?php echo site_url(); ?>/chart/produk" class="colspan" judul="Rekapitulasi Temuan Produk"></div>
</div>
</body>
</html>
