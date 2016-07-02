<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR); ?>
<script type="text/javascript">
	$(document).ready(function(){
		$('input, select, textarea').focus(function(){$(this).css('background-color','#FFF');$(this).css('border','1px solid #dddddd');});
		$("table.form_tabel tr:even").css("background-color", "#f0f0f0");
		$("table.form_tabel tr:odd").css("background-color", "#fff");
		$('select, textarea, input:not(:image, submit, checkbox, radio)').poshytip({className: 'tip-twitter',showTimeout: 1,alignTo: 'target',alignX: 'right',alignY: 'center',offsetX: 5,allowTipHover: false,fade: false,slide: false});
		
	$("#nm_produk").autocomplete($("#nm_produk").attr('url'), {width: 244, selectFirst: false});
	$("#nm_produk").result(function(event, data, formatted){
		if(data){
			$(this).val(data[1]);
			$("#nie").val(data[2]);
			$("#nmsarana").val(data[3]);
			$("#kemasan").val(data[4]);
			$("#alsarana").val(data[5]);
			$("#pemilik").val(data[6]);
			$("#pabrik").val(data[7]);
			$("#asl").val(data[8]);
			$("#flag").val('1');
		}
	});

		
	});
</script>

<table class="form_tabel">
	<tr><td class="td_left">Nama Produk</td><td class="td_right"><input type="text" class="stext" name="TEMUAN[NAMA_PRODUK]" id="nm_produk" title="Nama Produk" rel="required" url="<?php echo site_url(); ?>/autocompletes/autocomplete/produk_reg/01" value="<?php echo $sess_produk['NAMA_PRODUK']; ?>" /></td><td class="td_left">Kategori</td><td class="td_right"><?php echo form_dropdown('TEMUAN[KATEGORI][]',$kategori_temuan,explode(",",$sess_produk['KATEGORI']),'class="stext multiselect" rel="required" id="kategori" multiple title="Kategori Temuan. Jika lebih dari satu, Klik + Ctrl untuk memilih"'); ?></td></tr>
	<tr><td class="td_left">Pabrik / Produsen</td><td class="td_right"><input type="text" rel="required" class="stext" name="TEMUAN[PRODUSEN]" title="Asal Pabrik / Produsen" id="pabrik" value="<?php echo $sess_produk['PRODUSEN']; ?>" /></td><td class="td_left">Negara Asal</td><td class="td_right"><input type="text" class="stext" name="TEMUAN[NEGARA_ASAL]" title="Negara Asal" id="asl" value="<?php echo $sess_produk['NEGARA_ASAL']; ?>" /></td></tr>
	<tr><td class="td_left">Kemasan</td><td class="td_right"><input type="text" class="stext" name="TEMUAN[KEMASAN]" id="kemasan" title="Kemasan produk" rel="required" value="<?php echo $sess_produk['KEMASA']; ?>" /></td><td class="td_left">NIE</td><td class="td_right"><input type="text" class="stext" name="TEMUAN[NOMOR_REGISTRASI]" title="Nomor Izin Edar / Nomor Registrasi Produk" id="nie" value="<?php echo $sess_produk['NOMOR_REGISTRASI']; ?>" /></td></tr>
	<tr><td class="td_left">No. Lots / Bets</td><td class="td_right"><input type="text" class="stext" name="TEMUAN[NO_BATCH]" title="Nomor lots / Bets" rel="required" value="<?php echo $sess_produk['NO_BATCH']; ?>" /></td><td class="td_left">Tanggal Expire</td><td class="td_right"><input type="text" rel="required" class="sdate" name="TEMUAN[TANGGAL_EXPIRE]" title="Tanggal Expire Produk" value="<?php echo $sess_produk['TANGGAL_EXPIRE']; ?>" /></td></tr>
	<tr><td class="td_left">Jumlah Temuan</td><td class="td_right"><input rel="required" type="text" name="TEMUAN[JUMLAH_TEMUAN]" class="sdate" title="Jumlah Temuan" value="<?php echo $sess_produk['JUMLAH_TEMUAN']; ?>" />&nbsp;&nbsp;<?php echo form_dropdown('TEMUAN[SATUAN]',$kemasan,$sess_produk['SATUAN'],'class="sel_penyimpangan" title="Kemasan"'); ?></td><td class="td_left">Tindakan Terhadap Produk</td><td class="td_right"><?php echo form_dropdown('TEMUAN[TINDAKAN_PRODUK][]',$tindakan_produk,explode(",",$sess_produk['TINDAKAN_PRODUK']),'class="stext multiselect" multiple rel="required" title="Tindakan Terhadap Produk. Jika lebih dari satu, Klik + Ctrl untuk memilih" id="tproduk"'); ?></td></tr>
    <tr><td class="td_left">Pendaftar</td><td class="td_right"><input type="text" class="stext" name="TEMUAN[NAMA_PERUSAHAAN]" id="nmsarana" title="Nama Sarana" rel="required" value="<?php echo $sess_produk['NAMA_PERUSAHAAN']; ?>" /></td><td class="td_left">Alamat Pendaftar</td><td class="td_right"><textarea class="stext" id="alsarana" rel="required" title="Alamat Sarana" name="TEMUAN[ALAMAT_PERUSAHAAN]"><?php echo $sess_produk['ALAMAT_PERUSAHAAN']; ?></textarea></td></tr>
    <tr><td class="td_left">Importir</td><td class="td_right"><input rel="required" type="text" class="stext" id="pemilik" name="TEMUAN[PEMILIK]" title="Pemilik Sarana" value="<?php echo $sess_produk['PEMILIK']; ?>" /></td><td class="td_left">Keterangan</td><td class="td_right"><textarea rel="required" class="stext" id="keterangan" title="Keterangan" name="TEMUAN[KETERANGAN_SUMBER]"><?php echo $sess_produk['KETERANGAN_SUMBER']; ?></textarea></td></tr>
    <tr><td class="temuan_left">Harga Satuan</td><td class="temuan_right"><input type="text" class="sdate" id="harga" title="Harga Satuan" value="<?php echo $sess_produk['HARGA_SATUAN']; ?>" name="TEMUAN[HARGA_SATUAN]" /></td><td class="temuan_pemisah">&nbsp;</td><td class="temuan_left">&nbsp;</td><td class="temuan_right">&nbsp;</td></tr>
</table>
<input type="hidden" name="TEMUAN[FLAG]" value="0" id="flag">