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
              <tr id="cbpanel-sub-sub-kategori" data-target = "#cbpanel-sub-sub-sub-kategori" style="display:none;" data-before = "#cbpanel-sub-sub-kategori" data-position="3" class="2">
                <td class="td_left bold">&nbsp;</td>
                <td class="td_right"><?= form_dropdown('','','','class="select-kategori stext" style="width:100%;" id = "sub-sub-sub-kategori" data-url = "'.site_url().'/get/kategori/ac_kategori/" title = "Sub Sub Sub Kategori"'); ?></td>
              </tr>
              <tr id="cbpanel-sub-sub-sub-kategori" style="display:none;" data-before = "#cbpanel-sub-sub-sub-kategori" data-position="4" class="2">
                <td class="td_left bold">&nbsp;</td>
                <td class="td_right"><?= form_dropdown('','','','class="select-kategori stext" style="width:100%;" id = "sub-sub-sub-kategori" data-url = "'.site_url().'/get/kategori/ac_kategori/" title = "Sub  Sub Sub Sub Kategori"'); ?></td>
              </tr>
              <tr><td colspan="2">&nbsp;</td></tr>
            </table>
			<table class="form_tabel" id="tbparamater">
			  <tr>
                <td class="td_left bold">Bidang Uji</td>
                <td class="td_right"><?= form_dropdown('',$bidang_uji,'','id="bidang_uji" class="select-kategori stext" style="width:100%;" title="Bidang Pengujian"'); ?></td>
              </tr>
              <?php
			  if($kategorix != "0106")
			  {
			  ?>
              <tr>
                <td class="td_left bold">Ketentuan Khusus</td>
                <td class="td_right"><?= form_dropdown('','','','id="ketentuan_khusus" class="select-tms stext" style="width:100%;" title="Ketentuan Khusus"'.$rel); ?></td>
              </tr>
              <?php
			  }
			  ?>
              <tr>
                <td class="td_left bold">Parameter Uji</td>
                <td class="td_right">
                <?= form_dropdown('',$cb_parameter,'','id="cb_parameter" class="select-tms stext" style="width:100%;" title="Parameter Uji"'.$rel); ?>
                </td>
              </tr>
              <tr>
                <td class="td_left bold">Pustaka</td>
                <td class="td_right"><input type="text" id="pustaka" class="stext" title="Pustaka wajib diisi" style="width:100%" /></td>
              </tr>
              <tr>
                <td class="td_left bold">Metode</td>
                <td class="td_right"><input type="text" id="metode" class="stext" title="Metode wajib diisi" style="width:100%" /></td>
              </tr>
              <tr>
                <td class="td_left bold">Syarat</td>
                <td class="td_right"><input type="text" id="syarat" class="stext" title="Syarat" style="width:100%" /></td>
              </tr>
            </table>
			<!--newone-->
			<div style="height:5px;"></div>
            <div class="btn"><span><a href="javascript:void(0);" id="addparameter">Klik Disini Untuk Menambah Parameter Uji</a></span></div>
            <h2 class="small garis">Daftar Tambahan Parameter Uji Sampling</h2>
            <table class="listtemuan" width="100%" id="draft-parameter">
              <thead>
                <tr>                  
                  <th width="35">Bidang Uji</th>
                  <th width="75">Parameter Uji</th>
                  <th width="75">Pustaka</th>
				  <th width="125">Metode</th>
                  <th width="75">Syarat</th>
                  <th width="75">Opsi</th>
                </tr>
              </thead>
              <tbody id="body-paramater">
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <div style="padding:10px;"></div>
    <div><a style="display:none;" id="btn_proses" href="#" class="button save" onclick="fpost('#paramsampling-new','',''); return false;"><span><span class="icon"></span>&nbsp; Simpan &nbsp;</span></a>&nbsp;<a href="#" class="button reload" onclick="javascript:history.back(); return false;" ><span><span class="icon"></span>&nbsp; Batal &nbsp;</span></a></div>
    <div style="padding:10px;"></div>
    <input type="hidden" id="IF" value="<?= $kategorix; ?>" />
    <input type="hidden" id="parameter_kritis" <?= $kategorix == "0106" ? 'value="0"' : ''; ?>>
    <?php 
	if($kategorix == "0106"){
		?>
        <input type="hidden" id="ketentuan_khusus" value="0">
        <?php
	}
	?>
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
						if($data)
						{
							var $length = $data.length;
							var $if = $("#IF").val();
							$this.attr("name","GOLONGAN[]");
							/*if($if == "0111" || $if == "0110")
							{
								if($length > 0)
								{
									$($target).show();
									$next.children().children().attr("rel","required");
									$next.children().children().html($data);
								}
								else if($length == 1){
									$($target).hide();
								}
							}
							else
							{*/
								if($length > 1)
								{
									$($target).show();
									$next.children().children().attr("rel","required");
									$next.children().children().html($data);
								}
								else if($length == 1)
								{
									$($target).hide();
									$substr = $this.val().substring(0,4);
									$.get('<?= site_url(); ?>/get/kategori/ac_ketentuan_khusus/' + $this.val(), function($ret){
										if($ret)
										{
											$("#ketentuan_khusus").html($ret);
											$("#ketentuan_khusus").attr("golongan", $this.val());
										}
									});
									/*$.get('<?= site_url(); ?>/get/kategori/ac_parameter/' + $this.val(), function($ret){
										if($ret)
										{
											$("#cb_parameter").html($ret).change(function(e) {
												var $cb_parameter = $(this);
												$.get('<?= site_url(); ?>/get/kategori/ac_puk/' + $cb_parameter.val(), function($retx){
													$arr = $retx.split("#");
													if($arr.length > 1){
														$("#parameter_kritis").val($arr[0]);
														$("#ketentuan_khusus").val($arr[1]);
													}
												});
                                            });	
										}
									});*/
								}
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
		
		$("#ketentuan_khusus").change(function(e) {
            var $this = $(this);
			$.get('<?= site_url(); ?>/get/kategori/ac_parameter/' + $this.attr("golongan") + '/' + $this.val(), function($ret){
				if($ret)
				{
					$("#cb_parameter").html($ret);
				}
			});
        });
		$("#cb_parameter").change(function(e) {
			var $this = $(this);	
			<?php 
			if($kategorix != "0106")
			{
			?>
			$.get('<?= site_url(); ?>/get/kategori/ac_puk/' + $this.val(), function($ret){
				if($ret)
				{
					$("#parameter_kritis").val($ret);
				}
			});
			<?php
			}
			else
			{
				?>
					$("#parameter_kritis").val($this.val());
				<?php
			}
			?>
        });
		$("#addparameter").live("click", function(){
			if(!beforeSubmit("#draft-parameter")){
				return false;
			}else{
				if($("#kategori").val()==""){
					jAlert('Maaf, Anda belum memilih kategori.', 'SIPT Versi 1.0');
					$("#kategori").focus();
					return false;
				}
				if($("#bidang_uji").val()==""){
					jAlert('Maaf, Anda belum memilih bidang uji.', 'SIPT Versi 1.0');
					$("#bidang_uji").focus();
					return false;
				}
				if($("#kategori_tms").val()==""){
					if($("#kategori").val().substring(0,4)=="0105"){	//D1 wajib TMS diisi
						jAlert('Maaf, Anda belum memilih kategori TMS.', 'SIPT Versi 1.0');
						$("#kategori_tms").focus();
						return false;
					}
				}
				if($("#parameter_uji").val()==""){
					jAlert('Maaf, Anda belum mengisi parameter uji.', 'SIPT Versi 1.0');
					$("#parameter_uji").focus();
					return false;
				}
				
				var no = $("#body-paramater tr").length;
				var bidanguji = $("#bidang_uji").val();
				var cetakbidang = '';
				if(bidanguji=='01'){
					cetakbidang = 'Mikrobiologi';
				}else{
					cetakbidang = 'Kimia - Fisika';
				}
				var parameter_uji = $("#cb_parameter option:selected").text();
				var str = '<tr id="baris'+(no+1)+'">';
					str += '<td>'+cetakbidang+'&nbsp;<input type="hidden" name="PRIORITAS[BIDANG_UJI][]" value="'+$("#bidang_uji").val()+'"></td>';
					str += '<td>'+parameter_uji+'&nbsp;<input type="hidden" name="PRIORITAS[PARAMETER_UJI][]" value="'+parameter_uji+'"></td>';
					str += '<td>'+$("#pustaka").val()+'&nbsp;<input type="hidden" name="PRIORITAS[PUSTAKA][]" value="'+$("#pustaka").val()+'"></td>';
					str += '<td>'+$("#metode").val()+'&nbsp;<input type="hidden" name="PRIORITAS[METODE][]" value="'+$("#metode").val()+'"></td>';
					str += '<td>'+$("#syarat").val()+'&nbsp;<input type="hidden" name="PRIORITAS[SYARAT][]" value="'+$("#syarat").val()+'"><input type="hidden" name="PRIORITAS[KETENTUAN_KHUSUS][]" value="'+$("#ketentuan_khusus").val()+'"><input type="hidden" name="PRIORITAS[PARAMETER_KRITIS_ID][]" value="'+$("#parameter_kritis").val()+'"></td>';
					str += '<td><a href="#" class="hapusparams">Hapus</a></td>';
					str += '</tr>';
					$("#body-paramater").append(str);
					clearForm("#tbparamater");
					$("#btn_proses").show();
					$(".hapusparams").live("click", function(){
						var idke = $(this).closest("tr").attr("id");
						$("#"+idke).remove();
						return false;
					});
			}
			return false;
		});
	});
</script> 
