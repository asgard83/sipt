<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR); ?>
<div id="juduluji" class="judul"></div>
<div class="headersarana"><?php echo $judul; ?></div>
<?php 
if(in_array('B1',$this->newsession->userdata('SESS_SUB_SARANA')) || in_array('B2',$this->newsession->userdata('SESS_SUB_SARANA'))){
	if($existing[0] == 1 && $existing[2] == 2)
		$allowed = FALSE;
	else
		$allowed = TRUE;
}else{
	if($existing[1] == 1 && $existing[2] == 2)
		$allowed = FALSE;
	else
		$allowed = TRUE;
}

if(!$allowed){
?>
<div class="content">
    <div class="adCntnr">
    	<div class="acco2">
        	<div class="expand"><a title="expand/collapse" href="#" style="display: block;">SURAT PERINTAH KERJA</a></div>
                <div class="accCntnt">
				<h2 class="small garis">Surat perintah kerja sudah dibuat.</h2>
				<div style="padding-left:5px;"><a href="#" class="button back" url="<?php echo $batal; ?>" onclick="batal($(this)); return false;"><span><span class="icon"></span>&nbsp; Kembali &nbsp;</span></a></div>
				</div>
		</div>
	</div>
</div>
<?php
}else{
?>
<div class="content">
    <div class="adCntnr">
    	<div class="acco2">
        	<div class="expand"><a title="expand/collapse" href="#" style="display: block;">SURAT PERINTAH KERJA</a></div>
                <div class="accCntnt">
				<h2 class="small garis">Informasi Data Surat Perintah Kerja</h2>
				<form name="fspk" id="fspk" method="post" action="<?php echo $act; ?>" autocomplete="off">
					<table class="form_tabel">
                        <tr><td class="td_left">Tanggal Surat Perintah Kerja</td><td class="td_right"><input type="text" class="sdate" title="Tanggal Surat Perintah Kerja" name="SPK[TANGGAL]" rel="required" /></td></tr>
                        <tr><td class="td_left petugas">Ditujukan Kepada</td><td class="td_right"><input type="text" class="stext operator"  url="<?php echo site_url(); ?>/autocompletes/autocomplete/get_petugas_pengujian/3" title="Ketikan Nama Penyelia, kemudian tekan enter" /></td></tr>
                        <tr><td class="td_left">&nbsp;</td><td class="td_right"><ul style="list-style:none; margin:0px; padding:0px;" id="urut0"></ul></td></tr>
                    </table>
					<h2 class="small garis">Detil Sampel</h2>
                    <div style="height:5px;"></div>
					<div>
					<?php
					$jml = count($arr);
					if($jml > 0){
						?>
                       <table class="tabelajax">
                       <tr class="head"><th width="14">No</th><th width="300">Identitas Sampel</th><th width="300">Parameter Uji</th></tr>
                       <?php 
                       $no = 1;
					   for($i=0; $i<$jml; $i++){
						   $kode_sampel = substr($arr[$i]['KODE_SAMPEL'],0,2).'.'.substr($arr[$i]['KODE_SAMPEL'],2,2).'.'.substr($arr[$i]['KODE_SAMPEL'],4,2).'.'.substr($arr[$i]['KODE_SAMPEL'],6,2).'.'.substr($arr[$i]['KODE_SAMPEL'],8,2).'.'.substr($arr[$i]['KODE_SAMPEL'],10,4).'.'.substr($arr[$i]['KODE_SAMPEL'],14,2);
						   ?>
						   <tr>
								<td><?php echo $no; ?></td>
								<td><div><?php echo $arr[$i]['NAMA_SAMPEL']; ?><div><div><?php echo $kode_sampel; ?><?php /*?><input type="hidden" name="UJI[KODE_SAMPEL][]" value="<?php echo $arr[$i]['KODE_SAMPEL']; ?>" /><?php */?></div>
                                <div>&bull; <?php echo $arr[$i]['KOMODITI']; ?></div>
                                <div>&bull; <?php echo $arr[$i]['SUB_KOMODITI']; ?></div><div>&bull; <?php echo $arr[$i]['SUB_SUBKOMODITI']; ?></div>
								<div>Bentuk Sediaan : <?php echo $arr[$i]['BENTUK_SEDIAAN']; ?></div></td>
								<td><div><input type="text" style="height:20px;" class="stext paramuji" title="Ketik nama parameter uji, kemudian tekan enter untuk menambahkan parameter uji" url="<?php echo site_url(); ?>/autocompletes/autocomplete/get_jenis_pengujian/<?php echo $arr[$i]['KLASIFIKASI']; ?>/<?php echo $arr[$i]['SUB_KLASIFIKASI']; ?>/<?php echo $arr[$i]['SUB_SUB_KLASIFIKASI']; ?>" ke="<?php echo $i; ?>" spl="<?php echo $arr[$i]['KODE_SAMPEL']; ?>"/></div>
                                	<ul style="margin:0px; padding:0px; list-style:none;" id="param_ke_<?php echo $i; ?>" ></ul>
                                </td>
						   <?php
						   $no++;
					   }
                       ?>
                    </table>
                        <?php
					}else{
						?>
                        <b>Tidak Ada Data Sampel</b>
                        <?php
					}
					?>
					</div>
					<div style="height:10px;">&nbsp;</div>
                <div style="padding-left:5px;"><a href="#" class="button check" onclick="fpost('#fspk','',''); return false;"><span><span class="icon"></span>&nbsp; Proses &nbsp;</span></a>&nbsp;<a href="#" class="button reload" url="<?php echo $batal; ?>" onclick="batal($(this)); return false;"><span><span class="icon"></span>&nbsp; Batal &nbsp;</span></a></div>
                <input type="hidden" name="komoditi" value="<?php echo $komoditi; ?>" />
                <input type="hidden" name="jenis_uji" value="<?php echo $jenis_uji; ?>" />
                <input type="hidden" name="spuid" value="<?php echo $spuid; ?>" />
				</form>
				</div>
         </div>
	</div>
</div>       
</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$('input.sdate').datepicker({ dateFormat: 'dd/mm/yy',regional: 'id'});
	$("input.operator").autocomplete($("input.operator").attr('url'), {width: 244, selectFirst: false});
	$("input.operator").result(function(event, data, formatted){
		if(data){
			$("ul#urut0").append('<li style="padding-bottom:5px;" id="'+data[1]+'"><input type="text" class="stext" value="'+data[2]+'" readonly>&nbsp;&nbsp;<a href="#"><img src="<?php echo base_url(); ?>images/cancel.png" align="top" style="border:none" title="Hapus Petugas" onclick="$(\'ul#urut0 li#' + data[1]+ '\').remove();" /></a><input type="hidden" name="USER_ID[]" value="'+data[1]+'"></li>'); 
			$(this).val(''); $(this).focus();
		}
	});
	$("input.paramuji").autocomplete($("input.paramuji").attr('url'), {width: 244, selectFirst: false});
	$("input.paramuji").result(function(event, data, formatted){
		if(data){
			var spl = $(this).attr("spl");
			var ke = parseInt($(this).attr("ke"));
			var idli = data[1]+data[7]+data[8]+ke;
			$("ul#param_ke_"+ke).append('<li style="padding-bottom:5px; border-bottom:1px solid #ccc;" id="'+idli+'"><div>&bull; Parameter : '+data[2]+'</div><div>&bull; Metode : '+data[3]+'</div><div>&bull; Syarat : '+data[5]+'</div><div>&bull; Pustaka : '+data[4]+'</div><div>&bull; Ruang Lingkup : '+data[6]+'</div><div><a href="#"><img src="<?php echo base_url(); ?>images/cancel.png" align="top" style="border:none" title="Hapus parameter uji" onclick="$(\'ul#param_ke_'+ke+' li#' + idli+ '\').remove(); return false;" /></a>&nbsp;Hapus Parameter</div><input type="hidden" name="UJI[PARAMETER_UJI][]" value="'+data[2]+'"><input type="hidden" name="UJI[METODE][]" value="'+data[3]+'"><input type="hidden" name="UJI[SYARAT][]" value="'+data[5]+'"><input type="hidden" name="UJI[RUANG_LINGKUP][]" value="'+data[6]+'"></li><input type="hidden" name="UJI[PUSTAKA][]" value="'+data[4]+'"><input type="hidden" name="UJI[KODE_SAMPEL][]" value="'+spl+'"></li>'); 
			$(this).val(''); 
			$(this).focus();
		}
	});
});
</script>
<?php
}
?>            