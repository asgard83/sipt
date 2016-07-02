<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);
?>
<script type="text/javascript">
	$(document).ready(function(){
		$('input, select, textarea').focus(function(){
			$(this).css('background-color','#FFF');
			$(this).css('border','1px solid #dddddd');
		});
		$("table.form_tabel tr:even").css("background-color", "#f0f0f0");
		$("table.form_tabel tr:odd").css("background-color", "#fff");
		$('select, textarea, input:not(:image, submit, checkbox, radio)').poshytip({className: 'tip-twitter',showTimeout: 1,alignTo: 'target',alignX: 'right',alignY: 'center',offsetX: 5,allowTipHover: false,fade: false,slide: false});		<?php #if($this->newsession->userdata('SESS_BBPOM_ID') == "00" || in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))){ ?>
		$("#propinsi").change(function(){ 
			var propinsi = $(this).val(); 
			$.get($(this).attr('url')+ propinsi, function(hasil){
				$("#kota").html(hasil);
			});
		});		
		<?php #} ?>
});
</script>

<h2 class="small">Jenis Sarana : <?php echo $nama_jenis_sarana; ?></h2>
<?php
if($ispreview){
	?>
    <table class="form_tabel detil">
        <tr><td class="td_left">Alamat Kantor</td><td class="td_right"><ul style="list-style-type:disc; padding-left:15px; margin:0;"><?php $alamat_1 = explode(";", $sess['ALAMAT_1']); echo "<li>".join("</li><li>", $alamat_1)."</li>"; ?></ul></td></tr>
        <tr><td class="td_left">Alamat Pabrik / Gudang</td><td class="td_right"><ul style="list-style-type:disc; padding-left:15px; margin:0;"><?php $alamat_2 = explode(";", $sess['ALAMAT_2']); echo "<li>".join("</li><li>", $alamat_2)."</li>"; ?></ul></td></tr>
        <tr><td class="td_left">Propinsi</td><td class="td_right"><?php echo $sess['NAMA_PROP']; ?></td></tr>
        <tr><td class="td_left">Kota / Kabupaten</td><td class="td_right"><?php echo $sess['NAMA_KOTA']; ?></td></tr>
        <tr><td class="td_left">Jenis Industri</td><td class="td_right"><?php echo $sess['JENIS_INDUSTRI']; ?></td></tr>
        <tr><td class="td_left">Kegiatan yang Dilakukan oleh Sarana Produksi</td><td class="td_right"><ul style="list-style-type:decimal; padding-left:20px; margin:0;"><?php $kegiatan = explode(";", $sess['KEGIATAN_SARANA']); echo "<li>".join("</li><li>", $kegiatan)."</li>"; ?></ul></td></tr>
        <tr><td class="td_left">Nama Pemilik</td><td class="td_right"><?php echo $sess['NAMA_PIMPINAN']; ?></td></tr>
        <tr><td class="td_left">Nama Penanggung Jawab</td><td class="td_right"><?php echo $sess['PENANGGUNG_JAWAB']; ?></td></tr>
    </table>
    <?php
}else{
	?>
    <table class="form_tabel detil">
        <tr><td class="td_left">Alamat Kantor</td><td class="td_right"><textarea class="stext" name="SARANA[ALAMAT_1]" title="Alamat Sarana. Jika mempunyai lebih dari satu, pisahkan dengan tanda ; (titik koma)"  rel="required"><?php echo $sess['ALAMAT_1']; ?></textarea></td></tr>
        <tr><td class="td_left">Alamat Pabrik / Gudang</td><td class="td_right"><textarea class="stext" name="SARANA[ALAMAT_2]" title="Alamat Sarana. Jika mempunyai lebih dari satu, pisahkan dengan tanda ; (titik koma)"  rel="required"><?php echo $sess['ALAMAT_2']; ?></textarea></td></tr>                
        <tr><td class="td_left">Propinsi</td><td class="td_right"><?php echo form_dropdown('SARANA[PROPINSI]',$propinsi,$sel_propinsi,'id="propinsi" class="stext" rel="required" title="Nama Propinsi asal sarana" url="'.site_url().'/autocompletes/autocomplete/set_kota/"'); ?></td></tr>
        <tr><td class="td_left">Kota / Kabupaten</td><td class="td_right"><?php echo form_dropdown('SARANA[KOTA]',$kota,$sel_kota,'class="stext" id="kota" rel="required" title="Nama Kota asal sarana"'); ?></td></tr>

        <tr><td class="td_left">Jenis Industri</td><td class="td_right"><?php echo form_dropdown('SARANA[JENIS_INDUSTRI]',$jenis_industri[0],$sess['JENIS_INDUSTRI'],'class="stext" title="Pilih salah satu jenis industri"'); ?></td></tr>
        <tr><td class="td_left">Kegiatan yang Dilakukan oleh Sarana Produksi</td><td class="td_right"><textarea class="stext" name="SARANA[KEGIATAN_SARANA]" title="Kegiatan yang dilakukan oleh sarana produksi. Jika melakukan kegiatan lebih dari satu, pisahkan dengan tanda ; (titik koma). Pilihan : Produksi bahan baku kosmetik; Produksi produk jadi kosmetik; Produksi produk antara dan bulk; Pengujian/laboratorium"><?php echo $sess['KEGIATAN_SARANA']; ?></textarea></td></tr>
        <tr><td class="td_left">Nama Pemilik</td><td class="td_right"><input type="text" class="stext" name="SARANA[NAMA_PIMPINAN]" value="<?php echo $sess['NAMA_PIMPINAN']; ?>" title="Nama Pemilik Sarana" /></td></tr>
        <tr><td class="td_left">Nama Penanggung Jawab</td><td class="td_right"><input type="text" class="stext" name="SARANA[PENANGGUNG_JAWAB]" value="<?php echo $sess['PENANGGUNG_JAWAB']; ?>" title="Penanggung Jawab Sarana" /></td></tr>
    </table>
    <?php
}
?>
