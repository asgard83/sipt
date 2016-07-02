<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR);?>
<div id="judulpassword" class="judul"></div>
<div class="content">
<div id="accordion">
    <h2 class="current">Edit Password</h2>
    <form name="fpass" id="fpass" method="post" action="<?php echo site_url(); ?>/login/password" autocomplete="off">
    <table class="form_tabel">
    <tr><td class="td_left">Password Lama</td><td class="td_right"><input type="password" name="plama" class="stext" rel="required" title="Password Lama Anda" /></td></tr>
    <tr><td class="td_left">Password Baru</td><td class="td_right"><input type="password" name="pwd" class="stext" rel="required" title="Password Baru Anda" /></td></tr>
    <tr><td class="td_left">Konfirmasi Password</td><td class="td_right"><input type="password" name="kpwd" class="stext" rel="required" title="Konfirmasi Password Baru" /></td></tr>
    </table>
    </form>
    <div style="padding-left:5px; padding-bottom:10px;"><a href="#" class="button save" onclick="fpost('#fpass','',''); return false;"><span><span class="icon"></span>&nbsp; Simpan &nbsp;</span></a>&nbsp;<a href="#" class="button reload" url="<?php echo site_url().'/home/user/password'; ?>" onclick="batal($(this)); return false;"><span><span class="icon"></span>&nbsp; Batal &nbsp;</span></a></div>
</div>
</div>
