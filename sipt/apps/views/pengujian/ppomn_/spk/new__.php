<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR); ?>
<div id="juduluji" class="judul"></div>
<div class="headersarana"><?php echo $judul; ?></div>
<?php 
if($existing > 0)
	$allowed = FALSE;
else
	$allowed = TRUE;
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
                        <tr>
                        	<td class="td_left">Nomor Surat Permintaan Uji</td>
                            <td class="td_right bold"><?php echo $dtspu[0]['UR_FORMAT']; ?></td>
                        </tr>
                        <tr>
                        	<td class="td_left">Tanggal Surat</td>
                            <td class="td_right bold"><?php echo $dtspu[0]['TANGGAL']; ?></td>
                        </tr>
                        <tr>
                        	<td class="td_left">Tanggal Surat Perintah Kerja</td>
                            <td class="td_right"><input type="text" class="sdate" title="Tanggal Surat Perintah Kerja" name="TANGGAL" rel="required" /></td>
                        </tr>
                        <tr class="row-petugas" ke="0" id="petugas">
                        	<td class="td_left">Ditujukan kepada Penyelia</td>
                            <td class="td_right"><input type="text" class="stext operator" rel="required" url="<?php echo site_url(); ?>/autocompletes/autocomplete/get_petugas_pengujian/3/<?php echo $spuid; ?>" title="Ketikan Nama Penyelia, kemudian tekan enter" /><input type="hidden" id="ippetugas-0" name="USER_ID[]" />&nbsp;<a href="#" class="addpetugas"><img src="<?php echo base_url(); ?>images/add.png" align="top" style="border:none" /></a><div style="padding-top:5px; font-size:9px; font-weight:bold;">Klik tanda plus disamping untuk menambah penyelia baru</div></td>
                        </tr>
                    </table>
					<h2 class="small garis">Detil Sampel</h2>
                    <div style="height:5px;"></div>
					<div>
					<?php
					$jml = count($arr);
					if($jml > 0){
						?>
                       <table class="tabelajax">
                   		 <tr class="head">
                       	   <th width="14">No</th>
                           <th width="300">Identitas Sampel</th>
                           <th>Parameter Uji</th>
                         </tr>
                       <?php 
                       $no = 1;
					   for($i=0; $i<$jml; $i++){
						   ?>
						   <tr>
								<td><?php echo $no; ?>.</td>
								<td><div><?php echo $arr[$i]['NAMA_SAMPEL']; ?></div><div><?php echo $sess['KODE']; ?></div>
                                <div>&bull; <?php echo $arr[$i]['UR_KATEGORI']; ?></div>
								<div>Bentuk Sediaan : <?php echo $arr[$i]['BENTUK_SEDIAAN']; ?></div></td>
								<td><input type="text" style="height:20px;" class="stext paramuji" title="Ketik nama parameter uji, kemudian tekan enter untuk menambahkan parameter uji" id="<?php echo $arr[$i]['KATEGORI']; ?>" url="<?php echo site_url(); ?>/autocompletes/autocomplete/get_jenis_pengujian/<?php echo $arr[$i]['KATEGORI']; ?>"  ke="<?php echo $i; ?>" spl="<?php echo $arr[$i]['KODE_SAMPEL']; ?>"/>
                                	<div>
									<ul style="margin:0px; padding:0px; list-style:none;" id="param_ke_<?php echo $i; ?>" ></ul>
									</div>
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
					<input type="hidden" name="komoditi" value="<?php echo $komoditi; ?>" />
					<input type="hidden" name="jenis_uji" value="<?php echo $jenis_uji; ?>" />
					<input type="hidden" name="spuid" value="<?php echo $spuid; ?>" />
					</form>
				</div>
         </div>
	</div>
	
	<div style="height:10px;">&nbsp;</div>
	<div style="padding-left:5px;"><a href="#" class="button check" onclick="fpost('#fspk','',''); return false;"><span><span class="icon"></span>&nbsp; Proses &nbsp;</span></a>&nbsp;<a href="#" class="button reload" url="<?php echo $batal; ?>" onclick="batal($(this)); return false;"><span><span class="icon"></span>&nbsp; Batal &nbsp;</span></a></div>
	<div style="height:10px;">&nbsp;</div>

</div>       
</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$('input.sdate').datepicker({ dateFormat: 'dd/mm/yy',regional: 'id'});
	$("input.operator").autocomplete($("input.operator").attr('url'), {width: 244, selectFirst: false});
	$("input.operator").result(function(event, data, formatted){
		if(data){
			var ke = parseInt($(this).closest("tr").attr("ke"));
			$(this).val(data[2]);
			$("#ippetugas-"+ke).val(data[1]);
		}
	});
	$(".addpetugas").live("click", function(){
		var ke = $(this).closest("tr").attr("ke");
		var jml = $("tr.row-petugas").length;
		var str = '<tr id="row-petugas" ke="'+(jml+1)+'" id="petugas'+(jml+1)+'"><td class="td_left">&nbsp;</td><td class="td_right"><input type="text" class="stext operator" url="<?php echo site_url(); ?>/autocompletes/autocomplete/get_petugas_pengujian/3/<?php echo $spuid; ?>" rel="required" title="Ketikan Nama Penyelia, kemudian tekan enter" /><input type="hidden" id="ippetugas-'+(jml+1)+'" name="USER_ID[]" />&nbsp;<a href="#" class="removepetugas"><img src="<?php echo base_url(); ?>images/cancel.png" align="top" style="border:none" /></a></td></tr>';
		$("tr#petugas").after(str);
		$("input.operator").autocomplete($("input.operator").attr('url'), {width: 244, selectFirst: false});
		$("input.operator").result(function(event, data, formatted){
			if(data){
				var ke = parseInt($(this).closest("tr").attr("ke"));
				$(this).val(data[2]);
				$("#ippetugas-"+ke).val(data[1]);
			}
		});
		return false;
	});
	$(".removepetugas").live("click", function(){
		var tr = $(this).closest("tr").attr("id");
		$("#"+tr).remove();
		return false;
	});
	$("input.paramuji").each(function(){
		$(this).autocomplete($(this).attr('url'), {width: 244, selectFirst: false});
		$(this).result(function(event, data, formatted){
			if(data){
				var spl = $(this).attr("spl");
				var ke = parseInt($(this).attr("ke"));
				var idli = data[1]+data[7]+data[8]+ke;
				$("ul#param_ke_"+ke).append('<li style="padding-bottom:5px; border-bottom:1px solid #ccc;" id="'+idli+'"><div>&bull; Parameter : '+data[2]+'</div><div>&bull; Metode : '+data[3]+'</div><div>&bull; Syarat : '+data[5]+'</div><div>&bull; Pustaka : '+data[4]+'</div><div>&bull; Ruang Lingkup : '+data[6]+'</div><div><a href="#"><img src="<?php echo base_url(); ?>images/cancel.png" align="top" style="border:none" title="Hapus parameter uji" onclick="$(\'ul#param_ke_'+ke+' li#' + idli+ '\').remove(); return false;" /></a>&nbsp;Hapus Parameter</div><input type="hidden" name="UJI[PARAMETER_UJI][]" value="'+data[2]+'"><input type="hidden" name="UJI[METODE][]" value="'+data[3]+'"><input type="hidden" name="UJI[SYARAT][]" value="'+data[5]+'"><input type="hidden" name="UJI[RUANG_LINGKUP][]" value="'+data[6]+'"><input type="hidden" name="UJI[PUSTAKA][]" value="'+data[4]+'"><input type="hidden" name="UJI[KODE_SAMPEL][]" value="'+spl+'"><input type="hidden" name="SRL_ID[]" value="'+data[1]+'"></li>'); 
				$(this).val(''); 
				$(this).focus();
			}
		})
	});
});
function set_params(obj){
	$(obj).autocomplete($(obj).attr('url'), {width: 244, selectFirst: false});
	$(obj).result(function(event, data, formatted){
		if(data){
			var spl = $(obj).attr("spl");
			var ke = parseInt($(obj).attr("ke"));
			var idli = data[1]+data[7]+data[8]+ke;
			$("ul#param_ke_"+ke).append('<li style="padding-bottom:5px; border-bottom:1px solid #ccc;" id="'+idli+'"><div>&bull; Parameter : '+data[2]+'</div><div>&bull; Metode : '+data[3]+'</div><div>&bull; Syarat : '+data[5]+'</div><div>&bull; Pustaka : '+data[4]+'</div><div>&bull; Ruang Lingkup : '+data[6]+'</div><div><a href="#"><img src="<?php echo base_url(); ?>images/cancel.png" align="top" style="border:none" title="Hapus parameter uji" onclick="$(\'ul#param_ke_'+ke+' li#' + idli+ '\').remove(); return false;" /></a>&nbsp;Hapus Parameter</div><input type="hidden" name="UJI[PARAMETER_UJI][]" value="'+data[2]+'"><input type="hidden" name="UJI[METODE][]" value="'+data[3]+'"><input type="hidden" name="UJI[SYARAT][]" value="'+data[5]+'"><input type="hidden" name="UJI[RUANG_LINGKUP][]" value="'+data[6]+'"><input type="hidden" name="UJI[PUSTAKA][]" value="'+data[4]+'"><input type="hidden" name="UJI[KODE_SAMPEL][]" value="'+spl+'"><input type="hidden" name="SRL_ID[]" value="'+data[1]+'"></li>'); 
			$(obj).val(''); 
			$(obj).focus();
		}
	});
}
</script>
<?php
}
?>            