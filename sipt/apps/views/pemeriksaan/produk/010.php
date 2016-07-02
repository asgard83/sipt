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
				$("#produsen").val(data[3]);
				$("#alamat").val(data[5]);
				$("#flag").val('1');
			}
		});
	});
</script>

<table class="form_tabel">
<tr><td class="td_left">Nama Obat Tradisional</td><td class="td_right"><input type="text" rel="required" name="TEMUAN[NAMA_PRODUK]" class="stext" id="nama_produk" title="Nama obat tradisional" url="<?php echo site_url(); ?>/autocompletes/autocomplete/produk_reg/10" value="<?php echo $sess_produk['NAMA_PRODUK']; ?>" /></td><td class="td_left">Nama Perusahaan</td><td class="td_right"><input rel="required" type="text" class="stext" id="produsen" title="Nama perusahaan" name="TEMUAN[PRODUSEN]" value="<?php echo $sess_produk['PRODUSEN']; ?>"/></td></tr>
<tr><td class="td_left">Klasifikasi</td><td class="td_right"><?php echo form_dropdown('TEMUAN[KLASIFIKASI_PRODUK]',$klasifikasi_temuan,$sess_produk['KLASIFIKASI_TEMUAN'],'rel="required" class="stext" title="Klasifikasi produk"'); ?></td><td class="td_left">Alamat Perusahaan</td><td class="td_right"><textarea rel="required" class="stext" name="TEMUAN[ALAMAT_PERUSAHAAN]" id="alamat" title="Alamat perusahaan"><?php echo $sess_produk['ALAMAT_PERUSAHAAN']; ?></textarea></td></tr>
<tr><td class="td_left">No Registrasi</td><td class="td_right"><input rel="required" type="text" class="stext" id="no_registrasi" name="TEMUAN[NOMOR_REGISTRASI]" title="Nomor registrasi" value="<?php echo $sess_produk['NOMOR_REGISTRASI']; ?>"/></td><td class="td_left">No Batch</td><td class="td_right"><input type="text" rel="required" class="stext" name="TEMUAN[NO_BATCH]" value="<?php echo $sess_produk['NO_BATCH']; ?>" title="No Batch" /></td></tr>
<tr><td class="td_left">Tanggal Expire</td><td class="td_right"><input rel="required" type="text" class="sdate" name="TEMUAN[TANGGAL_EXPIRE]" value="<?php echo $sess_produk['TANGGAL_EXPIRE']; ?>" title="Tanggal expire" />&nbsp;<small>Jika kosong, isi dengan tanda - (strip)</small></td><td class="td_left">Netto</td><td class="td_right"><input rel="required" type="text" class="sdate" name="TEMUAN[NETTO]" value="<?php echo $sess_produk['NETTO']; ?>" title="Netto Produk"/></td></tr>
<tr><td class="td_left">Harga Satuan</td><td class="td_right"><input rel="required" type="text" class="sdate" name="TEMUAN[HARGA_SATUAN]" onkeyup="numericOnly($(this))" title="Harga satuan" value="<?php echo $sess_produk['HARGA_SATUAN']; ?>" /></td><td class="td_left">Kategori Temuan</td><td class="td_right"><?php echo form_dropdown('TEMUAN[KATEGORI]',$kategori_temuan,$sess_produk['KATEGORI'],'class="stext" id="kategori" rel="required" title="Kategori temuan"'); ?></td></tr>
<?php /*?><tr id="td_temuan" style="display:none;"><td class="td_left">&nbsp;</td><td class="td_right">&nbsp;</td><td class="td_left">&nbsp;</td><td class="td_right"><span class="tmk_penandaan" style="display:none;"><input type="text" id="F01HH_temuan_pelanggaran" class="stext" name="F01HH_temuan_pelanggaran" value="-" title="Keterangan TMK Penandaan" /></span><span class="farmasetik" style="display:none;"><?php echo form_dropdown('F01HH_temuan_farmasetik',$farmasetik,'','class="stext" id="F01HH_temuan_farmasetik" title="Kategori temuan farmasetik"'); ?></span></td></tr>
<?php */?>
<tr><td class="td_left">Jenis satuan</td><td class="td_right"><?php echo form_dropdown('TEMUAN[SATUAN]',$kemasan,$sess_produk['SATUAN'],'class="sel_penyimpangan" title="Kemasan"'); ?></td>
<td class="td_left">Tindakan Terhadap Produk</td>
<td class="td_right"><?php echo form_dropdown('TEMUAN[TINDAKAN_PRODUK]',$tindakan_produk, $sess_produk['TINDAKAN_PRODUK'],'rel="required" class="stext" title="Pilih salah satu tindak lanjut terhadap produk."'); ?></td></tr>
<tr><td class="td_left">Jumlah Temuan</td><td class="td_right"><input rel="required" type="text" name="TEMUAN[JUMLAH_TEMUAN]" value="<?php echo $sess_produk['JUMLAH_TEMUAN']; ?>"class="sdate" onkeyup="numericOnly($(this))" rel="required" title="Jumlah temuan" /></td><td class="td_left">Keterangan (sumber perolehan)</td><td class="td_right"><input type="text" rel="required" class="stext" name="TEMUAN[KETERANGAN_SUMBER]" title="Keterangan (sumber perolehan)" value="<?php echo $sess_produk['KETERANGAN_SUMBER']; ?>" /></td></tr>
</table>
<input type="hidden" name="TEMUAN[FLAG]" value="0" id="flag