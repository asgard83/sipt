<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR); ?>

<tr>
  <td class="td_left">Tanggal Terima di TPS</td>
  <td class="td_right"><?= $row[0]['TGLTERIMA']; ?></td>
</tr>
<tr>
  <td class="td_left">Petugas Penerima</td>
  <td class="td_right"><?= $row[0]['PETUGAS_PENERIMA']; ?></td>
</tr>
<tr>
  <td class="td_left">Tanggal Verifikasi</td>
  <td class="td_right"><input type="text" class="sdate" rel="required" name="TANGGAL_VERIFIKASI" title="Tanggal verifikasi sampel rujukan oleh Manajer Administrasi" /></td>
</tr>
<script>
	$(document).ready(function(){
		$('input.sdate').datepicker({ dateFormat: 'dd/mm/yy',regional: 'id'});
    });
</script>