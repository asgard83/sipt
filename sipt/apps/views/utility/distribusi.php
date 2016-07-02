<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR);?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
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
<script type="text/javascript" src="<?php echo base_url();?>js/ajaxtable.js"></script>
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
<form name="fdistribusi" id="fdistribusi" method="post" action="<?php echo $act; ?>" autocomplete="off">
<table class="form_tabel">
<tr><td class="td_left">Periksa ID</td><td class="td_right"><input type="text" class="sdate" name="PERIKSA_ID" rel="required" /></td></tr>
<tr><td class="td_left">Hasil Temuan</td><td class="td_right"><textarea class="stext catatan" name="DISTRIBUSI[HASIL_TEMUAN]" rel="required" ></textarea></td></tr>
<tr><td class="td_left">Pelanggaran Major</td><td class="td_right"><input type="text" name="DISTRIBUSI[KLASIFIKASI_PELANGGARAN_MAJOR]" rel="required"  class="sdate"/></td></tr>
<tr><td class="td_left">Pelanggaran Minor</td><td class="td_right"><input type="text" name="DISTRIBUSI[KLASIFIKASI_PELANGGARAN_MINOR]" rel="required"  class="sdate"/></td></tr>
<tr><td class="td_left">Pelanggaran Critical</td><td class="td_right"><input type="text" name="DISTRIBUSI[KLASIFIKASI_PELANGGARAN_CRITICAL]" rel="required"  class="sdate"/></td></tr>
<tr><td class="td_left">Pelanggaran Critical Absolute</td><td class="td_right"><input type="text" name="DISTRIBUSI[KLASIFIKASI_PELANGGARAN_CRITICAL_ABSOLUTE]" rel="required"  class="sdate"/></td></tr>
</table>
</form>
<div style="padding-left:5px; padding-bottom:10px;"><a href="#" class="button save" onclick="fpost('#fdistribusi','',''); return false;"><span><span class="icon"></span>&nbsp; Simpan &nbsp;</span></a></div>
</div>
</div>
</div>
</div>
</body>
</html>