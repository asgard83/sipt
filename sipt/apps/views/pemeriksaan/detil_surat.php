<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR); ?>
<div id="judulpetugas" class="judul"></div>
<div class="content">
<div class="adCntnr">
    <div class="acco2">
        <div class="expand"><b><?php echo $header; ?></b></div>
        <div class="collapse">
                <div class="accCntnt">
                <form action="<?php echo $act; ?>" method="post" autocomplete="off" id="fsurat">
				<table class="form_tabel">
					<tr><td class="td_left">Nomor Surat Tugas</td><td class="td_right"><input type="text" class="stext" name="SURAT[NOMOR]" title="Nomor Surat Tugas" rel="required"/></td></tr>
					<tr><td class="td_left">Tanggal Surat</td><td class="td_right"><input type="text" class="sdate" name="SURAT[TANGGAL]" title="Tanggal Surat Tugas" rel="required"/></td></tr>
				<tr>
                  <td class="td_left">Petugas</td>
                  <td class="td_right"><input type="text" class="stext operator" id="operator" url="<?php echo site_url(); ?>/autocompletes/autocomplete/operator/" title="Ketikan nama petugas, lalu tekan enter untuk menambahkan nama petugas." /></td>
                </tr>
                <tr>
                  <td class="td_left">&nbsp;</td>
                  <td class="td_right"><ul style="list-style:none; margin:0px; padding:0px;" id="urut0"></ul></td>
                </tr>
				</table>
				<h2 class="small">Informasi Data Pemeriksaan</h2>
				<table class="form_tabel">
					<tr><td class="td_left">Nama Sarana</td><td class="td_right"><b><?php echo $sess['NAMA_SARANA']; ?></b></td></tr>
					<tr><td class="td_left">Petugas Entri</td><td class="td_right"><?php echo $sess['PETUGAS']; ?></td></tr>
					<tr><td class="td_left">Tanggal Entri</td><td class="td_right"><?php echo $sess['TANGGAL']; ?></td></tr>
				</table>
				<h2 class="small">Informasi Petugas Pemeriksa</h2>
				<div><?php echo $tabel; ?></div>
				<div style="height:5px;">&nbsp;</div>
				<?php
				if($id != ""){
					?>
					<input type="hidden" name="SURAT_ID" value="<?php echo $id; ?>" />
					<?php
				}
				?>
				<input type="hidden" name="PERIKSA_ID" value="<?php echo $periksa_id; ?>" />
				<input type="hidden" name="CREATE_BY" value="<?php echo $sess['CREATE_BY']; ?>" />
				<input type="hidden" name="CREATE_DATE" value="<?php echo $sess['CREATE_DATE']; ?>" />
                </form>
				<div style="height:5px;"></div>
				<div><a href="#" class="button save" onclick="fpost('#fsurat','',''); return false;"><span><span class="icon"></span>&nbsp; <?php echo $save; ?> &nbsp;</span></a>&nbsp;<a href="#" class="button reload" onclick="kembali(); return false;" ><span><span class="icon"></span>&nbsp; <?php echo $cancel; ?> &nbsp;</span></a></div>
				</div>
		</div>
    </div>
</div>
</div>
<script>
	$(document).ready(function(){
		$('input.sdate').datepicker({ dateFormat: 'dd/mm/yy',regional: 'id'});
		$("input.operator").autocomplete($("input.operator").attr("url"), {width: 244, selectFirst: false}); $("input.operator").result(function(event, data, formatted){ if(data){ $("ul#urut0").append('<li style="padding-bottom:5px;" id="'+data[1]+'"><input type="text" class="stext" value="'+data[2]+'" readonly>&nbsp;&nbsp;<a href="#"><img src="<?php echo base_url(); ?>images/cancel.png" align="top" style="border:none" title="Hapus Petugas" onclick="$(\'ul#urut0 li#' + data[1]+ '\').remove();" /></a><input type="hidden" name="USER_ID[]" value="'+data[1]+'"></li>'); $(this).val(''); $(this).focus(); } });
	});
</script>