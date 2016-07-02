<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR); 
$rel = ($kategorix == "0105" ? 'rel="required"' : '');
?>
<div id="juduluji" class="judul"></div>
<div class="content">
  <form action="<?php echo $act; ?>" method="post" autocomplete="off" id="paramsampling-new" name="paramsampling-new">
    <div class="adCntnr">
      <div class="acco2">
        <div class="expand"><b>Penambahan Parameter Uji Prioritas Sampling</b></div>
        <div class="collapse">
          <div class="accCntnt">
            <table class="form_tabel">
              <tr>
                <td class="td_left bold">Komoditi</td>
                <td class="td_right"><b><?= $komoditi; ?></b></td>
              </tr>
              <tr id="cbkategori" data-target = "#cbpanel-kategori" data-position="0">
                <td class="td_left bold">Kategori</td>
                <td class="td_right"><?= form_dropdown('GOLONGAN[]',$kategori,'','class="select-kategori stext" style="width:100%;" rel="required" data-url = "'.site_url().'/get/kategori/ac_kategori/" title = "Kategori" id = "kat"'); ?></td>
              </tr>
              <tr id="cbpanel-kategori" data-target = "#cbpanel-sub-kategori" data-position="1" style="display:none;" class="1">
                <td class="td_left bold">&nbsp;</td>
                <td class="td_right"><?= form_dropdown('GOLONGAN[]',$cbkategori,'','class="select-kategori stext" style="width:100%;" id="kategori" data-url = "'.site_url().'/get/kategori/ac_kategori/" title = "Sub Kategori"'); ?></td>
              </tr>
              <tr id="cbpanel-sub-kategori" data-target = "#cbpanel-sub-sub-kategori" style="display:none;" data-before="#cbpanel-sub-sub-kategori" data-position="2" class="2">
                <td class="td_left bold">&nbsp;</td>
                <td class="td_right"> <?= form_dropdown('','','','class="select-kategori stext" style="width:100%;" id="sub-kategori"; data-url = "'.site_url().'/get/kategori/ac_kategori/" title = "Sub Sub Kategori"'); ?></td>
              </tr>
              <tr id="cbpanel-sub-sub-kategori" style="display:none;" data-before = "#cbpanel-sub-sub-kategori" data-position="3" class="2">
                <td class="td_left bold">&nbsp;</td>
                <td class="td_right"><?= form_dropdown('','','','class="select-kategori stext" style="width:100%;" id = "sub-sub-sub-kategori" data-url = "'.site_url().'/get/kategori/ac_kategori/" title = "Sub Sub Sub Kategori"'); ?></td>
              </tr>
              <tr><td colspan="2">&nbsp;</td></tr>
              <tr>
                <td class="td_left bold">Bidang Uji</td>
                <td class="td_right"><?= form_dropdown('PRIORITAS[BIDANG_UJI]',$bidang_uji,'','class="select-kategori stext" style="width:100%;" title="Bidang Pengujian" rel="required"'); ?></td>
              </tr>
              <tr>
                <td class="td_left bold">Kategori TMS</td>
                <td class="td_right"><?= form_dropdown('PRIORITAS[KATEGORI_PU]',$kategori_tms,'','class="select-tms stext" style="width:100%;" title="Kategori TMS"'.$rel); ?></td>
              </tr>
              <tr>
                <td class="td_left bold">Parameter Uji</td>
                <td class="td_right"><input type="text" name="PRIORITAS[PARAMETER_UJI]" class="stext" title="Parameter uji wajib diisi" rel="required" style="width:100%" /></td>
              </tr>
              <tr>
                <td class="td_left bold">Pustaka</td>
                <td class="td_right"><input type="text" name="PRIORITAS[PUSTAKA]" class="stext" title="Pustaka wajib diisi" rel="required" style="width:100%" /></td>
              </tr>
              <tr>
                <td class="td_left bold">Metode</td>
                <td class="td_right"><input type="text" name="PRIORITAS[METODE]" class="stext" title="Metode wajib diisi" rel="required" style="width:100%" /></td>
              </tr>
              <tr>
                <td class="td_left bold">Syarat</td>
                <td class="td_right"><input type="text" name="PRIORITAS[SYARAT]" class="stext" title="Syarat" style="width:100%" /></td>
              </tr>
            </table>
          </div>
        </div>
      </div>
    </div>
    <div style="padding:10px;"></div>
    <div><a href="#" class="button save" onclick="fpost('#paramsampling-new','',''); return false;"><span><span class="icon"></span>&nbsp; Simpan &nbsp;</span></a>&nbsp;<a href="#" class="button reload" onclick="javascript:history.back(); return false;" ><span><span class="icon"></span>&nbsp; Batal &nbsp;</span></a></div>
    <div style="padding:10px;"></div>
    <input type="hidden" id="IF" value="<?= $kategorix; ?>" />
  </form>
</div>
<script type="text/javascript">
	$(document).ready(function(){ 
		$(".select-kategori").change(function(e){
            var $this = $(this);
			var $parent = $this.parent().parent();
			var $target = $parent.attr("data-target");
			var $next = $parent.next(); 
			var $ke = parseInt($parent.attr("data-position"));
			if($ke == 1){
				$("tr.2").hide();
			}
			if($this.val() == "" && $parent.attr("data-position").length > 0){
				$($target).hide();
				$next.children().children().removeAttr("name");
				return false;
			}
			if($this.val() != "new"){
				if($this.attr("data-url")){
					$.get($this.attr("data-url") + $this.val() + '/sel', function($data){
						if($data){
							var $length = $data.length;
							var $if = $("#IF").val();
								$this.attr("name","GOLONGAN[]");
								console.log($if);
							//if($if == "0111" || $if == "0110"){
								if($if == "0111" || $if == "0110"){
									if($length > 0){
										$($target).show();
										$next.children().children().attr("rel","required");
										$next.children().children().html($data);
									}
								}else{
									if($length > 1){
										$($target).show();
										$next.children().children().attr("rel","required");
										$next.children().children().html($data);
									}
								}
							//}else{
								//if($length > 1){
									//$($target).show();
									//$next.children().children().attr("rel","required");
									//$next.children().children().html($data);
								//}
							//}
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
