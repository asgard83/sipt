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
		$('select, textarea, input:not(:image, submit, checkbox, radio)').poshytip({className: 'tip-twitter',showTimeout: 1,alignTo: 'target',alignX: 'right',alignY: 'center',offsetX: 5,allowTipHover: false,fade: false,slide: false});
		
		<?php #if($this->newsession->userdata('SESS_BBPOM_ID') == "00" || in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))){ ?>
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
        <tr><td class="td_left">Telepon</td><td class="td_right"><?php $telepon = explode(";", $sess['TELEPON']); echo join("<br>", $telepon); ?></td></tr>
        <tr><td class="td_left">Nama Pemilik</td><td class="td_right"><?php echo $sess['NAMA_PIMPINAN']; ?></td></tr>
        <tr><td class="td_left">Nama Penanggung Jawab</td><td class="td_right"><?php echo $sess['PENANGGUNG_JAWAB']; ?></td></tr>
        <tr><td class="td_left">Nomor Izin</td><td class="td_right"><?php echo $sess['NOMOR_IZIN']; ?></td></tr>
        <tr><td class="td_left">Tanggal Izin</td><td class="td_right"><?php echo $sess['TANGGAL_IZIN']; ?></td></tr>
        <tr><td class="td_left">Nomor SIK</td><td class="td_right"><?php echo $sess['NO_SIK']; ?></td></tr>
    </table>
    <?php
}else{
	?>
    <table class="form_tabel detil">
        <tr><td class="td_left">Alamat</td><td class="td_right"><textarea name="SARANA[ALAMAT_1]" class="stext" title="Alamat Sarana" rel="required"><?php echo $sess['ALAMAT_1']; ?></textarea></td></tr>                
        <tr><td class="td_left">Propinsi</td><td class="td_right"><?php echo form_dropdown('SARANA[PROPINSI]',$propinsi,$sel_propinsi,'id="propinsi" class="stext" rel="required" title="Nama Propinsi asal sarana" url="'.site_url().'/autocompletes/autocomplete/set_kota/"'); ?></td></tr>
        <tr><td class="td_left">Kota / Kabupaten</td><td class="td_right"><?php echo form_dropdown('SARANA[KOTA]',$kota,$sel_kota,'class="stext" id="kota" rel="required" title="Nama Kota asal sarana"'); ?></td></tr>

        <tr><td class="td_left">Telepon</td><td class="td_right"><input type="text" name="SARANA[TELEPON]" class="stext" title="Nomor Telepon Sarana. Contoh penulisan : 021xxxxxx. Jika lebih dari satu, gunakan tanda pemisah ; (titik koma)" value="<?php echo $sess['TELEPON']; ?>"></td></tr>
        <tr><td class="td_left">Nama Pemilik</td><td class="td_right"><input type="text" name="SARANA[NAMA_PIMPINAN]" value="<?php echo $sess['NAMA_PIMPINAN']; ?>" class="stext" title="Nama Pemilik Sarana"/></td></tr>
        <tr><td class="td_left">Nama Penanggung Jawab</td><td class="td_right"><input type="text" name="SARANA[PENANGGUNG_JAWAB]" value="<?php echo $sess['PENANGGUNG_JAWAB']; ?>" class="stext" title="Nama Penanggung Jawab Sarana."/></td></tr>
        <tr><td class="td_left">Nomor Izin</td><td class="td_right"><input type="text" name="SARANA[NOMOR_IZIN]" class="stext" title="Nomor izin Sarana." value="<?php echo $sess['NOMOR_IZIN']; ?>"></td></tr>
        <tr><td class="td_left">Tanggal Izin</td><td class="td_right"><input type="text" name="SARANA[TANGGAL_IZIN]" class="sdate" id="tg_izin" value="<?php echo $sess['TANGGAL_IZIN']; ?>" title="Tanggal izin. Contoh format penulisan tanggal izin : dd/mm/yyyy"></td></tr>
        <tr><td class="td_left">Nomor SIK</td><td class="td_right"><input type="text" name="SARANA[NO_SIK]" class="stext" title="No. SIK" value="<?php echo $sess['NO_SIK']; ?>"></td></tr>
    </table>
    <?php
}
?>
