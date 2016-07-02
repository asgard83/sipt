<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR); 
//print_r($lingkup); die();?>
<tr>
	<td colspan="5">&nbsp;</td>
</tr>

<tr>
  <td class="td_left">Lingkup Pengujian</td>
  <td class="td_right" colspan="4"><?php echo form_dropdown('LINGKUP',$lingkup,$sess['LINGKUP'],'class="stext" rel="required" title="Lingkup Pengujian" id="lingkup_uji"'); ?></td>
</tr>
<tr id="tdanak2" ke="2" class="hideme">
  <td class="td_left">Balai Tujuan</td>
  <td class="td_right"><?php echo form_dropdown('TUJUAN','','','class="stext komoditi" title="balai tujuan pengujian" id="sel2" ke="2" rel="required"'); ?></td>                
</tr>
<script>
	$('#lingkup_uji').change(function(){
		var $this = $(this).val();		
		if($this=='04'){
			$.get('<?php echo site_url().'/autocompletes/autocomplete/set_balai_unggulan/'; ?>' + $this, function(hasil){
					$('#tdanak2').show();
					$('#sel2').html(hasil);				
			});
		}else if($this=='02'){
			$.get('<?php echo site_url().'/autocompletes/autocomplete/set_balai_unggulan/'; ?>' + $this, function(hasil){
					$('#tdanak2').show();
					$('#sel2').html(hasil);				
			});
		}else{
			$('#tdanak2').hide();
			$('#sel2').html('');
			$('#sel2').removeAttr('rel');
			//$('#sel2').attr('disabled', 'disabled');
		}
		});
</script>