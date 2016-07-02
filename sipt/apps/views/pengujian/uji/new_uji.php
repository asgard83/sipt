<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR); ?>
<div id="juduluji" class="judul"></div>
<div class="headersarana"><?php echo $judul; ?></div>
<div class="content">
    <div class="adCntnr">
    	<div class="acco2">
        	<div class="expand"><a title="expand/collapse" href="#" style="display: block;">PENGUJIAN</a></div>
                <div class="accCntnt">
                <h2 class="small garis">Informasi Sampel</h2>
				<form name="fuji" id="fuji" method="post" action="<?php echo $act; ?>" autocomplete="off">
				<table class="form_tabel">
					<tr>
						<td class="td_left">Kode Sampel</td><td class="td_right" width="300"><b><?php echo $kode_sampel ?></b></td>
					</tr>
<?php /*?>					<tr>
						<td class="td_left">No Pengujian </td><td class="td_right"><?php echo $uji_id; ?></td>
               	  </tr>
<?php */?>                  
				</table>
			    <div style="height:5px;">&nbsp;</div>		
                <h2 class="small garis">SRL Pengujian</h2>
				<table class="form_tabel">
					<tr>
						<td class="td_left">Parameter Uji</td><td class="td_right"><?php echo $sess['PARAMETER_UJI'];  ?></td>
					</tr>
					<tr>
						<td class="td_left">Metode</td><td class="td_right"><?php echo $sess['METODE']; ?></td>
					</tr>
					<tr>
						<td class="td_left">Pustaka</td><td class="td_right"><?php echo $sess['PUSTAKA']; ?></td>
				  	</tr>
				  	<tr>
						<td class="td_left">Syarat</td><td class="td_right" width="300"><?php echo $sess['SYARAT'];  ?></td>
				  	</tr>
				</table>
			    <div style="height:5px;">&nbsp;</div>		
                <h2 class="small garis">Hasil Pengujian</h2>
				<table class="form_tabel">
				<tr>
				  <td class="td_left">Mulai Di Uji </td>
				  <td class="td_right"><input type="text" class="sdate datepick" title="Mulai Di Uji" name="UJI[AWAL_UJI]" value="<?php echo $sess['AWAL_UJI']; ?>" /></td>
				  <td></td>
				  <td class="td_left">Selesai Di Uji </td>
				  <td class="td_right"><input type="text" class="sdate datepick" title="Selesai Di Uji" name="UJI[AKHIR_UJI]" value="<?php echo $sess['AKHIR_UJI']; ?>" /></td>
				  </tr>
				<tr>
				  <td class="td_left">Jumlah Sampel Di Uji </td>
				  <td class="td_right"><input type="text" class="sdate" title="Jumlah sampel yang diuji" name="UJI[JUMLAH_UJI]" value="<?php echo $sess['JUMLAH_UJI']; ?>"/></td>
				  <td></td>
				  <td class="td_left">Sisa Sampel <div>Habis / di simpan </div></td>
				  <td class="td_right"><input type="text" class="stext" title="Sisa sampel : habis / atau di simpan" name="UJI[SISA_UJI]" value="<?php echo $sess['SISA_UJI']; ?>" /></td>
				  </tr>
				<tr>
				  <td class="td_left">Pemerian</td>
				  <td class="td_right"><textarea class="stext" name="UJI[PEMERIAN]" rel="required" title="Pemerian" style="height:80px;"><?php echo $sess['PEMERIAN']; ?></textarea></td><td width="10"></td>
				  <td class="td_left">Identifikasi</td>
				  <td class="td_right"><textarea class="stext" name="UJI[IDENTIFIKASI]" rel="required" title="Identifikasi" style="height:80px;"><?php echo $sess['IDENTIFIKASI']; ?></textarea></td>
				  </tr>
<?php /*?>				<tr><td class="td_left">Pengujian</td><td class="td_right" width="300"><textarea class="stext" name="UJI[JENIS_UJI]" rel="required" title="Pengujian" style="height:80px;"><?php echo $sess['JENIS_UJI']; ?></textarea></td><td width="10"></td><td class="td_left">Syarat</td><td class="td_right"><textarea class="stext" name="UJI[SYARAT_UJI]" rel="required" title="Syarat Uji" style="height:80px;"><?php echo $sess['SYARAT_UJI']; ?></textarea></td>
				</tr>
<?php */?>				<tr>
				  <td class="td_left">Reagen</td>
				  <td class="td_right"><input type="text" class="stext" title="Reagen" name="UJI[REAGEN]" value="<?php echo $sess['REAGEN']; ?>" /></td>
				  <td></td>
				  <td class="td_left">Jumlah Reagen </td>
				  <td class="td_right"><input type="text" class="sdate" title="Jumlah Reagen" name="UJI[JUMLAH_REAGEN]" value="<?php echo $sess['JUMLAH_REAGEN']; ?>" /></td>
				  </tr>
				<tr>
				  <td class="td_left">Hasil </td>
				  <td class="td_right"><?php echo form_dropdown('UJI[HASIL]', $hasil,$sess['HASIL'], 'class="stext" rel="required" title="Hasil Kesimpulan"'); ?></td>
				  <td></td>
				  <td class="td_left">Catatan</td>
				  <td class="td_right"><textarea class="stext" name="UJI[CATATAN]" title="Catatan hasil uji"><?php echo $sess['CATATAN']; ?></textarea></td>
				  </tr>
				</table>
				

			    <div style="height:10px;">&nbsp;</div>		
                <div style="padding-left:5px;"><a href="#" class="button check" onclick="fpost('#fuji','',''); return false;"><span><span class="icon"></span>&nbsp; Proses &nbsp;</span></a>&nbsp;<a href="#" class="button reload" url="<?php echo $batal; ?>" onclick="batal($(this)); return false;"><span><span class="icon"></span>&nbsp; Batal &nbsp;</span></a></div>
				<input type="hidden" name="UJI_ID" value="<?php echo $sess['UJI_ID']; ?>" />
				<input type="hidden" name="KODE_SAMPEL" value="<?php echo $sess['KODE_SAMPEL']; ?>" />
				<input type="hidden" name="SPK_ID" value="<?php echo $sess['SPK_ID']; ?>" />
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$('input.datepick').datepicker({ dateFormat: 'dd/mm/yy',regional: 'id', maxDate: new Date()});
	});
</script>