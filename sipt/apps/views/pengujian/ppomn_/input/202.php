<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR); 
$required = $row[0]['HASIL_PPOMN'] == 'MS' ? 'rel="required"' : '';	
?>
<tr>
	<td class="td_left">Tindak lanjut hasil sampling</td>
    <td class="td_right"><?php echo form_dropdown('TINDAK_LANJUT', $tl,'','class="stext" title="Pilih salah satu, untuk memproses tindak lanjut hasil sampling" '.$required); ?></td>
</tr>