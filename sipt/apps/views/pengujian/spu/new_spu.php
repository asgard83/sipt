<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR); ?>

<div id="juduluji" class="judul"></div>
<div class="headersarana"><?php echo $judul; ?></div>
<div class="content">
  <div class="adCntnr">
    <div class="acco2">
      <div class="expand"><a title="expand/collapse" href="#" style="display: block;">SURAT PERINTAH UJI</a></div>
      <div class="accCntnt">
        <h2 class="small garis">Informasi Data Surat Perintah Uji</h2>
        <form name="fspu" id="fspu" method="post" action="<?php echo $act; ?>" autocomplete="off">
          <table class="form_tabel">
            <tr>
              <td class="td_left">Tanggal Terima Sampel</td>
              <td class="td_right"><b><?php echo $sess['TANGGAL_TERIMA']; ?></b></td>
            </tr>
            <tr>
              <td class="td_left">Nomor Surat Permintaan Uji</td>
              <td class="td_right"><?php
						 $no_spu = substr($sess['SPU_GENERATE'],0,3).".".substr($sess['SPU_GENERATE'],3,2).".".substr($sess['SPU_GENERATE'],5,2).".".substr($sess['SPU_GENERATE'],7,2).".".substr($sess['SPU_GENERATE'],9,2).".".substr($sess['SPU_GENERATE'],11,2).".".substr($sess['SPU_GENERATE'],13,4);
						 ?>
                <b><?php echo $no_spu; ?></b></td>
            </tr>
            <tr>
              <td class="td_left">Tanggal Surat Perintah Uji</td>
              <td class="td_right"><input type="text" class="sdate" title="Tanggal Surat Perintah Uji" rel="required" name="PERINTAH_UJI[TANGGAL_PERINTAH]" /></td>
            </tr>
            <tr>
              <td class="td_left petugas">Ditujukan Kepada</td>
              <td class="td_right"><input type="text" class="stext operator"  url="<?php echo site_url(); ?>/autocompletes/autocomplete/get_petugas_pengujian/4/<?php echo $sess['SPU_GENERATE']; ?>" title="Ketikan Nama Manager Teknis, kemudian tekan enter" /></td>
            </tr>
            <tr>
              <td class="td_left">&nbsp;</td>
              <td class="td_right"><ul style="list-style:none; margin:0px; padding:0px;" id="urut0">
                </ul></td>
            </tr>
          </table>
          <div style="height:20px;">&nbsp;</div>
          <div style="padding-left:5px;"><a href="#" class="button save" onclick="fpost('#fspu','',''); return false;"><span><span class="icon"></span>&nbsp; Simpan &nbsp;</span></a>&nbsp;<a href="#" class="button reload" url="<?php echo $batal; ?>" onclick="batal($(this)); return false;"><span><span class="icon"></span>&nbsp; Batal &nbsp;</span></a></div>
          <input type="hidden" name="SPU_ID" value="<?php echo $sess['SPU_GENERATE']; ?>" />
          <input type="hidden" name="KLASIFIKASI" value="<?php echo $sess['KLASIFIKASI']; ?>" />
        </form>
        <div style="height:5px;"></div>
        <h2 class="small garis">Detil Sampel</h2>
        <div style="height:5px;"></div>
        <div> <?php echo $tabel; ?> </div>
      </div>
      <!-- Akhir Informasi SPU!--> 
      
    </div>
  </div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$('input.sdate').datepicker({ dateFormat: 'dd/mm/yy',regional: 'id', maxDate: new Date()});
	$("input.operator").autocomplete($("input.operator").attr('url'), {width: 244, selectFirst: false});
	$("input.operator").result(function(event, data, formatted){
		if(data){
			$("ul#urut0").append('<li style="padding-bottom:5px;" id="'+data[1]+'"><input type="text" class="stext" value="'+data[2]+'" readonly>&nbsp;&nbsp;<a href="#"><img src="<?php echo base_url(); ?>images/cancel.png" align="top" style="border:none" title="Hapus Petugas" onclick="$(\'ul#urut0 li#' + data[1]+ '\').remove();" /></a><input type="hidden" name="USER_ID[]" value="'+data[1]+'"></li>'); 
			$(this).val(''); $(this).focus();
		}
	});
});
</script> 