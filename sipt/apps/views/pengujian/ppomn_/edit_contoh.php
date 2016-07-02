<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR); ?>
<div id="judulmsampel" class="judul"></div>
<div class="headersarana"><?php echo $judul; ?></div>
<div class="content">
    <div class="adCntnr">
    	<div class="acco2">
        	<div class="expand"><a title="expand/collapse" href="#" style="display: block;">FORM DATA SAMPEL</a></div>
                <div class="accCntnt">
                  <h2 class="small garis">Edit Data Sampel</h2>
                  <form name="fnewsampel" id="fnewsampel" method="post" action="<?php echo $act; ?>" autocomplete="off">
                    <table class="form_tabel">
                    	<tr><td class="td_left">Komoditi</td><td class="td_right"><?php echo form_dropdown('SAMPEL[KLASIFIKASI]',$komoditi,$sess['KLASIFIKASI'],'class="stext komoditi" title="Komoditi" ke="1" id="sel1" rel="required"'); ?></td><td width="10"></td><td class="td_left">Komoditi Tambahan</td><td class="td_right"><?php echo form_dropdown('SAMPEL[KLASIFIKASI_TAMBAHAN]',$klasifikasi_tambahan,$sess['KLASIFIKASI_TAMBAHAN'],'class="stext" title="Komoditi" id="kk_tambahan"'); ?></td></tr>
                    	<tr><td class="td_left">Nama sampel</td><td class="td_right"><input type="text" class="stext" title="Nama sampel" name="SAMPEL[NAMA_SAMPEL]" id="nama_sampel" rel="required" value="<?php echo $sess['NAMA_SAMPEL'];?>" url="<?php echo site_url(); ?>/autocompletes/autocomplete/produk_reg/"/><input type="hidden" id="klasifikasi" value="<?php echo $sess['KLASIFIKASI']; ?>" /></td><td width="10"></td><td class="td_left">No Registrasi</td><td class="td_right"><input type="text" class="stext" title="Nomor Registrasi" name="SAMPEL[NOMOR_REGISTRASI]" value="<?php echo $sess['NOMOR_REGISTRASI']; ?>" id="nie" /></td></tr>
                    	<tr>
                    	  <td class="td_left">Kategori sampel</td>
                    	  <td class="td_right"><?php echo form_dropdown('SAMPEL[SUB_KLASIFIKASI]',$sub_komoditi,$sess['SUB_KLASIFIKASI'],'class="stext komoditi" title="Sub Komoditi atau Sub Kategori sampel" id="sel2" ke="2"'); ?></td><td width="10"></td>
                    	<td class="td_left">Sub Kategori sampel</td><td class="td_right"><?php echo form_dropdown('SAMPEL[SUB_SUB_KLASIFIKASI]',$sub_sub_komoditi,$sess['SUB_SUB_KLASIFIKASI'],'class="stext komoditi" title="Sub Sub Komoditi atau Sub Sub Kategori sampel" id="sel3" ke="3"'); ?></td></tr>
                    	<tr><td class="td_left">Pabrik</td><td class="td_right"><input type="text" class="stext" title="Nama Pabrik" name="SAMPEL[PABRIK]" value="<?php echo $sess['PABRIK']; ?>" id="pabrik" /></td><td width="10"></td><td class="td_left">Importir</td><td class="td_right"><input type="text" class="stext" name="SAMPEL[IMPORTIR]" title="Importir" id="pemilik" value="<?php echo $sess['IMPORTIR']; ?>" /></td></tr>                    	
                        <tr><td class="td_left">Bentuk Sediaan sampel</td><td class="td_right"><input type="text" class="stext" title="Bentuk Sediaan Sampel / sampel" name="SAMPEL[BENTUK_SEDIAAN]" value="<?php echo $sess['BENTUK_SEDIAAN']; ?>" id="bentuk" /></td><td width="10"></td><td class="td_left">Kemasan sampel</td><td class="td_right"><input type="text" class="stext" title=" Kemasan Sampel / sampel" name="SAMPEL[KEMASAN]" value="<?php echo $sess['KEMASAN']; ?>" id="kemasan" /></td></tr>
                    	<tr><td class="td_left">No Bets</td><td class="td_right"><input type="text" name="SAMPEL[NO_BETS]" class="stext" title="Nomor Bets" value="<?php echo $sess['NO_BETS']; ?>" /></td><td width="10"></td><td class="td_left">Keterangan ED</td><td class="td_right"><input type="text" class="sdate" title="Expire Date" name="SAMPEL[KETERANGAN_ED]" value="<?php echo $sess['KETERANGAN_ED']; ?>" /></td></tr>
                    	<tr><td class="td_left">Komposisi</td><td class="td_right"><textarea class="stext" style="height:80px; resize:none;" name="SAMPEL[KOMPOSISI]" title="Komposisi sampel. Jika lebih dari satu, pisahkan dengan titik koma"><?php echo $sess['KOMPOSISI']; ?></textarea></td><td width="10"></td><td class="td_left">Netto</td><td class="td_right"><input type="text" class="stext w100" title="Netto" name="SAMPEL[NETTO]" value="<?php echo $sess['NETTO']; ?>" /></td></tr>
                    	<tr><td class="td_left">Evaluasi Penandaan</td><td class="td_right"><input type="text" class="stext" title="Evaluasi Penandaan, Misal : Tidak dicantumkan nomor reg, nomor reg lama" name="SAMPEL[EVALUASI_PENANDAAN]" value="<?php echo $sess['EVALUASI_PENANDAAN']; ?>" /></td><td width="10"></td><td class="td_left">Cara Penyimpanan</td><td class="td_right"><input type="text" class="stext" title="Sesuai dengan keterangan yang ada di label" name="SAMPEL[CARA_PENYIMPANAN]" value="<?php echo $sess['CARA_PENYIMPANAN']; ?>" /></td></tr>
                    	<tr><td class="td_left">Kondisi sampel</td><td class="td_right"><?php echo form_dropdown('SAMPEL[KONDISI_SAMPEL]',$kondisi_sampel,$sess['KONDISI_SAMPEL'],'class="stext" title="Kondisi sampel" rel="required"'); ?></td><td width="10"></td><td class="td_left">Jumlah sampel</td><td class="td_right"><input type="text" class="scode" id="jumlah" title="Jumlah sampel" rel="required" value="<?php echo array_key_exists('JUMLAH_SAMPEL', $sess)?$sess['JUMLAH_SAMPEL']:"0"; ?>" name="SAMPEL[JUMLAH_SAMPEL]"/>&nbsp;&nbsp;<?php echo form_dropdown('SAMPEL[SATUAN]',$satuan,$sess['SATUAN'],'class="stext sjenis" title="Satuan" rel="required"'); ?></td></tr>
                    	<tr>
                    	  <td class="td_left">Pengujian</td>
                    	  <td class="td_right"><div style="padding-bottom:5px;"><input type="checkbox" name="lab[]" class="chklab" id="kimia" onchange="check_uji('#kimia', '#jml_kimia');" value="K" <?php echo $sess['UJI_KIMIA'] > 0 ? 'checked="checked"' : ''; ?> />&nbsp;Kimia&nbsp;<input type="text" class="scode jml" title="Pengujian Kimia" id="jml_kimia" value="<?php echo array_key_exists('JUMLAH_KIMIA', $sess)?$sess['JUMLAH_KIMIA']:"0"; ?>" name="SAMPEL[JUMLAH_KIMIA]" <?php echo trim($sess['JUMLAH_KIMIA']) != "" ? "":'readonly="readonly"'; ?> /></div><div style="padding-bottom:5px;"><input type="checkbox" class="chklab" name="lab[]" id="mikro" onchange="check_uji('#mikro', '#jml_mikro');" value="M" <?php echo $sess['UJI_MIKRO'] > 0 ? 'checked="checked"' : ''; ?>/>&nbsp;Mikro&nbsp;<input type="text" class="scode jml" title="Pengujian Mikro" name="SAMPEL[JUMLAH_MIKRO]" <?php echo trim($sess['JUMLAH_KIMIA']) != "" ? "":'readonly="readonly"'; ?> id="jml_mikro" value="<?php echo array_key_exists('JUMLAH_MIKRO', $sess)?$sess['JUMLAH_MIKRO']:"0"; ?>" onkeyup="numericOnly($(this))" /></div>
                          <div><span style="margin-left:22px;">Sisa</span>&nbsp;<input type="text" class="scode" id="sisa" title="Sisa (retain) sampel " name="SAMPEL[SISA]" readonly="readonly" value="<?php echo array_key_exists('SISA', $sess)?$sess['SISA']:"0"; ?>" onkeyup="numericOnly($(this))" /></div></td>
                    	  <td></td>
                    	  <td class="td_left">Harga Pembelian</td>
                    	  <td class="td_right"><input type="text" class="stext w100" title="Harga Pembelian" name="SAMPEL[HARGA_SAMPEL]" rel="required" value="<?php echo $sess['HARGA_SAMPEL']; ?>" onkeyup="numericOnly($(this))"/></td>
                  	  </tr>
                        <tr>
                          <td class="td_left">Catatan</td><td class="td_right"><textarea class="stext" title="Catatan" name="SAMPEL[CATATAN]"><?php echo $sess['CATATAN']; ?></textarea></td><td width="10"></td>
                          <td class="td_left">Lampiran File</td><td class="td_right"><input type="file" class="stext" title="Lampiran File : file photo dan lain-lain" /></td></tr>
                    </table>
                    <input type="hidden" name="kode_sampel" value="<?php echo $sess['KODE_SAMPEL']; ?>" />
                    <input type="hidden" name="status_sampel" value="<?php echo $sess['STATUS_SAMPEL']; ?>" />
                    </form>
            </div><!-- Akhir Informasi Pemeriksaan Sampel !-->
        </div>
    </div>
    <div style="height:10px;">&nbsp;</div>
    <div style="padding-left:5px;"><a href="#" class="button save" onclick="fpost('#fnewsampel','',''); return false;"><span><span class="icon"></span>&nbsp; <?php echo $save; ?> &nbsp;</span></a>&nbsp;<a href="#" class="button reload" url="<?php echo $batal; ?>" onclick="batal($(this)); return false;"><span><span class="icon"></span>&nbsp; Batal &nbsp;</span></a></div>
    <div style="height:10px;">&nbsp;</div>
   
