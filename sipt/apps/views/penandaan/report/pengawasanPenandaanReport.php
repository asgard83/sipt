<div id="<?php echo $idjudul; ?>" class="judul"></div>
<div class="content">
    <div id="accordion">
	<h2 class="current"><?php echo $judul; ?></h2>
	<form action="<?php echo $act; ?>" autocomplete="off" method="post" id="rhpk">
	    <table class="form_tabel">
		<tr><td class="td_left">Periode Tahun</td><td class="td_right"><input type="text" class="sdate" name="AWAL" id="tglAwalPengawasan<?php echo $i; ?>" title="Tanggal Pengawasan Penandaan" onchange="comp('A')" rel='required'/>&nbsp; sampai dengan&nbsp;
			<input type="text" class="sdate" name="AKHIR" id="tglAkhirPengawasan<?php echo $i; ?>" title="Tanggal Pengawasan Penandaan" onchange="comp('B')" rel='required'/></td></tr>
		<tr><td class="td_left">Jenis Klasifikasi</td><td class="td_right"><?php echo form_dropdown('JENIS', $jenisKlasifikasi, '', 'class="stext klasifikasi" title="Pilih Jenis Klasifikasi" rel="required"', $disinput); ?></td></tr>
		<?php if ($this->newsession->userdata('SESS_BBPOM_ID') == "00" || in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) { ?>
    		<tr><td class="td_left">Balai Besar / Balai POM</td><td class="td_right"><?php echo form_dropdown('BBPOM_ID', $bbpom, '', 'class="stext" title="Pilih Balai Besar / Balai POM"'); ?></td></tr>
		<?php } ?>
		<tr><td class="td_left">Hasil</td><td class="td_right"><select name="HASIL" class="stext" title="Hasil Pengawasan" id="hasil_1"><option value=""></option><option value="MK">MK</option><option value="TMK">TMK</option></select><select class="stext" title="Hasil Pengawasan" id="hasil_2" hidden><option value=""></option><option value="MS">MS</option><option value="TMS">TMS</option></select></td></tr>
		<tr class="bungkus _001" hidden><td class="td_left">Bungkus Yang Di Nilai</td><td class="td_right"><select class="stext bungkus _001" title="Bungkus"><option value=""></option><option value="BUNGKUS_LUAR+BL+ Bungkus Luar">Bungkus Luar</option><option value="ETIKET+ET+Etiket">Etiket</option><option value="AMPUL_VIAL10ML+AV1+Ampul Vial >= 10 ML">Ampul Vial >= 10 ML</option><option value="AMPUL_VIAL9ML+AV2+Ampul Vial < 10 ML">Ampul Vial < 10 ML</option><option value="BROSUR+BR+Brousr">Brosur</option><option value="AMPLOP+AS+Amplop / Catch Cover / Sachet">Amplop</option><option value="BLISTER+SB+Strip / Blister">Blister</option></select></td></tr><tr class="bungkus _010 _011" hidden><td class="td_left">Bungkus Yang Di Nilai</td><td class="td_right"><select class="stext bungkus _010 _011" title="Bungkus"><option value=""></option><option value="BUNGKUS_LUAR+BL+ Bungkus Luar">Bungkus Luar</option><option value="KEMASAN_PRIMER+KP+Kemasan Primer">Kemasan Sekunder</option></select></td></tr>
	    </table>
	    <div style="padding-left:5px; padding-bottom:10px;"><a href="#" class="button check" onclick="freport('#rhpk');
			return false;"><span><span class="icon"></span>&nbsp; Proses &nbsp;</span></a>&nbsp;<a href="#" class="button reload" url="<?php echo $batal; ?>" onclick="batal($(this));
			return false;"><span><span class="icon"></span>&nbsp; Batal &nbsp;</span></a></div>
	</form>
    </div>
</div>
<script type="text/javascript">
		    var arrKomo = ["001", "010", "011"];
		    function comp(A) {
			var tgl2 = '#tglAwalPengawasan', tgl3 = '#tglAkhirPengawasan';
			if (A === 'A') {
			    if ($('#tglAkhirPengawasan').val() !== '')
				compareHere(tgl2, tgl3);
			}
			else if (A === 'B') {
			    if ($('#tglAwalPengawasan').val() !== '')
				compareHere(tgl2, tgl3);
			}
		    }
		    function compareHere(objstart, objend) {
			var date_str = $(objstart).val();
			var date_end = $(objend).val();
			date_str = new Date(date_str.split('/')[2], date_str.split('/')[1], date_str.split('/')[0]);
			date_end = new Date(date_end.split('/')[2], date_end.split('/')[1], date_end.split('/')[0]);
			if (date_end.getTime() < date_str.getTime()) {
			    jAlert("Harap dipastikan untuk periode : \n  Periode Awal < Periode Akhir", "SIPT Versi 1.0");
			    $(objend).val('');
			    $(objend).focus();
			    return false;
			}
		    }
		    $(document).ready(function() {
			$('input.sdate').datepicker({dateFormat: 'dd/mm/yy', regional: 'id'});
		    });
		    $(".klasifikasi").change(function() {
			if ($.inArray($(this).val(), arrKomo) > -1) {
			    $('._' + $(this).val()).show();
			    $('._' + $(this).val()).attr('name', 'BUNGKUS');
			} else {
			    $('.bungkus').hide();
			    $('.bungkus').attr('name', '');
			}
			if ($(this).val() == "012") {
			    $('#hasil_1').hide();
			    $('#hasil_1').attr("name", "");
			    $('#hasil_2').show();
			    $('#hasil_2').attr("name", "HASIL");
			} else {
			    $('#hasil_1').show();
			    $('#hasil_1').attr("name", "HASIL");
			    $('#hasil_2').hide();
			    $('#hasil_2').attr("name", "");
			}
		    });
</script>
