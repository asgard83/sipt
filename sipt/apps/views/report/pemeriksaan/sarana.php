<div id="<?php echo $idjudul; ?>" class="judul"></div>
<div class="content">
<div id="accordion">
    <h2 class="current"><?php echo $judul; ?></h2>
    <form action="<?php echo $act; ?>" autocomplete="off" method="post" id="rptpemeriksaan">
        <table class="form_tabel">
            <tr><td class="td_left">Jenis Sarana</td><td class="td_right"><?php echo form_dropdown('JENIS', $jenis_sarana, '', 'class="stext" url="'.site_url().'/pemeriksaan/pemeriksaan/klasifikasi/" title="Pilih salah satu jenis sarana" rel="required" id="jenis_sarana" onchange="select_sarana();"', $disinput); ?>&nbsp;&nbsp;<input type="checkbox" id="selesai" name="SELESAI" onchange="check();"  />&nbsp;Pemeriksaan Selesai<div id="divpirt" style="display:none;margin-left: 6.5cm;">&nbsp;&nbsp;&nbsp;<input type="checkbox" id="pirtlama" name="PIRTLAMA" value="pirt2014"/>&nbsp;Data PIRT Sebelum Juni 2015</div></td></tr>
            <?php if($this->newsession->userdata('SESS_BBPOM_ID') == "00" || in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))){ ?>
            <tr><td class="td_left">Balai Besar / Balai POM</td><td class="td_right"><?php echo form_dropdown('BBPOM_ID',$bbpom,'','class="stext" title="Pilih Balai Besar / Balai POM"'); ?></td></tr>
            <?php } ?>
            <tr><td class="td_left">Klasifikasi</td><td class="td_right"><?php echo form_dropdown('KK_ID',$klasifikasi,'','class="stext" id="kk" title="Pilih Klasifikasi Komoditi"'); ?></td></tr>
            <tr><td class="td_left">Periode Pemeriksaan Awal</td><td class="td_right"><input type="text" class="sdate" name="AWAL" id="waktuperiksa_" title="Periode Pemeriksaan Awal" /></td></tr>
            <tr><td class="td_left">Periode Pemeriksaan Akhir</td><td class="td_right"><input type="text" class="sdate" name="AKHIR" id="waktu_akhir" title="Periode Pemeriksaan Akhir" onchange="compare('#waktuperiksa_', '#waktu_akhir'); return false;" /></td></tr>
            <?php if($this->newsession->userdata('SESS_BBPOM_ID') != "00" && !in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))){ ?>
            <tr><td class="td_left">Kabupaten / Kota</td><td class="td_right"><?php echo form_dropdown('KOTA',$kota,'','class="stext" title="Kabupaten / Kota"'); ?></td></tr>
            <?php } ?>
            <tr><td class="td_left">Temuan</td><td class="td_right"><input type="text" class="stext" name="TEMUAN" title="Temuan Sarana" /></td></tr>            
            <tr><td class="td_left" id="td_tl">Tindak Lanjut</td><td class="td_right"><input type="text" class="stext" name="TINDAKAN" title="Tindak Lanjut" /></td></tr>
            <tr><td class="td_left">Hasil</td><td class="td_right"><?php echo form_dropdown('HASIL',$hasil,'','class="stext" title="Hasil Pemeriksaan Sarana"'); ?></td></tr>
        </table>
        <div style="padding-left:5px; padding-bottom:10px;"><a href="#" class="button check" onclick="freport('#rptpemeriksaan'); return false;"><span><span class="icon"></span>&nbsp; Proses &nbsp;</span></a>&nbsp;<a href="#" class="button reload" url="<?php echo $batal; ?>" onclick="batal($(this)); return false;"><span><span class="icon"></span>&nbsp; Batal &nbsp;</span></a></div>
    </form>			
</div>
</div>
<script type="text/javascript">
	function check(){
		if($('#selesai').attr("checked")){
			$('#jenis_sarana').attr("disabled", "disabled");
			$("#selesai").val('1');
			$('#jenis_sarana').removeAttr("rel");
		}else{
			$('#jenis_sarana').removeAttr("disabled");
			$('#jenis_sarana').attr("rel", "required");
			$("#selesai").val('');
		}
	}
	function select_sarana(){
		if($('#jenis_sarana').val()=='01VV'){			
			$('#divpirt').show();
		}else{
			$('#divpirt').attr("disabled", "disabled");
			$('#divpirt').hide();			
		}
	}
</script>
