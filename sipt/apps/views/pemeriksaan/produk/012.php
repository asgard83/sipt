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
<tr><td class="td_left">Nama Kosmetik</td><td class="td_right"><input rel="required" type="text" class="stext" id="nama_produk" title="Nama Kosmetik" url="<?php echo site_url(); ?>/autocompletes/autocomplete/produk_reg/12" name="TEMUAN[NAMA_PRODUK]" value="<?php echo $sess_produk['NAMA_PRODUK']; ?>" /></td><td class="td_left">Nama Perusahaan</td><td class="td_right"><input rel="required" type="text" name="TEMUAN[PRODUSEN]" class="stext" id="produsen" title="Nama perusahaan" value="<?php echo $sess_produk['PRODUSEN']; ?>"/></td></tr>
<tr><td class="td_left">Klasifikasi Produk</td><td class="td_right"><?php echo form_dropdown('TEMUAN[KLASIFIKASI_PRODUK]',$klasifikasi_temuan,'','class="stext" title="Pilih salah satu : Lokal , Impor" rel="required"'); ?></span></td><td class="td_left">Alamat Perusahaan</td><td class="td_right"><textarea rel="required" class="stext" name="TEMUAN[ALAMAT_PERUSAHAAN]" id="alamat" title="Alamat perusahaan"><?php echo $sess_produk['ALAMAT_PERUSAHAAN']; ?></textarea></td></tr>
<tr><td class="td_left">Tanggal Expire</td><td class="td_right"><input rel="required" type="text" class="sdate" name="TEMUAN[TANGGAL_EXPIRE]" value="<?php echo $sess_produk['TANGGAL_EXPIRE']; ?>"  title="Tanggal expire" />&nbsp;<small>Jika kosong, isi dengan tanda - (strip)</small></td><td class="td_left">No. Registrasi / Notifkasi</td><td class="td_right"><input rel="required" type="text" class="stext" id="no_registrasi" name="TEMUAN[NOMOR_REGISTRASI]" value="<?php echo $sess_produk['NOMOR_REGISTRASI']; ?>" title="No. Registrasi / Notifikasi"/></td></tr>
<tr><td class="td_left">No. Batch</td><td class="td_right"><input type="text" rel="required" class="stext" name="TEMUAN[NO_BATCH]" value="<?php echo $sess_produk['NO_BATCH']; ?>" title="No. Batch" /></td><td class="td_left">Netto</td><td class="td_right"><input type="text" class="sdate" name="TEMUAN[NETTO]" title="Netto produk" rel="required" value="<?php echo $sess_produk['NETTO']; ?>"/>&nbsp;<small>Pemisah desimal gunakan titik</small></td></tr>
<tr><td class="td_left">Harga Satuan</td><td class="td_right"><input rel="required" type="text" class="sdate" name="TEMUAN[HARGA_SATUAN]" value="<?php echo $sess_produk['HARGA_SATUAN']; ?>" onkeyup="numericOnly($(this))" title="Harga satuan" /></td><td class="td_left">Jumlah Temuan</td><td class="td_right"><input type="text" rel="required" name="TEMUAN[JUMLAH_TEMUAN]" value="<?php echo $sess_produk['JUMLAH_TEMUAN']; ?>" class="sdate" onkeyup="numericOnly($(this))" title="Jumlah temuan"  />&nbsp;&nbsp;&nbsp;&nbsp;<?php echo form_dropdown('TEMUAN[SATUAN]',$kemasan,$sess_produk['SATUAN'],'class="sel_penyimpangan" rel="required" title="Kemasan"'); ?></td></tr>
<tr><td class="td_left">Kategori Temuan</td><td class="td_right"><?php echo form_dropdown('TEMUAN[KATEGORI]',$kategori_temuan,$sess_produk['KATEGORI'],'class="stext" rel="required" title="Pilih salah satu : TIE, Dilarang, Penandaan, Kadaluarsa, Rusak"'); ?></td><td class="td_left">Jenis Pelanggaran</td><td class="td_right"><input type="text" class="stext" rel="required" name="TEMUAN[JENIS_PELANGGARAN]" value="<?php echo $sess_produk['JENIS_PELANGGARAN']; ?>" title="Jenis pelanggaran" /></td></tr><tr><td class="td_left">Tindakan Produk</td><td class="td_right"><?php echo form_dropdown('TEMUAN[TINDAKAN_PRODUK]',$tindakan_produk,$sess_produk['TINDAKAN_PRODUK'],'class="stext" title="Pilih salah satu : Pengamanan, Pemusnahan, Penarikan" rel="required"'); ?></td><td class="td_left">Keterangan Sumber (perolehan)</td><td class="td_right"><input type="text" class="stext" name="TEMUAN[KETERANGAN_SUMBER]" value="<?php echo $sess_produk['KETERANGAN_SUMBER']; ?>" rel="required" title="Keterangan sumber (perolehan)" /></td></tr>
</table>
<input type="hidden" name="TEMUAN[FLAG]" value="0" id="flag">