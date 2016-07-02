<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR); ?>
<tr>
  <td class="td_left">Diterima di TPS Tanggal</td>
  <td class="td_right"><input type="text" class="sdate" rel="required" name="TANGGAL_TERIMA" title="Tanggal terima sampel rujukan di TPS" /></td>
</tr>
<script>
	$(document).ready(function(){
		$('input.sdate').datepicker({ dateFormat: 'dd/mm/yy',regional: 'id', maxDate: new Date()});
    });
</script>