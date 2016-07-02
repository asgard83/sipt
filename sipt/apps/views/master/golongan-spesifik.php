<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR); ?>
<style>
.hideme {
	display: none;
}
</style>
<div id="juduluji" class="judul"></div>
<div class="content">
  <form action="<?php echo $act; ?>" method="post" autocomplete="off" id="mgolongan-spesifik" name="mgolongan-spesifik">
    <div class="adCntnr">
      <div class="acco2">
        <div class="expand"><b>Golongan Spesifik Lokal</b></div>
        <div class="collapse">
          <div class="accCntnt">
            <table class="form_tabel">
              <tr>
                <td class="td_left">Komoditi</td>
                <td class="td_right"><?php echo form_dropdown('GOLONGAN[]',$golongan,$sess['KOMODITI'],'class="stext kategori" title="Komoditi" id="sel0" ke="0" rel="required"'); ?></td>
              </tr>
              <tr <?php echo (strlen($sess['KATEGORI']) == 4) ? '' : 'class="hideme"' ;?> id="tdanak1" ke="1">
                <td class="td_left">Kategori</td>
                <td class="td_right"><?php echo form_dropdown('GOLONGAN[]',is_array($selkategori[0]) ? $selkategori[0] : '',$sess['KATEGORI'],'class="stext kategori" title="Sub Kategori" ke="1" id="sel1"'); ?>
                  <div id="tmpnew1"></div></td>
              </tr>
              <tr <?php echo strlen($sess['SUB_KATEGORI']) == 6 ? '' : 'class="hideme"' ;?> id="tdanak2" ke="2">
                <td class="td_left">Sub Kategori</td>
                <td class="td_right"><?php echo form_dropdown('GOLONGAN[]',is_array($selkategori[1]) ? $selkategori[1] : '',$sess['SUB_KATEGORI'],'class="stext kategori" title="Sub Sub Kategori" ke="2" id="sel2"'); ?>
                  <div id="tmpnew2"></div></td>
              </tr>
              <tr <?php echo strlen($sess['SUB_SUB_KATEGORI']) == 8 ? '' : 'class="hideme"' ;?> id="tdanak3" ke="3">
                <td class="td_left">Sub Sub Kategori</td>
                <td class="td_right"><?php echo form_dropdown('GOLONGAN[]',is_array($selkategori[2]) ? $selkategori[2] : '',$sess['SUB_SUB_KATEGORI'],'class="stext kategori" title="Sub Sub Kategori" ke="3" id="sel3"'); ?>
                  <div id="tmpnew3"></div></td>
              </tr>
              <tr <?php echo strlen($sess['SUB_SUB_SUB_KATEGORI']) == 10 ? '' : 'class="hideme"' ;?> id="tdanak4" ke="4">
                <td class="td_left">Sub Sub Sub Kategori</td>
                <td class="td_right"><?php echo form_dropdown('GOLONGAN[]',is_array($selkategori[3]) ? $selkategori[3] : '',$sess['SUB_SUB_SUB_KATEGORI'],'class="stext kategori" title="Sub Sub Kategori" ke="4" id="sel4"'); ?>
                  <div id="tmpnew4"></div></td>
              </tr>
              <tr class="trnewgolongan" style="display:none;">
                <td class="td_left">Kategori, sub kategori, sub sub kategori</td>
                <td class="td_right"><input type="text" class="stext" id="newgolongan" name="KLASIFIKASI" title="Nama zat aktif, bentuk sediaan, golongan atau sub kategori" />
                  <div style="padding-top:5px;">Klik <a href="javascript:void(0);" class="cancelgolongan"><b>disini</b></a> untuk membatalkan pengisian golongan, sub kategori atau sub sub kategori</div></td>
              </tr>
            </table>
          </div>
        </div>
      </div>
      <div style="padding:10px;"></div>
      <div><a href="#" class="button save" onclick="fpost('#mgolongan-spesifik','',''); return false;"><span><span class="icon"></span>&nbsp; <?php echo $save; ?> &nbsp;</span></a>&nbsp;<a href="#" class="button reload" url="<?php echo $batal; ?>" onclick="batal($(this)); return false;" ><span><span class="icon"></span>&nbsp; <?php echo $cancel; ?> &nbsp;</span></a></div>
    </div>
    <div style="padding:10px;"></div>
    <input type="hidden" name="KLASIFIKASI_ID" value="<?php echo $id; ?>" />
  </form>
</div>
<script type="text/javascript">
	$(document).ready(function(){ 
		$('select.kategori').change(function(){
		  var ke = $(this).attr('ke');
		  var kunci = $(this).val();
		  $(".trnewgolongan").hide();
		  $("#newgolongan").removeAttr("rel");
		  $("#newgolongan").val('');
		  ke = parseInt(ke) + 1;
		  for(i=ke;i<=5;i++){
			  $('#tdanak' + i).hide();
		  }
		  //$.get(site_url().'/autocompletes/autocomplete/get_kategori_spesifik/'; ?>' + kunci, function(hasil){
		  $.get('<?php echo site_url().'/autocompletes/autocomplete/get_kategori/'; ?>' + kunci + '/0', function(hasil){	  
			  var hasil = hasil.replace(' ', '');
			  var jum = hasil.length;
			  if(jum==0){
				  $('#tdanak' + ke).hide();
				  $('#sel' + ke).removeAttr("rel");
				  $('.trnewgolongan').show();
			  }else{
				  $('#tdanak' + ke).show();
				  $('#sel' + ke).html(hasil);
				  $('#sel' + ke).attr("rel","required");
				  $('#tmpnew' + ke).html('Jika belum terdapat dalam list diatas, silahkan klik <a href="javascript:void(0);" class="addolongan"><b>disini</b></a> untuk menambahkan data baru </div>');
			  }
		  });
		});
		$(".addolongan").live("click", function(){
			var ke = $(this).closest("tr").attr("ke");
			$('#tdanak' + ke).hide();
			$('#tdanak' + ke).val('');
			$('#sel' + ke).removeAttr("rel");
			$(".trnewgolongan").show();
			$(".trnewgolongan").attr("ke",ke);
			$(".trnewgolongan").attr("id","trnewgol");
			$("#newgolongan").attr("rel","required");
			return false;
		});
		$(".cancelgolongan").live("click",function(){
			var ke = $(this).closest("tr").attr("id");
			$('#tdanak'+ke).show();
			$('#sel'+ke).attr("rel","required");
			$(".trnewgolongan").hide();
			$("#newgolongan").removeAttr("rel");
			$("#newgolongan").val('');
			return false;
		});
	});
</script> 
