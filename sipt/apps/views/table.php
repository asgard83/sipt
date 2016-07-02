<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<div id="<?php echo $idjudul; ?>" class="judul"></div>
<div class="content">
<div id="accordion">
	<h2 class="current"><?php echo $caption_header; ?></h2>
    <?php 
		if($search){
			echo $frmsearch;
		}
		echo $table; 
	?>
</div>
<?php
if($batal != "" && $cancel != ""){
?>
	<div style="height:5px;"></div><div style="padding-left:5px; padding-bottom:5px;"><a href="#" class="button back" url="<?php echo $batal; ?>" onclick="batal($(this)); return false;" ><span><span class="icon"></span>&nbsp; <?php echo $cancel; ?> &nbsp;</span></a></div>
<?php
}
?>

</div>




