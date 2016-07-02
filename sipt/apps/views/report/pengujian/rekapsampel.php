<div id="<?php echo $idjudul; ?>" class="judul"></div>
<div class="content">
  <div id="accordion">
    <h2 class="current"><?php echo $judul; ?></h2>
    <form action="<?php echo $act; ?>" autocomplete="off" method="post" id="rhpksampel">
      <input type="hidden" name="all" value="<?php echo $all; ?>" />
      <table class="form_tabel">
        <?php
		if(in_array('1', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('10', $this->newsession->userdata('SESS_KODE_ROLE'))){
			?>
        <tr>
          <td class="td_left">Balai Besar / Balai POM</td>
          <td class="td_right"><?php echo form_dropdown('BBPOM_ID',$bbpom,'','class="stext" title="Pilih Balai Besar / Balai POM"'); ?></td>
        </tr>
        
        <tr>
          <td class="td_left">Komoditi</td>
          <td class="td_right"><?php echo form_dropdown('KOMODITI',$komoditi,'','rel="required" class="stext" title="Pilih Satu Komoditi"'); ?></td>
        </tr>
        <?php
		}else{
			?>
        <tr>
          <td class="td_left">Balai Besar / Balai POM</td>
          <td class="td_right"><?php echo form_dropdown('BBPOM_ID',$bbpom,'','rel="required" class="stext" title="Pilih Balai Besar / Balai POM"'); ?></td>
        </tr>
        <?php
		}
		?>
        <tr>
          <td class="td_left">Periode Tanggal Sampling</td>
          <td class="td_right"><input type="text" class="sdate" name="AWAL" id="waktuperiksa_" title="Periode Awal Sampling" />
            s.d
            <input type="text" class="sdate" name="AKHIR" id="waktu_akhir" title="Periode Akhir Sampling" onchange="compare('#waktuperiksa_', '#waktu_akhir'); return false;" /></td>
        </tr>
        <tr>
          <td class="td_left">Tujuan Sampling</td>
          <td class="td_right"><div style="padding-bottom:5px;"> <?php echo form_dropdown('TUJUAN_SAMPLING',$tujuan,'','class="stext" title="Tujuan Sampling" id="tujuan_sampling" url="'.site_url().'/autocompletes/autocomplete/get_tujuan_sampling/"'); ?> </div>
            <div id="div_tujuan" style="display:none;"> <?php echo form_dropdown('SUB_TUJUAN',$sub_tujuan,'','class="stext" title="Tujuan Sampling" id="sub_tujuan"'); ?> </div>
        </tr>
        <tr>
          <td class="td_left">Asal Sampel</td>
          <td class="td_right"><?php echo form_dropdown('ASAL_SAMPLING',$asal,'','class="stext" title="Pilih salah satu asal pengirim sampel"'); ?></td>
        </tr>
      </table>
      <div style="padding:3px;">&nbsp;</div>
      <div style="padding-left:5px; padding-bottom:10px;"><a href="#" class="button check" onclick="freport('#rhpksampel'); return false;"><span><span class="icon"></span>&nbsp; Proses &nbsp;</span></a>&nbsp;<a href="#" class="button reload" url="<?php echo $batal; ?>" onclick="batal($(this)); return false;"><span><span class="icon"></span>&nbsp; Batal &nbsp;</span></a></div>
    </form>
  </div>
</div>
