<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link type="image/x-icon" href="<?php echo base_url();?>images/favicon.gif" rel="Shortcut Icon" />
<link type="text/css" href="<?php echo base_url();?>css/aristo.css" rel="stylesheet" />
<link type="text/css" href="<?php echo base_url();?>css/css.css" rel="stylesheet" media="screen"/>
<link type="text/css" href="<?php echo base_url();?>css/jquery.alerts.css" rel="stylesheet" />
<link type="text/css" href="<?php echo base_url();?>css/newtable.css" rel="stylesheet" />
<link type="text/css" href="<?php echo base_url();?>js/css/redactor.css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.alerts.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.poshytip.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.autocomplete.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.ui.datepicker-id.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.innerfade.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/ajaxfileupload.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/google_api.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/redactor.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/apps.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/newtable.js"></script>
<script type="text/javascript">
	var isUrl = "<?php echo base_url(); ?>";
	$(document).ready(function(){
		$('ul#menus li').hover(function(){
			 $(this).children('ul').stop().show();
		}, function(){
			 $(this).children('ul').stop().hide();
		});
		/*var refreshId = setInterval(function(){
			show_notif();
		}, 25000);*/
		notif_all("#notifall");
	});
	info();
	function info(){
		setTimeout(function(){
			$.get(isUrl+'index.php/load/utility/set_notif', function(data){
				$("#news").html(data);
				$('#news').innerfade({speed: 1000, timeout: 15000, type: 'sequence', containerheight: '1em'});
			});
			setTimeout('info()', 5000);
		}, 2500)
	}
</script> 
