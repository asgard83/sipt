<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR);?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link type="image/x-icon" href="<?php echo base_url();?>images/favicon.gif" rel="Shortcut Icon" />
<link type="text/css" href="<?php echo base_url();?>css/aristo.css" rel="stylesheet" />
<link type="text/css" href="<?php echo base_url();?>css/css.css" rel="stylesheet" media="screen"/>
<link type="text/css" href="<?php echo base_url();?>css/jquery.alerts.css" rel="stylesheet" />
<link type="text/css" href="<?php echo base_url();?>js/css/redactor.css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.alerts.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.poshytip.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.autocomplete.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.ui.datepicker-id.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/redactor.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/apps.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/ajaxfileupload.js"></script>
<script type="text/javascript">
	var isUrl = "<?php echo base_url(); ?>";
</script>
<title><?php echo $judul; ?></title>
</head>
<body>
<div align="center" id="wrap">
  <div id="contentbox">
    <div class="content">
      <div id="accordion">
        <input type="checkbox" name="chk_start" id="chk_start" onChange="fstart();">
        &nbsp;Mulai, Interval&nbsp;&nbsp;
        <input type="text" class="sdate" name="intreset" id="intreset" value="5" title="Interval timer">
        <div style="height:2px;">&nbsp;</div>
        <div id="timer_reset" style="padding-top:5px; padding-bottom:5px;"></div>
        <div style="height:2px;">&nbsp;</div>
        <ul id="isi" style="list-style:none; padding:0px; margin-left:5px;">
        </ul>
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
			var url = '<?= site_url();?>/utility/tools/get_salah_kode/' + arrid[idx];
			var percent = 0;
			$.get(url, function(data){
				arrdata = data.split('#'); 
				if(arrdata[0].trim()=='OK'){
					percent = parseFloat((idx) / arrid.length) * 100;
					$("ul#isi").append(arrdata[1]);
					$('#timer_reset').html('Proses Data ' + idx + ' Dari ' + arrid.length + ' : ' + arrdata[2] + ' ( '+ percent.toFixed(2) +' %)');
				}else if(arrdata[0].trim()=='NO'){
					$("ul#isi").append(arrdata[1]);
				}
				idx++;
				set_kode();
			});
		}else{
			stratreset = false;
			/*$('#timer_reset').html('Complete');
			$("ul#isi").html('');*/
		}
		return false;
	}
</script>
</body>
</html>