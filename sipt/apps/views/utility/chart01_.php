<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<div id="<?php echo $idjudul; ?>" class="judul"></div>
<div class="content">
<div id="accordion" style="min-height:450px;">
	<h2 class="current"><?php echo $caption_header; ?></h2>
    <table width="900" align="center"><tr>
        <td width="300" align="center" valign="top"><div id="week"></div></td>
        <td align="center" valign="top"><div id="month"></div></td>
        <td width="300" align="center" valign="top"><div id="year"></div></td>
    </tr><tr>
        <td colspan="3"><div style="margin-top:15px;width:100%;" id="all"></div></td>
    </tr></table>
    <div style="height:20px;"></div>
</div>
</div>
<script type="text/javascript">
jLoadingOpen('','SIPT Versi 1.0'); 
google.load("visualization", "1", {packages:["corechart"]}); google.setOnLoadCallback(function(){setTimeout(function(){ $('#all').load(isUrl+'index.php/utility/grafik/chart_pemeriksaan/all'); $.get(isUrl+'index.php/utility/grafik/chart_pemeriksaan/week', function(hasil){ hasil = $.trim(hasil); drawChart(hasil, "week");}); $.get(isUrl+'index.php/utility/grafik/chart_pemeriksaan/month', function(hasil){ hasil = $.trim(hasil); drawChart(hasil, "month");}); $.get(isUrl+'index.php/utility/grafik/chart_pemeriksaan/year', function(hasil){ hasil = $.trim(hasil); drawChart(hasil, "year");}); jLoadingClose();}, 2000);});
function drawChart(hasil, idobj){hasil = hasil.split('|'); var len = hasil.length; if(len>0){ var data = new google.visualization.DataTable(); data.addColumn('string', 'BBPOM / BPOM'); data.addColumn('number', 'Jumlah Pemeriksaan'); for(i=0;i<len;i++){ var temp = hasil[i]; temp = temp.split(';'); data.addRows([[temp[0], parseInt(temp[1])]]); if(i==len)break;}var options = {width: 240,height: 240, backgroundColor: '#fff',chartArea: {left:10, top:10, bottom:0, width:'85%', height:'85%'}, tooltip: {textStyle: {fontName: 'verdana', fontSize: 11}}, legend: {position: 'none'},is3D: true, pieSliceTextStyle: {fontName: 'verdana', fontSize: 11}};var chart = new google.visualization.PieChart(document.getElementById(idobj));chart.draw(data, options);i--;$('#' + idobj).append(hasil[i]);}}
</script>