<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR); ?>
<div id="juduluji" class="judul"></div>
<div class="headersarana"><?php echo $judul; ?></div>
<div class="content">
    <div class="adCntnr">
    	<div class="acco2">
        	<div class="expand"><a title="expand/collapse" href="#" style="display: block;">SURAT PERINTAH PENGUJIAN</a></div>
                <div class="accCntnt">
                <h2 class="small garis">Informasi Data Surat Perintah Pengujian</h2>
                    <form name="fspp" id="fspp" method="post" action="<?php echo $act; ?>" autocomplete="off">
                    <table class="form_tabel">
                        <tr><td class="td_left">Tanggal Surat Perintah Pengujian</td><td class="td_right"><input type="text" class="sdate" title="Tanggal Surat Perintah Kerja" name="SPP[TANGGAL]" rel="required" /></td></tr>
                    </table>
                    <h2 class="small garis">Daftar Penguji dan Sampel</h2>
					<?php
					$arruji = count($penguji);
					if($arruji > 0){
						for($x = 0; $x < $arruji; $x++){
							?>
								<div style="padding-bottom:5px;">
									<div style="padding-bottom:5px; margin-left:18px;"><b>Penguji</b></div>
									<div><input type="checkbox" name="SPP_SAMPEL[PENGUJI][]" class="chk_penguji" value="<?php $penguji[$i]['USER_ID']; ?>" />&nbsp;&nbsp;<?php echo $penguji[$x]['NAMA_USER']; ?></div>
								</div>
								<div>
									<?php
									$jml = count($arr);
									if($jml > 0){
										?>
									   <table class="newtableajax" id="list<?php $x; ?>">
									   <thead><tr class="head"><th width="13">&nbsp;</th><th width="16">No</th><th width="75">Kode Sampel</th><th width="250">Nama Sampel</th><th width="250">Komoditi</th><th>Parameter Uji</th></tr></thead>
									   <tbody>
									   <?php 
									   $no = 1;
									   for($i=0; $i<$jml; $i++){
										   ?>
										   <tr>
												<td><input type="checkbox" name="UJI_ID[]" value="<?php echo $arr[$i]['UJI_ID']; ?>" class="chk_sampel" id="<?php echo $arr[$i]['UJI_ID']; ?>" /></td>
												<td><?php echo $no; ?></td>
												<td><?php echo $arr[$i]['KODE_SAMPEL']; ?></td>
												<td><?php echo $arr[$i]['NAMA_SAMPEL']; ?></td>
												<td><?php echo $arr[$i]['KOMODITI']; ?></td>
												<td><?php echo $arr[$i]['PARAM']; ?></td>
										  </tr>      
										   <?php
										   $no++;
									   }
									   ?>
									   </tbody>
									<tfoot><tr class="title"><td colspan="6"></td></tr></tfoot>
									</table>
										<?php
									}else{
										?>
										<b>Tidak Ada Data Sampel</b>
										<?php
									}
									?>
								</div>
								<div style="height:10px;"></div>
							<?php
						}
					}else{
						?>
						<div>Data penguji tidak ditemukan, silahkan menghubungi administrator atau admin balai</div>
						<?php
					}
					?>
                    <div style="height:5px;"></div>
					<input type="hidden" name="jenis_uji" value="<?php echo $jenis_uji; ?>" />
					<input type="hidden" name="spuid" value="<?php echo $spuid; ?>" />
                </form>
            </div><!-- Akhir Informasi SPU!-->
        </div>
		<div style="height:10px;">&nbsp;</div>
		<div style="padding-left:5px;"><a href="#" class="button check" onclick="fpost('#fspp','',''); return false;"><span><span class="icon"></span>&nbsp; Proses &nbsp;</span></a>&nbsp;<a href="#" class="button reload" url="<?php echo $batal; ?>" onclick="batal($(this)); return false;"><span><span class="icon"></span>&nbsp; Batal &nbsp;</span></a></div>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$('input.sdate').datepicker({ dateFormat: 'dd/mm/yy',regional: 'id'});
	$("input.metode").autocomplete($("input.metode").attr('url') + $("input.metode").attr("kk"), {width: 244, selectFirst: false});
	$("input.metode").result(function(event, data, formatted){
		if(data){
			$(this).val(data[0]);
		}
	});
	$(".newtableajax tbody tr").mouseover(function(){
		$(this).addClass("hilite");
		if($(this).next().hasClass('tdmenu')){
			$(this).next().addClass("hilite");
		}else if($(this).hasClass('tdmenu')){
			$(this).prev().addClass("hilite");
		}
   	});
	$(".newtableajax tbody tr").mouseout(function(){
		$(this).removeClass("hilite");
		if($(this).next().hasClass('tdmenu')){
			$(this).next().removeClass("hilite");
		}else if($(this).hasClass('tdmenu')){
			$(this).prev().removeClass("hilite");
		}
	});
});
</script>            