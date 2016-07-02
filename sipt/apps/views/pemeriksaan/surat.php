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
					<tr><td class="td_left">Nomor Surat Tugas</td><td class="td_right"><input type="text" class="stext" name="SURAT[NOMOR]" title="Nomor Surat Tugas" value="<?php echo $sess['NOMOR']; ?>" /></td></tr>
					<tr><td class="td_left">Tanggal Surat</td><td class="td_right"><input type="text" class="sdate" name="SURAT[TANGGAL]" title="Tanggal Surat Tugas" value="<?php echo $sess['TANGGAL']; ?>" /></td></tr>
				</table>
				<?php
				if($id != ""){
					?>
					<input type="hidden" name="SURAT_ID" value="<?php echo $id; ?>" />
					<?php
				}
				?>
				<input type="hidden" name="PERIKSA_ID" value="<?php echo $periksa_id; ?>" />
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
	});
</script>