<div id="<?php echo $idjudul; ?>" class="judul"></div>
<div class="content">
  <div id="accordion">
    <h2 class="current"><?php echo $judul; ?></h2>
    <form action="<?php echo $act; ?>" autocomplete="off" method="post" id="rkppemeriksaan">
      <table class="form_tabel">
        <?php if(in_array('1', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('9', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('10', $this->newsession->userdata('SESS_KODE_ROLE'))) { ?>
        <tr>
          <td class="td_left">Jenis Sarana</td>
          <td class="td_right"><?php echo form_dropdown('JENIS',$jenis_sarana,'','class="stext" style="display:none;" id="jenis_sarana" title="Pilih Jenis Sarana"',$disinput); ?><?php echo form_dropdown('SARANA',$sarana,'','class="stext" id="sarana" rel="required" title="Pilih sarana"'); ?>&nbsp;<input type="checkbox" name="chkjenis" id="chkjenis" value="1" />&nbsp;Cetak Berdasarkan Jenis Sarana</td>
        </tr>
        <?php  } else { ?>
        <tr>
          <td class="td_left">Jenis Sarana</td>
          <td class="td_right"><?php echo form_dropdown('JENIS',$jenis_sarana,'','class="stext" title="Pilih Jenis Sarana" rel="required"',$disinput); ?></td>
        </tr>
        <?php } ?>
        <tr>
          <td class="td_left">Periode Pemeriksaan Awal</td>
          <td class="td_right"><input type="text" class="sdate" name="AWAL" id="rekapawal" title="Periode Pemeriksaan Awal" /></td>
        </tr>
        <tr>
          <td class="td_left">Periode Pemeriksaan Akhir</td>
          <td class="td_right"><input type="text" class="sdate" name="AKHIR" id="rekapakhir" title="Periode Pemeriksaan Akhir" onchange="compare('#rekapawal', '#rekapakhir'); return false;" /></td>
        </tr>
        <?php if($this->newsession->userdata('SESS_BBPOM_ID') == "00" || in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))){ ?>
        <tr>
          <td class="td_left">Balai Besar / Balai POM</td>
          <td class="td_right"><?php echo form_dropdown('BBPOM_ID',$bbpom,'','class="stext" title="Pilih Balai Besar / Balai POM"'); ?></td>
        </tr>
        <?php } ?>
      </table>
      <div style="padding-left:5px; padding-bottom:10px;"><a href="#" class="button check" onclick="freport('#rkppemeriksaan'); return false;"><span><span class="icon"></span>&nbsp; Proses &nbsp;</span></a>&nbsp;<a href="#" class="button reload" url="<?php echo $batal; ?>" onclick="batal($(this)); return false;"><span><span class="icon"></span>&nbsp; Batal &nbsp;</span></a></div>
    </form>
  </div>
</div>
<script>
	$(document).ready(function(){
        $("#chkjenis").change(function(){
			if($('#chkjenis').attr("checked")){
				$("#jenis_sarana, #sarana").val('');
				$("#jenis_sarana").show();
				$("#sarana").hide();
				$("#sarana").removeAttr("rel");
			}else{
				$("#jenis_sarana, #sarana").val('');
				$("#jenis_sarana").hide();
				$("#sarana").show();
				$("#sarana").attr("rel","required");
			}
			return false;
		});
    });
</script>