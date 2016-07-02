<?php  if ( ! defined('BASEPATH')) exit();?>
<style type="text/css">
.blok_error{
width:605px;
height:140px;
margin:160px auto;
padding:10px;
text-align:justify;
color:#000;
font: 11px Tahoma;
}
.blok_error a{
	text-decoration:none;
	}
.blok_error a :hover{
	text-decoration:underline;
	}
h1{
font-size:1.2em;
font-weight:normal;
margin:0px 5px 5px 10px;
}
</style>
<div class="blok_error">
<center><b><?php echo $pesan?></b>
<br /><br /><h1>
Tunggu sebentar ... Anda akan diarahkan dalam beberapa saat. Jika tidak, <?php echo anchor($url,'klik disini.')?></h1><br />
<img src="<?php echo base_url(); ?>/images/bpom.png" /><br />
<img src="<?php echo base_url(); ?>/images/loading.gif" /></center><br />
</div>
<?php echo  redirect(''.$url.$this->uri->segment($seg),'refresh',302,5);?>
