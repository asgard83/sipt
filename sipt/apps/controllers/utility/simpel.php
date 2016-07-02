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
<form name="fsimpel" id="fsimpel" method="post" action="<?php echo $act; ?>" autocomplete="off">
<table class="form_tabel">
<tr><td class="td_left">Editor</td><td class="td_right"><textarea class="stext catatan" name="editor" style="text-align:justify; font-size:14px; height:200px;" rel="required" ></textarea></td></tr>
</table>
<span class="upload_LCP"><input type="file" class="stext upload" allowed="xls-doc-xlsx-docx-pdf-rar-zip" url="<?php echo site_url(); ?>/utility/uploads/new_upload" id="fileToUpload_LCP" title="File Lampiran Catatan Pengujian" name="userfile" onchange="do_upload($(this)); return false;"/>&nbsp; <div>Tipe File : *.xls, *.xlsx, *.doc, *.docx, *.rar, *.zip, *.pdf</div></span><span class="file_LCP"></span>

</form>
<div style="padding-left:5px; padding-bottom:10px;"><a href="#" class="button check" onclick="fpost('#fsimpel','',''); return false;"><span><span class="icon"></span>&nbsp; Jalankan &nbsp;</span></a></div>
</div>
</div>
</div>
</div>
</body>
</html>