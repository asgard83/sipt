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
                    <h2 class="small garis">Detil Sampel</h2>
                    <div style="height:5px;"></div>
                    <div>
                    <?php
					$jml = count($arr);
					if($jml > 0){
						?>
                       <table class="tabelajax">
                       <tr class="head"><th width="16">No</th><th width="250">Identitas Sampel<th width="200">Parameter Uji</th><th width="250">Metode & Pustaka</th><th width="250">Petugas Uji</th></tr>
                       <?php 
                       $no = 1;
					   for($i=0; $i<$jml; $i++){
						   $kode_sampel = substr($arr[$i]['KODE_SAMPEL'],0,2).'.'.substr($arr[$i]['KODE_SAMPEL'],2,2).'.'.substr($arr[$i]['KODE_SAMPEL'],4,2).'.'.substr($arr[$i]['KODE_SAMPEL'],6,2).'.'.substr($arr[$i]['KODE_SAMPEL'],8,2).'.'.substr($arr[$i]['KODE_SAMPEL'],10,4).'.'.substr($arr[$i]['KODE_SAMPEL'],14,2);
						   ?>
						   <tr>
								<td><?php echo $no; ?></td>
								<td>
                                	<div><?php echo $arr[$i]['NAMA_SAMPEL']; ?></div>
                                    <div>&bull; Kode Sampel : <?php echo $kode_sampel; ?><input type="hidden" name="SPP_SAMPEL[UJI_ID][]" value="<?php echo $arr[$i]['UJI_ID']; ?>" /></div>
                                    <div>&bull; Komoditi : <?php echo $arr[$i]['KOMODITI']; ?></div>
                                    <div>&bull; Bentuk Sediaan : <?php echo $arr[$i]['BENTUK_SEDIAAN']; ?></div>
                                </td>
								<td><?php echo $arr[$i]['PARAM']; ?></td>
                                <td><?php echo $arr[$i]['METODE']; ?></td>
                                <td><input type="text" style="height:20px;" class="stext uji" title="Ketikan nama petugas penguji, kemudian enter" ke="<?php echo $no; ?>" url="<?php echo site_url(); ?>/autocompletes/autocomplete/get_petugas_uji/2" rel="required" /><input type="hidden" name="SPP_SAMPEL[PENGUJI][]" id="petugas<?php echo $no; ?>" /></td>
                          </tr>      
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
					<div style="padding-left:5px;"><a href="#" class="button check" onclick="fpost('#fspp','',''); return false;"><span><span class="icon"></span>&nbsp; Proses &nbsp;</span></a>&nbsp;<a href="#" class="button reload" url="<?php echo $batal; ?>" onclick="batal($(this)); return false;"><span><span class="icon"></span>&nbsp; Batal &nbsp;</span></a></div>
					<input type="hidden" name="jenis_uji" value="<?php echo $jenis_uji; ?>" />
					<input type="hidden" name="spuid" value="<?php echo $spuid; ?>" />
                </form>
            </div><!-- Akhir Informasi SPU!-->
        </div>
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
	$("input.uji").autocomplete($("input.uji").attr('url'), {width: 244, selectFirst: false});
	$("input.uji").result(function(event, data, formatted){
		if(data){
			var ke = $(this).attr("ke");
			$("#petugas"+ke).val(data[1]);
			$(this).val(data[2]);
		}
	});
});
</script>            