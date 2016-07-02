<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR); ?>
<script type="text/javascript">
	$(document).ready(function(){
		$('input, select, textarea').focus(function(){$(this).css('background-color','#FFF');$(this).css('border','1px solid #dddddd');});
		$("table.form_tabel tr:even").css("background-color", "#f0f0f0");
		$("table.form_tabel tr:odd").css("background-color", "#fff");
		$('select, textarea, input:not(:image, submit, checkbox, radio)').poshytip({className: 'tip-twitter',showTimeout: 1,alignTo: 'target',alignX: 'right',alignY: 'center',offsetX: 5,allowTipHover: false,fade: false,slide: false});
		$("#sarana_bb").autocomplete($("#sarana_bb").attr("url"), {width: 244, selectFirst: false}); 
		$("#sarana_bb").result(function(event, data, formatted){ 
			if(data){ 
				$(this).val(data[2]); 
				$("#alamat_bb").val(data[3]); 
			} 
		});
	});
</script>
<table class="form_tabel">
<tr><td class="td_left">Bahan Berbahaya</td><td class="td_right">
<select class="stext" title="Bahan Berbahaya" id="nama_bb" name="TEMUAN[NAMA_BB]">
<option value=""></option>
<option value="Larutan Formaldehid">Larutan Formaldehid (Formalin)</option>
<option value="Paraformaldehid serbuk">Paraformaldehid serbuk</option>
<option value="Paraformaldehidtablet">Paraformaldehidtablet</option>
<option value="Boraks">Boraks</option>
<option value="Rhodamin B">Rhodamin B</option>
<option value="Kuning Metanil">Kuning Metanil</option>
<option value="Auramin">Auramin</option>
<option value="Amaran">Amaran</option>
</select></td><td class="td_left">Nama Dagang</td><td class="td_right"><input type="text" class="stext" id="nama_dagang" name="TEMUAN[NAMA_PRODUK]" title="Nama Dagang"/></td></tr>
<tr><td class="td_left">Ukuran kemasan</td><td class="td_right"><input type="text" class="stext" id="ukuran_bb" title="Ukuran Kemasan" name="TEMUAN[KEMASAN]"/></td><td class="td_left">Asal Bahan Berbahaya</td><td class="td_right"><?php echo form_dropdown('TEMUAN[KLASIFIKASI_PRODUK]',$klasifikasi_temuan,'','class="stext" id="asal_bb" title="Pilih salah satu : Lokal , Impor"'); ?></td></tr>
<tr><td class="td_left">Sumber Pengadaan</td><td class="td_right">
<?php echo form_dropdown('TEMUAN[SUMBER_PENGADAAN]', $status_bb, $sess['STATUS_BB'], 'class="stext" title="Sumber Pengadaan" id="sumber_bb"'); ?>					
</td><td class="td_left">Nama Sarana</td><td class="td_right"><input type="text" class="stext" id="sarana_bb" title="Nama Sarana Pengadaan" url="<?php echo site_url(); ?>/autocompletes/autocomplete/sarana_bb" name="TEMUAN[NAMA_PERUSAHAAN]"/></td></tr>
<tr><td class="td_left">Alamat</td><td class="td_right"><textarea class="stext" title="Alamat pengadaan" name="TEMUAN[ALAMAT_PERUSAHAAN]" id="alamat_bb"></textarea></td><td class="td_left">Telepon</td><td class="td_right"><input type="text" class="stext" id="telepon_bb" name="TEMUAN[TELEPON]" title="Telepon Sarana Pengadaan"/></td></tr>
<tr>
  <td class="td_left">Cara Pembelian </td>
  <td class="td_right"><input type="text" class="stext" id="pembelian_bb" title="Cara pembelian" name="TEMUAN[CARA_PEMBELIAN]"/></td>
  <td class="td_left">Status Produk</td>
  <td class="td_right"><select class="stext" title="Status Produk" id="status_bb" name="TEMUAN[STATUS_REPACKING]"><option value=""></option><option value="1">Hasil Repacking</option><option value="0">Kemasan Original</option></select></td>
</tr>
<?php /*?><tr>
  <td class="td_left">Lampiran File</td>
  <td colspan="3" class="td_right"><span class="upload_LABEL"><input type="file" class="stext upload" jenis="LABEL" allowed="jpeg-jpg" url="<?php echo site_url(); ?>/utility/uploads/get_upload/<?php echo $sess['SARANA_ID'];?>" id="fileToUpload_LABEL" title="File Lampiran (attachment)" name="userfile" onchange="do_upload_produk($(this)); return false;"/>&nbsp;<div>Tipe File : *.jpeg, *.jpg</div></span><span class="file_LABEL"></span></td>
</tr>
<?php */?>
</table>
<input type="hidden" name="TEMUAN[FLAG]" value="0" id="flag">