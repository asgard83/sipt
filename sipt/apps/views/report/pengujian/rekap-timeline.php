<div id="<?php echo $idjudul; ?>" class="judul"></div>
<div class="content">
  <div id="accordion">
    <h2 class="current"><?php echo $judul; ?></h2>
    <form action="<?php echo $act; ?>" autocomplete="off" method="post" id="rptstatus">
      <table class="form_tabel">
        <tr>
          <td class="td_left">Balai Besar / Balai POM</td>
          <td class="td_right"><?php echo form_dropdown('BBPOM_ID',$bbpom,'','class="stext" title="Pilih Balai Besar / Balai POM"'); ?></td>
        </tr>
		<tr>
          <td class="td_left">Komoditi</td>
          <td class="td_right"><?php echo form_dropdown('KOMODITI',$komoditi,'','class="stext komoditi" title="Komoditi" ke="1" id="sel1" rel="required"'); ?></td>
        </tr>
		<tr>
		  <td class="td_left">Filter Berdasarkan Tanggal</td>
		  <td class="td_right"><?php echo form_dropdown('FILTERTANGGAL',$filter_tanggal,'','class="stext" title="Filter Tanggal" rel="required"'); ?></td>
		</tr>
        <tr>
          <td class="td_left">Periode Tanggal Sampling</td>
          <td class="td_right"><input type="text" class="sdate" name="AWAL" id="waktuperiksa_" title="Periode Awal Sampling" rel="required"/> s.d <input type="text" class="sdate" name="AKHIR" id="waktu_akhir" title="Periode Akhir Sampling" onchange="compare('#waktuperiksa_', '#waktu_akhir'); return false;" rel="required"/></td>
        </tr>
      </table>
      <div style="padding:3px;">&nbsp;</div>
      <div style="padding-left:5px; padding-bottom:10px;"><a href="#" class="button check" onclick="freport('#rptstatus'); return false;"><span><span class="icon"></span>&nbsp; Proses &nbsp;</span></a>&nbsp;<a href="#" class="button reload" url="<?php echo $batal; ?>" onclick="batal($(this)); return false;"><span><span class="icon"></span>&nbsp; Batal &nbsp;</span></a></div>
    </form>
  </div>
</div>