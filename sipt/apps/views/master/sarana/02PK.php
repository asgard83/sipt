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
        <tr>
          <td class="td_left">Alamat Kantor</td><td class="td_right"><?php echo $sess['ALAMAT_1']; ?></td></tr>
        <tr>
          <td class="td_left">Alamat Gudang</td>
          <td class="td_right"><?php $gudang = explode(";", $sess['ALAMAT_2']); echo join("<br>", $gudang); ?></td>
        </tr>
        <tr><td class="td_left">Propinsi</td><td class="td_right"><?php echo $sess['NAMA_PROP']; ?></td></tr>
        <tr><td class="td_left">Kota / Kabupaten</td><td class="td_right"><?php echo $sess['NAMA_KOTA']; ?></td></tr>
        <tr><td class="td_left">Telepon</td><td class="td_right"><ul style="list-style-type:decimal; padding-left:20px; margin:0;"><?php $telepon = explode(";", $sess['TELEPON']); echo "<li>".join("</li><li>", $telepon)."</li>"; ?></ul></td></tr>
        <tr><td class="td_left">Nama Pimpinan</td><td class="td_right"><?php echo $sess['NAMA_PIMPINAN']; ?></td></tr>
        <tr><td class="td_left">Nama Penanggung Jawab</td><td class="td_right"><?php echo $sess['PENANGGUNG_JAWAB']; ?></td></tr>
    </table>
    <?php
}else{
	?>
    <table class="form_tabel detil">
        <tr>
          <td class="td_left">Alamat Kantor</td><td class="td_right"><textarea name="SARANA[ALAMAT_1]" class="stext" title="Alamat Sarana" rel="required"><?php echo $sess['ALAMAT_1']; ?></textarea></td></tr>
        <tr>
          <td class="td_left">Alamat Gudang</td>
          <td class="td_right"><textarea name="SARANA[ALAMAT_2]" class="stext" title="Alamat Gudang. Jika lebih dari satu, pisahkan dengan tanda ; (titik koma)" rel="required"><?php echo $sess['ALAMAT_2']; ?></textarea></td>
        </tr>                
        <tr><td class="td_left">Propinsi</td><td class="td_right"><?php echo form_dropdown('SARANA[PROPINSI]',$propinsi,$sel_propinsi,'id="propinsi" class="stext" rel="required" title="Nama Propinsi asal sarana" url="'.site_url().'/autocompletes/autocomplete/set_kota/"'); ?></td></tr>
        <tr><td class="td_left">Kota / Kabupaten</td><td class="td_right"><?php echo form_dropdown('SARANA[KOTA]',$kota,$sel_kota,'class="stext" id="kota" rel="required" title="Nama Kota asal sarana"'); ?></td></tr>

        <tr><td class="td_left">Nama Pimpinan</td><td class="td_right"><input type="text" name="SARANA[NAMA_PIMPINAN]" value="<?php echo $sess['NAMA_PIMPINAN']; ?>" class="stext" title="Nama Pimpinan Sarana"/></td></tr>
        <tr><td class="td_left">Nama Penanggung Jawab</td><td class="td_right"><input type="text" name="SARANA[PENANGGUNG_JAWAB]" value="<?php echo $sess['PENANGGUNG_JAWAB']; ?>" class="stext" title="Nama Penanggung Jawab Sarana."/></td></tr>
    </table>
    <?php
}
?>
