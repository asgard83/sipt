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
                <td class="td_right"><b><?= $komoditi; ?></b></td>
              </tr>
              <tr>
                <td class="td_left bold">Kategori</td>
                <td class="td_right"><?= form_dropdown('KLASIFIKASI_ID[]',$kategori,'','class="select-kategori stext" style="width:100%;" title="Kategori"'); ?></td>
              </tr>
              <tr id="cbpanel-kategori" data-target = "#cbpanel-sub-kategori" data-position="1">
                <td class="td_left bold">&nbsp;</td>
                <td class="td_right"><?= form_dropdown('KLASIFIKASI_ID[]',$cbkategori,'','class="select-kategori stext" style="width:100%;" id="kategori" data-url = "'.site_url().'/get/kategori/ac_kategori/" title ="Zat Aktif"'); ?></td>
              </tr>
              <tr id="cbpanel-sub-kategori" data-target = "#cbpanel-sub-sub-kategori" style="display:none;" data-before="#cbpanel-sub-sub-kategori" data-position="2">
                <td class="td_left bold">&nbsp;</td>
                <td class="td_right"><?= form_dropdown('','','','class="select-kategori stext" style="width:100%;" id="sub-kategori"; data-url = "'.site_url().'/get/kategori/ac_kategori/" title="Bentuk Sediaan"'); ?></td>
              </tr>
              <tr id="cbpanel-sub-sub-kategori" style="display:none;" data-before = "#cbpanel-sub-sub-kategori" data-position="3">
                <td class="td_left bold">&nbsp;</td>
                <td class="td_right"><?= form_dropdown('','','','class="select-kategori stext" style="width:100%;" id = "sub-sub-sub-kategori" data-url = "'.site_url().'/get/kategori/ac_kategori/" title="Sediaan Pustaka"'); ?></td>
              </tr>
              <tr>
                <td colspan="2">&nbsp;</td>
              </tr>
              <tr>
                <td class="td_left bold">&nbsp;</td>
                <td class="td_right">Untuk zat aktif, bentuk sediaan, atau pustaka baru silahkan isi input text dibawah</td>
              </tr>
              <tr  >
                <td class="td_left bold">&nbsp;</td>
                <td class="td_right"><input type="text" placeholder="Zat aktif, bentuk sediaan, atau pustaka baru" class="stext" wajib="yes" name="KLASIFIKASI" style="width:100%" title = "Zat aktif, bentuk sediaan, atau pustaka baru"></td>
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
		$(".select-kategori").change(function(e){
      //$('#zaktif').hide();
            var $this = $(this);

			var $parent = $this.parent().parent();
			var $target = $parent.attr("data-target");
			var $next = $parent.next(); 
      var $input = $("#zaktif");
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
</script> 
