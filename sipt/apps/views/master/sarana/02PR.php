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
        <tr><td class="td_left">Alamat</td><td class="td_right"><?php echo $sess['ALAMAT_1']; ?></td></tr>
        <tr><td class="td_left">Propinsi</td><td class="td_right"><?php echo $sess['NAMA_PROP']; ?></td></tr>
        <tr><td class="td_left">Kota / Kabupaten</td><td class="td_right"><?php echo $sess['NAMA_KOTA']; ?></td></tr>
        <tr><td class="td_left">Nama Pemilik / Pimpinan</td><td class="td_right"><?php echo $sess['NAMA_PIMPINAN']; ?></td></tr>
        <tr><td class="td_left">Nomor Izin Usaha</td><td class="td_right"><?php echo $sess['IZIN_PERUSAHAAN']; ?></td></tr>
    </table>
    <?php
}
else{
	?>
<table class="form_tabel detil">
    <tr><td class="td_left">Alamat</td><td class="td_right"><textarea class="stext" name="SARANA[ALAMAT_1]" title="Alamat Sarana. Jika mempunyai lebih dari satu, pisahkan dengan tanda ; (titik koma)" rel="required"><?php echo $sess['ALAMAT_1']; ?></textarea></td></tr>                
    <tr><td class="td_left">Propinsi</td><td class="td_right"><?php echo form_dropdown('SARANA[PROPINSI]',$propinsi,$sel_propinsi,'id="propinsi" class="stext" rel="required" title="Nama Propinsi asal sarana" url="'.site_url().'/autocompletes/autocomplete/set_kota/"'); ?></td></tr>
        <tr><td class="td_left">Kota / Kabupaten</td><td class="td_right"><?php echo form_dropdown('SARANA[KOTA]',$kota,$sel_kota,'class="stext" id="kota" rel="required" title="Nama Kota asal sarana"'); ?></td></tr>

    <tr><td class="td_left">Nama Pemilik / Pimpinan</td><td class="td_right"><input type="text" class="stext" name="SARANA[NAMA_PIMPINAN]" value="<?php echo $sess['NAMA_PIMPINAN']; ?>" title="Nama Pemilik Sarana / Pimpinan" /></td></tr>
    <tr><td class="td_left">Nomor Izin Usaha</td><td class="td_right"><input type="text" class="stext" name="SARANA[IZIN_PERUSAHAAN]" value="<?php echo $sess['IZIN_PERUSAHAAN']; ?>" title="Nomor Izin Usaha Sarana" /></td></tr>
</table>
<?php
}
?>