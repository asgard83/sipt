<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR); ?>
<style>
.hideme {
	display: none;
}
</style>
<div id="juduluji" class="judul"></div>
<div class="content">
  <form action="<?php echo $act; ?>" method="post" autocomplete="off" id="m_srl">
    <div class="adCntnr">
      <div class="acco2">
        <div class="expand"><b>Standar Ruang Lingkup Pengujian</b></div>
        <div class="collapse">
          <div class="accCntnt">
            <table class="form_tabel">
              <tr>
                <td class="td_left">Bidang Pengujian</td>
                <td class="td_right"><?php echo form_dropdown('SRL[BIDANG_UJI]',$bidang,$sess['BIDANG_UJI'],'class="stext" rel="required" title="Bidang Pengujian"'); ?></td>
              </tr>
              <tr>
                <td class="td_left">Komoditi</td>
                <td class="td_right"><?php echo form_dropdown('GOLONGAN[]',$golongan,$sess['KOMODITI'],'class="stext kategori" rel="required" title="Kategori" ke="0" id="sel0"'); ?></td>
              </tr>
              <tr <?php echo (strlen($sess['KATEGORI']) == 4) ? '' : 'class="hideme"' ;?> id="tdanak1" ke="1">
                <td class="td_left">Sub Kategori</td>
                <td class="td_right"><?php echo form_dropdown('GOLONGAN[]',$kategori,$sess['KATEGORI'],'class="stext kategori" title="Sub Kategori" ke="1" id="sel1"'); ?></td>
              </tr>
              <tr <?php echo strlen($sess['SUB_KATEGORI']) == 6 ? '' : 'class="hideme"' ;?> id="tdanak2" ke="2">
                <td class="td_left">&nbsp;</td>
                <td class="td_right"><?php echo form_dropdown('GOLONGAN[]',$sub_kategori,$sess['SUB_KATEGORI'],'class="stext kategori" title="Sub Sub Kategori" ke="2" id="sel2"'); ?></td>
              </tr>
              <tr <?php echo strlen($sess['SUB_KATEGORI_1']) == 8 ? '' : 'class="hideme"' ;?> id="tdanak3" ke="3">
                <td class="td_left">&nbsp;</td>
                <td class="td_right"><?php echo form_dropdown('GOLONGAN[]',$sub_kategori_1,$sess['SUB_KATEGORI_1'],'class="stext kategori" title="Sub Sub Kategori" ke="3" id="sel3"'); ?></td>
              </tr>
              <tr <?php echo strlen($sess['SUB_KATEGORI_2']) == 10 ? '' : 'class="hideme"' ;?> id="tdanak4" ke="4">
                <td class="td_left">&nbsp;</td>
                <td class="td_right"><?php echo form_dropdown('GOLONGAN[]',$sub_kategori_2,$sess['SUB_KATEGORI_2'],'class="stext kategori" title="Sub Sub Kategori" ke="4" id="sel4"'); ?></td>
              </tr>
              <tr>
                <td class="td_left">Parameter Uji</td>
                <td class="td_right"><textarea class="stext" name="SRL[PARAMETER_UJI]" title="Parameter Uji" id="parameter-uji"><?php echo $sess['PARAMETER_UJI']; ?></textarea></td>
              </tr>
              <tr>
                <td class="td_left">Metode</td>
                <td class="td_right"><textarea class="stext" name="SRL[METODE]" title="Metode"><?php echo $sess['METODE']; ?></textarea></td>
              </tr>
              <tr>
                <td class="td_left">Pustaka</td>
                <td class="td_right"><textarea class="stext" name="SRL[PUSTAKA]" title="Syarat"><?php echo $sess['PUSTAKA']; ?></textarea></td>
              </tr>
              <tr>
                <td class="td_left">Syarat</td>
                <td class="td_right"><textarea class="stext" name="SRL[SYARAT]" title="Syarat"><?php echo $sess['SYARAT']; ?></textarea></td>
              </tr>
              <tr>
                <td class="td_left">Ruang Lingkup</td>
                <td class="td_right"><textarea class="stext" name="SRL[RUANG_LINGKUP]" title="Syarat"><?php echo $sess['RUANG_LINGKUP']; ?></textarea></td>
              </tr>
            </table>
          </div>
        </div>
      </div>
      <div style="padding:10px;"></div>
      <div><a href="#" class="button save" onclick="fpost('#m_srl','',''); return false;"><span><span class="icon"></span>&nbsp; <?php echo $save; ?> &nbsp;</span></a>&nbsp;<a href="#" class="button reload" onclick="window.history.back(); return false;" ><span><span class="icon"></span>&nbsp; <?php echo $cancel; ?> &nbsp;</span></a></div>
    </div>
    <div style="padding:10px;"></div>
    <input type="hidden" name="ID" value="<?php echo $id; ?>" />
  </form>
</div>
<script type="text/javascript">
	$(document).ready(function(){ 
		$('select.kategori').change(function(){
			var ke = $(this).attr('ke');
			var kunci = $(this).val();
			//console.log(kunci);
			ke = parseInt(ke) + 1;
			for(i=ke;i<=5;i++){
				$('#tdanak' + i).hide();
			}
			$.get('<?php echo site_url().'/autocompletes/autocomplete/get_kategori/'; ?>' + kunci + '/0', function(hasil){	  
				var hasil = hasil.replace(' ', '');
				var jum = hasil.length;
				if(jum==0){
					$('#tdanak' + ke).hide();
					$('#sel' + ke).removeAttr("rel");
				}else{
					$('#tdanak' + ke).show();
					$('#sel' + ke).html(hasil);
					$('#sel' + ke).attr("rel","required");
				}
			});
			if(kunci == '10' || kunci == '11'){
				$("#parameter-uji").attr("url",'<?php echo site_url(); ?>/autocompletes/autocomplete/get_list_param');
				$("#parameter-uji").autocomplete($("#parameter-uji").attr("url"), {width: 249, selectFirst: false, multiple: false, matchContains: true});
			}else{
				$("#parameter-uji").removeAttr("url");
				$("#parameter-uji").val('');
			}
		});
	});
</script> 