</div>
<script type="text/javascript">
$(document).ready(function(){
	var sisa = 0;
	$('input.sdate').datepicker({ dateFormat: 'dd/mm/yy',regional: 'id'});
	$('select.komoditi').change(function(){
		var ke = $(this).attr('ke');
		var kunci = $(this).val();
		if(ke == 1){
			$(this).attr("klas",kunci);
			$.get('<?php echo site_url().'/autocompletes/autocomplete/get_kk_tambahan/'; ?>' + kunci, function(hasil){
				var hasil = hasil.replace(' ', '');
				var jum = hasil.length;
				if(jum==0){
					$('#kk_tambahan').html();
				}else{
					$('#kk_tambahan').html(hasil);
				}
			});
		}
		ke = parseInt(ke) + 1;
		for(i=ke;i<=3;i++){
			$('#sel' + ke).html();
		}
		$.get('<?php echo site_url().'/autocompletes/autocomplete/get_kategori/'; ?>' + kunci, function(hasil){
			var hasil = hasil.replace(' ', '');
			var jum = hasil.length;
			if(jum==0){
				$('#sel' + ke).html();
			}else{
				$('#sel' + ke).html(hasil);
			}
		});
	});
	$("#nama_sampel").autocomplete($("#nama_sampel").attr('url') + $("#sel1").attr("klas"), {width: 244, selectFirst: false});
	$("#nama_sampel").result(function(event, data, formatted){
		if(data){
			$(this).val(data[1]);
			$("#nie").val(data[2]);
			$("#kemasan").val(data[4]);
			$("#pemilik").val(data[7]);
			$("#pabrik").val(data[6]);
			$("#bentuk").val(data[9]);
		}
	});
	$("#jml_kimia").change(function(){
		var jml = parseInt($("#jml_mikro").val()) + parseInt($("#jml_kimia").val());
		if($("#jumlah").val() == "" || parseInt($("#jumlah").val()) == 0) return false;
		sisa = parseInt($("#jumlah").val()) - (parseInt($("#jml_mikro").val()) + parseInt($(this).val()));		
		if(parseInt($("#jml_kimia").val()) + sisa > parseInt($("#jumlah").val())){
			jAlert('Jumlah sampel melebihi sisa sampel','SIPT versi 1.0')
			$("#jml_kimia").focus();
		}
		if(jml > parseInt($("#jumlah").val())){
			jAlert('Total jumlah sampel kimia dan mikro melebihi jumlah sampel','SIPT versi 1.0')
			$("#jml_kimia").focus();
			$("#jml_kimia").val('0');
			sisa = parseInt($("#jumlah").val()) - (parseInt($("#jml_mikro").val()) + parseInt($(this).val()));
		}
		if(sisa < 0) sisa = 0;
		$("#sisa").val(parseInt(sisa));
	});
	$("#jml_mikro").change(function(){
		var jml = parseInt($("#jml_mikro").val()) + parseInt($("#jml_kimia").val());
		if($("#jumlah").val() == "" || parseInt($("#jumlah").val()) == 0) return false;
		sisa = parseInt($("#jumlah").val()) - (parseInt($("#jml_kimia").val()) + parseInt($(this).val()));
		if(parseInt($("#jml_mikro").val()) + sisa > parseInt($("#jumlah").val())){
			jAlert('Jumlah sampel melebihi sisa sampel','SIPT versi 1.0')
			$("#jml_mikro").focus();
		}
		if(jml > parseInt($("#jumlah").val())){
			jAlert('Total jumlah sampel kimia dan mikro melebihi jumlah sampel','SIPT versi 1.0')
			$("#jml_mikro").focus();
			$("#jml_mikro").val('0');
			sisa = parseInt($("#jumlah").val()) - (parseInt($("#jml_kimia").val()) + parseInt($(this).val()));
		}
		if(sisa < 0) sisa = 0;
		$("#sisa").val(parseInt(sisa));
	});
	
});
function check_uji(obj, next){
	var jml = $("#jumlah").val();
	if($(obj).is(':checked')){
		if(jml > 0){
			$(next).attr("readonly", "");
			$(next).focus();
		}
	}else{
		$(next).attr("readonly", "readonly");
		$(next).val('0');
	}
	sisa = parseInt($("#jumlah").val()) - (parseInt($("#jml_kimia").val()) + parseInt($("#jml_mikro").val()));
	$("#sisa").val(parseInt(sisa));
}
</script>            