
<table class="form_tabel">
  <tr>
    <td class="td_left">Kode Balai</td>
    <td class="td_right"><?php echo $kodebalai; ?></td>
  </tr>
  <tr>
    <td class="td_left">Komoditi</td>
    <td class="td_right"><?php echo $ur_ko; ?></td>
  </tr>
  <tr>
    <td class="td_left">Anggaran</td>
    <td class="td_right"><?php echo $ur_as; ?></td>
  </tr>
  <tr>
    <td class="td_left">Tahun Aktif</td>
    <td class="td_right"><?php echo $ur_ta; ?></td>
  </tr>
  <tr>
    <td class="td_left">Total Sampel</td>
    <td class="td_right"><?php echo $jml; ?>, Data</td>
  </tr>
  <tr>
    <td class="td_left"><input type="checkbox" name="chk_start" id="chk_start" onChange="fstart();">
      &nbsp;Start Reset, Interval&nbsp;&nbsp;</td>
    <td class="td_right"><input type="text" class="sdate" name="intreset" id="intreset" value="5" title="Interval timer"></td>
  </tr>
</table>
<div style="height:2px;">&nbsp;</div>
<div id="timer_reset" style="padding-top:5px; padding-bottom:5px;"></div>
<div style="height:2px;">&nbsp;</div>
<ul id="isireset" style="list-style:none; padding:0px; margin-left:5px;">
</ul>
<script>
	var stratreset = false;
	var ids = '<?= $kode_sampel; ?>';
	arrid = ids.split('|');
	var idx = 0;
	
	function fstart(){
		if($('#chk_start').attr("checked")){
			$('#chk_start').attr("checked", "checked");
			var bar = $("#intreset").val(),
			loaded = bar;
			var load = function(){
				if(loaded>0) $('#timer_reset').html(loaded + ' ... Mohon tunggu <img src="'+isUrl+'/images/_indicator.gif" alt="loading" align="absmiddle"  />');
				if(loaded==0){
					clearInterval(beginLoad);
					$('#timer_reset').html('');
					stratreset = true;
					set_kode();
				}
				loaded -= 1;
			}
			var beginLoad = setInterval(function(){ load(); }, 5000);
		}else{
			$('#chk_start').removeAttr("checked");
			stratreset = false;
		}
	}
	
	function set_kode(){
		if(stratreset===false) return false;
		if(idx<arrid.length){
			var url = '<?= site_url();?>/utility/tools/step_reset/second/ajax/' + arrid[idx];
			var percent = 0;
			$.get(url, function(data){
				arrdata = data.split('#'); 
				if(arrdata[0].trim()=='OK'){
					percent = parseFloat((idx) / arrid.length) * 100;
					$("ul#isireset").html(arrdata[1]);
					$('#timer_reset').html('Proses Data ' + idx + ' Dari ' + arrid.length + ' : ' + arrdata[2] + ' ( '+ percent.toFixed(2) +' %)');
				}
				idx++;
				set_kode();
			});
		}else{
			stratreset = false;
			$('#timer_reset').html('Complete');
			$("ul#isireset").html('');
		}
		return false;
	}
	
	$(document).ready(function(){
		$("table.form_tabel tr:even").css("background-color", "#f0f0f0");
		$("table.form_tabel tr:odd").css("background-color", "#fff");
	});
	
</script> 
