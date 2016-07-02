<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR); ?>
<link type="text/css" href="<?php echo base_url();?>css/css.css" rel="stylesheet" />
<div id="tabs">
  <ul>
    <li><a href="#tabs-1">Penyerahan Sampel</a></li>
    <li><a href="#tabs-2">Perintah Kerja</a></li>
    <li><a href="#tabs-3">Perintah Pengujian</a></li>
    <li><a href="#tabs-4">Parameter Uji</a></li>
    <li><a href="#tabs-5">Catatan & Laporan Pengujian</a></li>
  </ul>
  <div id="tabs-1" class="tab-pengujian" url="<?php echo site_url(); ?>/get/pengujian/trans_act/sps/<?php echo $sess['KODE_SAMPEL']; ?>"></div>
  <div id="tabs-2" class="tab-pengujian" url="<?php echo site_url(); ?>/get/pengujian/trans_act/spk/<?php echo $sess['KODE_SAMPEL']; ?>"></div>
  <div id="tabs-3" class="tab-pengujian" url="<?php echo site_url(); ?>/get/pengujian/trans_act/spp/<?php echo $sess['KODE_SAMPEL']; ?>"></div>
  <div id="tabs-4" class="tab-pengujian" url="<?php echo site_url(); ?>/get/pengujian/trans_act/parameter/<?php echo $sess['KODE_SAMPEL']; ?>"></div>
  <div id="tabs-5" class="tab-pengujian" url="<?php echo site_url(); ?>/get/pengujian/trans_act/cp/<?php echo $sess['KODE_SAMPEL']; ?>"></div>
</div>
<div style="height:5px;">&nbsp;</div>
<table class="form_tabel detil">
  <tr>
    <td class="td_left">Kode Sampel</td>
    <td class="td_right"><?php echo $sess['UR_KODE']; ?></td>
  </tr>
  <tr>
    <td class="td_left">Hasil Kimia</td>
    <td class="td_right"><?php echo strlen($sess['HASIL_KIMIA']) > 0 ? $sess['HASIL_KIMIA'] : '-'; ?></td>
  </tr>
  <tr>
    <td class="td_left">Hasil Mikro</td>
    <td class="td_right"><?php echo strlen($sess['HASIL_MIKRO']) > 0 ? $sess['HASIL_MIKRO'] : '-'; ?></td>
  </tr>
  <tr>
    <td class="td_left">Hasil Sampel</td>
    <td class="td_right"><?php echo strlen($sess['HASIL_SAMPEL']) > 0 ? $sess['HASIL_SAMPEL'] : '-'; ?></td>
  </tr>
  <tr>
    <td class="td_left">Catatan</td>
    <td class="td_right"><?php echo $sess['CATATAN_CP']; ?></td>
  </tr>
  <tr>
    <td class="td_left">Status Kimia</td>
    <td class="td_right"><?php echo (int)$sess['STATUS_KIMIA'] == 0 ? 'Belum selesai atau tidak ada proses pengujian kimia' : 'Selesai'; ?></td>
  </tr>
  <tr>
    <td class="td_left">Status Mikro</td>
    <td class="td_right"><?php echo (int)$sess['STATUS_MIKRO'] == 0 ? 'Belum selesai atau tidak ada proses pengujian mikro' : 'Selesai'; ?></td>
  </tr>
</table>
<script>
	$(document).ready(function(){
		$('#tabs').tabs();
		$(".tab-pengujian").each(function(){
			var $this = $(this).attr("id");
			$.get($(this).attr('url'), function(hasil){
				if(hasil){
					$('#'+$this).html(hasil);
				}
			});
        });	
    });
</script>