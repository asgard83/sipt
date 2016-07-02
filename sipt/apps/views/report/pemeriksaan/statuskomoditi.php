<div id="<?php echo $idjudul; ?>" class="judul"></div>
<div class="content">
<div id="accordion">
    <h2 class="current"><?php echo $judul; ?></h2>
    <form action="<?php echo $act; ?>" autocomplete="off" method="post" id="rkpstatus">
        <table class="form_tabel">
            <tr><td class="td_left">Periode Pemeriksaan Awal</td><td class="td_right"><input type="text" class="sdate" name="STATUS_AWAL" id="statusawal" title="Periode Pemeriksaan Awal" /></td></tr>
            <tr><td class="td_left">Periode Pemeriksaan Akhir</td><td class="td_right"><input type="text" class="sdate" name="STATUS_AKHIR" id="statusakhir" title="Periode Pemeriksaan Akhir" onchange="compare('#statusawal', '#statusakhir'); return false;" /></td></tr>
            <tr><td class="td_left">Komoditi</td><td class="td_right"><?php echo form_dropdown('KLASIFIKASI', $klasifikasi,'','class="stext" rel="required" title="Pilih salah satu komoditi"'); ?></td></tr>
            <?php if($this->newsession->userdata('SESS_BBPOM_ID') == "00" || in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))){ ?>
            <tr><td class="td_left">Balai Besar / Balai POM</td><td class="td_right"><?php echo form_dropdown('BBPOM_ID',$bbpom,'','class="stext" title="Pilih Balai Besar / Balai POM"'); ?></td></tr>
            <?php } ?>
        </table>
        <div style="padding-left:5px; padding-bottom:10px;"><a href="#" class="button check" onclick="freport('#rkpstatus'); return false;"><span><span class="icon"></span>&nbsp; Proses &nbsp;</span></a>&nbsp;<a href="#" class="button reload" url="<?php echo $batal; ?>" onclick="batal($(this)); return false;"><span><span class="icon"></span>&nbsp; Batal &nbsp;</span></a></div>
    </form>
</div>
</div>
