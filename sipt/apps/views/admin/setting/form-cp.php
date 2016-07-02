<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR);?>

<div id="juduluji" class="judul"></div>
<div class="content">
  <div class="adCntnr">
    <div class="acco2">
      <div class="expand"><b>Setting Penomoran Catatan Pengujian</b></div>
      <div class="collapse">
        <div class="accCntnt">
          <h2 class="small">Monitoring Penomoran Catatan Pengujian</h2>
          <table class="form_tabel">
            <tr>
              <td class="td_left">Balai Besar / Balai POM</td>
              <td class="td_right"><?php echo form_dropdown('bbpom_id',$balai,"",'class="stext" id="bbpom_id" rel="required" title="Pilih salah satu Balai" data-url= "'.site_url().'/utility/setting/get_cp/"'); ?></td>
            </tr>
          </table>
          <div style="height:10px;">&nbsp;</div>
          <div id="ret-sampel"></div>
          <div style="height:10px;">&nbsp;</div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
	$(document).ready(function(){
		$("#bbpom_id").change(function(){
			var $this = $(this);
			var $anggaran = $this.parent().parent().next().children().children();
			if($anggaran.val() == ""){
				$("#ret-sampel").html('');
				return false
			}else{
				$.get($this.attr("data-url") + $this.val(), function(hasil){
					if(hasil){
						$("#ret-sampel").html(hasil);
					}
				});
			}			
			return false;
		});
    });
</script>