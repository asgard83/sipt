<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR);  
$required = $row[0]['HASIL_PPOMN'] == 'MS' ? 'rel="required"' : '';	
?>
<tr>
	<td class="td_left">Tindak lanjut hasil sampling</td>
    <td class="td_right"><?php echo $row[0]['TINDAK_LANJUT']; ?></td>
</tr>