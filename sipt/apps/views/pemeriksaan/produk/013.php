<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR); ?>
<script type="text/javascript">
	$(document).ready(function(){
		$('input, select, textarea').focus(function(){$(this).css('background-color','#FFF');$(this).css('border','1px solid #dddddd');});
		$("table.form_tabel tr:even").css("background-color", "#f0f0f0");
		$("table.form_tabel tr:odd").css("background-color", "#fff");
		$('select, textarea, input:not(:image, submit, checkbox, radio)').poshytip({className: 'tip-twitter',showTimeout: 1,alignTo: 'target',alignX: 'right',alignY: 'center',offsetX: 5,allowTipHover: false,fade: false,slide: false});
		$("#nama_produk").autocomplete($("#nama_produk").attr('url'), {width: 244, selectFirst: false});
		$("#nama_produk").result(function(event, data, formatted){
			if(data){
				$(this).val(data[1]);
				$("#no_registrasi").val(data[2]);
				$("#importir").val(data[6]);
				$("#flag").val('1');
			}
		});
		
		$("#kategori_temuan").change(function(){
			if($("#kategori_temuan").val() == "Lain-Lain"){
				$("#kategori_lain").show();
			}else{
				$("#kategori_lain").hide();
			}
		});
			
	});
</script>

<table class="form_tabel">
<tr><td class="td_left">Nama produk</td><td class="td_right"><input rel="required" type="text" class="stext" id="nama_produk" name="TEMUAN[NAMA_PRODUK]" url="<?php echo site_url(); ?>/autocompletes/autocomplete/produk_reg/13" title="Nama produk" value="<?php echo $sess_produk['NAMA_PRODUK']; ?>" /></td><td class="td_left"> Produsen/Importir</td><td class="td_right"><input rel="required" type="text" id="importir" name="TEMUAN[PRODUSEN]" class="stext" title="Produsen / importir" value="<?php echo $sess_produk['PRODUSEN']; ?>" /></td></tr>
<tr><td class="td_left">Registrasi Produk</td><td class="td_right"><?php echo form_dropdown('TEMUAN[REGISTRASI]',$registrasi_produk,$sess_produk['REGISTRASI'],'class="stext" rel="required" title="Pilih salah satu jenis registrasi produk"'); ?></td><td class="td_left">Nomor Registrasi</td><td class="td_right"><input type="text" name="TEMUAN[NOMOR_REGISTRASI]" rel="required" value="<?php echo $sess_produk['NOMOR_REGISTRASI']; ?>" id="no_registrasi" class="stext" title="Nomor Registrasi" /></td></tr>
<tr><td class="td_left">Jumlah Kemasan Terkecil</td><td class="td_right"><input rel="required" type="text" class="scode" value="<?php echo $sess_produk['JUMLAH_TEMUAN']; ?>" name="TEMUAN[JUMLAH_TEMUAN]" title="Jumlah kemasan terkecil" onkeyup="numericOnly($(this))" />&nbsp;<?php echo form_dropdown('TEMUAN[SATUAN]',$kemasan,$sess_produk['KEMASAN'],'rel="required" class="sel_penyimpangan" title="Kemasan"'); ?></td><td class="td_left">Kategori Temuan</td><td class="td_right"><?php echo form_dropdown('TEMUAN[KATEGORI]',$kategori_temuan,$sess_produk['KATEGORI'],'class="stext" title="Pilih salah satu kategori temuan" rel="required" id="kategori_temuan"'); ?></td></tr>
<?php /*?><tr id="kategori_lain" <?php if($sess_produk['KATEGORI'] == "Lain-Lain") echo 'style=""'; else echo 'style="display:none;"'; ?>><td class="td_left">&nbsp;</td><td class="td_right">&nbsp;</td><td class="td_left">&nbsp;</td><td class="td_right"><input type="text" class="stext" title="Kategori temuan lainnya" <?php if($sess_produk['KATEGORI'] == "Lain-Lain") echo 'name="TEMUAN[KATEGORI]"'; else echo '';?> /></td></tr>
<?php */?><tr><td class="td_left">Perkiraan harga total</td><td class="td_right"><input rel="required" type="text" id="harga" class="sdate" name="TEMUAN[HARGA]" title="Perkiraan harga total" onkeyup="numericOnly($(this))" value="<?php echo $sess_produk['HARGA']; ?>" /></td><td class="td_left">&nbsp;</td><td class="td_right"></td></tr>
</table>
<input type="hidden" name="TEMUAN[FLAG]" value="0" id="flag">