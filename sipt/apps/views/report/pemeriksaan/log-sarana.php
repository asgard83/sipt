<div id="<?php echo $idjudul; ?>" class="judul"></div>
<div class="content">
  <div id="accordion">
    <h2 class="current"><?php echo $judul; ?></h2>
    <form action="<?php echo $act; ?>" autocomplete="off" method="post" id="rekaplogsarana">
      <table class="form_tabel">
        <tr>
          <td class="td_left">Berdasarkan Nama Sarana</td>
          <td class="td_right"><input type="text" class="stext" name="NAMA_SARANA" title="Nama Sarana" /></td>
        </tr>
        <tr>
          <td class="td_left">Periode Pemeriksaan</td>
          <td class="td_right"><input type="text" class="sdate" name="AWAL" id="rekapawal" title="Periode Pemeriksaan Awal" />&nbsp; s.d &nbsp;<input type="text" class="sdate" name="AKHIR" id="rekapakhir" title="Periode Pemeriksaan Akhir" onchange="compare('#rekapawal', '#rekapakhir'); return false;" /></td>
        </tr>
        <tr>
          <td class="td_left">Balai Besar / Balai POM</td>
          <td class="td_right"><?php echo form_dropdown('BBPOM_ID',$bbpom,'','class="stext" title="Pilih Balai Besar / Balai POM"'); ?></td>
        </tr>
        <tr>
          <td class="td_left">Hasil Pemeriksaan</td>
          <td class="td_right"><?php echo form_dropdown('HASIL',$hasil,'','class="stext" title="Pilih salah satu hasil pemeriksaan"'); ?></td>
        </tr>
      </table>
      <div style="padding-left:5px; padding-bottom:10px;"><a href="#" class="button check" onclick="freport('#rekaplogsarana'); return false;"><span><span class="icon"></span>&nbsp; Proses &nbsp;</span></a>&nbsp;<a href="#" class="button reload" url="<?php echo $batal; ?>" onclick="batal($(this)); return false;"><span><span class="icon"></span>&nbsp; Batal &nbsp;</span></a></div>
    </form>
  </div>
</div>
