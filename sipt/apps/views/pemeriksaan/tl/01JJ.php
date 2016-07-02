<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);
?>
<input type="hidden" name="TL[BBPOM_ID]" value="<?php echo $this->newsession->userdata('SESS_BBPOM_ID'); ?>" />
<table class="form_tabel" id="tb_pelanggaran">
	<tr ><td class="td_left">Perihal</td><td class="td_right"><?php echo form_dropdown('TL[PERIHAL]',$perihal,$sess_['PERIHAL'],'class="stext" rel="required" title="Perihal Surat"'); ?></td></tr>
    <tr><td colspan="2" style="padding:3px;">Pelanggaran tersebut merupakan pelanggaran terhadap ketentuan sebagai berikut :</td></tr>
	<?php
	$jmldata = count($jml_point);
	if($jmldata==0){
		$jmldata = 1;
		$jml_point[] = "";
	}
	$i = 0;
	do{
	?>  
    <tr class="urut<?php echo $i; ?>"><td class="td_left">&nbsp;</td><td class="td_right">
    	<div style="padding-bottom:5px;"><?php echo form_dropdown('TL[POINT][]',$point,$jml_point[$i],'class="stext" title="Jenis Pelanggaran"'); ?>&nbsp;&nbsp;
        <?php
        if($i==0){
        ?>
            <a href="#" class="addpoint" periksa="urut" terakhir="<?php echo $jmldata; ?>"><img src="<?php echo base_url(); ?>images/add.png" align="absmiddle" style="border:none" title="Klik disini untuk menambah point pelanggaran" /></a>
        <?php
        }else{
        ?>
            <a href="#" class="min" onclick="$('.urut<?php echo  $i; ?>').remove(); return false;"><img src="<?php echo base_url(); ?>images/cancel.png" align="absmiddle" style="border:none" title="Klik disini untuk membatalkan atau menghapus point pelanggaran" /></a>
        <?php
        }
        ?> 
        </div>
        <div style="padding-bottom:5px;"><textarea name="TL[PELANGGARAN][]" class="stext chk" title="Penjelasan pelanggaran"><?php echo $pelanggaran[$i]; ?></textarea></div>
    </td></tr>
    <?php
	$i++;
	}while($i<$jmldata);
	?>
</table>
<table class="form_tabel">
    <tr><td colspan="2">Terhadap pelanggaran tersebut sesuai dengan ketentuan pada :</td></tr>
    <tr><td class="td_left">&nbsp;</td><td class="td_right"><textarea name="TL[KETENTUAN]" class="stext chk" title="Penjelasan pelanggaran berdasarkan ketentuan" id="KETENTUAN"><?php echo $sess_['KETENTUAN']; ?></textarea></td></tr>
    <tr><td class="td_left">Jenis Tindakan</td><td class="td_right"><?php echo form_dropdown('TL[TINDAKAN]',$tsurat,$sess_['TINDAKAN'],'class="stext" title="Jenis tindakan atau peringatan yang diberikan"'); ?></td></tr>
    <tr><td class="td_left">Keterangan Tindakan</td><td class="td_right"><textarea name="TL[KETERANGAN]" class="stext chk" title="Penjelasan pelanggaran dari tindakan"><?php echo $sess_['KETERANGAN']; ?></textarea></td></tr>
</table>

<script type="text/javascript">
	$(document).ready(function(){
        $(".addpoint").click(function(){ 
			var nom = $(this).attr("terakhir");
			if(nom < 6){
				var idtr = $(this).attr("periksa"); 
				var cls = idtr + nom; 
				$("#tb_pelanggaran").append('<tr class= "' + cls + '"><td class="left">&nbsp;</td><td class="td_right"><div style="padding-bottom:5px;"><?php echo str_replace(chr(10),'',form_dropdown('TL[POINT][]',$point,'','class="stext" title="Jenis Pelanggaran"')); ?>&nbsp;&nbsp;<a href="#" class="min" onclick="$(\'.' + cls + '\').remove(); return false;"><img src="<?php echo base_url(); ?>images/cancel.png" align="absmiddle" style="border:none" title="Klik disini untuk membatalkan atau menghapus point pelanggaran" /></a></div><div style="padding-bottom:5px;"><textarea name="TL[PELANGGARAN][]" class="stext chk" title="Penjelasan pelanggaran" id="PELANGGARAN'+nom+'"></textarea></div></td></tr>');
				$(this).attr('terakhir', parseInt(nom) + 1);
				create_ck('#PELANGGARAN'+nom,505);
				return false;
			}
		});
    });
</script>