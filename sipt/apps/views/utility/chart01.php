<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<style type="text/css">
#wrap-chart {
	width:950px;
	margin:0 auto;
}
.colspan{
	width:900px;
	margin:0 auto;
	min-height:200px;
	background:url('<?php echo base_url(); ?>images/loading.gif') no-repeat center;
}
</style>
<div id="<?php echo $idjudul; ?>" class="judul"></div>
<div class="content">
<div id="accordion" style="min-height:450px;">
	<h2 class="current"><?php echo $caption_header; ?></h2>
    <div id="wrap-chart">
        <div id="week" url="<?php echo site_url(); ?>/utility/grafik/top_chart/1" class="colspan" judul="10 Top Pemeriksaan Periode Minggu Ini" tipe="column" t="250" l="800"></div>
        <div id="month" url="<?php echo site_url(); ?>/utility/grafik/top_chart/2" class="colspan" judul="10 Top Pemeriksaan Periode Bulan Ini" tipe="column" t="250" l="800"></div>
        <div id="year" url="<?php echo site_url(); ?>/utility/grafik/top_chart/3" class="colspan" judul="10 Top Pemeriksaan Periode Tahun Ini" tipe="column" t="250" l="800"></div>
        <div id="all" url="<?php echo site_url(); ?>/utility/grafik/top_chart/all" class="colspan" judul="Rekapitulasi Semua Pemeriksaan Sarana" tipe="column" t="250" l="800"></div>
    </div>
    <div id="clear_fix"></div>
</div>
</div>
<script type="text/javascript">
//jLoadingOpen('','SIPT Versi 1.0'); 
google.setOnLoadCallback(function(){
	$("#wrap-chart").children().each(function(n,i){
		var cont = $(this).attr("id");
		var url = $(this).attr("url");
		var judul = $(this).attr("judul");
		var tipe = $(this).attr("tipe");
		var tinggi = $(this).attr("t");
		var lebar = $(this).attr("l");
		setTimeout(function(){drawChart(url, cont, lebar, tinggi, judul,'left',tipe);}, 2000);
		//jLoadingClose();
	});	
});
google.load("visualization", "1", {packages:["corechart"]});
function drawChart(url, cont, lebar, tinggi, judul, position, tipe){
	$.get(url, function(hasil){
		hasil = $.trim(hasil);
		if(hasil=="0") return false;
		hasil = hasil.split('|');
		if(hasil.length>0){
			var judul = hasil[0];
			var arrdat = hasil[1].split(';');
			var data = new google.visualization.DataTable();
			data.addColumn('string', 'Jumlah');
			for(i=0;i<arrdat.length;i++){
				data.addColumn('number', arrdat[i]);
			}
			arrdat = hasil[2].split('@');
			for(i=0;i<arrdat.length;i++){
				intdata = arrdat[i].split(';');
				var arrtemp = new Array;
				for(j=0;j<intdata.length;j++){
					if(j==0)
						arrtemp[j] = intdata[j];
					else
						arrtemp[j] = parseInt(intdata[j]);
				}
				data.addRows([arrtemp]);				
			}
			
			var options = {width: lebar, height: tinggi, title: judul, fontSize: 11, titleTextStyle: {fontSize: 11},legend: {position:'bottom'}};
			if(tipe == "column") var chart = new google.visualization.ColumnChart(document.getElementById(cont));
			if(tipe == "bar") var chart = new google.visualization.BarChart(document.getElementById(cont));
			chart.draw(data, options);
		}
	});
}

</script>