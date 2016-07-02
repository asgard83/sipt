<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR);?>
<link type="text/css" href="<?php echo base_url();?>css/css.css" rel="stylesheet" />
<form id="fmasterif" action="<?php echo $act; ?>"	autocomplete="off" name="fmasterif" method="post">
  <table class="form_tabel">
    <tr>
      <td class="td_left bold">Komoditi</td>
      <td class="td_right"><?= $komoditi; ?></td>
    </tr>
    <tr>
      <td class="td_left bold">Kategori</td>
      <td class="td_right"><?= form_dropdown('KLASIFIKASI_ID[]',$kategori,'','class="select-kategori stext" style="width:100%;"'); ?></td>
    </tr>
    <tr id="cbpanel-kategori" data-target = "#cbpanel-sub-kategori" data-position="1">
      <td class="td_left bold">&nbsp;</td>
      <td class="td_right"><?= form_dropdown('KLASIFIKASI_ID[]',$cbkategori,'','class="select-kategori stext" style="width:100%;" id="kategori" data-url = "'.site_url().'/get/kategori/ac_kategori/" '); ?></td>
    </tr>
    <tr id="cbpanel-sub-kategori" data-target = "#cbpanel-sub-sub-kategori" style="display:none;" data-before="#cbpanel-sub-sub-kategori" data-position="2">
      <td class="td_left bold">&nbsp;</td>
      <td class="td_right"> <?= form_dropdown('','','','class="select-kategori stext" style="width:100%;" id="sub-kategori"; data-url = "'.site_url().'/get/kategori/ac_kategori/" '); ?></td>
    </tr>
    <tr id="cbpanel-sub-sub-kategori" style="display:none;" data-before = "#cbpanel-sub-sub-kategori" data-position="3">
      <td class="td_left bold">&nbsp;</td>
      <td class="td_right"><?= form_dropdown('','','','class="select-kategori stext" style="width:100%;" id = "sub-sub-sub-kategori" data-url = "'.site_url().'/get/kategori/ac_kategori/" '); ?></td>
    </tr>
    <tr>
    	<td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td class="td_left bold">&nbsp;</td>
      <td class="td_right">Untuk zat aktif, bentuk sediaan, atau pustaka baru silahkan isi input text dibawah</td>
    </tr>
    <tr>
      <td class="td_left bold">&nbsp;</td>
      <td class="td_right"><input type="text" placeholder="Zat aktif, bentuk sediaan, atau pustaka baru" class="stext" wajib="yes" name="KLASIFIKASI" style="width:100%"></td>
    </tr>
  </table>
</form>
<div style="padding-left:5px;"> <a href="#" class="button save" onclick="fost_popup('#fmasterif'); return false;"><span><span class="icon"></span>&nbsp; Simpan &nbsp;</span></a> </div>
<script>
	$(document).ready(function(){
		$("table.form_tabel tr:even").css("background-color", "#f0f0f0");
		$("table.form_tabel tr:odd").css("background-color", "#fff");
		$(".select-kategori").change(function(e){
            var $this = $(this);
			var $parent = $this.parent().parent();
			var $target = $parent.attr("data-target");
			var $next = $parent.next(); 
			if($this.val() == "" && $parent.attr("data-position").length > 0){
				$($target).hide();
				$next.children().children().removeAttr("name");
				return false;
			}
			if($this.val() != "new"){
				if($this.attr("data-url")){
					$.get($this.attr("data-url") + $this.val(), function($data){
						if($data){
							$this.attr("name","KLASIFIKASI_ID[]");
							$($target).show();
							$next.children().children().html($data);
						}
					});
				}
			}else{
				$($target).hide();
				$next.children().children().removeAttr("name");
			}
			return false;
        });
	});
	
	function fost_popup(b){
		var $f = $(b);
		var wajib = 0;
		$.each($("input:visible, select:visible, textarea:visible"), function(){
			if($(this).attr('wajib')){
				if($(this).attr('wajib')=="yes" && ($(this).val()=="" || $(this).val()==null)){
					$(this).css('border-color','#b94a48');
					wajib++;
				}
			}
		});
		if(wajib > 0){
			jAlert('Ada <b>'+wajib+'</b> kolom / inputan / dropdown list yang harus diisi. Silahkan periksa kembali isian form anda.','SIPT Versi 1.0');
			return false
		}else{
			jConfirm('Apakah anda yakin dengan data yang Anda isikan ?', 'SIPT Versi 1.0', function(ojan){
				if(ojan==true){
					$.ajax({
						type: "POST",
						url: $(b).attr('action') + '/ajax',
						data: $(b).serialize(),
						error: function() {
							jAlert('Request halaman tidak ditemukan','SIPT Versi 1.0');
						},
						beforeSend: function(){
							jLoadingOpen('','SIPT Versi 1.0');
						},
						complete: function(){
							jLoadingClose();
						},
						success: function(data) {
							if (data.search("MSG") >= 0) {
								arrdata = data.split('#');
								if (arrdata[1] == "YES"){
									jAlert(arrdata[2],'SIPT Versi 1.0');
									if(arrdata.length > 3){
										if(arrdata[3] == "back"){
											setTimeout(function(){ history.back(); }, 2000);
										}else if(arrdata[3] == "refresh"){
											setTimeout(function(){location.reload(true);}, 1000);
										}else if(arrdata[3] == "redirect"){
											setTimeout(function(){location.href = arrdata[4]}, 2000);
										}
									}
								}else if(arrdata[1] == "NO"){
									jAlert(arrdata[2],'SIPT Versi 1.0');
								}
							}
						}
					});
				}else{
					return false;
				}
			});
			return false;
		}
	}


</script>