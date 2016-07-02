<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR);?>
<div id="judulprofil" class="judul"></div>
<div class="content">
<div id="accordion">
    <h2 class="current">Edit Profil</h2>
    <form name="fprof" id="fprof" method="post" action="<?php echo $act; ?>" autocomplete="off">
    <table class="form_tabel">
    <tr><td class="td_left">Nama</td><td class="td_right"><input type="text" name="nama" id="nama_" class="stext" value="<?php echo $nama; ?>" rel="required" title="Nama Lengkap Anda" /></td></tr>
    <tr><td class="td_left">Jabatan</td><td class="td_right"><input type="text" name="jabatan" id="jabatan_" class="stext" value="<?php echo $jabatan; ?>" rel="required" title="Jabatan Anda" /></td></tr>
    <tr><td class="td_left">E-mail</td><td class="td_right"><input type="text" name="email" id="email_" class="stext" value="<?php echo $email; ?>" rel="required" title="Email Anda" /></td></tr>
    </table>
    </form>
    <div style="padding-left:5px; padding-bottom:10px;"><a href="#" class="button save" onclick="fpost('#fprof','',''); return false;"><span><span class="icon"></span>&nbsp; Simpan &nbsp;</span></a>&nbsp;<a href="#" class="button reload" url="<?php echo $batal; ?>" onclick="batal($(this)); return false;"><span><span class="icon"></span>&nbsp; Batal &nbsp;</span></a></div>
</div>
</div>
