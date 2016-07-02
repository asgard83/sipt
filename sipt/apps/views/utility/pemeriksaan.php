<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR);?>
<div id="<?php echo $idjudul; ?>" class="judul"></div>
<div class="content">
<form action="<?php echo $act; ?>" method="post" autocomplete="off" id="form-grafik">
<div class="adCntnr">
    <div class="acco2">
        <div class="expand"><b>Rekapitulasi Grafik Pemeriksaan Sarana</b></div>
        <div class="collapse">
                <div class="accCntnt">
                    <table class="form_tabel">
                        <tr><td class="td_left">Periode Awal</td><td class="td_right"><input type="text" onfocus="create_dp($(this));" name="sarana-awal" class="sdate" title="Periode Awal Pemeriksaan" id="awal-sarana" /></td></tr>
                        <tr><td class="td_left">Periode Akhir</td><td class="td_right"><input type="text" onfocus="create_dp($(this));" name="sarana-akhir" class="sdate" title="Periode Akhir Pemeriksaan" id="akhir-sarana" /></td></tr><tr><td class="td_left">Pemeriksaan Jenis Sarana</td><td class="td_right"><?php echo form_dropdown('jenis', $jenis, '', 'id="jenis" class="stext" title="Pilih Jenis Sarana"', $disinput); ?></td></tr>
                    </table>
                    <div style="height:20px"></div>
                    <div id="chart-sarana"></div>
                </div>
		</div>        
        <div style="height:10px"></div>
        <div><a href="#" class="button reload" onclick="chart('#form-grafik', 'chart-sarana', 950, 350, 'Pemeriksaan Sarana', 'bottom', 'column'); return false;"><span><span class="icon"></span>&nbsp; Proses &nbsp;</span></a></div> 

    </div>
</div>
</form>
</div>

<script type="text/javascript">
	google.load('visualization', '1', {'packages':['corechart']});	
</script>

