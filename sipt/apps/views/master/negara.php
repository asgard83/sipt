<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<div id="judulnegara" class="judul"></div>
<div class="content">
<form name="fnegara_" id="fnegara_" method="post" action="<?php echo $act; ?>" autocomplete="off"> 
<div class="kotak">
<div class="spjudul">MASTER NEGARA</div>
<table>
<tr>
  <td colspan="2" class="atas" width="130">Kode Negara</td>
  <td width="30"></td><td><input type="text" class="stext" name="kodenegara_" id="kodenegara_" /></td>
</tr>
<tr>
  <td colspan="2" class="atas">Nama Negara</td>
  <td></td><td><input type="text" class="stext" name="namanegara_" id="namanegara_" /></td>
</tr>
</table>
</div>
<div><input type="submit" id="btncancel" class="cancelnegara" value="" url="<?php echo $urlbacknegara; ?>" /><input type="submit" id="btnsave" class="savenegara" value="" />
</div>
</form>
</div>

<div id="juduldata" class="judul"></div>
<div class="content">
	<div class="data">
		&bull; Master Negara - <a href="<?php echo $urllistview; ?>"><?php echo $jumlah; ?></a>
    </div>
 </div>
<div id="clear_fix"></div>
