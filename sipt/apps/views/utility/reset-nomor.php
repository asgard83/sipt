<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR);?>

<div id="juduluji" class="judul"></div>
<div class="content">
  <div class="adCntnr">
    <div class="acco2">
      <div class="expand"><b>Tools</b></div>
      <div class="collapse">
        <div class="accCntnt">
          <div style="padding-bottom:3px;"><b>Reset Kode Sampel</b></div>
          <input type="checkbox" name="chk_start" id="chk_start" onChange="fstart();">
          &nbsp;Start Reset, Interval&nbsp;&nbsp;
          <input type="text" class="sdate" name="intreset" id="intreset" value="5" title="Interval timer">
          <div id="timer_reset" style="padding-top:5px; padding-bottom:5px;"></div>
          <ul id="isi" style="list-style:none; padding:0px; margin-left:5px;">
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
	var stratreset = false;
	var ids = '<?= $id; ?>';
	arrid = ids.split('|');
	var idx = 0;
	
	function fstart(){
		if($('#chk_start').attr("checked")){
			$('#chk_start').attr("checked", "checked");
			var bar = $("#intreset").val(),
			loaded = bar;
			var load = function(){
				if(loaded>0) $('#timer_reset').html(loaded + ' ... Memuat <img src="'+isUrl+'/images/_indicator.gif" alt="loading" align="absmiddle"  />');
				//$('#timer_reset').html('Wait ... ' + loaded);
				if(loaded==0){
					clearInterval(beginLoad);
					$('#timer_reset').html('');
					stratreset = true;
					set_kode();
				}
				loaded -= 1;
			}
			var beginLoad = setInterval(function(){ load(); }, 2000);
		}else{
			$('#chk_start').removeAttr("checked");
			stratreset = false;
		}
	}
	
	function set_kode(){
		if(stratreset===false) return false;
		if(idx<arrid.length){
			var url = '<?= site_url();?>/utility/dbutils/resetkode/' + arrid[idx];
			var percent = 0;
			$.get(url, function(data){
				arrdata = data.split('#'); 
				if(arrdata[0].trim()=='OK'){
					percent = parseFloat((idx) / arrid.length) * 100;
					$("ul#isi").append('<li>- Kode <b>'+ arrdata[2] + '</b> &raquo; <b>' + arrdata[1] + '</b>, Update : &radic; &nbsp;' + arrdata[3] + '</li>');
					$('#timer_reset').html('Proses Data ' + idx + ' Dari ' + arrid.length + ' : ' + arrdata[1] + ' ( '+ percent.toFixed(2) +' %)');
				}
				idx++;
				set_kode();
			});
		}else{
			stratreset = false;
			//set_kode();
		}
		return false;
	}
</script>