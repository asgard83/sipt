<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
{_header_}
<title>{_appname_}</title>
</head>
<body>
<table align="center">
	<tr><td>
	<div id="logobox">
	</div>
	<div id="loginbox">
	<form name="flog" id="flog" method="post" action="" autocomplete="off" url="<?php echo base_url(); ?>index.php/login/login_attempt/<?= $this->session->userdata('session_id'); ?>">
	<b>User ID<br /></b>
	<input type="text" class="text" name="userid" id="userid" title="User id tidak boleh kosong" /><br />
	<b>Password</b></label><br />
	<input type="password" class="text" name="password" id="password" title="Password tidak boleh kosong" /><br />
	<input id="loginbtn" name="loginbtn" src="<?php echo base_url(); ?>images/trans.gif" type="image" />
	</form>
	<a href="#">Lupa password Anda?</a>
	</div>
	<div id="menutopbox">
	<a href="<?php echo base_url(); ?>">Home</a> | <a href="mailto:bidang_ti@pom.go.id">Contact Us</a>
	</div>
	<div id="menubotbox">
	Copyright &copy; 2011 - BPOM
	</div>
	<div id="msgbox" style="display:none;"><span id="isimsgbox">Note</span></div>
	</td></tr>
</table>
</body>
</html>