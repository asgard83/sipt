<input type="checkbox" name="chk_start" id="chk_start" onChange="fstart();">
&nbsp;Start Download, Interval&nbsp;&nbsp;
<input type="text" class="sdate" name="intreset" id="intreset" value="5" title="Interval timer">
<div style="height:2px;">&nbsp;</div>
<div id="timer_reset" style="padding-top:5px; padding-bottom:5px;"></div>
<div style="height:2px;">&nbsp;</div>
<ul id="isispk" style="list-style:none; padding:0px; margin-left:5px;">
</ul>
<script>
	var stratreset = false;
	var ids = '<?= $spuid; ?>';
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
			var url = '<?= site_url();?>/utility/tools/get_spkmt/' + arrid[idx];
			var percent = 0;
			$.get(url, function(data){
				arrdata = data.split('#'); 
				if(arrdata[0].trim()=='OK'){
					percent = parseFloat((idx) / arrid.length) * 100;
					$("ul#isispk").html(arrdata[1]);
					$('#timer_reset').html('Proses Data ' + idx + ' Dari ' + arrid.length + ' : ' + arrdata[2] + ' ( '+ percent.toFixed(2) +' %)');
				}
				idx++;
				set_kode();
			});
		}else{
			stratreset = false;
			$('#timer_reset').html('Complete');
			$("ul#isispk").html('');
		}
		return false;
	}
</script>
