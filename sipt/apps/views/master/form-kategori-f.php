<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR); ?>
<style>
.hideme {
	display: none;
}
</style>
<div id="juduluji" class="judul"></div>
<div class="content">
  <form action="<?php echo $act; ?>" method="post" autocomplete="off" id="kategorisampling-new" name="kategorisampling-new">
    <div class="adCntnr">
      <div class="acco2">
        <div class="expand"><b>Penambahan kategori sampling baru</b></div>
        <div class="collapse">
          <div class="accCntnt">
            <table class="form_tabel">
              <tr>
                <td class="td_left bold">Komoditi</td>
                <td class="td_right"><b>
                  <?= $komoditi; ?>
                  </b></td>
              </tr>
              <tr>
                <td class="td_left bold">Kategori</td>
                <td class="td_right"><?= form_dropdown('KLASIFIKASI_ID[]',$kategori,'','class="stext" style="width:100%;" title="Kategori"'); ?></td>
              </tr>
              <tr id="cbpanel-kategori" data-target = "#cbpanel-sub-kategori" data-position="1">
                <td class="td_left bold">Sub Kategori</td>
                <td class="td_right"><?= form_dropdown('KLASIFIKASI_ID[]',$cbkategori,'','class="select-kategori stext" style="width:100%;" id="kategori" data-url = "'.site_url().'/get/kategori/ac_kategori/" title ="Zat Aktif" data-new="1"', array("011001")); ?></td>
              </tr>
              <tr class="trcb" id="cbpanel-sub-kategori" data-target = "#cbpanel-sub-sub-kategori" style="display:none;" data-before="#cbpanel-sub-sub-kategori" data-position="2">
                <td class="td_left bold"></td>
                <td class="td_right"><?= form_dropdown('','','','class="select-kategori stext" style="width:100%;" id="sub-kategori"; data-url = "'.site_url().'/get/kategori/ac_kategori/" title="Bentuk Sediaan"'); ?></td>
              </tr>
              <tr class="trcb" id="cbpanel-sub-sub-kategori" style="display:none;" data-before = "#cbpanel-sub-sub-kategori" data-position="3">
                <td class="td_left bold"></td>
                <td class="td_right"><?= form_dropdown('','','','class="select-kategori stext" style="width:100%;" id = "sub-sub-sub-kategori" data-url = "'.site_url().'/get/kategori/ac_kategori/" title="Sediaan Pustaka"'); ?></td>
              </tr>
              <tr class="input-control" id="<?= rand(); ?>">
                <td class="td_left bold">&nbsp;</td>
                <td class="td_right"><input type="text" wajib="yes" name="KLASIFIKASI" style="width:100%"></td>
              </tr>
            </table>
          </div>
        </div>
      </div>
    </div>
    <div style="padding:10px;"></div>
    <div><a href="#" class="button save" onclick="fpost('#kategorisampling-new','',''); return false;"><span><span class="icon"></span>&nbsp; Simpan &nbsp;</span></a>&nbsp;<a href="#" class="button reload" onclick="javascript:history.back(); return false;" ><span><span class="icon"></span>&nbsp; Batal &nbsp;</span></a></div>
    <div style="padding:10px;"></div>
  </form>
</div>
<script type="text/javascript">
	$(document).ready(function(){ 
		$(".input-control").hide();
		$(".select-kategori").change(function(e){
            var $this = $(this);
			var $parent = $this.parent().parent();
			var $target = $parent.attr("data-target");
			var $next = $parent.next();
			var $input = $(".input-control");
			
			
			if($this.val() == "" && $parent.attr("data-position").length > 0){
				$($target).hide();
				$next.children().children().removeAttr("name");
				return false;
			}
			var $chk = "";
			if($this.attr("data-new")){ 
				$chk = "/123";
			}
	
			if($this.val() != "new"){
				if($this.attr("data-url")){
					$.get($this.attr("data-url") + $this.val() + $chk, function($data){
						if($data){
							$this.attr("name","KLASIFIKASI_ID[]");
							$($target).show();
							$next.children().children().html($data);							
							$input.hide();
							if($this.val().length == 8){
								$input.show();	
									$parent.children().first().html('Zat Aktif');
									$next.children().first().html('Bentuk Sediaan');
									$input.children().children().attr("placeholder", "Bentuk Sediaan Baru");
							}else if($this.val().length > 8){
								$input.hide();	
							}
						}else{
							$(".input-control").hide();
							$input.children().children().val("");
							$($target).hide();
							$next.children().children().removeAttr("name");
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
</script> 
