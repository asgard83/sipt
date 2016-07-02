<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /><link rel="Shortcut Icon" href="<?php echo base_url();?>images/favicon.gif" type="image/x-icon" /><link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/login.css" media="screen" />
<link type="text/css" href="<?php echo base_url();?>css/jquery.alerts.css" rel="stylesheet" /><script type="text/javascript" src="<?php echo base_url();?>js/jquery.min.js"></script><script type="text/javascript" src="<?php echo base_url();?>js/curvycorners.js"></script><script type="text/javascript" src="<?php echo base_url();?>js/login.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.alerts.js"></script>
<script type="text/javascript">
function initCorners(){ 
	var settings = { tl: { radius: 10 }, tr: { radius: 10 }, bl: { radius: 10 }, br: { radius: 10 }, antiAlias: true } 
	curvyCorners(settings, "#loginbox, #logobox, #msgbox"); $('#userid').focus();
}
$(document).ready(function(){ 
	initCorners(); 
});
</script>
