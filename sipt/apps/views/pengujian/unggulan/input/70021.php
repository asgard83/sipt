<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR); ?>
<tr>
  <td class="td_left">Tanggal Terima Sampel</td>
  <td class="td_right"><input type="text" class="sdate" rel="required" name="TANGGAL_TERIMA" title="Tanggal terima sampel" /></td>
</tr>
<script>
	$(document).ready(function(){
		$('input.sdate').datepicker({ dateFormat: 'dd/mm/yy',regional: 'id'});
    });
</script>