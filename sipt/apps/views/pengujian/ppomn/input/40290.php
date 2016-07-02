<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR); 
switch ($row[0]['TINDAK_LANJUT_PPOMN']){
	case '9901':
		$arruraian = 'Dilakukan Uji Absah';
	break;
	case '9902':
		$arruraian = 'Ditanggapi - Dikirim Ke Bidang Pengujian';
	break;
	case '9903':
		$arruraian = 'Diarsipkan';
	break;
}
?>
<link type="text/css" href="<?php echo base_url();?>css/css.css" rel="stylesheet" />
<tr>
  <td class="td_left">Verifikasi Sampel</td>
  <td class="td_right atas isi"><?php echo $arruraian; ?></td>
</tr>
