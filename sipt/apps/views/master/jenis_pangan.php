<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR);  ?>
<link type="text/css" href="<?php echo base_url();?>css/css.css" rel="stylesheet" />
<form name="fnewjenispangan" id="fnewjenispangan" method="post" action="<?php echo $act; ?>" autocomplete="off" data-target = "tbodyjenispangan">
<input type="hidden" name="JENIS_PANGAN[SARANA_ID]" value="<?php echo $sarana_id; ?>" />
<table class="form_tabel">
  <tr>
    <td class="td_left">Jenis Pangan</td>
    <td class="td_right"><?php echo form_dropdown('',$jenis_pangan_new,'','id="jenis_pangan_new" class="stext" wajib="yes" title="Jenis Pangan" url="'.site_url().'/autocompletes/autocomplete/set_jenis_pangan/"'); ?></td>
  </tr>
  <tr id="tr-jenis-pangan" style="display:none;">
    <td class="td_left">&nbsp;</td>
    <td class="td_right"><?php echo form_dropdown('UR_JENIS_PANGAN','','','id="jenis_pangan_new_2" class="stext" title="Jenis Pangan"'); ?></td>
  </tr>
  <tr>
    <td class="td_left">No. PIRT</td>
    <td class="td_right"><input type="text" id="no_pirt" class="stext" wajib="yes" title="No. PIRT" maxlength="15" onkeyup="numericOnly($(this));" onblur="numericOnly($(this));" onmouseup="numericOnly($(this));" name="JENIS_PANGAN[NO_PIRT]" /></td>
  </tr>
  <tr>
    <td class="td_left">Status</td>
    <td class="td_right"><select name="JENIS_PANGAN[STATUS]" id="status" wajib="yes" class="stext" title="Status No. PIRT (Berlaku / Tidak Berlaku)">
        <option value="">Status</option>
        <option value="1">Berlaku</option>
        <option value="0">Tidak Berlaku</option>
      </select></td>
  </tr>
</table>
  <div style="height:10px;">&nbsp;</div>
  <div style="padding-left:5px;"><a href="#" class="button save" onclick="divobj('#fnewjenispangan'); return false;"><span><span class="icon"></span>&nbsp; Simpan &nbsp;</span></a></div>
  <div style="height:10px;">&nbsp;</div>
</form>
<script type="text/javascript">
	$(document).mouseup(function(){
		
	});
	$(document).ready(function(e){
		$("table.form_tabel tr:even").css("background-color", "#f0f0f0");
		$("table.form_tabel tr:odd").css("background-color", "#fff");
		$("#jenis_pangan_new").change(function(e){
            var $this = $(this);
			$.get($this.attr("url") + $this.val(), function(data){
				if(data){
					$("#jenis_pangan_new_2").html(data);
					$("tr#tr-jenis-pangan").css("display","");
					$("#jenis_pangan_new_2").attr("wajib","yes");
				}
			});
        });
	});
</script> 