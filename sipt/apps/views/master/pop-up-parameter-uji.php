<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR); ?>
<link type="text/css" href="<?php echo base_url();?>css/css.css" rel="stylesheet" />
<style>
.hideme {
	display:none;
}
</style>
<div class="content">
  <div class="adCntnr">
    <div class="acco2">
      <div class="expand"><a title="expand/collapse" href="#" style="display: block;">STANDAR RUANG LINGKUP</a></div>
      <div class="accCntnt">
        <h2 class="small garis">Edit Standar Ruang Lingkup</h2>
        <form action="<?php echo $act; ?>" method="post" autocomplete="off" id="m_srl_pop_up">
          <div class="adCntnr">
            <div class="acco2">
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
                  <td class="td_right"><textarea rel="required" class="stext" name="SRL[PARAMETER_UJI]" title="Parameter Uji"><?php echo $sess['PARAMETER_UJI']; ?></textarea></td>
                </tr>
                <tr>
                  <td class="td_left">Metode</td>
                  <td class="td_right"><textarea rel="required" class="stext" name="SRL[METODE]" title="Metode"><?php echo $sess['METODE']; ?></textarea></td>
                </tr>
                <tr>
                  <td class="td_left">Pustaka</td>
                  <td class="td_right"><textarea rel="required" class="stext" name="SRL[PUSTAKA]" title="Syarat"><?php echo $sess['PUSTAKA']; ?></textarea></td>
                </tr>
                <tr>
                  <td class="td_left">Syarat</td>
                  <td class="td_right"><textarea rel="required" class="stext" name="SRL[SYARAT]" title="Syarat"><?php echo $sess['SYARAT']; ?></textarea></td>
                </tr>
                <tr>
                  <td class="td_left">Ruang Lingkup</td>
                  <td class="td_right"><textarea class="stext" name="SRL[RUANG_LINGKUP]" title="Syarat"><?php echo $sess['RUANG_LINGKUP']; ?></textarea></td>
                </tr>
                <tr>
                  <td class="td_left">Data Prioritas</td>
                  <td class="td_right"><?php echo form_dropdown('SRL[PRIORITAS]',$prioritas,$sess['PRIORITAS'],'class="stext" title="Sampling Prioritas"'); ?></td>
                </tr>
              </table>
            </div>
            <div style="padding:10px;"></div>
            <div><a href="#" class="button save" onclick="post_srl('#m_srl_pop_up'); return false;"><span><span class="icon"></span>&nbsp; <?php echo $save; ?> &nbsp;</span></a>&nbsp;<a href="#" class="button reload" onclick="close_popup();" ><span><span class="icon"></span>&nbsp; Batal &nbsp;</span></a></div>
          </div>
          <div style="padding:10px;"></div>
          <input type="hidden" name="ID" value="<?php echo $id; ?>" />
        </form>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
	$(document).ready(function(){ 
		$('select.kategori').change(function(){
		  var ke = $(this).attr('ke');
		  var kunci = $(this).val();
		  ke = parseInt(ke) + 1;
		  for(i=ke;i<=5;i++){
			  $('#tdanak' + i).hide();
		  }
		  $.get('<?php echo site_url().'/autocompletes/autocomplete/get_kategori/'; ?>' + kunci, function(hasil){
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
		});
		$('input, select, textarea').focus(function(){
			$(this).css('background-color','#FFF');
			$(this).css('border','1px solid #dddddd');
		});
		$("table.form_tabel tr:even").css("background-color", "#f0f0f0");
		$("table.form_tabel tr:odd").css("background-color", "#fff");
		$('select, textarea, input:not(:image, submit, checkbox, radio)').poshytip({className: 'tip-twitter',showTimeout: 1,alignTo: 'target',alignX: 'right',alignY: 'center',offsetX: 5,allowTipHover: false,fade: false,slide: false});	
	});
	
	function post_srl(formid){
		var jumlah = 0; 
		$(':input[rel=required]:not(:image, submit, button)', formid).each(function(){
			if($(this).val() == "" || $(this).val() == null){ 
				$(this).css('background-color','#FBE3E4'); 
				$(this).css('border','1px solid #F00'); 
				jumlah++;
			}
		}); 
		if(jumlah>0){
			jAlert('Maaf, ada '+jumlah+' kolom yang harus diisi', 'SIPT Versi 1.0'); 
			return false;
		}else{
			jConfirm('Apakah anda yakin dengan data yang Anda isikan ?', 'SIPT Versi 1.0', function(ojan){
				if(ojan==true){
					  $.ajax({
						  type: "POST", 
						  url: $(formid).attr('action') + '/ajax', 
						  data: $(formid).serialize(),
						  error: function(){ 
							  jAlert('Maaf, Request halaman tidak ditemukan', 'SIPT Versi 1.0'); 
						  }, 
						  beforeSend: function(){
							  jLoadingOpen('','SIPT Versi 1.0');
						  }, 
						  complete: function(){ 
							  jLoadingClose();
						  },
						  success: function(data){
							  if(data.search("MSG")>=0){
								  arrdata = data.split('#');
								  if(arrdata[1]=="YES"){
									  jAlert(arrdata[2],'SIPT Versi 1.0');
								  }
								  $.alerts._hidePopup();
								  if(arrdata.length>3){
									  setTimeout(function(){location.reload(true);}, 1000);
									  return false;
								  }
							  }else{
								  jAlert(arrdata[2],'SIPT Versi 1.0');
							  }
							  return false;
						  } 
					  }); 
				}else{
					return false;
				}
			});
		} 
		return false;
	}
</script> 
